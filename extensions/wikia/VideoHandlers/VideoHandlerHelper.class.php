<?php

/**
 * VideoHandler Helper
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */
class VideoHandlerHelper extends WikiaModel {

	/**
	 * create file page by adding video category
	 * @param Title|string $title
	 * @param User|integer $user
	 * @return Status|false $status
	 */
	public function addCategoryVideos( $title, $user, $flags = EDIT_NEW ) {
		$this->wf->ProfileIn( __METHOD__ );

		if ( is_string($title) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		$status = false;
		if ( $title instanceof Title && !$title->exists() ) {
			if ( is_integer($user) ) {
				$user = User::newFromId( $user );
			}

			$content = '[['.WikiaVideoPage::getVideosCategory().']]';

			$article = new Article( $title );
			$status = $article->doEdit( $content, 'created video', $flags, false, $user );
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * remove description header
	 * @param string $content
	 * @return string $newContent
	 */
	public function removeDescriptionHeader( $content ) {
		$newContent = preg_replace( '/^==\s*'.$this->wf->Message( 'videohandler-description' ).'\s*==/mi', '', $content );

		return $newContent;
	}

	/**
	 * add description header
	 * @param string $content
	 * @return string $newContent
	 */
	public function addDescriptionHeader( $content ) {
		$newContent = '=='.$this->wf->Message( 'videohandler-description' ).'=='."\n".$content;

		return $newContent;
	}

}
