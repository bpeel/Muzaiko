#!/usr/bin/python
# -*- coding: utf-8 -*-

import time
import urllib
import cgi
import os
import pkagordoj
import xml.etree.ElementTree as ET
import xml.parsers.expat
import MySQLdb
import cxapeloj
import textwrap
import httplib
import sys

RADIOUID = "14694a7d-9023-4db1-86b4-d85d96cba181"

# Plej granda nombro de literoj antaŭ ol tranĉi la ĉenon
LINILONGO = 60

class Peto:
    class FusxaTransformo(Exception):
        pass

    def __init__(self):
        self.pasinta_gxisdatigo = 0
        self.sekva_gxisdatigo = 0

    def anstatauxigu_dosieron(self, datumo):
        # Unue eligu la datumon al portempa dosiero
        dosiero = open(self.DOSIERO + ".tmp", "w")
        dosiero.write(datumo.encode("utf-8"))
        dosiero.close()

        # Renomu la originalan dosieron al la nova kiel atoma ago por ke
        # la dosiero neniam estos duone plenumita
        os.rename(self.DOSIERO + ".tmp", self.DOSIERO)

    def gxisdatigu(self):
        # Prenu la datumon el la URL kaj silente ignoru erarojn
        try:
            dosiero = urllib.urlopen(self.URL)
            try:
                datumo = dosiero.read()
                if dosiero.getcode() != httplib.OK:
                    raise IOError("La HTTP peto fusxis")
            finally:
                dosiero.close()
        except (IOError, httplib.HTTPException):
            pass
        else:
            try:
                # Transformu la datumon
                datumo = self.transformu(datumo)
            except Peto.FusxaTransformo:
                pass
            else:
                try:
                    Peto.anstatauxigu_dosieron(self, datumo)
                except IOError:
                    pass
        finally:
            self.pasinta_gxisdatigo = time.time()
            self.sekva_gxisdatigo = self.pasinta_gxisdatigo + self.pauxzo

class NombroDeAuxskultantoj(Peto):
    URL = \
        "http://api.radionomy.com/currentaudience.cfm?" \
        "radiouid=" + RADIOUID

    DOSIERO = \
        pkagordoj.get("loko_de_ajax") + \
        "/nombro_de_auxskultantoj.html"

    def __init__(self):
        Peto.__init__(self)

        # Atendu la sekvan ĝisdatigon dum 1 minuto kvankam
        # la prokrasto laŭ Radionomy devas daŭri 5 minutojn
        self.pauxzo = 60

    def transformu(self, datumo):
        return cgi.escape(unicode(datumo, "utf-8"))

class Ligilo:
    def _filtru_cxenon(self, cxeno):
        if cxeno and cxeno != '0' and cxeno != '-1':
            return cxeno
        else:
            return None

    def _faru_elektilon(self, ry_kampo, kampo):
        return ("if(isnull(" + ry_kampo + ") or " +
                ry_kampo + " = '', " + kampo + ", " + ry_kampo + ")")

    def __init__(self, db, artisto, titolo):
        self.artisto = artisto
        self.titolo = titolo
        self.ligilo_vk = None
        self.ligilo_vk_mp3 = None
        self.ligilo_CD1D = None
        self.ligilo_muzikteksto = None
        self.ligilo_retpagxo = None

        if artisto == None and titolo == None:
            return

        sercxiloj = []
        params = []

        if artisto:
            sercxiloj.append(self._faru_elektilon("`RY_Artistoj`",
                                                  "`Artistoj`") +
                             " = %s")
            params.append(cxapeloj.malcxapeligu(artisto))
        if titolo:
            sercxiloj.append(self._faru_elektilon("`RY_Titolo`",
                                                  "`Titolo`") +
                             " = %s")
            params.append(cxapeloj.malcxapeligu(titolo))

        sercxiloj.append("(isnull(`REF`) or `REF` NOT LIKE 'VK%%')");

        cur = db.cursor()
        cur.execute("select `Ligoj_al_diskoservo`, `Ligoj_al_la_elsxutejo`, "
                    "`Ligoj_al_CD1D`, `Ligoj_al_muzikteksto`, "
                    "`Ligoj_al_retpagxo`, "
                    "`Artistoj`, `Titolo` "
                    "from `muzaiko_datumbazo` "
                    "where " + (" and ".join(sercxiloj)) + " " +
                    "limit 1",
                    params)

        trovita = False
        for row in cur:
            self.ligilo_vk = self._filtru_cxenon(row[0])
            self.ligilo_vk_mp3 = self._filtru_cxenon(row[1])
            self.ligilo_CD1D = self._filtru_cxenon(row[2])
            self.ligilo_muzikteksto = self._filtru_cxenon(row[3])
            self.ligilo_retpagxo = self._filtru_cxenon(row[4])
            self.artisto = self._filtru_cxenon(row[5])
            self.titolo = self._filtru_cxenon(row[6])
            trovita = True

        if not trovita:
            cur.execute("insert into `netrovita_kanto` "
                        "(`artistoj`, `titolo`, `dato_de_manko`) "
                        "values (%s, %s, now()) "
                        "on duplicate key update `dato_de_manko` = now()",
                        [ artisto if artisto else "",
                          titolo if titolo else "" ])

class AktualaKanto(Peto):
    URL = \
        "http://api.radionomy.com/currentsong.cfm?" \
        "radiouid=" + RADIOUID + "&" + \
        "apikey=" + pkagordoj.get("apikey") + "&" + \
        "callmeback=yes&" + \
        "type=xml"

    DOSIERO = \
        pkagordoj.get("loko_de_ajax") + \
        "/aktuala_kanto.html"

    def __init__(self):
        Peto.__init__(self)

        self.db = MySQLdb.connect(passwd = pkagordoj.get("kantdb_passwd"),
                                  db = pkagordoj.get("kantdb_db"),
                                  host = pkagordoj.get("kantdb_host"),
                                  user = pkagordoj.get("kantdb_user"),
                                  charset = "utf8")

    def gxisdatigu(self):
        # Defaŭlte repetu post 30 sekundoj se la peto fuŝas
        self.pauxzo = 30

        Peto.gxisdatigu(self)

    def transformu(self, datumo):
        rezulto = []

        try:
            dok = ET.fromstring(datumo)
        except (UnicodeError, xml.parsers.expat.ExpatError):
            raise Peto.FusxaTransformo()

        titolo = dok.findtext("track/title")
        artisto = dok.findtext("track/artists")
        callmeback = dok.findtext("track/callmeback")

        try:
            callmeback = int(callmeback)
        except (ValueError, TypeError):
            raise Peto.FusxaTransformo()

        ligilo = Ligilo(self.db, artisto, titolo)

        nomo = []
        if artisto:
            nomo.append(cgi.escape(cxapeloj.cxapeligu(ligilo.artisto)))
        if titolo:
            nomo.append(cgi.escape(cxapeloj.cxapeligu(ligilo.titolo)))
        try:
            rezulto.append("<br>".join(textwrap.wrap(" - ".join(nomo), LINILONGO)))
        except:
	    print "Unexpected error:", sys.exc_info()[0]
	    f = open('/var/muzaiko/datumo.txt','w')
	    f.write(datumo)
	    f.close()


        rezulto.append("<br>")

        ligiloj =[]

        if ligilo.ligilo_vk:
            ligiloj.append('<a target="blank" href="' +
                           cgi.escape(ligilo.ligilo_vk) + '">' +
                           'Fizika albumo</a>')
        if ligilo.ligilo_vk_mp3:
            ligiloj.append('<a target="blank" href="' +
                           cgi.escape(ligilo.ligilo_vk_mp3) + '">' +
                           'MP3</a>')
        if ligilo.ligilo_CD1D:
            ligiloj.append('<a target="blank" href="' +
                           cgi.escape(ligilo.ligilo_CD1D) + '">' +
                           'CD1D</a>')
        if ligilo.ligilo_muzikteksto:
            ligiloj.append('<a target="blank" href="' +
                           cgi.escape(ligilo.ligilo_muzikteksto) + '">' +
                           'Muzikteksto</a>')
        if ligilo.ligilo_retpagxo:
            ligiloj.append('<a target="blank" href="' +
                           cgi.escape(ligilo.ligilo_retpagxo) + '">' +
                           u'Retpaĝo</a>')

        rezulto.append(" - ".join(ligiloj))

        self.pauxzo = callmeback / 1000.0

        return ''.join([(unicode(x, "utf-8") if isinstance(x, str) else x)
                        for x in rezulto])

def cxefiteracio():
    nun = 0
    petoj = [ AktualaKanto(), NombroDeAuxskultantoj() ]

    while True:
        # Ĝisdatigu ĉiujn petojn kiuj jam pretas
        for peto in petoj:
            if (nun >= peto.sekva_gxisdatigo or
                nun < peto.pasinta_gxisdatigo):
                peto.gxisdatigu()

        # Dormu ĝis la sekva ĝisdatigo
        while True:
            sekva_gxisdatigo = min([peto.sekva_gxisdatigo for peto in petoj])
            pasinta_gxisdatigo = max([peto.pasinta_gxisdatigo
                                      for peto in petoj])

            nun = time.time()

            if (nun >= sekva_gxisdatigo or nun < pasinta_gxisdatigo):
                break

            time.sleep(sekva_gxisdatigo - nun + 0.05)

cxefiteracio()
