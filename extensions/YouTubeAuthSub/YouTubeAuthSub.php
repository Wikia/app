<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+
 * An extension that allows users to rate articles.
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @link http://www.wikihow.com/WikiHow:YouTubeAuthSub-Extension Documentation
 *
 *
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfYouTubeAuthSub';

$wgYTAS_UseClientLogin = true;

# Fill out if you are using $wgUseClientLogin
$wgYTAS_User = "";
$wgYTAS_Password = "";
$wgYTAS_DeveloperId = "";
$wgYTAS_DefaultCategory = false;

$wgYTAS_EnableLogging = true;
$wgYTAS_UseNamespace = true;

define ( 'NS_YOUTUBE' , 20);
define ( 'NS_YOUTUBE_TALK' , 21);

$wgExtensionCredits['other'][] = array(
	'name'           => 'YouTubeAuthSub',
	'svn-date' => '$LastChangedDate: 2008-05-06 13:59:58 +0200 (wto, 06 maj 2008) $',
	'svn-revision' => '$LastChangedRevision: 34306 $',
	'author'         => 'Travis Derouin',
	'description'    => 'Allows users to upload videos directly to YouTube through the wiki',
	'descriptionmsg' => 'youtubeauthsub-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:YouTubeAuthSub',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['YouTubeAuthSub'] = $dir . 'YouTubeAuthSub.i18n.php';
$wgAutoloadClasses['SpecialYouTubeAuthSub'] = $dir . 'YouTubeAuthSub_body.php';
$wgSpecialPages['YouTubeAuthSub'] = 'SpecialYouTubeAuthSub';

function wfYouTubeAuthSub() {
	global $wgYTAS_UseNamespace, $wgExtraNamespaces;

	$wgExtraNamespaces[NS_YOUTUBE] = "YouTube";
	$wgExtraNamespaces[NS_YOUTUBE_TALK] = "YouTube_talk";
}

function wfSpecialYouTubePost ($url, $content, $headers = null) {
	// Set the date of your post
	$issued=gmdate("Y-m-d\TH:i:s\Z", time());

	if ($headers == null)
	$headers  =  array( "Content-type: application/x-www-form-urlencoded" );

	// Use curl to post to your blog.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 4);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	$data = curl_exec($ch);

	if (curl_errno($ch)) {
		print curl_error($ch);
	}
	else {
		curl_close($ch);
	}

	// $data contains the result of the post...
	return $data;
}

function wfSpecialYouTubeGetCategories() {
	global $wgMemc;
	$key = wfMemcKey('youtube', 'authsub', 'cats');
	$cats =  $wgMemc->get( $key );
	if (!$cats) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://gdata.youtube.com/schemas/2007/categories.cat");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		$data =  curl_exec($ch);
		if (curl_errno($ch)) {
			print curl_error($ch);
		}
		else {
			curl_close($ch);
		}
		preg_match_all("/<atom:category term='([^']*)' label='([^']*)'>/", $data, $matches);
		$cats = "";
		for ($i = 0; $i < sizeof ($matches[1]) && $i < sizeof($matches[2]); $i++) {
			$cats .= "<OPTION VALUE='{$matches[1][$i]}'>{$matches[2][$i]}</OPTION>";
		}
		$wgMemc->set($key, $cats, 3600 * 24);
	}
	return $cats;
}
