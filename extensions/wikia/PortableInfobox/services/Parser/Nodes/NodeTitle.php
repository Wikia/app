<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeTitle extends Node {
	public function getData() {
		if ( !isset( $this->data ) ) {
			$title = $this->sanitizeInfoboxTitle( $this->getValueWithDefault( $this->xmlNode ) );

			$this->data = [ 'value' => $title ];
		}

		return $this->data;
	}

	/**
	 * removes all html tags from title
	 *
	 * @param $title
	 * @return string
	 */
	public function sanitizeInfoboxTitle( $title ) {
		$title = strip_tags( $title );
		$title = trim( $title );

		return $title;
	}
}
