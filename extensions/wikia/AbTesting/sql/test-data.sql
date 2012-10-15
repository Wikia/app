--
-- Must be run against a newly created database (IDs hardcoded)
--

-- experiments
INSERT INTO ab_experiments(name,description) VALUES
  -- experiment_id = 1
  ('Test experiment','This is a test experiment that does nothing');
-- groups
INSERT INTO ab_experiment_groups(experiment_id,name,description) VALUES
  -- group_id = 1
  (1,'Legacy','Currently used approach'),
  -- group_id = 2
  (1,'Concurrent','Load all assets simultaneously'),
  -- group_id = 3
  (1,'Batches','Load assets in multiple batches');
-- versions
INSERT INTO ab_experiment_versions(experiment_id,start_time,end_time,ga_slot,control_group_id) VALUES
  -- version_id = 1
  (1,'2010-01-01 00:00:00','2013-01-01 00:00:00','1',1),
  -- version_id = 2
  (1,'2013-01-01 00:00:00','2014-01-01 00:00:00','1',1);
-- group_ranges
INSERT INTO ab_experiment_group_ranges(version_id,group_id,ranges) VALUES
  (1,1,'0-4'),
  (1,2,'5-9'),
  (1,3,'10-14'),
  (2,1,'0-4,15-19'),
  (2,2,'5-9,20-24'),
  (2,3,'10-14,25-29');

