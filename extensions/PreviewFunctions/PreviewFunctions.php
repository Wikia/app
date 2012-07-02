<?php
/**
 * Extension to add parserfunction that get triggered during preview process
 * Ex: {{#ifpreview:text during preview|text not during preview}}
 *
 * @author Brian Wolff <bawolff+ext _at_ gmail _dot_ com>
 *
 * Copyright © Brian Wolff 2012.
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}


$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'PreviewFunctions',
	'descriptionmsg' => 'previewfunctions-desc',
	'version' => 2,
	'url' => 'https://mediawiki.org/wiki/Extension:PreviewFunctions',
	'author' => '[https://mediawiki.org/wiki/User:Bawolff Brian Wolff]',
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['PreviewFunctions'] = $dir . 'PreviewFunctions.i18n.php';
$wgExtensionMessagesFiles['PreviewFunctionsMagic'] = $dir . 'PreviewFunctions.i18n.magic.php';

$wgAutoloadClasses['PreviewFunctions'] = $dir . 'PreviewFunctions_body.php';

$wgHooks['ParserFirstCallInit'][] = 'PreviewFunctions::register';
