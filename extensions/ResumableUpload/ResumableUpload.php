<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * @copyright Copyright © 2010 Mark A. Hershberger <mah@everybody.org>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Resumable Upload',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ResumableUpload',
	'author' => array( 'Mark A. Hershberger', 'Michael Dale' ),
	'descriptionmsg' => 'resumableupload-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ResumableUpload'] = $dir . 'ResumableUpload.i18n.php';
$wgAutoloadClasses['ApiResumableUpload'] = $dir . 'ApiResumableUpload.php';
$wgAutoloadClasses['ResumableUploadHandler'] = $dir . 'ResumableUploadHandler.php';

$wgAPIModules['resumableupload'] = 'ApiResumableUpload';

