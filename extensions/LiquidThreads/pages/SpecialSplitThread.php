<?php
// TODO access control
class SpecialSplitThread extends ThreadActionPage {
	function getFormFields() {
		$splitForm = array(
			'src' => array(
				'type' => 'info',
				'label-message' => 'lqt-thread-split-thread',
				'default' => LqtView::permalink( $this->mThread ),
				'raw' => 1,
			),
			'subject' => array(
				'type' => 'text',
				'label-message' => 'lqt-thread-split-subject',
			),
			'reason' => array(
				'label-message' => 'movereason',
				'type' => 'text',
			),
		);

		return $splitForm;
	}

	/**
	* @see SpecialPage::getDescription
	*/
	function getDescription() {
		return wfMsg( 'lqt_split_thread' );
	}

	protected function getRightRequirement() { return 'lqt-split'; }

	function trySubmit( $data ) {
		// Load data
		$newSubject = $data['subject'];
		$reason = $data['reason'];

		$this->mThread->split( $newSubject, $reason );

		$link = LqtView::linkInContext( $this->mThread );

		global $wgOut;
		$wgOut->addHTML( wfMsgExt( 'lqt-split-success', array( 'parseinline', 'replaceafter' ),
							 $link ) );

		return true;
	}

	function validateSubject( $target ) {
		if ( !$target ) {
			return wfMsgExt( 'lqt_split_nosubject', 'parseinline' );
		}

		$title = null;
		$article = $this->mThread->article();

		$ok = Thread::validateSubject( $target, $title, null, $article );

		if ( !$ok ) {
			return wfMsgExt( 'lqt_split_badsubject', 'parseinline' );
		}

		return true;
	}

	function getPageName() {
		return 'SplitThread';
	}

	function getSubmitText() {
		return wfMsg( 'lqt-split-submit' );
	}
}
