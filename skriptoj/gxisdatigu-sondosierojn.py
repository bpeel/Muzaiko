#!/usr/bin/python
# -*- coding: utf-8 -*-

import MySQLdb
import pkagordoj
import subprocess
import re
import sys
import os
import stat
import string
import tempfile

class KunigEraro(Exception):
    def __init__(self, value):
        self.value = value
    def __str__(self):
        return repr(self.value)

def mp3igu(mp3_dosiero, wav_dosiero):
    # Malgrandigu per lame
    subprocess.call(["lame", "--quiet", wav_dosiero, mp3_dosiero])

def oggigu(ogg_dosiero, wav_dosiero):
    # Malgrandigu per oggenc
    res = subprocess.call(["oggenc", "--quiet",
                           "-o", ogg_dosiero,
                           wav_dosiero])

def kunigu_en_wavon(dosieroj):
    # Kunigu la dosierojn per SoX. Per SoX ne eblas kunigi dosierojn kiuj
    # havas malsamajn poecojn do ni devas unue ŝanĝi ilin en portempajn
    # dosierojn

    temp_files = []

    for dosiero in dosieroj:
        temp_file = tempfile.NamedTemporaryFile(delete = True)
        temp_files.append(temp_file)

        res = subprocess.call(["sox",
                               dosiero,
                               "-c", "2",
                               "-r", "44100",
                               "-V1",
                               "-t", "wav",
                               temp_file.name])

        if res != 0:
            raise KunigEraro("sox malsukcesis")

    kunigita_dosiero = tempfile.NamedTemporaryFile(delete = True)

    res = subprocess.call(["sox"] +
                          [item for sublist in [["-t", "wav", x.name]
                                                for x in temp_files]
                           for item in sublist] +
                          ["-t", "wav",
                           kunigita_dosiero.name])

    for dosiero in temp_files:
        dosiero.close()
    
    if res != 0:
        kunigita_dosiero.close()
        raise KunigEraro("sox malsukcesis")
    
    return kunigita_dosiero

def akiru_mtime(dosiero):
    try:
        s = os.stat(dosiero)
        return s[stat.ST_MTIME]
    except OSError:
        return 0

def procedi_programeron(id, dosieroj):
    kunigita_dosierujo = pkagordoj.get("loko_de_kunigitaj_programeroj")
    fina_mp3 = kunigita_dosierujo + "/programero" + str(id) + ".mp3"
    fina_ogg = kunigita_dosierujo + "/programero" + str(id) + ".ogg"
    maks_mtime = 0
    lasta_mtime = 0

    for dosiero in dosieroj:
        try:
            s = os.stat(dosiero)
        except OSError:
            # Se iu ajn dosiero ne ekzistas ni ne povas procedi ĉi
            # tiun programeron
            return

        if s[stat.ST_MTIME] > maks_mtime:
            maks_mtime = s[stat.ST_MTIME]

    # Kontrolu ĉu la dosieroj de la programeroj ŝanĝiĝis post la lasta
    # procedo de la programero
    if (akiru_mtime(fina_mp3) < maks_mtime or
        akiru_mtime(fina_ogg) < maks_mtime):

        try:
            kunigita_dosiero = kunigu_en_wavon(dosieroj)
        except KunigEraro:
            return

        mp3igu(fina_mp3, kunigita_dosiero.name)
        oggigu(fina_ogg, kunigita_dosiero.name)

        kunigita_dosiero.close()

db = MySQLdb.connect(passwd = pkagordoj.get("db_passwd"),
                     db = pkagordoj.get("db_db"),
                     host = pkagordoj.get("db_host"),
                     user = pkagordoj.get("db_user"),
                     charset = "utf8")

cur = db.cursor()

# Akiru ĉiujn programerojn kiuj havas sondosierojn

cur.execute("select `sondosiero`.`programero`, `sondosiero`.`nomo` " +
            "from `sondosiero` " +
            "order by `sondosiero`.`programero`, `sondosiero`.`nomo`");

programeroj = []
programeroj_dosierujo = pkagordoj.get("loko_de_programeroj")
for row in cur:
    if len(programeroj) == 0 or programeroj[-1][0] != row[0]:
        programeroj.append((row[0], []))
    programeroj[-1][1].append(programeroj_dosierujo + "/" + row[1])

cur.close()
db.close()

for programero in programeroj:
    procedi_programeron(programero[0], programero[1])
