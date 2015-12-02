<?php
namespace Flags;

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
		$app = \F::app();
		$wikiaFlagTypesResponse = $app->sendRequest(
			'FlagsApiController',
			'getFlagTypes',
			[],
			true,
			\WikiaRequest::EXCEPTION_MODE_RETURN
		);
		$wikiaFlagTypes = $wikiaFlagTypesResponse->getData();

		if ( $wikiaFlagTypes['status'] === true ) {
			foreach ( $flags as $i => $flag ) {
				$flagTypeId = $flag['flag_type_id'];
				$title = \Title::newFromID( $pageId );

				/* Log info about changes */
				$log = new \LogPage( 'flags' );
				$log->addEntry(
					$actionType,
					$title,
					'',
					[ $wikiaFlagTypes['data'][$flagTypeId]['flag_name'] ],
					$this->createdByUser()
				);
			}
		} else {
			$this->error( "No flags types found for wikia (city_id:{$this->getWikiId()})" );
		}

	}

	/**
	 * Adds logs if parameters in flags were changed
	 *
	 * @param Array $oldFlags old flags values
	 * @param Array $flags new flags values
	 * @param $pageId
	 */
	public function logParametersChange( Array $oldFlags, Array $flags, $pageId ) {
		if ( $oldFlags['status'] === true ) {
			foreach ( $flags as $i => $flag ) {
				$title = \Title::newFromID( $pageId );
				$log = new \LogPage( 'flags' );

				if ( !empty( $oldFlags['data'][$flag['flag_type_id']]['flag_params_names'] ) ) {
					$this->logParameters( $oldFlags['data'][$flag['flag_type_id']], $flag, $log, $title );
				}
			}
		} else {
			$this->error( "No flags found for page (city_id:{$this->getWikiId()}; page_id:{$pageId})" );
		}

	}

	private function logParameters( $oldFlag, $newFlag, $log, $title ) {
		$paramNames = json_decode( $oldFlag['flag_params_names'] );

		foreach ( $paramNames as $paramName => $paramDescription ) {
			$addToLog = false;
			if ( !empty( $oldFlag['params'][$paramName] ) ) {
				if ( empty( $newFlag['params'][$paramName] ) ) {
					// parameter was removed
					$addToLog = true;
					$actionType = 'flag-parameter-removed';
					$logParams = [
						'flag_name' => $oldFlag['flag_name'],
						'param_name' => $paramName,
						'old_value' => $oldFlag['params'][$paramName],
						'new_value' => ''
					];
				} elseif ( $oldFlag['params'][$paramName] !== $newFlag['params'][$paramName] ) {
					// parameter was modified
					$addToLog = true;
					$actionType = 'flag-parameter-modified';
					$logParams = [
						'flag_name' => $oldFlag['flag_name'],
						'param_name' => $paramName,
						'old_value' => $oldFlag['params'][$paramName],
						'new_value' => $newFlag['params'][$paramName]
					];
				}
			} elseif ( empty( $oldFlag['params'][$paramName] ) && !empty( $newFlag['params'][$paramName] ) ) {
				// parameter was added
				$addToLog = true;
				$actionType = 'flag-parameter-added';
				$logParams = [
					'flag_name' => $oldFlag['flag_name'],
					'param_name' => $paramName,
					'old_value' => '',
					'new_value' => $newFlag['params'][$paramName]
				];
			}

			if ( $addToLog ) {
				$log->addEntry(
					$actionType,
					$title,
					'',
					$logParams,
					$this->createdByUser()
				);
			}
		}
	}
}
