<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
$messages = array();

$messages['en'] = array(
     'playerstatsgrabber' => 'Player stats survey',
	'ps_take_video_survey' => 'Video playback survey',
	'ps_survey_description' => 'This survey will help improve support for rich media.
Please answer the following questions:',
	'ps_could_play' => 'When you clicked "play", did the video playback perfectly with audio?',
	'ps_play_yes' => 'Yes, the clip played perfectly',
	'ps_play_no' => 'No, there were issues or it did not play',

	'ps_problem_checkoff' => 'Please mark any of the following problems if they occurred:',

	'ps_no_video' => 'No video played back at all',
	'ps_jumpy_playback' => ' Jumping playback (the video played, then paused, then played)',
	'ps_no_sound' => 'No audio (my computer volume is on, but I hear no audio for this video)',
	'ps_bad_sync' => 'Audio was out of sync with the video',

	'ps_problems_desc' => 'Please describe any additional issues below (optional):',

	'ps_would_install' => 'Would you install an additional plug-in to view videos on this wiki?',
	'ps_no_install' => 'No, I would not install an additional plug-in',
	'ps_yes_install' => 'Yes, I would install an additional plug-in',

	'ps_would_switch' => 'You appear to be running Internet Explorer.
Would you consider installing a different browser to improve your media experience on this wiki?',
	'ps_yes_switch' => 'Yes, I would switch browsers',
	'ps_no_switch' => 'No, I would not switch browsers',

	'ps_your_email' => 'Your email address (optional)',
	'ps_submit_survey' => 'Submit survey',
	'ps_privacy' => 'Privacy policy: The data collected here will be used to improve video and audio playback on Wikimedia Foundation projects.
Only aggregate data will be published, and no personally identifiable information will be shared with any third party, ever.
If you provide an e-mail address, we may contact you for further information on any problems you have experienced.',
	'ps_thanks' => 'Thank you for participating in this video survey',
	'ps_only_one_survey_pp' => 'Only one survey per user is currently accepted',
	'ps_stats_welcome_link' => 'Statistics will be reported here once the survey is complete.<br />
Please [[Special:PlayerStatsGrabber/Survey|take the suvey]] (if you have not already taken it).'
);
