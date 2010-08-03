<?php
/**
 * Copyright (C) 2005 Brion Vibber <brion@pobox.com>
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @addtogroup Extensions
 */

/**
 * Define special-purpose parser extension hooks which will just
 * include an image. Key needs to be string-safe.
 */
$wgFixedImageHooks = array(
	'fundraising' => array(
		'src' => 'http://fundraising.wikimedia.org/2005q4/progress/320px.png',
		'width' => 320,
		'height' => 28,
		'alt' => '...' ),
	);

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'FixedImage',
	'author'         => 'Brion Vibber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:FixedImage',
	'svn-date'       => '$LastChangedDate: 2008-12-20 10:32:47 +0100 (sob, 20 gru 2008) $',
	'svn-revision'   => '$LastChangedRevision: 44839 $',
	'description'    => 'Just include an image',
	'descriptionmsg' => 'fixedimage-desc',
);
$wgExtensionMessagesFiles['FixedImage'] =  dirname(__FILE__) . '/FixedImage.i18n.php';

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'fixedImageSetup';
} else {
	$wgExtensionFunctions[] = 'fixedImageSetup';
}

function fixedImageSetup() {
	global $wgParser, $wgFixedImageHooks;
	foreach( $wgFixedImageHooks as $key => $data ) {
		$wrapper = create_function( '$text, $params=null',
			"return fixedImageHandler('$key', \$text, \$params);" );
		$wgParser->setHook( $key, $wrapper );
	}
	return true;
}

/**
 * This function is *not* to be used directly as a parser hook handler;
 * a wrapper for each defined tag is created at runtime.
 *
 * @param string $key the tag name and key in $wgImageHooks for the image
 * @param string $text parser hook parameter, ignored
 * @param array $params parser hook parameter, ignored
 * @return string HTML <img> tag
 */
function fixedImageHandler( $key, $text, $params=null ) {
	global $wgFixedImageHooks;
	return Xml::element( 'img', $wgFixedImageHooks[$key] );
}
