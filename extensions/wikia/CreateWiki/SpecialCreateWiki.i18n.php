<?php
/**
 * Internationalisation file for ConfigureWiki extension.
 *
 * @addtogroup Extensions
 */

$wgCreateWikiMessages = array();
$wgCreateWikiMessages['en'] = array(
    'createwiki' => 'Create a new wiki',
    "createwikipagetitle" => 'Create a new wiki',
    "createwikirejectpagetitle" => 'Reject wiki',
    "createwikistep" => ", step ",
    'createwikilogin' => 'Please <a href="/index.php?title=Special:Userlogin&returnto=Special:CreateWiki" class="internal" title="create an account or log in">create an account or log in</a> before requesting a wiki.',
    'createwikistafftext' => 'You are staff, so you can create a new wiki using this page',
    'createwikitext' => 'You can request a new wiki be created on this page.  Just fill out the form',
    'createwikititle' => 'Title for the wiki',
    'createwikiname' => 'Name for the wiki',
    'createwikinamevstitle' => 'The name for the wiki differs from the title of the wiki in that the name is what will be used to determine the default url.  For instance, a name of "starwars" would be accessible as http://starwars.wikia.com/. The title of the wiki may contain spaces, the name should only contain letters and numbers.',
    'createwikidesc' => 'Description of the wiki',
    'createwikidescen' => 'English main description for Central Wikia',
    'createwikidescnational' => 'Description in request language',
    'createwikiaddtnl' => 'Additional Information',
    'createwikimailsub' => 'Wikia request',
    'requestcreatewiki' => 'Request Wiki',
    'createwikisubmitcomplete' => 'Your submission is complete.  If you gave an email address, you will be contacted regarding the new Wiki.  Thank you for using {{SITENAME}}.',
    'createwikicreatecomplete' => 'Your wiki creation is complete.  ',
    'createwikichangecomplete' => 'Your changes have been saved.',
    'createwikilang' => 'Default language',
    'createwikibademail' => "The email you provided is not a proper email address, please retype it correctly.",
    "createwikifounder" => "Founder",
    "createwikicategory" => "Category",
    "createwikinosimilar" => "Didn't find similar Wiki",
    "createwikinametooshort" => "Name is too short, it should have at least 3 characters\n",
    "createwikirejecttemplates" => "
    <!-- rules: link has to have title (which will be pasted to form) and class \"r-template\" -->
    <ul id=\"rtemplate\">
        <li><a title=\"D\" class=\"r-template\">D</a> - Page is content rather than a request</li>
        <li><a title=\"R-i\" class=\"r-template\">R-i</a> - Rejection due to no reply</li>
        <li><a title=\"P\" class=\"r-template\">P</a> - User requested a personal wiki</li>
        <li><a title=\"scratchpad\" class=\"r-template\">scratchpad</a> - Go to scratchpad</li>
        <li><a title=\"university\" class=\"r-template\">university</a> - Apply on students</li>
        <li><a title=\"reject\" class=\"r-template\">reject</a> - Miscellaneus</li>
        <li><a title=\"goto\" class=\"r-template\">goto</a> - A wikia on the same topic already exists</li>
        <li><a title=\"topic\" class=\"r-template\">topic</a> - Too broad in focus</li>
    </ul>
    ",
    "createwiki_unlocked" => "
        Create lock removed. Back to <a href=\"$1\">create form</a>.
    ",
    "createwiki_requestlocked" => "Request is locked by $1 $2",
    "createwiki-info-needed-email-subject" => "Request Wiki - more info needed.",
    "createwiki-info-needed-email" => "Hello $1

Thanks for your request for a new wiki at $2, but we need more information before we can accept this wiki.

Please return to the request page and respond to the questions there. Tell us about more about the subjects you want to cover, and who would you expect to contribute to the wiki.

Tell us whether there are other communities out there around this subject who would be likely to edit this wiki.

$3
				",
				"createwiki-reject-email-subject" => "Request Wiki - request rejected."
);
