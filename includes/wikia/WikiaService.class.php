<?php

/**
 * Nirvana Framework - Service class
 *
 * @ingroup nirvana
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
abstract class WikiaService extends WikiaDispatchableObject {
	final public function allowsExternalRequests(){
		return false;
	}
}
