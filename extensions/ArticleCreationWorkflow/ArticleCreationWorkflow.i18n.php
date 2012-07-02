<?php
/* Internationalization File for Article Creation Extension 
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Rob Moen
 */
$messages['en'] = array(
	'article-creation-desc' => 'Adds a more user-friendly article creation pageflow.',
	
	'ac-hover-tooltip-title' => 'Select this if...',
	'ac-landing-page-title' =>  'Article creation landing page',
	
	//buttons
	'ac-action-indicator' => 'I want to...',

	'ac-action-login' => 'Log in to Wikipedia',
	'ac-action-login-subtitle' => 'I have a Wikipedia account.',
	'ac-hover-tooltip-body-login' => "<ul><li>You already have a user account and wish to edit under that name.</li></ul>",

	'ac-action-signup' => 'Create a Wikipedia account',
	'ac-action-signup-subtitle' => 'A Wikipedia account allows you to create new articles.',
	'ac-hover-tooltip-body-signup' => "<ul><li>You <b><i>do not</i></b> have a Wikipedia account.</li></ul>",

	'ac-action-request' => 'Request this article',
	'ac-action-request-subtitle' => "I'll submit a request that it be written.",
	'ac-action-request-subtitle-anon' => "I'll submit a request that it be written.",
	'ac-hover-tooltip-body-request' => "<ul><li> You want to see the article exist, and</li>
	<li>You do not wish to write it yourself.</li></ul>",

	'ac-action-draft' => 'Create a draft',
	'ac-action-draft-subtitle' => 'I want to make a draft of this article before I publish it to Wikipedia.',
	'ac-hover-tooltip-body-draft' => "<ul><li>You haven't created an article before, or</li>
		<li>You want to work on your article a bit before it's ready to publish</li></ul>",

	'ac-action-create' => 'Create this article myself',
	'ac-action-create-subtitle' => 'I know what I\'m doing.',
	'ac-create-warning-create' => "Articles may be deleted immediately if:
	they copy from other sources, or
	are overly promotional, or
	lack context, or
	fail to explain why their subject is notable.
	",
	'ac-create-button' => "Let's Go",
	'ac-hover-tooltip-body-create' => "<ul><li>You have created articles before, and</li>
		<li>You are familiar with Wikipedia's policies, and</li>
		<li>You <b><i>do not</i></b> have a <i>conflict of interest</i> regarding the subject matter of the article, and</li>
		<li>You have several references about the subject.</li></ul>
	",

	'ac-landing-login-required' => 'In order to create an article, you need to have a Wikipedia user account.',

	'ac-create-dismiss' => 'I want to skip this step in the future',

	'ac-create-help' => 'Learn more',
	'ac-click-tip-title-create' => 'I know that…',
);

$messages['qqq'] = array(
	'article-creation-desc' => 'Extension description.',
	
	'ac-hover-tooltip-title' => 'The title for the tooltip displayed next to the buttons',
	'ac-landing-page-title' =>  'The title of the landing page',
	
	//buttons
	'ac-action-indicator' => 'Introduction for the selection of the action that the user wants to take ("I want to...")',

	'ac-action-login' => 'Prompt to log in to the wiki, goes inside the button',
	'ac-action-login-subtitle' => 'First-person statement for the login button subtitle',
	'ac-hover-tooltip-body-login' => "Bullet point, displayed when the user has an account but isn't logged in",

	'ac-action-signup' => 'Prompt to create an account, goes inside the button',
	'ac-action-signup-subtitle' => 'First-person statement for the signup button subtitle',
	'ac-hover-tooltip-body-signup' => "* Bullet point, explaining why the user might like to sign up",

	'ac-action-request' => 'Prompt to request an article using AfC, goes inside the button',
	'ac-action-request-subtitle' => 'First-person statement for the article request button subtitle',
	'ac-action-request-subtitle-anon' => 'Explanation that AfC does not require an account',
	'ac-hover-tooltip-body-request' => "Bullet point, explains why the user might want to create a draft",

	'ac-action-draft' => 'Prompt to create a draft, goes inside button',
	'ac-action-draft-subtitle' => 'First-person statement for the draft button subtitle.',
	'ac-hover-tooltip-body-draft' => "Bullet point, explains why the user might want to create a draft article.",

	'ac-action-create' => 'Prompt to create an article directly, goes inside the button',
	'ac-action-create-subtitle' => 'First-person statement for the create button subtitle',
	'ac-create-warning-create' => 'Tooltip warning about how new articles may be deleted if they don\'t conform to policy',
	'ac-create-button' => "OK button that goes inside the warning tooltip",
	'ac-hover-tooltip-body-create' => 'Bullet point, explains which users should choose the create button.  Goes inside a tooltip.',

	'ac-create-dismiss' => 'Checkbox prompt to skip this step in future',

	'ac-create-help' => 'Link text for article creation help, goes in tooltip above text.',
	'ac-click-tip-title-create' => 'Title for reasons that an article might be deleted',
);
