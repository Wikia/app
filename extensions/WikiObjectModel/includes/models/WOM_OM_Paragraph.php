<?php
/**
 * This model implements Paragraph models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMParagraphModel extends WikiObjectModelCollection {

	public function __construct() {
		parent::__construct( WOM_TYPE_PARAGRAPH );
	}

	public function getWikiText() {
		$pre = $this->getPreviousObject();
		return ( ( $pre != null && ( $pre->getTypeID() == WOM_TYPE_PARAGRAPH ) ) ? "\n\n" : '' ) . $this->getValueText();
	}

	public function getValueText() {
		return parent::getWikiText();
	}
}
