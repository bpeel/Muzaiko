#!/usr/bin/python
# -*- coding: utf-8 -*-

import ConfigParser

_conf = ConfigParser.RawConfigParser()
_conf.read("/var/muzaiko/podkasto-agordoj.ini")

def get(nomo):
    return _conf.get("agordoj", nomo)
