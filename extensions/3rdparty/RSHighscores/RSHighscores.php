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
    'version' => '2.0.7',
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

/**
 * Setup parser function
 *
 * @param Parser $parser
 * @return bool
 */
function wfHiscores( &$parser ) {
    $parser->setFunctionHook( 'hs', 'wfHiscores_Render' );
     return true;
}

# Parser function
function wfHiscores_Magic( &$magicWords ) {
    $magicWords['hs'] = array( 0, 'hs' );
    return true;
}

# Skills:
#  0-Overall(Default), 1-Attack, 2-Defence, 3-Strength, 4-Constitution(formerly Hitpoints),
#  5-Ranged, 6-Prayer, 7-Magic, 8-Cooking, 9-Woodcutting,
#  10-Fletching, 11-Fishing, 12-Firemaking, 13-Crafting, 14-Smithing,
#  15-Mining, 16-Herblore, 17-Agility, 18-Thieving, 19-Slayer,
#  20-Farming, 21-Runecrafting, 22-Hunter, 23-Construction, 24-Summoning,
#  25-Dungeoneering, 26-Divination,
# Activities:
#  27-Bounty Hunter, 28-Bounty Hunter Rogue, 29-Dominion Tower, 30-The Crucible, 31-Castle Wars Games,
#  32-B.A. Attackers, 33-B.A. Defenders, 34-B.A. Collectors, 35-B.A. Healers, 36-Duel Tournament,
#  37-Mobilising Armies, 38-Conquest, 39-Fist of Guthix, 40-GG: Resource Race, 41-GG: Athletics,
#  42-WE2: Armadyl Lifetime Contribution, 43-WE2: Bandos Lifetime Contribution, 44-WE2: Armadyl PvP Kills, 45-WE2: Bandos PvP Kills,
#  46-Heist Guard Level, 47-Heist Robber Level, 48-CFP: 5 Game Average
# Types:
#  0-Rank, 1-Level/Score(Default), 2-Experience

# Function for the parser function
function wfHiscores_Render( &$parser, $player = '', $skill = 0, $type = 1, $debug = false ) {
    global $wgRSch, $wgRSHiscoreCache, $wgRSLimit, $wgRSTimes, $wgHTTPTimeout;
    if( $debug != '!' ) {
	    $player = trim( $player );
	    if( $player == '' ) {
	        return 'A'; # No (display)name entered
	    } elseif( array_key_exists( $player, $wgRSHiscoreCache ) ) {
	        $data = $wgRSHiscoreCache[$player];
	        # Check to see if an error has already occurred, if so then return the error, otherwise will return wrong error and waste a bit of resource.
	        # Checks first char as some errors have integer statuses.
	        if( ctype_alpha ( $data{0} ) ) return $data;
	        $data = explode( "\n", rtrim($data), $skill+2 );
	        if( !array_key_exists( $skill, $data ) ) return 'F'; # Non-existant skill
	        $data = explode( ',', $data[$skill], $type+2 );
	        if( !array_key_exists( $type, $data ) ) return 'G'; # Non-existant type
	        return $data[$type];
	    } elseif( $wgRSTimes < $wgRSLimit || $wgRSLimit == 0 ) {
	        $wgRSTimes++;
	        if( !isset( $wgRSch ) ) {
	            # Setup cURL
	            $wgRSch = curl_init();
	            curl_setopt( $wgRSch, CURLOPT_TIMEOUT, $wgHTTPTimeout );
	            curl_setopt( $wgRSch, CURLOPT_RETURNTRANSFER, TRUE );
	        }
	        # Other known working URL: 'http://hiscore.runescape.com/index_lite.ws?player='
	        curl_setopt( $wgRSch, CURLOPT_URL, 'http://services.runescape.com/m=hiscore/index_lite.ws?player='.urlencode( $player ) );
	        if( $data = curl_exec( $wgRSch ) ) {
	            $wgRSHiscoreCache[$player] = $data;
	            $status = curl_getinfo( $wgRSch, CURLINFO_HTTP_CODE );
	            if( $status == 200 ) {
	                $data = $wgRSHiscoreCache[$player];
	                $data = explode( "\n", $data, $skill+2 );
	                if( !array_key_exists( $skill, $data ) ) return 'F'; # Non-existant skill
	                $data = explode( ',', $data[$skill], $type+2 );
	                if( !array_key_exists( $type, $data ) ) return 'G'; # Non-existant type
	                return $data[$type];
	            } elseif( $status == 404 ) {
	                return $wgRSHiscoreCache[$player] = 'B'; # Non-existant player
	            }
	            # Unexpected HTTP status code
	            return $wgRSHiscoreCache[$player] = 'D'.$status;
	        }
	        # An unhandled curl error occurred, report it.
	        $errno = curl_errno ( $wgRSch );
	        if( $errno ) {
	            return $wgRSHiscoreCache[$player] = 'C'.$errno;
	        }
	        # Should be impossible, but odd things happen, so handle it.
	        return $wgRSHiscoreCache[$player] = 'C';
	    } else {
	        return 'E'; # Parser function limit reached.
	    }
    } else {
    	curl_setopt( $wgRSch, CURLOPT_URL, 'http://services.runescape.com/m=hiscore/index_lite.ws?player='.urlencode( $player ) );
    	if( $data = curl_exec( $wgRSch ) ) {
    		$ret = 'H'.$data.'D,'.$wgRSLimit.','.$wgHTTPTimeout.','.curl_getinfo( $wgRSch, CURLINFO_HTTP_CODE ).','.curl_getinfo( $wgRSch, CURLINFO_TOTAL_TIME ).
    		','.curl_getinfo( $wgRSch, CURLINFO_NAMELOOKUP_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_CONNECT_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_PRETRANSFER_TIME ).
    		','.curl_getinfo( $wgRSch, CURLINFO_STARTTRANSFER_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_SPEED_DOWNLOAD ).','.curl_getinfo( $wgRSch, CURLINFO_SPEED_UPLOAD );
    	} else {
    		$ret = 'H'.curl_errno ( $wgRSch ).'E,'.$wgRSLimit.','.$wgHTTPTimeout.','.curl_getinfo( $wgRSch, CURLINFO_HTTP_CODE ).','.curl_getinfo( $wgRSch, CURLINFO_TOTAL_TIME ).
    		','.curl_getinfo( $wgRSch, CURLINFO_NAMELOOKUP_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_CONNECT_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_PRETRANSFER_TIME ).
    		','.curl_getinfo( $wgRSch, CURLINFO_STARTTRANSFER_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_SPEED_DOWNLOAD ).','.curl_getinfo( $wgRSch, CURLINFO_SPEED_UPLOAD );
    	}
    	curl_setopt( $wgRSch, CURLOPT_URL, 'http://www.google.com/' );
    	if( curl_exec( $wgRSch ) ) {
    		$ret .= 'G'.curl_getinfo( $wgRSch, CURLINFO_HTTP_CODE ).','.curl_getinfo( $wgRSch, CURLINFO_TOTAL_TIME ).
    		','.curl_getinfo( $wgRSch, CURLINFO_NAMELOOKUP_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_CONNECT_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_PRETRANSFER_TIME ).
    		','.curl_getinfo( $wgRSch, CURLINFO_STARTTRANSFER_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_SPEED_DOWNLOAD ).','.curl_getinfo( $wgRSch, CURLINFO_SPEED_UPLOAD );
    	} else {
    		$ret .= 'G'.curl_errno ( $wgRSch ).'E,'.curl_getinfo( $wgRSch, CURLINFO_HTTP_CODE ).','.curl_getinfo( $wgRSch, CURLINFO_TOTAL_TIME ).
    		','.curl_getinfo( $wgRSch, CURLINFO_NAMELOOKUP_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_CONNECT_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_PRETRANSFER_TIME ).
    		','.curl_getinfo( $wgRSch, CURLINFO_STARTTRANSFER_TIME ).','.curl_getinfo( $wgRSch, CURLINFO_SPEED_DOWNLOAD ).','.curl_getinfo( $wgRSch, CURLINFO_SPEED_UPLOAD );
    	}
    	return $ret;
    }
}
## If A is returned, then no (display)name was entered.(Enter a username!)
## If B is returned, then the player could not be found.(HTTP 404)
## If C is returned, then an unknown error occurred.(Any response or lack there of HTTP 200/404)
## If C<#> is returned, then an unexpected error occurred, see the curl error codes for more information.(http://curl.haxx.se/libcurl/c/libcurl-errors.html)
## If D<#> is returned, then an unexpected HTTP status was returned, see the HTTP status codes for more information.(http://en.wikipedia.org/wiki/List_of_HTTP_status_codes)
## If E is returned, then the hiscores parser function limit was reached.(By default one, configurable with $wgRSLimit, limit is not affected by same username used repeatedly)
## If F is returned, then the skill does not exist.
## If G is returned, then the type does not exist.
## If H<*> is returned, then this is debug mode.
## If anything else if returned, then it worked and that is the hiscores data.(Yay!)
