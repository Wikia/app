<?php
/**
 * Support MediaWiki: http://www.mediawiki.org/.
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */


$dir = dirname( __FILE__ );
$wgAutoloadClasses['MediaWikiMessageChecker'] = dirname( __FILE__ ) . '/Checker.php';