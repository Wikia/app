<?php

/**
 * HTML form for Special:Movepage
 * @ingroup SpecialPage
 */
class CustomMovePageForm extends MovePageForm{

	/**
	 * Show the form
	 * @param mixed $err Error message. May either be a string message name or
	 *    array message name and parameters, like the second argument to
	 *    OutputPage::wrapWikiMsg().
	 */
	function showForm( $err ) {
		global $wgOut, $wgUser;

		$skin = $this->getSkin();
		$oldTitleLink = $skin->makeLinkObj( $this->oldTitle );

		$wgOut->setPagetitle( wfMsg( 'move-page', $this->oldTitle->getPrefixedText() ) );
		//$wgOut->setSubtitle( wfMsg( 'move-page-backlink', $oldTitleLink ) );

		$newTitle = $this->newTitle;

		if( !$newTitle ) {
			# Show the current title as a default
			# when the form is first opened.
			$newTitle = $this->oldTitle;
		}
		else {
			if( empty($err) ) {
				# If a title was supplied, probably from the move log revert
				# link, check for validity. We can then show some diagnostic
				# information and save a click.
				$newerr = $this->oldTitle->isValidMoveOperation( $newTitle );
				if( $newerr ) {
					$err = $newerr[0];
				}
			}
		}

		if ( !empty($err) && $err[0] == 'articleexists' && $wgUser->isAllowed( 'delete' ) ) {
			$wgOut->addWikiMsg( 'delete_and_move_text', $newTitle->getPrefixedText() );
			$movepagebtn = wfMsg( 'delete_and_move' );
			$submitVar = 'wpDeleteAndMove';
			$confirm = "
				<tr>
					<td></td>
					<td class='mw-input'>" .
						Xml::checkLabel( wfMsg( 'delete_and_move_confirm' ), 'wpConfirm', 'wpConfirm' ) .
					"</td>
				</tr>";
			$err = '';
		} else {
			$wgOut->addWikiMsg( 'movepagetext' );
			$movepagebtn = wfMsg( 'movepagebtn' );
			$submitVar = 'wpMove';
			$confirm = false;
		}

		$oldTalk = $this->oldTitle->getTalkPage();
		$considerTalk = ( !$this->oldTitle->isTalkPage() && $oldTalk->exists() );

		if ( $considerTalk ) {
			$wgOut->addWikiMsg( 'movepagetalktext' );
		}

		$titleObj = SpecialPage::getTitleFor( 'Movepage' );
		$token = htmlspecialchars( $wgUser->getEditToken() );

		if ( !empty($err) ) {
			$wgOut->setSubtitle( wfMsg( 'formerror' ) );
			if( $err[0] == 'hookaborted' ) {
				$hookErr = $err[1];
				$errMsg = "<p><strong class=\"error\">$hookErr</strong></p>\n";
				$wgOut->addHTML( $errMsg );
			} else {
				$wgOut->wrapWikiMsg( '<p><strong class="error">$1</strong></p>', $err );
			}
		}

		$wgOut->addHTML(
			 Xml::openElement( 'form', array( 'onsubmit' => 'this.wpNewTitle.value=this.wpNewTitle.value.replace(/\?/g,\'\')', 'method' => 'post', 'action' => $titleObj->getLocalURL( 'action=submit' ), 'id' => 'movepage' ) )
		);
		Hooks::run( 'ArticleMoveForm', array( &$wgOut ) );
		$wgOut->addHTML(
			 //Xml::openElement( 'fieldset' ) .
			 //Xml::element( 'legend', null, wfMsg( 'move-page-legend' ) ) .
			 Xml::openElement( 'table', array( 'border' => '0', 'id' => 'mw-movepage-table' ) ) .
			 "<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'newtitle' ), 'wpNewTitle' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'wpNewTitle', 75, $newTitle->getPrefixedText(), array( 'type' => 'text', 'id' => 'wpNewTitle' ) ) . ' <b>?</b>' .
					Html::hidden( 'wpOldTitle', $this->oldTitle->getPrefixedText() ) .
				"</td>
			</tr>"
		);

		if( $considerTalk ) {
			$wgOut->addHTML( "
				<tr>
					<td></td>
					<td class='mw-input'>" .
						Xml::checkLabel( wfMsg( 'movetalk' ), 'wpMovetalk', 'wpMovetalk', $this->moveTalk ) .
					"</td>
				</tr>"
			);
		}

		if ( $wgUser->isAllowed( 'suppressredirect' ) ) {
			$wgOut->addHTML( "
				<tr>
					<td></td>
					<td class='mw-input' >" .
						Xml::checkLabel( wfMsg( 'move-leave-redirect' ), 'wpLeaveRedirect',
							'wpLeaveRedirect', $this->leaveRedirect ) .
					"</td>
				</tr>"
			);
		}

		if( ($this->oldTitle->hasSubpages() || $this->oldTitle->getTalkPage()->hasSubpages())
		&& $this->oldTitle->userCan( 'move-subpages' ) ) {
			$wgOut->addHTML( "
				<tr>
					<td></td>
					<td class=\"mw-input\">" .
				Xml::checkLabel( wfMsg(
						$this->oldTitle->hasSubpages()
						? 'move-subpages'
						: 'move-talk-subpages'
					),
					'wpMovesubpages', 'wpMovesubpages',
					# Don't check the box if we only have talk subpages to
					# move and we aren't moving the talk page.
					$this->moveSubpages && ($this->oldTitle->hasSubpages() || $this->moveTalk)
				) .
					"</td>
				</tr>"
			);
		}

		$wgOut->addHTML( "
				{$confirm}
			<tr>
				<td>&nbsp;</td>
				<td class='mw-submit'>" .
					Xml::submitButton( $movepagebtn, array( 'name' => $submitVar ) ) .
				"</td>
			</tr>" .
			Xml::closeElement( 'table' ) .
			Html::hidden( 'wpEditToken', $token ) .
			//Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) .
			"\n"
		);

		//$this->showLogFragment( $this->oldTitle, $wgOut );

	}

}
