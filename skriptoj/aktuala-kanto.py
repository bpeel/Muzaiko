#!/usr/bin/python
# -*- coding: utf-8 -*-

import time
import urllib
import cgi
import os
import pkagordoj

# Kiom da sekundoj inter ĉiu ĝisdatigo
SEKUNDOJ_INTER_GXISDATIGO = 15

URL_POR_NOMBRO_DE_AUXSKULTANTOJ = \
    "http://api.radionomy.com/currentaudience.cfm?" \
    "radiouid=14694a7d-9023-4db1-86b4-d85d96cba181"

def transformu_nombron_de_auxskultantoj(datumo):
    return "Nombro de aŭskultantoj " \
        "(laŭ Radionomy, eble ne tute preciza): " + \
        cgi.escape(datumo)

def anstatauxigu_dosieron(dosiernomo, datumo):
    # Unue eligu la datumon al portempa dosiero
    dosiero = open(dosiernomo + ".tmp", "w")
    dosiero.write(datumo)
    dosiero.close()

    # Renomu la originalan dosieron al la nova kiel atoma ago por ke
    # la dosiero neniam estos duone plenumita
    os.rename(dosiernomo + ".tmp", dosiernomo)

def gxisdatigu(url, transformo, dosiernomo):
    # Prenu la datumon el la URL kaj silente ignoru erarojn
    try:
        dosiero = urllib.urlopen(url)
        try:
            datumo = dosiero.read()
        finally:
            dosiero.close()
    except IOError:
        pass
    else:
        # Transformu la datumon
        datumo = transformo(datumo)

        try:
            anstatauxigu_dosieron(dosiernomo, datumo)
        except IOError:
            pass

def cxefiteracio():
    while True:
        pasinta_gxisdatigo = time.time()

        gxisdatigu(URL_POR_NOMBRO_DE_AUXSKULTANTOJ,
                   transformu_nombron_de_auxskultantoj,
                   pkagordoj.get("loko_de_ajax") +
                   "/nombro_de_auxskultantoj.html")

        # Dormu ĝis la sekva ĝisdatigo
        while True:
            nun = time.time()
            if (nun >= pasinta_gxisdatigo + SEKUNDOJ_INTER_GXISDATIGO or
                nun < pasinta_gxisdatigo):
                break

            time.sleep(pasinta_gxisdatigo +
                       SEKUNDOJ_INTER_GXISDATIGO - nun + 0.05)

cxefiteracio()
