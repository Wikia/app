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
		$this->tally = wfMessage( 'oasis-total-articles-mainpage' )
			->params( SiteStats::articles() )
			->parse();
	}
}
