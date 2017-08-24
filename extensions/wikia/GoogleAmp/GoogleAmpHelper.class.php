<?php

class GoogleAmpHelper {
    /**
     * Attempts to recover a URL that was truncated by an external service (e.g. /wiki/Wanted! --> /wiki/Wanted)
     * @param Article $article
     * @param bool $outputDone
     * @param bool $pcache
     * @return bool
     */
    static public function onBeforePageDisplay( OutputPage $out, Skin $skin ): bool {

        $title = $out->getTitle();
        $isMainpage = $title->isMainPage();
        if ( $isMainpage ) {
            //$meta["og:type"] = "website";
            //$meta["og:title"] = $wgSitename;
        } else {
            $out->addLink( [
                'rel' => 'alternate',
                'href' => 'http://example.com',
                'hreflang' => 'en-us'
            ] );
        }

        return true;
    }
}
