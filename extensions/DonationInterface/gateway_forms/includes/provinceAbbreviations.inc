<?php

/**
 * Supplies the drop down menu options of Canadian Provinces
 */
function statesMenuXML() {
	$states = array(
		'YY' => 'Select a Province',
		'XX' => 'Outside Canada',
		'AB' => 'Alberta',
		'BC' => 'British Columbia',
		'MB' => 'Manitoba',
		'NB' => 'New Brunswick',
		'NL' => 'Newfoundland and Labrador',
		'NT' => 'Northwest Territories',
		'NS' => 'Nova Scotia',
		'NU' => 'Nunavut',
		'ON' => 'Ontario',
		'PE' => 'Prince Edward Island',
		'QC' => 'Quebec',
		'SK' => 'Saskatchewan',
		'YT' => 'Yukon',
	);
	
	return $states;
}
