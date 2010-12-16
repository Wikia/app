<?php
abstract class ThreadActionPage extends UnlistedSpecialPage {
	protected $user, $output, $request, $title, $mThread;

	function __construct() {
		parent::__construct( $this->getPageName(), $this->getRightRequirement() );
		$this->includable( false );

		global $wgOut, $wgUser, $wgRequest;
		$this->output = $wgOut;
		$this->user = $wgUser;
		$this->request = $wgRequest;
	}

	abstract function getPageName();

	abstract function getFormFields();

	protected function getRightRequirement() { return ''; }

	function execute( $par ) {
		wfLoadExtensionMessages( 'LiquidThreads' );

		global $wgOut, $wgUser;

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		// Page title
		$wgOut->setPageTitle( $this->getDescription() );

		if ( !$this->checkParameters( $par ) ) {
			return;
		}

		$form = $this->buildForm();
		$form->show();
	}

	// Loads stuff like the thread and so on
	function checkParameters( $par ) {
		// Handle parameter
		$this->mTarget = $par;
		if ( $par === null || $par === "" ) {
			wfLoadExtensionMessages( 'LiquidThreads' );
			$this->output->addHTML( wfMsg( 'lqt_threadrequired' ) );
			return false;
		}

		$thread = Threads::withRoot( new Article( Title::newFromURL( $par ) ) );
		if ( !$thread ) {
			$this->output->addHTML( wfMsg( 'lqt_nosuchthread' ) );
			return false;
		}

		$this->mThread = $thread;

		return true;
	}

	abstract function getSubmitText();

	function buildForm() {
		$form = new HTMLForm( $this->getFormFields(), 'lqt-' . $this->getPageName() );

		$par = $this->mThread->title()->getPrefixedText();

		$form->setSubmitText( $this->getSubmitText() );
		$form->setTitle( SpecialPage::getTitleFor( $this->getPageName(), $par ) );
		$form->setSubmitCallback( array( $this, 'trySubmit' ) );

		return $form;
	}

	abstract function trySubmit( $data );
}
