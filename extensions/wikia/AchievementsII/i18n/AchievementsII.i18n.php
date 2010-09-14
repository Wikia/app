<?php

$messages = array();

$messages['en'] = array(
	'achievementsii-desc' => 'An achievement badges system for wiki users',

	/*
	 * Error messages
	 */
	'achievements-upload-error' => 'Sorry!
That picture does not work.
Make sure that it is a .jpg or .png file.
If it still does not work, then the picture may be too big.
Please try another one!',
	'achievements-upload-not-allowed' => 'Administrators can change the names and pictures of Achievement badges by visiting [[Special:AchievementsCustomize|the Customize achievements]] page.',
	'achievements-non-existing-category' => 'The specified category does not exist.',
	'achievements-edit-plus-category-track-exists' => 'The specified category already has an <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">associated track</a>.',
	'achievements-no-stub-category' => 'Please do not create tracks for stubs.',

	/*
	 * Badges' levels
	 */
	'achievements-platinum' => 'Platinum',
	'achievements-gold' => 'Gold',
	'achievements-silver' => 'Silver',
	'achievements-bronze' => 'Bronze',

	/*
	 * Misc
	 */
	'achievements-you-must' => 'You need to $1 to earn this badge.',
	'leaderboard-button' => 'Achievements leaderboard',
 	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|point|points}}</small>',

	/*
	 * Track names
	 */
	'achievements-track-name-edit' => 'Edit track',
	'achievements-track-name-picture' => 'Pictures track',
	'achievements-track-name-category' => 'Category track',
	'achievements-track-name-blogpost' => 'Blog Post track',
	'achievements-track-name-blogcomment' => 'Blog Comment track',
	'achievements-track-name-love' => 'Wiki Love track',

	/*
	 * User notifications
	 */
	'achievements-notification-title' => 'Way to go, $1!',
	'achievements-notification-subtitle' => 'You just earned the "$1" badge $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|See more badges you can earn]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|point|points}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|point|points}}',

	/*
	 * User profile
	 */
	'achievements-earned' => 'This badge has been earned by {{PLURAL:$1|1 user|$1 users}}.',
	'achievements-profile-title' => '$1\'s $2 earned {{PLURAL:$2|badge|badges}}',
	'achievements-profile-title-no' => '$1\'s badges',
	'achievements-profile-title-challenges' => 'More badges you can earn!',
	'achievements-profile-customize' => 'Customize badges >',
	'achievements-ranked' => 'Ranked #$1 on this wiki',
	'achievements-no-badges' => 'Check out the list below to see the badges that you can earn on this wiki!',
	'achievements-viewall' => 'View all',
	'achievements-viewless' => 'Close',

	'achievements-profile-title-oasis' => 'achievement <br/> points',
	'achievements-ranked-oasis' => '$1 is [[Special:Leaderboard|Ranked #$2]] on this wiki',
	'achievements-viewall-oasis' => 'See all',
	//'achievements-viewall-oasis' => 'See all $1\'s badges',
	/*
	 * Leaderboard
	 */
	'leaderboard-intro' => "'''&ldquo;What are Achievements?&rdquo;'''
You can earn special badges by participating on this wiki!
Each badge that you earn adds points to your total score:
Bronze badges are worth 10 points, Silver badges are worth 50 points, and Gold badges are worth 100 points.

When you join the wiki, your user profile displays the badges that you have earned, and shows you a list of the challenges that are available for you.
[[Special:MyPage|Go to your user profile to check it out]]!",
	'leaderboard' => 'Achievements leaderboard',
	'achievements-recent-earned-badges' => 'Recent Earned Badges',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />earned by <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'earned the <strong><a href="$3" class="badgeName">$1</a></strong> badge<br />$2',
	'achievements-leaderboard-disclaimer' => 'Leaderboard shows changes since yesterday',
	'achievements-leaderboard-rank-label' => 'rank',
	'achievements-leaderboard-member-label' => 'member',
	'achievements-leaderboard-points-label' => 'points',
	/*
	 * AchievementsCustomize
	 */
	'achievements-send' => 'Save picture',
	'achievements-save' => 'Save changes',
	'achievements-reverted' => 'Badge reverted to original.',
	'achievements-customize' => 'Customize picture',
	'achievements-customize-new-category-track' => 'Create new track for category:',
	'achievements-enable-track' => 'enabled',
	'achievements-revert' => 'Revert to default',
	'achievements-special-saved' => 'Changes saved.',
	'achievements-special' => 'Special achievements',
	'achievements-secret' => 'Secret achievements',
	'achievementscustomize' => 'Customize badges',
	'achievements-about-title' => 'About this page...',
	'achievements-about-content' => 'Administrators on this wiki can customize the names and pictures of the achievement badges.

You can upload any .jpg or .png picture, and your picture will automatically fit inside the frame.
It works best when your picture is square, and when the most important part of the picture is right in the middle.

You can use rectangular pictures, but you might find that a bit gets cropped out by the frame.
If you have a graphics program, then you can crop your picture to put the important part of the image in the center.
If you do no have a graphics program, then just experiment with different pictures until you find the ones that work for you!
If you do not like the picture that you have chosen, click "{{int:achievements-revert}}" to go back to the original graphic.

You can also give the badges new names that reflect the topic of the wiki.
When you have changed badge names, click "{{int:achievements-save}}" to save your changes.
Have fun!',

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

	/*
	 * Platinum
	 */
	'platinum' => 'Platinum',
	'achievements-community-platinum-awarded-email-subject' => 'You have been awarded a new Platinum badge!',
	'achievements-community-platinum-awarded-email-body-text' => "Congratulations $1!

You have just been awarded with the '$2' Platinum badge on $4 ($3).
This adds 250 points to your score!

Check out your fancy new badge on your user profile page:

$5",
	'achievements-community-platinum-awarded-email-body-html' => "<strong>Congratulations $1!</strong><br /><br />
You have just been awarded with the '<strong>$2</strong>' Platinum badge on <a href=\"$3\">$4</a>.
This adds 250 points to your score!<br /><br />
Check out your fancy new badge on your <a href=\"$5\">user profile page</a>.",
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

	/*
	 * Badges' names
	 */

	// edit track
	'achievements-badge-name-edit-0' => 'Making a Difference',
	'achievements-badge-name-edit-1' => 'Just the Beginning',
	'achievements-badge-name-edit-2' => 'Making Your Mark',
	'achievements-badge-name-edit-3' => 'Friend of the Wiki',
	'achievements-badge-name-edit-4' => 'Collaborator',
	'achievements-badge-name-edit-5' => 'Wiki Builder',
	'achievements-badge-name-edit-6' => 'Wiki Leader',
	'achievements-badge-name-edit-7' => 'Wiki Expert',

	// picture track
	'achievements-badge-name-picture-0' => 'Snapshot',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illustrator',
	'achievements-badge-name-picture-3' => 'Collector',
	'achievements-badge-name-picture-4' => 'Art Lover',
	'achievements-badge-name-picture-5' => 'Decorator',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Curator',

	// category track
	'achievements-badge-name-category-0' => 'Make a Connection',
	'achievements-badge-name-category-1' => 'Trail Blazer',
	'achievements-badge-name-category-2' => 'Explorer',
	'achievements-badge-name-category-3' => 'Tour Guide',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Bridge Builder',
	'achievements-badge-name-category-6' => 'Wiki Planner',

	// blogpost track
	'achievements-badge-name-blogpost-0' => 'Something to say',
	'achievements-badge-name-blogpost-1' => 'Five Things to say',
	'achievements-badge-name-blogpost-2' => 'Talk Show',
	'achievements-badge-name-blogpost-3' => 'Life of the party',
	'achievements-badge-name-blogpost-4' => 'Public Speaker',

	// blogcomment track
	'achievements-badge-name-blogcomment-0' => 'Opinionator',
	'achievements-badge-name-blogcomment-1' => 'And one more thing',

	// love track
	'achievements-badge-name-love-0' => 'Key to the Wiki!',
	'achievements-badge-name-love-1' => 'Two weeks on the wiki',
	'achievements-badge-name-love-2' => 'Devoted',
	'achievements-badge-name-love-3' => 'Dedicated',
	'achievements-badge-name-love-4' => 'Addicted',
	'achievements-badge-name-love-5' => 'A Wiki life',
	'achievements-badge-name-love-6' => 'Wiki Hero!',

	// not in track
	'achievements-badge-name-welcome' => 'Welcome to the Wiki',
	'achievements-badge-name-introduction' => 'Introduction',
	'achievements-badge-name-sayhi' => 'Stopping by to say hi',
	'achievements-badge-name-creator' => 'The Creator',
	'achievements-badge-name-pounce' => 'Pounce!',
	'achievements-badge-name-caffeinated' => 'Caffeinated',
	'achievements-badge-name-luckyedit' => 'Lucky edit',

	/*
	 * Badges' details for challenges list on user profile
	 */
	'achievements-badge-to-get-edit' => 'make $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a page|pages}}',
	'achievements-badge-to-get-edit-plus-category' => 'make {{PLURAL:$1|one edit|$1 edits}} on {{PLURAL:$1|a $2 page|$2 pages}}',
	'achievements-badge-to-get-picture' => 'add $1 {{PLURAL:$1|picture|pictures}} to {{PLURAL:$1|a page|pages}}',
	'achievements-badge-to-get-category' => 'add $1 {{PLURAL:$1|page|pages}} to {{PLURAL:$1|a category|categories}}',
	'achievements-badge-to-get-blogpost' => 'write $1 {{PLURAL:$1|blog post|blog posts}}',
	'achievements-badge-to-get-blogcomment' => 'write a comment on {{PLURAL:$1|a blog post|$1 different blog posts}}',
	'achievements-badge-to-get-love' => 'contribute to the wiki every day for {{PLURAL:$1|one day|$1 days}}',
	'achievements-badge-to-get-welcome' => 'join the wiki',
	'achievements-badge-to-get-introduction' => 'add to your own user page',
	'achievements-badge-to-get-sayhi' => 'leave someone a message on their talk page',
	'achievements-badge-to-get-creator' => 'be the creator of this wiki',
	'achievements-badge-to-get-pounce' => 'be quick',
	'achievements-badge-to-get-caffeinated' => 'make {{PLURAL:$1|one edit|$1 edits}} on pages in a single day',
	'achievements-badge-to-get-luckyedit' => 'be lucky',

	/*
	 * Badges' details for challenges list hovers on user profile
	 */
	'achievements-badge-to-get-edit-details' => 'Is something missing?
Is there a mistake?
Don\'t be shy.
Click the "{{int:edit}}" button and you can add to any page!',
	'achievements-badge-to-get-edit-plus-category-details' => 'The <strong>$1</strong> pages need your help!
Click the "{{int:edit}}" button on any page in that category to help out.
Show your support for the $1 pages!',
	'achievements-badge-to-get-picture-details' => 'Click the "{{int:edit}}" button, and then the "{{int:rte-ck-image-add}}" button.
	You can add a photo from your computer, or from another page on the wiki.',
	'achievements-badge-to-get-category-details' => 'Categories are tags that help readers find similar pages.
Click the "{{int:categoryselect-addcategory-button}}" button at the bottom of a page to list that page in a category.',
	'achievements-badge-to-get-blogpost-details' => 'Write your opinions and questions!
Click on "{{int:blogs-recent-url-text}}" in the sidebar, and then the link on the left for "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Add your two cents!
Read any of the recent blog posts, and write your thoughts in the comments box.',
	'achievements-badge-to-get-love-details' => 'The counter resets if you miss a day, so be sure to come back to the wiki every day!',
	'achievements-badge-to-get-welcome-details' => 'Click the "{{int:autocreatewiki-create-account}}" button at the top right to join the community.
You can start earning your own badges!',
	'achievements-badge-to-get-introduction-details' => 'Is your user page empty?
Click on your user name at the top of the screen to see.
Click "{{int:edit}}" to add some information about yourself!',
	'achievements-badge-to-get-sayhi-details' => 'You can leave other users messages by clicking "{{int:tooltip-ca-addsection}}" on their talk page.
Ask for help, thank them for their work, or just say hi!',
	'achievements-badge-to-get-creator-details' => 'This badge is given to the person who founded the wiki.
Click the "{{int:createwiki}}" button at the top to start a site about whatever you like most!',
	'achievements-badge-to-get-pounce-details' => 'You have to be quick to earn this badge.
Click the "{{int:activityfeed}}" button to see the new pages that users are creating!',
	'achievements-badge-to-get-caffeinated-details' => 'It takes a busy day to earn this badge.
Keep editing!',
	'achievements-badge-to-get-luckyedit-details' => 'You have got to be lucky to earn this badge.
Keep editing!',
	'achievements-badge-to-get-community-platinum-details' => 'This is a special Platinum badge that is only available for a limited time!',

	/*
	 * Badges' details for badges list hovers on user profile
	 */
	'achievements-badge-hover-desc-edit' => 'for making $1 {{PLURAL:$1|edit|edits}}<br />
on {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'for making $1 {{PLURAL:$1|edit|edits}}<br />
on {{PLURAL:$1|a $2 page|$2 pages}}!',
	'achievements-badge-hover-desc-picture' => 'for adding $1 {{PLURAL:$1|picture|pictures}}<br />
to {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-hover-desc-category' => 'for adding $1 {{PLURAL:$1|page|pages}}<br />
to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-hover-desc-blogpost' => 'for writing $1 {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-hover-desc-blogcomment' => 'for writing a comment<br />
on $1 different {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-hover-desc-love' => 'for contributing to the wiki every day for {{PLURAL:$1|one day|$1 days}}!',
	'achievements-badge-hover-desc-welcome' => 'for joining the wiki!',
	'achievements-badge-hover-desc-introduction' => 'for adding to<br />
your own user page!',
	'achievements-badge-hover-desc-sayhi' => 'for leaving a message<br />
on someone else\'s talk page!',
	'achievements-badge-hover-desc-creator' => 'for creating the wiki!',
	'achievements-badge-hover-desc-pounce' => 'for making edits on 100 pages within an hour of the page\'s creation!',
	'achievements-badge-hover-desc-caffeinated' => 'for making 100 edits on pages in a single day!',
	'achievements-badge-hover-desc-luckyedit' => 'for making the Lucky $1th Edit on the wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'This is a special Platinum badge that is only available for a limited time!',

	/*
	 * Badges' details for info in notification
	 */
	'achievements-badge-your-desc-edit' => 'for making {{PLURAL:$1|your first edit|$1 edits}} on {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'for making {{PLURAL:$1|your first edit|$1 edit}} on {{PLURAL:$1|a $2 page|$2 pages}}!',
	'achievements-badge-your-desc-picture' => 'for adding {{PLURAL:$1|your first picture|$1 pictures}} to {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-your-desc-category' => 'for adding {{PLURAL:$1|your first page|$1 pages}} to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-your-desc-blogpost' => 'for writing {{PLURAL:$1|your first blog post|$1 blog posts}}!',
	'achievements-badge-your-desc-blogcomment' => 'for writing a comment on {{PLURAL:$1|a blog post|$1 different blog posts}}!',
	'achievements-badge-your-desc-love' => 'for contributing to the wiki every day for {{PLURAL:$1|one day|$1 days}}!',
	'achievements-badge-your-desc-welcome' => 'for joining the wiki!',
	'achievements-badge-your-desc-introduction' => 'for adding to your own user page!',
	'achievements-badge-your-desc-sayhi' => 'for leaving a message on someone else\'s talk page!',
	'achievements-badge-your-desc-creator' => 'for creating the wiki!',
	'achievements-badge-your-desc-pounce' => 'for making edits on 100 pages within an hour of the page\'s creation!',
	'achievements-badge-your-desc-caffeinated' => 'for making 100 edits on pages in a single day!',
	'achievements-badge-your-desc-luckyedit' => 'for making the Lucky $1th edit on the wiki!',

	/*
	 * Badges' details for recent badges list on leaderboard
	 */
	'achievements-badge-desc-edit' => 'for making $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-desc-edit-plus-category' => 'for making $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a $2 page|$2 pages}}!',
	'achievements-badge-desc-picture' => 'for adding $1 {{PLURAL:$1|picture|pictures}} to {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-desc-category' => 'for adding $1 {{PLURAL:$1|page|pages}} to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-desc-blogpost' => 'for writing $1 {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-desc-blogcomment' => 'for writing a comment on {{PLURAL:$1|a blog post|$1 different blog posts}}!',
	'achievements-badge-desc-love' => 'for contributing to the wiki every day for {{PLURAL:$1|a day|$1 days}}!',
	'achievements-badge-desc-welcome' => 'for joining the wiki!',
	'achievements-badge-desc-introduction' => 'for adding to your own user page!',
	'achievements-badge-desc-sayhi' => 'for leaving a message on someone else\'s talk page!',
	'achievements-badge-desc-creator' => 'for creating the wiki!',
	'achievements-badge-desc-pounce' => 'for making edits on 100 pages within an hour of the page\'s creation!',
	'achievements-badge-desc-caffeinated' => 'for making 100 edits on pages in a single day!',
	'achievements-badge-desc-luckyedit' => 'for making the Lucky $1th edit on the wiki!',
);

/** Message documentation (Message documentation)
 * @author Avatar
 * @author LWChris
 * @author McDutchie
 * @author Siebrand
 */
$messages['qqq'] = array(
	'achievements-edit-plus-category-track-exists' => '{{doc-important|Do not change the link itself.}}
Parameters:
* $1 is the ID of an existing track used to jump to.',
	'achievements-you-must' => 'Parameters:
* $1 is the description of what needs to be achieved to earn a badge.

Possible messages for $1 are: {{msg-mw|achievements-badge-to-get-blogcomment|notext=1}}, {{msg-mw|achievements-badge-to-get-blogpost|notext=1}}, {{msg-mw|achievements-badge-to-get-caffeinated|notext=1}}, {{msg-mw|achievements-badge-to-get-category|notext=1}}, {{msg-mw|achievements-badge-to-get-creator|notext=1}}, {{msg-mw|achievements-badge-to-get-edit|notext=1}}, {{msg-mw|achievements-badge-to-get-edit-plus-category|notext=1}}, {{msg-mw|achievements-badge-to-get-introduction|notext=1}}, {{msg-mw|achievements-badge-to-get-love|notext=1}}, {{msg-mw|achievements-badge-to-get-luckyedit|notext=1}}, {{msg-mw|achievements-badge-to-get-picture|notext=1}}, {{msg-mw|achievements-badge-to-get-pounce|notext=1}}, {{msg-mw|achievements-badge-to-get-sayhi|notext=1}}, {{msg-mw|achievements-badge-to-get-welcome|notext=1}}',
	'achievements-masthead-points' => 'Parameters:
* $1 is the number of earned points.',
	'achievements-track-name-edit' => 'Capitalization has been requested by Product Management, please don\'t change it.

This is a track name, so "edit" is a noun, not a verb. In other words, this could be translated as "track of edits", \'\'not\'\' as "edit the track".',
	'achievements-track-name-picture' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-track-name-category' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-track-name-blogpost' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-track-name-blogcomment' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-track-name-love' => "Capitalization has been requested by Product Management, please don't changeit",
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
	'achievements-profile-title' => "Capitalization has been requested by Product Management, please don't change it. Parameters:
* $1 is a user name
* $2 is the number of earned badges",
	'achievements-profile-title-no' => "Capitalization has been requested by Product Management, please don't change it. Parameters:
* $1 is a user name.",
	'achievements-profile-title-challenges' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-ranked' => 'Parameter:
* $1 is the rank number of a user on a wiki with regards to achievement points.',
	'achievements-recent-earned-badges' => "Capitalization has been requested by Product Management, please don't changeit",
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
	'achievements-community-platinum-awarded-email-body-html' => 'Parameters:
* $1 is the user name of the user to which the badge was awarded
* $2 is the badge name
* $3 is a URL to the server script path
* $4 is the site name
* $5 is a URL to a user profile page',
	'achievements-badge-name-edit-0' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-edit-1' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-edit-2' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-edit-3' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-edit-4' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-edit-5' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-edit-6' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-edit-7' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-category-0' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-category-1' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-category-3' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-category-5' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-category-6' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-blogpost-0' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-blogpost-1' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-blogpost-2' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-blogpost-3' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-blogpost-4' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-blogcomment-1' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-love-0' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-love-1' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-love-5' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-love-6' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-welcome' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-sayhi' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-creator' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-name-luckyedit' => "Capitalization has been requested by Product Management, please don't changeit",
	'achievements-badge-to-get-edit-plus-category' => '$2 is a pagetype, e. g. content, talk, etc.',
	'achievements-badge-to-get-edit-plus-category-details' => 'What is $1 here? Possibly localised (?) form of "category", or another namespace name.',
	'achievements-badge-to-get-sayhi-details' => 'The word "people" has been requested by Product Management, please don\'t changeit',
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
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'achievementsii-desc' => 'Ur sistem badjoù evit implijerien ar wiki',
	'achievements-upload-error' => "Digarezit !
Ar skeudenn-mañ ne 'z a ket en-dro.
Bezit sur ez eo ur restr .jpg pe .png
Ma ne 'z a ket en-dro c'hoazh ez eo marteze peogwir eo re bounner ar skeudenn.
Mar plij klaskit gant unan all !",
	'achievements-upload-not-allowed' => 'Gellout a ra ar verourien kemm anvioù ha skeudennoù badjoù an tournamantoù en ur vont war pajenn [[Special:AchievementsCustomize|personelaat an tournamantoù]].',
	'achievements-non-existing-category' => "N'eus ket eus an rummad meneget.",
	'achievements-edit-plus-category-track-exists' => 'Ar rummad meneget he deus dija un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Mont d\'an tournamant">tournamant kevelet</a>.',
	'achievements-no-stub-category' => 'Mar plij na grouit ket a dournamant evit an divrazoù.',
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Aour',
	'achievements-silver' => "Arc'hant",
	'achievements-bronze' => 'Arem',
	'achievements-you-must' => 'Rankout a rit $1 evit gounit ar badj-mañ.',
	'leaderboard-button' => 'Taolenn an tournamantoù',
	'achievements-masthead-points' => '$1 <small>poent{{PLURAL:$1||}}</small>',
	'achievements-track-name-edit' => 'Tournamantoù embann',
	'achievements-track-name-picture' => 'Tournamant skeudennaouiñ',
	'achievements-track-name-category' => 'Tournamant rummadoù',
	'achievements-track-name-blogpost' => 'Tournamant embannadur war ur blog',
	'achievements-track-name-blogcomment' => 'Tournamant evezhiadennoù diwar-benn ur blog',
	'achievements-track-name-love' => 'Tournamant "Karantez evit ar Wiki"',
	'achievements-notification-title' => "War an hent mat emaoc'h, $1 !",
	'achievements-notification-subtitle' => '$2 emaoc\'h o paouez gounit ar badj "$1"',
	'achievements-notification-link' => "<strong><big>[[Special:MyPage|Sellit ouzh muioc'h a badjoù a c'hellit gounid]] !</big></strong>",
	'achievements-points' => '$1 poent{{PLURAL:$1||}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|poent|poent}}',
	'achievements-earned' => 'Gounezet eo bet ar badj-mañ gant {{PLURAL:$1|1|$1}} implijer.',
	'achievements-profile-title' => 'An $2 {{PLURAL:$2||badj|badj}} gounezet gant $1',
	'achievements-profile-title-no' => 'Badjoù $1',
	'achievements-profile-title-challenges' => "Badjoù all hag a c'hellit gounit !",
	'achievements-profile-customize' => 'Personelaat ar badjoù >',
	'achievements-ranked' => 'Renket #$1 war ar wiki-mañ',
	'achievements-no-badges' => "Taolit ur sell d'ar roll amañ a-is evit gwelet ar badjoù a c'hellit gounid war ar wiki-mañ !",
	'achievements-viewall' => 'Gwelet pep tra',
	'achievements-viewless' => 'Serriñ',
	'achievements-viewall-oasis' => 'Gwelet pep tra',
	'leaderboard' => 'Taolenn an tournamantoù',
	'achievements-recent-earned-badges' => 'Badjoù gounezet nevez zo',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />gounezet gant <a href="$1">$2</a><br />$5',
	'achievements-leaderboard-rank-label' => 'renk',
	'achievements-leaderboard-member-label' => 'ezel',
	'achievements-leaderboard-points-label' => 'poentoù',
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
	'achievements-community-platinum-awarded-email-body-html' => '↓ <strong>Gourc\'hemennoù $1 ! </strong><br /><br />

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
	'achievements-badge-name-edit-0' => "A ra an diforc'h",
	'achievements-badge-name-edit-1' => "N'eo nemet ar pennkentañ",
	'achievements-badge-name-edit-3' => "Mignon d'ar wiki",
	'achievements-badge-name-edit-4' => 'Kenlabourer',
	'achievements-badge-name-edit-5' => 'Saver Wiki',
	'achievements-badge-name-edit-6' => 'Levier ar Wiki',
	'achievements-badge-name-edit-7' => 'Arbennigour Wiki',
	'achievements-badge-name-picture-0' => 'Prim',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Skeudennaouer',
	'achievements-badge-name-picture-3' => 'Dastumader',
	'achievements-badge-name-picture-4' => 'Hag a gar an arz',
	'achievements-badge-name-picture-5' => 'Kinklour',
	'achievements-badge-name-picture-6' => 'Neuzier',
	'achievements-badge-name-picture-7' => 'Mirour',
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
	'achievements-badge-name-love-5' => 'Ur Wiki-buhez',
	'achievements-badge-name-love-6' => 'Haroz ar Wiki !',
	'achievements-badge-name-welcome' => "Deuet mat oc'h war ar Wiki",
	'achievements-badge-name-introduction' => 'Digoradur',
	'achievements-badge-name-creator' => "Ar C'hrouer",
	'achievements-badge-name-pounce' => "Loc'het eo",
	'achievements-badge-name-caffeinated' => 'Gant kafein',
	'achievements-badge-name-luckyedit' => 'Kemm gant chañs',
	'achievements-badge-to-get-edit' => 'ober $1 kemm war {{PLURAL:$1|ur bajenn|pajennoù}}',
	'achievements-badge-to-get-edit-plus-category' => "ober {{PLURAL:$1|ur c'hemm|$1 kemm}} war {{PLURAL:$1|ur bajenn|pajennoù}} $2",
	'achievements-badge-to-get-picture' => "ouzhpennañ $1 skeudenn{{PLURAL:$1||}} {{PLURAL:$1|d'ur bajenn|da pajennoù}}",
	'achievements-badge-to-get-category' => "ouzhpennañ $1 pajenn{{PLURAL:$1||}} {{PLURAL:$1|d'ur rummad|da rummadoù}}",
	'achievements-badge-to-get-love' => 'kemer perzh er wiki bemdez e-pad $1 devezh{{PLURAL:}}',
	'achievements-badge-to-get-welcome' => 'dont war ar wiki',
	'achievements-badge-to-get-introduction' => "ouzhpennañ d'ho pajenn implijer",
	'achievements-badge-to-get-sayhi' => "leuskel ur gemennadenn d'unan bennak war e bajenn implijer",
	'achievements-badge-to-get-creator' => 'bezañ krouer ar wiki',
	'achievements-badge-to-get-pounce' => 'bezañ prim',
	'achievements-badge-to-get-caffeinated' => "ober {{PLURAL:$1|ur c'hemm|$1 kemm}} er pajennoù en un devezh",
	'achievements-badge-to-get-luckyedit' => 'kaout chañs',
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
	'achievements-badge-to-get-love-details' => "Adderaouekaat e vez ar c'honter ma c'hwitit un devezh. Bezit sur distreiñ bemdez war ar wiki !",
	'achievements-badge-to-get-welcome-details' => 'Klikit war ar bouton "{{int:autocreatewiki-create-account}}" en nec\'h a zehou evit dont er gumuniezh.
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
	'achievements-badge-hover-desc-edit' => "evit bezañ degaset $1 {{PLURAL:$1|c'hemm|kemm}}<br />
war {{PLURAL:$1|ur bajenn|pajennoù}} !",
	'achievements-badge-hover-desc-edit-plus-category' => "evit bezañ degaset $1 {{PLURAL:$1|c'hemm|kemm}}<br />
war {{PLURAL:$1|un $2 pajenn|$2 pajenn}} !",
	'achievements-badge-hover-desc-picture' => 'evit bezañ ouzhpennet $1 {{PLURAL:$1|skeudenn|skeudenn}}<br />
war {{PLURAL:$1ur bajenn|pajennoù}} !',
	'achievements-badge-hover-desc-category' => "evit bezañ ouzhpennet $1 {{PLURAL:$1|bajenn|pajenn}}<br />
{{PLURAL:$1|d'ur rummad|da rummadoù}} !",
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
	'achievements-badge-your-desc-edit' => 'Evit bezañ degaset ho {{PLURAL:$1|kemm gentañ|$1 kemm}} war {{PLURAL:$1|ur bajenn|pajennoù}} !',
	'achievements-badge-your-desc-edit-plus-category' => 'evit bezañ degaset {{PLURAL:$1|ho kemm gentañ|$1 kemm}} war {{PLURAL:$1|ur bajenn|$2 pajenn}}!',
	'achievements-badge-your-desc-picture' => 'Evit bezañ degaset ho {{PLURAL:$1|skeudenn gentañ|$1 skeudenn}} war {{PLURAL:$1|ur bajenn|pajennoù}} !',
	'achievements-badge-your-desc-category' => "evit bezañ ouzhpennet {{PLURAL:$1|ho pajenn gentañ|$1 pajenn}} {{PLURAL:$1|d'ur rummad|da rummadoù}} !",
	'achievements-badge-your-desc-welcome' => 'evit bezañ deuet war ar wiki !',
	'achievements-badge-your-desc-introduction' => 'evit bezañ ouzhpennet titouroù war ho pajenn implijer !',
	'achievements-badge-your-desc-sayhi' => 'evit bezañ laosket ur gemennadenn war pajenn kaozeal unan bennak all !',
	'achievements-badge-your-desc-creator' => 'evit bezañ krouet ar wiki !',
	'achievements-badge-your-desc-pounce' => 'evit bezañ degaset kemmoù war 100 pajenn en eurvezh goude krouidigezh ar bajenn !',
	'achievements-badge-your-desc-caffeinated' => 'evit bezañ degaset 100 kemm e pajennoù en un devezh !',
	'achievements-badge-your-desc-luckyedit' => 'evit bezañ degaset ar $1vet kemm gant chañs war ar wiki !',
	'achievements-badge-desc-edit' => "evit bezañ degaset $1 {{PLURAL:$1|c'hemm|kemm}} war {{PLURAL:$1|ur bajenn|pajennoù}} !",
	'achievements-badge-desc-edit-plus-category' => 'evit bezañ degaset $1 kemm war {{PLURAL:$1|ur bajenn|$2 pajenn}}!',
	'achievements-badge-desc-picture' => 'evit bezañ ouzhpennet $1 {{PLURAL:$1|skeudenn|skeudenn}} war {{PLURAL:$1ur bajenn|pajennoù}} !',
	'achievements-badge-desc-category' => "evit bezañ ouzhpennet $1 {{PLURAL:$1|bajenn|pajenn}} {{PLURAL:$1|d'ur rummad|da rummadoù}} !",
	'achievements-badge-desc-love' => 'evit bezañ kemeret perzh er wiki bemdez e-pad {{PLURAL:$1|un devezh|$1 devezh}} !',
	'achievements-badge-desc-welcome' => 'evit bezañ deuet war ar wiki !',
	'achievements-badge-desc-introduction' => "evit bezañ ouzhpennet d'ho pajenn implijer !",
	'achievements-badge-desc-sayhi' => 'evit bezañ laosket ur gemennadenn war pajenn kaozeal unan bennak all !',
	'achievements-badge-desc-creator' => 'evit bezañ krouet ar wiki !',
	'achievements-badge-desc-pounce' => 'evit bezañ degaset kemmoù war 100 pajenn en eurvezh goude krouidigezh ar bajenn !',
	'achievements-badge-desc-caffeinated' => 'evit bezañ degaset 100 kemm e pajennoù en un devezh !',
	'achievements-badge-desc-luckyedit' => 'evit bezañ degaset ar $1vet kemm gant chañs war ar wiki !',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Palapa
 */
$messages['bs'] = array(
	'achievements-platinum' => 'platina',
	'achievements-gold' => 'Zlato',
	'achievements-silver' => 'Srebro',
	'achievements-bronze' => 'Bronza',
	'achievements-you-must' => 'Potrebno je da $1 da biste dobili ovu značku.',
	'leaderboard-button' => 'Tabela dostignuća',
	'achievements-track-name-edit' => 'Zapis o uređivanjima',
	'achievements-track-name-picture' => 'Zapis o slikama',
	'achievements-track-name-category' => 'Zapis o kategorijama',
	'achievements-track-name-blogpost' => 'Zapis o postavljenim blogovima',
	'achievements-track-name-blogcomment' => 'Zapis o komentarima na blogu',
	'achievements-track-name-love' => 'Zapis o Wiki Love',
	'achievements-notification-subtitle' => '$2 upravo ste zaradili "$1" značku',
	'achievements-profile-title-no' => 'Značke korisnika $1',
	'achievements-profile-title-challenges' => 'Više znački koje možete zaraditi!',
	'achievements-profile-customize' => 'Prilagodi značke >',
	'achievements-ranked' => 'Rangiran #$1 na ovoj wiki',
	'achievements-no-badges' => 'Provjeri donju listu da vidiš koje značke možeš zaraditi na ovoj wiki!',
	'achievements-viewall' => 'Pogledaj sve',
	'achievements-viewless' => 'Zatvori',
	'achievements-viewall-oasis' => 'Vidi sve',
	'leaderboard' => 'Tabela vodećih dostignuća',
	'achievements-recent-earned-badges' => 'Nedavno Osvojene Značke',
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
	'achievements-badge-name-introduction' => 'Uvod',
	'achievements-badge-desc-welcome' => 'za pridruživanje na wiki!',
	'achievements-badge-desc-introduction' => 'za pravljenje vlastite korisničke stranice!',
	'achievements-badge-desc-sayhi' => 'za ostavljanje poruke na nečijoj stranici za razgovor!',
	'achievements-badge-desc-creator' => 'za pravljenje wiki!',
);

/** Catalan (Català) */
$messages['ca'] = array(
	'achievements-gold' => 'Or',
	'achievements-silver' => 'Plata',
);

/** German (Deutsch)
 * @author Avatar
 * @author ChrisiPK
 * @author Dardio
 * @author Kjell
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de'] = array(
	'achievementsii-desc' => 'Leistungsbasierte Abzeichen für Wiki-Benutzer',
	'achievements-upload-error' => 'Entschuldigung!
Dieses Bild funktioniert nicht.
Stelle sicher, dass es sich um eine .jpg- oder- .png-Datei handelt.
Wenn es immer noch nicht funktioniert, dann ist das Bild wohl zu groß.
Bitte versuche es mit einem anderen!',
	'achievements-upload-not-allowed' => 'Administratoren können die Namen und Bilder von Abzeichen durch die [[Special:AchievementsCustomize|Abzeichen ändern]]-Seite anpassen.',
	'achievements-non-existing-category' => 'Die angegebene Kategorie existiert nicht.',
	'achievements-edit-plus-category-track-exists' => 'Die angegebene Kateogrie hat bereits eine <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">Laufbahn</a>.',
	'achievements-no-stub-category' => 'Bitte lege keine Laufbahn für Stubs an.',
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Gold',
	'achievements-silver' => 'Silber',
	'achievements-bronze' => 'Bronze',
	'achievements-you-must' => 'Du musst $1 um dieses Abzeichen zu verdienen.',
	'leaderboard-button' => 'Rangliste',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|Punkt|Punkte}}</small>',
	'achievements-track-name-edit' => 'Bearbeitungen-Laufbahn',
	'achievements-track-name-picture' => 'Bilder-Laufbahn',
	'achievements-track-name-category' => 'Kategorie-Laufbahn',
	'achievements-track-name-blogpost' => 'Blogeintrag-Laufbahn',
	'achievements-track-name-blogcomment' => 'Blogkommentar-Laufbahn',
	'achievements-track-name-love' => 'Wiki Love-Laufbahn',
	'achievements-notification-title' => 'Weiter so, $1!',
	'achievements-notification-subtitle' => 'Du hast gerade das „$1“-Abzeichen erhalten $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Mehr von dir verdienbare Abzeichen ansehen]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|Punkt|Punkte}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|Punkt|Punkte}}',
	'achievements-earned' => 'Dieses Abzeichen wurde von {{PLURAL:$1|einem Benutzer|$1 Benutzern}} verdient.',
	'achievements-profile-title' => '$1 hat $2 {{PLURAL:$2|Auszeichnung|Auszeichnungen}} erhalten',
	'achievements-profile-title-no' => 'Abzeichen von $1',
	'achievements-profile-title-challenges' => 'Mehr von dir verdienbare Abzeichen!',
	'achievements-profile-customize' => 'Abzeichen anpassen',
	'achievements-ranked' => 'Platz #$1 in diesem Wiki',
	'achievements-no-badges' => 'Schau dir die Liste unten an, um die Abzeichen anzusehen, die du dir in diesem Wiki verdienen kannst!',
	'achievements-viewall' => 'Alle anzeigen',
	'achievements-viewless' => 'Schließen',
	'achievements-viewall-oasis' => 'Sehe alle',
	'leaderboard-intro' => "'''&ldquo;Was sind Herausforderungen?&rdquo;'''
Du kannst spezielle Abzeichen durch die Teilnahme in diesem Wiki verdienen!
Jedes Abzeichen, das du verdienst, bringt dir Punkte für deine Gesamtpunktzahl:
Bronze-Abzeichen sind 10 Punkte wert, Silber-Abzeichen haben einen Wert von 50 Punkten und Gold-Abzeichen sind 100 Punkte wert.

Wenn du dem Wiki beitrittst, zeigt dein Benutzerprofil die Abzeichen an, die du verdient hast, und zeigt dir eine Liste der Herausforderungen, die für dich verfügbar sind. 
[[Special:MyPage|Geh zu deinem Benutzerprofil um es dir anzusehen]]!",
	'leaderboard' => 'Rangliste',
	'achievements-recent-earned-badges' => 'Kürzlich Verdiente Abzeichen',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />verdient von <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'hat sich das <strong><a href="$3" class="badgeName">$1</a></strong>-Abzeichen verdient<br />$2',
	'achievements-leaderboard-disclaimer' => 'Rangliste zeigt die Veränderungen seit gestern',
	'achievements-leaderboard-rank-label' => 'Rang',
	'achievements-leaderboard-member-label' => 'Mitglied',
	'achievements-leaderboard-points-label' => 'Punkte',
	'achievements-send' => 'Bild speichern',
	'achievements-save' => 'Änderungen speichern',
	'achievements-reverted' => 'Abzeichen auf das Original zurückgesetzt.',
	'achievements-customize' => 'Eigenes Bild verwenden',
	'achievements-customize-new-category-track' => 'Eine neue Laufbahn für diese Kategorie erstellen:',
	'achievements-enable-track' => 'aktiviert',
	'achievements-revert' => 'Auf Standard zurücksetzen',
	'achievements-special-saved' => 'Änderungen gespeichert.',
	'achievements-special' => 'Besondere Herausforderungen',
	'achievements-secret' => 'Geheime Herausforderungen',
	'achievementscustomize' => 'Abzeichen anpassen',
	'achievements-about-title' => 'Über diese Seite...',
	'achievements-about-content' => 'Administratoren in diesem Wiki können die Namen und Bilder der Abzeichen in diesem Wiki anpassen.

Du kannst ein beliebiges .jpg- oder .png-Bild hochladen, und dein Bild wird automatisch in den Rahmen passen.
Das funktioniert am besten, wenn dein Bild quadratisch ist, und wenn der wichtigste Teil des Bildes genau in der Mitte ist.

Du kannst auch rechteckige Bilder verwenden, wirst aber vielleicht feststellen, dass ein Teil des Rahmens abgeschnitten wird.
Wenn du ein Bildbearbeitungs-Programm hast, kannst du das Bild zuschneiden, um den wichtigsten Teil des Bildes in die Mitte zu bringen.
Wenn du kein Bildbearbeitungs-Programm hast, dann experimentiere einfach mit verschiedenen Bildern, bis du die findest, die für dich funktionieren!
Wenn du das von dir gewählte Bild nicht magst, klicke auf „{{int:achievements-revert}}“, um es wieder auf die ursprüngliche Grafik zurückzusetzen.

Du kannst auch den Abzeichen einen neuen Namen geben, welche das Thema des Wikis wiedergeben.
Wenn du den Namen geändert hast, klicke auf „{{int:achievements-save}}“ um die Änderungen zu speichern.
Viel Spaß!',
	'achievements-edit-plus-category-track-name' => '$1 Bearbeitungen-Laufbahn',
	'achievements-create-edit-plus-category-title' => 'Eine neue Laufbahn für Bearbeitungen erstellen',
	'achievements-create-edit-plus-category-content' => 'Du kannst einen neuen Satz Abzeichen erstellen um Benutzer für die Bearbeitung von Seiten in einer bestimmten Kategorie zu belohnen, um so einen bestimmten Bereich der Seite hervorzuheben, in dem Benutzer gerne arbeiten würden.
Du kannst mehrere Kategorie-Laufbahnen erstellen, also versuchen zwei Kategorien zu wählen, die die Besonderheit der Benutzer hervorheben!
Entzünde einen Rivalitätenkampf zwischen den Benutzern, die Vampirseiten bearbeiten und den Benutzern, die Werwolfseiten bearbeiten, oder Zauberer und Muggel, oder Autobots und Decepticons.

Um eine neue „Bearbeitung in einer Kategorie“-Laufbahn zu erstellen, gib den Namen der Kategorie in das Feld unterhalb ein.
Die normale Bearbeitungen-Laufbahn wird weiterhin existieren;
dies wird eine eigene Bearbeitungen-Laufbahn erstellen, die du separat anpassen kannst.

Wenn die Laufbahn erstellt wurde, wird das neue Abzeichen in der Liste links unter der normalen Bearbeitungen-Laufbahn erscheinen.
Passe den Namen und das Bild der neuen Laufbahn an, sodass Benutzer den Unterschied sehen!

Sobald du die Anpassungen vorgenommen hast, hake das {{int:achievements-enable-track}}-Kontrollkästchen an um die neue Laufbahn zu aktivieren, und klicke dann auf „{{int:achievements-save}}“.
Du kannst die Laufbahn auch später wieder deaktivieren, wenn du entscheidest, dass du diese Kategorie nicht mehr hervorheben möchtest.
Benutzer, die Abzeichen dieser Laufbahn erhalten haben, werden ihre Abzeichen immer behalten, auch, wenn die Laufbahn wieder deaktiviert wurde.

Dies kann helfen, eine neue Dimension der Freude zu den Erfolgen hinzuzufügen.
Versuchs mal!',
	'achievements-create-edit-plus-category' => 'Diese Laufbahn erstellen',
	'platinum' => 'Platin',
	'achievements-community-platinum-awarded-email-subject' => 'Du hast ein neues Platin-Abzeichen erhalten!',
	'achievements-community-platinum-awarded-email-body-text' => "Herzlichen Glückwunsch $1!

Du bist gerade mit dem '$2' Platin-Abzeichen bei $4 ($3) versehen worden.
Dafür gibt es 250 Punkte auf dein Konto!

Schau dir dein hübsches neues Abzeichen auf deiner Benutzerseite an:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Herzlichen Glückwunsch $1!</strong><br /><br />
Du bist gerade mit dem \'<strong>$2</strong>\' Platin-Abzeichen bei <a href="$3">$4</a> versehen worden.
Dafür gibt es 250 Punkte auf dein Konto!<br /><br />
Schau dir dein hübsches neues Abzeichen auf deiner <a href="$5">Benutzerseite</a> an.',
	'achievements-community-platinum-awarded-for' => 'Ausgezeichnet für:',
	'achievements-community-platinum-how-to-earn' => 'Wie zu verdienen:',
	'achievements-community-platinum-awarded-for-example' => 'z. B. „durch...“',
	'achievements-community-platinum-how-to-earn-example' => 'z. B. „3 Bearbeitungen...“',
	'achievements-community-platinum-badge-image' => 'Abzeichen Bild:',
	'achievements-community-platinum-awarded-to' => 'Vergeben an:',
	'achievements-community-platinum-current-badges' => 'Aktuelle Platin-Abzeichen',
	'achievements-community-platinum-create-badge' => 'Abzeichen erstellen',
	'achievements-community-platinum-enabled' => 'aktiviert',
	'achievements-community-platinum-show-recents' => 'In den letzten Abzeichen anzeigen',
	'achievements-community-platinum-edit' => 'bearbeiten',
	'achievements-community-platinum-save' => 'speichern',
	'achievements-badge-name-edit-0' => 'Macht einen Unterschied',
	'achievements-badge-name-edit-1' => 'Nur der Anfang',
	'achievements-badge-name-edit-2' => 'Machst Dir Einen Namen',
	'achievements-badge-name-edit-3' => 'Freund des Wikis',
	'achievements-badge-name-edit-4' => 'Mitarbeiter',
	'achievements-badge-name-edit-5' => 'Wiki Aufbauer',
	'achievements-badge-name-edit-6' => 'Wiki Anführer',
	'achievements-badge-name-edit-7' => 'Wiki Experte',
	'achievements-badge-name-picture-0' => 'Schnappschuss',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Illustrator',
	'achievements-badge-name-picture-3' => 'Sammler',
	'achievements-badge-name-picture-4' => 'Kunstliebhaber',
	'achievements-badge-name-picture-5' => 'Dekorateur',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Kurator',
	'achievements-badge-name-category-0' => 'Macht eine Verbindung',
	'achievements-badge-name-category-1' => 'Wegbereiter',
	'achievements-badge-name-category-2' => 'Forscher',
	'achievements-badge-name-category-3' => 'Tour Guide',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Brückenbauer',
	'achievements-badge-name-category-6' => 'Wiki Planer',
	'achievements-badge-name-blogpost-0' => 'Hat was zu sagen',
	'achievements-badge-name-blogpost-1' => 'Fünf Dinge zu sagen',
	'achievements-badge-name-blogpost-2' => 'Talkshow',
	'achievements-badge-name-blogpost-3' => 'Herz der Partei',
	'achievements-badge-name-blogpost-4' => 'Redner',
	'achievements-badge-name-blogcomment-0' => 'Meinungssager',
	'achievements-badge-name-blogcomment-1' => 'Und noch eine Sache',
	'achievements-badge-name-love-0' => 'Schlüssel zum Wiki!',
	'achievements-badge-name-love-1' => 'Zwei Wochen im Wiki',
	'achievements-badge-name-love-2' => 'Hingebungsvoll',
	'achievements-badge-name-love-3' => 'Engagiert',
	'achievements-badge-name-love-4' => 'Süchtig',
	'achievements-badge-name-love-5' => 'Lebt im Wiki',
	'achievements-badge-name-love-6' => 'Held des Wikis!',
	'achievements-badge-name-welcome' => 'Willkommen im Wiki',
	'achievements-badge-name-introduction' => 'Einführung',
	'achievements-badge-name-sayhi' => 'Schaue vorbei und sage hi',
	'achievements-badge-name-creator' => 'Der Schöpfer',
	'achievements-badge-name-pounce' => 'Rumms!',
	'achievements-badge-name-caffeinated' => 'Koffeiniert',
	'achievements-badge-name-luckyedit' => 'Glückliche Bearbeitung',
	'achievements-badge-to-get-edit' => 'Mache $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} auf {{PLURAL:$1|einer Seite|Seiten}}',
	'achievements-badge-to-get-edit-plus-category' => 'mache {{PLURAL:$1|eine Bearbeitung|$1 Bearbeitungen}} auf {{PLURAL:$1|einer $2 Seite|$2 Seiten}}',
	'achievements-badge-to-get-picture' => 'Füge $1 {{PLURAL:$1|Bild|Bilder}} zu {{PLURAL:$1|einer Seite|Seiten}} hinzu',
	'achievements-badge-to-get-category' => 'füge $1 {{PLURAL:$1|Seite|Seiten}} zu {{PLURAL:$1|einer Kategorie|Kategorien}} hinzu',
	'achievements-badge-to-get-blogpost' => 'schreibe $1 {{PLURAL:$1|Blogeintrag|Blogeinträge}}',
	'achievements-badge-to-get-blogcomment' => 'schreibe einen Kommentar zu {{PLURAL:$1|einem Blogeintrag|$1 verschiedenen Blogeinträgen}}',
	'achievements-badge-to-get-love' => 'bearbeite das Wiki täglich über einen Zeitraum von {{PLURAL:$1|einem Tag|$1 Tagen}}',
	'achievements-badge-to-get-welcome' => 'trete dem Wiki bei',
	'achievements-badge-to-get-introduction' => 'füge zu deiner eigenen Benutzerseite hinzu',
	'achievements-badge-to-get-sayhi' => 'hinterlasse jemandem eine Nachricht auf seiner Diskussionsseite',
	'achievements-badge-to-get-creator' => 'sei der Schöpfer dieses Wikis',
	'achievements-badge-to-get-pounce' => 'sei schnell',
	'achievements-badge-to-get-caffeinated' => 'mache {{PLURAL:$1|eine Bearbeitung|$1 Bearbeitungen}} an einem einzigen Tag',
	'achievements-badge-to-get-luckyedit' => 'habe Glück',
	'achievements-badge-to-get-edit-details' => 'Fehlt etwas? 
Ist da ein Fehler? 
Keine Angst. 
Klicke auf den „{{int:edit}}“-Button und du kannst zu jeder Seite beitragen!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Die <strong>$1</strong> Seiten brauchen deine Hilfe!
Klicke auf den „{{int:edit}}“-Button auf einer beliebigen Seite in dieser Kategorie, um zu helfen.
Zeig deine Unterstützung für die $1 Seiten!',
	'achievements-badge-to-get-picture-details' => 'Klick auf den „{{int:edit}}“-Button und dann den „{{int:rte-ck-image-add}}“-Button.
Du kannst ein Foto von deinem Computer oder von einer anderen Seite im Wiki hinzufügen.',
	'achievements-badge-to-get-category-details' => 'Kategorien sind Schlagworte, die Lesern helfen ähnliche Seiten zu finden.
Klicke auf den „{{int:categoryselect-addcategory-button}}“-Button am unteren Rand einer Seite um sie in eine Kategorie einzuordnen.',
	'achievements-badge-to-get-blogpost-details' => 'Schreib deine Meinung und Fragen!
Klicke auf „{{int:blogs-recent-url-text}}“ in der Sidebar und danach den Link „{{int:create-blog-post-title}}“ auf der linken Seite!',
	'achievements-badge-to-get-blogcomment-details' => 'Gib deinen Senf dazu!
Lies einen der aktuellen Blog-Posts und schreib deine Meinung in das Kommentarfeld!',
	'achievements-badge-to-get-love-details' => 'Der Zähler geht auf null zurück, wenn du einen Tag verpasst. Komm also jeden Tag zum Wiki zurück!',
	'achievements-badge-to-get-welcome-details' => 'Klick auf den „{{int:autocreatewiki-create-account}}“-Button oben rechts, um der Gemeinschaft beizutreten.
Du kannst dir dann sofort eigene Auszeichnungen verdienen.',
	'achievements-badge-to-get-introduction-details' => 'Ist deine Benutzerseite leer?
Klicke auf deinen Benutzernamen oben rechts, um nachzusehen!
Klicke auf „{{int:edit}}“, um ein paar Informationen zu dir einzugeben!',
	'achievements-badge-to-get-sayhi-details' => 'Du kannst anderen Benutzern Nachrichten hinterlassen, indem du auf „{{int:tooltip-ca-addsection}}“ auf ihrer Diskussionsseite klickst.
Frage sie um Hilfe, danke ihnen für ihre Arbeit oder sag einfach mal Hallo!',
	'achievements-badge-to-get-creator-details' => 'Die Auszeichnung geht an die Person, die das Wiki gegründet hat.
Klicke auf den „{{int:createwiki}}“-Button oben, um dein eigenes Wiki zu einem beliebigen Thema zu erstellen!',
	'achievements-badge-to-get-pounce-details' => 'Du musst schnell sein, um diese Auszeichnung zu erhalten.
Klicke auf den „{{int:activityfeed}}“-Button, um die neuen Seiten zu sehen, die andere Benutzer erstellen!',
	'achievements-badge-to-get-caffeinated-details' => 'Du musst dich einen Tag ganz schön ranhalten, um diese Auszeichnung zu erhalten.
Also häng dich rein!',
	'achievements-badge-to-get-luckyedit-details' => 'Du musst Glück haben, um diese Auszeichnung zu erhalten.
Häng dich rein!',
	'achievements-badge-to-get-community-platinum-details' => 'Dies ist eine spezielle Platinum-Auszeichnung, die nur kurze Zeit verfügbar ist.',
	'achievements-badge-hover-desc-edit' => 'für $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}}<br />
auf {{PLURAL:$1|einer Seite|$1 Seiten}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'für $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}}<br />
auf {{PLURAL:$1|einer $2 Seite|$2 Seiten}}!',
	'achievements-badge-hover-desc-picture' => 'für das Hinzufügen von $1 {{PLURAL:$1|Bild|Bildern}}<br />
zu {{PLURAL:$1|einer Seite|Seiten}}!',
	'achievements-badge-hover-desc-category' => 'für das Hinzufügen von $1 {{PLURAL:$1|Seite|Seiten}}<br />
zu {{PLURAL:$1|einer Kategorie|Kategorien}}!',
	'achievements-badge-hover-desc-blogpost' => 'für das Verfassen von $1 {{PLURAL:$1|Blogbeitrag|Blogbeiträgen}}!',
	'achievements-badge-hover-desc-blogcomment' => 'für das Verfassen eines Kommentars<br />
zu $1 verschiedenen {{PLURAL:$1|Blogeintrag|Blogeinträgen}}!',
	'achievements-badge-hover-desc-love' => 'für einen täglichen Beitrag im Wiki über einen Zeitraum von {{PLURAL:$1|einem Tag|$1 Tagen}}!',
	'achievements-badge-hover-desc-welcome' => 'für den Beitritt zum Wiki!',
	'achievements-badge-hover-desc-introduction' => 'für das Hinzufügen zu<br />
deiner eigenen Benutzerseite!',
	'achievements-badge-hover-desc-sayhi' => 'für das Hinterlassen einer Nachricht<br />
auf der Diskussionsseite eines anderen!',
	'achievements-badge-hover-desc-creator' => 'Für der Erstellung des Wikis!',
	'achievements-badge-hover-desc-pounce' => 'für das Bearbeiten von 100 Seiten innerhalb einer Stunde nach ihrer Erstellung!',
	'achievements-badge-hover-desc-caffeinated' => 'für 100 Bearbeitungen auf Seiten an einem einzigen Tag!',
	'achievements-badge-hover-desc-luckyedit' => 'für die Glückliche $1ste Bearbeitung in diesem Wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Dies ist ein besonderes Platin-Abzeichen das nur für eine begrenzte Zeit verfügbar ist!',
	'achievements-badge-your-desc-edit' => 'für {{PLURAL:$1|deine erste Bearbeitung|$1 Bearbeitungen}} auf {{PLURAL:$1|einer Seite|Seiten}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'für {{PLURAL:$1|deine erste Bearbeitung|$1 Bearbeitungen}} auf {{PLURAL:$1|einer $2 Seite|$2 Seiten}}!',
	'achievements-badge-your-desc-picture' => 'für das Hinzufügen {{PLURAL:$1|deines ersten Bildes|von $1 Bildern}} auf {{PLURAL:$1|einer Seite|Seiten}}!',
	'achievements-badge-your-desc-category' => 'für das Hinzufügen {{PLURAL:$1|deiner ersten Seite|von $1 Seiten}} zu {{PLURAL:$1|einer Kategorie|Kategorien}}!',
	'achievements-badge-your-desc-blogpost' => 'für das Schreiben {{PLURAL:$1|deines ersten Blogeintrags|von $1 Blogeinträgen}}!',
	'achievements-badge-your-desc-blogcomment' => 'für das Schreiben eines Kommentars zu {{PLURAL:$1|einem Blogeintrag|$1 verschiedenen Blogeinträgen}}!',
	'achievements-badge-your-desc-love' => 'für das tägliche Bearbeiten des Wikis über einen Zeitraum von {{PLURAL:$1|einem Tag|$1 Tagen}}!',
	'achievements-badge-your-desc-welcome' => 'für den Beitritt zum Wiki!',
	'achievements-badge-your-desc-introduction' => 'als Zusatz zu Irhrer eigenen Benutzerseite!',
	'achievements-badge-your-desc-sayhi' => 'für das Hinterlassen einer Nachricht auf der Diskussionsseite eines anderen!',
	'achievements-badge-your-desc-creator' => 'für die Erstellung des Wikis!',
	'achievements-badge-your-desc-pounce' => 'für Bearbeitungen auf 100 Seiten innerhalb der ersten Stunde nach der Erstellung!',
	'achievements-badge-your-desc-caffeinated' => 'für 100 Bearbeitungen auf Seiten an einem einzigen Tag!',
	'achievements-badge-your-desc-luckyedit' => 'für die Glückliche $1ste Bearbeitung in dem Wiki!',
	'achievements-badge-desc-edit' => 'für $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} auf {{PLURAL:$1|einer Seite|Seiten}}!',
	'achievements-badge-desc-edit-plus-category' => 'für $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} auf {{PLURAL:$1|einer $2 Seite|$2 Seiten}}!',
	'achievements-badge-desc-picture' => 'für das Hinzufügen von $1 {{PLURAL:$1|Bild|Bildern}} zu {{PLURAL:$1|einer Seite|Seiten}}!',
	'achievements-badge-desc-category' => 'für das Hinzufügen von $1 {{PLURAL:$1|Seite|Seiten}} zu {{PLURAL:$1|einer Kategorie|Kategorien}}!',
	'achievements-badge-desc-blogpost' => 'für das Schreiben von $1 {{PLURAL:$1|Blogeintrag|Blogeinträgen}}!',
	'achievements-badge-desc-blogcomment' => 'für das Schreiben eines Kommentars zu {{PLURAL:$1|einem Blogeintrag|$1 verschiedenen Blogeinträgen}}!',
	'achievements-badge-desc-love' => 'für die tägliche Bearbeitung des Wikis über einen Zeitraum von {{PLURAL:$1|einem Tag|$1 Tagen}}!',
	'achievements-badge-desc-welcome' => 'für den Beitritt zum Wiki!',
	'achievements-badge-desc-introduction' => 'für das Hinterlassen einer Nachricht auf der Diskussionsseite eines anderen!',
	'achievements-badge-desc-sayhi' => 'für das Hinterlassen einer Nachricht auf der Diskussionsseite eines anderen!',
	'achievements-badge-desc-creator' => 'für die Erstellung des Wikis!',
	'achievements-badge-desc-pounce' => 'für Bearbeitungen auf 100 Seiten innerhalb der ersten Stunde nach der Erstellung!',
	'achievements-badge-desc-caffeinated' => 'für 100 Bearbeitungen auf Seiten an einem einzigen Tag!',
	'achievements-badge-desc-luckyedit' => 'für die Glückliche $1ste Bearbeitung in dem Wiki!',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'achievements-upload-error' => 'Entschuldigung!
Dieses Bild funktioniert nicht.
Stellen Sie sicher, dass es sich um eine .jpg- oder- .png-Datei handelt.
Wenn es immer noch nicht funktioniert, dann ist das Bild wohl zu größ.
Bitte versuchen Sie es erneut!',
	'achievements-you-must' => 'Sie müssen $1 um dieses Abzeichen zu verdienen.',
	'achievements-notification-subtitle' => 'Sie haben gerade die „$1“-Auszeichnung erhalten $2',
	'achievements-about-content' => 'Administratoren in diesem Wiki können die Namen und Bilder der Auszeichnungen in diesem Wiki anpassen.

Sie können ein beliebiges .jpg- oder .png-Bild hochladen, und Ihr Bild wird automatisch in den Rahmen passen.
Das funktioniert am besten, wenn Ihr Bild quadratisch ist, und wenn der wichtigste Teil des Bildes genau in der Mitte ist.

Sie können auch rechteckige Bilder verwenden, werden aber vielleicht feststellen, dass ein Teil des Rahmens abgeschnitten wird.
Wenn Sie ein Bildbearbeitungs-Programm haben, können Sie das Bild zuschneiden, um den wichtigsten Teil des Bildes in die Mitte zu bringen.
Wenn Sie kein Bildbearbeitungs-Programm hbent, dann experimentieren Sie einfach mit verschiedenen Bildern, bis Sie die finden, die für Sie funktionieren!
Wenn Sie das von Ihnen gewählte Bild nicht mögen, klicken Sie auf „{{int:achievements-revert}}“, um es wieder auf die ursprüngliche Grafik zurückzusetzen.

Sie können auch den Auszeichnungen einen neuen Namen geben, welche das Thema des Wikis wiedergeben.
Wenn Sie den Namen geändert haben, klicken Sie auf „{{int:achievements-save}}“ um die Änderungen zu speichern.
Viel Spaß!',
	'achievements-create-edit-plus-category-content' => 'Sie können einen neuen Satz Badges erstellen um Benutzer für die Bearbeitung von Seiten in einer bestimmten Kategorie zu belohnen, um einen bestimmten Bereich der Seite hervorzuheben in dem Benutzer gerne arbeiten würden.
Sie können mehrere Kategorien verknüpfen, also versuchen zwei Kategorien zu wählen, die die Besonderheit der Benutzer hervorheben!
Entzünden Sie einen Rivalitätenkampf zwischen den Benutzern, die Vampirseiten bearbeiten und den Benutzern, die Werwolfseiten bearbeiten, oder Zauberer und Muggel, oder Autobots und Decepticons.

Um eine neue „Bearbeitung in einer Kategorie“-Verknüpfung zu erstellen, geben Sie den Namen der Kategorie in das Feld unterhalb ein.
Die normale Bearbeitungsverknüpfung wird weiterhin existieren;
dies wird eine eigene Bearbeitungsverknüpfung erstellen, die Sie separat anpassen kannst.

Wenn die Verknüpfung erstellt wurde, wird die neue Auszeichnung in der Liste links unter der normalen Bearbeitungsverknüpfung erscheinen.
Passen Sie den Namen und das Bild der neuen Verknüpfung an, sodass Benutzer den Unterschied sehen!

Sobald Sie die Anpassungen vorgenommen haben, haken Sie das {{int:achievements-enable-track}}-Kontrollkästchen an um die neue Verknüpfung zu aktivieren, und klicken Sie dann auf „{{int:achievements-save}}“.
Sie können die Verknüpfung auch später wieder deaktivieren, wenn Sie entscheiden, dass Sie diese Kategorie nicht mehr hervorheben möchten.
Benutzer, die Auszeichnungen für diese Verknüpfung erhalten haben, werden ihre Auszeichnungen immer behalten, auch, wenn die Verknüpfung wieder deaktiviert wurde.

Dies kann helfen, eine neue Dimension der Freude zu den Erfolgen hinzuzufügen.
Versuchen Sie es mal!',
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
	'achievements-badge-to-get-welcome-details' => 'Klicken Sie auf den „{{int:autocreatewiki-create-account}}“-Button oben rechts, um der Gemeinschaft beizutreten.
Sie können sich dann sofort eigene Auszeichnungen verdienen.',
	'achievements-badge-to-get-sayhi-details' => 'Sie können anderen Benutzern Nachrichten hinterlassen, indem Sie auf „{{int:tooltip-ca-addsection}}“ auf ihrer Diskussionsseite klicken.
Fragen Sie sie um Hilfe, danken Sie ihnen für ihre Arbeit oder sagen Sie einfach mal Hallo!',
	'achievements-badge-to-get-creator-details' => 'Die Auszeichnung geht an die Person, die das Wiki gegründet hat.
Klicken Sie auf den „{{int:createwiki}}“-Button oben, um Ihr eigenes Wiki zu einem beliebigen Thema zu erstellen!',
	'achievements-badge-to-get-pounce-details' => 'Sie müssen schnell sein, um diese Auszeichnung zu erhalten.
Klicken Sie auf den „{{int:activityfeed}}“-Button, um die neuen Seiten zu sehen, die andere Benutzer erstellen!',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['el'] = array(
	'achievements-platinum' => 'Πλατινένιο',
	'achievements-gold' => 'Χρυσό',
	'achievements-silver' => 'Αργυρό',
	'achievements-bronze' => 'Χάλκινο',
	'achievements-viewall' => 'Προβολή όλων:',
	'achievements-viewless' => 'Κλείσιμο',
	'achievements-community-platinum-badge-image' => 'Εικόνα του παράσημου:',
	'achievements-badge-name-edit-4' => 'Συνεργάτης',
	'achievements-badge-name-picture-0' => 'Στιγμιότυπο',
	'achievements-badge-name-picture-1' => 'Παπαράτσι',
	'achievements-badge-name-picture-2' => 'Εικονογράφος',
	'achievements-badge-name-picture-3' => 'Συλλέκτης',
	'achievements-badge-name-picture-5' => 'Διακοσμητής',
	'achievements-badge-name-picture-6' => 'Σχεδιαστής',
	'achievements-badge-name-picture-7' => 'Έφορος',
	'achievements-badge-name-category-2' => 'Εξερευνητής',
	'achievements-badge-name-category-3' => 'Ξεναγός',
	'achievements-badge-name-category-4' => 'Πλοηγός',
	'achievements-badge-name-love-3' => 'Αφιερωμένο',
	'achievements-badge-name-love-4' => 'Εθισμένος',
	'achievements-badge-name-introduction' => 'Εισαγωγή',
	'achievements-badge-name-creator' => 'O δημιουργός',
);

/** Spanish (Español)
 * @author Absay
 * @author Bola
 * @author Crazymadlover
 * @author Peter17
 * @author Sanbec
 */
$messages['es'] = array(
	'achievementsii-desc' => 'Un sistema de logros para los usuarios del wiki',
	'achievements-upload-error' => '¡Lo sentimos!
Esa imagen no funciona.
Asegúrate de que es un archivo .jpg o .png.
Si continúa sin funcionar, debe ser porque la imagen es demasiado grande.
Por favor, inténtalo con otra imagen.',
	'achievements-upload-not-allowed' => 'Los administradores pueden cambiar los nombres e imágenes de los Logros visitando la página de [[Special:AchievementsCustomize|de personalización de logros]].',
	'achievements-non-existing-category' => 'La categoría especificada no existe.',
	'achievements-edit-plus-category-track-exists' => 'La categoría especificada ya tiene un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Ir al logro">logro asociado</a>.',
	'achievements-no-stub-category' => 'Por favor, no crees grupos de logros para bocetos.',
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Oro',
	'achievements-silver' => 'Plata',
	'achievements-bronze' => 'Bronce',
	'achievements-you-must' => 'Necesitas $1 para conseguir este logro.',
	'leaderboard-button' => 'Tabla de líderes con más logros',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punto|puntos}}</small>',
	'achievements-track-name-edit' => 'Referentes a Editar',
	'achievements-track-name-picture' => 'Referentes a Imágenes',
	'achievements-track-name-category' => 'Referentes a Categorías',
	'achievements-track-name-blogpost' => 'Referentes a Entradas de blog',
	'achievements-track-name-blogcomment' => 'Referentes a Comentarios de blog',
	'achievements-track-name-love' => 'Referentes a "Amor por el wiki"',
	'achievements-notification-title' => '¡Así se hace, $1!',
	'achievements-notification-subtitle' => 'Acabas de conseguir el logro "$1", $2',
	'achievements-notification-link' => '<strong><big>¡[[Special:MyPage|Haz clic aquí para ver más logros que puedes conseguir]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punto|puntos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punto|puntos}}',
	'achievements-earned' => 'Este logro ha sido conseguido por {{PLURAL:$1|1 usuario|$1 usuarios}}.',
	'achievements-profile-title' => '$1 consiguió $2 {{PLURAL:$2|logro|logros}}',
	'achievements-profile-title-no' => '$1 logros',
	'achievements-profile-title-challenges' => '¡Más logros que puedes conseguir!',
	'achievements-profile-customize' => 'Personalizar logros >',
	'achievements-ranked' => 'Puesto #$1 en este wiki',
	'achievements-no-badges' => '¡Echa un vistazo a la lista de debajo para ver los logros que puedes conseguir en este wiki!',
	'achievements-viewall' => 'Ver todo',
	'achievements-viewless' => 'Cerrar',
	'achievements-profile-title-oasis' => 'logro <br /> puntos',
	'achievements-ranked-oasis' => '$1 está [[Special:Leaderboard|en el puesto #$2]] en este wiki',
	'achievements-viewall-oasis' => 'Ver todos',
	'leaderboard-intro' => "'''&ldquo;¿Qué son los Logros?&rdquo;'''
Puedes conseguir logros especiales por participar en este wiki!
Con cada logro consigues puntos que se añaden a tu puntuación final:
Los logros de Bronce te darán 10 puntos, los logros de Plata te darán 50 puntos y los de Oro 100 puntos.

Cuando participes en un wiki, tu perfil de usuario mostrará los logros que has conseguido, y mostrará una lista con los retos que tendrás disponibles.
¡[[Special:MyPage|Ve a tu perfil de usuario para comprobarlo]]!",
	'leaderboard' => 'Tabla de líderes con más logros',
	'achievements-recent-earned-badges' => 'Logros conseguidos recientemente',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />conseguido por <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => ' Ganó la <strong><a href="$3" class="badgeName">$1</a></strong> insignia<br />$2',
	'achievements-leaderboard-disclaimer' => 'La tabla de líderes muestra los cambios desde ayer',
	'achievements-leaderboard-rank-label' => 'clasificación',
	'achievements-leaderboard-member-label' => 'miembro',
	'achievements-leaderboard-points-label' => 'puntos',
	'achievements-send' => 'Grabar imagen',
	'achievements-save' => 'Grabar cambios',
	'achievements-reverted' => 'Logro revertido a su original.',
	'achievements-customize' => 'Personalizar imagen',
	'achievements-customize-new-category-track' => 'Crear nuevo grupo de logros por categoría:',
	'achievements-enable-track' => 'activado',
	'achievements-revert' => 'Revertir al que está por defecto',
	'achievements-special-saved' => 'Cambios grabados',
	'achievements-special' => 'Logros especiales',
	'achievements-secret' => 'Logros secretos',
	'achievementscustomize' => 'Personalizar logros',
	'achievements-about-title' => 'Acerca de esta página...',
	'achievements-about-content' => 'Los administradores de este wiki pueden personalizar los nombres y las imágenes de los logros.

Puedes subir cualquier imagen .jpg o .png, y tu imagen se pondrá automáticamente en el interior del marco.
Funciona mejor con las imágenes que son cuadradas, y cuando la parte más importante de la imagen está situada en medio.

Puedes usar imágenes rectangulares, pero pero podrías encontrarte con que se coloca mal en el marco.
Si tienes un programa gráfico, puedes arreglar la imagen para poner la parte más importante de la misma en el centro.
¡Si no tienes un programa gráfico, puedes probar con diferentes imágenes hasta que encuentres la que funcione mejor!
Si no has elegido aún la imagen para poner, haz clic en "{{int:achievements-revert}}" para volver a la imagen original.

También puedes dar nuevos nombres a los logros para que estén relacionados con el tema del wiki. 
Cuando hayas cambiado el nombre de los logros, haz clic en "{{int:achievements-save}}" para guardar los cambios.
¡Diviértete!',
	'achievements-edit-plus-category-track-name' => '$1 logro de edición',
	'achievements-create-edit-plus-category-title' => 'Crear un nuevo logro de Edición.',
	'achievements-create-edit-plus-category-content' => 'Puedes crear una nueva configuración de logros que premie a los usuarios por editar páginas de una determinada categoría, para impulsar una determinada área del sitio consiguiendo que los usuarios disfruten trabajando en ella.
¡Puedes configurar tantos logros como desees por categoría, aunque intenta elegir dos categorías al menos para ayudar a los usuarios a demostrar su especialidad!
Enciende la rivalidad entre los usuarios que editen páginas sobre Vampiros y los que editen páginas sobre Hombres Lobo, o los Magos y Muggles, o Autobots y Decepticons.

Para crear un nuevo logro de "Editar en la categoría", escribe el nombre de la categoría en el campo de debajo.
El logro normal de "Editar" continuará existiendo;
este se creará en un logro separado que podrás personalizar de forma independiente.

Cuando el logro esté creado, el nuevo logro aparecerá en la lista de la izquierda, debajo del logro normal de "Editar".
Personaliza los nombres y las imágenes del nuevo logro, ¡así los usuarios podrán ver las diferencias!

Una vez tengas hecha la personalización, haz clic en la casilla de verificación "{{int:achievements-enable-track}}" para volver al nuevo logro, y después haz clic en "{{int:achievements-save}}".
Los usuarios podrán ver la apariencia del nuevo logro en sus perfiles de usuario, y podrán comenzar a conseguir los logros cuando editen páginas de esa categoría.
También puedes desactivar el logro posteriormente, si decides que no se debe impulsar esa categoría por más tiempo.
Los usuarios que haya conseguido el logro lo mantendrán, incluso si se desactiva.

Todo esto te puede ayudar a dar un pequeño impulso a la diversión que se puede conseguir con los logros.
¡Inténtalo!',
	'achievements-create-edit-plus-category' => 'Crear este grupo',
	'platinum' => 'Platino',
	'achievements-community-platinum-awarded-email-subject' => '¡Has conseguido un nuevo logro de Platino!',
	'achievements-community-platinum-awarded-email-body-text' => "¡Felicidades $1!

Has conseguido el logro de Platino '$2' en $4 ($3). ¡Con este logro has conseguido 250 puntos para tu puntuación total!

Echa un vistazo a este logro de lujo en tu perfil de usuario:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>¡Felicidades $1!</strong><br /><br />
Has conseguido el logro de Platino \'<strong>$2</strong>\' en <a href="$3">$4</a>. ¡Con este logro has conseguido 250 puntos para tu puntuación total!<br /><br />
Echa un vistazo a este logro de lujo en tu <a href="$5">perfil de usuario</a>.',
	'achievements-community-platinum-awarded-for' => 'Conseguido por:',
	'achievements-community-platinum-how-to-earn' => 'Cómo conseguirlo:',
	'achievements-community-platinum-awarded-for-example' => 'ej. "Por hacer..."',
	'achievements-community-platinum-how-to-earn-example' => 'ej. "hacer tres ediciones..."',
	'achievements-community-platinum-badge-image' => 'Imagen del logro:',
	'achievements-community-platinum-awarded-to' => 'Otorgado a:',
	'achievements-community-platinum-current-badges' => 'Logros de platino actuales',
	'achievements-community-platinum-create-badge' => 'Crear logro',
	'achievements-community-platinum-enabled' => 'activado',
	'achievements-community-platinum-show-recents' => 'mostrar en logros recientes',
	'achievements-community-platinum-edit' => 'editar',
	'achievements-community-platinum-save' => 'guardar',
	'achievements-badge-name-edit-0' => 'Marcando la Diferencia',
	'achievements-badge-name-edit-1' => 'Sólo el Principio',
	'achievements-badge-name-edit-2' => 'Dejando Tu Marca',
	'achievements-badge-name-edit-3' => 'Amigo del Wiki',
	'achievements-badge-name-edit-4' => 'Colaborador',
	'achievements-badge-name-edit-5' => 'Constructor Wiki',
	'achievements-badge-name-edit-6' => 'Líder del Wiki',
	'achievements-badge-name-edit-7' => 'Experto Wiki',
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
	'achievements-badge-name-category-3' => 'Guía Turística',
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
	'achievements-badge-name-love-5' => 'Su vida es el wiki',
	'achievements-badge-name-love-6' => 'Héroe del Wiki',
	'achievements-badge-name-welcome' => 'Bienvenido al wiki',
	'achievements-badge-name-introduction' => 'Introducción',
	'achievements-badge-name-sayhi' => 'Deteniendo para decir hola',
	'achievements-badge-name-creator' => 'El Creador',
	'achievements-badge-name-pounce' => '¡Salta!',
	'achievements-badge-name-caffeinated' => 'Con cafeína',
	'achievements-badge-name-luckyedit' => 'Edición afortunada',
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
	'achievements-badge-to-get-edit-details' => '¿Falta algo? ¿Hay algún error? No seas tímido. ¡Haz clic en el botón "{{int:edit}}" y podrás añadir cualquier página!',
	'achievements-badge-to-get-edit-plus-category-details' => '¡Las <strong>$1</strong> páginas necesitan tu ayuda! Haz clic en el botón "{{int:edit}}" de cualquier página en esta categoría para ayudar. ¡Demuestra tu apoyo a las $1 páginas!',
	'achievements-badge-to-get-picture-details' => 'Haz clic en el botón "{{int:edit}}", y después en el botón de "{{int:rte-ck-image-add}}". Puedes añadir una imagen desde tu ordenador, o desde otra página del wiki.',
	'achievements-badge-to-get-category-details' => 'Las categorías son etiquetas que ayudan a los lectores a encontrar páginas similares. Haz clic en el botón de "{{int:categoryselect-addcategory-button}}" para añadir la página a una categoría.',
	'achievements-badge-to-get-blogpost-details' => '¡Escribe tu opinión y tus preguntas! Haz clic en "{{int:blogs-recent-url-text}}" en el panel lateral, y después en el enlace de la izquierda para "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => '¡Añade tu granito de arena! 
Lee cualquiera de las entradas de blog, y escribe tus propias opiniones en los comentarios.',
	'achievements-badge-to-get-love-details' => '¡El contador se reinicia si dejas de editar durante un día, asegúrate de volver al wiki cada día!',
	'achievements-badge-to-get-welcome-details' => 'Haz clic en el botón "{{int:autocreatewiki-create-account}}" arriba a la derecha para participar en la comunidad. ¡Así podrás comenzar a ganar tus propios logros!',
	'achievements-badge-to-get-introduction-details' => '¿Tu página de usuario está vacía? Haz clic en tu nombre de usuario al comienzo de la pantalla para verla. ¡Haz clic en "{{int:edit}}" para añadir algo de información sobre ti!',
	'achievements-badge-to-get-sayhi-details' => 'Puedes dejar mensajes a otros usuarios haciendo clic en "{{int:tooltip-ca-addsection}}" al comienzo de la página de discusión. ¡Para pedirle ayuda, agradecerle su trabajo, o para decirle hola!',
	'achievements-badge-to-get-creator-details' => 'Este logro se otorga a la persona que fundó el wiki. ¡Haz clic en el botón "{{int:createwiki}}" arriba, para comenzar tu propio sitio sobre el tema que más te guste!',
	'achievements-badge-to-get-pounce-details' => 'Tienes que ser rápido para conseguir este logro. ¡Haz clic en el botón de "{{int:activityfeed}}" para ver las nuevas páginas que los usuarios están creando!',
	'achievements-badge-to-get-caffeinated-details' => 'Necesitarás todo un día para conseguir este logro. 
¡No dejes de editar!',
	'achievements-badge-to-get-luckyedit-details' => 'Necesitas suerte para conseguir este logro. 
¡No dejes de editar!',
	'achievements-badge-to-get-community-platinum-details' => '¡Este es un logro especial de platino que solamente estará disponible por un tiempo limitado!',
	'achievements-badge-hover-desc-edit' => 'por hacer $1 {{PLURAL:$1|edición|ediciones}}<br />
en {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'por hacer $1 {{PLURAL:$1|edición|ediciones}}<br />
en {{PLURAL:$1|una|}} $2 {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-hover-desc-picture' => 'por agregar $1 {{PLURAL:$1|imagen|imágenes}}<br />
a {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-hover-desc-category' => 'por agregar $1 {{PLURAL:$1|página|páginas}}<br />
a {{PLURAL:$1|una categoría|categorías}}!',
	'achievements-badge-hover-desc-blogpost' => 'por escribir $1 {{PLURAL:$1|entrada de blog|entradas de blog}}!',
	'achievements-badge-hover-desc-blogcomment' => 'por escribir un comentario<br />
en $1 {{PLURAL:$1|entrada de blog|entradas de blog diferentes}}!',
	'achievements-badge-hover-desc-love' => 'por contribuir en el wiki {{PLURAL:$1|durante todo un día|cada día durante $1 días}}!',
	'achievements-badge-hover-desc-welcome' => 'por unirte al wiki!',
	'achievements-badge-hover-desc-introduction' => 'por agregar a<br />
tu propia página de usuario!',
	'achievements-badge-hover-desc-sayhi' => 'por dejar un mensaje<br />
en la página de discusión de alguien más!',
	'achievements-badge-hover-desc-creator' => 'por crear el wiki!',
	'achievements-badge-hover-desc-pounce' => 'por editar en 100 páginas dentro de la primera hora de vida de las páginas!',
	'achievements-badge-hover-desc-caffeinated' => 'por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-hover-desc-luckyedit' => 'por hacer la edición afortunada $1th en el wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Este es un logro especial de platino que solamente estará disponible por un tiempo limitado!',
	'achievements-badge-your-desc-edit' => 'por hacer {{PLURAL:$1|tu primera edición|$1 ediciones}} en {{PLURAL:$1|una página|varias páginas}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'por hacer {{PLURAL:$1|tu primera edición|$1 ediciones}} en {{PLURAL:$2|una página|$2 páginas}}!',
	'achievements-badge-your-desc-picture' => 'por agregar {{PLURAL:$1|tu primera imagen|$1 imágenes}} a {{PLURAL:$1|una página|varias páginas}}!',
	'achievements-badge-your-desc-category' => 'por añadir {{PLURAL:$1|tu primera página|$1 páginas}} a {{PLURAL:$1|una categoría|varias categorías}}!',
	'achievements-badge-your-desc-blogpost' => 'por escribir {{PLURAL:$1|tu primera entrada de blog|$1 entradas de blog}}!',
	'achievements-badge-your-desc-blogcomment' => 'por escribir un comentario en {{PLURAL:$1|una entrada de blog|$1 entradas de blog diferentes}}!',
	'achievements-badge-your-desc-love' => 'por contribuir en el wiki {{PLURAL:$1|durante todo el día|todos los días durante $1 días}}!',
	'achievements-badge-your-desc-welcome' => 'por unirte al wiki!',
	'achievements-badge-your-desc-introduction' => 'por agregar tu propia página de usuario!',
	'achievements-badge-your-desc-sayhi' => 'por dejar un mensaje en la página de discusión de alguien más!',
	'achievements-badge-your-desc-creator' => 'por crear el wiki!',
	'achievements-badge-your-desc-pounce' => 'por hacer ediciones en 100 páginas dentro de la primera hora de vida de las páginas!',
	'achievements-badge-your-desc-caffeinated' => 'por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-your-desc-luckyedit' => 'por hacer la edición afortunada $1th en el wiki!',
	'achievements-badge-desc-edit' => 'por hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-desc-edit-plus-category' => 'por hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$2|una página|$2 páginas}}!',
	'achievements-badge-desc-picture' => 'por agregar $1 {{PLURAL:$1|imagen|imágenes}} a {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-desc-category' => 'por agregar $1 {{PLURAL:$1|página|páginas}} a {{PLURAL:$1|una categoría|varias categorías}}!',
	'achievements-badge-desc-blogpost' => 'por escribir $1 {{PLURAL:$1|entrada de blog|entradas de blog}}!',
	'achievements-badge-desc-blogcomment' => 'por escribir un comentario en {{PLURAL:$1|una entrada de blog|$1 diferentes entradas de blog}}!',
	'achievements-badge-desc-love' => 'por contribuir en el wiki {{PLURAL:$1|durante todo un día|cada día durante $1 días}}!',
	'achievements-badge-desc-welcome' => 'por unirte al wiki!',
	'achievements-badge-desc-introduction' => 'por agregar a tu propia página de usuario!',
	'achievements-badge-desc-sayhi' => 'por dejar un mensaje en la página de discusión de alguien más!',
	'achievements-badge-desc-creator' => 'por crear el wiki!',
	'achievements-badge-desc-pounce' => 'por hacer ediciones en 100 páginas dentro de la primera hora de vida las páginas!',
	'achievements-badge-desc-caffeinated' => ' por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-desc-luckyedit' => 'por hacer la edición afortunada $1th en el wiki!',
);

/** French (Français)
 * @author IAlex
 * @author Peter17
 * @author Urhixidur
 * @author Zetud
 */
$messages['fr'] = array(
	'achievementsii-desc' => 'Un système de badges pour les utilisateurs du wiki',
	'achievements-upload-error' => "Désolé !
Cette image ne fonctionne pas.
Veuillez vous assurer qu’il s'agit bien d'un fichier .jpg ou .png.
Si cela ne fonctionne toujours pas, c'est peut-être que l’image est trop lourde.
Merci d'en essayer une autre !",
	'achievements-upload-not-allowed' => 'Les administrateurs peuvent changer les noms et images des badges des challenges en visitant [[Special:AchievementsCustomize|la page de personnalisations des challenges]].',
	'achievements-non-existing-category' => "La catégorie spécifiée n'existe pas.",
	'achievements-edit-plus-category-track-exists' => 'La catégorie spécifiée a déjà un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Aller au challenge">challenge associée</a>.',
	'achievements-no-stub-category' => 'Veuillez ne pas créer de challenge pour les ébauches.',
	'achievements-platinum' => 'Platine',
	'achievements-gold' => 'Or',
	'achievements-silver' => 'Argent',
	'achievements-bronze' => 'Bronze',
	'achievements-you-must' => 'Vous devez $1 pour gagner ce badge.',
	'leaderboard-button' => 'Tableau des challenges',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|point|points}}</small>',
	'achievements-track-name-edit' => 'Challenges d’édition',
	'achievements-track-name-picture' => 'Challenges d’illustration',
	'achievements-track-name-category' => 'Challenges de catégorie',
	'achievements-track-name-blogpost' => 'Challenges de publication sur un blog',
	'achievements-track-name-blogcomment' => 'Challenges de commentaire d’un blog',
	'achievements-track-name-love' => "Challenges ''wiki love''",
	'achievements-notification-title' => 'Vous êtes sur le bon chemin, $1 !',
	'achievements-notification-subtitle' => 'Vous venez de gagner le badge « $1 » $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Cliquez ici pour voir davantage de badges que vous pouvez gagner]] !</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|point|points}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|point|points}}',
	'achievements-earned' => 'Ce badge a été gagné par {{PLURAL:$1|un utilisateur|$1 utilisateurs}}.',
	'achievements-profile-title' => '{{PLURAL:$2|Le badge gagné|Les $2 badges gagnés}} par $1',
	'achievements-profile-title-no' => 'Badges de $1',
	'achievements-profile-title-challenges' => 'D’autres badges que vous pouvez gagner !',
	'achievements-profile-customize' => 'Personnaliser les badges >',
	'achievements-ranked' => 'Classé n°$1 sur ce wiki',
	'achievements-no-badges' => 'Jetez un œil à la liste ci-dessous pour voir les badges que vous pouvez gagner sur ce wiki !',
	'achievements-viewall' => 'Tout voir',
	'achievements-viewless' => 'Fermer',
	'achievements-profile-title-oasis' => 'réalisation <br /> points',
	'achievements-ranked-oasis' => '$1 est [[Special:Leaderboard|classé n°$2]] sur ce wiki',
	'achievements-viewall-oasis' => 'Tout voir',
	'leaderboard-intro' => "'''&ldquo;Que sont les Challenges ?&rdquo;'''
Vous pouvez gagner des badges spéciaux en participant à ce wiki !
Chaque badge que vous gagnez ajoute des points à votre score total :
Les badges de bronze valent 10 points, ceux en argent valent 50 points et ceux en or, 100 points.

Lorsque vous rejoignez le wiki, votre profil utilisateur affiche les badges que vous avez gagnés et vous montre une liste de challenges qui sont disponibles pour vous.
[[Special:MyPage|Allez sur votre profil jeter un œil]] !",
	'leaderboard' => 'Tableau des challenges',
	'achievements-recent-earned-badges' => 'Badges récemment gagnés',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />gagné par <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'a gagné le badge <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'La table de leaders montre les changements depuis hier',
	'achievements-leaderboard-rank-label' => 'rang',
	'achievements-leaderboard-member-label' => 'membre',
	'achievements-leaderboard-points-label' => 'points',
	'achievements-send' => 'Enregistrer l’image',
	'achievements-save' => 'Sauvegarder les modifications',
	'achievements-reverted' => "Le badge est revenu à l'original.",
	'achievements-customize' => 'Personnaliser l’image',
	'achievements-customize-new-category-track' => 'Créer un nouveau challenge pour cette catégorie',
	'achievements-enable-track' => 'activé',
	'achievements-revert' => 'Revenir à la version par défaut',
	'achievements-special-saved' => 'Modifications enregistrées.',
	'achievements-special' => 'Challenges spéciaux',
	'achievements-secret' => 'Challenges secrets',
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
	'achievements-edit-plus-category-track-name' => '$1 challenge d’édition',
	'achievements-create-edit-plus-category-title' => 'Créer un nouveau challenge d’édition',
	'achievements-create-edit-plus-category-content' => 'Vous pouvez créer un nouvel ensemble de badges qui récompense les utilisateurs pour avoir modifié les pages d’une catégorie particulière, afin de mettre en valeur un domaine particulier de ce site sur lequel les utilisateurs apprécieront de travailler.
Vous pouvez définir plusieurs challenges de catégories. Choisissez donc deux catégories qui aideront les utilisateurs à montrer leurs spécialités !
Créez une rivalité entre les utilisateurs qui modifient les pages sur les vampires et ceux qui modifient celles sur les loup-garous, ou les sorciers et les moldus ou encore les Autobots et les Decepticans.

Pour créer un nouveau challenge « Modifications dans une catégorie », saisissez le nom de la catégorie dans le champ ci-dessous.
Le challenge de modification classique existera toujours ; cela créera un challenge indépendant que vous pourrez personnaliser séparément.

Lorsque le challenge sera créé, les nouveaux badges apparaîtront dans la liste sur la gauche, sous le challenge d’édition classique.
Personnalisez les noms et images du nouveau challenge, pour que les utilisateurs puissent faire la différence !

Lorsque vous aurez fini la personnalisation, cochez la case « {{int:achievements-enable-track}} » pour démarrer le nouveau challenge, et cliquez ensuite sur « {{int:achievements-save}} ».
Les utilisateurs verront le nouveau challenge apparaître dans leurs profils utilisateur et commenceront à gagner des badges lorsqu’ils modifieront des pages dans cette catégorie.
Vous pourrez désactiver ce challenge plus tard, si vous ne voulez plus mettre en valeur cette catégorie.
Les utilisateurs qui auront gagné des badges dans ce challenge les conserveront toujours, même si le challenge est désactivé.

Ceci peut aider à s’amuser davantage avec les challenges.
Essayez !',
	'achievements-create-edit-plus-category' => 'Créer ce challenge',
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
	'achievements-community-platinum-how-to-earn' => 'Comment gagner :',
	'achievements-community-platinum-awarded-for-example' => 'ex : « pour faire... »',
	'achievements-community-platinum-how-to-earn-example' => 'ex : « faire 3 modifications... »',
	'achievements-community-platinum-badge-image' => 'Image du badge :',
	'achievements-community-platinum-awarded-to' => 'Décerné à :',
	'achievements-community-platinum-current-badges' => 'Badges en platine actuels',
	'achievements-community-platinum-create-badge' => 'Créer un badge',
	'achievements-community-platinum-enabled' => 'activé',
	'achievements-community-platinum-show-recents' => 'afficher dans les badges récents',
	'achievements-community-platinum-edit' => 'modifier',
	'achievements-community-platinum-save' => 'sauvegarder',
	'achievements-badge-name-edit-0' => 'Fait la différence',
	'achievements-badge-name-edit-1' => 'Ce n’est que le début',
	'achievements-badge-name-edit-2' => 'Fait son trou',
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
	'achievements-badge-name-welcome' => 'Bienvenue sur le wiki',
	'achievements-badge-name-introduction' => 'Introduction',
	'achievements-badge-name-sayhi' => 'Bonjour en passant',
	'achievements-badge-name-creator' => 'Le créateur',
	'achievements-badge-name-pounce' => 'C’est parti !',
	'achievements-badge-name-caffeinated' => 'Caféiné',
	'achievements-badge-name-luckyedit' => 'Modification chanceuse',
	'achievements-badge-to-get-edit' => 'faire $1 {{PLURAL:$1|modification|modifications}} sur {{PLURAL:$1|une page|des pages}}',
	'achievements-badge-to-get-edit-plus-category' => 'faire $1 {{PLURAL:$1|modification|modifications}} sur {{PLURAL:$1|une page|des pages}} $2',
	'achievements-badge-to-get-picture' => 'ajouter $1 {{PLURAL:$1|image|images}} à {{PLURAL:$1|une page|des pages}}',
	'achievements-badge-to-get-category' => 'ajouter $1 {{PLURAL:$1|page|pages}} à {{PLURAL:$1|une catégorie|des catégories}}',
	'achievements-badge-to-get-blogpost' => 'écrire $1 {{PLURAL:$1|billet de blogue|billets de blogues}}',
	'achievements-badge-to-get-blogcomment' => 'commenter {{PLURAL:$1|un billet de blogue|$1 billets de blogues}}',
	'achievements-badge-to-get-love' => 'contribuer sur le wiki chaque jour pendant $1 jours',
	'achievements-badge-to-get-welcome' => 'rejoindre le wiki',
	'achievements-badge-to-get-introduction' => 'ajouter à votre propre page utilisateur',
	'achievements-badge-to-get-sayhi' => 'laisser un message à quelqu’un sur sa page de discussion',
	'achievements-badge-to-get-creator' => 'être le créateur de ce wiki',
	'achievements-badge-to-get-pounce' => 'être rapide',
	'achievements-badge-to-get-caffeinated' => 'faire $1 modifications sur les pages en une seule journée',
	'achievements-badge-to-get-luckyedit' => 'avoir de la chance',
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
	'achievements-badge-to-get-blogcomment-details' => 'Ajoutez votre grain de sel ! Lisez un des billets de blogues récents et donnez votre avis dans la boîte à commentaires.',
	'achievements-badge-to-get-love-details' => 'Le compteur se réinitialise si vous ratez un jour. Soyez sûr de revenir sur le wiki tous les jours !',
	'achievements-badge-to-get-welcome-details' => 'Cliquez sur le bouton « {{int:autocreatewiki-create-account}} » en haut à droite pour rejoindre la communauté.
Vous pourrez commencer à gagner vos propres badges !',
	'achievements-badge-to-get-introduction-details' => 'Votre page utilisateur est vide ?
Cliquez sur votre nom d’utilisateur en haut de l’écran pour voir.
Cliquez sur « {{int:edit}} » pour ajouter des informations sur vous !',
	'achievements-badge-to-get-sayhi-details' => 'Vous pouvez laisser des messages aux autres utilisateurs en cliquant sur « {{int:tooltip-ca-addsection}} » sur leur page de discussion.
Demandez de l’aide, remerciez-les pour leur travail, ou dites simplement bonjour !',
	'achievements-badge-to-get-creator-details' => 'Ce badge est décerné à la personne qui crée le wiki.
Cliquez sur le bouton « {{int:createwiki}} » en haut de l’écran pour créer un site à propos de ce que vous aimez le plus !',
	'achievements-badge-to-get-pounce-details' => 'Vous devez être rapide pour gagner ce badge.
Cliquez sur le bouton « {{int:activityfeed}} » pour voir les nouvelles pages que les utilisateurs créent !',
	'achievements-badge-to-get-caffeinated-details' => 'Il faut toute une journée pour gagner ce badge. Continuez à modifier !',
	'achievements-badge-to-get-luckyedit-details' => 'Vous devez être chanceux pour gagner ce badge. Continuez à modifier !',
	'achievements-badge-to-get-community-platinum-details' => 'Ceci est un badge spécial en platine qui n’est disponible que pour un temps limité !',
	'achievements-badge-hover-desc-edit' => 'pour avoir fait $1 {{PLURAL:$1|modification|modifications}}<br />
sur {{PLURAL:$1|une page|des pages}} !',
	'achievements-badge-hover-desc-edit-plus-category' => 'pour avoir fait $1 {{PLURAL:$1|modification|modifications}}<br />
sur {{PLURAL:$1|une page|des pages}} $2 !',
	'achievements-badge-hover-desc-picture' => 'pour avoir ajouté $1 {{PLURAL:$1|image|images}}<br />
à {{PLURAL:$1|une page|des pages}} !',
	'achievements-badge-hover-desc-category' => 'pour avoir ajouté $1 {{PLURAL:$1|page|pages}}<br />
à {{PLURAL:$1|une catégorie|des catégories}} !',
	'achievements-badge-hover-desc-blogpost' => 'pour avoir écrit {{PLURAL:$1|un billet de blogue|$1 billets de blogues}} !',
	'achievements-badge-hover-desc-blogcomment' => 'pour avoir commenté<br />
{{PLURAL:$1|un billet de blogue|$1 billets de blogues}} !',
	'achievements-badge-hover-desc-love' => 'pour avoir contribué au wiki tous les jours pendant $1 jours !',
	'achievements-badge-hover-desc-welcome' => 'pour avoir rejoint le wiki !',
	'achievements-badge-hover-desc-introduction' => 'pour avoir ajouté des informations sur<br />
votre propre page utilisateur !',
	'achievements-badge-hover-desc-sayhi' => "pour avoir laissé un message<br />
sur la page de discussion de quelqu’un d'autre !",
	'achievements-badge-hover-desc-creator' => 'pour avoir créé le wiki !',
	'achievements-badge-hover-desc-pounce' => 'pour avoir fait des modifications sur 100 pages dans l’heure suivant la création de la page !',
	'achievements-badge-hover-desc-caffeinated' => 'pour avoir fait 100 modifications sur des pages en un seul jour !',
	'achievements-badge-hover-desc-luckyedit' => 'pour avoir fait la modification chanceuse n°$1 sur le wiki !',
	'achievements-badge-hover-desc-community-platinum' => 'Ceci est un badge spécial en platine qui n’est disponible que pour un temps limité !',
	'achievements-badge-your-desc-edit' => 'pour avoir fait {{PLURAL:$1|votre première modification sur une page|$1 modifications sur des pages}} !',
	'achievements-badge-your-desc-edit-plus-category' => 'pour avoir fait {{PLURAL:$1|votre première modification sur une page|$1 modifications sur des pages}} $2 !',
	'achievements-badge-your-desc-picture' => 'pour avoir ajouté {{PLURAL:$1|votre première image sur une page|$1 images sur des pages}} !',
	'achievements-badge-your-desc-category' => 'pour avoir ajouté {{PLURAL:$1|votre première page à une catégorie|$1 pages à des catégories}} !',
	'achievements-badge-your-desc-blogpost' => 'pour avoir écrit {{PLURAL:$1|votre premier billet de blogue|$1 billets de blogues}} !',
	'achievements-badge-your-desc-blogcomment' => 'pour avoir commenté {{PLURAL:$1|un billet de blogue|$1 billets de blogues}} !',
	'achievements-badge-your-desc-love' => 'pour avoir contribué au wiki tous les jours pendant $1 jours !',
	'achievements-badge-your-desc-welcome' => 'pour avoir rejoint le wiki !',
	'achievements-badge-your-desc-introduction' => 'pour avoir ajouté des informations sur votre propre page utilisateur !',
	'achievements-badge-your-desc-sayhi' => "pour avoir laissé un message sur la page de discussion de quelqu’un d'autre !",
	'achievements-badge-your-desc-creator' => 'pour avoir créé le wiki !',
	'achievements-badge-your-desc-pounce' => 'pour avoir fait des modifications sur 100 pages dans l’heure suivant la création de la page !',
	'achievements-badge-your-desc-caffeinated' => 'pour avoir fait 100 modifications sur des pages en un seul jour !',
	'achievements-badge-your-desc-luckyedit' => 'pour avoir fait la modification chanceuse n°$1 sur le wiki !',
	'achievements-badge-desc-edit' => 'pour avoir fait $1 {{PLURAL:$1|modification|modifications}} sur {{PLURAL:$1|une page|des pages}} !',
	'achievements-badge-desc-edit-plus-category' => 'pour avoir fait $1 {{PLURAL:$1|modification|modifications}}<br />sur {{PLURAL:$1|une page|des pages}} $2 !',
	'achievements-badge-desc-picture' => 'pour avoir ajouté $1 {{PLURAL:$1|image|images}} à {{PLURAL:$1|une page|des pages}} !',
	'achievements-badge-desc-category' => 'pour avoir ajouté $1 {{PLURAL:$1|page|pages}} à {{PLURAL:$1|une catégorie|des catégories}} !',
	'achievements-badge-desc-blogpost' => 'pour avoir écrit {{PLURAL:$1|un billet de blogue|$1 billets de blogues}} !',
	'achievements-badge-desc-blogcomment' => 'pour avoir commenté {{PLURAL:$1|un billet de blogue|$1 billets de blogues}} !',
	'achievements-badge-desc-love' => 'pour avoir contribué au wiki tous les jours pendant {{PLURAL:$1|un jour|$1 jours}} !',
	'achievements-badge-desc-welcome' => 'pour avoir rejoint le wiki !',
	'achievements-badge-desc-introduction' => 'pour avoir ajouté des informations sur votre propre page utilisateur !',
	'achievements-badge-desc-sayhi' => "pour avoir laissé un message sur la page de discussion de quelqu’un d'autre !",
	'achievements-badge-desc-creator' => 'pour avoir créé le wiki !',
	'achievements-badge-desc-pounce' => 'pour avoir fait des modifications sur 100 pages dans l’heure suivant la création de la page !',
	'achievements-badge-desc-caffeinated' => 'pour avoir fait 100 modifications sur des pages en un seul jour !',
	'achievements-badge-desc-luckyedit' => 'pour avoir fait la modification chanceuse n°$1 sur le wiki !',
);

/** Galician (Galego)
 * @author Toliño
 */
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
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Ouro',
	'achievements-silver' => 'Prata',
	'achievements-bronze' => 'Bronce',
	'achievements-you-must' => 'Ten que $1 para gañar esta insignia.',
	'leaderboard-button' => 'Taboleiro de logros',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punto|puntos}}</small>',
	'achievements-track-name-edit' => 'Logros de edición',
	'achievements-track-name-picture' => 'Logros de imaxe',
	'achievements-track-name-category' => 'Logros de categoría',
	'achievements-track-name-blogpost' => 'Logros de publicación nun blogue',
	'achievements-track-name-blogcomment' => 'Logros de comentarios nun blogue',
	'achievements-track-name-love' => 'Logros de amor polo wiki',
	'achievements-notification-title' => 'Vai no bo camiño, $1!',
	'achievements-notification-subtitle' => 'Obtivo a insignia "$1" por $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Olle máis insignias que pode gañar]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punto|puntos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punto|puntos}}',
	'achievements-earned' => '{{PLURAL:$1|1 usuario|$1 usuarios}} gañaron esta insignia.',
	'achievements-profile-title' => '{{PLURAL:$2|A insignia gañada|As $2 insignias gañadas}} por $1',
	'achievements-profile-title-no' => 'Insignias de $1',
	'achievements-profile-title-challenges' => 'Máis insignias que pode gañar!',
	'achievements-profile-customize' => 'Personalizar as insignias >',
	'achievements-ranked' => 'Obtivo o posto #$1 neste wiki',
	'achievements-no-badges' => 'Consulte a lista que aparece a continuación para ollar as insignias que pode gañar neste wiki!',
	'achievements-viewall' => 'Ollar todas',
	'achievements-viewless' => 'Pechar',
	'achievements-profile-title-oasis' => 'logro <br /> puntos',
	'achievements-ranked-oasis' => '$1 está [[Special:Leaderboard|no posto nº$2]] neste wiki',
	'achievements-viewall-oasis' => 'Ollar todos',
	'leaderboard-intro' => "'''&ldquo;Que son os logros?&rdquo;'''
Pode gañar insignias especiais por participar neste wiki!
Con cada insignia que obteña engadirá puntos á súa puntuación total:
as insignias de bronce dan 10 puntos, as de prata outorgan 50 puntos e as de ouro conceden 100 puntos.

Ao unirse ao wiki, o seu perfil de usuario mostra as insignias que gañou, así como unha lista dos logros aos que pode acceder.
[[Special:MyPage|Vaia ao seu perfil de usuario para comprobalo]]!",
	'leaderboard' => 'Taboleiro de logros',
	'achievements-recent-earned-badges' => 'Insignias conseguidas recentemente',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />conseguida por <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'conseguiu a insignia <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'O taboleiro mostra os cambios desde onte',
	'achievements-leaderboard-rank-label' => 'clasificación',
	'achievements-leaderboard-member-label' => 'membro',
	'achievements-leaderboard-points-label' => 'puntos',
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
	'achievements-badge-name-welcome' => 'Benvido ao wiki',
	'achievements-badge-name-introduction' => 'Introdución',
	'achievements-badge-name-sayhi' => 'Parado un intre para saudar',
	'achievements-badge-name-creator' => 'O creador',
	'achievements-badge-name-pounce' => 'Salta!',
	'achievements-badge-name-caffeinated' => 'Con cafeína',
	'achievements-badge-name-luckyedit' => 'Edición afortunada',
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
	'achievements-badge-to-get-welcome-details' => 'Prema sobre o botón "{{int:autocreatewiki-create-account}}" no canto superior dereito para unirse á comunidade.
Pode comezar a gañar as súas propias insignias!',
	'achievements-badge-to-get-introduction-details' => 'A súa páxina de usuario está baleira?
Prema no seu nome de usuario na parte superior da pantalla para comprobalo.
Prema en "{{int:edit}}" para engadir algunha información sobre si mesmo!',
	'achievements-badge-to-get-sayhi-details' => 'Pode deixar mensaxes a outros usuarios premendo en "{{int:tooltip-ca-addsection}}" nas súas páxinas de conversa.
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
	'achievements-badge-hover-desc-edit' => 'por facer $1 {{PLURAL:$1|edición|edicións}}<br />
{{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'por facer $1 {{PLURAL:$1|edición|edicións}}<br />
{{PLURAL:$1|nunha páxina|en páxinas}} $2!',
	'achievements-badge-hover-desc-picture' => 'por engadir $1 {{PLURAL:$1|imaxe|imaxes}}<br />
{{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-hover-desc-category' => 'por engadir $1 {{PLURAL:$1|páxina|páxinas}}<br />
a {{PLURAL:$1|unha categoría|categorías}}!',
	'achievements-badge-hover-desc-blogpost' => 'por escribir $1 {{PLURAL:$1|mensaxe|mensaxes}} de blogue!',
	'achievements-badge-hover-desc-blogcomment' => 'por escribir un comentario<br />
{{PLURAL:$1|nunha mensaxe|en $1 mensaxes}} de blogue!',
	'achievements-badge-hover-desc-love' => 'por colaborar no wiki cada día durante {{PLURAL:$1|un día|$1 días}}!',
	'achievements-badge-hover-desc-welcome' => 'por unirse ao wiki!',
	'achievements-badge-hover-desc-introduction' => 'por engadir información<br />
á súa páxina de usuario!',
	'achievements-badge-hover-desc-sayhi' => 'por deixar unha mensaxe<br />
na páxina de conversa de alguén!',
	'achievements-badge-hover-desc-creator' => 'por crear o wiki!',
	'achievements-badge-hover-desc-pounce' => 'por facer edicións en 100 páxinas durante a hora seguinte á creación da mesma!',
	'achievements-badge-hover-desc-caffeinated' => 'por facer 100 edicións en páxinas nun mesmo día!',
	'achievements-badge-hover-desc-luckyedit' => 'por facer a $1ª edición afortunada no wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Esta é unha insignia de platino especial que só estará dispoñible por tempo limitado!',
	'achievements-badge-your-desc-edit' => 'por facer {{PLURAL:$1|a súa primeira edición|$1 edicións}} {{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'por facer {{PLURAL:$1|a súa primeira edición|$1 edicións}} {{PLURAL:$1|nunha páxina|en páxinas}} $2!',
	'achievements-badge-your-desc-picture' => 'por engadir {{PLURAL:$1|a súa primeira imaxe|$1 imaxes}} {{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-your-desc-category' => 'por engadir {{PLURAL:$1|a súa primeira páxina|$1 páxinas}} a {{PLURAL:$1|unha categoría|categorías}}!',
	'achievements-badge-your-desc-blogpost' => 'por escribir {{PLURAL:$1|a súa primeira entrada|$1 entradas}} de blogue!',
	'achievements-badge-your-desc-blogcomment' => 'por escribir un comentario {{PLURAL:$1|nunha mensaxe|en $1 mensaxes}} de blogue!',
	'achievements-badge-your-desc-love' => 'por colaborar no wiki cada día durante {{PLURAL:$1|un día|$1 días}}!',
	'achievements-badge-your-desc-welcome' => 'por unirse ao wiki!',
	'achievements-badge-your-desc-introduction' => 'por engadir información á súa páxina de usuario!',
	'achievements-badge-your-desc-sayhi' => 'por deixar unha mensaxe na páxina de conversa de alguén!',
	'achievements-badge-your-desc-creator' => 'por crear o wiki!',
	'achievements-badge-your-desc-pounce' => 'por facer edicións en 100 páxinas durante a hora seguinte á creación da mesma!',
	'achievements-badge-your-desc-caffeinated' => 'por facer 100 edicións en páxinas nun mesmo día!',
	'achievements-badge-your-desc-luckyedit' => 'por facer a $1ª edición afortunada no wiki!',
	'achievements-badge-desc-edit' => 'por facer $1 {{PLURAL:$1|edición|edicións}} {{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-desc-edit-plus-category' => 'por facer $1 {{PLURAL:$1|edición|edicións}} {{PLURAL:$1|nunha páxina|en páxinas}} $2!',
	'achievements-badge-desc-picture' => 'por engadir $1 {{PLURAL:$1|imaxe|imaxes}} {{PLURAL:$1|nunha páxina|en páxinas}}!',
	'achievements-badge-desc-category' => 'por engadir $1 {{PLURAL:$1|páxina|páxinas}} a {{PLURAL:$1|unha categoría|categorías}}!',
	'achievements-badge-desc-blogpost' => 'por escribir $1 {{PLURAL:$1|mensaxe|mensaxes}} de blogue!',
	'achievements-badge-desc-blogcomment' => 'por escribir un comentario {{PLURAL:$1|nunha mensaxe|en $1 mensaxes}} de blogue!',
	'achievements-badge-desc-love' => 'por colaborar no wiki cada día durante {{PLURAL:$1|un día|$1 días}}!',
	'achievements-badge-desc-welcome' => 'por unirse ao wiki!',
	'achievements-badge-desc-introduction' => 'por engadir información á súa páxina de usuario!',
	'achievements-badge-desc-sayhi' => 'por deixar unha mensaxe na páxina de conversa de alguén!',
	'achievements-badge-desc-creator' => 'por crear o wiki!',
	'achievements-badge-desc-pounce' => 'por facer edicións en 100 páxinas durante a hora seguinte á creación da mesma!',
	'achievements-badge-desc-caffeinated' => 'por facer 100 edicións en páxinas nun mesmo día!',
	'achievements-badge-desc-luckyedit' => 'por facer a $1ª edición afortunada no wiki!',
);

/** Hungarian (Magyar) */
$messages['hu'] = array(
	'achievements-community-platinum-edit' => 'szerkesztés',
	'achievements-community-platinum-save' => 'mentés',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
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
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Auro',
	'achievements-silver' => 'Argento',
	'achievements-bronze' => 'Bronzo',
	'achievements-you-must' => 'Tu debe $1 pro ganiar iste insignia.',
	'leaderboard-button' => 'Classamento de successos',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|puncto|punctos}}</small>',
	'achievements-track-name-edit' => 'Tracia de modification',
	'achievements-track-name-picture' => 'Tracia de imagines',
	'achievements-track-name-category' => 'Tracia de categorias',
	'achievements-track-name-blogpost' => 'Tracia de articulos de blog',
	'achievements-track-name-blogcomment' => 'Tracia de commentos de blog',
	'achievements-track-name-love' => 'Tracia de amor wiki',
	'achievements-notification-title' => 'Va ben, $1!',
	'achievements-notification-subtitle' => 'Tu ha justo meritate le insignia "$1" $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Clicca hic pro vider plus insignias que tu pote meritar]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|puncto|punctos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|puncto|punctos}}',
	'achievements-earned' => 'Iste insignia ha essite meritate per {{PLURAL:$1|1 usator|$1 usatores}}.',
	'achievements-profile-title' => 'Le $2 {{PLURAL:$2|insignia|insignias}} meritate per $1',
	'achievements-profile-title-no' => 'Le insignias de $1',
	'achievements-profile-title-challenges' => 'Plus insignias que tu pote meritar!',
	'achievements-profile-customize' => 'Personalisar insignias >',
	'achievements-ranked' => 'Ha le rango №$1 in iste wiki',
	'achievements-no-badges' => 'Reguarda le lista hic infra pro vider le insignias que tu pote meritar in iste wiki!',
	'achievements-viewall' => 'Vider toto',
	'achievements-viewless' => 'Clauder',
	'achievements-profile-title-oasis' => 'punctos <br /> de merito',
	'achievements-ranked-oasis' => '$1 ha le [[Special:Leaderboard|rango №$2]] in iste wiki',
	'achievements-viewall-oasis' => 'Vider totes',
	'leaderboard-intro' => "'''&ldquo;Que es le insignias de merito?&rdquo;'''
Tu pote meritar special insignias per participar in iste wiki!
Cata insignia que tu merita adde punctos a tu score total:
le insignias de bronzo vale 10 punctos, le insignias de argento vale 50 punctos, e le insignias de auro vale 100 punctos.

Quando tu deveni membro del wiki, tu profilo de usator presenta le insignias que tu ha meritate, e te monstra un lista del defias que es disponibile a te.
[[Special:MyPage|Va a tu profilo de usator pro vider lo]]!",
	'leaderboard' => 'Classamento de successos',
	'achievements-recent-earned-badges' => 'Insignias recentemente ganiate',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />ganiate per <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'ganiava le insignia <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Le classamento monstra le cambios depost heri',
	'achievements-leaderboard-rank-label' => 'rango',
	'achievements-leaderboard-member-label' => 'membro',
	'achievements-leaderboard-points-label' => 'punctos',
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
	'achievements-community-platinum-awarded-to' => 'Meritate per:',
	'achievements-community-platinum-current-badges' => 'Insignias de platino actual',
	'achievements-community-platinum-create-badge' => 'Crear insignia',
	'achievements-community-platinum-enabled' => 'activate',
	'achievements-community-platinum-show-recents' => 'monstrar in insignias recente',
	'achievements-community-platinum-edit' => 'modificar',
	'achievements-community-platinum-save' => 'salveguardar',
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
	'achievements-badge-name-welcome' => 'Benvenite al wiki!',
	'achievements-badge-name-introduction' => 'Introduction',
	'achievements-badge-name-sayhi' => 'Passante pro dicer salute',
	'achievements-badge-name-creator' => 'Le creator',
	'achievements-badge-name-pounce' => 'Salta!',
	'achievements-badge-name-caffeinated' => 'Con caffeina',
	'achievements-badge-name-luckyedit' => 'Modification fortunate',
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
	'achievements-badge-to-get-welcome-details' => 'Clicca super le button "{{int:autocreatewiki-create-account}}" in alto a dextra pro junger te al communitate.
Tu pote comenciar a ganiar tu proprie insignias!',
	'achievements-badge-to-get-introduction-details' => 'Tu pagina de usator es vacue?
Clicca super tu nomine de usator in alto del schermo pro vider lo.
Clicca super "{{int:edit}}" pro adder alcun information super te!',
	'achievements-badge-to-get-sayhi-details' => 'Tu pote lassar messages a altere usatores cliccante "{{int:tooltip-ca-addsection}}" in lor pagina de discussion.
Demanda adjuta, regratia les pro lor labor, o simplemente saluta les!',
	'achievements-badge-to-get-creator-details' => 'Iste insignia es date al persona qui fundava le wiki.
Clicca super le button "{{int:createwiki}}" in alto pro comenciar un sito super lo que tu ama le plus!',
	'achievements-badge-to-get-pounce-details' => 'Tu debe esser rapide pro ganiar iste insignia.
Clicca super le button "{{int:activityfeed}}" pro vider le nove paginas que usatores crea!',
	'achievements-badge-to-get-caffeinated-details' => 'Es necessari haber un die productive pro ganiar iste insignia.
Continua a modificar!',
	'achievements-badge-to-get-luckyedit-details' => 'Tu debe esser fortunate pro ganiar iste insignia.
Continua a modificar!',
	'achievements-badge-to-get-community-platinum-details' => 'Isto es un insignia special de platino que es solmente disponibile pro un tempore limitate!',
	'achievements-badge-hover-desc-edit' => 'pro facer $1 {{PLURAL:$1|modification|modificationes}}<br />
in {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'pro facer $1 {{PLURAL:$1|modification|modificationes}}<br />
in {{PLURAL:$1|un pagina de $2|paginas de $2}}!',
	'achievements-badge-hover-desc-picture' => 'pro adder $1 {{PLURAL:$1|imagine|imagines}}<br />
a {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-hover-desc-category' => 'pro adder $1 {{PLURAL:$1|pagina|paginas}}<br />
a {{PLURAL:$1|un categoria|categorias}}!',
	'achievements-badge-hover-desc-blogpost' => 'pro scriber $1 {{PLURAL:$1|articulo|articulos}} de blog!',
	'achievements-badge-hover-desc-blogcomment' => 'pro scriber un commento<br />
super $1 differente {{PLURAL:$1|articulo|articulos}} de blog!',
	'achievements-badge-hover-desc-love' => 'pro contribuer al wiki cata die durante {{PLURAL:$1|un die|$1 dies}}!',
	'achievements-badge-hover-desc-welcome' => 'pro junger te al wiki!',
	'achievements-badge-hover-desc-introduction' => 'pro adder a<br />
tu proprie pagina de usator!',
	'achievements-badge-hover-desc-sayhi' => 'pro lassar un message<br />
in le pagina de discussion de un altere persona!',
	'achievements-badge-hover-desc-creator' => 'pro crear le wiki!',
	'achievements-badge-hover-desc-pounce' => 'pro facer modificationes in 100 paginas intra un hora post le creation del pagina!',
	'achievements-badge-hover-desc-caffeinated' => 'pro facer 100 modificationes in paginas in un sol die!',
	'achievements-badge-hover-desc-luckyedit' => 'pro facer le modification fortunate №$1 in le wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Isto es un insignia special de platino que es solmente disponibile pro un tempore limitate!',
	'achievements-badge-your-desc-edit' => 'pro facer {{PLURAL:$1|tu prime modification|$1 modificationes}} in {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'pro facer {{PLURAL:$1|tu prime modification|$1 modificationes}} in {{PLURAL:$1|un pagina de $2|paginas de $2}}!',
	'achievements-badge-your-desc-picture' => 'pro adder {{PLURAL:$1|tu prime imagine|$1 imagines}} a {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-your-desc-category' => 'pro adder {{PLURAL:$1|tu prime pagina|$1 paginas}} a {{PLURAL:$1|un categoria|categorias}}!',
	'achievements-badge-your-desc-blogpost' => 'pro scriber {{PLURAL:$1|tu prime articulo|$1 articulos}} de blog!',
	'achievements-badge-your-desc-blogcomment' => 'pro scriber un commento super {{PLURAL:$1|un articulo|$1 differente articulos}} de blog!',
	'achievements-badge-your-desc-love' => 'pro contribuer al wiki cata die durante {{PLURAL:$1|un die|$1 dies}}!',
	'achievements-badge-your-desc-welcome' => 'pro junger te al wiki!',
	'achievements-badge-your-desc-introduction' => 'pro adder a tu proprie pagina de usator!',
	'achievements-badge-your-desc-sayhi' => 'pro lassar un message in le pagina de discussion de un altere persona!',
	'achievements-badge-your-desc-creator' => 'pro crear le wiki!',
	'achievements-badge-your-desc-pounce' => 'pro facer modificationes in 100 paginas intra un hora post le creation del pagina!',
	'achievements-badge-your-desc-caffeinated' => 'pro facer 100 modificationes in paginas in un sol die!',
	'achievements-badge-your-desc-luckyedit' => 'pro facer le modification fortunate №$1 in le wiki!',
	'achievements-badge-desc-edit' => 'pro facer $1 {{PLURAL:$1|modification|modificationes}} in {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-desc-edit-plus-category' => 'pro facer $1 {{PLURAL:$1|modification|modificationes}} in {{PLURAL:$1|un pagina de $2|paginas de $2}}!',
	'achievements-badge-desc-picture' => 'pro adder $1 {{PLURAL:$1|imagine|imagines}} a {{PLURAL:$1|un pagina|paginas}}!',
	'achievements-badge-desc-category' => 'pro adder $1 {{PLURAL:$1|pagina|paginas}} a {{PLURAL:$1|un categoria|categorias}}!',
	'achievements-badge-desc-blogpost' => 'pro scriber $1 {{PLURAL:$1|articulo|articulos}} de blog!',
	'achievements-badge-desc-blogcomment' => 'pro scriber un commento super {{PLURAL:$1|un articulo|$1 differente articulos}} de blog!',
	'achievements-badge-desc-love' => 'pro contribuer al wiki cata die durante {{PLURAL:$1|un die|$1 dies}}!',
	'achievements-badge-desc-welcome' => 'pro junger te al wiki!',
	'achievements-badge-desc-introduction' => 'pro adder a tu proprie pagina de usator!',
	'achievements-badge-desc-sayhi' => 'pro lassar un message in le pagina de discussion de un altere persona!',
	'achievements-badge-desc-creator' => 'pro crear le wiki!',
	'achievements-badge-desc-pounce' => 'pro facer modificationes in 100 paginas intra un hora post le creation del pagina!',
	'achievements-badge-desc-caffeinated' => 'pro facer 100 modificationes in paginas in un sol die!',
	'achievements-badge-desc-luckyedit' => 'pro facer le modification fortunate №$1 in le wiki!',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'achievements-viewless' => 'Mèchié',
	'achievements-badge-name-category-4' => 'Ọtúzọr',
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'leaderboard-button' => '達成度ランキング',
	'achievements-masthead-points' => '$1 <small>ポイント</small>',
	'achievements-earned' => 'これまでに $1 人がこのバッジを入手しました。',
	'achievements-profile-title' => '$1 が入手したバッジ（$2 個）',
	'achievements-profile-title-challenges' => '入手可能なバッジ',
	'achievements-profile-customize' => 'バッジのカスタマイズ',
	'achievements-ranked' => 'このウィキ上での順位 - #$1',
	'leaderboard-intro' => "'''&ldquo;達成度とは？&rdquo;'''
このウィキに参加すると、特別なバッジを入手できます。それぞれのバッジには、ブロンズバッジが10ポイント、シルバーバッジが50ポイント、ゴールドバッジが100ポイント、といったようにポイントが設定されており、バッジを入手すると、そのバッジに設定されたポイントが総合ポイントに加算されます。

ウィキに参加すると、利用者ページにあなたが入手したバッジが表示され、さらに入手可能なバッジとそれを入手するための条件がリスト形式で表示されます。[[Special:MyPage|自分の利用者ページをチェックしてみましょう]]。",
	'leaderboard' => '達成度ランキング',
	'achievements-recent-earned-badges' => '最近授与されたバッジ',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br /><a href="$1">$2</a> が入手<br />$5',
	'achievements-activityfeed-info' => '$2<br /><strong><a href="$3" class="badgeName">$1</a></strong> バッジを入手',
	'achievements-leaderboard-disclaimer' => '昨日からの変動を表示しています',
	'achievements-leaderboard-rank-label' => '順位',
	'achievements-leaderboard-member-label' => 'メンバー',
	'achievements-leaderboard-points-label' => 'ポイント',
	'achievementscustomize' => 'バッジのカスタマイズ',
	'achievements-about-title' => 'このページについて',
	'achievements-about-content' => 'このウィキの管理者は、達成度バッジの名称と画像をカスタマイズできます。

.jpg もしくは .png の画像がアップロードでき、アップロードされた画像はバッジの枠に合うように自動的に調整されます。
この機能は、画像が正方形で、バッジに用いるにあたって重要な部分が画像の中央に集まっているときに最もよく機能するようになっています。

長方形の画像を使うこともできますが、画像が切れて一部が枠から外れてしまうかもしれません。
画像編集ソフトを持っているのであれば、画像を切り抜いて重要な部分が中央にくるようにしてください。
選択した画像が気に入らなければ、"{{int:achievements-revert}}" をクリックしてもとの画像に戻してください。

各ウィキで扱っている話題に合わせて、バッジに新しい名称を設定できます。
バッジの名称を変更したときは、"{{int:achievements-save}}" をクリックして変更を保存してください。',
	'achievements-badge-to-get-love' => '$1日間継続してこのウィキに投稿する',
	'achievements-badge-hover-desc-welcome' => 'このウィキへの参加に対して',
	'achievements-badge-hover-desc-introduction' => '自分の利用者ページの作成に対して',
	'achievements-badge-your-desc-introduction' => '自分の利用者ページの作成に対して',
	'achievements-badge-desc-edit' => '編集回数 $1 回を達成したことに対して',
);

/** Korean (한국어)
 * @author Infinity
 */
$messages['ko'] = array(
	'achievementsii-desc' => '위키 사용자의 기여도를 배지로 환산해주는 시스템',
	'achievements-upload-error' => '죄송합니다! 
이 그림은 적합하지 않습니다.
그림의 확장자가 .jpg 또는.png 이어야 합니다. 
또는 그림이 너무 무겁기 때문일수도 있습니다. 
다른 그림으로 시도해보세요.',
	'achievements-upload-not-allowed' => '관리자는 [[특수기능:AchievementsCustomize|배지 설정]] 문서를 통해 이름과 성취 배지의 사진을 변경할 수 있습니다.',
	'achievements-non-existing-category' => '지정한 분류가 존재하지 않습니다.',
	'achievements-no-stub-category' => '토막글을 위한 트랙을 생성하지 말아주세요.',
	'achievements-platinum' => '플래티넘',
	'achievements-gold' => '골드',
	'achievements-silver' => '실버',
	'achievements-bronze' => '브론즈',
	'achievements-you-must' => '이 배지를 얻기 위해서는 $1이(가) 필요합니다.',
	'leaderboard-button' => '배지 현황판',
	'achievements-masthead-points' => '$1 <small>포인트</small>',
	'achievements-track-name-edit' => '편집 트랙',
	'achievements-track-name-picture' => '그림 트랙',
	'achievements-track-name-category' => '분류 트랙',
	'achievements-track-name-blogpost' => '블로그 글 트랙',
	'achievements-track-name-blogcomment' => '블로그 댓글 트랙',
	'achievements-track-name-love' => '위키 사랑 트랙',
	'achievements-notification-title' => '$1님 축하드립니다!',
	'achievements-notification-subtitle' => "당신은 $2 '$1' 배지를 얻었습니다.",
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|얻을 수 있는 더 많은 배지 보기]]</big></strong>',
	'achievements-points' => '$1 포인트',
	'achievements-points-with-break' => '$1<br />포인트',
	'achievements-earned' => '$1명의 사용자가 이 배지를 갖고 있습니다.',
	'achievements-profile-title' => '$1 사용자가 소유하고 있는 $2개의 배지 목록',
	'achievements-profile-title-no' => '$1의 배지',
	'achievements-profile-title-challenges' => '받을 수 있는 배지 목록',
	'achievements-profile-customize' => '배지 사용자 정의',
	'achievements-ranked' => '이 위키의 $1위',
	'achievements-no-badges' => '아래 목록에서 이 위키에서 얻을 수 있는 배지를 찾아보실 수 있습니다.',
	'achievements-viewall' => '모두 보기',
	'achievements-viewless' => '닫기',
	'leaderboard-intro' => "'''&ldquo;배지란 무엇인가요?&rdquo;'''
이 위키에 기여함으로써 배지를 얻을 수 있습니다!
받은 모든 배지의 점수를 합산한 점수가 자신의 계정 이름 옆에 표시됩니다.
브론즈 배지는 하나당 10포인트이고 실버 배지는 하나당 50포인트이며 골드 배지는 하나당 100포인트입니다.

사용자 프로필 문서에서 자신이 받은 배지와 받을 수 있는 배지를 확인하실 수 있습니다.
[[Special:MyPage|지금 바로 확인해보세요]]!",
	'leaderboard' => '배지 현황판',
	'achievements-recent-earned-badges' => '최근에 수여된 배지',
	'achievements-recent-info' => '$5 <a href="$1">$2</a> 사용자가 $4 \'$3\' 배지를 얻었습니다.',
	'achievements-leaderboard-disclaimer' => '이 목록은 어제 이후의 변경 사항을 보여주고 있습니다.',
	'achievements-leaderboard-rank-label' => '순위',
	'achievements-leaderboard-member-label' => '사용자 이름',
	'achievements-leaderboard-points-label' => '포인트',
	'achievements-send' => '그림 저장',
	'achievements-save' => '변경 사항 저장',
	'achievements-reverted' => '배지를 초기값으로 되돌렸습니다.',
	'achievements-customize' => '배지 그림 사용자 정의',
	'achievements-revert' => '초기 설정으로 되돌리기',
	'achievements-special-saved' => '변경 사항이 저장되었습니다.',
	'achievementscustomize' => '배지 사용자 정의',
	'achievements-about-title' => '이 문서에 대해서...',
	'platinum' => '플래티넘',
	'achievements-community-platinum-awarded-email-subject' => '당신은 방금 새로운 플래티넘 배지를 받았습니다!',
	'achievements-community-platinum-how-to-earn' => '얻는 방법 :',
	'achievements-community-platinum-awarded-for-example' => "예시 : '~을(를) 함으로써...'",
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
	'achievements-badge-name-welcome' => '위키에 어서 오세요',
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
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Jold',
	'achievements-silver' => 'Selver',
	'achievements-bronze' => 'Brongße',
	'achievements-you-must' => 'Do moß ald $1, öm dä Orde ze verdeene.',
	'achievements-leaderboard-points-label' => 'Pünkscher',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Gold',
	'achievements-silver' => 'Sëlwer',
	'achievements-viewless' => 'Zoumaachen',
	'achievements-send' => 'Bild späicheren',
	'achievements-save' => 'Ännerunge späicheren',
	'achievements-revert' => 'Op de Standard zrécksetzen',
	'achievements-special-saved' => 'Ännerunge gespäichert.',
	'achievements-about-title' => 'Iwwer dës Säit...',
	'platinum' => 'Platin',
	'achievements-community-platinum-edit' => 'änneren',
	'achievements-community-platinum-save' => 'späicheren',
	'achievements-badge-name-edit-4' => 'Mataarbechter',
	'achievements-badge-name-blogcomment-1' => 'An dann nach eppes',
	'achievements-badge-name-welcome' => 'Wëllkomm op der Wiki',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'achievementsii-desc' => 'Систем на значки за достигнувања на вики-корисници',
	'achievements-upload-error' => 'Жалиме!
Таа слика не работи.
Проверете дали е со наставка .jpg или .png.
Ако и покрај тоа не работи, тогаш веројатно е преголема.
Пробајте со друга!',
	'achievements-upload-not-allowed' => 'Администраторите можат да ги менуваат називите и сликите на значките за достигнувања на страницата [[Special:AchievementsCustomize|Прилагодување на достигнувања]].',
	'achievements-non-existing-category' => 'Укажаната категорија не постои.',
	'achievements-edit-plus-category-track-exists' => 'Укажаната категорија веќе има <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Оди на лентата">своја лента</a>.',
	'achievements-no-stub-category' => 'Не создавајте ленти за никулци.',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Злато',
	'achievements-silver' => 'Сребро',
	'achievements-bronze' => 'Бронза',
	'achievements-you-must' => 'Треба $1 за да ја заработите оваа значка.',
	'leaderboard-button' => 'Предводници',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|бод|бода}}</small>',
	'achievements-track-name-edit' => 'Уреди лента',
	'achievements-track-name-picture' => 'Лента со слики',
	'achievements-track-name-category' => 'Категориска лента',
	'achievements-track-name-blogpost' => 'Лента за блог-записи',
	'achievements-track-name-blogcomment' => 'Лента за блог-коментари',
	'achievements-track-name-love' => 'Викиљубовна лента',
	'achievements-notification-title' => 'Само така, $1!',
	'achievements-notification-subtitle' => 'Штотуку ја заработивте значката „$1“ $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Кликнете тука за да ги видите значките што можат да се заработат]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|бод|бода}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|бод|бода}}',
	'achievements-earned' => 'Оваа значка {{PLURAL:$1|ја заработил 1 корисник|ја заработиле $1 корисници}}.',
	'achievements-profile-title' => '{{PLURAL:$2|1-та заработена значка|$2-те заработени значки}} на $1',
	'achievements-profile-title-no' => 'значките на $1',
	'achievements-profile-title-challenges' => 'Повеќе значки кои можете да ги заработите!',
	'achievements-profile-customize' => 'Прилагоди значки >',
	'achievements-ranked' => 'На $1 место на ова вики',
	'achievements-no-badges' => 'Проверете го долунаведениот список за да видите кои значки можете да ги заработите на ова вики!',
	'achievements-viewall' => 'Преглед на сите',
	'achievements-viewless' => 'Затвори',
	'achievements-profile-title-oasis' => 'наградни <br /> бодови',
	'achievements-ranked-oasis' => '$1 се [[Special:Leaderboard|котира на $2 место]] на ова вики',
	'achievements-viewall-oasis' => 'Сите',
	'leaderboard-intro' => "'''&ldquo;What are Achievements?&rdquo;'''
Со учество на ова вики можете да заработите специјални значки! 
Секоја заработена значка ви носи бодови кон вкупното салдо: 
Бронзените значки носат 10 бода, Сребрените значки носат 50 бода, а Златните носат 100 бода.

Кога ќе се зачлените на викито, на корисничкиот профил се истакнати значките што сте ги заработиле, како и список на предизвиците кои ви се достапни. [[Special:MyPage|Одете на вашиот кориснички профил и погледајте!]]",
	'leaderboard' => 'Предводници',
	'achievements-recent-earned-badges' => 'Скорешни заработени значки',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />заработена од <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'заработена значката <strong><a href="$3" class="badgeName">$1</a></strong> <br />$2',
	'achievements-leaderboard-disclaimer' => 'Табелата на водачи ги прикажува промените од вчера до денес',
	'achievements-leaderboard-rank-label' => 'ранг',
	'achievements-leaderboard-member-label' => 'член',
	'achievements-leaderboard-points-label' => 'бодови',
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
	'achievements-badge-name-welcome' => 'Добредојде на викито',
	'achievements-badge-name-introduction' => 'Претставување',
	'achievements-badge-name-sayhi' => 'Поздрав',
	'achievements-badge-name-creator' => 'Создавач',
	'achievements-badge-name-pounce' => 'Залетан',
	'achievements-badge-name-caffeinated' => 'Кофеинизиран',
	'achievements-badge-name-luckyedit' => 'Среќно уредување',
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
	'achievements-badge-to-get-welcome-details' => 'Кликнете на копчето „{{int:autocreatewiki-create-account}}“ во горниот десен агол за да се приклучите кон заеднцата. 
Потоа можете да почнете да си печалите значки!',
	'achievements-badge-to-get-introduction-details' => 'Дали ви е празна корисничката страница? 
Кликнете на вашето корисничко име најгоре за да видите. 
Кликнете на „{{int:edit}}“ за да ставите некои податоци за себе!',
	'achievements-badge-to-get-sayhi-details' => 'Можете да им оставате пораки на другите корисници со стискање на „{{int:tooltip-ca-addsection}}“ на нивната страница за разговор. 
Вака можете да побарате помош, да им се заблагодарите за трудот, или едноставно да ги поздравите!',
	'achievements-badge-to-get-creator-details' => 'Оваа страница се доделува на личноста која е основач на викито. 
Кликнете на копчето „{{int:createwiki}}“ најгоре и започнете мрежно-место на вашата омилена тематика!',
	'achievements-badge-to-get-pounce-details' => 'За да ја добиете оваа значка мора да бидете брзи. 
Кликнете на копчето „{{int:activityfeed}}“ за да ги видите новите страници што ги создаваат корисниците!',
	'achievements-badge-to-get-caffeinated-details' => 'Треба доста работа за да ја заработите оваа значка. Продолжете така!',
	'achievements-badge-to-get-luckyedit-details' => 'Треба да имате среќа за да ја добиете оваа значка. Продолжете со уредување!',
	'achievements-badge-to-get-community-platinum-details' => 'Ова е специјална Платинска значка што се доделува само извесно време!',
	'achievements-badge-hover-desc-edit' => 'за $1 {{PLURAL:$1|уредување|уредувања}}<br />
на {{PLURAL:$1|една страница|страници}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'за $1 {{PLURAL:$1|уредување|уредувања}}<br />
на {{PLURAL:$1|една|}} $2 {{PLURAL:$1|страница| страници}}!',
	'achievements-badge-hover-desc-picture' => 'за ставање на $1 {{PLURAL:$1|слика|слики}}<br />
на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-hover-desc-category' => 'за ставање на $1 {{PLURAL:$1|страница|страници}}<br />
во {{PLURAL:$1|категорија|категории}}!',
	'achievements-badge-hover-desc-blogpost' => 'за пишување на $1 {{PLURAL:$1|блог-запис|блог-записи}}!',
	'achievements-badge-hover-desc-blogcomment' => 'за оставање коментар<br />
на $1 {{PLURAL:$1|блог-запис|различни блог-записи}}!',
	'achievements-badge-hover-desc-love' => 'за секојдневен придонес на викито во текот на $1 дена!',
	'achievements-badge-hover-desc-welcome' => 'за зачленување на викито!',
	'achievements-badge-hover-desc-introduction' => 'за додавање содржини на<br />
вашата корисничка страница!',
	'achievements-badge-hover-desc-sayhi' => 'за оставање на порака<br />
на нечија страница за разговор!',
	'achievements-badge-hover-desc-creator' => 'за создавање на викито!',
	'achievements-badge-hover-desc-pounce' => 'за извршени уредувања на 100 страници во рок од еден час од нивното создавање!',
	'achievements-badge-hover-desc-caffeinated' => 'за извршени 100 уредувања на страници за еден ден!',
	'achievements-badge-hover-desc-luckyedit' => 'за извршување на Среќното $1-то уредување на викито!',
	'achievements-badge-hover-desc-community-platinum' => 'Ова е специјална Платинска значка што се доделува само извесно време!',
	'achievements-badge-your-desc-edit' => 'за {{PLURAL:$1|вашето прво|$1}} {{PLURAL:$1|уредување|уредувања}} на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'за {{PLURAL:$1|вашето прво|$1}} {{PLURAL:$1|уредување|уредувања}} на {{PLURAL:$1||}} $2 {{PLURAL:$1|страница| страници}}!',
	'achievements-badge-your-desc-picture' => 'за ставање на {{PLURAL:$1|вашата прва|$1}} {{PLURAL:$1|слика|слики}} на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-your-desc-category' => 'за додавање на {{PLURAL:$1|вашата прва|$1}} {{PLURAL:$1|страница|страници}} во {{PLURAL:$1|категорија|категории}}!',
	'achievements-badge-your-desc-blogpost' => 'за пишување на {{PLURAL:$1|вашиот прв|$1}} {{PLURAL:$1|блог-запис|блог-записи}}!',
	'achievements-badge-your-desc-blogcomment' => 'за коментирање на $1 различни блог-записи.',
	'achievements-badge-your-desc-love' => 'за секојдневно придонесување на викито во текот на $1 дена',
	'achievements-badge-your-desc-welcome' => 'за зачленување на викито!',
	'achievements-badge-your-desc-introduction' => 'за збогатување на вашата корисничка страница.',
	'achievements-badge-your-desc-sayhi' => 'за оставање порака на нечија страница за разговор!',
	'achievements-badge-your-desc-creator' => 'за создавање на викито!',
	'achievements-badge-your-desc-pounce' => 'за уредување на 100 страници во рок од еден час од нивното создавање!',
	'achievements-badge-your-desc-caffeinated' => 'за 100 уредувања на страници во еден ден!',
	'achievements-badge-your-desc-luckyedit' => 'за Среќното $1-то уредување на викито!',
	'achievements-badge-desc-edit' => 'а $1 {{PLURAL:$1|извршено уредување|извршени уредувања}} на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-desc-edit-plus-category' => 'за $1 {{PLURAL:$1|извршено уредување|извршени уредувања}} на {{PLURAL:$1|една|}} $2 {{PLURAL:$1|страница| страници}}!',
	'achievements-badge-desc-picture' => 'за ставање на $1 {{PLURAL:$1|слика|слики}} на {{PLURAL:$1|страница|страници}}!',
	'achievements-badge-desc-category' => 'за $1 {{PLURAL:$1|ставена страница|ставени страници}} во {{PLURAL:$1|категорија|категории}}!',
	'achievements-badge-desc-blogpost' => 'за $1 {{PLURAL:$1|напишан блог-запис|напишани блог-записи}}!',
	'achievements-badge-desc-blogcomment' => 'за оставање коментар на {{PLURAL:$1|блог-запис|$1 различни блог-записи}}!',
	'achievements-badge-desc-love' => 'за секојдневен придонес на викито во текот на {{PLURAL:$1|еден ден|$1 дена}}!',
	'achievements-badge-desc-welcome' => 'за зачленување на викито!',
	'achievements-badge-desc-introduction' => 'за додавање содржина на вашата корисничка страница!',
	'achievements-badge-desc-sayhi' => 'за оставање порака на нечија страница за разговор!',
	'achievements-badge-desc-creator' => 'за создавање на викито!',
	'achievements-badge-desc-pounce' => 'за извршени уредувања на 100 страници во текот на еден час од создавањето на страниците!',
	'achievements-badge-desc-caffeinated' => 'за извршени 100 уредувања на страници во текот на еден ден!',
	'achievements-badge-desc-luckyedit' => 'за извршување на Среќното $1-то уредување на викито!',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'achievementsii-desc' => 'Een speldjessysteem voor op de wiki door gebruikers geleverde prestaties',
	'achievements-upload-error' => 'Dat plaatje werkt niet.
Zorg dat het een .jpg- of .png-bestand is.
Als het dan nog steeds niet werkt, dan is het plaatje mogelijk te groot.
Kies dan een ander plaatje.',
	'achievements-upload-not-allowed' => 'Beheerders kunnen de namen en afbeeldingen van prestatiespeldjes wijzigen via de pagina [[Special:AchievementsCustomize|Prestaties aanpassen]].',
	'achievements-non-existing-category' => 'De opgegeven categorie bestaat niet.',
	'achievements-edit-plus-category-track-exists' => 'De aangegeven categorie heeft al een <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Naar het traject">bijbehorend traject</a>.',
	'achievements-no-stub-category' => 'Maak alstublieft geen trajecten voor beginnetjes aan.',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Goud',
	'achievements-silver' => 'Zilver',
	'achievements-bronze' => 'Brons',
	'achievements-you-must' => 'U moet $1 om dit speldje te verdienen.',
	'leaderboard-button' => 'Scorebord prestaties',
	'achievements-masthead-points' => '$1 <small>punten</small>',
	'achievements-track-name-edit' => 'Voor bewerkingen',
	'achievements-track-name-picture' => 'Voor afbeeldingen',
	'achievements-track-name-category' => 'Voor categorieën',
	'achievements-track-name-blogpost' => 'Voor blogberichten',
	'achievements-track-name-blogcomment' => 'Voor reacties op blogberichten',
	'achievements-track-name-love' => 'Voor wikilove',
	'achievements-notification-title' => 'Dat gaat goed, $1!',
	'achievements-notification-subtitle' => 'U hebt zojuist het speldje "$1" verdiend $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Klik hier om meer speldjes te zien die u kunt verdienen]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punt|punten}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punt|punten}}',
	'achievements-earned' => 'Dit speldje is verdiend door {{PLURAL:$1|één gebruiker|$1 gebruikers}}.',
	'achievements-profile-title' => '$2 heeft $1 {{PLURAL:$2|speldje|speldjes}} verdiend',
	'achievements-profile-title-no' => 'Speldjes van $1',
	'achievements-profile-title-challenges' => 'Meer te verdienen speldjes!',
	'achievements-profile-customize' => 'Speldjes aanpassen >',
	'achievements-ranked' => 'Op plaats $1 in de ranglijst van deze wiki',
	'achievements-no-badges' => 'Hieronder staan de speldjes die u op deze wiki kunt verdienen!',
	'achievements-viewall' => 'Allemaal bekijken',
	'achievements-viewless' => 'Sluiten',
	'achievements-profile-title-oasis' => 'punten',
	'achievements-ranked-oasis' => '$1 staat op [[Special:Leaderboard|plaats $2]] voor deze wiki',
	'achievements-viewall-oasis' => 'Allemaal bekijken',
	'leaderboard-intro' => "'''&ldquo;Wat zijn prestaties?&rdquo;'''
U kunt speciale speldjes verdienen door deel te nemen aan deze wiki!
Met ieder speldje dat u verdient loopt uw totaalscore op. Bronzen speldjes zijn 10 punten waard, zilveren speldjes zijn 50 punten waard en gouden speldjes zijn 100 punten waard.

Als u bij de wiki komt, wordt in uw gebruikersprofiel aangegeven welke speldjes u verdiend hebt en de lijst met uitdagingen die u nog kunt voltooien.
[[Special:MyPage|Ga naar uw gebruikersprofiel voor details]]!",
	'leaderboard' => 'Scorebord prestaties',
	'achievements-recent-earned-badges' => 'Recent verdiende speldjes',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />Uitgereikt aan <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'heeft het speldje <strong><a href="$3" class="badgeName">$1</a></strong> verdiend<br />$2',
	'achievements-leaderboard-disclaimer' => 'Wijzigingen op het scorebord sinds gisteren',
	'achievements-leaderboard-rank-label' => 'Rang',
	'achievements-leaderboard-member-label' => 'Lid',
	'achievements-leaderboard-points-label' => 'Punten',
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
	'achievements-create-edit-plus-category-content' => 'U kunt u nieuwe reeks speldjes maken om gebruikers te belonen voor het maken van bewerkingen in een bepaalde categorie, om een bepaald gebied van de site waarin gebruikers het leuk vinden om te werken uit te lichten.
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
Hiermee zijn ook 250 puten aan uw score toegevoegd!<br /><br />
Bekijk uw glimmende nieuwe speldje op uw <a href="$5">gebruikersprofielpagina</a>.',
	'achievements-community-platinum-awarded-for' => 'Toegewezen door:',
	'achievements-community-platinum-how-to-earn' => 'Hoe te verdienen:',
	'achievements-community-platinum-awarded-for-example' => 'Bijvoorbeeld "voor het uitvoeren van ...',
	'achievements-community-platinum-how-to-earn-example' => 'Bijvoorbeeld "maak drie bewerkingen ...',
	'achievements-community-platinum-badge-image' => 'Afbeelding voor speldje:',
	'achievements-community-platinum-awarded-to' => 'Toegewezen voor:',
	'achievements-community-platinum-current-badges' => 'Bestaande Platina speldjes',
	'achievements-community-platinum-create-badge' => 'Speldje aanmaken',
	'achievements-community-platinum-enabled' => 'ingeschakeld',
	'achievements-community-platinum-show-recents' => 'weergeven in recente speldjes',
	'achievements-community-platinum-edit' => 'bewerken',
	'achievements-community-platinum-save' => 'opslaan',
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
	'achievements-badge-name-picture-7' => 'Curator',
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
	'achievements-badge-name-welcome' => 'Welkom bij de wiki',
	'achievements-badge-name-introduction' => 'Inleiding',
	'achievements-badge-name-sayhi' => 'Langsgekomen voor een begroeting',
	'achievements-badge-name-creator' => 'De oprichter',
	'achievements-badge-name-pounce' => 'Stormram!',
	'achievements-badge-name-caffeinated' => 'Overdosis koffie',
	'achievements-badge-name-luckyedit' => 'Gelukkige bewerking',
	'achievements-badge-to-get-edit' => "maak {{PLURAL:$1|één bewerking|$1 bewerkingen}} aan {{PLURAL:$1een pagina|pagina's}}",
	'achievements-badge-to-get-edit-plus-category' => "maak $1 {{PLURAL:$1|bewerking|bewerkingen}} aan $2 {{PLURAL:$2|pagina|pagina's}}",
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
	'achievements-badge-to-get-edit-details' => 'Mist er iets?
Is er een fout gemaakt?
Wees niet verlegen. Klik op de knop "{{int:edit}}" en u kunt iedere pagina bewerken!',
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
Lees de recente blogberichten en schrijf uw gedachten in het opmerkingenveld.',
	'achievements-badge-to-get-love-details' => 'De teller wordt op nul gezet als u een dag mist, dus zorg ervoor dat u iedere dag naar de wiki komt!',
	'achievements-badge-to-get-welcome-details' => 'Klik op de knop "{{int:autocreatewiki-create-account}}" rechts bovenaan om bij de gemeenschap te komen.
U kunt nu beginnen met het verzamelen van speldjes!',
	'achievements-badge-to-get-introduction-details' => 'Is uw gebruikerspagina leeg?
Klik op uw gebruikersnaam bovenaan het scherm om te kijken of dat zo is.
Klik op "{{int:edit}}" om wat informatie over uzelf toe te voegen!',
	'achievements-badge-to-get-sayhi-details' => 'U kunt berichten voor andere gebruikers achterlaten door te klikken op "{{int:tooltip-ca-addsection}}" op hun overlegpagina.
Vraag om hulp, bedank ze voor hun bijdragen of groet ze gewoon!',
	'achievements-badge-to-get-creator-details' => 'Dit speldje wordt gegeven aan de oprichter van de wiki.
Klik op de knop "{{int:createwiki}}" bovenaan om een site te beginnen over waar u van houdt!',
	'achievements-badge-to-get-pounce-details' => 'U moet snel zijn om dit speldje te verdienen. Klik op de knop "{{int:activityfeed}}" om te zien welke nieuwe pagina\'s gebruikers aan het aanmaken zijn!',
	'achievements-badge-to-get-caffeinated-details' => 'U moet een drukke dag hebben om dit speldje te verdienen. Blijf bewerkingen maken!',
	'achievements-badge-to-get-luckyedit-details' => 'U moet geluk hebben om dit speldje te verdienen. Blijf bewerkingen maken!',
	'achievements-badge-to-get-community-platinum-details' => 'Dit is een speciaal platina speldje dat slechts voor beperkte tijd beschikbaar is!',
	'achievements-badge-hover-desc-edit' => "voor het maken van {{PLURAL:$1|één bewerking|$1 bewerkingen}}<br />
aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-hover-desc-edit-plus-category' => "voor het maken van {{PLURAL:$1|één bewerking|$1 bewerkingen}}<br />
aan {{PLURAL:$1|een $2pagina|$2pagina's}}!",
	'achievements-badge-hover-desc-picture' => "voor het toevoegen van {{PLURAL:$1|een afbeelding|$1 afbeeldingen}}<br />
aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-hover-desc-category' => "voor het toevoegen van {{PLURAL:$1|een pagina|$1 pagina's}}<br />
aan {{PLURAL:$1|een categorie|categorieën}}!",
	'achievements-badge-hover-desc-blogpost' => 'voor het schrijven van {{PLURAL:$1|een blogbericht|$1 blogberichten}}!',
	'achievements-badge-hover-desc-blogcomment' => 'voor het schrijven van een opmerking<br />
bij {{PLURAL:$1|een blogbericht|$1 verschillende blogberichten}}!',
	'achievements-badge-hover-desc-love' => 'voor het iedere dag bijdragen aan de wiki gedurende {{PLURAL:$1|een dag|$1 dagen}}!',
	'achievements-badge-hover-desc-welcome' => 'voor het deelnemen aan de wiki!',
	'achievements-badge-hover-desc-introduction' => 'voor het aanmaken van<br />
uw eigen gebruikerspagina!',
	'achievements-badge-hover-desc-sayhi' => 'voor het achterlaten van een bericht op<br />
de overlegpagina van een andere gebruiker!',
	'achievements-badge-hover-desc-creator' => 'voor het oprichten van de wiki!',
	'achievements-badge-hover-desc-pounce' => "voor het maken van bewerkingen aan 100 pagina's binnen een uur van het aanmaken van de pagina!",
	'achievements-badge-hover-desc-caffeinated' => 'voor het maken van 100 bewerkingen op één dag.',
	'achievements-badge-hover-desc-luckyedit' => 'voor het maken van de gelukkige bewerking nummer $1 op de wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Dit is een speciaal platina speldje dat slechts voor beperkte tijd beschikbaar is!',
	'achievements-badge-your-desc-edit' => "voor het maken van {{PLURAL:$1|uw eerste bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-your-desc-edit-plus-category' => "voor het maken van {{PLURAL:$1|uw eerste bewerking|$1 bewerkingen}} on {{PLURAL:$1|een $2pagina|$2pagina's}}!",
	'achievements-badge-your-desc-picture' => "voor het toevoegen van {{PLURAL:$1|uw eerste afbeelding|$1 afbeeldingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-your-desc-category' => "voor het toevoegen van {{PLURAL:$1|uw eerste pagina|$1 pagina's}} aan {{PLURAL:$1|een categorie|categorieën}}!",
	'achievements-badge-your-desc-blogpost' => 'voor het schrijven van {{PLURAL:$1|uw eerste|$1}} {{PLURAL:$1|blogbericht|blogberichten}}!',
	'achievements-badge-your-desc-blogcomment' => 'voor het schrijven van een opmerking bij {{PLURAL:$1|een blogbericht|$1 verschillende blogberichten}}!',
	'achievements-badge-your-desc-love' => 'voor het iedere dag bijdragen aan de wiki gedurende {{PLURAL:$1|een dag|$1 dagen}}!',
	'achievements-badge-your-desc-welcome' => 'voor het deelnemen aan de wiki!',
	'achievements-badge-your-desc-introduction' => 'voor het aanmaken van uw eigen gebruikerspagina!',
	'achievements-badge-your-desc-sayhi' => 'voor het achterlaten van een bericht op de overlegpagina van een andere gebruiker!',
	'achievements-badge-your-desc-creator' => 'voor het oprichten van de wiki!',
	'achievements-badge-your-desc-pounce' => "voor het maken van bewerkingen aan 100 pagina's binnen een uur van het aanmaken van de pagina!",
	'achievements-badge-your-desc-caffeinated' => 'voor het maken van 100 bewerkingen op één dag.',
	'achievements-badge-your-desc-luckyedit' => 'voor het maken van de gelukkige bewerking nummer $1 op de wiki!',
	'achievements-badge-desc-edit' => "voor het maken van {{PLURAL:$1|een bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-desc-edit-plus-category' => "voor het maken van {{PLURAL:$1|een bewerking|$1 bewerkingen}} aan {{PLURAL:$1|een $2pagina|$2pagina's}}!",
	'achievements-badge-desc-picture' => "voor het toevoegen van {{PLURAL:$1|een afbeelding|$1 afbeeldingen}} aan {{PLURAL:$1|een pagina|pagina's}}!",
	'achievements-badge-desc-category' => "voor het toevoegen van {{PLURAL:$1|een pagina|$1 pagina's}} aan {{PLURAL:$1|een categorie|categorieën}}!",
	'achievements-badge-desc-blogpost' => 'voor het schrijven van {{PLURAL:$1|een blogbericht|$1 blogberichten}}!',
	'achievements-badge-desc-blogcomment' => 'voor het schrijven van een opmerking bij {{PLURAL:$1|een blogbericht|$1 verschillende blogberichten}}!',
	'achievements-badge-desc-love' => 'voor het iedere dag bijdragen aan de wiki gedurende {{PLURAL:$1|een dag|$1 dagen}}!',
	'achievements-badge-desc-welcome' => 'voor het deelnemen aan de wiki!',
	'achievements-badge-desc-introduction' => 'voor het aanmaken van uw eigen gebruikerspagina!',
	'achievements-badge-desc-sayhi' => 'voor het achterlaten van een bericht op de overlegpagina van een andere gebruiker!',
	'achievements-badge-desc-creator' => 'voor het oprichten van de wiki!',
	'achievements-badge-desc-pounce' => "voor het maken van bewerkingen aan 100 pagina's binnen een uur van het aanmaken van de pagina!",
	'achievements-badge-desc-caffeinated' => 'voor het maken van 100 bewerkingen op één dag.',
	'achievements-badge-desc-luckyedit' => 'voor het maken van de gelukkige bewerking nummer $1 op de wiki!',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'achievementsii-desc' => 'Et utmerkelsessystem for wikibrukere',
	'achievements-upload-error' => 'Beklager!
Det bilde fungerer ikke.
Sørg for at det er en .jpg- eller .png-fil.
Hvis det fremdeles ikke fungerer, er bildet muligens for stort.
Vennligst prøv et annet!',
	'achievements-upload-not-allowed' => 'Administratorer kan endre navn og bilde for utmerkelser ved å besøke [[Special:AchievementsCustomize|Tilpass utmerkelser]]-siden.',
	'achievements-non-existing-category' => 'Den angitte kategorien eksisterer ikke.',
	'achievements-edit-plus-category-track-exists' => 'Den angitte kategorien har allerede et <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Gå til sporet">tilknyttet spor</a>.',
	'achievements-no-stub-category' => 'Vennligst ikke lag spor for stubber.',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Gull',
	'achievements-silver' => 'Sølv',
	'achievements-bronze' => 'Bronse',
	'achievements-you-must' => 'Du må $1 for å motta denne utmerkelsen.',
	'leaderboard-button' => 'Toppliste over utmerkelser',
	'achievements-masthead-points' => '↓ $1 <small>{{PLURAL:$1|poeng|poeng}}</small>',
	'achievements-track-name-edit' => 'Redigeringsspor',
	'achievements-track-name-picture' => 'Bildespor',
	'achievements-track-name-category' => 'Kategorispor',
	'achievements-track-name-blogpost' => 'Blogginnleggsspor',
	'achievements-track-name-blogcomment' => 'Bloggkommentarspor',
	'achievements-track-name-love' => 'Wiki-kjærlighetsspor',
	'achievements-notification-title' => 'Godt jobba, $1!',
	'achievements-notification-subtitle' => 'Du mottok nettopp «$1»-utmerkelsen $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Trykk her for å se flere utmerkelser du kan oppnå]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|poeng|poeng}}',
	'achievements-points-with-break' => '1<br />{{PLURAL: $1|poeng|poeng}}',
	'achievements-earned' => 'Denne utmerkelsen har blitt tildelt {{PLURAL:$1|1 bruker|$1 brukere}}.',
	'achievements-profile-title' => '$1s $2 tildelte {{PLURAL:$2|utmerkelse|utmerkelser}}',
	'achievements-profile-title-no' => '$1s utmerkelser',
	'achievements-profile-title-challenges' => 'Flere utmerkelser du kan oppnå!',
	'achievements-profile-customize' => 'Tilpass utmerkelser >',
	'achievements-ranked' => 'Rangert #$1 på denne wikien',
	'achievements-no-badges' => 'Sjekk ut listen under for å se utmerkelsene du kan oppnå på denne wikien!',
	'achievements-viewall' => 'Vis alle',
	'achievements-viewless' => 'Lukk',
	'achievements-viewall-oasis' => 'Se alle',
	'leaderboard-intro' => "'''&laquo;Hva er utmerkelser?&rdquo;'''
Du kan motta spesielle utmerkelser ved å delta på denne wikien! 
Hver utmerkelse du oppnår gir poeng til den totale poengsummen sin:
Bronseutmerkelser er verdt 10 poeng, Sølvutmerkelser er verdt 50 poeng, og Gullutmerkelser er verdt 100 poeng.

Når du blir med i wikien, viser brukerprofilen din de utmerkelsene du har mottatt, og viser en liste over de utfordringene som er tilgjengelige for deg.
[[Special:MyPage|Gå til brukerprofilen din og sjekk det ut]]!",
	'leaderboard' => 'Toppliste over utmerkelser',
	'achievements-recent-earned-badges' => 'Nylig utdelte utmerkelser',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />ble tildelt <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'fikk utmerkelsen <strong><a href="$3" class="badgeName">$1</a></strong><br />$2',
	'achievements-leaderboard-disclaimer' => 'Topplisten viser endringer siden i går',
	'achievements-leaderboard-rank-label' => 'rangering',
	'achievements-leaderboard-member-label' => 'medlem',
	'achievements-leaderboard-points-label' => 'poeng',
	'achievements-send' => 'Lagre bilde',
	'achievements-save' => 'Lagre endringer',
	'achievements-reverted' => 'Utmerkelsen tilbakestilt til originalen.',
	'achievements-customize' => 'Tilpass bilde',
	'achievements-customize-new-category-track' => 'Lag nytt spor for kategori:',
	'achievements-enable-track' => 'slått på',
	'achievements-revert' => 'Tilbakestill til standard',
	'achievements-special-saved' => 'Endringer lagret.',
	'achievements-special' => 'Spesialutmerkelser',
	'achievements-secret' => 'Hemmelige utmerkelser',
	'achievementscustomize' => 'Tilpass utmerkelser',
	'achievements-about-title' => 'Om denne siden...',
	'achievements-about-content' => 'Administratorer på denne wikien kan tilpasse navn og bilde for utmerkelsene.

Du kan laste opp ethvert .jpg- eller .png-bilde, og bildet vil automatisk passe inn i rammen.
Det fungerer best når bildet er kvadratisk, og når den viktigste delene av bildet er i midten.

Du kan bruke rektangulære bilder, men vil kanskje oppleve at biter vil bli fjernet av rammen. 
Hvis du har et grafikkprogram, kan du beskjære bildet for å plassere den viktigste delen av bildet i midten.
Hvis du ikke har det, kan du eksperimentere med forskjellige bilder til du finner det som passer deg best!
Hvis du ikke liker bildet du har valgt, trykker du «{{int:achievements-revert}}» for å gå tilbake til den ordinære grafikken.

Du kan også gi utmerkelsene nye navn som reflekterer wikiens tema. Når du har endret navn for utmerkelser, trykker du «{{int:achievements-save}}» for å lagre endringene. Ha det gøy!',
	'achievements-edit-plus-category-track-name' => '$1 rediger spor',
	'achievements-create-edit-plus-category-title' => 'Opprett et nytt Rediger spor',
	'achievements-create-edit-plus-category-content' => 'Du kan opprette et nytt sett utmerkelser som belønner brukere for å redigere sider i en bestemt kategori, for å markere et bestemt område av siden brukerne vil sette pris på.
Du kan sette opp fler enn et kategorispor, så prøv å velge to kategorier som lar brukerne vise frem sine spesialiteter!
Sett i gang en rivalisering mellom brukerne som redigerer vampyrsider og brukerne som redigerer varulvsider, eller trollmenn og gomper, eller Autoboter og Decepticoner.

For å lage et nytt «Rediger-i-kategori»-spor, skriv inn navnet på kategorien i feltet nedenfor.
Den vanlige Rediger spor vil fremdeles eksistere; dette vil opprette et separat spor som du kan tilpasse separat.

Når sporet er opprettet, vil den nye utmerkelsen vises i lista til venstre, under den vanlige Rediger spor.
Tilpass navnene og bildene for det nye sporet, slik at brukerne kan se forskjellen!

Så fort du er ferdig med tilpasningen, trykk på «{{int:achievements-enable-track}}»-boksen for å skru på det nye sporet, og trykk deretter «{{int:achievements-save}}».
Brukere vil se det nye sporet på brukerprofilene sine, og du vil begynne å motta utmerkelser når de redigerer sider i den kategorien.
Du kan også skru av sporet senere, hvis du beslutter at du ikke vil markere kategorien lenger.
Brukere som har mottatt utmerkelser i det sporet vil alltid beholde utmerkelsene, selv om sporet er deaktivert.

Dette kan skape et helt nytt nivå av moro for utmerkelsene.
Prøv det ut!',
	'achievements-create-edit-plus-category' => 'Opprett dette sporet',
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
	'achievements-badge-name-category-0' => 'Opprett en sammenheng',
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
	'achievements-badge-name-love-0' => 'Nøkkel til wikien!',
	'achievements-badge-name-love-1' => 'To uker på wikien',
	'achievements-badge-name-love-2' => 'Engasjert',
	'achievements-badge-name-love-3' => 'Dedikert',
	'achievements-badge-name-love-4' => 'Avhengig',
	'achievements-badge-name-love-5' => 'Et wiki-liv',
	'achievements-badge-name-love-6' => 'Wiki-helt!',
	'achievements-badge-name-welcome' => 'Velkommen til wikien',
	'achievements-badge-name-introduction' => 'Introduksjon',
	'achievements-badge-name-sayhi' => 'Stopper for å si hei',
	'achievements-badge-name-creator' => 'Skaperen',
	'achievements-badge-name-pounce' => 'Angrip!',
	'achievements-badge-name-caffeinated' => 'Koffeinholdig',
	'achievements-badge-name-luckyedit' => 'Heldig redigering',
	'achievements-badge-to-get-edit' => 'foreta $1 {{PLURAL:$1|redigering|redigeringer}} på {{PLURAL:$1|en side|sider}}',
	'achievements-badge-to-get-edit-plus-category' => 'foreta $1 {{PLURAL:$1|redigering|redigeringer}} på {{PLURAL:$1|en|}} $2-{{PLURAL:$1|side|sider}}',
	'achievements-badge-to-get-picture' => 'legge $1 {{PLURAL:$1|bilde|bilder}} til {{PLURAL:$1|en side|sider}}',
	'achievements-badge-to-get-category' => 'legge $1 {{PLURAL:$1|side|sider}} til {{PLURAL:$1|en kategori|kategorier}}',
	'achievements-badge-to-get-blogpost' => 'skrive $1 {{PLURAL:$1|blogginnlegg|blogginnlegg}}',
	'achievements-badge-to-get-blogcomment' => 'skrive en kommentar på $1 forskjellige blogginnlegg',
	'achievements-badge-to-get-love' => 'bidra til wikien hver dag i $1 dager',
	'achievements-badge-to-get-welcome' => 'bli med i wikien',
	'achievements-badge-to-get-introduction' => 'legge til på din egen brukerside',
	'achievements-badge-to-get-sayhi' => 'legge igjen en beskjed på noens diskusjonsside',
	'achievements-badge-to-get-creator' => 'vær grunnleggeren av denne wikien',
	'achievements-badge-to-get-pounce' => 'vær rask',
	'achievements-badge-to-get-caffeinated' => 'foreta $1 redigeringer på sider på én dag',
	'achievements-badge-to-get-luckyedit' => 'vær heldig',
	'achievements-badge-to-get-edit-details' => 'Mangler noe? Er det en feil?
Ikke vær sjenert.
Trykk på «{{int:edit}}»-knappen og du kan legge til noe på enhver side!',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong>-sidene trenger din hjelp! Trykk på «{{int:edit}}»-knappen på enhver side i denne kategorien for å hjelpe til. Vis din støtte for de $1 sidene!',
	'achievements-badge-to-get-picture-details' => 'Trykk på «{{int:edit}}»-knappen, og så trykk på «{{int:rte-ck-image-add}}»-knappen. Du kan legge til et bilde fra datamaskinen din, eller fra en annen side på wikien.',
	'achievements-badge-to-get-category-details' => 'Kategorier er navnelapper som hjelper leserne å finne lignende sider.
Trykk på «{{int:categoryselect-addcategory-button}}»-knappen på bunnen av en side for å legge den til en kategori.',
	'achievements-badge-to-get-blogpost-details' => 'Skriv dine meninger og spørsmål!
Trykk på «{{int:blogs-recent-url-text}}» i sidepanelet, og så lenken til venstre for Opprett et nytt «{{int:create-blog-post-title}}».',
	'achievements-badge-to-get-blogcomment-details' => 'Legg til din mening! Les et hvilken som helst av de siste blogginnleggene, og skriv dine tanker i kommentarfeltet.',
	'achievements-badge-to-get-love-details' => 'Telleren tilbakestilles hvis du går glipp av en dag, så sørg for å komme tilbake til wikien hver dag!',
	'achievements-badge-to-get-welcome-details' => 'Trykk på «{{int:autocreatewiki-create-account}}»-knappen øverst til høyre for å bli med i fellesskapet.
Du kan begynne å motta egne utmerkelser!',
	'achievements-badge-to-get-introduction-details' => 'Er brukersiden din tom? Trykk på brukernavnet ditt på toppen av skjermen for å sjekke.
Trykk «{{int:edit}}» for å legge til litt informasjon om deg selv!',
	'achievements-badge-to-get-sayhi-details' => 'Du kan legge igjen beskjeder til andre brukere ved å trykke «{{int:tooltip-ca-addsection}}» på diskusjonssiden deres. Spør etter hjelp, takk dem for arbeidet deres, eller bare si hei!',
	'achievements-badge-to-get-creator-details' => 'Denne utmerkelsen er gitt til personen som grunnla wikien.
Trykk på «{{int:createwiki}}»-knappen øverst for å starte et nettsted om det du liker best!',
	'achievements-badge-to-get-pounce-details' => 'Du må være rask for å motta denne utmerkelsen.
Trykk på «{{int:activityfeed}}»-knappen for å se nye sider som brukere oppretter!',
	'achievements-badge-to-get-caffeinated-details' => 'Det krever en travel dag for å oppnå denne utmerkelsen. Fortsett å redigere!',
	'achievements-badge-to-get-luckyedit-details' => 'Du må være heldig for å oppnå denne utmerkelsen. Fortsett å redigere!',
	'achievements-badge-to-get-community-platinum-details' => 'Dette er en spesiell Platinautmerkelse som kun er tilgjengelig i en begrenset periode!',
	'achievements-badge-hover-desc-edit' => 'for å gjøre $1 {{PLURAL:$1|redigering|redigeringer}}<br />
på {{PLURAL:$1|en side|sider}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'for å gjøre $1 {{PLURAL:$1|redigering|redigeringer}}<br />
på {{PLURAL:$1|en|}} $2 {{PLURAL:$1|side| sider}}!',
	'achievements-badge-hover-desc-picture' => 'for å legge $1 {{PLURAL:$1|bilde|bilder}}<br />
til {{PLURAL:$1|en side|sider}}!',
	'achievements-badge-hover-desc-category' => 'for å legge $1 {{PLURAL:$1|side|sider}}<br />
til {{PLURAL:$1|en kategori|kategorier}}!',
	'achievements-badge-hover-desc-blogpost' => 'for å skrive $1 {{PLURAL:$1|blogginnlegg|blogginnlegg}}!',
	'achievements-badge-hover-desc-blogcomment' => 'for å skrive en kommentar<br />
på $1 forskjellige {{PLURAL:$1|blogginnlegg|blogginnlegg}}!',
	'achievements-badge-hover-desc-love' => 'for å bidra til wikien hver dag i $1 dager!',
	'achievements-badge-hover-desc-welcome' => 'for å bli med i wikien!',
	'achievements-badge-hover-desc-introduction' => 'for å legge til<br />
på din egen brukerside!',
	'achievements-badge-hover-desc-sayhi' => 'for å legge igjen en beskjed<br />
på noen andres diskusjonsside!',
	'achievements-badge-hover-desc-creator' => 'for å opprette wikien!',
	'achievements-badge-hover-desc-pounce' => 'for å redigere 100 sider i løpet av en time etter at siden ble opprettet!',
	'achievements-badge-hover-desc-caffeinated' => 'for å gjøre 100 redigeringer på sider på én dag!',
	'achievements-badge-hover-desc-luckyedit' => 'for å gjøre den heldige $1. redigeringen på wikien!',
	'achievements-badge-hover-desc-community-platinum' => 'Dette er en spesiell Platinautmerkelse som kun er tilgjengelig i en begrenset tidsperiode!',
	'achievements-badge-your-desc-edit' => 'for å gjøre {{PLURAL:$1|din første|$1}} {{PLURAL:$1|redigering|redigeringer}} på {{PLURAL:$1|en side|sider}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'for å gjøre {{PLURAL:$1|din første|$1}} {{PLURAL:$1|redigering|redigeringer}} på {{PLURAL:$1|en|}} $2-{{PLURAL:$1|side|sider}}!',
	'achievements-badge-your-desc-picture' => 'for å legge {{PLURAL:$1|ditt første|$1}} {{PLURAL:$1|bilde|bilder}} til {{PLURAL:$1|en side|sider}}!',
	'achievements-badge-your-desc-category' => 'for å legge {{PLURAL:$1|din første|$1}} {{PLURAL:$1|side|sider}} til {{PLURAL:$1|en kategori|kategorier}}!',
	'achievements-badge-your-desc-blogpost' => 'for å skrive {{PLURAL:$1|ditt første|$1}} {{PLURAL:$1|blogginnlegg|blogginnlegg}}!',
	'achievements-badge-your-desc-blogcomment' => 'for å skrive en kommentar på $1 forskjellige blogginnlegg!',
	'achievements-badge-your-desc-love' => 'for å bidra til wikien hver dag i $1 dager!',
	'achievements-badge-your-desc-welcome' => 'for å bli med i wikien!',
	'achievements-badge-your-desc-introduction' => 'for å legge til på din egen brukerside!',
	'achievements-badge-your-desc-sayhi' => 'for å legge igjen en beskjed på noen andres diskusjonsside!',
	'achievements-badge-your-desc-creator' => 'for å opprette wikien!',
	'achievements-badge-your-desc-pounce' => 'for å gjøre redigeringer på 100 sider i løpet av en time etter at siden ble opprettet!',
	'achievements-badge-your-desc-caffeinated' => 'for å gjøre 100 redigeringer på sider på én dag!',
	'achievements-badge-your-desc-luckyedit' => 'for å gjøre den heldige $1. redigeringen på wikien!',
	'achievements-badge-desc-edit' => 'for å gjøre $1 {{PLURAL:$1|redigering|redigeringer}} på {{PLURAL:$1|en side|sider}}!',
	'achievements-badge-desc-edit-plus-category' => 'for å gjøre $1 {{PLURAL:$1|redigering|redingeringer}} på {{PLURAL:$1|en|}} $2 {{PLURAL:$1|side| sider}}!',
	'achievements-badge-desc-picture' => 'for å legge $1 {{PLURAL:$1|bilde|bilder}} til {{PLURAL:$1|en side|sider}}!',
	'achievements-badge-desc-category' => 'for å legge $1 {{PLURAL:$1|side|sider}} til {{PLURAL:$1|en kategori|kategorier}}!',
	'achievements-badge-desc-blogpost' => 'for å skrive $1 {{PLURAL:$1|blogginnlegg|blogginnlegg}}!',
	'achievements-badge-desc-blogcomment' => 'for å skrive en kommentar på {{PLURAL:$1|et blogginnlegg|$1 forskjellige blogginnlegg}}!',
	'achievements-badge-desc-love' => 'for å bidra på wikien hver dag i {{PLURAL:$1|én dag|$1 dager}}!',
	'achievements-badge-desc-welcome' => 'for å bli med i wikien!',
	'achievements-badge-desc-introduction' => 'for å legge til på din egen brukerside!',
	'achievements-badge-desc-sayhi' => 'for å legge igjen en beskjed på noen andres diskusjonsside!',
	'achievements-badge-desc-creator' => 'for å opprette wikien!',
	'achievements-badge-desc-pounce' => 'for å redigere 100 sider i løpet av en time etter at siden ble opprettet!',
	'achievements-badge-desc-caffeinated' => 'for å gjøre 100 redigeringer på sider på én dag!',
	'achievements-badge-desc-luckyedit' => 'for å gjøre den heldige $1. redigeringen på wikien!',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'achievementsii-desc' => "Un sistema ëd distintiv dle realisassion për j'utent ëd la wiki",
	'achievements-upload-error' => "Spiasent!
Sta figura a travaja pa.
Sigurte ch'a sia un file .jpg o .png.
Se a travaja anco' pa, antlora la figura a peul esse tròp gròssa.
Për piasì preuva con n'àutra!",
	'achievements-upload-not-allowed' => "J'aministrador a peulo cangé ij nòm e le figure dij distintiv ëd Ragiungiment an visitand la pàgina [[Special:AchievementsCustomize|Përsonalisa Ragiungiment]].",
	'achievements-non-existing-category' => 'La categorìa specificà a esist pa.',
	'achievements-edit-plus-category-track-exists' => 'La categorìa specificà a l\'ha già na <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">trassa associà</a>.',
	'achievements-no-stub-category' => 'Për piasì crea pa trasse për jë sbòss.',
	'achievements-platinum' => 'Plàtin',
	'achievements-gold' => 'Òr',
	'achievements-silver' => 'Argent',
	'achievements-bronze' => 'Bronz',
	'achievements-you-must' => 'It deuve rivé a $1 për vagné sto distintiv.',
	'leaderboard-button' => 'Leaderbord dij Ragiungiment',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|pont|pont}}</small>',
	'achievements-track-name-edit' => 'Trassa dle modìfiche',
	'achievements-track-name-picture' => 'Trassa dle figure',
	'achievements-track-name-category' => 'Trassa dle categorìe',
	'achievements-track-name-blogpost' => 'Trassa dij Blog Post',
	'achievements-track-name-blogcomment' => 'Trassa dij Coment ëd Blog',
	'achievements-track-name-love' => 'Trassa ëd Wiki Love',
	'achievements-notification-title' => "Manera d'andé, $1!",
	'achievements-notification-subtitle' => 'It l\'has mach vagnà ël distintiv "$1" $2',
	'achievements-notification-link' => "<strong><big>[[Special:MyPage|Varda ij distintiv ch'it peule anco' vagné]]!</big></strong>",
	'achievements-points' => '$1 {{PLURAL:$1|pont|pont}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|pont|pont}}',
	'achievements-earned' => "Sto distintiv a l'é stàit vagnà da {{PLURAL:$1|1 utent|$1 utent}}.",
	'achievements-profile-title' => '$2 {{PLURAL:$2|distintiv|distintiv}} vagnà da $1',
	'achievements-profile-title-no' => 'distintiv ëd $1',
	'achievements-profile-title-challenges' => "Distintiv ch'it peule anco' vagné!",
	'achievements-profile-customize' => 'Përsonalisa distintiv >',
	'achievements-ranked' => 'Classìfica $1 su sta wiki',
	'achievements-no-badges' => "Contròla la lista sota për vëdde ij distintiv ch'it peule anco' vagné su sta wiki!",
	'achievements-viewall' => 'Varda tut',
	'achievements-viewless' => 'Sara',
	'achievements-profile-title-oasis' => 'ragiungiment <br /> pont',
	'achievements-ranked-oasis' => "$1 a l'é [[Special:Leaderboard|Ranked #$2]] su sta wiki",
	'achievements-viewall-oasis' => 'Varda tut',
	'leaderboard-intro' => "'''&ldquo;Lòn ch'a son ij Ragiungiment?&rdquo;'''
It peule vagné dij distintiv speciaj an partessipand a sta wiki!
Minca distintiv ch'it vagne a gionta dij pont a tò pontegi total:
Distintiv ëd Brons a valo 10 pont, distintiv d'Argent a valo 50 pont, e distintiv d'Òr a valo 100 pont.

Quand it intre ant la wiki, tò profil utent a visualisa ij distintiv ch'it l'has vagnà, e at mosta na lista dle sfide ch'a son disponìbij për ti.
[[Special:MyPage|va a tò profil utent për controlelo]]!",
	'leaderboard' => 'Leaderbord dij Ragiungiment',
	'achievements-recent-earned-badges' => 'Distintiv vagnà recentemenmt',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />vagnà da <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'vagnà ël <strong><a href="$3" class="badgeName">$1</a></strong> distintiv<br />$2',
	'achievements-leaderboard-disclaimer' => 'Leaderboard a mosta ij cambi da ier',
	'achievements-leaderboard-rank-label' => 'antërval',
	'achievements-leaderboard-member-label' => 'mèmber',
	'achievements-leaderboard-points-label' => 'pont',
	'achievements-send' => 'Salva figura',
	'achievements-save' => 'Salvé ij cangiament',
	'achievements-reverted' => "Distintiv tornà a l'original",
	'achievements-customize' => 'Përsonalisa figura',
	'achievements-customize-new-category-track' => 'Crea na trassa neuva për la categorìa:',
	'achievements-enable-track' => 'abilità',
	'achievements-revert' => 'Torna al default',
	'achievements-special-saved' => 'Cambi salvà.',
	'achievements-special' => 'Ragiungiment speciaj',
	'achievements-secret' => 'Ragiungiment segret',
	'achievementscustomize' => 'Përsonalisa distintiv',
	'achievements-about-title' => 'A propòsit dë sta pàgina...',
	'achievements-about-content' => "J'aministrador su sta wiki a peulo përsonalisé ij nòm e le figure dij distintiv dij ragiungiment.

It peule carié minca figura .jpg o .png, e toa figura a intrerà automaticament an drinta a la fnesta.
A travaja mej quand che toa figura a l'é quadra, e quand che la part pi amportanta dla figura a l'é pròpi ant ël mes.

It peule dovré figure retangolar, ma it podrìe trové che un pòch a ven tajà fòra dla fnesta.
S'it l'has un program gràfich, it peule ritajé toa figura për buté la part pi amportanta dla figura ant ël mes.
S'it l'has pa un program gràfich, antlora preuva pura con figure diferente fin che it treuve cola ch'a va për ti!
S'at pias pa la figura ch'it l'has sërnù, sgnaca \"{{int:achievements-revert}}\" për andé andré al gràfich original.

It peule ëdcò deje ai distintiv dij nòm neuv che a arfleto l'argoment ëd la wiki.
Quand it l'has cangià ij nòm dij distintiv, sgnaca \"{{int:achievements-save}}\" për salvé ij tò cambi.
Bon divertiment!",
	'achievements-edit-plus-category-track-name' => '$1 trassa ëd modìfiche',
	'achievements-create-edit-plus-category-title' => 'Crea na trassa ëd modìfica neuva',
	'achievements-create-edit-plus-category-content' => "It peule trové un neuv ansema ëd distintiv che a premio j'utent ch'a modìfico pàgine ant na particolar categorìa, për a anluminé n'aira particolar dël sit dont a j'utent a podrìa piasije travajé an dzora.
It peule amposté pi che na trassa ëd categorìa, parèj preuva a serne doe categorìe ch'a podrìo gioté j'utent a mosté soe specialisassion!
Anvisca na rivalità tra j'utent ch'a modìfico le pàgine dij Vàmpir e j'utent ch'a modìfico le pàgine dij Werewolves, o Magh e Muggles, o Autobot e Decepticon.

Për creé na neuva trassa \"Modìfica ant la categorìa\", ansëriss ël nòm dla categorìa ant ël camp sota.
La trassa ëd Modìfica regolar a esisterà anco';
sossì a creerà na trassa separà ch'it peule përsonalisé separatament.

Quand la trassa a l'é creà, ij distintiv neuv a apariran ant la lista an sla snista, sota la trassa regolar ëd Modìfica.
Përsonalisa nòm e figure për la trassa neuva, an manera che j'utet a peusso vëdde la diferensa!

Na vira ch'it l'has fàit la përsonalisassion, sgnaca la checkbox \"{{int:achievements-enable-track}}\" për rende ativa la trassa neuva, e peui sgnaca \"{{int:achievements-save}}\".
J'utent a vëddran che la trassa neuva a apariss an sò profil utent, e a ancamineran a vagné dij distintiv quand che a modìfico dle pàgine an cola categorìa.
It peule ëdcò disabilité la trassa pi tard, s'it decide ch'it veule pa anluminé cola categorìa an gnun cas.
J'utent ch'a l'han vagnà dij distintiv ant la trassa a manteniran sempe ij sò distintiv, ëdcò se la trassa a l'é disabilità.

Sossì a peul gioté a rivé a n'àutr livel ëd divertiment për ij ragiungiment.
Preuvlo!",
	'achievements-create-edit-plus-category' => 'Crea sta trassa',
	'platinum' => 'Plàtin',
	'achievements-community-platinum-awarded-email-subject' => 'It ses stàit premià con un distintiv Plàtin neuv!',
	'achievements-community-platinum-awarded-email-body-text' => "Congratulassin $1!

It ses pen-e stàit premià con ël distintiv Plàtin '$2' su $4 ($3).
Sossì a gionta 250 pont a tò pontegi!

Contròla tò fantàstich distintiv neuv an sla pàgina ëd tò profil utent:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Congratulassion $1!</strong><br /><br />
It ses pen-e stàit premià con ël \'<strong>$2</strong>\' distintiv ëd Plàtin su <a href="$3">$4</a>.
Sossì a gionta 250 pont a tò pontegi!<br /><br />
Contròla tò fantàstich distintiv neuv ans toa <a href="$5">pàgina dël profil utent</a>.',
	'achievements-community-platinum-awarded-for' => 'Premià për:',
	'achievements-community-platinum-how-to-earn' => 'Com vagné:',
	'achievements-community-platinum-awarded-for-example' => 'p.e. "për fé..."',
	'achievements-community-platinum-how-to-earn-example' => 'p.e. "fà 3 modìfiche..."',
	'achievements-community-platinum-badge-image' => 'Figura dël distintiv:',
	'achievements-community-platinum-awarded-to' => 'Premià a:',
	'achievements-community-platinum-current-badges' => 'Distintiv corent ëd plàtin',
	'achievements-community-platinum-create-badge' => 'Crea distintiv',
	'achievements-community-platinum-enabled' => 'abilità',
	'achievements-community-platinum-show-recents' => 'mosta ant ij distintiv recent',
	'achievements-community-platinum-edit' => 'modìfica',
	'achievements-community-platinum-save' => 'salva',
	'achievements-badge-name-edit-0' => 'Fé na diferensa',
	'achievements-badge-name-edit-1' => "Mach l'Inissi",
	'achievements-badge-name-edit-2' => 'Fà Toa Marca',
	'achievements-badge-name-edit-3' => 'Amis ëd la Wiki',
	'achievements-badge-name-edit-4' => 'Colaborador',
	'achievements-badge-name-edit-5' => 'Costrudor ëd Wiki',
	'achievements-badge-name-edit-6' => 'Leader ëd Wiki',
	'achievements-badge-name-edit-7' => 'Espert ëd Wiki',
	'achievements-badge-name-picture-0' => 'Fotografìa',
	'achievements-badge-name-picture-1' => 'Paparass',
	'achievements-badge-name-picture-2' => 'Ilustrador',
	'achievements-badge-name-picture-3' => 'Coletor',
	'achievements-badge-name-picture-4' => "Amant ëd l'Art",
	'achievements-badge-name-picture-5' => 'Decorador',
	'achievements-badge-name-picture-6' => 'Disegnador',
	'achievements-badge-name-picture-7' => 'Curador',
	'achievements-badge-name-category-0' => 'Fà na Conession',
	'achievements-badge-name-category-1' => 'Scopridor dël Senté',
	'achievements-badge-name-category-2' => 'Esplorador',
	'achievements-badge-name-category-3' => 'Guida dël Gir',
	'achievements-badge-name-category-4' => 'Navigador',
	'achievements-badge-name-category-5' => 'Costrutor ëd Pont',
	'achievements-badge-name-category-6' => 'Pianificador ëd Wiki',
	'achievements-badge-name-blogpost-0' => 'Quaicòs da dì',
	'achievements-badge-name-blogpost-1' => 'Sinch Ròbe da dì',
	'achievements-badge-name-blogpost-2' => 'Talk Show',
	'achievements-badge-name-blogpost-3' => 'Vita dël partì',
	'achievements-badge-name-blogpost-4' => 'Parlador Pùblich',
	'achievements-badge-name-blogcomment-0' => 'Opinionista',
	'achievements-badge-name-blogcomment-1' => "E na ròba anco'",
	'achievements-badge-name-love-0' => 'Ciav për la Wiki!',
	'achievements-badge-name-love-1' => 'Doe sman-e an sla wiki',
	'achievements-badge-name-love-2' => 'Dëvòt',
	'achievements-badge-name-love-3' => 'Dicà',
	'achievements-badge-name-love-4' => 'Giontà',
	'achievements-badge-name-love-5' => 'Na vita ëd Wiki',
	'achievements-badge-name-love-6' => 'Eròe dla Wiki',
	'achievements-badge-name-welcome' => 'Bin ëvnù a la Wiki',
	'achievements-badge-name-introduction' => 'Antrodussion',
	'achievements-badge-name-sayhi' => 'Finì ëd dì cerea',
	'achievements-badge-name-creator' => 'Ël Creador',
	'achievements-badge-name-pounce' => 'Brinca!',
	'achievements-badge-name-caffeinated' => 'Cafeinà',
	'achievements-badge-name-luckyedit' => 'Modìfica fortunà',
	'achievements-badge-to-get-edit' => 'fà $1 {{PLURAL:$1|modìfica|modìfiche}} su {{PLURAL:$1|na pàgina|pàgine}}',
	'achievements-badge-to-get-edit-plus-category' => 'fà $1 {{PLURAL:$1|na modìfica|$1 modìfiche}} su {{PLURAL:$1|na $2 pàgina|$2 pàgine}}',
	'achievements-badge-to-get-picture' => 'gionta $1 {{PLURAL:$1|figuraa|figuree}} a {{PLURAL:$1|na pàgina|pàgine}}',
	'achievements-badge-to-get-category' => 'gionta $1 {{PLURAL:$1|pàgina|pàgine}} a {{PLURAL:$1|na categorìa|categorìe}}',
	'achievements-badge-to-get-blogpost' => 'scriv $1 {{PLURAL:$1|mëssagi ëd blog|mëssagi ëd blog}}',
	'achievements-badge-to-get-blogcomment' => 'scriv un coment su {{PLURAL:$1|un mëssagi ëd blog|$1 diferent mëssagi ëd blog}}',
	'achievements-badge-to-get-love' => 'contribuiss a la wiki minca di për {{PLURAL:$1|un di|$1 di}}',
	'achievements-badge-to-get-welcome' => 'unisste a la wiki',
	'achievements-badge-to-get-introduction' => 'gionta a toa pàgina utent',
	'achievements-badge-to-get-sayhi' => 'lassa a quaidun un mëssagi su soa pàgina ëd discussion',
	'achievements-badge-to-get-creator' => 'esse ël creador dë sta wiki',
	'achievements-badge-to-get-pounce' => 'esse lest',
	'achievements-badge-to-get-caffeinated' => 'fé {{PLURAL:$1|na modìfica|$1 modìfiche}} su pàgine ant un ùnich di',
	'achievements-badge-to-get-luckyedit' => 'esse fortunà',
	'achievements-badge-to-get-edit-details' => 'A-i manca quaicòs?
A-i é n\'eror?
Esse pa tìmid.
Sgnaca ël boton "{{int:edit}}" e it peulo gionté a minca pàgina!',
	'achievements-badge-to-get-edit-plus-category-details' => 'La pàgina <strong>$1</strong> a l\'ha dabzògn ëd tò agiut!
Sgnaca ël boton "{{int:edit}}" su minca pàgina an cola categorìa për giuté.
Mosta tò supòrt për la pàgina $1!',
	'achievements-badge-to-get-picture-details' => 'Sgnaca ël boton "{{int:edit}}", e antlora ël boton "{{int:rte-ck-image-add}}".
It peule gionté na fòto da tò computer, o da n\'àutra pàgina an sla wiki.',
	'achievements-badge-to-get-category-details' => 'Le categorìe a son tichëtte che a giuto ij letor a trové pàgine smijante.
Sgnaca ël boton "{{int:categoryselect-addcategory-button}}" a la sima dla pàgina për listé cola pàgina ant na categorìa.',
	'achievements-badge-to-get-blogpost-details' => 'Scriv toe opinion e custion!
Sgnaca su "{{int:blogs-recent-url-text}}" ant la bara lateral, e peui ël colegament an sla snista për "{{int:create-blog-post-title}}".',
	'achievements-badge-to-get-blogcomment-details' => 'Gionta i toi doi cent!
Les tùit ij mëssagi recent dël blog, e scriv ij tò pensé ant la box dij coment.',
	'achievements-badge-to-get-love-details' => "Ël conteur a part da zero s'it perde un di, parèj sigurte ëd torné a la wiki minca di!",
	'achievements-badge-to-get-welcome-details' => 'Sgnaca ël boton "{{int:autocreatewiki-create-account}}" an sima an sla drita për unite a la comunità.
It peule ancaminé a vagné ij tò distintiv!',
	'achievements-badge-to-get-introduction-details' => 'Toa pàgina utent a l\'é veuida?
Sgnaca su tò nòm utent a la sima dlë scherm për vëdde.
Sgnaca "{{int:edit}}" për gionté quaich anformassion dzora ëd ti!',
	'achievements-badge-to-get-sayhi-details' => 'It peule lassé dij mëssagi a j\'àutri utent an sgnacand "{{int:tooltip-ca-addsection}}" ans la soa pàgina utent.
Ciama agiut, ringrassje për sò travaj, o salutje mach!',
	'achievements-badge-to-get-creator-details' => "Sto distintiv a l'é dàit a la përson-a che a l'ha fondà la wiki.
Sgnaca ël boton \"{{int:createwiki}}\" a la sima për ancaminé un sit a propòsit ëd lòn ch'at pias ëd pi!",
	'achievements-badge-to-get-pounce-details' => "It deuve esse lest për vagné sto distintiv.
Sgnaca ël boton  për vëdde le pàgine neuve che j'utent a creo!",
	'achievements-badge-to-get-caffeinated-details' => 'A-i va un di complet për vagné sto distintiv.
Continua a modifiché!',
	'achievements-badge-to-get-luckyedit-details' => 'It deuve esse fortunà për vagné sto distitiv.
Continua a modifiché!',
	'achievements-badge-to-get-community-platinum-details' => "Sossì a l'é un distintiv special ëd Plàtin che a l'é mach disponìbil për un temp limità!",
	'achievements-badge-hover-desc-edit' => 'për fé $1 {{PLURAL:$1|modìfica|modìfiche}}<br />
su {{PLURAL:$1|na pàgina|pàgine}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'për fé $1 {{PLURAL:$1|modìfica|modìfiche}}<br />
su {{PLURAL:$1|na pàgina ëd $2|pàgine ëd $2}}!',
	'achievements-badge-hover-desc-picture' => 'për gionté $1 {{PLURAL:$1|figura|figure}}<br />
su {{PLURAL:$1|na pàgina|pàgine}}!',
	'achievements-badge-hover-desc-category' => 'për gionté $1 {{PLURAL:$1|pàgina|pàgine}}<br />
a {{PLURAL:$1|na categorìa|categorìe}}!',
	'achievements-badge-hover-desc-blogpost' => 'për scrive $1 {{PLURAL:$1|mëssagi ëd blog|mëssagi ëd blog}}!',
	'achievements-badge-hover-desc-blogcomment' => 'për scrive un coment<br />
su $1 diferent {{PLURAL:$1|mëssagi ëd blog|mëssagi ëd blog}}!',
	'achievements-badge-hover-desc-love' => 'për contribuì a la wiki minca di për {{PLURAL:$1|un di|$1 di}}!',
	'achievements-badge-hover-desc-welcome' => 'për unite a la wiki!',
	'achievements-badge-hover-desc-introduction' => 'për gionté a<br />
toa pàgina utent!',
	'achievements-badge-hover-desc-sayhi' => 'për lassé un mëssagi<br />
an sla pàgina ëd discussion ëd quaidun!',
	'achievements-badge-hover-desc-creator' => 'për creé la wiki!',
	'achievements-badge-hover-desc-pounce' => "Për fé modìfiche su 100 pàgine ant n'ora da la creassion dla pàgina!",
	'achievements-badge-hover-desc-caffeinated' => 'për fé 100 modìfiche su pàgine ant un sol di!',
	'achievements-badge-hover-desc-luckyedit' => 'për fé la $1a Modìfica Fortunà an sla wiki!',
	'achievements-badge-hover-desc-community-platinum' => "Sossì a l'é un distintiv special ëd Plàtin che a l'é mach disponìbil për un temp limità!",
	'achievements-badge-your-desc-edit' => 'për fé {{PLURAL:$1|toa prima modìfica|$1 modìfiche}} su {{PLURAL:$1|na pàgina|pàgine}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'për fé {{PLURAL:$1|toa prima modìfica|$1 modìfiche}} su {{PLURAL:$1|na pàgina ëd $2|pàgine ëd $2}}!',
	'achievements-badge-your-desc-picture' => 'për gionté {{PLURAL:$1|toa prima figura|$1 figure}} su {{PLURAL:$1|na pàgina|pàgine}}!',
	'achievements-badge-your-desc-category' => 'për gionté {{PLURAL:$1|toa prima pàgina|$1 pàgine}} su {{PLURAL:$1|na categorìa|categorìe}}!',
	'achievements-badge-your-desc-blogpost' => 'për scrive {{PLURAL:$1|tò prim mëssagi ëd blog|$1 mëssagi ëd blog}}!',
	'achievements-badge-your-desc-blogcomment' => 'për scrive un coment su {{PLURAL:$1|un mëssagi ëd blog|$1 diferent mëssagi ëd blog}}!',
	'achievements-badge-your-desc-love' => 'për contribuì a la wiki minca di për {{PLURAL:$1|un di|$1 di}}!',
	'achievements-badge-your-desc-welcome' => 'për unite a la wiki!',
	'achievements-badge-your-desc-introduction' => 'për gionté a toa pàgina utent!',
	'achievements-badge-your-desc-sayhi' => 'për lassé un mëssagi an sla pàgina ëd discussion ëd quaidun!',
	'achievements-badge-your-desc-creator' => 'për creé la wiki!',
	'achievements-badge-your-desc-pounce' => "Për fé modìfiche su 100 pàgine ant n'ora da la creassion dla pàgina!",
	'achievements-badge-your-desc-caffeinated' => 'për fé 100 modìfiche su pàgine ant un sol di!',
	'achievements-badge-your-desc-luckyedit' => 'për fé la $1a modìfica Fortunà an sla wiki!',
	'achievements-badge-desc-edit' => 'për fé $1 {{PLURAL:$1|modìfica|modìfiche}} su {{PLURAL:$1|na pàgina|pàgine}}!',
	'achievements-badge-desc-edit-plus-category' => 'për fé $1 {{PLURAL:$1|modìfica|modìfiche}} su {{PLURAL:$1|na pàgina ëd $2|pàgine ëd $2}}!',
	'achievements-badge-desc-picture' => 'për gionté $1 {{PLURAL:$1|figura|figure}} su {{PLURAL:$1|na pàgina|pàgine}}!',
	'achievements-badge-desc-category' => 'për gionté $1 {{PLURAL:$1|pàgina|pàgine}} a {{PLURAL:$1|na categorìa|categorìe}}!',
	'achievements-badge-desc-blogpost' => 'për scrive $1 {{PLURAL:$1|mëssagi ëd blog|mëssagi ëd blog}}!',
	'achievements-badge-desc-blogcomment' => 'për scrive un coment su {{PLURAL:$1|un mëssagi ëd blog|$1 diferent mëssagi ëd blog}}!',
	'achievements-badge-desc-love' => 'për contribuì a la wiki minca di për {{PLURAL:$1|un di|$1 di}}!',
	'achievements-badge-desc-welcome' => 'për unite a la wiki!',
	'achievements-badge-desc-introduction' => 'për gionté a toa pàgina utent!',
	'achievements-badge-desc-sayhi' => 'për lassé un mëssagi an sla pàgina ëd discussion ëd quaidun!',
	'achievements-badge-desc-creator' => 'për creé la wiki!',
	'achievements-badge-desc-pounce' => "Për fé modìfiche su 100 pàgine ant n'ora da la creassion dla pàgina!",
	'achievements-badge-desc-caffeinated' => 'për fé 100 modìfiche su pàgine ant un sol di!',
	'achievements-badge-desc-luckyedit' => 'për fé la $1a modìfica Fortunà an sla wiki!',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'achievements-gold' => 'سره زر',
	'achievements-silver' => 'سپين زر',
	'achievements-bronze' => 'ژېړ',
	'achievements-viewall' => 'ټول کتل',
	'achievements-viewless' => 'تړل',
	'achievements-leaderboard-member-label' => 'غړی',
	'achievements-send' => 'انځور خوندي کول',
	'achievements-save' => 'بدلونونه خوندي کول',
	'achievements-about-title' => 'د دې مخ په اړه ...',
	'platinum' => 'پلاټېنيم',
	'achievements-community-platinum-edit' => 'سمول',
	'achievements-community-platinum-save' => 'خوندي کول',
	'achievements-badge-name-edit-3' => 'د ويکي ملګری',
	'achievements-badge-name-blogcomment-1' => 'او يو بل څه',
	'achievements-badge-name-welcome' => 'ويکي ته ښه راغلاست',
	'achievements-badge-name-introduction' => 'پېژندنه',
);

/** Portuguese (Português)
 * @author Crazymadlover
 * @author Giro720
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'achievementsii-desc' => 'Um sistema de medalhas para os utilizadores',
	'achievements-upload-error' => 'Desculpe!
Essa imagem não funciona.
Assegure-se de que se trata de um ficheiro .jpg ou .png.
Se ainda assim a imagem não funcionar, poderá ser demasiado grande.
Tente outra imagem, por favor!',
	'achievements-platinum' => 'Platina',
	'achievements-gold' => 'Ouro',
	'achievements-silver' => 'Prata',
	'achievements-bronze' => 'Bronze',
	'achievements-viewless' => 'Fechar',
	'achievements-leaderboard-rank-label' => 'posição',
	'achievements-leaderboard-member-label' => 'membro',
	'achievements-leaderboard-points-label' => 'pontos',
	'achievements-community-platinum-enabled' => 'activado',
	'achievements-community-platinum-edit' => 'editar',
	'achievements-community-platinum-save' => 'gravar',
	'achievements-badge-name-edit-0' => 'Fazendo a Diferença',
	'achievements-badge-name-edit-1' => 'Apenas o Começo',
	'achievements-badge-name-edit-4' => 'Colaborador',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Ilustrador',
	'achievements-badge-name-picture-3' => 'Coleccionador',
	'achievements-badge-name-picture-5' => 'Decorador',
	'achievements-badge-name-picture-6' => 'Designer',
	'achievements-badge-name-picture-7' => 'Curador',
	'achievements-badge-name-category-0' => 'Fazer uma Ligação',
	'achievements-badge-name-category-2' => 'Explorador',
	'achievements-badge-name-category-4' => 'Navegador',
	'achievements-badge-name-blogpost-0' => 'Algo a dizer',
	'achievements-badge-name-blogpost-1' => 'Cinco Coisas a dizer',
	'achievements-badge-name-love-2' => 'Devoto',
	'achievements-badge-name-love-3' => 'Dedicado',
	'achievements-badge-name-love-4' => 'Viciado',
	'achievements-badge-name-welcome' => 'Bem-vindo(a) à Wiki',
	'achievements-badge-name-introduction' => 'Introdução',
	'achievements-badge-to-get-edit-plus-category' => 'fazer {{PLURAL:$1|uma edição de uma página|$1 edições de páginas}} $2',
	'achievements-badge-to-get-introduction' => 'adicionar à sua página de utilizador',
	'achievements-badge-to-get-sayhi' => 'deixar uma mensagem na página de discussão de alguém',
	'achievements-badge-to-get-creator' => 'ser o criador desta wiki',
	'achievements-badge-to-get-pounce' => 'ser rápido',
	'achievements-badge-to-get-caffeinated' => 'fazer {{PLURAL:$1|uma edição|$1 edições}} num único dia',
	'achievements-badge-to-get-luckyedit' => 'ter sorte',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'achievements-non-existing-category' => 'A categoria especificada não existe.',
	'achievements-gold' => 'Ouro',
	'achievements-silver' => 'Prata',
	'achievements-bronze' => 'Bronze',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|ponto|pontos}}</small>',
	'achievements-points' => '$1 {{PLURAL:$1|ponto|pontos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|ponto|pontos}}',
	'achievements-viewless' => 'Fechar',
	'achievements-send' => 'Salvar imagem',
	'achievements-save' => 'Salvar alterações',
	'achievements-customize' => 'Personalizar imagem',
	'achievements-special-saved' => 'Alterações salvas.',
	'achievements-about-title' => 'Sobre esta página...',
	'achievements-community-platinum-edit' => 'editar',
	'achievements-community-platinum-save' => 'salvar',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'achievements-platinum' => 'Platine',
	'achievements-gold' => 'Ore',
	'achievements-silver' => 'Argende',
	'achievements-bronze' => 'Bronze',
	'achievements-you-must' => 'Tu è abbesogne de $1 pe pigghià stu badge.',
	'achievements-viewall' => 'Vide tutte',
	'achievements-viewless' => 'Achiude',
	'achievements-leaderboard-rank-label' => 'posizione',
	'achievements-leaderboard-member-label' => 'membre',
	'achievements-leaderboard-points-label' => 'punde',
	'achievements-enable-track' => 'abbilitate',
	'platinum' => 'Platine',
	'achievements-community-platinum-enabled' => 'abbilitate',
	'achievements-community-platinum-edit' => 'cange',
	'achievements-community-platinum-save' => 'reggistre',
);

/** Russian (Русский)
 * @author DCamer
 * @author Eleferen
 * @author JenVan
 * @author Lockal
 * @author Strizh
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'achievementsii-desc' => 'Система достижений пользователей вики-сайта',
	'achievements-upload-error' => 'Простите!
Это изображение не подходит.
Убедитесь в том, что это файл формата .JPG или .PNG.
Если всё равно не работает, то, скорее всего, размер изображения слишком большой.
Пожалуйста, попробуйте еще раз!',
	'achievements-upload-not-allowed' => 'Администраторы могут изменять названия и изображения значков достижений на спецстранице «[[Special:AchievementsCustomize|Управление достижениями]]».',
	'achievements-non-existing-category' => 'Указанной категории не существует.',
	'achievements-edit-plus-category-track-exists' => 'Указанной категории уже <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Перейти к треку">назначен трек</a>.',
	'achievements-no-stub-category' => 'Пожалуйста, не создавайте треки для заготовок.',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Золото',
	'achievements-silver' => 'Серебро',
	'achievements-bronze' => 'Бронза',
	'achievements-you-must' => 'Вам необходимо $1, чтобы получить этот значок.',
	'leaderboard-button' => 'Лидеры по наградам',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|очко|очков}}</small>',
	'achievements-track-name-edit' => 'Изменить трек',
	'achievements-track-name-picture' => 'Изображение трека',
	'achievements-track-name-category' => 'Категория трека',
	'achievements-track-name-blogpost' => 'Сообщение в блоге трека',
	'achievements-notification-title' => 'Так держать, $1!',
	'achievements-notification-subtitle' => 'Вы заработали значок «$1» $2',
	'achievements-notification-link' => '<big><strong>[[Special:MyPage|Посмотрите, какие ещё значки вы можете заработать]]!</strong></big>',
	'achievements-points' => '$1 {{PLURAL:$1|очко|очков}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|очко|очков}}',
	'achievements-earned' => 'Этот значок был заработан {{PLURAL:$1|1 участником|$1 участниками}}.',
	'achievements-profile-title' => 'Участник $1 заработал $2 {{PLURAL:$2|значок|значков}}',
	'achievements-profile-title-no' => 'Значки участника $1',
	'achievements-profile-title-challenges' => 'Можно заработать дополнительные значки!',
	'achievements-profile-customize' => 'Настройка значков',
	'achievements-ranked' => 'Ранг #$1 в этой вики',
	'achievements-no-badges' => 'Просмотрите список, чтобы увидеть значки, которые можно заработать в этой вики!',
	'achievements-viewall' => 'Посмотреть всё',
	'achievements-viewless' => 'Закрыть',
	'leaderboard-intro' => "'''\"Что такое достижения?&rdquo;'''
Вы можете получить специальные значки, за участие в этой вики!
Каждый значок, что вы заработаете, добавит очки на ваш общий счет:
Бронзовые значки стоят 10 очков, серебряные значки стоят 50 очков, а золотые — 100 очков.

После регистрации в вики, в профиле пользователя отображаются значки, которые вы уже заработали, а так же представлен список задач, которые вам доступны.
[[Special:MyPage|Перейти к профилю пользователя, чтобы проверить его]]!",
	'leaderboard' => 'Лидеры по наградам',
	'achievements-recent-earned-badges' => 'Последние заработанные значки',
	'achievements-recent-info' => '<strong>$3</strong><br />$4<br />заработал <a href="$1">$2</a><br />$5',
	'achievements-activityfeed-info' => 'заработал <a href="$3" class="badgeName"><strong>$1</strong></a> значок <br /> $2',
	'achievements-leaderboard-rank-label' => 'место',
	'achievements-leaderboard-member-label' => 'Участник',
	'achievements-leaderboard-points-label' => 'очков',
	'achievements-send' => 'Сохранить изображние',
	'achievements-save' => 'Сохранить изменения',
	'achievements-reverted' => 'Значок возвращён к исходной версии',
	'achievements-customize' => 'Настроить изображение',
	'achievements-customize-new-category-track' => 'Создать новый трек для категории:',
	'achievements-enable-track' => 'включено',
	'achievements-revert' => 'Восстановить по умолчанию',
	'achievements-special-saved' => 'Изменения сохранены.',
	'achievements-special' => 'Особые достижения',
	'achievements-secret' => 'Секретные достижения',
	'achievementscustomize' => 'Настройка значков',
	'achievements-about-title' => 'Об этой странице...',
	'platinum' => 'Платина',
	'achievements-community-platinum-awarded-email-subject' => 'Вы получили новый Платиновый значок!',
	'achievements-community-platinum-awarded-for' => 'Награждён за:',
	'achievements-community-platinum-how-to-earn' => 'Как заработать:',
	'achievements-community-platinum-awarded-for-example' => 'например, «для этого…»',
	'achievements-community-platinum-how-to-earn-example' => 'например, «сделать три правки…»',
	'achievements-community-platinum-badge-image' => 'Изображение значка:',
	'achievements-community-platinum-awarded-to' => 'Награждён:',
	'achievements-community-platinum-current-badges' => 'Текущие платиновые значки',
	'achievements-community-platinum-create-badge' => 'Создать значок',
	'achievements-community-platinum-enabled' => 'включено',
	'achievements-community-platinum-edit' => 'править',
	'achievements-community-platinum-save' => 'сохранить',
	'achievements-badge-name-edit-0' => 'Вносить изменения',
	'achievements-badge-name-edit-1' => 'Это только начало',
	'achievements-badge-name-edit-3' => 'Друг Wiki',
	'achievements-badge-name-edit-4' => 'Сотрудник',
	'achievements-badge-name-edit-5' => 'Разработчик Wiki',
	'achievements-badge-name-edit-6' => 'Лидер Wiki',
	'achievements-badge-name-edit-7' => 'Эксперт Wiki',
	'achievements-badge-name-picture-0' => 'Моментальный снимок',
	'achievements-badge-name-picture-1' => 'Папарацци',
	'achievements-badge-name-picture-2' => 'Иллюстратор',
	'achievements-badge-name-picture-3' => 'Коллекционер',
	'achievements-badge-name-picture-4' => 'Поклонник искусства',
	'achievements-badge-name-picture-5' => 'Декоратор',
	'achievements-badge-name-picture-6' => 'Дизайнер',
	'achievements-badge-name-picture-7' => 'Куратор',
	'achievements-badge-name-category-2' => 'Исследователь',
	'achievements-badge-name-category-3' => 'Экскурсовод',
	'achievements-badge-name-category-4' => 'Навигатор',
	'achievements-badge-name-blogpost-4' => 'Докладчик',
	'achievements-badge-name-love-1' => 'Две недели в вики',
	'achievements-badge-name-love-2' => 'Приверженный',
	'achievements-badge-name-love-6' => 'Вики-Герой!',
	'achievements-badge-name-welcome' => 'Добро пожаловать в вики',
	'achievements-badge-name-introduction' => 'Введение',
	'achievements-badge-name-caffeinated' => 'С кофеином',
	'achievements-badge-name-luckyedit' => 'Счастливая правка',
	'achievements-badge-to-get-welcome' => 'присоединиться к вики',
	'achievements-badge-to-get-introduction' => 'добавил(а) свою собственную страницу участника',
	'achievements-badge-to-get-sayhi' => 'кто-то оставил сообщение на странице обсуждения',
	'achievements-badge-to-get-creator' => 'является создателем этой вики',
	'achievements-badge-to-get-pounce' => 'быть быстрым',
	'achievements-badge-to-get-edit-details' => 'Чего-то не хватает? 
Есть ошибки? 
Не стесняйтесь. 
Нажмите на кнопку «{{int:edit}}», чтобы изменить содержимое страницы!',
	'achievements-badge-to-get-love-details' => 'Счетчик сбрасывается, если вы пропустите один день, поэтому не забудьте возвращаться в вики каждый день!',
	'achievements-badge-to-get-welcome-details' => 'Нажмите на кнопку «{{int:autocreatewiki-create-account}}» в правом верхнем углу, чтобы присоединиться к сообществу. 
Вы можете начать зарабатывать собственные значки!',
	'achievements-badge-to-get-creator-details' => 'Этот значок даётся создателю вики-сайта. 
Нажмите на кнопку «{{int:createwiki}}» вверху, чтобы создать вики-сайт на вашу любимую тему!',
	'achievements-badge-to-get-community-platinum-details' => 'Это особый Платиновый значок, который доступен в течение ограниченного времени!',
	'achievements-badge-hover-desc-edit' => 'за $1 {{PLURAL:$1|правку|правок}}<br />на {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'за $1 {{PLURAL:$1|правку|правок}}<br />на $2 {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-hover-desc-picture' => 'за добавление $1 {{PLURAL:$1|изображения|изображений}}<br />на {{PLURAL:$1|страницу|страницах}}!',
	'achievements-badge-hover-desc-love' => 'за ежедневный вклад в вики в течение {{PLURAL:$1|дня|$1 дней}}',
	'achievements-badge-hover-desc-welcome' => 'за присоединение к вики!',
	'achievements-badge-hover-desc-introduction' => 'за добавление<br />своей собственной страницы!',
	'achievements-badge-hover-desc-sayhi' => 'за написание сообщения<br />на чьей-то странице обсуждения!',
	'achievements-badge-hover-desc-creator' => 'за создание вики!',
	'achievements-badge-hover-desc-pounce' => 'за правку 100 страниц в течение часа после создании страницы!',
	'achievements-badge-hover-desc-caffeinated' => 'за 100 правок на страницах за один день!',
	'achievements-badge-hover-desc-community-platinum' => 'Это особый Платиновый значок, который доступен ограниченное время!',
	'achievements-badge-your-desc-edit' => 'за {{PLURAL:$1|свою первую|$1}} {{PLURAL:$1|правку|правок}} на {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'за {{PLURAL:$1|свою первую|$1}} {{PLURAL:$1|правку|правок}} на $2 {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-your-desc-category' => 'за добавление {{PLURAL:$1|вашей первой страницы|$1 страницы}} в {{PLURAL:$1|категорию|категории}}!',
	'achievements-badge-your-desc-love' => 'за ежедневный вклад в вики в течение {{PLURAL:$1|дня|$1 дней}}',
	'achievements-badge-your-desc-welcome' => 'за присоединение к вики!',
	'achievements-badge-your-desc-introduction' => 'за создание своей собственной страницы участника!',
	'achievements-badge-your-desc-creator' => 'за создание вики!',
	'achievements-badge-your-desc-caffeinated' => 'за 100 правок на страницах за один день!',
	'achievements-badge-desc-edit' => 'за $1 {{PLURAL:$1|правку|правок}} на {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-desc-edit-plus-category' => 'за $1 {{PLURAL:$1|правку|правки|правок}} на {{PLURAL:$1|$2 странице|$2 страницах|$2 страницах}}!',
	'achievements-badge-desc-picture' => 'за добавление $1 {{PLURAL:$1|изображения|изображений}} на {{PLURAL:$1|страницу|страницах}}!',
	'achievements-badge-desc-category' => 'за добавление $1 {{PLURAL:$1|страницы|страниц|страниц}} в {{PLURAL:$1|категорию|категории}}!',
	'achievements-badge-desc-blogpost' => 'за написание $1 {{PLURAL:$1|сообщения в блоге|сообщений в блоге|сообщений в блоге}}!',
	'achievements-badge-desc-love' => 'за вклад в эту вики каждый день в течение {{PLURAL:$1|дня|$1 дней}}!',
	'achievements-badge-desc-welcome' => 'за присоединение к вики!',
	'achievements-badge-desc-introduction' => 'за добавление своей собственной страницы участника!',
	'achievements-badge-desc-sayhi' => 'за создание сообщения на чьей-то странице обсуждения!',
	'achievements-badge-desc-creator' => 'за создание вики!',
	'achievements-badge-desc-pounce' => 'за правку 100 страниц в течении часа после создании страницы!',
	'achievements-badge-desc-caffeinated' => 'за 100 правок страницы, за день!',
	'achievements-badge-desc-luckyedit' => 'за $1 правку(ок) в вики!',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Злато',
	'achievements-silver' => 'Сребро',
	'achievements-bronze' => 'Бронза',
	'achievements-you-must' => 'Потребно Вам је $1 да бисте добили овај беџ.',
	'achievements-track-name-edit' => 'Уреди запис',
	'achievements-track-name-picture' => 'Запис фотографија',
	'achievements-track-name-category' => 'Запис категорија',
	'achievements-notification-title' => 'Само напред,  $1!',
	'achievements-viewall' => 'Види све',
	'achievements-viewless' => 'Затвори',
	'achievements-leaderboard-rank-label' => 'ранг',
	'achievements-leaderboard-member-label' => 'члан',
	'achievements-leaderboard-points-label' => 'поени',
	'achievements-send' => 'Сачувај слику',
	'achievements-save' => 'Сачувај измене',
	'achievements-customize-new-category-track' => 'Направи нови запис за категорију:',
	'achievements-enable-track' => 'омогућено',
	'achievements-special-saved' => 'Измене су сачуване.',
	'achievements-about-title' => 'О овој страници...',
	'achievements-create-edit-plus-category' => 'Направи овај запис',
	'platinum' => 'Платина',
	'achievements-community-platinum-awarded-email-subject' => 'Награђени сте новим платинастим беџом!',
);

/** Swahili (Kiswahili)
 * @author Muddyb Blast Producer
 */
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

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'achievements-platinum' => 'ప్లాటినం',
	'achievements-gold' => 'స్వర్ణం',
	'achievements-silver' => 'రజతం',
	'achievements-bronze' => 'కాంస్యం',
	'achievements-profile-title-no' => '$1 యొక్క బాడ్జీలు',
);

/** Vietnamese (Tiếng Việt)
 * @author Trần Nguyễn Minh Huy
 */
$messages['vi'] = array(
	'achievements-gold' => 'Vàng',
	'achievements-silver' => 'Bạc',
	'achievements-bronze' => 'Đồng',
	'achievements-you-must' => 'Bạn cần phải $1 để nhận được huy hiệu này.',
	'achievements-track-name-picture' => 'Theo dõi hình ảnh',
	'achievements-track-name-category' => 'Cây thể loại',
	'achievements-track-name-blogpost' => 'Theo dõi Blog Post',
);

