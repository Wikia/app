<?php
/**
 * @author Markus Krötzsch
 *
 * An abstract query page base class that supports array-based
 * data retrieval instead of the SQL-based access used by MW.
 * @file
 * @ingroup SMW
 */

/**
 * Abstract base class for SMW's variant of the MW QueryPage.
 * Subclasses must implement getResults() and formatResult(), as
 * well as some other standard functions of QueryPage.
 * @ingroup SMW
 */
abstract class SMWQueryPage extends QueryPage {

	/**
	 * Implemented by subclasses to provide concrete functions.
	 */
	abstract function getResults( $requestoptions );

	/**
	 * Clear the cache and save new results
	 * @todo Implement caching for SMW query pages
	 */
	function recache( $limit, $ignoreErrors = true ) {
		/// TODO
	}

	function isExpensive() {
		return false; // Disables caching for now
	}

	function isSyndicated() {
		return false; // TODO: why not?
	}

	/**
	 * This is the actual workhorse. It does everything needed to make a
	 * real, honest-to-gosh query page.
	 * Alas, we need to overwrite the whole beast since we do not assume
	 * an SQL-based storage backend.
	 *
	 * @param $offset database query offset
	 * @param $limit database query limit
	 */
	function doQuery( $offset = false, $limit = false ) {
		global $wgOut, $wgContLang;

		$options = new SMWRequestOptions();
		$options->limit = $limit;
		$options->offset = $offset;
		$options->sort = true;
		$res = $this->getResults( $options );
		$num = count( $res );

		$sk = $this->getSkin();
		$sname = $this->getName();

		$wgOut->addHTML( $this->getPageHeader() );

		// if list is empty, show it
		if ( $num == 0 ) {
			$wgOut->addHTML( '<p>' . wfMessage( 'specialpage-empty' )->escaped() . '</p>' );
			return;
		}

		$top = wfShowingResults( $offset, $num );
		$wgOut->addHTML( "<p>{$top}\n" );

		// often disable 'next' link when we reach the end
		$atend = $num < $limit;

		$sl = wfViewPrevNext( $offset, $limit ,
			$wgContLang->specialPage( $sname ),
			wfArrayToCGI( $this->linkParameters() ), $atend );
		$wgOut->addHTML( "<br />{$sl}</p>\n" );
			
		if ( $num > 0 ) {
			$s = array();
			if ( ! $this->listoutput )
				$s[] = $this->openList( $offset );

			foreach ( $res as $r ) {
				$format = $this->formatResult( $sk, $r );
				if ( $format ) {
					$s[] = $this->listoutput ? $format : "<li>{$format}</li>\n";
				}
			}

			if ( ! $this->listoutput )
				$s[] = $this->closeList();
			$str = $this->listoutput ? $wgContLang->listToText( $s ) : implode( '', $s );
			$wgOut->addHTML( $str );
		}
		
		$wgOut->addHTML( "<p>{$sl}</p>\n" );
		
		return $num;
	}

    /**
     * Compatibility method to get the skin; MW 1.18 introduces a getSkin method in SpecialPage.
     *
     * @since 1.6
     *
     * @return Skin
     */
    public function getSkin() {
        if ( method_exists( 'SpecialPage', 'getSkin' ) ) {
            return parent::getSkin();
        } else {
            global $wgUser;
            return $wgUser->getSkin();
        }
    }

}
