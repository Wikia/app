<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 12:58
 */

class JsonFormatApiController extends WikiaApiController {
	public function getJsonFormat() {
		$articleId = $this->getRequest()->getInt("article", NULL);
		if( empty($articleId) ) {
			throw new InvalidParameterApiException( self::ARTICLE_CACHE_ID );
		}
		$jsonFormatService = new JsonFormatService();
		$json = $jsonFormatService->getJsonFormatForArticleId( $articleId );
		//var_dump( $json );
		$this->getResponse()->setVal( "jsonFormat" , $json->toArray() );
	}

	private function toHtml( JsonFormatNode $node ) {
		if( $node->getType() == 'root' ) {
			return $this->iterate( $node );
		} else if ( $node->getType() == 'section' ) {
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
		}
	}

	private function iterate($node) {
		$result = '';
		foreach ( $node->getChildren() as $childNode ) {
			$result .= $this->toHtml($childNode);
		}
		return $result;
	}

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
