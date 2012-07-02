<?php

class LinkEdit extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'LinkEdit' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest;

		// Check permissions
		if ( !Link::canAdmin() ) {
			$this->displayRestrictionError();
			return;
		}

		// Is the database locked or not?
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		// No access for blocked users
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Add CSS & JS
		$wgOut->addModules( 'ext.linkFilter' );

		if ( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
			$_SESSION['alreadysubmitted'] = true;

			// Update link
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update(
				'link',
				array(
					'link_url' => $_POST['lf_URL'],
					'link_description' => $_POST['lf_desc'],
					'link_type' => intval( $_POST['lf_type'] )
				),
				/* WHERE */array(
					'link_page_id' => $wgRequest->getInt( 'id' )
				),
				__METHOD__
			);

			$title = Title::newFromId( $wgRequest->getInt( 'id' ) );
			$wgOut->redirect( $title->getFullURL() );
		} else {
			$wgOut->addHTML( $this->displayEditForm() );
		}
	}

	function displayEditForm() {
		global $wgOut, $wgRequest;

		$url = $wgRequest->getVal( '_url' );
		$title = $wgRequest->getVal( '_title' );

		$l = new Link();
		$link = $l->getLinkByPageID( $wgRequest->getInt( 'id' ) );

		if( is_array( $link ) ) {
			$url = htmlspecialchars( $link['url'], ENT_QUOTES );
			$description = htmlspecialchars( $link['description'], ENT_QUOTES );
		} else {
			$title = SpecialPage::getTitleFor( 'LinkSubmit' );
			$wgOut->redirect( $title->getFullURL() );
		}

		$wgOut->setPageTitle( wfMsg( 'linkfilter-edit-title', $link['title'] ) );

		$_SESSION['alreadysubmitted'] = false;

		$output = '<div class="lr-left">

			<div class="link-home-navigation">
				<a href="' . Link::getHomeLinkURL() . '">' .
					wfMsg( 'linkfilter-home-button' ) . '</a>';

		if( Link::canAdmin() ) {
			$output .= ' <a href="' . Link::getLinkAdminURL() . '">' .
				wfMsg( 'linkfilter-approve-links' ) . '</a>';
		}

		$output .= '<div class="cleared"></div>
			</div>
			<form name="link" id="linksubmit" method="post" action="">
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
				<textarea tabindex="3" class="lr-input" rows="4" name="lf_desc" id="lf_desc">'
				. $description .
				'</textarea>

				<div class="link-submit-title">
					<label>' . wfMsg( 'linkfilter-type' ) . '</label>
				</div>
				<select tabindex="4" name="lf_type" id="lf_type">
				<option value="">-</option>';
		$linkTypes = Link::getLinkTypes();
		foreach( $linkTypes as $id => $type ) {
			$selected = '';
			if ( $link['type'] == $id ) {
				$selected = ' selected="selected"';
			}
			$output .= "<option value=\"{$id}\"{$selected}>{$type}</option>";
		}
		$output .= '</select>
				<div class="link-submit-button">
					<input tabindex="5" class="site-button" type="button" id="link-submit-button" value="' . wfMsg( 'linkfilter-submit-button' ) . '" />
				</div>
			</form>
		</div>';

		$output .= '<div class="lr-right">' .
			wfMsgExt( 'linkfilter-instructions', 'parse' ) .
		'</div>
		<div class="cleared"></div>';

		return $output;
	}

}