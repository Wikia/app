<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension to show full screen maps
 *
 * @addtogroup Extensions
 *
 * @author Jens Frank <jeluf@gmx.de>
 * @copyright Copyright © 2007, Jens Frank
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfSpecialWikimaps';
$wgExtensionCredits['specialpage'][] = array(
        'name' => 'Wikimaps',
        'author' => 'Jens Frank',
        'url' => 'http://meta.wikimedia.org/wiki/Wikimaps',
        'description' => 'Show maps',
);

global $wgWikimapsMessages;
$wgWikimapsMessages = array();

if ( !function_exists( 'extAddSpecialPage' ) ) {
        require( dirname(__FILE__) . '/../ExtensionFunctions.php' );
}
extAddSpecialPage( dirname(__FILE__) . '/SpecialWikimaps_body.php', 'Wikimaps', 'Wikimaps' );

function wfSpecialWikimaps() {
        # Add messages
        global $wgMessageCache, $wgWikimapsMessages, $wgSpecialPages;
        foreach( $wgWikimapsMessages as $key => $value ) {
                $wgMessageCache->addMessages( $wgWikimapsMessages[$key], $key );
        }
#	print "<pre>"; print_r( $wgSpecialPages ); print "</pre>";
}
?>

