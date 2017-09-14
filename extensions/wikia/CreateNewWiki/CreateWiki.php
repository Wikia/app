<?php
/**
 * CreateWiki class
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia Inc.
 * @author Adrian Wieczorek <adi@wikia-inc.com> for Wikia Inc.
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia Inc.
 * @copyright © 2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

use Wikia\CreateNewWiki\Tasks;
use Wikia\CreateNewWiki\Tasks\TaskContext;

class CreateWiki {

	use \Wikia\Logger\Loggable;

	private $taskContext;

	public function __construct( $name, $domain, $language, $vertical, $categories ) {
		$this->taskContext = TaskContext::newFromUserInput( $name, $domain, $language, $vertical, $categories );
	}

	/**
	 * Add more context to messages sent to LogStash
	 *
	 * @return array
	 */
	protected function getLoggerContext() {
		return Tasks\TaskHelper::getLoggerContext( $this->taskContext );
	}

	public function getSiteName() {
		return $this->taskContext->getSiteName();
	}

	public function getCityId() {
		return $this->taskContext->getCityId();
	}

	/**
	 * main entry point, create wiki with given parameters
	 *
	 * @throw CreateWikiException an exception with status of operation set
	 */
	public function create() {
		wfProfileIn( __METHOD__ );

		$taskRunner = new Wikia\CreateNewWiki\Tasks\TaskRunner( $this->taskContext );

		$taskRunner->prepare();

		$taskRunner->check();

		$taskRunner->run();

		wfProfileOut( __METHOD__ );
	}
}
