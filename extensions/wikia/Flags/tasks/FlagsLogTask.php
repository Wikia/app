<?php
namespace Flags;

use Flags\Models\FlagType;
use Wikia\Tasks\Tasks\BaseTask;

class FlagsLogTask extends BaseTask {
	/**
	 * Task for adding logs about changed flags to Special:Log and Special:RecentChanges
	 * It adds one log per changed flag
	 *
	 * Task need to be run in wikia context (where flags were changed) to store in local logging table in DB -
	 * invoke ->wikiId( ... ) method before queuing task.
	 *
	 * @param array $flags list of flags changed, each item of that list is an array with flag fields as items
	 * @param int $pageId ID of article where flags were changed
	 * @param string $actionType Type of action performed on flag represented by constants in \FlagsApiController class
	 */
	public function logFlagChange( array $flags, $pageId, $actionType ) {
		global $wgCityId;

		foreach ( $flags as $i => $flag ) {
			$flagTypeId = $flag['flag_type_id'];
			$title = \Title::newFromID( $pageId );
			$flagType = new FlagType();
			$wikiaFlagTypes = $flagType->getFlagTypesForWikia( $wgCityId );

			/* Log info about changes */
			$log = new \LogPage( 'flags' );
			$log->addEntry( $actionType, $title, '', [ $wikiaFlagTypes[$flagTypeId]['flag_name'] ], $this->createdByUser() );
		}

	}
}
