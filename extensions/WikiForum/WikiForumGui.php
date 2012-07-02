<?php
/**
 * Graphical User Interface (GUI) methods used by WikiForum extension.
 *
 * All class methods are public and static.
 *
 * @file
 * @ingroup Extensions
 */
class WikiForumGui {

	public static function getFrameHeader() {
		return '<table class="mw-wikiforum-frame" cellspacing="10"><tr><td class="mw-wikiforum-innerframe">';
	}

	public static function getFrameFooter() {
		return '</td></tr></table>';
	}

	public static function getSearchbox() {
		global $wgScriptPath;

		$specialPageObj = SpecialPage::getTitleFor( 'WikiForum' );

		$icon = '<img src="' . $wgScriptPath . '/extensions/WikiForum/icons/zoom.png" id="searchbox_picture" title="' . wfMsg( 'search' ) . '" />';

		$output = '<div id="searchbox"><form method="post" action="' . $specialPageObj->escapeFullURL() . '">' .
			'<div id="searchbox_border">' . $icon .
			'<input type="text" value="" name="txtSearch" id="txtSearch" /></div>
		</form></div>';

		return $output;
	}

	/**
	 * Builds the header row -- the breadcrumb navigation
	 * (Overview > Category name > Forum)
	 *
	 * @todo FIXME: would be nice to add > Topic name to the navigation, too
	 */
	public static function getHeaderRow( $catId, $catName, $forumId, $forumName, $additionalLinks ) {
		global $wgUser, $wgWikiForumAllowAnonymous;

		$output = '<table class="mw-wikiforum-headerrow"><tr><td class="mw-wikiforum-leftside">';
		if (
			strlen( $additionalLinks ) == 0 ||
			$catId > 0 && strlen( $catName ) > 0
		)
		{
			$specialPageObj = SpecialPage::getTitleFor( 'WikiForum' );
			$output .= '<a href="' . $specialPageObj->escapeFullURL() . '">' .
				wfMsg( 'wikiforum-overview' ) . '</a>';
			if ( $catId > 0 && strlen( $catName ) > 0 ) {
				$output .= ' &gt; <a href="' .
					$specialPageObj->escapeFullURL( 'category=' . $catId ) . '">' .
					$catName . '</a>';
			}
			if ( $forumId > 0 && strlen( $forumName ) > 0 ) {
				$output .= ' &gt; <a href="' . $specialPageObj->escapeFullURL( 'forum=' . $forumId ) . '">' . $forumName . '</a>';
			}
		}
		if (
			strlen( $additionalLinks ) > 0 &&
			( $wgWikiForumAllowAnonymous || $wgUser->getId() > 0 )
		)
		{
			$output .= '</td><td class="mw-wikiforum-rightside">' . $additionalLinks;
		}
		$output .= '</td></tr></table>';
		return $output;
	}

	/**
	 * Gets the footer row, in other words: pagination links.
	 *
	 * @param $page Integer: number of the current page
	 * @param $maxissues Integer: amount of replies, fetched from the DB
	 * @param $limit Integer: limit; this is also used for the SQL query
	 * @param $forumId Integer: forum ID number, so that the pagination code
	 *                          knows where it's going...
	 * @param $threadId Integer: thread ID number, if we're paginating a thread
	 * @return HTML
	 */
	public static function getFooterRow( $page, $maxissues, $limit, $forumId, $threadId = 0 ) {
		$output = '';
		$specialPage = SpecialPage::getTitleFor( 'WikiForum' );

		if ( $maxissues / $limit > 1 ) {
			$output = '<table class="mw-wikiforum-footerrow"><tr><td class="mw-wikiforum-leftside">' .
				wfMsg( 'wikiforum-pages' ) . wfMsg( 'word-separator' );
			for ( $i = 1; $i < ( $maxissues / $limit ) + 1; $i++ ) {
				// URL query parameters
				$urlParams = array(
					'lp' => $i
				);
				// Thread ID is optional, but if it was given, we need to get
				// rid of the forum parameter for the thread parameter to take
				// precedence. Stupid, I know.
				if ( $threadId ) {
					$urlParams['thread'] = $threadId;
				} else {
					$urlParams['forum'] = $forumId;
				}
				if ( $i != $page + 1 ) {
					$output .= '<a href="' . $specialPage->escapeFullURL( $urlParams ) . '">';
				} else {
					$output .= '[';
				}

				if ( $i <= 9 ) {
					$output .= '0' . $i;
				} else {
					$output .= $i;
				}

				if ( $i != $page + 1 ) {
					$output .= '</a>';
				} else {
					$output .= ']';
				}

				$output .= wfMsg( 'word-separator' );
			}
			$output .= '</td><td class="mw-wikiforum-rightside">';
			$output .= '</td></tr></table>';
		}
		return $output;
	}

	public static function getMainHeader( $title1, $title2, $title3, $title4, $title5 ) {
		return self::getFrameHeader() . '<table class="mw-wikiforum-title">' .
			self::getMainHeaderRow(
				$title1, $title2, $title3,
				$title4, $title5
			);
	}

	public static function getMainPageHeader( $title1, $title2, $title3, $title4 ) {
		return '<table class="mw-wikiforum-mainpage" cellspacing="0">' .
			self::getMainHeaderRow(
				$title1, $title2,
				$title3, $title4, false
			);
	}

	public static function getMainHeaderRow( $title1, $title2, $title3, $title4, $title5 ) {
		$output = '<tr class="mw-wikiforum-title">
					<th class="mw-wikiforum-title">' . $title1 . '</th>';
		if ( $title5 ) {
			$output .= '<th class="mw-wikiforum-admin"><p class="mw-wikiforum-valuetitle">' .
				$title5 . '</p></th>';
		}
		$output .= '
					<th class="mw-wikiforum-value"><p class="mw-wikiforum-valuetitle">' . $title2 . '</p></th>
					<th class="mw-wikiforum-value"><p class="mw-wikiforum-valuetitle">' . $title3 . '</p></th>
					<th class="mw-wikiforum-lastpost"><p class="mw-wikiforum-valuetitle">' . $title4 . '</p></th></tr>';
		return $output;
	}

	public static function getMainBody( $col_value1, $col_value2, $col_value3, $col_value4, $col_title5, $marked ) {
		$output = '<tr class="mw-wikiforum-';
		if ( $marked ) {
			$output .= $marked;
		} else {
			$output .= 'normal';
		}
		$output .= '"><td class="mw-wikiforum-title">' . $col_value1 . '</td>';
		if ( $col_title5 ) {
			$output .= '<td class="mw-wikiforum-admin">' . $col_title5 . '</td>';
		}
		$output .= '
					<td class="mw-wikiforum-value">' . $col_value2 . '</td>
					<td class="mw-wikiforum-value">' . $col_value3 . '</td>
					<td class="mw-wikiforum-value">' . $col_value4 . '</td></tr>';
		return $output;
	}

	public static function getMainFooter() {
		return '</table>' . self::getFrameFooter();
	}

	public static function getMainPageFooter() {
		return '</table>';
	}

	/**
	 * Get the thread header. This is used only for the starting post.
	 *
	 * @param $title
	 * @param $text String: thread text
	 * @param $posted
	 * @param $buttons
	 * @param $id Integer: internal post ID number
	 * @param $userId Integer: if supplied, and if wAvatar class (social tools)
	 *                         exists, this will be used to get the poster's
	 *                         avatar image
	 */
	public static function getThreadHeader( $title, $text, $posted, $buttons, $id, $userId ) {
		$avatar = '';
		if ( $userId && class_exists( 'wAvatar' ) ) {
			$avatarObj = new wAvatar( $userId, 'l' );
			$avatar = '<div class="wikiforum-avatar-image">';
			$avatar .= $avatarObj->getAvatarURL();
			$avatar .= '</div>';
		}
		return self::getFrameHeader() . '
				<table style="width:100%">
					<tr>
						<th class="mw-wikiforum-thread-top" style="text-align: right;">[#' . $id . ']</th>
					</tr>
					<tr>
						<td class="mw-wikiforum-thread-main" colspan="2">' . $avatar .
							$text . self::getBottomLine( $posted, $buttons ) . '
						</td>
					</tr>';
	}

	public static function getReplyHeader( $title ) {
		return self::getFrameHeader() . '
			<table style="width:100%">
				<tr>
					<th class="mw-wikiforum-thread-top" colspan="2">' .
						$title .
					'</th>
				</tr>';
	}

	public static function getThreadFooter() {
		return '</table>' . self::getFrameFooter();
	}

	public static function getReply( $reply, $posted, $buttons, $id, $userId ) {
		$avatar = '';
		if ( $userId && class_exists( 'wAvatar' ) ) {
			$avatarObj = new wAvatar( $userId, 'l' );
			$avatar = '<div class="wikiforum-avatar-image">';
			$avatar .= $avatarObj->getAvatarURL();
			$avatar .= '</div>';
		}
		return '<tr><td class="mw-wikiforum-thread-sub" colspan="2" id="reply_' . intval( $id ) . '">' . $avatar .
			$reply . self::getBottomLine( $posted, $buttons ) . '</td></tr>';
	}

	public static function getBottomLine( $posted, $buttons ) {
		global $wgUser;

		$output = '<table cellspacing="0" cellpadding="0" class="mw-wikiforum-posted">' .
			'<tr><td class="mw-wikiforum-leftside">' . $posted . '</td>';

		if ( $wgUser->isLoggedIn() ) {
			$output .= '<td class="mw-wikiforum-rightside">' . $buttons . '</td>';
		}

		$output .= '</tr></table>';

		return $output;
	}

	public static function getSingleLine( $message, $cols ) {
		return '<tr class="sub"><td class="mw-wikiforum-title" colspan="' . intval( $cols ) . '">' .
			$message . '</td></tr>';
	}

	/**
	 * Get the editor form for writing a new thread, a reply, etc.
	 *
	 * @param $type String: either 'addthread' or 'editthread', depending on
	 * what we are doing to a thread.
	 * @param $action Array: action parameter(s) to be passed to the WikiForum
	 * special page call (i.e. array( 'thread' => $threadId ))
	 * @param $input String: usually whatever WikiForumGui::getInput() returns
	 * @param $height String: height of the textarea, i.e. '10em'
	 * @param $text_prev
	 * @param $saveButton String: save button text
	 * @return String: HTML
	 */
	public static function getWriteForm( $type, $action, $input, $height, $text_prev, $saveButton ) {
		global $wgOut, $wgUser, $wgWikiForumAllowAnonymous;

		$output = '';

		if ( $wgWikiForumAllowAnonymous || $wgUser->isLoggedIn() ) {
			// Required for the edit buttons to display
			$wgOut->addModules( 'mediawiki.action.edit' );
			$toolbar = EditPage::getEditToolbar();
			$specialPage = SpecialPage::getTitleFor( 'WikiForum' );

			$output = '<form name="frmMain" method="post" action="' . $specialPage->escapeFullURL( $action ) . '" id="writereply">
			<table class="mw-wikiforum-frame" cellspacing="10">' . $input . '
				<tr>
					<td>' . $toolbar . '</td>
				</tr>
				<tr>
					<td><textarea name="frmText" id="wpTextbox1" style="height: ' . $height . ';">' . $text_prev . '</textarea></td>
				</tr>
				<tr>
					<td>
						<input name="butSave" type="submit" value="' . $saveButton . '" accesskey="s" title="' . $saveButton . ' [s]" />
						<input name="butPreview" type="submit" value="' . wfMsg( 'wikiforum-button-preview' ) . '" accesskey="p" title="' . wfMsg( 'wikiforum-button-preview' ) . ' [p]" />';
			if ( $type == 'addthread' ) {
				$output .= ' <input name="butCancel" type="button" value="' . wfMsg( 'cancel' ) . '" accesskey="c" onclick="javascript:history.back();" title="' . wfMsg( 'cancel' ) . ' [c]" />';
			}
			$output .= '</td>
					</td>
				</tr>
			</table>
			</form>' . "\n";
		}
		return $output;
	}

	/**
	 * Get the form for adding/editing categories and forums.
	 *
	 * @param $type
	 * @param $categoryName
	 * @param $action Array: URL parameters (like array( 'foo' => 'bar' ) or so)
	 * @param $title_prev
	 * @param $text_prev
	 * @param $saveButton
	 */
	public static function getFormCatForum( $type, $categoryName, $action, $title_prev, $text_prev, $saveButton, $overviewObj ) {
		global $wgUser;

		if ( $wgUser->isAllowed( 'wikiforum-admin' ) ) {
			$title_prev = str_replace( '"', '&quot;', $title_prev );
			$specialPage = SpecialPage::getTitleFor( 'WikiForum' );
			$output = '
			<form name="frmMain" method="post" action="' . $specialPage->escapeFullURL( $action ) . '" id="form">
			<table class="mw-wikiforum-frame" cellspacing="10">
				<tr>
					<th class="mw-wikiforum-title">' . $categoryName . '</th>
				</tr>
				<tr>
					<td>
						<p>' . wfMsg( 'wikiforum-name' ) . '</p>
						<input type="text" name="frmTitle" style="width: 100%" value="' . $title_prev . '" />
					</td>
				</tr>';
			if ( $type == 'addforum' || $type == 'editforum' ) {
				$check = '';
				if ( is_object( $overviewObj ) && $overviewObj->wff_announcement == true ) {
					$check = 'checked="checked"';
				}
				$output .= '<tr>
					<td>
						<p>' . wfMsg( 'wikiforum-description' ) . '</p>
						<textarea name="frmText" style="height: 40px;">' . $text_prev . '</textarea>
					</td>
				</tr>
				<tr>
					<td>
						<p><input type="checkbox" name="chkAnnouncement"' . $check . '/> ' .
							wfMsg( 'wikiforum-announcement-only-description' ) .
						'</p>
					</td>
				</tr>';
			}
			$output .= '
				<tr>
					<td>
						<input name="butSubmit" type="submit" value="' . $saveButton . '" accesskey="s" title="' . $saveButton . ' [s]" />
						<input name="butCancel" type="button" value="' . wfMsg( 'cancel' ) . '" accesskey="c" onclick="javascript:history.back();" title="' . wfMsg( 'cancel' ) . ' [c]" />
					</td>
				</tr>
			</table>
		</form>
			';
			return $output;
		} else {
			return '';
		}
	}

	public static function getInput( $title_prev ) {
		$title_prev = str_replace( '"', '&quot;', $title_prev );
		return '<tr><td><input type="text" name="frmTitle" style="width:100%" value="' . $title_prev . '" /></td></tr>';
	}

}