 <?php
 
 /**
  * SearchDigest
  *
  * A short description of the SearchDigest extention
  *
  * @author Lucas Garczewski <tor@wikia-inc.com>
  * @date 2011-08-03
  * @copyright Copyright (C) 2011 Wikia Inc.
  * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
  * @package MediaWiki
  */
 
 // Extension credits
 $wgExtensionCredits['other'][] = array(
		 'name' => 'SearchDigest',
		 'version' => '1.0',
		 'author' => array( '[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]' ),
		 'descriptionmsg' => 'searchdigest-desc',
		 );

$dir = dirname(__FILE__);

// Interface code
require_once("$dir/SearchDigest.php");

// autoloaded classes
$wgAutoloadClasses['SpecialSearchDigest'] = "$dir/SearchDigest.class.php";

// i18n
$wgExtensionMessagesFiles['SearchDigest'] = $dir.'/SearchDigest.i18n.php';

// register special page
$wgSpecialPages['SearchDigest'] = 'SpecialSearchDigest';
