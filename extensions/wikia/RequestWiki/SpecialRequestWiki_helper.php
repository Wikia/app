<?php

/**
 * @package MediaWiki
 * @subpackage RequestWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

/**
 * wfRequestExact
 *
 * check in city_domains if we have such wikia in city_domains
 *
 * @param string $name: domain name
 * @param string $language default null - choosen language
 *
 * @return integer - 0 or 1
 */
function wfRequestExact( $name, $language = null  ) {
    $sDomain = Wikia::fixDomainName($name, $language);

    $dbr = wfGetDB( DB_SLAVE );
    $oRow = $dbr->selectRow(
        wfSharedTable("city_domains"),
        array( "count(*) as count" ),
        array( "city_domain" => $sDomain ),
        __METHOD__
    );
    return $oRow->count;
}

/**
 * wfRequestTitle
 *
 * build Title for request page
 *
 * @param string $name: domain name
 * @param string $language default null: choosen language
 *
 * @return Title: MW Title class
 */
function wfRequestTitle( $name, $language = null)
{
    global $wgContLang;

    $sTitle = ($language == "en")
        ? $wgContLang->ucfirst(trim($name))
        : $wgContLang->ucfirst(trim($language)).".".$wgContLang->ucfirst(trim($name));

    return Title::newFromText( $sTitle, NS_MAIN );
}

/**
 * wfRequestLikeOrExact
 *
 * check if name is similar or the same, using sql like queries
 *
 * @access public
 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
 *
 * @param string $name: name to check
 * @param string $language default null - choosen language
 *
 * @return array with matches
 */
function wfRequestLikeOrExact( $name, $language = null ) {

	$dbr = wfGetDB( DB_SLAVE );

	$domains = array();
	$domains["like"] = array();
	$domains["exact"] = array();
	$unique = array();

	/**
	 * don't check short names
	 */
	if( strlen( $name ) > 2 ) {

		$names = explode(" ", $name);
		$skip = false;
		$tmp_array = array();

		if( is_array( $names ) ) {
			foreach( $names as $n ) {
				if( !preg_match("/^[\w\.]+$/",$n) ) continue;
				$tmp_array[] = "city_domain like '{$n}.%'";
			}
			if( sizeof( $tmp_array ) ) {
				$condition = implode(" or ", $tmp_array);
			}
			else {
				$skip = true;
			}
		}
		else {
			$condition = "city_domain like '{$name}.%'";
		}

		if( $skip === false ) {
			#--- exact (but with language prefixes)
			$oRes = $dbr->select(
				array(
					wfSharedTable("city_domains"),
					wfSharedTable("city_list"),
				),
				array( "*" ),
				array(
					$condition,
					wfSharedTable("city_domains").".city_id = " .
					wfSharedTable("city_list").".city_id",
					wfSharedTable("city_list").".city_public" => 1
				),
				__METHOD__,
				array( "limit" => 20 )
			);

			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				if( preg_match( "/^www\./", strtolower( $oRow->city_domain ) ) )
					continue;
				if( preg_match( "/wikicities\.com/", strtolower( $oRow->city_domain ) ) )
					continue;
				$unique[ strtolower( $oRow->city_domain ) ] = 1;
				$domains["exact"][] = $oRow;
			}
			$dbr->freeResult($oRes);
		}

		#--- similar
		$skip = false;
		$tmp_array = array();

		if( is_array( $names ) ) {
			foreach( $names as $n ) {
				if (!preg_match("/^[\w\.]+$/",$n)) continue;
				$tmp_array[] = "city_domain like '%{$n}%'";
			}
			if( sizeof( $tmp_array ) ) {
				$condition = implode(" or ", $tmp_array);
			}
			else {
				$skip = true;
			}
		}
		else {
			$condition = "city_domain like '%{$name}%'";
		}

		if( $skip === false ) {
			$oRes = $dbr->select(
				array(
					wfSharedTable("city_domains"),
					wfSharedTable("city_list"),
				),
				array( "*" ),
				array(
					$condition,
					wfSharedTable("city_domains").".city_id = " .
					wfSharedTable("city_list").".city_id",
					wfSharedTable("city_list").".city_public" => 1
				),
				__METHOD__,
				array( "limit" => 20 )
			);

			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				if( preg_match( "/^www\./", strtolower( $oRow->city_domain ) ) )
					continue;
				if( preg_match( "/wikicities\.com/", strtolower( $oRow->city_domain ) ) )
					continue;
				if( array_key_exists( strtolower($oRow->city_domain), $unique)
					&& $unique[ strtolower($oRow->city_domain) ] == 1 )
					continue;
				$domains["like"][] = $oRow;
			}
			$dbr->freeResult($oRes);
		}
	}
	return $domains;
}


#----------------------------------------------------------------------------
# Ajax requests handlers
#----------------------------------------------------------------------------

/**
 * check name availability in databases (city_list and city_list_requests tables)
 */
function axWRequestCheckName() {
	wfLoadExtensionMessages("RequestWiki");

    global $wgRequest, $wgDBname, $wgContLang;

    $sName = $wgRequest->getVal('name');
    $sLang = $wgRequest->getVal('lang');
    $iEdit = $wgRequest->getVal('edit');

    $iError = 0;
    $sResponse = Wikia::successmsg(wfMsg('requestwiki-second-valid-url'));

    if (!strlen($sName)) {
        $sResponse = Wikia::errormsg(wfMsg('requestwiki-error-empty-field'));
        $iError++;
    }
    elseif (preg_match('/[^a-z0-9-]/i', $sName)) {
        $sResponse = Wikia::errormsg(wfMsg('requestwiki-error-bad-name'));
        $iError++;
    }
    else {

        $iExists = wfRequestExact($sName, $sLang);
        #--- only $aDomains['exact'] are insteresting
        if (!empty($iExists)) {
            $sResponse = Wikia::errormsg(wfMsg('requestwiki-error-name-taken'));
            $iError++;
        }
        else {
            #--- check city_list_requests as well
            $dbr = wfGetDB( DB_SLAVE );
            $oRow = $dbr->selectRow(
                wfSharedTable('city_list_requests'),
                array( '*' ),
                array(
                    'LOWER(request_name)' => strtolower($sName),
                    'request_language' => $sLang
                ),
                __METHOD__
            );
            if ( !empty($oRow->request_id) && $oRow->request_id != $iEdit ) {
                $sResponse = Wikia::errormsg(wfMsg('requestwiki-error-in-progress'));
                $iError++;
            }

            # check if there is article on requests.wikia.com and it doesn't
            # contain RequestForm* template

            #-- build page from elements
            $oTitle = wfRequestTitle( $sName, $sLang );
            $oArticle = new Article( $oTitle /*title*/, 0 );
            $sContent = $oArticle->getContent();
            if (empty($iEdit)) {
                if ($oArticle->exists() && strpos($sContent, 'RequestForm' ) === false) {
                    $sResponse = Wikia::errormsg(
                        wfMsg('requestwiki-error-page-exists', array( sprintf('<a href="%s">%s</a>',
                            $oTitle->getLocalURL(),$oTitle->getText()))
                    ));
                    $iError++;
                }
            }
        }
    }
    $aResponse = array(
        'div-body' => $sResponse,
        'is-error' => $iError,
        'div-name' => 'rw-name-check'
    );

    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

/**
 * Like or Exact
 * returns unordered list <ul><li></li></ul>
 */
function axRequestLikeOrExact()
{
	wfLoadExtensionMessages("RequestWiki");

    global $wgRequest, $wgOut;

    $sName = $wgRequest->getVal('name');
    $sLike = $sExact = $sExtra = '';

    $aDomains = wfRequestLikeOrExact( $sName );

    if (strlen($sName) < 3) {
		$sExtra = wfMsg('requestwiki-error-name-too-short');
    }
    elseif ( count($aDomains['exact']) == 0 && count($aDomains['like']) == 0 ) {
		$sExtra = wfMsg('requestwiki-first-wiki-notfound');
    }
    else {
        if (is_array($aDomains['like'])) {
            foreach ( $aDomains['like'] as $domain ) {
                $sLike .= "<li><a href=\"http://{$domain->city_domain}/\" target=\"_blank\">{$domain->city_domain}</a></li>";
            }
        }

        if (is_array($aDomains['exact'])) {
            foreach ( $aDomains['exact'] as $domain ) {
                $sExact .= "<li><a href=\"http://{$domain->city_domain}/\" target=\"_blank\">{$domain->city_domain}</a></li>";
            }
        }
        $sLike = "<ul id='cw-result-list-like'>{$sLike}</ul>";
        $sExact = "<ul id='cw-result-list-exact'>{$sExact}</ul>";
		$sExtra = wfMsg('requestwiki-first-wiki-found');
    }

    $aResponse = array(
        'like' => $sLike,
        'exact' => $sExact,
		'extra' => $wgOut->parse($sExtra)
    );

    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}


global $wgAjaxExportList;
$wgAjaxExportList[] = 'axWRequestCheckName';
$wgAjaxExportList[] = 'axRequestLikeOrExact';
