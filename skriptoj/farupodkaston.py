#!/usr/bin/python
# -*- coding: utf-8 -*-

import MySQLdb
import pkagordoj
import subprocess
import re
import datetime
import sys
import xml.etree.ElementTree as ET
import os
import cgi
import string
import tempfile
import random

# Maksimuma aĝo en tagoj post kiu dosiero foriĝos
MAKSIMUMA_AGXO = 7

# Malfruo en tagoj post kio la podkasto haveblos
ELDONMALFRUO = 1

def kiel_rfc822(tempo):
    return tempo.strftime("%a, %d %b %Y %H:%M:%S UTC")

def faru_ligilojn(cxen):
    cxen = cgi.escape(cxen)

    cxen = re.sub(r"\[(\S+)\s+([^\]]+)\]",
                  lambda(match): ("<a href=\"" + match.group(1) + "\">" +
                                  match.group(2) + "</a>"),
                  cxen)
    cxen = re.sub(r"\*([^\*]+)\*",
                  lambda(match): "<i>" + match.group(1) + "</i>",
                  cxen)

    return cxen

def phpigu_cxenon(cxeno, cgi_escape = False):
    if cgi_escape:
        cxeno = cgi.escape(cxeno)
    return re.sub(r"[\\\"]", lambda(match): "\\" + match.group(0), cxeno)

def faru_item(cur, dato):
    item = ET.Element("item")

    cxendato = dato.strftime("%Y-%m-%d")

    ET.SubElement(item, "title").text = ("Elsendo de " +
                                         dato.strftime(cxendato))
    dato_tempo = datetime.datetime(dato.year,
                                   dato.month,
                                   dato.day,
                                   3)
    ET.SubElement(item, "pubDate").text = \
        kiel_rfc822(dato_tempo + datetime.timedelta(days = ELDONMALFRUO))

    # Serĉu ĉiujn priskribojn de tiu tago
    programeroj = []
    cur.execute("select `programero`.`skizo` "
                "from `programero` inner join `elsendo` "
                "on `elsendo`.`programero_id` = `programero`.`id` "
                "inner join `sondosiero` "
                "on `programero`.`id` = `sondosiero`.`programero` "
                "where `dato` = %s "
                "group by `programero`.`id` "
                "order by `elsendo`.`dato`",
                cxendato)
    for row in cur:
        programeroj.append(faru_ligilojn(row[0]))

    priskribo = string.join(["<p>" + x + "</p>" for x in programeroj])

    ET.SubElement(item, "description").text = priskribo

    baza_adreso = pkagordoj.get("pk_url_radiko") + "/podkasto-" + cxendato
    mp3_url = baza_adreso + ".mp3"
    ogg_url = baza_adreso + ".ogg"

    enc = ET.SubElement(item, "enclosure")
    enc.set("url", mp3_url)
    enc.set("type", "audio/mpeg")
    enc.set("length",
            str(os.path.getsize(pkagordoj.get("loko_de_podkastajxoj") +
                                "/podkasto-" + cxendato + ".mp3")))

    html = ("array(\"dato\" => \"" + phpigu_cxenon(cxendato) + "\", " +
            "\"mp3\" => \"" + phpigu_cxenon(mp3_url) + "\", " +
            "\"ogg\" => \"" + phpigu_cxenon(ogg_url) + "\", " +
            "\"priskribo\" => \"" + phpigu_cxenon(priskribo, False) + "\"),")

    return [item, html]

def sercxu_dosierojn_laux_regexp(subdosierujo, regexp):
    dosieroj = []
    path = pkagordoj.get("loko_de_programeroj") + "/" + subdosierujo

    if os.path.exists(path):
        for dn in os.listdir(path):
            if regexp.match(dn):
                dosieroj.append(path + "/" + dn)

    return sorted(dosieroj)

def sercxu_kromdosierojn(dato):
    # Serĉu kromdosierojn por hodiaŭ
    cxendato = dato.strftime("%Y%m%d")
    regexp = re.compile('\A' + re.escape(cxendato) +
                        r'.*\.(mp3|ogg|flac|wav)\Z',
                        re.IGNORECASE)
    return sercxu_dosierojn_laux_regexp('kromdosieroj', regexp)
    
def aldonu_kromdosierojn(programeroj, kromdosieroj):
    aldonloko = 1
    
    # Aldonu la kromdosierojn ekde post la unua programo
    for kd in kromdosieroj:
        programeroj.insert(aldonloko, [ kd ])
        aldonloko += 2

def sercxu_jxinglojn():
    regexp = re.compile(r'.*\.(mp3|ogg|flac|wav)\Z', re.IGNORECASE)
    return sercxu_dosierojn_laux_regexp('jxingloj', regexp)

def aldonu_jxinglojn(dosieroj, jxingloj):
    # Se ne ekzistas ĵingloj, rezignu jam
    if len(jxingloj) < 1:
        return
    # Elektu hazardan ĵinglon por komenci
    jxinglo = random.randrange(len(jxingloj))

    lok = 0
    while lok <= len(dosieroj):
        dosieroj.insert(lok, jxingloj[jxinglo])
        jxinglo += 1
        if jxinglo >= len(jxingloj):
            jxinglo = 0
        lok += 2

if len(sys.argv) > 1:
    match = re.match(r"^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$", sys.argv[1])
    if match:
        hodiaux_dato = datetime.date(int(match.group(1)),
                                     int(match.group(2)),
                                     int(match.group(3)))
    else:
        print >> sys.stderr, "uzado: farupodkaston.py [JJJJ-MM-TT]"
        exit(1)
else:
    hodiaux_dato = datetime.date.today() - datetime.timedelta(days = ELDONMALFRUO)

hodiaux_tempo = datetime.datetime(hodiaux_dato.year,
                                  hodiaux_dato.month,
                                  hodiaux_dato.day,
                                  12)
hodiaux = hodiaux_tempo.strftime("%Y-%m-%d")

db = MySQLdb.connect(passwd = pkagordoj.get("db_passwd"),
                     db = pkagordoj.get("db_db"),
                     host = pkagordoj.get("db_host"),
                     user = pkagordoj.get("db_user"),
                     charset = "utf8")

cur = db.cursor()

# Serĉu la dosierojn por la hodiaŭa programo

cur.execute("select `sondosiero`.`nomo`, `elsendo`.`programero_id` "
            "from `elsendo` inner join `sondosiero` "
            "on `elsendo`.`programero_id` = `sondosiero`.`programero` "
            "where `dato` = %s"
            "order by `elsendo`.`dato`, "
            "`sondosiero`.`nomo`",
            hodiaux)

programeroj = []
last_id = -1
for row in cur:
    if last_id != row[1]:
        programeroj.append([])
        last_id = row[1]
    programeroj[-1].append(pkagordoj.get("loko_de_programeroj") + "/" + row[0])

if len(programeroj) < 1:
    print >> sys.stderr, "neniuj programeroj troviĝis por " + hodiaux
    exit(1)

kromdosieroj = sercxu_kromdosierojn(hodiaux_tempo)

aldonu_kromdosierojn(programeroj, sercxu_kromdosierojn(hodiaux_tempo))

dosieroj = [dosiero for sublisto in programeroj for dosiero in sublisto]

aldonu_jxinglojn(dosieroj, sercxu_jxinglojn())

# Kunigu la dosierojn per SoX. Per SoX ne eblas kunigi dosierojn kiuj
# havas malsamajn poecojn do ni devas unue ŝanĝi ilin en portempajn
# dosierojn

temp_files = []

for dosiero in dosieroj:
    temp_file = tempfile.NamedTemporaryFile(delete = True)
    temp_files.append(temp_file)

    res = subprocess.call(["sox",
                           dosiero,
                           "-c", "1",
                           "-r", "44100",
                           "-V1",
                           "-t", "wav",
                           temp_file.name])

    if res != 0:
        print >> sys.stderr, "sox malsukcesis"
        exit(res)

kunigita_dosiero = tempfile.NamedTemporaryFile(delete = True)

res = subprocess.call(["sox"] +
                      [item for sublist in [["-t", "wav", x.name]
                                            for x in temp_files]
                       for item in sublist] +
                      ["-t", "wav",
                       kunigita_dosiero.name])

for dosiero in temp_files:
    dosiero.close()

# Malgrandigu per lame

res = subprocess.call(["lame", "--quiet",
                       kunigita_dosiero.name,
                       pkagordoj.get("loko_de_podkastajxoj") +
                       "/podkasto-" + hodiaux + ".mp3"])

if res != 0:
    print >> sys.stderr, "lame malsukcesis"
    exit(res)

# Kaj per oggenc

res = subprocess.call(["oggenc", "--quiet",
                       "-o", (pkagordoj.get("loko_de_podkastajxoj") +
                              "/podkasto-" + hodiaux + ".ogg"),
                       kunigita_dosiero.name])

kunigita_dosiero.close()

# Serĉu jam ekzistantajn podkasterojn

pkre = re.compile(r"^podkasto-([0-9]{4})-([0-9]{2})-([0-9]{2})\.([a-z0-9]+)$")

datoj = []

for fn in os.listdir(pkagordoj.get("loko_de_podkastajxoj")):
    match = pkre.match(fn)

    if match:
        dato = datetime.date(int(match.group(1)),
                             int(match.group(2)),
                             int(match.group(3)))
        ext = match.group(4)
        # Se la dosiero tro malnovas, forigu ĝin
        if (hodiaux_dato - dato).days >= MAKSIMUMA_AGXO:
            os.remove(pkagordoj.get("loko_de_podkastajxoj") + "/" + fn)
        elif ext == "mp3":
            datoj.append(dato)

datoj.sort(reverse = True)

# Kreu la arbon por la RSS-dosiero
rss = ET.Element("rss")
rss.set("version", "2.0")
channel = ET.SubElement(rss, "channel")

ET.SubElement(channel, "title").text = "Muzaiko"
ET.SubElement(channel, "description").text = \
    "Podkasto de la Esperanta radio Muzaiko"
ET.SubElement(channel, "link").text = "http://muzaiko.info/"
ET.SubElement(channel, "language").text = "eo"

date_rfc822 = kiel_rfc822(datetime.datetime.utcnow())
ET.SubElement(channel, "pubDate").text = date_rfc822
ET.SubElement(channel, "lastBuildDate").text = date_rfc822

image = ET.SubElement(channel, "image")
ET.SubElement(image, "url").text = "http://muzaiko.info/public/images/reklambendoj/rb7.png"
ET.SubElement(image, "title").text = "Muzaiko"
ET.SubElement(image, "link").text = "http://muzaiko.info/"

html = ["<?php $podkastajxoj = array("]

for dato in datoj:
    # Faru 'item' por la dato
    (item, item_html) = faru_item(cur, dato)
    channel.append(item)
    html.append(item_html)

html.append(");?>")

# Eligu la RSS-dosieron
arbo = ET.ElementTree(rss)
arbo.write(pkagordoj.get("pk_rss_dosiero"))

out = open(pkagordoj.get("loko_de_podkastajxoj") + "/podkastajxoj.php", "w")
out.write(string.join(html, "").encode("utf-8"))
out.close()
