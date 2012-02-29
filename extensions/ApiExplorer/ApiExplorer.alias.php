<?php
/**
 * Aliases for Special:404
 *
 * @file
 * @ingroup Extensions
 */

$specialPageAliases = array();

/** English (English) */
$specialPageAliases['en'] = array(
	'ApiExplorer' => array( 'ApiExplorer' ),
);

/**
 * Polish (Polski)
 */
$specialPageAliases['pl'] = array(
	'ApiExplorer' => array( 'Eksplorator API', 'ApiExplorer' )
);

/**
 * For backwards compatibility with MediaWiki 1.15 and earlier.
 */
$aliases =& $specialPageAliases;
