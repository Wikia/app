<?php
/**
 * Contains class with job for rebuilding message index.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2011, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Job for rebuilding message index.
 *
 * @ingroup JobQueue
 */
class MessageIndexRebuildJob extends Job {

	/**
	 * @return MessageIndexRebuildJob
	 */
	public static function newJob() {
		$job = new self( Title::newMainPage() );
		return $job;
	}

	function __construct( $title, $params = array(), $id = 0 ) {
		parent::__construct( __CLASS__, $title, $params, $id );
	}

	function run() {
		MessageIndex::singleton()->rebuild();
	}
}
