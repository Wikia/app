<?php

class GoogleTagManagerHooks {
	static public function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		$inlineScript = "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-MDPTN53');";

		$scripts .= Html::inlineScript( $inlineScript );

		return true;
	}
	
	public static function onBeforePageDisplay( OutputPage $out ) {
		wfProfileIn( __METHOD__ );
		global $wgEnableGoogleTagManager;

		$out->addModules( 'ext.wikia.GoogleTagManager' );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
