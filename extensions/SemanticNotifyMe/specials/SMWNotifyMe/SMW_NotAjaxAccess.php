<?php
/**
 * Author: ning
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

global $wgAjaxExportList;
$wgAjaxExportList[] = 'smwf_nm_NotifyAccess';

function smwf_nm_NotifyAccess( $method, $params ) {
	$p_array = explode( ",", $params );
	global $smwgQEnabled;

	$result = "Query disabled.";
	if ( $method == "updateMail" ) {
		global $wgUser;
		$wgUser->setGlobalPreference( 'enotifyme', $params );
		$wgUser->saveSettings();
		return wfMsg( 'smw_nm_ajax_mailupdate' );
	}
	elseif ( $method == "addNotify" ) {
		if ( $smwgQEnabled ) {
			$result = SMWNotifyProcessor::addNotify( str_replace( '&amp;', '&', str_replace( '&comma;', ',', $p_array[0] ) ),
				str_replace( '&amp;', '&', str_replace( '&comma;', ',', $p_array[3] ) ),
				$p_array[1], $p_array[2], implode( ",", array_slice( $p_array, 4 ) ) );
		}
		return $result;
	}
	elseif ( $method == "getQueryResult" ) {
		if ( $smwgQEnabled ) {
			$params .= '
| format=table
| link=all';

			// parse params and answer query
			SMWQueryProcessor::processFunctionParams( SMWNotifyProcessor::getQueryRawParams( $params ), $querystring, $params, $printouts );

			$result = SMWQueryProcessor::getResultFromQueryString( $querystring, $params, $printouts, SMW_OUTPUT_WIKI );
			switch ( $params->format ) {
				case 'timeline':
					return $result;
					break;
				case 'eventline':
					return $result;
					break;
				case 'googlepie':
					return $result[0];
					break;
				case 'googlebar':
					return $result[0];
					break;
				case 'exhibit':
					return $result;
					break;
				default:
			}
			global $wgParser;

		   	if ( ( $wgParser->getTitle() instanceof Title ) && ( $wgParser->getOptions() instanceof ParserOptions ) ) {
				$result = $wgParser->recursiveTagParse( $result );
			} else {
				global $wgTitle;
				$popt = new ParserOptions();
				$popt->setEditSection( false );
				$pout = $wgParser->parse( $result . '__NOTOC__', $wgTitle, $popt );
				// / NOTE: as of MW 1.14SVN, there is apparently no better way to hide the TOC
				SMWOutputs::requireFromParserOutput( $pout );
				$result = $pout->getText();
			}

			// add target="_new" for all links
			$pattern = "|<a|i";
			$result = preg_replace( $pattern, '<a target="_new"', $result );
		}
		return $result;
	}
	elseif ( $method == "updateStates" ) {
		if ( $smwgQEnabled ) {
			$result = SMWNotifyProcessor::updateStates( $p_array );
		}
		return $result;
	}
	elseif ( $method == "updateReportAll" ) {
		if ( $smwgQEnabled ) {
			$result = SMWNotifyProcessor::updateReportAll( $p_array );
		}
		return $result;
	}
	elseif ( $method == "updateShowAll" ) {
		if ( $smwgQEnabled ) {
			$result = SMWNotifyProcessor::updateShowAll( $p_array );
		}
		return $result;
	}
	elseif ( $method == "updateDelegates" ) {
		if ( $smwgQEnabled ) {
			$result = SMWNotifyProcessor::updateDelegates( explode( "|", $params ) );
		}
		return $result;
	}
	elseif ( $method == "delNotify" ) {
		if ( $smwgQEnabled ) {
			$result = SMWNotifyProcessor::delNotify( $p_array );
		}
		return $result;
	}
	else {
		return wfMsg( 'smw_nm_ajax_fail' );
	}
}
