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
 * axWFactoryTagCheck
 *
 * Method for checking tag name and getting number of tagged wikis
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @access public
 *
 * @return json data
 */
function axWFactoryTagCheck() {
	global $wgRequest, $wgUser;

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		return;
	}

	$tagName = $wgRequest->getVal( "tagName" );
	if( !empty( $tagName ) ) {
		$tagsQuery = new WikiFactoryTagsQuery( $tagName );
		$wikiIds = $tagsQuery->doQuery();
		$result = array(
			'tagName' => $tagName,
			'wikiCount' => count( $wikiIds ),
			'divName' => 'wf-variable-parse'
		);
	}
	else {
		$result = array(
			'errorMsg' => 'empty tag name',
			'divName' => 'wf-variable-parse',
			'wikiCount' => 0
		);
	}

	return Wikia::json_encode( $result );
}


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
	global $wgRequest, $wgUser, $wgOut;

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		$wgOut->readOnlyPage(); #--- FIXME: later change to something reasonable
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

/**
 * axWFactoryChangeVariable
 *
 * Method for getting a change-variable form via AJAX request.
 * This is for changing the variable itself (discription, groups, etc.), NOT for
 * changing the values set on each wiki.
 *
 * @author Sean Colombo
 * @access public
 *
 * @return HTML code with variable-edit form
 */
function axWFactoryChangeVariable() {
	global $wgRequest, $wgUser, $wgOut;

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		$wgOut->readOnlyPage(); #--- FIXME: later change to something reasonable
		return;
	}

	$cv_id = $wgRequest->getVal("varid");
	$city_id = $wgRequest->getVal("wiki");

	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

	$variable = WikiFactory::getVarById( $cv_id, $city_id );
	$vars = array(
			"title"             => Title::makeTitle( NS_SPECIAL, 'WikiFactory' ),
			"groups"            => WikiFactory::getGroups(),
			"accesslevels"      => WikiFactory::$levels,
			"types"             => WikiFactory::$types,
			"cv_variable_id"    => $variable->cv_variable_id,
			"cv_name"           => $variable->cv_name,
			"cv_variable_type"  => $variable->cv_variable_type,
			"cv_access_level"   => $variable->cv_access_level,
			"cv_variable_group" => $variable->cv_variable_group,
			"cv_description"    => $variable->cv_description,
		);
	$oTmpl->set_vars($vars);

	return Wikia::json_encode( array(
		"div-body" => $oTmpl->execute( "change-variable" ),
		"div-name" => "wk-variable-form"
	));
}

/**
 * axWFactorySubmitChangeVariable
 *
 * Method for getting a change-variable form via AJAX request.
 * This is for changing the variable itself (discription, groups, etc.), NOT for
 * changing the values set on each wiki.
 *
 * @author Sean Colombo
 * @access public
 *
 * @return HTML code with variable-edit form
 */
function axWFactorySubmitChangeVariable() {
	global $wgRequest, $wgUser, $wgOut;

	if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
		$wgOut->readOnlyPage(); #--- FIXME: later change to something reasonable
		return;
	}

	$cv_variable_id = $wgRequest->getVal("cv_variable_id");
	$city_id = $wgRequest->getVal("wiki");
	$cv_name = $wgRequest->getVal("cv_name");
	$cv_variable_type = $wgRequest->getVal("cv_variable_type");
	$cv_access_level = $wgRequest->getVal("cv_access_level");
	$cv_variable_group = $wgRequest->getVal("cv_variable_group");
	$cv_description = $wgRequest->getval("cv_description");

	// Verify that the form is filled out, then add the variable if it is (display an error if it isn't).
	$errMsg = "";
	if($cv_name == ""){
		$errMsg .= "<li>Please enter a name for the variable.</li>\n";
	}
	if(!in_array($cv_variable_type, WikiFactory::$types)){
		$errMsg .= "<li>The value \"$cv_variable_type\" was not recognized as a valid WikiFactory::\$type.</li>\n";
	}
	if(!in_array($cv_access_level, array_keys(WikiFactory::$levels))){
		$errMsg .= "<li>The value \"$cv_access_level\" was not recognized as a valid key from WikiFactory::\$levels.</li>\n";
	}
	if(!in_array($cv_variable_group, array_keys(WikiFactory::getGroups()))){
		$errMsg .= "<li>The value \"$cv_variable_group\" was not recognized as a valid group_id from city_variables_groups table as returned by WikiFactory::getGroups()</li>\n";
	}
	if($cv_description == ""){
		$errMsg .= "<li>Please enter a description of what the variable is used for.</li>\n";
	}
	if($errMsg == ""){
		$success = WikiFactory::changeVariable($cv_variable_id, $cv_name, $cv_variable_type, $cv_access_level, $cv_variable_group, $cv_description);
		if(!$success){
			$errMsg .= "<li>There was a database error while trying to change the variable.  Please see the logs for more info.</li>";
		}
	}

	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$variable = WikiFactory::getVarById( $cv_variable_id, $city_id );
	if($errMsg != ""){
		$errHtml = "";
		$errHtml .= "<div style='border:1px #f00 solid;background-color:#faa;padding:5px'>";
		$errHtml .= "<strong>ERROR: Unable to update variable!</strong>";
		$errHtml .= "<ul>\n$errMsg</ul>\n";
		$errHtml .= "</div>";
		$vars = array(
				"error_message"     => $errHtml,
				"title"             => Title::makeTitle( NS_SPECIAL, 'WikiFactory' ),
				"groups"            => WikiFactory::getGroups(),
				"accesslevels"      => WikiFactory::$levels,
				"types"             => WikiFactory::$types,
				"cv_variable_id"    => $cv_variable_id,
				"cv_name"           => $cv_name,
				"cv_variable_type"  => $cv_variable_type,
				"cv_access_level"   => $cv_access_level,
				"cv_variable_group" => $cv_variable_group,
				"cv_description"    => $cv_description,
			);
		$oTmpl->set_vars($vars);

		return Wikia::json_encode( array(
			"div-body" => $oTmpl->execute( "change-variable" ),
			"div-name" => "wk-variable-form"
		));
	} else {
		// Set it back to the normal form for just setting the variable's value for the current wiki.
		$oTmpl->set_vars( array(
			"cityid"        => $city_id,
			"variable"      => WikiFactory::getVarById( $cv_variable_id, $city_id ),
			"groups"        => WikiFactory::getGroups(),
			"accesslevels"  => WikiFactory::$levels,
		));

		// Inject a success message above the form so that the user know the updates worked.
		$html = "";
		$html .= "<div style='border:1px #0f0 solid;background-color:#afa;padding:5px'>";
		$html .= "<strong>{$variable->cv_name}</strong> successfully updated.";
		$html .= "</div>";

		return Wikia::json_encode( array(
			"div-body" => $html . $oTmpl->execute( "variable" ),
			"div-name" => "wk-variable-form"
		));
	}
}

function axWFactoryDomainCRUD($type="add") {
    global $wgRequest, $wgUser, $wgExternalSharedDB, $wgOut;
    $sDomain = $wgRequest->getVal("domain");
    $city_id = $wgRequest->getVal("cityid");

    if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
        $wgOut->readOnlyPage(); #--- later change to something reasonable
        return;
    }
    if (empty($city_id)) {
        $wgOut->readOnlyPage(); #--- later change to something reasonable
        return;
    }
    $dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
    $aDomains = array();
    $aResponse = array();
    $sInfo = "";
    switch( $type ) {
		case "add":
			if (!preg_match("/^[\w\.\-]+$/", $sDomain)) {
				/**
				 * check if domain is valid (a im sure that there is function
				 * somewhere for such purpose
				 */
				$sInfo .= "Error: Domain <em>{$sDomain}</em> is invalid (or empty) so it's not added.";
			}
			else {
				$added = WikiFactory::addDomain( $city_id, $sDomain );
				if ( $added ) {
					$sInfo .= "Success: Domain <em>{$sDomain}</em> added.";
				}
				else {
					$sInfo .= "Error: Domain <em>{$sDomain}</em> is already used so it's not added.";
				}
			}
			break;
        case "change":
            $sNewDomain = $wgRequest->getVal("newdomain");
            #--- first, check if domain is not used
            $oRes = $dbw->select(
                "city_domains",
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
                    "city_domains",
                    array("city_domain" => strtolower($sNewDomain)),
                    array(
                        "city_id" => $city_id,
                        "city_domain" => strtolower($sDomain)
                    )
                );
				$dbw->commit();
                $sInfo .= "Success: Domain <em>{$sDomain}</em> changed to <em>{$sNewDomain}</em>.";
            }
            break;
        case "remove":
		$removed = WikiFactory::removeDomain( $city_id, $sDomain );
		if ( $removed ) {
			$sInfo .= "Success: Domain <em>{$sDomain}</em> removed.";
		} else {
			$sInfo .= "Failed: Domain <em>{$sDomain}</em> was not removed.";
		}
            break;
        case "status":
            $iNewStatus = $wgRequest->getVal("status");
            if (in_array($iNewStatus, array(0,1,2))) {
                #--- updatec city_list table
                $dbw->update("city_list", array("city_public" => $iNewStatus),
                    array("city_id" => $city_id));
				$dbw->commit();
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
        case "setmain":
				$setmain = WikiFactory::setmainDomain( $city_id, $sDomain );
				if ( $setmain ) {
					$sInfo .= "Success: Domain <em>{$sDomain}</em> set as main.";
				} else {
					$sInfo .= "Failed: Domain <em>{$sDomain}</em> was not set as main.";
				}
            break;
    }
    #--- get actuall domain list
	 $aDomains = WikiFactory::getDomains( $city_id, true );

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

    $city_id = $wgRequest->getVal("cityid");
    $iError = 0;
    $sError = "";

    if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
        #--- no permission, do nothing
        $iError++;
        $sError = "no permission for removing";
    }
    if (empty($city_id)) {
        #--- no permission, do nothing
        $iError++;
        $sError = "city id missing";
    }

    if (empty($iError)) {
        WikiFactory::clearCache( $city_id );
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
		$tag_name = $wgRequest->getVal( 'tagName' );
		$tag_wiki_count = 0;

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

		# Save to DB, but only if no errors occurred
		if ( empty( $error ) ) {
			if( ! WikiFactory::setVarByID( $cv_id, $city_id, $cv_value ) ) {
				$error++;
				$return = Wikia::errormsg( "Variable not saved because of problems with database. Try again." );
			} else {
				$tied = WikiFactory::getTiedVariables( $cv_name );
				if( $tied ) {
					$return .= Wikia::successmsg(
						" This variable is tied with others. Check: ". implode(", ", $tied )
					);
				}
				if ( !empty( $tag_name ) ) {
					// apply changes to all wikis with given tag
					$tagsQuery = new WikiFactoryTagsQuery( $tag_name );
					foreach ( $tagsQuery->doQuery() as $tagged_wiki_id ) {
						if ( WikiFactory::setVarByID( $cv_id, $tagged_wiki_id, $cv_value ) ) {
							$tag_wiki_count++;
						}
					}
					$return .= Wikia::successmsg(" ({$tag_wiki_count} wikis affected)");
				}
			}
		}

	}

	return Wikia::json_encode(
		array(
			"div-body" => $return,
			"is-error" => $error,
			"tag-name" => $tag_name,
			"tag-wikis" => $tag_wiki_count,
			"div-name" => "wf-variable-parse"
		)
	);
}

/**
 * axWFactoryDomainQuery
 *
 * used in autocompletion
 *
 * @return string JSON encoded array
 */
function axWFactoryDomainQuery() {
	global $wgRequest;

	$query = $wgRequest->getVal( "query", false );

	$return = array(
		"query"       => $query,
		"suggestions" => array(),
		"data"        => array()
	);

	$exact = array( "suggestions" => array(), "data" => array() );
	$match = array( "suggestions" => array(), "data" => array() );

	if( $query ) {
		/**
		 * maybe not very effective but used only by staff anyway
		 */
		$query = strtolower( $query );
		$dbr = WikiFactory::db( DB_SLAVE );
		$sth = $dbr->select(
			array( "city_domains" ),
			array( "city_id", "city_domain" ),
			array(
				"city_domain not like 'www.%'",
				"city_domain not like '%.wikicities.com'",
				"city_domain like '%{$query}%'"
			),
			__METHOD__
		);

		while( $domain = $dbr->fetchObject( $sth ) ) {
			$domain->city_domain = strtolower( $domain->city_domain );
		    if( preg_match( "/^$query/", $domain->city_domain ) ) {
				$exact[ "suggestions" ][] = $domain->city_domain;
				$exact[ "data" ][] = $domain->city_id;
		    }
			elseif( preg_match( "/$query/", $domain->city_domain ) ){
				$match[ "suggestions" ][] = $domain->city_domain;
				$match[ "data" ][] = $domain->city_id;
			}
		}
		$return[ "suggestions" ] = array_merge( $exact[ "suggestions" ], $match[ "suggestions" ] );
		$return[ "data" ] = array_merge( $exact[ "data" ], $match[ "suggestions" ] );
	}

	return Wikia::json_encode( $return );
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

/**
 * axWFactoryRemoveVariable
 *
 * Ajax call, remove
 *
 * @access public
 * @author eloy@wikia
 *
 * @return string: json string with array of variables
 */
function axWFactoryRemoveVariable( ) {
	global $wgUser, $wgRequest;

	$error     = 0;
	$return    = "";

	if ( ! $wgUser->isAllowed('wikifactory') ) {
		$error++;
		$return = Wikia::errormsg( "You are not allowed to change variable value" );
	}
	else {
		$cv_id    = $wgRequest->getVal( 'varId' );
		$city_id  = $wgRequest->getVal( 'cityid' );
		$tag_name = $wgRequest->getVal( 'tagName' );
		$tag_wiki_count = 0;

		if( ! WikiFactory::removeVarById( $cv_id, $city_id ) ) {
			$error++;
			$return = Wikia::errormsg( "Variable not removed because of problems with database. Try again." );
		} else {
			$return = Wikia::successmsg( " Value of variable was removed ");
			if ( !empty( $tag_name ) ) {
				// apply changes to all wikis with given tag
				$tagsQuery = new WikiFactoryTagsQuery( $tag_name );
				foreach ( $tagsQuery->doQuery() as $tagged_wiki_id ) {
					if ( WikiFactory::removeVarByID( $cv_id, $tagged_wiki_id ) ) {
						$tag_wiki_count++;
					}
				}
				$return .= Wikia::successmsg(" ({$tag_wiki_count} wikis affected)");
			}

		}
	}

	return Wikia::json_encode(
		array(
			"div-body" => $return,
			"is-error" => $error,
			"tag-name" => $tag_name,
			"tag-wikis" => $tag_wiki_count,
			"div-name" => "wf-variable-parse"
		)
	);
}

/**
 * axAWCMetrics
 *
 * Ajax call, return filtered list of all wikis with some metrics data
 *
 * @access public
 * @author moli@wikia
 *
 * @return string: json string
 */
function axAWCMetrics() {
	global $wgUser, $wgRequest;

	if ( wfReadOnly() ) {
		return;
	}

	if ( !in_array('staff', $wgUser->getGroups()) ) {
		return "";
	}

	if( $wgUser->isBlocked() ) {
		return "";
	}

	$limit = $wgRequest->getVal('awc-limit', WikiMetrics::LIMIT);
	$page = $wgRequest->getVal('awc-offset', 0);
	$order = $wgRequest->getVal('awc-order', WikiMetrics::ORDER);
	$desc = $wgRequest->getVal('awc-desc', WikiMetrics::DESC);
	$aResponse = array('nbr_records' => 0, 'limit' => $limit, 'page' => $page, 'order' => $order, 'desc' => $desc);

	$OAWCMetrics = new WikiMetrics();
	$OAWCMetrics->getRequestParams();
	list ($res, $count) = $OAWCMetrics->getMainStatsRecords();

	if ( !empty($res) ) {
		$aResponse['data'] = $res;
		$aResponse['nbr_records'] = $count;
	}

	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	} else {
		return json_encode($aResponse);
	}
}

/**
 * axAWCMetricsCategory
 *
 * Ajax call, return # of Wikis per hubs per month
 *
 * @access public
 * @author moli@wikia
 *
 * @return string: json string
 */
function axAWCMetricsCategory() {
	global $wgUser, $wgRequest;

	if ( wfReadOnly() ) {
		return;
	}

	if ( !in_array('staff', $wgUser->getGroups()) ) {
		return "";
	}

	if( $wgUser->isBlocked() ) {
		return "";
	}

	$aResponse = array('nbr_records' => 0, 'data' => '', 'cats' => array());

	$OAWCMetrics = new WikiMetrics();
	$OAWCMetrics->getRequestParams();
	if ( !$OAWCMetrics->getFrom() ) {
		$OAWCMetrics->setFrom( date('Y/m/d', time() - WikiMetrics::TIME_DELTA * 60 * 60 * 24 ) );
	}
	list ($res, $count, $categories) = $OAWCMetrics->getCategoriesRecords();

	if ( !empty($res) ) {
		$aResponse['data'] = $res;
		$aResponse['nbr_records'] = $count;
		$aResponse['cats'] = $categories;
	}

	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	} else {
		return json_encode($aResponse);
	}
}

/**
 * axAWCMetrics
 *
 * Ajax call, return filtered list of all wikis with some metrics data
 *
 * @access public
 * @author moli@wikia
 *
 * @return string: json string
 */
function axAWCMetricsAllWikis() {
	global $wgUser, $wgRequest;

	if ( wfReadOnly() ) {
		return;
	}

	if ( !in_array('staff', $wgUser->getGroups()) ) {
		return "";
	}

	if( $wgUser->isBlocked() ) {
		return "";
	}

	$aResponse = array('nbr_records' => 0, 'data' => '');

	$OAWCMetrics = new WikiMetrics();
	$res = $OAWCMetrics->getFilteredWikis();

	if ( !empty($res) ) {
		$aResponse['data'] = $res;
		$aResponse['nbr_records'] = count($res);
	}

	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	} else {
		return json_encode($aResponse);
	}
}


global $wgAjaxExportList;
$wgAjaxExportList[] = "axWFactoryGetVariable";
$wgAjaxExportList[] = "axWFactoryChangeVariable";
$wgAjaxExportList[] = "axWFactorySubmitChangeVariable";
$wgAjaxExportList[] = "axWFactoryFilterVariables";
$wgAjaxExportList[] = "axWFactoryDomainCRUD";
$wgAjaxExportList[] = "axWFactoryDomainQuery";
$wgAjaxExportList[] = "axWFactoryClearCache";
$wgAjaxExportList[] = "axWFactorySaveVariable";
$wgAjaxExportList[] = "axAWCMetrics";
$wgAjaxExportList[] = "axAWCMetricsCategory";
$wgAjaxExportList[] = "axAWCMetricsAllWikis";
$wgAjaxExportList[] = "axWFactoryRemoveVariable";
$wgAjaxExportList[] = "axWFactoryTagCheck";
