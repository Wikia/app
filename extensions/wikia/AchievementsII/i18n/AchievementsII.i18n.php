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
	'achievements-profile-customize' => 'Customize badges',
	'achievements-ranked' => 'Ranked #$1 on this wiki',
	'achievements-no-badges' => 'Check out the list below to see the badges that you can earn on this wiki!',
	'achievements-viewall' => 'View all',
	'achievements-viewless' => 'Close',

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
	'achievements-recent-info' => '<strong>$3</strong><br/>$4<br/>earned by <a href="$1">$2</a><br/>$5',
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
	'achievements-recent-platinum' => "Should be removed, replaced by achievements-recent-earned-badges instead",
	'achievements-recent-gold' => "Should be removed, replaced by achievements-recent-earned-badges instead",
	'achievements-recent-silver' => "Should be removed, replaced by achievements-recent-earned-badges instead",
	'achievements-recent-bronze' => "Should be removed, replaced by achievements-recent-earned-badges instead",
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
	'achievements-badge-to-get-edit-plus-category' => 'What is $2?',
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
 * @author Y-M D
 */
$messages['br'] = array(
	'achievements-platinum' => 'Platin',
	'achievements-gold' => 'Aour',
	'achievements-silver' => "Arc'hant",
	'achievements-bronze' => 'Arem',
	'achievements-viewall' => 'Gwelet pep tra',
	'achievements-viewless' => 'Serriñ',
	'achievements-send' => 'Enrollañ ar skeudenn',
	'achievements-save' => "Enrollañ ar c'hemmoù",
	'achievements-customize' => 'Personelaat ar skeudenn',
	'achievements-enable-track' => 'gweredekaet',
	'achievements-about-title' => 'Diwar-benn ar bajenn-mañ...',
	'platinum' => 'Platin',
	'achievements-community-platinum-awarded-email-subject' => "Gounezet hoc'h eus ur badj platin nevez !",
	'achievements-community-platinum-awarded-for' => 'Roet evit :',
	'achievements-community-platinum-how-to-earn' => 'Penaos gounid :',
	'achievements-community-platinum-badge-image' => 'Skeudenn ar badj :',
	'achievements-community-platinum-awarded-to' => 'Roet da :',
	'achievements-community-platinum-enabled' => 'gweredekaet',
	'achievements-community-platinum-edit' => 'kemmañ',
	'achievements-community-platinum-save' => 'enrollañ',
);

/** German (Deutsch)
 * @author The Evil IP address
 */
$messages['de'] = array(
	'achievementsii-desc' => 'Leistungsbasierte Abzeichen für Wiki-Benutzer',
	'achievements-upload-error' => 'Entschuldigung!
Dieses Bild funktioniert nicht.
Stelle sicher, dass es sich um eine .jpg- oder- .png-Datei handelt.
Wenn es immer noch nicht funktioniert, dann ist das Bild wohl zu größ.
Bitte versuche es erneut!',
	'achievements-upload-not-allowed' => 'Administratoren können die Namen und BIlder von Abzeichen durch die [[Special:AchievementsCustomize|Abzeichen ändern]]-Seite anpassen.',
	'achievements-non-existing-category' => 'Die angegebene Kategorie existiert nicht.',
	'achievements-platinum' => 'Platin',
	'achievements-silver' => 'Silber',
	'achievements-you-must' => 'Du musst $1 um dieses Abzeichen zu verdienen.',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|Punkt|Punkte}}</small>',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Für weitere verdienbare Abzeichen hier klicken]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|Punkt|Punkte}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|Punkt|Punkte}}',
	'achievements-earned' => 'Dieses Abzeichen wurde von {{PLURAL:$1|einem Benutzer|$1 Benutzern}} verdient.',
	'achievements-profile-title-no' => 'Abzeichen von $1',
	'achievements-profile-title-challenges' => 'Mehr verdienbare Abzeichen!',
	'achievements-profile-customize' => 'Abzeichen anpassen',
	'achievements-viewall' => 'Alle anzeigen',
	'achievements-viewless' => 'Schließen',
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
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 */
$messages['el'] = array(
	'achievements-platinum' => 'Πλατίνα',
	'achievements-gold' => 'Χρυσός',
	'achievements-silver' => 'Ασήμι',
	'achievements-bronze' => 'Χάλκινο',
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
	'achievements-badge-name-creator' => ' Η δημιουργός',
);

/** Spanish (Español)
 * @author Bola
 * @author Crazymadlover
 * @author Peter17
 */
$messages['es'] = array(
	'achievementsii-desc' => 'Un sistema de insignias para los usuarios del wiki',
	'achievements-upload-error' => '¡Lo sentimos!
Esa imagen no funciona.
Asegúrate de que es un archivo .jpg o .png.
Si continúa sin funcionar, debe ser porque la imagen es demasiado grande.
Por favor, inténtalo con otra imagen.',
	'achievements-upload-not-allowed' => 'Los administradores pueden cambiar los nombres e imágenes de los Logros visitando la página de [[Special:AchievementsCustomize|de personalización de logros]].',
	'achievements-non-existing-category' => 'La categoría especificada no existe.',
	'achievements-edit-plus-category-track-exists' => 'La categoría especificada ya tiene un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Ir al logro">logro asociado</a>.',
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Oro',
	'achievements-silver' => 'Plata',
	'achievements-bronze' => 'Bronce',
	'achievements-you-must' => 'Necesitas $1 para conseguir este logro.',
	'leaderboard-button' => 'Tabla de líderes con más logros',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punto|puntos}}</small>',
	'achievements-track-name-edit' => 'Logro de editar',
	'achievements-track-name-picture' => 'Logro de imágenes',
	'achievements-track-name-category' => 'Logro de categoría',
	'achievements-track-name-blogpost' => 'Logro de entrada de blog',
	'achievements-track-name-blogcomment' => 'Logro de comentario de blog',
	'achievements-track-name-love' => 'Logro de "amor por el wiki"',
	'achievements-notification-title' => '¡Así se hace, $1!',
	'achievements-notification-subtitle' => 'Acabas de conseguir el logro "$1", $2',
	'achievements-notification-link' => '<strong><big>¡[[Special:MyPage|Haz clic aquí para ver más logros que puedes conseguir]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|punto|puntos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punto|puntos}}',
	'achievements-earned' => 'Este logro ha sido activado por {{PLURAL:$1|1 usuario|$1 usuarios}}.',
	'achievements-profile-title' => '$1 consiguió $2 {{PLURAL:$2|logro|logros}}',
	'achievements-profile-title-no' => '$1 logros',
	'achievements-profile-title-challenges' => '¡Más logros que puedes conseguir!',
	'achievements-profile-customize' => 'Personalizar logros',
	'achievements-ranked' => 'Puesto #$1 en este wiki',
	'achievements-no-badges' => '¡Echa un vistazo a la lista de debajo para ver los logros que puedes conseguir en este wiki!',
	'achievements-viewall' => 'ver todo',
	'achievements-viewless' => 'Cerrar',
	'leaderboard-intro' => "'''&ldquo;¿Qué son los Logros?&rdquo;'''
Puedes conseguir logros especiales por participar en este wiki!
Con cada logro consigues puntos que se añaden a tu puntuación final:
Los logros de Bronce te darán 10 puntos, los logros de Plata te darán 50 puntos y los de Oro 100 puntos.

Cuando participes en un wiki, tu perfil de usuario mostrará los logros que has conseguido, y mostrará una lista con los retos que tendrás disponibles.
¡[[Special:MyPage|Ve a tu perfil de usuario para comprobarlo]]!",
	'leaderboard' => 'Tabla de líderes con más logros',
	'achievements-recent-platinum' => 'Insignias de platino recientes',
	'achievements-recent-gold' => 'Insignias de oro recientes',
	'achievements-recent-silver' => 'Insignias de plata recientes',
	'achievements-recent-bronze' => 'insignias de bronce recientes',
	'achievements-recent-info' => '<a href="$1">$2</a> ganó la &ldquo;$3&rdquo; insignia $4',
	'achievements-send' => 'Grabar imagen',
	'achievements-save' => 'grabar cambios',
	'achievements-reverted' => 'Logro revertido a su original.',
	'achievements-customize' => 'Personalizar foto',
	'achievements-enable-track' => 'Activado',
	'achievements-revert' => 'Revertir al que está por defecto',
	'achievements-special-saved' => 'Cambios grabados',
	'achievements-special' => 'Logros especiales',
	'achievements-secret' => 'Logros secretos',
	'achievementscustomize' => 'Personalizar insignias',
	'achievements-about-title' => 'Acerca de esta página...',
	'achievements-about-content' => 'Los administradores de este wiki pueden personalizar los nombres y las imágenes de los logros.

Puedes subir cualquier imagen .jpg o .png, y tu imagen se pondrá automáticamente en el interior del marco.
Funciona mejor con las imágenes que son cuadradas, y cuando la parte más importante de la imagen está situada en medio.

Puedes usar imágenes rectangulares, pero pero podrías encontrarte con que se coloca mal en el marco.
Si tienes un programa gráfico, puedes arreglar la imagen para poner la parte más importante de la misma en el centro.
¡Si no tienes un programa gráfico, puedes probar con diferentes imágenes hasta que encuentres la que funcione mejor!
Si no has elegido aún la imagen para poner, haz clic en "{{int:achievements-revert}}" para volver a la imagen original.

También puedes dar nuevos nombres a los logros para que estén relacionados con el tema del wiki. Cuando hayas cambiado el nombre de los logros, haz clic en "{{int:achievements-save}}" para guardar los cambios.
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
	'achievements-create-edit-plus-category' => 'Crea este logro',
	'platinum' => 'Platino',
	'achievements-community-platinum-awarded-email-subject' => '¡Has conseguido un nuevo logro de Platino!',
	'achievements-community-platinum-awarded-email-body-text' => "¡Felicidades $1!

Has conseguido el logro de Platino '$2' en $4 ($3). ¡Con este logro has conseguido 250 puntos para tu puntuación total!

Echa un vistazo a este logro de lujo en tu perfil de usuario:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>¡Felicidades $1!</strong><br /><br />
Has conseguido el logro de Platino \'<strong>$2</strong>\' en <a href="$3">$4</a>. ¡Con este logro has conseguido 250 puntos para tu puntuación total!<br /><br />
Echa un vistazo a este logro de lujo en tu <a href="$5">perfil de usuario</a>.',
	'achievements-community-platinum-awarded-for' => 'Otorgado por:',
	'achievements-community-platinum-how-to-earn' => 'Cómo ganar:',
	'achievements-community-platinum-awarded-for-example' => 'ej. "Por hacer..."',
	'achievements-community-platinum-how-to-earn-example' => 'ej. "hacer tres ediciones..."',
	'achievements-community-platinum-badge-image' => 'Imagen de insignia:',
	'achievements-community-platinum-awarded-to' => 'Otorgado a:',
	'achievements-community-platinum-current-badges' => 'Logros de platino actuales',
	'achievements-community-platinum-create-badge' => 'Crear logro',
	'achievements-community-platinum-enabled' => 'activado',
	'achievements-community-platinum-show-recents' => 'mostrar en logros recientes',
	'achievements-community-platinum-edit' => 'editar',
	'achievements-community-platinum-save' => 'guardar',
	'achievements-badge-name-edit-0' => 'Marcando la diferencia',
	'achievements-badge-name-edit-1' => 'Sólo el principio',
	'achievements-badge-name-edit-2' => 'Dejando tu impronta',
	'achievements-badge-name-edit-3' => 'Amigo del wiki',
	'achievements-badge-name-edit-4' => 'Colaborador',
	'achievements-badge-name-edit-5' => 'Constructor Wiki',
	'achievements-badge-name-edit-6' => 'Líder Wiki',
	'achievements-badge-name-edit-7' => 'Experto Wiki',
	'achievements-badge-name-picture-0' => 'Instantánea',
	'achievements-badge-name-picture-1' => 'Paparazzi',
	'achievements-badge-name-picture-2' => 'Ilustrador',
	'achievements-badge-name-picture-3' => 'Coleccionista',
	'achievements-badge-name-picture-4' => 'Amante del arte',
	'achievements-badge-name-picture-5' => 'Decorador',
	'achievements-badge-name-picture-6' => 'Diseñador',
	'achievements-badge-name-picture-7' => 'Curador',
	'achievements-badge-name-category-0' => 'Establecer una conexión',
	'achievements-badge-name-category-1' => 'Pionero',
	'achievements-badge-name-category-2' => 'Explorador',
	'achievements-badge-name-category-3' => 'Guía turística',
	'achievements-badge-name-category-4' => 'Navegante',
	'achievements-badge-name-category-5' => 'Constructor de Puentes',
	'achievements-badge-name-category-6' => 'Planificador Wiki',
	'achievements-badge-name-blogpost-0' => 'Algo que decir',
	'achievements-badge-name-blogpost-1' => 'Cinco cosas que decir',
	'achievements-badge-name-blogpost-2' => 'Show de la conversación',
	'achievements-badge-name-blogpost-3' => 'Alma de la fiesta',
	'achievements-badge-name-blogpost-4' => 'Relaciones públicas',
	'achievements-badge-name-blogcomment-0' => 'Comentarista',
	'achievements-badge-name-blogcomment-1' => 'Y una cosa más',
	'achievements-badge-name-love-0' => '¡Esencial para el wiki!',
	'achievements-badge-name-love-1' => 'Dos semanas en el wiki',
	'achievements-badge-name-love-2' => 'Devoto',
	'achievements-badge-name-love-3' => 'Dedicado',
	'achievements-badge-name-love-4' => 'Adicto',
	'achievements-badge-name-love-5' => 'Su vida es el wiki',
	'achievements-badge-name-love-6' => 'Héroe Wiki',
	'achievements-badge-name-welcome' => 'Bienvenido al wiki',
	'achievements-badge-name-introduction' => 'Introducción',
	'achievements-badge-name-sayhi' => 'Deteniendo para decir hola',
	'achievements-badge-name-creator' => 'El creador',
	'achievements-badge-name-pounce' => '¡Salta!',
	'achievements-badge-name-caffeinated' => 'Con cafeína',
	'achievements-badge-name-luckyedit' => 'Edición afortunada',
	'achievements-badge-to-get-edit' => 'hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una página|páginas}}',
	'achievements-badge-to-get-edit-plus-category' => 'hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una|}} $2 {{PLURAL:$1|una página|páginas}}',
	'achievements-badge-to-get-picture' => 'agregar $1 {{PLURAL:$1|imagen|imágenes}} a {{PLURAL:$1|una página|páginas}}',
	'achievements-badge-to-get-category' => 'agregar $1 {{PLURAL:$1|página|páginas}} a {{PLURAL:$1|una categoría|categorías}}',
	'achievements-badge-to-get-blogpost' => 'escribir $1 {{PLURAL:$1|mensaje de blog|mensajes de blog}}',
	'achievements-badge-to-get-blogcomment' => 'escribir un comentario en $1 diferentes mensajes de blog',
	'achievements-badge-to-get-love' => 'contribuir al wiki cada día por $1 días',
	'achievements-badge-to-get-welcome' => 'unirse al wiki',
	'achievements-badge-to-get-introduction' => 'agregar a tu propia página de usuario',
	'achievements-badge-to-get-sayhi' => 'dejar a alguien un mensaje en su página de discusión',
	'achievements-badge-to-get-creator' => 'ser el crador de esta wiki',
	'achievements-badge-to-get-pounce' => 'ser rápido',
	'achievements-badge-to-get-caffeinated' => 'hacer $1 ediciones en las páginas en un solo día',
	'achievements-badge-to-get-luckyedit' => 'tener suerte',
	'achievements-badge-to-get-edit-details' => '¿Falta algo? ¿Hay algún error? No seas tímido. ¡Haz clic en el botón editar y podrás añadir cualquier página!',
	'achievements-badge-to-get-edit-plus-category-details' => '¡Las <strong>$1</strong> páginas necesitan tu ayuda! Haz clic en el botón editar de cualquier página en esta categoría para ayudar. ¡Demuestra tu apoyo a las $1 páginas!',
	'achievements-badge-to-get-picture-details' => 'Haz clic en el botón editar, y después en el botón de Añadir una imagen. Puedes añadir una imagen desde tu ordenador, o desde otra página del wiki.',
	'achievements-badge-to-get-category-details' => 'Las categorías son etiquetas que ayudan a los lectores a encontrar páginas similares. Haz clic en el botón de Añadir categoría para añadir la página a una categoría.',
	'achievements-badge-to-get-blogpost-details' => '¡Escribe tu opinión y tus preguntas! Haz clic en "Entradas de blog recientes" en el panel lateral, y después en el enlace de la izquierda para Crear una nueva entrada de blog.',
	'achievements-badge-to-get-blogcomment-details' => '¡Añade tu granito de arena! Lee cualquiera de las entradas de blog, y escribe tus propias opiniones en los comentarios.',
	'achievements-badge-to-get-love-details' => '¡El contador se resetea si pierdes un día, asegúrate de volver al wiki cada día!',
	'achievements-badge-to-get-welcome-details' => 'Haz clic en el botón para crear una nueva cuenta arriba a la derecha para participar en la comunidad. ¡Así podrás comenzar a ganar tus propios logros!',
	'achievements-badge-to-get-introduction-details' => '¿Tu página de usuario está vacía? Haz clic en tu nombre de usuario al comienzo de la pantalla para verla. ¡Haz clic en editar para añadir algo de información sobre ti!',
	'achievements-badge-to-get-sayhi-details' => 'Puedes dejar mensajes a otros usuarios haciendo clic en "Dejar mensaje" al comienzo de la página de discusión. ¡Para pedirle ayuda, agradecerle su trabajo, o para decirle hola!',
	'achievements-badge-to-get-creator-details' => 'Este logro se otorga a la persona que fundó el wiki. ¡Haz clic en el botón para Crear un nuevo wiki arriba, para comenzar tu propio sitio sobre el tema que más te guste!',
	'achievements-badge-to-get-pounce-details' => 'Tienes que ser rápido para conseguir este logro. ¡Haz clic en el botón de Actividad reciente para ver las nuevas páginas que los usuarios están creando!',
	'achievements-badge-to-get-caffeinated-details' => 'Necesitarás todo un día para conseguir este logro. ¡No dejes de editar!',
	'achievements-badge-to-get-luckyedit-details' => 'Necesitas suerte para conseguir este logro. ¡No dejes de editar!',
	'achievements-badge-to-get-community-platinum-details' => 'Esta es una insignia especial de platino que está disponible por un tiempo limitado!',
	'achievements-badge-hover-desc-edit' => 'Por hacer $1 {{PLURAL:$1|edición|ediciones}}<br />
en {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'Por hacer $1 {{PLURAL:$1|edición|ediciones}}<br />
en {{PLURAL:$1|una|}} $2 {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-hover-desc-picture' => 'Por agregar $1 {{PLURAL:$1|imagen|imágenes}}<br />
a {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-hover-desc-category' => 'Por agregar $1 {{PLURAL:$1|página|páginas}}<br />
a {{PLURAL:$1|una categoría|categorías}}!',
	'achievements-badge-hover-desc-blogpost' => 'Por escribir $1 {{PLURAL:$1|mensaje de blog|mensajes de blog}}!',
	'achievements-badge-hover-desc-blogcomment' => 'por escribir un comentario<br />
en $1 diferentes {{PLURAL:$1|mensajes de blog|mensajes de blog}}!',
	'achievements-badge-hover-desc-love' => 'Por contribuir en el wiki cada día por $1 días!',
	'achievements-badge-hover-desc-welcome' => 'por unirte al wiki!',
	'achievements-badge-hover-desc-introduction' => 'por agregar a<br />
tu propia página de usuario!',
	'achievements-badge-hover-desc-sayhi' => 'por dejar un mensaje<br />
en la página de discusión de alguien más!',
	'achievements-badge-hover-desc-creator' => 'por crear el wiki!',
	'achievements-badge-hover-desc-pounce' => 'por hacer ediciones en 100 páginas dentro de la hora de creada la página!',
	'achievements-badge-hover-desc-caffeinated' => 'por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-hover-desc-luckyedit' => 'por hacer la edición afortunada $1th en el wiki!',
	'achievements-badge-hover-desc-community-platinum' => 'Esta es una insignia especial de platino que está disponible por un tiempo limitado!',
	'achievements-badge-your-desc-edit' => 'por hacer {{PLURAL:$1|tus primeras|$1}} {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'por hacer {{PLURAL:$1|tus primeras|$1}} {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una|}} $2 {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-your-desc-picture' => 'por agregar {{PLURAL:$1|tus primeras|$1}} {{PLURAL:$1|imagen|imágenes}} a {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-your-desc-category' => 'por agregar {{PLURAL:$1|tus primeras|$1}} {{PLURAL:$1|página|páginas}} a {{PLURAL:$1|una categoría|categorías}}!',
	'achievements-badge-your-desc-blogpost' => 'por escribir {{PLURAL:$1|tus primeros|$1}} {{PLURAL:$1|mensajes de blog|mensajes de blog}}!',
	'achievements-badge-your-desc-blogcomment' => 'por escribir un comentario en $1 diferentes mensajes de blog!',
	'achievements-badge-your-desc-love' => 'Por contribuir en el wiki cada día por $1 días!',
	'achievements-badge-your-desc-welcome' => 'por unirte al wiki!',
	'achievements-badge-your-desc-introduction' => 'por agregar a tu propia página de usuario!',
	'achievements-badge-your-desc-sayhi' => 'por dejar un mensaje en la página de discusión de alguien más!',
	'achievements-badge-your-desc-creator' => 'por crear el wiki!',
	'achievements-badge-your-desc-pounce' => 'por hacer ediciones en 100 páginas dentro de la hora de creada la página!',
	'achievements-badge-your-desc-caffeinated' => 'por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-your-desc-luckyedit' => 'por hacer la edición afortunada $1th en el wiki!',
	'achievements-badge-desc-edit' => 'por hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-desc-edit-plus-category' => 'por hacer $1 {{PLURAL:$1|edición|ediciones}} en {{PLURAL:$1|una|}} $2 {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-desc-picture' => 'por agregar $1 {{PLURAL:$1|imagen|imágenes}} a {{PLURAL:$1|una página|páginas}}!',
	'achievements-badge-desc-category' => 'por agregar $1 {{PLURAL:$1|página|páginas}} a {{PLURAL:$1|una categoría|categorías}}!',
	'achievements-badge-desc-blogpost' => 'por escribir $1 {{PLURAL:$1|mensaje de blog|mensajes de blog}}!',
	'achievements-badge-desc-blogcomment' => ' por escribir un comentario en $1 diferentes mensajes de blog!',
	'achievements-badge-desc-love' => 'por contribuir en el wiki cada día por $1 días!',
	'achievements-badge-desc-welcome' => 'por unirte al wiki!',
	'achievements-badge-desc-introduction' => 'por agregar a tu propia página de usuario!',
	'achievements-badge-desc-sayhi' => 'por dejar un mensaje en la página de discusión de alguien más!',
	'achievements-badge-desc-creator' => 'por crear el wiki!',
	'achievements-badge-desc-pounce' => 'por hacer ediciones en 100 páginas dentro de la hora de creada la página!',
	'achievements-badge-desc-caffeinated' => ' por hacer 100 ediciones en páginas en un solo día!',
	'achievements-badge-desc-luckyedit' => 'por hacer la edición afortunada $1th en el wiki!',
);

/** French (Français)
 * @author IAlex
 * @author Peter17
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
	'achievements-profile-customize' => 'Personnaliser les badges',
	'achievements-ranked' => 'Classé n°$1 sur ce wiki',
	'achievements-no-badges' => 'Jetez un œil à la liste ci-dessous pour voir les badges que vous pouvez gagner sur ce wiki !',
	'achievements-viewall' => 'Tout voir',
	'achievements-viewless' => 'Fermer',
	'leaderboard-intro' => "'''&ldquo;Que sont les Challenges ?&rdquo;'''
Vous pouvez gagner des badges spéciaux en participant à ce wiki !
Chaque badge que vous gagnez ajoute des points à votre score total :
Les badges de bronze valent 10 points, ceux en argent valent 50 points et ceux en or, 100 points.

Lorsque vous rejoignez le wiki, votre profil utilisateur affiche les badges que vous avez gagnés et vous montre une liste de challenges qui sont disponibles pour vous.
[[Special:MyPage|Allez sur votre profil jeter un œil]] !",
	'leaderboard' => 'Tableau des challenges',
	'achievements-recent-platinum' => 'Badges en platine récents',
	'achievements-recent-gold' => 'Badges en or récents',
	'achievements-recent-silver' => 'Badges en argent récents',
	'achievements-recent-bronze' => 'Badges en bronze récents',
	'achievements-recent-info' => '<a href="$1">$2</a> a gagné le badge &ldquo;$3&rdquo; $4',
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

Ceci peut aider s’amuser davantage avec les challenges.
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
	'achievements-badge-to-get-blogpost' => 'écrire $1 {{PLURAL:$1|billet de blog|billets de blog}}',
	'achievements-badge-to-get-blogcomment' => 'écrire un commentaire sur $1 billets de blog différents',
	'achievements-badge-to-get-love' => 'contribuer sur le wiki chaque jour pendant $1 jours',
	'achievements-badge-to-get-welcome' => 'rejoindre le wiki',
	'achievements-badge-to-get-introduction' => 'ajouter à votre propre page utilisateur',
	'achievements-badge-to-get-sayhi' => 'laisser un message à quelqu’un sur sa page de discussion',
	'achievements-badge-to-get-creator' => 'être le créateur de ce wiki',
	'achievements-badge-to-get-pounce' => 'être rapide',
	'achievements-badge-to-get-caffeinated' => 'faire $1 modifications sur les pages en une seule journée',
	'achievements-badge-to-get-luckyedit' => 'avoir de la chance',
	'achievements-badge-to-get-edit-details' => 'Quelque chose manque ? Il y a une erreur ? Ne soyez pas timide. Cliquez sur le bouton modifier et améliorez n’importe quelle page !',
	'achievements-badge-to-get-edit-plus-category-details' => 'Les pages <strong>$1</strong> ont besoin de votre aide ! Cliquez sur le bouton modifier sur n’importe quelle page de cette catégorie pour aider. Montrez votre soutien aux pages $1 !',
	'achievements-badge-to-get-picture-details' => 'Cliquez sur le bouton modifier puis sur le bouton Ajouter une image. Vous pouvez ajouter une photo depuis votre ordinateur ou depuis une autre page du wiki.',
	'achievements-badge-to-get-category-details' => 'Les catégories sont des étiquettes qui aident les lecteurs à trouver des pages similaires. Cliquez sur le bouton « Ajouter une catégorie » d’une page pour lister cette page dans une catégorie.',
	'achievements-badge-to-get-blogpost-details' => 'Écrivez vos opinions et questions ! Cliquez sur « Billets de blog récents » dans la barre latérale et ensuite sur le lien à gauche pour créer un nouveau billet de blog.',
	'achievements-badge-to-get-blogcomment-details' => 'Ajoutez votre grain de sel ! Lisez un des billets de blog récents et donnez votre avis dans la boîte à commentaires.',
	'achievements-badge-to-get-love-details' => 'Le compteur se réinitialise si vous ratez un jour. Soyez sûr de revenir sur le wiki tous les jours !',
	'achievements-badge-to-get-welcome-details' => 'Cliquez sur le bouton « Créer un compte » en haut à droite pour rejoindre la communauté. Vous pourrez commencer à gagner vos propres badges !',
	'achievements-badge-to-get-introduction-details' => 'Votre page utilisateur est vide ? Cliquez sur votre nom d’utilisateur en haut de l’écran pour voir. Cliquez sur « Modifier » pour ajouter des informations sur vous !',
	'achievements-badge-to-get-sayhi-details' => 'Vous pouvez laisser des messages aux autres utilisateurs en cliquant sur « Laisser un message » sur leur page de discussion. Demandez de l’aide, remerciez-les pour leur travail, ou dites simplement bonjour !',
	'achievements-badge-to-get-creator-details' => 'Ce badge est décerné à la personne qui crée le wiki. Cliquez sur le bouton « Créer un nouveau wiki » en haut de l’écran pour créer un site à propos de ce que vous aimez le plus !',
	'achievements-badge-to-get-pounce-details' => 'Vous devez être rapide pour gagner ce badge. Cliquez sur le bouton « Activité récente » pour voir les nouvelles pages que les utilisateurs créent !',
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
	'achievements-badge-hover-desc-blogpost' => 'pour avoir écrit $1 {{PLURAL:$1|billet de blog|billets de blog}} !',
	'achievements-badge-hover-desc-blogcomment' => 'pour avoir écrit un commentaire<br />
sur $1 {{PLURAL:$1|billet de blog|billets de blog différents}} !',
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
	'achievements-badge-your-desc-blogpost' => 'pour avoir écrit {{PLURAL:$1|votre premier billet de blog|$1 billets de blog}} !',
	'achievements-badge-your-desc-blogcomment' => 'pour avoir écrit un commentaire sur $1 billets de blog différents !',
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
	'achievements-badge-desc-blogpost' => 'pour avoir écrit $1 {{PLURAL:$1|billet de blog|billets de blog}} !',
	'achievements-badge-desc-blogcomment' => 'pour avoir écrit un commentaire sur $1 billets de blog différents !',
	'achievements-badge-desc-love' => 'pour avoir contribué au wiki tous les jours pendant $1 jours !',
	'achievements-badge-desc-welcome' => 'pour avoir rejoint le wiki !',
	'achievements-badge-desc-introduction' => 'pour avoir ajouté des informations sur votre propre page utilisateur !',
	'achievements-badge-desc-sayhi' => "pour avoir laissé un message sur la page de discussion de quelqu’un d'autre !",
	'achievements-badge-desc-creator' => 'pour avoir créé le wiki !',
	'achievements-badge-desc-pounce' => 'pour avoir fait des modifications sur 100 pages dans l’heure suivant la création de la page !',
	'achievements-badge-desc-caffeinated' => 'pour avoir fait 100 modifications sur des pages en un seul jour !',
	'achievements-badge-desc-luckyedit' => 'pour avoir fait la modification chanceuse n°$1 sur le wiki !',
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
	'achievements-edit-plus-category-track-exists' => 'Le categoria specificate ha ja un <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Go to the track">tracia associate</a>.',
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Auro',
	'achievements-silver' => 'Argento',
	'achievements-bronze' => 'Bronzo',
	'achievements-you-must' => 'Tu debe $1 pro meritar iste insignia.',
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
	'achievements-profile-customize' => 'Personalisar insignias',
	'achievements-ranked' => 'Ha le rango №$1 in iste wiki',
	'achievements-no-badges' => 'Reguarda le lista hic infra pro vider le insignias que tu pote meritar in iste wiki!',
	'achievements-viewall' => 'Vider toto',
	'achievements-viewless' => 'Clauder',
	'leaderboard-intro' => "'''&ldquo;Que es le insignias de merito?&rdquo;'''
Tu pote meritar special insignias per participar in iste wiki!
Cata insignia que tu merita adde punctos a tu score total:
le insignias de bronzo vale 10 punctos, le insignias de argento vale 50 punctos, e le insignias de auro vale 100 punctos.

Quando tu deveni membro del wiki, tu profilo de usator presenta le insignias que tu ha meritate, e te monstra un lista del defias que es disponibile a te.
[[Special:MyPage|Va a tu profilo de usator pro vider lo]]!",
	'leaderboard' => 'Classamento de successos',
	'achievements-recent-platinum' => 'Insignias de platino recente',
	'achievements-recent-gold' => 'Insignias de auro recente',
	'achievements-recent-silver' => 'Insignias de argento recente',
	'achievements-recent-bronze' => 'Insignias de bronzo recente',
	'achievements-recent-info' => '<a href="$1">$2</a> meritava le insignia &ldquo;$3&rdquo; $4',
	'achievements-send' => 'Salveguardar imagine',
	'achievements-save' => 'Confirmar modificationes',
	'achievements-reverted' => 'Insignia revertite al original.',
	'achievements-customize' => 'Personalisar imagine',
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
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Felicitationes, $1!</strong><br/><br/>
Tu ha justo recipite le insignia de Platino \'<strong>$2</strong>\' in <a href="$3">$4</a>. Isto adde 250 punctos a tu score!<br/><br/>
Reguarda tu nove insignia fantastic in le <a href="$5">pagina de tu profilo de usator</a>.',
	'achievements-community-platinum-awarded-for' => 'Meritate pro',
	'achievements-community-platinum-how-to-earn' => 'Como meritar',
	'achievements-community-platinum-awarded-for-example' => 'p.ex. "pro haber facite..."',
	'achievements-community-platinum-how-to-earn-example' => 'p.ex. "facer 3 modificationes..."',
	'achievements-community-platinum-badge-image' => 'Imagine del insignia',
	'achievements-community-platinum-awarded-to' => 'Meritate per',
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
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'achievements-masthead-points' => '$1 <small>ポイント</small>',
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
	'achievements-profile-customize' => 'Прилагоди значки',
	'achievements-ranked' => 'На $1 место на ова вики',
	'achievements-no-badges' => 'Проверете го долунаведениот список за да видите кои значки можете да ги заработите на ова вики!',
	'achievements-viewall' => 'Преглед на сите',
	'achievements-viewless' => 'Затвори',
	'leaderboard-intro' => "'''&ldquo;What are Achievements?&rdquo;'''
Со учество на ова вики можете да заработите специјални значки! 
Секоја заработена значка ви носи бодови кон вкупното салдо: 
Бронзените значки носат 10 бода, Сребрените значки носат 50 бода, а Златните носат 100 бода.

Кога ќе се зачлените на викито, на корисничкиот профил се истакнати значките што сте ги заработиле, како и список на предизвиците кои ви се достапни. [[Special:MyPage|Одете на вашиот кориснички профил и погледајте!]]",
	'leaderboard' => 'Предводници',
	'achievements-recent-platinum' => 'Скорешни Платински значки',
	'achievements-recent-gold' => 'Скорешни Златни значки',
	'achievements-recent-silver' => 'Скорешни Сребрени значки',
	'achievements-recent-bronze' => 'Скорешни Бронзени значки',
	'achievements-recent-info' => '<a href="$1">$2</a> заработи значката „$3“ $4',
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
	'achievements-badge-to-get-welcome-details' => 'Кликнете на копчето „Создај сметка“ во горениот десен агол за да се приклучите кон заеднцата. Потоа можете да почнете да си печалите значки!',
	'achievements-badge-to-get-introduction-details' => 'Дали ви е празна корисничката страница? Кликнете на вашето корисничко име најгоре за да видите. Кликнете на „уреди“ за да ставите некои податоци за себе!',
	'achievements-badge-to-get-sayhi-details' => 'Можете да им оставате пораки на другите корисници со стискање на „Остави порака“ на нивната страница за разговор. Вака можете да побарате помош, да им се заблагодарите за трудот, или едноставно да ги поздравите!',
	'achievements-badge-to-get-creator-details' => 'Оваа страница се доделува на личноста која е основач на викито. Кликнете на копчето „Создај ново вики“ најгоре и започнете мрежно-место на вашата омилена тематика!',
	'achievements-badge-to-get-pounce-details' => 'За да ја добиете оваа значка мора да бидете брзи. Кликнете на копчето за Канал со активности за да ги видите новите страници што ги создаваат корисниците!',
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
	'achievements-badge-desc-blogcomment' => 'за оставање коментар на $1 различни блог-записи!',
	'achievements-badge-desc-love' => 'за секојдневен придонес на викито во тек на $1 дена!',
	'achievements-badge-desc-welcome' => 'за зачленување на викито!',
	'achievements-badge-desc-introduction' => 'за додавање содржина на вашата корисничка страница!',
	'achievements-badge-desc-sayhi' => 'за оставање порака на нечија страница за разговор!',
	'achievements-badge-desc-creator' => 'за создавање на викито!',
	'achievements-badge-desc-pounce' => 'за извршени уредувања на 100 страници во текот на еден час од создавањето на страниците!',
	'achievements-badge-desc-caffeinated' => 'за извршени 100 уредувања на страници во текот на еден ден!',
	'achievements-badge-desc-luckyedit' => 'за извршување на Среќното $1-то уредување на викито!',
);

/** Dutch (Nederlands)
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
	'achievements-profile-customize' => 'Speldjes aanpassen',
	'achievements-ranked' => 'Op plaats $1 in de ranglijst van deze wiki',
	'achievements-no-badges' => 'Hieronder staan de speldjes die u op deze wiki kunt verdienen!',
	'achievements-viewall' => 'Allemaal bekijken',
	'achievements-viewless' => 'Sluiten',
	'leaderboard-intro' => "'''&ldquo;Wat zijn prestaties?&rdquo;'''
U kunt speciale speldjes verdienen door deel te nemen aan deze wiki!
Met ieder speldje dat u verdient loopt uw totaalscore op. Bronzen speldjes zijn 10 punten waard, zilveren speldjes zijn 50 punten waard en gouden speldjes zijn 100 punten waard.

Als u bij de wiki komt, wordt in uw gebruikersprofiel aangegeven welke speldjes u verdiend hebt en de lijst met uitdagingen die u nog kunt voltooien.
[[Special:MyPage|Ga naar uw gebruikersprofiel voor details]]!",
	'leaderboard' => 'Scorebord prestaties',
	'achievements-recent-platinum' => 'Recente platina speldjes',
	'achievements-recent-gold' => 'Recente gouden speldjes',
	'achievements-recent-silver' => 'Recente zilveren speldjes',
	'achievements-recent-bronze' => 'Recente bronzen speldjes',
	'achievements-recent-info' => '<a href="$1">$2</a> heeft het speldje &ldquo;$3&rdquo; verdiend $4',
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
	'achievements-badge-to-get-blogcomment' => 'schrijf een reactie bij {{PLURAL:$1|eeb blogbericht|$1 blogberichten}}',
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
	'achievements-profile-customize' => 'Tilpass utmerkelser',
	'achievements-ranked' => 'Rangert #$1 på denne wikien',
	'achievements-no-badges' => 'Sjekk ut listen under for å se utmerkelsene du kan oppnå på denne wikien!',
	'achievements-viewall' => 'Vis alle',
	'achievements-viewless' => 'Lukk',
	'leaderboard-intro' => "'''&laquo;Hva er utmerkelser?&rdquo;'''
Du kan motta spesielle utmerkelser ved å delta på denne wikien! 
Hver utmerkelse du oppnår gir poeng til den totale poengsummen sin:
Bronseutmerkelser er verdt 10 poeng, Sølvutmerkelser er verdt 50 poeng, og Gullutmerkelser er verdt 100 poeng.

Når du blir med i wikien, viser brukerprofilen din de utmerkelsene du har mottatt, og viser en liste over de utfordringene som er tilgjengelige for deg.
[[Special:MyPage|Gå til brukerprofilen din og sjekk det ut]]!",
	'leaderboard' => 'Toppliste over utmerkelser',
	'achievements-recent-platinum' => 'Siste Platinautmerkelser',
	'achievements-recent-gold' => 'Siste Gullutmerkelser',
	'achievements-recent-silver' => 'Siste Sølvutmerkelser',
	'achievements-recent-bronze' => 'Siste Bronseutmerkelser',
	'achievements-recent-info' => '<a href="$1">$2</a> mottok &laquo;$3&raquo;-utmerkelsen $4',
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
	'achievements-badge-desc-blogcomment' => 'for å skrive en kommentar på $1 forskjellige blogginnlegg!',
	'achievements-badge-desc-love' => 'for å bidra på wikien hver dag i $1 dager!',
	'achievements-badge-desc-welcome' => 'for å bli med i wikien!',
	'achievements-badge-desc-introduction' => 'for å legge til på din egen brukerside!',
	'achievements-badge-desc-sayhi' => 'for å legge igjen en beskjed på noen andres diskusjonsside!',
	'achievements-badge-desc-creator' => 'for å opprette wikien!',
	'achievements-badge-desc-pounce' => 'for å redigere 100 sider i løpet av en time etter at siden ble opprettet!',
	'achievements-badge-desc-caffeinated' => 'for å gjøre 100 redigeringer på sider på én dag!',
	'achievements-badge-desc-luckyedit' => 'for å gjøre den heldige $1. redigeringen på wikien!',
);

/** Russian (Русский)
 * @author DCamer
 * @author Eleferen
 * @author Strizh
 */
$messages['ru'] = array(
	'achievementsii-desc' => 'Система достижений пользователей вики-сайта',
	'achievements-upload-error' => 'Простите!
Это изображение не подходит.
Убедитесь в том, что это файл формата .JPG или .PNG.
Если всё равно не работает, то, скорее всего, размер изображения слишком большой.
Пожалуйста, попробуйте еще раз!',
	'achievements-upload-not-allowed' => 'Администраторы могут изменять названия и изображения значков достижений на спецстранице "[[Служебная:AchievementsCustomize|Управление достижениями]]".',
	'achievements-non-existing-category' => 'Указанной категории не существует.',
	'achievements-edit-plus-category-track-exists' => 'Указанной категории уже <a href="#" onclick="$(window).scrollTo(\'#section$1\', 2500); return false;" title="Перейти к треку">назначен трек</a>.',
	'achievements-platinum' => 'Платина',
	'achievements-gold' => 'Золото',
	'achievements-silver' => 'Серебро',
	'achievements-bronze' => 'Бронза',
	'achievements-you-must' => 'Вам необходимо $1, чтобы получить этот значок.',
	'leaderboard-button' => 'Лидеры по наградам',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|поинт|поинтов}}</small>',
	'achievements-track-name-picture' => 'Изображение трека',
	'achievements-track-name-category' => 'Категория трека',
	'achievements-points' => '$1 {{PLURAL:$1|очко|очков}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|очко|очков}}',
	'achievements-profile-customize' => 'Настройка значков',
	'achievements-viewall' => 'Посмотреть всё',
	'achievements-viewless' => 'Закрыть',
	'achievements-recent-platinum' => 'Последние платиновые награждения',
	'achievements-recent-gold' => 'Последние золотые награждения',
	'achievements-recent-silver' => 'Последние серебряные награждения',
	'achievements-recent-bronze' => 'Последние бронзовые награждения',
	'achievements-send' => 'Сохранить изображние',
	'achievements-save' => 'Сохранить изменения',
	'achievements-community-platinum-create-badge' => 'Создать значок',
	'achievements-community-platinum-edit' => 'править',
	'achievements-community-platinum-save' => 'сохранить',
	'achievements-badge-to-get-introduction' => 'добавил(а) свою собственную страницу участника',
	'achievements-badge-hover-desc-edit' => 'за $1 {{PLURAL:$1|правку|правок}}<br />на {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'за $1 {{PLURAL:$1|правку|правок}}<br />на $2 {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-hover-desc-picture' => 'за добавление $1 {{PLURAL:$1|изображения|изображений}}<br />на {{PLURAL:$1|страницу|страницах}}!',
	'achievements-badge-hover-desc-welcome' => 'за присоединение к вики!',
	'achievements-badge-hover-desc-introduction' => 'за добавление<br />своей собственной страницы!',
	'achievements-badge-hover-desc-sayhi' => 'за написание сообщения<br />на чьей-то странице обсуждения!',
	'achievements-badge-hover-desc-creator' => 'за создание вики!',
	'achievements-badge-hover-desc-pounce' => 'за правку 100 страниц в течение часа после создании страницы!',
	'achievements-badge-hover-desc-caffeinated' => 'за 100 правок на страницах за один день!',
	'achievements-badge-your-desc-edit' => 'за {{PLURAL:$1|свою первую|$1}} {{PLURAL:$1|правку|правок}} на {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'за {{PLURAL:$1|свою первую|$1}} {{PLURAL:$1|правку|правок}} на $2 {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-desc-edit' => 'за $1 {{PLURAL:$1|правку|правок}} на {{PLURAL:$1|странице|страницах}}!',
	'achievements-badge-desc-love' => 'за вклад в эту вики каждый день в течение $1 дней!',
	'achievements-badge-desc-welcome' => 'за присоединение к вики!',
	'achievements-badge-desc-introduction' => 'за добавление своей собственной страницы участника!',
	'achievements-badge-desc-sayhi' => 'за создание сообщения на чьей-то странице обсуждения!',
	'achievements-badge-desc-creator' => 'за создание вики!',
	'achievements-badge-desc-pounce' => 'за правку 100 страниц в течении часа после создании страницы!',
	'achievements-badge-desc-caffeinated' => 'за 100 правок страницы, за день!',
	'achievements-badge-desc-luckyedit' => 'за $1 правку(ок) в вики!',
);

