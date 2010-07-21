<?PHP
/**
* Config file...
* @filepath /extensions/awc/config/config.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();
//  This controls your forums Default Language
// Change the 'en' to what you need.
// Make sure you create a new language sheet in yout AdminCP before you change this.
define('awcs_forum_lang_default', 'en'); 
define('awcs_forum_convert_latin', false);

// Display the Forums Navagation menu automaticly in your Wiki's 'MediaWiki:Sidebar'
//  place <awc_forum_menu_tag> in your 'MediaWiki:Sidebar' and the forums menu will appear there...
// http://wiki.anotherwebcom.com/awc_forum_menu_tag
define('awcs_forum_nav_bar', true);


// Place Forum Menu at the top of your current menu or at the bottom
define('awcs_forum_nav_bar_top', true); // true = top, false = bottom


define('show_whos_here_in_WIKI', true);
define('awcs_forum_use_poll', true);
define('show_whos_use_wiki_tag', true);