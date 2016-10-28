<?php


//namespace Wikia\JsonFormat\visitors;


class DivContainingHeadersVisitor extends DOMNodeVisitorBase {

	function __construct( IDOMNodeVisitor $childrenVisitor, JsonFormatBuilder $jsonFormatTraversingState )	{
		parent::__construct( $childrenVisitor, $jsonFormatTraversingState );
		DomHelper::cleanDescendantHeaderInternalCache();
	}

	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		/** @var DOMElement $currentNode */

		if (DomHelper::isElement( $currentNode, 'div' ) ) {
			if( \DomHelper::hasDescendantHeader( $currentNode ) ) {
				return true;
			}

			// this div contains <tabview> tabs
			if( strpos( $currentNode->getAttribute('id'), 'flytab' ) !== false ) {
				return true;
			}

			// this div contains <tabber> tabs
			if( $currentNode->getAttribute('class') == 'tabber' ) {
				return true;
			}

			// each tab of <tabber> tabs - wrapped into div with class 'tabbertab'
			if( $currentNode->getAttribute('class') == 'tabbertab' ) {
				return true;
			}

			// if any descendant divs contains tabs
			$xpath = new DOMXPath( $currentNode->ownerDocument );
			$tabDivs = $xpath->query(".//div[contains(@id, 'flytab')]", $currentNode);
			if( $tabDivs->length > 0 ) {
				return true;
			}

			return false;
		}
		return false;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		if( strpos( $currentNode->getAttribute('id'), 'flytab' ) !== false ) {
			// current div contains <tabview> tabs (ajax tabs)
			// each tab treated as section
			$this->parseTabview( $currentNode );
		} else if( $currentNode->getAttribute('class') == 'tabber' ) {
			// current div contains <tabber> tabs (embedded tabs)
			// each tab treated as section
			$this->parseTabber( $currentNode );
		} else {
			// this is not div with tabs
			// so, we will just visit child nodes
			$this->iterate( $currentNode->childNodes );
		}
	}

	/**
	 * This is div with <tabview> tabs (ajax tabs).
	 * It has following structure:
	 *
	 * <div id="flytabs_0">
	 *      <ul>
	 *          <li class="selected" data-tab="flytabs_00">
	 *              <a href="/wiki/New_Moon?action=render">
	 *                  <span>New Moon</span>
	 *              </a>
	 *          </li>
	 *          <li class="" data-tab="flytabs_01">
	 *              <a href="/wiki/Eclipse?action=render">
	 *                  <span>Eclipse</span>
	 *              </a>
	 *          </li>
	 *      </ul>
	 * </div>
	 *
	 * This structure is the same for all wikia pages, which loading tabs by ajax.
	 *
	 * So, this method is iterating over all links inside this list and parsing
	 * content of corresponding articles (preventing from circular references).
	 *
	 * @param DOMNode $currentNode
	 */
	protected function parseTabview( DOMNode $currentNode ) {
		$xpath = new DOMXPath( $currentNode->ownerDocument );
		$tabs = $xpath->query( ".//a", $currentNode );

		$htmlParser = new Wikia\JsonFormat\HtmlParser();

		foreach ( $tabs as $tab ) {
			$url = $xpath->query( './@href', $tab )->item( 0 );
			$tabTitle = $this->getTabTitle( $xpath, $tab );

			$article = $this->getArticleByUrl( $url );
			if( empty( $article ) ) {
				continue;
			}
			$title = $article->getTitle()->getText();

			// Prevent from cyclic references
			if ( \Wikia\JsonFormat\HtmlParser::isVisited( $title ) ) {
				continue;
			}
			\Wikia\JsonFormat\HtmlParser::markAsVisited( $title );

			$tabSection = $this->parseArticleToSection( $article, $htmlParser, $tabTitle );

			$this->adjustLevel( $tabSection );

			$this->getJsonFormatBuilder()->add( $tabSection );
		}
	}

	protected function getArticleByUrl( $url ) {
		global $wgArticlePath;
		$url = $this->getUrlWithoutPath( $url->value, $wgArticlePath );
		if( empty( $url ) ) {
			return null;
		}
		$title = Title::newFromURL( $url );
		if( $title ) {
			$article = Article::newFromTitle( $title, RequestContext::getMain() );
			return $article;
		} else {
			\Wikia\Logger\WikiaLogger::instance()->info( "TabView with not existing url found.", [ "url" => $url ] );
			return null;
		}
	}

	protected function getUrlWithoutPath( $url, $baseArticlePath ) {
		if( empty( $url ) ) {
			return null;
		}

		if( empty( $baseArticlePath ) || strpos( $baseArticlePath, '$1' ) === false ) {
			return $url;
		}

		// Constructing regexp, using $wgArticlePath, e.g.:
		// "/wiki/$1" -> "/^\/wiki\/(.+?)(\?.*)?$/i"
		// "$1" -> "/^(.+?)(\?.*)?$/i"
		$regexp = '/^' . str_replace( '/', '\/', str_replace( '$1', '(.+?)', $baseArticlePath ) ) . '(\?.*)?$/i';

		// Transforming url, using constructed regexp:
		// "/wiki/Some_Title?action=render" -> "Some_Title"
		$urlWithoutPath = preg_replace( $regexp, '$1', $url );

		return $urlWithoutPath;
	}

	/**
	 * @param $article
	 * @param $htmlParser
	 * @return JsonFormatSectionNode
	 */
	protected function parseArticleToSection( $article, $htmlParser, $tabTitle ) {
		$html = $article->getPage()->getParserOutput( \ParserOptions::newFromContext( new RequestContext() ) )->getText();
		$jsonArticle = $htmlParser->parse( $html );
		$tabSection = new JsonFormatSectionNode( 1, $tabTitle );
		foreach ( $jsonArticle->getChildren() as $child ) {
			$tabSection->addChild( $child );
		}
		return $tabSection;
	}

	/**
	 * From description of the task: PLA-1848
	 *
	 * Tabs should be rendered as ordinary sections with the same level as the section above.
	 * The exception is level 1 which is unique to article title.
	 *
	 * Sections inside the tabview cannot have levels lower or equal than the tabs.
	 * Such sections have to have their level increased to be one higher than the tab.
	 *
	 * This should apply to the whole tree of levels.
	 *
	 * @param $tabSection
	 */
	protected function adjustLevel( $tabSection ) {
		// title has unique level: 1 (unique value of level)
		// so, by default - we have to adjust teb section level by 1
		$level = 1;
		if ( $this->getJsonFormatBuilder()->getCurrentContainer()->getType() === 'section' ) {
			$level = $this->getJsonFormatBuilder()->getCurrentContainer()->getLevel();
		}
		if ( $level > 1 ) {
			$level -= 1;
		}
		$this->addLevel( $tabSection, $level );
	}

	protected function addLevel( $node, $level ) {
		if( property_exists( $node, 'level' ) && method_exists( $node, 'getLevel' ) && method_exists( $node, 'setLevel' ) ) {
			$node->setLevel( $node->getLevel() + $level );
		}
		if( method_exists( $node, 'getChildren' ) ) {
			foreach( $node->getChildren() as $child ) {
				$this->addLevel( $child, $level );
			}
		}
	}

	/**
	 * This is div with <tabber> tabs (embedded tabs).
	 * It has following structure (embedded divs with class "tabbertab"):
	 *
	 * <div class="tabber">
	 *      <div class="tabbertab" title="Title of the tab">
	 *          ...
	 *      </div>
	 *      ...
	 *      <div class="tabbertab" title="Title of the other tab">
	 *          ...
	 *      </div>
	 * </div>
	 *
	 * This structure is the same pages which use <tabber>.
	 *
	 * So, this method treats each tab as a separate section.
	 *
	 * @param DOMNode $currentNode
	 */
	protected function parseTabber( DOMNode $currentNode ) {
		// extracting all divs, which corresponds to embedded tabs
		$xpath = new DOMXPath( $currentNode->ownerDocument );
		$tabNodes = $xpath->query( ".//div[contains(@class, 'tabbertab')]", $currentNode );
		// parse each div, and put into its own section
		foreach ( $tabNodes as $tabNode ) {
			$tabTitle = $tabNode->getAttribute( 'title' );

			$tabSection = new JsonFormatSectionNode( 1, $tabTitle );
			$jsonFormatTraversingState = new \JsonFormatBuilder();
			$jsonFormatTraversingState->pushSection( $tabSection );

			$visitor = ( new \Wikia\JsonFormat\HtmlParser() )->createVisitor( $jsonFormatTraversingState );
			$visitor->visit( $tabNode );

			$this->adjustLevel( $tabSection );
			$this->getJsonFormatBuilder()->add( $tabSection );
		}
	}

	/**
	 * Extracting title from <tabview> tab
	 *
	 * @param $xpath
	 * @param $tab
	 * @return string
	 */
	protected function getTabTitle( $xpath, $tab ) {
		$tabTitleText = $xpath->query( './/text()', $tab );
		$tabTitleTextArr = [ ];
		foreach ( $tabTitleText as $tabTitleTextItem ) {
			$tabTitleTextArr[ ] = trim( $tabTitleTextItem->nodeValue );
		}
		$tabTitle = join( ' ', $tabTitleTextArr );
		$tabTitle = trim( $tabTitle );
		return $tabTitle;
	}
}
