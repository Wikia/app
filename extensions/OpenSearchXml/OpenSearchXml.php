<?php

/*
 * Copyright (C) 2008 Brion Vibber <brion@wikimedia.org>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'OpenSearchXml',
	'svn-date'       => '$LastChangedDate: 2008-11-30 04:15:22 +0100 (ndz, 30 lis 2008) $',
	'svn-revision'   => '$LastChangedRevision: 44056 $',
	'description'    => 'OpenSearch XML interface provides for text extracts',
	'descriptionmsg' => 'opensearchxml-desc',
	'author'         => 'Brion Vibber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:OpenSearchXml'
);

$wgExtensionMessagesFiles['OpenSearchXml'] = dirname(__FILE__) . '/OpenSearchXml.i18n.php';

$wgAPIModules['opensearch'] = 'ApiOpenSearchXml';
$wgAutoloadClasses['ApiOpenSearchXml'] =
	dirname(__FILE__) . '/ApiOpenSearchXml.php';

$wgHooks['OpenSearchUrls'][] = 'efOpenSearchXmlUrls';

$wgOpenSearchAdvertiseXml = true;

function efOpenSearchXmlUrls( &$urls ) {
	global $wgEnableAPI, $wgOpenSearchAdvertiseXml;
	if( $wgEnableAPI && $wgOpenSearchAdvertiseXml ) {
		$urls[] = array(
			'type' => 'application/x-suggestions+xml',
			'method' => 'get',
			'template' => efOpenSearchXmlTemplate() );

	}
	return true;
}

function efOpenSearchXmlTemplate() {
	global $wgServer, $wgScriptPath;
	$ns = implode( '|', SearchEngine::defaultNamespaces() );
	if( !$ns ) $ns = '0';
	return $wgServer . $wgScriptPath . '/api.php?action=opensearch&format=xml&search={searchTerms}&namespace='.$ns;
}
