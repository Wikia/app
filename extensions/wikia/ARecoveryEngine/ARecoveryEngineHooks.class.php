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
		global $wgServer;
		$resourceLoader = new ResourceLoaderAdEngineSourcePointCSBootstrap();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest() );
		$source = $resourceLoader->getScript($resourceLoaderContext);
		$source .= <<<EOT

		window._sp_ = {
			config: {
				enable_rid: true,
				content_control_callback: function() {
					var msg = '<h2>Ad blocker interference detected!</h2>';
					msg += '<h3>If you added a new rule to your ad blocker that interferes with the loading of ads on your pages, ';
					msg += 'this Interference Screen is the expected behaviour. <br />';
					msg += 'Removing the rule(s) should load the page as expected.</h3>';

					document.getElementById('WikiaArticle').innerHTML = msg;
				}
			}
		};
EOT;

		$source .= "\nspBootstrap('{$wgServer}/api/v1/ARecoveryEngine/delivery');";
		$scripts = '<script>' . $source . '</script>' . $scripts;

		return true;
	}

	public static function onBeforePageDisplay(&$outputPage, &$skin) {
		global $wgOasisLastCssScripts;
		$sp = new ARecoveryUnlockCSS($outputPage);
		$wgOasisLastCssScripts[] = $sp->getUnlockCSSUrl();

		return true;
	}
}
