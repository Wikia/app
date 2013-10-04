<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 12:58
 */

/**
 * Class JsonFormatApiController
 * !! Beta !!
 * simplified representation of wiki article
 */
class JsonFormatApiController extends WikiaApiController {

	const CACHE_EXPIRATION = 14400; //4 hour

	const VARNISH_CACHE_EXPIRATION = 86400; //24 hours

	const SIMPLE_JSON_SCHEMA_VERSION = 1;

	/**
	 * @throws InvalidParameterApiException
	 */
	public function getJsonFormat() {
		$articleId = $this->getRequest()->getInt("article", NULL);
		if( empty($articleId) ) {
			throw new InvalidParameterApiException( self::ARTICLE_CACHE_ID );
		}
		$jsonFormatService = new \JsonFormatService();
		$json = $jsonFormatService->getJsonFormatForArticleId( $articleId );
		//var_dump( $json );
		$this->getResponse()->setVal( "jsonFormat" , $json->toArray() );
	}

	private function toHtml( JsonFormatNode $node ) {
		if( $node->getType() == 'root' )  {
			return $this->iterate( $node );
		} else if ( $node->getType() == 'infobox' ) {
			return "<table style='width: 600px; float: right;'>{$this->iterate( $node )}</table>";
		} else if ( $node->getType() == 'infoboxKeyValue' ) {
			return "<tr><td style='font-weight: bold;'>{$node->getKey()}</td><td>{$this->iterate( $node->getValue() )}</td></tr>";
		}  else if ( $node->getType() == 'section' ) {
			return "<h{$node->getLevel()}>{$node->getTitle()}</h{$node->getLevel()}>{$this->iterate($node)}";
		} else if ( $node->getType() == 'link' ) {
			return "<a href=\"{$node->getUrl()}\">{$node->getText()}</a>";
		} else if ( $node->getType() == 'text' ) {
			return $node->getText();
		} else if ( $node->getType() == 'list' ) {
			$tag = $node->getOrdered() ? 'ol' : 'ul';
			return "<$tag>{$this->iterate( $node )}</$tag>";
		} else if ( $node->getType() == 'listItem' ) {
			return "<li>{$this->iterate( $node )}</li>";
		} else if ( $node->getType() == 'table' ) {
			return "<table>{$this->iterate( $node )}</table>";
		} else if ( $node->getType() == 'tableRow' ) {
			return "<tr>{$this->iterate( $node )}</tr>";
		} else if ( $node->getType() == 'tableCell' ) {
			return "<td>{$this->iterate( $node )}</td>";
		} else if ( $node->getType() == 'paragraph' ) {
			return "<p>{$this->iterate( $node )}</p>";
		} else if ( $node->getType() == 'imageFigure' ) {
			return "<div style=\"\"><img src=\"{$node->getSrc()}\"/></div>";
		} else if ( $node->getType() == 'image' ) {
			return "<img src=\"{$node->getSrc()}\"/>";
		} else if ( $node->getType() == 'quote' ) {
			return "<div><i>{$node->getText()}</i></div><div><i>{$node->getAuthor()}</i></div>";
		}
	}

	private function iterate($node) {
		$result = '';
		foreach ( $node->getChildren() as $childNode ) {
			$result .= $this->toHtml($childNode);
		}
		return $result;
	}

	public function getSimpleJson() {
		$articleId = $this->getRequest()->getInt("article", NULL);
		if( empty($articleId) ) {
			throw new InvalidParameterApiException( self::ARTICLE_CACHE_ID );
		}

	    $cacheKey = wfMemcKey( "SimpleJson:".$articleId, self::SIMPLE_JSON_SCHEMA_VERSION);

	    $jsonSimple = $this->app->wg->memc->get( $cacheKey );

	    if( $jsonSimple===false ){

		    $jsonFormatService = new JsonFormatService();
		    $json = $jsonFormatService->getJsonFormatForArticleId( $articleId );

		    $simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;
		    $jsonSimple = $simplifier->getJsonFormat( $json );

		    $this->app->wg->memc->set( $cacheKey, $jsonSimple, self::CACHE_EXPIRATION );
	    }
		$response = $this->getResponse();
	    $response->setCacheValidity(self::VARNISH_CACHE_EXPIRATION, self::VARNISH_CACHE_EXPIRATION,
		                            [WikiaResponse::CACHE_TARGET_VARNISH,
			                         WikiaResponse::CACHE_TARGET_BROWSER ]);

	    $response->setFormat("json");
	    $response->setData( $jsonSimple );
    }

	private function simpleToHtml( &$json ) {
		$html = "";
		foreach ( $json["sections"] as $section ) {
			$html .= "<h" . $section["level"] . ">";
			$html .= $section["title"];
			$html .= "</h" . $section["level"] . ">";
			foreach( $section["content"] as $contentElement ) {
				if ( $contentElement["type"] == "paragraph" ) {
					$html .= "<p>" . $contentElement["text"] . "</p>";
				}else if ( $contentElement["type"] == "list" ) {
					$html .= "<ul>";
					foreach( $contentElement["elements"] as $liText ) {
						$html .= "<li>" . $liText . "</li>";
					}
					$html .= "</ul>";
				}
			}
			foreach( $section["images"] as $image ) {
				$html .= "<img src=\"${image["src"]}\" style=\"max-width:100px; max-height: 100px; display:inline\"></img>";
			}
		}
		return $html;
	}

	/**
	 * @throws InvalidParameterApiException
	 */
	public function getSimpleAsText() {
		$articleId = $this->getRequest()->getInt("article", NULL);
		if( empty($articleId) ) {
			throw new InvalidParameterApiException( self::ARTICLE_CACHE_ID );
		}
		$jsonFormatService = new JsonFormatService();
		$json = $jsonFormatService->getJsonFormatForArticleId( $articleId );

		$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;
		$jsonSimple = $simplifier->getJsonFormat( $json );

		$text = $this->simpleToHtml($jsonSimple);
		header('Content-Type: text/html; charset=utf-8');
		die($text);
	}

	/**
	 * @throws InvalidParameterApiException
	 */
	public function getJsonFormatAsText() {
		$articleId = $this->getRequest()->getInt("article", NULL);
		if( empty($articleId) ) {
			throw new InvalidParameterApiException( self::ARTICLE_CACHE_ID );
		}
		$jsonFormatService = new JsonFormatService();
		$json = $jsonFormatService->getJsonFormatForArticleId( $articleId );

		$text = $this->toHtml($json);
		header('Content-Type: text/html; charset=utf-8');
		die($text);
	}
}
