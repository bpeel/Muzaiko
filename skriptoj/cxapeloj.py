#!/usr/bin/python
# -*- coding: utf-8 -*-

import re

_CXAPELOLISTO = {
    'c': 'ĉ', 'g': 'ĝ', 'h': 'ĥ', 'j': 'ĵ', 's': 'ŝ', 'u': 'ŭ',
    'C': 'Ĉ', 'G': 'Ĝ', 'H': 'Ĥ', 'J': 'Ĵ', 'S': 'Ŝ', 'U': 'Ŭ'
   }

_cxapeligu_re = re.compile(r"([cghjsu])x", re.IGNORECASE)

def cxapeligu(cxeno):
    return _cxapeligu_re.sub(lambda(x): _CXAPELOLISTO[x.group(1)],
                             cxeno)

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
