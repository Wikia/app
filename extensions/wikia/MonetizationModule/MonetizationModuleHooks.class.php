<?php
/**
 * Monetization Hooks
 */
class MonetizationModuleHooks {

    /**
     * Register monetization-related scripts on top
     *
     * @param array $vars
     * @param array $scripts
     *
     * @return bool
     */
    static public function onWikiaSkinTopScripts(&$vars, &$scripts) {
        wfProfileIn( __METHOD__ );

        // This hook is registered twice so we're going to check if the
        // script was called before we write it out again
        // TODO: figure out why this hook is registered twice
        $app = F::app();

        if ( $app->wg->MonetizationScriptsLoaded ) {
            wfProfileOut(__METHOD__);
            return true;
        }

        $isFromSearchScript =  <<<QQ
            var isFromSearch = function () {
            var ref = document.referrer;
            if (ref.indexOf('https://www.google.com/') == 0 || (ref.indexOf('google.') != -1 && ref.indexOf('mail.google.com') == -1 && ref.indexOf('url?q=') == -1 && ref.indexOf('q=') != -1)) return true;
            if (ref.indexOf('bing.com') != -1 && ref.indexOf('q=') != -1) return true;
            if (ref.indexOf('yahoo.com') != -1 && ref.indexOf('p=') != -1) return true;
            if (ref.indexOf('ask.com') != -1 && ref.indexOf('q=') != -1) return true;
            if (ref.indexOf('aol.com') != -1 && ref.indexOf('q=') != -1) return true;
            if (ref.indexOf('baidu.com') != -1 && ref.indexOf('wd=') != -1) return true;
            if (ref.indexOf('yandex.com') != -1 && ref.indexOf('text=') != -1) return true;
            if (document.cookie.replace(/(?:(?:^|.*;\s*)fromsearch\s*\=\s*([^;]*).*$)|^.*$/, "$1") == "1") return true;
			return false;
			};
			var fromsearch = isFromSearch();
			if (fromsearch) {
                var date = new Date();
                date.setTime(date.getTime() + (30 * 60 * 1000));
                document.cookie = 'fromsearch=1; expires='+date.toGMTString()+'; path=/';
            }
QQ;
        $scripts .= Html::inlineScript($isFromSearchScript) . "\n";
        $app->wg->MonetizationScriptsLoaded = true;

        wfProfileOut(__METHOD__);
        return true;
    }
}
