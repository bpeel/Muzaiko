#!/bin/bash

# Ĉi tiu skripto mallongigas la dosieron hortabelo.js per la programo
# YUI.

echo -e "/* Cxi tiu dosiero estas auxtomate farite per" \
    "mallongigi-hortabelon.sh.\n   Bonvolu ne redakti gxin. */" \
    > hortabelo.js

yui-compressor hortabelo-originala.js \
    >> hortabelo.js
