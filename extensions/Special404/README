Special404 can be installed by installing the extension and adding some webserver
config to make the special page handle 404s.

For apache there are issues getting a ErrorDocument to work, a RewriteRule is
one known way to make this work. You can place something like this inside of your
.htaccess file:

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^/?.*$ /index.php?title=Special:Error404

Be sure to tweak it to match the local location of your index.php and include any
other RewriteRules BEFORE this rule, this should be the very last RewriteRule you have.

Note that it's important that you use /index.php?title=Special:Error404 instead
of something that includes the path and you do not use something like /wiki/Special:Error404
because this destination using index.php and an explicit title is the only one
that will get MediaWiki to display the 404 special page. It also retains the
request path which the extension will then pass to the 404 body.

Note that you can customize the 404 page's body by using [[MediaWiki:Special404-body]].
