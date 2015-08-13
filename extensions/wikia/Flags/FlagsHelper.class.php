<?php

/**
 * A helper class that contains various universal functions or helps clients to interact with Flags.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags;

use Flags\Models\FlagType;

class FlagsHelper {

	/**
	 * Strings used to parse the content of an array
	 * posted from an edit form for flags for a page
	 */
	const FLAGS_INPUT_NAME_PREFIX = 'editFlags';
	const FLAGS_INPUT_NAME_CHECKBOX = 'checkbox';
	const FLAGS_LOG_PREFIX = 'FlagsLog';

	/**
	 * Compares the data posted from the edit form with the database results.
	 * Extracts data on particular types of flags and decides if
	 * they should be skipped, added, updated or deleted.
	 * Returns an array with the possible following keys: `toAdd`, `toRemove` and `toUpdate`.
	 * @param array $currentFlags An array with the data retrieved from the database
	 * @param array $postData An array with the data posted from the form
	 * @return array
	 */
	public function compareDataAndGetFlagsToChange( Array $currentFlags, Array $postData ) {
		$flagsToAdd = $flagsToRemove = $flagsToUpdate = [];

		foreach ( $currentFlags as $flagTypeId => $flag ) {
			if ( !isset( $flag['flag_id'] ) && !isset( $postData[$flagTypeId][self::FLAGS_INPUT_NAME_CHECKBOX] ) ) {
				/**
				 * 1. The flag type DOES NOT have an instance on this page and WAS NOT posted - continue
				 */
				continue;

			} elseif ( !isset( $flag['flag_id'] ) && isset( $postData[$flagTypeId][self::FLAGS_INPUT_NAME_CHECKBOX] ) ) {
				/**
				 * 2. The flag type DOES NOT have an instance on this page and WAS posted - new flag
				 */
				$flagsToAdd[$flagTypeId] = $this->getFlagFromPostData( $flag, $postData );

			} elseif ( isset( $flag['flag_id'] ) && !isset( $postData[$flagTypeId][self::FLAGS_INPUT_NAME_CHECKBOX] ) ) {
				/**
				 * 3. The flag type HAS an instance on this page and WAS NOT posted - remove flag
				 */
				$flagsToRemove[$flag['flag_id']] = $flag; // Pass old flag data to enable logging it

			} elseif ( $flag['flag_params_names'] !== null ) {
				/**
				 * 4. The flag type HAS an instance on this page and WAS posted
				 * and HAS parameters - update the parameters of the instance.
				 * If the flag type has no parameters defined - there is nothing to update
				 * because the form only allows you to modify parameters.
				 */
				$flagsToUpdate[$flag['flag_id']] = $this->getFlagFromPostData( $flag, $postData );
			}
		}

		return [
			\FlagsController::FLAGS_CONTROLLER_ACTION_ADD => $flagsToAdd,
			\FlagsController::FLAGS_CONTROLLER_ACTION_REMOVE => $flagsToRemove,
			\FlagsController::FLAGS_CONTROLLER_ACTION_UPDATE => $flagsToUpdate,
		];
	}

	/**
	 * Retrieves data on the flag for INSERT or UPDATE actions
	 * @param array $flag Data on the flag from the database
	 * @param array $postData Data on the flag from the edit form
	 * @return array
	 */
	public function getFlagFromPostData( $flag, $postData ) {
		$flagTypeId = $flag['flag_type_id'];

		$flagFromPost = [];

		/**
		 * flag_id is used for update
		 */
		$flagFromPost['flag_id'] = isset( $flag['flag_id'] ) ? $flag['flag_id'] : null;
		/**
		 * flag_type_id is used for insert
		 */
		$flagFromPost['flag_type_id'] = $flagTypeId;

		$flagFromPost['params'] = [];

		/**
		 * Check if params should be posted
		 */
		if ( $flag['flag_params_names'] !== null ) {
			$paramNames = json_decode( $flag['flag_params_names'] );

			/**
			 * Check only for names of parameters defined in the flag_param_names field.
			 * This is a protection from users modifying names of parameters in the DOM.
			 */
			foreach ( $paramNames as $paramName => $paramDescription ) {
				if ( isset( $postData[$flagTypeId][$paramName] ) ) {
					/**
					 * Use a value from the form if it is provided.
					 * It will be escaped by default mechanism from FluentSQL.
					 */
					$flagFromPost['params'][$paramName] = $postData[$flagTypeId][$paramName];
				} else {
					/**
					 * Insert an empty string if a value is not provided.
					 */
					$flagFromPost['params'][$paramName] = '';
				}
			}
		}

		return $flagFromPost;
	}

	/**
	 * Checks if a request for flags does not come from an edit page
	 * Used for determining whether flags should be injected to parsed output
	 * @return bool
	 */
	public function shouldInjectFlags() {
		global $wgTitle, $wgRequest;

		return
			/* Don't display flags when parsing message (wgTitle doesn't exist then) */
			$wgTitle instanceof \Title
			/* Display flags only on content namespaces */
			&& \Wikia::isContentNamespace()
			/* Don't display flags on edit pages that are content namespaces */
			&& !in_array(
				$wgRequest->getVal( 'action', 'view' ),
				[ 'edit', 'formedit' , 'history', 'visualeditor' ]
			);
	}

	/**
	 * Checks if flags should be displayed on a page
	 * @return bool
	 */
	public function shouldDisplayFlags() {
		global $wgTitle;

		return
			/* Don't display flags for non existent pages */
			$wgTitle->exists()
			/* Display flags only on content namespaces */
			&& \Wikia::isContentNamespace();
	}

	/**
	 * Checks if flags can be edited on current page to decide whether include edit modal
	 * @return bool
	 */
	public function areFlagsEditable() {
		global $wgHideFlagsExt, $wgTitle;
		return
			/* Should signs of Flags extension be hidden? */
			$wgHideFlagsExt !== true
			/* Check condition for view */
			&& $this->shouldDisplayFlags()
			/* Don't display flags when user is not allowed to edit */
			&& $wgTitle->userCan( 'edit' );
	}

	/**
	 * Get a localized and human-readable names of Flags targets (readers and contibutors)
	 *
	 * @return array An array of localized names of targets of Flags
	 */
	public static function getFlagTargetFullNames() {
		$flagTargetFullNames = [];

		/**
		 * Generates the following messages:
		 * flags-target-readers
		 * flags-target-contributors
		 */
		foreach ( FlagType::$flagTargeting as $flagTargetId => $flagTargetKey ) {
			$flagTargetFullNames[$flagTargetId] = [
				'name' => wfMessage( "flags-target-{$flagTargetKey}" )->escaped(),
				'value' => $flagTargetId
			];
		}

		return $flagTargetFullNames;
	}

	/**
	 * Get a localized and human-readable names of Flags groups
	 *
	 * @return array An array of localized names of groups of Flags
	 */
	public static function getFlagGroupsFullNames() {
		$flagGroupsFullNames = [];
		/**
		 * Generates the following messages:
		 * flags-groups-spoiler
		 * flags-groups-disambig
		 * flags-groups-canon
		 * flags-groups-stub
		 * flags-groups-delete
		 * flags-groups-improvements
		 * flags-groups-status
		 * flags-groups-navigation
		 * flags-groups-other
		 */
		foreach ( FlagType::$flagGroups as $flagGroupId => $flagGroupKey ) {
			$flagGroupsFullNames[$flagGroupId] = [
				'name' => wfMessage( "flags-groups-{$flagGroupKey}" )->escaped(),
				'value' => $flagGroupId
			];
		}
		return $flagGroupsFullNames;
	}
}
