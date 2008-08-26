<?php
/**
 * Internationalisation file for WikiFactory extension.
 *
 * @addtogroup Languages
 */

$messages = array();
$messages["en"] = array(
	'privatedomains_nomanageaccess' => "<p>Sorry, you do not have enough rights to manage the allowed private domains for this wiki. Only wiki bureaucrats and staff members have access.</p><p>If you aren't logged in, you probably <a href='/wiki/Special:Userlogin'>should</a>.</p>",
	'privatedomains' =>  'Manage Private Domains',
	'privatedomains_ifemailcontact' => "<p>Otherwise, please contact [[Special:Emailuser/$1|$1]] if you have any questions.</p>",
	'saveprivatedomains_success' => "Private Domains changes saved.",
	'privatedomains_invalidemail' => "<p>Sorry, access to this wiki is restricted to members of $1. If you have an email address affiliated with $1, you can enter or reconfirm your email address on your account preference page <a href=/wiki/Special:Preferences>here</a>. You can still view pages on this wiki, but you will be unable to edit.</p>",
	'privatedomains_affiliatenamelabel' => "<br>Name of organization: ",
	'privatedomains_emailadminlabel' => "<br>Contact username for access problems or queries: ",
	'privatedomainsinstructions' => "<br /> <br /> <p>Below is the list of email domains allowed for editors of this wiki. Each line designates an email suffix that is given access for editing. This should be formatted with one suffix per line. For example:</p> <p style=\"width: 20%; padding:5px; border: 1px solid grey;\">cs.stanford.edu<br /> stanfordalumni.org</p> <p>This would allow edits from anyone with the email address whatever@cs.stanford.edu or whatever@stanfordalumni.org</p> <p><b>Enter the allowed domains in the text box below, and click \"save\".</b></p>"
);
