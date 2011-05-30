<?php
/**
 * Contains class with filter to Special:RecentChanges to enable additional
 * filtering.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Adds a new filter to Special:RecentChanges which makes it possible to filter
 * translations away or show them only.
 */
class TranslateRcFilter {
	/**
	 * Default action for the filter: ('', 'only', 'filter', 'site')
	 */
	protected static $defaultAction = 'filter';

	/**
	 * Hooks SpecialRecentChangesQuery. See the hook documentation for
	 * documentation of the function parameters.
	 *
	 * Appends SQL filter conditions into $conds.
	 * @return \bool true
	 */
	public static function translationFilter( &$conds, &$tables, &$join_conds, $opts ) {
		global $wgRequest, $wgTranslateMessageNamespaces;

		$translations = $wgRequest->getVal( 'translations', self::$defaultAction );
		$opts->add( 'translations', self::$defaultAction );
		$opts->setValue( 'translations', $translations );

		$dbr = wfGetDB( DB_SLAVE );

		$namespaces = array();

		foreach ( $wgTranslateMessageNamespaces as $index ) {
			$namespaces[] = $index;
			$namespaces[] = $index + 1; // Talk too
		}

		if ( $translations === 'only' ) {
			$conds[] = 'rc_namespace IN (' . $dbr->makeList( $namespaces ) . ')';
			$conds[] = 'rc_title like \'%%/%%\'';
		} elseif ( $translations === 'filter' ) {
			$conds[] = 'rc_namespace NOT IN (' . $dbr->makeList( $namespaces ) . ')';
		} elseif ( $translations === 'site' ) {
			$conds[] = 'rc_namespace IN (' . $dbr->makeList( $namespaces ) . ')';
			$conds[] = 'rc_title not like \'%%/%%\'';
		}

		return true;
	}

	/**
	 * Hooks SpecialRecentChangesPanel. See the hook documentation for
	 * documentation of the function parameters.
	 *
	 * Adds a HTMl selector into $items
	 * @return \bool true
	 */
	public static function translationFilterForm( &$items, $opts ) {
		$opts->consumeValue( 'translations' );
		$default = $opts->getValue( 'translations' );

		$label = Xml::label( wfMsg( 'translate-rc-translation-filter' ), 'mw-translation-filter' );
		$select = new XmlSelect( 'translations', 'mw-translation-filter', $default );
		$select->addOption( wfMsg( 'translate-rc-translation-filter-no' ), '' );
		$select->addOption( wfMsg( 'translate-rc-translation-filter-only' ), 'only' );
		$select->addOption( wfMsg( 'translate-rc-translation-filter-filter' ), 'filter' );
		$select->addOption( wfMsg( 'translate-rc-translation-filter-site' ), 'site' );

		$items['translations'] = array( $label, $select->getHTML() );

		return true;
	}
}
