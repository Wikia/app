<?php
/**
 * TaggedImages class
 *
 * @file
 * @ingroup Extensions
 */

define( 'TAGGEDIMGS_PER_PAGE', 12 );

/**
 * Photos tagged gallery
 *
 * Add images to the gallery using add(), then render that list to HTML using toHTML().
 */
class TaggedImages extends SpecialPage {
	var $mQuery, $mImages, $mShowFilename;

	/**
	 * Create a new tagged images object.
	 */
	public function __construct() {
		global $wgRequest, $wgOut;

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/ImageTagging/img_tagging.css' );

		$this->mQuery = preg_replace( "/[\"'<>]/", '', $wgRequest->getText( 'q' ) );
		$this->mStartPage = preg_replace( "/[\"'<>]/", '', $wgRequest->getVal( 'page' ) );
		$this->mCount = 0;
		if ( !$this->mStartPage ) {
			$this->mStartPage = 0;
		}
		$this->mImages = array();

		parent::__construct( 'TaggedImages' );
	}

	/**
	 * Start doing stuff
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgOut;

		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE );

		$where = array();
		if ( $this->mQuery ) {
			$where = array(
				'article_tag' => $this->mQuery
			);
		}
		$foo = $dbr->select(
			'imagetags',
			'img_name',
			$where,
			__METHOD__
		);
		$imageNames = array();
		foreach ( $foo as $omg ) {
			$imageNames[] = $omg;
		}

		$imageNamesString = implode( ',', $imageNames ); // @todo CHECKME
		$res = $dbr->select(
			'image',
			array( 'img_name', 'img_timestamp' ),
			array( "img_name IN $imageNamesString" ),
			__METHOD__,
			array(
				'ORDER BY' => 'img_timestamp DESC',
				'LIMIT' => TAGGEDIMGS_PER_PAGE,
				'OFFSET' => $this->mStartPage * TAGGEDIMGS_PER_PAGE
			)
		);

		foreach( $res as $o ) {
			$img = wfFindFile( $o->img_name );
			$this->add( $img, '' );
		}

		$res = $dbr->select(
			'imagetags',
			'COUNT(img_name) AS img_count',
			$where,
			__METHOD__,
			array( 'GROUP BY' => 'article_tag' )
		);
		$o = $dbr->fetchObject( $res );
		if ( $o ) {
			$this->mCount = $o->img_count;
		}

		$wgOut->setPageTitle( wfMsg( 'imagetagging-taggedimages-title', $this->mQuery ? $this->mQuery : 'all' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->addHTML( $this->toHTML() );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Add an image to the gallery.
	 *
	 * @param $image Object: Image object that is added to the gallery
	 * @param $html String: additional HTML text to be shown. The name and size
	 *                      of the image are always shown.
	 */
	function add( $image, $html = '' ) {
		$this->mImages[] = array( &$image, $html );
	}

	/**
	 * Add an image at the beginning of the gallery.
	 *
	 * @param $image Object: Image object that is added to the gallery
	 * @param $html String: additional HTML text to be shown. The name and size
	 *                      of the image are always shown.
	 */
	function insert( $image, $html = '' ) {
		array_unshift( $this->mImages, array( &$image, $html ) );
	}

	/**
	 * @return Boolean: true if the gallery contains no images
	 */
	function isEmpty() {
		return empty( $this->mImages );
	}

	function pagerStatusHTML() {
		wfProfileIn( __METHOD__ );

		$numPages = $this->mCount / TAGGEDIMGS_PER_PAGE;

		if ( !$this->mQuery ) {
			$this->mQuery = 'all';
		}

		$queryTitle = Title::newFromText( $this->mQuery, NS_MAIN );

		$html = wfMsg(
			'imagetagging-taggedimages-displaying',
			$this->mStartPage * TAGGEDIMGS_PER_PAGE + 1,
			min( ( $this->mStartPage + 1 ) * TAGGEDIMGS_PER_PAGE, $this->mCount ),
			$this->mCount,
			'<a href="' . $queryTitle->getLocalURL() . '">' . $this->mQuery . '</a>'
		);

		wfProfileOut( __METHOD__ );
		return $html;
	}

	function pageNoLink( $pageNum, $pageText, $hrefPrefix, $cur ) {
		if ( $cur == false ) {
			$html = '<a href="'. $hrefPrefix . $pageNum . '">' . $pageText .
				'</a>';
		} else {
			$html = '<b>' . $pageText . '</b>';
		}

		$html .= '&#160;';
		return $html;
	}

	function pagerHTML( $topBottom ) {
		global $wgOut;

		$titleObj = SpecialPage::getTitleFor( 'TaggedImages' );

		$maxPages = 5; // 5 real pagers
		$numPages = ceil( $this->mCount / TAGGEDIMGS_PER_PAGE );

		if ( $numPages <= 1 ) {
			return '';
		}

		$html = "<span id=\"{$topBottom}pager\" class=\"pager\" style=\"float: right; text-align: right; right: 30px;\">";

		$hrefPrefix = $titleObj->escapeLocalURL(
			'q=' . $this->mQuery . '&page='
		);

		// build prev button
		if ( $this->mStartPage - 1 >= 0 ) {
			$html .= $this->pageNoLink(
				$this->mStartPage - 1,
				wfMsg( 'allpagesprev' ),
				$hrefPrefix,
				false
			);
		}

		// build page # buttons
		for ( $i = $this->mStartPage - 2; $i < $this->mStartPage + $maxPages; $i++ ) {
			if ( $i >= $numPages ) {
				break;
			}
			if ( $i < 0 ) {
				continue;
			}

			$html .= $this->pageNoLink(
				$i,
				$i + 1,
				$hrefPrefix,
				( $this->mStartPage == $i )
			);
		}

		// build next button
		if ( $this->mStartPage < $numPages - 1 ) {
			$html .= $this->pageNoLink(
				$this->mStartPage + 1,
				wfMsg( 'allpagesnext' ),
				$hrefPrefix,
				false
			);
		}

		$html .= '</span>';

		return $html;
	}

	/**
	 * Return a HTML representation of the image gallery
	 *
	 * For each image in the gallery, display
	 * - a thumbnail
	 * - the image name
	 * - the additional text provided when adding the image
	 * - the size of the image
	 */
	function toHTML() {
		global $wgLang, $wgUser;

		$sk = $wgUser->getSkin();

		$s = '<div>';
		$s .= $this->pagerStatusHTML();
		$s .= $this->pagerHTML( 'top' );
		$s .= '</div>';

		$s .= '<table class="gallery" cellspacing="0" cellpadding="0">';
		$i = 0;
		foreach ( $this->mImages as $pair ) {
			$img =& $pair[0];
			$text = $pair[1];

			$name = $img->getName();
			$nt = $img->getTitle();

			// Not an image. Just print the name and skip.
			if ( $nt->getNamespace() != NS_IMAGE ) {
				$s .= '<td><div class="gallerybox" style="height: 152px;">' .
				htmlspecialchars( $nt->getText() ) . '</div></td>' .  ( ( $i%4 == 3 ) ? "</tr>\n" : '');
				$i++;
				continue;
			}

			$nb = '';
			$textlink = $this->mShowFilename ?
			$sk->makeKnownLinkObj( $nt, htmlspecialchars( $wgLang->truncate( $nt->getText(), 20 ) ) ) . "<br />\n" :
			'';

			$s .= ( $i%4 == 0 ) ? '<tr>' : '';
			$thumb = $img->transform(array( 'width' => 120, 'height' => 120 ) , 0 );
			$vpad = floor( ( 150 - $thumb->height ) /2 ) - 2;
			$s .= '<td><div class="gallerybox">' . '<div class="thumb" style="padding: ' . $vpad . 'px 0;">';

			# ATTENTION: The newline after <div class="gallerytext"> is needed to accommodate htmltivdy which
			# in version 4.8.6 generated crackpot html in its absence, see:
			# http://bugzilla.wikimedia.org/show_bug.cgi?id=1765 -Ævar
			$s .= $sk->makeKnownLinkObj( $nt, $thumb->toHtml() ) . '</div><div class="gallerytext">' . "\n" .
			$textlink . $text . $nb .
			'</div>';
			$s .= "</div></td>\n";
			$s .= ( $i%4 == 3 ) ? '</tr>' : '';
			$i++;
		}
		if ( $i %4 != 0 ) {
			$s .= "</tr>\n";
		}
		$s .= '</table>';
		$s .= $this->pagerHTML( 'bottom' );
		return $s;
	}
} //class
