<?php

class ApiFirstEditsHooks {
	/**
	 * Purge API when edit is made
	 *
	 * @param Revision $rev
	 * @param $data
	 * @param $flags
	 * @return bool true to continue hook processing
	 */
	public static function onRevisionInsertComplete( Revision $rev, $data, $flags ): bool {
		Wikia::purgeSurrogateKey( ApiQueryFirstEdits::getSurrogateKey() );
		return true;
	}
}
