<?php
class MirrorEditPage extends EditPage {

	/**
	 * Attempt submission (no UI)
	 * @return one of the constants describing the result
	 */
	function mirrorinternalAttemptSave( &$result, $bot = false, $mirrorUser ) {
		global $wgFilterCallback, $wgUser, $wgOut, $wgParser;
		global $wgMaxArticleSize;
                $user = User::newFromName ( $mirrorUser, true );
		wfProfileIn( __METHOD__  );
		wfProfileIn( __METHOD__ . '-checks' );

		if ( !wfRunHooks( 'EditPage::attemptSave', array( $this ) ) ) {
			wfDebug( "Hook 'EditPage::attemptSave' aborted article saving\n" );
			return self::AS_HOOK_ERROR;
		}

		# Check image redirect
		if ( $this->mTitle->getNamespace() == NS_FILE &&
			Title::newFromRedirect( $this->textbox1 ) instanceof Title &&
			!$wgUser->isAllowed( 'upload' ) ) {
				if ( $wgUser->isAnon() ) {
					return self::AS_IMAGE_REDIRECT_ANON;
				} else {
					return self::AS_IMAGE_REDIRECT_LOGGED;
				}
		}

		# Check for spam
		$match = self::matchSummarySpamRegex( $this->summary );
		if ( $match === false ) {
			$match = self::matchSpamRegex( $this->textbox1 );
		}
		if ( $match !== false ) {
			$result['spam'] = $match;
			$ip = wfGetIP();
			$pdbk = $this->mTitle->getPrefixedDBkey();
			$match = str_replace( "\n", '', $match );
			wfDebugLog( 'SpamRegex', "$ip spam regex hit [[$pdbk]]: \"$match\"" );
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_SPAM_ERROR;
		}
		if ( $wgFilterCallback && $wgFilterCallback( $this->mTitle, $this->textbox1, $this->section, $this->hookError, $this->summary ) ) {
			# Error messages or other handling should be performed by the filter function
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_FILTERING;
		}
		if ( !wfRunHooks( 'EditFilter', array( $this, $this->textbox1, $this->section, &$this->hookError, $this->summary ) ) ) {
			# Error messages etc. could be handled within the hook...
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_HOOK_ERROR;
		} elseif ( $this->hookError != '' ) {
			# ...or the hook could be expecting us to produce an error
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_HOOK_ERROR_EXPECTED;
		}
		if ( $wgUser->isBlockedFrom( $this->mTitle, false ) ) {
			# Check block state against master, thus 'false'.
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_BLOCKED_PAGE_FOR_USER;
		}
		$this->kblength = (int)( strlen( $this->textbox1 ) / 1024 );
		if ( $this->kblength > $wgMaxArticleSize ) {
			// Error will be displayed by showEditForm()
			$this->tooBig = true;
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_CONTENT_TOO_BIG;
		}

		if ( !$wgUser->isAllowed( 'edit' ) ) {
			if ( $wgUser->isAnon() ) {
				wfProfileOut( __METHOD__ . '-checks' );
				wfProfileOut( __METHOD__ );
				return self::AS_READ_ONLY_PAGE_ANON;
			} else {
				wfProfileOut( __METHOD__ . '-checks' );
				wfProfileOut( __METHOD__ );
				return self::AS_READ_ONLY_PAGE_LOGGED;
			}
		}

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_READ_ONLY_PAGE;
		}
		if ( $wgUser->pingLimiter() ) {
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_RATE_LIMITED;
		}

		# If the article has been deleted while editing, don't save it without
		# confirmation
		if ( $this->wasDeletedSinceLastEdit() && !$this->recreate ) {
			wfProfileOut( __METHOD__ . '-checks' );
			wfProfileOut( __METHOD__ );
			return self::AS_ARTICLE_WAS_DELETED;
		}

		wfProfileOut( __METHOD__ . '-checks' );

		# If article is new, insert it.
		$aid = $this->mTitle->getArticleID( Title::GAID_FOR_UPDATE );
		if ( 0 == $aid ) {
			// Late check for create permission, just in case *PARANOIA*
			if ( !$this->mTitle->userCan( 'create' ) ) {
				wfDebug( __METHOD__ . ": no create permission\n" );
				wfProfileOut( __METHOD__ );
				return self::AS_NO_CREATE_PERMISSION;
			}

			# Don't save a new article if it's blank.
			if ( $this->textbox1 == '' ) {
				wfProfileOut( __METHOD__ );
				return self::AS_BLANK_ARTICLE;
			}

			// Run post-section-merge edit filter
			if ( !wfRunHooks( 'EditFilterMerged', array( $this, $this->textbox1, &$this->hookError, $this->summary ) ) ) {
				# Error messages etc. could be handled within the hook...
				wfProfileOut( __METHOD__ );
				return self::AS_HOOK_ERROR;
			} elseif ( $this->hookError != '' ) {
				# ...or the hook could be expecting us to produce an error
				wfProfileOut( __METHOD__ );
				return self::AS_HOOK_ERROR_EXPECTED;
			}

			# Handle the user preference to force summaries here. Check if it's not a redirect.
			if ( !$this->allowBlankSummary && !Title::newFromRedirect( $this->textbox1 ) ) {
				if ( md5( $this->summary ) == $this->autoSumm ) {
					$this->missingSummary = true;
					wfProfileOut( __METHOD__ );
					return self::AS_SUMMARY_NEEDED;
				}
			}

			$isComment = ( $this->section == 'new' );

			# FIXME: paste contents from Article::doEdit here and
			# actually handle errors it may return
			$flags = EDIT_NEW | EDIT_DEFER_UPDATES | EDIT_AUTOSUMMARY |
			( $isminor ? EDIT_MINOR : 0 ) |
			( $suppressRC ? EDIT_SUPPRESS_RC : 0 ) |
			( $bot ? EDIT_FORCE_BOT : 0 );

                        $this->mArticle->doEdit( $this->textbox1, $this->summary, $flags, false, $user, $this->watchthis, $isComment, '', true );
			wfProfileOut( __METHOD__ );
			return self::AS_SUCCESS_NEW_ARTICLE;
		}

		# Article exists. Check for edit conflict.

		$this->mArticle->clear(); # Force reload of dates, etc.

		wfDebug( "timestamp: {$this->mArticle->getTimestamp()}, edittime: {$this->edittime}\n" );

		if ( $this->mArticle->getTimestamp() != $this->edittime ) {
			$this->isConflict = true;
			if ( $this->section == 'new' ) {
				if ( $this->mArticle->getUserText() == $wgUser->getName() &&
					$this->mArticle->getComment() == $this->summary ) {
					// Probably a duplicate submission of a new comment.
					// This can happen when squid resends a request after
					// a timeout but the first one actually went through.
					wfDebug( __METHOD__ . ": duplicate new section submission; trigger edit conflict!\n" );
				} else {
					// New comment; suppress conflict.
					$this->isConflict = false;
					wfDebug( __METHOD__ .": conflict suppressed; new section\n" );
				}
			}
		}
		$userid = $wgUser->getId();

		# Suppress edit conflict with self, except for section edits where merging is required.
		if ( $this->isConflict && $this->section == '' && $this->userWasLastToEdit( $userid, $this->edittime ) ) {
			wfDebug( __METHOD__ . ": Suppressing edit conflict, same user.\n" );
			$this->isConflict = false;
		}

		if ( $this->isConflict ) {
			wfDebug( __METHOD__ . ": conflict! getting section '$this->section' for time '$this->edittime' (article time '" .
				$this->mArticle->getTimestamp() . "')\n" );
			$text = $this->mArticle->replaceSection( $this->section, $this->textbox1, $this->summary, $this->edittime );
		} else {
			wfDebug( __METHOD__ . ": getting section '$this->section'\n" );
			$text = $this->mArticle->replaceSection( $this->section, $this->textbox1, $this->summary );
		}
		if ( is_null( $text ) ) {
			wfDebug( __METHOD__ . ": activating conflict; section replace failed.\n" );
			$this->isConflict = true;
			$text = $this->textbox1; // do not try to merge here!
		} elseif ( $this->isConflict ) {
			# Attempt merge
			if ( $this->mergeChangesInto( $text ) ) {
				// Successful merge! Maybe we should tell the user the good news?
				$this->isConflict = false;
				wfDebug( __METHOD__ . ": Suppressing edit conflict, successful merge.\n" );
			} else {
				$this->section = '';
				$this->textbox1 = $text;
				wfDebug( __METHOD__ . ": Keeping edit conflict, failed merge.\n" );
			}
		}

		if ( $this->isConflict ) {
			wfProfileOut( __METHOD__ );
			return self::AS_CONFLICT_DETECTED;
		}

		$oldtext = $this->mArticle->getContent();

		// Run post-section-merge edit filter
		if ( !wfRunHooks( 'EditFilterMerged', array( $this, $text, &$this->hookError, $this->summary ) ) ) {
			# Error messages etc. could be handled within the hook...
			wfProfileOut( __METHOD__ );
			return self::AS_HOOK_ERROR;
		} elseif ( $this->hookError != '' ) {
			# ...or the hook could be expecting us to produce an error
			wfProfileOut( __METHOD__ );
			return self::AS_HOOK_ERROR_EXPECTED;
		}

		# Handle the user preference to force summaries here, but not for null edits
		if ( $this->section != 'new' && !$this->allowBlankSummary && 0 != strcmp( $oldtext, $text )
			&& !Title::newFromRedirect( $text ) ) # check if it's not a redirect
		{
			if ( md5( $this->summary ) == $this->autoSumm ) {
				$this->missingSummary = true;
				wfProfileOut( __METHOD__ );
				return self::AS_SUMMARY_NEEDED;
			}
		}

		# And a similar thing for new sections
		if ( $this->section == 'new' && !$this->allowBlankSummary ) {
			if ( trim( $this->summary ) == '' ) {
				$this->missingSummary = true;
				wfProfileOut( __METHOD__ );
				return self::AS_SUMMARY_NEEDED;
			}
		}

		# All's well
		wfProfileIn( __METHOD__ . '-sectionanchor' );
		$sectionanchor = '';
		if ( $this->section == 'new' ) {
			if ( $this->textbox1 == '' ) {
				$this->missingComment = true;
				wfProfileOut( __METHOD__ . '-sectionanchor' );
				wfProfileOut( __METHOD__ );
				return self::AS_TEXTBOX_EMPTY;
			}
			if ( $this->summary != '' ) {
				$sectionanchor = $wgParser->guessSectionNameFromWikiText( $this->summary );
				# This is a new section, so create a link to the new section
				# in the revision summary.
				$cleanSummary = $wgParser->stripSectionName( $this->summary );
				$this->summary = wfMsgForContent( 'newsectionsummary', $cleanSummary );
			}
		} elseif ( $this->section != '' ) {
			# Try to get a section anchor from the section source, redirect to edited section if header found
			# XXX: might be better to integrate this into Article::replaceSection
			# for duplicate heading checking and maybe parsing
			$hasmatch = preg_match( "/^ *([=]{1,6})(.*?)(\\1) *\\n/i", $this->textbox1, $matches );
			# we can't deal with anchors, includes, html etc in the header for now,
			# headline would need to be parsed to improve this
			if ( $hasmatch and strlen( $matches[2] ) > 0 ) {
				$sectionanchor = $wgParser->guessSectionNameFromWikiText( $matches[2] );
			}
		}
		wfProfileOut( __METHOD__ . '-sectionanchor' );

		// Save errors may fall down to the edit form, but we've now
		// merged the section into full text. Clear the section field
		// so that later submission of conflict forms won't try to
		// replace that into a duplicated mess.
		$this->textbox1 = $text;
		$this->section = '';

		// Check for length errors again now that the section is merged in
		$this->kblength = (int)( strlen( $text ) / 1024 );
		if ( $this->kblength > $wgMaxArticleSize ) {
			$this->tooBig = true;
			wfProfileOut( __METHOD__ );
			return self::AS_MAX_ARTICLE_SIZE_EXCEEDED;
		}

		// Update the article here
		$flags = EDIT_UPDATE | EDIT_DEFER_UPDATES | EDIT_AUTOSUMMARY |
			( $this->minoredit ? EDIT_MINOR : 0 ) |
			( $bot ? EDIT_FORCE_BOT : 0 );
		$status = $this->mArticle->doEdit( $text, $this->summary, $flags,
			false, $userObj, $this->watchthis, false, $sectionanchor, true );

		if ( $status->isOK() )
		{
			wfProfileOut( __METHOD__ );
			return self::AS_SUCCESS_UPDATE;
		} else {
			$this->isConflict = true;
			$result = $status->getErrorsArray();
		}
		wfProfileOut( __METHOD__ );
		return self::AS_END;
	}
}