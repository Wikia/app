<?php
/**
 * Class definition for \Wikia\Search\IndexService\DefaultContent
 * @author relwell
 */
namespace Wikia\Search\IndexService;
use Wikia\Search\Utilities, simple_html_dom;
/**
 * This is intended to provide core article content
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class DefaultContent extends AbstractService
{
	/**
	 * Text from selectors in this list should be removed during HTML stripping.
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
	 * @var array
	 */
	protected $asideSelectors = [ 'table', 'figure', 'div.noprint', 'div.quote', '.dablink' ];

	/**
	 * Stores multivalued nolang_txt field as we add stuff to it.
	 * @var array
	 */
	protected $nolang_txt = [];

	/**
	 * Returns the fields required to make the document searchable (specifically, wid and title and body content)
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		$service = $this->getService();
		$sitename = $service->getGlobal( 'Sitename' );
		if ( $service->getGlobal( 'BacklinksEnabled' ) ) {
			$service->registerHook( 'LinkEnd', 'Wikia\Search\Hooks', 'onLinkEnd' );
		}
		$service->setGlobal( 'EnableParserCache', false );
		$pageId = $service->getCanonicalPageIdFromPageId( $this->currentPageId );

		// we still assume the response is the same format as MediaWiki's
		$response   = $service->getParseResponseFromPageId( $pageId );

		// ensure the response is an array, even if empty.
		$response   = $response == false ? array() : $response;
		$titleStr   = $service->getTitleStringFromPageId( $pageId );

		$this->pushNolangTxt( $titleStr )
		     ->pushNolangTxt( preg_replace( '/([[:punct:]])/', ' $1 ', $titleStr ) );

		$pageFields = [
				'wid'                        => $service->getWikiId(),
				'pageid'                     => $pageId,
				$this->field( 'title' )      => $titleStr,
				'titleStrict'                => $titleStr,
				'url'                        => $service->getUrlFromPageId( $pageId ),
				'ns'                         => $service->getNamespaceFromPageId( $pageId ),
				'host'                       => $service->getHostName(),
				'lang'                       => $service->getSimpleLanguageCode(),
				$this->field( 'wikititle' )  => $sitename,
				'page_images'                => count( $response['parse']['images'] ),
				'iscontent'                  => $service->isPageIdContent( $pageId ) ? 'true' : 'false',
				'is_main_page'               => $service->isPageIdMainPage( $pageId ) ? 'true' : 'false',
				];
		return array_merge(
				$this->getPageContentFromParseResponse( $response ),
				$this->getCategoriesFromParseResponse( $response ),
				$this->getHeadingsFromParseResponse( $response ),
				$this->getOutboundLinks(),
				$pageFields,
				$this->getNolangTxt()
				);
	}

	/**
	 * @return Wikia\Search\IndexService\DefaultContent
	 */
	protected function reinitialize() {
		$this->nolang_txt = [];
		return $this;
	}

	/**
	 * Provides an array of outbound links from the current document to other doc IDs.
	 * Filters out self-links (e.g. Edit and the like)
	 * @return array
	 */
	protected function getOutboundLinks() {
		$service = $this->getService();
		$result = [];
		$docId = $this->getCurrentDocumentId();
		if ( $service->getGlobal( 'BacklinksEnabled' ) ) {
			$backlinks = (new \Wikia\Search\Hooks)->popLinks();
			$backlinksProcessed = [];
			foreach ( $backlinks as $backlink ) {
				if ( substr_count( $backlink, $docId.' |' ) == 0 ) {
					$backlinksProcessed[] = $backlink;
				}
			}
			$result = [ 'outbound_links_txt' => $backlinksProcessed ];
		}
		return $result;
	}

	/**
	 * Optionally sets language field for field. Old backend already does this.
	 * @param string $field
	 * @return string
	 */
	protected function field( $field ) {
		return $this->getService()->getGlobal( 'AppStripsHtml' ) ? (new Utilities)->field( $field ) : $field;
	}

	/**
	 * Wraps logic for creating the initial result array, based on which implementation we're using.
	 * The old version strips HTML from the backend; the new version strips HTML within the IndexService.
	 * @param array $response
	 * @return array
	 */
	protected function getPageContentFromParseResponse( array $response ) {
		$html = empty( $response['parse']['text']['*'] ) ? '' : $response['parse']['text']['*'];
		if ( $this->getService()->getGlobal( 'AppStripsHtml' ) ) {
			return $this->prepValuesFromHtml( $html );
		}
		return [ 'html' => html_entity_decode($html, ENT_COMPAT, 'UTF-8') ];
	}

	/**
	 * Extracts categories from the MW parse response.
	 * @param array $response
	 * @return array $categories
	 */
	protected function getCategoriesFromParseResponse( array $response ) {
		$categories = array();
		if (! empty( $response['parse']['categories'] ) ) {
			foreach ( $response['parse']['categories'] as $category ) {
				$categories[] = str_replace( '_', ' ', $category['*'] );
			}
		}
		return [ $this->field( 'categories' ) => $categories ];
	}

	/**
	 * Returns an array with section headings for the page.
	 * @param array $response
	 * @return array
	 */
	protected function getHeadingsFromParseResponse( array $response ) {
		$headings = array();
		if (! empty( $response['parse']['sections'] ) ) {
			foreach( $response['parse']['sections'] as $section ) {
				$headings[] = $section['line'];
			}
		}
		return [ $this->field( 'headings' ) => $headings ];
	}

	/**
	 * Add a language-agnostic field value
	 * @param string $txt
	 * @return DefaultContent
	 */
	protected function pushNolangTxt( $txt ) {
		$this->nolang_txt[] = $txt;
		return $this;
	}

	/**
	 * Returns language-agnostic multi-valued text
	 * @return array
	 */
	protected function getNolangTxt() {
		return [ 'nolang_txt' => $this->nolang_txt ];
	}

	/**
	 * Allows us to strip and parse HTML
	 * By the way, if every document on the site was as big as the Jim Henson page,
	 * then it would take under two minutes to parse them all using this function.
	 * So this scales on the application side. I promise. I mathed it.
	 * @param string $html
	 * @return array
	 */
	protected function prepValuesFromHtml( $html ) {
		$result = array();
		$paragraphs = array();
		// default value; we'll overwrite if dom can parse
		$plaintext = preg_replace( '/\s+/', ' ', html_entity_decode( strip_tags( $html ), ENT_COMPAT, 'UTF-8' ) );

		$dom = new \simple_html_dom( html_entity_decode($html, ENT_COMPAT, 'UTF-8') );
		if ( $dom->root ) {
			if ( $this->getService()->getGlobal( 'ExtractInfoboxes' ) ) {
				$result = array_merge( $result, $this->extractInfoboxes( $dom, $result ) );
			}
			$this->removeGarbageFromDom( $dom );
			$plaintext = $this->getPlaintextFromDom( $dom );
			$paragraphs = $this->getParagraphsFromDom( $dom );
		}
		$paragraphString = preg_replace( '/\s+/', ' ', implode( ' ', $paragraphs ) ); // can be empty
		$words = preg_split( '/[[:space:]]+/', $paragraphString?: $plaintext);
		$wordCount = count( $words );
		$upTo100Words = implode( ' ', array_slice( $words, 0, min( array( $wordCount, 100 ) ) ) );
		$this->pushNolangTxt( $upTo100Words );

		return  array_merge( $result,
				[
				'nolang_txt'           => $upTo100Words,
				'words'                => $wordCount,
				$this->field( 'html' ) => $plaintext
				]);
	}

	/**
	 * Assigns infobox-based values to result (passed by reference), when found.
	 * @param simple_html_dom $dom
	 * @return array
	 */
	protected function extractInfoboxes( simple_html_dom $dom ) {
		$result = array();
		$infoboxes = $dom->find( 'table.infobox' );
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
						if ( count( $infoboxCells ) == 2 ) {
							$result['infoboxes_txt'][] = "infobox_{$counter} | " . preg_replace( '/\s+/', ' ', $infoboxCells[0]->plaintext . ' | ' . $infoboxCells[1]->plaintext  );
						}
					}
				}
				$counter++;
			}
		}
		return $result;
	}

	/**
	 * Iterates through UI remnants and removes them from the dom.
	 * Removed type hinting due to testing requirements and WikiaMockProxy
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
	 * @param simple_html_dom $dom
	 * @return string
	 */
	protected function extractAsidesFromDom( simple_html_dom $dom ) {
		$plaintext = '';
		foreach ( $this->asideSelectors as $aside ) {
			foreach( $dom->find( $aside ) as $aside ) {
				$plaintext .= $aside->plaintext;
				$aside->outertext = ' ';
			}
		}
		$dom->load( $dom->save() );
		return $plaintext;
	}

	/**
	 * Returns an array of paragraph text as plaintext
	 * @param simple_html_dom $dom
	 * @return array
	 */
	protected function getParagraphsFromDom( simple_html_dom $dom ) {
		$paragraphs = array();
		foreach ( $dom->find( 'p' ) as $pNode ) {
			$paragraphs[] = $pNode->plaintext;
		}
		return $paragraphs;
	}

	/**
	 * Returns HTML-free article text. Appends any tables to the bottom of the dom.
	 * @param simple_html_dom $dom
	 * @return string
	 */
	protected function getPlaintextFromDom( simple_html_dom $dom ) {
		$tables = $this->extractAsidesFromDom( $dom );
		return preg_replace( '/\s+/', ' ', strip_tags( $dom->plaintext . ' ' . $tables ) );
	}
}
