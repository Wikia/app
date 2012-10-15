#!/bin/bash
echo "Content-type: text/html"
echo
echo '<html>'
echo '<body>'
echo '<h1> performance statistics </h1>'
echo '<pre>'
echo '<div style="color:#A00">=== Qcache ===</div>'
echo 'show status like "Qcache%";' |  mysql
echo 
echo '<div style="color:#0A0">=== Innodb ===</div>'
echo 'show status like "%buffer%";' | mysql
echo
echo '<div style="color:#00A">=== Memory (1 Mb blocks) ===</div>'
free -m

echo '</pre>'
echo '</body>'
echo '</html>'
