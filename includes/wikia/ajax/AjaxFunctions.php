<?php

$wgAjaxExportList[] = 'GetHubMenu';
function GetHubMenu() {
	$tmpl = new EasyTemplate(dirname(__FILE__).'/templates');
	$tmpl->set_vars(array(
		'categorylist' => DataProvider::getCategoryList()
	));

	$response = new AjaxResponse();
	$response->addText( $tmpl->execute('hubMenu') );
	$response->setCacheDuration( 3600 * 24 * 365 * 10); // 10 years

	return $response;
}
