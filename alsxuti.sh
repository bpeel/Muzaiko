#!/bin/bash

exec rsync \
    -a \
    -v \
    --exclude=/alsxuti.sh \
    --cvs-exclude \
    --exclude=/admin \
    --rsh=ssh \
    --delete \
    "$@" \
    . \
    root@muzaiko.info:/var/www
