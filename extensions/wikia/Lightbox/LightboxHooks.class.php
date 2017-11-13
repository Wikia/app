<?php

/**
 * Class LightboxHooks
 */
class LightboxHooks {

	/**
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript( &$vars ) {
		$vars['wgEnableLightboxExt'] = true;

		return true;
	}

	public static function onGetHTMLAfterBody( Skin $skin, &$html ) {
		// When starting the page with ?file URL param, start with the blackout layer
		if ( $skin->getRequest()->getVal( 'file' ) ) {
			$html .= Html::element( 'dev', [
				'class' => 'lightbox-beforejs-blackout',
				'style' => 'background: #fff; height: 100%; left: 0; opacity: .65; position: fixed; top: 0; width: 100%; z-index: 10000000;'
			] );
		}
		return true;
	}

}
