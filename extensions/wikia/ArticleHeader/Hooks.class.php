<?php

namespace ArticleHeader;

class Hooks {
    /**
     * @param \OutputPage $out
     * @param \Skin $skin
     *
     * @return bool
     */
    public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
        \Wikia::addAssetsToOutput( 'article_header_scss' );

        return true;
    }
}