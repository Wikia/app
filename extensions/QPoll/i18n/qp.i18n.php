<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 *
 * @file
 * @version 0.8.0a
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 * @ingroup Extensions
 */

/**
 * Messages list.
 */

$messages = array();

/** English (English)
 * @author QuestPC
 */
$messages['en'] = array(
	'pollresults' => 'Results of the polls on this site',
	'qpollwebinstall' => 'Installation / update of QPoll extension',
	'qp_parentheses' => '($1)',
	'qp_full_category_name' => '$1($2)',
	'qp_desc' => 'Allows creation of polls',
	'qp_desc-sp' => '[[Special:PollResults|Special page]] for viewing results of the polls',
	'qp_result_NA' => 'Not answered',
	'qp_result_error' => 'Syntax error',
	'qp_vote_button' => 'Vote',
	'qp_vote_again_button' => 'Change your vote',
	'qp_submit_attempts_left' => '$1 {{PLURAL:$1|attempt|attempts}} left',
	'qp_polls_list' => 'List all polls',
	'qp_users_list' => 'List all users',
	'qp_browse_to_poll' => 'Browse to $1',
	'qp_browse_to_user' => 'Browse to $1',
	'qp_browse_to_interpretation' => 'Browse to $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|vote|votes}}',
	'qp_source_link' => 'Source',
	'qp_stats_link' => 'Statistics',
	'qp_users_link' => 'Users',
	'qp_voice_link' => 'User voice',
	'qp_voice_link_inv' => 'User voice?',
	'qp_user_polls_link' => 'Participated in $1 {{PLURAL:$1|poll|polls}}', // Supports use of GENDER with $2
	'qp_user_missing_polls_link' => 'No participation', // Supports use of GENDER with $1
	'qp_not_participated_link' => 'Not participated',
	'qp_order_by_username' => 'Order by username',
	'qp_order_by_polls_count' => 'Order by polls count',
	'qp_results_line_qupl' => 'Page "$1" Poll "$2": $3',
	'qp_results_line_qpl' => 'Page "$1" Poll "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Page "$2" Poll "$3" ]',
	'qp_results_line_qpul' => '$1: $2',
	'qp_header_line_qucl' => '$1. $2<br />$3 ??? $4',
	'qp_results_line_qucl' => '$1: $2 $3',
	'qp_results_submit_attempts' => 'Submit attempts: $1',
	'qp_results_interpretation_header' => 'Answer interpretation',
	'qp_results_short_interpretation' => 'Short interpretation',
	'qp_results_long_interpretation' => 'Long interpretation',
	'qp_results_structured_interpretation' => 'Structured interpretation',
	'qp_poll_has_no_interpretation' => 'This poll has no interpretation template defined in the poll\'s header.',
	'qp_interpetation_wrong_answer' => 'Wrong answer',
	'qp_export_to_xls' => 'Export statistics into XLS format',
	'qp_voices_to_xls' => 'Export voices into XLS format',
	'qp_interpretation_results_to_xls' => 'Export answer interpretations into XLS format',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|user|users}} answered to the questions',
	'qp_func_no_such_poll' => 'No such poll ($1)',
	'qp_func_missing_question_id' => 'Please specify an existing question id (starting from 1) for the poll $1.',
	'qp_func_invalid_question_id' => 'Invalid question id=$2 (not a number) for the poll $1.',
	'qp_func_missing_proposal_id' => 'Please specify an existing proposal id (starting from 0) for the poll $1, question $2.',
	'qp_func_invalid_proposal_id' => 'Invalid proposal id=$3 (not a number) for the poll $1, question $2.',
	'qp_error_no_such_poll' => 'No such poll ($1).
Make sure that the poll declared and saved, also be sure to use address delimiter character #.',
	'qp_error_in_question_header' => 'Invalid question header: $1.',
	'qp_error_id_in_stats_mode' => 'Cannot declare an ID of the poll in statistical mode.',
	'qp_error_dependance_in_stats_mode' => 'Cannot declare dependance chain of the poll in statistical mode.',
	'qp_error_no_stats' => 'No statistical data is available, because no one has voted for this poll, yet (address=$1).',
	'qp_error_address_in_decl_mode' => 'Cannot get an address of the poll in declaration mode.',
	'qp_error_question_not_implemented' => 'Questions of such type are not implemented: $1.',
	'qp_error_question_empty_body' => 'Question body is empty.',
	'qp_error_question_no_proposals' => 'Question does not have any proposals defined.',
	'qp_error_invalid_question_type' => 'Invalid question type: $1.',
	'qp_error_invalid_question_name' => 'Invalid question name: $1.',
	'qp_error_type_in_stats_mode' => 'Question type cannot be defined in statistical display mode: $1.',
	'qp_error_no_poll_id'	=> 'Poll tag has no id attribute defined.',
	'qp_error_invalid_poll_id' => 'Invalid poll id (id=$1).
Poll id may contain only letters, numbers and space character.',
	'qp_error_already_used_poll_id' => 'The poll id has already been used on this page (id=$1).',
	'qp_error_too_long_dependance_value' => 'The poll (id=$1) dependance attribute value (dependance="$2") is too long to be stored in database.',
	'qp_error_invalid_dependance_value' => 'The poll (id=$1) dependance chain has invalid value of dependance attribute (dependance="$2").',
	'qp_error_missed_dependance_title' => 'The poll (id=$1) is dependant on the another poll (id=$3) from page [[$2]], but the title [[$2]] was not found.
Either remove the dependance attribute, or restore [[$2]].',
	'qp_error_missed_dependance_poll' => 'The poll (id=$1) is dependant on the another poll (id=$3) at page $2, but that poll does not exists or has not been saved yet.
Either remove the dependance attribute, or create the poll with id=$3 at the page $2 and save it.
To save a poll, submit it while not answering to any proposal questions.',
	'qp_error_vote_dependance_poll' => 'Please vote for poll $1 first.',
	'qp_error_too_many_spans' => 'Too many category groups for the total number of subcategories defined.',
	'qp_error_unanswered_span' => 'Unanswered subcategory.',
	'qp_error_non_unique_choice' => 'This question requires unique proposal answer.',
	'qp_error_category_name_empty' => 'Category name is empty.',
	'qp_error_proposal_text_empty' => 'Proposal text is empty.',
	'qp_error_too_long_category_option_value' => 'Category option value is too long to be stored in the database.',
	'qp_error_too_long_category_options_values' => 'Category options values are too long to be stored in the database.',
	'qp_error_too_long_proposal_text' => 'Proposal text is too long to be stored in the database.',
	'qp_error_too_long_proposal_name' => 'Proposal name is too long to be stored in the database.',
	'qp_error_multiline_proposal_name' => 'Proposal name cannot contain multiple text lines.',
	'qp_error_numeric_proposal_name' => 'Proposal name cannot be numeric.',
	'qp_error_too_few_categories' => 'At least two categories must be defined.',
	'qp_error_too_few_spans' => 'Every category group must contain at least two subcategories.',
	'qp_error_no_answer' => 'Unanswered proposal.',
	'qp_error_not_enough_categories_answered' => 'Not enough categories selected.',
	'qp_error_unique' => 'Question of type unique() has more proposals than possible answers defined: Impossible to complete.',
	'qp_error_no_more_attempts' => 'You have reached maximal number of submitting attempts for this poll.',
	'qp_error_no_interpretation' => 'Interpretation script does not exist.',
	'qp_error_interpretation_no_return' => 'Interpretation script returned no result.',
	'qp_error_structured_interpretation_is_too_long' => 'Structured interpretation is too long to be stored in database. Please correct your interpretation script.',
	'qp_error_no_json_decode' => 'Interpretation of poll answers requires json_decode() PHP function.',
	'qp_error_eval_missed_lang_attr' => 'XML attribute "lang" is required to choose proper interpretation language.',
	'qp_error_eval_mix_languages' => 'Single interpretation script cannot mix different interpretation languages: "$1", "$2".',
	'qp_error_eval_unsupported_language' => 'Unsupported interpretation language "$1".',
	'qp_error_eval_illegal_token' => 'PHP token $1 with value $2 is not allowed in line $3.',
	'qp_error_eval_illegal_superglobal' => 'PHP token $1 with superglobal $2 is not allowed in line $3.',
	'qp_error_eval_illegal_function_call' => 'PHP token $1 with function $2 is not allowed in line $3.',
	'qp_error_eval_variable_variable_access' => 'PHP token $1 with variable variable $2 is not allowed in line $3.',
	'qp_error_eval_illegal_variable_name' => 'PHP token $1 has disallowed variable name $2 in line $3.',
	'qp_error_eval_variable_function_call' => 'PHP token $1 with variable function $2 is not allowed in line $3.',
	'qp_error_eval_self_check' => 'The following eval() self-check has failed: $1. You have unsupported version of PHP, which does not allow to run eval scripts securely.',
	'qp_error_eval_unable_to_lint' => 'Unable to lint. Check your system configuration.',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Hamilton Abreu
 * @author IAlex
 * @author Kghbln
 * @author McDutchie
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'pollresults' => 'Special page name in [[Special:SpecialPages]]',
	'qpollwebinstall' => 'Special page name in [[Special:SpecialPages]]',
	'qp_parentheses' => '{{optional}}',
	'qp_full_category_name' => '{{optional}}',
	'qp_desc' => '{{desc}} Important notice: Categories can be grouped into category groups, which are internally referred as "spans". Such grouped categories become "subcategories". While the extension evolved, these groups were consequentially called as "spans", "metacategories", "category groups". Please read the on-line documentation carefully before translating.',
	'qp_desc-sp' => "Description of extension's special page at Special:Version page.",
	'qp_result_NA' => '{{Identical|Not answered}}',
	'qp_result_error' => '{{Identical|Syntax error}}',
	'qp_vote_button' => '{{Identical|Vote}}',
	'qp_vote_again_button' => 'When the user already submitted the poll / quiz, text of submit button title changes to indicate that the data will be re-submitted again.',
	'qp_submit_attempts_left' => 'How many attempts of poll / quiz submissions are left to the current user.',
	'qp_polls_list' => 'A link title in the header of [[Special:Pollresults]] which displays list of polls at current wiki site.',
	'qp_users_list' => 'A link title in the header of [[Special:Pollresults]] which displays list of poll participants at current wiki site.',
	'qp_browse_to_poll' => 'A link title at [[Special:Pollresults]] which opens wiki page where the selected poll was defined.',
	'qp_browse_to_user' => "A link title at [[Special:Pollresults]] which opens user page of selected poll's voter (participant).",
	'qp_browse_to_interpretation' => 'A link title at [[Special:Pollresults]] which opens wiki page where the interpretation script of selected poll was defined.',
	'qp_votes_count' => 'Displays how many times the user re-submitted the poll. $1 is number of poll submissions.',
	'qp_source_link' => '"Source" is the link text for a link to the page where the poll is defined.
{{Identical|Source}}',
	'qp_stats_link' => '{{Identical|Statistics}}',
	'qp_users_link' => '{{Identical|User}}',
	'qp_voice_link' => 'A link title at [[Special:Pollresults]] which displays user vote (selected categories) for the selected poll.',
	'qp_voice_link_inv' => 'At the moment of query generation there was no user answer for the selected poll yet. Question mark encourages wiki administrator to re-submit the query again.',
	'qp_user_polls_link' => 'Parameters:
* $1 is the number of polls participated in.
* $2 is the name of the user this message refers to (optional - use for GENDER)',
	'qp_user_missing_polls_link' => 'Parameters:
* $1 is the name of the user this message refers to (optional - use for GENDER)',
	'qp_not_participated_link' => 'A link title at [[Special:Pollresults]] which displays the list of users which participated in another polls but did not participate in the selected poll.',
	'qp_order_by_username' => 'Order the list of polls at [[Special:Pollresults]] by username.',
	'qp_order_by_polls_count' => 'Order the list of polls at [[Special:Pollresults]] by number of their voters (popularity of the polls).',
	'qp_results_line_qupl' => 'Parameters:
* $1 is a link to the page page name the poll is on with the page title as link label
* $2 is the poll name in plain text
* $3 is a link to the poll statistics with link label {{msg-mw|qp_stats_link}}',
	'qp_results_line_qpl' => 'Parameters:
* $1 is a link to the page page name the poll is on with the page title as link label
* $2 is the poll name in plain text
* $3 is a link to the poll with link label {{msg-mw|qp_source_link}}
* $4 is a link to the poll statistics with link label {{msg-mw|qp_stats_link}}
* $5 is a link to the users that participated in the poll with link label {{msg-mw|qp_users_link}}
* $6 is a link to the with link label {{msg-mw|qp_not_participated_link}}',
	'qp_header_line_qpul' => 'Parameters:
* $1 is a link to the [[Special:Pollresults]] which displays either the list of users which participated in current poll, or the list of users that participated in another polls but this one
* $2 is a link to the page title where the poll is defined
* $3 is the poll name (poll identifier) in plain text',
	'qp_results_line_qpul' => '{{optional}}',
	'qp_header_line_qucl' => '{{optional}}',
	'qp_results_line_qucl' => '{{optional}}',
	'qp_results_submit_attempts' => 'Parameters:
* $1 is the number of submit attempts',
	'qp_results_interpretation_header' => 'Since v0.8.0 polls may have interpretation scripts defined at separate wiki pages, which allows to use the extension for quizes. Interpretation scripts return the following types of interpretation results: global error message, proposal error, proposal/category error, short interpretation, long interpretation, structured interpretation.  This message is the header of the block of these results displayed both to end-user and to poll admin at [[Special:Pollresults]] page.',
	'qp_results_short_interpretation' => 'Short interpretation header. Short interpretation will contain small sortable string in separate block. No parameters.',
	'qp_results_long_interpretation' => 'Long interpretation header. Long interpretation will contain long text (usually displayed to end-user) in separate block. No parameters.',
	'qp_results_structured_interpretation' => "Structured interpretation header. This type of interpretation is used to store measurable accountable structured data in interpretation scripts. Structured interpretation also can be read by another poll's interpretation scripts at later time and exported into XLS format. No parameters.",
	'qp_interpetation_wrong_answer' => "Indicates that user-submitted choices of categories are considered incorrect by poll's interpretation script.",
	'qp_export_to_xls' => 'Poll average statistics will be exported into XLS file.',
	'qp_voices_to_xls' => 'Poll user category choices will be exported into XLS file.',
	'qp_interpretation_results_to_xls' => 'Poll\\`s structured interpetation results will be exported into XLS file.',
	'qp_users_answered_questions' => 'Writes the message how many users answered to the poll questions in XLS file cell.',
	'qp_func_no_such_poll' => "qpuserchoice parser function did not found the poll specified in it's parameter.
* $1 is the poll address (page title + hash sign + qp prefix + poll id)",
	'qp_func_missing_question_id' => 'qpuserchoice parser function call should have question_id parameter specified.',
	'qp_func_invalid_question_id' => 'qpuserchoice parser function question_id call value should be integer number, [1..n].',
	'qp_func_missing_proposal_id' => 'qpuserchoice parser function call should have proposal id parameter specified.',
	'qp_func_invalid_proposal_id' => 'qpuserchoice parser function proposal id call value should be integer number, [0..n].',
	'qp_error_no_such_poll' => 'Poll statistics cannot be displayed because incorrect / missing poll address was specified in qpoll tag statistical mode.',
	'qp_error_in_question_header' => 'Main question header (common question or xml-like attributes) has syntax error.
* $1 is the source text of header.',
	'qp_error_id_in_stats_mode' => 'Poll "id" attribute is meaningless in statistical display mode.',
	'qp_error_dependance_in_stats_mode' => 'Poll "dependance" attribute is meaningless in statistical display mode.',
	'qp_error_address_in_decl_mode' => 'Poll "address" attribute is meaningless in poll declaration / voting mode.',
	'qp_error_question_not_implemented' => 'Invalid value of qustion xml-like "type" attribute was specified. There is no such type of question. Please read the manual for list of valid question types.',
	'qp_error_question_empty_body' => 'Question body contains no proposals / categories definition.',
	'qp_error_question_no_proposals' => 'Question body contains no proposals definition, there is nothing to vote for.',
	'qp_error_invalid_question_type' => '{{Identical|Invalid value of qustion xml-like "type" attribute was specified. There is no such type of question. Please read the manual for list of valid question types.}}',
	'qp_error_invalid_question_name' => '{{Identical|Invalid value of qustion xml-like "name" attribute was specified. Numeric names are not allowed due to possible index clash with integer question ids. Empty names are not allowed as impossible to reference. Too long names are not allowed, otherwise they will be improperly truncated when stored into DB field.}}',
	'qp_error_type_in_stats_mode' => 'Question\'s "type" xml-like attribute is meaningless in statistical display mode.',
	'qp_error_no_poll_id' => 'Every poll definition in declaration / voting mode must have "id" attribute.',
	'qp_error_too_long_dependance_value' => 'Parameters:
* $1 is the poll ID of the poll having an error.
* $2 is the value of poll "dependance" attribute, which cannot be stored into database because it is too long.',
	'qp_error_missed_dependance_poll' => 'Parameters:
* $1 is the poll ID of the poll having an error.
* $2 is a link to the page with the poll, that this erroneous poll depends on.
* $3 is the poll ID of the poll, which this erroneous poll depends on.',
	'qp_error_too_many_spans' => 'There cannot be more category groups defined than the total count of subcategories.',
	'qp_error_too_long_category_option_value' => 'Question type="text" categories with more than one text option to chose are displayed as html select/options list. Submitted (chosen) option value is stored in the database field. If the length of chosen value is too long, the value will be partially lost and select/option will not be properly highlighted. That\'s why the length limit is enforced.',
	'qp_error_too_long_category_options_values' => 'Question type="text" categories with more than one text option to chose are displayed as html select/options list. Submitted (chosen) options values are stored in the database field. If the total length of chosen values is too long, some of the values will be partially lost and select/options will not be properly highlighted. That\'s why the length limit is enforced.',
	'qp_error_too_long_proposal_text' => "Question type=\"text\" stores it's proposal parts and category definitions in 'proposal_text' field of database table, serialized. If serialized data is longer than database table field length, some of data will be lost and unserialization will be impossible.",
	'qp_error_too_long_proposal_name' => "Proposal name is defined to be used in interpretation scripts. It is stored in 'proposal_text' field of database table in such case. When the length of proposal name overflows the field length, the name will be truncated, and proposal will not be addressable by it's name in the interpretation script.",
	'qp_error_multiline_proposal_name' => 'Proposal name should not contain next characters: line feed and carriage return.',
	'qp_error_numeric_proposal_name' => 'Proposal name should not be numeric to avoid possible reference clash with proposal ids, which are integer numbers.',
	'qp_error_too_few_spans' => 'Every category group should include at least two subcategories',
	'qp_error_not_enough_categories_answered' => 'Current proposal\'s "catreq" attribute or it\'s inherited value of poll / question "catreq" attribute requires more than one category to be selected in the current proposal.',
	'qp_error_no_interpretation' => 'Title of interpretation script was specified in poll header, but no article was found with that title. Either remove "interpretation" xml attribute of poll or create the title specified by "interpretation" attribute.',
	'qp_error_interpretation_no_return' => 'Interpretation script missed an return statement.',
	'qp_error_structured_interpretation_is_too_long' => "Structured interpretation is serialized string containing scalar value or an associative array stored into database table field. It's purpose is to have measurable, easily processable interpretation result for the particular poll which then can be processed by external tools (via XLS export) or, to be read and processed by next poll interpretation script (data import and in the future maybe an export as well). When the serialized string is too long, it should never be stored, otherwise it will be truncated by DBMS so it cannot be properly unserialized later.",
	'qp_error_eval_missed_lang_attr' => '{{doc-important|Do not translate "lang" as it is the name of an XML attribute that is not localised.}}',
	'qp_error_eval_mix_languages' => 'Parameters:
* $1 is a language code,
* $2 is a language code.',
	'qp_error_eval_unsupported_language' => 'Parameters:
* $1 is a language code (usually is a value of qpinterpret tag lang attribute).',
	'qp_error_eval_illegal_token' => 'Parameters:
* $1 is a PHP token
* $2 is a PHP token value
* $3 is a line number in a script.',
	'qp_error_eval_illegal_superglobal' => 'Parameters:
* $1 is a PHP token
* $2 is a PHP superglobal value
* $3 is a line number in a script.',
	'qp_error_eval_illegal_function_call' => 'Parameters:
* $1 is a PHP token
* $2 is a function
* $3 is a line number in a script.',
	'qp_error_eval_variable_variable_access' => '"variable variable" is \'\'not\'\' a typo, see: http://php.net/manual/en/language.variables.variable.php

Parameters:
* $1 is a PHP token
* $2 is a PHP variable variable name
* $3 is a line number in a script.',
	'qp_error_eval_illegal_variable_name' => 'Parameters:
* $1 is a PHP token
* $2 is a variable name
* $3 is a line number in a script.',
	'qp_error_eval_variable_function_call' => 'Parameters:
* $1 is a PHP token
* $2 is a variable function name
* $3 is a line number in a script.',
	'qp_error_eval_self_check' => 'Parameters:
* $1 is self check that has failed.',
	'qp_error_eval_unable_to_lint' => '"Lint" is the term that is now applied generically to tools that flag suspicious usage in software written in any computer language [[w:en:Lint_%28software%29]].',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'pollresults' => 'Resultate van die peilings op hierdie webwerf',
	'qp_desc' => 'Maak dit moontlik om peilings te skep',
	'qp_desc-sp' => '[[Special:PollResults|Speciale bladsy]] om die resultate van peilings te wys',
	'qp_result_NA' => 'Nie beantwoord nie',
	'qp_result_error' => 'Sintaksfout',
	'qp_vote_button' => 'Stem',
	'qp_vote_again_button' => 'Verander u stem',
	'qp_polls_list' => 'Wys alle peilings',
	'qp_users_list' => 'Lys alle gebruikers',
	'qp_browse_to_poll' => 'Wys peiling $1',
	'qp_browse_to_user' => 'Blaai na gebruiker $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|stem|stemme}}',
	'qp_source_link' => 'Bron',
	'qp_stats_link' => 'Statistieke',
	'qp_users_link' => 'Gebruikers',
	'qp_voice_link' => 'Gebruikersstem',
	'qp_voice_link_inv' => 'Gebruikersstem',
	'qp_user_polls_link' => 'Het aan $1 {{PLURAL:$1|peiling|peilings}} deelgeneem',
	'qp_user_missing_polls_link' => 'Geen deelname',
	'qp_not_participated_link' => 'Nie deelgeneem nie',
	'qp_order_by_username' => 'Sorteer op gebruikersnaam',
	'qp_order_by_polls_count' => 'Sorteer op aantal peilings',
	'qp_results_line_qupl' => 'Bladsy "$1", peiling "$2": $3',
	'qp_results_line_qpl' => 'Bladsy "$1", peiling "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ bladsy "$2", peiling "$3" ]',
	'qp_export_to_xls' => 'Eksporteer statistieke na XLS-formaat',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|gebruiker|gebruikers}} het die vraag beantwoord',
	'qp_func_no_such_poll' => 'Die peiling bestaan nie ($1)',
	'qp_func_missing_question_id' => "Verskaf asseblief 'n vraag-ID (begin by 1) vir die peiling $1",
	'qp_func_invalid_question_id' => "Ongeldige vraag-ID ($2 - nie 'n getal nie) vir die peiling $1",
	'qp_func_missing_proposal_id' => "Verskaf asseblief 'n voorstel-ID (begin by 0) vir die peiling $1, vraag $2",
	'qp_func_invalid_proposal_id' => "Ongeldige voorstel-ID ($3 - nie 'n getal nie) vir die peiling $1, vraag $2",
	'qp_error_no_such_poll' => 'Die peiling bestaan nie ($1).
Sorg dat die peiling opgestel en gestoor is, en dat "#" as skeidingskarakter in die adres gebruik word.',
	'qp_error_id_in_stats_mode' => "Dit is nie moontlik om 'n ID vir die peiling in die statistiese modus te verklaar nie",
	'qp_error_dependance_in_stats_mode' => "Dit is nie moontlik om 'n afhanklikheid-ketting vir die peiling in die statistiese modus te verklaar nie",
	'qp_error_no_stats' => 'Daar is geen statistiese data beskikbaar nie omdat nog geen gebruikers in hierdie peiling gestem het nie (adres $1)',
	'qp_error_address_in_decl_mode' => "Dit is nie moontlik om 'n adres van die peiling in die verklaar-modus aan te vra nie.",
	'qp_error_question_not_implemented' => 'Vrae van die tipe is nie geïmplementeer nie: $1',
	'qp_error_invalid_question_type' => 'Ongeldige vraagtipe: $1',
	'qp_error_type_in_stats_mode' => 'Die vraagtipe kan nie in die statistiese vertoon-modus gedefinieer word nie: $1',
	'qp_error_no_poll_id' => 'Die eienskap "id" is nie vir die peiling gedefinieer nie.',
	'qp_error_invalid_poll_id' => 'Ongeldig peiling-ID ($1).
Die ID mag slegs letters, syfers en spasies bevat.',
	'qp_error_already_used_poll_id' => 'Die peilingsnommer word al reeds op hierdie bladsy gebruik (ID $1)',
	'qp_error_invalid_dependance_value' => 'Die peiling se afhanklikheid-ketting (ID $1) het \'n ongeldige waarde vir die afhanklikheid-eienskap (dependance "$2")',
	'qp_error_missed_dependance_title' => 'Die peiling (ID $1) is afhanklik van \'n ander peiling (ID $3) op bladsy [[$2]], maar die bladsy [[$2]] bestaan nie.
Verwyder die eienskap "dependance" of plaas die bladsy [[$2]] terug.',
	'qp_error_missed_dependance_poll' => 'Die peiling (ID $1) is afhanklik van \'n ander peiling (ID $3) op bladsy $2, maar die peiling bestaan nie of is nog nie geskep nie.
Verwyder die eienskap "dependance" of skep \'n peiling met ID $3 op bladsy $2.
Om \'n peiling te stoor, stuur dit sonder dat enig voorstel beantwoord word.',
	'qp_error_vote_dependance_poll' => 'Stem asseblief eers in die peiling $1.',
	'qp_error_too_many_spans' => 'Daar is te veel kategorieklasse vir die subkategorieë gedefinieer',
	'qp_error_unanswered_span' => 'Onbeantwoorde subkategorie',
	'qp_error_non_unique_choice' => "Hierdie vraag vereis 'n unieke voorstel-antwoord",
	'qp_error_category_name_empty' => 'Kategorie se naam is leeg',
	'qp_error_proposal_text_empty' => 'Geen voorstelteks is verskaf nie',
	'qp_error_too_few_categories' => 'Ten minste twee kategorieë moet gedefinieer word',
	'qp_error_too_few_spans' => 'Vir elke kategorieklas moet daar ten minste twee moontlike antwoorde gedefinieerd wees',
	'qp_error_no_answer' => 'Onbeantwoorde voorstel',
	'qp_error_unique' => 'Vir die vraag van die tipe unique() is daar meer voorstelle as moontlike antwoorde gedefinieer. Dit is nie reg voorberei nie.',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'qp_votes_count' => '$1 {{PLURAL:$1|votuar|vota}}',
	'qp_source_link' => 'Burim',
	'qp_stats_link' => 'Statistika',
	'qp_users_link' => 'Përdorues',
	'qp_voice_link' => 'zëri i përdoruesit',
	'qp_voice_link_inv' => 'zë User?',
	'qp_user_polls_link' => 'Marrë pjesë në $1 {{PLURAL:$1|sondazhi|Sondazhet}}',
	'qp_user_missing_polls_link' => 'Nuk ka pjesëmarrje',
	'qp_not_participated_link' => 'Nuk ka marrë pjesë',
	'qp_order_by_username' => 'Rendit nga username',
	'qp_order_by_polls_count' => 'Rendit nga sondazhet numërimin e',
	'qp_results_line_qupl' => 'Faqja "$1" Hulumtimi i opinionit publik "$2": $3',
	'qp_results_line_qpl' => 'Faqja "$1" Hulumtimi i opinionit publik "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Faqja "$2" Hulumtimi i opinionit publik "$3"]',
	'qp_export_to_xls' => 'Statistikat e eksportit në formatin XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|përdorues|përdorues}} përgjigjur në pyetjet',
	'qp_func_no_such_poll' => 'Asnjë sondazh i tillë ($1)',
	'qp_func_missing_question_id' => 'Ju lutem specifikoni një pyetje id ekzistuese (duke filluar nga 1) për sondazhi i $1',
	'qp_func_invalid_question_id' => 'pyetje e pavlefshme id = $2 (nuk një numër) për sondazhi i $1',
	'qp_func_missing_proposal_id' => 'Ju lutem specifikoni një propozim id ekzistuese (duke filluar nga 0) për votimin e pyetjes $1, $2',
	'qp_func_invalid_proposal_id' => 'propozimin e pavlefshme id = $3 nuk (një numër) për votimin e pyetjes $1, $2',
	'qp_error_no_such_poll' => 'Asnjë sondazh i tillë ($1). Sigurohuni që sondazhi i deklaruar dhe ruhet, gjithashtu të jetë e sigurtë për të përdorur karakter adresën Kufi #',
	'qp_error_in_question_header' => 'Fillim i pavlefshëm pyetje: $1',
	'qp_error_id_in_stats_mode' => 'Nuk mund të deklarojë një ID të anketës në mënyrë statistikore',
	'qp_error_dependance_in_stats_mode' => 'Nuk mund të deklaroj zinxhir dependance e anketës në mënyrë statistikore',
	'qp_error_no_stats' => 'Nuk ka të dhëna statistikore është në dispozicion, sepse askush nuk ka votuar për këtë sondazh, por (adresa = $1)',
	'qp_error_address_in_decl_mode' => 'Nuk mund të merrni një adresë e anketës në deklaratë mode',
	'qp_error_question_not_implemented' => 'Pyetjet e tipit të tillë nuk janë zbatuar: $1',
	'qp_error_invalid_question_type' => 'Lloj i pavlefshëm pyetje: $1',
	'qp_error_type_in_stats_mode' => 'Lloji i Pyetja nuk mund të përcaktohet në mënyrë të shfaqur statistikore: $1',
	'qp_error_no_poll_id' => 'tag Anketa id ka asnjë atribut të përcaktuar.',
	'qp_error_invalid_poll_id' => 'Sondazhi id pavlefshme (id = $1). id Anketa mund të përmbajë vetëm shkronja, numra dhe karakterin hapësirë',
	'qp_error_already_used_poll_id' => 'Id sondazh është tashmë të përdorura në këtë faqe (id = $1).',
	'qp_error_invalid_dependance_value' => 'Anketa (id = 1 $) zinxhirit të dependance ka vlerë të pavlefshme e vetive dependance (dependance = "$2")',
	'qp_error_missed_dependance_title' => 'Anketa (id = $1) është i varur nga anketa e një tjetër (id = $3) nga faqja [[$2]], por titullin [[$2]] nuk u gjet.
Ose hequr atribut dependance, ose rivendosjen e [[$2]]',
	'qp_error_missed_dependance_poll' => 'Anketa (id = $1) është i varur nga anketa e një tjetër (id = $3) në faqe $2, por se sondazhi nuk ekziston ose nuk është ruajtur akoma. Ose hequr atribut dependance, apo krijimi i anketës me id = $3 në faqe $2 dhe për të shpëtuar atë. Për të ruajtur një sondazh, i jepni kohë nuk iu përgjigjur ndonjë pyetje propozim.',
	'qp_error_vote_dependance_poll' => 'Ju lutemi të votojnë për sondazh $1 të parë.',
	'qp_error_too_many_spans' => 'Shumë grupe të kategorisë së për numrin e përgjithshëm të nën-kategori të përcaktuara',
	'qp_error_unanswered_span' => 'nënkategori pa përgjigje',
	'qp_error_non_unique_choice' => 'Kjo pyetje kërkon përgjigje unike propozim',
	'qp_error_category_name_empty' => 'Emri Kategoria është e zbrazët',
	'qp_error_proposal_text_empty' => 'tekstit Propozimi është e zbrazët',
	'qp_error_too_few_categories' => 'Së paku dy kategori duhet të përcaktohet',
	'qp_error_too_few_spans' => 'Çdo grup kategori Duhet të përmbajë të paktën dy nën-kategori',
	'qp_error_no_answer' => 'propozim pa përgjigje',
	'qp_error_unique' => 'Pyetje të tipit () ka unike propozimet më shumë se përgjigje të mundshme të përcaktuara: e pamundur për të kompletuar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'pollresults' => 'نتائج الاستقصاءات في هذا الموقع',
	'qp_desc' => 'يسمح بإنشاء اقتراعات',
	'qp_desc-sp' => '[[Special:PollResults|صفحة خاصة]] لرؤية نتائج الاقتراعات',
	'qp_result_NA' => 'غير مجاب عنه',
	'qp_result_error' => 'خطأ صياغة',
	'qp_vote_button' => 'تصويت',
	'qp_vote_again_button' => 'غير صوتك',
	'qp_polls_list' => 'عرض كل الاقتراعات',
	'qp_users_list' => 'عرض كل المستخدمين',
	'qp_browse_to_poll' => 'اذهب إلى $1',
	'qp_browse_to_user' => 'اذهب إلى $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|صوت|أصوات}}',
	'qp_source_link' => 'مصدر',
	'qp_stats_link' => 'إحصاءات',
	'qp_users_link' => 'مستخدمون',
	'qp_voice_link' => 'صوت المستخدم',
	'qp_voice_link_inv' => 'صوت المستخدم؟',
	'qp_user_polls_link' => 'شارك في $1 {{PLURAL:$1|اقتراع|اقتراعات}}',
	'qp_user_missing_polls_link' => 'لا مشاركة',
	'qp_not_participated_link' => 'لم يشارك',
	'qp_order_by_username' => 'رتب حسب اسم المستخدم',
	'qp_order_by_polls_count' => 'رتب حسب عداد الاقتراعات',
	'qp_results_line_qupl' => 'الصفحة "$1" الاقتراع "$2": $3',
	'qp_results_line_qpl' => 'الصفحة "$1" الاقتراع "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ الصفحة "$2" الاقتراع "$3" ]',
	'qp_export_to_xls' => 'صدر الإحصاءات بصيغة XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|مستخدم|مستخدم}} أجاب على الأسئلة',
	'qp_func_no_such_poll' => 'لا استطلاع كهذا ($1)',
	'qp_func_missing_question_id' => 'من فضلك حدد رقم سؤال موجود (بدءا من 1) للاقتراع $1',
	'qp_func_invalid_question_id' => 'سؤال غير صحيح id=$2 (ليس رقما) للاقتراع $1',
	'qp_func_missing_proposal_id' => 'من فضلك حدد رقم اقتراح موجود (بدءا من 0) للاقتراع $1, السؤال $2',
	'qp_func_invalid_proposal_id' => 'عرض غير صحيح id=$3 (ليس رقما) للاقتراع $1, السؤال $2',
	'qp_error_no_such_poll' => 'لا اقتراع كهذا ($1).
تأكد من أن الاقتراع معلن عنه ومحفوظ، وتأكد أيضا من استخدام حرف فصل العنوان #',
	'qp_error_id_in_stats_mode' => 'لا يمكن إعلان رقم للاقتراع في نمط الإحصاءات',
	'qp_error_dependance_in_stats_mode' => 'لا يمكن الإعلان عن سلسلة اعتماد الاقتراع في نمط الإحصاءات',
	'qp_error_no_stats' => 'لا بيانات إحصائية متوفرة، لأنه لا أحد صوت في هذا الاقتراع بعد (address=$1)',
	'qp_error_address_in_decl_mode' => 'لا يمكن الحصول على عنوان في نمط الإعلان',
	'qp_error_question_not_implemented' => 'الأسئلة من هذا النوع غير مطبقة: $1',
	'qp_error_invalid_question_type' => 'نوع سؤال غير صالح: $1',
	'qp_error_type_in_stats_mode' => 'نوع السؤال لا يمكن تعريفه في نمط العرض الإحصائي: $1',
	'qp_error_no_poll_id' => 'وسم الاقتراع ليس به معرف رقم محدد.',
	'qp_error_invalid_poll_id' => 'رقم اقتراع غير صحيح (id=$1).
رقم الاقتراع يمكن ان يحتوي فقط على حروف، أرقام وحرف الفراغ',
	'qp_error_already_used_poll_id' => 'رقم الاقتراع تم استخدامه بالفعل في هذه الصفحة (id=$1).',
	'qp_error_invalid_dependance_value' => 'سلسة اعتماد الاقتراع (id=$1) بها قيمة غير صحيحة لمحدد الاعتماد (dependance="$2")',
	'qp_error_missed_dependance_title' => 'الاقتراع (id=$1) معتمد على اقتراع آخر (id=$3) من الصفحة [[$2]]، لكن العنوان [[$2]] لم يتم العثور عليه.
إما أن تزيل محدد الاعتماد، أو تسترجع [[$2]]',
	'qp_error_missed_dependance_poll' => 'الاقتراع (id=$1) معتمد على اقتراع آخر (id=$3) في الصفحة $2، لكن هذا الاقتراع غير موجود أو لم يتم حفظه بعد.
إما أن تزيل محدد الاعتماد، أو تنشئ الاقتراع بالرقم id=$3 في الصفحة $2 وتحفظه.
لحفظ اقتراع، نفذه مع عدم الإجابة على أي أسئلة مطروحة.',
	'qp_error_vote_dependance_poll' => 'من فضلك صوت للاقتراع $1 أولا.',
	'qp_error_too_many_spans' => 'عدد كبير من مجموعات التصنيفات للعدد الإجمالي المعرف من التصنيفات الفرعية',
	'qp_error_unanswered_span' => 'تصنيف فرعي غير مجاب عليه',
	'qp_error_non_unique_choice' => 'يجب أن يتوفر للسؤال إجابة مُقترحة فريدة',
	'qp_error_category_name_empty' => 'اسم التصنيف فارغ',
	'qp_error_proposal_text_empty' => 'نص الاقتراح فارغ',
	'qp_error_too_few_categories' => 'يجب أن تُعرّف تصنيفين على الأقل',
	'qp_error_too_few_spans' => 'كل مجموعة تصنيف يجب أن تحتوي على الأقل على تصنيفين فرعيين',
	'qp_error_no_answer' => 'اقتراح غير مجاب عليه',
	'qp_error_unique' => 'السؤال من نوع unique() لديه اقتراحات أكثر من الأجوبة المحتملة المعرفة: مستحيل الإكمال',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author 334a
 * @author Basharh
 * @author Michaelovic
 */
$messages['arc'] = array(
	'qp_vote_button' => 'ܝܗܒ ܩܠܐ',
	'qp_users_list' => 'ܚܘܝ ܟܠ ܡܦܠܚܢ̈ܐ',
	'qp_browse_to_poll' => 'ܙܠ ܠ $1',
	'qp_browse_to_user' => 'ܙܠ ܠ $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|ܩܠܐ|ܩܠ̈ܐ}}',
	'qp_source_link' => 'ܡܒܘܥܐ',
	'qp_users_link' => 'ܡܦܠܚܢ̈ܐ',
	'qp_voice_link' => 'ܩܠܐ ܕܡܦܠܚܢܐ',
	'qp_voice_link_inv' => 'ܡܦܠܚܢܐ ܝܗܒ ܩܠܐ؟',
	'qp_error_category_name_empty' => 'ܫܡܐ ܕܣܕܪܐ ܣܦܝܩܐ ܗܘ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'pollresults' => 'نتائج الاستقصاءات فى هذا الموقع',
	'qp_desc' => 'يسمح بإنشاء اقتراعات',
	'qp_desc-sp' => '[[Special:PollResults|صفحه خاصة]] لرؤيه نتائج الاقتراعات',
	'qp_result_NA' => 'غير مجاب عنه',
	'qp_result_error' => 'خطأ صياغة',
	'qp_vote_button' => 'تصويت',
	'qp_vote_again_button' => 'غير صوتك',
	'qp_polls_list' => 'عرض كل الاقتراعات',
	'qp_users_list' => 'عرض كل المستخدمين',
	'qp_browse_to_poll' => 'اذهب إلى $1',
	'qp_browse_to_user' => 'اذهب إلى $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|صوت|أصوات}}',
	'qp_source_link' => 'مصدر',
	'qp_stats_link' => 'إحصاءات',
	'qp_users_link' => 'مستخدمون',
	'qp_voice_link' => 'صوت المستخدم',
	'qp_voice_link_inv' => 'صوت المستخدم؟',
	'qp_user_polls_link' => 'شارك فى $1 {{PLURAL:$1|اقتراع|اقتراعات}}',
	'qp_user_missing_polls_link' => 'لا مشاركة',
	'qp_not_participated_link' => 'لم يشارك',
	'qp_order_by_username' => 'رتب حسب اسم المستخدم',
	'qp_order_by_polls_count' => 'رتب حسب عداد الاقتراعات',
	'qp_results_line_qupl' => 'الصفحه "$1" الاقتراع "$2": $3',
	'qp_results_line_qpl' => 'الصفحه "$1" الاقتراع "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ الصفحه "$2" الاقتراع "$3" ]',
	'qp_export_to_xls' => 'صدر الإحصاءات بصيغه XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|مستخدم|مستخدم}} أجاب على الأسئلة',
	'qp_func_no_such_poll' => 'لا استطلاع كهذا ($1)',
	'qp_func_missing_question_id' => 'من فضلك حدد رقم سؤال موجود (بدءا من 1) للاقتراع $1',
	'qp_func_invalid_question_id' => 'سؤال غير صحيح id=$2 (ليس رقما) للاقتراع $1',
	'qp_func_missing_proposal_id' => 'من فضلك حدد رقم اقتراح موجود (بدءا من 0) للاقتراع $1, السؤال $2',
	'qp_func_invalid_proposal_id' => 'عرض غير صحيح id=$3 (ليس رقما) للاقتراع $1, السؤال $2',
	'qp_error_no_such_poll' => 'لا اقتراع كهذا ($1).
تأكد من أن الاقتراع معلن عنه ومحفوظ، وتأكد أيضا من استخدام حرف فصل العنوان #',
	'qp_error_id_in_stats_mode' => 'لا يمكن إعلان رقم للاقتراع فى نمط الإحصاءات',
	'qp_error_dependance_in_stats_mode' => 'لا يمكن الإعلان عن سلسله اعتماد الاقتراع فى نمط الإحصاءات',
	'qp_error_no_stats' => 'لا بيانات إحصائيه متوفره، لأنه لا أحد صوت فى هذا الاقتراع بعد (address=$1)',
	'qp_error_address_in_decl_mode' => 'لا يمكن الحصول على عنوان فى نمط الإعلان',
	'qp_error_question_not_implemented' => 'الأسئله من هذا النوع غير مطبقة: $1',
	'qp_error_invalid_question_type' => 'نوع سؤال غير صالح: $1',
	'qp_error_type_in_stats_mode' => 'نوع السؤال لا يمكن تعريفه فى نمط العرض الإحصائي: $1',
	'qp_error_no_poll_id' => 'وسم الاقتراع ليس به معرف رقم محدد.',
	'qp_error_invalid_poll_id' => 'رقم اقتراع غير صحيح (id=$1).
رقم الاقتراع يمكن ان يحتوى فقط على حروف، أرقام وحرف الفراغ',
	'qp_error_already_used_poll_id' => 'رقم الاقتراع تم استخدامه بالفعل فى هذه الصفحه (id=$1).',
	'qp_error_invalid_dependance_value' => 'سلسه اعتماد الاقتراع (id=$1) بها قيمه غير صحيحه لمحدد الاعتماد (dependance="$2")',
	'qp_error_missed_dependance_title' => 'الاقتراع (id=$1) معتمد على اقتراع آخر (id=$3) من الصفحه [[$2]]، لكن العنوان [[$2]] لم يتم العثور عليه.
إما أن تزيل محدد الاعتماد، أو تسترجع [[$2]]',
	'qp_error_missed_dependance_poll' => 'الاقتراع (id=$1) معتمد على اقتراع آخر (id=$3) فى الصفحه $2، لكن هذا الاقتراع غير موجود أو لم يتم حفظه بعد.
إما أن تزيل محدد الاعتماد، أو تنشئ الاقتراع بالرقم id=$3 فى الصفحه $2 وتحفظه.
لحفظ اقتراع، نفذه مع عدم الإجابه على أى أسئله مطروحه.',
	'qp_error_vote_dependance_poll' => 'من فضلك صوت للاقتراع $1 أولا.',
	'qp_error_too_many_spans' => 'عدد كبير من مجموعات التصنيفات للعدد الإجمالى المعرف من التصنيفات الفرعية',
	'qp_error_unanswered_span' => 'تصنيف فرعى غير مجاب عليه',
	'qp_error_non_unique_choice' => 'يجب أن يتوفر للسؤال إجابه مُقترحه فريدة',
	'qp_error_category_name_empty' => 'اسم التصنيف فارغ',
	'qp_error_proposal_text_empty' => 'نص الاقتراح فارغ',
	'qp_error_too_few_categories' => 'يجب أن تُعرّف تصنيفين على الأقل',
	'qp_error_too_few_spans' => 'كل مجموعه تصنيف يجب أن تحتوى على الأقل على تصنيفين فرعيين',
	'qp_error_no_answer' => 'اقتراح غير مجاب عليه',
	'qp_error_unique' => 'السؤال من نوع unique() لديه اقتراحات أكثر من الأجوبه المحتمله المعرفة: مستحيل الإكمال',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'qp_vote_button' => 'Səs',
	'qp_source_link' => 'Mənbə',
	'qp_users_link' => 'İstifadəçilər',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'qp_stats_link' => 'Статыстыка',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'pollresults' => 'Вынікі апытаньняў на гэтым сайце',
	'qp_desc' => 'Дазваляе стварэньне апытаньняў',
	'qp_desc-sp' => '[[Special:PollResults|Спэцыяльная старонка]] для прагляду вынікаў апытаньняў',
	'qp_result_NA' => 'Няма адказу',
	'qp_result_error' => 'Сынтаксычная памылка',
	'qp_vote_button' => 'Прагаласаваць',
	'qp_vote_again_button' => 'Зьмяніць Ваш голас',
	'qp_submit_attempts_left' => '{{PLURAL:$1|засталася $1 спроба|засталіся $1 спробы|засталося $1 спробаў}}',
	'qp_polls_list' => 'Сьпіс усіх апытаньняў',
	'qp_users_list' => 'Сьпіс усіх удзельнікаў',
	'qp_browse_to_poll' => 'Перайсьці да $1',
	'qp_browse_to_user' => 'Перайсьці да $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|голас|галасы|галасоў}}',
	'qp_source_link' => 'Крыніца',
	'qp_stats_link' => 'Статыстыка',
	'qp_users_link' => 'Удзельнікі',
	'qp_voice_link' => 'Голас удзельніка',
	'qp_voice_link_inv' => 'Голас удзельніка?',
	'qp_user_polls_link' => '{{GENDER:$2|Удзельнічаў|Удзельнічала}} у $1 {{PLURAL:$1|апытаньні|апытаньнях|апытаньнях}}',
	'qp_user_missing_polls_link' => 'Не {{GENDER:$1|ўдзельнічаў|ўдзельнічала}}',
	'qp_not_participated_link' => 'Сьпіс не прыняўшых удзел',
	'qp_order_by_username' => 'Сартаваць па імені ўдзельніка',
	'qp_order_by_polls_count' => 'Сартаваць па колькасьці апытаньняў',
	'qp_results_line_qupl' => 'Старонка «$1» Апытаньне «$2»: $3',
	'qp_results_line_qpl' => 'Старонка «$1» Апытаньне «$2»: $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Старонка «$2» Апытаньне «$3» ]',
	'qp_results_submit_attempts' => 'Спробаў адказаў: $1',
	'qp_results_interpretation_header' => 'Інтэрпрэтацыя адказу',
	'qp_results_short_interpretation' => 'Кароткая інтэрпрэтацыя',
	'qp_results_long_interpretation' => 'Доўгая інтэрпрэтацыя',
	'qp_poll_has_no_interpretation' => 'Шаблён, які выкарыстоўваецца для інтэрпрэтацыі вынікаў апытаньня, ня вызначаны ў загалоўку апытаньня.',
	'qp_interpetation_wrong_answer' => 'Няслушны адказ',
	'qp_export_to_xls' => 'Экспартаваць статыстыку ў фармат XLS',
	'qp_voices_to_xls' => 'Экспартаваць галасы ў фармат XLS',
	'qp_users_answered_questions' => 'На пытаньні {{PLURAL:$1|адказаў $1 удзельнік|адказалі $1 удзельнікі|адказалі $1 удзельнікаў}}',
	'qp_func_no_such_poll' => 'Няма такога апытаньня ($1)',
	'qp_func_missing_question_id' => 'Калі ласка, пазначце ідэнтыфікатар існуючага пытаньня (пачынаючы з 1) для апытаньня $1',
	'qp_func_invalid_question_id' => 'Няслушны ідэнтыфікатар апытаньня=$2 (ня лік) для апытаньня $1',
	'qp_func_missing_proposal_id' => 'Калі ласка, пазначце існуючы ідэнтыфікатар (пачынаючы з 0) для апытаньня $1, пытаньня $2',
	'qp_func_invalid_proposal_id' => 'Няслушны ідэнтыфікатар=$3 (ня лік) для апытаньня $1, пытаньня $2',
	'qp_error_no_such_poll' => 'Няма такога апытаньня ($1).
Упэўніцеся што апытаньне вызначанае і захаванае, а таксама, што выкарыстоўваецца сымбаль падзелу адрасу #',
	'qp_error_in_question_header' => 'Няслушны загаловак пытаньня: $1',
	'qp_error_id_in_stats_mode' => 'Немагчыма вызначаць ідэнтыфікатар апытаньня ў статыстычным рэжыме',
	'qp_error_dependance_in_stats_mode' => 'Немагчыма вызначаць залежную пасьлядоўнасьць апытаньня ў статыстычным рэжыме',
	'qp_error_no_stats' => 'Няма статыстычных зьвестак, таму што ніхто яшчэ не падаў голас у гэтым апытаньні (адрас=$1)',
	'qp_error_address_in_decl_mode' => 'Немагчыма атрымаць адрас апытаньня ў рэжыме вызначэньня',
	'qp_error_question_not_implemented' => 'Пытаньні гэтага тыпу не рэалізаваныя: $1',
	'qp_error_invalid_question_type' => 'Няслушны тып пытаньня: $1',
	'qp_error_type_in_stats_mode' => 'Немагчыма вызначыць тып пытаньня ў статыстычным рэжыме: $1',
	'qp_error_no_poll_id' => 'Тэг апытаньня ня мае атрыбута ідэнтыфікацыі.',
	'qp_error_invalid_poll_id' => 'Няслушны ідэнтыфікатар апытаньня (id=$1).
Ідэнтыфікатар апытаньня можа ўтрымліваць толькі літары, лічбы і сымбаль прагалу',
	'qp_error_already_used_poll_id' => 'Ідэнтыфікатар апытаньня ўжо быў выкарыстаны на гэтай старонцы (id=$1).',
	'qp_error_invalid_dependance_value' => 'У ланцугу залежнасьці апытаньня (id=$1) існуе няслушнае значэньне атрыбуту залежнасьці (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Апытаньне (id=$1) залежыць ад іншага апытаньня (id=$3) са старонкі [[$2]], але назва [[$2]] не была знойдзеная.
Неабходна выдаліць атрыбут залежнасьці ці аднавіць [[$2]]',
	'qp_error_missed_dependance_poll' => 'Апытаньне (id=$1) залежыць ад іншага апытаньня (id=$3) на старонцы $2, але гэта апытаньне не існуе ці яшчэ не было захаванае.
Неабходна выдаліць атрыбут залежнасьці альбо стварыць апытаньне з ідэнтыфікатарам id=$3 на старонцы $2 і яго захаваць. Каб захаваць апытаньне можна націснуць кнопку «Прагаласаваць», не адказваючы на пытаньні.',
	'qp_error_vote_dependance_poll' => 'Калі ласка, спачатку прыміце ўдзел у апытаньні $1.',
	'qp_error_too_many_spans' => 'Вызначана зашмат клясаў катэгорыяў для падкатэгорыяў',
	'qp_error_unanswered_span' => 'Падкатэгорыя без адказу',
	'qp_error_non_unique_choice' => 'Гэта пытаньне патрабуе, каб варыянт адказу не выкарыстоўваўся раней',
	'qp_error_category_name_empty' => 'Пустая назва катэгорыі',
	'qp_error_proposal_text_empty' => 'Прапанаваны тэкст — пусты',
	'qp_error_too_long_proposal_text' => 'Прапанаваны тэкст занадта доўгі, каб быць захаваным у базе зьвестак',
	'qp_error_too_few_categories' => 'Павінны быць вызначаныя хаця б дзьве катэгорыі',
	'qp_error_too_few_spans' => 'Кожная кляса катэгорыі патрабуе хаця б два варыянты адказу',
	'qp_error_no_answer' => 'Няма адказу на пытаньне',
	'qp_error_unique' => 'Пытаньне тыпу unique() мае больш адказаў чым гэта магчыма: немагчыма скончыць',
	'qp_error_no_more_attempts' => 'Вы дасягнулі максымальнай колькасьці спробаў адказу на гэтае апытаньне.',
	'qp_error_interpretation_no_return' => 'Скрыпт інтэрпрэтацыі не вярнуў вынік.',
	'qp_error_no_json_decode' => 'Інтэрпрэтацыя вынікаў апытаньня патрабуе PHP-функцыю json_decode().',
	'qp_error_eval_missed_lang_attr' => 'XML-атрыбут «lang» патрабуецца для выбару слушнай мовы інтэрпрэтацыі.',
	'qp_error_eval_mix_languages' => 'Асобны скрыпт інтэрпрэтацыі ня можа зьмешваць розныя мовы інтэрпрэтацыі: «$1», «$2».',
	'qp_error_eval_unsupported_language' => 'Непадтрымліваемая мова інтэрпрэтацыі «$1».',
	'qp_error_eval_illegal_token' => 'Ключ PHP $1 са значэньнем $2 не дазволены ў радку $3.',
	'qp_error_eval_illegal_superglobal' => 'Ключ PHP $1 з супэрглябальным значэньнем $2 не дазволены ў радку $3.',
	'qp_error_eval_illegal_function_call' => 'Ключ PHP $1 з функцыяй $2 не дазволены ў радку $3.',
	'qp_error_eval_variable_variable_access' => 'Ключ PHP $1 са зьменнай $2 не дазволены ў радку $3.',
	'qp_error_eval_illegal_variable_name' => 'Ключ PHP $1 мае недазволеную назву зьменнай $2 у радку $3.',
	'qp_error_eval_variable_function_call' => 'Ключ PHP $1 са зьменнай функцыяй $2 не дазволены ў радку $3.',
	'qp_error_eval_self_check' => 'Наступная самаправерка eval() вярнула памылку: $1. Вы маеце непадтрымліваемую вэрсію PHP, якая не дазваляе запускаць скрыпт eval бясьпечна.',
	'qp_error_eval_unable_to_lint' => 'Немагчыма праверыць слушнасьць праграмы. Праверце налады Вашай сыстэмы.',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'qp_vote_button' => 'ভোট',
	'qp_vote_again_button' => 'আপনার ভোট পরিবর্তন করুন',
	'qp_polls_list' => 'সকল নির্বাচন তালিকাভুক্ত করো',
	'qp_source_link' => 'উৎস',
	'qp_stats_link' => 'পরিসংখ্যান',
	'qp_users_link' => 'ব্যবহারকারীগণ',
	'qp_voice_link' => 'ব্যবহারকারীর কণ্ঠ',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'pollresults' => "Disoc'hoù ar sontadegoù el lec'hienn-mañ",
	'qp_desc' => 'Aotren krouiñ sontadegoù',
	'qp_desc-sp' => "[[Special:PollResults|Pajenn ispisial]] evit sellet ouzh disoc'hoù ar sontadegoù",
	'qp_result_NA' => 'Direspont',
	'qp_result_error' => 'Fazi ereadur',
	'qp_vote_button' => 'Mouezhiañ',
	'qp_vote_again_button' => 'Distreiñ war ho vot',
	'qp_polls_list' => 'Rollañ an holl sontadegoù',
	'qp_users_list' => 'Renabliñ an holl implijerien',
	'qp_browse_to_poll' => 'Mont betek $1',
	'qp_browse_to_user' => 'Mont betek $1',
	'qp_browse_to_interpretation' => 'Medeiñ betek $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|vot|vot}}',
	'qp_source_link' => 'Mammenn',
	'qp_stats_link' => 'Stadegoù',
	'qp_users_link' => 'Implijerien',
	'qp_voice_link' => 'Mouezh an implijer',
	'qp_voice_link_inv' => 'Mouezh an implijer ?',
	'qp_user_polls_link' => 'En deus kemeret perzh e $1 sontadeg{{PLURAL:$1||}}',
	'qp_user_missing_polls_link' => 'Ne gemer ket perzh',
	'qp_not_participated_link' => "N'en deus ket kemeret perzh",
	'qp_order_by_username' => 'Urzhiañ dre anv implijer',
	'qp_order_by_polls_count' => 'Urzhiañ dre an niver a sontadegoù',
	'qp_results_line_qupl' => 'Pajenn "$1" Sontadeg "$2" : $3',
	'qp_results_line_qpl' => 'Pajenn "$1" Sontadeg "$2" : $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Pajenn "$2" Votadeg "$3" ]',
	'qp_interpetation_wrong_answer' => 'Respont fall',
	'qp_export_to_xls' => "Ezporzhiañ ar stadegoù d'ar furmad XLS",
	'qp_voices_to_xls' => "Ezporzhiañ ar votoù d'ar furmad XLS",
	'qp_users_answered_questions' => "$1 {{PLURAL:$1|implijer|implijer}} o deus respontet d'ar goulennoù",
	'qp_func_no_such_poll' => "N'eus ket eus ar votadeg-mañ ($1)",
	'qp_func_missing_question_id' => "Spisait un ID evit ur goulenn zo anezhañ c'hoazh (adalek 1) evit ar sontadeg $1",
	'qp_func_invalid_question_id' => 'Id direizh evit ar goulenn=$2 direizh (ket un niver) evit ar sontadeg $1',
	'qp_func_missing_proposal_id' => "Spisait un ID kinnig zo anezhañ c'hoazh (adalek 0) evit ar sontadeg $1, goulenn $2",
	'qp_func_invalid_proposal_id' => 'Id kinnig=$3 direizh (ket un niver) evit ar sontadeg $1, goulenn $2',
	'qp_error_no_such_poll' => "N'eus ket eus ar sontadeg ($1).
Bezit sur eo bet disklêriet hag enrollet ar sontadeg ha na zisoñjit ket ober gant an arouezenn bevenniñ chomlec'hioù #",
	'qp_error_in_question_header' => 'Talbenn goulenn direizh : $1',
	'qp_error_id_in_stats_mode' => 'Dibosupl eo diskleriañ un ID eus ar sontadeg er mod stadegoù',
	'qp_error_dependance_in_stats_mode' => "Dibosupl eo diskleriañ ar chadenn amzalc'h d'ar sontadeg er mod stadegoù",
	'qp_error_no_stats' => "N'eus ket a roadennoù stadegel rak den ebet n'en deus respontet d'ar sontadeg evit c'hoazh (chomlec'h=$1)",
	'qp_error_address_in_decl_mode' => "N'haller ket tapout ur chomlec'h eus ar sontadeg er mod disklêriañ",
	'qp_error_question_not_implemented' => "N'eo ket emplementet ar goulennoù a-seurt gant $1",
	'qp_error_invalid_question_type' => 'Seurt goulenn direizh : $1',
	'qp_error_type_in_stats_mode' => "N'haller ket termeniñ doare ar goulennoù er mod diskwel stadegoù : $1",
	'qp_error_no_poll_id' => "N'eus ket a niverenn-anout termenet gant balizenn ar sontadeg.",
	'qp_error_invalid_poll_id' => "Direizh eo an niverenn-anaout (id=$1).
N'hall bezañ en niverenn-anaout nemet lizherennoù, niverennoù hag an arouezenn esaouenn",
	'qp_error_already_used_poll_id' => 'Implijet eo bet choazh an niverenn-anaout sontadeg war ar bajenn (id=$1).',
	'qp_error_invalid_dependance_value' => 'Direizh eo talvoudenn chadennad amzalc\'h ar sontadeg (id=$1) evit an atribut amzalc\'h (amzalc\'h="$2")',
	'qp_error_missed_dependance_title' => "E dalc'h ur sontadeg all (id=$3) eus ar bajenn [[$2]] emañ ar sontadeg (i=$1), met an titl [[$2]] n'eo ket bet kavet.
Diverkit an atribut amzalc'h pe assavit [[$2]]",
	'qp_error_missed_dependance_poll' => "Dindan dalc'h ur sontadeg all (id=$3) war pajenn $2 emañ ar sontadeg (id=$1), met n'eus ket eus ar sontadeg-se pe n'eo ket bet enrollet c'hoazh.
Tennit an atribut amzalc'h pe krouit ar sontadeg $3 war ar bajenn $2 hag enrollit anezhi.
Evit enrollañ ur sontadeg, kasit anezhi ha na respontit da goulenn kinnig ebet.",
	'qp_error_vote_dependance_poll' => 'Mar plij, votit evit ar sontadeg $1 da gentañ.',
	'qp_error_too_many_spans' => 'Re a strolladoù rummadoù evit an niver hollek a isrummadoù termenet',
	'qp_error_unanswered_span' => 'Is-rummad hep respont',
	'qp_error_non_unique_choice' => 'Ar goulenn-mañ he deus ezhomm ur respont gant un dibab hepken',
	'qp_error_category_name_empty' => 'Goullo eo anv ar rummad',
	'qp_error_proposal_text_empty' => "Goullo eo testenn ar c'hinnig",
	'qp_error_too_few_categories' => 'Daou rummad da nebeutañ a rank bezañ termenet',
	'qp_error_too_few_spans' => 'Pep strollad rummad a rank bezañ ennañ daou isrummad da nebeutañ',
	'qp_error_no_answer' => 'Kinnig direspont',
	'qp_error_unique' => 'Re a ginnigoù zo evit ar goulenn seurt nemetañ () eget an niver a respontoù posupl termenet : dibosupl eo klokaat',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'pollresults' => 'Rezultati glasanja na ovoj stranici',
	'qp_desc' => 'Omogućuje pravljenje glasanja',
	'qp_desc-sp' => '[[Special:PollResults|Posebna stranica]] za pregled rezultata glasanja',
	'qp_result_NA' => 'Nije odgovoreno',
	'qp_result_error' => 'Sintaksna greška',
	'qp_vote_button' => 'Glasaj',
	'qp_vote_again_button' => 'Promijeni svoj glas',
	'qp_polls_list' => 'Prikaži sva glasanja',
	'qp_users_list' => 'Prikaži sve korisnike',
	'qp_browse_to_poll' => 'Pregledaj po $1',
	'qp_browse_to_user' => 'Pregledaj po $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|glas|glasa|glasova}}',
	'qp_source_link' => 'Izvor',
	'qp_stats_link' => 'Statistika',
	'qp_users_link' => 'Korisnici',
	'qp_voice_link' => 'Korisnički glas',
	'qp_voice_link_inv' => 'Korisnički glas?',
	'qp_user_polls_link' => 'Učestvovao u $1 {{PLURAL:$1|glasanju|glasanja}}',
	'qp_user_missing_polls_link' => 'Bez učešća',
	'qp_not_participated_link' => 'Nije učestvovao',
	'qp_order_by_username' => 'Pregled po korisničkim imenima',
	'qp_order_by_polls_count' => 'Pregled po broju glasova',
	'qp_results_line_qupl' => 'Stranica "$1" Anketa "$2": $3',
	'qp_results_line_qpl' => 'Stranica "$1" Anketa "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Stranica "$2" Anketa "$3" ]',
	'qp_func_no_such_poll' => 'Nema takve ankete ($1)',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'qp_source_link' => 'Zdroj',
	'qp_stats_link' => 'Statistika',
	'qp_users_link' => 'Uživatelé',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Imre
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de'] = array(
	'pollresults' => 'Abstimmungsergebnisse auf dieser Seite',
	'qpollwebinstall' => 'Installation/Aktualisierung von QPoll',
	'qp_desc' => 'Ermöglicht die Erstellung von Umfragen',
	'qp_desc-sp' => '[[Special:PollResults|Spezialseite]] zum Anzeigen von Abstimmungsergebnissen',
	'qp_result_NA' => 'Nicht beantwortet',
	'qp_result_error' => 'Syntaxfehler',
	'qp_vote_button' => 'Abstimmen',
	'qp_vote_again_button' => 'Stimme ändern',
	'qp_submit_attempts_left' => 'Noch {{PLURAL:$1|ist ein Versuch|sind $1 Versuche}} möglich',
	'qp_polls_list' => 'Alle Abstimmungen auflisten',
	'qp_users_list' => 'Alle Benutzer anzeigen',
	'qp_browse_to_poll' => 'Nach $1 wechseln',
	'qp_browse_to_user' => 'Nach $1 wechseln',
	'qp_browse_to_interpretation' => 'Nach $1 wechseln',
	'qp_votes_count' => '$1 {{PLURAL:$1|Stimme|Stimmen}}',
	'qp_source_link' => 'Quelle',
	'qp_stats_link' => 'Statistik',
	'qp_users_link' => 'Benutzer',
	'qp_voice_link' => 'Benutzerstimme',
	'qp_voice_link_inv' => 'Benutzerstimme?',
	'qp_user_polls_link' => 'Hat an $1 {{PLURAL:$1|Abstimmung|Abstimmungen}} teilgenommen',
	'qp_user_missing_polls_link' => 'Keine Teilnahme',
	'qp_not_participated_link' => 'Nicht teilgenommen',
	'qp_order_by_username' => 'Nach Benutzernamen ordnen',
	'qp_order_by_polls_count' => 'Nach Abstimmungszahl ordnen',
	'qp_results_line_qupl' => 'Seite „$1“ Abstimmung „$2“: $3',
	'qp_results_line_qpl' => 'Seite „$1“ Abstimmung „$2“: $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Seite „$2“ Abstimmung „$3“ ]',
	'qp_results_submit_attempts' => 'Abstimmversuche: $1',
	'qp_results_interpretation_header' => 'Auswertung der Antworten',
	'qp_results_short_interpretation' => 'Kurzauswertung',
	'qp_results_long_interpretation' => 'Ausführliche Auswertung',
	'qp_results_structured_interpretation' => 'Strukturierte Auswertung',
	'qp_poll_has_no_interpretation' => 'Diese Abstimmung verfügt über keine Auswertungsvorlage im Kopfbereich',
	'qp_interpetation_wrong_answer' => 'Falsche Antwort',
	'qp_export_to_xls' => 'Statistiken in das XLS-Format exportieren',
	'qp_voices_to_xls' => 'Stimmen im XLS-Format exportieren',
	'qp_interpretation_results_to_xls' => 'Auswertungen der Antworten im XLS-Format exportieren',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|Benutzer|Benutzer}} haben auf die Fragen geantwortet',
	'qp_func_no_such_poll' => 'Abstimmung nicht vorhanden ($1)',
	'qp_func_missing_question_id' => 'Bitte lege eine vorhandene Fragekennung (ab 1 aufwärts) für die Abstimmung $1 fest.',
	'qp_func_invalid_question_id' => 'Ungültige Fragekennung $2 (keine Nummer) für die Abstimmung $1',
	'qp_func_missing_proposal_id' => 'Bitte lege eine existierende Vorschlagskennung für die Abstimmung $1 fest (ab 0 aufwärts), Frage $2.',
	'qp_func_invalid_proposal_id' => 'Ungültige Vorschlagskennung $3 (keine Nummer) für die Abstimmung $1, Frage $2',
	'qp_error_no_such_poll' => 'Abstimmung nicht vorhanden ($1).
Stelle sicher, dass die Abstimmung festgelegt und gespeichert ist und dass # als Trennsymbol für Adressen verwendet wird',
	'qp_error_in_question_header' => 'Ungültige Bezeichnung: $1',
	'qp_error_id_in_stats_mode' => 'Kann keine Kennung für diese Abstimmung im Statistik-Modus festlegen.',
	'qp_error_dependance_in_stats_mode' => 'Kann Abhängigkeitskette der Abstimmung im statistischen Modus nicht festlegen',
	'qp_error_no_stats' => 'Es sind keine statistischen Daten verfügbar, da noch niemand für diese Abstimmung gestimmt hat (Adresse $1)',
	'qp_error_address_in_decl_mode' => 'Kann keine Adresse der Abstimmung im Festlegungs-Modus ermitteln',
	'qp_error_question_not_implemented' => 'Fragen diesen Typs sind nicht implementiert: $1',
	'qp_error_question_empty_body' => 'Es wurde keine Frage eingegeben.',
	'qp_error_question_no_proposals' => 'Zur Frage wurden keine Antwortvorschläge festgelegt.',
	'qp_error_invalid_question_type' => 'Ungültiger Fragetyp: $1',
	'qp_error_invalid_question_name' => 'Ungültiger Name: $1',
	'qp_error_type_in_stats_mode' => 'Der Fragetyp kann im statistischen Anzeigemodus nicht definiert werden: $1',
	'qp_error_no_poll_id' => 'Für das Abstimmungs-Tag wurde keine Abstimmungskennung definiert.',
	'qp_error_invalid_poll_id' => 'Ungültige Abstimmungskennung ($1).
Die Abstimmungskennung darf nur Buchstaben, Zahlen und Leerstellen enthalten.',
	'qp_error_already_used_poll_id' => 'Die Abstimmungskennung wurde bereits auf dieser Seite benutzt (Kennung $1).',
	'qp_error_too_long_dependance_value' => 'Das Abhängigkeitsattribut (Abhängigkeit „$2“) der Abstimmung (Kennung $1) ist zu lang, um in der Datenbank gespeichert werden zu können.',
	'qp_error_invalid_dependance_value' => 'Die Abhängigkeitskette der Abstimmung (Kennung $1) hat einen ungültigen Wert in dem Abhängigkeitssttribut (Abhängigkeit „$2“)',
	'qp_error_missed_dependance_title' => 'Die Abstimmung (Kennung $1) ist abhängig von einer anderen Abstimmung (Kennung $3) auf der Seite [[$2]], aber der Titel [[$2]] wurde nicht gefunden.
Entferne entweder die Abhängigkeitsattribute, oder stelle [[$2]] wieder her.',
	'qp_error_missed_dependance_poll' => 'Die Abstimmung (Kennung $1) ist abhängig von einer anderen Abstimmung (Kennung $3) auf Seite $2, welche aber nicht vorhanden ist noch nicht gespeichert wurde.
Entferne entweder die Abhängigkeitsattribute oder erstelle die Abstimmung mit Kennung $3 auf Seite $2 und speichere sie.
Um die Abstimmung zu speichern, übermittle sie ohne dabei auf eine Frage zu antworten.',
	'qp_error_vote_dependance_poll' => 'Bitte erst für $1 abstimmen.',
	'qp_error_too_many_spans' => 'Es wurden zu viele Kategoriegruppen für die Gesamtanzahl der Unterkategorien definiert.',
	'qp_error_unanswered_span' => 'Unbeantwortete Unterrubrik',
	'qp_error_non_unique_choice' => 'Diese Frage erfordert einen einzelnen Antwortvorschlag.',
	'qp_error_category_name_empty' => 'Es wurde kein Name für die Kategorie angegeben.',
	'qp_error_proposal_text_empty' => 'Es wurde kein Text vorgeschlagen.',
	'qp_error_too_long_category_option_value' => 'Der Wert der Kategorieoption ist zu lang, um in der Datenbank gespeichert werden zu können.',
	'qp_error_too_long_category_options_values' => 'Die Werte der Kategorieoptionen sind zu lang, um in der Datenbank gespeichert werden zu können.',
	'qp_error_too_long_proposal_text' => 'Der vorgeschlagene Text ist zu lang, um in der Datenbank gespeichert werden zu können.',
	'qp_error_too_long_proposal_name' => 'Der vorgeschlagene Name ist zu lang, um in der Datenbank gespeichert werden zu können.',
	'qp_error_multiline_proposal_name' => 'Der vorgeschlagene Name darf keine Zeilenumbrüche enthalten.',
	'qp_error_numeric_proposal_name' => 'Der vorgeschlagene Name darf nicht ausschließlich aus Zahlen bestehen.',
	'qp_error_too_few_categories' => 'Es müssen mindestens zwei Kategorien festgelegt werden.',
	'qp_error_too_few_spans' => 'Jede Kategoriengruppe muss mindestens zwei Unterkategorien enthalten.',
	'qp_error_no_answer' => 'Unbeantworteter Vorschlag',
	'qp_error_not_enough_categories_answered' => 'Es wurden nicht genug Kategorien ausgewählt.',
	'qp_error_unique' => 'Die Frage des Typs unique() hat mehr Vorschläge, als mögliche Antworten definiert sind: Ausführung unmöglich',
	'qp_error_no_more_attempts' => 'Du hast die maximale Anzahl an Abstimmversuchen für diese Abstimmung erreicht',
	'qp_error_no_interpretation' => 'Das Auswertungsskript ist nicht vorhanden.',
	'qp_error_interpretation_no_return' => 'Das Auswertungsskript hat kein Ergebnis ermittelt',
	'qp_error_structured_interpretation_is_too_long' => 'Die strukturierte Auswertung ist zu lang, um in der Datenbank gespeichert werden zu können. Bitte das Auswertungsskript berichtigen.',
	'qp_error_no_json_decode' => 'Die Auswertung der Abstimmungsergebnisse erfordert die PHP-Funktion json_decode()',
	'qp_error_eval_missed_lang_attr' => 'Das XML-Attribut „lang“ wird benötigt, um die richtige Auswertungssprache auswählen zu können',
	'qp_error_eval_mix_languages' => 'Einzelne Auswertungsskripte können nicht unterschiedliche Auswertungssprachen kombinieren: „$1“, „$2“',
	'qp_error_eval_unsupported_language' => 'Nicht unterstützte Auswertungssprache „$1“',
	'qp_error_eval_illegal_token' => 'PHP-Token $1 mit Wert $2 ist in Zeile $3 nicht zulässig',
	'qp_error_eval_illegal_superglobal' => 'PHP-Token $1 mit Superglobal $2 ist in Zeile $3 nicht zulässig',
	'qp_error_eval_illegal_function_call' => 'PHP-Token $1 mit Funktion $2 ist in Zeile $3 nicht zulässig',
	'qp_error_eval_variable_variable_access' => 'PHP-Token $1 mit der veränderlichen Variable $2 ist in Zeile $3 nicht zulässig',
	'qp_error_eval_illegal_variable_name' => 'PHP-Token $1 mit dem nicht zulässigen Variablenname $2 ist in Zeile $3 nicht zulässig',
	'qp_error_eval_variable_function_call' => 'PHP-Token $1 mit der veränderlichen Funktion $2 ist in Zeile $3 nicht zulässig',
	'qp_error_eval_self_check' => 'Der folgende Selbsttest eval() ist gescheitert: $1. Es wird eine nicht unterstützte Version von PHP verwendet, welche die sichere Ausführung des Skripts eval() nicht zulässt.',
	'qp_error_eval_unable_to_lint' => 'Die statische Code-Analyse konnte nicht durchgeführt werden (bitte die Systemkonfiguration prüfen)',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'qp_func_missing_question_id' => 'Bitte legen Sie eine vorhandene Fragekennung (ab 1 aufwärts) für die Abstimmung $1 fest.',
	'qp_error_no_such_poll' => 'Abstimmung nicht vorhanden ($1).
Stellen Sie sicher, dass die Abstimmung festgelegt und gespeichert ist und dass # als Trennsymbol für Adressen verwendet wird',
	'qp_error_missed_dependance_title' => 'Die Abstimmung (Kennung $1) ist abhängig von einer anderen Abstimmung (Kennung $3) auf der Seite [[$2]], aber der Titel [[$2]] wurde nicht gefunden.
Entfernen Sie entweder die Abhängigkeitsattribute, oder stellen Sie [[$2]] wieder her.',
	'qp_error_missed_dependance_poll' => 'Die Abstimmung (Kennung $1) ist abhängig von einer anderen Abstimmung (Kennung $3) auf Seite $2, welche aber nicht vorhanden ist noch nicht gespeichert wurde.
Entfernen Sie entweder die Abhängigkeitsattribute oder erstellen Sie die Abstimmung mit Kennung $3 auf Seite $2 und speichern Sie sie.
Um die Abstimmung zu speichern, übermitteln Sie sie ohne dabei auf eine Frage zu antworten.',
	'qp_error_no_more_attempts' => 'Sie haben die maximale Anzahl an Abstimmversuchen für diese Abstimmung erreicht',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'pollresults' => 'Wuslědki napšašowanjow na toś tom sedle',
	'qp_desc' => 'Zmóžnja napóranje napšašowanjow',
	'qp_desc-sp' => '[[Special:PollResults|Specialny bok]] za woglědowanje wuslědkow napšašowanjow',
	'qp_result_NA' => 'Njewótgronjony',
	'qp_result_error' => 'Syntaksowa zmólka',
	'qp_vote_button' => 'Wótgłosowaś',
	'qp_vote_again_button' => 'Twójo wótgłosowanje změniś',
	'qp_polls_list' => 'Wše napšašowanja nalicyś',
	'qp_users_list' => 'Wšych wužywarjow nalicyś',
	'qp_browse_to_poll' => 'Dalej k $1',
	'qp_browse_to_user' => 'Dalej k $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|głos|głosa|głose|głosow}}',
	'qp_source_link' => 'Žrědło',
	'qp_stats_link' => 'Statistika',
	'qp_users_link' => 'Wužywarje',
	'qp_voice_link' => 'Wužywarski głos',
	'qp_voice_link_inv' => 'Wužywarski głos?',
	'qp_user_polls_link' => 'Jo se wobźělił na $1 {{PLURAL:$1|napšašowanju|napšašowanjoma|napšašowanjach|napšašowanjach}}',
	'qp_user_missing_polls_link' => 'Žedno wobźělenje',
	'qp_not_participated_link' => 'Njewobźělony',
	'qp_order_by_username' => 'Pórěd pó wužywarskem mjenju',
	'qp_order_by_polls_count' => 'Pórěd pó licbje napšašowanjow',
	'qp_results_line_qupl' => 'Bok "$1" napšašowanje "$2": $3',
	'qp_results_line_qpl' => 'Bok "$1" napšašowanje "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ bok "$2" napšašowanje "$3" ]',
	'qp_export_to_xls' => 'Statistiku do XLS-formata eksportěrowaś',
	'qp_voices_to_xls' => 'Głose do XLS-formata eksportěrowaś',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|wužywaŕ jo wótegronił|wužywarja stej wótegroniłej|wužywarje su wótegronili|wužywarjow jo wótegroniło}}',
	'qp_func_no_such_poll' => 'Take napšašowanje njejo ($1)',
	'qp_func_missing_question_id' => 'Pšosym pódaj eksistěrujucy ID pšašanja (zachopinajucy wót 1) za napšašowanje $1',
	'qp_func_invalid_question_id' => 'Njepłaśiwy ID=$2 pšašanja (žedna licba) za napšašowanje $1',
	'qp_func_missing_proposal_id' => 'Pšosym pódaj eksistěrujucy ID naraźenja (zachopinajucy wót 0) za napšašowanje $1, pšašanje $2',
	'qp_func_invalid_proposal_id' => 'Njepłaśiwy ID=$3 naraźenja (žedna licba) za napšašowanje $1, pšašanje $2',
	'qp_error_no_such_poll' => 'Take napšašowanje ($1) njejo.
Zawěsć, až napšašowanje se deklarěrujo a składujo, zawěsć se teke adresowe źěleńske znamuško # wužywaś',
	'qp_error_in_question_header' => 'Njepłaśiwy typ pšašanja: $1',
	'qp_error_id_in_stats_mode' => 'Njejo móžno ID napšašowanja w statistiskem modusu deklarěrowaś',
	'qp_error_dependance_in_stats_mode' => 'Njejo móžno rjeśak wótwisnosći napšašowanja w statistiskem modusu deklarěrowaś',
	'qp_error_no_stats' => 'Žedne statistiske daty k dispoziciji, dokulaž nichten njejo wótgłosował za toś to napšašowanje (adresa=$1)',
	'qp_error_address_in_decl_mode' => 'Njejo móžno adresu napšašowanja w deklaraciskem modusu dostaś',
	'qp_error_question_not_implemented' => 'Pšašanja takego typa njejsu implementěrowane: $1',
	'qp_error_invalid_question_type' => 'Njepłaśiwy typ pšašanja: $1',
	'qp_error_type_in_stats_mode' => 'Typ pšašanja njedajo se w statistiskem zwobraznjeńskem modusu definěrowaś: $1',
	'qp_error_no_poll_id' => 'Toflicka Poll njejo atribut ID definěrowana.',
	'qp_error_invalid_poll_id' => 'Njepłaśiwy napšašowański ID (ID=$1).
Napšašowański ID smějo jano pismiki, licby a prozne znamje wopśimjeś',
	'qp_error_already_used_poll_id' => 'Napšašowański ID jo se južo wužył na toś tom boku (ID=$1).',
	'qp_error_invalid_dependance_value' => 'Rjeśazk wótwisnosći napšašowanja (ID=$1) ma njepłaśiwu gódnotu atributa dependance (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Napšašowanje (ID=$1) jo wótwisne wót drugego napšašowanja (ID=$3) z boka [[$2]], ale titel [[$2]] njejo se namakał.
Wótpóraj pak atribut dependance pak wótnow [[$2]]',
	'qp_error_missed_dependance_poll' => 'Napšašowanje (ID=$1) jo wótwisne wót drugego napšašowanja (ID=$3) na boku $2, ale to napšašowanje njeeksistěrujo abo njejo se doněnta składło.
Wótpóraj pak atribut dependance pak napóraj napšašowanje z ID=$3 na boku $2 a składuj jo.
Aby składował napšašowanje, wótpósćel jo, mimo až sy wótegronił na naraźeńske pšašanja.',
	'qp_error_vote_dependance_poll' => 'Pšosym wótgłosuj nejpjerwjej za napšašowanje $1.',
	'qp_error_too_many_spans' => 'Pśewjele kategorijowych klasow za pódkategorije definěrowane',
	'qp_error_unanswered_span' => 'Pódkategorija bźez wótegrona',
	'qp_error_non_unique_choice' => 'Toś to pšašanje trjeba jadnorazne wótegrono naraźenja',
	'qp_error_category_name_empty' => 'Mě kategorije jo prozne',
	'qp_error_proposal_text_empty' => 'Tekst naraźenja jo prozny',
	'qp_error_too_few_categories' => 'Nanejmjenjej dwě kategorji musytej se definěrować',
	'qp_error_too_few_spans' => 'Kužda kategorijowa klasa trjeba nanejmjenjej dwě móžnej wótegronje',
	'qp_error_no_answer' => 'Naraźenje bźez wótegrona',
	'qp_error_unique' => 'Pšašanje typa unique() ma wěcej naraźenjow ako móžne wótegrona su definěrowane: njemóžno pókšacowaś',
);

/** Greek (Ελληνικά)
 * @author Egmontaz
 * @author ZaDiak
 */
$messages['el'] = array(
	'qp_result_NA' => 'Αναπάντητο',
	'qp_result_error' => 'Συντακτικό σφάλμα',
	'qp_vote_button' => 'Ψήφισε',
	'qp_vote_again_button' => 'Αλλαγή ψήφου',
	'qp_polls_list' => 'Καταγραφή όλων των δημοσκοπήσεων',
	'qp_users_list' => 'Καταγραφή όλων των χρηστών',
	'qp_browse_to_poll' => 'Πλοήγηση σε $1',
	'qp_browse_to_user' => 'Πλοήγηση σε $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|ψήφος|ψήφοι}}',
	'qp_source_link' => 'Πηγή',
	'qp_stats_link' => 'Στατιστικά',
	'qp_users_link' => 'Χρήστες',
	'qp_voice_link' => 'Φωνή χρήστη',
	'qp_voice_link_inv' => 'Φωνή χρήστη;',
	'qp_user_polls_link' => 'Συμμετοχή σε $1 {{PLURAL:$1|δημοσκόπηση|δημοσκοπήσεις}}',
	'qp_user_missing_polls_link' => 'Καμία συμμετοχή',
	'qp_not_participated_link' => 'Δεν συμμετείχε',
	'qp_order_by_username' => 'Ταξινόμηση κατά όνομα χρήστη',
	'qp_results_line_qupl' => 'Σελίδα "$1" Δημοσκόπηση "$2": $3',
	'qp_func_no_such_poll' => 'Καμιά τέτοια δημοσκόπηση ($1)',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'qp_result_error' => 'Sintaksa eraro',
	'qp_vote_button' => 'Voĉdoni',
	'qp_source_link' => 'Fonto',
	'qp_stats_link' => 'Statistikoj',
	'qp_users_link' => 'Uzantoj',
);

/** Spanish (Español)
 * @author Imre
 * @author Translationista
 */
$messages['es'] = array(
	'pollresults' => 'Resultados de las encuestas en esta página',
	'qp_desc' => 'Permite la creación de encuestas',
	'qp_desc-sp' => '[[Special:PollResults|Página especial]] para ver los resultados de las encuestas',
	'qp_result_NA' => 'No respondido',
	'qp_result_error' => 'Error de sintaxis',
	'qp_vote_button' => 'Vota',
	'qp_vote_again_button' => 'Cambia tu voto',
	'qp_polls_list' => 'Lista todas las encuestas',
	'qp_users_list' => 'Hacer una lista de todos los usuarios',
	'qp_browse_to_poll' => 'Navegar a $1',
	'qp_browse_to_user' => 'Navegar a $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|voto|votos}}',
	'qp_source_link' => 'Fuente',
	'qp_stats_link' => 'Estadísticas',
	'qp_users_link' => 'Usuarios',
	'qp_voice_link' => 'Voz de usuario',
	'qp_voice_link_inv' => '¿Voz de usuario?',
	'qp_user_polls_link' => 'Ha participado en $1 {{PLURAL:$1|sondeo|sondeos}}',
	'qp_user_missing_polls_link' => 'No participación',
	'qp_not_participated_link' => 'No ha participado',
	'qp_order_by_username' => 'Organizar por nombre de usuario',
	'qp_order_by_polls_count' => 'Ordenar por conteo de encuestas',
	'qp_results_line_qupl' => 'Página "$1" Votación "$2": $3',
	'qp_results_line_qpl' => 'Página "$1" Votación "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Página "$2" Votación "$3" ]',
	'qp_export_to_xls' => 'Exportar estadísticas a formato XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|usuario ha|usuarios han}} respondido a las preguntas',
	'qp_func_no_such_poll' => 'No hay votación ($1)',
	'qp_func_missing_question_id' => 'Por favor, especifica un identificador de pregunta existente (a partir de 1) para la encuesta $1',
	'qp_func_invalid_question_id' => 'Pregunta inválida id=$2 (no es un número) para la encuesta $1',
	'qp_func_missing_proposal_id' => 'Por favor, especifica un identificador de propuesta que exista (comenzando a partir de 0) para la encuesta $1, pregunta $2',
	'qp_func_invalid_proposal_id' => 'Identificador de propuesta inválido=$3 (no es un número) para la encuesta $1, pregunta $2',
	'qp_error_no_such_poll' => 'No existe tal encuesta ($1).
Asegúrate de que la encuesta está declarada y guardada, y no olvides usar el carácter delimitador de dirección #',
	'qp_error_in_question_header' => 'Encabezado de pregunta inválido: $1',
	'qp_error_id_in_stats_mode' => 'No se puede declarar una ID de encuesta en modo estadístico',
	'qp_error_dependance_in_stats_mode' => 'No se puede declarar una cadena de dependencia para la encuesta en modo estadístico',
	'qp_error_no_stats' => 'No hay datos estadísticos disponibles porque nadie ha votado aún en esta encuesta (dirección=$1)',
	'qp_error_address_in_decl_mode' => 'No se puede obtener una dirección de la encuesta en modo declarativo',
	'qp_error_question_not_implemented' => 'Las preguntas de este tipo no están implementadas: $1',
	'qp_error_invalid_question_type' => 'Tipo de pregunta inválido: $1',
	'qp_error_type_in_stats_mode' => 'El tipo de pregunta no puede definirse en modo de visualización estadística: $1',
	'qp_error_no_poll_id' => 'La etiqueta de la encuesta no tiene atributo de id definido.',
	'qp_error_invalid_poll_id' => 'El id de la encuesta no es válido (id=$1).
El id sólo puede contener letras, números y espacios',
	'qp_error_already_used_poll_id' => 'El identificador de encuesta ya se ha utilizado en esta página (id=$1).',
	'qp_error_invalid_dependance_value' => 'La cadena de dependencia de la encuesta (id=$1) tiene un valor inválido de atributo de dependencia (dependencia="$2")',
	'qp_error_missed_dependance_title' => 'La encuesta (id=$1) es dependiente de otra encuesta, (id =$3), de la página [[$2]], pero el título de [[$2]] no se ha encontrado. Elimina el atributo de dependencia, o restaura [[$2] ]',
	'qp_error_missed_dependance_poll' => 'La encuesta (id=$1) es dependiente de la encuesta (id=$3) en la página $2, pero esa encuesta no existe o aún no se ha guardado. Elimina el atributo de la dependencia o crea la encuesta con id=$3 en la página de $2 y guárdala. Para guardar una encuesta, envíala sin responder a las preguntas.',
	'qp_error_vote_dependance_poll' => 'Por favor, vota primero en la encuesta $1.',
	'qp_error_too_many_spans' => 'Muchas clases de categorías para las subcategorías definidas',
	'qp_error_unanswered_span' => 'Subcategoría sin responder',
	'qp_error_non_unique_choice' => 'Esta pregunta requiere una propuesta de respuesta única',
	'qp_error_category_name_empty' => 'El nombre de categoría está vacío',
	'qp_error_proposal_text_empty' => 'El texto de propuesta está vacío',
	'qp_error_too_few_categories' => 'Se debe definir al menos dos categorías',
	'qp_error_too_few_spans' => 'Cada clase de categoría requiere de al menos dos respuestas possibles definidas',
	'qp_error_no_answer' => 'Propuesta no respondida',
	'qp_error_unique' => 'La pregunta de tipo único() tiene definidas más propuestas que respuestas posibles: imposible completar',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Str4nd
 * @author Tofu II
 */
$messages['fi'] = array(
	'qp_result_NA' => 'Ei vastattu',
	'qp_result_error' => 'Syntaksivirhe',
	'qp_vote_button' => 'Äänestä',
	'qp_vote_again_button' => 'Vaihda ääntäsi',
	'qp_users_list' => 'Lista kaikista käyttäjistä',
	'qp_votes_count' => '$1 {{PLURAL:$1|ääni|ääntä}}',
	'qp_source_link' => 'Lähde',
	'qp_stats_link' => 'Tilastot',
	'qp_users_link' => 'Käyttäjät',
	'qp_order_by_username' => 'Lajittele käyttäjänimen mukaan',
	'qp_export_to_xls' => 'Vie tilastot XLS-muotoon',
	'qp_error_category_name_empty' => 'Luokan nimi on tyhjä',
	'qp_error_proposal_text_empty' => 'Ehdotusteksti on tyhjä',
	'qp_error_too_few_categories' => 'Ainakin kaksi luokkaa pitää määritellä',
	'qp_error_no_answer' => 'Vastaamaton ehdotus',
);

/** French (Français)
 * @author Crochet.david
 * @author DavidL
 * @author Gomoko
 * @author Hashar
 * @author IAlex
 * @author Jean-Frédéric
 * @author McDutchie
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'pollresults' => 'Résultats des sondages sur ce site',
	'qpollwebinstall' => "Installation / mise à jour de l'extension QPoll",
	'qp_desc' => 'Permet la création de sondages',
	'qp_desc-sp' => '[[Special:PollResults|Page spéciale]] pour consulter les résultats des sondages',
	'qp_result_NA' => 'Pas de réponse',
	'qp_result_error' => 'Erreur de syntaxe',
	'qp_vote_button' => 'Vote',
	'qp_vote_again_button' => 'Changer votre vote',
	'qp_submit_attempts_left' => '$1 {{PLURAL:$1|tentative restante|tentatives restantes}}',
	'qp_polls_list' => 'Lister tous les sondages',
	'qp_users_list' => 'Lister tous les utilisateurs',
	'qp_browse_to_poll' => 'Aller jusqu’à $1',
	'qp_browse_to_user' => 'Aller jusqu’à $1',
	'qp_browse_to_interpretation' => "Naviguer jusqu'à $1",
	'qp_votes_count' => '$1 {{PLURAL:$1|vote|votes}}',
	'qp_source_link' => 'Source',
	'qp_stats_link' => 'Statistiques',
	'qp_users_link' => 'Utilisateurs',
	'qp_voice_link' => 'Voix de l’utilisateur',
	'qp_voice_link_inv' => 'Voix de l’utilisateur ?',
	'qp_user_polls_link' => 'A participé à $1 {{PLURAL:$1|sondage|sondages}}',
	'qp_user_missing_polls_link' => 'Pas de participation',
	'qp_not_participated_link' => 'Pas de participation',
	'qp_order_by_username' => 'Trier par nom d’utilisateur',
	'qp_order_by_polls_count' => 'Trier par nombre de sondages',
	'qp_results_line_qupl' => 'Page « $1 » Sondage « $2 » : $3',
	'qp_results_line_qpl' => 'Page « $1 » Sondage « $2 » : $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Page « $2 » Sondage « $3 » ]',
	'qp_results_submit_attempts' => 'Tentatives de soumission: $1',
	'qp_results_interpretation_header' => 'Interprétation de la réponse',
	'qp_results_short_interpretation' => 'Interprétation résumée',
	'qp_results_long_interpretation' => 'Interprétation longue',
	'qp_results_structured_interpretation' => 'Interprétation structurée',
	'qp_poll_has_no_interpretation' => "Ce scrutin n'a pas de modèle d'interprétation défini dans son entête.",
	'qp_interpetation_wrong_answer' => 'Mauvaise réponse',
	'qp_export_to_xls' => 'Exporter les statistiques au format XLS',
	'qp_voices_to_xls' => 'Exporter les votes au format XLS',
	'qp_interpretation_results_to_xls' => 'Exporter les interprétations de réponse au format XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|utilisateur a|utilisateurs ont}} répondu aux questions',
	'qp_func_no_such_poll' => 'Ce sondage n’existe pas ($1)',
	'qp_func_missing_question_id' => 'Veuillez spécifier un id question existant (à partir de 1) pour le sondage $1',
	'qp_func_invalid_question_id' => 'id question=$2 invalide (pas un nombre) pour le sondage $1',
	'qp_func_missing_proposal_id' => 'Veuillez spécifier un id proposition existant (à partir de 0) pour le sondage $1, question $2',
	'qp_func_invalid_proposal_id' => 'id proposition=$3 invalide (pas un nombre) pour le sondage $1, question $2',
	'qp_error_no_such_poll' => 'Ce sondage n’existe pas ($1).
Assurez-vous que le sondage soit déclaré et sauvegardé. Vérifiez également si vous utilisez le caractère délimiteur d’adresse #',
	'qp_error_in_question_header' => 'En-tête de question incorrect : $1',
	'qp_error_id_in_stats_mode' => 'Impossible de déclarer un ID du sondage dans le mode statistique',
	'qp_error_dependance_in_stats_mode' => 'Impossible de déclarer la chaîne de dépendance du sondage en mode statistique',
	'qp_error_no_stats' => 'Aucune donnée statistique n’est disponible, car personne n’a répondu à ce sondage pour l’instant (address=$1)',
	'qp_error_address_in_decl_mode' => 'Impossible d’obtenir une adresse du sondage en mode déclaratif',
	'qp_error_question_not_implemented' => 'Les questions de ce type ne sont pas implémentées : $1',
	'qp_error_question_empty_body' => 'Le corps de la question est vide.',
	'qp_error_question_no_proposals' => "La question n'a aucune proposition définie.",
	'qp_error_invalid_question_type' => 'Type de question invalide : $1',
	'qp_error_invalid_question_name' => 'Nom de question invalide:  $1.',
	'qp_error_type_in_stats_mode' => 'Le type de question ne peut pas être défini en mode d’affichage statistique : $1',
	'qp_error_no_poll_id' => 'La balise du sondage n’a pas d’identifiant défini.',
	'qp_error_invalid_poll_id' => 'Identifiant de sondage invalide (id=$1).
L’identifiant de sondage peut contenir uniquement des lettres, des nombres et le caractère espace',
	'qp_error_already_used_poll_id' => 'L’identifiant de sondage a déjà été utilisé sur cette page (id=$1).',
	'qp_error_too_long_dependance_value' => 'La valeur de l\'attribut de dépendance (dependance="$2") du sondage (id=$1) est trop longue pour être stocké dans la base de données.',
	'qp_error_invalid_dependance_value' => 'La chaîne de dépendance du sondage (id=$1) a une valeur invalide pour l’attribut de dépendance (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Le sondage (i=$1) dépend d’un autre sondage (id=$3) de la page [[$2]], mais le titre [[$2]] n’a pas été trouvé.
Supprimez l’attribut de dépendance, ou bien restaurez [[$2]]',
	'qp_error_missed_dependance_poll' => 'Le sondage (id=$1) dépend d’un autre sondage (id=$3) à la page $2, mais ce sondage n’existe pas ou n’a pas encore été enregistré.
Supprimez l’attribut de dépendance, ou bien créez le sondage $3 à la page $2 et enregistrez-le.
Pour enregistrer un sondage, soumettez-le en ne répondant à aucune question de proposition.',
	'qp_error_vote_dependance_poll' => 'Veuillez d’abord répondre au sondage $1.',
	'qp_error_too_many_spans' => 'Trop de classes de catégories pour les sous-catégories définies',
	'qp_error_unanswered_span' => 'Sous-catégorie sans réponse',
	'qp_error_non_unique_choice' => 'Cette question nécessite une réponse de proposition unique',
	'qp_error_category_name_empty' => 'Le nom de la catégorie est vide',
	'qp_error_proposal_text_empty' => 'Le texte de la proposition est vide',
	'qp_error_too_long_category_option_value' => "La valeur de l'option catégorie est trop longue pour être stockée dans la base de données.",
	'qp_error_too_long_category_options_values' => 'Les valeurs des options catégorie sont trop longues pour être stockées dans la base de données.',
	'qp_error_too_long_proposal_text' => 'Le texte de la proposition est trop long pour être enregistré dans la base de données',
	'qp_error_too_long_proposal_name' => 'Le nom de la proposition est trop long pour être stocké dans la base de données.',
	'qp_error_multiline_proposal_name' => 'Le nom de la proposition ne peut pas contenir plusieurs lignes de texte.',
	'qp_error_numeric_proposal_name' => 'Le nom de la proposition ne peut pas être numérique.',
	'qp_error_too_few_categories' => 'Au moins deux catégories doivent être définies',
	'qp_error_too_few_spans' => 'Toute classe de catégorie nécessite au moins deux réponses possibles définies',
	'qp_error_no_answer' => 'Proposition sans réponse',
	'qp_error_not_enough_categories_answered' => 'Pas assez de catégories sélectionnées.',
	'qp_error_unique' => 'La question de type unique() a plus de propositions qu’il n’y a de réponses possibles définies : impossible de compléter',
	'qp_error_no_more_attempts' => 'Vous avez atteint le nombre maximal de tentatives de soumission pour ce sondage.',
	'qp_error_no_interpretation' => "Le script d'interprétation n'existe pas.",
	'qp_error_interpretation_no_return' => "Le script d'interprétation n'a renvoyé aucun résultat.",
	'qp_error_structured_interpretation_is_too_long' => "L'interprétation structurée est trop longue pour être stockée dans la base de données. Merci de corriger votre script d'interprétation.",
	'qp_error_no_json_decode' => "L'interprétation des réponses au sondage nécessite la fonction PHP json_decode().",
	'qp_error_eval_missed_lang_attr' => 'L\'attribut XML "lang" est obligatoire pour choisir la bonne langue d\'interprétation.',
	'qp_error_eval_mix_languages' => 'Un même script d\'interprétation ne peut pas mélanger différentes langues d\'interprétation: "$1", $2".',
	'qp_error_eval_unsupported_language' => 'Langue "$1" d\'interprétation non supportée.',
	'qp_error_eval_illegal_token' => "L'élément PHP $1 avec la valeur $2 n'est pas autorisé en ligne $3.",
	'qp_error_eval_illegal_superglobal' => "L'élément PHP $1 avec la superglobale $2 n'est pas autorisé en ligne $3.",
	'qp_error_eval_illegal_function_call' => "L'élément PHP $1 avec la fonction $2 n'est pas autorisé en ligne $3.",
	'qp_error_eval_variable_variable_access' => "L'élément PHP $1 avec la variable $2 n'est pas autorisé en ligne $3.",
	'qp_error_eval_illegal_variable_name' => "L'élément PHP $1 a rejeté le nom de variable $2 en ligne $3.",
	'qp_error_eval_variable_function_call' => "L'élément PHP $1 avec la fonction variable $2 n'est pas autorisé en ligne $3.",
	'qp_error_eval_self_check' => "L'auto-vérification eval() suivante a échoué: $1. Votre version de PHP n'est pas supportée, ce qui ne permet pas d'exécuter des scripts d'évaluation de façon sûre.",
	'qp_error_eval_unable_to_lint' => 'Impossible de contrôler (lint). Vérifiez la configuration de votre système.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'pollresults' => 'Rèsultats des sondâjos sur ceti seto',
	'qp_desc' => 'Pèrmèt la crèacion de sondâjos.',
	'qp_desc-sp' => '[[Special:PollResults|Pâge spèciâla]] por vêre los rèsultats des sondâjos',
	'qp_result_NA' => 'Pas rèpondu',
	'qp_result_error' => 'Èrror de sintaxa',
	'qp_vote_button' => 'Votar',
	'qp_vote_again_button' => 'Changiér voutron voto',
	'qp_submit_attempts_left' => '$1 {{PLURAL:$1|tentativa que réste|tentatives que réstont}}',
	'qp_polls_list' => 'Listar tôs los sondâjos',
	'qp_users_list' => 'Listar tôs los utilisators',
	'qp_browse_to_poll' => 'Navegar tant qu’a $1',
	'qp_browse_to_user' => 'Navegar tant qu’a $1',
	'qp_browse_to_interpretation' => 'Navegar tant qu’a $1',
	'qp_votes_count' => '$1 voto{{PLURAL:$1||s}}',
	'qp_source_link' => 'Sôrsa',
	'qp_stats_link' => 'Statistiques',
	'qp_users_link' => 'Usanciérs',
	'qp_voice_link' => 'Vouèx a l’usanciér',
	'qp_voice_link_inv' => 'Vouèx a l’usanciér ?',
	'qp_user_polls_link' => 'At participâ a $1 sondâjo{{PLURAL:$1||s}}',
	'qp_user_missing_polls_link' => 'Gins de participacion',
	'qp_not_participated_link' => 'At pas participâ',
	'qp_order_by_username' => 'Triyér per nom d’utilisator',
	'qp_order_by_polls_count' => 'Triyér per nombro de sondâjos',
	'qp_results_line_qupl' => 'Pâge « $1 » Sondâjo « $2 » : $3',
	'qp_results_line_qpl' => 'Pâge « $1 » Sondâjo « $2 » : $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Pâge « $2 » Sondâjo « $3 » ]',
	'qp_results_submit_attempts' => 'Tentatives de somission : $1',
	'qp_results_interpretation_header' => 'Entèrprètacion de la rèponsa',
	'qp_results_short_interpretation' => 'Côrta entèrprètacion',
	'qp_results_long_interpretation' => 'Entèrprètacion longe',
	'qp_interpetation_wrong_answer' => 'Crouye rèponsa',
	'qp_export_to_xls' => 'Èxportar les statistiques u format XLS',
	'qp_voices_to_xls' => 'Èxportar los votos u format XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|usanciér a|usanciérs on}}t rèpondu a les quèstions',
	'qp_func_no_such_poll' => 'Lo sondâjo ègziste pas ($1)',
	'qp_error_in_question_header' => 'En-téta de quèstion fôssa : $1',
	'qp_error_invalid_question_type' => 'Tipo de quèstion envalido : $1',
	'qp_error_vote_dependance_poll' => 'Volyéd d’abôrd rèpondre u sondâjo $1.',
	'qp_error_unanswered_span' => 'Sot-catègorie sen rèponsa',
	'qp_error_category_name_empty' => 'Lo nom de la catègorie est vouedo',
	'qp_error_proposal_text_empty' => 'Lo tèxto de la proposicion est vouedo',
	'qp_error_no_answer' => 'Proposicion sen rèponsa',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'pollresults' => 'Resultados das enquisas desta páxina',
	'qpollwebinstall' => 'Instalación / actualización da extensión QPoll',
	'qp_desc' => 'Permite a creación de enquisas',
	'qp_desc-sp' => '[[Special:PollResults|Páxina especial]] para ollar os resultados das enquisas',
	'qp_result_NA' => 'Sen resposta',
	'qp_result_error' => 'Erro de sintaxe',
	'qp_vote_button' => 'Votar',
	'qp_vote_again_button' => 'Cambiar o seu voto',
	'qp_submit_attempts_left' => '$1 {{PLURAL:$1|intento restante|intentos restantes}}',
	'qp_polls_list' => 'Lista de todas as enquisas',
	'qp_users_list' => 'Lista de todos os usuarios',
	'qp_browse_to_poll' => 'Navegar ata $1',
	'qp_browse_to_user' => 'Navegar ata $1',
	'qp_browse_to_interpretation' => 'Navegar ata $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|voto|votos}}',
	'qp_source_link' => 'Fonte',
	'qp_stats_link' => 'Estatísticas',
	'qp_users_link' => 'Usuarios',
	'qp_voice_link' => 'Voz do usuario',
	'qp_voice_link_inv' => 'Voz do usuario?',
	'qp_user_polls_link' => 'Participou {{PLURAL:$1|nunha enquisa|en $1 enquisas}}',
	'qp_user_missing_polls_link' => 'Non participou',
	'qp_not_participated_link' => 'Non participou',
	'qp_order_by_username' => 'Ordenar por nome de usuario',
	'qp_order_by_polls_count' => 'Ordenar por número de enquisa',
	'qp_results_line_qupl' => 'Páxina "$1", enquisa "$2": $3',
	'qp_results_line_qpl' => 'Páxina "$1", enquisa "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Páxina "$2", enquisa "$3" ]',
	'qp_results_submit_attempts' => 'Intentos de envío: $1',
	'qp_results_interpretation_header' => 'Interpretación da resposta',
	'qp_results_short_interpretation' => 'Interpretación curta',
	'qp_results_long_interpretation' => 'Interpretación longa',
	'qp_results_structured_interpretation' => 'Interpretación estruturada',
	'qp_poll_has_no_interpretation' => 'Esta enquisa non ten ningún modelo de interpretación definido na súa cabeceira.',
	'qp_interpetation_wrong_answer' => 'Resposta incorrecta',
	'qp_export_to_xls' => 'Exportar as estatísticas en formato XLS',
	'qp_voices_to_xls' => 'Exportar as voces en formato XLS',
	'qp_interpretation_results_to_xls' => 'Exportar as interpretacións da resposta en formato XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|usuario respondeu|usuarios responderon}} ás preguntas',
	'qp_func_no_such_poll' => 'Non existe tal enquisa ($1)',
	'qp_func_missing_question_id' => 'Por favor, especifique o id dunha pregunta existente (a partir de 1) para a enquisa $1.',
	'qp_func_invalid_question_id' => 'question id=$2 (non un número) non válido para a enquisa $1.',
	'qp_func_missing_proposal_id' => 'Por favor, especifique o id dunha proposta existente (a partir de 0) para a enquisa $1, pregunta $2.',
	'qp_func_invalid_proposal_id' => 'proposal id=$3 (non un número) non válido para a enquisa $1, pregunta $2.',
	'qp_error_no_such_poll' => 'Non existe tal enquisa ($1).
Asegúrese de que a enquisa está declarada e gardada, non esqueza usar o carácter delimitador de enderezo #.',
	'qp_error_in_question_header' => 'Cabeceira de pregunta non válida: $1.',
	'qp_error_id_in_stats_mode' => 'Non se pode declarar un ID da enquisa no modo de estatística.',
	'qp_error_dependance_in_stats_mode' => 'Non se pode declarar a cadea de dependencia da enquisa no modo de estatística.',
	'qp_error_no_stats' => 'Non hai datos estatísticos dispoñibles porque aínda ninguén votou nesta enquisa (address=$1).',
	'qp_error_address_in_decl_mode' => 'Non se pode obter un enderezo da enquisa no modo de declaración.',
	'qp_error_question_not_implemented' => 'As preguntas deste tipo non están implementadas: $1.',
	'qp_error_question_empty_body' => 'O corpo da pregunta está baleiro.',
	'qp_error_question_no_proposals' => 'A pregunta non ten definida ningunha proposta.',
	'qp_error_invalid_question_type' => 'Tipo de pregunta non válido: $1.',
	'qp_error_invalid_question_name' => 'Nome de pregunta non válido: $1.',
	'qp_error_type_in_stats_mode' => 'O tipo de pregunta non se pode definir no modo de vista estatística: $1.',
	'qp_error_no_poll_id' => 'A etiqueta da enquisa non ten ningún atributo id definido.',
	'qp_error_invalid_poll_id' => 'O id da enquisa non é válido (id=$1).
O id só pode conter letras, números e espazos.',
	'qp_error_already_used_poll_id' => 'O id da enquisa xa se empregou nesta páxina (id=$1).',
	'qp_error_too_long_dependance_value' => 'O valor do atributo de dependencia (dependencia="$2") da enquisa (id=$1) é longo de máis e a base de datos non o pode almacenar.',
	'qp_error_invalid_dependance_value' => 'A cadea de dependencia da enquisa (id=$1) ten un valor non válido para o atributo de dependencia (dependance="$2").',
	'qp_error_missed_dependance_title' => 'A enquisa (id=$1) depende doutra enquisa (id=$3) da páxina [[$2]], pero non se atopou o título [[$2]].
Elimine o atributo de dependencia ou restaure [[$2]].',
	'qp_error_missed_dependance_poll' => 'A enquisa (id=$1) depende doutra enquisa (id=$3) na páxina $2, pero esa enquisa non existe ou aínda non foi gardada.
Elimine o atributo de dependencia ou cree a enquisa co id=$3 na páxina $2 e gárdea.
Para gardar unha enquisa, envíea sen responder a ningunha pregunta.',
	'qp_error_vote_dependance_poll' => 'Por favor, vote primeiro na enquisa $1.',
	'qp_error_too_many_spans' => 'Demasiadas clases de categoría para as subcategorías definidas.',
	'qp_error_unanswered_span' => 'Subcategoría sen resposta.',
	'qp_error_non_unique_choice' => 'Esta pregunta require unha resposta única.',
	'qp_error_category_name_empty' => 'O nome da categoría está baleiro.',
	'qp_error_proposal_text_empty' => 'O texto da proposta está baleiro.',
	'qp_error_too_long_category_option_value' => 'O valor da opción da categoría é longo de máis para almacenalo na base de datos.',
	'qp_error_too_long_category_options_values' => 'Os valores das opcións da categoría son longos de máis para almacenalos na base de datos.',
	'qp_error_too_long_proposal_text' => 'O texto da proposta é longo de máis para almacenalo na base de datos.',
	'qp_error_too_long_proposal_name' => 'O nome da proposta é longo de máis para almacenalo na base de datos.',
	'qp_error_multiline_proposal_name' => 'O nome da proposta non pode conter múltiples liñas de texto.',
	'qp_error_numeric_proposal_name' => 'O nome da proposta non pode ser numérico.',
	'qp_error_too_few_categories' => 'Débense definir, polo menos, dúas categorías.',
	'qp_error_too_few_spans' => 'Cada clase de categoría necesita definidas, polo menos, dúas respostas posibles.',
	'qp_error_no_answer' => 'Proposta sen resposta.',
	'qp_error_not_enough_categories_answered' => 'Non abondan as categorías seleccionadas.',
	'qp_error_unique' => 'A pregunta de tipo unique() ten definidas máis propostas que respostas posibles: Imposible de completar.',
	'qp_error_no_more_attempts' => 'Alcanzou o número máximo de intentos de envío para esta enquisa.',
	'qp_error_no_interpretation' => 'A escritura de interpretación non existe.',
	'qp_error_interpretation_no_return' => 'A escritura de interpretación non devolveu resultados.',
	'qp_error_structured_interpretation_is_too_long' => 'A interpretación estruturada é longa de máis para almacenala na base de datos. Corrixa a súa escritura de interpretación.',
	'qp_error_no_json_decode' => 'A interpretación das respostas ás enquisas necesitan a función PHP json_decode().',
	'qp_error_eval_missed_lang_attr' => 'Cómpre o atributo XML "lang" para elixir a lingua de interpretación axeitada.',
	'qp_error_eval_mix_languages' => 'Unha mesma escritura de interpretación non pode mesturar diferentes linguas de interpretación: "$1", "$2".',
	'qp_error_eval_unsupported_language' => 'A lingua de interpretación "$1" non está soportada.',
	'qp_error_eval_illegal_token' => 'O pase PHP $1 co valor $2 non está permitido na liña $3.',
	'qp_error_eval_illegal_superglobal' => 'O pase PHP $1 co valor superglobal $2 non está permitido na liña $3.',
	'qp_error_eval_illegal_function_call' => 'O pase PHP $1 coa función $2 non está permitido na liña $3.',
	'qp_error_eval_variable_variable_access' => 'O pase PHP $1 coa variable variable $2 non está permitido na liña $3.',
	'qp_error_eval_illegal_variable_name' => 'O pase PHP $1 rexeitou o nome de variable $2 na liña $3.',
	'qp_error_eval_variable_function_call' => 'O pase PHP $1 coa función variable $2 non está permitido na liña $3.',
	'qp_error_eval_self_check' => 'A seguinte comprobación automática eval() fallou: $1. Ten unha versión de PHP non soportada, que non permite executar escrituras de avaliación de xeito seguro.',
	'qp_error_eval_unable_to_lint' => 'Non se puido controlar (lint). Comprobe a configuración do seu sistema.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'qp_source_link' => 'Πηγή',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'pollresults' => 'Ergebnis vu dr Abstimmige uf däm Site',
	'qpollwebinstall' => 'Installation/Aktualisierig vo QPoll',
	'qp_desc' => 'Erlaubt s Aalege vu Abstimmige',
	'qp_desc-sp' => '[[Special:PollResults|Spezialsyte]] zum Aalueg vu dr Ergebnis vu dr Abstimmige',
	'qp_result_NA' => 'Kei Antwort',
	'qp_result_error' => 'Syntaxfähler',
	'qp_vote_button' => 'Abstimme',
	'qp_vote_again_button' => 'Dyy Stimm ändere',
	'qp_submit_attempts_left' => 'Noch {{PLURAL:$1|isch ei Versuech|sin $1 Versuech}} mögli',
	'qp_polls_list' => 'Alli Abstimmige uflischte',
	'qp_users_list' => 'Alli Benutzer uflischte',
	'qp_browse_to_poll' => 'Wyter zue $1',
	'qp_browse_to_user' => 'Wyter zue $1',
	'qp_browse_to_interpretation' => 'Wyter zue $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|Stimm|Stimme}}',
	'qp_source_link' => 'Quälle',
	'qp_stats_link' => 'Statischtik',
	'qp_users_link' => 'Benutzer',
	'qp_voice_link' => 'Benutzerstimm',
	'qp_voice_link_inv' => 'Benutzerstimm?',
	'qp_user_polls_link' => 'Mitgmacht bi $1 {{PLURAL:$1|Abstimmig|Abstimmige}}',
	'qp_user_missing_polls_link' => 'Niene mitgmacht',
	'qp_not_participated_link' => 'Niene mitgmacht',
	'qp_order_by_username' => 'No Benutzername gordnet',
	'qp_order_by_polls_count' => 'No Abstimmigsaazahl gordnet',
	'qp_results_line_qupl' => 'Syte „$1“ Abstimmig „$2“: $3',
	'qp_results_line_qpl' => 'Syte „$1“ Abstimmig „$2“: $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Syte „$2“ Abstimmig „$3“ ]',
	'qp_header_line_qucl' => '$1. $2<br />$3 ??? $4',
	'qp_results_submit_attempts' => 'Abstimmversuech: $1',
	'qp_results_interpretation_header' => 'Usswärtig vo de Antworte',
	'qp_results_short_interpretation' => 'Churzusswärtig',
	'qp_results_long_interpretation' => 'Ussfierlichi Usswärtig',
	'qp_results_structured_interpretation' => 'Strukturierti Usswärtig',
	'qp_poll_has_no_interpretation' => 'Die Abstimmig het kei Usswärtigsvorlag im Chopf',
	'qp_interpetation_wrong_answer' => 'Falschi Antwort',
	'qp_export_to_xls' => 'Statischtik im XLS-Format exportiere',
	'qp_voices_to_xls' => 'Stimme im XLS-Format exportiere',
	'qp_interpretation_results_to_xls' => 'Usswärtig vo de Antworte in s XLS-Format exportiere',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|Benutzer het|Benutzer hän}} Antworte uf d Froge gee',
	'qp_func_no_such_poll' => 'Kei sonigi Abstimmig ($1)',
	'qp_func_missing_question_id' => 'Bitte spezifizier e Froge-Chännnummere (mit 1 aafange) fir d Abstimmig $1',
	'qp_func_invalid_question_id' => 'Uugiltigi Froge-Chännnummere ($2, kei Zahl) fir d Abstimmig $1',
	'qp_func_missing_proposal_id' => 'Bitte spezifiezier e Vorschlags-Chännnummere, wu s scho git (mit 0 aafange) fir d Abstimmig $1, Frog $2',
	'qp_func_invalid_proposal_id' => 'Nit giltigi Vorschlags-Chännnummere ($3, kei Zahl) fir d Abstimmig $1, Frog $2',
	'qp_error_no_such_poll' => 'Kei sonigi Abstimmig ($1).
Stell sicher, ass d Abstimmig verchindet un gspycheret woren isch, stell au sicher, ass as Trännzeiche in dr Adräss alliwyl # brucht wird',
	'qp_error_in_question_header' => 'Nit giltige Frogechopf: $1',
	'qp_error_id_in_stats_mode' => 'Cha dr Abstimmig kei Chännnummere zuewyyse im statistische Modus',
	'qp_error_dependance_in_stats_mode' => 'Cha d Abhägikeits-Chette vu dr Abstimmig nit verchinde im statistische Modus',
	'qp_error_no_stats' => 'Kei statistischi Date verfiegbar, wel no keini Benutzer abgstumme hän (Adräss $1)',
	'qp_error_address_in_decl_mode' => 'Cha kei Adräss vu dr Abstimmig iberchuu im Verchindigs-Modus',
	'qp_error_question_not_implemented' => 'Forge vu däm Typ sin nit vorgsäh: $1',
	'qp_error_invalid_question_type' => 'Nit giltige Frogetyp: $1',
	'qp_error_type_in_stats_mode' => 'Frogetyp cha nit im statistische Widergabmodus definiert wäre: $1',
	'qp_error_no_poll_id' => 'D Eigeschaft „id“ (Chännnummere) isch nit definiert fir d Abstimmig.',
	'qp_error_invalid_poll_id' => 'Nit giltigi Abstimmigs-Chännnummere ($1).
In dr Chännnummere derf s nume Buechstabe, Zahle un Läärstelle haa.',
	'qp_error_already_used_poll_id' => 'Die Abstimmigs-Chännnummere wird schoi rbuc ht uf däre Syte ($1)',
	'qp_error_invalid_dependance_value' => 'D Abhängigkeits-Chette vu dr Abstimmig (id=$1) het e nit giltige Wärt vu dr Abhängigkeitseigeschaft („$2“)',
	'qp_error_missed_dependance_title' => 'D Abstimmig ($1) hangt aqb vun ere andere Abstimmig ($3) vu dr Syte [[$2]], aber dr Titel [[$2]] isch nit gfunde wore.
Entwäder due d Abhängigkeitseigeschaft uuseneh oder spychere [[$2]] um',
	'qp_error_missed_dependance_poll' => 'D Abstimmig ($1) isch abhängig vun ere andere Abstimmig ($3) uf dr Syte $2, aber sälli Abstimmig git s nit oder si isch nonig gspycheret wore.
Entwäder due d Abhängigkeitseigeschaft uuseneh oder leg d Abstimmig aa mit dr Chännnummere $3 uf dr Syte $2 un due si spychere.
Go ne Abstimmig spychere due si ibertrage ohni ne Antwort gee uf irged e Vorschlagsfrog.',
	'qp_error_vote_dependance_poll' => 'Bitte stimm zerscht ab in dr Abstimmig $1.',
	'qp_error_too_many_spans' => 'S sin zvyl Kategorieklasse definiert fir d Unterkategorie',
	'qp_error_unanswered_span' => 'Unterkategori ohni Antwort',
	'qp_error_non_unique_choice' => 'D Frog brucht ei einzige Vorschlags-Antwort',
	'qp_error_category_name_empty' => 'Kei Kategoriname aagee',
	'qp_error_proposal_text_empty' => 'Kei Vorschlagstext aagee',
	'qp_error_too_few_categories' => 'Zmindescht zwo Kategorie mien definiert wäre',
	'qp_error_too_few_spans' => 'Fir jedi Kategorieklasse brucht s zmindescht zwo definierti Antworte',
	'qp_error_no_answer' => 'Vorschlag ohni Antwort',
	'qp_error_unique' => 'Fir d Frog vum Typ unique() git s meh Vorschleg wie Antworte definiert sin: cha nit abgschlosse wäre',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'pollresults' => 'תוצאות הסקרים באתר',
	'qp_desc' => 'מאפשר יצירת סקרים',
	'qp_desc-sp' => '[[Special:PollResults|דף מיוחד]] לצפייה בתוצאות הסקרים',
	'qp_result_NA' => 'לא נענה',
	'qp_result_error' => 'שגיאת תחביר',
	'qp_vote_button' => 'הצבעה',
	'qp_vote_again_button' => 'שינוי הצבעתכם',
	'qp_polls_list' => 'הצגת כל הסקרים',
	'qp_users_list' => 'הצגת כל המשתמשים',
	'qp_browse_to_poll' => 'עיון בסקר $1',
	'qp_browse_to_user' => 'עיון בחשבון $1',
	'qp_votes_count' => '{{PLURAL:$1|הצבעה אחת|$1 הצבעות}}',
	'qp_source_link' => 'מקור',
	'qp_stats_link' => 'סטטיסטיקה',
	'qp_users_link' => 'משתמשים',
	'qp_voice_link' => 'קול המשתמש',
	'qp_voice_link_inv' => 'קול המשתמש?',
	'qp_user_polls_link' => 'השתתף ב{{PLURAL:$1|סקר אחד|־$1 סקרים}}',
	'qp_user_missing_polls_link' => 'אין השתתפות',
	'qp_not_participated_link' => 'לא השתתף',
	'qp_order_by_username' => 'מיון לפי שם משתמש',
	'qp_order_by_polls_count' => 'מיון לפי מספר הסקרים',
	'qp_results_line_qupl' => 'הדף "$1" סקר "$2": $3',
	'qp_results_line_qpl' => 'הדף "$1" סקר "$2": $3‏, $4‏, $5‏, $6',
	'qp_header_line_qpul' => '$1 [ דף "$2" סקר "$3" ]',
	'qp_export_to_xls' => 'ייצוא הסטטיסטיקה לקובץ מסוג XLS',
	'qp_voices_to_xls' => 'ייצוא קולות לתסדיר XLS',
	'qp_users_answered_questions' => '{{PLURAL:$1|משתמש אחד ענה|$1 משתמשים ענו}} על השאלות',
	'qp_func_no_such_poll' => 'אין כזה סקר ($1)',
	'qp_func_missing_question_id' => "יש לציין מס' שאלה קיים (החל מ־1) עבור הסקר $1",
	'qp_func_invalid_question_id' => 'מזהה שאלה לא תקין=$2 (לא מספר) בסקר $1',
	'qp_func_missing_proposal_id' => 'נא להגדיר מזהה תשובה אפשירת קיים (מתחיל 0) לסקר $1, שאלה $2',
	'qp_func_invalid_proposal_id' => 'מזהה תשובה מוצעת לא תקין=$3 (לא מספר) בסקר $1, שאלה $2',
	'qp_error_no_such_poll' => 'אין סקר כזה ($1).
נא לוודא שהסקר מוכרז ושמור, ולוודא שנעשה שימוש בתו המפריד # בכתובת',
	'qp_error_in_question_header' => 'כותרת שאלה לא תקינה: $1',
	'qp_error_id_in_stats_mode' => "לא ניתן להצהיר על מס' עבור הסקר במצב סטטיסטי",
	'qp_error_dependance_in_stats_mode' => 'לא ניתן להכריז על שרשרת תלות של הסקר במצב סטטיסטיקה',
	'qp_error_no_stats' => 'אין נתונים סטטיסטיים זמינים כיוון שאף אחד עוד לא הצביע בסקר הזה, עדיין (כתובת=$1)',
	'qp_error_address_in_decl_mode' => 'לא ניתן לאחזר את כתובת הסקר במצב הצהרה',
	'qp_error_question_not_implemented' => 'שאלות מהסוג הזה אינן מיושמות: $1',
	'qp_error_invalid_question_type' => 'סוג השאלה שגוי: $1',
	'qp_error_type_in_stats_mode' => 'סוג השאלה לא ניתן להגדרה במצב תצוגה סטטיסטית: $1',
	'qp_error_no_poll_id' => 'לא מוגדר מאפיין id לתג סקר.',
	'qp_error_invalid_poll_id' => 'מזהה סקר לא תקין (id=$1).
מזהה הסקר יכול להכיל רק אותיות, ספרות ותו רווח',
	'qp_error_already_used_poll_id' => 'כבר נעשה שימוש במזהה הסקר בדף הזה (id=$1).',
	'qp_error_invalid_dependance_value' => 'לשרשרת התלות של הסקר (id=$1) יש ערך בלתי תקין של מאפיין dependance‏ (dependance="$2")',
	'qp_error_missed_dependance_title' => 'הסקר (id=$1) תלוי בסקר אחר (id=$3) מהדף [[$2]], אבל הכותרת [[$2]] לא נמצאה.
הסירו את מאפיין התלות או שחזרו את [[$2]]',
	'qp_error_missed_dependance_poll' => 'הסקר (id=$1) תלוי בסקר אחר (id=$3) בדף $2, אבל הסקר ההוא אינו קיים או שהוא עדיין לא נשמר.
הסירו את מאפיין התלות או צרו סקר עם id=$3 בדף $2 ושִמרו אותו.
כדי לשמור סקר, שלחו אותו בלי לענות על השאלות.',
	'qp_error_vote_dependance_poll' => 'יש להצביע עבור הסקר $1 תחילה.',
	'qp_error_too_many_spans' => 'הוגדרו קבוצות קטגוריות רבות מדי עבור המספר הכולל של קטגוריות משנה',
	'qp_error_unanswered_span' => 'קטגוריית משנה ללא מענה',
	'qp_error_non_unique_choice' => 'שאלה זו מחייבת תשובה הצעה ייחודית',
	'qp_error_category_name_empty' => 'שם הקטגוריה ריק',
	'qp_error_proposal_text_empty' => 'טקסט ההצעה ריק',
	'qp_error_too_few_categories' => 'יש להגדיר לפחות שתי קטגוריות',
	'qp_error_too_few_spans' => 'כל קבוצת קטגוריות חייבת להכיל לפחות שתי תת־קטגוריות',
	'qp_error_no_answer' => 'הצעה שלא נענתה',
	'qp_error_unique' => 'לשאלה מסוג unique()‎ יש יותר הצעות ממספר התשובות האפשריות מוגדרות: אי־אפשר להשלים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'pollresults' => 'Wuslědki wothłosowanjow na tutym sydle',
	'qp_desc' => 'Zmóžnja wutworjenje wothłosowanjow',
	'qp_desc-sp' => '[[Special:PollResults|Specialna strona]] za wobhladowanje wuslědkow wothłosowanjow',
	'qp_result_NA' => 'Njewotmołwjeny',
	'qp_result_error' => 'Syntaksowy zmylk',
	'qp_vote_button' => 'Hłosować',
	'qp_vote_again_button' => 'Twoje wothłosowanje změnić',
	'qp_polls_list' => 'Wšě wothłosowanja nalistować',
	'qp_users_list' => 'Wšěch wužiwarjow nalistować',
	'qp_browse_to_poll' => 'Dale k $1',
	'qp_browse_to_user' => 'Dale k $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|hłós|hłosaj|hłosy|hłosow}}',
	'qp_source_link' => 'Žórło',
	'qp_stats_link' => 'Statistika',
	'qp_users_link' => 'Wužiwarjo',
	'qp_voice_link' => 'Wužiwarski hłós',
	'qp_voice_link_inv' => 'Wužiwarski hłós?',
	'qp_user_polls_link' => 'Wobdźěli so na $1 {{PLURAL:$1|wothłosownju|wothłosowanjomaj|wothłosowanjach|wothłosowanjach}}',
	'qp_user_missing_polls_link' => 'Žane wobdźělenje',
	'qp_not_participated_link' => 'Njewobdźěleny',
	'qp_order_by_username' => 'Porjad po wužiwarskim mjenje',
	'qp_order_by_polls_count' => 'Porjad po ličbje wothłosowanjow',
	'qp_results_line_qupl' => 'Strona "$1" wothłosowanje "$2": $3',
	'qp_results_line_qpl' => 'Strona "$1" wothłosowanje "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ strona "$2" wothłosowanje "$3" ]',
	'qp_export_to_xls' => 'Statistiku do XLS-formata eksportować',
	'qp_voices_to_xls' => 'Hłosy do XLS-formata eksportować',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|wužiwar je|wužiwarjej staj|wužiwarjo su|wužiwarjow je}} na prašenja {{PLURAL:$1|wotmołwił|wotmołwiłoj|wotmołwili|wotmołwiło}}',
	'qp_func_no_such_poll' => 'Žane tajke wothłosowanje ($1)',
	'qp_func_missing_question_id' => 'Prošu podaj eksistowacy prašenski ID (započinajo wot 1) za wothłosowanje $1',
	'qp_func_invalid_question_id' => 'Njepłaćiwe prašenje id=$2 (žana ličba) za wothłosowanje $1',
	'qp_func_missing_proposal_id' => 'Prošu podaj eksistowacy namjetowy ID (započinajo wot 0) za naprašowanje $1, prašenje $2',
	'qp_func_invalid_proposal_id' => 'Njepłaćiwy namjet id=$3 (žana ličba) za wothłosowanje $1, prašenje $2',
	'qp_error_no_such_poll' => 'Tajke wothłosowanje njeje ($1).
Zawěsć, zo wothłosowanje bu deklarowane a składowane, přeswědč so, zo wužiwaš adresowe dźělatko #',
	'qp_error_in_question_header' => 'Njepłaćiwy prašenski typ: $1',
	'qp_error_id_in_stats_mode' => 'Njeje móžno ID wothłosowanja w statistiskim modusu deklarowác',
	'qp_error_dependance_in_stats_mode' => 'Njeje móžno wotwisnosćowy rjećazk  wothłosowanja w statistiskim modusu deklarować',
	'qp_error_no_stats' => 'Žane statistiske daty k dispoziciji, dokelž dotal nichtó njeje za tute wothłosowanje hłosował (adresa=$1)',
	'qp_error_address_in_decl_mode' => 'Njeje móžno adresu wothłosowanja w deklaraciskim modusu dóstać',
	'qp_error_question_not_implemented' => 'Prašenja tutoho typa njejsu implementowane: $1',
	'qp_error_invalid_question_type' => 'Njepłaćiwy prašenski typ: $1',
	'qp_error_type_in_stats_mode' => 'Prašenski typ njeda so w statistiskim zwobraznjenskim modusu definować: $1',
	'qp_error_no_poll_id' => 'Taflička Poll njeje atribut ID definował.',
	'qp_error_invalid_poll_id' => 'Njepłaćiwy Id wothłosowanja (ID=$1).
ID wothłosowanja smě jenož pismiki, ličby a mjezeru wobsahować',
	'qp_error_already_used_poll_id' => 'ID wothłosowanja wužiwa so hižo na tutej stronje (ID=$1).',
	'qp_error_invalid_dependance_value' => 'Wotwisnosćowy rjećazk wothłosowanja (id=$1) ma njepłaćiwu hódnotu atributa dependance (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Wothłosowanje (ID=$1) je wot druheho wothłosowanja (ID=$3) ze strony [[$2]] wotwisne, ale titul [[$2]] njebu namakany. Wotstroń pak atribut dependance pak wobnow [[$2]]',
	'qp_error_missed_dependance_poll' => 'Wothłosowanje (ID=$1) je wot druheho wothłosowanja (ID=$3) na stronje $2 wotwisne, ale te wothłosowanje njeeksistuje abo njeje so składowało.
Wotstroń pak atribut dependance pak wutwor wothłosowanje z ID=$3 na stronje $2 a składuj jo.
Zo by wothłosowanje składował, wotpósćel jo, bjeztoho zo by na namjetowe prašenja wotmołwił.',
	'qp_error_vote_dependance_poll' => 'Prošu hłosuj najprjedy za wothłosowanje $1.',
	'qp_error_too_many_spans' => 'Přewjele kategorijowych klasow za podkategorije definowane',
	'qp_error_unanswered_span' => 'Njewotmołwjena podkategorija',
	'qp_error_non_unique_choice' => 'Tute prašenje trjeba jónkróćnu namjetowu wotmołwu',
	'qp_error_category_name_empty' => 'Kategorijowe mjeno je prózdne',
	'qp_error_proposal_text_empty' => 'Namjetowy tekst je prózdny',
	'qp_error_too_few_categories' => 'Znajmjeńša dwě kategoriji dyrbitej so definować',
	'qp_error_too_few_spans' => 'Kóžda kategorijowa klasa trjeba znajmjeńša dwě móžnej definowanej wotmołwje',
	'qp_error_no_answer' => 'Njewotmołwjeny namjet',
	'qp_error_unique' => 'Prašenje typa unique() ma wjace namjetow hač su móžne wotmołwy definowane: njemóžno pokročować',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'pollresults' => 'Az oldal szavazásainak eredményei',
	'qp_desc' => 'Lehetővé teszi szavazások készítését',
	'qp_desc-sp' => '[[Special:PollResults|Speciális lap]] a szavazások eredményeinek megtekintésére',
	'qp_result_NA' => 'Nem válaszolt',
	'qp_result_error' => 'Szintaktikai hiba',
	'qp_vote_button' => 'Szavazás',
	'qp_vote_again_button' => 'Szavazat megváltoztatása',
	'qp_polls_list' => 'Szavazások listája',
	'qp_users_list' => 'Felhasználók listája',
	'qp_browse_to_poll' => 'Ugrás a szavazás helyére: $1',
	'qp_browse_to_user' => 'A felhasználó lapja: $1',
	'qp_votes_count' => '$1 szavazat',
	'qp_source_link' => 'Forrás',
	'qp_stats_link' => 'Statisztika',
	'qp_users_link' => 'Felhasználók',
	'qp_voice_link' => 'A felhasználó szavazatai',
	'qp_voice_link_inv' => 'A felhasználó szavazatai?',
	'qp_user_polls_link' => '$1 szavazáson vett részt',
	'qp_user_missing_polls_link' => 'Nem vett részt',
	'qp_not_participated_link' => 'Nem vett részt',
	'qp_order_by_username' => 'Rendezés felhasználónév szerint',
	'qp_order_by_polls_count' => 'Rendezés a szavazások száma szerint',
	'qp_results_line_qupl' => 'Lap: „$1”, szavazás: „$2”: $3',
	'qp_results_line_qpl' => 'Lap: „$1”, szavazás: „$2”: $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Lap: „$2”, szavazás: „$3” ]',
	'qp_export_to_xls' => 'Statisztikák exportálása XLS-formátumban',
	'qp_users_answered_questions' => '$1 felhasználó válaszolt a kérdésekre',
	'qp_func_no_such_poll' => 'Nincs ilyen szavazás ($1)',
	'qp_func_missing_question_id' => 'Add meg egy létező kérdés azonosítóját (1-től kezdve) a(z) $1 szavazáshoz',
	'qp_func_invalid_question_id' => 'Érvénytelen kérdés id=$2 (nem szám) a(z) $1 szavazáshoz',
	'qp_func_missing_proposal_id' => 'Add meg egy létező javaslat azonosítóját (0-tól kezdve) a(z) $1 szavazás $2 kérdéséhez',
	'qp_func_invalid_proposal_id' => 'Érvénytelen javaslat id=$3 (nem szám) a(z) $1 szavazás $2 kérdéséhez',
	'qp_error_no_such_poll' => 'Nincs ilyen szavazás ($1).
Győződj meg róla, hogy a szavazás deklarálva van, és elmentetted, valamint hogy használtad-e a címhatároló karaktert (#)',
	'qp_error_in_question_header' => 'Érvénytelen kérdés-fejléc: $1',
	'qp_error_id_in_stats_mode' => 'Nem deklarálható egy szavazás azonosítója statisztikai módban',
	'qp_error_dependance_in_stats_mode' => 'Nem deklarálható a szavazás függőségi lánca statisztikai módban',
	'qp_error_no_stats' => 'A statisztikai adatok nem elérhetőek, mert még senki sem szavazott ezen a szavazáson (address=$1)',
	'qp_error_address_in_decl_mode' => 'A szavazás címe nem kérhető le deklarációs módban',
	'qp_error_question_not_implemented' => 'Az ilyen típusú kérdések nincsenek implementálva: $1',
	'qp_error_invalid_question_type' => 'Érvénytelen kérdéstípus: $1',
	'qp_error_type_in_stats_mode' => 'A kérdés típusát nem lehet megadni statisztikai módban: $1',
	'qp_error_no_poll_id' => 'A szavazás tagnek nincs azonosító (id) attribútuma megadva.',
	'qp_error_invalid_poll_id' => 'Érvénytelen szavazásazonosító (id=$1).
A szavazásazonosító csak betűket, számokat és szóközt tartalmazhat',
	'qp_error_already_used_poll_id' => 'Ez a szavazásazonosító már használva volt korábban ezen a lapon (id=$1).',
	'qp_error_invalid_dependance_value' => 'A szavazás (id=$1) függőségi lánca érvénytelen függőségi attribútum-értékkel rendelkezik (dependance="$2")',
	'qp_error_missed_dependance_title' => 'A szavazás (id=$1) függ a(z) [[$2]] lapon található másik szavazástól (id=$3), de ez a lap nem található.
Vagy távolítsd el a függőségi attribútumot, vagy állítsd helyre a(z) [[$2]] lapot.',
	'qp_error_missed_dependance_poll' => 'A szavazás (id=$1) függ egy, a(z) $2 lapon található másik szavazástól  (id=$3), de ez a szavazás nem létezik, vagy még nem lett elmentve.
Távolítsd el a függőségi attribútumot, vagy készítsd el a(z) id=$3 azonosítóval rendelkező szavazást a(z) $2 lapon, és mentsd el.
A szavazás elmentéséhez küldd el azt anélkül, hogy válaszolnál bármelyik kérdésre.',
	'qp_error_vote_dependance_poll' => 'Először szavazz a(z) $1 szavazáson.',
	'qp_error_too_many_spans' => 'Túl sok kategóriaosztály lett az alkategóriák számára megadva.',
	'qp_error_unanswered_span' => 'Megválaszolatlan alkategória',
	'qp_error_non_unique_choice' => 'Ennek kérdésnek egyedi javasolt válaszra van szüksége',
	'qp_error_category_name_empty' => 'A kategória neve üres',
	'qp_error_proposal_text_empty' => 'A javaslat szövege üres',
	'qp_error_too_few_categories' => 'Legalább két kategóriát kell megadni',
	'qp_error_too_few_spans' => 'Mindegyik kategóriaosztályhoz meg kell adni legalább két lehetséges választ',
	'qp_error_no_answer' => 'Megválaszolatlan javaslat',
	'qp_error_unique' => 'A unique() típus kérdése több javaslattal rendelkezik, mint a megadott lehetséges válaszol száma: nem lehet befejezni',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'pollresults' => 'Resultatos del sondages in iste sito',
	'qpollwebinstall' => 'Installation / actualisation del extension QPoll',
	'qp_desc' => 'Permitte le creation de sondages',
	'qp_desc-sp' => '[[Special:PollResults|Pagina special]] pro vider le resultatos del sondages',
	'qp_result_NA' => 'Sin responsa',
	'qp_result_error' => 'Error de syntaxe',
	'qp_vote_button' => 'Votar',
	'qp_vote_again_button' => 'Modificar tu voto',
	'qp_submit_attempts_left' => 'Resta $1 {{PLURAL:$1|tentativa|tentativas}}',
	'qp_polls_list' => 'Listar tote le sondages',
	'qp_users_list' => 'Listar tote le usatores',
	'qp_browse_to_poll' => 'Navigar verso $1',
	'qp_browse_to_user' => 'Navigar verso $1',
	'qp_browse_to_interpretation' => 'Navigar verso $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|voto|votos}}',
	'qp_source_link' => 'Origine',
	'qp_stats_link' => 'Statisticas',
	'qp_users_link' => 'Usatores',
	'qp_voice_link' => 'Voce del usator',
	'qp_voice_link_inv' => 'Voce de usator?',
	'qp_user_polls_link' => 'Participava in $1 {{PLURAL:$1|sondage|sondages}}',
	'qp_user_missing_polls_link' => 'Nulle participation',
	'qp_not_participated_link' => 'Non participate',
	'qp_order_by_username' => 'Ordinar per nomine de usator',
	'qp_order_by_polls_count' => 'Ordinar per numero de sondages',
	'qp_results_line_qupl' => 'Pagina "$1" Sondage "$2": $3',
	'qp_results_line_qpl' => 'Pagina "$1" Sondage "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Pagina "$2" Sondage "$3" ]',
	'qp_results_submit_attempts' => 'Tentativas de submission: $1',
	'qp_results_interpretation_header' => 'Interpretation del responsas',
	'qp_results_short_interpretation' => 'Interpretation curte',
	'qp_results_long_interpretation' => 'Interpretation longe',
	'qp_results_structured_interpretation' => 'Interpretation structurate',
	'qp_poll_has_no_interpretation' => 'Nulle patrono de interpretation ha essite definite in le capite de iste sondage',
	'qp_interpetation_wrong_answer' => 'Responsa false',
	'qp_export_to_xls' => 'Exportar statisticas in formato XLS',
	'qp_voices_to_xls' => 'Exportar voces in formato XLS',
	'qp_interpretation_results_to_xls' => 'Exportar interpretationes de responsa in formato XLS',
	'qp_users_answered_questions' => 'usatores respondeva al questiones',
	'qp_func_no_such_poll' => 'Sondage non existe ($1)',
	'qp_func_missing_question_id' => 'Per favor specifica le ID de un question existente (a partir de 1) pro le sondage $1',
	'qp_func_invalid_question_id' => 'Question invalide id=$2 (non un numero) pro le sondage $1',
	'qp_func_missing_proposal_id' => 'Per favor specifica un ID de proposition existente (a partir de 0) pro le sondage $1, question $2',
	'qp_func_invalid_proposal_id' => 'ID de proposition invalide "$3" (non un numero) pro le sondage $1, question $2',
	'qp_error_no_such_poll' => 'Sondage non existe ($1).
Verifica que le sondage ha essite declarate e salveguardate, e que le character # es usate como delimitator de adresse.',
	'qp_error_in_question_header' => 'Titulo de question invalide: $1',
	'qp_error_id_in_stats_mode' => 'Non pote declarar un ID del sondage in modo statistic',
	'qp_error_dependance_in_stats_mode' => 'Non pote declarar le catena de dependentia del sondage in modo statistic',
	'qp_error_no_stats' => 'Nulle dato statistic es disponibile, proque necuno ha ancora votate pro iste sondage (adresse=$1)',
	'qp_error_address_in_decl_mode' => 'Non pote obtener un adresse del sondage in modo declarative',
	'qp_error_question_not_implemented' => 'Le questiones de iste typo non es implementate: $1',
	'qp_error_question_empty_body' => 'Le texto del question es vacue.',
	'qp_error_question_no_proposals' => 'Le question non ha alcun proposition definite.',
	'qp_error_invalid_question_type' => 'Typo de question invalide: $1',
	'qp_error_invalid_question_name' => 'Nomine de question invalide: $1.',
	'qp_error_type_in_stats_mode' => 'Le typo de question non pote esser definite in modo de presentation statistic: $1',
	'qp_error_no_poll_id' => 'Le etiquetta del sondage non ha un attributo "id" definite.',
	'qp_error_invalid_poll_id' => 'ID de sondage invalide (id=$1).
Le ID del sondage pote continer solmente litteras, numeros e le character de spatio.',
	'qp_error_already_used_poll_id' => 'Le ID del sondage ha ja essite usate in iste pagina (id=$1).',
	'qp_error_too_long_dependance_value' => 'Le valor del attributo de dependentia (dependance="$2") del sondage (id=$1) es troppo longe pro esser immagazinate in le base de datos.',
	'qp_error_invalid_dependance_value' => 'Le catena de dependentia del sondage (id=$1) ha un valor invalide del attributo de dependentia (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Le sondage (id=$1) depende de un altere sondage (id=$3) del pagina [[$2]], ma le titulo [[$2]] non ha essite trovate.
O remove le attributo de dependentia, o restaura [[$2]].',
	'qp_error_missed_dependance_poll' => 'Le sondage (id=$1) depende de un altere sondage (id=$3) al pagina $2, ma ille sondage non existe o non ha ancora essite salveguardate.
O remove le attributo de dependentia, o crea le sondage con id=$3 al pagina $2 e salveguarda lo.
Pro salveguardar un sondage, submitte lo sin responder a alcun question de proposition.',
	'qp_error_vote_dependance_poll' => 'Per favor vota primo pro le sondage $1.',
	'qp_error_too_many_spans' => 'Troppo de classes de categoria pro le subcategorias definite',
	'qp_error_unanswered_span' => 'Subcategoria sin responsa',
	'qp_error_non_unique_choice' => 'Iste question require un responsa de proposition unic',
	'qp_error_category_name_empty' => 'Le nomine del categoria es vacue',
	'qp_error_proposal_text_empty' => 'Le texto del proposition es vacue',
	'qp_error_too_long_category_option_value' => 'Le valor del option de categoria es troppo longe pro esser immagazinate in le base de datos.',
	'qp_error_too_long_category_options_values' => 'Le valores del optiones de categoria es troppo longe pro esser immagazinate in le base de datos.',
	'qp_error_too_long_proposal_text' => 'Le texto del proposition es troppo longe pro poter esser immagazinate in le base de datos',
	'qp_error_too_long_proposal_name' => 'Le nomine del proposition es troppo longe pro poter esser immagazinate in le base de datos.',
	'qp_error_multiline_proposal_name' => 'Le nomine del proposition non pote continer multiple lineas de texto.',
	'qp_error_numeric_proposal_name' => 'Le nomine del proposition non pote esser numeric.',
	'qp_error_too_few_categories' => 'Al minus duo categorias debe esser definite',
	'qp_error_too_few_spans' => 'Cata classe de categoria require le definition de al minus duo responsas possibile',
	'qp_error_no_answer' => 'Proposition sin responsa',
	'qp_error_not_enough_categories_answered' => 'Non satis de categorias specificate.',
	'qp_error_unique' => 'Pro le question de typo unique() es definite plus propositiones que responsas possibile: non pote completar',
	'qp_error_no_more_attempts' => 'Tu ha attingite le numero maxime de tentativas de submission pro iste sondage',
	'qp_error_no_interpretation' => 'Le script de interpretation non existe.',
	'qp_error_interpretation_no_return' => 'Le script de interpretation non retornava resultatos',
	'qp_error_structured_interpretation_is_too_long' => 'Le interpretation structurate es troppo longe pro immagazinar lo in le base de datos. Per favor corrige le script de interpretation.',
	'qp_error_no_json_decode' => 'Le interpretation del responsas al sondage require le function PHP json_decode()',
	'qp_error_eval_missed_lang_attr' => 'Le attributo XML "lang" es necessari pro seliger le lingua correcte de interpretation',
	'qp_error_eval_mix_languages' => 'Un sol script de interpretation non pote combinar differente linguas de interpretation: "$1", "$2"',
	'qp_error_eval_unsupported_language' => 'Lingua de interpretation "$1" non supportate',
	'qp_error_eval_illegal_token' => 'Le indicio PHP $1 con valor $2 non es permittite in linea $3',
	'qp_error_eval_illegal_superglobal' => 'Le indicio PHP $1 con superglobal $2 non es permittite in linea $3',
	'qp_error_eval_illegal_function_call' => 'Le indicio PHP $1 con function $2 non es permittite in linea $3',
	'qp_error_eval_variable_variable_access' => 'Le indicio PHP $1 con le variabile variabile $2 non es permittite in linea $3',
	'qp_error_eval_illegal_variable_name' => 'Le indicio PHP $1 ha un nomine de variabile non permittite $2 in linea $3',
	'qp_error_eval_variable_function_call' => 'Le indicio PHP $1 con le function variabile $2 non es permittite in linea $3',
	'qp_error_eval_self_check' => 'Le sequente auto-test de eval() ha fallite: $1. Tu ha un version non supportate de PHP, le qual non permitte le execution secur de scripts de evalutation.',
	'qp_error_eval_unable_to_lint' => 'Impossibile analysar le codice-fonte con "lint" (verifica le configuration del systema)',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author IvanLanin
 */
$messages['id'] = array(
	'pollresults' => 'Hasil pemilihan di situs ini',
	'qp_desc' => 'Izinkan pembuatan pemilihan',
	'qp_desc-sp' => '[[Special:PollResults|Halaman khusus]] untuk melihat hasil pemilihan',
	'qp_result_NA' => 'Tak dijawab',
	'qp_result_error' => 'Kesalahan sintaks',
	'qp_vote_button' => 'Pilih',
	'qp_vote_again_button' => 'Ubah pilihan Anda',
	'qp_polls_list' => 'Daftar semua pemilihan',
	'qp_users_list' => 'Daftar semua pengguna',
	'qp_browse_to_poll' => 'Cari ke $1',
	'qp_browse_to_user' => 'Tamban ke $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|suara|suara}}',
	'qp_source_link' => 'Sumber',
	'qp_stats_link' => 'Statistik',
	'qp_users_link' => 'Pengguna',
	'qp_voice_link' => 'Suara pengguna',
	'qp_voice_link_inv' => 'Suara pengguna?',
	'qp_user_polls_link' => 'Berpartisipasi dalam $1 {{PLURAL:$1|pemilihan|pemilihan}}',
	'qp_user_missing_polls_link' => 'Tak ada partisipasi',
	'qp_not_participated_link' => 'Tidak berpartisipasi',
	'qp_order_by_username' => 'Urutan menurut nama pengguna',
	'qp_order_by_polls_count' => 'Urutan menurut jumlah pemilihan',
	'qp_results_line_qupl' => 'Halaman "$1" Pemilihan "$2": $3',
	'qp_results_line_qpl' => 'Halaman "$1" Pemilihan "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Halaman "$2" Pemilihan "$3" ]',
	'qp_export_to_xls' => 'Ekspor statistik ke dalam format XLS',
	'qp_voices_to_xls' => 'Ekspor suara ke format XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|pengguna|pengguna}} telah menjawab pertanyaan',
	'qp_func_no_such_poll' => 'Tidak ada pemilihan ($1)',
	'qp_func_missing_question_id' => 'Silakan masukkan suatu nomor pertanyaan yang ada (mulai dari 1) untuk pemilihan $1',
	'qp_func_invalid_question_id' => 'Pertanyaan salah id=$2 (bukan angka) untuk pemilihan $1',
	'qp_func_missing_proposal_id' => 'Silakan masukkan suatu nomor proposal yang ada (mulai dari 0) untuk pemilihan $1, pertanyaan $2',
	'qp_func_invalid_proposal_id' => 'Proposal salah id=$3 (bukan angka) untuk pemilihan $1, pertanyaan $2',
	'qp_error_no_such_poll' => 'Pemilihan tidak ditemukan ($1).
Pastikan bahwa pemilihan telah dibuat dan disimpan. Pastikan untuk menggunakan karakter penanda alamat #',
	'qp_error_in_question_header' => 'Kepala pertanyaan tidak sah: $1',
	'qp_error_id_in_stats_mode' => 'Tidak dapat menetapkan ID pemilihan dalam mode statistik',
	'qp_error_dependance_in_stats_mode' => 'Tidak dapat menetapkan rantai dependensi pemilihan dalam modus statistik',
	'qp_error_no_stats' => 'Tidak ada data statistik tersedia, karena belum ada yang memilih pada pemilihan ini (address=$1)',
	'qp_error_address_in_decl_mode' => 'Tidak dapat memperoleh alamat pemilihan dalam modus deklarasi',
	'qp_error_question_not_implemented' => 'Pertanyaan dengan jenis itu belum diberlakukan: $1',
	'qp_error_invalid_question_type' => 'Jenis pertanyaan salah: $1',
	'qp_error_type_in_stats_mode' => 'Jenis pertanyaan tak dapat ditetapkan dalam mode tampilan statistik: $1',
	'qp_error_no_poll_id' => 'Tag pemilihan tidak memiliki atribut nomor.',
	'qp_error_invalid_poll_id' => 'ID pemilihan salah (id=$1)
ID pemilihan hanya boleh berisi huruf, angka dan spasi',
	'qp_error_already_used_poll_id' => 'ID pemilihan telah digunakan di halaman ini (id=$1)',
	'qp_error_invalid_dependance_value' => 'Rantai dependensi pemilihan (nomor=$1) memiliki nilai atribut dependensi tidak sah (dependensi="$2")',
	'qp_error_missed_dependance_title' => 'Pemilihan (nomor=$1) tergantung kepada pemilihan lain (nomor=$3) dari halaman [[$2]], tetapi judul [[$2]] tidak ditemukan.
Hapus atribut dependensi atau pulihkan [[$2]]',
	'qp_error_missed_dependance_poll' => 'Pemilihan (id=$1) tergantung kepada pemilihan lain (id=$3) pada halaman $2, tetapi pemilihan tersebut tidak ada atau belum disimpan.
Hapus atribut dependensi atau buat dan simpan pemilihan dengan id=$3 pada halaman $2.
Untuk menyimpan pemilihan, kirimkan tanpa menjawab pertanyaan proposal.',
	'qp_error_vote_dependance_poll' => 'Mohon pilih pada pemilihan $1 dahulu.',
	'qp_error_too_many_spans' => 'Terlalu banyak kelas kategori untuk subkategori yang ditetapkan',
	'qp_error_unanswered_span' => 'Subkategori belum terjawab',
	'qp_error_non_unique_choice' => 'Pertanyaan ini membutuhkan jawaban proposal yang unik',
	'qp_error_category_name_empty' => 'Nama kategori kosong',
	'qp_error_proposal_text_empty' => 'Teks proposal kosong',
	'qp_error_too_few_categories' => 'Sedikitnya dua kategori harus ditetapkan',
	'qp_error_too_few_spans' => 'Setiap kelas kategori membutuhkan sedikitnya dua jawaban',
	'qp_error_no_answer' => 'Proposal belum terjawab',
	'qp_error_unique' => 'Pertanyaan dari jenis unique() memiliki lebih banyak proposal daripada kemungkinan jawaban yang didefinisikan: mustahil untuk menyelesaikan',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'qp_result_error' => 'Errore di sintassi',
	'qp_vote_button' => 'Vota',
	'qp_source_link' => 'Fonte',
	'qp_stats_link' => 'Statistiche',
	'qp_users_link' => 'Utenti',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Whym
 */
$messages['ja'] = array(
	'pollresults' => 'このサイトでの投票結果',
	'qp_desc' => '投票を実施できるようにする',
	'qp_desc-sp' => '投票結果を見るための[[Special:PollResults|特別ページ]]',
	'qp_result_NA' => '回答されていません',
	'qp_result_error' => '構文エラー',
	'qp_vote_button' => '投票',
	'qp_vote_again_button' => 'あなたの票を変更',
	'qp_polls_list' => '全投票一覧',
	'qp_users_list' => '全利用者一覧',
	'qp_browse_to_poll' => '$1 を閲覧',
	'qp_browse_to_user' => '$1 を閲覧',
	'qp_votes_count' => '$1{{PLURAL:$1|票}}',
	'qp_source_link' => '投票場所',
	'qp_stats_link' => '統計',
	'qp_users_link' => '利用者',
	'qp_voice_link' => '利用者の声',
	'qp_voice_link_inv' => '利用者の声?',
	'qp_user_polls_link' => '$1件の{{PLURAL:$1|投票}}に参加',
	'qp_user_missing_polls_link' => '参加なし',
	'qp_not_participated_link' => '未参加',
	'qp_order_by_username' => '利用者名順に整列',
	'qp_order_by_polls_count' => '投票数順に整列',
	'qp_results_line_qupl' => 'ページ「$1」投票「$2」: $3',
	'qp_results_line_qpl' => 'ページ「$1」投票「$2」: $3、$4、$5、$6',
	'qp_header_line_qpul' => '$1 [ ページ「$2」投票「$3」]',
	'qp_export_to_xls' => '統計を XLS 形式でエクスポート',
	'qp_voices_to_xls' => 'すべての投票をXLS形式でエクスポートする',
	'qp_users_answered_questions' => '$1{{PLURAL:$1|人}}の利用者がこの質問に答えました',
	'qp_func_no_such_poll' => 'そのような投票はありません ($1)',
	'qp_func_missing_question_id' => '投票 $1 に存在する質問 ID を指定してください (1から始まります)',
	'qp_func_invalid_question_id' => '投票 $1 に対して無効な質問 ID ($2 は数値ではありません)',
	'qp_func_missing_proposal_id' => '投票 $1、質問 $2 に存在する提案 ID を指定してください (1から始まります)',
	'qp_func_invalid_proposal_id' => '投票 $1、質問 $2 に対して無効な提案 ID ($3 は数値ではありません)',
	'qp_error_no_such_poll' => 'そのような投票はありません ($1)。
その投票が宣言され保存されていること、およびアドレス区切り記号 # を使っていることを確認してください。',
	'qp_error_in_question_header' => '無効な質問見出し: $1',
	'qp_error_id_in_stats_mode' => '統計モードでは投票の ID を宣言できません',
	'qp_error_dependance_in_stats_mode' => '統計モードでは投票の依存性チェーンを宣言できません',
	'qp_error_no_stats' => 'まだ誰もこの投票に投票していないので、統計データはありません (アドレス $1)',
	'qp_error_address_in_decl_mode' => '宣言モードでは投票のアドレスを取得できません',
	'qp_error_question_not_implemented' => 'そのタイプの質問は実装されていません: $1',
	'qp_error_invalid_question_type' => '無効な質問タイプ: $1',
	'qp_error_type_in_stats_mode' => '質問タイプは統計表示モードでは定義できません: $1',
	'qp_error_no_poll_id' => '投票タグに id 属性がありません。',
	'qp_error_invalid_poll_id' => '無効な投票 ID (id=$1)。
投票 ID はアルファベット、数字、スペースのみを含むことができます。',
	'qp_error_already_used_poll_id' => 'その投票 ID は既にこのページで使われています (id=$1)。',
	'qp_error_invalid_dependance_value' => 'この投票 (id=$1) の依存性チェーンには依存性属性に不正な値があります (dependance="$2")',
	'qp_error_missed_dependance_title' => 'この投票 (id=$1) はページ [[$2]] の別の投票 (id=$3) に依存していますが、ページ名 [[$2]] は見つかりませんでした。依存性属性を削除するか、[[$2]] を復帰させてください',
	'qp_error_missed_dependance_poll' => 'この投票 (id=$1) はページ $2 の別の投票 (id=$3) に依存していますが、その投票が存在しないかまだ保存されていません。依存性属性を削除するか、ページ $2 で id=$3 の投票を作成してください。投票を保存するには、どの提案質問にも答えずに投稿してください。',
	'qp_error_vote_dependance_poll' => '初めに投票 $1 に投票してください。',
	'qp_error_too_many_spans' => 'このサブカテゴリーに対して定義されているカテゴリーが多すぎます',
	'qp_error_unanswered_span' => '未回答のサブカテゴリー',
	'qp_error_non_unique_choice' => 'この質問には答えとして独自の提案が必要です',
	'qp_error_category_name_empty' => 'カテゴリー名が空です',
	'qp_error_proposal_text_empty' => '提案文が空です',
	'qp_error_too_few_categories' => '最低でも2つのカテゴリーが定義されなければなりません',
	'qp_error_too_few_spans' => 'どのカテゴリーも最低でも2つの回答がとり得るように定義されなければなりません',
	'qp_error_no_answer' => '未回答の提案',
	'qp_error_unique' => 'タイプが unique() の質問には回答可能なものより多くの質問が定義されています。すべてに記入することはできません',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'pollresults' => 'Wat bei dä Affschtemmunge en heh däm Wiki eruß gekumme es',
	'qp_parentheses' => '(<code>$1</code>)',
	'qp_full_category_name' => '$1(<code>$2</code>)',
	'qp_desc' => 'Määt Affschtemmunge müjjelesch.',
	'qp_desc-sp' => '[[Special:PollResults|{{int:nstab-special}}]] för aanzeloore, wat bei Affschtemmunge erus kohm.',
	'qp_result_NA' => 'Kein Antwoot jejovve',
	'qp_result_error' => 'Ene Fähler en dä Syntax es opjefalle',
	'qp_vote_button' => 'Afschtemme!',
	'qp_vote_again_button' => 'Donn Ding Shtemm ändere',
	'qp_polls_list' => 'Alle Affschtemmunge opleste',
	'qp_users_list' => 'Alle Metmaacher opleste',
	'qp_browse_to_poll' => 'Bes $1 bläddere',
	'qp_browse_to_user' => 'Bes $1 bläddere',
	'qp_votes_count' => '{{PLURAL:$1|ein Schtemm|$1 Schtemme|Kein Schtemm}}',
	'qp_source_link' => 'Beschrevve',
	'qp_stats_link' => 'Schtatistike',
	'qp_users_link' => 'Metmaacher',
	'qp_voice_link' => 'Enem Metmaacher sing Stemm',
	'qp_voice_link_inv' => 'Enem Metmaacher sing Stemm?',
	'qp_user_polls_link' => 'Hät beij {{PLURAL:$1|eine Affschtemmung|$1 Affschtemmunge|keine Affschtemmung}} metjemaat',
	'qp_user_missing_polls_link' => 'Keine hät metjemaat',
	'qp_not_participated_link' => 'Nit metjmaat',
	'qp_order_by_username' => 'Noh de Metmaacher iere Name zoteere',
	'qp_order_by_polls_count' => 'Noh e Affschtemmunge ier Zahle zoteere',
	'qp_results_line_qupl' => 'Sigg „$1“ Affschtemmung „$2“: $3',
	'qp_results_line_qpl' => 'Sigg „$1“ Affschtemmung „$2“: $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Sigg „$2“ Affschtemmung „$3“ ]',
	'qp_results_line_qpul' => '$1: $2',
	'qp_header_line_qucl' => '$1. $2<br />$3 ??? $4',
	'qp_results_line_qucl' => '$1: $2 $3',
	'qp_export_to_xls' => 'Donn de Schtatistike em <i lang="en">XLS</i> Fommaat äxpotteere',
	'qp_voices_to_xls' => 'Donn de Shtemme em <i lang="en">XLS</i> Fommaat äxpotteere',
	'qp_users_answered_questions' => '{{PLURAL:$1|Eine|$1|Keine}} Metmaacher {{PLURAL:$1|hät|han|hät}} op di Froore jeantwoot \\',
	'qp_func_no_such_poll' => 'Esu en Affschtemmung ham_mer nit ($1)',
	'qp_func_missing_question_id' => 'Bes esu joot, un jif en Kännong aan, di et jitt,för en Frooch (vun 1 aan jezallt) för de Affschtemmung $1',
	'qp_func_invalid_question_id' => 'Dat es en onjöltijje Frooch (<code lang="en">id=$2</code>), nämmlesch kein Nommer, för de Affschtemmung $1',
	'qp_func_missing_proposal_id' => 'Bes esu joot, un jif en Kännong aan, di et jitt,för ene Vörschlaach (vun 0 aan jezallt) för de Affschtemmung $1 un de Frooch $2',
	'qp_func_invalid_proposal_id' => 'Dat es en onjöltijje Kännong för ene Vörschlaach (<code lang="en">id=$3</code>), nämmlesch kein Nommer, för de Affschtemmung $1 un de Frooch $2',
	'qp_error_no_such_poll' => 'Mer hann kein esu en Affschtemmung ($1).
Bes sescher, dat di Affschtemmung wennjerescht es un affjeschpeijschert, un bes sescher, dat De dat Bejränzungszeijsche # en dä Addräß bruche deihß.',
	'qp_error_in_question_header' => 'Dat es en onjöltijje Övverschreff vun en Frooch: $1',
	'qp_error_id_in_stats_mode' => 'Mer künne kein Kännung (<code lang="en">id=</code>) fö di Affschtemmung en de Enschtellung för de Schtatistike faßlääje',
	'qp_error_dependance_in_stats_mode' => 'Mer künne kein Kett vun Affhängeschkeite fö di Affschtemmung en de Enschtellung för de Schtatistike faßlääje',
	'qp_error_no_stats' => 'Ner han kein schtatistesche Daate, weil noch keiner för heh di Affjeschtemmung affjeschtemmp hät. (<code>address=$1</code>)',
	'qp_error_address_in_decl_mode' => 'Mer künne kein Addräß vun dä Affschtemmung beij em Fäßlääje vun de Enschtellung un Eijeschaffte krijje',
	'qp_error_question_not_implemented' => 'Froore vun dä Zoot sin nit em Projramm: $1',
	'qp_error_invalid_question_type' => 'Dat es en onjöltijje Zoot Frooch: $1',
	'qp_error_type_in_stats_mode' => 'Froore ier Zoot kam_mer nit en de Enschtellung för de Schtatistike faßlääje: $1',
	'qp_error_no_poll_id' => 'Dä Befähl för en Affschtemmung hät kein Kännung (<code>id=</code>) aanjejovve.',
	'qp_error_invalid_poll_id' => 'Dat es en onjöltijje Kännung för en Affschtemmung (<code>id=$1</code>)
Doh dörfe nur Bochschtabe, Zeffere, un Affschtänd dren sin.',
	'qp_error_already_used_poll_id' => 'Di Kännung för en Affschtemmung (<code>id=$1</code>) es ald ens op heh dä Sigg jebruch woode.',
	'qp_error_invalid_dependance_value' => 'Di Affschtemmung fö di Kännung (<code>id=$1</code>) ier Kett vun Afhängeschkeite hät en onjöltesch Eijeschaff (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Di Affschtemmung met dä Kännung (<code>id=$1</code>) hängk aff vun ene andere Affschtemmung met dä Kännung (<code>id=$3</code>) op dä Sigg „[[$2]]“, ävver di ham_mer nit jefonge.
Entweder donn die Eijeschaff met dä Affhängeschkeit fott, udder holl di Sigg „[[$2]]“ wider en et Wiki,',
	'qp_error_missed_dependance_poll' => 'Di Affschtemmung met dä Kännung (<code>id=$1</code>) hängk aff vun ene andere Affschtemmung met dä Kännung (<code>id=$3</code>) op dä Sigg „$2“, ävver di Affschtemmung ham_mer doh nit jefonge.
Entweder donn die Eijeschaff met dä Affhängeschkeit fott, udder donn en Affschtemmung met dä Kännung (<code>id=$3</code>) op di Sigg „$2“ un donn se afschpeijschere.
Öm en Afschtemmung reschtesch ze schpeijschere, donn dat, der ohne op en Frooch jeantwoot ze han.',
	'qp_error_vote_dependance_poll' => 'Bes esu joot un donn övver „$1“ et eets affschtemme',
	'qp_error_too_many_spans' => 'Et sinn_er zoh vill Zoote-Jroppe för de Ongerknubbelle aanjejovve',
	'qp_error_unanswered_span' => 'Ongerknubbel oohne Antwoot',
	'qp_error_non_unique_choice' => 'Di Frooch bruch ene einzelne Vörschlaach för en Antwoot',
	'qp_error_category_name_empty' => 'Dä Name för dä Knubbel es läddesch',
	'qp_error_proposal_text_empty' => 'En däm Täx för dä Vörschlaach schteiht nix dren',
	'qp_error_too_few_categories' => 'Winnischsdens zweij Knubbelle möße doh sin',
	'qp_error_too_few_spans' => 'För jeede Zoote-Knubbel möte winnischsdens zweij müjjelesche Ongerzoote doh sin',
	'qp_error_no_answer' => 'Ene Vörschlaach ohne Antwoot',
	'qp_error_unique' => 'En Frooch vun dä Zoot <code>unique()</code> hät mieh Vörschlääsch, wi müjjelesche Antwoote aanjejovve: Dat kam_mer nit ußfölle.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'pollresults' => 'Resultater vun der Ëmfro op dësem Site',
	'qp_desc' => "Erlaabt et Ëmfroen z'organiséieren",
	'qp_desc-sp' => "[[Special:PollResults|Spezialsäit]] fir d'Resultater vun der Ëmfro ze gesinn",
	'qp_result_NA' => 'Keng Äntwert',
	'qp_result_error' => 'Syntaxfeeler',
	'qp_vote_button' => 'Ofstëmmen',
	'qp_vote_again_button' => 'Ännert Är Ofstëmmung',
	'qp_submit_attempts_left' => 'Et {{PLURAL:$1|bleift nach $1 Versuch|bleiwen nach $1 Versich}}',
	'qp_polls_list' => 'All Ëmfroe weisen',
	'qp_users_list' => 'All Benotzer opzielen',
	'qp_browse_to_poll' => 'Op $1 goen',
	'qp_browse_to_user' => 'Bäi de(n) $1 goen',
	'qp_votes_count' => '$1 {{PLURAL:$1|Stëmm|Stëmmen}}',
	'qp_source_link' => 'Quell',
	'qp_stats_link' => 'Statistiken',
	'qp_users_link' => 'Benotzer',
	'qp_voice_link' => 'Stëmm vum Benotzer',
	'qp_voice_link_inv' => 'Stëmm vum Benotzer?',
	'qp_user_polls_link' => 'huet {{PLURAL:$1|un enger Ëmfro|u(n) $1 Ëmfroen}} deelgeholl',
	'qp_user_missing_polls_link' => 'Keng Bedeelegung',
	'qp_not_participated_link' => 'Net matgemaach',
	'qp_order_by_username' => 'Nom Benotzernumm zortéieren',
	'qp_order_by_polls_count' => 'No der Zuel vun den Ënfroen zortéieren',
	'qp_results_line_qupl' => 'Säit "$1" Ëmfro "$2": $3',
	'qp_results_line_qpl' => 'Säit "$1" Ëmfro "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Säit "$2" Ëmfro "$3" ]',
	'qp_results_interpretation_header' => 'Interpretatioun vun den Äntwerten',
	'qp_results_short_interpretation' => 'Kuerz Interpretatioun',
	'qp_results_long_interpretation' => 'Laang Interpretatioun',
	'qp_interpetation_wrong_answer' => 'Falsch Äntwert',
	'qp_export_to_xls' => "Exportéiert d'Statistiken am XLS-Format",
	'qp_voices_to_xls' => "Exportéiert d'Stëmmen an den XLS-Format",
	'qp_users_answered_questions' => "$1 {{PLURAL:$1|Benotzer huet|Benotzer hun}} op d'Froe geäntwert",
	'qp_func_no_such_poll' => 'Et gëtt keng esou eng Ëmfro ($1)',
	'qp_func_missing_question_id' => "Gitt w.e.g. d'Id vun enger Fro un déi et gëtt (ugefaang mat 1) fir d'Ëmfro $1",
	'qp_func_invalid_question_id' => "id vun der Fro=$2 ass net valabel (et ass keng Zuel) fir d'Ëmfro $1",
	'qp_error_in_question_header' => 'Iwwerschrëft vun der Fro net valabel: $1',
	'qp_error_no_stats' => 'Et gëtt keng statistesch Donnéeën, well bis elo (Adress=$1) kee fir dës Ëmfro gestëmmt huet.',
	'qp_error_question_not_implemented' => 'Froe vun esou engem Typ sinn net implementéiert: $1',
	'qp_error_invalid_question_type' => 'Net-valabelen Typ vu Fro: $1',
	'qp_error_already_used_poll_id' => "D'Ëmfro-Nummer (poll id) gouf op dëser Säit scho benotzt (id=$1).",
	'qp_error_vote_dependance_poll' => "Stëmmt w.e.g. fir d'éischt bäi der Ëmfro $1 of.",
	'qp_error_too_many_spans' => "Zevill Gruppe vu Kategorien fir d'Gesamtzuel vun definéierten Ënnerkategorien",
	'qp_error_unanswered_span' => 'Ënnerkategorie ouni Äntwert',
	'qp_error_non_unique_choice' => 'Dës Fro brauch eng Äntwert mat enger eenzeger Propos',
	'qp_error_category_name_empty' => 'Den Numm vun der Kategorie ass eidel',
	'qp_error_proposal_text_empty' => 'Den Text vum Virschlag ass eidel',
	'qp_error_numeric_proposal_name' => 'De Numm vun der Propos däerf net numeresch sinn.',
	'qp_error_too_few_categories' => 'Et musse mindestens zwou Kategorien definéiert sinn',
	'qp_error_too_few_spans' => 'All Kategoriegrupp muss mindestens aus zwou Ënnerkategorie bestoen',
	'qp_error_no_answer' => 'Propos ouni Äntwert',
	'qp_error_not_enough_categories_answered' => 'Net genuch Kategorien erausgesicht.',
	'qp_error_eval_unsupported_language' => 'Net ënnerstëtzte Interpretatiouns-Sprooch "$1"',
	'qp_error_eval_illegal_token' => 'PHP-Token $1 mam Wäert $2 ass an der Linn $3 net erlaabt.',
	'qp_error_eval_illegal_variable_name' => 'PHP-Token $1 huet den net erlaabten Numm $2 als Variabel an der Linn $3.',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'qp_export_to_xls' => 'Avoaka rakitra XLS ny statistika',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'pollresults' => 'Резултати од анкетите на ова мрежно место',
	'qpollwebinstall' => 'Инсталација / поднова на додатокот QPoll',
	'qp_desc' => 'Овозможува создавање на анкети',
	'qp_desc-sp' => '[[Special:PollResults|Специјална страница]] за преглед на резултати од анкетите',
	'qp_result_NA' => 'Без одговор',
	'qp_result_error' => 'Синтаксна грешка',
	'qp_vote_button' => 'Гласај',
	'qp_vote_again_button' => 'Прегласај',
	'qp_submit_attempts_left' => 'Преостануваат $1 {{PLURAL:$1|обид|обиди}}',
	'qp_polls_list' => 'Список на сите анкети',
	'qp_users_list' => 'Список на сите корисници',
	'qp_browse_to_poll' => 'Прејди на $1',
	'qp_browse_to_user' => 'Прејди на $1',
	'qp_browse_to_interpretation' => 'Прејди на $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|глас|гласа}}',
	'qp_source_link' => 'Извор',
	'qp_stats_link' => 'Статистики',
	'qp_users_link' => 'Корисници',
	'qp_voice_link' => 'Кориснички глас',
	'qp_voice_link_inv' => 'Кориснички глас?',
	'qp_user_polls_link' => 'Учествувал во $1 {{PLURAL:$1|анкета|анкети}}',
	'qp_user_missing_polls_link' => 'Без одзив',
	'qp_not_participated_link' => 'Не учествувале',
	'qp_order_by_username' => 'Подреди по корисничко име',
	'qp_order_by_polls_count' => 'Подреди по број на анкети',
	'qp_results_line_qupl' => 'Страница „$1“ Анкета „$2“: $3',
	'qp_results_line_qpl' => 'Страница „$1“ Анкета „$2“: $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Страница „$2“ Анкета „$3“ ]',
	'qp_results_submit_attempts' => 'Обиди за поднесување: $1',
	'qp_results_interpretation_header' => 'Толкување на одговорот',
	'qp_results_short_interpretation' => 'Кратко толкување',
	'qp_results_long_interpretation' => 'Долго толкување',
	'qp_results_structured_interpretation' => 'Структурирано толкување',
	'qp_poll_has_no_interpretation' => 'Оваа анкета нема зададено шаблон за толкување во заглавието',
	'qp_interpetation_wrong_answer' => 'Погрешен одговор',
	'qp_export_to_xls' => 'Извези ги статистиките во XLS формат',
	'qp_voices_to_xls' => 'Извези гласови во XLS-формат',
	'qp_interpretation_results_to_xls' => 'Извези толкувања на одговори во XLS-формат',
	'qp_users_answered_questions' => 'На прашањата $1 {{PLURAL:$1|одговорил $1 корисник|одговориле $1 корисници}}',
	'qp_func_no_such_poll' => 'Нема таква анкета ($1)',
	'qp_func_missing_question_id' => 'Назначете постоечка назнака за прашањето (започнувајќи со 1) за анкетата $1',
	'qp_func_invalid_question_id' => 'Неважечка назнака на прашањето id=$2 (не е број) за анкетата $1',
	'qp_func_missing_proposal_id' => 'Назначете постоечкa назнака за предлогот (започнувајќи со 0) за анкетата $1, прашање $2',
	'qp_func_invalid_proposal_id' => 'Неважечки предлог id=$3 на предлог (не е број) за анкетата $1, прашање $2',
	'qp_error_no_such_poll' => 'Нема таква анкета ($1).
Проверете дали анкетата е утврдена и зачувана, и осигурајте се дека во адресата користите разграничен знак #',
	'qp_error_in_question_header' => 'Погрешно заглавие за прашањето: $1',
	'qp_error_id_in_stats_mode' => 'Не можам да утврдам назнака за анкетата во статистички режим.',
	'qp_error_dependance_in_stats_mode' => 'Не можете да утврдите ланец на зависност за анкетата во статистички режим',
	'qp_error_no_stats' => 'Нема достапни статистички податоци, бидејќи сè уште никој нема гласано на оваа анкета (address=$1)',
	'qp_error_address_in_decl_mode' => 'Не може да се дава адреса на анкетата во утврдувачки режим',
	'qp_error_question_not_implemented' => 'Прашањата од таков тип не се имплементираат: $1',
	'qp_error_question_empty_body' => 'Содржината на прашањето е празна.',
	'qp_error_question_no_proposals' => 'Прашањето нема зададено ниту еден предлог.',
	'qp_error_invalid_question_type' => 'Неважечки тип на прашање: $1',
	'qp_error_invalid_question_name' => 'Неважечко име на прашањето: $1.',
	'qp_error_type_in_stats_mode' => 'Не може да се определува тип на прашање во статистички режим: $1',
	'qp_error_no_poll_id' => 'Ознаката на анкетата нема определено атрибут за назнака („id“).',
	'qp_error_invalid_poll_id' => 'Неважечка назнака на анкетата (id=$1).
Назнаката може да содржи само букви, бројки и знак за место (проред)',
	'qp_error_already_used_poll_id' => 'Назнаката на анкетата веќе се користи на оваа страница (id=$1).',
	'qp_error_too_long_dependance_value' => 'Вредноста (dependance="$2") на атрибутот за зависноста на анкетата (id=$1) е предолга за може да се складира во базата.',
	'qp_error_invalid_dependance_value' => 'Ланецот на зависност за анкетата (id=$1) има неважечка вредност во атрибутот за зависност (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Анкетата (id=$1) е зависна од друга анкета (id=$3) од страницата [[$2]], но насловот [[$2]] не беше најден.
Или отстранете го атрибутот за зависност, или вратете ја страницата [[$2]]',
	'qp_error_missed_dependance_poll' => 'Анкетата (id=$1) е зависна од друга анкета (id=$3) на страницата $2, но таа анкета не постои или сè уште не е зачувана.
Или отстранете го атрибутот за зависност, или создајде анкета со id=$3 на страницата $2 и зачувајте ја.
За да зачувате анкета, притиснете на „Гласај“ но притоа без да одговорите на ниеден предлог (прашање).',
	'qp_error_vote_dependance_poll' => 'Прво одговорете на анкетата $1.',
	'qp_error_too_many_spans' => 'Премногу категориски групи за вкупниот број на утврдени поткатегории',
	'qp_error_unanswered_span' => 'Неодговорена поткатегорија',
	'qp_error_non_unique_choice' => 'Ова прашање бара одговор кој не е даден претходно',
	'qp_error_category_name_empty' => 'Името на категоријата е празно',
	'qp_error_proposal_text_empty' => 'Текстот за предлог е празен',
	'qp_error_too_long_category_option_value' => 'Можноста за категоријата е предолга за да може да се зачува во базата.',
	'qp_error_too_long_category_options_values' => 'Можностите за категоријата се предолги за да можат да се зачуваат во базата.',
	'qp_error_too_long_proposal_text' => 'Текстот на предлогот е предолг за да може да се складира во базата',
	'qp_error_too_long_proposal_name' => 'Името на предлогот е предолго за да се зачува во базата.',
	'qp_error_multiline_proposal_name' => 'Името на предлогот не може да содржи повеќе од еден ред текст.',
	'qp_error_numeric_proposal_name' => 'Името на предлогот не може да биде број.',
	'qp_error_too_few_categories' => 'Мора да определите барем две категории',
	'qp_error_too_few_spans' => 'Секоја класа на категории бара да определите барем два можни одговора',
	'qp_error_no_answer' => 'Неодговорен предлог',
	'qp_error_not_enough_categories_answered' => 'Немате одбрано доволно категории.',
	'qp_error_unique' => 'Прашањето од типот unique() има определено повеќе предлози од можни одговори: одговарањето на прашањето е неизводливо',
	'qp_error_no_more_attempts' => 'Бројот на обиди за поднесување на одговор е исцрпен',
	'qp_error_no_interpretation' => 'Толковната скрипта не постои',
	'qp_error_interpretation_no_return' => 'Скриптата за толкување не врати резултати',
	'qp_error_structured_interpretation_is_too_long' => 'Структурираното толкување е предолго за да може да се зачува во базата. Исправете ја толковната скрипта.',
	'qp_error_no_json_decode' => 'Толкувањето на анкетните одговори ја бара PHP-функцијата json_decode()',
	'qp_error_eval_missed_lang_attr' => 'Потребен е XML-атрибутотот „lang“ за да се избере сооветен јазик на толкувањето',
	'qp_error_eval_mix_languages' => 'Една толковна скрипта не може да меша различни толковни јазици: „$1“, „$2“',
	'qp_error_eval_unsupported_language' => 'Неподдржан толковен јазик „$1“',
	'qp_error_eval_illegal_token' => 'PHP-жетонот $1 со вредност $2 не е дозволен во редот $3',
	'qp_error_eval_illegal_superglobal' => 'PHP-жетонот $1 со суперглобала $2 не е дозволен во редот $3',
	'qp_error_eval_illegal_function_call' => 'PHP-жетонот $1 со функција $2 не е дозволен во редот $3',
	'qp_error_eval_variable_variable_access' => 'PHP-жетонот $1 со променлива $2 не е дозволен во редот $3',
	'qp_error_eval_illegal_variable_name' => 'PHP-жетонот $1 во во редот $3 има променлива $2 чие име е недозволено',
	'qp_error_eval_variable_function_call' => 'PHP-жетонот $1 со променлива функција $2 не е дозволен во редот $3',
	'qp_error_eval_self_check' => 'Следнава самопроверка на eval() не успеа: $1. Имате неподдржана верзија на PHP, која не дозволува работење со „eval“-скрипти на безбеден начин.',
	'qp_error_eval_unable_to_lint' => 'Не можам да расчленам (проверете ја поставеноста на системот)',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'qp_vote_button' => 'Undi',
	'qp_source_link' => 'Sumber',
	'qp_users_link' => 'Pengguna',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'pollresults' => 'Resultater fra spørreundersøkelsen på denne siden',
	'qp_desc' => 'Tillater opprettelse av spørreundersøkelser',
	'qp_desc-sp' => '[[Special:PollResults|Spesialside]] for visning av resultater fra spørreundersøkelsene',
	'qp_result_NA' => 'Ikke besvart',
	'qp_result_error' => 'Syntaksfeil',
	'qp_vote_button' => 'Stem',
	'qp_vote_again_button' => 'Endre din stemme',
	'qp_polls_list' => 'List opp alle spørreundersøkelser',
	'qp_users_list' => 'List opp alle brukere',
	'qp_browse_to_poll' => 'Bla igjennom til $1',
	'qp_browse_to_user' => 'Bla igjennom til $1',
	'qp_votes_count' => '{{PLURAL:$1|Én stemme|$1 stemmer}}',
	'qp_source_link' => 'Kilde',
	'qp_stats_link' => 'Statistikk',
	'qp_users_link' => 'Brukere',
	'qp_voice_link' => 'Brukerstemme',
	'qp_voice_link_inv' => 'Brukerstemme?',
	'qp_user_polls_link' => 'Deltok i {{PLURAL:$1|én spørreundersøkelse|$1 spørreundersøkelser}}',
	'qp_user_missing_polls_link' => 'Ingen deltakelse',
	'qp_not_participated_link' => 'Ikke deltatt',
	'qp_order_by_username' => 'Sorter etter brukernavn',
	'qp_order_by_polls_count' => 'Sorter etter antall spørreundersøkelser',
	'qp_results_line_qupl' => 'Side «$1» Spørreundersøkelse «$2»: $3',
	'qp_results_line_qpl' => 'Side «$1» Spørreundersøkelse «$2»: $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Side «$2» Spørreundersøkelse «$3» ]',
	'qp_export_to_xls' => 'Eksporter statistikk til XLS-format',
	'qp_voices_to_xls' => 'Eksporter stemmer til XLS-format',
	'qp_users_answered_questions' => '{{PLURAL:$1|Én bruker|$1 brukere}} besvarte spørsmålene',
	'qp_func_no_such_poll' => 'Ingen slik spørreundersøkelse ($1)',
	'qp_func_missing_question_id' => 'Vennligst oppgi en eksisterende spørsmåls-ID (starter fra 1) for spørreundersøkelsen $1',
	'qp_func_invalid_question_id' => 'Ugyldig spørsmåls-id=$2 (ikke et tall) for spørreundersøkelsen $1',
	'qp_func_missing_proposal_id' => 'Vennligst oppgi en eksisterende forslags-id (starter fra 0) for spørreundersøkelsen $1, spørsmål $2',
	'qp_func_invalid_proposal_id' => 'Ugyldig forslags-id=$3 (ikke et tall) for spørreundersøkelsen $1, spørsmål $2',
	'qp_error_no_such_poll' => 'Ingen slik spørreundersøkelse ($1).
Vær sikker på at spørreundersøkelsen ble deklarert og lagret, vær også sikker på at tegnet # blir brukt som addresse avgrenser',
	'qp_error_in_question_header' => 'Ugyldig spørsmålsoverskrift: $1',
	'qp_error_id_in_stats_mode' => 'Kan ikke deklarere en ID for spørreundersøkelsen i statistikkmodus',
	'qp_error_dependance_in_stats_mode' => 'Kan ikke deklarere kjede av avhengigheter for spørreundersøkelsen i statistikkmodus',
	'qp_error_no_stats' => 'Ingen statistiske data er tilgjengelig fordi ingen har stemt for denne spørreundersøkelsen enda (address=$1)',
	'qp_error_address_in_decl_mode' => 'Kan ikke få en adresse for spørreundersøkelsen i deklareringsmodus',
	'qp_error_question_not_implemented' => 'Spørsmål av en slik type er ikke implementert: $1',
	'qp_error_invalid_question_type' => 'Ugyldig spørsmålstype: $1',
	'qp_error_type_in_stats_mode' => 'Spørsmålstypen kan ikke defineres i statistisk visningsmodus: $1',
	'qp_error_no_poll_id' => 'Spørreundersøkelsesmerkelappen har ingen definerte id-atributter.',
	'qp_error_invalid_poll_id' => 'Ugyldig spørreundersøkelses-id (id=$1).
Spørreundersøkelses-id kan kun inneholde bokstaver, tall og mellomrom',
	'qp_error_already_used_poll_id' => 'Spørreundersøkelses-id-en har allerede blitt brukt på denne siden (id=$1).',
	'qp_error_invalid_dependance_value' => 'Spørreundersøkelsens (id=$1) kjede av avhengigheter har en ugyldig verdi av avhengighetsatributter (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Spørreundersøkelsen (id=$1) avhenger av en annen spørreundersøkelse (id=$3) fra side [[$2]], men tittelen [[$2]] ble ikke funnet.
Enten fjern avhengighetsatributten, eller gjenopprett [[$2]]',
	'qp_error_missed_dependance_poll' => 'Spørreundersøkelsen (id=$1) avhenger av en annen spørreundersøkelse (id=$3) på side $2, men den spørreundersøkelsen finnes ikke eller har ikke blitt lagret enda.
Enten fjern avhengighetsatributten eller opprett spørreundersøkelsen med id=$3 på siden $2 og lagre den.
For å lagre en spørreundersøkelse, send den mens du ikke svarer på noen forslagsspørsmål.',
	'qp_error_vote_dependance_poll' => 'Vennligst stem for spørreundersøkelsen $1 først.',
	'qp_error_too_many_spans' => 'For mange kategorigrupper for det totale antall underkategorier definert',
	'qp_error_unanswered_span' => 'Ubesvart underkategori',
	'qp_error_non_unique_choice' => 'Dette spørsmålet krever unikt forslagssvar',
	'qp_error_category_name_empty' => 'Kategorinavn er tomt',
	'qp_error_proposal_text_empty' => 'Forslagstekst er tom',
	'qp_error_too_few_categories' => 'Minst to kategorier må defineres',
	'qp_error_too_few_spans' => 'Hver kategorigruppe må inneholde minst to underkategorier',
	'qp_error_no_answer' => 'Ubesvart forslag',
	'qp_error_unique' => 'Spørsmål av typen unique() har flere forslag enn mulige definerte svar: umulig å gjennomføre',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Purodha
 * @author SPQRobin
 * @author Saruman
 * @author Siebrand
 */
$messages['nl'] = array(
	'pollresults' => 'Resultaten van de stemmingen op deze site',
	'qpollwebinstall' => 'Uitbreiding QPoll installeren of bijwerken',
	'qp_desc' => 'Maakt het aanmaken van peilingen mogelijk',
	'qp_desc-sp' => '[[Special:PollResults|Speciale pagina]] voor het bekijken van de resultaten van peilingen',
	'qp_result_NA' => 'Niet beantwoord',
	'qp_result_error' => 'Er zit een fout in de syntaxis',
	'qp_vote_button' => 'Stemmen',
	'qp_vote_again_button' => 'Stem wijzigen',
	'qp_submit_attempts_left' => '$1 {{PLURAL:$1|poging|pogingen}} over',
	'qp_polls_list' => 'Alle peilingen weergeven',
	'qp_users_list' => 'Alle gebruikers weergeven',
	'qp_browse_to_poll' => 'Naar de peiling $1',
	'qp_browse_to_user' => 'Naar gebruiker $1',
	'qp_browse_to_interpretation' => 'Bladeren naar $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|stem|stemmen}}',
	'qp_source_link' => 'Bron',
	'qp_stats_link' => 'Statistieken',
	'qp_users_link' => 'Gebruikers',
	'qp_voice_link' => 'Gebruikersstem',
	'qp_voice_link_inv' => 'Gebruikersstem?',
	'qp_user_polls_link' => 'Heeft deelgenomen aan $1 {{PLURAL:$1|peiling|peilingen}}',
	'qp_user_missing_polls_link' => 'Geen deelname',
	'qp_not_participated_link' => 'Niet deelgenomen',
	'qp_order_by_username' => 'Sorteren op gebruikersnaam',
	'qp_order_by_polls_count' => 'Sorteren op peilingenaantal',
	'qp_results_line_qupl' => 'Pagina "$1", peiling "$2": $3',
	'qp_results_line_qpl' => 'Pagina "$1", peiling "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ pagina "$2", peiling "$3" ]',
	'qp_header_line_qucl' => '$1. $2<br />$3 ??? $4',
	'qp_results_submit_attempts' => 'Pogingen tot opslaan: $1',
	'qp_results_interpretation_header' => 'Antwoordinterpretatie',
	'qp_results_short_interpretation' => 'Korte uitleg',
	'qp_results_long_interpretation' => 'Lange uitleg',
	'qp_results_structured_interpretation' => 'Gestructureerde interpretatie',
	'qp_poll_has_no_interpretation' => 'Voor deze peiling is geen uitlegsjabloon aangegeven in de koptekst van de peiling.',
	'qp_interpetation_wrong_answer' => 'Fout antwoord',
	'qp_export_to_xls' => 'Statistieken naar XLS-formaat exporteren',
	'qp_voices_to_xls' => 'Stemmen in XLS-formaat exporteren',
	'qp_interpretation_results_to_xls' => 'Antwoordinterpretaties exporteren naar XML-opmaak',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|gebruiker heeft|gebruikers hebben}} de vragen beantwoord',
	'qp_func_no_such_poll' => 'Die peiling bestaat niet ($1)',
	'qp_func_missing_question_id' => 'Geef alstublieft een vraag-ID op (begin bij 1) voor de peiling $1',
	'qp_func_invalid_question_id' => 'Ongeldig vraag-ID ($2 - geen getal) voor de peiling $1',
	'qp_func_missing_proposal_id' => 'Geef alstublieft een voorstel-ID op (begin bij 0) voor de peiling $1, vraag $2',
	'qp_func_invalid_proposal_id' => 'Ongeldig voorstel-ID ($3 - geen getal) voor de peiling $1, vraag $2',
	'qp_error_no_such_poll' => 'Die peiling bestaat niet ($1).
Zorg dat de peiling is ingesteld en opgeslagen, en dat het adresscheidingsteken "#" is gebruikt.',
	'qp_error_in_question_header' => 'Ongeldige kop voor vraag: $1',
	'qp_error_id_in_stats_mode' => 'Het is niet mogelijk een ID voor de peiling te declareren in de statistische modus',
	'qp_error_dependance_in_stats_mode' => 'Het is niet mogelijk een afhankelijkheidsketen voor de peiling te declareren in de statistische modus',
	'qp_error_no_stats' => 'Er zijn geen statistische gegevens beschikbaar omdat er nog geen gebruikers hebben gestemd in deze peiling (adres $1)',
	'qp_error_address_in_decl_mode' => 'Het is niet mogelijk een adres van de peiling op te vragen in de declaratiemodus',
	'qp_error_question_not_implemented' => 'Vragen van dit type zijn niet beschikbaar: $1',
	'qp_error_question_empty_body' => 'Het invoerveld voor de vraag is leeg.',
	'qp_error_question_no_proposals' => 'Er zijn geen voorstellen voor de vraag opgegeven.',
	'qp_error_invalid_question_type' => 'Ongeldig vraagtype: $1',
	'qp_error_invalid_question_name' => 'Ongeldige vraagnaam: $1.',
	'qp_error_type_in_stats_mode' => 'Het vraagtype kan niet gedefinieerd wordne in de statistische weergavemodus: $1',
	'qp_error_no_poll_id' => 'De eigenschap "id" is niet gedefinieerd voor de peiling.',
	'qp_error_invalid_poll_id' => 'Ongeldig peiling-ID ($1)
Het ID mag alleen letters, cijfers en spaties bevatten.',
	'qp_error_already_used_poll_id' => 'Het peilingsnummer wordt al gebruikt op deze pagina (ID $1)',
	'qp_error_too_long_dependance_value' => 'De waarde van het afhankelijkheidsattribuut (dependance=$2) van de peiling (id=$1) is te lang om opgeslagen te kunnen worden in de database.',
	'qp_error_invalid_dependance_value' => 'De peilingafhankelijkheidsketen (ID $1) heeft een ongeldige waarde voor de afhankelijkheidseigenschap (dependance "$2")',
	'qp_error_missed_dependance_title' => 'De peiling (ID $1) is afhankelijk van een andere peiling (ID $3) op pagina [[$2]], maar de pagina [[$2]] bestaat niet.
Verwijder de eigenschap "dependance" of plaats de pagina [[$2]] terug.',
	'qp_error_missed_dependance_poll' => 'De peiling (ID $1) is afhankelijk van een andere peiling (ID $3) op pagina $2, maar die peiling bestaat niet of is nog niet opgeslagen.
Verwijder de eigenschap "dependance" of maak een peiling aan met het ID $3 op pagina $2.
Sla een peiling op door deze op te slaan zonder dat enig voorstel is beantwoord.',
	'qp_error_vote_dependance_poll' => 'Stem alstublieft eerst in de peiling $1.',
	'qp_error_too_many_spans' => 'Er zijn te veel categorieklassen voor de subcategorieën gedefinieerd',
	'qp_error_unanswered_span' => 'Onbeantwoorde subcategorie',
	'qp_error_non_unique_choice' => 'Voor deze vraag is een uniek voorstelantwoord nodig',
	'qp_error_category_name_empty' => 'Er is geen categorienaam opgegeven',
	'qp_error_proposal_text_empty' => 'Er is geen voorsteltekst opgegeven',
	'qp_error_too_long_category_option_value' => 'De categorie-optiewaarde is te lang om opgeslagen te kunnen worden in de database.',
	'qp_error_too_long_category_options_values' => 'De categorie-optiewaarden zijn te lang om opgeslagen te kunnen worden in de database.',
	'qp_error_too_long_proposal_text' => 'Het tekstvoorstel is te lang om opgeslagen te kunnen worden in de database.',
	'qp_error_too_long_proposal_name' => 'De voorstelnaam is te lang om te worden opgeslagen in de database.',
	'qp_error_multiline_proposal_name' => 'De voorstelnaam kan niet bestaan uit meerdere regels tekst.',
	'qp_error_numeric_proposal_name' => 'De naam van het voorstel mag niet numeriek zijn.',
	'qp_error_too_few_categories' => 'Er moeten tenminste twee categorieën gedefinieerd worden.',
	'qp_error_too_few_spans' => 'Voor iedere categorieklasse dienen tenminste twee mogelijk antwoorden gedefinieerd te zijn',
	'qp_error_no_answer' => 'Onbeantwoord voorstel',
	'qp_error_not_enough_categories_answered' => 'Er zijn niet genoeg categorieën geselecteerd.',
	'qp_error_unique' => 'Voor de vraag van het type unique() zijn meer voorstellen dan mogelijke antwoorden gedefinieerd. Dat is niet recht te breien.',
	'qp_error_no_more_attempts' => 'U hebt bereikt maximale aantal pogingen voor meedoen in deze peiling bereikt.',
	'qp_error_no_interpretation' => 'Het interpretatiescript bestaat niet.',
	'qp_error_interpretation_no_return' => 'Het uitlegscript had geen resultaat.',
	'qp_error_structured_interpretation_is_too_long' => 'De gestructureerde interpretatie is te lang om op te slaan in de database. Corrigeer uw interpretatiescript.',
	'qp_error_no_json_decode' => 'Voor de interpretatie van peilingresultaten  is de PHP-functie json_decode() nodig.',
	'qp_error_eval_missed_lang_attr' => 'Het XML-attribuut "lang" is verplicht om een correct interpretatietaal te kiezen.',
	'qp_error_eval_mix_languages' => 'Bij enkelvoudige schriftinterpretatie kunnen geen twee verschillende interpretatietalen gebruikt worden: "$1" en "$2".',
	'qp_error_eval_unsupported_language' => 'Niet-ondersteunde interpretatietaal: "$1".',
	'qp_error_eval_illegal_token' => 'Het PHP-token $1 met de waarde $2 is niet toegestaan in regel $3.',
	'qp_error_eval_illegal_superglobal' => 'Het PHP-token $1 met de superglobal $2 is niet toegestaan in regel $3.',
	'qp_error_eval_illegal_function_call' => 'Het PHP-token $1 met de functie $2 is niet toegestaan in regel $3.',
	'qp_error_eval_variable_variable_access' => 'Het PHP-token $1 met de variabele variabele $2 is niet toegestaan in regel $3.',
	'qp_error_eval_illegal_variable_name' => 'Het PHP-token $1 heeft een ongeldige variabelenaam $2 in regel $3.',
	'qp_error_eval_variable_function_call' => 'Het PHP-token $1 met de variabele functie $2 is niet toegestaan in regel $3.',
	'qp_error_eval_self_check' => 'De volgende zelfcontrole met eval() is mislukt: $1. U gebruikt een niet-ondersteunde versie van PHP waarmee eval-scripts niet veilig kunnen worden uitgevoerd.',
	'qp_error_eval_unable_to_lint' => 'Lint uitvoeren was niet mogelijk. Controleer uw systeeminstellingen.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 */
$messages['nn'] = array(
	'qp_result_NA' => 'Ikkje svar',
	'qp_users_list' => 'List opp alle brukarar',
	'qp_source_link' => 'Kjelde',
	'qp_stats_link' => 'Statistikk',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'qp_stats_link' => 'Schdadischdik',
);

/** Polish (Polski)
 * @author Odder
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'pollresults' => 'Wyniki ankiet na tej witrynie',
	'qp_desc' => 'Pozwala na tworzenie ankiet',
	'qp_desc-sp' => '[[Special:PollResults|Strona specjalna]] z wynikami ankiet',
	'qp_result_NA' => 'Brak odpowiedzi',
	'qp_result_error' => 'Błąd składni',
	'qp_vote_button' => 'Zapisz głos',
	'qp_vote_again_button' => 'Zmień głos',
	'qp_polls_list' => 'Spis wszystkich ankiet',
	'qp_users_list' => 'Spis wszystkich użytkowników',
	'qp_browse_to_poll' => 'Przeglądaj do $1',
	'qp_browse_to_user' => 'Przeglądaj do $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|głos|głosy|głosów}}',
	'qp_source_link' => 'źródło',
	'qp_stats_link' => 'statystyki',
	'qp_users_link' => 'użytkownicy',
	'qp_voice_link' => 'Głos użytkownika',
	'qp_voice_link_inv' => 'Głos użytkownika?',
	'qp_user_polls_link' => 'Brał udział w $1 {{PLURAL:$1|ankiecie|ankietach}}',
	'qp_user_missing_polls_link' => '{{GENDER:$1|Nie brał|Nie brała|Brak}} udziału',
	'qp_not_participated_link' => 'brak udziału',
	'qp_order_by_username' => 'Posortowane względem nazwy użytkownika',
	'qp_order_by_polls_count' => 'Posortowane względem liczby uczestników ankiety',
	'qp_results_line_qupl' => 'Strona „$1” ankieta „$2” – $3',
	'qp_results_line_qpl' => 'Strona „$1” ankieta „$2” – $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Strona „$2” ankieta „$3” ]',
	'qp_export_to_xls' => 'Eksport statystyk w formacie XLS',
	'qp_voices_to_xls' => 'Eksport głosów w formacie XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|użytkownik odpowiedział|użytkowników odpowiedziało}} na pytania',
	'qp_func_no_such_poll' => 'Brak takiej ankiety ($1)',
	'qp_func_missing_question_id' => 'Określ istniejący identyfikator pytania (zaczynając od 1) dla ankiety $1',
	'qp_func_invalid_question_id' => 'Nieprawidłowy identyfikator $2 pytania (nie jest to numer) dla ankiety $1',
	'qp_func_missing_proposal_id' => 'Określ identyfikator istniejącej propozycji (zaczynając od 0) dla pytania $2 z ankiety $1',
	'qp_func_invalid_proposal_id' => 'Nieprawidłowy identyfikator $3 propozycji (to nie jest numer) pytania $2 w ankiecie $1',
	'qp_error_no_such_poll' => 'Brak takiej ankiety ($1).
Upewnij się, że ankieta została zadeklarowana i zapisana oraz, że użyłeś jako ogranicznika adresu znaku #',
	'qp_error_in_question_header' => 'Nieprawidłowy nagłówek pytania – $1',
	'qp_error_id_in_stats_mode' => 'Nie można zadeklarować identyfikatora ankiety w trybie statycznym',
	'qp_error_dependance_in_stats_mode' => 'Nie można zadeklarować łańcucha zależności ankiety w trybie statystycznym',
	'qp_error_no_stats' => 'Brak danych statystycznych, ponieważ nikt jeszcze nie brał udziału w tej ankiecie (adres=$1)',
	'qp_error_address_in_decl_mode' => 'Nie można uzyskać adresu ankiety w trybie deklaracji',
	'qp_error_question_not_implemented' => 'Pytania tego typu nie zostały jeszcze zaimplementowane – $1',
	'qp_error_invalid_question_type' => 'Nieprawidłowy typ pytania – $1',
	'qp_error_type_in_stats_mode' => 'Typ pytania nie może być definiowany w trybie wyświetlania statystyki – $1',
	'qp_error_no_poll_id' => 'Znacznik ankiety nie ma zdefiniowanego atrybutu identyfikatora.',
	'qp_error_invalid_poll_id' => 'Nieprawidłowy identyfikator ankiety (id=$1).
Identyfikator ankiety może zawierać wyłączanie litery, cyfry i znak odstępu',
	'qp_error_already_used_poll_id' => 'Identyfikator ankiety został już użyty na tej stronie (id=$1).',
	'qp_error_invalid_dependance_value' => 'Łańcuch zależności ankiety (id=$1) ma nieprawidłową wartość atrybutu zależności (dependence=„$2”)',
	'qp_error_missed_dependance_title' => 'Ankieta (id=$1) jest uzależniona od innej ankiety (id=$3) ze strony [[$2]], ale tytuł [[$2]] nie został odnaleziony.
Należy usunąć atrybut zależności lub przywrócić [[$2]]',
	'qp_error_missed_dependance_poll' => 'Ankieta (id=$1) jest uzależniona od innej ankiety (id=$3) na stronie $2, ale ankieta nie istnieje lub nie została jeszcze zapisana.
Należy usunąć atrybut zależności lub utworzyć ankietę z id=$3 na stronie $2 i ją zapisać.
Aby zapisać ankietę, zapisz ją bez odpowiadania na jakiekolwiek proponowane pytania.',
	'qp_error_vote_dependance_poll' => 'Najpierw weź udział w ankiecie $1.',
	'qp_error_too_many_spans' => 'Zbyt wiele grup kategorii dla ogólnej liczby zdefiniowanych podkategorii',
	'qp_error_unanswered_span' => 'Podkategoria bez odpowiedzi',
	'qp_error_non_unique_choice' => 'To pytanie wymaga udzielenia unikalnej odpowiedzi',
	'qp_error_category_name_empty' => 'Nazwa kategorii jest pusta',
	'qp_error_proposal_text_empty' => 'Tekst odpowiedzi jest pusty',
	'qp_error_too_few_categories' => 'Należy wybrać co najmniej dwie kategorie',
	'qp_error_too_few_spans' => 'Każda grupa kategorii musi zawierać co najmniej dwie podkategorie',
	'qp_error_no_answer' => 'Pytanie bez odpowiedzi',
	'qp_error_unique' => 'Pytanie typu unique() ma więcej propozycji odpowiedzi niż zdefiniowano jako dopuszczalne – brak możliwości zakończenia',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'pollresults' => 'Arzultà dij sondagi an sto sit-sì',
	'qp_desc' => 'A përmet la creassion ëd sondagi',
	'qp_desc-sp' => "[[Special:PollResults|Pàgina special]] për vëdde j'arzultà dij sondagi",
	'qp_result_NA' => 'Pa arspondù',
	'qp_result_error' => 'Eror ëd sintassi',
	'qp_vote_button' => 'Vot',
	'qp_vote_again_button' => 'Cangia tò vot',
	'qp_polls_list' => 'Lista tùit ij sondagi',
	'qp_users_list' => "Lista tùit j'utent",
	'qp_browse_to_poll' => 'Andé fin-a a $1',
	'qp_browse_to_user' => 'Andé fin-a a $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|vot|vot}}',
	'qp_source_link' => 'Sorgiss',
	'qp_stats_link' => 'Statìstiche',
	'qp_users_link' => 'Utent',
	'qp_voice_link' => "Vos ëd l'utent",
	'qp_voice_link_inv' => "Vos ëd l'utent?",
	'qp_user_polls_link' => 'Partessipà a $1 {{PLURAL:$1|sondagi|sondagi}}',
	'qp_user_missing_polls_link' => 'Gnun-e partessipassion',
	'qp_not_participated_link' => 'Pa partessipà',
	'qp_order_by_username' => 'Ordiné për nòm utent',
	'qp_order_by_polls_count' => 'Ordiné për nùmer ëd sondagi',
	'qp_results_line_qupl' => 'Pàgina "$1" Sondagi "$2": "$3"',
	'qp_results_line_qpl' => 'Pàgina "$1" Sondagi "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Pàgina "$2" Sondagi "$3" ]',
	'qp_export_to_xls' => 'Espòrta statìstiche an formà XLS',
	'qp_voices_to_xls' => 'Espòrta ij vot an formà XLS',
	'qp_users_answered_questions' => "$1 {{PLURAL:$1|utent|utent}} a l'han arspondù a la custion",
	'qp_func_no_such_poll' => 'Ël sondagi a esist pa ($1)',
	'qp_func_missing_question_id' => "Për piasì specìfica n'id ëd custion esistent (partend da 1) për ël sondagi $1",
	'qp_func_invalid_question_id' => 'Id custion=$2 pa bon (pa un nùmer) për ël sondagi $1',
	'qp_func_missing_proposal_id' => "Për piasì specifica n'id propòsta esistent (an partend da 0) për ël sondagi $1, chestion $2",
	'qp_func_invalid_proposal_id' => 'Id propòsta=$3 pa bon (pa un nùmer) për ël sondagi $1, chestion $2',
	'qp_error_no_such_poll' => "Sondagi pa esistent ($1).
Sicurte che ël sondagi a sia diciarà e salvà, ëdcò sicurte ëd dovré ël caràter delimitador d'adrësse #",
	'qp_error_in_question_header' => 'Antestassion dla chestion pa bon-a: $1',
	'qp_error_id_in_stats_mode' => "As peul pa diciaresse n'ID ëd sondagi an manera statìstica",
	'qp_error_dependance_in_stats_mode' => 'As peul pa diciaresse na caden-a ëd dipendensa dël sondagi an manera statìstica',
	'qp_error_no_stats' => "Pa gnun dat statìstich a son disponìbij, përchè gnun a l'ha votà për sto sondagi-sì, për adess (adrëssa=$1)",
	'qp_error_address_in_decl_mode' => "As peul pa pijé n'adrëssa dël sondagi an manera diciarativa",
	'qp_error_question_not_implemented' => 'Chestion dë sta sòrt-sì a son pa sostnùe: $1',
	'qp_error_invalid_question_type' => 'Sòrt ëd custion pa bon-a: $1',
	'qp_error_type_in_stats_mode' => 'Le Sòrt ëd custion a peulo pa esse definìe an manera statìstica: $1',
	'qp_error_no_poll_id' => "L'etichëtta dël sondagi a l'ha gnun atribù definì.",
	'qp_error_invalid_poll_id' => "Id dël sondagi pa bon (id=$1).
L'id dël sondagi a peul conten-e mach litre, nùmer e caràter dë spassi",
	'qp_error_already_used_poll_id' => "L'id dël sondagi a l'é già stàit dovrà an sta pàgina (id=$1).",
	'qp_error_invalid_dependance_value' => 'La caden-a ëd dipendensa dël sondagi (id=$1) a l\'ha valor pa bon ëd l\'atribù ëd dipendensa (dipendensa="$2")',
	'qp_error_missed_dependance_title' => "Ël sondagi (id=$1) a l'é dipendent da n'àutr sondagi (id=$3) ëd pàgina [[$2]], ma ël tìtol [[$2]] a l'é pa stàit trovà.
Ch'a gava l'atribù ëd dipendensa, o ch'a buta torna [[$2]]",
	'qp_error_missed_dependance_poll' => "Ël sondagi (id=$1) a l'é dipendent da n'àutr sondagi (id=$3) a pàgina $2, ma ël sondagi a esist pa o a l'é pa stàit ancor salvà.
Ch'a gava l'atribù ëd dipendensa, o ch'a crea ël sondagi con id=$3 a la pàgina $2 e ch'a lo salva.
Për salvé un sondagi, ch'a lo spedissa sensa arsponde a gnun-e custion ëd propòsta.",
	'qp_error_vote_dependance_poll' => 'Për piasì vòta për ël sondagi $1 prima.',
	'qp_error_too_many_spans' => 'Tròpe partìe ëd categorìe për ël nùmer total ëd sot-categorìe definìe',
	'qp_error_unanswered_span' => 'Sotcategorìe pa arspondùe',
	'qp_error_non_unique_choice' => 'Sta custion-sì a veul na sola arspòsta ëd propòsta',
	'qp_error_category_name_empty' => "Ël nòm categorìa a l'é veuid",
	'qp_error_proposal_text_empty' => "Ël test ëd propòsta a l'é veuid",
	'qp_error_too_few_categories' => 'Almanch doe categorìe a devo esse definìe',
	'qp_error_too_few_spans' => 'Minca partìa ëd categorìe a deuv conten-e almanch doe sot-categorìe',
	'qp_error_no_answer' => 'Propòsta sensa rispòsta',
	'qp_error_unique' => "La custion ëd sòrt ùnica() a l'ha pi propòste che arspòste possìbij definìe: impossìbil da completé",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'qp_result_NA' => 'بې ځوابه',
	'qp_vote_button' => 'رايه ورکول',
	'qp_vote_again_button' => 'خپله رايه بدلول',
	'qp_users_list' => 'د ټولو کارنانو لړليک جوړول',
	'qp_votes_count' => '$1 {{PLURAL:$1|رايه|رايې}}',
	'qp_source_link' => 'سرچينه',
	'qp_users_link' => 'کارنان',
	'qp_order_by_username' => 'د کارن-نوم له مخې اوډل',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|کارن|کارنانو}} پوښتنې ځواب کړې',
	'qp_error_invalid_question_type' => 'د ناسمې پوښتنې ډول: $1',
	'qp_error_unanswered_span' => 'بې ځوابه څېرمه وېشنيزه',
	'qp_error_category_name_empty' => 'د وېشنيزې نوم تش دی',
	'qp_error_no_answer' => 'بې ځوابه وړانديز',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'pollresults' => 'Resultados das sondagens neste síte',
	'qp_desc' => 'Permite a criação de sondagens',
	'qp_desc-sp' => '[[Special:PollResults|Página especial]] para ver os resultados das sondagens',
	'qp_result_NA' => 'Sem resposta',
	'qp_result_error' => 'Erro sintáctico',
	'qp_vote_button' => 'Vote',
	'qp_vote_again_button' => 'Altere o seu voto',
	'qp_submit_attempts_left' => '$1 {{PLURAL:$1|falta uma tentativa|faltam $1 tentativas}}',
	'qp_polls_list' => 'Listar todas as sondagens',
	'qp_users_list' => 'Listar todos os utilizadores',
	'qp_browse_to_poll' => 'Navegar para $1',
	'qp_browse_to_user' => 'Navegar para $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|voto|votos}}',
	'qp_source_link' => 'Fonte',
	'qp_stats_link' => 'Estatísticas',
	'qp_users_link' => 'Utilizadores',
	'qp_voice_link' => 'Voz do utilizador',
	'qp_voice_link_inv' => 'Voz do utilizador?',
	'qp_user_polls_link' => 'Participou {{PLURAL:$1|numa sondagem|em $1 sondagens}}',
	'qp_user_missing_polls_link' => 'Nenhuma participação',
	'qp_not_participated_link' => 'Não participada',
	'qp_order_by_username' => 'Ordenar por utilizador',
	'qp_order_by_polls_count' => 'Ordenar por contagem de sondagens',
	'qp_results_line_qupl' => 'Página "$1" Sondagem "$2": $3',
	'qp_results_line_qpl' => 'Página "$1" Sondagem "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Página "$2" Sondagem "$3" ]',
	'qp_results_submit_attempts' => 'Enviar tentativas: $1',
	'qp_results_interpretation_header' => 'Interpretação da resposta',
	'qp_results_short_interpretation' => 'Interpretação curta',
	'qp_results_long_interpretation' => 'Interpretação longa',
	'qp_poll_has_no_interpretation' => 'Esta sondagem não tem nenhum modelo de interpretação definido no cabeçalho',
	'qp_interpetation_wrong_answer' => 'Resposta errada',
	'qp_export_to_xls' => 'Exportar estatísticas para o formato XLS',
	'qp_voices_to_xls' => 'Exportar vozes para o formato XLS',
	'qp_users_answered_questions' => '{{PLURAL:$1|Um utilizador respondeu|$1 utilizadores responderam}} às questões',
	'qp_func_no_such_poll' => 'Sondagem inexistente ($1)',
	'qp_func_missing_question_id' => 'Por favor, especifique o número de uma pergunta existente (começando a partir de 1) para a sondagem $1',
	'qp_func_invalid_question_id' => 'Número de pergunta=$2 é inválido (não é numérico) para a sondagem $1',
	'qp_func_missing_proposal_id' => 'Por favor, especifique o número de uma proposta existente (começando a partir de 0) para a sondagem $1, pergunta $2',
	'qp_func_invalid_proposal_id' => 'Número de proposta=$3 é inválido (não é numérico) para a sondagem $1, pergunta $2',
	'qp_error_no_such_poll' => 'Sondagem inexistente ($1).
Verifique que a sondagem foi declarada e gravada, certifique-se também de que foi usado o carácter delimitador #',
	'qp_error_in_question_header' => 'Cabeçalho de pergunta inválido: $1',
	'qp_error_id_in_stats_mode' => 'Não é possível declarar um identificador da sondagem em modo estatístico',
	'qp_error_dependance_in_stats_mode' => 'Não é possível declarar uma cadeia de dependências da sondagem em modo estatístico',
	'qp_error_no_stats' => 'Não estão disponíveis dados estatísticos, porque ainda ninguém votou nesta sondagem (endereço=$1)',
	'qp_error_address_in_decl_mode' => 'Não é possível obter um endereço da sondagem em modo declarativo',
	'qp_error_question_not_implemented' => 'Não estão implementadas perguntas do tipo: $1',
	'qp_error_invalid_question_type' => 'Tipo de pergunta inválido: $1',
	'qp_error_type_in_stats_mode' => 'Não é possível definir no modo de visionamento estatístico o tipo de pergunta: $1',
	'qp_error_no_poll_id' => "Não foi definido um atributo de identificação no marcador ''(tag)'' da sondagem",
	'qp_error_invalid_poll_id' => 'Identificador de sondagem inválido (id=$1).
O identificador só pode conter letras, números e espaços',
	'qp_error_already_used_poll_id' => 'O identificador da sondagem (id=$1) já foi usado nesta página',
	'qp_error_invalid_dependance_value' => 'A cadeia de dependências da sondagem (id=$1) tem um valor inválido no atributo da dependência (dependance="$2")',
	'qp_error_missed_dependance_title' => 'A sondagem (id=$1) está dependente de outra sondagem (id=$3) da página [[$2]], mas o título [[$2]] não foi encontrado.
Remova o atributo da dependência ou restaure a página [[$2]]',
	'qp_error_missed_dependance_poll' => 'A sondagem (id=$1) está dependente de outra sondagem (id=$3) da página $2, mas essa sondagem não existe ou ainda não foi gravada.
Remova o atributo da dependência ou crie a sondagem com id=$3 na página $2 e grave-a.
Para gravar uma sondagem, submeta-a sem ter respondido a nenhuma pergunta.',
	'qp_error_vote_dependance_poll' => 'Por favor, vote na sondagem $1 antes.',
	'qp_error_too_many_spans' => 'Demasiadas classes de categorias para as subcategorias definidas',
	'qp_error_unanswered_span' => 'Subcategoria sem resposta',
	'qp_error_non_unique_choice' => 'Esta pergunta requer resposta a uma única proposta',
	'qp_error_category_name_empty' => 'O nome da categoria está vazio',
	'qp_error_proposal_text_empty' => 'O texto da proposta está vazio',
	'qp_error_too_few_categories' => 'Deve definir pelo menos duas categorias',
	'qp_error_too_few_spans' => 'Cada classe de categorias requer pelo menos duas respostas possíveis definidas',
	'qp_error_no_answer' => 'Proposta sem resposta',
	'qp_error_unique' => 'Pergunta do tipo unique() tem mais propostas definidas do que respostas possíveis: impossível de completar',
	'qp_error_no_more_attempts' => 'Atingiu o número máximo de tentativas de envio para esta sondagem',
	'qp_error_interpretation_no_return' => 'O código de interpretação não devolveu nenhum resultado',
	'qp_error_no_json_decode' => 'A interpretação das respostas da sondagem requer a função do PHP json_decode()',
	'qp_error_eval_missed_lang_attr' => 'O atributo XML "lang" é necessário para escolher a língua de interpretação adequada',
	'qp_error_eval_mix_languages' => 'Um único código de interpretação não pode misturar várias línguas de interpretação: "$1", "$2"',
	'qp_error_eval_unsupported_language' => 'A língua de interpretação "$1" não é suportada',
	'qp_error_eval_illegal_token' => 'A chave PHP $1, com o valor $2, não é permitida na linha $3',
	'qp_error_eval_illegal_superglobal' => 'A chave PHP $1, com a superglobal $2, não é permitida na linha $3',
	'qp_error_eval_illegal_function_call' => 'A chave PHP $1, com a função $2, não é permitida na linha $3',
	'qp_error_eval_variable_variable_access' => 'A chave PHP $1 com a variável de nome variável $2, não é permitida na linha $3',
	'qp_error_eval_illegal_variable_name' => 'A chave PHP $1 não permite o nome da variável $2 na linha $3',
	'qp_error_eval_variable_function_call' => 'A chave PHP $1 com a função variável $2 não é permitida na linha $3',
	'qp_error_eval_self_check' => 'A seguinte auto-verificação eval() falhou: $1. tem uma versão do PHP que não é suportada, o que não permite executar código eval de forma segura.',
	'qp_error_eval_unable_to_lint' => 'Não foi possível processar no lint (verifique a configuração do sistema)',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Luckas Blade
 * @author Raylton P. Sousa
 */
$messages['pt-br'] = array(
	'pollresults' => "Resultados de enquetes neste ''site''",
	'qp_desc' => 'Habilita a criação de enquetes',
	'qp_desc-sp' => '[[Special:PollResults|Página especial]] para visulizar os resultados das enquetes',
	'qp_result_NA' => 'Não respondido',
	'qp_result_error' => 'Erro de sintaxe',
	'qp_vote_button' => 'Votar',
	'qp_vote_again_button' => 'Alterar o seu voto',
	'qp_polls_list' => 'Listar todas as enquetes',
	'qp_users_list' => 'Listar todos os usuários',
	'qp_browse_to_poll' => 'Navegar para $1',
	'qp_browse_to_user' => 'Navegar para $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|voto|votos}}',
	'qp_source_link' => 'Fonte',
	'qp_stats_link' => 'Estatísticas',
	'qp_users_link' => 'Usuários',
	'qp_voice_link' => 'Voz do usuário',
	'qp_voice_link_inv' => 'Voz do usuário?',
	'qp_user_polls_link' => 'Participou {{PLURAL:$1|numa sondagem|em $1 sondagens}}',
	'qp_user_missing_polls_link' => 'Nenhuma participação',
	'qp_not_participated_link' => 'Não participada',
	'qp_order_by_username' => 'Ordenar por nome de usuário',
	'qp_order_by_polls_count' => 'Ordenar por contagem de sondagens',
	'qp_results_line_qupl' => 'Página "$1" Sondagem "$2": $3',
	'qp_results_line_qpl' => 'Página "$1" Sondagem "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Página "$2" Sondagem "$3" ]',
	'qp_export_to_xls' => 'Exportar estatísticas para o formato XLS',
	'qp_voices_to_xls' => 'Exportar vozes para o formato XLS',
	'qp_users_answered_questions' => '{{PLURAL:$1|Um usuário respondeu|$1 usuários responderam}} às questões',
	'qp_func_no_such_poll' => 'Sondagem inexistente ($1)',
	'qp_func_missing_question_id' => 'Por favor, especifique o número de uma pergunta existente (começando a partir de 1) para a sondagem $1',
	'qp_func_invalid_question_id' => 'Número de pergunta=$2 é inválido (não é numérico) para a sondagem $1',
	'qp_func_missing_proposal_id' => 'Por favor, especifique o número de uma proposta existente (começando a partir de 0) para a sondagem $1, pergunta $2',
	'qp_func_invalid_proposal_id' => 'Número de proposta=$3 é inválido (não é numérico) para a sondagem $1, pergunta $2',
	'qp_error_no_such_poll' => 'Sondagem inexistente ($1).
Verifique que a sondagem foi declarada e gravada, certifique-se também de que foi usado o carácter delimitador #',
	'qp_error_in_question_header' => 'Cabeçalho de pergunta inválido: $1',
	'qp_error_id_in_stats_mode' => 'Não é possível declarar um identificador da sondagem em modo estatístico',
	'qp_error_dependance_in_stats_mode' => 'Não é possível declarar uma cadeia de dependências da sondagem em modo estatístico',
	'qp_error_no_stats' => 'Não estão disponíveis dados estatísticos, porque ainda ninguém votou nesta sondagem (endereço=$1)',
	'qp_error_address_in_decl_mode' => 'Não é possível obter um endereço da sondagem em modo declarativo',
	'qp_error_question_not_implemented' => 'Não estão implementadas perguntas do tipo: $1',
	'qp_error_invalid_question_type' => 'Tipo de pergunta inválido: $1',
	'qp_error_type_in_stats_mode' => 'Não é possível definir no modo de visualização estatística o tipo de pergunta: $1',
	'qp_error_no_poll_id' => 'Não foi definido um atributo de identificação no marcador da sondagem',
	'qp_error_invalid_poll_id' => 'Identificador de sondagem inválido (id=$1).
O identificador só pode conter letras, números e espaços',
	'qp_error_already_used_poll_id' => 'O identificador da sondagem (id=$1) já foi usado nesta página',
	'qp_error_invalid_dependance_value' => 'A cadeia de dependências da sondagem (id=$1) tem um valor inválido no atributo da dependência (dependance="$2")',
	'qp_error_missed_dependance_title' => 'A sondagem (id=$1) está dependente de outra sondagem (id=$3) da página [[$2]], mas o título [[$2]] não foi encontrado.
Remova o atributo da dependência ou restaure a página [[$2]]',
	'qp_error_missed_dependance_poll' => 'A sondagem (id=$1) está dependente de outra sondagem (id=$3) da página $2, mas essa sondagem não existe ou ainda não foi salva.
Remova o atributo da dependência ou crie a sondagem com id=$3 na página $2 e salve-a.
Para gravar uma sondagem, submeta-a sem ter respondido a nenhuma pergunta.',
	'qp_error_vote_dependance_poll' => 'Por favor, vote na sondagem $1 antes.',
	'qp_error_too_many_spans' => 'Demasiadas classes de categorias para as subcategorias definidas',
	'qp_error_unanswered_span' => 'Subcategoria sem resposta',
	'qp_error_non_unique_choice' => 'Esta pergunta requer resposta a uma única proposta',
	'qp_error_category_name_empty' => 'O nome da categoria está vazio',
	'qp_error_proposal_text_empty' => 'O texto da proposta está vazio',
	'qp_error_too_few_categories' => 'Pelo menos duas categorias devem ser definidas',
	'qp_error_too_few_spans' => 'Cada classe de categorias requer pelo menos duas respostas possíveis definidas',
	'qp_error_no_answer' => 'Proposta sem resposta',
	'qp_error_unique' => 'Pergunta do tipo unique() tem mais propostas definidas do que respostas possíveis: impossível de completar',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'qp_result_error' => 'Eroare de sintaxă',
	'qp_vote_button' => 'Votați',
	'qp_polls_list' => 'Arătați toate sondajele',
	'qp_users_list' => 'Arătați toți utilizatorii',
	'qp_source_link' => 'Sursa',
	'qp_stats_link' => 'Statistici',
	'qp_users_link' => 'Utilizatori',
	'qp_voice_link' => 'Vocea utilizatorului',
	'qp_voice_link_inv' => 'Vocea utilizatorului?',
	'qp_order_by_username' => 'Ordonează după numele utilizatorilor',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'qp_vote_button' => 'Vote',
	'qp_stats_link' => 'Statisteche',
	'qp_users_link' => 'Utinde',
);

/** Russian (Русский)
 * @author QuestPC
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'pollresults' => 'Результаты опросов на сайте',
	'qp_desc' => 'Позволяет создавать опросы',
	'qp_desc-sp' => '[[Special:PollResults|Специальная страница]] для просмотра результатов опросов',
	'qp_result_NA' => 'Нет ответа',
	'qp_result_error' => 'Синтаксическая ошибка',
	'qp_vote_button' => 'Проголосовать',
	'qp_vote_again_button' => 'Переголосовать',
	'qp_submit_attempts_left' => '{{PLURAL:$1|Осталась|Осталось|Осталось}} $1 {{PLURAL:$1|попытка|попытки|попыток}} ответа',
	'qp_polls_list' => 'Список всех опросов',
	'qp_users_list' => 'Список всех участников',
	'qp_browse_to_poll' => 'Перейти к $1',
	'qp_browse_to_user' => 'Перейти к $1',
	'qp_browse_to_interpretation' => 'Перейти к $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|голос|голоса|голосов}}',
	'qp_source_link' => 'Исходный код',
	'qp_stats_link' => 'Статистика',
	'qp_users_link' => 'Участники',
	'qp_voice_link' => 'Голос участника',
	'qp_voice_link_inv' => 'Голос участника?',
	'qp_user_polls_link' => 'Участвовал в $1 {{PLURAL:$1|опросе|опросах|опросах}}',
	'qp_user_missing_polls_link' => 'Неучастие в опросах',
	'qp_not_participated_link' => 'Список неучаствовавших',
	'qp_order_by_username' => 'Сортировать по имени пользователя',
	'qp_order_by_polls_count' => 'Сортировать по количеству опросов',
	'qp_results_line_qupl' => 'Страница "$1" Опрос "$2": $3',
	'qp_results_line_qpl' => 'Страница "$1" Опрос "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Страница "$2" Опрос "$3" ]',
	'qp_results_line_qpul' => '$1: $2',
	'qp_header_line_qucl' => '$1. $2<br />$3 ??? $4',
	'qp_results_line_qucl' => '$1: $2 $3',
	'qp_results_submit_attempts' => 'Попыток ответа: $1',
	'qp_results_interpretation_header' => 'Интерпретация ответа',
	'qp_results_short_interpretation' => 'Краткая интерпретация',
	'qp_results_long_interpretation' => 'Подробная интерпретация',
	'qp_results_structured_interpretation' => 'Структурная интерпретация',
	'qp_poll_has_no_interpretation' => 'Шаблон, используемый для интерпретации результатов опроса, не определен в заголовке опроса',
	'qp_interpetation_wrong_answer' => 'Неправильный ответ',
	'qp_export_to_xls' => 'Экспортировать статистику в XLS формате',
	'qp_voices_to_xls' => 'Экспортировать голоса в XLS формате',
	'qp_interpretation_results_to_xls' => 'Экспортировать интерпретации ответов в XLS формате',
	'qp_users_answered_questions' => 'На вопросы {{PLURAL:$1|ответил $1 участник|ответило $1 участника|ответили $1 участников}}',
	'qp_func_no_such_poll' => 'Опрос не найден ($1)',
	'qp_func_missing_question_id' => 'Укажите существующий идентификатор вопроса (начинающийся с единицы) для опроса $1',
	'qp_func_invalid_question_id' => 'Ошибочный идентификатор вопроса (question id=$2 - требуется числовое значение) для опроса $1',
	'qp_func_missing_proposal_id' => 'Укажите идентификатор строки (начинающийся с нуля) для опроса $1, вопроса $2',
	'qp_func_invalid_proposal_id' => 'Ошибочный идентификатор строки (proposal id=$3 - требуется числовое значение) для опроса $1, вопроса $2',
	'qp_error_no_such_poll' => 'Опрос не найден ($1). Убедитесь что заданный опрос определён и сохранён, а также что используется символ разделителя адреса #',
	'qp_error_in_question_header' => 'Неверный заголовок вопроса: $1',
	'qp_error_id_in_stats_mode' => 'Недопустимо определять идентификатор опроса (id) в статистическом режиме вывода',
	'qp_error_dependance_in_stats_mode' => 'Недопустимо определять атрибут зависимости опроса (dependance) в статистическом режиме',
	'qp_error_no_stats' => 'Статистика голосования недоступна, так как еще никто не голосовал в этом опросе (address=$1)',
	'qp_error_address_in_decl_mode' => 'Недопустимо задавать адрес опроса (address) в режиме определения',
	'qp_error_question_not_implemented' => 'Вопросы данного типа не реализованы в коде расширения: $1',
	'qp_error_question_empty_body' => 'Текст определения вопроса пуст.',
	'qp_error_question_no_proposals' => 'Текст определения вопроса не содержит ни одной строки вопроса.',
	'qp_error_invalid_question_type' => 'Недопустимый тип вопроса: $1',
	'qp_error_invalid_question_name' => 'Недопустимое имя вопроса: $1',
	'qp_error_type_in_stats_mode' => 'Недопустимо определять тип вопроса в статистическом режиме: $1',
	'qp_error_no_poll_id' => 'Тэг опроса не имеет атрибута id.',
	'qp_error_invalid_poll_id' => 'Недопустимый идентификатор опроса (id=$1). Идентификатор опроса может содержать только буквы, цифры и символ пробела',
	'qp_error_already_used_poll_id' => 'Установленный атрибут id опроса уже используется другим опросом на данной странице (id=$1).',
	'qp_error_too_long_dependance_value' => 'Значение атрибута зависимости опросов (dependance="$2") для опроса (id=$1) имеет слишком большую длину, из-за чего не может быть сохранено.',
	'qp_error_invalid_dependance_value' => 'В цепочке зависимости опросов для опроса (id=$1) было найдено синтаксически неверное значение атрибута зависимости (dependance="$2")',
	'qp_error_missed_dependance_title' => 'Опрос с идентификатором id=$1 имеет атрибут зависимости от другого опроса (id=$3), находящегося на отсутствующей странице [[$2]]. Необходимо убрать атрибут зависимости от другого опроса, либо восстановить страницу [[$2]]',
	'qp_error_missed_dependance_poll' => 'Опрос с идентификатором id=$1 требует прохождения другого опроса с идентификатором id=$3, находящегося на странице $2. Однако же, последний не был найден. Необходимо удалить атрибут зависимости из опроса (id=$1), либо создать опрос с идентификатором id=$3 на странице $2 и сохранить его. Для сохранения опроса будет достаточно нажать кнопку "Проголосовать", не отвечая ни на один вопрос.',
	'qp_error_vote_dependance_poll' => 'Пожалуйста ответьте сначала на опрос $1.',
	'qp_error_too_many_spans' => 'Определено слишком много классов для подкатегорий вопросов',
	'qp_error_unanswered_span' => 'Подкатегория вопроса без ответа',
	'qp_error_non_unique_choice' => 'Данный вопрос требует чтобы выбранный вариант ответа не использовался ранее',
	'qp_error_category_name_empty' => 'Отсутствует название варианта ответа',
	'qp_error_proposal_text_empty' => 'Отсутствует текст строки вопроса',
	'qp_error_too_long_category_option_value' => 'Вариант ответа для данной категории слишком длинный для сохранения в базе данных',
	'qp_error_too_long_category_options_values' => 'Варианты ответов для данной категории слишком длинны для сохранения в базе данных',
	'qp_error_too_long_proposal_text' => 'Строка вопроса слишком длинна для сохранения в базе данных',
	'qp_error_multiline_proposal_name' => 'Имя строки вопроса не должно содержать в себе более одной строки текста.',
	'qp_error_numeric_proposal_name' => 'Имя строки вопроса не может быть числом.',
	'qp_error_too_few_categories' => 'Каждый вопрос должен иметь по крайней мере два варианта ответа',
	'qp_error_too_few_spans' => 'Каждая подкатегория вопроса требует по меньшей мере два варианта ответа',
	'qp_error_no_answer' => 'Нет ответа на вопрос',
	'qp_error_not_enough_categories_answered' => 'Недостаточное количество заполненных категорий в строке вопроса.',
	'qp_error_unique' => 'Опрос, имеющий тип unique(), не должен иметь больше ответов чем вопросов',
	'qp_error_no_more_attempts' => 'Исчерпано количество попыток ответа на данный опрос',
	'qp_error_no_interpretation' => 'Скрипт интерпретации не найден',
	'qp_error_interpretation_no_return' => 'Скрипт интерпретации не вернул результат',
	'qp_error_structured_interpretation_is_too_long' => 'Структурированная интерпретация слишком длинна для хранения в базе данных. Пожалуйста скорректируйте Ваш скрипт интерпретации.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'qp_stats_link' => 'Штатістікы',
	'qp_users_link' => 'Хоснователї',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'qp_parentheses' => '($1)',
	'qp_full_category_name' => '$1($2)',
	'qp_desc' => 'Омогућава покретање анкета',
	'qp_result_NA' => 'Неодговорено',
	'qp_result_error' => 'Синтаксна грешка',
	'qp_vote_button' => 'Гласај',
	'qp_vote_again_button' => 'Прегласај',
	'qp_polls_list' => 'Прикажи све анкете',
	'qp_users_list' => 'Прикажи све кориснике',
	'qp_votes_count' => '$1 {{PLURAL:$1|глас|гласа|гласова}}',
	'qp_stats_link' => 'Статистике',
	'qp_users_link' => 'Корисници',
	'qp_user_polls_link' => '{{GENDER:$2|Учествовао|Учествовала|Учествовао}} у $1 {{PLURAL:$1|анкети|анкете|анкета}}',
	'qp_results_line_qpul' => '$1: $2',
	'qp_header_line_qucl' => '$1. $2<br />$3 ??? $4',
	'qp_results_line_qucl' => '$1: $2 $3',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'qp_parentheses' => '($1)',
	'qp_full_category_name' => '$1($2)',
	'qp_desc' => 'Omogućava pokretanje anketa',
	'qp_result_NA' => 'Neodgovoreno',
	'qp_result_error' => 'Sintaksna greška',
	'qp_vote_button' => 'Glasaj',
	'qp_vote_again_button' => 'Preglasaj',
	'qp_polls_list' => 'Prikaži sve ankete',
	'qp_users_list' => 'Prikaži sve korisnike',
	'qp_votes_count' => '$1 {{PLURAL:$1|glas|glasa|glasova}}',
	'qp_stats_link' => 'Statistike',
	'qp_users_link' => 'Korisnici',
	'qp_user_polls_link' => '{{GENDER:$2|Učestvovao|Učestvovala|Učestvovao}} u $1 {{PLURAL:$1|anketi|ankete|anketa}}',
	'qp_results_line_qpul' => '$1: $2',
	'qp_header_line_qucl' => '$1. $2<br />$3 ??? $4',
	'qp_results_line_qucl' => '$1: $2 $3',
);

/** Swedish (Svenska)
 * @author Ozp
 * @author Per
 */
$messages['sv'] = array(
	'pollresults' => 'Resultat av omröstningarna på denna sida',
	'qp_desc' => 'Tillåter skapandet av frågeundersökningar',
	'qp_desc-sp' => '[[Special:PollResults|Specialsida]] för visning av resultat av omröstningarna',
	'qp_result_NA' => 'Inte besvarad',
	'qp_result_error' => 'Syntaxfel',
	'qp_vote_button' => 'Rösta',
	'qp_vote_again_button' => 'Ändra din röst',
	'qp_polls_list' => 'Lista alla röstningar',
	'qp_users_list' => 'Lista alla användare',
	'qp_browse_to_poll' => 'Bläddra till $1',
	'qp_browse_to_user' => 'Bläddra till $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|röst|röster}}',
	'qp_source_link' => 'Källa',
	'qp_stats_link' => 'Statistik',
	'qp_users_link' => 'Användare',
	'qp_voice_link' => 'Användaråsikt',
	'qp_voice_link_inv' => 'Användaråsikt?',
	'qp_user_polls_link' => 'Deltagit i $1 {{PLURAL:$1|omröstning|omröstningar}}',
	'qp_user_missing_polls_link' => 'Ingen deltagelse',
	'qp_not_participated_link' => 'Inte deltagit',
	'qp_order_by_username' => 'Sortera efter användarnanm',
	'qp_order_by_polls_count' => 'Sortera efter antal omröstningar',
	'qp_results_line_qupl' => 'Sida "$1" Undersökning "$2": $3',
	'qp_results_line_qpl' => 'Sida "$1" Undersökning "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Sida "$2" Frågeundersökning "$3" ]',
	'qp_export_to_xls' => 'Exportera statistik till XLS-format',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|användare|användare}} besvarade frågorna',
	'qp_func_no_such_poll' => 'Ingen sådan undersökning ($1)',
	'qp_error_no_such_poll' => 'Ingen sådan omröstning ($1).
Var säker på att omröstningen deklarerades och sparades, var också med att använda adressavgränsar-tecknet #',
	'qp_error_no_stats' => 'Ingen statistik är tillgänglig eftersom ingen ännu har röstat på denna undersökning (adress=$1)',
	'qp_error_question_not_implemented' => 'Frågor av den typen är inte implementerade: $1',
	'qp_error_invalid_question_type' => 'Ogiltig frågetyp:$1',
	'qp_error_already_used_poll_id' => 'Detta omröstnings-id har redan använts på denna sida (id=$1).',
	'qp_error_vote_dependance_poll' => 'Vänligen rösta i undersökningen $1 först.',
	'qp_error_too_many_spans' => 'För många kategorigrupper för det totala antalet underkategorier definerade',
	'qp_error_unanswered_span' => 'Obesvarad underkategori',
	'qp_error_non_unique_choice' => 'Denna fråga kräver unika svarsförslag',
	'qp_error_category_name_empty' => 'Kategorinamn är tomt',
	'qp_error_proposal_text_empty' => 'Förslagstext är tom',
	'qp_error_too_few_categories' => 'Minst två kategorier måste definieras',
	'qp_error_too_few_spans' => 'Varje kategorigrupp måste innehålla minst två underkategorier',
	'qp_error_no_answer' => 'Obesvarat förslag',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'qp_votes_count' => '$1 {{PLURAL:$1|వోటు|వోట్లు}}',
	'qp_stats_link' => 'గణాంకాలు',
	'qp_users_link' => 'వాడుకరులు',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|వాడుకరి|గురు వాడుకరులు}} ప్రశ్నలకు జవాబిచ్చారు',
	'qp_error_category_name_empty' => 'వర్గం పేరు ఖాళీగా ఉంది',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'qp_users_link' => 'Ulanyjylar',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'pollresults' => 'Mga resulta ng halalan sa sityong ito',
	'qp_desc' => 'Nagpapahintulot sa paglikha ng mga halalan',
	'qp_desc-sp' => '[[Special:PollResults|Natatnging pahina]] para sa pagtingin sa mga resulta ng mga halalan',
	'qp_result_NA' => 'Hindi sinagutan',
	'qp_result_error' => 'Kamalian sa palaugnayan',
	'qp_vote_button' => 'Bumoto',
	'qp_vote_again_button' => 'Baguhin ang boto mo',
	'qp_polls_list' => 'Talaan ng lahat ng mga pagboto',
	'qp_users_list' => 'Itala ang lahat ng mga tagagamit',
	'qp_browse_to_poll' => 'Tumingin-tingin sa $1',
	'qp_browse_to_user' => 'Tumingin-tingin sa $1',
	'qp_votes_count' => '$1 {{PLURAL:$1|boto|mga boto}}',
	'qp_source_link' => 'Pinagmulan',
	'qp_stats_link' => 'Estadistika',
	'qp_users_link' => 'Mga tagagamit',
	'qp_voice_link' => 'Tinig ng tagagamit',
	'qp_voice_link_inv' => 'Tinig ng tagagamit?',
	'qp_user_polls_link' => 'Nakilahok sa $1 {{PLURAL:$1|botohan|mga botohan}}',
	'qp_user_missing_polls_link' => 'Walang pakikilahok',
	'qp_not_participated_link' => 'Hindi lumahok',
	'qp_order_by_username' => 'Pagkakasunud-sunod ayon sa pangalan ng tagagamit',
	'qp_order_by_polls_count' => 'Pagkakasunud-sunod ayon sa bilang ng botohan',
	'qp_results_line_qupl' => 'Pahina "$1" Botohan "$2": $3',
	'qp_results_line_qpl' => 'Pahina "$1" Botohan "$2": $3, $4, $5, $6',
	'qp_header_line_qpul' => '$1 [ Pahina "$2" Botohan "$3" ]',
	'qp_export_to_xls' => 'Iluwas ang estadistika sa anyong XLS',
	'qp_voices_to_xls' => 'Iluwas ang mga tinig papaloob sa anyong XLS',
	'qp_users_answered_questions' => '$1 {{PLURAL:$1|tagagamit|mga tagagamit}} sumagot sa mga tanong',
	'qp_func_no_such_poll' => 'Walang ganyang botohan ($1)',
	'qp_func_missing_question_id' => 'Mangyaring tukuyin ang isang umiiral na id ng tanong (simula sa 1) para sa botohang $1',
	'qp_func_invalid_question_id' => 'Hindi tanggap na tanong na id=$2 (hindi isang bilang) para sa botohang $1',
	'qp_func_missing_proposal_id' => 'Mangyaring tukuyin ang isang umiiral na iminungkahing id (simula sa 0) para sa botohang $1, tanong $2',
	'qp_func_invalid_proposal_id' => 'Hindi tanggap na mungkahing id=$3 (hindi isang bilang) para sa botohang $1, tanong $2',
	'qp_error_no_such_poll' => 'Walang ganyang botohan ($1).
Tiyaking na nagpahayag ang botohan at nasagip, tiyakin ding ginamit ang panghanggang tirahan ng panitik na #',
	'qp_error_in_question_header' => 'Hindi tanggap na paulo ng tanong: $1',
	'qp_error_id_in_stats_mode' => 'Hindi maipahayag ang ID ng botohan sa modalidad ng pang-estadistika',
	'qp_error_dependance_in_stats_mode' => 'Hindi maipahayag ang tanikalang pangsandig ng botohan sa modalidad na pang-estadistika',
	'qp_error_no_stats' => 'Walang makuhang datong pang-estadistika, dahil wala pang bumoboto para sa halalang ito,  (tirahan=$1)',
	'qp_error_address_in_decl_mode' => 'Hindi makakuha ng tirahan ng botohan sa modalidad ng pagpapahayag',
	'qp_error_question_not_implemented' => 'Hindi ipinapatupad ang ganyang uri ng mga tanong: $1',
	'qp_error_invalid_question_type' => 'Hindi tanggap na uri ng tanong: $1',
	'qp_error_type_in_stats_mode' => 'Hindi mabigyang kahulugan ang uri ng tanong sa modalidad ng nagpapakita ng estadistika: $1',
	'qp_error_no_poll_id' => 'Walang tinukoy na id ng katangian ng tatak ng botohan.',
	'qp_error_invalid_poll_id' => 'Hindi tanggap na id ng botohan (id=$1).
Maaaring maglaman lang ang id ng botohan ng mga titik, mga bilang at patlang na panitik',
	'qp_error_already_used_poll_id' => 'Nagamit na ang id ng botohan sa pahinang ito (id=$1).',
	'qp_error_invalid_dependance_value' => 'Ang tanikala ng pagsandig ng botohan (id=$1) ay may hindi tanggap na halaga ng katangian ng pagsandig (pagsandig="$2")',
	'qp_error_missed_dependance_title' => 'Ang botohan (id=$1) ay nakasandig sa ibang botohan (id=$3) mula sa pahinang [[$2]], subalit hindi natagpuan ang pamagat na  [[$2]].
Maaaring tanggalin ang katangian ng pagsandig, o ibalik ang [[$2]]',
	'qp_error_missed_dependance_poll' => 'Ang botohang (id=$1) ay nakasandig sa ibang botohan (id=$3) sa pahinang $2, subalit hindi umiiral ang botohang iyon o hindi pa nasasagip.
Maaaring tanggalin ang katangian ng pagsandig, o likhain ang botohan na may id=$3 sa pahinang $2 at sagipin ito.
To save a poll, submit it while not answering to any proposal questions.',
	'qp_error_vote_dependance_poll' => 'Mangyaring bumoto muna para sa botohang $1.',
	'qp_error_too_many_spans' => 'Napakaraming tinukoy na mga pangkat ng kategorya para sa kabuoang bilang ng kabahaging mga kategorya',
	'qp_error_unanswered_span' => 'Hindi sinagot na kabahaging kategorya',
	'qp_error_non_unique_choice' => 'Nangangailangan ang tanong na ito ng natatanging sagot na pangmungkahi',
	'qp_error_category_name_empty' => 'Walang laman ang pangalan ng kategorya',
	'qp_error_proposal_text_empty' => 'Walang laman ang teksto ng mungkahi',
	'qp_error_too_few_categories' => 'Dapat na tumukoy ng kahit na dalawang mga kategorya',
	'qp_error_too_few_spans' => 'Dapat na maglaman ang bawat pangkat ng kategorya ng kahit na dalawang kabahaging mga kategorya',
	'qp_error_no_answer' => 'Hindi tinugunang mungkahi',
	'qp_error_unique' => 'Ang tanong ng uring natatangi() ay may mas maraming mga mungkahi kaysa tinukoy na maaaring mga tugon: hindi maaaring makumpleto',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'pollresults' => 'Bu sitedeki anketlerin sonuçları',
	'qp_desc' => 'Anket oluşturulmasını mümkün kılar',
	'qp_desc-sp' => 'Anketlerin sonuçlarının görüntülenmesi amaçlı [[Special:PollResults|özel sayfa]]',
	'qp_result_NA' => 'Cevaplanmadı',
	'qp_result_error' => 'Sözdizimi hatası',
	'qp_vote_button' => 'Oy ver',
	'qp_vote_again_button' => 'Oyunu değiştir',
	'qp_polls_list' => 'Tüm anketleri listele',
	'qp_users_list' => 'Tüm kullanıcıları listele',
	'qp_browse_to_poll' => '$1 adlı sayfaya gözat',
	'qp_browse_to_user' => '$1 adlı sayfaya gözat',
	'qp_votes_count' => '$1 {{PLURAL:$1|oy|oy}}',
	'qp_source_link' => 'Kaynak',
	'qp_stats_link' => 'İstatistikler',
	'qp_users_link' => 'Kullanıcılar',
	'qp_user_polls_link' => '$1 {{PLURAL:$1|ankete|ankete}} katılmış',
	'qp_user_missing_polls_link' => 'Katılım yok',
	'qp_not_participated_link' => 'Katılmadı',
	'qp_order_by_username' => 'Kullanıcı adına göre sırala',
	'qp_order_by_polls_count' => 'Anket sayılarına göre sırala',
	'qp_results_line_qupl' => 'Sayfa "$1" Anket "$2": $3',
	'qp_export_to_xls' => 'İstatistikleri XLS formatına aktar',
	'qp_users_answered_questions' => 'Sorulara $1 {{PLURAL:$1|kullanıcı|kullanıcı}} cevap verdi',
	'qp_func_no_such_poll' => 'Böyle bir anket yok ($1)',
	'qp_error_dependance_in_stats_mode' => 'İstatistik modunda anketin bağımlılık zinciri bildirilemiyor',
	'qp_error_no_stats' => 'İstatistiksel veri mevcut değil, çünkü hiç kimse bu anket için oy vermemiş (adres=$1)',
	'qp_error_question_not_implemented' => 'Bu türdeki sorular uygulamaya koyulmamaktadır: $1',
	'qp_error_invalid_question_type' => 'Geçersiz soru türü: $1',
	'qp_error_no_poll_id' => 'Anket etiketinin tanımlanmış bir kimlik değeri yok.',
	'qp_error_already_used_poll_id' => 'Anket kimliği bu sayfada önceden kullanılmış (kimlik=$1).',
	'qp_error_vote_dependance_poll' => 'Lütfen ilk olarak $1. anket için oy verin.',
	'qp_error_unanswered_span' => 'Cevaplanmamış alt kategori',
	'qp_error_category_name_empty' => 'Kategori adı boş',
	'qp_error_proposal_text_empty' => 'Teklif metni boş',
	'qp_error_too_few_categories' => 'En az iki kategori tanımlanmalı',
	'qp_error_too_few_spans' => 'Tüm kategori grupları en az iki alt kategori içermelidir',
	'qp_error_no_answer' => 'Cevaplanmamış teklif',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'qp_user_missing_polls_link' => 'Сорауларда катнашмау',
	'qp_not_participated_link' => 'Сорауларда катнашмаучылар исемлеге',
	'qp_order_by_username' => 'Кулланучы исеме буенча тәртипкә салу',
	'qp_order_by_polls_count' => 'Сорау алулар саны буенча тәртипкә салу',
	'qp_results_line_qupl' => '"$1" бит "$2": $3 сорау алу',
	'qp_results_line_qpl' => '"$1"  бит  "$2": $3, $4, $5, $6 сорау алу',
	'qp_header_line_qpul' => '$1 [ "$2" бит "$3" сорау алу ]',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'qp_desc' => 'Дозволяє створювати опитування',
	'qp_result_error' => 'Синтаксична помилка',
	'qp_vote_button' => 'Проголосувати',
	'qp_source_link' => 'Джерело',
	'qp_stats_link' => 'Статистика',
	'qp_users_link' => 'Користувачі',
	'qp_users_answered_questions' => 'На питання {{PLURAL:$1|відповів $1 користувач|відповіли $1 користувачі|відповіли $1 користувачів}}',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'qp_vote_button' => 'שטימען',
	'qp_source_link' => 'מקור',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'qp_result_NA' => '未回答',
	'qp_result_error' => '语法错误',
	'qp_vote_button' => '投票',
	'qp_vote_again_button' => '改变您的投票',
	'qp_polls_list' => '所有投票名单',
	'qp_users_list' => '列出所有使用者',
	'qp_source_link' => '来源',
	'qp_stats_link' => '统计',
	'qp_users_link' => '用户',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'qp_result_NA' => '未回答',
	'qp_result_error' => '語法錯誤',
	'qp_vote_button' => '投票',
	'qp_vote_again_button' => '修改你的投票',
	'qp_polls_list' => '所有投票名單',
	'qp_users_list' => '列出所有使用者',
	'qp_source_link' => '來源',
	'qp_stats_link' => '統計',
	'qp_users_link' => '用戶',
);

