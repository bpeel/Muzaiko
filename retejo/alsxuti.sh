#!/bin/bash

exec rsync \
    -a \
    -v \
    --exclude=/alsxuti.sh \
    --exclude=/alsxuti_loke.sh \
    --cvs-exclude \
    --exclude=/admin \
    --exclude=/.gitignore \
    --exclude=/drupal7 \
    --exclude=/datumbazensalutiloj.php \
    --exclude=/ajax/nekonata.log \
    --exclude=/sengit \
    --exclude=/mediawiki \
    --exclude=/ajax/cache_api.txt \
    --exclude=/ajax/cache_callapi.txt \
    --exclude=/programo/.htaccess \
    --exclude=/novajxoj_de_muzaiko/.htaccess \
    --exclude=/novajxoj_pri_muzaiko/.htaccess \
    --exclude=/hortabelo-originala.js \
    --exclude=/mallongigi-hortabelo.sh \
    --exclude=/diagramoj \
    --rsh=ssh \
    --delete \
    "$@" \
    . \
    root@muzaiko.info:/var/www/www.muzaiko.info
