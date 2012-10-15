<?php
/**
 * Frequent Pattern Tag Cloud Plug-in
 * Special page
 *
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

include_once( FPTC_PATH_INCLUDES . 'TagCloud.php' );
include_once( FPTC_PATH_INCLUDES . 'Proposal.php' );

class FreqPatternTagCloud extends SpecialPage {

	const ATTRIBUTE_VALUE_INDEX_SPECIALPAGE = 'SearchByProperty';

	const CATEGORY_PAGE = 'Category';

	/**
	 * Maximum font size of tags in px
	 *
	 * @var int
	 */
	private $fontSizeMax = 70;

	/**
	 * Minimum font size of tags in px
	 *
	 * @var int
	 */
	private $fontSizeMin = 8;

	const MAINTENANCE_SPECIALPAGE = 'FreqPatternTagCloudMaintenance';

	const SPECIALPAGE_PREFIX = 'Special';

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'FreqPatternTagCloud' );
		$this->includable( true );
	}

	/**
	 * Executes special page (will be called when accessing special page)
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgFreqPatternTagCloudMaxFontSize, $wgFreqPatternTagCloudMinFontSize;

		include_once( "includes/FrequentPattern.php" );
		/*
		FrequentPattern::deleteAllRules();
		FrequentPattern::computeAllRules();
		FrequentPattern::showAllRules();
		*/

		$this->setHeaders();

		// Configuration
		// @todo FIXME: register_globals...
		if (isset($wgFreqPatternTagCloudMaxFontSize)) {
			$this->fontSizeMax = $wgFreqPatternTagCloudMaxFontSize;
		}
		if (isset($wgFreqPatternTagCloudMinFontSize)) {
			$this->fontSizeMin = $wgFreqPatternTagCloudMinFontSize;
		}

		// Check whether special page is included
		// Show attribute-selection form only if special page is not included and $par was given
		if ( !$this->including() || !strlen( $par ) ) {
			// Print form
			$this->printForm( $par );

			// Print search result with suggestions
			$this->printSearchResult( $par );
		}

		$this->printTagCloud( $par );
	}

	/**
	 * Gets suggestions for current attribute value
	 *
	 * @param $currentAttributeValue String
	 * @return string JSON Array of attributes
	 */
	public static function getAttributeSuggestions( $currentAttributeValue ) {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'smw_ids',
			'smw_title',
			array(
				'smw_namespace' => 102,
				'LENGTH(smw_iw) = 0',
				'smw_title ' . $dbr->buildLike(
					$dbr->anyString(),
					$currentAttributeValue,
					$dbr->anyString()
				)
			),
			__METHOD__,
			array( 'ORDER BY' => 'smw_title', 'LIMIT' => 20 )
		);

		$attributes = array();
		while ( $row = $res->fetchRow() ) {
			$attributes[] = sprintf( '"%s"', addcslashes( $row['smw_title'], '"' ) );
		}

		// Category
		if ( strpos( wfMsg( 'fptc-categoryname' ), $currentAttributeValue ) !== false ) {
			$attributes[] = sprintf( '"%s"', wfMsg( 'fptc-categoryname' ) );
		}

		return sprintf( '[%s]', implode( ', ', $attributes ) );
	}

	/**
	 * Gets suggestions for current search value
	 *
	 * @param $currentSearchValue String
	 * @return string JSON Array of values
	 */
	public static function getSearchSuggestions( $currentSearchValue ) {
		$dbr = wfGetDB( DB_SLAVE );

		// Get possible attribute values
		$res = $dbr->query(
			"(SELECT DISTINCT vals.smw_title AS val, atts.smw_title AS att
				FROM ".$dbr->tableName("smw_ids")." vals, ".$dbr->tableName("smw_ids")." atts, ".$dbr->tableName("smw_rels2")." rels
				WHERE vals.smw_id = rels.o_id
				AND atts.smw_id = rels.p_id
				AND vals.smw_namespace = 0
				AND atts.smw_namespace = 102
				AND LENGTH(vals.smw_iw) = 0
				AND LENGTH(atts.smw_iw) = 0
					AND vals.smw_title LIKE '%".mysql_real_escape_string($currentSearchValue)."%'
					ORDER BY vals.smw_title
					LIMIT 20) UNION (
					SELECT smw_title AS val, '".mysql_real_escape_string(wfMsg("fptc-categoryname"))."' AS att
					FROM ".$dbr->tableName("smw_ids")."
					WHERE smw_title LIKE '%".mysql_real_escape_string($currentSearchValue)."%'
					AND smw_namespace = 14
					ORDER BY smw_title
					LIMIT 10
				)"
		);

		$suggestions = array();
		while ( $row = $res->fetchRow() ) {
			// Apply frequent pattern rules
			$conclusions = FrequentPattern::getConclusions( $row['att'], $row['val'] );

			if ( !count( $conclusions ) ) {
				continue;
			} else {
				foreach ( $conclusions as $conclusion ) {
					$suggestions[] = sprintf(
						'{ "label": "%s", "category": "' .
							addcslashes( wfMsg( 'fptc-search-suggestion-value' ), '"' ) .
							'" }', addcslashes( $conclusion, '"' ), addcslashes( $row['val'], '"' )
					);
				}
			}
		}

		return sprintf( '[%s]', implode( ', ', $suggestions ) );
	}

	/**
	 * Gets suggestions
	 *
	 * @param $attribute String: attribute
	 * @param $value String: chosen value
	 * @return string
	 */
	public static function getSuggestions( $attribute, $value ) {
		// Get similar tags, sorted by priority
		$tags = FrequentPattern::getConclusions( $attribute, $value );

		if ( !count( $tags ) ) {
			return '<li class="no_entries">-</li>';
		} else {
			$suggestions = array();
			foreach ( $tags as $number => $tag ) {
				$suggestions[] = sprintf(
					'<li class="similar_tag"><a href="#browse_similar_tag" title="%2$s">%1$d. %2$s</a></li>',
					$number + 1, $tag
				);
			}

			return implode( "\n", $suggestions );
		}
	}

	/**
	 * Prints form to <code>$wgOut</code>
	 *
	 * @param $defaultAttribute String: (optional)Default value for attribute to be tagged
	 */
	private function printForm( $defaultAttribute ) {
		global $wgOut, $wgUser;

		// Add input field
		if ( $wgUser->isAllowed( 'protect' ) ) {
			$refreshData = sprintf(
				'<div id="fptc_refresh">%s</div>',
				$wgOut->parseInline(
					sprintf(
						'[[:%s:%s|%s]]',
						self::SPECIALPAGE_PREFIX,
						self::MAINTENANCE_SPECIALPAGE,
						wfMsg( 'fptc-refresh-frequent-patterns' )
					)
				)
			);
		} else {
			$refreshData = '';
		}

		$wgOut->addHTML(
			$refreshData .
			wfMsg( 'fptc-form-attribute-name' ) .
			' <input type="text" name="fptc_attributeName" id="fptc_attributeName" value="' .
				$defaultAttribute . '"><input type="submit" value="' .
				wfMsg( 'fptc-form-submit-button' ) . '" onclick="fptc_relocate();">'
		);

		$wgOut->addHTML( '<br /><br />' );
	}

	/**
	 * Prints tag cloud for attribute <code>attribute</code> to <code>$wgOut</code>
	 *
	 * @param $attribute String: attribute
	 */
	private function printTagCloud( $attribute ) {
		global $wgOut;

		try {
			$tagCloud = new TagCloud( $attribute );

			// Context menu
			$wgOut->addHTML(
				'<ul id="fptc_contextMenu" class="contextMenu">
					<li class="browse">
						<a href="#browse">' . wfMsg( 'fptc-context-menu-browse' ) . '</a>
					</li>
					<li class="fptc_suggestions separator">
						' . wfMsg( 'fptc-context-menu-similar-tags' ) . '
					</li>
				</ul>'
			);

			// Print tags
			foreach ( $tagCloud->getTags() as $tag ) {
				$this->printTag( $tag, $attribute );
			}

			$wgOut->addHTML( '<div style="clear:both"></div>' );
		} catch ( InvalidAttributeException $e ) {
			if ( $attribute ) {
				// Attribute not found -> show error
				$wgOut->addHTML(
					'<span style="color:red; font-weight:bold;">' .
					wfMsg( 'fptc-invalid-attribute' ) .
					'</span>'
				);
			}
		}
	}

	/**
	 * Prints tag to <code>$wgOut</code>
	 *
	 * @param $tag Tag
	 * @param $attribute
	 */
	private function printTag( Tag $tag, $attribute ) {
		global $wgOut;

		$wgOut->addHTML(
			sprintf(
				'<div class="fptc_tag" style="font-size:%dpx;">%s</div>',
				$this->fontSizeMin + ( $this->fontSizeMax - $this->fontSizeMin ) * $tag->getRate(),
				$attribute == wfMsg( 'fptc-categoryname' )
					? $wgOut->parseInline(
						sprintf(
							'[[:%s:%s|%s]]',
							self::CATEGORY_PAGE,
							$tag->getValue(),
							$tag->getValue()
						)
					)
					: $wgOut->parseInline(
						sprintf(
							'[[:%s:%s/%s/%s|%s]]',
							self::SPECIALPAGE_PREFIX,
							self::ATTRIBUTE_VALUE_INDEX_SPECIALPAGE,
							$attribute,
							$tag->getValue(),
							$tag->getValue()
						)
					)
			)
		);
	}

	/**
	 * Prints the result of the search for attribute <code>attribute</code> to
	 * <code>$wgOut</code>
	 *
	 * @param $attribute String: attribute
	 */
	private function printSearchResult( $attribute ) {
		global $wgOut;

		if ( strlen( $attribute ) ) {
			try {
				$searchResult = new TagCloud( $attribute );

			} catch ( InvalidAttributeException $e ) {

				if ( $attribute ) {
					$proposal = new Proposal( $attribute );
					// Attribute not found -> show attributes that are related
					try {
						// Only if suggestions found
						if ( $proposal->getProposal() ) {
							$wgOut->addHTML( wfMsg( 'fptc-suggestion' ) );
							$wgOut->addHTML( ' ' );
						}

						$w = 1;
						foreach ( $proposal->getProposal() as $possibleAttribute ) {
							$wgOut->addHTML(
								// @todo FIXME: oh hello there XSS
								'<a href=' . $possibleAttribute . '>' .
									$possibleAttribute . '</a>'
							);
							if ( $w < count( $proposal->getProposal() ) ) {
								$wgOut->addHTML( ', ' );
							}
							$w++;
						}

					} catch ( InvalidAttributeException $e ) {
						$wgOut->addHTML( wfMsg( 'fptc-no-suggestion' ) );
					}
					if ( $proposal->getProposal() ) {
						$wgOut->addHTML( '<br /><br />' );
					}
				}
			}
		}
	}
}