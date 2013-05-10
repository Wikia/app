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
		wfProfileIn( __METHOD__ );

		if ( is_string($title) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		$status = false;
		if ( $title instanceof Title && !$title->exists() ) {
			if ( is_integer($user) ) {
				$user = User::newFromId( $user );
			}

			$content = '[['.WikiaFileHelper::getVideosCategory().']]';

			$article = new Article( $title );
			$status = $article->doEdit( $content, 'created video', $flags, false, $user );
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * remove description header
	 * @param string $content
	 * @return string $newContent
	 */
	public function removeDescriptionHeader( $content ) {
		$headerText = $this->wf->Message( 'videohandler-description' );

		// Grab everything after the description header
		preg_match("/^==\s*$headerText\s*==\n*(.+)/sim", $content, $matches);

		$newContent = '';
		if (!empty($matches[1])) {
			// Get rid of any H2 headings after the description
			$newContent = preg_replace('/^==[^=]+==.*/sm', '', $matches[1]);
		}

		return $newContent;
	}

	public function replaceDescriptionSection( $content, $descText = '' ) {
		$headerText = $this->wf->Message( 'videohandler-description' );

		// Get any text before the first description header by deleting the first decription
		// header and everything after it.
		$preText = preg_replace("/^==\s*$headerText\s*==\n*(.*)/sim", '', $content);

		// Grab everything after the description header
		preg_match("/^==\s*$headerText\s*==\n*(.+)/sim", $content, $matches);

		// From the above match (if it was successful) try to grab the next H2 heading and below
		if (empty($matches[1])) {
			$postText = $preText;
			$preText = '';
		} else {
			preg_match('/^(==[^=]+==.*)/sm', $matches[1], $postMatch);

			// If we got anything, save it for the final reconstruction
			$postText = empty($postMatch[1]) ? '' : $postMatch[1];
		}

		// If there's no newline at the end of the preText, add one so our '==' wiki text
		// header shows up properly
		if (! preg_match("/\n$/", $preText)) {
			$preText .= "\n";
		}

		// Don't include the description section if there's no description text
		$descSection = '';
		if (trim($descText) != '') {
			$descSection = "== $headerText ==\n".$descText;
		}

		return $preText.$descSection.$postText;
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
