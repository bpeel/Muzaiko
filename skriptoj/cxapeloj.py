#!/usr/bin/python
# -*- coding: utf-8 -*-

import re

_CXAPELOLISTO = {
    u'c': u'ĉ', u'g': u'ĝ', u'h': u'ĥ', u'j': u'ĵ', u's': u'ŝ', u'u': u'ŭ',
    u'C': u'Ĉ', u'G': u'Ĝ', u'H': u'Ĥ', u'J': u'Ĵ', u'S': u'Ŝ', u'U': u'Ŭ'
   }

_cxapeligu_re = re.compile(u"([cghjsu])x", re.IGNORECASE | re.UNICODE)

def cxapeligu(cxeno):
    if isinstance(cxeno, str):
        ucxeno = unicode(cxeno, "utf-8")
    else:
        ucxeno = cxeno
    urezulto = _cxapeligu_re.sub(lambda(x): _CXAPELOLISTO[x.group(1)],
                                 ucxeno)
    if isinstance(cxeno, str):
        return urezulto.encode("utf-8")
    else:
        return urezulto

_MALCXAPELOLISTO = {
    u'ĉ': u'cx', u'ĝ': u'gx', u'ĥ': u'hx',
    u'ĵ': u'jx', u'ŝ': u'sx', u'ŭ': u'ux',
    u'Ĉ': u'Cx', u'Ĝ': u'Gx', u'Ĥ': u'Hx',
    u'Ĵ': u'Jx', u'Ŝ': u'Sx', u'Ŭ': u'Ux'
   }

_malcxapeligu_re = re.compile(u"[ĉĝĥĵŝŭ]", re.UNICODE | re.IGNORECASE)

def malcxapeligu(cxeno):
    if isinstance(cxeno, str):
        ucxeno = unicode(cxeno, "utf-8")
    else:
        ucxeno = cxeno
    urezulto = _malcxapeligu_re.sub(lambda(x): _MALCXAPELOLISTO[x.group(0)],
                                    ucxeno)
    if isinstance(cxeno, str):
        return urezulto.encode("utf-8")
    else:
        return urezulto
