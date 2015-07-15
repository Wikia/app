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

use Flags\Models\FlagParameter;

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
	 * Check if saved template is one of flag type,
	 * and should update flag parameters if template variables have changed
	 *
	 * @return bool
	 */
	public static function onArticleSaveComplete( &$article, &$user, $text, $summary,
			$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId
	) {
		if ( $article->mTitle->getNamespace() === NS_TEMPLATE ) {
			$app = \F::app();

			$flagTypesResponse = $app->sendRequest(
				'FlagsApiController', 'getFlagTypes', [ 'wiki_id' => $app->wg->CityId ]
			)->getData();

			// Get flag types
			if ( $flagTypesResponse[\FlagsApiController::FLAGS_API_RESPONSE_STATUS] ) {
				$flagsTypes = $flagTypesResponse[\FlagsApiController::FLAGS_API_RESPONSE_DATA];
				$templateName = $article->mTitle->getText();

				foreach ( $flagsTypes as $flagType ) {
					// Check if saved template is one of the flags
					if ( $flagType['flag_view'] === $templateName ) {
						$prevRevision = $revision->getPrevious( true );
						if ( is_null( $prevRevision ) ) {
							return true;
						}

						$oldText = $prevRevision->getRawText();

						// if template text has changed
						if ( strcmp( $text, $oldText ) !== 0 ) {
							if ( is_null( $flagType['flag_params_names'] ) ) {
								$flagVariables = [];
							} else {
								$flagVariables = json_decode( $flagType['flag_params_names'], true );
							}

							$flagParamsDiff = ( new FlagsParamsComparison() )->compareTemplateVariables(
								$article->mTitle,
								$oldText,
								$text,
								$flagVariables
							);

							if ( !is_null( $flagParamsDiff ) ) {
								$flagParamsNames = !empty( $flagParamsDiff['params'] )
										? json_encode( $flagParamsDiff['params'] )
										: null;

								$response = $app->sendRequest(
									'FlagsApiController',
									'updateFlagTypeParameters',
									[
										'flag_type_id' => $flagType['flag_type_id'],
										'flag_params_names' => $flagParamsNames
									],
									true,
									\WikiaRequest::EXCEPTION_MODE_RETURN
								)->getData();

								if ( !empty( $response['status'] ) ) {
									$flagParameters = new FlagParameter();

									if ( !empty( $flagParamsDiff['changed'] ) ) {
										foreach ( $flagParamsDiff['changed'] as $changed ) {
											$flagParameters->updateParameterNameForFlag(
												$flagType['flag_type_id'],
												$changed['old'],
												$changed['new']
											);
										}
									}
								}
							}
						}

						break;
					}
				}
			}
		}
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
	 *
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
