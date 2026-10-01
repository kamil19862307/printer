#!/bin/bash

cd /home/c/cs494308/printerimfu || exit 1

/usr/bin/flock -n /tmp/printerimfu-queue.lock \
    /opt/php84/bin/php artisan queue:work --stop-when-empty

