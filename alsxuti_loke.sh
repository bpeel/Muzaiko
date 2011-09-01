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
    --rsh=ssh \
    --delete \
    "$@" \
    . \
    /var/www

chown -R www-data:www-data /var/www/ 
