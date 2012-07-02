<?php
/**
 * A special page for submitting new links for link admin approval.
 *
 * @file
 * @ingroup Extensions
 */
class LinkSubmit extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'LinkSubmit' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest;

		// Anonymous users need to log in first
		if ( $wgUser->isAnon() ) {
			throw new ErrorPageError( 'linkfilter-login-title', 'linkfilter-login-text' );
			return true;
		}

		// Is the database locked or not?
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		// Blocked through Special:Block? No access for you either
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Add CSS & JS (JS is required by displayAddForm())
		$wgOut->addModules( 'ext.linkFilter' );

		// If the request was POSTed and we haven't already submitted it, start
		// processing it
		if ( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
			$_SESSION['alreadysubmitted'] = true;

			// No link title? Show an error message in that case.
			if ( !$wgRequest->getVal( 'lf_title' ) ) {
				$wgOut->setPageTitle( wfMsg( 'error' ) );
				$wgOut->addHTML( $this->displayAddForm() );
				return true;
			}

			// The link must have a description, too!
			if ( !$wgRequest->getVal( 'lf_desc' ) ) {
				$wgOut->setPageTitle( wfMsg( 'error' ) );
				$wgOut->addHTML( $this->displayAddForm() );
				return true;
			}

			// ...and it needs a type
			if ( !$wgRequest->getInt( 'lf_type' ) ) {
				$wgOut->setPageTitle( wfMsg( 'error' ) );
				$wgOut->addHTML( $this->displayAddForm() );
				return true;
			}

			// Initialize a new instance of the Link class so that we can use
			// its non-static functions
			$link = new Link();

			// If we have a real URL, only then add the link to the database.
			if ( $link->isURL( $wgRequest->getVal( 'lf_URL' ) ) ) {
				$link->addLink(
					$wgRequest->getVal( 'lf_title' ),
					$wgRequest->getVal( 'lf_desc' ),
					htmlspecialchars( $wgRequest->getVal( 'lf_URL' ) ),
					$wgRequest->getInt( 'lf_type' )
				);
				// Great success, comrade!
				$wgOut->setPageTitle( wfMsg( 'linkfilter-submit-success-title' ) );
				$wgOut->addHTML(
					'<div class="link-success-text">' .
						wfMsg( 'linkfilter-submit-success-text' ) .
					'</div>
					<div class="link-submit-button">
						<input type="button" onclick="window.location=\'' .
							Link::getSubmitLinkURL() . '\'" value="' .
							wfMsg( 'linkfilter-submit-another' ) . '" />
					</div>'
				);
			}
		} else { // Something went wrong...
			$wgOut->setPageTitle( wfMsg( 'linkfilter-submit-title' ) );
			$wgOut->addHTML( $this->displayAddForm() );
		}
	}

	/**
	 * Display the form for submitting a new link.
	 * @return String: HTML
	 */
	function displayAddForm() {
		global $wgRequest;

		$url = $wgRequest->getVal( '_url' );
		$title = $wgRequest->getVal( '_title' );

		if( !$url ) {
			$url = 'http://';
		}

		if( !$title ) {
			$titleFromRequest = $wgRequest->getVal( 'lf_title' );
			if( isset( $titleFromRequest ) ) {
				$title = $titleFromRequest;
			}
		}

		$_SESSION['alreadysubmitted'] = false;

		$descFromRequest = $wgRequest->getVal( 'lf_desc' );
		$lf_desc = isset( $descFromRequest ) ? $descFromRequest : '';

		$output = '<div class="lr-left">

			<div class="link-home-navigation">
				<a href="' . Link::getHomeLinkURL() . '">' .
					wfMsg( 'linkfilter-home-button' ) . '</a>';

		// Show a link to the LinkAdmin page for privileged users
		if( Link::canAdmin() ) {
			$output .= ' <a href="' . Link::getLinkAdminURL() . '">' .
				wfMsg( 'linkfilter-approve-links' ) . '</a>';
		}

		$output .= '<div class="cleared"></div>
			</div>
			<form name="link" id="linksubmit" method="post" action="">
				<div class="link-submit-title">
					<label>' . wfMsg( 'linkfilter-title' ) . '</label>
				</div>
				<input tabindex="1" class="lr-input" type="text" name="lf_title" id="lf_title" value="' . $title . '" maxlength="150" />
				<div class="link-submit-title">
					<label>' . wfMsg( 'linkfilter-url' ) . '</label>
				</div>
				<input tabindex="2" class="lr-input" type="text" name="lf_URL" id="lf_URL" value="' . $url . '"/>

				<div class="link-submit-title">
					<label>' . wfMsg( 'linkfilter-description' ) . '</label>
				</div>
				<div class="link-characters-left">' .
					wfMsg( 'linkfilter-description-max' ) . ' - ' .
					wfMsg( 'linkfilter-description-left', '<span id="desc-remaining">300</span>' ) .
				'</div>
				<textarea tabindex="3" class="lr-input" rows="4" name="lf_desc" id="lf_desc" value="' . $lf_desc . '"></textarea>

				<div class="link-submit-title">
					<label>' . wfMsg( 'linkfilter-type' ) . '</label>
				</div>
				<select tabindex="4" name="lf_type" id="lf_type">
				<option value="">-</option>';
		$linkTypes = Link::getLinkTypes();
		foreach( $linkTypes as $id => $type ) {
			$output .= "<option value=\"{$id}\">{$type}</option>";
		}
		$output .= '</select>
				<div class="link-submit-button">
					<input tabindex="5" class="site-button" type="button" id="link-submit-button" value="' . wfMsg( 'linkfilter-submit-button' ) . '" />
				</div>
			</form>
		</div>';

		$output .= '<div class="lr-right">' .
			wfMessage( 'linkfilter-instructions' )->inContentLanguage()->parse() .
		'</div>
		<div class="cleared"></div>';

		return $output;
	}

}
