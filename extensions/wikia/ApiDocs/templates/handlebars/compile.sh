#!/usr/bin/env bash

for i in *.handlebars; do
  echo compile $i to $i.js
  handlebars $i -f $i.js -o
done
