<?php

namespace Wikia\Search\IndexService;

use simple_html_dom;

/**
 * This is intended to provide core article content.
 * It has been copy pasted from DefaultContent.php but allso includes full_html, so that it can be parsed by
 * an article snippet parser.
 *
 * @subpackage IndexService
 */
class FullContent extends AbstractService {
	const SPACE_SEQUENCE_REGEXP = "/\s+/";

	/**
	 * Text from selectors in this list should be removed during HTML stripping.
	 *
	 * @var array
	 */
	protected $garbageSelectors = [
		'span.editsection',
		'img',
		'noscript',
		'div.picture-attribution',
		'table#toc',
		'ol.references',
		'sup.reference',
		'script',
		'style',
	];

	/**
	 * We remove these selectors since they are unreliable indicators of textual content
	 *
	 * @var array
	 */
	protected $asideSelectors = [ 'table', 'figure', 'div.noprint', 'div.quote', '.dablink' ];

	/**
	 * Returns the fields required to make the document searchable (specifically, wid and title and body content)
	 *
	 * @return array
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 */
	public function execute() {
		$service = $this->getService();
		if ( $service->getGlobal( 'BacklinksEnabled' ) ) {
			$service->registerHook( 'LinkEnd', 'Wikia\Search\Hooks', 'onLinkEnd' );
		}
		$service->setGlobal( 'EnableParserCache', false );
		$pageId = $service->getCanonicalPageIdFromPageId( $this->currentPageId );

		// we still assume the response is the same format as MediaWiki's
		$response = $service->getParseResponseFromPageId( $pageId );

		// ensure the response is an array, even if empty.
		$response = empty( $response ) ? [] : $response;
		$titleStr = $service->getTitleStringFromPageId( $pageId );

		return array_merge( $this->getPageContentFromParseResponse( $response ), [
			'wid' => $service->getWikiId(),
			'pageid' => $pageId,
			'title' => $titleStr,
			'redirect_titles' => $service->getRedirectTitlesForPageId( $pageId ),
			'url' => $service->getUrlFromPageId( $pageId ),
			'ns' => $service->getNamespaceFromPageId( $pageId ),
			'lang' => $service->getSimpleLanguageCode(),
			'iscontent' => $service->isPageIdContent( $pageId ) ? 'true' : 'false',
			'is_main_page' => $service->isPageIdMainPage( $pageId ) ? 'true' : 'false'
		] );
	}

	/**
	 * Wraps logic for creating the initial result array, based on which implementation we're using.
	 * The old version strips HTML from the backend; the new version strips HTML within the IndexService.
	 *
	 * @param array $response
	 *
	 * @return array
	 */
	protected function getPageContentFromParseResponse( array $response ) {
		$html = empty( $response['parse']['text']['*'] ) ? '' : $response['parse']['text']['*'];
		if ( $this->getService()->getGlobal( 'AppStripsHtml' ) ) {
			return $this->prepValuesFromHtml( $html );
		}

		return [
			'html' => html_entity_decode( $html, ENT_COMPAT, 'UTF-8' ),
		];
	}

	/**
	 * Returns an array with section headings for the page.
	 *
	 * @param array $response
	 *
	 * @return array
	 */
	protected function getHeadingsFromParseResponse( array $response ) {
		$headings = [];
		if ( !empty( $response['parse']['sections'] ) ) {
			foreach ( $response['parse']['sections'] as $section ) {
				$headings[] = $section['line'];
			}
		}

		return [ 'headings' => $headings ];
	}

	/**
	 * Allows us to strip and parse HTML
	 * By the way, if every document on the site was as big as the Jim Henson page,
	 * then it would take under two minutes to parse them all using this function.
	 * So this scales on the application side. I promise. I mathed it.
	 *
	 * @param string $html
	 *
	 * @return array
	 */

	protected function prepValuesFromHtml( $html ) {
		$result = [];
		// workaround for bug in html_entity_decode that truncates the text
		$html = str_replace( [ "&lt;", "&gt;" ], "", $html );

		$dom = new \simple_html_dom( html_entity_decode( $html, ENT_COMPAT, 'UTF-8' ) );
		if ( $dom->root ) {
			if ( $this->getService()->getGlobal( 'ExtractInfoboxes' ) ) {
				$result = array_merge( $result, $this->extractInfoboxes( $dom ) );
			}
			$this->removeGarbageFromDom( $dom );
			$plaintext = $this->getPlaintextFromDom( $dom );
		} else {
			$plaintext = html_entity_decode( strip_tags( $html ), ENT_COMPAT, 'UTF-8' );
		}
		$plaintext = trim( preg_replace( static::SPACE_SEQUENCE_REGEXP, ' ', $plaintext ) );

		return array_merge( $result, [
			'full_html' => html_entity_decode( $html, ENT_COMPAT, 'UTF-8' ),
			'html' => $plaintext,
		] );
	}

	/**
	 * Assigns infobox-based values to result (passed by reference), when found.
	 *
	 * @param simple_html_dom $dom
	 *
	 * @return array
	 */
	protected function extractInfoboxes( simple_html_dom $dom ) {
		$result = [];
		$infoboxes = $dom->find( 'table.infobox,table.wikia-infobox' );
		if ( count( $infoboxes ) > 0 ) {
			$result['infoboxes_txt'] = [];
			$counter = 1;
			foreach ( $infoboxes as $infobox ) {
				$outerText = $infobox->outertext();
				$infobox = new simple_html_dom( $outerText );
				$this->removeGarbageFromDom( $infobox );
				$infobox->load( $infobox->save() );
				$infoboxRows = $infobox->find( 'tr' );
				if ( $infoboxRows ) {
					foreach ( $infoboxRows as $row ) {
						$infoboxCells = $row->find( 'td' );
						$headerCells = $row->find( 'th' );
						$infoBoxCellCount = count( $infoboxCells );
						$headerCellCount = count( $headerCells );
						if ( $infoBoxCellCount == 2 && $headerCellCount == 0 ) {
							$result['infoboxes_txt'][] =
								"infobox_{$counter} | " . preg_replace( '/\s+/', ' ',
									$infoboxCells[0]->plaintext . ' | ' .
									$infoboxCells[1]->plaintext );
						} else {
							if ( $infoBoxCellCount == 1 && $headerCellCount == 1 ) {
								$result['infoboxes_txt'][] =
									"infobox_{$counter} | " . preg_replace( '/\s+/', ' ',
										$headerCells[0]->plaintext . ' | ' .
										$infoboxCells[0]->plaintext );
							}
						}
					}
				}
				$counter ++;
			}
		}

		return $result;
	}

	/**
	 * Iterates through UI remnants and removes them from the dom.
	 * Removed type hinting due to testing requirements and WikiaMockProxy
	 *
	 * @param simple_html_dom $dom
	 */
	protected function removeGarbageFromDom( $dom ) {
		foreach ( $this->garbageSelectors as $selector ) {
			foreach ( $dom->find( $selector ) as $node ) {
				$node->outertext = ' ';
			}
		}
	}

	/**
	 * Returns all text from tables as plaintext, and then removes them.
	 *
	 * @param simple_html_dom $dom
	 *
	 * @return string
	 */
	protected function extractAsidesFromDom( simple_html_dom $dom ) {
		$plaintext = '';
		foreach ( $this->asideSelectors as $aside ) {
			foreach ( $dom->find( $aside ) as $a ) {
				$plaintext .= $a->plaintext;
				$a->outertext = ' ';
			}
		}
		$dom->load( $dom->save() );

		return $plaintext;
	}

	/**
	 * Returns an array of paragraph text as plaintext
	 *
	 * @param simple_html_dom $dom
	 *
	 * @return array
	 */
	protected function getParagraphsFromDom( simple_html_dom $dom ) {
		$paragraphs = [];
		foreach ( $dom->find( 'p' ) as $pNode ) {
			$paragraphs[] = $pNode->plaintext;
		}

		return $paragraphs;
	}

	/**
	 * Returns HTML-free article text. Appends any tables to the bottom of the dom.
	 *
	 * @param simple_html_dom $dom
	 *
	 * @return string
	 */
	protected function getPlaintextFromDom( simple_html_dom $dom ) {
		$tables = $this->extractAsidesFromDom( $dom );

		return preg_replace( '/\s+/', ' ', strip_tags( $dom->plaintext . ' ' . $tables ) );
	}

}
