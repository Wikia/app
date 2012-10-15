<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCNamesSegment extends WCDataSegment {

	protected $namesObject;

	protected $scope;

	protected $nameType;

	protected $citationPosition;

	protected $citationLength;

	protected $nameSort;

	public function __construct(
			WCCitation $citation,
			WCSegmentImportance $importance,
			WCScopeEnum $scope,
			WCNameTypeEnum $nameType,
			WCCitationPosition $citationPosition,
			WCCitationLengthEnum $citationLength,
			$nameSort = False,
			$prefix = '',
			$suffix = '' ) {
		parent::__construct( $citation, $prefix, $suffix );
		$this->citationPosition = $citationPosition;
		$this->citationLength = $citationLength;
		$this->nameSort = $nameSort;

		switch( $importance->key ) {
			case WCSegmentImportance::mandatory:
				$this->namesObject = $citation->reference->inferNames( $scope, $nameType );
				$this->exists = True;
				break;
			case WCSegmentImportance::important:
				$this->namesObject = $citation->reference->inferNames( $scope, $nameType );
				$this->exists = (bool) $this->namesObject;
				break;
			case WCSegmentImportance::optional:
				$namesObject = $citation->reference->getNames( $scope, $nameType );
				if ( isset( $namesObject ) ) {
					$this->namesObject = $namesObject;
					$this->exists = True;
				} else {
					$this->exists = False;
				}
		}
		# $scope and $nameType may have changed as a side-effect of $citation->inferNames.
		$this->scope = $scope;
		$this->nameType = $nameType;
	}


	public function getLabel( WCStyle $style, WCLabelFormEnum $form, WCPluralEnum $plural ) {
		return $style->nameLabels[ $this->nameType->key ][ $form->key ][ $plural->key ];
	}


	public function count() {
		return count( $this->namesObject );
	}


	public function render( WCStyle $style, $endSeparator = '' ) {
		if ( $this->namesObject ) {
			return $this->prefix . $this->namesObject->render( $style, $this->citationPosition, $this->citationLength, $this->extendSuffix( $endSeparator ), $this->nameSort );
		} else {
			return $this->prefix . $style->segmentMissing . $this->extendSuffix( $endSeparator );
		}
	}


	public function getSortingParts() {
		$arr = array();
		foreach( $this->namesObject as $name ) {
			$arr += $name->getSortingParts();
		}
		return $arr;
	}


}
