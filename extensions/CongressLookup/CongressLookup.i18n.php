<?php
/**
 * Internationalisation for CongressLookup extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Ryan Kaldari
 */
$messages['en'] = array(
	'congresslookup-desc' => 'Look up congressional representatives based on a U.S. zip code',
	'congresslookup' => 'CongressLookup',
	'congresslookup-submit' => 'Submit',
	'congresslookup-submit-zip' => 'Submit zip',
	'congresslookup-phone' => 'Phone: $1',
	'congresslookup-fax' => 'Fax: $1',
	'congresslookup-contact-form' => 'Contact form',
	'congresslookup-twitter' => 'Twitter: $1',
	'congresslookup-your-reps' => 'Your representatives:',
	'congresslookup-contact-your-reps' => 'Contact your representatives:',
	'congresslookup-no-house-rep' => 'No House representative was found for your zip code.',
	'congresslookup-no-senators' => 'No senators were found for your zip code.',
	'congresslookup-report-errors' => 'Report an error',
	'congresslookup-zipcode-error' => 'Please enter your zipcode in the format "12345" or "12345-1234".',
	'congresslookup-multiple-house-reps' => 'Note: In some cases, there is more than one representative district assigned to a particular zip code. Please select the representative appropriate for your particular district.',
	'congressfail' => 'CongressFail',
	'congresslookup-text' => '<div style="font-size: 1.5em;margin-bottom: 0.5em;">Call your elected officials.</div>
<p>Tell them you are their constituent, and you oppose SOPA and PIPA.</p>
<div style="font-size: 1.2em;margin-bottom: 0.2em;">Why?</div>
<p>SOPA and PIPA would put the burden on website owners to police user-contributed material and call for the unnecessary blocking of entire sites. Small sites won\'t have sufficient resources to defend themselves. Big media companies may seek to cut off funding sources for their foreign competitors, even if copyright isn\'t being infringed. Foreign sites will be blacklisted, which means they won\'t show up in major search engines. SOPA and PIPA would build a framework for future restrictions and suppression.</p>
<p>In a world in which politicians regulate the Internet based on the influence of big money, Wikipedia &mdash; and sites like it &mdash; cannot survive. </p>
<p>Congress says it\'s trying to protect the rights of copyright owners, but the "cure" that SOPA and PIPA represent is worse than the disease. SOPA and PIPA are not the answer: they would fatally damage the free and open Internet.</p>',
);

/** Message documentation (Message documentation)
 * @author Ryan Kaldari
 */
$messages['qqq'] = array(
	'congresslookup-desc' => '{{desc}}',
	'congresslookup' => 'The name of the extension CongressLookup.',
	'congresslookup-submit' => 'Submit button',
	'congresslookup-submit-zip' => 'Submit button',
	'congresslookup-phone' => 'Phone number listing. $1 is the phone number.',
	'congresslookup-fax' => 'Fax number listing. $1 is the fax number.',
	'congresslookup-contact-form' => "Label for a link to the representative's contact form",
	'congresslookup-twitter' => 'Twitter ID listing. $1 is the ID.',
	'congresslookup-your-reps' => 'Label for data. Should be short.',
	'congresslookup-no-house-rep' => 'Error message for when no House representative is found',
	'congresslookup-no-senators' => 'Error message for when no Senators are found',
	'congresslookup-report-errors' => 'Label for a link to the error reporting page',
	'congresslookup-zipcode-error' => 'Error message for when an invalid zip code is entered to the form.',
	'congresslookup-multiple-house-reps' => 'A note for people who see more than one representative listed for them. Many folks would find this unusual, but we are not looking up representatives at a granular-enough level to necessarily return their one specific rep. So in the event that there are more than one representatives returned to the user, we explain why.',
	'congressfail' => 'Title of secondary special page where one can report data errors',
	'congresslookup-text' => "Just in case the local MediaWiki message isn't set. Probably don't need to translate this.",
);
