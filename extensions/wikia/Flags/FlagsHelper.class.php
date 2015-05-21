<?php

/**
 * A helper class that contains various universal functions or helps clients to interact with Flags.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags;

use Flags\Views\FlagView;

class Helper {

	/**
	 * Strings used to parse the content of an array
	 * posted from an edit form for flags for a page
	 */
	const FLAGS_INPUT_NAME_PREFIX = 'editFlags';
	const FLAGS_INPUT_NAME_CHECKBOX = 'checkbox';

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
			$keyCheckbox = $this->composeInputName( $flagTypeId, self::FLAGS_INPUT_NAME_CHECKBOX );

			if ( !isset( $flag['flag_id'] ) && !isset( $postData[$keyCheckbox] ) ) {
				/**
				 * 1. The flag type DOES NOT have an instance on this page and WAS NOT posted - continue
				 */
				continue;

			} elseif ( !isset( $flag['flag_id'] ) && isset( $postData[$keyCheckbox] ) ) {
				/**
				 * 2. The flag type DOES NOT have an instance on this page and WAS posted - new flag
				 */
				$flagsToAdd[$flagTypeId] = $this->getFlagFromPostData( $flag, $postData );

			} elseif ( isset( $flag['flag_id'] ) && !isset( $postData[$keyCheckbox] ) ) {
				/**
				 * 3. The flag type HAS an instance on this page and WAS NOT posted - remove flag
				 */
				$flagsToRemove[] = $flag['flag_id'];

			} elseif ( $flag['flag_param_names'] !== null ) {
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
			'toAdd' => $flagsToAdd,
			'toRemove' => $flagsToRemove,
			'toUpdate' => $flagsToUpdate,
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

		if ( isset( $flag['flag_id'] ) ) {
			/**
			 * If the flag exists - use flag_id for update
			 */
			$flagFromPost['flag_id'] = $flag['flag_id'];
		} else {
			/**
			 * If the flag does not exist - use flag_type_id for insert
			 */
			$flagFromPost['flag_type_id'] = $flagTypeId;
		}

		/**
		 * Check if params should be posted
		 */
		if ( $flag['flag_params_names'] !== null ) {
			$flagFromPost['params'] = [];
			$paramNames = json_decode( $flag['flag_params_names'] );

			/**
			 * Check only for names of parameters defined in the flag_param_names field.
			 * This is a protection from users modifying names of parameters in the DOM.
			 */
			foreach ( $paramNames as $paramName ) {
				$key = $this->composeInputName( $flagTypeId, $paramName );
				if ( isset( $postData[$key] ) ) {
					/**
					 * Use a value from the form if it is provided.
					 * It will be escaped by default mechanism from FluentSQL.
					 */
					$flagFromPost['params'][$paramName] = $postData[$key];
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
	 * @return bool
	 */
	public function shouldDisplayFlags() {
		global $wgRequest;

		return !in_array(
			$wgRequest->getVal( 'action', 'view' ),
			[ 'edit', 'formedit' , 'history' ]
		);
	}

	/**
	 * A wrapper for a request to the FlagsController for flags for the given page
	 * that returns a wikitext string with calls to templates of the flags.
	 * @param int $pageId
	 * @return null|string
	 */
	public function getFlagsForPageWikitext( $pageId ) {
		$flags = $this->sendGetFlagsForPageRequest( $pageId );
		if ( !empty( $flags ) ) {
			$flagsWikitext = '';
			$flagView = new FlagView();
			foreach ( $flags as $flagId => $flag ) {
				$flagsWikitext .= $flagView->createWikitextCall( $flag['flag_view'], $flag['params'] );
			}
			return $flagsWikitext;
		}

		return null;
	}

	/**
	 * Sends a request to the FlagsController to get data on flags for the given page.
	 * @param int $pageId
	 * @return array
	 */
	private function sendGetFlagsForPageRequest( $pageId ) {
		$app = \F::app();
		return $app->sendRequest( 'FlagsController',
			'getFlagsForPage',
			[
				'pageId' => $pageId,
			]
		)->getData();
	}

	/**
	 * Composes the name of a flags edit form input from the $field parameter and a $flagTypeId
	 * @param int $flagTypeId
	 * @param string $field
	 * @return string
	 */
	private function composeInputName( $flagTypeId, $field ) {
		return self::FLAGS_INPUT_NAME_PREFIX . ":{$flagTypeId}:{$field}";
	}
}
