<?php
/**
 * Controller for rail module containing page count tally and contribute button/dropdown
 * See VOLDEV-145 for details
 *
 * @author Cqm <cqm.fwd@gmail.com>
 */

class ContributeController extends WikiaController {
	/**
	 * Method for the contribute sidebar module
	 */
	public function index() {

		$sassUrl = 'skins/oasis/css/modules/ContributeModule.scss';
		$this->wg->Out->addStyle(
			AssetsManager::getInstance()->getSassCommonURL( $sassUrl )
		);

		$this->tally = wfMessage( 'oasis-total-articles-mainpage' )
			// for quick testing
			// ->params( '999999999' )
			->params( SiteStats::articles() )
			->parse();
	}
}
