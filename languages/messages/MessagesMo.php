<?php
/** Moldavian (Молдовеняскэ)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Comp1089
 * @author Node ue
 * @author לערי ריינהארט
 */

$fallback = 'ro';

$specialPageAliases = array(
	'CreateAccount'             => array( 'КреареКонт' ),
	'Preferences'               => array( 'Преферинце' ),
	'Recentchanges'             => array( 'Модификэрьреченте' ),
);

$pluralRules = [
	"i = 1 and v = 0",
	"v != 0 or n = 0 or n != 1 and n % 100 = 1..19",
];
