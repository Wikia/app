<?php

/**
* Internationalisation file for the LicensedVideoSwap extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'lvs-page-title' => 'Licensed Video Swap',
	'lvs-callout-header' => 'We\'ve found matches for videos on your wiki in the Wikia Video Library. <br />Replacing your videos with videos from the Wikia Video Library is a good idea because:',
	'lvs-callout-reason-licensed' => 'Wikia videos are licensed for our communities for use on your wikis',
	'lvs-callout-reason-quality' => 'Wikia videos are high quality',
	'lvs-callout-reason-collaborative' => 'Wikia videos are collaborative and can be used across multiple wikis',
	'lvs-callout-reason-more' => 'and more... we will be adding more features and ways to easily use and manage Wikia Libary videos. Stay tuned!',
	'lvs-instructions' => 'This page lists all unlicensed videos on this wiki that we think we have a licensed video match for in the Wikia Video Library. We recommend that you swap out your unlicensed videos for Wikia Video Libary videos, which have been licensed by Wikia for use on your wikis. Please note that the same video may have different video thumbnails so it\'s best to watch the video before you make a decision.',
	'lvs-button-keep' => 'Keep',
	'lvs-button-swap' => 'Swap',
	'lvs-more-suggestions' => '$1 more {{PLURAL:$1|suggestion|suggestions}}',
	'lvs-best-match-label' => 'Best Match from Wikia Video Library',
	'lvs-swap-video-success' => 'Congratulations! You have successfully swapped the existing video with the wikia video. You can check it via [[$1|Link]] [[$2|Undo]]',
	'lvs-keep-video-success' => 'You have chosen to keep your current video. The video will be removed from this list. [[$1|Undo]]',
	'lvs-restore-video-success' => 'You have restored the video to this list.',
	'lvs-error-permission' => 'you cannot swap this video.',
	'lvs-posted-in-label' => 'Current video posted in ',
	'lvs-posted-in-label-none' => 'Current video is not posted in any articles',
	'lvs-posted-in-more' => 'more',
	'lvs-confirm-swap-message' => 'You are about to swap out $1 with $2 on your wiki. This will replace all instances of the video, including any videos embedded in articles. Any changes can be reversed from the file page. Do you want to continue?',
	'lvs-confirm-keep-message' => 'You have chosen not to replace your current video with a licensed Wikia Video Libary video. Do you want to continue?',
	'lvs-no-matching-videos' => 'There are currently no premium videos related to this video',
);

$messages['qqq'] = array(
	'lvs-page-title' => 'This is the page header/title (h1 tag) that is displayed at the top of the page.  This section is temporary and will go away after a certain number of views.',
	'lvs-callout-header' => 'This is some header text that encourages the user to replace unlicensed videos with videos licensed for use on Wikia.  This section is temporary and will go away after a certain number of views. There\'s an optional <br /> tag between the two sentences for purposes of making the header look nicer.',
	'lvs-callout-reason-licensed' => 'This is a bullet point that appears below lvs-callout-header. It explains that Wikia videos are licensed for use on Wikia. This section is temporary and will go away after a certain number of views.',
	'lvs-callout-reason-quality' => 'This is a bullet point that appears below lvs-callout-header.  This section is temporary and will go away after a certain number of views.',
	'lvs-callout-reason-collaborative' => 'This is a bullet point that appears below lvs-callout-header.  This section is temporary and will go away after a certain number of views.',
	'lvs-callout-reason-more' => 'This is a bullet point that appears below lvs-callout-header.  This section is temporary and will go away after a certain number of views.',
	'lvs-instructions' => 'This is the text at the top of the Licensed Video Swap special page that explains to the user what this page is all about. The idea is that users can exchange unlicensed videos for videos licensed for use on Wikia.',
	'lvs-button-keep' => 'This is the text that appears on a button that, when clicked, will keep the non-licensed video as opposed to swapping it out for a licensed video.',
	'lvs-button-swap' => 'This is the text that appears on a button that, when clicked, will swap out a non-licensed video for a licensed video suggested from the wikia video library.',
	'lvs-more-suggestions' => 'This text will appear below a video that is a suggestion for a licensed version of a video that already exists on the wiki.  When clicked, this link will reveal more licensed possible replacements for the non-licensed video.',
	'lvs-best-match-label' => 'This text appears above the licensed video that is considered the best match for replacing a non-licensed video.',
	'lvs-swap-video-success' => 'This text appears after swapping out the video.
* $1 is a link to the file page
* $2 is a link to reverse the replacement',
	'lvs-keep-video-success' => 'This text appears after keeping the video.
* $1 is the title of the video
* $2 is a link to restore the video to the Special page again',
	'lvs-restore-video-success' => 'This text appears after restoring the video to the list.',
	'lvs-error-permission' => 'This text appears if user does not have permission to swap the video.',
	'lvs-posted-in-label' => 'This is the label text that appears before a list of titles in which the video is posted.  Due to design constraints, it comes before the list, so if, when translated, it would otherwise come after the list, please do your best to adjust accordingly.  ex: "Current video posted in: title1, title2, title3."  It is up to you if you want to include a colon at the end.',
	'lvs-posted-in-more' => 'This is the text that is shown after a truncated list of titles in which a video is posted.  When hovered, a full list appears.  When clicked, the user is taken to a page where the full list is displayed.',
	'lvs-confirm-swap-message' => 'This message is show in a modal when a user clicks a button to swap out an un-licensed video for a licensed video. It is a coonfirmation message.',
	'lvs-confirm-keep-message' => 'This message is show in a modal when a user clicks a button to keep an un-licensed video as opposed to swapping it out for a licensed video. It is a coonfirmation message.',
	'lvs-no-matching-videos' => 'Message shown when no video can be found that matches the title of the youtube video we intend to swap',
);