#!/usr/bin/python
# -*- coding: utf-8 -*-

import MySQLdb
import pkagordoj
import subprocess
import re

def forigu_ligilojn(cxen):
    cxen = re.sub(r"\[([^\]]+)\]\([^\)]+\)",
                  lambda(match): match.group(1),
                  cxen)
    cxen = re.sub(r"\*([^\*]+)\*",
                  lambda(match): match.group(1),
                  cxen)
    return cxen

def faru_titolon(titolo, priskribo):
    # Se jam estas valida titolo en la datumbazo, ni simple uzos ĝin
    # rekte
    if titolo:
        return forigu_ligilojn(titolo)

    # Alie ni uzos la unuan frazon de la priskribo
    titolo = forigu_ligilojn(priskribo)

    match = re.match(r"\.( |$)", titolo)
    if match:
        titolo = titolo[:match.start(0)]

    # Limigu la titolon je 15 vortoj
    match = re.match(r"^([^ ]+ +){15}", titolo)
    if match:
        titolo = match.group(0)

    return titolo

db = MySQLdb.connect(passwd = pkagordoj.db_passwd,
                     db = pkagordoj.db_db,
                     host = pkagordoj.db_host,
                     user = pkagordoj.db_user,
                     charset = "utf8")

cur = db.cursor()

cur.execute("select `id`, `title`, `description` from `programero`")

for row in cur:
    (id, titolo, priskribo) = row
    titolo = faru_titolon(titolo, priskribo)

    subprocess.call(["espeak", "-v", "eo",
                     "-w", (pkagordoj.loko_de_programeroj +
                            "/programero-" + str(id) + "-1.wav"),
                     (u"Programero " + str(id) + u"." +
                      u"la titolo estas \"" + titolo + u"\"").encode("utf-8")])
    subprocess.call(["espeak", "-v", "eo",
                     "-w", (pkagordoj.loko_de_programeroj +
                            "/programero-" + str(id) + "-2.wav"),
                     "Jen la dua sondosiero de la programero " + str(id)])

    for i in range(0, 2):
        cur.execute("insert into `sondosiero` (`programero`, `nomo`) "
                    "values (%s, %s)",
                    [ id, u"programero-" +
                      str(id) + u"-" + str(i + 1) + u".wav" ])
