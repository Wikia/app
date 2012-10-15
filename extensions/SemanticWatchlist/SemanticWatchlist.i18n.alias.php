<?php

/**
 * Aliases for the special pages of the Semantic Watchlist extension.
 *
 * @file SemanticWatchlist.i18n.alias.php
 * @ingroup SemanticWatchlist
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$specialPageAliases = array();

/** English (English) */
$specialPageAliases['en'] = array(
	'SemanticWatchlist' => array( 'SemanticWatchlist' ),
	'WatchlistConditions' => array( 'WatchlistConditions' ),
);

/** Arabic (العربية) */
$specialPageAliases['ar'] = array(
	'SemanticWatchlist' => array( 'قائمة_مراقبة_سيمانتيك' ),
	'WatchlistConditions' => array( 'شروط_قائمة_المراقبة' ),
);

/** Dutch (Nederlands) */
$specialPageAliases['nl'] = array(
	'SemanticWatchlist' => array( 'SemantischeVolglijst' ),
	'WatchlistConditions' => array( 'Volglijstcondities' ),
);

/**
 * For backwards compatibility with MediaWiki 1.15 and earlier.
 */
$aliases =& $specialPageAliases;