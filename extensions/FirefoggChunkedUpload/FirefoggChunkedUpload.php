<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * @copyright Copyright © 2010 Mark A. Hershberger <mah@everybody.org>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'FirefoggChunkedUpload',
	'url' => 'http://www.mediawiki.org/wiki/Extension:FirefoggChunkedUpload',
	'author' => array( 'Mark A. Hershberger' ),
	'descriptionmsg' => 'firefoggcu-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['FirefoggChunkedUpload'] = $dir . 'FirefoggChunkedUpload.i18n.php';
$wgAutoloadClasses['ApiFirefoggChunkedUpload'] = $dir . 'ApiFirefoggChunkedUpload.php';
$wgAutoloadClasses['FirefoggChunkedUploadHandler'] = $dir . 'FirefoggChunkedUploadHandler.php';

$wgAPIModules['firefoggupload'] = 'ApiFirefoggChunkedUpload';
