<?php

class ARecoveryEngineHooks {

	/**
	 * Register recovery related scripts on the top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {


		$resourceLoader = new ResourceLoaderAdEngineSourcePointCSBootstrap();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest());
		$source = $resourceLoader->getScript($resourceLoaderContext);
		$source .= <<<EOF


//    /*
//     * Setup googletag for GPT loading
//     */
//    function resetGPT() {
//        window.googletag = {};
//        window.googletag.cmd = [];
//
//		console.log("RESET...");
//        googletag.cmd.push(function () {
//		var slot = googletag.defineSlot('/5441/wka.ent/_firefly//article/gpt/TOP_RIGHT_BOXAD', [300, 250], 'TOP_RIGHT_BOXAD').addService(googletag.pubads());
//		googletag.pubads().enableSingleRequest();
//		googletag.enableServices();
//		googletag.display('TOP_RIGHT_BOXAD');
//
//		googletag.pubads().refresh([slot], {changeCorrelator: false});
//	});
//
//
//    }
//
//    /*
//     *  Reset and load GPT via Sourcepoint proxy if initial GPT load complete and adblocker detected
//     */
//    var recoveryHasBeenRun = false;
//    function resetAndLoadGPTRecovery () {
//    	recoveryHasBeenRun = true;
//    	alert("RUNNING RECOVERY...");
//    	resetGPT();
//    }
//
//    window._sp_ = window._sp_ || {};
//    window._sp_.config = window._sp_.config || {};
//    //window._sp_.config.client_id = "kpwbBOFeVRnEVFP";
//    window._sp_.config.gpt_auto_load = false;
//    window._sp_.config.enable_rid = false;
//    window._sp_.config.content_control_callback = function() {
//        console.log('load of detection code failed, you should content lock here');
//    };
//
//    /*
//     *  setup listener for adblocker detected.  Set  flag and optionally load recovery
//     */
//    document.addEventListener('sp.blocking', function (e) {
//    	alert("IS BLOCKING!");
//        console.log('sp.blocking detected');
//        isBlocking = true;
//        if (!recoveryHasBeenRun) {
//        	resetAndLoadGPTRecovery();
//
//        }
//    });
//
//    /*
//     * adblock not detected - don't do anything
//     */
//    document.addEventListener('sp.not_blocking', function (e) {
//        console.log('sp.not_blocking');
//    });

	spBootstrap('/api/v1/ARecoveryEngine/delivery', '/api/v1/ARecoveryEngine/message');
EOF;


		$scripts = '<script>' . $source . '</script>' . $scripts;

		return true;
	}
}
