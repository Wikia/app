<?php
/**
 * Internationalisation file for SpecialUploadLocal extension.
 *
 * @package MediaWiki
 * @subpackage Extensions
*/
$messages = array();

$messages['en'] = array(
	'uploadlocal-desc' => 'Allows users to link in files already on the server',
	'specialuploadlocal' => 'Upload local files',
	'uploadlocal' => 'Upload local files',
	'uploadlocal_directory_readonly' => 'The local upload directory ($1) is not writeable by the webserver.',
	'uploadlocaltext' => 'Use this form to mass upload files already on the server in the upload local directory.
You can find out more general information at [[Special:Upload|the regular upload file page]].',
	'uploadlocalbtn' => 'Upload local files',
	'nolocalfiles' => 'There are no files in the local upload folder. Try placing some files in "<code>$1</code>."',
	'uploadednolocalfiles' => 'You did not upload any files.',
	'allfilessuccessful' => 'All files uploaded successfully',
	'uploadlocalerrors' => 'Some files had errors',
	'allfilessuccessfultext' => 'All files uploaded successfully.
Return to [[{{int:mainpage}}]].',
	'uploadlocal_descriptions_append' => 'Append to description:',
	'uploadlocal_descriptions_prepend' => 'Prepend to description:',
	'uploadlocal_dest_file_append' => 'Append to destination filename:',
	'uploadlocal_dest_file_prepend' => 'Prepend to destination filename: ',
	'uploadlocal_file_list' => 'Files ready for upload',
	'uploadlocal_file_list_explanation' => "'''X''' indicates whether or not you want the file to be uploaded (uncheck to prevent a file from being processed).
'''W''' indicates whether you want the file added to your watchlist.",
	'uploadlocal_global_params' => 'Global parameters',
	'uploadlocal_global_params_explanation' => "What is entered here will automatically get added to the entries listed above.
This helps remove repetitive text such as categories and metadata.
To '''append''' is to add to the end of text, while to '''prepend''' means to add to the beginning of text.
Especially for descriptions, make sure you give a few linebreaks before/after the text.",
		
	'uploadlocal_error_exists' => 'The file $1 already exists.',
	'uploadlocal_error_empty' => 'The file you submitted was empty.',
	'uploadlocal_error_missing' => 'The file is missing an extension.',
	'uploadlocal_error_badtype' => 'This type of file is banned.',
	'uploadlocal_error_tooshort' => 'The filename is too short.',
	'uploadlocal_error_illegal' => 'The filename is not allowed.',
	'uploadlocal_error_overwrite' => 'Overwriting an existing file is not allowed.',
	'uploadlocal_error_verify' => 'This file did not pass file verification: $1.',
	'uploadlocal_error_hook' => 'The modification you tried to make was aborted by an extension hook.',
	'uploadlocal_error_unknown' => 'An unknown error occurred.',
		
	'right-uploadlocal' => 'Upload files from the local machine'
);

