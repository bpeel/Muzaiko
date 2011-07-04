#!/bin/bash

exec rsync \
    -a \
    --exclude=/alsxuti.sh \
    --cvs-exclude \
    --exclude=/admin \
    --rsh=ssh \
    --delete \
    "$@" \
    . \
    root@muzaiko.info:/var/www
