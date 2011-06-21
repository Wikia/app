<?php

/**
 * Nirvana Framework - Service class
 *
 * @ingroup nirvana
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
abstract class WikiaService extends WikiaBaseController {
	public function allowsExternalRequests(){
		return false;
	}
}
