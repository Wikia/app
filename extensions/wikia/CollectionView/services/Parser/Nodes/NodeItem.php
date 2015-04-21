<?php
namespace Wikia\CollectionView\Parser\Nodes;

class NodeItem extends Node {

	public function getData() {
		$node = [];
		$node['description'] = $this->parseWithExternalParser((string) ( $this->xmlNode->{'description'} ), false);
		$node['img'] = $this->resolveImageUrl( $this->getXmlAttribute( $this->xmlNode, 'img' ) );
		$node['link'] = $this->resolveArticleUrl( $this->getXmlAttribute( $this->xmlNode, 'link' ) );
		return $node;
	}

	public function isEmpty( $data ) {
		return !( isset( $data[ 'img' ] ) ) || empty( $data[ 'img' ] );
	}

	protected function resolveImageUrl( $filename ) {
		$title = \Title::newFromText( $filename, NS_FILE );
		if ( $title && $title->exists() ) {
			return \WikiaFileHelper::getFileFromTitle($title)->getUrlGenerator()->url();
		}
		return '';
	}

	protected function resolveArticleUrl( $titleStr ) {
		$title = \Title::newFromText( $titleStr );
		if ( $title && $title->exists() ) {
			return $title->getLocalURL();
		}
		return '';
	}
}
