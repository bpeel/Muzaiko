#!/bin/bash
set -eux

#exec 
rsync \
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
    --exclude=/ajax/cache_api.txt \
    --exclude=/ajax/cache_callapi.txt \
    --rsh=ssh \
    --delete \
    "$@" \
    . \
    /var/www

chown -R www-data:www-data /var/www/ 
