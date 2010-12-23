<?php

class DPLListMode {
	var $name;
	var $sListStart = '';
	var $sListEnd = '';
	var $sHeadingStart = '';
	var $sHeadingEnd = '';
	var $sItemStart = '';
	var $sItemEnd = '';
	var $sInline = '';
	var $sSectionTags = array();
	var $aMultiSecSeparators = array();
	var $iDominantSection = - 1;

	function __construct( $listmode, $secseparators, $multisecseparators,
		$inlinetext, $listattr = '', $itemattr = '', $listseparators, $iOffset,
		$dominantSection
	) {
		// default for inlinetext (if not in mode=userformat)
		if ( ( $listmode != 'userformat' ) && ( $inlinetext == '' ) ) {
			$inlinetext = '&#160;-&#160;';
		}
		$this->name = $listmode;
		$_listattr = ( $listattr == '' ) ? '' : ' ' . Sanitizer::fixTagAttributes( $listattr, 'ul' );
		$_itemattr = ( $itemattr == '' ) ? '' : ' ' . Sanitizer::fixTagAttributes( $itemattr, 'li' );

		$this->sSectionTags = $secseparators;
		$this->aMultiSecSeparators = $multisecseparators;
		$this->iDominantSection = $dominantSection - 1;  // 0 based index

		switch ( $listmode ) {
			case 'inline':
				if ( stristr( $inlinetext, '<BR />' ) ) { // one item per line (pseudo-inline)
					$this->sListStart = '<DIV' . $_listattr . '>';
					$this->sListEnd = '</DIV>';
				}
				$this->sItemStart = '<SPAN' . $_itemattr . '>';
				$this->sItemEnd = '</SPAN>';
				$this->sInline = $inlinetext;
				break;
			case 'ordered':
				if ( $iOffset == 0 ) {
					$this->sListStart = '<OL start=1 ' . $_listattr . '>';
				} else {
					$this->sListStart = '<OL start=' . ( $iOffset + 1 ) . ' ' . $_listattr . '>';
				}
				$this->sListEnd = '</OL>';
				$this->sItemStart = '<LI' . $_itemattr . '>';
				$this->sItemEnd = '</LI>';
				break;
			case 'unordered':
				$this->sListStart = '<UL' . $_listattr . '>';
				$this->sListEnd = '</UL>';
				$this->sItemStart = '<LI' . $_itemattr . '>';
				$this->sItemEnd = '</LI>';
				break;
			case 'definition':
				$this->sListStart = '<DL' . $_listattr . '>';
				$this->sListEnd = '</DL>';
				// item html attributes on dt element or dd element ?
				$this->sHeadingStart = '<DT>';
				$this->sHeadingEnd = '</DT><DD>';
				$this->sItemEnd = '</DD>';
				break;
			case 'H2':
			case 'H3':
			case 'H4':
				$this->sListStart = '<DIV' . $_listattr . '>';
				$this->sListEnd = '</DIV>';
				$this->sHeadingStart = '<' . $listmode . '>';
				$this->sHeadingEnd = '</' . $listmode . '>';
				break;
			case 'userformat':
				switch( count( $listseparators ) ) {
					case 4:
						$this->sListEnd = $listseparators[3];
					case 3:
						$this->sItemEnd = $listseparators[2];
					case 2:
						$this->sItemStart = $listseparators[1];
					case 1:
						$this->sListStart = $listseparators[0];
				}
				$this->sInline = $inlinetext;
				break;
		}
	}
}
