
####
# SOME RULES:
#	- Each version of an experiment must have exactly one control group.
#	- Treatment groups can be grown from one version of an experiment to the next, but none of them can shrink. This is to make sure that the data is statistically valid.
#	- Treatment groups can add up to as much as 100%, but will typically be much less (eg: two groups of 4% each). The rest of the users will be untracked but see the control-group experience.
#	- Google Analytics tracking is totally optional for an experiment.
#		- If your experiment is going to be tracked in Google Analytics, you can NOT change treatment_group sizes in-flight. This would give you bad data. You either should switch to using the data warehouse for tracking or create a new experiment with the different sizes (yes, this will require re-coding the js constants & redeploying).
####


####
# Each experiment may have multiple versions because a new version is created each time
# the treatment_groups and percentages of those treatment groups are changed.
#
# To find the actual experiment runtime, use the begin_time of the min(version) and end_time of the max(version)
####
CREATE TABLE `experiments` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`version` int(11) DEFAULT 1,
	
	`name` varchar(255) DEFAULT NULL,
	
	# if this experiment is to be tracked in Google Analytics also, this is the custom var that will hold the treatment_group
	`ga_custom_var` int(11) default null, # will probably be null a lot of the time
	
	`begin_time` datetime DEFAULT NULL,
	`end_time` datetime DEFAULT NULL,
	
	UNIQUE KEY (`id`, `version`),
	UNIQUE KEY (`name`)
);


####
# Each version of an experiement will have one or more treatment groups.
#
# For each version, there should be exactly 1 control group.
####
CREATE TABLE `treatment_groups` (
	`id` int(11) NOT NULL, # the same treatment-group will keep its id across different versions of the same experiment, but the id will only exist for one experiment
	`experiment_id` int(11) NOT NULL,
	`experiment_version` int(11) NOT NULL,

	`name` varchar(255) DEFAULT NULL,

	# TODO: In the future, add this functionality as part of BugzId 31983
	#`js_variable_name` int(11) NOT NULL, # so that we can change the name of the treatment group w/out recoding/redeploying javascript.

	`is_control` tinyint(1) DEFAULT NULL,
	`percentage` tinyint(3) unsigned DEFAULT NULL,

	`ranges` VARCHAR(255) DEFAULT NULL, # the various min/max ranges. this would normally just be one range, but group sizes can be grown mid-experiment

	PRIMARY KEY `tg_experiment_and_version` (`experiment_id`,`experiment_version`, `id`)
);
