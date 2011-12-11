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

# Maksimuma aĝo en tagoj post kiu dosiero foriĝos
MAKSIMUMA_AGXO = 7

def kiel_rfc822(tempo):
    return tempo.strftime("%a, %d %b %Y %H:%M:%S UTC")

def faru_ligilojn(cxen):
    cxen = cgi.escape(cxen)

    cxen = re.sub(r"\[([^\]]+)\]\(([^\)]+)\)",
                  lambda(match): ("<a href=\"" + match.group(2) + "\">" +
                                  match.group(1) + "</a>"),
                  cxen)
    cxen = re.sub(r"\*([^\*]+)\*",
                  lambda(match): "<i>" + match.group(1) + "</i>",
                  cxen)

    return cxen

def faru_item(cur, dato):
    item = ET.Element("item")

    cxendato = dato.strftime("%Y-%m-%d")

    ET.SubElement(item, "title").text = ("Elsendo de " +
                                         dato.strftime(cxendato))
    dato_tempo = datetime.datetime(dato.year,
                                   dato.month,
                                   dato.day,
                                   3)
    ET.SubElement(item, "pubDate").text = kiel_rfc822(dato_tempo)

    # Serĉu ĉiujn priskribojn de tiu tago
    programeroj = []
    cur.execute("select `programero`.`description` "
                "from `programero` inner join `elsendo` "
                "on `elsendo`.`programero_id` = `programero`.`id` "
                "where date(`elsendo`.`date_begin`) = %s "
                "order by `elsendo`.`date_begin`",
                cxendato)
    for row in cur:
        programeroj.append(faru_ligilojn(row[0]))

    priskribo = ("<p>La programo por " + cxendato + " estas:</p>" +
                 string.join(["<p>" + x + "</p>" for x in programeroj]))

    ET.SubElement(item, "description").text = priskribo

    url = pkagordoj.url_radiko + "/podkasto-" + cxendato + ".mp3"
    enc = ET.SubElement(item, "enclosure")
    enc.set("url", url)
    enc.set("type", "audio/mpeg")
    enc.set("length", str(os.path.getsize(pkagordoj.loko_de_podkastajxoj +
                                          "/podkasto-" + cxendato + ".mp3")))

    return item

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
    hodiaux_dato = datetime.date.today()

hodiaux_tempo = datetime.datetime(hodiaux_dato.year,
                                  hodiaux_dato.month,
                                  hodiaux_dato.day,
                                  12)
hodiaux = hodiaux_tempo.strftime("%Y-%m-%d")

db = MySQLdb.connect(passwd = pkagordoj.db_passwd,
                     db = pkagordoj.db_db,
                     host = pkagordoj.db_host,
                     user = pkagordoj.db_user,
                     charset = "utf8")

cur = db.cursor()

# Serĉu la dosierojn por la hodiaŭa programo

cur.execute("select `sondosiero`.`nomo` "
            "from `elsendo` inner join `sondosiero` "
            "on `elsendo`.`programero_id` = `sondosiero`.`programero` "
            "where date(`elsendo`.`date_begin`) = %s"
            "order by `elsendo`.`date_begin`, "
            "`sondosiero`.`nomo`",
            hodiaux)

dosieroj = [pkagordoj.loko_de_programeroj + "/" + row[0] for row in cur]

if len(dosieroj) < 1:
    print >> sys.stderr, "neniuj programeroj troviĝis por " + hodiaux
    exit(1)

# Kunigu la dosierojn kaj ŝanĝi ilin al MP3 per SoX

res = subprocess.call(["sox"] + dosieroj +
                      ["-c", "1",
                       "-r", "44100",
                       "-V1",
                       pkagordoj.loko_de_podkastajxoj +
                       "/podkasto-" + hodiaux + ".wav"])

if res != 0:
    print >> sys.stderr, "sox malsukcesis"
    exit(res)

# Malgrandigu per lame

res = subprocess.call(["lame", "--quiet",
                       pkagordoj.loko_de_podkastajxoj +
                       "/podkasto-" + hodiaux + ".wav",
                       pkagordoj.loko_de_podkastajxoj +
                       "/podkasto-" + hodiaux + ".mp3"])

if res != 0:
    print >> sys.stderr, "lame malsukcesis"
    exit(res)

# Kaj per oggenc

res = subprocess.call(["oggenc", "--quiet",
                       "-o", (pkagordoj.loko_de_podkastajxoj +
                              "/podkasto-" + hodiaux + ".ogg"),
                       pkagordoj.loko_de_podkastajxoj +
                       "/podkasto-" + hodiaux + ".wav"])

# Serĉu jam ekzistantajn podkasterojn

pkre = re.compile(r"^podkasto-([0-9]{4})-([0-9]{2})-([0-9]{2})\.([a-z0-9]+)$")

datoj = []

for fn in os.listdir(pkagordoj.loko_de_podkastajxoj):
    match = pkre.match(fn)

    if match:
        dato = datetime.date(int(match.group(1)),
                             int(match.group(2)),
                             int(match.group(3)))
        ext = match.group(4)
        # Se la dosiero tro malnovas, forigu ĝin
        if (hodiaux_dato - dato).days >= MAKSIMUMA_AGXO:
            os.remove(pkagordoj.loko_de_podkastajxoj + "/" + fn)
        elif ext == "mp3":
            datoj.append(dato)

datoj.sort()

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
ET.SubElement(image, "url").text = "http://muzaiko.info/reklambendoj/rb7.png"
ET.SubElement(image, "title").text = "Muzaiko"
ET.SubElement(image, "link").text = "http://muzaiko.info/"

for dato in datoj:
    # Faru 'item' por la dato
    channel.append(faru_item(cur, dato))

# Eligu la RSS-dosieron
arbo = ET.ElementTree(rss)
arbo.write(pkagordoj.rss_dosiero)
