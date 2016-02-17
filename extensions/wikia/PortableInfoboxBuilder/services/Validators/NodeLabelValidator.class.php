<?php

namespace Wikia\PortableInfoboxBuilder\Validators;

class NodeLabelValidator extends NodeValidator {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ ];

	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ ];
}
