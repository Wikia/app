<?php
/**
 * This model implements Sentence models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMSentenceModel extends WikiObjectModelCollection {

	public function __construct() {
		parent::__construct( WOM_TYPE_SENTENCE );
	}
}
