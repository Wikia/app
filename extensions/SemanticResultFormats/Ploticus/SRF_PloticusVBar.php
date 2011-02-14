<?php
/**
 * A query printer using Ploticus drawing vertical bars.
 * loosely based on the Ploticus Extension by Flavien Scheurer
 * and CSV result printer
 *
 * @note AUTOLOADED
 * @author Joel Natividad
 * @author Denny Vrandecic
 */

/**
 * Result printer using Ploticus to plot vertical bars.
 * TODO: Create expanded doxygen comments
 *
 * @ingroup SMWQuery
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

include_once( "SRF_Ploticus.php" );

/**
 * This class only specifies the the SRFPloticus superclass. Since the
 * current working of the SRFPloticus class is unsafe, this specialization
 * filters out this unsecure parameter passing (and the power of Ploticus)
 * and allows only for vertical bars.
 */
class SRFPloticusVBar extends SRFPloticus {

	protected function readParameters( $params, $outputmode ) {
		SRFPloticus::readParameters( $params, $outputmode );

		// All other options will be simply ignored;
		$this->m_ploticusmode === 'prefab';
		$this->m_ploticusparams = "-prefab vbars x=1 y=2";
	}

}