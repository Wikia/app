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
			$app->wg->Out->redirect( $model->getSpecialCssUrl() );
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
	private function shouldRedirect($app, $model, $articleId) {
		return !empty($app->wg->EnableSpecialCssExt)
			&& $model->isWikiaCssArticle( $articleId )
			&& $app->checkSkin('oasis')
			&& $app->wg->User->isAllowed('specialcss');
	}
}
