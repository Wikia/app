ALTER TABLE `translated_content` 
	DROP `is_latest_set`,
	DROP `first_set`,
	DROP `revision_id`;
	
ALTER TABLE `uw_alt_meaningtexts` 
	DROP `is_latest_set`,
	DROP `first_set`,
	DROP `revision_id`;
	
ALTER TABLE `uw_collection_contents` 
	DROP `set_id`,
	DROP `is_latest_set`,
	DROP `first_set`,
	DROP `revision_id`;
	
ALTER TABLE `uw_collection_language`
	DROP `set_id`,
	DROP `is_latest_set`,
	DROP `first_set`,
	DROP `revision_id`;
  
ALTER TABLE `uw_collection_ns`
	DROP `first_ver`,
	DROP `is_latest`;
	
ALTER TABLE `uw_defined_meaning`
	DROP `first_ver`,
	DROP `is_latest_ver`,
	DROP `revision_id`;
	
ALTER TABLE `uw_expression_ns`
	DROP `first_ver`,
	DROP `is_latest`;
	
ALTER TABLE `uw_meaning_relations`
	DROP `set_id`,
	DROP `is_latest_set`,
	DROP `first_set`,
	DROP `revision_id`;
	
ALTER TABLE `uw_syntrans`
	DROP `set_id`,
	DROP `is_latest_set`,
	DROP `first_set`,
	DROP `revision_id`;
	
ALTER TABLE `uw_syntrans_relations`
	DROP `set_id`,
	DROP `is_latest_set`,
	DROP `first_set`,
	DROP `revision_id`;