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
#
# #################################################################################
#
# Copyright 2008 Harry Wood, Jens Frank, Grant Slater, Raymond Spekking and others
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# @addtogroup Extensions
#


if ( !defined( 'MEDIAWIKI' ) )
	die();

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfslippymap';
} else {
	$wgExtensionFunctions[] = 'wfslippymap';
}

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'OpenStreetMap Slippy Map',
	'author'         => array( '[http://harrywood.co.uk Harry Wood]', 'Jens Frank' ),
	'svn-date'       => '$LastChangedDate: 2008-12-07 16:35:06 +0100 (ndz, 07 gru 2008) $',
	'svn-revision'   => '$LastChangedRevision: 44282 $',
	'url'            => 'http://wiki.openstreetmap.org/index.php/Slippy_Map_MediaWiki_Extension',
	'description'    => 'Allows the use of the &lt;slippymap&gt; tag to display an OpenLayers slippy map. Maps are from [http://openstreetmap.org openstreetmap.org]',
	'descriptionmsg' => 'slippymap_desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['SlippyMap'] = $dir . 'SlippyMap.class.php';
$wgExtensionMessagesFiles['SlippyMap'] = $dir . 'SlippyMap.i18n.php';

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
	return true;
}
