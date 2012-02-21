#!/usr/bin/python
# -*- coding: utf-8 -*-

import time
import urllib
import cgi
import os
import pkagordoj

RADIOUID = "14694a7d-9023-4db1-86b4-d85d96cba181"

class Peto:
    def __init__(self):
        self.pasinta_gxisdatigo = 0
        self.sekva_gxisdatigo = 0

    def anstatauxigu_dosieron(self, datumo):
        # Unue eligu la datumon al portempa dosiero
        dosiero = open(self.DOSIERO + ".tmp", "w")
        dosiero.write(datumo)
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
            finally:
                dosiero.close()
        except IOError:
            pass
        else:
            # Transformu la datumon
            datumo = self.transformu(datumo)

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

        # Atendu la sekvan ĝisdatigon dum 15 sekundoj
        self.pauxzo = 15

    def transformu(self, datumo):
        return "Nombro de aŭskultantoj " \
            "(laŭ Radionomy, eble ne tute preciza): " + \
            cgi.escape(datumo)

def cxefiteracio():
    nun = 0
    petoj = [ NombroDeAuxskultantoj() ]

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
