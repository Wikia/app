<?php

/**
 * Class for handling geographical SMW queries.
 *
 * @since 0.7.3
 *
 * @ingroup SemanticMaps
 * @file SM_QueryHandler.php
 *
 * @author Jeroen De Dauw
 */
class SMQueryHandler {

	protected $queryResult;
	protected $outputmode;

	protected $locations = false;

	/**
	 * The template to use for the text, or false if there is none.
	 *
	 * @since 0.7.3
	 *
	 * @var false or string
	 */
	protected $template = false;

	/**
	 * The global icon.
	 *
	 * @since 0.7.3
	 *
	 * @var string
	 */
	public $icon = '';

	/**
	 * The global text.
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public $text = '';

	/**
	 * The global title.
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * Make a separate link to the title or not?
	 *
	 * @since 0.7.3
	 *
	 * @var boolean
	 */
	public $titleLinkSeparate;

	/**
	 * Should link targets be made absolute (instead of relative)?
	 *
	 * @since 1.0
	 *
	 * @var boolean
	 */
	protected $linkAbsolute;

	/**
	 * The text used for the link to the page (if it's created). $1 will be replaced by the page name.
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	protected $pageLinkText;

	/**
	 * A separator to use beteen the subject and properties in the text field.
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	protected $subjectSeparator = '<hr />';

	/**
	 * Make the subject in the text bold or not?
	 *
	 * @since 1.0
	 *
	 * @var boolean
	 */
	protected $boldSubject = true;

	/**
	 * Show the subject in the text or not?
	 *
	 * @since 1.0
	 *
	 * @var boolean
	 */
	protected $showSubject = true;

	/**
	 * Constructor.
	 *
	 * @since 0.7.3
	 *
	 * @param SMWQueryResult $queryResult
	 * @param integer $outputmode
	 */
	public function __construct( SMWQueryResult $queryResult, $outputmode, $linkAbsolute = false, $pageLinkText = '$1', $titleLinkSeparate = false ) {
		$this->queryResult = $queryResult;
		$this->outputmode = $outputmode;

		$this->linkAbsolute = $linkAbsolute;
		$this->pageLinkText = $pageLinkText;
		$this->titleLinkSeparate = $titleLinkSeparate;
	}

	/**
	 * Sets the template.
	 *
	 * @since 1.0
	 *
	 * @param string $template
	 */
	public function setTemplate( $template ) {
		$this->template = $template === '' ? false : $template;
	}

	/**
	 * Sets the global icon.
	 *
	 * @since 1.0
	 *
	 * @param string $icon
	 */
	public function setIcon( $icon ) {
		$this->icon = $icon;
	}

	/**
	 * Sets the global title.
	 *
	 * @since 1.0
	 *
	 * @param string $title
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * Sets the global text.
	 *
	 * @since 1.0
	 *
	 * @param string $text
	 */
	public function setText( $text ) {
		$this->text = $text;
	}

	/**
	 * Sets the subject separator.
	 *
	 * @since 1.0
	 *
	 * @param string $subjectSeparator
	 */
	public function setSubjectSeparator( $subjectSeparator ) {
		$this->subjectSeparator = $subjectSeparator;
	}

	/**
	 * Sets if the subject should be made bold in the text.
	 *
	 * @since 1.0
	 *
	 * @param string $boldSubject
	 */
	public function setBoldSubject( $boldSubject ) {
		$this->boldSubject = $boldSubject;
	}

	/**
	 * Sets if the subject should shown in the text.
	 *
	 * @since 1.0
	 *
	 * @param string $showSubject
	 */
	public function setShowSubject( $showSubject ) {
		$this->showSubject = $showSubject;
	}

	/**
	 * Sets the text for the link to the page when separate from the title.
	 *
	 * @since 1.0
	 *
	 * @param string $text
	 */
	public function setPageLinkText( $text ) {
		$this->pageLinkText = $text;
	}

	/**
	 * Gets the query result as a list of locations.
	 *
	 * @since 0.7.3
	 *
	 * @return array of MapsLocation
	 */
	public function getLocations() {
		if ( $this->locations === false ) {
			$this->locations = $this->findLocations();
		}

		return $this->locations;
	}

	/**
	 * Gets the query result as a list of locations.
	 *
	 * @since 0.7.3
	 *
	 * @return array of MapsLocation
	 */
	protected function findLocations() {
		$locations = array();

		while ( ( $row = $this->queryResult->getNext() ) !== false ) {
			$locations = array_merge( $locations, $this->handleResultRow( $row ) );
		}

		return $locations;
	}

	/**
	 * Returns the locations found in the provided result row.
	 *
	 * @since 0.7.3
	 *
	 * @param array $row Array of SMWResultArray
	 *
	 * @return array of MapsLocation
	 */
	protected function handleResultRow( array /* of SMWResultArray */ $row ) {
		$locations = array();
		$properties = array();

		$title = '';
		$text = '';

		// Loop throught all fields of the record.
		foreach ( $row as $i => $resultArray ) {
			/* SMWPrintRequest */ $printRequest = $resultArray->getPrintRequest();

			// Loop throught all the parts of the field value.
			while ( ( /* SMWDataValue */ $dataValue = $resultArray->getNextDataValue() ) !== false ) {
				if ( $dataValue->getTypeID() == '_wpg' && $i == 0 ) {
					list( $title, $text ) = $this->handleResultSubject( $dataValue );
				}
				else if ( $dataValue->getTypeID() == '_str' && $i == 0 ) {
					$title = $dataValue->getLongText( $this->outputmode, null );
					$text = $dataValue->getLongText( $this->outputmode, $GLOBALS['wgUser']->getSkin() );
				}
				else if ( $dataValue->getTypeID() != '_geo' && $i != 0 ) {
					$properties[] = $this->handleResultProperty( $dataValue, $printRequest );
				}
				else if ( $printRequest->getMode() == SMWPrintRequest::PRINT_PROP && $printRequest->getTypeID() == '_geo' ) {
					$dataItem = $dataValue->getDataItem();

					$location = MapsLocation::newFromLatLon( $dataItem->getLatitude(), $dataItem->getLongitude() );

					if ( $location->isValid() ) {
						$locations[] = $location;
					}

				}
			}
		}

		if ( count( $properties ) > 0 && $text !== '' ) {
			$text .= $this->subjectSeparator;
		}

		$icon = $this->getLocationIcon( $row );

		return $this->buildLocationsList( $locations, $title, $text, $icon, $properties );
	}

	/**
	 * Handles a SMWWikiPageValue subject value.
	 * Gets the plain text title and creates the HTML text with headers and the like.
	 *
	 * @since 1.0
	 *
	 * @param SMWWikiPageValue $object
	 *
	 * @return array with title and text
	 */
	protected function handleResultSubject( SMWWikiPageValue $object ) {
		global $wgUser;

		$title = $object->getLongText( $this->outputmode, null );
		$text = '';

		if ( $this->showSubject ) {
			if ( !$this->titleLinkSeparate && $this->linkAbsolute ) {
				$text = Html::element(
					'a',
					array( 'href' => $object->getTitle()->getFullUrl() ),
					$object->getTitle()->getText()
				);
			}
			else {
				$text = $object->getLongText( $this->outputmode, $wgUser->getSkin() );
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
					array( 'href' => $object->getTitle()->getFullUrl() ),
                    $txt
				);
			}
		}

		return array( $title, $text );
	}

	/**
	 * Handles a single property (SMWPrintRequest) to be displayed for a record (SMWDataValue).
	 *
	 * @since 1.0
	 *
	 * @param SMWDataValue $object
	 * @param SMWPrintRequest $printRequest
	 *
	 * @return string
	 */
	protected function handleResultProperty( SMWDataValue $object, SMWPrintRequest $printRequest ) {
		global $wgUser;

		if ( $this->template ) {
			if ( $object instanceof SMWWikiPageValue ) {
				return $object->getTitle()->getPrefixedText();
			} else {
				return $object->getLongText( SMW_OUTPUT_WIKI, NULL );
			}
		}

		if ( $this->linkAbsolute ) {
			$t = Title::newFromText( $printRequest->getHTMLText( NULL ), SMW_NS_PROPERTY );

			if ( $t instanceof Title && $t->exists() ) {
				$propertyName = $propertyName = Html::element(
					'a',
					array( 'href' => $t->getFullUrl() ),
					$printRequest->getHTMLText( NULL )
				);
			}
			else {
				$propertyName = $printRequest->getHTMLText( NULL );
			}
		}
		else {
			$propertyName = $printRequest->getHTMLText( $wgUser->getSkin() );
		}

		if ( $this->linkAbsolute ) {
			$hasPage = $object->getTypeID() == '_wpg';

			if ( $hasPage ) {
				$t = Title::newFromText( $object->getLongText( $this->outputmode, NULL ), NS_MAIN );
				$hasPage = $t->exists();
			}

			if ( $hasPage ) {
				$propertyValue = Html::element(
					'a',
					array( 'href' => $t->getFullUrl() ),
					$object->getLongText( $this->outputmode, NULL )
				);
			}
			else {
				$propertyValue = $object->getLongText( $this->outputmode, NULL );
			}
		}
		else {
			$propertyValue = $object->getLongText( $this->outputmode, $wgUser->getSkin() );
		}

		return $propertyName . ( $propertyName === '' ? '' : ': ' ) . $propertyValue;
	}

	/**
	 * Builds a set of locations with the provided title, text and icon.
	 *
	 * @since 1.0
	 *
	 * @param array of MapsLocation $locations
	 * @param string $title
	 * @param string $text
	 * @param string $icon
	 * @param array $properties
	 *
	 * @return array of MapsLocation
	 */
	protected function buildLocationsList( array $locations, $title, $text, $icon, array $properties ) {
		if ( $this->template ) {
			global $wgParser;
			$parser = version_compare( $GLOBALS['wgVersion'], '1.18', '<' ) ? $wgParser : clone $wgParser;
		}
		else {
			$text .= implode( '<br />', $properties );
		}

		foreach ( $locations as $location ) {
			if ( $this->template ) {
				$segments = array_merge(
					array( $this->template, 'title=' . $title, 'latitude=' . $location->getLatitude(), 'longitude=' . $location->getLongitude() ),
					$properties
				);

				$text .= $parser->parse( '{{' . implode( '|', $segments ) . '}}', $parser->getTitle(), new ParserOptions() )->getText();
			}

			$location->setTitle( $title );
			$location->setText( $text );
			$location->setIcon( $icon );

			$locations[] = $location;
		}

		return $locations;
	}

	/**
	 * Get the icon for a row.
	 *
	 * @since 0.7.3
	 *
	 * @param array $row
	 *
	 * @return string
	 */
	protected function getLocationIcon( array $row ) {
		$icon = '';
		$legend_labels = array();

		// Look for display_options field, which can be set by Semantic Compound Queries
        // the location of this field changed in SMW 1.5
		$display_location = method_exists( $row[0], 'getResultSubject' ) ? $row[0]->getResultSubject() : $row[0];

		if ( property_exists( $display_location, 'display_options' ) && is_array( $display_location->display_options ) ) {
			$display_options = $display_location->display_options;
			if ( array_key_exists( 'icon', $display_options ) ) {
				$icon = $display_options['icon'];

				// This is somewhat of a hack - if a legend label has been set, we're getting it for every point, instead of just once per icon
				if ( array_key_exists( 'legend label', $display_options ) ) {

					$legend_label = $display_options['legend label'];

					if ( ! array_key_exists( $icon, $legend_labels ) ) {
						$legend_labels[$icon] = $legend_label;
					}
				}
			}
		} // Icon can be set even for regular, non-compound queries If it is, though, we have to translate the name into a URL here
		elseif ( $this->icon !== '' ) {
			$icon = MapsMapper::getFileUrl( $this->icon );
		}

		return $icon;
	}

}
