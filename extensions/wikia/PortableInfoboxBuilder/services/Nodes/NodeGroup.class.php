<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeGroup extends Node {
	const XML_TAG_NAME = 'group';

	/**
	 * @var array string
	 */
	protected $allowedChildNodes = [ 'data', 'header', 'image' ];

	/**
	 * @var array
	 */
	protected $requiredChildNodes = [ 'header' ];


	/**
	 * @var array of string
	 */
	protected $allowedAttributes = [ 'collapse' => [ 'open' ] ];

	public function asJsonObject() {
		$data = $this->getChildrenAsJsonObjects();
		$collapsible = false;

		if ( ( (string)$this->xmlNode[ 'collapse' ] ) === 'open' ) {
			$collapsible = true;
		}

		foreach ( $data as $child ) {
			if ( $child->type == 'section-header' ) {
				$child->collapsible = $collapsible;
				break;
			}
		}

		return $data;
	}
}
