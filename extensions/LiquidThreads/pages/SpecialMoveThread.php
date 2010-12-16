<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class SpecialMoveThread extends ThreadActionPage {
	/**
	* @see SpecialPage::getDescription
	*/
	function getDescription() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		return wfMsg( 'lqt_movethread' );
	}

	function getFormFields() {
		return array(
			'dest-title' => array(
				'label-message' => 'lqt_move_destinationtitle',
				'type' => 'text',
				'validation-callback' => array( $this, 'validateTarget' ),
			),
			'reason' => array(
				'label-message' => 'movereason',
				'type' => 'text',
			)
		);
	}

	function getPageName() { return 'MoveThread'; }

	function getSubmitText() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		return wfMsg( 'lqt_move_move' );
	}

	function buildForm() {
		$form = parent::buildForm();

		// Generate introduction
		$intro = '';

		global $wgUser;
		$sk = $wgUser->getSkin();
		$page = $article_name = $this->mThread->article()->getTitle()->getPrefixedText();

		$edit_text = wfMsgExt( 'lqt_move_torename_edit', 'parseinline' );
		$edit_link = $sk->link(
			$this->mThread->title(),
			$edit_text,
			array(),
			array(
				'lqt_method' => 'edit',
				'lqt_operand' => $this->mThread->id()
			)
		);

		$intro .= wfMsgExt(
			'lqt_move_movingthread',
			'parse',
			array( '[[' . $this->mTarget . ']]', '[[' . $page . ']]' )
		);
		$intro .= wfMsgExt(
			'lqt_move_torename',
			array( 'parse', 'replaceafter' ),
			array( $edit_link )
		);

		$form->setIntro( $intro );

		return $form;
	}

	function checkUserRights( $oldTitle, $newTitle ) {
		global $wgUser, $wgOut;

		$oldErrors = $oldTitle->getUserPermissionsErrors( 'move', $wgUser );
		$newErrors = $newTitle->getUserPermissionsErrors( 'move', $wgUser );

		// Custom merge/unique function because we don't have the second parameter to
		// array_unique on Wikimedia.
		$mergedErrors = array();
		foreach ( array_merge( $oldErrors, $newErrors ) as $key => $value ) {
			if ( !is_numeric( $key ) ) {
				$mergedErrors[$key] = $value;
			} elseif ( !in_array( $value, $mergedErrors ) ) {
				$mergedErrors[] = $value;
			}
		}

		if ( count( $mergedErrors ) > 0 ) {
			return $wgOut->parse(
				$wgOut->formatPermissionsErrorMessage( $mergedErrors, 'move' )
			);
		}

		return true;
	}

	function trySubmit( $data ) {
		// Load data
		$tmp = $data['dest-title'];
		$newtitle = Title::newFromText( $tmp );
		$reason = $data['reason'];

		$rightsResult = $this->checkUserRights( $this->mThread->title(), $newtitle );

		if ( $rightsResult !== true )
			return $rightsResult;

		// TODO no status code from this method.
		$this->mThread->moveToPage( $newtitle, $reason, true );

		global $wgOut, $wgUser;
		$sk = $wgUser->getSkin();
		$wgOut->addHTML( wfMsgExt( 'lqt_move_success', array( 'parse', 'replaceafter' ),
			array( $sk->link( $newtitle ) ) ) );

		return true;
	}

	function validateTarget( $target ) {
		if ( !$target ) {
			return wfMsgExt( 'lqt_move_nodestination', 'parseinline' );
		}

		$title = Title::newFromText( $target );

		if ( !$title || !LqtDispatch::isLqtPage( $title ) ) {
			return wfMsgExt( 'lqt_move_thread_bad_destination', 'parseinline' );
		}

		if ( $title->equals( $this->mThread->article()->getTitle() ) ) {
			return wfMsgExt( 'lqt_move_samedestination', 'parseinline' );
		}

		return true;
	}
}
