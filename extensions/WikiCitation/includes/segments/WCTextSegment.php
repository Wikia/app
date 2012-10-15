<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCTextSegment extends WCDataSegment {

	protected $textObject;

	protected $scope;

	protected $propertyType;

	protected $blank;

	public function __construct(
			WCCitation $citation,
			WCSegmentImportance $importance,
			WCScopeEnum $scope,
			WCPropertyEnum $propertyType,
			$prefix = '',
			$suffix = '' ) {
		parent::__construct( $citation, $prefix, $suffix );
		switch( $importance->key ) {
			case WCSegmentImportance::mandatory:
				$this->textObject = $citation->reference->inferProperty( $scope, $propertyType );
				$this->exists = True;
				return;
			case WCSegmentImportance::important:
				$this->textObject = $citation->reference->inferProperty( $scope, $propertyType );
				$this->exists = (bool) $this->textObject;
				break;
			case WCSegmentImportance::optional:
				$textObject = $citation->reference->getProperty( $scope, $propertyType );
				if ( isset( $textObject ) ) {
					$this->textObject = $textObject;
					$this->exists = True;
				} else {
					$this->exists = False;
				}
		}
		# $scope and $propertyType may have changed as a side-effect of $citation->inferProperty.
		$this->scope = $scope;
		$this->propertyType = $propertyType;
	}


	public function getLabel( WCStyle $style, WCLabelFormEnum $form, WCPluralEnum $plural ) {
		return $style->propertyLabels[ $this->propertyType->key ][ $form->key ][ $plural->key ];
	}


	public function render( WCStyle $style, $endSeparator = '' ) {
		$endSeparator = $this->extendSuffix( $endSeparator );
		if ( $this->textObject ) {
			$text = $this->textObject->getText();
			if ( $endSeparator ) {
				$chrL = mb_substr( $text, -1, 1 );
				$chrR = mb_substr( $endSeparator, 0, 1 );
				if ( $chrL == $chrR ) {
					$endSeparator = ltrim( $endSeparator, $chrR );
				}
				return $this->prefix . $text . $endSeparator;
			} else {
				return $this->prefix . $text;
			}
		} else {
			return $this->prefix . $style->segmentMissing . $endSeparator;
		}
	}


	public function getSortingParts() {
		return array( $this->textObject->getText() );
	}


}
