<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

class AbuseFilterViewTools extends AbuseFilterView {
	function show() {
		global $wgRequest, $wgOut, $wgUser;

		// Header
		$wgOut->setSubTitle( wfMsg( 'abusefilter-tools-subtitle' ) );
		$wgOut->addWikiMsg( 'abusefilter-tools-text' );

		// Expression evaluator
		$eval = '';
		$eval .= AbuseFilter::buildEditBox( '', 'wpTestExpr' );

		// Only let users with permission actually test it
		if ( $wgUser->isAllowed( 'abusefilter-modify' ) ) {
			$eval .= Xml::tags( 'p', null,
				Xml::element( 'input',
				array(
					'type' => 'button',
					'id' => 'mw-abusefilter-submitexpr',
					'onclick' => 'doExprSubmit();',
					'value' => wfMsg( 'abusefilter-tools-submitexpr' ) )
				)
			);
			$eval .= Xml::element( 'p', array( 'id' => 'mw-abusefilter-expr-result' ), ' ' );
		}
		$eval = Xml::fieldset( wfMsg( 'abusefilter-tools-expr' ), $eval );
		$wgOut->addHTML( $eval );

		// Associated script
		$exprScript = file_get_contents( dirname( __FILE__ ) . '/tools.js' );

		$wgOut->addInlineScript( $exprScript );

		global $wgUser;

		if ( $wgUser->isAllowed( 'abusefilter-modify' ) ) {
			// Hacky little box to re-enable autoconfirmed if it got disabled
			$rac = '';
			$rac .= Xml::inputLabel(
				wfMsg( 'abusefilter-tools-reautoconfirm-user' ),
				'wpReAutoconfirmUser',
				'reautoconfirm-user',
				45
			);
			$rac .= '&nbsp;';
			$rac .= Xml::element(
				'input',
				array(
					'type' => 'button',
					'id' => 'mw-abusefilter-reautoconfirmsubmit',
					'onclick' => 'doReautoSubmit();',
					'value' => wfMsg( 'abusefilter-tools-reautoconfirm-submit' )
				)
			);
			$rac = Xml::fieldset( wfMsg( 'abusefilter-tools-reautoconfirm' ), $rac );
			$wgOut->addHTML( $rac );
		}
	}
}
