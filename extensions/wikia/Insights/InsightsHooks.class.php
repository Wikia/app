<?php

class InsightsHooks {

	/**
	 * Check if article is in insights flow and init script to show banner with message and next steps
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		global $wgRequest;

		$subpage = $wgRequest->getVal( 'insights', null );

		// Load scripts for pages in insights loop
		if ( InsightsHelper::isInsightPage( $subpage ) ) {
			$out->addScriptFile('/extensions/wikia/Insights/scripts/LoopNotification.js');
		}

		// Load scripts for pages in insights loop and Special:Insights
		if ( InsightsHelper::isInsightPage( $subpage ) || F::app()->wg->title->isSpecial( 'Insights' ) ) {
			$out->addScriptFile( '/extensions/wikia/Insights/scripts/Insights.run.js' );
			$out->addScriptFile( '/extensions/wikia/Insights/scripts/LoopTracking.js' );
		}

		return true;
	}

	/**
	 * Add insight param to keep information about flow after edit
	 */
	public static function AfterActionBeforeRedirect( Article $article, &$sectionanchor, &$extraQuery ) {
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
	public static function onGetLocalURL( &$this, &$url, $query ) {
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

		if ( $wgTitle->isSpecial( 'WikiActivity' ) && $wgUser->isPowerUser() ) {
			$railModuleList[1501] = [ 'InsightsModule', 'Index', null ];
		}

		return true;
	}
} 
