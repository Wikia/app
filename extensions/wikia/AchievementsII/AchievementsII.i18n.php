<?php
$messages = array();

$messages['en'] = array(
	'achievementsii-desc' => 'An achievement badges system for wiki users',
	'achievements-upload-error' => 'Sorry!
That picture does not work.
Make sure that it is a .jpg or .png file.
If it still does not work, then the picture may be too big.
Please try another one!',
	'achievements-upload-not-allowed' => 'Administrators can change the names and pictures of Achievement badges by visiting [[Special:AchievementsCustomize|the Customize achievements]] page.',
	'achievements-non-existing-category' => 'The specified category does not exist.',
	'achievements-edit-plus-category-track-exists' => 'The specified category already has an <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">associated track</a>.',
	'achievements-no-stub-category' => 'Please do not create tracks for stubs.',
	'right-platinum' => 'Create and edit Platinum badges',
	'right-sponsored-achievements' => 'Manage Sponsored achievements',
	'right-achievements-exempt' => 'User is ineligible to earn achievement points',
	'right-achievements-explicit' => 'User is eligible to earn achievement points (Overrides exempt)',
	'action-platinum' => 'create and edit Platinum badges',
	'achievements-platinum' => 'Platinum',
	'achievements-gold' => 'Gold',
	'achievements-silver' => 'Silver',
	'achievements-bronze' => 'Bronze',
	'achievements-gold-points' => '100<br />pts',
	'achievements-silver-points' => '50<br />pts',
	'achievements-bronze-points' => '10<br />pts',
	'achievements-you-must' => 'You need to $1 to earn this badge.',
	'leaderboard-button' => 'Achievements Leaderboard',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|point|points}}</small>',
	'achievements-track-name-edit' => 'Edit track',
	'achievements-track-name-picture' => 'Pictures track',
	'achievements-track-name-category' => 'Category track',
	'achievements-track-name-blogpost' => 'Blog Post track',
	'achievements-track-name-blogcomment' => 'Blog Comment track',
	'achievements-track-name-love' => 'Wiki Love track',
	'achievements-track-name-sharing' => 'Sharing track',
	'achievements-notification-title' => 'Way to go, $1!',
	'achievements-notification-subtitle' => 'You just earned the "<strong>$1</strong>" badge $2',
	'achievements-notification-link' => "'''<big>[[Special:MyPage|Click here to see more badges you can earn!]]</big>'''",
	'achievements-points' => '$1 {{PLURAL:$1|point|points}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|point|points}}',
	'achievements-earned' => 'This badge has been earned by<br />{{PLURAL:$1|1 person|$1 people}}.',
	'achievements-profile-title' => "$1's $2 Earned {{PLURAL:$2|Badge|Badges}}",
	'achievements-profile-title-no' => "$1's {{PLURAL:$2|Badge|Badges}}",
	'achievements-profile-title-challenges' => 'More Badges You Can Earn!',
	'achievements-profile-customize' => 'Customize Badges',
	'achievements-ranked' => 'Ranked #$1 on this wiki',
	'achievements-no-badges' => 'Check out the list below to see the badges that you can earn on this wiki!',
	'achievements-viewall' => 'View all',
	'achievements-viewless' => 'Close',
	'achievements-profile-title-oasis' => 'achievement <br /> points',
	'achievements-ranked-oasis' => '$1 is [[Special:Leaderboard|Ranked #$2]] on this wiki',
	'achievements-viewall-oasis' => 'See all',
	'achievements-next-oasis' => 'Next',
	'achievements-prev-oasis' => 'Previous',
	'achievements-toggle-hide' => 'Hide my achievements on my profile from everybody',
	'leaderboard-intro-hide' => 'hide',
	'leaderboard-intro-open' => 'open',
	'leaderboard-intro-headline' => 'What are Achievements?',
	'leaderboard-intro' => "You can earn badges on this wiki by editing pages, uploading photos and leaving comments. Each badge earns you points - the more points you get, the higher up the leaderboard you go! You'll find the badges you've earned on your [[$1|user profile page]].

	'''What are badges worth?'''",
	'leaderboard' => 'Achievements Leaderboard',
	'achievements-title' => 'Achievements',
	'leaderboard-title' => 'Leaderboard',
	'achievements-recent-earned-badges' => 'Recent Earned Badges',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />earned by <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'earned the <strong><a href="$3" class="badgeName">$1</a></strong> badge<br />$2',
	'achievements-leaderboard-disclaimer' => 'Leaderboard shows changes since yesterday',
	'achievements-leaderboard-rank-label' => 'Rank',
	'achievements-leaderboard-member-label' => 'Member',
	'achievements-leaderboard-points-label' => 'Points',
	'achievements-leaderboard-points' => '{{PLURAL:$1|point|points}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Most recently earned',
	'achievements-send' => 'Save picture',
	'achievements-save' => 'Save changes',
	'achievements-reverted' => 'Badge reverted to original.',
	'achievements-customize' => 'Customize picture',
	'achievements-customize-new-category-track' => 'Create new track for category:',
	'achievements-enable-track' => 'enabled',
	'achievements-revert' => 'Revert to default',
	'achievements-special-saved' => 'Changes saved.',
	'achievements-special' => 'Special Achievements',
	'achievements-secret' => 'Secret Achievements',
	'achievementscustomize' => 'Customize badges',
	'achievements-about-title' => 'About this page...',
	'achievements-about-content' => 'Administrators on this wiki can customize the names and pictures of the achievement badges. You can upload any .jpg or .png picture, and your picture will automatically fit inside the frame. It works best when your picture is square, and when the most important part of the picture is right in the middle. You can use rectangular pictures, but you might find that a bit gets cropped out by the frame. If you have a graphics program, then you can crop your picture to put the important part of the image in the center. If you don\'t have a graphics program, then just experiment with different pictures until you find the ones that work for you! If you don\'t like the picture that you\'ve chosen, click "{{int:achievements-revert}}" to go back to the original graphic. You can also give the badges new names that reflect the topic of the wiki. When you\'ve changed badge names, click "{{int:achievements-save}}" to save your changes. Have fun!',
	'achievements-edit-plus-category-track-name' => '$1 edit track',
	'achievements-create-edit-plus-category-title' => 'Create a new Edit track',
	'achievements-create-edit-plus-category-content' => 'You can create a new set of badges that reward users for editing pages in a particular category, to highlight a particular area of the site that users would enjoy working on.
You can set up more than one category track, so try choosing two categories that would help users show off their specialty!
Ignite a rivalry between the users who edit Vampires pages and the users who edit Werewolves pages, or Wizards and Muggles, or Autobots and Decepticons.

To create a new "Edit in category" track, type the name of the category in the field below.
The regular Edit track will still exist;
this will create a separate track that you can customize separately.

When the track is created, the new badges will appear in the list on the left, under the regular Edit track.
Customize the names and images for the new track, so that users can see the difference!

Once you have done the customization, click the "{{int:achievements-enable-track}}" checkbox to turn on the new track, and then click "{{int:achievements-save}}".
Users will see the new track appear on their user profiles, and they will start earning badges when they edit pages in that category.
You can also disable the track later, if you decide you do not want to highlight that category anymore.
Users who have earned badges in that track will always keep their badges, even if the track is disabled.

This can help to bring another level of fun to the achievements.
Try it out!',
	'achievements-create-edit-plus-category' => 'Create this track',
	'platinum' => 'Platinum',
	'achievements-community-platinum-awarded-email-subject' => 'You have been awarded a new Platinum badge!',
	'achievements-community-platinum-awarded-email-body-text' => "Congratulations $1!

You have just been awarded with the '$2' Platinum badge on $4 ($3).
This adds 250 points to your score!

Check out your fancy new badge on your user profile page:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Congratulations $1!</strong><br /><br />
You have just been awarded with the \'<strong>$2</strong>\' Platinum badge on <a href="$3">$4</a>.
This adds 250 points to your score!<br /><br />
Check out your fancy new badge on your <a href="$5">user profile page</a>.',
	'achievements-community-platinum-awarded-for' => 'Awarded for:',
	'achievements-community-platinum-how-to-earn' => 'How to earn:',
	'achievements-community-platinum-awarded-for-example' => 'e.g. "for doing..."',
	'achievements-community-platinum-how-to-earn-example' => 'e.g. "make 3 edits..."',
	'achievements-community-platinum-badge-image' => 'Badge image:',
	'achievements-community-platinum-awarded-to' => 'Awarded to:',
	'achievements-community-platinum-current-badges' => 'Current platinum badges',
	'achievements-community-platinum-create-badge' => 'Create badge',
	'achievements-community-platinum-enabled' => 'enabled',
	'achievements-community-platinum-show-recents' => 'show in recent badges',
	'achievements-community-platinum-edit' => 'edit',
	'achievements-community-platinum-save' => 'save',
	'achievements-community-platinum-cancel' => 'cancel',
	'achievements-community-platinum-sponsored-label' => 'Sponsored achievement',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Hover picture <small>(hover minimum size: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Tracking URL for badge impressions:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Tracking URL for Hover impression:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Badge link <small>(DART click command URL)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Click for more information',
	'achievements-badge-name-edit-0' => 'Making a Difference',
	'achievements-badge-name-edit-1' => 'Just the Beginning',
	'achievements-badge-name-edit-2' => 'Making Your Mark',
	'achievements-badge-name-edit-3' => 'Friend of the Wiki',
	'achievements-badge-name-edit-4' => 'Collaborator',
	'achievements-badge-name-edit-5' => 'Wiki Builder',
	'achievements-badge-name-edit-6' => 'Wiki Leader',
	'achievements-badge-name-edit-7' => 'Wiki Expert',
	'achievements-badge-name-picture-0' => 'Snapshot',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illustrator',
	'achievements-badge-name-picture-3' => 'Collector',
	'achievements-badge-name-picture-4' => 'Art Lover',
	'achievements-badge-name-picture-5' => 'Decorator',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Curator',
	'achievements-badge-name-category-0' => 'Make a Connection',
	'achievements-badge-name-category-1' => 'Trail Blazer',
	'achievements-badge-name-category-2' => 'Explorer',
	'achievements-badge-name-category-3' => 'Tour Guide',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Bridge Builder',
	'achievements-badge-name-category-6' => 'Wiki Planner',
	'achievements-badge-name-blogpost-0' => 'Something to Say',
	'achievements-badge-name-blogpost-1' => 'Five Things to Say',
	'achievements-badge-name-blogpost-2' => 'Talk Show',
	'achievements-badge-name-blogpost-3' => 'Life of the Party',
	'achievements-badge-name-blogpost-4' => 'Public Speaker',
	'achievements-badge-name-blogcomment-0' => 'Opinionator',
	'achievements-badge-name-blogcomment-1' => 'And One More Thing',
	'achievements-badge-name-love-0' => 'Key to the Wiki!',
	'achievements-badge-name-love-1' => 'Two Weeks on the Wiki',
	'achievements-badge-name-love-2' => 'Devoted',
	'achievements-badge-name-love-3' => 'Dedicated',
	'achievements-badge-name-love-4' => 'Addicted',
	'achievements-badge-name-love-5' => 'A Wiki Life',
	'achievements-badge-name-love-6' => 'Wiki Hero!',
	'achievements-badge-name-sharing-0' => 'Sharer',
	'achievements-badge-name-sharing-1' => 'Bring it back',
	'achievements-badge-name-sharing-2' => 'Speaker',
	'achievements-badge-name-sharing-3' => 'Announcer',
	'achievements-badge-name-sharing-4' => 'Evangelist',
	'achievements-badge-name-welcome' => 'Welcome to the Wiki',
	'achievements-badge-name-introduction' => 'Introduction',
	'achievements-badge-name-sayhi' => 'Stopping By to Say Hi',
	'achievements-badge-name-creator' => 'The Creator',
	'achievements-badge-name-pounce' => 'Pounce!',
	'achievements-badge-name-caffeinated' => 'Caffeinated',
	'achievements-badge-name-luckyedit' => 'Lucky Edit',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|share link|get {{PLURAL:$1|one person|$1 people}} clicked on link you shared}}',
	'achievements-badge-to-get-edit' => 'make $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|an article|articles}}',
	'achievements-badge-to-get-edit-plus-category' => 'make {{PLURAL:$1|one edit|$1 edits}} on {{PLURAL:$1|a $2 article|$2 articles}}',
	'achievements-badge-to-get-picture' => 'add $1 {{PLURAL:$1|picture|pictures}} to {{PLURAL:$1|an article|articles}}',
	'achievements-badge-to-get-category' => 'add $1 {{PLURAL:$1|article|articles}} to {{PLURAL:$1|a category|categories}}',
	'achievements-badge-to-get-blogpost' => 'write $1 {{PLURAL:$1|blog post|blog posts}}',
	'achievements-badge-to-get-blogcomment' => 'write a comment on {{PLURAL:$1|a blog post|$1 different blog posts}}',
	'achievements-badge-to-get-love' => 'contribute to the wiki every day for {{PLURAL:$1|one day|$1 days}}',
	'achievements-badge-to-get-welcome' => 'join the wiki',
	'achievements-badge-to-get-introduction' => 'add to your own user page',
	'achievements-badge-to-get-sayhi' => 'leave someone a message on their talk page',
	'achievements-badge-to-get-creator' => 'be the creator of this wiki',
	'achievements-badge-to-get-pounce' => 'be quick',
	'achievements-badge-to-get-caffeinated' => 'make 100 edits on article pages in a single day',
	'achievements-badge-to-get-luckyedit' => 'be lucky',
	'achievements-badge-to-get-sharing-details' => 'Share links and get others to click on them!',
	'achievements-badge-to-get-edit-details' => "Is something missing? Is there a mistake? Don't be shy.<br />Click the edit button and<br />you can add to any page!",
	'achievements-badge-to-get-edit-plus-category-details' => 'The <strong>$1</strong> pages need your help!
Click the "{{int:edit}}" button on any page in that category to help out.
Show your support for the $1 pages!',
	'achievements-badge-to-get-picture-details' => 'Click the edit button, and then the Add a picture button. You can add a photo from your computer, or from another page on the wiki.',
	'achievements-badge-to-get-category-details' => 'Categories are tags that help readers find similar pages.<br />Click the Add category button<br />at the bottom of an article<br />to list that page in a category.',
	'achievements-badge-to-get-blogpost-details' => 'Write your opinions and questions! Click on Recent blog posts in<br />the sidebar, and then the link on the left for Create a new blog post.',
	'achievements-badge-to-get-blogcomment-details' => 'Add your two cents! Read any of the recent blog posts, and<br />write your thoughts in the comments box.',
	'achievements-badge-to-get-love-details' => 'The counter resets if you miss a day, so be sure to come back<br />to the wiki every day!',
	'achievements-badge-to-get-welcome-details' => 'Click the "{{int:oasis-signup}}" button at the top right to join the community.
You can start earning your own badges!',
	'achievements-badge-to-get-introduction-details' => 'Is your user page empty?
Click on your user name at the top of the screen to see.
Click "{{int:edit}}" to add some information about yourself!',
	'achievements-badge-to-get-sayhi-details' => 'You can leave other users messages by clicking "{{int:addsection}}" on their talk page.
Ask for help, thank them for their work, or just say hi!',
	'achievements-badge-to-get-creator-details' => 'This badge is given to the person who founded the wiki.
Click the "{{int:createwiki}}" button at the top to start a site about whatever you like most!',
	'achievements-badge-to-get-pounce-details' => 'You have to be quick to earn this badge.
Click the "{{int:activityfeed}}" button to see the new pages that users are creating!',
	'achievements-badge-to-get-caffeinated-details' => 'It takes a busy day to earn this badge.
Keep editing!',
	'achievements-badge-to-get-luckyedit-details' => 'The Lucky Edit badge is given to the person who made the 1,000th edit on the wiki, and every 1,000 after that. To earn this badge, contribute a lot to the wiki<br />and hope you get lucky!',
	'achievements-badge-to-get-community-platinum-details' => 'This is a special Platinum badge that is only available for a limited time!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|for sharing one link|for getting {{PLURAL:$1|one person|$1 people}} to click on shared links}}',
	'achievements-badge-hover-desc-edit' => 'Awarded for making $1 {{PLURAL:$1|edit|edits}}<br />
on {{PLURAL:$1|an article|articles}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Awarded for making $1 {{PLURAL:$1|edit|edits}}<br />
on {{PLURAL:$1|a $2 article|$2 articles}}!',
	'achievements-badge-hover-desc-picture' => 'Awarded for adding $1 {{PLURAL:$1|picture|pictures}}<br />
to {{PLURAL:$1|an article|articles}}!',
	'achievements-badge-hover-desc-category' => 'Awarded for adding $1 {{PLURAL:$1|article|articles}}<br />
to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-hover-desc-blogpost' => 'Awarded for writing $1 {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-hover-desc-blogcomment' => 'Awarded for writing a comment<br />
on $1 different {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-hover-desc-love' => 'Awarded for contributing to the wiki every day for {{PLURAL:$1|one day|$1 days}}!',
	'achievements-badge-hover-desc-welcome' => 'Awarded for joining the wiki!',
	'achievements-badge-hover-desc-introduction' => 'Awarded for adding to<br />
your own user page!',
	'achievements-badge-hover-desc-sayhi' => "Awarded for leaving a message<br />
on someone else's talk page!",
	'achievements-badge-hover-desc-creator' => 'Awarded for creating the wiki!',
	'achievements-badge-hover-desc-pounce' => "Awarded for making an edit within an hour of a page's creation, one hundred times!",
	'achievements-badge-hover-desc-caffeinated' => 'Awarded for making 100 edits on articles in a single day!',
	'achievements-badge-hover-desc-luckyedit' => 'Awarded for making the Lucky $1th Edit on the wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'This is a special Platinum badge that is only available for a limited time!',
	'achievements-badge-your-desc-sharing' => 'Awarded {{#ifeq:$1|0|for sharing one link|for getting {{PLURAL:$1|one person|$1 people}} to click on shared links}}',
	'achievements-badge-your-desc-edit' => 'Awarded for making {{PLURAL:$1|your first edit|$1 edits}} on {{PLURAL:$1|an article|articles}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'Awarded for making {{PLURAL:$1|your first edit|$1 edits}} on {{PLURAL:$1|a $2 article|$2 articles}}!',
	'achievements-badge-your-desc-picture' => 'Awarded for adding {{PLURAL:$1|your first picture|$1 pictures}} to {{PLURAL:$1|an article|articles}}!',
	'achievements-badge-your-desc-category' => 'Awarded for adding {{PLURAL:$1|your first article|$1 articles}} to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-your-desc-blogpost' => 'Awarded for writing {{PLURAL:$1|your first blog post|$1 blog posts}}!',
	'achievements-badge-your-desc-blogcomment' => 'Awarded for writing a comment on {{PLURAL:$1|a blog post|$1 different blog posts}}!',
	'achievements-badge-your-desc-love' => 'Awarded for contributing to the wiki every day for {{PLURAL:$1|one day|$1 days}}!',
	'achievements-badge-your-desc-welcome' => 'Awarded for joining the wiki!',
	'achievements-badge-your-desc-introduction' => 'Awarded for adding to your own user page!',
	'achievements-badge-your-desc-sayhi' => "Awarded for leaving a message on someone else's talk page!",
	'achievements-badge-your-desc-creator' => 'Awarded for creating the wiki!',
	'achievements-badge-your-desc-pounce' => "Awarded for making edits on 100 articles within an hour of the page's creation!",
	'achievements-badge-your-desc-caffeinated' => 'Awarded for making 100 edits on pages in a single day!',
	'achievements-badge-your-desc-luckyedit' => 'Awarded for making the Lucky $1th edit on the wiki!',
	'achievements-badge-desc-sharing' => 'Awarded {{#ifeq:$1|0|for sharing one link|for getting {{PLURAL:$1|one person|$1 people}} to click on shared links}}',
	'achievements-badge-desc-edit' => 'Awarded for making $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|an article|articles}}!',
	'achievements-badge-desc-edit-plus-category' => 'Awarded for making $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a $2 article|$2 articles}}!',
	'achievements-badge-desc-picture' => 'Awarded for adding $1 {{PLURAL:$1|picture|pictures}} to {{PLURAL:$1|an article|articles}}!',
	'achievements-badge-desc-category' => 'Awarded for adding $1 {{PLURAL:$1|article|articles}} to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-desc-blogpost' => 'Awarded for writing $1 {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-desc-blogcomment' => 'Awarded for writing a comment on {{PLURAL:$1|a blog post|$1 different blog posts}}!',
	'achievements-badge-desc-love' => 'Awarded for contributing to the wiki every day for {{PLURAL:$1|a day|$1 days}}!',
	'achievements-badge-desc-welcome' => 'Awarded for joining the wiki!',
	'achievements-badge-desc-introduction' => 'Awarded for adding to your own user page!',
	'achievements-badge-desc-sayhi' => "Awarded for leaving a message on someone else's talk page!",
	'achievements-badge-desc-creator' => 'Awarded for creating the wiki!',
	'achievements-badge-desc-pounce' => "Awarded for making edits on 100 pages within an hour of the page's creation!",
	'achievements-badge-desc-caffeinated' => 'Awarded for making 100 edits on pages in a single day!',
	'achievements-badge-desc-luckyedit' => 'Awarded for making the Lucky $1th edit on the wiki!',
	'achievements-userprofile-title-no' => "$1's Earned Badges",
	'achievements-userprofile-title' => "$1's Earned {{PLURAL:$2|Badge|Badges}} ($2)",
	'achievements-userprofile-no-badges-owner' => 'Check out the list below to see the badges that you can earn on this wiki!',
	'achievements-userprofile-no-badges-visitor' => "This user hasn't earned any badge yet.",
	'achievements-userprofile-profile-score' => '<em>$1</em> Achievement<br />points',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Ranked #$1]]<br />on this wiki',
);

$messages['qqq'] = array(
	'achievementsii-desc' => '{{desc}}',
	'achievements-upload-error' => 'Гафу итегез!
Бу рәсем дөрес укылмый.
Ул .jpg яки .png форматында булырга тиеш.
Әгәр ул дөрес укылмый икән, рәсем бик зур булырга мөмкин.
Зинһар, яңадан тырышып карагыз!',
	'achievements-edit-plus-category-track-exists' => '{{doc-important|Do not change the link itself.}}
Parameters:
* $1 is the ID of an existing track used to jump to.',
	'right-platinum' => '{{doc-right}}',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Алтын',
	'achievements-silver' => 'Көмеш',
	'achievements-bronze' => 'Бронза',
	'achievements-you-must' => 'Parameters:
* $1 is the description of what needs to be achieved to earn a badge.

Possible messages for $1 are: {{msg-mw|achievements-badge-to-get-blogcomment|notext=1}}, {{msg-mw|achievements-badge-to-get-blogpost|notext=1}}, {{msg-mw|achievements-badge-to-get-caffeinated|notext=1}}, {{msg-mw|achievements-badge-to-get-category|notext=1}}, {{msg-mw|achievements-badge-to-get-creator|notext=1}}, {{msg-mw|achievements-badge-to-get-edit|notext=1}}, {{msg-mw|achievements-badge-to-get-edit-plus-category|notext=1}}, {{msg-mw|achievements-badge-to-get-introduction|notext=1}}, {{msg-mw|achievements-badge-to-get-love|notext=1}}, {{msg-mw|achievements-badge-to-get-luckyedit|notext=1}}, {{msg-mw|achievements-badge-to-get-picture|notext=1}}, {{msg-mw|achievements-badge-to-get-pounce|notext=1}}, {{msg-mw|achievements-badge-to-get-sayhi|notext=1}}, {{msg-mw|achievements-badge-to-get-welcome|notext=1}}',
	'achievements-masthead-points' => 'Parameters:
* $1 is the number of earned points.',
	'achievements-profile-title-no' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}} Parameters:
* $1 is a user name.',
	'achievements-track-name-edit' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}

This is a track name, so "edit" is a noun, not a verb. In other words, this could be translated as "track of edits", \'\'not\'\' as "edit the track".',
	'achievements-track-name-picture' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-track-name-category' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-track-name-blogpost' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-track-name-blogcomment' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-track-name-love' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-notification-title' => 'Parameters:
* $1 is a user name',
	'achievements-notification-subtitle' => 'Parameters:
* $1 is the badge name
* $2 is the action that triggered the earning. Example: {{msg-mw|achievements-badge-your-desc-edit}}

All messages for the triggers: {{msg-mw|achievements-badge-your-desc-blogcomment|notext=1}},
{{msg-mw|achievements-badge-your-desc-blogpost|notext=1}},
{{msg-mw|achievements-badge-your-desc-caffeinated|notext=1}},
{{msg-mw|achievements-badge-your-desc-category|notext=1}},
{{msg-mw|achievements-badge-your-desc-creator|notext=1}},
{{msg-mw|achievements-badge-your-desc-edit|notext=1}},
{{msg-mw|achievements-badge-your-desc-edit-plus-category|notext=1}},
{{msg-mw|achievements-badge-your-desc-introduction|notext=1}},
{{msg-mw|achievements-badge-your-desc-love|notext=1}},
{{msg-mw|achievements-badge-your-desc-luckyedit|notext=1}},
{{msg-mw|achievements-badge-your-desc-picture|notext=1}},
{{msg-mw|achievements-badge-your-desc-pounce|notext=1}},
{{msg-mw|achievements-badge-your-desc-sayhi|notext=1}},
{{msg-mw|achievements-badge-your-desc-welcome|notext=1}}.',
	'achievements-points' => 'Parameters:
* $1 is the number of points',
	'achievements-points-with-break' => 'Parameters:
* $1 is the number of points',
	'achievements-earned' => 'Parameters:
* $1 is the number of users that has earned a badge.',
	'achievements-profile-title' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}} Parameters:
* $1 is a user name
* $2 is the number of earned badges',
	'achievements-profile-title-challenges' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-ranked' => 'Parameter:
* $1 is the rank number of a user on a wiki with regards to achievement points.',
	'achievements-viewless' => '{{Identical|Close}}',
	'achievements-ranked-oasis' => "Parameters:
* $1 is a user name
* $2 is the user's position on the leaderboard
Example:
* John is Ranked #3 on this wiki",
	'leaderboard-intro-hide' => '{{Identical|Hide}}',
	'leaderboard-intro-open' => '{{Identical|Open}}',
	'achievements-recent-earned-badges' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-recent-info' => 'Parameters:
* $1 is a link to a user page
* $2 is a user name
* $3 is the name of a badge
* $4 is the description what was achieved to get the badge
* $5 is an expression of passed time in the current user language (5 seconds/minutes/hours/days ago, the date if the amount of days is more than 1 year)

$4 is any of:
* {{msg-mw|achievements-badge-desc-blogcomment}}
* {{msg-mw|achievements-badge-desc-blogpost}}
* {{msg-mw|achievements-badge-desc-caffeinated}}
* {{msg-mw|achievements-badge-desc-category}}
* {{msg-mw|achievements-badge-desc-creator}}
* {{msg-mw|achievements-badge-desc-edit}}
* {{msg-mw|achievements-badge-desc-edit-plus-category}}
* {{msg-mw|achievements-badge-desc-introduction}}
* {{msg-mw|achievements-badge-desc-love}}
* {{msg-mw|achievements-badge-desc-luckyedit}}
* {{msg-mw|achievements-badge-desc-picture}}
* {{msg-mw|achievements-badge-desc-pounce}}
* {{msg-mw|achievements-badge-desc-sayhi}}
* {{msg-mw|achievements-badge-desc-welcome}}',
	'achievements-activityfeed-info' => 'Parameters:
* $1 is the name of the badge
* $2 is why the badge was given
* $3 is a link to the leaderboard',
	'achievements-leaderboard-member-label' => '{{Identical|Member}}',
	'achievements-leaderboard-points-label' => '{{Identical|Point}}',
	'achievements-enable-track' => '{{Identical|Enabled}}',
	'achievementscustomize' => 'It should be in noun form since it is a tab text.',
	'achievements-edit-plus-category-track-name' => 'Parameters:
* $1 is user name or bot name',
	'achievements-community-platinum-awarded-email-body-text' => 'Parameters:
* $1 is the user name of the user to which the badge was awarded
* $2 is the badge name
* $3 is a URL to the server script path
* $4 is the site name
* $5 is a URL to a user profile page',
	'achievements-community-platinum-awarded-email-body-html' => 'Parameters:
* $1 is the user name of the user to which the badge was awarded
* $2 is the badge name
* $3 is a URL to the server script path
* $4 is the site name
* $5 is a URL to a user profile page',
	'achievements-community-platinum-enabled' => '{{Identical|Enabled}}',
	'achievements-community-platinum-edit' => '{{Identical|Edit}}',
	'achievements-community-platinum-save' => '{{Identical|Save}}',
	'achievements-community-platinum-cancel' => '{{Identical|Cancel}}',
	'achievements-badge-name-edit-0' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-edit-1' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-edit-2' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-edit-3' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-edit-4' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-edit-5' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-edit-6' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-edit-7' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-category-0' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-category-1' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-category-3' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-category-5' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-category-6' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-blogpost-0' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-blogpost-1' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-blogpost-2' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-blogpost-3' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-blogpost-4' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-blogcomment-1' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-love-0' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-love-1' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-love-5' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-love-6' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-welcome' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-sayhi' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-creator' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-name-luckyedit' => '{{doc-important|Capitalization has been requested by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-to-get-edit-plus-category' => 'Parameters:
* $1 is the number of edits
* $2 is a pagetype, e.g. content, talk, etc.',
	'achievements-badge-to-get-edit-plus-category-details' => 'What is $1 here? Possibly localised (?) form of "category", or another namespace name.',
	'achievements-badge-to-get-sayhi-details' => '{{doc-important|The word "people" was decided upon by Product Management of Wikia. Please do not change it in English.}}',
	'achievements-badge-hover-desc-edit' => 'Parameters:
* $1 is the number of edits made.',
	'achievements-badge-hover-desc-edit-plus-category' => 'Parameters:
* $1 is the number of edits made
* $2 is unknown (possibly localised form of "category")',
	'achievements-badge-hover-desc-picture' => 'Parameters:
* $1 is the number of images added to pages',
	'achievements-badge-hover-desc-category' => 'Parameters:
* $1 is number of pages added to categories',
	'achievements-badge-hover-desc-blogpost' => 'Parameters:
* $1 is the number of written blog posts',
	'achievements-badge-hover-desc-blogcomment' => 'Parameters:
* $1 is the number of comments written on distinct blog posts',
	'achievements-badge-hover-desc-love' => 'Parameters:
* $1 is the number of consecutive days on which edits were made',
	'achievements-badge-hover-desc-luckyedit' => 'Parameters:
* $1 is the so manieth edit that was made to the wiki',
	'achievements-badge-your-desc-edit' => 'Parameters:
* $1 is the number of edits made to pages',
	'achievements-badge-your-desc-edit-plus-category' => 'What is $2? Parameters:
* $1 is the number of edits made to pages of type $2
* $2 is unknown.',
	'achievements-badge-your-desc-picture' => 'Parameters:
* $1 is the number of images added to pages',
	'achievements-badge-your-desc-category' => 'Parameters:
* $1 is number of pages added to categories',
	'achievements-badge-your-desc-blogpost' => 'Parameters:
* $1 is the number of blog posts written',
	'achievements-badge-your-desc-blogcomment' => 'Parameters:
* $1 is the number of blog posts commented on',
	'achievements-badge-your-desc-love' => 'Parameters:
* $1 is the number of consecutive days with edits.',
	'achievements-badge-your-desc-luckyedit' => 'Parameters:
* $1 is the so manieth edit that was made to the wiki',
	'achievements-badge-desc-edit' => 'Parameters:
* $1 is the number of edits made to pages',
	'achievements-badge-desc-edit-plus-category' => 'Parameters:
* $1 is the number of edits made to a particular type of pages (related to $2)
* $2 is unknown (possibly localised form of "category")',
	'achievements-badge-desc-picture' => 'Parameters:
* $1 is the number of images added to pages',
	'achievements-badge-desc-category' => 'Parameters:
* $1 is number of pages added to categories',
	'achievements-badge-desc-luckyedit' => 'Parameters:
* $1 is the so manieth edit that was made to the wiki',
	'achievements-userprofile-title' => "*$1 is the user's name
*$2 is the number of badges the user has earned",
	'achievements-userprofile-ranked' => '*$1 is the ranking of the user.',
	'action-platinum' => '{{doc-action|platinum}}',
);

$messages['af'] = array(
	'achievements-platinum' => 'Platinum',
	'achievements-gold' => 'Goud',
	'achievements-silver' => 'Silwer',
	'achievements-bronze' => 'Brons',
	'achievements-viewall' => 'Wys almal',
	'achievements-viewless' => 'Sluit',
	'achievements-leaderboard-rank-label' => 'Rang',
	'achievements-leaderboard-member-label' => 'Lid',
	'achievements-leaderboard-points-label' => 'Punte',
	'platinum' => 'Platinum',
	'achievements-community-platinum-edit' => 'wysig',
	'achievements-community-platinum-save' => 'stoor',
	'achievements-community-platinum-cancel' => 'kanselleer',
	'achievements-badge-name-picture-3' => 'Versamelaar',
	'achievements-badge-name-picture-6' => 'Ontwerper',
	'achievements-badge-name-picture-7' => 'Kurator',
);

$messages['ar'] = array(
	'achievementsii-desc' => 'نظام الشارات الإنجاز لمستخدمي ويكي',
	'achievements-upload-error' => 'آسف! N! تلك الصورة لا يعمل! N! تأكد أنه هو ملف. jpg أو بابوا نيو غينيا.! N! إذا كان لا يزال لا يعمل ، ثم أن الصورة قد تكون كبيرة جدا.! N! الرجاء المحاولة واحد آخر!',
	'achievements-upload-not-allowed' => 'يمكن للإداريين تغيير أسماء وصور اشارات الانجاز من خلال الذهاب الى صفحة [[Special:AchievementsCustomize|the Customize achievements]]',
	'achievements-non-existing-category' => 'التصنيف المحدد غير موجود.',
	'achievements-edit-plus-category-track-exists' => 'التصنيف المختار لديه  <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="إنتقل إلى المسار"> مسار مرتبط به</a>.',
	'achievements-no-stub-category' => 'رجاء لا تقم بإنشاء مسارات للصفحات الصغيرة (بذرات).',
	'right-platinum' => 'إنشاء و تعديل شارات البلاتينوم.',
	'right-sponsored-achievements' => 'إدارة الشارات التي تملك رعاية.',
	'achievements-platinum' => 'بلاتين',
	'achievements-gold' => 'الذهب',
	'achievements-silver' => 'فضة',
	'achievements-bronze' => 'برونز',
	'achievements-gold-points' => '100<br />نقطة',
	'achievements-silver-points' => '50<br />نقطة',
	'achievements-bronze-points' => '10<br />نقطة',
	'achievements-you-must' => 'أنت بحاجة إلى $1 لكسب هذه الشارة.',
	'leaderboard-button' => 'قيادة الشارات.',
	'achievements-masthead-points' => '<small>{{PLURAL:$1|نقطة|نقاط}}</small> $1',
	'achievements-profile-title-no' => 'شارات $1',
	'achievements-no-badges' => 'تحقق من القائمة أدناه لمشاهدة الشارات التي يمكنك كسبها في هذه الويكي!',
	'achievements-track-name-edit' => 'متابعة التعديلات',
	'achievements-track-name-picture' => 'متابعة الصور',
	'achievements-track-name-category' => 'متابعة التصنيفات',
	'achievements-track-name-blogpost' => 'متابعة المدونة',
	'achievements-track-name-blogcomment' => 'متابعة التعليقات على المدونة',
	'achievements-track-name-love' => 'متابعة محبة الويكي',
	'achievements-track-name-sharing' => 'متابعة النشر',
	'achievements-notification-title' => 'أحسنت يا $1!',
	'achievements-notification-subtitle' => 'لقد كسبت شارة  "$1". $2',
	'achievements-notification-link' => '<strong><big>[[خاص:MyPage|شاهد المزيد من الشارات التي يمكنك كسبها]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|نقطة|نقطة}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|نقطة|نقطة}}',
	'achievements-earned' => 'هذه الشارة يحملها {{PLURAL:$1|مستخدم واحد|$1 مستخدم}}.',
	'achievements-profile-title' => 'قائمة ال $2 {{PLURAL:$2|شارة|شارات}} التي يحملها $1.',
	'achievements-profile-title-challenges' => 'المزيد من الشارات التي يمكنك كسبها.',
	'achievements-viewall' => 'اعرض الكل',
	'achievements-viewless' => 'أغلق',
	'achievements-viewall-oasis' => 'أنظر أيضاً',
	'leaderboard-intro-hide' => 'أخفِ',
	'leaderboard-intro-open' => 'افتح',
	'achievements-leaderboard-rank-label' => 'الترتيب',
	'achievements-leaderboard-member-label' => 'عضو',
	'achievements-leaderboard-points-label' => 'النقاط',
	'achievements-leaderboard-points' => '{{PLURAL:$1||نقطة واحدة|نقطتان|$1 نقاط|$1 نقطة}}',
	'achievements-about-title' => 'حول هذه الصفحة...',
	'platinum' => 'بلاتين',
	'achievements-community-platinum-enabled' => 'تمكين',
	'achievements-community-platinum-edit' => 'عدل',
	'achievements-community-platinum-save' => 'احفظ',
	'achievements-community-platinum-cancel' => 'ألغِ',
);

$messages['as'] = array(
	'achievements-upload-error' => 'দুঃখিত!
এই ছবিখন কাৰ্য্যক্ষম নহয় |
ছবিখন .jpg বা .png হয় নে নহয় পুনাৰাই চাওক |
যদি তথাপিও ই কাৰ্য্যকৰী নহয় তেন্তে ছবিখন নিশ্চয় ডাঙৰ আকৃতিৰ |
অনুগ্ৰহ কৰি আন এখন ছবি চেষ্টা কৰক |',
	'achievements-non-existing-category' => 'উল্লেখিত শ্রেনীটোৰ  কোনো অস্তিত্ব নাই।',
);

$messages['az'] = array(
	'achievementsii-desc' => 'Wiki istifadəçilər üçün bir nailiyyət döş nişanları sistemi',
	'achievements-upload-error' => 'Bağışlayın!

Bu şəkil işləmir.

Əmin olun ki şəkil Bir. jpg və ya .png faylıdır.

Hələ də işləmirsə, onda şəkil çox böyük ola bilər.

Başqa bir cəhd edin!',
	'achievements-upload-not-allowed' => 'İdarəçilər adları və nailiyyət nişanları şəkilləri, [[Special: AchievementsCustomize | Özelleştir nailiyyətləri]] səhifəsinə baxmaqla dəyişdirə bilərlər.',
	'achievements-non-existing-category' => 'Müəyyən kateqoriya yoxdur.',
	'achievements-no-stub-category' => 'Qaralamalar üçün yollar (tracks) yaratmamaqı xahiş edirik.',
	'right-platinum' => 'Platinum nişanları yaradmaq və redaktə etmək.',
	'right-sponsored-achievements' => 'Sponsor İdarə nailiyyətləri.',
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Qızıl',
	'achievements-silver' => 'Gümüş',
	'achievements-bronze' => 'Bürünc',
	'achievements-gold-points' => '100<br />pts',
	'achievements-silver-points' => '50<br />pts',
	'achievements-bronze-points' => '10<br />pts',
	'achievements-you-must' => 'Bu nişan qazanmaq üçün $ 1 lazımdır.',
	'leaderboard-button' => 'Liderlərin nailiyyətləri.',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|point|points}}</small>',
	'achievements-profile-title-no' => '$ 1\'s döş nişanları.',
	'achievements-no-badges' => 'Bu wiki haqqında qazanmaq imkanı olan döş nişanları görmək üçün aşağıdakı siyahısını  yoxlayın!',
	'achievements-viewall' => 'Hamısına bax',
	'achievements-viewless' => 'Bağla',
	'achievements-viewall-oasis' => 'Həmçinin bax',
	'leaderboard-intro-hide' => 'gizlə',
	'leaderboard-intro-open' => 'açıq',
	'leaderboard' => 'Liderlərin nailiyyətləri',
	'achievements-title' => 'Nailiyyətlər',
	'leaderboard-title' => 'Liderlər',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br /> <a href="$1">$2</a> tərəfindən işlənib<br />$5',
	'achievements-leaderboard-rank-label' => 'Ranq',
	'achievements-leaderboard-member-label' => 'Üzv',
	'achievements-leaderboard-points-label' => 'Xallar',
	'achievements-leaderboard-points' => '{{PLURAL:$1|xal|xallar}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Bir qədər əvvəl hazırlanıb',
	'achievements-send' => 'Şəkili yadda saxla',
	'achievements-save' => 'Dəyişiklikləri yadda saxla',
	'achievements-customize' => 'Şəklin nizamlanması',
	'achievements-enable-track' => 'effektiv',
	'achievements-revert' => 'Susmaya görə olana qaytar',
	'achievements-special-saved' => 'Dəyişikliklər yaddaşda saxlandı.',
	'achievements-special' => 'Xüsusi nailiyyətlər',
	'achievements-secret' => 'Gizli nailiyyətlər',
	'achievementscustomize' => 'Nişanların nizamlanması',
	'achievements-about-title' => 'Bu səhifə haqqında...',
	'platinum' => 'Platin',
	'achievements-community-platinum-awarded-for' => 'Niyə mükafatlandırılıb:',
	'achievements-community-platinum-awarded-to' => 'Mükafatlandırılıb:',
	'achievements-community-platinum-enabled' => 'qoşulub',
	'achievements-community-platinum-edit' => 'redaktə',
	'achievements-community-platinum-save' => 'Qeyd et',
	'achievements-community-platinum-cancel' => 'ləğv et',
	'achievements-badge-name-edit-5' => 'Wiki Builder',
	'achievements-badge-name-edit-6' => 'Lider Viki',
	'achievements-badge-name-edit-7' => 'Ekspert Viki',
	'achievements-badge-name-picture-6' => 'Dizayner',
	'achievements-badge-name-welcome' => 'Vikiyə xöş gəlmişsiniz',
	'achievements-badge-to-get-edit' => ' {{PLURAL:$1|səhifədə}} $1 {{PLURAL:$1|düzəliş}} et',
	'achievements-badge-to-get-welcome' => 'Wikiyə qoşulmaq',
	'achievements-badge-to-get-introduction' => 'öz istifadəçi səhifənə əlavə et',
	'achievements-badge-to-get-creator' => 'Bu wikinin xaliqi olmaq',
	'achievements-badge-to-get-pounce' => 'tez ol',
	'achievements-badge-to-get-luckyedit' => 'bəxtiyar ol',
);

$messages['ba'] = array(
	'achievementsii-desc' => 'Вики-сайт ҡулланыусыларының ҡаҙаныштары систамаһы',
	'achievements-upload-error' => 'Ғафү итегеҙ!
Был рәсем тура килмәй.Файлдың .JPG йәки .PNG форматында булыуын тикшерегеҙ.
Әгәр рәсем барыбер дөрөҫ уҡылмаһа, тимәк ул бик ҙур.
Тағы бер мәртәбә эшләп ҡарағыҙ!',
	'achievements-upload-not-allowed' => ' Хакимдәр [[Special:AchievementsCustomize|Ҡаҙаныштар менән идары итеү]]  тигән махсус биттә тамғаларҙың исемдәрен һәм рәсемндәрен үҙгәртә ала.',
	'achievements-non-existing-category' => 'Был категория юҡ.',
);

$messages['be'] = array(
	'achievements-viewless' => 'Закрыць',
);

$messages['be-tarask'] = array(
	'achievementsii-desc' => 'Сыстэма дасягненьняў для вікі-карыстальнікаў',
	'achievements-upload-error' => 'Прабачце!
Гэтая выява — няслушная.
Упэўніцеся, што гэта файл фармату JPG ці PNG.
Калі ўсё роўна няслушная, гэта, верагодна, азначае, што выява занадта вялікая.
Калі ласка, паспрабуйце выкарыстаць іншую!',
	'achievements-upload-not-allowed' => 'Адміністратары могуць зьмяняць назвы і выявы ўзнагародаў наведаўшы старонку [[Special:AchievementsCustomize|кіраваньня дасягненьнямі]].',
	'achievements-non-existing-category' => 'Пазначаная катэгорыя не існуе.',
	'achievements-edit-plus-category-track-exists' => 'Пазначаная катэгорыя ўжо <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Перайсьці да трэку">прызначаны трэк</a>.',
	'achievements-no-stub-category' => 'Калі ласка, не стварайце трэкі для накідаў.',
	'right-platinum' => 'Стварыць і рэдагаваць плятынавую ўзнагароду',
	'right-sponsored-achievements' => 'Кіраваньне спансараванымі дасягненьнямі',
	'achievements-platinum' => 'Плятына',
	'achievements-gold' => 'Золата',
	'achievements-silver' => 'Срэбра',
	'achievements-bronze' => 'Бронза',
	'achievements-gold-points' => '100<br />пунктаў',
	'achievements-silver-points' => '50<br />пунктаў',
	'achievements-bronze-points' => '10<br />пунктаў',
	'achievements-you-must' => 'Вам неабходна $1, каб атрымаць гэтую ўзнагароду.',
	'leaderboard-button' => 'Дошка гонару',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|ачко|ачкі|ачкоў}}</small>',
	'achievements-profile-title-no' => 'Узнагароды $1',
	'achievements-no-badges' => 'Праглядзіце сьпіс пададзены ніжэй, каб убачыць узнагароды, якія Вы можаце атрымаць у {{GRAMMAR:месны|{{SITENAME}}}}!',
	'achievements-track-name-edit' => 'Рэдагаваць трэк',
	'achievements-track-name-picture' => 'Выява трэку',
	'achievements-track-name-category' => 'Катэгорыя трэку',
	'achievements-track-name-blogpost' => 'Паведамленьне ў блёге трэку',
	'achievements-track-name-blogcomment' => 'Камэнтар у блёге трэку',
	'achievements-track-name-love' => 'Трэк Wiki Love',
	'achievements-track-name-sharing' => 'Агульнадаступны трэк',
	'achievements-notification-title' => 'Так трымаць, $1!',
	'achievements-notification-subtitle' => 'Вы атрымалі ўзнагароду «$1» $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Паглядзіце, якія яшчэ ўзнагароды Вы можаце атрымаць]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|ачко|ачкі|ачкоў}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|ачко|ачкі|ачкоў}}',
	'achievements-earned' => 'Гэтая ўзнагарода для атрыманая $1 {{PLURAL:$1|удзельнікам|удзельнікамі|удзельнікамі}}.',
	'achievements-profile-title' => '$1 {{GENDER:$2|атрымаў|атрымала}} $2 {{PLURAL:$2|узнагароду|узнагароды|узнагародаў}}',
	'achievements-profile-title-challenges' => 'Вы можаце атрымаць болей узнагародаў!',
	'achievements-profile-customize' => 'Зьмяніць ўзнагароды',
	'achievements-ranked' => 'Узровень № $1 у {{GRAMMAR:месны|{{SITENAME}}}}',
	'achievements-viewall' => 'Паказаць усё',
	'achievements-viewless' => 'Закрыць',
	'achievements-profile-title-oasis' => 'дасягненьні <br /> ачкоў',
	'achievements-ranked-oasis' => '$1 займае [[Special:Leaderboard|$2 месца]] ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'achievements-viewall-oasis' => 'Паказаць усё',
	'achievements-toggle-hide' => 'Схаваць мае дасягненьні ў маім профілі ад усіх',
	'leaderboard-intro-hide' => 'схаваць',
	'leaderboard-intro-open' => 'адкрыць',
	'leaderboard-intro-headline' => 'Якія дасягненьні?',
	'leaderboard-intro' => "Вы можаце атрымаць ўзнагароды ў {{GRAMMAR:месны|{{SITENAME}}}} за рэдагаваньне старонак, загрузку фатаграфіяў і за камэнтары. Кожная ўзнагарода, якую Вы атрымаеце, дадае ачкі да Вашага агульнага ліку! Вы можаце знайсьці Вашыя атрыманыя ўзнагароды на [[$1|старонцы профілю]].

'''Што такое ўзнагароды?'''",
	'leaderboard' => 'Дошка гонару',
	'achievements-title' => 'Дасягненьні',
	'leaderboard-title' => 'Дошка гонару',
	'achievements-recent-earned-badges' => 'Апошнія атрыманыя ўзнагароды',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />атрыманая <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'атрымаў <strong><a href="$3" class="badgeName">$1</a></strong> узнагароду<br />$2',
	'achievements-leaderboard-disclaimer' => 'Дошка гонару паказвае зьмены з ўчарашняга дня',
	'achievements-leaderboard-rank-label' => 'Месца',
	'achievements-leaderboard-member-label' => 'Удзельнік',
	'achievements-leaderboard-points-label' => 'Пункты',
	'achievements-leaderboard-points' => '{{PLURAL:$1|пункт|пункты|пунктаў}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Апошнія ўзнагароды',
	'achievements-send' => 'Захаваць выяву',
	'achievements-save' => 'Захаваць зьмены',
	'achievements-reverted' => 'Узнагарода вернутая за арыгіналу.',
	'achievements-customize' => 'Устанавіць выяву',
	'achievements-customize-new-category-track' => 'Стварыць новы трэк для катэгорыі:',
	'achievements-enable-track' => 'уключана',
	'achievements-revert' => 'Аднавіць па змоўчваньні',
	'achievements-special-saved' => 'Зьмены захаваныя.',
	'achievements-special' => 'Спэцыяльныя дасягненьні',
	'achievements-secret' => 'Сакрэтныя дасягненьні',
	'achievementscustomize' => 'Зьмяніць ўзнагароды',
	'achievements-about-title' => 'Пра гэтую старонку…',
	'achievements-about-content' => 'Адміністратары {{GRAMMAR:родны|{{SITENAME}}}} могуць зьмяняць назвы і выявы узнагародаў.

Вы можаце загрузіць любую выяву ў фармаце .jpg ці .png, і яна аўтаматычна будзе ўстаўленая ў рамку.
Будзе лепей, калі Вашая выява будзе квадратнай, і калі самая важная частка выявы будзе знаходзіцца ў цэнтры.

Вы можаце выкарыстоўваць прамавугольныя выявы, але памятайце, што часткі выявы па-за межамі рамкі ня будуць паказвацца.
Калі Вы маеце графічную праграму, то Вы можаце памясьціць важную частку выявы ў цэнтар.
Калі Вы ня маеце графічнай праграмы, то можаце паспрабаваць выкарыстоўваць некалькі выяваў, каб выбраць тую, якая будзе пасаваць Вам найлепей!
Калі Вам не спадабалася выява, якую Вы ўжо выбралі, націсьніце «{{int:achievements-revert}}», каб вярнуцца да пачатковай выявы.

Таксама, Вы можаце зьмяняць назвы ўзнагародаў, каб яны лепей адпавядалі тэме {{GRAMMAR:родны|{{SITENAME}}}}.
Калі Вы зьмянілі назву ўзнагароды, націсьніце «{{int:achievements-save}}», каб захаваць Вашыя зьмены.
Цешцеся!',
	'achievements-edit-plus-category-track-name' => '$1 рэдагаваў трэк',
	'achievements-create-edit-plus-category-title' => 'Стварыць новы шлях',
	'achievements-create-edit-plus-category' => 'Стварыць шлях',
	'platinum' => 'Плятына',
	'achievements-community-platinum-awarded-email-subject' => 'Вы атрымалі новую плятынавую ўзнагароду!',
	'achievements-community-platinum-awarded-email-body-text' => "Віншуем, $1!

Вас толькі што узнагародзілі '$2' плятынавай узнагародай на $4 ($3).
Да Вашага рахунку дадаецца 250 пунктаў!

Вы можаце ўбачыць Вашую новую ўзнагароду ў Вашым профілі:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Віншуем, $1!</strong><br /><br />
Вы былі ўзнагароджаны плятынавай узнагародай \'<strong>$2</strong>\' на <a href="$3">$4</a>.
Да Вашага рахунку дадаецца 250 ачкоў!<br /><br />
Вы можаце ўбачыць Вашую новую ўзнагароду ў <a href="$5">Вашым профілі</a>.',
	'achievements-community-platinum-awarded-for' => 'Узнагароджаны за:',
	'achievements-community-platinum-how-to-earn' => 'Як атрымаць:',
	'achievements-community-platinum-awarded-for-example' => 'напрыклад, «за выкананьне…»',
	'achievements-community-platinum-how-to-earn-example' => 'напрыклад, «зрабіць тры рэдагаваньня…»',
	'achievements-community-platinum-badge-image' => 'Выява ўзнагароды:',
	'achievements-community-platinum-awarded-to' => 'Узнагароджаны:',
	'achievements-community-platinum-current-badges' => 'Цяперашнія плятынавыя ўзнагароды',
	'achievements-community-platinum-create-badge' => 'Стварыць узнагароду',
	'achievements-community-platinum-enabled' => 'уключана',
	'achievements-community-platinum-show-recents' => 'паказаць у апошніх узнагародах',
	'achievements-community-platinum-edit' => 'рэдагаваць',
	'achievements-community-platinum-save' => 'захаваць',
	'achievements-community-platinum-cancel' => 'скасаваць',
	'achievements-community-platinum-sponsored-label' => 'Спансараваныя дасягненьні',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Навісаючая выява <small>(мінімальны памер навісаючай выявы: 270пкс × 100пкс)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Сачэньне за URL-адрасам для меркаваньняў пра ўзнагароды:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Спасылка ўзнагароды <small>(DART націсьніце каманду URL)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Націсьніце для дадатковай інфармацыі',
	'achievements-badge-name-edit-0' => 'Рабіць зьмены',
	'achievements-badge-name-edit-1' => 'Толькі пачатак',
	'achievements-badge-name-edit-2' => 'Рабіць Вашыя меткі',
	'achievements-badge-name-edit-3' => 'Сябар {{GRAMMAR:родны|{{SITENAME}}}}',
	'achievements-badge-name-edit-4' => 'Супрацоўнік',
	'achievements-badge-name-edit-5' => 'Будаўнік {{GRAMMAR:родны|{{SITENAME}}}}',
	'achievements-badge-name-edit-6' => 'Лідэр {{GRAMMAR:родны|{{SITENAME}}}}',
	'achievements-badge-name-edit-7' => 'Экспэрт {{GRAMMAR:родны|{{SITENAME}}}}',
	'achievements-badge-name-picture-0' => 'Здымак',
	'achievements-badge-name-picture-1' => 'Папараццы',
	'achievements-badge-name-picture-2' => 'Ілюстратар',
	'achievements-badge-name-picture-3' => 'Калекцыянэр',
	'achievements-badge-name-picture-4' => 'Аматар мастацтваў',
	'achievements-badge-name-picture-5' => 'Дэкаратар',
	'achievements-badge-name-picture-6' => 'Дызайнэр',
	'achievements-badge-name-picture-7' => 'Куратар',
	'achievements-badge-name-category-0' => 'Зрабіць злучэньне',
	'achievements-badge-name-category-1' => 'Бліскучы сьлед',
	'achievements-badge-name-category-2' => 'Дасьледчык',
	'achievements-badge-name-category-3' => 'Экскурсавод',
	'achievements-badge-name-category-4' => 'Навігатар',
	'achievements-badge-name-category-5' => 'Будаўнік мастоў',
	'achievements-badge-name-category-6' => 'Пляніроўшчык {{GRAMMAR:родны|{{SITENAME}}}}',
	'achievements-badge-name-blogpost-0' => 'Што-небудзь сказаць',
	'achievements-badge-name-blogpost-2' => 'Ток-шоў',
	'achievements-badge-name-blogpost-4' => 'Дакладчык',
	'achievements-badge-name-blogcomment-1' => 'І яшчэ адна рэч',
	'achievements-badge-name-love-0' => 'Ключ да {{GRAMMAR:родны|{{SITENAME}}}}!',
	'achievements-badge-name-love-1' => 'Два тыдні ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'achievements-badge-name-love-2' => 'Прыхільны',
	'achievements-badge-name-love-3' => 'Прызначаны',
	'achievements-badge-name-love-4' => 'Захапляючыся',
	'achievements-badge-name-love-5' => 'Жыцьцё ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'achievements-badge-name-love-6' => 'Герой {{GRAMMAR:родны|{{SITENAME}}}}!',
	'achievements-badge-name-sharing-0' => 'Адкрыты доступ',
	'achievements-badge-name-welcome' => 'Вітаем у {{GRAMMAR:месны|{{SITENAME}}}}',
	'achievements-badge-name-introduction' => 'Уводзіны',
	'achievements-badge-name-sayhi' => 'Спыняецца, каб павітацца',
	'achievements-badge-name-creator' => 'Стваральнік',
	'achievements-badge-name-luckyedit' => 'Шчасьлівае рэдагаваньне',
	'achievements-badge-to-get-edit' => 'зрабіць $1 {{PLURAL:$1|рэдагаваньне|рэдагаваньня|рэдагаваньняў}} на {{PLURAL:$1|старонцы|старонках}}',
	'achievements-badge-to-get-picture' => 'дадаць $1 {{PLURAL:$1|выяву|выявы|выяваў}} на {{PLURAL:$1|старонцы|старонках}}',
	'achievements-badge-to-get-welcome' => 'далучыцца да {{GRAMMAR:родны|{{SITENAME}}}}',
	'achievements-badge-to-get-introduction' => 'дадаць на Вашую старонку ўдзельніка',
	'achievements-badge-to-get-sayhi' => 'пакінуў камусьці паведамленьне на старонцы гутарак',
	'achievements-badge-to-get-creator' => 'стваральнік {{GRAMMAR:родны|{{SITENAME}}}}',
	'achievements-badge-to-get-pounce' => 'будзь хуткім',
	'achievements-badge-desc-welcome' => 'за далучэньне да {{GRAMMAR:родны|{{SITENAME}}}}!',
	'achievements-badge-desc-introduction' => 'за даданьне Вашай уласнай старонкі ўдзельніка!',
	'achievements-badge-desc-sayhi' => 'за стварэньне паведамленьня на чыёй-небудзь старонцы абмеркаваньня!',
	'achievements-badge-desc-creator' => 'за стварэньне вікі!',
	'achievements-badge-desc-pounce' => 'за рэдагаваньне 100 старонак на працягу гадзіны пасьля стварэньня старонкі!',
);

$messages['bg'] = array(
	'achievements-non-existing-category' => 'Посочената категория не съществува.',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Злато',
	'achievements-silver' => 'Сребро',
	'achievements-bronze' => 'Бронз',
	'achievements-gold-points' => '100<br />т.',
	'achievements-silver-points' => '50<br />т.',
	'achievements-bronze-points' => '10<br />т.',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|точка|точки}}</small>',
	'achievements-profile-title-no' => 'Значките на $1',
	'achievements-points' => '$1 {{PLURAL:$1|точка|точки}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|точка|точки}}',
	'achievements-viewall' => 'Преглеждане на всички',
	'achievements-viewless' => 'Затваряне',
	'achievements-viewall-oasis' => 'Преглеждане на всички',
	'achievements-toggle-hide' => 'Скриване на моите постижения от профила ми за всички',
	'leaderboard-intro-hide' => 'скриване',
	'leaderboard-intro-open' => 'показване',
	'achievements-title' => 'Постижения',
	'achievements-leaderboard-rank-label' => 'Ранг',
	'achievements-leaderboard-member-label' => 'Член',
	'achievements-leaderboard-points-label' => 'Точки',
	'achievements-leaderboard-points' => '{{PLURAL:$1|точка|точки}}',
	'achievements-save' => 'Съхраняване на промените',
	'achievements-about-title' => 'За тази страница...',
	'achievements-community-platinum-how-to-earn' => 'Как се спечелва:',
	'achievements-community-platinum-create-badge' => 'Създаване на значка',
	'achievements-community-platinum-edit' => 'редактиране',
	'achievements-community-platinum-save' => 'съхраняване',
	'achievements-community-platinum-cancel' => 'отказване',
	'achievements-badge-name-picture-1' => 'Папарак',
	'achievements-badge-name-picture-2' => 'Илюстратор',
	'achievements-badge-name-picture-3' => 'Колекционер',
	'achievements-badge-name-picture-5' => 'Декоратор',
	'achievements-badge-name-picture-6' => 'Дизайнер',
	'achievements-badge-name-picture-7' => 'Куратор',
	'achievements-badge-name-category-2' => 'Изследовател',
	'achievements-badge-name-category-4' => 'Навигатор',
	'achievements-badge-name-introduction' => 'Въведение',
	'achievements-badge-hover-desc-edit-plus-category' => 'за $1 {{PLURAL:$1|направена редакция|направени редакции}}<br />
в {{PLURAL:$1|$2 страница|$2 страници}}!',
	'achievements-badge-hover-desc-picture' => 'за добавяне на $1 {{PLURAL:$1|изображение|изображения}}<br />
в {{PLURAL:$1|една страница|страници}}!',
	'achievements-badge-hover-desc-category' => 'за добавяне на $1 {{PLURAL:$1|страница|страници}}<br />
в {{PLURAL:$1|категория|категории}}!',
	'achievements-badge-hover-desc-welcome' => 'за присъединяване към уикито!',
	'achievements-badge-hover-desc-creator' => 'за създаване на уикито!',
	'achievements-badge-your-desc-welcome' => 'за присъединяване към уикито!',
	'achievements-badge-your-desc-creator' => 'за създаване на уикито!',
	'achievements-badge-desc-welcome' => 'за присъединяване към уикито!',
	'achievements-badge-desc-creator' => 'за създаване на уикито!',
	'achievements-userprofile-no-badges-owner' => 'Вижте списъка по-долу, за да видите всички значки, които можете да спечелите в това уики!',
);

$messages['bn'] = array(
	'achievements-non-existing-category' => 'উল্লেখিত শ্রেনীটির কোন অস্তিত্ব নেই।',
);

$messages['br'] = array(
	'achievementsii-desc' => 'Ur sistem badjoù evit implijerien ar wiki',
	'achievements-upload-error' => "Digarezit !
Ar skeudenn-mañ ne 'z a ket en-dro.
Bezit sur ez eo ur restr .jpg pe .png
Ma ne 'z a ket en-dro c'hoazh ez eo marteze peogwir eo re bounner ar skeudenn.
Mar plij klaskit gant unan all !",
	'achievements-upload-not-allowed' => 'Gellout a ra ar verourien kemm anvioù ha skeudennoù badjoù an tournamantoù en ur vont war pajenn [[Special:AchievementsCustomize|personelaat an tournamantoù]].',
	'achievements-non-existing-category' => "N'eus ket eus ar rummad meneget.",
	'achievements-edit-plus-category-track-exists' => 'Ar rummad meneget he deus dija un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Mont d\'an tournamant">tournamant kevelet</a>.',
	'achievements-no-stub-category' => 'Mar plij na grouit ket a dournamant evit an divrazoù.',
	'right-platinum' => 'Krouiñ ha kemmañ badjoù Platinum',
	'right-sponsored-achievements' => 'Merañ ar sevenidigezhioù paeroniet',
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Aour',
	'achievements-silver' => "Arc'hant",
	'achievements-bronze' => 'Arem',
	'achievements-gold-points' => '100<br />poent',
	'achievements-silver-points' => '50<br />poent',
	'achievements-bronze-points' => '10<br />poent',
	'achievements-you-must' => 'Rankout a rit $1 evit gounit ar badj-mañ.',
	'leaderboard-button' => 'Taolenn an tournamantoù',
	'achievements-masthead-points' => '$1 <small>poent{{PLURAL:$1||}}</small>',
	'achievements-profile-title-no' => 'Badjoù $1',
	'achievements-no-badges' => "Taolit ur sell d'ar roll amañ a-is evit gwelet ar badjoù a c'hellit gounid war ar wiki-mañ !",
	'achievements-track-name-edit' => 'Tournamantoù embann',
	'achievements-track-name-picture' => 'Tournamant skeudennaouiñ',
	'achievements-track-name-category' => 'Tournamant rummadoù',
	'achievements-track-name-blogpost' => 'Tournamant embannadur war ur blog',
	'achievements-track-name-blogcomment' => 'Tournamant evezhiadennoù diwar-benn ur blog',
	'achievements-track-name-love' => 'Tournamant "Karantez evit ar Wiki"',
	'achievements-track-name-sharing' => 'Heuliañ ar rannañ',
	'achievements-notification-title' => "War an hent mat emaoc'h, $1 !",
	'achievements-notification-subtitle' => 'Emoc\'h o paouez gounit ar badj "$1" $2',
	'achievements-notification-link' => "<strong><big>[[Special:MyPage|Sellit ouzh muioc'h a badjoù a c'hellit gounid]] !</big></strong>",
	'achievements-points' => '$1 poent{{PLURAL:$1||}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|poent|poent}}',
	'achievements-earned' => 'Gounezet eo bet ar badj-mañ gant {{PLURAL:$1|1|$1}} implijer.',
	'achievements-profile-title' => 'An $2 {{PLURAL:$2||badj|badj}} gounezet gant $1',
	'achievements-profile-title-challenges' => "Badjoù all hag a c'hallit gounit !",
	'achievements-profile-customize' => 'Personelaat ar badjoù',
	'achievements-ranked' => 'Renket #$1 war ar wiki-mañ',
	'achievements-viewall' => 'Gwelet pep tra',
	'achievements-viewless' => 'Serriñ',
	'achievements-profile-title-oasis' => 'sevenidigezh <br /> poentoù',
	'achievements-ranked-oasis' => '$1 a zo gant [[Special:Leaderboard|ar renk #$2]] war ar wiki-mañ',
	'achievements-viewall-oasis' => 'Gwelet pep tra',
	'achievements-toggle-hide' => 'Chom hep diskwel ar poentoù, ar badjoù hag ar renkadur war ma frofil',
	'leaderboard-intro-hide' => 'kuzhat',
	'leaderboard-intro-open' => 'digeriñ',
	'leaderboard-intro-headline' => 'Petra eo ar garedonoù ?',
	'leaderboard-intro' => "''Petra eo ar sevenidigezhioù ?''
Gallout a rit gounit badjoù dibar en ur gemer perzh er wiki-mañ !
Kement badj gounezet ganeoc'h a zegas poentoù ouzhpenn d'ho skor hollek :
10 poent e talvez ar badjoù arem, 50 ar badjoù arc'hant ha 100 poent ar badjoù aour.

P'en em enskrivit war ar wiki e tiskouez ho profil implijer an niver a vadjoù gounezet ganeoc'h ha dispakañ a ra ur roll palioù a c'hallit kas da benn.
[[$1|Kit da deuler ur sell war ho profil]] !",
	'leaderboard' => 'Taolenn an tournamantoù',
	'achievements-title' => 'Garedonoù',
	'leaderboard-title' => 'Renkadur',
	'achievements-recent-earned-badges' => 'Badjoù gounezet nevez zo',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />gounezet gant <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'en deus gounezet ar badj <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => "Diskouez a ra taolenn al levierien ar c'hemmoù c'hoarvezet abaoe dec'h.",
	'achievements-leaderboard-rank-label' => 'Renk',
	'achievements-leaderboard-member-label' => 'Ezel',
	'achievements-leaderboard-points-label' => 'Poentoù',
	'achievements-leaderboard-points' => '{{PLURAL:$1|poent|poent}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Resevet da ziwezhañ',
	'achievements-send' => 'Enrollañ ar skeudenn',
	'achievements-save' => "Enrollañ ar c'hemmoù",
	'achievements-reverted' => "Distroet eo ar badj d'an orin",
	'achievements-customize' => 'Personelaat ar skeudenn',
	'achievements-customize-new-category-track' => 'Krouiñ un tournamant nevez evit ar rummad-mañ',
	'achievements-enable-track' => 'gweredekaet',
	'achievements-revert' => "Distreiñ d'ar stumm dre ziouer",
	'achievements-special-saved' => 'Kemmoù enrollet.',
	'achievements-special' => 'Tournamantoù ispisial',
	'achievements-secret' => 'Tournamantoù sekred',
	'achievementscustomize' => 'Personelaat ar badjoù',
	'achievements-about-title' => 'Diwar-benn ar bajenn-mañ...',
	'achievements-edit-plus-category-track-name' => '$1 tournamant embann',
	'achievements-create-edit-plus-category-title' => 'Krouiñ un tournamant embann nevez',
	'achievements-create-edit-plus-category' => 'Krouiñ an tournamant-se',
	'platinum' => 'Platin',
	'achievements-community-platinum-awarded-email-subject' => "Gounezet hoc'h eus ur badj platin nevez !",
	'achievements-community-platinum-awarded-email-body-text' => 'Gourc\'hemennoù $1 !

Emaoc\'h o paouez gounid ar badj platin "$2" e $4 ($3).
An dra-mañ a ouzhpenn 250 poent d\'ho skor !

Taolit ur sell d\'ho badj dispar nevez war ho pajenn implijer :

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Gourc\'hemennoù $1 ! </strong><br /><br />

Emaoc\'h o paouez gounid ar badj platin "<strong>$2</strong>" e <a href="$3">$4</a>.
An dra-mañ a ouzhpenn 250 poent d\'ho skor !<br /><br />

Taolit ur sell d\'ho badj dispar nevez war ho <a href="$5">pajenn implijer</a>.',
	'achievements-community-platinum-awarded-for' => 'Roet evit :',
	'achievements-community-platinum-how-to-earn' => 'Penaos gounid :',
	'achievements-community-platinum-awarded-for-example' => 'da sk. : "evit ober..."',
	'achievements-community-platinum-how-to-earn-example' => 'da sk. : "degas 3 c\'hemm..."',
	'achievements-community-platinum-badge-image' => 'Skeudenn ar badj :',
	'achievements-community-platinum-awarded-to' => 'Roet da :',
	'achievements-community-platinum-current-badges' => 'Badjoù platin a-vremañ',
	'achievements-community-platinum-create-badge' => 'Krouiñ ur badj',
	'achievements-community-platinum-enabled' => 'gweredekaet',
	'achievements-community-platinum-show-recents' => 'diskouez e-mesk ar badjoù nevez',
	'achievements-community-platinum-edit' => 'kemmañ',
	'achievements-community-platinum-save' => 'enrollañ',
	'achievements-community-platinum-cancel' => 'nullañ',
	'achievements-community-platinum-sponsored-label' => 'Garedon sponsoret',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => "Chomlec'h URL evezhiañ evit ar moullañ badjoù :",
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Liamm ar badj <small>(URL an urzhias klik DART) </small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => "Klikit evit gouzout hiroc'h",
	'achievements-badge-name-edit-0' => "A ra an diforc'h",
	'achievements-badge-name-edit-1' => "N'eo nemet ar pennkentañ",
	'achievements-badge-name-edit-3' => "Mignon d'ar wiki",
	'achievements-badge-name-edit-4' => 'Kenlabourer',
	'achievements-badge-name-edit-5' => 'Saver Wiki',
	'achievements-badge-name-edit-6' => 'Levier ar Wiki',
	'achievements-badge-name-edit-7' => 'Arbennigour Wiki',
	'achievements-badge-name-picture-0' => 'Tapadenn brim',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Skeudennaouer',
	'achievements-badge-name-picture-3' => 'Dastumader',
	'achievements-badge-name-picture-4' => 'Hag a gar an arz',
	'achievements-badge-name-picture-5' => 'Kinklour',
	'achievements-badge-name-picture-6' => 'Neuzier',
	'achievements-badge-name-picture-7' => 'Mirour',
	'achievements-badge-name-category-0' => 'Kevreañ',
	'achievements-badge-name-category-1' => 'Savet gwenodennoù',
	'achievements-badge-name-category-2' => 'Ergerzher',
	'achievements-badge-name-category-3' => 'Heñcher touristel',
	'achievements-badge-name-category-4' => 'Moraer',
	'achievements-badge-name-category-5' => 'Saver pontoù',
	'achievements-badge-name-category-6' => 'Steuñver Wiki',
	'achievements-badge-name-blogpost-0' => 'Un dra bennak da lavaret',
	'achievements-badge-name-blogpost-1' => 'Pemp tra da lavaret',
	'achievements-badge-name-blogpost-2' => 'Kaozeadeg',
	'achievements-badge-name-blogpost-3' => 'Buhez ar strollad',
	'achievements-badge-name-blogpost-4' => 'Prezeger',
	'achievements-badge-name-blogcomment-0' => 'Displeger',
	'achievements-badge-name-blogcomment-1' => "Hag un dra all c'hoazh",
	'achievements-badge-name-love-0' => 'Diwanad yaouank ar wiki !',
	'achievements-badge-name-love-1' => 'Div sizhun war ar wiki',
	'achievements-badge-name-love-2' => 'Gredus',
	'achievements-badge-name-love-3' => 'Dediet',
	'achievements-badge-name-love-4' => 'Sod-nay',
	'achievements-badge-name-love-5' => 'Ur Wiki-buhez',
	'achievements-badge-name-love-6' => 'Haroz ar Wiki !',
	'achievements-badge-name-sharing-0' => 'Ranner',
	'achievements-badge-name-sharing-1' => "Deus amañ 'ta",
	'achievements-badge-name-sharing-2' => 'Prezeger',
	'achievements-badge-name-sharing-3' => 'Kemenner',
	'achievements-badge-name-sharing-4' => 'Avielour',
	'achievements-badge-name-welcome' => "Deuet mat oc'h war ar Wiki",
	'achievements-badge-name-introduction' => 'Digoradur',
	'achievements-badge-name-sayhi' => 'Demat en ur dremen',
	'achievements-badge-name-creator' => "Ar C'hrouer",
	'achievements-badge-name-pounce' => "Loc'het eo",
	'achievements-badge-name-caffeinated' => 'Gant kafein',
	'achievements-badge-name-luckyedit' => 'Kemm gant chañs',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|rannañ ul liamm|lakaat {{PLURAL:$1|un|$1}} den da glikañ war al liamm ho peus rannet}}',
	'achievements-badge-to-get-edit' => 'ober $1 kemm war {{PLURAL:$1|ur bajenn|pajennoù}}',
	'achievements-badge-to-get-edit-plus-category' => "ober {{PLURAL:$1|ur c'hemm|$1 kemm}} war {{PLURAL:$1|ur bajenn|pajennoù}} $2",
	'achievements-badge-to-get-picture' => "ouzhpennañ $1 skeudenn{{PLURAL:$1||}} {{PLURAL:$1|d'ur bajenn|da pajennoù}}",
	'achievements-badge-to-get-category' => "ouzhpennañ $1 pajenn{{PLURAL:$1||}} {{PLURAL:$1|d'ur rummad|da rummadoù}}",
	'achievements-badge-to-get-blogpost' => 'skrivañ $1 {{PLURAL:$1|blogadenn|blogadenn}}',
	'achievements-badge-to-get-blogcomment' => 'ober un evezhiadenn diwar-benn {{PLURAL:$1|ur blogadenn|$1 blogadenn}}',
	'achievements-badge-to-get-love' => 'kemer perzh er wiki bemdez e-pad $1 devezh{{PLURAL:}}',
	'achievements-badge-to-get-welcome' => 'dont war ar wiki',
	'achievements-badge-to-get-introduction' => "ouzhpennañ d'ho pajenn implijer",
	'achievements-badge-to-get-sayhi' => "leuskel ur gemennadenn d'unan bennak war e bajenn implijer",
	'achievements-badge-to-get-creator' => 'bezañ krouer ar wiki',
	'achievements-badge-to-get-pounce' => 'bezañ prim',
	'achievements-badge-to-get-caffeinated' => "ober {{PLURAL:$1|ur c'hemm|$1 kemm}} er pajennoù en un devezh",
	'achievements-badge-to-get-luckyedit' => 'kaout chañs',
	'achievements-badge-to-get-sharing-details' => "Rannit liammoù ha grit d'ar re all klikañ warno !",
	'achievements-badge-to-get-edit-details' => 'Un dra bennak a vank ?
ur fazi \'zo ?
Na vezit ket lent.
Klikit war ar bouton "{{int:edit}}" ha klokait forzh peseurt pajenn !',
	'achievements-badge-to-get-edit-plus-category-details' => 'Ar bajenn <strong>$1</strong> he deus ezhomm ho sikour !
Klikit war ar bouton "{{int:edit}}" eus forzh peseurt pajenn er rummad evit reiñ un taol sikour.
Diskouezit ho skoazell d\'ar pajennoù $1 !',
	'achievements-badge-to-get-picture-details' => 'Klikit war ar bouton "{{int:edit}}" ha goude war "{{int:rte-ck-image-add}}".
Gellout a rit ouzhpennañ ur skeudenn adalek ho urzhiataer pe adalek ur bajenn all eus ar wiki.',
	'achievements-badge-to-get-category-details' => 'Ar rummadoù a zo tikedennoù hag a sikour al lennerien da gavout pajennoù kar.
Klikit war bouton "{{int:categoryselect-addcategory-button}}" ur bajenn evit rollañ ar bajenn-mañ en ur rummad.',
	'achievements-badge-to-get-blogpost-details' => 'Skrivit ho alioù hag ho koulennoù !
Klikit war "{{int:blogs-recent-url-text}}" ar barenn kostez ha goude war al liamm a gleiz evit "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => "Kemerit perzh !
Lennit ur blogadenn eus ar re nevez ha roit oc'h ali e maezienn an evezhiadennoù.",
	'achievements-badge-to-get-love-details' => "Adderaouekaat e vez ar c'honter ma c'hwitit un devezh. Bezit sur distreiñ bemdez war ar wiki !",
	'achievements-badge-to-get-welcome-details' => 'Klikit war ar bouton "{{int:oasis-signup}}" en nec\'h a zehou evit dont er gumuniezh.
Gellout a rit kregiñ da c\'hounid ho badjoù !',
	'achievements-badge-to-get-introduction-details' => 'Goullo eo ho pajenn implijer ?
Klikit war ho anv implijer e penn uhelañ ar skramm evit gwelet.
Klikit war "{{int:edit}}" evit ouzhpennañ titouroù diwar ho penn !',
	'achievements-badge-to-get-sayhi-details' => 'Gellout a rit leuskel kemennadennoù d\'an implijerien all en ur klikañ war "{{int:tooltip-ca-addsection}}", war o fajenn implijer.
Goulennit sikour, trugarekait anezho evit o labour, pe saludit anezho hepken !',
	'achievements-badge-to-get-creator-details' => "Roet e vez ar badj-mañ d'an den hag a grou ar wiki.
Klikit war ar bouton \"{{int:createwiki}}\" e penn uhelañ ar skramm evit krouiñ ul lec'hienn war ar pezh a blij deoc'h ar muiañ !",
	'achievements-badge-to-get-pounce-details' => 'Rankout a rit bezañ prim evit gounid ar badj-mañ.
Klikit war ar bouton "{{int:activityfeed}}" evit gwelet ar pajennoù nevez hag a vez krouet gant an implijerien !',
	'achievements-badge-to-get-caffeinated-details' => "Un devezh pad a zo ezhomm evit gounid ar badj-mañ.
Kendalc'hit da gemmañ !",
	'achievements-badge-to-get-luckyedit-details' => "Chañs a rankit kaout evit gounid ar badj-mañ.
Kendalc'hit da gemmañ !",
	'achievements-badge-to-get-community-platinum-details' => 'Ur badj dibar e platin eo hemañ, ha ne vez outañ nemet e-pad ur prantad termenet !',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|evit bezañ rannet ul liamm|evit bezañ lakaet {{PLURAL:$1|un den|$1 den}} da glikañ war liammoù rannet}}',
	'achievements-badge-hover-desc-edit' => "evit bezañ degaset $1 {{PLURAL:$1|c'hemm|kemm}}<br />
war {{PLURAL:$1|ur bajenn|pajennoù}} !",
	'achievements-badge-hover-desc-edit-plus-category' => "evit bezañ degaset $1 {{PLURAL:$1|c'hemm|kemm}}<br />
war {{PLURAL:$1|un $2 pajenn|$2 pajenn}} !",
	'achievements-badge-hover-desc-picture' => 'evit bezañ ouzhpennet $1 {{PLURAL:$1|skeudenn|skeudenn}}<br />
war {{PLURAL:$1ur bajenn|pajennoù}} !',
	'achievements-badge-hover-desc-category' => "evit bezañ ouzhpennet $1 {{PLURAL:$1|bajenn|pajenn}}<br />
{{PLURAL:$1|d'ur rummad|da rummadoù}} !",
	'achievements-badge-hover-desc-blogpost' => 'evit bezañ skrivet $1 {{PLURAL:$1|blogadenn|blogadenn}}',
	'achievements-badge-hover-desc-blogcomment' => 'evit bezañ graet un evezhiadenn</br>
war {{PLURAL:$1|ur|$1}} blogadenn !',
	'achievements-badge-hover-desc-love' => 'evit bezañ graet degasadennoù bemdez war ar wiki e-pad {{PLURAL:$1|un devezh|$1 devezh}} !',
	'achievements-badge-hover-desc-welcome' => 'evit bezañ deuet war ar wiki !',
	'achievements-badge-hover-desc-introduction' => 'evit bezañ ouzhpennet titouroù war<br />
ho pajenn implijer !',
	'achievements-badge-hover-desc-sayhi' => 'evit bezañ laosket ur gemennadenn<br />
war pajenn kaozeal unan bennak all !',
	'achievements-badge-hover-desc-creator' => 'evit bezañ krouet ar wiki !',
	'achievements-badge-hover-desc-pounce' => 'evit bezañ degaset kemmoù war 100 pajenn en eurvezh goude krouidigezh ar bajenn !',
	'achievements-badge-hover-desc-caffeinated' => 'evit bezañ degaset 100 kemm e pajennoù en un devezh !',
	'achievements-badge-hover-desc-luckyedit' => 'evit bezañ degaset ar $1vet kemm gant chañs war ar wiki !',
	'achievements-badge-hover-desc-community-platinum' => 'Ur badj dibar e platin eo hemañ, ha ne vez outañ nemet e-pad ur prantad termenet !',
	'achievements-badge-your-desc-sharing' => '{{#ifeq:$1|0|evit bezañ rannet ul liamm|evit bezañ lakaet {{PLURAL:$1|un den|$1 den}} da glikañ war liammoù rannet}}',
	'achievements-badge-your-desc-edit' => 'Evit bezañ degaset ho {{PLURAL:$1|kemm gentañ|$1 kemm}} war {{PLURAL:$1|ur bajenn|pajennoù}} !',
	'achievements-badge-your-desc-edit-plus-category' => 'evit bezañ degaset {{PLURAL:$1|ho kemm gentañ|$1 kemm}} war {{PLURAL:$1|ur bajenn|$2 pajenn}}!',
	'achievements-badge-your-desc-picture' => 'Evit bezañ degaset ho {{PLURAL:$1|skeudenn gentañ|$1 skeudenn}} war {{PLURAL:$1|ur bajenn|pajennoù}} !',
	'achievements-badge-your-desc-category' => "evit bezañ ouzhpennet {{PLURAL:$1|ho pajenn gentañ|$1 pajenn}} {{PLURAL:$1|d'ur rummad|da rummadoù}} !",
	'achievements-badge-your-desc-blogpost' => 'evit bezañ skrivet {{PLURAL:$1|ho plogadenn gentañ|$1 blogadenn}} !',
	'achievements-badge-your-desc-blogcomment' => 'evit bezañ graet evezhiadennoù diwar-benn {{PLURAL:$1|ur|$1}} bloagadenn !',
	'achievements-badge-your-desc-love' => 'evit bezañ graet degasadennoù bemdez war ar wiki e-pad {{PLURAL:$1|un devezh|$1 devezh}} !',
	'achievements-badge-your-desc-welcome' => 'evit bezañ deuet war ar wiki !',
	'achievements-badge-your-desc-introduction' => 'evit bezañ ouzhpennet titouroù war ho pajenn implijer !',
	'achievements-badge-your-desc-sayhi' => 'evit bezañ laosket ur gemennadenn war pajenn kaozeal unan bennak all !',
	'achievements-badge-your-desc-creator' => 'evit bezañ krouet ar wiki !',
	'achievements-badge-your-desc-pounce' => 'evit bezañ degaset kemmoù war 100 pajenn en eurvezh goude krouidigezh ar bajenn !',
	'achievements-badge-your-desc-caffeinated' => 'evit bezañ degaset 100 kemm e pajennoù en un devezh !',
	'achievements-badge-your-desc-luckyedit' => 'evit bezañ degaset ar $1vet kemm gant chañs war ar wiki !',
	'achievements-badge-desc-sharing' => '{{#ifeq:$1|0|evit bezañ rannet ul liamm|evit bezañ lakaet {{PLURAL:$1|un den|$1 den}} da glikañ war liammoù rannet}}',
	'achievements-badge-desc-edit' => "evit bezañ degaset $1 {{PLURAL:$1|c'hemm|kemm}} war {{PLURAL:$1|ur bajenn|pajennoù}} !",
	'achievements-badge-desc-edit-plus-category' => 'evit bezañ degaset $1 kemm war {{PLURAL:$1|ur bajenn|$2 pajenn}}!',
	'achievements-badge-desc-picture' => 'evit bezañ ouzhpennet $1 {{PLURAL:$1|skeudenn|skeudenn}} war {{PLURAL:$1ur bajenn|pajennoù}} !',
	'achievements-badge-desc-category' => "evit bezañ ouzhpennet $1 {{PLURAL:$1|bajenn|pajenn}} {{PLURAL:$1|d'ur rummad|da rummadoù}} !",
	'achievements-badge-desc-blogpost' => 'evit bezañ skrivet $1 {{PLURAL:$1|blogadenn|blogadenn}}',
	'achievements-badge-desc-blogcomment' => 'evit bezañ graet evezhiadennoù diwar-benn {{PLURAL:$1|ur|$1}} bloagadenn !',
	'achievements-badge-desc-love' => 'evit bezañ kemeret perzh er wiki bemdez e-pad {{PLURAL:$1|un devezh|$1 devezh}} !',
	'achievements-badge-desc-welcome' => 'evit bezañ deuet war ar wiki !',
	'achievements-badge-desc-introduction' => "evit bezañ ouzhpennet d'ho pajenn implijer !",
	'achievements-badge-desc-sayhi' => 'evit bezañ laosket ur gemennadenn war pajenn kaozeal unan bennak all !',
	'achievements-badge-desc-creator' => 'evit bezañ krouet ar wiki !',
	'achievements-badge-desc-pounce' => 'evit bezañ degaset kemmoù war 100 pajenn en eurvezh goude krouidigezh ar bajenn !',
	'achievements-badge-desc-caffeinated' => 'evit bezañ degaset 100 kemm e pajennoù en un devezh !',
	'achievements-badge-desc-luckyedit' => 'evit bezañ degaset ar $1vet kemm gant chañs war ar wiki !',
	'achievements-userprofile-title-no' => 'Badjoù gounezet gant $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Badj|Badjoù}} gounezet gant $1 ($2)',
	'achievements-userprofile-no-badges-owner' => "Taolit ur sell war ar roll amañ dindan evit gwelet peseurt badjoù a c'hallit gounit er wiki-mañ !",
	'achievements-userprofile-no-badges-visitor' => "An implijer-mañ n'en deus gounezet badj ebet evit ar mare",
	'achievements-userprofile-profile-score' => '<em>$1</em> poentoù<br /> garedon',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|gant ar renk #$1]] war ar wiki-mañ',
);

$messages['bs'] = array(
	'right-platinum' => 'Napravi i uredi Platinaste bedževe',
	'achievements-platinum' => 'platina',
	'achievements-gold' => 'Zlato',
	'achievements-silver' => 'Srebro',
	'achievements-bronze' => 'Bronza',
	'achievements-gold-points' => ' 100<br />pts',
	'achievements-you-must' => 'Potrebno je da $1 da biste dobili ovu značku.',
	'leaderboard-button' => 'Tabela dostignuća',
	'achievements-profile-title-no' => 'Značke korisnika $1',
	'achievements-no-badges' => 'Provjeri donju listu da vidiš koje značke možeš zaraditi na ovoj wiki!',
	'achievements-track-name-edit' => 'Zapis o uređivanjima',
	'achievements-track-name-picture' => 'Zapis o slikama',
	'achievements-track-name-category' => 'Zapis o kategorijama',
	'achievements-track-name-blogpost' => 'Zapis o postavljenim blogovima',
	'achievements-track-name-blogcomment' => 'Zapis o komentarima na blogu',
	'achievements-track-name-love' => 'Zapis o Wiki Love',
	'achievements-notification-subtitle' => '$2 upravo ste zaradili "$1" značku',
	'achievements-profile-title-challenges' => 'Više znački koje možete zaraditi!',
	'achievements-profile-customize' => 'Prilagodi značke',
	'achievements-ranked' => 'Rangiran #$1 na ovoj wiki',
	'achievements-viewall' => 'Pogledaj sve',
	'achievements-viewless' => 'Zatvori',
	'achievements-viewall-oasis' => 'Vidi sve',
	'leaderboard-intro-hide' => 'sakrij',
	'leaderboard-intro-open' => 'otvori',
	'leaderboard-intro-headline' => 'Koja su dostignuća?',
	'leaderboard' => 'Tabela vodećih dostignuća',
	'achievements-recent-earned-badges' => 'Nedavno Osvojene Značke',
	'achievements-leaderboard-member-label' => 'Član',
	'achievements-send' => 'Spasi sliku',
	'achievements-save' => 'Sačuvaj promjene',
	'achievements-reverted' => 'Značka vraćena u original.',
	'achievements-customize' => 'Prilagodi sliku',
	'achievements-customize-new-category-track' => 'Napravi novi zapis za kategoriju:',
	'achievements-enable-track' => 'Omogućeno',
	'achievements-revert' => 'Vrati na zadanu vrijednost',
	'achievements-special-saved' => 'Promjene sačuvane.',
	'achievements-special' => 'Posebna dostignuća',
	'achievements-secret' => 'Tajna dostignuća',
	'achievementscustomize' => 'Prilagodi značke korisniku',
	'achievements-about-title' => 'O ovoj stranici',
	'platinum' => 'Platinasta',
	'achievements-community-platinum-awarded-for' => 'Nagrađen/a za:',
	'achievements-community-platinum-how-to-earn' => 'Kako zaraditi:',
	'achievements-community-platinum-awarded-for-example' => 'što znači "za pravljenje..."',
	'achievements-community-platinum-how-to-earn-example' => 'što znači "uradite 3 uređivanja..."',
	'achievements-community-platinum-badge-image' => 'Izgled značke:',
	'achievements-community-platinum-current-badges' => 'Aktuelne platinaste značke',
	'achievements-community-platinum-create-badge' => 'Napravi značku',
	'achievements-community-platinum-enabled' => 'omogućeno',
	'achievements-community-platinum-edit' => 'uređivanje',
	'achievements-community-platinum-save' => 'Sačuvaj',
	'achievements-badge-name-edit-0' => 'Pravljenje razlika',
	'achievements-badge-name-edit-1' => 'Tek početak',
	'achievements-badge-name-edit-3' => 'Wiki prijatelj',
	'achievements-badge-name-edit-4' => 'Saradnik',
	'achievements-badge-name-edit-5' => 'Wiki graditelj',
	'achievements-badge-name-edit-6' => 'Wiki predvodnik',
	'achievements-badge-name-edit-7' => 'Wiki stručnjak',
	'achievements-badge-name-picture-0' => 'Trenutni snimak',
	'achievements-badge-name-picture-1' => 'Paparaci',
	'achievements-badge-name-picture-2' => 'Ilustrator',
	'achievements-badge-name-picture-3' => 'Sakupljač',
	'achievements-badge-name-picture-4' => 'Ljubitelj umjetnosti',
	'achievements-badge-name-picture-5' => 'Dekorater',
	'achievements-badge-name-picture-6' => 'Dizajner',
	'achievements-badge-name-picture-7' => 'Kustos',
	'achievements-badge-name-category-0' => 'Napravi Poveznicu',
	'achievements-badge-name-category-2' => 'Istraživač',
	'achievements-badge-name-category-3' => 'Priručnik za obilazak',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Graditelj mostova',
	'achievements-badge-name-category-6' => 'Wiki planer',
	'achievements-badge-name-blogpost-0' => 'Nešto za reći',
	'achievements-badge-name-blogpost-1' => 'Pet stvari za reći',
	'achievements-badge-name-blogpost-2' => 'Diskusija',
	'achievements-badge-name-love-2' => 'Požrtvovan',
	'achievements-badge-name-love-3' => 'Zaokupljen',
	'achievements-badge-name-love-4' => 'Ovisnik',
	'achievements-badge-name-sharing-2' => 'Govornik',
	'achievements-badge-name-sharing-3' => 'Najavljivač',
	'achievements-badge-name-introduction' => 'Uvod',
	'achievements-badge-to-get-pounce' => 'budi hitar',
	'achievements-badge-hover-desc-welcome' => 'za pridruživanje na wiki!',
	'achievements-badge-your-desc-creator' => 'za pravljenje wiki!',
	'achievements-badge-desc-welcome' => 'za pridruživanje na wiki!',
	'achievements-badge-desc-introduction' => 'za pravljenje vlastite korisničke stranice!',
	'achievements-badge-desc-sayhi' => 'za ostavljanje poruke na nečijoj stranici za razgovor!',
	'achievements-badge-desc-creator' => 'za pravljenje wiki!',
);

$messages['ca'] = array(
	'right-platinum' => 'Crear i editar medalles de Platí',
	'achievements-platinum' => 'Platí',
	'achievements-gold' => 'Or',
	'achievements-silver' => 'Plata',
	'achievements-bronze' => 'Bronze',
	'achievements-gold-points' => '100<br />pts',
	'achievements-silver-points' => '50<br />pts',
	'achievements-bronze-points' => '10<br />pts',
	'achievements-you-must' => 'Necessites $1 per guanyar aquesta medalla.',
	'leaderboard-button' => 'Rànquing de Medalles',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punt|punts}}</small>',
	'achievements-profile-title-no' => 'Medalles de $1',
	'achievements-no-badges' => 'Fes una ullada a la següent llista per veure les medalles que pots guanyar en aquest wiki!',
	'achievements-track-name-edit' => "Seguiment d'Edicions",
	'achievements-track-name-picture' => "Seguiment d'Imatges",
	'achievements-track-name-category' => 'Seguiment de Categories',
	'achievements-track-name-blogpost' => 'Seguiment de Blog Post',
	'achievements-track-name-blogcomment' => 'Seguiment de Comentaris en Blogs',
	'achievements-track-name-love' => "Seguiment de l'Amor al Wiki",
	'achievements-track-name-sharing' => 'Seguiment de Compartir',
	'achievements-notification-title' => 'Camí per recórrer, $1!',
	'achievements-notification-subtitle' => 'Acabes de guanyar la medalla "$1" $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Veure més medalles que pots guanyar]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punt|punts}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punt|punts}}',
	'achievements-earned' => 'Aquesta medalla ha estat guanyada per {{PLURAL:$1|1 usuari|$1 usuaris}}.',
	'achievements-profile-title' => '$1 ha guanyat $2 {{PLURAL:$2|medalla|medalles}}',
	'achievements-profile-title-challenges' => 'Més medalles que pots guanyar!',
	'achievements-profile-customize' => 'Personalitzar medalles',
	'achievements-ranked' => 'Número $1 en aquest wiki',
	'achievements-viewall' => 'Veure-ho tot',
	'achievements-viewless' => 'Tancar',
	'achievements-profile-title-oasis' => 'punts <br /> de medalles',
	'achievements-ranked-oasis' => '$1 és el [[Special:Leaderboard|Número #$2]] en aquest wiki',
	'achievements-viewall-oasis' => 'Veure-ho tot',
	'achievements-toggle-hide' => 'Amaga les medalles del meu perfil per a tothom',
	'leaderboard-intro-hide' => 'amaga',
	'leaderboard-intro-open' => 'obre',
	'achievements-leaderboard-rank-label' => 'Lloc',
	'achievements-leaderboard-member-label' => 'Membre',
	'achievements-leaderboard-points-label' => 'Punts',
	'achievements-leaderboard-points' => '{{PLURAL:$1|punt|punts}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Guanyat més recentment',
	'achievements-about-content' => 'Els administradors d\'aquest wiki poden personalitzar els noms i fotos de les medalles.

Pots pujar qualsevol imatge .jpg. o .png i la imatge automàticament s\'ajustarà dins del marc.
Funciona millor si la imatge és quadrada i la part més important d\'aquesta es troba al mig.

Podeu utilitzar imatges rectangulars, però et pots trobar que una tros es quedi fora del marc.
Si tens un programa de gràfics, pots retallar la imatge per posar la part important d\'aquesta al centre.
Si no tens un programa de gràfics, pots provar amb diferents imatges fins trobar les que vagin bé!
Si no us agrada la imatge que heu triat, fes clic a "{{int:achievements-revert}}" per tornar a la imatge original.

També pots donar nous noms a les medalles que reflecteixen el tema de la wiki.
Quan hagis canviat el nom de la medalla, fes clic a "{{int:achievements-save}}" per guardar els canvis.
Que et diverteixis!',
	'platinum' => 'Platí',
	'achievements-community-platinum-awarded-email-body-text' => "Felicitats$1 !

Acabes de ser guardonat amb la medalla Platí '$2' de $4 ( $3 ).
Això afegeix 250 punts a la teva puntuació!

Fes un cop d'ull a la teva nova insígnia de luxe a la teva pàgina de perfil d'usuari:

$5",
	'achievements-userprofile-title-no' => 'Medalles Guanyades per $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Medalla|Medalles}} {{PLURAL:$2|Guanyada|Guanyades}} per $1 ($2)',
	'achievements-userprofile-no-badges-visitor' => 'Aquest usuari encara no ha guanyat cap medalla.',
	'achievements-userprofile-profile-score' => '<em>$1</em> Punts<br />aconseguits',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Número #$1]]<br />en aquest wiki',
);

$messages['ce'] = array(
	'achievements-leaderboard-member-label' => 'Декъашхо',
);

$messages['cs'] = array(
	'achievementsii-desc' => 'Systém odznaků úspěchů pro uživatele wiki',
	'achievements-upload-error' => 'Omlouváme se!
Tento obrázek nefunguje.
Ujistěte se, že se jedná o soubor .jpg nebo .png.
Pokud stále nefunguje, pak obrázek může být příliš velký.
Prosím zkuste jiný!',
	'achievements-upload-not-allowed' => 'Administrátoři mohou změnit názvy a obrázky odznaků úspěchů navštívením stránky [[Special:AchievementsCustomize|úpravy úspěchů]].',
	'achievements-non-existing-category' => 'Zadaná kategorie neexistuje.',
	'achievements-edit-plus-category-track-exists' => 'Zadaná kategorie má již <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Jdi na stopu">přiřazenou stopu</a>.',
	'achievements-no-stub-category' => ' Nevytvářejte prosím stopy pro pahýly.',
	'right-platinum' => ' Vytvořit a upravit platinové odznaky',
	'right-sponsored-achievements' => 'Spravovat sponzorované úspěchy',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Zlato',
	'achievements-silver' => 'Stříbro',
	'achievements-bronze' => 'Bronz',
	'achievements-gold-points' => '100<br />bodů',
	'achievements-silver-points' => '50<br />bodů',
	'achievements-bronze-points' => '10<br />bodů',
	'achievements-you-must' => 'K získání tohoto odznaku je potřeba $1',
	'leaderboard-button' => 'Žebříček úspěchů',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|bod|bodů}}</small>',
	'achievements-profile-title-no' => 'Odznaky uživatele $1',
	'achievements-no-badges' => 'Prohlédněte si seznam odznaků, které můžete získat na této wiki.',
	'achievements-track-name-edit' => 'Stopa úprav',
	'achievements-track-name-picture' => 'Stopa obrázků',
	'achievements-track-name-category' => 'Stopa kategorie',
	'achievements-track-name-blogpost' => 'Stopa příspěvků na blogu',
	'achievements-track-name-blogcomment' => 'Stopa komentářů na blogu',
	'achievements-track-name-love' => 'Stopa Wiki Love',
	'achievements-track-name-sharing' => 'Stopa sdílení',
	'achievements-notification-title' => 'Jen tak dál, $1!',
	'achievements-notification-subtitle' => 'Právě jsi získal "$1" odznak za $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Zjisti, jaké další odznaky můžeš získat]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|bod|body|bodů}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|bod|body|bodů}}',
	'achievements-earned' => 'Tento odznak vlastní již {{PLURAL:$1|1 uživatel|$1 uživatelé|$1 uživatelů}}',
	'achievements-profile-title' => 'Uživatel $1 získal $2 {{PLURAL:$2|odznak|odznaky|odznaků}}',
	'achievements-profile-title-challenges' => 'Další odznaky, které můžeš získat.',
	'achievements-profile-customize' => 'Upravit odznaky',
	'achievements-ranked' => 'Na místě #$1 na této wiki',
	'achievements-viewall' => 'Zobrazit vše',
	'achievements-viewless' => 'Zavřít',
	'achievements-profile-title-oasis' => 'úspěch  <br /> body',
	'achievements-ranked-oasis' => '$1 je v žebříčku na [[Special:Leaderboard|místě číslo #$2]] na této wiki',
	'achievements-viewall-oasis' => 'Zobrazit vše',
	'achievements-toggle-hide' => 'Skrýt body, odznaky a pořadí na mém profilu.',
	'leaderboard-intro-hide' => 'skrýt',
	'leaderboard-intro-open' => 'otevřít',
	'leaderboard-intro-headline' => 'Co jsou úspěchy?',
	'leaderboard-intro' => "Odznaky na této wiki můžete získat za editování stránek, nahrávání obrázků a komentováním příspěvků. Za každý odznak získáváte body - čím více bodů máte, tím výše jste v pořadí. Získané odznaky můžete najít na [[$1|uživatelské stránce]].

'''Jaký mají odznaky smysl?'''",
	'leaderboard' => 'Žebříček úspěchů',
	'achievements-title' => 'Úspěchy',
	'leaderboard-title' => 'Žebříček',
	'achievements-recent-earned-badges' => 'Nedávno získané odznaky',
	'achievements-recent-info' => '<a href="$1">$2</a><br /> získal/a odznak <strong>$3</strong><br />$4<br />$5',
	'achievements-activityfeed-info' => 'získal/a odznak <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Žebříček ukazuje změny platné od včerejška',
	'achievements-leaderboard-rank-label' => 'Pořadí',
	'achievements-leaderboard-member-label' => 'Člen',
	'achievements-leaderboard-points-label' => 'Body',
	'achievements-leaderboard-points' => '{{PLURAL:$1|bod|body|bodů}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Nedávno získané',
	'achievements-send' => 'Uložit obrázek',
	'achievements-save' => 'Uložit změny',
	'achievements-reverted' => 'Odznak vrácen do původní verze.',
	'achievements-customize' => 'Upravit obrázek',
	'achievements-customize-new-category-track' => 'Vytvořte novou stopu pro kategorii:',
	'achievements-enable-track' => 'aktivováno',
	'achievements-revert' => 'Zpět na výchozí',
	'achievements-special-saved' => 'Změny uloženy',
	'achievements-special' => 'Speciální úspěchy',
	'achievements-secret' => 'Tajné úspěchy',
	'achievementscustomize' => 'Upravit odznaky >',
	'achievements-about-title' => 'O této stránce...',
	'achievements-about-content' => 'Správci na této wiki mohou upravovat název a podobu každého odznaku.

Můžete nahrát jakýkoliv obrázek ve formátu .jpg nebo .png a váš obrázek bude automaticky zasazen do rámečku.
Ideální je, pokud je obrázek čtvercový a jeho nejvýznamnější část je přesně uprostřed.

Můžete použít rovněž obdélníkové obrázky, ale může se stát, že budou rámečkem oříznuté.
Máte-li program pro úpravu obrázků, můžete si svůj obrázek upravit, aby jeho nejdůležitější část byla uprostřed.
Pokud takový program nemáte, tak zkuste experimentovat s různými obrázky, dokud nenajdete takový, se kterým budete spokojeni!
Pokud se vám zvolený obrázek nelíbí, klikněte na tlačítko "{{int:achievements-revert}}", kterým se vrátíte na původní grafiku.

Rovněž můžete odznaky nově pojmenovávat a odrážet tak téma wiki.
Jakmile jste upravili název odznaku, pro uložení změn klikněte na "{{int:achievements-save}}".
Příjemnou zábavu!',
	'achievements-edit-plus-category-track-name' => '$1 upravit dráhu',
	'achievements-create-edit-plus-category-title' => 'Vytvořit novou stopu pro úpravy',
	'achievements-create-edit-plus-category-content' => 'Můžete vytvořit novou sadu odznaků, které odměňují uživatele za úpravy stránek v jednotlivých kategoriích, abyste vyzdvihli oblast stránky, na které by uživatele bavilo pracovat.
Můžete nastavit více než jednu stopu kategorie, proto zkuste výběr dvou kategorií, které by pomohly uživatelům ukázat své přednosti.
Zažehněte soutěživost mezi uživateli, kteří upravují stránky o upírech a mezi uživateli, kteří upravují stránky o vlkodlacích, čarodějích a mudlech nebo autobotech a deceptikonech.

Pro vytvoření nové stopy "Úpravy v kategorii", napište název kategorie do pole níže.
Základní stopa Úpravy bude stále existovat;
tímto vytvoříte oddělenou stopu, kterou můžete nezávisle přizpůsobovat.

Když je stopa vytvořena, v seznamu vlevo pod základní stopou Úpravy se objeví nové odznaky.
Přizpůsobte si názvy a obrázky pro novou stopu, aby uživatelé poznali rozdíl!

Jakmile budete s přizpůsobováním hotovi, klepněte na zaškrtávací políčko "{{int:achievements-enable-track}}", abyste novou stopu spustili. Poté klepněte na tlačítko "{{int:achievements-save}}".
Uživatelé uvidí novou stopu v jejich uživatelských profilech a začnou získávat odznaky, když budou upravovat stránky v dané kategorii.
Stopu můžete kdykoliv vypnout, když se rozhodnete, že již nechcete danou kategorii více zviditelňovat.
Uživatelé, kteří získali nějaké odznaky v dané stopy, si své odznaky nechají, i když je tato stopa již vypnutá.

Tato funkce může dát nový rozměr zábavy v úspěších (achievementech).
Vyzkoušejte to!',
	'achievements-create-edit-plus-category' => 'Vytvořit tuto stopu',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'Byl vám udělen nový platinový odznak!',
	'achievements-community-platinum-awarded-email-body-text' => "Blahopřejeme!

Právě jste na $4 ($3) získali '$2' platinový odznak.
Získáváte navíc 250 bodů k vašemu celkovému skóre.

Prohlédněte si svůj báječný nový odznak na své profilové stránce:",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Blahopřejeme, $1!</strong><br /><br />
Právě jste byli odměněni Platinovým odznakem \'<strong>$2</strong>\' na stránce <a href="$3">$4</a>.
Tímto jste získali 250 bodů k vašemu skóre!<br /><br />
Podívejte se na svůj zbrusu nový odznak na vaší <a href="$5">profilové stránce</a>.',
	'achievements-community-platinum-awarded-for' => 'Uděleno za:',
	'achievements-community-platinum-how-to-earn' => 'Jak získat:',
	'achievements-community-platinum-awarded-for-example' => 'např. "za..."',
	'achievements-community-platinum-how-to-earn-example' => 'např. "udělej 3 úpravy"',
	'achievements-community-platinum-badge-image' => 'Obrázek odznaku',
	'achievements-community-platinum-awarded-to' => 'Uděleno uživateli:',
	'achievements-community-platinum-current-badges' => 'Aktuální platinové odznaky',
	'achievements-community-platinum-create-badge' => 'Vytvořit odznak',
	'achievements-community-platinum-enabled' => 'aktivováno',
	'achievements-community-platinum-show-recents' => 'zobrazit v nedávných odznacích',
	'achievements-community-platinum-edit' => 'upravit',
	'achievements-community-platinum-save' => 'uložit',
	'achievements-community-platinum-cancel' => 'zrušit',
	'achievements-community-platinum-sponsored-label' => 'Sponzorovaný odznak',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Obrázek s aktivovaným efektem přechodu <small>(minimální velikost: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Klikněte pro více informací',
	'achievements-badge-name-edit-0' => 'Udělat rozdíl',
	'achievements-badge-name-edit-1' => 'Pouze začátek',
	'achievements-badge-name-edit-2' => 'Zanechat stopu',
	'achievements-badge-name-edit-3' => 'Přítel wiki',
	'achievements-badge-name-edit-4' => 'Kolaborant',
	'achievements-badge-name-edit-5' => 'Wiki Stavitel',
	'achievements-badge-name-edit-6' => 'Vůdce wiki',
	'achievements-badge-name-edit-7' => 'Wiki Expert',
	'achievements-badge-name-picture-0' => 'Snímek',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Ilustrátor',
	'achievements-badge-name-picture-3' => 'Sběratel',
	'achievements-badge-name-picture-4' => 'Milovník umění',
	'achievements-badge-name-picture-5' => 'Dekoratér',
	'achievements-badge-name-picture-6' => 'Designér',
	'achievements-badge-name-picture-7' => 'Kurátor',
	'achievements-badge-name-category-0' => 'Navázat spojení',
	'achievements-badge-name-category-1' => 'Průkopník',
	'achievements-badge-name-category-2' => 'Badatel',
	'achievements-badge-name-category-3' => 'Průvodce',
	'achievements-badge-name-category-4' => 'Navigátor',
	'achievements-badge-name-category-5' => 'Stavitel mostů',
	'achievements-badge-name-category-6' => 'Wiki plánovač',
	'achievements-badge-name-blogpost-0' => 'Říci něco',
	'achievements-badge-name-blogpost-1' => 'Říci pět věcí',
	'achievements-badge-name-blogpost-2' => 'Talk show',
	'achievements-badge-name-blogpost-3' => 'Život strany',
	'achievements-badge-name-blogpost-4' => 'Řečník',
	'achievements-badge-name-blogcomment-0' => 'Novic',
	'achievements-badge-name-blogcomment-1' => 'A ještě něco',
	'achievements-badge-name-love-0' => 'Klíč k wiki!',
	'achievements-badge-name-love-1' => 'Dva týdny na wiki',
	'achievements-badge-name-love-2' => 'Oddaný',
	'achievements-badge-name-love-3' => 'Zasvěcený',
	'achievements-badge-name-love-4' => 'Závislý',
	'achievements-badge-name-love-5' => 'Wiki-život',
	'achievements-badge-name-love-6' => 'Hrdina wiki!',
	'achievements-badge-name-sharing-0' => 'Účastník',
	'achievements-badge-name-sharing-1' => 'Vrať to zpátky',
	'achievements-badge-name-sharing-2' => 'Mluvčí',
	'achievements-badge-name-sharing-3' => 'Hlasatel',
	'achievements-badge-name-sharing-4' => 'Evangelista',
	'achievements-badge-name-welcome' => 'Vítejte na wiki',
	'achievements-badge-name-introduction' => 'Úvod',
	'achievements-badge-name-sayhi' => 'Stav se a řekni ahoj',
	'achievements-badge-name-creator' => 'Zakladatel',
	'achievements-badge-name-pounce' => 'Udeř!',
	'achievements-badge-name-caffeinated' => 'zkofeinovaný',
	'achievements-badge-name-luckyedit' => 'Šťastná úprava',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|share link|get {{PLURAL:$1|jeden člověk|$1 lidé(í)}} kliklo na tvůj odkaz}}',
	'achievements-badge-to-get-edit' => 'udělej $1 {{PLURAL:$1|úpravu|úprav}} na {{PLURAL:$1|stránce|stránkách}}',
	'achievements-badge-to-get-edit-plus-category' => 'udělej {{PLURAL:$1|jednu úpravu|$1 úprav}} na {{PLURAL:$1| stránce: $2|stránkách: $2}}',
	'achievements-badge-to-get-picture' => 'přidej $1 {{PLURAL:$1|obrázek|obrázky/ů}} na {{PLURAL:$1|stránku|stránky}}',
	'achievements-badge-to-get-category' => 'přidej $1 {{PLURAL:$1|stránku|stránek}} do {{PLURAL:$1|kategorie|kategorií}}',
	'achievements-badge-to-get-blogpost' => 'napiš $1 {{PLURAL:$1|příspěvěk na blog|příspěvky/ů na blog}}',
	'achievements-badge-to-get-blogcomment' => 'napiš komentář k {{PLURAL:$1|příspěvku na blogu| $1 příspěvkům na blogu}}',
	'achievements-badge-to-get-love' => 'přispívej do wiki každý den po dobu {{PLURAL:$1|dne|$1 dnů}}!',
	'achievements-badge-to-get-welcome' => 'připoj se k Wiki',
	'achievements-badge-to-get-introduction' => 'přidat k vlastní uživatelské stránce',
	'achievements-badge-to-get-sayhi' => 'zanechat někomu zprávu na diskusní stránce',
	'achievements-badge-to-get-creator' => 'být tvůrcem této wiki',
	'achievements-badge-to-get-pounce' => 'rychle',
	'achievements-badge-to-get-caffeinated' => 'udělej  {{PLURAL:$1| jednu úpravu| $1  úprav(y)}} na stránkách za jediný den',
	'achievements-badge-to-get-luckyedit' => 'mějte štěstí',
	'achievements-badge-to-get-sharing-details' => 'Sdílej odkazy a přiměj ostatní na ně kliknout!',
	'achievements-badge-to-get-edit-details' => 'Něco chybí?
Vidíte chybu?
Neostýchejte se.
Klikněte na tlačítko „{{int:edit}}“ a upravte kteroukoliv stránku!',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong> stránka potřebuje tvoji pomoc!
Klikni na tlačítko "{{int:edit}}" na jakékoliv stránce.
Ukaž tvojí podporu $1 stránkám.',
	'achievements-badge-to-get-picture-details' => 'Klepnětě na tlačítko "{{int:edit}}" a poté na "{{int:rte-ck-image-add}}".
Můžete přidat fotografii ze svého počítače nebo z jiné stránky na wiki.',
	'achievements-badge-to-get-category-details' => 'Kategorie jsou značky, které pomáhají čtenářům najít podobné stránky.
Klikněte na tlačítko "{{int:categoryselect-addcategory-button}}" na konci stránky pro přidání kategorie k článku.',
	'achievements-badge-to-get-blogpost-details' => 'Napište své názory či dotazy!
Klikněte na „{{int:blogs-recent-url-text}}“ na postranním panelu a poté na odkaz „{{int:create-blog-post-title}}“.',
	'achievements-badge-to-get-blogcomment-details' => 'Přispějte svou troškou!
Přečtěte si kterýkoliv nedávno přidaný blogový příspěvek a napište svůj názor do komentářů.',
	'achievements-badge-to-get-introduction-details' => 'Je vaše uživatelská stránka prázdná?
Klikněte v horní části obrazovky  na své uživatelské jméno a podívejte se.
Klikněte na tlačítko „{{int:edit}}“ a doplňte nějaké informace o sobě!',
	'achievements-badge-to-get-sayhi-details' => 'Můžete ostatním zanechat zprávu klepnutím na  „{{int:addsection}}“ na jejich diskusní stránce.
Požádejte o pomoc, poděkujte za spolupráci nebo jen pošlete pozdrav!',
	'achievements-badge-to-get-creator-details' => 'Tento odznak je udělen osobě, jež založila wiki.
Klikněte nahoře na tlačítko „{{int:createwiki}}“ a založte stránku o čemkoli, co vás zajímá!',
	'achievements-badge-to-get-luckyedit-details' => 'Abyste získali tento odznak, musíte mít štěstí.
Editujte dál!',
	'achievements-badge-hover-desc-introduction' => 'Odměněn/a za přidání na<br />
vaší uživatelskou stránku!',
	'achievements-badge-your-desc-blogcomment' => 'Odměněn/a za komentování {{PLURAL:$1|blogového příspěvku|$1 různých blogových příspěvků}}!',
	'achievements-badge-your-desc-love' => 'Odměněn/a za každodenní přispívání na wiki po dobu {{PLURAL:$1|dne|$1 dnů}}!',
	'achievements-badge-your-desc-welcome' => 'Odměněn/a za vstup na wiki!',
	'achievements-badge-your-desc-introduction' => 'Odměněn/a za přidání na vaší uživatelskou stránku!',
	'achievements-badge-your-desc-sayhi' => 'Odměněn/a za napsání zprávy na diskusní stránce jiného uživatele!',
	'achievements-badge-your-desc-creator' => 'Odměněn/a za založení wiki!',
	'achievements-badge-desc-love' => 'Odměněn/a za každodenní přispívání do wiki po dobu {{PLURAL:$1|dne|$1 dnů}}!',
	'achievements-badge-desc-sayhi' => 'Odměněn/a za zanechání zprávy na diskusní stránce jiného uživatele!',
	'achievements-badge-desc-creator' => 'Odměněn/a za vytvoření wiki!',
	'achievements-badge-desc-caffeinated' => 'Odměněn/a za provedení 100 editací v jediném dni!',
	'achievements-userprofile-no-badges-visitor' => 'Tento uživatel ještě nemá žádný odznak!',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Hodnocení #$1]]<br />na této wiki',
);

$messages['da'] = array(
	'achievements-badge-name-edit-1' => 'Bare begyndelsen',
);

$messages['de'] = array(
	'achievementsii-desc' => 'Leistungsbasierte Abzeichen für Wiki-Benutzer',
	'achievements-upload-error' => 'Tut uns Leid!
Dieses Bild funktioniert nicht.
Stelle sicher, dass es sich um eine .jpg- oder- .png-Datei handelt.
Wenn es immer noch nicht funktioniert, dann ist das Bild wohl zu groß.
Bitte versuche es mit einem anderen!',
	'achievements-upload-not-allowed' => 'Administratoren können die Namen und Bilder von Abzeichen durch die [[Special:AchievementsCustomize|Abzeichen ändern]]-Seite anpassen.',
	'achievements-non-existing-category' => 'Die angegebene Kategorie existiert nicht.',
	'achievements-edit-plus-category-track-exists' => 'Die angegebene Kategorie hat bereits eine <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">Laufbahn</a>.',
	'achievements-no-stub-category' => 'Bitte lege keine Laufbahn für Stubs an.',
	'right-platinum' => 'Platin-Abzeichen erstellen und bearbeiten',
	'right-sponsored-achievements' => 'Gesponserte Herausforderungen verwalten',
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Gold',
	'achievements-silver' => 'Silber',
	'achievements-bronze' => 'Bronze',
	'achievements-gold-points' => '100<br />Pkt.',
	'achievements-silver-points' => '50<br />Pkt.',
	'achievements-bronze-points' => '10<br />Pkt.',
	'achievements-you-must' => 'Du musst $1 um dieses Abzeichen zu verdienen.',
	'leaderboard-button' => 'Rangliste',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|Punkt|Punkte}}</small>',
	'achievements-profile-title-no' => 'Abzeichen von $1',
	'achievements-no-badges' => 'In der Liste unten siehst du die Abzeichen, die du dir in diesem Wiki verdienen kannst!',
	'achievements-track-name-edit' => 'Bearbeitungen-Laufbahn',
	'achievements-track-name-picture' => 'Bilder-Laufbahn',
	'achievements-track-name-category' => 'Kategorien-Laufbahn',
	'achievements-track-name-blogpost' => 'Blogbeiträge-Laufbahn',
	'achievements-track-name-blogcomment' => 'Blogkommentar-Laufbahn',
	'achievements-track-name-love' => 'Wiki-Love-Laufbahn',
	'achievements-track-name-sharing' => 'Teilen-Laufbahn',
	'achievements-notification-title' => 'Weiter so, $1!',
	'achievements-notification-subtitle' => 'Du hast gerade das „<strong>$1</strong>“-Abzeichen erhalten $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Mehr von dir verdienbare Abzeichen ansehen]]!</big></strong>',
	'achievements-points' => '{{PLURAL:$1|Punkt|$1 Punkte}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|Punkt|Punkte}}',
	'achievements-earned' => 'Dieses Abzeichen wurde von {{PLURAL:$1|einem Benutzer|$1 Benutzern}} verdient.',
	'achievements-profile-title' => '$1 hat $2 {{PLURAL:$2|Abzeichen|Abzeichen}} verdient',
	'achievements-profile-title-challenges' => 'Mehr Abzeichen, die du verdienen kannst!',
	'achievements-profile-customize' => 'Abzeichen anpassen',
	'achievements-ranked' => 'Platz #$1 in diesem Wiki',
	'achievements-viewall' => 'Alle anzeigen',
	'achievements-viewless' => 'Schließen',
	'achievements-profile-title-oasis' => 'Leistungs- <br /> punkte',
	'achievements-ranked-oasis' => '$1 belegt [[Special:Leaderboard|Rang #$2]] in diesem Wiki',
	'achievements-viewall-oasis' => 'Alle anzeigen',
	'achievements-toggle-hide' => 'Meine verdienten Abzeichen nicht auf meiner Profilseite anzeigen',
	'leaderboard-intro-hide' => 'Ausblenden',
	'leaderboard-intro-open' => 'Öffnen',
	'leaderboard-intro-headline' => 'Was sind Herausforderungen?',
	'leaderboard-intro' => "In diesem Wiki kannst du Abzeichen verdienen, indem du Seiten bearbeitest, Bilder hochlädst und Kommentare hinterlässt. Mit jedem Abzeichen verdienst du Punkte - und je mehr Punkte du hast, desto höher kletterst du auf der Rangliste! Du findest die Abzeichen, die du verdient hast, auf deiner [[$1|Benutzerseite]].

'''Was sind Abzeichen wert?'''",
	'leaderboard' => 'Rangliste',
	'achievements-title' => 'Herausforderungen',
	'leaderboard-title' => 'Rangliste',
	'achievements-recent-earned-badges' => 'Kürzlich verdiente Abzeichen',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />verdient von <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'hat sich das <strong><a href="$3" class="badgeName">$1</a></strong>-Abzeichen verdient<br />$2',
	'achievements-leaderboard-disclaimer' => 'Rangliste zeigt die Veränderungen seit gestern',
	'achievements-leaderboard-rank-label' => 'Rang',
	'achievements-leaderboard-member-label' => 'Mitglied',
	'achievements-leaderboard-points-label' => 'Punkte',
	'achievements-leaderboard-points' => '{{PLURAL:$1|Punkt|Punkte}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Zuletzt verdiente',
	'achievements-send' => 'Bild speichern',
	'achievements-save' => 'Änderungen speichern',
	'achievements-reverted' => 'Abzeichen auf Voreinstellung zurückgesetzt.',
	'achievements-customize' => 'Eigenes Bild verwenden',
	'achievements-customize-new-category-track' => 'Eine neue Laufbahn für diese Kategorie erstellen:',
	'achievements-enable-track' => 'aktiviert',
	'achievements-revert' => 'Auf Voreinstellungen zurücksetzen',
	'achievements-special-saved' => 'Änderungen gespeichert.',
	'achievements-special' => 'Besondere Herausforderungen',
	'achievements-secret' => 'Geheime Herausforderungen',
	'achievementscustomize' => 'Abzeichen anpassen',
	'achievements-about-title' => 'Über diese Seite...',
	'achievements-about-content' => 'Administratoren können die Namen und Bilder der Abzeichen in diesem Wiki anpassen.

Du kannst ein beliebiges .jpg- oder .png-Bild hochladen, und dein Bild wird automatisch in den Rahmen passen.
Das funktioniert am besten, wenn dein Bild quadratisch ist, und wenn der wichtigste Teil des Bildes genau in der Mitte ist.

Du kannst auch rechteckige Bilder verwenden, wirst aber vielleicht feststellen, dass ein Teil des Bildes vom Rahmen abgeschnitten wird.
Wenn du ein Bildbearbeitungs-Programm hast, kannst du das Bild zuschneiden, um den wichtigsten Teil des Bildes in die Mitte zu rücken.
Wenn du kein Bildbearbeitungs-Programm hast, dann experimentiere einfach mit verschiedenen Bildern, bis du etwas findest, das für dich funktioniert!
Wenn du das von dir gewählte Bild nicht magst, klicke auf „{{int:achievements-revert}}“, um es wieder auf die ursprüngliche Grafik zurückzusetzen.

Du kannst auch den Abzeichen einen neuen Namen geben, welche das Thema des Wikis wiedergeben.
Wenn du den Namen geändert hast, klicke auf „{{int:achievements-save}}“.
Viel Spaß!',
	'achievements-edit-plus-category-track-name' => '$1 Bearbeitungen-Laufbahn',
	'achievements-create-edit-plus-category-title' => 'Eine neue Laufbahn für Bearbeitungen erstellen',
	'achievements-create-edit-plus-category-content' => 'Du kannst einen neuen Satz Abzeichen erstellen, um Benutzer für die Bearbeitung von Seiten in einer bestimmten Kategorie zu belohnen und so einen bestimmten Bereich der Seite hervorzuheben, in dem Benutzer gerne arbeiten würden.
Du kannst mehrere Kategorie-Laufbahnen erstellen, also versuche, zwei Kategorien zu wählen, die die Talente der Benutzer hervorheben!
Entzünde einen Rivalitätskampf zwischen den Benutzern, die Vampirseiten bearbeiten und den Benutzern, die Werwolfseiten bearbeiten, oder Zauberer und Muggel, oder Autobots und Decepticons.

Um eine neue „Bearbeitung in einer Kategorie“-Laufbahn zu erstellen, gib den Namen der Kategorie in das Feld unten ein.
Die normale Bearbeitungen-Laufbahn bleibt bestehen, während du eine eigene Bearbeitungen-Laufbahn erstellst, die du separat anpassen kannst.

Wenn die Laufbahn erstellt wurde, erscheint das neue Abzeichen in der Liste links unter der normalen Bearbeitungen-Laufbahn.
Passe den Namen und das Bild der neuen Laufbahn an, sodass Benutzer den Unterschied sehen!

Sobald du die Anpassungen vorgenommen hast, hake das {{int:achievements-enable-track}}-Kontrollkästchen ab, um die neue Laufbahn zu aktivieren, und klicke dann auf „{{int:achievements-save}}“.
Du kannst die Laufbahn auch später wieder deaktivieren, wenn du entscheidest, dass du diese Kategorie nicht mehr hervorheben möchtest.
Benutzer, die Abzeichen dieser Laufbahn erhalten haben, behalten ihre Abzeichen auch dann, wenn die Laufbahn deaktiviert wird.

Dies kann helfen, Herausforderungen noch spaßiger zu gestalten.
Probier es einfach aus!',
	'achievements-create-edit-plus-category' => 'Diese Laufbahn erstellen',
	'platinum' => 'Platin',
	'achievements-community-platinum-awarded-email-subject' => 'Du hast ein neues Platin-Abzeichen erhalten!',
	'achievements-community-platinum-awarded-email-body-text' => "Herzlichen Glückwunsch $1!

du bist gerade mit dem '$2' Platin-Abzeichen bei $4 ($3) versehen worden.
Dafür gibt es 250 Punkte auf dein Konto!

Schau dir dein schickes neues Abzeichen auf deiner Benutzerseite an:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Herzlichen Glückwunsch $1!</strong><br /><br />
du bist gerade mit dem \'<strong>$2</strong>\' Platin-Abzeichen bei <a href="$3">$4</a> versehen worden.
Dafür gibt es 250 Punkte auf dein Konto!<br /><br />
Schau dir dein hübsches neues Abzeichen auf deiner <a href="$5">Benutzerseite</a> an.',
	'achievements-community-platinum-awarded-for' => 'Ausgezeichnet für:',
	'achievements-community-platinum-how-to-earn' => 'So verdient man:',
	'achievements-community-platinum-awarded-for-example' => 'z. B. „durch...“',
	'achievements-community-platinum-how-to-earn-example' => 'z. B. „3 Bearbeitungen...“',
	'achievements-community-platinum-badge-image' => 'Abzeichen-Bild:',
	'achievements-community-platinum-awarded-to' => 'Vergeben an:',
	'achievements-community-platinum-current-badges' => 'Aktuelle Platin-Abzeichen',
	'achievements-community-platinum-create-badge' => 'Abzeichen erstellen',
	'achievements-community-platinum-enabled' => 'aktiviert',
	'achievements-community-platinum-show-recents' => 'in den letzten Abzeichen anzeigen',
	'achievements-community-platinum-edit' => 'bearbeiten',
	'achievements-community-platinum-save' => 'speichern',
	'achievements-community-platinum-cancel' => 'abbrechen',
	'achievements-community-platinum-sponsored-label' => 'Gesponserte Herausforderung',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Mouseover-Bild <small>(Mindestmaße: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Tracking-URL für Abzeichen-Eindrücke:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Tracking-URL für Mouseover-Eindruck:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Abzeichen-Link <small>(PFEIL Klick URL)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Klicken, um mehr zu erfahren',
	'achievements-badge-name-edit-0' => 'Bewegt etwas',
	'achievements-badge-name-edit-1' => 'Nur der Anfang',
	'achievements-badge-name-edit-2' => 'Dein Zeichen setzen',
	'achievements-badge-name-edit-3' => 'Freund des Wikis',
	'achievements-badge-name-edit-4' => 'Mitarbeiter',
	'achievements-badge-name-edit-5' => 'Wiki-Aufbauer',
	'achievements-badge-name-edit-6' => 'Wiki-Anführer',
	'achievements-badge-name-edit-7' => 'Wiki-Experte',
	'achievements-badge-name-picture-0' => 'Schnappschuss',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Grafiker',
	'achievements-badge-name-picture-3' => 'Sammler',
	'achievements-badge-name-picture-4' => 'Kunstliebhaber',
	'achievements-badge-name-picture-5' => 'Dekorateur',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Kurator',
	'achievements-badge-name-category-0' => 'Verknüpfer',
	'achievements-badge-name-category-1' => 'Wegbereiter',
	'achievements-badge-name-category-2' => 'Entdecker',
	'achievements-badge-name-category-3' => 'Reiseführer',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Brückenbauer',
	'achievements-badge-name-category-6' => 'Wiki-Planer',
	'achievements-badge-name-blogpost-0' => 'Hat was zu sagen',
	'achievements-badge-name-blogpost-1' => 'Hat fünf Dinge zu sagen',
	'achievements-badge-name-blogpost-2' => 'Talkshow',
	'achievements-badge-name-blogpost-3' => 'Partylöwe',
	'achievements-badge-name-blogpost-4' => 'Redner',
	'achievements-badge-name-blogcomment-0' => 'Meinungssager',
	'achievements-badge-name-blogcomment-1' => 'Da ist noch etwas',
	'achievements-badge-name-love-0' => 'Schlüssel zum Wiki!',
	'achievements-badge-name-love-1' => 'Zwei Wochen im Wiki',
	'achievements-badge-name-love-2' => 'Hingebungsvoll',
	'achievements-badge-name-love-3' => 'Engagiert',
	'achievements-badge-name-love-4' => 'Süchtig',
	'achievements-badge-name-love-5' => 'Lebt im Wiki',
	'achievements-badge-name-love-6' => 'Held des Wikis!',
	'achievements-badge-name-sharing-0' => 'Teilender',
	'achievements-badge-name-sharing-1' => 'Bring es zurück',
	'achievements-badge-name-sharing-2' => 'Sprecher',
	'achievements-badge-name-sharing-3' => 'Ansager',
	'achievements-badge-name-sharing-4' => 'Trendsetter',
	'achievements-badge-name-welcome' => 'Willkommen im Wiki',
	'achievements-badge-name-introduction' => 'Vorstellung',
	'achievements-badge-name-sayhi' => 'Schau vorbei und sag Hallo',
	'achievements-badge-name-creator' => 'Der Schöpfer',
	'achievements-badge-name-pounce' => 'Rumms!',
	'achievements-badge-name-caffeinated' => 'Koffeiniert',
	'achievements-badge-name-luckyedit' => 'Zufällige Bearbeitung',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|Link teilen|bringe {{PLURAL:$1|eine Person|$1 Leute}} dazu, auf den von dir geteilten Link zu klicken}}',
	'achievements-badge-to-get-edit' => '$1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} auf {{PLURAL:$1|einem Artikel|Artikeln}}',
	'achievements-badge-to-get-edit-plus-category' => '{{PLURAL:$1|eine Bearbeitung|$1 Bearbeitungen}} auf {{PLURAL:$1|einer $2 Seite|$2 Seiten}} tätigen',
	'achievements-badge-to-get-picture' => '$1 {{PLURAL:$1|Bild|Bilder}} zu {{PLURAL:$1|einer Seite|Seiten}} hinzufügen',
	'achievements-badge-to-get-category' => '$1 {{PLURAL:$1|Seite|Seiten}} zu {{PLURAL:$1|einer Kategorie|Kategorien}} hinzufügen',
	'achievements-badge-to-get-blogpost' => '$1 {{PLURAL:$1|Blogbeitrag|Blogbeiträge}} schreiben',
	'achievements-badge-to-get-blogcomment' => 'einen Kommentar zu {{PLURAL:$1|einem Blogbeitrag|$1 verschiedenen Blogbeiträgen}} schreiben',
	'achievements-badge-to-get-love' => 'im Wiki täglich über einen Zeitraum von {{PLURAL:$1|einem Tag|$1 Tagen}} mitmachen',
	'achievements-badge-to-get-welcome' => 'dem Wiki beitreten',
	'achievements-badge-to-get-introduction' => 'zur eigenen Benutzerseite hinzufügen',
	'achievements-badge-to-get-sayhi' => 'jemandem eine Nachricht auf seiner Diskussionsseite hinterlassen',
	'achievements-badge-to-get-creator' => 'der Ersteller des Wikis sein',
	'achievements-badge-to-get-pounce' => 'sei schnell',
	'achievements-badge-to-get-caffeinated' => '100 Artikelbearbeitungen an einem einzigen Tag',
	'achievements-badge-to-get-luckyedit' => 'Glück haben',
	'achievements-badge-to-get-sharing-details' => 'Teile Links und motiviere andere dazu, sie anzuklicken!',
	'achievements-badge-to-get-edit-details' => 'Fehlt etwas?
Ist da ein Fehler?
Keine Angst.
Klicke auf den „{{int:edit}}“-Button und du kannst zu jeder Seite beitragen!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Die <strong>$1</strong>-Seiten brauchen deine Hilfe!
Klicke auf den „{{int:edit}}“-Button auf einer beliebigen Seite in dieser Kategorie, um zu helfen.
Zeig deine Unterstützung für die $1-Seiten!',
	'achievements-badge-to-get-picture-details' => 'Klick auf den „{{int:edit}}“-Button und dann den „{{int:rte-ck-image-add}}“-Button.
Du kannst ein Bild von deinem Computer oder von einer anderen Seite im Wiki hinzufügen.',
	'achievements-badge-to-get-category-details' => 'Kategorien sind Schlagworte, die Lesern helfen, ähnliche Seiten zu finden.
Klicke auf den „{{int:categoryselect-addcategory-button}}“-Button am unteren Rand einer Seite um sie in eine Kategorie einzuordnen.',
	'achievements-badge-to-get-blogpost-details' => 'Schreib deine Meinung und Fragen! Klicke auf „{{int:blogs-recent-url-text}}“ in der Seitenleiste und danach den Link „{{int:create-blog-post-title}}“ auf der linken Seite.',
	'achievements-badge-to-get-blogcomment-details' => 'Gib deinen Senf dazu!
Lies einen der aktuellen Blog-Posts und schreib deine Meinung in das Kommentarfeld!',
	'achievements-badge-to-get-love-details' => 'Der Zähler geht auf null zurück, wenn du einen Tag verpasst. Komm also jeden Tag zum Wiki zurück!',
	'achievements-badge-to-get-welcome-details' => 'Klick auf den „{{int:oasis-signup}}“-Button oben rechts, um der Community beizutreten.
Du kannst dir dann eigene Abzeichen verdienen!',
	'achievements-badge-to-get-introduction-details' => 'Ist deine Benutzerseite leer?
Klicke auf deinen Benutzernamen oben rechts, um nachzusehen!
Klicke auf „{{int:edit}}“, um ein paar Informationen zu dir einzugeben!',
	'achievements-badge-to-get-sayhi-details' => 'Du kannst anderen Benutzern Nachrichten hinterlassen, indem du auf „{{int:addsection}}“ auf ihrer Diskussionsseite klickst.
Frage sie um Hilfe, danke ihnen für ihre Arbeit oder sag einfach mal Hallo!',
	'achievements-badge-to-get-creator-details' => 'Dieses Abzeichen geht an die Person, die das Wiki gegründet hat.
Klicke auf den „{{int:createwiki}}“-Button oben, um dein eigenes Wiki zu einem beliebigen Thema zu erstellen!',
	'achievements-badge-to-get-pounce-details' => 'Du musst schnell sein, um dieses Abzeichen zu erhalten.
Klicke auf den „{{int:activityfeed}}“-Button, um die neuen Seiten zu sehen, die andere Benutzer erstellen!',
	'achievements-badge-to-get-caffeinated-details' => 'Du musst dich einen Tag ganz schön ranhalten, um dieses Abzeichen zu erhalten.
Also häng dich rein!',
	'achievements-badge-to-get-luckyedit-details' => 'Es braucht Glück, um dieses Abzeichen zu erhalten.
Einfach weitermachen!',
	'achievements-badge-to-get-community-platinum-details' => 'Dies ist ein besonderes Platinum-Abzeichen, das nur kurze Zeit verfügbar ist!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|für das Teilen eines Links|für {{PLURAL:$1|eine Person|$1 Leute}} die auf geteilte Links geklickt haben}}',
	'achievements-badge-hover-desc-edit' => 'Verliehen für $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} auf {{PLURAL:$1|einem Artikel|$1 Artikeln}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Verliehen für $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} auf {{PLURAL:$1|einem $2 Artikel|$2 Artikeln}}!',
	'achievements-badge-hover-desc-picture' => 'Verliehen für das Hinzufügen von $1 {{PLURAL:$1|Bild|Bildern}} zu {{PLURAL:$1|einem Artikel|Artikeln}}!',
	'achievements-badge-hover-desc-category' => 'Verliehen für das Hinzufügen von $1 {{PLURAL:$1|Artikel|Artikeln}} zu {{PLURAL:$1|einer Kategorie|Kategorien}}!',
	'achievements-badge-hover-desc-blogpost' => 'Verliehen für das Schreiben von $1 {{PLURAL:$1|Blogbeitrag|Blogbeiträgen}}!',
	'achievements-badge-hover-desc-blogcomment' => 'Verliehen für das Verfassen eines Kommentars<br />
zu $1 verschiedenen {{PLURAL:$1|Blogbeitrag|Blogbeiträgen}}!',
	'achievements-badge-hover-desc-love' => 'Verliehen für einen täglichen Beitrag im Wiki über einen Zeitraum von {{PLURAL:$1|einem Tag|$1 Tagen}}!',
	'achievements-badge-hover-desc-welcome' => 'Verliehen für den Beitritt zum Wiki!',
	'achievements-badge-hover-desc-introduction' => 'Verliehen für das Ausbauen der eigenen Benutzerseite!',
	'achievements-badge-hover-desc-sayhi' => 'Verliehen für das Hinterlassen einer Nachricht auf der Diskussionsseite eines anderen!',
	'achievements-badge-hover-desc-creator' => 'Verliehen für das Erstellen des Wikis!',
	'achievements-badge-hover-desc-pounce' => 'Verliehen für das Bearbeiten von 100 Seiten innerhalb einer Stunde nach ihrer Erstellung!',
	'achievements-badge-hover-desc-caffeinated' => 'Verliehen für 100 Artikelbearbeitungen an einem einzigen Tag!',
	'achievements-badge-hover-desc-luckyedit' => 'Verliehen für die zufällige $1ste Bearbeitung in diesem Wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Dies ist ein besonderes Platin-Abzeichen das nur für eine begrenzte Zeit verfügbar ist!',
	'achievements-badge-your-desc-sharing' => 'Verliehen {{#ifeq:$1|0|für das Teilen eines Links|für Klicks auf geteilte Links von {{PLURAL:$1|einer Person|$1 Leuten}}}}',
	'achievements-badge-your-desc-edit' => 'Verliehen für {{PLURAL:$1|deine erste Bearbeitung|$1 Bearbeitungen}} auf {{PLURAL:$1|einem Artikel|Artikeln}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'Verliehen für {{PLURAL:$1|deine erste Bearbeitung|$1 Bearbeitungen}} auf {{PLURAL:$1|einem $2 Artikel|$2 Artikeln}}!',
	'achievements-badge-your-desc-picture' => 'Verliehen für das Hinzufügen {{PLURAL:$1|deines ersten Bildes|von $1 Bildern}} auf {{PLURAL:$1|einer Seite|Seiten}}!',
	'achievements-badge-your-desc-category' => 'Verliehen für das Hinzufügen {{PLURAL:$1|deiner ersten Seite|von $1 Seiten}} zu {{PLURAL:$1|einer Kategorie|Kategorien}}!',
	'achievements-badge-your-desc-blogpost' => 'Verliehen für das Schreiben {{PLURAL:$1|deines ersten Blogbeitrags|von $1 Blogbeiträgen}}!',
	'achievements-badge-your-desc-blogcomment' => 'Verliehen für das Schreiben eines Kommentars zu {{PLURAL:$1|einem Blogbeitrag|$1 verschiedenen Blogbeiträgen}}!',
	'achievements-badge-your-desc-love' => 'Verliehen für das tägliche Bearbeiten des Wikis über einen Zeitraum von {{PLURAL:$1|einem Tag|$1 Tagen}}!',
	'achievements-badge-your-desc-welcome' => 'Verliehen für den Beitritt zum Wiki!',
	'achievements-badge-your-desc-introduction' => 'Verliehen für das Hinzufügen zur eigenen Benutzerseite!',
	'achievements-badge-your-desc-sayhi' => 'Verliehen für das Hinterlassen einer Nachricht auf der Diskussionsseite eines anderen!',
	'achievements-badge-your-desc-creator' => 'Verliehen für das Erstellen des Wikis!',
	'achievements-badge-your-desc-pounce' => 'Verliehen für Bearbeitungen auf 100 Artikeln innerhalb einer Stunde nach ihrer Erstellung!',
	'achievements-badge-your-desc-caffeinated' => 'Verliehen für 100 Bearbeitungen an einem einzigen Tag!',
	'achievements-badge-your-desc-luckyedit' => 'Verliehen für die $1ste Bearbeitung im Wiki!',
	'achievements-badge-desc-sharing' => 'Verliehen {{#ifeq:$1|0|für das Teilen eines Links|für Klicks auf geteilte Links von {{PLURAL:$1|einer Person|$1 Leuten}}}}',
	'achievements-badge-desc-edit' => 'Verliehen für $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} auf {{PLURAL:$1|einem Artikel|Artikeln}}!',
	'achievements-badge-desc-edit-plus-category' => 'Verliehen für $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} auf {{PLURAL:$1|einem $2 Artikel|$2 Artikeln}}!',
	'achievements-badge-desc-picture' => 'Verliehen für das Hinzufügen von $1 {{PLURAL:$1|Bild|Bildern}} auf {{PLURAL:$1|einer Seite|Seiten}}!',
	'achievements-badge-desc-category' => 'Verliehen für das Hinzufügen von $1 {{PLURAL:$1|Seite|Seiten}} zu {{PLURAL:$1|einer Kategorie|Kategorien}}!',
	'achievements-badge-desc-blogpost' => 'Verliehen für das Schreiben von $1 {{PLURAL:$1|Blogbeitrag|Blogbeiträgen}}!',
	'achievements-badge-desc-blogcomment' => 'Verliehen für das Schreiben eines Kommentars zu {{PLURAL:$1|einem Blogbeitrag|$1 verschiedenen Blogbeiträgen}}!',
	'achievements-badge-desc-love' => 'Verliehen für die tägliche Bearbeitung des Wikis über einen Zeitraum von {{PLURAL:$1|einem Tag|$1 Tagen}}!',
	'achievements-badge-desc-welcome' => 'Verliehen für den Beitritt zum Wiki!',
	'achievements-badge-desc-introduction' => 'Verliehen für das Hinzufügen zur eigenen Benutzerseite!',
	'achievements-badge-desc-sayhi' => 'Verliehen für das Hinterlassen einer Nachricht auf der Diskussionsseite eines anderen!',
	'achievements-badge-desc-creator' => 'Verliehen für das Erstellen des Wikis!',
	'achievements-badge-desc-pounce' => 'Verliehen für Bearbeitungen auf 100 Seiten innerhalb einer Stunde nach ihrer Erstellung!',
	'achievements-badge-desc-caffeinated' => 'Verliehen für 100 Bearbeitungen an einem einzigen Tag!',
	'achievements-badge-desc-luckyedit' => 'Verliehen für die $1ste Bearbeitung im Wiki!',
	'achievements-userprofile-title-no' => 'Abzeichen von $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Das|Die}} Abzeichen von $1 ($2)',
	'achievements-userprofile-no-badges-owner' => 'In der Liste unten siehst du die Abzeichen, die du dir in diesem Wiki verdienen kannst!',
	'achievements-userprofile-no-badges-visitor' => 'Dieser Benutzer hat noch keine Abzeichen verdient.',
	'achievements-userprofile-profile-score' => '<em>$1</em> Herausforderungs-<br />punkte',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Rang #$1]]<br />in diesem Wiki',
	'action-platinum' => 'Platin-Abzeichen erstellen und bearbeiten',
	'achievements-next-oasis' => 'Weiter',
	'achievements-prev-oasis' => 'Vorherige',
	'right-achievements-exempt' => 'Benutzer ist nicht berechtigt, Punkte für Herausforderungen zu sammeln',
	'right-achievements-explicit' => 'Benutzer ist berechtigt, Punkte für Herausforderungen zu sammeln (überschreibt gegenteilige Rechte)',
);

$messages['de-formal'] = array(
	'achievements-upload-error' => 'Verzeihung,
dieses Bild funktioniert nicht.
Stellen Sie sicher, dass es sich um eine JPEG- oder PNG-Datei handelt.
Wenn es immer noch nicht funktioniert, dann ist das Bild wohl zu groß.
Bitte versuchen Sie ein anderes Bild!',
	'achievements-no-stub-category' => 'Bitte legen Sie keine Laufbahn für Stubs an.',
	'achievements-you-must' => 'Sie müssen $1 um dieses Abzeichen zu verdienen.',
	'achievements-no-badges' => 'Erreichbare Auszeichnungen können Sie untenstehender Liste entnehmen.',
	'achievements-notification-title' => 'Lobenswert, $1!',
	'achievements-notification-subtitle' => 'Sie haben gerade die Auszeichnung „$1“ erhalten $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Weitere erreichbare Abzeichen ansehen]]</big></strong>',
	'achievements-profile-title-challenges' => 'Mehr von Ihnen verdienbare Abzeichen',
	'leaderboard-intro' => "In diesem Wiki können Sie Abzeichen verdienen, indem Sie Artikel bearbeiten, Fotos hochladen und Kommentare hinterlassen. Mit jedem Abzeichen verdienen Sie Punkte steigen auf der Rangliste auf. Verdiente Abzeichen finden Sie auf Ihrer [[$1|Benutzerseite]].

'''Was sind Abzeichen wert?'''",
	'achievements-about-content' => 'Administratoren in diesem Wiki können die Namen und Bilder der Auszeichnungen in diesem Wiki anpassen.

Sie können ein beliebiges .jpg- oder .png-Bild hochladen, und Ihr Bild wird automatisch in den Rahmen passen.
Das funktioniert am besten, wenn Ihr Bild quadratisch ist, und wenn der wichtigste Teil des Bildes genau in der Mitte ist.

Sie können auch rechteckige Bilder verwenden, werden aber vielleicht feststellen, dass ein Teil des Rahmens abgeschnitten wird.
Wenn Sie ein Bildbearbeitungs-Programm haben, können Sie das Bild zuschneiden, um den wichtigsten Teil des Bildes in die Mitte zu bringen.
Wenn Sie kein Bildbearbeitungs-Programm haben, dann experimentieren Sie einfach mit verschiedenen Bildern, bis Sie die finden, die für Sie funktionieren!
Wenn Sie das von Ihnen gewählte Bild nicht mögen, klicken Sie auf „{{int:achievements-revert}}“, um es wieder auf die ursprüngliche Grafik zurückzusetzen.

Sie können auch den Auszeichnungen einen neuen Namen geben, welche das Thema des Wikis widerspiegeln.
Wenn Sie den Namen geändert haben, klicken Sie auf „{{int:achievements-save}}“ um die Änderungen zu speichern.
Viel Spaß!',
	'achievements-create-edit-plus-category-content' => 'Sie können einen neuen Satz Abzeichen erstellen, der Benutzer für die Bearbeitung von Seiten in einer bestimmten Kategorie belohnt, um einen bestimmten Bereich der Seite hervorzuheben, in dem Benutzer gerne arbeiten würden.
Sie können für mehrere Kategorien solche Laufbahnen erstellen, also versuchen Sie, zwei Kategorien zu wählen, in denen Benutzer ihr Fachwissen demonstrieren könnten.
Entzünden Sie einen Rivalitätenkampf zwischen Benutzern, die Popmusik-Seiten bearbeiten und Benutzern, die Klassische-Musik-Seiten bearbeiten, oder Western versus Science-Fiction, oder Konservative versus Liberale.

Geben Sie den Namen der Kategorie in das Feld unterhalb ein, um eine neue „Bearbeitung-in-einer-Kategorie“-Laufbahn zu erstellen.
Die normale Bearbeitungslaufbahn wird weiterhin existieren;
dies wird eine eigentümliche Bearbeitungslaufbahn erstellen, die Sie separat anpassen können.

Wenn die Laufbahn erstellt wurde, wird die neue Auszeichnung in der Liste links unter der normalen Bearbeitungslaufbahn erscheinen.
Passen Sie den Namen und das Bild der neuen Laufbahn an, sodass Benutzer den Unterschied erkennen!

Sobald Sie die Anpassungen vorgenommen haben, haken Sie das {{int:achievements-enable-track}}-Kontrollkästchen an, um die neue Verknüpfung zu aktivieren, und klicken Sie dann auf „{{int:achievements-save}}“.
Sie können die Laufbahn später auch wieder deaktivieren, wenn Sie diese Kategorie nicht mehr hervorheben möchten.
Benutzer, die Auszeichnungen für diese Verknüpfung erhalten haben, werden ihre Auszeichnungen immer behalten, auch, wenn die Verknüpfung wieder deaktiviert wurde.

Dies kann helfen, eine weitere Ebene an Spaß zu den Auszeichnungen hinzuzufügen.
Versuchen Sie es!',
	'achievements-community-platinum-awarded-email-subject' => 'Sie haben ein neues Platin-Abzeichen erhalten.',
	'achievements-community-platinum-awarded-email-body-text' => "Herzlichen Glückwunsch, $1,

Sie sind gerade mit dem Platin-Abzeichen '$2' auf $4 ($3) versehen worden.
Dafür erhalten Sie 250 Punkte auf Ihr Konto.

Sie können das neue Abzeichen auf ihrer Benutzerseite einsehen:

$5",
	'achievements-community-platinum-awarded-email-body-html' => 'Herzlichen Glückwunsch, $1,<br /><br />
Sie sind gerade mit dem Platin-Abzeichen \'$2\' auf <a href="$3">$4</a> versehen worden.
Dafür erhalten Sie 250 Punkte auf Ihr Konto.<br /><br />
Sie können das neue Abzeichen auf <a href="$5">ihrer Benutzerseite</a> einsehen.',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|Link teilen|{{PLURAL:$1|eine Person|$1 Personen}} klicken auf den von Ihnen geteilten Link}}',
	'achievements-badge-to-get-sharing-details' => 'Teilen Sie Links, die von Anderen angeklickt werden!',
	'achievements-badge-to-get-edit-details' => 'Fehlt etwas?
Ist da ein Fehler?
Keine Angst.
Klicken Sie auf den „{{int:edit}}“-Button und Sie können zu jeder Seite beitragen!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Die <strong>$1</strong> Seiten brauchen Ihre Hilfe!
Klicken Sie auf den „{{int:edit}}“-Button auf einer beliebigen Seite in dieser Kategorie, um zu helfen.
Zeigen Sie Ihre Unterstützung für die $1 Seiten!',
	'achievements-badge-to-get-picture-details' => 'Klicken Sie auf den „{{int:edit}}“-Button und dann den „{{int:rte-ck-image-add}}“-Button.
Sie können ein Foto von Ihrem Computer oder von einer anderen Seite im Wiki hinzufügen.',
	'achievements-badge-to-get-category-details' => 'Kategorien sind Schlagworte, die Lesern helfen ähnliche Seiten zu finden.
Klicken Sie auf den „{{int:categoryselect-addcategory-button}}“-Button am unteren Rand einer Seite um sie in eine Kategorie einzuordnen.',
	'achievements-badge-to-get-blogpost-details' => 'Schreiben Sie Ihre Meinung und Fragen!
Klicken Sie auf „{{int:blogs-recent-url-text}}“ in der Sidebar und danach den Link „{{int:create-blog-post-title}}“ auf der linken Seite!',
	'achievements-badge-to-get-blogcomment-details' => 'Machen Sie ihre Meinung laut!
Lesen Sie einen der aktuellen Blog-Posts und schreiben Sie Ihre Meinung in das Kommentarfeld!',
	'achievements-badge-to-get-love-details' => 'Der Zähler geht auf null zurück, wenn Sie einen Tag auslassen. Sie sollten also jeden Tag das Wiki aufsuchen.',
	'achievements-badge-to-get-welcome-details' => 'Klicken Sie auf den „{{int:oasis-signup}}“-Button oben rechts, um der Gemeinschaft beizutreten.
Sie können sich dann sofort eigene Auszeichnungen verdienen.',
	'achievements-badge-to-get-introduction-details' => 'Ist Ihre Benutzerseite leer?
Klicken Sie auf Ihren Benutzernamen oben rechts, um nachzusehen!
Klicken Sie auf „{{int:edit}}“, um ein paar Informationen zu Ihrer Person einzugeben!',
	'achievements-badge-to-get-sayhi-details' => 'Sie können anderen Benutzern Nachrichten hinterlassen, indem Sie auf „{{int:addsection}}“ auf ihrer Diskussionsseite klicken.
Fragen Sie sie um Hilfe, danken Sie ihnen für ihre Arbeit oder sagen Sie einfach mal Hallo!',
	'achievements-badge-to-get-creator-details' => 'Die Auszeichnung geht an die Person, die das Wiki gegründet hat.
Klicken Sie auf den „{{int:createwiki}}“-Button oben, um Ihr eigenes Wiki zu einem beliebigen Thema zu erstellen!',
	'achievements-badge-to-get-pounce-details' => 'Sie müssen schnell sein, um diese Auszeichnung zu erhalten.
Klicken Sie auf den „{{int:activityfeed}}“-Button, um die neuen Seiten zu sehen, die andere Benutzer erstellen!',
	'achievements-badge-to-get-caffeinated-details' => 'Diese Auszeichnung benötigt einen Tag volles Engagement.
Geben Sie nicht nach!',
	'achievements-userprofile-no-badges-owner' => 'Erreichbare Auszeichnungen können Sie untenstehender Liste entnehmen.',
);

$messages['diq'] = array(
	'achievements-platinum' => 'Platinyum',
	'achievements-gold' => 'Altun',
	'achievements-bronze' => 'Bronz',
	'achievements-gold-points' => '100<br /> puan',
	'achievements-silver-points' => '50<br /> puan',
	'achievements-bronze-points' => '10<br />puan',
	'achievements-masthead-points' => '<small>{{PLURAL:$1|puanê|puanê}}</small> $1',
	'achievements-track-name-sharing' => 'vatısi vıla qı',
	'achievements-viewall' => 'Pêron bıvin',
	'achievements-viewless' => 'Racnê',
	'achievements-viewall-oasis' => 'hemi bıvinı',
	'leaderboard-intro-hide' => 'bınımne',
	'leaderboard-intro-open' => 'ake',
	'achievements-leaderboard-rank-label' => 'Rate',
	'achievements-leaderboard-member-label' => 'Eza',
	'achievements-leaderboard-points-label' => 'Puan',
	'achievements-leaderboard-points' => '{{PLURAL:$1|puan|puani}}',
	'achievements-enable-track' => 'mekefilne',
	'platinum' => 'Platinyum',
	'achievements-community-platinum-enabled' => 'mekefilne',
	'achievements-community-platinum-edit' => 'bıvurne',
	'achievements-community-platinum-save' => 'Star ke',
	'achievements-community-platinum-cancel' => 'Bıterkne',
	'achievements-badge-name-picture-1' => 'Paparazi',
	'achievements-badge-name-picture-6' => 'Vıraştkar',
	'achievements-badge-name-category-2' => 'Keşıfkar',
	'achievements-badge-name-sharing-0' => 'Vılakar',
	'achievements-badge-name-sharing-2' => 'Qısekar',
	'achievements-badge-name-sharing-4' => 'Ewangelis',
	'achievements-userprofile-profile-score' => '<em>$1</em>Puanê<br />qezenci',
);

$messages['el'] = array(
	'achievementsii-desc' => 'Ένα σύστημα επιτεύξεων με κονκάρδες για τους χρήστες wiki',
	'achievements-upload-error' => 'Συγγνώμη! N! Η εικόνα δεν λειτουργεί.!Βεβαιωθείτε ότι είναι. Jpg ή. Png αρχείο.! Αν εξακολουθεί να μην λειτουργεί, τότε η εικόνα μπορεί να είναι πολύ μεγάλη.! Παρακαλώ δοκιμάστε μια άλλη!',
	'achievements-non-existing-category' => 'Η συγκεκριμένη κατηγορία δεν υπάρχει.',
	'right-platinum' => 'Δημιουργία και επεξεργασία κονκάρδων Platinum',
	'achievements-platinum' => 'Πλατινένιο',
	'achievements-gold' => 'Χρυσό',
	'achievements-silver' => 'Αργυρό',
	'achievements-bronze' => 'Χάλκινο',
	'achievements-gold-points' => '100<br />πόντοι',
	'achievements-silver-points' => '50<br />πόντοι',
	'achievements-bronze-points' => '10<br />πόντοι',
	'achievements-you-must' => 'Χρειάζεσαι  $1  για να κερδίσεις αυτή την κονκάρδα.',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|point|πόντοι}}</small>',
	'achievements-track-name-edit' => 'Επεξεργασία γραμμής',
	'achievements-track-name-picture' => 'Σειρά εικόνων',
	'achievements-track-name-category' => 'Δέντρο κατηγορίας',
	'achievements-track-name-blogcomment' => 'Ακολουθία Σχολίων του Blog',
	'achievements-notification-title' => 'Δρόμος για να πας, $1!',
	'achievements-notification-subtitle' => 'Μόλις κερδίσες το "$1" κονκάρδα$2',
	'achievements-notification-link' => '<big><strong>[[Special: MyPage | Δείτε περισσότερες κονκάρδες που μπορείτε να κερδίσετε]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1| σημείο | σημεία}}',
	'achievements-earned' => 'Αυτή η κονκάρδα έχει κερδηθεί  από {{PLURAL:$1| 1 user| $1 users}}.',
	'achievements-profile-title-challenges' => 'Περισσότερες κονκάρδες που μπορείτε να κερδίσετε!',
	'achievements-profile-customize' => 'Προσαρμογή κονκάρδων',
	'achievements-ranked' => 'Βαθμολογημένος #$1 σε αυτό το βίκι',
	'achievements-viewall' => 'Προβολή όλων:',
	'achievements-viewless' => 'Κλείσιμο',
	'achievements-profile-title-oasis' => 'επίτευξη<br />πόντων',
	'achievements-viewall-oasis' => 'Προβολή όλων',
	'leaderboard-intro-hide' => 'Απόκρυψη',
	'leaderboard-intro-open' => 'Ανοίξτε',
	'leaderboard-intro-headline' => 'Τι είναι τα Επιτεύγματα;',
	'achievements-title' => 'Επιτεύγματα',
	'achievements-recent-earned-badges' => 'Πρόσφατες Κερδισμένες Κονκάρδες',
	'achievements-leaderboard-rank-label' => 'Βαθμός',
	'achievements-leaderboard-member-label' => 'Μέλος',
	'achievements-leaderboard-points-label' => 'Πόντοι',
	'achievements-leaderboard-points' => '$1 {{PLURAL:$1|πόντος|πόντοι}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Πιο πρόσφατα κερδισμένα',
	'achievements-send' => 'Αποθήκευση εικόνας',
	'achievements-save' => 'Αποθήκευση αλλαγών',
	'achievements-reverted' => 'Η κονκάρδα  επανήλθε στο αρχικό της.',
	'achievements-customize' => 'Προσαρμογή εικόνας',
	'achievements-customize-new-category-track' => 'Δημιουργία νέου ίχνους για κατηγορία:',
	'achievements-enable-track' => 'ενεργοποιημένο',
	'achievements-revert' => 'Επαναφορά στην προεπιλογή',
	'achievements-special-saved' => 'Οι αλλαγές αποθηκεύτηκαν.',
	'achievements-special' => 'Ειδικά επιτεύγματα',
	'achievements-secret' => 'Μυστικά επιτεύγματα',
	'achievementscustomize' => 'Προσαρμογή κονκάρδων',
	'achievements-about-title' => 'Σχετικά με αυτή τη σελίδα ...',
	'achievements-edit-plus-category-track-name' => '$1Επεξεργασία ακολουθίας',
	'achievements-create-edit-plus-category-title' => 'Δημιουργήστε μια νέα ακολουθία επεξεργασιών',
	'achievements-create-edit-plus-category' => 'Δημιουργήστε αυτή τη γραμμή',
	'platinum' => 'Πλατίνα',
	'achievements-community-platinum-awarded-email-subject' => 'Σας  έχει απονεμηθεί ένα νέο σήμα Πλατίνας!',
	'achievements-community-platinum-badge-image' => 'Εικόνα του παράσημου:',
	'achievements-community-platinum-enabled' => 'ενεργοποιημένο',
	'achievements-community-platinum-edit' => 'επεξεργασία',
	'achievements-community-platinum-save' => 'αποθήκευση',
	'achievements-community-platinum-cancel' => 'Άκυρο',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Κάντε κλικ για περισσότερες πληροφορίες',
	'achievements-badge-name-edit-0' => 'Κάνοντας τη Διαφορά',
	'achievements-badge-name-edit-1' => 'Μόνο η Αρχή',
	'achievements-badge-name-edit-2' => 'Αφήνοντας την Στάμπα σας',
	'achievements-badge-name-edit-3' => 'Φίλος του Βίκι',
	'achievements-badge-name-edit-4' => 'Συνεργάτης',
	'achievements-badge-name-edit-7' => 'Wiki Εμπειρογνωμόνων',
	'achievements-badge-name-picture-0' => 'Στιγμιότυπο',
	'achievements-badge-name-picture-1' => 'Παπαράτσι',
	'achievements-badge-name-picture-2' => 'Εικονογράφος',
	'achievements-badge-name-picture-3' => 'Συλλέκτης',
	'achievements-badge-name-picture-4' => 'Εραστής της Τέχνης',
	'achievements-badge-name-picture-5' => 'Διακοσμητής',
	'achievements-badge-name-picture-6' => 'Σχεδιαστής',
	'achievements-badge-name-picture-7' => 'Έφορος',
	'achievements-badge-name-category-0' => 'Πραγματοποίηση Σύνδεσης',
	'achievements-badge-name-category-2' => 'Εξερευνητής',
	'achievements-badge-name-category-3' => 'Ξεναγός',
	'achievements-badge-name-category-4' => 'Πλοηγός',
	'achievements-badge-name-love-3' => 'Αφιερωμένο',
	'achievements-badge-name-love-4' => 'Εθισμένος',
	'achievements-badge-name-love-6' => 'Βικιήρωας!',
	'achievements-badge-name-sharing-2' => 'Ομιλητής',
	'achievements-badge-name-sharing-4' => 'Ευαγγελιστής',
	'achievements-badge-name-welcome' => 'Καλώς ήρθατε στο Βίκι',
	'achievements-badge-name-introduction' => 'Εισαγωγή',
	'achievements-badge-name-creator' => 'O δημιουργός',
	'achievements-badge-desc-welcome' => 'για τη συμμετοχή στο wiki!',
	'achievements-badge-desc-creator' => 'για τη δημιουργία του wiki!',
);

$messages['eo'] = array(
	'achievements-upload-error' => 'Tiu dosiero ne funkcias.
Certiĝu, ke ĝi estas formatp .jpg aŭ .png.
Se ĝi senĉese ne funkcios, la dosiero povas esti tro granda.
Provu kun la alia!',
	'achievements-badge-name-edit-5' => 'Viki Konstruanto',
	'achievements-badge-name-welcome' => 'Bonvenon al la Vikio',
);

$messages['es'] = array(
	'achievementsii-desc' => 'Un sistema de logros para los usuarios del wiki',
	'achievements-upload-error' => '¡Lo sentimos!
Esa imagen no funciona.
Asegúrate de que es un archivo .jpg o .png.
Si continúa sin funcionar, debe ser porque la imagen es demasiado grande.
Por favor, inténtalo con otra imagen.',
	'achievements-upload-not-allowed' => 'Los administradores pueden cambiar los nombres e imágenes de las Insignias visitando la página de [[{{#Special:AchievementsCustomize}}|de personalización de insignias]].',
	'achievements-non-existing-category' => 'La categoría especificada no existe.',
	'achievements-edit-plus-category-track-exists' => 'La categoría especificada ya tiene una <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Ir al logro">insignia asociada</a>.',
	'achievements-no-stub-category' => 'Por favor, no crees grupos de insignias para bocetos.',
	'right-platinum' => 'Crear y editar insignias de Platino',
	'right-sponsored-achievements' => 'Administrar insignias patrocinadas',
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Oro',
	'achievements-silver' => 'Plata',
	'achievements-bronze' => 'Bronce',
	'achievements-gold-points' => '100<br />pts',
	'achievements-silver-points' => '50<br />pts',
	'achievements-bronze-points' => '10<br />pts',
	'achievements-you-must' => 'Necesitas $1 para conseguir esta insignia.',
	'leaderboard-button' => 'Tabla de líderes',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punto|puntos}}</small>',
	'achievements-profile-title-no' => '$1 {{PLURAL:$2|insignia|insignias}}',
	'achievements-no-badges' => '¡Echa un vistazo a la lista de debajo para ver las insignias que puedes conseguir en este wiki!',
	'achievements-track-name-edit' => 'Seguimiento a Ediciones',
	'achievements-track-name-picture' => 'Seguimiento a Imágenes',
	'achievements-track-name-category' => 'Seguimiento a Categorías',
	'achievements-track-name-blogpost' => 'Seguimiento a Entradas de blog',
	'achievements-track-name-blogcomment' => 'Seguimiento a Comentarios de blog',
	'achievements-track-name-love' => 'Seguimiento a "Amor por el wiki"',
	'achievements-track-name-sharing' => 'Seguimiento a Compartir',
	'achievements-notification-title' => '¡Así se hace, $1!',
	'achievements-notification-subtitle' => 'Acabas de conseguir la insignia "$1", $2',
	'achievements-notification-link' => '<strong><big>¡[[{{#Special:MyPage}}|Haz clic aquí para ver más insignias que puedes conseguir]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punto|puntos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punto|puntos}}',
	'achievements-earned' => 'Esta insignia ha sido conseguida por <br />{{PLURAL:$1|1 usuario|$1 usuarios}}.',
	'achievements-profile-title' => '$1 consiguió $2 {{PLURAL:$2|insignia|insignias}}',
	'achievements-profile-title-challenges' => '¡Más insignias que puedes conseguir!',
	'achievements-profile-customize' => 'Personalizar insignias',
	'achievements-ranked' => 'Puesto #$1 en este wiki',
	'achievements-viewall' => 'Ver todos',
	'achievements-viewless' => 'Cerrar',
	'achievements-profile-title-oasis' => 'logro <br /> puntos',
	'achievements-ranked-oasis' => '$1 está [[{{#Special:Leaderboard}}|en el puesto #$2]] en este wiki',
	'achievements-viewall-oasis' => 'Ver todos',
	'achievements-toggle-hide' => 'Ocultar mis logros en mi perfil para todo el mundo',
	'leaderboard-intro-hide' => 'ocultar',
	'leaderboard-intro-open' => 'abrir',
	'leaderboard-intro-headline' => '¿Qué son los logros?',
	'leaderboard-intro' => "Puedes ganar insignias al participar (haciendo ediciones, subiendo imágenes) en este wiki. Cada insignia te gana puntos, los cuales pueden llevarte más arriba en la clasificación. Podrás encontrar las insignias que has ganado en tu [[$1|página de usuario]].

'''¿Cuánto valen las insignias?'''",
	'leaderboard' => 'Tabla de líderes',
	'achievements-title' => 'Logros',
	'leaderboard-title' => 'Tabla de líderes',
	'achievements-recent-earned-badges' => 'Insignias conseguidas recientemente',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />conseguido por <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => ' Ganó la <strong><a href="$3" class="badgeName">$1</a></strong> insignia<br />$2',
	'achievements-leaderboard-disclaimer' => 'La tabla de líderes muestra los cambios desde ayer',
	'achievements-leaderboard-rank-label' => 'Clasificación',
	'achievements-leaderboard-member-label' => 'Miembro',
	'achievements-leaderboard-points-label' => 'Puntos',
	'achievements-leaderboard-points' => '{{PLURAL:$1|punto|puntos}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Recientemente ganado',
	'achievements-send' => 'Guardar imagen',
	'achievements-save' => 'Guardar cambios',
	'achievements-reverted' => 'Insignia revertida a su original.',
	'achievements-customize' => 'Personalizar imagen',
	'achievements-customize-new-category-track' => 'Crear nuevo grupo de logros por categoría:',
	'achievements-enable-track' => 'activado',
	'achievements-revert' => 'Revertir al que está por defecto',
	'achievements-special-saved' => 'Cambios guardados.',
	'achievements-special' => 'Logros especiales',
	'achievements-secret' => 'Logros secretos',
	'achievementscustomize' => 'Personalizar insignias',
	'achievements-about-title' => 'Acerca de esta página...',
	'achievements-about-content' => 'Los administradores de este wiki pueden personalizar los nombres y las imágenes de las insignias.

Puedes subir cualquier imagen .jpg o .png, y tu imagen se pondrá automáticamente en el interior del marco.
Funciona mejor con las imágenes que son cuadradas, y cuando la parte más importante de la imagen está situada en medio.

Puedes usar imágenes rectangulares, pero pero podrías encontrarte con que se coloca mal en el marco.
Si tienes un programa gráfico, puedes arreglar la imagen para poner la parte más importante de la misma en el centro.
¡Si no tienes un programa gráfico, puedes probar con diferentes imágenes hasta que encuentres la que funcione mejor!
Si no has elegido aún la imagen para poner, haz clic en "{{int:achievements-revert}}" para volver a la imagen original.

También puedes dar nuevos nombres a las insignias para que estén relacionados con el tema de la wikia.
Cuando hayas cambiado el nombre de las insignias, haz clic en "{{int:achievements-save}}" para guardar los cambios.
¡Diviértete!',
	'achievements-edit-plus-category-track-name' => '$1 insignia de edición',
	'achievements-create-edit-plus-category-title' => 'Crear una nueva insignia de Edición',
	'achievements-create-edit-plus-category-content' => 'Puedes crear una nueva configuración de insignias que premie a los usuarios por editar páginas de una determinada categoría, para impulsar una determinada área del sitio consiguiendo que los usuarios disfruten trabajando en ella.
¡Puedes configurar tantas insignias como desees por categoría, aunque intenta elegir dos categorías al menos para ayudar a los usuarios a demostrar su especialidad!
Enciende la rivalidad entre los usuarios que editen páginas sobre Vampiros y los que editen páginas sobre Hombres Lobo, o los Magos y Muggles, o Autobots y Decepticons.

Para crear un nuevo logro de "Editar en la categoría", escribe el nombre de la categoría en el campo de debajo.
El logro normal de "Editar" continuará existiendo;
este se creará en una insignia separada que podrás personalizar de forma independiente.

Cuando la insignia esté creada, la nueva insignia aparecerá en la lista de la izquierda, debajo de la insignia normal de "Editar".
Personaliza los nombres y las imágenes de la nueva insignia, ¡así los usuarios podrán ver las diferencias!

Una vez tengas hecha la personalización, haz clic en la casilla de verificación "{{int:achievements-enable-track}}" para volver a la nueva insignia, y después haz clic en "{{int:achievements-save}}".
Los usuarios podrán ver la apariencia de la nueva insignia en sus perfiles de usuario, y podrán comenzar a conseguir las insignias cuando editen páginas de esa categoría.
También puedes desactivar la insignia posteriormente, si decides que no se debe impulsar esa categoría por más tiempo.
Los usuarios que haya conseguido la insignia lo mantendrán, incluso si se desactiva.

Todo esto te puede ayudar a dar un pequeño impulso a la diversión que se puede conseguir con las insignias.
¡Inténtalo!',
	'achievements-create-edit-plus-category' => 'Crear este grupo',
	'platinum' => 'Platino',
	'achievements-community-platinum-awarded-email-subject' => '¡Has conseguido una nueva insignia de Platino!',
	'achievements-community-platinum-awarded-email-body-text' => "¡Felicidades $1!

Has conseguido la insignia de Platino '$2' en $4 ($3). ¡Con esta insignia has conseguido 250 puntos para tu puntuación total!

Echa un vistazo a esta insignia de lujo en tu perfil de usuario:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>¡Felicidades $1!</strong><br /><br />
Has conseguido la insignia de Platino \'<strong>$2</strong>\' en <a href="$3">$4</a>. ¡Con esta insignia has conseguido 250 puntos para tu puntuación total!<br /><br />
Echa un vistazo a esta insignia de lujo en tu <a href="$5">perfil de usuario</a>.',
	'achievements-community-platinum-awarded-for' => 'Premiado por:',
	'achievements-community-platinum-how-to-earn' => 'Cómo conseguirlo:',
	'achievements-community-platinum-awarded-for-example' => 'ej. "Por hacer..."',
	'achievements-community-platinum-how-to-earn-example' => 'ej. "hacer tres ediciones..."',
	'achievements-community-platinum-badge-image' => 'Imagen de la insignia:',
	'achievements-community-platinum-awarded-to' => 'Premiado por:',
	'achievements-community-platinum-current-badges' => 'Insignias de platino actuales',
	'achievements-community-platinum-create-badge' => 'Crear insignia',
	'achievements-community-platinum-enabled' => 'activado',
	'achievements-community-platinum-show-recents' => 'mostrar en insignias recientes',
	'achievements-community-platinum-edit' => 'editar',
	'achievements-community-platinum-save' => 'guardar',
	'achievements-community-platinum-cancel' => 'cancelar',
	'achievements-community-platinum-sponsored-label' => 'Insignia Patrocinada',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Imagen resaltable <small>(tamaño mínimo de la imagen: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'URL de seguimiento para las impresiones de la insignia:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'URL de seguimiento para las impresiones de la imagen resaltable:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Enlace de insignias <small>(haz clic en la URL de comando)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Haz clic para más información',
	'achievements-badge-name-edit-0' => 'Marcando la Diferencia',
	'achievements-badge-name-edit-1' => 'Sólo el Principio',
	'achievements-badge-name-edit-2' => 'Dejando Tu Marca',
	'achievements-badge-name-edit-3' => 'Amigo del wiki',
	'achievements-badge-name-edit-4' => 'Colaborador',
	'achievements-badge-name-edit-5' => 'Constructor del wiki',
	'achievements-badge-name-edit-6' => 'Líder del wiki',
	'achievements-badge-name-edit-7' => 'Experto del wiki',
	'achievements-badge-name-picture-0' => 'Instantánea',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Ilustrador',
	'achievements-badge-name-picture-3' => 'Coleccionista',
	'achievements-badge-name-picture-4' => 'Amante del arte',
	'achievements-badge-name-picture-5' => 'Decorador',
	'achievements-badge-name-picture-6' => 'Diseñador',
	'achievements-badge-name-picture-7' => 'Curador',
	'achievements-badge-name-category-0' => 'Crea una Conexión',
	'achievements-badge-name-category-1' => 'Pionero',
	'achievements-badge-name-category-2' => 'Explorador',
	'achievements-badge-name-category-3' => 'Guía Turístico',
	'achievements-badge-name-category-4' => 'Navegante',
	'achievements-badge-name-category-5' => 'Constructor de Puentes',
	'achievements-badge-name-category-6' => 'Planificador Wiki',
	'achievements-badge-name-blogpost-0' => 'Algo que decir',
	'achievements-badge-name-blogpost-1' => 'Cinco cosas que decir',
	'achievements-badge-name-blogpost-2' => 'Amante de la Conversación',
	'achievements-badge-name-blogpost-3' => 'Alma de la fiesta',
	'achievements-badge-name-blogpost-4' => 'Relaciones Públicas',
	'achievements-badge-name-blogcomment-0' => 'Comentarista',
	'achievements-badge-name-blogcomment-1' => 'Y una cosa más',
	'achievements-badge-name-love-0' => '¡Esencial para el wiki!',
	'achievements-badge-name-love-1' => 'Dos semanas en el wiki',
	'achievements-badge-name-love-2' => 'Devoto',
	'achievements-badge-name-love-3' => 'Dedicado',
	'achievements-badge-name-love-4' => 'Adicto',
	'achievements-badge-name-love-5' => 'Una vida wiki',
	'achievements-badge-name-love-6' => '¡Héroe del wiki!',
	'achievements-badge-name-sharing-0' => 'Compartir',
	'achievements-badge-name-sharing-1' => 'Regresar',
	'achievements-badge-name-sharing-2' => 'Hablante',
	'achievements-badge-name-sharing-3' => 'Anunciante',
	'achievements-badge-name-sharing-4' => 'Evangelista',
	'achievements-badge-name-welcome' => 'Bienvenido al wiki',
	'achievements-badge-name-introduction' => 'Introducción',
	'achievements-badge-name-sayhi' => 'Deteniendo para decir hola',
	'achievements-badge-name-creator' => 'El Creador',
	'achievements-badge-name-pounce' => '¡Salta!',
	'achievements-badge-name-caffeinated' => 'Con cafeína',
	'achievements-badge-name-luckyedit' => 'Edición afortunada',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|compartir enlace| {{PLURAL:$1|una persona hizo|$1 personas hicieron}} clic en el enlace que compartiste}}',
	'achievements-badge-to-get-edit' => 'hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una página|páginas}}',
	'achievements-badge-to-get-edit-plus-category' => 'hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una|}} $2 {{PLURAL:$1|una página|páginas}}',
	'achievements-badge-to-get-picture' => 'agregar $1 {{PLURAL:$1|imagen|imágenes}} a {{PLURAL:$1|una página|páginas}}',
	'achievements-badge-to-get-category' => 'agregar $1 {{PLURAL:$1|página|páginas}} a {{PLURAL:$1|una categoría|categorías}}',
	'achievements-badge-to-get-blogpost' => 'escribir $1 {{PLURAL:$1|mensaje de blog|mensajes de blog}}',
	'achievements-badge-to-get-blogcomment' => 'escribir un comentario en {{PLURAL:$1|una entrada de blog|$1 entradas de blog diferentes}}',
	'achievements-badge-to-get-love' => 'contribuir en el wiki {{PLURAL:$1|durante todo un día|cada día durante $1 días}}',
	'achievements-badge-to-get-welcome' => 'unirse al wiki',
	'achievements-badge-to-get-introduction' => 'agregar tu propia página de usuario',
	'achievements-badge-to-get-sayhi' => 'dejar a alguien un mensaje en su página de discusión',
	'achievements-badge-to-get-creator' => 'ser el creador de este wiki',
	'achievements-badge-to-get-pounce' => 'ser rápido',
	'achievements-badge-to-get-caffeinated' => 'hacer {{PLURAL:$1|una edición|$1 ediciones}} en el wiki en un solo día',
	'achievements-badge-to-get-luckyedit' => 'tener suerte',
	'achievements-badge-to-get-sharing-details' => '¡Comparte enlaces y consigue que otros hagan clic a ellos!',
	'achievements-badge-to-get-edit-details' => '¿Falta algo? ¿Hay algún error? No seas tímido. <br />¡Haz clic en el botón editar y<br />podrás añadir cualquier página!',
	'achievements-badge-to-get-edit-plus-category-details' => '¡Las <strong>$1</strong> páginas necesitan tu ayuda! Haz clic en el botón "{{int:edit}}" de cualquier página en esta categoría para ayudar. ¡Demuestra tu apoyo a las $1 páginas!',
	'achievements-badge-to-get-picture-details' => 'Haz clic en el botón de editar, y después en el botón de imagen. Puedes añadir una imagen desde tu ordenador, o desde otra página del wiki.',
	'achievements-badge-to-get-category-details' => 'Las categorías son etiquetas que ayudan a los lectores a encontrar páginas similares. Haz clic en el botón de "{{int:categoryselect-addcategory-button}}" para añadir la página a una categoría.',
	'achievements-badge-to-get-blogpost-details' => '¡Escribe tu opinión y tus preguntas! Haz clic en "{{int:blogs-recent-url-text}}" en el panel lateral, y después en el enlace de la izquierda para "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => '¡Añade tu granito de arena! Lee cualquiera de las entradas de blog, y escribe tus propias opiniones en los comentarios.',
	'achievements-badge-to-get-love-details' => '¡El contador se reinicia si dejas de editar durante un día, asegúrate de volver<br />al wiki cada día!',
	'achievements-badge-to-get-welcome-details' => 'Haz clic en el botón "{{int:oasis-signup}}" arriba a la derecha para participar en la comunidad. ¡Así podrás comenzar a ganar tus propias insignias!',
	'achievements-badge-to-get-introduction-details' => '¿Tu página de usuario está vacía? Haz clic en tu nombre de usuario al comienzo de la pantalla para verla. ¡Haz clic en "{{int:edit}}" para añadir algo de información sobre ti!',
	'achievements-badge-to-get-sayhi-details' => 'Puedes dejar mensajes a otros usuarios haciendo clic en "{{int:addsection}}" en su página de discusión. Pide ayuda, agradece su trabajo o simplemente dile ¡hola!',
	'achievements-badge-to-get-creator-details' => 'Este logro se otorga a la persona que fundó el wiki. ¡Haz clic en el botón "{{int:createwiki}}" arriba, para comenzar tu propio sitio sobre el tema que más te guste!',
	'achievements-badge-to-get-pounce-details' => 'Tienes que ser rápido para conseguir esta insignia. ¡Haz clic en el botón de "{{int:activityfeed}}" para ver las nuevas páginas que los usuarios están creando!',
	'achievements-badge-to-get-caffeinated-details' => 'Necesitarás todo un día para conseguir esta insignia.
¡No dejes de editar!',
	'achievements-badge-to-get-luckyedit-details' => 'La insignia de edición afortunada se da a la persona que realizó la edición 1.000 en el wiki y cada 1.000 después de eso. Para obtener esta insignia, contribuye mucho en el wiki <br />; espero que tengas suerte!',
	'achievements-badge-to-get-community-platinum-details' => '¡Esta es una insignia especial de platino que solamente estará disponible por un tiempo limitado!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|por compartir un enlace|por conseguir que {{PLURAL:$1|una persona|$1 personas}} {{PLURAL:$1|haga|hagan}} clic en los enlaces compartidos}}',
	'achievements-badge-hover-desc-edit' => 'Premiado por hacer $1 {{PLURAL:$1|edición|ediciones}}<br />
en {{PLURAL:$1|una página|diversas páginas}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Premiado por hacer $1 {{PLURAL:$1|edición|ediciones}}<br />
en {{PLURAL:$1|una página|diversas páginas}} de $2!',
	'achievements-badge-hover-desc-picture' => 'Premiado por agregar $1 {{PLURAL:$1|imagen|imágenes}}<br />
en {{PLURAL:$1|una página|varias páginas}}!',
	'achievements-badge-hover-desc-category' => 'Premiado por agregar $1 {{PLURAL:$1|página|páginas}}<br />
a {{PLURAL:$1|una categoría|varias categorías}}!',
	'achievements-badge-hover-desc-blogpost' => 'Premiado por escribir $1 {{PLURAL:$1|entrada de blog|entradas de blog}}!',
	'achievements-badge-hover-desc-blogcomment' => 'Premiado por escribir un comentario<br />
en $1 {{PLURAL:$1|entrada de blog|entradas de blog diferentes}}!',
	'achievements-badge-hover-desc-love' => '¡Premiado por contribuir en el wiki {{PLURAL:$1|durante un día|diariamente durante $1 días}}!',
	'achievements-badge-hover-desc-welcome' => '¡Premiado por unirte al wiki!',
	'achievements-badge-hover-desc-introduction' => '¡Premiado por agregar<br />
tu propia página de usuario!',
	'achievements-badge-hover-desc-sayhi' => '¡Premiado por dejar un mensaje<br />
en la página de discusión de alguien!',
	'achievements-badge-hover-desc-creator' => '¡Premiado por crear el wiki!',
	'achievements-badge-hover-desc-pounce' => '¡Premiado por editar en 100 páginas dentro de la primera hora de vida de las páginas!',
	'achievements-badge-hover-desc-caffeinated' => '¡Premiado por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-hover-desc-luckyedit' => '¡Premiado por hacer la edición afortunada $1ª en el wiki!',
	'achievements-badge-hover-desc-community-platinum' => '¡Esta es una insignia especial de platino que solamente estará disponible por un tiempo limitado!',
	'achievements-badge-your-desc-sharing' => '¡Premiado {{#ifeq:$1|0|por compartir un enlace|por conseguir que {{PLURAL:$1|una persona|$1 personas}} {{PLURAL:$1|haga|hagan}} clic en los enlaces compartidos}}',
	'achievements-badge-your-desc-edit' => '¡Premiado por hacer {{PLURAL:$1|tu primera edición|$1 ediciones}} en {{PLURAL:$1|una página|varias páginas}}!',
	'achievements-badge-your-desc-edit-plus-category' => '¡Premiado por hacer {{PLURAL:$1|tu primera edición|$1 ediciones}} en {{PLURAL:$2|una página|$2 páginas}}!',
	'achievements-badge-your-desc-picture' => '¡Premiado por añadir {{PLURAL:$1|tu primera página|$1 páginas}} a {{PLURAL:$1|una categoría|varias categorías}}!',
	'achievements-badge-your-desc-category' => '¡Premiado por añadir {{PLURAL:$1|tu primera página|$1 páginas}} a {{PLURAL:$1|una categoría|varias categorías}}!',
	'achievements-badge-your-desc-blogpost' => '¡Premiado por escribir {{PLURAL:$1|tu primera entrada de blog|$1 entradas de blog}}!',
	'achievements-badge-your-desc-blogcomment' => '¡Premiado por escribir un comentario en {{PLURAL:$1|una entrada de blog|$1 entradas de blog diferentes}}!',
	'achievements-badge-your-desc-love' => '¡Premiado por contribuir en el wiki {{PLURAL:$1|durante un día|diariamente durante $1 días}}!',
	'achievements-badge-your-desc-welcome' => '¡Premiado por unirte al wiki!',
	'achievements-badge-your-desc-introduction' => '¡Premiado por agregar tu propia página de usuario!',
	'achievements-badge-your-desc-sayhi' => '¡Premiado por dejar un mensaje en la página de discusión de alguien!',
	'achievements-badge-your-desc-creator' => '¡Premiado por crear el wiki!',
	'achievements-badge-your-desc-pounce' => '¡Premiado por editar en 100 páginas dentro de la primera hora de vida de las páginas!',
	'achievements-badge-your-desc-caffeinated' => '¡Premiado por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-your-desc-luckyedit' => '¡Premiado por hacer la edición afortunada $1ª en el wiki!',
	'achievements-badge-desc-sharing' => '¡Premiado {{#ifeq:$1|0|por compartir un enlace|por conseguir que {{PLURAL:$1|una persona|$1 personas}} {{PLURAL:$1|haga|hagan}} clic en los enlaces compartidos}}',
	'achievements-badge-desc-edit' => 'Premiado por hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una página|diversas páginas}} de $2!',
	'achievements-badge-desc-edit-plus-category' => 'Premiado por hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una página|diversas páginas}} de $2!',
	'achievements-badge-desc-picture' => 'Premiado por agregar $1 {{PLURAL:$1|imagen|imágenes}}<br />
en {{PLURAL:$1|una página|varias páginas}}!',
	'achievements-badge-desc-category' => 'Premiado por agregar $1 {{PLURAL:$1|página|páginas}}<br />
a {{PLURAL:$1|una categoría|varias categorías}}!',
	'achievements-badge-desc-blogpost' => 'Premiado por escribir $1 {{PLURAL:$1|entrada de blog|entradas de blog}}!',
	'achievements-badge-desc-blogcomment' => '¡Premiado por escribir un comentario en {{PLURAL:$1|una entrada de blog|$1 entradas de blog diferentes}}!',
	'achievements-badge-desc-love' => '¡Premiado por contribuir en el wiki {{PLURAL:$1|durante un día|diariamente durante $1 días}}!',
	'achievements-badge-desc-welcome' => '¡Premiado por unirte al wiki!',
	'achievements-badge-desc-introduction' => '¡Premiado por agregar tu propia página de usuario!',
	'achievements-badge-desc-sayhi' => '¡Premiado por dejar un mensaje en la página de discusión de alguien!',
	'achievements-badge-desc-creator' => '¡Premiado por crear el wiki!',
	'achievements-badge-desc-pounce' => '¡Premiado por editar en 100 páginas dentro de la primera hora de vida de las páginas!',
	'achievements-badge-desc-caffeinated' => '¡Premiado por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-desc-luckyedit' => '¡Premiado por hacer la edición afortunada $1ª en el wiki!',
	'achievements-userprofile-title-no' => '$1 insignias conseguidas',
	'achievements-userprofile-title' => '$1 ganó {{PLURAL:$2|insignia|insignias}} ($2)',
	'achievements-userprofile-no-badges-owner' => '¡Echa un vistazo a la lista de debajo para ver las insignias que puedes conseguir en este wiki!',
	'achievements-userprofile-no-badges-visitor' => 'Este usuario no ha ganado ninguna insignia todavía.',
	'achievements-userprofile-profile-score' => '<em>$1</em> Logros<br />puntos',
	'achievements-userprofile-ranked' => '[[{{#Special:Leaderboard}}|Clasificación $1]]<br />en este wiki',
	'action-platinum' => 'crear y editar insignias de Platino',
	'achievements-next-oasis' => 'Siguiente',
	'achievements-prev-oasis' => 'Anterior',
	'right-achievements-exempt' => 'El usuario es elegible para ganar puntos de logro',
	'right-achievements-explicit' => 'El usuario es elegible para ganar puntos de logro (reemplaza)',
);

$messages['et'] = array(
	'achievementsii-desc' => 'Saavutusembleemidesüsteem viki kasutajatele',
	'achievements-upload-error' => 'Vabandust!
Pilt ei tööta.
Kontrolli et see oleks .jpg või .png fail.
Kui pilt ikkagi ei tööta, siis võib see olla liiga suur.
Palun proovi mõnda teist pilti!',
	'achievements-upload-not-allowed' => 'Administraatorid saavad muuta saavutusembleemide pilte ja nimesid, kui nad külastavad [[Eri:SaavutusedMuuda|muuda saavutusi]] lehte.',
	'achievements-non-existing-category' => 'Etteantud kategooriat ei eksisteeri.',
	'achievements-edit-plus-category-track-exists' => 'Etteantud kategoorial on juba <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">seotud tee</a>.',
	'achievements-no-stub-category' => 'Palun ärge looge teid poolikuks jäänud lehtedele.',
	'right-platinum' => 'Loo ja muuda plaatina embleeme',
	'right-sponsored-achievements' => 'Muuda Sponsoreeritud saavutusi',
	'achievements-platinum' => 'Plaatina',
	'achievements-gold' => 'Kuld',
	'achievements-silver' => 'Hõbe',
	'achievements-bronze' => 'Pronks',
	'achievements-gold-points' => '100<br />punkti',
	'achievements-silver-points' => '50<br />punkti',
	'achievements-bronze-points' => '10<br />punkti',
	'achievements-you-must' => 'Peate tegema ära ülesande "$1" et saada see embleem.',
	'leaderboard-button' => 'Saavutuste Edetabel',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punkt|punkti}}</small>',
	'achievements-profile-title-no' => 'Kasutaja $1 embleemid',
	'achievements-no-badges' => 'Vaata allpool olevat nimekirja, et näha milliseid embleeme selles vikis võimalik saada on!',
	'achievements-track-name-edit' => 'Muutmiste tee',
	'achievements-track-name-picture' => 'Piltide tee',
	'achievements-track-name-category' => 'Kategooriate tee',
);

$messages['eu'] = array(
	'achievements-platinum' => 'Platinoa',
	'achievements-gold' => 'Urrea',
	'achievements-silver' => 'Zilarra',
	'achievements-bronze' => 'Brontzea',
	'achievements-gold-points' => '100<br />ptu',
	'achievements-silver-points' => '50<br />ptu',
	'achievements-bronze-points' => '10<br />ptu',
	'achievements-viewless' => 'Itxi',
	'achievements-viewall-oasis' => 'Denak ikusi',
	'leaderboard-intro-hide' => 'ezkutatu',
	'leaderboard-intro-open' => 'ireki',
	'achievements-leaderboard-rank-label' => 'Postua',
	'achievements-leaderboard-member-label' => 'Kideak',
	'achievements-leaderboard-points-label' => 'Puntuak',
	'achievements-enable-track' => 'gaitua',
	'achievements-about-title' => 'Orrialde honi buruz...',
	'platinum' => 'Platinoa',
	'achievements-community-platinum-how-to-earn' => 'Nola irabazi:',
	'achievements-community-platinum-enabled' => 'gaitua',
	'achievements-community-platinum-edit' => 'aldatu',
	'achievements-community-platinum-save' => 'gorde',
	'achievements-community-platinum-cancel' => 'utzi',
	'achievements-badge-name-edit-4' => 'Kolaboratzailea',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Marrazkilaria',
	'achievements-badge-name-picture-5' => 'Dekoratzailea',
	'achievements-badge-name-picture-6' => 'Diseinatzailea',
	'achievements-badge-name-category-2' => 'Esploratzailea',
	'achievements-badge-name-category-4' => 'Nabigatzailea',
	'achievements-badge-name-sharing-2' => 'Hizlaria',
	'achievements-badge-name-sharing-4' => 'Ebanjelaria',
	'achievements-badge-name-welcome' => 'Ongi etorri Wikira',
	'achievements-badge-name-introduction' => 'Sarrera',
	'achievements-badge-name-creator' => 'Sortzailea',
);

$messages['fa'] = array(
	'achievementsii-desc' => 'سامانه‌ای برای مدال‌های افتخار کاربران ویکی',
	'achievements-upload-error' => 'با پوزش!
این عکس کار نمی‌کند.
اطمینان حاصل کنید که پرونده با پسوند.پی‌ان‌جی یا .جی‌پی‌جی است.
لطفا یکی دیگر را امتحان کنید!',
	'achievements-upload-not-allowed' => 'مدیران می‌توانند نام‌ها و تصویرهای نشان‌های دستاوردها را با بازدید از صفحهٔ [[Special:AchievementsCustomize|دستاورد سفارشی]] تغییر دهند.',
	'achievements-non-existing-category' => 'رده مشخص‌شده وجود ندارد',
	'achievements-edit-plus-category-track-exists' => 'این ردهٔ مشخص هم‌اکنون دارای یک <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="به مسیر برو">مسیر وابسته</a> است.',
	'achievements-no-stub-category' => 'لطفاً برای نوشتارهای خرد، مسیر ایجاد نکنید.',
	'right-platinum' => 'ایجاد و ویرایش مدال‌های پلاتینیوم',
	'right-sponsored-achievements' => 'مدیریت دستاوردهای حمایت‌شده',
	'achievements-platinum' => 'پلاتینیوم',
	'achievements-gold' => 'زرین',
	'achievements-silver' => 'نقره',
	'achievements-bronze' => 'برنز',
	'achievements-gold-points' => '۱۰۰<br />امتیاز',
	'achievements-silver-points' => '۵۰<br />امتیاز',
	'achievements-bronze-points' => '۱۰<br />امتیاز',
	'achievements-you-must' => 'شما به $1 برای کسب این مدال نیاز دارید',
	'leaderboard-button' => 'تابلوی رهبری دستاوردها',
	'achievements-masthead-points' => '$1 <small>{{جمع:$1|امتیاز|امتیازها}}</small>',
	'achievements-profile-title-no' => 'نشان‌های $1',
	'achievements-no-badges' => 'فهرست زیر را برای دیدن نشان‌هایی که می‌توانید در این ویکی بدست آورید بررسی کنید!',
	'achievements-track-name-edit' => 'رد ویرایش',
	'achievements-track-name-picture' => 'رد تصاویر',
	'achievements-track-name-category' => 'رد رده‌ها',
	'achievements-track-name-blogpost' => 'رد پست وبلاگ',
	'achievements-track-name-blogcomment' => 'رد دیدگاه وبلاگ',
	'achievements-track-name-love' => 'رد عشق ویکی',
	'achievements-track-name-sharing' => 'اشتراک‌گذاری مسیر',
	'achievements-notification-title' => '$1، مبارک باشد!',
	'achievements-notification-subtitle' => 'شما نشان "$1" را $2 بدست آوردید',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|نشان‌های بیش‌تری را که می‌توانید بدست آورید ببینید]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|امتیاز|امتیاز}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|امتیاز|امتیاز}}',
	'achievements-earned' => 'این نشان توسط {{PLURAL:$1|۱ کاربر|$1 کاربر}} کسب شده است.',
	'achievements-profile-title' => '$2 {{PLURAL:$2|نشان|نشان}} بدست‌آمده توسط $1',
	'achievements-profile-title-challenges' => 'می‌توانید نشان‌های بیش‌تری کسب کنید!',
	'achievements-profile-customize' => 'سفارشی‌کردن نشان‌ها',
	'achievements-ranked' => 'رتبهٔ #$1 در این ویکی',
	'achievements-viewall' => 'نمایش همه',
	'achievements-viewless' => 'بستن',
	'achievements-profile-title-oasis' => 'دستاورد <br /> امتیاز',
	'achievements-ranked-oasis' => '$1 دارای [[Special:Leaderboard|رتبهٔ #$2]] در این ویکی است',
	'achievements-viewall-oasis' => 'مشاهدهٔ همه',
	'achievements-toggle-hide' => 'امتیازها، نشان‌ها و رتبه‌بندی را در صفحهٔ مشخصات من نشان نده',
	'leaderboard-intro-hide' => 'نهفتن',
	'leaderboard-intro-open' => 'گشودن',
	'leaderboard-intro-headline' => 'دستاوردها چه هستند؟',
	'leaderboard-intro' => "شما می‌توانید با ویرایش صفحات، بارگذاری عکس‌ها و نظردهی در این ویکی، نشان بدست آورید. هر نشان برایتان امتیاز کسب می‌کند - هرچه امتیازهای بیش‌تری کسب کنید، در تابلوی رهبری بالاتر خواهید رفت! شما می‌توانید نشان‌هایی را که بدست آورده‌اید در [[$1|صفحهٔ مشخصات کاربری]] بیابید.

'''ارزش مدال‌ها چیست؟'''",
	'leaderboard' => 'تابلوی رهبری دستاوردها',
	'achievements-title' => 'دستاوردها',
	'leaderboard-title' => 'تابلوی رهبری',
	'achievements-recent-earned-badges' => 'نشان‌های اخیراً بدست‌آمده',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br /> بدست‌آمده توسط <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'نشان <strong><a href="$3" class="badgeName">$1</a></strong> بدست آمد<br />$2',
	'achievements-leaderboard-disclaimer' => 'تابلوی رهبری تغییراتی را از دیروز نشان می‌دهد',
	'achievements-leaderboard-rank-label' => 'رتبه',
	'achievements-leaderboard-member-label' => 'عضو',
	'achievements-leaderboard-points-label' => 'امتیازها',
	'achievements-leaderboard-points' => '{{PLURAL:$1|امتیاز|امتیاز}}',
	'achievements-leaderboard-most-recently-earned-label' => 'اخیرا به دست آورده',
	'achievements-send' => 'ذخیره تصویر',
	'achievements-save' => 'ذخیره‌کردن تغییرات',
	'achievements-reverted' => 'نشان به اصلش واگردانده شد.',
	'achievements-customize' => 'سفارشی‌کردن عکس',
	'achievements-customize-new-category-track' => 'مسیر جدیدی برای رده ایجاد کن:',
	'achievements-enable-track' => 'فعال',
	'achievements-revert' => 'واگردانی به پیش‌فرض',
	'achievements-special-saved' => 'تغییرات ذخیره شد.',
	'achievements-special' => 'دستاوردهای ویژه',
	'achievements-secret' => 'دستاوردهای مخفی',
	'achievementscustomize' => 'سفارشی‌کردن نشان‌ها',
	'achievements-about-title' => 'درباره این صفحه...',
	'achievements-about-content' => 'مدیران می‌توانند در این ویکی نام‌ها و تصیرهای نشان‌های دستاورد را سفارشی کنند.

شما می‌تواند تصاویر .jpg یا .png را بارگذاری کنید، و تصویر شما به طور خودکار در درون قاب درج خواهد شد.
اگر تصویر مربعی باشد و مهم‌ترین بخش تصویر درست در وسط باشد، بهتر عمل خواهد کرد.

شما می‌توانید از تصاویر مستطیلی استفاده کنید، اما ممکن است ذره‌ای از آن توسط قاب بریده شود.
اگر برنامه‌ای گرافیکی دارید، پس می‌توانید عکس را جوری ببرید که بخش مهم تصویر در مرکز قرار بگیرد.
اگر برنامهٔ گرافیکی ندارید، پس فقط با تصاویر مختلف امتحان کنید تا به آنی که به کارتان می‌آید را پیدا کنید!
اگر تصویری که انتخاب کرده‌اید را دوست ندارید، بر «{{int:achievements-revert}}» کلیک کنید تا به تصویر اصلی بازگردید.

شما همچنین می‌توانید به نشان‌ها نام‌های جدیدی بدهید که عنوان ویکی را بازتاب دهد.
هنگامی که نام نشان‌ها را تغییر دادید، بر «{{int:achievements-save}}» کلیک کنید تا تغییراتتان را ذخیره کنید.
حالش را ببرید!',
	'achievements-edit-plus-category-track-name' => '$1 ویرایش مسیر',
	'achievements-create-edit-plus-category-title' => 'مسیر جدیدی ایجاد کنید',
	'achievements-create-edit-plus-category' => 'این مسیر را ایجاد کن',
	'platinum' => 'پلاتین',
	'achievements-community-platinum-awarded-email-subject' => 'یک نشان پلاتین جدید به شما اعطا شده است!',
	'achievements-community-platinum-awarded-for' => 'اهداشده برای:',
	'achievements-community-platinum-how-to-earn' => 'چگونه کسب شود:',
	'achievements-community-platinum-awarded-for-example' => 'مثال «برای انجام...»',
	'achievements-community-platinum-how-to-earn-example' => 'مثال «۳ ویرایش انجام بده...»',
	'achievements-community-platinum-badge-image' => 'تصویر نشان:',
	'achievements-community-platinum-awarded-to' => 'اهدا به:',
	'achievements-community-platinum-current-badges' => 'نشان‌های پلاتینی کنونی',
	'achievements-community-platinum-create-badge' => 'ایجاد نشان',
	'achievements-community-platinum-enabled' => 'فعال‌شده',
	'achievements-community-platinum-show-recents' => 'نمایش در نشان‌های اخیر',
	'achievements-community-platinum-edit' => 'ویرایش',
	'achievements-community-platinum-save' => 'ذخیره',
	'achievements-community-platinum-cancel' => 'انصراف',
	'achievements-community-platinum-sponsored-label' => 'دستاورد حمایتی',
	'achievements-community-platinum-sponsored-hover-content-label' => 'تصویر شناور <small>(حداقل اندازهٔ شناور: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'ردگیری نشانی برای تاثیرات نشان:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'ردگیری نشانی برای تاثیرات شناور:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'پیوند نشان <small>(DART کلیک بر نشانی دستور)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'کلیک برای اطلاعات بیشتر',
	'achievements-badge-name-edit-0' => 'ساختن یک تفاوت',
	'achievements-badge-name-edit-1' => 'تازه اول کار',
	'achievements-badge-name-edit-2' => 'ساخت علامت خود',
	'achievements-badge-name-edit-3' => 'دوست از ویکی',
	'achievements-badge-name-edit-4' => 'یاور',
	'achievements-badge-name-edit-5' => 'ویکی‌ساز',
	'achievements-badge-name-edit-6' => 'رهبر ویکی',
	'achievements-badge-name-edit-7' => 'کارشناس ویکی',
	'achievements-badge-name-picture-0' => 'عکس لحظه‌ای',
	'achievements-badge-name-picture-1' => 'پاپارازی (عکاسی که از افراد مهم عکس می‌گیرد)',
	'achievements-badge-name-picture-2' => 'تصویرگر',
	'achievements-badge-name-picture-3' => 'گردآورنده',
	'achievements-badge-name-picture-4' => 'عاشق هنر',
	'achievements-badge-name-picture-5' => 'دکوراتور',
	'achievements-badge-name-picture-6' => 'طراح',
	'achievements-badge-name-picture-7' => 'نگهبان',
	'achievements-badge-name-category-0' => 'اتصال برقرار کنید',
	'achievements-badge-name-category-1' => 'پیشگام',
	'achievements-badge-name-category-2' => 'مرورگر',
	'achievements-badge-name-category-3' => 'راهنمای تور',
	'achievements-badge-name-category-4' => 'ناوبری',
	'achievements-badge-name-category-5' => 'پل‌ساز',
	'achievements-badge-name-category-6' => 'برنامه‌ریز ویکی',
	'achievements-badge-name-blogpost-0' => 'چیزی برای گفتن',
	'achievements-badge-name-blogpost-1' => 'پنج چیز برای گفتن',
	'achievements-badge-name-blogpost-3' => 'زندگی حزب',
	'achievements-badge-name-blogpost-4' => 'سخنران عمومی',
	'achievements-badge-name-blogcomment-0' => 'خودرای',
	'achievements-badge-name-blogcomment-1' => 'و یک چیز دیگر',
	'achievements-badge-name-love-0' => 'کلید به ویکی!',
	'achievements-badge-name-love-1' => 'دو هفته در ویکی',
	'achievements-badge-name-love-2' => 'فداشده',
	'achievements-badge-name-love-3' => 'تخصیص‌یافته',
	'achievements-badge-name-love-4' => 'معتاد',
	'achievements-badge-name-love-5' => 'یک زندگی ویکی',
	'achievements-badge-name-love-6' => 'قهرمان ویکی!',
	'achievements-badge-name-sharing-0' => 'سهیم',
	'achievements-badge-name-sharing-1' => 'به قبل بازگردان',
	'achievements-badge-name-sharing-2' => 'سخنگو',
	'achievements-badge-name-sharing-3' => 'گوینده',
	'achievements-badge-name-sharing-4' => 'واعظ',
	'achievements-badge-name-welcome' => 'به ویکی خوش آمدید',
	'achievements-badge-name-introduction' => 'مقدمه',
	'achievements-badge-name-sayhi' => 'توقف برای سلام کردن',
	'achievements-badge-name-creator' => 'آفریننده',
	'achievements-badge-name-pounce' => 'یورش!',
	'achievements-badge-name-caffeinated' => 'کافئین‌دار',
	'achievements-badge-name-luckyedit' => 'ویرایش خوش‌شانس',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|به‌اشتراک‌گذاری پیوند|get {{PLURAL:$1|یک فرد|$1 فرد}} بر پیوندی که به اشتراک گذاشتید کلیک کردند}}',
	'achievements-badge-to-get-edit' => '$1 {{PLURAL:$1|ویرایش|ویرایش}} در {{PLURAL:$1|یک صفحه|صفحه}} انجام بده',
	'achievements-badge-to-get-edit-plus-category' => '{{PLURAL:$1|یک ویرایش|$1 ویرایش}} در {{PLURAL:$1|یک صفحهٔ $2|$2 صفحات}} انجام بده',
	'achievements-badge-to-get-picture' => '$1 {{PLURAL:$1|تصویر|تصویر}} به {{PLURAL:$1|صفحه|صفحات}} بیفزا',
	'achievements-badge-to-get-welcome' => 'به ویکی بپیوندید',
	'achievements-badge-to-get-introduction' => 'به صفحهٔ کاربری خود بیفزایید',
	'achievements-badge-to-get-sayhi' => 'برای کسی در صفحهٔ بحثش پیغام بگذارید',
	'achievements-badge-to-get-creator' => 'پدیدآورندهٔ این ویکی باشید',
	'achievements-badge-to-get-pounce' => 'سریع باش',
	'achievements-badge-to-get-caffeinated' => '{{PLURAL:$1|یک ویرایش|$1 ویرایش}} در یک روز در صفحات انجام بده',
	'achievements-badge-to-get-luckyedit' => 'خوش‌شانس باش',
	'achievements-badge-to-get-sharing-details' => 'پیوندها را به اشتراک بگذارید و از دیگران بخواهید بر آن‌ها کلیک کنند!',
	'achievements-badge-to-get-edit-details' => 'آیا چیزی جا افتاده؟
آیا اشتباهی است؟
خجالت نکشید.
بر دکمهٔ «{{int:edit}}» کلیک کنید و می‌تواند در هر صفحه‌ای اضافه کنید!',
	'achievements-badge-to-get-edit-plus-category-details' => 'صفحات <strong>$1</strong> به کمک شما نیاز دارند!
بر دکمهٔ «{{int:edit}}» در هر صفحه‌ای در آن رده کلیک کنید تا کمک کنید.
پشتیبانی خود را از صفحات $1 نشان دهید!',
	'achievements-badge-to-get-picture-details' => 'بر دکمهٔ «{{int:edit}}» کلیک کنید، و سپس بر دکمهٔ «{{int:rte-ck-image-add}}».
شما می‌توانید از رایانهٔ خود تصویری اضافه کنید، یا از صفحه‌ای دیگر در ویکی.',
	'achievements-badge-to-get-category-details' => 'رده‌ها برچسب‌هایی هستند که به خوانندگان برای یافتن صفحات مشابه کمک می‌کنند.
بر دکمهٔ «{{int:categoryselect-addcategory-button}}» در پایین صفحه کلیک کنید تا آن صفحه را در رده‌ای فهرست کنید.',
	'achievements-badge-to-get-blogpost-details' => 'نظرات و سوالات خود را بنویسید!
بر {{int:blogs-recent-url-text}} در نوار کناری کلیک کنید، و سپس بر پیوند در سمت راست برای «{{int:create-blog-post-title}}».',
	'achievements-badge-to-get-blogcomment-details' => 'دو سنت خود را بیفزایید!
یکی از آخرین پست‌های وبلاگ را بخوانید، و افکار خود را در بخش جعبهٔ نظرات بنویسید.',
	'achievements-badge-to-get-love-details' => 'در صورتی که یک روز را از دست بدهید شمارشگر ازنو خواهد شد، بنابراین مطمئن باشید که هر روز به ویکی سر بزنید!',
	'achievements-badge-to-get-welcome-details' => 'بر دکمهٔ «{{int:oasis-signup}}» در بالا سمت چپ برای پیوستن به جامعه کلیک کنید.
شما می‌توانید شروع به کسب نشان‌های خود بکنید!',
	'achievements-badge-to-get-introduction-details' => 'آیا صفحهٔ کاربری‌تان خالی است؟
بر نام کاربری خود در بالای صفحه برای دیدن کلیک کنید.
بر «{{int:edit}}» برای افزودن اطلاعاتی دربارهٔ خودتان کلیک کنید!',
	'achievements-badge-to-get-sayhi-details' => 'شما می‌توانید برای دیگر کاربران با کلیک بر «{{int:tooltip-ca-addsection}}» در صفحات کاربری‌شان پیام بگذارید.
کمک بخواهید، از آن‌ها برای کارشان سپاسگذاری کنید، یا تنها بگویید سلام!',
	'achievements-badge-to-get-creator-details' => 'این نشان به فردی که ویکی را تأسیس کرد داده می‌شود.
بر دکمهٔ «{{int:createwiki}}» در بالا برای شروع سایتی دربارهٔ هر موضوعی که بیشتر دوست دارید کلیک کنید!',
	'achievements-badge-to-get-pounce-details' => 'شما برای بدست آوردن این نشان باید سریع باشید.
بر دکمهٔ «{{int:activityfeed}}» برای دیدن صفحات جدیدی که کاربران می‌سازند کلیک کنید!',
	'achievements-badge-to-get-caffeinated-details' => 'کسب این نشان روز پرکاری را می‌طلبد.
به ویرایش ادامه دهید!',
	'achievements-badge-to-get-luckyedit-details' => 'برای کسب این نشان باید خوش‌شانس باشید.
به ویراش ادامه دهید!',
	'achievements-badge-to-get-community-platinum-details' => 'این یک نشان ویژهٔ پلاتینی است که تنها برای زمان محدودی در دسترس است!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|برای به‌اشتراک‌گذاری یک پیوند|برای ترغیب  {{PLURAL:$1|یک نفر|$1 نفر}} برای کلیک بر لینک‌های به‌اشتراک‌گذارده}}',
	'achievements-badge-hover-desc-edit' => 'برای انجام $1 {{PLURAL:$1|ویرایش|ویرایش}}<br />
در {{PLURAL:$1|صفحه|صفحه}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'برای انجام $1 {{PLURAL:$1|ویرایش|ویرایش}}<br />
در {{PLURAL:$1|یک صفحهٔ $2|صفحات $2}}!',
	'achievements-badge-hover-desc-picture' => 'برای افزودن $1 {{PLURAL:$1|تصویر|تصویر}}<br />
به {{PLURAL:$1|صفحه|صفحه}}!',
	'achievements-badge-hover-desc-category' => 'برای افزودن $1 {{PLURAL:$1|صفحه|صفحه}}<br />
به {{PLURAL:$1|یک رده|رده‌ها}}!',
	'achievements-badge-hover-desc-blogpost' => 'برای نوشتن $1 {{PLURAL:$1|پست وبلاگ|پست وبلاگ}}!',
	'achievements-badge-hover-desc-welcome' => 'برای پیوستن به ویکی!',
	'achievements-badge-hover-desc-caffeinated' => 'برای انجام ۱۰۰ ویرایش در صفحات در یک روز!',
	'achievements-badge-hover-desc-luckyedit' => 'برای انجام $1مین ویرایش خوش‌شانس در ویکی!',
	'achievements-badge-hover-desc-community-platinum' => 'این یک نشان پلاتین ویژه است که تنها برای زمان محدودی در دسترس است!',
	'achievements-badge-your-desc-sharing' => '{{#ifeq:$1|0|برای اشتراک یک پیوند|برای ترغیب {{PLURAL:$1|یک نفر|$1 نفر}} برای کلیک بر پیوندهای به‌اشتراک‌گذارده}}',
	'achievements-badge-your-desc-edit' => 'برای انجام {{PLURAL:$1|نخستین ویرایشتان|$1 ویرایش}} در {{PLURAL:$1|یک صفحه|صفحات}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'برای انجام {{PLURAL:$1|نخستین ویرایشتان|$1 ویرایش}} در {{PLURAL:$1|یک صفحهٔ $2|صفحات $2}}!',
	'achievements-badge-your-desc-welcome' => 'برای پیوستن به ویکی!',
	'achievements-badge-your-desc-introduction' => 'برای افزودن به صفحهٔک اربری خودتان!',
	'achievements-badge-your-desc-sayhi' => 'برای پیغام گذاشتن در صفحهٔ کاربری فردی دیگر!',
	'achievements-badge-your-desc-creator' => 'برای ایجاد ویکی!',
	'achievements-badge-your-desc-pounce' => 'برای انجام ویرایش‌ها در ۱۰۰ صفحه از یک ساعت پس از ایجاد صفحه!',
	'achievements-badge-your-desc-caffeinated' => 'برای انجام ۱۰۰ ویرایش در صفحات در یک روز!',
	'achievements-badge-your-desc-luckyedit' => 'برای انجام خوش‌شانس $1مین ویرایش در ویکی!',
	'achievements-badge-desc-welcome' => 'برای پیوستن به ویکی!',
);

$messages['fi'] = array(
	'achievementsii-desc' => 'Kunniamerkkijärjestelmä wikin käyttäjille',
	'achievements-upload-error' => 'Tämä kuva ei toimi.
Varmista, että se on tyypiltään jpg tai png.
Jos se ei vieläkään toimi, niin kuva voi olla liian suuri.
Kokeile toista kuvaa.',
	'achievements-upload-not-allowed' => 'Ylläpitäjät voivat vaihtaa kunniamerkkien nimiä ja kuvia [[Special:AchievementsCustomize|Muokkaa kunniamerkkejä]] sivulla.',
	'achievements-non-existing-category' => 'Määritettyä kategoriaa ei ole olemassa.',
	'right-platinum' => 'Luoda ja muokata platinakunniamerkkejä',
	'right-sponsored-achievements' => 'Hallitse sponsoroituja kunniamerkkejä',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Kulta',
	'achievements-silver' => 'Hopea',
	'achievements-bronze' => 'Pronssi',
	'achievements-gold-points' => '100<br />pistettä',
	'achievements-silver-points' => '50<br />pistettä',
	'achievements-bronze-points' => '10<br />pistettä',
	'achievements-you-must' => 'Ansaitaksesi tämän kunniamerkin sinun täytyy $1.',
	'leaderboard-button' => 'Kunniamerkkien arvoasteikko',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|piste|pistettä}}</small>',
	'achievements-profile-title-no' => 'Käyttäjän $1 kunniamerkit',
	'achievements-no-badges' => 'Tutustu alla olevasta listasta kunniamerkkeihin, jotka voit ansaita tässä wikissä!',
	'achievements-notification-subtitle' => 'Ansaitsit juuri kunniamerkin $1 $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Katso lisää kunniamerkkejä joita voit saada]]!</big></strong>',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|piste|pistettä}}',
	'achievements-earned' => 'Tämän kunniamerkin on ansainnut {{PLURAL:$1|1 käyttäjä|$1 käyttäjää}}.',
	'achievements-profile-title' => 'Käyttäjän $1 {{PLURAL:$2|ansaitsema kunniamerkki|ansaitsemat $2 kunniamerkkiä}}',
	'achievements-profile-title-challenges' => 'Lisää kunniamerkkejä, joita voit ansaita!',
	'achievements-profile-customize' => 'Mukauta kunniamerkkejä',
	'achievements-ranked' => 'Sijalla #$1 tässä wikissä',
	'achievements-viewall' => 'Näytä kaikki',
	'achievements-viewless' => 'Sulje',
	'achievements-ranked-oasis' => '$1 on [[Special:Leaderboard|sijalla #$2]] tässä wikissä',
	'achievements-viewall-oasis' => 'Näytä kaikki',
	'achievements-toggle-hide' => 'Piilota kunniamerkit profiilistani',
	'leaderboard-intro-hide' => 'piilota',
	'leaderboard-intro-open' => 'avaa',
	'leaderboard-intro-headline' => 'Mitä kunniamerkinnät ovat?',
	'leaderboard-intro' => "Voit ansaita kunniamerkkejä tässä wikissä muokkaamalla sivuja, lataamalla kuvia ja jättämällä kommentteja. Saat jokaisesta kunniamerkistä pisteitä – mitä enemmän pisteitä ansaitset sitä ylemmäs pääset arvoasteikolla! Löydät ansaitsemasi kunniamerkit [[$1|käyttäjäsivultasi]].

'''Minkä arvoisia kunniamerkit ovat?'''",
	'leaderboard' => 'Kunniamerkkien  top-lista',
	'achievements-title' => 'Kunniamerkit',
	'leaderboard-title' => 'Top-lista',
	'achievements-leaderboard-rank-label' => 'Sijoitus',
	'achievements-leaderboard-member-label' => 'Käyttäjä',
	'achievements-leaderboard-points-label' => 'Pisteet',
	'achievements-leaderboard-points' => '{{PLURAL:$1|piste|pistettä}}',
	'achievements-send' => 'Tallenna kuva',
	'achievements-save' => 'Tallenna muutokset',
	'achievements-customize' => 'Mukauta kuvaa',
	'achievements-enable-track' => 'käytössä',
	'achievements-special-saved' => 'Muutokset tallennettu.',
	'achievements-special' => 'Erityiset saavutukset',
	'achievements-secret' => 'Salaiset saavutukset',
	'achievementscustomize' => 'Mukauta kunniamerkkejä',
	'achievements-about-title' => 'Tietoja tästä sivusta...',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'Sinut on palkittu uudella platinakunniamerkillä!',
	'achievements-community-platinum-how-to-earn' => 'Kuinka ansaitset:',
	'achievements-community-platinum-badge-image' => 'Kunniamerkin kuva:',
	'achievements-community-platinum-create-badge' => 'Luo kunniamerkki',
	'achievements-community-platinum-enabled' => 'käytössä',
	'achievements-community-platinum-save' => 'tallenna',
	'achievements-community-platinum-cancel' => 'peruuta',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Lisätietoja napsauttamalla tästä',
	'achievements-badge-name-love-1' => 'Kaksi viikkoa wikissä',
	'achievements-badge-name-love-4' => 'Addiktoitunut',
	'achievements-badge-name-sharing-4' => 'Evankelista',
	'achievements-badge-name-introduction' => 'Johdanto',
	'achievements-badge-to-get-edit' => 'tehdä $1 {{PLURAL:$1|muokkaus|muokkausta}} {{PLURAL:$1|sivuun}}',
	'achievements-badge-to-get-edit-plus-category' => 'tehdä {{PLURAL:$1|yksi muokkaus|$1 muokkausta}} $2 sivuun',
	'achievements-badge-to-get-picture' => 'lisätä $1 {{PLURAL:$1|kuva|kuvaa}} {{PLURAL:$1|sivulle}}',
	'achievements-badge-to-get-welcome' => 'liittyä wikiin',
	'achievements-badge-to-get-sayhi' => 'jättää viesti toisen käyttäjän keskustelusivulle',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong> sivut tarvitsevat apuasi!
Klikkaa "{{int:edit}}"-näppäintä sivulla tai luokassa auttaaksesi sitä.
Näytä käyttäjän tuki $1 sivuilla!!',
	'achievements-badge-to-get-introduction-details' => 'Onko käyttäjäsivusi tyhjä?
Omalle sivullesi pääset napsauttamalla omaa nimeäsi sivun yläosassa.
Napsauta "{{int:edit}}" ja lisää tietoa itsestäsi.',
	'achievements-badge-to-get-sayhi-details' => 'Voit jättää muille käyttäjille viestejä napsauttamalla "{{int:addsection}}" heidän keskustelusivulla.
Voit kysyä apua, kiittää heitä työstä, tai sanoa hei!',
	'achievements-badge-to-get-creator-details' => 'Tämä kunniamerkki annetaan henkilölle, joka perusti wikin.
Napsauta "{{int:createwiki}}"-painiketta yläreunasta aloittaaksesi sivuston lempiaiheestasi!',
	'achievements-badge-to-get-pounce-details' => 'Sinun on oltava nopea ansaitaksesi tämän kunniamerkin.
Napsauta »{{Int:activityfeed}}»-painiketta nähdäksesi uudet sivut, joita käyttäjät luovat!',
	'achievements-badge-to-get-luckyedit-details' => 'Sinun täytyy olla onnekas ansaitaksesi tämän kunniamerkin.
Jatka muokkaamista!',
	'achievements-badge-to-get-community-platinum-details' => 'Tämä on erityinen platinakunniamerkki, joka on saatavissa vain rajoitetun ajan!',
	'achievements-badge-hover-desc-picture' => 'Palkittiin $1 {{PLURAL:$1|lisätystä kuvasta|lisätystä kuvasta}}<br />{{PLURAL:$1|artikkeliin|artikkeliin}}!',
	'achievements-badge-hover-desc-introduction' => 'Palkittiin lisäämisestä<br />
jotain omalle käyttäjäsivullesi!',
	'achievements-badge-hover-desc-sayhi' => 'Palkittiin jätetystä viestistä<br />
jonkun henkilön keskustelusivulle!',
	'achievements-badge-hover-desc-creator' => 'Myönnetty wikin luomisesta!',
	'achievements-badge-your-desc-edit' => 'Palkittiin {{PLURAL:$1|ensimmäisen muokkauksesi|$1 muokkausta}} {{PLURAL:$1|artikkeliin|artikkeliin}}!',
	'achievements-userprofile-title-no' => 'Käyttäjän $1 ansaitsemat kunniamerkit',
);

$messages['fo'] = array(
	'achievementsii-desc' => 'Ein avriks kort skipan fyri wiki brúkarar',
	'achievements-upload-error' => 'Orsaka!
Handa myndin kann ikki brúkast.
Eftirkanna og syrg fyri, at tað er ein .jpg ella .png fíla.
Um tað heldur ikki virkar nú, so kann orsøkin vera, at myndin er ov stór.
Vinarliga royn við aðrari mynd!',
	'achievements-upload-not-allowed' => 'Administratorar kunnu broyta nøvnini og myndir á Avriks kortunum við at vitja síðuna [[Special:AchievementsCustomize|Tillagað avrik]].',
	'achievements-non-existing-category' => 'Nevndi bólkurin er ikki til.',
	'achievements-edit-plus-category-track-exists' => 'Nevndi bólkur hevur longu eitt <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">associated track</a>.',
	'achievements-no-stub-category' => 'Vinarliga lat vera við at skapa spor fyri stubbar.',
	'right-platinum' => 'Skapa og rætta Platinkort',
	'right-sponsored-achievements' => 'Stýr Sponsoreraði avrik',
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Gull',
	'achievements-silver' => 'Silvur',
	'achievements-bronze' => 'Bronsa',
	'achievements-gold-points' => '100<br />stig',
	'achievements-silver-points' => '50<br />stig',
	'achievements-bronze-points' => '10<br />stig',
	'achievements-you-must' => 'Tær tørvar $1 fyri at vinna hetta kortið (badge).',
	'leaderboard-button' => 'Avriks stigatalvan',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|stig|stig}}</small>',
	'achievements-profile-title-no' => 'Limakortið (badge) hjá $1',
	'achievements-no-badges' => 'Hygg eftir listanum niðanfyri fyri at síggja kortini, sum tú kanst vinna á hesi wiki!',
	'achievements-track-name-edit' => 'Spor av rættingum',
	'achievements-track-name-picture' => 'Slóðir eftir myndum',
	'achievements-track-name-category' => 'Bólka spor',
	'achievements-track-name-love' => 'Wiki Kærleiki spor',
	'achievements-notification-title' => 'Soleiðis skal tað vera, $1!',
	'achievements-notification-subtitle' => 'Tú hevur júst vunnið "$1" kort $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Síggj fleiri kort ið tú kanst vinna]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|stig|stig}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|stig|stig}}',
	'achievements-earned' => 'Hetta kortið hava {{PLURAL:$1|1 brukari|$1 brúkarar}} vunnið.',
	'achievements-profile-title' => "$1'sa $2 vunnin {{PLURAL:$2|kort|kort}}",
	'achievements-profile-title-challenges' => 'Fleiri kort ið tú kanst vinna!',
	'achievements-profile-customize' => 'Tillagaði kort',
	'achievements-ranked' => 'Flokkað #$1 á hesi wiki',
	'achievements-viewall' => 'Síggj øll',
	'achievements-viewless' => 'Lat aftur',
	'achievements-profile-title-oasis' => 'avrik <br /> stig',
	'achievements-ranked-oasis' => '$1 er [[Special:Leaderboard|Flokkaður #$2]]',
	'achievements-viewall-oasis' => 'Síggj øll',
	'achievements-toggle-hide' => 'Halt míni úrslit loynilig´fyri øllum á míni vangamynd',
	'leaderboard-intro-hide' => 'fjal',
	'leaderboard-intro-open' => 'lat upp',
	'leaderboard-intro-headline' => 'Hvar merkir Avrik',
	'leaderboard-intro' => "Tú kanst vinna kort (badges) á hesi wiki við at rætta síður, upplóta myndir og við at gera viðmerkingar. Hvørt kort gevur tær stig - jú fleiri stig tú fær, jú hægri kemur tú upp á stigatalvuna! [[$1|brúkara vangamynd]].

'''Hvat virði hava kortini?'''",
	'leaderboard' => 'Avriks stigatalvan',
	'achievements-title' => 'Avrik',
	'leaderboard-title' => 'Stigatalva',
	'achievements-recent-earned-badges' => 'Nýliga vunnin kort',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />vunnið hevur <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'vann <strong><a href="$3" class="badgeName">$1</a></strong> badge<br />$2',
	'achievements-leaderboard-disclaimer' => 'Stigatalvan vísir broytingar síðan í gjár',
	'achievements-leaderboard-rank-label' => 'Rang',
	'achievements-leaderboard-member-label' => 'Limur',
	'achievements-leaderboard-points-label' => 'Stig',
	'achievements-leaderboard-points' => '{{PLURAL:$1|stig|stig}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Seinast vunnið',
	'achievements-send' => 'Goym myndina',
	'achievements-save' => 'Goym broytingar',
	'achievements-reverted' => 'Kortið er sett aftur til tað upprunaliga.',
	'achievements-customize' => 'Tilpassa myndina',
	'achievements-customize-new-category-track' => 'Skapa nýtt spor fyri bólkin:',
	'achievements-enable-track' => 'er gjørt virkið',
	'achievements-revert' => 'Set aftur til standard',
	'achievements-special-saved' => 'Broytingar goymdar.',
	'achievements-special' => 'Serlig avrik',
	'achievements-secret' => 'Loynilig avrik',
	'achievementscustomize' => 'Tillaga kortini',
	'achievements-about-title' => 'Um hesa síðu...',
	'achievements-community-platinum-edit' => 'rætta',
	'achievements-community-platinum-save' => 'goym',
	'achievements-community-platinum-cancel' => 'ógilda',
	'achievements-badge-name-edit-1' => 'Bert byrjanin',
);

$messages['fr'] = array(
	'achievementsii-desc' => 'Un système de badges pour les utilisateurs du wiki',
	'achievements-upload-error' => "Désolé !
Cette image ne fonctionne pas.
Veuillez vous assurer qu’il s'agit bien d'un fichier .jpg ou .png.
Si cela ne fonctionne toujours pas, c'est peut-être que l’image est trop lourde.
Merci d'en essayer une autre !",
	'achievements-upload-not-allowed' => 'Les administrateurs peuvent changer les noms et images des badges de distinction en visitant [[Special:AchievementsCustomize|la page de personnalisation des distinctions]].',
	'achievements-non-existing-category' => "La catégorie spécifiée n'existe pas.",
	'achievements-edit-plus-category-track-exists' => 'La catégorie spécifiée a déjà un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Aller au suivi">suivi associé</a>.',
	'achievements-no-stub-category' => 'Veuillez ne pas créer de groupes pour les ébauches.',
	'right-platinum' => 'Créer et modifier des badges de platine',
	'right-sponsored-achievements' => 'Gérer les distinctions sponsorisées',
	'achievements-platinum' => 'Platine',
	'achievements-gold' => 'Or',
	'achievements-silver' => 'Argent',
	'achievements-bronze' => 'Bronze',
	'achievements-gold-points' => '100<br />pts',
	'achievements-silver-points' => '50<br />pts',
	'achievements-bronze-points' => '10<br />pts',
	'achievements-you-must' => 'Vous devez $1 pour gagner ce badge.',
	'leaderboard-button' => 'Tableau des distinctions',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|point|points}}</small>',
	'achievements-profile-title-no' => 'Badges de $1',
	'achievements-no-badges' => 'Jetez un œil à la liste ci-dessous pour voir les badges que vous pouvez gagner sur ce wiki !',
	'achievements-track-name-edit' => 'Suivi des modifications',
	'achievements-track-name-picture' => 'Suivi des images',
	'achievements-track-name-category' => 'Suivi des catégories',
	'achievements-track-name-blogpost' => 'Suivi des billets de blog',
	'achievements-track-name-blogcomment' => 'Suivi des commentaires de blog',
	'achievements-track-name-love' => 'Suivi Amour de wiki',
	'achievements-track-name-sharing' => 'Suivi du partage',
	'achievements-notification-title' => 'Vous êtes sur le bon chemin, $1 !',
	'achievements-notification-subtitle' => 'Vous venez de gagner le badge « $1 » $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Cliquez ici pour voir davantage de badges que vous pouvez gagner]] !</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|point|points}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|point|points}}',
	'achievements-earned' => 'Ce badge a été gagné par {{PLURAL:$1|un utilisateur|$1 utilisateurs}}.',
	'achievements-profile-title' => '{{PLURAL:$2|Le badge gagné|Les $2 badges gagnés}} par $1',
	'achievements-profile-title-challenges' => 'D’autres badges que vous pouvez gagner !',
	'achievements-profile-customize' => 'Personnaliser les badges',
	'achievements-ranked' => 'Classé n°$1 sur ce wiki',
	'achievements-viewall' => 'Tout voir',
	'achievements-viewless' => 'Fermer',
	'achievements-profile-title-oasis' => 'points de <br /> distinction',
	'achievements-ranked-oasis' => '$1 est [[Special:Leaderboard|classé n°$2]] sur ce wiki',
	'achievements-viewall-oasis' => 'Tout voir',
	'achievements-toggle-hide' => 'Masquer mes distinctions sur mon profil pour tout le monde',
	'leaderboard-intro-hide' => 'masquer',
	'leaderboard-intro-open' => 'ouvrir',
	'leaderboard-intro-headline' => 'Que sont les récompenses ?',
	'leaderboard-intro' => "Sur ce wiki vous pouvez gagner des badges en modifiant des articles, téléversant des photos et en laissant des commentaires. Chaque badge vous rapporte des points — plus vous aurez de points et plus haut vous serez dans le classement ! Vous trouverez les badges que vous avez récoltés sur votre [[$1|page utilisateur]].

'''Que valent les badges ?'''",
	'leaderboard' => 'Tableau des distinctions',
	'achievements-title' => 'Distinctions',
	'leaderboard-title' => 'Classement',
	'achievements-recent-earned-badges' => 'Badges récemment gagnés',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />gagné par <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'a gagné le badge <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Le classement affiche les changements depuis hier',
	'achievements-leaderboard-rank-label' => 'Rang',
	'achievements-leaderboard-member-label' => 'Membre',
	'achievements-leaderboard-points-label' => 'Points',
	'achievements-leaderboard-points' => '{{PLURAL:$1|point|points}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Dernier reçu',
	'achievements-send' => 'Enregistrer l’image',
	'achievements-save' => 'Enregistrer les modifications',
	'achievements-reverted' => "Le badge est revenu à l'original.",
	'achievements-customize' => 'Personnaliser l’image',
	'achievements-customize-new-category-track' => 'Créer un nouveau suivi pour la catégorie :',
	'achievements-enable-track' => 'activé',
	'achievements-revert' => 'Revenir à la version par défaut',
	'achievements-special-saved' => 'Modifications enregistrées.',
	'achievements-special' => 'Distinctions spéciales',
	'achievements-secret' => 'Distinctions secrètes',
	'achievementscustomize' => 'Personnaliser les badges',
	'achievements-about-title' => 'À propos de cette page...',
	'achievements-about-content' => 'Les administrateurs de ce wiki peuvent personnaliser les noms et images des badges.

Vous pouvez importer n’importe quelle image .jpg ou .png, et elle sera automatiquement redimensionnée pour tenir dans le cadre.
Cela fonctionne mieux quand votre image est carrée, et quand la partie la plus importante est au centre de l’image.

Vous pouvez utiliser des images rectangulaires, mais il est possible qu’une partie soit rognée par le cadre.
Si vous avez un logiciel de graphisme, vous pouvez rogner l’image par vous-même pour que la partie importante se trouve au centre.
Si vous n’avez pas de logiciel de graphisme, vous pouvez essayer d’importer différentes images jusqu’à trouver celle qui fonctionne le mieux !
Si vous n’aimez pas l’image que vous avez importée, cliquez sur « {{int:achievements-revert}} » pour revenir à l’image par défaut.

Vous pouvez aussi donner de nouveaux noms aux badges pour refléter le sujet du wiki. Lorsque vous modifiez un nom, cliquez sur « {{int:achievements-save}} » pour enregistrer vos modifications.
Amusez-vous bien !',
	'achievements-edit-plus-category-track-name' => 'Suivi des modifications $1',
	'achievements-create-edit-plus-category-title' => 'Créer un nouveau suivi de modifications',
	'achievements-create-edit-plus-category-content' => 'Vous pouvez créer un nouvel ensemble de badges qui récompense les utilisateurs pour avoir modifié les pages d’une catégorie particulière, afin de mettre en valeur un domaine particulier de ce site sur lequel les utilisateurs apprécieront de travailler.
Vous pouvez définir plusieurs catégories de suivi, essayez donc de choisir deux catégories qui aideront les utilisateurs à montrer leurs spécialités !
Créez une rivalité entre les utilisateurs qui modifient les pages sur les vampires et ceux qui modifient celles sur les loups-garous ou les sorciers et les moldus ou encore les Autobots et les Decepticans.

Pour créer un nouveau suivi « Modifications dans une catégorie », saisissez le nom de la catégorie dans le champ ci-dessous.
Le suivi de modifications classique existera toujours ; cela créera un suivi à part que vous pourrez personnaliser séparément.

Lorsque le suivi est créé, les nouveaux badges apparaîtront dans la liste sur la gauche, sous le suivi de modifications classique.
Personnalisez les noms et images pour le nouveau suivi, afin que les utilisateurs puissent voire la différence !

Lorsque vous aurez fini la personnalisation, cochez la case « {{int:achievements-enable-track}} » pour démarrer le nouveau suivi et cliquez ensuite sur « {{int:achievements-save}} ».
Les utilisateurs verront le nouveau suivi apparaître dans leur profil utilisateur et commenceront à gagner des badges lorsqu’ils modifieront des pages dans cette catégorie.
Vous pourrez désactiver ce suivi plus tard, si vous ne voulez plus mettre en valeur cette catégorie.
Les utilisateurs qui auront gagné des badges dans ce suivi les conserveront toujours, même si le suivi est désactivé.

Ceci peut aider à s’amuser davantage avec les récompenses.
Essayez !',
	'achievements-create-edit-plus-category' => 'Créer ce suivi',
	'platinum' => 'Platine',
	'achievements-community-platinum-awarded-email-subject' => 'Vous avez gagné un nouveau badge de platine !',
	'achievements-community-platinum-awarded-email-body-text' => 'Félicitations $1 !

Vous venez de gagner le badge de platine « $2 » sur $4 ($3). Ceci ajoute 250 points à votre score !

Venez jeter un œil à votre super nouveau badge sur votre page utilisateur :

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Félicitations $1 !</strong><br /><br />
Vous venez de gagner le badge de platine « <strong>$2</strong> » sur <a href="$3">$4</a>. Ceci ajoute 250 points à votre score !<br /><br />
Venez jeter un œil à votre super nouveau badge sur votre <a href="$5">page utilisateur</a>.',
	'achievements-community-platinum-awarded-for' => 'Décerné pour :',
	'achievements-community-platinum-how-to-earn' => "Comment l'obtenir :",
	'achievements-community-platinum-awarded-for-example' => 'ex : « pour faire... »',
	'achievements-community-platinum-how-to-earn-example' => 'ex : « faire 3 modifications... »',
	'achievements-community-platinum-badge-image' => 'Image du badge :',
	'achievements-community-platinum-awarded-to' => 'Décerné à :',
	'achievements-community-platinum-current-badges' => 'Badges de platine actuels',
	'achievements-community-platinum-create-badge' => 'Créer un badge',
	'achievements-community-platinum-enabled' => 'activé',
	'achievements-community-platinum-show-recents' => 'afficher dans les badges récents',
	'achievements-community-platinum-edit' => 'modifier',
	'achievements-community-platinum-save' => 'enregistrer',
	'achievements-community-platinum-cancel' => 'annuler',
	'achievements-community-platinum-sponsored-label' => 'Distinction sponsorisée',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Photo d’aperçu au survol <small>(taille minimale d’aperçu : 270&nbsp;×&nbsp;100 pixels) :</small>',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Adresse URL de suivi pour les impressions de badges :',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Adresse URL de suivi pour l’impression des aperçus :',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Lien du badge <small>(adresse URL la commande de clic DART) :</small>',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Cliquez ici pour plus d’informations',
	'achievements-badge-name-edit-0' => 'Fait la différence',
	'achievements-badge-name-edit-1' => 'Ce n’est que le début',
	'achievements-badge-name-edit-2' => 'Se fait remarquer',
	'achievements-badge-name-edit-3' => 'Ami du wiki',
	'achievements-badge-name-edit-4' => 'Collaborateur',
	'achievements-badge-name-edit-5' => 'Constructeur de wiki',
	'achievements-badge-name-edit-6' => 'Leader de wiki',
	'achievements-badge-name-edit-7' => 'Expert en wiki',
	'achievements-badge-name-picture-0' => 'Instantané',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illustrateur',
	'achievements-badge-name-picture-3' => 'Collectionneur',
	'achievements-badge-name-picture-4' => "Amateur d'art",
	'achievements-badge-name-picture-5' => 'Décorateur',
	'achievements-badge-name-picture-6' => 'Concepteur',
	'achievements-badge-name-picture-7' => 'Conservateur',
	'achievements-badge-name-category-0' => 'Établir une connexion',
	'achievements-badge-name-category-1' => 'Traceur de sentiers',
	'achievements-badge-name-category-2' => 'Explorateur',
	'achievements-badge-name-category-3' => 'Guide touristique',
	'achievements-badge-name-category-4' => 'Navigateur',
	'achievements-badge-name-category-5' => 'Constructeur de ponts',
	'achievements-badge-name-category-6' => 'Planificateur de wiki',
	'achievements-badge-name-blogpost-0' => 'Quelque chose à dire',
	'achievements-badge-name-blogpost-1' => 'Cinq choses à dire',
	'achievements-badge-name-blogpost-2' => 'Foire de discussion',
	'achievements-badge-name-blogpost-3' => 'Vie du parti',
	'achievements-badge-name-blogpost-4' => 'Conférencier',
	'achievements-badge-name-blogcomment-0' => 'Commentateur',
	'achievements-badge-name-blogcomment-1' => 'Et encore une chose',
	'achievements-badge-name-love-0' => 'Jeune espoir du wiki !',
	'achievements-badge-name-love-1' => 'Deux semaines sur le wiki',
	'achievements-badge-name-love-2' => 'Dévoué',
	'achievements-badge-name-love-3' => 'Dédié',
	'achievements-badge-name-love-4' => 'Accro',
	'achievements-badge-name-love-5' => 'Une wiki-vie',
	'achievements-badge-name-love-6' => 'Héros du wiki !',
	'achievements-badge-name-sharing-0' => 'Partageur',
	'achievements-badge-name-sharing-1' => 'Viens par ici',
	'achievements-badge-name-sharing-2' => 'Orateur',
	'achievements-badge-name-sharing-3' => 'Annonceur',
	'achievements-badge-name-sharing-4' => 'Évangéliste',
	'achievements-badge-name-welcome' => 'Bienvenue sur le wiki',
	'achievements-badge-name-introduction' => 'Introduction',
	'achievements-badge-name-sayhi' => 'Bonjour en passant',
	'achievements-badge-name-creator' => 'Le créateur',
	'achievements-badge-name-pounce' => 'C’est parti !',
	'achievements-badge-name-caffeinated' => 'Accro à la caféine',
	'achievements-badge-name-luckyedit' => 'Modification chanceuse',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|partager un lien|amener {{PLURAL:$1|une personne|$1 personnes}} à cliquer sur le lien que vous avez partagé}}',
	'achievements-badge-to-get-edit' => 'faire $1 {{PLURAL:$1|modification|modifications}} sur {{PLURAL:$1|une page|des pages}}',
	'achievements-badge-to-get-edit-plus-category' => 'faire $1 {{PLURAL:$1|modification|modifications}} sur {{PLURAL:$1|une page|des pages}} $2',
	'achievements-badge-to-get-picture' => 'ajouter $1 {{PLURAL:$1|image|images}} à {{PLURAL:$1|une page|des pages}}',
	'achievements-badge-to-get-category' => 'ajouter $1 {{PLURAL:$1|page|pages}} à {{PLURAL:$1|une catégorie|des catégories}}',
	'achievements-badge-to-get-blogpost' => 'écrire $1 {{PLURAL:$1|billet de blog|billets de blog}}',
	'achievements-badge-to-get-blogcomment' => 'commenter {{PLURAL:$1|un billet de blog|$1 billets de blog}}',
	'achievements-badge-to-get-love' => 'contribuer sur le wiki chaque jour pendant $1 jours',
	'achievements-badge-to-get-welcome' => 'rejoindre le wiki',
	'achievements-badge-to-get-introduction' => 'ajouter à votre propre page utilisateur',
	'achievements-badge-to-get-sayhi' => 'laisser un message à quelqu’un sur sa page de discussion',
	'achievements-badge-to-get-creator' => 'être le créateur de ce wiki',
	'achievements-badge-to-get-pounce' => 'être rapide',
	'achievements-badge-to-get-caffeinated' => 'faire {{PLURAL:$1|une modification|$1 modifications}} sur les pages en une seule journée',
	'achievements-badge-to-get-luckyedit' => 'avoir de la chance',
	'achievements-badge-to-get-sharing-details' => 'Partagez des liens et amenez les autres à cliquer dessus !',
	'achievements-badge-to-get-edit-details' => 'Quelque chose manque ?
Il y a une erreur ?
Ne soyez pas timide.
Cliquez sur le bouton « {{int:edit}} » et améliorez n’importe quelle page !',
	'achievements-badge-to-get-edit-plus-category-details' => 'Les pages <strong>$1</strong> ont besoin de votre aide !
Cliquez sur le bouton « {{int:edit}} » de n’importe quelle page de cette catégorie pour donner un coup de main.
Montrez votre soutien aux pages $1 !',
	'achievements-badge-to-get-picture-details' => 'Cliquez sur le bouton « {{int:edit}} » puis sur le bouton « {{int:rte-ck-image-add}} ».
Vous pouvez ajouter une photo depuis votre ordinateur ou depuis une autre page du wiki.',
	'achievements-badge-to-get-category-details' => 'Les catégories sont des étiquettes qui aident les lecteurs à trouver des pages similaires.
Cliquez sur le bouton « {{int:categoryselect-addcategory-button}} » d’une page pour lister cette page dans une catégorie.',
	'achievements-badge-to-get-blogpost-details' => 'Écrivez vos opinions et questions !
Cliquez sur « {{int:blogs-recent-url-text}} » dans la barre latérale et ensuite sur le lien à gauche pour « {{int:create-blog-post-title}} ».',
	'achievements-badge-to-get-blogcomment-details' => 'Ajoutez votre grain de sel !
Lisez un des billets de blog récents et donnez votre avis dans le champ commentaires.',
	'achievements-badge-to-get-love-details' => 'Le compteur se réinitialise si vous ratez un jour, assurez-vous de revenir sur le wiki tous les jours !',
	'achievements-badge-to-get-welcome-details' => 'Cliquez sur le bouton « {{int:oasis-signup}} » en haut à droite pour rejoindre la communauté.
Vous pourrez commencer à gagner vos propres badges !',
	'achievements-badge-to-get-introduction-details' => 'Votre page utilisateur est vide ?
Cliquez sur votre nom d’utilisateur en haut de l’écran pour voir.
Cliquez sur « {{int:edit}} » pour ajouter des informations sur vous !',
	'achievements-badge-to-get-sayhi-details' => 'Vous pouvez laisser des messages aux autres utilisateurs en cliquant sur "{{int:addsection}}" sur leur page de discussion.
Demandez de l’aide, remerciez-les pour leur travail, ou dites simplement bonjour !',
	'achievements-badge-to-get-creator-details' => 'Ce badge est décerné à la personne qui a créé le wiki.
Cliquez sur le bouton « {{int:createwiki}} » en haut de l’écran pour créer un site à propos de ce que vous aimez le plus !',
	'achievements-badge-to-get-pounce-details' => 'Vous devez être rapide pour gagner ce badge.
Cliquez sur le bouton « {{int:activityfeed}} » pour voir les nouvelles pages que les utilisateurs créent !',
	'achievements-badge-to-get-caffeinated-details' => 'Il faut toute une journée pour gagner ce badge.
Continuez à modifier !',
	'achievements-badge-to-get-luckyedit-details' => 'Vous devez être chanceux pour gagner ce badge.
Continuez à modifier !',
	'achievements-badge-to-get-community-platinum-details' => 'Ceci est un badge de platine spécial qui n’est disponible que pour un temps limité !',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|pour partager un lien|pour amener {{PLURAL:$1|une personne|$1 personnes}} à cliquer sur des liens partagés}}',
	'achievements-badge-hover-desc-edit' => 'Distingué pour avoir fait $1 {{PLURAL:$1|modification|modifications}}<br />
sur {{PLURAL:$1|une page|des pages}} !',
	'achievements-badge-hover-desc-edit-plus-category' => 'Distingué pour avoir fait $1 {{PLURAL:$1|modification|modifications}}<br />
sur {{PLURAL:$1|une page|des pages}} $2 !',
	'achievements-badge-hover-desc-picture' => 'Distingué pour avoir ajouté $1 {{PLURAL:$1|image|images}}<br />
à {{PLURAL:$1|une page|des pages}} !',
	'achievements-badge-hover-desc-category' => 'Distingué pour avoir ajouté $1 {{PLURAL:$1|page|pages}}<br />
à {{PLURAL:$1|une catégorie|des catégories}} !',
	'achievements-badge-hover-desc-blogpost' => 'Distingué pour avoir écrit {{PLURAL:$1|un billet de blog|$1 billets de blog}} !',
	'achievements-badge-hover-desc-blogcomment' => 'Distingué pour avoir commenté<br />
{{PLURAL:$1|un billet de blog|$1 billets de blog}} !',
	'achievements-badge-hover-desc-love' => 'Distingué pour avoir contribué au wiki tous les jours pendant {{PLURAL:$1|un jour|$1 jours}} !',
	'achievements-badge-hover-desc-welcome' => 'Distingué pour avoir rejoint le wiki !',
	'achievements-badge-hover-desc-introduction' => 'Distingué pour avoir ajouté des informations sur<br />
votre propre page utilisateur !',
	'achievements-badge-hover-desc-sayhi' => "Distingué pour avoir laissé un message<br />
sur la page de discussion de quelqu’un d'autre !",
	'achievements-badge-hover-desc-creator' => 'Distingué pour avoir créé le wiki !',
	'achievements-badge-hover-desc-pounce' => 'Distingué pour avoir fait des modifications sur 100 pages dans l’heure suivant la création de la page !',
	'achievements-badge-hover-desc-caffeinated' => 'Distingué pour avoir fait 100 modifications sur des pages en un seul jour !',
	'achievements-badge-hover-desc-luckyedit' => 'Distingué pour avoir fait la modification chanceuse n°$1 sur le wiki !',
	'achievements-badge-hover-desc-community-platinum' => 'Ceci est un badge de platine spécial qui n’est disponible que pour un temps limité !',
	'achievements-badge-your-desc-sharing' => 'Distingué {{#ifeq:$1|0|pour avoir partagé un lien|pour avoir amené {{PLURAL:$1|une personne|$1 personnes}} à cliquer sur des liens partagés}}',
	'achievements-badge-your-desc-edit' => 'Distingué pour avoir fait {{PLURAL:$1|votre première modification sur une page|$1 modifications sur des pages}} !',
	'achievements-badge-your-desc-edit-plus-category' => 'Distingué pour avoir fait {{PLURAL:$1|votre première modification|$1 modifications}} sur {{PLURAL:$1|une page $2|les pages $2}}!',
	'achievements-badge-your-desc-picture' => 'Distingué pour avoir ajouté {{PLURAL:$1|votre première image sur une page|$1 images sur des pages}} !',
	'achievements-badge-your-desc-category' => 'Distingué pour avoir ajouté {{PLURAL:$1|votre première page à une catégorie|$1 pages à des catégories}} !',
	'achievements-badge-your-desc-blogpost' => 'Distingué pour avoir écrit {{PLURAL:$1|votre premier billet de blog|$1 billets de blog}} !',
	'achievements-badge-your-desc-blogcomment' => 'Distingué pour avoir commenté {{PLURAL:$1|un billet de blog|$1 billets de blog}} !',
	'achievements-badge-your-desc-love' => 'Distingué pour avoir contribué au wiki tous les jours pendant {{PLURAL:$1|un jour|$1 jours}}!',
	'achievements-badge-your-desc-welcome' => 'Distingué pour avoir rejoint le wiki !',
	'achievements-badge-your-desc-introduction' => 'Distingué pour avoir ajouté des informations sur votre propre page utilisateur !',
	'achievements-badge-your-desc-sayhi' => "Distingué pour avoir laissé un message sur la page de discussion de quelqu’un d'autre !",
	'achievements-badge-your-desc-creator' => 'Distingué pour avoir créé le wiki !',
	'achievements-badge-your-desc-pounce' => 'Distingué pour avoir fait des modifications sur 100 pages dans l’heure suivant la création de la page !',
	'achievements-badge-your-desc-caffeinated' => 'Distingué pour avoir fait 100 modifications sur des pages en un seul jour !',
	'achievements-badge-your-desc-luckyedit' => 'Distingué pour avoir fait la modification chanceuse n°$1 sur le wiki !',
	'achievements-badge-desc-sharing' => 'Distingué {{#ifeq:$1|0|pour avoir partagé un lien|pour avoir amené {{PLURAL:$1|une personne|$1 personnes}} à cliquer sur des liens partagés}}',
	'achievements-badge-desc-edit' => 'Distingué pour avoir fait $1 {{PLURAL:$1|modification|modifications}} sur {{PLURAL:$1|une page|des pages}} !',
	'achievements-badge-desc-edit-plus-category' => 'Distingué pour avoir fait $1 {{PLURAL:$1|modification|modifications}}<br />sur {{PLURAL:$1|une page|des pages}} $2 !',
	'achievements-badge-desc-picture' => 'Distingué pour avoir ajouté $1 {{PLURAL:$1|image|images}} à {{PLURAL:$1|une page|des pages}} !',
	'achievements-badge-desc-category' => 'Distingué pour avoir ajouté $1 {{PLURAL:$1|page|pages}} à {{PLURAL:$1|une catégorie|des catégories}} !',
	'achievements-badge-desc-blogpost' => 'Distingué pour avoir écrit {{PLURAL:$1|un billet de blog|$1 billets de blog}} !',
	'achievements-badge-desc-blogcomment' => 'Distingué pour avoir commenté {{PLURAL:$1|un billet de blog|$1 billets de blog}} !',
	'achievements-badge-desc-love' => 'Distingué pour avoir contribué au wiki tous les jours pendant {{PLURAL:$1|un jour|$1 jours}} !',
	'achievements-badge-desc-welcome' => 'Distingué pour avoir rejoint le wiki !',
	'achievements-badge-desc-introduction' => 'Distingué pour avoir ajouté des informations sur votre propre page utilisateur !',
	'achievements-badge-desc-sayhi' => "Distingué pour avoir laissé un message sur la page de discussion de quelqu’un d'autre !",
	'achievements-badge-desc-creator' => 'Distingué pour avoir créé le wiki !',
	'achievements-badge-desc-pounce' => 'Distingué pour avoir fait des modifications sur 100 pages dans l’heure suivant la création de la page !',
	'achievements-badge-desc-caffeinated' => 'Distingué pour avoir fait 100 modifications sur des pages en un seul jour !',
	'achievements-badge-desc-luckyedit' => 'Distingué pour avoir fait la modification chanceuse n°$1 sur le wiki !',
	'achievements-userprofile-title-no' => 'Badges gagnés par $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Badge|Badges}} gagnés par $1 ($2)',
	'achievements-userprofile-no-badges-owner' => 'Jetez un œil à la liste ci-dessous pour voir les badges que vous pouvez gagner sur ce wiki !',
	'achievements-userprofile-no-badges-visitor' => 'Cet utilisateur n’a pas encore gagné de badge.',
	'achievements-userprofile-profile-score' => '<em>$1</em> points<br /> de distinction',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Classé n°$1]]<br />sur ce wiki',
	'action-platinum' => 'créer et modifier des badges de platine',
	'achievements-next-oasis' => 'Suite',
	'achievements-prev-oasis' => 'Précédent',
	'right-achievements-exempt' => 'L’utilisateur n’est pas admissible pour gagner des points de distinction',
	'right-achievements-explicit' => 'L’utilisateur est admissible pour gagner des points de distinction (prime sur inadmissible)',
);

$messages['gl'] = array(
	'achievementsii-desc' => 'Un sistema de insignias para os usuarios do wiki',
	'achievements-upload-error' => 'Sentímolo!
A imaxe non vai.
Asegúrese de que é un ficheiro .jpg ou .png.
Se segue sen funcionar, entón poida que a imaxe sexa grande de máis.
Inténteo con outra imaxe!',
	'achievements-upload-not-allowed' => 'Os administradores poden cambiar os nomes e imaxes das insignias visitando [[Special:AchievementsCustomize|a páxina de personalización dos logros]].',
	'achievements-non-existing-category' => 'A categoría especificada non existe.',
	'achievements-edit-plus-category-track-exists' => 'A categoría especificada xa ten un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Ir ao logro">logro asociado</a>.',
	'achievements-no-stub-category' => 'Non cree logros para os bosquexos.',
	'right-platinum' => 'Crear e editar insignias de prata',
	'right-sponsored-achievements' => 'Xestionar os logros patrocinados',
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Ouro',
	'achievements-silver' => 'Prata',
	'achievements-bronze' => 'Bronce',
	'achievements-gold-points' => '100<br />pts.',
	'achievements-silver-points' => '50<br />pts.',
	'achievements-bronze-points' => '10<br />pts.',
	'achievements-you-must' => 'Ten que $1 para gañar esta insignia.',
	'leaderboard-button' => 'Taboleiro de logros',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punto|puntos}}</small>',
	'achievements-profile-title-no' => 'Insignias de $1',
	'achievements-no-badges' => 'Consulte a lista que aparece a continuación para ollar as insignias que pode gañar neste wiki!',
	'achievements-track-name-edit' => 'Logros de edición',
	'achievements-track-name-picture' => 'Logros de imaxe',
	'achievements-track-name-category' => 'Logros de categoría',
	'achievements-track-name-blogpost' => 'Logros de publicación nun blogue',
	'achievements-track-name-blogcomment' => 'Logros de comentarios nun blogue',
	'achievements-track-name-love' => 'Logros de amor polo wiki',
	'achievements-track-name-sharing' => 'Seguimento da compartición',
	'achievements-notification-title' => 'Vai no bo camiño, $1!',
	'achievements-notification-subtitle' => 'Obtivo a insignia "$1" por $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Olle máis insignias que pode gañar]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punto|puntos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punto|puntos}}',
	'achievements-earned' => '{{PLURAL:$1|1 usuario|$1 usuarios}} gañaron esta insignia.',
	'achievements-profile-title' => '{{PLURAL:$2|A insignia gañada|As $2 insignias gañadas}} por $1',
	'achievements-profile-title-challenges' => 'Máis insignias que pode gañar!',
	'achievements-profile-customize' => 'Personalizar as insignias',
	'achievements-ranked' => 'Obtivo o posto #$1 neste wiki',
	'achievements-viewall' => 'Ollar todas',
	'achievements-viewless' => 'Pechar',
	'achievements-profile-title-oasis' => 'logro <br /> puntos',
	'achievements-ranked-oasis' => '$1 está [[Special:Leaderboard|no posto nº$2]] neste wiki',
	'achievements-viewall-oasis' => 'Ollar todos',
	'achievements-toggle-hide' => 'Agochar os meus logros no meu perfil da vista de todos',
	'leaderboard-intro-hide' => 'agochar',
	'leaderboard-intro-open' => 'abrir',
	'leaderboard-intro-headline' => 'Que son os logros?',
	'leaderboard-intro' => "Pode gañar insignias neste wiki editando páxinas, cargando fotos e deixando comentarios. Con cada insignia obterá puntos que o poden levar máis arriba no taboleiro de logros! Atopará as insignias que gañou na [[$1|páxina do seu perfil de usuario]].

'''Canto valen os logros?'''",
	'leaderboard' => 'Taboleiro de logros',
	'achievements-title' => 'Logros',
	'leaderboard-title' => 'Taboleiro de logros',
	'achievements-recent-earned-badges' => 'Insignias conseguidas recentemente',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />conseguida por <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'conseguiu a insignia <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'O taboleiro mostra os cambios desde onte',
	'achievements-leaderboard-rank-label' => 'Clasificación',
	'achievements-leaderboard-member-label' => 'Membro',
	'achievements-leaderboard-points-label' => 'Puntos',
	'achievements-leaderboard-points' => '{{PLURAL:$1|punto|puntos}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Gañadas hai pouco',
	'achievements-send' => 'Gardar a imaxe',
	'achievements-save' => 'Gardar os cambios',
	'achievements-reverted' => 'A insignia foi revertida ao estado orixinal.',
	'achievements-customize' => 'Personalizar a imaxe',
	'achievements-customize-new-category-track' => 'Crear un novo logro para a categoría:',
	'achievements-enable-track' => 'activado',
	'achievements-revert' => 'Volver á versión por defecto',
	'achievements-special-saved' => 'Gardáronse os cambios.',
	'achievements-special' => 'Logros especiais',
	'achievements-secret' => 'Logros secretos',
	'achievementscustomize' => 'Personalizar as insignias',
	'achievements-about-title' => 'Acerca desta páxina...',
	'achievements-about-content' => 'Os administradores deste wiki poden personalizar os nomes e imaxes das insignias de logros.

Pode cargar calquera imaxe con extensión .jpg ou .png, e a súa imaxe encaixará automaticamente dentro do cadro.
Funciona mellor cando a imaxe é cadrada e cando a parte máis importante da imaxe está ben centrada.

Pode empregar imaxes rectangulares, pero atopará que quedan un pouco cortadas polo marco.
Se ten un programa de gráficos, entón pode cortar a imaxe para poñer a parte máis importante da mesma no centro.
Se non ten un programa de gráficos, entón intente experimentar con diferentes imaxes ata atopar a que mellor lle vaia!
Se non lle gusta a imaxe que elixiu, prema sobre "{{int:achievements-revert}}" para volver ao gráfico orixinal.

Tamén pode cambiarlles o nome ás insignias que reflicten o tema do wiki.
Ao trocar o nome dunha insignia, prema sobre "{{int:achievements-save}}" para salvar as súas modificacións.
Páseo ben!',
	'achievements-edit-plus-category-track-name' => 'Logro de edición "$1"',
	'achievements-create-edit-plus-category-title' => 'Crear un novo logro de edición',
	'achievements-create-edit-plus-category-content' => 'Pode crear un novo conxunto de insignias para recompensar os usuarios pola edición en páxinas nunha categoría especial e para destacar unha determinada área do sitio e así conseguir que os usuarios poidan gozar traballando nela.
Pode configurar máis dun logro de categoría, intente elixir dúas categorías que axudarán aos usuarios a mostrar a súa especialidade!
Inicie unha rivalidade entre aqueles usuarios que editan as páxinas sobre vampiros e aqueloutros que editan as páxinas de lobishomes ou bruxas.

Para crear un novo logro "Editar na categoría", escriba o nome da categoría no campo de embaixo.
O logro de edición habitual seguirá existindo;
isto creará un logro por separado, que tamén se poderá personalizar por separado.

Ao crear o logro, as novas insignias aparecen na lista da esquerda, por debaixo do logro de edición habitual.
Personalice os nomes e imaxes do novo logro, de xeito que os usuarios poidan ver a diferenza!

Unha vez feita a personalización, faga clic no botón "{{int:achievements-enable-track}}" da caixa de selección para activar o novo logro e, a continuación, prema sobre "{{int:achievements-save}}".
Os usuarios verán aparecer o novo logro no seu perfil de usuario e empezarán a gañar insignias en canto editen as páxinas desa categoría.
Tamén pode desactivar o logro máis tarde, se decide que xa non quere destacar a categoría.
Os usuarios que conseguiron insignias no logro manterán sempre as súas insignias, aínda que o logro estea desactivado.

Isto pode axudar a dar un pulo á diversión que se pode conseguir cos logros.
Próbeo!',
	'achievements-create-edit-plus-category' => 'Crear o logro',
	'platinum' => 'Platino',
	'achievements-community-platinum-awarded-email-subject' => 'Conseguiu unha nova insignia de platino!',
	'achievements-community-platinum-awarded-email-body-text' => 'Parabéns $1!

Acaba de gañar a insignia de platino "$2" en $4 ($3).
Isto engade 250 puntos á súa puntuación!

Bote unha ollada á súa nova insignia na súa páxina de perfil de usuario:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Parabéns $1!</strong><br /><br />
Acaba de gañar a insignia de platino "<strong>$2</strong>" en <a href="$3">$4</a>.
Isto engade 250 puntos á súa puntuación!<br /><br />
Bote unha ollada á súa nova insignia na súa <a href="$5">páxina de perfil de usuario</a>.',
	'achievements-community-platinum-awarded-for' => 'Premiado por:',
	'achievements-community-platinum-how-to-earn' => 'Como conseguir:',
	'achievements-community-platinum-awarded-for-example' => 'por exemplo, "por facer..."',
	'achievements-community-platinum-how-to-earn-example' => 'por exemplo, "facer tres edicións..."',
	'achievements-community-platinum-badge-image' => 'Imaxe da insignia:',
	'achievements-community-platinum-awarded-to' => 'Outorgado a:',
	'achievements-community-platinum-current-badges' => 'Insignias de platino actuais',
	'achievements-community-platinum-create-badge' => 'Crear unha insignia',
	'achievements-community-platinum-enabled' => 'activado',
	'achievements-community-platinum-show-recents' => 'mostrar nas insignias recentes',
	'achievements-community-platinum-edit' => 'editar',
	'achievements-community-platinum-save' => 'gardar',
	'achievements-community-platinum-cancel' => 'cancelar',
	'achievements-community-platinum-sponsored-label' => 'Logro patrocinado',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Imaxe de vista previa <small>(tamaño mínimo da vista previa: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'URL de seguimento para as impresións de insignias:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'URL de seguimento para as impresións de vistas previas:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Ligazón da insignia <small>(enderezo URL do comando DART)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Prema para obter máis información',
	'achievements-badge-name-edit-0' => 'Marcando a diferenza',
	'achievements-badge-name-edit-1' => 'Só o comezo',
	'achievements-badge-name-edit-2' => 'Deixando a marca',
	'achievements-badge-name-edit-3' => 'Amigo do wiki',
	'achievements-badge-name-edit-4' => 'Colaborador',
	'achievements-badge-name-edit-5' => 'Construtor do wiki',
	'achievements-badge-name-edit-6' => 'Líder do wiki',
	'achievements-badge-name-edit-7' => 'Experto no wiki',
	'achievements-badge-name-picture-0' => 'Instantánea',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Ilustrador',
	'achievements-badge-name-picture-3' => 'Coleccionista',
	'achievements-badge-name-picture-4' => 'Amante da arte',
	'achievements-badge-name-picture-5' => 'Decorador',
	'achievements-badge-name-picture-6' => 'Deseñador',
	'achievements-badge-name-picture-7' => 'Conservador',
	'achievements-badge-name-category-0' => 'Establecer unha conexión',
	'achievements-badge-name-category-1' => 'Pioneiro',
	'achievements-badge-name-category-2' => 'Explorador',
	'achievements-badge-name-category-3' => 'Guía turístico',
	'achievements-badge-name-category-4' => 'Navegante',
	'achievements-badge-name-category-5' => 'Construtor de pontes',
	'achievements-badge-name-category-6' => 'Planificador do wiki',
	'achievements-badge-name-blogpost-0' => 'Algo que dicir',
	'achievements-badge-name-blogpost-1' => 'Cinco cousas que dicir',
	'achievements-badge-name-blogpost-2' => 'Foro de conversas',
	'achievements-badge-name-blogpost-3' => 'Alma da festa',
	'achievements-badge-name-blogpost-4' => 'Locutor público',
	'achievements-badge-name-blogcomment-0' => 'Comentarista',
	'achievements-badge-name-blogcomment-1' => 'E unha cousa máis',
	'achievements-badge-name-love-0' => 'Esencial para o wiki!',
	'achievements-badge-name-love-1' => 'Dúas semanas no wiki',
	'achievements-badge-name-love-2' => 'Devoto',
	'achievements-badge-name-love-3' => 'Dedicado',
	'achievements-badge-name-love-4' => 'Adicto',
	'achievements-badge-name-love-5' => 'Unha vida no wiki',
	'achievements-badge-name-love-6' => 'Heroe do wiki!',
	'achievements-badge-name-sharing-0' => 'Compartidor',
	'achievements-badge-name-sharing-1' => 'Traelo de volta',
	'achievements-badge-name-sharing-2' => 'Falante',
	'achievements-badge-name-sharing-3' => 'Locutor',
	'achievements-badge-name-sharing-4' => 'Evanxelista',
	'achievements-badge-name-welcome' => 'Benvido ao wiki',
	'achievements-badge-name-introduction' => 'Introdución',
	'achievements-badge-name-sayhi' => 'Parado un intre para saudar',
	'achievements-badge-name-creator' => 'O creador',
	'achievements-badge-name-pounce' => 'Salta!',
	'achievements-badge-name-caffeinated' => 'Con cafeína',
	'achievements-badge-name-luckyedit' => 'Edición afortunada',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|compartir unha ligazón|conseguir que {{PLURAL:$1|unha persoa prema|$1 persoas preman}} na ligazón que compartiu}}',
	'achievements-badge-to-get-edit' => 'facer $1 {{PLURAL:$1|edición|edicións}} {{PLURAL:$1|nunha páxina|en páxinas}}',
	'achievements-badge-to-get-edit-plus-category' => 'facer $1 {{PLURAL:$1|edición|edicións}} {{PLURAL:$1|nunha páxina|en páxinas}} $2',
	'achievements-badge-to-get-picture' => 'engadir $1 {{PLURAL:$1|imaxe|imaxes}} {{PLURAL:$1|nunha páxina|en páxinas}}',
	'achievements-badge-to-get-category' => 'engadir $1 {{PLURAL:$1|páxina|páxinas}} a {{PLURAL:$1|unha categoría|categorías}}',
	'achievements-badge-to-get-blogpost' => 'escribir $1 {{PLURAL:$1|mensaxe|mensaxes}} de blogue',
	'achievements-badge-to-get-blogcomment' => 'escribir un comentario {{PLURAL:$1|nunha mensaxe|en $1 mensaxes}} de blogue',
	'achievements-badge-to-get-love' => 'colaborar no wiki cada día durante {{PLURAL:$1|un día|$1 días}}',
	'achievements-badge-to-get-welcome' => 'unirse ao wiki',
	'achievements-badge-to-get-introduction' => 'engadir información á súa páxina de usuario',
	'achievements-badge-to-get-sayhi' => 'deixar unha mensaxe a alguén na súa páxina de conversa',
	'achievements-badge-to-get-creator' => 'ser o creador do wiki',
	'achievements-badge-to-get-pounce' => 'ser rápido',
	'achievements-badge-to-get-caffeinated' => 'facer {{PLURAL:$1|unha edición|$1 edicións}} en páxinas nun mesmo día',
	'achievements-badge-to-get-luckyedit' => 'ser afortunado',
	'achievements-badge-to-get-sharing-details' => 'Compartir ligazóns e conseguir que outros preman nelas!',
	'achievements-badge-to-get-edit-details' => 'Falta algo?
Hai algún erro?
Non sexa tímido.
Prema no botón "{{int:edit}}" e engada o que queira en calquera páxina!',
	'achievements-badge-to-get-edit-plus-category-details' => 'As páxinas <strong>$1</strong> necesitan a súa axuda!
Prema sobre o botón "{{int:edit}}" de calquera páxina desa categoría para botar unha man.
Mostre o seu apoio ás páxinas $1!',
	'achievements-badge-to-get-picture-details' => 'Prema sobre o botón "{{int:edit}}" e logo sobre "{{int:rte-ck-image-add}}".
Pode engadir unha foto desde o seu ordenador ou desde outra páxina do wiki.',
	'achievements-badge-to-get-category-details' => 'As categorías son etiquetas que axudan aos lectores a atopar páxinas similares.
Prema sobre o botón "{{int:categoryselect-addcategory-button}}" que hai ao pé de cada páxina para incluír esa páxina nunha categoría.',
	'achievements-badge-to-get-blogpost-details' => 'Dea a súa opinión e faga as súas preguntas!
Prema en "{{int:blogs-recent-url-text}}" na barra lateral e logo na ligazón á esquerda para "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Poña o seu gran de area!
Lea calquera das mensaxe de blogue recentes e escriba o que pensa na caixa de comentarios.',
	'achievements-badge-to-get-love-details' => 'O contador reiníciase se deixa de editar un día. Asegúrese de volver ao wiki todos os días!',
	'achievements-badge-to-get-welcome-details' => 'Prema sobre o botón "{{int:oasis-signup}}" no canto superior dereito para unirse á comunidade.
Pode comezar a gañar as súas propias insignias!',
	'achievements-badge-to-get-introduction-details' => 'A súa páxina de usuario está baleira?
Prema no seu nome de usuario na parte superior da pantalla para comprobalo.
Prema en "{{int:edit}}" para engadir algunha información sobre si mesmo!',
	'achievements-badge-to-get-sayhi-details' => 'Pode deixar mensaxes a outros usuarios premendo en "{{int:addsection}}" nas súas páxinas de conversa.
Pida axuda, agradézalles o seu traballo ou, simplemente, dígalles ola!',
	'achievements-badge-to-get-creator-details' => 'Esta insignia concédeselle á persoa que fundou o wiki.
Prema sobre o botón "{{int:createwiki}}" no canto superior para comezar un sitio sobre o que máis lle guste!',
	'achievements-badge-to-get-pounce-details' => 'Terá que ser rápido para gañar esta insignia.
Prema sobre o botón "{{int:activityfeed}}" para ollar as novas páxinas que os usuarios están a crear!',
	'achievements-badge-to-get-caffeinated-details' => 'Necesitará todo un día para gañar esta insignia.
Non deixe de editar!',
	'achievements-badge-to-get-luckyedit-details' => 'Necesitará ser afortunado para gañar esta insignia.
Non deixe de editar!',
	'achievements-badge-to-get-community-platinum-details' => 'Esta é unha insignia de platino especial que só estará dispoñible por tempo limitado!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|por compartir unha ligazón|por conseguir que {{PLURAL:$1|unha persoa prema|$1 persoas preman}} nas ligazóns compartidas}}',
	'achievements-badge-hover-desc-edit' => 'Premiado por facer $1 {{PLURAL:$1|edición|edicións}}<br />
{{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Premiado por facer $1 {{PLURAL:$1|edición|edicións}}<br />
{{PLURAL:$1|nunha páxina|en páxinas}} $2!',
	'achievements-badge-hover-desc-picture' => 'Premiado por engadir $1 {{PLURAL:$1|imaxe|imaxes}}<br />
{{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-hover-desc-category' => 'Premiado por engadir $1 {{PLURAL:$1|páxina|páxinas}}<br />
a {{PLURAL:$1|unha categoría|categorías}}!',
	'achievements-badge-hover-desc-blogpost' => 'Premiado por escribir $1 {{PLURAL:$1|mensaxe|mensaxes}} de blogue!',
	'achievements-badge-hover-desc-blogcomment' => 'Premiado por escribir un comentario<br />
{{PLURAL:$1|nunha mensaxe|en $1 mensaxes}} de blogue!',
	'achievements-badge-hover-desc-love' => 'Premiado por colaborar no wiki cada día durante {{PLURAL:$1|un día|$1 días}}!',
	'achievements-badge-hover-desc-welcome' => 'Premiado por unirse ao wiki!',
	'achievements-badge-hover-desc-introduction' => 'Premiado por engadir información<br />
á súa páxina de usuario!',
	'achievements-badge-hover-desc-sayhi' => 'Premiado por deixar unha mensaxe<br />
na páxina de conversa de alguén!',
	'achievements-badge-hover-desc-creator' => 'Premiado por crear o wiki!',
	'achievements-badge-hover-desc-pounce' => 'Premiado por facer edicións en 100 páxinas durante a hora seguinte á creación da mesma!',
	'achievements-badge-hover-desc-caffeinated' => 'Premiado por facer 100 edicións en páxinas nun mesmo día!',
	'achievements-badge-hover-desc-luckyedit' => 'Premiado por facer a $1ª edición afortunada no wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Esta é unha insignia de platino especial que só estará dispoñible por tempo limitado!',
	'achievements-badge-your-desc-sharing' => 'Premiado {{#ifeq:$1|0|por compartir unha ligazón|por conseguir que {{PLURAL:$1|unha persoa prema|$1 persoas preman}} nas ligazóns compartidas}}',
	'achievements-badge-your-desc-edit' => 'Premiado por facer {{PLURAL:$1|a súa primeira edición|$1 edicións}} {{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'Premiado por facer {{PLURAL:$1|a súa primeira edición|$1 edicións}} {{PLURAL:$1|nunha páxina|en páxinas}} $2!',
	'achievements-badge-your-desc-picture' => 'Premiado por engadir {{PLURAL:$1|a súa primeira imaxe|$1 imaxes}} {{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-your-desc-category' => 'Premiado por engadir {{PLURAL:$1|a súa primeira páxina|$1 páxinas}} a {{PLURAL:$1|unha categoría|categorías}}!',
	'achievements-badge-your-desc-blogpost' => 'Premiado por escribir {{PLURAL:$1|a súa primeira entrada|$1 entradas}} de blogue!',
	'achievements-badge-your-desc-blogcomment' => 'Premiado por escribir un comentario {{PLURAL:$1|nunha mensaxe|en $1 mensaxes}} de blogue!',
	'achievements-badge-your-desc-love' => 'Premiado por colaborar no wiki cada día durante {{PLURAL:$1|un día|$1 días}}!',
	'achievements-badge-your-desc-welcome' => 'Premiado por unirse ao wiki!',
	'achievements-badge-your-desc-introduction' => 'Premiado por engadir información á súa páxina de usuario!',
	'achievements-badge-your-desc-sayhi' => 'Premiado por deixar unha mensaxe na páxina de conversa de alguén!',
	'achievements-badge-your-desc-creator' => 'Premiado por crear o wiki!',
	'achievements-badge-your-desc-pounce' => 'Premiado por facer edicións en 100 páxinas durante a hora seguinte á creación da mesma!',
	'achievements-badge-your-desc-caffeinated' => 'Premiado por facer 100 edicións en páxinas nun mesmo día!',
	'achievements-badge-your-desc-luckyedit' => 'Premiado por facer a $1ª edición afortunada no wiki!',
	'achievements-badge-desc-sharing' => 'Premiado {{#ifeq:$1|0|por compartir unha ligazón|por conseguir que {{PLURAL:$1|unha persoa prema|$1 persoas preman}} nas ligazóns compartidas}}',
	'achievements-badge-desc-edit' => 'Premiado por facer $1 {{PLURAL:$1|edición|edicións}} {{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-desc-edit-plus-category' => 'Premiado por facer $1 {{PLURAL:$1|edición|edicións}} {{PLURAL:$1|nunha páxina|en páxinas}} $2!',
	'achievements-badge-desc-picture' => 'Premiado por engadir $1 {{PLURAL:$1|imaxe|imaxes}} {{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-desc-category' => 'Premiado por engadir $1 {{PLURAL:$1|páxina|páxinas}} a {{PLURAL:$1|unha categoría|categorías}}!',
	'achievements-badge-desc-blogpost' => 'Premiado por escribir $1 {{PLURAL:$1|mensaxe|mensaxes}} de blogue!',
	'achievements-badge-desc-blogcomment' => 'Premiado por escribir un comentario {{PLURAL:$1|nunha mensaxe|en $1 mensaxes}} de blogue!',
	'achievements-badge-desc-love' => 'Premiado por colaborar no wiki cada día durante {{PLURAL:$1|un día|$1 días}}!',
	'achievements-badge-desc-welcome' => 'Premiado por unirse ao wiki!',
	'achievements-badge-desc-introduction' => 'Premiado por engadir información á súa páxina de usuario!',
	'achievements-badge-desc-sayhi' => 'Premiado por deixar unha mensaxe na páxina de conversa de alguén!',
	'achievements-badge-desc-creator' => 'Premiado por crear o wiki!',
	'achievements-badge-desc-pounce' => 'Premiado por facer edicións en 100 páxinas durante a hora seguinte á creación da mesma!',
	'achievements-badge-desc-caffeinated' => 'Premiado por facer 100 edicións en páxinas nun mesmo día!',
	'achievements-badge-desc-luckyedit' => 'Premiado por facer a $1ª edición afortunada no wiki!',
	'achievements-userprofile-title-no' => 'Insignias gañadas por $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Insignia gañada|Insignias gañadas}} por $1 ($2)',
	'achievements-userprofile-no-badges-owner' => 'Consulte a lista que aparece a continuación para ollar as insignias que pode gañar neste wiki!',
	'achievements-userprofile-no-badges-visitor' => 'Este usuario aínda non gañou ningunha insignia.',
	'achievements-userprofile-profile-score' => '<em>$1</em> puntos<br />de logro',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Posto nº$1]]<br />neste wiki',
);

$messages['grc'] = array(
	'achievements-community-platinum-cancel' => 'Ἀκυροῦν',
);

$messages['he'] = array(
	'achievementsii-desc' => 'מערכת מתן תגי הוכרה למשתמשי ויקי',
	'achievements-upload-error' => 'מצטערים!
התמונה אינה מתאימה.
אנא ודאו כי מדובר בקובץ jpg או png.
אם מדובר באחד מסוגי הקבצים האמורים, יתכן שמדור בקובץ גדול מידי.
אנא נסו להעלות קובץ אחר!',
	'achievements-upload-not-allowed' => 'מפעילי מערכת יכולים לשנות את השם והתמונה של תגי הוכרה על ידי ביקור בדף [[Special:AchievementsCustomize|עיצוב התגים]].',
	'achievements-non-existing-category' => 'הקטגוריה הספציפית אינה קיימת.',
	'right-platinum' => 'יצירה ועריכה של תגי פלטינה',
	'right-sponsored-achievements' => 'ניהול הישגים תחת חסות',
	'achievements-platinum' => 'פלטיניום',
	'achievements-gold' => 'זהב',
	'achievements-silver' => 'כסף',
	'achievements-bronze' => 'ארד',
	'achievements-gold-points' => '
100<br /> נקודות',
	'achievements-silver-points' => '50<br />נקודות',
	'achievements-bronze-points' => '10<br />נקודות',
	'achievements-you-must' => 'יש לבצע $1 על מנת לזכות בתג זה.',
	'leaderboard-button' => 'לוח מובילי ההישגים',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|נקודה|נקודות}}</small>',
	'achievements-profile-title-no' => 'תגי $1',
	'achievements-no-badges' => 'בדקו את הרשימה שלהלן על מנת לראות את התגים אשר תכלו לזכות בהם ב- wiki זה!',
	'achievements-track-name-edit' => 'מסלול העריכה',
	'achievements-track-name-picture' => 'מסלול התמונות',
	'achievements-track-name-category' => 'מסלול הקטגוריות',
	'achievements-track-name-blogpost' => 'מסלול הבלוגים',
	'achievements-track-name-blogcomment' => 'מסלול הערות הבלוגים',
	'achievements-track-name-love' => 'מסלול אהבת ויקי',
	'achievements-track-name-sharing' => 'מסלול השיתוף',
	'achievements-notification-title' => 'כל הכבוד, $1!',
	'achievements-notification-subtitle' => 'זכית בתג "$1", $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|לצפייה בתגים נוספים אשר ניתן לזכות בהם]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|נקודה|נקודות}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|נקודה|נקודות}}',
	'achievements-earned' => '{{PLURAL:$1|משתמש אחד|$1 משתמשים}} קיבלו תג זה.',
	'achievements-profile-title' => '$2 {{PLURAL:$2|התג|התגים}} בהם זכה $1',
	'achievements-profile-title-challenges' => 'ניתן לזכות בתגים נוספים!',
	'achievements-profile-customize' => 'התאמה אישית של תגים',
	'achievements-ranked' => 'מדורג במקום $1 בוויקי זו',
	'achievements-viewall' => 'הצגת הכול',
	'achievements-viewless' => 'סגירה',
	'achievements-profile-title-oasis' => 'הישגים <br /> נקודות',
	'achievements-ranked-oasis' => '$1 [[Special:Leaderboard|מדורג/ת #$2]] בוויקי זה',
	'achievements-viewall-oasis' => 'להצגת הכל',
	'achievements-toggle-hide' => 'להסתרת הישגי המופיעים בפרופיל שלי מייתר המשתמשים',
	'leaderboard-intro-hide' => 'הסתרה',
	'leaderboard-intro-open' => 'פתיחה',
	'leaderboard-intro-headline' => 'מה הם "הישגים"?',
	'leaderboard-intro' => "הנכם יכולים לזכות בתגים בויקי זה באמצעות עריכת דפים, העלאת תמונות, או השארת הערות. כל תג יזכה בנקודות. ככל שתזכו ביותר נקודות, תופיעו במיקום גבוה יותר בלוח ההישגים! ניתן לצפות בתגים בהם זכיתם [[$1|בדף שלכם]].

'''מה שוויים של התגים?'''",
	'leaderboard' => 'לוח מובילי ההישגים',
	'achievements-title' => 'הישגים',
	'leaderboard-title' => 'לוח המובילים',
	'achievements-recent-earned-badges' => 'תגים שהושגו לאחרונה',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />הושג על ידי <a href="$1">$2</a><br />$5',
	'achievements-leaderboard-disclaimer' => 'לוח ההישגים מראה שינויים שבוצעו מאז אתמול',
	'achievements-leaderboard-points-label' => 'נקודות',
	'achievements-leaderboard-points' => '{{PLURAL:$1|נקודה|נקודות}}',
	'achievements-leaderboard-most-recently-earned-label' => 'הורווח לאחרונה',
	'achievements-send' => 'שמירת תמונה',
	'achievements-save' => 'שמירת השינויים',
	'achievements-reverted' => 'התג שוחזר לברירת המחדל.',
	'achievements-customize' => 'התאם אישית את התמונה',
	'achievements-enable-track' => 'פעיל',
	'achievements-revert' => 'שחזור לברירת המחדל',
	'achievements-special-saved' => 'השינויים נשמרו',
	'achievements-special' => 'תגים מיוחדים',
	'achievements-secret' => 'תגים סודיים',
	'achievementscustomize' => 'תגים מותאמים אישית',
	'achievements-about-title' => 'אודות דף זה...',
	'platinum' => 'פלטינה',
	'achievements-community-platinum-edit' => 'עריכה',
	'achievements-community-platinum-save' => 'שמירה',
	'achievements-community-platinum-cancel' => 'ביטול',
	'achievements-badge-name-edit-4' => 'משתף/פת',
	'achievements-badge-name-edit-5' => 'בונה ויקי',
	'achievements-badge-name-edit-6' => 'מנהיג/ת ויקי',
	'achievements-badge-name-edit-7' => 'מומחה/ית ויקי',
	'achievements-badge-name-picture-0' => 'צילום בזק',
	'achievements-badge-name-picture-1' => 'פפראצי',
	'achievements-badge-name-picture-2' => 'מאייר/ת',
	'achievements-badge-name-picture-3' => 'אספן/נית',
	'achievements-badge-name-picture-4' => 'אוהב/ת אמנות',
	'achievements-badge-name-picture-5' => 'מעצב/ת',
	'achievements-badge-name-picture-6' => 'מתכנן/נת',
	'achievements-badge-name-picture-7' => 'אוצר/ת',
	'achievements-badge-name-introduction' => 'מבוא',
	'achievements-badge-your-desc-edit' => 'עבור ביצוע {{PLURAL:$1|העריכה הראשונה|$1 העריכות}} ב{{PLURAL:$1|דף|דפים}}!',
);

$messages['hi'] = array(
	'achievements-upload-error' => 'क्षमा करें!
वह तस्वीर काम नहीं करता है!
सुनिश्चित करें कि यह एक .jpg या .png फ़ाइल है!
अगर यह अभी भी काम नहीं करता है, तो चित्र बहुत बड़ा हो सकता है!
कृपया पुनः प्रयास करें!',
	'achievements-gold' => 'स्वर्ण',
	'achievements-silver' => 'रजत',
	'achievements-bronze' => 'कांस्य',
	'achievements-you-must' => 'इस बैज अर्जित करने के लिए आपको $1 की जरूरत है।',
);

$messages['hu'] = array(
	'achievementsii-desc' => 'Eredményalapú jelvényrendszer a wiki felhasználói számára',
	'achievements-upload-error' => 'Hoppá!

Ez a kép nem megfelelő.

Ellenőrizd, hogy .jpg vagy .png fájl-e. Ha még mindig nem működik, valószínűleg túl nagy méretű, amely esetben próbálj meg egy másikat feltölteni.',
	'achievements-upload-not-allowed' => 'Az adminisztrátorok megváltoztathatják a jelvények nevét és illusztrációját a [[Special:AchievementsCustomize|jelvényszerkesztő oldal]] használatával.',
	'achievements-non-existing-category' => 'A megadott kategória nem létezik.',
	'achievements-edit-plus-category-track-exists' => 'A megadott kategória már rendelkezik egy <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">társított jelvénysávval</a>.',
	'achievements-no-stub-category' => 'Kérlek, ne csinálj sávot csonk szócikkeknek.',
	'right-platinum' => 'Platinajelvények készítése és szerkesztése',
	'right-sponsored-achievements' => 'Szponzorált jelvények kezelése',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Arany',
	'achievements-silver' => 'Ezüst',
	'achievements-bronze' => 'Bronz',
	'achievements-gold-points' => '100<br />pont',
	'achievements-silver-points' => '50<br />pont',
	'achievements-bronze-points' => '10<br />pont',
	'achievements-you-must' => 'A jelvény megszerzéséhez $1.',
	'leaderboard-button' => 'Eredmények toplistája',
	'achievements-masthead-points' => '$1 <small>pont</small>',
	'achievements-profile-title-no' => '$1 jelvényei',
	'achievements-no-badges' => 'Tekintsd meg a lenti listát, hogy megismerhesd a wikin megszerezhető jelvényeket!',
	'achievements-track-name-edit' => 'Szerkesztési sáv',
	'achievements-notification-title' => 'Csak így tovább, $1!',
	'achievements-notification-subtitle' => 'Megszerezted az "$1" jelvényt, $2',
	'achievements-notification-link' => '<span style="font: bold larger Arial;">Tekintsd meg a többi elérhető jelvényt!</span>',
	'achievements-points' => '$1 pont',
	'achievements-points-with-break' => '$1<br />pont',
	'achievements-earned' => 'Ezt a jelvényt {{PLURAL:$1|egy|$1}} felhasználó kapta meg.',
	'achievements-profile-title' => '$1 $2 jelvényt szerzett',
	'achievements-profile-title-challenges' => 'Még több megszerezhető jelvény!',
	'achievements-profile-customize' => 'Jelvények testreszabása',
	'achievements-ranked' => '$1. helyezett a wikin',
	'achievements-viewall' => 'Összes megtekintése',
	'achievements-viewless' => 'Bezárás',
	'achievements-ranked-oasis' => '$1 [[Special:Leaderboard|$2. helyezett]] ezen a wikin',
	'achievements-viewall-oasis' => 'Összes megtekintése',
	'achievements-toggle-hide' => 'Az oldalamon lévő jelvények elrejtése mindenki elől',
	'leaderboard-intro-hide' => 'elrejtés',
	'leaderboard-intro-open' => 'kinyit',
	'leaderboard-intro-headline' => 'Mik a kitüntetések?',
	'leaderboard-intro' => "A wikin oldalak szerkesztésével, képek feltöltésével és hozzászólások írásával szerezhetsz jelvényeket. Minden jelvény pontokat ér&mdash;minél több pontot szerzel, annál magasabbra jutsz a toplistán! A már a birtokodban lévő jelvényeket megtekintheted [[$1|a profilodon]].

	'''Mennyit érnek a jelvények?'''",
	'leaderboard' => 'Eredmények toplistája',
	'achievements-title' => 'Kitüntetések',
	'leaderboard-title' => 'Ranglista',
	'achievements-recent-earned-badges' => 'Legutóbb megszerzett jelvények',
	'achievements-recent-info' => '<strong>$3</strong><br />$4</br /> megszerezte: <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'megszerezte a <a href="$3" class="badgeName" style="font-weight: bold;">$1</a> jelvényt<br />$2',
	'achievements-leaderboard-disclaimer' => 'A ranglista a tegnap óta történt változtatásokat mutatja',
	'achievements-leaderboard-rank-label' => 'Rang',
	'achievements-leaderboard-member-label' => 'Tag',
	'achievements-leaderboard-points-label' => 'Pontok',
	'achievements-leaderboard-points' => 'pont',
	'achievements-leaderboard-most-recently-earned-label' => 'Legfrissebb jelvény',
	'achievements-send' => 'Kép mentése',
	'achievements-save' => 'Változtatások mentése',
	'achievements-reverted' => 'A jelvény eredetije vissza lett állítva.',
	'achievements-customize' => 'Kép megváltoztatása',
	'achievements-customize-new-category-track' => 'Új sáv készítése a kategóriához:',
	'achievements-enable-track' => 'engedélyezve',
	'achievements-revert' => 'Alapértelmezések visszaállítása',
	'achievements-special-saved' => 'Változtatások elmentve.',
	'achievements-special' => 'Speciális kitüntetések',
	'achievements-secret' => 'Titkos kitüntetések',
	'achievementscustomize' => 'Jelvények megváltoztatása',
	'achievements-about-title' => 'Információk a lapról...',
	'achievements-about-content' => 'A wiki adminisztrátorai megváltoztathatják a jelvények nevét és a hozzátartozó képet.

Bármilyen .jpg vagy .png fájl megfelel&mdash;a kép automatikusan illeszkedni fog a keretbe.
Akkor a legjobb, ha a kép négyzetes és a legfontosabb része középen van.

Használhatsz téglalap alakú képeket is, de ezeknek egy részét elrejtheti a keret.
Ha van képszerkesztő programod, a kép vágásával középre helyezheted a fontos tartalmat.
Ha nem rendelkezel képszerkesztővel, próbálkozz különböző képekkel, amíg meg nem találod a legjobbakat!
Ha nem tetszik a kiválasztott kép, kattints "{{int:achievements-revert}}" hogy visszaállítsd az eredetit.

A jelvényeket át is nevezheted, hogy tükrözzék a wiki témáját.
Miután megváltoztattad a neveket, kattints "{{int:achievements-save}}" a változtatások elmentéséhez.
Élvezd!',
	'achievements-create-edit-plus-category-content' => 'Itt létrehozhatsz egy új jelvénykészletet egy bizonyos kategória tagjait szerkesztők jutalmazására, hogy az oldalnak egy élvezhetően módosítható részét előtérbe helyezd.
Több mint egy kategóriasávot is felállíthatsz; próbálj meg két olyat választani, amelyekben a felhasználók megmutathatják erősségeiket!
Hozz létre rivalizálást a vámpírok és a vérfarkasok vagy az Autobotok és Decepticonok szerkesztői között.

Az új sáv készítéséhez gépeld be a kategória nevét a lenti mezőbe.
Az általános szerkesztési sáv megmarad;
a most megteremtett sáv függetlenül változtatható.

A sáv létrejöttekor az új jelvények a baloldali listában fognak megjelenni, az általános szerkesztési sáv alatt.
Változtasd meg az új sáv képeit és leírásait, hogy könnyebben észrevehető legyen a különbség!

Ha befejezted a módosításaidat, kattints a "{{int:achievements-enable-track}}" jelölőnégyzetbe az új sáv bekapcsolásához, majd kattints a "{{int:achievements-save}}" gombra.
A felhasználók profiljain ezután megjelenik az új sáv és jelvényeket fognak gyűjteni az adott kategória tartalmainak szerkesztésekor.
Lésőbb, ha már nem akarod a kategóriát kiemelni, kikapcsolhatod a sávot.
A sávban jelvényeket szerzett felhasználók minding meg fogják tartani azokat&mdash;a sáv kikapcsolása után is.

Ez az eredményalapú jelvényrendszerben új, vicces szintet állíthat be.
Próbáld ki!',
	'achievements-create-edit-plus-category' => 'Sáv létrehozása',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'Szereztél egy új platinajelvényt!',
	'achievements-community-platinum-awarded-email-body-text' => 'Gratulálunk, $1!

Épp most kaptad meg a(z) $2 platina jelvényt a következő wikin: $4 ($3)
A pontjaid száma így 250-nel nőtt!

Az új jelvényedet a profiloldaladon tekintheted meg:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Gratulálunk, $1!</strong><br /><br />
Megszerezted a \'<strong>$2</strong>\' platinajelvényt a <a href="$3">$4</a>-n.
Ez 250 ponttal növeli eddigi eredményeidet!<br /><br />
Nézd meg az új jelvényedet <a href="$5">a profilodon</a>.',
	'achievements-community-platinum-awarded-for' => 'Kiadás oka:',
	'achievements-community-platinum-how-to-earn' => 'Hogyan szerezhető meg:',
	'achievements-community-platinum-awarded-for-example' => 'pl. "&hellip;elvégzéséért"',
	'achievements-community-platinum-how-to-earn-example' => 'pl. "végezz el 3 szerkesztést&hellip;"',
	'achievements-community-platinum-badge-image' => 'Jelvény képe:',
	'achievements-community-platinum-awarded-to' => 'Díjazott:',
	'achievements-community-platinum-current-badges' => 'Jelenlegi platina jelvények',
	'achievements-community-platinum-create-badge' => 'Jelvény létrehozása',
	'achievements-community-platinum-enabled' => 'engedélyezve',
	'achievements-community-platinum-show-recents' => 'megjelenítés a legutóbbi jelvények között',
	'achievements-community-platinum-edit' => 'szerkesztés',
	'achievements-community-platinum-save' => 'mentés',
	'achievements-community-platinum-cancel' => 'mégse',
	'achievements-community-platinum-sponsored-label' => 'Szponzorált kitüntetés',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Kattints ide több információért',
	'achievements-badge-name-edit-1' => 'Csak a kezdet',
	'achievements-badge-name-edit-3' => 'A wiki barátja',
	'achievements-badge-name-edit-4' => 'Közreműködő',
	'achievements-badge-name-edit-5' => 'Wikiszerkesztő',
	'achievements-badge-name-edit-6' => 'Wikivezető',
	'achievements-badge-name-edit-7' => 'Wikiszakértő',
	'achievements-badge-name-picture-0' => 'Pillanatfelvétel',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illusztrátor',
	'achievements-badge-name-picture-3' => 'Gyűjtő',
	'achievements-badge-name-picture-4' => 'Művészetimádó',
	'achievements-badge-name-picture-5' => 'Díszlettervező',
	'achievements-badge-name-picture-6' => 'Tervező',
	'achievements-badge-name-picture-7' => 'Kurátor',
	'achievements-badge-name-category-0' => 'Kapcsolat létrehozása',
	'achievements-badge-name-category-1' => 'Úttörő',
	'achievements-badge-name-category-2' => 'Felfedező',
	'achievements-badge-name-category-3' => 'Idegenvezető',
	'achievements-badge-name-category-4' => 'Navigátor',
	'achievements-badge-name-category-5' => 'Hídépítő',
	'achievements-badge-name-category-6' => 'Wikitervező',
	'achievements-badge-name-blogpost-0' => 'Van mondanivalója',
	'achievements-badge-name-blogpost-1' => 'Van pár mondanivalója',
	'achievements-badge-name-blogpost-2' => 'Talkshow',
	'achievements-badge-name-blogpost-3' => 'A parti lelke',
	'achievements-badge-name-blogpost-4' => 'Nyilvános hangszóró',
	'achievements-badge-name-blogcomment-0' => 'Véleménynyilvánító',
	'achievements-badge-name-blogcomment-1' => 'És még egy dolog',
	'achievements-badge-name-love-0' => 'Kulcs a wikihez!',
	'achievements-badge-name-love-1' => 'Két hete a wikin',
	'achievements-badge-name-love-2' => 'Odaadó',
	'achievements-badge-name-love-3' => 'Elkötelezett',
	'achievements-badge-name-love-4' => 'Függő',
	'achievements-badge-name-love-5' => 'Wikis élet',
	'achievements-badge-name-love-6' => 'A wiki hőse!',
	'achievements-badge-name-sharing-0' => 'Megosztó',
	'achievements-badge-name-sharing-1' => 'Hozd vissza',
	'achievements-badge-name-sharing-2' => 'Beszélő',
	'achievements-badge-name-sharing-3' => 'Bemondó',
	'achievements-badge-name-sharing-4' => 'Evangélista',
	'achievements-badge-name-welcome' => 'Üdvözlünk a Wikin',
	'achievements-badge-name-introduction' => 'Bevezetés',
	'achievements-badge-name-creator' => 'A Teremtő',
	'achievements-badge-name-caffeinated' => 'Koffeinezett',
	'achievements-badge-name-luckyedit' => 'Szerencsés szerkesztés',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|hivatkozás megosztása|vegyél rá {{PLURAL:$1|egy személyt|$1 embert}} az általad megosztott hivatkozás megtekintésére}}',
	'achievements-badge-to-get-edit' => 'végezz el $1 szerkesztést {{PLURAL:$1|egy|több}} szócikken',
	'achievements-badge-to-get-edit-plus-category' => 'végezz {{PLURAL:$1|egy|$1}} szerkesztést {{PLURAL:$1|egy $2 oldalon|$2 oldalakon}}',
	'achievements-badge-to-get-picture' => 'Adj hozzá $1 képet {{PLURAL:$1|egy oldalhoz|néhány oldalhoz}}',
	'achievements-badge-to-get-category' => 'Helyezz el $1 lapot {{PLURAL:$1|egy kategóriában|kategóriákban}}',
	'achievements-badge-to-get-blogpost' => 'írj $1 blogbejegyzést',
	'achievements-badge-to-get-blogcomment' => 'szólj hozzá {{PLURAL:$1|egy blogbejegyzéshez|$1 blogbejegyzéshez}}',
	'achievements-badge-to-get-love' => 'tevékenykedj a wikin mindennap $1 napon keresztül',
	'achievements-badge-to-get-welcome' => 'csatlakozz a wikihez',
	'achievements-badge-to-get-introduction' => 'Adj hozzá a felhasználói oldaladhoz',
	'achievements-badge-to-get-sayhi' => 'Hagyj üzenetet valaki vitalapján',
	'achievements-badge-to-get-creator' => 'Hozd létre ezt a wikit',
	'achievements-badge-to-get-pounce' => 'Légy gyors',
	'achievements-badge-to-get-caffeinated' => 'végezz $1 szerkesztést egy nap alatt',
	'achievements-badge-to-get-luckyedit' => 'Légy szerencsés',
	'achievements-badge-to-get-sharing-details' => 'Ossz meg hivatkozásokat és vegyél rá másokat, hogy kattintsanak rájuk!',
	'achievements-badge-to-get-edit-details' => 'Valami hiányzik?
Hiba van a szövegben?
Ne légy visszahúzódó.
Kattints a "{{int:edit}}" gombra és bármelyik oldalt szerkesztheted!',
	'achievements-badge-to-get-edit-plus-category-details' => 'A(z) <strong>$1</strong> oldalaknak szükségük van rád!
Kattints a "{{int:edit}}" gombra a kategória bármelyik oldalán, hogy segíts.
Mutasd meg, hogy támogatod a(z) $1 oldalakat!',
	'achievements-badge-to-get-picture-details' => "Kattins a ''{{int:edit}}'', majd a ''{{int:rte-ck-image-add}}'' gombra.
Ezzel hozzáaddhatsz egy képet a számítógépedről vagy a wiki egy másik lapjáról.",
	'achievements-badge-to-get-category-details' => "A kategóriák címkék, amelyek segítik az olvasókat a hasonló oldalak megtalálásában.
Kattints a ''{{int:categoryselect-addcategory-button}}'' gombra az oldal alján hogy hozzáadd az oldalt egy kategóriához.",
	'achievements-badge-to-get-blogpost-details' => 'Írd meg véleményedet és kérdéseidet!
Kattints a "{{int:blogs-recent-url-text}}" hivatkozásra az oldalsávban, majd a baloldali linkre, hogy "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-love-details' => 'A számláló nullázódik, ha kihagysz egy napot, úgyhogy térj vissza a wikihez minden nap!',
	'achievements-badge-to-get-welcome-details' => 'Kattints a "{{int:oasis-signup}}" gombra a jobb felső sarokban a közösséghez való csatlakozáshoz&mdash;így elkezdhetsz jelványeket gyűjteni!',
	'achievements-badge-to-get-introduction-details' => 'Üres a felhasználói lapod?
Kattints a felhasználónevedre a képernyő tetején az ellenőrzéshez.
Klikkelj a "{{int:edit}}"  gombra, hogy információt addhass meg magadról!',
	'achievements-badge-to-get-sayhi-details' => 'Más felhasználóknak a vitalapjukon lévő "{{int:addsection}}" gomb segítségével hagyhatsz üzenetet.
Kérj segítséget, köszönd meg munkájukat vagy csak üdvözöld őket!',
	'achievements-badge-to-get-creator-details' => 'Ezt a jelvényt a wikit alapító személy kapja.
Kattints a "{{int:createwiki}}" gombra az oldal tetején, hogy wikit indíts arról, amit a legjobban kedvelsz!',
	'achievements-badge-to-get-pounce-details' => 'Gyorsnak kell lenned ezen jelvény megszerzéséhez.
Kattints az "{{int:activityfeed}}" gombra az újonnan készített oldalak megtekintéséhez!',
	'achievements-badge-to-get-caffeinated-details' => 'Egy szorgos nap kell ennek a jelvénynek a megszerzéséhez.
Folytasd a szerkesztést!',
	'achievements-badge-to-get-luckyedit-details' => 'Szerencsésnek kell lenned ezen jelvény megkaparintásához.
Folytasd a szerkesztést!',
	'achievements-badge-to-get-community-platinum-details' => 'Ez egy korlátozott ideig elérhető platinajelvény!',
	'achievements-badge-hover-desc-edit' => 'Odaítélve $1 szerkesztés elvégzéséért<br />{{PLURAL:$1|egy oldalon|több oldalon}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Odaítélve $1 szerkesztés elvégzéséért<br />
{{PLURAL:$1|egy $2 oldalon|$2 oldalakon}}!',
	'achievements-badge-hover-desc-picture' => 'Megadva $1 kép {{PLURAL:$1|egy oldalra|több oldalra}}<br />
történő hozzáadásáért!',
	'achievements-badge-hover-desc-category' => 'amelyet $1 lap {{PLURAL:$1|egy kategóriába|több kategóriába}}<br />
történő besorolásáért adományoztak neked!',
	'achievements-badge-hover-desc-blogpost' => 'amelyet $1 blogbejegyzés írásáért kaptál!',
	'achievements-badge-hover-desc-blogcomment' => 'amelyet $1 különböző blogbejegyzéshez<br />
történő hozzászóláshért kaptál!',
	'achievements-badge-hover-desc-love' => 'amelyet a wikin való $1 napos részvételért kaptál!',
	'achievements-badge-hover-desc-welcome' => 'amelyet a wikihez való csatlakozásért kaptál!',
	'achievements-badge-hover-desc-introduction' => 'amelyet a saját felhasználói lapod<br />
szerkesztéséért kaptál!',
	'achievements-badge-hover-desc-sayhi' => 'amelyet egy<br />
más vitalapján hagyott üzenetért kaptál!',
	'achievements-badge-hover-desc-creator' => 'amelyet a wiki létrehozásáért kaptál!',
	'achievements-badge-hover-desc-pounce' => 'amelyet 100 oldal az azok létrehozását követő egy órában végrehajtott szerkesztéséért kaptál!',
	'achievements-badge-hover-desc-caffeinated' => 'amelyet az egy nap alatt végzett 100 szerkesztésért kaptál!',
	'achievements-badge-hover-desc-luckyedit' => 'amelyet a szerencsés $1. szerkesztés elvégzéséért kaptál!',
	'achievements-badge-hover-desc-community-platinum' => 'Ez egy különleges, csak korlátozott ideig elérhető platinajelvény!',
	'achievements-badge-your-desc-edit' => 'amelyet {{PLURAL:$1|az első szerkesztésed|$1 szerkesztés}} {{PLURAL:$1|egy oldalon|az oldalakon}} történő elvégzéséért kaptál!',
	'achievements-badge-your-desc-edit-plus-category' => 'amelyet {{PLURAL:$1|az első szerkesztésed|$1 szerkesztés}} {{PLURAL:$1|egy $2 oldalon|$2 oldalakon}} történő elvégzéséért kaptál!',
	'achievements-badge-your-desc-picture' => 'amelyet {{PLURAL:$1|az első képed|$1 képnek}} {{PLURAL:$1|egy oldalra|az oldalakra}} való hozzáadásáért kaptál!',
	'achievements-badge-your-desc-category' => 'amelyet {{PLURAL:$1|egy|több}} oldalnak {{PLURAL:$1|egy kategóriával|kategóriákkal}} történő ellátásáért kaptál!',
	'achievements-badge-your-desc-blogpost' => 'amelyet {{PLURAL:$1|az első blogbejegyzésed|$1 blogbejegyzés}} írásáért kaptál!',
	'achievements-badge-your-desc-blogcomment' => 'amelyet {{PLURAL:$1|egy blogbejegyzéshez|$1 blogbejegyzéshez}} történő hozzászólásért kaptál!',
	'achievements-badge-your-desc-love' => 'amelyet a wikin való {{PLURAL:$1|egy|$1}} napos részvételedért kaptál!',
	'achievements-badge-your-desc-welcome' => 'amelyet a wikihez való csatlakozásért kaptál!',
	'achievements-badge-your-desc-introduction' => 'amelyet a felhasználói lapod megtöltéséért kaptál!',
	'achievements-badge-your-desc-sayhi' => 'amelyet azért katpál, mert üzenetet hagytál valaki más vitalapján!',
	'achievements-badge-your-desc-creator' => 'amelyet a wiki létrehozásáért kaptál!',
	'achievements-badge-your-desc-pounce' => 'amelyet 100 oldalnak az azok létrehozását követő egy órában végrehajtott szerkesztéséért kaptál!',
	'achievements-badge-your-desc-caffeinated' => 'amelyet az oldalakon egy nap alatt végzett 100 szerkesztésért kaptál!',
	'achievements-badge-your-desc-luckyedit' => 'amelyet a szerencsés $1. szerkesztés elvégzéséért kaptál!',
	'achievements-badge-desc-edit' => 'amelyet {{PLURAL:$1|az első cikkeken végzett szerkesztésed|$1 cikkeken végzett szerkesztés}} elvégzéséért kaptál!',
	'achievements-badge-desc-picture' => 'amelyet $1 kép {{PLURAL:$1|egy cikkhez|cikkekhez}} történő hozzáadásáért kaptál!',
	'achievements-badge-desc-category' => 'amelyet $1 cikk {{PLURAL:$1|egy kategóriába|több kategóriába}} történő besorolásáért kaptál!',
	'achievements-badge-desc-blogpost' => 'amelyet $1 blogbejegyzés írásáért kaptál!',
	'achievements-badge-desc-blogcomment' => 'amelyet {{PLURAL:$1|egy blogbejegyzéshez|$1 különböző blogbejegyzéshez}} történő hozzászólásért kaptál!',
	'achievements-badge-desc-love' => 'amelyet a wikin való $1 napos folyamatos részvételért kaptál!',
	'achievements-badge-desc-welcome' => 'amelyet a wikihez való csatlakozásért kaptál!',
	'achievements-badge-desc-introduction' => 'amelyet a felhasználói lapod megtöltéséért kaptál!',
	'achievements-badge-desc-sayhi' => 'amelyet azért kaptál, mert üzenetet hagytál valaki más vitalapján!',
	'achievements-badge-desc-creator' => 'amelyet a wiki létrehozásáért kaptál!',
	'achievements-badge-desc-pounce' => 'amelyet 100 oldalnak az azok létrehozását követő egy órában végrehajtott szerkesztéséért kaptál!',
	'achievements-badge-desc-caffeinated' => 'amelyet az oldalakon egy nap alatt végzett 100 szerkesztésért kaptál!',
	'achievements-badge-desc-luckyedit' => 'amelyet a szerencsés $1. szerkesztés elvégzéséért kaptál!',
	'achievements-userprofile-title-no' => '$1 megszerzett jelvényei',
	'achievements-userprofile-title' => '$1 megszerzett jelvénye{{PLURAL:$2||i}} ($2)',
	'achievements-userprofile-no-badges-owner' => 'Tekintsd meg a lenti listát, hogy megismerhesd a wikin megszerezhető jelvényeket!',
	'achievements-userprofile-no-badges-visitor' => 'Ennek a felhasználónak még nincsenek jelvényei.',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|$1. helyezett]]<br />ezen a wikin.',
);

$messages['ia'] = array(
	'achievementsii-desc' => 'Un systema de insignias de merito pro usatores del wiki',
	'achievements-upload-error' => 'Guai!
Iste imagine non functiona.
Assecura te que illo es un file .jpg o .png.
Si illo sempre non functiona, alora le imagine pote esser troppo grande.
Per favor essaya un altere!',
	'achievements-upload-not-allowed' => 'Le administratores pote cambiar le nomines e imagines del insignias de merito visitante le pagina pro [[Special:AchievementsCustomize|personalisation de insignias]].',
	'achievements-non-existing-category' => 'Le categoria specificate non existe.',
	'achievements-edit-plus-category-track-exists' => 'Le categoria specificate ha ja un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Ir al tracia">tracia associate</a>.',
	'achievements-no-stub-category' => 'Per favor non crea tracias pro peciettas.',
	'right-platinum' => 'Crear e modificar insignias de Platino',
	'right-sponsored-achievements' => 'Gerer realisationes sponsorisate',
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Auro',
	'achievements-silver' => 'Argento',
	'achievements-bronze' => 'Bronzo',
	'achievements-gold-points' => '100<br />pts',
	'achievements-silver-points' => '50<br />pts',
	'achievements-bronze-points' => '10<br />pts',
	'achievements-you-must' => 'Tu debe $1 pro ganiar iste insignia.',
	'leaderboard-button' => 'Classamento de successos',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|puncto|punctos}}</small>',
	'achievements-profile-title-no' => 'Le insignias de $1',
	'achievements-no-badges' => 'Reguarda le lista hic infra pro vider le insignias que tu pote ganiar in iste wiki!',
	'achievements-track-name-edit' => 'Tracia de modification',
	'achievements-track-name-picture' => 'Tracia de imagines',
	'achievements-track-name-category' => 'Tracia de categorias',
	'achievements-track-name-blogpost' => 'Tracia de articulos de blog',
	'achievements-track-name-blogcomment' => 'Tracia de commentos de blog',
	'achievements-track-name-love' => 'Tracia de amor wiki',
	'achievements-track-name-sharing' => 'Carriera de condivision',
	'achievements-notification-title' => 'Va ben, $1!',
	'achievements-notification-subtitle' => 'Tu ha justo ganiate le insignia "$1" $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Clicca hic pro vider plus insignias que tu pote meritar]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|puncto|punctos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|puncto|punctos}}',
	'achievements-earned' => 'Iste insignia ha essite ganiate per {{PLURAL:$1|1 usator|$1 usatores}}.',
	'achievements-profile-title' => 'Le $2 {{PLURAL:$2|insignia|insignias}} ganiate per $1',
	'achievements-profile-title-challenges' => 'Plus insignias que tu pote ganiar!',
	'achievements-profile-customize' => 'Personalisar insignias',
	'achievements-ranked' => 'Ha le rango №$1 in iste wiki',
	'achievements-viewall' => 'Vider toto',
	'achievements-viewless' => 'Clauder',
	'achievements-profile-title-oasis' => 'punctos <br /> de merito',
	'achievements-ranked-oasis' => '$1 ha le [[Special:Leaderboard|rango №$2]] in iste wiki',
	'achievements-viewall-oasis' => 'Vider totes',
	'achievements-toggle-hide' => 'Celar mi successos sur mi profilo pro tote le mundo',
	'leaderboard-intro-hide' => 'celar',
	'leaderboard-intro-open' => 'aperir',
	'leaderboard-intro-headline' => 'Que es Successos?',
	'leaderboard-intro' => "Tu pote ganiar insignias in iste wiki per modificar articulos, incargar photos e lassar commentos. Con cata insignia, tu gania punctos. Quanto plus punctos tu recipe, tanto plus alte tu position in le classamento! Le insignias que tu ha ganiate se trova in tu [[$1|profilo de usator]].

'''Quanto vale le insignias?'''",
	'leaderboard' => 'Classamento de successos',
	'achievements-title' => 'Successos',
	'leaderboard-title' => 'Classamento',
	'achievements-recent-earned-badges' => 'Insignias recentemente ganiate',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />ganiate per <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'ganiava le insignia <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Le classamento monstra le cambios depost heri',
	'achievements-leaderboard-rank-label' => 'Rango',
	'achievements-leaderboard-member-label' => 'Membro',
	'achievements-leaderboard-points-label' => 'Punctos',
	'achievements-leaderboard-points' => '{{PLURAL:$1|puncto|punctos}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Ganiate le plus recentemente',
	'achievements-send' => 'Salveguardar imagine',
	'achievements-save' => 'Confirmar modificationes',
	'achievements-reverted' => 'Insignia revertite al original.',
	'achievements-customize' => 'Personalisar imagine',
	'achievements-customize-new-category-track' => 'Crea un nove tracia pro le categoria:',
	'achievements-enable-track' => 'activate',
	'achievements-revert' => 'Reverter al original',
	'achievements-special-saved' => 'Cambios salveguardate.',
	'achievements-special' => 'Successos special',
	'achievements-secret' => 'Successos secrete',
	'achievementscustomize' => 'Personalisar insignias',
	'achievements-about-title' => 'A proposito de iste pagina…',
	'achievements-about-content' => 'Le administratores de iste wiki pote personalisar le nomines e imagines del insignias de merito.

Tu pote incargar qualcunque imagine .jpg o .png, e le imagine essera automaticamente redimensionate pro vader in le quadro.
Isto functiona melio si le imagine es quadrate, e si le parte le plus importante del imagine es justo in le medio.

Es possibile usar imagines rectangular, ma tu poterea trovar que un parte essera taliate per le quadro.
Si tu ha un programma graphic, tu pote taliar le imagine pro positionar le parte importante del imagine in le centro.
Si tu non ha un programma graphic, alora simplemente experimenta con differente imagines usque tu trova illos que functiona pro te!
Si non te place le imagine que tu ha seligite, clicca super "{{int:achievements-revert}}" pro retornar al imagine original.

Tu pote etiam dar nove nomines al insignias que reflecte le thema del wiki. Si tu ha cambiate le nomines del insignias, clicca super "{{int:achievements-save}}" pro salveguardar tu cambios.
Bon divertimento!',
	'achievements-edit-plus-category-track-name' => '$1 tracia de modificationes',
	'achievements-create-edit-plus-category-title' => 'Crear un nove tracia de modificationes',
	'achievements-create-edit-plus-category-content' => 'Tu pote crear un nove collection de insignias que premia le usatores pro haber modificate paginas in un particular categoria, pro mitter in evidentia un particular area del sito al qual le usatores volerea laborar.
Tu pote installar plus de un sol tracia de categorias, dunque tenta seliger duo categorias que adjutarea le usatores a demonstrar lor specialitate!
Igni un rivalitate inter le usatores que modifica paginas super Vampires e le usatores que modifica paginas super Lycanthropos, o inter Magos e Muggles, o inter Esperanto e Interlingua.

Pro crear un nove tracia de "Modificar in categoria", entra le nomine del categoria in le campo hic infra.
Le tracia normal de "Modificar" continuara a exister;
isto creara un tracia separate que tu pote personalisar separatemente.

Quando le tracia ha essite create, le nove insignias apparera in le lista al sinistra, sub le tracia normal de "Modificar". Personalisa le nomines e imagines pro le nove tracia, de sorta que le usatores pote vider le differentia!

Un vice que tu ha facite le personalisation, clicca super le quadrato "{{int:achievements-enable-track}}" pro activar le nove tracia, e postea clicca super "{{int:achievements-save}}".
Le usatores videra le nove tracia apparer in lor profilos de usator, e illes comenciara a meritar insignias quando illes modifica paginas in iste categoria.
Tu pote etiam disactivar le tracia plus tarde, si tu decide que tu non vole plus mitter iste categoria in evidentia.
Le usatores que ha meritate insignias in tal tracia retenera sempre lor insignias, mesmo si le tracia ha essite activate.

Isto pote adjutar a portar un altere nivello de divertimento al insignias de merito.
Proba lo!',
	'achievements-create-edit-plus-category' => 'Crear iste tracia',
	'platinum' => 'Platino',
	'achievements-community-platinum-awarded-email-subject' => 'Tu ha meritate un nove insignia de Platino!',
	'achievements-community-platinum-awarded-email-body-text' => "Felicitationes, $1!

Tu ha justo recipite le insignia de Platino '$2' in $4 ($3). Isto adde 250 punctos a tu score!

Reguarda tu nove insignia fantastic in le pagina de tu profilo de usator:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Felicitationes, $1!</strong><br /><br />
Tu ha justo recipite le insignia de Platino \'<strong>$2</strong>\' in <a href="$3">$4</a>. Isto adde 250 punctos a tu score!<br /><br />
Reguarda tu nove insignia fantastic in le <a href="$5">pagina de tu profilo de usator</a>.',
	'achievements-community-platinum-awarded-for' => 'Meritate pro:',
	'achievements-community-platinum-how-to-earn' => 'Como meritar:',
	'achievements-community-platinum-awarded-for-example' => 'p.ex. "pro haber facite..."',
	'achievements-community-platinum-how-to-earn-example' => 'p.ex. "facer 3 modificationes..."',
	'achievements-community-platinum-badge-image' => 'Imagine del insignia:',
	'achievements-community-platinum-awarded-to' => 'Attribuite a:',
	'achievements-community-platinum-current-badges' => 'Insignias de platino actual',
	'achievements-community-platinum-create-badge' => 'Crear insignia',
	'achievements-community-platinum-enabled' => 'activate',
	'achievements-community-platinum-show-recents' => 'monstrar in insignias recente',
	'achievements-community-platinum-edit' => 'modificar',
	'achievements-community-platinum-save' => 'salveguardar',
	'achievements-community-platinum-cancel' => 'cancellar',
	'achievements-community-platinum-sponsored-label' => 'Realisation sponsorisate',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Imagine flottante <small>(dimension minime: 270&nbsp;×&nbsp;100 pixels)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'URL pro traciar impressiones de insignia:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'URL pro traciar impressiones de imagine flottante:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Ligamine al insignia <small>(URL del commando de clic DART)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Clicca pro plus informationes',
	'achievements-badge-name-edit-0' => 'Facer le differentia',
	'achievements-badge-name-edit-1' => 'Solmente le initio',
	'achievements-badge-name-edit-2' => 'Lassar tu marca',
	'achievements-badge-name-edit-3' => 'Amico del wiki',
	'achievements-badge-name-edit-4' => 'Collaborator',
	'achievements-badge-name-edit-5' => 'Constructor del wiki',
	'achievements-badge-name-edit-6' => 'Leader del wiki',
	'achievements-badge-name-edit-7' => 'Experto del wiki',
	'achievements-badge-name-picture-0' => 'Instantaneo',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illustrator',
	'achievements-badge-name-picture-3' => 'Collector',
	'achievements-badge-name-picture-4' => 'Amator de arte',
	'achievements-badge-name-picture-5' => 'Decorator',
	'achievements-badge-name-picture-6' => 'Designator',
	'achievements-badge-name-picture-7' => 'Curator',
	'achievements-badge-name-category-0' => 'Facer un connexion',
	'achievements-badge-name-category-1' => 'Pionero',
	'achievements-badge-name-category-2' => 'Explorator',
	'achievements-badge-name-category-3' => 'Guida touristic',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Constructor de pontes',
	'achievements-badge-name-category-6' => 'Planificator del wiki',
	'achievements-badge-name-blogpost-0' => 'Qualcosa a dicer',
	'achievements-badge-name-blogpost-1' => 'Cinque cosas a dicer',
	'achievements-badge-name-blogpost-2' => 'Programma de conversation',
	'achievements-badge-name-blogpost-3' => 'Le anima del festa',
	'achievements-badge-name-blogpost-4' => 'Orator public',
	'achievements-badge-name-blogcomment-0' => 'Commentator',
	'achievements-badge-name-blogcomment-1' => 'E un cosa plus',
	'achievements-badge-name-love-0' => 'Essential pro le wiki!',
	'achievements-badge-name-love-1' => 'Duo septimanas in le wiki',
	'achievements-badge-name-love-2' => 'Devotate',
	'achievements-badge-name-love-3' => 'Dedicate',
	'achievements-badge-name-love-4' => 'Maniac',
	'achievements-badge-name-love-5' => 'Un vita wiki',
	'achievements-badge-name-love-6' => 'Heroe wiki!',
	'achievements-badge-name-sharing-0' => 'Condivisor',
	'achievements-badge-name-sharing-1' => 'Porta lo retro',
	'achievements-badge-name-sharing-2' => 'Parlante',
	'achievements-badge-name-sharing-3' => 'Annunciator',
	'achievements-badge-name-sharing-4' => 'Evangelista',
	'achievements-badge-name-welcome' => 'Benvenite al wiki!',
	'achievements-badge-name-introduction' => 'Introduction',
	'achievements-badge-name-sayhi' => 'Passante pro dicer salute',
	'achievements-badge-name-creator' => 'Le creator',
	'achievements-badge-name-pounce' => 'Salta!',
	'achievements-badge-name-caffeinated' => 'Con caffeina',
	'achievements-badge-name-luckyedit' => 'Modification fortunate',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|divider un ligamine|inducer {{PLURAL:$1|un persona|$1 personas}} a cliccar sur le ligamine que tu divideva}}',
	'achievements-badge-to-get-edit' => 'facer $1 {{PLURAL:$1|modification|modificationes}} in {{PLURAL:$1|un pagina|paginas}}',
	'achievements-badge-to-get-edit-plus-category' => 'facer {{PLURAL:$1|un modification|$1 modificationes}} in {{PLURAL:$1|un pagina|paginas}} de $2',
	'achievements-badge-to-get-picture' => 'adder $1 {{PLURAL:$1|imagine|imagines}} a {{PLURAL:$1|un pagina|paginas}}',
	'achievements-badge-to-get-category' => 'adder $1 {{PLURAL:$1|pagina|paginas}} a {{PLURAL:$1|un categoria|categorias}}',
	'achievements-badge-to-get-blogpost' => 'scriber $1 {{PLURAL:$1|articulo|articulos}} de blog',
	'achievements-badge-to-get-blogcomment' => 'scriber un commento super {{PLURAL:$1|un articulo|$1 differente articulos}} de blog',
	'achievements-badge-to-get-love' => 'contribuer al wiki cata die durante {{PLURAL:$1|un die|$1 dies}}',
	'achievements-badge-to-get-welcome' => 'junger se al wiki',
	'achievements-badge-to-get-introduction' => 'adder al proprie pagina de usator',
	'achievements-badge-to-get-sayhi' => 'lassar un message a alcuno in su pagina de discussion',
	'achievements-badge-to-get-creator' => 'esser le creator de iste wiki',
	'achievements-badge-to-get-pounce' => 'esser rapide',
	'achievements-badge-to-get-caffeinated' => 'facer {{PLURAL:$1|un modification|$1 modificationes}} in paginas in un sol die',
	'achievements-badge-to-get-luckyedit' => 'esser fortunate',
	'achievements-badge-to-get-sharing-details' => 'Divide ligamines e induce alteres a cliccar sur illos!',
	'achievements-badge-to-get-edit-details' => 'Qualcosa manca?
Il ha un error?
Non sia timide.
Clicca super le button "{{int:edit}}" e tu pote adder a omne pagina!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Le paginas de <strong>$1</strong> ha besonio de tu adjuta!
Clicca super le button "{{int:edit}}" in qualcunque pagina de iste categoria pro adjutar.
Demonstra tu supporto pro le paginas de $1!',
	'achievements-badge-to-get-picture-details' => 'Clicca super le button "{{int:edit}}", e postea super le button "{{int:rte-ck-image-add}}".
Tu pote adder un photo de tu computator, o de un altere pagina in le wiki.',
	'achievements-badge-to-get-category-details' => 'Le categorias es etiquettas que adjuta le lectores a trovar paginas similar.
Clicca super le button "{{int:categoryselect-addcategory-button}}" al pede de un pagina pro listar iste pagina in un categoria.',
	'achievements-badge-to-get-blogpost-details' => 'Scribe tu opiniones e questiones!
Clicca super "{{int:blogs-recent-url-text}}" in le barra lateral, e postea super le ligamine a sinistra pro "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Adde tu grano de sal!
Lege un del recente articulos de blog, e scribe tu pensamentos in le quadro a commentos.',
	'achievements-badge-to-get-love-details' => 'Le contator se reinitialisa si tu perde un die, dunque assecura te de revenir al wiki cata die!',
	'achievements-badge-to-get-welcome-details' => 'Clicca super le button "{{int:oasis-signup}}" in alto a dextra pro junger te al communitate.
Tu pote comenciar a ganiar tu proprie insignias!',
	'achievements-badge-to-get-introduction-details' => 'Tu pagina de usator es vacue?
Clicca super tu nomine de usator in alto del schermo pro vider lo.
Clicca super "{{int:edit}}" pro adder alcun information super te!',
	'achievements-badge-to-get-sayhi-details' => 'Pro lassar un message a un altere usator, clicca sur "{{int:addsection}}" in su pagina de discussion.
Demanda adjuta, regratia le usator pro su labor, o lassa simplemente un salute!',
	'achievements-badge-to-get-creator-details' => 'Iste insignia es date al persona qui fundava le wiki.
Clicca super le button "{{int:createwiki}}" in alto pro comenciar un sito super lo que tu ama le plus!',
	'achievements-badge-to-get-pounce-details' => 'Tu debe esser rapide pro ganiar iste insignia.
Clicca super le button "{{int:activityfeed}}" pro vider le nove paginas que usatores crea!',
	'achievements-badge-to-get-caffeinated-details' => 'Es necessari haber un die productive pro ganiar iste insignia.
Continua a modificar!',
	'achievements-badge-to-get-luckyedit-details' => 'Tu debe esser fortunate pro ganiar iste insignia.
Continua a modificar!',
	'achievements-badge-to-get-community-platinum-details' => 'Isto es un insignia special de platino que es solmente disponibile pro un tempore limitate!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|pro divider un ligamine|pro facer {{PLURAL:$1|un persona|$1 personas}} cliccar sur ligamines dividite}}',
	'achievements-badge-hover-desc-edit' => 'Adjudicate pro facer $1 {{PLURAL:$1|modification|modificationes}}<br />
in {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Adjudicate pro facer $1 {{PLURAL:$1|modification|modificationes}}<br />
in {{PLURAL:$1|un pagina de $2|paginas de $2}}!',
	'achievements-badge-hover-desc-picture' => 'Adjudicate pro adder $1 {{PLURAL:$1|imagine|imagines}}<br />
a {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-hover-desc-category' => 'Adjudicate pro adder $1 {{PLURAL:$1|pagina|paginas}}<br />
a {{PLURAL:$1|un categoria|categorias}}!',
	'achievements-badge-hover-desc-blogpost' => 'Adjudicate pro scriber $1 {{PLURAL:$1|articulo|articulos}} de blog!',
	'achievements-badge-hover-desc-blogcomment' => 'Adjudicate pro scriber un commento<br />
super $1 differente {{PLURAL:$1|articulo|articulos}} de blog!',
	'achievements-badge-hover-desc-love' => 'Adjudicate pro contribuer al wiki cata die durante {{PLURAL:$1|un die|$1 dies}}!',
	'achievements-badge-hover-desc-welcome' => 'Adjudicate pro junger te al wiki!',
	'achievements-badge-hover-desc-introduction' => 'Adjudicate pro adder qualcosa<br />
a tu proprie pagina de usator!',
	'achievements-badge-hover-desc-sayhi' => 'Adjudicate pro lassar un message<br />
in le pagina de discussion de un altere persona!',
	'achievements-badge-hover-desc-creator' => 'Adjudicate pro crear le wiki!',
	'achievements-badge-hover-desc-pounce' => 'Adjudicate pro facer modificationes in 100 paginas intra un hora post le creation del pagina!',
	'achievements-badge-hover-desc-caffeinated' => 'Adjudicate pro facer 100 modificationes in paginas in un sol die!',
	'achievements-badge-hover-desc-luckyedit' => 'Adjudicate pro facer le modification fortunate №$1 in le wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Isto es un insignia special de platino que es solmente disponibile pro un tempore limitate!',
	'achievements-badge-your-desc-sharing' => 'Adjudicate {{#ifeq:$1|0|pro divider un ligamine|pro facer {{PLURAL:$1|un persona|$1 personas}} cliccar sur ligamines dividite}}',
	'achievements-badge-your-desc-edit' => 'Adjudicate pro facer {{PLURAL:$1|tu prime modification|$1 modificationes}} in {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'Adjudicate pro facer {{PLURAL:$1|tu prime modification|$1 modificationes}} in {{PLURAL:$1|un pagina de $2|paginas de $2}}!',
	'achievements-badge-your-desc-picture' => 'Adjudicate pro adder {{PLURAL:$1|tu prime imagine|$1 imagines}} a {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-your-desc-category' => 'Adjudicate pro adder {{PLURAL:$1|tu prime pagina|$1 paginas}} a {{PLURAL:$1|un categoria|categorias}}!',
	'achievements-badge-your-desc-blogpost' => 'Adjudicate pro scriber {{PLURAL:$1|tu prime articulo|$1 articulos}} de blog!',
	'achievements-badge-your-desc-blogcomment' => 'Adjudicate pro scriber un commento super {{PLURAL:$1|un articulo|$1 differente articulos}} de blog!',
	'achievements-badge-your-desc-love' => 'Adjudicate pro contribuer al wiki cata die durante {{PLURAL:$1|un die|$1 dies}}!',
	'achievements-badge-your-desc-welcome' => 'Adjudicate pro junger te al wiki!',
	'achievements-badge-your-desc-introduction' => 'Adjudicate pro adder qualcosa a tu proprie pagina de usator!',
	'achievements-badge-your-desc-sayhi' => 'Adjudicate pro lassar un message in le pagina de discussion de un altere persona!',
	'achievements-badge-your-desc-creator' => 'Adjudicate pro crear le wiki!',
	'achievements-badge-your-desc-pounce' => 'Adjudicate pro facer modificationes in 100 paginas intra un hora post le creation del pagina!',
	'achievements-badge-your-desc-caffeinated' => 'Adjudicate pro facer 100 modificationes in paginas in un sol die!',
	'achievements-badge-your-desc-luckyedit' => 'Adjudicate pro facer le modification fortunate №$1 in le wiki!',
	'achievements-badge-desc-sharing' => 'Adjudicate {{#ifeq:$1|0|pro divider un ligamine|pro facer {{PLURAL:$1|un persona|$1 personas}} cliccar sur ligamines dividite}}',
	'achievements-badge-desc-edit' => 'Adjudicate pro facer $1 {{PLURAL:$1|modification|modificationes}} in {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-desc-edit-plus-category' => 'Adjudicate pro facer $1 {{PLURAL:$1|modification|modificationes}} in {{PLURAL:$1|un pagina de $2|paginas de $2}}!',
	'achievements-badge-desc-picture' => 'Adjudicate pro adder $1 {{PLURAL:$1|imagine|imagines}} a {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-desc-category' => 'Adjudicate pro adder $1 {{PLURAL:$1|pagina|paginas}} a {{PLURAL:$1|un categoria|categorias}}!',
	'achievements-badge-desc-blogpost' => 'Adjudicate pro scriber $1 {{PLURAL:$1|articulo|articulos}} de blog!',
	'achievements-badge-desc-blogcomment' => 'Adjudicate pro scriber un commento super {{PLURAL:$1|un articulo|$1 differente articulos}} de blog!',
	'achievements-badge-desc-love' => 'Adjudicate pro contribuer al wiki cata die durante {{PLURAL:$1|un die|$1 dies}}!',
	'achievements-badge-desc-welcome' => 'Adjudicate pro junger te al wiki!',
	'achievements-badge-desc-introduction' => 'Adjudicate pro adder qualcosa a tu proprie pagina de usator!',
	'achievements-badge-desc-sayhi' => 'Adjudicate pro lassar un message in le pagina de discussion de un altere persona!',
	'achievements-badge-desc-creator' => 'Adjudicate pro crear le wiki!',
	'achievements-badge-desc-pounce' => 'Adjudicate pro facer modificationes in 100 paginas intra un hora post le creation del pagina!',
	'achievements-badge-desc-caffeinated' => 'Adjudicate pro facer 100 modificationes in paginas in un sol die!',
	'achievements-badge-desc-luckyedit' => 'Adjudicate pro facer le modification fortunate №$1 in le wiki!',
	'achievements-userprofile-title-no' => 'Insignias ganiate per $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Insignia|Insignias}} ganiate per $1 ($2)',
	'achievements-userprofile-no-badges-owner' => 'Reguarda le lista hic infra pro vider le insignias que tu pote ganiar in iste wiki!',
	'achievements-userprofile-no-badges-visitor' => 'Iste usator non ha ancora ganiate alcun insignia.',
	'achievements-userprofile-profile-score' => '<em>$1</em> Punctos de<br />merito',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Rango №$1]]<br />in iste wiki',
);

$messages['id'] = array(
	'achievementsii-desc' => 'System lencana prestasi untuk pengguna wiki',
	'achievements-upload-error' => 'Maaf!
Gambar itu tidak dapat di gunakan.
Pastikan bahwa gambar tersebut adalah file .jpg atau.png.
Jika masih tidak bekerja, maka gambar mungkin terlalu besar.
Silahkan coba yang lain.',
	'achievements-upload-not-allowed' => 'Administrator dapat mengubah nama dan gambar lencana Prestasi dengan mengunjungi [[Special:AchievementsCustomize|the Customize achievements]] halaman.',
	'achievements-non-existing-category' => 'Kategori yang diminta tidak ditemukan.',
	'achievements-edit-plus-category-track-exists' => 'Kategori tertentu sudah memiliki <a href="#" onclick="$(window).scrollTo(\'#section<span class="notranslate">$1 \', 2500); return false; "title =" Pergi ke trek "> lagu yang terkait</a> .',
	'achievements-no-stub-category' => 'Tolong jangan membuat jejak untuk Rintisan bertopik.',
	'right-platinum' => 'Membuat dan mengedit lencana Platinum.',
	'right-sponsored-achievements' => 'Mengelola prestasi yang di sponsori',
	'achievements-platinum' => 'Platinum',
	'achievements-gold' => 'Emas',
	'achievements-silver' => 'Perak',
	'achievements-bronze' => 'Perunggu',
	'achievements-gold-points' => '100<br />poin',
	'achievements-silver-points' => '50<br />poin',
	'achievements-bronze-points' => '10<br />poin',
	'achievements-you-must' => 'Anda harus $1 untuk mendapatkan lencana ini.',
	'leaderboard-button' => 'Papan prestasi',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|Point|Points}}</small>',
	'achievements-profile-title-no' => 'Lencana milik $1',
	'achievements-no-badges' => 'Lihat daftar di bawah ini untuk melihat lencana yang dapat Anda peroleh pada wiki ini!',
	'achievements-track-name-edit' => 'Jejak edit',
	'achievements-track-name-picture' => 'Lacak Gambar',
	'achievements-track-name-category' => 'Jejak Kategori',
	'achievements-track-name-blogpost' => 'Jejak postingan blog.',
	'achievements-track-name-blogcomment' => 'Lacak komentar blog',
	'achievements-track-name-love' => 'Lacak wiki cinta',
	'achievements-track-name-sharing' => 'Berbagi jejak',
	'achievements-notification-title' => 'Kerja bagus, $1!',
	'achievements-notification-subtitle' => 'Anda baru saja mendapat lencana "$1" untuk $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|See more badges you can earn]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|poin|poin}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|poin|poin}}',
	'achievements-profile-title-challenges' => 'Lencana lain yang dapat anda dapatkan!',
	'achievements-profile-customize' => 'menyesuaikan lencana',
	'achievements-ranked' => 'Peringkat # $1 di wiki ini',
	'achievements-viewall' => 'Lihat semua',
	'achievements-viewless' => 'Tutup',
	'achievements-profile-title-oasis' => 'prestasi<br />poin',
	'achievements-ranked-oasis' => '$1adalah [[Special:Leaderboard|Ranked #$2]] pada wiki ini',
	'achievements-viewall-oasis' => 'Lihat semua',
	'achievements-toggle-hide' => 'Jangan tampilkan poin, lencana dan peringkat di halaman profil saya',
	'leaderboard-intro-hide' => 'Sembunyikan',
	'leaderboard-intro-open' => 'Buka',
	'leaderboard-intro-headline' => 'Apakah prestasi?',
	'leaderboard-intro' => "Anda bisa mendapatkan lencana di wiki ini dengan mengedit halaman, meng-upload foto dan meninggalkan komentar. Lencana setiap Anda mendapatkan poin - semakin banyak Anda mendapatkan poin, semakin tinggi peringkat Anda!, Anda akan menemukan lencana yang Anda telah diterima pada [[$1|user profile page]].

	''' Apa harga lencana?'' '",
	'leaderboard' => 'Papan prestasi',
	'achievements-title' => 'Prestasi',
	'achievements-recent-earned-badges' => 'Lencana yang baru-baru ini diterima',
	'achievements-leaderboard-disclaimer' => 'Perubahan papan peringkat sejak kemarin',
	'achievements-leaderboard-rank-label' => 'Peringkat',
	'achievements-leaderboard-member-label' => 'Anggota',
	'achievements-leaderboard-points-label' => 'Poin',
	'achievements-leaderboard-most-recently-earned-label' => 'Baru-baru ini diperoleh',
	'achievements-send' => 'Simpan gambar',
	'achievements-save' => 'Simpan perubahan',
	'achievements-reverted' => 'Lencana dirubah ke aslinya.',
	'achievements-customize' => 'Menyesuaikan gambar',
	'achievements-customize-new-category-track' => 'Membuat jejak baru untuk Kategori:',
	'achievements-enable-track' => 'diaktifkan',
	'achievements-revert' => 'Kembali ke default',
	'achievements-special-saved' => 'Perubahan disimpan.',
	'achievements-special' => 'Prestasi khusus',
	'achievements-secret' => 'Prestasi rahasia',
	'achievementscustomize' => 'Menyesuaikan lencana',
	'achievements-about-title' => 'Tentang Halaman ini...',
	'achievements-about-content' => 'Administrator pada wiki ini dapat menyesuaikan nama dan gambar lencana prestasi.

Anda dapat meng-upload gambar apapun  jpg atau. Png., Dan gambar Anda secara otomatis akan muat di dalam bingkai.
Gambar bekerja dengan baik bila gambar Anda persegi, dan bagian yang paling penting dari gambar terletak di tengah.


Anda dapat menggunakan gambar persegi panjang, tetapi gambar Anda mungkin akan dipotong oleh frame.
Jika Anda memiliki program grafis, maka Anda dapat memotong gambar Anda untuk menempatkan bagian penting dari gambar di tengah.

Jika Anda tidak memiliki program grafis,  bereksperimenlah dengan gambar yang berbeda sampai Anda menemukan gambar yang tepat!
Jika Anda tidak menyukai gambar yang telah dipilih, klik "{{int:achievements-revert}}" untuk kembali ke grafik sebelumnya.

Anda juga dapat memberikan nama-nama lencana baru yang mencerminkan topik dari wiki.
Bila Anda telah meberubah nama lencana, klik "{{int:achievements-save}}" untuk menyimpan perubahan Anda.
Selamat Mencoba!',
	'achievements-edit-plus-category-track-name' => 'Jejak edit $1',
	'achievements-create-edit-plus-category-title' => 'Membuat jejak edit baru',
	'achievements-create-edit-plus-category-content' => 'Anda dapat membuat set baru lencana penghargaan yang menghadiahi pengguna untuk mengedit halaman dalam kategori tertentu, untuk menyoroti area tertentu dari situs yang pengguna sukai.
Anda dapat menetapkan lebih dari satu jejak kategori, jadi cobalah  memilih dua kategori yang akan membantu pengguna  memamerkan kekhususan mereka!
Piculah  persaingan di antara pengguna yang mengedit halaman  Vampir dan pengguna yang mengedit halaman Werewolves, atau Wizards dan  Muggle, Autobots dan Decepticons.

Untuk membuat jejak baru "Edit dalam kategori", ketik nama kategori dalam bidang di bawah ini.
Jejak suntingan biasa akan tetap ada;
Suntingan akan menciptakan jejak yang terpisah, Anda dapat menyesuaikannya secara terpisah.


Ketika jejak dibuat, lencana baru akan muncul dalam daftar di sebelah kiri, di bawah jalur Suntingan biasa.
Sesuaikan nama dan gambar untuk jejak baru, sehingga pengguna dapat melihat perbedaannya!

Setelah Anda melakukan kustomisasi, klik  "{{int:achievements-enable-track}}" kotak centang untuk mengaktifkan  jalur baru, dan kemudian klik "{{int:achievements-save}}".
Pengguna akan melihat jejak baru muncul pada profil pengguna mereka, dan mereka akan mulai mendapatkan badge ketika mereka mengedit halaman dalam kategori tersebut.
Anda juga dapat menonaktifkan jejak setelah selesai, jika Anda memutuskan Anda tidak ingin menyoroti kategori itu lagi.
Pengguna yang telah mendapatkan lencana di jejak akan selalu menyimpan lencana mereka, biarpun jejak dinonaktifkan.

Hal ini dapat membantu meningkatkan kesenangan dalam hal prestasi.
Cobalah!',
	'platinum' => 'Platinum',
	'achievements-community-platinum-badge-image' => 'Gambar lencana:',
	'achievements-community-platinum-awarded-to' => 'Diberikan kepada:',
	'achievements-community-platinum-create-badge' => 'Buat lencana',
	'achievements-community-platinum-edit' => 'sunting',
	'achievements-community-platinum-save' => 'simpan',
	'achievements-community-platinum-cancel' => 'batal',
	'achievements-community-platinum-sponsored-label' => 'Prestasi yang disponsori',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Klik untuk informasi lebih lanjut',
	'achievements-badge-name-edit-0' => 'Membuat Perbedaan',
	'achievements-badge-name-edit-1' => 'Baru Permulaan',
	'achievements-badge-name-edit-2' => 'Membuat jejakmu',
	'achievements-badge-name-edit-3' => 'Teman dari Wiki',
	'achievements-badge-name-edit-4' => 'Kolaborator',
	'achievements-badge-name-edit-5' => 'Pembangun wiki',
	'achievements-badge-name-edit-6' => 'Pemimpin wiki',
	'achievements-badge-name-edit-7' => 'Ahli wiki',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Ilustrator',
	'achievements-badge-name-picture-3' => 'Pengumpul',
	'achievements-badge-name-picture-4' => 'Pecinta seni',
	'achievements-badge-name-picture-5' => 'Dekorator',
	'achievements-badge-name-picture-6' => 'Desainer',
	'achievements-badge-name-picture-7' => 'Kurator',
	'achievements-badge-name-category-0' => 'Buat Hubungan',
	'achievements-badge-name-category-2' => 'Penjelajah',
	'achievements-badge-name-category-3' => 'Pemandu Wisata',
	'achievements-badge-name-category-4' => 'Pemandu',
	'achievements-badge-name-category-5' => 'Pembangun Jembatan',
	'achievements-badge-name-category-6' => 'Perencana Wiki',
	'achievements-badge-name-blogpost-4' => 'Pembicara Publik',
	'achievements-badge-name-blogcomment-1' => 'Dan satu hal lagi',
	'achievements-badge-name-love-0' => 'Kunci Wiki!',
	'achievements-badge-name-love-1' => 'Dua minggu di wiki',
	'achievements-badge-name-love-4' => 'Kecanduan',
	'achievements-badge-name-love-5' => 'Sebuah Kehidupan Wiki',
	'achievements-badge-name-love-6' => 'Pahlawan Wiki!',
	'achievements-badge-name-sharing-0' => 'Pembagi',
	'achievements-badge-name-sharing-1' => 'Bawa kembali',
	'achievements-badge-name-sharing-2' => 'Juru Bicara',
	'achievements-badge-name-welcome' => 'Selamat Datang di Wiki',
	'achievements-badge-name-introduction' => 'Perkenalan',
	'achievements-badge-name-creator' => 'Pencipta',
	'achievements-badge-name-caffeinated' => 'Kurang tidur',
	'achievements-badge-name-luckyedit' => 'Suntingan beruntung',
	'achievements-badge-to-get-blogpost' => 'tulis $1 {{PLURAL:$1|kiriman blog|kiriman blog}}',
	'achievements-badge-to-get-introduction' => 'tambahkan ke halaman pengguna Anda',
	'achievements-badge-to-get-sayhi' => 'tinggalkan pesan kepada seseorang di halaman pembicaraannya',
	'achievements-badge-to-get-creator' => 'jadilah pencipta wiki ini',
);

$messages['ig'] = array(
	'achievements-viewless' => 'Mèchié',
	'achievements-badge-name-category-4' => 'Ọtúzọr',
);

$messages['inh'] = array(
	'achievements-non-existing-category' => 'Лаьрха цатег йоацаш я',
	'achievements-gold' => 'Дошув',
	'achievements-silver' => 'Дотув',
	'achievements-track-name-edit' => 'Дийнасурт хувца',
	'achievements-track-name-picture' => 'Дийнасуртий бIасанче',
	'achievements-track-name-category' => 'Дийнасуртий цатег',
	'achievements-viewall' => 'Массадолачунга хьажа',
	'achievements-viewless' => 'ДIакъовла',
	'achievements-viewall-oasis' => 'Дерригачунга хьажа',
	'leaderboard-intro-hide' => 'къайладаккха',
	'leaderboard-intro-open' => 'хьадела',
	'leaderboard-intro-headline' => 'Толамаш фу яхалг да?',
	'achievements-title' => 'Толамаш',
	'achievements-send' => 'Сурт кходе',
	'achievements-save' => 'Хувцамаш кходе',
	'achievements-special-saved' => 'Хувцамаш кхояь я',
	'achievements-about-title' => 'Укх оагIува лаьца...',
	'achievements-create-edit-plus-category' => 'Ер дийнасурт хьаде',
	'achievements-community-platinum-edit' => 'хувца',
	'achievements-community-platinum-save' => 'кходе',
	'achievements-community-platinum-cancel' => 'дIадаккха',
);

$messages['it'] = array(
	'achievementsii-desc' => 'Un sistema di medaglie per gli utenti della wiki',
	'achievements-upload-error' => "Spiacenti!
Questa immagine non funziona.
Assicurati che sia un file .jpg o .png.
Se non funziona comunque, allora potrebbe essere troppo grande.
Per favore, provane un'altra!",
	'achievements-upload-not-allowed' => 'Gli amministratori possono cambiare i nomi e le immagini delle medaglie tramite la [[Special:AchievementsCustomize|pagina di personalizzazione]].',
	'achievements-non-existing-category' => 'La categoria indicata non esiste.',
	'achievements-edit-plus-category-track-exists' => 'La categoria specificata ha già un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Vai al set">set associato</a>.',
	'achievements-no-stub-category' => 'Per favore, non creare set per le bozze.',
	'right-platinum' => 'Crea e modifica medaglie di platino',
	'right-sponsored-achievements' => 'Gestisci i successi sponsorizzati',
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Oro',
	'achievements-silver' => 'Argento',
	'achievements-bronze' => 'Bronzo',
	'achievements-gold-points' => '100<br />punti',
	'achievements-silver-points' => '50<br />punti',
	'achievements-bronze-points' => '10<br />punti',
	'achievements-you-must' => 'Devi $1 per ottenere questa medaglia.',
	'leaderboard-button' => 'Classifica dei successi',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punto|punti}}</small>',
	'achievements-profile-title-no' => 'Medaglie di $1',
	'achievements-no-badges' => "Dai un'occhiata all'elenco qui sotto per vedere le medaglie che puoi ottenere su questa wiki!",
	'achievements-track-name-edit' => 'Set per le modifiche',
	'achievements-track-name-picture' => 'Set per le immagini',
	'achievements-track-name-category' => 'Set per le categorie',
	'achievements-track-name-blogpost' => 'Set per i blog',
	'achievements-track-name-blogcomment' => 'Set per i commenti ai blog',
	'achievements-track-name-love' => "Set per l'amore della wiki",
	'achievements-track-name-sharing' => 'Set per la condivisione',
	'achievements-notification-title' => 'Ben fatto, $1!',
	'achievements-notification-subtitle' => 'Hai appena ottenuto la medaglia "$1" $2',
	'achievements-notification-link' => "'''<big>[[Special:MyPage|Vedi le altre medaglie che puoi ottenere]]!</big>'''",
	'achievements-points' => '$1 {{PLURAL:$1|punto|punti}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punto|punti}}',
	'achievements-earned' => 'Questa medaglia è stata ottenuta da {{PLURAL:$1|1 utente|$1 utenti}}.',
	'achievements-profile-title' => '$2 {{PLURAL:$2|medaglia|medaglie}} di $1',
	'achievements-profile-title-challenges' => 'Altre medaglie ottenibili!',
	'achievements-profile-customize' => 'Personalizza medaglie',
	'achievements-ranked' => 'In $1ª posizione su questa wiki',
	'achievements-viewall' => 'Vedi tutte',
	'achievements-viewless' => 'Chiudi',
	'achievements-profile-title-oasis' => 'punti in <br /> Successi',
	'achievements-ranked-oasis' => '$1 è in [[Special:Leaderboard|$2ª posizione]] su questa wiki',
	'achievements-viewall-oasis' => 'Vedi tutte',
	'achievements-toggle-hide' => 'Nascondi a tutti le mie medaglie sul mio profilo',
	'leaderboard-intro-hide' => 'nascondi',
	'leaderboard-intro-open' => 'mostra',
	'leaderboard-intro-headline' => 'Cosa sono i Successi?',
	'leaderboard-intro' => "Su questa wiki puoi ottenere delle medaglie modificando pagine, caricando immagini e lasciando commenti. Ogni medaglia ti fa guadagnare punti - più punti ottieni, più in alto salirai nella classifica! Trovi l'elenco delle medaglie che hai ottenuto sul tuo [[$1|profilo utente]].

'''Quanto valgono le medaglie?'''",
	'leaderboard' => 'Classifica dei Successi',
	'achievements-title' => 'Successi',
	'leaderboard-title' => 'Classifica',
	'achievements-recent-earned-badges' => 'Medaglie ottenute di recente',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />ottenuta da <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'ha ottenuto la medaglia <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'La classifica mostra i cambiamenti da ieri',
	'achievements-leaderboard-rank-label' => 'Posizione',
	'achievements-leaderboard-member-label' => 'Utente',
	'achievements-leaderboard-points-label' => 'Punti',
	'achievements-leaderboard-points' => '{{PLURAL:$1|punto|punti}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Ottenuta di recente',
	'achievements-send' => 'Salva immagine',
	'achievements-save' => 'Salva modifiche',
	'achievements-reverted' => 'Medaglia originale ripristinata.',
	'achievements-customize' => 'Personalizza immagine',
	'achievements-customize-new-category-track' => 'Crea un nuovo set per la categoria:',
	'achievements-enable-track' => 'attivato',
	'achievements-revert' => 'Ripristina originale',
	'achievements-special-saved' => 'Modifiche salvate.',
	'achievements-special' => 'Successi speciali',
	'achievements-secret' => 'Successi segreti',
	'achievementscustomize' => 'Personalizza le medaglie',
	'achievements-about-title' => 'Su questa pagina...',
	'achievements-about-content' => "Gli amministratori di questa wiki possono personalizzare i nomi e le immagini delle medaglie.

Puoi caricare qualsiasi immagine .jpg o .png e l'immagine si adatterà automaticamente all'interno della cornice.
Funziona meglio quando l'immagine è quadrata e quando la parte più importante dell'immagine è proprio al centro.

Puoi utilizzare anche un'immagine rettangolare, ma una parte potrebbe essere un po' tagliata dalla cornice.
Se possiedi un programma di grafica, puoi ritagliare l'immagine in modo da posizionare la sua parte più importante al centro.
Se non hai un programma di grafica, prova diverse immagini fino a trovare quelle che vanno bene per te!
Se non ti piace l'immagine che hai scelto, clicca su \"{{int:achievements-revert}}\" per tornare alla grafica originale.

Puoi anche dare alle medaglie nuovi nomi che riflettono l'argomento della wiki.
Quando hai cambiato i nomi delle medaglie, clicca su \"{{int:achievements-save}}\" per salvare le modifiche.
Buon divertimento!",
	'achievements-edit-plus-category-track-name' => 'Set per modifiche $1',
	'achievements-create-edit-plus-category-title' => 'Crea un nuovo set per le modifiche',
	'achievements-create-edit-plus-category-content' => 'Puoi creare un nuovo set di medaglie per premiare gli utenti che modificano le pagine in una determinata categoria, per evidenziare un\'area particolare del sito a cui gli utenti si divertirebbero a collaborare.
Puoi impostare più di una categoria, quindi provate a scegliere due categorie che aiutino gli utenti a mostrare la loro specialità!
Per esempio, crea una rivalità tra gli utenti che modificano le pagine di Vampiri e gli utenti che modifica le pagine di Lupi mannari, o tra Maghi e Babbani, o tra Autobots e Decepticons.

Per creare un set "Modifica nella categoria", digita il nome della categoria nel campo sottostante.
Il set regolare per le modifiche continuerà ad esserci, questa funzione creerà solo un set autonomo di medaglie personalizzabile separatamente.

Quando viene creato il set, le nuove medaglie appariranno nell\'elenco a sinistra, sotto il set regolare di medaglie per le modifiche.

Personalizza i nomi e le immagini per il nuovo set, in modo che gli utenti possano notare la differenza!
Una volta che hai finito la personalizzazione, spunta la casella "{{int:achievements-enable-track}}" per attivare il set e quindi fare clic su "{{int:achievements-save}}".
Gli utenti potranno visualizzare il nuovo set nei loro profili utente e cominceranno a guadagnare medaglie quando modificheranno pagine in quella categoria.
Potrai anche decidere di disattivare il set in seguito se non vuoi più evidenziare quella categoria.
Gli utenti che avranno guadagnato medaglie in quel set le manterranno sempre, anche se il set sarà disattivato.

Questa funzione aggiungerà divertimento alla conquista delle medaglie. Provala!',
	'achievements-create-edit-plus-category' => 'Crea questo set',
	'platinum' => 'Platino',
	'achievements-community-platinum-awarded-email-subject' => 'Hai ottenuto una nuova medaglia di Platino!',
	'achievements-community-platinum-awarded-email-body-text' => 'Congratulazioni $1!

Hai appena ottenuto la medaglia di platino "$2" su $4 ($3).
Questa aggiunge 250 punti al tuo punteggio!

Vedi la tua nuova sgargiante medaglia sul tuo profilo utente:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Congratulazioni $1!</strong><br /><br />
Hai appena ottenuto la medaglia di platino "<strong>$2</strong>" su <a href="$3">$4</a>.
Questa aggiunge 250 punti al tuo punteggio!<br /><br />
Vedi la tua nuova sgargiante medaglia sul <a href="$5">tuo profilo utente</a>.',
	'achievements-community-platinum-awarded-for' => 'Ottenuta per:',
	'achievements-community-platinum-how-to-earn' => 'Come ottenerla:',
	'achievements-community-platinum-awarded-for-example' => 'es. "per aver..."',
	'achievements-community-platinum-how-to-earn-example' => 'es. "fatto 3 modifiche..."',
	'achievements-community-platinum-badge-image' => 'Immagine della medaglia:',
	'achievements-community-platinum-awarded-to' => 'Ottenuta da:',
	'achievements-community-platinum-current-badges' => 'Medaglie di platino attuali',
	'achievements-community-platinum-create-badge' => 'Crea medaglia',
	'achievements-community-platinum-enabled' => 'attivato',
	'achievements-community-platinum-show-recents' => 'mostra nelle medaglie recenti',
	'achievements-community-platinum-edit' => 'modifica',
	'achievements-community-platinum-save' => 'salva',
	'achievements-community-platinum-cancel' => 'annulla',
	'achievements-community-platinum-sponsored-label' => 'Successo sponsorizzato',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Immagine al passaggio del mouse <small>(dimensioni minime: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => "URL tracciante per l'impatto delle medaglie:",
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => "URL tracciante per l'impatto al passaggio:",
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Link medaglia <small>(DART click command URL)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Clicca qui per maggiori informazioni',
	'achievements-badge-name-edit-0' => 'Fare la differenza',
	'achievements-badge-name-edit-1' => "È solo l'inizio",
	'achievements-badge-name-edit-2' => 'Lasciare il segno',
	'achievements-badge-name-edit-3' => 'Amico della wiki',
	'achievements-badge-name-edit-4' => 'Collaboratore',
	'achievements-badge-name-edit-5' => 'Costruttore della wiki',
	'achievements-badge-name-edit-6' => 'Leader della wiki',
	'achievements-badge-name-edit-7' => 'Esperto della wiki',
	'achievements-badge-name-picture-0' => 'Istantanea',
	'achievements-badge-name-picture-1' => 'Paparazzo',
	'achievements-badge-name-picture-2' => 'Illustratore',
	'achievements-badge-name-picture-3' => 'Collezionista',
	'achievements-badge-name-picture-4' => "Amante dell'arte",
	'achievements-badge-name-picture-5' => 'Decoratore',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Curatore',
	'achievements-badge-name-category-0' => 'Crea una connessione',
	'achievements-badge-name-category-1' => 'Divulgatore',
	'achievements-badge-name-category-2' => 'Esploratore',
	'achievements-badge-name-category-3' => 'Guida turistica',
	'achievements-badge-name-category-4' => 'Navigatore',
	'achievements-badge-name-category-5' => 'Costruttore di ponti',
	'achievements-badge-name-category-6' => 'Progettista della wiki',
	'achievements-badge-name-blogpost-0' => 'Qualcosa da dire',
	'achievements-badge-name-blogpost-1' => 'Cinque cose da dire',
	'achievements-badge-name-blogpost-2' => 'Talk show',
	'achievements-badge-name-blogpost-3' => 'Animatore della festa',
	'achievements-badge-name-blogpost-4' => 'Oratore',
	'achievements-badge-name-blogcomment-0' => 'Opinionista',
	'achievements-badge-name-blogcomment-1' => "E un'altra cosa",
	'achievements-badge-name-love-0' => 'Persona chiave della wiki!',
	'achievements-badge-name-love-1' => 'Due settimane sulla wiki',
	'achievements-badge-name-love-2' => 'Devoto',
	'achievements-badge-name-love-3' => 'Appassionato',
	'achievements-badge-name-love-4' => 'Dipendente',
	'achievements-badge-name-love-5' => 'Una vita sulla wiki',
	'achievements-badge-name-love-6' => 'Eroe della wiki!',
	'achievements-badge-name-sharing-0' => 'Condivisore',
	'achievements-badge-name-sharing-1' => 'Trascinatore',
	'achievements-badge-name-sharing-2' => 'Diplomatico',
	'achievements-badge-name-sharing-3' => 'Annunciatore',
	'achievements-badge-name-sharing-4' => 'Evangelista',
	'achievements-badge-name-welcome' => 'Benvenuto nella wiki',
	'achievements-badge-name-introduction' => 'Presentazione',
	'achievements-badge-name-sayhi' => 'Solo un saluto',
	'achievements-badge-name-creator' => 'Il creatore',
	'achievements-badge-name-pounce' => 'Catapultato!',
	'achievements-badge-name-caffeinated' => 'Caffeinomane',
	'achievements-badge-name-luckyedit' => 'Modifica fortunata',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|link condiviso|fai in modo che {{PLURAL:$1|una persona|$1 persone}} clicchino sul link da te condiviso}}',
	'achievements-badge-to-get-edit' => 'effettua {{PLURAL:$1|una modifica in una pagina|$1 modifiche nelle pagine}}',
	'achievements-badge-to-get-edit-plus-category' => 'effettua {{PLURAL:$1|una modifica in una pagina|$1 modifiche nelle pagine}}',
	'achievements-badge-to-get-picture' => "aggiungi {{PLURAL:$1|un'immagine in una pagina|$1 immagini nelle pagine}}",
	'achievements-badge-to-get-category' => 'categorizza {{PLURAL:$1|una pagina|$1 pagine}}',
	'achievements-badge-to-get-blogpost' => 'scrivi $1 blog post',
	'achievements-badge-to-get-blogcomment' => 'commenta {{PLURAL:$1|un blog post|$1 diversi blog post}}',
	'achievements-badge-to-get-love' => 'contribuisci alla wiki ogni giorno per {{PLURAL:$1|un giorno|$1 giorni}}',
	'achievements-badge-to-get-welcome' => 'diventa membro della wiki',
	'achievements-badge-to-get-introduction' => 'scrivi qualcosa nella tua pagina utente',
	'achievements-badge-to-get-sayhi' => 'lascia un messaggio nella pagina di discussione di un utente',
	'achievements-badge-to-get-creator' => 'sii il creatore di questa wiki',
	'achievements-badge-to-get-pounce' => 'sii veloce',
	'achievements-badge-to-get-caffeinated' => 'effettua 100 modifiche nelle pagine in una sola giornata',
	'achievements-badge-to-get-luckyedit' => 'sii fortunato',
	'achievements-badge-to-get-sharing-details' => 'Condividi i link e fai in modo che gli altri li clicchino!',
	'achievements-badge-to-get-edit-details' => 'Manca qualcosa? C\'è un errore? Non essere timido.<br />Clicca sul pulsante "{{int:edit}}"<br />per modificare qualsiasi pagina!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Le pagine di <strong> $1 </strong> hanno bisogno del tuo aiuto!
Clicca sul pulsante "{{int:edit}}" in qualsiasi pagina di quella categoria per contribuire.
Mostra il tuo aiuto per le pagine di $1!',
	'achievements-badge-to-get-picture-details' => 'Clicca sul pulsante "{{int:edit}}" e poi sul pulsante "{{int:rte-ck-image-add}}". Puoi aggiungere un\'immagine dal tuo computer o dalla wiki.',
	'achievements-badge-to-get-category-details' => 'Le categorie sono delle etichette che aiutano gli utenti a trovare pagine simili.<br />Clicca sul pulsante "{{int:categoryselect-addcategory-button}}" in fondo alla pagina per inserire quella pagina in una categoria.',
	'achievements-badge-to-get-blogpost-details' => 'Scrivi le tue opinioni e domande! Clicca su "{{int:blogs-recent-url-text}}" nella colonna laterale<br />e poi sul link a sinistra "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Dii la tua! Leggi un qualsiasi blog post recente<br />e scrivi quello che pensi nella sezione dei commenti.',
	'achievements-badge-to-get-love-details' => 'Il contatore viene resettato se salti un giorno, perciò cerca di tornare sulla wiki ogni giorno!',
	'achievements-badge-to-get-welcome-details' => 'Clicca sul pulsante "{{int:oasis-signup}}" in alto a destra per unirti alla community.
Puoi iniziare a guadagnare le medaglie anche tu!',
	'achievements-badge-to-get-introduction-details' => 'La tua pagina utente è vuota?
Clicca sul tuo nome utente in cima allo schermo per controllare.
Clicca su "{{int:edit}}" per inserire delle informazioni su di te!',
	'achievements-badge-to-get-sayhi-details' => 'Puoi lasciare messaggi agli altri utenti cliccando su "{{int:tooltip-ca-addsection}}" nella loro pagina di discussione.
Chiedi aiuto, ringraziali per il loro lavoro o lascia semplicemente un saluto!',
	'achievements-badge-to-get-creator-details' => 'Questa medaglia viene assegnata alla persona che ha fondato la wiki.
Clicca sul pulsante "{{int:createwiki}}" in cima per creare un sito su qualsiasi cosa ti interessi!',
	'achievements-badge-to-get-pounce-details' => 'Devi essere veloce per ottenere questa medaglia.
Clicca sul pulsante "{{int:activityfeed}}" per vedere le nuove pagine che gli utenti stanno creando!',
	'achievements-badge-to-get-caffeinated-details' => 'Ci vuole una giornata piena per guadagnare questa medaglia.
Continua a modificare!',
	'achievements-badge-to-get-luckyedit-details' => 'La medaglia per la modifica fortunata è assegnata alla persona che compie la millesima modifica sulla wiki e ad ogni altra millesima modifica a seguire. Per ottenere questa medaglia, contribuisci molto e spera di essere fortunato!',
	'achievements-badge-to-get-community-platinum-details' => 'Questa è una medaglia speciale di platino disponibile solo per un periodo limitato!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|per aver condiviso un link|per aver fatto in modo che {{PLURAL:$1|una persona cliccasse|$1 persone cliccassero}} su link condivisi}}',
	'achievements-badge-hover-desc-edit' => 'per aver effettuato $1 {{PLURAL:$1|modifica|modifiche}}<br />
{{PLURAL:$1|in una pagina|nelle pagine}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'per aver effettuato $1 {{PLURAL:$1|modifica|modifiche}}<br />
{{PLURAL:$1|in una pagina di $2|nelle pagine di $2}}!',
	'achievements-badge-hover-desc-picture' => "per aver inserito {{PLURAL:$1|un'immagine|$1 immagini}}<br />
{{PLURAL:$1|in una pagina|nelle pagine}}!",
	'achievements-badge-hover-desc-category' => 'per aver categorizzato $1 {{PLURAL:$1|pagina|pagine}}!',
	'achievements-badge-hover-desc-blogpost' => 'per aver scritto $1 blog post!',
	'achievements-badge-hover-desc-blogcomment' => 'per aver commentato<br />
{{PLURAL:$1|un|$1 diversi}} blog post!',
	'achievements-badge-hover-desc-love' => 'per aver contribuito alla wiki ogni giorno per {{PLURAL:$1|un giorno|$1 giorni}}!',
	'achievements-badge-hover-desc-welcome' => 'per essere diventato membro della wiki!',
	'achievements-badge-hover-desc-introduction' => 'per aver modificato<br />
la propria pagina utente!',
	'achievements-badge-hover-desc-sayhi' => 'per aver lasciato un messaggio<br />
nella pagina di discussione di un altro utente!',
	'achievements-badge-hover-desc-creator' => 'per aver creato la wiki!',
	'achievements-badge-hover-desc-pounce' => "per aver effettuato modifiche in 100 pagine nell'arco di un'ora dalla creazione della pagina!",
	'achievements-badge-hover-desc-caffeinated' => 'per aver effettuato 100 modifiche nelle pagine in un solo giorno!',
	'achievements-badge-hover-desc-luckyedit' => 'per aver effettuato la modifica fortunata n° $1 sulla wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Questa è una medaglia speciale di platino disponibile sono per un periodo limitato!',
	'achievements-badge-your-desc-sharing' => '{{#ifeq:$1|0|per aver condiviso un link|per aver fatto in modo che {{PLURAL:$1|una persona cliccasse|$1 persone cliccassero}} sui link condivisi}}',
	'achievements-badge-your-desc-edit' => 'per aver effettuato {{PLURAL:$1|la tua prima modifica in una pagina|$1 modifiche nelle pagine}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'per aver effettuato {{PLURAL:$1|la tua prima modifica in una pagina di $2|$1 modifiche nelle pagine di $2}}!',
	'achievements-badge-your-desc-picture' => 'per aver inserito {{PLURAL:$1|la tua prima immagine in una pagina|$1 immagini nelle pagine}}!',
	'achievements-badge-your-desc-category' => 'per aver categorizzato {{PLURAL:$1|la tua prima pagina|$1 pagine}}!',
	'achievements-badge-your-desc-blogpost' => 'per aver scritto {{PLURAL:$1|il tuo primo blog post|$1 blog post}}!',
	'achievements-badge-your-desc-blogcomment' => 'per aver commentato {{PLURAL:$1|un blog post|$1 diversi blog post}}!',
	'achievements-badge-your-desc-love' => 'per aver contribuito alla wiki ogni giorno per {{PLURAL:$1|un giorno|$1 giorni}}!',
	'achievements-badge-your-desc-welcome' => 'per essere diventato membro della wiki!',
	'achievements-badge-your-desc-introduction' => 'per aver modificato la propria pagina utente!',
	'achievements-badge-your-desc-sayhi' => 'per aver lasciato un messaggio nella pagina di discussione di un altro utente!',
	'achievements-badge-your-desc-creator' => 'per aver creato la wiki!',
	'achievements-badge-your-desc-pounce' => "per aver effettuato modifiche in 100 pagine nell'arco di un'ora dalla loro creazione!",
	'achievements-badge-your-desc-caffeinated' => 'per aver effettuato 100 modifiche nelle pagine in un solo giorno!',
	'achievements-badge-your-desc-luckyedit' => 'per aver effettuato la modifica fortunata n° $1 sulla wiki!',
	'achievements-badge-desc-sharing' => '{{#ifeq:$1|0|per aver condiviso un link|per aver fatto in modo che {{PLURAL:$1|una persona cliccasse|$1 persone cliccassero}} sui link condivisi}}',
	'achievements-badge-desc-edit' => 'per aver effettuato $1 {{PLURAL:$1|modifica in una pagina|modifiche nelle pagine}}!',
	'achievements-badge-desc-edit-plus-category' => 'per aver effettuato $1 {{PLURAL:$1|modifica in una pagina di $2|modifiche nelle pagine di $2}}!',
	'achievements-badge-desc-picture' => "per aver inserito {{PLURAL:$1|un'immagine in una pagina|$1 immagini nelle pagine}}!",
	'achievements-badge-desc-category' => 'per aver categorizzato $1 {{PLURAL:$1|pagina|pagine}}!',
	'achievements-badge-desc-blogpost' => 'per aver scritto $1 blog post!',
	'achievements-badge-desc-blogcomment' => 'per aver commentato {{PLURAL:$1|un|$1 diversi}} blog post!',
	'achievements-badge-desc-love' => 'per aver contribuito alla wiki ogni giorno per {{PLURAL:$1|un giorno|$1 giorni}}!',
	'achievements-badge-desc-welcome' => 'per essere diventato membro della wiki!',
	'achievements-badge-desc-introduction' => 'per aver modificato la propria pagina utente!',
	'achievements-badge-desc-sayhi' => 'per aver lasciato un messaggio nella pagina di discussione di un altro utente!',
	'achievements-badge-desc-creator' => 'per aver creato la wiki!',
	'achievements-badge-desc-pounce' => "per aver effettuato modifiche in 100 pagine nell'arco di un'ora dalla loro creazione!",
	'achievements-badge-desc-caffeinated' => 'per aver effettuato 100 modifiche nelle pagine in un solo giorno!',
	'achievements-badge-desc-luckyedit' => 'per aver effettuato la modifica fortunata n° $1 sulla wiki!',
	'achievements-userprofile-title-no' => 'Medaglie di $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Medaglia|Medaglie}} di $1 ($2)',
	'achievements-userprofile-no-badges-owner' => "Controlla l'elenco qui sotto per vedere le medaglie che puoi ottenere su questa wiki!",
	'achievements-userprofile-no-badges-visitor' => 'Questo utente non ha ancora ottenuto alcuna medaglia.',
	'achievements-userprofile-profile-score' => '<em>$1</em> Punti<br />in Successi',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|In $1ª posizione]]<br />su questa wiki',
	'action-platinum' => 'crea e modifica medaglie di platino',
	'achievements-next-oasis' => 'Successive',
	'achievements-prev-oasis' => 'Precedenti',
	'right-achievements-exempt' => "L'utente non è idoneo a guadagnare punti in successi",
	'right-achievements-explicit' => "L'utente è idoneo a guadagnare punti in successi (annulla eccezioni)",
);

$messages['ja'] = array(
	'achievementsii-desc' => 'コミュニティ編集者のためのアチーブメント・バッジシステム',
	'achievements-upload-error' => '申し訳ありません、この画像は使用できません。
.jpg もしくは .png のファイルをご利用ください。
それでもエラーになる場合、画像サイズが大きすぎないかご確認の上、
別の画像でお試しください。',
	'achievements-upload-not-allowed' => 'アドミンの方は、[[Special:AchievementsCustomize|アチーブメントのカスタマイズページ]]でアチーブメントバッジの名称と画像を変更できます。',
	'achievements-non-existing-category' => 'ご指定のカテゴリは存在しません',
	'achievements-edit-plus-category-track-exists' => '指定されたカテゴリは<a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="トラックに移動">すでにトラッキングされています</a>。',
	'achievements-no-stub-category' => 'スタブカテゴリのトラッキングは作成しないでください。',
	'right-platinum' => 'プラチナバッジの作成と編集',
	'achievements-platinum' => 'プラチナ',
	'achievements-gold' => 'ゴールド',
	'achievements-silver' => 'シルバー',
	'achievements-bronze' => 'ブロンズ',
	'achievements-gold-points' => '100<br />ポイント',
	'achievements-silver-points' => '50<br />ポイント',
	'achievements-bronze-points' => '10<br />ポイント',
	'achievements-you-must' => 'このバッジを獲得するには$1必要があります',
	'leaderboard-button' => 'アチーブメント・ランキング',
	'achievements-masthead-points' => '$1 <small>ポイント</small>',
	'achievements-profile-title-no' => '$1 が獲得したバッジ',
	'achievements-no-badges' => '下のリストで獲得できるバッジをチェックしてみましょう。',
	'achievements-track-name-edit' => 'トラッキングを編集',
	'achievements-track-name-picture' => '画像のトラッキング',
	'achievements-track-name-category' => 'カテゴリのトラッキング',
	'achievements-track-name-blogpost' => 'ブログ投稿のトラッキング',
	'achievements-track-name-blogcomment' => 'ブログコメントのトラッキング',
	'achievements-track-name-love' => 'お気に入りトラッキング',
	'achievements-notification-subtitle' => '$2 "$1" バッジが贈られました',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|他にも獲得できるバッジをチェック]]</big></strong>',
	'achievements-points' => '$1 ポイント',
	'achievements-points-with-break' => '$1<br />ポイント',
	'achievements-earned' => 'これまでに $1 人がこのバッジを獲得しました。',
	'achievements-profile-title' => '$1 が獲得したバッジ（$2 個）',
	'achievements-profile-title-challenges' => '獲得できるバッジ',
	'achievements-profile-customize' => 'バッジのカスタマイズ',
	'achievements-ranked' => 'このコミュニティ上でのランキング - #$1',
	'achievements-viewall' => 'すべて見る',
	'achievements-viewless' => '閉じる',
	'achievements-profile-title-oasis' => 'アチーブメント<br />ポイント',
	'achievements-ranked-oasis' => '$1 のこのコミュニティでのランキング - [[Special:Leaderboard|#$2]]',
	'achievements-viewall-oasis' => 'すべて見る',
	'achievements-toggle-hide' => 'アチーブメントをプロフィールページで表示しない',
	'leaderboard-intro-hide' => '閉じる',
	'leaderboard-intro-open' => '開く',
	'leaderboard-intro-headline' => 'アチーブメントとは？',
	'leaderboard-intro' => '画像をアップロードしたりコメントを残して、このコミュニティの編集に参加すると、バッジを獲得することができます。<br />バッジを獲得するとポイントが貯まり、アチーブメントのランキング順位に影響します。

各バッジで貯まるポイントは以下のとおりです。',
	'leaderboard' => 'アチーブメント・ランキング',
	'achievements-title' => 'アチーブメント',
	'leaderboard-title' => 'ランキング',
	'achievements-recent-earned-badges' => '最近獲得したバッジ',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br /><a href="$1">$2</a> が獲得<br />$5',
	'achievements-activityfeed-info' => '$2<br /><strong><a href="$3" class="badgeName">$1</a></strong> バッジを獲得',
	'achievements-leaderboard-disclaimer' => '昨日からの変化を表示しています',
	'achievements-leaderboard-rank-label' => 'ランキング',
	'achievements-leaderboard-member-label' => 'メンバー',
	'achievements-leaderboard-points-label' => 'ポイント',
	'achievements-leaderboard-points' => '{{PLURAL:$1|ポイント}}',
	'achievements-leaderboard-most-recently-earned-label' => '最近獲得したバッジ',
	'achievements-send' => '画像を保存',
	'achievements-save' => '変更を保存',
	'achievements-reverted' => 'バッジをデフォルトに戻しました',
	'achievements-customize' => '画像のカスタマイズ',
	'achievements-enable-track' => '有効',
	'achievements-revert' => 'デフォルトに戻す',
	'achievements-special-saved' => '変更が保存されました',
	'achievements-special' => '特別バッジ',
	'achievements-secret' => 'シークレットバッジ',
	'achievementscustomize' => 'バッジのカスタマイズ',
	'achievements-about-title' => 'このページについて',
	'achievements-about-content' => 'コミュニティのアドミンは、アチーブメント・バッジの名称と画像をカスタマイズすることができます。

.jpg もしくは .png の画像がアップロードでき、アップロードされた画像はバッジの枠に合うように自動的に調整されます。
この機能は画像が正方形、そして重要な部分が画像の中央にあるときに最もよく機能するようになっています。

長方形の画像を使うこともできますが、画像が切れて一部が枠から外れてしまうかもしれません。
画像編集ソフトをお持ちの場合は、画像をクロップして、重要な部分が中央に位置するようにしましょう。
選択した画像が思い通りにならなかったときは、「{{int:achievements-revert}}」 をクリックするともとの画像に戻すことができます。

各コミュニティで扱っている話題に合わせて、バッジの名称を設定することができます。
バッジの名称を変更したいときには、「{{int:achievements-save}}」 をクリックして変更を保存してください。',
	'achievements-edit-plus-category-track-name' => '"$1" 編集トラッキング',
	'achievements-create-edit-plus-category-title' => '編集トラッキングの作成',
	'achievements-create-edit-plus-category' => 'トラッキングを作成',
	'platinum' => 'プラチナ',
	'achievements-community-platinum-awarded-for' => '何をした時に獲得できるか:',
	'achievements-community-platinum-how-to-earn' => '獲得方法:',
	'achievements-community-platinum-awarded-for-example' => '例: 「.... の達成」',
	'achievements-community-platinum-how-to-earn-example' => '例: 「... を編集する」',
	'achievements-community-platinum-badge-image' => 'バッジ画像:',
	'achievements-community-platinum-awarded-to' => '獲得者の設定:',
	'achievements-community-platinum-current-badges' => '現在のプラチナバッジ',
	'achievements-community-platinum-create-badge' => 'バッジを作成',
	'achievements-community-platinum-enabled' => '有効',
	'achievements-community-platinum-show-recents' => '最近獲得したバッジの一覧に表示',
	'achievements-community-platinum-edit' => '編集',
	'achievements-community-platinum-save' => '保存',
	'achievements-community-platinum-cancel' => 'キャンセル',
	'achievements-badge-name-edit-0' => 'もっと良くできる！',
	'achievements-badge-name-edit-3' => 'コミュニティの仲間',
	'achievements-badge-name-edit-5' => 'Wiki ビルダー',
	'achievements-badge-name-edit-6' => 'Wiki リーダー',
	'achievements-badge-name-edit-7' => 'Wiki エキスパート',
	'achievements-badge-name-picture-0' => 'スナップショット',
	'achievements-badge-name-picture-1' => 'パパラッチ',
	'achievements-badge-name-picture-6' => 'デザイナー',
	'achievements-badge-name-category-3' => 'ツアー ガイド',
	'achievements-badge-name-blogpost-2' => 'トークショー',
	'achievements-badge-to-get-edit' => '$1 ページで $1 回編集',
	'achievements-badge-to-get-edit-plus-category' => '「$2」 のカテゴリのページで $1 回編集',
	'achievements-badge-to-get-picture' => '$1 ページに $1 枚の画像を追加',
	'achievements-badge-to-get-category' => '$1 件のページにカテゴリを追加する',
	'achievements-badge-to-get-blogpost' => 'ブログ記事を $1 件投稿',
	'achievements-badge-to-get-blogcomment' => '$1 件のブログ記事にコメントを投稿',
	'achievements-badge-to-get-love' => '$1 日間連続このコミュニティで投稿',
	'achievements-badge-to-get-welcome' => 'このコミュニティに参加',
	'achievements-badge-to-get-introduction' => 'ユーザーページを作成する',
	'achievements-badge-to-get-sayhi' => '他のユーザーのページにメッセージを残す',
	'achievements-badge-to-get-creator' => 'このコミュニティの作成者になる',
	'achievements-badge-to-get-caffeinated' => '1日に $1 回の編集を行う',
	'achievements-badge-to-get-luckyedit' => 'ラッキー',
	'achievements-badge-to-get-community-platinum-details' => 'このバッジは、期間限定で獲得可能な特別プラチナバッジです。',
	'achievements-badge-hover-desc-edit' => '$1 回の編集を達成',
	'achievements-badge-hover-desc-edit-plus-category' => '$2 件のカテゴリのページで $1 回の編集を達成',
	'achievements-badge-hover-desc-picture' => '$1 ページに <br />
$1 枚の画像の追加を達成',
	'achievements-badge-hover-desc-category' => '$1 件のページに<br />
カテゴリ追加を達成',
	'achievements-badge-hover-desc-blogpost' => '$1 件のブログ記事の投稿を達成',
	'achievements-badge-hover-desc-blogcomment' => '$1 件のブログ記事にコメント投稿を達成',
	'achievements-badge-hover-desc-love' => '$1 日間連続このコミュニティで投稿を達成',
	'achievements-badge-hover-desc-welcome' => 'このコミュニティへの参加達成',
	'achievements-badge-hover-desc-introduction' => 'ユーザーページの<br />
作成の達成',
	'achievements-badge-hover-desc-sayhi' => '他のユーザーのページに<br />メッセージ投稿を達成',
	'achievements-badge-hover-desc-creator' => 'このコミュニティの作成を達成',
	'achievements-badge-hover-desc-pounce' => 'ページ作成から1時間以内に 100 ページで編集を達成',
	'achievements-badge-hover-desc-caffeinated' => '1日で 100 回の編集を達成',
	'achievements-badge-hover-desc-luckyedit' => 'このコミュニティで $1 番目の編集を達成',
	'achievements-badge-hover-desc-community-platinum' => 'このバッジは、期間限定で獲得可能な特別プラチナバッジです。',
	'achievements-badge-your-desc-edit' => '$1 回の編集を達成',
	'achievements-badge-your-desc-edit-plus-category' => '「$2 」 カテゴリのページで $1 回の編集を達成',
	'achievements-badge-your-desc-picture' => '$1 ページに画像を $1 枚追加達成',
	'achievements-badge-your-desc-category' => '$1 ページにカテゴリの追加を達成',
	'achievements-badge-your-desc-blogpost' => '$1 件のブログ記事投稿を達成',
	'achievements-badge-your-desc-blogcomment' => '$1 件のブログ記事にコメント投稿を達成',
	'achievements-badge-your-desc-love' => '$1 日間連続このコミュニティで投稿を達成',
	'achievements-badge-your-desc-welcome' => 'このコミュニティへの参加達成',
	'achievements-badge-your-desc-introduction' => 'ユーザーページの作成を達成',
	'achievements-badge-your-desc-sayhi' => '他のユーザーのページにメッセージ投稿を達成',
	'achievements-badge-your-desc-creator' => 'このコミュニティの作成を達成',
	'achievements-badge-your-desc-pounce' => 'ページ作成から1時間以内に 100 ページで編集を達成',
	'achievements-badge-your-desc-caffeinated' => '1日で 100 回の編集を達成',
	'achievements-badge-your-desc-luckyedit' => 'このコミュニティで $1 番目の編集を達成',
	'achievements-badge-desc-edit' => '$1 ページで $1 回編集達成',
	'achievements-badge-desc-edit-plus-category' => '$2 件のカテゴリのページで $1 回の編集を達成',
	'achievements-badge-desc-picture' => '$1 ページに画像を $1 枚追加達成',
	'achievements-badge-desc-category' => '$1 ページに $1 件のカテゴリの追加を達成',
	'achievements-badge-desc-blogpost' => '$1 件のブログ記事の投稿を達成',
	'achievements-badge-desc-blogcomment' => '$1 件のブログ記事にコメント投稿を達成',
	'achievements-badge-desc-love' => '$1 日間連続このコミュニティで投稿を達成',
	'achievements-badge-desc-welcome' => 'このコミュニティへの参加達成',
	'achievements-badge-desc-introduction' => 'ユーザーページの作成の達成',
	'achievements-badge-desc-sayhi' => '他のユーザーのページにメッセージ投稿を達成',
	'achievements-badge-desc-creator' => 'このコミュニティの作成を達成',
	'achievements-badge-desc-pounce' => 'ページ作成から1時間以内に 100 ページで編集を達成',
	'achievements-badge-desc-caffeinated' => '1日で 100 回の編集を達成',
	'achievements-badge-desc-luckyedit' => 'このコミュニティで $1 番目の編集を達成',
	'achievements-userprofile-title-no' => '$1 が獲得したバッジ',
	'achievements-userprofile-title' => '$1 が獲得したバッジ ($2)',
	'achievements-userprofile-no-badges-owner' => '以下の一覧から、このコミュニティであなたが獲得できるバッジをチェックしてみよう！',
	'achievements-userprofile-no-badges-visitor' => 'このユーザーはまだバッジを獲得していません。',
	'achievements-userprofile-profile-score' => '<em>$1</em> アチーブメント<br />ポイント',
	'achievements-userprofile-ranked' => 'このコミュニティでの順位<br />[[Special:Leaderboard|$1 位]]',
	'right-sponsored-achievements' => 'スポンサー付きアチーブメントの管理',
	'action-platinum' => 'プラチナバッジを作成・編集',
	'achievements-track-name-sharing' => '共有トラック',
	'achievements-notification-title' => '$1さん、おめでとうございます！',
	'achievements-next-oasis' => '次へ',
	'achievements-prev-oasis' => '前へ',
	'achievements-customize-new-category-track' => 'カテゴリのトラッキングを新規作成：',
	'achievements-create-edit-plus-category-content' => '特定のカテゴリのページを編集してくれたユーザーがバッジをもらえるようにして、コミュニティ内でよく編集されている人気の部分をハイライトすることができます。
複数のカテゴリトラッキングを設定できるので、ファンなら知識を共有したくなるようなカテゴリを2つ選んでみましょう。
吸血鬼、オオカミ人間、魔法族とマグル、オートボッツとディセプティコンズなど、それぞれのページを編集するユーザー同士の競争心を刺激してみましょう。

「カテゴリの編集」のトラッキングを新たに作成するには、下の欄にカテゴリ名を入力します。
通常の編集トラッキングはそのまま残っているため、
別のトラッキングを作成して個別にカスタマイズすることができます。

トラッキングを作成すると、左側にある通常の編集トラッキングの下の一覧に新しいバッジが表示されます。
新しいトラッキングの名前や画像をカスタマイズして、ユーザーが見分けられるようにしましょう！

カスタマイズが完了したら、「{{int:achievements-enable-track}}」チェックボックスをクリックして新しいトラッキングをオンにし、「{{int:achievements-save}}」をクリックしましょう。
新しいトラッキングがユーザーのプロフィールに表示され、そのカテゴリでページを編集したユーザーはバッジを獲得できるようになります。
カテゴリのハイライトをやめたい場合には、トラッキングを無効にすることができます。
トラッキングが無効になっても、そのトラッキングでユーザーが獲得したバッジはそのまま残ります。

新しいトラッキング機能で、アチーブメントがより一層楽しくなりました。
早速試してみよう！',
	'achievements-community-platinum-awarded-email-subject' => '新しいプラチナバッジを獲得しました！',
	'achievements-community-platinum-awarded-email-body-text' => "$1さん、おめでとうございます！

$4（$3）で'$2'のプラチナバッジを獲得しました。
スコアに250ポイントが追加されます。

新しいバッジはユーザー・プロフィールのページでご確認いただけます。

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>$さん、おめでとうございます！</strong><br /><br />
<a href="$3">$4</a>で\'<strong>$2</strong>\'のプラチナバッジを獲得しました。
スコアに250ポイントが追加されます。<br /><br />
新しいバッジは<a href="$5">ユーザー・プロフィールのページ</a>でご確認いただけます。',
	'achievements-community-platinum-sponsored-label' => 'スポンサー付きのアチーブメント',
	'achievements-community-platinum-sponsored-hover-content-label' => 'マウスオーバー画像<small>（最小サイズ：270px x 100px）</small>：',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'バッジの表示回数の追跡URL：',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'マウスオーバーの表示回数の追跡URL：',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'バッジのリンク<small>（DARTのクリックコマンドURL）</small>：',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'クリックすると詳細を表示できます',
	'achievements-badge-name-edit-1' => 'まだまだ始まったばかり',
	'achievements-badge-name-edit-2' => '記録更新中',
	'achievements-badge-name-edit-4' => 'コラボレーター',
	'achievements-badge-name-picture-2' => 'イラストレーター',
	'achievements-badge-name-picture-3' => 'コレクター',
	'achievements-badge-name-picture-4' => 'アート好き',
	'achievements-badge-name-picture-5' => 'デコレーター',
	'achievements-badge-name-picture-7' => '写真家',
	'achievements-badge-name-category-0' => '繋がりの第一歩',
	'achievements-badge-name-category-1' => '先駆者',
	'achievements-badge-name-category-2' => '探求家',
	'achievements-badge-name-category-4' => 'ナビゲーター',
	'achievements-badge-name-category-5' => 'ブリッジビルダー',
	'achievements-badge-name-category-6' => 'Wiki プランナー',
	'achievements-badge-name-blogpost-0' => 'ブログビギナー',
	'achievements-badge-name-blogpost-1' => 'ブログ中級',
	'achievements-badge-name-blogpost-3' => 'ブログに夢中',
	'achievements-badge-name-blogpost-4' => '演説家',
	'achievements-badge-name-blogcomment-0' => '評論家',
	'achievements-badge-name-blogcomment-1' => 'その調子！',
	'achievements-badge-name-love-0' => '大切なメンバー',
	'achievements-badge-name-love-1' => '14日連続投稿',
	'achievements-badge-name-love-2' => '熱中',
	'achievements-badge-name-love-3' => 'ひたむき',
	'achievements-badge-name-love-4' => 'ほぼ中毒',
	'achievements-badge-name-love-5' => 'Wiki人生',
	'achievements-badge-name-love-6' => 'コミュニティのヒーロー',
	'achievements-badge-name-sharing-0' => 'シェア・ビギナー',
	'achievements-badge-name-sharing-1' => 'もっとシェア',
	'achievements-badge-name-sharing-2' => 'シェアに夢中',
	'achievements-badge-name-sharing-3' => 'シェアに熱中',
	'achievements-badge-name-sharing-4' => 'シェアに没頭中',
	'achievements-badge-name-welcome' => 'ようこそ',
	'achievements-badge-name-introduction' => '初めまして',
	'achievements-badge-name-sayhi' => 'ごあいさつ',
	'achievements-badge-name-creator' => 'クリエーター',
	'achievements-badge-name-pounce' => '急いで！',
	'achievements-badge-name-caffeinated' => 'パワー全開',
	'achievements-badge-name-luckyedit' => 'ラッキー',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|リンクをシェア|シェアしたリンクを{{PLURAL:$1|1人|$1人}} がクリック}}',
	'achievements-badge-to-get-pounce' => '急いで',
	'achievements-badge-to-get-sharing-details' => 'リンクをシェアして他のユーザーにクリックしてもらおう！',
	'achievements-badge-to-get-edit-details' => '追加したいことや
間違いがありましたか？
まずは「{{int:edit}}」ボタンをクリックして
知っていることを追加してみましょう！',
	'achievements-badge-to-get-edit-plus-category-details' => '「<strong>$1</strong>」のページはあなたの編集を待っています！
このカテゴリが入ったページで「{{int:edit}}」ボタンをクリックしてみましょう。
「$1」のページでご協力をお待ちしています！',
	'achievements-badge-to-get-picture-details' => '「{{int:edit}}」ボタン、「{{int:rte-ck-image-add}}」ボタンの順にクリックすると、
	PCやWiki上の別のページから写真を追加できます。',
	'achievements-badge-to-get-category-details' => 'カテゴリは、関連のあるページを見つけるのに役立ちます。
ページの下部にある「{{int:categoryselect-addcategory-button}}」ボタンをクリックすると、カテゴリの一覧にそのページを追加することができます。',
	'achievements-badge-to-get-blogpost-details' => '意見や質問を投稿してみましょう！
サイドバー「{{int:blogs-recent-url-text}}」の、左側にある「{{int:create-blog-post-title}}」のリンクをクリックしてください。',
	'achievements-badge-to-get-blogcomment-details' => 'ご意見をお寄せください！
最近のブログ投稿を読んで、コメント欄から意見や感想を投稿してみましょう。',
	'achievements-badge-to-get-love-details' => 'コミュニティにアクセスしない日があると、カウンターがリセットされてしまいます。毎日このコミュニティにアクセスしよう！',
	'achievements-badge-to-get-welcome-details' => '右上の「{{int:oasis-signup}}」ボタンをクリックすると、コミュニティに参加できます。
バッジ獲得を目指して頑張ろう！',
	'achievements-badge-to-get-introduction-details' => 'ユーザーページに何も追加されていないようです。
画面上部のユーザー名をクリックすると、ユーザーページを表示できます。
「{{int:edit}}」をクリックして自己紹介をしてみよう！',
	'achievements-badge-to-get-sayhi-details' => '他のユーザーのトークページで「{{int:addsection}}」をクリックすると、そのユーザーにメッセージを残すことができます。
質問したり、感謝の気持ちを伝えたり、あいさつしてみよう！',
	'achievements-badge-to-get-creator-details' => 'コミュニティの設立者が獲得できるバッジです。
上部の「{{int:createwiki}}」ボタンをクリックして、あなたも自分の好きなことについてのコミュニティを作成してみよう！',
	'achievements-badge-to-get-pounce-details' => 'このバッジを獲得するには急ぐ必要があるかも！？
「{{int:activityfeed}}」ボタンをクリックして、ユーザーが作成している新しいページを見つけてみよう！',
	'achievements-badge-to-get-caffeinated-details' => 'このバッジを獲得するには、たくさんの編集する必要があります。
継続して編集をしよう！',
	'achievements-badge-to-get-luckyedit-details' => 'このバッジを獲得するには、運が必要です。
継続して編集をしよう！',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|リンク1個を共有|{{PLURAL:$1|1人|$1人}}が共有リンクをクリック}}する',
	'achievements-badge-your-desc-sharing' => '{{#ifeq:$1|0|リンク1個をシェア|シェアしたリンクを{{PLURAL:$1|1人|$1人}} がクリック}} を達成',
	'achievements-badge-desc-sharing' => '{{#ifeq:$1|0|リンク1個のシェア|シェアしたリンクの{{PLURAL:$1|1|$1}} クリック}} を達成',
	'right-achievements-exempt' => 'ユーザーはアチーブメントの獲得に該当しません',
	'right-achievements-explicit' => 'ユーザーはアチーブメント獲得に該当します（除外設定されている場合でも適用）',
);

$messages['ka'] = array(
	'achievementsii-desc' => 'ვიკი მომხმარებლების მიღწევების სისტემა',
	'achievements-upload-error' => 'უკაცრავად!
ეს სურათი არ არის თავსებადი.
დარწმუნდით, რომ ეს ფაილი .jpg ან .png ფორმატისაა.
თუ კვლავაც არ მუშაობს, მაშინ სურათის ზომა ძალიან დიდია.
გთხოვთ, კიდევ სდადეთ!',
	'achievements-upload-not-allowed' => 'ადმინისტრატორებს შეუძლიათ შეცვალონ მიღწევების ნიშნების სახელები და სურათები სპეცგვერდზე [[Special:AchievementsCustomize|მიღწევების მართვა]].',
	'achievements-non-existing-category' => 'აღნიშნული კატეგორია არ არსებობს.',
	'achievements-edit-plus-category-track-exists' => 'აღნიშნული კატეგორია უკვე <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="ტრეკზე გადასვლა">დაკავშირებული ტრეკი</a>.',
	'achievements-no-stub-category' => 'გთხოვთ ნუ შექმნით ტრეკებს ბლანკებისათვის.',
	'right-platinum' => 'პლატინის ნიშნების შექმნა და რედაქტირება',
	'right-sponsored-achievements' => 'სარეკლამო მიღწევების მართვა',
	'achievements-platinum' => 'პლატინა',
	'achievements-gold' => 'ოქრო',
	'achievements-silver' => 'ვერცხლი',
	'achievements-bronze' => 'ბრინჯაო',
	'achievements-gold-points' => '100<br />ქულა',
	'achievements-silver-points' => '50<br />ქულა',
	'achievements-bronze-points' => '10<br />ქულა',
	'achievements-you-must' => 'თქვენ გჭირდებათ $1, რომ მიიღოთ ეს ნიშანი.',
	'leaderboard-button' => 'ლიდერები ჯილდოების მიხედვით',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|ქულა}}</small>',
	'achievements-profile-title-no' => 'მომხმარებელი $1 ნიშნები',
	'achievements-no-badges' => 'გადახედეთ სიას, რომ იხილოთ ნიშნები, რომლის მიღებაც შესაძლებელია ამ ვიკიში!',
	'achievements-track-name-edit' => 'ტრეკის რედაქტირება',
	'achievements-track-name-picture' => 'ტრეკის სურათი',
	'achievements-track-name-category' => 'ტრეკის კატეგორია',
	'achievements-track-name-blogpost' => 'შეტყობინება ტრეკის ბლოგში',
	'achievements-track-name-blogcomment' => 'კომენტარი ტრეკის ბლოგში',
	'achievements-track-name-love' => 'ვიკი-სიყვარულის ტრეკი',
	'achievements-track-name-sharing' => 'ტრეკის გაზიარება',
	'achievements-notification-title' => 'ესე გააგრძელე, $1!',
	'achievements-notification-subtitle' => 'თქვენ მიიღეთ ნიშანი "$1" $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|ნახეთ კიდევ რა ნიშნების მიღება შეგიძლიათ]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|ქულა}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|ქულა}}',
	'achievements-earned' => 'ეს ნიშანი მოპოვებულ იქნა $1 {{PLURAL:$1|მომხმარებლის}} მიერ.',
	'achievements-profile-title' => 'მომხმარებელმა $1 მიიღო $2 {{PLURAL:$2|ნიშანი}}',
	'achievements-profile-title-challenges' => 'შესაძლებელია დამატებითი ნიშნების მიღება!',
	'achievements-profile-customize' => 'ნიშნების კონფიგურაცია',
	'achievements-ranked' => 'რანგი #$1 ამ ვიკიში',
	'achievements-viewall' => 'ყველას ჩვენება',
	'achievements-viewless' => 'დახურვა',
	'achievements-profile-title-oasis' => 'მიღწევების <br /> ქულები',
);

$messages['khw'] = array(
	'achievements-gold' => 'سوروم',
);

$messages['km'] = array(
	'achievements-platinum' => 'ប្លាទីន',
	'achievements-gold' => 'មាស',
	'achievements-silver' => 'ប្រាក់',
	'achievements-bronze' => 'សំរិទ្ធ',
	'achievements-viewall' => 'បង្ហាញទាំងអស់',
	'achievements-viewless' => 'បិទ',
	'achievements-viewall-oasis' => 'មើលទាំងអស់',
	'leaderboard-intro-hide' => 'លាក់',
	'leaderboard-intro-open' => 'បើក',
	'achievements-leaderboard-rank-label' => 'ចំណាត់ថ្នាក់',
	'achievements-leaderboard-member-label' => 'សមាជិក',
	'achievements-send' => 'រក្សារូបភាពទុក',
	'achievements-save' => 'រក្សាបំលាស់ប្តូរទុក',
	'achievements-revert' => 'ត្រឡប់ទៅភាពដើមវិញ',
	'platinum' => 'ប្លាទីន',
	'achievements-community-platinum-edit' => 'កែប្រែ',
	'achievements-community-platinum-save' => 'រក្សាទុក',
	'achievements-community-platinum-cancel' => 'បោះបង់',
	'achievements-badge-name-sharing-0' => 'អ្នកចែករំលែក',
	'achievements-badge-name-sharing-3' => 'អ្នកផ្សព្វផ្សាយ',
	'achievements-badge-to-get-welcome' => 'ចូលរួមវិគី',
);

$messages['kn'] = array(
	'achievements-platinum' => 'ಪ್ಲಾಟಿನಂ',
	'achievements-gold' => 'ಸ್ವರ್ಣ',
	'achievements-silver' => 'ರಜತ',
	'achievements-bronze' => 'ಕಂಚು',
	'achievements-viewless' => 'ಮುಚ್ಚಿ',
	'leaderboard-intro-hide' => 'ಅಡಗಿಸು',
	'achievements-title' => 'ಸಾಧನೆಗಳು',
	'achievements-leaderboard-member-label' => 'ಸದಸ್ಯ',
	'achievements-save' => 'ಬದಲಾವಣೆಗಳನ್ನು ಉಳಿಸು',
	'platinum' => 'ಪ್ಲಾಟಿನಂ',
	'achievements-community-platinum-edit' => 'ಸಂಪಾದಿಸಿ',
	'achievements-community-platinum-save' => 'ಉಳಿಸಿ',
);

$messages['ko'] = array(
	'achievementsii-desc' => '위키 사용자의 기여도를 배지로 환산해주는 시스템',
	'achievements-upload-error' => '죄송합니다!
이 그림은 적합하지 않습니다.
그림의 확장자가 .jpg 또는.png 이어야 합니다.
또는 그림이 너무 무겁기 때문일수도 있습니다.
다른 그림으로 시도해보세요.',
	'achievements-upload-not-allowed' => '관리자는 [[특수기능:AchievementsCustomize|배지 설정]] 문서를 통해 배지의 이름과 그림을 변경할 수 있습니다.',
	'achievements-non-existing-category' => '지정한 분류가 존재하지 않습니다.',
	'achievements-no-stub-category' => '토막글을 위한 트랙을 생성하지 말아주세요.',
	'achievements-platinum' => '플래티넘',
	'achievements-gold' => '골드',
	'achievements-silver' => '실버',
	'achievements-bronze' => '브론즈',
	'achievements-gold-points' => '100 포인트',
	'achievements-silver-points' => '50 포인트',
	'achievements-bronze-points' => '10 포인트',
	'achievements-you-must' => '이 배지를 얻기 위해서는 $1이(가) 필요합니다.',
	'leaderboard-button' => '배지 현황판',
	'achievements-masthead-points' => '$1 <small>포인트</small>',
	'achievements-profile-title-no' => '$1의 배지',
	'achievements-no-badges' => '아래 목록에서 이 위키에서 얻을 수 있는 배지를 찾아보실 수 있습니다.',
	'achievements-track-name-edit' => '편집 트랙',
	'achievements-track-name-picture' => '그림 트랙',
	'achievements-track-name-category' => '분류 트랙',
	'achievements-track-name-blogpost' => '블로그 글 트랙',
	'achievements-track-name-blogcomment' => '블로그 댓글 트랙',
	'achievements-track-name-love' => '위키 사랑 트랙',
	'achievements-notification-title' => '$1님 축하드립니다!',
	'achievements-notification-subtitle' => "회원님께서는 $2 '$1' 배지를 얻었습니다.",
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|얻을 수 있는 더 많은 배지 보기]]</big></strong>',
	'achievements-points' => '$1 포인트',
	'achievements-points-with-break' => '$1<br />포인트',
	'achievements-earned' => '$1명의 사용자가 이 배지를 갖고 있습니다.',
	'achievements-profile-title' => '$1 사용자가 소유하고 있는 $2개의 배지 목록',
	'achievements-profile-title-challenges' => '받을 수 있는 배지 목록',
	'achievements-profile-customize' => '배지 설정 >',
	'achievements-ranked' => '이 위키의 $1위',
	'achievements-viewall' => '모두 보기',
	'achievements-viewless' => '닫기',
	'achievements-viewall-oasis' => '전체 보기',
	'leaderboard-intro-hide' => '숨기기',
	'leaderboard-intro-open' => '보이기',
	'leaderboard-intro' => "위키에서 문서를 편집하고 파일을 올리고 댓글을 남김으로서 배지를 얻으실 수 있습니다. 배지를 얻게 되면 그에 대응하는 포인트도 획득하실 수 있으며 많은 포인트를 얻을수록 리더보드에서 더 높은 자리에 위치할 수 있게 됩니다. 얻으신 배지는 회원님의 [[$1|사용자 문서]]에서 확인하실 수 있습니다.

'''배지는 얼마나 가치가 있나요?'''",
	'leaderboard' => '배지 순위',
	'leaderboard-title' => '배지 현황판',
	'achievements-recent-earned-badges' => '최근에 수여된 배지',
	'achievements-recent-info' => '$5 <a href="$1">$2</a> 사용자가 \'$4\' 조건을 달성하였으므로 \'$3\' 배지를 얻었습니다.',
	'achievements-leaderboard-disclaimer' => '이 목록은 어제 이후의 변경 사항을 보여주고 있습니다.',
	'achievements-leaderboard-rank-label' => '순위',
	'achievements-leaderboard-member-label' => '사용자',
	'achievements-leaderboard-points-label' => '포인트',
	'achievements-leaderboard-points' => '{{PLURAL:$1|포인트|포인트}}',
	'achievements-send' => '그림 저장',
	'achievements-save' => '바뀐 사항 저장',
	'achievements-reverted' => '배지를 초기값으로 되돌렸습니다.',
	'achievements-customize' => '배지 그림 사용자 정의',
	'achievements-revert' => '초기 설정으로 되돌리기',
	'achievements-special-saved' => '변경 사항이 저장되었습니다.',
	'achievementscustomize' => '배지 설정',
	'achievements-about-title' => '이 문서에 대해서...',
	'platinum' => '플래티넘',
	'achievements-community-platinum-awarded-email-subject' => '당신은 방금 새로운 플래티넘 배지를 받았습니다!',
	'achievements-community-platinum-how-to-earn' => '얻는 방법 :',
	'achievements-community-platinum-awarded-for-example' => "예시 : '~을(를) 했으므로...'",
	'achievements-community-platinum-how-to-earn-example' => '예시 : "기여 3회"',
	'achievements-community-platinum-badge-image' => '배지 그림:',
	'achievements-community-platinum-create-badge' => '배지 만들기',
	'achievements-community-platinum-edit' => '편집',
	'achievements-community-platinum-save' => '저장',
	'achievements-badge-name-edit-0' => '차이를 만들어요',
	'achievements-badge-name-edit-1' => '시작에 불과해요',
	'achievements-badge-name-edit-3' => '위키의 친구',
	'achievements-badge-name-edit-4' => '협력가',
	'achievements-badge-name-edit-5' => '위키 빌더',
	'achievements-badge-name-edit-6' => '위키 리더',
	'achievements-badge-name-edit-7' => '위키 전문가',
	'achievements-badge-name-picture-0' => '스냅샷',
	'achievements-badge-name-picture-1' => '파파라치',
	'achievements-badge-name-picture-2' => '일러스트레이터',
	'achievements-badge-name-picture-3' => '수집가',
	'achievements-badge-name-picture-4' => '그림 애호가',
	'achievements-badge-name-picture-5' => '데코레이터',
	'achievements-badge-name-picture-6' => '디자이너',
	'achievements-badge-name-picture-7' => '큐레이터',
	'achievements-badge-name-category-2' => '탐험가',
	'achievements-badge-name-category-3' => '관광 가이드',
	'achievements-badge-name-category-4' => '항해사',
	'achievements-badge-name-category-6' => '위키 플래너',
	'achievements-badge-name-blogpost-0' => '말할 게 있어요',
	'achievements-badge-name-blogpost-2' => '토크 쇼',
	'achievements-badge-name-blogpost-4' => '연설가',
	'achievements-badge-name-blogcomment-0' => '오피니어네이터',
	'achievements-badge-name-love-6' => '위키 영웅',
	'achievements-badge-name-sharing-3' => '아나운서',
	'achievements-badge-name-welcome' => '위키에 어서 오세요',
	'achievements-badge-name-creator' => '설립자',
	'achievements-badge-to-get-edit' => '$1개의 문서에 기여를 {{PLURAL:$1|한 번|$1번}} 해 주세요',
	'achievements-badge-to-get-edit-plus-category' => '$2개의 문서에 기여를 {{PLURAL:$1|한 번|$1번}} 해 주세요',
	'achievements-badge-to-get-picture' => '$1개의 문서에 $1개의 그림을 추가해주세요',
	'achievements-badge-to-get-category' => '$1개의 문서에 $1개의 분류를 추가해주세요',
	'achievements-badge-to-get-blogpost' => '블로그 글을 $1개 작성해주세요',
	'achievements-badge-to-get-blogcomment' => '{{PLURAL:$1|한 개의|$1개의 다른}} 블로그 글에 댓글을 작성해주세요',
	'achievements-badge-to-get-love' => '위키에 $1일동안 매일 기여해주세요',
	'achievements-badge-to-get-welcome' => '위키에 방문해주세요',
	'achievements-badge-to-get-introduction' => '당신의 사용자 문서를 만드세요',
	'achievements-badge-to-get-sayhi' => '다른 사용자의 사용자 문서에 메시지를 남겨주세요',
	'achievements-badge-to-get-creator' => '위키를 개설하세요',
	'achievements-badge-to-get-caffeinated' => '하루에 $1번의 기여를 해주세요',
	'achievements-badge-to-get-luckyedit' => '행운을 빌어요',
	'achievements-badge-your-desc-edit' => '{{PLURAL:$1|문서|문서들}}에 {{PLURAL:$1|첫 기여|$1회의 기여}}을 해주셨으므로',
	'achievements-badge-your-desc-edit-plus-category' => '{{PLURAL:$1|문서|문서들}}에 {{PLURAL:$1|첫 기여|$1회의 기여}}을 해주셨으므로',
	'achievements-badge-your-desc-picture' => '{{PLURAL:$1|문서|문서들}}에 {{PLURAL:$1|그림|$1장의 그림}}을 추가하셨으므로',
	'achievements-badge-your-desc-category' => '{{PLURAL:$1|한 문서|$1개의 문서}}에 {{PLURAL:$1|하나의 분류를|분류들을}} 추가하셨으므로',
	'achievements-badge-your-desc-blogpost' => '{{PLURAL:$1|첫 블로그 글|$1개의 블로그 글들}}을 작성하셨으므로',
	'achievements-badge-your-desc-blogcomment' => '{{PLURAL:$1|블로그 글|$1개의 다른 블로그 글들}}에 댓글을 달아주셨으므로',
	'achievements-badge-your-desc-love' => '{{PLURAL:$1|하루|$1일}}동안 꾸준히 기여를 해주셨으므로',
	'achievements-badge-your-desc-welcome' => '위키에 처음 방문하셨으므로',
	'achievements-badge-your-desc-introduction' => '자신의 사용자 문서를 만드셨으므로',
	'achievements-badge-your-desc-sayhi' => '다른 사용자의 토론 문서에 메시지를 남기셨으므로',
	'achievements-badge-your-desc-creator' => '위키를 생성하셨으므로',
	'achievements-badge-your-desc-pounce' => '한 시간 내에 100개의 문서에 기여를 해주셨으므로',
	'achievements-badge-your-desc-caffeinated' => '하루에 100회의 기여를 해주셨으므로',
	'achievements-badge-your-desc-luckyedit' => '위키에 $1번째 편집을 해주셨으므로',
	'achievements-userprofile-title-no' => '$1 사용자가 획득한 배지',
	'achievements-userprofile-title' => '$1 사용자가 획득한 배지 ($2)',
	'achievements-userprofile-no-badges-owner' => '다음 목록에서 이 위키에서 획득하실 수 있는 배지들을 확인해보세요.',
	'achievements-userprofile-no-badges-visitor' => '이 사용자는 아직 아무 배지도 획득하지 않았습니다.',
	'achievements-userprofile-profile-score' => '<em>$1</em> <br />포인트',
	'achievements-userprofile-ranked' => '이 위키에서<br />[[Special:Leaderboard|$1위]]입니다',
	'achievements-badge-to-get-sayhi-details' => "'{{int:tooltip-ca-addsection}}' 링크를 클릭하시면 다른 사용자에게 메시지를 남길 수 있습니다.
도움을 요청하거나, 그들의 기여에 감사하거나, 안부를 전하세요.",
	'achievements-about-content' => "위키의 관리자는 배지의 이름과 그림을 관리할 수 있습니다.

.jpg나 .png 그림을 올리시면 자동으로 크기에 맞도록 조절됩니다.
중요한 부분이 정중앙에 있는 정사각형 모양의 그림이 가장 좋습니다.

직사각형 모양의 그림을 사용하실 수도 있지만 크기를 조절하는 과정에서 그림이 잘릴 가능성이 있습니다.
그림을 편집할 수 있는 프로그램이 있다면 중요한 부분이 가운데에 있도록 잘라내서 올려주세요.
그림을 편집할 수 있는 프로그램이 없다면 적합한 그림이 나올 때까지 다양한 그림으로 시도해보세요.
올린 배지 그림이 마음에 들지 않으신다면 '{{int:achievements-revert}}'를 클릭하셔서 원래 그림으로 되돌리실 수 있습니다.

위키가 다루는 주제에 맞도록 배지의 이름을 새로 부여하는 것도 물론 가능합니다.
배지의 이름을 바꾸셨다면 '{{int:achievements-save}}'을 클릭하셔서 변경 사항을 저장해주세요.",
	'achievements-activityfeed-info' => '<strong><a href="$3" class="badgeName">$1</a></strong> 배지를 얻었습니다.
<br />획득 방법: $2',
	'achievements-badge-desc-blogcomment' => '$1개의 블로그 글에 댓글을 작성하세요.',
	'achievements-badge-desc-blogpost' => '{{PLURAL:$1|첫 블로그 글|$1개의 블로그 글들}}을 작성하세요.',
	'achievements-badge-desc-caffeinated' => '하루에 100회 기여해주세요.',
	'achievements-badge-desc-category' => '$1개의 문서에 분류를 추가해주세요.',
	'achievements-badge-desc-creator' => '위키를 생성하세요.',
	'achievements-badge-desc-edit-plus-category' => '$2개의 문서에 $1회 기여해주세요.',
	'achievements-badge-desc-edit' => '{{PLURAL:$1|한|여러}} 문서에 $1회 기여해주세요.',
	'achievements-badge-desc-introduction' => '자신의 사용자 문서를 만들어보세요.',
	'achievements-badge-desc-love' => '위키에 $1일동안 매일 기여해주세요.',
	'achievements-badge-desc-luckyedit' => '위키에서 행운의 $1번째 기여를 해주세요.',
	'achievements-badge-desc-picture' => '{{PLURAL:$1|한|여러}} 문서에 $1장의 그림을 추가해주세요.',
	'achievements-badge-desc-sayhi' => '다른 사용자의 토론 문서에 메시지를 남기세요.',
	'achievements-badge-desc-welcome' => '위키에서 활동을 시작해보세요.',
	'achievements-badge-hover-desc-blogcomment' => '$1개의 블로그 글에 댓글을 작성하였습니다.',
	'achievements-badge-hover-desc-blogpost' => '{{PLURAL:$1|첫 블로그 글|$1개의 블로그 글들}}을 작성하였습니다.',
	'achievements-badge-hover-desc-caffeinated' => '하루에 100회 기여했습니다.',
	'achievements-badge-hover-desc-category' => '$1개의 문서에 분류를 추가했습니다.',
	'achievements-badge-hover-desc-community-platinum' => '이 배지는 받을 수 있는 기간이 한정되어 있는 특별한 플래티넘 배지입니다.',
	'achievements-badge-hover-desc-creator' => '위키를 생성하였습니다.',
	'achievements-badge-hover-desc-edit-plus-category' => '$2개의 문서에 $1회 기여했습니다.',
	'achievements-badge-hover-desc-edit' => '{{PLURAL:$1|한|여러}} 문서에 $1회 기여하였습니다.',
	'achievements-badge-hover-desc-introduction' => '자신의 사용자 문서를 작성하였습니다.',
	'achievements-badge-hover-desc-love' => '위키에 $1일동안 매일 기여했습니다.',
	'achievements-badge-hover-desc-luckyedit' => '위키에서 행운의 $1번째 기여를 했습니다.',
	'achievements-badge-hover-desc-picture' => '{{PLURAL:$1|한|여러}} 문서에 $1장의 그림을 추가했습니다.',
	'achievements-badge-hover-desc-sayhi' => '다른 사용자의 토론 문서에 메시지를 남겼습니다.',
	'achievements-badge-hover-desc-welcome' => '위키에서 활동을 시작했습니다.',
	'achievements-badge-name-blogcomment-1' => '그리고 하나 더',
	'achievements-badge-name-blogpost-1' => '말하고 싶은 5가지',
	'achievements-badge-name-blogpost-3' => '파티 인생',
	'achievements-badge-name-caffeinated' => '카페인 중독',
	'achievements-badge-name-category-0' => '연결 고리를 만들어요',
	'achievements-badge-name-category-1' => '개척자',
	'achievements-badge-name-category-5' => '교량 건축가',
	'achievements-badge-name-edit-2' => '흔적을 남겨요',
	'achievements-badge-name-introduction' => '자기 소개',
	'achievements-badge-name-love-0' => '위키의 핵심!',
	'achievements-badge-name-love-1' => '위키에서의 2주',
	'achievements-badge-name-love-2' => '헌신하는',
	'achievements-badge-name-love-3' => '전념하는',
	'achievements-badge-name-love-4' => '위키 중독',
	'achievements-badge-name-love-5' => '위키 인생',
	'achievements-badge-name-luckyedit' => '럭키 편집',
	'achievements-badge-name-pounce' => '폭풍!',
	'achievements-badge-name-sayhi' => '인사하러 들렀어요',
	'achievements-badge-name-sharing-0' => '공유자',
	'achievements-badge-name-sharing-2' => '스피커',
	'achievements-badge-name-sharing-4' => '전도사',
	'achievements-badge-to-get-blogcomment-details' => '아무 블로그 글에 댓글을 남겨주세요.',
	'achievements-badge-to-get-blogpost-details' => '회원님의 생각을 글로 표현해주세요.
사이드바의 "{{int:blogs-recent-url-text}}" 메뉴를 클릭하신 후에 "{{int:create-blog-post-title}}"를 클릭하여 글을 작성하세요.',
	'achievements-badge-to-get-caffeinated-details' => '이 배지를 얻기 위해서는 하루를 바쁘게 보내야 합니다.
꾸준히 기여해주세요!',
	'achievements-badge-to-get-category-details' => '분류는 문서를 찾기 쉽도록 만드는 태그와 같습니다.
문서 아래의 "{{int:categoryselect-addcategory-button}}" 버튼을 클릭하신 후에 문서에 맞는 분류를 추가해주세요.',
	'achievements-badge-to-get-community-platinum-details' => '이 플래티넘 배지는 한정된 시간에만 얻으실 수 있습니다.',
	'achievements-badge-to-get-creator-details' => '이 배지는 이 위키를 개설한 사용자에게만 주어집니다.
"{{int:createwiki}}" 버튼을 누르셔서 위키를 개설해보세요.',
	'achievements-badge-to-get-edit-details' => '무언가 보충할 게 있으신가요?
오타가 있나요?
두려워하지 마세요.
"{{int:edit}}" 버튼을 눌러 과감하게 고쳐주세요.',
	'achievements-badge-to-get-edit-plus-category-details' => "<strong>$1</strong>개의 문서가 회원님의 도움을 필요로 합니다. 
아무 문서에서나 '{{int:edit}}' 버튼을 눌러 그 문서에 기여해주세요.",
	'achievements-badge-to-get-introduction-details' => "아직 사용자 문서를 만들지 않으셨나요?
페이지 상단의 계정 이름을 클릭해보세요.
클릭하신 후 나오는 화면에서 '편집' 버튼을 누르신 후 회원님에 대해 글로 간단히 표현해보세요.",
	'achievements-badge-to-get-love-details' => '하루라도 놓치면 수치가 초기화되므로 매일매일 위키에 방문해주세요.',
	'achievements-badge-to-get-luckyedit-details' => '이 배지를 얻기 위해서는 행운이 필요합니다.
꾸준한 기여 부탁드립니다.',
	'achievements-badge-to-get-picture-details' => "'{{int:edit}}' 버튼을 누르신 후 '{{int:rte-ck-image-add}}' 버튼을 눌러 그림을 추가하실 수 있습니다.
컴퓨터에서 직접 올리실 수도 있고 이미 위키에 올려져 있는 그림을 넣을 수도 있습니다.",
	'achievements-badge-to-get-pounce-details' => "이 배지를 얻기 위해서는 민첩해져야 합니다.
'{{int:activityfeed}}' 버튼을 눌러 다른 사용자들이 생성하는 문서를 주시하세요.",
	'achievements-badge-to-get-pounce' => '민첩하게 행동하세요',
	'achievements-badge-to-get-welcome-details' => "페이지 상단의 '{{int:autocreatewiki-create-account}}' 버튼을 눌러 위키에 가입해보세요.
가입하신 후에 배지를 획득하실 수 있습니다!",
	'achievements-community-platinum-awarded-for' => '수여 이유:',
	'achievements-community-platinum-current-badges' => '현재 존재하는 플래티넘 배지',
	'achievements-create-edit-plus-category-content' => "특정한 분류에 있는 문서를 대상으로 배지를 수여하는 편집 트랙을 생성하실 수 있습니다. 주로 특정 분류의 문서들에 대한 기여를 장려하는 목적으로 활용되고 있습니다.
하나 이상의 편집 트랙을 생성하실 수 있으므로 둘 이상이 되면 사용자들이 전문적으로 기여하는 분야에 대해 알아보실 수도 있습니다.
두 개 이상의 편집 트랙을 생성하여 둘 간에 경쟁 구도를 형성시키는 것도 좋은 방법입니다,

특정 분류에 대한 편집 트랙을 생성하시려면 아래 빈칸에 해당하는 분류의 이름을 입력하세요.
특정 분류에 대한 편집 트랙이 생성되어도 기존에 전체를 대상으로 하는 편집 트랙은 그대로 남아있게 됩니다.

새로운 트랙이 만들어지면 새로운 배지들의 목록은 전체를 대상으로 하는 편집 트랙의 아래에 나오게 됩니다.
배지의 이름과 그림을 새로 지정하셔서 사용자들이 차이를 볼 수 있도록 하는 것이 좋습니다.

커스터마이징을 완료하셨다면 '{{int:achievements-enable-track}}'에 체크하신 후 '{{int:achievements-save}}' 버튼을 눌러 트랙을 활성화하면 됩니다.
트랙이 활성화되면 위키의 사용자들은 새 트랙이 그들의 사용자 문서에 나타나는 것을 볼 수 있게 되며 그 분류에 속해있는 문서를 편집할 때 해당하는 배지를 받을 수 있습니다.
나중에 더 이상 필요가 없다고 생각하신다면 생성한 트랙을 비활성화할 수도 있습니다. 
허나 비활성화해도 사용자들이 기존에 그 트랙에서 받은 배지는 그대로 유지됩니다.

새 트랙을 만드셔서 새로운 차원의 즐거움을 누리시기 바랍니다.",
	'achievements-create-edit-plus-category-title' => '새로운 편집 트랙 만들기',
	'achievements-create-edit-plus-category' => '트랙 생성',
	'achievements-customize-new-category-track' => '다음 분류에 있는 문서를 대상으로 하는 편집 트랙 생성:',
	'achievements-edit-plus-category-track-name' => '$1 편집 트랙',
	'achievements-enable-track' => '활성화',
	'achievements-leaderboard-most-recently-earned-label' => '최근에 수여된 배지',
	'achievements-profile-title-oasis' => ' <br /> 포인트',
	'achievements-ranked-oasis' => '$1 사용자는 이 위키에서 [[Special:Leaderboard|$2위]]입니다',
	'achievements-secret' => '숨겨진 트랙',
	'achievements-special' => '특별 트랙',
	'achievements-title' => '배지 현황판',
	'achievements-toggle-hide' => '내 사용자 문서에서 받은 배지와 배지 순위를 공개하지 않기',
	'achievements-track-name-sharing' => '공유 트랙',
	'leaderboard-intro-headline' => '배지란 무엇인가요?',
);

$messages['krj'] = array(
	'achievements-upload-error' => 'Pasaylo!
Ang litrato wara naga gana.
Siguraduha nga .jpeg o kun .png ang litrato.
Kun wara pa gid nag gana, ang litrato nali tam-an ka bug-at.
Palihog tirawi nga mag gamit ka iba nga litrato!',
	'achievements-gold' => 'Bulawan',
	'achievements-silver' => 'Pilak',
	'achievements-bronze' => 'Tanso',
	'achievements-viewall' => 'Lantawon ang tanan',
	'achievements-viewless' => 'Isarado',
	'achievements-viewall-oasis' => 'Lantawon ang tanan',
	'leaderboard-intro-hide' => 'Itago',
	'leaderboard-intro-open' => 'Bukas',
	'achievements-leaderboard-member-label' => 'Imaw',
);

$messages['ksh'] = array(
	'achievementsii-desc' => 'E Süßteem för Afzeische för Leißtunge em Wiki verdeene.',
	'achievements-upload-not-allowed' => 'Dem Wiki sing Köbeße künne de Naame un Belder vun de [[Special:AchievementsCustomize|Afzeische ändere]].',
	'achievements-non-existing-category' => 'De aanjejovve Saachjropp jidd_et nit.',
	'right-platinum' => 'Afzeische us Plaatin äschaffe un ändere',
	'achievements-platinum' => 'Plaatin',
	'achievements-gold' => 'Jold',
	'achievements-silver' => 'Selver',
	'achievements-bronze' => 'Brongße',
	'achievements-gold-points' => '100<br />Pkte.',
	'achievements-silver-points' => '50<br />Pkte.',
	'achievements-bronze-points' => '10<br />Pkte.',
	'achievements-you-must' => 'Do moß ald $1, öm dä Orde ze verdeene.',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|Punk|Punkte|Punkte}}</small>',
	'achievements-profile-title-no' => '{{GENDER:$1|Däm|Däm|Däm Metmaacher|Dä|Däm}} $1 {{GENDER:$1|sing|sing|sing|ier|sing}} Afzeische',
	'achievements-no-badges' => 'Loor op heh di Leß, doh sen de Afzeische dren, di De Der heh em Wiki verdeene kanns!',
	'achievements-points' => '{{PLURAL:$1|eine Punk|$1 Punkte|kein Punkte}}',
	'achievements-profile-title-challenges' => 'Mieh Afzeische, di De Der verdeene kanns!',
	'achievements-profile-customize' => 'Afzeische aanpaße',
	'achievements-ranked' => 'Op Plaz $1 en heh däm Wiki',
	'achievements-viewall' => 'Alle aanloore',
	'achievements-viewless' => 'Zohmaache',
	'achievements-viewall-oasis' => 'Looer alle aan',
	'leaderboard-intro-hide' => 'usblende',
	'leaderboard-intro-open' => 'opmaache',
	'achievements-recent-earned-badges' => 'Zoläz verdeente Afzeische',
	'achievements-leaderboard-rank-label' => 'Rang',
	'achievements-leaderboard-points-label' => 'Pünkscher',
	'achievements-leaderboard-points' => '{{PLURAL:$1|Pünksche|Pünkscher|Pünkscher}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Zoläz verdeent',
	'achievements-send' => 'Beld avshpeishere!',
	'achievements-save' => 'Änderunge avspeichere',
	'achievements-reverted' => 'Dat Afzeische es retuur ob_et Ojinaal.',
	'achievements-customize' => 'Et Beld sellver aanpaße',
	'achievements-enable-track' => 'enjeschalldt',
	'achievements-revert' => 'Retuur noh_m Shtandatt',
	'achievements-special-saved' => 'Änderonge faßjehallde',
	'achievementscustomize' => 'Afzeische aanpaße',
	'achievements-about-title' => 'Övver heh di Sigg&nbsp;…',
	'platinum' => 'Plaatin',
	'achievements-community-platinum-awarded-email-subject' => 'Do häs e neu Afzeische us Plaatin krääje!',
	'achievements-community-platinum-awarded-for' => 'Belohnt för:',
	'achievements-community-platinum-how-to-earn' => 'Wih verdeene?',
	'achievements-community-platinum-badge-image' => 'Et Beld för dat Afzeische',
	'achievements-community-platinum-awarded-to' => 'Verdeent vum:',
	'achievements-community-platinum-current-badges' => 'Aktoälle Afzeische uß Plaatin',
	'achievements-community-platinum-create-badge' => 'E Afzeische maache',
	'achievements-community-platinum-enabled' => 'enjeschalldt',
	'achievements-community-platinum-show-recents' => 'en de neuste Afzeische aanzeije',
	'achievements-community-platinum-edit' => 'ändere',
	'achievements-community-platinum-save' => 'afspeichere',
	'achievements-community-platinum-cancel' => 'Stopp! Avbreche!',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Kleck, öm mieh ze lässe',
	'achievements-badge-name-edit-0' => 'Määt ene Ongerscheid',
	'achievements-badge-name-edit-1' => 'Blooß der Aanfang',
	'achievements-badge-name-edit-2' => 'Ene Endrock hengerlohße',
	'achievements-badge-name-edit-3' => 'Fründ vum Wiki',
	'achievements-badge-name-edit-4' => 'Metmaacher',
	'achievements-badge-name-edit-5' => 'Wiki-Opbouer',
	'achievements-badge-name-edit-6' => 'Aanföhrer vum Wiki',
	'achievements-badge-name-edit-7' => 'Äxpäät vum Wiki',
	'achievements-badge-name-picture-0' => 'Schnappschoß',
	'achievements-badge-name-picture-1' => 'Papparazi',
	'achievements-badge-name-picture-2' => 'Beldermäächer',
	'achievements-badge-name-picture-3' => 'Sammler',
	'achievements-badge-name-picture-4' => 'Hät Kunß jään',
	'achievements-badge-name-picture-5' => 'Dekeratöör',
	'achievements-badge-name-picture-6' => 'Jeschtallder',
	'achievements-badge-name-picture-7' => 'Kurator',
	'achievements-badge-name-category-0' => 'Maach en Verbendung',
	'achievements-badge-name-category-1' => 'Wääch frei Määcher',
	'achievements-badge-name-category-2' => 'Fochscher',
	'achievements-badge-name-category-3' => 'Aanföhrer vun ene Tuur',
	'achievements-badge-name-category-4' => 'Stüürmann',
	'achievements-badge-name-category-5' => 'Bröckebouer',
	'achievements-badge-name-category-6' => 'Wiki_Planer',
	'achievements-badge-name-blogpost-0' => 'Hät jät ze verzälle',
	'achievements-badge-name-blogpost-1' => 'Hät fönef Saache ze saare',
	'achievements-badge-name-blogpost-3' => 'Et Häz vun de Pattei',
	'achievements-badge-name-blogpost-4' => 'Öffentlesch Reddeschwenger',
	'achievements-badge-name-blogcomment-1' => 'Un norr_en Saach',
	'achievements-badge-name-love-6' => 'Held vum Wiki',
	'achievements-badge-name-sharing-3' => 'Bekanntmaacher',
	'achievements-badge-name-welcome' => 'Welkumme em Wiki',
	'achievements-badge-name-introduction' => 'Enföhrung',
	'achievements-badge-name-creator' => 'Dä Jrönder',
	'achievements-badge-name-pounce' => 'Bomm!',
	'achievements-badge-name-luckyedit' => 'Jlöcklesche Änderong',
	'achievements-badge-to-get-pounce' => 'flöck sin',
	'achievements-badge-to-get-caffeinated' => 'maach {{PLURAL:$1|ein Änderong|$1 Änderonge|kein Änderong}} aan Sigge en enem einzijje Daach',
	'achievements-badge-to-get-luckyedit' => 'jöcklesch sin',
	'achievements-badge-to-get-community-platinum-details' => 'Dat es en extra Afzeische us Plaatin, wat bloß för en jeweße Zigg ze han es!',
	'achievements-badge-hover-desc-sharing' => 'för {{#ifeq:$1|0|ene Lengk jedeilt ze han|{{PLURAL:$1|eine Minsch|$1 Lück|Keine}} dozoh jebraat ze han, op ene jedeilte Lengk ze klecke}}!',
	'achievements-badge-hover-desc-edit' => 'för {{PLURAL:$1|ein Änderong|$1 Änderonge|kein Änderong}}<br />
op {{PLURAL:$1|eine Sigg|$1 Sigge|keine Sigg}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'för {{PLURAL:$1|ein Änderong|$1 Änderonge|kein Änderonge}} op<br />
{{PLURAL:$2|ein Sigg|$2 Sigge|keine Sigge}} jemaat ze han!',
	'achievements-badge-hover-desc-picture' => 'för {{PLURAL:$1|ein Beld|$1 Belder|kein Beld}} en<br />
{{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigge}} jedonn ze han!',
	'achievements-badge-hover-desc-category' => 'för {{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigg}} en<br />
{{PLURAL:$1|ein Saachjropp|$1 Saachjroppe|keine Saachjropp}} jedonn ze han!',
	'achievements-badge-hover-desc-blogpost' => 'för {{PLURAL:$1|eine Beidraach|$1 Beidrääsch|kein Beidrääch}} zo enem <i lang="en">blog</i> jeschrevve ze han!',
	'achievements-badge-hover-desc-blogcomment' => 'för ene Beidraach zo {{PLURAL:$1|enem<br /><i lang="en">blog</i> |<br />$1 <i lang="en">blogs</i> |keinem<br /><i lang="en">blog</i> }} jeschrevve ze han!',
	'achievements-badge-hover-desc-love' => 'För jeede Daach ennerhallef vun {{PLURAL:$1|einem Daach|$1 Dääsch aam Stöck|keinem Daach}} jet zom Wiki beijedraare ze han!',
	'achievements-badge-hover-desc-welcome' => 'för en et Wiki jekumme ze sin!',
	'achievements-badge-hover-desc-introduction' => 'För op de eije<br />
Metmaacher_Sigg ze donn!',
	'achievements-badge-hover-desc-sayhi' => 'för enem Metmaacher en Nohreesch<br />
op sing Klaafsigg jedonn ze han!',
	'achievements-badge-hover-desc-creator' => 'för et Wiki opzemaache!',
	'achievements-badge-hover-desc-pounce' => 'för ennerhallef vun ener Shtond, nohdämm se aanjelaat woode wohre, 100 Änderonge aan Sigge jemaat ze han!',
	'achievements-badge-hover-desc-caffeinated' => 'för 100 Änderonge aan Sigge ennerhallef vun einem Daach jemaat ze han!',
	'achievements-badge-hover-desc-luckyedit' => 'för et Jlöck, de $1-ste Änderong em Wiki jemaat ze han!',
	'achievements-badge-hover-desc-community-platinum' => 'Dat es en extra Afzeische us Plaatin, wat bloß för en jeweße Zigg ze han es!',
	'achievements-badge-your-desc-sharing' => 'för {{#ifeq:$1|0|ene Lengk jedeilt ze han|{{PLURAL:$1|eine Minsch|$1 Lück|Keine}} dozoh jebraat ze han, op ene jedeilte Lengk ze klecke}}!',
	'achievements-badge-your-desc-edit' => 'för Ding eezde {{PLURAL:$1|Änderong|$1 Änderonge|kein Änderonge}} aan {{PLURAL:$1|en Sigg|$1 Sigge|keine Sigge}} jemaat ze han!',
	'achievements-badge-your-desc-edit-plus-category' => 'för {{PLURAL:$1|Ding eezde Änderong|$1 Änderonge|kein Änderonge}} aan {{PLURAL:$1|en $2_Sigg|$2_Sigge|keine $2_Sigge}} jemaat ze han!',
	'achievements-badge-your-desc-picture' => 'för {{PLURAL:$1|Ding eezdes Beld|$1 Belder|kein Beld}} en {{PLURAL:$1|en Sigg|$1 Sigge|kein Sigge}} jedonn ze han!',
	'achievements-badge-your-desc-category' => 'för {{PLURAL:$1|Ding eezde Sigg|$1 Sigge|kein Sigg}} en {{PLURAL:$1|en Saachjropp|$1 Saachjroppe|keine Saachjropp}} jedonn ze han!',
	'achievements-badge-your-desc-blogpost' => 'för {{PLURAL:$1|Dinge eezde Beidraach för e <i lang="en">blog</i>|$1 Beidrääsch zo <i lang="en">blogs</i>|keine Beidraach zoh enem <i lang="en">blog</i>}} jeschrevve ze han!',
	'achievements-badge-your-desc-blogcomment' => 'för en Aanmärkong op {{PLURAL:$1|ene Beidraach|$1 ongerscheidlijje Beidrääsh|keine Beidraach}} en enem <i lang="en">blog</i> jeschrevve ze han!!',
	'achievements-badge-your-desc-love' => 'För jeede Daach ennerhallef vun {{PLURAL:$1|enem Daach|$1 Dääsch aam Stöck|keinem Daach}} jet zom Wiki beijedraare ze han!',
	'achievements-badge-your-desc-welcome' => 'för en et Wiki jekumme ze sin!',
	'achievements-badge-your-desc-introduction' => 'för op de eije Metmaacher_Sigg et eez jät drop jeschrevve ze han!',
	'achievements-badge-your-desc-sayhi' => 'för en Nohreesch op enem andere Metmaacher singe Klaafsigg jedonn ze han!',
	'achievements-badge-your-desc-creator' => 'för dat Wiki jeschaffe ze han!',
	'achievements-badge-your-desc-pounce' => 'för 100 Änderonge aan Sigge, ennerhallef vun ener Shtond nohdämm se aanjelaat woode wohre, jemaat ze han!',
	'achievements-badge-your-desc-caffeinated' => 'för 100 Änderonge aan Sigge ennerhallef vun einem Daach jemaat ze han!',
	'achievements-badge-your-desc-luckyedit' => 'för et Jlöck, de $1-ste Änderong em Wiki jemaat ze han!',
	'achievements-badge-desc-sharing' => 'för {{#ifeq:$1|0|ene Lengk jedeilt ze han|{{PLURAL:$1|eine Minsch|$1 Lück|Keine}} dozoh jebraat ze han, op ene jedeilte Lengk ze klecke}}!',
	'achievements-badge-desc-edit' => 'för {{PLURAL:$1|ein Änderong|$1 Änderonge|kein Änderonge}} op {{PLURAL:$1|eine Sigg|$1 Sigge|keine Sigge}} jemaat ze han!',
	'achievements-badge-desc-edit-plus-category' => 'för {{PLURAL:$1|ein Änderong|$1 Änderonge|kein Änderonge}} op {{PLURAL:$1|en $2_Sigg|$2_Sigge|keine $2_Sigge}} jemaat ze han!',
	'achievements-badge-desc-picture' => 'för {{PLURAL:$1|ein Beld|$1 Belder|kein Beld}} en {{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigge}} jedonn ze han!',
	'achievements-badge-desc-category' => 'för {{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigg}} en {{PLURAL:$1|en Saachjropp|$1 Saachjroppe|keine Saachjropp}} jedonn ze han!',
	'achievements-badge-desc-blogpost' => 'för {{PLURAL:$1|eine Beidraach för e <i lang="en">blog</i>|$1 Beidrääsch zo <i lang="en">blogs</i>|keine Beidraach zoh enem <i lang="en">blog</i>}} jeschrevve ze han!',
	'achievements-badge-desc-blogcomment' => 'för en Aanmärkong op {{PLURAL:$1|eine Beidraach|$1 ongerscheidlijje Beidrääsh|keine Beidraach}} en enem <i lang="en">blog</i> jeschrevve ze han!',
	'achievements-badge-desc-love' => 'För jeede Daach ennerhallef vun {{PLURAL:$1|enem Daach|$1 Dääsch aam Stöck|keinem Daach}} jet zom Wiki beijedraare ze han!',
	'achievements-badge-desc-welcome' => 'för en et Wiki jekumme ze sin!',
	'achievements-badge-desc-introduction' => 'för op de eije Metmaacher_Sigg ze donn!',
	'achievements-badge-desc-sayhi' => 'för en Nohreesch op enem andere Metmaacher singe Klaafsigg jedonn ze han!',
	'achievements-badge-desc-creator' => 'för dat Wiki jeschaffe ze han!',
	'achievements-badge-desc-pounce' => 'för Änderonge aan 100 Sigge ennerhallef vun ener Shtond nohdämm se aanjelaat woode wohre jemaat ze han!',
	'achievements-badge-desc-caffeinated' => 'för 100 Änderonge aan Sigge ennerhallef vun einem Daach jemaat ze han!',
	'achievements-badge-desc-luckyedit' => 'för et Jlöck, de $1-ste Änderong em Wiki jemaat ze han!',
	'achievements-userprofile-title-no' => '{{GENDER:$1|Däm|Däm|Däm Metmaacher|Dä|Däm}} $1 {{GENDER:$1|sing|sing|sing|ier|sing}} verdeente Afzeische',
	'achievements-userprofile-title' => '{{GENDER:$1|Däm|Däm|Däm Metmaacher|Dä|Däm}} $1 {{GENDER:$1|sing|sing|sing|ier|sing}} {{PLURAL:$2|Afzeische}} ($2)',
	'achievements-userprofile-no-badges-owner' => 'Loor op heh di Leß, doh sen de Afzeische dren, di De Der heh em Wiki verdeene kanns!',
	'achievements-userprofile-no-badges-visitor' => 'Dä Metmaacher hät noch kein Afzeische verdeent.',
);

$messages['ku-latn'] = array(
	'achievements-gold' => 'Zêr',
	'achievements-silver' => 'Zîv',
	'achievements-bronze' => 'Bronz',
	'achievements-gold-points' => '100<br />pts',
	'leaderboard-intro-hide' => 'veşêre',
	'leaderboard-intro-open' => 'veke',
	'achievements-leaderboard-member-label' => 'Endam',
	'achievements-send' => 'Wêneyî tomar bike',
	'achievements-save' => 'Guherandina qeyd bike',
	'achievements-about-title' => 'der barê vê rûpelê...',
	'achievements-community-platinum-edit' => 'biguherîne',
	'achievements-community-platinum-save' => 'tomar bike',
	'achievements-community-platinum-cancel' => 'betal bike',
	'achievements-badge-name-category-2' => 'Explorer',
);

$messages['la'] = array(
	'achievements-gold' => 'Aurum',
	'achievements-silver' => 'Argentum',
	'achievements-bronze' => 'Aerāmen',
	'achievements-badge-hover-desc-creator' => 'nam vicium creāns!',
);

$messages['lb'] = array(
	'achievements-non-existing-category' => 'Déi Kategorie déi ugi gouf gëtt et net.',
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Gold',
	'achievements-silver' => 'Sëlwer',
	'achievements-bronze' => 'Bronze',
	'achievements-gold-points' => '100<br />Pkt.',
	'achievements-silver-points' => '50<br />Pkt.',
	'achievements-bronze-points' => '10<br />Pkt.',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|Punkt|Punkten}}</small>',
	'achievements-notification-title' => 'Weider esou, $1:',
	'achievements-points' => '$1 {{PLURAL:$1|Punkt|Punkten}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|Punkt|Punkten}}',
	'achievements-ranked' => 'Plaz #$1 op dëser Wiki',
	'achievements-viewall' => 'Alles weisen',
	'achievements-viewless' => 'Zoumaachen',
	'achievements-viewall-oasis' => 'All kucken',
	'leaderboard-intro-hide' => 'verstoppen',
	'leaderboard-intro-open' => 'opmaachen',
	'leaderboard-title' => 'Classement',
	'achievements-leaderboard-disclaimer' => 'Am Classement gesitt Dir Ännerunge vu gëschter un',
	'achievements-leaderboard-rank-label' => 'Classement',
	'achievements-leaderboard-member-label' => 'Member',
	'achievements-leaderboard-points-label' => 'Punkten',
	'achievements-leaderboard-points' => '{{PLURAL:$1|Punkt|Punkten}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Rezent verdéngt',
	'achievements-send' => 'Bild späicheren',
	'achievements-save' => 'Ännerunge späicheren',
	'achievements-enable-track' => 'aktivéiert',
	'achievements-revert' => 'Op de Standard zrécksetzen',
	'achievements-special-saved' => 'Ännerunge gespäichert.',
	'achievements-about-title' => 'Iwwer dës Säit...',
	'platinum' => 'Platin',
	'achievements-community-platinum-badge-image' => 'Bild vum Badge:',
	'achievements-community-platinum-enabled' => 'aktivéiert',
	'achievements-community-platinum-edit' => 'änneren',
	'achievements-community-platinum-save' => 'späicheren',
	'achievements-community-platinum-cancel' => 'ofbriechen',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Klickt fir méi Informatiounen',
	'achievements-badge-name-edit-0' => 'Maacht den Ënnerscheed',
	'achievements-badge-name-edit-1' => 'Just den Ufank',
	'achievements-badge-name-edit-3' => 'Frënd vun der Wiki',
	'achievements-badge-name-edit-4' => 'Mataarbechter',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-5' => 'Decorateur',
	'achievements-badge-name-blogpost-0' => 'Huet eppes ze soen',
	'achievements-badge-name-blogpost-1' => 'Fënnef Saachen ze soen',
	'achievements-badge-name-blogcomment-1' => 'An dann nach eppes',
	'achievements-badge-name-love-0' => "Schlëssel fir d'Wiki!",
	'achievements-badge-name-love-1' => 'Zwou Wochen op der Wiki',
	'achievements-badge-name-love-6' => 'Wiki Held!',
	'achievements-badge-name-welcome' => 'Wëllkomm op der Wiki',
	'achievements-badge-to-get-edit' => '$1 {{PLURAL:$1|Ännerung|Ännerungen}} op {{PLURAL:$1|enger Säit|Säite}} maachen',
	'achievements-badge-to-get-welcome' => 'maacht mat bäi der Wiki',
	'achievements-badge-to-get-introduction' => 'op Är eege Benotzersäit derbäisetzen',
	'achievements-badge-to-get-sayhi' => 'engem eng Noriicht op senger Diskussiounssäit hannerloossen',
	'achievements-badge-to-get-pounce' => 'séier sinn',
	'achievements-badge-to-get-luckyedit' => 'glécklech sinn',
	'achievements-badge-to-get-edit-details' => 'Feelt eppes?
Ass eppes net richteg?
Sidd net schei.
Klickt op de Knäppchen "{{int:edit}}" an Dir kënnt all Säit änneren!',
	'achievements-badge-hover-desc-introduction' => "Ausgezeechent fir d'Derbaissetzen<br />
vun Ärer eegener Benotzersäit!",
	'achievements-badge-desc-caffeinated' => 'Ausgezeechent fir 100 Ännerungen op Säiten an engem eenzegen Dag gemaach ze hunn!',
);

$messages['lez'] = array(
	'achievements-community-platinum-edit' => 'Дегишарун',
	'achievements-badge-name-category-4' => 'Къекъуьн',
);

$messages['lt'] = array(
	'achievementsii-desc' => 'Viki naudotojų pasiekimų raiščiai',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Auksas',
	'achievements-silver' => 'Sidabras',
	'achievements-bronze' => 'Bronza',
	'achievements-gold-points' => '100 <br /> taškai',
	'achievements-silver-points' => '50 <br /> taškai',
	'achievements-bronze-points' => '10 <br /> taškai',
	'achievements-you-must' => 'Jums reikia $1 gautumėt šį ženklelį.',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|taškas|taškai}}</small>',
	'achievements-profile-title-no' => '$1 ženkleliai',
	'achievements-no-badges' => 'Peržiūrėkite žemiau, norėdami pamatyti ženklelius, kuriuos galite uždirbti šioje wiki!',
	'achievements-notification-subtitle' => 'Jūs ką tik uždirbote "$1" ženklelį $2',
	'achievements-notification-link' => '<big><strong>[[Specialus: Mypage | Sužinokite daugiau ženkliukų kuriuos galite uždirbti]]!</strong></big>',
	'achievements-points' => '$1 {{PLURAL:$1|taškas|taškai}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|taškas|taškai}}',
	'achievements-earned' => 'Šis ženklelis buvo uždirbtas {{PLURAL:$1| 1 vartotojo | $1 vartotojų}}.',
	'achievements-profile-title' => '$1 $2 uždirbo {{PLURAL:$2|ženklelį|ženklelius}}',
	'achievements-profile-title-challenges' => 'Daugiau ženklelių, kuriuos galite užsidirbti!',
	'achievements-profile-customize' => 'Redaguokite ženklelius',
	'achievements-ranked' => 'Užėmė #$1 šioje wiki',
	'achievements-viewall' => 'Peržiūrėti visus',
	'achievements-viewless' => 'Uždaryti',
	'achievements-profile-title-oasis' => 'pasiekimas <br /> taškai',
	'achievements-viewall-oasis' => 'Žiūrėti visus',
	'achievements-toggle-hide' => 'Nerodyti taškų, ženklelių ir reitingo mano profilyje',
	'leaderboard-intro-hide' => 'slėpti',
	'leaderboard-intro-open' => 'atidaryti',
	'leaderboard' => 'Pasiekimų lyderių lenta',
	'achievements-title' => 'Pasiekimai',
	'achievements-leaderboard-rank-label' => 'Rangas',
	'achievements-leaderboard-member-label' => 'Narys',
	'achievements-leaderboard-points-label' => 'Taškai',
	'achievements-leaderboard-points' => '{{PLURAL:$1|taškas|taškai}}',
	'achievements-send' => 'Išsaugoti nuotrauką',
	'achievements-save' => 'Išsaugoti pakeitimus',
	'achievements-customize' => 'Redaguoti nuotrauką',
	'achievements-enable-track' => 'įjungta',
	'achievements-special-saved' => 'Pakeitimai išsaugoti.',
	'achievements-special' => 'Specialus pasiekimai',
	'achievements-secret' => 'Slapti pasiekimai',
	'achievementscustomize' => 'Redaguoti ženklelius',
	'achievements-about-title' => 'Apie šį puslapį...',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'Jums buvo suteiktas naujas platinos ženklelis!',
	'achievements-community-platinum-awarded-for' => 'Apdovanotas už:',
	'achievements-community-platinum-how-to-earn' => 'Kaip uždirbti:',
	'achievements-community-platinum-awarded-for-example' => 'pavyzdžiui, "darant ..."',
	'achievements-community-platinum-how-to-earn-example' => 'pavyzdžiui, "padaryti 3 keitimus ..."',
	'achievements-community-platinum-badge-image' => 'Ženklelio vaizdas:',
	'achievements-community-platinum-awarded-to' => 'Skiriama:',
	'achievements-community-platinum-current-badges' => 'Dabartiniai platinos ženkleliai',
	'achievements-community-platinum-create-badge' => 'Sukurti ženklelį',
	'achievements-community-platinum-enabled' => 'įjungta',
	'achievements-community-platinum-edit' => 'redaguoti',
	'achievements-community-platinum-save' => 'išsaugoti',
	'achievements-community-platinum-cancel' => 'atšaukti',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Paspauskite norėdami gauti daugiau informacijos',
	'achievements-badge-name-edit-3' => 'Wiki draugas',
	'achievements-badge-name-edit-6' => 'Wiki lyderis',
	'achievements-badge-name-edit-7' => 'Wiki ekspertas',
	'achievements-badge-name-picture-2' => 'Iliustratorius',
	'achievements-badge-name-picture-3' => 'Kolektorius',
	'achievements-badge-name-picture-4' => 'Meno mėgėjas',
	'achievements-badge-name-picture-6' => 'Dizaineris',
	'achievements-badge-name-category-2' => 'Tyrinėtojas',
	'achievements-badge-name-category-4' => 'Navigatorius',
	'achievements-badge-name-category-6' => 'Wiki Planuotojas',
	'achievements-badge-name-blogpost-0' => 'Kažką pasakyti',
	'achievements-badge-name-blogpost-1' => 'Penki dalykai pasakyti',
	'achievements-badge-name-blogpost-2' => 'Kalbėjimo Šou',
	'achievements-badge-name-blogpost-3' => 'Vakarėlio gyvenimas',
	'achievements-badge-name-blogcomment-1' => 'Ir dar vienas dalykas',
	'achievements-badge-name-love-0' => 'Raktas į Wiki!',
	'achievements-badge-name-love-1' => 'Dvi savaites wiki',
	'achievements-badge-name-love-3' => 'Skirta',
	'achievements-badge-name-love-5' => 'Wiki gyvenimas',
	'achievements-badge-name-love-6' => 'Wiki herojus!',
	'achievements-badge-name-sharing-1' => 'Gražinkit atgal',
	'achievements-badge-name-sharing-2' => 'Kalbantysis',
	'achievements-badge-name-welcome' => 'Sveiki atvykę į Wiki',
	'achievements-badge-name-sayhi' => 'Sustoja pasisveikinti',
	'achievements-badge-name-creator' => 'Kūrėjas',
	'achievements-badge-name-luckyedit' => 'Laimingas redagavimas',
	'achievements-badge-to-get-welcome' => 'prisijungti prie wiki',
	'achievements-badge-to-get-introduction' => 'pridėti prie savo vartotojo puslapio',
	'achievements-badge-to-get-sayhi' => 'palikti kam nors pranešimą jų aptarimo puslapyje',
	'achievements-badge-to-get-pounce' => 'skubėk',
	'achievements-badge-to-get-luckyedit' => 'būk sėkmingas',
	'achievements-badge-hover-desc-welcome' => 'už prisijungimą prie Wiki!',
);

$messages['ltg'] = array(
	'achievements-viewless' => 'Aizdareit',
	'leaderboard-intro-hide' => 'nūglobuot',
);

$messages['map-bms'] = array(
	'achievements-non-existing-category' => 'Kategori sing digoleti ora ana',
	'achievements-gold' => 'Emas',
	'achievements-silver' => 'Perak',
	'achievements-bronze' => 'Perunggu',
	'achievements-viewall' => 'Deleng kabeh',
	'achievements-viewless' => 'Tutup',
	'achievements-send' => 'Simpen gambar',
);

$messages['min'] = array(
	'achievements-gold' => '↓ Ameh',
	'achievements-silver' => '↓ Perak',
	'achievements-bronze' => '↓ Perunggu',
	'achievements-gold-points' => '↓ 100<br />pts',
	'achievements-silver-points' => '↓ 50<br />pts',
	'achievements-bronze-points' => '↓ 10<br />pts',
	'achievements-you-must' => '↓ Awak ang mesti malakuan $1 untuak mandapek lencana ko.',
);

$messages['mk'] = array(
	'achievementsii-desc' => 'Систем на значки за достигнувања на вики-корисници',
	'achievements-upload-error' => 'Жалиме!
Таа слика не работи.
Проверете дали е со наставка .jpg или .png.
Ако и покрај тоа не работи, тогаш веројатно е преголема.
Пробајте со друга!',
	'achievements-upload-not-allowed' => 'Администраторите можат да ги менуваат називите и сликите на значките за достигнувања на страницата [[Special:AchievementsCustomize|Прилагодување на достигнувања]].',
	'achievements-non-existing-category' => 'Наведената категорија не постои.',
	'achievements-edit-plus-category-track-exists' => 'Укажаната категорија веќе има <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Оди на лентата">своја лента</a>.',
	'achievements-no-stub-category' => 'Не создавајте ленти за никулци.',
	'right-platinum' => 'Создај и уреди Платински значки',
	'right-sponsored-achievements' => 'Раководење со спонзорирани достигнувања',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Злато',
	'achievements-silver' => 'Сребро',
	'achievements-bronze' => 'Бронза',
	'achievements-gold-points' => '100<br />бода',
	'achievements-silver-points' => '50<br />бода',
	'achievements-bronze-points' => '10<br />бода',
	'achievements-you-must' => 'Треба $1 за да ја заработите оваа значка.',
	'leaderboard-button' => 'Предводници',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|бод|бода}}</small>',
	'achievements-profile-title-no' => 'значките на $1',
	'achievements-no-badges' => 'Проверете го долунаведениот список за да видите кои значки можете да ги заработите на ова вики!',
	'achievements-track-name-edit' => 'Лента со уредувања',
	'achievements-track-name-picture' => 'Лента со слики',
	'achievements-track-name-category' => 'Категориска лента',
	'achievements-track-name-blogpost' => 'Лента за блог-записи',
	'achievements-track-name-blogcomment' => 'Лента за блог-коментари',
	'achievements-track-name-love' => 'Викиљубовна лента',
	'achievements-track-name-sharing' => 'Историја на споделување',
	'achievements-notification-title' => 'Само така, $1!',
	'achievements-notification-subtitle' => 'Штотуку ја заработивте значката „$1“ $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Кликнете тука за да ги видите значките што можат да се заработат]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|бод|бода}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|бод|бода}}',
	'achievements-earned' => 'Оваа значка {{PLURAL:$1|ја заработил 1 корисник|ја заработиле $1 корисници}}.',
	'achievements-profile-title' => '{{PLURAL:$2|1-та заработена значка|$2-те заработени значки}} на $1',
	'achievements-profile-title-challenges' => 'Повеќе значки кои можете да ги заработите!',
	'achievements-profile-customize' => 'Прилагоди значки',
	'achievements-ranked' => 'На $1 место на ова вики',
	'achievements-viewall' => 'Преглед на сите',
	'achievements-viewless' => 'Затвори',
	'achievements-profile-title-oasis' => 'наградни <br /> бодови',
	'achievements-ranked-oasis' => '$1 се [[Special:Leaderboard|котира на $2 место]] на ова вики',
	'achievements-viewall-oasis' => 'Сите',
	'achievements-toggle-hide' => 'Скривај ги моите достигнувања на профилот од секого',
	'leaderboard-intro-hide' => 'скриј',
	'leaderboard-intro-open' => 'отвори',
	'leaderboard-intro-headline' => 'Што се достигнувања?',
	'leaderboard-intro' => "Учествувајќи (уредувајќи, подигајќи слики) на ова вики, добивате значки.<br />Значките носат бодови, и со нив се искачувате повисоко на таблата со предводници. Добиените значки ќе ги најдете на вашиот [[$1|кориснички профил]].

'''Колку вредат значките?'''",
	'leaderboard' => 'Предводници',
	'achievements-title' => 'Достигнувања',
	'leaderboard-title' => 'Предводници',
	'achievements-recent-earned-badges' => 'Скорешни заработени значки',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />заработена од <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'заработена значката <strong><a href="$3" class="badgeName">$1</a></strong> <br />$2',
	'achievements-leaderboard-disclaimer' => 'Табелата на водачи ги прикажува промените од вчера до денес',
	'achievements-leaderboard-rank-label' => 'Ранг',
	'achievements-leaderboard-member-label' => 'Член',
	'achievements-leaderboard-points-label' => 'Бодови',
	'achievements-leaderboard-points' => '{{PLURAL:$1|бод|бода}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Неодамна заработени',
	'achievements-send' => 'Зачувај слика',
	'achievements-save' => 'Зачувај промени',
	'achievements-reverted' => 'Значката е вратена на првичната.',
	'achievements-customize' => 'Прилагоди слика',
	'achievements-customize-new-category-track' => 'Создајте нова лента за категорија',
	'achievements-enable-track' => 'овозможена',
	'achievements-revert' => 'Врати по основно',
	'achievements-special-saved' => 'Промените се зачувани.',
	'achievements-special' => 'Специјални достигнувања',
	'achievements-secret' => 'Тајни достигнувања',
	'achievementscustomize' => 'Прилагоди значки',
	'achievements-about-title' => 'За страницава...',
	'achievements-about-content' => 'Администраторите на ова вики можат да ги прилагодуваат (менуваат) називите и сликите на значките за достигнувања.

Можете да подигнете било која .jpg или .png слика, и истата автоматски ќе биде сместена во рамката. Ова најдобро работи ако сликата е квадратна, и кога најважниот дел од неа е точно во средината.

Можете да користите и правоаголни слики, но знајте дека рамката ќе засече делови од неа.
Доколку имате графички програм, тогаш можете да ја кадрирате сликата за да го поставите важниот дел во средината.
Ако немате, тогаш едноставно пробувајте разни слики, додека не ја најдете таа што највеќе ви одговара!
Ако не ви се допаѓа одбраната слика, кликнете на „Врати по основно“ за да ја вратите првично зададената слика.

Значките можете да ги именувате со нови називи соодветни на тематиката на викито. Кога сте готови со преименувањето, кликнете на „Зачувај промени“.
Ви пожелуваме пријатни мигови!',
	'achievements-edit-plus-category-track-name' => '$1 лента за уредување',
	'achievements-create-edit-plus-category-title' => 'Создај нова Лента за уредување',
	'achievements-create-edit-plus-category-content' => 'Можете да создадете нов комплет од значки со кои ќе се наградуваат корисниците за нивните уредувања на страници во дадена категорија, за да се нагласи извесен дел мрежното место каде корисниците би сакале да работат.
Можете да создадете повеќе од една лента со категории, па затоа одберете две категории преку кои корисниците би можеле да ги покажат своите стручности! Потпалете соперништво меѓу корисниците кои уредуваат страници за Вампири и они што уредуваат Врколаци, or Волшебници и Нормалци, или Автботови и Десептикони.

За да создадете нова лента „Уредување во категорија“, внесете го името на категоријата во долунаведеното поле. Обичната лента за Уредување ќе си постои и понатаму; ова ќе создаде засебна лента што можете посебно да ја прилагодите.

Кога ќе ја создадете лентата, новите значки ќе се појават на лево на списокот, под редовната лента за Уредување. Изменете ги називите и сликите а новата лента, така што сите корисници можат да ја видат разликата!

Кога ќе завршите со прилагодувањето, кликнете на кутивчето „{{int:achievements-enable-track}}“ за да ја пуштите (овозможите) новата лента, а потоа кликнете на „{{int:achievements-save}}“. Новата лента ќе им се појави на профилите на корисниците, и тие ќе почнат да заработуваат значки со уредување на страници од таа категорија. Можете и да ја оневозможите лентата подоцна, кога ќе решите дека повеќе не сакате да ја истакнувате таа категорија. Корисниците што имаат заработено значки од таа лента ќе си ги зачуваат засекогаш, дури и по нејзиното оневозможување.

Со ова достигнувањата ќе ги збогатите и со забава.
Пробајте ги!',
	'achievements-create-edit-plus-category' => 'Создај ја нумерава',
	'platinum' => 'Платина',
	'achievements-community-platinum-awarded-email-subject' => 'Добивте нова Платинска значка!',
	'achievements-community-platinum-awarded-email-body-text' => 'Ви честитаме, $1!

Штотуку бевте наградени со новата Платинска значка „$2“ на $4 ($3). Ова ви носи 250 бода во салдото!

Погледајте ја новата значка на вашата корисничка страница:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Ви честитаме, $1!</strong><br /><br />
Штотуку бевте наградени со Платинска значка „<strong>$2</strong>“ на <a href="$3">$4</a>. Ова ви носи 250 бода во салдото!<br /><br />
Погледајте ја новата значка на вашата <a href="$5">корисничка страница</a>.',
	'achievements-community-platinum-awarded-for' => 'Се доделува за:',
	'achievements-community-platinum-how-to-earn' => 'Како се заработува:',
	'achievements-community-platinum-awarded-for-example' => 'на пр. „за направени...“',
	'achievements-community-platinum-how-to-earn-example' => 'на пр. „направени 3 уредувања...“',
	'achievements-community-platinum-badge-image' => 'Слика на значката:',
	'achievements-community-platinum-awarded-to' => 'Доделена на:',
	'achievements-community-platinum-current-badges' => 'Тековни платински значки',
	'achievements-community-platinum-create-badge' => 'Создај значка',
	'achievements-community-platinum-enabled' => 'овозможена',
	'achievements-community-platinum-show-recents' => 'прикажи во скорешни значки',
	'achievements-community-platinum-edit' => 'уреди',
	'achievements-community-platinum-save' => 'зачувај',
	'achievements-community-platinum-cancel' => 'откажи',
	'achievements-community-platinum-sponsored-label' => 'Спонзорирано достигнување',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Лебдечка слика <small>(мин. големина: 270 × 100 пиксела)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Следечка URL-адреса за прикази на значката:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Следечка URL-адреса за прикази на лебдечката слика:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Врска за значката <small>(командна URL-адреса за DART-следење)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Кликнете за повеќе информации',
	'achievements-badge-name-edit-0' => 'Прави разлика',
	'achievements-badge-name-edit-1' => 'На самиот почеток',
	'achievements-badge-name-edit-2' => 'Остава свој белег',
	'achievements-badge-name-edit-3' => 'Пријател на викито',
	'achievements-badge-name-edit-4' => 'Соработнник',
	'achievements-badge-name-edit-5' => 'Викиградител',
	'achievements-badge-name-edit-6' => 'Википредводник',
	'achievements-badge-name-edit-7' => 'Викистручњак',
	'achievements-badge-name-picture-0' => 'Слика',
	'achievements-badge-name-picture-1' => 'Папараци',
	'achievements-badge-name-picture-2' => 'Илустратор',
	'achievements-badge-name-picture-3' => 'Колекционер',
	'achievements-badge-name-picture-4' => 'Вљубеник во уметноста',
	'achievements-badge-name-picture-5' => 'Декоратор',
	'achievements-badge-name-picture-6' => 'Дизајнер',
	'achievements-badge-name-picture-7' => 'Кустос',
	'achievements-badge-name-category-0' => 'Поврзува',
	'achievements-badge-name-category-1' => 'Патопробивач',
	'achievements-badge-name-category-2' => 'Истражувач',
	'achievements-badge-name-category-3' => 'Водич',
	'achievements-badge-name-category-4' => 'Навигатор',
	'achievements-badge-name-category-5' => 'Мостоградител',
	'achievements-badge-name-category-6' => 'Википланер',
	'achievements-badge-name-blogpost-0' => 'Има нешто да каже',
	'achievements-badge-name-blogpost-1' => 'Два реда муабет',
	'achievements-badge-name-blogpost-2' => 'Разговорна емисија',
	'achievements-badge-name-blogpost-3' => 'Партиски живот',
	'achievements-badge-name-blogpost-4' => 'Говорник',
	'achievements-badge-name-blogcomment-0' => 'Јавен мислител',
	'achievements-badge-name-blogcomment-1' => 'И уште една работа',
	'achievements-badge-name-love-0' => 'Клуч за викито!',
	'achievements-badge-name-love-1' => 'Две недели на викито',
	'achievements-badge-name-love-2' => 'Приврзан',
	'achievements-badge-name-love-3' => 'Оддаден',
	'achievements-badge-name-love-4' => 'Навлечен',
	'achievements-badge-name-love-5' => 'Викиживот',
	'achievements-badge-name-love-6' => 'Викихерој!',
	'achievements-badge-name-sharing-0' => 'Споделувач',
	'achievements-badge-name-sharing-1' => 'Вратете го',
	'achievements-badge-name-sharing-2' => 'Говорник',
	'achievements-badge-name-sharing-3' => 'Најавувач',
	'achievements-badge-name-sharing-4' => 'Евангелист',
	'achievements-badge-name-welcome' => 'Добредојде на викито',
	'achievements-badge-name-introduction' => 'Претставување',
	'achievements-badge-name-sayhi' => 'Поздрав',
	'achievements-badge-name-creator' => 'Создавач',
	'achievements-badge-name-pounce' => 'Залетан',
	'achievements-badge-name-caffeinated' => 'Кофеинизиран',
	'achievements-badge-name-luckyedit' => 'Среќно уредување',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|споделете врска| {{PLURAL:$1|На врската што ја споделивте стиснало едно лице|На врската што ја споделивте стиснале $1 луѓе}}}}',
	'achievements-badge-to-get-edit' => 'да имаш направено $1 {{PLURAL:$1|уредување|уредувања}} на {{PLURAL:$1|една страница|страници}}',
	'achievements-badge-to-get-edit-plus-category' => 'да имаш направено $1 {{PLURAL:$1|уредување|уредувања}} на {{PLURAL:$1|една|}} $2 {{PLURAL:$1|страница| страници}}',
	'achievements-badge-to-get-picture' => 'да имаш додадено $1 {{PLURAL:$1|слика|слики}} во {{PLURAL:$1|една страница|страници}}',
	'achievements-badge-to-get-category' => 'да имаш додадено $1 {{PLURAL:$1|страница|страници}} во {{PLURAL:$1|една категорија|категории}}',
	'achievements-badge-to-get-blogpost' => 'да имаш напишано $1 {{PLURAL:$1|блог-запис|блог-записи}}',
	'achievements-badge-to-get-blogcomment' => 'да имаш коментирано на $1 различни блог-записи',
	'achievements-badge-to-get-love' => 'да имаш придонесувано на викито секојдневно во тек на $1 дена',
	'achievements-badge-to-get-welcome' => 'да се имаш зачленето на викито',
	'achievements-badge-to-get-introduction' => 'да се имаш додадено своја корисничка страница',
	'achievements-badge-to-get-sayhi' => 'да се имаш оставено некому порака на страница за разговор',
	'achievements-badge-to-get-creator' => 'да бидеш создавач на ова вики',
	'achievements-badge-to-get-pounce' => 'да бидеш брз',
	'achievements-badge-to-get-caffeinated' => 'да имаш направено $1 уредувања на страници за еден ден',
	'achievements-badge-to-get-luckyedit' => 'да имаш среќа',
	'achievements-badge-to-get-sharing-details' => 'Споделувајте врски за другите да ги отвораат!',
	'achievements-badge-to-get-edit-details' => 'Нешто што недостасува?
Да не има некоја грешка?
Не се стегајте.
Кликнете на копчето „{{int:edit}}“, и можете да допринесувате на секоја страница!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Потребна е вашата помош на страниците за <strong>$1</strong>!
Кликнете на копчето „{{int:edit}}“ на некоја страница од таа категорија за да помогнете.
Искажете ја вашата поддршка за страниците на $1!',
	'achievements-badge-to-get-picture-details' => 'Кликнете на копчето „{{int:edit}}“, а потоа на копчето „{{int:rte-ck-image-add}}“.
Можете да додадете слика од вашиот сметач, или од друга страница на викито.',
	'achievements-badge-to-get-category-details' => 'Категориите претставуваат ознаки што им помагаат на корисниците да пронајдат слични страници.
Кликнете на копчето „{{int:categoryselect-addcategory-button}}“ на дното од страницата за да ја заведете страницата во категорија.',
	'achievements-badge-to-get-blogpost-details' => 'Запишете ги вашите мислења и прашања!
Кликнете на „{{int:blogs-recent-url-text}}“ во страничната лента, а потоа на врската лево за „{{int:create-blog-post-title}}“.',
	'achievements-badge-to-get-blogcomment-details' => 'Искажете се! Прочитајте некој од скорешните блог-записи и запишете ги вашите размисли во полето за коментари.',
	'achievements-badge-to-get-love-details' => 'Бројачот се враќа почеток ако пропуштите ден, па затоа навраќајте на викито секој ден!',
	'achievements-badge-to-get-welcome-details' => 'Кликнете на копчето „{{int:oasis-signup}}“ во горниот десен агол за да се приклучите кон заеднцата.
Потоа можете да почнете да си печалите значки!',
	'achievements-badge-to-get-introduction-details' => 'Дали ви е празна корисничката страница?
Кликнете на вашето корисничко име најгоре за да видите.
Кликнете на „{{int:edit}}“ за да ставите некои податоци за себе!',
	'achievements-badge-to-get-sayhi-details' => 'Можете да им оставате пораки на другите корисници со стискање на „{{int:addsection}}“  на нивната страница за разговор.
Вака можете да побарате помош, да им се заблагодарите за трудот, или едноставно да ги поздравите!',
	'achievements-badge-to-get-creator-details' => 'Оваа страница се доделува на личноста која е основач на викито.
Кликнете на копчето „{{int:createwiki}}“ најгоре и започнете мрежно-место на вашата омилена тематика!',
	'achievements-badge-to-get-pounce-details' => 'За да ја добиете оваа значка мора да бидете брзи.
Кликнете на копчето „{{int:activityfeed}}“ за да ги видите новите страници што ги создаваат корисниците!',
	'achievements-badge-to-get-caffeinated-details' => 'Треба доста работа за да ја заработите оваа значка. Продолжете така!',
	'achievements-badge-to-get-luckyedit-details' => 'Треба да имате среќа за да ја добиете оваа значка. Продолжете со уредување!',
	'achievements-badge-to-get-community-platinum-details' => 'Ова е специјална Платинска значка што се доделува само извесно време!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|бидејќи споделивте врска|бидејќи {{PLURAL:$1|едно лице|$1 луѓе}} стиснаа на споделените врски}}',
	'achievements-badge-hover-desc-edit' => 'Се доделува за $1 {{PLURAL:$1|уредување|уредувања}}<br />
на {{PLURAL:$1|една страница|страници}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Се доделува за $1 {{PLURAL:$1|уредување|уредувања}}<br />
на {{PLURAL:$1|една|}} $2 {{PLURAL:$1|страница| страници}}!',
	'achievements-badge-hover-desc-picture' => 'Се доделува за ставање на $1 {{PLURAL:$1|слика|слики}}<br />
на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-hover-desc-category' => 'Се доделува за ставање на $1 {{PLURAL:$1|страница|страници}}<br />
во {{PLURAL:$1|категорија|категории}}!',
	'achievements-badge-hover-desc-blogpost' => 'Се доделува за пишување на $1 {{PLURAL:$1|блог-запис|блог-записи}}!',
	'achievements-badge-hover-desc-blogcomment' => 'Се доделува за давање коментар<br />
на $1 {{PLURAL:$1|блог-запис|различни блог-записи}}!',
	'achievements-badge-hover-desc-love' => 'Се доделува за секојдневен придонес на викито во текот на {{PLURAL:$1|еден ден|$1 дена}}!',
	'achievements-badge-hover-desc-welcome' => 'Се доделува за зачленување на викито!',
	'achievements-badge-hover-desc-introduction' => 'Се доделува за додавање содржини на<br />
вашата корисничка страница!',
	'achievements-badge-hover-desc-sayhi' => 'Се доделува за оставање на порака<br />
на нечија страница за разговор!',
	'achievements-badge-hover-desc-creator' => 'Се доделува за создавање на викито!',
	'achievements-badge-hover-desc-pounce' => 'Се доделува за извршени уредувања на 100 страници во рок од еден час од нивното создавање!',
	'achievements-badge-hover-desc-caffeinated' => 'Се доделува за извршени 100 уредувања на страници за еден ден!',
	'achievements-badge-hover-desc-luckyedit' => 'Се доделува за извршување на Среќното $1-то уредување на викито!',
	'achievements-badge-hover-desc-community-platinum' => 'Ова е специјална Платинска значка што се доделува само извесно време!',
	'achievements-badge-your-desc-sharing' => 'Се доделува {{#ifeq:$1|0|за споделување на една врска|кога {{PLURAL:$1|едно лице|$1 луѓе}} ќе стиснат на споделените врски}}',
	'achievements-badge-your-desc-edit' => 'Се доделува за {{PLURAL:$1|вашето прво уредување|извршени $1 уредувања}} на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'Се доделува за {{PLURAL:$1|вашето прво уредување|извршени $1 уредувања}} на {{PLURAL:$1|$2 страница|$2 страници}}!',
	'achievements-badge-your-desc-picture' => 'Се доделува за ставање на {{PLURAL:$1|вашата прва слика|$1 слики}} на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-your-desc-category' => 'Се доделува за додавање на {{PLURAL:$1|вашата прва страница|$1 страници}} во {{PLURAL:$1|категорија|категории}}!',
	'achievements-badge-your-desc-blogpost' => 'Се доделува за пишување на {{PLURAL:$1|вашиот прв блог-запис|$1 блог-записи}}',
	'achievements-badge-your-desc-blogcomment' => 'Се доделува за коментирање на {{PLURAL:$1|блог-запис|$1 различни блог-записи}}!',
	'achievements-badge-your-desc-love' => 'Се доделува за секојдневен придонес на викито во текот на {{PLURAL:$1|еден ден|$1 дена}}!',
	'achievements-badge-your-desc-welcome' => 'Се доделува за зачленување на викито!',
	'achievements-badge-your-desc-introduction' => 'Се доделува за збогатување на вашата корисничка страница!',
	'achievements-badge-your-desc-sayhi' => 'Се доделува за оставање порака на нечија страница за разговор!',
	'achievements-badge-your-desc-creator' => 'Се доделува за создавање на викито!',
	'achievements-badge-your-desc-pounce' => 'Се доделува за уредување на 100 страници во рок од еден час од нивното создавање!',
	'achievements-badge-your-desc-caffeinated' => 'Се доделува за 100 уредувања на страници во еден ден!',
	'achievements-badge-your-desc-luckyedit' => 'Се доделува за Среќното $1-то уредување на викито!',
	'achievements-badge-desc-sharing' => 'Се доделува {{#ifeq:$1|0|за споделување на една врска|кога {{PLURAL:$1|едно лице|$1 луѓе}} ќе стиснат на споделените врски}}',
	'achievements-badge-desc-edit' => 'Се доделува за $1 {{PLURAL:$1|извршено уредување|извршени уредувања}} на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-desc-edit-plus-category' => 'Се доделува за $1 {{PLURAL:$1|извршено уредување|извршени уредувања}} на {{PLURAL:$1|страница ($2) |страници ($2)}}!',
	'achievements-badge-desc-picture' => 'Се доделува за ставање на $1 {{PLURAL:$1|слика|слики}} на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-desc-category' => 'Се доделува за $1 {{PLURAL:$1|ставена страница|ставени страници}} во {{PLURAL:$1|категорија|категории}}!',
	'achievements-badge-desc-blogpost' => 'Се доделува за $1 {{PLURAL:$1|напишан блог-запис|напишани блог-записи}}!',
	'achievements-badge-desc-blogcomment' => 'Се доделува за оставање коментар на {{PLURAL:$1|блог-запис|$1 различни блог-записи}}!',
	'achievements-badge-desc-love' => 'Се доделува за секојдневен придонес на викито во текот на {{PLURAL:$1|еден ден|$1 дена}}!',
	'achievements-badge-desc-welcome' => 'Се доделува за зачленување на викито!',
	'achievements-badge-desc-introduction' => 'Се доделува за додавање содржина на вашата корисничка страница!',
	'achievements-badge-desc-sayhi' => 'Се доделува за оставање порака на нечија страница за разговор!',
	'achievements-badge-desc-creator' => 'Се доделува за создавање на викито!',
	'achievements-badge-desc-pounce' => 'Се доделува за извршени уредувања на 100 страници во текот на еден час од создавањето на страниците!',
	'achievements-badge-desc-caffeinated' => 'Се доделува за извршени 100 уредувања на страници во текот на еден ден!',
	'achievements-badge-desc-luckyedit' => 'Се доделува за извршување на Среќното $1-то уредување на викито!',
	'achievements-userprofile-title-no' => 'Заработените значки на $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Заработената значка|Заработените значки}} ($2) на $1',
	'achievements-userprofile-no-badges-owner' => 'На списокот подолу се наведени значките што можете да ги заработите на ова вики!',
	'achievements-userprofile-no-badges-visitor' => 'Овој корисник сè уште нема заработено ниедна значка.',
	'achievements-userprofile-profile-score' => '<em>$1</em> бода за<br />достигнувања',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|На $1 место]]<br />на ова вики',
);

$messages['ml'] = array(
	'achievements-platinum' => 'പ്ലാറ്റിനം',
	'achievements-gold' => 'സ്വർണ്ണം',
	'achievements-silver' => 'വെള്ളി',
	'achievements-bronze' => 'വെങ്കലം',
	'achievements-viewall' => 'എല്ലാം കാണുക',
	'achievements-viewless' => 'അടയ്ക്കുക',
	'achievements-viewall-oasis' => 'എല്ലാം കാണുക',
	'leaderboard-intro-hide' => 'മറയ്ക്കുക',
	'leaderboard-intro-open' => 'തുറക്കുക',
	'achievements-leaderboard-rank-label' => 'റാങ്ക്',
	'achievements-leaderboard-member-label' => 'അംഗം',
	'achievements-leaderboard-points-label' => 'പോയിന്റുകൾ',
	'achievements-leaderboard-points' => '{{PLURAL:$1|പോയിന്റ്|പോയിന്റുകൾ}}',
	'achievements-send' => 'ചിത്രം സേവ് ചെയ്യുക',
	'achievements-save' => 'മാറ്റങ്ങൾ സേവ് ചെയ്യുക',
	'achievements-enable-track' => 'സജ്ജമാക്കിയിരിക്കുന്നു',
	'achievements-revert' => 'സ്വതേയുള്ളതിലേയ്ക്ക് പുനഃസ്ഥാപിക്കുക',
	'achievements-special-saved' => 'മാറ്റങ്ങൾ സേവ് ചെയ്തിരിക്കുന്നു.',
	'platinum' => 'പ്ലാറ്റിനം',
	'achievements-community-platinum-enabled' => 'സജ്ജമാക്കിയിരിക്കുന്നു',
	'achievements-community-platinum-edit' => 'തിരുത്തുക',
	'achievements-community-platinum-save' => 'സേവ് ചെയ്യുക',
	'achievements-community-platinum-cancel' => 'റദ്ദാക്കുക',
	'achievements-badge-name-edit-1' => 'ഇതൊരു തുടക്കം മാത്രം',
	'achievements-badge-name-edit-3' => 'വിക്കിയുടെ സുഹൃത്ത്',
	'achievements-badge-name-picture-1' => 'പപ്പരാസി',
	'achievements-badge-name-picture-4' => 'കലാസ്നേഹി',
	'achievements-badge-to-get-welcome' => 'വിക്കിയിൽ ചേരുക',
	'achievements-badge-to-get-introduction' => 'താങ്കളുടെ തന്നെ ഉപയോക്തൃതാളിൽ ചേർക്കുക',
	'achievements-badge-to-get-sayhi' => 'മറ്റാർക്കെങ്കിലും അവരുടെ സംവാദം താളിൽ ഒരു സന്ദേശമിടുക',
	'achievements-badge-to-get-creator' => 'ഈ വിക്കിയുടെ സ്രഷ്ടാവാകുക',
	'achievements-badge-to-get-pounce' => 'പെട്ടന്നാവട്ടെ',
	'achievements-badge-your-desc-welcome' => 'വിക്കിയിൽ ചേർന്നതിന്!',
	'achievements-badge-desc-welcome' => 'വിക്കിയിൽ ചേർന്നതിന്!',
);

$messages['mr'] = array(
	'achievements-platinum' => 'प्लॅटिनम',
	'achievements-gold' => 'सोने',
	'achievements-silver' => 'चांदी',
	'achievements-bronze' => 'कांस्य',
	'achievements-gold-points' => '१००<br />गुण',
	'achievements-silver-points' => '५०<br /> गुण',
	'achievements-bronze-points' => '१०<br /> गुण',
);

$messages['ms'] = array(
	'achievementsii-desc' => 'Sistem lencana pencapaian untuk pengguna wiki',
	'achievements-upload-error' => 'Maaf!
Gambar ini tidak dapat digunakan.
Pastikan failnya ialah .jpg atau .png.
Jika tidak berfungsi lagi, mungkin gambar itu terlalu besar.
Sila cuba satu lagi!',
	'achievements-upload-not-allowed' => 'Pentadbir boleh menukar nama dan gambar lencana Pencapaian dengan melawat laman [[Special:AchievementsCustomize|Ubah suai pencapaian]].',
	'achievements-non-existing-category' => 'Kategori yang dinyatakan tidak wujud.',
	'achievements-edit-plus-category-track-exists' => 'Kategori yang dinyatakan sudah ada <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">jejak yang berkenaan</a>.',
	'achievements-no-stub-category' => 'Tolong jangan membuat jejak untuk rencana tunas.',
	'right-platinum' => 'Cipta dan sunting lencana Platinum',
	'right-sponsored-achievements' => 'Uruskan pencapaian yang Ditaja',
	'achievements-platinum' => 'Platinum',
	'achievements-gold' => 'Emas',
	'achievements-silver' => 'Perak',
	'achievements-bronze' => 'Gangsa',
	'achievements-gold-points' => '100<br />mata',
	'achievements-silver-points' => '50<br />mata',
	'achievements-bronze-points' => '10<br />mata',
	'achievements-you-must' => 'Anda memerlukan $1 untuk mendapatkan lencana ini.',
	'leaderboard-button' => 'Papan teraju pencapaian',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|mata|mata}}</small>',
	'achievements-profile-title-no' => 'Lencana $1',
	'achievements-no-badges' => 'Semak senarai di bawah untuk melihat lencana-lencana yang boleh anda peroleh di wiki ini!',
	'achievements-track-name-edit' => 'Sunting jejak',
	'achievements-track-name-picture' => 'Jejak gambar',
	'achievements-track-name-category' => 'Jejak kategori',
	'achievements-track-name-blogpost' => 'Jejak Kiriman Blog',
	'achievements-track-name-blogcomment' => 'Jejak Ulasan Blog',
	'achievements-track-name-love' => 'Jejak Suka Wiki',
	'achievements-track-name-sharing' => 'Jejak Kongsi',
	'achievements-notification-title' => 'Syabas, $1!',
	'achievements-notification-subtitle' => 'Anda baru meraih lencana "$1" $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Tengok banyak lagi lencana yang anda boleh raih]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|mata|mata}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|mata|mata}}',
	'achievements-earned' => 'Lencana ini telah diraih oleh {{PLURAL:$1|seorang pengguna|$1 orang pengguna}}.',
	'achievements-profile-title' => '$1 memperoleh {{PLURAL:$2|sebutir lencana|$2 butir lencana}}',
	'achievements-profile-title-challenges' => 'Banyak lagi lencana yang boleh anda perolehi!',
	'achievements-profile-customize' => 'Ubah suai lencana',
	'achievements-ranked' => 'Menduduki tangga #$1 di wiki ini',
	'achievements-viewall' => 'Lihat semua',
	'achievements-viewless' => 'Tutup',
	'achievements-profile-title-oasis' => 'mata <br /> pencapaian',
	'achievements-ranked-oasis' => '$1 di tangga [[Special:Leaderboard|#$2]] di wiki ini',
	'achievements-viewall-oasis' => 'Lihat semua',
	'achievements-toggle-hide' => 'Sorokkan pencapaian saya pada profil saya daripada semua orang',
	'leaderboard-intro-hide' => 'sorokkan',
	'leaderboard-intro-open' => 'buka',
	'leaderboard-intro-headline' => 'Pencapaian tu apa?',
	'leaderboard-intro' => "Anda boleh meraih lencana di wiki ini dengan menyunting laman, memuat naik gambar dan membuat ulasan. Setiap lencana ada mata untuk anda – lebih banyak mata yang anda dapat, semakin tinggi kedudukan anda di papan teraju pencapaian. Anda boleh mencari lencana-lencana yang anda raih dalam [[$1|laman profil pengguna]] anda.

'''Apakah nilai lencana ini?'''",
	'leaderboard' => 'Papan teraju pencapaian',
	'achievements-title' => 'Pencapaian',
	'leaderboard-title' => 'Papan teraju',
	'achievements-recent-earned-badges' => 'Lencana yang Baru Diraih',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />diraih oleh <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'meraih lencana <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Papan teraju menunjukkan perubahan sejak semalam',
	'achievements-leaderboard-rank-label' => 'Kedudukan',
	'achievements-leaderboard-member-label' => 'Ahli',
	'achievements-leaderboard-points-label' => 'Mata',
	'achievements-leaderboard-points' => '{{PLURAL:$1|mata|mata}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Baru diraih',
	'achievements-send' => 'Simpan gambar',
	'achievements-save' => 'Simpan perubahan',
	'achievements-reverted' => 'Lencana dikembalikan ke asalnya.',
	'achievements-customize' => 'Ubah suai gambar',
	'achievements-customize-new-category-track' => 'Cipta jejak baru untuk kategori:',
	'achievements-enable-track' => 'dihidupkan',
	'achievements-revert' => 'Kembali ke asali',
	'achievements-special-saved' => 'Perubahan disimpan.',
	'achievements-special' => 'Pencapaian istimewa',
	'achievements-secret' => 'Pencapaian rahsia',
	'achievementscustomize' => 'Ubah suai lencana',
	'achievements-about-title' => 'Perihal laman ini...',
	'achievements-about-content' => 'Pentadbir di wiki ini boleh mengubahsuai nama-nama dan gambar-gambar lencana pencapaian.

Anda boleh memuat naik sebarang gambar .jpg atau .png, dan gambar itu akan muat dalam bingkai secara automatik.
Paling bagus jika gambar itu berbentuk segiempat sama, dan ciri terpenting dalam gambar terletak di tengah-tengah sekali.

Anda boleh menggunakan gambar segiempat tepat, tetapi ia mungkin akan terpangkas oleh bingkai.
Jika anda ada perisian grafik, bolehlah anda memangkas (\'\'crop\'\') gambar anda supaya ciri terpenting dalam gambar itu dijajarkan ke tengah-tengah.
Jika anda tiada perisian grafik, anda cuma perlu menguji berbagai-bagai gambar sehingga anda mencari gambar yang sesuai!
If anda tidak suka gambar yang anda pilih, klik "{{int:achievements-revert}}" untuk memulihkan gambar asal.

Anda juga boleh menukar nama lencana supaya mencerminkan topik wiki anda.
Apabila anda menukar nama lencana, klik "{{int:achievements-save}}" untuk menyimpan perubahan anda.
Semoga anda berseronok!',
	'achievements-edit-plus-category-track-name' => '$1 jejak suntingan',
	'achievements-create-edit-plus-category-title' => 'Cipta jejak Suntingan baru',
	'achievements-create-edit-plus-category-content' => 'Anda boleh mencipta satu set lencana yang baru untuk memuji pengguna kerana menyunting laman dalam kategori tertentu, untuk menonjolkan bahagian laman tertentu yang digemari oleh pengguna anda.
Anda boleh mendirikan satu atau lebih jejak kategori, jadi apa kata anda cuba memilih dua kategori yang membantu pengguna menyerlahkan pengkhususan mereka!
Cetuskan persaingan antara pengguna yang menyunting laman Pontianak dan pengguna yang menyunting laman Serigala Jadian, ataupun antara Ahli Sihir dan Muggle, ataupun Autobot lawan Decepticon.

Untuk mencipta jejak "Sunting dalam kategori" yang baru, taipkan nama kategori dalam ruangan di bawah.
Jejak Sunting yang biasa akan masih ada;
ini akan mencipta jejak berbeza yang boleh anda ubahsuai secara berasingan.

Apabila jejak itu dicipta, lencana baru akan muncul dalam senarai di sebelah kiri, di bawah jejak Sunting yang biasa.
Ubah suai nama-nama dan gambar-gambar untuk jejak baru tiu, supaya pengguna boleh merasai perbezaannya!

Selepas membuat penyesuaian, tandai kotak pilihan "{{int:achievements-enable-track}}" untuk menghidupkan jejak baru, kemudian klik "{{int:achievements-save}}". Pengguna akan melihat jejak baru itu muncul dalam profil pengguna mereka, dan mereka akan mulai meraih lencana sebaik sahaja mereka menyunting laman dalam kategori itu.
Anda boleh mematikan jejak itu lain kali, jika anda memutuskan untuk tidak menonjolkan kategori itu lagi.
Pengguna yang sudah meraih lencana dalam jejak itu akan sentiasa menyimpan lencana mereka walaupun jejaknya dimatikan.

Ini oleh membantu menceriakan lagi pencapaian pengguna Wiki!
Cubalah!',
	'achievements-create-edit-plus-category' => 'Cipta jejak ini',
	'platinum' => 'Platinum',
	'achievements-community-platinum-awarded-email-subject' => 'Anda telah dianugerahkan lencana Platinum yang baru!',
	'achievements-community-platinum-awarded-email-body-text' => "Tahniah, $1!

Anda baru dianugerahkan dengan lencana Platinum '$2' di $4 ($3).
Oleh itu, markah anda ditambah 250 mata lagi!

Lihatlah lencana baru anda yang hebat ini dalam laman profil pengguna anda:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Tahniah, $1!</strong><br /><br />
Anda baru dianugerahkan lenana Platinum \'<strong>$2</strong>\' di <a href="$3">$4</a>.
Oleh itu, markah anda ditambah 250 mata lagi!<br /><br />
Lihatlah lencana baru yang hebat ini di dalam <a href="$5">laman profil pengguna</a> anda.',
	'achievements-community-platinum-awarded-for' => 'Dianugerahkan kerana:',
	'achievements-community-platinum-how-to-earn' => 'Cara meraihnya:',
	'achievements-community-platinum-awarded-for-example' => 'cth. "kerana melakukan..."',
	'achievements-community-platinum-how-to-earn-example' => 'cth. "membuat 3 suntingan..."',
	'achievements-community-platinum-badge-image' => 'Gambar lencana:',
	'achievements-community-platinum-awarded-to' => 'Dianugerahkan kepada:',
	'achievements-community-platinum-current-badges' => 'Lencana platinum semasa',
	'achievements-community-platinum-create-badge' => 'Cipta lencana',
	'achievements-community-platinum-enabled' => 'dihidupkan',
	'achievements-community-platinum-show-recents' => 'tunjukkan dalam lencana terbaru',
	'achievements-community-platinum-edit' => 'sunting',
	'achievements-community-platinum-save' => 'simpan',
	'achievements-community-platinum-cancel' => 'batalkan',
	'achievements-community-platinum-sponsored-label' => 'Pencapaian yang ditaja',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Gambar Hover <small>(saiz minimum hover: 270px x 100px):</small>',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Menjejaki URL untuk impresi lencana:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Menjejaki URL untuk impresi Hover:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Pautan lencana <small>(URL perintah klik DART)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Klik untuk maklumat lebih lanjut',
	'achievements-badge-name-edit-0' => 'Penggerak Bumi',
	'achievements-badge-name-edit-1' => 'Baru Nak Bermula',
	'achievements-badge-name-edit-2' => 'Meninggalkan Kesan',
	'achievements-badge-name-edit-3' => 'Sahabat Wiki',
	'achievements-badge-name-edit-4' => 'Rakan Usaha Sama',
	'achievements-badge-name-edit-5' => 'Pembina Wiki',
	'achievements-badge-name-edit-6' => 'Peneraju Wiki',
	'achievements-badge-name-edit-7' => 'Pakar Wiki',
	'achievements-badge-name-picture-0' => 'Snapshot',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Pengilustrasi',
	'achievements-badge-name-picture-3' => 'Pengumpul',
	'achievements-badge-name-picture-4' => 'Pencinta Seni',
	'achievements-badge-name-picture-5' => 'Tukang Hias',
	'achievements-badge-name-picture-6' => 'Penghias',
	'achievements-badge-name-picture-7' => 'Kurator',
	'achievements-badge-name-category-0' => 'Penghubung',
	'achievements-badge-name-category-1' => 'Perintis',
	'achievements-badge-name-category-2' => 'Penjelajah',
	'achievements-badge-name-category-3' => 'Pemandu Pelawat',
	'achievements-badge-name-category-4' => 'Pemandu Arah',
	'achievements-badge-name-category-5' => 'Pembina Jambatan',
	'achievements-badge-name-category-6' => 'Perancang Wiki',
	'achievements-badge-name-blogpost-0' => 'Perkara untuk dikatakan',
	'achievements-badge-name-blogpost-1' => 'Lima Perkara untuk dikatakan',
	'achievements-badge-name-blogpost-2' => 'Wawancara',
	'achievements-badge-name-blogpost-3' => 'Kehidupan parti',
	'achievements-badge-name-blogpost-4' => 'Pemidato',
	'achievements-badge-name-blogcomment-0' => 'Tukang Pendapat',
	'achievements-badge-name-blogcomment-1' => 'Seperkara lagi',
	'achievements-badge-name-love-0' => 'Kunci ke Wiki ini!',
	'achievements-badge-name-love-1' => 'Dua minggu di wiki',
	'achievements-badge-name-love-2' => 'Setia',
	'achievements-badge-name-love-3' => 'Berdedikasi',
	'achievements-badge-name-love-4' => 'Ketagih',
	'achievements-badge-name-love-5' => 'Kehidupan Wiki',
	'achievements-badge-name-love-6' => 'Wira Wiki!',
	'achievements-badge-name-sharing-0' => 'Pekongsi',
	'achievements-badge-name-sharing-1' => 'Kembalikannya',
	'achievements-badge-name-sharing-2' => 'Pengucap',
	'achievements-badge-name-sharing-3' => 'Penyiar',
	'achievements-badge-name-sharing-4' => 'Mubaligh',
	'achievements-badge-name-welcome' => 'Selamat Datang ke Wiki',
	'achievements-badge-name-introduction' => 'Pengenalan',
	'achievements-badge-name-sayhi' => 'Bersinggah untuk bersalaman',
	'achievements-badge-name-creator' => 'Sang Pencipta',
	'achievements-badge-name-pounce' => 'Terkam!',
	'achievements-badge-name-caffeinated' => 'Ketagih Kafein',
	'achievements-badge-name-luckyedit' => 'Suntingan bertuah',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|berkongsi pautan|mencari {{PLURAL:$1|seorang|$1 orang}} untuk mengklik pautan kongsian anda}}',
	'achievements-badge-to-get-edit' => 'membuat $1 suntingan pada {{PLURAL:$1|laman|laman-laman}}',
	'achievements-badge-to-get-edit-plus-category' => 'membuat {{PLURAL:$1|suntingan pertama anda|$1 suntingan}} pada laman $2!',
	'achievements-badge-to-get-picture' => 'membubuh $1 gambar pada laman!',
	'achievements-badge-to-get-category' => 'menambahkan $1 laman pada kategori!',
	'achievements-badge-to-get-blogpost' => 'menulis $1 kiriman blog!',
	'achievements-badge-to-get-blogcomment' => 'menulis ulasan dalam {{PLURAL:$1|satu kiriman blog|$1 kiriman blog yang berbeza}}!',
	'achievements-badge-to-get-love' => 'menyumbang kepada wiki setiap hari selama {{PLURAL:$1|sehari|$1 hari}}!',
	'achievements-badge-to-get-welcome' => 'menyertai wiki',
	'achievements-badge-to-get-introduction' => 'mengisi laman pengguna anda sendiri',
	'achievements-badge-to-get-sayhi' => 'meninggalkan pesanan di laman perbincangan orang lain',
	'achievements-badge-to-get-creator' => 'menjadi pencipta wiki ini',
	'achievements-badge-to-get-pounce' => 'lekas',
	'achievements-badge-to-get-caffeinated' => 'membuat $1 suntingan laman dalam sehari',
	'achievements-badge-to-get-luckyedit' => 'beruntung',
	'achievements-badge-to-get-sharing-details' => 'berkongsi pautan dan cari orang lain untuk mengkliknya!',
	'achievements-badge-to-get-edit-details' => 'Ada sesuatu yang tak kena ke?
Jangan malu-malu.
Klik butang "{{int:edit}}" untuk menambahkan maklumat di mana-mana laman!',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong> memerlukan bantuan anda!
Klik butang "{{int:edit}}" di mana-mana laman dalam kategori itu untuk membantu.
Berikan sokongan kepada laman-laman $1!',
	'achievements-badge-to-get-picture-details' => 'Klik butang "{{int:edit}}", kemudian klik butang "{{int:rte-ck-image-add}}".
Anda boleh membubuh gambar dari komputer anda, atau laman lain di wiki ini.',
	'achievements-badge-to-get-category-details' => 'Kategori merupakan tag yang membantu para pembaca mencari laman-laman yang berkaitan
Klik butang "{{int:categoryselect-addcategory-button}}" di bawah laman untuk menyenaraikan laman itu dalam satu kategori.',
	'achievements-badge-to-get-blogpost-details' => 'Tuliskan pendapat dan soalan anda!
Klik pada "{{int:blogs-recent-url-text}}" dalam bar sisi, kemudian klik pautan di kiri untuk "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Luahkan pendapat anda!
Baca mana-mana kiriman blog terkini, dan tuliskan nukilan hati anda dalam ruangan ulasan.',
	'achievements-badge-to-get-love-details' => 'Pembilang mereset jika anda terlepas sehari, jadi anda harus kembali ke wiki ini setiap hari!',
	'achievements-badge-to-get-welcome-details' => 'Klik butang "{{int:oasis-signup}}" di kanan atas untuk menyertai komuniti.
Anda boleh bermula meraih lencana sendiri!',
	'achievements-badge-to-get-introduction-details' => 'Adakah laman pengguna anda kosong?
Klik nama pengguna anda di atas skrin untuk tengok.
Klik "{{int:edit}}" untuk mengisikan maklumat tentang diri anda!',
	'achievements-badge-to-get-sayhi-details' => 'Anda boleh meninggalkan pesanan kepada pengguna lain dengan mengklik "{{int:addsection}}" pada laman perbincangan mereka, sama ada untuk minta tolong, ucap terima kasih atas usaha mereka, atau bersalaman saja!',
	'achievements-badge-to-get-creator-details' => 'Lencana ini diberikan kepada pengasas wiki.
Klik butang "{{int:createwiki}}" di atas untuk membuka tapak baru mengenai topik kegemaran anda!',
	'achievements-badge-to-get-pounce-details' => 'Anda perlu cepat untuk meraih lencana ini.
Klik butang "{{int:activityfeed}}" untuk melihat laman-laman baru yang dicipta oleh pengguna!',
	'achievements-badge-to-get-caffeinated-details' => 'Anda perlu sibuk sepanjang hari untuk meraih lencana ini.
Teruskan menyunting!',
	'achievements-badge-to-get-luckyedit-details' => 'Anda harus bertuah untuk meraih lencana ini.
Teruskan menyunting!',
	'achievements-badge-to-get-community-platinum-details' => 'Inilah lencana Platinum istimewa yang didapati dalam masa yang terhad sahaja!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|kerana berkongsi satu pautan|kerana mencari {{PLURAL:$1|satu orang|$1 orang}} untuk mengklik pautan terkongsi}}',
	'achievements-badge-hover-desc-edit' => 'Diberikan kerana membuat $1 suntingan<br />
pada laman!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Diberikan kerana membuat $1 suntingan<br />
pada laman $2!',
	'achievements-badge-hover-desc-picture' => 'Diberikan kerana menambahkan $1<br />
gambar pada laman!',
	'achievements-badge-hover-desc-category' => 'Diberikan kerana menambahkan $1<br />
laman pada kategori!',
	'achievements-badge-hover-desc-blogpost' => 'Diberikan kerana menulis $1 catatan blog!',
	'achievements-badge-hover-desc-blogcomment' => 'Diberikan kerana menulis ulasan pada<br />
$1 kiriman blog berbeza!',
	'achievements-badge-hover-desc-love' => 'Diberikan kerana menyumbang kepada wiki setiap hari selama {{PLURAL:$1|sehari|$1 hari}}!',
	'achievements-badge-hover-desc-welcome' => 'Diberikan kerana menyertai wiki ini!',
	'achievements-badge-hover-desc-introduction' => 'Diberikan kerana menambahkan bahan<br />
ke dalam laman pengguna sendiri!',
	'achievements-badge-hover-desc-sayhi' => 'Diberikan kerana meninggalkan pesanan<br />
dalam laman perbincangan orang lain!',
	'achievements-badge-hover-desc-creator' => 'Diberikan kerana mencipta wiki ini!',
	'achievements-badge-hover-desc-pounce' => 'Diberikan kerana membuat suntingan pada 100 laman dalam sejam selepas laman dicipta!',
	'achievements-badge-hover-desc-caffeinated' => 'Diberikan kerana membuat 100 suntingan pada laman dalam sehari!',
	'achievements-badge-hover-desc-luckyedit' => 'Diberikan kerana menjadi Penyunting ke-$1 Bertuah di wiki ini!',
	'achievements-badge-hover-desc-community-platinum' => 'Ini merupakan lencana Platinum istimewa yang diberikan dalam masa yang terhad sahaja!',
	'achievements-badge-your-desc-sharing' => 'Diberikan {{#ifeq:$1|0|kerana berkongsi satu pautan|kerana mencari {{PLURAL:$1|seorang|$1 orang}} untuk mengklik pautan terkongsi}}',
	'achievements-badge-your-desc-edit' => 'Diberikan kerana membuat {{PLURAL:$1|suntingan pertama anda|$1 suntingan}} pada laman!',
	'achievements-badge-your-desc-edit-plus-category' => 'Diberikan kerana membuat {{PLURAL:$1|suntingan pertama anda|$1 suntingan}} pada laman $2!',
	'achievements-badge-your-desc-picture' => 'Diberikan kerana menambahkan {{PLURAL:$1|gambar pertama anda|$1 gambar}} pada laman!',
	'achievements-badge-your-desc-category' => 'Diberikan kerana menambahkan {{PLURAL:$1|laman pertama anda|$1 laman}} ke dalam kategori!',
	'achievements-badge-your-desc-blogpost' => 'Diberikan kerana menulis {{PLURAL:$1|kiriman blog pertama anda|$1 kiriman blog}}!',
	'achievements-badge-your-desc-blogcomment' => 'Diberikan kerana menulis komen dalam {{PLURAL:$1|satu kiriman blog|$1 kiriman blog berlainan}}!',
	'achievements-badge-your-desc-love' => 'Diberikan kerana menyumbang kepada wiki setiap hari selama {{PLURAL:$1|sehari|$1 hari}}!',
	'achievements-badge-your-desc-welcome' => 'Diberikan kerana menyertai wiki ini!',
	'achievements-badge-your-desc-introduction' => 'Diberikan kerana menambahkan bahan ke dalam laman pengguna sendiri!',
	'achievements-badge-your-desc-sayhi' => 'Diberikan kerana meninggalkan pesanan di laman perbincangan orang lain!',
	'achievements-badge-your-desc-creator' => 'Diberikan kerana mencipta wiki ini!',
	'achievements-badge-your-desc-pounce' => 'Diberikan kerana membuat suntingan pada 100 laman dalam sejam selepas laman dicipta.',
	'achievements-badge-your-desc-caffeinated' => 'Diberikan kerana membuat 100 suntingan pada laman dalam sehari!',
	'achievements-badge-your-desc-luckyedit' => 'Diberikan kerana menjadi Penyunting ke-$1 Bertuah di wiki ini!',
	'achievements-badge-desc-sharing' => 'Diberikan {{#ifeq:$1|0|kerana berkongsi satu pautan|kerana mencari {{PLURAL:$1|seorang|$1 orang}} untuk mengklik pautan terkongsi}}',
	'achievements-badge-desc-edit' => 'Diberikan kerana membuat $1 suntingan pada laman!',
	'achievements-badge-desc-edit-plus-category' => 'Diberikan kerana membuat $1 suntingan pada laman $2!',
	'achievements-badge-desc-picture' => 'Diberikan kerana membubuh $1 gambar pada laman!',
	'achievements-badge-desc-category' => 'Diberikan kerana menambahkan $1 laman pada kategori!',
	'achievements-badge-desc-blogpost' => 'Diberikan kerana menulis $1 kiriman blog!',
	'achievements-badge-desc-blogcomment' => 'Diberikan kerana menulis komen dalam {{PLURAL:$1|satu kiriman blog|$1 kiriman blog berlainan}}!',
	'achievements-badge-desc-love' => 'Diberikan kerana menyumbang kepada wiki setiap hari selama {{PLURAL:$1|sehari|$1 hari}}!',
	'achievements-badge-desc-welcome' => 'Diberikan kerana menyertai wiki ini!',
	'achievements-badge-desc-introduction' => 'Diberikan kerana menambahkan bahan ke dalam laman pengguna sendiri!',
	'achievements-badge-desc-sayhi' => 'Diberikan kerana meninggalkan pesanan di laman perbincangan orang lain!',
	'achievements-badge-desc-creator' => 'Diberikan kerana mencipta wiki ini!',
	'achievements-badge-desc-pounce' => 'Diberikan kerana membuat suntingan pada 100 laman dalam sejam selepas laman dicipta.',
	'achievements-badge-desc-caffeinated' => 'Diberikan kerana membuat 100 suntingan pada laman dalam sehari!',
	'achievements-badge-desc-luckyedit' => 'Diberikan kerana menjadi Penyunting ke-$1 Bertuah di wiki ini!',
	'achievements-userprofile-title-no' => 'Lencana yang Diraih oleh $1',
	'achievements-userprofile-title' => '$1 Meraih $2 Lencana',
	'achievements-userprofile-no-badges-owner' => 'Sila lihat senarai di bawah untuk melihat lencana-lencana yang boleh diraih di wiki ini!',
	'achievements-userprofile-no-badges-visitor' => 'Pengguna ini belum meraih lencana lagi.',
	'achievements-userprofile-profile-score' => '<em>$1</em> mata<br />Pencapaian',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Tangga #$1]]<br />di wiki ini',
);

$messages['mt'] = array(
	'achievements-upload-error' => "Jiddispjaċina!
Din l-istampa ma taħdimx.
Kun żgur li hija fajl .jpg jew .png.
Jekk xorta ma taħdimx, allura jista' jkun li l-istampa hi wisq kbira.
Jekk jogħġbok, ipprova oħra!",
	'achievements-non-existing-category' => 'Il-kategorija speċifikata ma teżistix.',
	'achievements-gold-points' => '100<br />punt',
	'achievements-silver-points' => '50<br />punt',
	'achievements-bronze-points' => '10<br />punti',
);

$messages['my'] = array(
	'achievements-gold' => 'ရွှေ',
	'achievements-silver' => 'ငွေထည်',
	'achievements-points' => 'တည်းဖြတ်မှု $1 {{PLURAL:$1|ခု|ခု}}',
	'achievements-points-with-break' => 'တည်းဖြတ်မှု $1 {{PLURAL:$1|ခု|ခု}}',
	'achievements-viewless' => 'ပိတ်ရန်',
	'achievements-viewall-oasis' => 'ဆက်လက်ကြည့်ရန်',
	'leaderboard-intro-hide' => 'ဝှက်',
	'leaderboard-intro-open' => 'ဖွင့်ရန်',
	'achievements-leaderboard-points' => 'တည်းဖြတ်မှု $1 {{PLURAL:$1|ခု|ခု}}',
	'achievements-save' => 'ပြင်​ဆင်​ထား​သည်​များ​ကို​ သိမ်းရန်',
);

$messages['mzn'] = array(
	'achievements-community-platinum-edit' => 'دچی‌ین',
);

$messages['nan'] = array(
	'achievementsii-desc' => '予Wiki用者的成就徽章系統',
	'achievements-gold' => '金',
	'achievements-silver' => '銀',
	'achievements-bronze' => '銅',
	'achievements-gold-points' => '100<br />點',
	'achievements-silver-points' => '50<br />點',
	'achievements-bronze-points' => '10<br />點',
	'achievements-viewall-oasis' => '看全部',
	'leaderboard-intro-hide' => '收',
	'leaderboard-intro-open' => '開',
	'achievements-leaderboard-member-label' => '成員',
	'achievements-send' => '保存影像',
	'achievements-save' => '共改的保存',
	'achievements-enable-track' => '通用',
	'achievements-revert' => '恢復做設便的',
	'achievements-about-title' => '關係這頁...',
	'achievements-community-platinum-edit' => '修改',
	'achievements-community-platinum-save' => '保存',
	'achievements-community-platinum-cancel' => '取消',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => '點擊就通看另外的',
);

$messages['nb'] = array(
	'achievementsii-desc' => 'Et utmerkelsessystem for wikibrukere',
	'achievements-upload-error' => 'Beklager!
Det bildet fungerer ikke.
Sørg for at det er en .jpg- eller .png-fil.
Hvis det fremdeles ikke fungerer, er bildet muligens for stort.
Vennligst prøv et annet!',
	'achievements-upload-not-allowed' => 'Administratorer kan endre navn og bilde for utmerkelser ved å besøke [[Special:AchievementsCustomize|Tilpass utmerkelser]]-siden.',
	'achievements-non-existing-category' => 'Den angitte kategorien eksisterer ikke.',
	'achievements-edit-plus-category-track-exists' => 'Den angitte kategorien har allerede en <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Gå til serien">tilknyttet serie</a>.',
	'achievements-no-stub-category' => 'Vennligst ikke lag serier for stubber.',
	'right-platinum' => 'Opprett og rediger Platinatmerkelser',
	'right-sponsored-achievements' => 'Behandle sponsede utmerkelser',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Gull',
	'achievements-silver' => 'Sølv',
	'achievements-bronze' => 'Bronse',
	'achievements-gold-points' => '100<br />poeng',
	'achievements-silver-points' => '50<br />poeng',
	'achievements-bronze-points' => '10<br />poeng',
	'achievements-you-must' => 'Du må $1 for å motta denne utmerkelsen.',
	'leaderboard-button' => 'Toppliste over utmerkelser',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|poeng|poeng}}</small>',
	'achievements-profile-title-no' => '$1s utmerkelser',
	'achievements-no-badges' => 'Sjekk ut listen under for å se utmerkelsene du kan oppnå på denne wikien!',
	'achievements-track-name-edit' => 'Redigeringsserie',
	'achievements-track-name-picture' => 'Bildeserie',
	'achievements-track-name-category' => 'Kategoriserie',
	'achievements-track-name-blogpost' => 'Blogginnlegg-serie',
	'achievements-track-name-blogcomment' => 'Bloggkommentar-serie',
	'achievements-track-name-love' => 'Wiki-kjærlighetsserie',
	'achievements-track-name-sharing' => 'Delingsteller',
	'achievements-notification-title' => 'Godt jobba, $1!',
	'achievements-notification-subtitle' => 'Du mottok nettopp «$1»-utmerkelsen $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Trykk her for å se flere utmerkelser du kan bli tildelt]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|poeng|poeng}}',
	'achievements-points-with-break' => '1<br />{{PLURAL: $1|poeng|poeng}}',
	'achievements-earned' => 'Denne utmerkelsen har blitt tildelt {{PLURAL:$1|1 bruker|$1 brukere}}.',
	'achievements-profile-title' => '$1s $2 tildelte {{PLURAL:$2|utmerkelse|utmerkelser}}',
	'achievements-profile-title-challenges' => 'Flere utmerkelser du kan oppnå!',
	'achievements-profile-customize' => 'Tilpass utmerkelser',
	'achievements-ranked' => 'rangert som nummer $1 på denne wikien',
	'achievements-viewall' => 'Vis alle',
	'achievements-viewless' => 'Lukk',
	'achievements-profile-title-oasis' => 'utmerkelses- <br /> poeng',
	'achievements-ranked-oasis' => '$1 er [[Special:Leaderboard|rangert som #$2]] på denne wikien',
	'achievements-viewall-oasis' => 'Se alle',
	'achievements-toggle-hide' => 'Skjul utmerkelsene på profilen min for alle',
	'leaderboard-intro-hide' => 'skjul',
	'leaderboard-intro-open' => 'åpne',
	'leaderboard-intro-headline' => 'Hva er utmerkelser?',
	'leaderboard-intro' => "Du kan motta utmerkelser på denne wikien ved å redigere sider, laste opp bilder og å legge inn kommentarer. Hver utmerkelse tjener deg poeng – jo fler poeng du får, jo høyere kommer du på topplista! Du finner utmerkelser du har mottatt på [[$1|brukerprofilen din]].

'''Hva er utmerkelsene verdt?'''",
	'leaderboard' => 'Toppliste over utmerkelser',
	'achievements-title' => 'Utmerkelser',
	'leaderboard-title' => 'Toppliste',
	'achievements-recent-earned-badges' => 'Nylig utdelte utmerkelser',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />ble tildelt <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'fikk utmerkelsen <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Topplisten viser endringer siden i går',
	'achievements-leaderboard-rank-label' => 'Rangering',
	'achievements-leaderboard-member-label' => 'Medlem',
	'achievements-leaderboard-points-label' => 'Poeng',
	'achievements-leaderboard-points' => '{{PLURAL:$1|poeng|poeng}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Sist tildelt',
	'achievements-send' => 'Lagre bilde',
	'achievements-save' => 'Lagre endringer',
	'achievements-reverted' => 'Utmerkelsen tilbakestilt til originalen.',
	'achievements-customize' => 'Tilpass bilde',
	'achievements-customize-new-category-track' => 'Lag ny serie for kategori:',
	'achievements-enable-track' => 'slått på',
	'achievements-revert' => 'Tilbakestill til standard',
	'achievements-special-saved' => 'Endringer lagret.',
	'achievements-special' => 'Spesialutmerkelser',
	'achievements-secret' => 'Hemmelige utmerkelser',
	'achievementscustomize' => 'Tilpass utmerkelser',
	'achievements-about-title' => 'Om denne siden...',
	'achievements-about-content' => 'Administratorer på denne wikien kan tilpasse navn og bilde for utmerkelsene.

Du kan laste opp ethvert .jpg- eller .png-bilde, og bildet vil automatisk tilpasses rammen.
Det fungerer best når bildet er kvadratisk, og når den viktigste delene av bildet er i sentrum.

Du kan bruke rektangulære bilder, men vil kanskje oppleve at biter vil bli skåret ut av rammen.
Hvis du har et grafikkprogram, kan du beskjære bildet for å plassere den viktigste delen av bildet i sentrum.
Hvis du ikke har det, kan du eksperimentere med forskjellige bilder til du finner det som passer deg best!
Hvis du ikke liker bildet du har valgt, trykker du «{{int:achievements-revert}}» for å gå tilbake til den ordinære grafikken.

Du kan også gi utmerkelsene nye navn som reflekterer wikiens tema. Når du har endret navn for utmerkelser, trykker du «{{int:achievements-save}}» for å lagre endringene. Ha det gøy!',
	'achievements-edit-plus-category-track-name' => '$1 rediger serie',
	'achievements-create-edit-plus-category-title' => 'Opprett en ny redigerigsserie',
	'achievements-create-edit-plus-category-content' => 'Du kan opprette et nytt sett utmerkelser som belønner brukere som redigerre sider i en bestemt kategori, for å markere et bestemt område av siden brukerne vil sette ekstra pris på å arbeide i.
Du kan opprette fler enn én kategoriserie, så prøv å velge to kategorier som lar brukerne vise frem sine spesialfelter!
Start en rivalisering mellom brukerne som redigerer vampyrsider og brukerne som redigerer varulvsider, eller trollmenn og gomper, eller Autoboter og Decepticoner.

For å lage en ny «Rediger-i-kategori»-serie, skriv inn navnet på kategorien i feltet nedenfor.
Den vanlige redigeringsserien vil fremdeles eksistere; dette vil opprette en separat serie som du kan tilpasse separat.

Når serien er opprettet, vil den nye utmerkelsen vises i lista til venstre, under den vanlige redigeringsserien.
Tilpass navnene og bildene for det nye serien, slik at brukerne kan se forskjellen!

Så fort du er ferdig med tilpasningen, trykk på «{{int:achievements-enable-track}}»-boksen for å aktivere den nye serien, og trykk deretter «{{int:achievements-save}}».
Brukere vil se den nye serien på brukerprofilene sine, og de vil begynne å motta utmerkelser når de redigerer sider i den kategorien.
Du kan også deaktivere serien senere, hvis du beslutter at du ikke vil markere kategorien lenger.
Brukere som har mottatt utmerkelser i denne serien vil beholde utmerkelsene for alltid, selv om serien er deaktivert.

Dette kan ta utmerkelsene til et helt nytt nivå.
Prøv det ut!',
	'achievements-create-edit-plus-category' => 'Opprett denne serien',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'Du har blitt tildelt en ny Platinautmerkelse!',
	'achievements-community-platinum-awarded-email-body-text' => "Gratulerer $1!

Du har nettopp blitt tildelt '$2'-Platinautmerkelsen på $4 ($3). Dette legger 250 poeng til summen din!

Sjekk ut den stilige nye utmerkelsen din på brukerprofilen din:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Gratulerer $1!</strong><br /><br />
Du har nettopp blitt tildelt \'<strong>$2</strong>\'-Platinautmerkelsen på <a href="$3">$4</a>. Dette legger 250 poeng til den totale summen din!<br /><br />
Sjekk ut den stilige nye utmerkelsen din på <a href="$5">brukerprofilen din</a>.',
	'achievements-community-platinum-awarded-for' => 'Tildelt for:',
	'achievements-community-platinum-how-to-earn' => 'Hvordan motta:',
	'achievements-community-platinum-awarded-for-example' => 'f.eks. «for å gjøre...»',
	'achievements-community-platinum-how-to-earn-example' => 'f.eks. «gjør tre endringer...»',
	'achievements-community-platinum-badge-image' => 'Utmerkelsesbilde:',
	'achievements-community-platinum-awarded-to' => 'Tildelt:',
	'achievements-community-platinum-current-badges' => 'Nåværende platinautmerkelser',
	'achievements-community-platinum-create-badge' => 'Lag utmerkelse',
	'achievements-community-platinum-enabled' => 'slått på',
	'achievements-community-platinum-show-recents' => 'vis i siste utmerkelser',
	'achievements-community-platinum-edit' => 'rediger',
	'achievements-community-platinum-save' => 'lagre',
	'achievements-community-platinum-cancel' => 'avbryt',
	'achievements-community-platinum-sponsored-label' => 'Sponset utmerkelse',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Bilde når mus holdes over <small>(minimumsstørrelse: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Sporingsadresse for inntrykk av utmerkelse:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Sporingsadresse for inntrykk av objekt ved mus over:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Utmerkelseslenke <small>(DART-trykk kommando-URL)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Klikk for mer informasjon',
	'achievements-badge-name-edit-0' => 'Gjør en forskjell',
	'achievements-badge-name-edit-1' => 'Bare begynnelsen',
	'achievements-badge-name-edit-2' => 'Gjør sin del',
	'achievements-badge-name-edit-3' => 'Venn av wikien',
	'achievements-badge-name-edit-4' => 'Samarbeidspartner',
	'achievements-badge-name-edit-5' => 'Wiki-bygger',
	'achievements-badge-name-edit-6' => 'Wiki-leder',
	'achievements-badge-name-edit-7' => 'Wiki-ekspert',
	'achievements-badge-name-picture-0' => 'Blinkskudd',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illustratør',
	'achievements-badge-name-picture-3' => 'Samler',
	'achievements-badge-name-picture-4' => 'Kunstelsker',
	'achievements-badge-name-picture-5' => 'Dekoratør',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Kurator',
	'achievements-badge-name-category-0' => 'Se en sammenheng',
	'achievements-badge-name-category-1' => 'Kartlegger',
	'achievements-badge-name-category-2' => 'Utforsker',
	'achievements-badge-name-category-3' => 'Turguide',
	'achievements-badge-name-category-4' => 'Navigatør',
	'achievements-badge-name-category-5' => 'Brobygger',
	'achievements-badge-name-category-6' => 'Wiki-planlegger',
	'achievements-badge-name-blogpost-0' => 'Noe å si',
	'achievements-badge-name-blogpost-1' => 'Fem ting å si',
	'achievements-badge-name-blogpost-2' => 'Talkshow',
	'achievements-badge-name-blogpost-3' => 'Festens midtpunkt',
	'achievements-badge-name-blogpost-4' => 'Folketaler',
	'achievements-badge-name-blogcomment-0' => 'Meningsinnehaver',
	'achievements-badge-name-blogcomment-1' => 'Og én ting til',
	'achievements-badge-name-love-0' => 'Nøkkelen til wikien!',
	'achievements-badge-name-love-1' => 'To uker på wikien',
	'achievements-badge-name-love-2' => 'Engasjert',
	'achievements-badge-name-love-3' => 'Dedikert',
	'achievements-badge-name-love-4' => 'Avhengig',
	'achievements-badge-name-love-5' => 'Et wiki-liv',
	'achievements-badge-name-love-6' => 'Wiki-helt!',
	'achievements-badge-name-sharing-0' => 'Utdeler',
	'achievements-badge-name-sharing-1' => 'Rett hjem',
	'achievements-badge-name-sharing-2' => 'Talsmann',
	'achievements-badge-name-sharing-3' => 'Annonsør',
	'achievements-badge-name-sharing-4' => 'Evangelist',
	'achievements-badge-name-welcome' => 'Velkommen til wikien',
	'achievements-badge-name-introduction' => 'Introduksjon',
	'achievements-badge-name-sayhi' => 'Stopper for å si hei',
	'achievements-badge-name-creator' => 'Skaperen',
	'achievements-badge-name-pounce' => 'Angrip!',
	'achievements-badge-name-caffeinated' => 'Koffeinholdig',
	'achievements-badge-name-luckyedit' => 'Lykketreff',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|del lenke|få {{PLURAL:$1|én person|$1 personer}} til å trykke på lenken du delte}}',
	'achievements-badge-to-get-edit' => 'rediger $1 {{PLURAL:$1|side|sider}}',
	'achievements-badge-to-get-edit-plus-category' => 'foreta $1 {{PLURAL:$1|redigering|redigeringer}} på {{PLURAL:$1|en|}} $2-{{PLURAL:$1|side|sider}}',
	'achievements-badge-to-get-picture' => 'legge til $1 {{PLURAL:$1|bilde|bilder}}',
	'achievements-badge-to-get-category' => 'kategorisere $1 {{PLURAL:$1|side|sider}}',
	'achievements-badge-to-get-blogpost' => 'skrive $1 {{PLURAL:$1|blogginnlegg|blogginnlegg}}',
	'achievements-badge-to-get-blogcomment' => 'skrive en kommentar på $1 forskjellige blogginnlegg',
	'achievements-badge-to-get-love' => 'bidra til wikien hver dag i $1 dager',
	'achievements-badge-to-get-welcome' => 'bli med i wikien',
	'achievements-badge-to-get-introduction' => 'legge til innhold på din egen brukerside',
	'achievements-badge-to-get-sayhi' => 'legge igjen en beskjed på noens diskusjonsside',
	'achievements-badge-to-get-creator' => 'vær grunnleggeren av denne wikien',
	'achievements-badge-to-get-pounce' => 'vær rask',
	'achievements-badge-to-get-caffeinated' => 'rediger $1 {{PLURAL:$1|side|sider}} på én dag',
	'achievements-badge-to-get-luckyedit' => 'vær heldig',
	'achievements-badge-to-get-sharing-details' => 'Del lenker og få andre til å klikke på dem!',
	'achievements-badge-to-get-edit-details' => 'Mangler noe? Er noe feil?
Ikke vær sjenert.
Trykk på «{{int:edit}}»-knappen og du kan legge til noe på en hvilken som helst side!',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong>-sidene trenger din hjelp! Trykk på «{{int:edit}}»-knappen på enhver side i denne kategorien for å hjelpe til. Vis din støtte for de $1 sidene!',
	'achievements-badge-to-get-picture-details' => 'Trykk på «{{int:edit}}»-knappen, og så trykk på «{{int:rte-ck-image-add}}»-knappen. Du kan legge til et bilde fra datamaskinen din, eller fra en annen side på wikien.',
	'achievements-badge-to-get-category-details' => 'Kategorier er navnelapper som hjelper leserne å finne lignende sider.
Trykk på «{{int:categoryselect-addcategory-button}}»-knappen på bunnen av en side for å legge den til en kategori.',
	'achievements-badge-to-get-blogpost-details' => 'Skriv dine meninger og spørsmål!
Trykk på «{{int:blogs-recent-url-text}}» i sidepanelet, og så lenken til venstre for Opprett et nytt «{{int:create-blog-post-title}}».',
	'achievements-badge-to-get-blogcomment-details' => 'Legg til din mening! Les et hvilken som helst av de siste blogginnleggene, og skriv dine tanker i kommentarfeltet.',
	'achievements-badge-to-get-love-details' => 'Telleren tilbakestilles hvis du går glipp av en dag, så sørg for å komme tilbake til wikien hver dag!',
	'achievements-badge-to-get-welcome-details' => 'Trykk på «{{int:oasis-signup}}»-knappen øverst til høyre for å bli med i fellesskapet.
Du kan begynne å motta egne utmerkelser!',
	'achievements-badge-to-get-introduction-details' => 'Er brukersiden din tom? Trykk på brukernavnet ditt på toppen av skjermen for å sjekke.
Trykk «{{int:edit}}» for å legge til litt informasjon om deg selv!',
	'achievements-badge-to-get-sayhi-details' => 'Du kan legge igjen beskjeder til andre brukere ved å trykke «{{int:addsection}}» på diskusjonssiden deres. Spør etter hjelp, takk dem for arbeidet deres, eller bare si hei!',
	'achievements-badge-to-get-creator-details' => 'Denne utmerkelsen er gitt til personen som grunnla wikien.
Trykk på «{{int:createwiki}}»-knappen øverst for å starte et nettsted om det du liker best!',
	'achievements-badge-to-get-pounce-details' => 'Du må være rask for å motta denne utmerkelsen.
Trykk på «{{int:activityfeed}}»-knappen for å se nye sider som brukere oppretter!',
	'achievements-badge-to-get-caffeinated-details' => 'Det krever en travel dag for å oppnå denne utmerkelsen. Fortsett å redigere!',
	'achievements-badge-to-get-luckyedit-details' => 'Du må være heldig for å oppnå denne utmerkelsen. Fortsett å redigere!',
	'achievements-badge-to-get-community-platinum-details' => 'Dette er en spesiell Platinautmerkelse som kun er tilgjengelig i en begrenset periode!',
	'achievements-badge-hover-desc-sharing' => 'Tildelt {{#ifeq:$1|0|for å dele én lenke|for å få {{PLURAL:$1|én person|$1 personer}} til å trykke på delte lenker}}',
	'achievements-badge-hover-desc-edit' => 'Tildelt for å gjøre $1 {{PLURAL:$1|redigering|redigeringer}}',
	'achievements-badge-hover-desc-edit-plus-category' => 'Tildelt for å gjøre $1 {{PLURAL:$1|redigering|redigeringer}}<br />
på {{PLURAL:$1|en $2-side|$2-sider}}',
	'achievements-badge-hover-desc-picture' => 'Tildelt for å legge til $1 {{PLURAL:$1|bilde|bilder}}',
	'achievements-badge-hover-desc-category' => 'Tildelt for å kategorisere $1 {{PLURAL:$1|side|sider}}',
	'achievements-badge-hover-desc-blogpost' => 'Tildelt for å skrive $1 {{PLURAL:$1|blogginnlegg|blogginnlegg}}!',
	'achievements-badge-hover-desc-blogcomment' => 'Tildelt for å skrive en kommentar<br />
til $1 forskjellige {{PLURAL:$1|blogginnlegg|blogginnlegg}}!',
	'achievements-badge-hover-desc-love' => 'Tildelt for å bidra til wikien hver dag i $1 {{PLURAL:$1|én dag|$1 dager}}!',
	'achievements-badge-hover-desc-welcome' => 'Tildelt for å bli med i wikien!',
	'achievements-badge-hover-desc-introduction' => 'Tildelt for å legge til innhold<br />
på din egen brukerside!',
	'achievements-badge-hover-desc-sayhi' => 'Tildelt for å legge igjen en beskjed<br />
på noen andres diskusjonsside!',
	'achievements-badge-hover-desc-creator' => 'Tildelt for å opprette wikien!',
	'achievements-badge-hover-desc-pounce' => 'Tildelt for å redigere 100 sider i løpet av en time etter at siden ble opprettet!',
	'achievements-badge-hover-desc-caffeinated' => 'Tildelt for å gjøre 100 redigeringer på sider på én dag!',
	'achievements-badge-hover-desc-luckyedit' => 'Tildelt for å gjøre den heldige $1. redigeringen på wikien!',
	'achievements-badge-hover-desc-community-platinum' => 'Tildelt Dette er en spesiell Platinautmerkelse som kun er tilgjengelig i en begrenset tidsperiode!',
	'achievements-badge-your-desc-sharing' => 'Tildelt {{#ifeq:$1|0|for å dele én lenke|for å få {{PLURAL:$1|én person|$1 personer}} til å trykke på delte lenker}}',
	'achievements-badge-your-desc-edit' => 'Tildelt for å gjøre {{PLURAL:$1|din første|$1}} {{PLURAL:$1|redigering|redigeringer!}} {{PLURAL:$1|på en side!|}}',
	'achievements-badge-your-desc-edit-plus-category' => 'Tildelt for å gjøre {{PLURAL:$1|din første|$1}} {{PLURAL:$1|redigering|redigeringer}} på {{PLURAL:$1|en|}} $2-{{PLURAL:$1|side|sider}}!',
	'achievements-badge-your-desc-picture' => 'Tildelt for å legge {{PLURAL:$1|ditt første|til $1}} {{PLURAL:$1|bilde|bilder!}} {{PLURAL:$1|til en side!|}}',
	'achievements-badge-your-desc-category' => 'Tildelt for å legge {{PLURAL:$1|din første|$1}} {{PLURAL:$1|side|sider}} til {{PLURAL:$1|en kategori|kategorier}}!',
	'achievements-badge-your-desc-blogpost' => 'Tildelt for å skrive {{PLURAL:$1|ditt første|$1}} {{PLURAL:$1|blogginnlegg|blogginnlegg}}!',
	'achievements-badge-your-desc-blogcomment' => 'Tildelt for å skrive en kommentar til {{PLURAL:$1|et blogginnlegg|$1 forskjellige blogginnlegg}}!',
	'achievements-badge-your-desc-love' => 'Tildelt for å bidra til wikien hver dag i {{PLURAL:$1|én dag|$1 dager}}!',
	'achievements-badge-your-desc-welcome' => 'Tildelt for å bli med i wikien!',
	'achievements-badge-your-desc-introduction' => 'Tildelt for å legge til innhold på din egen brukerside!',
	'achievements-badge-your-desc-sayhi' => 'Tildelt for å legge igjen en beskjed på noen andres diskusjonsside!',
	'achievements-badge-your-desc-creator' => 'Tildelt for å ha opprettet wikien!',
	'achievements-badge-your-desc-pounce' => 'Tildelt for å gjøre redigeringer på 100 sider i løpet av en time etter at siden ble opprettet!',
	'achievements-badge-your-desc-caffeinated' => 'Tildelt for å gjøre 100 redigeringer på sider på én dag!',
	'achievements-badge-your-desc-luckyedit' => 'Tildelt for å gjøre den heldige $1. redigeringen på wikien!',
	'achievements-badge-desc-sharing' => 'Tildelt {{#ifeq:$1|0|for å dele én lenke|for å få {{PLURAL:$1|én person|$1 personer}} til å trykke på delte lenker}}',
	'achievements-badge-desc-edit' => 'Tildelt for å gjøre $1 {{PLURAL:$1|redigering|redigeringer!}} {{PLURAL:$1|på en side!|}}',
	'achievements-badge-desc-edit-plus-category' => 'Tildelt for å gjøre $1 {{PLURAL:$1|redigering|redingeringer}} på {{PLURAL:$1|en|}} $2-{{PLURAL:$1|side|sider}}!',
	'achievements-badge-desc-picture' => 'Tildelt for å legge {{PLURAL:$1|$1 bilde|til $1 bilder!}} {{PLURAL:$1|til en side!|}}',
	'achievements-badge-desc-category' => 'Tildelt for å kategorisere $1 {{PLURAL:$1|side|sider}}!',
	'achievements-badge-desc-blogpost' => 'Tildelt for å skrive $1 {{PLURAL:$1|blogginnlegg|blogginnlegg}}!',
	'achievements-badge-desc-blogcomment' => 'Tildelt for å skrive en kommentar på {{PLURAL:$1|et blogginnlegg|$1 forskjellige blogginnlegg}}!',
	'achievements-badge-desc-love' => 'Tildelt for å bidra på wikien hver dag i {{PLURAL:$1|én dag|$1 dager}}!',
	'achievements-badge-desc-welcome' => 'Tildelt for å bli med i wikien!',
	'achievements-badge-desc-introduction' => 'Tildelt for å legge til innhold på din egen brukerside!',
	'achievements-badge-desc-sayhi' => 'Tildelt for å legge igjen en beskjed på noen andres diskusjonsside!',
	'achievements-badge-desc-creator' => 'Tildelt for å opprette wikien!',
	'achievements-badge-desc-pounce' => 'Tildelt for å redigere 100 sider i løpet av en time etter at siden ble opprettet!',
	'achievements-badge-desc-caffeinated' => 'Tildelt for å gjøre 100 redigeringer på sider på én dag!',
	'achievements-badge-desc-luckyedit' => 'Tildelt for å gjøre den heldige $1. redigeringen på wikien!',
	'achievements-userprofile-title-no' => '$1s tildelte utmerkelser',
	'achievements-userprofile-title' => '$1s mottatte {{PLURAL:$2|utmerkelse|utmerkelser}} ($2)',
	'achievements-userprofile-no-badges-owner' => 'Sjekk ut listen under for å se utmerkelsene du kan motta på denne wikien!',
	'achievements-userprofile-no-badges-visitor' => 'Denne brukeren har ikke mottatt noen utmerkelser ennå.',
	'achievements-userprofile-profile-score' => '<em>$1</em> utmerkelses-<br />poeng',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Plassert som #$1]]<br /> på denne wikien',
);

$messages['nl'] = array(
	'achievementsii-desc' => 'Een speldjessysteem voor door wikigebruikers geleverde prestaties',
	'achievements-upload-error' => 'Dat plaatje werkt niet.
Zorg dat het een .jpg- of .png-bestand is.
Als het dan nog steeds niet werkt, dan is het plaatje mogelijk te groot.
Kies dan een ander plaatje.',
	'achievements-upload-not-allowed' => 'Beheerders kunnen de namen en afbeeldingen van prestatiespeldjes wijzigen via de pagina [[Special:AchievementsCustomize|Prestaties aanpassen]].',
	'achievements-non-existing-category' => 'De opgegeven categorie bestaat niet.',
	'achievements-edit-plus-category-track-exists' => 'De opgegeven categorie heeft al een <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Naar het traject">bijbehorend traject</a>.',
	'achievements-no-stub-category' => 'Maak alstublieft geen trajecten voor beginnetjes aan.',
	'right-platinum' => 'Platinaspeldjes aanmaken en bewerken',
	'right-sponsored-achievements' => 'Gesponsorde prestaties beheren',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Goud',
	'achievements-silver' => 'Zilver',
	'achievements-bronze' => 'Brons',
	'achievements-gold-points' => '100<br />punten',
	'achievements-silver-points' => '50<br />punten',
	'achievements-bronze-points' => '10<br />punten',
	'achievements-you-must' => 'U moet $1 om dit speldje te verdienen.',
	'leaderboard-button' => 'Ranglijst voor prestaties',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punt|punten}}</small>',
	'achievements-profile-title-no' => 'Speldjes van $1',
	'achievements-no-badges' => 'Hieronder staan de speldjes die u op deze wiki kunt verdienen!',
	'achievements-track-name-edit' => 'Voor bewerkingen',
	'achievements-track-name-picture' => 'Voor afbeeldingen',
	'achievements-track-name-category' => 'Voor categorieën',
	'achievements-track-name-blogpost' => 'Voor blogberichten',
	'achievements-track-name-blogcomment' => 'Voor reacties op blogberichten',
	'achievements-track-name-love' => 'Voor Wikilove',
	'achievements-track-name-sharing' => 'Delen-carrière',
	'achievements-notification-title' => 'Dat gaat goed, $1!',
	'achievements-notification-subtitle' => 'U hebt zojuist het speldje "$1" verdiend $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Klik hier om meer speldjes te zien die u kunt verdienen]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punt|punten}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punt|punten}}',
	'achievements-earned' => 'Dit speldje is verdiend door {{PLURAL:$1|één gebruiker|$1 gebruikers}}.',
	'achievements-profile-title' => '$1 heeft {{PLURAL:$2|één speldje|$2 speldjes}} verdiend',
	'achievements-profile-title-challenges' => 'Meer te verdienen speldjes!',
	'achievements-profile-customize' => 'Speldjes aanpassen',
	'achievements-ranked' => 'Op plaats $1 in de ranglijst van deze wiki',
	'achievements-viewall' => 'Allemaal bekijken',
	'achievements-viewless' => 'Sluiten',
	'achievements-profile-title-oasis' => 'prestatie-<br />punten',
	'achievements-ranked-oasis' => '$1 staat op [[Special:Leaderboard|plaats $2]] voor deze wiki',
	'achievements-viewall-oasis' => 'Allemaal bekijken',
	'achievements-toggle-hide' => 'Speldjes niet weergeven op mijn profielpagina',
	'leaderboard-intro-hide' => 'verbergen',
	'leaderboard-intro-open' => 'openen',
	'leaderboard-intro-headline' => 'Wat zijn speldjes?',
	'leaderboard-intro' => "U kunt speldjes verdienen door pagina's te bewerken, foto's te uploaden en reacties achter te laten. Voor ieder speldje krijgt u punten. Hoe meer punten u verdient, hoe hoger u komt te staan op het scorebord! Speldjes die u hebt verdiend worden weergegeven op uw [[$1|profielpagina]].

'''Wat zijn speldjes waard?'''",
	'leaderboard' => 'Ranglijst voor prestaties',
	'achievements-title' => 'Prestaties',
	'leaderboard-title' => 'Ranglijst',
	'achievements-recent-earned-badges' => 'Recent verdiende speldjes',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />toegekend aan <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'heeft het speldje <strong><a href="$3" class="badgeName">$1</a></strong> verdiend<br />$2',
	'achievements-leaderboard-disclaimer' => 'Wijzigingen op in de ranglijst sinds gisteren',
	'achievements-leaderboard-rank-label' => 'Positie',
	'achievements-leaderboard-member-label' => 'Lid',
	'achievements-leaderboard-points-label' => 'Punten',
	'achievements-leaderboard-points' => '{{PLURAL:$1|punt|punten}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Meer recent verdiend',
	'achievements-send' => 'Afbeelding opslaan',
	'achievements-save' => 'Wijzigingen opslaan',
	'achievements-reverted' => 'Het speldje is teruggedraaid naar de originele versie.',
	'achievements-customize' => 'Afbeelding aanpassen',
	'achievements-customize-new-category-track' => 'Nieuw traject voor de volgende categorie maken:',
	'achievements-enable-track' => 'ingeschakeld',
	'achievements-revert' => 'Terugdraaien naar de standaardversie',
	'achievements-special-saved' => 'De wijzigingen zijn opgeslagen.',
	'achievements-special' => 'Speciale prestaties',
	'achievements-secret' => 'Geheime prestaties',
	'achievementscustomize' => 'Speldjes aanpassen',
	'achievements-about-title' => 'Over deze pagina...',
	'achievements-about-content' => 'Beheerders van deze wiki kunnen de namen en de afbeeldingen voor de prestatiespeldjes aanpassen.

U kunt .jpg- en .png-afbeeldingen uploaden en uw afbeelding wordt automatisch aangepast aan het venster.
Het werkt het beste als uw afbeelding vierkant is en als het belangrijkste deel precies in het midden staat.

U kunt ook rechthoekige afbeeldingen gebruiken, maar dan valt een deel waarschijnlijk buiten het venster.
Als u een beeldbewerkingsprogramma heb, snijd het beeld dan bij zodat het belangrijkste deel in het midden staat.
Als u toch een andere afbeelding wilt gebruiken, klik dan op "{{int:achievements-revert}}" om terug te gaan naar de oorspronkelijke versie.

U kunt de speldjes ook een andere naam geven die beter past bij het onderwerp van de wiki.Klik op "{{int:achievements-save}}" om de gewijzigde speldjesnamen op te slaan.
Veel plezier!',
	'achievements-edit-plus-category-track-name' => 'Bewerkingstraject voor $1',
	'achievements-create-edit-plus-category-title' => 'Nieuw bewerkingstraject aanmaken',
	'achievements-create-edit-plus-category-content' => 'U kunt een nieuwe reeks speldjes maken om gebruikers te belonen voor het maken van bewerkingen in een bepaalde categorie, om een bepaald gebied van de site waarin gebruikers het leuk vinden om te werken uit te lichten.
U kunt meerdere categorietrajecten opzetten, dus probeer het eens voor twee categorieën waarin gebruikers kunnen etaleren!
Laat de rivaliteit tussen gebruikers die pagina\'s over vampieren en weerwolven bewerken ontbranden of stoomtreinen en elektrische treinen of Autobots en Decepticons.

Voer de naam van de categorie in het veld hieronder in om een nieuwe traject voor "Bewerkingen in een categorie" op te zetten.
Het standaard bewerkingentraject blijft gewoon bestaan.
Er wordt een extra traject aangemaakt dat u kunt aanpassen.

Als het traject is aangemaakt, verschijnen de speldjes in de lijst aan de linkerkant, onder het standaard bewerkingentraject.
Pas de namen en afbeeldingen voor het nieuwe traject aan, zodat gebruikers het verschil kunnen zien!

Selecteer na het maken van de aanpassingen het vakje "{{int:achievements-enable-track}}" om het nieuwe traject actief te maken en klik dan op "{{int:achievements-save}}".
Gebruikers kunnen het nieuwe traject zien in hun gebruikersprofielen en ze kunnen speldjes verdienen als ze pagina\'s in de categorie bewerken.
Op een later moment kunt u het traject ook weer uitschakelen als u die categorie niet langer wilt benadrukken.
Gebruikers behouden de speldjes die ze verdiend hebben, ook als een traject is uitgeschakeld.

Dit voegt een compleet nieuwe dimensie toe aan de pret bij het verdienen van speldjes.
Probeer het nu uit!',
	'achievements-create-edit-plus-category' => 'Dit traject aanmaken',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'U hebt een nieuw platina speldje verdiend!',
	'achievements-community-platinum-awarded-email-body-text' => 'Gefeliciteerd $1!

U heeft net het platina speldje "$2" gekregen op $4 ($3). Dit voegt 250 punten toe aan uw score.

Bekijk nu uw nieuwe speldje op uw gebruikersprofielpagina:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Gefeliciteerd $1!</strong><br /><br />
U hebt net het platina speldje "<strong>$2</strong>" op <a href="$3">$4</a> gekregen.
Hiermee zijn ook 250 punten aan uw score toegevoegd!<br /><br />
Bekijk uw glimmende nieuwe speldje op uw <a href="$5">gebruikersprofielpagina</a>.',
	'achievements-community-platinum-awarded-for' => 'Toegewezen door:',
	'achievements-community-platinum-how-to-earn' => 'Hoe te verdienen:',
	'achievements-community-platinum-awarded-for-example' => 'Bijvoorbeeld "voor het uitvoeren van ...',
	'achievements-community-platinum-how-to-earn-example' => 'Bijvoorbeeld "maak drie bewerkingen ...',
	'achievements-community-platinum-badge-image' => 'Afbeelding voor speldje:',
	'achievements-community-platinum-awarded-to' => 'Uitgereikt aan:',
	'achievements-community-platinum-current-badges' => 'Bestaande Platina speldjes',
	'achievements-community-platinum-create-badge' => 'Speldje aanmaken',
	'achievements-community-platinum-enabled' => 'ingeschakeld',
	'achievements-community-platinum-show-recents' => 'weergeven in recente speldjes',
	'achievements-community-platinum-edit' => 'bewerken',
	'achievements-community-platinum-save' => 'opslaan',
	'achievements-community-platinum-cancel' => 'annuleren',
	'achievements-community-platinum-sponsored-label' => 'Gesponsorde prestatie',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Afbeelding bij muisover <small>(minimale afmeting bij muisover: 270px x 100px):</small>',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Track-URL voor speldjesweergave:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Track-URL voor muisoverweergave:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Verwijzing naar speldje <small>(klikcommando-URL voor DART)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Klik voor meer informatie',
	'achievements-badge-name-edit-0' => 'Het verschil maken',
	'achievements-badge-name-edit-1' => 'Nog maar het begin',
	'achievements-badge-name-edit-2' => 'Uw stempel zetten',
	'achievements-badge-name-edit-3' => 'Vriend van de wiki',
	'achievements-badge-name-edit-4' => 'Samenwerker',
	'achievements-badge-name-edit-5' => 'Wikibouwer',
	'achievements-badge-name-edit-6' => 'Wikileider',
	'achievements-badge-name-edit-7' => 'Wikiexpert',
	'achievements-badge-name-picture-0' => 'Kiekje',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illustrator',
	'achievements-badge-name-picture-3' => 'Verzamelaar',
	'achievements-badge-name-picture-4' => 'Kunstliefhebber',
	'achievements-badge-name-picture-5' => 'Decorateur',
	'achievements-badge-name-picture-6' => 'Ontwerper',
	'achievements-badge-name-picture-7' => 'Conservator',
	'achievements-badge-name-category-0' => 'Maak een verbinding',
	'achievements-badge-name-category-1' => 'Verkenner',
	'achievements-badge-name-category-2' => 'Onderzoeker',
	'achievements-badge-name-category-3' => 'Gids',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Bruggenbouwer',
	'achievements-badge-name-category-6' => 'Wikiplanner',
	'achievements-badge-name-blogpost-0' => 'Iets te zeggen',
	'achievements-badge-name-blogpost-1' => 'Vijf dingen te zeggen',
	'achievements-badge-name-blogpost-2' => 'Praatprogramma',
	'achievements-badge-name-blogpost-3' => 'Feestbeest',
	'achievements-badge-name-blogpost-4' => 'Openbaar spreker',
	'achievements-badge-name-blogcomment-0' => 'Commentator',
	'achievements-badge-name-blogcomment-1' => 'En dan nog iets',
	'achievements-badge-name-love-0' => 'Belangrijk voor de wiki!',
	'achievements-badge-name-love-1' => 'Twee weken in de wiki',
	'achievements-badge-name-love-2' => 'Verknocht',
	'achievements-badge-name-love-3' => 'Toegewijd',
	'achievements-badge-name-love-4' => 'Verslaafd',
	'achievements-badge-name-love-5' => 'Een wikileven',
	'achievements-badge-name-love-6' => 'Wikiheld!',
	'achievements-badge-name-sharing-0' => 'Deler',
	'achievements-badge-name-sharing-1' => 'Breng het terug',
	'achievements-badge-name-sharing-2' => 'Spreker',
	'achievements-badge-name-sharing-3' => 'Omroeper',
	'achievements-badge-name-sharing-4' => 'Evangelist',
	'achievements-badge-name-welcome' => 'Welkom bij de wiki',
	'achievements-badge-name-introduction' => 'Inleiding',
	'achievements-badge-name-sayhi' => 'Langsgekomen voor een begroeting',
	'achievements-badge-name-creator' => 'De oprichter',
	'achievements-badge-name-pounce' => 'Stormram!',
	'achievements-badge-name-caffeinated' => 'Overdosis koffie',
	'achievements-badge-name-luckyedit' => 'Gelukkige bewerking',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|verwijzing delen|zorg dat {{PLURAL:$1|één gebruiker|$1 gebruikers}} klikt op de verwijzing die u hebt gedeeld}}',
	'achievements-badge-to-get-edit' => "maak {{PLURAL:$1|één bewerking|$1 bewerkingen}} aan {{PLURAL:$1een pagina|pagina's}}",
	'achievements-badge-to-get-edit-plus-category' => "maak {{PLURAL:$1|één bewerking|$1 bewerkingen}} aan $2 {{PLURAL:$2|pagina|pagina's}}",
	'achievements-badge-to-get-picture' => "voeg {{PLURAL:$1|een afbeelding|$1 afbeeldingen}} toe aan {{PLURAL:$1|een pagina|pagina's}}",
	'achievements-badge-to-get-category' => "voeg {{PLURAL:$1|één pagina|$1 pagina's}} toe aan {{PLURAL:$1|een categorie|categorieën}}",
	'achievements-badge-to-get-blogpost' => 'schrijf {{PLURAL:$1|een blogbericht|$1 blogberichten}}',
	'achievements-badge-to-get-blogcomment' => 'schrijf een reactie bij {{PLURAL:$1|een blogbericht|$1 verschillende blogberichten}}',
	'achievements-badge-to-get-love' => 'draag iedere dag bij aan de wiki gedurende {{PLURAL:$1|één dag|$1 dagen}}',
	'achievements-badge-to-get-welcome' => 'registreer bij de wiki',
	'achievements-badge-to-get-introduction' => 'bewerk uw eigen gebruikerspagina',
	'achievements-badge-to-get-sayhi' => 'laat een bericht op de overlegpagina van een andere geburiker achter',
	'achievements-badge-to-get-creator' => 'wees de oprichter van deze wiki',
	'achievements-badge-to-get-pounce' => 'wees snel',
	'achievements-badge-to-get-caffeinated' => 'maak {{PLURAL:$1|één bewerking|$1 bewerkingen}} in één dag',
	'achievements-badge-to-get-luckyedit' => 'wees gelukkig',
	'achievements-badge-to-get-sharing-details' => 'Deel verwijzingen en zorg dat anderen erop klikken!',
	'achievements-badge-to-get-edit-details' => 'Mist er iets?
Is er een fout gemaakt?
Wees niet verlegen.
Klik op de knop "{{int:edit}}" en u kunt iedere pagina bewerken!',
	'achievements-badge-to-get-edit-plus-category-details' => 'De pagina\'s van de categorie <strong>$1</strong> hebben uw hulp nodig.
Klik op de knop "{{int:edit}}" op een pagina uit die categorie om te helpen.
Steun de pagina\'s uit de categorie $1!',
	'achievements-badge-to-get-picture-details' => 'Klik op de knop "{{int:edit}}" en daarna op de knop "{{int:rte-ck-image-add}}".
U kunt een afbeelding van uw computer toevoegen of een afbeelding van een andere pagina van de wiki.',
	'achievements-badge-to-get-category-details' => 'Categorieën zijn labels die lezers helpen bij het vinden van soortgelijke pagina\'s.
Klik op de knop "{{int:categoryselect-addcategory-button}}" onderaan een pagina om die pagina in een categorie op te nemen.',
	'achievements-badge-to-get-blogpost-details' => 'Laat uw mening horen en stel vragen!
Klik op "{{int:blogs-recent-url-text}}" in het menu en daarna op de verwijzing "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Laat uw mening gelden!
Lees de recente blogberichten en schrijf uw gedachten op in het opmerkingenveld.',
	'achievements-badge-to-get-love-details' => 'De teller wordt op nul gezet als u een dag mist, dus zorg ervoor dat u iedere dag naar de wiki komt!',
	'achievements-badge-to-get-welcome-details' => 'Klik op de knop "{{int:oasis-signup}}" rechts bovenaan om bij de gemeenschap te komen.
U kunt nu beginnen met het verzamelen van speldjes!',
	'achievements-badge-to-get-introduction-details' => 'Is uw gebruikerspagina leeg?
Klik op uw gebruikersnaam bovenaan het scherm om te kijken of dat zo is.
Klik op "{{int:edit}}" om wat informatie over uzelf toe te voegen!',
	'achievements-badge-to-get-sayhi-details' => 'U kunt berichten voor andere gebruikers achterlaten door te klikken op "{{int:addsection}}" op hun overlegpagina.
Vraag om hulp, bedank ze voor hun bijdragen of groet ze gewoon!',
	'achievements-badge-to-get-creator-details' => 'Dit speldje wordt gegeven aan de oprichter van de wiki.
Klik op de knop "{{int:createwiki}}" bovenaan om een site te beginnen over waar u van houdt!',
	'achievements-badge-to-get-pounce-details' => 'U moet snel zijn om dit speldje te verdienen.
Klik op de knop "{{int:activityfeed}}" om te zien welke nieuwe pagina\'s gebruikers aan het aanmaken zijn!',
	'achievements-badge-to-get-caffeinated-details' => 'U moet een drukke dag hebben om dit speldje te verdienen.
Blijf bewerkingen maken!',
	'achievements-badge-to-get-luckyedit-details' => 'U moet geluk hebben om dit speldje te verdienen.
Blijf bewerkingen maken!',
	'achievements-badge-to-get-community-platinum-details' => 'Dit is een speciaal platina speldje dat slechts voor beperkte tijd beschikbaar is!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|voor het delen van één verwijzing|voor het overreden van {{PLURAL:$1|één gebruiker|$1 gebruikers}} op gedeelde verwijzingen te klikken}}',
	'achievements-badge-hover-desc-edit' => "Toegekend voor het maken van {{PLURAL:$1|één bewerking|$1 bewerkingen}}<br />
aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-hover-desc-edit-plus-category' => "Toegekend voor het maken van {{PLURAL:$1|één bewerking|$1 bewerkingen}}<br />
aan {{PLURAL:$1|een $2pagina|$2pagina's}}!",
	'achievements-badge-hover-desc-picture' => "Toegekend voor het toevoegen van {{PLURAL:$1|een afbeelding|$1 afbeeldingen}}<br />
aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-hover-desc-category' => "Toegekend voor het toevoegen van {{PLURAL:$1|een pagina|$1 pagina's}}<br />
aan {{PLURAL:$1|een categorie|categorieën}}!",
	'achievements-badge-hover-desc-blogpost' => 'Toegekend voor het schrijven van {{PLURAL:$1|een blogbericht|$1 blogberichten}}!',
	'achievements-badge-hover-desc-blogcomment' => 'Toegekend voor het schrijven van een opmerking<br />
bij {{PLURAL:$1|een blogbericht|$1 verschillende blogberichten}}!',
	'achievements-badge-hover-desc-love' => 'Toegekend voor het iedere dag bijdragen aan de wiki gedurende {{PLURAL:$1|een dag|$1 dagen}}!',
	'achievements-badge-hover-desc-welcome' => 'Toegekend voor het deelnemen aan de wiki!',
	'achievements-badge-hover-desc-introduction' => 'Toegekend voor het aanmaken van<br />
uw eigen gebruikerspagina!',
	'achievements-badge-hover-desc-sayhi' => 'Toegekend voor het achterlaten van een bericht op<br />
de overlegpagina van een andere gebruiker!',
	'achievements-badge-hover-desc-creator' => 'Toegekend voor het oprichten van de wiki!',
	'achievements-badge-hover-desc-pounce' => "Toegekend voor het maken van bewerkingen aan 100 pagina's binnen een uur van het aanmaken van de pagina!",
	'achievements-badge-hover-desc-caffeinated' => 'Toegekend voor het maken van 100 bewerkingen op één dag.',
	'achievements-badge-hover-desc-luckyedit' => 'Toegekend voor het maken van de gelukkige bewerking nummer $1 op de wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Dit is een speciaal platina speldje dat slechts voor beperkte tijd beschikbaar is!',
	'achievements-badge-your-desc-sharing' => 'Toegekend {{#ifeq:$1|0|voor het delen van één verwijzing|voor het overreden van {{PLURAL:$1|één gebruiker|$1 gebruikers}} op gedeelde verwijzingen te klikken}}',
	'achievements-badge-your-desc-edit' => "Toegekend voor het maken van {{PLURAL:$1|uw eerste bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-your-desc-edit-plus-category' => "Toegekend voor het maken van {{PLURAL:$1|uw eerste bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een $2pagina|$2pagina's}}!",
	'achievements-badge-your-desc-picture' => "Toegekend voor het toevoegen van {{PLURAL:$1|uw eerste afbeelding|$1 afbeeldingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-your-desc-category' => "Toegekend voor het toevoegen van {{PLURAL:$1|uw eerste pagina|$1 pagina's}} aan {{PLURAL:$1|een categorie|categorieën}}!",
	'achievements-badge-your-desc-blogpost' => 'Toegekend voor het schrijven van {{PLURAL:$1|uw eerste blogbericht|$1 blogberichten}}!',
	'achievements-badge-your-desc-blogcomment' => 'Toegekend voor het schrijven van een opmerking bij {{PLURAL:$1|een blogbericht|$1 verschillende blogberichten}}!',
	'achievements-badge-your-desc-love' => 'Toegekend voor het iedere dag bijdragen aan de wiki gedurende {{PLURAL:$1|een dag|$1 dagen}}!',
	'achievements-badge-your-desc-welcome' => 'Toegekend voor het deelnemen aan de wiki!',
	'achievements-badge-your-desc-introduction' => 'Toegekend voor het aanmaken van uw eigen gebruikerspagina!',
	'achievements-badge-your-desc-sayhi' => 'Toegekend voor het achterlaten van een bericht op de overlegpagina van een andere gebruiker!',
	'achievements-badge-your-desc-creator' => 'Toegekend voor het oprichten van de wiki!',
	'achievements-badge-your-desc-pounce' => "Toegekend voor het maken van bewerkingen aan 100 pagina's binnen een uur na het aanmaken van de pagina!",
	'achievements-badge-your-desc-caffeinated' => 'Toegekend voor het maken van 100 bewerkingen op één dag.',
	'achievements-badge-your-desc-luckyedit' => 'Toegekend voor het maken van de gelukkige bewerking nummer $1 op de wiki!',
	'achievements-badge-desc-sharing' => 'Toegekend {{#ifeq:$1|0|voor het delen van één verwijzing|voor het overreden van {{PLURAL:$1|één gebruiker|$1 gebruikers}} op gedeelde verwijzingen te klikken}}',
	'achievements-badge-desc-edit' => "Toegekend voor het maken van {{PLURAL:$1|een bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-desc-edit-plus-category' => "Toegekend voor het maken van {{PLURAL:$1|een bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een $2pagina|$2pagina's}}!",
	'achievements-badge-desc-picture' => "Toegekend voor het toevoegen van {{PLURAL:$1|een afbeelding|$1 afbeeldingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-desc-category' => "Toegekend voor het toevoegen van {{PLURAL:$1|een pagina|$1 pagina's}} aan {{PLURAL:$1|een categorie|categorieën}}!",
	'achievements-badge-desc-blogpost' => 'Toegekend voor het schrijven van {{PLURAL:$1|een blogbericht|$1 blogberichten}}!',
	'achievements-badge-desc-blogcomment' => 'Toegekend voor het schrijven van een opmerking bij {{PLURAL:$1|een blogbericht|$1 verschillende blogberichten}}!',
	'achievements-badge-desc-love' => 'Toegekend voor het iedere dag bijdragen aan de wiki gedurende {{PLURAL:$1|een dag|$1 dagen}}!',
	'achievements-badge-desc-welcome' => 'Toegekend voor het deelnemen aan de wiki!',
	'achievements-badge-desc-introduction' => 'Toegekend voor het aanmaken van uw eigen gebruikerspagina!',
	'achievements-badge-desc-sayhi' => 'Toegekend voor het achterlaten van een bericht op de overlegpagina van een andere gebruiker!',
	'achievements-badge-desc-creator' => 'Toegekend voor het oprichten van de wiki!',
	'achievements-badge-desc-pounce' => "Toegekend voor het maken van bewerkingen aan 100 pagina's binnen een uur van het aanmaken van de pagina!",
	'achievements-badge-desc-caffeinated' => 'Toegekend voor het maken van 100 bewerkingen op één dag.',
	'achievements-badge-desc-luckyedit' => 'Toegekend voor het maken van de gelukkige bewerking nummer $1 op de wiki!',
	'achievements-userprofile-title-no' => 'Door $1 verdiende speldjes',
	'achievements-userprofile-title' => 'Door $1 {{PLURAL:$2|verdiend speldje|verdiende speldjes}} ($2)',
	'achievements-userprofile-no-badges-owner' => 'Hieronder staat de lijst met speldjes die u in deze wiki kunt verdienen!',
	'achievements-userprofile-no-badges-visitor' => 'Deze gebruiker heeft nog geen speldje verdiend.',
	'achievements-userprofile-profile-score' => '<em>$1</em> prestatie-<br />punten',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Op plaats #$1]]<br />op deze wiki',
	'action-platinum' => 'create and edit Platinum badges',
	'achievements-next-oasis' => 'Next',
	'achievements-prev-oasis' => 'Previous',
	'right-achievements-exempt' => 'User is ineligible to earn achievement points',
	'right-achievements-explicit' => 'User is eligible to earn achievement points (Overrides exempt)',
);

$messages['nl-informal'] = array(
	'achievements-you-must' => 'Je moet $1 om dit speldje te verdienen.',
	'achievements-no-badges' => 'Hieronder staan de speldjes die je op deze wiki kunt verdienen!',
	'achievements-notification-subtitle' => 'Je hebt zojuist het speldje "$1" verdiend $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Klik hier om meer speldjes te zien die je kunt verdienen]]!</big></strong>',
	'leaderboard-intro' => "Je kunt speldjes verdienen door pagina's te bewerken, foto's te uploaden en reacties achter te laten. Voor ieder speldje krijg je punten. Hoe meer punten je verdient, hoe hoger je komt te staan op het scorebord! Speldjes die je hebt verdiend worden weergegeven op uw [[$1|profielpagina]].

'''Wat zijn speldjes waard?'''",
	'achievements-about-content' => 'Beheerders van deze wiki kunnen de namen en de afbeeldingen voor de prestatiespeldjes aanpassen.

Je kunt .jpg- en .png-afbeeldingen uploaden en je afbeelding wordt automatisch aangepast aan het venster.
Het werkt het beste als je afbeelding vierkant is en als het belangrijkste deel precies in het midden staat.

Je kunt ook rechthoekige afbeeldingen gebruiken, maar dan valt een deel waarschijnlijk buiten het venster.
Als je een beeldbewerkingsprogramma heb, snijd het beeld dan bij zodat het belangrijkste deel in het midden staat.
Als je toch een andere afbeelding wilt gebruiken, klik dan op "{{int:achievements-revert}}" om terug te gaan naar de oorspronkelijke versie.

Je kunt de speldjes ook een andere naam geven die beter past bij het onderwerp van de wiki.Klik op "{{int:achievements-save}}" om de gewijzigde speldjesnamen op te slaan.
Veel plezier!',
	'achievements-create-edit-plus-category-content' => 'Je kunt een nieuwe reeks speldjes maken om gebruikers te belonen voor het maken van bewerkingen in een bepaalde categorie, om een bepaald gebied van de site waarin gebruikers het leuk vinden om te werken uit te lichten.
Je kunt meerdere categorietrajecten opzetten, dus probeer het eens voor twee categorieën waarin gebruikers kunnen etaleren!
Laat de rivaliteit tussen gebruikers die pagina\'s over vampieren en weerwolven bewerken ontbranden of stoomtreinen en elektrische treinen of Autobots en Decepticons.

Voer de naam van de categorie in het veld hieronder in om een nieuwe traject voor "Bewerkingen in een categorie" op te zetten.
Het standaard bewerkingentraject blijft gewoon bestaan.
Er wordt een extra traject aangemaakt dat je kunt aanpassen.

Als het traject is aangemaakt, verschijnen de speldjes in de lijst aan de linkerkant, onder het standaard bewerkingentraject.
Pas de namen en afbeeldingen voor het nieuwe traject aan, zodat gebruikers het verschil kunnen zien!

Selecteer na het maken van de aanpassingen het vakje "{{int:achievements-enable-track}}" om het nieuwe traject actief te maken en klik dan op "{{int:achievements-save}}".
Gebruikers kunnen het nieuwe traject zien in hun gebruikersprofielen en ze kunnen speldjes verdienen als ze pagina\'s in de categorie bewerken.
Op een later moment kan je het traject ook weer uitschakelen als je die categorie niet langer wilt benadrukken.
Gebruikers behouden de speldjes die ze verdiend hebben, ook als een traject is uitgeschakeld.

Dit voegt een compleet nieuwe dimensie toe aan de pret bij het verdienen van speldjes.
Probeer het nu uit!',
	'achievements-community-platinum-awarded-email-subject' => 'Je hebt een nieuw platina speldje verdiend!',
	'achievements-community-platinum-awarded-email-body-text' => 'Gefeliciteerd $1!

Je hebt net het platina speldje "$2" gekregen op $4 ($3). Dit voegt 250 punten toe aan je score.

Bekijk nu je nieuwe speldje op je gebruikersprofielpagina:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Gefeliciteerd $1!</strong><br /><br />
Je hebt net het platina speldje "<strong>$2</strong>" op <a href="$3">$4</a> gekregen.
Hiermee zijn ook 250 puten aan je score toegevoegd!<br /><br />
Bekijk je glimmende nieuwe speldje op je <a href="$5">gebruikersprofielpagina</a>.',
	'achievements-badge-name-edit-2' => 'Je stempel zetten',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|verwijzing delen|zorg dat {{PLURAL:$1|één gebruiker|$1 gebruikers}} klikt op de verwijzing die je hebt gedeeld}}',
	'achievements-badge-to-get-introduction' => 'bewerk je eigen gebruikerspagina',
	'achievements-badge-to-get-edit-details' => 'Mist er iets?
Is er een fout gemaakt?
Wees niet verlegen. Klik op de knop "{{int:edit}}" en je kunt iedere pagina bewerken!',
	'achievements-badge-to-get-edit-plus-category-details' => 'De pagina\'s van de categorie <strong>$1</strong> hebben je hulp nodig.
Klik op de knop "{{int:edit}}" op een pagina uit die categorie om te helpen.
Steun de pagina\'s uit de categorie $1!',
	'achievements-badge-to-get-picture-details' => 'Klik op de knop "{{int:edit}}" en daarna op de knop "{{int:rte-ck-image-add}}".
Je kunt een afbeelding van je computer toevoegen of een afbeelding van een andere pagina van de wiki.',
	'achievements-badge-to-get-blogpost-details' => 'Laat je mening horen en stel vragen!
Klik op "{{int:blogs-recent-url-text}}" in het menu en daarna op de verwijzing "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Laat je mening gelden!
Lees de recente blogberichten en schrijf je gedachten op in het opmerkingenveld.',
	'achievements-badge-to-get-love-details' => 'De teller wordt op nul gezet als je een dag mist, dus zorg ervoor dat je iedere dag naar de wiki komt!',
	'achievements-badge-to-get-welcome-details' => 'Klik op de knop "{{int:oasis-signup}}" rechts bovenaan om bij de gemeenschap te komen.
Je kunt nu beginnen met het verzamelen van speldjes!',
	'achievements-badge-to-get-introduction-details' => 'Is je gebruikerspagina leeg?
Klik op je gebruikersnaam bovenaan het scherm om te kijken of dat zo is.
Klik op "{{int:edit}}" om wat informatie over jezelf toe te voegen!',
	'achievements-badge-to-get-sayhi-details' => 'Je kunt berichten voor andere gebruikers achterlaten door te klikken op "{{int:tooltip-ca-addsection}}" op hun overlegpagina.
Vraag om hulp, bedank ze voor hun bijdragen of zeg gewoon hoi!',
	'achievements-badge-to-get-creator-details' => 'Dit speldje wordt gegeven aan de oprichter van de wiki.
Klik op de knop "{{int:createwiki}}" bovenaan om een site te beginnen over waar je van houd!',
	'achievements-badge-to-get-pounce-details' => 'Je moet snel zijn om dit speldje te verdienen. Klik op de knop "{{int:activityfeed}}" om te zien welke nieuwe pagina\'s gebruikers aan het aanmaken zijn!',
	'achievements-badge-to-get-luckyedit-details' => 'Je moet geluk hebben om dit speldje te verdienen. Blijf bewerkingen maken!',
	'achievements-badge-hover-desc-introduction' => 'voor het aanmaken van<br />
je eigen gebruikerspagina!',
	'achievements-badge-your-desc-edit' => "voor het maken van {{PLURAL:$1|je eerste bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-your-desc-edit-plus-category' => "voor het maken van {{PLURAL:$1|je eerste bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een $2pagina|$2pagina's}}!",
	'achievements-badge-your-desc-picture' => "voor het toevoegen van {{PLURAL:$1|je eerste afbeelding|$1 afbeeldingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-your-desc-category' => "voor het toevoegen van {{PLURAL:$1|je eerste pagina|$1 pagina's}} aan {{PLURAL:$1|een categorie|categorieën}}!",
	'achievements-badge-your-desc-blogpost' => 'voor het schrijven van {{PLURAL:$1|je eerste|$1}} {{PLURAL:$1|blogbericht|blogberichten}}!',
	'achievements-badge-your-desc-introduction' => 'voor het aanmaken van je eigen gebruikerspagina!',
	'achievements-badge-desc-introduction' => 'voor het aanmaken van je eigen gebruikerspagina!',
	'achievements-userprofile-no-badges-owner' => 'Hieronder staat de lijst met speldjes die je in deze wiki kunt verdienen!',
);

$messages['or'] = array(
	'achievements-non-existing-category' => 'ଆପଣ ଖୋଜୁଥିବା ବିଭାଗଟି ମିଳୁନାହିଁ ।',
	'achievements-platinum' => 'ହୀରକ',
	'achievements-gold' => 'ସ୍ଵର୍ଣ',
	'achievements-silver' => 'ରୂପା',
	'achievements-bronze' => 'ପିତ୍ତଳ',
	'achievements-gold-points' => '୧୦୦<br />pts',
	'achievements-silver-points' => '୫୦<br />pts',
	'achievements-bronze-points' => '୧୦<br />pts',
	'achievements-leaderboard-member-label' => 'ସଭ୍ୟ',
	'achievements-about-title' => 'ଏହି ପୃଷ୍ଠା ବିଷୟରେ ...',
);

$messages['pdc'] = array(
	'achievements-community-platinum-save' => 'beilege',
);

$messages['pfl'] = array(
	'achievementsii-desc' => 'Abzaische fa Laischdunge fa Wiki-Benudza',
	'achievements-upload-error' => "Dschuldischung!
Awa des Bild fungzioniad ned.
S'gejen bloss .jpg- oda .png-Datei.
Wonn's imma noch ned fungzioniere dud, donn isch's Bild vielaischd zu grooß.
Vasuchs mol midm oanare!",
	'achievements-upload-not-allowed' => 'Adminischdradore kennen die Noame un Bilda vun Abzaische uffde Said [[Special:AchievementsCustomize|Abzaische änare]] änare.',
	'achievements-non-existing-category' => 'Die oagewene Kadegorie hods ned.',
	'achievements-edit-plus-category-track-exists' => 'Die oagewene Kadegorie hod schun ä dzugherische <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">Weesch</a>.',
	'achievements-no-stub-category' => 'Leesch kän Weesch fa Schdubs oa.',
	'right-platinum' => 'Blaadin-Abzaische mache un änare',
	'right-sponsored-achievements' => 'Brodeschierde Laischdunge vawalde',
	'achievements-platinum' => 'Blaadin',
	'achievements-gold' => 'Gold',
	'achievements-silver' => 'Silwa',
	'achievements-bronze' => 'Broase',
	'achievements-gold-points' => '100<br />Pingd',
	'achievements-silver-points' => '50<br />Pingd',
	'achievements-bronze-points' => '10<br />Pingd',
	'achievements-you-must' => 'Fas Abzaische zu grische mugschd $1.',
	'leaderboard-button' => 'Ronglischd',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|Pungd|Pingd}}</small>',
	'achievements-profile-title-no' => 'Abzaische vun $1',
	'achievements-no-badges' => 'Fa die Abzaische, wuda do vadiend konschd, guggda die Lisch unne oa!',
	'achievements-track-name-edit' => 'Weesch vunde Beawaidunge',
	'achievements-track-name-picture' => 'Bilda-Weesch',
	'achievements-track-name-category' => 'Kadegorije-Weesch',
	'achievements-track-name-blogpost' => 'Blogoidrach-Weesch',
	'achievements-track-name-blogcomment' => 'Blogkommnda-Weesch',
	'achievements-track-name-love' => 'Wiki Liewe-Weesch',
	'achievements-track-name-sharing' => 'Weesch deele',
	'achievements-notification-title' => 'Guud gmachd, $1!',
	'achievements-notification-subtitle' => "Du hoschda grad s'„$1“-Abzaische vadiend $2",
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Guggda waidari Abzaische oa, wuda vadiene konschd]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|Pungd|Pingd}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|Pungd|Pingd}}',
	'achievements-earned' => "S'Abzaische {{PLURAL:$1|hod sisch än Benudza|hawen sich $1 Benudza}} vadiend.",
	'achievements-profile-title' => '$1 hod $2 {{PLURAL:$2|Abzaische|Abzaische}} krieschd',
	'achievements-profile-title-challenges' => 'Waidari Abzaische, wuda vadiene konschd!',
	'achievements-profile-customize' => 'Abzaische oapasse',
	'achievements-ranked' => 'Bladz #$1 uffm Wiki',
	'achievements-viewall' => 'Alles zaische',
	'achievements-viewless' => 'Schließe',
	'achievements-viewall-oasis' => 'Alle oagugge',
	'leaderboard-intro-hide' => 'vaschdegle',
	'leaderboard-intro-open' => 'Effne',
	'achievements-leaderboard-member-label' => 'Midglied',
	'achievements-leaderboard-points-label' => 'Pingd',
	'achievements-leaderboard-points' => '{{PLURAL:$1|Pungd|Pingd}}',
	'achievements-send' => 'Bild schbaischare',
	'achievements-save' => 'Ännerunge schbaischare',
	'achievements-enable-track' => 'Oagschdeld',
	'achievements-revert' => 'Uffde Schdondad zrigg',
	'achievements-about-title' => 'Iwa die Said...',
	'achievements-community-platinum-enabled' => 'Oagschdeld',
	'achievements-community-platinum-edit' => 'beaawaide',
	'achievements-community-platinum-save' => 'schbaischere',
	'achievements-community-platinum-cancel' => 'Abbresche',
	'achievements-badge-name-sharing-1' => 'Brings zrigg',
	'achievements-badge-to-get-welcome' => "m'Wiki baidreede",
	'achievements-badge-to-get-luckyedit' => 'Gligg hawe',
);

$messages['pl'] = array(
	'achievementsii-desc' => 'System odznaczeń dla użytkowników wiki',
	'achievements-upload-error' => 'Nie można wyświetlić tego obrazu.
Upewnij się że jest to plik .jpg lub .png.
Jeśli mimo to nie działa, obraz może być za duży.
Spróbuj dodać inny!',
	'achievements-upload-not-allowed' => 'Administratorzy mogą zmienić nazwy i ikony odznaczeń na [[Special:AchievementsCustomize|stronie specjalnej]].',
	'achievements-non-existing-category' => 'Taka kategoria nie istnieje.',
	'achievements-edit-plus-category-track-exists' => 'Podana kategoria już posiada <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Przejdź do ścieżki">powiązaną ścieżkę</a>.',
	'achievements-no-stub-category' => 'Nie twórz ścieżek dla artykułów oznaczonych jako zalążki.',
	'right-platinum' => 'Umożliwia tworzenie i edytowanie platynowych odznaczeń',
	'right-sponsored-achievements' => 'Zarządzanie sponsorowanymi odznaczeniami.',
	'achievements-platinum' => 'Platyna',
	'achievements-gold' => 'Złoto',
	'achievements-silver' => 'Srebro',
	'achievements-bronze' => 'Brąz',
	'achievements-gold-points' => '100<br />pkt',
	'achievements-silver-points' => '50<br />pkt',
	'achievements-bronze-points' => '10<br />pkt',
	'achievements-you-must' => 'Aby zdobyć to odznaczenie, $1.',
	'leaderboard-button' => 'Ranking odznaczeń',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punkt|punkty|punktów}}</small>',
	'achievements-profile-title-no' => 'Odznaczenia $1',
	'achievements-no-badges' => 'Sprawdź listę poniżej, aby zobaczyć jakie odznaczenia możesz zdobyć na tej wiki.',
	'achievements-track-name-edit' => 'Ścieżka dla edycji',
	'achievements-track-name-picture' => 'Ścieżka dla obrazów',
	'achievements-track-name-category' => 'Ścieżka kategorii',
	'achievements-track-name-blogpost' => 'Ścieżka dla wpisów na blogu',
	'achievements-track-name-blogcomment' => 'Ścieżka dla komentarzy na blogach',
	'achievements-track-name-love' => 'Ścieżka Wiki Love',
	'achievements-track-name-sharing' => 'Ścieżka dla udostępniania linków',
	'achievements-notification-title' => 'Tak trzymaj, $1!',
	'achievements-notification-subtitle' => 'Właśnie {{GENDER:|otrzymałeś|otrzymałaś}} odznaczenie „<strong>$1</strong>”. $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Zobacz więcej odznaczeń do zdobycia]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punkt|punkty|punktów}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punkt|punkty|punktów}}',
	'achievements-earned' => 'To odznaczenie zostało zdobyte przez {{PLURAL:$1|jednego użytkownika|$1 użytkowników}}.',
	'achievements-profile-title' => '$1 {{GENDER:$1|zdobył|zdobyła}} $2 {{PLURAL:$2|odznaczenie|odznaczenia|odznaczeń}}',
	'achievements-profile-title-challenges' => 'Więcej odznaczeń, które możesz zdobyć!',
	'achievements-profile-customize' => 'Dostosuj odznaczenia',
	'achievements-ranked' => 'Na miejscu #$1 na tej wiki',
	'achievements-viewall' => 'Pokaż wszystkie',
	'achievements-viewless' => 'Zamknij',
	'achievements-profile-title-oasis' => 'punktów <br />',
	'achievements-ranked-oasis' => '$1 jest na [[Special:Leaderboard|miejscu #$2]] na tej wiki.',
	'achievements-viewall-oasis' => 'Pokaż wszystkie',
	'achievements-toggle-hide' => 'Ukryj moje odznaczenia dla wszystkich',
	'leaderboard-intro-hide' => 'ukryj',
	'leaderboard-intro-open' => 'pokaż',
	'leaderboard-intro-headline' => 'Czym są odznaczenia?',
	'leaderboard-intro' => "Zdobywaj odznaczenia edytując strony, dodając obrazy oraz zostawiając komentarze na tej wiki. Każde odznaczenie powoduje przyznanie punktów – im więcej punktów posiadasz, tym wyżej znajdujesz się w rankingu użytkowników. Odznaczenia zdobyte przez ciebie możesz znaleźć na [[$1|swoim profilu]].

'''Ile punktów są warte?'''",
	'leaderboard' => 'Ranking',
	'achievements-title' => 'Odznaczenia',
	'leaderboard-title' => 'Ranking',
	'achievements-recent-earned-badges' => 'Ostatnio zdobyte odznaczenia',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />zdobyte przez <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'zdobył odznaczenie <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Ranking pokazuje zmiany od wczoraj',
	'achievements-leaderboard-rank-label' => 'Miejsce',
	'achievements-leaderboard-member-label' => 'Użytkownik',
	'achievements-leaderboard-points-label' => 'Punkty',
	'achievements-leaderboard-points' => '{{PLURAL:$1|punkt|punkty|punktów}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Ostatnio zdobyte',
	'achievements-send' => 'Zapisz obraz',
	'achievements-save' => 'Zapisz zmiany',
	'achievements-reverted' => 'Odznaczenie zostało przywrócone do oryginalnej wersji.',
	'achievements-customize' => 'Dostosuj obraz',
	'achievements-customize-new-category-track' => 'Utwórz nową ścieżkę dla kategorii:',
	'achievements-enable-track' => 'włączone',
	'achievements-revert' => 'Przywrócić do oryginalnej wersji',
	'achievements-special-saved' => 'Zmiany zostały zapisane.',
	'achievements-special' => 'Specjalne odznaczenia',
	'achievements-secret' => 'Ukryte odznaczenia',
	'achievementscustomize' => 'Dostosuj odznaczenia',
	'achievements-about-title' => 'O tej stronie...',
	'achievements-about-content' => 'Administratorzy tej wiki mogą modyfikować nazwy i wygląd odznaczeń.

Możesz wgrać dowolny obraz w formacie .jpg lub .png – zostanie on automatycznie przeskalowany, aby zmieścił się w ramce. Najlepiej, jeśli obraz jest kwadratowy z istotną częścią znajdującą się w jego środku.

Prostokątne obrazy mogą być również użyte, ale pewne ich fragmenty mogą zostać obcięte i znaleźć się poza ramką. Jeśli posiadasz program graficzny, możesz go użyć do wykadrowania obrazu. Jeśli go nie posiadasz, poeksperymentuj z różnymi obrazami.
Jeśli nie podoba ci się nowa wersja odznaczenia, kliknij „{{int:achievements-revert}}”, aby przywrócić jego oryginalną wersję.

Możesz także nadać odznaczeniom nazwy nawiązujące do tematyki wiki. Po zakończeniu edycji odznaczeń kliknij „{{int:achievements-save}}”, aby zapisać zmiany.

Powodzenia!',
	'achievements-edit-plus-category-track-name' => 'Ścieżka edycji dla kategorii $1',
	'achievements-create-edit-plus-category-title' => 'Stwórz nową ścieżkę dla edycji',
	'achievements-create-edit-plus-category-content' => 'Możesz utworzyć nowy zestaw odznaczeń przyznawanych użytkownikom za edycje w poszczególnych kategoriach, aby wskazać obszary wiki, które mogą potrzebować edytorów.
Możesz utworzyć więcej zestawów, więc spróbuj zachęcić użytkowników o rożnych zakresach umiejętności i wiedzy.
Zainicjuj konkurencję pomiędzy użytkownikami wolącymi wampiry i tymi, którzy wolą wilkołaki, wolącymi czarodziei lub mugoli, czy Autoboty lub Decepticony.

Aby utworzyć nową grupę odznaczeń dla poszczególnych kategorii, wprowadź nazwę kategorii poniżej.
Standardowy zestaw odznaczeń pozostanie bez zmian – ta opcja utworzy dodatkowy zestaw, który można dostosowywać oddzielnie.

Kiedy zestaw zostanie utworzony, nowe odznaczenia pojawią się na liście po lewej, pod standardowym zestawem.
Dostosuj nazwy i obrazy dla nowych odznaczeń, aby użytkownicy zobaczyli różnice!

Gdy skoczysz dostosowywanie, kliknij na pole „{{int:achievements-enable-track}}”, aby włączyć nowy zestaw, a potem na „{{int:achievements-save}}”.

Użytkownicy zobaczą nową ścieżkę dostępnych oznaczeń na swoich profilach i zaczną edytować na stronach z wybranej kategorii.
Możesz także wyłączyć dodatkowe odznaczenia później, jeśli uznasz, że nie chcesz już poświęcać tyle uwagi wybranej kategorii.
Użytkownicy, którzy otrzymali odznaczenia z nowego kompletu zachowają je, nawet jeżeli ten zostanie wyłączony.

To może dodać nowy wymiar zabawy do zbierania odznaczeń!',
	'achievements-create-edit-plus-category' => 'Stwórz ścieżkę',
	'platinum' => 'Platyna',
	'achievements-community-platinum-awarded-email-subject' => 'Nowe platynowe odznaczenie!',
	'achievements-community-platinum-awarded-email-body-text' => 'Gratulacje, $1!

{{GENDER:$1|Otrzymałeś|Otrzymałaś}} właśnie platynowe odznaczenie „$2” na $4 ($3).
Spowodowało to dodanie 250 punktów do Twojego konta!

Zobacz nowe odznaczenie na swoim profilu:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Gratulacje, $1!</strong><br /><br />
{{GENDER:$1|Otrzymałeś|Otrzymałaś}} właśnie platynowe odznaczenie \'<strong>$2</strong>\' na <a href="$3">$4</a>.
Spowodowało to dodanie 250 punktów do Twojego konta!<br /><br />
Zobacz nowe odznaczenie na <a href="$5">swoim profilu</a>.',
	'achievements-community-platinum-awarded-for' => 'Przyznane za:',
	'achievements-community-platinum-how-to-earn' => 'Jak zdobyć:',
	'achievements-community-platinum-awarded-for-example' => 'np. „za edycję...”',
	'achievements-community-platinum-how-to-earn-example' => 'np. „dokonanie 3 edycji”',
	'achievements-community-platinum-badge-image' => 'Obraz odznaczenia:',
	'achievements-community-platinum-awarded-to' => 'Przyznana użytkownikowi:',
	'achievements-community-platinum-current-badges' => 'Aktualne platynowe odznaczenia',
	'achievements-community-platinum-create-badge' => 'Stwórz odznaczenie',
	'achievements-community-platinum-enabled' => 'włączone',
	'achievements-community-platinum-show-recents' => 'pokaż na liście ostatnich odznaczeń',
	'achievements-community-platinum-edit' => 'edytuj',
	'achievements-community-platinum-save' => 'zapisz',
	'achievements-community-platinum-cancel' => 'anuluj',
	'achievements-community-platinum-sponsored-label' => 'Odznaczenie sponsorowane',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Obrazek widoczny po najechaniu myszką <small>(minimalne rozmiary: 270×100 pikseli)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'URL do śledzenia kliknięć na odznakę:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'URL do śledzenia najechań na odznakę:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Łącze do odznaki <small>(polecenie kliknięcia URL w systemie DART)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Kliknij, aby uzyskać więcej informacji',
	'achievements-badge-name-edit-0' => 'Inspirator zmian',
	'achievements-badge-name-edit-1' => 'Tylko początek',
	'achievements-badge-name-edit-2' => 'Zostawiam po sobie ślad',
	'achievements-badge-name-edit-3' => 'Przyjaciel wiki',
	'achievements-badge-name-edit-4' => 'Współpracownik',
	'achievements-badge-name-edit-5' => 'Budowniczy wiki',
	'achievements-badge-name-edit-6' => 'Lider wiki',
	'achievements-badge-name-edit-7' => 'Ekspert wiki',
	'achievements-badge-name-picture-0' => 'Migawka',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Ilustrator',
	'achievements-badge-name-picture-3' => 'Kolekcjoner',
	'achievements-badge-name-picture-4' => 'Miłośnik sztuki',
	'achievements-badge-name-picture-5' => 'Dekorator',
	'achievements-badge-name-picture-6' => 'Projektant',
	'achievements-badge-name-picture-7' => 'Kustosz',
	'achievements-badge-name-category-0' => 'Tworzenie połączenia',
	'achievements-badge-name-category-1' => 'Pionier',
	'achievements-badge-name-category-2' => 'Odkrywca',
	'achievements-badge-name-category-3' => 'Przewodnik',
	'achievements-badge-name-category-4' => 'Nawigator',
	'achievements-badge-name-category-5' => 'Budowniczy mostów',
	'achievements-badge-name-category-6' => 'Wiki-planista',
	'achievements-badge-name-blogpost-0' => 'Coś do powiedzenia',
	'achievements-badge-name-blogpost-1' => 'Pięć rzeczy do powiedzenia',
	'achievements-badge-name-blogpost-2' => 'Talk-show',
	'achievements-badge-name-blogpost-3' => 'Dusza towarzystwa',
	'achievements-badge-name-blogpost-4' => 'Mówca',
	'achievements-badge-name-blogcomment-0' => 'Komentator',
	'achievements-badge-name-blogcomment-1' => 'No i jeszcze jedno',
	'achievements-badge-name-love-0' => 'Klucz do wiki!',
	'achievements-badge-name-love-1' => 'Dwa tygodnie na wiki',
	'achievements-badge-name-love-2' => 'Zaangażowany',
	'achievements-badge-name-love-3' => 'Oddany',
	'achievements-badge-name-love-4' => 'Uzależniony',
	'achievements-badge-name-love-5' => 'Życie dla wiki',
	'achievements-badge-name-love-6' => 'Bohater wiki!',
	'achievements-badge-name-sharing-0' => 'Dzielący się wiedzą',
	'achievements-badge-name-sharing-1' => 'Przywróć to!',
	'achievements-badge-name-sharing-2' => 'Mówca',
	'achievements-badge-name-sharing-3' => 'Krasomówca',
	'achievements-badge-name-sharing-4' => 'Prelegent',
	'achievements-badge-name-welcome' => 'Witaj na wiki',
	'achievements-badge-name-introduction' => 'Wprowadzenie',
	'achievements-badge-name-sayhi' => 'Powiedz cześć!',
	'achievements-badge-name-creator' => 'Twórca',
	'achievements-badge-name-pounce' => 'Skok!',
	'achievements-badge-name-caffeinated' => 'Upojony kawą',
	'achievements-badge-name-luckyedit' => 'Szczęśliwa edycja',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|podziel się linkiem|zachęć {{PLURAL:$1|jedną osobę|$1 osoby|$1 osób}} do kliknięcia na udostępniony link}}',
	'achievements-badge-to-get-edit' => 'wykonaj $1 {{PLURAL:$1|edycję|edycje|edycji}} na {{PLURAL:$1|stronie|stronach}}',
	'achievements-badge-to-get-edit-plus-category' => 'wykonaj {{PLURAL:$1|jedną edycję|$1 edycje|$1 edycji}} na {{PLURAL:$1|stronie|stronach}} z przestrzeni $2',
	'achievements-badge-to-get-picture' => 'dodaj $1 {{PLURAL:$1|obraz|obrazy|obrazów}} na {{PLURAL:$1|stronę|strony|stron}}',
	'achievements-badge-to-get-category' => 'dodaj $1 {{PLURAL:$1|stronę|strony|stron}} do kategorii',
	'achievements-badge-to-get-blogpost' => 'napisz $1 {{PLURAL:$1|wpis|wpisy|wpisów}} na blogu',
	'achievements-badge-to-get-blogcomment' => 'napisz komentarz pod {{PLURAL:$1|wpisem na blogu|$1 różnymi wpisami na blogu}}',
	'achievements-badge-to-get-love' => 'bądź {{GENDER:|aktywny|aktywna}} na wiki codziennie przez {{PLURAL:$1|jeden dzień|$1 dni|$1 dni}}',
	'achievements-badge-to-get-welcome' => 'dołącz do wiki',
	'achievements-badge-to-get-introduction' => 'edytuj własną stronę użytkownika',
	'achievements-badge-to-get-sayhi' => 'zostaw komuś wiadomość na stronie dyskusji',
	'achievements-badge-to-get-creator' => 'bądź założycielem tej wiki',
	'achievements-badge-to-get-pounce' => 'bądź {{GENDER:|szybki|szybka}}',
	'achievements-badge-to-get-caffeinated' => 'dokonaj $1 {{PLURAL:$1|edycję artykułu|edycje artykułów|edycji artykułów}} w ciągu jednego dnia',
	'achievements-badge-to-get-luckyedit' => 'miej szczęście',
	'achievements-badge-to-get-sharing-details' => 'Podziel się linkami i zachęć innych do kliknięcia na nie.',
	'achievements-badge-to-get-edit-details' => 'Czegoś brakuje? {{GENDER:|Znalazłeś|Znalazłaś}} błąd?<br />
Nie bój się – kliknij przycisk „{{int:edit}}” i popraw dowolną stronę!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Strony z kategorii <strong>$1</strong> wymagają twojej pomocy!
Kliknij na „{{int:edit}}” na dowolnej stronie z tej kategorii, aby pomóc.
Pokaż swoje wsparcie dla stron z kategorii <strong>$1</strong>.',
	'achievements-badge-to-get-picture-details' => 'Kliknij przycisk „{{int:edit}}”, a następnie „{{int:rte-ck-image-add}}”.
Można dodać obraz z komputera lub innej strony na wiki.',
	'achievements-badge-to-get-category-details' => 'Kategorie pomagają użytkownikom znaleźć podobne strony.
Kliknij na przycisk „{{int:categoryselect-addcategory-button}}” na dole strony, aby dodać ją do kategorii.',
	'achievements-badge-to-get-blogpost-details' => 'Zapisz własne opinie i pytania!
Kliknij na „{{int:blogs-recent-url-text}}” w panelu bocznym, a następnie na link po prawej „{{int:create-blog-post-title}}”.',
	'achievements-badge-to-get-blogcomment-details' => 'Wtrąć własne trzy grosze!
Zapoznaj się z którymś z ostatnich blogów i dodaj swoją opinię w komentarzach.',
	'achievements-badge-to-get-love-details' => 'Licznik resetuje się, jeżeli ominiesz dzień, więc odwiedzaj wiki każdego dnia!',
	'achievements-badge-to-get-welcome-details' => 'Kliknij na przycisk „{{int:oasis-signup}}” w górnym prawym rogu, aby stać się częścią społeczności wiki.
Możesz rozpocząć zbieranie własnych odznaczeń!',
	'achievements-badge-to-get-introduction-details' => 'Czy twoja strona użytkownika jest pusta?
Kliknij na swoją nazwę użytkownika, aby się dowiedzieć.
Kliknij na „{{int:edit}}”, aby napisać coś o sobie!',
	'achievements-badge-to-get-sayhi-details' => 'Możesz zostawić innym wiadomości klikając „{{int:addsection}}” na ich stronach dyskusji.
Zapytaj o pomoc, podziękuj za ich wkład albo po prostu się przywitaj!',
	'achievements-badge-to-get-creator-details' => 'To odznaczenie przyznawane jest twórcy wiki.
Kliknij na przycisk „{{int:createwiki}}” na górze strony, aby utworzyć wiki na interesujący cię temat!',
	'achievements-badge-to-get-pounce-details' => 'Musisz być {{GENDER:|szybki|szybka}}, aby otrzymać to odznaczenie!
Kliknij na przycisk „{{int:activityfeed}}”, aby zobaczyć nowe strony tworzone przez innych!',
	'achievements-badge-to-get-caffeinated-details' => 'Zdobycie tego odznaczenia może trochę potrwać.
Nie przestawaj edytować!',
	'achievements-badge-to-get-luckyedit-details' => 'Zdobycie tego odznaczenia wymaga nieco szczęścia.
Edytuj dalej!',
	'achievements-badge-to-get-community-platinum-details' => 'To specjalne platynowe odznaczenie dostępne przez ograniczony czas!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|za podzielenie się linkiem|za zachęcenie {{PLURAL:$1|jednej osoby|$1 osób}} do kliknięcia na udostępniony link}}',
	'achievements-badge-hover-desc-edit' => 'Za dokonanie $1 {{PLURAL:$1|edycji|edycji|edycji}}<br />na {{PLURAL:$1|stronie|stronach}}.',
	'achievements-badge-hover-desc-edit-plus-category' => 'Za wykonanie $1 {{PLURAL:$1|edycji|edycji|edycji}}<br />
na {{PLURAL:$1|stronie|stronach}} z kategorii $2.',
	'achievements-badge-hover-desc-picture' => 'Za dodanie $1 {{PLURAL:$1|obrazu|obrazów}}<br />
do {{PLURAL:$1|strony|stron}}.',
	'achievements-badge-hover-desc-category' => 'Za dodanie $1 {{PLURAL:$1|strony|stron}}<br />
do kategorii.',
	'achievements-badge-hover-desc-blogpost' => 'Za napisanie $1 {{PLURAL:$1|wpisu na blogu|wpisów na blogu}}.',
	'achievements-badge-hover-desc-blogcomment' => 'Za dodanie komentarza<br />
na $1 {{PLURAL:$1|blogu|blogach}}.',
	'achievements-badge-hover-desc-love' => 'Za wnoszenie wkładu do wiki codziennie przez {{PLURAL:$1|jeden dzień|$1 dni|$1 dni}}.',
	'achievements-badge-hover-desc-welcome' => 'Za dołączenie do wiki.',
	'achievements-badge-hover-desc-introduction' => 'Za edytowanie<br />
własnej strony użytkownika.',
	'achievements-badge-hover-desc-sayhi' => 'Za zostawienie wiadomości<br />
na czyjejś stronie dyskusji.',
	'achievements-badge-hover-desc-creator' => 'Za utworzenie wiki.',
	'achievements-badge-hover-desc-pounce' => 'Za dokonanie edycji w 100 artykułach w ciągu godziny od założenia strony.',
	'achievements-badge-hover-desc-caffeinated' => 'Za wykonanie 100 edycji w ciągu jednego dnia.',
	'achievements-badge-hover-desc-luckyedit' => 'Za dokonanie szczęśliwej edycji nr $1 na wiki.',
	'achievements-badge-hover-desc-community-platinum' => 'To specjalne platynowe odznaczenie dostępne przez ograniczony czas.',
	'achievements-badge-your-desc-sharing' => '{{#ifeq:$1|0|Za podzielenie się linkiem|Za zachęcenie {{PLURAL:$1|jednej osoby|$1 osób}} do kliknięcia na udostępniony link}}',
	'achievements-badge-your-desc-edit' => 'Za wykonanie {{PLURAL:$1|swojej pierwszej edycji strony|$1 edycji stron|$1 edycji stron}}.',
	'achievements-badge-your-desc-edit-plus-category' => 'Za {{PLURAL:$1|twoją pierwszą edycję|$1 edycje|$1 edycji}} na {{PLURAL:$1|stronie $2|stronach $2}}.',
	'achievements-badge-your-desc-picture' => 'Za dodanie {{PLURAL:$1|twojego pierwszego obrazu|$1 obrazów}} do {{PLURAL:$1|strony|stron}}.',
	'achievements-badge-your-desc-category' => 'Za dodanie {{PLURAL:$1|twojej pierwszej strony|$1 stron}} do kategorii.',
	'achievements-badge-your-desc-blogpost' => 'Za napisanie {{PLURAL:$1|twojego pierwszego wpisu na blogu|$1 wpisów na blogu}}.',
	'achievements-badge-your-desc-blogcomment' => 'Za napisanie {{PLURAL:$1|komentarza do wpisu na blogu|komentarzy do $1 różnych wpisów na blogu}}.',
	'achievements-badge-your-desc-love' => 'Za wnoszenie wkładu do wiki codziennie przez {{PLURAL:$1|jeden dzień|$1 dni|$1 dni}}.',
	'achievements-badge-your-desc-welcome' => 'Za dołączenie do wiki.',
	'achievements-badge-your-desc-introduction' => 'Za rozwinięcie własnej strony użytkownika.',
	'achievements-badge-your-desc-sayhi' => 'Za zostawienie wiadomości na czyjejś stronie dyskusji.',
	'achievements-badge-your-desc-creator' => 'Za utworzenie wiki.',
	'achievements-badge-your-desc-pounce' => 'Za dokonanie edycji w 100 artykułach w ciągu godziny od ich utworzenia.',
	'achievements-badge-your-desc-caffeinated' => 'Za dokonanie 100 edycji w artykułach w ciągu jednego dnia.',
	'achievements-badge-your-desc-luckyedit' => 'Za dokonanie szczęśliwej edycji nr $1 na wiki.',
	'achievements-badge-desc-sharing' => '{{#ifeq:$1|0|Za podzielenie się linkiem|Za zachęcenie {{PLURAL:$1|jednej osoby|$1 osób}} do kliknięcia na udostępniony link}}',
	'achievements-badge-desc-edit' => 'Za dokonanie $1 edycji w {{PLURAL:$1|artykule|artykułach}}.',
	'achievements-badge-desc-edit-plus-category' => 'Za dokonanie $1 edycji na {{PLURAL:$1|stronie $2|stronach $2}}.',
	'achievements-badge-desc-picture' => 'Za dodanie $1 {{PLURAL:$1|obrazu|obrazów}} do {{PLURAL:$1|artykułu|artykułów}}.',
	'achievements-badge-desc-category' => 'Za dodanie $1 {{PLURAL:$1|artykułu|artykułów}} do kategorii.',
	'achievements-badge-desc-blogpost' => 'Za napisanie $1 {{PLURAL:$1|wpisu na blogu|wpisów na blogu}}.',
	'achievements-badge-desc-blogcomment' => 'Za skomentowanie {{PLURAL:$1|wpisu na blogu|$1 różnych wpisów na blogach}}.',
	'achievements-badge-desc-love' => 'Za wnoszenie wkładu do wiki codziennie przez {{PLURAL:$1|jeden dzień|$1 dni|$1 dni}}.',
	'achievements-badge-desc-welcome' => 'Za dołączenie do wiki.',
	'achievements-badge-desc-introduction' => 'Za dodanie własnej strony użytkownika.',
	'achievements-badge-desc-sayhi' => 'Za pozostawienie wiadomości na czyjejś stronie dyskusji.',
	'achievements-badge-desc-creator' => 'Za stworzenie wiki.',
	'achievements-badge-desc-pounce' => 'Za dokonanie edycji w 100 artykułach w ciągu godziny od ich utworzenia.',
	'achievements-badge-desc-caffeinated' => 'Za dokonanie 100 edycji w artykułach w ciągu jednego dnia.',
	'achievements-badge-desc-luckyedit' => 'Za dokonanie szczęśliwej edycji nr $1 na wiki.',
	'achievements-userprofile-title-no' => 'Odznaczenia $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Odznczenie|Odznaczenia}} $1 ($2)',
	'achievements-userprofile-no-badges-owner' => 'Zobacz poniższą listę, aby dowiedzieć się jakie odznaczenia można zdobyć na tej wiki.',
	'achievements-userprofile-no-badges-visitor' => 'Ten użytkownik nie zdobył jeszcze żadnego odznaczenia.',
	'achievements-userprofile-profile-score' => '<em>$1</em> Punktów<br />',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Miejsce #$1]]<br />na tej wiki',
	'action-platinum' => 'twórz i edytuj platynowe odznaczenia',
	'achievements-next-oasis' => 'Następna',
	'achievements-prev-oasis' => 'Poprzednia',
	'right-achievements-exempt' => 'Użytkownik nie może zdobywać punktów za odznaczenia',
	'right-achievements-explicit' => 'Użytkownik może zdobywać punkty za odznaczenia (nadpisuje uprawnienie uniemożliwiające)',
);

$messages['pms'] = array(
	'achievementsii-desc' => "Un sistema ëd distintiv dle realisassion për j'utent ëd la wiki",
	'achievements-upload-error' => "Darmagi!
Sta figura a marcia pa.
Ch'as sigura ch'a sia n'archivi .jpg o .png.
Se a marcia anco' pa, antlora la figura a peul esse tròp gròssa.
Për piasì, ch'a preuva con n'àutra!",
	'achievements-upload-not-allowed' => "J'aministrator a peulo cangé ij nòm e le figure dij distintiv dij Sucess an visitand la pàgina [[Special:AchievementsCustomize|ëd Përsonalisassion dij sucess]].",
	'achievements-non-existing-category' => 'La categorìa specificà a esist pa.',
	'achievements-edit-plus-category-track-exists' => 'La categorìa specificà a l\'ha già na <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Andé a la dësfida">dësfida associà</a>.',
	'achievements-no-stub-category' => "Për piasì, ch'a crea pa ëd dësfide për jë sbòss.",
	'right-platinum' => 'Creé e modifiché ël distintiv ëd plàtin',
	'right-sponsored-achievements' => "Gestì j'obietiv sponsorisà",
	'achievements-platinum' => 'Plàtin',
	'achievements-gold' => 'Òr',
	'achievements-silver' => 'Argent',
	'achievements-bronze' => 'Bronz',
	'achievements-gold-points' => '100<br />pont',
	'achievements-silver-points' => '50<br />pont',
	'achievements-bronze-points' => '10<br />pont',
	'achievements-you-must' => 'A dev $1 për vagné sto distintiv.',
	'leaderboard-button' => 'Tàula dij sucess',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|pont|pont}}</small>',
	'achievements-profile-title-no' => 'distintiv ëd $1',
	'achievements-no-badges' => "Contròla la lista sota për vëdde ij distintiv ch'it peule anco' vagné su sta wiki!",
	'achievements-track-name-edit' => 'Dësfida ëd modìfica',
	'achievements-track-name-picture' => 'Dësfida ëd figure',
	'achievements-track-name-category' => 'Dësfida ëd categorìa',
	'achievements-track-name-blogpost' => 'Dësfida ëd Publicassion an snë scartari',
	'achievements-track-name-blogcomment' => 'Dësfida ëd Coment ëd në scartari',
	'achievements-track-name-love' => 'Dësfida Wiki Love',
	'achievements-track-name-sharing' => 'Stòria dla condivision',
	'achievements-notification-title' => "A l'é an sla bon-a stra, $1!",
	'achievements-notification-subtitle' => 'It l\'has mach vagnà ël distintiv "$1" $2',
	'achievements-notification-link' => "<strong><big>[[Special:MyPage|Varda ij distintiv ch'it peule anco' vagné]]!</big></strong>",
	'achievements-points' => '$1 {{PLURAL:$1|pont|pont}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|pont|pont}}',
	'achievements-earned' => "Cost distintiv a l'é stàit vagnà da {{PLURAL:$1|1 utent|$1 utent}}.",
	'achievements-profile-title' => '$2 {{PLURAL:$2|distintiv|distintiv}} vagnà da $1',
	'achievements-profile-title-challenges' => "Distintiv ch'it peule anco' vagné!",
	'achievements-profile-customize' => 'Përsonalisé ij distintiv',
	'achievements-ranked' => 'Classificà al pòst $1 su sta wiki',
	'achievements-viewall' => 'Varda tut',
	'achievements-viewless' => 'Sara',
	'achievements-profile-title-oasis' => 'realisassion <br /> pont',
	'achievements-ranked-oasis' => "$1 a l'é [[Special:Leaderboard|Classificà al pòst $2]] su sta wiki",
	'achievements-viewall-oasis' => 'Varda tut',
	'achievements-toggle-hide' => 'Mostré nen ij pont, ij distintiv e la clàssifica an mia pagina ëd profil',
	'leaderboard-intro-hide' => 'stërma',
	'leaderboard-intro-open' => 'duverté',
	'leaderboard-intro-headline' => "Lòn ch'a son le Realisassion?",
	'leaderboard-intro' => "A peul vagné dij distintiv ansima a costa wiki an modificand dle pàgine, an cariand dle fòto e an lassand dij coment.
Minca distintiv a-j fa vagné dij pont - pi pont a vagna, pi àut a monta ant la classìfica!
A trovrà ij distintiv ch'a l'ha vagnà an soa [[$1|pagina ëd profil dl'utent]].

'''Lòn ch'a valo ij distintiv?'''",
	'leaderboard' => 'Tàula dle realisassion',
	'achievements-title' => 'Realisassion',
	'leaderboard-title' => 'Classìfica',
	'achievements-recent-earned-badges' => 'Distintiv vagnà ëd recent',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />vagnà da <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'vagnà ël <strong><a href="$3" class="badgeName">$1</a></strong> distintiv<br />$2',
	'achievements-leaderboard-disclaimer' => 'La tàula a smon ij cambi da jer',
	'achievements-leaderboard-rank-label' => 'Classìfica',
	'achievements-leaderboard-member-label' => 'Mèmber',
	'achievements-leaderboard-points-label' => 'Pont',
	'achievements-leaderboard-points' => '{{PLURAL:$1|Pont|Pont}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Arseivù pi ëd recent',
	'achievements-send' => 'Salvé la figura',
	'achievements-save' => 'Salvé ij cangiament',
	'achievements-reverted' => "Distintiv butà torna a l'original.",
	'achievements-customize' => 'Përsonalisé la figura',
	'achievements-customize-new-category-track' => 'Creé na dësfida neuva për la categorìa:',
	'achievements-enable-track' => 'abilità',
	'achievements-revert' => 'Torné a lë stàndard',
	'achievements-special-saved' => 'Cambi salvà.',
	'achievements-special' => 'Realisassion speciaj',
	'achievements-secret' => 'Realisassion segrete',
	'achievementscustomize' => 'Përsonalisé ij distintiv',
	'achievements-about-title' => 'A propòsit dë sta pàgina...',
	'achievements-about-content' => "J'aministrator ëd sa wiki a peulo përsonalisé ij nòm e le figure dij distintiv dle realisassion.

A peul carié qualsëssìa figura .jpg o .png, e soa figura as rangërà automaticament andrinta al quàder.
A marcia mej quand che soa figura a l'é quadra, e quand che la part pi amportanta dla figura a l'é pròpi ant ël mes.

A peul dovré ëd figure retangolar, ma a podrìa trové che cheicòs a resta tajà fòra dal quàder.
S'a l'ha un programa gràfich, a peul ritajé soa figura për buté la part pi amportanta dla figura ant ël mes.
S'a l'ha pa un programa gràfich, antlora ch'a preuva pura con figure diferente fin ch'a treuva cola che për chiel a marcia!
S'a-j pias pa la figura ch'a l'has sërnù, ch'a sgnaca \"{{int:achievements-revert}}\" për andé andré al gràfich original.

A peul ëdcò deje ai distintiv dij nòm neuv che a arfleto l'argoment ëd la wiki.
Quand ch'a l'ha cangià ij nòm dij distintiv, ch'a sgnaca \"{{int:achievements-save}}\" për salvé ij sò cambi.
Ch'as amusa bin!",
	'achievements-edit-plus-category-track-name' => '$1 dësfida ëd modìfica',
	'achievements-create-edit-plus-category-title' => 'Creé na neuva dësfida ëd modìfica',
	'achievements-create-edit-plus-category-content' => "A peul creé un neuv ansema ëd distintiv che a premio j'utent ch'a modìfico dle pàgine ant na categorìa particolar, për valorisé na zòna particolar dël sit anté che a j'utent a podrìa piasèj-je travajeje ansima.
A peul amposté pi che na dësfida ëd categorìa, parèj ch'a preuva a serne doe categorìe ch'a podrìo giuté j'utent a mostré soe specialisassion!
Ch'a anvisca na rivalità tra j'utent ch'a modìfico le pàgine dij Vàmpir e j'utent ch'a modìfico le pàgine dij Luv mostro, o Mago e Muggles, o Autobot e Decepticon.

Për creé na neuva dësfida \"Modìfica ant la categorìa\", ch'a anserissa ël nòm dla categorìa ant ël camp sì-sota.
La dësfida ëd Modìfica regolar a esisterà anco';
sossì a creerà na dësfida separà ch'a peule përsonalisé separatament.

Quand la dësfida a l'é creà, ij distintiv neuv a compariran ant la lista an sla snista, sota la dësfida regolar ëd Modìfica.
Ch'a përsonalisa ij nòm e le figure për la neuva dësfida, an manera che j'utent a peulo vëdde la diferensa!

Na vira ch'a l'ha fàit la përsonalisassion, ch'a sgnaca la casela \"{{int:achievements-enable-track}}\" për rende ativa la neuva dësfida, e peui ch'a sgnaca \"{{int:achievements-save}}\".
J'utent a vëddran che la neuva dësfida a compariss an sò profil utent, e a ancamineran a vagné dij distintiv quand che a modìfico dle pàgine an cola categorìa.
A peule ëdcò disabilité la dësfida pi tard, s'a decid che comsëssìa a veul pa valorisé cola categorìa.
J'utent ch'a l'han vagnà dij distintiv ant la dësfida a mantniran sempe ij sò distintiv, ëdcò se la dësfida a l'é disabilità.

Sòn a peul giuté a buté n'àutr livel d'amusament për le realisassion.
Ch'a lo preuva!",
	'achievements-create-edit-plus-category' => 'Creé costa dësfida',
	'platinum' => 'Plàtin',
	'achievements-community-platinum-awarded-email-subject' => "A l'é stàit premià con un neuv distintiv ëd Plàtin!",
	'achievements-community-platinum-awarded-email-body-text' => "Congratulassion $1!

A l'é pen-a stàit premià con ël distintiv ëd Plàtin '$2' su $4 ($3).
Sòn a gionta 250 pont a sò pontegi!

Ch'a daga n'ociada a sò distintiv neuv fiamengh an sla pàgina ëd sò profil utent:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Congratulassion $1!</strong><br /><br />
A l\'é pen-a stàit premià con ël distintiv ëd Plàtin \'<strong>$2</strong>\' su <a href="$3">$4</a>.
Sòn a gionta 250 pont a sò pontegi!<br /><br />
Ch\'a daga n\'ociada a sò fiamengh distintiv neuv an soa <a href="$5">pàgina d\'utent</a>.',
	'achievements-community-platinum-awarded-for' => 'Premià për:',
	'achievements-community-platinum-how-to-earn' => 'Com vagné:',
	'achievements-community-platinum-awarded-for-example' => 'pr\'esempi "për fé..."',
	'achievements-community-platinum-how-to-earn-example' => 'pr\'esempi "fé 3 modìfiche..."',
	'achievements-community-platinum-badge-image' => 'Figura dël distintiv:',
	'achievements-community-platinum-awarded-to' => 'Dàit a:',
	'achievements-community-platinum-current-badges' => 'Distintiv corent ëd plàtin',
	'achievements-community-platinum-create-badge' => 'Creé un distintiv',
	'achievements-community-platinum-enabled' => 'abilità',
	'achievements-community-platinum-show-recents' => 'mostré ant ij distintiv recent',
	'achievements-community-platinum-edit' => 'modìfica',
	'achievements-community-platinum-save' => 'salva',
	'achievements-community-platinum-cancel' => 'scancela',
	'achievements-community-platinum-sponsored-label' => 'Obietiv sponsorisà',
	'achievements-community-platinum-sponsored-hover-content-label' => "Figura da l'àut <small>(dimension mìnima dla vista: 270px x 100px)</small>:",
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Anliura da andeje dapress për le visualisassion ëd distintiv:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Anliura da andeje dapress për le visualisassion dle viste:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Colegament dël distintiv <small>(DART click command URL)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Sgnaca për savèjne ëd pi',
	'achievements-badge-name-edit-0' => 'Fé la diferensa',
	'achievements-badge-name-edit-1' => "Mach l'Inissi",
	'achievements-badge-name-edit-2' => 'Fesse armarché',
	'achievements-badge-name-edit-3' => 'Amis ëd la Wiki',
	'achievements-badge-name-edit-4' => 'Colaborador',
	'achievements-badge-name-edit-5' => 'Costrutor ëd Wiki',
	'achievements-badge-name-edit-6' => 'Cap ëd Wiki',
	'achievements-badge-name-edit-7' => 'Espert ëd Wiki',
	'achievements-badge-name-picture-0' => 'Istantania',
	'achievements-badge-name-picture-1' => 'Paparass',
	'achievements-badge-name-picture-2' => 'Ilustrador',
	'achievements-badge-name-picture-3' => 'Colessionista',
	'achievements-badge-name-picture-4' => "Amant ëd l'Art",
	'achievements-badge-name-picture-5' => 'Decorador',
	'achievements-badge-name-picture-6' => 'Progetista',
	'achievements-badge-name-picture-7' => 'Conservador',
	'achievements-badge-name-category-0' => 'Fà na Conession',
	'achievements-badge-name-category-1' => 'Marcador ëd senté',
	'achievements-badge-name-category-2' => 'Esplorador',
	'achievements-badge-name-category-3' => 'Guida torìstica',
	'achievements-badge-name-category-4' => 'Navigador',
	'achievements-badge-name-category-5' => 'Costrutor ëd Pont',
	'achievements-badge-name-category-6' => 'Pianificador ëd Wiki',
	'achievements-badge-name-blogpost-0' => 'Quaicòs da dì',
	'achievements-badge-name-blogpost-1' => 'Sinch Ròbe da dì',
	'achievements-badge-name-blogpost-2' => 'Fera ëd discussion',
	'achievements-badge-name-blogpost-3' => 'Vita dël partì',
	'achievements-badge-name-blogpost-4' => 'Conferensié',
	'achievements-badge-name-blogcomment-0' => 'Opinionista',
	'achievements-badge-name-blogcomment-1' => 'E ancor na ròba',
	'achievements-badge-name-love-0' => 'Ciav për la Wiki!',
	'achievements-badge-name-love-1' => 'Doe sman-e an sla wiki',
	'achievements-badge-name-love-2' => 'Dedicà',
	'achievements-badge-name-love-3' => 'Angagià',
	'achievements-badge-name-love-4' => 'Dipendent',
	'achievements-badge-name-love-5' => 'Na vita ëd Wiki',
	'achievements-badge-name-love-6' => 'Eròe dla Wiki',
	'achievements-badge-name-sharing-0' => 'Partagiator',
	'achievements-badge-name-sharing-1' => 'Pòrtlo andré',
	'achievements-badge-name-sharing-2' => 'Orator',
	'achievements-badge-name-sharing-3' => 'Nonsi',
	'achievements-badge-name-sharing-4' => 'Evangelista',
	'achievements-badge-name-welcome' => 'Bin ëvnù an sla Wiki',
	'achievements-badge-name-introduction' => 'Antrodussion',
	'achievements-badge-name-sayhi' => 'Passà a dì cerea',
	'achievements-badge-name-creator' => 'Ël Creador',
	'achievements-badge-name-pounce' => 'Partensa!',
	'achievements-badge-name-caffeinated' => 'Pien ëd cafein-a',
	'achievements-badge-name-luckyedit' => 'Modìfica fortunà',
	'achievements-badge-to-get-edit' => 'fà $1 {{PLURAL:$1|modìfica|modìfiche}} su {{PLURAL:$1|na pàgina|pàgine}}',
	'achievements-badge-to-get-edit-plus-category' => 'fà $1 {{PLURAL:$1|na modìfica|$1 modìfiche}} su {{PLURAL:$1|na $2 pàgina|$2 pàgine}}',
	'achievements-badge-to-get-picture' => 'gionté $1 {{PLURAL:$1|plancia|plance}} a {{PLURAL:$1|na pàgina|pàgine}}',
	'achievements-badge-to-get-category' => 'gionta $1 {{PLURAL:$1|pàgina|pàgine}} a {{PLURAL:$1|na categorìa|categorìe}}',
	'achievements-badge-to-get-blogpost' => 'scrive $1 {{PLURAL:$1|mëssagi dë scartari|mëssagi dë scartari}}',
	'achievements-badge-to-get-blogcomment' => 'scrive un coment su {{PLURAL:$1|un mëssagi dë scartari|$1 mëssagi diferent dë scartari}}',
	'achievements-badge-to-get-love' => 'contribuì a la wiki tuti ij di për {{PLURAL:$1|un di|$1 di}}',
	'achievements-badge-to-get-welcome' => 'unisste a la wiki',
	'achievements-badge-to-get-introduction' => 'gionta a toa pàgina utent',
	'achievements-badge-to-get-sayhi' => 'lassa a quaidun un mëssagi su soa pàgina ëd discussion',
	'achievements-badge-to-get-creator' => 'esse ël creador dë sta wiki',
	'achievements-badge-to-get-pounce' => 'esse lest',
	'achievements-badge-to-get-caffeinated' => 'fé {{PLURAL:$1|na modìfica|$1 modìfiche}} an sle pàgine ant di sol',
	'achievements-badge-to-get-luckyedit' => 'esse fortunà',
	'achievements-badge-to-get-edit-details' => "A-i manca quaicòs?
A-i é n'eror?
Ch'a sia pa tìmid.
Ch'a sgnaca ël boton \"{{int:edit}}\" e a peul amelioré qualsëssìa pàgina!",
	'achievements-badge-to-get-edit-plus-category-details' => 'La pàgina <strong>$1</strong> a l\'ha dabzògn ëd sò agiut!
Ch\'a sgnaca ël boton "{{int:edit}}" su qualsëssìa pàgina an cola categorìa për giuté.
Ch\'a mostra sò sostegn a le pàgina $1!',
	'achievements-badge-to-get-picture-details' => 'Ch\'a sgnaca ël boton "{{int:edit}}", e peui ël boton "{{int:rte-ck-image-add}}".
A peul gionté na fòto da tò ordinator, o da n\'àutra pàgina ëd la wiki.',
	'achievements-badge-to-get-category-details' => 'Le categorìe a son dle tichëtte che a giuto ij letor a trové dle pàgine ch\'a së smijo.
Ch\'a sgnaca ël boton "{{int:categoryselect-addcategory-button}}" an cò dla pàgina për listé cola pàgina ant na categorìa.',
	'achievements-badge-to-get-blogpost-details' => 'Ch\'a scriva soe opinion e chestion!
Ch\'a sgnaca su "{{int:blogs-recent-url-text}}" ant la bara lateral, e peui an sl\'anliura a snista për "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => "Ch'a gionta ij sò doi sòld!
Ch'a un mëssagi recent ëd lë scartari, e ch'a scriva lòn ch'a pensa ant la casela dij coment.",
	'achievements-badge-to-get-love-details' => "Ël conteur a part da zero s'it perde un di, parèj sigurte ëd torné a la wiki minca di!",
	'achievements-badge-to-get-welcome-details' => 'Ch\'a sgnaca ël boton "{{int:oasis-signup}}" an àut a drita për gionz-se a la comunità.
A peul ancaminé a vagné ij sò distintiv!',
	'achievements-badge-to-get-introduction-details' => "Soa pàgina utent a l'é veuida?
Ch'a sgnaca su sò stranòm an cò dlë scren për vëdde.
Ch'a sgnaca \"{{int:edit}}\" për gionté chèiche anformassion ëd chiel!",
	'achievements-badge-to-get-sayhi-details' => "A peul lassé dij mëssagi a j'àutri utent an sgnacand \"{{int:tooltip-ca-addsection}}\" an soa pàgina ëd ciaciarade.
Ch'a ciama agiut, ch'a-j aringrassie për sò travaj, o ch'a-j disa bele mach cerea!",
	'achievements-badge-to-get-creator-details' => "Cost distintiv a l'é dàit a la përson-a che a l'ha fondà la wiki.
Ch'a sgnaca ël boton \"{{int:createwiki}}\" an àut për ancaminé un sit a propòsit ëd lòn ch'a-j pias ëd pi!",
	'achievements-badge-to-get-pounce-details' => "A dev esse lest për vagné cost distintiv-sì.
Ch'a sgnaca ël boton «{{int:activityfeed}}» për vëdde le pàgine neuve che j'utent a creo!",
	'achievements-badge-to-get-caffeinated-details' => 'A-i va un di complet për vagné sto distintiv.
Continua a modifiché!',
	'achievements-badge-to-get-luckyedit-details' => "A dev avèj dël cavicc për vagné sto distitiv.
Ch'a continua a modifiché!",
	'achievements-badge-to-get-community-platinum-details' => "Cost-sì a l'é un distintiv special ëd Plàtin che a l'é mach disponìbil për un temp limità!",
	'achievements-badge-hover-desc-edit' => 'për avèj fàit $1 {{PLURAL:$1|modìfica|modìfiche}}<br />
su {{PLURAL:$1|na pàgina|dle pàgine}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'për avèj fàit $1 {{PLURAL:$1|modìfica|modìfiche}}<br />
su {{PLURAL:$1|na pàgina ëd $2|dle pàgine ëd $2}}!',
	'achievements-badge-hover-desc-picture' => 'për avèj giontà $1 {{PLURAL:$1|figura|figure}}<br />
su {{PLURAL:$1|na pàgina|dle pàgine}}!',
	'achievements-badge-hover-desc-category' => 'për avèj giontà $1 {{PLURAL:$1|pàgina|pàgine}}<br />
a {{PLURAL:$1|na categorìa|dle categorìe}}!',
	'achievements-badge-hover-desc-blogpost' => 'për avèj scrivù $1 {{PLURAL:$1|artìcol dë scartari|artìcoj dë scartari}}!',
	'achievements-badge-hover-desc-blogcomment' => 'për avèj scrivù un coment<br />
su $1 diferent {{PLURAL:$1|artìcol dë scartari|artìcoj dë scartari}}!',
	'achievements-badge-hover-desc-love' => 'për avèj contribuì a la wiki tuti ij di për {{PLURAL:$1|un di|$1 di}}!',
	'achievements-badge-hover-desc-welcome' => 'për esse gionzusse a la wiki!',
	'achievements-badge-hover-desc-introduction' => 'për avèj anrichì<br />
soa pàgina utent!',
	'achievements-badge-hover-desc-sayhi' => 'për avèj lassà un mëssagi<br />
an sla pàgina ëd discussion ëd quaidun!',
	'achievements-badge-hover-desc-creator' => 'për avèj creà la wiki!',
	'achievements-badge-hover-desc-pounce' => "për avèj fàit ëd modìfiche su 100 pàgine ant n'ora da la creassion dla pàgina!",
	'achievements-badge-hover-desc-caffeinated' => 'për avèj fàit 100 modìfiche a dle pàgine ant un di sol!',
	'achievements-badge-hover-desc-luckyedit' => 'për avèj fàit la Modìfica Fortunà nùmer $1 an sla wiki!',
	'achievements-badge-hover-desc-community-platinum' => "Sossì a l'é un distintiv special ëd Plàtin che a l'é mach disponìbil për un temp limità!",
	'achievements-badge-your-desc-edit' => 'për avèj fàit {{PLURAL:$1|soa prima modìfica|$1 modìfiche}} su {{PLURAL:$1|na pàgina|dle pàgine}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'për avèj fàit {{PLURAL:$1|soa prima modìfica|$1 modìfiche}} su {{PLURAL:$1|na pàgina ëd $2|dle pàgine ëd $2}}!',
	'achievements-badge-your-desc-picture' => 'për avèj giontà {{PLURAL:$1|soa prima figura|$1 figure}} su {{PLURAL:$1|na pàgina|dle pàgine}}!',
	'achievements-badge-your-desc-category' => 'për avèj giontà {{PLURAL:$1|soa prima pàgina|$1 pàgine}} a {{PLURAL:$1|na categorìa|dle categorìe}}!',
	'achievements-badge-your-desc-blogpost' => 'për avèj scrivù {{PLURAL:$1|sò prim artìcol dë scartari|$1 artìcoj dë scartari}}!',
	'achievements-badge-your-desc-blogcomment' => "për avèj scrivù un coment a {{PLURAL:$1|n'artìcol dë scartari|$1 artìcoj dë scartari diferent}}!",
	'achievements-badge-your-desc-love' => 'për avèj contribuì a la wiki tuti ij di për {{PLURAL:$1|un di|$1 di}}!',
	'achievements-badge-your-desc-welcome' => 'për ess-se unisse la wiki!',
	'achievements-badge-your-desc-introduction' => 'për avèj anrichì soa pàgina utent!',
	'achievements-badge-your-desc-sayhi' => 'për avèj lassà un mëssagi an sla pàgina ëd discussion ëd quaidun!',
	'achievements-badge-your-desc-creator' => 'për avèj creà la wiki!',
	'achievements-badge-your-desc-pounce' => "Për avèj fàit ëd modìfiche su 100 pàgine ant n'ora da soa creassion!",
	'achievements-badge-your-desc-caffeinated' => 'për avèj fàit 100 modìfiche su dle pàgine ant un di sol!',
	'achievements-badge-your-desc-luckyedit' => 'për avèj fàit la modìfica Fortunà nùmer $1 an sla wiki!',
	'achievements-badge-desc-edit' => 'për avèj fàit $1 {{PLURAL:$1|modìfica|modìfiche}} su {{PLURAL:$1|na pàgina|dle pàgine}}!',
	'achievements-badge-desc-edit-plus-category' => 'për avèj fàit $1 {{PLURAL:$1|modìfica|modìfiche}} su {{PLURAL:$1|na pàgina ëd $2|dle pàgine ëd $2}}!',
	'achievements-badge-desc-picture' => 'për avèj giontà $1 {{PLURAL:$1|figura|figure}} su {{PLURAL:$1|na pàgina|dle pàgine}}!',
	'achievements-badge-desc-category' => 'për avèj giontà $1 {{PLURAL:$1|pàgina|pàgine}} a {{PLURAL:$1|na categorìa|dle categorìe}}!',
	'achievements-badge-desc-blogpost' => 'për avèj scrivù $1 {{PLURAL:$1|artìcol dë scartari|artìcoj dë scartari}}!',
	'achievements-badge-desc-blogcomment' => "për avèj scrivù un coment su {{PLURAL:$1|n'artìcol dë scartari|$1 artìcoj dë scartari diferent}}!",
	'achievements-badge-desc-love' => 'për avèj contribuì a la wiki minca di për {{PLURAL:$1|un di|$1 di}}!',
	'achievements-badge-desc-welcome' => 'për ess-se giontasse a la wiki!',
	'achievements-badge-desc-introduction' => 'për avèj anrichì soa pàgina utent!',
	'achievements-badge-desc-sayhi' => 'për avèj lassà un mëssagi an sla pàgina ëd discussion ëd quaidun!',
	'achievements-badge-desc-creator' => 'për avèj creà la wiki!',
	'achievements-badge-desc-pounce' => "Për avèj fàit dle modìfiche su 100 pàgine ant n'ora da soa creassion!",
	'achievements-badge-desc-caffeinated' => 'për avèj fàit 100 modìfiche su dle pàgine ant un di sol!',
	'achievements-badge-desc-luckyedit' => 'për avèj fàit la modìfica Fortunà nùmer $1 an sla wiki!',
);

$messages['ps'] = array(
	'achievements-platinum' => 'پلاټېنيم',
	'achievements-gold' => 'سره زر',
	'achievements-silver' => 'سپين زر',
	'achievements-bronze' => 'ژېړ',
	'achievements-viewall' => 'ټول کتل',
	'achievements-viewless' => 'تړل',
	'achievements-viewall-oasis' => 'ټول کتل',
	'leaderboard-intro-hide' => 'پټول',
	'leaderboard-intro-open' => 'پرانيستل',
	'achievements-title' => 'لاسته راوړنې',
	'achievements-leaderboard-member-label' => 'غړی',
	'achievements-send' => 'انځور خوندي کول',
	'achievements-save' => 'بدلونونه خوندي کول',
	'achievements-about-title' => 'د دې مخ په اړه ...',
	'platinum' => 'پلاټېنيم',
	'achievements-community-platinum-edit' => 'سمول',
	'achievements-community-platinum-save' => 'خوندي کول',
	'achievements-community-platinum-cancel' => 'ناګارل',
	'achievements-badge-name-edit-3' => 'د ويکي ملګری',
	'achievements-badge-name-edit-5' => 'ويکي جوړونکی',
	'achievements-badge-name-edit-6' => 'ويکي لارښوونکی',
	'achievements-badge-name-edit-7' => 'ويکي کارپوه',
	'achievements-badge-name-picture-0' => 'انځور',
	'achievements-badge-name-picture-3' => 'غونډونکی',
	'achievements-badge-name-picture-4' => 'هنر ميين',
	'achievements-badge-name-picture-6' => 'سکښتګر',
	'achievements-badge-name-blogcomment-1' => 'او يو بل څه',
	'achievements-badge-name-love-5' => 'يو ويکي ژوند',
	'achievements-badge-name-love-6' => 'ويکي اتل!',
	'achievements-badge-name-sharing-2' => 'وييونکي',
	'achievements-badge-name-sharing-3' => 'وياند',
	'achievements-badge-name-sharing-4' => 'واعظ',
	'achievements-badge-name-welcome' => 'ويکي ته ښه راغلاست',
	'achievements-badge-name-introduction' => 'پېژندنه',
	'achievements-badge-name-creator' => 'جوړونکی',
	'achievements-badge-to-get-welcome' => 'ويکي سره يوځای کېدل',
	'achievements-badge-to-get-introduction' => 'خپل کارن مخ ته يې ګډول',
	'achievements-badge-to-get-pounce' => 'چټک اوسه',
	'achievements-badge-your-desc-creator' => 'د ويکي جوړولو لپاره ورکړ شوی!',
);

$messages['pt'] = array(
	'achievementsii-desc' => 'Um sistema de recompensa através de medalhas para os usuários da wiki',
	'achievements-upload-error' => 'Desculpe!
Essa imagem não funciona.
Certifique-se de que se trata de um arquivo .jpg ou .png.
Se ainda assim não funcionar, pode ser que a imagem seja grande demais.
Por favor, tente usar outra imagem!',
	'achievements-upload-not-allowed' => 'Os administradores podem trocar os nomes e imagens das medalhas visitando a página de [[Special:AchievementsCustomize|customização]].',
	'achievements-non-existing-category' => 'A categoria especificada não existe.',
	'achievements-edit-plus-category-track-exists' => 'A categoria especificada já possui um <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">caminho associado</a>.',
	'achievements-no-stub-category' => 'Por favor, não crie trajetos para esboços.',
	'right-platinum' => 'Crie e edite medalhas de platina',
	'right-sponsored-achievements' => 'Administrar conquistas patrocinadas',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Ouro',
	'achievements-silver' => 'Prata',
	'achievements-bronze' => 'Bronze',
	'achievements-gold-points' => '100<br />pts',
	'achievements-silver-points' => '50<br />pts',
	'achievements-bronze-points' => '10<br />pts',
	'achievements-you-must' => 'Para ganhar essa medalha você deve $1.',
	'leaderboard-button' => 'Tabela de liderança',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|ponto|pontos}}</small>',
	'achievements-profile-title-no' => '{{PLURAL:$2|A medalha|As medalhas}} de $1',
	'achievements-no-badges' => 'Dê uma olhada na lista abaixo para ver as medalhas que você pode ganhar nesta wiki!',
	'achievements-track-name-edit' => 'Caminho de edição',
	'achievements-track-name-picture' => 'Caminho de Imagens',
	'achievements-track-name-category' => 'Trajeto de categorias',
	'achievements-track-name-blogpost' => 'Trajeto de posts de blog',
	'achievements-track-name-blogcomment' => 'Trajeto de comentários de blogs',
	'achievements-track-name-love' => 'Trajeto da paixão pela wikia',
	'achievements-track-name-sharing' => 'Trajeto de compartilhamento',
	'achievements-notification-title' => 'É isso aí, $1!',
	'achievements-notification-subtitle' => 'Você acaba de ganhar a medalha <strong>"$1"</strong>, $2',
	'achievements-notification-link' => "'''<big>[[Special:MyPage|Clique aqui para ver mais medalhas que você pode ganhar]]!</big>'''",
	'achievements-points' => '$1 {{PLURAL:$1|ponto|pontos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|ponto|pontos}}',
	'achievements-earned' => '{{#ifeq: $1|0|Esta medalha não foi recebida por nenhum editor ainda.|Esta medalha foi recebida por {{PLURAL:$1|apenas 1 editor|$1 editores}}.}}',
	'achievements-profile-title' => '{{PLURAL:$2|A medalha ganha|As $2 medalhas ganhas}} por $1',
	'achievements-profile-title-challenges' => 'Mais medalhas que você pode ganhar!',
	'achievements-profile-customize' => 'Personalizar medalhas',
	'achievements-ranked' => 'Posição #$1 nesta wiki',
	'achievements-viewall' => 'Ver todos',
	'achievements-viewless' => 'Fechar',
	'achievements-profile-title-oasis' => 'pontos <br /> obtidos',
	'achievements-ranked-oasis' => '$1 está na [[Special:Leaderboard|posição #$2]] nesta wiki',
	'achievements-viewall-oasis' => 'Ver tudo',
	'achievements-toggle-hide' => 'Esconder de todos as minhas conquistas no meu perfil 
',
	'leaderboard-intro-hide' => 'ocultar',
	'leaderboard-intro-open' => 'mostrar',
	'leaderboard-intro-headline' => 'O que são as Medalhas?',
	'leaderboard-intro' => "Você pode ganhar medalhas nesta wiki ao editar páginas, ao fazer upload de imagens e deixar comentários. Você ganha pontos com cada medalha - quanto mais pontos obtiver, melhor será sua colocação na tabela de liderança! Encontre a lista das medalhas já obtidas na página [[$1|perfil de usuário]].

'''Quanto valem as medalhas?'''",
	'leaderboard' => 'Tabela de liderança',
	'achievements-title' => 'Conquistas',
	'leaderboard-title' => 'Tabela de liderança',
	'achievements-recent-earned-badges' => 'Medalhas recebidas recentemente',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />recebida por <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'ganhou a medalha <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'A tabela de liderança mostra as mudanças desde ontem',
	'achievements-leaderboard-rank-label' => 'Posição',
	'achievements-leaderboard-member-label' => 'Membro',
	'achievements-leaderboard-points-label' => 'Pontos',
	'achievements-leaderboard-points' => '{{PLURAL:$1|ponto|pontos}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Ganhas mais recentemente',
	'achievements-send' => 'Salvar imagem',
	'achievements-save' => 'Salvar alterações',
	'achievements-reverted' => 'Medalha revertida para a original.',
	'achievements-customize' => 'Personalizar imagem',
	'achievements-customize-new-category-track' => 'Criar um trajeto para a categoria:',
	'achievements-enable-track' => 'ativado',
	'achievements-revert' => 'Reverter para o padrão',
	'achievements-special-saved' => 'Alterações salvas.',
	'achievements-special' => 'Medalhas especiais',
	'achievements-secret' => 'Medalhas secretas',
	'achievementscustomize' => 'Personalizar medalhas',
	'achievements-about-title' => 'Sobre esta página...',
	'achievements-about-content' => 'Os administradores desta wiki podem personalizar os nomes e imagens das medalhas.

Pode fazer o upload de imagens nos formatos .jpg ou .png.
As imagens são automaticamente ajustadas ao espaço disponível.
Obtém os melhores resultados com imagens quadradas cuja parte mais importante esteja no centro.

Pode usar imagens rectangulares, mas uma parte poderá ser cortada no enquadramento.
Se tiver um editor de imagens, pode cortar a imagem de forma a que a parte mais importante fique ao centro.
Se não tem um editor de imagens, tente usar várias imagens até encontrar as melhores para aquilo que pretende!
Se não gostar da imagem que escolheu, clique "{{int:achievements-revert}}" para voltar à imagem original.

Também pode alterar os nomes das medalhas, para adaptá-los à sua wiki.
Depois de alterá-los, clique "{{int:achievements-save}}".
Divirta-se!',
	'achievements-edit-plus-category-track-name' => 'Trajeto de edição $1',
	'achievements-create-edit-plus-category-title' => 'Criar um novo trajeto de edição',
	'achievements-create-edit-plus-category-content' => 'Você pode criar um conjunto de medalhas novas para premiar os usuários pela edição das páginas de uma determinada categoria a fim de salientar uma área no site que os usuários gostarão de desenvolver.
É possível configurar mais do que um trajeto de categoria, por isso tente escolher categorias que ajudem os usuários a exibir os seus talentos!
Crie uma rivalidade entre os usuários que editam páginas sobre Vampiros e os que editam páginas sobre Lobisomens, ou Magos e Druidas, ou Autobots e Decepticons.

Para criar um trajeto de edição novo, como "Editar na categoria", insira o nome da categoria no campo abaixo.
O trajeto normal para Editar continuará a existir, mas criará um trajeto separado, que poderá ser personalizado individualmente.

Quando o trajeto é criado, as novas medalhas aparecerão na lista à esquerda, abaixo do trajeto normal Editar.
Personalize os nomes e as imagens das medalhas do novo trajeto, para que os usuários notem a diferença!

Quando terminar a personalização, clique a caixa de seleção "{{int:achievements-enable-track}}" para ativar o novo trajeto e depois clique "{{int:achievements-save}}".
Os usuários verão um novo trajeto no seu perfil de usuário e podem começar a ganhar medalhas quando editarem páginas na categoria correspondente.
O trajeto pode ser desativado mais tarde, caso você decida que já não deseja salientar a categoria correspondente.
Os usuários que já tiverem recebido medalhas nesse trajeto continuarão a ter as suas medalhas, mesmo que o mesmo seja desativado.

Isto pode ajudar a criar um nível adicional de diversão na conquista dos objectivos.
Experimente!',
	'achievements-create-edit-plus-category' => 'Criar este trajeto',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'Você ganhou uma nova medalha de platina!',
	'achievements-community-platinum-awarded-email-body-text' => "Parabéns, $1!

Você acabou de ganhar a medalha de platina '$2' em $4 ($3).
Isto acrescenta 250 pontos ao seu total!

Dê uma olhada na sua nova medalha na sua página de perfil de usuário:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Parabéns, $1!</strong><br /><br />
Você acaba de ganhar a medalha de platina \'<strong>$2</strong>\' na <a href="$3">$4</a>.
Isto acrescenta 250 pontos ao seu total!<br /><br />
Você pode ver a nova medalha na sua <a href="$5">página de perfil do usuário</a>.',
	'achievements-community-platinum-awarded-for' => 'Atribuída por:',
	'achievements-community-platinum-how-to-earn' => 'Como ganhar:',
	'achievements-community-platinum-awarded-for-example' => 'ex: "por fazer..."',
	'achievements-community-platinum-how-to-earn-example' => 'ex: "fazer 3 edições..."',
	'achievements-community-platinum-badge-image' => 'Imagem da medalha:',
	'achievements-community-platinum-awarded-to' => 'Atribuída para:',
	'achievements-community-platinum-current-badges' => 'Medalhas de platina atuais',
	'achievements-community-platinum-create-badge' => 'Criar medalha',
	'achievements-community-platinum-enabled' => 'ativado',
	'achievements-community-platinum-show-recents' => 'mostrar em medalhas recentes',
	'achievements-community-platinum-edit' => 'editar',
	'achievements-community-platinum-save' => 'salvar',
	'achievements-community-platinum-cancel' => 'cancelar',
	'achievements-community-platinum-sponsored-label' => 'Conquista patrocinada',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Imagem Hover <small>(dimensão mínima: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'URL de seguimento para impressões de medalhas:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'URL de seguimento para impressões Hover:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Link para medalha <small>(URL do comando clique DART)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Clique para mais informações',
	'achievements-badge-name-edit-0' => 'Fazendo a diferença',
	'achievements-badge-name-edit-1' => 'Apenas o começo',
	'achievements-badge-name-edit-2' => 'Deixando sua marca',
	'achievements-badge-name-edit-3' => 'Amigo da Wiki',
	'achievements-badge-name-edit-4' => 'Colaborador',
	'achievements-badge-name-edit-5' => 'Construtor da Wiki',
	'achievements-badge-name-edit-6' => 'Líder da Wiki',
	'achievements-badge-name-edit-7' => 'Perito da Wiki',
	'achievements-badge-name-picture-0' => 'Imagem',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Ilustrador',
	'achievements-badge-name-picture-3' => 'Colecionador',
	'achievements-badge-name-picture-4' => 'Amante da arte',
	'achievements-badge-name-picture-5' => 'Decorador',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Curador',
	'achievements-badge-name-category-0' => 'Faça uma conexão',
	'achievements-badge-name-category-1' => 'Pioneiro',
	'achievements-badge-name-category-2' => 'Explorador',
	'achievements-badge-name-category-3' => 'Guia turístico',
	'achievements-badge-name-category-4' => 'Navegador',
	'achievements-badge-name-category-5' => 'Construtor de pontes',
	'achievements-badge-name-category-6' => 'Planejador da Wiki',
	'achievements-badge-name-blogpost-0' => 'Algo a dizer',
	'achievements-badge-name-blogpost-1' => 'Cinco coisas a dizer',
	'achievements-badge-name-blogpost-2' => 'Programa de entrevistas',
	'achievements-badge-name-blogpost-3' => 'Alma da festa',
	'achievements-badge-name-blogpost-4' => 'Orador público',
	'achievements-badge-name-blogcomment-0' => 'Comentarista',
	'achievements-badge-name-blogcomment-1' => 'E mais uma coisa',
	'achievements-badge-name-love-0' => 'Essencial para a Wiki!',
	'achievements-badge-name-love-1' => 'Duas semanas na Wiki',
	'achievements-badge-name-love-2' => 'Devoto',
	'achievements-badge-name-love-3' => 'Dedicado',
	'achievements-badge-name-love-4' => 'Viciado',
	'achievements-badge-name-love-5' => 'Uma vida na Wiki',
	'achievements-badge-name-love-6' => 'Herói da Wiki!',
	'achievements-badge-name-sharing-0' => 'Compartilhador',
	'achievements-badge-name-sharing-1' => 'Traga de volta',
	'achievements-badge-name-sharing-2' => 'Porta-voz',
	'achievements-badge-name-sharing-3' => 'Locutor',
	'achievements-badge-name-sharing-4' => 'Evangelizador',
	'achievements-badge-name-welcome' => 'Bem-vindo(a) à Wiki',
	'achievements-badge-name-introduction' => 'Introdução',
	'achievements-badge-name-sayhi' => 'Pare para dar um oi',
	'achievements-badge-name-creator' => 'O criador',
	'achievements-badge-name-pounce' => 'Atacar!',
	'achievements-badge-name-caffeinated' => 'Com cafeína',
	'achievements-badge-name-luckyedit' => 'Edição sortuda',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|compartilhar link|conseguir que {{PLURAL:$1|uma pessoa|$1 pessoas}} clique(m) no link compartilhado}}',
	'achievements-badge-to-get-edit' => 'fazer $1 {{PLURAL:$1|edição|edições}} {{PLURAL:$1|num artigo|artigos}}',
	'achievements-badge-to-get-edit-plus-category' => 'fazer {{PLURAL:$1|uma edição|$1 edições}} no {{PLURAL:$1|$2 artigo|$2 artigos}}',
	'achievements-badge-to-get-picture' => 'acrescentar $1 {{PLURAL:$1|imagem|imagens}} a {{PLURAL:$1|um artigo|artigos}}',
	'achievements-badge-to-get-category' => 'adicionar $1 {{PLURAL:$1|artigo|artigos}} a {{PLURAL:$1|categoria|categorias}}',
	'achievements-badge-to-get-blogpost' => 'escrever $1 {{PLURAL:$1|post|posts}} ',
	'achievements-badge-to-get-blogcomment' => 'comentar sobre {{PLURAL:$1|um post|$1 posts diferentes}}',
	'achievements-badge-to-get-love' => 'colaborar na wiki {{PLURAL:$1|um dia|$1 dias}}',
	'achievements-badge-to-get-welcome' => 'juntar-se à wiki',
	'achievements-badge-to-get-introduction' => 'adicionar à sua página de usuário',
	'achievements-badge-to-get-sayhi' => 'deixar uma mensagem na página de discussão de alguém',
	'achievements-badge-to-get-creator' => 'seja o criador desta wiki',
	'achievements-badge-to-get-pounce' => 'seja rápido',
	'achievements-badge-to-get-caffeinated' => 'fazer 100 edições em artigos em um único dia',
	'achievements-badge-to-get-luckyedit' => 'tenha sorte',
	'achievements-badge-to-get-sharing-details' => 'Compartilhe links e consiga que outros os cliquem!',
	'achievements-badge-to-get-edit-details' => 'Falta alguma coisa?
Existe um erro?
Não se acanhe.
Clique no botão "{{int:edit}}" e você pode melhorar qualquer página!',
	'achievements-badge-to-get-edit-plus-category-details' => 'As páginas <strong>$1</strong> precisam da sua ajuda!
Para ajudar, clique o botão "{{int:edit}}" de qualquer página dessa categoria.
Mostre o seu apoio às páginas $1!',
	'achievements-badge-to-get-picture-details' => 'Clique o botão "{{int:edit}}" e depois o botão "{{int:rte-ck-image-add}}".
Pode acrescentar uma imagem vinda do seu computador, ou de outra página da wiki.',
	'achievements-badge-to-get-category-details' => 'As categorias são etiquetas que ajudam os leitores a encontrar páginas semelhantes.
Clique o botão "{{int:categoryselect-addcategory-button}}" ao fundo da página, para colocar uma página numa categoria.',
	'achievements-badge-to-get-blogpost-details' => 'Escreva as suas perguntas e opiniões!
Clique "{{int:blogs-recent-url-text}}" na barra lateral e depois clique à esquerda para "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Dê a sua opinião!
Leia qualquer das entradas de blog recentes e <br />escreva a sua opinião na caixa de comentários.',
	'achievements-badge-to-get-love-details' => 'O contador reinicia se você perder um dia, então visite <br />a wiki todos os dias!',
	'achievements-badge-to-get-welcome-details' => 'Clique o botão "{{int:oasis-signup}}" no canto direito superior para se juntar à comunidade. Você pode começar a ganhar as suas próprias medalhas!',
	'achievements-badge-to-get-introduction-details' => 'A sua página de usuário está vazia?
Para vê-la, clique o seu nome de usuário no topo da página.
Depois, clique "{{int:edit}}" para acrescentar informações pessoais!',
	'achievements-badge-to-get-sayhi-details' => 'Você pode deixar mensagens para outros usuários, clicando "{{int:tooltip-ca-addsection}}" na página de usuário deles. Peça ajuda, agradeça pela colaboração, ou simplesmente diga olá!',
	'achievements-badge-to-get-creator-details' => 'Esta medalha é atribuída á pessoa que fundou a wikia.
Clique o botão "{{int:createwiki}}" no topo, para criar um site sobre o tema de que mais gosta!',
	'achievements-badge-to-get-pounce-details' => 'Para ganhar esta medalha você tem de ser rápido.
Clique o botão "{{int:activityfeed}}" para ver as páginas novas que os usuários estão criando!',
	'achievements-badge-to-get-caffeinated-details' => 'Para ganhar esta medalha é preciso um dia de trabalho.
Continue a editar!',
	'achievements-badge-to-get-luckyedit-details' => 'A medalha Edição sortuda é dada ao usuário que fizer a 1000ª edição na wiki, e a cada 1000 depois disso. Para ganhar essa medalha, contribua bastante nessa wiki<br />e conte com a sorte!',
	'achievements-badge-to-get-community-platinum-details' => 'Esta é uma medalha especial de platina disponível apenas por um período limitado!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|por compartilhar um link|por conseguir que {{PLURAL:$1|uma pessoa clicasse|$1 pessoas clicassem}} nos links partilhados}}',
	'achievements-badge-hover-desc-edit' => 'Premiado por fazer $1 {{PLURAL:$1|edição|edições}}<br />
em {{PLURAL:$1|um artigo|artigos}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Premiado por fazer $1 {{PLURAL:$1|edição|edições}}<br />
a {{PLURAL:$1|a $2 artigo|$2 artigos}}!',
	'achievements-badge-hover-desc-picture' => 'Premiado por acrescentar $1 {{PLURAL:$1|imagem|imagens}}<br />
a {{PLURAL:$1|um artigo|artigos}}!',
	'achievements-badge-hover-desc-category' => 'Premiado por adicionar $1 {{PLURAL:$1|artigo|artigos}}<br /> à
{{PLURAL:$1|uma categoria |categorias}}!',
	'achievements-badge-hover-desc-blogpost' => 'Premiado por escrever $1 {{PLURAL:$1|post|posts}}!',
	'achievements-badge-hover-desc-blogcomment' => 'Premiado por escrever um comentário<br /> em
{{PLURAL:$1|post diferente|posts diferentes}}!',
	'achievements-badge-hover-desc-love' => 'Premiado por colaborar na wiki {{PLURAL:$1|um dia|$1 dias}}!',
	'achievements-badge-hover-desc-welcome' => 'Premiado por juntar-se à wiki!',
	'achievements-badge-hover-desc-introduction' => 'Premiado por adicionar <br />
sua página de usuário!',
	'achievements-badge-hover-desc-sayhi' => 'Premiado por deixar uma mensagem na<br />
página de discussão de outro usuário!',
	'achievements-badge-hover-desc-creator' => 'Premiado por criar a wiki!',
	'achievements-badge-hover-desc-pounce' => 'Premiado por fazer uma edição dentro de uma hora após a criação da página!',
	'achievements-badge-hover-desc-caffeinated' => 'Premiado por fazer 100 edições num único dia!',
	'achievements-badge-hover-desc-luckyedit' => 'Premiado por fazer a $1ª edição na wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Esta é uma medalha especial de platina, somente disponível por um período limitado!',
	'achievements-badge-your-desc-sharing' => 'Premiado {{#ifeq:$1|0|por compartilhar um link|por conseguir que {{PLURAL:$1|uma pessoa clicasse|$1 pessoas clivassem}} nos links compartilhados}}',
	'achievements-badge-your-desc-edit' => 'Premiado por fazer {{PLURAL:$1|a sua primeira edição|$1 edições}} no {{PLURAL:$1|artigo|artigos}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'Premiado por fazer {{PLURAL:$1|a sua primeira edição|$1 edições}} no {{PLURAL:$1|artigo $2|artigos $2}}!',
	'achievements-badge-your-desc-picture' => 'Premiado por adicionar {{PLURAL:$1|a sua primeira imagem|$1 imagens}} a {{PLURAL:$1|um artigo|artigos}}!',
	'achievements-badge-your-desc-category' => 'Premiado por adicionar {{PLURAL:$1|o seu primeiro artigo|$1 artigos}} a {{PLURAL:$1|uma categoria|categorias}}!',
	'achievements-badge-your-desc-blogpost' => 'Premiado por escrever {{PLURAL:$1|o seu primeiro post|$1 posts}}!',
	'achievements-badge-your-desc-blogcomment' => 'Premiado por escrever um comentário {{PLURAL:$1|num post|$1 post diferente}}!',
	'achievements-badge-your-desc-love' => 'Premiado por colaborar na wiki por {{PLURAL:$1|um dia|$1 dias}}!',
	'achievements-badge-your-desc-welcome' => 'Premiado por juntar-se à wiki!',
	'achievements-badge-your-desc-introduction' => 'Premiado por adicionar sua página de usuário!',
	'achievements-badge-your-desc-sayhi' => 'Premiado por deixar uma mensagem na página de discussão de outro usuário!',
	'achievements-badge-your-desc-creator' => 'Premiado por criar a wiki!',
	'achievements-badge-your-desc-pounce' => 'Premiado por fazer edições em 100 artigos dentro de uma hora após a criação de uma página!',
	'achievements-badge-your-desc-caffeinated' => 'Premiado por fazer 100 edições em um único dia!',
	'achievements-badge-your-desc-luckyedit' => 'Premiado por fazer a $1ª edição na wiki!',
	'achievements-badge-desc-sharing' => 'Premiado {{#ifeq:$1|0|por compartilhar um link|por conseguir que {{PLURAL:$1|uma pessoa clicasse|$1 pessoas clicassem}} nos links compartilhados}}',
	'achievements-badge-desc-edit' => 'Premiado por fazer $1 {{PLURAL:$1|edição|edições}}<br />
{{PLURAL:$1|a um artigo|artigos}}!',
	'achievements-badge-desc-edit-plus-category' => 'Premiado por fazer $1 {{PLURAL:$1|edição|edições}}<br />
a {{PLURAL:$1|a $2 artigo|$2 artigos}}!',
	'achievements-badge-desc-picture' => 'Premiado por adicionar $1 {{PLURAL:$1|imagem|imagens}} a {{PLURAL:$1|um artigo|artigos}}!',
	'achievements-badge-desc-category' => 'Premiado por adicionar $1 {{PLURAL:$1|artigo|artigos}}<br /> à
{{PLURAL:$1|uma categoria |categorias}}!',
	'achievements-badge-desc-blogpost' => 'Premiado por escrever $1 {{PLURAL:$1|post|posts}}!',
	'achievements-badge-desc-blogcomment' => 'Premiado por escrever um comentário {{PLURAL:$1|num post|$1 post diferente}}!',
	'achievements-badge-desc-love' => 'Premiado por colaborar na wiki por {{PLURAL:$1|um dia|$1 dias}}!',
	'achievements-badge-desc-welcome' => 'Premiado por juntar-se à wiki!',
	'achievements-badge-desc-introduction' => 'Premiado por adicionar informação na sua página de usuário!',
	'achievements-badge-desc-sayhi' => 'Premiado por deixar uma mensagem na página de discussão de outro usuário!',
	'achievements-badge-desc-creator' => 'Premiado por criar a wiki!',
	'achievements-badge-desc-pounce' => 'Premiado por fazer edições em 100 páginas dentro de uma hora após a criação das mesmas!',
	'achievements-badge-desc-caffeinated' => 'Premiado por fazer 100 edições de página em um único dia!',
	'achievements-badge-desc-luckyedit' => 'Premiado por fazer a $1ª edição na wiki!',
	'achievements-userprofile-title-no' => 'Medalhas recebidas por $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Medalha|Medalhas}} recebidas por $1 ($2)',
	'achievements-userprofile-no-badges-owner' => 'Veja na lista abaixo as medalhas que você pode ganhar nesta wiki!',
	'achievements-userprofile-no-badges-visitor' => 'Este usuário ainda não ganhou nenhuma medalha.',
	'achievements-userprofile-profile-score' => '<em>$1</em> Conquistas<br />',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Posição #$1]]<br />nesta wiki',
	'action-platinum' => 'Crie e edite medalhas de platina',
	'achievements-next-oasis' => 'Próximo',
	'achievements-prev-oasis' => 'Anterior',
	'right-achievements-exempt' => 'O usuário está inelegível para ganhar pontos de medalhas',
	'right-achievements-explicit' => 'O usuário está elegível para ganhar pontos de medalhas (anula a exceção)',
);

$messages['ro'] = array(
	'achievementsii-desc' => 'Un sistem de medalii pentru reușitele utilizatorilor',
	'achievements-upload-error' => 'Ne pare rău!
Această imagine nu este bună.
Asigurați-vă că fișierul are una dintre extensiile .jpg sau .png!
Dacă după aceasta în continuare nu funcționează, atunci imaginea ar putea fi prea mare.
Vă rugăm să încercați alt fișier!',
	'achievements-upload-not-allowed' => 'Administratorii pot schimba numele și imaginile medaliilor pentru reușite, vizitând pagina de [[Special:AchievementsCustomize|editare a medaliilor]].',
	'achievements-non-existing-category' => 'Nu există categoria specificată.',
	'achievements-edit-plus-category-track-exists' => 'Categoriei specificate i se ține deja <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Du-te la evidența respectivă">evidența</a>.',
	'achievements-no-stub-category' => 'Vă rugăm să nu creați evidente pentru cioturi!',
	'right-platinum' => 'Creați și editați medaliile de Platină.',
	'right-sponsored-achievements' => 'Gestionați Medaliile Sponsorizate',
	'achievements-platinum' => 'Platină',
	'achievements-gold' => 'Aur',
	'achievements-silver' => 'Argint',
	'achievements-bronze' => 'Bronz',
	'achievements-gold-points' => '100<br />pct',
	'achievements-silver-points' => '50<br />pct',
	'achievements-bronze-points' => '10<br />pct',
	'achievements-you-must' => 'Trebuie să $1 pentru a câștiga această medalie.',
	'leaderboard-button' => 'Pagina Liderilor în realizări',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punct|puncte}}</small>',
	'achievements-profile-title-no' => 'Medaliile lui $1',
	'achievements-no-badges' => 'Vedeți lista de mai jos pentru a afla care sunt medaliile pe care le puteți câștiga pe acest wiki!',
	'achievements-track-name-edit' => 'Evidența Editărilor',
	'achievements-track-name-picture' => 'Evidența Imaginilor',
	'achievements-track-name-category' => 'Evidența Categoriilor',
	'achievements-track-name-blogpost' => 'Evidența Postărilor pe Blog',
	'achievements-track-name-blogcomment' => 'Evidenţa Comentariilor pe Blog',
	'achievements-track-name-love' => 'Evidentă Dedicației pentru Wiki',
	'achievements-track-name-sharing' => 'Evidența Comunicărilor',
	'achievements-notification-title' => 'Felicitări, $1!',
	'achievements-notification-subtitle' => 'Tocmai a câștigat Medalia "$1" $2',
	'achievements-notification-link' => '<stong><big>[[Special:MyPage|Vezi mai multe medalii pe care le poți câştiga]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punct|puncte}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punct|puncte}}',
	'achievements-earned' => 'Această medalie a fost câștigata de {{PLURAL:$1|1 utilizator|$1 utilizatori}}.',
	'achievements-profile-title' => '$1 a câștigat până acum $2 {{PLURAL:$2|Medalie|Medalii}}',
	'achievements-profile-title-challenges' => 'Poți câștiga mai multe medalii!',
	'achievements-profile-customize' => 'Editați medaliile',
	'achievements-ranked' => '{{GENDER:Username|Al|A|Al}} $1-{{GENDER:Username|lea|a|lea}} pe wiki',
	'achievements-viewall' => 'Vizualizează-le pe toate',
	'achievements-viewless' => 'Închide',
	'achievements-profile-title-oasis' => 'puncte pentru <br /> realizări',
	'achievements-ranked-oasis' => '$1 este {{GENDER:$1|al|a|al}} [[Special:Leaderboard|$2]]-{{GENDER:$1|lea|a|lea}}',
	'achievements-viewall-oasis' => 'Vizualizați-le pe toate',
	'achievements-toggle-hide' => 'Ascunde realizările mele pe pagina mea de utilizator pentru toată lumea',
	'leaderboard-intro-hide' => 'ascunde',
	'leaderboard-intro-open' => 'deschide',
	'leaderboard-intro-headline' => 'Ce sunt Medaliile?',
	'leaderboard-intro' => "Puteți câștiga medalii pe acest wiki editând paginile, încărcând imagini și comentând. Orice Medalie vă aduce puncte - cu cât ai mai multe, cu atât te ridici în clasament! Puteți vedea Medaliile pe care le-ați câștigat pe [[$1|pagina dumneavoastră de utilizator]].

'''Ce îmi aduc Medaliile?'''",
	'leaderboard' => 'Pagina Liderilor în realizări',
	'achievements-title' => 'Medalii',
	'leaderboard-title' => 'Pagina Liderilor',
	'achievements-recent-earned-badges' => 'Medalii Câștigate Recent',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />Medalie câștigată de <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'a câștigat Medalia <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Pagina liderilor arată schimbările începând cu ziua de ieri.',
	'achievements-leaderboard-rank-label' => 'Poziția',
	'achievements-leaderboard-member-label' => 'Membru',
	'achievements-leaderboard-points-label' => 'Puncte',
	'achievements-leaderboard-points' => '{{PLURAL:$1|punct|puncte}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Cea mai recentă Medalie câștigată',
	'achievements-send' => 'Salvați imaginea',
	'achievements-save' => 'Salvează modificările',
	'achievements-reverted' => 'Medalia a fost readusă la forma originală.',
	'achievements-customize' => 'Editați imaginea',
	'achievements-customize-new-category-track' => 'Crează o nouă evidenţă a categoriei:',
	'achievements-enable-track' => 'activat',
	'achievements-revert' => 'Revenire la setările implicite',
	'achievements-special-saved' => 'Modificările au fost salvate.',
	'achievements-special' => 'Medalii Speciale',
	'achievements-secret' => 'Medalii Secrete',
	'achievementscustomize' => 'Editați Medaliile',
	'achievements-about-title' => 'Despre această pagină...',
	'achievements-about-content' => 'Administratorii acestui wiki pot edita numele și imaginile Medaliilor.

Puteți încărca orice fișier cu una dintre extensiile .jpg sau .png, iar imaginea va fi redimensionată automat.
Cel mai bine funcționează când imaginea este pătrată, şi când cea mai importantă parte din imagine este în mijloc.

Puteți folosi imagini dreptunghiulare, dar ar putea fi tăiate pentru a se potrivi.
Dacă dețineți un program de editare grafică, atunci puteți decupa doar partea importantă din imagine pentru a o pune în centru.
Dacă nu dețineți un astfel de program, atunci experimentați cu diferite imagini, până când o veți găsi pe cea bună.
Dacă nu vă convine rezultatul, dați click pe "{{int:achievements-revert}}" pentru a vă întoarce la imaginea originală

Puteți da un nume Medaliei, care reflectă subiectul acestui wiki.
Când ați schimbat numele Medaliei, dați click pe "{{int:achievements-save}}" pentru a vă salva modificările.
Distracție plăcută!',
	'achievements-edit-plus-category-track-name' => 'Evidență $1',
	'achievements-create-edit-plus-category-title' => 'Creați o nouă evidență a editărilor',
	'achievements-create-edit-plus-category-content' => 'Puteți crea un nou set de Medalii care premiază utilizatorii pentru editarea paginilor dintr-o anumită categorie, pentru a sublinia o anumită parte a site-ului, în care mulți utilizatori la care s-ar bucura să lucreze.
Puteți crea mai multe evidențe ale categoriilor, așa că încercați să alegeți două categorii la care utilizatorii ar putea să-și arate priceperea!
Aprindeți o rivalitate între utilizatorii care editează paginile despre Jedi și cei care editează paginile despre Sith, sau Autoboți și Decepticoni, sau Vampiri și Vârcolaci.

Pentru a crea o nouă evidență a editărilor dintr-o categorie, scrieți numele categoriei în câmpul de mai jos.
Evidența normală a Editărilor va exista în continuare;
aceasta va crea o nouă evidență pe care o veți putea edita separat.

Când evidența a fost creată, noile Medalii vor apărea în lista din stânga, sub Evidența normală a Editărilor.
Editați numele și imaginile pentru noua evidență, pentru ca utilizatorii să poată vedea diferența!

După ce ați terminat modificările, dați click pe căsuța "{{int:achievements-enable-track}}" pentru a porni noua evidență, iar apoi dați click pe "{{int:achievements-save}}".
Utilizatorii vor putea, de asemenea, să vadă noua evidență pe pagina lor de utilizator, și vor putea să câștige medaliile când vor edita paginile din acea categorie.
Puteți, de asemenea, să dezactivați evidența mai târziu, dacă decideți că nu vreți să mai subliniați acea categorie.
Utilizatorii care au câștigat Medalii în acea categorii își vor păstra Medaliile, chiar dacă evidența este dezactivată

Acest lucru poate aduce un alt nivel de amuzament pentru Medalii.
Încercați!',
	'achievements-create-edit-plus-category' => 'Creați această evidență',
	'platinum' => 'Platină',
	'achievements-community-platinum-awarded-email-subject' => 'Ai primit o nouă Medalie de Platină!',
	'achievements-community-platinum-awarded-email-body-text' => 'Felicitări, $1!

Ai fost premiat cu Medalia de Platină "$2" pe $4 ($3).
Aceasta adaugă 250 de puncte la scorul tău!

Vezi noua ta Medalie în pagina ta de utilizator:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Felicitări, $1!</strong><br /><br />
Ai primit Medalia de Platină "<strong>$2</strong>" pe <a href="$3">$4</a>.
Asta adaugă 250 de puncte la scorul tău!<br /><br />
Vezi noua ta Medalie pe <a href="$5">pagina ta de utilizator</a>.',
	'achievements-community-platinum-awarded-for' => 'Acordat pentru:',
	'achievements-community-platinum-how-to-earn' => 'Cum să câştigi:',
	'achievements-community-platinum-awarded-for-example' => 'ex: pentru a face...',
	'achievements-community-platinum-how-to-earn-example' => 'ex: editează de 3 ori',
	'achievements-community-platinum-badge-image' => 'Imaginea Medaliei:',
	'achievements-community-platinum-awarded-to' => 'Acourdat către:',
	'achievements-community-platinum-current-badges' => 'Medaliile de Platină actuale',
	'achievements-community-platinum-create-badge' => 'Crează o Medalie',
	'achievements-community-platinum-enabled' => 'activat',
	'achievements-community-platinum-show-recents' => 'arată Medaliile recente',
	'achievements-community-platinum-edit' => 'modificare',
	'achievements-community-platinum-save' => 'salvează',
	'achievements-community-platinum-cancel' => 'anulează',
	'achievements-community-platinum-sponsored-label' => 'Medalie Sponsorizată',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Imaginea <small>(dimensiune minimă: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'URL-ul pentru impresiile despre Medalie:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'URL-ul pentru impresiile despre Imagine:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Link către Medalie <small>(DART click pe URL-ul de comandă)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Dați click pentru mai multe informații',
	'achievements-badge-name-edit-0' => 'Fă Diferența!',
	'achievements-badge-name-edit-1' => 'Doar Începutul',
	'achievements-badge-name-edit-2' => 'Lasă-ţi Amprenta!',
	'achievements-badge-name-edit-3' => 'Prietenul acestui Wiki',
	'achievements-badge-name-edit-4' => 'Colaborator',
	'achievements-badge-name-edit-5' => 'Constructor al acestui Wiki',
	'achievements-badge-name-edit-6' => 'Lider al acestui Wiki',
	'achievements-badge-name-edit-7' => 'Expert al acestui Wiki',
	'achievements-badge-name-picture-0' => 'Instantaneu',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Artist',
	'achievements-badge-name-picture-3' => 'Cloecţionar',
	'achievements-badge-name-picture-4' => 'Iubitor de Artă',
	'achievements-badge-name-picture-5' => 'Decorator',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'De 500 de ori mai frumos!',
	'achievements-badge-name-category-0' => 'Realizează o conexiune',
	'achievements-badge-name-category-1' => 'Super Conector',
	'achievements-badge-name-category-2' => 'Explorator',
	'achievements-badge-name-category-3' => 'Ghid',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Constructor de Poduri',
	'achievements-badge-name-category-6' => 'Planificator',
	'achievements-badge-name-blogpost-0' => 'Ai ceva de spus?',
	'achievements-badge-name-blogpost-1' => '5 Lucruri de Spus',
	'achievements-badge-name-blogpost-2' => 'Talk Show',
	'achievements-badge-name-blogpost-3' => 'Viața unei petreceri',
	'achievements-badge-name-blogpost-4' => 'Difuzor uman',
	'achievements-badge-name-blogcomment-0' => 'Exprimă opinia',
	'achievements-badge-name-blogcomment-1' => 'Mai Spune încă Ceva',
	'achievements-badge-name-love-0' => 'Cheia acestui Wiki',
	'achievements-badge-name-love-1' => 'Două săptămâni pe Wiki',
	'achievements-badge-name-love-2' => 'Devotat',
	'achievements-badge-name-love-3' => 'Dedicat',
	'achievements-badge-name-love-4' => 'Dependent',
	'achievements-badge-name-love-5' => 'O Viaţă pentru Wiki',
	'achievements-badge-name-love-6' => 'Erou al acestui Wiki',
	'achievements-badge-name-sharing-0' => 'Împărtăşitor',
	'achievements-badge-name-sharing-1' => 'Adu-l înapoi',
	'achievements-badge-name-sharing-2' => 'Difuzor',
	'achievements-badge-name-sharing-3' => 'Crainic',
	'achievements-badge-name-sharing-4' => 'Evanghelist',
	'achievements-badge-name-welcome' => 'Bun Venit pe Wiki',
	'achievements-badge-name-introduction' => 'Introducere',
	'achievements-badge-name-sayhi' => 'Opreşte-te să Spui Bună!',
	'achievements-badge-name-creator' => 'Creator',
	'achievements-badge-name-pounce' => 'Ca o Felină',
	'achievements-badge-name-caffeinated' => 'Parcă a băut cafea!',
	'achievements-badge-name-luckyedit' => 'Editarea Norocoasă',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|legătură comunicată|adu {{PLURAL:$1|o persoană|$1 persoane}} prin legăturile comunicate}}',
	'achievements-badge-to-get-edit' => 'fă $1 {{PLURAL:$1|modificare|modificări}} pe {{PLURAL:$1|o pagină|pagini}}',
	'achievements-badge-to-get-edit-plus-category' => 'fă {{PLURAL:$1|o modificare|$1 modificări}} pe {{PLURAL:$1|o pagină $2|pagini $2}}',
	'achievements-badge-to-get-picture' => 'adaugă $1 {{PLURAL:$1|imagine|imagini}} pe {{PLURAL:$1|o pagină|pagini}}',
	'achievements-badge-to-get-category' => 'adaugă $1 {{PLURAL:$1|pagină|pagini}} la {{PLURAL:$1|o categorie|categorii}}',
	'achievements-badge-to-get-blogpost' => 'scrie $1 {{PLURAL:$1|postare pe blog|postări pe blog}}',
	'achievements-badge-to-get-blogcomment' => 'scrie un comentariu la {{PLURAL:$1|o postare pe blog|$1 postări pe blog diferite}}',
	'achievements-badge-to-get-love' => 'contribuie la wiki în fiecare zi pentru {{PLURAL:$1|o zi|$1 zile}}',
	'achievements-badge-to-get-welcome' => 'alătură-te acestui wiki',
	'achievements-badge-to-get-introduction' => 'adaugă la pagina dumneavoastră de utilizator',
	'achievements-badge-to-get-sayhi' => 'lasă un mesaj cuiva pe pagina lui/ei de discuţie',
	'achievements-badge-to-get-creator' => 'fi creatorul acestui wiki',
	'achievements-badge-to-get-pounce' => 'fi rapid',
	'achievements-badge-to-get-caffeinated' => 'fă {{PLURAL:$1|o modificare|$1 modificări}} pe pagini într-o singură zi',
	'achievements-badge-to-get-luckyedit' => 'fi norocos',
	'achievements-badge-to-get-sharing-details' => 'Comunică legături și fă-i pe ceilalți să dea click pe ele!',
	'achievements-badge-to-get-edit-details' => 'Lipsește ceva?
Este vreo greșeală?
Nu te sfii,
Dă click pe butonul "{{int:edit}}", și poți edita orice pagină!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Paginile <strong>$1</strong> au nevoie de ajutorul tău!
Dă click pe butonul "{{int:edit}}" pe orice pagină din acea categorie pentru a ajuta..
Arată-ți suportul pentru paginile $1!',
	'achievements-badge-to-get-picture-details' => 'Dă click pe butonul "{{int:edit}}", şi apoi pe butonul "{{int:rte-ck-image-add}}".
Poţi adăuga o poză de pe calculatorul tău, sau de pe altă pagină de pe wiki.',
	'achievements-badge-to-get-category-details' => 'Categoriile sunt pagini care ajută utilizatorii să găsească pagini asemănătoare.
Dați click pe butonul "{{int:categoryselect-addcategory-button}}" la sfârșitul unei pagini pentru a o adăuga într-o categorie..',
	'achievements-badge-to-get-blogpost-details' => 'Scrie opiniile şi întrebările!
Dă click pe "{{int:blogs-recent-url-text}}" în bara laterală, şi apoi pe legătura din stânga pentru "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Adaugă un comentariu!
Citește orice postare pe blog, și scrie-ți părerea în câmpul pentru comentarii.',
	'achievements-badge-to-get-love-details' => 'Cronometrul se resetează dacă ratezi o zi, aşa că asigură-te că nu pierzi niciuna!',
	'achievements-badge-to-get-welcome-details' => 'Apasă butonul „{{int:oasis-signup}}” din dreapta-sus pentru a te alătura comunității.
Poți începe să câștigi propriile medalii!',
	'achievements-badge-to-get-introduction-details' => 'Este pagina ta de utilizator goală?
Dă click pe numele tău de utilizator pentru a verifica.
Dă click pe "{{int:edit}}" pentru a adăuga câteva informaţii despre tine!',
	'achievements-badge-to-get-sayhi-details' => 'Poți lăsa mesaje altor utilizatori apăsând butonul "{{int:tooltip-ca-addsection}}" pe paginile lor de discuție.
Cere-le ajutorul, mulțumește-le pentru contribuții, sau doar spune-le bună!',
	'achievements-badge-to-get-creator-details' => 'Acestă medalie este dată celui care a creat acest wiki.
Daţi click pe butonul "{{int:createwiki}}" de la începutul acestui Wiki pentru a începe unul nou depre orice vă place!',
	'achievements-badge-to-get-pounce-details' => 'Trebuie să fii {{GENDER:Username|rapd|rapidă}} pentru a câştiga această medalie.
Dă click pe butonul "{{int:activityfeed}}" pentru a vedea paginile noi create de utilizatori!',
	'achievements-badge-to-get-caffeinated-details' => 'Va fi o zi grea pentru a primi această Medalie.
Editează!',
	'achievements-badge-to-get-luckyedit-details' => 'Trebuie să fii norocos pentru această medalie.
Editează!',
	'achievements-badge-to-get-community-platinum-details' => 'Aceasta este o Medalie de Platină specială care este valabilă doar pentru un timp limitat!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|pentru comunicarea unei legături|pentru a face {{PLURAL:$1|o persoană|$1 persoane}} să dea click pe o legătură comunicată}}',
	'achievements-badge-hover-desc-edit' => 'pentru modificarea {{PLURAL:$1|unei pagini|paginilor}}<br />
{{PLURAL:$1|o dată|de $1 ori}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'pentru modificarea a {{PLURAL:$1|unei pagini $2|a două pagini $2}}<br />
{{PLURAL:$1|o dată|de $1 ori}}!',
	'achievements-badge-hover-desc-picture' => 'pentru adăugarea a $1 {{PLURAL:$1|imagine|imagini}}<br />
la {{PLURAL:$1|o pagină|pagini}}!',
	'achievements-badge-hover-desc-category' => 'pentru adăugarea a $1 {{PLURAL:$1|pagină|pagini}}<br />
la {{PLURAL:$1|o categorie|categorii}}!',
	'achievements-badge-hover-desc-blogpost' => 'pentru scrierea a $1 {{PLURAL:$1|postare pe blog|postări pe blog}}!',
	'achievements-badge-hover-desc-blogcomment' => 'pentru scrierea unui comentariu<br />
la $1 {{PLURAL:$1| postare pe blog|postări de blog diferite}}!',
	'achievements-badge-hover-desc-love' => 'pentru contribuirea la wiki în fiecare zi pentru {{PLURAL:$1|o zi|$1 zile}}!',
	'achievements-badge-hover-desc-welcome' => 'pentru alăturarea la wiki!',
	'achievements-badge-hover-desc-introduction' => 'pentru modificarea<br />
paginii de utilizator!',
	'achievements-badge-hover-desc-sayhi' => 'pentru lăsarea unui mesaj<br />
pe pagina cuiva de discuție!',
	'achievements-badge-hover-desc-creator' => 'pentru crearea wiki-ului!',
	'achievements-badge-hover-desc-pounce' => 'pentru modificarea a 100 de pagini în timpul primei ore de la crearea paginii!',
	'achievements-badge-hover-desc-caffeinated' => 'pentru modificarea paginilor de 100 de ori într-o singură zi!',
	'achievements-badge-hover-desc-luckyedit' => 'Pentru realizarea Modificării Norocoase nr. $1!',
	'achievements-badge-hover-desc-community-platinum' => 'Aceasta este o Medalie specială de Platină, valabilă pentru un timp limitat!',
	'achievements-badge-your-desc-sharing' => '{{#ifeq:$1|0|pentru comunicarea unei legături|pentru a face {{PLURAL:$1|o persoană|$1 persoane}} să dea click pe o legătură comunicată}}',
	'achievements-badge-your-desc-edit' => 'pentru realizarea {{PLURAL:$1|primei tale modificări|a $1 modificări}} pe {{PLURAL:$1|o pagină|pagini}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'Acordat pentru realizarea {{PLURAL:$1|primei dumneavoastră modificări|a $1 modificări}} pe {{PLURAL:$1|o pagină $2|pagini $2}}!',
	'achievements-badge-your-desc-picture' => 'pentru adăugarea {{PLURAL:$1|primei tale imagini|a $1 imagini}} {{PLURAL:$1|unei pagini|paginilor}}!',
	'achievements-badge-your-desc-category' => 'Acordat pentru adăugarea {{PLURAL:$1|primei dumneavoastră pagini|a $1 pagini}} {{PLURAL:$1|unei categorii|categoriilor}}!',
	'achievements-badge-your-desc-blogpost' => 'Acordat pentru scrierea {{PLURAL:$1|primei dumneavoastră postări pe blog|a $1 postări pe blog}}!',
	'achievements-badge-your-desc-blogcomment' => 'pentru comentarea {{PLURAL:$1|unei postări pe blog|a $1 postări pe blog pe blog}}!',
	'achievements-badge-your-desc-love' => 'pentru contribuirea la wiki în fiecare zi pentru {{PLURAL:$1|o zi|$1 zile}}!',
	'achievements-badge-your-desc-welcome' => 'pentru alăturarea la wiki!',
	'achievements-badge-your-desc-introduction' => 'pentru editarea propriei tale pagini de utilizator!',
	'achievements-badge-your-desc-sayhi' => 'pentru lăsarea unui mesaj pe pagina ltcuiva de utilizator!',
	'achievements-badge-your-desc-creator' => 'Acordat pentru crearea acestui wiki!',
	'achievements-badge-your-desc-pounce' => 'pentru modificarea paginilor de 100 de ori în timpul unei ore la crearea acestora!',
	'achievements-badge-your-desc-caffeinated' => 'Acordat pentru modificarea a 100 de pagini într-o singură zi!',
	'achievements-badge-your-desc-luckyedit' => 'Pentru Modificarea Norocoasă nr. $1',
	'achievements-badge-desc-sharing' => '{{#ifeq:$1|0|pentru a face {{PLURAL:$1|o persoană|$1 persoane}} să dea click pe o legătură comunicată}}',
	'achievements-badge-desc-edit' => 'Acordat pentru realizarea {{PLURAL:$1|unei modificări|a $1 modificări}} pe {{PLURAL:$1|o pagină|pagini}}!',
	'achievements-badge-desc-edit-plus-category' => 'Acordat pentru realizarea {{PLURAL:$1|unei modificări|a $1 modificări}} pe {{PLURAL:$1|o pagină $2|pagini $2}}!',
	'achievements-badge-desc-picture' => 'Acordat pentru adăugarea {{PLURAL:$1|unei imagini|a $1 imagini}} pe {{PLURAL:$1|o pagină|pagini}}!',
	'achievements-badge-desc-category' => 'Acordat pentru adăugarea {{PLURAL:$1|unei pagini|a $1 pagini}} {{PLURAL:$1|într-o categorie|în categorii}}!',
	'achievements-badge-desc-blogpost' => 'Acordat pentru scrierea {{PLURAL:$1|unei postări pe blog|a $1 postări pe blog}}!',
	'achievements-badge-desc-blogcomment' => 'Acordat pentru comentarea {{PLURAL:$1|unei postări pe blog|a $1 diferite postări pe blog}}!',
	'achievements-badge-desc-love' => 'Acordat pentru contribuirea la wiki în fiecare zi timp de {{PLURAL:$1|o zi|$1 zile}}!',
	'achievements-badge-desc-welcome' => 'pentru alăturarea la wiki!',
	'achievements-badge-desc-introduction' => 'Acordat pentru editarea propriei dumneavoastră pagini de utilizator!',
	'achievements-badge-desc-sayhi' => 'pentru lăsarea unui mesaj pe pagina de discuție a altcuiva!',
	'achievements-badge-desc-creator' => 'Acordat pentru crearea acestui wiki!',
	'achievements-badge-desc-pounce' => 'pentru modificarea paginilor de 100 de ori în timpul unei ore la crearea acestora!',
	'achievements-badge-desc-caffeinated' => 'Acordat pentru modificarea a 100 de pagini într-o singură zi!',
	'achievements-badge-desc-luckyedit' => 'Acordat pentru realizarea modificării Norocoase nr. $1 pe acest wiki!',
	'achievements-userprofile-title-no' => 'Medaliile lui $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Medalia|Medaliile}} lui $1($2)',
	'achievements-userprofile-no-badges-owner' => 'Vedeți lista de mai jos pentru a afla care sunt medaliile pe care le puteți câștiga pe acest wiki!',
	'achievements-userprofile-no-badges-visitor' => 'Acest utilizator încă nu a câștigat nicio medalie.',
	'achievements-userprofile-profile-score' => '<em>$1</em> Puncte pentru<br />reușite',
	'achievements-userprofile-ranked' => 'Pe locul [[Special:Leaderboard|$1]]<br />pe wiki',
);

$messages['roa-tara'] = array(
	'achievements-non-existing-category' => "'A categorije specificate non g'esiste.",
	'achievements-platinum' => 'Platine',
	'achievements-gold' => 'Ore',
	'achievements-silver' => 'Argende',
	'achievements-bronze' => 'Bronze',
	'achievements-gold-points' => '100<br />punde',
	'achievements-silver-points' => '50<br />punde',
	'achievements-bronze-points' => '10<br />punde',
	'achievements-you-must' => 'Tu è abbesogne de $1 pe pigghià stu badge.',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punde|punde}}</small>',
	'achievements-viewall' => 'Vide tutte',
	'achievements-viewless' => 'Achiude',
	'achievements-viewall-oasis' => 'Vide tutte',
	'leaderboard-intro-hide' => 'scunne',
	'leaderboard-intro-open' => 'iapre',
	'achievements-leaderboard-rank-label' => 'Posizione',
	'achievements-leaderboard-member-label' => 'Membre',
	'achievements-leaderboard-points-label' => 'Punde',
	'achievements-send' => "Reggistre l'immaggine",
	'achievements-save' => 'Reggistre le cangiaminde',
	'achievements-customize' => "Personalizze l'immaggine",
	'achievements-enable-track' => 'abbilitate',
	'achievements-special-saved' => 'Cnagiaminde reggistrate.',
	'achievements-about-title' => "'Mbormaziune sus a sta pàgene...",
	'platinum' => 'Platine',
	'achievements-community-platinum-how-to-earn' => 'Cumme guadagnà:',
	'achievements-community-platinum-awarded-for-example' => 'p.e. "pe fa..."',
	'achievements-community-platinum-how-to-earn-example' => 'p.e. "fà 3 cangiaminde..."',
	'achievements-community-platinum-enabled' => 'abbilitate',
	'achievements-community-platinum-edit' => 'cange',
	'achievements-community-platinum-save' => 'reggistre',
	'achievements-community-platinum-cancel' => 'annulle',
	'achievements-badge-name-picture-2' => 'Illustratore',
	'achievements-badge-name-picture-3' => 'Collezzioniste',
	'achievements-badge-name-picture-5' => 'Decoratore',
	'achievements-badge-name-picture-7' => 'Curatore',
	'achievements-badge-name-category-0' => "Fà 'na connessione",
	'achievements-badge-name-category-2' => 'Esploratore',
	'achievements-badge-name-category-3' => 'Guide Turisteche',
	'achievements-badge-name-category-4' => 'Navigatore',
	'achievements-badge-name-blogpost-0' => 'Quacchecose da dicere',
	'achievements-badge-name-blogpost-1' => 'Cinghe Cose da dicere',
	'achievements-badge-name-blogcomment-0' => 'Opinioniste',
	'achievements-badge-name-blogcomment-1' => 'E une o cchiù cose',
	'achievements-badge-name-love-1' => "Doje sumàne sus 'a uicchi",
	'achievements-badge-name-love-2' => 'Devote',
	'achievements-badge-name-love-3' => 'Dedicate',
	'achievements-badge-name-sharing-4' => 'Evangeliste',
	'achievements-badge-name-welcome' => "Bovègne jndr'à Uicchi",
	'achievements-badge-name-introduction' => "'Ndroduzione",
);

$messages['ru'] = array(
	'achievementsii-desc' => 'Система достижений для участников вики',
	'achievements-upload-error' => 'Это изображение не подходит.
Убедитесь в том, что файл в формате .jpg или .png.
Если изображение всё равно не загружается, то, скорее всего, его размер слишком большой.
Выберите другое изображение.',
	'achievements-upload-not-allowed' => 'Администраторы могут менять изображения и названия значков достижений на служебной странице [[Special:AchievementsCustomize]].',
	'achievements-non-existing-category' => 'Указанной категории не существует.',
	'achievements-edit-plus-category-track-exists' => 'Указанной категории уже <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Перейти к треку">назначен трек</a>.',
	'achievements-no-stub-category' => 'Пожалуйста, не создавайте треки для заготовок.',
	'right-platinum' => 'Создание и редактирование платиновых значков',
	'right-sponsored-achievements' => 'Управление спонсируемыми достижениями',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Золото',
	'achievements-silver' => 'Серебро',
	'achievements-bronze' => 'Бронза',
	'achievements-gold-points' => '100<br />очков',
	'achievements-silver-points' => '50<br />очков',
	'achievements-bronze-points' => '10<br />очков',
	'achievements-you-must' => 'Вам необходимо $1, чтобы получить этот значок.',
	'leaderboard-button' => 'Лидеры по достижениям',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|очко|очка|очков}}</small>',
	'achievements-profile-title-no' => 'Значки участника $1',
	'achievements-no-badges' => 'Просмотрите список, чтобы увидеть значки, которые можно заработать на этой вики.',
	'achievements-track-name-edit' => 'Редактировать трек',
	'achievements-track-name-picture' => 'Трек изображений',
	'achievements-track-name-category' => 'Трек категории',
	'achievements-track-name-blogpost' => 'Трек сообщения в блоге',
	'achievements-track-name-blogcomment' => 'Трек комментария в блоге',
	'achievements-track-name-love' => 'Трек любви к вики',
	'achievements-track-name-sharing' => 'Трек для «поделиться»',
	'achievements-notification-title' => 'Так держать, $1!',
	'achievements-notification-subtitle' => 'Вы заработали значок «$1» — $2',
	'achievements-notification-link' => '<big><strong>[[Special:MyPage|Посмотрите, какие ещё значки вы можете заработать]]!</strong></big>',
	'achievements-points' => '$1 {{PLURAL:$1|очко|очка|очков}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|очко|очка|очков}}',
	'achievements-earned' => 'Этот значок был заработан $1 {{PLURAL:$1|участником|участниками|участниками}}.',
	'achievements-profile-title' => '$1 заработал(а) $2 {{PLURAL:$2|значок|значка|значков}}',
	'achievements-profile-title-challenges' => 'Вы можете заработать ещё больше значков!',
	'achievements-profile-customize' => 'Настройка значков',
	'achievements-ranked' => '№$1 по очкам на этой вики',
	'achievements-viewall' => 'Просмотреть все',
	'achievements-viewless' => 'Закрыть',
	'achievements-profile-title-oasis' => 'очки <br /> достижений',
	'achievements-ranked-oasis' => '$1 [[Special:Leaderboard|занимает $2-е место]] по количеству очков на этой вики',
	'achievements-viewall-oasis' => 'Смотреть все',
	'achievements-toggle-hide' => 'Скрыть достижения в моём профиле от всех',
	'leaderboard-intro-hide' => 'свернуть',
	'leaderboard-intro-open' => 'развернуть',
	'leaderboard-intro-headline' => 'Что такое достижения?',
	'leaderboard-intro' => "Вы можете зарабатывать значки на этой вики, редактируя страницы, загружая изображения и оставляя комментарии. Каждый значок даёт очки: чем больше очков вы получите, тем выше вы будете в таблице лидеров! Значки, которые вы заработали, можно просмотреть на [[$1|вашей странице]].

	'''Как оцениваются значки?'''",
	'leaderboard' => 'Лидеры по наградам',
	'achievements-title' => 'Достижения',
	'leaderboard-title' => 'Таблица лидеров',
	'achievements-recent-earned-badges' => 'Последние заработанные значки',
	'achievements-recent-info' => '<a href="$1">$2</a> заработал(а) <strong>$3</strong><br />$4<br />$5',
	'achievements-activityfeed-info' => 'заработал(а) значок <a href="$3" class="badgeName"><strong>$1</strong></a> за <br /> $2',
	'achievements-leaderboard-disclaimer' => 'Таблица лидеров показывает изменения со вчерашнего дня',
	'achievements-leaderboard-rank-label' => 'Позиция',
	'achievements-leaderboard-member-label' => 'Участник',
	'achievements-leaderboard-points-label' => 'Очки',
	'achievements-leaderboard-points' => '{{PLURAL:$1|очко|очка|очков}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Последний полученный',
	'achievements-send' => 'Сохранить изображение',
	'achievements-save' => 'Сохранить изменения',
	'achievements-reverted' => 'Значок возвращён к исходной версии.',
	'achievements-customize' => 'Настроить изображение',
	'achievements-customize-new-category-track' => 'Создать новый трек для категории:',
	'achievements-enable-track' => 'включён',
	'achievements-revert' => 'Восстановить по умолчанию',
	'achievements-special-saved' => 'Изменения сохранены.',
	'achievements-special' => 'Особые достижения',
	'achievements-secret' => 'Тайные достижения',
	'achievementscustomize' => 'Настроить значки',
	'achievements-about-title' => 'Об этой странице...',
	'achievements-about-content' => 'Администраторы этой вики могут настраивать названия и изображения достижений.

Вы можете загрузить любую картинку в формате .jpg или .png, и она автоматически подстроится под рамку.
Лучше всего, если ваша картинка квадратная и имеет самую важную часть в середине.

Вы можете использовать прямоугольные картинки, но они будут обрезаны под размеры рамки.
Если у вас есть любой графический редактор, то вы можете обрезать картинку так, чтобы важная её часть была посередине.
Если у вас нет графических программ, то просто экспериментируйте с различными картинками, пока не найдёте ту, которая подойдёт вам.
Если вам не нравится картинка, которую вы выбрали, нажмите на «{{int:achievements-revert}}», чтобы вернуть первоначальную картинку.

Вы также можете дать значкам новые названия, которые лучше подходят теме вашей вики.
После того, как вы измените название значка, нажмите на «{{int:achievements-save}}», чтобы сохранить ваши изменения. 

Удачи!',
	'achievements-edit-plus-category-track-name' => '$1 изменил(а) трек',
	'achievements-create-edit-plus-category-title' => 'Создание нового трека',
	'achievements-create-edit-plus-category-content' => 'Вы можете создать новый набор значков, которые будут награждаться за редактирование страниц определённой категории, если она интересна участникам.
Вы можете создать сразу два трека для двух разных категорий, устроив небольшое соревнование!
Например, между участниками, которые редактируют страницы о вампирах, и участниками, редактирующими страницы об оборотнях. 

Чтобы создать новый трек, введите имя категории в поле ниже.
Стандартные треки при этом останутся без изменений;
ваши действия просто создадут отдельный трек, который также можно настроить по собственному вкусу.

Сразу после создания нового трека новые значки появятся в списке слева вместе со стандартными значками.
Настройте названия и изображения для значков нового трека, чтобы участники могли их отличить!

Как только вы завершите настройки нового трека, поставьте флажок напротив «{{int:achievements-enable-track}}», чтобы включить новый трек, а затем нажмите на кнопку «{{int:achievements-save}}».
Как только вы это сделаете, участники сразу смогут начать получать новые значки за редактирование страниц в категории нового трека.
Вы можете отключить этот трек в любое время, если решите, что правок на страницах данной категории было сделано достаточно.
При этом участники, которые заработали значки за редактирование этих страниц, не лишатся новых значков — значки останутся у них навсегда.

Новые треки могут послужить отличным инструментом для развития различных отделов вашей вики.
Попробуйте!',
	'achievements-create-edit-plus-category' => 'Создать трек',
	'platinum' => 'Платина',
	'achievements-community-platinum-awarded-email-subject' => 'Вы получили новый платиновый значок!',
	'achievements-community-platinum-awarded-email-body-text' => 'Поздравляем, $1!

Вы только что были награждены платиновым значком «$2» на $4 ($3).
Он добавит 250 очков в ваш общий счётчик!

Вы можете увидеть новый значок на вашей личной странице:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Поздравляем, $1!</strong><br /><br />
Вы только что были награждены платиновым значком «<strong>$2</strong>» на <a href="$3">$4</a>.
Он добавит 250 очков в ваш общий счётчик!<br /><br />
Вы можете увидеть новый значок на <a href="$5">вашей личной странице</a>.',
	'achievements-community-platinum-awarded-for' => 'Награждён за:',
	'achievements-community-platinum-how-to-earn' => 'Как заработать:',
	'achievements-community-platinum-awarded-for-example' => 'например, «за…»',
	'achievements-community-platinum-how-to-earn-example' => 'например, «сделать три правки…»',
	'achievements-community-platinum-badge-image' => 'Изображение значка:',
	'achievements-community-platinum-awarded-to' => 'Награждён:',
	'achievements-community-platinum-current-badges' => 'Текущие платиновые значки',
	'achievements-community-platinum-create-badge' => 'Создать значок',
	'achievements-community-platinum-enabled' => 'включён',
	'achievements-community-platinum-show-recents' => 'показать в списке последних значков',
	'achievements-community-platinum-edit' => 'править',
	'achievements-community-platinum-save' => 'сохранить',
	'achievements-community-platinum-cancel' => 'отменить',
	'achievements-community-platinum-sponsored-label' => 'Спонсируемое достижение',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Предварительный просмотр при наведении <small>(минимальный размер: 270 х 100 пикселей)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Отслеживание по показам значков:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Отслеживание по количеству наведений мыши:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Ссылка на значок <small>(URL-адрес для отслеживания количества кликов системой DART)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Кликните для получения дополнительной информации',
	'achievements-badge-name-edit-0' => 'Сделать мир лучше',
	'achievements-badge-name-edit-1' => 'Это только начало',
	'achievements-badge-name-edit-2' => 'Оставить свой след',
	'achievements-badge-name-edit-3' => 'Друг вики',
	'achievements-badge-name-edit-4' => 'Участник коллектива',
	'achievements-badge-name-edit-5' => 'Разработчик вики',
	'achievements-badge-name-edit-6' => 'Лидер вики',
	'achievements-badge-name-edit-7' => 'Эксперт вики',
	'achievements-badge-name-picture-0' => 'Кадр',
	'achievements-badge-name-picture-1' => 'Папарацци',
	'achievements-badge-name-picture-2' => 'Иллюстратор',
	'achievements-badge-name-picture-3' => 'Коллекционер',
	'achievements-badge-name-picture-4' => 'Поклонник искусства',
	'achievements-badge-name-picture-5' => 'Декоратор',
	'achievements-badge-name-picture-6' => 'Дизайнер',
	'achievements-badge-name-picture-7' => 'Куратор',
	'achievements-badge-name-category-0' => 'Найти общий язык',
	'achievements-badge-name-category-1' => 'Новатор',
	'achievements-badge-name-category-2' => 'Исследователь',
	'achievements-badge-name-category-3' => 'Экскурсовод',
	'achievements-badge-name-category-4' => 'Навигатор',
	'achievements-badge-name-category-5' => 'Налаживающий отношения',
	'achievements-badge-name-category-6' => 'Проектировщик вики',
	'achievements-badge-name-blogpost-0' => 'Есть что сказать',
	'achievements-badge-name-blogpost-1' => 'Высказать пять мыслей',
	'achievements-badge-name-blogpost-2' => 'Ток-шоу',
	'achievements-badge-name-blogpost-3' => 'Душа компании',
	'achievements-badge-name-blogpost-4' => 'Оратор',
	'achievements-badge-name-blogcomment-0' => 'Риторик',
	'achievements-badge-name-blogcomment-1' => 'А также',
	'achievements-badge-name-love-0' => 'Ключ к вики!',
	'achievements-badge-name-love-1' => 'Две недели на вики',
	'achievements-badge-name-love-2' => 'Приверженный',
	'achievements-badge-name-love-3' => 'Посвящённый',
	'achievements-badge-name-love-4' => 'Увлечённый',
	'achievements-badge-name-love-5' => 'Вики-жизнь',
	'achievements-badge-name-love-6' => 'Вики-герой!',
	'achievements-badge-name-sharing-0' => 'Не жадный',
	'achievements-badge-name-sharing-1' => 'Вернись',
	'achievements-badge-name-sharing-2' => 'Докладчик',
	'achievements-badge-name-sharing-3' => 'Диктор',
	'achievements-badge-name-sharing-4' => 'Пропагандист',
	'achievements-badge-name-welcome' => 'Добро пожаловать на вики',
	'achievements-badge-name-introduction' => 'Введение',
	'achievements-badge-name-sayhi' => 'Заглянуть на минутку',
	'achievements-badge-name-creator' => 'Создатель',
	'achievements-badge-name-pounce' => 'Бросок!',
	'achievements-badge-name-caffeinated' => 'Эффект кофеина',
	'achievements-badge-name-luckyedit' => 'Счастливая правка',
	'achievements-badge-to-get-edit' => 'сделать $1 {{PLURAL:$1|правку|правки|правок}} в {{PLURAL:$1|статье|статьях}}',
	'achievements-badge-to-get-edit-plus-category' => 'сделать {{PLURAL:$1|одну правку|$1 правки|$1 правок}} в {{PLURAL:$1|$2 статье|$2 статьях}}',
	'achievements-badge-to-get-picture' => 'добавить $1 {{PLURAL:$1|изображение|изображения|изображений}} в {{PLURAL:$1|статью|статьи}}',
	'achievements-badge-to-get-category' => 'добавить $1 {{PLURAL:$1|статью|статьи|статей}} в {{PLURAL:$1|категорию|категории}}',
	'achievements-badge-to-get-blogpost' => 'написать $1 {{PLURAL:$1|сообщение в блоге|сообщения в блоге|сообщений в блоге}}',
	'achievements-badge-to-get-blogcomment' => 'оставить комментарий к {{PLURAL:$1|блогу|$1 разным блогам}}',
	'achievements-badge-to-get-love' => 'редактируйте на вики ежедневно в течение {{PLURAL:$1|дня|$1 дней}}',
	'achievements-badge-to-get-welcome' => 'присоединиться к вики',
	'achievements-badge-to-get-introduction' => 'добавить на вашу страницу',
	'achievements-badge-to-get-sayhi' => 'оставить сообщение на их странице обсуждения',
	'achievements-badge-to-get-creator' => 'быть создателем этой вики',
	'achievements-badge-to-get-pounce' => 'быть быстрым',
	'achievements-badge-to-get-caffeinated' => 'сделать 100 правок в статьях в течение одного дня',
	'achievements-badge-to-get-luckyedit' => 'быть удачливым',
	'achievements-badge-to-get-sharing-details' => 'Поделитесь ссылками и сделайте так, чтобы ими делились другие.',
	'achievements-badge-to-get-edit-details' => 'Чего-то не хватает? Есть ошибки? Не стесняйтесь.<br />Нажмите на кнопку «{{int:edit}}»<br /> и отредактируйте страницу!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Страницам в категории «<strong>$1</strong>» нужна ваша помощь.
Кликните по кнопке «{{int:edit}}» на любой странице в категории, чтобы начать редактировать.
Помогите страницам в категории «$1»!',
	'achievements-badge-to-get-picture-details' => 'Нажмите на кнопку «{{int:edit}}», а затем на «{{int:rte-ck-image-add}}». Вы можете добавить изображение с вашего компьютера или с другой страницы на вики.',
	'achievements-badge-to-get-category-details' => 'Категории — это теги, которые помогают читателям найти похожие по теме страницы.
Нажмите на кнопку «{{Int:categoryselect-addcategory-button}}» в нижней части страницы, чтобы добавить её в категорию.',
	'achievements-badge-to-get-blogpost-details' => 'Поделитесь своими мнениями и вопросами.
Нажмите на кнопку «{{int:blogs-recent-url-text}}» в боковой панели, а затем на ссылку «{{int:create-blog-post-title}}».',
	'achievements-badge-to-get-blogcomment-details' => 'Общайтесь с другими участниками! Читайте последние сообщения в блогах и оставляйте комментарии.',
	'achievements-badge-to-get-love-details' => 'Счётчик сбрасывается, если вы пропустите один день, поэтому заходите на вики каждый день!',
	'achievements-badge-to-get-welcome-details' => 'Нажмите на кнопку «{{int:oasis-signup}}» в правом верхнем углу, чтобы присоединиться к сообществу.
Вы можете начать зарабатывать собственные значки!',
	'achievements-badge-to-get-introduction-details' => 'На вашей личной странице пусто? 
Нажмите на аватар в верхней части экрана, чтобы открыть меню и перейти к вашей странице.
Нажмите «{{int:edit}}», чтобы добавить информацию о себе.',
	'achievements-badge-to-get-sayhi-details' => 'Вы можете оставить сообщения другим пользователям, нажав на кнопку «{{int:addsection}}» на их страницах обсуждения.
Попросите их о помощи, поблагодарите их за работу или просто поздоровайтесь.',
	'achievements-badge-to-get-creator-details' => 'Этот значок выдаётся создателю вики.
Нажмите на кнопку «{{int:createwiki}}» вверху, чтобы создать вики на вашу любимую тему.',
	'achievements-badge-to-get-pounce-details' => 'Действуйте быстро, чтобы заработать этот значок.
Нажмите на кнопку «{{int:activityfeed}}», чтобы увидеть все новые страницы, которые создают участники.',
	'achievements-badge-to-get-caffeinated-details' => 'Чтобы заработать этот значок, нужно изрядно трудиться целый день.
Продолжайте в том же духе!',
	'achievements-badge-to-get-luckyedit-details' => 'Значок «Счастливая правка» выдаётся участнику, который сделал тысячную правку на вики и потом за каждую следующую тысячную правку на вики. Редактируйте на вики почаще,<br />и возможно вам повезёт ещё раз!',
	'achievements-badge-to-get-community-platinum-details' => 'Это особый платиновый значок, который доступен в течение ограниченного времени.',
	'achievements-badge-hover-desc-edit' => 'Награда за $1 {{PLURAL:$1|правку|правки|правок}}<br />в {{PLURAL:$1|статье|статьях}}.',
	'achievements-badge-hover-desc-edit-plus-category' => 'Награда за $1 {{PLURAL:$1|правку|правки|правок}}<br />в {{PLURAL:$1|статье категории «$2»|статьях категории «$2»}}.',
	'achievements-badge-hover-desc-picture' => 'Награда за добавление $1 {{PLURAL:$1|изображения|изображений}}<br />в {{PLURAL:$1|статью|статьи|статей}}.',
	'achievements-badge-hover-desc-category' => 'Награда за добавление $1 {{PLURAL:$1|статьи|статей}} <br />в {{PLURAL:$1|категорию|категории}}.',
	'achievements-badge-hover-desc-blogpost' => 'Награда за написание $1 {{PLURAL:$1|сообщения в блоге|сообщений в блоге|сообщений в блоге}}.',
	'achievements-badge-hover-desc-blogcomment' => 'Награда за комментарии<br />
к $1 {{PLURAL:$1|блогу|различным блогам}}.',
	'achievements-badge-hover-desc-love' => 'Награда за ежедневный вклад в вики в течение {{PLURAL:$1|дня|$1 дней}}.',
	'achievements-badge-hover-desc-welcome' => 'Награда за присоединение к вики.',
	'achievements-badge-hover-desc-introduction' => 'Награда за редактирование<br />вашей личной страницы.',
	'achievements-badge-hover-desc-sayhi' => 'Награда за сообщение<br />на чужой странице обсуждения.',
	'achievements-badge-hover-desc-creator' => 'Награда за создание вики.',
	'achievements-badge-hover-desc-pounce' => 'Награда за 100 правок на странице в течение часа после её создания.',
	'achievements-badge-hover-desc-caffeinated' => 'Награда за 100 правок в статьях за один день.',
	'achievements-badge-hover-desc-luckyedit' => 'Награда за счастливую правку номер $1 на вики.',
	'achievements-badge-hover-desc-community-platinum' => 'Это особый платиновый значок, который доступен в течение ограниченного времени.',
	'achievements-badge-your-desc-edit' => 'Награда за {{PLURAL:$1|первую правку|$1 правки|$1 правок}} в {{PLURAL:$1|статье|статьях}}.',
	'achievements-badge-your-desc-edit-plus-category' => 'Награда за {{PLURAL:$1|первую правку|$1 правки|$1 правок}} в {{PLURAL:$1|статье категории «$2»|статьях категории «$2»}}.',
	'achievements-badge-your-desc-picture' => 'Награда за добавление {{PLURAL:$1|первого изображения|$1 изображений}} в {{PLURAL:$1|статью|статьи}}.',
	'achievements-badge-your-desc-category' => 'Награда за добавление {{PLURAL:$1|вашей первой статьи|$1 статей}} в {{PLURAL:$1|категорию|категории}}.',
	'achievements-badge-your-desc-blogpost' => 'Награда за публикацию {{PLURAL:$1|вашего первого блога|$1 блогов}}.',
	'achievements-badge-your-desc-blogcomment' => 'Награда за комментарии к {{PLURAL:$1|блогу|$1 различным блогам}}.',
	'achievements-badge-your-desc-love' => 'Награда за ежедневный вклад в вики в течение {{PLURAL:$1|дня|$1 дней}}.',
	'achievements-badge-your-desc-welcome' => 'Награда за присоединение к вики.',
	'achievements-badge-your-desc-introduction' => 'Награда за редактирование вашей личной страницы.',
	'achievements-badge-your-desc-sayhi' => 'Награда за сообщение на чужой странице обсуждения.',
	'achievements-badge-your-desc-creator' => 'Награда за создание вики.',
	'achievements-badge-your-desc-pounce' => 'Награда за правку 100 статей в течение часа после создания страницы.',
	'achievements-badge-your-desc-caffeinated' => 'Награда за 100 правок на страницах за один день.',
	'achievements-badge-your-desc-luckyedit' => 'Награда за счастливую правку номер $1 на вики.',
	'achievements-badge-desc-edit' => 'Награда за $1 {{PLURAL:$1|правку|правки|правок}} в {{PLURAL:$1|статье|статьях}}.',
	'achievements-badge-desc-edit-plus-category' => 'Награда за $1 {{PLURAL:$1|правку|правки|правок}} в {{PLURAL:$1|статье категории «$2»|статьях категории «$2»}}.',
	'achievements-badge-desc-picture' => 'Награда за добавление $1 {{PLURAL:$1|изображения|изображений}} в {{PLURAL:$1|статью|статьи}}.',
	'achievements-badge-desc-category' => 'Награда за добавление $1 {{PLURAL:$1|статьи|статей}} в {{PLURAL:$1|категорию|категории}}.',
	'achievements-badge-desc-blogpost' => 'Награда за написание $1 {{PLURAL:$1|сообщения в блоге|сообщений в блоге|сообщений в блоге}}.',
	'achievements-badge-desc-blogcomment' => 'Награда за комментарии к {{PLURAL:$1|блогу|$1 различным блогам}}.',
	'achievements-badge-desc-love' => 'Награда за ежедневный вклад в вики в течение {{PLURAL:$1|дня|$1 дней}}.',
	'achievements-badge-desc-welcome' => 'Награда за присоединение к вики.',
	'achievements-badge-desc-introduction' => 'Награда за добавление своей собственной страницы участника!',
	'achievements-badge-desc-sayhi' => 'Награда за сообщение на чужой странице обсуждения.',
	'achievements-badge-desc-creator' => 'Награда за создание вики.',
	'achievements-badge-desc-pounce' => 'Награда за правку 100 страниц в течение часа после создания страницы.',
	'achievements-badge-desc-caffeinated' => 'Награда за 100 правок на страницах за один день.',
	'achievements-badge-desc-luckyedit' => 'Награда за счастливую правку номер $1 на вики.',
	'achievements-userprofile-title-no' => 'Заработанных участником $1 значков',
	'achievements-userprofile-title' => '$1 заработал(а) $2 {{PLURAL:$2|значок|значка|значков}}',
	'achievements-userprofile-no-badges-owner' => 'Просмотрите список, чтобы увидеть значки, которые можно заработать в этой вики!',
	'achievements-userprofile-no-badges-visitor' => 'Этот участник ещё не заработал ни одного значка.',
	'achievements-userprofile-profile-score' => '<em>$1</em>очков<br />достижений',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Занимает $1-е место]]<br />по количеству очков на вики',
	'action-platinum' => 'создание и редактирование платиновых значков',
	'achievements-next-oasis' => 'Следующие',
	'achievements-prev-oasis' => 'Предыдущие',
	'achievements-badge-to-get-sharing' => 'за то, что {{#ifeq:$1|0|вы поделились ссылкой|{{PLURAL:$1|один посетитель кликнул|$1 посетителя кликнули|$1 посетителей кликнули}} по ссылке, которой вы поделились}}',
	'achievements-badge-hover-desc-sharing' => 'за {{#ifeq:$1|0|то, что вы поделились одной ссылкой|то, что {{PLURAL:$1|один посетитель кликнул|$1 посетителя кликнули|$1 посетителей кликнули}} по ссылке, которой вы поделились}}',
	'achievements-badge-your-desc-sharing' => 'Награда за {{#ifeq:$1|0|то, что вы поделились одной ссылкой|то, что {{PLURAL:$1|один посетитель кликнул|$1 посетителя кликнули|$1 посетителей кликнули}} по ссылке, которой вы поделились}}',
	'achievements-badge-desc-sharing' => 'Награда за {{#ifeq:$1|0|то, что вы поделились одной ссылкой|то, что {{PLURAL:$1|один посетитель кликнул|$1 посетителя кликнули|$1 посетителей кликнули}} по ссылке, которой вы поделились}}',
	'right-achievements-exempt' => 'Участник не может получать очки достижений',
	'right-achievements-explicit' => 'Участник может получать очки достижений',
);

$messages['si'] = array(
	'achievements-platinum' => 'ප්ලැටිනම්',
	'achievements-gold' => 'රත්‍රන්',
	'achievements-silver' => 'රිදී',
	'achievements-bronze' => 'ලෝකඩ',
	'achievements-viewall' => 'සියල්ල නරඹන්න',
	'achievements-viewless' => 'වසන්න',
	'leaderboard-intro-hide' => 'සඟවන්න',
	'achievements-leaderboard-rank-label' => 'තනතුර',
	'achievements-leaderboard-member-label' => 'සාමාජිකයා',
	'achievements-leaderboard-points-label' => 'ලකුණු',
	'achievements-leaderboard-points' => '{{PLURAL:$1|එක් ලකුණක්|ලකුණු $1 ක්}}',
	'achievements-community-platinum-enabled' => 'බලය දෙනලදී (enabled)',
	'achievements-community-platinum-edit' => 'සංස්කරණය කරන්න',
	'achievements-community-platinum-save' => 'සුරකින්න',
	'achievements-community-platinum-cancel' => 'අත් හරින්න',
);

$messages['sl'] = array(
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Zlata',
	'achievements-silver' => 'Srebrna',
	'achievements-bronze' => 'Bronasta',
	'leaderboard-button' => 'Lestvica dosežkov',
	'achievements-profile-title-no' => 'Značke uporabnika $1.',
	'achievements-no-badges' => 'Preverite na spodnjem seznamu, katere značke lahko pridobite na tem projektu!',
	'leaderboard-intro-hide' => 'Skrij',
	'leaderboard-intro-open' => 'Odpri',
	'leaderboard-intro-headline' => 'Kaj so Dosežki?',
	'achievements-title' => 'Dosežki',
	'leaderboard-title' => 'Lestvica',
	'achievements-recent-earned-badges' => 'Nedavno pridobljene značke',
);

$messages['sq'] = array(
	'achievementsii-desc' => 'Një shenjë arritjeje e sistemit për wiki përdoruesit',
);

$messages['sr-ec'] = array(
	'achievementsii-desc' => 'Систем значки за достигнућа корисника',
	'achievements-upload-error' => 'Нажалост, та слика не ради. Проверите да ли је формата JPG или PNG.
Ако и поред тога не ради, онда је вероватно превелика. Пробајте другу.',
	'achievements-upload-not-allowed' => 'Администратори могу да мењају називе и слике значки за достигнућа на страници [[Special:AchievementsCustomize|Прилагођавање значки]].',
	'achievements-non-existing-category' => 'Наведена категорија не постоји.',
	'achievements-edit-plus-category-track-exists' => 'Наведена категорија већ има <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Иди на траку">своју траку</a>.',
	'achievements-no-stub-category' => 'Не правите траке за клице.',
	'right-platinum' => 'стварање и уређивање платинастих значака',
	'right-sponsored-achievements' => 'Управљање спонзорисаним достигнућима',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Злато',
	'achievements-silver' => 'Сребро',
	'achievements-bronze' => 'Бронза',
	'achievements-gold-points' => '100<br />бод.',
	'achievements-silver-points' => '50<br />бод.',
	'achievements-bronze-points' => '10<br />бод.',
	'achievements-you-must' => 'Потребно је $1 да бисте освојили ову значку.',
	'leaderboard-button' => 'Предводници',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|бод|бода|бодова}}</small>',
	'achievements-profile-title-no' => 'Значке {{GENDER:$1|корисника|кориснице|корисника}} $1',
	'achievements-no-badges' => 'Проверите доленаведени списак да видите које значке можете да освојите на овом викију.',
	'achievements-track-name-edit' => 'Трака с изменама',
	'achievements-track-name-picture' => 'Трака са сликама',
	'achievements-track-name-category' => 'Трака с категоријама',
	'achievements-track-name-blogpost' => 'Трака с порукама на блогу',
	'achievements-track-name-blogcomment' => 'Трака с коментарима на блогу',
	'achievements-track-name-love' => 'Трака за Вики-љубав',
	'achievements-track-name-sharing' => 'Историја дељења',
	'achievements-notification-title' => 'Само тако, $1!',
	'achievements-notification-subtitle' => 'Управо сте освојили значку „$1“ $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Кликните овде да видите значке које можете да освојите]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|бод|бода|бодова}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|бод|бода|бодова}}',
	'achievements-earned' => 'Ову значку {{PLURAL:$1|је освојио један корисник|су освојила $1 корисника|је освојило $1 корисника}}.',
	'achievements-profile-title' => '{{GENDER:$1|Корисник $1 је освојио|Корисница $1 је освојила|Корисник $1 је освојио}} {{PLURAL:$2|једну значку|$2 значке|$2 значки}}',
	'achievements-profile-title-challenges' => 'Погледајте још значки које можете да освојите!',
	'achievements-profile-customize' => 'Прилагоди значке',
	'achievements-ranked' => 'На $1 месту на овом викију',
	'achievements-viewall' => 'Погледај све',
	'achievements-viewless' => 'Затвори',
	'achievements-profile-title-oasis' => 'наградних <br /> бодова',
	'achievements-ranked-oasis' => '$1 се [[Special:Leaderboard|налази на $2 месту]] на овом викију',
	'achievements-viewall-oasis' => 'Све',
	'achievements-toggle-hide' => 'Сакриј моја достигнућа на профилу од свих',
	'leaderboard-intro-hide' => 'сакриј',
	'leaderboard-intro-open' => 'отвори',
	'leaderboard-intro-headline' => 'Шта су достигнућа?',
	'leaderboard-intro' => "Учествујући (уређујући, отпремајући слике) на овом викију, добијате значке.<br />Оне носе бодове, и с њима се пењете на табели. Добијене значке ћете наћи у свом [[$1|корисничком профилу]].

'''Колико вреде значке?'''",
	'leaderboard' => 'Предводници',
	'achievements-title' => 'Достигнућа',
	'leaderboard-title' => 'Предводници',
	'achievements-recent-earned-badges' => 'Скорашње освојене значке',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />освојено од <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'освојена значка <strong><a href="$3" class="badgeName">$1</a></strong> <br />$2',
	'achievements-leaderboard-disclaimer' => 'Табела водећих приказује промене од јуче до данас',
	'achievements-leaderboard-rank-label' => 'Ранг',
	'achievements-leaderboard-member-label' => 'Члан',
	'achievements-leaderboard-points-label' => 'Бодови',
	'achievements-leaderboard-points' => '{{PLURAL:$1|бод|бода|бодова}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Недавно освојено',
	'achievements-send' => 'Сачувај слику',
	'achievements-save' => 'Сачувај измене',
	'achievements-reverted' => 'Значка је враћена на првобитно стање.',
	'achievements-customize' => 'Прилагоди слику',
	'achievements-customize-new-category-track' => 'Направите нову траку за категорију:',
	'achievements-enable-track' => 'омогућено',
	'achievements-revert' => 'Врати на подразумевано',
	'achievements-special-saved' => 'Измене су сачуване.',
	'achievements-special' => 'Посебна достигнућа',
	'achievements-secret' => 'Тајна достигнућа',
	'achievementscustomize' => 'Прилагођавање значака',
	'achievements-about-title' => 'О страници…',
	'achievements-edit-plus-category-track-name' => '$1 трака за уређивање',
	'achievements-create-edit-plus-category-title' => 'Прављење нове траке за уређивање',
	'achievements-create-edit-plus-category' => 'Направи траку',
	'platinum' => 'Платина',
	'achievements-community-platinum-awarded-email-subject' => 'Освојили сте нову платинасту значку!',
	'achievements-community-platinum-awarded-email-body-text' => 'Честитамо, $1!

Управо сте награђени с новом платинастом значком „$2“ на $4 ($3). Ово вам доноси додатних 250 бодова!

Погледајте нову значку на вашој корисничкој страници:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Честитамо, $1!</strong><br /><br />
Управо сте награђени с платинастом значком „<strong>$2</strong>“ на <a href="$3">$4</a>. Ово вам доноси додатних 250 бодова!<br /><br />
Погледајте нову значку на вашој <a href="$5">корисничкој страници</a>.',
	'achievements-community-platinum-awarded-for' => 'Додељује се за:',
	'achievements-community-platinum-how-to-earn' => 'Како освојити:',
	'achievements-community-platinum-awarded-for-example' => 'нпр. „зато што…“',
	'achievements-community-platinum-how-to-earn-example' => 'нпр. „направите три измене…“',
	'achievements-community-platinum-badge-image' => 'Слика значке:',
	'achievements-community-platinum-awarded-to' => 'Додељено:',
	'achievements-community-platinum-current-badges' => 'Текуће платинасте значке',
	'achievements-community-platinum-create-badge' => 'Направи значку',
	'achievements-community-platinum-enabled' => 'омогућено',
	'achievements-community-platinum-show-recents' => 'прикажи у скорашњим значкама',
	'achievements-community-platinum-edit' => 'уреди',
	'achievements-community-platinum-save' => 'сачувај',
	'achievements-community-platinum-cancel' => 'откажи',
	'achievements-community-platinum-sponsored-label' => 'Спонзорисано достигнуће',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Лебдећа слика <small>(најмања величина: 270 × 100 пиксела)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Пратећа адреса за приказе значки:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Пратећа адреса за приказе лебдећих слика:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Веза за значку <small>(командна адреса за DART праћење)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Кликните за више информација',
	'achievements-badge-name-edit-0' => 'Прављење разлика',
	'achievements-badge-name-edit-1' => 'На самом почетку',
	'achievements-badge-name-edit-2' => 'Остављање свог трага',
	'achievements-badge-name-edit-3' => 'Пријатељ викија',
	'achievements-badge-name-edit-4' => 'Сарадник',
	'achievements-badge-name-edit-5' => 'Вики-градитељ',
	'achievements-badge-name-edit-6' => 'Вики-предводник',
	'achievements-badge-name-edit-7' => 'Вики-стручњак',
	'achievements-badge-name-picture-0' => 'Слика',
	'achievements-badge-name-picture-1' => 'Папараци',
	'achievements-badge-name-picture-2' => 'Илустратор',
	'achievements-badge-name-picture-3' => 'Колекционар',
	'achievements-badge-name-picture-4' => 'Љубитељ уметности',
	'achievements-badge-name-picture-5' => 'Декоратор',
	'achievements-badge-name-picture-6' => 'Дизајнер',
	'achievements-badge-name-picture-7' => 'Кустос',
	'achievements-badge-name-category-0' => 'Повезивање',
	'achievements-badge-name-category-1' => 'Крчилац',
	'achievements-badge-name-category-2' => 'Истраживач',
	'achievements-badge-name-category-3' => 'Водич',
	'achievements-badge-name-category-4' => 'Навигатор',
	'achievements-badge-name-category-5' => 'Мостоградитељ',
	'achievements-badge-name-category-6' => 'Вики-планер',
	'achievements-badge-name-blogpost-0' => 'Има нешто да каже',
	'achievements-badge-name-blogpost-1' => 'Ћаскање',
	'achievements-badge-name-blogpost-2' => 'Ток-шоу',
	'achievements-badge-name-blogpost-3' => 'Страначки живот',
	'achievements-badge-name-blogpost-4' => 'Говорник',
	'achievements-badge-name-blogcomment-0' => 'Јавни мислилац',
	'achievements-badge-name-blogcomment-1' => 'И још једна ствар',
	'achievements-badge-name-love-0' => 'Кључ за вики!',
	'achievements-badge-name-love-1' => 'Две недеље на викију',
	'achievements-badge-name-love-2' => 'Пожртвован',
	'achievements-badge-name-love-3' => 'Посвећен',
	'achievements-badge-name-love-4' => 'Навучен',
	'achievements-badge-name-love-5' => 'Вики-живот',
	'achievements-badge-name-love-6' => 'Вики-херој!',
	'achievements-badge-name-sharing-0' => 'Делилац',
	'achievements-badge-name-sharing-1' => 'Вратите га',
	'achievements-badge-name-sharing-2' => 'Говорник',
	'achievements-badge-name-sharing-3' => 'Најављивач',
	'achievements-badge-name-sharing-4' => 'Јеванђелиста',
	'achievements-badge-name-welcome' => 'Добро дошли на вики',
	'achievements-badge-name-introduction' => 'Увод',
	'achievements-badge-name-sayhi' => 'Поздрав',
	'achievements-badge-name-creator' => 'Творац',
	'achievements-badge-name-pounce' => 'Залет!',
	'achievements-badge-name-caffeinated' => 'Кофеинизиран',
	'achievements-badge-name-luckyedit' => 'Срећна измена',
	'achievements-badge-to-get-edit' => 'да направите $1 {{PLURAL:$1|измену|измене|измена}} на {{PLURAL:$1|страници|страницама}}',
	'achievements-badge-to-get-edit-plus-category' => 'да направите {{PLURAL:$1|једну измену|$1 измене|$1 измена}} на $2 {{PLURAL:$1|страници|странице|страница}}',
	'achievements-badge-to-get-picture' => 'да додате $1 {{PLURAL:$1|слику|слике|слика}} на {{PLURAL:$1|страницу|странице}}',
	'achievements-badge-to-get-category' => 'да додате $1 {{PLURAL:$1|страницу|странице|страница}} у {{PLURAL:$1|категорију|категорије}}',
	'achievements-badge-to-get-blogpost' => 'да напишете $1 {{PLURAL:$1|поруку|поруке|порука}} на блогу',
	'achievements-badge-to-get-blogcomment' => 'да прокоментаришете {{PLURAL:$1|поруку|$1 поруке|$1 порука}} на блогу',
	'achievements-badge-to-get-love' => 'да доприносите викију свакодневно у року од {{PLURAL:$1|једног дана|$1 дана|$1 дана}}',
	'achievements-badge-to-get-welcome' => 'да се придружите викију',
	'achievements-badge-to-get-introduction' => 'да додате у своју корисничку страницу',
	'achievements-badge-to-get-sayhi' => 'да оставите некоме поруку на страници за разговор',
	'achievements-badge-to-get-creator' => 'да постанете творац овог викија',
	'achievements-badge-to-get-pounce' => 'да будете брзи',
	'achievements-badge-to-get-caffeinated' => 'да направите {{PLURAL:$1|измену|$1 измене|$1 измена}} на страницама у једном дану',
	'achievements-badge-to-get-luckyedit' => 'да имате среће',
	'achievements-userprofile-title-no' => 'Освојене значке {{GENDER:$1|корисника|кориснице|корисника}} $1',
	'achievements-userprofile-title' => '{{PLURAL:$2|Освојена значка|Освојене значке}} {{GENDER:$1|корисника|кориснице|корисника}} $1 ($2)',
	'achievements-userprofile-no-badges-visitor' => 'Овај корисник још није освојио ниједну значку.',
	'achievements-userprofile-profile-score' => '<em>$1</em> бода за<br />достигнућа',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|На $1 месту]]<br />на овом викију',
);

$messages['sv'] = array(
	'achievementsii-desc' => 'En prestationsemblems-system för wiki-användare',
	'achievements-upload-error' => 'Tyvärr!
Den här bilden fungerar inte.
Se till att bilden är en .jpg eller .png fil.
Om det fortfarande inte fungerar, kan bilden vara för stor.
Försök med en annan!',
	'achievements-upload-not-allowed' => 'Administratörer kan ändra namn och bilder på Utmärkelseemblem genom att besöka sidan [[Special:AchievementsCustomize|Anpassa utmärkelser]].',
	'achievements-non-existing-category' => 'Den angivna kategorin finns inte.',
	'achievements-edit-plus-category-track-exists' => 'Valda kategorin har redan ett <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Gå till spåret">associerat spår</a>.',
	'achievements-no-stub-category' => 'Var god skapa inte spår för stubbar.',
	'right-platinum' => 'Skapa och redigera Platinaemblem',
	'right-sponsored-achievements' => 'Hantera sponsrade utmärkelser',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Guld',
	'achievements-silver' => 'Silver',
	'achievements-bronze' => 'Brons',
	'achievements-gold-points' => '100<br />poäng',
	'achievements-silver-points' => '50<br />poäng',
	'achievements-bronze-points' => '10<br />poäng',
	'achievements-you-must' => 'Du måste tjäna $1 för att få detta emblem.',
	'leaderboard-button' => 'Topplista för utmärkelser',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|poäng|poäng}}</small>',
	'achievements-profile-title-no' => '$1s emblem',
	'achievements-no-badges' => 'Kolla in listan nedan för att se de emblem som du kan tjäna på denna wiki!',
	'achievements-track-name-edit' => 'Redigeringsserie',
	'achievements-track-name-picture' => 'Bildserie',
	'achievements-track-name-category' => 'Kategoriserie',
	'achievements-track-name-blogpost' => 'Blogginläggsserie',
	'achievements-track-name-blogcomment' => 'Bloggkommentarsserie',
	'achievements-track-name-love' => 'Wiki-kärleksserie',
	'achievements-track-name-sharing' => 'Delningsserie',
	'achievements-notification-title' => 'Bra jobbat, $1!',
	'achievements-notification-subtitle' => 'Du har just fått emblemet "$1" $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Se fler emblem du kan tjäna]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|poäng|poäng}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|poäng|poäng}}',
	'achievements-earned' => 'Detta emblem har tjänats av {{PLURAL:$1|1 användare|$1 användare}}.',
	'achievements-profile-title' => '$1s $2 tjänade {{PLURAL:$2|emblem|emblem}}',
	'achievements-profile-title-challenges' => 'Fler emblem som du kan tjäna!',
	'achievements-profile-customize' => 'Anpassa emblem',
	'achievements-ranked' => 'Rankad #$1 på denna wiki',
	'achievements-viewall' => 'Visa alla',
	'achievements-viewless' => 'Stäng',
	'achievements-profile-title-oasis' => 'utmärkelse- <br /> poäng',
	'achievements-ranked-oasis' => '$1 är [[Special:Leaderboard|Rankad #$2]] på denna wiki',
	'achievements-viewall-oasis' => 'Se alla',
	'achievements-toggle-hide' => 'Göm mina utmärkelser på min profil från alla',
	'leaderboard-intro-hide' => 'göm',
	'leaderboard-intro-open' => 'öppna',
	'leaderboard-intro-headline' => 'Vad är Utmärkelser?',
	'leaderboard-intro' => "Du kan tjäna emblem genom att ändra sidor på denna wiki, ladda upp foton och lämna kommentarer. För varje emblem kan du tjäna poäng - desto mer poäng du får, desto högre upp på topplistan går du! Du kan hitta alla intjänade emblem på din [[$1|användarsida]].

	'''Vad är emblem värda?'''",
	'leaderboard' => 'Topplistan för Utmärkelser',
	'achievements-title' => 'Utmärkelser',
	'leaderboard-title' => 'Topplista',
	'achievements-recent-earned-badges' => 'Senaste Emblem Tjänade',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />tjänats av <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'tjänade emblemet <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Topplistan visar ändringar sedan igår',
	'achievements-leaderboard-rank-label' => 'Rank',
	'achievements-leaderboard-member-label' => 'Medlem',
	'achievements-leaderboard-points-label' => 'Poäng',
	'achievements-leaderboard-points' => '{{PLURAL:$1|poäng|poäng}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Senaste tjänade',
	'achievements-send' => 'Spara bild',
	'achievements-save' => 'Spara ändringar',
	'achievements-reverted' => 'Emblem återgick till orginalet.',
	'achievements-customize' => 'Anpassa bild',
	'achievements-customize-new-category-track' => 'Skapa en ny serie för kategori:',
	'achievements-enable-track' => 'aktiverad',
	'achievements-revert' => 'Återgå till standard',
	'achievements-special-saved' => 'Ändringar sparade.',
	'achievements-special' => 'Speciella utmärkelser',
	'achievements-secret' => 'Hemliga utmärkelser',
	'achievementscustomize' => 'Anpassa emblem',
	'achievements-about-title' => 'Om den här sidan...',
	'achievements-about-content' => 'Administratörer på denna wiki kan anpassa namn och bilder på Prestationsemblem.

Du kan ladda upp alla .jpg eller .png-bilder och bilden kommer automatiskt passa inuti ramen.
Det fungerar bäst om bilden är fyrkantig och den viktigaste delen av bilden är i mitten.

Du kan använda rektangulära bilder, men du kan upptäcka att en bit måste beskäras av ramen.
Om du har ett bildredigeringsprogram kan du beskära bilden och sätta den viktiga delen av bilden i mitten.
Om du inte har ett bildredigeringsprogram, experimentera då bara med olika bilder tills du hittar den som fungerar för dig!
Om du inte tycker om bilden som du har valt, klickar du på "{{int:achievements-save}}" för att spara din ändringar.

Du kan också ge emblemen nya namn som återspeglar ämnet för wikin.
När du har ändrat namnet på emblemet, klickar du på "{{int:achievements-save}}" för att spara dina ändringar
Ha det så kul!',
	'achievements-edit-plus-category-track-name' => '$1 redigera serie',
	'achievements-create-edit-plus-category-title' => 'Skapa en ny redigeringsserie',
	'achievements-create-edit-plus-category-content' => 'Du kan skapa en ny uppsättning emblems som belönar användare för att redigera sidor i en viss kategori, för att lyfta fram ett särskilt område av den webbplats som användare skulle trivas att arbeta på.
Du kan ställa in mer än ett kategorispår, så försök att välja två kategorier som skulle hjälpa användare att visa upp deras specialitet!
Antänd en rivalitet mellan användarna som redigerar sidorna om vampyrer och användarna som redigerar sidorna om varulvar, eller trollkarlar och mugglare, eller autobots och bedragare.

För att skapa en ny "Redigera i kategori"-spår anger du namnet på kategorin i fältet nedan.
Det vanliga redigeringsspåret kommer fortfarande existera;
detta kommer att skapa ett separat spår som du kan anpassa separat.

När spåret är skapat kommer de nya emblemen dyka upp i listan till vänster, under det vanliga redigeringsspåret.
Anpassa namnen och bilderna för det nya spåret, så att användare kan se skillnaden!

När du är klar med anpassningen klickar du på kryssrutan "{{int:achievements-enable-track}}" för att slå på det nya spåret, och sedan klickar du på "{{int:achievements-save}}".
Användare kommer att se det nya spåret dyka upp på deras användarprofiler, och de kommer att börja tjänan emblem när de redigerar sidor i den kategorin.
Du kan också inaktivera spåret senare om du bestämmer dig för att du inte vill lyfta fram den kategorin längre.
Användare som har tjänat emblem kommer alltid behålla sina emblem, även om spåret är inaktiverat.

Detta kan ta utmärkelserna till en helt ny nivå.
Prova ut den!',
	'achievements-create-edit-plus-category' => 'Skapa denna serie',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'Du har tilldelats ett nytt Platinaemblem!',
	'achievements-community-platinum-awarded-email-body-text' => "Grattis $1!

Du har just belönats med Platinaemblemet '$2' på $4 ($3).
Detta lägger till 250 poäng till din poängsumma!

Kolla in dina nya snygga emblem på din användarprofilsida:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Grattis, $1!</strong><br /><br />
Du har tjänat Platina-emblemet \'<strong>$2</strong>\' på <a href="$3">$4</a>.
Detta lägger till 250 poäng till din poängställning!<br /><br />
Kolla in ditt nya snygga emblem på din <a href="$5">användarprofilsida</a>.',
	'achievements-community-platinum-awarded-for' => 'Tilldelad för:',
	'achievements-community-platinum-how-to-earn' => 'Hur man tjänar den:',
	'achievements-community-platinum-awarded-for-example' => 't.ex. "för att du gjorde..."',
	'achievements-community-platinum-how-to-earn-example' => 't.ex. "göra 3 redigeringar..."',
	'achievements-community-platinum-badge-image' => 'Emblembild:',
	'achievements-community-platinum-awarded-to' => 'Tilldelats till:',
	'achievements-community-platinum-current-badges' => 'Nuvarande platinaemblem',
	'achievements-community-platinum-create-badge' => 'Skapa emblem',
	'achievements-community-platinum-enabled' => 'aktiverad',
	'achievements-community-platinum-show-recents' => 'visa de senaste emblem',
	'achievements-community-platinum-edit' => 'redigera',
	'achievements-community-platinum-save' => 'spara',
	'achievements-community-platinum-cancel' => 'avbryt',
	'achievements-community-platinum-sponsored-label' => 'Sponsrade utmärkelser',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Hovringsbild <small>(minsta storlek: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Spårningsadress för intrycksemblem:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Spårningsadress för muspekningsintryck:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Emblem-länk <small>(DART-klickningskommando-URL)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Klicka för mer information',
	'achievements-badge-name-edit-0' => 'Att göra skillnad',
	'achievements-badge-name-edit-1' => 'Bara början',
	'achievements-badge-name-edit-2' => 'Göra sin del',
	'achievements-badge-name-edit-3' => 'Vän till Wikin',
	'achievements-badge-name-edit-4' => 'Medarbetare',
	'achievements-badge-name-edit-5' => 'Wiki-byggare',
	'achievements-badge-name-edit-6' => 'Wiki-Ledare',
	'achievements-badge-name-edit-7' => 'Wiki-expert',
	'achievements-badge-name-picture-0' => 'Ögonblicksbild',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illustratör',
	'achievements-badge-name-picture-3' => 'Samlare',
	'achievements-badge-name-picture-4' => 'Konstälskare',
	'achievements-badge-name-picture-5' => 'Dekoratör',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Kurator',
	'achievements-badge-name-category-0' => 'Skapa en anslutning',
	'achievements-badge-name-category-1' => 'Banbrytare',
	'achievements-badge-name-category-2' => 'Utforskare',
	'achievements-badge-name-category-3' => 'Turguide',
	'achievements-badge-name-category-4' => 'Navigatör',
	'achievements-badge-name-category-5' => 'Brobyggare',
	'achievements-badge-name-category-6' => 'Wiki-Planerare',
	'achievements-badge-name-blogpost-0' => 'Någonting att säga',
	'achievements-badge-name-blogpost-1' => 'Fem saker att säga',
	'achievements-badge-name-blogpost-2' => 'Pratshow',
	'achievements-badge-name-blogpost-3' => 'Festens medelpunkt',
	'achievements-badge-name-blogpost-4' => 'Folktalare',
	'achievements-badge-name-blogcomment-0' => 'Meningsinnehavare',
	'achievements-badge-name-blogcomment-1' => 'Och en sak till',
	'achievements-badge-name-love-0' => 'Nyckeln till Wikin!',
	'achievements-badge-name-love-1' => 'Två veckor på wikin',
	'achievements-badge-name-love-2' => 'Hängiven',
	'achievements-badge-name-love-3' => 'Målmedveten',
	'achievements-badge-name-love-4' => 'Begivenhet',
	'achievements-badge-name-love-5' => 'Ett Wiki-liv',
	'achievements-badge-name-love-6' => 'Wiki-hjälte!',
	'achievements-badge-name-sharing-0' => 'Delare',
	'achievements-badge-name-sharing-1' => 'Ta tillbaka det',
	'achievements-badge-name-sharing-2' => 'Talare',
	'achievements-badge-name-sharing-3' => 'Annonsör',
	'achievements-badge-name-sharing-4' => 'Evangelist',
	'achievements-badge-name-welcome' => 'Välkommen till Wikin',
	'achievements-badge-name-introduction' => 'Introduktion',
	'achievements-badge-name-sayhi' => 'Tittar in för att säga hej',
	'achievements-badge-name-creator' => 'Skaparen',
	'achievements-badge-name-pounce' => 'Angrepp!',
	'achievements-badge-name-caffeinated' => 'Koffeinerad',
	'achievements-badge-name-luckyedit' => 'Tursam redigering',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|dela länk|få {{PLURAL:$1|en person|$1 personer}} att klicka på länken du delade}}',
	'achievements-badge-to-get-edit' => 'redigera {{PLURAL:$1|en sida|$1 sidor}}',
	'achievements-badge-to-get-edit-plus-category' => 'gör {{PLURAL:$1|en redigering|$1 redigeringar}} på {{PLURAL:$1|en $2-sida|$2 sidor}}',
	'achievements-badge-to-get-picture' => 'lägg till $1 {{PLURAL:$1|bild|bilder}} på {{PLURAL:$1|sida|sidor}}',
	'achievements-badge-to-get-category' => 'lägg till $1 {{PLURAL:$1|sida|sidor}} till {{PLURAL:$1|en kategori|kategorier}}',
	'achievements-badge-to-get-blogpost' => 'skriva $1 {{PLURAL:$1|blogginlägg|blogginlägg}}',
	'achievements-badge-to-get-blogcomment' => 'skriva en kommentar till {{PLURAL:$1|ett blogginlägg|$1 olika blogginlägg}}',
	'achievements-badge-to-get-love' => 'bidrag till wikin varje dag i {{PLURAL:$1|en dag|$1 dagar}}',
	'achievements-badge-to-get-welcome' => 'gå med i wikin',
	'achievements-badge-to-get-introduction' => 'lägg till din egen användarsida',
	'achievements-badge-to-get-sayhi' => 'lämna ett meddelande på någons diskussionssidan',
	'achievements-badge-to-get-creator' => 'var skaparen av denna wiki',
	'achievements-badge-to-get-pounce' => 'var snabb',
	'achievements-badge-to-get-caffeinated' => 'gör {{PLURAL:$1|en redigering|$1 redigeringar}} på en dag',
	'achievements-badge-to-get-luckyedit' => 'var tursam',
	'achievements-badge-to-get-sharing-details' => 'Dela länkar och få andra att klicka på dem!',
	'achievements-badge-to-get-edit-details' => 'Saknas någoting?
Finns det ett misstag?
Var inte blyg.
Klicka på knappen "{{int:edit}}" och du kan lägga till valfri sida!',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong>-sidorna behöver din hjälp!
Klicka på knappen "{{int:edit}}" på någon sida i den kategorin för att hjälpa till.
Visa din stöd för $1-sidorna!',
	'achievements-badge-to-get-picture-details' => 'Klicka på knappen "{{int:edit}}", och sedan "{{int:rte-ck-image-add}}". Du kan lägga till ett foto från din dator, eller från en annan sida på wikin.',
	'achievements-badge-to-get-category-details' => 'Kategorier är taggar som hjälper läsarna att hitta liknande sidor.
Klicka på knappen "{{int:categoryselect-addcategory-button}}" längst ned på en sida för att lägga till den i en kategori.',
	'achievements-badge-to-get-blogpost-details' => 'Skriva dina åsikter och frågor!
Klicka på "{{int:blogs-recent-url-text}}" i sidofältet och sedan på länken till vänster för "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Lägg till din mening!
Läs någon av de senaste bloggarna och skriva dina tankar i kommentarfältet.',
	'achievements-badge-to-get-love-details' => 'Räknaren återställs om du missar en dag, så se till att komma tillbaka till wiki varje dag!',
	'achievements-badge-to-get-welcome-details' => 'Klicka på knappen "{{int:oasis-signup}}" längst upp för att gå med i gemenskapen.
Du kan börja tjäna egna emblem!',
	'achievements-badge-to-get-introduction-details' => 'Är din användarsida tom?
Klicka på ditt användarnamn längst upp på skärmen för att se.
Klicka sedan på "{{int:edit}}" för att lägga till lite information om dig själv!',
	'achievements-badge-to-get-sayhi-details' => 'Du kan lämna andra användarmeddelanden genom att klicka på "{{int:addsection}}" på deras diskussionssida.
Be om hjälp, tacka dem för deras arbete eller säg bara hej!',
	'achievements-badge-to-get-creator-details' => 'Detta emblem ges ut till personen som grundade denna wiki.
Klicka på knappen "{{int:createwiki}}" längst upp för att starta en sida om vad du gillar mest!',
	'achievements-badge-to-get-pounce-details' => 'Du måste vara snabb att tjäna detta emblem.
Klicka på knappen "{{int:activityfeed}}" för att se de nya sidorna som användare skapar!',
	'achievements-badge-to-get-caffeinated-details' => 'Det kräver en hektisk dag för att förtjäna detta emblem.
Fortsätta redigera!',
	'achievements-badge-to-get-luckyedit-details' => 'Du måste vara tursam för att tjäna detta emblem.
Fortsätt redigera!',
	'achievements-badge-to-get-community-platinum-details' => 'Detta är en speciellt Platina-emblem som endast är tillgänglig under en begränsad tid!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|för att dela en länk|för att få {{PLURAL:$1|en person|$1 personer}} att klicka på delade länkar}}',
	'achievements-badge-hover-desc-edit' => 'Tilldelad för att göra {{PLURAL:$1|en redigering|$1 redigeringar}}<br />
på {{PLURAL:$1|en sida|sidor}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Tilldelad för att göra {{PLURAL:$1|en redigering|$1 redigeringar}}<br />
på {{PLURAL:$1|en $2sida|$2sidor}}!',
	'achievements-badge-hover-desc-picture' => 'Tilldelad för att lägga till {{PLURAL:$1|en bild|$1 bilder}}<br />
på {{PLURAL:$1|en sida|sidor}}!',
	'achievements-badge-hover-desc-category' => 'Tilldelad för att lägga till {{PLURAL:$1|en sida|$1 sidor}}<br />
på {{PLURAL:$1|en kategori|kategorier}}!',
	'achievements-badge-hover-desc-blogpost' => 'Tilldelad för att skriva {{PLURAL:$1|ett blogginlägg|$1 blogginlägg}}!',
	'achievements-badge-hover-desc-blogcomment' => 'Tilldelad för att skriva en kommentar<br />
på {{PLURAL:$1|ett blogginlägg|$1 olika blogginlägg}}!',
	'achievements-badge-hover-desc-love' => 'Tilldelad för att bidra till wikin varje dag i {{PLURAL:$1|en dag|$1 dagar}}!',
	'achievements-badge-hover-desc-welcome' => 'Tilldelad för att gå med i wikin!',
	'achievements-badge-hover-desc-introduction' => 'Tilldelad för att lägga till din<br />
egen användarsida!',
	'achievements-badge-hover-desc-sayhi' => 'Tilldelad för att lämna ett meddelande<br />
på någon annans diskussionssida!',
	'achievements-badge-hover-desc-creator' => 'Tilldelad för att skapa wikin!',
	'achievements-badge-hover-desc-pounce' => 'Tilldelad för att göra redigeringar på 100 sidor inom en timme sedan sidan skapades!',
	'achievements-badge-hover-desc-caffeinated' => 'Tilldelad för att göra 100 redigeringar på en enda dag!',
	'achievements-badge-hover-desc-luckyedit' => 'Tilldelad för att göra den {{PLURAL:$1|$1:a|$1:e}} tursamma redigeringen på wikin!',
	'achievements-badge-hover-desc-community-platinum' => 'Detta är ett speciellt Platina-emblem som endast är tillgänglig under en begränsad tid!',
	'achievements-badge-your-desc-sharing' => 'Tilldelad {{#ifeq:$1|0|för att dela en länk|för att få {{PLURAL:$1|en person|$1 personer}} att klicka på delade länkar}}',
	'achievements-badge-your-desc-edit' => 'Tilldelad för att göra {{PLURAL:$1|din första redigering|$1 redigeringar!}} på {{PLURAL:$1|en sida|sidor}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'Tilldelad för att göra {{PLURAL:$1|din första redigering|$1 redigeringar}} på {{PLURAL:$1|en $2sida|$2sidor}}!',
	'achievements-badge-your-desc-picture' => 'Tilldelad för att lägga till {{PLURAL:$1|din första bild|$1 bilder}} på {{PLURAL:$1|en sida|sidor}}!',
	'achievements-badge-your-desc-category' => 'Tilldelad för att lägga till {{PLURAL:$1|din första sida|$1 sidor}} på {{PLURAL:$1|en kategori|kategorier}}!',
	'achievements-badge-your-desc-blogpost' => 'Tilldelad för att skriva {{PLURAL:$1|ditt första blogginlägg|$1 blogginlägg}}!',
	'achievements-badge-your-desc-blogcomment' => 'Tilldelad för att skriva en kommentar på {{PLURAL:$1|ett blogginlägg|$1 olika blogginlägg}}!',
	'achievements-badge-your-desc-love' => 'Tilldelad för att bidra till wikin varje dag i {{PLURAL:$1|en dag|$1 dagar}}!',
	'achievements-badge-your-desc-welcome' => 'Tilldelad för att gå med i wikin!',
	'achievements-badge-your-desc-introduction' => 'Tilldelad för att lägga till din egen användarsida!',
	'achievements-badge-your-desc-sayhi' => 'Tilldelad för att lämna ett meddelande på någon annans diskussionssida!',
	'achievements-badge-your-desc-creator' => 'Tilldelad för att skapa wikin!',
	'achievements-badge-your-desc-pounce' => 'Tilldelad för att göra redigeringar på 100 sidor inom en timme sedan sidan skapades!',
	'achievements-badge-your-desc-caffeinated' => 'Tilldelad för att göra 100 redigeringar på en enda dag!',
	'achievements-badge-your-desc-luckyedit' => 'Tilldelad för att göra den {{PLURAL:$1|$1:a|$1:e}} tursamma redigeringen på wikin!',
	'achievements-badge-desc-sharing' => 'Tilldelad {{#ifeq:$1|0|för att dela en länk|för att få {{PLURAL:$1|en person|$1 personer}} att klicka på delade länkar}}',
	'achievements-badge-desc-edit' => 'Tilldelad för att göra {{PLURAL:$1|en redigering|$1 redigeringar}} på {{PLURAL:$1|en sida|sidor}}!',
	'achievements-badge-desc-edit-plus-category' => 'Tilldelad för att göra {{PLURAL:$1|en redigering|$1 redigeringar}} på {{PLURAL:$1|en $2sida|$2sidor}}!',
	'achievements-badge-desc-picture' => 'Tilldelad för att lägga till $1 {{PLURAL:$1|bild|bilder}} på {{PLURAL:$1|en sida|sidor}}!',
	'achievements-badge-desc-category' => 'Tilldelad för att lägga till {{PLURAL:$1|en sida|$1 sidor}} på {{PLURAL:$1|en kategori|kategorier}}!',
	'achievements-badge-desc-blogpost' => 'Tilldelad för att skriva {{PLURAL:$1|ett blogginlägg|$1 blogginlägg}}!',
	'achievements-badge-desc-blogcomment' => 'Tilldelad för att skriva en kommentar på {{PLURAL:$1|ett blogginlägg|$1 olika blogginlägg}}!',
	'achievements-badge-desc-love' => 'Tilldelad för att bidra till wikin varje dag i {{PLURAL:$1|en dag|$1 dagar}}!',
	'achievements-badge-desc-welcome' => 'Tilldelad för att gå med i wikin!',
	'achievements-badge-desc-introduction' => 'Tilldelad för att lägga till din egen användarsida!',
	'achievements-badge-desc-sayhi' => 'Tilldelad för att lämna ett meddelande på någon annans diskussionssida!',
	'achievements-badge-desc-creator' => 'Tilldelad för att skapa wikin!',
	'achievements-badge-desc-pounce' => 'Tilldelad för att göra redigeringar på 100 sidor inom en timme sedan sidan skapades!',
	'achievements-badge-desc-caffeinated' => 'Tilldelad för att göra 100 redigeringar på en enda dag!',
	'achievements-badge-desc-luckyedit' => 'Tilldelad för att göra den {{PLURAL:$1|$1:a|$1:e}} tursamma redigeringen på wikin!',
	'achievements-userprofile-title-no' => '$1s tjänade emblem',
	'achievements-userprofile-title' => '$1s intjänade {{PLURAL:$2|emblem|emblem}} ($2)',
	'achievements-userprofile-no-badges-owner' => 'Kolla in listan nedan för att se de emblem som du kan tjäna på denna wiki!',
	'achievements-userprofile-no-badges-visitor' => 'Denna användare har inte tjänat några emblem ännu.',
	'achievements-userprofile-profile-score' => '<em>$1</em> prestations-<br />poäng',
	'achievements-userprofile-ranked' => '[[Special:Leaderboard|Rankad som #$1]]<br />på denna wiki',
);

$messages['sw'] = array(
	'achievements-upload-error' => 'Pole!
Picha hiyo haifanyi kazi.
Hakikisha kwamba hilo faili ni .jpg au .png.
Ikiwa bado halifanyi kazi, basi huenda picha ikawa kubwa sana.
Tafadhali jaribu nyingine!',
	'achievements-viewless' => 'Funga',
	'achievements-community-platinum-edit' => 'hariri',
	'achievements-community-platinum-save' => 'hifadhi',
);

$messages['ta'] = array(
	'achievements-upload-error' => '↓மன்னிக்கவும்!</br>
அந்த படம் வேலை செய்யவில்லை.</br>
அது ஒரு .jpg அல்லது .png கோப்பு என்பதை உறுதி செய்யவும்.</br>
அது இன்னமும் வேலை செய்யவில்லை என்றால், படம் மிக பெரிதாக இருக்க கூடும்.</br>
வேறு ஒன்றை முயற்சிக்கவும்!',
	'achievements-non-existing-category' => 'குறிப்பிட்ட வகை பகுப்பு இங்கு இல்லை.',
	'achievements-platinum' => 'பிளாட்டினம்',
	'achievements-gold' => 'தங்கம்',
	'achievements-silver' => 'வெள்ளி',
	'achievements-bronze' => 'வெண்கலம்',
	'achievements-track-name-edit' => 'தடங்களை தொகு',
	'achievements-viewall' => 'எல்லாவற்றையும் பார்க்கவும்',
	'achievements-viewless' => 'மூடுக',
	'achievements-viewall-oasis' => 'எல்லாவற்றையும் பார்க்கவும்',
	'leaderboard-intro-hide' => 'மறை',
	'leaderboard-intro-open' => 'திற',
	'leaderboard-intro-headline' => 'என்னென்ன சாதனைகள்?',
	'achievements-title' => 'சாதனைகள்',
	'achievements-leaderboard-rank-label' => 'தர வரிசை',
	'achievements-leaderboard-member-label' => 'உறுப்பினர்',
	'achievements-leaderboard-points-label' => 'புள்ளிகள்',
	'achievements-leaderboard-points' => '{{PLURAL:$1|புள்ளி|புள்ளிகள்}}',
	'achievements-leaderboard-most-recently-earned-label' => 'மிக சமீபத்தில் பெற்ற',
	'achievements-send' => 'படத்தைச் சேமி',
	'achievements-save' => 'மாற்றங்களைச் சேமி',
	'achievements-enable-track' => 'பயன்பாட்டில் உள்ளது',
	'achievements-special-saved' => 'மாற்றங்கள் சேமிக்கப்பட்டுவிட்டன.',
	'achievements-special' => 'சிறப்பான சாதனைகள்',
	'achievements-secret' => 'இரகசியமான சாதனைகள்',
	'achievements-about-title' => 'இந்த பக்கத்தைப்பற்றி...',
	'achievements-create-edit-plus-category' => 'இந்தத் தடம் உருவாக்கு',
	'platinum' => 'பிளாட்டினம்',
	'achievements-community-platinum-awarded-email-subject' => 'உங்களுக்கு ஒரு புதிய பிளாட்டினம் பட்டை வழங்கப்பட்டுள்ளது!',
	'achievements-community-platinum-how-to-earn' => 'எவ்வாறு பெறுவது:',
	'achievements-community-platinum-enabled' => 'பயன்பாட்டில் உள்ளது',
	'achievements-community-platinum-edit' => 'தொகு',
	'achievements-community-platinum-save' => 'சேமி',
	'achievements-community-platinum-cancel' => 'ரத்து செய்',
	'achievements-badge-name-edit-1' => 'தொடக்கம் மட்டுமே',
);

$messages['te'] = array(
	'achievements-platinum' => 'ప్లాటినం',
	'achievements-gold' => 'స్వర్ణం',
	'achievements-silver' => 'రజతం',
	'achievements-bronze' => 'కాంస్యం',
	'achievements-profile-title-no' => '$1 యొక్క బాడ్జీలు',
	'achievements-viewless' => 'మూసివేయి',
	'achievements-enable-track' => 'చేతనమైంది',
	'achievements-about-title' => 'ఈ పుట గురించి...',
	'achievements-community-platinum-edit' => 'సవరించు',
	'achievements-community-platinum-save' => 'భద్రపరుచు',
	'achievements-community-platinum-cancel' => 'రద్దుచేయి',
);

$messages['tet'] = array(
	'achievements-community-platinum-edit' => 'edita',
);

$messages['th'] = array(
	'achievements-viewall' => 'เปิดดูทั้งหมด',
	'achievements-viewless' => 'ปิด',
	'achievements-viewall-oasis' => 'ดูทั้งหมด',
	'leaderboard-intro-hide' => 'ซ่อน',
	'leaderboard-intro-open' => 'เปิด',
	'achievements-leaderboard-rank-label' => 'อันดับ',
	'achievements-leaderboard-member-label' => 'สมาชิก',
	'achievements-leaderboard-points-label' => 'คะแนน',
	'achievements-send' => 'บันทึกรูปภาพ',
	'achievements-save' => 'บันทึกการเปลี่ยนแปลง',
	'achievements-enable-track' => 'เปิดใช้งานแล้ว',
	'achievements-special-saved' => 'บันทึกการเปลี่ยนแปลงแล้ว',
	'achievements-about-title' => 'เกี่ยวกับหน้านี้',
	'achievements-community-platinum-enabled' => 'เปิดใช้งานแล้ว',
	'achievements-community-platinum-edit' => 'แก้ไข',
	'achievements-community-platinum-save' => 'บันทึก',
	'achievements-community-platinum-cancel' => 'ยกเลิก',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'คลิกดูรายละเอียดเพิ่มเติม',
);

$messages['tl'] = array(
	'achievementsii-desc' => 'Isang sistema ng mga tsapa ng naisagawa para sa mga tagagamit ng wiki',
	'achievements-upload-error' => 'Paumanhin!
Hindi gumagana ang larawang iyan!
Pakitiyak na isa itong talaksang .jpg o .png.
Kapag hindi pa rin gumana, kung gayon maaaring napakalaki ng larawan.
Pakisubukan ang iba pa!',
	'achievements-upload-not-allowed' => 'Mababago ng mga tagapangasiwa ang mga pangalan at mga larawan ng mga tsapa ng Naisagawa sa pamamagitan ng pagdalaw sa pahina ng [[Special:AchievementsCustomize|Ipasadya ang mga naisagawa]].',
	'achievements-non-existing-category' => 'Hindi umiiral ang tinukoy na kategorya.',
	'achievements-edit-plus-category-track-exists' => 'Ang tinukoy na kategorya ay mayroon nang <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">kaugnay na bakas</a>.',
	'achievements-no-stub-category' => 'Mangyaring huwag lumikha ng mga bakas para sa mga usbong.',
	'right-platinum' => 'Likhain at baguhin ang mga tsapang Platinum',
	'right-sponsored-achievements' => 'Pamahalaan ang mga naisagawang may Tagapagtaguyod',
	'achievements-platinum' => 'Platinum',
	'achievements-gold' => 'Ginto',
	'achievements-silver' => 'Pilak',
	'achievements-bronze' => 'Tansong pula',
	'achievements-gold-points' => '100<br /> mga puntos',
	'achievements-silver-points' => '50<br /> mga puntos',
	'achievements-bronze-points' => '10<br /> mga puntos',
	'achievements-you-must' => 'Kailangan mong $1 upang makamit ang tsapang ito.',
	'leaderboard-button' => 'Pinunong pisara ng mga nakamit',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|puntos|mga puntos}}</small>',
	'achievements-profile-title-no' => 'Mga tsapa ni $1',
	'achievements-no-badges' => 'Suriin ang talaang nasa ibaba upang makita ang mga tsapang maaari mong makamit sa wiking ito!',
	'achievements-track-name-edit' => 'Baguhin ang bakas',
	'achievements-track-name-picture' => 'Bakas ng mga larawan',
	'achievements-track-name-category' => 'Bakas ng kategorya',
	'achievements-track-name-blogpost' => 'Bakas ng Pagpapaskil sa Blog',
	'achievements-track-name-blogcomment' => 'Bakas ng Puna sa Blog',
	'achievements-track-name-love' => 'Bakas ng Pagmamahal ng Wiki',
	'achievements-track-name-sharing' => 'Bakas ng Pagbabahagi',
	'achievements-notification-title' => 'Ganyan nga, $1!',
	'achievements-notification-subtitle' => 'Kakakamit mo lamang ng tsapang "$1" na $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Tumingin ng iba pang mga tsapang maaari mong makamtan]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|puntos|mga puntos}}',
	'achievements-points-with-break' => '$1<br /> {{PLURAL:$1|puntos|mga puntos}}',
	'achievements-earned' => 'Ang tsapang ito ay nakamit ng {{PLURAL:$1|1 tagagamit|$1 mga tagagamit}}.',
	'achievements-profile-title' => 'Ang $2 {{PLURAL:$2|tsapa|mga tsapa}}ng nakamit na ni $1',
	'achievements-profile-title-challenges' => 'Marami pang mga tsapang maaari mong makamit!',
	'achievements-profile-customize' => 'Ipasadya ang mga tsapa',
	'achievements-ranked' => 'Hinanay na #$1 sa wiking ito',
	'achievements-viewall' => 'Tingnang lahat',
	'achievements-viewless' => 'Isara',
	'achievements-profile-title-oasis' => 'nakamit <br /> na mga pangpuntos',
	'achievements-ranked-oasis' => 'Si $1 ay [[Special:Leaderboard|Nasa ranggong #$2]] sa wiking ito',
	'achievements-viewall-oasis' => 'Tingnan ang lahat',
	'achievements-toggle-hide' => 'Itago mula sa lahat ang mga nagawa kong nasa aking balangkas',
	'leaderboard-intro-hide' => 'itago',
	'leaderboard-intro-open' => 'buksan',
	'leaderboard-intro-headline' => 'Ano ba ang mga Naisagawa?',
	'leaderboard-intro' => "Magkakamit ka ng mga tsapa sa wiking ito sa pamamagitan ng pamamatnugot ng mga pahina, pagkakarga ng mga larawan at pag-iiwan ng mga puna. Bawat tsapa ay nagbibigay sa iyo ng mga puntos - kung mas marami ang mga puntos na nakuha mo, mas mataas ang kalalagyan mo sa pisara ng mga nangunguna! Matatagpuan mo ang mga tsapang nakamit mo doon sa iyong [[$1|pahina ng balangkas ng tagagamit]].

'''Ano ba ang halaga ng mga tsapa?'''",
	'leaderboard' => 'Pinunong pisara ng mga nakamit',
	'achievements-title' => 'Mga nagawa',
	'leaderboard-title' => 'Pangunahing-pisara',
	'achievements-recent-earned-badges' => 'Kamakailang Nakamit na mga Tsapa',
	'achievements-recent-info' => 'Ang <strong>$3</strong><br />$4<br />ay nakamtan ni <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'nagkamit ng strong><a href="$3" class="badgeName">$1</a></strong> tsapang<br />$2',
	'achievements-leaderboard-disclaimer' => 'Ipinapakita ng pangunahing pisara ang mga pagbabago magmula kahapon',
	'achievements-leaderboard-rank-label' => 'Ranggo',
	'achievements-leaderboard-member-label' => 'Kasapi',
	'achievements-leaderboard-points-label' => 'Mga puntos',
	'achievements-leaderboard-points' => '{{PLURAL:$1|puntos|mga puntos}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Pinaka kamakailang nakamit',
	'achievements-send' => 'Sagipin ang larawan',
	'achievements-save' => 'Sagipin ang mga pagbabago',
	'achievements-reverted' => 'Ibinalik ang tsapa sa orihinal.',
	'achievements-customize' => 'Ipasadya ang larawan',
	'achievements-customize-new-category-track' => 'Lumikha ng bagong bakas para sa kategorya:',
	'achievements-enable-track' => 'pinagana na',
	'achievements-revert' => 'Manumbalik sa likas na katakdaan',
	'achievements-special-saved' => 'Nasagip na ang mga pagbabago.',
	'achievements-special' => 'Natatanging mga nagawa',
	'achievements-secret' => 'Lihim na mga nagawa',
	'achievementscustomize' => 'Ipasadya ang mga tsapa',
	'achievements-about-title' => 'Tungkol sa pahinang ito...',
	'achievements-about-content' => 'Ang mga tagapangasiwa sa wiking ito ay makapagpapasadya ng mga pangalan at mga larawan ng mga tsapa para sa mga nagawa.

Makapagkakarga kang paitaas ng anumang larawang .jpg o .png, at ang larawan mo ay kusang lalapat sa kuwadro.
Pinaka mainam kung ang larawan mo ay parisukat, at kung ang pinakamahalagang bahagi ng larawan ay nasa gitna.

Maaari kang gumamit ng mga larawang parihaba, subalit maaari mong matagpuan na ang kaunti ay magugupit ng kuwadro.
Kung mayroon kang isang programang panggrapiks, kung gayon maaani mo ang larawan upang mailagay ang mahalagang bahagi ng larawan sa gitna.
Kung wala kang programang panggrapiks, kung gayon mag-eksperimento na lamang sa iba\'t ibang mga larawan hanggang sa matagpuan mo ang mga magiging pinaka mainam para sa iyo!
Kung hindi mo gusto ang larawang napili mo, pindutin ang "{{int:achievements-revert}}" upang bumalik sa orihinal na grapiko.

Maaari mo ring bigyan ng mga bagong mga pangalan ang mga tsapa na magpapakilala ng paksa ng wiki.
Kapag nabago mo na ang mga pangalan ng tsapa, pindutin ang "{{int:achievements-save}}" upang masagip ang mga pagbabago mo.
Masiyahan ka sana!',
	'achievements-edit-plus-category-track-name' => '$1 pagpatnugot ng bakas',
	'achievements-create-edit-plus-category-title' => 'Lumikha ng isang bagong bakas ng Pamamatnugot',
	'achievements-create-edit-plus-category' => 'Likhain ang bakas na ito',
	'platinum' => 'Platinum',
	'achievements-community-platinum-awarded-email-subject' => 'Ginawaran ka ng isang bagong tsapang Platinum!',
	'achievements-community-platinum-awarded-for' => 'Iginawad para sa:',
	'achievements-community-platinum-how-to-earn' => 'Paano magkamit:',
	'achievements-community-platinum-awarded-for-example' => 'iyon ay "para sa paggawa ng..."',
	'achievements-community-platinum-how-to-earn-example' => 'iyon ay "gumawa ng 3 mga pamamatnugot..."',
	'achievements-community-platinum-badge-image' => 'Larawan ng tsapa:',
	'achievements-community-platinum-awarded-to' => 'Iginawad kay:',
	'achievements-community-platinum-current-badges' => 'Pangkasalukuyang mga tsapang platinum',
	'achievements-community-platinum-create-badge' => 'Likhain ang tsapa',
	'achievements-community-platinum-enabled' => 'pinagana',
	'achievements-community-platinum-show-recents' => 'ipakita sa kamakailang mga tsapa',
	'achievements-community-platinum-edit' => 'baguhin',
	'achievements-community-platinum-save' => 'sagipin',
	'achievements-community-platinum-cancel' => 'huwag ituloy',
	'achievements-community-platinum-sponsored-label' => 'naisagawang may tagapagtaguyod',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Palutangin ang larawan <small>(pinakamaliit na sukat ng paglutang: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => 'Sinusubaybayan ang URL para sa mga kintal ng tsapa:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => 'Sinusubaybayan ang URL para kintal ng Paglutang:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Pindutin para sa mas maraming kabatiran',
	'achievements-badge-name-edit-0' => 'Paggawa ng isang Kaibahan',
	'achievements-badge-name-edit-1' => 'Ang Simula Lamang',
	'achievements-badge-name-edit-2' => 'Paggawa ng Tanda Mo',
	'achievements-badge-name-edit-3' => 'Kaibigan ng Wiki',
	'achievements-badge-name-edit-4' => 'Kasapakat',
	'achievements-badge-name-edit-5' => 'Tagapagtayo ng Wiki',
	'achievements-badge-name-edit-6' => 'Pinuno ng Wiki',
	'achievements-badge-name-edit-7' => 'Dalubhasa ng Wiki',
	'achievements-badge-name-picture-0' => 'Kuha ng kamera',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Dibuhista',
	'achievements-badge-name-picture-3' => 'Tagalikom',
	'achievements-badge-name-picture-4' => 'Mangingibig ng Sining',
	'achievements-badge-name-picture-5' => 'Tagapagpalamuti',
	'achievements-badge-name-picture-6' => 'Tagapagdisenyo',
	'achievements-badge-name-picture-7' => 'Kurador',
	'achievements-badge-name-category-0' => 'Gumawa ng isang Kaugnayan',
	'achievements-badge-name-category-1' => 'Tagapaglagablab ng Landas',
	'achievements-badge-name-category-2' => 'Manggagalugad',
	'achievements-badge-name-category-3' => 'Gabay sa Paglilibot',
	'achievements-badge-name-category-4' => 'Maglalayag',
	'achievements-badge-name-category-5' => 'Tagapagtayo ng Tulay',
	'achievements-badge-name-category-6' => 'Tagapagplano ng Wiki',
	'achievements-badge-name-blogpost-0' => 'Isang bagay na masasabi',
	'achievements-badge-name-blogpost-1' => 'Limang mga Bagay na masasabi',
	'achievements-badge-name-blogpost-2' => 'Palabas ng Usapan',
	'achievements-badge-name-blogpost-3' => 'Buhay ng handaan',
	'achievements-badge-name-blogpost-4' => 'Tagapagsalita na Pangmadla',
	'achievements-badge-name-blogcomment-0' => 'Tagapagwari',
	'achievements-badge-name-blogcomment-1' => 'At isa pang bagay',
	'achievements-badge-name-love-0' => 'Susi papunta sa Wiki!',
	'achievements-badge-name-love-1' => 'Dalawang linggo sa wiki',
	'achievements-badge-name-love-2' => 'Tapat',
	'achievements-badge-name-love-3' => 'Nakalaan',
	'achievements-badge-name-love-4' => 'Nagumon',
	'achievements-badge-name-love-5' => 'Isang buhay sa Wiki',
	'achievements-badge-name-love-6' => 'Bayani ng Wiki!',
	'achievements-badge-name-sharing-0' => 'Tagapagbahagi',
	'achievements-badge-name-sharing-1' => 'Dalhin itong pabalik',
	'achievements-badge-name-sharing-2' => 'Tagapagsalita',
	'achievements-badge-name-sharing-3' => 'Tagapagpahayag',
	'achievements-badge-name-sharing-4' => 'Ebanghelista',
	'achievements-badge-name-welcome' => 'Maligayang pagdating sa Wiki',
	'achievements-badge-name-introduction' => 'Pagpapakilala',
	'achievements-badge-name-sayhi' => 'Dumaan upang makapagsabi ng kumusta',
	'achievements-badge-name-creator' => 'Ang Manlilikha',
	'achievements-badge-name-pounce' => 'Sagpangin!',
	'achievements-badge-name-caffeinated' => 'May kapeina',
	'achievements-badge-name-luckyedit' => 'Mapalad na pamamatnugot',
	'achievements-badge-to-get-welcome' => 'sumali sa wiki',
	'achievements-badge-to-get-introduction' => 'idagdag sa sarili mong pahina ng tagagamit',
	'achievements-badge-to-get-sayhi' => 'mag-iwan sa isang tao ng isang mensahe sa kanilang pahina ng usapan',
	'achievements-badge-to-get-creator' => 'maging manlilikha ng wiking ito',
	'achievements-badge-to-get-pounce' => 'maging mabilis',
	'achievements-badge-to-get-luckyedit' => 'maging mapalad',
	'achievements-badge-to-get-sharing-details' => 'Ibahagi ang mga kawing at kumuha ng iba pa na pipindot sa kanila!',
	'achievements-badge-to-get-edit-details' => 'May nawawala ba?
May mali ba?
Huwag mahiya.
Lagitikin ang pindutang "{{int:edit}}" at makapagdaragdag ka sa anumang pahina!',
	'achievements-badge-to-get-luckyedit-details' => 'Maaaring mapalad ka upang makamit ang tsapang ito.
Magpatuloy sa pamamatnugot!',
	'achievements-badge-to-get-community-platinum-details' => 'Isa itong natatanging tsapang Platinum na makukuha lamang sa loob ng isang panahong may hangganan!',
	'achievements-badge-hover-desc-creator' => 'para sa paglikha ng wiki!',
	'achievements-badge-hover-desc-pounce' => 'para sa paggawa ng mga pamamatnugot sa 100 mga pahina sa loob ng isang oras pagkaraan ng pagkakalikha ng pahina!',
	'achievements-badge-hover-desc-caffeinated' => 'para sa paggawa ng 100 mga pamamatnugot sa loob ng isang araw!',
	'achievements-badge-hover-desc-luckyedit' => 'para sa paggawa ng Mapalad na ika-$1 na Pamamatnugot sa wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Isa itong natatanging tsapang Platinum na makukuha lamang sa loob ng isang panahong may hangganan!',
	'achievements-badge-your-desc-welcome' => 'Iginantimpala para sa pagsali sa wiki!',
	'achievements-badge-your-desc-introduction' => 'Iginantimpala para sa pagdaragdag sa sarili mong pahina ng tagagamit!',
	'achievements-badge-your-desc-sayhi' => 'Iginantimpala para sa pag-iiwan ng isang mensahe sa pahina ng usapan ng ibang tao!',
	'achievements-badge-your-desc-creator' => 'Iginantimpala para sa paglikha ng wiki!',
	'achievements-badge-your-desc-pounce' => 'Iginantimpala para sa paggawa ng mga pamamatnugot sa 100 mga pahina sa loob ng isang oras pagkaraan ng pagkakalikha ng pahina!',
	'achievements-badge-your-desc-caffeinated' => 'Iginantimpala para sa paggawa ng 100 mga pamamatnugot sa loob ng isang araw!',
	'achievements-badge-your-desc-luckyedit' => 'Iginantimpala para sa paggawa ng Mapalad na ika-$1 na pamamatnugot sa wiki!',
	'achievements-badge-desc-welcome' => 'para sa pagsali sa wiki!',
	'achievements-badge-desc-introduction' => 'para sa pagdaragdag sa sarili mong pahina ng tagagamit!',
	'achievements-badge-desc-sayhi' => 'para sa pag-iiwan ng isang mensahe sa pahina ng usapan ng ibang tao!',
	'achievements-badge-desc-creator' => 'para sa paglikha ng wiki!',
	'achievements-badge-desc-pounce' => 'para sa paggawa ng mga pamamatnugot sa 100 mga pahina sa loob ng isang oras pagkaraan ng pagkakalikha ng pahina!',
	'achievements-badge-desc-caffeinated' => 'para sa paggawa ng 100 mga pamamatnugot sa loob ng isang araw!',
	'achievements-badge-desc-luckyedit' => 'para sa paggawa ng Mapalad na ika-$1 na pamamatnugot sa wiki!',
	'achievements-userprofile-title-no' => 'Nakamit na mga Tsapa ni $1',
	'achievements-userprofile-no-badges-visitor' => 'Ang tagagamit na ito ay hindi pa nagkakamit ng anumang tsapa.',
);

$messages['tly'] = array(
	'achievements-gold' => 'Телы',
	'achievements-silver' => 'Нығә',
	'achievements-bronze' => 'Бырынҹ',
	'achievements-masthead-points' => '',
	'achievements-viewall' => 'Бә һәммәј дијә кардеј',
	'achievements-viewless' => 'Жәј',
	'achievements-viewall-oasis' => 'Һәммәј дијә кардеј',
	'leaderboard-intro-hide' => 'нијо кардеј',
	'leaderboard-intro-open' => 'окардеј',
	'achievements-leaderboard-member-label' => 'Иштирокәкә',
	'achievements-save' => 'Дәгишон огәтеј',
	'achievements-special-saved' => 'Дәгишон огәтә быән.',
	'achievements-community-platinum-badge-image' => 'Нышони шикил:',
	'achievements-community-platinum-awarded-to' => 'Мыджәвони сәше:',
	'achievements-community-platinum-create-badge' => 'Нышон сохтеј',
	'achievements-community-platinum-enabled' => 'дахыл кардә быә',
	'achievements-community-platinum-show-recents' => 'нишо дој охонә нышонон сијоһиәдә',
	'achievements-community-platinum-edit' => 'сәрост кардеј',
	'achievements-community-platinum-save' => 'огәтеј',
	'achievements-community-platinum-cancel' => 'ләғв кардеј',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Егәтән бо зијодә мәлумоти сәј горнә',
	'achievements-badge-name-blogpost-0' => 'Чичсә вотеј',
	'achievements-badge-name-welcome' => 'Бә Вики хәш омәјон',
	'achievements-badge-name-sayhi' => 'Вәсе "Сәлом" вотеј',
);

$messages['tr'] = array(
	'achievementsii-desc' => 'Viki kullanıcıları için bir başarı nişanı sistemi',
	'achievements-upload-error' => 'Üzgünüz!
Bu resim çalışmıyor.
.jpg ya da .png dosyası olduğundan emin olun.
Eğer hala çalışmazsa, resim çok büyük olabilir.
Lütfen bir başkasını deneyin.',
	'achievements-non-existing-category' => 'Belirtilen kategori yok.',
	'achievements-platinum' => 'Altın',
	'achievements-gold' => 'Altın',
	'achievements-silver' => 'Gümüş',
	'achievements-bronze' => 'Bronz',
	'achievements-gold-points' => '100<br /> puan',
	'achievements-silver-points' => '50<br /> puan',
	'achievements-bronze-points' => '10<br />puan',
	'achievements-you-must' => 'Bu rozeti kazanmak için 1$\'a ihtiyacınız var.',
	'achievements-profile-title-no' => '$1 kişisinin rozetleri',
	'achievements-profile-title-challenges' => 'Daha fazla rozet kazanabilirsin!',
	'achievements-profile-customize' => 'Rozetleri düzenle',
	'achievements-ranked' => "Bu wiki'de #$1 oldun",
	'achievements-viewall' => 'Hepsini göster',
	'achievements-viewless' => 'Kapat',
	'achievements-viewall-oasis' => 'Hepsini gör',
	'achievements-toggle-hide' => 'Puanları, rozetleri ve sıralamamı profilimde gösterme',
	'leaderboard-intro-hide' => 'gizle',
	'leaderboard-intro-open' => 'aç',
	'leaderboard-title' => 'Sıralama',
	'achievements-recent-earned-badges' => 'Son Kazanılan Rozetler',
	'achievements-leaderboard-rank-label' => 'Sıralama',
	'achievements-leaderboard-member-label' => 'Üye',
	'achievements-leaderboard-points-label' => 'Puan',
	'achievements-leaderboard-most-recently-earned-label' => 'Son kazanılanlar',
	'achievements-send' => 'Resmi kaydet',
	'achievements-save' => 'Değişiklikleri kaydet',
	'achievements-customize' => 'Resmi düzenle',
	'achievements-enable-track' => 'etkin',
	'achievements-special-saved' => 'Değişiklikler kaydedildi.',
	'achievementscustomize' => 'Rozetleri düzenle',
	'achievements-about-title' => 'Bu sayfa hakkında...',
	'platinum' => 'Altın',
	'achievements-community-platinum-awarded-for' => 'Ödül sebebi:',
	'achievements-community-platinum-how-to-earn' => 'Nasıl kazanılır:',
	'achievements-community-platinum-awarded-for-example' => 'örneğin "... yapmak için"',
	'achievements-community-platinum-how-to-earn-example' => 'örneğin "3 düzenleme yap"',
	'achievements-community-platinum-badge-image' => 'Rozet görseli:',
	'achievements-community-platinum-current-badges' => 'Mevcut platin rozetler',
	'achievements-community-platinum-create-badge' => 'Rozet oluştur',
	'achievements-community-platinum-enabled' => 'etkin',
	'achievements-community-platinum-show-recents' => 'son kazanılan rozetlerde göster',
	'achievements-community-platinum-edit' => 'değiştir',
	'achievements-community-platinum-save' => 'kaydet',
	'achievements-community-platinum-cancel' => 'iptal et',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Daha fazla bilgi için tıkla',
	'achievements-badge-name-edit-0' => 'Bir Fark Yaratmak',
	'achievements-badge-name-edit-1' => 'Sadece Başlangıç',
	'achievements-badge-name-edit-3' => 'Viki Dost',
	'achievements-badge-name-edit-4' => 'İşbirlikçi',
	'achievements-badge-name-edit-5' => 'Wiki Oluşturucu',
	'achievements-badge-name-edit-6' => 'Wiki Lideri',
	'achievements-badge-name-edit-7' => 'Wiki Uzmanı',
	'achievements-badge-name-picture-0' => 'Enstantane',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-3' => 'Koleksiyoner',
	'achievements-badge-name-picture-4' => 'Sanat Sever',
	'achievements-badge-name-picture-5' => 'Dekoratör',
	'achievements-badge-name-picture-6' => 'Tasarımcı',
	'achievements-badge-name-picture-7' => 'Küratör',
	'achievements-badge-name-category-0' => 'Bağlantı Oluştur',
	'achievements-badge-name-category-2' => 'Araştırmacı',
	'achievements-badge-name-category-3' => 'Tur Rehberi',
	'achievements-badge-name-category-6' => 'Wiki Planlayıcısı',
	'achievements-badge-name-blogpost-0' => 'Söylenecek bir şey',
	'achievements-badge-name-blogpost-1' => 'Söylenecek 5 şey',
	'achievements-badge-name-blogpost-2' => 'Talk Show',
	'achievements-badge-name-blogcomment-1' => 'Ve bir şey daha',
	'achievements-badge-name-love-1' => "Wiki'de 2 hafta",
	'achievements-badge-name-love-2' => 'Sadık',
	'achievements-badge-name-love-3' => 'Adanmış',
	'achievements-badge-name-love-4' => 'Bağımlı',
	'achievements-badge-name-love-5' => 'Bir Viki yaşamı',
	'achievements-badge-name-love-6' => 'Viki Kahramanı!',
	'achievements-badge-name-sharing-0' => 'Paylaşımcı',
	'achievements-badge-name-sharing-1' => 'Geri getir',
	'achievements-badge-name-sharing-2' => 'Konuşmacı',
	'achievements-badge-name-welcome' => "Viki'ye hoşgeldiniz",
	'achievements-badge-name-introduction' => 'Giriş',
	'achievements-badge-name-sayhi' => 'Selam vermek için durma',
	'achievements-badge-name-luckyedit' => 'Şanslı düzenleme',
	'achievements-badge-to-get-welcome' => "Viki'ye katıl",
	'achievements-badge-to-get-introduction' => 'kullanıcı sayfanızı ekleyin',
	'achievements-badge-to-get-pounce' => 'hızlı ol',
	'achievements-badge-to-get-luckyedit' => 'şanslı ol',
	'achievements-badge-hover-desc-welcome' => "Viki'ye katılmak için!",
	'achievements-badge-hover-desc-creator' => "Viki'yi yaratmak için!",
	'achievements-badge-your-desc-welcome' => 'wikiye katıldığınız için!',
	'achievements-badge-your-desc-introduction' => 'kendi kullanıcı sayfanızı eklediğiniz için!',
	'achievements-badge-your-desc-sayhi' => 'başkasının tartışma penceresine mesaj bıraktığınız için!',
	'achievements-badge-your-desc-creator' => 'wiki oluşturduğunuz için!',
	'achievements-badge-your-desc-pounce' => 'sayfa oluşturulduktan sonraki 1 saat içinde 100 değişiklik yaptığınız için!',
	'achievements-badge-your-desc-caffeinated' => 'bir gün içinde 100 değişiklik yaptığınız için!',
	'achievements-badge-your-desc-luckyedit' => 'wikide Şanslı $1 sayılı düzenlemeyi yaptığın için!',
	'achievements-badge-desc-welcome' => 'wikiye katıldığın için!',
	'achievements-badge-desc-introduction' => 'kendi kullanıcı sayfanı eklediğin için!',
	'achievements-badge-desc-sayhi' => 'başkasının tartışma sayfasına mesaj bıraktığın için!',
	'achievements-badge-desc-creator' => 'wiki oluşturduğun için!',
);

$messages['tt-cyrl'] = array(
	'achievementsii-desc' => 'Вики-сайт кулланучыларның казанышлар системасы',
	'achievements-upload-error' => 'Гафу итегез!
Бу рәсем туры килми.
Файлның .JPG яки .PNG форматында булуын тикшерегез.
Әгәр барыбер эшләми икән, димәк, рәсем артык зур.
Зинһар, тагын бер кат эшләп карагыз!',
	'achievements-upload-not-allowed' => ' Идарәчеләр [[Special:AchievementsCustomize|Казанышлар белән идарә итү]]  дигән махсус биттә тамгаларның исемнәрен һәм рәсемнәрен үзгәртә алалар',
	'achievements-non-existing-category' => 'Күрсәтелгән төркем юк.',
	'achievements-edit-plus-category-track-exists' => 'Күрсәтелгән төркемгә <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Трекка күчәргә ">трек куелган инде</a>.',
	'achievements-no-stub-category' => 'Зинһар өчен, төпчекләр өчен треклар ясамагыз',
	'right-platinum' => 'Платина тамгаларын төзү һәм төзәтү',
	'right-sponsored-achievements' => 'Реклама казанышлары белән идарә итү',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Алтын',
	'achievements-silver' => 'Көмеш',
	'achievements-bronze' => 'Бронза',
	'achievements-gold-points' => '100<br />балл',
	'achievements-silver-points' => '50<br />балл',
	'achievements-bronze-points' => '10<br />балл',
	'achievements-you-must' => 'Бу тамганы алыр өчен, сезгә $1 кирәк',
	'leaderboard-button' => 'Казанышлар буенча лидерлар',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|балл|балл}}</small>',
	'achievements-profile-title-no' => '$1 катнашучысының тамгалары',
	'achievements-no-badges' => 'Бу викида яулап алырга мөмкин булган тамгалар исемлеген карагыз!',
	'achievements-track-name-edit' => 'Трекны үзгәртү',
	'achievements-track-name-picture' => 'Трекның рәсеме',
	'achievements-track-name-category' => 'Трекның төркеме',
	'achievements-track-name-blogpost' => 'Трек блогында хәбәр',
	'achievements-track-name-blogcomment' => 'Блок шәрехләре рәте',
	'achievements-track-name-love' => 'Вики-мәхәббәт трегы',
	'achievements-track-name-sharing' => 'Трекны бүлү',
	'achievements-notification-title' => 'Менә шулай, $1!',
	'achievements-notification-subtitle' => 'Сез  $2 "$1" тамгасын  яулап алдыгыз',
	'achievements-notification-link' => '<big><strong>[[Special:MyPage|Нинди тамгалар алып булганын карагыз]]!</strong></big>',
	'achievements-points' => '$1 {{PLURAL:$1|балл|баллар}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|балл|баллар}}',
	'achievements-earned' => 'Бу тамга $1 {{PLURAL:$1|катнашучы}} тарафыннан яулап алынды',
	'achievements-profile-title' => '$1 катнашучы $2 {{PLURAL:$2|тамга}} яулап алды',
	'achievements-profile-title-challenges' => 'Өстәмә тамгалар алып була!',
	'achievements-profile-customize' => 'Тамгаларны төзәтү',
	'achievements-ranked' => 'Бу викида #$1 дәрәҗәсе',
	'achievements-viewall' => 'Барысын да карау',
	'achievements-viewless' => 'Ябу',
	'achievements-profile-title-oasis' => 'казанышларның <br /> баллы',
	'achievements-ranked-oasis' => '$1 бу вики-сайтта [[Special:Leaderboard|#$2 урында]]',
	'achievements-viewall-oasis' => 'Барысын да карау',
	'achievements-toggle-hide' => 'Минем профайлда казанышларымны барысыннан да яшерергә.',
	'leaderboard-intro-hide' => 'яшерү',
	'leaderboard-intro-open' => 'ачу',
	'leaderboard-intro-headline' => 'Нәрсә ул казанышлар?',
	'leaderboard-intro' => "Сез бу Викида мәкаләләрне төзәтеп, фотолар кертеп һәм шәрехләр калдырып, тамгалар казана аласыз. Һәр тамга баллар бирә - күбрәк баллар җыйган саен, лидерлар җәдвәлендә сез зуррак урында булачаксыз! Сез яулаган тамгаларыгызны [[$1|кулланучы битендә]] карый аласыз.

'''Нәрсә ул тамгалар?'''",
	'leaderboard' => 'Казанышлар буенча лидерлар',
	'achievements-title' => 'Казанышлар',
	'leaderboard-title' => 'Җиңүчеләр исемлеге',
	'achievements-recent-earned-badges' => 'Соңгы казанган тамгалар',
	'achievements-recent-info' => "<strong>$3</strong><br />$4<br /> <a href=''$1''>$2</a><br />$5 казанды",
	'achievements-activityfeed-info' => '<a href="$3" class="badgeName"><strong>$1</strong></a>  <br /> $2 тамгасын казанды',
	'achievements-leaderboard-disclaimer' => 'Лидерлар җәдвәле кичәге көннән үзгәрешләрне күрсәтә',
	'achievements-leaderboard-rank-label' => 'Дәрәҗә',
	'achievements-leaderboard-member-label' => 'Катнашучы',
	'achievements-leaderboard-points-label' => 'Балл',
	'achievements-leaderboard-points' => '$1 {{PLURAL:$1|балл|балл}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Яңа казанышлар',
	'achievements-send' => 'Рәсемне саклау',
	'achievements-save' => 'Үзгәртүләрне саклау',
	'achievements-reverted' => 'Тамга элеккеге версияга кайтарылган',
	'achievements-customize' => 'Рәсемне төзәтү',
	'achievements-customize-new-category-track' => 'Төркем өчен яңа трек ясау:',
	'achievements-enable-track' => 'кертелгән:',
	'achievements-revert' => 'Төп көйләнмәгә кайтарырга',
	'achievements-special-saved' => 'Үзгәртүләр сакланган',
	'achievements-special' => 'Махсус казанышлар',
	'achievements-secret' => 'Яшерен казанышлар',
	'achievementscustomize' => 'Тамгаларны көйләү',
	'achievements-about-title' => 'Бу бит турында...',
	'achievements-about-content' => "Бу вики-сайт идарәчеләре казанышлар исемнәрен һәм рәсемнәрен көйли алалар.

Сез JPG яки PNG форматында теләсә нинди рәсемне йөкли аласыз, һәм сезнең рәсем автомат рәвештә кыса эченә көйләнәчәк.
Бу әгәр сезнең рәсем квадрат рәвешендә, һәм, рәсемнең иң мөһим өлеше уртада булганда, яхшырак эшләячәк

Сез турыпочмаклы рәсемнәр куллана аласыз, ләкин алар кысаның зурлыгына бәйле рәвештә киселәчәкләр.
Әгәр сездә теләсә нинди график редактор бар икән, сез рәсемнең иң мөһим өлеше уртада калырлык итеп, аны кисә аласыз.
Әгәр сезнең график программа юк икән, сезгә туры килердәй рәсем тапканчы, төрле рәсемнәр белән экспериментлар үткәреп карагыз!
Әгәр  сезгә үзегез сайлаган рәсем ошамый икән, оригиналь рәсемне кире кайтарыр өчен,  ''{{int:achievements-revert}}'' чирттерегез.

Сез тамгаларга вики-сайтның темасын яктыртучы яңа исемнәр дә бирә аласыз.
Тамганың исемен үзгәрткәч, үзгәртүләрне саклар өчен, ''{{int:achievements-save}}'' басыгыз.
Уңышлар!",
	'achievements-edit-plus-category-track-name' => '$1 трек үзгәртелгән',
	'achievements-create-edit-plus-category-title' => 'Яңа трек ясау',
	'achievements-create-edit-plus-category-content' => 'Сез ике төрле төркем өчен ике трек ясап, катнашучылар арасында бәйгеләр оештыра аласыз!
Мәсәлән, Татарлар һәм Башкортлар, авыллар һәм шәһәрләр арасында. Шулай ук, Былтыр атнасын яки корал атнасын үткәрергә мөмкин.

Яңа трек ясар өчен, астагы юлда төркем исемен языгыз. Стандарт треклар бу очракта үзгәрмәячәкләр;
Сез ирекле рәвештә үзгәртерлек аерым трек ясаячаксыз.

Яңа трек ясагач та, яңа тамгалар сулдагы исемлектә стандарт тамгалар белән бергә булачаклар.
Яңа трек тамгаларының исемнәрен һәм рәсемнәрен көйләгез!

Яңа трек көйләнмәләрен тәмамлагач, яңа трекны кушыр өчен, "{{int:achievements-enable-track}}" дигән урында әләм куегыз, ә аннары "{{int:achievements-save}}" төймәсенә басыгыз.
Боларны эшләгәч тә, катнашучылар яңа трек төркемендәге мәкаләләрне үзгәрткән өчен яңа тамгалар алачаклар.
Сез трекны теләсә кайсы вакытта сүндерә аласыз.
Ул төркем тамгаларын үзгәрткән катнашучылар яулап алган тамгаларын югалтмаячаклар, тамга аларда гел булачак.

Яңа треклар сезнең Викидә төрле бүлекләрнең үсеше өчен ярдәм итәчәк.
Уңышлар!',
	'achievements-create-edit-plus-category' => 'Трек ясау',
	'platinum' => 'Платина',
	'achievements-community-platinum-awarded-email-subject' => 'Сез яңа платиналы тамга алдыгыз!',
	'achievements-community-platinum-awarded-email-body-text' => 'Котлыйбыз $1!

Сез $4 ($3) сайтында «$2» платиналы тамгасы белән бүләкләндегез!
Ул сезнең гомуми хисапка 250 балл өсти!

Яңа тамганы кулланучы сәхифәсендә карагыз:

$5',
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Котлыйбыз $1!</strong><br /><br />
Сез <a href="$3">$4</a> сайтында яңа гына  «<strong>$2</strong>» платина билгесе белән бүләкләндегез!
Ул сезнең гомуми хисапка 250 балл өсти!<br /><br />
Яңа тамганы  <a href="$5">кулланучы профиле сәхифәсендә карагыз</a>.',
	'achievements-community-platinum-awarded-for' => 'Бүләкләнү сәбәбе:',
	'achievements-community-platinum-how-to-earn' => 'Ничек казанырга:',
	'achievements-community-platinum-awarded-for-example' => 'мәсәлән, "моның өчен..."',
	'achievements-community-platinum-how-to-earn-example' => 'мәсәлән, "өч үзгәртү ясарга..."',
	'achievements-community-platinum-badge-image' => 'Тамганың рәсеме:',
	'achievements-community-platinum-awarded-to' => 'Бүләкләнгән:',
	'achievements-community-platinum-current-badges' => 'Хәзерге платина тамгалары',
	'achievements-community-platinum-create-badge' => 'Тамга ясарга',
	'achievements-community-platinum-enabled' => 'кертелгән',
	'achievements-community-platinum-show-recents' => 'соңгы тамгалар исемлегендә күрсәтергә',
	'achievements-community-platinum-edit' => 'үзгәртү',
	'achievements-community-platinum-save' => 'саклау',
	'achievements-community-platinum-cancel' => 'Кире кагу',
	'achievements-community-platinum-sponsored-label' => 'Реклама казанышлары',
	'achievements-community-platinum-sponsored-hover-content-label' => 'Рәсем якынлаштырылгач <small>(минималь зурлык: 270px х 100px)</small>',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => ' URL-адресны тамгалардан туган тәэсирләр өчен күзәтү:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => ' URL-адресны тамгалардан туган тәэсирләр өчен күзәтү:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => 'Тамгага сылтама <small>(DART URL-адрес командасына басыгыз)</small>:',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => 'Өстәмә мәгълүмат өчен чирттерегез',
	'achievements-badge-name-edit-0' => 'Үзгәртүләр кертх',
	'achievements-badge-name-edit-1' => 'Бу әле башы гына',
	'achievements-badge-name-edit-2' => 'Төзәтмә кую',
	'achievements-badge-name-edit-3' => "Wiki'ның дусты",
	'achievements-badge-name-edit-4' => 'Хезмәттәш',
	'achievements-badge-name-edit-5' => 'Wiki төзүчесе',
	'achievements-badge-name-edit-6' => 'Wiki лидеры',
	'achievements-badge-name-edit-7' => 'Wiki эксперты',
	'achievements-badge-name-picture-0' => 'Оста фотограф',
	'achievements-badge-name-picture-1' => 'Папарацци',
	'achievements-badge-name-picture-2' => 'Бизәлеш остасы',
	'achievements-badge-name-picture-3' => 'Җыючы',
	'achievements-badge-name-picture-4' => 'Сәнгать сөюче',
	'achievements-badge-name-picture-5' => 'Декоратор',
	'achievements-badge-name-picture-6' => 'Дизайнер',
	'achievements-badge-name-picture-7' => 'Ярдәмче',
	'achievements-badge-name-category-0' => 'Элемтә тудыручы',
	'achievements-badge-name-category-1' => 'Яңартучы',
	'achievements-badge-name-category-2' => 'Тикшеренүче',
	'achievements-badge-name-category-3' => 'Өйрәтүче',
	'achievements-badge-name-category-4' => 'Оста',
	'achievements-badge-name-category-5' => 'Мөгаллим',
	'achievements-badge-name-category-6' => 'Акыл иясе',
	'achievements-badge-name-blogpost-0' => 'Ни дә булса әйтергә',
	'achievements-badge-name-blogpost-1' => 'Биш фикер әйт',
	'achievements-badge-name-blogpost-2' => 'Әңгәмә',
	'achievements-badge-name-blogpost-3' => 'Сүз остасы',
	'achievements-badge-name-blogpost-4' => 'Фикер иясе',
	'achievements-badge-name-blogcomment-0' => 'Акын',
	'achievements-badge-name-blogcomment-1' => 'Тагын бер фикер',
	'achievements-badge-name-love-0' => ' Викигә ачкыч!',
	'achievements-badge-name-love-1' => 'Викидә ике атна',
	'achievements-badge-name-love-2' => 'Тугрылыклы',
	'achievements-badge-name-love-3' => 'Ышанычлы',
	'achievements-badge-name-love-4' => 'Бирелгән',
	'achievements-badge-name-love-5' => 'Вики-тормыш',
	'achievements-badge-name-love-6' => 'Вики батыры!',
	'achievements-badge-name-sharing-0' => 'Саран түгел',
	'achievements-badge-name-sharing-1' => 'Кире кайт',
	'achievements-badge-name-sharing-2' => 'Әңгәмәдәш',
	'achievements-badge-name-sharing-3' => 'Сүз остасы',
	'achievements-badge-name-sharing-4' => 'Вәгазьче',
	'achievements-badge-name-welcome' => 'Викига рәхим итегез',
	'achievements-badge-name-introduction' => 'Кереш',
	'achievements-badge-name-sayhi' => '"Сәлам" дә, "сәлам"... Җитәр инде!',
	'achievements-badge-name-creator' => 'Барлыкка китерүче',
	'achievements-badge-name-pounce' => 'Ыргылу!',
	'achievements-badge-name-caffeinated' => 'Кофеинлы',
	'achievements-badge-name-luckyedit' => 'Куанычлы төзәтмә',
	'achievements-badge-to-get-edit' => '{{PLURAL:$1|мәкаләдә}}   $1{{PLURAL:$1|төзәтмә}} ясаган!',
	'achievements-badge-to-get-edit-plus-category' => '{{PLURAL:$1|$2 мәкаләдә}}  {{PLURAL:$1|бер төзәтмә|$1 төзәтмә}}  ясаган!',
	'achievements-badge-to-get-picture' => '{{PLURAL:$1|мәкаләгә}}  {{PLURAL:$1|сурәт өстәгән өчен}}',
	'achievements-badge-to-get-category' => '{{PLURAL:$1|төркемгә}} $1 {{PLURAL:$1|мәкалә}} өстәгән өчен бүләк!',
	'achievements-badge-to-get-creator' => 'бу викине барлыкка китерүче булып тора',
	'achievements-badge-to-get-pounce' => 'тиз булу',
	'achievements-badge-to-get-edit-details' => 'Ни дә булса җитмиме?
Хаталар бармы?
Кыенсынмагыз.
Сәхифәнең эчтәлеген төзәтер өчен, "{{int:edit}}" төймәсенә басыгыз!',
	'achievements-badge-to-get-community-platinum-details' => 'Бу билгеле бер вакыт эчендә генә эшләүче махсус платиналы тамга!',
	'achievements-badge-hover-desc-edit' => ' {{PLURAL:$1|биттә}} $1  <br /> {{PLURAL:$1|төзәтмә}} ясаган өчен!',
	'achievements-badge-hover-desc-edit-plus-category' => '{{PLURAL:$1|$2 мәкаләдә|$2 мәкаләләрендә}} $1 {{PLURAL:$1|төзәтмә}} <br /> ясаган өчен бүләк!',
	'achievements-badge-hover-desc-picture' => '{{PLURAL:$1|биттә}} $1  <br /> {{PLURAL:$1|рәсем}} өстәгән өчен бүләк!',
	'achievements-badge-hover-desc-category' => '{{PLURAL:$1|төркемгә}} $1 {{PLURAL:$1|мәкалә}} өстәгән өчен бүләк!',
	'achievements-badge-hover-desc-blogpost' => 'Блогта $1 {{PLURAL:$1|хәбәр}} язган өчен бүләк!',
	'achievements-badge-hover-desc-blogcomment' => ' {{PLURAL:$1|Блогта төрле хәбәрләргә}}<br />
җаваплар язган өчен!',
	'achievements-badge-hover-desc-love' => '{{PLURAL:$1|көн}} эчендә викигә ясаган кертем өчен бүләкк',
	'achievements-badge-hover-desc-welcome' => 'Викигә кушылган өчен бүләк!',
	'achievements-badge-hover-desc-introduction' => 'Үз битеңне<br />өстәгән өчен бүләк!',
	'achievements-badge-hover-desc-creator' => 'Вики төзегән өчен бүләк!',
	'achievements-badge-hover-desc-community-platinum' => 'Бу билгеле бер вакыт эчендә генә эшләүче махсус платиналы тамга!',
	'achievements-badge-your-desc-love' => '{{PLURAL:$1|көн}} эчендә викигә ясаган кертем өчен бүләкк',
	'achievements-badge-your-desc-welcome' => 'Викигә кушылган өчен!',
	'achievements-badge-your-desc-introduction' => 'Үз сәхифәңне өстәгән өчен бүләк!',
	'achievements-badge-your-desc-sayhi' => 'Кемнең-дә булса бәхәс битендә язма калдырган өчен!',
	'achievements-badge-your-desc-creator' => 'Вики төзегән өчен бүләк!',
	'achievements-badge-desc-category' => '{{PLURAL:$1|төркемгә}} $1 {{PLURAL:$1|мәкалә}} өстәгән өчен бүләк!',
	'achievements-badge-desc-blogpost' => 'Блогта $1 {{PLURAL:$1|хәбәр}} язган өчен бүләк!',
	'achievements-badge-desc-love' => '{{PLURAL:$1|көн}} эчендә викигә ясаган кертем өчен бүләк',
	'achievements-badge-desc-welcome' => 'Викигә кушылган өчен бүләк!',
	'achievements-badge-desc-introduction' => 'Үз сәхифәңне өстәгән өчен бүләк!',
	'achievements-badge-desc-creator' => 'Вики төзегән өчен бүләк!',
	'achievements-userprofile-no-badges-owner' => 'Бу викида яулап алырга мөмкин булган тамгалар исемлеген карагыз!',
);

$messages['uk'] = array(
	'achievementsii-desc' => 'Система відзнак для користувачів',
	'achievements-upload-error' => '↓Вибачте!
Не вдалося зчитати малюнок.
Переконайтеся, що це JPG або PNG-файл.
Також може бути, що зображення завелике.
Будь ласка, спробуйте знову!',
	'achievements-upload-not-allowed' => 'Адміністратори можуть змінювати назви та фотографії відзнак на сторінці [[Special:AchievementsCustomize|Налаштування відзнак]].',
	'achievements-non-existing-category' => 'Зазначеної категорії не існує.',
	'achievements-edit-plus-category-track-exists' => 'З вказаною категорією вже <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Перейти до трека">пов\'язано трек</a>.',
	'achievements-no-stub-category' => 'Будь-ласка, не створюйте треки для заготовок.',
	'right-platinum' => 'Створення і редагування платинових відзнак',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Золото',
	'achievements-silver' => 'Срібло',
	'achievements-bronze' => 'Бронза',
	'achievements-gold-points' => '100<br>балів',
	'achievements-silver-points' => '50<br>балів',
	'achievements-bronze-points' => '10<br>балів',
	'achievements-you-must' => 'Потрібно  $1  , щоб заробити цю відзнаку.',
	'leaderboard-button' => 'Список нагороджених на вікі',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|бал|балів}}</small>',
	'achievements-profile-title-no' => 'Відзнаки користувача $1s',
	'achievements-no-badges' => 'Оглянути список відзнак, які можна заробити в цій вікі!',
	'achievements-track-name-edit' => 'Редагувати трек',
	'achievements-viewall' => 'Переглянути всі',
	'achievements-viewless' => 'Закрити',
	'achievements-profile-title-oasis' => 'відзнаки<br>бали',
	'achievements-ranked-oasis' => '$1Це [[спеціальні: Leaderboard|Займає # $2 ]] місце в рейтингу цієї вікі',
	'achievements-viewall-oasis' => 'Переглянути всі',
	'achievements-toggle-hide' => 'Приховати досягнення в моєму профілі від усіх',
	'leaderboard-intro-hide' => 'приховати',
	'leaderboard-intro-open' => 'відкрити',
	'leaderboard-intro-headline' => 'Що таке відзнаки?',
	'leaderboard' => 'Список нагороджених на вікі',
	'achievements-title' => 'Досягнення',
	'leaderboard-title' => 'Дошка перших',
	'achievements-recent-earned-badges' => 'Останні відзнаки',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />зароблено користувачем <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'заробив значок <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Дошка пошани показує зміни з учорашнього дня',
	'achievements-leaderboard-rank-label' => 'Рейтинг',
	'achievements-leaderboard-member-label' => 'Учасник',
	'achievements-leaderboard-points-label' => 'Балів',
	'achievements-leaderboard-points' => '{{PLURAL:$1|бал|бали|балів}}',
	'achievements-leaderboard-most-recently-earned-label' => 'Нещодавно отримав',
	'achievements-send' => 'Зберегти малюнок',
	'achievements-save' => 'Зберегти зміни',
	'achievements-reverted' => 'Відзнаку повернено до первісної версії.',
	'achievements-customize' => 'Налаштування зображення',
	'achievements-customize-new-category-track' => 'Створити новий трек для категорії:',
	'achievements-enable-track' => 'ввімкнено',
	'achievements-revert' => 'Відновити за замовченням',
	'achievements-special-saved' => 'Зміни збережено.',
	'achievements-special' => 'Спеціальні відзнаки',
	'achievements-secret' => 'Секретні відзнаки',
	'achievementscustomize' => 'Налаштувати відзнаки',
	'achievements-about-title' => 'Про цю сторінку...',
	'achievements-about-content' => 'Адміністратори цього вікі-сайту можуть налаштовувати назви і картинки відзнак.

Ви можете завантажити будь-яку картинку у форматі JPG або PNG, і ваша картинка автоматично підлаштується під рамку.
Найкраще виглядають квадратні картинки з найважливішою частиною картинки прямо в центрі.

Ви можете використовувати прямокутні картинки, але вони будуть обрізані, у відповідності з розмірами рамки.
Ви можете обрізати картинку в графічному редакторі, так, щоб важлива її частина була в центрі.
Якщо у вас немає графічних програм, то просто поекспериментуйте з різними картинками, поки не знайдете ту, яка підійде вам!
Якщо вам не подобається картинка, яку ви обрали, натисніть "{{int: achievements-revert}}" щоб повернути оригінальну картинку.

Ви також можете дати піктограм нові назви, які відображають тему вікі-сайту.
Після зміни назви відзнаки, натисніть "{{int: achievements-save}}" щоб зберегти ваші зміни.
Удачі!',
	'achievements-create-edit-plus-category-title' => 'Створити новий трек редагування',
	'achievements-community-platinum-awarded-email-subject' => 'Ви отримали нову Платинову відзнаку!',
	'achievements-community-platinum-edit' => 'редагувати',
	'achievements-community-platinum-save' => 'зберегти',
	'achievements-badge-to-get-welcome' => 'приєднатися до вікі',
	'achievements-badge-to-get-introduction' => 'додати до своєї сторінки користувача',
	'achievements-badge-to-get-sayhi' => 'залишити комусь повідомлення на його сторінці обговорення',
	'achievements-badge-to-get-creator' => 'бути засновником цієї вікі',
	'achievements-badge-to-get-pounce' => 'поспішайте',
	'achievements-badge-to-get-luckyedit' => 'щасти',
);

$messages['vep'] = array(
	'achievements-viewall' => 'Kacta kaik',
	'achievements-viewless' => 'Saubata',
	'leaderboard-intro-hide' => 'peitta',
	'leaderboard-intro-open' => 'avaita',
	'achievements-enable-track' => 'Kävutamas',
	'achievements-special-saved' => 'Toižetused oma pandud muštho',
	'platinum' => 'Platin',
	'achievements-community-platinum-edit' => 'redaktiruida',
	'achievements-community-platinum-save' => 'Kirjutada muštho',
	'achievements-community-platinum-cancel' => 'Heitta',
	'achievements-badge-name-picture-3' => 'Keradai',
	'achievements-badge-name-picture-4' => 'Čomamahton navedii',
	'achievements-badge-name-picture-5' => 'Čomitai',
	'achievements-badge-name-picture-6' => 'Dizainer',
	'achievements-badge-name-picture-7' => 'Kurator',
	'achievements-badge-name-category-0' => 'Sidoi',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-love-6' => "Wiki-vägimez'",
	'achievements-badge-name-sharing-2' => 'Pagižii',
	'achievements-badge-name-welcome' => 'Tulgat tervhin Wikihe',
	'achievements-badge-name-creator' => 'Sädai',
	'achievements-badge-to-get-pounce' => 'rigehtida',
	'achievements-badge-your-desc-creator' => 'wikin sädmas!',
);

$messages['vi'] = array(
	'achievementsii-desc' => 'Một hệ thống phù hiệu cho thành viên',
	'achievements-upload-error' => 'Rấc tiếc!
Không thể dùng ảnh đó.
Hãy chắc chắn đó là một file .jpg hoặc .png.
Nếu vẫn không dùng được, có lẽ do ảnh quá lớn.
Hãy thử những ảnh khác!',
	'achievements-non-existing-category' => 'Thể loại đã chỉ định không tồn tại',
	'achievements-platinum' => 'Bạch kim',
	'achievements-gold' => 'Vàng',
	'achievements-silver' => 'Bạc',
	'achievements-bronze' => 'Đồng',
	'achievements-gold-points' => '100<br />pts',
	'achievements-silver-points' => '50<br />pts',
	'achievements-bronze-points' => '10<br />pts',
	'achievements-you-must' => 'Bạn cần phải $1 để nhận được huy hiệu này.',
	'achievements-track-name-picture' => 'Theo dõi hình ảnh',
	'achievements-track-name-category' => 'Cây thể loại',
	'achievements-track-name-blogpost' => 'Theo dõi Blog Post',
	'achievements-notification-subtitle' => 'Bạn vừa giành được huy hiệu “$1” $2',
	'leaderboard-intro-hide' => 'ẩn',
	'leaderboard' => 'Bảng vàng thành tựu',
	'achievements-title' => 'Thành tựu',
	'leaderboard-title' => 'Bảng vàng',
	'achievements-leaderboard-rank-label' => 'Cấp bậc',
	'achievements-leaderboard-member-label' => 'Thành viên',
	'achievements-leaderboard-points-label' => 'Điểm',
	'achievements-save' => 'Lưu các thay đổi',
	'achievements-enable-track' => 'đã kích hoạt',
	'achievements-revert' => 'Trở lại mặc định',
	'platinum' => 'Bạch kim',
	'achievements-community-platinum-enabled' => 'kích hoạt',
	'achievements-community-platinum-edit' => 'sửa',
	'achievements-community-platinum-save' => 'Lưu',
	'achievements-badge-name-picture-1' => 'Tay săn ảnh',
);

$messages['zh-hans'] = array(
	'achievementsii-desc' => '一项为维基用户提供成就徽章的系统',
	'achievements-upload-error' => '对不起！
这张图片无法使用。
请确保它是一个 .jpg 或 .png 文件。
如果它仍无法使用，那么可能是因为图片大小超过标准了。
请尝试另一个文件！',
	'achievements-upload-not-allowed' => '管理员可以点击[[Special:AchievementsCustomize|自定义成就]]页面定制化徽章名称以及上传图片。',
	'achievements-non-existing-category' => '指定的类别不存在。',
	'achievements-edit-plus-category-track-exists' => '指定的类别已经有 <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">关联的轨道</a>。',
	'achievements-no-stub-category' => '请不要帮小作品创建轨道。',
	'right-platinum' => '创建和编辑白金徽章',
	'right-sponsored-achievements' => '管理赞助成就徽章',
	'achievements-platinum' => '铂',
	'achievements-gold' => '金',
	'achievements-silver' => '银',
	'achievements-bronze' => '铜',
	'achievements-gold-points' => '一百<br />点',
	'achievements-silver-points' => '五十<br />点',
	'achievements-bronze-points' => '十<br />点',
	'achievements-you-must' => '你需要$1获得此徽章。',
	'leaderboard-button' => '成就排行榜',
	'achievements-masthead-points' => '$1<small>{{PLURAL:$1|点|点}}</small>',
	'achievements-profile-title-no' => '$1的徽章',
	'achievements-no-badges' => '看看下面这个维基上你可以获得的徽章列表 ！',
	'achievements-track-name-edit' => '编辑轨道',
	'achievements-track-name-picture' => '图片轨道',
	'achievements-track-name-category' => '类别轨道',
	'achievements-track-name-blogpost' => '博客发布轨道',
	'achievements-track-name-blogcomment' => '博客评论轨道',
	'achievements-track-name-love' => '维基钟爱轨道',
	'achievements-track-name-sharing' => '分享轨道',
	'achievements-notification-title' => '$1，继续加油！',
	'achievements-notification-subtitle' => '你刚刚获取了"$1"徽章$2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|看看你可以获取哪些徽章]]!</big></strong>',
	'achievements-points' => '$1{{PLURAL:$1|点|点}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|点|点}}',
	'achievements-earned' => '这枚徽章被 {{PLURAL:$1|1个用户|$1个用户}}获得。',
	'achievements-profile-title' => '$1获取了$2枚{{PLURAL:$2|徽章|徽章}}',
	'achievements-profile-title-challenges' => '你可以获得更多的徽章！',
	'achievements-profile-customize' => '自定义徽章',
	'achievements-ranked' => '此维基上排名第$1',
	'achievements-viewall' => '查看所有',
	'achievements-viewless' => '关闭',
	'achievements-profile-title-oasis' => '成就<br />分数',
	'achievements-ranked-oasis' => '$1在此维基上[[Special:Leaderboard|排名第$2]]',
	'achievements-viewall-oasis' => '查看所有',
	'achievements-toggle-hide' => '向所有人隐藏我的成就',
	'leaderboard-intro-hide' => '隐藏',
	'leaderboard-intro-open' => '打开',
	'leaderboard-intro-headline' => '成就是什么？',
	'leaderboard-intro' => "您可以通过编辑网页、上传图片和留言赢取这个维基上的徽章。 每个徽章帮你获得点数－点数越高，排名越高！ 你会在你的[[$1|用户页面]]看到已经获得的徽章。

'''各种徽章的价值有多少?'''",
	'leaderboard' => '成就排行榜',
	'achievements-title' => '成就',
	'leaderboard-title' => '排行榜',
	'achievements-recent-earned-badges' => '最近赢得的徽章',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />由<a href="$1">$2</a><br />$5获得',
	'achievements-activityfeed-info' => '获得徽章<strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => '排行榜显示自昨天以来的变化',
	'achievements-leaderboard-rank-label' => '排名',
	'achievements-leaderboard-member-label' => '成员',
	'achievements-leaderboard-points-label' => '分数',
	'achievements-leaderboard-points' => '{{PLURAL:$1|点|点}}',
	'achievements-leaderboard-most-recently-earned-label' => '最近赢得',
	'achievements-send' => '保存图片',
	'achievements-save' => '保存更改',
	'achievements-reverted' => '徽章还原为原始。',
	'achievements-customize' => '自定义图片',
	'achievements-customize-new-category-track' => '创建类别的最新轨道：',
	'achievements-enable-track' => '启用',
	'achievements-revert' => '还原到默认',
	'achievements-special-saved' => '已经保存更改。',
	'achievements-special' => '特别成就',
	'achievements-secret' => '秘密成就',
	'achievementscustomize' => '自定义徽章',
	'achievements-about-title' => '有关此页...',
	'achievements-about-content' => '管理员可以自定义此维基上的成就徽章名称和图片。

您可以上载任何.jpg或.png的图片，图片将自动调整尺寸。
正方形的图片最佳，图片设置在中间将得到最佳显示。

您也可以使用长方形图片，但可能需要裁剪尺寸。
如果您使用绘图工具，您可以在裁剪图片后将图像最重要部分置于中心。
如果您没有绘图工具，您可以尝试使用不同的图片直到满意为止。
如果您不喜欢选择的图片，请单击"{{int:achievements-revert}}"回复到原本的图片。

您也可以通过命名徽章以便更符合您的维基社区主题。
在您更改徽章名称之后，请单击"{{int:achievements-save}}"保存您的更改。
还等什么，赶快去尝试一下吧！',
	'achievements-edit-plus-category-track-name' => '$1编辑轨道',
	'achievements-create-edit-plus-category-title' => '创建一个新的编辑轨道',
	'achievements-create-edit-plus-category-content' => '您可以创建一系列徽章用来奖励用户对社区做出的某种特别贡献，或者突显用户在社区某一个特别领域的贡献。
您可以设置许多不同的类别，用来展示用户不同的特长！
制造两种不同的徽章主题阵营，比如吸血鬼和狼人，或者魔法师和恶魔，或者汽车人和霸天虎！

创建一个新的“编辑类别”轨道，在下面输入类别名称。
普通的编辑轨道依然存在；
这将帮助你单独创建一个自定义的轨道。

当轨道成功创建后，新的徽章将出现在左侧，位于普通编辑轨道下方。
为新的轨道自定义名称和图片，为用户彰显个性！

一旦完成定制化，点击"{{int:achievements-enable-track}}"开启新的轨道，然后点击"{{int:achievements-save}}"。
用户将会看到新的轨道出现在他们的主页上，当他们开始编辑的时候就会获得这些徽章。
如果您不再希望彰显这些类别，您也可以随时关闭轨道。
虽然如此，已经获得徽章的用户将可以继续保留这些徽章，不会因为轨道的消逝而失去这些徽章。

这将帮助您更有效地使用成就功能。
赶快去试一下吧！
',
	'achievements-create-edit-plus-category' => '创建轨道',
	'platinum' => '铂',
	'achievements-community-platinum-awarded-email-subject' => '你被授予了一枚新的铂徽章!',
	'achievements-community-platinum-awarded-email-body-text' => "恭喜您，$1!

您在$4($3)上获得一枚白金徽章'$2'！
这将为您增添250点积分！

快去看一下您的个人主页上的最新徽章吧！

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>$1, 祝贺你！ </strong><br /><br />

你刚刚在<a href="$3">$4</a>上被授予了一枚<strong>$2</strong>白金徽章，
它给你带来了250点积分！

快去看看你的<a href="$5">个人主页</a>上的新徽章吧。',
	'achievements-community-platinum-awarded-for' => '奖赏原因：',
	'achievements-community-platinum-how-to-earn' => '如何获得：',
	'achievements-community-platinum-awarded-for-example' => '例如："由于做了..."',
	'achievements-community-platinum-how-to-earn-example' => '例如：“做出3个编辑…”',
	'achievements-community-platinum-badge-image' => '徽章图片：',
	'achievements-community-platinum-awarded-to' => '授予：',
	'achievements-community-platinum-current-badges' => '当前白金徽章',
	'achievements-community-platinum-create-badge' => '创建徽章',
	'achievements-community-platinum-enabled' => '已启用',
	'achievements-community-platinum-show-recents' => '在最近的徽章中显示',
	'achievements-community-platinum-edit' => '编辑',
	'achievements-community-platinum-save' => '保存',
	'achievements-community-platinum-cancel' => '取消',
	'achievements-community-platinum-sponsored-label' => '赞助的成就',
	'achievements-community-platinum-sponsored-hover-content-label' => '悬停图片<small>(最小尺寸: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => '徽章使用追踪URL:',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => '悬停印象的跟踪 URL：',
	'achievements-community-platinum-sponsored-badge-click-url-label' => '徽章链接<small>(DART单击命令URL)</small>：',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => '点击查看详细信息',
	'achievements-badge-name-edit-0' => '进行变化',
	'achievements-badge-name-edit-1' => '仅仅是个开始',
	'achievements-badge-name-edit-2' => '制作您的标记',
	'achievements-badge-name-edit-3' => '维基朋友',
	'achievements-badge-name-edit-4' => '合作者',
	'achievements-badge-name-edit-5' => '维基创建者',
	'achievements-badge-name-edit-6' => '维基领袖人物',
	'achievements-badge-name-edit-7' => '维基专家',
	'achievements-badge-name-picture-0' => '快照',
	'achievements-badge-name-picture-1' => '狗仔队',
	'achievements-badge-name-picture-2' => '插画师',
	'achievements-badge-name-picture-3' => '收藏家',
	'achievements-badge-name-picture-4' => '艺术爱好者',
	'achievements-badge-name-picture-5' => '装饰师',
	'achievements-badge-name-picture-6' => '设计师',
	'achievements-badge-name-picture-7' => '策展人',
	'achievements-badge-name-category-0' => '建立连接',
	'achievements-badge-name-category-1' => '开拓者',
	'achievements-badge-name-category-2' => '探索家',
	'achievements-badge-name-category-3' => '旅游指南',
	'achievements-badge-name-category-4' => '航海家',
	'achievements-badge-name-category-5' => '造桥师',
	'achievements-badge-name-category-6' => '维基规划师',
	'achievements-badge-name-blogpost-0' => '有话要说',
	'achievements-badge-name-blogpost-1' => '五件事要说',
	'achievements-badge-name-blogpost-2' => '脱口秀',
	'achievements-badge-name-blogpost-3' => '聚会生活',
	'achievements-badge-name-blogpost-4' => '公众演说家',
	'achievements-badge-name-blogcomment-0' => '意见领袖',
	'achievements-badge-name-blogcomment-1' => '还有一件事',
	'achievements-badge-name-love-0' => '维基的关键 ！',
	'achievements-badge-name-love-1' => '在此维基上已经两个星期',
	'achievements-badge-name-love-2' => '热心的',
	'achievements-badge-name-love-3' => '乐于奉献',
	'achievements-badge-name-love-4' => '上瘾的',
	'achievements-badge-name-love-5' => '维基生活',
	'achievements-badge-name-love-6' => '维基英雄！',
	'achievements-badge-name-sharing-0' => '分享者',
	'achievements-badge-name-sharing-1' => '把它带回来',
	'achievements-badge-name-sharing-2' => '演讲者',
	'achievements-badge-name-sharing-3' => '播音员',
	'achievements-badge-name-sharing-4' => '福音传教士',
	'achievements-badge-name-welcome' => '欢迎使用维基',
	'achievements-badge-name-introduction' => '介绍',
	'achievements-badge-name-sayhi' => '停下来问好',
	'achievements-badge-name-creator' => '创建者',
	'achievements-badge-name-pounce' => '突袭!',
	'achievements-badge-name-caffeinated' => '含咖啡因',
	'achievements-badge-name-luckyedit' => '幸运编辑',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|分享链接|让{{PLURAL:$1|一个人|$1个人}}点击您分享的链接}}',
	'achievements-badge-to-get-edit' => '对{{PLURAL:$1|条目|条目}}做出$1{{PLURAL:$1|次编辑|次编辑}}',
	'achievements-badge-to-get-edit-plus-category' => '在{{PLURAL:$1|$2页面|$2页面}}中做出{{PLURAL:$1|一次编辑|$1次编辑}}',
	'achievements-badge-to-get-picture' => '为{{PLURAL:$1|一篇文章|文章}}添加$1{{PLURAL:$1|张图片|张图片}}',
	'achievements-badge-to-get-category' => '为$1{{PLURAL:$1|篇文章|篇文章}}添加{{PLURAL:$1|分类|分类}}',
	'achievements-badge-to-get-blogpost' => '撰写 $1{{PLURAL:$1|篇博客|篇博客}}',
	'achievements-badge-to-get-blogcomment' => '为{{PLURAL:$1|一篇博客|$1篇不同的博客}}撰写评论!',
	'achievements-badge-to-get-love' => '连续为本维基贡献{{PLURAL:$1|一天|$1天}}',
	'achievements-badge-to-get-welcome' => '加入维基',
	'achievements-badge-to-get-introduction' => '添加內容至您的用户页',
	'achievements-badge-to-get-sayhi' => '在其他人的讨论页上留言',
	'achievements-badge-to-get-creator' => '成为这个维基的创建者',
	'achievements-badge-to-get-pounce' => '加油',
	'achievements-badge-to-get-caffeinated' => '一天之内对所有文章做出{{PLURAL:$1|一次编辑|$1次编辑}}',
	'achievements-badge-to-get-luckyedit' => '很幸运',
	'achievements-badge-to-get-sharing-details' => '共享链接, 让其他人点击它们!',
	'achievements-badge-to-get-edit-details' => '是不是缺少了什么?
是不是哪里有错误?
不要觉得羞怯.
点击 "{{int:edit}}" 按钮, 你可以添加任何页面!',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong>页面需要您的帮助！
在那个分类中的页面点击“{{int:edit}}”按钮来帮助我们。
在$1页面上尽情展示您的才华！',
	'achievements-badge-to-get-introduction-details' => '您的用户页空空如也？
单击屏幕顶部的用户名查看一下。
单击"{{int:edit}}"添加一些关于您的个人信息吧！',
	'achievements-badge-to-get-pounce-details' => '要获得这个徽章你得赶快啦。
点击“{{int:activityfeed}}”查看其他用户正在创建的新页面！',
	'achievements-badge-to-get-luckyedit-details' => '幸运编辑徽章是给予在Wiki作出第1000次编辑以及之后每1000次编辑的人，要获得这个徽章你必须要在wiki上贡献够多且足够幸运。',
	'achievements-badge-hover-desc-edit' => '对{{PLURAL:$1|文章|文章}}进行$1{{PLURAL:$1|次修改|次修改}}获得奖励！',
	'achievements-badge-hover-desc-edit-plus-category' => '对{{PLURAL:$1|$2文章|$2文章}}<br />
进行$1{{PLURAL:$1|次修改|次修改}}获得奖励！',
	'achievements-badge-hover-desc-blogpost' => '撰写$1{{PLURAL:$1|篇博客|篇博客}}获得奖励！',
	'achievements-badge-hover-desc-blogcomment' => '在$1篇{{PLURAL:$1|博客|博客}}上<br />
发表评论获得奖励！',
	'achievements-badge-hover-desc-love' => '连续为本维基贡献{{PLURAL:$1|一天|$1天}}！',
	'achievements-badge-hover-desc-welcome' => '加入本维基的奖励！',
	'achievements-badge-hover-desc-introduction' => '为自己的用户页添砖加瓦！',
	'achievements-badge-hover-desc-sayhi' => '在其他用户的讨论页上留言！',
	'achievements-badge-hover-desc-creator' => '创建维基的奖励！',
	'achievements-badge-hover-desc-pounce' => '为100个条目在页面建立的一个小时内执行编辑！',
	'achievements-badge-hover-desc-caffeinated' => '在一天之内对文章页面做出总共一百个编辑！',
	'achievements-badge-hover-desc-luckyedit' => '幸运地做出本维基第$1次修改！',
	'achievements-badge-your-desc-edit' => '在{{PLURAL:$1|条目|条目}}上进行{{PLURAL:$1|你的首次编辑|$1次编辑}}获得奖励 !',
	'achievements-badge-your-desc-edit-plus-category' => '为{{PLURAL:$1|$2条目|$2条目}}进行{{PLURAL:$1|你的首次编辑|$1次编辑}} !',
	'achievements-badge-your-desc-blogpost' => '撰写{{PLURAL:$1|您的第一篇博客|$1篇博客}} 获得奖励！',
	'achievements-badge-your-desc-blogcomment' => '为{{PLURAL:$1|一篇博客|$1篇不同的博客}}撰写评论获得奖励！',
	'achievements-badge-your-desc-love' => '连续为本维基贡献{{PLURAL:$1|一天|$1天}}！',
	'achievements-badge-your-desc-welcome' => '加入本wiki的奖励！',
	'achievements-badge-your-desc-introduction' => '添加个人用户页的奖励！',
	'achievements-badge-your-desc-sayhi' => '在其他用户的讨论页上留言！',
	'achievements-badge-your-desc-creator' => '创建本维基的奖励！',
	'achievements-badge-your-desc-pounce' => '为100个条目在页面建立的一个小时内执行编辑！',
	'achievements-badge-your-desc-caffeinated' => '一天之内就对页面做出一百个编辑！',
	'achievements-badge-your-desc-luckyedit' => '幸运地做出本维基第$1次修改！',
	'achievements-badge-desc-edit' => '为{{PLURAL:$1|条目|条目}}进行$1{{PLURAL:$1|次编辑|次编辑}} !',
	'achievements-badge-desc-edit-plus-category' => '对{{PLURAL:$1|$2文章|$2文章}}进行$1{{PLURAL:$1|次修改|次修改}}获得奖励！',
	'achievements-badge-desc-picture' => '为{{PLURAL:$1|文章|文章}}添加$1{{PLURAL:$1|张图片|张图片}}获得奖励！',
	'achievements-badge-desc-category' => '为$1{{PLURAL:$1|篇文章|篇文章}}添加{{PLURAL:$1|分类|分类}}获得奖励！',
	'achievements-badge-desc-blogpost' => '撰写$1{{PLURAL:$1|篇博客|篇博客}}！',
	'achievements-badge-desc-blogcomment' => '为{{PLURAL:$1|一篇博客|$1篇不同的博客}}撰写评论!',
	'achievements-badge-desc-love' => '连续为本维基贡献{{PLURAL:$1|一天|$1天}}获得奖励！',
	'achievements-badge-desc-welcome' => '加入本维基的奖励！',
	'achievements-badge-desc-introduction' => '添加个人用户页的奖励！',
	'achievements-badge-desc-sayhi' => '在其他用户的讨论页上留言！',
	'achievements-badge-desc-creator' => '创建本维基的奖励！',
	'achievements-badge-desc-pounce' => '为100个页面在页面建立的一个小时内执行编辑！',
	'achievements-badge-desc-caffeinated' => '一天之内就对页面做出一百个编辑！',
	'achievements-badge-desc-luckyedit' => '幸运地做出本维基第$1次修改！',
	'achievements-userprofile-title-no' => '$1获得的徽章',
	'achievements-userprofile-title' => '$1已获得的{{PLURAL:$2|徽章|徽章}} ($2)',
	'achievements-userprofile-no-badges-owner' => '查看下面的列表来浏览您在本维基上可以获得的徽章！',
	'achievements-userprofile-no-badges-visitor' => '这个用户没有得到任何徽章。',
	'achievements-userprofile-profile-score' => '<em>$1</em>成就<br />点数',
	'achievements-userprofile-ranked' => '在本维基上<br />[[Special:Leaderboard|排名第 #$1]]',
	'action-platinum' => '创建和编辑白金徽章',
	'achievements-next-oasis' => '下一页',
	'achievements-prev-oasis' => '上一页',
	'achievements-badge-to-get-picture-details' => '点击"{{int:edit}}"按钮之后再点击"{{int:rte-ck-image-add}}"按钮。
	您可以从电脑上传图片，或者从维基文章页选取图片进行添加。',
	'achievements-badge-to-get-category-details' => '类别是一种用来帮助用户查找相似页面的标签。
单击页面底部的"{{int:categoryselect-addcategory-button}}" 按钮将此页面列在相应的类别下。',
	'achievements-badge-to-get-blogpost-details' => '写下你的意见和问题！
点击边栏中的"{{int:blogs-recent-url-text}}"，然后点击左侧链接"{{int:create-blog-post-title}}"。',
	'achievements-badge-to-get-blogcomment-details' => '添加两枚硬币!
阅读最近的博客文章，在评论框中填写你的想法。',
	'achievements-badge-to-get-love-details' => '如果你错过了一天计数器将重置，所以记得每天都要回来社区看一下哟！',
	'achievements-badge-to-get-welcome-details' => '单击顶部右侧的"{{int:oasis-signup}}"按钮加入社区。
你就可以开始赢取徽章啦!',
	'achievements-badge-to-get-sayhi-details' => '你可以通过点击讨论页中的"{{int:addsection}}"给其他用户留言。
寻求帮助，感谢他们的贡献，或者向他们问好!',
	'achievements-badge-to-get-creator-details' => '这枚徽章是奖给维基社区创始人的。
单击顶部"{{int:createwiki}}"按钮，开始创建你喜爱的社区网站!',
	'achievements-badge-to-get-caffeinated-details' => '需要一天的忙碌才能获得这枚徽章！
加油编辑吧！',
	'achievements-badge-to-get-community-platinum-details' => '获得这枚特殊的白金徽章的时间可是有限的哟!',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|由于分享一个链接|由于{{PLURAL:$1|一个人|$1个人}}点击了这个链接}}',
	'achievements-badge-hover-desc-picture' => '因为在{{PLURAL:$1|文章|文章}}中添加了<br />$1张{{PLURAL:$1|图片|图片}}而获得徽章！',
	'achievements-badge-hover-desc-category' => '因为帮$1{{PLURAL:$1|篇文章|篇文章}}<br />
添加了{{PLURAL:$1|分类|分类}}而获得徽章！',
	'achievements-badge-hover-desc-community-platinum' => '获得这枚特殊的白金徽章的时间可是有限的哟!',
	'achievements-badge-your-desc-sharing' => '{{#ifeq:$1|0|由于分享了一个链接|由于{{PLURAL:$1|一个人|$1个人}}点击了这个链接}}而获得徽章。',
	'achievements-badge-your-desc-picture' => '在{{PLURAL:$1|文章|文章}}中添加了{{PLURAL:$1|你的第一张图片|$1张图片}}获得奖励!',
	'achievements-badge-your-desc-category' => '把{{PLURAL:$1|一篇文章|$1篇文章}}添加到{{PLURAL:$1|分类|分类}}获得的奖励！',
	'achievements-badge-desc-sharing' => '{{#ifeq:$1|0|由于分享了一个链接|由于{{PLURAL:$1|一个人|$1个人}}点击分享了这个链接}}而获得徽章。',
	'right-achievements-exempt' => '用户没有资格获得成就积分',
	'right-achievements-explicit' => '用户有资格获得成就积分（覆盖免除设定）',
);

$messages['zh-hant'] = array(
	'achievements-platinum' => '白金',
	'achievements-gold' => '金',
	'achievements-silver' => '銀',
	'achievements-bronze' => '銅',
	'achievements-gold-points' => '100<br />點',
	'achievements-silver-points' => '50<br />點',
	'achievements-bronze-points' => '10<br />點',
	'achievements-viewall-oasis' => '查看全部',
	'leaderboard-intro-hide' => '隱藏',
	'achievements-title' => '成就',
	'leaderboard-title' => '排行榜',
	'achievements-leaderboard-points-label' => '點數',
	'achievements-leaderboard-points' => '{{PLURAL:$1|點|點}}',
	'achievements-send' => '保存圖片',
	'achievements-about-title' => '有關此頁...',
	'platinum' => '白金',
	'achievements-community-platinum-edit' => '編輯',
	'achievements-community-platinum-save' => '儲存',
	'achievements-community-platinum-cancel' => '取消',
	'achievements-community-platinum-sponsored-badge-click-tooltip' => '點擊查看更多資訊',
	'achievements-badge-to-get-welcome' => '加入這個wiki',
	'achievementsii-desc' => '一項為wiki使用者提供成就徽章的系統',
	'achievements-upload-error' => '抱歉！
這張圖片無法使用。
請確保它是一個.jpg或.png檔案。
如果它仍無法使用，那麼可能是因為圖片大小超過標準了。
請嘗試另一張圖片！',
	'achievements-upload-not-allowed' => '管理員可以點擊[[Special:AchievementsCustomize|自訂成就]]頁面，更改徽章名稱和圖片。',
	'achievements-non-existing-category' => '指定的類別不存在。',
	'achievements-edit-plus-category-track-exists' => '指定的類別已經有 <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">關聯的軌道</a>。',
	'achievements-no-stub-category' => '請不要幫小作品創建軌道。',
	'right-platinum' => '創建和編輯白金徽章',
	'right-sponsored-achievements' => '管理贊助的成就徽章',
	'action-platinum' => '創建和編輯白金徽章',
	'achievements-you-must' => '你需要$1 以獲得此徽章。',
	'leaderboard-button' => '成就排行榜',
	'achievements-masthead-points' => '$1<small>{{PLURAL:$1|點|點}}</small>',
	'achievements-track-name-edit' => '編輯軌道',
	'achievements-track-name-picture' => '圖片軌道',
	'achievements-track-name-category' => '分類軌道',
	'achievements-track-name-blogpost' => '網誌發佈軌道',
	'achievements-track-name-blogcomment' => '網誌評論軌道',
	'achievements-track-name-love' => 'wiki鍾愛軌道',
	'achievements-track-name-sharing' => '分享軌道',
	'achievements-notification-title' => '$1，繼續努力！',
	'achievements-notification-subtitle' => '你剛剛獲取了"$1"徽章$2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|看看你還可以獲得哪些徽章]]!</big></strong>',
	'achievements-points' => '$1{{PLURAL:$1|點|點}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|點|點}}',
	'achievements-earned' => '這枚徽章有 {{PLURAL:$1|1個使用者|$1個使用者}}獲得。',
	'achievements-profile-title' => '$1獲取了$2枚{{PLURAL:$2|徽章|徽章}}',
	'achievements-profile-title-no' => '$1的徽章',
	'achievements-profile-title-challenges' => '你可以獲得更多的徽章!',
	'achievements-profile-customize' => '自訂徽章',
	'achievements-ranked' => '在這個wiki上排名第$1',
	'achievements-no-badges' => '看看在這個wiki上你可以獲取的徽章清單!',
	'achievements-viewall' => '查看全部',
	'achievements-viewless' => '關閉',
	'achievements-profile-title-oasis' => '成就<br / >分數',
	'achievements-ranked-oasis' => '$1在此wiki上[[Special:Leaderboard|排名第$2]]',
	'achievements-next-oasis' => '下一頁',
	'achievements-prev-oasis' => '上一頁',
	'achievements-toggle-hide' => '在我的個人資料頁上隱藏我的成就',
	'leaderboard-intro-open' => '打開',
	'leaderboard-intro-headline' => '成就是什麼?',
	'leaderboard-intro' => "你可以經由編輯頁面、上傳圖片和留言等方式在這個wiki上獲得徽章。每個徽章都能讓你獲得點數－點數越高，排名越高！你會在你的[[$1|使用者頁面面]]看到已經獲得的徽章。

 '''各種徽章的價值有多少?'''",
	'leaderboard' => '成就排行榜',
	'achievements-recent-earned-badges' => '最近獲得的徽章',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />由<a href="$1">$2</a><br />$5獲得',
	'achievements-activityfeed-info' => '獲得徽章<strong><a href="$3" class="badgeName">$1</a></strong><br/>$2',
	'achievements-leaderboard-disclaimer' => '排行榜顯示更新至昨日',
	'achievements-leaderboard-rank-label' => '排名',
	'achievements-leaderboard-member-label' => '成員',
	'achievements-leaderboard-most-recently-earned-label' => '最近獲得',
	'achievements-save' => '保存更改',
	'achievements-reverted' => '徽章回歸原始。',
	'achievements-customize' => '自訂圖片',
	'achievements-customize-new-category-track' => '創建新的類別軌道:',
	'achievements-enable-track' => '啟用',
	'achievements-revert' => '恢復為預設值',
	'achievements-special-saved' => '已保存更改。',
	'achievements-special' => '特別成就',
	'achievements-secret' => '秘密成就',
	'achievementscustomize' => '自訂徽章',
	'achievements-about-content' => '管理員可以自訂此wiki上的成就徽章名稱和圖片。

您可以上載任何.jpg或.png的圖片，圖片將自動調整尺寸。
正方形的圖片最佳，圖片設置在中間將得到最佳顯示。

您也可以使用長方形圖片，但可能需要裁剪尺寸。
如果您使用繪圖工具，您可以在裁剪圖片後將圖像最重要部分置於中心。
如果您沒有繪圖工具，您可以嘗試使用不同的圖片直到滿意為止。
如果您不喜歡選擇的圖片，請點擊「{{int:achievements-revert}}」恢復為原本的圖片。

您也可以重新命名徽章以便更適合您的wiki社區主題。
在您更改徽章名稱之後，請點擊「{{int:achievements-save}}」保存您的更改。
還等什麼，趕快去嘗試一下吧！',
	'achievements-edit-plus-category-track-name' => '$1編輯軌道',
	'achievements-create-edit-plus-category-title' => '創建一個新的編輯軌道',
	'achievements-create-edit-plus-category-content' => '您可以創建一系列的徽章，用來獎勵、突顯使用者對社區某一個特別領域做出的貢獻
您可以設置許多不同分類的軌道，用來展示使用者不同的特長！也可以製造兩種不同的徽章主題陣營，比如吸血鬼和狼人，或者魔法師和惡魔，或者汽車人和霸天虎！

要創建一個新的「編輯分類」軌道，在下面輸入分類名稱。
普通的編輯軌道依然會存在；
這將讓你另創建一個自訂的軌道。

當軌道成功創建後，新的徽章將出現在左側，位於普通編輯軌道下方。
為新的軌道中自訂名稱和圖片，讓人能看出它們的差別！

一旦完成自訂內容，點擊「{{int:achievements-enable-track}}」來開啟新的軌道，然後點擊「{{int:achievements-save}}」。
使用者將會看到新的軌道出現在他們的使用者頁面上，當他們在該分類開始編輯的時候就會獲得這些徽章。
如果您不再希望突出這些分類時，您也可以隨時關閉軌道。
雖然如此，已經獲得徽章的使用者將可以繼續保留這些徽章，不會因為軌道的消逝而失去這些徽章。

這將幫助您更有效地使用成就功能。
趕快去試一下吧！',
	'achievements-create-edit-plus-category' => '創建此軌道',
	'achievements-community-platinum-awarded-email-subject' => '你獲得了一個新的白金徽章！',
	'achievements-community-platinum-awarded-email-body-text' => "恭喜，$1!

您在$4($3)上獲得一枚白金徽章'$2'！
這將為您增加250點積分！

快去看一下您的個人頁面上的最新徽章吧！

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>$1, 祝賀你！</strong><br /><br />

你剛剛在<a href="$3">$4</a>上被授予了一枚<strong>$2</strong>白金徽章，
它給你帶來了250點積分！

快去看看你的<a href="$5">個人頁面</a>上的新徽章吧。',
	'achievements-community-platinum-awarded-for' => '獎賞原因：',
	'achievements-community-platinum-how-to-earn' => '如何獲得：',
	'achievements-community-platinum-awarded-for-example' => '比如："由於做了..."',
	'achievements-community-platinum-how-to-earn-example' => '例如："編輯3次..."',
	'achievements-community-platinum-badge-image' => '徽章圖像：',
	'achievements-community-platinum-awarded-to' => '授予：',
	'achievements-community-platinum-current-badges' => '當前白金徽章',
	'achievements-community-platinum-create-badge' => '創建徽章',
	'achievements-community-platinum-enabled' => '啟用',
	'achievements-community-platinum-show-recents' => '展示最近的徽章',
	'achievements-community-platinum-sponsored-label' => '贊助的成就',
	'achievements-community-platinum-sponsored-hover-content-label' => '懸停圖片<small>(最小尺寸: 270px x 100px)</small>:',
	'achievements-community-platinum-sponsored-badge-impression-pixel-url-label' => '徽章顯示追蹤URL：',
	'achievements-community-platinum-sponsored-hover-impression-pixel-url-label' => '懸停顯示追蹤URL:',
	'achievements-community-platinum-sponsored-badge-click-url-label' => '徽章連結<small>(DART按一下命令URL)</small>：',
	'achievements-badge-name-edit-0' => '進行改變',
	'achievements-badge-name-edit-1' => '僅僅是個開始',
	'achievements-badge-name-edit-2' => '留下你的印記',
	'achievements-badge-name-edit-3' => 'wiki的朋友',
	'achievements-badge-name-edit-4' => '合作者',
	'achievements-badge-name-edit-5' => 'wiki構建者',
	'achievements-badge-name-edit-6' => 'wiki領導者',
	'achievements-badge-name-edit-7' => 'wiki專家',
	'achievements-badge-name-picture-0' => '快照',
	'achievements-badge-name-picture-1' => '狗仔隊',
	'achievements-badge-name-picture-2' => '插畫家',
	'achievements-badge-name-picture-3' => '收藏家',
	'achievements-badge-name-picture-4' => '藝術愛好者',
	'achievements-badge-name-picture-5' => '室內設計師',
	'achievements-badge-name-picture-6' => '設計師',
	'achievements-badge-name-picture-7' => '策展人',
	'achievements-badge-name-category-0' => '建立連接',
	'achievements-badge-name-category-1' => '開拓者',
	'achievements-badge-name-category-2' => '探險家',
	'achievements-badge-name-category-3' => '導遊',
	'achievements-badge-name-category-4' => '導航者',
	'achievements-badge-name-category-5' => '造橋者',
	'achievements-badge-name-category-6' => 'wiki規劃師',
	'achievements-badge-name-blogpost-0' => '有話要說',
	'achievements-badge-name-blogpost-1' => '五件事要說',
	'achievements-badge-name-blogpost-2' => '脫口秀',
	'achievements-badge-name-blogpost-3' => '生活聚會',
	'achievements-badge-name-blogpost-4' => '公眾演說家',
	'achievements-badge-name-blogcomment-0' => '意見領袖',
	'achievements-badge-name-blogcomment-1' => '還有一件事',
	'achievements-badge-name-love-0' => 'wiki的關鍵！',
	'achievements-badge-name-love-1' => '在這個wiki上兩個星期',
	'achievements-badge-name-love-2' => '熱心的',
	'achievements-badge-name-love-3' => '樂於奉獻',
	'achievements-badge-name-love-4' => '上癮',
	'achievements-badge-name-love-5' => 'wiki生活',
	'achievements-badge-name-love-6' => 'wiki英雄！',
	'achievements-badge-name-sharing-0' => '分享者',
	'achievements-badge-name-sharing-1' => '把它帶回來',
	'achievements-badge-name-sharing-2' => '演講者',
	'achievements-badge-name-sharing-3' => '播音員',
	'achievements-badge-name-sharing-4' => '福音傳教士',
	'achievements-badge-name-welcome' => '歡迎來到這個wiki',
	'achievements-badge-name-introduction' => '介紹',
	'achievements-badge-name-sayhi' => '停下來打聲招呼',
	'achievements-badge-name-creator' => '創建者',
	'achievements-badge-name-pounce' => '突襲！',
	'achievements-badge-name-caffeinated' => '含咖啡因',
	'achievements-badge-name-luckyedit' => '幸運編輯',
	'achievements-badge-to-get-sharing' => '{{#ifeq:$1|0|分享連結|讓{{PLURAL:$1|一個人|$1個人}}點擊您分享的連結}}',
	'achievements-badge-to-get-edit' => '對{{PLURAL:$1|條目|條目}}做出$1{{PLURAL:$1|次編輯|次編輯}}',
	'achievements-badge-to-get-edit-plus-category' => '在{{PLURAL:$1|$2頁面|$2頁面}}中做出{{PLURAL:$1|一次編輯|$1次編輯}}',
	'achievements-badge-to-get-picture' => '為{{PLURAL:$1|一篇文章|文章}}添加$1{{PLURAL:$1|張圖片|張圖片}}',
	'achievements-badge-to-get-category' => '為$1{{PLURAL:$1|篇文章|篇文章}}添加{{PLURAL:$1|分類|分類}}',
	'achievements-badge-to-get-blogpost' => '撰寫$1{{PLURAL:$1|篇網誌|篇網誌}}',
	'achievements-badge-to-get-blogcomment' => '在{{PLURAL:$1|一篇網誌|$1篇不同的網誌}}上撰寫評論',
	'achievements-badge-to-get-love' => '連續{{PLURAL:$1|一天|$1天}}不斷在這個wiki貢獻',
	'achievements-badge-to-get-introduction' => '添加到您自己的使用者頁面',
	'achievements-badge-to-get-sayhi' => '在使用者討論頁留言',
	'achievements-badge-to-get-creator' => '成為這個wiki的創始人',
	'achievements-badge-to-get-pounce' => '要快',
	'achievements-badge-to-get-caffeinated' => '在一天中對文章做了{{PLURAL:$1|1次編輯|$1次編輯}}',
	'achievements-badge-to-get-luckyedit' => '很幸運',
	'achievements-badge-to-get-sharing-details' => '分享連結，並讓其他人點擊這些連結！',
	'achievements-badge-to-get-edit-details' => '是不是缺少了什麼？
是不是哪裡有錯誤？
不要害羞。
點擊 "{{int:edit}}" 按鈕，你可以添加任何頁面！',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong>頁面需要您的幫助！
在那個分類中的頁面點擊「{{int:edit}}」按鈕來幫助我們。
在$1頁面上展示您的才華！',
	'achievements-badge-to-get-picture-details' => '點擊"{{int:edit}}"按鈕之後再點擊"{{int:rte-ck-image-add}}"按鈕。
您可以從電腦上傳圖片，或者從其他wiki頁面選取圖片添加。',
	'achievements-badge-to-get-category-details' => '分類是一種用來協助使用者查找相關頁面的標籤。
按一下頁面底部的"{{int:categoryselect-addcategory-button}}" 按鈕將此頁面放入相應的分類下。',
	'achievements-badge-to-get-blogpost-details' => '寫下你的意見和問題！
點擊邊欄中的"{{int:blogs-recent-url-text}}"，然後點擊左側連結"{{int:create-blog-post-title}}"。',
	'achievements-badge-to-get-blogcomment-details' => '添加兩枚硬幣！
閱讀最近的網誌文章，在評論框中寫下你的想法。',
	'achievements-badge-to-get-love-details' => '如果你錯過了一天計數器將會重置，所以記得每天都要回來社區看一下喔！',
	'achievements-badge-to-get-welcome-details' => '按一下頂部右側的"{{int:oasis-signup}}"按鈕加入社區。
你就可以開始獲取徽章啦！',
	'achievements-badge-to-get-introduction-details' => '您的使用者頁面空空如也？
按一下螢幕頂部的使用者名稱進行查看。
按一下"{{int:edit}}"添加一些關於您個人的資訊吧！',
	'achievements-badge-to-get-sayhi-details' => '您可以透過點擊討論頁中的"{{int:addsection}}"給其他使用者留言。
尋求協助、感謝他們的貢獻，或者向他們問好！',
	'achievements-badge-to-get-creator-details' => '這枚徽章是頒給這個wiki社區創始人的。
按一下頂部的"{{int:createwiki}}"按鈕，開始創建你喜愛的社區網站！',
	'achievements-badge-to-get-pounce-details' => '要獲得這個徽章你得趕快啦。
點擊「{{int:activityfeed}}」來查看使用者們正在創建的新頁面！',
	'achievements-badge-to-get-caffeinated-details' => '要努力編輯一天才能獲得這枚徽章！
繼續編輯吧！',
	'achievements-badge-to-get-luckyedit-details' => '幸運編輯徽章是給予在wiki作出第1000次編輯以及之後每1000次編輯的人，要獲得這個徽章你必須要在wiki上貢獻夠多且足夠幸運。',
	'achievements-badge-to-get-community-platinum-details' => '獲得這枚特殊白金徽章的時間可是有限的喔！',
	'achievements-badge-hover-desc-sharing' => '{{#ifeq:$1|0|由於分享了一個連結|由於{{PLURAL:$1|一個人|$1個人}}點擊了這個連結}}',
	'achievements-badge-hover-desc-edit' => '對{{PLURAL:$1|文章|文章}}進行$1{{PLURAL:$1|次修改|次修改}}！',
	'achievements-badge-hover-desc-edit-plus-category' => '對{{PLURAL:$1|$2文章|$2文章}}<br />
進行$1{{PLURAL:$1|次修改|次修改}}！',
	'achievements-badge-hover-desc-picture' => '為{{PLURAL:$1|文章|文章}}<br />
添加$1{{PLURAL:$1|張圖片|張圖片}}！',
	'achievements-badge-hover-desc-category' => '為$1{{PLURAL:$1|篇文章|篇文章}}<br />
添加了{{PLURAL:$1|分類|分類}}而獲得獎勵！',
	'achievements-badge-hover-desc-blogpost' => '撰寫$1{{PLURAL:$1|篇網誌|篇網誌}}！',
	'achievements-badge-hover-desc-blogcomment' => '在$1篇{{PLURAL:$1|網誌文章|網誌文章}}上發表評論！',
	'achievements-badge-hover-desc-love' => '連續為本wiki貢獻{{PLURAL:$1|一天|$1天}}！',
	'achievements-badge-hover-desc-welcome' => '加入本wiki的獎勵！',
	'achievements-badge-hover-desc-introduction' => '添加內容到您的使用者頁面！',
	'achievements-badge-hover-desc-sayhi' => '在其他使用者的討論頁上留言！',
	'achievements-badge-hover-desc-creator' => '創建wiki的獎勵！',
	'achievements-badge-hover-desc-pounce' => '在100 篇文章創建的一個小時內進行編輯！',
	'achievements-badge-hover-desc-caffeinated' => '在一天之內對文章頁做出100個編輯！',
	'achievements-badge-hover-desc-luckyedit' => '在這個wiki上進行第$1次幸運編輯！',
	'achievements-badge-hover-desc-community-platinum' => '獲得這枚特殊白金徽章的時間可是有限的喔！',
	'achievements-badge-your-desc-sharing' => '{{#ifeq:$1|0|由於分享了一個連結|由於{{PLURAL:$1|一個人|$1個人}}點擊了這個連結}}而獲得獎勵。',
	'achievements-badge-your-desc-edit' => '在{{PLURAL:$1|條目|條目}}上進行{{PLURAL:$1|你的首次編輯|$1次編輯}}！',
	'achievements-badge-your-desc-edit-plus-category' => '在{{PLURAL:$1|$2條目|$2條目}}上進行{{PLURAL:$1|你的首次編輯|$1次編輯}} !',
	'achievements-badge-your-desc-picture' => '在{{PLURAL:$1|文章|文章}}中添加了{{PLURAL:$1|你的第一張圖片|$1張圖片}}！',
	'achievements-badge-your-desc-category' => '把{{PLURAL:$1|1篇文章|$1篇文章}}加入{{PLURAL:$1|分類|分類}}中！',
	'achievements-badge-your-desc-blogpost' => '撰寫{{PLURAL:$1|您的第1篇網誌|$1篇網誌}}！',
	'achievements-badge-your-desc-blogcomment' => '為{{PLURAL:$1|1篇網誌文章|$1篇網誌文章}}撰寫評論！',
	'achievements-badge-your-desc-love' => '連續為本wiki貢獻{{PLURAL:$1|1天|$1天}}！',
	'achievements-badge-your-desc-welcome' => '加入這個wiki的獎勵！',
	'achievements-badge-your-desc-introduction' => '添加個人使用者頁面的獎勵！',
	'achievements-badge-your-desc-sayhi' => '在其他使用者的討論頁上留言的獎勵！',
	'achievements-badge-your-desc-creator' => '創建這個wiki的獎勵！',
	'achievements-badge-your-desc-pounce' => '在100 篇文章創建的一個小時內進行編輯！',
	'achievements-badge-your-desc-caffeinated' => '一天之內在頁面上進行100次編輯！',
	'achievements-badge-your-desc-luckyedit' => '在這個wiki上進行第$1次幸運編輯！',
	'achievements-badge-desc-sharing' => '{{#ifeq:$1|0|由於分享了一個連結|由於{{PLURAL:$1|一個人|$1個人}}點擊了這個連結}}而獲得獎勵。',
	'achievements-badge-desc-edit' => '對{{PLURAL:$1|文章|文章}}進行$1{{PLURAL:$1|次修改|次修改}}！',
	'achievements-badge-desc-edit-plus-category' => '對{{PLURAL:$1|$2文章|$2文章}}進行$1{{PLURAL:$1|次修改|次修改}}！',
	'achievements-badge-desc-picture' => '為{{PLURAL:$1|文章|文章}}添加$1{{PLURAL:$1|張圖片|張圖片}}！',
	'achievements-badge-desc-category' => '為$1{{PLURAL:$1|篇文章|篇文章}}添加{{PLURAL:$1|分類|分類}}！',
	'achievements-badge-desc-blogpost' => '撰寫$1{{PLURAL:$1|篇網誌|篇網誌}}！',
	'achievements-badge-desc-blogcomment' => '為{{PLURAL:$1|1篇網誌文章|$1篇網誌文章}}撰寫評論！',
	'achievements-badge-desc-love' => '連續為本wiki貢獻{{PLURAL:$1|一天|$1天}}！',
	'achievements-badge-desc-welcome' => '加入本wiki的獎勵！',
	'achievements-badge-desc-introduction' => '在個人使用者頁面增加內容！',
	'achievements-badge-desc-sayhi' => '在其他使用者的討論頁上留言！',
	'achievements-badge-desc-creator' => '創建這個wiki的獎勵！',
	'achievements-badge-desc-pounce' => '在100 篇文章頁面創建的一個小時內進行編輯！',
	'achievements-badge-desc-caffeinated' => '一天之內在頁面上進行100次編輯！',
	'achievements-badge-desc-luckyedit' => '在這個wiki上進行第$1次幸運編輯！',
	'achievements-userprofile-title-no' => '$1獲得的徽章',
	'achievements-userprofile-title' => '$1獲得的{{PLURAL:$2|徽章|徽章}} ($2)',
	'achievements-userprofile-no-badges-owner' => '查看在這個wiki上你可以獲取的徽章清單!',
	'achievements-userprofile-no-badges-visitor' => '此使用者尚未獲得任何徽章。',
	'achievements-userprofile-profile-score' => '<em>$1</em>成就<br />點數',
	'achievements-userprofile-ranked' => '在這個wiki上<br />
[[Special:Leaderboard|排名第$1]]',
	'right-achievements-exempt' => '不能獲得成就積分',
	'right-achievements-explicit' => '可獲得成就積分（會覆蓋其他無法獲得積分的使用者組的設定）',
);

