<?php
/**
 * A special page holding a form that allows the user to create a filter
 * page
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SDCreateFilter extends SpecialPage {

	/**
	 * Constructor
	 */
	public function SDCreateFilter() {
		parent::__construct( 'CreateFilter' );
		// Backwards compatibility for MediaWiki < 1.16
		if ( version_compare( $GLOBALS['wgVersion'], '1.16', '<' ) ) {
			wfLoadExtensionMessages( 'SemanticDrilldown' );
		}
	}

	function execute( $par ) {
		$this->setHeaders();
		doSpecialCreateFilter();
	}
}

function createFilterText( $property_name, $values_source, $category_used, $time_period, $filter_values, $input_type, $required_filter, $filter_label ) {
	global $sdgContLang;

	$sd_props = $sdgContLang->getPropertyLabels();
	$property_tag = "[[" . $sd_props[SD_SP_COVERS_PROPERTY] . "::$property_name]]";
	$text = wfMsgForContent( 'sd_filter_coversproperty', $property_tag );
	if ( $values_source == 'category' ) {
		$category_tag = "[[" . $sd_props[SD_SP_GETS_VALUES_FROM_CATEGORY] . "::$category_used]]";
		$text .= " " . wfMsgForContent( 'sd_filter_getsvaluesfromcategory', $category_tag );
	} elseif ( $values_source == 'property' ) {
		// do nothing
	} elseif ( $values_source == 'dates' ) {
		$time_period_tag = "[[" . $sd_props[SD_SP_USES_TIME_PERIOD] . "::$time_period]]";
		$text .= " " . wfMsgForContent( 'sd_filter_usestimeperiod', $time_period_tag );
	} elseif ( $values_source == 'manual' ) {
		// replace the comma substitution character that has no
		// chance of being included in the values list - namely,
		// the ASCII beep
		global $sdgListSeparator;
		$filter_values = str_replace( "\\$sdgListSeparator", "\a", $filter_values );
		$filter_values_array = explode( $sdgListSeparator, $filter_values );
		$filter_values_tag = "";
		foreach ( $filter_values_array as $i => $filter_value ) {
			if ( $i > 0 ) {
				$filter_values_tag .= ", ";
			}
			// replace beep with comma, trim
			$filter_value = str_replace( "\a", $sdgListSeparator, trim( $filter_value ) );
			$filter_values_tag .= "[[" . $sd_props[SD_SP_HAS_VALUE] . "::$filter_value]]";
		}
		$text .= " " . wfMsgForContent( 'sd_filter_hasvalues', $filter_values_tag );
	}
	if ( $input_type != '' ) {
		$input_type_tag = "[[" . $sd_props[SD_SP_HAS_INPUT_TYPE] . "::$input_type]]";
		$text .= " " . wfMsgForContent( 'sd_filter_hasinputtype', "\"$input_type_tag\"" );
	}
	if ( $required_filter != '' ) {
		$sd_namespace_labels = $sdgContLang->getNamespaces();
		$filter_namespace = $sd_namespace_labels[SD_NS_FILTER];
		$filter_tag = "[[" . $sd_props[SD_SP_REQUIRES_FILTER] . "::$filter_namespace:$required_filter|$required_filter]]";
		$text .= " " . wfMsgForContent( 'sd_filter_requiresfilter', $filter_tag );
	}
	if ( $filter_label != '' ) {
		$filter_label_tag = "[[" . $sd_props[SD_SP_HAS_LABEL] . "::$filter_label]]";
		$text .= " " . wfMsgForContent( 'sd_filter_haslabel', $filter_label_tag );
	}
	return $text;
}

function doSpecialCreateFilter() {
	global $wgOut, $wgRequest, $wgUser, $sdgScriptPath;

	# cycle through the query values, setting the appropriate local variables
	$filter_name = $wgRequest->getVal( 'filter_name' );
	$values_source = $wgRequest->getVal( 'values_source' );
	$property_name = $wgRequest->getVal( 'property_name' );
	$category_name = $wgRequest->getVal( 'category_name' );
	$time_period = $wgRequest->getVal( 'time_period' );
	$filter_values = $wgRequest->getVal( 'filter_values' );
	$input_type = $wgRequest->getVal( 'input_type' );
	$required_filter = $wgRequest->getVal( 'required_filter' );
	$filter_label = $wgRequest->getVal( 'filter_label' );

	$save_button_text = wfMsg( 'savearticle' );
	$preview_button_text = wfMsg( 'preview' );
	$filter_name_error_str = '';
	$save_page = $wgRequest->getCheck( 'wpSave' );
	$preview_page = $wgRequest->getCheck( 'wpPreview' );
	if ( $save_page || $preview_page ) {
		# validate filter name
		if ( $filter_name == '' ) {
			$filter_name_error_str = wfMsg( 'sd_blank_error' );
		} else {
			# redirect to wiki interface
			$namespace = SD_NS_FILTER;
			$title = Title::newFromText( $filter_name, $namespace );
			$full_text = createFilterText( $property_name, $values_source, $category_name, $time_period, $filter_values, $input_type, $required_filter, $filter_label );
			// HTML-encode
			$full_text = str_replace( '"', '&quot;', $full_text );
			$text = SDUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false );
			$wgOut->addHTML( $text );
			return;
		}
	}

	// set 'title' as hidden field, in case there's no URL niceness
	global $wgContLang;
	$mw_namespace_labels = $wgContLang->getNamespaces();
	$special_namespace = $mw_namespace_labels[NS_SPECIAL];
	$name_label = wfMsg( 'sd_createfilter_name' );
	$property_label = wfMsg( 'sd_createfilter_property' );
	$label_label = wfMsg( 'sd_createfilter_label' );
	$text = <<<END
	<form action="" method="post">
	<input type="hidden" name="title" value="$special_namespace:CreateFilter">
	<p>$name_label <input size="25" name="filter_name" value="">
	<span style="color: red;">$filter_name_error_str</span></p>
	<p>$property_label
	<select id="property_dropdown" name="property_name">

END;
	$all_properties = SDUtils::getSemanticProperties();
	foreach ( $all_properties as $property_name ) {
		$text .= "	<option>$property_name</option>\n";
	}

	$values_from_property_label = wfMsg( 'sd_createfilter_usepropertyvalues' );
	$values_from_category_label = wfMsg( 'sd_createfilter_usecategoryvalues' );
	$date_values_label = wfMsg( 'sd_createfilter_usedatevalues' );
	$enter_values_label = wfMsg( 'sd_createfilter_entervalues' );
	// need both label and value, in case user's language is different
	// from wiki's
	$year_label = wfMsg( 'sd_filter_year' );
	$year_value = wfMsgForContent( 'sd_filter_year' );
	$month_label = wfMsg( 'sd_filter_month' );
	$month_value = wfMsgForContent( 'sd_filter_month' );
	$input_type_label = wfMsg( 'sd_createfilter_inputtype' );
	$values_list_label = wfMsg( 'sd_createfilter_listofvalues' );
	// same as for time values
	$combo_box_label = wfMsg( 'sd_filter_combobox' );
	$combo_box_value = wfMsgForContent( 'sd_filter_combobox' );
	$date_range_label = wfMsg( 'sd_filter_daterange' );
	$date_range_value = wfMsgForContent( 'sd_filter_daterange' );
	$require_filter_label = wfMsg( 'sd_createfilter_requirefilter' );
	$text .= <<<END
	</select>
	</p>
	<p><input type="radio" name="values_source" checked value="property">
	$values_from_property_label
	</p>
	<p><input type="radio" name="values_source" value="category">
	$values_from_category_label
	<select id="category_dropdown" name="category_name">

END;
	$categories = SDUtils::getCategoriesForBrowsing();
	foreach ( $categories as $category ) {
		$category = str_replace( '_', ' ', $category );
		$text .= "	<option>$category</option>\n";
	}
	$text .= <<<END
	</select>
	</p>
	<p><input type="radio" name="values_source" value="dates">
	$date_values_label
	<select id="time_period_dropdown" name="time_period">
	<option value="$year_value">$year_label</option>
	<option value="$month_value">$month_label</option>
	</select>
	</p>
	<p><input type="radio" name="values_source" value="manual">
	$enter_values_label <input size="40" name="filter_values" value="">
	</p>
	<p>$input_type_label
	<select id="input_type_dropdown" name="input_type">
	<option value="">$values_list_label</option>
	<option value="$combo_box_value">$combo_box_label</option>
	<option value="$date_range_value">$date_range_label</option>
	</select>
	</p>
	<p>$require_filter_label
	<select id="required_filter_dropdown" name="required_filter">
	<option />

END;
	$filters = SDUtils::getFilters();
	foreach ( $filters as $filter ) {
		$filter = str_replace( '_', ' ', $filter );
		$text .= "	<option>$filter</option>\n";
	}
	$text .= <<<END
	</select>
	</p>
	<p>$label_label <input size="25" name="filter_label" value=""></p>
	<div class="editButtons">
	<input type="submit" id="wpSave" name="wpSave" value="$save_button_text"></p>
	<input type="submit" id="wpPreview" name="wpPreview" value="$preview_button_text"></p>
	</div>

END;

	$text .= "	</form>\n";

	$wgOut->addExtensionStyle( "$sdgScriptPath/skins/SD_main.css" );
	$wgOut->addHTML( $text );
}
