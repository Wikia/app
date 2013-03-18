<?php
/**
 * Class definition for \Wikia\Search\IndexService\DefaultContent
 * @author relwell
 */
namespace Wikia\Search\IndexService;
use Wikia\Search\Utilities;
/**
 * This is intended to provide core article content
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class DefaultContent extends AbstractService
{
	/**
	 * Returns the fields required to make the document searchable (specifically, wid and title and body content)
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		$pageId = $this->getService()->getCanonicalPageIdFromPageId( $this->currentPageId );

		// we still assume the response is the same format as MediaWiki's
		$response   = $this->getService()->getParseResponseFromPageId( $pageId ); 
		$titleStr   = $this->getService()->getTitleStringFromPageId( $pageId );
		$html       = empty( $response['parse']['text']['*'] ) ? '' : $response['parse']['text']['*'];
		
		$pageFields = [
				'wid'                        => $this->getService()->getWikiId(),
				'pageid'                     => $pageId,
				$this->field( 'title' )      => $titleStr,
				'titleStrict'                => $titleStr,
				'url'                        => $this->getService()->getUrlFromPageId( $pageId ),
				'ns'                         => $this->getService()->getNamespaceFromPageId( $pageId ),
				'host'                       => $this->getService()->getHostName(),
				'lang'                       => $this->getService()->getSimpleLanguageCode(),
				$this->field( 'wikititle' )  => $this->getService()->getGlobal( 'Sitename' ),
				'page_images'                => count( $response['parse']['images'] ),
				'iscontent'                  => $this->getService()->isPageIdContent( $pageId ) ? 'true' : 'false',
				'is_main_page'               => $this->getService()->isPageIdMainPage( $pageId ) ? 'true' : 'false',
				];
		return array_merge( 
				$this->getResultFromHtml( $html ), 
				$this->getCategoriesFromParseResponse( $response ),
				$this->getHeadingsFromParseResponse( $response ),
				$pageFields 
				);
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
	 * @param string $html
	 * @return array
	 */
	protected function getResultFromHtml( $html ) {
		if ( $this->getService()->getGlobal( 'AppStripsHtml' ) ) {
			return $this->prepValuesFromHtml( $html );
		}
		return array( 'html' => html_entity_decode($html, ENT_COMPAT, 'UTF-8') );
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
			$this->extractInfoboxes( $dom, $result );
			$this->removeGarbageFromDom( $dom );
			$plaintext = $this->getPlaintextFromDom( $dom );
			$paragraphs = $this->getParagraphsFromDom( $dom );
		}
		$paragraphString = preg_replace( '/\s+/', ' ', implode( ' ', $paragraphs ) ); // can be empty
		$words = str_word_count( $paragraphString?:$plaintext, 1 );
		$wordCount = count( $words );
		$upTo500Words = implode( ' ', array_slice( $words, 0, min( array( $wordCount, 500 ) ) ) );
		
		return  [
				'nolang_txt'           => $upTo500Words,
				'words'                => $wordCount,
				$this->field( 'html' ) => $plaintext
				];
	}
	
	/**
	 * Assigns infobox-based values to result (passed by reference), when found.
	 * @param simple_html_dom $dom
	 * @param array $result
	 */
	protected function extractInfoboxes( simple_html_dom $dom, array &$result ) {
		$infoboxes = $dom->find( 'table.infobox' );
		if ( count( $infoboxes ) > 0 ) {
			$infobox = $infoboxes[0];
			$infoboxRows = $infobox->find( 'tr' );
			
			if ( $infoboxRows ) {
				foreach ( $infoboxRows as $row ) {
					$infoboxCells = $row->find( 'td' );
					// we only care about key-value pairs in infoboxes
					if ( count( $infoboxCells ) == 2 ) {
						$keyName = preg_replace( '/_+/', '_', sprintf( 'box_%s_txt', strtolower( preg_replace( '/\W+/', '_', $infoboxCells[0]->plaintext ) ) ) );
						$result[$keyName] = preg_replace( '/\s+/', ' ', $infoboxCells[1]->plaintext  );
					}
				}
			}
		}
	}
	
	/**
	 * Iterates through UI remnants and removes them from the dom.
	 * @param simple_html_dom $dom
	 */
	protected function removeGarbageFromDom( simple_html_dom $dom ) {
		// content in these selectors should be removed
		$garbageSelectors  = [
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
		foreach ( $garbageSelectors as $selector ) {
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
	protected function extractTablesFromDom( simple_html_dom $dom ) {
		$plaintext = '';
		foreach( $dom->find( 'table' ) as $table ) {
			$plaintext .= $table->plaintext;
			$table->outertext = ' '; 
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
		$tables = $this->extractTablesFromDom( $dom );
		return preg_replace( '/\s+/', ' ', strip_tags( $dom->plaintext . "\n" . $tables ) );
	}
}