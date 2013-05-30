<?php

/**
 * VideoHandler Helper
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */
class VideoHandlerHelper extends WikiaModel {

	/**
	 * create file page by adding video category
	 * @param Title|string $title - Title text of a video
	 * @param User|integer $user - A user ID
	 * @param integer $flags - Edit flags to pass to the Article::doEdit method
	 * @return Status|false $status - The status returned by Article::doEdit
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

	/**
	 * Replace the contents of the description section within the content passed in.
	 * @param string $content - The file page content
	 * @param string $descText - The text to use to replace any existing description section
	 * @return String - The updated file page content
	 */
	public function replaceDescriptionSection( $content, $descText = '' ) {
		$headerText = $this->wf->Message( 'videohandler-description' );

		// Don't include the description section if there's no description text
		$descSection = '';
		if (trim($descText) != '') {
			$descSection = "== $headerText ==\n".$descText;
		}

		// Search for the description section in the file page content
		$section = 1;
		$sectionFound = 0;
		$sectionText = '';
		while (1) {
			// Get section $section to see if its the description
			$sectionText = $this->wg->Parser->getSection( $content, $section );

			// If we find a description header here, exit the loop.  Check for English
			// and the wiki's language
			if (preg_match("/^== *(Description|$headerText)/mi", $sectionText)) {
				$sectionFound = 1;
				break;
			}

			// If there are no more sections to check, exit the loop
			if (trim($sectionText) == '') {
				break;
			}

			$section++;
		}

		// If we found a description section, replace it here
		if ($sectionFound) {
			// If there were any categories in the original section, put them back in
			$catText = $this->extractCategories($sectionText);

			$content = $this->wg->Parser->replaceSection( $content, $section, $descSection."\n".$catText );
		} else {
			// If there wasn't a description section, add one
			$content = $descSection."\n".$content;
		}

		return $content;
	}

	/**
	 * Extract category tags from content text passed in
	 * @param string $content - Content in which to look for category tags
	 * @return string
	 */
	private function extractCategories( $content ) {
		$catText = '(?:Category|'.$this->wf->Message( 'nstab-category' ).')';
		preg_match_all( "/(\[\[$catText:[^\]]+\]\])/", $content, $matches );

		if ( !empty($matches[1]) ) {
			return implode('', $matches[1]);
		} else {
			return '';
		}
	}

	/**
	 * Add a description header
	 * @param string $content
	 * @return string $newContent
	 */
	public function addDescriptionHeader( $content ) {
		$newContent = '=='.$this->wf->Message( 'videohandler-description' ).'=='."\n".$content;

		return $newContent;
	}

	/**
	 * get video detail
	 * @param array $videoInfo [ array( 'title' => title, 'addedAt' => addedAt , 'addedBy' => addedBy ) ]
	 * @param integer $thumbWidth
	 * @param integer $thumbHeight
	 * @param integer $postedInArticles
	 * @return array $videoDetail
	 */
	public function getVideoDetail( $videoInfo, $thumbWidth, $thumbHeight, $postedInArticles ) {
		wfProfileIn( __METHOD__ );

		$videoDetail = array();
		$title = Title::newFromText( $videoInfo['title'], NS_FILE );
		if ( $title instanceof Title ) {
			$file = $this->wf->FindFile( $title );
			if ( $file instanceof File && $file->exists() && WikiaFileHelper::isFileTypeVideo( $file ) ) {
				// get thumbnail
				$thumb = $file->transform( array( 'width' => $thumbWidth, 'height' => $thumbHeight ) );
				$thumbUrl = $thumb->getUrl();

				// get user
				$user = User::newFromId( $videoInfo['addedBy'] );
				$userName = ( User::isIP($user->getName()) ) ? $this->wf->Msg( 'oasis-anon-user' ) : $user->getName();
				$userUrl = $user->getUserPage()->getFullURL();

				// get article list
				$mediaQuery = new ArticlesUsingMediaQuery( $title );
				$articleList = $mediaQuery->getArticleList();
				list( $truncatedList, $isTruncated ) = WikiaFileHelper::truncateArticleList( $articleList, $postedInArticles );

				// video details
				$videoDetail = array(
					'title' => $title->getDBKey(),
					'fileTitle' => $title->getText(),
					'fileUrl' => $title->getLocalUrl(),
					'thumbUrl' => $thumbUrl,
					'userName' => $userName,
					'userUrl' => $userUrl,
					'truncatedList' => $truncatedList,
					'isTruncated' => $isTruncated,
					'timestamp' => $videoInfo['addedAt'],
					'embedUrl' => $file->getHandler()->getEmbedUrl(),
				);
			}
		}

		wfProfileOut( __METHOD__ );

		return $videoDetail;
	}

}
