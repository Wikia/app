<?php
/* This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

# Only execute extension through MediaWiki
if ( !defined( 'MEDIAWIKI' ) ) die();

# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'wfHiscores';
$wgExtensionCredits['parserhook'][] = array(
    'name' => 'RSHiscores',
    'version' => '2.0.3',
    'description' => 'A parser function returning raw player data from RuneScape\'s Hiscores Lite',
    'url' => 'http://runescape.wikia.com/wiki/User:Catcrewser/RSHiscores',
    'author' => '[http://runescape.wikia.com/wiki/User_talk:Catcrewser TehKittyCat]'
);

# Set limit to prevent abuse, defaults to two, which allows for comparison of hiscore data
if( !isset( $wgRSLimit ) ) $wgRSLimit = 2;
$wgRSTimes = 0;

# Cache of hiscore fetches
$wgRSHiscoreCache = array();

# Initialise the parser function
$wgHooks['LanguageGetMagic'][] = 'wfHiscores_Magic';

# Setup parser function 
function wfHiscores( &$parser ) {
    $parser->setFunctionHook( 'hs', 'wfHiscores_Render' );
	 return true;
}

# Parser function
function wfHiscores_Magic( &$magicWords ) {
    $magicWords['hs'] = array( 0, 'hs' );
    return true;
}

#Skills: 0-Overall(Default), 1-Attack, 2-Defence, 3-Constitution/Hitpoints, 5-Ranged, 6-Prayer, 7-Magic, 8-Cooking, 9-Woodcutting, 10-Fletching, 11-Fishing,
# 12-Firemaking, 13-Crafting, 14-Smithing, 15-Mining, 16-Herblore, 17-Agility, 18-Thieving, 19-Slayer, 20-Farming, 21-Runecrafting, 22-Hunter,
# 23-Construction, 24-Summoning, 25-Duel Tournament, 26-Bounty Hunter, 27-Bounty Hunter Rogue, 28-Fist of Guthix, 29-Mobilising Armies,
# 30-B.A. Attacker, 31-B.A. Defender, 32-B.A. Collector, 33-B.A. Healer
#Types: 0-Rank, 1-Level(Default), 2-Experience

# Function for the parser function
function wfHiscores_Render( &$parser, $player = '', $skill = 0, $type = 1 ) {
    global $wgRSch, $wgRSHiscoreCache, $wgRSLimit, $wgRSTimes, $wgHTTPTimeout;
    $player = trim( $player );
    if( $player == '' ) {
    	return 0;
    } elseif( array_key_exists( $player, $wgRSHiscoreCache ) ) {
        $data = $wgRSHiscoreCache[$player];
        $data = explode( "\n", rtrim($data), $skill+2 );
        if( !array_key_exists( $skill, $data ) ) return 4;
        $data = explode( ',', $data[$skill], $type+2 );
        if( !array_key_exists( $type, $data ) ) return 5;
        return $data[$type];
    } elseif( $wgRSTimes < $wgRSLimit || $wgRSLimit == 0 ) {
        $wgRSTimes++;
        if( !isset( $wgRSch ) ) {
	        # Setup cURL
			$wgRSch = curl_init();
			curl_setopt( $wgRSch, CURLOPT_TIMEOUT, $wgHTTPTimeout );
			curl_setopt( $wgRSch, CURLOPT_RETURNTRANSFER, TRUE );
	    }
        curl_setopt( $wgRSch, CURLOPT_URL, 'http://services.runescape.com/m=hiscore/index_lite.ws?player='.urlencode( $player ) );
        if( $data = curl_exec( $wgRSch ) ) {
        	$wgRSHiscoreCache[$player] = $data;
            $status = curl_getinfo( $wgRSch, CURLINFO_HTTP_CODE );
            if( $status == 200 ) {
            	$data = $wgRSHiscoreCache[$player];
		        $data = explode( "\n", $data, $skill+2 );
		        if( !array_key_exists( $skill, $data ) ) return 4;
		        $data = explode( ',', $data[$skill], $type+2 );
		        if( !array_key_exists( $type, $data ) ) return 5;
		        return $data[$type];
            } elseif( $status == 404 ) {
                return $wgRSHiscoreCache[$player] = 1;
            }
        }
        return $wgRSHiscoreCache[$player] = 2;
    } else {
        return 3;
    }
}
## If 0 is returned, then no name was entered.(Enter a username!)
## If 1 is returned, then the player could not be found.(HTTP 404)
## If 2 is returned, then an error occurred.(Any response or lack there of HTTP 200/404)
## If 3 is returned, then the hiscores parser function limit was reached.(By default one, configurable with $wgRSLimit, limit is not affected by same username used repeatedly)
## If 4 is returned, then the skill does not exist.
## If 5 is returned, then the type does not exist.
## If anything else if returned, then it worked and that is the hiscores data.(Yay!)
