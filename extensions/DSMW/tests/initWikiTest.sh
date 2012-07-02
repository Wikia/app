#!/bin/sh
mysql -u root -padmin wikidbTest10 < $1
mysql -u root -padmin wikidbTest11 < $1
mysql -u root -padmin wikidbTest12 < $1

#mysql -u "wikidbTest4" -p"wiki" wikidbTest4 < dump16.sql
#mysql -u "wikidbTest5" -p"wiki" wikidbTest5 < dump16.sql
#mysql -u "wikidbTest6" -p"wiki" wikidbTest6 < dump16.sql
