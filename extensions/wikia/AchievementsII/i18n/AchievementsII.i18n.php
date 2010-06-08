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
	'error-no-user-privileges' => 'current user has no privileges to access this functionality',
	'error-cannot-load-as-image' => 'can\'t load uploaded file as an image',
	'error-db-cannot-insert' => 'There were some issues with the database, badge insertion failed',
	'error-db-cannot-update' => 'There were some issues with the database, badge update failed',
	*/

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

	'achievements-track-name-edit' => 'Edit track',
	'achievements-track-name-picture' => 'Pictures track',
	'achievements-track-name-category' => 'Category track',
	'achievements-track-name-blogpost' => 'Blog Post track',
	'achievements-track-name-blogcomment' => 'Blog comment track',
	'achievements-track-name-love' => 'Wiki love track',

	/*
	 * User notifications
	 */
	'achievements-notification-title' => 'Way to go, $1!',
	'achievements-notification-subtitle' => 'You just earned the "$1" badge $2',
	'achievements-notification-link' => '<strong><big>[[Special:MyPage|Click here to see more badges you can earn]]!</big></strong>',
	'achievements-points' => 'points',

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
	'leaderboard-intro' => '<b>&ldquo;What are Achievements?&rdquo;</b> You can earn special badges by participating on this wiki! Each badge that you earn adds points to your total score: Bronze badges are worth 10 points, Silver badges are worth 50 points, and Gold badges are worth 100 points.<br /><br />
When you join the wiki, your user profile displays the badges that you have earned, and shows you a list of the challenges that are available for you. [[Special:MyPage|Go to your user profile to check it out!]]',
	'leaderboard' => 'Achievements leaderboard',
	'achievements-recent-platinum' => 'Recent Platinum badges',
	'achievements-recent-gold' => 'Recent Gold badges',
	'achievements-recent-silver' => 'Recent Silver badges',
	'achievements-recent-bronze' => 'Recent Bronze badges',
	'achievements-recent-info' => '<a href="$1">$2</a> earned the &ldquo;$3&rdquo; badge $4',

	/*
	 * AchievementsCustomize
	 */
	'achievements-send' => 'Save picture',
	'achievements-save' => 'Save changes',
	'achievements-reverted' => 'Badge reverted to original.',
	'achievements-customize' => 'Customize picture',
	'achievements-revert' => 'Revert to default',
	'achievements-special-saved' => 'Changes saved.',
	'achievements-special' => 'Special achievements',
	'achievements-secret' => 'Secret achievements',
	'achievementscustomize' => 'Customize badges',
	'achievements-about-title' => 'About this page...',
	'achievements-about-content' => 'Administrators on this wiki can customize the names and pictures of the achievement badges.<br /><br />
You can upload any .jpg or .png picture, and your picture will automatically fit inside the frame. It works best when your picture is square, and when the most important part of the picture is right in the middle.<br /><br />
You can use rectangular pictures, but you might find that a bit gets cropped out by the frame. If you have a graphics program, then you can crop your picture to put the important part of the image in the center. If you don\'t, then just experiment with different pictures until you find the ones that work for you! If you do not like the picture that you have chosen, click "Revert to default" to go back to the original graphic.<br /><br />
You can also give the badges new names that reflect the topic of the wiki. When you have changed badge names, click "Save changes" to save your changes. Have fun!',

	'achievements-edit-plus-category-track-name' => '$1 edit track',
	'achievements-create-edit-plus-category-title' => 'Create a new Edit track',
	'achievements-create-edit-plus-category-content' => 'You can create a new set of badges that reward users for editing pages in a particular category, to highlight a particular area of the site that users would enjoy working on. You can set up more than one category track, so try choosing two categories that would help users show off their specialty! Ignite a rivalry between the users who edit Vampires pages and the users who edit Werewolves pages, or Wizards and Muggles, or Autobots and Decepticons.<br /><br />
To create a new "Edit in category" track, type the name of the category in the field below. The regular Edit track will still exist; this will create a separate track that you can customize separately.<br /><br />
When the track is created, the new badges will appear in the list on the left, under the regular Edit track. Customize the names and images for the new track, so that users can see the difference!<br /><br />
Once you have done the customization, click the "enabled" checkbox to turn on the new track, and then click "Save changes". Users will see the new track appear on their user profiles, and they will start earning badges when they edit pages in that category. You can also disable the track later, if you decide you do not want to highlight that category anymore. Users who have earned badges in that track will always keep their badges, even if the track is disabled.<br /><br />
This can help to bring another level of fun to the achievements. Try it out!',
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
	'achievements-community-platinum-awarded-email-body-html' => "<strong>Congratulations $1</strong><br/><br/>
You have just been awarded with the '<strong>$2</strong>' Platinum badge on <a href=\"$3\">$4</a>. This adds 250 points to your score!<br/><br/>
Check out your fancy new badge on your <a href=\"$5\">user profile page</a>.",

	/*
	 * Badges' names
	 */

	// edit track
	'achievements-badge-name-edit-0' => 'Making a difference',
	'achievements-badge-name-edit-1' => 'Just the beginning',
	'achievements-badge-name-edit-2' => 'Making your mark',
	'achievements-badge-name-edit-3' => 'Friend of the wiki',
	'achievements-badge-name-edit-4' => 'Collaborator',
	'achievements-badge-name-edit-5' => 'Wiki builder',
	'achievements-badge-name-edit-6' => 'Wiki leader',
	'achievements-badge-name-edit-7' => 'Wiki expert',

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
	'achievements-badge-name-category-0' => 'Make a connection',
	'achievements-badge-name-category-1' => 'Trail blazer',
	'achievements-badge-name-category-2' => 'Explorer',
	'achievements-badge-name-category-3' => 'Tour guide',
	'achievements-badge-name-category-4' => 'Navigator',
	'achievements-badge-name-category-5' => 'Bridge builder',
	'achievements-badge-name-category-6' => 'Wiki planner',

	// blogpost track
	'achievements-badge-name-blogpost-0' => 'Something to say',
	'achievements-badge-name-blogpost-1' => 'Five Things to say',
	'achievements-badge-name-blogpost-2' => 'Talk show',
	'achievements-badge-name-blogpost-3' => 'Life of the party',
	'achievements-badge-name-blogpost-4' => 'Public speaker',

	// blogcomment track
	'achievements-badge-name-blogcomment-0' => 'Opinionator',
	'achievements-badge-name-blogcomment-1' => 'And one more thing',

	// love track
	'achievements-badge-name-love-0' => 'Key to the wiki!',
	'achievements-badge-name-love-1' => 'Two weeks on the wiki',
	'achievements-badge-name-love-2' => 'Devoted',
	'achievements-badge-name-love-3' => 'Dedicated',
	'achievements-badge-name-love-4' => 'Addicted',
	'achievements-badge-name-love-5' => 'A wiki life',
	'achievements-badge-name-love-6' => 'Wiki hero!',

	// not in track
	'achievements-badge-name-welcome' => 'Welcome to the wiki',
	'achievements-badge-name-introduction' => 'Introduction',
	'achievements-badge-name-sayhi' => 'Stopping by to say hi',
	'achievements-badge-name-creator' => 'The creator',
	'achievements-badge-name-pounce' => 'Pounce!',
	'achievements-badge-name-caffeinated' => 'Caffeinated',
	'achievements-badge-name-luckyedit' => 'Lucky edit',

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
	'achievements-badge-to-get-sayhi-details' => 'You can leave other users messages by clicking "Leave message" on their talk page. Ask for help, thank them for their work, or just say hi!',
	'achievements-badge-to-get-creator-details' => 'This badge is given to the person who founded the wiki. Click the Create a new wiki button at the top to start a site about whatever you like most!',
	'achievements-badge-to-get-pounce-details' => 'You have to be quick to earn this badge. Click the Activity feed button to see the new pages that users are creating!',
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
