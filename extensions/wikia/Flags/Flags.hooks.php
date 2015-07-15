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
		if ( $helper->shouldDisplayFlags() ) {
			\Wikia::addAssetsToOutput( 'flags_view_scss' );
		}
		/* Assets for flags edit form */
		if ( $helper->areFlagsEditable() ) {
			\Wikia::addAssetsToOutput( 'flags_editform_js' );
			$out->addModules( 'ext.wikia.Flags.EditFormMessages' );
		}

		if ( $out->getTitle()->isSpecial( 'Flags' ) ) {
			\Wikia::addAssetsToOutput( 'flags_special_scss' );
			\Wikia::addAssetsToOutput( 'flags_special_js' );
		}

		if ( $skin->getTitle()->getNamespace() === NS_TEMPLATE ) {
			self::showFlagsNotification( $skin->getTitle()->getBaseText() );
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
	 * @param \Page $article
	 * @return bool
	 */
	public static function onBeforeParserCacheSave( \ParserOutput $parserOutput, \Page $article ) {
		if ( ! \FlagsController::$parsed ) {
			$parserOutput = ( new \FlagsController )
				->modifyParserOutputWithFlags( $parserOutput, $article->getID() );
		}

		return true;
	}

	/**
	 * Modifies ParserOutput
	 * @param \LinksUpdate $linksUpdate
	 * @return bool
	 */
	public static function onLinksUpdate( \LinksUpdate $linksUpdate ) {
		$linksUpdate->mParserOutput = ( new \FlagsController )
			->modifyParserOutputWithFlags(
				$linksUpdate->getParserOutput(),
				$linksUpdate->getTitle()->getArticleID()
			);

		return true;
	}

	/**
	 * @param \ParserOutput $parserOutput
	 * @param \Title $title
	 * @return bool
	 */
	public static function onArticlePreviewAfterParse( \ParserOutput $parserOutput, \Title $title ) {
		$parserOutput = ( new \FlagsController )
			->modifyParserOutputWithFlags( $parserOutput, $title->getArticleID() );

		return true;
	}

	public static function onLinksUpdateInsertTemplates( $pageId, Array $templates ) {
		$app = \F::app();

		if ( !empty( $templates ) && $app->wg->HideFlagsExt !== true ) {
			$flagTypesResponse = $app->sendRequest( 'FlagsApiController',
				'getFlagsForPageForEdit',
				[
					'wiki_id' => $app->wg->CityId,
					'page_id' => $pageId,
				]
			)->getData();

			if ( $flagTypesResponse[\FlagsApiController::FLAGS_API_RESPONSE_STATUS] ) {
				$flagTypesToExtract = $flagTypesToExtractNames = [];

				/**
				 * We need modified versions of names of templates and flag_view values to
				 * compare in a case-insensitive and space-underscore-insensitive way.
				 */
				$templatesKeys = [];
				foreach ( $templates as $template ) {
					$templatesKeys[] = strtolower( $template['tl_title'] );
				}

				foreach ( $flagTypesResponse[\FlagsApiController::FLAGS_API_RESPONSE_DATA] as $flagType ) {
					if ( isset( $flagType['flag_id'] ) ) {
						continue;
					}

					$flagViewKey = strtolower( str_replace( ' ', '_', $flagType['flag_view'] ) );
					if ( in_array( $flagViewKey, $templatesKeys ) ) {
						$flagTypesToExtract[$flagType['flag_view']] = $flagType;
					}
				}

				if ( !empty( $flagTypesToExtract ) ) {
					$task = new FlagsExtractTemplatesTask();
					$task->wikiId( $app->wg->CityId );
					$task->call( 'extractTemplatesFromPage', $pageId, $flagTypesToExtract );
					$task->prioritize();
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

	/**
	 * @param Array $preloads
	 * @param Title $title
	 * @return bool
	 */

	public static function onEditPageLayoutShowIntro( &$preloads, \Title $title ) {

		if( $title->getNamespace() === NS_TEMPLATE ) {
			$app = \F::app();
			$response = $app->sendRequest( 'FlagsApiController',
				'getFlagTypeIdByTemplate',
				[
					'flag_view' => $title->getBaseText()
				]
			)->getData();

			if ( $response['status'] ) {
				$preloads['EditPageFlagsIntro'] = [
					'content' => wfMessage( 'flags-edit-intro-notification' )->parse(),
				];
			}
		}
		return true;
	}

	/**
	 * Adds banner notification on view page if template is mapped as a Flag.
	 * @param $templateName
	 * @return bool
	 */

	public static function showFlagsNotification( $templateName ) {
		$app = \F::app();
		$response = $app->sendRequest( 'FlagsApiController',
			'getFlagTypeIdByTemplate',
			[
				'flag_view' => $templateName
			]
		)->getData();

		if ( $response['status'] ) {
			\BannerNotificationsController::addConfirmation(
				wfMessage( 'flags-edit-intro-notification' )->parse(),
				\BannerNotificationsController::CONFIRMATION_NOTIFY
			);
		}
		return true;
	}
}
