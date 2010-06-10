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
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Click here to see more badges you can earn]]!</big></strong>',
	'achievements-points' => '$1 {{PLURAL:$1|point|points}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|point|points}}',

	/*
	 * User profile
	 */
	'achievements-earned' => 'This badge has been earned by {{PLURAL:$1|1 user|$1 users}}.',
	'achievements-profile-title' => '$1\'s $2 Earned {{PLURAL:$2|Badge|Badges}}',
	'achievements-profile-title-no' => '$1\'s Badges',
	'achievements-profile-title-challenges' => 'More Badges You Can Earn!',
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
	'achievements-recent-platinum' => 'Recent Platinum Badges',
	'achievements-recent-gold' => 'Recent Gold Badges',
	'achievements-recent-silver' => 'Recent Silver Badges',
	'achievements-recent-bronze' => 'Recent Bronze Badges',
	'achievements-recent-info' => '<a href="$1">$2</a> earned the &ldquo;$3&rdquo; badge $4',

	/*
	 * AchievementsCustomize
	 */
	'achievements-send' => 'Save picture',
	'achievements-save' => 'Save changes',
	'achievements-reverted' => 'Badge reverted to original.',
	'achievements-customize' => 'Customize picture',
	'achievements-enable-track' => 'enabled',
	'achievements-revert' => 'Revert to default',
	'achievements-special-saved' => 'Changes saved.',
	'achievements-special' => 'Special Achievements',
	'achievements-secret' => 'Secret Achievements',
	'achievementscustomize' => 'Customize Badges',
	'achievements-about-title' => 'About this page...',
	'achievements-about-content' => 'Administrators on this wiki can customize the names and pictures of the achievement badges.
	
You can upload any .jpg or .png picture, and your picture will automatically fit inside the frame.
It works best when your picture is square, and when the most important part of the picture is right in the middle.

You can use rectangular pictures, but you might find that a bit gets cropped out by the frame.
If you have a graphics program, then you can crop your picture to put the important part of the image in the center.
If you do no have a graphics program, then just experiment with different pictures until you find the ones that work for you!
If you do not like the picture that you have chosen, click "{{int:achievements-revert}}" to go back to the original graphic.

You can also give the badges new names that reflect the topic of the wiki. When you have changed badge names, click "{{int:achievements-save}}" to save your changes.
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

Once you have done the customization, click the "enabled" checkbox to turn on the new track, and then click "{{int:achievements-save}}".
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
	
You have just been awarded with the '$2' Platinum badge on $4 ($3). This adds 250 points to your score!

Check out your fancy new badge on your user profile page:

$5",
	'achievements-community-platinum-awarded-email-body-html' => "<strong>Congratulations $1!</strong><br/><br/>
You have just been awarded with the '<strong>$2</strong>' Platinum badge on <a href=\"$3\">$4</a>. This adds 250 points to your score!<br/><br/>
Check out your fancy new badge on your <a href=\"$5\">user profile page</a>.",
	'achievements-community-platinum-awarded-for' => 'Awarded for',
	'achievements-community-platinum-how-to-earn' => 'How to earn',
	'achievements-community-platinum-awarded-for-example' => 'e.g. "for doing..."',
	'achievements-community-platinum-how-to-earn-example' => 'e.g. "make 3 edits..."',
	'achievements-community-platinum-badge-image' => 'Badge image',
	'achievements-community-platinum-awarded-to' => 'Awarded to',
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
	'achievements-badge-name-blogpost-0' => 'Something to Say',
	'achievements-badge-name-blogpost-1' => 'Five Things to Say',
	'achievements-badge-name-blogpost-2' => 'Talk Show',
	'achievements-badge-name-blogpost-3' => 'Life of the Party',
	'achievements-badge-name-blogpost-4' => 'Public Speaker',

	// blogcomment track
	'achievements-badge-name-blogcomment-0' => 'Opinionator',
	'achievements-badge-name-blogcomment-1' => 'And One More Thing',

	// love track
	'achievements-badge-name-love-0' => 'Key to the Wiki!',
	'achievements-badge-name-love-1' => 'Two Weeks on the Wiki',
	'achievements-badge-name-love-2' => 'Devoted',
	'achievements-badge-name-love-3' => 'Dedicated',
	'achievements-badge-name-love-4' => 'Addicted',
	'achievements-badge-name-love-5' => 'A Wiki Life',
	'achievements-badge-name-love-6' => 'Wiki Hero!',

	// not in track
	'achievements-badge-name-welcome' => 'Welcome to the Wiki',
	'achievements-badge-name-introduction' => 'Introduction',
	'achievements-badge-name-sayhi' => 'Stopping By to Say Hi',
	'achievements-badge-name-creator' => 'The Creator',
	'achievements-badge-name-pounce' => 'Pounce!',
	'achievements-badge-name-caffeinated' => 'Caffeinated',
	'achievements-badge-name-luckyedit' => 'Lucky Edit',

	/*
	 * Badges' details for challenges list on user profile
	 */
	'achievements-badge-to-get-edit' => 'make $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a page|pages}}',
	'achievements-badge-to-get-edit-plus-category' => 'make $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a|}} $2 {{PLURAL:$1|page| pages}}',
	'achievements-badge-to-get-picture' => 'add $1 {{PLURAL:$1|picture|pictures}} to {{PLURAL:$1|a page|pages}}',
	'achievements-badge-to-get-category' => 'add $1 {{PLURAL:$1|page|pages}} to {{PLURAL:$1|a category|categories}}',
	'achievements-badge-to-get-blogpost' => 'write $1 {{PLURAL:$1|blog post|blog posts}}',
	'achievements-badge-to-get-blogcomment' => 'write a comment on $1 different blog posts',
	'achievements-badge-to-get-love' => 'contribute to the wiki every day for $1 days',
	'achievements-badge-to-get-welcome' => 'join the wiki',
	'achievements-badge-to-get-introduction' => 'add to your own user page',
	'achievements-badge-to-get-sayhi' => 'leave someone a message on their talk page',
	'achievements-badge-to-get-creator' => 'be the creator of this wiki',
	'achievements-badge-to-get-pounce' => 'be quick',
	'achievements-badge-to-get-caffeinated' => 'make $1 edits on pages in a single day',
	'achievements-badge-to-get-luckyedit' => 'be lucky',

	/*
	 * Badges' details for challenges list hovers on user profile
	 */
	'achievements-badge-to-get-edit-details' => 'Is something missing? Is there a mistake? Don\'t be shy. Click the edit button and you can add to any page!',
	'achievements-badge-to-get-edit-plus-category-details' => 'The <strong>$1</strong> pages need your help! Click the edit button on any page in that category to help out. Show your support for the $1 pages!',
	'achievements-badge-to-get-picture-details' => 'Click the edit button, and then the Add a picture button. You can add a photo from your computer, or from another page on the wiki.',
	'achievements-badge-to-get-category-details' => 'Categories are tags that help readers find similar pages. Click the Add category button at the bottom of a page to list that page in a category.',
	'achievements-badge-to-get-blogpost-details' => 'Write your opinions and questions! Click on Recent blog posts in the sidebar, and then the link on the left for Create a new blog post.',
	'achievements-badge-to-get-blogcomment-details' => 'Add your two cents! Read any of the recent blog posts, and write your thoughts in the comments box.',
	'achievements-badge-to-get-love-details' => 'The counter resets if you miss a day, so be sure to come back to the wiki every day!',
	'achievements-badge-to-get-welcome-details' => 'Click the Create an account button at the top right to join the community. You can start earning your own badges!',
	'achievements-badge-to-get-introduction-details' => 'Is your user page empty? Click on your user name at the top of the screen to see. Click edit to add some information about yourself!',
	'achievements-badge-to-get-sayhi-details' => 'You can leave other people messages by clicking "Leave message" on their talk page. Ask for help, thank them for their work, or just say hi!',
	'achievements-badge-to-get-creator-details' => 'This badge is given to the person who founded the wiki. Click the Create a new wiki button at the top to start a site about whatever you like most!',
	'achievements-badge-to-get-pounce-details' => 'You have got to be quick to earn this badge. Click the Activity feed button to see the new pages that people are creating!',
	'achievements-badge-to-get-caffeinated-details' => 'It takes a busy day to earn this badge. Keep editing!',
	'achievements-badge-to-get-luckyedit-details' => 'You have got to be lucky to earn this badge. Keep editing!',
	'achievements-badge-to-get-community-platinum-details' => 'This is a special Platinum badge that is only available for a limited time!',

	/*
	 * Badges' details for badges list hovers on user profile
	 */
	'achievements-badge-hover-desc-edit' => 'for making $1 {{PLURAL:$1|edit|edits}}<br />
on {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-hover-desc-edit-plus-category' => 'for making $1 {{PLURAL:$1|edit|edits}}<br />
on {{PLURAL:$1|a|}} $2 {{PLURAL:$1|page| pages}}!',
	'achievements-badge-hover-desc-picture' => 'for adding $1 {{PLURAL:$1|picture|pictures}}<br />
to {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-hover-desc-category' => 'for adding $1 {{PLURAL:$1|page|pages}}<br />
to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-hover-desc-blogpost' => 'for writing $1 {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-hover-desc-blogcomment' => 'for writing a comment<br />
on $1 different {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-hover-desc-love' => 'for contributing to the wiki every day for $1 days!',
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
	'achievements-badge-your-desc-edit' => 'for making {{PLURAL:$1|your first|$1}} {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-your-desc-edit-plus-category' => 'for making {{PLURAL:$1|your first|$1}} {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a|}} $2 {{PLURAL:$1|page| pages}}!',
	'achievements-badge-your-desc-picture' => 'for adding {{PLURAL:$1|your first|$1}} {{PLURAL:$1|picture|pictures}} to {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-your-desc-category' => 'for adding {{PLURAL:$1|your first|$1}} {{PLURAL:$1|page|pages}} to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-your-desc-blogpost' => 'for writing {{PLURAL:$1|your first|$1}} {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-your-desc-blogcomment' => 'for writing a comment on $1 different blog posts!',
	'achievements-badge-your-desc-love' => 'for contributing to the wiki every day for $1 days!',
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
	'achievements-badge-desc-edit-plus-category' => 'for making $1 {{PLURAL:$1|edit|edits}} on {{PLURAL:$1|a|}} $2 {{PLURAL:$1|page| pages}}!',
	'achievements-badge-desc-picture' => 'for adding $1 {{PLURAL:$1|picture|pictures}} to {{PLURAL:$1|a page|pages}}!',
	'achievements-badge-desc-category' => 'for adding $1 {{PLURAL:$1|page|pages}} to {{PLURAL:$1|a category|categories}}!',
	'achievements-badge-desc-blogpost' => 'for writing $1 {{PLURAL:$1|blog post|blog posts}}!',
	'achievements-badge-desc-blogcomment' => 'for writing a comment on $1 different blog posts!',
	'achievements-badge-desc-love' => 'for contributing to the wiki every day for $1 days!',
	'achievements-badge-desc-welcome' => 'for joining the wiki!',
	'achievements-badge-desc-introduction' => 'for adding to your own user page!',
	'achievements-badge-desc-sayhi' => 'for leaving a message on someone else\'s talk page!',
	'achievements-badge-desc-creator' => 'for creating the wiki!',
	'achievements-badge-desc-pounce' => 'for making edits on 100 pages within an hour of the page\'s creation!',
	'achievements-badge-desc-caffeinated' => 'for making 100 edits on pages in a single day!',
	'achievements-badge-desc-luckyedit' => 'for making the Lucky $1th edit on the wiki!',
);

$messages['qqq'] = array(
	'achievements-track-name-edit' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-track-name-picture' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-track-name-category' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-track-name-blogpost' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-track-name-blogcomment' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-track-name-love' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-profile-title' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-profile-title-no' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-profile-title-challenges' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-recent-platinum' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-recent-gold' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-recent-silver' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-recent-bronze' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-badge-name-edit-0' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-edit-1' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-edit-2' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-edit-3' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-edit-4' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-edit-5' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-edit-6' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-edit-7' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-badge-name-category-0' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-category-1' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-category-3' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-category-5' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-category-6' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-badge-name-blogpost-0' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-blogpost-1' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-blogpost-2' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-blogpost-3' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-blogpost-4' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-badge-name-blogcomment-1' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-badge-name-love-0' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-love-1' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-love-5' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-love-6' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-badge-name-welcome' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-sayhi' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-creator' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	'achievements-badge-name-luckyedit' => 'Capitalization has been requested by Product Management, please don\'t changeit',
	
	'achievements-badge-to-get-sayhi-details' => 'The word "people" has been requested by Product Management, please don\'t changeit',

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
	'achievements-recent-info' => "* $1 = link to user page
* $2 = user's name
* $3 = name of badge
* $4 = description what was necessary to get the badge",
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'achievements-gold' => 'Aour',
	'achievements-viewall' => 'Gwelet pep tra',
	'achievements-viewless' => 'Serriñ',
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
 * @author Crazymadlover
 */
$messages['es'] = array(
	'achievementsii-desc' => 'Un sistema de insignias para los usuarios del wiki',
	'achievements-non-existing-category' => 'La categoría especificada no existe.',
	'achievements-platinum' => 'Platino',
	'achievements-gold' => 'Oro',
	'achievements-silver' => 'Plata',
	'achievements-bronze' => 'Bronce',
	'achievements-masthead-points' => '$1 <small>{{PLURAL:$1|punto|puntos}}</small>',
	'achievements-points' => '$1 {{PLURAL:$1|punto|puntos}}',
	'achievements-points-with-break' => '$1<br />{{PLURAL:$1|punto|puntos}}',
	'achievements-viewall' => 'ver todo',
	'achievements-viewless' => 'Cerrar',
	'achievements-recent-platinum' => 'Insignias de platino recientes',
	'achievements-recent-gold' => 'Insignias de oro recientes',
	'achievements-recent-silver' => 'Insignias de plata recientes',
	'achievements-recent-bronze' => 'insignias de bronce recientes',
	'achievements-recent-info' => '<a href="$1">$2</a> ganó la &ldquo;$3&rdquo; insignia $4',
	'achievements-send' => 'Grabar imagen',
	'achievements-save' => 'grabar cambios',
	'achievements-customize' => 'Personalizar foto',
	'achievements-revert' => 'Revertir al que está por defecto',
	'achievements-special-saved' => 'Cambios grabados',
	'achievements-special' => 'Logros especiales',
	'achievements-secret' => 'Logros secretos',
	'achievementscustomize' => 'Personalizar insignias',
	'achievements-about-title' => 'Acerca de esta página...',
	'platinum' => 'Platino',
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
	'achievements-badge-name-category-2' => 'Explorador',
	'achievements-badge-name-category-3' => 'Guía turística',
	'achievements-badge-name-category-4' => 'Navegante',
	'achievements-badge-name-category-5' => 'Constructor de Puentes',
	'achievements-badge-name-category-6' => 'Planificador Wiki',
	'achievements-badge-name-blogpost-0' => 'Algo que decir',
	'achievements-badge-name-blogpost-1' => 'Cinco cosas que decir',
	'achievements-badge-name-blogpost-2' => 'Show de la conversación',
	'achievements-badge-name-blogcomment-1' => 'Y una cosa más',
	'achievements-badge-name-love-1' => 'Dos semanas en el wiki',
	'achievements-badge-name-love-2' => 'Devoto',
	'achievements-badge-name-love-3' => 'Dedicado',
	'achievements-badge-name-love-4' => 'Adicto',
	'achievements-badge-name-love-6' => 'Héroe Wiki',
	'achievements-badge-name-welcome' => 'Bienvenido al wiki',
	'achievements-badge-name-introduction' => 'Introducción',
	'achievements-badge-name-sayhi' => 'Deteniendo para decir hola',
	'achievements-badge-name-creator' => 'El creador',
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
 * @author Peter17
 */
$messages['fr'] = array(
	'achievements-upload-error' => "Désolé !
Cette image ne fonctionne pas.
Veuillez vous assurer qu’il s'agit bien d'un fichier .jpg ou .png.
Si cela ne fonctionne toujours pas, c'est peut-être que l’image est trop lourde.
Merci d'en essayer une autre !",
	'achievements-platinum' => 'Platine',
	'achievements-gold' => 'Or',
	'achievements-silver' => 'Argent',
	'achievements-bronze' => 'Bronze',
	'platinum' => 'Platine',
	'achievements-badge-name-edit-0' => 'Fait la différence',
	'achievements-badge-name-edit-1' => 'Ce n’est que le début',
	'achievements-badge-name-edit-2' => 'Fait son trou',
	'achievements-badge-name-edit-3' => 'Ami du wiki',
	'achievements-badge-name-edit-4' => 'Collaborateur',
	'achievements-badge-name-edit-5' => 'Constructeur de wiki',
	'achievements-badge-name-edit-6' => 'Leader de wiki',
	'achievements-badge-name-edit-7' => 'Expert en wiki',
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
	'leaderboard-intro' => '<b>&ldquo;Што се „Достигнувања“?&rdquo;</b> Со учесто на ова вики можете да заработите специјални значки! Секоја заработена значка ви носи бодови кон вкупното салдо: бронзените значки носат 10 бода, сребрените значки носат 50 бода, а златните носат 100 бода.<br /><br />
Кога ќе се зачлените на викито, на корисничкиот профил се истакнати значките што сте ги заработиле, како и список на предизвиците кои ви се достапни. [[Special:MyPage|Одете на вашиот кориснички профил и погледајте!]]',
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
	'achievements-revert' => 'Врати по основно',
	'achievements-special-saved' => 'Промените се зачувани.',
	'achievements-special' => 'Специјални достигнувања',
	'achievements-secret' => 'Тајни достигнувања',
	'achievementscustomize' => 'Прилагоди значки',
	'achievements-about-title' => 'За страницава...',
	'achievements-about-content' => 'Администраторите на ова вики можат да ги прилагодуваат (менуваат) називите и сликите на значките за достигнувања.<br /><br />
Можете да подигнете било која .jpg или .png слика, и истата автоматски ќе биде сместена во рамката. Ова најдобро работи ако сликата е квадратна, и кога најважниот дел од неа е точно во средината.<br /><br />
Можете да користите и правоаголни слики, но знајте дека рамката ќе засече делови од неа. Доколку имате графички програм, тогаш можете да ја кадрирате сликата за да го поставите важниот дел во средината. Ако немате, тогаш едноставно пробувајте разни слики, додека не ја најдете таа што највеќе ви одговара! Ако не ви се допаѓа одбраната слика, кликнете на „Врати по основно“ за да ја вратите првично зададената слика.<br /><br />
Значките можете да ги именувате со нови називи соодветни на тематиката на викито. Кога сте готови со преименувањето, кликнете на „Зачувај промени“. Ви пожелуваме пријатни мигови!',
	'achievements-edit-plus-category-track-name' => '$1 лента за уредување',
	'achievements-create-edit-plus-category-title' => 'Создај нова Лента за уредување',
	'achievements-create-edit-plus-category-content' => 'Можете да создадете нов комплет од значки со кои ќе се наградуваат корисниците за нивните уредувања на страници во дадена категорија, за да се нагласи извесен дел мрежното место каде корисниците би сакале да работат. Можете да создадете повеќе од една лента со категории, па затоа одберете две категории преку кои корисниците би можеле да ги покажат своите стручности! Потпалете соперништво меѓу корисниците кои уредуваат страници за Вампири и они што уредуваат Врколаци, or Волшебници и Нормалци, или Автботови и Десептикони.<br /><br />
За да создадете нова лента „Уредување во категорија“, внесете го името на категоријата во долунаведеното поле. Обичната лента за Уредување ќе си постои и понатаму; ова ќе создаде засебна лента што можете посебно да ја прилагодите.<br /><br />
Кога ќе ја создадете лентата, новите значки ќе се појават на лево на списокот, под редовната лента за Уредување. Изменете ги називите и сликите а новата лента, така што сите корисници можат да ја видат разликата!<br /><br />
Кога ќе завршите со прилагодувањето, кликнете на кутивчето „овозможено“ за да ја пуштите (овозможите) новата лента, а потоа кликнете на „Зачувај промени“. Новата лента ќе им се појави на профилите на корисниците, и тие ќе почнат да заработуваат значки со уредување на страници од таа категорија. Можете и да ја оневозможите лентата подоцна, кога ќе решите дека повеќе не сакате да ја истакнувате таа категорија. Корисниците што имаат заработено значки од таа лента ќе си ги зачуваат засекогаш, дури и по нејзиното оневозможување.<br /><br />
Со ова достигнувањата ќе ги збогатите и со забава. Пробајте!',
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
	'achievements-badge-to-get-edit-details' => 'Има нешто што недостасува? Да не има некоја грешка? Не се стегајте. Кликнете на копчето за уредување и додавајте на која било страница!',
	'achievements-badge-to-get-edit-plus-category-details' => 'Потребна е вашата помош на страниците за <strong>$1</strong>! Кликнете на копчето за уредување на некоја страница од таа категорија за да помогнете. Искажете ја вашата поддршка за страниците за $1!',
	'achievements-badge-to-get-picture-details' => 'Кликнете на копчето за уредување, а потоа на копчето „Додај слика“. Можете да додадете слика од вашиот сметач, или од друга страница на викито.',
	'achievements-badge-to-get-category-details' => 'Категориите претставуваат ознаки што им помагаат на корисниците да пронајдат слични страници. Кликнете на копчето „Додај категорија“ на дното од страницата за да ја заведете страницата во категорија.',
	'achievements-badge-to-get-blogpost-details' => 'Запишете ги вашите мислења и прашања! Кликнете на „Скорешни блог-записи“ во страничната лента, а потоа на врската лево „Создај нов блог-запис“.',
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
	'achievements-profile-title-challenges' => 'Meer te verdienen speldjes!',
	'achievements-profile-customize' => 'Speldjes aanpassen',
	'achievements-ranked' => 'Op plaats $1 in de ranglijst van deze wiki',
	'achievements-viewall' => 'Allemaal bekijken',
	'achievements-viewless' => 'Sluiten',
	'leaderboard-intro' => '<b>&ldquo;Wat zijn prestaties?&rdquo;</b> U kunt speciale speldjes verdienen door deel te nemen aan deze wiki! Met ieder speldje dat u verdient loopt uw totaalscore op. Bronzen speldjes zijn 10 punten waard, zilverren speldjes zijn 50 punten waard en gouden speldjes zijn 100 punten waard.<br /><br />
Als u bij de wiki komt, wordt in uw gebruikersprofiel aangegeven welke speldjes u verdiend hebt en de lijst met uitdagingen die u nog kunt voltooien. [[Special:MyPage|Ga naar uw gebruikersprofiel voor details]]!',
	'leaderboard' => 'Scorebord prestaties',
	'achievements-recent-platinum' => 'Recente platina speldjes',
	'achievements-recent-gold' => 'Recente gouden speldjes',
	'achievements-recent-silver' => 'Recente zilveren speldjes',
	'achievements-recent-bronze' => 'Recente bronzen speldjes',
	'achievements-send' => 'Afbeelding opslaan',
	'achievements-save' => 'Wijzigingen opslaan',
	'achievements-customize' => 'Afbeelding aanpassen',
	'achievements-special-saved' => 'De wijzigingen zijn opgeslagen.',
	'achievements-special' => 'Speciale prestaties',
	'achievements-secret' => 'Geheime prestaties',
	'achievementscustomize' => 'Speldjes aanpassen',
	'achievements-about-title' => 'Over deze pagina...',
	'achievements-create-edit-plus-category' => 'Dit traject aanmaken',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'U hebt een nieuw platina speldje verdiend!',
	'achievements-badge-name-edit-0' => 'Het verschil maken',
	'achievements-badge-name-edit-1' => 'Nog maar het begin',
	'achievements-badge-name-edit-2' => 'Uw stempel zetten',
	'achievements-badge-name-edit-3' => 'Vriend van de wiki',
	'achievements-badge-name-edit-4' => 'Samenwerker',
	'achievements-badge-name-edit-5' => 'Wikibouwer',
	'achievements-badge-name-edit-6' => 'Wikileider',
	'achievements-badge-name-edit-7' => 'Wikiexpert',
	'achievements-badge-name-category-2' => 'Onderzoeker',
	'achievements-badge-name-category-3' => 'Gids',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-love-2' => 'Verknocht',
	'achievements-badge-name-love-3' => 'Toegewijd',
	'achievements-badge-name-love-4' => 'Verslaafd',
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
	'achievements-track-name-edit' => 'Rediger spor',
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
	'leaderboard-intro' => '<b>&ldquo;Hva er utmerkelser?&rdquo;</b> Du kan motta spesielle utmerkelser ved å delta på denne wikien! Hver utmerkelse du kan oppnå gir poeng til den totale poengsummen sin: Bronseutmerkelser er verdt 10 poeng, Sølvutmerkelser er verdt 50 poeng, og Gullutmerkelser er verdt 100 poeng.<br /><br />
Når du blir med i wikien, viser brukerprofilen din de utmerkelsene du har mottatt, og viser en liste over de utfordringene som er tilgjengelige for deg. [[Special:MyPage|Gå til brukerprofilen din og sjekk det ut!]]',
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
	'achievements-revert' => 'Tilbakestill til standard',
	'achievements-special-saved' => 'Endringer lagret.',
	'achievements-special' => 'Spesialutmerkelser',
	'achievements-secret' => 'Hemmelige utmerkelser',
	'achievementscustomize' => 'Tilpass utmerkelser',
	'achievements-about-title' => 'Om denne siden...',
	'achievements-about-content' => 'Administratorer på denne wikien kan tilpasse navn og bilde for utmerkelsene.<br /><br />
Du kan laste opp ethvert .jpg- eller .png-bilde, og bildet vil automatisk passe inn i rammen. Det fungerer best når bildet er kvadratisk, og når den viktigste delene av bildet er i midten.<br /><br />
Du kan bruke rektangulære bilder, men vil kanskje oppleve at biter vil bli fjernet av rammen. Hvis du har et grafikkprogram, kan du beskjære bildet for å plassere den viktigste delen av bildet i midten. Hvis du ikke har det, kan du eksperimentere med forskjellige bilder til du finner det som passer deg best! Hvis du ikke liker bildet du har valgt, trykker du «Tilbakestill til standard» for å gå tilbake til den ordinære grafikken.<br /><br />
Du kan også gi utmerkelsene nye navn som reflekterer wikiens tema. Når du har endret navn for utmerkelser, trykker du «Lagre endringer» for å lagre endringene. Ha det gøy!',
	'achievements-edit-plus-category-track-name' => '$1 rediger spor',
	'achievements-create-edit-plus-category-title' => 'Opprett et nytt Rediger spor',
	'achievements-create-edit-plus-category-content' => 'Du kan opprette et nytt sett utmerkelser som belønner brukere for å redigere sider i en bestemt kategori, for å markere et bestemt område av siden brukerne vil sette pris på. Du kan sette opp fler enn et kategorispor, så prøv å velge to kategorier som lar brukerne vise frem sine spesialiteter! Sett i gang en rivalisering mellom brukerne som redigerer vampyrsider og brukerne som redigerer varulvsider, eller trollmenn og gomper, eller Autoboter og Decepticoner.<br /><br />
For å lage et nytt «Rediger-i-kategori»-spor, skriv inn navnet på kategorien i feltet nedenfor. Den vanlige Rediger spor vil fremdeles eksistere; dette vil opprette et separat spor som du kan tilpasse separat.<br /><br />
Når sporet er opprettet, vil den nye utmerkelsen vises i lista til venstre, under den vanlige Rediger spor. Tilpass navnene og bildene for det nye sporet, slik at brukerne kan se forskjellen!<br /><br />
Så fort du er ferdig med tilpasningen, trykk på «påskrudd»-boksen for å skru på det nye sporet, og trykk deretter «Lagre endringer». Brukere vil se det nye sporet på brukerprofilene sine, og du vil begynne å motta utmerkelser når de redigerer sider i den kategorien. Du kan også skru av sporet senere, hvis du beslutter at du ikke vil markere kategorien lenger. Brukere som har mottatt utmerkelser i det sporet vil alltid beholde utmerkelsene, selv om sporet er deaktivert.<br /><br /> 
Dette kan skape et helt nytt nivå av moro for utmerkelsene. Prøv det ut!',
	'achievements-create-edit-plus-category' => 'Opprett dette sporet',
	'platinum' => 'Platina',
	'achievements-community-platinum-awarded-email-subject' => 'Du har blitt tildelt en ny Platinautmerkelse!',
	'achievements-community-platinum-awarded-email-body-text' => "Gratulerer $1!

Du har nettopp blitt tildelt '$2'-Platinautmerkelsen på $4 ($3). Dette legger 250 poeng til summen din!

Sjekk ut den stilige nye utmerkelsen din på brukerprofilen din:

$5",
	'achievements-community-platinum-awarded-email-body-html' => '<strong>Gratulerer $1</strong><br/><br/>
Du har nettopp blitt tildelt \'<strong>$2</strong>\'-Platinautmerkelsen på <a href="$3">$4</a>. Dette legger 250 poeng til summen din!
<br/><br/>
Sjekk ut den stilige nye utmerkelsen din på <a href="$5">brukerprofilen din</a>.',
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
	'achievements-badge-to-get-edit-details' => 'Mangler noe? Er det en feil? Ikke vær sjenert. Trykk på rediger-knappen og du kan legge til noe på enhver side!',
	'achievements-badge-to-get-edit-plus-category-details' => '<strong>$1</strong>-sidene trenger din hjelp! Trykk på rediger-knappen på enhver side i denne kategorien for å hjelpe til. Vis din støtte for de $1 sidene!',
	'achievements-badge-to-get-picture-details' => 'Trykk på rediger-knappen, og så trykk på Legg til en bilde-knappen. Du kan legge til et bilde fra datamaskinen din, eller fra en annen side på wikien.',
	'achievements-badge-to-get-category-details' => 'Kategorier er navnelapper som hjelper leserne å finne lignende sider. Trykk på Legg til kategori-knappen på bunnen av en side for å legge den til en kategori.',
	'achievements-badge-to-get-blogpost-details' => 'Skriv dine meninger og spørsmål! Trykk på Siste blogginnlegg i sidepanelet, og så lenken til venstre for Opprett et nytt blogginnlegg.',
	'achievements-badge-to-get-blogcomment-details' => 'Legg til din mening! Les et hvilken som helst av de siste blogginnleggene, og skriv dine tanker i kommentarfeltet.',
	'achievements-badge-to-get-love-details' => 'Telleren tilbakestilles hvis du går glipp av en dag, så sørg for å komme tilbake til wikien hver dag!',
	'achievements-badge-to-get-welcome-details' => 'Trykk på Opprett en konto-knappen øverst til høyre for å bli med i fellesskapet. Du kan begynne å motta egne utmerkelser!',
	'achievements-badge-to-get-introduction-details' => 'Er brukersiden din tom? Trykk på brukernavnet ditt på toppen av skjermen for å sjekke. Trykk rediger for å legge til litt informasjon om deg selv!',
	'achievements-badge-to-get-sayhi-details' => 'Du kan legge igjen beskjeder til andre brukere ved å trykke «Legg igjen beskjed» på diskusjonssiden deres. Spør etter hjelp, takk dem for arbeidet deres, eller bare si hei!',
	'achievements-badge-to-get-creator-details' => 'Denne utmerkelsen er gitt til personen som grunnla wikien. Trykk på Opprett en ny wiki-knappen øverst for å starte et nettsted om det du liker best!',
	'achievements-badge-to-get-pounce-details' => 'Du må være rask for å motta denne utmerkelsen. Trykk på Aktivitetsfeed-knappen for å se nye sider som brukere oppretter!',
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