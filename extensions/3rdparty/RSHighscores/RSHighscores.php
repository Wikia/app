<?php
/**
 *
 * This program is free software: you can redistribute it and/or modify
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
 *
 * Contributors: [http://runescape.wikia.com/wiki/User_talk:Catcrewser TehKittyCat]
 *
 */
 
# Only execute extension through MediaWiki
if (!defined( 'MEDIAWIKI')) die();

# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'wfHighscores';
$wgExtensionCredits['parserhook'][] = array(
    'path' => __FILE__,
    'name' => 'RSHighscores',
    'version' => '0.2.2',
    'description' => 'A parser function which returns raw player data from RuneScape Highscores Lite',
    'url' => 'http://runescape.wikia.com/wiki/User:Catcrewser/RSHighscores',
    'author' => '[http://runescape.wikia.com/wiki/User:Catcrewser TehKittyCat]'
);

# Set limit to prevent abuse
if(!isset($wgRSLimit)) $wgRSLimit = 1;
$wgRSTimes = 0;

# Initialise the parser function
$wgHooks['LanguageGetMagic'][] = 'wfHighscores_Magic';

# Setup parser function 
function wfHighscores(&$parser) {
    $parser->setFunctionHook('highscores', 'wfHighscores_Render');
	 return true;
}

# Parser function
function wfHighscores_Magic(&$magicWords) {
    $magicWords['highscores'] = array(0, 'highscores');
    return(true);
}

# Function for the parser function
function wfHighscores_Render(&$parser, $player = '') {
    global $wgRSTimes,$wgRSLimit;
    if($wgRSTimes<$wgRSLimit || $wgRSLimit==0) {
        $wgRSTimes++;
        if($player!='') {
            $data = Http::get('http://services.runescape.com/m=hiscore/index_lite.ws?player='.urlencode($player),$info);
            if($data===false) {
    			return(0);
            } elseif($info['response_code']==404) {
                return(2);
            } else {
                return($data);
            }
        } else {
            return(1);
        }
    } else {
        return(0);
    }
}
## Possible return values
# 0 = Could not connect
# 1 = No player name
# 2 = Player does not exist
# Anything else is the highscores data
