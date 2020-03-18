<?php

class GoogleTagManagerHooks {
	static public function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		$tagManagerScript = "<!-- Google Tag Manager --><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-MDPTN53');</script><!-- End Google Tag Manager -->";

		$scripts .= $tagManagerScript;

		return true;
	}
	
	public static function onBeforePageDisplay( OutputPage $out ) {
		wfProfileIn( __METHOD__ );
		$tagManagerNoScript = '<!-- Google Tag Manager (noscript) --><noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MDPTN53" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->';

		$out->addModules( 'ext.wikia.GoogleTagManager' );
		$out->prependHTML( $tagManagerNoScript );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
