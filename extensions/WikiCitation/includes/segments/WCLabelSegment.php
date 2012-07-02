<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCLabelFormEnum extends WCEnum {
	const none       = 0;
	const long       = 1;
	const verb       = 2;
	const short      = 3;
	const verbShort  = 4;
	const symbol     = 5;
	const __default  = self::none;
}


class WCPluralEnum extends WCEnum {
	const singular  = 0;
	const plural    = 1;
	const __default = self::singular;
}


class WCLabelPluralEnum extends WCEnum {
	const contextual = 0;
	const always     = 1;
	const never      = 2;
	const __default  = self::contextual;
}


class WCRelativePositionEnum extends WCEnum {
	const before       = 0;
	const after        = 1;
	const __default  = self::before;
}


class WCLabelSegment extends WCWrapperSegment {

	protected $segment;
	protected $positionEnum, $labelForm, $labelTextCase, $plural;

	public function __construct(
			WCDataSegment $segment,
			WCRelativePositionEnum $positionEnum,
			WCLabelFormEnum $labelForm,
			WCTextCaseEnum $labelTextCase,
			WCLabelPluralEnum $labelPlural,
			$prefix = '',
			$suffix = '' ) {
		$this->segment = $segment;
		$this->positionEnum = $positionEnum;
		$this->labelForm = $labelForm;
		$this->labelTextCase = $labelTextCase;
		if ( $segment->exists() ) {
			$this->exists = True;
		} else {
			$this->exists = False;
			return;
		}
		switch ( $labelPlural->key ) {
			case WCLabelPluralEnum::contextual:
				if ( count( $segment ) > 1 ) {
					$this->plural = new WCPluralEnum( WCPluralEnum::plural );
				} else {
					$this->plural = new WCPluralEnum( WCPluralEnum::singular );
				}
				break;
			case WCLabelPluralEnum::always:
				$this->plural = new WCPluralEnum( WCPluralEnum::plural );
				break;
			case WCLabelPluralEnum::never:
				$this->plural = new WCPluralEnum( WCPluralEnum::singular );
		}

	}


	public function render( WCStyle $style, $endSeparator = '' ) {
		$label = $this->segment->getLabel( $style, $this->labelForm, $this->plural );
		$label = $style->capitalize( $label, $this->labelTextCase );

		if ( $label ) {
			if ( $this->positionEnum->key == WCRelativePositionEnum::before ) {
				$this->prefix = $label . ' ' . $this->prefix;
			} else { # WCRelativePositionEnum::after
				$this->suffix .= ', ' . $label;
			}
			return $this->prefix . $this->segment->render( $style, $this->extendSuffix( $endSeparator ) );
		}
	}


}
