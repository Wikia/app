<?php
#Related to visitor skins: Slate.php and Smoke.php
$messages = array_merge( $messages , array(

# Default for monaco skin
'monaco_skins' => 'Monaco',
'monaco-sapphire' => 'Sapphire',
'monaco-jade' => 'Jade',
'monaco-slate' => 'Slate',
'monaco-smoke' => 'Smoke',
'monaco-beach' => 'Beach',
'monaco-brick' => 'Brick',
'monaco-gaming' => 'Gaming',
'monaco-custom' => 'Custom',
'monaco-edit-this-menu' => 'Edit this menu',
'monaco-articles-on' => '$1 articles on this wiki<br />',
'monaco-welcome-back' => 'Welcome back, <b>$1</b><br />',
'monaco-widgets' => 'Widgets',
'monaco-latest' => 'Latest Activity',
'monaco-latest-item' => '$1 by $2',
'monaco-whos-online' => 'Who\'s Online',
'seemoredotdotdot' => 'See more...',

'monaco-category-list' => '*w:Category:Hubs|more wikis
**w:Gaming|Gaming
**w:Entertainment|Entertainment
**w:Sci-Fi|Science Fiction
**w:Big_wikis|Biggest wikis
**w:Hobbies|Hobbies
**w:Technology|Technology',

'monaco-footer-links' => '*Hubs
**w:Entertainment|Entertainment
**w:Gaming|Gaming
**w:Sports|Sports
**w:Toys|Toys
**w:Big_wikis|Biggest wikis
**w:Hubs|see all...
*Featured
**http://cocktails.wikia.com|Cocktails
**http://recipes.wikia.com|Recipes
**http://green.wikia.com|Green
**http://help.wikia.com/wiki/Help:Video_demos|Help Videos

*Wikia is hiring
**w:Hiring|General hiring',

'monaco-footer-wikia-links' => '*http://www.wikia.com/wiki/About_Wikia|About Wikia
*http://www.wikia.com/wiki/Contact_us|Contact Wikia
*http://www.wikia.com/wiki/Terms_of_use|Terms
*http://www.mediawiki.org/|MediaWiki
*http://www.gnu.org/copyleft/fdl.html|GFDL
*http://www.wikia.com/wiki/Advertising|Advertise on Wikia
*http://www.wikia.com/wiki/Terms_of_use#Collection_of_personal_information|<b>Privacy</b>',

'monaco-related-communities' => '*w:Entertainment|Entertainment|TV shows, movies, cartoons and comics.
*w:Gaming|Gaming|Get your game on with Wikia\'s video game wikis.
*w:Sci-Fi|Science Fiction|Explore the world of the future.
*w:Big_wikis|Biggest Wikis|See Wikia\'s biggest wikis.
*w:Hubs|See all...',

'monaco-related-communities-2' => '*w:c:ssb|Super Smash Bros|Check out the Brawl
*w:c:aoc|Age of Conan Wiki|Age of Conan
*w:c:wow|WoWWiki|World of Warcraft
*w:c:gta|Grand Theft Wiki|Grand Theft Auto 4
*w:c:guildwars|GuildWiki|Guild Wars
*w:c:yugioh|Yu-Gi-Oh!
*w:c:Runescape|Runescape',

'monaco-sidebar' => '*mainpage|{{SITENAME}}
*mainpage|Top Content
**#popular#|most_popular
**#visited#|most_visited
**#voted#|highest_ratings
**#newlychanged#|newly_changed
*portal-url|Community
**#topusers#|top_users
**portal-url|portal
**forum-url|forum
*#category1#
*#category2#',

'monaco-toolbox' => '* upload-url|Upload image
* specialpages-url|specialpages
* helppage|help
* recentchanges-url|recentchanges
* randompage-url|randompage
* whatlinkshere|whatlinkshere',



'specialpages-url' => 'Special:Specialpages',
'upload-url' => 'Special:Upload',

# Widget

'limit' => 'Limit',
'title' => 'Title',

#Overrides for MediaWiki defaults
'common.css' => '/***** CSS placed here will be applied to all skins on the entire site. *****/
/* See also: [[MediaWiki:Monobook.css]] */
/* <pre> */

/* Mark redirects in Special:Allpages and Special:Watchlist */
.allpagesredirect { font-style: italic; }
.watchlistredir { font-style: italic; }

/* Infobox template style */
.infobox {
   border: 1px solid #aaaaaa;
   background-color: #f9f9f9;
   color: black;
   margin-bottom: 0.5em;
   margin-left: 1em;
   padding: 0.2em;
   float: right;
   clear: right;
}
.infobox td,
.infobox th {
   vertical-align: top;
}
.infobox caption {
   font-size: larger;
   margin-left: inherit;
}
.infobox.bordered {
   border-collapse: collapse;
}
.infobox.bordered td,
.infobox.bordered th {
   border: 1px solid #aaaaaa;
}
.infobox.bordered .borderless td,
.infobox.bordered .borderless th {
   border: 0;
}

/* Forum formatting (by -Algorithm & -Splaka) */
.forumheader {
     border: 1px solid #aaa;
     background-color: #f9f9f9; margin-top: 1em; padding: 12px;
}
.forumlist td.forum_edited a {
     color: black; text-decoration: none
}
.forumlist td.forum_title a {
     padding-left: 20px;
}
.forumlist td.forum_title a.forum_new {
     font-weight: bold; background: url(/images/4/4e/Forum_new.gif)
     center left no-repeat; padding-left: 20px;
}
.forumlist td.forum_title a.forum_new:visited {
     font-weight: normal; background: none; padding-left: 20px;
}
.forumlist th.forum_title {
     padding-left: 20px;
}

/* Recent changes byte indicators */
.mw-plusminus-pos { color: #006500; }
.mw-plusminus-neg { color: #8B0000; }
/* </pre> */',
'skinchooser-customcss' => 'For custom themes, select the custom option in the menu above and specify custom CSS in [[MediaWiki:Monaco.css]].',
'confirmemail_subject' => 'Welcome to Wikia!',
'confirmemail_body' => "Hi $2,

Welcome to Wikia!

With thousands of communities on Wikia, there are many ways to have fun here. Spend some time getting to know Wikia by visiting the home page (www.wikia.com), taking a tutorial (<http://www.wikia.com/wiki/Help:Tutorial_1>), reading interesting and cool articles, writing content on your favorite subjects, or meeting other members of the community.


To fully activate your account, please confirm your email by clicking on the link below or pasting it into your browser.

$3

This confirmation link will expire in 7 days.

(For your information, this username was created from the following address: $1)

We look forward to seeing you on Wikia!
The Wikia Community Team
www.wikia.com
",
'enotif_lastvisited' => 'To see all changes to this page since your last visit, click here: $1',
'fileexists'		=> 'A file with this name exists already, please check $1 if you are not sure if you want to change it. Once uploaded, this image may take up to 2 minutes to be visible.',
'enotif_body' => 'Dear $WATCHINGUSERNAME,

There has been an edit to a page you are watching on {{SITENAME}}.

See $PAGETITLE_URL for the current version.

$NEWPAGE

The summary of the edit is: "$PAGESUMMARY"

Please visit and edit often,

{{SITENAME}}

___________________________________________________________________________

    * Want to control which emails you receive from Wikia? Go to: {{fullurl:{{ns:special}}:Preferences}}.
    * To see new wikis created this week, please visit http://www.wikia.com/wiki/New_wikis_this_week
',
'imagereverted' => 'Revert to earlier version was successful. <strong>This change may take up to 2 minutes to be visible.</strong>',
'pagetitle'		=> '$1 - {{SITENAME}} - a Wikia wiki',
'passwordremindertitle' => 'Password reminder from Wikia',
'passwordremindertext' => 'Hi,
The login password for user "$2" is now "$3".
If you did not request a new password, don’t worry. The replacement password has been sent only to you at this email address. Your account is secure and you can continue to use your old password.

Thanks,

The Wikia Community Team

www.wikia.com
___________________________________________________________

    * To change your preferences or password, go to: http://www.wikia.com/wiki/Special:Preferences.
    * This password reminder was requested from the following address: $1.
',
'rcshowhideenhanced' => '$1 enhanced recent changes',
'prefsnologintext'	=> 'You must be <span class="plainlinks">[{{fullurl:Special:Userlogin|returnto=$1}} logged in]</span> to set user preferences.',
'recentchangestext' => '<div style="border:solid 3px #e9e9e9; margin-bottom:0.3em;">
<div style="padding-left:0.5em; padding-right:0.5em;">
This special page lets you track the most recent changes to the wiki.

See also: [[Special:Newpages|New pages]] – [[Special:Newimages|New files]] – [[Special:Log|Logs]] – [[Special:Activeusers|Active users]] – [[Special:Listusers/sysop|Admins]]
</div>
</div>',
'sidebar' => '
* navigation
** mainpage|mainpage
** portal-url|portal
** currentevents-url|currentevents
** recentchanges-url|recentchanges
** randompage-url|randompage
** helppage|help',
'talkpage'		=> 'Talk page',
'welcomecreation' => "== Welcome, $1! ==

Your account has been created. Don't forget to change your {{SITENAME}} [[Special:Preferences|preferences]].",


# Wikia custom messages

# janitors & helpers
'group-janitor' => 'Janitors',
'grouproup-janitor-member' => 'Janitor',
'grouppage-janitor' => 'w:Janitor policy and guidelines',
'group-helper' => 'Helpers',
'group-helper-member' => 'Helper',
'grouppage-helper' => 'w:Wikia Helper Group',
'grouppage-staff' => 'w:Wikia_Staff',

# V2 navlinks
'navlinks' => '
* 1
** mainpage|Home
** Forum:Index|forum
** Special:Randompage|randompage
** Special:Createpage|createpage
',

# AjaxLogin
'ajaxLogin1' => 'To complete your log in, you must enter a new password.  This will take you away from this edit page and you may lose your current edit.',
'ajaxLogin2' => 'Are you sure? You may lose your edits if you leave this page now.',

# MiniUpload
'mu_login' => 'You must be logged in to upload files.',

# Footer Enhancements
'footer_1' => 'Improve $1 by',
'footer_1.5' => 'editing this page',
'footer_2' => 'Discuss this article',
'footer_5' => '$1 made an edit on $2',
'footer_6' => 'View random page',
'footer_7' => 'Email this article',
'footer_8' => 'Share this article',
'footer_9' => 'Rate this article',
'footer_10' => 'Share with $1',

'tagline-url-interwiki' => 'From [[wikia:c:$1|{{SITENAME}}]], a [[wikia:|Wikia]] wiki.',

# Skins
'defaultskin1' => 'The admins for this wiki have chosen: <b>$1</b> as the default skin.',
'defaultskin2' => 'The admins for this wiki have chosen: <b>$1</b> as the default skin. Click <a href="$2">here</a> to see the code.',
'defaultskin3' => 'The admins for this wiki have not chosen a default skin. Using the Wikia default: <b>$1</b>.',
'adminskin_ds' => 'Default',

'quartz_skins' => 'Quartz',
'quartz-smoke' => 'Smoke',
'quartz-slate' => 'Slate',
'quartz-beach' => 'Beach',
'quartz-brick' => 'Brick',
'quartz-gaming' => 'Gaming',
'quartz-sapphire' => 'Sapphire',
'quartz-custom' => 'Custom',

# Need to find a better place for it
'custom_info' => 'Custom themes can be built by selecting "Custom" above and then editing ',
'quartz.css' => 'body {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/background.gif) repeat-x;
	background-color: #f2f2f2;
}

#header, ul#wikia, ul#wikia li {
	background-image: url(http://images.wikia.com/common/skins/quartz/sapphire/images/header_bg.gif);
}
#header, #header a {
	color: #000;
}
#header a:hover {
	color: #333;
}

/*** User area ***/
ul#welcome li.user {
	background-image: url(http://images.wikia.com/common/skins/quartz/sapphire/images/user_menu.gif);
	color: #36C;
}
#userMenu {
	background: #f2f2f2;
	border-color: #36C;
}
#userMenu a {
	color: #000;
}
#userMenu a:hover {
	background: #36C;
	color: #FFF;
}

/*** Wikia box ***/
#wikiaLogo {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/wikia_logo.gif) no-repeat;
}
#search input {
	border-color: #36C;
}
#search div {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/search.gif) no-repeat;
}
div.gelButton {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/gel_buttons.gif) top left no-repeat;
}
div.gelButton a {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/gel_buttons.gif) top right no-repeat;
	color: #FFF;
}

/*** Nav Links ***/
table#navLinksWikia a {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/nav_bullet.gif) 0% 4px no-repeat;
	color: #000;
}

/*** Article ***/
.articleBar {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/article_bars.gif) top left no-repeat;
	color: #FFF;
}
.articleBar div {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/article_bars.gif) top right no-repeat;
}
.articleBar a {
	color: #000;
}
/*
.articleBar .editButton, .articleBar .editButton span {
	background-image: url(http://images.wikia.com/common/skins/quartz/sapphire/images/edit_button.gif);
	color: #FFF;
}
*/
table#wikiafooter, table#wikiafooter td a {
	color: #000;
}
a#wikiaFooterLogo {
	background: url(http://images.wikia.com/common/skins/quartz/sapphire/images/wikia_logo_small.gif);
}

/* widgets integration */
li.widget {
	border-color: #999;
	background: #FFF;
	color: #000;
}
li.widget a, li.widget a:visited {
	color: #000;
}
li.widget h1 {
	color: #36C;
}
.roundedDiv b.xb2, .roundedDiv b.xb3, .roundedDiv b.xb4 {
	background: #F2F2F2;
	border-color: #999;
}
.roundedDiv b.xb1 {
	background: #87888C;
}

.roundedDiv div.r_boxContent {
	background: #F2F2F2;
	border-color: #87888C;
	color: #000;
}
.widgetWikiaToolbox .listHdr {
	color: #36C;
}

div.wikiaDialog .hd,
div.wikiaDialog h2,
.boxHeader_noBorderMargin,
.boxHeader_noBorder,
.boxHeader {
	color: #36C !important;
	border-color: #87888c;
}

#switchSkin a {
	color: #FFF;
}

/* AutoComplete/SearchSuggest - Inez */
.yui-ac-content li.yui-ac-highlight {
	background: #36C !important;
}
.yui-ac-content li.yui-ac-prehighlight {
	background: #36C !important;
}

/* tooltips */
.wikiaTooltip {
	background-color: #ffec3b;
	border-color: #FFD242;
}

.prefSection {
	background: #EEE;
}
',

'wikipedia_skin' => 'Wikipedia skin',
'old_skins' => 'Old skins',
'tog-skinoverwrite' => '<b>See custom wikis</b> (recommended)<br>Some wiki administrators take a lot of time to customize the look of their wikis. Check the box above to see their wikis with full customization.',
'defaultskin_choose' => 'Set the default theme for this wiki: ',
'admin_skin' => 'Admin Options',

#Misc stuff
'or' => 'or',
'contris' => 'Contributions',
'wikicitieshome' => 'Wikia Home',
'wikicitieshome-url' => 'http://www.wikia.com/',
'wikicitieshome-url/fr' => 'http://fr.wikia.com/',
'irc' => 'Live wiki help',
'irc-url' => 'http://irc.wikia.com/',
'shared-problemreport' => 'Report a problem',
'shared-problemreport-url' => 'http://www.wikia.com/wiki/Report_a_problem',
'wikicities-nav' => 'wikia',
'searchsuggest' => 'Search suggest',
'tog-searchsuggest' => 'Use search suggest',
'tog-htmlemails' => 'Emails in HTML format',
'tagline-url'   => 'From [{{SERVER}} {{SITENAME}}], a [http://www.wikia.com Wikia] wiki.',
'tagline-url-interwiki' => 'From [[wikia:c:$1|{{SITENAME}}]], a [[wikia:|Wikia]] wiki.',
'showall' => 'Show All', #ticet #699 messages
'hidesome' => 'Hide Some',
'popular-articles' => 'Popular Articles',
'popular-wikis' => 'Popular Wikis',

#Wikia Widgets

'wg_lastwikis' => 'Recently Visited',
'editedrecently' => "Recently edited by",
'nocontributors' => 'This page has no contributors',
'refreshpage' => 'Reload page to activate this widget',
'needhelp' => "Need Help: Please edit [[MediaWiki:needhelp|this page]] to show articles here.",
'shoutbox' => 'Shout Box',
'send' => 'Send',

#Wikia Widgets tooltips
'wt_help_startup'  => '|Not familiar with widgets?||Open user menu and click "Manage widgets"...',
'wt_help_cockpit'  => '|Widgets cockpit||Drag widget thumbs and drop them on sidebar to add wiget...',
'wt_help_sidebar'  =>  '|Widgets sidebar||Click "edit" to change widgets preferences. You can close widgets with x icon',

# Wikia countdown widget
'wt_countdown_give_date' => 'Please give date in format YYYY-MM-DD HH:MM:SS (like 2007-03-28 13:56:00) or YYYY-MM-DD (like 2007-02-17) or HH:MM:SS (like 17:01:00)',
'wt_countdown_show_seconds' => 'Show seconds',

# Wikia LastWikis widget
'wt_lastwikis_noresults' => 'There are no previously visited wikis to display. Visit our [[w:Category:Hubs|Hub list]] for other wikis to visit.',

# Wikia WikiPage widget
'widgetwikipage' => "This ''message'' is a '''simple''' test of WikiPage widget. You can '''edit content of widget''' by simply [[Mediawiki:$1|editing page]] in MediaWiki namespace.",
'widget-wikipage-title' => 'Title of widget',
'widget-wikipage-source' => 'Source page',

# Wikia shoutbox widget
'wt_shoutbox_initial_message' => 'Hi... welcome to the chat!',

# Wikia referrers widget
'wt_referers_empty_list' => 'Currently we don\'t have statistics to generate top referrers cloud for this wiki. Please try later...',
'wt_show_referrers' => 'Show referrers',
'wt_show_period' => 'Show period',
'wt_show_external_urls' => 'Show only external urls',
'wt_show_internal_urls' => 'Show also internal urls',

# Wikia widgets special pages
'widgets' => 'Widgets list',

# Wikia tooltip
'wt_click_to_close'  => 'Click to close tooltip...',

# Recent changes widget 
'hidebots' => 'Hide bots',

# Community widget
'widget-community-secondsago' => ', {{PLURAL:$1|one second ago|$1 seconds ago}}',
'widget-community-minutesago' => ', {{PLURAL:$1|one minute ago|$1 minutes ago}}',
'widget-community-hoursago' => ', {{PLURAL:$1|one hour ago|$1 hours ago}}',
'widget-community-yesterday' => ', yesterday',

'widget-bookmark-empty' => 'Add your favorite pages by clicking "add" icon above',
'widget-contribs-empty' => 'You have no contributions on this wiki.',
'widget-contribs-limit' => 'Limit',
'widget-empty-list' => '(the list is empty)',

#CreateWiki stuff
'createwiki' => 'Request a new wiki',
'createwikipagetitle' => 'Request a new wiki',
'createwikitext' => 'You can request a new wiki be created on this page.  Just fill out the form',
'createwikititle' => 'Title for the wiki',
'createwikiname' => 'Name for the wiki',
'createwikinamevstitle' => 'The name for the wiki differs from the title of the wiki in that the name is what will be used to determine the default url.  For instance, a name of "starwars" would be accessible as http://starwars.wikia.com/. The title of the wiki may contain spaces, the name should only contain letters and numbers.',
'createwikidesc' => 'Description of the wiki',
'createwikiaddtnl' => 'Additional Information',
'createwikimailsub' => 'Request for a new Wikia',
'requestcreatewiki' => 'Submit Request',
'createwikisubmitcomplete' => 'Your submission is complete.  If you gave an email address, you will be contacted regarding the new Wiki.  Thank you for using {{SITENAME}}.',
'createwikilang' => 'Default language for this wiki',

#Special:Contact stuff

'contact' => 'Contact Wikia',
'contactpagetitle' => 'Contact Wikia',
'contactproblem' => 'Subject',
'contactproblemdesc' => 'Message',
'createwikidesc' => 'Description of the Wiki',
'contactmailsub' => 'Wikia Contact Mail',
'contactmail' => 'Send',
'contactpage-email-failed' => '<b style="color: red">Please provide a valid e-mail address.</b>',
'yourmail' => 'Your email address',
'contactsubmitcomplete' => 'Thank you for contacting Wikia.',
'contactrealname' => 'Your name',
'contactwikiname' => 'Name of the wiki',
'contactintro' => 'Please read the <a href=http://www.wikia.com/wiki/Report_a_problem>Report a problem</a> page for information on reporting problems and using this contact form.<p />You can contact the Wikia community at the <a href=http://www.wikia.com/wiki/Community_portal>Community portal</a> and report software bugs at <a href=http://bugs.wikia.com>bugs.wikia.com</a>. <p>If you prefer your message to <a href=http://www.wikia.com/wiki/Wikia>Wikia</a> to be private, please use the contact form below. <i>All fields are optional</i>.',

#Special:SharedHelp
'shared_help_info' => 'This text is stored on the Help Wikia.  [[w:c:Help:Help_talk:$1|Suggest changes here]].',
'shared_help_edit_info' => 'The help text within the box is stored at [[w:c:help:Help:$1|Help:$1]] on Wikia Help. See [[Help:Shared Help]] for more info.

Any changes that apply to \'\'all\'\' wikis should be made to the Wikia Help copy. [[w:c:help:Help_talk:$1|Suggest changes here]].

Text should be placed on this page if you wish to explain usage, style and policy guidelines which apply only to {{SITENAME}}. Text added in this edit box will be displayed below the boxed help text.',
'shared_help_search_info' => 'To search for help with editing, please visit the [http://help.wikia.com/wiki/Special:Search?search=$1 Help Wikia]',
'shared_help_was_redirect' => 'This page is a redirect to $1',

#Special:MultiUpload
'multiplefileuploadsummary' => 'Summary:',

# image upload (all methods) 
'uploadtext-ext' => "A full list of allowed extensions is available on the [[{{ns:Special}}:Version|wiki version page]].", 

# Wikiwyg related stuff
'save' => 'Save' ,
'wysiwygcaption' => 'Visual editing' ,
'insertimage' => 'Insert image' ,
'edit-summary' => 'Edit summary' ,
'mwlink_tip' => 'Internal link' ,

# tabbed search
'searchtype'	=> 'Search frontend type',
'tabbedsearchsolr'	=> 'Tabbed search',
'tabbedsearchcse'	=> 'Tabbed search (Google custom search)',
'nontabbedsearch'	=> 'Non-tabbed search',
'nontabbedsearchold'	=> 'Non-tabbed search (use old title/text matches display)',

#Related to home page skin
'right_now' => 'Right Now<br />people are...',
'other_people' => 'Other people have been searching for...',
'whats_new' => "What's New",
'featured' => 'Featured',
'hubs' => 'Hubs',
'all_the_wikia' => 'All the wikia',
'its_easy' => "...it's easy and free",
'or_learn' => 'Or to learn more, take the ',

#Related to visitor skins: Slate.php and Smoke.php
'login_greeting' => "Welcome, [[User:$1|$1]]!",
'create_an_account' => "Create an account",
'log_in' => "Log in",
'already_a_member' => "Already a member?",
'login_as_another' => "Login as another user",
'not_you' => "Not you?",
'this_wiki' => "this wiki",
'home' => "Home",
'forum' => "Forum",
'forum-url' => "Forum:Index",
'helpfaq' => "Help & FAQ",
'createpage' => "Start new article",
'joinnow' => "join now",
'most_popular_articles' => "most popular articles",
'messagebar_mess' => "Did you know you can <a href=\"$1\">edit this page</a> or <a href=\"$2\">create a new one</a>? <a href=\"$3\">Find out how</a> this works.",
'edit_this_page' => "<a href=\"$1\">Edit this article</a>",
'expert_tools' => "expert tools",
'this_article' => "This article",
'this_page' => "This page",
'this_user' => 'This user',
'this_project' => 'This project',
'this_image' => 'This image',
'this_message' => 'This message',
'this_template' => 'This template',
'this_help' => 'This help',
'this_category' => 'This category',
'this_forum' => 'This forum',
'this_special' => 'This special page',
'this_discussion' => 'This discussion',
'edit_contribute' => "Edit / Contribute",
'discuss' => "Discuss this page",
'return_to_article' => 'Return to article',
'return_to_talk' => 'Return to discussion',
'return_to_user' => 'Return to user page',
'return_to_user_talk' => 'Return to discussion',
'return_to_project' => 'Return to project page',
'return_to_project_talk' => 'Return to discussion',
'return_to_image' => 'Return to image page',
'return_to_image_talk' => 'Return to discussion',
'return_to_mediawiki' => 'Return to message page',
'return_to_mediawiki_talk' => 'Return to discussion',
'return_to_template' => 'Return to template page',
'return_to_template_talk' => 'Return to discussion',
'return_to_help' => 'Return to help page',
'return_to_help_talk' => 'Return to discussion',
'return_to_category' => 'Return to category page',
'return_to_category_talk' => 'Return to discussion',
'return_to_forum' => 'Return to forum page',
'return_to_forum_talk' => 'Return to discussion',
'return_to_special' => 'Return to special page',
'add_comment' => 'Leave message',
'share_it' => "Share it:",
'my_stuff' => "my stuff",
'choose_reason' => "Choose reason",
'top_five' => "top five",
'most_popular' => "Most popular",
'most_visited' => "Most visited",
'newly_changed' => "Newly changed",
'highest_ratings' => "Highest ratings",
'most_emailed' => "Most emailed",
'users' => "Users",
'community' => 'Community',
'rate_it' => 'Rate this article:',
'unrate_it' => 'Unrate it',
'use_old_formatting' => 'Switch to Monobook skin',
'use_new_formatting' => 'Try new skin',
'review_reason_1' => 'Review reason 1',
'review_reason_2' => 'Review reason 2',
'review_reason_3' => 'Review reason 3',
'review_reason_4' => 'Review reason 4',
'review_reason_5' => 'Review reason 5',
'review_reason_4' => 'Review reason 4',
'review_reason_5' => 'Review reason 5',
'contris_s' => 'Contributions',
'watchlist_s' => 'Watchlist',
'preferences_s' => 'Preferences',
'tog-searchsuggest' => 'Show suggests in search box',
'manage_widgets' => 'Manage widgets',
'cockpit_hide' => 'Hide cockpit',
'widget_name' => 'Name',
'widget_description' => 'Description',
'see_more' => 'See more...',
'back' => 'Back',
'new_article' => 'New article',
'new_wiki' => 'New wiki',
'profile' => 'Profile',
'wikia_messages' => 'Wikia messages',
'footer_MediaWiki' => '[http://www.mediawiki.org/ MediaWiki]',
'footer_License' => '[http://www.gnu.org/copyleft/fdl.html GFDL]',
'footer_About_Wikia' => '[http://www.wikia.com/wiki/About_Wikia About Wikia]',
'footer_Contact_Wikia' => '[http://www.wikia.com/wiki/Contact_us Contact Wikia]',
'footer_Terms_of_use' => '[http://www.wikia.com/wiki/Terms_of_use Terms of use]',
'footer_Advertise_on_Wikia' => '[http://www.wikia.com/wiki/Advertising Advertise on Wikia]',

'related_wiki' => 'Add bulleted links here to display wiki related to this one in the related wiki [[Special:Widgets|widget]].

* [{{FULLURL:MediaWiki:Related wiki}} No related wiki have been selected yet.]',
'locked' => 'locked',
'unlocked' => 'unlocked',
'var_set' => 'set the $2 to "$3"',
'var_logtext' => 'Settings log',
'yourbirthdate' => 'Birth date:',
'userlogin-bad-birthday' => 'Choose correct birthdate.',
'userlogin-choose-year' => 'Year',
'userlogin-choose-month' => 'Month',
'userlogin-choose-day' => 'Day',
'userlogin-unable-title' => 'Unable to create registration',
'userlogin-unable-info' => 'We are sorry, we are unable to register you at this time.',
'userlogin-captcha-label' => 'Enter the word that appears:',
'userlogin-form-error' => 'Please fix errors above before proceeding.',
'unable-block-edit' => 'You are not allowed to edit this page. Try again later.',
'var_logheader' => 'Below is a list of the most recent configuration changes for this wiki.',
'tog-showAds' => '<b>Show all advertisements</b><br/>Select this option to see article pages as logged-out users see them.<br/><br/>',
'fast-adv' => 'Advertisement',
'tog-disablewysiwyg' => 'Disable Rich Text Editing',
'atom' => 'Wikia Atom',
'feed-watom' => 'Wikia Atom',
'nodiff' => 'No changes',
));
