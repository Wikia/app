<?php

$messages = array();
// note: leaving in body-HTML for backwards compatibility

$messages['en'] = array(
	'founderemails-desc' => 'Helps informing founders about changes on their wiki',
	'tog-founderemailsenabled' => 'E-mail me updates on what other people are doing (founders only)',
// registered
	'founderemails-email-user-registered-subject' => 'Someone new joined $WIKINAME',
	'founderemails-email-user-registered-body' => 'Hi $FOUNDERNAME,

Congratulations! $USERNAME has just joined $WIKINAME.

Take this opportunity to welcome them to your wiki and encourage them to help edit. The more the merrier, and the faster your wiki will grow.

The Wikia Team',
	'founderemails-email-user-registered-greeting' => 'Hi $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Congratulations! $USERNAME has just joined $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Take this opportunity to welcome them to your wiki and encourage them to help edit. The more the merrier, and the faster your wiki will grow.',
	'founderemails-email-user-registered-signature' => 'The Wikia Team',
	'founderemails-email-user-registered-button' => 'Welcome Them',
	'founderemails-email-user-registered-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It looks like $USERNAME has registered on your wiki! Why don\'t you drop by their <a href="$USERTALKPAGEURL">talkpage</a> to say hello?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-email-0-days-passed-subject' => 'Welcome to Wikia!',
	'founderemails-email-0-days-passed-body' => 'Nice to meet you $FOUNDERNAME,

Congratulations on creating $WIKINAME!

Here are a few helpful tips to get you started:

Add pages. A wiki is all about sharing information about your unique topic. Create pages by clicking on “Add a Page” and fill out more specific information about your topic.

Add photos. Pages are always better when they have visuals! Add images to your pages and to your main page. You can click Add a Photo to add a photo, a photo gallery, or a slideshow.

Customize your theme. Customize your wiki’s theme and wordmark to make your wiki stand out! Use the Theme Designer to add custom colors to your wiki and make it unique to your topic.

We won’t leave you out in the cold. We’re here to help you make $WIKINAME successful every step of the way. Visit community.wikia.com for forums, advice and help, or to email us your questions!

Happy wiki building! The Wikia Team

___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: http://messaging.wikia.com/wiki/Special:Preferences.
Click the following link to unsubscribe from all Wikia emails: $UNSUBSCRIBEURL',
	'founderemails-email-0-days-passed-body-HTML' => 'Congratulations on creating <strong>$WIKINAME</strong> - you\'re now part of the Wikia community!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-email-3-days-passed-subject' => 'How\'s it going on your wiki',
	'founderemails-email-3-days-passed-body' => 'Hi there $FOUNDERNAME,

We wanted to check in and see how things are going at $WIKINAME.

It\'s been 3 days since you started and we thought we\'d drop by to
offer some more tips on building your wiki:

Spruce up your main page. The main page is one of the first things
people see when they visit $WIKINAME. Make a good first impression by
writing a detailed summary of what your topic is about and adding a
slideshow, gallery, or photo slider.
  
Add even more photos. One of the best ways to make your pages snap,
crackle, and pop is to "add some photos".
  
Find inspiration. Don\'t be afraid to check out other wikis to see how
they\'ve worked out their main page, articles pages and more. Here are
some of our favorites: Muppet Wiki, Pop Tarts Wiki, Monster High Wiki.

Need help figuring out how something works? We\'re always here for you!
Come ask us for help and advice at community.wikia.com.

Keep up the great work!
The Wikia Team 


To check out the latest happenings on Wikia, visit community.wikia.com
Want to control which emails you receive? Go to your
http://community.wikia.com/wiki/Special:Preferences',
	'founderemails-email-3-days-passed-body-HTML' => 'Hey there $FOUNDERNAME,<br /><br />
Now that you\'re a few days into your wiki, we thought you might want to check out a few other things you can do.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-email-10-days-passed-subject' => 'Happy 10 day anniversary!',
	'founderemails-email-10-days-passed-body' => 'How\'s it going $FOUNDERNAME?

Whoa, time flies!  It\'s already been 10 days since you started $WIKINAME.  

Get others involved in your project and show off all the awesome work you’ve been doing!  Here are some ways to spread the word:

Didn\'t your mother tell you to Share? Use the Share button on your toolbar, article pages and photos to show them off to your friends and Followers on Facebook, Twitter or other popular sites.

Harness the power of email.  Email others you know who are interested in your topic or interested in helping you, like a friend from school or a co-worker.  You can also email specific photos from your wiki using the email button.

Join up with similar websites. Ask people on other forums or websites that are about your topic for help by posting in their forums or comments.  If possible, contact the administrator and see if they\'re interested in link-sharing — they\'ll put your wiki link on their website if you put their link on your wiki.

You can also ask other Wikians to help out on your wiki by posting in the forums on community.wikia.com.  

Keep up the good work!

The Wikia Team

___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: http://messaging.wikia.com/wiki/Special:Preferences.
Click the following link to unsubscribe from all Wikia emails: $UNSUBSCRIBEURL',
// first edit
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME has a new edit!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Hi $FOUNDERNAME,

All right! $USERNAME has just made their very first edit on $WIKINAME.

Head over to $PAGETITLE to check out what they added.

The Wikia Team',
	'founderemails-email-first-edit-greeting' => 'Hi $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => 'All right! $USERNAME has just made their very first edit on $WIKINAME.',
	'founderemails-email-first-edit-content' => 'Head over to $PAGETITLE to check out what they added.',
	'founderemails-email-first-edit-signature' => 'The Wikia Team',
	'founderemails-email-first-edit-button' => 'Check it out!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It looks like registered user $USERNAME has edited your wiki for the first time! Why don\'t you drop by their <a href="$USERTALKPAGEURL">talkpage</a> to say hello?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
// general user edit
	'founderemails-email-page-edited-reg-user-subject' => 'New edit on $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Hi $FOUNDERNAME,

$USERNAME just made another edit to the $WIKINAME on $PAGETITLE.

Head over to $PAGETITLE to see what they\'ve changed.

The Wikia Team',
	'founderemails-email-general-edit-greeting' => 'Hi $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => '$USERNAME just made another edit to the $WIKINAME on $PAGETITLE.',
	'founderemails-email-general-edit-content' => 'Head over to $PAGETITLE to check out what they added.',
	'founderemails-email-general-edit-signature' => 'The Wikia Team',
	'founderemails-email-general-edit-button' => 'Check it out!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It looks like registered user $USERNAME has edited your wiki! Why don\'t you drop by their <a href="$USERTALKPAGEURL">talkpage</a> to say hello?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
// anon edit
	'founderemails-email-page-edited-anon-subject' => 'A mysterious friend edited $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Hi $FOUNDERNAME,

A Wikia Contributor has just made an edit to $PAGETITLE on $WIKINAME.

Wikia Contributors are people who make edits without logging in to a Wikia account. Go see what this mysterious friend added!

The Wikia Team',
	'founderemails-email-anon-edit-greeting' => 'Hi $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'A Wikia Contributor has just made an edit to $PAGETITLE on $WIKINAME.',
	'founderemails-email-anon-edit-content' => 'Wikia Contributors are people who make edits without logging in to a Wikia account. Go see what this mysterious friend added!',
	'founderemails-email-anon-edit-signature' => 'The Wikia Team',
	'founderemails-email-anon-edit-button' => 'Check it out!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It looks like someone has edited your wiki! Why don\'t you <a href="$MYHOMEURL">check it out</a> to see what changed?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
// answers
	'founderemails-answers-email-user-registered-subject' => 'Someone registered an account on your QA wiki!',
	'founderemails-answers-email-user-registered-body' => 'Hey $FOUNDERNAME,

It looks like $USERNAME has registered on your wiki! Why don\'t you drop by their talkpage $USERTALKPAGEURL to say hello?

-- The Wikia Team',
	'founderemails-answers-email-user-registered-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It looks like $USERNAME has registered on your wiki! Why don\'t you drop by their <a href="$USERTALKPAGEURL">talkpage</a> to say hello?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Welcome to QA Wikia!',
	'founderemails-answers-email-0-days-passed-body' => 'Congratulations on creating $WIKINAME - you\'re now part of the Wikia community!

-- The Wikia Team',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Congratulations on creating <strong>$WIKINAME</strong> - you\'re now part of the Wikia community!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Checking in',
	'founderemails-answers-email-3-days-passed-body' => 'Hey there $FOUNDERNAME,

Now that you\'re a few days into your wiki, we thought you might want to check out a few other things you can do.

-- The Wikia Team',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Hey there $FOUNDERNAME,<br /><br />
Now that you\'re a few days into your wiki, we thought you might want to check out a few other things you can do.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'How are things going on your wiki?',
	'founderemails-answers-email-10-days-passed-body' => 'Hey $FOUNDERNAME,

It\'s been a little while since you started a wiki on Wikia - we hope it\'s going great! We wanted to share a few final tidbits to help make your wiki more like home.

-- The Wikia Team',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It\'s been a little while since you started a wiki on Wikia - we hope it\'s going great! We wanted to share a few final tidbits to help make your wiki more like home.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Registered user changed your site for the first time!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Hey $FOUNDERNAME,

It looks like registered user $USERNAME has edited your wiki for the first time! Why don\'t you drop by their talkpage ($USERTALKPAGEURL) to say hello?

-- The Wikia Team',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It looks like registered user $USERNAME has edited your wiki for the first time! Why don\'t you drop by their <a href="$USERTALKPAGEURL">talkpage</a> to say hello?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Registered user changed your site!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Hey $FOUNDERNAME,

It looks like registered user $USERNAME has edited your wiki! Why don\'t you drop by their talkpage ($USERTALKPAGEURL) to say hello?

-- The Wikia Team',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It looks like registered user $USERNAME has edited your wiki! Why don\'t you drop by their <a href="$USERTALKPAGEURL">talkpage</a> to say hello?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Someone changed your site!',
	'founderemails-answers-email-page-edited-anon-body' => 'Hey $FOUNDERNAME,

It looks like someone has edited your wiki! Why don\'t you check it out $MYHOMEURL to see what changed?

-- The Wikia Team',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
It looks like someone has edited your wiki! Why don\'t you <a href="$MYHOMEURL">check it out</a> to see what changed?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
// a lot happening 
	'founderemails-lot-happening-subject' => '$WIKINAME is heating up!',
	'founderemails-lot-happening-body' => 'Hi $FOUNDERNAME,

Congratulations! there\'s a lot going on at $WIKINAME today!

If you haven\'t already you can go to Wiki Activity see all of the great work that\'s been happening.

Since there\'s so much going on, you might also want to change your email preferences to digest mode. With digest mode on you\'ll receive one email that lists all of the activity on your wiki each day.

The Wikia Team',
	'founderemails-lot-happening-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
There\'s a lot happening on your wiki today! Drop by $MYHOMEURL to see what\'s been going on.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-email-lot-happening-greeting' => 'Hi $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => 'Congratulations! there\'s a lot going on at $WIKINAME today!',
	'founderemails-email-lot-happening-content' => 'If you haven\'t already you can go to Wiki Activity see all of the great work that\'s been happening.  Since there\'s so much going on, you might also want to change your email preferences to digest mode. With digest mode on you\'ll receive one email that lists all of the activity on your wiki each day.',
	'founderemails-email-lot-happening-signature' => 'The Wikia Team',
	'founderemails-email-lot-happening-button' => 'See Activities',
// New Founder email messages
	'founderemails-email-footer-line1' => 'To check out the latest happenings on Wikia, visit <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Want to control which emails you receive? Go to your <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferences</a>',
// day 0
	'founderemails-email-0-day-heading' => 'Nice to meet you $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Congratulations on creating $HDWIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Here are a few helpful tips to get you started:',
	'founderemails-email-0-day-addpages-heading' => 'Add pages.',
	'founderemails-email-0-day-addpages-content' => 'A wiki is all about sharing information about your unique topic.  Create pages by clicking on <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">"Add a Page"</a> and fill out more specific information about your topic.',
	'founderemails-email-0-day-addpages-button' => 'Add a Page',
	'founderemails-email-0-day-addphotos-heading' => 'Add photos.',
	'founderemails-email-0-day-addphotos-content' => 'Pages are always better when they have visuals!  Add images to your pages and to your main page.  You can click <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"Add a Photo"</a> to add a photo, a photo gallery, or a slideshow.',
	'founderemails-email-0-day-addphotos-button' => 'Add a Photo',
	'founderemails-email-0-day-customizetheme-heading' => 'Customize your theme.',
	'founderemails-email-0-day-customizetheme-content' => 'Customize your wiki\'s theme and wordmark to make your wiki stand out!  Use the <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Theme Designer</a> to add custom colors to your wiki and make it unique to your topic.',
	'founderemails-email-0-day-customizetheme-button' => 'Customize',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">We won\'t leave you out in the cold.</span>  We\'re here to help you make $WIKINAME successful every step of the way.  Visit <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> for forums, advice, and help, or to <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">email us</a> your questions!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Happy wiki building!<br />The Wikia Team',
// day 3
	'founderemails-email-3-day-heading' => 'Hi there $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'We wanted to check in and see how things are going at $HDWIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'It\'s been 3 days since you started and we thought we\'d drop by to offer some more tips on building your wiki:',
	'founderemails-email-3-day-editmainpage-heading' => 'Spruce up your main page.',
	'founderemails-email-3-day-editmainpage-content' => 'The main page is one of the first things people see when they visit <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>.  Make a good first impression by writing a detailed summary of what your topic is about and adding a slideshow, gallery, or photo slider.',
	'founderemails-email-3-day-editmainpage-button' => 'Spruce It Up',
	'founderemails-email-3-day-addphotos-heading' => 'Add even more photos.',
	'founderemails-email-3-day-addphotos-content' => 'One of the best ways to make your pages snap, crackle, and pop is to <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"add some photos"</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Add Photos',
	'founderemails-email-3-day-explore-heading' => 'Find inspiration.',
	'founderemails-email-3-day-explore-content' => 'Don\'t be afraid to check out other wikis to see how they\'ve worked out their main page, articles pages and more.  Here are some of our favorites: <a style="color:#2a87d5;text-decoration:none;" href="http://muppets.wikia.com">Muppet Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://poptarts.wikia.com">Pop Tarts Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://monsterhigh.wikia.com">Monster High Wiki</a>.',
	'founderemails-email-3-day-explore-button' => 'Explore',
	'founderemails-email-3-day-wikiahelps-text' => 'Need help figuring out how something works?  We\'re always here for you!  Come ask us for help and advice at <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Keep up the great work!<br />The Wikia Team',
// day 10
	'founderemails-email-10-day-heading' => 'How\'s it going $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Whoa, time flies!  It\'s already been 10 days since you started $HDWIKINAME.',
	'founderemails-email-10-day-tips-heading' => 'Get others involved in your project and show off all the awesome work you\'ve been doing!  Here are some ways to spread the word:',
	'founderemails-email-10-day-share-heading' => 'Didn\'t your mother tell you to Share?',
	'founderemails-email-10-day-share-content' => 'Use the Facebook Like button on your wiki\'s main page, article pages and photos to show them off to your friends and followers on Facebook.',
	'founderemails-email-10-day-email-heading' => 'Harness the power of email.',
	'founderemails-email-10-day-email-content' => 'Email others you know who are interested in your topic or interested in helping you, like a friend from school or a co-worker.  You can also email specific photos from your wiki using the email button',
	'founderemails-email-10-day-join-heading' => 'Join up with similar websites.',
	'founderemails-email-10-day-join-content' => 'Ask people on other forums or websites that are about your topic for help by posting in their forums or comments.  If possible, contact the administrator and see if they\'re interested in link-sharing &mdash; they\'ll put your wiki link on their website if you put their link on your wiki.',
	'founderemails-email-10-day-wikiahelps-text' => 'You can also ask other Wikians to help out on your wiki by posting in the forums on <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Keep up the good work!<br />The Wikia Team',
// views digest
	'founderemails-email-views-digest-subject' => 'Today\'s views on $WIKINAME',
	'founderemails-email-views-digest-body' => 'Hi $FOUNDERNAME,

Today $WIKINAME was viewed by $1 {{PLURAL:$1|person|people}}.

Keep adding new content and promoting your wiki to encourage more people to read, edit and spread the word.

The Wikia Team',
	'founderemails-email-views-digest-greeting' => 'Hi $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Today $WIKINAME was viewed by $1 {{PLURAL:$1|person|people}}.',
	'founderemails-email-views-digest-content' => 'Keep adding new content and promoting your wiki to encourage more people to read, edit and spread the word.',
	'founderemails-email-views-digest-signature' => 'The Wikia Team',
	'founderemails-email-views-digest-button' => 'Add more pages',	
// complete digest
	'founderemails-email-complete-digest-subject' => 'The latest activity on $WIKINAME',
	'founderemails-email-complete-digest-body' => 'Hi $FOUNDERNAME,

It\'s time for your daily dose of activity from $WIKINAME.

$1 {{PLURAL:$1|person|people}} viewed your wiki.

Keep up the great work adding interesting content for people to read!

$2 {{PLURAL:$2|edit was|edits were}} made.

Happy editors make happy wikis. Make sure to thank your editors and check in with them from time to time.

$3 {{PLURAL:$3|person|people}} joined your wiki.

Welcome new people to your wiki with a talk page message.

You can always head over to wiki activity to view all of the exiting changes being made on $WIKINAME. Check in often, as the founder your community looks to you to help guide and run the wiki.

The Wikia Team',
	'founderemails-email-complete-digest-greeting' => 'Hi $FOUNDERNAME,',
	'founderemails-email-complete-digest-headline' => 'It\'s time for your daily dose of activity from $WIKINAME.',
	'founderemails-email-complete-digest-content-heading1' => '$1 {{PLURAL:$1|person|people}} viewed your wiki.',
	'founderemails-email-complete-digest-content1' => 'Keep up the great work adding interesting content for people to read!',
	'founderemails-email-complete-digest-content-heading2' => '$1 {{PLURAL:$1|edit was|edits were}} made.',
	'founderemails-email-complete-digest-content2' => 'Happy editors make happy wikis. Make sure to thank your editors and check in with them from time to time.',
	'founderemails-email-complete-digest-content-heading3' => '$1 {{PLURAL:$1|person|people}} joined your wiki.',
	'founderemails-email-complete-digest-content3' => 'Welcome new people to your wiki with a talk page message.
<br><br>
You can always head over to wiki activity to view all of the exiting changes being made on $WIKINAME. Check in often, as the founder your community looks to you to help guide and run the wiki.',
	'founderemails-email-complete-digest-signature' => 'The Wikia Team',
	'founderemails-email-complete-digest-button' => 'Go to wiki activity',
// founder emails preferences
	'founderemails-pref-joins' => 'Email me when someone joins $1',
	'founderemails-pref-edits' => 'Email me when someone edits $1',
	'founderemails-pref-views-digest' => 'Send me a daily email telling me how many times $1 was viewed',
	'founderemails-pref-complete-digest' => 'Send me a daily digest of activity on $1',
);

/** Message documentation (Message documentation)
 * @author McDutchie
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'founderemails-desc' => '{{desc}}',
	'founderemails-email-views-digest-subject' => '"views" means site views/visits.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'founderemails-email-3-day-heading' => 'Hallo $FOUNDERNAME!',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'founderemails-email-0-days-passed-body' => 'Поздравления за създаването на $WIKINAME - вече сте част от общността на Wikia!

-- Екипът на Wikia',
	'founderemails-email-0-day-addpages-button' => 'Добавяне на страница',
	'founderemails-email-0-day-addphotos-heading' => 'Добавяне на снимки.',
	'founderemails-email-0-day-addphotos-button' => 'Добавяне на снимка',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'founderemails-desc' => 'Skoazellañ a ra da gelaouiñ ar grouerien pa vez degaset kemmoù en o wikioù',
	'tog-founderemailsenabled' => 'Kas din hizivadennoù eus ar pezh a ra an dud all (diazezerien hepken)',
	'founderemails-email-user-registered-subject' => 'Unan bennak en deus krouet ur gont war ho wiki !',
	'founderemails-email-user-registered-body' => 'Ac\'hanta $FOUNDERNAME,

Evit doare eo bet an implijer $USERNAME oc\'h en em enrollañ war ho wiki ! Perak ned afec\'h ket da saludi anezhañ war e bajenn kaozeal $USERTALKPAGEURL ?

-- Skipailh Wikia',
	'founderemails-email-user-registered-greeting' => 'Ac\'hanta $FOUNDERNAME,',
	'founderemails-email-user-registered-signature' => 'Skipailh Wikia',
	'founderemails-email-user-registered-button' => 'Degemerit anezho',
	'founderemails-email-user-registered-body-HTML' => 'Ac\'hanta $FOUNDERNAME,<br /><br />
Evit doare eo bet an implijer $USERNAME oc\'h en em enrollañ war ho wiki ! Perak ned afec\'h ket da saludi anezhañ war <a href="$USERTALKPAGEURL">e bajenn kaozeal</a> ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-email-0-days-passed-subject' => "Deuet mat oc'h war Wikia !",
	'founderemails-email-0-days-passed-body' => "Gourc'hemennoù evit bezañ krouet \$WIKINAME - e kumuniezh Wikia emaoc'h bremañ !

-- Skipailh Wikia",
	'founderemails-email-0-days-passed-body-HTML' => 'Gourc\'hemennoù evit bezañ krouet <strong>$WIKINAME</strong> - er gumuniezh Wkia emaoc\'h bremañ !<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Enrolladenn',
	'founderemails-email-3-days-passed-body' => "Ac'hanta \$FOUNDERNAME,

Bremañ hoc'h eus tremenet un nebeut devezhioù en ho wiki, e soñjomp ho pefe c'hoant teurel ur sell war traoù all a c'hellfec'h ober.

-- Skipailh Wikia",
	'founderemails-email-3-days-passed-body-HTML' => "Ac'hanta \$FOUNDERNAME,<br /><br />
Bremañ hoc'h eus tremenet un nebeut devezhioù en ho wiki, e soñjomp ho pefe c'hoant teurel ur sell war traoù all a c'hellfec'h ober.<br /><br />
<div style=\"font-style: italic; font-size: 120%;\">-- Skipailh Wikia</div>",
	'founderemails-email-10-days-passed-subject' => "Penaos 'mañ kont gant ho wiki ?",
	'founderemails-email-10-days-passed-body' => "Ac'hanta \$FOUNDERNAME,

Kroget hoc'h eus gant ur wiki war Wikia ur prantadig 'zo bremañ - spi hon eus e tremen mat pep tra ! C'hoant hon defe rannañ ganeoc'h un nebeut finesaoù a-benn sikour ac'hanoc'h da vezañ en ho aes en ho wiki, evel er gêr.

-- Skipailh Wikia",
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Ur c\'hemm nevez a zo war $WIKINAME !',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Ac\'hanta $FOUNDERNAME,

Evit doare eo bet kemmet evit ar wech kentañ ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da saludiñ anezhañ war e bajenn kaozeal ($USERTALKPAGEURL) ?

-- Skipailh Wikia',
	'founderemails-email-first-edit-greeting' => 'Ac\'hanta $FOUNDERNAME,',
	'founderemails-email-first-edit-signature' => 'Skipailh Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Ac\'hanta $FOUNDERNAME,<br /><br />
Evit doare eo bet kemmet evit ar wech kentañ ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da saludiñ anezhañ war <a href="$USERTALKPAGEURL">e bajenn kaozeal</a> ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Ur c\'hemm nevez a zo war $WIKINAME !',
	'founderemails-email-page-edited-reg-user-body' => 'Salud deoc\'h, $FOUNDERNAME !

Evit doare eo bet kemmet ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da saludiñ anezhañ war e bajenn kaozeal ?

-- Skipailh Wikia',
	'founderemails-email-general-edit-greeting' => 'Ac\'hanta $FOUNDERNAME,',
	'founderemails-email-general-edit-signature' => 'Skipailh Wikia',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Ac\'hanta, $FOUNDERNAME,<br /><br />
Evit doare eo bet kemmet ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da saludiñ anezhañ war <a href="$USERTALKPAGEURL">e bajenn kaozeal</a> ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-email-page-edited-anon-subject' => 'Ur mignon dianv en deus kemmet $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Ac\'hanta $FOUNDERNAME,

Evit doare eo bet kemmet ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da welet war $MYHOMEURL ar pezh zo kemmet ?

-- Skipailh Wikia',
	'founderemails-email-anon-edit-greeting' => 'Ac\'hanta $FOUNDERNAME,',
	'founderemails-email-anon-edit-signature' => 'Skipailh Wikia',
	'founderemails-email-page-edited-anon-body-HTML' => 'Ac\'hanta $FOUNDERNAME,
Evit doare eo bet kemmet ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket <a href="$MYHOMEURL">da welet ar pezh zo kemmet</a> ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-answers-email-user-registered-subject' => 'Unan bennak en deus krouet ur gont war ho wiki G&R !',
	'founderemails-answers-email-user-registered-body' => 'Ac\'hanta $FOUNDERNAME,

Evit doare eo bet an implijer $USERNAME oc\'h en em enrollañ war ho wiki ! Perak ned afec\'h ket da saludi anezhañ war e bajenn kaozeal $USERTALKPAGEURL ?

-- Skipailh Wikia',
	'founderemails-answers-email-user-registered-body-HTML' => 'Ac\'hanta $FOUNDERNAME,<br /><br />
Evit doare eo bet an implijer $USERNAME oc\'h en em enrollañ war ho wiki ! Perak ned afec\'h ket da saludi anezhañ war <a href="$USERTALKPAGEURL">e bajenn kaozeal</a> ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-answers-email-0-days-passed-subject' => "Deuet mat oc'h war G&R Wikia !",
	'founderemails-answers-email-0-days-passed-body' => "Gourc'hemennoù evit bezañ krouet \$WIKINAME - Ezel eus ar gumuniezh Wikia oc'h bremañ !

-- Skipailh Wikia",
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Gourc\'hemennoù evit bezañ krouet <strong>$WIKINAME</strong> - er gumuniezh Wkia emaoc\'h bremañ !<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Enrolladur',
	'founderemails-answers-email-3-days-passed-body' => "Ac'hanta \$FOUNDERNAME,

Bremañ hoc'h eus tremenet un nebeut devezhioù en ho wiki, e soñjomp ho pefe c'hoant teurel ur sell war traoù all a c'hellfec'h ober.

-- Skipailh Wikia",
	'founderemails-answers-email-3-days-passed-body-HTML' => "Ac'hanta \$FOUNDERNAME,<br /><br />
Bremañ hoc'h eus tremenet un nebeut devezhioù en ho wiki, e soñjomp ho pefe c'hoant teurel ur sell war traoù all a c'hellfec'h ober.<br /><br />
<div style=\"font-style: italic; font-size: 120%;\">-- Skipailh Wikia</div>",
	'founderemails-answers-email-10-days-passed-subject' => 'Penaos emañ an traoù gant ho wiki ?',
	'founderemails-answers-email-10-days-passed-body' => "Ac'hanta \$FOUNDERNAME,

Kroget hoc'h eus gant Wikia ur prantadig 'zo bremañ, spi hon eus e tremen mat pep tra ! C'hoant hon defe rannañ ganeoc'h un nebeut finesaoù a-benn sikour ac'hanoc'h da vezañ en ho aes en ho wiki, evel er gêr.

-- Skipailh Wikia",
	'founderemails-answers-email-10-days-passed-body-HTML' => "Ac'hanta \$FOUNDERNAME,<br /><br />
Kroget hoc'h eus gant ur wiki war Wikia ur prantadig 'zo bremañ - spi hon eus e tremen mat pep tra ! C'hoant hon defe rannañ ganeoc'h un nebeut finesaoù a-benn sikour ac'hanoc'h da vezañ en ho aes en ho wiki, evel er gêr.<br /><br />
<div style=\"font-style: italic; font-size: 120%;\">-- Skipailh Wikia</div>",
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => "Evit ar wech kentañ eo bet kemmet ho lec'hienn gant ur implijer enrollet !",
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Ac\'hanta $FOUNDERNAME !

Evit doare eo bet kemmet ho wiki evit ar wech kentañ gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da saludiñ anezhañ war e bajenn kaozeal ($USERTALKPAGEURL) ?

-- Skipailh Wikia',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Ac\'hanta $FOUNDERNAME,<br /><br />
Evit doare eo bet kemmet evit ar wech kentañ ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da saludiñ anezhañ war <a href="$USERTALKPAGEURL">e bajenn kaozeal</a> ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => "Gant un implijer enrollet eo bet kemmet ho lec'hienn !",
	'founderemails-answers-email-page-edited-reg-user-body' => 'Ac\'hanta $FOUNDERNAME,

Evit doare eo bet kemmet ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da saludiñ anezhañ war e bajenn kaozeal ($USERTALKPAGEURL) ?

-- Skipailh Wikia',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Ac\'hanta $FOUNDERNAME,<br /><br />
Evit doare eo bet kemmet ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da saludiñ anezhañ war <a href="$USERTALKPAGEURL">e bajenn kaozeal</a> ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-answers-email-page-edited-anon-subject' => "Unan bennak en deus kemmet ho lec'hienn !",
	'founderemails-answers-email-page-edited-anon-body' => 'Ac\'hanta $FOUNDERNAME,

Evit doare eo bet kemmet ho wiki gant an implijer enrollet $USERNAME ! Perak ned afec\'h ket da welet war $MYHOMEURLe ar pezh zo kemmet ?

-- Ar skipailh Wikia',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Ac\'hanta $FOUNDERNAME,<br /><br />
Seblantout a ra en defe unan bennak kemmet ho wiki ! Perak ne yafec\'h ket <a href="$MYHOMEURL">da welet petra \'zo bet kemmet</a> ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh Wikia</div>',
	'founderemails-lot-happening-subject' => "Un toullad traoù a c'hoarvez war ho lec'hienn hiziv !",
	'founderemails-lot-happening-body' => 'Demat dit $FOUNDERNAME,

Ur bern traoù a c\'hoarvez war ho wiki hiziv ! Kit war $MYHOMEURL da welet penaos emaén kont.

-- Skipailh Wikia',
	'founderemails-lot-happening-body-HTML' => 'Demat dit $FOUNDERNAME,<br /><br />
Ur bern traoù a c\'hoarvez war ho wiki hiziv ! Kit war $MYHOMEURL da welet penaos emañ kont.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Skipailh wikia</div>',
	'founderemails-email-lot-happening-greeting' => 'Ac\'hanta $FOUNDERNAME,',
	'founderemails-email-lot-happening-signature' => 'Skipailh Wikia',
	'founderemails-email-footer-line1' => 'Evit gwelet darvoudoù ziwezhañ Wikia, kit war <a style="color:#2a87d5;text-decoration:none;" href="http://communaute.wikia.com">communaute.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Ha c\'hoant hoc\'h eus merañ ar posteloù a resevit ? Kit \'ta amañ : <a href="$WIKIURL/wiki/Special:Preferences" style="color:#2a87d5;text-decoration:none;">$WIKIURL/wiki/Special:Preferences</a>',
	'founderemails-email-0-day-heading' => "Ur blijadur eo anavezout ac'hanoc'h \$FOUNDERNAME,",
	'founderemails-email-0-day-congratulations' => 'Gourc’hemennoù evit krouidigezh $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => "Setu un nebeut kuzulioù talvoudus evit sikour ac'hanoc'h da gregiñ e-barzh :",
	'founderemails-email-0-day-addpages-heading' => 'Ouzhpennañ pajennoù.',
	'founderemails-email-0-day-addpages-button' => 'Ouzhpennañ ur bajenn',
	'founderemails-email-0-day-addphotos-heading' => 'Ouzhpennañ skeudennoù.',
	'founderemails-email-0-day-addphotos-button' => 'Ouzhpennañ ur skeudenn',
	'founderemails-email-0-day-customizetheme-heading' => 'Personelaat ho todenn.',
	'founderemails-email-0-day-customizetheme-button' => 'Personelaat',
	'founderemails-email-0-day-wikiahelps-signature' => "Plijadur deoc'h evit sevel ho wiki !<br />Skipailh Wikia",
	'founderemails-email-3-day-heading' => 'Demat dit $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'C\'hoant hon doa da dremen ha gwelet penaos emañ an traoù o vont war $WIKINAME.',
	'founderemails-email-3-day-addphotos-heading' => "Ouzhpennañ muioc'h c'hoazh a skeudennoù.",
	'founderemails-email-3-day-addphotos-button' => 'Ouzhpennañ skeudennoù',
	'founderemails-email-3-day-explore-heading' => 'Kavout awen.',
	'founderemails-email-3-day-explore-button' => 'Ergerzhout',
	'founderemails-email-3-day-wikiahelps-signature' => "Kendalc'hit gant ho labour dispar !<br />Skipailh Wikia",
	'founderemails-email-10-day-heading' => 'Penaos \'mañ kont $FOUNDERNAME ?',
	'founderemails-email-views-digest-greeting' => 'Ac\'hanta $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Hiziv eo bet gweladennet $WIKINAME gant $UNIQUEVIEWS den.',
	'founderemails-email-views-digest-signature' => 'Skipailh Wikia',
	'founderemails-email-views-digest-button' => "Ouzhpennañ muioc'h a bajennoù",
	'founderemails-email-complete-digest-subject' => 'An obererezh nevesañ war $WIKINAME',
	'founderemails-email-complete-digest-greeting' => 'Ac\'hanta $FOUNDERNAME,',
	'founderemails-email-complete-digest-content-heading1' => '$UNIQUEVIEWS den o deus gweladennet ho wiki.',
	'founderemails-email-complete-digest-content-heading2' => '$USEREDITS kemm a zo bet graet.',
	'founderemails-email-complete-digest-signature' => 'Skipailh Wikia',
	'founderemails-pref-edits' => 'Kas ur postel din pa vez kemmet $1 gant unan bennak',
	'founderemails-pref-views-digest' => 'Kas din ur postel bemdez evit lavaret din pet gwech eo bet gweladennet $1',
);

/** German (Deutsch)
 * @author Claudia Hattitten
 * @author George Animal
 * @author Inkowik
 * @author Jan Luca
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de'] = array(
	'founderemails-desc' => 'Hilft Gründer über Änderungen in ihrem Wiki zu informieren',
	'tog-founderemailsenabled' => 'Maile mir Berichte über Tätigkeiten anderer Leute (nur Gründer)',
	'founderemails-email-user-registered-subject' => 'Jemand hat einen Account auf deinem Wiki $WIKINAME registriert!',
	'founderemails-email-user-registered-body' => 'Hey $FOUNDERNAME,

Herzlichen Glückwunsch! $USERNAME ist gerade $WIKINAME beigetreten.

Nutze die Gelegenheit um sie in deinem Wiki zu begrüßen und ermutigen sie beim bearbeiten zu helfen. Je mehr desto besser, und umso schneller wird dein Wiki wachsen.

Das Wikia Team',
	'founderemails-email-user-registered-greeting' => 'Hey $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Herzlichen Glückwunsch! $USERNAME ist gerade $WIKINAME beigetreten.',
	'founderemails-email-user-registered-content' => 'Nutze die Gelegenheit um sie in deinem Wiki zu begrüßen und ermutigen sie beim bearbeiten zu helfen. Je mehr desto besser, und umso schneller wird dein Wiki wachsen.',
	'founderemails-email-user-registered-signature' => 'Das Wikia Team',
	'founderemails-email-user-registered-button' => 'Begrüße sie',
	'founderemails-email-user-registered-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es sieht so aus als ob sich $USERNAME bei deinem Wiki registriert hat! Warum besuchst du nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-0-days-passed-subject' => 'Willkommen bei Wikia!',
	'founderemails-email-0-days-passed-body' => 'Herzlichen Glückwunsch zum Erstellen von $WIKINAME - du bist nun Teil der Wikia-Gemeinschaft!

-- Das Wikia Team',
	'founderemails-email-0-days-passed-body-HTML' => 'Herzlichen Glückwunsch zum Erstellen von <strong>$WIKINAME</strong> - du bist nun Teil der Wikia-Gemeinschaft!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-3-days-passed-subject' => 'Ausprobieren',
	'founderemails-email-3-days-passed-body' => 'Hey $FOUNDERNAME,

Jetzt, wo du schon ein paar Tage in deinem Wiki registriert bist, dachten wir du möchtest vielleicht mal ein paar andere Dinge die du tun kannst ausprobieren.

-- Das Wikia Team',
	'founderemails-email-3-days-passed-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Jetzt, wo du schon ein paar Tage in deinem Wiki registriert bist, dachten wir du möchtest vielleicht mal ein paar andere Dinge die du tun kannst ausprobieren.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-10-days-passed-subject' => "Wie geht's voran mit deinem Wiki?",
	'founderemails-email-10-days-passed-body' => 'Hey $FOUNDERNAME,

Es ist nun eine Weile her seit du mit deinem Wiki auf Wikia angefangen hast - wir hoffen es läuft gut! Wir möchten zum Abschluss ein paar kleine Leckerbissen mit dir teilen, damit du dich in deinem Wiki noch mehr wie zu Hause fühlen kannst.

-- Das Wikia Team',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME hat eine neue Bearbeitung!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Hey $FOUNDERNAME,

Alles klar! $USERNAME hat gerade zum ersten Mal $WIKINAME bearbeitet.

Besuche $PAGETITLE um zu sehen, was verändert wurde.

Das Wikia Team',
	'founderemails-email-first-edit-greeting' => 'Hey $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => 'Alles klar! $USERNAME hat gerade zum ersten Mal $WIKINAME bearbeitet.',
	'founderemails-email-first-edit-content' => 'Besuche $PAGETITLE um zu sehen, was verändert wurde.',
	'founderemails-email-first-edit-signature' => 'Das Wikia Team',
	'founderemails-email-first-edit-button' => 'Nachsehen!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es sieht so aus als ob der registrierte Benutzer $USERNAME zum ersten Mal dein Wiki verändert hat! Warum besuchst du nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Neue Bearbeitung bei $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Hey $FOUNDERNAME,

$USERNAME hat gerade nochmal $PAGETITLE im $WIKINAME bearbeitet.

Besuche $PAGETITLE um zu sehen, was verändert wurde.

Das Wikia Team',
	'founderemails-email-general-edit-greeting' => 'Hey $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => '$USERNAME hat gerade nochmal $PAGETITLE im $WIKINAME bearbeitet.',
	'founderemails-email-general-edit-content' => 'Besuche $PAGETITLE um zu sehen, was verändert wurde.',
	'founderemails-email-general-edit-signature' => 'Das Wikia Team',
	'founderemails-email-general-edit-button' => 'Nachsehen!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es sieht so aus als ob der registrierte Benutzer $USERNAME dein Wiki verändert hat! Warum besuchst du nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-page-edited-anon-subject' => 'Ein mysteriöser Freund hat $WIKINAME bearbeitet',
	'founderemails-email-page-edited-anon-body' => 'Hey $FOUNDERNAME,

Ein Wikia Nutzer hat gerade $PAGETITLE im $WIKINAME bearbeitet.

Wikia Nutzer sind Leute, die Bearbeitungen machen, ohne sich in einen Wikia Account einzuloggen. Sieh nach, was dieser mysteriöse Freund hinzugefügt hat!

Das Wikia Team',
	'founderemails-email-anon-edit-greeting' => 'Hey $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'Ein Wikia Nutzer hat gerade $PAGETITLE im $WIKINAME bearbeitet.',
	'founderemails-email-anon-edit-content' => 'Wikia Nutzer sind Leute, die Bearbeitungen machen, ohne sich in einen Wikia Account einzuloggen. Sieh nach, was dieser mysteriöse Freund hinzugefügt hat!',
	'founderemails-email-anon-edit-signature' => 'Das Wikia Team',
	'founderemails-email-anon-edit-button' => 'Nachsehen!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es sieht so aus als ob jemand dein Wiki verändert hat! Warum <a href="$MYHOMEURL">besuchst</a> du es nicht mal um zu sehen was sich verändert hat?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-user-registered-subject' => 'Jemand hat einen Account auf deinem QA Wiki registriert!',
	'founderemails-answers-email-user-registered-body' => 'Hey $FOUNDERNAME,

Es sieht so aus als ob sich $USERNAME bei deinem Wiki registriert hat! Warum besuchst du nicht seine Diskussionsseite $USERTALKPAGEURL um Hallo zu sagen?

-- Das Wikia Team',
	'founderemails-answers-email-user-registered-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es sieht so aus als ob sich $USERNAME bei deinem Wiki registriert hat! Warum besuchst du nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Willkommen bei QA Wikia!',
	'founderemails-answers-email-0-days-passed-body' => 'Herzlichen Glückwunsch zum Erstellen von $WIKINAME - du bist nun Teil der Wikia-Gemeinschaft!

-- Das Wikia Team',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Herzlichen Glückwunsch zum Erstellen von <strong>$WIKINAME</strong> - du bist nun Teil der Wikia-Gemeinschaft!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Ausprobieren',
	'founderemails-answers-email-3-days-passed-body' => 'Hey $FOUNDERNAME,

Jetzt, wo du schon ein paar Tage in deinem Wiki registriert bist, dachten wir du möchtest vielleicht mal ein paar andere Dinge die du tun kannst ausprobieren.

-- Das Wikia Team',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Jetzt, wo du schon ein paar Tage in deinem Wiki registriert bist, dachten wir du möchtest vielleicht mal ein paar andere Dinge die du tun kannst ausprobieren.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-10-days-passed-subject' => "Wie geht's voran mit deinem Wiki?",
	'founderemails-answers-email-10-days-passed-body' => 'Hey $FOUNDERNAME,

Es ist nun eine Weile her seit du mit deinem Wiki auf Wikia angefangen hast - wir hoffen es läuft gut! Wir möchten zum Abschluss ein paar kleine Leckerbissen mit dir teilen, damit du dich in deinem Wiki noch mehr wie zu Hause fühlen kannst.

-- Das Wikia Team',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es ist nun eine Weile her seit du mit deinem Wiki auf Wikia angefangen hast - wir hoffen es läuft gut! Wir möchten zum Abschluss ein paar kleine Leckerbissen mit dir teilen, damit du dich in deinem Wiki noch mehr wie zu Hause fühlen kannst.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Registrierter Benutzer hat deine Seite zum ersten Mal geändert!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Hey $FOUNDERNAME,

Es sieht so aus als ob der registrierte Benutzer $USERNAME zum ersten Mal dein Wiki verändert hat! Warum besuchst du nicht seine Diskussionsseite $USERTALKPAGEURL um Hallo zu sagen?

-- Das Wikia Team',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es sieht so aus als ob der registrierte Benutzer $USERNAME zum ersten Mal dein Wiki verändert hat! Warum besuchst du nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Registrierter Benutzer hat deine Seite verändert!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Hey $FOUNDERNAME,

Es sieht so aus als ob der registrierte Benutzer $USERNAME dein Wiki verändert hat! Warum besuchst du nicht seine Diskussionsseite $USERTALKPAGEURL um Hallo zu sagen?

-- Das Wikia Team',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es sieht so aus als ob der registrierte Benutzer $USERNAME dein Wiki verändert hat! Warum besuchst du nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Jemand hat deine Seite verändert!',
	'founderemails-answers-email-page-edited-anon-body' => 'Hey $FOUNDERNAME,

Es sieht so aus als ob jemand dein Wiki verändert hat! Warum besuchst du nicht mal $MYHOMEURL um zu sehen was sich verändert hat?

-- Das Wikia Team',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Es sieht so aus als ob jemand dein Wiki verändert hat! Warum <a href="$MYHOMEURL">besuchst</a> du es nicht mal um zu sehen was sich verändert hat?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-lot-happening-subject' => 'Bei $WIKINAME ist heute eine Menge los!',
	'founderemails-lot-happening-body' => 'Hey $FOUNDERNAME,

Glückwunsch! Heute ist viel los bei $WIKINAME!

Wenn du es noch nicht getan hast, kannst du zu den letzten Aktivitäten gehen und nachschauen welche großartige Arbeit verrichtet wurde.

Da so viel los ist, willst du vielleicht auch die E-Mail-Benachrichtigungs-Einstellungen auf Zusammenfassungs-Modus ändern. Im Zusammenfassungs-Modus erhältst du eine Mail, die alle Aktivitäten des Tages im Wiki auflistet.

Das Wikia Team',
	'founderemails-lot-happening-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Eine Menge passiert auf deiner Seite heute! Schau mal auf $MYHOMEURL vorbei, um zu sehen was alles so los war.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-lot-happening-greeting' => 'Hey $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => 'Glückwunsch! Heute ist viel los bei $WIKINAME!',
	'founderemails-email-lot-happening-content' => 'Wenn du es noch nicht getan hast, kannst du zu den letzten Aktivitäten gehen und nachschauen welche großartige Arbeit verrichtet wurde. Da so viel los ist, willst du vielleicht auch die E-Mail-Benachrichtigungs-Einstellungen auf Zusammenfassungs-Modus ändern. Im Zusammenfassungs-Modus erhältst du eine Mail, die alle Aktivitäten des Tages im Wiki auflistet.',
	'founderemails-email-lot-happening-signature' => 'Das Wikia Team',
	'founderemails-email-lot-happening-button' => 'Aktivitäten ansehen',
	'founderemails-email-footer-line1' => 'Um aktuelle Ereignisse in Wikia mitzubekommen, besuche <a style="color:#2a87d5;text-decoration:none;" href="http://de.community.wikia.com">de.community.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Willst du steuern, welche E-Mails du bekommst? Gehe zu deinen [{{fullurl:{{ns:special}}:Preferences}} Einstellungen]',
	'founderemails-email-0-day-heading' => 'Schön, dich zu treffen, $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Herzlichen Glückwunsch zur Erstellung von $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Hier sind ein paar hilfreiche Tipps zum Einstieg:',
	'founderemails-email-0-day-addpages-heading' => 'Seiten hinzufügen',
	'founderemails-email-0-day-addpages-content' => 'In einem Wiki geht es um den Austausch von Informationen zu deinem einzigartigen Thema. Erstelle Seiten, indem du auf <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">"Seite hinzufügen"</a> klickst und weitere Informationen zu deinem Thema hinzufügst.',
	'founderemails-email-0-day-addpages-button' => 'Eine Seite hinzufügen',
	'founderemails-email-0-day-addphotos-heading' => 'Fotos hinzufügen',
	'founderemails-email-0-day-addphotos-content' => 'Seiten sind immer besser, wenn sie etwas Visuelles enthalten! Füge Bilder zu deinen Seiten und deiner Hauptseite hinzu. Du kannst <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"ein Foto hinzufügen"</a>, um ein Foto, eine Foto-Galerie oder eine Diashow hinzuzufügen.',
	'founderemails-email-0-day-addphotos-button' => 'Ein Foto hinzufügen',
	'founderemails-email-0-day-customizetheme-heading' => 'Passe dein Thema an.',
	'founderemails-email-0-day-customizetheme-content' => 'Passe Theme und Logo deines Wikis an um es zu etwas Besonderem zu machen! Verwende den <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Theme-Designer</a>, um eigene Farben zu deinem Wiki hinzufügen und es einzigartig für dein Thema zu gestalten.',
	'founderemails-email-0-day-customizetheme-button' => 'Anpassen',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">Wir lassen dich nicht im Regen stehen.</span> Wir sind da, um dein $WIKINAME Schritt für Schritt auf dem Weg zum Erfolg zu unterstützen. Besuche <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> für Foren, Beratung und Hilfe, oder <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">maile uns</a> deine Fragen!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Viel Spaß beim Aufbau deines Wikis!<br />Das Wikia Team',
	'founderemails-email-3-day-heading' => 'Hey $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Wir wollten bloß mal vorbeischauen und gucken, wie die Dinge bei $WIKINAME laufen.',
	'founderemails-email-3-day-tips-heading' => 'Du hast vor 3 Tagen angefangen und wir dachten, wir geben dir noch ein paar Tipps zum Aufbau deines Wikis:',
	'founderemails-email-3-day-editmainpage-heading' => 'Putz deine Hauptseite heraus.',
	'founderemails-email-3-day-editmainpage-content' => 'Die Hauptseite ist eines der ersten Dinge, die die Leute sehen, wenn sie <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a> besuchen. Mach einen guten ersten Eindruck mit einer ausführlichen Zusammenfassung deines Themas und durch das Hinzufügen einer Slideshow, Galerie oder eines Foto-Sliders.',
	'founderemails-email-3-day-editmainpage-button' => 'Putz Sie Heraus',
	'founderemails-email-3-day-addphotos-heading' => 'Füg noch mehr Fotos hinzu.',
	'founderemails-email-3-day-addphotos-content' => 'Einer der besten Wege, deinen Seiten mehr Pepp und Biss zu verleihen, ist das <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"Hinzufügen von Fotos"</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Fotos hinzufügen',
	'founderemails-email-3-day-explore-heading' => 'Lass dich inspirieren.',
	'founderemails-email-3-day-explore-content' => 'Hab keine Angst dir andere Wikis anzusehen, wie sie ihre Hauptseite, Artikel-Seiten und vieles mehr eingerichtet haben. Hier sind einige unserer Favoriten: <a style="color:#2a87d5;text-decoration:none;" href="http://muppets.wikia.com">Muppet Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://poptarts.wikia.com">Pop Tarts Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://monsterhigh.wikia.com">Monster High Wiki</a>.',
	'founderemails-email-3-day-explore-button' => 'Erkunden',
	'founderemails-email-3-day-wikiahelps-text' => 'Brauchst du Hilfe dabei, zu verstehen, wie etwas funktioniert? Wir sind immer für dich da! Komm und frag nach Hilfe und Beratung unter <a style="color:#2a87d5;text-decoration:none;" href="http://de.community.wikia.com">de.community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Weiter so!<br />Das Wikia Team',
	'founderemails-email-10-day-heading' => 'Wie läuft\'s $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Wahnsinn, wie die Zeit vergeht! Es ist bereits 10 Tage her, dass du mit $WIKINAME begonnnen hast.',
	'founderemails-email-10-day-tips-heading' => 'Hole neue Leute ins Projekt und zeig allen die tolle Arbeit, die du geleistet hast! Hier sind ein paar Möglichkeiten, das Wort zu verbreiten:',
	'founderemails-email-10-day-share-heading' => 'Hat dir deine Mutter nicht gesagt du sollst teilen?',
	'founderemails-email-10-day-share-content' => 'Verwende den Teilen-Button auf Toolbar, Artikelseiten und Fotos um sie Freunden und Anhängern auf Facebook, Twitter oder anderen beliebten Webseiten zu zeigen.',
	'founderemails-email-10-day-email-heading' => 'Nutze die Kraft der E-Mail.',
	'founderemails-email-10-day-email-content' => 'E-Maile anderen die du kennst und die sich für dein Thema interessieren oder dir helfen wollen, wie zum Beispiel einem Freund aus der Schule oder einem Arbeitskollegen. Du kannst mit dem E-Mail-Button auch gezielt Fotos aus deinem Wiki versenden.',
	'founderemails-email-10-day-join-heading' => 'Verbünde dich mit ähnlichen Webseiten.',
	'founderemails-email-10-day-join-content' => 'Bitte Leute in anderen Foren oder auf Webseiten zu deinem Thema um Hilfe, indem du Beiträge im Forum oder Kommentare verfasst. Wenn möglich, wende dich auch an den Administrator und frag, ob Interesse an einem Link-Tausch besteht &mdash; der Link zu deinem Wiki kommt auf ihre Webseite, wenn du den Link zu ihrer Webseite in deinem Wiki einbaust.',
	'founderemails-email-10-day-wikiahelps-text' => 'Du kannst auch andere Wikianer durch Beiträge im Forum unter <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> um Hilfe bitten.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Weiter so!<br />Das Wikia Team',
	'founderemails-email-views-digest-subject' => 'Heutige Seitenaufrufe bei $WIKINAME',
	'founderemails-email-views-digest-body' => 'Hey $FOUNDERNAME,

Heute wurde $WIKINAME von # Besuchern angesehen.

Füge weiterhin neue Inhalte hinzu und werbe für dein Wiki, um noch mehr Leute zu ermutigen darin zu lesen, zu bearbeiten oder es weiterzusagen.

Das Wikia Team',
	'founderemails-email-views-digest-greeting' => 'Hey $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Heute wurde $WIKINAME von $UNIQUEVIEWS Besuchern angesehen.',
	'founderemails-email-views-digest-content' => 'Füge weiterhin neue Inhalte hinzu und werbe für dein Wiki, um noch mehr Leute zu ermutigen darin zu lesen, zu bearbeiten oder es weiterzusagen.',
	'founderemails-email-views-digest-signature' => 'Das Wikia Team',
	'founderemails-email-views-digest-button' => 'Weitere Seiten hinzufügen',
	'founderemails-email-complete-digest-subject' => 'Die letzten Aktivitäten auf $WIKINAME',
	'founderemails-email-complete-digest-body' => 'Hey $FOUNDERNAME,

Zeit für deine tägliche Dosis an Aktivitäten auf $WIKINAME.

$UNIQUEVIEWS Besucher haben dein Wiki angeschaut.

Mach weiter so und füge interessante Inhalte zum Lesen für deine Besucht hinzu!

$USEREDITS Bearbeitungen wurden getätigt.

Glückliche Autoren machen glückliche Wikis. Vergiss nicht, dich mit deinen Autoren ab und zu kurzzuschließen und ihnen zu danken.

$USERJOINS Benutzer sind deinem Wiki beigetreten.

Begrüße neue Benutzer in deinem Wiki mit einer Nachricht auf ihrer Diskussionsseite.

In den letzten Aktivitäten kannst du die ganzen Änderungen in $WIKINAME ständig nachverfolgen. Schau öfters mal vorbei, die Community erwartet von dir als Gründer, dass du ihnen hilfst, sie leitest und das Wiki am Laufen hältst.

Das Wikia Team',
	'founderemails-email-complete-digest-greeting' => 'Hey $FOUNDERNAME,',
	'founderemails-email-complete-digest-headline' => 'Zeit für deine tägliche Dosis an Aktivitäten auf $WIKINAME.',
	'founderemails-email-complete-digest-content-heading1' => '$UNIQUEVIEWS Besucher haben dein Wiki angeschaut.',
	'founderemails-email-complete-digest-content1' => 'Mach weiter so und füge interessante Inhalte zum Lesen für deine Besucht hinzu!',
	'founderemails-email-complete-digest-content-heading2' => '$USEREDITS Bearbeitungen wurden getätigt.',
	'founderemails-email-complete-digest-content2' => 'Glückliche Autoren machen glückliche Wikis. Vergiss nicht, dich mit deinen Autoren ab und zu kurzzuschließen und ihnen zu danken.',
	'founderemails-email-complete-digest-content-heading3' => '$USERJOINS Benutzer sind deinem Wiki beigetreten.',
	'founderemails-email-complete-digest-content3' => 'Begrüße neue Benutzer in deinem Wiki mit einer Nachricht auf ihrer Diskussionsseite.
<br /><br />
In den letzten Aktivitäten kannst du die ganzen Änderungen in $WIKINAME ständig nachverfolgen. Schau öfters mal vorbei, die Community erwartet von dir als Gründer, dass du ihnen hilfst, sie leitest und das Wiki am Laufen hältst.',
	'founderemails-email-complete-digest-signature' => 'Das Wikia Team',
	'founderemails-email-complete-digest-button' => 'Zu den letzten Aktivitäten',
	'founderemails-pref-joins' => 'Sende mir eine E-Mail, wenn jemand $1 beitritt',
	'founderemails-pref-edits' => 'Schicke mir eine E-Mail, wenn jemand $1 bearbeitet.',
	'founderemails-pref-views-digest' => 'Benachrichtige mich per E-Mail über die Zugriffszahlen auf $1',
	'founderemails-pref-complete-digest' => 'Sende mir eine tägliche Zusammenfassung der Aktivitäten auf $1',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author LWChris
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'founderemails-email-user-registered-subject' => 'Jemand hat einen Account auf Ihrem Wiki registriert!',
	'founderemails-email-user-registered-body' => 'Hallo $FOUNDERNAME,

Es sieht so aus als ob sich $USERNAME bei Ihrem Wiki registriert hat! Warum besuchen Sie nicht seine Diskussionsseite $USERTALKPAGEURL um Hallo zu sagen?

-- Das Wikia Team',
	'founderemails-email-user-registered-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Es sieht so aus als ob sich $USERNAME bei Ihrem Wiki registriert hat! Warum besuchen Sie nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-0-days-passed-body' => 'Herzlichen Glückwunsch zum Erstellen von $WIKINAME - Sie sind nun Teil der Wikia-Gemeinschaft!

-- Das Wikia Team',
	'founderemails-email-0-days-passed-body-HTML' => 'Herzlichen Glückwunsch zum Erstellen von <strong>$WIKINAME</strong> - Sie sind nun Teil der Wikia-Gemeinschaft!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-3-days-passed-body' => 'Hallo $FOUNDERNAME,

Jetzt, wo Sie schon ein paar Tage in Ihrem Wiki registriert sind, dachten wir Sie möchten vielleicht mal ein paar andere Dinge die Sie machen können ausprobieren.

-- Das Wikia Team',
	'founderemails-email-3-days-passed-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Jetzt, wo Sie schon ein paar Tage in Ihrem Wiki registriert sind, dachten wir Sie möchten vielleicht mal ein paar andere Dinge die Sie machen können ausprobieren.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-10-days-passed-subject' => "Wie geht's voran mit Ihrem Wiki?",
	'founderemails-email-10-days-passed-body' => 'Hallo $FOUNDERNAME,

Es ist nun eine Weile her seit Sie mit Ihrem Wiki auf Wikia angefangen haben - wir hoffen es läuft gut! Wir möchten zum Abschluss ein paar kleine Leckerbissen mit Ihnen teilen, damit Sie sich in Ihrem Wiki noch mehr wie zu Hause fühlen können.

-- Das Wikia Team',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Registrierter Benutzer hat Ihr Wiki zum ersten Mal geändert!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Hallo $FOUNDERNAME,

Es sieht so aus als ob der registrierte Benutzer $USERNAME zum ersten Mal Ihr Wiki verändert hat! Warum besuchen Sie nicht seine Diskussionsseite $USERTALKPAGEURL um Hallo zu sagen?

-- Das Wikia Team',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Es sieht so aus als ob der registrierte Benutzer $USERNAME zum ersten Mal Ihr Wiki verändert hat! Warum besuchen Sie nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Registrierter Benutzer hat Ihr Wiki verändert!',
	'founderemails-email-page-edited-reg-user-body' => 'Hallo $FOUNDERNAME,

Es sieht so aus als ob der registrierte Benutzer $USERNAME Ihr Wiki verändert hat! Warum besuchen Sie nicht seine Diskussionsseite $USERTALKPAGEURL um Hallo zu sagen?

-- Das Wikia Team',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Es sieht so aus als ob der registrierte Benutzer $USERNAME Ihr Wiki verändert hat! Warum besuchen Sie nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-email-page-edited-anon-subject' => 'Jemand hat Ihr Wiki verändert!',
	'founderemails-email-page-edited-anon-body' => 'Hallo $FOUNDERNAME,

Es sieht so aus als ob jemand Ihr Wiki verändert hat! Warum besuchen Sie nicht mal $MYHOMEURL um zu sehen was sich verändert hat?

-- Das Wikia Team',
	'founderemails-email-page-edited-anon-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Es sieht so aus als ob jemand Ihr Wiki verändert hat! Warum <a href="$MYHOMEURL">besuchen</a> Sie es nicht mal um zu sehen was sich verändert hat?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-user-registered-subject' => 'Jemand hat einen Account auf Ihrem QA Wiki registriert!',
	'founderemails-answers-email-user-registered-body' => 'Hallo $FOUNDERNAME,

Es sieht so aus als ob sich $USERNAME bei Ihrem Wiki registriert hat! Warum besuchen Sie nicht seine Diskussionsseite $USERTALKPAGEURL um Hallo zu sagen?

-- Das Wikia Team',
	'founderemails-answers-email-user-registered-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Es sieht so aus als ob sich $USERNAME bei Ihrem Wiki registriert hat! Warum besuchen Sie nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-0-days-passed-body' => 'Herzlichen Glückwunsch zum Erstellen von $WIKINAME - Sie sind nun Teil der Wikia-Gemeinschaft!

-- Das Wikia Team',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Herzlichen Glückwunsch zum Erstellen von <strong>$WIKINAME</strong> - Sie sind nun Teil der Wikia-Gemeinschaft!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-3-days-passed-body' => 'Hallo $FOUNDERNAME,

Jetzt, wo Sie schon ein paar Tage in Ihrem Wiki registriert sind, dachten wir Sie möchten vielleicht mal ein paar andere Dinge die Sie machen können ausprobieren.

-- Das Wikia Team',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Jetzt, wo Sie schon ein paar Tage in Ihrem Wiki registriert sind, dachten wir Sie möchten vielleicht mal ein paar andere Dinge die Sie machen können ausprobieren.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-10-days-passed-subject' => "Wie geht's voran mit Ihrem Wiki?",
	'founderemails-answers-email-10-days-passed-body' => 'Hallo $FOUNDERNAME,

Es ist nun eine Weile her seit Sie mit Ihrem Wiki auf Wikia angefangen haben - wir hoffen es läuft gut! Wir möchten zum Abschluss ein paar kleine Leckerbissen mit Ihnen teilen, damit Sie sich in Ihrem Wiki noch mehr wie zu Hause fühlen können.

-- Das Wikia Team',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Es ist nun eine Weile her seit Sie mit Ihrem Wiki auf Wikia angefangen haben - wir hoffen es läuft gut! Wir möchten zum Abschluss ein paar kleine Leckerbissen mit Ihnen teilen, damit Sie sich in Ihrem Wiki noch mehr wie zu Hause fühlen können.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Registrierter Benutzer hat Ihre Seite zum ersten Mal geändert!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Hallo $FOUNDERNAME,

Es sieht so aus als ob der registrierte Benutzer $USERNAME zum ersten Mal Ihr Wiki verändert hat! Warum besuchen Sie nicht seine Diskussionsseite $USERTALKPAGEURL um Hallo zu sagen?

-- Das Wikia Team',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Es sieht so aus als ob der registrierte Benutzer $USERNAME zum ersten Mal Ihr Wiki verändert hat! Warum besuchen Sie nicht seine <a href="$USERTALKPAGEURL">Diskussionsseite</a> um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Registrierter Benutzer hat Ihre Seite verändert!',
	'founderemails-answers-email-page-edited-anon-subject' => 'Jemand hat Ihre Seite verändert!',
	'founderemails-answers-email-page-edited-anon-body' => 'Hallo $FOUNDERNAME,

Es sieht so aus als ob jemand Ihr Wiki verändert hat! Warum besuchen Sie nicht mal $MYHOMEURL um zu sehen was sich verändert hat?

-- Das Wikia Team',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Es sieht so aus als ob jemand Ihr Wiki verändert hat! Warum <a href="$MYHOMEURL">besuchen</a> Sie es nicht mal um zu sehen was sich verändert hat?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia Team</div>',
);

/** Spanish (Español)
 * @author Absay
 * @author Bola
 * @author Crazymadlover
 * @author VegaDark
 */
$messages['es'] = array(
	'founderemails-desc' => 'Ayuda a informar a los fundadores sobre los cambios que ocurrieron en su wiki',
	'tog-founderemailsenabled' => 'Mandadme por correo electrónico las actualizaciones que hacen otras personas (solamente fundadores)',
	'founderemails-email-user-registered-subject' => 'Alguien nuevo se unió a $WIKINAME',
	'founderemails-email-user-registered-body' => 'Hola $FOUNDERNAME,

¡Felicitaciones! $USERNAME se ha registrado en $WIKINAME.

Aprovecha esta oportunidad para darle la bienvenida y animarlo a que edite el wiki. Cuantos más, mejor y más rápido crecerá tu wiki.

-- El equipo de Wikia',
	'founderemails-email-user-registered-greeting' => 'Hola $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => '¡Felicitaciones! $USERNAME se ha registrado en $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Aprovecha esta oportunidad para darle la bienvenida y animarlo a que edite el wiki. Cuantos más, mejor y más rápido crecerá tu wiki.',
	'founderemails-email-user-registered-signature' => '-- El equipo de Wikia',
	'founderemails-email-user-registered-button' => 'Dale la bienvenida',
	'founderemails-email-user-registered-body-HTML' => 'Ey $FOUNDERNAME,<br /><br />
¡Parece que $USERNAME se ha registrado en tu wiki! ¿Por qué no te pasas por su <a href="$USERTALKPAGEURL">página de discusión</a> para saludarle?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El equipo de Wikia</div>',
	'founderemails-email-0-days-passed-subject' => '¡Bienvenido/a a Wikia!',
	'founderemails-email-0-days-passed-body' => '¡Felicidades por la creación de $WIKINAME - ahora eres parte de la comunidad de Wikia!

-- El equipo de Wikia',
	'founderemails-email-0-days-passed-body-HTML' => '¡Felicidades por la creación de <strong>$WIKINAME</strong> - ahora eres parte de la comunidad de Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El equipo de Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Comprobando',
	'founderemails-email-3-days-passed-body' => 'Ey $FOUNDERNAME,

Ahora que has pasado unos días en tu wiki, pensamos que es posible que quieras comprobar algunas cosas que podrías hacer.

-- El equipo de Wikia',
	'founderemails-email-3-days-passed-body-HTML' => 'Ey $FOUNDERNAME<br /><br />
Ahora que has estado unos días en tu wiki, pensamos que es posible que quieras comprobar unas cuantas cosas que podrías hacer.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El equipo de Wikia</div>',
	'founderemails-email-10-days-passed-subject' => '¿Cómo van las cosas en tu wiki?',
	'founderemails-email-10-days-passed-body' => 'Ey $FOUNDERNAME,

Ha pasado un tiempo desde que abriste un wiki en Wikia - ¡Esperamos que vaya genial! Queríamos compartir contigo unas cuantas cosas para ayudarte a que cuando estés en tu wiki, estés como en casa.

-- El equipo de Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '¡$WIKINAME tiene una nueva edición!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Hola $FOUNDERNAME,

¡Muy bien! $USERNAME acaba de hacer su primera edición en $WIKINAME.

Echa un vistazo a $PAGETITLE para ver lo que añadió.

-- El equipo de Wikia',
	'founderemails-email-first-edit-greeting' => 'Hola $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => '¡Muy bien! $USERNAME acaba de hacer su primera edición en $WIKINAME.',
	'founderemails-email-first-edit-content' => 'Echa un vistazo a $PAGETITLE para ver lo que añadió.',
	'founderemails-email-first-edit-signature' => '-- El equipo de Wikia',
	'founderemails-email-first-edit-button' => '¡Échale un vistazo!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Ey $FOUNDERNAME,<br /><br />
¡Parece que el usuario registrado $USERNAME ha editado tu wiki por primera vez! ¿Por qué no te pasas por su <a href="$USERTALKPAGEURL">página de discusión</a> para saludarle?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El equipo de Wikia</div>',
	'founderemails-email-page-edited-reg-user-subject' => '¡Nueva edición en $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Hola $FOUNDERNAME,

$USERNAME acaba de hacer otra edición a $PAGETITLE en $WIKINAME.

Échale un vistazo a $PAGETITLE para ver lo que ha cambiado.

-- El equipo de Wikia',
	'founderemails-email-general-edit-greeting' => 'Hola $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => '$USERNAME acaba de hacer otra edición a $PAGETITLE en $WIKINAME.',
	'founderemails-email-general-edit-content' => 'Échale un vistazo a $PAGETITLE para ver lo que ha cambiado.',
	'founderemails-email-general-edit-signature' => '-- El equipo de Wikia',
	'founderemails-email-general-edit-button' => '¡Échale un vistazo!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Ey $FOUNDERNAME,<br /><br />
¡Parece que el usuario registrado $USERNAME ha editado en tu wiki! ¿Por qué no te pasas por su <a href="$USERTALKPAGEURL">página de discusión</a> para saludarle?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El equipo de Wikia</div>',
	'founderemails-email-page-edited-anon-subject' => 'Un amigo misterioso editó en $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Hola $FOUNDERNAME,

Un colaborador de Wikia acaba de hacer una edición a $PAGETITLE en $WIKINAME.

Los colaboradores de Wikia son personas que hacen ediciones sin iniciar sesión con una cuenta registrada. ¡Mira lo que este amigo misterioso ha añadido!

-- El equipo de Wikia',
	'founderemails-email-anon-edit-greeting' => 'Hola $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'Un colaborador de Wikia acaba de hacer una edición a $PAGETITLE en $WIKINAME.',
	'founderemails-email-anon-edit-content' => 'Los colaboradores de Wikia son personas que hacen ediciones sin iniciar sesión con una cuenta registrada. ¡Mira lo que este amigo misterioso ha añadido!',
	'founderemails-email-anon-edit-signature' => '-- El equipo de Wikia',
	'founderemails-email-anon-edit-button' => '¡Échale un vistazo!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Ey $FOUNDERNAME,<br /><br />
¡Parece que alguien ha editado en tu wiki! ¿Por qué no <a href="$MYHOMEURL">echas un vistazo</a> para ver qué ha cambiado?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El equipo de Wikia</div>',
	'founderemails-answers-email-user-registered-subject' => 'Alguien registró una cuenta en tu wiki QA!',
	'founderemails-answers-email-user-registered-body' => 'Ey $FOUNDERNAME,

¡Parece que $USERNAME se ha registrado en tu wiki! ¿Por qué no vas a su página de discusión $USERTALKPAGEURL para saludarle?

-- El equipo Wikia',
	'founderemails-answers-email-user-registered-body-HTML' => 'Ey $FOUNDERNAME,<br /><br />
¡Parece que $USERNAME se ha registrado en tu wiki! ¿Por qué no vas a su <a href="$USERTALKPAGEURL">página de discusión</a> para saludarle?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El equipo Wikia</div>',
	'founderemails-answers-email-0-days-passed-subject' => '¡Bienvenido a Wikia QA!',
	'founderemails-answers-email-0-days-passed-body' => '¡Felicitaciones por crear $WIKINAME, ahora eres parte de la comunidad Wikia!

-- El Equipo Wikia',
	'founderemails-answers-email-0-days-passed-body-HTML' => '¡Felicitaciones por crear <strong>$WIKINAME</strong>, ahora eres parte de la comunidad Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El Equipo Wikia</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Comprobando',
	'founderemails-answers-email-3-days-passed-body' => 'Ey $FOUNDERNAME,

Ahora que estás pocos días en tu wiki, pensamos que tal vez desees comprobar algunas cosas que puedes hacer.

-- El Equipo Wikia',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Ey $FOUNDERNAME<br /><br />
Ahora que has estado unos días en tu wiki, pensamos que es posible que quieras comprobar unas cuantas cosas que podrías hacer.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El equipo de Wikia</div>',
	'founderemails-answers-email-10-days-passed-subject' => '¿Cómo van las cosas en tu wiki?',
	'founderemails-answers-email-10-days-passed-body' => 'Hey $FOUNDERNAME,

Ha sido poco desde que empezaste tu wiki en Wikia - esperqamos que te vaya genial! Queríamos compartir unas cuantas cosas más para ayudarte a hacerte sentir en tu wiki más como en casa.

-- El Equipo Wikia',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Ha sido poco desde que empezaste tu wiki en Wikia - esperamos que te vaya genial! Queríamos compartir unas cuantas cosas más para ayudar a sentirte en tu wiki más como en casa.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El Equipo Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Un usuario registrado cambión tu sitio por primera vez!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Hey $FOUNDERNAME,

Parece que el usuario registrado $USERNAME ha editado tu wiki por primera vez! Por qué no vas a su página de discusión  ($USERTALKPAGEURL) y le dices hola?

-- El Eqùipo Wikia',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Parece que el usuario registrado $USERNAME ha editado tu wiki por primera vez! Por qùé no vas a su <a href="$USERTALKPAGEURL">página de discusión</a> y le dices hola?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El Equipo Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Un usuario registrado cambió tu sitio!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Hey $FOUNDERNAME,

Parece que el usuario registrado $USERNAME ha editado tu wiki! Porqué no vas a su página de discusión ($USERTALKPAGEURL) y le dices hola?

-- El Equipo Wikia',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Parece que el usuario registrado $USERNAME ha editado tu wiki! Por qué no vas a su <a href="$USERTALKPAGEURL">Página de discusión</a> y le dices hola?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El Equipo Wikia</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Alguien cambió tu sitio!',
	'founderemails-answers-email-page-edited-anon-body' => 'Hey $FOUNDERNAME,

Parece que alguien ha editado tu wiki! Por qué no verificas $MYHOMEURL para ver que cambió?

-- El Equipo Wikia',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Parece que alguien ha editado tu wiki! Por qué no <a href="$MYHOMEURL">verificas</a> para ver que cambió?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El Equipo Wikia</div>',
	'founderemails-lot-happening-subject' => '¡Han ocurrido muchas cosas en $WIKINAME!',
	'founderemails-lot-happening-body' => 'Hola $FOUNDERNAME,

¡Felicitaciones! ¡Hay muchas cosas ocurriendo hoy en $WIKINAME!

Si no te has dado cuenta, puedes ir a Wiki Actividad y ver todo en gran trabajo que ha estado ocurriendo.

Dado que hay mucha actividad, quizás quieras cambiar tus preferencias del correo en modo de digesto. Con el modo de digesto, solamente recibirás un correo electrónico con una lista de toda la actividad diaria de tu wiki.

-- El Equipo de Wikia',
	'founderemails-lot-happening-body-HTML' => 'Hola &FOUNDERNAME,<br /><br />
¡Hay muchas cosas sucediendo hoy en tu wiki! Pasa por $MYHOMEURL para ver lo que ha estado pasando.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- El Equipo de Wikia</div>',
	'founderemails-email-lot-happening-greeting' => 'Hola $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => '¡Felicitaciones! ¡Hay muchas cosas ocurriendo hoy en $WIKINAME!',
	'founderemails-email-lot-happening-content' => 'Si no te has dado cuenta, puedes ir a Wiki Actividad y ver todo en gran trabajo que ha estado ocurriendo. Dado que hay mucha actividad, quizás quieras cambiar tus preferencias del correo en modo de digesto. Con el modo de digesto, solamente recibirás un correo electrónico con una lista de toda la actividad diaria de tu wiki.',
	'founderemails-email-lot-happening-signature' => '-- El Equipo de Wikia',
	'founderemails-email-lot-happening-button' => 'Ver las actividades',
	'founderemails-email-footer-line1' => 'Para ver las últimas noticias en Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'founderemails-email-footer-line2' => '¿Quieres controlar los correos electrónicos que recibes? Ve a tus [{{fullurl:{{ns:special}}:Preferences}} Preferencias]',
	'founderemails-email-0-day-heading' => 'Encantado de conocerte $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => '¡Felicitaciones por crear $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Aquí hay algunos consejos útiles para comenzar:',
	'founderemails-email-0-day-addpages-heading' => 'Añadir páginas.',
	'founderemails-email-0-day-addpages-content' => 'Una wiki es todo acerca de compartir información sobre tu tema. Crea páginas haciendo clic en <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">"Añadir una Página"</a> y llena más información específica sobre el tema.',
	'founderemails-email-0-day-addpages-button' => 'Añadir una Página',
	'founderemails-email-0-day-addphotos-heading' => 'Añadir imágenes.',
	'founderemails-email-0-day-addphotos-content' => '¡Las páginas siempre son mejores cuando tienen imágenes! Añade imágenes a tus páginas y a tu página principal. Puedes hacer clic en <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"Añadir una Imagen"</a> para añadir una imagen, una galería de imágenes o una secuencia de diapositivas.',
	'founderemails-email-0-day-addphotos-button' => 'Añadir una Imagen',
	'founderemails-email-0-day-customizetheme-heading' => 'Personaliza tu tema.',
	'founderemails-email-0-day-customizetheme-content' => '¡Personaliza el tema y el wordmark para destacar tu wiki! Usa el <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Diseñador de Temas</a> para añadir colores personalizados a tu wiki y hacerla única a tu tema.',
	'founderemails-email-0-day-customizetheme-button' => 'Personalizar',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">No te dejaremos a la interperie.</span> Estamos aquí para ayudarte con $WIKINAME en cada paso. Visita <a style="color:#2a87d5;text-decoration:none;" href="http://es.wikia.com">es.wikia.com</a> por foros, consejos y ayuda, o <a style="color:#2a87d5;text-decoration:none;" href="http://es.wikia.com/wiki/Special:Contact">contáctanos</a> si tienes preguntas.',
	'founderemails-email-0-day-wikiahelps-signature' => '¡Feliz construcción de tu wiki!<br />El Equipo de Wikia',
	'founderemails-email-3-day-heading' => 'Hola, $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Hemos querido revisar y ver cómo van las cosas en $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Han pasado tres días desde que comenzaste y pensamos que podríamos ofrecer algunos más consejos para la construcción de tu wiki:',
	'founderemails-email-3-day-editmainpage-heading' => 'Adorna tu página principal.',
	'founderemails-email-3-day-editmainpage-content' => 'La página principal es una de las primeras cosas que las personas ven cuando visitan <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>. Haz una buena impresión al escribir un resumen detallado sobre lo que trata tu tema y agrega una presentación de diapositivas, una galería o una presentación de imágenes.',
	'founderemails-email-3-day-editmainpage-button' => 'Hazla atractiva',
	'founderemails-email-3-day-addphotos-heading' => 'Añadir más imágenes.',
	'founderemails-email-3-day-addphotos-content' => 'Una de las mejores formas de complementar tus páginas es <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"añadiendo algunas imágenes"</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Añadir imágenes',
	'founderemails-email-3-day-explore-heading' => 'Encuentra inspiración.',
	'founderemails-email-3-day-explore-content' => 'No tengas miedo en visitar otras wikis para ver cómo han trabajado sus páginas principales, artículos y más. Aquí hay algunas de nuestras favoritas: <a style="color:#2a87d5;text-decoration:none;" href="http://es.memory-alpha.org">Memory Alpha</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://es.ben10.wikia.com">Ben 10</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://es.gta.wikia.com">Grand Theft Encyclopedia</a>.',
	'founderemails-email-3-day-explore-button' => 'Explorar',
	'founderemails-email-3-day-wikiahelps-text' => '¿Necesitas ayuda para saber cómo funciona algo? ¡Siempre estamos aquí para ti! Pregúntanos por ayuda y consejo en <a style="color:#2a87d5;text-decoration:none;" href="http://es.wikia.com">es.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => '¡Mantén el gran trabajo!<br />El Equipo de Wikia',
	'founderemails-email-10-day-heading' => '¿Cómo vas, $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => '¡Wow, el tiempo vuela! Han pasado 10 días desde que comenzaste $WIKINAME.',
	'founderemails-email-10-day-tips-heading' => '¡Involucra a otros en tu proyecto y muestra todo el gran trabajo que has estado haciendo! Aquí hay algunas formas de difundirlo:',
	'founderemails-email-10-day-share-heading' => '¿Tu madre no te dijo compartir?',
	'founderemails-email-10-day-share-content' => 'Usa el botón Compartir en tu barra de herramientas, artículos e imágenes para mostrárselas a tus amigos y seguidores en Twitter, Facebook u otros sitios populares.',
	'founderemails-email-10-day-email-heading' => 'Aprovecha el poder del correo electrónico.',
	'founderemails-email-10-day-email-content' => 'Envía mensajes de correo electrónico a otros que conozcan y estén interesados en tu wiki o interesados en ayudarte, como un amigo de la escuela o un compañero de trabajo. Además puedes enviar imágenes específicas de tu wiki usando el botón de correo electrónico.',
	'founderemails-email-10-day-join-heading' => 'Únete con sitios web similares.',
	'founderemails-email-10-day-join-content' => 'Pregunta a las personas en otros foros o sitios web relacionados con tu tema en busca de ayuda. Si es posible, contacta al administrador y ver si están interesandos en hacer un intercambio de enlace &mdash; ellos pondrían tu enlace a la wiki en su sitio web si tú pones su enlace en tu wiki.',
	'founderemails-email-10-day-wikiahelps-text' => 'También puedes preguntar a otros usuarios en busca de ayuda para tu wiki dejando una publicación en los foros de <a style="color:#2a87d5;text-decoration:none;" href="http://es.wikia.com">es.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => '¡Mantén el gran trabajo!<br />El Equipo de Wikia',
	'founderemails-email-views-digest-subject' => 'Visitas de hoy en $WIKINAME',
	'founderemails-email-views-digest-body' => 'Hola $FOUNDERNAME,

Hoy $WIKINAME fue visitada por # personas.

Mantente añadiendo contenido nuevo y promoviendo tu wiki para animar a más personas a leer, editar y correr la voz.

-- El Equipo de Wikia',
	'founderemails-email-views-digest-greeting' => 'Hola $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Hoy $WIKINAME fue visitada por $UNIQUEVIEWS personas.',
	'founderemails-email-views-digest-content' => 'Mantente añadiendo contenido nuevo y promoviendo tu wiki para animar a más personas a leer, editar y correr la voz.',
	'founderemails-email-views-digest-signature' => '-- El Equipo de Wikia',
	'founderemails-email-views-digest-button' => 'Añade más páginas',
	'founderemails-email-complete-digest-subject' => 'Actividad más reciente en $WIKINAME',
	'founderemails-email-complete-digest-body' => 'Hola $FOUNDERNAME,

Es momento de tu dosis diaria de la actividad en $WIKINAME.

$UNIQUEVIEWS visitaron tu wiki.

¡Mantén el gran trabajo añadiendo contenido interesante para que las personas lo lean!

$USEREDITS ediciones fueron realizadas.

Editores felices hacen feliz al wiki. Asegúrate de agradecer a tus editores y comunícate con ellos de vez en cuando.

$USERJOINS usuarios se unieron al wiki.

Dale la bienvenida a los usuarios nuevos con un mensaje en sus páginas de discusión.

Siempre puedes echarle un vistazo a la Wiki Actividad para ver todos los cambios existentes hechos en $WIKINAME. Revísalos frecuentemente, como fundador, la comunidad buscará tu orientación.

-- El Equipo de Wikia',
	'founderemails-email-complete-digest-greeting' => 'Hola $FOUNDERNAME,',
	'founderemails-email-complete-digest-headline' => 'Es momento de tu dosis diaria de la actividad en $WIKINAME.',
	'founderemails-email-complete-digest-content-heading1' => '$UNIQUEVIEWS visitaron tu wiki.',
	'founderemails-email-complete-digest-content1' => '¡Mantén el gran trabajo añadiendo contenido interesante para que las personas lo lean!',
	'founderemails-email-complete-digest-content-heading2' => '$USEREDITS ediciones fueron realizadas.',
	'founderemails-email-complete-digest-content2' => 'Editores felices hacen feliz al wiki. Asegúrate de agradecer a tus editores y comunícate con ellos de vez en cuando.',
	'founderemails-email-complete-digest-content-heading3' => '$USERJOINS usuarios se unieron al wiki.',
	'founderemails-email-complete-digest-content3' => 'Dale la bienvenida a los usuarios nuevos con un mensaje en sus páginas de discusión.
<br /><br />
Siempre puedes echarle un vistazo a la Wiki Actividad para ver todos los cambios existentes hechos en $WIKINAME. Revísalos frecuentemente, como fundador, la comunidad buscará tu orientación.',
	'founderemails-email-complete-digest-signature' => '-- El Equipo de Wikia',
	'founderemails-email-complete-digest-button' => 'Ir a la Wiki Actividad',
	'founderemails-pref-joins' => 'Enviarme un correo electrónico cuando alguien se une a $1',
	'founderemails-pref-edits' => 'Enviarme un correo cuando alguien edita $1',
	'founderemails-pref-views-digest' => 'Enviarme un correo electrónico diario de cuántas veces $1 ha sido visitada',
	'founderemails-pref-complete-digest' => 'Enviarme un digesto diario de la actividad en $1',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Tofu II
 */
$messages['fi'] = array(
	'founderemails-email-user-registered-body' => 'Hei $FOUNDERNAME,

Näyttää siltä, että $USERNAME on rekisteröitynyt wikiisi! Miksi et sano hänen keskustelusivullaan $USERTALKPAGEURL hei?

-- The Wikia Team',
	'founderemails-email-page-edited-reg-user-body' => 'Hei $FOUNDERNAME,

Näyttää siltä, että rekisteröitynyt käyttäjä $USERNAME on muokannut wikiäsi! Miksi et sano hänelle ($USERTALKPAGEURL) hei?

-- The Wikia Team',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Näyttää siltä, että rekisteröitynyt käyttäjä $USERNAME on muokannut wikiäsi! Miksi et sano hänen <a href="$USERTALKPAGEURL">keskustelusivullaan</a> hei?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Hei $FOUNDERNAME,

Näyttää siltä, että rekisteröitynyt käyttäjä $USERNAME on muokannut wikiäsi! Miksi et kävisi hänen keskustelusivullaan ($USERTALKPAGEURL) ja sanoisi hei?

-- Wikia Team',
);

/** French (Français)
 * @author Balzac 40
 * @author Crochet.david
 * @author IAlex
 * @author Peter17
 * @author Wyz
 */
$messages['fr'] = array(
	'founderemails-desc' => 'Aide les fondateurs en les informant des changements sur leur wiki',
	'tog-founderemailsenabled' => 'M’envoyer des mises à jour par courriel sur ce que font les autres personnes (fondateurs uniquement)',
	'founderemails-email-user-registered-subject' => 'Quelqu\'un de nouveau a rejoint $WIKINAME',
	'founderemails-email-user-registered-body' => 'Bonjour $FOUNDERNAME,

$USERNAME vient de rejoindre votre wiki !

Saisissez cette occasion pour leur souhaiter la bienvenue sur votre wiki et les encourager à aider à éditer. Plus on est de fous, plus on rit, et plus rapidement votre wiki se développera.

L’équipe Wikia',
	'founderemails-email-user-registered-greeting' => 'Bonjour $ FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Félicitations! $USERNAME vient de rejoindre $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Profitez de cette occasion pour leur souhaiter la bienvenue sur votre wiki et les encourager à vous aider à éditer. Plus on est de fous, plus on rit, et plus rapidement votre wiki va se développer.',
	'founderemails-email-user-registered-signature' => "L'équipe de Wikia",
	'founderemails-email-user-registered-button' => 'Leur souhaiter la bienvenue',
	'founderemails-email-user-registered-body-HTML' => 'Bonjour $FOUNDERNAME,<br /><br />
On dirait que $USERNAME a créé un compte sur votre wiki ! Pourquoi ne pas passer lui dire bonjour sur sa <a href="$USERTALKPAGEURL">page de discussion</a> ?<br /><br />

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner à tous les courriels de Wikia.</div>',
	'founderemails-email-0-days-passed-subject' => 'Bienvenue sur Wikia !',
	'founderemails-email-0-days-passed-body' => 'Félicitations pour la création de $WIKINAME – Vous faites maintenant partie de la communauté Wikia !

– L’équipe Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Félicitations pour la création de <strong>$WIKINAME</strong> – Vous faites maintenant partie de la communauté Wikia ! <br /><br />
<div style="font-style: italic; font-size: 120%;">– L’équipe Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Autres choses',
	'founderemails-email-3-days-passed-body' => 'Bonjour $FOUNDERNAME,

Maintenant que vous avez passé quelques jours sur votre wiki, nous avons pensé que vous voudriez jeter un œil sur d’autres choses que vous pourriez faire.

– L’équipe Wikia',
	'founderemails-email-3-days-passed-body-HTML' => 'Bonjour $FOUNDERNAME,<br /><br />
Maintenant que vous avez passé quelques jours sur votre wiki, nous avons pensé que vous voudriez jeter un œil sur d’autres choses que vous pourriez faire.<br /><br />
<div style="font-style: italic; font-size: 120%;">– L’équipe Wikia</div>',
	'founderemails-email-10-days-passed-subject' => 'Comment va votre wiki ?',
	'founderemails-email-10-days-passed-body' => 'Bonjour $FOUNDERNAME,

Cela fait maintenant quelque temps que vous avez commencé un wiki sur Wikia – nous espérons que ça se passe bien ! Nous voulions partager avec vous quelques trucs pour vous aider à vous sentir comme chez vous sur votre wiki.

– L’équipe Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME a reçu une nouvelle modification !',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Bonjour $FOUNDERNAME,

Très bien ! $USERNAME a effectué sa toute première modification sur $WIKINAME !

Jeter un coup d\'oeil sur $PAGETITLE pour vérifier ce qu\'il a ajouté.

L\'équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : $UNSUBSCRIBEURL',
	'founderemails-email-first-edit-greeting' => 'Bonjour $FOUNDERNAME,',
	'founderemails-email-first-edit-signature' => "L'équipe de Wikia",
	'founderemails-email-first-edit-button' => 'Vérifier !',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => '<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Bonjour $FOUNDERNAME,</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">$USERNAME a rejoint votre wiki et a effectué sa toute première modification !</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Passez lui souhaiter la bienvenue sur sa <a href="$USERTALKPAGEURL">page de discussion</a> et répondez aux questions qu’il pourrait avoir. Les contributeurs actifs sont très importants, ils peuvent aider à développer votre wiki et le rendre populaire. Faites au mieux pour l’encourager et l’aider à s’impliquer.</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Des contributeurs heureux font des wikis où il fait bon participer !</p> 
<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner à tous les courriels de Wikia.</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Une nouvelle modification sur votre wiki !',
	'founderemails-email-page-edited-reg-user-body' => 'Bonjour $FOUNDERNAME,

$USERNAME a modifié $WIKINAME ! Rendez-vous sur $MYHOMEURL pour voir ce qu’il(elle) a ajouté.

– L’équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : $UNSUBSCRIBEURL',
	'founderemails-email-general-edit-greeting' => 'Bonjour $FOUNDERNAME,',
	'founderemails-email-general-edit-signature' => "L'équipe Wikia",
	'founderemails-email-general-edit-button' => 'Vérifier !',
	'founderemails-email-page-edited-reg-user-body-HTML' => '<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Bonjour $FOUNDERNAME,</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">$USERNAME a modifié $WIKINAME ! Rendez vous sur <a href="$MYHOMEURL">l\'activité</a> de votre wiki pour voir ce qu’il(elle) a ajouté.</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
	'founderemails-email-page-edited-anon-subject' => 'Un ami mystérieux a modifié $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Bonjour $FOUNDERNAME,

Un contributeur Wikia a modifié $WIKINAME ! Rendez-vous sur $MYHOMEURL pour voir ce qu’il(elle) a ajouté.

– L’équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : $UNSUBSCRIBEURL',
	'founderemails-email-anon-edit-greeting' => 'Bonjour $FOUNDERNAME,',
	'founderemails-email-anon-edit-signature' => "L'équipe de Wikia",
	'founderemails-email-anon-edit-button' => 'Vérifier !',
	'founderemails-email-page-edited-anon-body-HTML' => '<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Bonjour $FOUNDERNAME,</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Un contributeur Wikia a modifié $WIKINAME ! Rendez vous sur <a href="$MYHOMEURL">l\'activité</a> de votre wiki pour voir ce qu’il(elle) a ajouté.</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
	'founderemails-answers-email-user-registered-subject' => 'Quelqu’un a créé un compte sur votre wiki !',
	'founderemails-answers-email-user-registered-body' => 'Bonjour $FOUNDERNAME,

On dirait que $USERNAME a créé un compte sur votre wiki ! Pourquoi ne pas passer lui dire bonjour sur sa page de discussion ($USERTALKPAGEURL) ?

– L’équipe Wikia

Cliquez ici ($UNSUBSCRIBEURL) pour vous désabonner de ces courriels.',
	'founderemails-answers-email-user-registered-body-HTML' => 'Bonjour $FOUNDERNAME,<br /><br />
On dirait que $USERNAME a créé un compte sur votre wiki ! Pourquoi ne pas passer lui dire bonjour sur sa <a href="$USERTALKPAGEURL">page de discussion</a> ?<br /><br />

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Bienvenue sur le wiki réponses !',
	'founderemails-answers-email-0-days-passed-body' => 'Que faire maintenant ?

Commencez par poser des questions et à répondre ! Un site de réponses est fait pour partager la connaissance et vous pouvez commencer à créer des questions et réponses dès maintenant pour cela.

N’essayez pas de répondre à toutes les questions – lancez-vous et allez-y. Si vous n’avez pas toutes les informations, quelqu’un d’autre peut passer par là et vous aider.

Comment faire ?

 - Pour poser une question, saisissez quelque chose dans la barre pour poser une question en haut de la page.
 - Pour répondre à une question, rendez-vous sur la page de la question et ajoutez quelque chose dans la zone de réponse.
 - Pour améliorer une réponse, cliquez « modifier » près d’une réponse existante et changez la !

Si vous avez besoin de plus d’aide n’hésitez pas à lire $WIKIURLwiki/Help:Wikianswers?ctc=AFE18 ou discuter avec nous sur les forums à http://communaute.wikia.com/wiki/Forum:Vue_d%27ensemble?ctc=AFE19. Avant tout, amusez-vous !

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : $UNSUBSCRIBEURL',
	'founderemails-answers-email-0-days-passed-body-HTML' => '<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Félicitations pour avoir créé $WIKINAME – vous faites à présent partie de la communauté Wikia !!</p>

<h3 style="line-height: 150%;font-family:Arial,sans-serif;color: #990000;">Que faire maintenant ?</h3>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Commencez par poser des questions et à répondre ! Un site de réponses est fait pour partager la connaissance et vous pouvez commencer à créer des questions et réponses dès maintenant pour cela.</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;"><strong>N’essayez pas de répondre à toutes les questions</strong> – lancez-vous et allez-y. Si vous n’avez pas toutes les informations, quelqu’un d’autre peut passer par là et vous aider.</p>

<h3 style="line-height: 150%;font-family:Arial,sans-serif;color: #990000;">Comment faire ?</h3>

<ul style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">
<li>Pour poser une question, saisissez quelque chose dans la barre pour poser une question en haut de la page.</li>
<li>Pour répondre à une question, rendez-vous sur la page de la question et ajoutez quelque chose dans la zone de réponse.</li>
<li>Pour améliorer une réponse, cliquez « modifier » près d’une réponse existante et changez la !</li>
</ul>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Si vous avez besoin de plus d’aide n’hésitez pas à lire <a href="$WIKIURLwiki/Help:Wikianswers?ctc=AFE18">ceci</a> ou discuter avec nous sur les <a href="http://communaute.wikia.com/wiki/Forum:Vue_d%27ensemble?ctc=AFE19">forums</a>. Avant tout, <em>amusez-vous</em> !</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Autres choses',
	'founderemails-answers-email-3-days-passed-body' => 'Bonjour $FOUNDERNAME,

Maintenant que vous avez passé quelques jours sur votre wiki de réponses, nous voulions vous montrer un super moyen pour le faire vivre – recruter d’autres personnes pour vous aider !

Impliquer les autres

 - Utilisez le bouton « Partager » pour afficher vos meilleurs questions sur Facebook ou Twitter !
 - Si votre site traite d’un sujet en particulier, pourquoi ne pas vous rendre sur un forum que vous connaissez et demander de l’aide ? Exemple : Si vous avez quelques pages sur votre sites de réponses traitant de la nature, rendez-vous sur un forum qui traite du même sujet, partagez avec eux les questions et réponses que vous avez écrites jusque là et invitez-les à vous posez plus de questions, voire à répondre à certaines.
 - Envoyez des courriels à tous ceux que vous connaissez qui partagent votre passion – ce peut-être un collègue ou un camarade – et demandez-leur s’il y a des questions sur lesquelles ils peuvent aider.

Tandis que les gens vous rejoignent, posent et répondent à des questions, vous pouvez garder un œil sur ce qu’ils font sur Mon accueil ($WIKIURLwiki/Special:My_Home?ctc=AFE15), qui vous permet de voir ce qu’il se passe sur votre wiki. Cliquez sur leur nom pour en savoir plus sur eux et leur souhaiter la bienvenue sur votre site !

Rappelez-vous, si vous avez besoin de plus d’aide n’hésitez pas à lire $WIKIURLwiki/Help:Wikianswers?ctc=AFE18 ou discuter avec nous sur les forums à http://communaute.wikia.com/wiki/Forum:Vue_d%27ensemble?ctc=AFE19.

– L’équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : $UNSUBSCRIBEURL',
	'founderemails-answers-email-3-days-passed-body-HTML' => '<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Bonjour $FOUNDERNAME,</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Maintenant que vous avez passé quelques jours sur votre wiki de réponses, nous voulions vous montrer un super moyen pour le faire vivre – <strong>recruter d’autres personnes pour vous aider !</strong></p>

<h3 style="line-height: 150%;font-family:Arial,sans-serif;color: #990000;">Impliquer les autres</h3>

<ul style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">
<li>Utilisez le bouton « Partager » pour afficher vos meilleurs questions sur Facebook ou Twitter !</li>
<li>Si votre site traite d’un sujet en particulier, pourquoi ne pas vous rendre sur un forum que vous connaissez et demander de l’aide ? <span class="example">Exemple : Si vous avez quelques pages sur votre sites de réponses traitant de la nature, rendez-vous sur un forum qui traite du même sujet, partagez avec eux les questions et réponses que vous avez écrites jusque là et invitez-les à vous posez plus de questions, voire à répondre à certaines.</span></li>
<li>Envoyez des courriels à tous ceux que vous connaissez qui partagent votre passion – ce peut-être un collègue ou un camarade – et demandez-leur s’il y a des questions sur lesquelles ils peuvent aider.</li>
</ul>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Tandis que les gens vous rejoignent, posent et répondent à des questions, vous pouvez garder un œil sur ce qu’ils font sur <a href="$WIKIURLwiki/Special:My_Home?ctc=AFE15">Mon Accueil</a>, qui vous permet de voir ce qu’il se passe sur votre wiki. Cliquez sur leur nom pour en savoir plus sur eux et leur souhaiter la bienvenue sur votre site !</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Rappelez-vous, si vous avez besoin de plus d’aide n’hésitez pas à lire <a href="$WIKIURLwiki/Help:Wikianswers?ctc=AFE18">ceci</a> ou discuter avec nous sur les <a href="http://communaute.wikia.com/wiki/Forum:Vue_d%27ensemble?ctc=AFE19">forums</a>.</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Votre site de réponses et vous',
	'founderemails-answers-email-10-days-passed-body' => 'Bonjour $FOUNDERNAME,

Cela fait maintenant quelque temps que vous avez commencé un wiki sur Wikia – nous espérons que ça se passe bien ! Nous voulions partager avec vous quelques trucs pour vous aider à vous sentir comme chez vous sur votre wiki.

– L’équipe Wikia',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Bonjour $FOUNDERNAME,<br /><br />
Cela fait maintenant quelque temps que vous avez commencé un wiki sur Wikia – nous espérons que ça se passe bien ! Nous voulions partager avec vous quelques trucs pour vous aider à vous sentir comme chez vous sur votre wiki.<br /><br />
<div style="font-style: italic; font-size: 120%;">– L’équipe Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Quelqu’un a modifié votre site !',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Bonjour $FOUNDERNAME,

Un nouvel utilisateur, $USERNAME, a effectué une modification sur votre site pour la toute première fois ! Pourquoi ne pas passer lui dire bonjour sur sa page de discussion ($USERTALKPAGEURL) ?

– L’équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : $UNSUBSCRIBEURL',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => '<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Bonjour $FOUNDERNAME,</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;"> Un nouvel utilisateur, $USERNAME, a effectué une modification sur votre site pour la toute première fois ! Pourquoi ne pas passer lui dire bonjour sur sa <a href="$USERTALKPAGEURL">page de discussion</a> ?</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Quelqu’un a modifié votre site !',
	'founderemails-answers-email-page-edited-reg-user-body' => '
Bonjour $FOUNDERNAME,

$USERNAME vient de modifier votre site ! Rendez-vous sur $MYHOMEURL pour voir ce qu’il(elle) a ajouté.

– L’équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : $UNSUBSCRIBEURL',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => '
<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Bonjour $FOUNDERNAME,</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">$USERNAME a modifié votre site ! Rendez vous sur <a href="$MYHOMEURL">l\'activité</a> de votre wiki pour voir ce qu’il(elle) a ajouté.</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Quelqu’un a modifié votre site !',
	'founderemails-answers-email-page-edited-anon-body' => 'Bonjour $FOUNDERNAME,

Il y a eu des modifications sur votre site ! Rendez-vous sur $MYHOMEURL pour voir ce qui a changé.

– L’équipe Wikia

___________________________________________
* Pour voir les derniers évènements sur Wikia, rendez-vous sur http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}.
* Cliquez sur le lien suivant pour vous désabonner de tous les courriels de Wikia : $UNSUBSCRIBEURL',
	'founderemails-answers-email-page-edited-anon-body-HTML' => '<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">Bonjour $FOUNDERNAME,</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">$USERNAME vient de modifier votre site ! Rendez-vous sur <a href="$MYHOMEURL">l’activité</a> de votre site pour voir ce qui a changé.</p>

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les courriels de Wikia.</div>',
	'founderemails-lot-happening-subject' => "Il se passe beaucoup de choses sur votre site aujourd'hui !",
	'founderemails-lot-happening-body' => "Bonjour \$FOUNDERNAME,

Il y a beaucoup de choses qui se passent sur votre wiki, aujourd'hui ! Rendez-vous sur \$MYHOMEURL pour voir ce qu'il en est.

-- L'équipe Wikia",
	'founderemails-lot-happening-body-HTML' => 'Bonjour $FOUNDERNAME,<br /><br />
Il y a beaucoup de choses qui se passent sur votre wiki, aujourd\'hui ! Rendez-vous sur $MYHOMEURL pour voir ce qu\'il en est.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'équipe Wikia</div>',
	'founderemails-email-lot-happening-greeting' => 'Bonjour $FOUNDERNAME,',
	'founderemails-email-lot-happening-signature' => "L'équipe Wikia",
	'founderemails-email-footer-line1' => 'Pour voir les derniers évènements sur Wikia, rendez-vous sur <a style="color:#2a87d5;text-decoration:none;" href="http://communaute.wikia.com">communaute.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : <a href="$WIKIURL/wiki/Special:Preferences" style="color:#2a87d5;text-decoration:none;">$WIKIURL/wiki/Special:Preferences</a>',
	'founderemails-email-0-day-heading' => 'Enchanté de vous connaître $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Félicitations pour la création de $WIKINAME !',
	'founderemails-email-0-day-tips-heading' => 'Voici quelques conseils utiles pour vous aider à démarrer :',
	'founderemails-email-0-day-addpages-heading' => 'Ajouter des pages.',
	'founderemails-email-0-day-addpages-content' => 'Le but d’un wiki est de partager des informations sur votre sujet en particulier. Créez des pages en cliquant sur « <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">Ajouter une page</a> » et complétez avec des informations plus spécifiques concernant votre sujet.',
	'founderemails-email-0-day-addpages-button' => 'Ajouter une page',
	'founderemails-email-0-day-addphotos-heading' => 'Ajouter des photos.',
	'founderemails-email-0-day-addphotos-content' => 'Les pages sont toujours mieux quand elles comportent des illustrations !  Ajoutez des images aux pages ainsi qu’à la page d’accueil.  Vous pouvez cliquer sur « <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">Ajouter une photo</a> », une galerie ou un carrousel.',
	'founderemails-email-0-day-addphotos-button' => 'Ajouter une photo',
	'founderemails-email-0-day-customizetheme-heading' => 'Personnaliser votre thème.',
	'founderemails-email-0-day-customizetheme-content' => 'Personnalisez le thème et le logo de votre wiki pour qu’il en jette !  Utilisez le <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Concepteur de thème</a> pour ajouter des couleurs personnalisées à votre wiki et le rendre unique pour votre sujet.',
	'founderemails-email-0-day-customizetheme-button' => 'Personnaliser',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">On ne vous abandonne pas.</span>  Nous sommes là pour vous aider à faire de $WIKINAME un succès tout au long du parcours.  Visitez <a style="color:#2a87d5;text-decoration:none;" href="http://communaute.wikia.com">communaute.wikia.com</a> pour les forums, des conseils et de l’aide, ou <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">envoyez-nous</a> vos questions !',
	'founderemails-email-0-day-wikiahelps-signature' => 'Bonne construction de wiki !<br />L’équipe Wikia',
	'founderemails-email-3-day-heading' => 'Bonjour $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Nous voulions passer et voir comment les choses vont sur $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Cela fait 3 jours que vous avez commencé et nous avons pensé que nous pourrions passer par là pour vous proposer quelques conseils en plus pour votre wiki :',
	'founderemails-email-3-day-editmainpage-heading' => 'Agrémentez votre page principale.',
	'founderemails-email-3-day-editmainpage-content' => 'La page principale est l’une des premières choses que voient les gens quand ils visitent <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>.  Faîtes bonne impression dès le début en écrivant un résumé détaillé de ce dont traite votre sujet et en ajoutant un diaporama, une galerie ou un carrousel.',
	'founderemails-email-3-day-editmainpage-button' => 'Agrémentez-la',
	'founderemails-email-3-day-addphotos-heading' => 'Ajouter encore plus de photos.',
	'founderemails-email-3-day-addphotos-content' => 'L’un des meilleurs moyens pour que vos pages brillent et étincellent est d’<a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">ajouter quelques photos</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Ajouter des photos',
	'founderemails-email-3-day-explore-heading' => 'Trouvez l’inspiration.',
	'founderemails-email-3-day-explore-content' => 'N’ayez pas peur de consulter d’autres wikis pour voir comment ils ont travaillé leur page principale, leurs pages d’article, etc.',
	'founderemails-email-3-day-explore-button' => 'Explorez',
	'founderemails-email-3-day-wikiahelps-text' => 'Vous avez besoin d’aide pour comprendre comment quelque chose fonctionne ? Nous sommes toujours là pour vous ! Venez demander de l’aide et des conseils sur <a style="color:#2a87d5;text-decoration:none;" href="http://communaute.wikia.com">communaute.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Continuez votre excellent travail !<br />L’équipe Wikia',
	'founderemails-email-10-day-heading' => 'Comment ça va $FOUNDERNAME ?',
	'founderemails-email-10-day-congratulations' => 'Ouah, le temps passe vite ! Cela fait déjà 10 jours que vous avez commencé $WIKINAME.',
	'founderemails-email-10-day-tips-heading' => 'Impliquez les autres sur votre projet et montrez tout le travail formidable que vous avez effectué ! Voici quelques façons de vous faire connaître :',
	'founderemails-email-10-day-share-heading' => 'Ne vous a-t-on jamais dit de partager ?',
	'founderemails-email-10-day-share-content' => 'Utilisez le bouton « Partager » sur votre barre d’outils, les pages d’article et les photos pour les montrer à vos amis et ceux qui vous suivent sur Facebook, Twitter et autres sites populaires.',
	'founderemails-email-10-day-email-heading' => 'Exploitez la puissance des courriels.',
	'founderemails-email-10-day-email-content' => 'Envoyez des courriels aux autres que vous connaissez qui sont intéressés par votre sujet ou par vous aider, comme des camarades ou des collègues.  Vous pouvez aussi envoyer par courriel certaines photos de votre wiki en utilisant le bouton d’envoi par courriel.',
	'founderemails-email-10-day-join-heading' => 'Contactez des sites Web similaires.',
	'founderemails-email-10-day-join-content' => 'Demandez de l’aide aux gens sur d’autres forums ou sites Web qui traitent du même sujet en postant des messages ou commentaires.  Si possible, contactez l’administrateur et voyez s’il est intéressé par le partage de liens – il met un lien vers votre wiki sur son site si vous mettez un lien vers son site sur votre wiki.',
	'founderemails-email-10-day-wikiahelps-text' => 'Vous pouvez aussi demander à d’autres Wikiens de vous aider sur votre wiki en postant sur les forums de <a style="color:#2a87d5;text-decoration:none;" href="http://communaute.wikia.com">communaute.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Continuez votre excellent travail !<br />L’équipe Wikia',
	'founderemails-email-views-digest-greeting' => 'Bonjour $FOUNDERNAME,',
	'founderemails-email-views-digest-signature' => "L'équipe Wikia",
	'founderemails-email-views-digest-button' => 'Ajouter plus de pages',
	'founderemails-email-complete-digest-greeting' => 'Bonjour $FOUNDERNAME,',
	'founderemails-email-complete-digest-content-heading3' => '$USERJOINS personnes ont rejoint votre wiki.',
	'founderemails-email-complete-digest-signature' => "L'équipe Wikia",
	'founderemails-pref-joins' => "Envoyez-moi un courriel quand quelqu'un rejoint $1",
	'founderemails-pref-edits' => "Envoyez-moi un courriel quand quelqu'un modifie $1",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'founderemails-desc' => 'Axuda a informar aos fundadores sobre os cambios que acontecen no seu wiki',
	'tog-founderemailsenabled' => 'Enviádeme actualizacións por correo electrónico sobre o que acontece no wiki (só fundadores)',
	'founderemails-email-user-registered-subject' => 'Alguén rexistrou unha conta no seu wiki!',
	'founderemails-email-user-registered-body' => 'Boas, $FOUNDERNAME:

Semella que $USERNAME rexistrou unha conta no seu wiki! Por que non se achega ata a súa páxina de conversa $USERTALKPAGEURL para darlle a benvida?

-- O equipo de Wikia',
	'founderemails-email-user-registered-greeting' => 'Boas, $FOUNDERNAME:',
	'founderemails-email-user-registered-signature' => 'O equipo de Wikia',
	'founderemails-email-user-registered-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Semella que $USERNAME rexistrou unha conta no seu wiki! Por que non se achega ata a súa páxina de conversa <a href="$USERTALKPAGEURL">páxina de conversa</a> para darlle a benvida?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-email-0-days-passed-subject' => 'Benvido a Wikia!',
	'founderemails-email-0-days-passed-body' => 'Parabéns pola creación de $WIKINAME. Agora xa é parte da comunidade de Wikia!

-- O equipo de Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Parabéns pola creación de <strong>$WIKINAME</strong>. Agora xa é parte da comunidade de Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Cousas',
	'founderemails-email-3-days-passed-body' => 'Boas, $FOUNDERNAME:

Agora que xa leva uns días co seu wiki, pensamos que xa é hora de que queira comprobar algunhas outras cousas que pode facer.

-- O equipo de Wikia',
	'founderemails-email-3-days-passed-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Agora que xa leva uns días co seu wiki, pensamos que xa é hora de que queira comprobar algunhas outras cousas que pode facer.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-email-10-days-passed-subject' => 'Como andan as cousas no seu wiki?',
	'founderemails-email-10-days-passed-body' => 'Boas, $FOUNDERNAME:

Xa hai algún tempo que comezou un wiki en Wikia; agardamos que lle vaia ben! Gustaríanos compartir uns poucos trucos que lle axudarán a facer o wiki máis acolledor.

-- O equipo de Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Un usuario rexistrado fixo unha modificación no seu wiki por vez primeira!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Boas, $FOUNDERNAME:

Semella que o usuario rexistrado chamado $USERNAME fixo unha edición no seu wiki por vez primeira! Por que non se achega ata a súa páxina de conversa ($USERTALKPAGEURL) para saudalo?

-- O equipo de Wikia',
	'founderemails-email-first-edit-greeting' => 'Boas, $FOUNDERNAME:',
	'founderemails-email-first-edit-signature' => 'O equipo de Wikia',
	'founderemails-email-first-edit-button' => 'Bótelle unha ollada!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Semella que o usuario rexistrado chamado $USERNAME fixo unha edición no seu wiki por vez primeira! Por que non se achega ata a súa <a href="$USERTALKPAGEURL">páxina de conversa</a> para saudalo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Un usuario rexistrado fixo unha modificación no seu wiki!',
	'founderemails-email-page-edited-reg-user-body' => 'Boas, $FOUNDERNAME:

Semella que o usuario rexistrado chamado $USERNAME fixo unha edición no seu wiki! Por que non se achega ata a súa páxina de conversa ($USERTALKPAGEURL) para saudalo?

-- O equipo de Wikia',
	'founderemails-email-general-edit-greeting' => 'Boas, $FOUNDERNAME:',
	'founderemails-email-general-edit-signature' => 'O equipo de Wikia',
	'founderemails-email-general-edit-button' => 'Bótelle unha ollada!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Semella que o usuario rexistrado chamado $USERNAME fixo unha edición no seu wiki! Por que non se achega ata a súa <a href="$USERTALKPAGEURL">páxina de conversa</a> para saudalo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-email-page-edited-anon-subject' => 'Alguén fixo unha modificación no seu wiki!',
	'founderemails-email-page-edited-anon-body' => 'Boas, $FOUNDERNAME:

Semella que alguén fixo unha edición no seu wiki! Por que non comproba $MYHOMEURL o que fixo?

-- O equipo de Wikia',
	'founderemails-email-anon-edit-greeting' => 'Boas, $FOUNDERNAME:',
	'founderemails-email-anon-edit-signature' => 'O equipo de Wikia',
	'founderemails-email-anon-edit-button' => 'Bótelle unha ollada!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Semella que alguén fixo unha edición no seu wiki! Por que non <a href="$MYHOMEURL">comproba</a> o que fixo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-answers-email-user-registered-subject' => 'Alguén rexistrou unha conta no seu wiki de preguntas e respostas!',
	'founderemails-answers-email-user-registered-body' => 'Boas, $FOUNDERNAME:

Semella que $USERNAME rexistrou unha conta no seu wiki! Por que non se achega ata a súa páxina de conversa $USERTALKPAGEURL para saudalo?

-- O equipo de Wikia',
	'founderemails-answers-email-user-registered-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Semella que $USERNAME rexistrou unha conta no seu wiki! Por que non se achega ata a súa <a href="$USERTALKPAGEURL">páxina de conversa</a> para saudalo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Benvido ao Wikia de preguntas e respostas!',
	'founderemails-answers-email-0-days-passed-body' => 'Parabéns pola creación de $WIKINAME. Agora xa é parte da comunidade de Wikia!

-- O equipo de Wikia',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Parabéns pola creación de <strong>$WIKINAME</strong>. Agora xa é parte da comunidade de Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Cousas',
	'founderemails-answers-email-3-days-passed-body' => 'Boas, $FOUNDERNAME:

Agora que xa leva uns días co seu wiki, pensamos que xa é hora de que queira comprobar algunhas outras cousas que pode facer.

-- O equipo de Wikia',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Agora que xa leva uns días co seu wiki, pensamos que xa é hora de que queira comprobar algunhas outras cousas que pode facer.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Como andan as cousas no seu wiki?',
	'founderemails-answers-email-10-days-passed-body' => 'Boas, $FOUNDERNAME:

Xa hai algún tempo que comezou un wiki en Wikia; agardamos que lle vaia ben! Gustaríanos compartir uns poucos trucos que lle axudarán a facer o wiki máis acolledor.

-- O equipo de Wikia',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Xa hai algún tempo que comezou un wiki en Wikia; agardamos que lle vaia ben! Gustaríanos compartir uns poucos trucos que lle axudarán a facer o wiki máis acolledor.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Un usuario rexistrado fixo unha modificación no seu sitio por vez primeira!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Boas, $FOUNDERNAME:

Semella que o usuario rexistrado chamado $USERNAME fixo unha edición no seu wiki por vez primeira! Por que non se achega ata a súa páxina de conversa ($USERTALKPAGEURL) para saudalo?

-- O equipo de Wikia',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Semella que o usuario rexistrado chamado $USERNAME fixo unha edición no seu wiki por vez primeira! Por que non se achega ata a súa <a href="$USERTALKPAGEURL">páxina de conversa</a> para saudalo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Un usuario rexistrado fixo unha modificación no seu sitio!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Boas, $FOUNDERNAME:

Semella que o usuario rexistrado chamado $USERNAME fixo unha edición no seu wiki! Por que non se achega ata a súa páxina de conversa ($USERTALKPAGEURL) para saudalo?

-- O equipo de Wikia',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Semella que o usuario rexistrado chamado $USERNAME fixo unha edición no seu wiki! Por que non se achega ata a súa <a href="$USERTALKPAGEURL">páxina de conversa</a> para saudalo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Alguén fixo unha modificación no seu sitio!',
	'founderemails-answers-email-page-edited-anon-body' => 'Boas, $FOUNDERNAME:

Semella que alguén fixo unha edición no seu wiki! Por que non comproba $MYHOMEURL o que fixo?

-- O equipo de Wikia',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Semella que alguén fixo unha edición no seu wiki! Por que non <a href="$MYHOMEURL">comproba</a> o que fixo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-lot-happening-subject' => 'Hoxe pasaron moitas cousas no seu sitio!',
	'founderemails-lot-happening-body' => 'Boas, $FOUNDERNAME:

Hoxe aconteceron moitas cousas no seu wiki! Pase por $MYHOMEURL para botarlle un ollo ao que ocorreu.

-- O equipo de Wikia',
	'founderemails-lot-happening-body-HTML' => 'Boas, $FOUNDERNAME:<br /><br />
Hoxe aconteceron moitas cousas no seu wiki! Pase por $MYHOMEURL para botarlle un ollo ao que ocorreu.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- O equipo de Wikia</div>',
	'founderemails-email-lot-happening-greeting' => 'Boas, $FOUNDERNAME:',
	'founderemails-email-lot-happening-signature' => 'O equipo de Wikia',
	'founderemails-email-0-day-heading' => 'Encantado de o coñecer $FOUNDERNAME:',
	'founderemails-email-0-day-congratulations' => 'Parabéns pola creación de $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Aquí ten algúns consellos útiles para comezar:',
	'founderemails-email-0-day-addpages-heading' => 'Engadir páxinas.',
	'founderemails-email-0-day-addpages-button' => 'Engadir unha páxina',
	'founderemails-email-0-day-addphotos-heading' => 'Engadir fotos.',
	'founderemails-email-0-day-addphotos-button' => 'Engadir unha foto',
	'founderemails-email-0-day-customizetheme-heading' => 'Personalice o seu tema visual.',
	'founderemails-email-0-day-customizetheme-button' => 'Personalizar',
	'founderemails-email-0-day-wikiahelps-signature' => 'Feliz construción de wiki!<br />O equipo de Wikia',
	'founderemails-email-3-day-heading' => 'Boas $FOUNDERNAME:',
	'founderemails-email-3-day-addphotos-heading' => 'Engadir aínda máis fotos.',
	'founderemails-email-3-day-addphotos-button' => 'Engadir as fotos',
	'founderemails-email-3-day-explore-heading' => 'Atope inspiración.',
	'founderemails-email-3-day-explore-button' => 'Explorar',
	'founderemails-email-3-day-wikiahelps-signature' => 'Siga traballando arreo!<br />O equipo de Wikia',
	'founderemails-email-10-day-heading' => 'Como van as cousas, $FOUNDERNAME?',
	'founderemails-email-10-day-join-heading' => 'Únase a sitios similares.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Siga traballando arreo!<br />O equipo de Wikia',
	'founderemails-email-views-digest-greeting' => 'Boas, $FOUNDERNAME:',
	'founderemails-email-views-digest-signature' => 'O equipo de Wikia',
	'founderemails-email-views-digest-button' => 'Engadir máis páxinas',
	'founderemails-email-complete-digest-greeting' => 'Boas, $FOUNDERNAME:',
	'founderemails-email-complete-digest-signature' => 'O equipo de Wikia',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'founderemails-desc' => 'Segít tájékoztatni a wiki alapítóit a rajta történt változásokról',
	'tog-founderemailsenabled' => 'Küldj emailt róla, mit csinálnak a többiek (csak alapítók)',
	'founderemails-email-user-registered-subject' => 'Valaki regisztrált a wikiden!',
	'founderemails-email-0-days-passed-subject' => 'Üdvözlünk a Wikián!',
	'founderemails-email-0-days-passed-body' => 'Gratulálunk a(z) $WIKINAME létrehozásához ‒ tagja lettél a Wikia közösségnek!

– A Wikia csapat',
	'founderemails-email-3-days-passed-subject' => 'Beköszönés',
	'founderemails-email-10-days-passed-subject' => 'Hogy mennek a dolgok a wikiden?',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Szia $FOUNDERNAME!

Úgy tűnik, hogy $USERNAME regisztrált felhasználó szerkesztette a wikidet! Beugorhatnál a vitalapjára ($USERTALKPAGEURL) köszönteni.

– A Wikia csapat',
	'founderemails-answers-email-page-edited-anon-subject' => 'Valaki megváltoztatta a QA wikidet!',
	'founderemails-answers-email-page-edited-anon-body' => 'Szia $FOUNDERNAME!

Úgy tűnik, hogy valaki szerkesztette a wikidet! Nézd meg a(z) $MYHOMEURL lapot, hogy lásd mi változott!

– A Wikia csapat',
	'founderemails-email-3-day-addphotos-button' => 'Fényképek hozzáadása',
	'founderemails-email-3-day-explore-button' => 'Felfedezés',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'founderemails-desc' => 'Adjuta a informar le fundatores super le modificationes in lor wiki',
	'tog-founderemailsenabled' => 'Inviar me actualisationes super lo que le altere personas face (fundatores solmente)',
	'founderemails-email-user-registered-subject' => 'Un nove usator in $WIKINAME',
	'founderemails-email-user-registered-body' => 'Salute $FOUNDERNAME,

Felicitationes! Le nove usator $USERNAME ha justo create su conto in $WIKINAME.

Per favor da le un benvenita a tu wiki e incoragia le a adjutar. Quanto plus contributores tanto plus gaudio, e tanto plus rapidemente tu wiki crescera.

Le equipa de Wikia',
	'founderemails-email-user-registered-greeting' => 'Salute $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Felicitationes! Le nove usator $USERNAME ha justo create su conto in $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Per favor da le un benvenita a tu wiki e incoragia le a adjutar. Quanto plus contributores tanto plus gaudio, e tanto plus rapidemente tu wiki crescera.',
	'founderemails-email-user-registered-signature' => 'Le equipa de Wikia',
	'founderemails-email-user-registered-button' => 'Dar le un benvenita',
	'founderemails-email-user-registered-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Il pare que $USERNAME ha create un conto in tu wiki! Proque non visitar su <a href="$USERTALKPAGEURL">pagina de discussion</a> pro salutar le?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-email-0-days-passed-subject' => 'Benvenite a Wikia!',
	'founderemails-email-0-days-passed-body' => 'Felicitationes pro le creation de $WIKINAME. Tu face ora parte del communitate de Wikia!

-- Le equipa de Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Felicitationes pro le creation de <strong>$WIKINAME</strong>. Tu face ora parte del communitate de Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Contacto',
	'founderemails-email-3-days-passed-body' => 'Salute $FOUNDERNAME,

Ora que tu ha passate qualque dies in tu wiki, nos pensa que tu poterea voler probar altere cosas que tu pote facer.

-- Le equipa de Wikia',
	'founderemails-email-3-days-passed-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Ora que tu ha passate qualque dies in tu wiki, nos pensa que tu poterea voler probar altere cosas que tu pote facer.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-email-10-days-passed-subject' => 'Como va le cosas in tu wiki?',
	'founderemails-email-10-days-passed-body' => 'Salute $FOUNDERNAME,

Alcun tempore ha passate depost que tu comenciava un wiki in Wikia - nos spera que illo va ben! Nos volerea partir qualque avisos final pro adjutar a facer tu wiki como esser in casa.

-- Le equipa de Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME ha un nove modification!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Salute $FOUNDERNAME,

Multo bon! $USERNAME ha justo facite su primissime modification in $WIKINAME.

Visita $PAGETITLE pro vider lo que ille ha addite.

Le equipa de Wikia',
	'founderemails-email-first-edit-greeting' => 'Salute $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => 'Multo bon! $USERNAME ha justo facite su primissime modification in $WIKINAME.',
	'founderemails-email-first-edit-content' => 'Visita $PAGETITLE pro vider lo que ille ha addite.',
	'founderemails-email-first-edit-signature' => 'Le equipa de Wikia',
	'founderemails-email-first-edit-button' => 'Monstra me lo!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Pare que le usator registrate $USERNAME ha modificate tu wiki pro le prime vice! Proque non visitar su pagina de discussion ($USERTALKPAGEURL) pro salutar le?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Nove modification in $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Salute $FOUNDERNAME,

$USERNAME ha justo facite un altere modification del pagina $PAGETITLE in $WIKINAME.

Visita $PAGETITLE pro vider su modification.

Le equipa de Wikia',
	'founderemails-email-general-edit-greeting' => 'Salute $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => '$USERNAME ha justo facite un altere modification del pagina $PAGETITLE in $WIKINAME.',
	'founderemails-email-general-edit-content' => 'Visita $PAGETITLE pro vider su modification.',
	'founderemails-email-general-edit-signature' => 'Le equipa de Wikia',
	'founderemails-email-general-edit-button' => 'Monstra me lo!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Pare que le usator registrate $USERNAME ha modificate tu wiki! Proque non visitar su pagina de discussion ($USERTALKPAGEURL) pro salutar le?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-email-page-edited-anon-subject' => 'Un amico mysteriose ha modificate $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Salute $FOUNDERNAME,

Un contributor a Wikia ha justo facite un modification del pagina $PAGETITLE in $WIKINAME.

Le contributores a Wikia es personas qui face modificationes sin identificar se con un conto de Wikia. Va vider lo que iste amico mysteriose ha addite!

Le equipa de Wikia',
	'founderemails-email-anon-edit-greeting' => 'Salute $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'Un contributor a Wikia ha justo facite un modification del pagina $PAGETITLE in $WIKINAME.',
	'founderemails-email-anon-edit-content' => 'Le contributores a Wikia es personas qui face modificationes sin identificar se con un conto de Wikia. Va vider lo que iste amico mysteriose ha addite!',
	'founderemails-email-anon-edit-signature' => 'Le equipa de Wikia',
	'founderemails-email-anon-edit-button' => 'Monstra me lo!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Il pare que alcuno ha modificate tu wiki! Proque non visitar $MYHOMEURL pro vider lo que ha cambiate?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-answers-email-user-registered-subject' => 'Alcuno ha create un conto in tu wiki Q&R!',
	'founderemails-answers-email-user-registered-body' => 'Salute $FOUNDERNAME,

Pare que $USERNAME ha create un conto in tu wiki! Proque non visitar su pagina de discussion $USERTALKPAGEURL pro salutar le?

-- Le equipa de Wikia',
	'founderemails-answers-email-user-registered-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Pare que $USERNAME ha create un conto in tu wiki! Proque non visitar su pagina de discussion $USERTALKPAGEURL pro salutar le?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Benvenite a Wikia Q&R!',
	'founderemails-answers-email-0-days-passed-body' => 'Felicitationes pro haber create $WIKINAME - tu face ora parte del communitate Wikia!

-- Le equipa de Wikia',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Felicitationes pro haber create <strong>$WIKINAME</strong> - tu face ora parte del communitate Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Contacto',
	'founderemails-answers-email-3-days-passed-body' => 'Salute $FOUNDERNAME,

Ora que tu ha passate qualque dies in tu wiki, nos pensava que tu poterea voler investigar altere cosas que tu pote facer.

-- Le equipa de Wikia',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Ora que tu ha passate qualque dies in tu wiki, nos pensava que tu poterea voler investigar altere cosas que tu pote facer.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Como va le cosas con tu wiki?',
	'founderemails-answers-email-10-days-passed-body' => 'Salute $FOUNDERNAME,

Il es alcun tempore retro que tu ha comenciate un wiki in Wikia; nos spera que illo va ben! Nos volerea dar te alcun avisos final pro adjutar te a facer tu wiki plus como a casa.

-- Le equipa de Wikia',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Il es alcun tempore retro que tu ha comenciate un wiki in Wikia; nos spera que illo va ben! Nos volerea dar te alcun avisos final pro adjutar te a facer tu wiki plus como a casa.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Un usator registrate ha modificate tu sito pro le prime vice!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Salute $FOUNDERNAME,

Il pare que le usator registrate $USERNAME ha modificate tu wiki pro le prime vice! Proque non visitar su pagina de discussion ($USERTALKPAGEURL) pro salutar le?

-- Le equipa de Wikia',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Il pare que le usator registrate $USERNAME ha modificate tu wiki pro le prime vice! Proque non visitar su pagina de discussion ($USERTALKPAGEURL) pro salutar le?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Un usator registrate ha modificate tu sito!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Salute $FOUNDERNAME,

Il pare que le usator registrate $USERNAME ha modificate tu wiki! Proque non visitar su pagina de discussion ($USERTALKPAGEURL) pro salutar le?

-- Le equipa de Wikia',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Il pare que le usator registrate $USERNAME ha modificate tu wiki! Proque non visitar su pagina de discussion ($USERTALKPAGEURL) pro salutar le?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Alcuno ha modificate tu sito!',
	'founderemails-answers-email-page-edited-anon-body' => 'Salute $FOUNDERNAME,

Il pare que alcuno ha modificate tu wiki! Proque non visitar $MYHOMEURL pro vider lo que ha cambiate?

-- Le equipa de Wikia',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Il pare que alcuno ha modificate tu wiki! Proque non visitar $MYHOMEURL pro vider lo que ha cambiate?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-lot-happening-subject' => '$WIKINAME deveni de plus in plus active!',
	'founderemails-lot-happening-body' => 'Salute $FOUNDERNAME,

Felicitationes, il eveni multo in $WIKINAME hodie!

Si tu non jam lo ha facite, visita Wiki Activitate pro vider tote le bon labor que ha essite facite.

Considerante que il ha multe activitate, es possibile que tu prefere cambiar le livration de e-mail in modo de digesto. Con le modo de digesto, tu recipera un sol e-mail cata die que lista tote le activitate de tu wiki.

-- Le equipa de Wiki',
	'founderemails-lot-happening-body-HTML' => 'Salute $FOUNDERNAME,<br /><br />
Il eveni multo in tu wiki hodie! Visita $MYHOMEURL pro vider lo que ha occurrite.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Le equipa de Wikia</div>',
	'founderemails-email-lot-happening-greeting' => 'Salute $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => 'Felicitationes, il eveni multo in $WIKINAME hodie!',
	'founderemails-email-lot-happening-content' => 'Si tu non jam lo ha facite, visita Wiki Activitate pro vider tote le bon labor que ha essite facite. Considerante que il ha multe activitate, es possibile que tu prefere cambiar le livration de e-mail in modo de digesto. Con le modo de digesto, tu recipera un sol e-mail cata die que lista tote le activitate de tu wiki.',
	'founderemails-email-lot-happening-signature' => 'Le equipa de Wikia',
	'founderemails-email-lot-happening-button' => 'Vider activitates',
	'founderemails-email-footer-line1' => 'Pro sequer le ultime evenimentos in Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Vole seliger le e-mails que tu recipe? Face lo in tu [{{fullurl:{{ns:special}}:Preferences}} Preferentias]',
	'founderemails-email-0-day-heading' => 'Placer de cognoscer te, $FOUNDERNAME.',
	'founderemails-email-0-day-congratulations' => 'Felicitationes pro le creation de $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Ecce alcun consilios utile pro adjutar te a comenciar:',
	'founderemails-email-0-day-addpages-heading' => 'Adder paginas.',
	'founderemails-email-0-day-addpages-content' => 'Le essentia de un wiki es divulgar informationes concernente le thema de tu preferentia. Crea paginas con un clic sur <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">"Adder un pagina"</a> e scribe informationes specific a proposito de tu thema.',
	'founderemails-email-0-day-addpages-button' => 'Adder un pagina',
	'founderemails-email-0-day-addphotos-heading' => 'Adder photos.',
	'founderemails-email-0-day-addphotos-content' => 'Un pagina es sempre melior si illo offere qualcosa de visual! Adde imagines a tu paginas e a tu pagina principal. Tu pote cliccar sur <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"Adder un photo"</a> pro adder un photo, un galeria de photos o un presentation de diapositivas.',
	'founderemails-email-0-day-addphotos-button' => 'Adder un photo',
	'founderemails-email-0-day-customizetheme-heading' => 'Personalisar le apparentia.',
	'founderemails-email-0-day-customizetheme-content' => 'Personalisa le apparentia e logotypo de tu wiki pro distinguer lo del alteres! Usa le <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">designator de apparentias</a> pro personalisar le colores de tu wiki e render lo unic pro tu thema.',
	'founderemails-email-0-day-customizetheme-button' => 'Personalisar',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">Nos non va abandonar te.</span>  Nos es presente pro adjutar te a facer $WIKINAME succeder, passo pro passo.  Visita <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> pro foros, consilios e adjuta, o pro <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">inviar nos</a> tu questiones!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Bon wiki-construction!<br />Le equipa de Wikia',
	'founderemails-email-3-day-heading' => 'Salute $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Nos es curiose de como le cosas va in $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Il ha 3 dies post que tu comenciava e le momenta sembla bon pro offerer te alcun consilios pro construer tu wiki:',
	'founderemails-email-3-day-editmainpage-heading' => 'Imbelli tu pagina principal.',
	'founderemails-email-3-day-editmainpage-content' => 'Le pagina principal es un del prime cosas que le gente vide quando illes visita <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>. Face un bon prime impression per scriber un summario in detalio de tu thema e per adder un presentation de diapositivas, galeria, o glissator de photos.',
	'founderemails-email-3-day-editmainpage-button' => 'Imbellimento',
	'founderemails-email-3-day-addphotos-heading' => 'Adder ancora plus photos.',
	'founderemails-email-3-day-addphotos-content' => 'Un del melior methodos de dar grande apparato e pompa a tu pagina es de <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"adder photos"</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Adder photos',
	'founderemails-email-3-day-explore-heading' => 'Trovar inspiration.',
	'founderemails-email-3-day-explore-content' => 'Non hesita a examinar altere wikis pro vider como illos ha elaborate lor paginas principal, articulos e alteres. Ecce alcunes de nostre favorites: <a style="color:#2a87d5;text-decoration:none;" href="http://muppets.wikia.com">Muppet Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://poptarts.wikia.com">Pop Tarts Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://monsterhigh.wikia.com">Monster High Wiki</a>.',
	'founderemails-email-3-day-explore-button' => 'Explorar',
	'founderemails-email-3-day-wikiahelps-text' => 'Necessita adjuta pro comprender como un cosa functiona? Nos es presente pro te! Veni demandar adjuta e consilio de nos a <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Continua le excellente labor!<br />Le equipa de Wikia',
	'founderemails-email-10-day-heading' => 'Como sta, $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Hola, le tempore vola! Ha passate jam 10 dies post que tu comenciava $WIKINAME.',
	'founderemails-email-10-day-tips-heading' => 'Recruta altere personas in tu projecto e face monstra de tote le superbe labor que tu ha facite! Ecce alcun methodos de diffunder le parola:',
	'founderemails-email-10-day-share-heading' => 'Non ha tu matre te dicite que tu debe repartir?',
	'founderemails-email-10-day-share-content' => 'Usa le button Repartir in tu barra de instrumentos, paginas de articulo e photos pro facer monstra de illos a tu amicos e sequitores in Facebook, Twitter o altere sitos popular.',
	'founderemails-email-10-day-email-heading' => 'Utilisa le fortia de e-mail.',
	'founderemails-email-10-day-email-content' => 'Invia e-mail a cognoscitos qui se interessa in tu thema o qui vole adjutar te, como un amico de schola o un collega. Tu pote etiam inviar photos specific de tu wiki usante le button de e-mail.',
	'founderemails-email-10-day-join-heading' => 'Uni te a sitos web similar.',
	'founderemails-email-10-day-join-content' => 'Demanda adjuta al personas in altere foros o sitos web super tu thema per inviar messages o commentos in lor foros. Si possibile, contacta le administrator pro determinar si ille es interessate in excambiar ligamines; ille inserera un ligamine a tu wiki in su sito si tu insere un ligamine al sue in le tue.',
	'founderemails-email-10-day-wikiahelps-text' => 'Tu pote etiam demandar a altere Wikianos de adjutar te in tu wiki per mitter messages in le foros in <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Continua le bon labor!<br />Le equipa de Wikia',
	'founderemails-email-views-digest-subject' => 'Visitas de $WIKINAME de hodie',
	'founderemails-email-views-digest-body' => 'Salute $FOUNDERNAME,

Hodie, $WIKINAME ha essite visitate per # personas.

Continua le addition de nove contento e le promotion de tu wiki pro incoragiar plus personas a leger, modificar e diffunder le parola.

Le equipa de Wikia',
	'founderemails-email-views-digest-greeting' => 'Salute $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Hodie, $WIKINAME ha essite visitate per $UNIQUEVIEWS personas.',
	'founderemails-email-views-digest-content' => 'Continua le addition de nove contento e le promotion de tu wiki pro incoragiar plus personas a leger, modificar e diffunder le parola.',
	'founderemails-email-views-digest-signature' => 'Le equipa de Wikia',
	'founderemails-email-views-digest-button' => 'Adder plus paginas',
	'founderemails-email-complete-digest-subject' => 'Le activitate le plus recente in $WIKINAME',
	'founderemails-email-complete-digest-body' => 'Salute $FOUNDERNAME,

Es le momento pro tu dose quotidian de activitate in $WIKINAME.

$UNIQUEVIEWS personas ha visitate tu wiki.

Continua le bon labor addente contento interessante que le gente pote leger!

$USEREDITS modificationes ha essite facite.

Redactores felice face wikis felice. Assecura te de regratiar le redactores e de contactar les de tempore a tempore.

$USERJOINS personas ha adherite a tu wiki.

Da le benvenita al nove personas in tu wiki con un message in lor pagina de discussion.

Tu pote sempre visitar Wiki Activitate pro vider tote le modificationes que es facite in $WIKINAME. Revisita lo sovente, proque le communitate depende de te, como fundator, pro adjuta e direction in le gerentia del wiki.

Le equipa de Wikia',
	'founderemails-email-complete-digest-greeting' => 'Salute $FOUNDERNAME,',
	'founderemails-email-complete-digest-headline' => 'Es le momento pro tu dose quotidian de activitate in $WIKINAME.',
	'founderemails-email-complete-digest-content-heading1' => '$UNIQUEVIEWS personas ha visitate tu wiki.',
	'founderemails-email-complete-digest-content1' => 'Continua le bon labor addente contento interessante que le gente pote leger!',
	'founderemails-email-complete-digest-content-heading2' => '$USEREDITS modificationes ha essite facite.',
	'founderemails-email-complete-digest-content2' => 'Redactores felice face wikis felice. Assecura te de regratiar le redactores e de contactar les de tempore a tempore.',
	'founderemails-email-complete-digest-content-heading3' => '$USERJOINS personas ha adherite a tu wiki.',
	'founderemails-email-complete-digest-content3' => 'Da le benvenita al nove personas in tu wiki con un message in lor pagina de discussion.
<br /><br />
Tu pote sempre visitar Wiki Activitate pro vider tote le modificationes que es facite in $WIKINAME. Revisita lo sovente, proque le communitate depende de te, como fundator, pro adjuta e direction in le gerentia del wiki.',
	'founderemails-email-complete-digest-signature' => 'Le equipa de Wikia',
	'founderemails-email-complete-digest-button' => 'Visitar Wiki Activitate',
	'founderemails-pref-joins' => 'Inviar me e-mail si qualcuno adhere a $1',
	'founderemails-pref-edits' => 'Inviar me e-mail si qualcuno modifica $1',
	'founderemails-pref-views-digest' => 'Inviar me un e-mail cata die con le numero de visitas de $1',
	'founderemails-pref-complete-digest' => 'Inviar me un digesto cata die con le activitate in $1',
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'founderemails-desc' => 'ウィキで行われた変更について設立者に通知する',
	'tog-founderemailsenabled' => 'ウィキで変更が行われたときにメールを受け取る（設立者のみ）',
	'founderemails-email-user-registered-subject' => 'ウィキでアカウントが登録されました',
	'founderemails-email-user-registered-body' => '$FOUNDERNAME さん、

$USERNAME がウィキにアカウントを登録しました。

トークページ:
$USERTALKPAGEURL

-- ウィキアチーム',
	'founderemails-email-user-registered-body-HTML' => '$FOUNDERNAME さん、<br /><br />
$USERNAME がウィキにアカウントを登録しました。<br /><br />
トークページ:<br />
<a href="$USERTALKPAGEURL">$USERTALKPAGEURL</a><br /><br />
-- ウィキアチーム',
	'founderemails-email-0-days-passed-subject' => 'ウィキアにようこそ！',
	'founderemails-email-0-days-passed-body' => '$WIKINAME の作成おめでとうございます。これにより、あなたもウィキアコミュニティの一員となりました！

-- ウィキアチーム',
	'founderemails-email-0-days-passed-body-HTML' => '$WIKINAME の作成おめでとうございます。これにより、あなたもウィキアコミュニティの一員となりました！<br /><br />
-- ウィキアチーム',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'founderemails-desc' => "Hëlleft d'Grënner vun den Ännerungen op hirer Wiki z'informéieren",
	'founderemails-email-user-registered-signature' => "D'Wikia-Team",
	'founderemails-email-general-edit-signature' => "D'Wikia-Team",
	'founderemails-email-general-edit-button' => 'Probéiert et aus!',
	'founderemails-email-page-edited-anon-subject' => 'E mysteriéise Frënd huet $WIKINAME geännert',
	'founderemails-answers-email-0-days-passed-subject' => 'Wëllkomm op der QA Wikia!',
	'founderemails-email-0-day-addpages-heading' => 'Säiten derbäisetzen.',
	'founderemails-email-0-day-addpages-button' => 'Eng Säit derbäisetzen',
	'founderemails-email-0-day-addphotos-heading' => 'Fotoen derbäisetzen.',
	'founderemails-email-0-day-addphotos-button' => 'Eng Foto derbäisetzen',
	'founderemails-email-3-day-addphotos-button' => 'Fotoen derbäisetzen',
	'founderemails-email-views-digest-signature' => "D'Wikia-Team",
	'founderemails-email-views-digest-button' => 'Méi Säiten derbäisetzen',
	'founderemails-email-complete-digest-signature' => "D'Wikia-Team",
);

/** Basa Banyumasan (Basa Banyumasan)
 * @author StefanusRA
 */
$messages['map-bms'] = array(
	'founderemails-email-0-days-passed-subject' => 'Sugeng rawuh nang Wikia!',
	'founderemails-email-0-days-passed-body' => 'Slamet ya, wis gawe $WIKINAME - Panjenengan siki dadi bagiane komunitas Wikia!

-- Tim Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Slamet ya, wis nggawe <strong>$WIKINAME</strong> - Panjenengan siki dadi bagiane komunitas Wikia !<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Tim Wikia</div>',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'founderemails-desc' => 'Ги информира основачите за промените на нивното вики',
	'tog-founderemailsenabled' => 'Испраќај ми по е-пошта што прават другите (само основачи)',
	'founderemails-email-user-registered-subject' => 'Некој се зачлени на $WIKINAME',
	'founderemails-email-user-registered-body' => 'Здраво $FOUNDERNAME,

Честитаме! Корисникот $USERNAME штотуку се зачлени на вики $WIKINAME.

Искористете ја оваа прилика за да му посакате добредојде на вашето вики и да го поттикнете да уредува. Што повеќе, тоа повесело, и така ќе се развива вашето вики.

-- Екипата на Викија',
	'founderemails-email-user-registered-greeting' => 'Здраво $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Честитаме! $USERNAME штотуку се зачлени на $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Искористете ја оваа прилика да им посакате добредојде и да ги поттикнете да уредуваат. Што повеќе уредници, тоа повесело, а така побрзо ќе се развива викито.',
	'founderemails-email-user-registered-signature' => 'Екипата на Викија',
	'founderemails-email-user-registered-button' => 'Посакајте му добредојде',
	'founderemails-email-user-registered-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Корисникот $USERNAME се регистрираше на вашето вики! Зошто не пуштите поздрав на неговата <a href="$USERTALKPAGEURL">страница за разговор</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-email-0-days-passed-subject' => 'Добредојдовте на Викија!',
	'founderemails-email-0-days-passed-body' => 'Ви честитаме што го создадовте викито $WIKINAME - сега сте дел од заедницата на Викија!

-- Екипата на Викија',
	'founderemails-email-0-days-passed-body-HTML' => 'Ви честитаме што го создадовте викито <strong>$WIKINAME</strong> - сега сте дел од заедницата на Викија!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-email-3-days-passed-subject' => 'Мала проверка',
	'founderemails-email-3-days-passed-body' => 'Здраво $FOUNDERNAME,

Поминаа неколку дена откако го создадовте вашето вики, и затоа би сакале да ви предложиме некои други нешта што можете да ги направите.

-- Екипата на Викија',
	'founderemails-email-3-days-passed-body-HTML' => 'Здраво $FOUNDERNAME<br /><br />
Сега, кога вашето вики работи веќе неколку дена, би сакале да ви предложиме некои други нешта што можете да ги направите.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-email-10-days-passed-subject' => 'Како ви оди со вашето вики?',
	'founderemails-email-10-days-passed-body' => 'Здраво $FOUNDERNAME,

Помина извесно време откако го започнавте вашето вики на Викија - се надеваме дека ви оди добро! Би сакале да ве потсетиме на неколку завршни поединости кои ќе ви овозможат да го направите вашето вики што попријатно.

-- Екипата на Викија',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME има ново уредување!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Здраво $FOUNDERNAME,

Корисникот $USERNAME за прв пат направи уредување на $WIKINAME.

Појдете на $PAGETITLE за да видите што додал.

Екипата на Викија',
	'founderemails-email-first-edit-greeting' => 'Здраво $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => 'Корисникот $USERNAME штотуку го изврши неговото прво уредување на $WIKINAME.',
	'founderemails-email-first-edit-content' => 'Појдете на $PAGETITLE за да видите што е додадено.',
	'founderemails-email-first-edit-signature' => 'Екипата на Викија',
	'founderemails-email-first-edit-button' => 'Погледајте го!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Регистрираниот корисник $USERNAME за прв пат го уреди вашето вики! Зошто не пуштите еден поздрав на неговата <a href="$USERTALKPAGEURL">страница за развогор</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Ново уредување на $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Здраво $FOUNDERNAME,

Корисникот $USERNAME штотуку изврши друго уредување на страницата $PAGETITLE на $WIKINAME.

Појдете на $PAGETITLE и видите што изменил.

Екипата на Викија',
	'founderemails-email-general-edit-greeting' => 'Здраво $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => 'Корисникот $USERNAME штотуку изврши друго уредување на страницата $WIKINAME на $PAGETITLE.',
	'founderemails-email-general-edit-content' => 'Појдете на $PAGETITLE за да проверите што е додадено.',
	'founderemails-email-general-edit-signature' => 'Екипата на Викија',
	'founderemails-email-general-edit-button' => 'Check it out!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Регистрираниот корисник $USERNAME го уреди вашето вики! Зошто не пуштите поздрав на неговата <a href="$USERTALKPAGEURL">страница за разговор</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-email-page-edited-anon-subject' => 'Таинствен пријател изврши уредување на $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Здраво $FOUNDERNAME,

Учесник на Викија штотуку изврши уредување на страницата $PAGETITLE на $WIKINAME.

Учесниците на Викија се лица што вршат уреувања без да се најавени со сметка на Викија. Појдете да видите што додал овој таинствен пријател!

Екипата на Викија',
	'founderemails-email-anon-edit-greeting' => 'Здраво $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'Учесник на Викија штотуку изврши уредување на страницата $PAGETITLE на $WIKINAME.',
	'founderemails-email-anon-edit-content' => 'Учесниците на Викија се лица што вршат уредувања без да се најавени со сметка на Викија. Појдете да видите што додал таинствениот пријател!',
	'founderemails-email-anon-edit-signature' => 'Екипата на Викија',
	'founderemails-email-anon-edit-button' => 'Погледајте го!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Некој ви го уредил вашето вики! Зошто не <a href="$MYHOMEURL">проверите</a> да видите што е изменето?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-answers-email-user-registered-subject' => 'Некој регистрираше сметка на вашето вики „Прашања и одговори“!',
	'founderemails-answers-email-user-registered-body' => 'Здраво $FOUNDERNAME,

Корисникот $USERNAME се регистрираше на вашето вики! Зошто не пуштите поздрав на неговата страница за разговор $USERTALKPAGEURL?

-- Екипата на Викија',
	'founderemails-answers-email-user-registered-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Корисникот $USERNAME се регистрираше на вашето вики! Зошто не пуштите поздрав на неговата <a href="$USERTALKPAGEURL">страница ра разговор</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Добредојдовте на викијата „Прашања и одговори“!',
	'founderemails-answers-email-0-days-passed-body' => 'Ви го честитаме создавањето на $WIKINAME - сега сте дел од заедницата на Викија!

-- Екипата на Викија',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Ви го честитаме создавањето на <strong>$WIKINAME</strong> - сега сте дел од заедницата на Викија!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Мала проверка',
	'founderemails-answers-email-3-days-passed-body' => 'Здраво $FOUNDERNAME,

Сега, кога вашето вики работи веќе неколку дена, би сакале да ви предложиме некои други нешта што можете да ги направите.

-- Екипата на Викија',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Здраво $FOUNDERNAME<br /><br />
Сега, кога вашето вики работи веќе неколку дена, би сакале да ви предложиме некои други нешта што можете да ги направите.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Како ви оди со викито?',
	'founderemails-answers-email-10-days-passed-body' => 'Здраво $FOUNDERNAME,

IПомина извесно време откако го започнавте вашето вики на Викија - се надеваме дека ви оди добро! Би сакале да ве потсетиме на неколку завршни поединости кои ќе ви овозможат да го направите вашето вики што попријатно.

-- Екипата на Викија',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Помина извесно време откако го започнавте вашето вики на Викија - се надеваме дека ви оди добро! Би сакале да ве потсетиме на неколку завршни поединости кои ќе ви овозможат да го направите вашето вики што попријатно.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Регистриран корисник за прв пат го измени вашето мрежно место!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Здраво $FOUNDERNAME,

Регистрираниот корисник $USERNAME за прв пати го уреди вашето вики! Зошто не пуштите поздрав на неговата страница за разговор ($USERTALKPAGEURL)?

-- Екипата на Викија',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Регистрираниот корисник $USERNAME за прв пат го уреди вашето вики! Зошто не пуштите еден поздрав на неговата <a href="$USERTALKPAGEURL">страница за разговор</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Регистриран корисник го измени вашето мрежно место!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Здраво $FOUNDERNAME,

Регистрираниот корисник $USERNAME ви го уредил викито! Зошто не пуштите еден поздрав на неговата страница за разговор ($USERTALKPAGEURL)?

-- Екипата на Викија',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Регистрираниот корисник $USERNAME за прв пат го уреди вашето вики! Зошто не пуштите еден поздрав на неговата <a href="$USERTALKPAGEURL">страница за разговор</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Некој го измени вашето мрежно место!',
	'founderemails-answers-email-page-edited-anon-body' => 'Здраво $FOUNDERNAME,

Некој ви го уредил вашето вики! Зошто не појдете на $MYHOMEURL да видите што е изменето?

-- Екипата на Викија',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Некој ви го уредил викито! Зошто не <a href="$MYHOMEURL">појдете таму</a> да видите што е изменето?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-lot-happening-subject' => '$WIKINAME заживува!',
	'founderemails-lot-happening-body' => 'Здраво $FOUNDERNAME,

Честитаме. Денес има многу случувања на $WIKINAME!

Ако досега не сте ја посетиле страницата Активности на викито, појдете и погледајте што сè таму се одвива.

Бидејќи има толку збиднувања, можеби ќе треба да го прилагодите начинот на примање на е-пошта во режимот во збирен преглед. Така ќе ги добивате вестите за сите збиднувања во денот во една порака.

Екипата на Викија',
	'founderemails-lot-happening-body-HTML' => 'Здраво $FOUNDERNAME,<br /><br />
Денес има многу случувања на вашето Вики! Наминете на $MYHOMEURL за да видите што има.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Екипата на Викија</div>',
	'founderemails-email-lot-happening-greeting' => 'Здраво $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => 'Честитки! На $WIKINAME денес има многу збиднувања!',
	'founderemails-email-lot-happening-content' => 'Ако досега не сте ја посетиле страницата Активности на викито, појдете и погледајте што сè таму се одвива. Бидејќи има толку збиднувања, можеби ќе треба да го прилагодите начинот на примање на е-пошта во режимот во збирен преглед. Така ќе ги добивате вестите за сите збиднувања во денот во една порака.',
	'founderemails-email-lot-happening-signature' => 'Екипата на Викија',
	'founderemails-email-lot-happening-button' => '→ Активности',
	'founderemails-email-footer-line1' => 'За да ги проследите најновите случувања на Викија, посетете ја страницата <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Сакате да одберете кои пораки да ги добивате? Појдете на вашите [{{fullurl:{{ns:special}}:Preferences}} нагодувања]',
	'founderemails-email-0-day-heading' => 'Драго ми е што Ве запознав, $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Честититки за новосоздаденото - $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Еве некои корисни совети за почеток:',
	'founderemails-email-0-day-addpages-heading' => 'Додајте страници.',
	'founderemails-email-0-day-addpages-content' => 'Целта на едно вики е споделување на информации на некоја тема.  Созјдате страници стискајќи на <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">„Додај страница“</a> и напишете поподробно за вашата тема.',
	'founderemails-email-0-day-addpages-button' => 'Додај страница',
	'founderemails-email-0-day-addphotos-heading' => 'Додајте слики.',
	'founderemails-email-0-day-addphotos-content' => 'Страниците секогаш се подобри со ликовни елементи!  Додајте слики во страниците и на вашата главна страница. Стиснете на <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">„Додја слика“</a> за да додадете слика, галерија или подвижна галерија.',
	'founderemails-email-0-day-addphotos-button' => 'Додај слика',
	'founderemails-email-0-day-customizetheme-heading' => 'Прилагодете си го изгледот.',
	'founderemails-email-0-day-customizetheme-content' => 'Прилагодете го изгледот на вашето вики и графичкиот жиг за да се разликува од останатите!  Употребете го <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Ликовниот уредник</a> за да ги приалгодите боите и да направите измени што е одговараат на вашата тема.',
	'founderemails-email-0-day-customizetheme-button' => 'Прилагоди',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">Нема да ве оставиме на студот.</span>  Тука сме за да ви помогнеме $WIKINAME да биде успешно во секој нов чекор.  Посетете ја страницата <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> и таму ќе најдете форуми, совети и помош, или пак <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">пишете ни</a> ако имате прашања!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Нека ви е со среќа работата и развојот на викито!<br />Екипата на Викија',
	'founderemails-email-3-day-heading' => 'Здраво-живо $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Наминуваме за да видиме како одат работите на $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Поминаа веќе 3 дена откако почнавте, па наминавме за да ви понудиме уште некој совет за изработката на вашето вики:',
	'founderemails-email-3-day-editmainpage-heading' => 'Дотерајте ја вашата главна страница.',
	'founderemails-email-3-day-editmainpage-content' => 'Главната страница е првото нешто што го гледаат луѓето кога ќе го посетат викито <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>.  Оставете добар прв впечаток со тоа што ќе напишете подробно објаснување за вашата тематика, додајте подвижна галерија, галерија, или лизгач со слики.',
	'founderemails-email-3-day-editmainpage-button' => 'Дотерај ја',
	'founderemails-email-3-day-addphotos-heading' => 'Додајте уште повеќе слики.',
	'founderemails-email-3-day-addphotos-content' => 'Еден од најдобрите начини за да направите солидна страница е да <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"додадете слики"</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Додај слики',
	'founderemails-email-3-day-explore-heading' => 'Најдете инспирација.',
	'founderemails-email-3-day-explore-content' => 'Најслободно разгледајте ги другите викија и погледајте како ги изработиле нивните главни страници, статии и др.  Еве ги нашите предлози: <a style="color:#2a87d5;text-decoration:none;" href="http://muppets.wikia.com">Muppet Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://poptarts.wikia.com">Pop Tarts Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://monsterhigh.wikia.com">Monster High Wiki</a>.',
	'founderemails-email-3-day-explore-button' => 'Истражи',
	'founderemails-email-3-day-wikiahelps-text' => 'Ви треба помош за да се снајдете?  Секогаш ви стоиме на располагање!  Побарајте ни помош и совети на страницата <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Продолжете со одличната работа!<br />Екипата на Викија',
	'founderemails-email-10-day-heading' => 'Како е, $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Е, па времето лета!  Има веќе 10 дена откако го зпаочнавте викито $WIKINAME.',
	'founderemails-email-10-day-tips-heading' => 'Привлечете учесници и пофалете се со она што сте го сработиле. Еве како да разгласите:',
	'founderemails-email-10-day-share-heading' => 'Зар не ви кажа мама дека треба да делите со другите?',
	'founderemails-email-10-day-share-content' => 'Користете го копчето „Сподели“ во алатникот, статиите и сликите за да им ги покажете на пријателите и оние што ве следат на Facebook, Twitter и другите популарни места.',
	'founderemails-email-10-day-email-heading' => 'Искористете ја моќта на е-поштата.',
	'founderemails-email-10-day-email-content' => 'Испратете им е-пошта на познатите што би ги интересирала вашата тематика или што ќе сакаат да ви помогнат (како другар, колега и сл.) Можете да испраќате и поединечни слики од вашето вики, преку копчето за е-пошта',
	'founderemails-email-10-day-join-heading' => 'Здружете се со слични мреж. места',
	'founderemails-email-10-day-join-content' => 'Побарајте помош од други форуми и мрежни места посветени на вашата тематика и прашајте го администраторот дали е заинтересиран за споделување на врски &mdash; врска до вашето вики на нивната страица и врска до нивната страница на вашето вики.',
	'founderemails-email-10-day-wikiahelps-text' => 'Можете да побарате помош и од другите викијанци на форумите на <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Продолжете така!<br />Екипата на Викија',
	'founderemails-email-views-digest-subject' => 'Денешни посети на $WIKINAME',
	'founderemails-email-views-digest-body' => 'Здраво $FOUNDERNAME,

Денес $WIKINAME ја посетија # луѓе.

Продолжете и понатаму да додавате содржини и да го промовирате викито - така ќе ги поттикнете луѓето да читаат, уредуваат и да разгласуваат.

Екипата на Викија',
	'founderemails-email-views-digest-greeting' => 'Здраво $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Денес $WIKINAME го посетија $UNIQUEVIEWS лица.',
	'founderemails-email-views-digest-content' => 'Продолжете да додавате нови содржини и да го промовирате викито за да поттикнете што повеќе читатели и уредници, и за да се расчуе за викито.',
	'founderemails-email-views-digest-signature' => 'Екипата на Викија',
	'founderemails-email-views-digest-button' => 'Додај уште страници',
	'founderemails-email-complete-digest-subject' => 'Најнови збиднувања на $WIKINAME',
	'founderemails-email-complete-digest-body' => 'Здраво $FOUNDERNAME,

Време е за дневниот преглед на збиднувањата на $WIKINAME.

Викито го посетиле $UNIQUEVIEWS лица.

Продолжете така, и додавајте интересни содржини за читателите!

Извршени се $USEREDITS уредувања.

Задоволни уредници создаваат пријатни викија. Не заборавајте да им се заблагодарите на уредниците и од време на време да проверите дали им треба нешто.

На викито се зачлениле $USERJOINS корисници.

Посакајте им добредојде на новодојдените со пораки на страниците за разговор.

Секогаш можете да појдете на страницата „Активности на викито“ за да ги погледате интересните збиднувања и измените на $WIKINAME. Проверовајте често - како основач, должни сте да ги водите корисниците, да им помагате и да раководите со викито.

Екипата на Викија',
	'founderemails-email-complete-digest-greeting' => 'Здраво $FOUNDERNAME,',
	'founderemails-email-complete-digest-headline' => 'Време е за дневната доза на збиднувања на $WIKINAME.',
	'founderemails-email-complete-digest-content-heading1' => 'Вашето вики го посетиле $UNIQUEVIEWS лица.',
	'founderemails-email-complete-digest-content1' => 'Продолжете со одличната работа и понатаму додавајте интересни содржини за читателите!',
	'founderemails-email-complete-digest-content-heading2' => 'Извршени се $USEREDITS уредувања.',
	'founderemails-email-complete-digest-content2' => 'Задоволните уредници создаваат убави викија. Не заборавајте да им се заблагодарите на уредниците и од време на време да проверите дали им треба нешто.',
	'founderemails-email-complete-digest-content-heading3' => 'На вашето вики се зачленија $USERJOINS лица.',
	'founderemails-email-complete-digest-content3' => 'Посакувајте им добредојде на новодојенците со порака на страницата за разговор.
<br /><br />
Секогаш можете да појдете на „Активности на викито“ и да ги подледате сите интересни промени што се вршат на $WIKINAME. Проварувајте често. Како основач на заедницата, вие сте должни да ги водите корисниците, да им помагате, и да раководите со викито.',
	'founderemails-email-complete-digest-signature' => 'Екипата на Викија',
	'founderemails-email-complete-digest-button' => 'Оди на Активности на викито',
	'founderemails-pref-joins' => 'Извести ме по е-пошта кога некој ќе се зачлени на $1',
	'founderemails-pref-edits' => 'Извести ме по е-пошта кога некој ќе изврши уредување на $1',
	'founderemails-pref-views-digest' => 'Еднаш дневно известувај ме по е-пошта колку пати е посетен $1',
	'founderemails-pref-complete-digest' => 'Испраќај ми збирен преглед на збиднувањата на $1 еднаш дневно',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'founderemails-email-0-day-addpages-heading' => 'താളുകൾ ചേർക്കുക.',
	'founderemails-email-0-day-addpages-button' => 'താൾ ചേർക്കുക',
	'founderemails-email-0-day-addphotos-heading' => 'ഫോട്ടോകൾ ചേർക്കുക.',
	'founderemails-email-0-day-addphotos-button' => 'ഒരു ഫോട്ടോ ചേർക്കുക',
	'founderemails-email-0-day-customizetheme-button' => 'ഇച്ഛാനുസരണമാക്കുക',
	'founderemails-email-3-day-addphotos-heading' => 'ഇനിയും കൂടുതൽ ഫോട്ടോകൾ ചേർക്കുക.',
	'founderemails-email-3-day-addphotos-button' => 'ഫോട്ടോകൾ ചേർക്കുക',
	'founderemails-email-3-day-explore-heading' => 'പ്രചോദനം കണ്ടെത്തുക.',
	'founderemails-email-10-day-join-heading' => 'സമാന വെബ്സൈറ്റുകളുമായി ചേരുക.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'founderemails-desc' => 'Membantu memaklumkan pengasas mengenai perubahan pada wikinya',
	'tog-founderemailsenabled' => 'E-melkan perkembangan kegiatan orang lain kepada saya (pengasas sahaja)',
	'founderemails-email-user-registered-subject' => 'Ada orang baru di $WIKINAME',
	'founderemails-email-user-registered-body' => 'Apa khabar $FOUNDERNAME,

Syabas! $USERNAME baru menyertai $WIKINAME.

Ambillah peluang ini untuk menyambut kedatangannya ke wiki anda serta menggalakkannya supaya tolong menyunting. Makin ramai makin meriah, dan makin pesatlah perkembangan wiki anda.

Pasukan Wikia',
	'founderemails-email-user-registered-greeting' => 'Apa khabar $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Syabas! $USERNAME baru menyertai $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Ambillah peluang ini untuk menyambut kedatangannya ke wiki anda serta menggalakkannya supaya tolong menyunting. Makin ramai makin meriah, dan makin pesatlah perkembangan wiki anda.',
	'founderemails-email-user-registered-signature' => 'Pasukan Wikia',
	'founderemails-email-user-registered-button' => 'Sambut Mereka',
	'founderemails-email-user-registered-body-HTML' => 'Hai $FOUNDERNAME,<br /><br />
Nampaknya $USERNAME sudah berdaftar di wki anda! Apa kata tuan/puan ke <a href="$USERTALKPAGEURL">laman perbincangannya</a> untuk beramah mesra?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Pasukan Wikia</div>',
	'founderemails-email-0-days-passed-subject' => 'Selamat Datang ke Wikia!',
	'founderemails-email-0-days-passed-body' => 'Tahniah kerana mencipta $WIKINAME - anda sudah menyertai komuniti Wikia!

-- Pasukan Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Tahniah kerana mencipta <strong>$WIKINAME</strong> - anda sudah menyertai komuniti Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Pasukan Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Mendaftar masuk',
	'founderemails-email-3-days-passed-body' => 'Apa khabar $FOUNDERNAME,

Memandangkan anda sudah membuka wiki beberapa hari lalu, apa kata anda cuba perkara-perkara lain yang boleh anda buat.

--Pasukan Wikia',
	'founderemails-email-3-days-passed-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />
Memandangkan anda sudah membuka wiki beberapa hari lalu, apa kata anda cuba perkara-perkara lain yang boleh anda buat.<br /><br />
<div style="font-style: italic; font-size: 120%;">--Pasukan Wikia</div>',
	'founderemails-email-10-days-passed-subject' => 'Apa khabar di wiki anda?',
	'founderemails-email-10-days-passed-body' => 'Apa khabar $FOUNDERNAME,

Memandangkan anda membuka wiki di Wikia tidak lama dahulu, semoga wiki anda itu berjalan dengan lancar. Kami ingin berkongsi sedikit petua lagi untuk menceriakan lagi suasana di wiki anda.

-- Pasukan Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME ada suntingan baru!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Apa khabar $FOUNDERNAME,

Bagus! $USERNAME telah melakukan suntingan sulungnya di $WIKINAME.

Pergi ke $PAGETITLE untuk melihat perubahan yang dibuatnya.

Pasukan Wikia',
	'founderemails-email-first-edit-greeting' => 'Apa khabar $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => 'Bagus! $USERNAME telah melakukan suntingan sulungnya di $WIKINAME.',
	'founderemails-email-first-edit-content' => 'Pergi ke $PAGETITLE untuk melihat perubahan yang dibuatnya.',
	'founderemails-email-first-edit-signature' => 'Pasukan Wikia',
	'founderemails-email-first-edit-button' => 'Tengok!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />
Nampaknya ada seorang pengguna berdaftar yang bernama $USERNAME yang menyunting wiki anda buat kali pertama! Apa kata anda singgah di <a href="$USERTALKPAGEURL">laman perbincangannya</a> untuk bersalaman?<br /><br />
<div style="font-style: italic; font-size: 120%;">--Pasukan Wikia</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Suntingan baru di $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Apa khabar $FOUNDERNAME,

$USERNAME telah melakukan satu lagi suntingan pada laman $PAGETITLE di $WIKINAME.

Pergi ke $PAGETITLE untuk melihat perubahan yang dibuatnya.

Pasukan Wikia',
	'founderemails-email-general-edit-greeting' => 'Apa khabar $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => '$USERNAME telah melakukan satu lagi suntingan pada laman $PAGETITLE di $WIKINAME.',
	'founderemails-email-general-edit-content' => 'Pergi ke $PAGETITLE untuk melihat perubahan yang dibuatnya.',
	'founderemails-email-general-edit-signature' => 'Pasukan Wikia',
	'founderemails-email-general-edit-button' => 'Tengok!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />

Nampaknya ada seorang pengguna berdaftar yang bernama $USERNAME yang menyunting wiki anda! Apa kata anda singgah di <a href="$USERTALKPAGEURL">laman perbincangannya</a> untuk bersalaman?<br /><br />
<div style="font-style: italic; font-size: 120%;">--Pasukan Wikia</div>',
	'founderemails-email-page-edited-anon-subject' => '$WIKINAME disunting oleh teman yang misteri',
	'founderemails-email-page-edited-anon-body' => 'Apa khabar $FOUNDERNAME,

Seorang Penyumbang Wikia baru melakukan suntingan pada laman $PAGETITLE di $WIKINAME.

Penyumbang Wikia merupakan pihak yang melakukan suntingan tanpa log masuk dengan akaun Wikia. Pergi tengok apa yang ditokok oleh teman misteri ini!

Pasukan Wikia',
	'founderemails-email-anon-edit-greeting' => 'Apa khabar $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'Seorang Penyumbang Wikia baru melakukan suntingan pada laman $PAGETITLE di $WIKINAME.',
	'founderemails-email-anon-edit-content' => 'Penyumbang Wikia merupakan pihak yang melakukan suntingan tanpa log masuk dengan akaun Wikia. Pergi tengok apa yang ditokok oleh teman misteri ini!',
	'founderemails-email-anon-edit-signature' => 'Pasukan Wikia',
	'founderemails-email-anon-edit-button' => 'Tengok!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />
Nampaknya wiki anda telah disunting oleh seseorang! Apa anda anda <a href="$MYHOMEURL">jenguk di situ</a> untuk melihat perubahannya?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Pasukan Wikia</div>',
	'founderemails-answers-email-user-registered-subject' => 'Ada orang mendaftarkan akaun di wiki QA anda!',
	'founderemails-answers-email-user-registered-body' => 'Apa khabar $FOUNDERNAME,

Nampaknya $USERNAME telah berdaftar di wiki anda! Apa kata anda singgah di laman perbincangannya ($USERTALKPAGEURL) untuk bersalaman?

--Pasukan Wikia',
	'founderemails-answers-email-user-registered-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />
Nampaknya $USERNAME telah berdaftar di wiki anda! Apa kata anda singgah di <a href="$USERTALKPAGEURL">laman perbincangannya</a> untuk bersalaman?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Pasukan Wikia</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Selamat datang ke Wikia QA!',
	'founderemails-answers-email-0-days-passed-body' => 'Syabas kerana membuka $WIKINAME, kini anda menyertai komuniti Wikia!

-- Pasukan Wikia',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Syabas kerana membuka <strong>$WIKINAME</strong>, kini anda menyertai komuniti Wikia!
<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Pasukan Wikia</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Mendaftar masuk',
	'founderemails-answers-email-3-days-passed-body' => 'Apa khabar $FOUNDERNAME,

Memandangkan anda sudah membuka wiki beberapa hari lalu, apa kata anda cuba perkara-perkara lain yang boleh anda buat.

--Pasukan Wikia',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />
Memandangkan anda sudah membuka wiki beberapa hari lalu, apa kata anda cuba perkara-perkara lain yang boleh anda buat.<br /><br />
<div style="font-style: italic; font-size: 120%;">--Pasukan Wikia</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Apa khabar dengan wiki anda?',
	'founderemails-answers-email-10-days-passed-body' => 'Apa khabar $FOUNDERNAME,

Memandangkan anda membuka wiki di Wikia tidak lama dahulu, semoga wiki anda itu berjalan dengan lancar. Kami ingin berkongsi sedikit petua lagi untuk menceriakan lagi suasana di wiki anda.

-- Pasukan Wikia',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />
Memandangkan anda membuka wiki di Wikia tidak lama dahulu, semoga wiki anda itu berjalan dengan lancar. Kami ingin berkongsi sedikit petua lagi untuk menceriakan lagi suasana di wiki anda.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Pasukan Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Pengguna berdaftar mengubah tapak anda buat kali pertama!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Apa khabar $FOUNDERNAME,

Nampaknya ada seorang pengguna berdaftar yang bernama $USERNAME yang menyunting wiki anda buat kali pertama! Apa kata anda singgah di laman perbincangannya ($USERTALKPAGEURL) untuk bersalaman?

--Pasukan Wikia',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />
Nampaknya ada seorang pengguna berdaftar yang bernama $USERNAME yang menyunting wiki anda buat kali pertama! Apa kata anda singgah di <a href="$USERTALKPAGEURL">laman perbincangannya</a> untuk bersalaman?<br /><br />
<div style="font-style: italic; font-size: 120%;">--Pasukan Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Tapak anda disunting oleh pengguna berdaftar!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Apa khabar $FOUNDERNAME,

Nampaknya ada seorang pengguna berdaftar yang bernama $USERNAME yang menyunting wiki anda! Apa kata anda singgah di laman perbincangannya ($USERTALKPAGEURL) untuk bersalaman?

--Pasukan Wikia',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />

Nampaknya ada seorang pengguna berdaftar yang bernama $USERNAME yang menyunting wiki anda! Apa kata anda singgah di <a href="$USERTALKPAGEURL">laman perbincangannya</a> untuk bersalaman?<br /><br />
<div style="font-style: italic; font-size: 120%;">--Pasukan Wikia</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Tapak anda telah disunting oleh orang lain!',
	'founderemails-answers-email-page-edited-anon-body' => 'Apa khabar $FOUNDERNAME,

Nampaknya anda seseorang yang telah menyunting wiki anda! Apa anda anda jenguk $MYHOMEURL untuk melihat perubahannya?

-- Pasukan Wikia',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Apa khabar $FOUNDERNAME,<br /><br />
Nampaknya anda seseorang yang telah menyunting wiki anda! Apa anda anda <a href="$MYHOMEURL">jenguk di situ</a> untuk melihat perubahannya?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Pasukan Wikia</div>',
	'founderemails-lot-happening-subject' => '$WIKINAME sangat rancak hari ini!',
	'founderemails-lot-happening-body' => 'Apa khabar $FOUNDERNAME,

Syabas! Hangatnya kegiatan di $WIKINAME hari ini!

Anda boleh pergi ke Kegiatan Wiki Activity untuk melihat segala perkara-perkara hebat yang telah berlaku.

Disebabkan sebegitu banyak yang berlaku, anda mungkin juga ingin menukar keutamaan e-mel kepada mod ringkasan. Dengan mod ini, anda akan menerima satu e-mel sahaja yang menyeranaikan segala aktiviti di wiki anda setiap hari.

Pasukan Wikia',
	'founderemails-lot-happening-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Wiki anda memang meriah hari ini! Sila bersinggah di $MYHOMEURL untuk melihat apa yang berlaku.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Pasukan Wikia</div>',
	'founderemails-email-lot-happening-greeting' => 'Apa khabar $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => 'Syabas! Banyak perkara yang berlaku di $WIKINAME hari ini!',
	'founderemails-email-lot-happening-content' => 'Disebabkan sebegitu banyak yang berlaku, anda mungkin juga ingin menukar keutamaan e-mel kepada mod ringkasan. Dengan mod ini, anda akan menerima satu e-mel sahaja yang menyeranaikan segala aktiviti di wiki anda setiap hari.',
	'founderemails-email-lot-happening-signature' => 'Pasukan Wikia',
	'founderemails-email-lot-happening-button' => 'Lihat Kegiatan',
	'founderemails-email-footer-line1' => 'Untuk melihat perkembangan terbaru di Wikia, kunjungi <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Ingin mengawal e-mel yang anda terima? Pergi ke [{{fullurl:{{ns:special}}:Preferences}} Keutamaan] anda',
	'founderemails-email-0-day-heading' => 'Selamat berkenalan, $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Syabas kerana mencipta $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Berikut ialah petua-petua berguna untuk membantu anda bermula:',
	'founderemails-email-0-day-addpages-heading' => 'Tambahkan laman.',
	'founderemails-email-0-day-addpages-content' => 'Anda boleh berkongsi maklumat tentang topik kegemaran anda dengan menggunakan wiki. Cipta laman dengan mengklik  <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">"Cipta Laman Baru"</a> dan isikan maklumat terperinci tentang topik anda itu.',
	'founderemails-email-0-day-addpages-button' => 'Cipta Laman Baru',
	'founderemails-email-0-day-addphotos-heading' => 'Sisipkan gambar.',
	'founderemails-email-0-day-addphotos-content' => 'Setiap laman pasti lebih menarik jika ada gambar! Sisipkan gambar pada laman-laman anda, termasuk laman utama. Anda boleh mengklik <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"Bubuh Gambar"</a> untuk membubuh gambar, galeri gambar atau tayangan slaid.',
	'founderemails-email-0-day-addphotos-button' => 'Bubuh Gambar',
	'founderemails-email-0-day-customizetheme-heading' => 'Ubah suai tema anda.',
	'founderemails-email-0-day-customizetheme-content' => 'Ubah suai tema wiki dan tanda kata anda supaya wiki anda menonjol! Gunakan <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Pereka Tema</a> untuk menambahkan warna-warna ubahsuai anda ke dalam wiki anda supaya kelihatan unik kepada topik anda.',
	'founderemails-email-0-day-customizetheme-button' => 'Ubah suai',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">Kami tak akan biarkan anda tersisih begitu saja.</span> Kami nak bantu anda menjayakan $WIKINAME langkah demi langkah.  Kunjungi <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> untuk berbincang dalam forum, mendapat nasihat dan bantuan, ataupun <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">e-melkan</a> soalan anda kepada kami!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Selamat membina wiki!<br />Pasukan Wikia',
	'founderemails-email-3-day-heading' => 'Apa khabar $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Kami datang ke sini untuk melihat perkembangan di $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Sudah 3 hari sejak anda bermula, jadi kami rasa hendak bersinggah di sini untuk memberikan sedikit lagi petua untuk membina wiki anda:',
	'founderemails-email-3-day-editmainpage-heading' => 'Ceriakan halaman utama anda.',
	'founderemails-email-3-day-editmainpage-content' => 'Laman utama merupakan antara perkara pertama yang dilihat oleh sesiapa yang mengunjungi <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>.  Pastikan tanggapan awal mereka memuaskan dengan menuliskan ringkasan terperinci mengenai topik anda, serta menambahkan tayangan slaid, galeri atau gelangsar gambar.',
	'founderemails-email-3-day-editmainpage-button' => 'Ceriakan',
	'founderemails-email-3-day-addphotos-heading' => 'Tambahkan lagi gambar.',
	'founderemails-email-3-day-addphotos-content' => 'Satu cara yang terbaik untuk menceriakan laman-laman anda adalah <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"meletakkan gambar"</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Sisipkan Gambar',
	'founderemails-email-3-day-explore-heading' => 'Cari ilham.',
	'founderemails-email-3-day-explore-content' => 'Jangan berasa segan untuk melihat bagaimana wiki lain mengusahakan laman utama, laman rencana dan lain-lain. Berikut ialah antara pilihan kami: <a style="color:#2a87d5;text-decoration:none;" href="http://muppets.wikia.com">Muppet Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://poptarts.wikia.com">Pop Tarts Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://monsterhigh.wikia.com">Monster High Wiki</a>.',
	'founderemails-email-3-day-explore-button' => 'Jelajah',
	'founderemails-email-3-day-wikiahelps-text' => 'Perlukan bantuan untuk mengetahui fungsi sesuatu? Kami sentiasa di sisi anda! Sila tanya kami untuk bantuan dan nasihat di <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Teruskan usaha anda!<br />Pasukan Wikia',
	'founderemails-email-10-day-heading' => 'Apa khabar, $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Wah, cepatnya masa berlalu! Sudah 10 hari sejak anda membuka $WIKINAME.',
	'founderemails-email-10-day-tips-heading' => 'Jemput orang lain untuk melibatkan diri dalam projek anda dan tunjukkan segala kerja hebat yang anda usahakan selama ini. Berikut ialah beberapa cara untuk menghebahkan wiki anda:',
	'founderemails-email-10-day-share-heading' => 'Ingat tak pesan orang tua supaya Berkongsi?',
	'founderemails-email-10-day-share-content' => 'Tekan butang Kongsi di bar alatan, laman rencana dan gambar anda untuk ditunjukkan kepada rakan-rakan dan pengikut-pengikut di Facebook, Twitter, atau tapak-tapak sosial yang lain,',
	'founderemails-email-10-day-email-heading' => 'Manfaatkan kuasa e-mel.',
	'founderemails-email-10-day-email-content' => 'E-mel kenalan-kenalan anda yang meminati topik anda atau berminat untuk membantu anda, seperti kawan dari sekolah atau rakan sekerja. Anda juga boleh menge-melkan gambar-gambar tertentu daripada wiki anda dengan menggunakan butang e-mel',
	'founderemails-email-10-day-join-heading' => 'Sertai tapak-tapak web yang serupa.',
	'founderemails-email-10-day-join-content' => 'Minta bantuan ahli forum atau tapak web lain yang berkenaan topik anda dengan membuat posting dalam forum atau ulasan. Jika boleh, hubungi pihak pentadbiran untuk melihat sama ada mereka berminat untuk berkongsi pautan &mdash; mereka akan membuat pautan wiki anda pada tapak web mereka jika anda meletakkan pautan mereka pada wiki anda.',
	'founderemails-email-10-day-wikiahelps-text' => 'Anda juga boleh meminta bantuan ahli Wikia yang lain untuk membantu mengusahakan wiki anda dengan mengepos di dalam forum di <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Teruskan usaha anda!<br />Pasukan Wikia',
	'founderemails-email-views-digest-subject' => 'Kunjungan hari ini di $WIKINAME',
	'founderemails-email-views-digest-body' => 'Apa khabar $FOUNDERNAME,

Hari ini, $WIKINAME dikunjungi oleh # orang.

Teruskan mengisikan kandungan baru dan mempromosikan wiki anda untuk menggalakkan lebih ramai orang untuk membaca, menyunting dan menyebarkan khabar.

Pasukan Wikia',
	'founderemails-email-views-digest-greeting' => 'Apa khabar $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Hari ini, $WIKINAME dikunjungi oleh # orang.',
	'founderemails-email-views-digest-content' => 'Teruskan mengisikan kandungan baru dan mempromosikan wiki anda untuk menggalakkan lebih ramai orang untuk membaca, menyunting dan menyebarkan khabar.',
	'founderemails-email-views-digest-signature' => 'Pasukan Wikia',
	'founderemails-email-views-digest-button' => 'Tambahkan lagi laman',
	'founderemails-email-complete-digest-subject' => 'Kegiatan terkini di $WIKINAME',
	'founderemails-email-complete-digest-body' => 'Apa khabar $FOUNDERNAME,

Masa untuk intisari kegiatan harian anda dari $WIKINAME.

$UNIQUEVIEWS orang mengunjungi wiki anda.

Teruskan usaha mengisikan kandungan yang menarik untuk tatapan pembaca!

$USEREDITS suntingan dilakukan.

Penyunting gembira, wiki pun ceria. Jangan lupa berterima kasih kepada para penyunting dan bertegur sapa dengan mereka dari masa ke semasa.

$USERJOINS orang menyertai wiki anda.

Alu-alukan kedatangan orang baru ke wiki anda dengan pesanan di laman perbincangan.

Anda boleh sentiasa pergi ke Kegiatan Wiki untuk melihat semua perubahan yang dilakukan di $WIKINAME. Sila datang selalu, kerana komuniti memandang tinggi anda sebagai pengasas untuk membantu membimbing dan menjalankan wiki.

Pasukan Wikia',
	'founderemails-email-complete-digest-greeting' => 'Apa khabar $FOUNDERNAME,',
	'founderemails-email-complete-digest-headline' => 'Masa untuk intisari kegiatan harian anda dari $WIKINAME.',
	'founderemails-email-complete-digest-content-heading1' => '$UNIQUEVIEWS orang mengunjungi wiki anda.',
	'founderemails-email-complete-digest-content1' => 'Teruskan usaha mengisikan kandungan yang menarik untuk tatapan pembaca!',
	'founderemails-email-complete-digest-content-heading2' => '$USEREDITS suntingan dilakukan.',
	'founderemails-email-complete-digest-content2' => 'Penyunting gembira, wiki pun ceria. Jangan lupa berterima kasih kepada para penyunting dan bertegur sapa dengan mereka dari masa ke semasa.',
	'founderemails-email-complete-digest-content-heading3' => '$USERJOINS orang menyertai wiki anda.',
	'founderemails-email-complete-digest-content3' => 'Alu-alukan kedatangan orang baru ke wiki anda dengan pesanan di laman perbincangan.
<br /><br />
Anda boleh sentiasa pergi ke Kegiatan Wiki untuk melihat semua perubahan yang dilakukan di $WIKINAME. Sila datang selalu, kerana komuniti memandang tinggi anda sebagai pengasas untuk membantu membimbing dan menjalankan wiki.',
	'founderemails-email-complete-digest-signature' => 'Pasukan Wikia',
	'founderemails-email-complete-digest-button' => 'Pergi ke kegiatan wiki',
	'founderemails-pref-joins' => 'E-mel saya apabila ada orang yang menyertai $1',
	'founderemails-pref-edits' => 'E-mel saya apabila ada orang yang menyunting $1',
	'founderemails-pref-views-digest' => 'Hantar e-mel harian kepada saya untuk memaklumkan saya berapa kali $1 dikunjungi',
	'founderemails-pref-complete-digest' => 'Hantar ringkasan kegiatan harian di $1 kepada saya',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 * @author Tjcool007
 */
$messages['nl'] = array(
	'founderemails-desc' => 'Informeert oprichters over wijzigingen in hun wiki',
	'tog-founderemailsenabled' => 'Mij informatie mailen over wat andere gebruikers doen (alleen voor oprichters)',
	'founderemails-email-user-registered-subject' => 'Iemand heeft een gebruiker geregistreerd op $WIKINAME!',
	'founderemails-email-user-registered-body' => 'Hallo $FOUNDERNAME,

Gefeliciteerd! $USERNAME heeft zich geregistreerd bij $WIKINAME.

Maak gebruik van deze kans om de gebruiker welkom te heten en te motiveren om in uw wiki te blijven bewerken. Hoe meer gebruikers hoe beter, en hoe sneller uw wiki groeit.

Het Wikia-team',
	'founderemails-email-user-registered-greeting' => 'Hallo $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Gefeliciteerd! $USERNAME heeft zich aangemeld bij $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Maak gebruik van de gelegenheid om de gebruiker te verwelkomen op uw wiki en aan te moedigen om te blijven bewerken. Hoe meer gebruikers hoe beter en hoe sneller uw wiki zal groeien.',
	'founderemails-email-user-registered-signature' => 'Het Wikia-team',
	'founderemails-email-user-registered-button' => 'Heet ze welkom',
	'founderemails-email-user-registered-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
$USERNAME heeft zich geregistreerd bij uw wiki! Waarom gaat u niet even naar de <a href="$USERTALKPAGEURL">overlegpagina</a> van de gebruiker om goedendag te zeggen?

<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-0-days-passed-subject' => 'Welkom bij Wikia!',
	'founderemails-email-0-days-passed-body' => 'Gefeliciteerd met het aanmaken van $WIKINAME. U bent nu onderdeel van de Wikia-gemeenschap!

-- Het Wikia-team',
	'founderemails-email-0-days-passed-body-HTML' => 'Gefeliciteerd met het aanmaken van <strong>$WIKINAME</strong>. U bent nu onderdeel van de Wikia-gemeenschap!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-3-days-passed-subject' => 'Hoe gaat het op uw wiki',
	'founderemails-email-3-days-passed-body' => 'Hallo $FOUNDERNAME,

Nu uw wiki een aantal dagen bestaat, vermoeden we dat u wellicht tips wilt hebben over andere dingen die u kunt doen.

-- Het Wikia-team',
	'founderemails-email-3-days-passed-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Nu uw wiki een aantal dagen bestaat, vermoeden we dat u wellicht tips wilt hebben over andere dingen die u kunt doen.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-10-days-passed-subject' => 'Hoe gaat het met uw wiki?',
	'founderemails-email-10-days-passed-body' => 'Hallo $FOUNDERNAME,

Uw Wikia-wiki bestaat nu een tijdje. We hopen dat het fantastisch gaat! We willen een aantal tips met u delen om uw wiki gezellig te maken.

-- Het Wikia-team',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Op $WIKINAME is een nieuwe bewerking gemaakt!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Hallo $FOUNDERNAME,

Gefeliciteerd! De geregistreerde gebruiker $USERNAME heeft uw wiki voor de eerste keer bewerkt!

Ga snel naar $PAGETITLE om de bewerking te bekijken.

Het Wikia-team',
	'founderemails-email-first-edit-greeting' => 'Hallo $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => 'Wow! $USERNAME heeft $WIKINAME voor het eerst bewerkt.',
	'founderemails-email-first-edit-content' => 'Ga naar $PAGETITLE om de wijziging te bekijken.',
	'founderemails-email-first-edit-signature' => 'Het Wikia-team',
	'founderemails-email-first-edit-button' => 'Ga kijken!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />

De geregistreerde gebruiker $USERNAME heeft uw wiki voor de eerste keer bewerkt! Waarom gaat u niet even langs op de <a href="$USERTALKPAGEURL">overlegpagina</a> om goedendag te zeggen?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Nieuwe bewerking op $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Hallo $FOUNDERNAME,

De geregistreerde gebruiker $USERNAME heeft de pagina $PAGETITLE op $WIKINAME bewerkt.

Ga naar $PAGETITLE om de wijziging te bekijken.

Het Wikia-team',
	'founderemails-email-general-edit-greeting' => 'Hallo $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => '$USERNAME heeft weer een bewerking gemaakt op de pagina $PAGETITLE op $WIKINAME.',
	'founderemails-email-general-edit-content' => 'Ga naar $PAGETITLE om de wijziging te bekijken.',
	'founderemails-email-general-edit-signature' => 'Het Wikia-team',
	'founderemails-email-general-edit-button' => 'Ga kijken!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />

De geregistreerde gebruiker $USERNAME heeft uw wiki bewerkt. Waarom gaat u niet even langs op de <a href="$USERTALKPAGEURL">overlegpagina</a> om goedendag te zeggen?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-page-edited-anon-subject' => 'Een mysterieuze vriend heeft $WIKINAME bewerkt',
	'founderemails-email-page-edited-anon-body' => 'Hallo $FOUNDERNAME,

Een Wikiagebruiker heeft de pagina $PAGETITLE op $WIKINAME bewerkt.

Wikiagebruikers zijn mensen die wijzigen maken zonder aan te melden. Ga snel kijken wat deze mysterieuze vriend heeft toegevoegd!

Het Wikia-team',
	'founderemails-email-anon-edit-greeting' => 'Hallo $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'Een Wikia-gebruiker heeft de pagina $PAGETITLE op $WIKINAME bewerkt.',
	'founderemails-email-anon-edit-content' => 'Wikia-gebruikers zijn mensen die bewerkingen maken zonder aan te melden met een Wikia-gebruiker. Ga snel kijken wat onze mysterieuze vriend heeft toegevoegd!',
	'founderemails-email-anon-edit-signature' => 'Het Wikia-team',
	'founderemails-email-anon-edit-button' => 'Ga kijken!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />

Het ziet ernaar uit dat iemand uw wiki heeft bewerkt! Waarom gaat u niet even kijken <a href="$MYHOMEURL">wat er is gewijzigd</a>?<br /><br />

<div style="font-style: italic; font-size: 120%;">Het Wikia-team</div>',
	'founderemails-answers-email-user-registered-subject' => 'Iemand heeft zich geregistreerd op uw QA-wiki!',
	'founderemails-answers-email-user-registered-body' => 'Hallo $FOUNDERNAME,

De gebruiker $USERNAME heeft zich geregistreerd op uw wiki! Waarom zegt u niet even goedendag op de overlegpagina? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-answers-email-user-registered-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
De gebruiker $USERNAME heeft zich geregistreerd op uw wiki! Waarom zegt u niet even goedendag op de <a href="$USERTALKPAGEURL">overlegpagina</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Welkom bij QA Wikia!',
	'founderemails-answers-email-0-days-passed-body' => 'Gefeliciteerd met het aanmaken van $WIKINAME. U bent nu lid van de Wikia-gemeenschap!

-- Het Wikia-team',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Gefeliciteerd met het aanmaken van <strong>$WIKINAME</strong>. U bent nu lid van de Wikia-gemeenschap!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Even contact houden',
	'founderemails-answers-email-3-days-passed-body' => 'Hallo $FOUNDERNAME,

Nu uw wiki een aantal dagen bestaat, dachten we dat het misschien een goed idee was als u eens ging kijken wat u allemaal kan doen.

-- Het Wikia-team',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Nu uw wiki een aantal dagen bestaat, dachten we dat het misschien een goed idee was als u eens ging kijken wat u allemaal kan doen.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Hoe gaat het met uw wiki?',
	'founderemails-answers-email-10-days-passed-body' => 'Hallo $FOUNDERNAME,

Het is al weer even geleden sinds uw u wiki aangemaakt hebt bij Wikia. We hopen dat het fantastisch gaat! We willen graag een paar laatste details met u delen om uw wiki verder te kunnen vormgeven.

-- Het Wikia-team',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Het is al weer even geleden sinds uw u wiki aangemaakt hebt bij Wikia. We hopen dat het fantastisch gaat! We willen graag een paar laatste details met u delen om uw wiki verder te kunnen vormgeven.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Een gebruiker heeft voor de eerste keer uw site gewijzigd!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Hallo $FOUNDERNAME,

De geregistreerde gebruiker $USERNAME heeft uw wiki voor de eerste keer gewijzigd! Waarom laat u niet even een berichtje achter op de overlegpagina? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
De geregistreerde gebruiker $USERNAME heeft uw wiki voor de eerste keer gewijzigd! Waarom laat u niet even een berichtje achter op de <a href="$USERTALKPAGEURL">overlegpagina</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Een gebruiker heeft uw site gewijzigd!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Hallo $FOUNDERNAME,

Het lijkt erop dat de geregistreerde gebruiker $USERNAME uw wiki heeft bewerkt! Waarom laat u geen bericht achter op de overlegpagina van $USERNAME? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Het lijkt erop dat de geregistreerde gebruiker $USERNAME uw wiki heeft bewerkt! Waarom laat u geen bericht achter op de <a href="$USERTALKPAGEURL">overlegpagina van $USERNAME</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Iemand heeft uw site gewijzigd!',
	'founderemails-answers-email-page-edited-anon-body' => 'Hallo $FOUNDERNAME,

Het lijkt erop dat iemand uw wiki heeft bewerkt! Waarom gaat u niet even kijken wat er is veranderd? $MYHOMEURL

-- Het Wikia-team',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Het lijkt erop dat iemand uw wiki heeft bewerkt! Waarom gaat u niet even kijken <a href="$MYHOMEURL">wat er is veranderd</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-lot-happening-subject' => 'Er gebeurt veel op $WIKINAME!',
	'founderemails-lot-happening-body' => 'Hallo $FOUNDERNAME.

Gefeliciteer! Er gebeurt veel op $WIKINAME vandaag.

Als u niet al hebt gekeken, kunt u op Wikiactiviteit zien wat er allemaal is gedaan.

Omdat er zoveel gebeurt, wilt u misschien ook wel uw e-mailvoorkeuren aanpassen naar verzamelmodus. In verzamelmodus ontvangt u iedere dag in een enkele e-mail een lijst met alles dat er in uw wiki is gebeurd.

Het Wikia-team',
	'founderemails-lot-happening-body-HTML' => 'Hallo $FOUNDERNAME,<br /><br />
Er gebeurt veel op uw wiki vandaag! Kom naar $MYHOMEURL om te kijken wat er allemaal gebeurt.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-lot-happening-greeting' => 'Hallo $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => 'Gefeliciteerd! Er is veel gaande op $WIKINAAM vandaag!',
	'founderemails-email-lot-happening-content' => 'Als u niet al hebt gekeken, kunt u op Wikiactiviteit zien wat er allemaal is gedaan. Omdat er zoveel gebeurt, wilt u misschien ook wel uw e-mailvoorkeuren aanpassen naar verzamelmodus. In verzamelmodus ontvangt u iedere dag in een enkele e-mail een lijst met alles dat er in uw wiki is gebeurd.',
	'founderemails-email-lot-happening-signature' => 'Het Wikia-team',
	'founderemails-email-lot-happening-button' => 'Activiteiten bekijken',
	'founderemails-email-footer-line1' => 'Ga naar <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> om de laatste ontwikkelingen bij Wikia te volgen',
	'founderemails-email-footer-line2' => 'Wilt u bepalen welke e-mails u krijgt? Ga naar uw [{{fullurl:{{ns:special}}:Preferences}} voorkeuren]',
	'founderemails-email-0-day-heading' => 'Goed u te ontmoeten, $FOUNDERNAME.',
	'founderemails-email-0-day-congratulations' => 'Gefeliciteerd met het aanmaken van $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Hier zijn een paar nuttige tips om u snel op weg te helpen:',
	'founderemails-email-0-day-addpages-heading' => "Pagina's toevoegen.",
	'founderemails-email-0-day-addpages-content' => 'In een wiki draait alles om het delen van informatie; in dit geval over uw unieke onderwerp. Maak pagina\'s aan door te klikken op "<a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">Pagina toevoegen</a>" en voeg nog meer gegevens over uw onderwerp toe.',
	'founderemails-email-0-day-addpages-button' => 'Pagina toevoegen',
	'founderemails-email-0-day-addphotos-heading' => 'Afbeeldingen toevoegen.',
	'founderemails-email-0-day-addphotos-content' => 'Pagina\'s zien er altijd beter uit als ze visueel zijn! Voeg afbeeldingen toe aan uw pagina\'s en aan uw hoofdpagina. U kunt klikken op "<a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">Afbeelding toevoegen</a>" om een afbeelding, galerij of diavoorstelling toe te voegen.',
	'founderemails-email-0-day-addphotos-button' => 'Afbeelding toevoegen',
	'founderemails-email-0-day-customizetheme-heading' => 'Het siteuiterlijk aanpassen.',
	'founderemails-email-0-day-customizetheme-content' => 'Pas het uiterlijk en het woordmerk van uw wiki aan om op te vallen! Gebruik de <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Wizard uiterlijk aanpassen</a> om aangepaste kleuren toe te voegen aan uw wiki en de site precies aan te passen aan uw onderwerp.',
	'founderemails-email-0-day-customizetheme-button' => 'Aanpassen',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">We laten u niet in de kou staan.</span> We zijn hier om u te helpen $WIKINAME succesvol te maken, stap voor stap. Kom langs op <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> voor forums, advies en hulp of <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">e-mail ons</a> uw vragen!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Veel plezier met wikibouwen!<br />Het Wikia-team',
	'founderemails-email-3-day-heading' => 'Hallo $FOUNDERNAME!',
	'founderemails-email-3-day-congratulations' => 'We wilden u even een berichtje sturen om te vragen hoe het gaat met $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Het is nu drie dagen geleden dat u bent begonnen en we denken dat het een goed moment is om u wat tips te geven over het opbouwen van uw wiki:',
	'founderemails-email-3-day-editmainpage-heading' => 'Zorg ervoor dat uw hoofdpagina pakkend is.',
	'founderemails-email-3-day-editmainpage-content' => 'De hoofdpagina is meestal een van de eerste pagina\'s die bezoekers zien als ze langskomen op <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>. Zorg voor een goede eerste indruk door het schrijven van een gedetailleerde samenvatting over uw onderwerp en door een diavoorstelling, galerij of schuifpresentatie toe te voegen.',
	'founderemails-email-3-day-editmainpage-button' => 'Verbeteren',
	'founderemails-email-3-day-addphotos-heading' => 'Voeg nog meer afbeeldingen toe.',
	'founderemails-email-3-day-addphotos-content' => '<a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">Meer afbeeldingen toevoegen</a> is een van de beste manieren om uw pagina\'s op te leuken.',
	'founderemails-email-3-day-addphotos-button' => 'Afbeeldingen toevoegen',
	'founderemails-email-3-day-explore-heading' => 'Inspiratie vinden.',
	'founderemails-email-3-day-explore-content' => 'Wees niet bang om naar andere wiki\'s te kijken. Bekijk goed hoe die hun hoofdpagina hebben opgebouwd, hoe hun pagina\'s eruit zien en meer. Dit zijn onze favorieten: <a style="color:#2a87d5;text-decoration:none;" href="http://muppets.wikia.com">Muppetwiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://poptarts.wikia.com">Pop Tarts-wiki</a> en <a style="color:#2a87d5;text-decoration:none;" href="http://monsterhigh.wikia.com">Monster High-wiki</a>.',
	'founderemails-email-3-day-explore-button' => 'Verkennen',
	'founderemails-email-3-day-wikiahelps-text' => 'Hebt u hulp nodig bij het uitzoeken hoe iets werkt? We zijn er altijd voor u! Vraag ons om hulp en advies via <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Ga vooral door met uw goede werk!<br />Het Wikia-team',
	'founderemails-email-10-day-heading' => 'Hoe gaat het $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Tjonge, jonge, de tijd vliegt. Het is al weer tien dagen geleden dat u $WIKINAME hebt opgericht.',
	'founderemails-email-10-day-tips-heading' => 'Betrek anderen bij uw project en pronk met het fantastische werk dat u hebt verzet! Dit zijn een aantal manieren om uw project bekend te maken:',
	'founderemails-email-10-day-share-heading' => 'Heeft uw moeder u niet verteld dat u moet delen?',
	'founderemails-email-10-day-share-content' => 'Gebruik de knop "Delen" in uw werkbalk, op pagina\'s en afbeeldingen om ze te laten zien aan uw vrienden en volgers op Facebook, Twitter en andere populaire sites.',
	'founderemails-email-10-day-email-heading' => 'Benut de kracht van e-mail.',
	'founderemails-email-10-day-email-content' => 'E-mail andere mensen die geïnteresseerd zijn in uw onderwerp of die u willen helpen, zoals een schoolvriend of een collega. U kunt ook bepaalde afbeeldingen die worden gebruikt in uw wiki e-mailen via de knop "E-mail".',
	'founderemails-email-10-day-join-heading' => 'Werk samen met gelijksoortige websites.',
	'founderemails-email-10-day-join-content' => 'Vraag mensen op andere forums of websites over uw onderwerp om hulp door daar berichten te plaatsen. Neem als het mogelijk is contact op met de beheerders en vraag of ze geïnteresseerd zijn in het uitwisselen van verwijzingen. Zij zetten dan een verwijzing naar uw website op hun website, en andersom.',
	'founderemails-email-10-day-wikiahelps-text' => 'U kunt ook andere Wikianen om hulp bij uw wiki vragen door berichten te plaatsen in de forums op <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Blijf vooral doorgaan met uw goede werk!<br />Het Wikia-team',
	'founderemails-email-views-digest-subject' => 'Bezoekersoverzicht van vandaag voor $WIKINAME',
	'founderemails-email-views-digest-body' => 'Hallo $FOUNDERNAME,

Vandaag is $WIKINAME bekeken door # mensen.

Blijf nieuwe inhoud toevoegen en blijf uw wiki promoten om mensen aan te moedigen te blijven lezen, bewerken en ook weer aan anderen over de wiki te vertellen.

Het Wikia-team',
	'founderemails-email-views-digest-greeting' => 'Hallo $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Vandaag is $WIKINAME bekeken door $UNIQUEVIEWS mensen.',
	'founderemails-email-views-digest-content' => 'Blijf nieuwe inhoud toevoegen en blijf uw wiki promoten om mensen aan te moedigen te blijven lezen, bewerken en ook weer aan anderen over de wiki te vertellen.',
	'founderemails-email-views-digest-signature' => 'Het Wikia-team',
	'founderemails-email-views-digest-button' => "Meer pagina's toevoegen",
	'founderemails-email-complete-digest-greeting' => 'Hallo $FOUNDERNAME,',
	'founderemails-email-complete-digest-button' => 'Naar wiki-activiteit',
	'founderemails-pref-joins' => 'Mij e-mailen als iemand lid wordt van $1',
	'founderemails-pref-edits' => 'Mij e-mailen als iemand $1 bewerkt',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'founderemails-email-user-registered-subject' => 'Iemand heeft een gebruiker geregistreerd op je wiki!',
	'founderemails-email-user-registered-body' => 'Hoi $FOUNDERNAME,

$USERNAME heeft zich geregistreerd bij je wiki! Waarom ga je niet even naar de overlegpagina van de gebruiker om hoi te zeggen? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-email-user-registered-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
$USERNAME heeft zich geregistreerd bij je wiki! Waarom ga je niet even naar de <a href="$USERTALKPAGEURL">overlegpagina</a> van de gebruiker om hoi te zeggen?

<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-0-days-passed-body' => 'Gefeliciteerd met het aanmaken van $WIKINAME. Je bent nu onderdeel van de Wikia-gemeenschap!

-- Het Wikia-team',
	'founderemails-email-0-days-passed-body-HTML' => 'Gefeliciteerd met het aanmaken van <strong>$WIKINAME</strong>. Je bent nu onderdeel van de Wikia-gemeenschap!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-3-days-passed-body' => 'Hoi $FOUNDERNAME,

Nu je wiki een aantal dagen bestaat, vermoeden we dat je wellicht tips wilt hebben over andere dingen die je kunt doen.

-- Het Wikia-team',
	'founderemails-email-3-days-passed-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
Nu je wiki een aantal dagen bestaat, vermoeden we dat je wellicht tips wilt hebben over andere dingen die je kunt doen.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-10-days-passed-subject' => 'Hoe gaat het met je wiki?',
	'founderemails-email-10-days-passed-body' => 'Hoi $FOUNDERNAME,

Je Wikia-wiki bestaat nu een tijdje. We hopen dat het fantastisch gaat! We willen een aantal tips met je delen om je wiki gezellig te maken.

-- Het Wikia-team',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Een geregistreerde gebruiker heeft de eerste wijziging in je wiki aangebracht!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Hoi $FOUNDERNAME,

De geregistreerde gebruiker $USERNAME heeft je wiki voor de eerste keer bewerkt! Waarom ga je niet even langs op de overlegpagina om hoi te zeggen? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />

De geregistreerde gebruiker $USERNAME heeft je wiki voor de eerste keer bewerkt! Waarom ga je niet even langs op de <a href="$USERTALKPAGEURL">overlegpagina</a> om hoi te zeggen?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-page-edited-reg-user-body' => 'Hoi $FOUNDERNAME,

De geregistreerde gebruiker $USERNAME heeft je wiki bewerkt. Waarom ga je niet even langs op de overlegpagina om hoi te zeggen? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />

De geregistreerde gebruiker $USERNAME heeft je wiki bewerkt. Waarom ga je niet even langs op de <a href="$USERTALKPAGEURL">overlegpagina</a> om hoi te zeggen?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-page-edited-anon-subject' => 'Iemand heeft je wiki gewijzigd!',
	'founderemails-email-page-edited-anon-body' => 'Hoi $FOUNDERNAME,

Het ziet ernaar uit dat iemand je wiki heeft bewerkt! Waarom ga je niet even kijken wat er is gewijzigd? $MYHOMEURL

-- Het Wikia-team',
	'founderemails-email-page-edited-anon-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />

Het ziet ernaar uit dat iemand je wiki heeft bewerkt! Waarom ga je niet even kijken <a href="$MYHOMEURL">wat er is gewijzigd</a>?<br /><br />

<div style="font-style: italic; font-size: 120%;">Het Wikia-team</div>',
	'founderemails-answers-email-user-registered-subject' => 'Iemand heeft zich geregistreerd op je QA-wiki!',
	'founderemails-answers-email-user-registered-body' => 'Hoi $FOUNDERNAME,

De gebruiker $USERNAME heeft zich geregistreerd op je wiki! Waarom zeg je niet even hoi op de overlegpagina? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-answers-email-user-registered-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
De gebruiker $USERNAME heeft zich geregistreerd op je wiki! Waarom zeg je niet even hoi op de <a href="$USERTALKPAGEURL">overlegpagina</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-answers-email-0-days-passed-body' => 'Gefeliciteerd met het aanmaken van $WIKINAME. Je bent nu lid van de Wikia-gemeenschap!

-- Het Wikia-team',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Gefeliciteerd met het aanmaken van <strong>$WIKINAME</strong>. Je bent nu lid van de Wikia-gemeenschap!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-3-days-passed-body' => 'Hoi $FOUNDERNAME,

Nu je wiki een aantal dagen bestaat, dachten we dat het misschien een goed idee was als je eens ging kijken wat je allemaal kan doen.

-- Het Wikia-team',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
Nu je wiki een aantal dagen bestaat, dachten we dat het misschien een goed idee was als je eens ging kijken wat je allemaal kan doen.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Hoe gaat het met je wiki?',
	'founderemails-answers-email-10-days-passed-body' => 'Hoi $FOUNDERNAME,

Het is al weer even geleden sinds jij je wiki aangemaakt hebt bij Wikia. We hopen dat het fantastisch gaat! We willen graag een paar laatste details met je delen om je wiki verder te kunnen vormgeven.

-- Het Wikia-team',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
Het is al weer even geleden sinds je je wiki aangemaakt hebt bij Wikia. We hopen dat het fantastisch gaat! We willen graag een paar laatste details met je delen om je wiki verder te kunnen vormgeven.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Een gebruiker heeft voor de eerste keer je site gewijzigd!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Hoi $FOUNDERNAME,

De geregistreerde gebruiker $USERNAME heeft je wiki voor de eerste keer gewijzigd! Waarom laat je niet even een berichtje achter op de overlegpagina? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
De geregistreerde gebruiker $USERNAME heeft je wiki voor de eerste keer gewijzigd! Waarom laat je niet even een berichtje achter op de <a href="$USERTALKPAGEURL">overlegpagina</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Een gebruiker heeft je site gewijzigd!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Hoi $FOUNDERNAME,

Het lijkt erop dat de geregistreerde gebruiker $USERNAME je wiki heeft bewerkt! Waarom laat je geen bericht achter op de overlegpagina van $USERNAME? $USERTALKPAGEURL

-- Het Wikia-team',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
Het lijkt erop dat de geregistreerde gebruiker $USERNAME je wiki heeft bewerkt! Waarom laat je geen bericht achter op de <a href="$USERTALKPAGEURL">overlegpagina van $USERNAME</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Iemand heeft je site gewijzigd!',
	'founderemails-answers-email-page-edited-anon-body' => 'Hoi $FOUNDERNAME,

Het lijkt erop dat iemand je wiki heeft bewerkt! Waarom ga je niet even kijken wat er is veranderd? $MYHOMEURL

-- Het Wikia-team',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
Het lijkt erop dat iemand je wiki heeft bewerkt! Waarom ga je niet even kijken <a href="$MYHOMEURL">wat er is veranderd</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-lot-happening-subject' => 'Er gebeurt veel op je site vandaag!',
	'founderemails-lot-happening-body' => 'Hoi $FOUNDERNAME.

Er gebeurt veel op je wiki vandaag. Kom naar $MYHOMEURL om te kijken wat er allemaal gebeurt.

-- Het Wikia-team',
	'founderemails-lot-happening-body-HTML' => 'Hoi $FOUNDERNAME,<br /><br />
Er gebeurt veel op je wiki vandaag! Kom naar $MYHOMEURL om te kijken wat er allemaal gebeurt.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Het Wikia-team</div>',
	'founderemails-email-footer-line2' => 'Wil je bepalen welke e-mails je krijgt? ga naar <a href="$WIKIURL/wiki/Special:Preferences" style="color:#2a87d5;text-decoration:none;">je voorkeuren</a>',
	'founderemails-email-0-day-heading' => 'Goed je te zien, $FOUNDERNAME.',
	'founderemails-email-0-day-tips-heading' => 'Hier zijn een paar nuttige tips om je snel op weg te helpen:',
	'founderemails-email-0-day-addpages-content' => 'In een wiki draait alles om het delen van informatie; in dit geval over jouw unieke onderwerp. Maak pagina\'s aan door te klikken op "<a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">Pagina toevoegen</a>" en voeg nog meer gegevens over je onderwerp toe.',
	'founderemails-email-0-day-addphotos-content' => 'Pagina\'s zien er altijd beter uit als ze visueel zijn! Voeg afbeeldingen toe aan je pagina\'s en aan je hoofdpagina. Je kunt klikken op "<a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">Afbeelding toevoegen</a>" om een afbeelding, galerij of diavoorstelling toe te voegen.',
	'founderemails-email-0-day-customizetheme-heading' => 'Het siteuiterlijk aanpassen.',
	'founderemails-email-0-day-customizetheme-content' => 'Pas het uiterlijk en het woordmerk van je wiki aan om op te vallen! Gebruik de <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Wizard uiterlijk aanpassen</a> om aangepaste kleuren toe te voegen aan je wiki en de site precies aan te passen aan je onderwerp.',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">We laten je niet in de kou staan.</span> We zijn hier om je te helpen $WIKINAME succesvol te maken, stap voor stap. Kom langs op <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> voor forums, advies en hulp of <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">e-mail ons</a> je vragen!',
	'founderemails-email-3-day-tips-heading' => 'Het is nu drie dagen geleden dat je bent begonnen en we denken dat het een goed moment is om je wat tips te geven over het opbouwen van je wiki:',
	'founderemails-email-3-day-editmainpage-heading' => 'Zorg ervoor dat je hoofdpagina pakkend is.',
	'founderemails-email-3-day-editmainpage-content' => 'De hoofdpagina is meestal een van de eerste pagina\'s die bezoekers zien als ze langskomen op <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>. Zorg voor een goede eerste indruk door het schrijven van een gedetailleerde samenvatting over uw onderwerp en door een diavoorstelling, galerij of schuifpresentatie toe te voegen.',
	'founderemails-email-3-day-addphotos-content' => '<a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">Meer afbeeldingen toevoegen</a> is een van de beste manieren om je pagina\'s op te leuken.',
	'founderemails-email-3-day-wikiahelps-text' => 'Heb je hulp nodig bij het uitzoeken hoe iets werkt? We zijn er altijd voor je! Vraag ons om hulp en advies via <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-congratulations' => 'Tjonge, jonge, de tijd vliegt. Het is al weer tien dagen geleden dat je $WIKINAME hebt opgericht.',
	'founderemails-email-10-day-tips-heading' => 'Betrek anderen bij je project en pronk met het fantastische werk dat je hebt verzet! Dit zijn een aantal manieren om je project bekend te maken:',
	'founderemails-email-10-day-share-heading' => 'Heeft je moeder je niet verteld dat je moet delen?',
	'founderemails-email-10-day-share-content' => 'Gebruik de knop "Delen" in je werkbalk, op pagina\'s en afbeeldingen om ze te laten zien aan je vrienden en volgers op Facebook, Twitter en andere populaire sites.',
	'founderemails-email-10-day-email-content' => 'E-mail andere mensen die geïnteresseerd zijn in je onderwerp of die je willen helpen, zoals een schoolvriend of een collega. Je kunt ook bepaalde afbeeldingen die worden gebruikt in je wiki e-mailen via de knop "E-mail".',
	'founderemails-email-10-day-join-content' => 'Vraag mensen op andere forums of websites over je onderwerp om hulp door daar berichten te plaatsen. Neem als het mogelijk is contact op met de beheerders en vraag of ze geïnteresseerd zijn in het uitwisselen van verwijzingen. Zij zetten dan een verwijzing naar jouw website op hun website, en andersom.',
	'founderemails-email-10-day-wikiahelps-text' => 'Je kunt ook andere Wikianen om hulp bij je wiki vragen door berichten te plaatsen in de forums op <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'founderemails-desc' => 'Hjelper til med å informere grunnleggere om endringer på deres wiki',
	'tog-founderemailsenabled' => 'Send meg oppdateringer på e-post om hva andre personer gjør (kun grunnleggere)',
	'founderemails-email-user-registered-subject' => 'Noen registrerte seg på $WIKINAME',
	'founderemails-email-user-registered-body' => 'Hei $FOUNDERNAME,

Gratulerer! $USERNAME registrerte seg nettopp på $WIKINAME.

Grip sjansen og ønsk nykommeren velkommen til wikien og oppfordre til å hjelpe til med redigeringen. Jo mer, jo bedre, og dess fastere vil wikien din vokse.

Wikia-teamet',
	'founderemails-email-user-registered-greeting' => 'Hei $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Gratulerer! $USERNAME har akkurat blitt med i $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Benytt denne muligheten til å ønske dem velkommen til din wiki og oppmuntre dem til å hjelpe å redigere. Jo flere jo bedre, og desto raskere vil wikien din vokse.',
	'founderemails-email-user-registered-signature' => 'Wikia-teamet',
	'founderemails-email-user-registered-button' => 'Ønsk dem velkommen',
	'founderemails-email-user-registered-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Det ser ut til at $USERNAME har registrert seg på wikien din! Hvorfor ikke stikke innom <a href="$USERTALKPAGEURL">diskusjonssiden</a> deres for å si hei?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-email-0-days-passed-subject' => 'Velkommen til Wikia!',
	'founderemails-email-0-days-passed-body' => 'Hyggelig å treffe deg, $FOUNDERNAME,

Gratulerer med å ha opprettet $WIKINAME!

Her er noen nyttige tips for å komme i gang:

Legg til sider. En wiki handler om å dele informasjon om ditt unike tema. Opprett sider ved å trykke «Legg til en side» og fyll ut mer spesifikk infirmasjon om emnet ditt.

Legg til bilder. Sider blir aldri bedre når de har visuell grafikk! Legg til bilder på sider og på hovedsiden din. Du kan trykke Legg til et bilde for å legge til et bilde, et billedgalleri eller en lysbildefremvisning.

Tilpass temaet ditt. Tilpass wikiens tema og logo for å få wikien til å skille seg ut! Bruk Temautformeren for å legge til egendefinerte farger på wikien og gjøre den unik for ditt emne.

Vi vil ikke overlate deg til deg selv. Vi er for for å hjelpe deg med $WIKINAME hvert eneste skritt på veien. Besøk community.wikia.com for forum, råd og hjelp, eller send oss en e-post med spørsmålene dine!

Gledelig wiki-bygging! Wikia-teamet

___________________________________________
For å sjekke ut de nyeste hendelsene på Wikia, besøk http://community.wikia.com
Vil du kontrollere hvilke e-poster du mottar? Gå til: http://messaging.wikia.com/wiki/Special:Preferences.
Trykk på den følgende lenken for å avslutte abonnementet på all e-post fra Wikia: $UNSUBSCRIBEURL',
	'founderemails-email-0-days-passed-body-HTML' => 'Gratulerer med opprettelsen av <strong>$WIKINAME</strong> - du er nå en del av Wikia-fellesskapet!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-email-3-days-passed-subject' => 'Hvordan går det med wikien din?',
	'founderemails-email-3-days-passed-body' => 'Hei der, $FOUNDERNAME,

Vi ville gjerne stikke innom og se hvordan din går på $WIKINAME.

Det har gått tre dager siden du startet opp og vi tenkte vi skulle tilby noen flere tips til hvordan du kan bygge opp wikien:

Sprit opp hovedsiden. Hovedsiden er det første folk vil se når de besøker $WIKINAME. Gjør et godt førsteinntrykk ved å skrive et detaljert sammendrag om hva slags tema siden tar for seg og ved å legge til en lysbildeserie, et galleri eller en bildekarusell.

Og enda flere bilder. En av de beste måtene å gjøre sidene dine glitrende og skinnende på, er å «legge til noen bilder».

Finn inspirasjon. Ikke vær redd for å sjekke ut andre wikien for å se hva de har gjort med hovedsiden sin, artiklene sine, og mer. Her er noen av våre favoritter: Muppet Wiki, Pop Tarts Wiki, Monster High Wiki.

Trenger du hjelp til å finne ut hvordan noe fungerer? Vi er alltid her for deg! Kom og spør oss om hjelp og råd på community.wikia.com.

Fortsett med den gode jobben!
Wikia-teamet


For å sjekke ut de nyeste hendelsene på Wikia, besøk http://community.wikia.com
Vil du kontrollere hvilke e-poster du mottar? Gå til: http://messaging.wikia.com/wiki/Special:Preferences.',
	'founderemails-email-3-days-passed-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Nå som du har hatt wikien din i et par dager tenkte vi at du kanskje ville sjekke ut et par andre ting du kan gjøre.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-email-10-days-passed-subject' => 'Gratulerer med tidagersjubileumet!',
	'founderemails-email-10-days-passed-body' => 'Hvordan går det, $FOUNDERNAME?

Hei som tiden flyr! Det har allerede gått ti dager siden du startet opp $WIKINAME.

Få andre involvert i prosjektet ditt og vis dem alt det fantastiske arbeidet du har gjort! Her er noen metoder for å spre ordet:

Ba ikke moren din deg om å dele? Bruk Del-knappen på verktøylinjen, artikler og bilder for å vise dem til dine venner og tilhengere på Facebook, Twitter og andre populære sider.

Dra nytte av e-postens kraft. Send en e-post til andre du vet er interessert i temaet ditt eller som er interessert i å hjelpe deg, slik som en venn fra skolen eller en kollega. Du kan også sende spesifikke bilder fra wikien med e-post ved hjelp av e-post-knappen.

Slutt deg til liknende nettsteder. Spør folk på andre forum eller nettsteder som handler om temaet ditt etter hjelp ved å postei forumet eller kommentarene deres. Hvis mulig, kontakt administratoren og se om han er interessert i lenkedeling — de setter en lenke til din wiki på sin side hvis du putter deres lenke på din wiki.

Du kan også spørre andre wikianere om hjelp ved å poste på forumet på community.wikia.com.

Fortsett med den gode jobben!

Wikia-teamet

___________________________________________
For å sjekke ut de nyeste hendelsene på Wikia, besøk http://community.wikia.com
Vil du kontrollere hvilke e-poster du mottar? Gå til: http://messaging.wikia.com/wiki/Special:Preferences.
Trykk på den følgende lenken for å avslutte abonnementet på all e-post fra Wikia: $UNSUBSCRIBEURL',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME har en ny redigering!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Hei $FOUNDERNAME,

Stilig! $USERNAME har nettopp gjort sin første redigering på $WIKINAME.

Stikk til $PAGETITLE og se hva som ble lagt til.

Wikia-teamet',
	'founderemails-email-first-edit-greeting' => 'Hei $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => 'Stilig! $USERNAME har nettopp gjort sin første redigering på $WIKINAME.',
	'founderemails-email-first-edit-content' => 'Stikk til $PAGETITLE og se hva som ble lagt til.',
	'founderemails-email-first-edit-signature' => 'Wikia-teamet',
	'founderemails-email-first-edit-button' => 'Sjekk det ut!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />

Det ser ut til at den registrerte brukeren $USERNAME redigerte wikien din for første gang! Hvorfor ikke stikke innom <a href="$USERTALKPAGEURL">diskusjonssiden</a> deres for å si hei?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Ny redigering på $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Hei $FOUNDERNAME,

$USERNAME har nettopp redigert enda en side på $WIKINAME, $PAGETITLE.

Stikk til $PAGETITLE for å se hva som ble endret.

Wikia-teamet',
	'founderemails-email-general-edit-greeting' => 'Hei $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => '$USERNAME har nettopp redigert enda en side på $WIKINAME, $PAGETITLE.',
	'founderemails-email-general-edit-content' => 'Stikk til $PAGETITLE og se hva som ble lagt til.',
	'founderemails-email-general-edit-signature' => 'Wikia-teamet',
	'founderemails-email-general-edit-button' => 'Sjekk det ut!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />

Det ser ut til at den registrerte brukeren $USERNAME redigerte wikien din! Hvorfor ikke stikke innom <a href="$USERTALKPAGEURL">diskusjonssiden</a> deres for å si hei?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-email-page-edited-anon-subject' => 'En mystisk venn redigerte $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Hei $FOUNDERNAME,

En Wikia-bidragsyter har nettopp redigert $PAGETITLE på $WIKINAME.

Wikia-bidragsytere er folk som redigerer uten å være logget inn med en Wikia-konto. Gå og se hva denne mystiske vennen la til!

Wikia-teamet',
	'founderemails-email-anon-edit-greeting' => 'Hei $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'En Wikia-bidragsyter har nettopp redigert $PAGETITLE på $WIKINAME.',
	'founderemails-email-anon-edit-content' => 'Wikia-bidragsytere er folk som redigerer uten å være logget inn med en Wikia-konto. Gå og se hva denne mystiske vennen la til!',
	'founderemails-email-anon-edit-signature' => 'Wikia-teamet',
	'founderemails-email-anon-edit-button' => 'Sjekk det ut!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Det ser ut til at noen redigerte wikien din! Hvorfor ikke stikke innom $MYHOMEURL for å se hva som ble endret?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-answers-email-user-registered-subject' => 'Noen registrerte en konto på SS-wikien din!',
	'founderemails-answers-email-user-registered-body' => 'Hei $FOUNDERNAME,

Det ser ut til at $USERNAME har registrert seg på wikien din! Hvorfor stikker du ikke til diskusjonssiden hans $USERTALKPAGEURL for å si hallo?

-- Wikia Teamet',
	'founderemails-answers-email-user-registered-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Det ser ut til at $USERNAME har registrert seg på wikien din! Hvorfor stikker du ikke til <a href="$USERTALKPAGEURL">diskusjonssiden hans</a> for å si hallo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Teamet</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Velkommen til SS-Wikia!',
	'founderemails-answers-email-0-days-passed-body' => 'Gratulerer med $WIKINAME - du er nå en del av Wikia-fellesskapet!

-- Wikia Teamet',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Gratulerer med <strong>$WIKINAME</strong> - du er nå en del av Wikia-fellesskapet!<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Wikia Teamet</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Sjekker innom',
	'founderemails-answers-email-3-days-passed-body' => 'Hei der $FOUNDERNAME,

Nå som du har noen få dagers erfaring med wikien din, tenkte vi at du kanskje ville sjekke ut et par andre ting du kan gjøre.

-- Wikia Teamet',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Hei der $FOUNDERNAME<br /><br />
Nå som du har noen få dagers erfaring med wikien din, tenkte vi at du kanskje ville sjekke ut et par andre ting du kan gjøre.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Teamet</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Hvordan går det med wikien din?',
	'founderemails-answers-email-10-days-passed-body' => 'Hei $FOUNDERNAME,

Det har gått en stund sinden du startet opp en wiki hos Wikia - vi håper det går bra! Vi vil gjerne dele noen siste godbiter med deg for å gjøre wikien din mer hjemmekoselig.

-- Wikia Teamet',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Det har gått en stund sinden du startet opp en wiki hos Wikia - vi håper det går bra! Vi vil gjerne dele noen siste godbiter med deg for å gjøre wikien din mer hjemmekoselig.<br /><br />
<div style="font-style: italic; font-size: 120%;">--Wikia Teamet</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Registrert bruker redigerte siden din for første gang!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Hei $FOUNDERNAME,

Det ser ut til at den registrerte brukeren $USERNAME har redigert wikien din for første gang! Hvorfor stikker du ikke innom diskusjonssiden hans ($USERTALKPAGEURL) for å si hallo?

-- Wikia Teamet',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Det ser ut til at den registrerte brukeren $USERNAME har redigert wikien din for første gang! Hvorfor stikker du ikke innom <a href="$USERTALKPAGEURL">diskusjonssiden hans</a> for å si hallo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Teamet</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Registrert bruker redigerte siden din!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Hei $FOUNDERNAME,

Det ser ut til at den registrerte brukeren $USERNAME har redigert wikien din! Hvorfor stikker du ikke innom diskusjonssiden hans ($USERTALKPAGEURL) og sier hallo?

-- Wikia Teamet',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Det ser ut til at den registrerte brukeren $USERNAME har redigert wikien din! Hvorfor stikker du ikke innom <a href="$USERTALKPAGEURL">diskusjonssiden</a> hans og sier hallo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Teamet</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Noen redigerte siden din!',
	'founderemails-answers-email-page-edited-anon-body' => 'Hei $FOUNDERNAME,

Det ser ut til at noen har endret wikien din! Hvorfor sjekker du ikke ut $MYHOMEURL for å se hva som er endret?

-- Wikia Teamet',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Det ser ut til at noen har endret wikien din! Hvorfor <a href="$MYHOMEURL">sjekker du det ikke ut</a> for å se hva som er endret?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Teamet</div>',
	'founderemails-lot-happening-subject' => '$WIKINAME er i siget!',
	'founderemails-lot-happening-body' => 'Hei $FOUNDERNAME,

Gratulerer! Det er en masse som skjer på $WIKINAME i dag!

Hvis du ikke har gjort det allerede kan du gå til Wiki-aktivitet og se alt det flotte arbeidet som har blitt gjort.

Siden det er så mye som skjer vil du kanskje endre e-postpreferansene dine til sammendragsmodus. Med sammendragsmodus får du en e-post som viser en liste over all aktiviteten på wikien din hver dag.

Wikia-teamet',
	'founderemails-lot-happening-body-HTML' => 'Hei $FOUNDERNAME,<br /><br />
Det er en masse som skjer på wikien din i dag! Stikk innom $MYHOMEURL for å se hva som står på.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-email-lot-happening-greeting' => 'Hei $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => 'Gratulerer! Det er en masse som skjer på $WIKINAME i dag!',
	'founderemails-email-lot-happening-content' => 'Hvis du ikke har gjort det allerede kan du gå til Wiki-aktivitet og se alt det flotte arbeidet som har blitt gjort. Siden det er så mye som skjer vil du kanskje endre e-postpreferansene dine til sammendragsmodus. Med sammendragsmodus får du en e-post som viser en liste over all aktiviteten på wikien din hver dag.',
	'founderemails-email-lot-happening-signature' => 'Wikia-teamet',
	'founderemails-email-lot-happening-button' => 'Se aktiviteter',
	'founderemails-email-footer-line1' => 'For å sjekke ut de siste hendelsene på Wikia, gå til <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Vil du kontrollere hvilke e-post du mottar? Gå til [{{fullurl:{{ns:special}}:Preferences}} innstillingene dine]',
	'founderemails-email-0-day-heading' => 'Hyggelig å treffe deg $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Gratulerer med opprettelsen av $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Her er noen nyttige tips for å komme i gang:',
	'founderemails-email-0-day-addpages-heading' => 'Legg til sider.',
	'founderemails-email-0-day-addpages-content' => 'En wiki handler først og fremst om å dele informasjon om ditt unike emne. Opprett sider ved å trykke på <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">«Legg til en side»</a> og fyll ut mer spesifikk informasjon om emnet.',
	'founderemails-email-0-day-addpages-button' => 'Legg til en side',
	'founderemails-email-0-day-addphotos-heading' => 'Legg til bilder.',
	'founderemails-email-0-day-addphotos-content' => 'Sider er alltid bedre når de har noe visuelt å se på! Legg bilder til sidene dine og hovedsiden. Du kan trykke <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">«Legg til et bilde»</a> for å legge til et bilde, et billedgalleri eller en lysbildeserie.',
	'founderemails-email-0-day-addphotos-button' => 'Legg til et bilde',
	'founderemails-email-0-day-customizetheme-heading' => 'Tilpass temaet.',
	'founderemails-email-0-day-customizetheme-content' => 'Tilpass wikiens tema og logo for å gjøre at wikien skiller seg ut! Bruk <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Temautformeren</a> for å legge egendefinerte farger til wikien og gjøre den unik for ditt emne.',
	'founderemails-email-0-day-customizetheme-button' => 'Tilpass',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">Vi vil ikke forlate deg ute i kulda.</span> Vi er her for å hjelpe deg med å gjøre $WIKINAME vellykket for hvert steg du tar. Besøk <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> for forum, råd, og hjelp, eller send dine spørsmål på <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">e-post</a>!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Lykke til med bygningen av wikien!<br />Wikia-teamet',
	'founderemails-email-3-day-heading' => 'Hei der, $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Vi ville sjekke innom og se hvordan ting går på $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Det har gått tre dager siden du startet opp, og vi tenkte vi skulle stikke innom for å gi deg noen flere tips til bygningen av wikien din:',
	'founderemails-email-3-day-editmainpage-heading' => 'Dekorér hovedsiden din.',
	'founderemails-email-3-day-editmainpage-content' => 'Hovedsiden er en av de første tingene folk vil se når de besøker <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>. Gjør et godt førsteinntrykk ved å skrive et detaljert sammendrag om hva emnet ditt handler om og ved å legge til en lysbildeserie, et galleri, eller en bildekarusell.',
	'founderemails-email-3-day-editmainpage-button' => 'Dekorér den',
	'founderemails-email-3-day-addphotos-heading' => 'Legg til enda flere bilder.',
	'founderemails-email-3-day-addphotos-content' => 'En av de beste måtene å få sidene dine til å skinne, glitre og sprake på er å <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">«legge til noen bilder»</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Legg til bilder',
	'founderemails-email-3-day-explore-heading' => 'Finn inspirasjon.',
	'founderemails-email-3-day-explore-content' => 'Ikke vær redd for å sjekke ut andre wikier for å se hvordan de har utformet sin hovedside, sine artikler og andre ting. Her er noen av våre favoritter: <a style="color:#2a87d5;text-decoration:none;" href="http://muppets.wikia.com">Muppet Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://poptarts.wikia.com">Pop Tarts Wiki</a>, <a style="color:#2a87d5;text-decoration:none;" href="http://monsterhigh.wikia.com">Monster High Wiki</a>.',
	'founderemails-email-3-day-explore-button' => 'Utforsk',
	'founderemails-email-3-day-wikiahelps-text' => 'Trenger du hjelp til å finne ut hvordan noe virker? Vi er alltid her for deg! Kom og spør oss om hjelp og råd på <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Fortsett med den gode jobben!<br />Wikia-teamet',
	'founderemails-email-10-day-heading' => 'Hvordan går det, $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Nei, som tiden flyr! Det har allerede gått 10 dager siden du startet $WIKINAME.',
	'founderemails-email-10-day-tips-heading' => 'Involver andre i prosjektet ditt og vis frem alt det utrolige arbeidet du har lagt i det! Her er noen måter å spre ordet på:',
	'founderemails-email-10-day-share-heading' => 'Lærte ikke moren din deg å Dele?',
	'founderemails-email-10-day-share-content' => 'Bruk Del-knappen på verktøylinjen din, artikkelsider og bilder for å vise dem frem til venner og tilhengere på Facebook, Twitter, eller andre populære sider.',
	'founderemails-email-10-day-email-heading' => 'Utnytt styrken i e-post.',
	'founderemails-email-10-day-email-content' => 'Send e-post til andre bekjente som er interessert i emnet ditt eller er interessert i å hjelpe deg, som en venn fra skolen eller en medarbeider. Du kan også sende e-post med bestemte bilder fra wikien din å bruke e-post-knappen',
	'founderemails-email-10-day-join-heading' => 'Bli med i lignende nettsider.',
	'founderemails-email-10-day-join-content' => 'Spør folk etter hjelp på andre forumer eller nettsider som handler om emnet ditt ved å poste på forumene eller i kommentarfeltene deres. Om mulig, kontakt administratoren og finn ut om de er interessert i å dele koblinger &mdash; de setter en lenke til wikien din på sin side om du setter en lenke til dem på wikien din.',
	'founderemails-email-10-day-wikiahelps-text' => 'Du kan også spørre andre wikianere om å hjelpe wikien din ved å poste på forumene på <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Fortsett med den gode jobben!<br />Wikia-teamet',
	'founderemails-email-views-digest-subject' => 'Dagens visninger på $WIKINAME',
	'founderemails-email-views-digest-body' => 'Hei $FOUNDERNAME,

I dag ble $WIKINAVN sett av # personer.

Fortsett å legge til innhold og reklamere for wikien for å oppfordre flere til å lese, redigere og spre ordet.

Wikia-teamet.',
	'founderemails-email-views-digest-greeting' => 'Hei $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'I dag ble $WIKINAME sett av $UNIQUEVIEWS personer.',
	'founderemails-email-views-digest-content' => 'Fortsett å legge til innhold og reklamere for wikien for å oppfordre flere til å lese, redigere og spre ordet.',
	'founderemails-email-views-digest-signature' => 'Wikia-teamet',
	'founderemails-email-views-digest-button' => 'Legg til flere sider',
	'founderemails-email-complete-digest-subject' => 'Den siste aktiviteten på $WIKINAME',
	'founderemails-email-complete-digest-body' => 'Hei $FOUNDERNAME,

Det er tid for din daglige dise med aktivitet fra $WIKINAME.

$UNIQUEVIEWS personer har sett på wikien.

Fortsett med den gode jobben og legg til interessant innhold til leserne!

$USEREDITS redigeringer ble gjort.

Glade redaktører lager glade wikier. Sørg for å takke redaktørene dine og sjekk innom dem fra tid til annen.

$USERJOINS personer registrerte seg på wikien.

Ønsk ny folk velkommen til wikien din med en melding på diskusjonssiden deres.

Du kan alltids stikke over til wiki-aktivitet for å se alle endringene gjort på $WIKINAME. Sjekk ofte, som grunnlegger vil fellesskapet se til deg for å få hjelp med å drifte wikien.',
	'founderemails-email-complete-digest-greeting' => 'Hei $FOUNDERNAME,',
	'founderemails-email-complete-digest-headline' => 'Det er tid for din daglige dose med aktivitet fra $WIKINAME.',
	'founderemails-email-complete-digest-content-heading1' => '$UNIQUEVIEWS personer har sett på wikien.',
	'founderemails-email-complete-digest-content1' => 'Fortsett med den gode jobben og legg til interessant innhold til leserne!',
	'founderemails-email-complete-digest-content-heading2' => '$USEREDITS redigeringer ble gjort.',
	'founderemails-email-complete-digest-content2' => 'Glade redaktører lager glade wikier. Sørg for å takke redaktørene dine og sjekk innom dem fra tid til annen.',
	'founderemails-email-complete-digest-content-heading3' => '$USERJOINS personer ble med i wikien din.',
	'founderemails-email-complete-digest-content3' => 'Ønsk ny folk velkommen til wikien din med en melding på diskusjonssiden deres.
<br /><br />
Du kan alltids stikke over til wiki-aktivitet for å se alle endringene gjort på $WIKINAME. Sjekk ofte, som grunnlegger vil fellesskapet se til deg for å få hjelp med å drifte wikien.',
	'founderemails-email-complete-digest-signature' => 'Wikia-teamet',
	'founderemails-email-complete-digest-button' => 'Gå til wikiaktivitet',
	'founderemails-pref-joins' => 'Send meg en e-post når noen blir med i $1',
	'founderemails-pref-edits' => 'Send meg en e-post når noen redigerer i $1',
	'founderemails-pref-views-digest' => 'Send meg en daglig e-post som forteller meg hvor mange ganger $1 har blitt besøkt',
	'founderemails-pref-complete-digest' => 'Send meg et daglig sammendrag av aktiviteten på $1',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'founderemails-email-user-registered-subject' => 'Ktoś nowy dołączył do $WIKINAME',
	'founderemails-email-user-registered-body' => 'Cześć $FOUNDERNAME,

Gratulacje! $USERNAME zarejestrował się na $WIKINAME!

Wykorzystaj tę okazję do przywitania go i nakłonienia do pomocy w edytowaniu. Przyjemniej i szybciej będzie rozrastała się Twoja wiki.

Zespół Wikii',
	'founderemails-email-user-registered-body-HTML' => 'Cześć $FOUNDERNAME,<br /><br />
$USERNAME zarejestrował się na twojej wiki! Może przywitasz się z nim na jego <a href="$USERTALKPAGEURL">stronie dyskusji</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Zespół Wikii</div>',
	'founderemails-email-0-days-passed-subject' => 'Witamy na Wikii!',
	'founderemails-email-0-days-passed-body' => 'Gratulujemy utworzenia $WIKINAME - jesteś teraz częścią społeczności Wikii!

-- Zespół Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Gratulujemy utworzenia <strong>$WIKINAME</strong> - jesteś teraz częścią społeczności Wikii!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Zespół Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Sprawdzanie',
	'founderemails-email-3-days-passed-body' => 'Cześć $FOUNDERNAME,

Minęło już kilka dni od powstania twojej wiki, pomyśleliśmy że chciałbyś sprawdzić kilka rzeczy, które możesz zrobić.

-- Zespół Wikia',
	'founderemails-email-3-days-passed-body-HTML' => 'Cześć $FOUNDERNAME, <br /> <br />
Minęło już kilka dni od powstania twojej wiki, pomyśleliśmy że chciałbyś dowiedzieć się, co jeszcze możesz zrobić.
<div style="font-style: italic; font-size: 120%;">-- Zespół Wikia</div>',
	'founderemails-email-10-days-passed-subject' => 'Co słychać na twojej wiki?',
	'founderemails-email-10-days-passed-body' => 'Cześć $FOUNDERNAME,

Minęło trochę czasu odkąd stworzyłeś swoją wiki - mamy nadzieje że wszystko idzie dobrze! Chcemy podzielić się kilkoma bajerami które pozwolą Ci czuć się jak u siebie w domu.

-- Zespół Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME została zmodyfikowana!',
	'founderemails-email-page-edited-anon-subject' => 'Tajemniczy przyjaciel dokonał zmian na $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Cześć $FOUNDERNAME,

Wygląda na to, że anonimowy gość dokonał zmiany $PAGETITLE na $WIKINAME.

Anonimowy goście to użytkownicy, którzy wykonują edycje bez zalogowania na konto Wikii. Sprawdź co się zmieniło!

Zespół Wikia',
	'founderemails-email-page-edited-anon-body-HTML' => 'Hej $FOUNDERNAME,<br /><br />
Wygląda na to, że ktoś dokonał zmiany na twojej wiki! Może <a href="$MYHOMEURL">sprawdzisz</a> co się zmieniło?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Zespół Wikia</div>',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'founderemails-desc' => 'A giuta anformand ij fondator an sij cambi dzora soa wiki',
	'tog-founderemailsenabled' => "Mandeme për pòsta eletrònica le modìfiche dzora lòn che d'àutre përson-e a fan (mach ai fondator)",
	'founderemails-email-user-registered-subject' => "Cheidun a l'ha registrà un cont dzora toa wiki!",
	'founderemails-email-user-registered-body' => 'Cerea $FOUNDERNAME,

A smija che $USERNAME a sia registrasse su toa wiki! Përchè it fas pa un sàut su soa pàgina dle ciaciarade $USERTALKPAGEURL për salutelo?

-- L\'Echip Wikia',
	'founderemails-email-user-registered-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A smija che $USERNAME a sia registrasse su soa wiki! Përchè a fas nen un sàut su soa <a href="$USERTALKPAGEURL">pàgine dle ciaciarade</a> për dije cerea? <br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-email-0-days-passed-subject' => 'Bin ëvnù su Wikia!',
	'founderemails-email-0-days-passed-body' => 'Congratulassion për la creassion ëd $WIKINAME - adess a fa part ëd la comunità Wikia!

-- L\'Echip Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Congratulassion për la creassion ëd <strong>$WIKINAME</strong> - adess a fa part ëd la comunità Wikia! <br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Controlé an',
	'founderemails-email-3-days-passed-body' => "Cerea \$FOUNDERNAME,

Adess ch'a l'ha passà chèich di su soa wiki, i l'oma pensà ch'a podrìa dé n'ociada a d'àutre còse ch'a peul fé.

-- L'Echip Wikia",
	'founderemails-email-3-days-passed-body-HTML' => "Cerea \$FOUNDERNAME,<br /><br />
Adess ch'a l'ha passà chèich di su soa wiki, i l'oma pensà ch'a podrìa controlé d'àutre còse ch'a peul fé.<br /><br />
<div style=\"font-style: italic; font-size: 120%;\">-- L'Echip Wikia</div>",
	'founderemails-email-10-days-passed-subject' => 'Com va-la soa wiki?',
	'founderemails-email-10-days-passed-body' => "Cerea \$FOUNDERNAME,

A l'é passaje un pòch ëd temp da quand a l'ha ancaminà na wiki su Wikia - i speroma ch'a vada bin! I voroma condivide chèich curiosità finaj për giuté a felo sente su soa wiki pi com a soa ca.

-- L'Echip Wikia",
	'founderemails-email-page-edited-reg-user-first-edit-subject' => "N'utent registrà a l'ha modificà soa wiki për la prima vira!",
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Cerea $FOUNDERNAME,

A smija che l\'utent registrà $USERNAME a l\'abia modificà toa wiki për la prima vira! Përchè it fas pa un sàut su soa pàgina dle ciaciarade ($USERTALKPAGEURL) për salutelo?

-- L\'Echip Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A smija che l\'utent registrà $USERNAME a l\'abia modificà toa wiki për la prima vira! Përchè it fas pa un sàut su soa pàgina dle ciaciarade ($USERTALKPAGEURL) për salutelo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-email-page-edited-reg-user-subject' => "N'utent registrà a l'ha modificà soa wiki!",
	'founderemails-email-page-edited-reg-user-body' => 'Cerea $FOUNDERNAME,

A smija che l\'utent registrà $USERNAME a l\'abia modificà toa wiki! Përchè it fas pa un sàut su soa pàgina dle ciaciarade ($USERTALKPAGEURL) për salutelo?

-- L\'Echip Wikia',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A smija che l\'utent registrà $USERNAME a l\'abia modificà soa wiki! Përchè a fas nen un sàut su soa <a href="$USERTALKPAGEURL">pàgina dle ciaciarade</a> për salutelo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-email-page-edited-anon-subject' => "Quaidun a l'ha modificà soa wiki!",
	'founderemails-email-page-edited-anon-body' => "Cerea \$FOUNDERNAME,

A smija che quaidun a l'abia modificà soa wiki! Përchè a controle nen \$MYHOMEURL për vëdde lòn ch'a l'é cangià?

-- L'Echip Wikia",
	'founderemails-email-page-edited-anon-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A smija che quaidun a l\'abia modificà soa wiki! Përchè <a href="$MYHOMEURL">it controle nen</a> për vëdde lòn ch\'a l\'é cangià?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-answers-email-user-registered-subject' => "Quaidun a l'ha registrà un cont dzora soa wiki D&R!",
	'founderemails-answers-email-user-registered-body' => 'Cerea $FOUNDERNAME,

A smija che $USERNAME a sia registrasse su toa wiki! Përchè it fas pa un sàut su soa pàgina dle ciaciarade $USERTALKPAGEURL për salutelo?

-- L\'Echip Wikia',
	'founderemails-answers-email-user-registered-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A smija che $USERNAME a sia registrasse su soa wiki! Përchè a fa nen un sàut su soa <a href="$USERTALKPAGEURL">pàgine dle ciaciarade</a> për dije cerea? <br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Bin ëvnù su Wikia C&R!',
	'founderemails-answers-email-0-days-passed-body' => 'Congratulassion për avèj creà $WIKINAME - adess a fa part ëd la comunità Wikia!

-- L\'Echip Wikia',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Congratulassion për avèj creà <strong>$WIKINAME</strong> - adess a fa part ëd la comunità Wikia! <br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Controlé an',
	'founderemails-answers-email-3-days-passed-body' => "Cerea \$FOUNDERNAME,

Adess ch'a l'ha passà chèich di su toa wiki, i l'oma pensà ch'a podrìa de n'ociada a d'àutre còse ch'a peul fé.

-- L'Echip Wikia",
	'founderemails-answers-email-3-days-passed-body-HTML' => "Cerea \$FOUNDERNAME,<br /><br />
Adess ch'a l'ha passà chèich di su soa wiki, i l'oma pensà ch'a podrìa dé n'ociada a d'àutre còse ch'a peul fé.<br /><br />
<div style=\"font-style: italic; font-size: 120%;\">-- L'Echip Wikia</div>",
	'founderemails-answers-email-10-days-passed-subject' => "Com it pense d'andé con toa wiki?",
	'founderemails-answers-email-10-days-passed-body' => "Cerea \$FOUNDERNAME,

A l'é passaje un pòch da quand a l'ha ancaminà na wiki su Wikia - i speroma ch'a von-a bin! I voroma condivide chèich curiosità finaj për giuté a felo sente su soa wiki pi com a soa ca.

-- L'Echip Wikia",
	'founderemails-answers-email-10-days-passed-body-HTML' => "Cerea \$FOUNDERNAME,<br /><br />
A l'é passaje un pòch ëd temp da quand a l'ha ancaminà na wiki su Wikia - i speroma ch'a von-a bin! I voroma condivide chèich curiosità finaj për giuté a felo sente su soa wiki pi com a soa ca<br /><br />
<div style=\"font-style: italic; font-size: 120%;\">-- L'Echip Wikia</div>",
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => "N'utent registrà a l'ha modificà sò sit për la prima vira!",
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Cerea $FOUNDERNAME,

A smija che l\'utent registrà $USERNAME a l\'abia modificà toa wiki për la prima vira! Përchè it fas pa un sàut su soa pàgina dle ciaciarade ($USERTALKPAGEURL) për salutelo?

-- L\'Echip Wikia',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A smija che l\'utent registrà $USERNAME a l\'abia modificà toa wiki për la prima vira! Përchè it fas pa un sàut su soa <a href="$USERTALKPAGEURL">pàgina dle ciaciarade</a> për salutelo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => "N'utent registrà a l'ha modificà sò sit!",
	'founderemails-answers-email-page-edited-reg-user-body' => 'Cerea $FOUNDERNAME,

A smija che l\'utent registrà $USERNAME a l\'abia modificà toa wiki! Përchè it fas pa un sàut su soa pàgina dle ciaciarade ($USERTALKPAGEURL) për salutelo?

-- L\'Echip Wikia',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A smija che l\'utent registrà $USERNAME a l\'abia modificà soa wiki! Përchè a fa nen un sàut su soa <a href="$USERTALKPAGEURL">pàgina dle ciaciarade</a> për salutelo?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-answers-email-page-edited-anon-subject' => "Quaidun a l'ha modificà tò sit!",
	'founderemails-answers-email-page-edited-anon-body' => "Cerea \$FOUNDERNAME,

A smija che quaidun a l'abia modificà soa wiki! Përchè a controla nen \$MYHOMEURL për vëdde lòn ch'a l'é cangià?

-- L'Echip Wikia",
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A smija che quaidun a l\'abia modificà soa wiki! Përchè <a href="$MYHOMEURL">a controla nen</a> për vëdde lòn ch\'a l\'é cangià?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
	'founderemails-lot-happening-subject' => "Un mucc ëd ròba a l'é capitaje su tò sit ancheuj!",
	'founderemails-lot-happening-body' => "cerea \$FOUNDERNAME,

A-i é un mucc ëd ròba capità su soa wiki ancheuj! Ch'a vada ansima a \$MYHOMEURL për vëdde lòn ch'a càpita.

-- L'Echip Wikia",
	'founderemails-lot-happening-body-HTML' => 'Cerea $FOUNDERNAME,<br /><br />
A-i é un mucc ëd ròba capità su soa wiki ancheuj! Ch\'a vada ansima a $MYHOMEURL për vëdde lòn ch\'a ancàpita.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- L\'Echip Wikia</div>',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'founderemails-email-0-days-passed-subject' => 'ويکييا ته ښه راغلاست!',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'founderemails-desc' => 'Ajuda a informar os fundadores acerca das mudanças na sua wiki',
	'tog-founderemailsenabled' => 'Enviar-me por correio electrónico actualizações sobre aquilo que os outros têm feito (só para fundadores)',
	'founderemails-email-user-registered-subject' => 'Alguém registou uma conta na sua wiki!',
	'founderemails-email-user-registered-body' => 'Olá $FOUNDERNAME,

Parece que o utilizador $USERNAME se registou na sua wiki! Que tal ir à página de discussão $USERTALKPAGEURL e dizer-lhe olá?

-- A Equipa da Wikia',
	'founderemails-email-user-registered-body-HTML' => 'Olá $FOUNDERNAME,<br /><br />
Parece que o utilizador $USERNAME se registou na sua wiki! Que tal ir à <a href="$USERTALKPAGEURL">página de discussão</a> e dizer-lhe olá?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-email-0-days-passed-subject' => 'Bem-vindo(a) à Wikia!',
	'founderemails-email-0-days-passed-body' => 'Parabéns por ter criado a wiki $WIKINAME - agora faz parte da comunidade Wikia!

-- A Equipa da Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Parabéns por ter criado a wiki <strong>$WIKINAME</strong> - agora faz parte da comunidade Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Vimos saber como está',
	'founderemails-email-3-days-passed-body' => 'Boas, $FOUNDERNAME,

Agora que a sua wiki já tem alguns dias, pensámos que gostaria de conhecer algumas outras coisas que pode fazer.

-- A Equipa da Wikia',
	'founderemails-email-3-days-passed-body-HTML' => 'Boas, $FOUNDERNAME,<br /><br />
Agora que a sua wiki já tem alguns dias, pensámos que gostaria de conhecer algumas outras coisas que pode fazer.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-email-10-days-passed-subject' => 'Que tal vão as coisas na sua wiki?',
	'founderemails-email-10-days-passed-body' => 'Olá, $FOUNDERNAME,

Há já algum tempo que criou uma wiki na Wikia - esperamos que tudo esteja a correr bem! Queríamos partilhar consigo umas coisinhas finais para ajudá-lo a sentir-se em casa na sua wiki.

-- A Equipa da Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Utilizador registado alterou a sua wiki pela primeira vez!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Olá $FOUNDERNAME,

Parece que o utilizador registado $USERNAME editou a sua wiki pela primeira vez! Que tal ir à página de discussão ($USERTALKPAGEURL) e dizer-lhe olá?

-- A Equipa da Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Olá $FOUNDERNAME,<br /><br />
Parece que o utilizador registado $USERNAME editou a sua wiki pela primeira vez! Que tal ir à <a href="$USERTALKPAGEURL">página de discussão</a> e dizer-lhe olá?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Utilizador registado alterou a sua wiki!',
	'founderemails-email-page-edited-reg-user-body' => 'Olá $FOUNDERNAME,

Parece que o utilizador registado $USERNAME editou a sua wiki! Que tal ir à página de discussão ($USERTALKPAGEURL) e dizer-lhe olá?

-- A Equipa da Wikia',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Olá $FOUNDERNAME,<br /><br />
Parece que o utilizador registado $USERNAME editou a sua wiki! Que tal ir à <a href="$USERTALKPAGEURL">página de discussão</a> e dizer-lhe olá?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-email-page-edited-anon-subject' => 'Alguém alterou a sua wiki!',
	'founderemails-email-page-edited-anon-body' => 'Olá $FOUNDERNAME,

Parece que alguém editou a sua wiki! Que tal visitá-la $MYHOMEURL e ver o que foi alterado?

-- A Equipa da Wikia',
	'founderemails-email-page-edited-anon-body-HTML' => 'Olá $FOUNDERNAME,<br /><br />
Parece que alguém editou a sua wiki! Que tal <a href="$MYHOMEURL">visitá-la</a> e ver o que foi alterado?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-answers-email-user-registered-subject' => 'Alguém registou uma conta na sua wiki de Perguntas e Respostas!',
	'founderemails-answers-email-user-registered-body' => 'Olá $FOUNDERNAME,

Parece que o utilizador $USERNAME se registou na sua wiki! Que tal visitar a página de discussão $USERTALKPAGEURL e dizer-lhe olá?

-- A Equipa da Wikia',
	'founderemails-answers-email-user-registered-body-HTML' => 'Olá $FOUNDERNAME,<br /><br />
Parece que o utilizador $USERNAME se registou na sua wiki! Que tal visitar a <a href="$USERTALKPAGEURL">página de discussão</a> e dizer-lhe olá?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Bem-vindo(a) à WikiaRespostas!',
	'founderemails-answers-email-0-days-passed-body' => 'Parabéns por ter criado a wiki $WIKINAME - agora faz parte da comunidade Wikia!

-- A Equipa da Wikia',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Parabéns por ter criado a wiki <strong>$WIKINAME</strong> - agora faz parte da comunidade Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Vimos saber como está',
	'founderemails-answers-email-3-days-passed-body' => 'Boas, $FOUNDERNAME,

Agora que a sua wiki já tem alguns dias, pensámos que gostaria de conhecer algumas outras coisas que pode fazer.

-- A Equipa da Wikia',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Boas, $FOUNDERNAME,<br /><br />
Agora que a sua wiki já tem alguns dias, pensámos que gostaria de conhecer algumas outras coisas que pode fazer.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Que tal vão as coisas na sua wiki?',
	'founderemails-answers-email-10-days-passed-body' => 'Olá, $FOUNDERNAME,

Há já algum tempo que criou uma wiki na Wikia - esperamos que tudo esteja a correr bem! Queríamos partilhar consigo umas coisinhas finais para ajudá-lo a sentir-se em casa na sua wiki.

-- A Equipa da Wikia',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Olá, $FOUNDERNAME,<br /><br />
Há já algum tempo que criou uma wiki na Wikia - esperamos que tudo esteja a correr bem! Queríamos partilhar consigo umas coisinhas finais para ajudá-lo a sentir-se em casa na sua wiki.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Utilizador registado alterou o seu site pela primeira vez!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Olá $FOUNDERNAME,

Parece que o utilizador registado $USERNAME editou a sua wiki pela primeira vez! Que tal ir à página de discussão ($USERTALKPAGEURL) e dizer-lhe olá?

-- A Equipa da Wikia',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Olá $FOUNDERNAME,<br /><br />
Parece que o utilizador registado $USERNAME editou a sua wiki pela primeira vez! Que tal ir à <a href="$USERTALKPAGEURL">página de discussão</a> e dizer-lhe olá?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Utilizador registado alterou o seu site!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Olá $FOUNDERNAME,

Parece que o utilizador registado $USERNAME editou a sua wiki! Que tal ir à página de discussão ($USERTALKPAGEURL) e dizer-lhe olá?

-- A Equipa da Wikia',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Olá $FOUNDERNAME,<br /><br />
Parece que o utilizador registado $USERNAME editou a sua wiki! Que tal ir à <a href="$USERTALKPAGEURL">página de discussão</a> e dizer-lhe olá?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Alguém alterou o seu site!',
	'founderemails-answers-email-page-edited-anon-body' => 'Olá $FOUNDERNAME,

Parece que alguém editou a sua wiki! Que tal visitá-la $MYHOMEURL e ver o que foi alterado?

-- A Equipa da Wikia',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Olá $FOUNDERNAME,<br /><br />
Parece que alguém editou a sua wiki! Que tal <a href="$MYHOMEURL">visitá-la</a> e ver o que foi alterado?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa da Wikia</div>',
	'founderemails-lot-happening-subject' => 'Passa-se muita coisa no seu site hoje!',
	'founderemails-lot-happening-body' => 'Olá, $ FOUNDERNAME, 

Há muitas coisas a acontecer hoje na sua wiki! Passe por $MYHOMEURL para ver o que se tem passado.

-- A Equipa Wikia',
	'founderemails-lot-happening-body-HTML' => 'Olá, $ FOUNDERNAME,<br /><br />
Há muitas coisas a acontecer hoje na sua wiki! Passe por $MYHOMEURL para ver o que se tem passado.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- A Equipa Wikia</div>',
	'founderemails-email-footer-line1' => 'Para conhecer as últimas novidades na Wikia, visite <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Quer decidir quais as mensagens de correio electrónico que recebe? Faça-o em <a href="$WIKIURL/wiki/Special:Preferences" style="color:#2a87d5;text-decoration:none;">$WIKIURL/wiki/Especial:Preferências</a>',
	'founderemails-email-0-day-heading' => 'É um prazer conhecê-lo(a) $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Parabéns por ter criado a wiki $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Tem aqui algumas dicas úteis para quem está a começar:',
	'founderemails-email-0-day-addpages-heading' => 'Adicionar páginas.',
	'founderemails-email-0-day-addpages-content' => 'Uma wiki serve para partilhar informação sobre um determinado tema. Para criar páginas, clique <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">"Adicionar uma Página"</a> e adicione informação específica sobre o assunto.',
	'founderemails-email-0-day-addpages-button' => 'Adicionar uma Página',
	'founderemails-email-0-day-addphotos-heading' => 'Adicionar fotos.',
	'founderemails-email-0-day-addphotos-content' => 'As páginas ficam sempre melhores com elementos visuais! Adicione imagens às páginas individuais e à página principal. Pode clicar <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"Adicionar uma Foto"</a> para acrescentar uma fotografia, uma galeria de fotografias, ou uma apresentação de slides.',
	'founderemails-email-0-day-addphotos-button' => 'Adicionar uma Foto',
	'founderemails-email-0-day-customizetheme-heading' => 'Personalize o seu tema.',
	'founderemails-email-0-day-customizetheme-content' => 'Pode personalizar o tema e o símbolo da sua wiki, para destacá-la! Use o <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Compositor de Variantes do Tema</a> para personalizar as cores da wiki e torná-la única e específica para o seu tema.',
	'founderemails-email-0-day-customizetheme-button' => 'Personalizar',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">Não ficará abandonado.</span> Estamos cá para acompanhá-lo em cada passo do processo para tornar a $WIKINAME num sucesso. Visite a <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>, onde poderá encontrar fóruns, conselhos e ajuda, e pode enviar-nos perguntas por <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">correio electrónico</a>!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Felicidades na construção da sua wiki!<br />A Equipa da Wikia',
	'founderemails-email-3-day-heading' => 'Olá $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Queriamos saber como está e como vão as coisas na wiki $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Já passaram 3 dias desde que começou e pensámos dar-lhe mais algumas dicas sobre a construção da sua wiki:',
	'founderemails-email-3-day-editmainpage-heading' => 'Dê brilho à página principal.',
	'founderemails-email-3-day-editmainpage-content' => 'A página principal é uma das primeiras coisas que os utilizadores vêem ao visitar a <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>. Cause uma boa primeira impressão, escrevendo um resumo detalhado do tópico da sua wiki e acrescentando-lhe uma apresentação de slides, uma galeria ou uma apresentação de fotos.',
	'founderemails-email-3-day-editmainpage-button' => 'Dar Mais Brilho',
	'founderemails-email-3-day-addphotos-heading' => 'Acrescentar ainda mais fotos.',
	'founderemails-email-3-day-addphotos-content' => 'Uma das melhores formas de dar brilho às suas páginas é <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"acrescentar algumas fotos"</a>.',
	'founderemails-email-3-day-addphotos-button' => 'Adicionar Fotos',
	'founderemails-email-3-day-explore-heading' => 'Encontrar inspiração.',
	'founderemails-email-3-day-explore-content' => 'Visite outras wikis para ver como construíram a página principal, as páginas de artigos e outras coisas. Algumas das nossas favoritas são: a <a style="color:#2a87d5;text-decoration:none;" href="http://muppets.wikia.com">Muppet Wiki</a>, a <a style="color:#2a87d5;text-decoration:none;" href="http://poptarts.wikia.com">Pop Tarts Wiki</a> e a <a style="color:#2a87d5;text-decoration:none;" href="http://monsterhigh.wikia.com">Monster High Wiki</a>.',
	'founderemails-email-3-day-explore-button' => 'Explorar',
	'founderemails-email-3-day-wikiahelps-text' => 'Precisa de ajuda para descobrir como algo funciona? Estamos sempre disponíveis! Venha pedir-nos ajuda e conselhos na <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Continue o bom trabalho!<br />A Equipa da Wikia',
	'founderemails-email-10-day-heading' => 'Como vão as coisas $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Como o tempo voa! Já passaram 10 dias desde que iniciou a $WIKINAME.',
	'founderemails-email-10-day-tips-heading' => 'Envolva outras pessoas no seu projecto e exponha o bom trabalho que tem estado a fazer! Algumas formas de espalhar a palavra são estas:',
	'founderemails-email-10-day-share-heading' => 'A sua mãe não lhe ensinou que devia Partilhar?',
	'founderemails-email-10-day-share-content' => 'Use o botão Partilhar na barra de ferramentas, nas páginas de artigos e nas fotos para mostrá-las aos seus amigos e seguidores no Facebook, no Twitter e noutros sites populares.',
	'founderemails-email-10-day-email-heading' => 'Aproveite o poder do correio electrónico.',
	'founderemails-email-10-day-email-content' => 'Envie mensagens de correio electrónico àqueles que conhece e sabe que podem ter interesse no tópico da sua wiki ou estar interessados em ajudá-lo, como um amigo da escola ou um colega de trabalho. Também pode enviar fotos específicas da sua wiki, usando o botão de envio por correio electrónico.',
	'founderemails-email-10-day-join-heading' => 'Junte-se a sites semelhantes.',
	'founderemails-email-10-day-join-content' => 'Peça ajuda às pessoas de outros fóruns ou sites sobre temas semelhantes ao da sua wiki, colocando tópicos ou comentários nos fóruns. Se possível, contacte os administradores e inquira se têm interesse em trocar links; eles colocam um link para a sua wiki no site deles e você coloca um link para o site deles na sua wiki.',
	'founderemails-email-10-day-wikiahelps-text' => 'Também pode pedir ajuda a outros utilizadores da Wikia nos fóruns da <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Continue o bom trabalho!<br />A Equipa da Wikia',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'founderemails-email-0-day-heading' => 'Încântat de cunoştinţă $FOUNDERNAME,',
	'founderemails-email-0-day-addpages-button' => 'Adaugă o pagină',
	'founderemails-email-0-day-addphotos-heading' => 'Adaugă fotografii.',
	'founderemails-email-0-day-addphotos-button' => 'Adaugă o fotografie',
	'founderemails-email-0-day-customizetheme-heading' => 'Personalizează-ţi tema.',
	'founderemails-email-3-day-addphotos-button' => 'Adaugă fotografii',
	'founderemails-email-3-day-explore-heading' => 'Găseşte inspiraţie.',
	'founderemails-email-3-day-explore-button' => 'Exploră',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'founderemails-desc' => 'Помогает информировать основателей вики об изменениях в их проекте',
	'tog-founderemailsenabled' => 'Отправлять мне письма об изменениях, производимых другими людьми (только для основателей)',
	'founderemails-email-user-registered-subject' => 'Кто-то зарегистрировал учётную запись в вашей вики!',
	'founderemails-email-user-registered-body' => 'Привет, $ FOUNDERNAME,

Похоже, что $USERNAME зарегистрировался в вашей вики! Почему бы вам не написать «Привет» на его странице обсуждения $USERTALKPAGEURL ?

-- Команда Викиа',
	'founderemails-email-user-registered-body-HTML' => 'Привет, $FOUNDERNAME,<br /><br />
Похоже, что $USERNAME зарегистрировался в вашей вики! Почему бы вам не написать «Привет» на его <a href="$USERTALKPAGEURL">странице обсуждения</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-email-0-days-passed-subject' => 'Добро пожаловать в Викиа!',
	'founderemails-email-0-days-passed-body' => 'Поздравляем с созданием $WIKINAME! Теперь вы являетесь частью сообщества Викиа!

-- Команда Викиа',
	'founderemails-email-0-days-passed-body-HTML' => 'Поздравляем с созданием <strong>$WIKINAME</strong>! Теперь вы являетесь частью сообщества Викиа!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-email-3-days-passed-subject' => 'Начало работы',
	'founderemails-email-3-days-passed-body' => 'Привет, $FOUNDERNAME,

Теперь, когда ваша вики работает уже несколько дней, вероятно, вы захотите заняться её обустройством.

-- Команда Викиа',
	'founderemails-email-3-days-passed-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />
Теперь, когда ваша вики работает уже несколько дней, вероятно, вы захотите заняться её обустройством.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-email-10-days-passed-subject' => 'Как идут дела у вашей вики?',
	'founderemails-email-10-days-passed-body' => 'Привет, $FOUNDERNAME.

Уже прошло некоторое время после запуска вашей вики в Викиа, надеемся, что у вас всё отлично! Хотим поделиться некоторыми подсказками по улучшению вашей вики.

-- Команда Викиа',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Зарегистрированный участник сделал первую правку в вашей вики!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Привет, $FOUNDERNAME.

Похоже, что участник $USERNAME сделал первую правку в вашей вики! Почему бы вам не поприветствовать его на странице обсуждения ($USERTALKPAGEURL)?

-- Команда Викиа',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />

Похоже, что участник $USERNAME сделал первую правку в вашей вики! Почему бы вам не поприветствовать его на <a href="$USERTALKPAGEURL">странице обсуждения</a>?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Зарегистрированный участник внёс изменения в вашу вики!',
	'founderemails-email-page-edited-reg-user-body' => 'Привет, $FOUNDERNAME.

Похоже, что участник $USERNAME внёс изменения в вашу вики! Почему бы вам не поприветствовать его на странице обсуждения ($USERTALKPAGEURL)?

-- Команда Викиа',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />

Похоже, что участник $USERNAME внёс изменения в вашу вики! Почему бы вам не поприветствовать его на <a href="$USERTALKPAGEURL">странице обсуждения</a>?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-email-page-edited-anon-subject' => 'Кто-то сделал правку в вашей вики!',
	'founderemails-email-page-edited-anon-body' => 'Привет, $FOUNDERNAME.

Похоже, что кто-то внёс изменения в вашу! Почему бы вам не посмотреть что было изменено ($MYHOMEURL)?

-- Команда Викиа',
	'founderemails-email-page-edited-anon-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />

Похоже, что кто-то внёс изменения в вашу! Почему бы вам не посмотреть что было изменено ($MYHOMEURL)?<br /><br />

<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-answers-email-user-registered-subject' => 'Кто-то зарегистрировал учётную запись на вашей QA-вики!',
	'founderemails-answers-email-user-registered-body' => 'Привет, $FOUNDERNAME.

Похоже, что $USERNAME зарегистрировался в вашей вики! Почему бы вам не написать «Привет» на его странице обсуждения $USERTALKPAGEURL?

-- Команда Викиа',
	'founderemails-answers-email-user-registered-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />

Похоже, что $USERNAME зарегистрировался в вашей вики! Почему бы вам не написать «Привет» на его <a href="$USERTALKPAGEURL">странице обсуждения</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Добро пожаловать в QA Викии!',
	'founderemails-answers-email-0-days-passed-body' => 'Поздравляем с созданием $WIKINAME, теперь вы являетесь частью сообщества Викия!

-- Команда Викиа',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Поздравляем с созданием <strong>$WIKINAME</strong>, теперь вы являетесь частью сообщества Викия!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Начало работы',
	'founderemails-answers-email-3-days-passed-body' => 'Привет, $FOUNDERNAME.

Теперь, когда вы уже провели несколько дней в вашей вики, мы подумали, что вы можете заинтересоваться некоторыми вещами, которые вы можете сделать.

-- Команда Викиа',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />
Теперь, когда вы уже провели несколько дней в вашей вики, мы подумали, что вы можете заинтересоваться некоторыми вещами, которые вы можете сделать.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Как идут дела у вашей вики?',
	'founderemails-answers-email-10-days-passed-body' => 'Привет, $FOUNDERNAME.

Уже прошло некоторое время после запуска вашей вики в Викиа, надеемся, что у вас всё отлично! Хотим поделиться некоторыми подсказками по улучшению вашей вики.

-- Команда Викиа',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />
Уже прошло некоторое время после запуска вашей вики в Викиа, надеемся, что у вас всё отлично! Хотим поделиться некоторыми подсказками по улучшению вашей вики.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Зарегистрированный участник сделал первую правку на вашем сайте!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Привет, $FOUNDERNAME.

Похоже, что участник $USERNAME сделал первую правку в вашей вики! Почему бы вам не поприветствовать его на странице обсуждения ($USERTALKPAGEURL)?

-- Команда Викиа',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />
Похоже, что участник $USERNAME сделал первую правку в вашей вики! Почему бы вам не поприветствовать его на <a href="$USERTALKPAGEURL">странице обсуждения</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Зарегистрированный участник внёс изменения в ваш сайт!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Привет, $FOUNDERNAME.

Похоже, что участник $USERNAME внёс изменения в вашу вики! Почему бы вам не поприветствовать его на странице обсуждения ($USERTALKPAGEURL)?

-- Команда Викиа',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />
Похоже, что участник $USERNAME внёс изменения в вашу вики! Почему бы вам не поприветствовать его на <a href="$USERTALKPAGEURL">странице обсуждения</a>?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Кто-то сделал правку на вашем сайте!',
	'founderemails-answers-email-page-edited-anon-body' => 'Привет, $FOUNDERNAME.

Похоже, что кто-то внёс изменения в вашу! Почему бы вам не посмотреть что было изменено ($MYHOMEURL)?

-- Команда Викиа',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />
Похоже, что кто-то внёс изменения в вашу! Почему бы вам не посмотреть что было изменено ($MYHOMEURL)?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
	'founderemails-lot-happening-subject' => 'Сегодня на вашем сайте произошло много событий!',
	'founderemails-lot-happening-body' => 'Привет, $FOUNDERNAME.

Сегодня на вашем сайте произошло много событий! Взгляните на $MYHOMEURL , чтобы посмотреть что происходит.

-- Команда Викиа',
	'founderemails-lot-happening-body-HTML' => 'Привет, $FOUNDERNAME.<br /><br />
Сегодня на вашем сайте произошло много событий! Взгляните на $MYHOMEURL , чтобы посмотреть что происходит.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Команда Викиа</div>',
);

/** Swedish (Svenska)
 * @author Lokal Profil
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'tog-founderemailsenabled' => 'Skicka uppdateringar till mig via e-post vad andra personer gör (endast grundare)',
	'founderemails-email-user-registered-subject' => 'Någon registrerade ett konto på din wiki!',
	'founderemails-email-user-registered-body' => 'Hej $FOUNDERNAME,

Det ser ut som $USERNAME har registrerat ett konto på din wiki! Varför går du inte och besöker dem på deras diskussionssida $USERTALKPAGEURL och säger hej?

-- The Wikia Team',
	'founderemails-email-user-registered-body-HTML' => 'Hey $FOUNDERNAME,<br /><br />
Det ser ut som $USERNAME har registrerat sig på din wiki! Varför tittar du inte in på <a href="$USERTALKPAGEURL">diskussionssidan</a> för att säga hej?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-email-0-days-passed-subject' => 'Välkommen till Wikia!',
	'founderemails-email-0-days-passed-body' => 'Grattis till att skapa $WIKINAME - nu är du en del av Wikia-gemenskapen!

-- Wikia-teamet',
	'founderemails-email-0-days-passed-body-HTML' => 'Grattis till att skapa <strong>$WIKINAME</strong> - nu är du en del av Wikia-gemenskapen!<br /><br />
<div style="font-style: italic; font-size: 120%;">--Wikia-teamet</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'En registrerad användare har redigerat din wiki!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Hej $FOUNDERNAME,<br /><br />
Det verkar som om den registrerade användaren $USERNAME har redigerat din wiki! Varför går du inte och besöker <a href="$USERTALKPAGEURL">diskussionssidan</a> för att säga hej?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia-teamet</div>',
	'founderemails-email-page-edited-anon-subject' => 'Någon har ändrat din wiki!',
	'founderemails-email-page-edited-anon-body' => 'Hej $FOUNDERNAME,

Det verkar som om någon har redigerat din wiki! Varför inte kolla $MYHOMEURL för att se vad som ändrats?

-- Wikia-teamet',
	'founderemails-answers-email-0-days-passed-subject' => 'Välkommen till QA-Wikia!',
	'founderemails-answers-email-0-days-passed-body' => 'Grattis till att skapa $WIKINAME - nu är du en del av Wikia-gemenskapen!

-- Wikia-teamet',
	'founderemails-answers-email-10-days-passed-subject' => 'Hur står det igång med din wiki?',
	'founderemails-answers-email-page-edited-anon-subject' => 'Någon redigerade din sida!',
	'founderemails-email-0-day-heading' => 'Trevligt att träffas $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Grattis till skapa $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Här är några användbara tips till dig att komma igång:',
	'founderemails-email-0-day-addpages-heading' => 'Lägg till sidor.',
	'founderemails-email-0-day-addpages-button' => 'Lägg till en sida',
	'founderemails-email-0-day-addphotos-heading' => 'Lägg till foton.',
	'founderemails-email-0-day-addphotos-button' => 'Lägg till ett foto',
	'founderemails-email-0-day-customizetheme-heading' => 'Anpassa ditt tema.',
	'founderemails-email-3-day-heading' => 'Hallå där, $ FOUNDERNAME,',
	'founderemails-email-3-day-addphotos-heading' => 'Lägga till ännu fler foton.',
	'founderemails-email-3-day-addphotos-button' => 'Lägg till foton',
	'founderemails-email-3-day-explore-heading' => 'Hitta inspiration.',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'founderemails-email-0-days-passed-subject' => 'விக்கியா தங்களை அன்புடன் வரவேற்கிறது !',
	'founderemails-email-page-edited-anon-subject' => 'யாரோ தங்களது விக்கியை மாற்றிவிட்டார்கள் !',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'founderemails-email-user-registered-subject' => 'మీ వికీలో ఒకరు ఖాతాని నమోదుచేసుకున్నారు!',
	'founderemails-email-10-days-passed-subject' => 'మీ వికీలో ఏమి జరుగుతూంది?',
	'founderemails-answers-email-10-days-passed-subject' => 'మీ వికీలో ఏమి జరుగుతూంది?',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'founderemails-desc' => 'Tumutulong sa pagpapabatid sa mga tagapagtatag tungkol sa mga pagbabago sa kanilang wiki',
	'tog-founderemailsenabled' => 'Padalhan ako ng mga pagsasapanahon sa pamamagitan ng e-liham kung ano ang ginagawa ng ibang mga tao (mga tagapagtatag lamang)',
	'founderemails-email-user-registered-subject' => 'May isang taong nagpatala ng akawnt sa wiki mo!',
	'founderemails-email-user-registered-body' => 'Hoy $FOUNDERNAME,

Tila nagpatala si $USERNAME sa wiki mo! Bakit hindi ka dumalaw sa kanilang pahina ng usapang $USERTALKPAGEURL upang magsabi ng pagbati?

-- Ang Pangkat ng Wikia',
	'founderemails-email-user-registered-body-HTML' => 'Hoy $FOUNDERNAME,<br /><br />
Tila nagpatala si $USERNAME sa iyong wiki! Bakit hindi ka dumalaw sa kanilang<a href="$USERTALKPAGEURL">pahina ng usapan</a> upang magsabi ng pagbati?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Ang Pangkat ng Wikia</div>',
	'founderemails-email-0-days-passed-subject' => 'Maligayang pagdating sa Wikia!',
	'founderemails-email-0-days-passed-body' => 'Maligayang bati sa paglikha ng $WIKINAME - isa ka nang bahagi ng pamayanan ng Wikia!

-- Ang Pangkat ng Wikia',
	'founderemails-email-0-days-passed-body-HTML' => 'Maligayang bati sa paglikha ng <strong>$WIKINAME</strong> - isa ka nang bahagi ng pamayanan ng Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Ang Pangkat ng Wikia</div>',
	'founderemails-email-3-days-passed-subject' => 'Sinusuri sa',
	'founderemails-email-3-days-passed-body' => 'Hoy diyan $FOUNDERNAME,

Ngayong ilang araw ka nang nasa wiki mo, iniisip namang baka nais mong suriin ang mangilan-ngilang mga bagay na magagawa mo. 

-- Ang Pangkat ng Wikia',
	'founderemails-email-3-days-passed-body-HTML' => 'Hoy diyan $FOUNDERNAME,<br /><br />
Ngayon ilang araw ka nang nasa wiki mo, iniisip naming baka nais mong suriin ang mangilan-ngilang ibang mga bagay na magagawa mo.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Ang Pangkat ng Wikia</div>',
	'founderemails-email-10-days-passed-subject' => 'Kumusta na ang mga bagay-bagay sa wiki mo?',
	'founderemails-email-10-days-passed-body' => 'Hoy $FOUNDERNAME,

Matagal-tagal na rin magmula noong magsimula ka ng isang wiki sa Wikia - umaasa kaming mabuti naman ang pagtakbo niyon! Nais sana naming mamahagi ng ilang panghuling mga piraso upang maging parang isang tahanan ang wiki mo.

-- Ang Pangkat ng Wikia',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Binago ng nakatalang tagagamit ang wiki mo sa unang pagkakataon!',
	'founderemails-email-page-edited-reg-user-subject' => 'Binago ng nagpatalang tagagamit ang wiki mo!',
	'founderemails-email-page-edited-anon-subject' => 'May taong nagbago ng wiki mo!',
	'founderemails-answers-email-user-registered-subject' => 'May isang taong nagpatala ng isang akawnt sa iyong wiki ng QA!',
	'founderemails-answers-email-0-days-passed-subject' => 'Maligayang pagdating sa Wikia ng QA!',
	'founderemails-answers-email-3-days-passed-subject' => 'Sinusuri sa',
	'founderemails-answers-email-10-days-passed-subject' => 'Kumusta ang mga bagay-bagay sa iyong wiki?',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Binago ng nakapagpatalang tagagamit ang sityo mo sa unang pagkakataon!',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Binago ng nagpatalang tagagamit ang iyong sityo!',
	'founderemails-answers-email-page-edited-anon-subject' => 'May tao na nagbago ng iyong sityo!',
	'founderemails-lot-happening-subject' => 'Maraming nagaganap sa sityo mo ngayong araw na ito!',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'founderemails-desc' => 'Допомагає інформуванню засновників про зміни на їх вікі',
	'founderemails-email-user-registered-subject' => 'Хтось зареєстрував обліковий запис у вашій вікі!',
	'founderemails-email-0-days-passed-subject' => 'Ласкаво просимо до Wikia!',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => 'Зареєстрований користувач змінив вашу вікі в перший раз!',
	'founderemails-email-page-edited-reg-user-subject' => 'Зареєстрований користувач змінив ваш вікі!',
	'founderemails-email-page-edited-anon-subject' => 'Хтось змінив вашу вікі!',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Зареєстрований користувач змінив ваш сайт!',
	'founderemails-answers-email-page-edited-anon-subject' => 'Хтось змінив ваш сайт!',
	'founderemails-lot-happening-subject' => 'Сьогодні на вашому сайті відбувається багато подій!',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'founderemails-desc' => 'Giúp thông báo cho thành viên sáng lập về những thay đổi trên wiki của họ',
	'tog-founderemailsenabled' => 'Gửi thư điện tử cập nhật cho tôi trên những gì người khác đang làm (chỉ thành viên sáng lập)',
	'founderemails-email-user-registered-subject' => 'Một ai đó đã tham gia $WIKINAME!',
	'founderemails-email-user-registered-body' => 'Chào $FOUNDERNAME,

Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn! Tại sao bạn không ghé qua trang thảo luận của họ $USERTALKPAGEURL để gửi lời chào nhỉ?

-- Wikia Team',
	'founderemails-email-user-registered-greeting' => 'Chào $FOUNDERNAME,',
	'founderemails-email-user-registered-headline' => 'Xin chúc mừng! $USERNAME đã tham gia $WIKINAME.',
	'founderemails-email-user-registered-content' => 'Hãy nhân cơ hội này để chào đón họ đến wiki của bạn và khuyến khích họ trợ giúp sửa đổi. Càng nhiều càng tốt, càng nhanh hơn wiki của bạn sẽ tăng trưởng.',
	'founderemails-email-user-registered-signature' => 'Wikia Team',
	'founderemails-email-user-registered-button' => 'Chào đón họ',
	'founderemails-email-user-registered-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn! Tại sao bạn không ghé qua <a href="$USERTALKPAGEURL">trang thảo luận</a> của họ để gửi lời chào nhỉ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-email-0-days-passed-subject' => 'Chào mừng bạn đến với Wikia!',
	'founderemails-email-0-days-passed-body' => 'Xin chúc mừng về việc tạo ra $WIKINAME - bây giờ bạn là một phần của cộng đồng Wikia!

-- Wikia Team',
	'founderemails-email-0-days-passed-body-HTML' => 'Xin chúc mừng về việc tạo ra <strong>$WIKINAME</strong> - bây giờ bạn là một phần của cộng đồng Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">--Wikia Team</div>',
	'founderemails-email-3-days-passed-subject' => 'Kiểm tra',
	'founderemails-email-3-days-passed-body' => 'Chào $FOUNDERNAME

Bây giờ bạn đã có một vài ngày trên wiki, chúng tôi nghĩ bạn có thể muốn kiểm tra một số điều bạn có thể làm.

-- Wikia Team',
	'founderemails-email-3-days-passed-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Bây giờ bạn đã một vài ngày trên wiki, chúng tôi nghĩ rằng bạn có thể muốn kiểm tra một số điều bạn có thể làm.<br /><br />
<div style="font-style: italic; font-size: 120%;">--Wikia Team</div>',
	'founderemails-email-10-days-passed-subject' => 'Wiki của bạn tiến triển sao rồi?',
	'founderemails-email-10-days-passed-body' => 'Chào $FOUNDERNAME,

Cũng đã có một khoảng thời gian ngắn từ khi bạn bắt đầu wiki của mình trên Wikia - chúng tôi hy vọng nó sẽ rất tốt! Chúng tôi muốn chia sẻ một vài mẩu tin để giúp làm cho wiki của bạn trở thành ngôi nhà của chính bạn.

-- Wikia Team',
	'founderemails-email-page-edited-reg-user-first-edit-subject' => '$WIKINAME đã có một sửa đổi mới!',
	'founderemails-email-page-edited-reg-user-first-edit-body' => 'Chào $FOUNDERNAME,

Tất cả tốt chứ! $USERNAME đã có những sửa đổi đầu tiên trên $WIKINAME.

Ghé qua $PAGETITLE để kiểm tra những gì họ thêm vào.

Wikia Team',
	'founderemails-email-first-edit-greeting' => 'Chào $FOUNDERNAME,',
	'founderemails-email-first-edit-headline' => 'Tất cả tốt chứ! $USERNAME đã có những sửa đổi đầu tiên trên $WIKINAME.',
	'founderemails-email-first-edit-content' => 'Ghé qua $PAGETITLE để kiểm tra những gì họ thêm vào.',
	'founderemails-email-first-edit-signature' => 'Wikia Team',
	'founderemails-email-first-edit-button' => 'Kiểm tra ngay!',
	'founderemails-email-page-edited-reg-user-first-edit-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn và tạo ra lần sửa đổi đầu tiên! Tại sao bạn không ghé qua <a href="$USERTALKPAGEURL">trang thảo luận</a> của họ để gửi lời chào nhỉ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-email-page-edited-reg-user-subject' => 'Sửa đổi mới trên $WIKINAME!',
	'founderemails-email-page-edited-reg-user-body' => 'Chào $FOUNDERNAME,

$USERNAME đã có những sửa đổi khác trên $WIKINAME ở trang $PAGETITLE.

Ghé qua $PAGETITLE để xem những gì họ vừa thay đổi.

Wikia Team',
	'founderemails-email-general-edit-greeting' => 'Chào $FOUNDERNAME,',
	'founderemails-email-general-edit-headline' => '$USERNAME đã có những sửa đổi khác trên $WIKINAME ở trang $PAGETITLE.',
	'founderemails-email-general-edit-content' => 'Ghé qua $PAGETITLE để xem những gì họ vừa thay đổi.',
	'founderemails-email-general-edit-signature' => 'Wikia Team',
	'founderemails-email-general-edit-button' => 'Kiểm tra ngay!',
	'founderemails-email-page-edited-reg-user-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn và tạo ra sửa đổi! Tại sao bạn không ghé qua <a href="$USERTALKPAGEURL">trang thảo luận</a> của họ để gửi lời chào nhỉ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-email-page-edited-anon-subject' => 'Một người lạ đã sửa đổi $WIKINAME',
	'founderemails-email-page-edited-anon-body' => 'Chào $FOUNDERNAME,

Một thành viên Wikia vô danh đã tạo ra sửa đổi đầu tiên ở trang $PAGETITLE trên $WIKINAME.

Thành viên Wikia vô danh là những người dùng chưa đăng nhập tài khoản tạo ra sửa đổi. Đến xem người bạn lạ này đã thêm gì vào!

Wikia Team',
	'founderemails-email-anon-edit-greeting' => 'Chào $FOUNDERNAME,',
	'founderemails-email-anon-edit-headline' => 'Một thành viên Wikia vô danh đã tạo ra sửa đổi đầu tiên ở trang $PAGETITLE trên $WIKINAME.',
	'founderemails-email-anon-edit-content' => 'Thành viên Wikia vô danh là những người dùng chưa đăng nhập tài khoản tạo ra sửa đổi. Đến xem người bạn lạ này đã thêm gì vào!',
	'founderemails-email-anon-edit-signature' => 'Wikia Team',
	'founderemails-email-anon-edit-button' => 'Kiểm tra ngay!',
	'founderemails-email-page-edited-anon-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn và tạo ra sửa đổi! Tại sao bạn không <a href="$MYHOMEURL">kiểm tra</a> để xem thay đổi thế nào nhỉ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-answers-email-user-registered-subject' => 'Ai đó đã đăng ký tài khoản trên wiki của bạn!',
	'founderemails-answers-email-user-registered-body' => 'Chào $FOUNDERNAME,

Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn! Tại sao bạn không ghé qua trang thảo luận của họ $USERTALKPAGEURL để gửi lời chào nhỉ?

-- Wikia Team',
	'founderemails-answers-email-user-registered-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn! Tại sao bạn không ghé qua <a href="$USERTALKPAGEURL">trang thảo luận</a> của họ để gửi lời chào nhỉ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-answers-email-0-days-passed-subject' => 'Chào mừng bạn đến với Wikia!',
	'founderemails-answers-email-0-days-passed-body' => 'Xin chúc mừng về việc tạo ra $WIKINAME - bây giờ bạn là một phần của cộng đồng Wikia!

-- Wikia Team',
	'founderemails-answers-email-0-days-passed-body-HTML' => 'Xin chúc mừng về việc tạo ra <strong>$WIKINAME</strong> - bây giờ bạn là một phần của cộng đồng Wikia!<br /><br />
<div style="font-style: italic; font-size: 120%;">--Wikia Team</div>',
	'founderemails-answers-email-3-days-passed-subject' => 'Kiểm tra',
	'founderemails-answers-email-3-days-passed-body' => 'Chào $FOUNDERNAME

Bây giờ bạn đã có một vài ngày trên wiki, chúng tôi nghĩ bạn có thể muốn kiểm tra một số điều bạn có thể làm.

-- Wikia Team',
	'founderemails-answers-email-3-days-passed-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Bây giờ bạn đã một vài ngày trên wiki, chúng tôi nghĩ rằng bạn có thể muốn kiểm tra một số điều bạn có thể làm.<br /><br />
<div style="font-style: italic; font-size: 120%;">--Wikia Team</div>',
	'founderemails-answers-email-10-days-passed-subject' => 'Wiki của bạn tiến triển sao rồi?',
	'founderemails-answers-email-10-days-passed-body' => 'Chào $FOUNDERNAME,

Cũng đã có một khoảng thời gian ngắn từ khi bạn bắt đầu wiki của mình trên Wikia - chúng tôi hy vọng nó sẽ rất tốt! Chúng tôi muốn chia sẻ một vài mẩu tin để giúp làm cho wiki của bạn trở thành ngôi nhà của chính bạn.

-- Wikia Team',
	'founderemails-answers-email-10-days-passed-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Cũng đã có một khoảng thời gian ngắn từ khi bạn bắt đầu wiki của mình trên Wikia - chúng tôi hy vọng nó sẽ rất tốt! Chúng tôi muốn chia sẻ một vài mẩu tin để giúp làm cho wiki của bạn trở thành ngôi nhà của chính bạn.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-first-edit-subject' => 'Người dùng đăng ký đã thay đổi wiki của bạn đầu tiên!',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body' => 'Chào $FOUNDERNAME,

Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn và tạo ra lần sửa đổi đầu tiên! Tại sao bạn không ghé qua trang thảo luận của họ $USERTALKPAGEURL để gửi lời chào nhỉ?

-- Wikia Team',
	'founderemails-answers-email-page-edited-reg-user-first-edit-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn và tạo ra lần sửa đổi đầu tiên! Tại sao bạn không ghé qua <a href="$USERTALKPAGEURL">trang thảo luận</a> của họ để gửi lời chào nhỉ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-answers-email-page-edited-reg-user-subject' => 'Người dùng đăng ký đã thay đổi wiki của bạn!',
	'founderemails-answers-email-page-edited-reg-user-body' => 'Chào $FOUNDERNAME,

Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn và tạo ra sửa đổi! Tại sao bạn không ghé qua trang thảo luận của họ ($USERTALKPAGEURL) để gửi lời chào nhỉ?

-- Wikia Team',
	'founderemails-answers-email-page-edited-reg-user-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Trông giống như $USERNAME đã đăng ký tài khoản tại wiki của bạn và tạo ra sửa đổi! Tại sao bạn không ghé qua <a href="$USERTALKPAGEURL">trang thảo luận</a> của họ để gửi lời chào nhỉ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-answers-email-page-edited-anon-subject' => 'Ai đó đã thay đổi wiki của bạn!',
	'founderemails-answers-email-page-edited-anon-body' => 'Chào $FOUNDERNAME,

Trông giống như ai đó đã sửa đổi wiki của bạn! Tại sao bạn không kiểm tra $MYHOMEURL để xem thay đổi thế nào nhỉ?

-- Wikia Team',
	'founderemails-answers-email-page-edited-anon-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Trông giống như ai đó đã sửa đổi wiki của bạn! Tại sao bạn không <a href="$MYHOMEURL">kiểm tra</a> để xem thay đổi thế nào nhỉ?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-lot-happening-subject' => '$WIKINAME đang nóng lên!',
	'founderemails-lot-happening-body' => 'Hi $FOUNDERNAME,

Chúc mừng! Có rất nhiều sự kiện đang xảy ra tại $WIKINAME ngày hôm nay!

Nếu chưa rõ, bạn có thể đi đến Hoạt động của Wiki để xem tất cả những việc tuyệt vời vừa xảy ra.

Kể từ khi có rất nhiều hoạt động đang xảy ra, bạn cũng có thể muốn thay đổi tuỳ chọn thư điện tử ở chế độ tóm tắt. Với chế độ này, bạn sẽ nhận được một email có danh sách tất cả các hoạt động tại wiki của bạn mỗi ngày.

Wikia Team',
	'founderemails-lot-happening-body-HTML' => 'Chào $FOUNDERNAME,<br /><br />
Có rất nhiều thay đổi trên wiki của bạn ngày hôm nay! Hãy ghé qua $MYHOMEURL để xem những gì đang diễn ra.<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia Team</div>',
	'founderemails-email-lot-happening-greeting' => 'Chào $FOUNDERNAME,',
	'founderemails-email-lot-happening-headline' => 'Chúc mừng! Có rất nhiều sự kiện đang xảy ra tại $WIKINAME ngày hôm nay!',
	'founderemails-email-lot-happening-content' => 'Nếu chưa rõ, bạn có thể đi đến Hoạt động của Wiki để xem tất cả những việc tuyệt vời vừa xảy ra.  Kể từ khi có rất nhiều hoạt động đang xảy ra, bạn cũng có thể muốn thay đổi tuỳ chọn thư điện tử ở chế độ tóm tắt. Với chế độ này, bạn sẽ nhận được một email có danh sách tất cả các hoạt động tại wiki của bạn mỗi ngày.',
	'founderemails-email-lot-happening-signature' => 'Wikia Team',
	'founderemails-email-lot-happening-button' => 'Xem hoạt động',
	'founderemails-email-footer-line1' => 'Để kiểm tra những diễn biến và thay đổi mới nhất về Wikia, hãy truy cập <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'founderemails-email-footer-line2' => 'Muốn kiểm soát những email mà bạn nhận được? Đi đến [{{fullurl:{{ns:Đặc biệt}}:Tùy chọn}} Tùy chọn] của bạn',
	'founderemails-email-0-day-heading' => 'Rất vui được gặp bạn $FOUNDERNAME,',
	'founderemails-email-0-day-congratulations' => 'Chúc mừng về việc tạo ra $WIKINAME!',
	'founderemails-email-0-day-tips-heading' => 'Sau đây là một số mẹo hữu ích để giúp bạn bắt đầu:',
	'founderemails-email-0-day-addpages-heading' => 'Tạo trang.',
	'founderemails-email-0-day-addpages-content' => 'Wiki là nơi chia sẻ tất cả thông tin về một chủ đề duy nhất của bạn.  Tạo các trang bằng cách nhấp vào <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPAGEURL">"Tạo trang"</a> và điền những thông tin cụ thể về tiêu đề bài viết của bạn.',
	'founderemails-email-0-day-addpages-button' => 'Tạo trang',
	'founderemails-email-0-day-addphotos-heading' => 'Thêm hình ảnh',
	'founderemails-email-0-day-addphotos-content' => 'Các trang luôn luôn tốt hơn khi chúng có hình ảnh!  Thêm hình ảnh vào các trang của bạn và vào trang chính. Bạn có thể nhấp vào <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"Thêm hình ảnh"</a> để thêm một hình ảnh, một bộ sưu tập ảnh hoặc trình chiếu.',
	'founderemails-email-0-day-addphotos-button' => 'Thêm hình ảnh',
	'founderemails-email-0-day-customizetheme-heading' => 'Tùy chỉnh chủ đề màu nền.',
	'founderemails-email-0-day-customizetheme-content' => 'Tuỳ chỉnh màu nền, chủ đề wiki sao cho thật nổi bật!  Sử dụng <a style="color:#2a87d5;text-decoration:none;" href="$CUSTOMIZETHEMEURL">Thiết kế chủ đề</a> để tùy chỉnh và thêm màu sắc cho wiki và làm cho nó là duy nhất cho nội dung của wiki.',
	'founderemails-email-0-day-customizetheme-button' => 'Tùy chỉnh',
	'founderemails-email-0-day-wikiahelps-text' => '<span style="color:#2a87d5;font-weight:bold">Chúng tôi sẽ không rời bỏ bạn một mình.</span> Chúng tôi ở đây để giúp bạn thực hiện $ WIKINAME thành công từng bước. Truy cập <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> để đến diễn đàn, tư vấn, và giúp đỡ, hoặc <a style="color:#2a87d5;text-decoration:none;" href="http://www.wikia.com/Special:Contact">email cho chúng tôi</a> câu hỏi của bạn!',
	'founderemails-email-0-day-wikiahelps-signature' => 'Xây dựng wiki vui vẻ!<br />-- Wikia Team',
	'founderemails-email-3-day-heading' => 'Xin chào $FOUNDERNAME,',
	'founderemails-email-3-day-congratulations' => 'Chúng tôi đến kiểm tra và xem sự tiến triển của $WIKINAME.',
	'founderemails-email-3-day-tips-heading' => 'Đã 3 ngày kể từ khi bạn bắt đầu và chúng tôi nghĩ nên ghé qua để cung cấp lời khuyên một số chi tiết xây dựng wiki của bạn:',
	'founderemails-email-3-day-editmainpage-heading' => 'Làm đẹp trang chính của bạn.',
	'founderemails-email-3-day-editmainpage-content' => 'Trang chính là một trong những điều đầu tiên người khác nhìn thấy khi họ truy cập vào <a href="$WIKIURL" style="color:#2a87d5;text-decoration:none;">$WIKINAME</a>.  Tạo một ấn tượng tốt đầu tiên bằng văn bản tóm tắt chi tiết về những nội dung chủ đề của bạn và thêm một bộ sưu tập ảnh, hoặc khung trình chiếu.',
	'founderemails-email-3-day-editmainpage-button' => 'Làm Đẹp Nó',
	'founderemails-email-3-day-addphotos-heading' => 'Thêm nhiều hình ảnh hơn.',
	'founderemails-email-3-day-addphotos-content' => 'Một trong những cách tốt nhất để làm cho các trang của bạn linh hoạt và nổi bật là <a style="color:#2a87d5;text-decoration:none;" href="$ADDAPHOTOURL">"thêm hình ảnh"</a>',
	'founderemails-email-3-day-addphotos-button' => 'Thêm hình ảnh',
	'founderemails-email-3-day-explore-heading' => 'Tìm cảm hứng.',
	'founderemails-email-3-day-explore-content' => 'Đừng ngại khi kiểm tra các wiki khác để xem cách họ đã làm việc trên trang chính của họ, bài viết và nhiều hơn nữa.',
	'founderemails-email-3-day-explore-button' => 'Khám phá',
	'founderemails-email-3-day-wikiahelps-text' => 'Cần giúp đỡ để tìm ra cách gì đó làm việc? Chúng tôi luôn ở đây cùng bạn! Hãy đến yêu cầu chúng tôi giúp đỡ và tư vấn tại <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-3-day-wikiahelps-signature' => 'Giữ việc làm tuyệt vời nhé!<br />-- Wikia Team',
	'founderemails-email-10-day-heading' => 'Tiến triển thế nào rồi $FOUNDERNAME?',
	'founderemails-email-10-day-congratulations' => 'Whoa, thời gian nhanh thật! Đã được 10 ngày kể từ khi bạn bắt đầu $WIKINAME.',
	'founderemails-email-10-day-tips-heading' => 'Mời những người khác tham gia vào dự án của bạn và thể hiện tất cả công việc tuyệt vời mà bạn đã làm! Sau đây là một số cách để thực hiện:',
	'founderemails-email-10-day-share-heading' => 'Gia đình của bạn đã không nói bạn chia sẻ?',
	'founderemails-email-10-day-share-content' => 'Sử dụng nút Share trên thanh công cụ ở trang bài viết của bạn, và hình ảnh để hiển thị chúng cho bạn bè của bạn và những người theo bạn trên Facebook, Twitter, hoặc các trang web phổ biến khác.',
	'founderemails-email-10-day-email-heading' => 'Khai thác sức mạnh của thư điện tử.',
	'founderemails-email-10-day-email-content' => 'Gửi email cho người khác bạn biết những người quan tâm đến nội dung chủ đề của bạn hoặc quan tâm trong việc giúp đỡ bạn, giống như một người bạn từ trường học hoặc một đồng nghiệp.  Bạn cũng có thể gửi email hình ảnh cụ thể từ wiki của bạn bằng cách sử dụng nút thư điện tử',
	'founderemails-email-10-day-join-heading' => 'Tham gia wiki với các trang web tương tự.',
	'founderemails-email-10-day-join-content' => 'Yêu cầu mọi người trên các diễn đàn hoặc các trang web về chủ đề của bạn để được giúp đỡ bằng cách đăng lên ý kiến trong diễn đàn của họ. Nếu có thể, hãy liên hệ với người quản trị và xem nếu họ quan tâm trong việc chia sẻ liên kết &mdash; họ sẽ đặt liên kết wiki của bạn trên trang web của họ nếu bạn đặt liên kết của họ tại wiki của bạn.',
	'founderemails-email-10-day-wikiahelps-text' => 'Bạn cũng có thể yêu cầu các thành viên Wikia đến giúp đỡ wiki của bạn bằng cách gửi lời trợ giúp tại diễn đàn trên <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>.',
	'founderemails-email-10-day-wikiahelps-signature' => 'Giữ việc làm tuyệt vời nhé!<br />-- Wikia Team',
	'founderemails-email-views-digest-subject' => 'Góc nhìn hôm nay của $ WIKINAME',
	'founderemails-email-views-digest-body' => 'Chào $FOUNDERNAME,

Hôm nay $WIKINAME đã được viếng thăm bởi # people.

Tiếp tục bổ sung nội dung mới và thúc đẩy wiki của bạn để khuyến khích nhiều người đến để đọc, sửa đổi và làm phong phú nội dung.

Wikia Team',
	'founderemails-email-views-digest-greeting' => 'Chào $FOUNDERNAME,',
	'founderemails-email-views-digest-headline' => 'Hôm nay $WIKINAME đã được viếng thăm bởi $UNIQUEVIEWS người.',
	'founderemails-email-views-digest-content' => 'Tiếp tục bổ sung nội dung mới và thúc đẩy wiki của bạn để khuyến khích nhiều người đến để đọc, sửa đổi và làm phong phú nội dung.',
	'founderemails-email-views-digest-signature' => 'Wikia Team',
	'founderemails-email-views-digest-button' => 'Thêm nhiều trang hơn',
	'founderemails-email-complete-digest-subject' => 'Hoạt động mới nhất trên $WIKINAME',
	'founderemails-email-complete-digest-body' => 'Chào $FOUNDERNAME,

Đây là thời gian biểu hàng ngày của các hoạt động từ $WIKINAME.

$UNIQUEVIEWS người xem wiki của bạn.

Giữ công việc tuyệt vời thêm nội dung thú vị cho người đọc!

$USEREDITS lần sửa đổi được tạo ra.

Biên tập viên hạnh phúc làm cho wiki tốt hơn. Hãy chắc chắn cảm ơn những biên tập viên của bạn và dành riêng một chút thời gian trò chuyện cùng họ.

$USERJOINS người tham gia wiki của bạn.

Chào đón những người mới đến wiki của bạn với một thông điệp tại trang thảo luận.

Bạn luôn luôn có thể ghé qua hoạt động của wiki để xem tất cả những thay đổi được thực hiện trên $WIKINAME. Kiểm tra thường xuyên, là người sáng lập cộng đồng, cộng đồng của bạn sẽ trông cậy bạn để tìm kiếm trợ giúp và hướng dẫn cho các hoạt động biên tập wiki.

Wikia Team',
	'founderemails-email-complete-digest-greeting' => 'Chào $FOUNDERNAME,',
	'founderemails-email-complete-digest-headline' => 'Đây là thời gian biểu hàng ngày của các hoạt động từ $WIKINAME.',
	'founderemails-email-complete-digest-content-heading1' => '$UNIQUEVIEWS người xem wiki của bạn.',
	'founderemails-email-complete-digest-content1' => 'Giữ công việc tuyệt vời, thêm nội dung thú vị cho người đọc!',
	'founderemails-email-complete-digest-content-heading2' => '$USEREDITS lần sửa đổi được tạo ra.',
	'founderemails-email-complete-digest-content2' => 'Biên tập viên hạnh phúc làm cho wiki tốt hơn. Hãy chắc chắn cảm ơn những biên tập viên của bạn và dành riêng một chút thời gian trò chuyện cùng họ.',
	'founderemails-email-complete-digest-content-heading3' => '$USERJOINS người tham gia wiki của bạn.',
	'founderemails-email-complete-digest-content3' => 'Chào đón những người mới đến wiki của bạn với một thông điệp tại trang thảo luận.
<br /><br />
Bạn luôn luôn có thể ghé qua hoạt động của wiki để xem tất cả những thay đổi được thực hiện trên $WIKINAME. Kiểm tra thường xuyên, là người sáng lập cộng đồng, cộng đồng của bạn sẽ trông cậy bạn để tìm kiếm trợ giúp và hướng dẫn cho các hoạt động biên tập wiki.',
	'founderemails-email-complete-digest-signature' => 'Wikia Team',
	'founderemails-email-complete-digest-button' => 'Đi đến hoạt động của wiki',
	'founderemails-pref-joins' => 'Gửi email cho tôi khi có người tham gia $1',
	'founderemails-pref-edits' => 'Gửi email cho tôi khi có ai đó sửa đổi $1',
	'founderemails-pref-views-digest' => 'Gửi tôi một email hàng ngày cho tôi biết bao nhiêu lần $1 đã được viếng thăm',
	'founderemails-pref-complete-digest' => 'Gửi cho tôi một bản tóm tắt hàng ngày của các hoạt động trên $1',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'founderemails-email-0-day-addpages-heading' => '添加页面',
	'founderemails-email-0-day-addpages-button' => '添加一个页面',
	'founderemails-email-0-day-addphotos-heading' => '添加照片',
	'founderemails-email-0-day-addphotos-button' => '添加一个照片',
	'founderemails-email-3-day-addphotos-button' => '添加照片',
);

