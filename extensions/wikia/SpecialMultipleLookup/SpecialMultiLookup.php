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

		$pager = new MultiLookupPager( $this->getContext(), $data['target'] );

		$this->getOutput()->addHTML(
			$pager->getNavigationBar() . $pager->getBody() . $pager->getNavigationBar()
		);

		$this->getOutput()->addModules( 'ext.wikia.multiLookup' );

		return true;
	}

	/**
	 * Do something exciting on successful processing of the form, most likely to show a
	 * confirmation message
	 */
	public function onSuccess() {
		// nothing to do
	}

	static public function onContributionsToolLinks( $id, $nt, &$links ) {
		global $wgUser; // NOSONAR

		if ( $id == 0 && $wgUser->isAllowed( 'multilookup' ) ) {
			$attribs = [
				'href' => 'http://community.wikia.com/wiki/Special:MultiLookup?target=' . urlencode( $nt->getText() ),
				'title' => wfMessage( 'multilookupselectuser' )->text(),
			];

			$links[] = Html::element( 'a', $attribs, wfMessage( 'multilookup' )->text() );
		}

		return true;
	}
}
