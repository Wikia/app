Complete online documenation: 
http://www.mediawiki.org/wiki/Extension:FlaggedRevs

== Setup ==
* Download the extension from SVN
* Upgrade to MediaWiki 1.14+
* Run 'maintenance/update.php' if you needed to upgrade
* Run 'maintenance/archives/populateSha1.php'.
* Make sure '../extensions/FlaggedRevs' is readable (for CSS/JS)
* To enable PNG images for reader feedback (instead of SVG), make sure PHP has the GD libraries installed. In windows, 
this is done by un-commenting them out in php.ini. In linux, php should be compiled with it enabled ('--with-gd'). 
(See a nice guide here: http://www.onlamp.com/pub/a/php/2003/03/27/php_gd.html). $wgSvgGraphDir must be set to false.
* Add the following line to 'LocalSettings.php': 
	include_once('extensions/FlaggedRevs/FlaggedRevs.php');
* Run 'maintenance/update.php'

It is important that the sha1 column is populated. This allows for image injection via key 
rather than the (name,timestamp) pair. In the future, image moves may be supported by MediaWiki, 
breaking the later method.

Be sure to set the $wgReviewCodes variable as well. See FlaggedRevs.php for details.

== Configuration ==
There is a commented list of configurable variables in FlaggedRevs.php. The online documentation
expains these further.

== Uninstallation ==
* Remove the include line from LocalSettings.php
* Drop the tables in FlaggedRevs.sql. Drop the columns 'page_ext_reviewed', 'page_ext_quality' and 'page_ext_stable', 
and the index 'ext_namespace_reviewed' from the page table.
* Run maintenance/refreshLinks.php from the command line to flush out the stable version links

== Licensing ==
© GPL, Aaron Schulz, Joerg Baach, 2007


