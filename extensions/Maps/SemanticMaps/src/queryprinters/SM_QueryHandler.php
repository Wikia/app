<?php

use Maps\Elements\Location;

/**
 * Class for handling geographical SMW queries.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMQueryHandler {

	/**
	 * The global icon.
	 *
	 * @var string
	 */
	public $icon = '';
	/**
	 * The global text.
	 *
	 * @var string
	 */
	public $text = '';
	/**
	 * The global title.
	 *
	 * @var string
	 */
	public $title = '';
	/**
	 * Make a separate link to the title or not?
	 *
	 * @var boolean
	 */
	public $titleLinkSeparate = false;
	private $queryResult;
	private $outputMode;
	/**
	 * @var array
	 */
	private $geoShapes = [
		'lines' => [],
		'locations' => [],
		'polygons' => []
	];
	/**
	 * The template to use for the text, or false if there is none.
	 *
	 * @var string|boolean false
	 */
	private $template = false;
	/**
	 * Should link targets be made absolute (instead of relative)?
	 *
	 * @var boolean
	 */
	private $linkAbsolute;

	/**
	 * The text used for the link to the page (if it's created). $1 will be replaced by the page name.
	 *
	 * @var string
	 */
	private $pageLinkText = '$1';

	/**
	 * A separator to use between the subject and properties in the text field.
	 *
	 * @var string
	 */
	private $subjectSeparator = '<hr />';

	/**
	 * Make the subject in the text bold or not?
	 *
	 * @var boolean
	 */
	private $boldSubject = true;

	/**
	 * Show the subject in the text or not?
	 *
	 * @var boolean
	 */
	private $showSubject = true;

	/**
	 * Hide the namespace or not.
	 *
	 * @var boolean
	 */
	private $hideNamespace = false;

	/**
	 * Defines which article names in the result are hyperlinked, all normally is the default
	 * none, subject, all
	 */
	private $linkStyle = 'all';

	/*
	 * Show headers (with links), show headers (just text) or hide them. show is default
	 * show, plain, hide
	 */
	private $headerStyle = 'show';

	/**
	 * Marker icon to show when marker equals active page
	 *
	 * @var string|null
	 */
	private $activeIcon = null;

	/**
	 * @var string
	 */
	private $userParam = '';

	/**
	 * @param SMWQueryResult $queryResult
	 * @param integer $outputMode
	 * @param boolean $linkAbsolute
	 */
	public function __construct( SMWQueryResult $queryResult, $outputMode, $linkAbsolute = false ) {
		$this->queryResult = $queryResult;
		$this->outputMode = $outputMode;
		$this->linkAbsolute = $linkAbsolute;
	}

	/**
	 * Sets the template.
	 *
	 * @param string $template
	 */
	public function setTemplate( $template ) {
		$this->template = $template === '' ? false : $template;
	}

	/**
	 * @param string $userParam
	 */
	public function setUserParam( $userParam ) {
		$this->userParam = $userParam;
	}

	/**
	 * Sets the global icon.
	 *
	 * @param string $icon
	 */
	public function setIcon( $icon ) {
		$this->icon = $icon;
	}

	/**
	 * Sets the global title.
	 *
	 * @param string $title
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * Sets the global text.
	 *
	 * @param string $text
	 */
	public function setText( $text ) {
		$this->text = $text;
	}

	/**
	 * Sets the subject separator.
	 *
	 * @param string $subjectSeparator
	 */
	public function setSubjectSeparator( $subjectSeparator ) {
		$this->subjectSeparator = $subjectSeparator;
	}

	/**
	 * Sets if the subject should be made bold in the text.
	 *
	 * @param string $boldSubject
	 */
	public function setBoldSubject( $boldSubject ) {
		$this->boldSubject = $boldSubject;
	}

	/**
	 * Sets if the subject should shown in the text.
	 *
	 * @param string $showSubject
	 */
	public function setShowSubject( $showSubject ) {
		$this->showSubject = $showSubject;
	}

	/**
	 * Sets the text for the link to the page when separate from the title.
	 *
	 * @param string $text
	 */
	public function setPageLinkText( $text ) {
		$this->pageLinkText = $text;
	}

	/**
	 *
	 * @param boolean $link
	 */
	public function setLinkStyle( $link ) {
		$this->linkStyle = $link;
	}

	/**
	 *
	 * @param boolean $headers
	 */
	public function setHeaderStyle( $headers ) {
		$this->headerStyle = $headers;
	}

	/**
	 * @return array
	 */
	public function getShapes() {
		$this->findShapes();
		return $this->geoShapes;
	}

	/**
	 * @since 2.0
	 */
	private function findShapes() {
		while ( ( $row = $this->queryResult->getNext() ) !== false ) {
			$this->handleResultRow( $row );
		}
	}

	/**
	 * Returns the locations found in the provided result row.
	 *
	 * @param SMWResultArray[] $row
	 */
	private function handleResultRow( array $row ) {
		$locations = [];
		$properties = [];

		$title = '';
		$text = '';

		// Loop through all fields of the record.
		foreach ( $row as $i => $resultArray ) {
			$printRequest = $resultArray->getPrintRequest();

			// Loop through all the parts of the field value.
			while ( ( $dataValue = $resultArray->getNextDataValue() ) !== false ) {
				if ( $dataValue->getTypeID() == '_wpg' && $i == 0 ) {
					list( $title, $text ) = $this->handleResultSubject( $dataValue );
				} else {
					if ( $dataValue->getTypeID() == '_str' && $i == 0 ) {
						$title = $dataValue->getLongText( $this->outputMode, null );
						$text = $dataValue->getLongText( $this->outputMode, smwfGetLinker() );
					} else {
						if ( $dataValue->getTypeID() == '_gpo' ) {
							$dataItem = $dataValue->getDataItem();
							$polyHandler = new PolygonHandler ( $dataItem->getString() );
							$this->geoShapes[$polyHandler->getGeoType()][] = $polyHandler->shapeFromText();
						} else {
							if ( strpos( $dataValue->getTypeID(), '_rec' ) !== false ) {
								foreach ( $dataValue->getDataItems() as $dataItem ) {
									if ( $dataItem instanceof \SMWDIGeoCoord ) {
										$location = Location::newFromLatLon(
											$dataItem->getLatitude(),
											$dataItem->getLongitude()
										);
										$locations[] = $location;
									}
								}
							} else {
								if ( $dataValue->getTypeID() != '_geo' && $i != 0 && !$this->isHeadersHide() ) {
									$properties[] = $this->handleResultProperty( $dataValue, $printRequest );
								} else {
									if ( $printRequest->getMode(
										) == SMWPrintRequest::PRINT_PROP && $printRequest->getTypeID(
										) == '_geo' || $dataValue->getTypeID() == '_geo' ) {
										$dataItem = $dataValue->getDataItem();

										$location = Location::newFromLatLon(
											$dataItem->getLatitude(),
											$dataItem->getLongitude()
										);

										$locations[] = $location;
									}
								}
							}
						}
					}
				}
			}
		}

		if ( $properties !== [] && $text !== '' ) {
			$text .= $this->subjectSeparator;
		}

		$icon = $this->getLocationIcon( $row );

		$this->geoShapes['locations'] = array_merge(
			$this->geoShapes['locations'],
			$this->buildLocationsList(
				$locations,
				$text,
				$icon,
				$properties,
				Title::newFromText( $title )
			)
		);
	}

	/**
	 * Handles a SMWWikiPageValue subject value.
	 * Gets the plain text title and creates the HTML text with headers and the like.
	 *
	 * @param SMWWikiPageValue $object
	 *
	 * @return array with title and text
	 */
	private function handleResultSubject( SMWWikiPageValue $object ) {
		$title = $object->getLongText( $this->outputMode, null );
		$text = '';

		if ( $this->showSubject ) {
			if ( !$this->showArticleLink() ) {
				$text = $this->hideNamespace ? $object->getText() : $object->getTitle()->getFullText();
			} else {
				if ( !$this->titleLinkSeparate && $this->linkAbsolute ) {
					$text = Html::element(
						'a',
						[ 'href' => $object->getTitle()->getFullUrl() ],
						$this->hideNamespace ? $object->getText() : $object->getTitle()->getFullText()
					);
				} else {
					if ( $this->hideNamespace ) {
						$text = $object->getShortHTMLText( smwfGetLinker() );
					} else {
						$text = $object->getLongHTMLText( smwfGetLinker() );
					}
				}
			}

			if ( $this->boldSubject ) {
				$text = '<b>' . $text . '</b>';
			}

			if ( $this->titleLinkSeparate ) {
				$txt = $object->getTitle()->getText();

				if ( $this->pageLinkText !== '' ) {
					$txt = str_replace( '$1', $txt, $this->pageLinkText );
				}
				$text .= Html::element(
					'a',
					[ 'href' => $object->getTitle()->getFullUrl() ],
					$txt
				);
			}
		}

		return [ $title, $text ];
	}

	private function showArticleLink() {
		return $this->linkStyle !== 'none';
	}

	private function isHeadersHide() {
		return $this->headerStyle === 'hide';
	}

	/**
	 * Handles a single property (SMWPrintRequest) to be displayed for a record (SMWDataValue).
	 *
	 * @param SMWDataValue $object
	 * @param SMWPrintRequest $printRequest
	 *
	 * @return string
	 */
	private function handleResultProperty( SMWDataValue $object, SMWPrintRequest $printRequest ) {
		if ( $this->hasTemplate() ) {
			if ( $object instanceof SMWWikiPageValue ) {
				return $object->getTitle()->getPrefixedText();
			}

			return $object->getLongText( SMW_OUTPUT_WIKI, null );
		}

		if ( $this->linkAbsolute ) {
			$titleText = $printRequest->getText( null );
			$t = Title::newFromText( $titleText, SMW_NS_PROPERTY );

			if ( $this->isHeadersShow() && $t instanceof Title && $t->exists() ) {
				$propertyName = $propertyName = Html::element(
					'a',
					[ 'href' => $t->getFullUrl() ],
					$printRequest->getHTMLText( null )
				);
			} else {
				$propertyName = $titleText;
			}
		} else {
			if ( $this->isHeadersShow() ) {
				$propertyName = $printRequest->getHTMLText( smwfGetLinker() );
			} else {
				if ( $this->isHeadersPlain() ) {
					$propertyName = $printRequest->getText( null );
				}
			}
		}

		if ( $this->linkAbsolute ) {
			$hasPage = $object->getTypeID() == '_wpg';

			if ( $hasPage ) {
				$t = Title::newFromText( $object->getLongText( $this->outputMode, null ), NS_MAIN );
				$hasPage = $t !== null && $t->exists();
			}

			if ( $hasPage ) {
				$propertyValue = Html::element(
					'a',
					[ 'href' => $t->getFullUrl() ],
					$object->getLongText( $this->outputMode, null )
				);
			} else {
				$propertyValue = $object->getLongText( $this->outputMode, null );
			}
		} else {
			$propertyValue = $object->getLongText( $this->outputMode, smwfGetLinker() );
		}

		return $propertyName . ( $propertyName === '' ? '' : ': ' ) . $propertyValue;
	}

	private function hasTemplate() {
		return is_string( $this->template );
	}

	private function isHeadersShow() {
		return $this->headerStyle === 'show';
	}

	private function isHeadersPlain() {
		return $this->headerStyle === 'plain';
	}

	/**
	 * Get the icon for a row.
	 *
	 * @param array $row
	 *
	 * @return string
	 */
	private function getLocationIcon( array $row ) {
		$icon = '';
		$legendLabels = [];

		//Check for activeicon parameter

		if ( $this->shouldGetActiveIconUrlFor( $row[0]->getResultSubject()->getTitle() ) ) {
			$icon = MapsMapper::getFileUrl( $this->activeIcon );
		}

		// Look for display_options field, which can be set by Semantic Compound Queries
		// the location of this field changed in SMW 1.5
		$display_location = method_exists( $row[0], 'getResultSubject' ) ? $row[0]->getResultSubject() : $row[0];

		if ( property_exists( $display_location, 'display_options' ) && is_array(
				$display_location->display_options
			) ) {
			$display_options = $display_location->display_options;
			if ( array_key_exists( 'icon', $display_options ) ) {
				$icon = $display_options['icon'];

				// This is somewhat of a hack - if a legend label has been set, we're getting it for every point, instead of just once per icon
				if ( array_key_exists( 'legend label', $display_options ) ) {

					$legend_label = $display_options['legend label'];

					if ( !array_key_exists( $icon, $legendLabels ) ) {
						$legendLabels[$icon] = $legend_label;
					}
				}
			}
		} // Icon can be set even for regular, non-compound queries If it is, though, we have to translate the name into a URL here
		elseif ( $this->icon !== '' ) {
			$icon = MapsMapper::getFileUrl( $this->icon );
		}

		return $icon;
	}

	private function shouldGetActiveIconUrlFor( Title $title ) {
		global $wgTitle;

		return isset( $this->activeIcon ) && is_object( $wgTitle )
			&& $wgTitle->equals( $title );
	}

	/**
	 * Builds a set of locations with the provided title, text and icon.
	 *
	 * @param Location[] $locations
	 * @param string $text
	 * @param string $icon
	 * @param array $properties
	 * @param Title|null $title
	 *
	 * @return Location[]
	 */
	private function buildLocationsList( array $locations, $text, $icon, array $properties, Title $title = null ) {
		if ( !$this->hasTemplate() ) {
			$text .= implode( '<br />', $properties );
		}

		$titleOutput = $this->getTitleOutput( $title );

		foreach ( $locations as &$location ) {
			if ( $this->hasTemplate() ) {
				$segments = array_merge(
					[
						$this->template,
						'title=' . $titleOutput,
						'latitude=' . $location->getCoordinates()->getLatitude(),
						'longitude=' . $location->getCoordinates()->getLongitude(),
						'userparam=' . $this->userParam
					],
					$properties
				);

				$text .= $this->getParser()->recursiveTagParseFully(
					'{{' . implode( '|', $segments ) . '}}'
				);
			}

			$location->setTitle( $titleOutput );
			$location->setText( $text );
			$location->setIcon( $icon );
		}

		return $locations;
	}

	private function getTitleOutput( Title $title = null ) {
		if ( $title === null ) {
			return '';
		}

		return $this->hideNamespace ? $title->getText() : $title->getFullText();
	}

	/**
	 * @return \Parser
	 */
	private function getParser() {
		return $GLOBALS['wgParser'];
	}

	/**
	 * @return boolean
	 */
	public function getHideNamespace() {
		return $this->hideNamespace;
	}

	/**
	 * @param boolean $hideNamespace
	 */
	public function setHideNamespace( $hideNamespace ) {
		$this->hideNamespace = $hideNamespace;
	}

	/**
	 * @return string
	 */
	public function getActiveIcon() {
		return $this->activeIcon;
	}

	/**
	 * @param string $activeIcon
	 */
	public function setActiveIcon( $activeIcon ) {
		$this->activeIcon = $activeIcon;
	}

}
