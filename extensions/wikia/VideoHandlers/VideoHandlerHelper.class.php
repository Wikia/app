<?php

/**
 * VideoHandler Helper
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */
class VideoHandlerHelper extends WikiaModel {

	/**
	 * add video category to file page
	 * @param string $titleText
	 * @param User $user
	 * @return Status|null $status
	 */
	public function addCategoryVideos( $titleText, $user ) {
		$this->wf->ProfileIn( __METHOD__ );

		$status = null;
		$title = Title::newFromText( $titleText, NS_FILE );
		if ( $title instanceof Title ) {
			$cat = $this->wg->ContLang->getFormattedNsText( NS_CATEGORY );
			$content = '[[' . $cat . ':' . wfMsgForContent( 'videohandler-category' ) . ']]';

			if ( $title->exists() ) {
				$article = Article::newFromID( $title->getArticleID() );
				$oldContent = $article->getContent();
				if ( !strstr($oldContent, $content) ) {
					$content = $oldContent.$content;
					$status = $article->doEdit( $content, 'added video category', EDIT_UPDATE, false, $user );
				}
			} else {
				$article = new Article( $title );
				$status = $article->doEdit( $content, 'created video', EDIT_NEW, false, $user );
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $status;
	}

}
