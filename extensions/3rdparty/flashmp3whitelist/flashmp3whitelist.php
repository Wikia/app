<?php

/*******************************************************************************
*                                                                              *
* flashmp3whitelist Extension by jabrwocky7 to embed a flash player with       *
* with mp3-files that are hosted externally.  This extension uses a whitelist  *
* to check if the domain is allowed to be used.                                *
*                                                                              *
* This extension uses the Audio Player Wordpress plugin from 1pixelout         *
* Download and unpack files audio-player.js and player.swf to your             *
* extensions/audio_player folder                                               *
*                                                                              *
*   http://www.1pixelout.net/code/audio-player-wordpress-plugin/               *
*                                                                              *
*  license http://www.gnu.org/licenses/gpl-3.0.html GNU GPLv3                  *
*                                                                              *
* Tag :                                                                        *
*   <mp3 url="http://foo.com/bar.mp3" />                                       *
*                                                                              *
* Whitelist:                                                                   *
*   Add allowed domains to [[MediaWiki:Flashmp3whitelist-domains]]             *
********************************************************************************/
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgHooks['ParserFirstCallInit'][] = 'wfflashmp3whitelist';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'flashmp3whitelist',
        'description' => 'Plays remote mp3 files in an embedded Flash-player.  Uses a whitelist to allow remote domains.',
        'author' => '[http://lostpedia.wikia.com/wiki/User:jabrwocky7 Jabrwocky7]',
        'url' => 'http://lostpedia.wikia.com/wiki/User:jabrwocky7/Extension:FlashMP3Whitelist',
        'version' => 'v0.10'
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['flashmp3whitelist'] = $dir . 'flashmp3whitelist.i18n.php';

function wfflashmp3whitelist( $parser ) {
        $parser->setHook('mp3', 'renderflashmp3whitelist');
        return true;
}

// The callback function for converting the input text to HTML output
function renderflashmp3whitelist($input, $params) {
        global $wgExtensionsPath, $wgStyleVersion;

        $domainwhitelist = explode("\n",trim(wfMsg ( 'flashmp3whitelist-domains' )));

        $id = 1;
        $player_path = $wgExtensionsPath.'/3rdparty/flashmp3whitelist/audio-player/';

	$url = htmlspecialchars($params['url']);
        if ($url==null) {
          $output = wfMsg ( 'flashmp3whitelist-no-URL' );
          return $output;
        }

        $domain = parse_url($url, PHP_URL_HOST);

        if (in_array($domain,$domainwhitelist)==FALSE) {
          $output = wfMsg ( 'flashmp3whitelist-not-in-whitelist', $domain );
          return $output;
        }

        $output = '<script type="text/javascript" language="JavaScript" src="'.$player_path.'audio-player.js?'.$wgStyleVersion.'"></script>'
                    . '<object type="application/x-shockwave-flash" data="'.$player_path.'player.swf" id="audioplayer'.$id.'" height="24" width="290">'
                    . '<param name="movie" value="'.$player_path.'player.swf">'
                    . '<param name="FlashVars" value="playerID='.$id.'&'.'soundFile='.$url.'">'
                    . '<param name="quality" value="high">'
                    . '<param name="menu" value="false">'
                    . '<param name="wmode" value="transparent">'
                    . '</object>';
        return $output;

}
