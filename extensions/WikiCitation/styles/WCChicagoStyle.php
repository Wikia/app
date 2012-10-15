<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCChicagoStyle extends WCStyle {

	public static $titleFormatArray = array (
		WCSourceTypeEnum::general                        => WCTitleFormat::italic,
		WCSourceTypeEnum::book                           => WCTitleFormat::italic,
			WCSourceTypeEnum::dictionary                 => WCTitleFormat::italic,
			WCSourceTypeEnum::encyclopedia               => WCTitleFormat::italic,
		WCSourceTypeEnum::periodical                     => WCTitleFormat::italic,
			WCSourceTypeEnum::magazine                   => WCTitleFormat::italic,
			WCSourceTypeEnum::newspaper                  => WCTitleFormat::italic,
			WCSourceTypeEnum::journal                    => WCTitleFormat::italic,
		WCSourceTypeEnum::entry                          => WCTitleFormat::quoted,
			WCSourceTypeEnum::article                    => WCTitleFormat::quoted,
			WCSourceTypeEnum::chapter                    => WCTitleFormat::quoted,
			WCSourceTypeEnum::review                     => WCTitleFormat::quoted,
		WCSourceTypeEnum::paper                          => WCTitleFormat::quoted,
			WCSourceTypeEnum::manuscript                 => WCTitleFormat::quoted,
			WCSourceTypeEnum::musicalScore               => WCTitleFormat::quoted,
			WCSourceTypeEnum::pamphlet                   => WCTitleFormat::italic,
			WCSourceTypeEnum::conferencePaper            => WCTitleFormat::quoted,
			WCSourceTypeEnum::thesis                     => WCTitleFormat::quoted,
			WCSourceTypeEnum::report                     => WCTitleFormat::italic,
			WCSourceTypeEnum::poem                       => WCTitleFormat::quoted,
			WCSourceTypeEnum::song                       => WCTitleFormat::italic,
		WCSourceTypeEnum::enactment                      => WCTitleFormat::quoted,
			WCSourceTypeEnum::bill                       => WCTitleFormat::quoted,
			WCSourceTypeEnum::statute                    => WCTitleFormat::quoted,
			WCSourceTypeEnum::treaty                     => WCTitleFormat::quoted,
			WCSourceTypeEnum::rule                       => WCTitleFormat::quoted,
			WCSourceTypeEnum::regulation                 => WCTitleFormat::quoted,
		WCSourceTypeEnum::legalDocument                  => WCTitleFormat::quoted,
			WCSourceTypeEnum::patent                     => WCTitleFormat::quoted,
			WCSourceTypeEnum::deed                       => WCTitleFormat::quoted,
			WCSourceTypeEnum::governmentGrant            => WCTitleFormat::quoted,
			WCSourceTypeEnum::filing                     => WCTitleFormat::quoted,
				WCSourceTypeEnum::patentApplication      => WCTitleFormat::quoted,
				WCSourceTypeEnum::regulatoryFiling       => WCTitleFormat::quoted,
		WCSourceTypeEnum::litigation                     => WCTitleFormat::italic,
			WCSourceTypeEnum::legalOpinion               => WCTitleFormat::italic,
			WCSourceTypeEnum::legalCase                  => WCTitleFormat::italic,
		WCSourceTypeEnum::graphic                        => WCTitleFormat::italic,
			WCSourceTypeEnum::photograph                 => WCTitleFormat::italic,
			WCSourceTypeEnum::map                        => WCTitleFormat::italic,
		WCSourceTypeEnum::statement                      => WCTitleFormat::quoted,
			WCSourceTypeEnum::pressRelease               => WCTitleFormat::quoted,
			WCSourceTypeEnum::interview                  => WCTitleFormat::quoted,
			WCSourceTypeEnum::speech                     => WCTitleFormat::quoted,
			WCSourceTypeEnum::personalCommunication      => WCTitleFormat::quoted,
		WCSourceTypeEnum::internetResource               => WCTitleFormat::quoted,
			WCSourceTypeEnum::webpage                    => WCTitleFormat::quoted,
			WCSourceTypeEnum::post                       => WCTitleFormat::quoted,
		WCSourceTypeEnum::production                     => WCTitleFormat::italic,
			WCSourceTypeEnum::motionPicture              => WCTitleFormat::italic,
			WCSourceTypeEnum::recording                  => WCTitleFormat::italic,
			WCSourceTypeEnum::play                       => WCTitleFormat::italic,
			WCSourceTypeEnum::broadcast                  => WCTitleFormat::italic,
				WCSourceTypeEnum::televisionBroadcast    => WCTitleFormat::italic,
				WCSourceTypeEnum::radioBroadcast         => WCTitleFormat::italic,
				WCSourceTypeEnum::internetBroadcast      => WCTitleFormat::italic,
		WCSourceTypeEnum::object                         => WCTitleFormat::quoted,
			WCSourceTypeEnum::star                       => WCTitleFormat::quoted,
			WCSourceTypeEnum::gravestone                 => WCTitleFormat::quoted,
			WCSourceTypeEnum::monument                   => WCTitleFormat::quoted,
			WCSourceTypeEnum::realProperty               => WCTitleFormat::quoted,
	);


	/**
	 * Constructor. Overwrites a few style properties of parent class, but
	 * otherwise keeps everything the same as default.
	 */
	public function __construct() {
		parent::__construct();
		$this->punctuationInQuotes   = True;
		$this->replaceAmpersands     = False;
		$this->eraWithoutPunctuation = True;
		$this->eraNoSpace            = False;
		$this->eraBeforeYear         = False;
		$this->styleHTML             = 'Chicago';

	}


	/**
	 * Composes a short inline citation.
	 * In the Chicago Manual of Style, inline citations are only used as part of
	 * author-date system. Thus, this calls $this->renderShortInlineCitation.
	 * is set.
	 * @return array
	 */
	public function renderShortInlineCitation( WCCitation $citation ) {
		return $this->renderShortAuthorDateCitation( $citation );
	}


	/**
	 * Renders a short citation for use in a footnote or endnote.
	 * The resulting citation includes closing sentence punctuation.
	 * @return array
	 */
	public function renderShortNoteCitation( WCCitation $citation ) {
		$workTypeEnum = $citation->reference->getWorkType();

		$titleFormat = new WCTitleFormat( self::$titleFormatArray[ $workTypeEnum->key ] );

		$cite = new WCGroupSegment(
			array(
				new WCNamesSegment(   $citation, $this->important, WCScopeEnum::$work, WCNameTypeEnum::$author, $this->first, WCCitationLengthEnum::$short, False ),
				new WCTitleSegment(   $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$shortTitle, $titleFormat ),
				new WCLocatorSegment( $citation, $this->important, WCPropertyEnum::$page ),
			),
			', ' # delimiter
		);

		return array( $cite->render( $this, '.' ), $cite );
	}


	/**
	 * Composes a short author-date citation.
	 * @return string
	 */
	public function renderShortAuthorDateCitation( WCCitation $citation ) {
		$workTypeEnum = $citation->reference->getWorkType();

		if ( $workTypeEnum->key == WCSourceTypeEnum::personalCommunication ) {
			$locator = new WCAlternativeSegment(
				array (
					new WCLocatorSegment( $citation, $this->important, WCPropertyEnum::$page ),
					new WCLiteralSegment( $this->personalCommunitation ),
				)
			);
		} else {
			$locator = new WCLocatorSegment( $citation, $this->important, WCPropertyEnum::$page );
		}

		$cite = new WCGroupSegment(
			array(
				new WCGroupSegment(
					array(
						new WCNamesSegment( $citation, $this->mandatory, WCScopeEnum::$work, WCNameTypeEnum::$author, $this->first, WCCitationLengthEnum::$short, False ),
						new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ), '', '' ),
					), ' '
				),
				$locator,
			),
			', ', # delimiter
			'(', # prefix
			')'  # suffix
		);

		return array( $cite->render( $this ), $cite );
	}


	/**
	 * Renders a long inline citation.
	 * This citation should omit ending punctuation, and be suitable for
	 * inclusion in inline text as part of a larger sentence.
	 * @return string
	 */
	public function renderLongInlineCitation( WCCitation $citation, $endPunctuation = '' ) {
		return $this->renderLongCitation( $citation, WCCitationTypeEnum::$inline, ', ', $endPunctuation );
	}


	/**
	 * Composes a long citation for a bibliography
	 * By default, this calls renderLongInlineCitation().
	 * @return string
	 */
	public function renderLongBiblioCitation( WCCitation $citation ) {
		return $this->renderLongCitation( $citation, WCCitationTypeEnum::$biblio, '. ', '.' );
	}


	/**
	 * Composes a long note citation
	 * By default, this calls renderLongInlineCitation().
	 * @return string
	 */
	public function renderLongNoteCitation( WCCitation $citation ) {
		return $this->renderLongCitation( $citation, WCCitationTypeEnum::$note, ', ', '.' );
	}


	/**
	 * Composes a long author-date citation
	 * By default, this calls renderLongInlineCitation().
	 * @return string
	 */
	public function renderLongAuthorDateCitation( WCCitation $citation ) {
		return $this->renderLongCitation( $citation, WCCitationTypeEnum::$authorDate, '. ', '.' );
	}


	/**
	 * Renders a long inline citation.
	 * @return string
	 */
	protected function renderLongCitation( WCCitation $citation, WCCitationTypeEnum $citationType, $segmentSeparator, $endPunctuation ) {
		switch ( $citation->reference->getWorkType()->key ) {

			/************************
			 * Books and book-like sources
			 ************************/
			case WCSourceTypeEnum::general:

			case WCSourceTypeEnum::book:
			case WCSourceTypeEnum::dictionary:
			case WCSourceTypeEnum::encyclopedia:
			case WCSourceTypeEnum::pamphlet:
			case WCSourceTypeEnum::report:
				switch ( $citationType->key ) {
					case WCCitationTypeEnum::biblio:
					case WCCitationTypeEnum::authorDate:
						$ed2LabelForm = $this->labelFormVerb;
						$ed2Case = $this->capitalizeFirst;
						$nameSort = True;
						break;
					default:
						$ed2LabelForm = $this->labelFormVerbShort;
						$ed2Case = $this->normalCase;
						$nameSort = False;
				}

				$editorTranslators1 = new WCLabelSegment(
					new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$editorTranslator, $this->first, WCCitationLengthEnum::$long, $nameSort, '', '' ),
					$this->after, $this->labelFormShort, $this->normalCase, $this->contextual
				);
				$editors1 = new WCLabelSegment(
					new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$editor, $this->first, WCCitationLengthEnum::$long, $nameSort, '', '' ),
					$this->after, $this->labelFormShort, $this->normalCase, $this->contextual
				);
				$translators1 = new WCLabelSegment(
					new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$translator, $this->first, WCCitationLengthEnum::$long, $nameSort, '', '' ),
					$this->after, $this->labelFormShort, $this->normalCase, $this->contextual
				);

				$editorTranslators2 = new WCLabelSegment(
					new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$editorTranslator, $this->first, WCCitationLengthEnum::$long, False, '', '' ),
					$this->before, $ed2LabelForm, $ed2Case, new WCLabelPluralEnum( WCLabelPluralEnum::contextual )
				);
				$editors2 = new WCLabelSegment(
					new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$editor, $this->first, WCCitationLengthEnum::$long, False, '', '' ),
					$this->before, $ed2LabelForm, $ed2Case, $this->contextual
				);
				$translators2 = new WCLabelSegment(
					new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$translator, $this->first, WCCitationLengthEnum::$long, False, '', '' ),
					$this->before, $ed2LabelForm, $ed2Case, $this->contextual
				);
				$date = new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ), '', '' );

				$authorsAndTitles = new WCGroupSegment(
					array(
						new WCAlternativeSegment(
							array (
								new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$author, $this->first, WCCitationLengthEnum::$long, $nameSort, '', '' ),
								$editorTranslators1,
								$editors1,
								$translators1,
							)
						),
						new WCConditionalSegment( $citationType->key == WCCitationTypeEnum::authorDate, $date ),
						new WCTitleSegment( $citation, $this->mandatory, WCScopeEnum::$work, WCPropertyEnum::$title, new WCTitleFormat( WCTitleFormat::italic ), '', '' ),
						$editorTranslators2,
						$editors2,
						$translators2,
					),
					$segmentSeparator, # delimiter
					'', # prefix
					''  # suffix
				);
				if ( $editorTranslators1->exists() ) $editorTranslators2->cancel();
				if ( $editors1->exists() ) $editors2->cancel();
				if ( $translators1->exists() ) $translators2->cancel();

				$bookPart = $this->bookPart( $citation, $citationType, $segmentSeparator );

				switch ( $citationType->key ) {
					case WCCitationTypeEnum::biblio:
					case WCCitationTypeEnum::authorDate:
						$cite = new WCGroupSegment(
							array(
								$authorsAndTitles,
								$bookPart,
							), '. '
						);
						break;
					default: # note and inline
						$cite = new WCGroupSegment(
							array(
								$authorsAndTitles,
								$bookPart,
							), ' '
						);
				}
				return array( $cite->render( $this, $endPunctuation ), $cite );

			case WCSourceTypeEnum::periodical:
			case WCSourceTypeEnum::magazine:
			case WCSourceTypeEnum::newspaper:
			case WCSourceTypeEnum::journal:


			case WCSourceTypeEnum::chapter:
			case WCSourceTypeEnum::entry:


			/************************
			 * Articles
			 ************************/
			case WCSourceTypeEnum::article:
				$date = new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ), '(', ')' );
				switch ( $citationType->key ) {
					case WCCitationTypeEnum::biblio:
					case WCCitationTypeEnum::authorDate:
						$artPages = new WCLocatorSegment( $citation, $this->important, WCPropertyEnum::$pageRange, '', '' );
						$nameSort = True;
						break;
					default: # This includes WCCitationTypeEnum::note and inline
						$artPages = new WCLocatorSegment( $citation, $this->important, WCPropertyEnum::$page, '', '' );
						$nameSort = False;
				}
				switch( $citation->reference->getSeriesType()->key ) {
					case WCSourceTypeEnum::magazine:
					case WCSourceTypeEnum::newspaper:
					case WCSourceTypeEnum::journal:
						$cite = new WCGroupSegment(
							array(
								new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$author, $this->first, WCCitationLengthEnum::$long, $nameSort, '', '' ),
								new WCConditionalSegment( $citationType->key == WCCitationTypeEnum::authorDate, new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ), '(', ')' ) ),
								new WCTitleSegment( $citation, $this->mandatory, WCScopeEnum::$work, WCPropertyEnum::$title, new WCTitleFormat( WCTitleFormat::quoted ), '', '' ),
								new WCGroupSegment(
									array(
										new WCGroupSegment(
											array(
												new WCTitleSegment( $citation, $this->mandatory, WCScopeEnum::$series, WCPropertyEnum::$title, new WCTitleFormat( WCTitleFormat::italic ), '', '' ),
												new WCGroupSegment(
													array(
														new WCLocatorSegment( $citation, $this->important, WCPropertyEnum::$volume, '', '' ),
														new WCLabelSegment(
															new WCLocatorSegment( $citation, $this->optional, WCPropertyEnum::$issue, '', '' ),
															$this->before, $this->labelFormShort, $this->normalCase, $this->contextual
														),
													), ', ', '', ''
												),
												new WCConditionalSegment( $citationType->key != WCCitationTypeEnum::authorDate, new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ), '(', ')' ) ),
											), ' ', '', ''
										),
										$artPages,
									), ': ', '', ''
								)
							),
							$segmentSeparator, # delimiter
							'', # prefix
							''  # suffix
						);
						return array( $cite->render( $this, $endPunctuation ), $cite );
					default: #includes magazine, newspaper, and periodical
						$cite = new WCGroupSegment(
							array(
								new WCNamesSegment( $citation, $this->optional, WCScopeEnum::$work, WCNameTypeEnum::$author, $this->first, WCCitationLengthEnum::$long, $nameSort, '', '' ),
								new WCConditionalSegment( $citationType->key == WCCitationTypeEnum::authorDate, new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ), '(', ')' ) ),
								new WCTitleSegment( $citation, $this->mandatory, WCScopeEnum::$work, WCPropertyEnum::$title, new WCTitleFormat( WCTitleFormat::quoted ), '', '' ),
								new WCGroupSegment(
									array(
										new WCGroupSegment(
											array(
												new WCTitleSegment( $citation, $this->mandatory, WCScopeEnum::$series, WCPropertyEnum::$title, new WCTitleFormat( WCTitleFormat::italic ), '', '' ),
												new WCGroupSegment(
													array(
														new WCTextSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$place, '(', ')' ),
														new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ), '', '' ), # this date should be a full date, or month and day if author-date system.
													), ' ', '', ''
												),
												new WCConditionalSegment( $citationType->key != WCCitationTypeEnum::authorDate, new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ), '(', ')' ) ),
											), ' ', '', ''
										),
										$artPages,
									), ': ', '', ''
								)
							),
							$segmentSeparator, # delimiter
							'', # prefix
							''  # suffix
						);
						return array( $cite->render( $this, $endPunctuation ), $cite );
				}

/*			case WCTypeEnum::review:
			case WCTypeEnum::paper:
			case WCTypeEnum::manuscript:
			case WCTypeEnum::musicalScore:
			case WCTypeEnum::conferencePaper:
			case WCTypeEnum::thesis:
			case WCTypeEnum::poem:
			case WCTypeEnum::song:
			case WCTypeEnum::enactment:
			case WCTypeEnum::bill:
			case WCTypeEnum::statute:
			case WCTypeEnum::treaty:
			case WCTypeEnum::rule:
			case WCTypeEnum::regulation:
			case WCTypeEnum::legalDocument:
			case WCTypeEnum::patent:
			case WCTypeEnum::deed:
			case WCTypeEnum::governmentGrant:
			case WCTypeEnum::filing:
			case WCTypeEnum::patentApplication:
			case WCTypeEnum::regulatoryFiling:
			case WCTypeEnum::litigation:
			case WCTypeEnum::legalOpinion:
			case WCTypeEnum::legalCase:
			case WCTypeEnum::graphic:
			case WCTypeEnum::photograph:
			case WCTypeEnum::map:
			case WCTypeEnum::statement:
			case WCTypeEnum::pressRelease:
			case WCTypeEnum::interview:
			case WCTypeEnum::speech:
			case WCTypeEnum::personalCommunication:
			case WCTypeEnum::internetResource:
			case WCTypeEnum::webpage:
			case WCTypeEnum::post:
			case WCTypeEnum::production:
			case WCTypeEnum::motionPicture:
			case WCTypeEnum::recording:
			case WCTypeEnum::play:
			case WCTypeEnum::broadcast:
			case WCTypeEnum::televisionBroadcast:
			case WCTypeEnum::radioBroadcast:
			case WCTypeEnum::internetBroadcast:
			case WCTypeEnum::object:
			case WCTypeEnum::star:
			case WCTypeEnum::gravestone:
			case WCTypeEnum::monument:
			case WCTypeEnum::realProperty:
*/
		}
	}


	protected function bookPart( WCCitation $citation, WCCitationTypeEnum $citationType, $segmentSeparator ) {
		# publisher-place: publisher
		$placePublisher = new WCGroupSegment(
			array(
				new WCTextSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$place ),
				new WCNamesSegment( $citation, $this->important, WCScopeEnum::$work, WCNameTypeEnum::$publisher, $this->first, WCCitationLengthEnum::$long, False ),
			), ': '
		);
		$year = new WCDateSegment( $citation, $this->important, WCScopeEnum::$work, WCPropertyEnum::$date, new WCDateParts( WCDateParts::year ), new WCDateOrder( WCDateOrder::littleEndian ), new WCDateForm( WCDateForm::numeric ), new WCDateRange( WCDateRange::range ) );

		switch ( $citationType->key ) {
			case WCCitationTypeEnum::biblio: # publisher-place: publisher, year.
				$placePublisherDate = new WCGroupSegment(
					array(
						$placePublisher,
						$year,
					), ', '
				);
				break;
			case WCCitationTypeEnum::authorDate: # publisher-place: publisher
				$placePublisherDate = $placePublisher;
				break;
			default: # note, inline -- (publisher-place: publisher, year), page
				$placePublisherDate = new WCGroupSegment(
					array(
						new WCGroupSegment(
							array(
								$placePublisher,
								$year,
							), ', ', '(', ')'
						),
						new WCLocatorSegment( $citation, $this->important, WCPropertyEnum::$page ),
					), ', '
				);
		}
		return new WCGroupSegment(
			array(
				$placePublisherDate,
				$this->urlPart( $citation, $citationType, $segmentSeparator ),
			), $segmentSeparator
		);
	}


	protected function urlPart( WCCitation $citation, WCCitationTypeEnum $citationType, $segmentSeparator ) {
		$url = new WCTextSegment( $citation, $this->optional, WCScopeEnum::$work, WCPropertyEnum::$url );
		return new WCConditionalSegment(
			$url->exists(),
			new WCGroupSegment(
				array(
					new WCDateSegment( $citation, $this->optional, WCScopeEnum::$work, WCPropertyEnum::$accessed, new WCDateParts( WCDateParts::yearMonthDay ), new WCDateOrder( WCDateOrder::middleEndian ), new WCDateForm( WCDateForm::long ), new WCDateRange( WCDateRange::range ) ),
					$url,
				), $segmentSeparator
			)
		);
	}


}
