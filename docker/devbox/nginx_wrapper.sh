#!/bin/sh
mkfifo /var/log/nginx/std.log
nginx -g "daemon off;" > /var/log/nginx/std.log