<?php
/**
 * Internationalisation file for Special:DeleteBatch extension.
 *
 * @addtogroup Extensions
 */

$messages = Array();
$messages["en"] = Array(
	'deletebatch' => 'Delete batch of pages',
	'deletebatch_button' => 'DELETE' , /* */
	'deletebatch_help' => 'Delete a batch of pages. You can either perform a single delete, or delete pages listed in a file.  Choose a user that will be shown in deletion logs. Uploaded file should contain page name and optional reason separated by | character in each line.' ,
	'deletebatch_caption' => 'Page list' ,
	'deletebatch_title' => 'Delete Batch' ,
	'deletebatch_link_back' => 'Go back to the special page ' ,
	'deletebatch_as' => 'Run the script as' ,
	'deletebatch_both_modes' => 'Please choose either one specified page or a given list of pages.' ,
	'deletebatch_or' => '<b>OR</b>' ,
	'deletebatch_page' => "Pages to be deleted" ,
	'deletebatch_reason' => 'Reason for deletion' ,
	'deletebatch_processing' => 'deleting pages ' ,
	'deletebatch_from_file' => 'from file list' ,
	'deletebatch_from_form' => 'from form' ,
	'deletebatch_success_subtitle' => 'for $1' ,
	'deletebatch_omitting_nonexistant' => 'Omitting non-existing page $1.' ,
	'deletebatch_omitting_invalid' => 'Omitting invalid page $1.' ,
	'deletebatch_file_bad_format' => 'The file should be plain text' ,
	'deletebatch_file_missing' => 'Unable to read given file' ,
	'deletebatch_select_script' => 'delete page script' ,
	'deletebatch_select_yourself' => 'you' ,
	'deletebatch_no_page' => 'Please specify at least one page to delete OR choose a file containing page list.'
);

$messages["qqq"] = Array(
	'deletebatch_button' => "Make it an irritably big button, on purpose."
);
