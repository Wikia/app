<?php

/**
 * @ingroup SpecialPage
 */
class WikiaNewFiles extends IncludableSpecialPage {
	const DEFAULT_LIMIT = 48;

	public function __construct() {
		parent::__construct( 'Newimages' );
	}

	public function execute( $par ) {
		global $wgRequest, $wgOut, $wmu;

		$this->mName = 'WikiaNewFiles';
		$this->setHeaders();

		Wikia::addAssetsToOutput( 'upload_photos_dialog_js' );
		Wikia::addAssetsToOutput( 'upload_photos_dialog_scss' );

		// The param to the special page is overriding the default limit of 48 images per page
		// We don't allow it to be more than 48 though
		$par = intval( $par );
		if ( $par > 0 ) {
			$limit = min( $par, self::DEFAULT_LIMIT );
		} else {
			$limit = self::DEFAULT_LIMIT;
		}

		// Parse request vars
		$hidebots = $wgRequest->getBool( 'hidebots', 1 );
		$until = $wgRequest->getVal( 'until' );
		$from = $wgRequest->getVal( 'from' );

		// Fetch data from DB
		$newFilesModel = new WikiaNewFilesModel( $hidebots );
		$images = $newFilesModel->getImages( $from, $until, $limit );
		$latestTimestamp = $newFilesModel->getLatestTS();

		$hasOlderImages = count( $images ) > $limit;
		$images = array_slice( $images, 0, $limit );

		// Hook for ContentFeeds::specialNewImagesHook
		wfRunHooks( 'SpecialNewImages::beforeDisplay', array( $images, $gallery, $limit ) );

		// Gallery
		if ( count( $images ) ) {
			$gallery = $this->getWikiaGallery( $images );
			$wmu['gallery'] = $gallery;
			$wgOut->addHTML( $gallery->toHTML() );

			if ( !$this->including() ) {
				$wgOut->addHTML( $this->getPagination( $hidebots, $limit, $latestTimestamp, $hasOlderImages, $images ) );
				// TODO: move $wmu integration here
			}
		} else {
			$wgOut->addWikiMsg( 'noimages' );
		}
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return $this->msg( 'wikianewfiles-title' )->text();
	}

	private function getLinkedFiles( $image ) {
		global $wgMemc;
		$anchorLength = 60;

		$cacheKey = wfMemcKey( __METHOD__, md5( $image->img_name ) );
		$data = $wgMemc->get( $cacheKey );
		if ( !is_array( $data ) ) {
			// The ORDER BY ensures we get NS_MAIN pages first
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'imagelinks', 'page' ),
				array( 'page_namespace', 'page_title' ),
				array( 'il_to' => $image->img_name, 'il_from = page_id' ),
				__METHOD__,
				array( 'LIMIT' => 2, 'ORDER BY' => 'page_namespace ASC' )
			);

			while ( $s = $res->fetchObject() ) {
				$data[] = array( 'ns' => $s->page_namespace, 'title' => $s->page_title );
			}
			$dbr->freeResult( $res );

			$wgMemc->set( $cacheKey, $data, 60 * 15 );
		}

		$links = array();

		if ( !empty( $data ) ) {
			foreach ( $data as $row ) {
				$name = Title::makeTitle( $row['ns'], $row['title'] );
				$links[] = Linker::link( $name, wfShortenText( $name, $anchorLength ), array( 'class' => 'wikia-gallery-item-posted' ) );
			}
		}

		return $links;
	}

	private function getPagination( $hidebots, $limit, $latestTimestamp, $hasOlderImages, $images ) {
		global $wgLang, $wmu;

		$lastImageIndex = count( $images ) - 1;
		$firstTimestamp = wfTimestamp( TS_MW, $images[0]->img_timestamp );
		$lastTimestamp = wfTimestamp( TS_MW, $images[$lastImageIndex]->img_timestamp );

		$titleObj = SpecialPage::getTitleFor( 'Newimages' );

		# If we change bot visibility, this needs to be carried along.
		if ( !$hidebots ) {
			$botpar = '&hidebots=0';
		} else {
			$botpar = '';
		}
		$now = wfTimestampNow();

		/* @var $wgLang Language */
		$d = $wgLang->date( $now, true );
		$t = $wgLang->time( $now, true );
		$dateLink = Linker::link( $titleObj, wfMessage( 'sp-newimages-showfrom' )->rawParams( $d, $t )->escaped(),
			array( 'class' => 'navigation-filesfrom' ),
			'from=' . $now . $botpar );

		$botLink = Linker::link( $titleObj,
			wfMessage( 'showhidebots', $hidebots ? wfMessage( 'show' )->plain() : wfMessage( 'hide' )->plain() )->escaped(),
			array( 'class' => 'navigation-' . ( $hidebots ? 'showbots' : 'hidebots' ) ),
			'hidebots=' . ( $hidebots ? '0' : '1' ) );

		$prevLink = wfMessage( 'pager-newer-n', $wgLang->formatNum( $limit ) )->escaped();
		if ( $firstTimestamp && $firstTimestamp != $latestTimestamp ) {
			$wmu['prev'] = $firstTimestamp;
			$prevLink = Linker::link( $titleObj, $prevLink,
				array( 'class' => 'navigation-newer' ),
				'from=' . $firstTimestamp . $botpar );
		}

		$nextLink = wfMessage( 'pager-older-n', $wgLang->formatNum( $limit ) )->escaped();
		if ( $hasOlderImages && $lastTimestamp ) {
			$wmu['next'] = $lastTimestamp;
			$nextLink = Linker::link( $titleObj, $nextLink,
				array( 'class' => 'navigation-older' ),
				'until=' . $lastTimestamp . $botpar );
		}

		$pagination = wfMessage( 'viewprevnext' )->rawParams( $prevLink, $nextLink, $dateLink )->escaped();

		return '<p id="newfiles-nav">' . $botLink . ' ' . $pagination . '</p>';
	}

	/**
	 * Generate WikiaPhotoGallery object from the images array
	 *
	 * @param array $images
	 * @return WikiaPhotoGallery
	 */
	private function getWikiaGallery( $images ) {
		$gallery = new WikiaPhotoGallery();
		$gallery->parseParams( array(
			"rowdivider" => true,
			"hideoverflow" => true
		) );

		if ( strtolower( $this->getSkin()->getSkinName() ) === 'oasis' ) {
			$gallery->setWidths( 212 );
		}

		foreach ( $images as $s ) {
			$name = $s->img_name;
			$ut = $s->img_user_text;

			$nt = Title::newFromText( $name, NS_FILE );
			$ul = Linker::link( Title::makeTitle( NS_USER, $ut ), $ut, array( 'class' => 'wikia-gallery-item-user' ) );
			$timeago = wfTimeFormatAgo( $s->img_timestamp );

			$links = $this->getLinkedFiles( $s );

			// If there are more than two files, remove the 2nd and link to the
			// image page
			if ( count( $links ) == 2 ) {
				array_splice( $links, 1 );
				$moreFiles = true;
			} else {
				$moreFiles = false;
			}

			$caption = wfMessage( 'wikianewfiles-uploadby' )->rawParams( $ul )->params( $ut )->escaped() . "<br />\n" .
				"<i>$timeago</i><br />\n";

			if ( count( $links ) ) {
				$caption .= wfMessage( 'wikianewfiles-postedin' )->escaped() . "&nbsp;" . $links[0];
			}

			if ( $moreFiles ) {
				$caption .= ", " . '<a href="' . $nt->getLocalUrl() .
					'#filelinks" class="wikia-gallery-item-more">' .
					wfMessage( 'wikianewfiles-more' )->escaped() . '</a>';
			}

			$gallery->add( $nt, $caption );
		}

		return $gallery;
	}
}
