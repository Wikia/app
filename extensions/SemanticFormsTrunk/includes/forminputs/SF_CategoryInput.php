<?php
/**
 * File holding the SFCategoryInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFCategoryInput class.
 *
 * @ingroup SFFormInput
 */
class SFCategoryInput extends SFFormInput {
	public static function getName() {
		return 'category';
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// escape if CategoryTree extension isn't included
		if ( !function_exists( 'efCategoryTreeParserHook' ) ) {
			return null;
		}

		global $sfgTabIndex, $sfgFieldNum;

		$className = ( $is_mandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		if ( array_key_exists( 'top category', $other_args ) ) {
			$top_category = $other_args['top category'];
		} else {
			// escape - we can't do anything
			return null;
		}
		$hideroot = array_key_exists( 'hideroot', $other_args );
		if ( array_key_exists( 'height', $other_args ) ) {
			$height = $other_args['height'];
		} else {
			$height = '100';
		}
		if ( array_key_exists( 'width', $other_args ) ) {
			$width = $other_args['width'];
		} else {
			$width = '500';
		}

		$text = '<div style="overflow: auto; padding: 5px; border: 1px #aaaaaa solid; max-height: ' . $height . 'px; width: ' . $width . 'px;">';

		// Start with an initial "None" value, unless this is a
		// mandatory field and there's a current value in place
		// (either through a default value or because we're editing
		// an existing page)
		if ( !$is_mandatory || $cur_value == '' ) {
			$text .= '	<input type="radio" tabindex="' . $sfgTabIndex . '" name="' . $input_name . '" value=""';
			if ( !$cur_value ) {
				$text .= ' checked="checked"';
			}
			$disabled_text = ( $is_disabled ) ? 'disabled' : '';
			$text .= " $disabled_text/> <em>" . wfMsg( 'sf_formedit_none' ) . "</em>\n";
		}

		global $wgCategoryTreeMaxDepth;
		$wgCategoryTreeMaxDepth = 10;
		$tree = efCategoryTreeParserHook( $top_category,
			array(
				'mode' => 'categories',
				'namespaces' => array( NS_CATEGORY ),
				'depth' => 10,
				'hideroot' => $hideroot,
			)
		);

		// Capitalize the first letter, if first letters always get
		// capitalized.
		global $wgCapitalLinks;
		if ( $wgCapitalLinks ) {
			global $wgContLang;
			$cur_value = $wgContLang->ucfirst( $cur_value );
		}

		$tree = preg_replace(
			'/(<a class="CategoryTreeLabel.*>)(.*)(<\/a>)/',
			'<input tabindex="' . $sfgTabIndex . '" name="' . $input_name .
				'" value="$2" type="radio"> $1$2$3',
			$tree
		);
		$tree = str_replace( "value=\"$cur_value\"", "value=\"$cur_value\" checked=\"checked\"", $tree );
		// if it's disabled, set all to disabled
		if ( $is_disabled ) {
			$tree = str_replace( 'type="radio"', 'type="radio" disabled', $tree );
		}

		// Get rid of all the 'no subcategories' messages.
		$tree = str_replace(
			'<div class="CategoryTreeChildren" style="display:block"><i class="CategoryTreeNotice">' .
				wfMsg( 'categorytree-no-subcategories' ) . '</i></div>',
			'',
			$tree
		);

		$text .= $tree . '</div>';

		$spanClass = 'radioButtonSpan';
		if ( $is_mandatory ) {
			$spanClass .= ' mandatoryFieldSpan';
		}
		$text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );

		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'top category',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_topcategory' )
		);
		$params[] = array(
			'name' => 'hideroot',
			'type' => 'boolean',
			'description' => wfMsg( 'sf_forminputs_hideroot' )
		);
		$params[] = array(
			'name' => 'height',
			'type' => 'int',
			'description' => wfMsg( 'sf_forminputs_height' )
		);
		$params[] = array(
			'name' => 'width',
			'type' => 'int',
			'description' => wfMsg( 'sf_forminputs_width' )
		);
		return $params;
	}

	/**
	 * Returns the HTML code to be included in the output page for this input.
	 */
	public function getHtmlText() {
		return self::getHTML(
			$this->mCurrentValue,
			$this->mInputName,
			$this->mIsMandatory,
			$this->mIsDisabled,
			$mOtherArgs
		);
	}
}
