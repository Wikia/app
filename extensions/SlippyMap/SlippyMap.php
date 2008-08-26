<?php
# OpenStreetMap SlippyMap - MediaWiki extension
# 
# This defines what happens when <slippymap> tag is placed in the wikitext
# 
# We show a map based on the lat/lon/zoom data passed in. This extension brings in
# the OpenLayers javascript, to show a slippy map.  
#
# Usage example:
# <slippymap lat=51.485 lon=-0.15 z=11 w=300 h=200 layer=osmarender></slippymap> 
#
# Tile images are not cached local to the wiki.
# To acheive this (remove the OSM dependency) you might set up a squid proxy,
# and modify the requests URLs here accordingly.
# 
# This file should be placed in the mediawiki 'extensions' directory
# ...and then it needs to be 'included' within LocalSettings.php

if( defined( 'MEDIAWIKI' ) ) {
	$wgExtensionFunctions[] = 'wfslippymap';

	$wgExtensionCredits['parserhook'][] = array(
		'name'           => 'OpenStreetMap Slippy Map',
		'author'         => '[http://harrywood.co.uk Harry Wood], Jens Frank',
		'svn-date'       => '$LastChangedDate: 2008-07-03 20:13:10 +0000 (Thu, 03 Jul 2008) $',
		'svn-revision'   => '$LastChangedRevision: 37003 $',
		'url'            => 'http://wiki.openstreetmap.org/index.php/Slippy_Map_MediaWiki_Extension',
		'description'    => 'Allows the use of the &lt;slippymap&gt; tag to display an OpenLayers slippy map. Maps are from [http://openstreetmap.org openstreetmap.org]',
		'descriptionmsg' => 'slippymap_desc',
	);

	$wgAutoloadClasses['SlippyMap'] = dirname( __FILE__ ) . '/SlippyMap.class.php';
	$wgExtensionMessagesFiles['SlippyMap'] = dirname( __FILE__ ) . "/SlippyMap.i18n.php";

	# Bump this when updating OpenStreetMap.js to help update caches
	$wgSlippyMapVersion = 1;

	function wfslippymap() {
		global $wgParser, $wgMapOfServiceUrl;
		# register the extension with the WikiText parser
		# the first parameter is the name of the new tag.
		# In this case it defines the tag <slippymap> ... </slippymap>
		# the second parameter is the callback function for
		# processing the text between the tags
		$wgParser->setHook( 'slippymap', array( 'SlippyMap', 'parse' ) );
		$wgMapOfServiceUrl = "http://osm-tah-cache.firefishy.com/~ojw/MapOf/?";
	}

}
