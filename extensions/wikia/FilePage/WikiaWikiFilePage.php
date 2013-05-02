<?php
/**
 * Special handling for file pages
 *
 * @ingroup Media
 */
class WikiaWikiFilePage extends WikiFilePage {

	/**
	 * @return array|null
	 *
	 * @todo Fix this so it works again.
	 * This has changed with MW1.19 so we need to re-fix this issue
	 * Original ticket: https://wikia.fogbugz.com/default.asp?26737
	 * Currently broken in places like this: http://glee.wikia.com/wiki/File:Glee_Sugar%27s_Audition-3x01
	 *
	 */
   	public function getDuplicates() {
		/*wfProfileIn( __METHOD__ );
		$img =  $this->getDisplayedFile();
		$handler = $img->getHandler();
		if ( $handler instanceof VideoHandler && $handler->isBroken() ) {
			$res = $this->dupes = array();
		} else {
			$dupes = parent::getDuplicates();
			$finalDupes = array();
			foreach( $dupes as $dupe ) {
		                if ( WikiaFileHelper::isFileTypeVideo( $dupe ) && $dupe instanceof WikiaLocalFile ) {
		                    if ( $dupe->getProviderName() != $img->getProviderName() ) continue;
		                    if ( $dupe->getVideoId() != $img->getVideoId() ) continue;
		                    $finalDupes[] = $dupe;
		                }
			}
			$res = $finalDupes;
		}
		wfProfileOut( __METHOD__ );
		return $res;*/

		return parent::getDuplicates();
	}
}
