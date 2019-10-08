#!/bin/sh
set -e
FILE=`basename -s .sh $0`
umbrello --export png  ${FILE}.xmi
xsltproc --nonet /usr/share/apps/umbrello/xmi2docbook.xsl ${FILE}.xmi  > ${FILE}.docbook
pandoc -s --toc --from docbook --to html --output ${FILE}.html ${FILE}.docbook