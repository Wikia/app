<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCLocatorSegment extends WCDataSegment {

	/**
	 * The WCLocator object
	 * @var WCLocator
	 */
	protected $locatorObject;

	protected $locatorType;

	public function __construct(
			WCCitation $citation,
			WCSegmentImportance $importance,
			WCPropertyEnum $locatorType,
			$prefix = '',
			$suffix = '' ) {
		parent::__construct( $citation, $prefix, $suffix );
		switch( $importance->key ) {
			case WCSegmentImportance::mandatory:
				$this->locatorObject = $citation->inferLocator( $locatorType );
				$this->exists = True;
				return;
			case WCSegmentImportance::important:
				$this->locatorObject = $citation->inferLocator( $locatorType );
				$this->exists = (bool) $this->locatorObject;
				break;
			case WCSegmentImportance::optional:
				$locatorObject = $citation->getLocator( $locatorType );
				if ( isset( $locatorObject ) ) {
					$this->locatorObject = $locatorObject;
					$this->exists = True;
				} else {
					$this->exists = False;
				}
		}
		# $locatorType may have changed as a side-effect of $citation->inferLocator.
		$this->locatorType = $locatorType;
	}

	public function getLabel( WCStyle $style, WCLabelFormEnum $form, WCPluralEnum $plural ) {
		return $style->propertyLabels[ $this->locatorType->key ][ $form->key ][ $plural->key ];
	}


	public function render( WCStyle $style, $endSeparator = '' ) {
		if ( $this->locatorObject ) {
			return $this->prefix . $this->locatorObject->render( $this->extendSuffix( $endSeparator ) );
		} else {
			return $this->prefix . $style->segmentMissing . $this->extendSuffix( $endSeparator );
		}
	}


	public function count() {
		$count = count( $this->locatorObject->ranges );
		if ( $count == 1 ) {
			$count = count( reset( $this->locatorObject->ranges ) );
		}
		return $count;
	}


	public function getSortingParts() {
		# Locators are not considered for sorting.
		return array();
	}


}
