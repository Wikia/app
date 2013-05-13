<?php
/**
 * User: artur
 * Date: 13.05.13
 * Time: 10:39
 */

class RevisionServiceFactory {
	public function get() {
		return new RevisionServiceCacheWrapper( new RevisionService(), 3600);
	}
}
