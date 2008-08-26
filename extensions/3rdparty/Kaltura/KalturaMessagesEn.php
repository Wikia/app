<?php
/*
This file is part of the Kaltura Collaborative Media Suite which allows users 
to do with audio, video, and animation what Wiki platfroms allow them to do with 
text.

Copyright (C) 2006-2008  Kaltura Inc.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/



$kaltura_messages = array (

// KalturaCollaborativeVideoInfo 
	'kalturacollaborativevideoinfo' => 'Kaltura: Add/Update Collaborative Video' ,
    'kalturacollaborativevideoinfologin' => 'Not logged in' ,
    'kalturacollaborativevideoinfologintext' => 'You have to be logged in to add/update Collaborative Video' ,
	
	"err_title_taken" => "This title is already taken. Please choose another." ,
	"title_add_collaborative" => "Add Collaborative Video" ,
	"title_update_collaborative" => "Update Collaborative Video" ,
	"body_text_add_collaborative" =>
					"<h2>What is this?</h2><br />" .
					"This form enables you to add a collaborative video to any Wiki page.<br/><br/>
A collaborative video is a video started by you or someone else. Anyone with editing permissions can add images, videos and sounds to the collaborative video, or edit it using the full-featured online video editor.<br/><br/>  
The form below enables you to start such a collaborative video.  At the bottom you will get a 'widget code' (this is the code for the video player that you can add to any wiki page). Paste the code in the page where you want to add the collaborative video. Now, anyone with editing permission can add images, videos and sounds to this video and edit it directly from the player that was created. To get the collaborative video started, you are encouraged to add videos, images or sounds to it.<br/><br/>
All further contributions and edits to the collaborative video are done directly from the video player itself on the wiki page.<br/>" ,

	"body_text_add_collaborative_short" =>
					"<h2>What is this?</h2><br />" .
					"A collaborative video is a video started by you or someone else. Anyone with editing permissions can add images, videos and sounds to the collaborative video, 
					or edit it using the full-featured online video editor. The video can appear on any article page as an interactive widget.<br/><br/>  
					You must be logged in to add a collaborative video widget. <br/><br/>
					Click the 'Collaborative Video' link in the toolbox or the button in the editor to get started." ,
					
	"body_text_add_collaborative_instructions" =>					
			"To add a collaborative video:<br/>" .
			"<ul>" .
			"<li>Enter a title and summary</li>" .
			"<li>Select size and position of widget (in relation to surrounding text)</li>" .
			"<li>Click on \"Generate Code\"</li>" .
			"<li>Copy the code that appears, then go to the article page where you want to place the widget. " . 
				"Click on edit in the article page and paste the code anywhere on the page.</li>" .
			"</ul>" .
			"<br/>" .
			"Once the video widget appears in the article page, you can upload and import video/image/audio files to the video and edit them.<br/><br/>" .
			"Try it out! " .
			"<br/>" ,
	"body_text_update_collaborative" => "To update the collaborative video info, modify the title or summary and click \"Update\".",
	 

	"lbl_video_title" => "Video Title:" ,
	"lbl_summary" => "Summary:"  ,
	"lbl_size" => "Size:"  ,
	"lbl_align" => "Align:"  ,
	"btn_txt_generate" => "Generate Tag" ,
	"lbl_widget_tag" => "Widget Tag:" ,
	"btn_txt_cancel" => "Cancel" , 
	"btn_txt_back" => "Back" , 
	"btn_txt_update" => "Update" , 
	"err_no_title" => "You need to specify a title for this Collaborative Video" , 
	"btn_txt_help" => "Help" ,
	
// KalturaAjaxCollaborativeVideoInfo	
	'kalturaajaxcollaborativevideoinfo' => '' ,
    'kalturaajaxcollaborativevideoinfologin' => 'Not logged in' ,
    'kalturacajaxollaborativevideoinfologintext' => 'You have to be logged in to add/update Collaborative Video' ,
    
    'btn_txt_insert_widget_code' => 'Insert in page',
    'btn_txt_generate_tag' => 'Generate Tag',
    "title_add_to_collaborative" => "Add to Collaborative Video" ,
    "body_text_contribution_wizard" => "This is where you can add media (images, videos, audio files) to the collaborative video from various sources.<br>" .
			"Start by selecting the media type you want to add." .
			"<br><br>" ,
					
			
// KalturaContributionWizard    
	'kalturacontributionwizard' => '' ,
	'kalturacontributionwizardlogin' => 'Not logged in' ,
	'kalturacontributionwizardlogintext' => 'You have to be logged in to add to this Collaborative Video' ,

	
	
// KalturaVideoEditor	
	'kalturavideoeditor' => " "  ,
	'kalturavideoeditorlogin' => 'Not logged in' ,
	'kalturavideoeditorlogintext' => 'You have to be logged in to edit this Collaborative Video' ,

	"title_editor" => "Collaborative Video Editor" ,

	
// KalturaTestPage    
	'kalturatestpage' => " " ,
	'kalturavideoeditorlogin' => 'Not logged in' ,
	'kalturavideoeditorlogintext' => 'You have to be logged in to use the test page' ,

// globals 	
	"btn_txt_edit_page" => 'Collaborative Video' , 	
	
// history list
	"alert_txt_revert" => 'Do you want to revert to this version?' ,
	'revert_to_version' => 'revert to this version' , 	
	"lbl_revision" => "Revision as of" ,
	"lbl_tag_code" => "Tag Code" ,
	"lbl_search" => "Search" ,
	"lbl_history" => "History" ,
	"lbl_info" => "Info" ,
	"lbl_version" => "Version" ,

	"new_version" => "*NEW*" ,
		
	"update_article_new" => "New " ,
	"update_article_revert" => "Reverted to version" ,
	"update_article_contrib" => "Contributor" ,
	"update_article_info_change" => "Info change" ,
	"update_article_editor" => "Editor" ,
	
);

$kaltura_objects = array (
	"list_widget_size" => array ( 'L' => 'Large' , 'M' => 'Medium' ) ,
	"list_widget_align" => array ( 'R' => 'Right' , 'C' => 'Center' , 'L' => 'Left' , '_' => 'None' )  ,
	
);
 
?>