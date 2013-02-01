<?php
/**
 * Class definition for \Wikia\Search\IndexService\DefaultContent
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * This is intended to provide core article content
 * @author relwell
 */
class DefaultContent extends AbstractService
{
	/**
	 * Returns the fields required to make the document searchable (specifically, wid and title and body content)
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		
		$pageId = $this->interface->getCanonicalPageIdFromPageId( $this->currentPageId );

		// we still assume the response is the same format as MediaWiki's
		$response = $this->interface->getParseResponseFromPageId( $pageId ); 
		$titleStr = $this->interface->getTitleStringFromPageId( $pageId );
		$html     = empty( $response['parse']['text']['*'] ) ? '' : $response['parse']['text']['*'];

		$categories = array();
		if (! empty( $response['parse']['categories'] ) ) {
			foreach ( $response['parse']['categories'] as $category ) {
				$categories[] = str_replace( '_', ' ', $category['*'] );
			}
		}

		$headings = array();
		if (! empty( $response['parse']['sections'] ) ) {
			foreach( $response['parse']['sections'] as $section ) {
				$headings[] = $section['line'];
			}
		}

		if ( $this->interface->getGlobal( 'AppStripsHtml' ) ) {
			$result = $this->prepValuesFromHtml( $html );
			$titleKey = \WikiaSearch::field( 'title' );
    		$wikiTitleKey = \WikiaSearch::field( 'wikititle' );
    		$categoriesKey = \WikiaSearch::field( 'categories' );
    		$headingsKey = \WikiaSearch::field( 'headings' );
		} else {
			// backwards compatibility
			$result = array( 'html' => html_entity_decode($html, ENT_COMPAT, 'UTF-8') );
			$titleKey = 'title';
    		$wikiTitleKey = 'wikititle';
    		$categoriesKey = 'categories';
    		$headingsKey = 'headings';
		}

		$result['wid']			= $this->interface->getWikiId();
		$result['pageid']		= $pageId;
		$result[$titleKey]		= $titleStr;
		$result['titleStrict']	= $titleStr;
		$result['url']			= $this->interface->getUrlFromPageId( $pageId );
		$result['ns']			= $this->interface->getNamespaceFromPageId( $pageId );
		$result['host']			= substr( $this->interface->getGlobal( 'Server' ), 7);
		$result['lang']			= $this->interface->getSimpleLanguageCode();
		$result[$wikiTitleKey]	= $this->interface->getGlobal( 'Sitename' );
		$result[$categoriesKey]	= $categories;
		$result['page_images']	= count( $response['parse']['images'] );
		$result[$headingsKey]	= $headings;
		
		if (! $this->interface->getGlobal( 'AppStripsHtml' ) ) {
			$result['id'] = $result['wid'] . '_' . $result['pageid'];
		}
	
		# these need to be strictly typed as bool strings since they're passed via http when in the hands of the worker
		$result['iscontent']	= $this->interface->isPageIdContent( $pageId ) ? 'true' : 'false';
	    $result['is_main_page'] = 'false';
		if ( $this->interface->getMainPageArticleId() == $pageId ) {
			$result['is_main_page'] = 'true';
		}
		
		wfProfileOut(__METHOD__);
		return $result;
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
		wfProfileIn(__METHOD__);
		$dom = new \simple_html_dom( html_entity_decode($html, ENT_COMPAT, 'UTF-8') );
		$result = array();
		if ( $dom->root ) {
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
    		
    		// content in these selectors should be removed
    		$garbageSelectors  = array(
    				'span.editsection',
    				'img',
    				'noscript',
    				'div.picture-attribution',
    				'table#toc',
    				'ol.references',
    				'sup.reference',
    				'script',
    				'style',
    				);
    		foreach ( $garbageSelectors as $selector ) {
    			foreach ( $dom->find( $selector ) as $node ) {
    				$node->outertext = ' ';
    			}
    		}
    		
    		$plaintext = '';
    		foreach( $dom->find( 'table' ) as $table ) {
    			$plaintext .= $table->plaintext;
    			$table->outertext = ' '; 
    		}
    		$dom->load( $dom->save() );
    		
    		$paragraphs = array();
    		foreach ( $dom->find( 'p' ) as $pNode ) {
    			$paragraphs[] = $pNode->plaintext;
    		}
    		$plaintext = $dom->plaintext . ' ' . $plaintext;
		} else {
			$plaintext = html_entity_decode( strip_tags( $html ), ENT_COMPAT, 'UTF-8' );
		}
		$plaintext = preg_replace( '/\s+/', ' ', $plaintext );
		
		if (! empty( $paragraphs ) ) {
			$paragraphString = preg_replace( '/\s+/', ' ', implode( ' ', $paragraphs ) );
			// regex for grabbing the first 500 words separate by white space
			$first500 = preg_replace( '/^((\S+ ){0,500}).*$/m', '$1', $paragraphString );
			if ( empty( $first500 ) ) {
				preg_replace( '/^((\S+ ){0,500}).*$/m', '$1', $plaintext );
				$result['nolang_txt'] = $first500;
			}
			$result['words'] = substr_count( $paragraphString, ' ' );
		} else {
			$result['words'] = substr_count( $plaintext, ' ' );
		}

		$result[\WikiaSearch::field( 'html' )] = $plaintext;

		wfProfileOut(__METHOD__);
		return $result;
	}
}