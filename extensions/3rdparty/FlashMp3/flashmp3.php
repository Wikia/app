<?php
 
/*******************************************************************************
*                                                                              *
* FlashMP3 Extension by Matthias Korn to embed a flash player with mp3-files   *
* http://www.mediawiki.org/wiki/Extension:FlashMP3                             *
*                                                                              *
* This extension uses the Audio Player Wordpress plugin from 1pixelout         *
* Download and unpack files audio-player.js and player.swf to your             *
* extensions/audio_player folder                                               *
*                                                                              *
*   http://www.1pixelout.net/code/audio-player-wordpress-plugin/               *
*                                                                              *
* Tag :                                                                        *
*   <flashmp3>mp3</flashmp3>                                                   *
*                                                                              *
* Example :                                                                    *
*   with a local file                                                          *
*   <flashmp3>music.mp3</flashmp3>                                             *
*                                                                              *
* Example :                                                                    *
*   with a remote file                                                         *
*   <flashmp3>http://www.somedomain.com/mp3/music.mp3</flashmp3>               *
*                                                                              *
********************************************************************************/
 
$wgExtensionFunctions[] = 'wfFlashMP3';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'FlashMP3',
        'description' => 'Plays mp3-files in an embedded Flash-player',
        'author' => 'Matthias Korn',
        'url' => 'http://www.mediawiki.org/wiki/Extension:FlashMP3',
        'version' => 'v0.91'
);
 
 
function wfFlashMP3() {
        global $wgParser;
        $wgParser->setHook('flashmp3', 'renderFlashMP3');
}
 
 
// The callback function for converting the input text to HTML output
function renderFlashMP3($input, $args) {
        global $wgExtensionsPath, $wgStyleVersion;
        $type = '1pixelout';
        $id = 1;
        $params = explode("|", htmlspecialchars($input));
        $files = explode(",", array_shift($params));
        $player_path = $wgExtensionsPath.'/3rdparty/FlashMp3/audio-player/';
 
        if (isset($args['type'])) {
           $type = $args['type'];
        }
 
        switch ($type) {
 
                        case 'lastfm':
 
                                // concat the parameter string
                                $typeParameter = array_shift($params);     // this is the resourceType
                                $param_string = implode('&amp;', $params);
                                if (!empty($param_string))
                                {
                                        $param_string = '&amp;'.$param_string;
                                }
 
                                // try to figure out the resourceType
                                $resourceTypes['artist']    =  6;
                                $resourceTypes['album']             =  8;
                                $resourceTypes['song']              =  9;
                                $resourceTypes['playlist']  = 10;
                                $resourceTypes['label']             = 10;
 
                                if (is_numeric($typeParameter))
                                {
                                        $resourceType = $typeParameter;
                                } else {
                                        $resourceType = $resourceTypes[$typeParameter];
                                }
 
                                // the resourceID to play (either from an artist, song, playlist, ...)
                                $resourceID = $files[0];
 
                                // setting default title and cover
                                if (strpos($param_string, 'restTitle=') === false)
                                {
                                        $restTitle = '&amp;restTitle=Default Title';      // TODO: you can set a default title here
                                }
                                if (strpos($param_string, 'albumArt=') === false)
                                {
                                        $albumArt = '&amp;albumArt=http://static.last.fm/depth/catalogue/noimage/cover_med.gif';  // TODO: you can set a default cover here
                                }
				else {
					$albumArt = '';
				}
 
                                $output = '<object width="340" height="123">'
                                        . '<param name="movie" value="http://static.last.fm/webclient/41/defaultEmbedPlayer.swf" />'
                                        . '<param name="FlashVars" value="viral=true&amp;lfmMode=playlist&amp;resourceID='.$resourceID.'&amp;resourceType='.$resourceType.$albumArt.$restTitle.$param_string.'" />'
                                        . '<param name="wmode" value="transparent" />'
                                        . '<embed src="http://static.last.fm/webclient/41/defaultEmbedPlayer.swf" width="340" '
                                        . '  FlashVars="viral=true&amp;lfmMode=playlist&amp;resourceID='.$resourceID.'&amp;resourceType='.$resourceType.$albumArt.$restTitle.$param_string.'"'
                                        . '  height="123" wmode="transparent" type="application/x-shockwave-flash" />'
                                        . '</object>';
 
                                break;
 
                        case '1pixelout':
                        default:
 
                        if (isset($args['id']) && preg_match('/^[a-z0-9]+$/iD', $args['id'])) {
                                $id = $args['id'];
                        }
 
                                // concat the file string for all files
                                $file_string = '';
                                $j = 0;
                                foreach ($files as $file)
                                {
                                        // get the intneral path if file is uploaded
                                        if (strpos($file, "http://") !== 0 && strpos($file, "https://") !== 0)
                                        {
                                                $file = getFlashMP3Title($file);    // get Wiki internal url
                                        }
 
                                        $file_string .= $file;
                                        if ($j < count($files)-1) $file_string .= ',';
                                        $j++;
                                }
 
                                // concat the parameter string
                                $param_string = implode('&amp;', $params);
                                if (!empty($param_string)) $param_string .= '&amp;';
 
                                $output = '<script language="JavaScript" src="'.$player_path.'audio-player.js?'.$wgStyleVersion.'"></script>'
                                        . '<object type="application/x-shockwave-flash" data="'.$player_path.'player.swf" id="audioplayer'.$id.'" height="24" width="290">'
                                        . '<param name="movie" value="'.$player_path.'player.swf">'
                                        . '<param name="FlashVars" value="playerID='.$id.'&amp;'.$param_string.'soundFile='.$file_string.'">'
                                        . '<param name="quality" value="high">'
                                        . '<param name="menu" value="false">'
                                        . '<param name="wmode" value="transparent">'
                                        . '</object>';
 
                                break;
        }
 
        return $output;
}
 
 
function getFlashMP3Title($file)
{
    $title = Title::makeTitleSafe("Image",$file);
    $img = new Image($title);
    $path = $img->getViewURL(false);
    return $path;
}
