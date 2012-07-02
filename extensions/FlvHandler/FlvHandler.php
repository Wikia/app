<?php

if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**
 * An image handler which adds support for Flash video (.flv) files.
 *
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:FlvHandler Documentation
 *
 * @author Adam Nielsen <malvineous@shikadi.net>
 * @copyright Copyright © 2009 Adam Nielsen
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// Extension credits that will show up on Special:Version
$wgExtensionCredits['media'][] = array(
	'path'         => __FILE__,
	'name'         => 'FLV Image Handler',
	'version'      => 'r4',
	'author'       => 'Adam Nielsen',
	'url'          => 'https://www.mediawiki.org/wiki/Extension:FlvHandler',
	'descriptionmsg' => 'flvhandler_desc'
);

// Register the media handler
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['FlvHandler'] = $dir . 'FlvHandler.i18n.php';
$wgAutoloadClasses['FlvImageHandler'] = $dir . 'FlvImageHandler.php';
$wgMediaHandlers['video/x-flv'] = 'FlvImageHandler';

// Commands to extract still frames out of the FLV files
$wgFLVConverters = array(
	'ffmpeg' => '$path/ffmpeg -i $input -ss 0 -vframes 1 -vcodec png -s $widthx$height -f image2 $output'
);
// Probe command (to get video width and height.)  'regex' is run over the
// command's output to get the dimensions.
$wgFLVProbes = array(
	'ffmpeg' => array(
		'cmd' => '$path/ffmpeg -i $input',
		'regex' => '/Stream.*Video.* (\d+)x(\d+),/'  // [1] == width, [2] == height
	)
);

// Pick one of the above as the converter to use
$wgFLVConverter = 'ffmpeg';

// If not in the executable PATH, specify
$wgFLVConverterPath = '';

// Path of Flash video playing applet
// Default value is $wgScriptPath . '/extensions/FlvHandler/flowplayer/flowplayer-3.0.3.swf'
$wgFlashPlayer = null;

// Minimum size for the flash player (width,height).  Used to make sure the
// controls don't get all squashed up on really small .flv movies.
$wgMinFLVSize = array( 250, 250 );

$wgHooks['ImageBeforeProduceHTML'][] = 'efFlvHandlerRender';

// Hook function called just before image code is displayed as HTML.  If the
// image is an FLV file, embed a flash player, otherwise ignore it and let
// the default MW code display the image.
function efFlvHandlerRender(&$skin, &$title, &$file, &$frameParams, &$handlerParams, &$time, &$res)
{
	global $wgMinFLVSize, $wgFlashPlayer, $wgScriptPath;

	// Ignore files that don't exist yet
	if (!$file) return true;

	// Ignore files/images that aren't Flash video
	if ($file->getMimeType() != 'video/x-flv') return true;

	// Ignore any .flv files that are thumbnails.  The image handler will pick
	// these up and render a still frame.
	if (isset($frameParams['thumbnail'])) return true;

	// Default address of Flash video playing applet
	if (empty($wgFlashPlayer)) $wgFlashPlayer = $wgScriptPath . '/extensions/FlvHandler/flowplayer/flowplayer-3.0.3.swf';

	$prefix = $postfix = '';
	if (!empty($frameParams['align'])) {
		switch ($frameParams['align']) {
			case 'center': $className = 'center'; break;
			case 'left': $className = 'floatleft'; break;
			case 'right': $className = 'floatright'; break;
			default: $className = 'floatnone'; break;
		}
		$prefix = '<div class="' . $className . '">';
		$postfix = '</div>';
	}

	if (!isset($handlerParams['width'])) $handlerParams['width'] = $file->getWidth(0);
	if (!isset($handlerParams['height'])) $handlerParams['height'] = $file->getHeight(0);
	
	if ($handlerParams['width'] < $wgMinFLVSize[0]) $handlerParams['width'] = $wgMinFLVSize[0];
	if ($handlerParams['height'] < $wgMinFLVSize[1]) $handlerParams['height'] = $wgMinFLVSize[1];
	
	$strURL = $file->getUrl();

	// Generate a "thumbnail" to display in the video window before the user
	// clicks the play button.
	$thumb = $file->transform($handlerParams);
	$strThumbURL = $thumb->getUrl();

	$strConfig = 'config={"playlist":[ {"url":"' . $strThumbURL . '", "autoPlay":true}, {"url":"' . $strURL . '","autoPlay":false,"fadeInSpeed":0} ] }';

	$s = <<<EOF
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="{$handlerParams['width']}" height="{$handlerParams['height']}">
		<param name="movie" value="{$wgFlashPlayer}" />
		<param name="allowfullscreen" value="true" />
		<param name="flashvars" value='{$strConfig}' />
		<embed type="application/x-shockwave-flash" width="{$handlerParams['width']}" height="{$handlerParams['height']}"
			allowfullscreen="true"
			src="{$wgFlashPlayer}"
			flashvars='{$strConfig}' />
	</object>
EOF;
	
	$res = str_replace("\n", ' ', $prefix . $s . $postfix);
	return false;
}
