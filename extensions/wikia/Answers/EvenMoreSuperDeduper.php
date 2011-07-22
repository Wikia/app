<?php
/**
 * SuperDeduper powered by solr search backend
 * @author ADi
 */
class EvenMoreSuperDeduper extends SuperDeduper {
	protected function getPotentialMatchesFromMediawiki( $text, $limit ) {
		global $wgEnableWikiaSearchExt;
		$out = array();
		if(!empty($wgEnableWikiaSearchExt)) {
			$resultSet = SolrSearchSet::newFromQuery( $text, 'title' );
			if(($resultSet instanceof SolrSearchSet) && $resultSet->hasResults()) {
				while($result = $resultSet->next()) {
					$out[] = $result->getTitle()->getText();
				}
			}
		}
		return $out;
	}

}