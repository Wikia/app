<?php
$messages = array();
 
$messages['en'] = array( 
	  'newwikibuilder' => 'New Wiki Builder',
	  "nwb-choose-a-file" => "Please choose a file",
	  "nwb-error-saving-description" => "Error Saving Description",
	  "nwb-error-saving-articles" => "Error Saving Articles",
	  "nwb-error-saving-logo" => "Error Uploading Logo",
	  "nwb-saving-articles" => "Saving Articles...",
	  "nwb-articles-saved" => "Articles Saved",
	  "nwb-theme-saved" => "Theme Choice Saved",
	  "nwb-saving-description" => "Saving Description...",
	  "nwb-description-saved" => "Description Saved",
	  "nwb-uploading-logo" => "Uploading Logo...",
	  "nwb-logo-uploaded" => "Logo Uploaded",
	  "nwb-login-successful" => "Login Successful",
	  "nwb-logout-successful" => "Logout Successful",
	  "nwb-login-error" => "Error logging in",
	  "nwb-logging-in" => "Logging in...",
	  "nwb-api-error" => "There was a problem: ",
	  "nwb-no-more-pages" => "No more pages can be created",
	  "nwb-must-be-logged-in" => "You must be logged in for this action",
	  "nwb-skip-this-step" => "Skip this step",
	  "nwb-coming-soon" => "Coming Soon",
	  "nwb-unable-to-edit-description" => "The description is uneditable with New Wiki Builder"
);

// Note that this variable is referenced in the NewWikiBuilder.html.php file
global $NWBmessages;
$NWBmessages = $messages;
