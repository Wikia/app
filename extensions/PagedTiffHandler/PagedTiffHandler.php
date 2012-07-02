<?php
/**
 * Copyright © Wikimedia Deutschland, 2009
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
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo 'PagedTiffHandler extension';
	exit( 1 );
}

/* Add to LocalSettings.php
require_once("$IP/extensions/PagedTiffHandler/PagedTiffHandler.php");

$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "C:\Program Files\ImageMagick-6.5.6-Q8\convert";
$wgImageMagickIdentifyCommand = "C:\Program Files\ImageMagick-6.5.6-Q8\identify";
$wgExiv2Command = "C:\Program Files\Exiv2\exiv2";
$wgMaxUploadSize = 1073741824;
$wgShowEXIF = true;
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
	'descriptionmsg' => 'tiff-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PagedTiffHandler',
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

$wgTiffTiffinfoRejectMessages = array(
	'/.*: Cannot read TIFF header\.$/',
	'/.*: Not a TIFF or MDI file, bad magic number .+\.$/',
	'/.*: Error fetching data for field .+\.$/',
	'/TIFFReadDirectory: .*: Can not read TIFF directory count\.$/',
);

$wgTiffTiffinfoBypassMessages = array(
	'/^TIFFReadCustomDirectory: .+: unknown field with tag .+? encountered\./',
	'/^TIFFReadCustomDirectory: .+: wrong data type .*; tag ignored\./',
);

// Use PHP-TiffReader
// This is still experimental
$wgTiffUseTiffReader = false;
$wgTiffReaderPath = dirname( __FILE__ );
$wgTiffReaderCheckEofForJS = 4; // check the last 4MB for JS

// Path to identify
$wgImageMagickIdentifyCommand = '/usr/bin/identify';
// Use exiv2? if false, MediaWiki's internal EXIF parser will be used
$wgTiffUseExiv = false;
//path to tiffinfo
$wgTiffTiffinfoCommand = '/usr/bin/tiffinfo';
// Use tiffinfo? if false, ImageMagick's identify command will be used
$wgTiffUseTiffinfo = false;
// Path to vips
$wgTiffVipsCommand = '/usr/bin/vips';
// Use vips? if false, ImageMagick's convert command will be used
$wgTiffUseVips = false;
// Maximum number of embedded files in tiff image
$wgTiffMaxEmbedFiles = 10000;
// Maximum resolution of embedded images (product of width x height pixels)
$wgMaxImageAreaForVips = 1600*1600; // max. Resolution 1600 x 1600 pixels
// Maximum size of metadata
$wgTiffMaxMetaSize = 64*1024; 
// TTL of cache entries for errors
$wgTiffErrorCacheTTL = 24*60*60;

$wgFileExtensions[] = 'tiff';
$wgFileExtensions[] = 'tif';

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['PagedTiffHandler'] = $dir . 'PagedTiffHandler.i18n.php';
$wgExtensionMessagesFiles['PagedTiffHandlerMagic'] = $dir . 'PagedTiffHandler.i18n.magic.php';
$wgAutoloadClasses['PagedTiffImage'] = $dir . 'PagedTiffHandler.image.php';
$wgAutoloadClasses['PagedTiffHandler'] = $dir . 'PagedTiffHandler_body.php';
$wgAutoloadClasses['TiffReader'] = $dir . 'TiffReader.php';
$wgAutoloadClasses['PagedTiffHandlerSeleniumTestSuite'] = $dir . 'selenium/PagedTiffHandlerTestSuite.php';

$wgMediaHandlers['image/tiff'] = 'PagedTiffHandler';

define('TIFF_METADATA_VERSION', '1.4');
# 1.0: initial
# 1.1: fixed bugs in imageinfo parser
# 1.2: photoshop quirks (reverted)
# 1.3: handing extra IFDs reported by tiffinfo

//$wgHooks['PagedTiffHandlerRenderCommand'][] = 'PagedTiffHandler::renderCommand';
//$wgHooks['PagedTiffHandlerTiffData'][] = 'PagedTiffImage::tiffData';
//$wgHooks['PagedTiffHandlerExifData'][] = 'PagedTiffImage::exifData';

$wgHooks['ExtractThumbParameters'][] = 'PagedTiffHandler::onExtractThumbParameters';
