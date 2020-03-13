<?php

class GoogleTagManagerHooks {
	public static function onBeforePageDisplay( OutputPage $out ) {
		wfProfileIn( __METHOD__ );
		global $wgEnableGoogleTagManager;

		$inlineScript = "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-MDPTN53');";
		$noScript =  '<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MDPTN53" height="0" width="0" style="display:none;visibility:hidden"></iframe>';

		$out->addModules( 'ext.wikia.GoogleTagManager' );
		$out->addHeadItem( 'GoogleTagManager Script' , Html::inlineScript( $inlineScript ) );
		$out->addHeadItem( 'GoogleTagManager NoScript' , Html::rawElement( 'noscript', [], $noScript ) );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
