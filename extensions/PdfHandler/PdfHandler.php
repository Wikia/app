<?php
/**
 * PDF Handler extension -- handler for viewing PDF files in image mode.
 *
 * @file
 * @ingroup Extensions
 * @author Martin Seidel (Xarax) <jodeldi@gmx.de>
 * @copyright Copyright © 2007 Martin Seidel (Xarax) <jodeldi@gmx.de>
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
	echo 'PdfHandler extension';
	exit( 1 );
}

$wgExtensionCredits['media'][] = array(
	'path' => __FILE__,
	'name' => 'PDF Handler',
	'author' => array( 'Martin Seidel', 'Mike Połtyn'),
	'descriptionmsg' => 'pdf-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PdfHandler',
);

// External program requirements...
$wgPdfProcessor     = 'gs';
$wgPdfPostProcessor = 'convert';
$wgPdfInfo          = 'pdfinfo';
$wgPdftoText        = 'pdftotext';

$wgPdfOutputExtension = 'jpg';
$wgPdfHandlerDpi = 150;

// This setting, if enabled, will put creating thumbnails into a job queue,
// so they do not have to be created on-the-fly,
// but rather inconspicuously during normal wiki browsing
// if setting to true, make sure to migrate CreatePdfThumbnailsJob to PdfHandlerTask!
$wgPdfCreateThumbnailsInJobQueue = false;

// To upload new PDF files you'll need to do this too:
// $wgFileExtensions[] = 'pdf';

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['PdfHandler'] = $dir . 'PdfHandler.i18n.php';
$wgAutoloadClasses['PdfImage'] = $dir . 'PdfHandler.image.php';
$wgAutoloadClasses['PdfHandler'] = $dir . 'PdfHandler_body.php';
$wgAutoloadClasses['CreatePdfThumbnailsJob'] = $dir . 'CreatePdfThumbnailsJob.class.php';
$wgAutoloadClasses['PdfHandlerTask'] = $dir . 'PdfHandlerTask.class.php';
$wgMediaHandlers['application/pdf'] = 'PdfHandler';
$wgJobClasses['createPdfThumbnailsJob'] = 'CreatePdfThumbnailsJob';
$wgHooks['UploadVerifyFile'][] = function($upload, $mime, &$error) {
	global $wgPdfCreateThumbnailsInJobQueue;
	if ( !$wgPdfCreateThumbnailsInJobQueue ) {
		return true;
	}
	if (!MimeMagic::singleton()->isMatchingExtension('pdf', $mime)) {
		return true; // not a PDF, abort
	}

	if (TaskExecutors::isModern('CreatePdfThumbnailsJob')) {
		return PdfHandlerTask::onUploadVerifyFile($upload, $mime, $error);
	} else {
		return CreatePdfThumbnailsJob::insertJobs($upload, $mime, $error);
	}
};
