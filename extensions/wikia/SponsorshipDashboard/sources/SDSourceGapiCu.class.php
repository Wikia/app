<?php


/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Googla API source modified to display manual interface. Logic the same as with mother class
 */

class SponsorshipDashboardSourceGapiCu extends SponsorshipDashboardSourceGapi {

	const SD_SOURCE_TYPE = 'GapiCu';

	public function getMenuTemplateLink(){

		return '../../templates/editor/addNewGapiCu';
	}

	public function getSourceKey(){
		return 'GapiCu';
	}

}
