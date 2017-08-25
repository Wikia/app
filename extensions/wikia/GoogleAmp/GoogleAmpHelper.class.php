<?php

class GoogleAmpHelper {

    static public function isAmpEnabled ( Title $title): bool {
        global $wgEnableGoogleAmp, $wgGoogleAmpNamespaces, $wgGoogleAmpArticleBlacklist;

        if ( $wgEnableGoogleAmp ) {
            if ( in_array( $title->getNamespace(), $wgGoogleAmpNamespaces ) ) {
                if ( !in_array( $title->getPrefixedDBkey(), $wgGoogleAmpArticleBlacklist ) ) {
                    return true;
                }
            }
        }
        return false;
    }

    static public function getAmpAddress( Title $title ) {
        global $wgServer, $wgGoogleAmpAddress;

        if ( !self::isAmpEnabled( $title) ) {
            return null;
        }

        $wikiServer = WikiFactory::getLocalEnvURL($wgServer, WIKIA_ENV_PROD);
        $serverRegex = '/^https?:\/\/(.+)\.wikia\.com/';
        if ( preg_match( $serverRegex, $wikiServer, $groups ) !== 1 ) {
            return null;
        }
        $wikiServer = $groups[1];
        $article = $title->getPrefixedDBkey();

        return str_replace( '{WIKI}', $wikiServer, str_replace( '{ARTICLE}', $article, $wgGoogleAmpAddress));;
    }

    static public function onMercuryPageData( Title $title, &$data ): bool {
        $ampAddress = self::getAmpAddress( $title );
        if ( $ampAddress ) {
            $data['amphtml'] = $ampAddress;
        }
        return true;
    }

    /**
     * Attempts to recover a URL that was truncated by an external service (e.g. /wiki/Wanted! --> /wiki/Wanted)
     * @param Article $article
     * @param bool $outputDone
     * @param bool $pcache
     * @return bool
     */
    static public function onBeforePageDisplay( OutputPage $out, Skin $skin ): bool {
        $title = $out->getTitle();
        if ( $title ) {
            $ampArticle = self::getAmpAddress( $title );
            if ( $ampArticle ) {
                $out->addLink( [
                    'rel' => 'amphtml',
                    'href' => $ampArticle
                ] );
            }
        }
        return true;
    }
}
