<?php

/**
 * Base class for classes `SubPageList' and `SubPageCount'. Contains code common for both
 * descendants.
 *
 * @since 0.6
 *
 * @file SubPageCount.class.php
 * @ingroup SPL
 *
 * @licence GNU GPL v3 or later
 *
 * @author Jeroen De Dauw
 * @author Van de Bugger
 * @author James McCormack (email: user "qedoc" at hotmail); preceding version Martin Schallnahs <myself@schaelle.de>, original Rob Church <robchur@gmail.com>
 * @copyright © 2008 James McCormack, preceding version Martin Schallnahs, original Rob Church
 */
abstract class SubPageBase extends ParserHook {

	/**
	 * Returns the title for which subpages should be fetched.
	 *
	 * @since 0.1
	 *
	 * @param string $page — Name of page.
	 *
	 * @return Instance of Title class — title of an existing page, or integer — index of an
	 * existing namespace, or null otherwise.
	 */
	protected function getTitle( $page ) {
		global $wgContLang;

		$title = null;

		if ( $page == '' ) {
			$title = $this->parser->mTitle;
		} else {
			$title = Title::newFromText( $page );
			if ( is_null( $title ) ) {
				// It is a wrog page name. Probably it is a namespace name?
				$m = array();
				if ( preg_match( '/^\s*(.*):\s*$/', $page, $m ) ) {
					$title = $wgContLang->getNsIndex( $m[ 1 ] );
				}
			} elseif ( ! $title->exists() ) {
				$title = null;
			}
		}

		return $title;
	}

	/**
	 * Returns condition array suitable for `select' or `estimateRowCount'.
	 *
	 * @since 0.6
	 *
	 * @param $title — Either page title (Title instance) or namespace (integer). Do not pass null.
	 *
	 * @param $kidsOnly — Boolean. If true, only direct subpages are included.
	 *
	 * @return array — Conditions or `null' if something is wrong (e. g. subpages are not enabled
	 *     in this namespace or page does not exits).
	 */
	protected function getConditions( $title, $kidsOnly ) {

		if ( is_null( $title ) ) {
			// Just in case. If `getTitle' returns `null' it means page does not exist.
			return null;
		}
		$dbr = wfGetDB( DB_SLAVE );
		$conditions = array();
		$conditions['page_is_redirect'] = 0;
		if ( $title instanceof Title ) {
			if ( ! MWNamespace::hasSubpages( $title->getNamespace() ) ) {
				// Subpages are not enabled in this namespace. If we return empty array such a
				// condition will meet all the pages, so let us return `null' istead to signal
				// result is not valid.
				return null;
			}
			$conditions['page_namespace'] = $title->getNamespace(); // Don't let list cross namespaces.
			// TODO: this is rather resource heavy
			$conditions[] = 'page_title ' . $dbr->buildLike( $title->getDBkey() . '/', $dbr->anyString() );
			if ( $kidsOnly ) {
				$conditions[] = 'page_title NOT ' . $dbr->buildLike( $title->getDBkey() . '/', $dbr->anyString(), '/', $dbr->anyString() );
			}
		} else {
			// `$title' is namespace index.
			$conditions['page_namespace'] = $title;
			if ( $kidsOnly && MWNamespace::hasSubpages( $title ) ) {
				// Requested only "root" pages, not subpages.
				$conditions[] = 'page_title NOT ' . $dbr->buildLike( $dbr->anyString(), '/', $dbr->anyString() );
			} else {
				// Subpages requested for namespace: not just direct kids or namespace does not have
				// subpages => we should return *all* the pages in namespace => condition is not
				// needed.
			}
		}
		return $conditions;
	} // getConditions

} // class SubPageBase
