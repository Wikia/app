<?php
/**
 * External image whitelist
 * Only allow external (hotlinked) images to be displayed when they match a regex on an on-wiki whitelist
 * Won't work with $wgAllowExternalImages set to true, but DOES work with $wgAllowExternalImagesFrom set
 * @license GPL
*/

if(!defined('MEDIAWIKI')) {
	echo "This file is an extension to the MediaWiki software and cannot be used standalone.";
	die(1);
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'External image whitelist',
	'author'         => 'Ryan Schmidt',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:External_image_whitelist',
	'version'        => '1.0',
	'description'    => 'Only allow external (hotlinked) images to be displayed when they match a regex on an on-wiki whitelist',
	'descriptionmsg' => 'externalimagewhitelist-desc',
);

$wgExtensionMessagesFiles['Extimgwl'] = dirname(__FILE__) . '/ExternalImageWhitelist.i18n.php';

$wgHooks['LinkerMakeExternalLink'][] = 'efExtImgWl';

//image extensions to check for
$wgExtImgWlExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'svg');

function efExtImgWl(&$url, &$text, &$html) {
	global $wgAllowExternalImages, $wgExtImgWlExtensions;
	
	if($wgAllowExternalImages)
		return true;
	$ext = implode('|', preg_replace('[^a-zA-Z0-9]', '', $wgExtImgWlExtensions));
	if(!preg_match('/\.'.$ext.'$/i', $url))
		return true;
	$whitelist = explode("\n", wfMsgForContent('external_image_whitelist'));
	foreach($whitelist as $entry) {
		$entry = trim($entry);
		if($entry == '')
			continue;
		if(strpos($entry, '#') === 0)
			continue;
		if(preg_match('/'.str_replace('/', '\\/', $entry).'/i', $url)) {
			$html = '<img src="'.$url.'" />';
			return false;
		}
	}
	return true;
}