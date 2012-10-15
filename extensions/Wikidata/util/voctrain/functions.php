<?php

/** Functions.php contains a bunch of functions from the old voctrainer.
 * lots of this is probably dead code by now.
 * definitely needs a broom!
 */


require_once 'settings.php';
require_once 'DBTools.php';
require_once 'HTML/QuickForm.php';

function display_form() {

	// ////////////////////////////////////////
	// Instantiate the HTML_QuickForm object
	$form = new HTML_QuickForm( 'firstForm', 'get' );



      $languages_suggs = array( "eng" => "eng",
			   "deu" => "deu",
			   "fra" => "fra",
			   "ita" => "ita",
			   "nld" => "nld"
			   );

	$collections = array(
		'376317' => 'One laptop per child basic vocabulary',
		'376322' => 'Destinazione Italia' );

	// Set defaults for the form elements
	$form->setDefaults( array(
	    'name' => 'From'
	) );

	// Add some elements to the form
	$form->addElement( 'header', null, '' );
	$form->addElement( 'hidden', 'ow', '1' );
	$form->addElement( 'select', 'mode', 'voc browser mode:', array( 'browser' => 'lookup dictionary', 'trainer' => 'vocabulary training' ) );
	if ( $_REQUEST['mode'] == 'trainer' ) {

		$form->addElement( 'select', 'wdcollection', 'Collection to choose vocabulary from:', $collections );
		$form->addElement( 'select', 'wdlanguages_1', 'target language you want to train:', $languages_suggs );
	} else {
		$form->addElement( 'select', 'wdlanguages_1', 'first output language:', $languages_suggs );
	}
	if ( $_REQUEST['settings'] == 1 ) {
		$form->addElement( 'text', 'wdlanguages_2', 'second output language:', array( 'value' => '', 'size' => 6, 'maxlength' => 6 ) );
		$form->addElement( 'text', 'wdlanguages_3', 'third output language:', array( 'size' => 6, 'maxlength' => 6 ) );
		$form->addElement( 'text', 'wdlanguages_4', 'fourth output language:', array( 'size' => 6, 'maxlength' => 6 ) );
		$link = build_get_uri_2( 'settings', '0', '' );
		echo '<a href="' . $link . '">hide settings and languages</a>';
	} elseif ( $_REQUEST['mode'] == 'trainer' && ( $_REQUEST['trainer_step'] == 0 ) ) {
		$form->addElement( 'text', 'wdlanguages_2', 'first language you can understand:', array( 'size' => 6, 'maxlength' => 6 ) );
		$form->addElement( 'text', 'wdlanguages_3', 'second language you can understand:', array( 'size' => 6, 'maxlength' => 6 ) );
		$form->addElement( 'text', 'wdlanguages_4', 'third language you can understand:', array( 'size' => 6, 'maxlength' => 6 ) );

	} else {
		$form->addElement( 'hidden', 'wdlanguages_2', '', array( 'size' => 6, 'maxlength' => 6 ) );
		$form->addElement( 'hidden', 'wdlanguages_3', '', array( 'size' => 6, 'maxlength' => 6 ) );
		$form->addElement( 'hidden', 'wdlanguages_4', '', array( 'size' => 6, 'maxlength' => 6 ) );
		$link = build_get_uri_2( 'settings', '1', '' );
		echo '<a href="' . $link . '">edit settings and languages</a>';
	}


	if ( $_REQUEST['definedmeaning'] ) {
		$expression_group[] = &HTML_QuickForm::createElement( 'text', 'expression', 'search expression:', array( 'value' => '' , 'size' => 20, 'maxlength' => 256 ) );
		$form->updateElementAttr( 'expression', array( 'value' => '' ) );
		$expression_group[] = &HTML_QuickForm::createElement( 'text', 'wdexplanguage', 'source language of an expression <br />(leave blank to search all languages)', array( 'size' => 20, 'maxlength' => 256 ) );
	} else {
		$expression_group[] = &HTML_QuickForm::createElement( 'text', 'expression', 'search expression:', array( 'size' => 20, 'maxlength' => 256 ) );
		$expression_group[] = &HTML_QuickForm::createElement( 'text', 'wdexplanguage', 'source language of an expression <br />(leave blank to search all languages)', array( 'size' => 4, 'maxlength' => 256 ) );
	}


	$form->addGroup( $expression_group, 'Expression', 'Search Expression:', '&#160; only in this language:', 0 );

	if ( $_REQUEST['settings'] == 1 ) {
		$form->addElement( 'text', 'definedmeaning', 'definedmeaning (word-id):', array( 'value' => '', 'size' => 15 ) );
	}

	$form->addElement( 'submit', null, 'set / update' );

	// Output the form
	$form->display();
	//
	// ////////////////////////////////////////
}


function build_api_query_url() {

	global $ow_api_location;
	$ow_api_url = $ow_api_location;
	# $ow_api_url = 'http://141.13.22.237/wikidata/api.php?action=wikidata';

	if (
		( $_REQUEST['expression'] )
		OR ( ( $_REQUEST['trainer_step'] == '0' ) AND ( $_REQUEST['wdcollection'] ) )
		OR ( $_REQUEST['definedmeaning'] )
	) {

		$ow_api_url = $ow_api_url . "&wdsections=def|syntrans";


		if ( $_REQUEST['definedmeaning'] ) {

			$ow_api_url = build_get_uri_2( 'wdtype', 'definedmeaning', $ow_api_url );
			$ow_api_url = build_get_uri_2( 'wddmid', $_REQUEST['definedmeaning'], $ow_api_url );
		} elseif ( $_REQUEST['trainer_step'] == '0' AND ( !( $_REQUEST['expression'] ) ) ) {
			$ow_api_url = build_get_uri_2( 'wdtype', 'randomdm', $ow_api_url );
			$ow_api_url = build_get_uri_2( 'wdcollection', $_REQUEST['wdcollection'], $ow_api_url );
			$ow_api_url = build_get_uri_2( 'wdexplanguage', $_REQUEST['wdexplanguage'], $ow_api_url );
		} else {
			$ow_api_url = build_get_uri_2( 'wdtype', 'expression', $ow_api_url );
			$ow_api_url = build_get_uri_2( 'wdexpression', $_REQUEST['expression'], $ow_api_url );
			$ow_api_url = build_get_uri_2( 'wdexplanguage', $_REQUEST['wdexplanguage'], $ow_api_url );
		}


		// 3320
		// dog http://141.13.222.103/wau/wau_0_5/ow/retrieve_neu.php?definedmeaning=966

		// http://kantoor.edia.nl/wikidata/api.php?action=wikidata&wdexpression=casa&wdexplanguage=ita&wdsections=def|syntrans|def|altdef|syntrans|syntransann|ann|classatt|classmem|colmem|rel&wdlanguages=nld|eng|fra



		$wdlanguages_ser = get_wdlanguages( 'ser' );


		$ow_api_url = build_get_uri_2( 'wdlanguages', $wdlanguages_ser, $ow_api_url );
		

	}

	if ( $_REQUEST['debug'] == 1 ) {
		echo '<br />' . $ow_api_url . "<br />";
	}
	return $ow_api_url;
}

function get_empty_collection_xml( $collection_id ) {
	global $ow_api_location;
	$ow_api_url = $ow_api_location;
	$ow_api_url = build_get_uri_2( 'wdtype', 'collection', $ow_api_url );
	$ow_api_url = build_get_uri_2( 'collection_id', "$collection_id", $ow_api_url );
	$content = get_ow_content_1( $ow_api_url );
	$xml = new SimpleXMLElement( $content );
}



function display_account_settings( $params ) {

	if ( $GLOBALS['userdata_type'] == 'wau' ) {

		if ( $GLOBALS['a']->checkAuth() ) {
			echo '<div id="login">logged in as ' . $GLOBALS['a']->getUsername() . ' | ';
			$link = build_get_uri_2( 'logout', '1' );
			echo '<a href="' . $link . '">logout<a> | ';


		} else {
			$link = build_get_uri_2( '', '', '../tn/login_1.php' );
			$link = build_get_uri_2( 'goto', $params['goto'], $link );
			$link = build_get_uri_2( 'modulname_neu', $params['modulname_neu'], $link );
			// $link = build_get_uri_2('do_auth', '1',$link);
			echo '<a href="' . $link . '">login / create account<a> | ';
		}

		if ( $_REQUEST['get_ow_trainer_overview'] ) {
			$arr = get_ow_trainer_overview( $params );
			echo "<h2>training  overview</h2>";
			echo "<ul>";
			foreach ( $params['status_values'] as $value ) {
				echo "<li>";
				echo $params['status_messages'][$value] . ": " . current( $arr );
				next( $arr );
				echo "</li>";
			}
			echo "</ul>";
		} else {
			$link = build_get_uri_2( 'get_ow_trainer_overview', '1', '' );
			echo '<a href="' . $link . '">training  overview<a> | ';
		}

	}
}


/** 
 * obtain languages from request...
 * no input validation is done here !?
 * @param output  can be 'arr' (default) which returns an array,
 * or ser which returns some kind of string (this should be refactored)
 */
function get_wdlanguages( $output = 'arr' ) {
        $wdlanguages = array();
        $wdlanguages[] = $_REQUEST['wdlanguages_1'];
        if ( $_REQUEST['wdlanguages_2'] ) {
                $wdlanguages[] = $_REQUEST['wdlanguages_2'];
        }
        if ( $_REQUEST['wdlanguages_3'] ) {
                $wdlanguages[] = $_REQUEST['wdlanguages_3'];
        }
        if ( $_REQUEST['wdlanguages_4'] ) {
                $wdlanguages[] = $_REQUEST['wdlanguages_4'];
        }

        if ( $output == 'ser' ) {
                $wdlanguages = implode( '|', $wdlanguages );
        }

return $wdlanguages;
}


function sub_dm( $sections, $xml, $defined_meaning, $wdlanguages ) {

        echo "<li>";
        $link = build_get_uri_2();
        $link = build_get_uri_2( 'definedmeaning', (string) $defined_meaning['defined-meaning-id'], $link );


        $link_ow = 'http://www.omegawiki.org?title=';
        $link_ow .= 'DefinedMeaning:(' . (string) $defined_meaning['defined-meaning-id'] . ')';

        echo '  <h2>
                        <a href="' . $link . '">dm: ' . (string) $defined_meaning['defined-meaning-id'] . '</a>
                        </h2>';
        echo '<a href="' . $link_ow . '" title="show and edit complete data at omegawiki.org">[edit at omegawiki.org]</a>';



        $link = build_get_uri_2( 'settings', '1', '' );
        echo  ' [<a href="' . $link . '">set language(s)</a>]';

        echo display_wrap( current( $sections ), $xml, $defined_meaning, $languages );
        next( $sections );





        if ( $_REQUEST['trainer_step'] == '0' ) {
                echo build_trainer_link( 1, $defined_meaning['defined-meaning-id'] );
        }




	if ( !( $_REQUEST['trainer_step'] == '0' ) ) {
		echo display_wrap( current( $sections ), $xml, $defined_meaning, $languages );
		next( $sections );

	}


	if ( $_REQUEST['trainer_step'] == '1' ) {
			echo build_trainer_link( 2, $defined_meaning['defined-meaning-id'] );
		}

	if ( $_REQUEST['trainer_step'] == '2' ) {
			echo build_trainer_link( 0, $defined_meaning['defined-meaning-id'] );
		}

	/*
			echo '<ul>';
			foreach($xml->xpath('//defined-meaning[@defined-meaning-id="'.$defined_meaning['defined-meaning-id'].'"]//synonyms-translations[@indentical-meaning="1"]/expression[@language="'.$wdlanguage.'"]') as $expression){
				echo '<li class="ow_voc_expression">'.$expression.'</li>';
			}
			foreach($xml->xpath('//defined-meaning[@defined-meaning-id="'.$defined_meaning['defined-meaning-id'].'"]//synonyms-translations[@indentical-meaning="0"]/expression[@language="'.$wdlanguage.'"]') as $expression){
				echo '<li class="ow_voc_expression_not_identical">'.$expression.' (not identical)</li>';
			}
	*/
	echo "</li>";

}

function display_wrap( $section, $xml, $defined_meaning, $languages ) {
        if ( $section == 'def' ) {
                $string = display_definition( $xml, $defined_meaning, $languages );
        }
        if ( $section == 'syntrans' ) {
                $string = display_expression( $wdlanguages, $xml, $defined_meaning, $languages );
        }
return $string;
}

function section_reverse_link() {
        $sections = array_reverse( $GLOBALS['sections'] );
        $string = implode( '|', $sections );
        $link = build_get_uri_2( 'sections', $string );

	if ( !$GLOBALS['section_reverse_link'] ) {
		$label = 'change order definition / expression';
	} else {
		$label = 'change order definition / expression';
	}

	$link = '<a href="' . $link . '">' . $label . '</a>';
	$GLOBALS['section_reverse_link'] = '1';
	return $link;
}

function display_definition( $xml, $defined_meaning, $languages ) {
	$string = '';

	$wdlanguages = get_wdlanguages();
	if ( $_REQUEST['trainer_step'] == '0' || $_REQUEST['trainer_step'] == '1' ) {
		$languages = array();
		$languages[] = $wdlanguages[0];
	} else {
		$languages = $wdlanguages;
	}

	$string .= "<h3>definitions</h3>";
	$string .= section_reverse_link();
	$string .= '<ul>';


	$definitions = get_definition( $xml, $defined_meaning, $languages );
	foreach ( $definitions['wdlanguage'] as $wdlanguage ) {
		$string .= '<li class="ow_voc_definition">';
		$string .= $wdlanguage . ': ';
		$string .= current( $definitions['translated_text'] );
		$string .= '</li>';
		next( $definitions['translated_text'] );
	}
	$string .= '</ul>';
	return $string;
}



function display_expression( $wdlanguages, $xml, $defined_meaning, $languages ) {
        $string = '';
        $wdlanguages = get_wdlanguages();

        $string .= "<h3>expressions / translations</h3>";
        $string .= section_reverse_link();
        $string .= '<ul>';


        if ( $_REQUEST['trainer_step'] == '0' || $_REQUEST['trainer_step'] == '1' ) {
                $languages = array();
                $languages[] = $wdlanguages[0];
        } else {
                $languages = $wdlanguages;
        }

        $expressions = get_expression( $xml, $defined_meaning, $languages );
        foreach ( $expressions['wdlanguage'] as $wdlanguage ) {

                if ( ( current( $expressions['indentical_meaning'] ) ) == '1' ) {
                        $string .= '<li class="ow_voc_expression">';
                } else {
                        $string .= '<li class="ow_voc_expression_not_identical">';
                }

                # echo '<li>';
                $string .= $wdlanguage . ': ';
                $string .= '<em>' . current( $expressions['expression'] ) . '</em>';

                if ( ( current( $expressions['indentical_meaning'] ) ) == '0' ) {
                        $string .= " (not identical) ";
                }

                $string .= '</li>';
                next( $expressions['expression'] );
                next( $expressions['indentical_meaning'] );
        }
        $string .= '</ul>';
return $string;
}

function get_definition( $xml, $defined_meaning, $wdlanguages ) {
                $lang_rows['wdlanguage'] = array();
                $lang_rows['translated_text'] = array();

        foreach ( $wdlanguages as $wdlanguage ) {
		$lang_row = get_definition_sub_1( $xml, $defined_meaning, $wdlanguage );
		$lang_rows['wdlanguage'] = array_merge( $lang_rows['wdlanguage'], (array)$lang_row['wdlanguage'] );
		$lang_rows['translated_text'] = array_merge( $lang_rows['translated_text'], (array)$lang_row['translated_text'] );
        }
        if ( $lang_rows['wdlanguage'][0] == '' ) {
		echo "leer";
		$lang_row = get_definition_sub_1( $xml, $defined_meaning, 'eng' );
		$lang_rows['wdlanguage'] = array_merge( $lang_rows['wdlanguage'], (array)$lang_row['wdlanguage'] );
		$lang_rows['translated_text'] = array_merge( $lang_rows['translated_text'], (array)$lang_row['translated_text'] );
        }
// print_r($arr);
return $lang_rows;
}

function get_definition_sub_1( $xml, $defined_meaning, $wdlanguage ) {

	if ( $xml->xpath( '//defined-meaning[@defined-meaning-id="' . $defined_meaning['defined-meaning-id'] . '"]/definition/translated-text-list/translated-text[@language="' . $wdlanguage . '"]' ) ) {
		foreach ( $xml->xpath( '//defined-meaning[@defined-meaning-id="' . $defined_meaning['defined-meaning-id'] . '"]/definition/translated-text-list/translated-text[@language="' . $wdlanguage . '"]' ) as $translated_text ) {

			$arr['wdlanguage'][] = $wdlanguage;
			$arr['translated_text'][] = (string) $translated_text;
		}
	}
return $arr;

}

function get_expression( $xml, $defined_meaning, $wdlanguages ) {
                $lang_rows['wdlanguage'] = array();
                $lang_rows['expression'] = array();
                $lang_rows['indentical_meaning'] = array();

        foreach ( $wdlanguages as $wdlanguage ) {
                $lang_row = get_expression_sub_1( $xml, $defined_meaning, $wdlanguage );
                $lang_rows['wdlanguage']                        = array_merge( $lang_rows['wdlanguage'], (array)$lang_row['wdlanguage'] );
                $lang_rows['expression']                        = array_merge( $lang_rows['expression'], (array)$lang_row['expression'] );
                $lang_rows['indentical_meaning']        = array_merge( $lang_rows['indentical_meaning'], (array)$lang_row['indentical_meaning'] );
        }
        if ( $lang_rows['expression'][0] == '' ) {
                echo "leer";
                $lang_row = get_expression_sub_1( $xml, $defined_meaning, 'eng' );
                $lang_rows['wdlanguage']                        = array_merge( $lang_rows['wdlanguage'], (array)$lang_row['wdlanguage'] );
                $lang_rows['expression']                        = array_merge( $lang_rows['expression'], (array)$lang_row['expression'] );
                $lang_rows['indentical_meaning']        = array_merge( $lang_rows['indentical_meaning'], (array)$lang_row['indentical_meaning'] );

        }
	// print_r($arr);
	return $lang_rows;
}

function get_expression_sub_1( $xml, $defined_meaning, $wdlanguage ) {
        $arr = array();
        $arr = get_expression_sub_2( $arr, $xml, $defined_meaning, $wdlanguage, '1' );
        $arr = get_expression_sub_2( $arr, $xml, $defined_meaning, $wdlanguage, '0' );
return $arr;
}

function get_expression_sub_2( $arr, $xml, $defined_meaning, $wdlanguage, $indentical_meaning ) {

$xpath_expr = '//defined-meaning[@defined-meaning-id="' . $defined_meaning['defined-meaning-id'] . '"]//synonyms-translations[@indentical-meaning="' . $indentical_meaning . '"]/expression[@language="' . $wdlanguage . '"]';
if ( $defined_meaning->xpath( $xpath_expr ) ) {
        foreach ( $defined_meaning->xpath( $xpath_expr )
        as $synonyms_translation ) {

                $arr['wdlanguage'][] = $wdlanguage;
                $arr['expression'][] = (string) $synonyms_translation;
                $arr['indentical_meaning'][] = $indentical_meaning;
        }
}
return $arr;

}

function build_trainer_link( $step, $definedmeaning ) {
        $step = intval( $step );
        $link = build_get_uri_2();
	var_dump( $link );
        $link = build_get_uri_2( 'trainer_step', $step, $link );
	var_dump( $link );
        $link = build_get_uri_2( 'definedmeaning', (string) $definedmeaning, $link );
	var_dump( $link );

        if ( $step != '0' ) {
                $linktext = 'show more';
                $link_a = '
                <a href="' . $link . '">
                ' . $linktext . '
                <img src="/wau/production/bilder/pfeil_u_1.png">
                <img src="/wau/production/bilder/question_mark_1.png">
                </a>';
        }
                $link = build_get_uri_2( 'trainer_step', '0', $link );
                $link = build_get_uri_2( 'definedmeaning', '', $link );
                $linktext = 'continue with next';
                $link_b = '
                <a href="' . $link . '">
                <img src="gfx/pfeil_r_1.gif">
                ' . $linktext . '
                </a>';

#               $linktext = 'continue with next';


        if ( $GLOBALS['userdata_type'] == 'wau' ) {
                if ( $GLOBALS['a']->checkAuth() ) {
                $link_a .= "<hr>" . build_save_staus_link( (string) $definedmeaning );
                }
        }

return $link_a . $link_b;
}

function build_save_staus_link( $definedmeaning ) {

                        $params = $GLOBALS['params'];
                        $params['dm_id'] =  (string) $definedmeaning;
                        $dm_status = get_ow_trainer_status( $params );

                $link = '<ul>';
        foreach ( $GLOBALS['params']['status_values'] as $value ) {
                $link .= build_save_staus_link_sub(
                                $definedmeaning, $dm_status, $value, current( $GLOBALS['params']['status_messages'] ) );
                next( $GLOBALS['params']['status_messages'] );
        }
                $link .= '</ul>';
return $link;
}

function build_save_staus_link_sub( $definedmeaning, $dm_status, $value, $message ) {
        $link = build_get_uri_2();
        $link = build_get_uri_2( 'save_ow_trainer_data', '1', $link );
        $link = build_get_uri_2( 'definedmeaning', (string) $definedmeaning, $link );
        $link = build_get_uri_2( 'dm_status', $value, $link );
        if ( $_REQUEST['trainer_step'] == '2' ) { // stay on same dm for switching
                $link = build_get_uri_2( 'trainer_step', '2', $link );
        }

        if ( $value != $dm_status ) {
                $string .= '<li class="ow_setting_active"><a href="' . $link . '">
                ' . $message . '</a>';
        } else {
                $string .= '<li class="ow_setting_off">' . $message . ' </li>';
        }

return $string;
}

function build_get_uri_2( $var_search = '', $replace_value = '', $uri = '' ) {
// ohne echo 
// kann keine Arrays verarbeiten (-> Aenderung von nur einer Variable)

	$var_search = urldecode( $var_search ); // sonst probleme mit []
	$replace_value = urlencode( $replace_value );

	// parameter ohne http:// erzeugen

	if ( strpos( $uri, '?' ) )
	{
		preg_match( "|(\?)(.*)|", $uri, $arr );
		// echo "<br />uri: $uri<--<br />";
		// print_r($arr);
		// echo "--->".$arr[2];
		$query_string = $arr[2];
	}
	else
	{
		$query_string = $GLOBALS[QUERY_STRING];
	}

	// eventuelles altes vorkommen der Parameter entfernen //:pending: was ist mit arrays als get paramater
	$var_search_escaped = str_replace( '[', '\[', $var_search );
	$var_search_escaped = str_replace( ']', '\]', $var_search_escaped );

	$pattern = 	"/
				(^|\&) # beginnt entweder mit & oder wenn von GLOBALS[QUERY_STRING] ab nach dem ?
				($var_search_escaped=[^&]*)
				/ix";
	$string = preg_replace( $pattern, "", $query_string );
   
	// variable setzen
	if ( $replace_value != '' ) // wenn entfernt werden soll, nicht = leer
	{
		$string = $var_search . "=" . $replace_value . "&" . $string ;
	}

	// echo  "<br />nach Variable setzen: $string";


	$get_uri_1 = $_SERVER["SCRIPT_URI"];

	if ( $uri == "" ) // nur die erzeugen Parameter hinhaengen
	{
		$stop = strpos( $GLOBALS["QUERY_STRING"], "?" );
		$get_uri_1 = $get_uri_1 . substr( $_SERVER["REQUEST_URI"], 0, $stop );
	}
	elseif ( ( strpos( $uri, 'http' ) ) !== false ) // es wurde eine ganz andere http.. der Funktion übergeben
	{
		// voderen Teil extrahieren (paramater kommen schon von obe, sonst doppelt)
		unset( $arr );
		$uri = preg_replace( "|(\?.*)|", "?", $uri );
		// echo "<br />uri: $uri<--<br />";
		$get_uri_1 = $uri;
	}
	else // es ist nur der hintere Teil anders (andere Datei)
	{
		$get_uri_1 = $get_uri_1 . "/" . $uri;
	}

	// http:  und parameter zusammensetzen        
	$get_uri_1 = $get_uri_1 . "?" . "$string";

	// ausputzen
	$get_uri_1 = str_replace( '&?', '&', $get_uri_1 );
	$get_uri_1 = str_replace( '??', '?', $get_uri_1 );
	$get_uri_1 = str_replace( '&&', '&', $get_uri_1 );

	// echo "<br />get_uri_1: ".$get_uri_1;

	return $get_uri_1;
}

function get_ow_content_1( $url, $params = '' )
{

	// echo $url;
	$curl = curl_init();
	curl_setopt ( $curl, CURLOPT_URL, $url );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );

	$string = curl_exec ( $curl );
	curl_close ( $curl );

	if ( is_numeric( strpos( $string, "http://upload.wikimedia.org/wikipedia/commons/a/af/Arrow_green.png" ) ) )
	{
	$string_ret = "<br />Kein Treffer. <br />vielleicht Anlegen in <a  href='" . $url . "'  target='_blank'>" . Wiktionary . "?</a>";
	}
	else
	{
	$string_ret = $string;
	}

	return $string_ret;
}

/** dump the contents of a domNode to screen
*/
function dumpNode( $domNode ) {
	$doc = new DOMDocument();
	$doc->formatOutput = true;
	$domNode = $doc->importNode( $domNode, 1 );
	$doc->appendChild( $domNode );
	print $doc->saveXML();

}


/** class defined in this file for now... might get own file later. Requires some of 
 * the functions defined in this file.
 * possibly some amount of refactoring might be good
 */
class OWFetcher {
	
	/**
	 * This echos build_api_query_url() but doesn't rely on $_REQUEST (among other things)
	 */
	public function getDefinedMeaningXML_asString( $dmid, $languages = null ) {
		global $ow_api_location;
		$ow_api_url = $ow_api_location;
		$ow_api_url = build_get_uri_2( 'wdtype', 'translation', $ow_api_url );
		$ow_api_url = build_get_uri_2( 'wddmid', "$dmid", $ow_api_url );
		if ( $languages && count( $languages ) > 0 ) {
			$wdlanguages_ser = implode( '|', $languages );
		} else {
			$wdlanguages_ser = get_wdlanguages( 'ser' );
		}
		$ow_api_url = build_get_uri_2( 'wdlanguages', $wdlanguages_ser, $ow_api_url );
		# var_dump($ow_api_url);
		return get_ow_content_1( $ow_api_url );
	}

	public function getFullSetXML_asString( $collection_id, $languages = null ) {
		global $ow_api_location;
		$ow_api_url = $ow_api_location;
		$ow_api_url = build_get_uri_2( 'wdtype', 'collection', $ow_api_url );
		$ow_api_url = build_get_uri_2( 'wdcollection_id', "$collection_id", $ow_api_url );
		if ( $languages && count( $languages ) > 0 ) {
			$wdlanguages_ser = implode( '|', $languages );
		} else {
			$wdlanguages_ser = get_wdlanguages( 'ser' );
		}
		$ow_api_url = build_get_uri_2( 'wdlanguages', $wdlanguages_ser, $ow_api_url );

		# var_dump($ow_api_url);
		return get_ow_content_1( $ow_api_url );
	}

	public function getCollectionListXML_asString() {
		global $ow_api_location;
		$ow_api_url = $ow_api_location;
		$ow_api_url = build_get_uri_2( 'wdtype', 'listCollections', $ow_api_url );
		return get_ow_content_1( $ow_api_url );
	}

}



?>
