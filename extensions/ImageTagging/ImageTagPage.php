<?php

class ImageTagPage extends ImagePage {

	function openShowImage() {
		global $wgOut, $wgUser, $wgScriptPath;

		wfProfileIn( __METHOD__ );

		$wgOut->addScriptFile( $wgScriptPath . '/extensions/ImageTagging/img_tagging.js' );
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/ImageTagging/json.js' );

		$imgName = $this->getTitle()->getText();
		$wgOut->addHTML( "<input type='hidden' value='$imgName' id='imgName' />" );
		$wgOut->addHTML( "<input type='hidden' value='$wgScriptPath/extensions/ImageTagging' id='imgPath' />" );

		if ( $wgUser->isLoggedIn() ) {
			$wgOut->addHTML( '<input type="hidden" value="1" id="userLoggedIn" />' );
		}

		if (
			$wgUser->isAllowed( 'edit' ) &&
			$this->mTitle->userCan( 'edit' ) &&
			( $this->mTitle->isProtected( 'edit' ) == false || in_array( 'sysop', $wgUser->getGroups() ) )
		)
		{
			$wgOut->addHTML( '<input type="hidden" value="1" id="canEditPage" />' );
		}

		$this->modifiedImagePageOpenShowImage();

		if ( $this->getFile()->exists() ) {
			$tagList = wfGetImageTags( $this->getFile(), $imgName );

			#if ( $tagList )
			$wgOut->addHTML( "<div id=\"tagListDiv\"><span id=\"tagList\">$tagList</span></div>" );
		}

		wfProfileOut( __METHOD__ );
	}

	function modifiedImagePageOpenShowImage() {
		global $wgOut, $wgUser, $wgImageLimits, $wgRequest, $wgEnableUploads;

		wfProfileIn( __METHOD__ );

		$full_url = $this->getFile()->getURL();
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

		if ( $this->getFile()->exists() ) {
			# image
			$width = $this->getFile()->getWidth();
			$height = $this->getFile()->getHeight();
			$showLink = false;

			if ( $this->getFile()->allowInlineDisplay() && $width && $height) {
				# image

				# "Download high res version" link below the image
				$msg = wfMsgHtml(
					'show-big-image',
					$width, $height,
					intval( $this->getFile()->getSize() / 1024 )
				);

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

					$thumbnail = $this->getFile()->transform(array( 'width' => $width ) , 0 );
					if ( $thumbnail == null ) {
						$url = $this->getFile()->getViewURL();
					} else {
						$url = $thumbnail->getURL();
					}

					$anchoropen  = "<a href=\"{$full_url}\">";
					$anchorclose = "</a><br />";
					if( $this->getFile()->mustRender() ) {
						$showLink = true;
					} else {
						$anchorclose .= "\n$anchoropen{$msg}</a>";
					}
				} else {
					$url = $this->getFile()->getViewURL();
					$showLink = true;
				}

				//$anchoropen = '';
				//$anchorclose = '';
	//			$width = 'auto'; //'100%';
	//			$height = 'auto'; //'100%';
				$wgOut->addHTML(
					'<div class="fullImageLink" id="file">' .
					"<img border=\"0\" src=\"{$url}\" width=\"{$width}\" height=\"{$height}\" style=\"max-width: {$maxWidth}px;\" alt=\"" .
					htmlspecialchars( $wgRequest->getVal( 'image' ) ) . '" />' .
					$anchoropen . $anchorclose . '</div>'
				);
			} else {
				# if direct link is allowed but it's not a renderable image, show an icon.
				if ( $this->getFile()->isSafeFile() ) {
					$icon= $this->getFile()->iconThumb();

					$wgOut->addHTML(
						'<div class="fullImageLink" id="file"><a href="' . $full_url . '">' .
						$icon->toHtml() .
						'</a></div>'
					);
				}

				$showLink = true;
			}

			if ( $showLink ) {
				$filename = wfEscapeWikiText( $this->getFile()->getName() );
				$info = wfMsg(
					'file-info',
					$sk->formatSize( $this->getFile()->getSize() ),
					$this->getFile()->getMimeType()
				);

				if ( !$this->getFile()->isSafeFile() ) {
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

			if( $this->getFile()->fromSharedDirectory ) {
				$this->printSharedImageText();
			}
		} else {
			# Image does not exist
			$nofile = wfMsgHtml( 'filepage-nofile' );
			if ( $wgEnableUploads && $wgUser->isAllowed( 'upload' ) ) {
				// Only show an upload link if the user can upload
				$nofile .= ' '.$sk->makeKnownLinkObj(
					SpecialPage::getTitleFor( 'Upload' ),
					wfMsgHtml( 'filepage-nofile-link' ),
					'wpDestFile=' . urlencode( $this->displayImg->getName() )
				);
			}
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
			$wgOut->addHTML( '<div id="mw-imagepage-nofile">' . $nofile . '</div>' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Create the TOC
	 *
	 * @access private
	 *
	 * @param $metadata Boolean: whether or not to show the metadata link
	 * @return string
	 */
	function showTOC( $metadata ) {
		global $wgLang, $wgUser, $wgScriptPath;

		$metadataHTML = '';
		if ( $metadata ) {
			$metadataHTML = '<li><a href="#metadata">' .
				wfMsgHtml( 'metadata' ) . '</a></li>';
		}

		$r = '<ul id="filetoc">
	<li><a href="#file">' . $wgLang->getNsText( NS_IMAGE ) . '</a></li>
	<li><a href="#filehistory">' . wfMsgHtml( 'imagetagging-imghistory' ) . '</a></li>
	<li><a href="#filelinks">' . wfMsgHtml( 'imagelinks' ) . '</a></li>' .
		$metadataHTML . '
	<li><a href="javascript:addImageTags()">' .
		wfMsgHtml( 'imagetagging-addimagetag' ) . '</a>' .
		wfMsg( 'imagetagging-new' ) .'</li>'
	. '</ul>';

		$r .= '<div id="tagStatusDiv" style="margin: 5px 5px 10px 5px; padding: 10px; border: solid 1px #ffe222; background: #fffbe2; display: none;"><table style="background-color: #fffbe2;"><tr><td width="450" height="30" align="center" style="padding-left: 20px;"><img src="' . $wgScriptPath . '/extensions/ImageTagging/progress-wheel.gif" id="progress_wheel" style="display:none;"><div id="tagging_message" style="background: #fffbe2;">' .
			wfMsgHtml( 'imagetagging-tagging-instructions' ) .
			'</td><td valign="middle"><input type="button" onclick="doneAddingTags();" id="done_tagging" name="done_tagging" value="' .
				wfMsgHtml( 'imagetagging-done-button' ) . '" /></div></td></tr></table></div>';

		$r .= '<div style="position: absolute; font: verdana, sans-serif; top: 10px; left: 10px; display: none; width:284px; height:24px; padding: 4px 6px; background-color: #eeeeee; color: #444444; border: 2px solid #555555; z-index:2;" id="tagEditField">

	<span style="position: absolute; left: 4px; top: 6px;">' .
		wfMsg( 'imagetagging-article' ) . "</span>

	<!-- TAH: don't use the popup just yet
	<select name='tagType'>
	<option selected>Article</option>
	<option>Category</option>
	</select>
	-->";

		$r .= '<input style="position: absolute; left: 189px; top: 6px; width: 39px; height: 20px;" type="submit" name="' . wfMsgHtml( 'imagetagging-tag-button' ) . "' value='" . wfMsgHtml( 'imagetagging-tag-button' ) . '" onclick="submitTag()" />';
		$r .= '<input style="position: absolute; left: 232px; top: 6px; width: 60px; height: 20px;" type="button" name="' . wfMsgHtml( 'imagetagging-tagcancel-button' ) . "' value='" . wfMsgHtml( 'imagetagging-tagcancel-button' ) . '" onclick="hideTagBox()" />';

		$r .= '<input type="text" style="position: absolute; left: 46px; top: 6px; background-color:white; width: 140px; height:18px;" name="articleTag" id="articleTag" value="" title="' . wfMsgHtml( 'imagetagging-articletotag' ) . '" onkeyup="typeTag(event);" />';

		$r .= '</div>';

		$r .= '<div id="popup" style="position:absolute; background-color: #eeeeee; top: 0px; left: 0px; z-index:3; visibility:hidden;"></div>';

		#$r .= '</div>';

		// TAH: adding this to grab edit tokens from javascript
		$token = $wgUser->editToken();
		$r .= "<input type=\"hidden\" value=\"$token\" name=\"wpEditToken\" id=\"wpEditToken\" />\n";
		$r .= "<input type=\"hidden\" id=\"addingtagmessage\" value=\"" . wfMsg( 'imagetagging-addingtag' ) . "\">\n";
		$r .= "<input type=\"hidden\" id=\"removingtagmessage\" value=\"" . wfMsg( 'imagetagging-removingtag' ) . "\">\n";
		$r .= "<input type=\"hidden\" id=\"addtagsuccessmessage\" value=\"" . wfMsg( 'imagetagging-addtagsuccess' ) . "\">\n";
		$r .= "<input type=\"hidden\" id=\"removetagsuccessmessage\" value=\"" . wfMsg( 'imagetagging-removetagsuccess' ) . "\">\n";

		$r .= "<input type=\"hidden\" id=\"oneactionatatimemessage\" value=\"" . wfMsg( 'imagetagging-oneactionatatimemessage' ) . "\">\n";
		$r .= "<input type=\"hidden\" id=\"canteditneedloginmessage\" value=\"" . wfMsg( 'imagetagging-canteditneedloginmessage' ) . "\">\n";
		$r .= "<input type=\"hidden\" id=\"canteditothermessage\" value=\"" . wfMsg( 'imagetagging-canteditothermessage' ) . "\">\n";
		$r .= "<input type=\"hidden\" id=\"oneuniquetagmessage\" value=\"" . wfMsg( 'imagetagging-oneuniquetagmessage' ) . "\">\n";

		return $r;
	}
}
