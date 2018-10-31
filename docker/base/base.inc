listen 8080;
root /usr/wikia/slot1/current/src;

rewrite "^/health/check$" /health.php break;
rewrite "^/proxy.php$" /extensions/wikia/Tasks/proxy/proxy.php break;

rewrite ^/robots.txt /wikia-robots-txt.php break;
rewrite "^/(sitemap.+\.xml(.gz)*)$" /index.php?title=Special:Sitemap/$1&uselang=en break;

rewrite "^/(?:[a-z]{2,3}(?:-[a-z-]{2,12})?/)?__load/[^/]*/([^/]*)/([^$].+)" /load.php?modules=$2&$1 break;
rewrite "^/(?:[a-z]{2,3}(?:-[a-z-]{2,12})?/)?__am/(\d+)/([A-Za-z]+)/([^/]*)/(.*)" /index.php?action=ajax&rs=AssetsManagerEntryPoint&cb=$1&type=$2&params=$3&oid=$4 break;

rewrite ^/api/(?:v1|test)/?$ /wikia.php?controller=ApiDocs&method=index break;
rewrite ^/api/(?:v1|test)/([^/]*)/([^/]*) /wikia.php?controller=$1Api&method=get$2 break;

# SUS-5798 / SUS-5824: alternative article paths - /wiki/index.php and /w
# SUS-6051 | because of The Complex Way wiki domain is passed down to nginx
#            we need to use /redirect-canonical.php to handle these redirects
rewrite "^/([a-z]{2,3}(-[a-z-]{2,12})?/)?w/(.*)$" /redirect-canonical.php break;
rewrite "^/([a-z]{2,3}(-[a-z-]{2,12})?/)?wiki/index.php/(.*)$" /redirect-canonical.php break;

# rewrites for language wiki
rewrite "^/[a-z]{2,3}(?:-[a-z-]{2,12})?/(sitemap.+\.xml[.gz]*)$" /index.php?title=Special:Sitemap/$1&uselang=en break;

rewrite "^/(?:[a-z]{2,3}(?:-[a-z-]{2,12})?/)?api.php(.*)" /api.php$1;
# SUS-5789 force pre-existing lyricwiki API calls to use a MediaWiki-compliant query
# it should be the last rewrite for api.php, since "if" behaviour might be unexpected otherwise (https://www.nginx.com/resources/wiki/start/topics/depth/ifisevil/)
# this if checks if there is a "func" query param
if ($arg_func) {
    rewrite ^(.*)$ $1?action=lyrics last;
}
 # SUS-6154
rewrite "^/(?:[a-z]{2,3}(?:-[a-z-]{2,12})?/)?(index|load|metrics|wikia).php(.*)" /$1.php$2 break;

# article URL
rewrite "^/(?:[a-z]{2,3}(?:-[a-z-]{2,12})?/)?wiki/(.*)" /index.php?title=$1 break;

# rewrite for language wiki root path
rewrite "^/(?:[a-z]{2,3}(?:-[a-z-]{2,12})?/?)?$" /index.php break;

# handle cachebuster URLs and default favicon on devboxes and local machines
rewrite "^/(?:[a-z]{2,3}(?:-[a-z-]{2,12})?/)?(__cb\d+/)?(skins|resources|extensions)/(.+)" /$2/$3 break;
rewrite ^/favicon.ico /skins/common/images/favicon.ico break;

# filter out unwanted directories
location ~ ^/(lib|serialized|tests|mw-config|includes|cache|maintenance|languages|config) {
    return 403;
}

error_page 404 = /redirect-canonical.php;
