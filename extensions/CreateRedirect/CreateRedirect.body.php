<?php
/**
 * MediaWiki Extension
 * CreateRedirect
 * By Marco Zafra ("Digi")
 * Started: September 18, 2007
 *
 * Adds a special page that eases creation of redirects via a simple form.
 * Also adds a menu item to the sidebar as a shortcut.
 *
 * This program, CreateRedirect, is Copyright (C) 2007 Marco Zafra.
 * CreateRedirect is released under the GNU Lesser General Public License version 3.
 *
 * This file is part of CreateRedirect. See the main file ("CreateRedirect.php") for additional information.
 *
 * CreateRedirect is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

/* Body file:
 * The bulk of the routines are stored here. This is where all the internal processing actually occurs.
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

class SpecialCreateRedirect extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'CreateRedirect' );
	}

	/**
	 * Show the special page.
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$this->setHeaders();

		if ( $wgRequest->wasPosted() ) {
			// 1. Retrieve POST vars. First, we want "crOrigTitle", holding the
			// title of the page we're writing to, and "crRedirectTitle",
			// holding the title of the page we're redirecting to.
			$crOrigTitle = $wgRequest->getText( 'crOrigTitle' );
			$crRedirectTitle = $wgRequest->getText( 'crRedirectTitle' );

			// 2. We need to construct a "FauxRequest", or fake a request that
			// MediaWiki would otherwise get naturally by a client browser to
			// do whatever it has to do. Let's put together the params.
			$title = $crOrigTitle;
			// a. We know our title, so we can instantiate a "Title" and
			// "Article" object. We don't actually plug this into the
			// FauxRequest, but they're required for the writing process,
			// and they contain important information on the article in
			// question that's being edited.
			$crEditTitle = Title::newFromText( $crOrigTitle ); // First, construct "Title". "Article" relies on the former object being set.
			$crEditArticle = new Article( $crEditTitle, 0 ); // Then, construct "Article". This is where most of the article's information is.
			$wpStarttime = wfTimestampNow(); // POST var "wpStarttime" stores when the edit was started.
			$wpEdittime = $crEditArticle->getTimestamp(); // POST var "wpEdittime" stores when the article was ''last edited''. This is used to check against edit conflicts, and also why we needed to construct "Article" so early. "Article" contains the article's last edittime.
			$wpTextbox1 = "#REDIRECT [[$crRedirectTitle]]\r\n"; // POST var "wpTextbox1" stores the content that's actually going to be written. This is where we write the #REDIRECT [[Article]] stuff. We plug in $crRedirectTitle here.
			$wpSave = 1;
			$wpMinoredit = 1; // TODO: Decide on this; should this really be marked and hardcoded as a minor edit, or not? Or should we provide an option? --Digi 11/4/07
			$wpEditToken = htmlspecialchars( $wgUser->editToken() );

			// 3. Put together the params that we'll use in "FauxRequest" into a single array.
			$crRequestParams = array(
				'title' => $title,
				'wpStarttime' => $wpStarttime,
				'wpEdittime' => $wpEdittime,
				'wpTextbox1' => $wpTextbox1,
				'wpSave' => $wpSave,
				'wpMinoredit' => $wpMinoredit,
				'wpEditToken' => $wpEditToken
			);

			// 4. Construct "FauxRequest"! Using a FauxRequest object allows
			// for a transparent interface of generated request params that
			// aren't retrieved from the client itself (i.e. $_REQUEST).
			// It's a very useful tool.
			$crRequest = new FauxRequest( $crRequestParams, true );

			// 5. Construct "EditPage", which contains routines to write all
			// the data. This is where all the magic happens.
			$crEdit = new EditPage( $crEditArticle ); // We plug in the "Article" object here so EditPage can center on the article that we need to edit.
			// a. We have to plug in the correct information that we just
			// generated. While we fed EditPage with the correct "Article"
			// object, it doesn't have the correct "Title" object.
			// The "Title" object actually points to Special:CreateRedirect,
			// which don't do us any good. Instead, explicitly plug in the
			// correct objects; the objects "Article" and "Title" that we
			// generated earlier. This will center EditPage on the correct article.
			$crEdit->mArticle = $crEditArticle;
			$crEdit->mTitle = $crEditTitle;
			// b. Then import the "form data" (or the FauxRequest object that
			// we just constructed). EditPage now has all the information we
			// generated.
			$crEdit->importFormData( $crRequest );

			$permErrors = $crEditTitle->getUserPermissionsErrors( 'edit', $wgUser );
			// Can this title be created?
			if ( !$crEditTitle->exists() ) {
				$permErrors = array_merge( $permErrors,
					wfArrayDiff2( $crEditTitle->getUserPermissionsErrors( 'create', $wgUser ), $permErrors ) );
			}
			if ( $permErrors ) {
				wfDebug( __METHOD__ . ": User can't edit\n" );
				$wgOut->addWikiText( $crEdit->formatPermissionsErrorMessage( $permErrors, 'edit' ) );
				wfProfileOut( __METHOD__ );
				return;
			}

			$resultDetails = false;
			$status = $crEdit->internalAttemptSave( $resultDetails, $wgUser->isAllowed( 'bot' ) && $wgRequest->getBool( 'bot', true ) );
			$value = $status->value;

			if ( $value == EditPage::AS_SUCCESS_UPDATE || $value == EditPage::AS_SUCCESS_NEW_ARTICLE ) {
				$wgOut->wrapWikiMsg(
					"<div class=\"mw-createredirect-done\">\n$1</div>",
					array( 'createredirect-redirect-done', $crOrigTitle, $crRedirectTitle )
				);
			}

			switch ( $value ) {
				case EditPage::AS_SPAM_ERROR:
					$crEdit->spamPageWithContent( $resultDetails['spam'] );
					return;

				case EditPage::AS_BLOCKED_PAGE_FOR_USER:
					$crEdit->blockedPage();
					return;

				case EditPage::AS_READ_ONLY_PAGE_ANON:
					$crEdit->userNotLoggedInPage();
					return;

			 	case EditPage::AS_READ_ONLY_PAGE_LOGGED:
			 	case EditPage::AS_READ_ONLY_PAGE:
			 		$wgOut->readOnlyPage();
					return;

			 	case EditPage::AS_RATE_LIMITED:
			 		$wgOut->rateLimited();
					break;

			 	case EditPage::AS_NO_CREATE_PERMISSION:
			 		$crEdit->noCreatePermission();
					return;
			}

			$wgOut->mRedirect = '';
			$wgOut->mRedirectCode = '';

			// TODO: Implement error handling (i.e. "Edit conflict!" or "You don't have permissions to edit this page!") --Digi 11/4/07
		}

		$action = htmlspecialchars( $this->getTitle()->getLocalURL() );
		// Also retrieve "crTitle". If this GET var is found, we autofill the
		// "Redirect to:" field with that text.
		$crTitle = $wgRequest->getText( 'crRedirectTitle', $wgRequest->getText( 'crTitle', $par ) );
		$crTitle = Title::newFromText( $crTitle );
		$crTitle = htmlspecialchars( isset( $crTitle ) ? $crTitle->getPrefixedText() : '' );

		$msgPageTitle = wfMsgHtml( 'createredirect-page-title' );
		$msgRedirectTo = wfMsgHtml( 'createredirect-redirect-to' );
		$msgSave = wfMsgHtml( 'createredirect-save' );
		
		// 2. Start rendering the output! The output is entirely the form.
		// It's all HTML, and may be self-explanatory.
		$wgOut->addHTML( wfMsgHtml( 'createredirect-instructions' ) );
		$wgOut->addHTML( <<<END
<form id="redirectform" name="redirectform" method="post" action="$action">
<table>
<tr>
<td><label for="crOrigTitle">$msgPageTitle</label></td>
<td><input type="text" name="crOrigTitle" id="crOrigTitle" size="60" tabindex="1" /></td>
</tr>
<tr>
<td><label for="crRedirectTitle">$msgRedirectTo</label></td>
<td><input type="text" name="crRedirectTitle" id="crRedirectTitle" value="{$crTitle}" size="60" tabindex="2" /></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="crWrite" id="crWrite" value="$msgSave" tabindex="4" /></td>
</tr>
</table>
</form>
END
		);
	}

}
