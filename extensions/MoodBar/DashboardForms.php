<?php
/**
 * Contains assorted forms associated with the Feedback Dashboards
 */


abstract class MBDashboardForm {
	/**
	 * Gets an HTMLForm object suitable for showing this form
	 */
	public function getForm() {
		$form = new HTMLForm( $this->getFormDescriptor() );
		$form->setSubmitCallback( array( $this, 'submit' ) );
		
		return $form;
	}
	
	/**
	 * Shows the form, but returns the output as HTML instead of sending it to $wgOut
	 */
	public function show() {
		global $wgOut;
		
		$oldText = $wgOut->getHTML();
		$wgOut->clearHTML();
		
		$result = $this->getForm()->show();
		
		$output = $wgOut->getHTML();
		$wgOut->clearHTML( );
		$wgOut->addHTML( $oldText );

		if ( $result === true ) {
			return true;
		}
		
		return $output;
	}
	
	/**
	 * Gets the HTMLForm form descriptor
	 * @return A structured array suitable for the HTMLForm constructor.
	 */
	public abstract function getFormDescriptor();
	
	/**
	 * Submits the form.
	 */
	public abstract function submit( $data );
}

abstract class MBActionForm extends MBDashboardForm {
	public function __construct( $id ) {
		$this->id = $id;
	}
	
	public function getForm() {
		$form = parent::getForm();
		
		$title = SpecialPage::getTitleFor( 'FeedbackDashboard', $this->id );
		$form->setTitle( $title );
		
		return $form;
	}

	/**
	 * Adds an 'item' field to provide built in support for doing actions to feedback items.
	 */
	public function getFormDescriptor() {
		$template = array(
			'item' => array(
				'type' => 'hidden',
				'required' => true,
				'readonly' => 'readonly',
				'label-message' => 'moodbar-action-item',
				'default' => $this->id,
			),
			'reason' => array(
				'type' => 'text',
				'size' => '60',
				'maxlength' => '200',
				'label-message' => 'movereason',
			),
		);
		
		return $template;
	}
	
	/**
	 * Load our item and do our thing
	 */
	public function submit( $data ) {
		$id = $data['item'];
		$dbr = wfGetDB( DB_SLAVE );
		
		$row = $dbr->selectRow( 'moodbar_feedback', '*',
			array( 'mbf_id' => $id ), __METHOD__ );
		
		if ( ! $row ) {
			return wfMessage( 'moodbar-invalid-item' )->parse();
		}
		
		$feedbackItem = MBFeedbackItem::load( $row );
		
		$this->manipulateItem( $feedbackItem, $data );
		
		return true;
	}
	
	/**
	 * Do whatever action you need to do to the $feedbackItem in this function
	 * @param $feedbackItem MBFeedbackItem to manipulate.
	 * @param $data The form data.
	 */
	protected abstract function manipulateItem( $feedbackItem, $data );
}

class MBHideForm extends MBActionForm {
	public function getFormDescriptor() {
		$desc = parent::getFormDescriptor();
		$desc += array(
			'hide-feedback' => array(
				'type' => 'hidden',
				'default' => '1',
				'name' => 'hide-feedback',
			),
		);
		
		return $desc;
	}
	
	protected function manipulateItem( $feedbackItem, $data ) {
		$feedbackItem->setProperty('hidden-state', 255);
		$feedbackItem->save();
		
		$title = SpecialPage::getTitleFor( 'FeedbackDashboard',
			$feedbackItem->getProperty('id') );
		
		$logPage = new LogPage('moodbar');
		$logPage->addEntry( 'hide', $title, $data['reason'] );
	}
	
	public function getForm() {
		$form = parent::getForm();
		
		$header = Html::rawElement( 'h3', null,
			wfMessage( 'moodbar-hide-header' )->parse() );
		
		$header .= wfMessage( 'moodbar-hide-intro' )->parse();
		
		$form->addPreText( $header );
		
		return $form;
	}
}

class MBRestoreForm extends MBActionForm {
	public function getFormDescriptor() {
		$desc = parent::getFormDescriptor();
		$desc += array(
			'restore-feedback' => array(
				'type' => 'hidden',
				'default' => '1',
				'name' => 'restore-feedback',
			),
		);
		
		return $desc;
	}
	
	protected function manipulateItem( $feedbackItem, $data ) {
		$feedbackItem->setProperty('hidden-state', 0);
		$feedbackItem->save();
		
		$title = SpecialPage::getTitleFor( 'FeedbackDashboard',
			$feedbackItem->getProperty('id') );
		
		$logPage = new LogPage('moodbar');
		$logPage->addEntry( 'restore', $title, $data['reason'] );
	}
	
	public function getForm() {
		$form = parent::getForm();
		
		$header = Html::rawElement( 'h3', null,
			wfMessage( 'moodbar-restore-header' )->parse() );
		
		$header .= wfMessage( 'moodbar-restore-intro' )->parse();
		
		$form->addPreText( $header );
		
		return $form;
	}
}
