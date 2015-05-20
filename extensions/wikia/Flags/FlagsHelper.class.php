<?php

namespace Flags;

use Flags\Views\FlagView;

class Helper {

	const FLAGS_INPUT_NAME_PREFIX = 'editFlags';
	const FLAGS_INPUT_NAME_CHECKBOX = 'checkbox';

	public function compareDataAndGetFlagsToChange( $currentFlags, $postData ) {
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
					 * Use a value from the form if it is provided
					 */
					$flagFromPost['params'][$paramName] = \Sanitizer::escapeHtmlAllowEntities( $postData[$key] );
				} else {
					/**
					 * Insert an empty string otherwise
					 */
					$flagFromPost['params'][$paramName] = '';
				}
			}
		}

		return $flagFromPost;
	}

	public function shouldDisplayFlags() {
		global $wgRequest;

		return !in_array(
			$wgRequest->getVal( 'action', 'view' ),
			[ 'edit', 'formedit' , 'history' ]
		);
	}

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

	private function sendGetFlagsForPageRequest( $pageId ) {
		$app = \F::app();
		return $app->sendRequest( 'FlagsController',
			'getFlagsForPage',
			[
				'pageId' => $pageId,
			]
		)->getData();
	}

	private function composeInputName( $flagTypeId, $field ) {
		return self::FLAGS_INPUT_NAME_PREFIX . ":{$flagTypeId}:" . $field;
	}
}
