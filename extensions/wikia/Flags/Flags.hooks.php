<?php

/**
 * A class that contains all methods that are hooked to events occurring in the stack.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags;

class Hooks {

	const FLAGS_DROPDOWN_ACTION = 'flags';

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$helper = new FlagsHelper();
		/* Assets for flags view */
		if ( $helper->shouldDisplayFlags()
			|| $out->getTitle()->isSpecial( 'Flags' ) ) {
			\Wikia::addAssetsToOutput( 'flags_view_scss' );
		}
		/* Assets for flags edit form */
		if ( $helper->areFlagsEditable() ) {
			\Wikia::addAssetsToOutput( 'flags_editform_js' );
			$out->addModules( 'ext.wikia.Flags.EditFormMessages' );
		}
		return true;
	}

	/**
	 * Adds flags item to edit button dropdown. Flags item shows modal for editing flags for article.
	 * This is attached to the MediaWiki 'SkinTemplateNavigation' hook.
	 *
	 * @param SkinTemplate $skin
	 * @param array $links Navigation links
	 * @return bool true
	 */
	public static function onSkinTemplateNavigation( $skin, &$links ) {
		$helper = new FlagsHelper();
		if ( $helper->areFlagsEditable() ) {
			$links['views'][self::FLAGS_DROPDOWN_ACTION] = [
				'href' => '#',
				'text' => wfMessage( 'flags-edit-modal-title' )->escaped(),
				'class' => 'flags-access-class',
			];
		}
		return true;
	}

	/**
	 * Adds flags action to dropdown actions to enable displaying flags item on edit dropdown
	 * @param array $actions
	 * @return bool true
	 */
	public static function onPageHeaderDropdownActions( array &$actions ) {
		$helper = new FlagsHelper();
		if ( $helper->areFlagsEditable() ) {
			$actions[] = self::FLAGS_DROPDOWN_ACTION;
		}
		return true;
	}

	/**
	 * Modifies the original ParserOutput object using the one returned from FlagView.
	 * The modification
	 * @param \ParserOutput $parserOutput
	 * @param \Article $article
	 * @return bool
	 */
	public static function onBeforeParserCacheSave( \ParserOutput $parserOutput, \Article $article ) {
		$parserOutput = ( new \FlagsController )
			->modifyParserOutputWithFlags( $parserOutput, $article );

		return true;
	}

	public static function onLinksUpdateInsertTemplates( $pageId, Array $templates ) {
		global $wgHideFlagsExt;

		if ( $wgHideFlagsExt !== true ) {
			$app = \F::app();
			$flagTypesResponse = $app->sendRequest( 'FlagsApiController',
				'getFlagTypes',
				[
					'wiki_id' => $app->wg->CityId,
				]
			)->getData();

			if ( $flagTypesResponse[\FlagsApiController::FLAGS_API_RESPONSE_STATUS] ) {
				$flagTypesToExtract = $flagTypesToExtractNames = [ ];
				foreach ( $flagTypesResponse[\FlagsApiController::FLAGS_API_RESPONSE_DATA] as $flagType ) {
					if ( isset( $templates[$flagType['flag_view']] ) ) {
						$flagTypesToExtract[$flagType['flag_view']] = $flagType;
					}
				}

				if ( !empty( $flagTypesToExtract ) ) {
					$task = new FlagsExtractTemplatesTask();
					$task->wikiId( $app->wg->CityId );
					$task->call( 'extractTemplatesFromPage', $pageId, $flagTypesToExtract );
					$task->queue();

					\BannerNotificationsController::addConfirmation(
						wfMessage( 'flags-notification-templates-extraction' )
							->params( implode( ', ', array_keys( $flagTypesToExtract ) ) )
							->parse(),
						\BannerNotificationsController::CONFIRMATION_WARN,
						true
					);
				}
			}
		}

		return true;
	}
}
