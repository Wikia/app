<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 */

define(TAGGEDIMGS_PER_PAGE, 12);


$wgExtensionFunctions[] = 'wfSpecialTaggedImages';


function wfSpecialTaggedImages() {
	global $wgMessageCache;

	$wgMessageCache->addMessage('taggedimages_title', 'Images of \'$1\'');
	$wgMessageCache->addMessage('taggedimages_total', '&#8220;$1&#8221; image(s) total');
	$wgMessageCache->addMessage('taggedimages_displaying', 'Displaying $1 - $2 of $3 images of &#8220;$4&#8221;');
	$wgMessageCache->addMessage('taggedimages', 'Tagged Images');

	SpecialPage::addPage( new TaggedImages );
}

/**
 * Photos tagged gallery
 *
 * Add images to the gallery using add(), then render that list to HTML using toHTML().
 *
 * @package MediaWiki
 */
class TaggedImages extends SpecialPage
{
    var $mQuery, $mImages;

    /**
     * Create a new tagged images object.
     */
    function TaggedImages() {
	global $wgLang, $wgAllowRealName;
        global $wgRequest;
        global $wgOut;

	$wgOut->addScript("<style type=\"text/css\">/*<![CDATA[*/ @import \"$GLOBALS[wgScriptPath]/extensions/wikia/ImageTagging/img_tagging.css?$GLOBALS[wgStyleVersion]\"; /*]]>*/</style>\n");

        $this->mQuery = preg_replace( "/[\"'<>]/", "", $wgRequest->getText('q') );
        $this->mStartPage = preg_replace( "/[\"'<>]/", "", $wgRequest->getVal('page') );
        $this->mCount = 0;
	if ( ! $this->mStartPage ) $this->mStartPage = 0;
        $this->mImages = array();
		
        SpecialPage::SpecialPage("TaggedImages");
    }
	
    /**
     * Start doing stuff
     * @access public
     */
    function execute() {
        global $wgDBname;
	global $wgOut;

	wfProfileIn( __METHOD__ );

        $db =& wfGetDB(DB_SLAVE);

        # COUNT(img_name) AS img_count
/*
	$res = $db->query("SELECT " . ( $this->mQuery ? "" : "DISTINCT " ) . "imagetags.img_name, image.img_timestamp FROM " .
		      " `$wgDBname`.`imagetags` LEFT JOIN `$wgDBname`.`image` ON imagetags.img_name = image.img_name ".
		      ( $this->mQuery ? " WHERE article_tag='" . $this->mQuery . "'" : "" ) .
		      " GROUP BY unique_id " . 
		      " ORDER BY image.img_timestamp desc " .
		      " LIMIT " . ($this->mStartPage * TAGGEDIMGS_PER_PAGE) . 
		      ", " . TAGGEDIMGS_PER_PAGE);
*/

	$res = $db->query("SELECT image.img_name, image.img_timestamp FROM starwars.image WHERE image.img_name IN (SELECT imagetags.img_name FROM imagetags ".($this->mQuery ? " WHERE imagetags.article_tag='" . $this->mQuery . "'" : "")." GROUP by imagetags.unique_id) ORDER BY image.img_timestamp DESC LIMIT " . ($this->mStartPage * TAGGEDIMGS_PER_PAGE) . ", " . TAGGEDIMGS_PER_PAGE);

	while ($o = $db->fetchObject($res)) {
	    $img = Image::newFromName($o->img_name);
            $this->add($img, '');
        }
        $db->freeResult($res);

        $res = $db->query("SELECT COUNT(img_name) as img_count FROM " .
                          " `$wgDBname`.`imagetags` ".
                          ( $this->mQuery ? " WHERE article_tag='" . $this->mQuery . "'" : "" ) .
                          " GROUP BY article_tag");
        if ( $o = $db->fetchObject($res) ) {
            $this->mCount = $o->img_count;
        }
        $db->freeResult($res);

	$wgOut->setPageTitle( wfMsg('taggedimages_title', $this->mQuery ? $this->mQuery : "all" ) );
	$wgOut->setRobotpolicy('noindex,nofollow');
        $wgOut->addHTML($this->toHTML());

	wfProfileOut( __METHOD__ );
    }

    /**
     * Add an image to the gallery.
     *
     * @param Image  $image  Image object that is added to the gallery
     * @param string $html   Additional HTML text to be shown. The name and size of the image are always shown.
     */
    function add( $image, $html='' ) {
	$this->mImages[] = array( &$image, $html );
    }

    /**
     * Add an image at the beginning of the gallery.
     *
     * @param Image  $image  Image object that is added to the gallery
     * @param string $html   Additional HTML text to be shown. The name and size of the image are always shown.
     */
    function insert( $image, $html='' ) {
	array_unshift( $this->mImages, array( &$image, $html ) );
    }


    /**
     * isEmpty() returns true if the gallery contains no images
     */
    function isEmpty() {
	return empty( $this->mImages );
    }

    function pagerStatusHTML() {
	wfProfileIn( __METHOD__ );

	$numPages = $this->mCount / TAGGEDIMGS_PER_PAGE;

	if (!$this->mQuery) $this->mQuery = "all";

	$queryTitle = Title::newFromText($this->mQuery, NS_MAIN);

	$html = wfMsg('taggedimages_displaying', $this->mStartPage*TAGGEDIMGS_PER_PAGE + 1, min(($this->mStartPage+1)*TAGGEDIMGS_PER_PAGE,$this->mCount), $this->mCount, '<a href="' . $queryTitle->getLocalURL() . '">' . $this->mQuery . '</a>');

	wfProfileOut( __METHOD__ );
	return $html;
    }

    function pageNoLink($pageNum, $pageText, $hrefPrefix, $cur) {
	if ( $cur == false ) 
            $html = '<a href="'. $hrefPrefix . $pageNum . '">' . $pageText . '</a>';
	else
	    $html = '<b>' . $pageText . '</b>';

        $html .= '&nbsp;';
        return $html;
    }

    function pagerHTML($topBottom) {
	global $wgOut;

	$titleObj = Title::makeTitle( NS_SPECIAL, 'TaggedImages' );

	$maxPages = 5; // 5 real pagers
	$numPages = ceil($this->mCount / TAGGEDIMGS_PER_PAGE);

	if ( $numPages <= 1 ) return '';

	$html = '<span id="{$topBottom}pager" class="pager" style="float: right; text-align: right; right: 30px;">';

	$hrefPrefix = $titleObj->escapeLocalURL("q=" . $this->mQuery . "&page=");

	// build prev button
	if ( $this->mStartPage - 1 >= 0 ) {
	    $html .= $this->pageNoLink($this->mStartPage-1, wfMsg('allpagesprev'), $hrefPrefix, false);
	}

	// build page # buttons
	for ( $i=$this->mStartPage-2; $i < $this->mStartPage + $maxPages; $i++ ) {
	    if ( $i >= $numPages ) break;
	    if ( $i < 0 ) continue;

	    $html .= $this->pageNoLink($i, $i+1, $hrefPrefix, ($this->mStartPage == $i));
	}

	// build next button
	if ( $this->mStartPage < $numPages-1 ) {
	    $html .= $this->pageNoLink($this->mStartPage+1, wfMsg('allpagesnext'), $hrefPrefix, false); 
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
     *
     */
    function toHTML() {
	global $wgLang, $wgUser;
	global $wgOut;

	$sk = $wgUser->getSkin();

	$s = '<div>';
	$s .= $this->pagerStatusHTML();
	$s .= $this->pagerHTML('top');
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
			htmlspecialchars( $nt->getText() ) . '</div></td>' .  (($i%4==3) ? "</tr>\n" : '');
		$i++;
		continue;
	    }

	    // TODO
	    // $ul = $sk->makeLink( $wgContLang->getNsText( Namespace::getUser() ) . ":{$ut}", $ut );

            $nb = '';
	    $textlink = $this->mShowFilename ?
			$sk->makeKnownLinkObj( $nt, htmlspecialchars( $wgLang->truncate( $nt->getText(), 20, '...' ) ) ) . "<br />\n" :
			'';

	    $s .= ($i%4==0) ? '<tr>' : '';
	    $thumb = $img->getThumbnail( 120, 120 );
	    $vpad = floor( ( 150 - $thumb->height ) /2 ) - 2;
	    $s .= '<td><div class="gallerybox">' . '<div class="thumb" style="padding: ' . $vpad . 'px 0;">';

	    # ATTENTION: The newline after <div class="gallerytext"> is needed to accommodate htmltivdy which
	    # in version 4.8.6 generated crackpot html in its absence, see:
	    # http://bugzilla.wikimedia.org/show_bug.cgi?id=1765 -Ævar
	    $s .= $sk->makeKnownLinkObj( $nt, $thumb->toHtml() ) . '</div><div class="gallerytext">' . "\n" .
		    $textlink . $text . $nb .
		    '</div>';
	    $s .= "</div></td>\n";
	    $s .= ($i%4==3) ? '</tr>' : '';
	    $i++;
	}
	if ( $i %4 != 0 ) {
	    $s .= "</tr>\n";
	}
	$s .= '</table>';
	$s .= $this->pagerHTML('bottom');
	return $s;
    }

} //class


?>
