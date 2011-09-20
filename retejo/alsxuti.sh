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
    --exclude=/ajax/current_song.xml \
    --exclude=/ajax/right_timestamp.txt \
    --exclude=/ajax/radionomy_access.log \
    --exclude=/ajax/cache_api.txt \
    --rsh=ssh \
    --delete \
    "$@" \
    . \
    root@muzaiko.info:/var/www
