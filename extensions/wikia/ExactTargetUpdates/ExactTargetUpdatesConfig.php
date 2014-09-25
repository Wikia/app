<?php

class ExactTargetUpdatesConfig {
	/* ExactTarget's Customer Keys - public names of tables */
	const EXACTTARGET_CK_PROD = [
		'user' => 'user',
		'user_properties' => 'user_properties',
		'city_list' => 'city_list',
		'city_cat_mapping' => 'city_cat_mapping',
	];

	/* Development mode Customer Keys */
	const EXACTTARGET_CK_DEV = [
		'user' => 'user_dev',
		'user_properties' => 'user_properties_dev',
		'city_list' => 'city_list_dev',
		'city_cat_mapping' => 'city_cat_mapping_dev',
	];

	/* List of variables that trigger an update when changed */
	const EXACTTARGET_UPDATE_WF_VARS = [ 
		'wgServer',
		'wgSitename',
	];
}
