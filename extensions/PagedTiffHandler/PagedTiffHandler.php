<?php
 /**
  * Copyright (C) Wikimedia Deuschland, 2009
  * Authors Hallo Welt! Medienwerkstatt GmbH
  * Authors Sebastian Ulbricht, Daniel Lynge, Marc Reymann, Markus Glaser
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
  *
  */

//error_reporting(E_ALL);
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "PagedTiffHandler extension";
	exit(1);
}

/** Add to LocalSettings.php
require_once("$IP/extensions/PagedTiffHandler/PagedTiffHandler.php");

$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "C:\Program Files\ImageMagick-6.5.6-Q8\convert";
$wgImageMagickIdentifyCommand = "C:\Program Files\ImageMagick-6.5.6-Q8\identify";
$wgTiffExivCommand = "C:\Program Files\Exiv2\exiv2";
$wgMaxUploadSize = 1073741824;


 */

$wgExtensionCredits['media'][] = array(
	'path' => __FILE__,
	'name' => 'PagedTiffHandler',
	'author' => array(
		'[http://www.hallowelt.biz HalloWelt! Medienwerkstatt GmbH]',
		'Sebastian Ulbricht',
		'Daniel Lynge',
		'Marc Reymann',
		'Markus Glaser for Wikimedia Deutschland'
	),
	'description' => 'Handler for viewing paged TIFF files in image mode',
	'descriptionmsg' => 'tiff-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:PagedTiffHandler',
);

$wgTiffIdentifyRejectMessages = array(
	'/TIFFErrors?/',
	'/^identify: Compression algorithm does not support random access/',
	'/^identify: Old-style LZW codes, convert file/',
	'/^identify: Sorry, requested compression method is not configured/',
	'/^identify: ThunderDecode: Not enough data at scanline/',
	'/^identify: .+?: Read error on strip/',
	'/^identify: .+?: Can not read TIFF directory/',
	'/^identify: Not a TIFF/',
);

$wgTiffIdentifyBypassMessages = array(
	//'/TIFFWarnings/',
	//'/TIFFWarning/',
	'/^identify: .*TIFFReadDirectory/',
	'/^identify: .+?: unknown field with tag .+? encountered/'
);

// Use PHP-TiffReader
$wgTiffUseTiffReader = true;
$wgTiffReaderPath = dirname(__FILE__);
$wgTiffReaderCheckEofForJS = 4; // check the last 4MB for JS

// Path to identify
$wgImageMagickIdentifyCommand = '/usr/bin/identify';
// Path to exiv2
$wgTiffExivCommand = '/usr/bin/exiv2';
// Use exiv2?
$wgTiffUseExiv = false;
// Path to vips
$wgTiffVipsCommand = '/usr/bin/vips';
// Use vips
$wgTiffUseVips = false;
// Maximum number of embedded files in tiff image
$wgTiffMaxEmbedFiles = 10000;
// Maximum resolution of embedded images (product of width x height pixels)
$wgTiffMaxEmbedFileResolution = 25600000; // max. Resolution 1600 x 1600 pixels
// Maximum size of meta data
$wgTiffMaxMetaSize = 67108864; // 64kB
// TTL of Cacheentries for Errors
$wgTiffErrorCacheTTL = 84600;

$wgFileExtensions[] = 'tiff';
$wgFileExtensions[] = 'tif';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['PagedTiffHandler'] = $dir . 'PagedTiffHandler.i18n.php';
$wgAutoloadClasses['PagedTiffImage'] = $dir . 'PagedTiffHandler.image.php';
$wgAutoloadClasses['PagedTiffHandler'] = $dir . 'PagedTiffHandler_body.php';
$wgMediaHandlers['image/tiff'] = 'PagedTiffHandler';
$wgHooks['UploadVerification'][] = 'PagedTiffHandler::check';
$wgHooks['LanguageGetMagic'][] = 'PagedTiffHandler::addTiffLossyMagicWordLang';
$wgHooks['PagedTiffHandlerRenderCommand'][] = 'PagedTiffHandler::renderCommand';
$wgHooks['PagedTiffHandlerExivCommand'][] = 'PagedTiffImage::exivCommand';