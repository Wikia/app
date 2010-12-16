--
-- Information on available test suites
DROP TABLE IF EXISTS /*$wgDBprefix*/code_test_suite;
CREATE TABLE /*$wgDBprefix*/code_test_suite (
  -- Unique ID per test suite
  ctsuite_id int auto_increment not null,
  
  -- Repository ID of the code base this applies to
  ctsuite_repo_id int not null,
  
  -- Which branch path this applies to, eg '/trunk/phase3'
  ctsuite_branch_path varchar(255) not null,
  
  -- Pleasantly user-readable name, eg "ParserTests"
  ctsuite_name varchar(255) not null,
  
  -- Description...
  ctsuite_desc varchar(255) not null,
  
  primary key ctsuite_id (ctsuite_id)
) /*$wgDBtableOptions*/;

DROP TABLE IF EXISTS /*$wgDBprefix*/code_test_case;
CREATE TABLE /*$wgDBprefix*/code_test_case (
  ctcase_id int auto_increment not null,
  ctcase_suite_id int not null,
  ctcase_name varchar(255) not null,
  
  primary key ctc_id (ctcase_id),
  key (ctcase_suite_id, ctcase_id)
) /*$wgDBtableOptions*/;

DROP TABLE IF EXISTS /*$wgDBprefix*/code_test_run;
CREATE TABLE /*$wgDBprefix*/code_test_run (
  ctrun_id int auto_increment not null,
  
  ctrun_suite_id int not null,
  ctrun_rev_id int not null,
  
  ctrun_status enum ('running', 'complete', 'abort'),
  
  ctrun_count_total int,
  ctrun_count_success int,
  
  primary key ctrun_id (ctrun_id),
  key suite_rev (ctrun_suite_id, ctrun_rev_id)
) /*$wgDBtableOptions*/;


DROP TABLE IF EXISTS /*$wgDBprefix*/code_test_result;
CREATE TABLE /*$wgDBprefix*/code_test_result (
  ctresult_id int auto_increment not null,
  
  -- Which test run and case are we on?
  ctresult_run_id int not null,
  ctresult_case_id int not null,
  
  -- Did we succeed or fail?
  ctresult_success bool not null,
  
  -- Optional HTML chunk data
  ctresult_details blob,
  
  primary key ctr_id (ctresult_id),
  key run_id (ctresult_run_id, ctresult_id)
) /*$wgDBtableOptions*/;
