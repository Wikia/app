<?php

namespace Wikia\PortableInfoboxBuilder\Validators;

class NodeInfoboxValidator extends NodeValidator {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ ];

	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ 'data', 'image', 'title' ];

}
