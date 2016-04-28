<?php

use Wikia\GlobalShortcuts\Helper;

class InsightsHooks {

	public static function init() {
		global $wgRequest;

		if ( !empty( $wgRequest->getVal( 'insights', null ) ) ) {
			Hooks::register( 'GetLocalURL', [ new self(), 'onGetLocalURL' ] );
		}
	}

	/**
	 * Check if article is in insights flow and init script to show banner with message and next steps
	 */
	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		global $wgEnableGlobalShortcutsExt;

		if ( !empty( $wgEnableGlobalShortcutsExt ) && Helper::shouldDisplayGlobalShortcuts() ) {
			\Wikia::addAssetsToOutput( 'insights_globalshortcuts_js' );
		}

		$subpage = $out->getRequest()->getVal( 'insights', null );

		// Load scripts for pages in insights loop
		if ( InsightsHelper::isInsightPage( $subpage ) ) {
			$out->addScriptFile('/extensions/wikia/InsightsV2/scripts/LoopNotification.js');
			$out->addScriptFile('/extensions/wikia/InsightsV2/scripts/InsightsLoopNotificationTracking.js');
		}

		return true;
	}

	/**
	 * Add insight param to keep information about flow after edit
	 */
	public static function onAfterActionBeforeRedirect( Article $article, &$sectionanchor, &$extraQuery ) {
		global $wgRequest;

		$subpage = $wgRequest->getVal( 'insights', null );

		if ( InsightsHelper::isInsightPage( $subpage ) ) {
			if ( !empty( $extraQuery ) ) {
				$extraQuery .= '&';
			}
			$extraQuery .= 'insights=' . $subpage;
		}

		return true;
	}

	/**
	 * Add insights param to edit page form to keep information about insights flow
	 */
	public static function onGetLocalURL( Title $title, &$url, $query ) {
		global $wgRequest;

		$subpage = $wgRequest->getVal( 'insights', null );

		if ( InsightsHelper::isInsightPage( $subpage ) ) {
			$action = $wgRequest->getVal( 'action', 'view' );
			if ( $action == 'edit'  && $query == 'action=submit' ) {
				$url .= '&insights=' . $subpage;
			}
		}

		return true;
	}

	/**
	 * Disable create new page popup and go directly to edit page to keep Insights flow
	 *
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript( Array &$vars ) {
		if ( F::app()->wg->title->isSpecial( 'Insights' ) ) {
			$vars['WikiaEnableNewCreatepage'] = false;
		}

		return true;
	}

	/**
	 * Add a right rail module to the Special:WikiActivity page
	 *
	 * @param array $railModuleList
	 * @return bool
	 */
	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgTitle, $wgUser;

		if ( ( $wgTitle->isSpecial( 'WikiActivity' ) && $wgUser->isLoggedIn() )
				|| ( $wgTitle->inNamespace( NS_MAIN ) && $wgUser->isPowerUser() )
		) {
			$railModuleList[1207] = [ 'InsightsModule', 'Index', null ];
		}

		return true;
	}

	/**
	 * Adds query page. Tie query page subclass with special page name.
	 * @param Array $wgQueryPages List of query pages: [ [ 'QueryPage subclass', 'SpecialPageName' ] ]
	 * @return bool
	 */
	public static function onwgQueryPages( Array &$wgQueryPages ) {
		global $wgEnableInsightsInfoboxes, $wgEnableTemplateClassificationExt,
			   $wgEnableInsightsPagesWithoutInfobox, $wgEnableInsightsPopularPages, $wgEnablePopularPagesQueryPage,
			   $wgEnableInsightsTemplatesWithoutType;

		if ( !empty( $wgEnableInsightsInfoboxes ) ) {
			$wgQueryPages[] = [ 'UnconvertedInfoboxesPage', 'Nonportableinfoboxes' ];
		}

		//TODO remove $wgEnablePopularPagesQueryPage variable after $wgEnableInsightsPopularPages is set to true
		if ( !empty( $wgEnableInsightsPopularPages ) || !empty( $wgEnablePopularPagesQueryPage ) ) {
			$wgQueryPages[] = [ 'PopularPages', 'Popularpages' ];
		}

		if ( !empty( $wgEnableTemplateClassificationExt ) ) {
			if ( !empty( $wgEnableInsightsPagesWithoutInfobox ) ) {
				$wgQueryPages[] = [ 'PagesWithoutInfobox', 'Pageswithoutinfobox' ];
			}

			if ( !empty( $wgEnableInsightsTemplatesWithoutType ) ) {
				$wgQueryPages[] = [ 'TemplatesWithoutTypePage', 'Templateswithouttype' ];
			}
		}

		return true;
	}

	/**
	 * Purge memcache with insights articles after updating special pages task is done
	 *
	 * @param  QueryPage $queryPage
	 * @return bool
	 */
	public static function onAfterUpdateSpecialPages( $queryPage ) {
		$queryPageName = strtolower( $queryPage->getName() );

		$model = InsightsHelper::getInsightModel( $queryPageName );

		if ( $model instanceof InsightsQueryPageModel && $model->purgeCacheAfterUpdateTask() ) {
			( new InsightsCache( $model->getConfig() ) )->purgeInsightsCache();
			$insightsContext = new InsightsContext( $model );
			$insightsContext->getContent();
		}

		return true;
	}


	public static function onTemplateClassified( $pageId, Title $title, $templateType ) {
		if ( !RecognizedTemplatesProvider::isUnrecognized( $templateType ) ) {
			$model = new InsightsTemplatesWithoutTypeModel();
			$model->removeFixedItem( TemplatesWithoutTypePage::TEMPLATES_WITHOUT_TYPE_TYPE, $title );
			( new InsightsCache( $model->getConfig() ) )->updateInsightsCache( $pageId );
		}
		return true;
	}

}
