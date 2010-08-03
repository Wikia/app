<?php
 /**
  *
  * Copyright (C) 2007 Martin Seidel (Xarax) <jodeldi@gmx.de>
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

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "PdfHandler extension";
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'PDF Handler',
	'svn-date' => '$LastChangedDate: 2008-12-25 01:29:44 +0100 (czw, 25 gru 2008) $',
	'svn-revision' => '$LastChangedRevision: 45011 $',
	'author' =>' Xarax',
	'description' => 'Handler for viewing PDF files in image mode',
	'descriptionmsg' => 'pdf-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:PdfHandler',
);

// External program requirements...
$wgPdfProcessor     = 'gs';
$wgPdfPostProcessor = 'convert';
$wgPdfInfo          = 'pdfinfo';

$wgPdfOutputExtension = "jpg";
$wgPdfHandlerDpi = 150;

// To upload new PDF files you'll need to do this too:
// $wgFileExtensions[] = 'pdf';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['PdfHandler'] = $dir . 'PdfHandler.i18n.php';
$wgAutoloadClasses['PdfImage'] = $dir . 'PdfHandler.image.php';
$wgAutoloadClasses['PdfHandler'] = $dir . 'PdfHandler_body.php';
$wgMediaHandlers['application/pdf'] = 'PdfHandler';
