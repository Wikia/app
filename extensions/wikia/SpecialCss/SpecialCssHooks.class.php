<?php
class SpecialCssHooks {
	/**
	 * @desc Redirects to Special:CSS if this is a try of edition of Wikia.css
	 * 
	 * @param EditPage $editPage
	 * @return bool
	 */
	public function onAlternateEdit(EditPage $editPage) {
		wfProfileIn(__METHOD__);
		$app = F::app();
		$model = new SpecialCssModel();

		if( $this->shouldRedirect($app, $model, $editPage->getArticle()->getTitle()->getArticleId()) ) {
			$oldid = $app->wg->Request->getIntOrNull( 'oldid' );
			$app->wg->Out->redirect( $model->getSpecialCssUrl( false, ( $oldid ) ? array( 'oldid' => $oldid ) : null ) );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @param $model SpecialCssModel
	 */
	private function shouldRedirect($app, $model, $articleId) {
		// currently special::css cannot handle undo mode
		if ( $app->wg->Request->getInt( 'undo' ) > 0 && $app->wg->Request->getInt( 'undoafter' ) > 0 ) {
			return false;
		}

		return $app->wg->EnableSpecialCssExt
			&& $model->isWikiaCssArticle( $articleId )
			&& $app->checkSkin( $model::$supportedSkins )
			&& $app->wg->User->isAllowed( 'specialcss' );
	}
}
