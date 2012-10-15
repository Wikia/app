<?php
/**
 * XMLRC extension for MediaWiki
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Daniel Kinzler
 * @copyright Copyright © 2010, Wikimedia Deutschland, All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 3.0 or later
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "XMLRC extension";
	exit( 1 );
}

// Extension credits that will show up on Special:Versiom
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'author' => 'Daniel Kinzler',
	'name' => 'XMLRC',
	'version' => '1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:XMLRC',
	'descriptionmsg'=> 'xmlrc-desc',
);

// Internationalisation file
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['XMLRC'] = $dir . 'XMLRC.i18n.php';

$wgXMLRCTransport = null;

#$wgXMLRCTransport = array(
#  'class' => 'XMLRC_File',
#  'file' => '/tmp/rc.xml',
#);

#$wgXMLRCTransport = array(
#  'class' => 'XMLRC_UDP',
#  'port' => 4455,
#  'address' => '127.0.0.1',
#);

$wgXMLRCProperties = 'user|comment|flags|timestamp|title|ids|sizes|redirect|loginfo|tags'; # sensible default
# $wgXMLRCProperties = 'title|timestamp|ids'; # default as per the API
# $wgXMLRCProperties = 'user|comment|parsedcomment|flags|timestamp|title|ids|sizes|redirect|loginfo|tags'; # everything except "patrolled", which is verboten

$wgAutoloadClasses['XMLRC'] = "$dir/XMLRC.class.php";
$wgAutoloadClasses['XMLRC_Transport'] = "$dir/XMLRC.class.php";
$wgAutoloadClasses['XMLRC_UDP'] = "$dir/XMLRC_UDP.class.php";
$wgAutoloadClasses['XMLRC_File'] = "$dir/XMLRC_File.class.php";

$wgHooks['RecentChange_save'][] = 'XMLRC::RecentChange_save';