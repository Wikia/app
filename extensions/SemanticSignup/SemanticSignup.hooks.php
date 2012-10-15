<?php

/**
 * Static class for hooks handled by the SemanticSignup extension.
 *
 * @since 0.3
 *
 * @file SemanticSignup.hooks.php
 * @ingroup SemanticSignup
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SemanticSignupHooks {

    /**
     * @since 0.3
     *
     * @param $template
     *
     * @return false
     */
	public static function onUserCreateForm( $template ) {
		if ( is_null( Title::newFromText( SemanticSignupSettings::get( 'formName' ), SF_NS_FORM ) ) ) {
			return true;
		}

		$url = SemanticSignup::getTitleFor( 'SemanticSignup' )->escapeFullURL();
		global $wgOut;
		$wgOut->redirect( $url );

		return false;
	}

    /**
     * @since 0.3
     *
     * @return true
     */
	public static function onParserFirstCallInit() {
        global $wgParser;
        $wgParser->setFunctionHook( 'signupfields', 'SES_SignupFields::render' );
        return true;
	}

}
