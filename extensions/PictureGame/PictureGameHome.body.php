<?php

class PictureGameHome extends UnlistedSpecialPage {
	private $SALT;

	/**
	 * Construct the MediaWiki special page
	 */
	public function __construct() {
		parent::__construct( 'PictureGameHome' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut, $wgScriptPath, $wgSupressPageTitle;

		// Is the database locked?
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		// Blocked through Special:Block? No access for you either!
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		$wgSupressPageTitle = true;

		// Salt as you like
		$this->SALT = md5( $wgUser->getName() );

		// Add the main JS file
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/PictureGame/picturegame/PictureGame.js' );

		// What should we do?
		$action = $wgRequest->getVal( 'picGameAction' );

		switch( $action ) {
			case 'startGame':
				$this->renderPictureGame();
				break;
			case 'createGame':
				$this->createGame();
				break;
			case 'castVote':
				$this->voteAndForward();
				break;
			case 'flagImage':
				$this->flagImage();
				break;
			case 'renderPermalink':
				$this->renderPictureGame();
				break;
			case 'gallery':
				$this->displayGallery();
				break;
			case 'editPanel':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'picturegameadmin' ) ) {
					$this->editPanel();
				} else {
					$this->showHomePage();
				}
				break;
			case 'completeEdit':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'picturegameadmin' ) ) {
					$this->completeEdit();
				} else {
					$this->showHomePage();
				}
				break;
			case 'adminPanel':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'picturegameadmin' ) ) {
					$this->adminPanel();
				} else {
					$this->showHomePage();
				}
				break;
			case 'adminPanelUnflag':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'picturegameadmin' ) ) {
					$this->adminPanelUnflag();
				} else {
					$this->showHomePage();
				}
				break;
			case 'adminPanelDelete':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'picturegameadmin' ) ) {
					$this->adminPanelDelete();
				} else {
					$this->showHomePage();
				}
				break;
			case 'protectImages':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'picturegameadmin' ) ) {
					$this->protectImages();
				} else {
					echo wfMsg( 'picturegame-sysmsg-unauthorized' );
				}
				break;
			case 'unprotectImages':
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'picturegameadmin' ) ) {
					$this->unprotectImages();
				} else {
					$this->showHomePage();
				}
				break;
			case 'startCreate':
				if( $wgUser->isBlocked() ) {
					$wgOut->blockedPage( false );
					return '';
				} else {
					$this->showHomePage();
				}
				break;
			default:
				$this->renderPictureGame();
				break;
		}
	}

	/**
	 * Called via AJAX to delete an image out of the game.
	 */
	function adminPanelDelete() {
		global $wgRequest, $wgUser, $wgOut;

		$wgOut->setArticleBodyOnly( true );

		$id = $wgRequest->getInt( 'id' );
		$image1 = addslashes( $wgRequest->getVal( 'img1' ) );
		$image2 = addslashes( $wgRequest->getVal( 'img2' ) );

		$key = $wgRequest->getVal( 'key' );
		$now = $wgRequest->getVal( 'chain' );

		if(
			$key != md5( $now . $this->SALT ) ||
			( !$wgUser->isLoggedIn() || !$wgUser->isAllowed( 'picturegameadmin' ) )
		)
		{
			//echo wfMsg( 'picturegame-sysmsg-badkey' );
			//return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'picturegame_images', array( 'id' => $id ), __METHOD__ );
		$dbw->commit();

		global $wgMemc;
		$key = wfMemcKey( 'user', 'profile', 'picgame', $wgUser->getID() );
		$wgMemc->delete( $key );

		/* Pop the images out of MediaWiki also */
		//$img_one = wfFindFile( $image1 );
		$oneResult = $twoResult = false;
		if( $image1 ) {
			$img_one = Title::makeTitle( NS_FILE, $image1 );
			$article = new Article( $img_one );
			$oneResult = $article->doDeleteArticle( 'Picture Game image 1 Delete' );
		}

		if( $image2 ) {
			$img_two = Title::makeTitle( NS_FILE, $image2 );
			$article = new Article( $img_two );
			$twoResult = $article->doDeleteArticle( 'Picture Game image 2 Delete' );
		}

		if( $oneResult && $twoResult ) {
			echo wfMsg( 'picturegame-sysmsg-successfuldelete' );
			return;
		}

		if( $oneResult ) {
			echo wfMsg( 'picturegame-sysmsg-unsuccessfuldelete', $image1 );
		}
		if( $twoResult ) {
			echo wfMsg( 'picturegame-sysmsg-unsuccessfuldelete', $image2 );
		}
	}

	/**
	 * Called over AJAX to unflag an image
	 */
	function adminPanelUnflag() {
		global $wgRequest, $wgUser, $wgOut;

		$wgOut->setArticleBodyOnly( true );

		$id = $wgRequest->getInt( 'id' );

		$key = $wgRequest->getVal( 'key' );
		$now = $wgRequest->getVal( 'chain' );

		if(
			$key != md5( $now . $this->SALT ) ||
			( !$wgUser->isLoggedIn() || !$wgUser->isAllowed( 'picturegameadmin' ) )
		) {
			echo wfMsg( 'picturegame-sysmsg-badkey' );
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'picturegame_images',
			array( 'flag' => PICTUREGAME_FLAG_NONE ),
			array( 'id' => $id ),
			__METHOD__
		);

		$wgOut->clearHTML();
		echo wfMsg( 'picturegame-sysmsg-unflag' );
	}

	/**
	 * Updates a record in the picture game table.
	 */
	function completeEdit() {
		global $wgRequest, $wgOut;

		$id = $wgRequest->getInt( 'id' );
		$key = addslashes( $wgRequest->getVal( 'key' ) );

		$title = $wgRequest->getVal( 'newTitle' );
		$imgOneCaption = $wgRequest->getVal( 'imgOneCaption' );
		$imgTwoCaption = $wgRequest->getVal( 'imgTwoCaption' );

		if( $key != md5( $id . $this->SALT ) ) {
			$wgOut->addHTML( '<h3>' . wfMsg( 'picturegame-sysmsg-badkey' ) . '</h3>' );
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'picturegame_images',
			array(
				'title' => $title,
				'img1_caption' => $imgOneCaption,
				'img2_caption' => $imgTwoCaption
			),
			array( 'id' => $id ),
			__METHOD__
		);

		/* When it's done, redirect to a permalink of these images */
		$wgOut->setArticleBodyOnly( true );
		header( 'Location: ?title=Special:PictureGameHome&picGameAction=renderPermalink&id=' . $id );
	}

	/**
	 * Displays the edit panel.
	 */
	function editPanel() {
		global $wgRequest, $wgOut, $wgUploadPath, $wgScriptPath, $wgRightsText, $wgHooks, $wgLang;

		$id = $wgRequest->getInt( 'id' );

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'picturegame_images',
			'*',
			array( 'id' => $id ),
			__METHOD__
		);

		$row = $dbw->fetchObject( $res );
		if ( empty( $row ) ) {
			$wgOut->addHTML( wfMsg( 'picturegame-nothing-to-edit' ) );
			return;
		}

		$imgID = $row->id;
		$user_name = $wgLang->truncate( $row->username, 20 );

		$title_text = $row->title;
		$img1_caption_text = $row->img1_caption;
		$img2_caption_text = $row->img2_caption;

		// I assume MediaWiki does some caching with these functions?
		$img_one = wfFindFile( $row->img1 );
		$imgOneWidth = 0;
		$thumb_one_url = $thumb_two_url = '';
		if ( is_object( $img_one ) ) {
			$thumb_one_url = $img_one->createThumb( 128 );
			if ( $img_one->getWidth() >= 128 ) {
				$imgOneWidth = 128;
			} else {
				$imgOneWidth = $img_one->getWidth();
			}
		}
		$imgOne = '<img width="' . $imgOneWidth . '" alt="" src="' .
			$thumb_one_url . '?' . time() . '"/>';
		$imgOneName = $row->img1;

		$img_two = wfFindFile( $row->img2 );
		$imgTwoWidth = 0;
		if ( is_object( $img_two ) ) {
			$thumb_two_url = $img_two->createThumb( 128 );
			if ( $img_one->getWidth() >= 128 ) {
				$imgTwoWidth = 128;
			} else {
				$imgTwoWidth = $img_one->getWidth();
			}
		}
		$imgTwo = '<img width="' . $imgTwoWidth . '" alt="" src="' .
			$thumb_two_url . '?' . time() . '"/>';
		$imgTwoName = $row->img2;

		$wgHooks['MakeGlobalVariablesScript'][] = 'PictureGameHome::addJSGlobals';
		$output = '';

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/PictureGame/picturegame/editpanel.css' );

		$wgOut->setPageTitle( wfMsg( 'picturegame-editgame-editing-title', $title_text ) );

		$id = User::idFromName( $row->username );
		$avatar = new wAvatar( $id, 'l' );
		$avatarID = $avatar->getAvatarImage();
		$stats = new UserStats( $id, $row->username );
		$stats_data = $stats->getUserStats();

		if ( $wgRightsText ) {
			$copywarnMsg = 'copyrightwarning';
			$copywarnMsgParams = array(
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$wgRightsText
			);
		} else {
			$copywarnMsg = 'copyrightwarning2';
			$copywarnMsgParams = array(
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]'
			);
		}

		$usrTitleObj = Title::makeTitle( NS_USER, $row->username );
		$imgPath = $wgScriptPath . '/extensions/PictureGame/images';

		$output .= '<div id="edit-container" class="edit-container">
			<form id="picGameVote" name="picGameVote" method="post" action="' .
			$this->getTitle()->escapeFullURL( 'picGameAction=completeEdit' ) . '">
			<div id="edit-textboxes" class="edit-textboxes">

				<div class="credit-box-edit" id="creditBox">
					<h1>' . wfMsg( 'picturegame-submittedby' ) . '</h1>
					<div class="submitted-by-image">
						<a href="' . $usrTitleObj->escapeFullURL() . "\">
							<img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\" alt=\"\" border=\"0\"/>
						</a>
					</div>
					<div class=\"submitted-by-user\">
						<a href=\"" . $usrTitleObj->escapeFullURL() . "\">{$user_name}</a>
						<ul>
							<li>
								<img src=\"{$imgPath}/voteIcon.gif\" border=\"0\" alt=\"\" />
								{$stats_data['votes']}
							</li>
							<li>
								<img src=\"{$imgPath}/pencilIcon.gif\" border=\"0\" alt=\"\" />
								{$stats_data['edits']}
							</li>
							<li>
								<img src=\"{$imgPath}/commentsIcon.gif\" border=\"0\" alt=\"\" />
								{$stats_data['comments']}
							</li>
						</ul>
					</div>
					<div class=\"cleared\"></div>
				</div>


				<h1>" . wfMsg( 'picturegame-editgamegametitle' ) . "</h1>
				<p><input name=\"newTitle\" id=\"newTitle\" type=\"text\" value=\"{$title_text}\" size=\"40\"/></p>
					<input id=\"key\" name=\"key\" type=\"hidden\" value=\"" . md5( $imgID . $this->SALT ) . "\" />
					<input id=\"id\" name=\"id\" type=\"hidden\" value=\"{$imgID}\" />

			</div>
			<div class=\"edit-images-container\">
				<div id=\"edit-images\" class=\"edit-images\">
					<div id=\"edit-image-one\" class=\"edit-image-one\">
						<h1>" . wfMsg( 'picturegame-createeditfirstimage' ) . "</h1>
						<p><input name=\"imgOneCaption\" id=\"imgOneCaption\" type=\"text\" value=\"{$img1_caption_text}\" /></p>
						<p id=\"image-one-tag\">{$imgOne}</p>
						<p><a href=\"javascript:PictureGame.loadUploadFrame('{$imgOneName}', 1)\">" .
							wfMsg( 'picturegame-editgameuploadtext' ) . '</a></p>
					</div>

					<div id="edit-image-two" class="edit-image-one">
						<h1>' . wfMsg( 'picturegame-createeditsecondimage' ) . "</h1>
						<p><input name=\"imgTwoCaption\" id=\"imgTwoCaption\" type=\"text\" value=\"{$img2_caption_text}\" /></p>
						<p id=\"image-two-tag\">{$imgTwo}</p>
						<p><a href=\"javascript:PictureGame.loadUploadFrame('{$imgTwoName}', 2)\">" .
							wfMsg( 'picturegame-editgameuploadtext' ) . "</a></p>
					</div>

					<div id=\"loadingImg\" class=\"loadingImg\" style=\"display:none\">
						<img src=\"{$imgPath}/ajax-loader-white.gif\" alt=\"\" />
					</div>

					<div class=\"cleared\"></div>

				</div>

				<div class=\"edit-image-frame\" id=\"edit-image-frame\" style=\"display:hidden\">
					<div class=\"edit-image-text\" id=\"edit-image-text\"></div>
					<iframe frameborder=\"0\" scrollbar=\"no\" class=\"upload-frame\" id=\"upload-frame\" src=\"\"></iframe>
				</div>

				<div class=\"cleared\"></div>
			</div>

			<div class=\"copyright-warning\">" .
				wfMsgExt( $copywarnMsg, 'parse', $copywarnMsgParams ) .
			'</div>

			<div id="complete-buttons" class="complete-buttons">
				<input type="button" onclick="document.picGameVote.submit()" value="' . wfMsg( 'picturegame-buttonsubmit' ) . "\"/>
				<input type=\"button\" onclick=\"window.location='" .
					$this->getTitle()->escapeFullURL( "picGameAction=renderPermalink&id={$imgID}" ) . "'\" value=\"" .
					wfMsg( 'picturegame-buttoncancel' ) . "\"/>
			</div>
		</form>
		</div>";

		$wgOut->addHTML( $output );
	}

	/**
	 * Displays the admin panel.
	 */
	function adminPanel() {
		global $wgRequest, $wgUser, $wgOut, $wgScriptPath, $wgLang;

		$now = time();
		$key = md5( $now . $this->SALT );

		$output = '<script type="text/javascript">
			var __admin_panel_now__ = "' . $now . '";
			var __admin_panel_key__ = "' . $key . '";
		</script>';

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/PictureGame/picturegame/adminpanel.css' );

		$wgOut->setPageTitle( wfMsg( 'picturegame-adminpaneltitle' ) );
		$output .= '
		<div class="back-link">
			<a href="' . $this->getTitle()->escapeFullURL( 'picGameAction=startGame' ) . '"> ' .
				wfMsg( 'picturegame-adminpanelbacktogame' ) . '</a>
		</div>

		<div id="admin-container" class="admin-container">
			<p><strong>' . wfMsg( 'picturegame-adminpanelflagged' ) . '</strong></p>';

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'picturegame_images',
			array( 'id', 'img1', 'img2' ),
			array(
				'flag' => PICTUREGAME_FLAG_FLAGGED,
				"img1 <> ''",
				"img2 <> ''"
			),
			__METHOD__
		);

		// If we have nothing, indicate that in the UI instead of showing...
		// well, nothing
		if ( $dbw->numRows( $res ) <= 0 ) {
			$output .= wfMsg( 'picturegame-none' );
		}

		foreach ( $res as $row ) {
			$img_one_tag = $img_two_tag = '';
			$img_one = wfFindFile( $row->img1 );
			if ( is_object( $img_one ) ) {
				$thumb_one = $img_one->transform( array( 'width' => 128 ) );
				$img_one_tag = $thumb_one->toHtml();
			}

			$img_two = wfFindFile( $row->img2 );
			if ( is_object( $img_two ) ) {
				$thumb_two = $img_two->transform( array( 'width' => 128 ) );
				$img_two_tag = $thumb_two->toHtml();
			}

			$img_one_description = $wgLang->truncate( $row->img1, 12 );
			$img_two_description = $wgLang->truncate( $row->img2, 12 );

			$output .= '<div id="' . $row->id . "\" class=\"admin-row\">

				<div class=\"admin-image\">
					<p>{$img_one_tag}</p>
					<p><b>{$img_one_description}</b></p>
				</div>
				<div class=\"admin-image\">
					<p>{$img_two_tag}</p>
					<p><b>{$img_two_description}</b></p>
				</div>
				<div class=\"admin-controls\">
					<a href=\"javascript:PictureGame.unflag({$row->id})\">" .
						wfMsg( 'picturegame-adminpanelreinstate' ) .
					"</a> |
					<a href=\"javascript:PictureGame.deleteimg(" . $row->id . ", '" . $row->img1 . "', '" . $row->img2 . "')\">"
						. wfMsg( 'picturegame-adminpaneldelete' ) .
					'</a>
				</div>
				<div class="cleared"></div>

			</div>';
		}

		$output .= '</div>
		<div id="admin-container" class="admin-container">
			<p><strong>' . wfMsg( 'picturegame-adminpanelprotected' ) . '</strong></p>';
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'picturegame_images',
			array( 'id', 'img1', 'img2' ),
			array(
				'flag' => PICTUREGAME_FLAG_PROTECT,
				"img1 <> ''", "img2 <> ''"
			),
			__METHOD__
		);

		// If we have nothing, indicate that in the UI instead of showing...
		// well, nothing
		if ( $dbw->numRows( $res ) <= 0 ) {
			$output .= wfMsg( 'picturegame-none' );
		}

		foreach ( $res as $row ) {
			$img_one_tag = $img_two_tag = '';
			$img_one = wfFindFile( $row->img1 );
			if ( is_object( $img_one ) ) {
				$thumb_one = $img_one->transform( array( 'width' => 128 ) );
				$img_one_tag = $thumb_one->toHtml();
			}

			$img_two = wfFindFile( $row->img2 );
			if ( is_object( $img_two ) ) {
				$thumb_two = $img_two->transform( array( 'width' => 128 ) );
				$img_two_tag = $thumb_two->toHtml();
			}

			$img_one_description = $wgLang->truncate( $row->img1, 12 );
			$img_two_description = $wgLang->truncate( $row->img2, 12 );

			$output .= '<div id="' . $row->id . "\" class=\"admin-row\">

				<div class=\"admin-image\">
					<p>{$img_one_tag}</p>
					<p><b>{$img_one_description}</b></p>
				</div>
				<div class=\"admin-image\">
					<p>{$img_two_tag}</p>
					<p><b>{$img_two_description}</b></p>
				</div>
				<div class=\"admin-controls\">
					<a href=\"javascript:PictureGame.unprotect({$row->id})\">" .
						wfMsg( 'picturegame-adminpanelunprotect' ) .
					"</a> |
					<a href=\"javascript:PictureGame.deleteimg(" . $row->id . ", '" . $row->img1 . "', '" . $row->img2 . "')\">"
						. wfMsg( 'picturegame-adminpaneldelete' ) .
					'</a>
				</div>
				<div class="cleared"></div>

			</div>';
		}

		$output .= '</div>';

		$wgOut->addHTML( $output );
	}

	/**
	 * Called with AJAX to flag an image.
	 */
	function flagImage() {
		global $wgRequest, $wgOut;

		$wgOut->setArticleBodyOnly( true );

		$id = $wgRequest->getInt( 'id' );
		$key = $wgRequest->getVal( 'key' );

		if( $key != md5( $id . $this->SALT ) ) {
			echo wfMsg( 'picturegame-sysmsg-badkey' );
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'picturegame_images',
			array( 'flag' => PICTUREGAME_FLAG_FLAGGED ),
			array( 'id' => $id, 'flag' => PICTUREGAME_FLAG_NONE ),
			__METHOD__
		);

		$wgOut->clearHTML();
		echo '<div style="color:red; font-weight:bold; font-size:16px; margin:-5px 0px 20px 0px;">' .
			wfMsg( 'picturegame-sysmsg-flag' ) .
		'</div>';
	}

	/**
	 * Called with AJAX to unprotect an image set.
	 */
	function unprotectImages() {
		global $wgRequest, $wgOut;

		$wgOut->setArticleBodyOnly( true );

		$id = $wgRequest->getInt( 'id' );
		$key = $wgRequest->getVal( 'key' );
		$chain = $wgRequest->getVal( 'chain' );

		if( $key != md5( $chain . $this->SALT ) ) {
			echo wfMsg( 'picturegame-sysmsg-badkey' );
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'picturegame_images',
			array( 'flag' => PICTUREGAME_FLAG_NONE ),
			array( 'id' => $id ),
			__METHOD__
		);

		$wgOut->clearHTML();
		echo wfMsg( 'picturegame-sysmsg-unprotect' );
	}

	/**
	 * Protects an image set.
	 */
	function protectImages() {
		global $wgRequest, $wgOut;

		$wgOut->setArticleBodyOnly( true );

		$id = $wgRequest->getInt( 'id' );
		$key = $wgRequest->getVal( 'key' );

		if( $key != md5( $id . $this->SALT ) ) {
			echo wfMsg( 'picturegame-sysmsg-badkey' );
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'picturegame_images',
			array( 'flag' => PICTUREGAME_FLAG_PROTECT ),
			array( 'id' => $id ),
			__METHOD__
		);

		$wgOut->clearHTML();
		echo wfMsg( 'picturegame-sysmsg-protect' );
	}

	function displayGallery() {
		global $wgRequest, $wgUser, $wgOut, $wgScriptPath, $wgLang;

		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg( 'picturegame-gallery' ) ) );

		$type = $wgRequest->getVal( 'type' );
		$direction = $wgRequest->getVal( 'direction' );

		if( ( $type == 'heat' ) && ( $direction == 'most' ) ) {
			$crit = 'Heat';
			$order = 'ASC';
			$sortheader = wfMsg( 'picturegame-sorted-most-heat' );
		} elseif( ( $type == 'heat' ) && ( $direction == 'least' ) ) {
			$crit = 'Heat';
			$order = 'DESC';
			$sortheader = wfMsg( 'picturegame-sorted-least-heat' );
		} elseif( ( $type == 'votes' ) && ( $direction == 'most' ) ) {
			$crit = '(img0_votes + img1_votes)';
			$order = 'DESC';
			$sortheader = wfMsg( 'picturegame-sorted-most-votes' );
		} elseif( ( $type == 'votes' ) && ( $direction == 'least' ) ) {
			$crit = '(img0_votes + img1_votes)';
			$order = 'ASC';
			$sortheader = wfMsg( 'picturegame-sorted-least-votes' );
		} else {
			$type = 'heat';
			$direction = 'most';
			$crit = 'Heat';
			$order = 'ASC';
			$sortheader = wfMsg( 'picturegame-sorted-most-heat' );
		}

		if ( isset( $sortheader ) ) {
			$wgOut->setPageTitle( $sortheader );
		}

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/PictureGame/picturegame/gallery.css' );
		$output = '<div class="picgame-gallery-navigation">';

		if( $type == 'votes' && $direction == 'most' ) {
			$output .= '<h1>' . wfMsg( 'picturegame-most' ) . '</h1>
					<p><b>' . wfMsg( 'picturegame-mostvotes' ) . '</b></p>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'heat',
						'direction' => 'most'
					) ) . '">' . wfMsg( 'picturegame-mostheat' ) . '</a></p>

					<h1 style="margin:10px 0px !important;">' . wfMsg( 'picturegame-least' ) . '</h1>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'votes',
						'direction' => 'least'
					) ) . '">' . wfMsg( 'picturegame-leastvotes' ) . '</a></p>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'heat',
						'direction' => 'least'
					) ) . '">' . wfMsg( 'picturegame-leastheat' ) . '</a></p>';
		}

		if( $type == 'votes' && $direction == 'least' ) {
			$output .= '<h1>' . wfMsg( 'picturegame-most' ) . '</h1>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'votes',
						'direction' => 'most'
					) ) . '">' . wfMsg( 'picturegame-mostvotes' ) . '</a></p>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'heat',
						'direction' => 'most'
					) ) . '">' . wfMsg( 'picturegame-mostheat' ) . '</a></p>

					<h1 style="margin:10px 0px !important;">' . wfMsg( 'picturegame-least' ) . '</h1>
					<p><b>' . wfMsg( 'picturegame-leastvotes' ) . '</b></p>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'heat',
						'direction' => 'least'
					) ) . '">' . wfMsg( 'picturegame-leastheat' ) . '</a></p>';
		}

		if( $type == 'heat' && $direction == 'most' ) {
			$output .= '<h1>' . wfMsg( 'picturegame-most' ) . '</h1>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'votes',
						'direction' => 'most'
					) ) . '">' . wfMsg( 'picturegame-mostvotes' ) . '</a></p>
					<p><b>' . wfMsg( 'picturegame-mostheat' ) . '</b></p>

					<h1 style="margin:10px 0px !important;">' . wfMsg( 'picturegame-least' ) . '</h1>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'votes',
						'direction' => 'least'
					) ) . '">' . wfMsg( 'picturegame-leastvotes' ) . '</a></p>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'heat',
						'direction' => 'least'
					) ) . '">' . wfMsg( 'picturegame-leastheat' ) . '</a></p>';
		}

		if( $type == 'heat' && $direction == 'least' ) {
			$output .= '<h1>' . wfMsg( 'picturegame-most' ) . '</h1>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'votes',
						'direction' => 'most'
					) ) . '">' . wfMsg( 'picturegame-mostvotes' ) . '</a></p>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'heat',
						'direction' => 'most'
					) ) . '">' . wfMsg( 'picturegame-mostheat' ) . '</a></p>

					<h1 style="margin:10px 0px !important;">' . wfMsg( 'picturegame-least' ) . '</h1>
					<p><a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'type' => 'votes',
						'direction' => 'least'
					) ) . '">' . wfMsg( 'picturegame-leastvotes' ) . '</a></p>
					<p><b>' . wfMsg( 'picturegame-leastheat' ) . '</b></p>';
		}

		$output .= '</div>';

		$output .= '<div class="picgame-gallery-container" id="picgame-gallery-thumbnails">';

		$per_row = 3;
		$x = 1;

		$dbr = wfGetDB( DB_SLAVE );
		$total = (int)$dbr->selectField(
			'picturegame_images',
			array( 'COUNT(*) AS mycount' ),
			array(),
			__METHOD__
		);

		// We have nothing? If so, inform the user about it...
		if ( $total == 0 ) {
			$output .= wfMsg( 'picturegame-gallery-empty' );
		}

		$page = $wgRequest->getInt( 'page', 1 );

		// Add limit to SQL
		$per_page = 9;
		$limit = $per_page;

		$limitvalue = 0;
		if( $limit > 0 && $page ) {
			$limitvalue = $page * $limit - ( $limit );
		}

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'picturegame_images',
			'*',
			array(
				'flag <> ' . PICTUREGAME_FLAG_FLAGGED,
				"img1 <> ''",
				"img2 <> ''"
			),
			__METHOD__,
			array(
				'ORDER BY' => "{$crit} {$order}",
				'OFFSET' => $limitvalue,
				'LIMIT' => $limit
			)
		);

		$preloadImages = array();

		foreach( $res as $row ) {
			$gameid = $row->id;

			$title_text = $wgLang->truncate( $row->title, 23 );

			$imgOneCount = $row->img0_votes;
			$imgTwoCount = $row->img1_votes;
			$totalVotes = $imgOneCount + $imgTwoCount;

			if( $imgOneCount == 0 ) {
				$imgOnePercent = 0;
			} else {
				$imgOnePercent = floor( $imgOneCount / $totalVotes  * 100 );
			}

			if( $imgTwoCount == 0 ) {
				$imgTwoPercent = 0;
			} else {
				$imgTwoPercent = 100 - $imgOnePercent;
			}

			$gallery_thumbnail_one = $gallery_thumbnail_two = '';
			$img_one = wfFindFile( $row->img1 );
			if ( is_object( $img_one ) ) {
				$gallery_thumb_image_one = $img_one->transform( array( 'width' => 80) );
				$gallery_thumbnail_one = $gallery_thumb_image_one->toHtml();
			}

			$img_two = wfFindFile( $row->img2 );
			if ( is_object( $img_two ) ) {
				$gallery_thumb_image_two = $img_two->transform( array( 'width' => 80 ) );
				$gallery_thumbnail_two = $gallery_thumb_image_two->toHtml();
			}

			$output .= "
			<div class=\"picgame-gallery-thumbnail\" id=\"picgame-gallery-thumbnail-{$x}\" onclick=\"javascript:document.location=wgScriptPath+'/index.php?title=Special:PictureGameHome&picGameAction=renderPermalink&id={$gameid}'\" onmouseover=\"PictureGame.doHover('picgame-gallery-thumbnail-{$x}')\" onmouseout=\"PictureGame.endHover('picgame-gallery-thumbnail-{$x}')\">
			<h1>{$title_text} ({$totalVotes})</h1>

				<div class=\"picgame-gallery-thumbnailimg\">
					{$gallery_thumbnail_one}
					<p>{$imgOnePercent}%</p>
				</div>

				<div class=\"picgame-gallery-thumbnailimg\">
					{$gallery_thumbnail_two}
					<p>{$imgTwoPercent}%</p>
				</div>

				<div class=\"cleared\"></div>
			</div>";

			if( $x != 1 && $x % $per_row == 0 ) {
				$output .= '<div class="cleared"></div>';
			}
			$x++;
		}

		$output .= '</div>';

		// Page Nav
		$numofpages = ceil( $total / $per_page );

		if( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';

			if( $page > 1 ) {
				$output .= '<a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'page' => ( $page - 1 ),
						'type' => $type,
						'direction' => $direction
					) ) . '">' . wfMsg( 'picturegame-prev' ) . '</a> ';
			}

			for( $i = 1; $i <= $numofpages; $i++ ) {
				if( $i == $page ) {
					$output .= ( $i . ' ' );
				} else {
					$output .= '<a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'page' => $i,
						'type' => $type,
						'direction' => $direction
					) ) . "\">{$i}</a> ";
				}
			}

			if( $page < $numofpages ) {
				$output .= ' <a href="' . $this->getTitle()->escapeFullURL( array(
						'picGameAction' => 'gallery',
						'page' => ( $page + 1 ),
						'type' => $type,
						'direction' => $direction
					) ) . '">' . wfMsg( 'picturegame-next' ) . '</a>';
			}

			$output .= '</div>';
		}

		$wgOut->addHTML( $output );
	}

	/**
	 * Cast a user vote.
	 * The JS takes care of redirecting the page.
	 */
	function voteAndForward() {
		global $wgRequest, $wgUser, $wgOut;

		$wgOut->setArticleBodyOnly( true );

		$key = $wgRequest->getVal( 'key' );
		$next_id = $wgRequest->getVal( 'nextid' );
		$id = $wgRequest->getInt( 'id' );
		$img = addslashes( $wgRequest->getVal( 'img' ) );

		$imgnum = ( $img == 0 ) ? 0 : 1;

		if( $key != md5( $id . $this->SALT ) ) {
			$wgOut->addHTML( wfMsg( 'picturegame-sysmsg-badkey' ) );
			return;
		}

		if( strlen( $id ) > 0 && strlen( $img ) > 0 ) {
			$dbw = wfGetDB( DB_MASTER );

			// check if the user has voted on this already
			// @todo FIXME: in both cases we can just use selectField(), I think
			$res = $dbw->select(
				'picturegame_votes',
				array( 'COUNT(*) AS mycount' ),
				array(
					'username' => $wgUser->getName(),
					'picid' => $id
				),
				__METHOD__
			);
			$row = $dbw->fetchObject( $res );

			// if they haven't, then check if the id exists and then insert the
			// vote
			if( $row->mycount == 0 ) {
				$res = $dbw->select(
					'picturegame_images',
					array( 'COUNT(*) AS mycount' ),
					array( 'id' => $id ),
					__METHOD__
				);
				$row = $dbw->fetchObject( $res );

				if( $row->mycount == 1 ) {
					$dbw->insert(
						'picturegame_votes',
						array(
							'picid' => $id,
							'userid' => $wgUser->getID(),
							'username' => $wgUser->getName(),
							'imgpicked' => $imgnum,
							'vote_date' => date( 'Y-m-d H:i:s' )
						),
						__METHOD__
					);

					$sql = "UPDATE picturegame_images SET img" . $imgnum . "_votes=img" . $imgnum . "_votes+1,
						heat=ABS( ( img0_votes / ( img0_votes+img1_votes) ) - ( img1_votes / ( img0_votes+img1_votes ) ) )
						WHERE id=" . $id . ";";
					$res = $dbw->query( $sql, __METHOD__ );
					/*$res = $dbw->update(
						'picturegame_images',
						array(
							"img{$imgnum}_votes = img{$imgnum}_votes + 1",
							"heat = ABS( ( img0_votes / ( img0_votes+img1_votes) ) - ( img1_votes / ( img0_votes+img1_votes ) ) )"
						),
						array( 'id' => $id ),
						__METHOD__
					);*/

					// Increase social statistics
					$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
					$stats->incStatField( 'picturegame_vote' );
				}
			}
		}

		$wgOut->addHTML( 'OK' );
	}

	/**
	 * Fetches the two images to be voted on
	 *
	 * @param $isPermalink Boolean: false by default
	 * @param $imgID Integer: is present if rendering a permalink
	 * @param $lastID Integer: optional; the last image ID the user saw
	 */
	function getImageDivs( $isPermalink = false, $imgID = -1, $lastID = -1 ) {
		global $wgRequest, $wgUser, $wgOut, $wgScriptPath, $wgUseEditButtonFloat, $wgUploadPath, $wgLang;

		$totalVotes = 0;

		$dbr = wfGetDB( DB_SLAVE );

		// if imgID is -1 then we need some random IDs
		if( $imgID == -1 ) {
			$query = $dbr->select(
				'picturegame_votes',
				'picid',
				array( 'username' => $wgUser->getName() ),
				__METHOD__
			);
			$picIds = array();
			foreach ( $query as $resultRow ) {
				$picIds[] = $resultRow->picid;
			}

			// If there are no picture games in the database, the above query
			// won't add anything to the picIds array, and trying to implode
			// an empty array...well, you'll get id NOT IN () which in turn is
			// invalid SQL.
			if ( !empty( $picIds ) ) {
				$res = $dbr->select(
					'picturegame_images',
					'*',
					array(
						'id NOT IN (' . implode( ',', $picIds ) . ')',
						'flag <> ' . PICTUREGAME_FLAG_FLAGGED,
						"img1 <> ''",
						"img2 <> ''"
					),
					__METHOD__,
					array( 'LIMIT' => 1 )
				);
				/*$sql = "SELECT * FROM picturegame_images WHERE picturegame_images.id NOT IN
					(SELECT picid FROM picturegame_votes WHERE picturegame_votes.username='" . $dbr->strencode( $wgUser->getName() ) . "')
					AND flag <> " . PICTUREGAME_FLAG_FLAGGED . " AND img1 <> '' AND img2 <> '' LIMIT 1;";
				$res = $dbr->query( $sql, __METHOD__ );*/
				$row = $dbr->fetchObject( $res );
				$imgID = isset( $row->id ) ? $row->id : 0;
			}
			$imgID = 0;
		} else {
			$res = $dbr->select(
				'picturegame_images',
				'*',
				array(
					'flag <> ' . PICTUREGAME_FLAG_FLAGGED,
					"img1 <> ''",
					"img2 <> ''",
					'id' => $imgID
				),
				__METHOD__
			);
			$row = $dbr->fetchObject( $res );
		}

		// Early return here in case if we have *nothing* in the database to
		// prevent fatals etc.
		if( empty( $row ) ) {
			$wgOut->setPageTitle( wfMsg( 'picturegame-nomoretitle' ) );
			// can't use addWikiMsg() because we can't make an internal link
			// to Special:PictureGameHome?picGameAction=startCreate :P
			$wgOut->addHTML( wfMsg( 'picturegame-empty',
				$this->getTitle()->escapeFullURL( 'picGameAction=startCreate' )
			) );
			return;
		}

		$user_title = Title::makeTitle( NS_USER, $row->username );

		if( $imgID ) {
			global $wgPictureGameID;
			$wgPictureGameID = $imgID;
			$toExclude = $dbr->select(
				'picturegame_votes',
				'picid',
				array( 'username' => $wgUser->getName() ),
				__METHOD__
			);

			$excludedImgIds = array();
			foreach ( $toExclude as $excludedRow ) {
				$excludedImgIds[] = $excludedRow->picid;
			}

			$next_id = 0;

			if ( !empty( $excludedImgIds ) ) {
				$nextres = $dbr->select(
					'picturegame_images',
					'*',
					array(
						"id <> {$imgID}",
						'id NOT IN (' . implode( ',', $excludedImgIds ) . ')',
						'flag != ' . PICTUREGAME_FLAG_FLAGGED,
						"img1 <> ''",
						"img2 <> ''"
					),
					__METHOD__,
					array( 'LIMIT' => 1 )
				);
				/*$sql = "SELECT * FROM picturegame_images WHERE picturegame_images.id <> {$imgID} AND picturegame_images.id NOT IN
						(SELECT picid FROM picturegame_votes WHERE picturegame_votes.username='" . $dbr->strencode( $wgUser->getName() ) . "')
					AND flag != " . PICTUREGAME_FLAG_FLAGGED . " AND img1 <> '' AND img2 <> '' LIMIT 1;";
				$nextres = $dbr->query( $sql, __METHOD__ );*/
				$nextrow = $dbr->fetchObject( $nextres );
				$next_id = ( isset( $nextrow->id ) ? $nextrow->id : 0 );
			}

			if( $next_id ) {
				$img_one = wfFindFile( $nextrow->img1 );
				if( is_object( $img_one ) ) {
					$preload_thumb = $img_one->transform( array( 'width' => 256 ) );
				}
				if( is_object( $preload_thumb ) ) {
					$preload_one_tag = $preload_thumb->toHtml();
				}

				$img_two = wfFindFile( $nextrow->img2 );
				if( is_object( $img_two ) ) {
					$preload_thumb = $img_two->transform( array( 'width' => 256 ) );
				}
				if( is_object( $preload_thumb ) ) {
					$preload_two_tag = $preload_thumb->toHtml();
				}

				$preload = $preload_one_tag . $preload_two_tag;
			}
		}

		if( ( $imgID < 0 ) || !is_numeric( $imgID ) || is_null( $row ) ) {
			$wgOut->setPageTitle( wfMsg( 'picturegame-nomoretitle' ) );

			// @todo FIXME: fugly i18n
			$out = '<div>' .
				wfMsg( 'picturegame-nomore' ) . '<br />' .
				wfMsg( 'picturegame-nomore-2' ) .
				'<a href="' . $this->getTitle()->escapeFullURL( 'picGameAction=startCreate' ) . '">'
					. wfMsg( 'picturegame-nomorecreatelink' ) .
				'</a> ' . wfMsg( 'picturegame-nomoreor' ) .
				' <a href="' . $wgScriptPath . '/index.php?title=Special:RandomPoll">'
					. wfMsg( 'picturegame-nomoretakepolls' ) .
				'</a>
			</div>';

			return $out;
		}

		// snag the images to vote on and grab some thumbnails
		// modify this query so that if the current user has voted on this
		// image pair don't show it again
		$imgOneCount = $row->img0_votes;
		$imgTwoCount = $row->img1_votes;

		$user_name = $wgLang->truncate( $row->username, 20 );

		$title_text_length = strlen( $row->title );
		$title_text_space = stripos( $row->title, ' ' );

		if( ( $title_text_space == false || $title_text_space >= '48' ) && $title_text_length > 48 ) {
			$title_text = substr( $row->title, 0, 48 ) . '<br />' .
				substr( $row->title, 48, 48 );
		} elseif( $title_text_length > 48 && substr( $row->title, 48, 1 ) == ' ' ) {
			$title_text = substr( $row->title, 0, 48 ) . '<br />' .
				substr( $row->title, 48, 48 );
		} elseif( $title_text_length > 48 && substr( $row->title, 48, 1 ) != ' ' ) {
			$title_text_lastspace = strrpos( substr( $row->title, 0, 48 ), ' ' );
			$title_text = substr( $row->title, 0, $title_text_lastspace ) .
				'<br />' . substr( $row->title, $title_text_lastspace, 30 );
		} else {
			$title_text = $row->title;
		}

		$x = 1;
		$img1_caption_text = '';
		$img1caption_array = str_split( $row->img1_caption );
		foreach( $img1caption_array as $img1_character ) {
			if( $x % 30 == 0 ) {
				$img1_caption_text .= $img1_character . '<br />';
			} else {
				$img1_caption_text .= $img1_character;
			}
			$x++;
		}

		$x = 1;
		$img2_caption_text = '';
		$img1caption_array = str_split( $row->img2_caption );
		foreach( $img1caption_array as $img2_character ) {
			if( $x % 30 == 0 ) {
				$img2_caption_text .= $img2_character . '<br />';
			} else {
				$img2_caption_text .= $img2_character;
			}
			$x++;
		}

		// I assume MediaWiki does some caching with these functions
		$img_one = wfFindFile( $row->img1 );
		$thumb_one_url = '';
		if( is_object( $img_one ) ) {
			$thumb_one_url = $img_one->createThumb( 256 );
			$imageOneWidth = $img_one->getWidth();
		}
		//$imgOne = '<img width="' . ( $imageOneWidth >= 256 ? 256 : $imageOneWidth ) . '" alt="" src="' . $thumb_one_url . ' "/>';
		//$imageOneWidth = ( $imageOneWidth >= 256 ? 256 : $imageOneWidth );
		//$imageOneWidth += 10;
		$imgOne = '<img style="width:100%;" alt="" src="' . $thumb_one_url . ' "/>';

		$img_two = wfFindFile( $row->img2 );
		$thumb_two_url = '';
		if( is_object( $img_two ) ) {
			$thumb_two_url = $img_two->createThumb( 256 );
			$imageTwoWidth = $img_two->getWidth();
		}
		//$imgTwo = '<img width="' . ( $imageTwoWidth >= 256 ? 256 : $imageTwoWidth ) . '" alt="" src="' . $thumb_two_url . ' "/>';
		//$imageTwoWidth = ( $imageTwoWidth >= 256 ? 256 : $imageTwoWidth );
		//$imageTwoWidth += 10;
		$imgTwo = '<img style="width:100%;" alt="" src="' . $thumb_two_url . ' " />';

		$title = $title_text;
		$img1_caption = $img1_caption_text;
		$img2_caption = $img2_caption_text;

		$vote_one_tag = '';
		$vote_two_tag = '';
		$imgOnePercent = '';
		$barOneWidth = '';
		$imgTwoPercent = '';
		$barTwoWidth = '';
		$permalinkJS = '';

		$isShowVotes = false;
		if( $lastID > 0 ) {
			$res = $dbr->select(
				'picturegame_images',
				'*',
				array(
					'flag <> ' . PICTUREGAME_FLAG_FLAGGED,
					'id' => $lastID
				),
				__METHOD__
			);
			$row = $dbr->fetchObject( $res );

			if( $row ) {
				$img_one = wfFindFile( $row->img1 );
				$img_two = wfFindFile( $row->img2 );
				$imgOneCount = $row->img0_votes;
				$imgTwoCount = $row->img1_votes;
				$isShowVotes = true;
			}
		}

		if( $isPermalink || $isShowVotes ) {
			if( is_object( $img_one ) ) {
				$vote_one_thumb = $img_one->transform( array( 'width' => 40 ) );
			}
			if( is_object( $vote_one_thumb ) ) {
				$vote_one_tag = $vote_one_thumb->toHtml();
			}

			if( is_object( $img_two ) ) {
				$vote_two_thumb = $img_two->transform( array( 'width' => 40 ) );
			}
			if( is_object( $vote_two_thumb ) ) {
				$vote_two_tag = $vote_two_thumb->toHtml();
			}

			$totalVotes = $imgOneCount + $imgTwoCount;

			if( $imgOneCount == 0 ) {
				$imgOnePercent = 0;
				$barOneWidth = 0;
			} else {
				$imgOnePercent = floor( $imgOneCount / $totalVotes  * 100 );
				$barOneWidth = floor( 200 * ( $imgOneCount / $totalVotes ) );
			}

			if( $imgTwoCount == 0 ) {
				$imgTwoPercent = 0;
				$barTwoWidth = 0;
			} else {
				$imgTwoPercent = 100 - $imgOnePercent;
				$barTwoWidth = floor( 200 * ( $imgTwoCount / $totalVotes ) );
			}

			$permalinkJS = "document.getElementById( 'voteStats' ).style.display = 'inline';
			document.getElementById( 'voteStats' ).style.visibility = 'visible';";
		}

		$output = '';
		// set the page title
		//$wgOut->setPageTitle( $title_text );

		// figure out if the user is an admin / the creator
		$editlinks = '';
		if( $wgUser->isAllowed( 'picturegameadmin' ) ) {
			// If the user can edit, throw in some links
			$editlinks = ' - <a href="' . $this->getTitle()->escapeFullURL(
				'picGameAction=adminPanel' ) . '"> ' .
				wfMsg( 'picturegame-adminpanel' ) .
			"</a> - <a href=\"javascript:PictureGame.protectImages('" .
				str_replace( "'", "\'", wfMsg( 'picturegame-protectimgconfirm' ) ) . "')\"> "
				. wfMsg( 'picturegame-protectimages' ) . '</a>';
		}

		$createLink = '';
		// Only registered users can create new picture games
		if( $wgUser->isLoggedIn() ) {
			$createLink = '
			<div class="create-link">
				<a href="' . $this->getTitle()->escapeFullURL( 'picGameAction=startCreate' ) . '">
					<img src="' . $wgScriptPath . '/extensions/PictureGame/images/addIcon.gif" border="0" alt="" />'
					. wfMsg( 'picturegame-createlink' ) .
				'</a>
			</div>';
		}

		$editLink = '';
		if( $wgUser->isLoggedIn() && $wgUser->isAllowed( 'picturegameadmin' ) && $wgUseEditButtonFloat == true ) {
			$editLink .= '<div class="edit-menu-pic-game">
				<div class="edit-button-pic-game">
					<img src="' . $wgScriptPath . '/extensions/PictureGame/images/editIcon.gif" alt="" />
					<a href="javascript:PictureGame.editPanel()">' . wfMsg( 'edit' ) . '</a>
				</div>
			</div>';
		}

		$id = User::idFromName( $user_title->getText() );
		$avatar = new wAvatar( $id, 'l' );
		$avatarID = $avatar->getAvatarImage();
		$stats = new UserStats( $id, $user_title->getText() );
		$stats_data = $stats->getUserStats();
		$preload = '';

		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', $title ) );

		$wgOut->addScriptFile( $wgScriptPath . '/extensions/PictureGame/picturegame/LightBox.js' );
		$next_id = ( isset( $next_id ) ? $next_id : 0 );
		$output .= "
		<script type=\"text/javascript\">var next_id = \"{$next_id}\";</script>
		{$editLink}
		<div class=\"editDiv\" id=\"editDiv\" style=\"display: none\"> </div>


				<div class=\"serverMessages\" id=\"serverMessages\"></div>

				<div class=\"imgContent\" id=\"imgContent\">
					<div class=\"imgTitle\" id=\"imgTitle\">" . $title . "</div>
					<div class=\"imgContainer\" id=\"imgContainer\" style=\"width:45%;\">
						<div class=\"imgCaption\" id=\"imgOneCaption\">" . $img1_caption . "</div>
						<div class=\"imageOne\" id=\"imageOne\" style=\"padding:5px;\" onclick=\"PictureGame.castVote(0)\" onmouseover=\"PictureGame.doHover('imageOne')\" onmouseout=\"PictureGame.endHover('imageOne')\">
							" . $imgOne . "	</div>
					</div>

					<div class=\"imgContainer\" id=\"imgContainer\" style=\"width:45%;\">
						<div class=\"imgCaption\" id=\"imgTwoCaption\">" . $img2_caption . "</div>
						<div class=\"imageTwo\" id=\"imageTwo\" style=\"padding:5px;\" onclick=\"PictureGame.castVote(1)\" onmouseover=\"PictureGame.doHover('imageTwo')\" onmouseout=\"PictureGame.endHover('imageTwo')\">
						" . $imgTwo . "	</div>
					</div>
					<div class=\"cleared\"></div>

					<div class=\"pic-game-navigation\">
						<ul>
							<li id=\"backButton\" style=\"display:" . ( $lastID > 0 ? 'block' : 'none' ) . "\">
								<a href=\"javascript:window.parent.document.location='" .
									$this->getTitle()->escapeFullURL( 'picGameAction=renderPermalink' ) .
									"&id=' + document.getElementById('lastid').value\">"
									. wfMsg( 'picturegame-backbutton' ) .
								"</a>
							</li>
							<li id=\"skipButton\" style=\"display:" . ( $next_id > 0 ? 'block' : 'none' ) . "\">
								<a href=\"" . $this->getTitle()->escapeFullURL( 'picGameAction=startGame' ) . '">'
									. wfMsg( 'picturegame-skipbutton' ) .
								'</a>
							</li>
						</ul>
					</div>

					<form id="picGameVote" name="picGameVote" method="post" action="' .
						$this->getTitle()->escapeFullURL( 'picGameAction=castVote' ) . "\">
						<input id=\"key\" name=\"key\" type=\"hidden\" value=\"" . md5( $imgID . $this->SALT ) . "\" />
						<input id=\"id\" name=\"id\" type=\"hidden\" value=\"" . $imgID . "\" />
						<input id=\"lastid\" name=\"lastid\" type=\"hidden\" value=\"" . $lastID . "\" />
						<input id=\"nextid\" name=\"nextid\" type=\"hidden\" value=\"" . $next_id . "\" />

						<input id=\"img\" name=\"img\" type=\"hidden\" value=\"\" />
					</form>
			</div>
			<div class=\"other-info\">
				{$createLink}
				<div class=\"credit-box\" id=\"creditBox\">
					<h1>" . wfMsg( 'picturegame-submittedby' ) . "</h1>
					<div class=\"submitted-by-image\">
						<a href=\"{$user_title->getFullURL()}\">
							<img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\" alt=\"\" />
						</a>
					</div>
					<div class=\"submitted-by-user\">
						<a href=\"{$user_title->getFullURL()}\">{$user_name}</a>
						<ul>
							<li>
								<img src=\"{$wgScriptPath}/extensions/PictureGame/images/voteIcon.gif\" border=\"0\" alt=\"\" />
								{$stats_data['votes']}
							</li>
							<li>
								<img src=\"{$wgScriptPath}/extensions/PictureGame/images/pencilIcon.gif\" border=\"0\" alt=\"\" />
								{$stats_data['edits']}
							</li>
							<li>
								<img src=\"{$wgScriptPath}/extensions/PictureGame/images/commentsIcon.gif\" border=\"0\" alt=\"\" />
								{$stats_data['comments']}
							</li>
						</ul>
					</div>
					<div class=\"cleared\"></div>
				</div>

				<div class=\"voteStats\" id=\"voteStats\" style=\"display:none\">
					<div id=\"vote-stats-text\">
						<h1>" . wfMsg( 'picturegame-previousgame' ) . " ({$totalVotes})</h1></div>
					<div class=\"vote-bar\">
						<span class=\"vote-thumbnail\" id=\"one-vote-thumbnail\">{$vote_one_tag}</span>
						<span class=\"vote-percent\" id=\"one-vote-percent\">{$imgOnePercent}%</span>
						<span class=\"vote-blue\">
							<img src=\"{$wgScriptPath}/extensions/PictureGame/images/vote-bar-blue.gif\" id=\"one-vote-width\" border=\"0\" style=\"width:{$barOneWidth}px;height:11px;\" alt=\"\" />
						</span>
					</div>
					<div class=\"vote-bar\">
						<span class=\"vote-thumbnail\" id=\"two-vote-thumbnail\">{$vote_two_tag}</span>
						<span class=\"vote-percent\" id=\"two-vote-percent\">{$imgTwoPercent}%</span>
						<span class=\"vote-red\">
							<img src=\"{$wgScriptPath}/extensions/PictureGame/images/vote-bar-red.gif\" id=\"two-vote-width\" border=\"0\" style=\"width:{$barTwoWidth}px;height:11px;\" alt=\"\" />
						</span>
					</div>
				</div>

				<div class=\"utilityButtons\" id=\"utilityButtons\">
					<a href=\"javascript:PictureGame.flagImg('" . str_replace( "'", "\'", wfMsg( 'picturegame-flagimgconfirm' ) ) . "')\">"
						. wfMsg( 'picturegame-reportimages' ) .
					" </a> -
					<a href=\"javascript:window.parent.document.location='" . $this->getTitle()->escapeFullURL( 'picGameAction=renderPermalink' ) . "&id=' + document.getElementById('id').value\">"
						. wfMsg( 'picturegame-permalink' ) .
					'</a>'
				. $editlinks . "
				</div>

			</div>

			<div class=\"cleared\"></div>

			<script language=\"javascript\">{$permalinkJS}</script>

		<div id=\"preload\" style=\"display:none\">
			{$preload}
			<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0\" width=\"75\" height=\"75\" title=\"hourglass\">
				<param name=\"movie\" value=\"" . $wgScriptPath . "/extensions/PictureGame/picturegame/ajax-loading.swf\" />
				<param name=\"quality\" value=\"high\" />
				<param name=\"wmode\" value=\"transparent\" />
				<param name=\"bgcolor\" value=\"#ffffff\" />
				<embed src=\"" . $wgScriptPath . "/extensions/PictureGame/picturegame/ajax-loading.swf\" quality=\"high\" wmode=\"transparent\" bgcolor=\"#ffffff\" pluginspage=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\"
				 type=\"application/x-shockwave-flash\" width=\"100\" height=\"100\">
				</embed>
			 </object>
		</div>";

		// fix syntax coloring
		return $output;
	}

	/**
	 * Insert information about the new picture game into the database,
	 * increase social statistics, purge memcached entries and redirect the
	 * user to the newly-created picture game.
	 */
	function createGame() {
		global $wgRequest, $wgUser;

		// @todo FIXME: as per Tim: http://www.mediawiki.org/wiki/Special:Code/MediaWiki/59183#c4709
		$title = addslashes( $wgRequest->getVal( 'picGameTitle' ) );

		$img1 = addslashes( $wgRequest->getVal( 'picOneURL' ) );
		$img2 = addslashes( $wgRequest->getVal( 'picTwoURL' ) );
		$img1_caption = addslashes( $wgRequest->getVal( 'picOneDesc' ) );
		$img2_caption = addslashes( $wgRequest->getVal( 'picTwoDesc' ) );

		$key = $wgRequest->getVal( 'key' );
		$chain = $wgRequest->getVal( 'chain' );
		$id = -1;

		$dbr = wfGetDB( DB_MASTER );

		// make sure no one is trying to do bad things
		if( $key == md5( $chain . $this->SALT ) ) {
			$sql = "SELECT COUNT(*) AS mycount FROM {$dbr->tableName( 'picturegame_images' )} WHERE
				( img1 = \"" . $img1 . "\" OR img2 = \"" . $img1 . "\" ) AND
				( img1 = \"" . $img2 . "\" OR img2 = \"" . $img2 . "\" ) GROUP BY id;";

			$res = $dbr->query( $sql, __METHOD__ );
			$row = $dbr->fetchObject( $res );

			// if these image pairs don't exist, insert them
			if( $row->mycount == 0 ) {
				$dbr->insert(
					'picturegame_images',
					array(
						'userid' => $wgUser->getID(),
						'username' => $wgUser->getName(),
						'img1' => $img1,
						'img2' => $img2,
						'title' => $title,
						'img1_caption' => $img1_caption,
						'img2_caption' => $img2_caption,
						'pg_date' => date( 'Y-m-d H:i:s' )
					),
					__METHOD__
				);

				$id = $dbr->selectField(
					'picturegame_images',
					'MAX(id) AS maxid',
					array(),
					__METHOD__
				);

				// Increase social statistics
				$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
				$stats->incStatField( 'picturegame_created' );

				// Purge memcached
				global $wgMemc;
				$key = wfMemcKey( 'user', 'profile', 'picgame', $wgUser->getID() );
				$wgMemc->delete( $key );
			}
		}

		header( "Location: ?title=Special:PictureGameHome&picGameAction=startGame&id={$id}" );
	}

	// Renders the initial page of the game
	function renderPictureGame() {
		global $wgRequest, $wgOut, $wgScriptPath;

		$permalinkID = $wgRequest->getInt( 'id', -1 );
		$lastId = $wgRequest->getInt( 'lastid', -1 );

		$isPermalink = false;
		$permalinkError = false;

		$dbr = wfGetDB( DB_MASTER );
		if( $permalinkID > 0 ) {
			$isPermalink = true;

			$mycount = (int)$dbr->selectField(
				'picturegame_images',
				'COUNT(*) AS mycount',
				array(
					'flag = ' . PICTUREGAME_FLAG_NONE .
						' OR flag = ' . PICTUREGAME_FLAG_PROTECT,
					'id' => $permalinkID
				),
				__METHOD__
			);

			if( $mycount == 0 ) {
				$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/PictureGame/picturegame/maingame.css' );
				$output = '
					<div class="picgame-container" id="picgame-container">
						<p>' . wfMsg( 'picturegame-permalinkflagged' ) . '</p>
						<p><input type="button" class="site-button" value="' .
							wfMsg( 'picturegame-buttonplaygame' ) .
							'" onclick="window.location=\'' .
							$this->getTitle()->escapeFullURL( 'picGameAction=startGame' ) . '\'" />
						</p>
					</div>';
				$wgOut->addHTML( $output );
				return;
			}
		}

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/PictureGame/picturegame/maingame.css' );
		$output = '<div class="picgame-container" id="picgame-container">' .
			$this->getImageDivs( $isPermalink, $permalinkID, $lastId ) .
		'</div>';
		$wgOut->addHTML( $output );
	}

	/**
	 * Shows the initial page that prompts the image upload.
	 */
	function showHomePage() {
		global $wgRequest, $wgUser, $wgOut, $wgScriptPath;

		// You need to be logged in to create a new picture game (because
		// usually only registered users can upload files)
		if( !$wgUser->isLoggedIn() ) {
			$wgOut->setPageTitle( wfMsg( 'picturegame-creategametitle' ) );
			$output = wfMsg( 'picturegame-creategamenotloggedin' );
			$output .= "<p>
				<input type=\"button\" class=\"site-button\" onclick=\"window.location='" .
					SpecialPage::getTitleFor( 'Userlogin', 'signup' )->escapeFullURL() .
					"'\" value=\"" . wfMsg( 'picturegame-signup' ) . "\" />
				<input type=\"button\" class=\"site-button\" onclick=\"window.location='" .
					SpecialPage::getTitleFor( 'Userlogin' )->escapeFullURL() .
					"'\" value=\"" . wfMsg( 'picturegame-login' ) . "\" />
			</p>";
			$wgOut->addHTML( $output );
			return;
		}

		/**
		 * Create Picture Game Thresholds based on User Stats
		 */
		global $wgCreatePictureGameThresholds;
		if( is_array( $wgCreatePictureGameThresholds ) && count( $wgCreatePictureGameThresholds ) > 0 ) {
			$can_create = true;

			$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
			$stats_data = $stats->getUserStats();

			$threshold_reason = '';
			foreach( $wgCreatePictureGameThresholds as $field => $threshold ) {
				if ( str_replace( ',', '', $stats_data[$field] ) < $threshold ) {
					$can_create = false;
					$threshold_reason .= ( ( $threshold_reason ) ? ', ' : '' ) . "$threshold $field";
				}
			}

			if( $can_create == false ) {
				global $wgSupressPageTitle;
				$wgSupressPageTitle = false;
				$wgOut->setPageTitle( wfMsg( 'picturegame-create-threshold-title' ) );
				$wgOut->addHTML( wfMsg( 'picturegame-create-threshold-reason', $threshold_reason ) );
				return '';
			}
		}

		// Show a link to the admin panel for picture game admins
		if( $wgUser->isAllowed( 'picturegameadmin' ) ) {
			$adminlink = '<a href="' . $this->getTitle()->escapeFullURL( 'picGameAction=adminPanel' ) . '"> ' .
				wfMsg( 'picturegame-adminpanel' ) . ' </a>';
		}

		$dbr = wfGetDB( DB_MASTER );

		$excludedIds = $dbr->select(
			'picturegame_votes',
			'picid',
			array( 'username' => $wgUser->getName() ),
			__METHOD__
		);

		$excluded = array();
		foreach ( $excludedIds as $excludedId ) {
			$excluded[] = $excludedId->picid;
		}

		$canSkip = false;
		if ( !empty( $excluded ) ) {
			$myCount = (int)$dbr->selectField(
				'picturegame_images',
				'COUNT(*) AS mycount',
				array(
					'id NOT IN(' . implode( ',', $excluded  ) . ')',
					'flag != ' . PICTUREGAME_FLAG_FLAGGED,
					"img1 <> ''",
					"img2 <> ''"
				),
				__METHOD__
			);
			if ( $myCount > 0 ) {
				$canSkip = true;
			}
		}
		/*$sql = "SELECT COUNT(*) AS mycount FROM picturegame_images WHERE picturegame_images.id NOT IN
				(SELECT picid FROM picturegame_votes WHERE picturegame_votes.username='" . $dbr->strencode( $wgUser->getName() ) . "')
			AND flag != " . PICTUREGAME_FLAG_FLAGGED . " AND img1 <> '' AND img2 <> '' LIMIT 1;";
		$res = $dbr->query( $sql, __METHOD__ );
		$row = $dbr->fetchObject( $res );

		$canSkip = ( $row->mycount != 0 ? true : false );*/

		// used for the key
		$now = time();

		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg( 'picturegame-creategametitle' ) ) );

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/PictureGame/picturegame/startgame.css' );
		// Anonymous functions are fun :) Too bad for you, PHP <= 5.2.x users!
		// @see http://php.net/manual/en/functions.anonymous.php
		global $wgHooks;
		$wgHooks['MakeGlobalVariablesScript'][] = function( &$vars ) {
			// for the upload form (see PictureGame.js, the uploadComplete
			// functions)
			$vars['__picturegame_edit__'] = wfMsg( 'picturegame-js-edit' );
			return true;
		};

		$output = "\t\t" . '<div class="pick-game-welcome-message">
			<h1>' . wfMsg( 'picturegame-creategametitle' ) . '</h1>';
		$output .= wfMsg( 'picturegame-creategamewelcome' );
		$output .= '<br />

			<div id="skipButton" class="startButton">';
		$play_button_text = wfMsg( 'picturegame-creategameplayinstead' );
		$skipButton = '';
		if ( $canSkip ) {
			$skipButton = "<input class=\"site-button\" type=\"button\" onclick=\"javascript:PictureGame.skipToGame()\" value=\"{$play_button_text}\"/>";
		}
		$output .= $skipButton .
				'</div>
			</div>

			<div class="uploadLeft">
				<div id="uploadTitle" class="uploadTitle">
					<form id="picGamePlay" name="picGamePlay" method="post" action="' .
						$this->getTitle()->escapeFullURL( 'picGameAction=createGame' ) . '">
						<h1>' . wfMsg( 'picturegame-creategamegametitle' ) . '</h1>
						<div class="picgame-errors" id="picgame-errors"></div>
						<p>
							<input name="picGameTitle" id="picGameTitle" type="text" value="" size="40" />
						</p>
						<input name="picOneURL" id="picOneURL" type="hidden" value="" />
						<input name="picTwoURL" id="picTwoURL" type="hidden" value="" />';
						/*<input name=\"picOneDesc\" id=\"picOneDesc\" type=\"hidden\" value=\"\" />
						<input name=\"picTwoDesc\" id=\"picTwoDesc\" type=\"hidden\" value=\"\" />*/
		$uploadObj = SpecialPage::getTitleFor( 'PictureGameAjaxUpload' );
		$output .= '<input name="key" type="hidden" value="' . md5( $now . $this->SALT ) . '" />
						<input name="chain" type="hidden" value="' . $now . '" />
					</form>
				</div>

				<div class="content">
					<div id="uploadImageForms" class="uploadImage">

						<div id="imageOneUpload" class="imageOneUpload">
							<h1>' . wfMsg( 'picturegame-createeditfirstimage' ) . '</h1>
							<!--Caption:<br /><input name="picOneDesc" id="picOneDesc" type="text" value="" /><br />-->
							<div id="imageOneUploadError"></div>
							<div id="imageOneLoadingImg" class="loadingImg" style="display:none">
								<img src="' . $wgScriptPath . '/extensions/PictureGame/images/ajax-loader-white.gif" alt="" />
							</div>
							<div id="imageOne" class="imageOne" style="display:none;"></div>
							<iframe class="imageOneUpload-frame" scrolling="no" frameborder="0" width="400" id="imageOneUpload-frame" src="' .
								$uploadObj->escapeFullURL( 'callbackPrefix=imageOne_' ) . '"></iframe>
						</div>

						<div id="imageTwoUpload" class="imageTwoUpload">
							<h1>' . wfMsg( 'picturegame-createeditsecondimage' ) . '</h1>
							<!--Caption:<br /><input name="picTwoDesc" id="picTwoDesc" type="text" value="" /><br />-->
							<div id="imageTwoUploadError"></div>
							<div id="imageTwoLoadingImg" class="loadingImg" style="display:none">
								<img src="' . $wgScriptPath . '/extensions/PictureGame/images/ajax-loader-white.gif" alt="" />
							</div>
							<div id="imageTwo" class="imageTwo" style="display:none;"></div>
							<iframe id="imageTwoUpload-frame" scrolling="no" frameborder="0" width="610" src="' .
								$uploadObj->escapeFullURL( 'callbackPrefix=imageTwo_' ) . '"></iframe>
						</div>

						<div class="cleared"></div>
					</div>
				</div>
			</div>

			<div id="startButton" class="startButton" style="display: none;">
				<input type="button" onclick="PictureGame.startGame()" value="' . wfMsg( 'picturegame-creategamecreateplay' ) . '" />
			</div>';

		$wgOut->addHTML( $output );
	}

	/**
	 * You've seen this code a dozen times before. It's your standard,
	 * home-made i18n-compatible, pre-ResourceLoader JavaScript.
	 *
	 * @param $vars Array: array of pre-existing JavaScript globals
	 * @return Boolean: true
	 */
	public static function addJSGlobals( &$vars ) {
		$vars['__picturegame_edit__'] = wfMsg( 'picturegame-js-edit' );
		$vars['__picturegame_error_title__'] = wfMsg( 'picturegame-js-error-title' );
		$vars['__picturegame_upload_imgone__'] = wfMsg( 'picturegame-js-error-upload-imgone' );
		$vars['__picturegame_upload_imgtwo__'] = wfMsg( 'picturegame-js-error-upload-imgtwo' );
		$vars['__picturegame_editing_imgone__'] = wfMsg( 'picturegame-js-editing-imgone' );
		$vars['__picturegame_editing_imgtwo__'] = wfMsg( 'picturegame-js-editing-imgtwo' );
		return true;
	}
}
