<?php
/**
 * Given a username returns a list of IP addresses that user has made edits to
 * the wiki from, listing one time per IP which is the latest edit from that
 * address.
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 */

if (!defined('MEDIAWIKI'))
	die;

if ( !function_exists( 'extAddSpecialPage' ) ) {
	require( dirname(__FILE__) . '/../ExtensionFunctions.php' );
}
extAddSpecialPage( dirname(__FILE__) . '/Userip_body.php', 'Espionage', 'Espionage' );


