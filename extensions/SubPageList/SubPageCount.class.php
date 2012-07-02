<?php 

/**
 * CLass to render the sub page count.
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
final class SubPageCount extends SubPageBase {
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */
	public static function staticInit( Parser &$wgParser ) {
		$instance = new self;
		return $instance->init( $wgParser );
	}

	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 *
	 * @since 0.6
	 *
	 * @return string
	 */
	protected function getName() {
		return array( 'subpagecount' );
	}

	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 *
	 * @since 0.6
	 *
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		$params = array();
		$params['page'] = new Parameter(
			'page',
			Parameter::TYPE_STRING,
			'',
			array( 'parent' )    // Aliases.
		);
		$params['page']->setMessage( 'spl-subpages-par-page' );
		$params['kidsonly'] = new Parameter(
			'kidsonly',
			Parameter::TYPE_BOOLEAN,
			'no'
		);
		$params['kidsonly']->setMessage( 'spl-subpages-par-kidsonly' );
		return $params;
	}

	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 *
	 * @since 0.6
	 *
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array( 'page' );
	}

	/**
	 * Renders and returns the output.
	 * @see ParserHook::render
	 *
	 * @since 0.6
	 *
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function render( array $parameters ) {
		$count = '';
		$title = $this->getTitle( $parameters['page'] );
		// TODO: Return an error message instead of empty string?
		if ( is_null( $title ) ) {
			return $count;
		}
		$conds = $this->getConditions( $title, $parameters['kidsonly'] );
		if ( is_null( $conds ) ) {
			return $count;
		}
		/*
			The code below is borrowed from `Database::estimateRowCount'. It works for MySQL, not
			yet tested with other databases. For unknown reason, `DatabaseMysql::estimateRowCount'
			does not work as expected. It returns number of subpages, direct and indirect,
			regardless of parameter `kidsonly'.
		*/
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page', 'COUNT(*) AS rowcount', $conds, __METHOD__ );
		if ( ! $res ) {
			return $count;
		}
		$row = $dbr->fetchRow( $res );
		$count = ( isset( $row['rowcount'] ) ? $row['rowcount'] : 0 );
		return $count;
	} // render

}

// end of file //
