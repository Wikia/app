<?php

namespace Wikia\PortableInfoboxBuilder\Validators;

class NodeCaptionValidator extends NodeValidator {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ 'source' ];

	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ ];
}
