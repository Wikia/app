<?php

class WikiaSearchWikiMatch extends WikiDataSource
{
	
	
	public function getResult() {
		global $wgContLang;
		$fields = array();
		$helper = new WikiaHomePageHelper; 
		$data = $helper->getWikiInfoForVisualization( $this->id, $wgContLang->getCode() );
		
		if ( !empty( $data ) ) {
    		
    		$fields['wid'] = $this->id;
    		$fields['title'] = $data['name'];
    		$fields[WikiaSearch::field('title')] = $data['name'];
    		$fields['url'] = $data['url'];
    		
    		$result = F::build( 'WikiaSearchResult', array($fields) );
    		$result->setText( $data['description'] );
		} else {
			//@todo -- grab main page?
			$result = F::build( 'WikiaSearchResult', array($fields) );
		}
		
		
		return $result;
	}
	
}