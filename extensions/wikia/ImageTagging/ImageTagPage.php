<?php

$wgHooks['UnknownAction'][] = 'addTag';
$wgHooks['UnknownAction'][] = 'removeTag';
$wgHooks['UnknownAction'][] = 'tagSearch';

$wgExtensionFunctions[] = 'wfImageTagPageSetup';
$wgExtensionCredits['other'][] = array(
    'name' => 'Image Tagging',
    'author' => 'Wikia, Inc. (Tristan Harris, Tomasz Klim)',
    //'version' => 1.0,
    'url' => 'http://www.wikia.com/wiki/Help:Image_tagging',
    'description' => 'Wikia Image Tagging',
);

// other hooks to try: 'ParserAfterTidy', ...
#$wgHooks['OutputPageBeforeHTML'][] = 'wfCheckArticleImageTags';
$wgHooks['ArticleFromTitle'][] = 'wfArticleFromTitle';


/********************
 * End Trie Handlers
 ********************/

function wfCheckArticleImageTags($outputPage, $text)
{
    global $wgOut, $wgDBname, $wgTitle;

    if ( $outputPage->isArticle() )
    {
        $db =& wfGetDB(DB_SLAVE);
        $res = $db->query("SELECT article_tag, tag_rect, unique_id, COUNT(article_tag) AS count FROM ".
			" `$wgDBname`.`imagetags` ".
			" WHERE article_tag='" . addslashes($wgTitle->getText()). "'" .  /*LIMIT 1"*/          " GROUP BY article_tag" );

        if ($o = $db->fetchObject($res)) {
            $taggedImagesObj = Title::newFromText('TaggedImages', NS_SPECIAL);
            $titleText = $wgTitle->getText();

            $wgOut->addHTML('
            <a href="' . $taggedImagesObj->getLocalUrl('q='.$titleText) . '">
            <span style="position:absolute;
             z-index:1;
             border:none;
             background:none;
             right:30px;
             top:3.7em;
             float:right;
             margin:0.0em;
             padding:0.0em;
             line-height:1.7em; /*1.5em*/
             text-align:right;
             text-indent:0;
             font-size:100%;
             text-transform:none;
             white-space:nowrap;" id="coordinates" class="plainlinksneverexpand">
            ' . wfMsg('imagetag_seemoreimages', $titleText, $o->count) .
             '</span></a>'); 
        }
    }
    return true;
}


// TKL 2006-03-07: it doesn't work in new MediaWiki, modification required in includes/Wiki.php (class name change only)
// $wgNamespaceTemplates[NS_IMAGE] = 'ImageTagPage'; 

function addTag($action, $article)
{
    if($action != 'addTag') return true;

    global $wgRequest, $wgTitle, $wgDBname, $wgOut, $wgUser;

    wfProfileIn( __METHOD__ );

    $wgOut->setArticleBodyOnly(true);

    $tagRect = $wgRequest->getText('rect');
    $tagName = $wgRequest->getText('tagName');
    $imgName = $wgRequest->getText('imgName');
    $userText = $wgUser->getName();

    $tagRect = preg_replace( "/[\"'<>]/", "", $tagRect );
    $tagName = preg_replace( "/[\"'<>]/", "", $tagName );
    $imgName = preg_replace( "/[\"'<>]/", "", $imgName );

    $img = Image::newFromName($imgName);
    if ($img)
    {
        $imgTitle = $img->getTitle();

        wfPurgeTitle($imgTitle);

        $db =& wfGetDB(DB_MASTER);
        $db->insert("`$wgDBname`.`imagetags`", 
        array(  'img_page_id' => 0,//$img->getTitle()->getArticleID(),
		'img_name' => $imgName,
		'article_tag' => $tagName,
		'tag_rect' => $tagRect,
		'user_text' => $userText));

       $wgOut->clearHTML();
       $wgOut->addHTML("<!-- added tag for image $imgName to database! -->");
       $wgOut->addHTML( wfGetImageTags($img, $imgName) );

       $logPage = new LogPage( 'tag' );
       $link = basename( $img->title->getLocalURL() );
       $logComment = "Image [[$link|$imgName]] was tagged to article [[$tagName]] by $userText";
       $logPage->addEntry( 'tag', $imgTitle, $logComment);

       EmailNotification::notifyOnPageChange($imgTitle, wfTimestampNow(), $logComment, false);
    }
    else {
        $wgOut->clearHTML();
        $wgOut->addHTML("<!-- ERROR: img named $imgName -->
                        <script type='text/javascript'>
                        alert(\"Error adding tag!\");
                        </script>");
    }

    wfProfileOut( __METHOD__ );
    return false;
}


function removeTag($action, $article)
{
    if ($action != 'removeTag') return true;

    global $wgRequest, $wgTitle, $wgOut, $wgDBname, $wgUser;

    wfProfileIn( __METHOD__ );

    $wgOut->setArticleBodyOnly(true);

    $tagID = $wgRequest->getVal('tagID');
    $tagName = $wgRequest->getText('tagName');
    $imgName = $wgRequest->getText('imgName');
    $userText = $wgUser->getName();

    $tagID = preg_replace( "/[\"'<>]/", "", $tagID );
    $tagName = preg_replace( "/[\"'<>]/", "", $tagName );
    $imgName = preg_replace( "/[\"'<>]/", "", $imgName );

    $img = Image::newFromName($imgName);
    if ($img)
    {
        $imgTitle = $img->getTitle();

        wfPurgeTitle($imgTitle);

        $db =& wfGetDB(DB_MASTER);
        $db->delete("`$wgDBname`.`imagetags`", array('unique_id' => $tagID));

        $wgOut->clearHTML();
        $wgOut->addHTML("<!-- removed tag to database! -->");
        $wgOut->addHTML( wfGetImageTags($img, $imgName) );

        $logPage = new LogPage( 'tag' );
        $logComment = "Removed tag to article [[$tagName]] by $userText";
        $logPage->addEntry( 'tag', $imgTitle, $logComment);

        EmailNotification::notifyOnPageChange($imgTitle, wfTimestampNow(), $logComment, false);
    }
    else {
        $wgOut->clearHTML();
        $wgOut->addHTML("<!-- ERROR: img named $imgName -->
                        <script type='text/javascript'>
                        alert(\"Error removing tag!\");
                        </script>");
    }

    wfProfileOut( __METHOD__ );
    return false;
}

function tagSearch($action, $article)
{
  if($action != 'tagSearch') return true;

  global $wgRequest, $wgTitle, $wgDBname, $wgOut, $wgUser;

  wfProfileIn( __METHOD__ );

  $wgOut->setArticleBodyOnly(true);

  $query = $wgRequest->getText('q');
  $query = preg_replace( "/[\"'<>]/", "", $query );

  $search = SearchEngine::create();
  $search->setLimitOffset( 10, 0 );
  $search->setNamespaces( array(NS_MAIN) );
  $search->showRedirects = true;
  $titleMatches = $search->searchTitle( $query );

  $numResults = ( $titleMatches ? $titleMatches->numRows() : 0 );
  if ( $numResults > 0 )
    $wgOut->addHTML(wfTagSearchShowMatches($titleMatches));

  #echo "numResults: " . $numResults . ", query: " . $query;

  wfProfileOut( __METHOD__ );
  return false;
}

/**
 * @param SearchResultSet $matches
 * @param string $terms partial regexp for highlighting terms
  */
 function wfTagSearchShowMatches( &$matches ) {
   global $wgContLang;

   wfProfileIn( __METHOD__ );

   $tm = $wgContLang->convertForSearchResult( $matches->termMatches() );
   $terms = implode( '|', $tm );

   $out = "<searchresults>\n";

   while( $result = $matches->next() ) {
     $out .= wfTagSearchHitXML( $result, $terms );
   }
   $out .= "</searchresults>\n";

   // convert the whole thing to desired language variant
   $out = $wgContLang->convert( $out );

   wfProfileOut( __METHOD__ );
   return $out;
 }

/**
 * Format a single hit result
 * @param SearchResult $result
 * @param string $terms partial regexp for highlighting terms
 */
function wfTagSearchHitXML( $result, $terms ) {
  global $wgUser, $wgContLang;

  wfProfileIn( __METHOD__ );

  $t = $result->getTitle();
  if( is_null( $t ) ) {
    wfProfileOut( __METHOD__ );
    return "<!-- Broken link in search result -->\n";
  }
  $sk =& $wgUser->getSkin();

  $contextlines=5;
  $contextchars=50;

  $link = $sk->makeKnownLinkObj( $t );
  $revision = Revision::newFromTitle( $t );
  $text = $revision->getText();

  $lines = explode( "\n", $text );

  $max = intval( $contextchars ) + 1;
  $pat1 = "/(.*)($terms)(.{0,$max})/i";

  $lineno = 0;

  $extract = '';
  foreach ( $lines as $line ) {
    if ( 0 == $contextlines ) {
      break;
    }
    ++$lineno;
    if ( ! preg_match( $pat1, $line, $m ) ) {
      continue;
    }
    $contextlines--;
    $pre = $wgContLang->truncate( $m[1], -$contextchars, '...' );

    if ( count( $m ) < 3 ) {
      $post = '';
    } else {
      $post = $wgContLang->truncate( $m[3], $contextchars, '...' );
    }

    $found = $m[2];

    $line = htmlspecialchars( $pre . $found . $post );
    $pat2 = '/(' . $terms . ")/i";
    $line = preg_replace( $pat2, "<span class='searchmatch'>\\1</span>", $line );

    $extract .= "<br /><small>{$lineno}: {$line}</small>\n";
  }

  wfProfileOut( __METHOD__ );
  return "<result>\n<link>{$link}</link>\n<context>{$extract}</context>\n</result>\n";
}

function wfPurgeTitle($title)
{
  global $wgUseSquid;

  wfProfileIn( __METHOD__ );

  $title->invalidateCache();

  if ( $wgUseSquid ) {
    // Commit the transaction before the purge is sent
    $dbw =& wfGetDB( DB_MASTER );
    $dbw->immediateCommit();

    // Send purge
    $update = SquidUpdate::newSimplePurge( $title );
    $update->doUpdate();
  }

  wfProfileOut( __METHOD__ );
}


function wfGetImageTags($img, $imgName) {
    global $wgDBname;
    global $wgUser;
    global $wgOut;

    wfProfileIn( __METHOD__ );

    $sk = $wgUser->getSkin();
    $db =& wfGetDB(DB_SLAVE);
    $db->selectDB($wgDBname);	
    $res = $db->select(
	array("imagetags"), 
	array("article_tag", "tag_rect", "unique_id"), 
	array("img_name" => $imgName), 
	__METHOD__ );

    $html = '';
    $wgOut->addHTML("<!-- this many image tags: " . count($res) . " from img " . $img->name . " -->");
    while ($o = $db->fetchObject($res)) {
        if ( strlen($html) > 0 )
            $html .= ', ';

        $wgOut->addHTML("<!-- tag rect: " . $o->tag_rect . ", tag title: " . $o->article_tag . ", unique_id: " . $o->unique_id . "-->"); 

        $span = '<span id="' . $o->article_tag . '-tag" onmouseout="hideTagBox()" onmouseover="tagBoxPercent(' . $o->tag_rect . ', false)">';

	#echo "article tag: " . $o->article_tag . "\n";
	$articleTitle = Title::newFromText($o->article_tag);

        #$articleLink = '<a href="' . $articleTitle->escapeFullURL() . '" onmouseout="hideTagBox()">' . $o->article_tag . '</a>';
        $articleLink = $sk->makeLinkObj($articleTitle);

	$specialImagesTitle = Title::newFromText("Special:TaggedImages");

        $imagesLink = '<a onmouseover="tagBoxPercent(' . $o->tag_rect . ', false)" onmouseout="hideTagBox()" href="' . $specialImagesTitle->escapeFullURL("q=".$o->article_tag) . '">' . wfMsgHtml('images') . '</a>';

        $removeLink = '<a href="#" onclick="removeTag(' . $o->unique_id . ', this, \'' . addslashes( $o->article_tag ) . '\'); return false;">' . wfMsgHtml('removetag') . '</a>';

        $html .= $span . $articleLink . ' (' . $imagesLink . ' | ' . $removeLink . ')</span>';
    }
    $db->freeResult($res);

    if ( $html )
        $html = 'In this image: ' . $html;

    wfProfileOut( __METHOD__ );
    return $html;
}


function wfArticleFromTitle( &$title, &$article ) {
    global $wgUser;

    wfProfileIn( __METHOD__ );

    if ( NS_IMAGE == $title->getNamespace() && !$wgUser->isBlocked() ) {
    	$article = new ImageTagPage( $title );
    }

    wfProfileOut( __METHOD__ );
    return true;
}

function wfImageTagPageSetup() {
  global $wgMessageCache,$wgLogTypes;
  $wgMessageCache->addMessage('addimagetag',"Tag this Image");
  $wgMessageCache->addMessage('images',"images");
  $wgMessageCache->addMessage('removetag', "remove tag");
  $wgMessageCache->addMessage('done_button', "Done Tagging");
  $wgMessageCache->addMessage('tag_button', "Tag");
  $wgMessageCache->addMessage('tagcancel_button', "Cancel");
  $wgMessageCache->addMessage('tagging_instructions', 'Click on people or things in the image to tag them. ');
  $wgMessageCache->addMessage('addingtag', "Adding tag...");
  $wgMessageCache->addMessage('removingtag', "removing tag...");
  $wgMessageCache->addMessage('addtagsuccess', "Added tag.");
  $wgMessageCache->addMessage('removetagsuccess', "Removed tag.");
  $wgMessageCache->addMessage('oneactionatatimemessage', "Removed tag.");
  $wgMessageCache->addMessage('canteditneedloginmessage', "You can't edit this page.  It may be because you need to login to tag images.  Do you want to login now?");
  $wgMessageCache->addMessage('canteditothermessage', "You can't edit this page, either because you don't have the rights, or because this page has been locked for other reasons.  For more information, see http://www.wikia.com/wiki/Protection");
  $wgMessageCache->addMessage('oneactionatatimemessage', "Sorry, only one tagging action at a time.  Please wait for the existing action to complete.");
  $wgMessageCache->addMessage('oneuniquetagmessage', "Sorry, this image already has a tag with this name.");
  $wgMessageCache->addMessage('imagetag_seemoreimages', 'See more images of &#8220;$1&#8221; ($2)');
 
  $wgLogTypes[] = 'tag';

class ImageTagPage extends ImagePage
{
    function openShowImage() {
        global $wgOut, $wgUser, $wgServer, $wgImageTaggingPath, $wgStyleVersion;

	wfProfileIn( __METHOD__ );

	// TKL 2007-03-09: get files only from extensions directory, and not from skins/common
	if ( $wgImageTaggingPath == '' ) {  $wgImageTaggingPath = '/wiki/extensions/wikia/ImageTagging/';  }

        $wgOut->addScript('<script type="text/javascript" src="' . $wgImageTaggingPath . 'img_tagging.js?'.$wgStyleVersion.'" charset="utf-8"></script>');
        $wgOut->addScript('<script type="text/javascript" src="' . $wgImageTaggingPath . 'json.js?'.$wgStyleVersion.'" charset="utf-8"></script>');

	// TKL commented out 2007-03-06
        // $wgOut->addHTML('<script type="text/javascript"> var baseUrl = "{$wgServer}/wiki/"; </script>');
	// $wgOut->addScript('<script type="text/javascript" src="' . $wgImageTaggingPath . 'WSuggest.js"></script>');

        $imgName = $this->getTitle()->getText();
        $wgOut->addHTML("<input type='hidden' value='" . $imgName . "' id='imgName' />");
        $wgOut->addHTML("<input type='hidden' value='" . $wgImageTaggingPath . "' id='imgPath' />");

        if ( $wgUser->isLoggedIn() )
            $wgOut->addHTML("<input type='hidden' value='1' id='userLoggedIn'/>");

        if ( $wgUser->isAllowed('edit') && 
             $this->mTitle->userCanEdit() &&
             ( $this->mTitle->isProtected('edit') == false || in_array( 'sysop', $wgUser->getGroups() ) ) )
            $wgOut->addHTML("<input type='hidden' value='1' id='canEditPage'/>");

        $this->modifiedImagePageOpenShowImage();

        if ( $this->img->exists() ) {
            $tagList = wfGetImageTags($this->img, $imgName);

            #if ( $tagList )
            $wgOut->addHTML("<div id='tagListDiv'><span id='tagList'>$tagList</span></div>");     
        }

	wfProfileOut( __METHOD__ );
    }

    function modifiedImagePageOpenShowImage() {
		global $wgOut, $wgUser, $wgImageLimits, $wgRequest, $wgUseImageResize;

		wfProfileIn( __METHOD__ );

		$full_url  = $this->img->getURL();
		$anchoropen = '';
		$anchorclose = '';

		if( $wgUser->getOption( 'imagesize' ) == '' ) {
			$sizeSel = User::getDefaultOption( 'imagesize' );
		} else {
			$sizeSel = intval( $wgUser->getOption( 'imagesize' ) );
		}
		if( !isset( $wgImageLimits[$sizeSel] ) ) {
			$sizeSel = User::getDefaultOption( 'imagesize' );
		}
		$max = $wgImageLimits[$sizeSel];
		$maxWidth = $max[0];
		$maxHeight = $max[1];
		$maxWidth = 600;
		$maxHeight = 460;
		$sk = $wgUser->getSkin();

		if ( $this->img->exists() ) {
			# image
			$width = $this->img->getWidth();
			$height = $this->img->getHeight();
			$showLink = false;

			if ( $this->img->allowInlineDisplay() and $width and $height) {
				# image

				# "Download high res version" link below the image
				$msg = wfMsgHtml('show-big-image', $width, $height, intval( $this->img->getSize()/1024 ) );

				# We'll show a thumbnail of this image
				if ( $width > $maxWidth || $height > $maxHeight ) {
					# Calculate the thumbnail size.
					# First case, the limiting factor is the width, not the height.
					if ( $width / $height >= $maxWidth / $maxHeight ) {
						$height = round( $height * $maxWidth / $width);
						$width = $maxWidth;
						# Note that $height <= $maxHeight now.
					} else {
						$newwidth = floor( $width * $maxHeight / $height);
						$height = round( $height * $newwidth / $width );
						$width = $newwidth;
						# Note that $height <= $maxHeight now, but might not be identical
						# because of rounding.
					}

					if( $wgUseImageResize ) {
						$thumbnail = $this->img->getThumbnail( $width );
						if ( $thumbnail == null ) {
							$url = $this->img->getViewURL();
						} else {
							$url = $thumbnail->getURL();
						}
					} else {
						# No resize ability? Show the full image, but scale
						# it down in the browser so it fits on the page.
						$url = $this->img->getViewURL();
					}
					$anchoropen  = "<a href=\"{$full_url}\">";
					$anchorclose = "</a><br />";
					if( $this->img->mustRender() ) {
						$showLink = true;
					} else {
						$anchorclose .= "\n$anchoropen{$msg}</a>";
					}
				} else {
					$url = $this->img->getViewURL();
					$showLink = true;
				}

				//$anchoropen = '';
				//$anchorclose = '';
//				$width = 'auto'; //'100%';
//				$height = 'auto'; //'100%'; 
				$wgOut->addHTML( '<div class="fullImageLink" id="file">' .
				     "<img border=\"0\" src=\"{$url}\" width=\"{$width}\" height=\"{$height}\" style=\"max-width: {$maxWidth}px;\" alt=\"" .
				     htmlspecialchars( $wgRequest->getVal( 'image' ) ).'" />' .
				      $anchoropen . $anchorclose . '</div>' );
			} else {
				#if direct link is allowed but it's not a renderable image, show an icon.
				if ($this->img->isSafeFile()) {
					$icon= $this->img->iconThumb();

					$wgOut->addHTML( '<div class="fullImageLink" id="file"><a href="' . $full_url . '">' .
					$icon->toHtml() .
					'</a></div>' );
				}

				$showLink = true;
			}

			if ($showLink) {
				$filename = wfEscapeWikiText( $this->img->getName() );
				$info = wfMsg( 'file-info',
					$sk->formatSize( $this->img->getSize() ),
					$this->img->getMimeType() );

				if (!$this->img->isSafeFile()) {
					$warning = wfMsg( 'mediawarning' );
					$wgOut->addWikiText( <<<END
<div class="fullMedia">
<span class="dangerousLink">[[Media:$filename|$filename]]</span>
<span class="fileInfo"> ($info)</span>
</div>

<div class="mediaWarning">$warning</div>
END
						);
				} else {
					$wgOut->addWikiText( <<<END
<div class="fullMedia">
[[Media:$filename|$filename]] <span class="fileInfo"> ($info)</span>
</div>
END
						);
				}
			}

			if($this->img->fromSharedDirectory) {
				$this->printSharedImageText();
			}
		} else {
			# Image does not exist

			$title = Title::makeTitle( NS_SPECIAL, 'Upload' );
			$link = $sk->makeKnownLinkObj($title, wfMsgHtml('noimage-linktext'),
				'wpDestFile=' . urlencode( $this->img->getName() ) );
			$wgOut->addHTML( wfMsgWikiHtml( 'noimage', $link ) );
		}

		wfProfileOut( __METHOD__ );
	}



  /**
   * Create the TOC
   *
   * @access private
   *
   * @param bool $metadata Whether or not to show the metadata link
   * @return string
   */
  function showTOC( $metadata ) {
    global $wgLang, $wgUser;

    $r = '<ul id="filetoc">
<li><a href="#file">' . $wgLang->getNsText( NS_IMAGE ) . '</a></li>
<li><a href="#filehistory">' . wfMsgHtml( 'imghistory' ) . '</a></li>
<li><a href="#filelinks">' . wfMsgHtml( 'imagelinks' ) . '</a></li>' .
      ($metadata ? '<li><a href="#metadata">' . wfMsgHtml( 'metadata' ) . '</a></li>' : '') . '
<li><a href="javascript:addImageTags()">' . wfMsgHtml( 'addimagetag' ) . '</a><sup><font color=red>New!</font></sup></li>' 
. '</ul>';

    $r .= '<div id="tagStatusDiv" style="margin: 5px 5px 10px 5px; padding: 10px; border: solid 1px #ffe222; background: #fffbe2; display: none;"><table style="background-color: #fffbe2;"><tr><td width="450" height="30" align="center" style="padding-left: 20px;"><img src="/skins/common/progress-wheel.gif" id="progress_wheel" style="display:none;"><div id="tagging_message" style="background: #fffbe2;">' . wfMsgHtml('tagging_instructions') . '</td><td valign="middle"><input type="button" onclick="doneAddingTags();" id="done_tagging" name="done_tagging" value="' . wfMsgHtml('done_button') . '" /></div></td></tr></table></div>';

    $r .= "<div style='position: absolute; font: verdana, sans-serif; top: 10px; left: 10px; display: none; width:284px; height:24px; padding: 4px 6px; background-color: #eeeeee; color: #444444; border: 2px solid #555555; z-index:2;' id='tagEditField'>

<span style='position: absolute; left: 4px; top: 6px;'>Article:</span>

<!-- TAH: don't use the popup just yet
<select name='tagType'>
<option selected>Article</option>
<option>Category</option>
</select> 
-->";

    $r .= "<input style='position: absolute; left: 189px; top: 6px; width: 39px; height: 20px;' type='submit' name='Tag' value='" . wfMsgHtml('tag_button') . "' onclick='submitTag()'/>";
    $r .= "<input style='position: absolute; left: 232px; top: 6px; width: 60px; height: 20px;' type='button' name='Cancel' value='" . wfMsgHtml('tagcancel_button') . "' onclick='hideTagBox()'/>";

    $r .= "<input type='text' style='position: absolute; left: 46px; top: 6px; background-color:white; width: 140px; height:18px;' name='articleTag' id='articleTag'  value='' title='Article to tag' onkeyup='typeTag(event);' />";

    $r .= '</div>';

    $r .= '<div id="popup" style="position:absolute; background-color: #eeeeee; top: 0px; left: 0px; z-index:3; visibility:hidden;"></div>';

    #$r .= '</div>';

    // TAH: adding this to grab edit tokens from javascript
    $token = $wgUser->editToken();
    $r .= "<input type=\"hidden\" value=\"$token\" name=\"wpEditToken\" id=\"wpEditToken\" />\n";
    $r .= "<input type=\"hidden\" id=\"addingtagmessage\" value=\"" . wfMsg('addingtag') . "\">\n";
    $r .= "<input type=\"hidden\" id=\"removingtagmessage\" value=\"" . wfMsg('removingtag') . "\">\n";
    $r .= "<input type=\"hidden\" id=\"addtagsuccessmessage\" value=\"" . wfMsg('addtagsuccess') . "\">\n";
    $r .= "<input type=\"hidden\" id=\"removetagsuccessmessage\" value=\"" . wfMsg('removetagsuccess') . "\">\n";

    $r .= "<input type=\"hidden\" id=\"oneactionatatimemessage\" value=\"" . wfMsg('oneactionatatimemessage') . "\">\n";
    $r .= "<input type=\"hidden\" id=\"canteditneedloginmessage\" value=\"" . wfMsg('canteditneedloginmessage') . "\">\n";
    $r .= "<input type=\"hidden\" id=\"canteditothermessage\" value=\"" . wfMsg('canteditothermessage') . "\">\n";
    $r .= "<input type=\"hidden\" id=\"oneuniquetagmessage\" value=\"" . wfMsg('oneuniquetagmessage') . "\">\n";

    return $r;
  }
}

}
?>
