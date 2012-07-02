<?php

/**
 * Form input for adding images from Wikipedia or Wikimedia Commons.
 * 
 * @since 0.1
 * 
 * @file InstantImageInput.php
 * @ingroup SFFormInput
 * @ingroup SII
 * 
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class InstantImageInput extends SFFormInput {
	
	public static function getName() {
		return 'instantimage';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getOtherPropTypesHandled() {
		return array( '_txt', '_wpg' );
	}

	public static function getDefaultPropTypeLists() {
		return array();
	}
	
	public static function getOtherPropTypeListsHandled() {
		return array();
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
			$this->mOtherArgs
		);
	}
	
	public static function getParameters() {
		$params = parent::getParameters();
		
		$params[] = array(
			'name' => 'type',
			'type' => 'str',
			'description' => wfMsg( 'sii-imageinput-type' )
		); // page
		
		$params[] = array(
			'name' => 'hide',
			'type' => 'bool',
			'description' => wfMsg( 'sii-imageinput-hide' )
		); // false
		
		$params[] = array(
			'name' => 'width',
			'type' => 'int',
			'description' => wfMsg( 'sii-imageinput-width' )
		); // 200
		
		$params[] = array(
			'name' => 'showdefault',
			'type' => 'bool',
			'description' => wfMsg( 'sii-imageinput-showdefault' )
		); // true
		
		return $params;
	}
	
	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $wgOut;
		$html = '';
		
		if ( !array_key_exists( 'page', $other_args ) ) {
			$other_args['type'] = 'page';
		}
		
		$showDefault = !array_key_exists( 'showdefault', $other_args ) || $other_args['showdefault'] === 'yes';
		
		if ( $showDefault && !array_key_exists( 'default', $other_args ) ) {
			$other_args['default'] = SIISettings::get( 'defaultImage' );
		}
		
		$defImg = $other_args['default'];
		
		$noImage = is_null( $cur_value ) || trim( $cur_value ) === '';
		$showInForm = !array_key_exists( 'hide', $other_args ) || trim( $other_args['hide'] ) === 'no';
		
		$width = array_key_exists( 'width', $other_args ) ? $other_args['width'] : SIISettings::get( 'defaultWidth' );
		
		if ( $showInForm && !$noImage ) {
			if ( $noImage ) {
				$html .= wfMsg( 'sii-imageinput-loading' );
			}
			else {
				global $wgParser;
				
				$html .= $wgParser->parse(
					'[[' . $cur_value . '|' . $width . ']]',
					Title::newFromText( self::getPage() ),
					( new ParserOptions() )
				)->getText();
			}
		}
		
		if ( $noImage || $cur_value === $defImg ) {
			$wgOut->addModules( 'sii.image' );
			$cur_value = $defImg;
			
			$args = array(
				'class' => 'instantImage',
				'data-image-type' => $other_args['type'],
				'data-input-name' => $input_name,
				'data-image-width' => $width,
			);
			
			if ( $other_args['type'] == 'page' ) {
				$args['data-image-name'] = self::getPage();
			}
			
			$html = Html::rawElement(
				'div',
				$args,
				$html
			);
		}
		
		return $html . Html::input( $input_name, $cur_value, 'hidden' );
	}
	
	protected static function getPage() {
		$parts = explode( '/', $GLOBALS['wgTitle']->getFullText() );
		
		// TODO: this will not work for non-en.
		if ( $parts[0] == 'Special:FormEdit' ) {
			array_shift( $parts );
			array_shift( $parts );
		}
		
		return implode( '/', $parts );
	}
	
}
