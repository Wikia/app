-- Create summary tables for fundraising statistics

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/public_reporting_fundraisers (
	`prf_id` varchar(32) NOT NULL,
	`prf_total` decimal(14,4) unsigned NOT NULL DEFAULT '0.0000',
	`prf_number` int(11) NOT NULL DEFAULT '0',
	`prf_average` decimal(8,4) NOT NULL DEFAULT '0.0000',
	`prf_maximum` decimal(11,4) NOT NULL DEFAULT '0.0000',
	`prf_insert_timestamp` int(10) NOT NULL,
	PRIMARY KEY (prf_id)
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/public_reporting_days (
	`prd_date` date NOT NULL,
	`prd_total` decimal(14,4) unsigned NOT NULL DEFAULT '0.0000',
	`prd_number` int(11) NOT NULL DEFAULT '0',
	`prd_average` decimal(8,4) unsigned NOT NULL DEFAULT '0.0000',
	`prd_maximum` decimal(11,4) unsigned NOT NULL DEFAULT '0.0000',
	`prd_insert_timestamp` int(10) NOT NULL,
	PRIMARY KEY (prd_date)
) /*$wgDBTableOptions*/;
