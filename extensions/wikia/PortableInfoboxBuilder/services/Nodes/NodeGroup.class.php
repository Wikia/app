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
	protected $allowedAttributes = [ 'collapse' ];

	public function asJsonObject() {
		$data = $this->getChildrenAsJsonObjects();
		$collapsible = false;

		foreach ( $this->xmlNode->attributes() as $attr => $val ) {
			if ( $attr == 'collapse' ) {
				if ( $val == 'open' ) {
					$collapsible = true;
				}
				break;
			}
		}

		foreach ( $data as $child) {
			if ( $child->type == 'section-header') {
				$child->collapsible = $collapsible;
				break;
			}
		}

		return $data;
	}
}
