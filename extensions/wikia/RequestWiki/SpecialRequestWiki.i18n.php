<?php
/**
 * Internationalisation file for ConfigureWiki extension.
 *
 * @addtogroup Extensions
 */


$messages = array();
$messages['en'] = array(
	'requestwiki' => 'Request wiki',	//the name displayed on Special:SpecialPages
//first step
	'requestwiki-first-button-agree' => 'Continue',
	'requestwiki-first-button-login' => 'Log in/Create account',
	'requestwiki-first-button-submit' => 'Search for wikis',
	'requestwiki-first-language-page-header' => 'View this page in your language:',
	'requestwiki-first-language-page-list' => 'de|Deutsch\nen|English\nes|Español\nfr|Français\nit|Italiano\nja|日本語\npl|Polski\npt|Português\nbr|Português do Brasil\nzh|中文',
	'requestwiki-first-login' => '<!-- not required, you see a log in button if you are not logged in -->',
	'requestwiki-first-page-top' => '<big><big>Start your own wiki community</big></big>

	Wikia communities are a great way to collaborate with passionate people on any topic you can imagine.
	<br /><br /><br />
	<big><big>Here\'s how it works:</big></big>

	{|
	|align="center" width="20%"|http://images.wikia.com/messaging/images/2/20/Blob1.png
	|width="30px"|http://images.wikia.com/messaging/images/8/84/Blob_arrow.png
	|align="center" width="20%"|http://images.wikia.com/messaging/images/b/b2/Blob2.png
	|width="30px"|http://images.wikia.com/messaging/images/8/84/Blob_arrow.png
	|align="center" width="20%"|http://images.wikia.com/messaging/images/6/6b/Blob3.png
	|width="30px"|http://images.wikia.com/messaging/images/8/84/Blob_arrow.png
	|align="center" width="20%"|http://images.wikia.com/messaging/images/8/8c/Blob4.png
	|width="30px"|http://images.wikia.com/messaging/images/8/84/Blob_arrow.png
	|align="center" width="20%"|http://images.wikia.com/messaging/images/7/7d/Blob5.png
	|-
	| align="center" valign="top"|Create an account<br>and log in
	|
	| align="center" valign="top"|Tell us about your idea
	|
	| align="center" valign="top"|We\'ll review your proposal
	|
	| align="center" valign="top"|We might have questions
	|
	| align="center" valign="top"|Your new wiki<br>is created!
	|}

	When your wiki is ready, we\'ll send you an email.
	<br /><br /><br />
	<big><big>Does a similar community exist?</big></big>

	Search on topic keywords to find out.',
	'requestwiki-first-search-tip' => '\'\'<font style="color:#666">Try terms such as \'harry potter\' or \'star wars\'.</font>\'\'',
	'requestwiki-first-tos' => 'By continuing, you agree to Wikia\'s <a target="_blank" href="http://www.wikia.com/wiki/Terms_of_use">terms of use</a>.',
	'requestwiki-first-tos-agree' => 'You must agree before continue.',
	'requestwiki-first-view-more' => '<b>View More Wikis</b>',
	'requestwiki-first-wiki-found' => "<br>
	'''It looks like there might already be a wiki on this topic'''. <br>We hope you'll join an existing community instead of submitting a duplicate request.",
	'requestwiki-first-wiki-name' => 'Topic:',
	'requestwiki-first-wiki-notfound' => "It looks like we don't yet have a wiki on this subject. We look forward to your proposal!",

//second step
	'requestwiki-second-category' => 'Category for your wiki:',
	'requestwiki-second-category-choose-option' => 'Choose one',
	'requestwiki-second-category-hint' => 'This will help visitors find your wiki.',
	'requestwiki-second-community' => 'Community:',
	'requestwiki-second-community-hint' => 'Who will join you in building your wiki? Do you plan to recruit users? Is there a community for this topic?',
	'requestwiki-second-date' => 'Date',
	'requestwiki-second-date-hint' => 'This field is set by the system and is for information only.',
	'requestwiki-second-description' => 'What is your wiki about?',
	'requestwiki-second-description-english' => 'Description of the wiki in English',
	'requestwiki-second-description-english-hint' => 'We have people able to help in several languages, including German, Spanish, Polish, Chinese, and Japanese. But it may help us if you can summarise your request in English.',
	'requestwiki-second-description-hint' => "Please write a couple of sentences to help us understand what you're planning.",
	'requestwiki-second-error' => 'There seems to be some missing information.  Please check the messages below.',
	'requestwiki-second-extrainfo' => 'Is there anything else you would like to tell us about this request?',
	'requestwiki-second-extrainfo-hint' => 'Please fill in any field that you can.  This part is optional, but it would help us to evaluate your request.',
	'requestwiki-second-language' => "Choose your wiki's language:",
	'requestwiki-second-language-group-all' => 'All languages',
	'requestwiki-second-language-group-top' => 'Top $1 languages',
	'requestwiki-second-language-hint' => 'This will be the default language for visitors to your wiki.',
	'requestwiki-second-language-top' => 'de,en,es,fr,it,ja,pl,pt,zh',
	'requestwiki-second-moreinfo' => 'Can you link us to more information about your topic and community?',
	'requestwiki-second-moreinfo-example' => 'example: http://www.sample.fansite.com/',
	'requestwiki-second-moreinfo-hint' => 'Where can we learn more about this topic?',
	'requestwiki-second-moreinfo-urls' => "Wikipedia\nDiscussion board\nOther",
	'requestwiki-second-submit' => 'Submit Request',
	'requestwiki-second-title' => 'Title for your wiki:',
	'requestwiki-second-title-example' => 'example: Muppet Wiki',
	'requestwiki-second-title-hint' => "The title will be displayed in several places including the wiki's main page and the browser bar. It's best to keep it short and simple.",
	'requestwiki-second-url' => 'URL for your wiki:',
	'requestwiki-second-url-example' => 'example: http://muppet.wikia.com',
	'requestwiki-second-url-hint' => "This is the web address for your wiki. It's best to use a word likely to be a search keyword for your topic. Please use only lower case without spaces and avoid special characters (i.e. $, @, or !).",
	'requestwiki-second-username' => "Requester's username",
	'requestwiki-second-username-hint' => 'Note: This username must exist in the shared database.',
	'requestwiki-second-valid-url' => 'This URL is available.',

//third step
	'requestwiki-third-footer' => '',
	'requestwiki-third-header' => '<strong>Thank you for your request!</strong><p>It has been saved successfully and will be looked at by our staff as soon as possible. We will be in touch shortly to let you know if your request has been accepted.</p><p>If you want to make changes to your form, please use the "Edit your request" link on the request page.</p><p><strong>Next steps:</strong></p><p><ol><li><a href="%s">View your request</a></li><li><a href="%s">Edit your request</a></li><li><a href="%s">Go to Wikia homepage</a></li></ol></p>',

//autoconfirm
	'requestwiki-extra-autoconfirmed-info' => 'Please <a href="$1">confirm your email</a> before requesting a new wiki.',
	'requestwiki-extra-login-info' => 'Please <a href="$1">log in</a> before requesting a new wiki.',

//comments
	'requestwiki-comments-comments' => 'Comments:',
	'requestwiki-comments-comments-hint' => 'Comments hint',
	'requestwiki-comments-header' => 'Do you have any comments on this request?  If so, please enter them here.',
	'requestwiki-comments-questions' => 'Questions:',
	'requestwiki-comments-questions-hint' => 'Is there anything you would like to ask the person requesting this wiki?  If so, please add it here.',

//misc
	'requestwiki-misc-pagetitle' => 'Request Wiki:',
	'requestwiki-first-pagetitle' => ' Step 1 of 3',
	'requestwiki-second-pagetitle' => ' Step 2 of 3',
	'requestwiki-third-pagetitle' => ' Step 3 of 3',
	'requestwiki-list-pagetitle' => ' : List of requests',

	'requestwiki-request-id' => 'Action',
	'requestwiki-request-name' => 'Proposed name',
	'requestwiki-request-language' => 'Lang',
	'requestwiki-request-title' => 'Title',
	'requestwiki-request-timestamp' => 'Request Date',
	'requestwiki-request-talk-timestamp' => 'Talk page history',
	'requestwiki-request-category' => 'Category',

//errors
	'requestwiki-error-bad-category' => 'Please choose a category for your wiki.',
	'requestwiki-error-bad-name' => 'The name cannot contain special characters (like $ or @) and must be a single lower-case word without spaces.',
	'requestwiki-error-bad-language' => 'This language does not exist.',
	'requestwiki-error-empty-field' => 'Please complete this field.',
	'requestwiki-error-in-progress' => 'Someone has already requested a wiki with this name.  Please try again, or contact staff for more help.',
	'requestwiki-error-name-taken' => 'Sorry, this name is already taken.',
	'requestwiki-error-name-too-short' => 'This name is too short, please choose a name with at least 3 characters.',
	'requestwiki-error-name-is-lang' => 'The name you have selected is a reserved language code. Please try to use a longer, more descriptive name.',
	'requestwiki-error-no-such-user' => 'This username was not found in the database.',
	'requestwiki-error-no-url-category' => 'Please choose a category for each link.',
	'requestwiki-error-page-exists' => "It's not possible to use this name because of an existing page on the request wiki.  Please try another name or contact staff for help."
);
