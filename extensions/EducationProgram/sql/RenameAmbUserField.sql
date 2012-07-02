-- MySQL for the Education Program extension.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

ALTER TABLE /*_*/ep_cas_per_course CHANGE `cpc_ca_id` `cpc_user_id` INT( 10 ) UNSIGNED NOT NULL;
ALTER TABLE /*_*/ep_oas_per_course CHANGE `opc_oa_id` `opc_user_id` INT( 10 ) UNSIGNED NOT NULL;