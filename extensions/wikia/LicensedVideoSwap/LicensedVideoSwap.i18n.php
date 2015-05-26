<?php
/**
 * Internationalisation file for the LicensedVideoSwap extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	'licensedvideoswap-desc' => 'Licensed Video Swap extension',
	'licensedvideoswap' => 'Licensed Video Swap',
	'action-licensedvideoswap' => 'swap unlicensed video',
	'lvs-page-title' => 'Licensed Video Swap',
	'lvs-history-page-title' => 'Licensed Video Swap History',
	'lvs-tooltip-history' => 'Licensed Video Swap Button',
	'lvs-history-button-text' => 'History',
	'lvs-page-header-back-link' => 'Back to Licensed Video Swap',
	'lvs-callout-header' => "We've found matches for videos on your wiki in Wikia Video. <br /> Replacing your videos with videos from Wikia Video is a good idea because:",
	'lvs-match-stats-description' => 'Videos<br />with Matches',
	'lvs-callout-title-licensed' => "100% Licensed",
	'lvs-callout-reason-licensed' => "Wikia Videos are licensed for our communities for use on your wikis",
	'lvs-callout-title-quality' => "High Quality",
	'lvs-callout-reason-quality' => "Wikia Videos are high quality",
	'lvs-callout-title-collaborative' => "Collaborative",
	'lvs-callout-reason-collaborative' => "Wikia Videos are collaborative and can be used across multiple wikis",
	'lvs-callout-reason-more' => 'and more... we will be adding more features and ways to easily use and manage Wikia Videos. Stay tuned!',
	'lvs-instructions-header' => 'How to use this page',
	'lvs-instructions' => "Many of the videos you embed on your wikis become unavailable when they are removed or taken down for copyright violations. That's why Wikia has licensed [[w:c:video|thousands of videos]] for use on your wikis from several content partners. This Special page is an easy way for you to see if we have a licensed copy of the same or similar videos on your wikis. Please note that often the exact same video may have a different video thumbnail so it's best to review the videos before you make a decision. Happy swapping!",
	'lvs-button-keep' => 'Keep',
	'lvs-button-swap' => 'Swap',
	'lvs-button-yes' => 'Yes',
	'lvs-button-no' => 'No',
	'lvs-more-suggestions' => 'More Suggestions',
	'lvs-best-match-label' => 'Best Licensed Match from Wikia Video',
	'lvs-undo-swap' => 'Undo',
	'lvs-undo-keep' => 'Undo',
	'lvs-swap-video-success' => 'Congratulations. The original video has been deleted and all instances of this video, including embeds, have successfully been swapped out with the matching Wikia Video. $1',
	'lvs-keep-video-success' => 'You have chosen to keep your current video. The video has been removed from this list. $1',
	'lvs-restore-video-success' => 'You have restored the video to this list.',
	'lvs-error-permission' => 'You cannot swap this video.',
	'lvs-error-permission-access' => 'You cannot access this page.',
	'lvs-error-invalid-page-status' => 'You cannot restore this video.',
	'lvs-error-already-swapped' => 'This video has already been swapped.',
	'lvs-error-already-kept-forever' => 'This video has already been kept.',
	'lvs-posted-in-label' => 'Current video posted in',
	'lvs-posted-in-label-none' => 'Current video is not posted in any articles',
	'lvs-posted-in-more' => 'more',
	'lvs-confirm-keep-title' => 'Keep Video',
	// confirm-keep-message ultimately goes to $.msg which does not support wiki text so we hardcode the markup
	'lvs-confirm-keep-message' => 'We are continuously adding new licensed videos to <a href="http://video.wikia.com/" target="_blank">Wikia Video</a>. Would you like to see new matches for this video as they become available?',
	'lvs-confirm-undo-swap-title' => 'Confirm Undo',
	'lvs-confirm-undo-swap-message' => 'Are you sure you want to restore the original video?',
	'lvs-confirm-undo-keep-title' => 'Confirm Undo',
	'lvs-confirm-undo-keep-message' => 'Are you sure you want to add this video back into the list?',
	'lvs-no-matching-videos' => 'There are currently no premium videos related to this video',
	'lvs-log-summary' => 'Swapped video from [[{{ns:File}}:$1]] to [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'swapped video',
	'lvs-log-restore' => 'Restored swapped video ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Removed redirected link',
	'lvs-zero-state' => "At this time we have no matching videos from Wikia Video for videos on your wiki. Check back again soon!",
	'lvs-history-swapped' => 'Swapped "$1" with "$2"',
	'lvs-history-swapped-exact' => 'Swapped "$1" with a video of the same name',
	'lvs-history-kept' => 'Kept "$1"',
	'lvs-history-instructions' => "To view the history for all swaps and undos, go to $1.",
	'lvs-no-monobook-support' => "This page is not supported in Monobook. To access it in the Wikia layout, $1. This will not change your layout preference",
	'lvs-click-here' => 'click here',
	'lvs-new-flag' => 'New',
);

/** Message documentation (Message documentation)
 * @author Liuxinyu970226
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = array(
	'licensedvideoswap' => 'Licensed Video Swap short title (for special page listings)
{{Identical|Licensed video swap}}',
	'action-licensedvideoswap' => '{{doc|action}}',
	'lvs-page-title' => 'This is the page header/title (h1 tag) that is displayed at the top of the page.
{{Identical|Licensed video swap}}',
	'lvs-history-page-title' => 'This is the LVS history page header/title (h1 tag) that is displayed at the top of the page.',
	'lvs-tooltip-history' => 'Tooltip Licensed Video Swap Button',
	'lvs-history-button-text' => 'LVS history button text.
{{Identical|History}}',
	'lvs-page-header-back-link' => 'Text for link that brings users back to the Licensed Video Swap page from the history page',
	'lvs-callout-header' => 'This is some header text that encourages the user to replace unlicensed videos with videos licensed for use on Wikia.  This section is temporary and will go away after a certain number of views. There\'s an optional "<br />" tag between the two sentences for purposes of making the header look nicer.',
	'lvs-match-stats-description' => 'Description for numerical counter that shows how many total matched videos are available.

Preceded by total number of videos.',
	'lvs-callout-title-licensed' => 'Title for lvs callout header section.',
	'lvs-callout-reason-licensed' => 'This is a bullet point that appears below lvs-callout-header. It explains that Wikia videos are licensed for use on Wikia. This section is temporary and will go away after a certain number of views.',
	'lvs-callout-title-quality' => 'Title for lvs callout header section.',
	'lvs-callout-reason-quality' => 'This is a bullet point that appears below lvs-callout-header.  This section is temporary and will go away after a certain number of views.',
	'lvs-callout-title-collaborative' => 'Title for lvs callout header section.',
	'lvs-callout-reason-collaborative' => 'This is a bullet point that appears below lvs-callout-header.  This section is temporary and will go away after a certain number of views.',
	'lvs-callout-reason-more' => 'This is a bullet point that appears below lvs-callout-header. This starts as "mid-sentence" because this is the last bullet point in the section and is a continuation of the previous ones in this set, saying basically "...and more". Due to design constraints this needs to be a separate message. This section is temporary and will go away after a certain number of views.',
	'lvs-instructions-header' => 'This is the title of the section on how to use this page.

Followed by:
* {{msg-wikia|Lvs-instructions}}.',
	'lvs-instructions' => 'This is the text at the top of the Licensed Video Swap special page that explains to the user what this page is all about. The idea is that users can exchange unlicensed videos for videos licensed for use on Wikia.

Preceded by the heading {{msg-wikia|Lvs-instructions-header}}.',
	'lvs-button-keep' => 'This is the text that appears on a button that, when clicked, will keep the non-licensed video as opposed to swapping it out for a licensed video.

{{Identical|Keep}}',
	'lvs-button-swap' => 'This is the text that appears on a button that, when clicked, will swap out a non-licensed video for a licensed video suggested from the wikia video library.
{{Identical|Swap}}',
	'lvs-button-yes' => 'Yes (user agrees to keep seeing suggestions for video matches for that video).
{{Identical|Yes}}',
	'lvs-button-no' => 'No, (user decides to "Keep" the video and no longer see matches for it).
{{Identical|No}}',
	'lvs-more-suggestions' => 'This text will appear below a video that is a suggestion for a licensed version of a video that already exists on the wiki.  When clicked, this link will reveal more licensed possible replacements for the non-licensed video.',
	'lvs-best-match-label' => 'This text appears above the licensed video that is considered the best match for replacing a non-licensed video.',
	'lvs-undo-swap' => 'This text appears after swapping out the video to undo the swapping video.
{{Identical|Undo}}',
	'lvs-undo-keep' => 'This text appears after keeping the video to undo the keeping video.
{{Identical|Undo}}',
	'lvs-swap-video-success' => 'This text appears after swapping out the video.
* $1 is a link to the file page
* $2 is a link to reverse the replacement',
	'lvs-keep-video-success' => 'This text appears after keeping the video. Parameters:
* $1 - the title of the video
* $2 - a link to restore the video to the Special page again',
	'lvs-restore-video-success' => 'This text appears after restoring the video to the list.',
	'lvs-error-permission' => 'This text appears if user does not have permission to swap the video.',
	'lvs-error-permission-access' => 'This text appears if user does not have permission to access the page.',
	'lvs-error-invalid-page-status' => 'This text appears if the file is in invalid status',
	'lvs-error-already-swapped' => 'This text appears if the file has already been swapped.',
	'lvs-error-already-kept-forever' => 'This text appears if the file has already been kept.',
	'lvs-posted-in-label' => 'This is the label text that appears before a list of titles in which the video is posted.  Due to design constraints, it comes before the list, so if, when translated, it would otherwise come after the list, please do your best to adjust accordingly. Think of it as a label or a heading followed by bullet points. ex: "Current video posted in: title1, title2, title3."  It is up to you if you want to include a colon at the end.',
	'lvs-posted-in-label-none' => 'Message shown above a video when it is not posted in any articles.',
	'lvs-posted-in-more' => 'This is the text that is shown after a truncated list of titles in which a video is posted.  When hovered, a full list appears.  When clicked, the user is taken to a page where the full list is displayed.
{{Identical|More}}',
	'lvs-confirm-keep-title' => 'This is the heading that is displayed in the confirm keep modal.',
	'lvs-confirm-keep-message' => "This message is show in a modal when a user clicks a button to keep an un-licensed video as opposed to swapping it out for a licensed video. It is a coonfirmation message. Translate the url in the <a> element to proper, would use wiki text but this is going to JavaScript which doesn't support wikitext",
	'lvs-confirm-undo-swap-title' => 'This is the heading that is displayed in the confirm undo swap modal.
{{Identical|Confirm undo}}',
	'lvs-confirm-undo-swap-message' => 'This message is show in a modal to confirm that a user wants to revert a video swap, i.e. the non-premium video they had originally replaced with a premium video will be restored.',
	'lvs-confirm-undo-keep-title' => 'This is the heading that is displayed in the confirm undo keep modal.
{{Identical|Confirm undo}}',
	'lvs-confirm-undo-keep-message' => 'This message is show in a modal to confirm that a user wants to un-keep a video, i.e. they chose to keep a non-premium but then decided to add it back into the list of videos with suggestions for swapping.',
	'lvs-no-matching-videos' => 'Message shown when no video can be found that matches the title of the youtube video we intend to swap',
	'lvs-log-summary' => 'Summary of log message shown in Special:RecentChanges for swapping video.',
	'lvs-log-description' => 'Description of action in Special:RecentChanges (x swapped video y (summary))',
	'lvs-log-restore' => 'log message shown in Special:RecentChanges for restoring swapped video.',
	'lvs-zero-state' => 'This message is displayed if there are no unlicenced videos to review on the licensed video swap page.',
	'lvs-history-swapped' => 'Message shown on the LVS history page for a video that had been swapped for a premium video',
	'lvs-history-swapped-exact' => 'Message shown on the LVS history page when the new video and the swapped video have exactly the same name',
	'lvs-history-kept' => 'Message shown on the LVS history page for a video that was kept as is and not swapped',
	'lvs-history-instructions' => 'This is informational text at the top of the LVS history page. Parameters:
* $1 - a link pointing to [[Special:RecentChanges]]',
	'lvs-no-monobook-support' => 'This message is shown to users who try to access LVS in an unsupported skin.

Parameters:
* $1 - a link which is labeled {{msg-wikia|Lvs-click-here}}',
	'lvs-click-here' => 'Used as <code>$1</code> in {{msg-wikia|Lvs-no-monobook-support}}.',
	'lvs-new-flag' => 'This message is shown in the new flag when the video has new suggestions.
{{Identical|New}}',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Claw eg
 * @author Kuwaity26
 */
$messages['ar'] = array(
	'licensedvideoswap' => 'مبادلة فيديو مرخص',
	'action-licensedvideoswap' => 'مبادلة فيديو غير مرخص',
	'lvs-page-title' => 'مبادلة فيديو مرخص',
	'lvs-history-page-title' => 'تاريخ مبادلة فيديو مرخص',
	'lvs-tooltip-history' => 'زر مبادلة فيديو مرخص',
	'lvs-history-button-text' => 'تاريخ',
	'lvs-page-header-back-link' => 'العودة إلى مبادلة فيديو مرخص',
	'lvs-callout-header' => 'وجدنا نتائج لمقاطع مصورة على الويكي الخاصة بك في ويكيا فيديو. <br /> استبدال مقطعك المصور بمقطع مصور من ويكيا فيديو فكرة جيدة بسبب:',
	'lvs-match-stats-description' => 'نتائج بحث<br />مقاطع مصورة',
	'lvs-callout-title-licensed' => 'مرخص 100%',
	'lvs-callout-reason-licensed' => 'مقاطع ويكيا المصورة مرخصة لمجتمعاتنا لتستخدموها على الويكي الخاصة بكم',
	'lvs-callout-title-quality' => 'جودة عالية',
	'lvs-callout-reason-quality' => 'مقاطع ويكيا المصورة ذات جودة عالية',
	'lvs-callout-title-collaborative' => 'تعاوني',
	'lvs-callout-reason-collaborative' => 'مقاطع ويكيا المصورة تعاونية ويمكن استخدامها على الويكيات المتعددة',
	'lvs-callout-reason-more' => 'والمزيد... سنضيف ميزات أكثر وطرق سهلة الاستخدام وإدراة "ويكيا فيديو". ابقوا معنا!',
	'lvs-instructions-header' => 'كيفية استخدام هذه الصفحة',
	'lvs-instructions' => 'كثير من المقاطع المصورة المضمنة على الويكي الخاصة بك أصبحت غير متاحة عندما تم حذفها بسبب انتهاكات حقوق التأليف والنشر. ولهذا السبب رخصت ويكيا [[w:c:video|آلاف المقاطع المصورة]] للاستخدام على الويكي الخاصة بك من عدة شركاء محتوى. هذه الصفحة الخاصة طريقة سهلة لك لترى إذا ما كان لدينا نسخة مرخصة من الفيديو نفسه أو ما يماثله على الويكي الخاصة بك. لاحظ أن غالبًا نفس الفيديو قد يكون فيديو مصغر مختلف لذا من الأفضل مراجعة الفيديو قبل اتخاذ القرار. مبادلة سعيدة!',
	'lvs-button-keep' => 'احتفظ',
	'lvs-button-swap' => 'بدل',
	'lvs-button-yes' => 'نعم',
	'lvs-button-no' => 'لا',
	'lvs-more-suggestions' => 'المزيد من الاقتراحات',
	'lvs-best-match-label' => 'أفضل نتيجة مرخصة من ويكيا فيديو',
	'lvs-undo-swap' => 'رجوع',
	'lvs-undo-keep' => 'رجوع',
	'lvs-swap-video-success' => 'تهانينا. تمت إزالة الفيديو الأصلي وكافة أمثال هذا الفيديو، بما فيها المضمن، وتم تبدليها بنجاح بالفيدو المطابق من ويكيا فيديو. $1',
	'lvs-keep-video-success' => 'لقد اخترت الاحتفاظ بالفيديو الحالي الخاص بك. لقد أزيل الفيديو من هذه القائمة. $1',
	'lvs-restore-video-success' => 'لقد قمت باستعادة الفيديو إلى هذه القائمة.',
	'lvs-error-permission' => 'لا يمكنك مبادلة هذا الفيديو.',
	'lvs-error-permission-access' => 'لا يمكنك الوصول إلى هذه الصفحة.',
	'lvs-error-invalid-page-status' => 'لا يمكنك استعادة هذا الفيديو.',
	'lvs-error-already-swapped' => 'لقد تم تبديل هذا الفيديو بالفعل.',
	'lvs-error-already-kept-forever' => 'لقد تم الإبقاء على هذا الفيديو بالفعل.',
	'lvs-posted-in-label' => 'الفيديو الحالي منشور',
	'lvs-posted-in-label-none' => 'الفيديو الحالي ليس منشورًا في أي مقال',
	'lvs-posted-in-more' => 'المزيد',
	'lvs-confirm-keep-title' => 'الاحتفاظ بالفيديو',
	'lvs-confirm-keep-message' => 'نحن نضيف باستمرار مقاطع جديدة مرخصة في <a href="http://video.wikia.com/" target="_blank">فيديو ويكيا</a>. هل ترغب في مشاهدة نتائج جديدة مطابقة لهذا الفيديو عندما تصبح متاحة؟',
	'lvs-confirm-undo-swap-title' => 'تأكيد الرجوع',
	'lvs-confirm-undo-swap-message' => 'هل أنت متأكد من أنك تريد استعادة الفيديو الأصلي؟',
	'lvs-confirm-undo-keep-title' => 'تأكيد الرجوع',
	'lvs-confirm-undo-keep-message' => 'هل أنت متأكد من أنك تريد إضافة هذا الفيديو إلى القائمة؟',
	'lvs-no-matching-videos' => 'لا يوجد حاليًا مقاطع استثنائية مرتبطة بهذا الفيديو',
	'lvs-log-summary' => 'فيديو مغير من  [[{{ns:File}}:$1]] إلى [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'تم تغيير الفيديو',
	'lvs-log-restore' => 'فيديو مبدل مستعاد ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'رابط محول محذوف',
	'lvs-zero-state' => 'حاليًا ليس لدينا مقاطع مصورة مطابقة من ويكيا فيديو للمقاطع المصورة على الويكي الخاصة بك. تحقق مجددًا لاحقًا!',
	'lvs-history-swapped' => 'بُدل "$1" مع "$2"',
	'lvs-history-swapped-exact' => 'بُدل "$1" بفيديو بنفس الاسم',
	'lvs-history-kept' => 'احتفظ بـ "$1"',
	'lvs-history-instructions' => 'لرؤية تاريخ كل التبادلات والتراجعات، اذهب إلى $1.',
	'lvs-no-monobook-support' => 'هذه الصفحة ليست مدعمة في مونوبوك. للوصل إليها في تصميم ويكيا، $1. هذا لن يغير تفضيلات تصميمك',
	'lvs-click-here' => 'اضغط هنا',
	'lvs-new-flag' => 'جديد',
);

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'lvs-button-yes' => 'Sí',
	'lvs-button-no' => 'Non',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'lvs-history-button-text' => 'Tarix',
	'lvs-button-yes' => 'Bəli',
	'lvs-button-no' => 'Xeyr',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'lvs-history-button-text' => 'История',
	'lvs-button-yes' => 'Да',
	'lvs-button-no' => 'Не',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'lvs-history-button-text' => 'Istor',
	'lvs-callout-title-quality' => 'Kalite uhel',
	'lvs-callout-title-collaborative' => 'Kenlabourat',
	'lvs-instructions-header' => 'Penaos implijout ar bajenn-mañ',
	'lvs-button-keep' => "Derc'hel",
	'lvs-button-swap' => 'Eskemm',
	'lvs-button-yes' => 'Ya',
	'lvs-button-no' => 'Ket',
	'lvs-more-suggestions' => "muioc'h a ginnigoù", # Fuzzy
	'lvs-undo-swap' => 'Dizober',
	'lvs-undo-keep' => 'Dizober',
	'lvs-restore-video-success' => 'Adlakaet ho peus ar video er roll-mañ.',
	'lvs-error-permission-access' => "Ne c'hallit ket mont d'ar bajenn-mañ.",
	'lvs-error-invalid-page-status' => "Ne c'hallit ket assevel ar video-mañ.",
	'lvs-error-already-kept-forever' => "Dalc'het eo bet ar video-mañ dija.",
	'lvs-posted-in-more' => "muioc'h",
	'lvs-confirm-keep-title' => "Derc'hel ar video",
	'lvs-confirm-undo-swap-title' => 'Kadarnaat an dizober',
	'lvs-confirm-undo-swap-message' => "Ha sur oc'h e fell deoc'h assevel ar video orin ?",
	'lvs-confirm-undo-keep-title' => 'Kardanaat an dizober',
	'lvs-confirm-undo-keep-message' => "Ha dur oc'h e fell deoc'h adlakaat ar video-mañ e-barzh ar roll ?",
	'lvs-history-kept' => 'Dalc\'het "$1"',
	'lvs-click-here' => 'klikañ amañ',
	'lvs-new-flag' => 'Nevez',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Roxas Nobody 15
 * @author Unapersona
 */
$messages['ca'] = array(
	'licensedvideoswap-desc' => "Extensió d'intercanvi de vídeos autoritzada",
	'licensedvideoswap' => 'Llicència Vídeo Swap',
	'action-licensedvideoswap' => 'intercanvi de vídeo sense llicència',
	'lvs-page-title' => 'Llicència Vídeo Swap',
	'lvs-history-page-title' => 'Llicència Vídeo Swap Història',
	'lvs-tooltip-history' => 'Llicència Vídeo Swap Botó',
	'lvs-history-button-text' => 'Historial',
	'lvs-page-header-back-link' => 'De tornada a la Llicència de Vídeo Swap',
	'lvs-callout-header' => 'Hemos encontrado los siguientes videos de tu wiki en Wikia Video. <br /> Sería buena idea reemplazar tus videos desde Wikia Video porque:',
	'lvs-match-stats-description' => 'Vídeos<br />amb resultats',
	'lvs-callout-title-licensed' => '100% Llicenciat',
	'lvs-callout-reason-licensed' => "Wikia Vídeos compta amb llicència per a les nostres comunitats per a l'ús en el seu wikis",
	'lvs-callout-title-quality' => 'Alta qualitat',
	'lvs-callout-reason-quality' => "Wikia Vídeos d'alta qualitat",
	'lvs-callout-title-collaborative' => 'Col·laboració',
	'lvs-callout-reason-collaborative' => 'Wikia Vídeos són de col·laboració i pot ser utilitzat en múltiples wikis',
	'lvs-callout-reason-more' => "i més... anirem afegint més trets i maneres d'utilitzar fàcilment i gestionar Wikia vídeos. Estigueu atents!",
	'lvs-instructions-header' => 'Com utilitzar aquesta pàgina',
	'lvs-instructions' => "Molts dels vídeos que permeten integrar en el seu wikis no estan disponibles quan es retira o baixat per violacions de drets d'autor. És per això que Wikia ha llicenciat [[w:c:video|thousands de vídeos]] per a l'ús en el seu wikis des de diversos socis de continguts. Aquesta pàgina Especial és una manera fàcil per a vostè per veure si tenim una llicència còpia de la mateixa o similar vídeos a la teva wikis. Si us plau, tingueu en compte que sovint el mateix vídeo pot tenir una altra miniatura del vídeo així que el millor és revisar els vídeos abans de prendre una decisió. Feliç el bescanvi!",
	'lvs-button-keep' => 'Mantenir',
	'lvs-button-swap' => 'Cambiar',
	'lvs-button-yes' => 'Sí',
	'lvs-button-no' => 'No',
	'lvs-more-suggestions' => 'Més suggeriments',
	'lvs-best-match-label' => 'Millor amb Llicència Partit de Wikia Vídeo',
	'lvs-undo-swap' => 'Desfés',
	'lvs-undo-keep' => 'Desfés',
	'lvs-swap-video-success' => 'Felicitats. El vídeo original ha estat suprimida i tots els casos d\'aquest vídeo, incloent-hi les insercions, han aconseguit estat intercanviats amb la coincidència de Wikia Vídeo. <span class="notranslate" traduir="no">$1</span>',
	'lvs-keep-video-success' => "Heu seleccionat mantenir el seu corrent de vídeo. El vídeo serà eliminat d'aquesta llista.$1",
	'lvs-restore-video-success' => "Vostè ha restaurat el vídeo d'aquesta llista.",
	'lvs-error-permission' => 'No es pot intercanviar aquest vídeo.',
	'lvs-error-permission-access' => 'No pots accedir a aquesta pàgina',
	'lvs-error-invalid-page-status' => 'Vostè no pot restaurar aquest vídeo.',
	'lvs-error-already-swapped' => "Aquest vídeo ja s'ha canviat.",
	'lvs-error-already-kept-forever' => 'Aquest vídeo ja ha estat guardat.',
	'lvs-posted-in-label' => 'Vídeo actual publicat a',
	'lvs-posted-in-label-none' => 'Vídeo actual no està publicat a articles',
	'lvs-posted-in-more' => 'més',
	'lvs-confirm-keep-title' => 'Mantenir Vídeo',
	'lvs-confirm-keep-message' => 'Estem contínuament afegint nous vídeos amb llicència a <a href="http://video.wikia.com/" target="_blank">Wikia vídeo</a>. T\'agradaria veure vídeos relacionats amb aquest?',
	'lvs-confirm-undo-swap-title' => 'Confirmar que vols desfer',
	'lvs-confirm-undo-swap-message' => 'Esteu segur que voleu restaurar el vídeo original?',
	'lvs-confirm-undo-keep-title' => 'Confirmar que vols desfer?',
	'lvs-confirm-undo-keep-message' => 'Esteu segur que voleu afegir aquest vídeo nou a la llista?',
	'lvs-no-matching-videos' => 'Actualment hi ha cap complement vídeos relacionats amb aquest vídeo',
	'lvs-log-summary' => 'Intercanviat el vídeo de [[{{ns:File}}:$1]] per [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'Vídeo intercambiat',
	'lvs-log-restore' => "S'ha restaurat el vídeo canviat ([[{{ns:File}}:$1]])",
	'lvs-log-removed-redirected-link' => "Eliminat l'enllaç redirigit",
	'lvs-zero-state' => 'En aquest moment no disposem de cap coincidència vídeos de Wikia Vídeo per a vídeos en el seu wiki. Torna aviat!!!',
	'lvs-history-swapped' => 'Intercanviats " $1 "amb" $2 "',
	'lvs-history-swapped-exact' => 'Intercanviats " $1 " amb un vídeo del mateix nom',
	'lvs-history-kept' => 'Manté "<span class="notranslate" traduir="no">$1</span>"',
	'lvs-history-instructions' => "Per visualitzar l'historial de totes els canvis i reversions, aneu a $1.",
	'lvs-no-monobook-support' => "Aquesta pàgina no és compatible amb Monobook. Per accedir a l'skin de Wikia, $1. Això no canviarà la seva preferència de skin",
	'lvs-click-here' => 'feu clic aquí',
	'lvs-new-flag' => 'Nou',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'lvs-history-button-text' => 'Истори',
	'lvs-posted-in-more' => 'кхин дӀа',
);

/** Czech (čeština)
 * @author H4nek
 */
$messages['cs'] = array(
	'lvs-callout-title-quality' => 'Vysoká kvalita',
	'lvs-callout-reason-quality' => 'Wikia videa jsou vysoce kvalitní',
	'lvs-callout-title-collaborative' => 'Kolaborativní',
	'lvs-callout-reason-collaborative' => 'Wikia videa jsou založená na spolupráci a mohou být použita napříč různými wiki',
	'lvs-instructions-header' => 'Jak používat tuto stránku',
	'lvs-button-keep' => 'Ponechat',
	'lvs-button-swap' => 'Zaměnit',
	'lvs-button-yes' => 'Ano',
	'lvs-button-no' => 'Ne',
);

/** German (Deutsch)
 * @author Avatar
 * @author Metalhead64
 */
$messages['de'] = array(
	'licensedvideoswap-desc' => 'Lizenzierte Videotauscherweiterung',
	'licensedvideoswap' => 'Lizenzierter Videoaustausch',
	'action-licensedvideoswap' => 'unlizenziertes Video austauschen',
	'lvs-page-title' => 'Finde passende lizenzierte Videos',
	'lvs-history-page-title' => 'Versionsgeschichte zu Finde passende lizenzierte Videos',
	'lvs-tooltip-history' => 'Ersetze durch lizenziertes Video',
	'lvs-history-button-text' => 'Versionsgeschichte',
	'lvs-page-header-back-link' => 'Zurück zu Finde passende lizenzierte Videos',
	'lvs-callout-header' => 'Wir haben Treffer für Videos in Wikias Video-Bibliothek gefunden. <br /> Es ist eine gute Idee, deine Videos mit Videos aus Wikias Video-Bibliothek auszutauschen, da:',
	'lvs-match-stats-description' => 'Videos<br />mit Treffern',
	'lvs-callout-title-licensed' => '100% Lizenziert',
	'lvs-callout-reason-licensed' => "Wikias Videos sind für die Nutzung in den Wikis unserer Communities '''lizensiert'''.",
	'lvs-callout-title-quality' => 'Hohe Qualität',
	'lvs-callout-reason-quality' => "Wikias Videos liegen in '''hoher Qualität''' vor.",
	'lvs-callout-title-collaborative' => 'Kollaborativ',
	'lvs-callout-reason-collaborative' => "Wikias Videos sind '''kollaborativ''' and können '''wiki-übergreifend genutzt werden'''.",
	'lvs-callout-reason-more' => '... wir weiterhin neue Funktionen und Möglichkeiten zur Nutzung und zur Verwaltung von Wikias Videos hinzufügen. Sei gespannt!',
	'lvs-instructions-header' => 'Wie diese Seite zu benutzen ist',
	'lvs-instructions' => 'Viele der Videos, die du in deinem Wiki einbindest, sind nicht mehr zugreifbar, falls sie aufgrund von Urheberrechtsverstößen entfernt oder gelöscht werden. Aus diesem Grund hat Wikia [[w:c:video|tausende von Videos]] von verschiedenen Partnern lizenziert. Diese Spezialseite ermöglicht dir die einfache Überprüfung, ob wir lizenzierte Video anbieten, die Videos in deinem Wiki entsprechen oder ähnlich sind. Bitte beachte, dass die gleichen Videos oft ein anderes Vorschaubild haben, so dass du am besten kurz in die Videos reinschauen solltest, bevor du eine Entscheidung triffst. Viel Spaß beim Austauschen!',
	'lvs-button-keep' => 'Behalten',
	'lvs-button-swap' => 'Austauschen',
	'lvs-button-yes' => 'Ja',
	'lvs-button-no' => 'Nein',
	'lvs-more-suggestions' => 'Weitere Vorschläge',
	'lvs-best-match-label' => 'Bester Treffer aus Wikias Video-Bibliothek',
	'lvs-undo-swap' => 'Rückgängig machen',
	'lvs-undo-keep' => 'Rückgängig machen',
	'lvs-swap-video-success' => 'Du hast dein Video erfolgreich durch ein Wikia-Video ausgetauscht. Weitere Informationen auf der Dateibeschreibungsseite $1.',
	'lvs-keep-video-success' => 'Du hast dich entschieden, dass aktuelle Video zu behalten. Dieses Video wird von der Liste entfernt. $1',
	'lvs-restore-video-success' => 'Du hast das Video wieder zur Liste hinzugefügt.',
	'lvs-error-permission' => 'Du kannst dieses Video nicht austauschen.',
	'lvs-error-permission-access' => 'Du kannst nicht auf diese Seite zugreifen.',
	'lvs-error-invalid-page-status' => 'Du kannst dieses Video nicht wiederherstellen.',
	'lvs-error-already-swapped' => 'Dieses Video wurde bereits ausgetauscht.',
	'lvs-error-already-kept-forever' => 'Dieses Video wurde bereits beibehalten.',
	'lvs-posted-in-label' => 'Aktuelles Video verwendet in',
	'lvs-posted-in-label-none' => 'Das aktuelle Video wird in keinem Artikel verwendet.',
	'lvs-posted-in-more' => 'weiter',
	'lvs-confirm-keep-title' => 'Video behalten',
	'lvs-confirm-keep-message' => 'Wir fügen ständig neu lizenzierte Videos zu <a href="http://video.wikia.com/" target="_blank">Wikia Video</a> hinzu. Willst du neue Treffer für dieses Video ansehen, wenn sie verfügbar werden?',
	'lvs-confirm-undo-swap-title' => 'Rückgängig machen bestätigen',
	'lvs-confirm-undo-swap-message' => 'Bist du sicher, dass du das Original-Video wiederherstellen möchtest?',
	'lvs-confirm-undo-keep-title' => 'Rückgängig machen bestätigen',
	'lvs-confirm-undo-keep-message' => 'Bist du sicher, dass du dieses Video wieder zur Liste hinzufügen willst?',
	'lvs-no-matching-videos' => 'Momentan gibt es keine ähnlichen Premium-Videos zu diesem Video',
	'lvs-log-summary' => 'Video von [[{{ns:File}}:$1]] zu [[{{ns:File}}:$2]] ausgetauscht',
	'lvs-log-description' => 'getauschtes Video',
	'lvs-log-restore' => 'Ausgetauschtes Video wiederhergestellt ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Weiterleitung entfernt',
	'lvs-zero-state' => 'Momentan haben wir keine passenden Videos in der Video-Bibliothek, die zu Videos in deinem Wiki passen. Schau bald wieder rein!',
	'lvs-history-swapped' => '"$1" durch "$2" ausgetauscht',
	'lvs-history-swapped-exact' => '"$1" durch eine Video gleichen Namens ausgetauscht',
	'lvs-history-kept' => '"$1" beibehalten',
	'lvs-history-instructions' => 'Um den Verlauf aller Austausche und Rückgängigmachungen anzusehen, gehe nach $1.',
	'lvs-no-monobook-support' => 'Diese Seite wird in Monobook nicht unterstützt. Um sie im Wikia-Layout anzusehen, $1. Dies ändert nicht deine Layouteinstellung.',
	'lvs-click-here' => 'hier klicken',
	'lvs-new-flag' => 'Neu',
);

/** Greek (Ελληνικά)
 * @author Astralnet
 */
$messages['el'] = array(
	'lvs-button-yes' => 'Ναι',
	'lvs-button-no' => 'Όχι',
	'lvs-error-permission-access' => 'Δεν έχετε πρόσβαση σε αυτή τη σελίδα.',
);

/** British English (British English)
 * @author Shirayuki
 */
$messages['en-gb'] = array(
	'licensedvideoswap' => 'Licenced Video Swap',
	'action-licensedvideoswap' => 'swap unlicenced video',
	'lvs-page-title' => 'Licenced Video Swap',
	'lvs-history-page-title' => 'Licenced Video Swap History',
	'lvs-tooltip-history' => 'Licenced Video Swap Button',
	'lvs-page-header-back-link' => 'Back to Licenced Video Swap',
	'lvs-callout-title-licensed' => '100% Licenced',
	'lvs-callout-reason-licensed' => 'Wikia Videos are licenced for our communities for use on your wikis',
	'lvs-instructions' => "Many of the videos you embed on your wikis become unavailable when they are removed or taken down for copyright violations. That's why Wikia has licenced [[w:c:video|thousands of videos]] for use on your wikis from several content partners. This Special page is an easy way for you to see if we have a licenced copy of the same or similar videos on your wikis. Please note that often the exact same video may have a different video thumbnail so it's best to review the videos before you make a decision. Happy swapping!",
	'lvs-best-match-label' => 'Best Licenced Match from Wikia Video',
	'lvs-confirm-keep-message' => 'We are continuously adding new licenced videos to <a href="http://video.wikia.com/" target="_blank">Wikia Video</a>. Would you like to see new matches for this video as they become available?',
);

/** Spanish (español)
 * @author Bola
 * @author Macofe
 * @author VegaDark
 */
$messages['es'] = array(
	'licensedvideoswap-desc' => 'Extensión de intercambio de videos autorizados',
	'licensedvideoswap' => 'Intercambio de videos autorizados',
	'action-licensedvideoswap' => 'intercambiar videos autorizados',
	'lvs-page-title' => 'Intercambio de videos autorizados',
	'lvs-history-page-title' => 'Historial de intercambio de videos autorizados',
	'lvs-tooltip-history' => 'Botón de intercambio de videos autorizados',
	'lvs-history-button-text' => 'Historial',
	'lvs-page-header-back-link' => 'Volver a la página de intercambio de videos',
	'lvs-callout-header' => 'Hemos encontrado los siguientes videos de tu wiki en Wikia Video. <br /> Sería buena idea reemplazar tus videos desde Wikia Video porque:',
	'lvs-match-stats-description' => 'Videos<br />con coincidencias',
	'lvs-callout-title-licensed' => '100% autorizado',
	'lvs-callout-reason-licensed' => 'Está autorizado su uso en las comunidades de sus wikis',
	'lvs-callout-title-quality' => 'Alta Calidad',
	'lvs-callout-reason-quality' => "Los videos de Wikia son en '''alta definición'''",
	'lvs-callout-title-collaborative' => 'Colaborativo',
	'lvs-callout-reason-collaborative' => 'Son colaborativos y pueden ser usados en múltiples wikis',
	'lvs-callout-reason-more' => 'y más cosas... añadiremos más funcionalidades y formas de usar y administrador estos vídeos fácilmente. ¡Mantente atento!',
	'lvs-instructions-header' => 'Cómo usar esta página',
	'lvs-instructions' => 'Muchos de los videos que se añaden a vuestros wikis dejan de estar disponibles cuando se borran por violaciones de derechos de autor. Es por esto que Wikia ha subido [[w:c:video|miles de videos]] autorizados por nuestros patrocinadores del contenido. Esta página especial es una forma fácil de ver si hay alguna copia autorizada de un video parecido o igual al de vuestro wiki. Por favor, tened en cuenta que a menudo el mismo video puede tener una miniatura diferente así que es mejor que reviséis el video antes de tomar una decisión. ¡Feliz intercambio!',
	'lvs-button-keep' => 'Mantener',
	'lvs-button-swap' => 'Cambiar',
	'lvs-button-yes' => 'Sí',
	'lvs-button-no' => 'No',
	'lvs-more-suggestions' => 'Más sugerencias',
	'lvs-best-match-label' => 'Mejor resultado desde Wikia Video',
	'lvs-undo-swap' => 'Deshacer',
	'lvs-undo-keep' => 'Deshacer',
	'lvs-swap-video-success' => 'Has reemplazado satisfactoriamente tu video con Wikia Video. Puedes comprobar la página del archivo $1.',
	'lvs-keep-video-success' => 'Has elegido mantener el video actual. El video será retirado de esta lista. $1',
	'lvs-restore-video-success' => 'Has restaurado el video en la lista.',
	'lvs-error-permission' => 'No puedes cambiar este video.',
	'lvs-error-permission-access' => 'No puedes acceder a esta página.',
	'lvs-error-invalid-page-status' => 'No puedes restaurar este video.',
	'lvs-error-already-swapped' => 'Este video ya ha sido cambiado.',
	'lvs-error-already-kept-forever' => 'Este video ya se ha mantenido.',
	'lvs-posted-in-label' => 'Video actualmente publicado en',
	'lvs-posted-in-label-none' => 'El video actual no está publicado en ningún artículo',
	'lvs-posted-in-more' => 'más',
	'lvs-confirm-keep-title' => 'Mantener video',
	'lvs-confirm-keep-message' => 'Constantemente estamos añadiendo nuevos videos autorizados a <a href="http://video.wikia.com/" target="_blank">Wikia Video</a>. ¿Te gustaría ver nuevas coincidencias para este video cuando se encuentren disponibles?',
	'lvs-confirm-undo-swap-title' => 'Confirmar que quieres deshacer',
	'lvs-confirm-undo-swap-message' => '¿Seguro que quieres restaurar el video original?',
	'lvs-confirm-undo-keep-title' => 'Confirmar que quieres deshacer',
	'lvs-confirm-undo-keep-message' => '¿Seguro que quieres añadir este video de nuevo a la lista?',
	'lvs-no-matching-videos' => 'Actualmente no hay videos premium relacionados con este video',
	'lvs-log-summary' => 'Video cambiado de [[{{ns:File}}:$1]] a [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'Video intercambiado',
	'lvs-log-restore' => 'Restaurado video cambiado previamente, ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Eliminado enlace de redirección',
	'lvs-zero-state' => 'En este momento no hay resultados en Wikia Video para los videos de tu wiki. ¡Vuelve pronto para comprobarlo de nuevo!',
	'lvs-history-swapped' => 'Cambiado "$1" por "$2"',
	'lvs-history-swapped-exact' => 'Cambiado "$1" por un video del mismo nombre',
	'lvs-history-kept' => 'Mantuvo "$1"',
	'lvs-history-instructions' => 'Para ver el historial de todos los intercambios y modificaciones, ve a $1.',
	'lvs-no-monobook-support' => 'Esta página no es compatible con el diseño Monobook. Para acceder a ella con el diseño Wikia, $1. Esto no cambiará tus preferencias de diseño.',
	'lvs-click-here' => 'clic aquí',
	'lvs-new-flag' => 'Nuevo',
);

/** Basque (euskara)
 * @author Subi
 */
$messages['eu'] = array(
	'lvs-button-yes' => 'Bai',
	'lvs-button-no' => 'Ez',
	'lvs-posted-in-more' => 'gehiago',
	'lvs-new-flag' => 'Berria',
);

/** Persian (فارسی)
 * @author Alirezaaa
 * @author Reza1615
 */
$messages['fa'] = array(
	'lvs-history-button-text' => 'تاریخچه',
	'lvs-button-yes' => 'بله',
	'lvs-button-no' => 'خیر',
	'lvs-undo-swap' => 'واگردانی',
	'lvs-undo-keep' => 'واگردانی',
	'lvs-posted-in-more' => 'بیشتر',
	'lvs-new-flag' => 'تازه',
);

/** Finnish (suomi)
 * @author Elseweyr
 * @author Konstaduck
 * @author Silvonen
 */
$messages['fi'] = array(
	'licensedvideoswap' => 'Ei-lisensoitujen videoiden vaihto',
	'action-licensedvideoswap' => 'vaihda lisensoimattomia videoita',
	'lvs-page-title' => 'Ei-lisensoitujen videoiden vaihto',
	'lvs-history-page-title' => 'Ei-lisensoitujen videoiden vaihtohistoria',
	'lvs-tooltip-history' => 'Ei-lisensoitujen videoiden vaihtopainike',
	'lvs-history-button-text' => 'Historia',
	'lvs-page-header-back-link' => 'Takaisin videoiden vaihtosivulle',
	'lvs-callout-header' => 'Löysimme Wikia Videolta vastineita wikisi videoille.<br />Videoidesi korvaaminen Wikia Videon videoilla on hyvä idea, koska:',
	'lvs-match-stats-description' => 'videota,<br />
joilla vastine',
	'lvs-callout-title-licensed' => '100% lisensoitu',
	'lvs-callout-reason-licensed' => 'Wikia Videon videot on lisensoitu wikien käytettäväksi',
	'lvs-callout-title-quality' => 'Korkea laatu',
	'lvs-callout-reason-quality' => 'Wikian Videot ovat korkealaatuisia',
	'lvs-callout-title-collaborative' => 'Tehty jaettavaksi',
	'lvs-callout-reason-collaborative' => 'Wikia Video on tehty yhteistyönä ja sen videoita voidaan käyttää useissa wikeissä',
	'lvs-callout-reason-more' => 'ja enemmän... tulemme jatkossa lisäämään ominaisuuksia ja tapoja käyttää ja hallita Wikian Videoita. Pysy kuulolla!',
	'lvs-instructions-header' => 'Kuinka käyttää tätä sivua',
	'lvs-instructions' => 'Monet videot poistetaan tekijänoikeussyistä, jolloin ne eivät myöskään ole saatavilla wikissäsi. Tämän ehkäisemiseksi Wikia on hyväksynyt [[w:c:video|tuhansia lisensoituja videoita]], joita voit vapaasti käyttää wikeissäsi. Tämä toimintosivu on helppo tapa tarkistaa, mikäli wikisi videoille (tai niiden vastineille) löytyy lisensoituja versioita.

Huomaathan, että samoilla videoilla on usein eri pienkuvakkeita; on siis parempi tarkastella itse videota ennen päätöksentekoa. Mukavia vaihtohetkiä!',
	'lvs-button-keep' => 'Pidä',
	'lvs-button-swap' => 'Vaihda',
	'lvs-button-yes' => 'Kyllä',
	'lvs-button-no' => 'Ei',
	'lvs-more-suggestions' => 'Lisää ehdotuksia',
	'lvs-best-match-label' => 'Paras lisensoitu Wikia Videon vastine',
	'lvs-undo-swap' => 'Kumoa',
	'lvs-undo-keep' => 'Kumoa',
	'lvs-swap-video-success' => 'Onnittelut. Alkuperäinen video on poistettu ja kaikki tämän videon esiintymät, upotukset mukaanlukien, on onnistuneesti vaihdettu vastaavaan Wikian Videoon. $1',
	'lvs-keep-video-success' => 'Olet valinnut säilyttää nykyisen videosi. Video on poistettu tästä luettelosta. $1',
	'lvs-restore-video-success' => 'Olet palauttanut videon tähän luetteloon.',
	'lvs-error-permission' => 'Et voi vaihtaa tätä videota.',
	'lvs-error-permission-access' => 'Et voi käyttää tätä sivua.',
	'lvs-error-invalid-page-status' => 'Et voi palauttaa tätä videota.',
	'lvs-error-already-swapped' => 'Tämä video on jo vaihdettu.',
	'lvs-error-already-kept-forever' => 'Tämä video on jo pidetty.',
	'lvs-posted-in-label' => 'Nykyinen video löytyy sivuilta',
	'lvs-posted-in-label-none' => 'Nykyinen video ei löydy mistään artikkelista',
	'lvs-posted-in-more' => 'lisää',
	'lvs-confirm-keep-title' => 'Pidä video',
	'lvs-confirm-keep-message' => 'Lisäämme jatkuvasti uusia lisensoituja videoita <a href="http://video.wikia.com/" target="_blank">Wikia Videoon</a>. Haluaisitko nähdä uusia vastineita tälle videolle heti, kun ne ovat saatavilla?',
	'lvs-confirm-undo-swap-title' => 'Vahvista Kumoa',
	'lvs-confirm-undo-swap-message' => 'Haluatko varmasti palauttaa alkuperäisen videon?',
	'lvs-confirm-undo-keep-title' => 'Vahvista Kumoa',
	'lvs-confirm-undo-keep-message' => 'Haluatko varmasti lisätä tämän videon takaisin luetteloon?',
	'lvs-no-matching-videos' => 'Tähän videoon ei tällä hetkellä liity yhtään premium-videota',
	'lvs-log-restore' => 'palautti vaihdetun videon ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'poisti uudelleenohjatun linkin',
	'lvs-zero-state' => 'Tällä hetkellä wikisi videoille ei löydy vastineita Wikian Videoista. Voit palata tarkistamaan asian uudelleen pian!',
	'lvs-history-swapped' => 'vaihtoi videon "$1" videoon "$2"',
	'lvs-history-swapped-exact' => 'vaihtoi videon "$1" toiseen samannimiseen videoon',
	'lvs-history-kept' => 'piti videon "$1"',
	'lvs-history-instructions' => 'Nähdäksesi koko vaihto- ja kumoamishistorian, mene sivulle $1.',
	'lvs-no-monobook-support' => 'Tätä sivua ei tueta Monobook -ulkoasua käytettäessä. Käyttääksesi sivua Wikia -ulkoasussa, $1. Tämä ei muuta ulkoasuvalintaa asetuksissasi.',
	'lvs-click-here' => 'klikkaa tästä',
	'lvs-new-flag' => 'Uusi',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'lvs-history-button-text' => 'Søga',
	'lvs-callout-title-quality' => 'Høg góðska',
	'lvs-callout-reason-quality' => 'Wikia Video hava høga góðsku',
	'lvs-callout-title-collaborative' => 'Samstarv',
	'lvs-instructions-header' => 'Hvussu man nýtir hesa síðu',
	'lvs-more-suggestions' => 'fleiri uppskot',
	'lvs-error-permission' => 'Tú kanst ikki umbýta hetta video.',
);

/** French (français)
 * @author Gomoko
 * @author Urhixidur
 */
$messages['fr'] = array(
	'licensedvideoswap-desc' => 'Extension d’échange de vidéo sous licence',
	'licensedvideoswap' => 'Bascule de vidéo sous licence',
	'action-licensedvideoswap' => 'bascule de vidéo sans licence',
	'lvs-page-title' => 'Bascule de vidéo sous licence',
	'lvs-history-page-title' => 'Historique de bascule des vidéos sous licence',
	'lvs-tooltip-history' => 'Bouton de bascule de vidéo sous licence',
	'lvs-history-button-text' => 'Historique',
	'lvs-page-header-back-link' => 'Retour à la bascule de vidéo sous licence',
	'lvs-callout-header' => 'Nous avons trouvé des correspondances pour les vidéos sur votre wiki dans Wikia Vidéo. <br />Remplacer vos vidéos par des vidéos de Wikia Vidéo est une bonne idée, parce que :',
	'lvs-match-stats-description' => 'Vidéos<br />avec correspondances',
	'lvs-callout-title-licensed' => '100% sous licence',
	'lvs-callout-reason-licensed' => 'Les vidéos de Wikia sont sous licence pour que nos communautés les utilisent dans leurs wikis',
	'lvs-callout-title-quality' => 'Haute qualité',
	'lvs-callout-reason-quality' => 'Les vidéos de Wikia sont en haute qualité',
	'lvs-callout-title-collaborative' => 'Collaboratif',
	'lvs-callout-reason-collaborative' => 'Les vidéos de Wikia sont collaboratives et peuvent être utilisées dans de multiples wikis',
	'lvs-callout-reason-more' => 'et davantage… nous ajouterons d’autres fonctionnalités et des moyens d’utiliser facilement et de gérer les vidéos Wikia. Restez à l’écoute !',
	'lvs-instructions-header' => 'Comment utiliser cette page',
	'lvs-instructions' => 'Beaucoup de vidéos incluses dans vos wikis deviennent indisponibles quand elles sont supprimées ou enlevées pour des violations de droit d’auteur. C’est pourquoi Wikia a mis sous licence [[w:c:video|des milliers de vidéos]] à utiliser sur vos wikis de la part de plusieurs partenaires de contenu. Cette page spéciale est un moyen pratique pour vous de voir si nous disposons d’une copie sous licence de vidéos identiques ou semblables à celles de vos wikis. Remarquez que souvent, la même vidéo peut avoir un format de vignette différent, donc il vaut mieux visualiser les vidéos avant de vous décider. Bonne bascule !',
	'lvs-button-keep' => 'Conserver',
	'lvs-button-swap' => 'Basculer',
	'lvs-button-yes' => 'Oui',
	'lvs-button-no' => 'Non',
	'lvs-more-suggestions' => 'Plus de suggestions',
	'lvs-best-match-label' => 'Meilleure correspondance sous licence pour Wikia Vidéo',
	'lvs-undo-swap' => 'Annuler',
	'lvs-undo-keep' => 'Annuler',
	'lvs-swap-video-success' => 'Félicitations. La vidéo d’origine a été supprimée et toutes les instances de celle-ci, y compris celles incluses, ont bien été basculées vers la vidéo Wikia correspondante. $1',
	'lvs-keep-video-success' => 'Vous avez choisi de conserver la vidéo actuelle. Cette vidéo sera supprimée de cette liste. $1',
	'lvs-restore-video-success' => 'Vous avez rétabli la vidéo dans cette liste.',
	'lvs-error-permission' => 'Vous ne pouvez pas basculer cette vidéo.',
	'lvs-error-permission-access' => 'Vous ne pouvez pas accéder à cette page.',
	'lvs-error-invalid-page-status' => 'Vous ne pouvez pas rétablir cette vidéo.',
	'lvs-error-already-swapped' => 'Cette vidéo a déjà été basculée.',
	'lvs-error-already-kept-forever' => 'Cette vidéo a déjà été conservée.',
	'lvs-posted-in-label' => 'Vidéo actuelle publiée dans :',
	'lvs-posted-in-label-none' => 'La vidéo actuelle n’est publiée dans aucun article',
	'lvs-posted-in-more' => 'plus',
	'lvs-confirm-keep-title' => 'Conserver la vidéo',
	'lvs-confirm-keep-message' => 'Nous ajoutons continuellement de nouvelles vidéos sous licence à <a href="http://video.wikia.com/" target="_blank">Wikia Vidéo</a>. Aimeriez-vous voir les nouvelles correspondances pour cette vidéo lorsqu’elles deviennent disponibles ?',
	'lvs-confirm-undo-swap-title' => 'Confirmer l’annulation',
	'lvs-confirm-undo-swap-message' => 'Êtes-vous sûr de vouloir restaurer la vidéo d’origine ?',
	'lvs-confirm-undo-keep-title' => 'Confirmer l’annulation',
	'lvs-confirm-undo-keep-message' => 'Êtes-vous sûr de vouloir de nouveau ajouter cette vidéo dans la liste ?',
	'lvs-no-matching-videos' => 'Il n’y a actuellement aucune vidéo prémium associée à cette vidéo',
	'lvs-log-summary' => 'Vidéo basculée de [[{{ns:File}}:$1]] à [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'vidéo basculée',
	'lvs-log-restore' => 'Vidéo basculée restaurée ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Lien de redirection supprimé',
	'lvs-zero-state' => 'Pour le moment, nous n’avons aucune vidéo de Wikia Vidéo correspondant à des vidéos sur votre wiki. Vérifiez de nouveau prochainement !',
	'lvs-history-swapped' => 'Basculé de « $1 » vers « $2 »',
	'lvs-history-swapped-exact' => 'Basculé de « $1 » vers une vidéo du même nom',
	'lvs-history-kept' => '« $1 » conservé',
	'lvs-history-instructions' => 'Pour afficher un historique de toutes les bascules et annulations, aller sur $1.',
	'lvs-no-monobook-support' => 'Cette page n’est pas prise en charge par Monobook. Pour y accéder dans la disposition de Wikia, $1. Cela ne modifiera pas votre choix de disposition',
	'lvs-click-here' => 'cliquer ici',
	'lvs-new-flag' => 'Nouveau',
);

/** Western Frisian (Frysk)
 * @author Robin0van0der0vliet
 */
$messages['fy'] = array(
	'lvs-history-button-text' => 'Skiednis',
	'lvs-button-yes' => 'Ja',
	'lvs-button-no' => 'Nee',
	'lvs-posted-in-more' => 'mear',
);

/** Galician (galego)
 * @author Elisardojm
 * @author Toliño
 * @author Vivaelcelta
 */
$messages['gl'] = array(
	'licensedvideoswap' => 'Intercambio de vídeos con licenza',
	'action-licensedvideoswap' => 'intercambiar vídeos sen licenza',
	'lvs-page-title' => 'Intercambio de vídeos con licenza',
	'lvs-history-page-title' => 'Historial de intercambio de vídeos con licenza',
	'lvs-tooltip-history' => 'Botón de intercambio de vídeos con licenza',
	'lvs-history-button-text' => 'Historial',
	'lvs-page-header-back-link' => 'Volver ao intercambio de vídeos con licenza',
	'lvs-callout-header' => 'Atopamos algunhas coincidencias para os vídeos do seu wiki entre os vídeos do Wikia. <br /> Substituír os seus vídeos por vídeos do Wikia é unha boa idea porque:',
	'lvs-match-stats-description' => 'Vídeos<br />con coincidencias',
	'lvs-callout-title-licensed' => 'O 100% ten licenza',
	'lvs-callout-reason-licensed' => 'Os vídeos do Wikia teñen unha licenza axeitada para que as nosas comunidades poidan empregalos nos seus wikis',
	'lvs-callout-title-quality' => 'Alta calidade',
	'lvs-callout-reason-quality' => 'Os vídeos do Wikia teñen unha alta calidade',
	'lvs-callout-title-collaborative' => 'Colaboración',
	'lvs-callout-reason-collaborative' => 'Os vídeos do Wikia son colaborativos e poden usarse en varios wikis',
	'lvs-callout-reason-more' => 'e ademais... engadiremos máis características e formas sinxelas de usar e xestionar os vídeos do Wikia. Atentos ás novidades!',
	'lvs-instructions-header' => 'Como usar esta páxina',
	'lvs-instructions' => 'Moitos dos vídeos que se engaden nos seus wikis deixan de estar dispoñibles cando se eliminan por violacións dos dereitos de autoría. É por isto que Wikia ten a licenza de [[w:c:video|miles de vídeos]] procedentes de diferentes socios de contido para usar nos seus wikis. Esta páxina especial é unha forma sinxela de comprobar se temos unha copia con licenza do mesmo vídeo ou dun similar ao dos seus wikis. Teña en conta que moitas veces o mesmo vídeo pode ter unha imaxe en miniatura diferente, polo que o mellor é revisar os vídeos antes de tomar unha decisión. Feliz intercambio!',
	'lvs-button-keep' => 'Manter',
	'lvs-button-swap' => 'Intercambiar',
	'lvs-button-yes' => 'Si',
	'lvs-button-no' => 'Non',
	'lvs-more-suggestions' => 'máis suxestións', # Fuzzy
	'lvs-best-match-label' => 'Mellor resultado de entre os vídeos do Wikia',
	'lvs-undo-swap' => 'Desfacer',
	'lvs-undo-keep' => 'Desfacer',
	'lvs-swap-video-success' => 'Parabéns. O vídeo orixinal foi borrado e todas as instancias deste vídeo, incluídas as copias incrustadas, intercambiáronse correctamente co vídeo do Wikia correspondente. $1',
	'lvs-keep-video-success' => 'Seleccionou manter o vídeo actual. O vídeo eliminarase desta lista. $1',
	'lvs-restore-video-success' => 'Restaurou o vídeo na lista.',
	'lvs-error-permission' => 'Non pode intercambiar este vídeo.',
	'lvs-error-permission-access' => 'Non pode acceder a esta páxina.',
	'lvs-error-invalid-page-status' => 'Non pode restaurar este vídeo.',
	'lvs-error-already-swapped' => 'Este vídeo xa se intercambiou.',
	'lvs-error-already-kept-forever' => 'Este vídeo xa se mantivo.',
	'lvs-posted-in-label' => 'Vídeo publicado actualmente en',
	'lvs-posted-in-label-none' => 'O vídeo actual non está publicado en ningún artigo',
	'lvs-posted-in-more' => 'máis',
	'lvs-confirm-keep-title' => 'Manter o vídeo',
	'lvs-confirm-keep-message' => 'Engadimos constantemente novos vídeos con licenza aos <a href="http://video.wikia.com/" target="_blank">vídeos do Wikia</a>. Queres ver as novas coincidencias para este vídeo en canto estean dispoñibles?',
	'lvs-confirm-undo-swap-title' => 'Confirmar que quere desfacer',
	'lvs-confirm-undo-swap-message' => 'Está seguro de querer restaurar o vídeo orixinal?',
	'lvs-confirm-undo-keep-title' => 'Confirmar que quere desfacer',
	'lvs-confirm-undo-keep-message' => 'Está seguro de querer engadir de novo este vídeo á lista?',
	'lvs-no-matching-videos' => 'Actualmente non hai vídeos premium relacionados con este vídeo.',
	'lvs-log-summary' => 'Intercambiouse o vídeo "[[{{ns:File}}:$1]]" por "[[{{ns:File}}:$2]]"',
	'lvs-log-restore' => 'Restaurouse o vídeo intercambiado ("[[{{ns:File}}:$1]]")',
	'lvs-log-removed-redirected-link' => 'Eliminouse a ligazón de redirección',
	'lvs-zero-state' => 'Neste momento non hai resultados entre os vídeos do Wikia que coincidan cos vídeos do seu wiki. Regresa máis adiante para comprobalo de novo!',
	'lvs-history-swapped' => 'Intercambiouse "$1" por "$2"',
	'lvs-history-swapped-exact' => 'Intercambiouse "$1" por un vídeo co mesmo nome',
	'lvs-history-kept' => 'Mantívose "$1"',
	'lvs-history-instructions' => 'Para ver o historial de todos os intercambios, vaia a $1.',
	'lvs-no-monobook-support' => 'Esta páxina non é compatible co deseño Monobook. Para acceder a ela co deseño do Wikia, $1. Isto non cambiará as súas preferencias de deseño',
	'lvs-click-here' => 'prema aquí',
	'lvs-new-flag' => 'Novo',
);

/** Hebrew (עברית)
 * @author LaG roiL
 */
$messages['he'] = array(
	'lvs-history-button-text' => 'היסטוריה',
	'lvs-button-yes' => 'כן',
	'lvs-button-no' => 'לא',
	'lvs-undo-swap' => 'ביטול',
	'lvs-undo-keep' => 'ביטול',
);

/** Indonesian (Bahasa Indonesia)
 * @author Fate Kage
 */
$messages['id'] = array(
	'lvs-history-button-text' => 'Riwayat',
	'lvs-callout-title-quality' => 'Kualitas Tinggi',
	'lvs-button-yes' => 'Ya',
	'lvs-button-no' => 'Tidak',
	'lvs-more-suggestions' => 'Saran Lain',
	'lvs-undo-swap' => 'Batal',
	'lvs-undo-keep' => 'Batal',
	'lvs-posted-in-more' => 'selebihnya',
	'lvs-confirm-undo-keep-title' => 'Konfirmasi Pembatalan',
	'lvs-click-here' => 'klik di sini',
	'lvs-new-flag' => 'Baru',
);

/** Japanese (日本語)
 * @author Barrel0116
 * @author Plover-Y
 * @author Tommy6
 */
$messages['ja'] = array(
	'licensedvideoswap' => '許諾済み動画への差し替え',
	'lvs-page-title' => '許諾済み動画への差し替え',
	'lvs-history-button-text' => '履歴',
	'lvs-callout-header' => 'このウィキの中から、ウィキア動画ライブラリの動画への差し替えをおすすめする動画が見つかりました。<br />ウィキアでは、以下の理由からウィキア動画ライブラリの動画への差し替えをお勧めしています:',
	'lvs-match-stats-description' => '件の動画に<br />差し替え候補があります',
	'lvs-callout-title-licensed' => '100%許諾済み',
	'lvs-callout-reason-licensed' => 'ウィキア動画ライブラリの動画は、各ウィキでの使用について許諾を得ています',
	'lvs-callout-title-quality' => '高品質',
	'lvs-callout-reason-quality' => 'ウィキア動画ライブラリの動画は高品質です',
	'lvs-instructions-header' => 'このページの使い方',
	'lvs-instructions' => 'せっかくページに動画を埋め込んでも、著作権侵害により動画が削除されてしまい、利用できなくなることがあります。この問題に対する解決策としてウィキアでは、[[w:c:video|提携先から得た数多くの許諾済み動画を提供し]]、各ウィキで利用できるようにしました。このページは、このウィキアに既に埋め込まれている各動画を、同じもしくは似た内容の許諾済み動画に差し替えられないか簡単に検索するためのものです。なお、完全に同じ動画であるにもかかわらず動画サムネイルが違ってしまうことがあることに注意してください。差し替え動画を決める際には、動画自体を再生して確認することをおすすめいたします。',
	'lvs-button-keep' => 'このまま',
	'lvs-button-swap' => '差し替え',
	'lvs-button-yes' => 'はい',
	'lvs-button-no' => 'いいえ',
	'lvs-undo-swap' => '元に戻す',
	'lvs-undo-keep' => '元に戻す',
	'lvs-click-here' => 'こちらをクリック',
	'lvs-new-flag' => '新規',
);

/** Kannada (ಕನ್ನಡ)
 * @author VASANTH S.N.
 */
$messages['kn'] = array(
	'lvs-history-button-text' => 'ಇತಿಹಾಸ',
	'lvs-button-yes' => 'ಹೌದು',
	'lvs-button-no' => 'ಇಲ್ಲ',
	'lvs-more-suggestions' => 'ಯಾವುದೇ ಸಲಹೆಗಳಿಲ್ಲ', # Fuzzy
	'lvs-undo-swap' => 'ಕಳಚು',
	'lvs-undo-keep' => 'ಕಳಚು',
	'lvs-posted-in-more' => 'ಹೆಚ್ಚು',
	'lvs-new-flag' => 'ಹೊಸ',
);

/** Korean (한국어)
 * @author Miri-Nae
 */
$messages['ko'] = array(
	'licensedvideoswap-desc' => '허가받은 동영상 대체 확장 기능',
	'licensedvideoswap' => '허가받은 동영상 대체',
	'lvs-page-title' => '허가받은 동영상 대체',
	'lvs-history-page-title' => '허가받은 동영상 대체 역사',
	'lvs-tooltip-history' => '허가받은 동영상 대체 버튼',
	'lvs-history-button-text' => '역사',
	'lvs-page-header-back-link' => '허가받은 동영상 대체로 돌아가기',
	'lvs-match-stats-description' => '일치하는<br />동영상',
	'lvs-callout-title-licensed' => '100% 허가받음',
	'lvs-callout-title-quality' => '고화질',
	'lvs-instructions-header' => '기능 사용법',
	'lvs-instructions' => '간혹 저작권 침해를 이유로 위키아에 올린 동영상이 삭제되는 경우가 있습니다. 그래서 저희 위키아는 저작권 침해를 걱정할 필요 없이 자유롭게 동영상을 사용할 수 있도록 콘텐츠 파트너로부터 [[w:c:video|수많은 동영상]]의 사용을 허가받았습니다. 이 특수기능을 통해 각 위키아에 올라온 동영상 중 저희가 사용 허가를 받은 동영상과 겹치는 내용이 있는지 확인할 수 있습니다. 완전히 같은 동영상이 다른 섬네일을 가지고 있는 경우도 있으니 직접 동영상을 재생해서 확인해 주세요. 이 기능이 도움이 되시길 바랍니다!',
	'lvs-button-swap' => '대체',
	'lvs-button-yes' => '예',
	'lvs-button-no' => '아니요',
	'lvs-best-match-label' => '가장 비슷한 동영상',
	'lvs-undo-swap' => '되돌리기',
	'lvs-undo-keep' => '되돌리기',
	'lvs-error-permission' => '이 동영상을 대체할 수 없습니다.',
	'lvs-error-permission-access' => '접속 권한이 없습니다.',
	'lvs-error-already-swapped' => '이 동영상은 이미 대체되었습니다.',
	'lvs-posted-in-more' => '더 보기',
	'lvs-confirm-keep-title' => '동영상 유지',
	'lvs-confirm-undo-swap-title' => '확인 취소',
	'lvs-confirm-undo-keep-title' => '확인 취소',
	'lvs-zero-state' => '현재는 해당 위키에 올라온 동영상과 일치하는 위키아 동영상을 찾을 수 없습니다. 다음에 다시 확인해 보세요!',
	'lvs-history-swapped' => '"$1" 동영상을 "$2" 동영상으로 대체함',
	'lvs-history-swapped-exact' => '"$1" 동영상을 같음 이름의 동영상으로 대체함',
	'lvs-new-flag' => '신규',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author Bikarhêner
 */
$messages['ku-latn'] = array(
	'lvs-history-button-text' => 'Dîrok',
	'lvs-button-yes' => 'Erê',
	'lvs-button-no' => 'Na',
	'lvs-posted-in-more' => 'bêhtir',
	'lvs-new-flag' => 'Nû',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'lvs-history-button-text' => 'Versiounen',
	'lvs-callout-title-quality' => 'Gutt Qualitéit',
	'lvs-callout-reason-quality' => 'Wikia Videoe si vun héijer Qualitéit',
	'lvs-callout-title-collaborative' => 'Kollaborativ',
	'lvs-callout-reason-collaborative' => 'Wikia Videoen si kollaborativ a kënnen iwwer verschidde Wikie benotzt ginn',
	'lvs-instructions-header' => 'Wéi dës Säit benotzt gëtt',
	'lvs-button-keep' => 'Behalen',
	'lvs-button-swap' => 'Austauschen',
	'lvs-button-yes' => 'Jo',
	'lvs-button-no' => 'Neen',
	'lvs-more-suggestions' => 'Méi Virschléi',
	'lvs-undo-swap' => 'Réckgängeg maachen',
	'lvs-undo-keep' => 'Réckgängeg maachen',
	'lvs-error-permission' => 'Dir kënnt dëse Video net wiesselen.',
	'lvs-error-permission-access' => 'Dir kënnt net op dës Säit goen.',
	'lvs-error-invalid-page-status' => 'Dir kënnt dëse Video net restauréieren.',
	'lvs-posted-in-more' => 'méi',
	'lvs-confirm-keep-title' => 'Video halen',
	'lvs-confirm-undo-swap-title' => 'Réckgängeg maache confirméieren',
	'lvs-confirm-undo-swap-message' => 'Sidd dir sécher datt Dir den Original-Video restauréiere wëllt?',
	'lvs-log-removed-redirected-link' => 'Viruleedung ewechgeholl',
	'lvs-click-here' => 'hei klicken',
	'lvs-new-flag' => 'Nei',
);

/** لوری (لوری)
 * @author Mogoeilor
 */
$messages['lrc'] = array(
	'lvs-history-button-text' => 'ويرگار',
	'lvs-button-keep' => 'واداشتن',
	'lvs-button-yes' => 'هری',
	'lvs-button-no' => 'نه',
	'lvs-more-suggestions' => 'پیشنادیا هنی',
	'lvs-undo-swap' => 'انجوم ندی ئن',
	'lvs-undo-keep' => 'انجوم ندی ئن',
	'lvs-posted-in-more' => 'بيشتر',
	'lvs-click-here' => 'ایچه بپورنیت',
	'lvs-new-flag' => 'تازه',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'lvs-new-flag' => 'പുതിയവ',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author SNN95
 */
$messages['ms'] = array(
	'licensedvideoswap-desc' => 'Sambungan Pertukaran Video berlesen',
	'licensedvideoswap' => 'Pertukaran Video Berlesen',
	'action-licensedvideoswap' => 'tukarkan video tak berlesen',
	'lvs-page-title' => 'Pertukaran Video Berlesen',
	'lvs-history-page-title' => 'Sejarah Pertukaran Video Berlesen',
	'lvs-tooltip-history' => 'Butang Pertukaran Video Berlesen',
	'lvs-history-button-text' => 'Sejarah',
	'lvs-page-header-back-link' => 'Kembali ke Pertukaran Video Berlesen',
	'lvs-callout-header' => 'Kami telah menemui padanan untuk video-video pada wiki anda di Wikia Video.<br />Adalah baik untuk menggantikan video anda dengan video dari Wikia Video kerana:',
	'lvs-match-stats-description' => 'Video<br />bersama Padanan',
	'lvs-callout-title-licensed' => '100% Berlesen',
	'lvs-callout-reason-licensed' => 'Wikia Videos dilesenkan untuk komuniti-komuniti kami untuk digunakan di wiki-wiki anda',
	'lvs-callout-title-quality' => 'Mutu Tinggi',
	'lvs-callout-reason-quality' => 'Wikia Videos bermutu tinggi',
	'lvs-callout-title-collaborative' => 'Kolaboratif',
	'lvs-callout-reason-collaborative' => 'Wikia Videos bersifat kolaboratif dan boleh digunakan di pelbagai wiki',
	'lvs-callout-reason-more' => 'dan banyak lagi... kami akan menambahkan banyak lagi ciri-ciri dan cara-cara untuk menggunakan dan menguruskan Wikia Videos! Terus setia bersama kami!',
	'lvs-instructions-header' => 'Cara menggunakan halaman ini',
	'lvs-instructions' => "Kebanyakan video yang terletak pada wiki anda akan hilang akibat dipadamkan atau ditanggalkan kerana menyalahi hak cipta. Oleh itu, Wikia telah melesenkan [[w:c:video|beribu-ribu video]] untuk digunakan pada wiki anda dari rakan-rakan kongsi kandungan. Halaman Istimewa ini adalah cara yang mudah untuk anda melihat sama ada terdapatnya video berlesen yang sepadan dengan video-video berhak cipta di wiki anda. Sila ambil perhatian bahawa selalunya video yang tepat-tepat sama menunjukkan lakaran kenit (''thumbnail'') yang berlainan, jadi adalah paling baik untuk meneliti video itu sebelum membuat pilihan. Selamat menukar!",
	'lvs-button-keep' => 'Simpan',
	'lvs-button-swap' => 'Tukar',
	'lvs-button-yes' => 'Ya',
	'lvs-button-no' => 'Tidak',
	'lvs-more-suggestions' => 'Cadangan Lain',
	'lvs-best-match-label' => 'Padanan Berlesen Terbaik dari Wikia Video',
	'lvs-undo-swap' => 'Buat asal',
	'lvs-undo-keep' => 'Buat asal',
	'lvs-swap-video-success' => 'Tahniah. Video yang asal telah pun dihapuskan, dan segala kejadian bagi video ini, termasuk peletakan pada halaman rencana, telah berjaya ditukarkan dengan Wikia Video yang sepadan. $1',
	'lvs-keep-video-success' => 'Anda telah memilih untuk mengekalkan video semasa anda. Video itu akan digugurkan dari senarai ini. $1',
	'lvs-restore-video-success' => 'Anda telah memulihkan video berkenaan pada senarai ini.',
	'lvs-error-permission' => 'Anda tidak boleh menukarkan video ini.',
	'lvs-error-permission-access' => 'Anda tidak boleh mengakses laman ini.',
	'lvs-error-invalid-page-status' => 'Anda tidak boleh memulihkan video ini.',
	'lvs-error-already-swapped' => 'Perisian video ini telah telah telah ditukar.',
	'lvs-error-already-kept-forever' => 'Video ini telah disimpan.',
	'lvs-posted-in-label' => 'Video semasa yang terpapar pada',
	'lvs-posted-in-label-none' => 'Video semasa tidak terpapar pada sebarang rencana',
	'lvs-posted-in-more' => 'selanjutnya',
	'lvs-confirm-keep-title' => 'Simpan Video',
	'lvs-confirm-keep-message' => 'Anda telah memilih untuk tidak menggantikan video semasa anda dengan <a href="http://video.wikia.com/" target="_blank">Wikia Video</a> yang berlesen. Adakah anda ingin teruskan?',
	'lvs-confirm-undo-swap-title' => 'Sahkan Pengunduran',
	'lvs-confirm-undo-swap-message' => 'Adakah anda benar-benar mahu memulihkan video asal?',
	'lvs-confirm-undo-keep-title' => 'Sahkan Pengunduran',
	'lvs-confirm-undo-keep-message' => 'Adakah anda benar-benar ingin menambahkan semula video ini ke dalam senarai?',
	'lvs-no-matching-videos' => 'Kini tidak terdapat video premium yang berkaitan dengan video ini',
	'lvs-log-summary' => 'Menukarkan video dari [[{{ns:File}}:$1]] ke [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'menukar video',
	'lvs-log-restore' => 'Memulihkan video tertukar ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Membuang pautan terlencong',
	'lvs-zero-state' => 'Pada ketika ini, kami tidak mempunyai Wikia Video yang sepadan untuk video-video di wiki anda. Sila datang lagi kemudian!',
	'lvs-history-swapped' => 'Menukarkan "$1" dengan "$2"',
	'lvs-history-swapped-exact' => 'Menukarkan "$1" dengan video yang sama tajuk',
	'lvs-history-kept' => 'Menyimpan "$1"',
	'lvs-history-instructions' => 'Untuk melihat sejarah untuk semua pertukaran dan pengunduran, sila layari $1.',
	'lvs-no-monobook-support' => 'Halaman ini tidak disokong di Monobook. Untuk mengaksesnya di dalam susun atur Wikia, $1. Ini tidak akan mengubah tetapan susun atur anda.',
	'lvs-click-here' => 'klik di sini',
	'lvs-new-flag' => 'Baru',
);

/** Nepali (नेपाली)
 * @author सरोज कुमार ढकाल
 */
$messages['ne'] = array(
	'lvs-new-flag' => 'नयाँ',
);

/** Dutch (Nederlands)
 * @author Breghtje
 * @author Flightmare
 * @author Jochempluim
 * @author Siebrand
 * @author Sjoerddebruin
 * @author Southparkfan
 */
$messages['nl'] = array(
	'licensedvideoswap' => 'Gelicenseerde video wisselen',
	'action-licensedvideoswap' => 'Niet gelicenseerde video wisselen',
	'lvs-page-title' => 'Gelicenseerde video wisselen',
	'lvs-history-page-title' => 'Geschiedenis gelicenseerde video wisselen',
	'lvs-tooltip-history' => 'Knop voor gelicenseerde video wisselen',
	'lvs-history-button-text' => 'Geschiedenis',
	'lvs-page-header-back-link' => 'Terug naar Gelicenseerde video wisselen',
	'lvs-callout-header' => "Er zijn in uw wiki video's gevonden uit Wikia Video.<br />Het vervangen van uw video's door Wikia Video is aan te raden omdat:",
	'lvs-match-stats-description' => "Video's met<br />resultaten",
	'lvs-callout-title-licensed' => '100% gelicenseerd',
	'lvs-callout-reason-licensed' => "Wikia's Video's hebben een licentie die het mogelijk maakt ze te gebruiken op uw wiki",
	'lvs-callout-title-quality' => 'Hoge kwaliteit',
	'lvs-callout-reason-quality' => "Wikia Video's hebben een hoge kwaliteit",
	'lvs-callout-title-collaborative' => 'Samenwerken',
	'lvs-callout-reason-collaborative' => "Wikia Video's kunnen samen gemaakt worden en tussen wiki's worden gedeeld",
	'lvs-callout-reason-more' => "en meer... We gaan meer functies toevoegen en manieren en Wikia Video's eenvoudig te kunnen gebruiken en beheren. We houden u op de hoogte!",
	'lvs-instructions-header' => 'Het gebruik van deze pagina',
	'lvs-instructions' => "Veel van de video's die u op uw wiki gebruikt zijn niet meer beschikbaar wanneer ze worden verwijderd of worden afgesloten vanwege schendingen van het auteursrecht. Daarom heeft Wikia een licentie genomen op [[w:c:video|duizenden video's]] van verschillende contentpartners. Via deze pagina kunt u gemakkelijke zien of we een gelicenseerde video van dezelfde of een soortgelijke video als die op uw wiki hebben. Houd er rekening mee dat exacte dezelfde video vaak een andere videominiatuur heeft, dus controleer een video voordat u een beslissing neemt. Veel succes met wisselen!",
	'lvs-button-keep' => 'Houden',
	'lvs-button-swap' => 'Wisselen',
	'lvs-button-yes' => 'Ja',
	'lvs-button-no' => 'Nee',
	'lvs-more-suggestions' => 'Meer suggesties',
	'lvs-best-match-label' => 'Best passende gelicenseerde Wikia Video',
	'lvs-undo-swap' => 'Ongedaan maken',
	'lvs-undo-keep' => 'Ongedaan maken',
	'lvs-swap-video-success' => 'Gefeliciteerd! De originele video is verwijderd en alle exemplaren van deze video zijn vervangen door de Wikia Video. $1',
	'lvs-keep-video-success' => 'U hebt gekozen de huidige video te behouden. Deze video wordt uit de lijst verwijderd. $1',
	'lvs-restore-video-success' => 'U hebt de video teruggezet in deze lijst.',
	'lvs-error-permission' => 'U kunt deze video niet wisselen.',
	'lvs-error-permission-access' => 'U hebt geen toegang tot deze pagina.',
	'lvs-error-invalid-page-status' => 'U kunt deze video niet terugplaatsen.',
	'lvs-error-already-swapped' => 'Deze video is al gewisseld.',
	'lvs-error-already-kept-forever' => 'Deze video is al behouden.',
	'lvs-posted-in-label' => 'Huidige video geplaatst in:',
	'lvs-posted-in-label-none' => "De huidige video is niet opgenomen in pagina's",
	'lvs-posted-in-more' => 'meer',
	'lvs-confirm-keep-title' => 'Video behouden',
	'lvs-confirm-keep-message' => 'Wij voegen voortdurend nieuwe gelicenseerde video\'s toe aan <a href="http://video.wikia.com/" target="_blank">Wikia Video</a>. Wilt u nieuwe overeenkomsten voor deze video zien zodra ze beschikbaar komen?',
	'lvs-confirm-undo-swap-title' => 'Ongedaan maken bevestigen',
	'lvs-confirm-undo-swap-message' => 'Weet u zeker dat u de oorspronkelijke video terug wilt plaatsen?',
	'lvs-confirm-undo-keep-title' => 'Ongedaan maken bevestigen',
	'lvs-confirm-undo-keep-message' => 'Weet u zeker dat u deze video terug in de lijst wilt plaatsen?',
	'lvs-no-matching-videos' => "Er zijn op het moment geen video's die gerelateerd zijn aan deze video",
	'lvs-log-summary' => 'Video gewisseld van [[{{ns:File}}:$1]] naar [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'gewisselde video',
	'lvs-log-restore' => 'Gewisselde video teruggeplaatst ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Doorverwezen koppeling verwijderd',
	'lvs-zero-state' => 'Op dit moment is er geen video uit Wikia Video beschikbaar voor uw wiki. Controleer het binnenkort opnieuw!',
	'lvs-history-swapped' => '"$1" is gewisseld met "$2"',
	'lvs-history-swapped-exact' => '"$1" is gewisseld met een video met dezelfde naam',
	'lvs-history-kept' => '"$1" is behouden',
	'lvs-history-instructions' => 'Ga naar $1 om de geschiedenis van wissels en terugwissels te bekijken.',
	'lvs-no-monobook-support' => 'Deze pagina wordt niet ondersteund in Monobook. Om deze te openen in de indeling van Wikia, $1. Dit zal uw voorkeurs-layout niet aanpassen.',
	'lvs-click-here' => 'klik hier',
	'lvs-new-flag' => 'Nieuw',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'lvs-history-button-text' => 'Istoric',
	'lvs-callout-title-quality' => 'Nauta qualitat',
	'lvs-callout-title-collaborative' => 'Collaboratiu',
	'lvs-button-keep' => 'Conservar',
	'lvs-button-swap' => 'Bascuolar',
	'lvs-button-yes' => 'Òc',
	'lvs-button-no' => 'Non',
	'lvs-more-suggestions' => 'Mai de suggestions',
	'lvs-undo-swap' => 'Anullar',
	'lvs-undo-keep' => 'Anullar',
	'lvs-error-permission' => 'Podètz pas bascuolar aquesta vidèo.',
	'lvs-error-permission-access' => 'Podètz pas accedir a aquesta pagina.',
	'lvs-error-invalid-page-status' => 'Podètz pas restablir aquesta vidèo.',
	'lvs-posted-in-more' => 'mai',
	'lvs-confirm-keep-title' => 'Conservar la vidèo',
	'lvs-confirm-undo-swap-title' => 'Confirmar l’anullacion',
	'lvs-confirm-undo-keep-title' => 'Confirmar l’anullacion',
	'lvs-history-kept' => '« $1 » conservat',
	'lvs-new-flag' => 'Novèl',
);

/** Polish (polski)
 * @author Matik7
 * @author Pio387
 * @author Sovq
 */
$messages['pl'] = array(
	'licensedvideoswap' => 'Wymiana na licencjonowane filmy',
	'action-licensedvideoswap' => 'wymiany nielicencjonowanego filmu',
	'lvs-page-title' => 'Wymiana na licencjonowane filmy',
	'lvs-history-page-title' => 'Historia wymian',
	'lvs-tooltip-history' => 'Przycisk wymiany filmów',
	'lvs-history-button-text' => 'Historia',
	'lvs-page-header-back-link' => 'Powrót do menu wymiany filmów',
	'lvs-callout-header' => 'Znaleźliśmy odpowiedniki dla filmów na Twojej Wikii w Filmotece Wikii. <br /> Wymiana filmów na pochodzące z Filmoteki to dobry wybór ponieważ:',
	'lvs-match-stats-description' => 'Filmy<br />pasujące',
	'lvs-callout-title-licensed' => '100% Licencjonowane',
	'lvs-callout-reason-licensed' => "Filmy na Wikii posiadają '''licencję''' na wykorzystanie przez edytorów na Wikii",
	'lvs-callout-title-quality' => 'Wysokiej Jakości',
	'lvs-callout-reason-quality' => "Filmy na Wikii są '''wysokiej jakości'''",
	'lvs-callout-title-collaborative' => 'Wszechstronne',
	'lvs-callout-reason-collaborative' => "Filmy z Filmoteki wykorzystywane mogą być '''na wielu wiki'''",
	'lvs-callout-reason-more' => 'i więcej... wkrótce dodawać będziemy więcej funkcjonalności umożliwiających łatwe zarządzenie filmami.',
	'lvs-instructions-header' => 'Jak korzystać z tej strony',
	'lvs-instructions' => 'Wiele filmów dodawanych na wiki, znika ponieważ usunięto je z oryginalnego źródła. Dlatego Wikia pozyskała licencję na wykorzystywanie [[w:c:video|tysięcy filmów]] pochodzących z wielu źródeł. Ta strona specjalna umożliwia łatwe sprawdzenie, czy Filmoteka Wikii zawiera licencjonowaną kopię wybranego filmu na Twojej wiki. Niektóre identyczne filmy różnić się mogą miniaturką - upewnij się, że treść filmu jest identyczna, nim podejmiesz decyzję. Przyjemnego podmieniania!',
	'lvs-button-keep' => 'Zachowaj',
	'lvs-button-swap' => 'Wymień',
	'lvs-button-yes' => 'Tak',
	'lvs-button-no' => 'Nie',
	'lvs-more-suggestions' => 'Więcej sugestii',
	'lvs-best-match-label' => 'Najbliższy film z Filmotekii',
	'lvs-undo-swap' => 'Cofnij',
	'lvs-undo-keep' => 'Cofnij',
	'lvs-swap-video-success' => 'Gratulacje. Oryginalny film został usunięty, a wszystkie odwołania do niego zastąpiono kopią z Filmoteki Wikii. $1',
	'lvs-keep-video-success' => 'Zachowano obecny film. Zostanie on usunięty z tej listy. $1',
	'lvs-restore-video-success' => 'Przywrócono film na tą listę.',
	'lvs-error-permission' => 'Nie możesz wymienić tego filmu.',
	'lvs-error-permission-access' => 'Brak dostępu do strony.',
	'lvs-error-invalid-page-status' => 'Nie możesz przywrócić tego filmu.',
	'lvs-error-already-swapped' => 'Ten film został już wymieniony.',
	'lvs-error-already-kept-forever' => 'Ten film został już zachowany.',
	'lvs-posted-in-label' => 'Film użyto w',
	'lvs-posted-in-label-none' => 'Filmu nie użyto w żadnym artykule',
	'lvs-posted-in-more' => 'więcej',
	'lvs-confirm-keep-title' => 'Zachowaj film',
	'lvs-confirm-keep-message' => 'Stale dodajemy nowe, licencjonowane filmy do <a href="http://video.wikia.com/" target="_blank">Filmoteki Wikii</a>. Czy chcesz zobaczyć nowe podpowiedzi wymiany tego filmu, gdy te staną się dostępne?',
	'lvs-confirm-undo-swap-title' => 'Potwierdź cofnięcie',
	'lvs-confirm-undo-swap-message' => 'Czy na pewno przywrócić oryginalny film?',
	'lvs-confirm-undo-keep-title' => 'Potwierdź cofnięcie',
	'lvs-confirm-undo-keep-message' => 'Czy na pewno dodać film z powrotem na tą listę?',
	'lvs-no-matching-videos' => 'Obecnie nie ma dostępnych filmów powiązanych z tym.',
	'lvs-log-summary' => 'Wymieniono film [[{{ns:File}}:$1]] na [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'zmieniono wideo',
	'lvs-log-restore' => 'Przywrócono wymieniony film ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Usunięto link przekierowujący',
	'lvs-zero-state' => 'Obecnie nie ma w Filmotece Wikii zamienników dla filmów wykorzystywanych na tej wiki. Sprawdź ponownie później!',
	'lvs-history-swapped' => 'Wymieniono "$1" na "$2"',
	'lvs-history-swapped-exact' => 'Wymieniono "$1" na film o tej samej nazwie',
	'lvs-history-kept' => 'Zachowano "$1"',
	'lvs-history-instructions' => 'Aby zobaczyć historię wszystkich podmian, przejdź do $1.',
	'lvs-no-monobook-support' => 'Ta strona nie jest obsługiwana w Monobooku. Aby przejść do skórki Wikia, $1. Nie zmieni to wybranych przez Ciebie ustawień skórki.',
	'lvs-click-here' => 'kliknij tutaj',
	'lvs-new-flag' => 'Nowy',
);

/** Portuguese (português)
 * @author Josep Maria 15.
 */
$messages['pt'] = array(
	'licensedvideoswap' => 'Troca de vídeos licenciados',
	'action-licensedvideoswap' => 'Troca de vídeos sem licença',
	'lvs-page-title' => 'Troca de vídeos licenciados',
	'lvs-history-page-title' => 'Histórico da roca de vídeos licenciados',
	'lvs-tooltip-history' => 'Botão da troca de vídeos licenciados',
	'lvs-history-button-text' => 'Histórico',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Jefersonmoraes
 * @author Luckas
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'lvs-history-button-text' => 'Histórico',
	'lvs-callout-title-quality' => 'Alta qualidade',
	'lvs-button-keep' => 'Manter',
	'lvs-button-yes' => 'Sim',
	'lvs-button-no' => 'Não',
	'lvs-more-suggestions' => 'Mais Sugestões',
	'lvs-undo-swap' => 'Desfazer',
	'lvs-undo-keep' => 'Desfazer',
	'lvs-posted-in-more' => 'mais',
	'lvs-click-here' => 'clique aqui',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'licensedvideoswap' => 'Scambie de video licenziate',
	'action-licensedvideoswap' => 'scambie de video none licenziate',
	'lvs-page-title' => 'Scambie de video licenziate',
	'lvs-history-page-title' => "Cunde d'u scambie de video licenziate",
	'lvs-tooltip-history' => "Buttone d'u scambie de video licenziate",
	'lvs-history-button-text' => 'Cunde',
	'lvs-page-header-back-link' => "Tuèrne a 'u scambie de video licenziate",
	'lvs-callout-title-collaborative' => 'Collabborative',
	'lvs-button-keep' => 'Mandine',
	'lvs-button-swap' => 'Scange',
	'lvs-button-yes' => 'Sìne',
	'lvs-button-no' => 'None',
	'lvs-more-suggestions' => 'Cchiù consiglie',
	'lvs-undo-swap' => 'Annulle',
	'lvs-undo-keep' => 'Annulle',
	'lvs-click-here' => 'cazze aqquà',
	'lvs-new-flag' => 'Nuève',
);

/** Russian (русский)
 * @author Okras
 */
$messages['ru'] = array(
	'licensedvideoswap' => 'Замена на лицензионное видео',
	'action-licensedvideoswap' => 'заменять нелицензионные видео',
	'lvs-page-title' => 'Замена на лицензионное видео',
	'lvs-history-page-title' => 'История замены на лицензионное видео',
	'lvs-tooltip-history' => 'Кнопка замены на лицензионное видео',
	'lvs-history-button-text' => 'История',
	'lvs-page-header-back-link' => 'Назад к Замене на лицензионное видео',
	'lvs-callout-header' => 'Мы нашли совпадения для видео из вашей вики в Wikia Video.<br />Замена вашего видео на видео из Wikia Video — это хорошая идея, потому что:',
	'lvs-match-stats-description' => 'Видео<br />с совпадениями',
	'lvs-callout-title-licensed' => '100% лицензионное',
	'lvs-callout-reason-licensed' => 'Видео в Wikia лицензированы для наших сообществ для использования в ваших проектах',
	'lvs-callout-title-quality' => 'Высокое качество',
	'lvs-callout-reason-quality' => 'Видео в Wikia — высокого качества',
	'lvs-callout-title-collaborative' => 'Общие',
	'lvs-callout-reason-collaborative' => 'Видеозаписи на Wikia — общие и могут быть использованы в нескольких проектах',
	'lvs-callout-reason-more' => 'и многое другое… Мы будем добавлять больше возможностей и способов легко использовать и управлять видеозаписями в Wikia. Оставайтесь с нами!',
	'lvs-instructions-header' => 'Как пользоваться этой страницей',
	'lvs-instructions' => 'Многие видео, которые вы вставляете в ваших проектах, становятся недоступными, когда их удаляют или убирают из-за нарушения авторских прав. Вот почему Wikia лицензировала [[w:c:video|тысячи видео]] от нескольких контент-партнеров для использования в вашей вики. Эта спецстраница — простой способ увидеть, если у нас есть лицензионная копия такого же или похожего видео с вашей вики. Пожалуйста, обратите внимание, что часто точно такое же видео может иметь различные видео-эскизы, так что лучше пересмотреть видео, прежде чем сделать решение. Счастливой замены!',
	'lvs-button-keep' => 'Оставить',
	'lvs-button-swap' => 'Заменить',
	'lvs-button-yes' => 'Да',
	'lvs-button-no' => 'Нет',
	'lvs-more-suggestions' => 'Больше предложений',
	'lvs-best-match-label' => 'Лучшее лицензированное совпадение из Wikia Video',
	'lvs-undo-swap' => 'Отменить',
	'lvs-undo-keep' => 'Отменить',
	'lvs-swap-video-success' => 'Поздравляем! Оригинальное видео было удалено и все экземпляры этого видео, включая внедрённые, успешно заменены на подходящие видео от Wikia. $1',
	'lvs-keep-video-success' => 'Вы решили оставить текущее видео. Видео будет удалено из этого списка. $1',
	'lvs-restore-video-success' => 'Вы восстановили видео в этот список.',
	'lvs-error-permission' => 'Вы не можете заменить это видео.',
	'lvs-error-permission-access' => 'Вы не можете получить доступ к этой странице.',
	'lvs-error-invalid-page-status' => 'Вы не можете восстановить это видео.',
	'lvs-error-already-swapped' => 'Это видео уже было заменено.',
	'lvs-error-already-kept-forever' => 'Это видео уже было оставлено.',
	'lvs-posted-in-label' => 'Это видео размещено в',
	'lvs-posted-in-label-none' => 'Это видео не размещено ни в одной статье',
	'lvs-posted-in-more' => 'далее',
	'lvs-confirm-keep-title' => 'Оставить видео',
	'lvs-confirm-keep-message' => 'Мы постоянно добавляем новые лицензионные видео в <a href="http://video.wikia.com/" target="_blank">Wikia Video</a>. Вы хотели бы видеть новые совпадения для этого видео, если они станут доступны?',
	'lvs-confirm-undo-swap-title' => 'Подтвердить отмену',
	'lvs-confirm-undo-swap-message' => 'Вы уверены, что хотите восстановить оригинальное видео?',
	'lvs-confirm-undo-keep-title' => 'Подтвердить отмену',
	'lvs-confirm-undo-keep-message' => 'Вы уверены, что хотите добавить это видео обратно в список?',
	'lvs-no-matching-videos' => 'В настоящее время нет премиум-видео, относящегося к этому видео',
	'lvs-log-summary' => 'Видео, заменённое с [[{{ns:File}}:$1]] на [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'заменённое видео',
	'lvs-log-restore' => 'Восстановленное заменённое видео ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Удалённые ссылки-перенаправления',
	'lvs-zero-state' => 'На данный момент у нас нет подходящих видео в Wikia Video для видео-записей в вашей вики. Попробуйте проверить еще раз через некоторое время!',
	'lvs-history-swapped' => '«$1» заменён на «$2»',
	'lvs-history-swapped-exact' => '«$1» заменён на видео с таким же именем',
	'lvs-history-kept' => 'Оставлено «$1»',
	'lvs-history-instructions' => 'Для просмотра истории всех замен и их отмен, перейдите на $1.',
	'lvs-no-monobook-support' => 'Эта страница не поддерживается в Monobook. Для доступа к ней в макете Wikia $1. Это не изменит тему в настройках',
	'lvs-click-here' => 'нажмите здесь',
	'lvs-new-flag' => 'Новое',
);

/** Scots (Scots)
 * @author John Reid
 */
$messages['sco'] = array(
	'licensedvideoswap' => 'Licensed Video Swap',
	'action-licensedvideoswap' => 'swap onlicensed video',
	'lvs-page-title' => 'Licensed Video Swap',
	'lvs-history-page-title' => 'Licensed Video Swap Histerie',
	'lvs-tooltip-history' => 'Licensed Video Swap Button',
	'lvs-history-button-text' => 'Histerie',
	'lvs-page-header-back-link' => 'Back tae Licensed Video Swap',
	'lvs-callout-header' => "We've foond matches fer videos oan yer wiki in Wikia Video. <br /> Replacin yer videos wi videos fae Wikia Video is ae guid idea cause:",
	'lvs-match-stats-description' => 'Videos<br />wi Matches',
	'lvs-callout-title-licensed' => '100% Licensed',
	'lvs-callout-reason-licensed' => 'Wikia Videos ar licensed fer oor communities fer uiss oan yer wikis',
	'lvs-callout-title-quality' => 'Hei Qualitie',
	'lvs-callout-reason-quality' => 'Wikia Videos ar hei qualitie',
	'lvs-callout-title-collaborative' => 'Collaberateeve',
	'lvs-callout-reason-collaborative' => 'Wikia Videos ar collaberateeve   can be uised across monie wikis',
	'lvs-callout-reason-more' => "n mair... we'll be eikin mair features n waas tae easilie uise n manage Wikia Videos. Stey tuned!",
	'lvs-instructions-header' => 'Hou tae uise this page',
	'lvs-instructions' => "Monie o the videos that ye embed oan yer wikis become onavailable whan they'r remuived or taen doun fer copiericht wranins. That's why Wikia haes licensed [[w:c:video|thoosands o videos]] fer uiss oan yer wikis fae several content pairtners. This Byordnar page is aen easie wa fer ye tae see gif we hae ae licensed copie o the same or siclike videos oan yer wikis. Please mynd that affen the exact same video micht hae ae different video thummnail, sae it's best tae luikower the videos afore ye mak ae deceesion. Happie swappin!",
	'lvs-button-keep' => 'Keep',
	'lvs-button-swap' => 'Swap',
	'lvs-button-yes' => 'Ay',
	'lvs-button-no' => 'Naw',
	'lvs-more-suggestions' => 'mair suggestions', # Fuzzy
	'lvs-best-match-label' => 'Best Licensed Match fae Wikia Video',
	'lvs-undo-swap' => 'Ondae',
	'lvs-undo-keep' => 'Ondae',
	'lvs-swap-video-success' => 'Weel dun. The oreeginal video haes been delytit n aw instances o this video, inclæding embeds, hae been successfulie swapt oot wi the matchin Wikia Video. $1',
	'lvs-keep-video-success' => "Ye'v chosen tae keep yer nou video. The video has been remuived fae this leet. $1",
	'lvs-restore-video-success' => "Ye'v restored the video tae this leet.",
	'lvs-error-permission' => 'Ye cannna swap this video.',
	'lvs-error-permission-access' => 'Ye canna access this page.',
	'lvs-error-invalid-page-status' => 'Ye canna restore this video.',
	'lvs-error-already-swapped' => 'This video haes awreadie been swapt.',
	'lvs-error-already-kept-forever' => 'This video haes awreadie been kept.',
	'lvs-posted-in-label' => 'The nou video posted in:',
	'lvs-posted-in-label-none' => 'The-nou video is no posted in onie airticles',
	'lvs-posted-in-more' => 'mair',
	'lvs-confirm-keep-title' => 'Keep Video',
	'lvs-confirm-keep-message' => 'We\'r aye eikin new licensed videos tae <a href="http://video.wikia.com/" target="_blank">Wikia Video</a>. Wid ye like tae see new matches fer this video aes thay become available?',
	'lvs-confirm-undo-swap-title' => 'Confirm Ondae',
	'lvs-confirm-undo-swap-message' => 'Ar ye sair ye want tae restore the oreeginal video?',
	'lvs-confirm-undo-keep-title' => 'Confirm Ondae',
	'lvs-confirm-undo-keep-message' => 'Ar ye sair that ye want tae eik this video back oantae the leet?',
	'lvs-no-matching-videos' => "Thaur's nae premium videos relatit tae this video the nou",
	'lvs-log-swap' => 'Swapt video fae [[{{ns:File}}:$1]] tae [[{{ns:File}}:$2]]',
	'lvs-log-restore' => 'Restored swapt video ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Remuived reguidit airtin',
	'lvs-zero-state' => 'At this time we hae nae matchin videos fae Wikia Video fer videos oan yer wiki. Check back again suin!',
	'lvs-history-swapped' => 'Swapt "$1" wi "$2"',
	'lvs-history-swapped-exact' => 'Swapt "$1" wi ae video o the same name',
	'lvs-history-kept' => 'Kept "$1"',
	'lvs-history-instructions' => 'To see the histerie fer aw swaps n ondaes, gang tae $1.',
	'lvs-no-monobook-support' => "This page is no supportit in Monobuik. Tae get at it in the Wikia layoot, $1. This'll no chynge yer layoot preferance",
	'lvs-click-here' => 'clap here',
	'lvs-new-flag' => 'New',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Milicevic01
 */
$messages['sr-ec'] = array(
	'lvs-button-yes' => 'Да',
	'lvs-button-no' => 'Не',
);

/** Serbian (Latin script) (srpski (latinica)‎)
 * @author Milicevic01
 */
$messages['sr-el'] = array(
	'lvs-button-yes' => 'Da',
	'lvs-button-no' => 'Ne',
);

/** Swedish (svenska)
 * @author Lokal Profil
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'licensedvideoswap-desc' => 'Licenserat tillägg för att byta ut videor',
	'licensedvideoswap' => 'Licensierat videobyte',
	'action-licensedvideoswap' => 'byt ut olicensierad video',
	'lvs-page-title' => 'Licensierat videobyte',
	'lvs-history-page-title' => 'Historik för licensierat videobyte',
	'lvs-tooltip-history' => 'Knapp för licensierat videobyte',
	'lvs-history-button-text' => 'Historik',
	'lvs-page-header-back-link' => 'Tillbaka till licensierat videobyte',
	'lvs-callout-header' => 'Vi har hittat resultat för videoklipp på din wiki i Wikia Video.<br />Det är en bra idé att ersätta dina videoklipp med videoklipp från Wikia Video, eftersom:',
	'lvs-match-stats-description' => 'Videor<br />som överensstämmer',
	'lvs-callout-title-licensed' => '100 % licensierad',
	'lvs-callout-reason-licensed' => 'Wikia Videos är licensierat för våra gemenskaper för användning på dina wikis',
	'lvs-callout-title-quality' => 'Hög kvalitet',
	'lvs-callout-reason-quality' => 'Wikia Videos är av hög kvalitet',
	'lvs-callout-title-collaborative' => 'Samarbete',
	'lvs-callout-reason-collaborative' => 'Wikia Videos är samverkande och kan användas över flera wikis',
	'lvs-callout-reason-more' => 'och mer... vi kommer att lägga till fler funktioner och sätt för att enkelt använda och hantera Wikia Videos. Håll ögonen öppna!',
	'lvs-instructions-header' => 'Hur man använder denna sida',
	'lvs-instructions' => 'Många av videoklippen du bäddar in på dina wikis blir otillgängliga när de tas bort eller tas ned för upphovsrättsliga brott. Det är därför Wikia har licensierat [[w:c:video|tusentals videoklipp]] för användning på dina wikis från flera innehållspartner. Denna specialsida är ett enkelt sätt för dig att se om vi har ett licensierat exemplar av samma eller liknande videoklipp på dina wikis. Var god observera att exakt samma videoklipp ofta kan ha en annan videominiatyr så det är bäst att granska videoklippen innan du fattar ett beslut. Lycka till!',
	'lvs-button-keep' => 'Behåll',
	'lvs-button-swap' => 'Byt ut',
	'lvs-button-yes' => 'Ja',
	'lvs-button-no' => 'Nej',
	'lvs-more-suggestions' => 'Fler förslag',
	'lvs-best-match-label' => 'Bästa licensierade resultaten från Wikia Video',
	'lvs-undo-swap' => 'Ångra',
	'lvs-undo-keep' => 'Ångra',
	'lvs-swap-video-success' => 'Grattis. Det ursprungliga videoklippet har raderats och alla förekomster av detta videoklipp, inklusive inbäddningar, har bytts ut med det överensstämmande videoklippet på Wikia Video. $1',
	'lvs-keep-video-success' => 'Du har valt att behålla ditt nuvarande videoklipp. Videoklippet kommer att tas bort från denna lista. $1',
	'lvs-restore-video-success' => 'Du har återställt videon till denna lista.',
	'lvs-error-permission' => 'Du kan inte byta ut denna video.',
	'lvs-error-permission-access' => 'Du kan inte komma åt denna sida.',
	'lvs-error-invalid-page-status' => 'Du kan inte återställa denna video.',
	'lvs-error-already-swapped' => 'Denna video har redan bytts ut.',
	'lvs-error-already-kept-forever' => 'Denna video har redan behållits.',
	'lvs-posted-in-label' => 'Det aktuella videoklippet finns på',
	'lvs-posted-in-label-none' => 'Det aktuella videoklippet är inte inlagt på någon artikel',
	'lvs-posted-in-more' => 'mer',
	'lvs-confirm-keep-title' => 'Behåll video',
	'lvs-confirm-keep-message' => 'Vi lägger kontinuerligt till nya licensierade videor till <a href="http://video.wikia.com/" target="_blank">Wikia Video</a>. Vill du se nya överensstämmande videor för denna video när de blir tillgängliga?',
	'lvs-confirm-undo-swap-title' => 'Bekräfta ångring',
	'lvs-confirm-undo-swap-message' => 'Vill du verkligen återställa den ursprungliga videon?',
	'lvs-confirm-undo-keep-title' => 'Bekräfta ångring',
	'lvs-confirm-undo-keep-message' => 'Vill du verkligen lägga tillbaka denna video i listan?',
	'lvs-no-matching-videos' => 'Det finns för tillfället inga premiumvideoklipp relaterade till detta videoklipp',
	'lvs-log-summary' => 'Bytte ut videon från [[{{ns:File}}:$1]] till [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'bytte ut videon',
	'lvs-log-restore' => 'Återställde den utbytta videon ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Tog bort omdirigeringslänk',
	'lvs-zero-state' => 'I denna stund har vi inga överensstämmande videoklipp från Wikia Video för videoklipp på din wiki. Kom tillbaka och kolla senare!',
	'lvs-history-swapped' => 'Bytte ut "$1" mot "$2"',
	'lvs-history-swapped-exact' => 'Bytte ut "$1" mot en video med samma namn',
	'lvs-history-kept' => 'Behöll "$1"',
	'lvs-history-instructions' => 'För att se historiken över alla utbytande och ångrande åtgärder, gå till $1.',
	'lvs-no-monobook-support' => 'Denna sida stöds inte i MonoBook. För att komma åt den i Wikia-layout, $1. Detta kommer inte att ändra dina utseendeinställningar.',
	'lvs-click-here' => 'klicka här',
	'lvs-new-flag' => 'Ny',
);

/** Tamil (தமிழ்)
 * @author ElangoRamanujam
 */
$messages['ta'] = array(
	'lvs-posted-in-more' => 'மேலும்',
	'lvs-new-flag' => 'புதிய',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 */
$messages['te'] = array(
	'lvs-history-button-text' => 'చరిత్ర',
	'lvs-instructions-header' => 'ఈ పేజీని వాడటం ఎలా',
	'lvs-button-keep' => 'ఉంచు',
	'lvs-button-swap' => 'మార్పిడి',
	'lvs-button-yes' => 'అవును',
	'lvs-button-no' => 'వద్దు',
	'lvs-more-suggestions' => 'మరిన్ని సూచనలు',
	'lvs-undo-swap' => 'రద్దుచెయ్యి',
	'lvs-undo-keep' => 'రద్దుచెయ్యి',
	'lvs-swap-video-success' => 'అభినందనలు. అసలు వీడియోను తొలగించేసాం. దానికి చెందిన అవతారాలు ఇముడ్పులతో సహా, అన్నిటినీ సరిపోలే వికియా వీడియోతో మార్పిడి చేసాం. $1',
	'lvs-keep-video-success' => 'మీ ప్రస్తుత వీడియోను ఉంచెయ్యాలని నిశ్చయించుకున్నారు. అది ఈ జాబితా నుంచి తొలగించబడింది. $1',
	'lvs-restore-video-success' => 'వీడియోను ఈ జాబితాకు పునసథాపించారు.',
	'lvs-error-permission' => 'మీరీ వీడియోను మార్పిడి చెయ్యలేరు.',
	'lvs-error-permission-access' => 'మీరీ పేజీని చూడలేరు.',
	'lvs-error-invalid-page-status' => 'మీరీ వీడియోను పునస్థాపించలేరు.',
	'lvs-error-already-swapped' => 'ఈ వీడియోను ఈసరికే మార్పిడి చేసారు.',
	'lvs-error-already-kept-forever' => 'ఈ వీడియోను ఈసరికే ఉంచేసారు.',
	'lvs-posted-in-label-none' => 'ప్రస్తుత వీడియో ఈ వ్యాసాల్లోనూ పెట్టలేదు',
	'lvs-posted-in-more' => 'మరిన్ని',
	'lvs-confirm-keep-title' => 'వీడియోను ఉంచండి',
	'lvs-confirm-undo-swap-message' => 'అసలు వీడియోను పునస్థాపించాలని మీరు నిశ్చయించుకున్నారా?',
	'lvs-confirm-undo-keep-title' => 'రద్దును నిర్ధారించండి',
	'lvs-confirm-undo-keep-message' => 'ఈ వీడియోను తిరిగి జాబితాలోకి చేర్చాలని మీరు నిశ్చయించుకున్నారా?',
	'lvs-log-removed-redirected-link' => 'దారిమార్పు లింకును తొలగించారు',
	'lvs-history-swapped' => '"$1" ను "$2" తో మార్పిడి చేసాం',
	'lvs-history-swapped-exact' => '"$1" ను అదేే పేరు గల మరో వీడియోతో మార్పిడి చేసాం',
	'lvs-history-kept' => '"$1" ను ఉంచేసాం',
	'lvs-history-instructions' => 'అన్ని మార్పిడులు, రద్దుల చరిత్రను చూసేందుకు $1 కు వెళ్ళండి.',
	'lvs-click-here' => 'ఇక్కడ నొక్కండి',
	'lvs-new-flag' => 'కొత్తవి',
);

/** Tagalog (Tagalog)
 * @author Jewel457
 */
$messages['tl'] = array(
	'lvs-more-suggestions' => 'Iba pang mga mungkahi',
);

/** Turkish (Türkçe)
 * @author Incelemeelemani
 * @author Rapsar
 */
$messages['tr'] = array(
	'lvs-history-button-text' => 'Geçmiş',
	'lvs-button-yes' => 'Evet',
	'lvs-button-no' => 'Hayır',
	'lvs-more-suggestions' => 'daha fazla öneri',
	'lvs-undo-swap' => 'Geri al',
	'lvs-undo-keep' => 'Geri al',
	'lvs-posted-in-more' => 'daha fazla',
	'lvs-click-here' => 'buraya tıkla',
	'lvs-new-flag' => 'Yeni',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Mykola Swarnyk
 * @author Капитан Джон Шепард
 */
$messages['uk'] = array(
	'licensedvideoswap' => 'Обмін на ліцензійне відео',
	'action-licensedvideoswap' => 'обміняти неліцензійне відео',
	'lvs-page-title' => 'Обмін на ліцензійне відео',
	'lvs-history-page-title' => 'Історія обміну ліцензійного відео',
	'lvs-tooltip-history' => 'Кнопка обміну ліцензійного відео',
	'lvs-history-button-text' => 'Історія',
	'lvs-page-header-back-link' => 'Назад до обміну ліцензійного відео',
	'lvs-callout-header' => 'Ми знайшли збіги відео на вашому вікі у Вікія відео.  <\\br> Заміна ваших відео на відео з Вікія відео це хороший вибір, бо:',
	'lvs-match-stats-description' => 'Відео<br /> із збігами',
	'lvs-callout-title-licensed' => '100% ліцензоване',
	'lvs-callout-reason-licensed' => 'Вікія відео ліцензовані для наших спільнот з метою використання на вашому вікі',
	'lvs-callout-title-quality' => 'Висока якість',
	'lvs-callout-reason-quality' => 'Відео вікіа є високої якості',
	'lvs-callout-title-collaborative' => 'Спільні',
	'lvs-callout-reason-collaborative' => 'Відео Вікіа є спільним і може бути використаним через кілька вікій',
	'lvs-callout-reason-more' => 'і ще... ми будемо додавати більше можливостей і способів легкого використання і управління Вікія відео. Залишайтеся з нами!',
	'lvs-instructions-header' => 'Як використовувати цю сторінку',
	'lvs-instructions' => 'Більшість відео, які ви вбудували у вашу вікі, стає недоступними, коли вони вилучені або зняті за порушення авторських прав. Ось чому Вікія вже ліцензувала [[w:c:video|тисячі відео]] для використання на вікі від кількох партнерів вмісту. Ця спеціальна сторінка є простим способом для вас, щоб побачити, чи у нас є ліцензійна копія того самого або схожого відео на ваше вікі. Будь ласка, зверніть увагу, що часто точне ж відео може мати різні мініатюри відео, тому найкраще переглянути відео, перш ніж прийняти рішення. Щасливої заміни!',
	'lvs-button-keep' => 'Зберегти',
	'lvs-button-swap' => 'Обмін',
	'lvs-button-yes' => 'Так',
	'lvs-button-no' => 'Ні',
	'lvs-more-suggestions' => 'Більше пропозицій',
	'lvs-best-match-label' => 'Найкращий ліцензований збіг з Вікія відео',
	'lvs-undo-swap' => 'Відмінити',
	'lvs-undo-keep' => 'Відмінити',
	'lvs-swap-video-success' => 'Вітаємо. Оригінальне відео було видалено, і всі екземпляри цього відео, у тому числі вбудовані, успішно було замінено на відповідне Вікія відео.$1',
	'lvs-keep-video-success' => 'Ви вже вибрали зберегти ваше поточне відео. Відео буде вилучено з цього списку. $1',
	'lvs-restore-video-success' => 'Ви відновили відео в цей список.',
	'lvs-error-permission' => 'Ви не можете обміняти це відео.',
	'lvs-error-permission-access' => 'Ви не маєте доступу до цієї сторінки.',
	'lvs-error-invalid-page-status' => 'Ви не зможете відновити це відео.',
	'lvs-error-already-swapped' => 'Це відео вже було поміняне.',
	'lvs-error-already-kept-forever' => 'Це відео вже збереглося.',
	'lvs-posted-in-label' => 'Поточне відео, розміщене в',
	'lvs-posted-in-label-none' => 'Поточне відео не опубліковано в будь-якій статті',
	'lvs-posted-in-more' => 'більше',
	'lvs-confirm-keep-title' => 'Зберегти відео',
	'lvs-confirm-keep-message' => 'Ми постійно додаємо нові ліцензійні відео <a href="http://video.wikia.com/" target="_blank">Wikia Video</a>. Ви хотіли б бачити нові збіги для цього відео, якщо вони стануть доступні?',
	'lvs-confirm-undo-swap-title' => 'Підтвердити скасування',
	'lvs-confirm-undo-swap-message' => 'Ви дійсно бажаєте відновити оригінальне відео?',
	'lvs-confirm-undo-keep-title' => 'Підтвердити скасування',
	'lvs-confirm-undo-keep-message' => 'Ви впевнені, що хочете додати це відео назад у список розсилки?',
	'lvs-no-matching-videos' => "Наразі немає немає преміум відео, пов'язаного з цим відео",
	'lvs-log-summary' => 'Поміняне відео з [[{{ns:File}}:$1]] на [[{{ns:File}}:$2]]',
	'lvs-log-description' => 'Замінене відео',
	'lvs-log-restore' => 'Відновлено поміняне відео ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Вилучене перенаправлене посилання',
	'lvs-zero-state' => 'На даний момент у нас немає збігів відео з Вікія відео для відео на вашому вікі. Зайдіть пізніше!',
	'lvs-history-swapped' => 'Поміняно"$1" з "$2"',
	'lvs-history-swapped-exact' => 'Поміняно "$1" на відео з тим же ім\'ям',
	'lvs-history-kept' => 'Збережено "$1"',
	'lvs-history-instructions' => 'Для перегляду історії всіх обмінів і відмін дій перейдіть на  $1.',
	'lvs-no-monobook-support' => 'Ця сторінка не підтримується в Monobook. Для доступу до неї у макеті Вікія,  $1. Це не змінить ваше налаштування макету',
	'lvs-click-here' => 'натисніть тут',
	'lvs-new-flag' => 'Нове',
);

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 * @author Dinhxuanduyet
 * @author Hallie1002
 * @author Max20091
 * @author Thanhtai2009
 */
$messages['vi'] = array(
	'licensedvideoswap-desc' => 'Mở rộng hoán đổi Video được cấp phép',
	'licensedvideoswap' => 'Cấp phép trao đổi Video',
	'action-licensedvideoswap' => 'Trao đổi không có giấy phép video',
	'lvs-page-title' => 'Cấp phép trao đổi Video',
	'lvs-history-page-title' => 'lịch sử cấp phép trao đổi Video',
	'lvs-tooltip-history' => 'Nút cấp phép trao đổi Video',
	'lvs-history-button-text' => 'Lịch sử',
	'lvs-page-header-back-link' => 'Quay lại cấp phép trao đổi Video',
	'lvs-callout-header' => 'Chúng tôi nhận thấy các tệp vidoe của wiki bạn trên Wikia Video. Hãy thay đổi các video của bạn thành video từ Wikia Video là một ý tưởng rất tốt, bởi vì:',
	'lvs-match-stats-description' => 'Video<br />phù hợp',
	'lvs-callout-title-licensed' => '100% có giấy phép',
	'lvs-callout-reason-licensed' => 'Wikia Videos có giấy phép cho cộng đồng của chúng tôi. Được cho phép sử dụng trên wiki của bạn.',
	'lvs-callout-title-quality' => 'Chất lượng cao',
	'lvs-callout-reason-quality' => 'Video Wikia có chất lượng cao',
	'lvs-callout-title-collaborative' => 'Cộng tác',
	'lvs-callout-reason-collaborative' => 'Video Wikia được cộng tác và có thể được sử dụng trên nhiều wiki',
	'lvs-callout-reason-more' => 'và nhiều hơn nữa... chúng tôi sẽ thêm nhiều tính năng và cách để sử dụng và quản lý video Wikia dễ dàng. Hãy chờ!',
	'lvs-instructions-header' => 'Cách dùng trang này',
	'lvs-instructions' => 'Bất kỳ video mà bạn đang nhúng trên wiki của bạn trước khi không có sẵn khi chúng bị xóa hoặc gỡ bỏ xuống vì vi phạm bản quyền. Đó là tại sao Wikia lại có giấy phép [[w:c:video|trên hàng nghìn video]] để sử dụng trên wiki của bạn từ các đối tác nội dung. Trên trang đặc biệt là một hướng cho bạn dễ dàng nhìn thấy nếu chúng tôi có giấy phép được sao chép giống nhau hoặc các video tương tự trên wiki của bạn. Xin vui lòng lưu ý, video giống nhau có thể chính xác và có một hình thu nhỏ video khác nhau vì vậy tốt nhất để xem xét các video trước khi bạn đưa ra quyết định. Trao đổi vui vẻ!',
	'lvs-button-keep' => 'Giữ',
	'lvs-button-swap' => 'Trao đổi',
	'lvs-button-yes' => 'Có',
	'lvs-button-no' => 'Không',
	'lvs-more-suggestions' => 'Gợi ý thêm',
	'lvs-best-match-label' => 'Giấy phép tốt nhất tìm thấy trong Wikia Video',
	'lvs-undo-swap' => 'Hoàn tác',
	'lvs-undo-keep' => 'Hoàn tác',
	'lvs-swap-video-success' => 'Xin chúc mừng. Video gốc của bạn đã bị xóa vĩnh viễn và các trường hợp trên video. Bao gồm thông tin nhung, đã đổi thành công với Wikia Video phù hợp. $1',
	'lvs-keep-video-success' => 'Bạn đã chọn để giữ cho video của bạn. Video đã được xóa khỏi danh sách này. $1',
	'lvs-restore-video-success' => 'Bạn đã khôi phục lại các video vào danh sách này.',
	'lvs-error-permission' => 'Bạn không thể trao đổi video này.',
	'lvs-error-permission-access' => 'Bạn không thể truy cập trang này.',
	'lvs-error-invalid-page-status' => 'Bạn không thể khôi phục video này.',
	'lvs-error-already-swapped' => 'Video này đã được đổi.',
	'lvs-error-already-kept-forever' => 'Video này đã được lưu giữ.',
	'lvs-posted-in-label' => 'Hiện tại video đăng trong',
	'lvs-posted-in-label-none' => 'Video hiện tại không được đăng trong bất kỳ bài viết nào',
	'lvs-posted-in-more' => 'Nhiều hơn',
	'lvs-confirm-keep-title' => 'Giữ Video',
	'lvs-confirm-keep-message' => 'Chúng tôi liên tục thêm các video được cấp phép mới <a href="http://video.wikia.com/" target="_blank"> Wikia video </a>. Bạn có muốn xem các video có nội dung tương tự với video này khi chúng xuất hiện?',
	'lvs-confirm-undo-swap-title' => 'Xác nhận hoàn tác',
	'lvs-confirm-undo-swap-message' => 'Bạn có chắc bạn muốn khôi phục video gốc?',
	'lvs-confirm-undo-keep-title' => 'Xác nhận hoàn tác',
	'lvs-confirm-undo-keep-message' => 'Bạn có chắc bạn muốn thêm video này trở lại vào danh sách?',
	'lvs-no-matching-videos' => 'Hiện tại không có video cao cấp nào liên quan đến video này',
	'lvs-log-description' => 'trao đổi Video',
	'lvs-log-restore' => 'Đã khôi phục video đã đổi ([[{{ns:File}}:$1]])',
	'lvs-log-removed-redirected-link' => 'Đã gỡ bỏ liên kết chuyển hướng',
	'lvs-zero-state' => 'Tại thời điểm này chúng tôi không có video phù hợp với Wikia video cho các video trên wiki của bạn. Kiểm tra lại một lần nữa!',
	'lvs-history-swapped' => 'Đổi chỗ "$1" với "$2"',
	'lvs-history-swapped-exact' => 'Đổi "$1" với một đoạn video của cùng tên',
	'lvs-history-kept' => 'Giữ "$1"',
	'lvs-history-instructions' => 'Để xem lịch sử cho tất cả các video đã hoán đổi và undo, vào $1 .',
	'lvs-click-here' => 'nhấn vào đây',
	'lvs-new-flag' => 'Mới',
);

/** Wu (吴语)
 * @author 十弌
 */
$messages['wuu'] = array(
	'lvs-history-button-text' => '歷史',
	'lvs-undo-swap' => '弗妝',
	'lvs-undo-keep' => '弗妝',
	'lvs-posted-in-more' => '還多',
	'lvs-confirm-undo-swap-title' => '準定弗妝',
	'lvs-click-here' => '點底',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hzy980512
 * @author Liuxinyu970226
 * @author Qiyue2001
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'licensedvideoswap-desc' => '已授权视频交换扩展',
	'licensedvideoswap' => '授权视频剪辑',
	'action-licensedvideoswap' => '交换未授权的视频',
	'lvs-page-title' => '授权视频剪辑',
	'lvs-history-page-title' => '已授权的视频交换历史',
	'lvs-tooltip-history' => '已授权的视频交换按钮',
	'lvs-history-button-text' => '历史',
	'lvs-page-header-back-link' => '回到已授权视频的交换',
	'lvs-callout-header' => '我们在Wikia视频中找到了与您的视频相匹配的。<br />用Wikia视频替换您的视频是个好主意，因为：',
	'lvs-match-stats-description' => '匹配的<br />视频',
	'lvs-callout-title-licensed' => '100%已授权',
	'lvs-callout-reason-licensed' => 'Wikia视频由我们社群许可用于您的wiki',
	'lvs-callout-title-quality' => '高清',
	'lvs-callout-reason-quality' => 'Wikia视频都是高清的',
	'lvs-callout-title-collaborative' => '协作',
	'lvs-callout-reason-collaborative' => 'Wikia视频是协同并可跨越多个维基使用的',
	'lvs-callout-reason-more' => '等等……我们将添加更多功能和方式，以便于轻松使用和管理Wikia视频。敬请关注！',
	'lvs-instructions-header' => '如何使用此页',
	'lvs-instructions' => '在您的wiki嵌入的许多视频将在它们被移除或因侵犯版权而下架时不可用。这就是为什么Wikia已授权在您的wiki上使用来自几个内容合作伙伴的[[w:c:video|成千上万的视频]]。此特殊页面是一个简单的方法，让你看到我们有一个与您的wiki上的视频的相同或相似的已授权副本。请注意，看起来缩略图完全相同的视频往往会有轻微或明显的不同，请在替换前进行查看。祝你使用愉快！',
	'lvs-button-keep' => '保持',
	'lvs-button-swap' => '交换',
	'lvs-button-yes' => '是',
	'lvs-button-no' => '否',
	'lvs-more-suggestions' => '更多建议',
	'lvs-best-match-label' => '来自Wikia视频的最好许可协议匹配',
	'lvs-undo-swap' => '撤销',
	'lvs-undo-keep' => '撤销',
	'lvs-swap-video-success' => '共享。原始视频已被删除，所有实例（包括嵌入的）已被成功换为相匹配的Wikia视频。$1',
	'lvs-keep-video-success' => '您选择了保留您当前的视频。该视频已从此列表中移除。$1',
	'lvs-restore-video-success' => '您将视频恢复至此列表。',
	'lvs-error-permission' => '您不能交换此视频。',
	'lvs-error-permission-access' => '您不能访问此页面。',
	'lvs-error-invalid-page-status' => '您无法恢复此视频。',
	'lvs-error-already-swapped' => '此视频已被交换。',
	'lvs-error-already-kept-forever' => '此视频已被保留。',
	'lvs-posted-in-label' => '现有视频发布于',
	'lvs-posted-in-label-none' => '当前视频未被任何条目引用',
	'lvs-posted-in-more' => '更多',
	'lvs-confirm-keep-title' => '保持视频',
	'lvs-confirm-keep-message' => '我们正在不断添加新的已授权视频到<a href="http://video.wikia.com/" target="_blank">Wikia视频</a>。您想在此视频有新的匹配可用时看到吗？',
	'lvs-confirm-undo-swap-title' => '确认撤销',
	'lvs-confirm-undo-swap-message' => '是否确定恢复原视频?',
	'lvs-confirm-undo-keep-title' => '确认撤消',
	'lvs-confirm-undo-keep-message' => '您确定想添加此视频回到此列表吗？',
	'lvs-no-matching-videos' => '目前没有与此视频相关的premium视频',
	'lvs-log-summary' => '从[[{{ns:File}}:$1]]至[[{{ns:File}}:$2]]交换的视频',
	'lvs-log-description' => '被交换的视频',
	'lvs-log-restore' => '恢复已交换的视频（[[{{ns:File}}:$1]]）',
	'lvs-log-removed-redirected-link' => '被删除的重定向链接',
	'lvs-zero-state' => '此时我们没有在您的 wiki 找到匹配的 Wikia 视频。请稍后重试！',
	'lvs-history-swapped' => '已将“$1”和“$2”交换',
	'lvs-history-swapped-exact' => '已将“$1”和同名视频交换',
	'lvs-history-kept' => '保持"$1"',
	'lvs-history-instructions' => '要查看所有已换掉或撤销的历史记录，前往$1。',
	'lvs-no-monobook-support' => '此页面不支持Monobook。要在Wikia布局中访问它，$1。这不会更改您的布局偏好',
	'lvs-click-here' => '点此',
	'lvs-new-flag' => '新',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Cwlin0416
 * @author Ffaarr
 */
$messages['zh-hant'] = array(
	'lvs-history-button-text' => '歷史',
	'lvs-button-keep' => '保留',
	'lvs-button-swap' => '交換',
	'lvs-button-yes' => '是',
	'lvs-button-no' => '否',
	'lvs-more-suggestions' => '更多建議',
	'lvs-undo-swap' => '還原',
	'lvs-undo-keep' => '還原',
	'lvs-posted-in-more' => '更多',
	'lvs-confirm-keep-title' => '保留視訊',
	'lvs-confirm-undo-swap-title' => '確認還原',
	'lvs-confirm-undo-keep-title' => '確認還原',
	'lvs-new-flag' => '新',
);
