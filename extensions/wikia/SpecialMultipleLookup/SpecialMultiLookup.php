<?php

class SpecialMultiLookup extends FormSpecialPage {

	public function __construct() {
		parent::__construct( 'MultiLookup' /* name */, 'multilookup' /* restriction */ );
	}

	/**
	 * Get an HTMLForm descriptor array
	 * @return array
	 */
	protected function getFormFields() {
		return [
			'target' => [
				'type' => 'text',
				'tabindex' => '1',
				'id' => 'ml-target',
				'required' => true,
			],
		];
	}

	protected function alterForm( HTMLForm $form ) {
		$form->setMethod( 'get' );
	}

	public function execute( $par ) {
		// Support passing IP address as target parameter
		$target = $this->getRequest()->getVal( 'target' );
		if ( $target && !$this->getRequest()->getCheck( 'wptarget' ) ) {
			$this->getRequest()->setVal( 'wptarget', $target );
		}

		parent::execute( $par );
	}

	/**
	 * Process the form on submission.
	 * @param  $data array
	 * @return Bool|array true for success, false for didn't-try, array of errors on failure
	 */
	public function onSubmit( array $data ) {
		// form not submitted
		if ( empty( $data['target'] ) ) {
			return false;
		}

		if ( !IP::isIPAddress( $data['target'] ) ) {
			return $this->msg( 'multilookupinvaliduser' )->text();
		}

		$out = $this->getOutput();

		// Make sure the form is always displayed so that a new search can be started
		$out->addHTML( $this->getForm()->displayForm( false ) );

		$pager = new MultiLookupPager( $this->getContext(), $data['target'] );

		$out->addHTML(
			$pager->getNavigationBar() . $pager->getBody() . $pager->getNavigationBar()
		);

		$out->addModules( 'ext.wikia.multiLookup' );

		return true;
	}

	/**
	 * Do something exciting on successful processing of the form, most likely to show a
	 * confirmation message
	 */
	public function onSuccess() {
		// nothing to do
	}
}
