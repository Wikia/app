<?php

class SpecialCongressFail extends UnlistedSpecialPage {

	/**
	 * Constructor.
	 *
	 * @param $request is the request (usually wgRequest)
	 * @param $par is everything in the URL after Special:CongressFail
	 */
	public function __construct( $request = null, $par = null ) {
		parent::__construct( 'CongressFail' );
	}

	public function execute( $subPage ) {
		global $wgRequest, $wgUser;

		$zip = (int)$wgRequest->getVal( 'zip' );

		$out = $this->getOutput();
		$this->setHeaders();
		$this->outputHeader();
		
		if( $wgRequest->getVal( 'store' ) ) {
			$dbw = wfGetDb( DB_MASTER );

			$res = $dbw->insert(
				'cl_errors',
				array(
					'cle_zip' => $zip,
					'cle_comment' => $wgRequest->getVal( 'comment' ),
				),
				__METHOD__,
				array()
			);
			
			$out->addHtml('Thank you!');
			
		} else {
			$out->addHtml('<form method=post action="/wiki/Special:CongressFail">');
			$out->addHtml('<div>');
			$out->addHtml('<div>');
			if ( $zip != 0 ) {
				$out->addHtml('ZIP Code (will be recorded): ' . $zip);
				$out->addHtml('<input type=hidden name=zip value=' . $zip . '>');
			} else {
				$out->addHtml('ZIP code: <input name=zip>');
			}
			$out->addHtml('</div>');
			$out->addHtml('Tell us what went wrong: <input type=text size=100 name=comment maxlength=255>');
			$out->addHtml('</div>');

			$out->addHtml('<div>');
			$out->addHtml('<input type=submit name=store value="Send Error Report">');
			$out->addHtml('</div>');
			$out->addHtml('</form>');
		}
	}

}
