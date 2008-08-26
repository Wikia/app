<?php

/**
 * @package MediaWiki
 * @subpackage WikiFactory
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiFactory.\n";
    exit( 1 ) ;
}


############################## Ajax methods ##################################

/**
 * axWFactoryGetVariable
 *
 * Method for getting variable form via AJAX request.
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
 * @access public
 *
 * @return HTML code with variable data
 */
function axWFactoryGetVariable() {
	global $wgRequest, $wgUser;

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		$wgOut->readOnlyPage(); #--- later change to something reasonable
		return;
	}

	$cv_id = $wgRequest->getVal("varid");
	$city_id = $wgRequest->getVal("wiki");

	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$oTmpl->set_vars( array(
		"cityid"        => $city_id,
		"variable"      => WikiFactory::getVarById( $cv_id, $city_id ),
		"groups"        => WikiFactory::getGroups(),
		"accesslevels"  => WikiFactory::$levels,
	));

	return Wikia::json_encode( array(
		"div-body" => $oTmpl->execute( "variable" ),
		"div-name" => "wk-variable-form"
	));
}

function axWFactoryDomainCRUD($type="add") {
    global $wgRequest, $wgUser;
    $sDomain = $wgRequest->getVal("domain");
    $iCityId = $wgRequest->getVal("cityid");

    if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
        $wgOut->readOnlyPage(); #--- later change to something reasonable
        return;
    }
    if (empty($iCityId)) {
        $wgOut->readOnlyPage(); #--- later change to something reasonable
        return;
    }

    $dbw = wfGetDB( DB_MASTER );
    $dbw->selectDB("wikicities");
    $aDomains = array();
    $aResponse = array();
    $sInfo = "";
    switch( $type ) {
        case "add":
            #--- first, check if domain is not used
            $oRes = $dbw->select(wfSharedTable("city_domains"), "count(*) as count",
                array("city_domain" => $sDomain), __METHOD__ );
            $oRow = $dbw->fetchObject( $oRes );
            $dbw->freeResult( $oRes );
            if ($oRow->count > 0) {
                #--- domain is used already
                $sInfo .= "Error: Domain <em>{$sDomain}</em> is already used so it's not added.";
            }
            elseif (!preg_match("/^[\w\.\-]+$/", $sDomain)) {
                #--- check if domain is valid (a im sure that there is function
                #--- somewhere for such purpose
                $sInfo .= "Error: Domain <em>{$sDomain}</em> is invalid (or empty) so it's not added.";
            }
            else {
                #--- reall add domain
                $dbw->insert(
                    wfSharedTable("city_domains"),
                    array(
                        "city_id" => $iCityId,
                        "city_domain" => strtolower($sDomain)
                    )
                );
                $sInfo .= "Success: Domain <em>{$sDomain}</em> added.";
            }
            break;
        case "change":
            $sNewDomain = $wgRequest->getVal("newdomain");
            #--- first, check if domain is not used
            $oRes = $dbw->select(
                wfSharedTable("city_domains"),
                "count(*) as count",
                array("city_domain" => $sNewDomain),
                __METHOD__
            );
            $oRow = $dbw->fetchObject( $oRes );
            $dbw->freeResult( $oRes );
            if ($oRow->count > 0) {
                #--- domain is used already
                $sInfo .= "<strong>Error: Domain <em>{$sNewDomain}</em> is already used so no change was done.</strong>";
            }
            elseif (!preg_match("/^[\w\.\-]+$/", $sNewDomain)) {
                #--- check if domain is valid (a im sure that there is function
                #--- somewhere for such purpose
                $sInfo .= "<strong>Error: Domain <em>{$sNewDomain}</em> is invalid so no change was done..</strong>";
            }
            else {
                #--- reall change domain
                $dbw->update(
                    wfSharedTable("city_domains"),
                    array("city_domain" => strtolower($sNewDomain)),
                    array(
                        "city_id" => $iCityId,
                        "city_domain" => strtolower($sDomain)
                    )
                );
                $sInfo .= "Success: Domain <em>{$sDomain}</em> changed to <em>{$sNewDomain}</em>.";
            }
            break;
        case "remove":
            $dbw->delete(wfSharedTable("city_domains"), array( "city_id" => $iCityId, "city_domain" => $sDomain ), __METHOD__);
            $sInfo .= "Success: Domain <em>{$sDomain}</em> removed.";
            break;
        case "status":
            $iNewStatus = $wgRequest->getVal("status");
            if (in_array($iNewStatus, array(0,1,2))) {
                #--- updatec city_list table
                $dbw->update(wfSharedTable("city_list"), array("city_public" => $iNewStatus),
                    array("city_id" => $iCityId));
                switch ($iNewStatus) {
                    case 0:
                        $aResponse["div-body"] = "<strong>changed to disabled</strong>";
                        break;
                    case 1:
                        $aResponse["div-body"] = "<strong>changed to enabled</strong>";
                        break;
                    case 2:
                        $aResponse["div-body"] = "<strong>changed to redirected</strong>";
                        break;
                }
            }
            else {
                $aResponse["div-body"] = "wrong status number";
            }
            $aResponse["div-name"] = "wf-domain-span";
            break;
        case "cancel":
            $sInfo .= "<em>Action cancelled</em>";
            break;
    }
    #--- get actuall domain list
    $oRes = $dbw->select(wfSharedTable("city_domains"), "city_domain",
        array("city_id" => $iCityId), __METHOD__, array("ORDER BY" => "city_domain") );
    while ( $oRow = $dbw->fetchObject( $oRes )) {
        $aDomains[] = $oRow->city_domain;
    }
    $dbw->freeResult( $oRes );
    $dbw->close();

    #--- send response, return domain array
    $aResponse["domains"] = $aDomains;
    $aResponse["info"] = $sInfo;

    return Wikia::json_encode($aResponse);
}

/**
 * clear wiki cache
 */
function axWFactoryClearCache()
{
    global $wgRequest, $wgUser, $wgOut, $wgWikiFactoryMessages;

    wfLoadExtensionMessages("WikiFactory");

    $iCityId = $wgRequest->getVal("cityid");
    $iError = 0;
    $sError = "";

    if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
        #--- no permission, do nothing
        $iError++;
        $sError = "no permission for removing";
    }
    if (empty($iCityId)) {
        #--- no permission, do nothing
        $iError++;
        $sError = "city id missing";
    }

    if (empty($iError)) {
        WikiFactory::clearCache( $iCityId );
        WikiFactory::clearInterwikiCache();

        #--- send response
        $aResponse = array(
            "div-body" => wfMsg("wikifactory_removeconfirm"),
            "div-name" => "wf-clear-cache"
        );
    }
    else {
        $aResponse = array(
            "div-body" => $sError,
            "div-name" => "wf-clear-cache"
        );
    }

    return Wikia::json_encode($aResponse);
}

/**
 * axWFactorySaveVariable
 *
 * ajax method, save variable from form
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @access public
 *
 * @return string encoded in JSON format
 */
function axWFactorySaveVariable() {
	global $wgUser, $wgRequest;

	$error     = 0;
	$return    = "";

	if ( ! $wgUser->isAllowed('wikifactory') ) {
		$error++;
		$return = Wikia::errormsg( "You are not allowed to change variable value" );
	}
	else {
		$cv_id				= $wgRequest->getVal( 'varId' );
		$city_id			= $wgRequest->getVal( 'cityid' );
		$cv_name			= $wgRequest->getVal( 'varName' );
		$cv_value			= $wgRequest->getVal( 'varValue' );
		$cv_variable_type	= $wgRequest->getVal( 'varType' );

		#--- check if variable is valid
		switch ( $cv_variable_type ) {
			case "boolean":
				if ((bool)$cv_value != $cv_value) {
					$error++;
					$return = Wikia::errormsg("Syntax error: value is not boolean. Variable not saved.");
				}
				else {
					$return = Wikia::successmsg( "Parse OK, variable saved" );
					$cv_value = (bool)$cv_value;
				}
			break;
			case "integer":
				if ((int)$cv_value != $cv_value) {
					$error++;
					$return = Wikia::errormsg( "Syntax error: value is not integer. Variable not saved." );
				}
				else {
					$return = Wikia::successmsg( "Parse OK, variable saved." );
					$cv_value = (int)$cv_value;
				}
			break;
			case "string":
				$return = Wikia::successmsg( "Parse OK, variable saved." );
			break;
			default:
				$tEval = "\$__var_value = $cv_value;";
				/**
				 * catch parse errors
				 */
				ob_start();
				if( eval( $tEval ) === FALSE ) {
					$error++;
					$return = Wikia::errormsg( "Syntax error, value is not valid PHP structure. Variable not saved." );
				}
				else {
					$cv_value = $__var_value;
					/**
					 * now check if it's actually array when we want array)
					 */
					if( in_array( $cv_variable_type, array( "array", "struct", "hash" ) ) ) {
						if( is_array( $cv_value ) ) {
							$return = Wikia::successmsg( "Syntax OK (array), variable saved." );
						}
						else {
							$error++;
							$return = Wikia::errormsg( "Syntax error: value is not array. Variable not saved." );
						}
					}
					else {
						$return = Wikia::successmsg( "Parse OK, variable saved." );
					}
				}
				ob_end_clean(); #--- puts parse error to /dev/null
		}

		if( ! WikiFactory::setVarByID( $cv_id, $city_id, $cv_value ) ) {
			$error++;
			$return = Wikia::errormsg( "Variable not saved because of problems with database. Try again." );
		}
		else {
			$tied = WikiFactory::getTiedVariables( $cv_name );
			if( $tied ) {
				$return .= Wikia::successmsg(
					" This variable is tied with others. Check: ". implode(", ", $tied )
				);
			}
		}
	}

	return Wikia::json_encode(
		array(
			"div-body" => $return,
			"is-error" => $error,
			"div-name" => "wf-variable-parse"
		)
	);
}

/**
 * axWFactoryDomainQuery
 *
 * used in autocompletion
 *
 * @param string	$input	string from input field
 *
 * @return string
 */
function axWFactoryDomainQuery( $input ) {
	$domains = WikiFactory::getDomains( null, true );
	$return = "";

    foreach( $domains as $domain ) {
        if( strpos( $domain->city_domain, $input ) ) {
            $return .= "{$domain->city_domain}\t{$domain->city_id}\n";
        }
	}

	return $return;
}

/**
 * axWFactoryFilterVariables
 *
 * Ajax call, return filtered group od variables
 *
 * @access public
 * @author eloy@wikia
 *
 * @return string: json string with array of variables
 */
function axWFactoryFilterVariables( )
{
    global $wgRequest;
    $defined = wfStrToBool( $wgRequest->getVal("defined", "false") );
    $editable = wfStrToBool( $wgRequest->getVal("editable", "false") );
    $wiki_id = $wgRequest->getVal("wiki", 0);
    $group = $wgRequest->getVal("group", 0);
	$string = $wgRequest->getVal("string", false );

    #--- cache it?
    $Variables = WikiFactory::getVariables( "cv_name", $wiki_id, $group, $defined, $editable, $string );
    $selector = "";

    foreach( $Variables as $Var) {
        $selector .= sprintf(
			"<option value=\"%d\">%s</option>\n",
            $Var->cv_id, $Var->cv_name
        );
    }

    return Wikia::json_encode(array(
        "selector" => $selector,
    ));
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "axWFactoryGetVariable";
$wgAjaxExportList[] = "axWFactoryFilterVariables";
$wgAjaxExportList[] = "axWFactoryDomainCRUD";
$wgAjaxExportList[] = "axWFactoryDomainQuery";
$wgAjaxExportList[] = "axWFactoryClearCache";
$wgAjaxExportList[] = "axWFactorySaveVariable";
