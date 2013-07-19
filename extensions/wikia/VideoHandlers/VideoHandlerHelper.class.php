<?php

/**
 * VideoHandler Helper
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */
class VideoHandlerHelper extends WikiaModel {

	/**
	 * Create file page by adding video category
	 *
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
			$status = $article->doEdit( $content, wfMessage('videohandler-log-add-video')->inContentLanguage()->plain(), $flags, false, $user );
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * Get video description, which is the content of the file page minus the category wiki tags
	 *
	 * @param File $file - The file object for this video
	 * @param bool $fillFromMeta - Whether or not to use the video meta description if the current
	 *                             description is blank
	 * @return string $text
	 */
	public function getVideoDescription( $file, $fillFromMeta = true ) {
		// Get the file page for this file
		$page = WikiPage::factory( $file->getTitle() );

		// Strip the description header
		$text = $this->stripDescriptionHeader( $page->getText() );

		// Strip out the category tags so they aren't shown to the user
		$text = FilePageHelper::stripCategoriesFromDescription( $text );

		// If we have an empty string or a bunch of whitespace, and we're asked to do so,
		// use the default description from the file metadata
		if ( $fillFromMeta && (trim($text) == '') ) {
			$text = $file->getMetaDescription();
		}

		return $text;
	}

	/**
	 * Add a default video description if one doesn't already exist
	 *
	 * @param $file - The file object for the video
	 * @return bool - Returns true if successful, false otherwise
	 */
	public function addDefaultVideoDescription( $file ) {
		$title = $file->getTitle();

		// Get the file page for this file
		$page = WikiPage::factory( $title );

		// Get the description and strip the H2 header
		$text = $this->stripDescriptionHeader( $page->getText() );

		// Strip out the category tags that might be part of the content
		$text = FilePageHelper::stripCategoriesFromDescription( $text );

		// If there is no description, pull the description from metadata,
		// otherwise do nothing
		if ( trim($text) == '' ) {
			$text = $file->getMetaDescription();
			return $this->setVideoDescription( $title, $text );
		} else {
			return true;
		}
	}

	/**
	 * Replace the description section from $title with the content given by $description.
	 *
	 * @param $title - The DBkey version of a title.
	 * @param $description - The text to use to replace the existing description
	 * @return bool Returns true if successful, false otherwise
	 */
	public function setVideoDescription( $title, $description ) {
		// Get the file page for this file
		$page = WikiPage::factory( $title );

		$text = $page->getText();

		// Insert description header
		$text = $this->replaceDescriptionSection( $text, $description );

		$summary = wfMessage('videohandler-log-add-description')->inContentLanguage()->plain();
		$status = $page->doEdit( $text, $summary );

		if ( $status->isOK() ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Remove description header
	 *
	 * @param string $content
	 * @return string $newContent
	 */
	public function stripDescriptionHeader( $content ) {
		$headerText = wfMessage( 'videohandler-description' );

		// Grab everything after the description header
		preg_match("/^==\s*$headerText\s*==\n*(.+)/sim", $content, $matches);

		$newContent = '';
		if ( !empty($matches[1]) ) {
			// Get rid of any H2 headings after the description
			$newContent = preg_replace('/^==[^=]+==.*/sm', '', $matches[1]);
		}

		return $newContent;
	}

	/**
	 * Replace the contents of the description section within the content passed in.
	 *
	 * @param string $content - The file page content
	 * @param string $descText - The text to use to replace any existing description section
	 * @return String - The updated file page content
	 */
	public function replaceDescriptionSection( $content, $descText = '' ) {
		$headerText = wfMessage( 'videohandler-description' );

		// Don't include the description section if there's no description text
		$descSection = '';
		if ( trim($descText) != '' ) {
			$descSection = "== $headerText ==\n".$descText;
		}

		// Search for the description section in the file page content
		$section = 1;
		$sectionFound = 0;
		$sectionText = '';
		while ( 1 ) {
			// Get section $section to see if its the description
			$sectionText = $this->wg->Parser->getSection( $content, $section );

			// If we find a description header here, exit the loop.  Check for English
			// and the wiki's language
			if ( preg_match("/^== *(Description|$headerText)/mi", $sectionText) ) {
				$sectionFound = 1;
				break;
			}

			// If there are no more sections to check, exit the loop
			if ( trim($sectionText) == '' ) {
				break;
			}

			$section++;
		}

		// If we found a description section, replace it here
		if ( $sectionFound ) {
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
	 *
	 * @param string $content - Content in which to look for category tags
	 * @return string
	 */
	private function extractCategories( $content ) {
		$catText = '(?:Category|'.wfMessage( 'nstab-category' ).')';
		preg_match_all( "/(\[\[$catText:[^\]]+\]\])/", $content, $matches );

		if ( !empty($matches[1]) ) {
			return implode('', $matches[1]);
		} else {
			return '';
		}
	}

	/**
	 * Add a description header
	 *
	 * @param string $content
	 * @return string $newContent
	 */
	public function addDescriptionHeader( $content ) {
		$newContent = '=='.wfMessage( 'videohandler-description' ).'=='."\n".$content;

		return $newContent;
	}
}
