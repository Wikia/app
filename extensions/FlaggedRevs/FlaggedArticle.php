<?php
/**
 * Class representing a MediaWiki article and history
 *
 * FlaggedArticle::getTitleInstance() is preferred over constructor calls
 */
class FlaggedArticle extends Article {
	# Process cache variables
	protected $stableRev = null;
	protected $pageConfig = null;

	/**
	 * Get a FlaggedArticle for a given title
	 */
	public static function getTitleInstance( Title $title ) {
		// Check if there is already an instance on this title
		if ( !isset( $title->flaggedRevsArticle ) ) {
			$title->flaggedRevsArticle = new self( $title );
		}
		return $title->flaggedRevsArticle;
	}

	/**
	 * Get a FlaggedArticle for a given article
	 */
	public static function getArticleInstance( Article $article ) {
		return self::getTitleInstance( $article->mTitle );
	}

	 /**
	 * Is the stable version shown by default for this page?
     * @param int $flags, FR_MASTER
	 * @returns bool
	 */
	public function isStableShownByDefault( $flags = 0 ) {
		# Get page configuration
		$config = $this->getVisibilitySettings( $flags );
		return (bool)$config['override'];
	}

	/**
	 * Is this page less open than the site defaults?
	 * @returns bool
	 */
	public function isPageLocked() {
		return ( !FlaggedRevs::isStableShownByDefault() && $this->isStableShownByDefault() );
	}

	/**
	 * Is this page more open than the site defaults?
	 * @returns bool
	 */
	public function isPageUnlocked() {
		return ( FlaggedRevs::isStableShownByDefault() && !$this->isStableShownByDefault() );
	}

	/**
	 * Should tags only be shown for unreviewed content for this user?
	 * @returns bool
	 */
	public function lowProfileUI() {
		return FlaggedRevs::lowProfileUI() &&
			FlaggedRevs::isStableShownByDefault() == $this->isStableShownByDefault();
	}

	 /**
	 * Is this article reviewable?
     * @param int $flags, FR_MASTER
     * @returns bool
	 */
	public function isReviewable( $flags = 0 ) {
		if ( !FlaggedRevs::inReviewNamespace( $this->getTitle() ) ) {
			return false;
		}
        return !( FlaggedRevs::forDefaultVersionOnly()
            && !$this->isStableShownByDefault( $flags ) );
	}
	
	/**
	* Is this page in patrolable?
    * @param int $flags, FR_MASTER
	* @return bool
	*/
	public function isPatrollable( $flags = 0 ) {
        if ( !FlaggedRevs::inPatrolNamespace( $this->getTitle() ) ) {
			return false;
        }
        return !$this->isReviewable( $flags ); // pages that are reviewable are not patrollable
	}

	/**
	 * Get latest quality rev, if not, the latest reviewed one
	 * @param int $flags
	 * @return Row
	 */
	public function getStableRev( $flags = 0 ) {
		if ( $this->stableRev === false ) {
			return null; // We already looked and found nothing...
		}
		# Cached results available?
		if ( !is_null( $this->stableRev ) ) {
			return $this->stableRev;
		}
		# Do we have one?
		$srev = FlaggedRevision::newFromStable( $this->getTitle(), $flags );
		if ( $srev ) {
			$this->stableRev = $srev;
			return $srev;
		} else {
			$this->stableRev = false;
			return null;
		}
	}

	/**
	 * Get visiblity restrictions on page
	 * @param int $flags, FR_MASTER
	 * @returns Array (select,override)
	 */
	public function getVisibilitySettings( $flags = 0 ) {
		# Cached results available?
		if ( !is_null( $this->pageConfig ) ) {
			return $this->pageConfig;
		}
		# Get the content page, skip talk
		$title = $this->getTitle()->getSubjectPage();
		$config = FlaggedRevs::getPageVisibilitySettings( $title, $flags );
		$this->pageConfig = $config;
		return $config;
	}
}
