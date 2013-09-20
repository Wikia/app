<?php
// ImageSizeInfoFunctions MediaWiki Extension.
// Give two parser functions returning width and height of a given image.
//
// Copyright (C) 2007, Dario de Judicibus.
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA



$wgExtensionCredits['parserhook'][] = array(
	'name' => 'ImageSizeInfoFunctions',
	'version' => '1.0.1~wikia',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ImageSizeInfoFunctions',
	'author' => 'Dario de Judicibus',
	'description' => 'Enhance parser with image size info functions',
);

$wgAutoloadClasses['ExtImageSizeInfoFunctionsHooks'] = dirname( __FILE__ ) . '/ImageSizeInfoFunctions.hooks.php';

$wgHooks['ParserFirstCallInit'][] = 'ExtImageSizeInfoFunctionsHooks::parserFirstCallInit';

$wgExtensionMessagesFiles['ImageSizeInfoFunctions'] =  dirname( __FILE__ ) . '/ImageSizeInfoFunctions.i18n.php';
