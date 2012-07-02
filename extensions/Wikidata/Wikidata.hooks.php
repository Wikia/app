<?php

class WikidataHooks {

	public static function onBeforePageDisplay( $out, $skin ) {
		global $wgLang, $wgScriptPath, $wgRequest, $wgResourceModules;

		if ( $wgLang->isRTL() ) {
			$out->addModules( 'ext.Wikidata.rtl' );
		} else {
			$out->addModules( 'ext.Wikidata' );
		}

		if ( $wgRequest->getText( 'action' )=='edit' ) {
			$out->addModules( 'ext.Wikidata.edit' );
			$out->addModules( 'ext.Wikidata.suggest' );
		}

		if ( $skin->getTitle()->isSpecialPage() ) {
			$out->addModules( 'ext.Wikidata.suggest' );
		}
		return true;
	}

	private static function isWikidataNs( $title ) {
		global $wdHandlerClasses;
		return array_key_exists( $title->getNamespace(), $wdHandlerClasses );
	}

	/**
	 * Purpose: Add custom tabs
	 *
	 * When editing in read-only data-set, if you have the copy permission, you can
	 * make a copy into the designated community dataset and edit the data there.
	 * This is accessible through an 'edit copy' tab which is added below.
	 *
	 * @param $skin Skin as passed by MW
	 * @param $tabs as passed by MW
	 */
	public static function onSkinTemplateTabs( $skin, $content_actions ) {
		global $wgUser, $wgCommunity_dc, $wdShowEditCopy, $wdHandlerClasses;

		$title = $skin->getTitle();

		if ( !self::isWikidataNs( $title ) ) {
			return true;
		}

		$ns = $title->getNamespace();
		$editChanged = false;
		$dc = wdGetDataSetContext();

		if ( $wdHandlerClasses[ $ns ] == 'DefinedMeaning' ) {

			# Hackishly determine which DMID we're on by looking at the page title component
			$tt = $title->getText();
			$rpos1 = strrpos( $tt, '(' );
			$rpos2 = strrpos( $tt, ')' );
			$dmid = ( $rpos1 && $rpos2 ) ? substr( $tt, $rpos1 + 1, $rpos2 - $rpos1 - 1 ) : 0;
			if ( $dmid ) {
				$copyTitle = SpecialPage::getTitleFor( 'Copy' );
				if ( $dc != $wgCommunity_dc && $wdShowEditCopy ) {
					$editChanged = true;
					$content_actions['edit'] = array(
						'class' => false,
						'text' => wfMsg( 'ow_nstab_edit_copy' ),
						'href' => $copyTitle->getLocalUrl( "action=copy&dmid=$dmid&dc1=$dc&dc2=$wgCommunity_dc" )
					);
				}
				$content_actions['nstab-definedmeaning'] = array(
					 'class' => 'selected',
					 'text' => wfMsg( 'ow_nstab_definedmeaning' ),
					 'href' => $title->getLocalUrl( "dataset=$dc" )
				);
			}
		}

		// Prevent move tab being shown.
		unset( $content_actions['move'] );

		// Add context dataset (old hooks 'GetEditLinkTrail' and 'GetHistoryLinkTrail')
		if ( !$editChanged && $content_actions['edit'] != null ) {
			$content_actions['edit']['href'] = wfAppendQuery( $content_actions['edit']['href'], "dataset=$dc" );
		}

		$content_actions['history']['href'] = wfAppendQuery( $content_actions['history']['href'], "dataset=$dc" );

		return true;
	}

	/**
	 * FIXME: This does not seem to do anything, need to check whether the
	 *        preferences are still being detected.
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		$datasets = wdGetDatasets();
		foreach ( $datasets as $datasetid => $dataset ) {
			$datasetarray[$dataset->fetchName()] = $datasetid;
		}
		$preferences['ow_uipref_datasets'] = array(
			'type' => 'multiselect',
			'options' => $datasetarray,
			'section' => 'omegawiki',
			'label' => wfMsg( 'ow_shown_datasets' ),
			'prefix' => 'ow_datasets-',
		);
		return true;
	}

	public static function onArticleFromTitle( &$title, &$article ) {
		if ( self::isWikidataNs( $title ) ) {
			$article = new WikidataArticle( $title );
		}
		return true;
	}

	public static function onCustomEditor( $article, $user ) {
		if ( self::isWikidataNs( $article->getTitle() ) ) {
			$editor = new WikidataEditPage( $article );
			$editor->edit();
			return false;
		}
		return true;
	}

	public static function onMediaWikiPerformAction( $output, $article, $title, $user, $request, $wiki ) {
		$action = $request->getVal( 'action' );
		if ( $action === 'history' && self::isWikidataNs( $title ) ) {
			$history = new WikidataPageHistory( $article );
			$history->history();
			return false;
		}
		return true;
	}

	public static function onAbortMove( $oldtitle, $newtitle, $user, &$error, $reason ) {
		if ( self::isWikidataNs( $oldtitle ) ) {
			$error = wfMsg( 'wikidata-handler-namespace-move-error' );
			return false;
		}
		return true;
	}
}
