<?php
function efWikiaVideo() {

	return array(
	
	'en' => array(
	'videologpage' => 'Video log',
	'videologpagetext' => 'This is a log of videos',
	'videologentry' => '',
	'category-video-header' => 'Videos in category "$1"',
	'category-video-count' => 'There are $1 videos in this category.',
	'novideo-linktext' => 'add it',
	'novideo' => 'No video by this name exists, you add a video $1.',
	'video_embed' => 'Embed',
	'video_addvideo_title' => 'Add Video',
	'video-addvideo_button' => 'Add Video',
	'video_addvideo_instructions' => "Adding a video to {{SITENAME}} is easy.  Just paste the video embed code ''or'' the video's URL into the following form, add a name for the video, and press the add video button.  If you want to embed the video on a page use the following format: '''<nowiki>[[Video:Video Title]]</nowiki>'''.\nYou can add a video from: [http://www.youtube.com YouTube], [http://vids.myspace.com/ MySpaceTV], [http://video.google.com/ Google Video], and [http://www.metacafe.com Metacafe].\n===Example of a Video Embed Code===\nThis is an example video embed code from YouTube:\n\n<pre style=\"background-color:#F9F9F9;border:1px dashed #2F6FAB;color:black;line-height:1.1em;padding:1em;\"><nowiki><object width=\"425\" height=\"355\">\n<param name=\"movie\" value=\"http://www.youtube.com/v/hUcFWPgB8oY\"></param>\n<param name=\"wmode\" value=\"transparent\"></param>\n<embed src=\"http://www.youtube.com/v/hUcFWPgB8oY\" type=\"application/x-shockwave-flash\"\nwmode=\"transparent\" width=\"425\" height=\"355\"></embed>\n</object></nowiki></pre>\n\n===Example of a Video URL===\nBelow is an example of a video's URL from YouTube: <pre style=\"background-color:#F9F9F9;border:1px dashed #2F6FAB;color:black;line-height:1.1em;padding:1em;\">http://www.youtube.com/watch?v=hUcFWPgB8oY</pre>	
	
	", 
	'video_addvideo_invalidcode' => 'The code or URL you pasted is invalid.  Please try again.', 
	'video_addvideo_exists' => 'The title for your video already exists.  Please choose another title for the video.',
	'video_addvideo_title_label' => 'Video Title:',
	'video_addvideo_embed_label' => 'Embed Code or Url:', 
	'video_history' => 'Video History',
	'video_revert' => 'rev',
	'video_histlegend' => 'Legend: (cur) = this is the current video, (rev) = revert to this old version.
				<br /><i>Click on date to see the video url on that date</i>.',
	'video_revert_success' => 'Revert to earlier version was successful.',
	'video_list_header' => 'To view list in gallery form, go to ',	
	'video_gallery' => 'video gallery.',
	'video_gallery_header' => 'To view gallery in list form, go to ',
	'video_list' => 'video list.',
	'video_gallery_return' => 'Return to main ',
	'video_log_entry' => 'added "[[$1]]"'
 
	),
	); 
}

?>
