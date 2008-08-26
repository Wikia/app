--
--Add new DefinedMeaning namespace
--

Set @newNameSpaceId=
(
SELECT max(ns_id)+1 FROM namespace
);

INSERT INTO `namespace` ( `ns_id` , `ns_system` , `ns_subpages` , `ns_search_default` , `ns_target` , `ns_parent` , `ns_hidden` , `ns_schema` )
VALUES (
@newNameSpaceId, NULL , '0', '0', '', NULL , '0', 'DefinedMeaning'
); 

INSERT INTO `namespace_names` ( `ns_id` , `ns_name` , `ns_default` , `ns_canonical` )
VALUES (
@newNameSpaceId, 'DefinedMeaning', '1', '0'
);

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '11 - Add DefinedMeaning namespace.sql'); 