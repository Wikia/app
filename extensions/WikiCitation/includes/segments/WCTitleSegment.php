<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCTitleSegment extends WCDataSegment {

	protected $titleObject;

	protected $titleFormat;

	protected $scope;

	protected $propertyType;

	public function __construct(
			WCCitation $citation,
			WCSegmentImportance $importance,
			WCScopeEnum $scope,
			WCPropertyEnum $propertyType,
			WCTitleFormat $titleFormat,
			$prefix = '',
			$suffix = ''
			) {
		parent::__construct( $citation, $prefix, $suffix );
		$this->titleFormat = $titleFormat;
		switch( $importance->key ) {
			case WCSegmentImportance::mandatory:
				$this->titleObject = $citation->reference->inferProperty( $scope, $propertyType );
				$this->exists = True;
				return;
			case WCSegmentImportance::important:
				$this->titleObject = $citation->reference->inferProperty( $scope, $propertyType );
				$this->exists = (bool) $this->titleObject;
				break;
			case WCSegmentImportance::optional:
				$titleObject = &$citation->properties[ $scope->key ][ $propertyType->key ];
				if ( isset( $titleObject ) ) {
					$this->titleObject = $titleObject;
					$this->exists = True;
				} else {
					$this->exists = False;
				}
		}
		# $scope and $propertyType may have changed by now.
		$this->scope = $scope;
		$this->propertyType = $propertyType;
	}


	public function getLabel( WCStyle $style, WCLabelFormEnum $form, WCPluralEnum $plural ) {
		return $style->propertyLabels[ $this->propertyType->key ][ $form->key ][ $plural->key ];
	}


	/**
	 * Format title with quotes and other optional styling.
	 *
	 * This will wrap the title in an HTML <cite> element. The title will also
	 * be quoted if the reference style is designated as a quoted-style
	 * title in WCTypeEnum::$titleFormat.
	 * @param WCStyle $style
	 * @param string $endSeparator
	 * @return string
	 */
	public function render( WCStyle $style, $endSeparator = '' ) {
		$endSeparator = $this->extendSuffix( $endSeparator );
		if ( $this->titleObject ) {
			$title = $this->titleObject->getTitle();

			# "quoted"-type title
			if ( $this->titleFormat->key == WCTitleFormat::quoted ) {

				if ( $style->punctuationInQuotes ) { # Punctuation is inside quotes:

					# Check for final quotes at the end of the title:
					$p = preg_split( '/(<\/q>+)$/uS', $title, 2, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
					if ( count( $p ) >= 2 ) {
						$title = $p[0] . mb_substr( $endSeparator, 0, 1 ) . $p[1];
						$title = $style->convertSemanticToCharacterQuotes( $title, True );
						$title = $style->transformTitle( $title );
						$title = '<cite class="' . WCStyle::quotedTitleHTML . '">' . $title . '</cite>';
						$title = $style->quote( $title );
					} else {
						$title = $style->convertSemanticToCharacterQuotes( $title, True );
						$title = $style->transformTitle( $title );
						$chrL = mb_substr( $title, -1, 1 );
						$chrR = mb_substr( $endSeparator, 0, 1 );
						if ( $chrR && ( $chrL === $chrR ) ) {
							# Wrap <cite> tag inside the quotes.
							$title = '<cite class="' . WCStyle::quotedTitleHTML . '">' . $title . '</cite>';
							$title = $style->quote( $title );
						} else {
							$title = $style->quote( $title . mb_substr( $endSeparator, 0, 1 ) );
							# Wrap <cite> tag outside the quotes.
							$title = '<cite class="' . WCStyle::quotedTitleHTML . '">' . $title . '</cite>';
						}
					}
					return $this->prefix . $title . mb_substr( $endSeparator, 1 );
				} else {
					# Punctuation follows quotes.
					$title = $style->convertSemanticToCharacterQuotes( $title, True );
					$title = $style->transformTitle( $title );
					$title = '<cite class="' . WCStyle::quotedTitleHTML . '">' . $title . '</cite>';
					return $this->prefix . $style->quote( $title ) . $endSeparator;
				}
			}

			# "italic"-type title
			$title = $style->convertSemanticToCharacterQuotes( $title );
			$title = $style->transformTitle( $title );
			$chrL = mb_substr( $title, -1, 1 );
			$chrR = mb_substr( $endSeparator, 0, 1 );
			if ( $chrR && $chrL == $chrR ) {
				$endSeparator = ltrim( $endSeparator, $chrR );
			}
			if ( $this->titleFormat->key == WCTitleFormat::italic ) {
				# "Italic"-type title
				return $this->prefix . '<cite class="' . WCStyle::italicTitleHTML . '">' . $title . '</cite>' . $endSeparator;
			} else {
				# WCTitleFormat::normal:
				return $this->prefix . '<cite>' . $title . '</cite>' . $endSeparator;
			}
		} else {
			return $this->prefix . $style->segmentMissing . $endSeparator;
		}
	}


	public function getSortingParts() {
		return array( strip_tags( $this->titleObject->getTitle() ) );
	}


}
