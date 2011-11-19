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
    --exclude=/novajxoj/.htaccess \
    --exclude=/hortabelo-originala.js \
    --exclude=/mallongigi-hortabelo.sh \
    --rsh=ssh \
    --delete \
    "$@" \
    . \
    root@muzaiko.info:/var/www/www.muzaiko.info
