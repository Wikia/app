<?php
/**
 * Internationalization file for AutoCreateWiki extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	"autocreatewiki" => "Create a new Wiki",
	"createwikipagetitle" => "Create a new Wiki",
	"createwiki"=> "Create a new Wiki",
	"autocreatewiki-chooseone" => "Choose one",
	"autocreatewiki-required" => "$1 = required",
	"autocreatewiki-web-address" => "Web Address:",
	"autocreatewiki-category-select" => "Select one",
	"autocreatewiki-language-top" => "Top $1 languages",
	"autocreatewiki-language-all" => "All languages",
	"autocreatewiki-birthdate" => "Birth date:",
	"autocreatewiki-blurry-word" => "Blurry word:",
	"autocreatewiki-remember" => "Remember me",
	"autocreatewiki-create-account" => "Create an Account",
	"autocreatewiki-done" => "done",
	"autocreatewiki-error" => "error",
	"autocreatewiki-language-top-list" => "de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh",
	"autocreatewiki-haveaccount-question" => "Do you already have a Wikia account?",
	"autocreatewiki-success-title" => "Your wiki has been created!",
	"autocreatewiki-success-subtitle" => "You can now begin working on your wiki by visiting:",
	"autocreatewiki-success-has-been-created" => "has been created!",
	"autocreatewiki-success-get-started" => "Get Started",
// form messages
	"autocreatewiki-info-domain" => "It's best to use a word likely to be a search keyword for your topic.",
	"autocreatewiki-info-topic" => "Add a short description such as \"Star Wars\" or \"TV Shows\".",
	"autocreatewiki-info-category" => "This will help visitors find your wiki.",
	"autocreatewiki-info-language" => "This will be the default language for visitors to your wiki.",
	"autocreatewiki-info-email-address" => "Your email address is never shown to anyone on Wikia.",
	"autocreatewiki-info-realname" => "If you choose to provide it this will be used for giving you attribution for your work.",
	"autocreatewiki-info-birthdate" => "Wikia requires all users to provide their real date of birth as both a safety precaution and as a means of preserving the integrity of the site while complying with federal regulations.",
	"autocreatewiki-info-blurry-word" => "To help protect against automated account creation, please type the blurry word that you see into this field.",
	"autocreatewiki-info-terms-agree" => "By creating a wiki and a user account, you agree to the <a href=\"http://www.wikia.com/wiki/Terms_of_use\">Wikia's Terms of Use</a>",
	"autocreatewiki-info-staff-username" => "<b>Staff only:</b> The specified user will be listed as the founder.",
// errors
	"autocreatewiki-limit-day" => "Wikia has exceeded the maximum number of wiki creations today ($1).",
	"autocreatewiki-limit-creation" => "You have exceeded the the maximum number of wiki creation in 24 hours ($1).",
	"autocreatewiki-empty-field" => "Please complete this field.",
	"autocreatewiki-bad-name" => "The name cannot contain special characters (like $ or @) and must be a single lower-case word without spaces.",
	"autocreatewiki-invalid-wikiname" => "The name cannot contain special characters (like $ or @) and cannot be empty",
	"autocreatewiki-violate-policy" => "This wiki name contains a word that violates our naming policy",
	"autocreatewiki-name-taken" => "A wiki with this name already exists. You are welcome to join us at <a href=\"http://$1.wikia.com\">http://$1.wikia.com</a>",
	"autocreatewiki-name-too-short" => "This name is too short, please choose a name with at least 3 characters.",
	"autocreatewiki-name-too-long" => "This name is too long, please choose a name with maximum 50 characters.",
	"autocreatewiki-similar-wikis" => "Below are the wikis already created on this topic. We suggest editing one of them.",
	"autocreatewiki-invalid-username" => "This username is invalid.",
	"autocreatewiki-busy-username" => "This username is already taken.",
	"autocreatewiki-blocked-username" => "You cannot create account.",
	"autocreatewiki-user-notloggedin" => "Your account was created but not logged in!",
	"autocreatewiki-empty-language" => "Please, select language of Wiki.",
	"autocreatewiki-empty-category" => "Please, select one of category.",
	"autocreatewiki-empty-wikiname" => "The name of Wiki cannot be empty.",
	"autocreatewiki-empty-username" => "Username cannot be empty.",
	"autocreatewiki-empty-password" => "Password cannot be empty.",
	"autocreatewiki-empty-retype-password" => "Retype password cannot be empty.",
	"autocreatewiki-set-username" => "Set username first.",
	"autocreatewiki-invalid-category" => "Invalid value of category. Please select proper from dropdown list.",
	"autocreatewiki-invalid-language" => "Invalid value of language. Please select proper from dropdown list.",
	"autocreatewiki-invalid-retype-passwd" => "Please, retype the same password as above",
	"autocreatewiki-invalid-birthday" => "Invalid birth date",
	"autocreatewiki-limit-birthday" => "Unable to create registration. ",
// processing
	"autocreatewiki-log-title" => "Your wiki is being created",
	"autocreatewiki-step0" => "Initializing process ... ",
	"autocreatewiki-stepdefault" => "Process is running, please wait ... ",
	"autocreatewiki-errordefault" => "Process was not finished ... ",
	"autocreatewiki-step1" => "Creating images folder ... ",
	"autocreatewiki-step2" => "Creating database ... ",
	"autocreatewiki-step3" => "Setting default information in database ...",
	"autocreatewiki-step4" => "Copying default images and logo ...",
	"autocreatewiki-step5" => "Setting default variables in database ...",
	"autocreatewiki-step6" => "Setting default tables in database ...",
	"autocreatewiki-step7" => "Setting language starter ... ",
	"autocreatewiki-step8" => "Setting user groups and categories ... ",
	"autocreatewiki-step9" => "Setting variables for new Wiki ... ",
	"autocreatewiki-step10" => "Setting pages on central Wiki ... ",
	"autocreatewiki-step11" => "Sending email to user ... ",
	"autocreatewiki-redirect" => "Redirecting to new Wiki: $1 ... ",
	"autocreatewiki-congratulation" => "Congratulations!",
	"autocreatewiki-welcometalk-log" => "Welcome Message",
	"autocreatewiki-regex-error-comment" => "used in Wiki $1 (whole text: $2)",
// processing errors
	"autocreatewiki-step2-error" => "Database exists!",
	"autocreatewiki-step3-error" => "Cannot set default information in database!",
	"autocreatewiki-step6-error" => "Cannot set default tables in database!",
	"autocreatewiki-step7-error" => "Cannot copy starter database for language!",
	"requestwiki-filter-language" => "kh,kp,mu,als,an,ast,de-form,de-weig,dk,en-gb,ia,ie,ksh,mwl,pdc,pfl,simple,tokipona,tp,zh-cn,zh-hans,zh-hant,zh-hk,zh-mo,zh-my,zh-sg,zh-tw",
// task
	"autocreatewiki-protect-reason" => 'Part of the official interface',
    "autocreatewiki-welcomesubject" => "$1 has been created!",
    "autocreatewiki-welcomebody" => "
Hello, $2,

The Wikia you requested is now available at <$1> We hope to see you editing there soon!

We've added some Information and Tips on your User Talk Page (<$5> to help you get started.

If you have any problems, you can ask for community help on the wiki at <http://www.wikia.com/wiki/Forum:Help_desk>, or via email to community@wikia.com. You can also visit our live #wikia IRC chat channel <http://irc.wikia.com>.

I can be contacted directly by email or on my talk page, if you have any questions or concerns.

Good luck with the project!

$3

Wikia Community Team

<http://www.wikia.com/wiki/User:$4>
    ",
    "autocreatewiki-welcometalk" => "
== Welcome! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hi $1 -- we're excited to have '''$4''' as part of the Wikia community!

Now you've got a whole website to fill up with information, pictures and videos about your favorite topic. But right now, it's just blank pages staring at you... Scary, right? Here are some ways to get started.

* '''Introduce your topic''' on the front page. This is your opportunity to explain to your readers what your topic is all about. Write as much as you want! Your description can link off to all the important pages on your site. 

* '''Start some new pages''' -- just a sentence or two is fine to get started. Don't let the blank page stare you down! A wiki is all about adding and changing things as you go along. You can also add pictures and videos, to fill out the page and make it more interesting.

And then just keep going! People like visiting wikis when there's lots of stuff to read and look at, so keep adding stuff, and you'll attract readers and editors. There's a lot to do, but don't worry -- today's your first day, and you've got plenty of time. Every wiki starts the same way -- a little bit at a time, starting with the first few pages, until it grows into a huge, busy site. 

If you've got questions, you can e-mail us through our [[Special:Contact|contact form]]. Have fun!

-- [[User:$2|$3]] <staff /></div>
    ",
// new wikis - special page
	"newwikis" => "New wikis",
	"newwikisstart" => "Display Wikis starting at:",
);
