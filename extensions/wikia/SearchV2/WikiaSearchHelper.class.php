<?php 

class WikiaSearchHelper {
	
	public function formatNumber($num, $decimals=0) {
		return number_format($num, $decimals, wfMsg('wikiasearch2-decimal-point'), wfMsg('wikiasearch2-thousands-separator'));
	}
}