<?php

/**
 * File holding the SFTextAreaInput class
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFTextAreaInput class.
 *
 * @ingroup SFFormInput
 */
class SFTextAreaInput extends SFFormInput {

	protected $mUseWikieditor = false;

        public static function getDefaultCargoTypes() {
                return array( 'Text' => array() );
        }

        public static function getDefaultCargoTypeLists() {
                return array(
                        'Text' => array( 'field_type' => 'text', 'is_list' => 'true' )
                );
        }
	
	/**
	 * Constructor for the SFTextAreaInput class.
	 *
	 * @param String $input_number
	 *	The number of the input in the form. For a simple HTML input element
	 *	this should end up in the id attribute in the format 'input_<number>'.
	 * @param String $cur_value
	 *	The current value of the input field. For a simple HTML input
	 *	element this should end up in the value attribute.
	 * @param String $input_name
	 *	The name of the input. For a simple HTML input element this should
	 *	end up in the name attribute.
	 * @param Array $other_args
	 *	An associative array of other parameters that were present in the
	 *	input definition.
	 */
	public function __construct( $input_number, $cur_value, $input_name, $disabled, $other_args ) {
		
		global $wgOut;
		
		parent::__construct( $input_number, $cur_value, $input_name, $disabled, $other_args );
		
		if (
			array_key_exists( 'editor', $this->mOtherArgs ) &&
			$this->mOtherArgs['editor'] == 'wikieditor' &&
			
			method_exists( $wgOut, 'getResourceLoader' ) &&
			in_array( 'jquery.wikiEditor', $wgOut->getResourceLoader()->getModuleNames() ) &&
			
			class_exists( 'WikiEditorHooks' )
		) {
			$this->mUseWikieditor = true;
			$this->addJsInitFunctionData( 'window.ext.wikieditor.init' );
		}
	}

	
	public static function getName() {
		return 'textarea';
	}

	public static function getDefaultPropTypes() {
		$defaultPropTypes = array( '_cod' => array() );
		if ( defined( 'SMWDataItem::TYPE_STRING' ) ) {
			// SMW < 1.9
			$defaultPropTypes['_txt'] = array();
		}
		return $defaultPropTypes;
	}

	public static function getOtherPropTypesHandled() {
		$otherPropTypesHandled = array( '_wpg' );
		if ( defined( 'SMWDataItem::TYPE_STRING' ) ) {
			// SMW < 1.9
			$otherPropTypesHandled[] = '_str';
		} else {
			$otherPropTypesHandled[] = '_txt';
		}
		return $otherPropTypesHandled;
	}

	public static function getOtherPropTypeListsHandled() {
		$otherPropTypeListsHandled = array( '_wpg' );
		if ( defined( 'SMWDataItem::TYPE_STRING' ) ) {
			// SMW < 1.9
			$otherPropTypeListsHandled[] = '_str';
		} else {
			$otherPropTypeListsHandled[] = '_txt';
		}
		return $otherPropTypeListsHandled;
	}

	public static function getParameters() {
		$params = parent::getParameters();

		$params['preload'] = array(
			'name' => 'preload',
			'type' => 'string',
			'description' => wfMessage( 'sf_forminputs_preload' )->text()
		);
		$params['rows'] = array(
			'name' => 'rows',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_rows' )->text()
		);
		$params['cols'] = array(
			'name' => 'cols',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_cols' )->text()
		);
		$params['maxlength'] = array(
			'name' => 'maxlength',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_maxlength' )->text()
		);
		$params['placeholder'] = array(
			'name' => 'placeholder',
			'type' => 'string',
			'description' => wfMessage( 'sf_forminputs_placeholder' )->text()
		);
		$params['autogrow'] = array(
			'name' => 'autogrow',
			'type' => 'boolean',
			'description' => wfMessage( 'sf_forminputs_autogrow' )->text()
		);
		return $params;
	}

	/**
	 * Returns the names of the resource modules this input type uses.
	 * 
	 * Returns the names of the modules as an array or - if there is only one 
	 * module - as a string.
	 * 
	 * @return null|string|array
	 */
	public function getResourceModuleNames() {
		return $this->mUseWikieditor?'ext.semanticforms.wikieditor':null;
	}

	protected function getTextAreaAttributes() {

		global $sfgTabIndex, $sfgFieldNum;

		// Use a special ID for the free text field -
		// this was originally done for FCKeditor, but maybe it's
		// useful for other stuff too.
		$input_id = $this->mInputName == 'sf_free_text' ? 'sf_free_text' : "input_$sfgFieldNum";

		if ( $this->mUseWikieditor ) {
			// Load modules for all enabled WikiEditor features.
			// The header for this function was changed in July
			// 2014, and the function itself was changed
			// significantly in March 2015 - this call should
			// hopefully work for all versions.
			global $wgTitle, $wgOut;
			$article = new Article( $wgTitle );
			$editPage = new EditPage( $article );
			WikiEditorHooks::editPageShowEditFormInitial( $editPage, $wgOut );
			$className = 'wikieditor ';
		} else {
			$className = '';
		}

		$className .= ( $this->mIsMandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'unique', $this->mOtherArgs ) ) {
			$className .= ' uniqueField';
		}

		if ( array_key_exists( 'class', $this->mOtherArgs ) ) {
			$className .= ' ' . $this->mOtherArgs['class'];
		}

		if ( array_key_exists( 'autogrow', $this->mOtherArgs ) ) {
			$className .= ' autoGrow';
		}

		if ( array_key_exists( 'rows', $this->mOtherArgs ) ) {
			$rows = $this->mOtherArgs['rows'];
		} else {
			$rows = 5;
		}

		$textarea_attrs = array(
			'tabindex' => $sfgTabIndex,
			'name' => $this->mInputName,
			'id' => $input_id,
			'class' => $className,
			'rows' => $rows,
		);

		if ( array_key_exists( 'cols', $this->mOtherArgs ) ) {
			$textarea_attrs['cols'] = $this->mOtherArgs['cols'];
			// Needed to prevent CSS from overriding the manually-
			// set width.
			$textarea_attrs['style'] = 'width: auto';
		} elseif ( array_key_exists( 'autogrow', $this->mOtherArgs ) ) {
			// If 'autogrow' has been set, automatically set
			// the number of columns - otherwise, the Javascript
			// won't be able to know how many characters there
			// are per line, and thus won't work.
			$textarea_attrs['cols'] = 90;
			$textarea_attrs['style'] = 'width: auto';
		} else {
			$textarea_attrs['cols'] = 90;
			$textarea_attrs['style'] = 'width: 100%';
		}

		if ( $this->mIsDisabled ) {
			$textarea_attrs['disabled'] = 'disabled';
		}

		if ( array_key_exists( 'maxlength', $this->mOtherArgs ) ) {
			$maxlength = $this->mOtherArgs['maxlength'];
			// For every actual character pressed (i.e., excluding
			// things like the Shift key), reduce the string to its
			// allowed length if it's exceeded that.
			// This JS code is complicated so that it'll work
			// correctly in IE - IE moves the cursor to the end
			// whenever this.value is reset, so we'll make sure to
			// do that only when we need to.
			$maxLengthJSCheck = "if (window.event && window.event.keyCode < 48 && window.event.keyCode != 13) return; if (this.value.length > $maxlength) { this.value = this.value.substring(0, $maxlength); }";
			$textarea_attrs['onKeyDown'] = $maxLengthJSCheck;
			$textarea_attrs['onKeyUp'] = $maxLengthJSCheck;
		}

		if ( array_key_exists( 'placeholder', $this->mOtherArgs ) ) {
			$textarea_attrs['placeholder'] = $this->mOtherArgs['placeholder'];
		}

		return $textarea_attrs;
	}

	/**
	 * Returns the HTML code to be included in the output page for this input.
	 */
	public function getHtmlText() {

		$textarea_attrs = $this->getTextAreaAttributes();

		$text = Html::element( 'textarea', $textarea_attrs, $this->mCurrentValue );
		$spanClass = 'inputSpan';
		if ( $this->mInputName == 'sf_free_text' ) {
			$spanClass .= ' freeText';
		}
		if ( array_key_exists( 'isSection', $this->mOtherArgs ) ) {
			$spanClass .= ' pageSection';
		}
		if ( $this->mIsMandatory ) {
			$spanClass .= ' mandatoryFieldSpan';
		}
		if ( array_key_exists( 'unique', $this->mOtherArgs ) ) {
			$spanClass .= ' uniqueFieldSpan';
		}
		$text = Html::rawElement( 'span', array( 'class' => $spanClass ), $text );

		return $text;
}

}
