<?php
/**
 * Internationalisation file for extension DeleteQueue.
 *
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Andrew Garrett
 * @author Purodha
 */
$messages['en'] = array(
	// General
	'deletequeue-desc' => 'Creates a [[Special:DeleteQueue|queue-based system for managing deletion]]',

	// Landing page
	'deletequeue-action-queued' => 'Deletion',
	'deletequeue-action' => 'Suggest deletion',
	'deletequeue-action-title' => "Suggest deletion of \"$1\"",
	'deletequeue-action-text' => "This wiki has a number of processes for deleting pages:
*If you believe that this page warrants it, you may [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} suggest it for ''speedy deletion''].
*If this page does not warrant speedy deletion, but ''deletion will likely be uncontroversial'', you should [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} propose uncontested deletion].
*If this page's deletion is ''likely to be contested'', you should [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} open a discussion].",
	'deletequeue-action-text-queued' => "You may view the following pages for this deletion case:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} View current endorsements and objections].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Endorse or object to this page's deletion].",

	// Permissions errors
	'deletequeue-permissions-noedit' => "You must be able to edit a page to be able to affect its deletion status.",

	// Nomination forms
	'deletequeue-generic-reasons' => "* Generic reasons\n ** Vandalism\n ** Spam\n ** Maintenance\n ** Out of project scope",
	'deletequeue-nom-alreadyqueued' => 'This page is already in a deletion queue.',

	// Speedy deletion
	'deletequeue-speedy-title' => 'Mark "$1" for speedy deletion',
	'deletequeue-speedy-text' => "You can use this form to mark the page \"'''$1'''\" for speedy deletion.

An administrator will review this request, and, if it is well-founded, delete the page.
You must select a reason for deletion from the drop-down list below, and add any other relevant information.",
	'deletequeue-speedy-reasons' => "-",

	// Proposed deletion
	'deletequeue-prod-title' => "Propose deletion of \"$1\"",
	'deletequeue-prod-text' => "You can use this form to propose that \"'''$1'''\" is deleted.\n
	If, after five days, nobody has contested this page's deletion, it will be deleted after final review by an administrator.",
	'deletequeue-prod-reasons' => '-',

	'deletequeue-delnom-reason' => 'Reason for nomination:',
	'deletequeue-delnom-otherreason' => 'Other reason',
	'deletequeue-delnom-extra' => 'Extra information:',
	'deletequeue-delnom-submit' => 'Submit nomination',

	// Log entries
	'deletequeue-log-nominate' => "nominated [[$1]] for deletion in the '$2' queue.",
	'deletequeue-log-rmspeedy' => "declined to speedily delete [[$1]].",
	'deletequeue-log-requeue' => "transferred [[$1]] to a different deletion queue: from '$2' to '$3'.",
	'deletequeue-log-dequeue' => "removed [[$1]] from the deletion queue '$2'.",

	// Rights
	'right-speedy-nominate' => 'Nominate pages for speedy deletion',
	'right-speedy-review' => 'Review nominations for speedy deletion',
	'right-prod-nominate' => 'Propose page deletion',
	'right-prod-review' => 'Review uncontested deletion proposals',
	'right-deletediscuss-nominate' => 'Start deletion discussions',
	'right-deletediscuss-review' => 'Close deletion discussions',
	'right-deletequeue-vote' => 'Endorse or object to deletions',

	// Queue names
	'deletequeue-queue-speedy' => 'Speedy deletion',
	'deletequeue-queue-prod' => 'Proposed deletion',
	'deletequeue-queue-deletediscuss' => 'Deletion discussion',

	// Display of status in page body
	'deletequeue-page-speedy' => "This page has been nominated for speedy deletion.
The reason given for this deletion is ''$1''.",
	'deletequeue-page-prod' => "It has been proposed that this page is deleted.
The reason given was ''$1''.
If this proposal is uncontested at ''$2'', this page will be deleted.
You can contest this page's deletion by [{{fullurl:{{FULLPAGENAME}}|action=delvote}} objecting to deletion].",
	'deletequeue-page-deletediscuss' => "This page has been proposed for deletion, and that proposal has been contested.
The reason given was ''$1''.
A discussion is ongoing at [[$5]], which will conclude at ''$2''.",

	// Review
	//Generic
	'deletequeue-notqueued' => 'The page you have selected is currently not queued for deletion',
	'deletequeue-review-action' => "Action to take:",
	'deletequeue-review-delete' => "Delete the page.",
	'deletequeue-review-change' => "Delete this page, but with a different rationale.",
	'deletequeue-review-requeue' => "Transfer this page to the following queue:",
	'deletequeue-review-dequeue' => "Take no action, and remove the page from the deletion queue.",
	'deletequeue-review-reason' => 'Comments:',
	'deletequeue-review-newreason' => 'New reason:',
	'deletequeue-review-newextra' => 'Extra information:',
	'deletequeue-review-submit' => 'Save Review',
	'deletequeue-review-original' => "Reason for nomination",
	'deletequeue-actiondisabled-involved' => 'The following action is disabled because you have taken part in this deletion case in the roles $1:',
	'deletequeue-actiondisabled-notexpired' => 'The following action is disabled because the deletion nomination has not yet expired:',
	'deletequeue-review-badaction' => 'You specified an invalid action',
	'deletequeue-review-actiondenied' => 'You specified an action which is disabled for this page',
	"deletequeue-review-objections" => "'''Warning''': The deletion of this page has [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} objections].
Please ensure that you have considered these objections before deleting this page.",
	//Speedy deletion
	'deletequeue-reviewspeedy-tab' => 'Review speedy deletion',
	'deletequeue-reviewspeedy-title' => 'Review speedy deletion nomination of "$1"',
	'deletequeue-reviewspeedy-text' => "You can use this form to review the nomination of \"'''$1'''\" for speedy deletion.
Please ensure that this page can be speedily deleted in accordance with policy.",
	//Proposed deletion
	'deletequeue-reviewprod-tab' => 'Review proposed deletion',
	'deletequeue-reviewprod-title' => 'Review proposed deletion of "$1"',
	'deletequeue-reviewprod-text' => "You can use this form to review the uncontested proposal for the deletion of \"'''$1'''\".",
	// Discussions
	'deletequeue-reviewdeletediscuss-tab' => 'Review deletion',
	'deletequeue-reviewdeletediscuss-title' => "Review deletion discussion for \"$1\"",
	'deletequeue-reviewdeletediscuss-text' => "You can use this form to review the deletion discussion of \"'''$1'''\".

A [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} list] of endorsements and objections of this deletion is available, and the discussion itself can be found at [[$2]].
Please ensure that you make a decision in accordance with the consensus on the discussion.",
	'deletequeue-review-success' => 'You have successfully reviewed the deletion of this page',
	'deletequeue-review-success-title' => 'Review complete',

	// Deletion discussions
	'deletequeue-deletediscuss-discussionpage' => "This is the discussion page for the deletion of [[$1]].
There are currently $2 {{PLURAL:$2|user|users}} endorsing deletion, and $3 {{PLURAL:$3|user|users}} objecting to deletion.
You may [{{fullurl:$1|action=delvote}} endorse or object] to deletion, or [{{fullurl:$1|action=delviewvotes}} view all endorsements and objections].",
	'deletequeue-discusscreate-summary' => 'Creating discussion for deletion of [[$1]].',
	'deletequeue-discusscreate-text' => 'Deletion proposed for the following reason: $2',

	// Roles
	'deletequeue-role-nominator' => 'original nominator for deletion',
	'deletequeue-role-vote-endorse' => 'endorser of deletion',
	'deletequeue-role-vote-object' => 'objector to deletion',

	// Endorsement and objection
	'deletequeue-vote-tab' => 'Vote on the deletion',
	'deletequeue-vote-title' => 'Endorse or object to deletion of "$1"',
	'deletequeue-vote-text' => "You may use this form to endorse or object to the deletion of \"'''$1'''\".
This action will override any previous endorsements/objections you have given to deletion of this page.
You can [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} view] the existing endorsements and objections.
The reason given in the nomination for deletion was ''$2''.",
	'deletequeue-vote-legend' => 'Endorse/Object to deletion',
	'deletequeue-vote-action' => 'Recommendation:',
	'deletequeue-vote-endorse' => 'Endorse deletion.',
	'deletequeue-vote-object' => 'Object to deletion.',
	'deletequeue-vote-reason' => 'Comments:',
	'deletequeue-vote-submit' => 'Submit',
	'deletequeue-vote-success-endorse' => 'You have successfully endorsed the deletion of this page.',
	'deletequeue-vote-success-object' => 'You have successfully objected to the deletion of this page.',
	'deletequeue-vote-requeued' => 'You have successfully objected to the deletion of this page.
Due to your objection, the page has been moved to the $1 queue.',

	// View all votes
	'deletequeue-showvotes' => "Endorsements and objections to deletion of \"$1\"",
	'deletequeue-showvotes-text' => "Below are the endorsements and objections made to the deletion of the page \"'''$1'''\".
You can [{{fullurl:{{FULLPAGENAME}}|action=delvote}} register your own endorsement of, or objection] to this deletion.",
	'deletequeue-showvotes-restrict-endorse' => "Show endorsements only",
	'deletequeue-showvotes-restrict-object' => "Show objections only",
	'deletequeue-showvotes-restrict-none' => "Show all endorsements and objections",
	'deletequeue-showvotes-vote-endorse' => "'''Endorsed''' deletion at $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Objected''' to deletion at $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => "Showing only endorsements",
	'deletequeue-showvotes-showingonly-object' => "Showing only objections",
	'deletequeue-showvotes-none' => "There are no endorsements or objections to the deletion of this page.",
	'deletequeue-showvotes-none-endorse' => "There are no endorsements of the deletion of this page.",
	'deletequeue-showvotes-none-object' => "There are no objections to the deletion of this page.",

	// List of queued pages
	'deletequeue' => 'Deletion queue',
	'deletequeue-list-text' => "This page displays all pages which are in the deletion system.",
	'deletequeue-list-search-legend' => 'Search for pages',
	'deletequeue-list-queue' => 'Queue:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Show only nominations requiring closing.',
	'deletequeue-list-search' => 'Search',
	'deletequeue-list-anyqueue' => '(any)',
	'deletequeue-list-votes' => 'List of votes',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|endorsement|endorsements}}, $2 {{PLURAL:$2|objection|objections}}',
	'deletequeue-list-header-page' => 'Page',
	'deletequeue-list-header-queue' => 'Queue',
	'deletequeue-list-header-votes' => 'Endorsements and objections',
	'deletequeue-list-header-expiry' => 'Expiry',
	'deletequeue-list-header-discusspage' => 'Discussion page',
	
	// Case view.
	'deletequeue-case-intro' => "This page lists information on a specific deletion case.",
	'deletequeue-list-header-reason' => 'Reason for deletion',
	'deletequeue-case-votes' => 'List of votes',
	'deletequeue-case-title' => "Deletion case details",
	'deletequeue-case-details' => 'Basic details',
	'deletequeue-case-page' => 'Page:',
	'deletequeue-case-reason' => 'Reason:',
	'deletequeue-case-expiry' => 'Expiry:',
	'deletequeue-case-votes' => 'Endorsements/objections:',
	'deletequeue-case-needs-review' => 'This case requires [[$1|review]].',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Ferrer
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'deletequeue-desc' => 'Shown in [[Special:Version]] as a short description of this extension. Do not translate links.',
	'deletequeue-generic-reasons' => 'Delete reasons in a dropdown menu. Lines prepended with "*" are a category separator. Lines prepended with "**" can be used as a reason. Please do not add additional reasons. This should be customised on wikis where the extension is actually being used.',
	'deletequeue-delnom-otherreason' => '{{Identical|Other reason}}',
	'deletequeue-delnom-extra' => '{{Identical|Extra information}}',
	'deletequeue-log-nominate' => '* $1 is a page name
* $2 is a queue name',
	'deletequeue-log-rmspeedy' => '$1 is a page name',
	'deletequeue-log-requeue' => '* $1 is a page name
* $2 is a queue name from which page $1 was removed
* $3 is a queue name to which page $1 was added',
	'deletequeue-log-dequeue' => '* $1 is a page name
* $2 is a queue name',
	'right-speedy-nominate' => '{{doc-right}}',
	'right-speedy-review' => '{{doc-right}}',
	'right-prod-nominate' => '{{doc-right}}',
	'right-prod-review' => '{{doc-right}}',
	'right-deletediscuss-nominate' => '{{doc-right}}',
	'right-deletediscuss-review' => '{{doc-right}}',
	'right-deletequeue-vote' => '{{doc-right}}',
	'deletequeue-page-speedy' => '$1 is the reason that the proposer entered.',
	'deletequeue-page-prod' => '$1 is the reason that the proposer entered,
$2 is a date/time,
$3 is its date alone,
$4 is its time alone',
	'deletequeue-page-deletediscuss' => '$1 is the reason that the proposer entered,
$2 is a date/time,
$3 is the date alone,
$4 is the time alone,
$5 is a page title.',
	'deletequeue-review-reason' => '{{Identical|Comments}}',
	'deletequeue-review-newextra' => '{{Identical|Extra information}}',
	'deletequeue-vote-reason' => '{{Identical|Comments}}',
	'deletequeue-vote-submit' => '{{Identical|Submit}}',
	'deletequeue-list-queue' => '{{Identical|Queue}}',
	'deletequeue-list-status' => '{{Identical|Status}}',
	'deletequeue-list-search' => '{{Identical|Search}}',
	'deletequeue-list-header-page' => '{{Identical|Page}}',
	'deletequeue-list-header-queue' => '{{Identical|Queue}}',
	'deletequeue-list-header-expiry' => '{{Identical|Expiry}}',
	'deletequeue-case-page' => '{{Identical|Page}}',
	'deletequeue-case-reason' => '{{Identical|Reason}}',
	'deletequeue-case-expiry' => '{{Identical|Expiry}}',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'deletequeue-generic-reasons' => '* Tipižed süd
   ** Vandalizm
   ** Spam
   ** Holitand
   ** Projektan röunan taga',
	'deletequeue-delnom-otherreason' => 'Toine sü',
	'deletequeue-delnom-extra' => 'Ližainformacii:',
	'deletequeue-delnom-submit' => 'Vahvištoitta nominacii',
	'deletequeue-review-newreason' => "Uz' sü:",
	'deletequeue-review-newextra' => 'Ližainformacii:',
	'deletequeue-review-submit' => 'Panda arvostelend muštho',
	'deletequeue-review-original' => 'Nominacijan sü',
	'deletequeue-vote-submit' => 'Oigeta',
	'deletequeue-list-queue' => 'Jono:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-case-page' => "Lehtpol':",
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'deletequeue-review-reason' => 'Opmerkings:',
	'deletequeue-vote-reason' => 'Opmerkings:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'deletequeue-list-search' => 'ፍለጋ',
);

/** Aragonese (Aragonés)
 * @author Remember the dot
 */
$messages['an'] = array(
	'deletequeue-list-header-page' => 'Pachina',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'deletequeue-desc' => 'ينشئ [[Special:DeleteQueue|نظاما معتمدا على طابور للتحكم بالحذف]]',
	'deletequeue-action-queued' => 'حذف',
	'deletequeue-action' => 'اقتراح الحذف',
	'deletequeue-action-title' => 'اقتراح الحذف ل"$1"',
	'deletequeue-action-text' => "{{SITENAME}} لديه عدد من العمليات لحذف الصفحات:
*لو أنك تعتقد أن هذه الصفحة تحتاج ''الحذف السريع''، يمكنك أن تقترح هذا هنا [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} هنا].
*لو أن هذه الصفحة لا تحتاج الحذف السريع، لكن ''الحذف سيكون على الأرجح غير خلافي''، ينبغي عليك أن [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} تقترح الحذف].
*لو أن حذف هذه الصفحة ''على الأرجح سيتم الاعتراض عليه''، ينبغي عليك أن [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} تبدأ نقاشا].",
	'deletequeue-action-text-queued' => 'أنت يمكنك رؤية الصفحات التالية لحالة الحذف هذه:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} عرض عمليات التأييد والمعارضة الحالية].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} تأييد أو معارضة حذف هذه الصفحة].',
	'deletequeue-permissions-noedit' => 'يجب أن تكون قادرا على تعديل الصفحة لتكون قادرا على التاثير على حالة حذفها.',
	'deletequeue-generic-reasons' => '* أسباب متكررة
  ** تخريب
  ** سبام
  ** صيانة
  ** خارج نطاق المشروع',
	'deletequeue-nom-alreadyqueued' => 'هذه الصفحة موجودة بالفعل في طابور حذف.',
	'deletequeue-speedy-title' => 'علم على "$1" للحذف السريع',
	'deletequeue-speedy-text' => "أنت يمكنك استخدام هذه الاستمارة للتعليم على الصفحة \"'''\$1'''\" للحذف السريع.

أحد الإداريين سيراجع هذا الطلب، و، لو أن أسبابه قوية، سيحذف الصفحة.
يجب عليك أن تختار سببا للحذف من قائمة الاختيارات بالأسفل، وتضيف أي معلومات متعلقة أخرى.",
	'deletequeue-prod-title' => 'اقتراح حذف "$1"',
	'deletequeue-prod-text' => "أنت يمكنك استخدام هذه الاستمارة لاقتراح حذف \"'''\$1'''\".

لو، بعد خمسة أيام، لا أحد اعترض على حذف هذه الصفحة، سيتم حذفها بعد مراجعة نهائية بواسطة إداري.",
	'deletequeue-delnom-reason' => 'السبب للترشيح:',
	'deletequeue-delnom-otherreason' => 'سبب آخر',
	'deletequeue-delnom-extra' => 'معلومات إضافية:',
	'deletequeue-delnom-submit' => 'تنفيذ الترشيح',
	'deletequeue-log-nominate' => "رشح [[$1]] للحذف في طابور '$2'.",
	'deletequeue-log-rmspeedy' => 'رفض أن يحذف سريعا [[$1]].',
	'deletequeue-log-requeue' => "نقل [[$1]] إلى طابور حذف مختلف: من '$2' إلى '$3'.",
	'deletequeue-log-dequeue' => "أزال [[$1]] من طابور الحذف '$2'.",
	'right-speedy-nominate' => 'ترشيح الصفحات للحذف السريع',
	'right-speedy-review' => 'مراجعة الترشيحات للحذف السريع',
	'right-prod-nominate' => 'اقتراح حذف الصفحة',
	'right-prod-review' => 'مراجعة اقتراحات الحذف غير المعترض عليها',
	'right-deletediscuss-nominate' => 'بدء نقاشات الحذف',
	'right-deletediscuss-review' => 'إغلاق نقاشات الحذف',
	'right-deletequeue-vote' => 'تأييد أو معارضة عمليات الحذف',
	'deletequeue-queue-speedy' => 'حذف سريع',
	'deletequeue-queue-prod' => 'حذف مقترح',
	'deletequeue-queue-deletediscuss' => 'نقاش الحذف',
	'deletequeue-page-speedy' => "هذه الصفحة تم ترشيحها للحذف السريع.
السبب المعطى لهذا الحذف هو ''$1''.",
	'deletequeue-page-prod' => "تم اقتراح حذف هذه الصفحة.
السبب المعطى كان ''$1''.
لو أن هذا الاقتراح لم يتم الاعتراض عليه في ''$2''، فهذه الصفحة سيتم حذفها.
يمكنك الاعتراض على حذف هذه الصفحة بواسطة [{{fullurl:{{FULLPAGENAME}}|action=delvote}} الاعتراض على الحذف].",
	'deletequeue-page-deletediscuss' => "هذه الصفحة تم اقتراحها للحذف، وهذا الاقتراح تم الاعتراض عليه.
السبب المعطى كان ''$1''.
يجري نقاش في [[$5]]، سينتهي في ''$2''.",
	'deletequeue-notqueued' => 'الصفحة التي اخترتها ليست في طابور الحذف حاليا',
	'deletequeue-review-action' => 'الفعل للعمل:',
	'deletequeue-review-delete' => 'حذف الصفحة.',
	'deletequeue-review-change' => 'حذف هذه الصفحة، لكن بسبب مختلف.',
	'deletequeue-review-requeue' => 'نقل هذه الصفحة إلى الطابور التالي:',
	'deletequeue-review-dequeue' => 'عدم اتخاذ أي إجراء، وإزالة الصفحة من طابور الحذف.',
	'deletequeue-review-reason' => 'تعليقات:',
	'deletequeue-review-newreason' => 'سبب جديد:',
	'deletequeue-review-newextra' => 'معلومات إضافية:',
	'deletequeue-review-submit' => 'حفظ المراجعة',
	'deletequeue-review-original' => 'السبب للترشيح',
	'deletequeue-actiondisabled-involved' => 'الفعل التالي معطل لأنك قمت بدور في حالة الحذف هذه في الأدوار $1:',
	'deletequeue-actiondisabled-notexpired' => 'الفعل التالي معطل لأن ترشيح الحذف لم ينته بعد:',
	'deletequeue-review-badaction' => 'أنت حددت فعلا غير صحيح',
	'deletequeue-review-actiondenied' => 'أنت حددت فعلا معطلا لهذه الصفحة',
	'deletequeue-review-objections' => "'''تحذير''': حذف هذه الصفحة لديه [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} اعتراضات].
من فضلك تأكد من أنك أخذت هذه الاعتراضات بالاعتبار قبل حذف هذه الصفحة.",
	'deletequeue-reviewspeedy-tab' => 'مراجعة الحذف السريع',
	'deletequeue-reviewspeedy-title' => 'مراجعة ترشيح الحذف السريع ل"$1"',
	'deletequeue-reviewspeedy-text' => "أنت يمكنك استخدام هذه الاستمارة لمراجعة ترشيح \"'''\$1'''\" للحذف السريع.
من فضلك تأكد من أن هذه الصفحة يمكن حذفها حذفا سريعا بالتوافق مع السياسة.",
	'deletequeue-reviewprod-tab' => 'مراجعة الحذف المقترح',
	'deletequeue-reviewprod-title' => 'مراجعة الحذف المقترح ل"$1"',
	'deletequeue-reviewprod-text' => "أنت يمكنك استخدام هذه الاستمارة لمراجعة ترشيح الحذف غير المعترض عليه ل\"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'مراجعة الحذف',
	'deletequeue-reviewdeletediscuss-title' => 'مراجعة نقاش الحذف ل"$1"',
	'deletequeue-reviewdeletediscuss-text' => "أنت يمكنك استخدام هذه الاستمارة لمراجعة نقاش الحذف ل\"'''\$1'''\".

[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} قائمة] بالتاييدات والاعتراضات على هذا الحذف متوفرة، والنقاش نفسه يمكن العثور عليه في [[\$2]].
من فضلك تأكد من أنك تتخذ قرارا مع الأخذ في الاعتبار التوافق في النقاش.",
	'deletequeue-review-success' => 'أنت راجعت بنجاح حذف هذه الصفحة',
	'deletequeue-review-success-title' => 'المراجعة اكتملت',
	'deletequeue-deletediscuss-discussionpage' => 'هذه هي صفحة النقاش لحذف [[$1]].
يوجد حاليا $2 {{PLURAL:$2|مستخدم يؤيد|مستخدم يؤيد}} الحذف، و $3 {{PLURAL:$3|مستخدم يعارض|مستخدم يعارض}} الحذف.
يمكنك [{{fullurl:$1|action=delvote}} تأييد أو معارضة] الحذف، أو [{{fullurl:$1|action=delviewvotes}} رؤية كل التأييدات والاعتراضات].',
	'deletequeue-discusscreate-summary' => 'إنشاء نقاش لحذف [[$1]].',
	'deletequeue-discusscreate-text' => 'الحذف تم اقتراحه للسبب التالي: $2',
	'deletequeue-role-nominator' => 'المرشح الأصلي للحذف',
	'deletequeue-role-vote-endorse' => 'مؤيد للحذف',
	'deletequeue-role-vote-object' => 'معترض على الحذف',
	'deletequeue-vote-tab' => 'تصويت على الحذف',
	'deletequeue-vote-title' => 'تأييد أو معارضة حذف "$1"',
	'deletequeue-vote-text' => "أنت يمكنك استخدام هذه الاستمارة لتأييد أو معارضة حذف \"'''\$1'''\".
هذا الفعل سيلغي أي تأييدات/اعتراضات قمت بها لحذف هذه الصفحة.
يمكنك [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} رؤية] التأييدات والاعتراضات الموجودة.
السبب المعطى في الترشيح للحذف كان ''\$2''.",
	'deletequeue-vote-legend' => 'تأييد/معارضة الحذف',
	'deletequeue-vote-action' => 'توصية:',
	'deletequeue-vote-endorse' => 'تأييد الحذف.',
	'deletequeue-vote-object' => 'معارضة الحذف.',
	'deletequeue-vote-reason' => 'تعليقات:',
	'deletequeue-vote-submit' => 'تنفيذ',
	'deletequeue-vote-success-endorse' => 'أنت أيدت بنجاح حذف هذه الصفحة.',
	'deletequeue-vote-success-object' => 'أنت اعترضت بنجاح على حذف هذه الصفحة.',
	'deletequeue-vote-requeued' => 'أنت اعترضت بنجاح على حذف هذه الصفحة.
نتيجة لاعتراضك، الصفحة تم نقلها إلى طابور $1.',
	'deletequeue-showvotes' => 'التأييدات والاعتراضات على حذف "$1"',
	'deletequeue-showvotes-text' => "بالأسفل التأييدات والاعتراضات على حذف الصفحة \"'''\$1'''\".
يمكنك تسجيل تأييدك الخاص، أو اعتراضك على هذا الحذف [{{fullurl:{{FULLPAGENAME}}|action=delvote}} هنا].",
	'deletequeue-showvotes-restrict-endorse' => 'عرض التأييد فقط',
	'deletequeue-showvotes-restrict-object' => 'عرض الاعتراضات فقط',
	'deletequeue-showvotes-restrict-none' => 'عرض كل التأييدات والاعتراضات',
	'deletequeue-showvotes-vote-endorse' => "'''أيد''' الحذف في $1 $2",
	'deletequeue-showvotes-vote-object' => "'''عارض''' الحذف في $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'عرض التأييدات فقط',
	'deletequeue-showvotes-showingonly-object' => 'عرض الاعتراضات فقط',
	'deletequeue-showvotes-none' => 'لا توجد تأييدات أو اعتراضات لحذف هذه الصفحة.',
	'deletequeue-showvotes-none-endorse' => 'لا توجد تأييدات لحذف هذه الصفحة.',
	'deletequeue-showvotes-none-object' => 'لا توجد اعتراضات على حذف هذه الصفحة.',
	'deletequeue' => 'طابور الحذف',
	'deletequeue-list-text' => 'هذه الصفحة تعرض كل الصفحات التي هي في نظام الحذف.',
	'deletequeue-list-search-legend' => 'بحث عن الصفحات',
	'deletequeue-list-queue' => 'طابور:',
	'deletequeue-list-status' => 'حالة:',
	'deletequeue-list-expired' => 'اعرض فقط الترشيحات المحتاجة للإغلاق.',
	'deletequeue-list-search' => 'بحث',
	'deletequeue-list-anyqueue' => '(أي)',
	'deletequeue-list-votes' => 'قائمة الأصوات',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|تأييد|تأييد}}، $2 {{PLURAL:$2|اعتراض|اعتراض}}',
	'deletequeue-list-header-page' => 'صفحة',
	'deletequeue-list-header-queue' => 'طابور',
	'deletequeue-list-header-votes' => 'التأييد والاعتراضات',
	'deletequeue-list-header-expiry' => 'تاريخ الانتهاء',
	'deletequeue-list-header-discusspage' => 'صفحة نقاش',
	'deletequeue-case-intro' => 'هذه الصفحة تعرض المعلومات حول حالة حذف معينة.',
	'deletequeue-list-header-reason' => 'السبب للحذف',
	'deletequeue-case-votes' => 'التأييد/المعارضة:',
	'deletequeue-case-title' => 'تفاصيل حالة الحذف',
	'deletequeue-case-details' => 'التفاصيل الأساسية',
	'deletequeue-case-page' => 'الصفحة:',
	'deletequeue-case-reason' => 'السبب:',
	'deletequeue-case-expiry' => 'الانتهاء:',
	'deletequeue-case-needs-review' => 'هذه الحالة تتطلب [[$1|المراجعة]].',
);

/** Araucanian (Mapudungun)
 * @author Remember the dot
 */
$messages['arn'] = array(
	'deletequeue-list-header-page' => 'Pakina',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'deletequeue-desc' => 'ينشئ [[Special:DeleteQueue|نظاما معتمدا على طابور للتحكم بالحذف]]',
	'deletequeue-action-queued' => 'حذف',
	'deletequeue-action' => 'اقتراح الحذف',
	'deletequeue-action-title' => 'اقتراح الحذف ل"$1"',
	'deletequeue-action-text' => "{{SITENAME}} لديه عدد من العمليات لحذف الصفحات:
*لو أنك تعتقد أن هذه الصفحة تحتاج ''الحذف السريع''، يمكنك أن تقترح هذا هنا [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} هنا].
*لو أن هذه الصفحة لا تحتاج الحذف السريع، لكن ''الحذف سيكون على الأرجح غير خلافي''، ينبغى عليك أن [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} تقترح الحذف].
*لو أن حذف هذه الصفحة ''على الأرجح سيتم الاعتراض عليه''، ينبغى عليك أن [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} تبدأ نقاشا].",
	'deletequeue-action-text-queued' => 'أنت يمكنك رؤية الصفحات التالية لحالة الحذف هذه:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} عرض عمليات التأييد والمعارضة الحالية].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} تأييد أو معارضة حذف هذه الصفحة].',
	'deletequeue-permissions-noedit' => 'يجب أن تكون قادرا على تعديل الصفحة لتكون قادرا على التاثير على حالة حذفها.',
	'deletequeue-generic-reasons' => '* أسباب متكررة
  ** تخريب
  ** سبام
  ** صيانة
  ** خارج نطاق المشروع',
	'deletequeue-nom-alreadyqueued' => 'هذه الصفحة موجودة بالفعل فى طابور حذف.',
	'deletequeue-speedy-title' => 'علم على "$1" للحذف السريع',
	'deletequeue-speedy-text' => "أنت يمكنك استخدام هذه الاستمارة للتعليم على الصفحة \"'''\$1'''\" للحذف السريع.

أحد الإداريين سيراجع هذا الطلب، و، لو أن أسبابه قوية، سيحذف الصفحة.
يجب عليك أن تختار سببا للحذف من قائمة الاختيارات بالأسفل، وتضيف أى معلومات متعلقة أخرى.",
	'deletequeue-prod-title' => 'اقتراح حذف "$1"',
	'deletequeue-prod-text' => "أنت يمكنك استخدام هذه الاستمارة لاقتراح حذف \"'''\$1'''\".

لو، بعد خمسة أيام، لا أحد اعترض على حذف هذه الصفحة، سيتم حذفها بعد مراجعة نهائية بواسطة إداري.",
	'deletequeue-delnom-reason' => 'السبب للترشيح:',
	'deletequeue-delnom-otherreason' => 'سبب آخر',
	'deletequeue-delnom-extra' => 'معلومات إضافية:',
	'deletequeue-delnom-submit' => 'تنفيذ الترشيح',
	'deletequeue-log-nominate' => "رشح [[$1]] للحذف فى طابور '$2'.",
	'deletequeue-log-rmspeedy' => 'رفض أن يحذف سريعا [[$1]].',
	'deletequeue-log-requeue' => "نقل [[$1]] إلى طابور حذف مختلف: من '$2' إلى '$3'.",
	'deletequeue-log-dequeue' => "أزال [[$1]] من طابور الحذف '$2'.",
	'right-speedy-nominate' => 'ترشيح الصفحات للحذف السريع',
	'right-speedy-review' => 'مراجعة الترشيحات للحذف السريع',
	'right-prod-nominate' => 'اقتراح حذف الصفحة',
	'right-prod-review' => 'مراجعة اقتراحات الحذف غير المعترض عليها',
	'right-deletediscuss-nominate' => 'بدء نقاشات الحذف',
	'right-deletediscuss-review' => 'إغلاق نقاشات الحذف',
	'right-deletequeue-vote' => 'تأييد أو معارضة عمليات الحذف',
	'deletequeue-queue-speedy' => 'حذف سريع',
	'deletequeue-queue-prod' => 'حذف مقترح',
	'deletequeue-queue-deletediscuss' => 'نقاش الحذف',
	'deletequeue-page-speedy' => "هذه الصفحة تم ترشيحها للحذف السريع.
السبب المعطى لهذا الحذف هو ''$1''.",
	'deletequeue-page-prod' => "تم اقتراح حذف هذه الصفحة.
السبب المعطى كان ''$1''.
لو أن هذا الاقتراح لم يتم الاعتراض عليه فى ''$2''، فهذه الصفحة سيتم حذفها.
يمكنك الاعتراض على حذف هذه الصفحة بواسطة [{{fullurl:{{FULLPAGENAME}}|action=delvote}} الاعتراض على الحذف].",
	'deletequeue-page-deletediscuss' => "هذه الصفحة تم اقتراحها للحذف، وهذا الاقتراح تم الاعتراض عليه.
السبب المعطى كان ''$1''.
يجرى نقاش فى [[$5]]، سينتهى فى ''$2''.",
	'deletequeue-notqueued' => 'الصفحة التى اخترتها ليست فى طابور الحذف حاليا',
	'deletequeue-review-action' => 'الفعل للعمل:',
	'deletequeue-review-delete' => 'حذف الصفحة.',
	'deletequeue-review-change' => 'حذف هذه الصفحة، لكن بسبب مختلف.',
	'deletequeue-review-requeue' => 'نقل هذه الصفحة إلى الطابور التالي:',
	'deletequeue-review-dequeue' => 'عدم اتخاذ أى إجراء، وإزالة الصفحة من طابور الحذف.',
	'deletequeue-review-reason' => 'تعليقات:',
	'deletequeue-review-newreason' => 'سبب جديد:',
	'deletequeue-review-newextra' => 'معلومات إضافية:',
	'deletequeue-review-submit' => 'حفظ المراجعة',
	'deletequeue-review-original' => 'السبب للترشيح',
	'deletequeue-actiondisabled-involved' => 'الفعل التالى معطل لأنك قمت بدور فى حالة الحذف هذه فى الأدوار $1:',
	'deletequeue-actiondisabled-notexpired' => 'الفعل التالى معطل لأن ترشيح الحذف لم ينته بعد:',
	'deletequeue-review-badaction' => 'أنت حددت فعلا غير صحيح',
	'deletequeue-review-actiondenied' => 'أنت حددت فعلا معطلا لهذه الصفحة',
	'deletequeue-review-objections' => "'''تحذير''': حذف هذه الصفحة لديه [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} اعتراضات].
من فضلك تأكد من أنك أخذت هذه الاعتراضات بالاعتبار قبل حذف هذه الصفحة.",
	'deletequeue-reviewspeedy-tab' => 'مراجعة الحذف السريع',
	'deletequeue-reviewspeedy-title' => 'مراجعة ترشيح الحذف السريع ل"$1"',
	'deletequeue-reviewspeedy-text' => "أنت يمكنك استخدام هذه الاستمارة لمراجعة ترشيح \"'''\$1'''\" للحذف السريع.
من فضلك تأكد من أن هذه الصفحة يمكن حذفها حذفا سريعا بالتوافق مع السياسة.",
	'deletequeue-reviewprod-tab' => 'مراجعة الحذف المقترح',
	'deletequeue-reviewprod-title' => 'مراجعة الحذف المقترح ل"$1"',
	'deletequeue-reviewprod-text' => "أنت يمكنك استخدام هذه الاستمارة لمراجعة ترشيح الحذف غير المعترض عليه ل\"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'مراجعة الحذف',
	'deletequeue-reviewdeletediscuss-title' => 'مراجعة نقاش الحذف ل"$1"',
	'deletequeue-reviewdeletediscuss-text' => "أنت يمكنك استخدام هذه الاستمارة لمراجعة نقاش الحذف ل\"'''\$1'''\".

[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} قائمة] بالتاييدات والاعتراضات على هذا الحذف متوفرة، والنقاش نفسه يمكن العثور عليه فى [[\$2]].
من فضلك تأكد من أنك تتخذ قرارا مع الأخذ فى الاعتبار التوافق فى النقاش.",
	'deletequeue-review-success' => 'أنت راجعت بنجاح حذف هذه الصفحة',
	'deletequeue-review-success-title' => 'المراجعة اكتملت',
	'deletequeue-deletediscuss-discussionpage' => 'هذه هى صفحة النقاش لحذف [[$1]].
يوجد حاليا $2 {{PLURAL:$2|مستخدم يؤيد|مستخدم يؤيد}} الحذف، و $3 {{PLURAL:$3|مستخدم يعارض|مستخدم يعارض}} الحذف.
يمكنك [{{fullurl:$1|action=delvote}} تأييد أو معارضة] الحذف، أو [{{fullurl:$1|action=delviewvotes}} رؤية كل التأييدات والاعتراضات].',
	'deletequeue-discusscreate-summary' => 'إنشاء نقاش لحذف [[$1]].',
	'deletequeue-discusscreate-text' => 'الحذف تم اقتراحه للسبب التالي: $2',
	'deletequeue-role-nominator' => 'المرشح الأصلى للحذف',
	'deletequeue-role-vote-endorse' => 'مؤيد للحذف',
	'deletequeue-role-vote-object' => 'معترض على الحذف',
	'deletequeue-vote-tab' => 'تصويت على الحذف',
	'deletequeue-vote-title' => 'تأييد أو معارضة حذف "$1"',
	'deletequeue-vote-text' => "أنت يمكنك استخدام هذه الاستمارة لتأييد أو معارضة حذف \"'''\$1'''\".
هذا الفعل سيلغى أى تأييدات/اعتراضات قمت بها لحذف هذه الصفحة.
يمكنك [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} رؤية] التأييدات والاعتراضات الموجودة.
السبب المعطى فى الترشيح للحذف كان ''\$2''.",
	'deletequeue-vote-legend' => 'تأييد/معارضة الحذف',
	'deletequeue-vote-action' => 'توصية:',
	'deletequeue-vote-endorse' => 'تأييد الحذف.',
	'deletequeue-vote-object' => 'معارضة الحذف.',
	'deletequeue-vote-reason' => 'تعليقات:',
	'deletequeue-vote-submit' => 'تنفيذ',
	'deletequeue-vote-success-endorse' => 'أنت أيدت بنجاح حذف هذه الصفحة.',
	'deletequeue-vote-success-object' => 'أنت اعترضت بنجاح على حذف هذه الصفحة.',
	'deletequeue-vote-requeued' => 'أنت اعترضت بنجاح على حذف هذه الصفحة.
نتيجة لاعتراضك، الصفحة تم نقلها إلى طابور $1.',
	'deletequeue-showvotes' => 'التأييدات والاعتراضات على حذف "$1"',
	'deletequeue-showvotes-text' => "بالأسفل التأييدات والاعتراضات على حذف الصفحة \"'''\$1'''\".
يمكنك تسجيل تأييدك الخاص، أو اعتراضك على هذا الحذف [{{fullurl:{{FULLPAGENAME}}|action=delvote}} هنا].",
	'deletequeue-showvotes-restrict-endorse' => 'عرض التأييد فقط',
	'deletequeue-showvotes-restrict-object' => 'عرض الاعتراضات فقط',
	'deletequeue-showvotes-restrict-none' => 'عرض كل التأييدات والاعتراضات',
	'deletequeue-showvotes-vote-endorse' => "'''أيد''' الحذف فى $1 $2",
	'deletequeue-showvotes-vote-object' => "'''عارض''' الحذف فى $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'عرض التأييدات فقط',
	'deletequeue-showvotes-showingonly-object' => 'عرض الاعتراضات فقط',
	'deletequeue-showvotes-none' => 'لا توجد تأييدات أو اعتراضات لحذف هذه الصفحة.',
	'deletequeue-showvotes-none-endorse' => 'لا توجد تأييدات لحذف هذه الصفحة.',
	'deletequeue-showvotes-none-object' => 'لا توجد اعتراضات على حذف هذه الصفحة.',
	'deletequeue' => 'طابور الحذف',
	'deletequeue-list-text' => 'هذه الصفحة تعرض كل الصفحات التى هى فى نظام الحذف.',
	'deletequeue-list-search-legend' => 'بحث عن الصفحات',
	'deletequeue-list-queue' => 'طابور:',
	'deletequeue-list-status' => 'حالة:',
	'deletequeue-list-expired' => 'اعرض فقط الترشيحات المحتاجة للإغلاق.',
	'deletequeue-list-search' => 'بحث',
	'deletequeue-list-anyqueue' => '(أي)',
	'deletequeue-list-votes' => 'قائمة الأصوات',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|تأييد|تأييد}}، $2 {{PLURAL:$2|اعتراض|اعتراض}}',
	'deletequeue-list-header-page' => 'صفحة',
	'deletequeue-list-header-queue' => 'طابور',
	'deletequeue-list-header-votes' => 'التأييد والاعتراضات',
	'deletequeue-list-header-expiry' => 'تاريخ الانتهاء',
	'deletequeue-list-header-discusspage' => 'صفحة نقاش',
	'deletequeue-case-intro' => 'هذه الصفحة تعرض المعلومات حول حالة حذف معينة.',
	'deletequeue-list-header-reason' => 'السبب للحذف',
	'deletequeue-case-votes' => 'التأييد/المعارضة:',
	'deletequeue-case-title' => 'تفاصيل حالة الحذف',
	'deletequeue-case-details' => 'التفاصيل الأساسية',
	'deletequeue-case-page' => 'الصفحة:',
	'deletequeue-case-reason' => 'السبب:',
	'deletequeue-case-expiry' => 'الانتهاء:',
	'deletequeue-case-needs-review' => 'هذه الحالة تتطلب [[$1|المراجعة]].',
);

/** Assamese (অসমীয়া)
 * @author Chaipau
 */
$messages['as'] = array(
	'deletequeue-list-search' => 'সন্ধান কৰক',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'deletequeue-list-status' => 'Статус:',
	'deletequeue-list-header-page' => 'Старонка',
	'deletequeue-case-reason' => 'Прычына:',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'deletequeue-desc' => 'Създава [[Special:DeleteQueue|система от опашки за управление на изтриванията]]',
	'deletequeue-action-queued' => 'Изтриване',
	'deletequeue-generic-reasons' => '* Основни причини
  ** Вандализъм
  ** Спам
  ** Поддръжка
  ** Извън тематиката на проекта',
	'deletequeue-nom-alreadyqueued' => 'Тази страница вече е в опашката за изтриване.',
	'deletequeue-speedy-title' => 'Отбелязване на „$1“ за бързо изтриване',
	'deletequeue-delnom-reason' => 'Причина за номинирането:',
	'deletequeue-delnom-otherreason' => 'Друга причина',
	'deletequeue-delnom-extra' => 'Допълнителна информация:',
	'deletequeue-review-action' => 'Действие за предприемане:',
	'deletequeue-review-delete' => 'Изтриване на страницата.',
	'deletequeue-review-reason' => 'Коментари:',
	'deletequeue-review-newreason' => 'Нова причина:',
	'deletequeue-review-newextra' => 'Допълнителна информация:',
	'deletequeue-review-original' => 'Причина за номинирането',
	'deletequeue-vote-reason' => 'Коментари:',
	'deletequeue-vote-submit' => 'Изпращане',
	'deletequeue-list-search-legend' => 'Търсене за страници',
	'deletequeue-list-queue' => 'Опашка:',
	'deletequeue-list-status' => 'Статут:',
	'deletequeue-list-search' => 'Търсене',
	'deletequeue-list-votes' => 'Списък на гласовете',
	'deletequeue-list-header-page' => 'Страница',
	'deletequeue-list-header-queue' => 'Опашка',
	'deletequeue-list-header-expiry' => 'Срок на изтичане',
	'deletequeue-list-header-discusspage' => 'Дискусионна страница',
	'deletequeue-case-details' => 'Основна информация',
	'deletequeue-case-page' => 'Страница:',
	'deletequeue-case-reason' => 'Причина:',
	'deletequeue-case-expiry' => 'Срок на изтичане:',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'deletequeue-action-queued' => 'Brisanje',
	'deletequeue-action' => 'Predloži brisanje',
	'deletequeue-action-title' => 'Predlaganje brisanja za "$1"',
	'deletequeue-permissions-noedit' => 'Morate imati mogućnost uređivanja stranica da bi ste mogli uticati na njen status brisanja.',
	'deletequeue-generic-reasons' => '*Opći razlozi
  ** Vandalizam
  ** Spam
  ** Održavanje
  ** Van smisla projekta',
	'deletequeue-nom-alreadyqueued' => 'Ova stranica se već nalazi u redu za brisanje.',
	'deletequeue-speedy-title' => 'Označi "$1" za brzo brisanje',
	'deletequeue-prod-title' => 'Predloženo brisanje "$1"',
	'deletequeue-delnom-reason' => 'Razlog za nominaciju:',
	'deletequeue-delnom-otherreason' => 'Ostali razlozi',
	'deletequeue-delnom-extra' => 'Dodane informacije:',
	'deletequeue-delnom-submit' => 'Pošalji nominaciju',
	'deletequeue-log-nominate' => "nominirana stranica [[$1]] za brisanje u redu za čekanje '$2'.",
	'deletequeue-log-dequeue' => "uklonjena [[$1]] iz reda za brisanje '$2'.",
	'right-speedy-nominate' => 'Nominiranje stranica za brzo brisanje',
	'right-prod-nominate' => 'Predlaganje brisanja stranice',
	'right-deletediscuss-nominate' => 'Započinjanje razgovora o brisanju',
	'right-deletediscuss-review' => 'Zatvaranje diskusija o brisanju',
	'deletequeue-queue-speedy' => 'Brzo brisanje',
	'deletequeue-queue-prod' => 'Predloženo brisanje',
	'deletequeue-queue-deletediscuss' => 'Brisanje razgovora',
	'deletequeue-review-action' => 'Akcija koja se preduzima:',
	'deletequeue-review-delete' => 'Brisanje stranice.',
	'deletequeue-review-reason' => 'Komentari:',
	'deletequeue-review-newreason' => 'Novi razlog:',
	'deletequeue-review-newextra' => 'Dodatne informacije:',
	'deletequeue-review-submit' => 'Sačuvaj pregled',
	'deletequeue-review-original' => 'Razlog za nominaciju',
	'deletequeue-review-badaction' => 'Naveli ste nevaljanu akciju',
	'deletequeue-review-actiondenied' => 'Naveli ste akciju koja je onemogućena na ovoj stranici',
	'deletequeue-role-nominator' => 'prvobitni predlagač brisanja',
	'deletequeue-vote-action' => 'Preporuke:',
	'deletequeue-vote-reason' => 'Komentari:',
	'deletequeue-vote-submit' => 'Pošalji',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Traži',
	'deletequeue-list-header-page' => 'Stranica',
	'deletequeue-case-expiry' => 'Ističe:',
);

/** Catalan (Català)
 * @author Loupeter
 */
$messages['ca'] = array(
	'deletequeue-review-reason' => 'Comentaris:',
	'deletequeue-vote-reason' => 'Comentaris:',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author ChrisiPK
 * @author Umherirrender
 */
$messages['de'] = array(
	'deletequeue-desc' => 'Erstellt ein [[Special:DeleteQueue|auf einer Warteschlange basierendes System zur Verwaltung von Löschungen]]',
	'deletequeue-action-queued' => 'Löschung',
	'deletequeue-action' => 'Löschung vorschlagen',
	'deletequeue-action-title' => '„$1“ zur Löschung vorschlagen',
	'deletequeue-action-text' => "{{SITENAME}} hat mehrere unterschiedliche Vorgehensweisen bei der Löschung von Seiten:
*Wenn du glaubst, dass diese Seite die ''Schnelllöschkriterien'' erfüllt, kannst du sie [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} hier] vorschlagen.
*Wenn diese Seite nicht zur Schnelllöschung geeignet ist, aber die Löschung ''wahrscheinlich nicht kontrovers'' ist, solltest du sie zur [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} unumstrittenen Löschung] vorschlagen.
*Wenn die Löschung dieser Seite ''wahrscheinlich umstritten'' ist, solltest du [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} eine Diskussion eröffnen].",
	'deletequeue-action-text-queued' => 'Du kannst die folgenden Seiten für den Löschantrag aufrufen:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Pros und Contras].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Stimme zu diesem Löschantrag abgeben].',
	'deletequeue-permissions-noedit' => 'Du musst eine Seite bearbeiten können, um ihren Löschstatus zu verändern.',
	'deletequeue-generic-reasons' => '* Oft vorkommende Gründe
  ** Vandalismus
  ** Werbung
  ** Wartung
  ** Nicht mit dem Projektziel vereinbar',
	'deletequeue-nom-alreadyqueued' => 'Diese Seite ist bereits in der Lösch-Warteschlange.',
	'deletequeue-speedy-title' => '„$1“ zur Schnelllöschung vorschlagen',
	'deletequeue-speedy-text' => "Auf dieser Seite kannst du „'''$1'''“ zur Schnelllöschung vorschlagen.

Ein Administrator wird den Antrag begutachten und, wenn er gut begründet ist, die Seite löschen.
Du musst einen Löschgrund aus dem untenstehenden Dropdown-Menü auswählen und alle weiteren relevanten Informationen hinzufügen.",
	'deletequeue-prod-title' => '„$1“ zur Löschung vorschlagen',
	'deletequeue-prod-text' => "Auf dieser Seite kannst du „'''$1'''“ zur Löschung vorschlagen.

Wenn nach fünf Tagen niemand Einspruch gegen die Löschung eingelegt hat, wird die Seite nach Begutachtung durch einen Administrator gelöscht.",
	'deletequeue-delnom-reason' => 'Grund für den Löschantrag:',
	'deletequeue-delnom-otherreason' => 'Anderer Grund',
	'deletequeue-delnom-extra' => 'Weitere Informationen:',
	'deletequeue-delnom-submit' => 'Löschung eintragen',
	'deletequeue-log-nominate' => 'hat [[$1]] zur Löschung in der Lösch-Warteschlange „$2“ vorgeschlagen.',
	'deletequeue-log-rmspeedy' => 'hat den Schnelllöschantrag für [[$1]] abgelehnt.',
	'deletequeue-log-requeue' => 'hat [[$1]] zu einer anderen Lösch-Warteschlange verschoben: von „$2“ zu „$3“.',
	'deletequeue-log-dequeue' => 'hat [[$1]] aus der Lösch-Warteschlange „$2“ entfernt.',
	'right-speedy-nominate' => 'Seiten zur Schnelllöschung vorschlagen',
	'right-speedy-review' => 'Schnelllöschanträge prüfen',
	'right-prod-nominate' => 'Seite zur Löschung vorschlagen',
	'right-prod-review' => 'Unumstrittene Löschanträge prüfen',
	'right-deletediscuss-nominate' => 'Löschdiskussionen eröffnen',
	'right-deletediscuss-review' => 'Löschdiskussionen beenden',
	'right-deletequeue-vote' => 'Für oder gegen die Löschung stimmen',
	'deletequeue-queue-speedy' => 'Schnelllöschung',
	'deletequeue-queue-prod' => 'Löschantrag',
	'deletequeue-queue-deletediscuss' => 'Löschdiskussion',
	'deletequeue-page-speedy' => "Diese Seite wurde zur Schnelllöschung vorgeschlagen.
Der angegebene Grund lautet ''$1''.",
	'deletequeue-page-prod' => "Diese Seite wurde zur Löschung vorgeschlagen.
Der angegebene Grund lautet ''$1''.
Wenn hiergegen bis zum ''$2'' kein Widerspruch eingelegt wird, wird diese Seite gelöscht werden.
Du kannst gegen diesen Löschantrag [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Widerspruch einlegen].",
	'deletequeue-page-deletediscuss' => "Diese Seite wurde zur Löschung vorgeschlagen und hiergegen wurde Widerspruch eingelegt.
Der angegebene Grund lautet ''$1''.
Die [[$5|Löschdiskussion]] läuft noch bis zum ''$2''.",
	'deletequeue-notqueued' => 'Die von dir ausgewählte Seite ist momentan in keiner Lösch-Warteschlange',
	'deletequeue-review-action' => 'Auszuführende Aktion:',
	'deletequeue-review-delete' => 'Seite löschen.',
	'deletequeue-review-change' => 'Seite löschen, aber mit einem anderen Grund.',
	'deletequeue-review-requeue' => 'Seite in diese Lösch-Warteschlange verschieben:',
	'deletequeue-review-dequeue' => 'Keine Aktion ausführen und Seite aus der Lösch-Warteschlange entfernen.',
	'deletequeue-review-reason' => 'Kommentare:',
	'deletequeue-review-newreason' => 'Neuer Grund:',
	'deletequeue-review-newextra' => 'Weitere Informationen:',
	'deletequeue-review-submit' => 'Überprüfung speichern',
	'deletequeue-review-original' => 'Grund für den Antrag',
	'deletequeue-actiondisabled-involved' => 'Die folgende Aktion ist deaktiviert, weil du in dieser Löschsache bereits als $1 teilgenommen hast:',
	'deletequeue-actiondisabled-notexpired' => 'Die folgende Aktion ist deaktiviert, weil der Löschantrag noch nicht ausgelaufen ist:',
	'deletequeue-review-badaction' => 'Du hast eine ungültige Aktion angegeben',
	'deletequeue-review-actiondenied' => 'Du hast eine Aktion angegeben, die für diese Seite deaktiviert ist',
	'deletequeue-review-objections' => "'''Warnung''': Gegen die Löschung dieser Seite wurde [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} Widerspruch eingelegt].
Bitte prüfe die Widerspruchs-Argumente, bevor du diese Seite löschst.",
	'deletequeue-reviewspeedy-tab' => 'Schnelllöschung prüfen',
	'deletequeue-reviewspeedy-title' => 'Schnelllöschantrag für „$1“ prüfen',
	'deletequeue-reviewspeedy-text' => "Auf dieser Seite kannst du den Schnelllöschantrag für „'''$1'''“ überprüfen.
Bitte stelle sicher, dass diese Seite in Übereinstimmung mit den Richtlinien schnellgelöscht werden kann.",
	'deletequeue-reviewprod-tab' => 'Löschantrag prüfen',
	'deletequeue-reviewprod-title' => 'Löschantrag für „$1“ prüfen',
	'deletequeue-reviewprod-text' => "Auf dieser Seite kannst du den unumstrittenen Löschantrag für „'''$1'''“ prüfen.",
	'deletequeue-reviewdeletediscuss-tab' => 'Löschung prüfen',
	'deletequeue-reviewdeletediscuss-title' => 'Löschdiskussion für „$1“ prüfen',
	'deletequeue-reviewdeletediscuss-text' => "Auf dieser Seite kannst du die Löschdiskussion von „'''$1'''“ prüfen.

Es gibt eine [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Liste] mit Stimmen für und gegen die Löschung; die eigentliche Diskussion ist unter [[$2]] zu finden.
Bitte achte darauf, dass deine Entscheidung mit dem Konsens der Diskussion vereinbar ist.",
	'deletequeue-review-success' => 'Du hast erfolgreich die Löschung dieser Seite geprüft',
	'deletequeue-review-success-title' => 'Prüfung abgeschlossen',
	'deletequeue-deletediscuss-discussionpage' => 'Dies ist die Diskussionsseite für die Löschung von [[$1]].
Momentan {{PLURAL:$2|unterstützt ein|unterstützen $2}} Benutzer die Löschung, während $3 Benutzer sie ablehnen.
Du kannst die Löschung [{{fullurl:$1|action=delvote}} befürworten oder ablehnen] oder [{{fullurl:$1|action=delviewvotes}} alle Stimmen ansehen].',
	'deletequeue-discusscreate-summary' => 'Löschdiskussion für [[$1]] wird erstellt.',
	'deletequeue-discusscreate-text' => 'Die Löschung wurde aus folgendem Grund vorgeschlagen: $2',
	'deletequeue-role-nominator' => 'ursprünglicher Löschantragsteller',
	'deletequeue-role-vote-endorse' => 'Befürworter der Löschung',
	'deletequeue-role-vote-object' => 'Gegner der Löschung',
	'deletequeue-vote-tab' => 'Löschung befürworten/ablehnen',
	'deletequeue-vote-title' => 'Löschung von „$1“ befürworten oder ablehnen',
	'deletequeue-vote-text' => "Auf dieser Seite kannst du die Löschung von „'''$1'''“ befürworten oder ablehnen.
Diese Aktion überschreibt alle Stimmen, die du vorher zur Löschung dieser Seite abgegeben hast.
Du kannst die bereits abgegebenen Stimmen [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ansehen].
Der Löschantragsgrund war ''$2''.",
	'deletequeue-vote-legend' => 'Löschung befürworten/ablehnen',
	'deletequeue-vote-action' => 'Empfehlung:',
	'deletequeue-vote-endorse' => 'Löschung befürworten.',
	'deletequeue-vote-object' => 'Löschung ablehnen.',
	'deletequeue-vote-reason' => 'Kommentare:',
	'deletequeue-vote-submit' => 'Abschicken',
	'deletequeue-vote-success-endorse' => 'Die hast erfolgreich die Löschung dieser Seite befürwortet.',
	'deletequeue-vote-success-object' => 'Du hast erfolgreich die Löschung dieser Seite abgelehnt.',
	'deletequeue-vote-requeued' => 'Du hast erfolgreich die Löschung dieser Seite abgelehnt.
Durch deinen Widerspruch wurde die Seite in die Lösch-Warteschlange $1 verschoben.',
	'deletequeue-showvotes' => 'Befürwortungen und Ablehnungen der Löschung von „$1“',
	'deletequeue-showvotes-text' => "Untenstehend sind die Befürwortungen und Ablehnungen der Löschung von „'''$1'''“.
Du kannst deine eigene Befürwortung oder Ablehnung der Löschung [{{fullurl:{{FULLPAGENAME}}|action=delvote}} hier] eintragen.",
	'deletequeue-showvotes-restrict-endorse' => 'Nur Befürwortungen anzeigen',
	'deletequeue-showvotes-restrict-object' => 'Nur Ablehnungen anzeigen',
	'deletequeue-showvotes-restrict-none' => 'Alle Befürwortungen und Ablehnungen anzeigen',
	'deletequeue-showvotes-vote-endorse' => "Löschung um $1 $2 '''befürwortet'''",
	'deletequeue-showvotes-vote-object' => "Löschung um $1 $2 '''abgelehnt'''",
	'deletequeue-showvotes-showingonly-endorse' => 'Nur Befürwortungen werden angezeigt',
	'deletequeue-showvotes-showingonly-object' => 'Nur Ablehnungen werden angezeigt.',
	'deletequeue-showvotes-none' => 'Es gibt keine Befürwortungen oder Ablehnungen der Löschung dieser Seite.',
	'deletequeue-showvotes-none-endorse' => 'Es gibt keine Befürwortungen der Löschung dieser Seite.',
	'deletequeue-showvotes-none-object' => 'Es gibt keine Ablehnungen der Löschung dieser Seite.',
	'deletequeue' => 'Lösch-Warteschlange',
	'deletequeue-list-text' => 'Diese Seite zeigt alle Seiten an, die sich im Löschsystem befinden.',
	'deletequeue-list-search-legend' => 'Suche nach Seiten',
	'deletequeue-list-queue' => 'Warteschlange:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Zeige nur zu schließende Löschanträge.',
	'deletequeue-list-search' => 'Suche',
	'deletequeue-list-anyqueue' => '(irgendeine)',
	'deletequeue-list-votes' => 'Stimmenliste',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|Befürwortung|Befürwortungen}}, $2 {{PLURAL:$2|Ablehnung|Ablehnungen}}',
	'deletequeue-list-header-page' => 'Seite',
	'deletequeue-list-header-queue' => 'Warteschlange',
	'deletequeue-list-header-votes' => 'Befürwortungen und Ablehnungen',
	'deletequeue-list-header-expiry' => 'Ablaufdatum',
	'deletequeue-list-header-discusspage' => 'Diskussionsseite',
	'deletequeue-case-intro' => 'Diese Seite listet Informationen über einen Löschantrag auf.',
	'deletequeue-list-header-reason' => 'Löschbegründung',
	'deletequeue-case-votes' => 'Befürwortungen/Einwände:',
	'deletequeue-case-title' => 'Weiterführende Details',
	'deletequeue-case-details' => 'Basisdetails',
	'deletequeue-case-page' => 'Seite:',
	'deletequeue-case-reason' => 'Begründung:',
	'deletequeue-case-expiry' => 'Ablaufdatum:',
	'deletequeue-case-needs-review' => 'Dieser Fall braucht eine [[$1|Überprüfung]].',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'deletequeue-review-success' => 'Sie haben erfolgreich die Löschung dieser Seite geprüft',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 */
$messages['el'] = array(
	'deletequeue-case-reason' => 'Αιτία:',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'deletequeue-action-queued' => 'Forigo',
	'deletequeue-action' => 'Sugesti forigon',
	'deletequeue-action-title' => 'Sugesti forigon de "$1"',
	'deletequeue-generic-reasons' => '*Ĝeneralaj kialoj
 ** Vandalismo
 ** Spamo
 ** Prizorgado
 ** El la projekta regiono',
	'deletequeue-nom-alreadyqueued' => 'Ĉi tiu paĝo jam en la foriga listo.',
	'deletequeue-speedy-title' => 'Marki "$1" por rapida forigo',
	'deletequeue-prod-title' => 'Proponi forigon de "$1"',
	'deletequeue-delnom-reason' => 'Kialo por kandidateco:',
	'deletequeue-delnom-otherreason' => 'Alia kialo',
	'deletequeue-delnom-extra' => 'Plia informo:',
	'deletequeue-delnom-submit' => 'Sendi peton',
	'deletequeue-log-rmspeedy' => 'neis rapide forigi [[$1]].',
	'deletequeue-log-dequeue' => "forviŝis [[$1]] el la forigada listo '$2'.",
	'right-speedy-nominate' => 'Kandidatigi paĝojn por rapida forigo',
	'right-speedy-review' => 'Kontroli kandidatojn por rapida forigo',
	'right-prod-nominate' => 'Proponi forigon de paĝo',
	'right-deletediscuss-nominate' => 'malfermi diskuton pri forigado',
	'right-deletediscuss-review' => 'Fermi diskuton pri forigado',
	'right-deletequeue-vote' => 'Kunsenti aŭ malkunsenti forigojn',
	'deletequeue-queue-speedy' => 'Rapida forigo',
	'deletequeue-queue-prod' => 'Proponita forigo',
	'deletequeue-queue-deletediscuss' => 'Diskuto pri forigo',
	'deletequeue-page-prod' => "Estis proponita ke ĉi tiu paĝo estas forigenda.
La kialo donita estis ''$1''.
Se ĉi tiun proponon neniu ajn kontraŭus de ''$2'', ĉi tiu paĝon estus forigita.
Vi povas kontraŭi la forigon de ĉi tiu paĝo de [{{fullurl:{{FULLPAGENAME}}|action=delvote}} oponado de la forigo].",
	'deletequeue-review-action' => 'Ago por fari:',
	'deletequeue-review-delete' => 'Forigi la paĝon.',
	'deletequeue-review-change' => 'Forigi ĉi tiun paĝon, sed kun malsama kialo.',
	'deletequeue-review-requeue' => 'Movi ĉi tiun paĝon al la jena listo:',
	'deletequeue-review-dequeue' => 'Fari nenion, kaj forigi la paĝon de la forigo-listo.',
	'deletequeue-review-reason' => 'Komentoj:',
	'deletequeue-review-newreason' => 'Nova kialo:',
	'deletequeue-review-newextra' => 'Plia informo:',
	'deletequeue-review-submit' => 'Konservi Kontrolon',
	'deletequeue-review-original' => 'Kialo por peto',
	'deletequeue-review-badaction' => 'Vi specifis nevalidan agon',
	'deletequeue-review-actiondenied' => 'Vi specifis agon kiu estas malŝalta por ĉi tiu paĝo',
	'deletequeue-reviewspeedy-tab' => 'Kontroli rapidan forigon',
	'deletequeue-reviewspeedy-title' => 'Kontroli kandidatecon de rapida forigado de "$1"',
	'deletequeue-reviewprod-tab' => 'Kontroli proponitan forigon',
	'deletequeue-reviewprod-title' => 'Kontroli proponitan forigadon de "$1"',
	'deletequeue-reviewdeletediscuss-tab' => 'Kontroli forigon',
	'deletequeue-discusscreate-text' => 'Forigo estis proponita pro la jena kialo: $2',
	'deletequeue-role-nominator' => 'originala proponinto por forigo',
	'deletequeue-role-vote-endorse' => 'konsentanto de forigo',
	'deletequeue-role-vote-object' => 'malkonsentanto de forigo',
	'deletequeue-vote-tab' => 'Konsenti/Malkonsenti forigon',
	'deletequeue-vote-legend' => 'Konsenti/Malkonsenti forigon.',
	'deletequeue-vote-action' => 'Rekomendo:',
	'deletequeue-vote-endorse' => 'Konsenti forigon.',
	'deletequeue-vote-object' => 'Malkonsenti forigon.',
	'deletequeue-vote-reason' => 'Komentoj:',
	'deletequeue-vote-submit' => 'Ek',
	'deletequeue-vote-success-endorse' => 'Vi sukcese subtenis la forigon de ĉi tiu paĝo.',
	'deletequeue-vote-success-object' => 'Vi sukcese malkonsentis la forigon de ĉi tiu paĝo.',
	'deletequeue-vote-requeued' => 'Vi sukcese malkonsentis la forigon de ĉi tiu paĝo.
Pro via malkonsento, la paĝo estis movita al la laborlisto $1.',
	'deletequeue' => 'Listo de forigoj',
	'deletequeue-list-search-legend' => 'Serĉi paĝojn',
	'deletequeue-list-queue' => 'Atendovico:',
	'deletequeue-list-status' => 'Statuso:',
	'deletequeue-list-search' => 'Serĉi',
	'deletequeue-list-anyqueue' => '(iu)',
	'deletequeue-list-votes' => 'Listo de voĉdonoj',
	'deletequeue-list-header-page' => 'Paĝo',
	'deletequeue-list-header-queue' => 'Laborlisto',
	'deletequeue-list-header-votes' => 'Aproboj kaj malaproboj',
	'deletequeue-list-header-expiry' => 'Findato',
	'deletequeue-list-header-discusspage' => 'Diskuto-paĝo',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Imre
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'deletequeue-desc' => 'Crea un [[Special:DeleteQueue|sistema de listas para organizar los borrados]]',
	'deletequeue-action-queued' => 'Borrado',
	'deletequeue-action' => 'Sugiera un borrado',
	'deletequeue-action-title' => 'Sugiera el borrado de «$1»',
	'deletequeue-action-text' => "{{SITENAME}} tiene varios procedimientos para borrar páginas:
*Si Ud. cree que la página es candidata para  ''borrado rápido'', puede sugerirlo [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} aquí].
*Si la página no reúne las condiciones para borrado rápido, pero ''su borrado no generaría oposición o conflictos'', puede proponer su [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} borrado directo].
*Si puede existir oposición al borrado, debería abrir [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} una propuesta de borrado].",
	'deletequeue-action-text-queued' => 'Ud. debe leer las siguientes páginas para este caso de borrado:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Opiniones a favor y en contra].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Opine sobre el borrado de esta página].',
	'deletequeue-permissions-noedit' => 'Tienes que ser capaz de editar una página para ser capaz de afectar su status de borrado.',
	'deletequeue-generic-reasons' => '* Razones genéricas
  ** Vandalismo
  ** Spam
  ** Mantenimiento
  ** Fuera del enfoque del proyecto',
	'deletequeue-nom-alreadyqueued' => 'Esta página ya está en una cola de borrado',
	'deletequeue-speedy-title' => 'Marcar "$1" para borrado rápido',
	'deletequeue-prod-title' => 'Proponer borrado de "$1"',
	'deletequeue-delnom-reason' => 'Razón para nominación:',
	'deletequeue-delnom-otherreason' => 'Otra razón',
	'deletequeue-delnom-extra' => 'Información extra:',
	'deletequeue-delnom-submit' => 'Enviar nominación',
	'deletequeue-log-nominate' => "nominado [[$1]] para borrado en la cola '$2'.",
	'deletequeue-log-requeue' => "transferido [[$1]] a una cola de borrado diferente: de '$2' a '$3'.",
	'deletequeue-log-dequeue' => "removido [[$1]] de la cola de borrado '$2'.",
	'right-speedy-nominate' => 'Nominar páginas para borrado rápido',
	'right-speedy-review' => 'Revisar nominaciones para borrado rápido',
	'right-prod-nominate' => 'Proponer borrado de página',
	'right-prod-review' => 'Revisar propuestas no contestadas de borrado',
	'right-deletediscuss-nominate' => 'Comenzar discusiones de borrado',
	'right-deletediscuss-review' => 'Cerrar discusiones de borrado',
	'deletequeue-queue-speedy' => 'Borrado rápido',
	'deletequeue-queue-prod' => 'Borrado propuesto',
	'deletequeue-queue-deletediscuss' => 'Discusión de borrado',
	'deletequeue-page-speedy' => "Esta página ha sido nominada para borrado rápido.
La razón dada para este borrado es ''$1''.",
	'deletequeue-review-action' => 'Acción a tomar:',
	'deletequeue-review-delete' => 'Borrar la página.',
	'deletequeue-review-requeue' => 'Transferir esta página a la siguiente cola:',
	'deletequeue-review-dequeue' => 'No tomar acción, y remover la página de la cola de borrado.',
	'deletequeue-review-reason' => 'Comentarios:',
	'deletequeue-review-newreason' => 'Nueva razón:',
	'deletequeue-review-newextra' => 'Información extra:',
	'deletequeue-review-submit' => 'Grabar Revisión',
	'deletequeue-review-original' => 'Razón para nominación',
	'deletequeue-review-badaction' => 'Usted especificó una acción inválida',
	'deletequeue-review-actiondenied' => 'Usted ha especificado una acción la cual está dehabilitada para esta página',
	'deletequeue-reviewspeedy-tab' => 'Revisar borrado rápido',
	'deletequeue-reviewspeedy-title' => 'Revisar nominación de borrado rápido de "$1"',
	'deletequeue-reviewprod-tab' => 'revisar borrado propuesto',
	'deletequeue-reviewprod-title' => 'Revisar borrado propuesto de "$1"',
	'deletequeue-reviewdeletediscuss-tab' => 'Revisar borrado',
	'deletequeue-reviewdeletediscuss-title' => 'Revisar discusión de borrado para "$1"',
	'deletequeue-review-success' => 'Has revisado exitosamente el borrado de esta página',
	'deletequeue-review-success-title' => 'Revisión completa',
	'deletequeue-discusscreate-summary' => 'creando discusión para el borrado de [[$1]].',
	'deletequeue-vote-action' => 'Recomendación:',
	'deletequeue-vote-reason' => 'Comentarios:',
	'deletequeue-vote-submit' => 'Enviar',
	'deletequeue-showvotes-restrict-object' => 'Mostrar objeciones solamente',
	'deletequeue-showvotes-showingonly-object' => 'Mostrando sólo objeciones',
	'deletequeue-showvotes-none-object' => 'No hay objeciones al borrado de esta página.',
	'deletequeue' => 'Cola de borrado',
	'deletequeue-list-search-legend' => 'Buscar páginas',
	'deletequeue-list-queue' => 'Cola:',
	'deletequeue-list-status' => 'Estatus:',
	'deletequeue-list-search' => 'Buscar',
	'deletequeue-list-anyqueue' => '(cualquiera)',
	'deletequeue-list-votes' => 'Lista de votos',
	'deletequeue-list-header-page' => 'Página',
	'deletequeue-list-header-queue' => 'Cola',
	'deletequeue-list-header-expiry' => 'Expirar',
	'deletequeue-list-header-discusspage' => 'Página de discusión',
	'deletequeue-list-header-reason' => 'Razón para borrado',
	'deletequeue-case-details' => 'Detalles básicos',
	'deletequeue-case-page' => 'Página:',
	'deletequeue-case-reason' => 'Razón:',
	'deletequeue-case-needs-review' => 'Este caso requiere [[$1|revisión]].',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'deletequeue-action-queued' => 'Ezabaketa',
	'deletequeue-action' => 'Ezabatzeko iradoki',
	'deletequeue-action-title' => '"$1" ezabatzeko iradoki',
	'deletequeue-generic-reasons' => '* Arrazoi motak:
** Bandalismoa
** Spam
** Mantenua
** Proiektuaren esparrutik kanpo kokatua',
	'deletequeue-nom-alreadyqueued' => 'Orrialde hau jada ezabaketa-ilaran dago.',
	'deletequeue-prod-title' => '"$1" ezabatzeko proposamena',
	'deletequeue-delnom-reason' => 'Izendapenaren arrazoia:',
	'deletequeue-delnom-otherreason' => 'Beste arrazoi bat',
	'deletequeue-delnom-extra' => 'Aparteko informazioa:',
	'deletequeue-delnom-submit' => 'Izendapena bidali',
	'deletequeue-log-dequeue' => "[[$1]] '$2' ezabatzeko ilaratik kendua.",
	'right-speedy-nominate' => 'Lehenbailehen ezabatzeko orrialdeak izendatu',
	'right-prod-nominate' => 'Orrialde bat ezabatzeko proposatu',
	'right-deletediscuss-nominate' => 'Ezabatzeko eztabaidak hasi',
	'deletequeue-queue-speedy' => 'Premiazko ezabaketa',
	'deletequeue-queue-deletediscuss' => 'Ezabaketa-eztabaida',
	'deletequeue-notqueued' => 'Zuk aukeratutako orrialdea ez dago ezabatzeko ilaran orain',
	'deletequeue-review-action' => 'Egin beharreko ekintza:',
	'deletequeue-review-delete' => 'Orrialdea ezabatu.',
	'deletequeue-review-reason' => 'Iruzkinak:',
	'deletequeue-review-newreason' => 'Arrazoi berria:',
	'deletequeue-review-newextra' => 'Aparteko informazioa:',
	'deletequeue-review-original' => 'Izendapenaren arrazoia',
	'deletequeue-discusscreate-summary' => '[[$1]] ezabatzeko eztabaida orria sortzen.',
	'deletequeue-vote-action' => 'Gomendioa:',
	'deletequeue-vote-reason' => 'Iruzkinak:',
	'deletequeue-vote-submit' => 'Bidali',
	'deletequeue' => 'Ezabaketa-ilara',
	'deletequeue-list-search-legend' => 'Orrialdeak bilatu',
	'deletequeue-list-queue' => 'Ilara:',
	'deletequeue-list-status' => 'Egoera:',
	'deletequeue-list-search' => 'Bilatu',
	'deletequeue-list-anyqueue' => '(edozein)',
	'deletequeue-list-votes' => 'Bozen zerrenda',
	'deletequeue-list-header-page' => 'Orrialdea',
	'deletequeue-list-header-queue' => 'Ilara',
	'deletequeue-list-header-expiry' => 'Epemuga',
	'deletequeue-list-header-discusspage' => 'Eztabaida orrialdea',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'deletequeue-desc' => 'Luo [[Special:DeleteQueue|jonopohjaisen järjestelmän poistojen hallintaan]].',
	'deletequeue-action-queued' => 'Poisto',
	'deletequeue-action' => 'Ehdota poistoa',
	'deletequeue-action-title' => 'Ehdota sivun ”$1” poistoa',
	'deletequeue-permissions-noedit' => 'Sivun poistamiseen vaikuttaminen edellyttää, että pystyt muokkaamaan sivua.',
	'deletequeue-generic-reasons' => '* Yleiset poistosyyt 
  ** Häiriköinti
  ** Mainostaminen
  ** Ylläpito
  ** Epäoleellinen projektille',
	'deletequeue-nom-alreadyqueued' => 'Sivu on valmiiksi poistojonossa.',
	'deletequeue-speedy-title' => 'Merkitse ”$1” poistettavaksi',
	'deletequeue-prod-title' => 'Ehdota sivun ”$1” poistoa',
	'deletequeue-prod-text' => "Voit ehdottaa sivun '''$1''' poistamista tällä lomakkeella.

Jos viiden päivän jälkeen kukaan ei ole kyseenalaistanut sivun poistamista, ylläpitäjän tarkastaa ja poistaa sen.",
	'deletequeue-prod-reasons' => '-',
	'deletequeue-delnom-reason' => 'Syy ehdollepanoon:',
	'deletequeue-delnom-otherreason' => 'Muu syy',
	'deletequeue-delnom-extra' => 'Lisätiedot',
	'deletequeue-delnom-submit' => 'Lähetä ehdollepano',
	'deletequeue-log-requeue' => 'siirrettiin [[$1]] toiseen poistojonoon: jonosta ”$2” jonoon ”$3”.',
	'deletequeue-log-dequeue' => 'poistettiin [[$1]] poistojonosta ”$2”.',
	'right-speedy-nominate' => 'Ehdottaa sivuja nopeaan poistoon',
	'right-speedy-review' => 'Tarkastaa nopean poiston ehdotukset',
	'right-prod-nominate' => 'Ehdottaa sivun poistoa',
	'right-prod-review' => 'Tarkastaa kaikki poistoehdotukset, joista ei ole äänestetty',
	'right-deletediscuss-nominate' => 'Aloittaa poistokeskustelu',
	'right-deletediscuss-review' => 'Sulkea poistokeskustelu',
	'right-deletequeue-vote' => 'Kannattaa tai vastustaa poistoja',
	'deletequeue-queue-speedy' => 'Nopea poisto',
	'deletequeue-queue-prod' => 'Ehdotettu poisto',
	'deletequeue-queue-deletediscuss' => 'Poistokeskustelu',
	'deletequeue-page-speedy' => "Tätä sivua on ehdotettu nopeasti poistettavaksi.
Syyksi tälle annettiin ''$1''.",
	'deletequeue-notqueued' => 'Valitsemasi sivu ei ole poistojonossa.',
	'deletequeue-review-action' => 'Toimenpide:',
	'deletequeue-review-delete' => 'Poista sivu.',
	'deletequeue-review-change' => 'Poista sivu, mutta eri perusteluilla.',
	'deletequeue-review-requeue' => 'Siirrä tämä sivu seuraavaan jonoon:',
	'deletequeue-review-dequeue' => 'Älä tee mitään ja poista sivu poistojonosta.',
	'deletequeue-review-reason' => 'Kommentit:',
	'deletequeue-review-newreason' => 'Uusi syy:',
	'deletequeue-review-newextra' => 'Lisätietoja:',
	'deletequeue-review-submit' => 'Tallenna katsaus',
	'deletequeue-review-original' => 'Syy ehdollepanolle',
	'deletequeue-actiondisabled-notexpired' => 'Seuraava toiminto on estetty, koska poistoehdotus ei ole vielä vanhentunut:',
	'deletequeue-review-badaction' => 'Määrittelit virheellisen toiminnon',
	'deletequeue-review-actiondenied' => 'Määrittelit toiminnon, joka on estetty tälle sivulle.',
	'deletequeue-review-objections' => "'''Varoitus''': Tämän sivun poistolla on [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} vastaväitettä].
Varmista, että olet ottanut huomioon nämä vastaväitteet ennen sivun poistoa.",
	'deletequeue-reviewspeedy-tab' => 'Tarkasta nopea poisto',
	'deletequeue-reviewspeedy-title' => 'Tarkasta sivun ”$1” nopean poiston ehdotus',
	'deletequeue-reviewspeedy-text' => "Voit käyttää tätä lomaketta sivun ”'''$1'''” nopean poiston ehdotuksen tarkastamiseen.
Huomaa, että tämä sivu voidaan poistaa nopeasti käytännön mukaisesti.",
	'deletequeue-reviewprod-tab' => 'Tarkasta ehdotettu poisto',
	'deletequeue-reviewprod-title' => 'Tarkasta sivun ”$1” ehdotettu poisto',
	'deletequeue-reviewdeletediscuss-tab' => 'Tarkasta poisto',
	'deletequeue-reviewdeletediscuss-title' => 'Tarkasta sivun ”$1” poistokeskustelu',
	'deletequeue-discusscreate-summary' => 'Luodaan keskustelusivua sivun [[$1]] poistosta.',
	'deletequeue-discusscreate-text' => 'Poistoa ehdotettiin seuraavan syyn takia: $2',
	'deletequeue-role-nominator' => 'alkuperäinen poiston ehdottaja',
	'deletequeue-role-vote-endorse' => 'poiston siirtäjä',
	'deletequeue-vote-title' => 'Myötäile tai vastusta sivun ”$1” poistoa',
	'deletequeue-vote-action' => 'Suositus:',
	'deletequeue-vote-endorse' => 'Hyväksy poisto.',
	'deletequeue-vote-object' => 'Vastusta poistoa.',
	'deletequeue-vote-reason' => 'Kommentit:',
	'deletequeue-vote-submit' => 'Lähetä',
	'deletequeue-vote-success-endorse' => 'Äänesi sivun poiston puolesta on kirjattu.',
	'deletequeue-vote-success-object' => 'Äänesi sivun säilyttämisen puolesta on kirjattu.',
	'deletequeue-showvotes' => 'Sivun ”$1” vastustajat ja hyväksyjät',
	'deletequeue-showvotes-restrict-endorse' => 'Näytä vain hyväksyjät',
	'deletequeue-showvotes-restrict-object' => 'Näytä vain vastustajat',
	'deletequeue-showvotes-restrict-none' => 'Näytä kaikki vastustajat ja hyväksyjät',
	'deletequeue-showvotes-showingonly-endorse' => 'Näytetään vain hyväksyjät',
	'deletequeue-showvotes-showingonly-object' => 'Näytetään vain vastustajat',
	'deletequeue-showvotes-none' => 'Tämän sivun poistolle ei ole yhtään vastustajaa tai hyväksyjää.',
	'deletequeue-showvotes-none-endorse' => 'Tämän sivun poistolle ei ole yhtään hyväksyjää.',
	'deletequeue-showvotes-none-object' => 'Tämän sivun poistolle ei ole yhtään vastustajaa.',
	'deletequeue' => 'Poistojono',
	'deletequeue-list-text' => 'Tällä sivulla näkyy kaikki poistojärjestelmässä olevat sivut.',
	'deletequeue-list-search-legend' => 'Etsi sivuja',
	'deletequeue-list-queue' => 'Jono:',
	'deletequeue-list-status' => 'Tila:',
	'deletequeue-list-expired' => 'Näytä vain sulkemista vaativat ehdotukset.',
	'deletequeue-list-search' => 'Etsi',
	'deletequeue-list-anyqueue' => '(mikä tahansa)',
	'deletequeue-list-votes' => 'Äänestyslista',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|hyväksyjä|hyväksyjää}} ja $2 {{PLURAL:$2|vastustaja|vastustajaa}}',
	'deletequeue-list-header-page' => 'Sivu',
	'deletequeue-list-header-queue' => 'Jono',
	'deletequeue-list-header-votes' => 'Hyväksyjät ja vastustajat',
	'deletequeue-list-header-discusspage' => 'Keskustelusivu',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Meno25
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'deletequeue-desc' => 'Crée un [[Special:DeleteQueue|système de queue pour gérer les suppression]]',
	'deletequeue-action-queued' => 'Suppression',
	'deletequeue-action' => 'Suggérer la suppression',
	'deletequeue-action-title' => 'Suggérer la suppression de « $1 »',
	'deletequeue-action-text' => "{{SITENAME}} dispose d'un nombre de processus pour la suppression des pages :
*Si vous croyez que cette page doit passer par une ''suppression immédiate'', vous pouvez en faire la demande [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} ici].
*Si cette page ne relève pas de la suppression immédiate, mais ''que cette suppression ne posera aucune controverse pour'', vous devrez [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} proposer une suppression non contestable].
*Si la suppression de la page est ''sujète à controverses'', vous devrez [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} ouvrir une discussion].",
	'deletequeue-action-text-queued' => 'Vous pouvez visionner les pages suivantes pour cette suppression :
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Voir les acquiescements et les objections].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Accepter ou objection pour la suppression de cette page].',
	'deletequeue-permissions-noedit' => 'Vous devez être capable de modifier une page pour pourvoir affecter son statut de suppression.',
	'deletequeue-generic-reasons' => '*Motifs les plus courants
** Vandalisme
** Pourriel
** Maintenance
** Hors critères',
	'deletequeue-nom-alreadyqueued' => 'Cette page est déjà dans la queue des suppressions.',
	'deletequeue-speedy-title' => 'Marquer « $1 » pour une suppression immédiate',
	'deletequeue-speedy-text' => "Vous pouvez utiliser ce formulaire pour parquer la page « '''$1''' » pour une suppression immédiate.

Un administrateur étudiera cette requête et, si elle est bien fondée, supprimera la page.
Vous devez sélectionner un motif à partir de la liste déroulante ci-dessous, et ajouter d’autres information y afférentes.",
	'deletequeue-prod-title' => 'Proposer la suppression de « $1 »',
	'deletequeue-prod-text' => "Vous pouvez utiliser ce formulaire pour propose que « '''$1''' » soit supprimée.

Si, après cinq jours, personne n’a émis d’objection pour cela, elle sera supprimée, après un examen final, par un administrateur.",
	'deletequeue-delnom-reason' => 'Motif pour la nomination :',
	'deletequeue-delnom-otherreason' => 'Autre raison',
	'deletequeue-delnom-extra' => 'Informations supplémentaires :',
	'deletequeue-delnom-submit' => 'Soumettre la nomination',
	'deletequeue-log-nominate' => '[[$1]] nominé pour la suppression dans la queue « $2 ».',
	'deletequeue-log-rmspeedy' => 'refusé pour la suppression immédiate de [[$1]].',
	'deletequeue-log-requeue' => '[[$1]] transféré vers une queue de suppression différente : de « $2 » vers « $3 ».',
	'deletequeue-log-dequeue' => '[[$1]] enlevé depuis la queue de suppression « $2 ».',
	'right-speedy-nominate' => 'Nomine les pages pour une suppression immédiate.',
	'right-speedy-review' => 'Revoir les nominations pour la suppression immédiate',
	'right-prod-nominate' => 'Proposer la suppression de la page',
	'right-prod-review' => 'Revoir les propositions de suppression non contestées',
	'right-deletediscuss-nominate' => 'Commencer les discussions sur la suppression',
	'right-deletediscuss-review' => 'Clôturer les discussions sur la suppression',
	'right-deletequeue-vote' => 'Acquiescer ou objecter pour les suppressions',
	'deletequeue-queue-speedy' => 'Suppression immédiate',
	'deletequeue-queue-prod' => 'Suppression proposée',
	'deletequeue-queue-deletediscuss' => 'Discussion sur la suppression',
	'deletequeue-page-speedy' => "Cette page a été nominée pour une suppression immédiate.
La raison invoquée pour cela est ''« $1 »''.",
	'deletequeue-page-prod' => "Il a été proposé la suppression de cette page.
La raison invoquée est ''« $1 »''.
Si la proposition ne rencontre aucune objection sur ''$2'', la page sera supprimée.
Vous pouvez contester cette suppression en [{{fullurl:{{FULLPAGENAME}}|action=delvote}} vous y opposant].",
	'deletequeue-page-deletediscuss' => "Cette page a été proposée à la suppression, mais cette requête a été contestée.
Le motif invoqué était « $1 ».
Une discussion est en cours sur [[$5]], elle terminera le ''$2''.",
	'deletequeue-notqueued' => 'La page que vous avez sélectionnée n’est pas dans la queue des suppression',
	'deletequeue-review-action' => 'Action à prendre :',
	'deletequeue-review-delete' => 'Supprimer la page.',
	'deletequeue-review-change' => 'Supprimer cette page, mais avec une autre raison.',
	'deletequeue-review-requeue' => 'Transférer cette page vers la queue suivante :',
	'deletequeue-review-dequeue' => 'Ne rien faire et retirer la page de la queue de suppression.',
	'deletequeue-review-reason' => 'Commentaires :',
	'deletequeue-review-newreason' => 'Nouveau motif :',
	'deletequeue-review-newextra' => 'Information supplémentaire :',
	'deletequeue-review-submit' => 'Sauvegarder la relecture',
	'deletequeue-review-original' => 'Motif de la nomination',
	'deletequeue-actiondisabled-involved' => 'L’action suivante est désactivée car vous avez pris part dans ce cas de suppression dans le sens de $1 :',
	'deletequeue-actiondisabled-notexpired' => 'L’action suivante a été désactivée car le délai pour la nomination à la suppression n’est pas encore expiré :',
	'deletequeue-review-badaction' => 'Vous avez indiqué une action incorrecte',
	'deletequeue-review-actiondenied' => 'Vous avez indiqué une action qui est désactivée pour cette page.',
	'deletequeue-review-objections' => "'''Attention''' : la suppression de cette page est [{{FULLURL:{{FULLPAGENAME}}|action=delvoteview|votetype=object}} contestée]. Assurez-vous que vous ayez examiné ces objections avant sa suppression.",
	'deletequeue-reviewspeedy-tab' => 'Revoir la suppression immédiate',
	'deletequeue-reviewspeedy-title' => 'Revoir la suppression immédiate de « $1 »',
	'deletequeue-reviewspeedy-text' => "Vous pouvez utiliser ce formulaire pour revoir la nommination de « '''$1''' » en suppression immédiate.
Veuillez vous assurer que cette page peut être supprimée de la sorte en conformité des règles du projet.",
	'deletequeue-reviewprod-tab' => 'Revoir les suppressions proposées',
	'deletequeue-reviewprod-title' => 'Revoir la suppression proposée pour « $1 »',
	'deletequeue-reviewprod-text' => "Vous pouvez utiliser ce formulaire pour revoir la proposition non contestée pour supprimer « '''$1''' ».",
	'deletequeue-reviewdeletediscuss-tab' => 'Revoir la suppression',
	'deletequeue-reviewdeletediscuss-title' => 'Revoir la discussion de la suppression pour « $1 »',
	'deletequeue-reviewdeletediscuss-text' => "Vous pouvez utiliser ce formulaire pour revoir la discussion concernant la suppression de « ''$1''».

Une [{{FULLURL:{{FULLPAGENAME}}|action=delviewvotes}} liste] des « pour » et des « contre » est disponible, la discussion par elle-même disponible sur [[$2]].
Veuillez vous assurer que vous ayez pris une décision en conformité du consensus issus de la discussion.",
	'deletequeue-review-success' => 'Vous avez revu avec succès la suppression de cette page',
	'deletequeue-review-success-title' => 'Révision complète',
	'deletequeue-deletediscuss-discussionpage' => 'Ceci est la page de discussion concernant la suppression de [[$1]].
Il y a actuellement $2 {{PLURAL:$2|utilisateur|utilisateurs}} en faveur, et $3 {{PLURAL:$3|utilisateur|utilisateurs}} qui y sont opposés.
Vous pouvez [{{FULLURL:$1|action=delvote}} appuyez ou refuser] la suppression, ou [{{FULLURL:$1|action=delviewvotes}} voir tous les « pour » et les « contre »].',
	'deletequeue-discusscreate-summary' => 'Création de la discussion concernant la suppression de [[$1]].',
	'deletequeue-discusscreate-text' => 'Suppression proposée pour la raison suivante : $2',
	'deletequeue-role-nominator' => 'initiateur original de la suppression',
	'deletequeue-role-vote-endorse' => 'Partisan pour la suppression',
	'deletequeue-role-vote-object' => 'Opposant à la suppression',
	'deletequeue-vote-tab' => 'Voter sur la suppression',
	'deletequeue-vote-title' => 'Appuyer ou refuser la suppression de « $1 »',
	'deletequeue-vote-text' => "Vous pouvez utiliser ce formulaire pour appuyer ou refuser la suppression de « '''$1''' ».
Cette action écrasera les avis que vous avez émis auparavant dans cette discussion.
Vous pouvez [{{FULLURL:{{FULLPAGENAME}}|action=delviewvotes}} voir] les différents avis déjà émis.
Le motif indiqué pour la nomination à la suppression était ''« $2 »''.",
	'deletequeue-vote-legend' => 'Appuyer/Refuser la suppression',
	'deletequeue-vote-action' => 'Recommandation :',
	'deletequeue-vote-endorse' => 'Appuie la suppression',
	'deletequeue-vote-object' => 'S’oppose à la suppression.',
	'deletequeue-vote-reason' => 'Commentaires :',
	'deletequeue-vote-submit' => 'Soumettre',
	'deletequeue-vote-success-endorse' => 'Vous avez appuyé, avec succès, la demande de suppression de cette page.',
	'deletequeue-vote-success-object' => 'Vous avez refusé, avec succès, la demande de suppression de cette page.',
	'deletequeue-vote-requeued' => 'Vous avez rejeté, avec succès, la demande de suppression de cette page.
Par votre refus, la page été déplacée dans la queue $1.',
	'deletequeue-showvotes' => 'Accords et refus concernant la suppression de « $1 »',
	'deletequeue-showvotes-text' => "Voici, ci-dessous, les accords et les désaccords émis en vue de la suppression de la page « '''$1''' ».
Vous pouvez enregistrer [{{FULLURL:{{FULLPAGENAME}}|action=delvote}} ici] votre propre accord ou désaccord sur cette suppression.",
	'deletequeue-showvotes-restrict-endorse' => 'Affiche uniquement les partisans',
	'deletequeue-showvotes-restrict-object' => 'Voir uniquement les oppositions',
	'deletequeue-showvotes-restrict-none' => 'Visionner tous les accords et les refus.',
	'deletequeue-showvotes-vote-endorse' => "'''Pour''' la suppression $2 le $1",
	'deletequeue-showvotes-vote-object' => "'''Contre''' la suppression $2 le $1",
	'deletequeue-showvotes-showingonly-endorse' => 'Ne voir que les accords',
	'deletequeue-showvotes-showingonly-object' => 'Ne voir que les refus',
	'deletequeue-showvotes-none' => 'Il n’existe ni « pour », ni « contre » la suppression de cette page.',
	'deletequeue-showvotes-none-endorse' => 'Personne ne s’est prononcé en faveur de la suppression de cette page.',
	'deletequeue-showvotes-none-object' => 'Personne ne s’est prononcé contre la suppression de cette page.',
	'deletequeue' => 'Queue de la suppression',
	'deletequeue-list-text' => 'Cette page affiche toutes les pages qui sont dans le système de suppression.',
	'deletequeue-list-search-legend' => 'Rechercher des pages',
	'deletequeue-list-queue' => 'Queue :',
	'deletequeue-list-status' => 'Statut :',
	'deletequeue-list-expired' => 'Ne voir que les clôture des nominations requises.',
	'deletequeue-list-search' => 'Rechercher',
	'deletequeue-list-anyqueue' => '(plusieurs)',
	'deletequeue-list-votes' => 'Liste des votes',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|accord|accords}}, $2 {{PLURAL:$2|refus|refus}}',
	'deletequeue-list-header-page' => 'Page',
	'deletequeue-list-header-queue' => 'Queue',
	'deletequeue-list-header-votes' => 'Accords et refus',
	'deletequeue-list-header-expiry' => 'Expiration',
	'deletequeue-list-header-discusspage' => 'Page de discussion',
	'deletequeue-case-intro' => 'Cette page liste des informations sur un cas spécifique de suppression.',
	'deletequeue-list-header-reason' => 'Motif de la suppression',
	'deletequeue-case-votes' => 'Pour / contre :',
	'deletequeue-case-title' => 'Détails du cas de suppression',
	'deletequeue-case-details' => 'Informations de base',
	'deletequeue-case-page' => 'Page :',
	'deletequeue-case-reason' => 'Raison :',
	'deletequeue-case-expiry' => 'Expiration :',
	'deletequeue-case-needs-review' => 'Ce cas requiert une [[$1|revue]].',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'deletequeue-review-reason' => 'Nótaí tráchta:',
	'deletequeue-vote-reason' => 'Nótaí tráchta:',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'deletequeue-desc' => 'Crea un [[Special:DeleteQueue|sitema baseado na cola para xestionar as eliminacións]]',
	'deletequeue-action-queued' => 'Borrado',
	'deletequeue-action' => 'Suxestionar o borrado',
	'deletequeue-action-title' => 'Suxestionar o borrado de "$1"',
	'deletequeue-action-text' => "{{SITENAME}} ten un número de procesos para borrar páxinas:
*Se cre que esta páxina posúe motivos xustificados para a súa ''eliminación rápida'', pode propoñelo [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} aquí].
*Se non os ten, pero a ''eliminación será probablemente sen controversia'', debería [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} propor un borrado non contestado].
*Se esta páxina de eliminación ''será probablemente contestada'', debería [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} abrir unha conversa].",
	'deletequeue-action-text-queued' => 'Pode ver as seguintes páxina para este caso de borrado:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Ver os apoios e as obxeccións actuais].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Apoiar este borrado ou obxectar no mesmo].',
	'deletequeue-permissions-noedit' => 'Debe ser capaz de editar unha páxina para poder afectar o seu status de borrado.',
	'deletequeue-generic-reasons' => '* Razóns xenéricas
  ** Vandalismo
  ** Spam
  ** Mantemento
  ** Fóra dos límites do proxecto',
	'deletequeue-nom-alreadyqueued' => 'Esta páxina xa está nunha cola de borrados.',
	'deletequeue-speedy-title' => 'Marcar "$1" para o seu borrado rápido',
	'deletequeue-speedy-text' => "Pode usar este formulario para marcar a páxina \"'''\$1'''\" para a súa eliminación rápida.

Un administrador revisará esta solicitude, e, se ten fundamentos, borrará a páxina.
Debe seleccionar un motivo para a eliminación da lista da caixa despregable de embaixo, e engadir calquera outra información relevante.",
	'deletequeue-prod-title' => 'Propor a eliminación de "$1"',
	'deletequeue-prod-text' => "Pode usar este formulario para propor \"'''\$1'''\" para a súa eliminación.

Se despois de cinco días ninguén dá contestación nesta páxina, será borrada tras unha revisión final feita por un administrador.",
	'deletequeue-delnom-reason' => 'Razón para a nominación:',
	'deletequeue-delnom-otherreason' => 'Outro motivo',
	'deletequeue-delnom-extra' => 'Información adicional:',
	'deletequeue-delnom-submit' => 'Enviar a nominación',
	'deletequeue-log-nominate' => 'nominou "[[$1]]" para a súa eliminación da cola "$2".',
	'deletequeue-log-rmspeedy' => 'declinou a eliminación rápida de "[[$1]]".',
	'deletequeue-log-requeue' => 'transferiu "[[$1]]" a unha cola de borrados diferente: de "$2" a "$3".',
	'deletequeue-log-dequeue' => 'eliminou "[[$1]]" da cola de borrados "$2".',
	'right-speedy-nominate' => 'Nominar páxinas para a súa eliminación rápida',
	'right-speedy-review' => 'Revisar as nominacións das eliminacións rápidas',
	'right-prod-nominate' => 'Propor o borrado dunha páxina',
	'right-prod-review' => 'Revisar as propostas de borrado non respostadas',
	'right-deletediscuss-nominate' => 'Comezar discusións de borrado',
	'right-deletediscuss-review' => 'Pechar discusións de borrado',
	'right-deletequeue-vote' => 'Apoiar os borrados ou obxectar nos mesmos',
	'deletequeue-queue-speedy' => 'Eliminación rápida',
	'deletequeue-queue-prod' => 'Borrado proposto',
	'deletequeue-queue-deletediscuss' => 'Discusión do borrado',
	'deletequeue-page-speedy' => "Esta páxina foi nominada para a súa eliminación rápida.
O motivo dado para este borrado é ''$1''.",
	'deletequeue-page-prod' => "Propoñeuse que esta páxina fose borrada.
A razón dada foi ''$1''.
Se esta proposta non recibe resposta en ''$2'', esta páxina será borrada.
Pode votar na páxina de eliminación [{{fullurl:{{FULLPAGENAME}}|action=delvote}} obxectando].",
	'deletequeue-page-deletediscuss' => "Esta páxina foi proposta para a súa eliminación e esa proposta foi presentada como candidata.
A razón dada foi ''\$1''.
Unha conversa está en curso en \"[[\$5]]\", a cal concluirá o ''\$2''.",
	'deletequeue-notqueued' => 'A páxina que seleccionou non está na cola de eliminación actualmente',
	'deletequeue-review-action' => 'Acción que levar a cabo:',
	'deletequeue-review-delete' => 'Borrar a páxina.',
	'deletequeue-review-change' => 'Eliminar esta páxina, pero cun motivo diferente.',
	'deletequeue-review-requeue' => 'Transferir esta páxina á seguinte cola:',
	'deletequeue-review-dequeue' => 'Non levar a cabo ningunha función e retirar a páxina da cola de eliminación.',
	'deletequeue-review-reason' => 'Comentarios:',
	'deletequeue-review-newreason' => 'Novo motivo:',
	'deletequeue-review-newextra' => 'Información adicional:',
	'deletequeue-review-submit' => 'Gardar a revisión',
	'deletequeue-review-original' => 'Motivo para a nominación',
	'deletequeue-actiondisabled-involved' => 'A seguinte acción está deshabilitada porque formou parte neste caso de borrado no papel de $1:',
	'deletequeue-actiondisabled-notexpired' => 'A seguinte acción está deshabilitada porque a nominación para o seu borrado aínda non caducou:',
	'deletequeue-review-badaction' => 'Especificou unha acción inválida',
	'deletequeue-review-actiondenied' => 'Especificou unha acción que foi deshabilitada para esta páxina',
	'deletequeue-review-objections' => "'''Aviso:''' a eliminación desta páxina ten [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} obxeccións].
Por favor, asegúrese que considerou estas obxeccións antes de borrar a páxina.",
	'deletequeue-reviewspeedy-tab' => 'Revisar a eliminación rápida',
	'deletequeue-reviewspeedy-title' => 'Revisar a nominación da eliminación rápida de "$1"',
	'deletequeue-reviewspeedy-text' => "Pode usar este formulario para revisar a nominación de \"'''\$1'''\" para a súa eliminación.
Por favor, asegúrese que esta páxina pode ser borrada rapidamente de acordo coa política.",
	'deletequeue-reviewprod-tab' => 'Revisar a proposta de eliminación',
	'deletequeue-reviewprod-title' => 'Revisar a proposta de eliminación de "$1"',
	'deletequeue-reviewprod-text' => "Pode usar este formulario para revisar a proposta de eliminación non respostada de \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Revisar o borrado',
	'deletequeue-reviewdeletediscuss-title' => 'Revisar a conversa de borrado de "$1"',
	'deletequeue-reviewdeletediscuss-text' => 'Pode usar este formulario para revisar a conversa de borrado de "\'\'\'$1\'\'\'".

Está dispoñible, unha [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] cos apoios e obxeccións desta eliminación, e a conversa pode ser atopada en "[[$2]]".
Por favor, asegúrese de que toma a decisión de acordo co consenso.',
	'deletequeue-review-success' => 'Revisou con éxito o borrado desta páxina',
	'deletequeue-review-success-title' => 'Revisión completada',
	'deletequeue-deletediscuss-discussionpage' => 'Esta é a páxina de conversa para a eliminación de "[[$1]]".
Actualmente hai $2 {{PLURAL:$2|usuario|usuarios}} que {{PLURAL:$2|apoia|apoian}} a eliminación, e $3 que {{PLURAL:$2|pon obxeccións|poñen obxeccións}}.
Pode [{{fullurl:$1|action=delvote}} apoiar ou obxectar] ou [{{fullurl:$1|action=delviewvotes}} ver todos os apoios e obxeccións].',
	'deletequeue-discusscreate-summary' => 'Creando a conversa para a eliminación de "[[$1]]".',
	'deletequeue-discusscreate-text' => 'Propoñeuse esta eliminación pola seguinte razón: $2',
	'deletequeue-role-nominator' => 'nominador orixinal da eliminación',
	'deletequeue-role-vote-endorse' => 'partícipe da eliminación',
	'deletequeue-role-vote-object' => 'obxector da eliminación',
	'deletequeue-vote-tab' => 'Votar na eliminación',
	'deletequeue-vote-title' => 'Apoiar a/Obxectar na eliminación de "$1"',
	'deletequeue-vote-text' => "Pode usar este formulario para apoiar ou obxectar na páxina de eliminación de \"'''\$1'''\".
Esta acción ignorará calquera apoio/obxección anterior que teña dado na eliminación desta páxina.
Pode [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ver] os apoios e obxeccións existentes.
O motivo dado na nominación para a eliminación foi ''\$2''.",
	'deletequeue-vote-legend' => 'Apoiar a/Obxectar na eliminación',
	'deletequeue-vote-action' => 'Recomentación:',
	'deletequeue-vote-endorse' => 'Apoiar a eliminación.',
	'deletequeue-vote-object' => 'Obxectar na eliminación.',
	'deletequeue-vote-reason' => 'Comentarios:',
	'deletequeue-vote-submit' => 'Enviar',
	'deletequeue-vote-success-endorse' => 'Apoiou con éxito a eliminación desta páxina.',
	'deletequeue-vote-success-object' => 'Obxectou con éxito a eliminación desta páxina.',
	'deletequeue-vote-requeued' => 'Obxectou con éxito na eliminación desta páxina.
Debido á súa obxección, a páxina foi movida á cola "$1".',
	'deletequeue-showvotes' => 'Apoios e obxeccións da eliminación de "$1"',
	'deletequeue-showvotes-text' => "Embaixo están os apoios e obxección feitos na páxina de eliminación de \"'''\$1'''\".
Pode rexistrar o seu propio apoio ou obxección na páxina da eliminación: [{{fullurl:{{FULLPAGENAME}}|action=delvote}} aquí].",
	'deletequeue-showvotes-restrict-endorse' => 'Amosar só os apoios',
	'deletequeue-showvotes-restrict-object' => 'Amosar só as obxeccións',
	'deletequeue-showvotes-restrict-none' => 'Amosar todos os apoios e obxeccións',
	'deletequeue-showvotes-vote-endorse' => "'''Apoiou''' a eliminación o $2 ás $1",
	'deletequeue-showvotes-vote-object' => "'''Obxectou''' na eliminación o $2 ás $1",
	'deletequeue-showvotes-showingonly-endorse' => 'Amosando só os apoios',
	'deletequeue-showvotes-showingonly-object' => 'Amosando só as obxeccións',
	'deletequeue-showvotes-none' => 'Non hai apoios ou obxeccións na eliminación desta páxina.',
	'deletequeue-showvotes-none-endorse' => 'Non hai apoios na eliminación desta páxina.',
	'deletequeue-showvotes-none-object' => 'Non hai obxeccións na eliminación desta páxina.',
	'deletequeue' => 'Cola de borrados',
	'deletequeue-list-text' => 'Esta páxina amosa todas as páxinas que están no sistema de eliminación.',
	'deletequeue-list-search-legend' => 'Procurar páxinas',
	'deletequeue-list-queue' => 'Cola:',
	'deletequeue-list-status' => 'Estado:',
	'deletequeue-list-expired' => 'Amosar só as nominacións que requiren ser pechadas.',
	'deletequeue-list-search' => 'Procurar',
	'deletequeue-list-anyqueue' => '(calquera)',
	'deletequeue-list-votes' => 'Lista de votos',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|apoio|apoios}}, $2 {{PLURAL:$2|obxección|obxeccións}}',
	'deletequeue-list-header-page' => 'Páxina',
	'deletequeue-list-header-queue' => 'Cola',
	'deletequeue-list-header-votes' => 'Apoios e obxeccións',
	'deletequeue-list-header-expiry' => 'Caducidade',
	'deletequeue-list-header-discusspage' => 'Páxina de conversa',
	'deletequeue-case-intro' => 'Esta páxina lista información sobre un caso específico de borrado.',
	'deletequeue-list-header-reason' => 'Motivo do borrado',
	'deletequeue-case-votes' => 'Apoios/obxeccións:',
	'deletequeue-case-title' => 'Detalles do caso de borrado',
	'deletequeue-case-details' => 'Detalles básicos',
	'deletequeue-case-page' => 'Páxina:',
	'deletequeue-case-reason' => 'Motivo:',
	'deletequeue-case-expiry' => 'Caducidade:',
	'deletequeue-case-needs-review' => 'Este caso precisa dunha [[$1|revisión]].',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'deletequeue-action-queued' => 'Διαγραφή',
	'deletequeue-action' => 'Πρότασις διαγραφῆς',
	'deletequeue-action-title' => 'Πρότασις διαγραφῆς τοῦ "$1"',
	'deletequeue-delnom-otherreason' => 'Ἑτέρα αἰτία',
	'deletequeue-review-reason' => 'Σχόλια:',
	'deletequeue-vote-reason' => 'Σχόλια:',
	'deletequeue-vote-submit' => 'Ὑποβάλλειν',
	'deletequeue-list-queue' => 'Οὐρά:',
	'deletequeue-list-status' => 'Καθεστώς:',
	'deletequeue-list-search' => 'Ζητεῖν',
	'deletequeue-list-anyqueue' => '(οἱαδήποτε)',
	'deletequeue-list-header-page' => 'Δέλτος',
	'deletequeue-list-header-queue' => 'Οὐρά',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'deletequeue-desc' => 'Legt e [[Special:DeleteQueue|Syschtem fir d Verwaltig vu Leschige aa uf dr Grundlag vun ere Warteschlang]]',
	'deletequeue-action-queued' => 'Leschig',
	'deletequeue-action' => 'Leschig vorschlaa',
	'deletequeue-action-title' => 'Vorschlaaa, ass „$1“ glescht wird',
	'deletequeue-action-text' => "Uf {{SITENAME}} git s mehreri unterschidligi Arte, wie bi dr LEschig vu Syte vorgange wird:
*Wänn Du glaubsch, ass die Syte d ''Schnällleschkriterie'' erfillt, no chasch si [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} doo ] vorschlaa.
*Wänn die Syte nit fir d Schnällleschig geignet isch, d Leschig aber ''wahrschyns nit umstritten'' isch, sottsch si fir e  [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} nit umstritteni Leschig] vorschlaa.
*Wänn d Leschig vu däre Syte ''wahrschyns umstritten'' isch, sottsch [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} e Diskussion aafange].",
	'deletequeue-action-text-queued' => 'Du chasch die Syte fir dr Leschaatrag ufruefe:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Pro un Contra].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Stimm zue däm Leschaatrag abgee].',
	'deletequeue-permissions-noedit' => 'Du muesch e Syte bearbeite chenne go dr Leschstatus vun ere verändere chenne.',
	'deletequeue-generic-reasons' => '* Grind, wu vyylmol vorchemme
   ** Vandalismus
   ** Wärbig
   ** Wartig
   ** Nit mit em Projäktziil vereinbar',
	'deletequeue-nom-alreadyqueued' => 'Die Syte isch scho in dr Lesch-Warteschlang.',
	'deletequeue-speedy-title' => '„$1“ fir e Schnällleschig vorschlaa',
	'deletequeue-speedy-text' => "Uf däre Syte chasch „'''$1'''“ fir e Schnällleschig vorschlaa.

E Ammann wird dr Aatrag bschaue un d Syte lesche, wänn er guet begrindet isch.
Du muesch e Leschgrund us em Dropdown-Menü do unten uuswehlen un alli wytere relevante Informatione dezuegee.",
	'deletequeue-prod-title' => '„$1“ zum Lesche vorschlaa',
	'deletequeue-prod-text' => "Uf däre Syte chasch „'''$1'''“ zum Lesche vorschlaa.

Wänn no fimf Täg nieme Yyspruch gege d Leschig yygleit het, wird d Syte glescht noch ere letschte Priefig dur e Ammann.",
	'deletequeue-delnom-reason' => 'Grund fir dr Leschaatrag:',
	'deletequeue-delnom-otherreason' => 'Andere Grund',
	'deletequeue-delnom-extra' => 'Wyteri Informatione:',
	'deletequeue-delnom-submit' => 'Leschig yytrage',
	'deletequeue-log-nominate' => 'het [[$1]] fir d Leschig in dr Lesch-Warteschlang „$2“ vorgschlaa.',
	'deletequeue-log-rmspeedy' => 'het dr Schnällleschaatrag fir [[$1]] abglähnt.',
	'deletequeue-log-requeue' => 'het [[$1]] in e andere Lesch-Warteschlang verschobe: vu „$2“ in „$3“.',
	'deletequeue-log-dequeue' => 'het [[$1]] us dr Lesch-Warteschlang „$2“ usegnuu.',
	'right-speedy-nominate' => 'Syte fir e Schnällleschig vorschlaa',
	'right-speedy-review' => 'Schnällleschaaträg priefe',
	'right-prod-nominate' => 'Syte zum Lesche vorschlaa',
	'right-prod-review' => 'Nit umstritteni Leschaaträg priefe',
	'right-deletediscuss-nominate' => 'Leschdiskussionen aafange',
	'right-deletediscuss-review' => 'Leschdiskussione zuemache',
	'right-deletequeue-vote' => 'Fir oder gege d Leschig stimme',
	'deletequeue-queue-speedy' => 'Schnällleschig',
	'deletequeue-queue-prod' => 'Leschaatrag',
	'deletequeue-queue-deletediscuss' => 'Leschdiskussion',
	'deletequeue-page-speedy' => "Die Syte isch fir e Schnällleschig vorgschlaa wore.
Dr Grund, wu aagee woren isch derfir, isch ''$1''.",
	'deletequeue-page-prod' => "Die Syten isch zum Lesche vorgschlaa wore.
Dr Grund, wu aagee woren isch derfir, isch ''$1''.
Wänn dodergege bis zum ''$2'' kei Yyspruch yygleit wird, no wird die Syte glescht.
Du chasch gege dää Leschaatrag [{{fullurl:{{FULLPAGENAME}}|action=delvote}} en Yyspruch yylege].",
	'deletequeue-page-deletediscuss' => "Die Syte isch zum Lesche vorgschlaa wore un dodergege isch Yyspruch yygleit wore.
Dr Grund, wu aagee woren isch, isch ''$1''.
D [[$5|Leschdiskussion]] lauft no bis am ''$2''.",
	'deletequeue-notqueued' => 'D Syte, wu Du uusgwehlt hesch, isch zur Zyt in keinere Lesch-Warteschlang',
	'deletequeue-review-action' => 'Aktion, wu uusgfiert soll wäre:',
	'deletequeue-review-delete' => 'Syte lesche.',
	'deletequeue-review-change' => 'Syte lesche, aber mit eme andere Grund.',
	'deletequeue-review-requeue' => 'Syte in die Lesch-Warteschlang verschiebe:',
	'deletequeue-review-dequeue' => 'Kei Aktion uusfieren un d Syte us dr Lesch-Warteschlang useneh',
	'deletequeue-review-reason' => 'Kommentar:',
	'deletequeue-review-newreason' => 'Neje Grund:',
	'deletequeue-review-newextra' => 'Wyteri Informatione:',
	'deletequeue-review-submit' => 'Iberpriefig spychere',
	'deletequeue-review-original' => 'Grund fir dr Aatrag',
	'deletequeue-actiondisabled-involved' => 'Die Aktion isch deaktiviert, wel Du in däm Leschfall scho as $1 teilgnuu hesch:',
	'deletequeue-actiondisabled-notexpired' => 'Die Aktion isch deaktiviert, wel dr Leschaatrag nonig uusglofen isch:',
	'deletequeue-review-badaction' => 'Du hesch e nit giltigi Aktion aagee',
	'deletequeue-review-actiondenied' => 'Du hesch en Aktion aagee, wu fir die Syte deaktiviert isch',
	'deletequeue-review-objections' => "'''Warnig''': Gege d Leschig vu däre Syte isch [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} Yyspruch yygleit] wore.
Bitte prief d Yyspruchs-Argumänt, voreb Du die syte leschesch.",
	'deletequeue-reviewspeedy-tab' => 'Schnällleschig priefe',
	'deletequeue-reviewspeedy-title' => 'Schnällleschaatrag fir „$1“ priefe',
	'deletequeue-reviewspeedy-text' => "Uf däre Syte chasch dr Schnällleschaatrag fir „'''$1'''“ iberpriefe.
Bitte stell sicher, ass die Syte schnällglescht cha wäre in Ibereinstimmig mit dr Richtlinie.",
	'deletequeue-reviewprod-tab' => 'Leschaatrag priefe',
	'deletequeue-reviewprod-title' => 'Leschaatrag fir „$1“ priefe',
	'deletequeue-reviewprod-text' => "Uf däre Syte chasch dr nit umstritte Leschaatrag fir „'''$1'''“ priefe.",
	'deletequeue-reviewdeletediscuss-tab' => 'Leschig priefe',
	'deletequeue-reviewdeletediscuss-title' => 'Leschdiskussion fir „$1“ priefe',
	'deletequeue-reviewdeletediscuss-text' => "Uf däre Syte chasch d Leschdiskussion vu „'''$1'''“ priefe.

S git e [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Lischt] mit Stimme fir un gege d Leschig; di eigetlig Diskussion findsch unter [[$2]].
Bitte gib Achtig, ass Dyy Entscheidig mit em Konsens vu dr Diskussion vereinbar isch.",
	'deletequeue-review-success' => 'Du hesch erfolgryych d Leschig vu däre Syte prieft',
	'deletequeue-review-success-title' => 'Priefig abgschlosse',
	'deletequeue-deletediscuss-discussionpage' => 'Des isch d Diskussionssyte fir d Leschig vu [[$1]].
Zur Zyt {{PLURAL:$2|unterstitzt ei|unterstitze $2}} Benutzer d Leschig, derwylscht $3 Benutzer gege si sin.
Du chasch [{{fullurl:$1|action=delvote}} fir oder gege d Leschig stimme] oder [{{fullurl:$1|action=delviewvotes}} alli Stimme go aaluege].',
	'deletequeue-discusscreate-summary' => 'Leschdiskussion fir [[$1]] wird aagleit.',
	'deletequeue-discusscreate-text' => 'D Leschig isch us däm Grund vorgschlaa wore: $2',
	'deletequeue-role-nominator' => 'urspringlige Leschaatragsteller',
	'deletequeue-role-vote-endorse' => 'Lyt, wu fir d Leschig gstimmt hän',
	'deletequeue-role-vote-object' => 'Lyt, wu gege d Leschig gstimmt hän',
	'deletequeue-vote-tab' => 'Iber d Leschung abstimme',
	'deletequeue-vote-title' => 'Fir oder gege d Leschig vu „$1“ stimme',
	'deletequeue-vote-text' => "Uf däre Syte chasch fir oder gege d LEschig vu „'''$1'''“ stimme.
Die Aktion iberschrybt alli Stimme, wu Du devor abgee hesch zue dr Leschig vu däre Syte.
Du chasch d Stimme, wu scho abgee wore sin, [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} go aaluege].
Dr Grund fir dr Leschaatrag isch ''$2'' gsi.",
	'deletequeue-vote-legend' => 'Fir oder gege d Leschig stimme',
	'deletequeue-vote-action' => 'Empfählig:',
	'deletequeue-vote-endorse' => 'Fir d Leschig stimme.',
	'deletequeue-vote-object' => 'Gege d Leschig stimme.',
	'deletequeue-vote-reason' => 'Kommentar:',
	'deletequeue-vote-submit' => 'Abschicke',
	'deletequeue-vote-success-endorse' => 'Die hesch erfolgryych fir d Leschig vu däre Syte gstimmt.',
	'deletequeue-vote-success-object' => 'Die hesch erfolgryych gege d Leschig vu däre Syte gstimmt.',
	'deletequeue-vote-requeued' => 'Du hesch erfolgryych gege d Leschig vu däre Syte gstimmt.
Dur Dyy Yyspruch isch d Syte in d Lesch-Warteschlang $1 verschobe wore.',
	'deletequeue-showvotes' => 'Fir- un Gege-Stimme zue dr Leschig vu „$1“',
	'deletequeue-showvotes-text' => "Unte si d Fir- un d Gege-Stimme zue dr Leschig vu „'''$1'''“.
Du chasch Dyy eige Stimm zue dr Leschig [{{fullurl:{{FULLPAGENAME}}|action=delvote}} doo] yytrage.",
	'deletequeue-showvotes-restrict-endorse' => 'Nume Fir-Stimme aazeige',
	'deletequeue-showvotes-restrict-object' => 'Nume Gege-Stimme aazeige',
	'deletequeue-showvotes-restrict-none' => 'Alli Fir- un Gege-Stimme aazeige',
	'deletequeue-showvotes-vote-endorse' => "'''Fir''' d Leschig gstimmt am $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Gege''' d Leschig gstimmt am $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Nume Fir-Stimme wäre aazeigt',
	'deletequeue-showvotes-showingonly-object' => 'Nume Gege-Stimme wäre aazeigt',
	'deletequeue-showvotes-none' => 'S git kei Fir- oder Gege-Stimme zue dr Leschig vu däre Syte.',
	'deletequeue-showvotes-none-endorse' => 'S git kei Fir-Stimme zue dr Leschig vu däre Syte.',
	'deletequeue-showvotes-none-object' => 'S git kei Gege-Stimme zue dr Leschig vu däre Syte.',
	'deletequeue' => 'Lesch-Warteschlang',
	'deletequeue-list-text' => 'Die Syte zeigt alli Syten aa, wu im Leschsyschtem din sin.',
	'deletequeue-list-search-legend' => 'No Syte sueche',
	'deletequeue-list-queue' => 'Warteschlang:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Zeig nume Leschaaträg, wu solle zuegmacht wäre.',
	'deletequeue-list-search' => 'Sueche',
	'deletequeue-list-anyqueue' => '(irgedeini)',
	'deletequeue-list-votes' => 'Stimmelischt',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|Fir-Stimme|Fir-Stimme}}, $2 {{PLURAL:$2|Gege-Stimme|Gege-Stimme}}',
	'deletequeue-list-header-page' => 'Syte',
	'deletequeue-list-header-queue' => 'Warteschlang',
	'deletequeue-list-header-votes' => 'Fir- un Gege-Stimme',
	'deletequeue-list-header-expiry' => 'Ablaufdatum',
	'deletequeue-list-header-discusspage' => 'Diskussionssyte',
	'deletequeue-case-intro' => 'Die Syte lischtet Informatione uf iber e bstimmte Leschfall.',
	'deletequeue-list-header-reason' => 'Leschgrund',
	'deletequeue-case-votes' => 'Fir-/Gege-Stimme:',
	'deletequeue-case-title' => 'Leschfalldetail',
	'deletequeue-case-details' => 'Grunddetail',
	'deletequeue-case-page' => 'Syte:',
	'deletequeue-case-reason' => 'Grund:',
	'deletequeue-case-expiry' => 'Ablaufdatum:',
	'deletequeue-case-needs-review' => 'Dää Fall bruucht e [[$1|Priefig]].',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 */
$messages['haw'] = array(
	'deletequeue-list-search' => 'Huli',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'deletequeue-desc' => 'יצירת [[Special:DeleteQueue|מערכת מבוססת תורים לניהול המחיקות]]',
	'deletequeue-action-queued' => 'מחיקה',
	'deletequeue-action' => 'הצעת מחיקה',
	'deletequeue-action-title' => 'הצעת מחיקה של "$1"',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'deletequeue-list-header-page' => 'Stranica',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'deletequeue-desc' => 'Wutworja [[Special:DeleteQueue|system za zarjadowanje wušmórnjenjow na zakładźe čakanskeho rynka]]',
	'deletequeue-action-queued' => 'Wušmórnjenje',
	'deletequeue-action' => 'Wušmórnjenje namjetować',
	'deletequeue-action-title' => '"$1" za wušmórnjenje namjetować',
	'deletequeue-action-text' => "Tutón wiki ma rjad procesow za wušmórnjenje stronow:
*Jeli wěriš, zo tuta strona to woprawnja, móžeš [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} ju za ''spěšne wušmórnjenje'' namjetować].
*Jeli tuta strona spěšne wušmórnjenje njewoprawnja, ale ''wušmórnjenje najskerje budźe njewotprějomne'', ty měł [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} připóznate wušmórnjenje namjetować].
*Jeli wušmórnjenje tuteje strony so ''najskerje wotprěwa'', ty měł [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} diskusiju wotewrěć].",
	'deletequeue-action-text-queued' => 'Móžeš sej slědowacej stronje za tutón pad wušmórnjenja wobhladać:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Aktualne schwalenja a znapřećiwjenja].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Wušmórnjenje tuteje strony schwalić abo wotpokazać].',
	'deletequeue-permissions-noedit' => 'Dyrbiš móc stronu wobdźěłać, zo by móhł jeje status wušmórnjenja wobwliwować.',
	'deletequeue-generic-reasons' => '* Powšitkowne přičiny
  ** Wandalizm
  ** Spam
  ** Wothladowanje
  ** Zwonka projektoweho wobłuka',
	'deletequeue-nom-alreadyqueued' => 'Tuta strona je hižo w čakanskim rynku.',
	'deletequeue-speedy-title' => '"$1" za spěšne wušmórnjenje markěrować',
	'deletequeue-speedy-text' => "Móžeš tutón formular wužiwać, zo by stronu \"'''\$1'''\" za spěšne wušmórnjenje woznamjenił.

Administrator budźe požadanje pruwować a, jeli je woprawnjene, stronu wušmórnyć.
Dyrbiš přičinu za wušmórnjenju ze slědowaceje dele padaceje lisćiny wubrać a druhe relewantne informacije přidać.",
	'deletequeue-prod-title' => '"$1" za wušmórnjenje namjetować',
	'deletequeue-prod-text' => "Móžeš tutón formular wužiwać, zo by wušmórnjenje strony \"'''\$1'''\" namjetował.

Jeli po pjeć dnjach nichtó njeje wušmórnjenje wotpokazał, wušmórnje so po kónčnym přepruwowanju wot administratora.",
	'deletequeue-delnom-reason' => 'Přičina za pomjenowanje:',
	'deletequeue-delnom-otherreason' => 'Druha přičina',
	'deletequeue-delnom-extra' => 'Přidatne informacije',
	'deletequeue-delnom-submit' => 'Pomjenowanje wotpósłać',
	'deletequeue-log-nominate' => "je [[$1]] za wušmórnjenje w čakanskim rynku '$2' namjetował.",
	'deletequeue-log-rmspeedy' => 'je wotpokazał [[$1]] spěšnje wušmórnyć.',
	'deletequeue-log-requeue' => "je [[$1]] k druhemu čakanskemu rynkej přenjesł: wot '$2' do '$3'.",
	'deletequeue-log-dequeue' => "je [[$1]] z čakanskeho rynka '$2' wotstronił.",
	'right-speedy-nominate' => 'Strony za spěšne wušmórnjenje pomjenować',
	'right-speedy-review' => 'Pomjenowanja za spěšne wušmórnjenje přepruwować',
	'right-prod-nominate' => 'Wušmórnjenje strony namjetować',
	'right-prod-review' => 'Připóznate namjety za wušmórnjenje přepruwować',
	'right-deletediscuss-nominate' => 'Diskusije wo wušmórnjenje započeć',
	'right-deletediscuss-review' => 'Diskusije wo wušmórnjenju skónčić',
	'right-deletequeue-vote' => 'Wušmórnjenja schwalić abo wotpokazać',
	'deletequeue-queue-speedy' => 'Spěšne wušmórnjenje',
	'deletequeue-queue-prod' => 'Namjetowane wušmórnjenje',
	'deletequeue-queue-deletediscuss' => 'Diskusija wo wušmórnjenju',
	'deletequeue-page-speedy' => "Tuta strona bu za spěšnje wušmórnjenje namjetowana.
Podata přičina za to je ''$1''.",
	'deletequeue-page-prod' => "Tuta strona bu za wušmórnjenje namjetowana.
Podata přičina je ''$1''.
Jeli tutón namjet je hač do ''$2'' připóznaty, wušmórnje so tuta strona.
Móžeš wušmórnjenje tuteje strony přez [{{fullurl:{{FULLPAGENAME}}|action=delvote}} wotpokazanje wušmórnjenja] wotprěć.",
	'deletequeue-page-deletediscuss' => "Tuta strona bu za wušmórnjenje namjetowana, ale tón namjet bu wotprěty.
Podata přičina je ''$1''.
Diskusija běži na [[$5]], kotraž budźe so ''$2'' kónčić.",
	'deletequeue-notqueued' => 'Strona, kotraž sy wubrana, tuchwilu w žanym čakanskim rynku njeje.',
	'deletequeue-review-action' => 'Akcija, kotraž ma so wuwjesć:',
	'deletequeue-review-delete' => 'Stronu wušmórnyć.',
	'deletequeue-review-change' => 'Tutu stronu wušmórnyć, ale z druhim wopodstatnjenjom.',
	'deletequeue-review-requeue' => 'Tutu stronu do slědowaceho čakanskeho rynka přenjesć:',
	'deletequeue-review-dequeue' => 'Žanu akciju njewuwjesć  a stronu z čakanskeho rynka wušmórnjenja wotstronić.',
	'deletequeue-review-reason' => 'Komentary:',
	'deletequeue-review-newreason' => 'Nowa přičina:',
	'deletequeue-review-newextra' => 'Přidatne informacije:',
	'deletequeue-review-submit' => 'Přepruwowanje składować',
	'deletequeue-review-original' => 'Přičina za pomjenowanje',
	'deletequeue-actiondisabled-involved' => 'Slědowaca akcija je znjemóžnena, dokelž sy so w tutym padźe wušmórnjenja jako $1 wobdźělił:',
	'deletequeue-actiondisabled-notexpired' => 'Slědowaca akcija je znjemóžnjena, dokelž požadanje wo wušmórnjenje hišće njeje spadnjene:',
	'deletequeue-review-badaction' => 'Sy njepłaćiwu akciju podał',
	'deletequeue-review-actiondenied' => 'Sy akciju podał, kotraž bu za tutu stronu znjemóžnjena',
	'deletequeue-review-objections' => "'''Warnowanje''': Wušmórnjenje tuteje strony ma [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} znapřećiwjenja].
Prošu zawěsć sej, zo sy tute znapřećiwjenja wobkedźbował, prjedy hač wušmórnješ tutu stronu.",
	'deletequeue-reviewspeedy-tab' => 'Spěšne wušmórnjenje přepruwować',
	'deletequeue-reviewspeedy-title' => 'Požadanje wo spěšne wušmórnjenje "$1" přepruwować',
	'deletequeue-reviewspeedy-text' => "Móžeš tutón formular wužiwać, zo by požadanje za stronu \"'''\$1'''\" wo spěšne wušmórnjenje přepruwował.
Prošu zawěsć sej, zo tuta strona da so wotpowědujo zasadam spěšnje wušmórnyć.",
	'deletequeue-reviewprod-tab' => 'Namjetowane wušmórnjenje přepruwować',
	'deletequeue-reviewprod-title' => 'Namjetowane wušmórnjenje za "$2" přepruwować',
	'deletequeue-reviewprod-text' => "Móžeš tutón formular wužiwać, zo by připóznaty namjet za wušmórnjenje \"'''\$1'''\" přepruwował.",
	'deletequeue-reviewdeletediscuss-tab' => 'Wušmórnjenje přepruwować',
	'deletequeue-reviewdeletediscuss-title' => 'Diskusiju wo wušmórnjenju za "$1" přepruwować',
	'deletequeue-reviewdeletediscuss-text' => "Móžeš tutón formular wužiwać, zo by diskusiju wušmórnjenja strony \"'''\$1'''\" přepruwował.

[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Lisćina] schwalenjow a znapřećiwjenjow tutoho wušmórnjenja k dispoziciji steji a diskusija sama hodźi so na [[\$2]] namakać.
Prošu zawěsć, zo sy po konsensu wo diskusiji rozsudźił.",
	'deletequeue-review-success' => 'Sy wušmórnjenje tuteje stronje wuspěšnje přepruwował.',
	'deletequeue-review-success-title' => 'Přepruwowanje dokónčene',
	'deletequeue-deletediscuss-discussionpage' => 'To je diskusijna strona za wušmórnjenje strony [[$1]].
Tuchwilu {{PLURAL:$2|je $2 wužiwar, kotryž|staj $2 wužiwarjej, kotrajž|su $2 wužiwarjo, kotřiž|je $2 wužiwarjow, kotrež}} wušmórnjenje {{PLURAL:$2|schwala|schaletaj|schwaleja|schwala}} a $3 {{PLURAL:$3|wužiwar, kotryž|wužiwarjej, kotrajž|wužiwarjo, kotřiž|wužiwarjow, kotrež}} wušmórnjenje {{PLURAL:$2|wotpokazuje|wotpokazujetaj|wotpokazuja|wotpokazuje}}.
Móžeš [{{fullurl:$1|action=delvote}} wušmórnjenje schwalić abo wotpokazać] abo [{{fullurl:$1|action=delviewvotes}} sej wšě schwalenja a znapřećiwjenja wobhladać].',
	'deletequeue-discusscreate-summary' => 'Diskusija za wušmórnjenje [[$1]] so wutworja.',
	'deletequeue-discusscreate-text' => 'Wušmórnjenje bu ze slědowaceje přičiny namjetowane: $2',
	'deletequeue-role-nominator' => 'prěnjotny požadar za wušmórnjenje',
	'deletequeue-role-vote-endorse' => 'Podpěrar wušmórnjenja',
	'deletequeue-role-vote-object' => 'Přećiwnik wušmórnjenja',
	'deletequeue-vote-tab' => 'Wo wušmórnjenju wothłosować',
	'deletequeue-vote-title' => 'Wušmórnjenje "$1" schwalić abo wotpokazać',
	'deletequeue-vote-text' => "Móžeš tutón formular wužiwać, zo by wušmórnjenje strony \"'''\$1'''\" schwalił abo wotpokazał.
Tuta akcija přepisa prjedawše schwalenja/znapřećiwjenja, kotrež sy k wušmórnjenju tuteje strony přednjesł.
Móžeš eksistowace schwalenja a znapřećiwjenja [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} sej wobhladać].
Podata přičina za požadanje wo wušmórnjenje bě ''\$2''.",
	'deletequeue-vote-legend' => 'Wušmórnjenje podpěrać/wotpokazać',
	'deletequeue-vote-action' => 'Poručenje:',
	'deletequeue-vote-endorse' => 'Wušmórnjenje schwalić.',
	'deletequeue-vote-object' => 'Wušmórnjenje wotpokazać.',
	'deletequeue-vote-reason' => 'Komentary:',
	'deletequeue-vote-submit' => 'Wotpósłać',
	'deletequeue-vote-success-endorse' => 'Sy wušmórnjenje tuteje strony wuspěšnje schwalił.',
	'deletequeue-vote-success-object' => 'Sy wušmórnjenje tuteje strony wuspěšnje wotpokazał.',
	'deletequeue-vote-requeued' => 'Sy wušmórnjenje tuteje strony wuspěšnje wotpokazał.
Přez twoje znapřećiwjenje strona je so do čakanskeho rynka $1 přesunyła.',
	'deletequeue-showvotes' => 'Schwalenja a wotpokazanja k wušmórnjenju  "$1"',
	'deletequeue-showvotes-text' => "Deleka su schwalenja a znapřećiwjenja k wušmórnjenju strony \"'''\$1'''\".
Móžeš [{{fullurl:{{FULLPAGENAME}}|action=delvote}} swoje schwalenje abo znapřećiwjenje k tutomu wušmórnjenju zapisać].",
	'deletequeue-showvotes-restrict-endorse' => 'Jenož schwalenja pokazać',
	'deletequeue-showvotes-restrict-object' => 'Jenož wotpokazanja pokazać',
	'deletequeue-showvotes-restrict-none' => 'Wšě schwalenja a wotpokazanja pokazać',
	'deletequeue-showvotes-vote-endorse' => "'''Podpěra''' wušmórnjenje $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Wotpokaza''' wušmórnjenje $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Jenož schwalenja so pokazuja',
	'deletequeue-showvotes-showingonly-object' => 'Jenož wotpokazanja so pokazuja',
	'deletequeue-showvotes-none' => 'Schwalenja abo wotpokazanja k wušmórnjenju tuteje strony njejsu.',
	'deletequeue-showvotes-none-endorse' => 'Schwalenja k wušmórnjenju tuteje strony njejsu.',
	'deletequeue-showvotes-none-object' => 'Njejsu žane znapřećiwjenja přećiwo wušmórnjenju tuteje strony.',
	'deletequeue' => 'Čakanski rynk wušmórnjenja',
	'deletequeue-list-text' => 'Tuta strona zwobraznja wšě strony, kotrež su w systemje wušmórnjenja.',
	'deletequeue-list-search-legend' => 'Strony pytać',
	'deletequeue-list-queue' => 'Čakanski rynk:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Jenož požadanja wušmórnjenja pokazać, kotrež maja so začinić.',
	'deletequeue-list-search' => 'Pytać',
	'deletequeue-list-anyqueue' => '(někajki)',
	'deletequeue-list-votes' => 'Lisćina hłosow',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|schwalenje|schwaleni|schwalenja|schwalenjow}}, $2 {{PLURAL:$2|wotpokazanje|wozpokazani|wotpokazanja|wotzpokazanjow}}',
	'deletequeue-list-header-page' => 'Strona',
	'deletequeue-list-header-queue' => 'Čakanski rynk',
	'deletequeue-list-header-votes' => 'Schwalenja a wotpokazanja',
	'deletequeue-list-header-expiry' => 'Spadnjenje',
	'deletequeue-list-header-discusspage' => 'Diskusijna strona',
	'deletequeue-case-intro' => 'Tuta strona informacije wo wěstym padźe wušmórnjenja nalistuje.',
	'deletequeue-list-header-reason' => 'Přičina za wušmórnjenje',
	'deletequeue-case-votes' => 'Schwalenja/Wotpokazanja:',
	'deletequeue-case-title' => 'Podrobnosće wo padźe wušmórnjenja',
	'deletequeue-case-details' => 'Zakładne podrobnosće',
	'deletequeue-case-page' => 'Strona:',
	'deletequeue-case-reason' => 'Přičina:',
	'deletequeue-case-expiry' => 'Spadnjenje:',
	'deletequeue-case-needs-review' => 'Tutón pad sej [[$1|přepruwowanje]] wužaduje.',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'deletequeue-review-reason' => 'Megjegyzések:',
	'deletequeue-vote-reason' => 'Megjegyzések:',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'deletequeue-desc' => 'Crea un [[Special:DeleteQueue|systema con caudas pro gerer deletiones]]',
	'deletequeue-action-queued' => 'Deletion',
	'deletequeue-action' => 'Suggerer deletion',
	'deletequeue-action-title' => 'Suggerer deletion de "$1"',
	'deletequeue-action-text' => "{{SITENAME}} ha plure processos pro deler paginas:
*Si tu crede que iste pagina merita un ''deletion rapide'', tu pote suggerer lo [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} hic].
*Si iste pagina non merita un deletion rapide, sed le ''deletion probabilemente non esserea controversial'', tu deberea [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} proponer un deletion non contestabile].
*Si le deletion de iste pagina ''probabilemente esserea contestate'', tu deberea [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} initiar un discussion].",
	'deletequeue-action-text-queued' => 'Tu pote vider le sequente paginas pro iste caso de deletion:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Vider le actual declarationes pro e contra].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Declarar te pro o contra le deletion de iste pagina].',
	'deletequeue-permissions-noedit' => 'Tu debe poter modificar un pagina pro poter afficer su stato de deletion.',
	'deletequeue-generic-reasons' => '* Motivos generic
  ** Vandalismo
  ** Spam
  ** Mantenentia
  ** Foras del criterios del projecto',
	'deletequeue-nom-alreadyqueued' => 'Iste pagina es ja in un cauda de deletiones.',
	'deletequeue-speedy-title' => 'Marcar "$1" pro deletion rapide',
	'deletequeue-speedy-text' => "Tu pote usar iste formulario pro marcar le pagina \"'''\$1'''\" pro deletion rapide.

Un administrator revidera iste requesta, e, si illo es ben fundate, delera le pagina.
Tu debe seliger un motivo pro deletion ab le lista disrolante infra, e adder omne altere information relevante.",
	'deletequeue-prod-title' => 'Proponer deletion de "$1"',
	'deletequeue-prod-text' => "Tu pote usar iste formulario pro proponer que \"'''\$1'''\" sia delite.

Si, post cinque dies, necuno ha contestate le deletion de iste pagina, illo essera delite post un examine final per un administrator.",
	'deletequeue-delnom-reason' => 'Motivo pro nomination:',
	'deletequeue-delnom-otherreason' => 'Altere motivo',
	'deletequeue-delnom-extra' => 'Informationes supplementari:',
	'deletequeue-delnom-submit' => 'Submitter nomination',
	'deletequeue-log-nominate' => "nominava [[$1]] pro deletion in le cauda '$2'.",
	'deletequeue-log-rmspeedy' => 'refusava le deletion rapide de [[$1]].',
	'deletequeue-log-requeue' => "transfereva [[$1]] a un altere cauda de deletiones: ab '$2' verso '$3'.",
	'deletequeue-log-dequeue' => "removeva [[$1]] del cauda de deletiones '$2'.",
	'right-speedy-nominate' => 'Nominar paginas pro deletion rapide',
	'right-speedy-review' => 'Revider nominationes pro deletion rapide',
	'right-prod-nominate' => 'Proponer le deletion de paginas',
	'right-prod-review' => 'Revider le propositiones de deletion non contestate',
	'right-deletediscuss-nominate' => 'Comenciar discussiones super deletiones',
	'right-deletediscuss-review' => 'Clauder discussiones super deletiones',
	'right-deletequeue-vote' => 'Declarar te pro o contra deletiones',
	'deletequeue-queue-speedy' => 'Deletion rapide',
	'deletequeue-queue-prod' => 'Deletion proponite',
	'deletequeue-queue-deletediscuss' => 'Discussion super le deletion',
	'deletequeue-page-speedy' => "Iste pagina ha essite nominate pro deletion rapide.
Le motivo date pro iste deletion es ''$1''.",
	'deletequeue-page-prod' => "Il ha essite proponite que iste pagina sia delite.
Le motivo date esseva ''$1''.
Si iste proposition remane non contestate al ''$2'', le pagina essera delite.
Tu pote contestar iste deletion per [{{fullurl:{{FULLPAGENAME}}|action=delvote}} facer un objection contra le deletion].",
	'deletequeue-page-deletediscuss' => "Iste pagina ha essite proponite pro deletion, e iste proposition ha essite contestate.
Le motivo date esseva ''$1''.
Un discussion es in curso a [[$5]], le qual se concludera le ''$2''.",
	'deletequeue-notqueued' => 'Le pagina que tu ha seligite non es in le cauda de deletiones',
	'deletequeue-review-action' => 'Action a prender:',
	'deletequeue-review-delete' => 'Deler le pagina.',
	'deletequeue-review-change' => 'Deler iste pagina, sed con un altere motivo.',
	'deletequeue-review-requeue' => 'Transferer iste pagina verso le cauda sequente:',
	'deletequeue-review-dequeue' => 'Facer nihil, e retirar le pagina del cauda de deletiones.',
	'deletequeue-review-reason' => 'Commentos:',
	'deletequeue-review-newreason' => 'Nove motivo:',
	'deletequeue-review-newextra' => 'Informationes supplementari:',
	'deletequeue-review-submit' => 'Immagazinar revision',
	'deletequeue-review-original' => 'Motivo pro nomination',
	'deletequeue-actiondisabled-involved' => 'Le sequente action es disactivate post que tu ha participate in iste caso de deletion in le rolos $1:',
	'deletequeue-actiondisabled-notexpired' => 'Le sequente action es disactivate proque le nomination del deletion non ha ancora expirate:',
	'deletequeue-review-badaction' => 'Tu specificava un action invalide',
	'deletequeue-review-actiondenied' => 'Tu specificava un action que es diactivate pro iste pagina',
	'deletequeue-review-objections' => "'''Attention''': Le deletion de iste pagina ha
[{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} objectiones].
Per favor assecura te que tu ha considerate iste objectiones ante que tu dele iste pagina.",
	'deletequeue-reviewspeedy-tab' => 'Revider deletion rapide',
	'deletequeue-reviewspeedy-title' => 'Revider le nomination pro deletion rapide de "$1"',
	'deletequeue-reviewspeedy-text' => "Tu pote usar iste formulario pro revider le nomination de \"'''\$1'''\" pro deletion rapide.
Per favor assecura te que iste pagina pote esser delite rapidemente in conformitate con le politicas.",
	'deletequeue-reviewprod-tab' => 'Revider deletion proponite',
	'deletequeue-reviewprod-title' => 'Revider deletion proponite de "$1"',
	'deletequeue-reviewprod-text' => "Tu pote usar iste formulario pro revider le proposition non contestate pro le deletion de \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Revider deletion',
	'deletequeue-reviewdeletediscuss-title' => 'Revider le discussion super le deletion de "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Tu pote usar iste formulario pro revider le discussion super le deletion de \"'''\$1'''\".

Un [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] de declarationes pro e contra iste deletion es disponibile, e le discussion mesme se trova a [[\$2]].
Per favor assecura te que tu face un decision in conformitate con le consenso del discussion.",
	'deletequeue-review-success' => 'Tu ha revidite con successo le deletion de iste pagina',
	'deletequeue-review-success-title' => 'Revision complete',
	'deletequeue-deletediscuss-discussionpage' => 'Isto es le pagina de discussion super le deletion de [[$1]].
Al momento, il ha $2 {{PLURAL:$2|usator|usatores}} qui se ha declarate pro iste deletion, e $3 {{PLURAL:$3|usator|usatores}} contra.
Tu pote [{{fullurl:$1|action=delvote}} declarar te pro o contra] le deletion, o [{{fullurl:$1|action=delviewvotes}} vider tote le declarationes pro e contra].',
	'deletequeue-discusscreate-summary' => 'Creation del discussion super le deletion de [[$1]].',
	'deletequeue-discusscreate-text' => 'Deletion proponite pro le sequente motivo: $2',
	'deletequeue-role-nominator' => 'nominator original pro deletion',
	'deletequeue-role-vote-endorse' => 'appoiator del deletion',
	'deletequeue-role-vote-object' => 'opponente del deletion',
	'deletequeue-vote-tab' => 'Pro/contra deletion',
	'deletequeue-vote-title' => 'Declarar se pro o contra le deletion de "$1"',
	'deletequeue-vote-text' => "Tu pote usar iste formulario pro declarar te pro o contra le deletion de \"'''\$1'''\".
Iste action ultrapassara omne previe declarationes pro/contra que tu ha date a proposito del deletion de iste pagina.
Tu pote [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} vider] le existente declarationes pro e contra.
Le motivo indicate in le nomination pro deletion esseva ''\$2''.",
	'deletequeue-vote-legend' => 'Declarar se pro o contra le deletion',
	'deletequeue-vote-action' => 'Recommendation:',
	'deletequeue-vote-endorse' => 'Pro deletion.',
	'deletequeue-vote-object' => 'Contra deletion.',
	'deletequeue-vote-reason' => 'Commentos:',
	'deletequeue-vote-submit' => 'Submitter',
	'deletequeue-vote-success-endorse' => 'Tu te ha declarate con successo pro le deletion de iste pagina.',
	'deletequeue-vote-success-object' => 'Tu te ha declarate con successo contra le deletion de iste pagina.',
	'deletequeue-vote-requeued' => 'Tu te ha declarate con successo contra le deletion de iste pagina.
A causa de tu objection, le pagina ha essite displaciate verso le cauda $1.',
	'deletequeue-showvotes' => 'Declarationes pro e contra le deletion de "$1"',
	'deletequeue-showvotes-text' => "Infra es le declarationes facite pro e contra le deletion del pagina \"'''\$1'''\".
Tu pote registrar tu proprie declaration pro o contra iste deletion [{{fullurl:{{FULLPAGENAME}}|action=delvote}} hic].",
	'deletequeue-showvotes-restrict-endorse' => 'Monstrar solmente declarationes pro',
	'deletequeue-showvotes-restrict-object' => 'Monstrar solmente declarationes contra',
	'deletequeue-showvotes-restrict-none' => 'Monstrar tote le declarationes',
	'deletequeue-showvotes-vote-endorse' => "'''Pro''' deletion le $2 a $1",
	'deletequeue-showvotes-vote-object' => "'''Contra''' deletion le $2 a $1",
	'deletequeue-showvotes-showingonly-endorse' => 'Se monstra solmente le declarationes pro',
	'deletequeue-showvotes-showingonly-object' => 'Se monstra solmente le declarationes contra',
	'deletequeue-showvotes-none' => 'Il ha nulle declarationes pro o contra le deletion de iste pagina.',
	'deletequeue-showvotes-none-endorse' => 'Il ha nulle declarationes pro le deletion de iste pagina.',
	'deletequeue-showvotes-none-object' => 'Il ha nulle declarationes contra le deletion de iste pagina.',
	'deletequeue' => 'Cauda de deletiones',
	'deletequeue-list-text' => 'Iste pagina monstra tote le paginas que se trova in le systema de deletiones.',
	'deletequeue-list-search-legend' => 'Cercar paginas',
	'deletequeue-list-queue' => 'Cauda:',
	'deletequeue-list-status' => 'Stato:',
	'deletequeue-list-expired' => 'Monstrar solmente nominationes que require clausura.',
	'deletequeue-list-search' => 'Cercar',
	'deletequeue-list-anyqueue' => '(omne)',
	'deletequeue-list-votes' => 'Lista de votos',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|pro|pro}}, $2 {{PLURAL:$2|contra|contra}}',
	'deletequeue-list-header-page' => 'Pagina',
	'deletequeue-list-header-queue' => 'Cauda',
	'deletequeue-list-header-votes' => 'Declarationes pro e contra',
	'deletequeue-list-header-expiry' => 'Expiration',
	'deletequeue-list-header-discusspage' => 'Pagina de discussion',
	'deletequeue-case-intro' => 'Iste pagina lista le informationes super un caso specific de deletion.',
	'deletequeue-list-header-reason' => 'Motivo del deletion',
	'deletequeue-case-votes' => 'Pro/contra:',
	'deletequeue-case-title' => 'Detalios del caso de deletion',
	'deletequeue-case-details' => 'Detalios de base',
	'deletequeue-case-page' => 'Pagina:',
	'deletequeue-case-reason' => 'Motivo:',
	'deletequeue-case-expiry' => 'Expiration:',
	'deletequeue-case-needs-review' => 'Iste caso require [[$1|revision]].',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'deletequeue-list-search' => 'Cari',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'deletequeue-list-header-expiry' => 'Expiro',
	'deletequeue-case-expiry' => 'Expiro:',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'deletequeue-desc' => 'Crea un [[Special:DeleteQueue|sistema per gestire le cancellazioni basato su code]]',
	'deletequeue-action' => 'Proponi cancellazione',
	'deletequeue-action-title' => 'Proponi la cancellazione di "$1"',
	'deletequeue-action-text' => "{{SITENAME}} ha una serie di processi per la cancellazione delle pagine:
*Se si crede che questa pagina debba essere ''cancellata immediatamente'', lo si può suggerire [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} qui].
*Se questa pagina non può essere cancellata immediatamente ma la sua ''cancellazione sarà probabilmente incontroversa'', dovrebbe essere [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} proposta per la cancellazione].
*Se la cancellazione di questa pagina è ''probabilmente discutibile'', si dovrebbe [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} aprire una discussione].",
	'deletequeue-permissions-noedit' => 'Si deve essere in grado di modificare una pagina per modificarne lo stato di cancellazione.',
	'deletequeue-generic-reasons' => '*Motivazioni generiche
** Vandalismo
** Spam
** Manutenzione
** Al di fuori degli scopi del progetto',
	'deletequeue-speedy-title' => 'Segnala "$1" per la cancellazione immediata',
	'deletequeue-speedy-text' => "È possibile utilizzare questo modulo per segnalare la pagina \"'''\$1'''\" per la cancellazione immediata.

Un amministratore controllerà questa richiesta e, se fondata, cancellerà la pagina. È necessario selezionare una motivazione di cancellazione dal menù a tendina e aggiungere qualsiasi altra informazione importante.",
	'deletequeue-prod-title' => 'Proponi cancellazione di "$1"',
	'deletequeue-prod-text' => "È possibile proporre la cancellazione di \"'''\$1'''\".

Se, dopo cinque giorni, non ci sono state opposizioni alla cancellazione della pagina, sarà cancellata dopo la verifica finale da parte di un amministratore.",
	'deletequeue-delnom-reason' => 'Motivazioni per la segnalazione:',
	'deletequeue-delnom-otherreason' => 'Altra motivazione',
	'deletequeue-delnom-extra' => 'Informazioni aggiuntive:',
	'deletequeue-delnom-submit' => 'Invia segnalazione',
	'deletequeue-log-nominate' => "ha segnalato [[$1]] per la cancellazione nella coda '$2'.",
	'deletequeue-log-rmspeedy' => 'ha respinto la cancellazione immediata di [[$1]].',
	'deletequeue-log-requeue' => "ha spostato [[$1]] in una differente coda di cancellazione: da '$2' a '$3'.",
	'deletequeue-log-dequeue' => "ha rimosso [[$1]] dalla coda '$2' delle cancellazioni.",
	'right-speedy-nominate' => 'Segnala pagine per la cancellazione immediata',
	'right-speedy-review' => 'Controlla le segnalazioni di cancellazioni immediate',
	'right-prod-nominate' => 'Propone una pagina per la cancellazione',
	'right-prod-review' => 'Controlla le proposte di cancellazione non contestate',
	'right-deletediscuss-nominate' => 'Inizia le discussioni sulla cancellazione',
	'right-deletediscuss-review' => 'Chiude le discussioni sulla cancellazione',
	'deletequeue-queue-speedy' => 'Cancellazione immediata',
	'deletequeue-queue-prod' => 'Cancellazione proposta',
	'deletequeue-queue-deletediscuss' => 'Discussione sulla cancellazione',
	'deletequeue-page-speedy' => "Questa pagina è stata segnalata per la cancellazione immediata. La motivazione fornita per questa cancellazione è ''$1''.",
	'deletequeue-page-prod' => "Questa pagina è stata proposta per la cancellazione. La motivazione fornita è ''$1''. Se questa proposta non avrà opposizioni il ''$2'', questa pagina sarà cancellata. È possibile contestare questa cancellazione [{{fullurl:{{FULLPAGENAME}}|action=delvote}} opponendosi a essa].",
	'deletequeue-page-deletediscuss' => "Questa pagina è stata proposta per la cancellazione e la proposta è stata contestata. La motivazione fornita è ''$1''. La discussione si sta tenendo in [[$5]] e si concluderà il ''$2''.",
	'deletequeue-notqueued' => 'La pagina che è stata selezionata non è al momento in coda per la cancellazione',
	'deletequeue-review-action' => 'Azione da effettuare:',
	'deletequeue-review-delete' => 'Cancella la pagina.',
	'deletequeue-review-change' => 'Cancella questa pagina, ma con una motivazione diversa.',
	'deletequeue-review-requeue' => 'Sposta questa pagina nella coda seguente:',
	'deletequeue-review-dequeue' => 'Non effettuare azioni e rimuovi la pagina dalla coda di cancellazione.',
	'deletequeue-review-reason' => 'Commenti:',
	'deletequeue-review-newreason' => 'Nuova motivazione:',
	'deletequeue-review-newextra' => 'Informazioni aggiuntive:',
	'deletequeue-review-submit' => 'Salva verifica',
	'deletequeue-review-original' => 'Motivazioni per la segnalazione',
	'deletequeue-actiondisabled-involved' => "L'azione seguente è stata disattivata perché hai preso parte in questo caso di cancellazione nei ruoli di: $1",
	'deletequeue-actiondisabled-notexpired' => "L'azione seguente è stata disattivata perché la segnalazione della cancellazione non è ancora scaduta:",
	'deletequeue-review-badaction' => "È stata specificata un'azione non valida",
	'deletequeue-review-actiondenied' => "È stata specificata un'azione che è disattivata per questa pagina",
	'deletequeue-review-objections' => "'''Attenzione''': La cancellazione di questa pagina ha delle [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} opposizioni]. Assicurarsi di aver considerato queste opposizioni prima di cancellare la pagina.",
	'deletequeue-reviewspeedy-tab' => 'Verifica cancellazione immediata',
	'deletequeue-reviewspeedy-title' => 'Verifica la segnalazione della cancellazione immediata di "$1"',
	'deletequeue-reviewspeedy-text' => "È possibile utilizzare questo modulo per verificare la segnalazione della cancellazione immediata di \"'''\$1'''\". Assicurarsi che questa pagina possa essere cancellata immediatamente secondo le policy.",
	'deletequeue-reviewprod-tab' => 'Verifica cancellazione proposta',
	'deletequeue-reviewprod-title' => 'Verifica la proposta di cancellazione cancellazione di "$1"',
	'deletequeue-reviewprod-text' => "È possibile utilizzare questo modulo per controllare la proposta di cancellazione non contestata di \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Controlla cancellazione',
	'deletequeue-reviewdeletediscuss-title' => 'Controlla la discussione sulla cancellazione di "$1"',
	'deletequeue-reviewdeletediscuss-text' => "È possibile utilizzare questo modulo per controllare la discussione sulla cancellazione di \"'''\$1'''\".

È disponibile un [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} elenco] dei supporti e delle opposizioni a questa cancellazione e la discussione può essere trovata a [[\$2]]. Assicurarsi di prendere una decisione in base al consenso raggiunto nella discussione.",
	'deletequeue-deletediscuss-discussionpage' => 'Questa è la pagina di discussione per la cancellazione di [[$1]]. Ci sono al momento $2 {{PLURAL:$2|utente che supporta|utenti che supportano}} la cancellazione e $3 {{PLURAL:$3|utente che si oppone|utenti che si oppongono}} a essa. È possibile [{{fullurl:$1|action=delvote}} supportare oppure opporsi] alla cancellazione o [{{fullurl:$1|action=delviewvotes}} visualizzare tutti i supporti e le opposizioni].',
	'deletequeue-discusscreate-summary' => 'Creazione della discussione sulla cancellazione di [[$1]].',
	'deletequeue-discusscreate-text' => 'Cancellazione proposta per il seguente motivo: $2',
	'deletequeue-role-nominator' => 'proponente della cancellazione',
	'deletequeue-role-vote-endorse' => 'supporti alla cancellazione',
	'deletequeue-role-vote-object' => 'opposizioni alla cancellazione',
	'deletequeue-vote-tab' => 'Supporta/Opponiti alla cancellazione',
	'deletequeue-vote-title' => 'Supporto o opposizione alla cancellazione di "$1"',
	'deletequeue-vote-text' => "È possibile utilizzare questo modulo per sostenere oppure opporsi alla cancellazione di \"'''\$1'''\". Questa azione sostituirà qualsiasi supporto o opposizione precedentemente dati alla cancellazione di questa pagina. È possibile [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} visualizzare] i supporti e le opposizioni già presenti. La motivazione fornita per la segnalazione di cancellazione è ''\$2''.",
	'deletequeue-vote-legend' => 'Supporta/Opponiti alla cancellazione',
	'deletequeue-vote-action' => 'Raccomandazioni:',
	'deletequeue-vote-endorse' => 'Supporta cancellazione.',
	'deletequeue-vote-object' => 'Opponiti alla cancellazione.',
	'deletequeue-vote-reason' => 'Commenti:',
	'deletequeue-vote-submit' => 'Invia',
	'deletequeue-vote-success-endorse' => 'Hai supportato con successo la cancellazione di questa pagina.',
	'deletequeue-vote-success-object' => 'Ti sei opposto con successo alla cancellazione di questa pagina.',
	'deletequeue-vote-requeued' => 'Ti sei opposto con successo alla cancellazione di questa pagina. A causa della tua opposizione la pagina è stata spostata nella coda $1.',
	'deletequeue-showvotes' => 'Supporti e opposizioni alla cancellazione di "$1"',
	'deletequeue-showvotes-text' => "Di seguito sono elencati i supporti e le opposizioni alla cancellazione della pagina \"'''\$1'''\". È possibile registrare il proprio supporto o la propria opposizione a questa cancellazione  [{{fullurl:{{FULLPAGENAME}}|action=delvote}} qui].",
	'deletequeue-showvotes-restrict-endorse' => 'Mostra solo i supporti',
	'deletequeue-showvotes-restrict-object' => 'Mostra solo le opposizioni',
	'deletequeue-showvotes-restrict-none' => 'Mostra tutti i supporti e le opposizioni',
	'deletequeue-showvotes-vote-endorse' => "Cancellazione '''supportata''' il $2 alle $1",
	'deletequeue-showvotes-vote-object' => "'''Opposizione''' alla cancellazione il $2 alle $1",
	'deletequeue-showvotes-none' => 'Non ci sono supporti o opposizioni alla cancellazione di questa pagina.',
	'deletequeue-showvotes-none-endorse' => 'Non ci sono supporti alla cancellazione di questa pagina.',
	'deletequeue-showvotes-none-object' => 'Non ci sono opposizioni alla cancellazione di questa pagina.',
	'deletequeue' => 'Coda di cancellazione',
	'deletequeue-list-text' => 'Di seguito sono mostrate tutte le pagine che si trovano nel sistema di cancellazione.',
	'deletequeue-list-search-legend' => 'Cerca pagine',
	'deletequeue-list-queue' => 'Coda:',
	'deletequeue-list-status' => 'Stato:',
	'deletequeue-list-expired' => 'Mostra solo le segnalazioni che richiedono di essere chiuse.',
	'deletequeue-list-search' => 'Ricerca',
	'deletequeue-list-anyqueue' => '(alcuni)',
	'deletequeue-list-votes' => 'Elenco dei voti',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|supporto|supporti}}, $2 {{PLURAL:$2|opposizione|opposizioni}}',
	'deletequeue-list-header-page' => 'Pagina',
	'deletequeue-list-header-queue' => 'Coda',
	'deletequeue-list-header-votes' => 'Supporti e opposizioni',
	'deletequeue-list-header-expiry' => 'Scadenza',
	'deletequeue-list-header-discusspage' => 'Pagina di discussione',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'deletequeue-desc' => '[[Special:DeleteQueue|キューを応用した削除管理システム]]を提供する',
	'deletequeue-action-queued' => '削除',
	'deletequeue-action' => '削除を提案',
	'deletequeue-action-title' => '「$1」の削除を提案',
	'deletequeue-action-text' => "{{SITENAME}} にはページ削除の手順が複数あります:
*あなたがこのページは'''即時削除'''が適当だと考える場合、[{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} こちら]で提示することができます。
*このページは即時削除に適わないが、削除が'''議論を引き起こさないだろう'''場合、[{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} 無議論削除を提案]します。
*このページの削除が'''議論を引き起こすだろう'''場合、[{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} 議論を開始]します。",
	'deletequeue-action-text-queued' => 'この削除事例に関して以下のページを見ることができます:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} 現時点での賛成と反対を見る]
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} このページの削除に賛成または反対する]',
	'deletequeue-permissions-noedit' => 'ページの削除評価に参加するにはそのページを編集できる必要があります。',
	'deletequeue-generic-reasons' => '* 一般的な理由
  ** 荒らし
  ** スパム
  ** メンテナンス
  ** プロジェクトの範囲から逸脱',
	'deletequeue-nom-alreadyqueued' => 'このページは既に削除キューに入っています。',
	'deletequeue-speedy-title' => '「$1」を即時削除候補とする',
	'deletequeue-speedy-text' => "このフォームを使ってページ「'''$1'''」の即時削除を依頼できます。

管理者はこの依頼を審査し、十分な根拠があると考える場合、このページを削除します。あなたは下のドロップ・ダウンリストから削除の理由を選択し、その他の関連情報を提供してください。",
	'deletequeue-prod-title' => '「$1」の削除を提案',
	'deletequeue-prod-text' => "このフォームを使って「'''$1'''」の削除を提案できます。

5日間後に誰もこのページの削除に異論を申し立てていなかった場合、管理者の最終審査の後に削除されます。",
	'deletequeue-delnom-reason' => '提案の理由:',
	'deletequeue-delnom-otherreason' => 'その他の理由',
	'deletequeue-delnom-extra' => '追加情報:',
	'deletequeue-delnom-submit' => '提案',
	'deletequeue-log-nominate' => '「$2」削除キューで [[$1]] の削除を提案',
	'deletequeue-log-rmspeedy' => '[[$1]] の即時削除を却下',
	'deletequeue-log-requeue' => '[[$1]] を別の削除キューに移し変え: 「$2」から「$3」へ',
	'deletequeue-log-dequeue' => '[[$1]] を削除キュー「$2」から除去',
	'right-speedy-nominate' => 'ページの即時削除を提案する',
	'right-speedy-review' => '即時削除の提案を審査する',
	'right-prod-nominate' => 'ページの削除を提案する',
	'right-prod-review' => '異論なしの削除提案を審査する',
	'right-deletediscuss-nominate' => '削除議論を開始する',
	'right-deletediscuss-review' => '削除議論を終了する',
	'right-deletequeue-vote' => '削除に賛成または反対する',
	'deletequeue-queue-speedy' => '即時削除',
	'deletequeue-queue-prod' => '提案削除',
	'deletequeue-queue-deletediscuss' => '削除議論',
	'deletequeue-page-speedy' => 'このページの即時削除が提案されています。削除の提案理由は「$1」です。',
	'deletequeue-page-prod' => "このページの削除が提案されています。提案理由は「$1」です。''$2'' 時点でこの提案に異論が申し立てられていない場合、このページは削除されます。あなたは[{{fullurl:{{FULLPAGENAME}}|action=delvote}} この削除に反対し]、異論を申し立てることができます。",
	'deletequeue-page-deletediscuss' => "このページの削除が提案され、議論が行われています。提案理由は「$1」です。削除議論は[[$5]]で進行中で、''$2'' に結論が出ます。",
	'deletequeue-notqueued' => '選択されたページは現時点で削除キューに入っていません',
	'deletequeue-review-action' => '対処:',
	'deletequeue-review-delete' => 'ページを削除する。',
	'deletequeue-review-change' => 'このページを削除するが、根拠は別のものとする。',
	'deletequeue-review-requeue' => 'このページを以下のキューに移し変える:',
	'deletequeue-review-dequeue' => '何の対処もとらず、ページを削除キューから除く。',
	'deletequeue-review-reason' => 'コメント:',
	'deletequeue-review-newreason' => '新しい理由:',
	'deletequeue-review-newextra' => '追加情報:',
	'deletequeue-review-submit' => '審査を保存',
	'deletequeue-review-original' => '提案理由',
	'deletequeue-actiondisabled-involved' => 'あなたはこの削除事例に$1として参加しているため、以下の操作は不可能です:',
	'deletequeue-actiondisabled-notexpired' => '削除提案が期限に達していないため、以下の操作は不可能です:',
	'deletequeue-review-badaction' => '無効な操作を指定しました',
	'deletequeue-review-actiondenied' => 'このページでは不可能な操作を指定しました',
	'deletequeue-review-objections' => "'''警告''': このページの削除には[{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} 反対]がなされています。このページを削除する前にそれらの反対意見を考慮したことを確認してください。",
	'deletequeue-reviewspeedy-tab' => '即時削除を審査',
	'deletequeue-reviewspeedy-title' => '「$1」の即時削除提案を審査',
	'deletequeue-reviewspeedy-text' => "このフォームを使って「'''$1'''」の即時削除提案を審査することができます。このページが方針に則って即時削除できることを確認してください。",
	'deletequeue-reviewprod-tab' => '提案削除を審査',
	'deletequeue-reviewprod-title' => '「$1」の提案削除を審査',
	'deletequeue-reviewprod-text' => "このフォームを使って「'''$1'''」の異論なしの削除提案を審査することができます。",
	'deletequeue-reviewdeletediscuss-tab' => '削除を審査',
	'deletequeue-reviewdeletediscuss-title' => '「$1」の削除議論を審査',
	'deletequeue-reviewdeletediscuss-text' => "このフォームを使って「'''$1'''」の削除議論を審査することができます。

この削除への賛成と反対の[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} 一覧]が確認でき、議論そのものは[[$2]]で見ることができます。議論での合意に則って決断を下してください。",
	'deletequeue-review-success' => 'このページの削除審査に成功しました',
	'deletequeue-review-success-title' => '審査完了',
	'deletequeue-deletediscuss-discussionpage' => 'これは [[$1]] の削除について議論するページです。現時点で、$2人の利用者が削除に賛成し、$3人の利用者が削除に反対しています。あなたは削除に[{{fullurl:$1|action=delvote}} 賛成または反対]をするか、[{{fullurl:$1|action=delviewvotes}} すべての賛成と反対を見る]ことができます。',
	'deletequeue-discusscreate-summary' => '[[$1]] の削除議論を作成中',
	'deletequeue-discusscreate-text' => '次の理由で提案された削除: $2',
	'deletequeue-role-nominator' => '削除の提案者',
	'deletequeue-role-vote-endorse' => '削除の賛成者',
	'deletequeue-role-vote-object' => '削除への反対者',
	'deletequeue-vote-tab' => '削除に投票',
	'deletequeue-vote-title' => '「$1」の削除に賛成または反対',
	'deletequeue-vote-text' => "このフォームを使って「'''$1'''」の削除に賛成あるいは反対することができます。この操作は、あなたがこのページの削除に対して以前に表明した、賛成あるいは反対を上書きします。また、既存の賛成および反対を[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} 確認]することができます。削除の提案理由は「$2」です。",
	'deletequeue-vote-legend' => '削除に賛成または反対',
	'deletequeue-vote-action' => '推奨:',
	'deletequeue-vote-endorse' => '削除に賛成',
	'deletequeue-vote-object' => '削除に反対',
	'deletequeue-vote-reason' => 'コメント:',
	'deletequeue-vote-submit' => '送信',
	'deletequeue-vote-success-endorse' => 'このページの削除への賛成表明に成功しました。',
	'deletequeue-vote-success-object' => 'このページの削除への反対表明に成功しました。',
	'deletequeue-vote-requeued' => 'このページの削除への反対表明に成功しました。あなたの反対のため、ページは$1キューに移動されました。',
	'deletequeue-showvotes' => '「$1」の削除への賛成と反対',
	'deletequeue-showvotes-text' => "以下はページ「'''$1'''」の削除に対して表明された賛成と反対です。あなたはこの削除に対する[{{fullurl:{{FULLPAGENAME}}|action=delvote}} 自信の賛成または反対を表明]することができます。",
	'deletequeue-showvotes-restrict-endorse' => '賛成のみ表示',
	'deletequeue-showvotes-restrict-object' => '反対のみ表示',
	'deletequeue-showvotes-restrict-none' => 'すべての賛成と反対を表示',
	'deletequeue-showvotes-vote-endorse' => "$1 $2 に削除に'''賛成'''",
	'deletequeue-showvotes-vote-object' => "$1 $2 に削除に'''反対'''",
	'deletequeue-showvotes-showingonly-endorse' => '賛成のみ表示中',
	'deletequeue-showvotes-showingonly-object' => '反対のみ表示中',
	'deletequeue-showvotes-none' => 'このページの削除に対する賛成や反対はありません。',
	'deletequeue-showvotes-none-endorse' => 'このページの削除には賛成がありません。',
	'deletequeue-showvotes-none-object' => 'このページの削除には反対がありません。',
	'deletequeue' => '削除キュー',
	'deletequeue-list-text' => 'このページはなんらかの削除が提案中であるすべてのページを表示します。',
	'deletequeue-list-search-legend' => 'ページの検索',
	'deletequeue-list-queue' => 'キュー:',
	'deletequeue-list-status' => '状況:',
	'deletequeue-list-expired' => '終了が必要な提案のみを表示',
	'deletequeue-list-search' => '検索',
	'deletequeue-list-anyqueue' => '(任意)',
	'deletequeue-list-votes' => '票一覧',
	'deletequeue-list-votecount' => '賛成 $1票、反対 $2票',
	'deletequeue-list-header-page' => 'ページ',
	'deletequeue-list-header-queue' => 'キュー',
	'deletequeue-list-header-votes' => '賛成と反対',
	'deletequeue-list-header-expiry' => '期限',
	'deletequeue-list-header-discusspage' => '議論ページ',
	'deletequeue-case-intro' => 'このページでは特定の削除事例の情報を一覧しています。',
	'deletequeue-list-header-reason' => '削除理由',
	'deletequeue-case-votes' => '賛成/反対:',
	'deletequeue-case-title' => '削除事例詳細',
	'deletequeue-case-details' => '概要',
	'deletequeue-case-page' => 'ページ:',
	'deletequeue-case-reason' => '理由:',
	'deletequeue-case-expiry' => '期限:',
	'deletequeue-case-needs-review' => 'この事例には[[$1|審査]]が必要です。',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'deletequeue-desc' => 'បង្កើត​[[Special:DeleteQueue|ប្រព័ន្ធ​ជា​ជួរ​សម្រាប់​គ្រប់គ្រង​ការ​លុប]]',
	'deletequeue-action-queued' => 'ការលុប',
	'deletequeue-action' => 'ស្នើឱ្យ​លុប',
	'deletequeue-action-title' => 'ស្នើឱ្យ​លុប​ចំពោះ "$1"',
	'deletequeue-nom-alreadyqueued' => 'ទំព័រ​នេះ​ស្ថិត​នៅ​ក្នុង​ជួរ​ដែល​ត្រូវ​លុប​រួចហើយ​។',
	'deletequeue-speedy-title' => 'សម្គាល់ "$1" សម្រាប់​ការលុប​ឱ្យ​បាន​លឿន',
	'deletequeue-delnom-otherreason' => 'មូលហេតុផ្សេងទៀត',
	'deletequeue-delnom-extra' => 'ព័ត៌មានបន្ថែម៖',
	'right-deletediscuss-nominate' => 'ចាប់ផ្ដើម​កិច្ចពិភាក្សា​អំពី​ការលុប',
	'right-deletediscuss-review' => 'បិទ​កិច្ចពិភាក្សា​អំពី​ការលុប',
	'right-deletequeue-vote' => 'យល់ស្រប ឬ ជំទាស់​ចំពោះ​ការលុប',
	'deletequeue-queue-speedy' => 'លុប​ឱ្យ​បាន​លឿន',
	'deletequeue-queue-deletediscuss' => 'កិច្ចពិភាក្សា​អំពី​ការលុប',
	'deletequeue-review-delete' => 'លុបទំព័រ។',
	'deletequeue-review-reason' => 'យោបល់៖',
	'deletequeue-review-newreason' => 'មូលហេតុថ្មី៖',
	'deletequeue-review-newextra' => 'ព័ត៌មានបន្ថែម៖',
	'deletequeue-review-submit' => 'រក្សាទុក​ពិនិត្យឡើងវិញ',
	'deletequeue-discusscreate-summary' => 'បាន​បង្កើត​កិច្ចពិភាក្សា​សម្រាប់​ការលុប [[$1]] ។',
	'deletequeue-role-vote-endorse' => 'អ្នកយល់ស្រប​ចំពោះ​ការលុប',
	'deletequeue-role-vote-object' => 'អ្នកជំទាស់​ចំពោះ​ការលុប',
	'deletequeue-vote-tab' => 'បោះឆ្នោត​ស្ដីពីការលុប',
	'deletequeue-vote-title' => 'យល់ស្រប ឬ បដិសេធ​ចំពោះ​ការលុប "$1"',
	'deletequeue-vote-legend' => 'យល់ស្រប/ជំទាស់ ចំពោះ​ការលុប',
	'deletequeue-vote-action' => 'អនុសាសន៍​៖',
	'deletequeue-vote-endorse' => 'យល់ស្រប​ឱ្យ​លុប​។',
	'deletequeue-vote-object' => 'ជំទាស់​មិនឱ្យ​លុប​។',
	'deletequeue-vote-reason' => 'សេចក្ដីអធិប្បាយ​៖',
	'deletequeue-vote-submit' => 'ដាក់ស្នើ',
	'deletequeue-vote-success-endorse' => 'អ្នក​បាន​បញ្ចេញ​មតិ​យល់ស្រប​ចំពោះ​ការលុប​ទំព័រ​នេះ ដោយជោគជ័យ​ហើយ​។',
	'deletequeue-vote-success-object' => 'អ្នក​បាន​បញ្ចេញ​មតិ​ជំទាស់​ចំពោះ​ការលុប​ទំព័រ​នេះ ដោយជោគជ័យ​ហើយ​។',
	'deletequeue-showvotes' => 'ការយល់ស្រប និង​ជំទាស់​ចំពោះ​ការ​លុប "$1"',
	'deletequeue-showvotes-restrict-endorse' => 'បង្ហាញ​ការ​យល់ស្រប​តែ​ប៉ុណ្ណោះ',
	'deletequeue-showvotes-restrict-object' => 'បង្ហាញ​ការ​ជំទាស់​តែ​ប៉ុណ្ណោះ',
	'deletequeue-showvotes-restrict-none' => 'បង្ហាញ​រាល់​ការយល់ស្រប និង​ជំទាស់​ទាំងអស់',
	'deletequeue-showvotes-vote-endorse' => "'''យល់ស្រប''' ចំពោះ​ការលុប $1 $2",
	'deletequeue-showvotes-vote-object' => "'''ជំទាស់''' ចំពោះ​ការលុប $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'បង្ហាញ​តែ​ការ​យល់ស្រប',
	'deletequeue-showvotes-showingonly-object' => 'បង្ហាញ​តែ​ការ​ជំទាស់',
	'deletequeue-showvotes-none' => 'គ្មាន​ការ​យល់ស្រប ឬ​ជំទាស់​ក្នុង​ការ​លុប​ទំព័រ​នេះ​ទេ​។',
	'deletequeue-showvotes-none-endorse' => 'គ្មាន​ការ​យល់ស្រប​ក្នុង​ការ​លុប​ទំព័រ​នេះ​ទេ​។',
	'deletequeue-showvotes-none-object' => 'គ្មាន​ការ​ជំទាស់​ក្នុង​ការ​លុប​ទំព័រ​នេះ​ទេ​។',
	'deletequeue' => 'លុប​ជួរ',
	'deletequeue-list-text' => 'ទំព័រ​នេះ​បង្ហាញ​រាល់​ទំព័រ​ទាំងអស់ ដែល​ស្ថិតនៅក្នុង​ប្រព័ន្ធ​ដែល​ត្រូវ​លុបចេញ​។',
	'deletequeue-list-search-legend' => 'ស្វែងរក​ទំព័រ',
	'deletequeue-list-queue' => 'ជួរ​៖',
	'deletequeue-list-status' => 'ស្ថានភាព​៖',
	'deletequeue-list-search' => 'ស្វែងរក',
	'deletequeue-list-anyqueue' => '(ណាមួយ)',
	'deletequeue-list-votes' => 'បញ្ជី​នៃ​ការបោះឆ្នោត',
	'deletequeue-list-header-page' => 'ទំព័រ',
	'deletequeue-list-header-queue' => 'ជួរ',
	'deletequeue-list-header-votes' => 'ការយល់ស្រប និង​ជំទាស់',
	'deletequeue-list-header-discusspage' => 'ទំព័រ​ពិភាក្សា',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'deletequeue-list-search' => 'Luk foh am',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'deletequeue-desc' => 'Schaff en Süßteem met [[Special:DeleteQueue|Schlange fun Sigge, di op et Fottschmiiße am waade]] sin.',
	'deletequeue-action-queued' => 'Fottschmiiße',
	'deletequeue-action' => 'Fottschmiiße vürjeschlare',
	'deletequeue-action-title' => '„$1“ för fottzeschmiiße vörschlare',
	'deletequeue-action-text' => 'Mer han en Aanzahl fun Müjjeleschkeite, wie mer Sigge loßß krijje künne:
* Wann De meins, dat en Sigg joot doför es, dann [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} schlaach för, se flöck fottzeschmiiße].
* Wann flöck Fottschmiiße nit paß, ävver koum Eine jet dojäje han weed, donn [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} Fottschmiiße oohne Jäjeshtemme vörschlonn].
* Wann de jlöüfs, dat et wall Jääjeshtemme jevve weet, dann es joot, [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} ene Klaaf drövver opzemaache].',
	'deletequeue-action-text-queued' => 'Do kanns för hee der Förschlaach zem Fottschmiiße op hee di Sigge jonn, un domet:
*de [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} aktoälle Zohshtemmunge un Afflehnunge beloore],
*udder [{{fullurl:{{FULLPAGENAME}}|action=delvote}} donn sellver zohshtemme udder afflehne].',
	'deletequeue-permissions-noedit' => 'Do moß en Sigg ändere dörve, öm beshtemme ze dörve, of se fottjeschmeße weed udder nit.',
	'deletequeue-generic-reasons' => '* jrundläje Jründ
   ** Vandaleere
   ** Reklame
   ** Waadung
   ** Paß nit ent Projäk',
	'deletequeue-nom-alreadyqueued' => 'Die Sigg es ald en dä Fotschmiiß-Leß',
	'deletequeue-speedy-title' => '„$1“ för flöck fottzeschmiiße vörschlaare',
	'deletequeue-speedy-text' => 'Övver hee dat Fommulaa kanns De de Sigg „$1“ för flöck fottzeschmiiße förmerke.

Ene Wiki-Köbes weed dä Förschlaach pröfe, un wann dä ene jode Jrond hät,
weed di Sigg fottjeschmeße. Do moß ene Jrund för et Fottschmiiße uß
unge dä Leß ußsööke, un alles sönß aanjevve, wat weschtesch sin künnt.',
	'deletequeue-prod-title' => 'Vörschlaach zem Fottschmiiße: „$1“',
	'deletequeue-prod-text' => 'Övver hee dat Fommulaa kanns De de Sigg „$1“ för fottzeschmiiße förschlonn.

Wann bes en fönnef Dääsch keine jet jääje et Fottschmiiße förjebraat hät,
weed ene Wiki-Köbes dä Förschlaach pröfe, un wann ene jode Jrond do es,
di Sigg fottschmiiße.',
	'deletequeue-delnom-reason' => 'Dä Jrund för dä Vörschlach:',
	'deletequeue-delnom-otherreason' => 'Ene andere Jrund',
	'deletequeue-delnom-extra' => 'Zosätzlijje Enfommazjuhne:',
	'deletequeue-delnom-submit' => 'Loß Jonn!',
	'deletequeue-log-nominate' => 'Hät vörjeschaare, „[[$1]]“ övver de Leß „$2“ fottzeschmiiße.',
	'deletequeue-log-rmspeedy' => 'hät affjelehnt, „[[$1]]“ flöck fottzeschmiiße.',
	'deletequeue-log-requeue' => 'hät „[[$1]]“ uß dä Leß „$2“ för et Fottschmiiße eruß jenumme un en de Leß „$3“ jedonn.',
	'deletequeue-log-dequeue' => 'hät „[[$1]]“ uß dä Leß „$2“ för et Fottschmiiße eruß jenumme.',
	'right-speedy-nominate' => 'Sigge för flöck fottzeschmiiße vörschlonn',
	'right-speedy-review' => 'Vörschlääsch för jet flöck fottzeschmiiße pröfe',
	'right-prod-nominate' => 'Sigge för et Fottschmiiße vörschlonn',
	'right-prod-review' => 'Vörschlääsch för et Fottschmiiße pröfe, die ohne Jäjeschtemme sin',
	'right-deletediscuss-nominate' => 'Der Klaaf övver et Fottschmiiße opmache',
	'right-deletediscuss-review' => 'Däm Klaaf övver et Fottschmiiße en Ängk maache',
	'right-deletequeue-vote' => 'Dämm Fottschmiiße zoshtemme odder derwidder sin',
	'deletequeue-queue-speedy' => 'Flöck Fottschmiiße',
	'deletequeue-queue-prod' => 'Förjeschlare fottzeschmiiße',
	'deletequeue-queue-deletediscuss' => 'Klaaf övver et Fottschmiiße',
	'deletequeue-page-speedy' => "Mer han ene Vörschlaach, di Sigg hee flöck fottzeschmiiße.
Als der Jrond doför es ''$1'' aanjejovve.",
	'deletequeue-page-prod' => "Mer han ene Vörschlaach, di Sigg hee fottzeschmiiße.
Als der Jrond doför wood ''$1'' aanjejovve.
Wann bes aam $3 öm $4 Uhr kei Jäjeshtemme opjedouch sin, dann dom_mer di Sigg fottschmiiße.
Wann De meijns, kanns De [{{fullurl:{{FULLPAGENAME}}|action=delvote}} jääje et Fottschmiiße shtemme].",
	'deletequeue-page-deletediscuss' => "Mer han ene Vörschlaach, di Sigg hee fottzeschmiiße.
Als der Jrond doför wood ''$1'' aanjejovve.
Et jitt ävver Jäjeshtemme.
Der Klaaf do drövver op [[$5]] jeiht bes aam $3 öm $2 Uhr.",
	'deletequeue-notqueued' => 'Do häß_Der en Sigg ußjesooht, di jaa nit en de Leß för fottzeschmiiße es.',
	'deletequeue-review-action' => 'Wat ze donn es:',
	'deletequeue-review-delete' => 'Die Sigg fottschmiiße.',
	'deletequeue-review-change' => 'De Sigg fottschmiiße, ävver met enem andere Jrond.',
	'deletequeue-review-requeue' => 'Donn hee di Sigg en de Leß:',
	'deletequeue-review-dequeue' => 'Donn nix sönß, ävver donn di Sigg uß dä Leß för et Fottschmiiße eruß nämme.',
	'deletequeue-review-reason' => 'Kommäntaare:',
	'deletequeue-review-newreason' => 'Neue Jrund:',
	'deletequeue-review-newextra' => 'Zosätzlijje Enfommazjuhne:',
	'deletequeue-review-submit' => 'Joß Jonn!',
	'deletequeue-review-original' => 'De Bejröndung för dä Vörschlaach',
	'deletequeue-actiondisabled-involved' => 'De Axjuhn hee noh is för Desch nit zohjelohße, Do häs jo ald als $1 beij dämm Vörschlaach för et Fottschmiiße metjemaat:',
	'deletequeue-actiondisabled-notexpired' => 'De Axjuhn hee noh is jez nit zohjelohße, dä Vörschlaach för et Fottschmiiße es noch jaa nit affjeloufe:',
	'deletequeue-review-badaction' => 'Do häs en onjöltijje Axjuhn aanjejovve',
	'deletequeue-review-actiondenied' => 'Do häs en Axjuhn jewullt, die för hee die Sigg affjeschalldt es.',
	'deletequeue-review-objections' => "'''Opjepaß''': Di Sigg hee fottzeschmiiße, hät
[{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} Jäjeshtemme] krääje.
Beß sescher, dat De Der di dorsch der Kopp jon löhß, iih dat de di Sigg wörklesch fott schmiiße deihß.",
	'deletequeue-reviewspeedy-tab' => 'Et flöcke Fottschmiiße pröfe',
	'deletequeue-reviewspeedy-title' => '„$1“ flöck Fottschmiiße pröfe',
	'deletequeue-reviewspeedy-text' => 'Do kanns met dämm Fommullaa hee dä Vörschlaach prööve,
di Sigg „$1“ flöck fottzeschmiiße.
Paß op: Beß sescher, dat di Sigg moh unser_Rääjelle
och wörklesch flöck fottjeschmeße wäde kann.',
	'deletequeue-reviewprod-tab' => 'Vörjeschlaare Fottschmiiße pröve',
	'deletequeue-reviewprod-title' => 'Vörjeschlaare Fottschmiiße pröve för „$1“',
	'deletequeue-reviewprod-text' => 'Do kanns met dämm Fommullaa hee dä Förschlaach, di Sigg „$1“ fottzeschmiiße, pröfe. Dä hät kei Jäjeshtemme kaßeet.',
	'deletequeue-reviewdeletediscuss-tab' => 'Et Fottschmiiße pröfe',
	'deletequeue-reviewdeletediscuss-title' => 'Dä Klaaf övver et Fottschmiiße fun „$1“ pröfe',
	'deletequeue-reviewdeletediscuss-text' => 'Do kanns met dämm Fommullaa hee dä Klaaf drövver, di Sigg „$1“ fottzeschmiiße, pröfe.

En [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Leß met Shtemme doför un däjääje]
es för Desch do, un dä Klaaf sellver fengkß de op  [[$2]].
Paß op: Beß sescher, dat och wörklesch noh unser_Rääjelle äntscheidtß.',
	'deletequeue-review-success' => 'Do häs dat Fottschmiiße jeprööf, för he di Sigg.',
	'deletequeue-review-success-title' => 'De Prööverei es fäädesch',
	'deletequeue-deletediscuss-discussionpage' => 'Dat hee es de Klaafsigg övver et Fottschmiiße fun [[$1]].
Mer han jez jraad {{PLURAL:$2|eine|$2|keine}} Metmaacher,
die do för sin, un {{PLURAL:$3|eine|$3|keine}} Metmaacher,
die do jäje sin.
Do kanns [{{fullurl:$1|action=delvote}} zoshtemme odder afflehne], dat
die Sigg fottjeschmeße weed, un Der de
[{{fullurl:$1|action=delviewvotes}} Zostemmunge un Afflehnunge aankike].',
	'deletequeue-discusscreate-summary' => 'Dä Klaaf övver et Fottschmiiße vun [[$1]] weed opjemaat.',
	'deletequeue-discusscreate-text' => 'Dat Fottschmiiße wood vörjeschlare wäje: $2',
	'deletequeue-role-nominator' => 'Wä dat Fottschmiiße et eets förjeschlaare hät',
	'deletequeue-role-vote-endorse' => 'Wä för et Fottschmiiße es',
	'deletequeue-role-vote-object' => 'Wä jäje et Fottschmiiße es',
	'deletequeue-vote-tab' => 'Övver et Fottschmiiße affshtemme',
	'deletequeue-vote-title' => 'Däm Fottschmiiße vun „$1“ zoshtemme odder et aflähne',
	'deletequeue-vote-text' => "Do kanns met dämm Fommullaa hee dä Vörschlaach, di Sigg „$1“ fottzeschmiiße,
zohshtemme udde desch dojääje ensäzze. Domet deihß De all Ding fröjere
Zohshtemmunge udder Afflehnunge widder ophävve. Wann De meijns, kanns De de
[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Shtemme doför un däjääje aanloore].
Als der Jrond för de Sigg fottzeschmiiße wood ''$2'' aanjejovve.",
	'deletequeue-vote-legend' => 'Däm Fottschmiiße zoshtemme odder et aflähne',
	'deletequeue-vote-action' => 'Emfällung:',
	'deletequeue-vote-endorse' => 'Zoshtimme zom Fottschmiiße.',
	'deletequeue-vote-object' => 'Jäje et Fottschmiiße.',
	'deletequeue-vote-reason' => 'Kommäntaare:',
	'deletequeue-vote-submit' => 'Loß Jonn!',
	'deletequeue-vote-success-endorse' => 'Dö häs doför jeshtimmp, di Sigg hee fottzeschmiiße.',
	'deletequeue-vote-success-object' => 'Dö häs dojääje jeshtimmp, di Sigg hee fottzeschmiiße.',
	'deletequeue-vote-requeued' => 'Dö häs dojääje jeshtimmp, di Sigg hee fottzeschmiiße.
Dröm es die Sigg jetz en de Leß „$1“ jekumme.',
	'deletequeue-showvotes' => 'Zohshtemmung un Aflehnunge doför un dojääje, „$1“ fottzeschmiiße',
	'deletequeue-showvotes-text' => "Unge sen de Zoshtemmunge un Aflehnunge för et Fottschmiiße vun dä Sigg „'''$1'''“ opjeleß.
Do kanns Ding [{{fullurl:{{FULLPAGENAME}}|action=delvote}} eije Zoshtemmung odder Aflehnung zom Fottschmiiße endraare].",
	'deletequeue-showvotes-restrict-endorse' => 'Nur Zoshtemmunge zeije',
	'deletequeue-showvotes-restrict-object' => 'Nur Aflehnunge zeije',
	'deletequeue-showvotes-restrict-none' => 'Alle Zoshtemmunge un Aflehnunge zeije',
	'deletequeue-showvotes-vote-endorse' => "Am $1 öm $2 et Fottschmiiße '''zojeshtemmp'''",
	'deletequeue-showvotes-vote-object' => "Am $1 öm $2 et Fottschmiiße '''affjelehnt'''",
	'deletequeue-showvotes-showingonly-endorse' => 'Nur de Zostemmunge',
	'deletequeue-showvotes-showingonly-object' => 'Nur de Afflehnunge',
	'deletequeue-showvotes-none' => 'Keine es doför, un och keine dojääje, die Sigg hee fottzeschmiiße.',
	'deletequeue-showvotes-none-endorse' => 'Keiner es doför, die Sigg hee fottzeschmiiße.',
	'deletequeue-showvotes-none-object' => 'Keiner es dojääje, die Sigg hee fottzeschmiiße.',
	'deletequeue' => 'Leß för zem Fottschmiiße',
	'deletequeue-list-text' => 'Die Sigg hee zeish all de Sigge, die en ein fun de Leßte för et Fottschmiiße shtonn.',
	'deletequeue-list-search-legend' => 'Noh Sigge söke',
	'deletequeue-list-queue' => 'Leß:',
	'deletequeue-list-status' => 'Stattus:',
	'deletequeue-list-expired' => 'Zeich nur de Vörschlääsh, die mer fäädesch maache künne.',
	'deletequeue-list-search' => 'Söke',
	'deletequeue-list-anyqueue' => '(jede)',
	'deletequeue-list-votes' => 'Leß met de Stemme',
	'deletequeue-list-votecount' => '{{PLURAL:$1|Eine es|$1 sin|Keine es}} doför, un {{PLURAL:$2|eine|$2|keine}} dojähje',
	'deletequeue-list-header-page' => 'Sigg',
	'deletequeue-list-header-queue' => 'Leß',
	'deletequeue-list-header-votes' => 'Doför un dojäje',
	'deletequeue-list-header-expiry' => 'Et Ußloufe',
	'deletequeue-list-header-discusspage' => 'Klaafsigg',
	'deletequeue-case-intro' => 'Hee op dä Sigg sin de Enfomazjuhne övver en beschtemmpte Vörschlaach för jet fottzeschmiiße.',
	'deletequeue-list-header-reason' => 'De Bejröndung för et Fottschmiiße',
	'deletequeue-case-votes' => 'Stemme doför un dojääje:',
	'deletequeue-case-title' => 'Eijzelheijte vum Fottschmiiße',
	'deletequeue-case-details' => 'Jrundlääje Eijnzelheijte',
	'deletequeue-case-page' => 'Sigg:',
	'deletequeue-case-reason' => 'Jrond udder Aanlaß:',
	'deletequeue-case-expiry' => 'Löüf uß aam:',
	'deletequeue-case-needs-review' => 'Hee dä Fall moß [[$1|nohjeloort wääde]].',
);

/** Cornish (Kernewek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'deletequeue-list-search' => 'Hwilas',
	'deletequeue-list-anyqueue' => '(vydh)',
	'deletequeue-case-page' => 'Folen:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'deletequeue-action-queued' => 'Läschen',
	'deletequeue-action' => 'Läsche virschloen',
	'deletequeue-action-title' => 'Läsche vu(n) "$1" virschloen',
	'deletequeue-permissions-noedit' => 'Dir musst eng Säit ännere kënnen, fir hire Läschstatus veränneren ze kënnen.',
	'deletequeue-generic-reasons' => '* Heefegst Grënn
** Vandalismus
** Spam
** Maintenance
** Net am Sënn vum Projet',
	'deletequeue-nom-alreadyqueued' => 'Dës Säit steet schon op der Lëscht fir ze läschen.',
	'deletequeue-prod-title' => 'D\'Läsche vu(n) "$1" virschloen',
	'deletequeue-delnom-reason' => "Grond fir d'Ufro (fir ze läschen):",
	'deletequeue-delnom-otherreason' => 'Anere Grond',
	'deletequeue-delnom-extra' => 'Zousätzlech Informatioun:',
	'right-prod-nominate' => 'Säit virschloe vir ze läschen',
	'right-deletediscuss-nominate' => 'Läschdiskussiounen ufänken',
	'right-deletediscuss-review' => 'Läschdiskussiounen ofschléissen',
	'deletequeue-queue-speedy' => 'Séier Läschen',
	'deletequeue-queue-prod' => 'Virgeschlo fir ze läschen',
	'deletequeue-queue-deletediscuss' => 'Läschdiskussioun',
	'deletequeue-review-delete' => "D'Säit läschen",
	'deletequeue-review-change' => 'Dës Säit läschen, awer mat engem anere Grond.',
	'deletequeue-review-reason' => 'Bemierkungen:',
	'deletequeue-review-newreason' => 'Neie Grond:',
	'deletequeue-review-newextra' => 'Zousätzlech Informatioun:',
	'deletequeue-reviewspeedy-tab' => 'Séier läschen iwwerpréifen',
	'deletequeue-reviewdeletediscuss-tab' => 'Läschen iwwerpréifen',
	'deletequeue-reviewdeletediscuss-title' => 'Diskussioun iwwer d\'Läsche vu(n) "$1" nokucken',
	'deletequeue-discusscreate-text' => "D'Läsche gouf aus dësem Grond virgeschlo: $2",
	'deletequeue-role-vote-endorse' => "Fir d'Läschen",
	'deletequeue-role-vote-object' => "Géint d'Läschen",
	'deletequeue-vote-tab' => "Iwwer d'Läschen ofstëmmen",
	'deletequeue-vote-legend' => "Dem Läschen zoustëmmen/Géint d'Läsche stëmmen",
	'deletequeue-vote-action' => 'Rot:',
	'deletequeue-vote-endorse' => 'Läschen ënnerstetzen',
	'deletequeue-vote-object' => "Géint d'Läschen",
	'deletequeue-vote-reason' => 'Bemierkungen:',
	'deletequeue-showvotes-restrict-endorse' => 'Nëmmem Zoustëmmunge weisen',
	'deletequeue-showvotes-showingonly-endorse' => "Nëmmen d'Zoustëmmunge gi gewisen",
	'deletequeue-list-text' => 'Op dëser Sàit stinn all déi Säiten déi am Läschsystem dra sinn.',
	'deletequeue-list-search-legend' => 'Säite sichen:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Sichen',
	'deletequeue-list-anyqueue' => '(iergendeng)',
	'deletequeue-list-votes' => 'Lëscht vun de Stëmmen',
	'deletequeue-list-header-page' => 'Säit',
	'deletequeue-list-header-discusspage' => 'Diskussiounssäit',
	'deletequeue-case-page' => 'Säit:',
	'deletequeue-case-reason' => 'Grond:',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'deletequeue-list-search' => 'Xerca',
);

/** Limburgish (Limburgs)
 * @author Remember the dot
 */
$messages['li'] = array(
	'deletequeue-list-header-page' => 'Pazjena',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'deletequeue-delnom-otherreason' => 'Вес амал',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$messages['mwl'] = array(
	'deletequeue-list-header-page' => 'Páigina',
	'deletequeue-case-page' => 'Páigina:',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'deletequeue-review-newreason' => 'Од тувталось:',
	'deletequeue-review-newextra' => 'Поладкс информациясь:',
	'deletequeue-list-queue' => 'Чиполань пулось:',
	'deletequeue-list-search' => 'Вешнэмс',
	'deletequeue-list-header-page' => 'Лопа',
	'deletequeue-list-header-queue' => 'Чиполань пуло',
	'deletequeue-list-header-expiry' => 'Таштомома шказо',
	'deletequeue-list-header-discusspage' => 'Кортнема лопа',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'deletequeue-review-newreason' => 'Yancuīc īxtlamatiliztli:',
	'deletequeue-list-header-expiry' => 'Motlamia',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'deletequeue-desc' => "Voegt een [[Special:DeleteQueue|wachtrij voor het beheren van te verwijderen pagina's]] toe",
	'deletequeue-action-queued' => 'Verwijderverzoek',
	'deletequeue-action' => 'Ter verwijdering voordragen',
	'deletequeue-action-title' => '"$1" ter verwijdering voordragen',
	'deletequeue-action-text' => "{{SITENAME}} heeft een aantal processen voor het verwijderen van pagina's:
* Als u denkt dat deze pagina ''direct verwijderd'' kan worden, kunt u deze pagina voor [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} direct verwijdering] voordragen.
* Als deze pagina niet in aanmerking komt voor directe verwijdering, maar het verwijderen ''waarschijnlijk niet tot discussie leidt'', dan kunt u deze [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} voor verwijdering nomineren].
* Als het verwijderen van deze pagina ''waarschijnlijk bezwaar oplevert'', dan kunt u [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} verwijderoverleg starten].",
	'deletequeue-action-text-queued' => "Bij dit verwijderverzoek horen de volgende pagina's:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Overzicht steun en bezwaar].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Het verwijderverzoek steunen of afwijzen].",
	'deletequeue-permissions-noedit' => 'U moet rechten hebben een pagina te bewerken om de verwijderstatus te kunnen veranderen.',
	'deletequeue-generic-reasons' => '* Algemene redenen
** Vandalisme
** Spam
** Onderhoud
** Buiten projectscope',
	'deletequeue-nom-alreadyqueued' => 'Voor deze pagina bestaat al een verwijderverzoek.',
	'deletequeue-speedy-title' => '"$1" voordragen voor directe verwijdering',
	'deletequeue-speedy-text' => "U kunt dit formulier gebruiken om \"'''\$1'''\" voor te dragen voor directe verwijdering.

Een beheerder bekijkt dit verzoek, en verwijdert de pagina's als het verzoek terecht is.
U moet een reden voor verwijdering opgeven uit de onderstaande uitklaplijst en overige relevante informatie invoeren.",
	'deletequeue-prod-title' => '"$1" ter verwijdering voordragen',
	'deletequeue-prod-text' => "U kunt dit formulier gebruiken om \"'''\$1'''\" voor verwijdering voor te dragen.

Als na vijf dagen niemand protest heeft aangetekend tegen de verwijdernominatie, wordt deze na beoordeling door een beheerder verwijderd.",
	'deletequeue-delnom-reason' => 'Reden voor nominatie:',
	'deletequeue-delnom-otherreason' => 'Andere reden',
	'deletequeue-delnom-extra' => 'Extra informatie:',
	'deletequeue-delnom-submit' => 'Nominatie opslaan',
	'deletequeue-log-nominate' => "heeft [[$1]] voor verwijdering voorgedragen in de wachtrij '$2'.",
	'deletequeue-log-rmspeedy' => 'heeft snelle verwijdering van [[$1]] geweigerd.',
	'deletequeue-log-requeue' => "heeft [[$1]] naar een andere verwijderingswachtrij verplaatst: van '$2' naar '$3'.",
	'deletequeue-log-dequeue' => "heeft [[$1]] uit de verwijderingswachtrij '$2' verwijderd.",
	'right-speedy-nominate' => "Pagina's voordragen voor directe verwijdering",
	'right-speedy-review' => 'Nominaties voor directe verwijdering beoordelen',
	'right-prod-nominate' => "Pagina's voor verwijdering voordragen",
	'right-prod-review' => 'Verwijderingsnominaties zonder bezwaar beoordelen',
	'right-deletediscuss-nominate' => 'Verwijderoverleg starten',
	'right-deletediscuss-review' => 'Verwijderoverleg sluiten',
	'right-deletequeue-vote' => 'Verwijderverzoeken steunen of afwijzen',
	'deletequeue-queue-speedy' => 'Snelle verwijdering',
	'deletequeue-queue-prod' => 'Verwijderingsvoorstel',
	'deletequeue-queue-deletediscuss' => 'Verwijderoverleg',
	'deletequeue-page-speedy' => "Deze pagina is genomineerd voor snelle verwijdering. De opgegeven reden is: ''$1''.",
	'deletequeue-page-prod' => "Deze pagina is voor verwijdering voorgedragen.
De opgegeven reden is: ''$1''.
Als er geen bezwaar is tegen dit voorstel op ''$2'', wordt deze pagina verwijderd.
U kunt [{{fullurl:{{FULLPAGENAME}}|action=delvote}} bezwaar maken] tegen de verwijdernominatie.",
	'deletequeue-page-deletediscuss' => "Deze pagina is genomineerd voor verwijdering, en tegen dat voorstel is bezwaar gemaakt.
De opgegeven reden is: ''$1''.
Overleg over dit voorstel wordt gevoerd op [[$5]], en loopt af op ''$2''.",
	'deletequeue-notqueued' => 'De door u geselecteerde pagina is niet genomineerd voor verwijdering',
	'deletequeue-review-action' => 'Te nemen actie:',
	'deletequeue-review-delete' => 'De pagina verwijderen.',
	'deletequeue-review-change' => 'Deze pagina om een andere reden verwijderen.',
	'deletequeue-review-requeue' => 'Deze pagina naar een andere wachtrij verplaatsen:',
	'deletequeue-review-dequeue' => 'Geen verwijdering uitvoeren, en de pagina weghalen van de verwijderingswachtrij.',
	'deletequeue-review-reason' => 'Opmerkingen:',
	'deletequeue-review-newreason' => 'Nieuwe reden:',
	'deletequeue-review-newextra' => 'Extra informatie:',
	'deletequeue-review-submit' => 'Beoordeling opslaan',
	'deletequeue-review-original' => 'Reden voor nominatie',
	'deletequeue-actiondisabled-involved' => 'De volgende handeling is uitgeschakeld omdat u in de volgende rollen aan deze verwijdernominatie hebt deelgenomen: $1',
	'deletequeue-actiondisabled-notexpired' => 'De volgende handeling is uitgeschakeld omdat de verwijdernominatie is nog niet vervallen:',
	'deletequeue-review-badaction' => 'U hebt een niet-bestaande handeling opgegeven',
	'deletequeue-review-actiondenied' => 'U hebt een handeling opgegeven die voor deze pagina is uigeschakeld',
	'deletequeue-review-objections' => "'''Waarschuwing''': er is [{{FULLURL:{{FULLPAGENAME}}|action=delvoteview|votetype=object}} bezwaar] gemaakt tegen de verwijdernominatie voor deze pagina.
Zorg er voor dat u deze overweegt voordat u deze pagina verwijdert.",
	'deletequeue-reviewspeedy-tab' => 'Snelle verwijdering beoordelen',
	'deletequeue-reviewspeedy-title' => 'De snelle verwijderingsnominatie voor "$1" beoordelen',
	'deletequeue-reviewspeedy-text' => "U kunt dit formulier gebruiken om de nominatie voor snelle verwijdering van \"'''\$1'''\" te beoordelen.
Zorg er voor dat u in lijn met het geldende beleid handelt.",
	'deletequeue-reviewprod-tab' => 'Voorgestelde verwijdering nakijken',
	'deletequeue-reviewprod-title' => 'Voorgestelde verwijdering van "$1" nakijken',
	'deletequeue-reviewprod-text' => "U kunt dit formulier gebruiken om de verwijdernominatie van \"'''\$1'''\" te beoordelen.",
	'deletequeue-reviewdeletediscuss-tab' => 'Verwijdernominatie beoordelen',
	'deletequeue-reviewdeletediscuss-title' => "Verwijderoverleg voor \"'''\$1'''\" beoordelen",
	'deletequeue-reviewdeletediscuss-text' => 'U kunt dit formulier gebruiken om de verwijderingsdiscussie voor "$1" na te kijken.

Een [{{FULLURL:{{FULLPAGENAME}}|action=delviewvotes}} lijst] met ondersteuningen en bezwaren voor deze verwijdering is beschikbaar, en de discussie zelf kunt u terugvinden op [[$2]].
Wees zeker dat u een beslissing maakt in overeenstemming met de consensus van de discussie.',
	'deletequeue-review-success' => 'U hebt de controle voor de verwijdering van deze pagina afgerond',
	'deletequeue-review-success-title' => 'Controle afgerond',
	'deletequeue-deletediscuss-discussionpage' => 'Dit is het verwijderoverleg voor [[$1]].
Er {{PLURAL:$2|is|zijn}} op dit moment {{PLURAL:$2|één gebruiker|$2 gebruikers}} die de verwijdernominatie steunen en {{PLURAL:$3|één gebruiker|$3 gebruikers}} die bezwaart {{PLURAL:$3|heeft|hebben}} tegen de verwijdernominatie.
U kunt [{{FULLURL:$1|action=delvote}} steun of bezwaar] bij de verwijdernominatie aangeven of [{{FULLURL:$1|action=delviewvotes}} alle steun en bezwaar bekijken].',
	'deletequeue-discusscreate-summary' => 'Bezig met het starten van een discussie voor de verwijdering van [[$1]].',
	'deletequeue-discusscreate-text' => 'Verwijdering voorgesteld voor de volgende reden: $2',
	'deletequeue-role-nominator' => 'indiener verwijdervoorstel',
	'deletequeue-role-vote-endorse' => 'ondersteunt verwijdervoorstel',
	'deletequeue-role-vote-object' => 'maakt bezwaar tegen verwijdervoorstel',
	'deletequeue-vote-tab' => 'Bezwaar maken/Steun geven aan de verwijdernominatie',
	'deletequeue-vote-title' => 'Bezwaar maken tegen of steun geven aan de verwijdernominatie voor "$1"',
	'deletequeue-vote-text' => "U kunt dit formulier gebruiken om bezwaar te maken tegen de verwijdernominatie voor \"'''\$1'''\" of deze te steunen.
Deze handeling komt in de plaats van eventuele eerdere uitspraken van steun of bezwaar bij de verwijdernominatie van deze pagina.
U kunt [{{FULLURL:{{FULLPAGENAME}}|action=delviewvotes}} alle steun en bezwaar bekijken].
De reden voor de verwijdernominatie is ''\$2''.",
	'deletequeue-vote-legend' => 'Bezwaar en ondersteuning verwijdervoorstel',
	'deletequeue-vote-action' => 'Aanbeveling:',
	'deletequeue-vote-endorse' => 'Verwijdervoorstel steunen.',
	'deletequeue-vote-object' => 'Bezwaar maken tegen verwijdervoorstel.',
	'deletequeue-vote-reason' => 'Opmerkingen:',
	'deletequeue-vote-submit' => 'Opslaan',
	'deletequeue-vote-success-endorse' => 'Uw steun voor de verwijdernominatie van deze pagina is opgeslagen.',
	'deletequeue-vote-success-object' => 'Uw bezwaar tegen de verwijdernominatie van deze pagina is opgeslagen.',
	'deletequeue-vote-requeued' => 'Uw bezwaar tegen de verwijdernominatie van deze pagina is opgeslagen.
Vanwege uw bezwaar, is de pagina verplaatst naar de wachtrij "$1".',
	'deletequeue-showvotes' => 'Steun en bezwaar bij de verwijdernominatie van "$1"',
	'deletequeue-showvotes-text' => "Hieronder worden steun en bezwaar bij de verwijdernominatie van de pagin \"'''\$1'''\" weergegeven.
U kunt ook [{{FULLURL:{{FULLPAGENAME}}|action=delvote}} steun of bezwaar] aangegeven bij deze verwijdernominatie.",
	'deletequeue-showvotes-restrict-endorse' => 'Alleen steun weergeven',
	'deletequeue-showvotes-restrict-object' => 'Alleen bezwaren weergeven',
	'deletequeue-showvotes-restrict-none' => 'Alle steun en bezwaar weergeven',
	'deletequeue-showvotes-vote-endorse' => "Heeft '''steun''' gegeven voor verwijdering op $1 om $2",
	'deletequeue-showvotes-vote-object' => "Heeft '''bezwaar''' gemaakt tegen verwijdering op $1 om $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Alleen steun wordt weergegeven',
	'deletequeue-showvotes-showingonly-object' => 'Alleen bezwaar wordt weergegeven',
	'deletequeue-showvotes-none' => 'Is is geen steun of bezwaar bij de verwijdernominatie van deze pagina.',
	'deletequeue-showvotes-none-endorse' => 'Er is geen steun voor de verwijdernominatie van deze pagina.',
	'deletequeue-showvotes-none-object' => 'Er is geen bezwaar tegen de verwijdermoninatie van deze pagina.',
	'deletequeue' => 'Verwijderingswachtrij',
	'deletequeue-list-text' => "Deze pagina toont alle pagina's die in het verwijderingssysteem zijn.",
	'deletequeue-list-search-legend' => "Zoeken naar pagina's",
	'deletequeue-list-queue' => 'Wachtrij:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Alleen verwijdernominaties weergeven die gesloten moeten worden.',
	'deletequeue-list-search' => 'Zoeken',
	'deletequeue-list-anyqueue' => '(alle)',
	'deletequeue-list-votes' => 'Stemmen',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|steunbetuiging|steunbetuigingen}}, $2 {{PLURAL:$2|bezwaar|bezwaren}}',
	'deletequeue-list-header-page' => 'Pagina',
	'deletequeue-list-header-queue' => 'Wachtrij',
	'deletequeue-list-header-votes' => 'Steun en bezwaar',
	'deletequeue-list-header-expiry' => 'Vervaldatum',
	'deletequeue-list-header-discusspage' => 'Overlegpagina',
	'deletequeue-case-intro' => 'Deze pagina geeft informatie weer over een verwijdering.',
	'deletequeue-list-header-reason' => 'Reden voor de verwijdering',
	'deletequeue-case-votes' => 'Steun/bezwaren:',
	'deletequeue-case-title' => 'Verwijderingsdetails',
	'deletequeue-case-details' => 'Basisdetails',
	'deletequeue-case-page' => 'Pagina:',
	'deletequeue-case-reason' => 'Reden:',
	'deletequeue-case-expiry' => 'Vervalt:',
	'deletequeue-case-needs-review' => 'Deze zaak heeft verder [[$1|onderzoek]] nodig.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'deletequeue-desc' => 'Opprettar eit [[Special:DeleteQueue|købasert system for å handsama sletting]]',
	'deletequeue-action-queued' => 'Sletting',
	'deletequeue-action' => 'Føreslå sletting',
	'deletequeue-action-title' => 'Føreslå sletting av «$1»',
	'deletequeue-action-text' => "{{SITENAME}} har fleire prosessar for sletting av sider:
* Om du meiner at denne sida kvalifiserer for ''snøggsletting'', kan du føreslå det [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=speedy}} her].
* Om sida ikkje kvalifserer for snøggsletting, men ''sletting likevel vil vera ukontroversielt'', kan du [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=prod}} føreslå sletting her].
* Om det er sannsynleg at sletting av sida ''vil verta omdiskutert'', bør du [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=deletediscuss}} opna ein diskusjon].",
	'deletequeue-action-text-queued' => 'Du kan sjå dei følgjande sidene for denne slettekandidaten:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Sjå noverande støtta og motstand].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Støtt eller gå imot sletting av sida].',
	'deletequeue-permissions-noedit' => 'Du må kunna endra ei sida for å kunna påverka slettestatusen hennar.',
	'deletequeue-generic-reasons' => '* Vanlege grunnar
   ** Hæverk
   ** Spam
   ** Vedlikehald
   ** Ikkje relevant for prosjektet',
	'deletequeue-nom-alreadyqueued' => 'Denne sida finst alt i ein slettekø',
	'deletequeue-speedy-title' => 'Merk «$1» for snøggsletting',
	'deletequeue-speedy-text' => "Du kan nytta dette skjemaet for å merkja sida «'''$1'''» for snøggsletting.

Ein administrator vil sjå gjennom førespurnaden, og om han er rimeleg, sletta sida.
Du må velja ei årsak frå lista nedanfor, og leggja til annan relevant informasjon.",
	'deletequeue-prod-title' => 'Føreslå sletting av «$1»',
	'deletequeue-prod-text' => "Du kan nytta dette skjemaet for å føreslå at «'''$1'''» vert sletta.

Om ingen har sett seg mot slettinga innan fem dagar, vil slettinga verta gjennomførd etter ei siste vurdering av ein administrator.",
	'deletequeue-delnom-reason' => 'Grunn for nominsasjon:',
	'deletequeue-delnom-otherreason' => 'Annan grunn',
	'deletequeue-delnom-extra' => 'Ekstra informasjon:',
	'deletequeue-delnom-submit' => 'Nominer',
	'deletequeue-log-nominate' => 'nominerte [[$1]] for sletting i køen «$2».',
	'deletequeue-log-rmspeedy' => 'avviste snøggsletting av [[$1]].',
	'deletequeue-log-requeue' => 'overførte [[$1]] frå slettekøen «$2» til «$3».',
	'deletequeue-log-dequeue' => 'fjerna [[$1]] frå slettekøen «$2».',
	'right-speedy-nominate' => 'Føreslå sider for snøggsletting',
	'right-speedy-review' => 'Handsama forslag om snøggsletting',
	'right-prod-nominate' => 'Føreslå sletting av sider',
	'right-prod-review' => 'Handsama ukontroversielle framlegg om sletting',
	'right-deletediscuss-nominate' => 'Byrja slettediskuskjonar',
	'right-deletediscuss-review' => 'Lukka slettediskusjonar',
	'right-deletequeue-vote' => 'Støtta eller gå imot sletteforslag',
	'deletequeue-queue-speedy' => 'Snøggsletting',
	'deletequeue-queue-prod' => 'Framlegg om sletting',
	'deletequeue-queue-deletediscuss' => 'Slettediskusjon',
	'deletequeue-page-speedy' => "Denne sida har vorten nominert for snøggsletting.
Årsaka som vart oppgjeven var ''$1''.",
	'deletequeue-page-prod' => "Denne sida har vorten føreslegen for sletting.
Årsaka som vart oppgjeven var ''$1''.
Om dette forslaget ikkje er gått imot innan ''$2'', vil sida verta sletta.
Du kan gå imot sletting av sida [{{fullurl:{{FULLPAGENAME}}|action=delvote}} her].",
	'deletequeue-page-deletediscuss' => "Det finst eit framlegg om å sletta denne sida, men innvendingar har kome.
Den oppgjevne sletteårsaka var ''$1''.
Eit ordskifte skjer på [[$5]]; det vil slutta ''$2''.",
	'deletequeue-notqueued' => 'Det har ikkje kome framlegg om sletting for sida du valde.',
	'deletequeue-review-action' => 'Handling:',
	'deletequeue-review-delete' => 'Slett sida.',
	'deletequeue-review-change' => 'Slett sida, men med ei anna grunngjeving.',
	'deletequeue-review-requeue' => 'Overfør sida til følgjande kø:',
	'deletequeue-review-dequeue' => 'Ikkje gjer noko, og fjern sida frå slettekøen.',
	'deletequeue-review-reason' => 'Kommentarar:',
	'deletequeue-review-newreason' => 'Ny grunngjeving:',
	'deletequeue-review-newextra' => 'Ekstra informasjon:',
	'deletequeue-review-submit' => 'Lagra vudering',
	'deletequeue-review-original' => 'Årsak for nominering',
	'deletequeue-actiondisabled-involved' => 'Følgjande handling kan ikkje verta utført av deg då du har teke del i slettesaka som $1:',
	'deletequeue-actiondisabled-notexpired' => 'Følgjande handling kan ikkje verta utført då slettenominasjonen enno ikkje er over:',
	'deletequeue-review-badaction' => 'Du oppgav ei ugyldig handling',
	'deletequeue-review-actiondenied' => 'Du oppgav ei handling som er slege av for denne sida',
	'deletequeue-review-objections' => "'''Åtvaring''': Det har kome [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} motstand] mot sletting av sida.
Gjer deg viss om at du har teke omsyn til han før du slettar ho.",
	'deletequeue-reviewspeedy-tab' => 'Handsam snøggsletting',
	'deletequeue-reviewspeedy-title' => 'Handsam snøggslettenominasjon av «$1»',
	'deletequeue-reviewspeedy-text' => "Du kan nytta dette skjemaet for å vurdera snøggsletting av «'''$1'''».
Gjer deg viss om at sida kan verta snøggsletta i høve til retningslinene.",
	'deletequeue-reviewprod-tab' => 'Handsam sletteforslag',
	'deletequeue-reviewprod-title' => 'Handsam sletteforslag til «$1»',
	'deletequeue-reviewprod-text' => "Du kan nytta dette skjemaet for å handsama slettinga av «'''$1'''», som ikkje har møtt motstand.",
	'deletequeue-reviewdeletediscuss-tab' => 'Vurder sletting',
	'deletequeue-reviewdeletediscuss-title' => 'Vurder sletteordskifte for «$1»',
	'deletequeue-reviewdeletediscuss-text' => "Du kan nytta dette skjemaet til å vurdera sletteordskiftet til «'''$1'''».

Ei [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] over støtta til og motstand mot denne slettinga er tilgjengeleg; og sjølve diskusjonen finst på [[$2]].
Gjer deg viss om at avgjersla di samsvarer med utkoma av diskusjonen.",
	'deletequeue-review-success' => 'Du har handsama slettinga av denne sida',
	'deletequeue-review-success-title' => 'Handsaming fullførd',
	'deletequeue-deletediscuss-discussionpage' => 'Dette er diskusjonssida for slettinga av [[$1]].
Det er no {{PLURAL:$2|éin brukar|$2 brukarar}} som er for sletting, og {{PLURAL:$3|éin brukar|$3 brukarar}} som er imot.
Du ynskjer kanskje [{{fullurl:$1|action=delvote}} å støtta eller gå imot] ei sletting, eller [{{fullurl:$1|action=delviewvotes}} å sjå all støtta og motstand].',
	'deletequeue-discusscreate-summary' => 'Opprettar ein diskusjon for sletting av [[$1]].',
	'deletequeue-discusscreate-text' => 'Sletting føreslege av følgjande grunn: $2',
	'deletequeue-role-nominator' => 'opphavleg nominert av',
	'deletequeue-role-vote-endorse' => 'støttar sletting',
	'deletequeue-role-vote-object' => 'går imot sletting',
	'deletequeue-vote-tab' => 'Røyst over slettinga',
	'deletequeue-vote-title' => 'Støtt eller gå imot sletting av «$1»',
	'deletequeue-vote-text' => "Du kan nytta dette skjemaet for å støtta eller gå imot slettinga av «'''$1'''».
Denne handlinga vil telja i staden for tidlegare støtta for eller motstand mot slettinga som du har gjeve.
Du kan [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} sjå] støtta og motstanden som finst frå før.
Årsaka gjeven for slettenomineringa var ''$2''.",
	'deletequeue-vote-legend' => 'Støtt/gå imot sletting',
	'deletequeue-vote-action' => 'Rår til:',
	'deletequeue-vote-endorse' => 'Støtt sletting.',
	'deletequeue-vote-object' => 'Gå imot sletting.',
	'deletequeue-vote-reason' => 'Kommentarar:',
	'deletequeue-vote-submit' => 'Send',
	'deletequeue-vote-success-endorse' => 'Du har støtta slettinga av sida.',
	'deletequeue-vote-success-object' => 'Du har gått imot slettinga av sida.',
	'deletequeue-vote-requeued' => 'Du har gått imot sletting av sida.
Grunna mostanden din har sida vorten flytta til køen $1.',
	'deletequeue-showvotes' => 'Støtta og motstand mot sletting av «$1»',
	'deletequeue-showvotes-text' => "Nedanfor er støtta og motstand mot slettinga av sida «'''$1'''».
Du kan [{{fullurl:{{FULLPAGENAME}}|action=delvote}} leggja inn di eiga støtta for eller motstand] mot slettinga.",
	'deletequeue-showvotes-restrict-endorse' => 'Syn berre støtta',
	'deletequeue-showvotes-restrict-object' => 'Syn berre motstand',
	'deletequeue-showvotes-restrict-none' => 'Syn all støtta og motstand',
	'deletequeue-showvotes-vote-endorse' => "'''Støtta''' sletting den $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Gjekk imot''' sletting den $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Syner berre støtta',
	'deletequeue-showvotes-showingonly-object' => 'Syner berre motstand',
	'deletequeue-showvotes-none' => 'Det finst korkje støtta eller motstand mot slettinga av denne sida.',
	'deletequeue-showvotes-none-endorse' => 'Det finst ikkje støtta for slettinga av denne sida.',
	'deletequeue-showvotes-none-object' => 'Det finst ikkje motstand mot slettinga av denne sida.',
	'deletequeue' => 'Slettekø',
	'deletequeue-list-text' => 'Denne sida syner alle sidene som er i slettesystemet.',
	'deletequeue-list-search-legend' => 'Søk etter sider',
	'deletequeue-list-queue' => 'Kø:',
	'deletequeue-list-status' => 'Stoda:',
	'deletequeue-list-expired' => 'Syn berre nominasjonar som krev stenging.',
	'deletequeue-list-search' => 'Søk',
	'deletequeue-list-anyqueue' => '(kva som helst)',
	'deletequeue-list-votes' => 'Lista over røyster',
	'deletequeue-list-votecount' => '{{PLURAL:$1|éi røyst for|$1 røyster for}}, {{PLURAL:$2|éi røyst mot|$2 røyster mot}}',
	'deletequeue-list-header-page' => 'Sida',
	'deletequeue-list-header-queue' => 'Kø',
	'deletequeue-list-header-votes' => 'Støtta og motstand',
	'deletequeue-list-header-expiry' => 'Går ut',
	'deletequeue-list-header-discusspage' => 'Diskusjonssida',
	'deletequeue-case-intro' => 'Denne sida listar opp informasjon for ei einskild slettesak.',
	'deletequeue-list-header-reason' => 'Grunngjeving for sletting',
	'deletequeue-case-votes' => 'Støtta/motstand:',
	'deletequeue-case-title' => 'Slettesakdetaljar',
	'deletequeue-case-details' => 'Grunnleggjande detaljar',
	'deletequeue-case-page' => 'Sida:',
	'deletequeue-case-reason' => 'Grunngjeving:',
	'deletequeue-case-expiry' => 'Går ut:',
	'deletequeue-case-needs-review' => 'Denne saka krev [[$1|vurdering]].',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'deletequeue-desc' => 'Skaper et [[Special:DeleteQueue|købasert system for å håndtere sletting]]',
	'deletequeue-action' => 'Foreslå sletting',
	'deletequeue-action-title' => 'Foreslå sletting av «$1»',
	'deletequeue-action-text' => "{{SITENAME}} har flere prosesser for sletting av sider:
* Om du mener at denne siden kvalifiserer for ''hurtigsletting'', kan du foreslå det [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=speedy}} her].
* Om siden ikke kvalifserer for hurtigsletting, men ''sletting likevel vil være ukontroversielt'', kan du [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=prod}} foreslå sletting her].
* Om det er sannsynlig at sletting av siden ''vil bli omdiskutert'', burde du [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=deletediscuss}} åpne en diskusjon].",
	'deletequeue-permissions-noedit' => 'Du må kunne redigere en side for å kunne påvirke dens slettingsstatus.',
	'deletequeue-generic-reasons' => '* Vanlige årsaker
  ** Hæverk
  ** Søppel
  ** Reklame
  ** Vedlikehold
  ** Ikke relevant for prosjektet',
	'deletequeue-speedy-title' => 'Merk «$1» for hurtigsletting',
	'deletequeue-speedy-text' => "Du kan bruke dette skjemaet for å merke siden «'''$1'''» for hurtigsletting.

En administrator vil se gjennom forespørselen, og om den er rimelig, slette siden.
Du må velge en årsak fra lista nedenfor, og legge til annen relevant informasjon.",
	'deletequeue-prod-title' => 'Foreslå sletting av «$1»',
	'deletequeue-prod-text' => "Du kan bruke dette skjemaet for å foreslå at «'''$1'''» slettes.

Om ingen har motsetninger mot slettingen innen fem dager, vil slettingen vurderes av en administrator.",
	'deletequeue-delnom-reason' => 'Nomneringsårsak:',
	'deletequeue-delnom-otherreason' => 'Annen grunn',
	'deletequeue-delnom-extra' => 'Ekstra informasjon:',
	'deletequeue-delnom-submit' => 'Nominer',
	'deletequeue-log-nominate' => 'nominerte [[$1]] for sletting i køen «$2».',
	'deletequeue-log-rmspeedy' => 'avviste hurtigsletting av [[$1]].',
	'deletequeue-log-requeue' => 'overførte [[$1]] fra slettingskøen «$2» til «$3».',
	'deletequeue-log-dequeue' => 'fjernet [[$1]] fra slettingskøen «$2».',
	'right-speedy-nominate' => 'Nominere sider til hurtigsletting',
	'right-speedy-review' => 'Behandle nominasjoner til hurtigsletting',
	'right-prod-nominate' => 'Foreslå sletting av sider',
	'right-prod-review' => 'Behandle ukontroversielle slettingsforslag',
	'right-deletediscuss-nominate' => 'Starte slettingsdiskusjoner',
	'right-deletediscuss-review' => 'Avslutte slettingsdiskusjoner',
	'deletequeue-queue-speedy' => 'Hurtigsletting',
	'deletequeue-queue-prod' => 'Slettingsforslag',
	'deletequeue-queue-deletediscuss' => 'Slettingsdiskusjon',
	'deletequeue-page-speedy' => "Denne siden har blitt nominert for hurtigsletting.
Årsaken som ble oppgitt var ''$1''.",
	'deletequeue-page-prod' => "Denne siden har blitt foreslått for sletting.
Årsaken som ble oppgitt var ''$1''.
Om dette forslaget ikke er motsagt innen ''$2'', vil siden bli slettet.
Du kan bestride sletting av siden ved å [{{fullurl:{{FULLPAGENAME}}|action=delvote}} motsi sletting].",
	'deletequeue-page-deletediscuss' => "Denne siden har blitt foreslått slettet, men forslaget har blitt bestridt.
Den oppgitte slettingsgrunnen var ''$1''.
En diskusjon foregår på [[$5]]; den vil slutte ''$2''.",
	'deletequeue-notqueued' => 'Siden du har valgt er ikke foreslått slettet',
	'deletequeue-review-action' => 'Handling:',
	'deletequeue-review-delete' => 'Slette siden.',
	'deletequeue-review-change' => 'Slette siden, men med annen begrunnelse.',
	'deletequeue-review-requeue' => 'Overføre siden til følgende kø:',
	'deletequeue-review-dequeue' => 'Ikke gjøre noe, og fjerne siden fra slettingskøen.',
	'deletequeue-review-reason' => 'Kommentarer:',
	'deletequeue-review-newreason' => 'Ny årsak:',
	'deletequeue-review-newextra' => 'Ekstra informasjon:',
	'deletequeue-review-submit' => 'Lagre gjennomgang',
	'deletequeue-review-original' => 'Nominasjonsårsak',
	'deletequeue-actiondisabled-involved' => 'Følgende handling kan ikke gjøres av deg, fordi du har tatt del i slettingen som $1:',
	'deletequeue-actiondisabled-notexpired' => 'Følgende handling kan ikke gjennomføres, fordi slettingsforslaget ikke har utgått:',
	'deletequeue-review-badaction' => 'Du oppga en ugyldig handling',
	'deletequeue-review-actiondenied' => 'Du oppga en handling som er slått av for denne siden',
	'deletequeue-review-objections' => "'''Advarsel''': Det er [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} motsigelser] til sletting av denne siden.
Forsikre deg om at du har tatt disse til hensyn før du sletter siden.",
	'deletequeue-reviewspeedy-tab' => 'Behandle hurtigsletting',
	'deletequeue-reviewspeedy-title' => 'Behandle hurtigsletting av «$1»',
	'deletequeue-reviewspeedy-text' => "Du kan bruke dette skjemaet for å vurdere hurtigsletting av «'''$1'''».
Forsikre deg om at siden kan hurtigslettes ifm. retningslinjene.",
	'deletequeue-reviewprod-tab' => 'Behandle slettingsforslag',
	'deletequeue-reviewprod-title' => 'Behandle slettingsforslag av «$1»',
	'deletequeue-reviewprod-text' => "Du kan bruke dette skjemaet for å behandle sletting av «'''$1'''».",
	'deletequeue-vote-reason' => 'Kommentarer:',
	'deletequeue' => 'Slettingskø',
	'deletequeue-list-search-legend' => 'Søk etter sider',
	'deletequeue-list-queue' => 'Kø:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Søk',
	'deletequeue-list-anyqueue' => '(noen)',
	'deletequeue-list-votes' => 'Liste over stemmer',
	'deletequeue-list-header-page' => 'Side',
	'deletequeue-list-header-queue' => 'Kø',
	'deletequeue-list-header-expiry' => 'Varighet',
	'deletequeue-list-header-discusspage' => 'Diskusjonsside',
);

/** Novial (Novial)
 * @author Malafaya
 */
$messages['nov'] = array(
	'deletequeue-case-reason' => 'Resone:',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Meno25
 */
$messages['oc'] = array(
	'deletequeue-desc' => 'Crea un [[Special:DeleteQueue|sistèma de coa per gerir las supressions]]',
	'deletequeue-action-queued' => 'Supression',
	'deletequeue-action' => 'Suggerís la supression',
	'deletequeue-action-title' => 'Suggerís la supression de « $1 »',
	'deletequeue-action-text' => "{{SITENAME}} dispausa d'un nombre de processús per la supression de las paginas :
*Se cresètz qu'aquesta pagina deu passar per una ''supression immediata'', ne podètz far la demanda [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} aicí].
*S'aquesta pagina relèva pas de la supression immediata, mas ''qu'aquesta supression pausarà pas cap de controvèrsa per'', vos caldrà [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} prepausar una supression pas contestabla].
*Se la supression de la pagina es ''subjècta a controvèrsas'', vos caldrà [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} dobrir una discussion].",
	'deletequeue-action-text-queued' => "Podètz visionar las paginas seguentas per aquesta supression :
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Veire las acòrdis e las objeccions].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Acceptar o objectar per la supression d'aquesta pagina].",
	'deletequeue-permissions-noedit' => 'Vos cal èsser capable de modificar una pagina per poder afectar son estatut de supression.',
	'deletequeue-generic-reasons' => '*Motius mai corrents
** Vandalisme
** Spam
** Mantenença
** Fòra de critèris',
	'deletequeue-nom-alreadyqueued' => 'Aquesta pagina ja es dins la coa de las supressions.',
	'deletequeue-speedy-title' => 'Marcar « $1 » per una supression immediata',
	'deletequeue-speedy-text' => "Podètz utilizar aqueste formulari per marcar la pagina « '''$1''' » per una supression immediata.

Un administrator estudiarà aquesta requèsta e, s'es fondada, suprimirà la pagina.
Vos cal seleccionar un motiu a partir de la lista desenrotlanta çaijós, e apondre d’autras entresenha aferentas.",
	'deletequeue-prod-title' => 'Prepausar la supression de « $1 »',
	'deletequeue-prod-text' => "Podètz utilizar aqueste formulari per prepausar que « '''$1''' » siá suprimida.

Se, aprèp cinc jorns, degun a pas emés d’objeccion per aquò, serà suprimida, aprèp un examèn final, per un administrator.",
	'deletequeue-delnom-reason' => 'Motiu per la nominacion :',
	'deletequeue-delnom-otherreason' => 'Autra rason',
	'deletequeue-delnom-extra' => 'Entresenhas suplementàrias :',
	'deletequeue-delnom-submit' => 'Sometre la nominacion',
	'deletequeue-log-nominate' => '[[$1]] nomenat per la supression dins la coa « $2 ».',
	'deletequeue-log-rmspeedy' => 'refusat per la supression immediata de [[$1]].',
	'deletequeue-log-requeue' => '[[$1]] transferit cap a una coa de supression diferenta : de « $2 » cap a « $3 ».',
	'deletequeue-log-dequeue' => '[[$1]] levat dempuèi la coa de supression « $2 ».',
	'right-speedy-nominate' => 'Nomena las paginas per una supression immediata.',
	'right-speedy-review' => 'Tornar veire las nominacions per la supression immediata',
	'right-prod-nominate' => 'Prepausar la supression de la pagina',
	'right-prod-review' => 'Tornar veire las proposicions de supression pas contestadas',
	'right-deletediscuss-nominate' => 'Començar las discussions sus la supression',
	'right-deletediscuss-review' => 'Clausurar las discussions sus la supression',
	'right-deletequeue-vote' => 'Consentir o objectar per las supressions',
	'deletequeue-queue-speedy' => 'Supression immediata',
	'deletequeue-queue-prod' => 'Supression prepausada',
	'deletequeue-queue-deletediscuss' => 'Discussion sus la supression',
	'deletequeue-page-speedy' => "Aquesta pagina es estada nomenada per una supression immediata.
La rason invocada per aquò es ''« $1 »''.",
	'deletequeue-page-prod' => "Es estat prepausada la supression d'aquesta pagina.
La rason invocada es ''« $1 »''.
Se la proposicion rencontra pas cap d'objeccion sus ''$2'', la pagina serà suprimida.
Podètz contestar aquesta supression en [{{fullurl:{{FULLPAGENAME}}|action=delvote}} vos i opausant].",
	'deletequeue-page-deletediscuss' => "Aquesta pagina es estada prepausada a la supression, aquesta es estada contestada.
Lo motiu invocat èra ''« $1 »''
Una discussion es intervenguda sus [[$5]], la quala serà concluida lo ''$2''.",
	'deletequeue-notqueued' => "La pagina qu'avètz seleccionada es pas dins la coa de las supressions",
	'deletequeue-review-action' => 'Accion de prene :',
	'deletequeue-review-delete' => 'Suprimir la pagina.',
	'deletequeue-review-change' => 'Suprimir aquesta pagina, mas amb una autra rason.',
	'deletequeue-review-requeue' => 'Transferir aquesta pagina cap a la coa seguenta :',
	'deletequeue-review-dequeue' => 'Far pas res e levar la pagina de la coa de supression.',
	'deletequeue-review-reason' => 'Comentaris :',
	'deletequeue-review-newreason' => 'Motiu novèl :',
	'deletequeue-review-newextra' => 'Entresenha suplementària :',
	'deletequeue-review-submit' => 'Salvar la relectura',
	'deletequeue-review-original' => 'Motiu de la nominacion',
	'deletequeue-actiondisabled-involved' => 'L’accion seguenta es desactivada perque avètz pres part a aqueste cas de supresion dins lo sens de $1 :',
	'deletequeue-actiondisabled-notexpired' => 'L’accion seguenta es estada desactivada perque lo relambi per la nominacion a la supression a pas encara expirat :',
	'deletequeue-review-badaction' => 'Avètz indicat una accion incorrècta',
	'deletequeue-review-actiondenied' => "Avètz indicat una accion qu'es desactivada per aquesta pagina.",
	'deletequeue-review-objections' => "'''Atencion''' : la supression d'aquesta pagina es [{{FULLURL:{{FULLPAGENAME}}|action=delvoteview|votetype=object}} contestada]. Asseguratz-vos qu'avètz examinat aquestas objeccions abans sa supression.",
	'deletequeue-reviewspeedy-tab' => 'Tornar veire la supression immediata',
	'deletequeue-reviewspeedy-title' => 'Tornar veire la supression immediata de « $1 »',
	'deletequeue-reviewspeedy-text' => "Podètz utilizar aqueste formular per tornar veire la nominacion de « '''$1''' » en supression immediata.
Asseguratz-vos qu'aquesta pagina pòt èsser suprimida atal en conformitat amb las règlas del projècte.",
	'deletequeue-reviewprod-tab' => 'Tornar veire las supressions prepausadas',
	'deletequeue-reviewprod-title' => 'Tornar veire la supression prepausada per « $1 »',
	'deletequeue-reviewprod-text' => "Podètz utilizar aqueste formulari per tornar veire la proposicion pas contestada per suprimir « '''$1''' ».",
	'deletequeue-reviewdeletediscuss-tab' => 'Tornar veire la supression',
	'deletequeue-reviewdeletediscuss-title' => 'Tornar veire la discussion de la supression per « $1 »',
	'deletequeue-reviewdeletediscuss-text' => "Podètz utilizar aqueste formulari per tornar veire la discussion concernent la supression de « ''$1''».

Una [{{FULLURL:{{FULLPAGENAME}}|action=delviewvotes}} lista] dels « per » e dels « contra » es disponibla, la discussion es ela-meteissa disponibla sus [[$2]].
Asseguratz-vos qu'avètz prés una decision en conformitat amb lo consensús eissit de la discussion.",
	'deletequeue-review-success' => "Avètz revist amb succès la supression d'aquesta pagina",
	'deletequeue-review-success-title' => 'Revision completa',
	'deletequeue-deletediscuss-discussionpage' => "Aquò es la pagina de discussion concernent la supression de [[$1]].
I a actualament $2 {{PLURAL:$2|utilizaire|utilizaires}} en favor, e $3 {{PLURAL:$3|utilizaire|utilizaires}} qu'i son opausats.
Podètz [{{FULLURL:$1|action=delvote}} sosténer o refusar] la supression, o [{{FULLURL:$1|action=delviewvotes}} veire totes los « per » e los « contra »].",
	'deletequeue-discusscreate-summary' => 'Creacion de la discussion concernent la supression de [[$1]].',
	'deletequeue-discusscreate-text' => 'Supression prepausada per la rason seguenta : $2',
	'deletequeue-role-nominator' => 'iniciaire original de la supression',
	'deletequeue-role-vote-endorse' => 'Partidari de la supression',
	'deletequeue-role-vote-object' => 'Opausant a la supression',
	'deletequeue-vote-tab' => 'Sosténer/Refusar la supression',
	'deletequeue-vote-title' => 'Sosténer o refusar la supression de « $1 »',
	'deletequeue-vote-text' => "Podètz utilizar aqueste formulari per apiejar o refusar la supression de « '''$1''' ».
Aquesta accion espotirà los vejaires qu'avètz emeses deperabans dins aquesta discussion.
Podètz [{{FULLURL:{{FULLPAGENAME}}|action=delviewvotes}} veire] los diferents vejaires ja emeses.
Lo motiu indicat per la nominacion a la supression èra ''« $2 »''.",
	'deletequeue-vote-legend' => 'Sosténer/Refusar la supression',
	'deletequeue-vote-action' => 'Recomandacion :',
	'deletequeue-vote-endorse' => 'Sosténer la supression.',
	'deletequeue-vote-object' => 'Refusar la supression.',
	'deletequeue-vote-reason' => 'Comentaris :',
	'deletequeue-vote-submit' => 'Sometre',
	'deletequeue-vote-success-endorse' => "Avètz sostengut, amb succès, la demanda de supression d'aquesta pagina.",
	'deletequeue-vote-success-object' => "Avètz refusat, amb succès, la demanda de supression d'aquesta pagina.",
	'deletequeue-vote-requeued' => "Avètz regetat, amb succès, la demanda de supression d'aquesta pagina.
Per vòstre refús, la pagina es estada desplaçada dins la coa $1.",
	'deletequeue-showvotes' => 'Acòrdis e refuses concernent la supression de « $1 »',
	'deletequeue-showvotes-text' => "Vaquí, çaijós, los acòrdis e los desacòrdis emeses en vista de la supression de la pagina « '''$1''' ».
Podètz enregistrar [{{FULLURL:{{FULLPAGENAME}}|action=delvote}} aicí] vòstra pròpri acòrdi o desacòrdi sus aquesta supression.",
	'deletequeue-showvotes-restrict-endorse' => 'Aficha unicament los partidaris',
	'deletequeue-showvotes-restrict-object' => 'Aficha unicament los opausants',
	'deletequeue-showvotes-restrict-none' => 'Aficha totes los partidaris e opausants',
	'deletequeue-showvotes-vote-endorse' => "'''Per''' la supression lo $2 a $1",
	'deletequeue-showvotes-vote-object' => "'''Contra''' la supression lo $2 a $1",
	'deletequeue-showvotes-showingonly-endorse' => 'Veire pas que los acòrdis',
	'deletequeue-showvotes-showingonly-object' => 'Veire pas que los desacòrdis',
	'deletequeue-showvotes-none' => "Existís pas ni « per », ni « contra » per la supression d'aquesta pagina.",
	'deletequeue-showvotes-none-endorse' => "Degun s’es pas prononciat en favor de la supression d'aquesta pagina.",
	'deletequeue-showvotes-none-object' => "Degun s’es pas prononciat contra la supression d'aquesta pagina.",
	'deletequeue' => 'Coa de la supression',
	'deletequeue-list-text' => 'Aquesta pagina aficha totas las paginas que son dins lo sistèma de supression.',
	'deletequeue-list-search-legend' => 'Recercar de paginas',
	'deletequeue-list-queue' => 'Coa :',
	'deletequeue-list-status' => 'Estatut :',
	'deletequeue-list-expired' => 'Veire pas que las clausuras de las nominacions requesas.',
	'deletequeue-list-search' => 'Recercar',
	'deletequeue-list-anyqueue' => "(mai d'un)",
	'deletequeue-list-votes' => 'Lista dels vòtes',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|acòrdi|acòrdis}}, $2 {{PLURAL:$2|refús|refuses}}',
	'deletequeue-list-header-page' => 'Pagina',
	'deletequeue-list-header-queue' => 'Coa',
	'deletequeue-list-header-votes' => 'Acòrdis e refuses',
	'deletequeue-list-header-expiry' => 'Expiracion',
	'deletequeue-list-header-discusspage' => 'Pagina de discussion',
	'deletequeue-case-intro' => "Aquesta pagina lista d'informacions sus un cas especific de supression.",
	'deletequeue-list-header-reason' => 'Motiu de la supression',
	'deletequeue-case-votes' => 'Per / contra :',
	'deletequeue-case-title' => 'Detalhs del cas de supression',
	'deletequeue-case-details' => 'Entresenhas de basa',
	'deletequeue-case-page' => 'Pagina :',
	'deletequeue-case-reason' => 'Motiu :',
	'deletequeue-case-expiry' => 'Expiracion :',
	'deletequeue-case-needs-review' => 'Aqueste cas requerís una [[$1|revista]].',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jose77
 */
$messages['or'] = array(
	'deletequeue-list-search' => 'ସନ୍ଧାନ',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'deletequeue-delnom-otherreason' => 'Æндæр аххостæ',
);

/** Polish (Polski)
 * @author Jwitos
 * @author Leinad
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'deletequeue-speedy-title' => 'Oznacz „$1” do ekspresowego skasowania',
	'right-speedy-nominate' => 'Oznacz strony do ekspresowego skasowania',
	'right-speedy-review' => 'Przejrzyj strony do ekspresowego skasowania',
	'deletequeue-review-delete' => 'Usuń stronę.',
	'deletequeue-vote-reason' => 'Komentarze:',
	'deletequeue-vote-submit' => 'Zapisz',
	'deletequeue-list-search-legend' => 'Szukaj stron',
	'deletequeue-list-queue' => 'Kolejka:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Szukaj',
	'deletequeue-list-header-page' => 'Strona',
	'deletequeue-list-header-queue' => 'Kolejka',
	'deletequeue-list-header-expiry' => 'Upływa',
	'deletequeue-list-header-discusspage' => 'Strona dyskusji',
	'deletequeue-case-details' => 'Podstawowe informacje',
	'deletequeue-case-page' => 'Strona',
	'deletequeue-case-reason' => 'Powód',
	'deletequeue-case-expiry' => 'Wygaśnięcie',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'deletequeue-list-status' => 'دريځ:',
	'deletequeue-list-header-expiry' => 'د پای نېټه',
);

/** Portuguese (Português)
 * @author Heldergeovane
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'deletequeue-desc' => 'Cria um [[Special:DeleteQueue|sistema baseado em fila para gerir eliminações]]',
	'deletequeue-action-queued' => 'Eliminação',
	'deletequeue-action' => 'Sugerir eliminação',
	'deletequeue-action-title' => 'Sugerir eliminação de "$1"',
	'deletequeue-action-text' => "{{SITENAME}} tem um número de processos para eliminar páginas:
*Se crê que esta página aconselha a uma ''eliminação rápida'', poderá sugeri-la [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} aqui].
*Se esta página não aconselha a uma eliminação rápida, mas ''a eliminação provavelmente será incontroversa'', deverá [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} propôr uma eliminação incontestada].
*Se a eliminação desta página será ''provavelmente contestada'', deverá [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} iniciar uma discussão].",
	'deletequeue-action-text-queued' => 'Você pode ver as seguintes páginas para este caso de eliminação:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Ver suportes e objeções atuais].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Suportar ou objetar à eliminação desta página].',
	'deletequeue-permissions-noedit' => 'Você deverá estar habilitado a editar uma página para poder afetar o seu estado de eliminação.',
	'deletequeue-generic-reasons' => '* Motivos genéricos
  ** Vandalismo
  ** Spam
  ** Manutenção
  ** Fora do âmbito do projeto',
	'deletequeue-nom-alreadyqueued' => 'Esta página já se encontra numa fila de eliminação.',
	'deletequeue-speedy-title' => 'Marcar "$1" para eliminação rápida',
	'deletequeue-speedy-text' => "Você pode usar este formulário para marcar a página \"'''\$1'''\" para eliminação rápida.

Um administrador irá rever este pedido e, se for bem fundamentado, eliminar a página.
Deverá selecionar um motivo de eliminação da lista de opções abaixo, e adicionar qualquer outra informação relevante.",
	'deletequeue-prod-title' => 'Propor eliminação de "$1"',
	'deletequeue-prod-text' => "Você pode usar este formulário para propor que \"'''\$1'''\" seja apagada.

Se, após cinco dias, ninguém tiver contestado a eliminação desta página, ela será eliminada após revisão final por um administrador.",
	'deletequeue-delnom-reason' => 'Motivo da nomeação:',
	'deletequeue-delnom-otherreason' => 'Outro motivo',
	'deletequeue-delnom-extra' => 'Informação extra:',
	'deletequeue-delnom-submit' => 'Submeter nomeação',
	'deletequeue-log-nominate' => "nomeou [[$1]] para eliminação na fila '$2'.",
	'deletequeue-log-rmspeedy' => 'declinou a eliminação rápida de [[$1]].',
	'deletequeue-log-requeue' => "transferiu [[$1]] para uma fila de eliminação diferente: de '$2' para '$3'.",
	'deletequeue-log-dequeue' => "removeu [[$1]] da fila de eliminação '$2'.",
	'right-speedy-nominate' => 'Nomear páginas para eliminação rápida',
	'right-speedy-review' => 'Rever nomeações para eliminação rápida',
	'right-prod-nominate' => 'Propor eliminação de página',
	'right-prod-review' => 'Rever propostas de eliminação incontestadas',
	'right-deletediscuss-nominate' => 'Iniciar discussões de eliminação',
	'right-deletediscuss-review' => 'Encerrar discussões de eliminação',
	'right-deletequeue-vote' => 'Aprovar ou contestar eliminações',
	'deletequeue-queue-speedy' => 'Eliminação rápida',
	'deletequeue-queue-prod' => 'Propor eliminação',
	'deletequeue-queue-deletediscuss' => 'Discussão da eliminação',
	'deletequeue-page-speedy' => "Esta página foi nomeada para eliminação rápida.
O motivo dado para esta eliminação foi ''$1''.",
	'deletequeue-page-prod' => "Foi proposta a eliminação desta página.
O motivo dado foi ''$1''.
Se esta proposta não for contestada em ''$2'', esta página será eliminada.
Você pode contestar a eliminação desta página [{{fullurl:{{FULLPAGENAME}}|action=delvote}} objetando à eliminação].",
	'deletequeue-page-deletediscuss' => "Esta página foi proposta para eliminação, e essa proposta foi contestada.
O motivo dado foi ''$1''.
Uma discussão encontra-se em curso em [[$5]], e que será concluída em ''$2''.",
	'deletequeue-notqueued' => 'A página que selecionou não está atualmente em nenhum fila para eliminação',
	'deletequeue-review-action' => 'Acção a tomar:',
	'deletequeue-review-delete' => 'Eliminar a página.',
	'deletequeue-review-change' => 'Eliminar esta página, mas com uma justificação diferente.',
	'deletequeue-review-requeue' => 'Transferir esta página para a seguinte fila:',
	'deletequeue-review-dequeue' => 'Não tomar nenhuma ação, e remover a página da fila de eliminação.',
	'deletequeue-review-reason' => 'Comentários:',
	'deletequeue-review-newreason' => 'Novo motivo:',
	'deletequeue-review-newextra' => 'Informação extra:',
	'deletequeue-review-submit' => 'Gravar Revisão',
	'deletequeue-review-original' => 'Motivo da nomeação',
	'deletequeue-actiondisabled-involved' => 'A seguinte ação está desativada porque você tomou parte neste caso de eliminação nos papéis $1:',
	'deletequeue-actiondisabled-notexpired' => 'A seguinte ação está desativada porque a nomeação para eliminação ainda não expirou:',
	'deletequeue-review-badaction' => 'Você especificou uma ação inválida',
	'deletequeue-review-actiondenied' => 'Você especificou uma ação que está desativada para esta página',
	'deletequeue-review-objections' => "'''Aviso''': A eliminação desta página tem [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} objeções].
Por favor, assegure-se de que considerou estas objeções antes de eliminar esta página.",
	'deletequeue-reviewspeedy-tab' => 'Rever eliminação rápida',
	'deletequeue-reviewspeedy-title' => 'Rever a nomeação para eliminação rápida de "$1"',
	'deletequeue-reviewspeedy-text' => "Você pode usar este formulário para rever a nomeação de \"'''\$1'''\" para eliminação rápida.
Por favor, assegure-se de que esta página pode ser eliminada rapidamente de acordo com a política.",
	'deletequeue-reviewprod-tab' => 'Rever eliminação proposta',
	'deletequeue-reviewprod-title' => 'Rever eliminação proposta de "$1"',
	'deletequeue-reviewprod-text' => "Você pode usar este formulário para rever a proposta incontestada de eliminação de \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Rever eliminação',
	'deletequeue-reviewdeletediscuss-title' => 'Rever discussão de eliminação de "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Você pode usar este formulário para rever a discussão de eliminação de \"'''\$1'''\".

Está disponível uma [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] de suportes e objeções desta eliminação, e a discussão pode ser encontrada em [[\$2]].
Por favor, assegure-se de que toma uma decisão de acordo com o consenso patente na discussão.",
	'deletequeue-review-success' => 'Você analisou com sucesso a eliminação desta página',
	'deletequeue-review-success-title' => 'Revisão completa',
	'deletequeue-deletediscuss-discussionpage' => 'Esta é a página de discussão para a eliminação de [[$1]].
Há atualmente $2 {{PLURAL:$2|utilizador|utilizadores}} a suportar a eliminação, e $3 {{PLURAL:$3|utilizador|utilizadores}} a objetar à eliminação.
Você pode [{{fullurl:$1|action=delvote}} suportar ou objetar] à eliminação, ou [{{fullurl:$1|action=delviewvotes}} ver todos os suportes e objeções].',
	'deletequeue-discusscreate-summary' => 'A criar discussão para a eliminação de [[$1]].',
	'deletequeue-discusscreate-text' => 'Eliminação proposta pelo seguinte motivo: $2',
	'deletequeue-role-nominator' => 'nomeador original da eliminação',
	'deletequeue-role-vote-endorse' => 'suportador da eliminação',
	'deletequeue-role-vote-object' => 'objetor à eliminação',
	'deletequeue-vote-tab' => 'Votar na eliminação',
	'deletequeue-vote-title' => 'Suportar ou objetar à eliminação de "$1"',
	'deletequeue-vote-text' => "Você pode usar este formulário para suportar ou objetar à eliminação de \"'''\$1'''\".
Esta ação sobrepor-se-á a quaisquer suportes/objeções que tenha prestado à eliminação desta página.
Você pode [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ver] os suportes e objeções existentes.
O motivo dado na nomeação para eliminação foi ''\$2''.",
	'deletequeue-vote-legend' => 'Suportar/Objetar à eliminação',
	'deletequeue-vote-action' => 'Recomendação:',
	'deletequeue-vote-endorse' => 'Aprovar eliminação.',
	'deletequeue-vote-object' => 'Contestar a eliminação.',
	'deletequeue-vote-reason' => 'Comentários:',
	'deletequeue-vote-submit' => 'Submeter',
	'deletequeue-vote-success-endorse' => 'Você suportou com sucesso a eliminação desta página.',
	'deletequeue-vote-success-object' => 'Você objetou com sucesso à eliminação desta página.',
	'deletequeue-vote-requeued' => 'Você suportou com sucesso a eliminação desta página.
Devido à sua objeção, a página foi movida para a fila $1.',
	'deletequeue-showvotes' => 'Suportes e objeções à eliminação de "$1"',
	'deletequeue-showvotes-text' => "Abaixo estão os suportes e objeções feitas à eliminação da página  \"'''\$1'''\".
Você pode [{{fullurl:{{FULLPAGENAME}}|action=delvote}} registar o seu próprio suporte ou objeção] a esta eliminação.",
	'deletequeue-showvotes-restrict-endorse' => 'Mostrar apenas aprovações',
	'deletequeue-showvotes-restrict-object' => 'Mostrar apenas contestações',
	'deletequeue-showvotes-restrict-none' => 'Mostrar todos os suportes e objeções',
	'deletequeue-showvotes-vote-endorse' => "'''Suportou''' a eliminação em $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Objetou''' à eliminação em $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Mostrando apenas aprovações',
	'deletequeue-showvotes-showingonly-object' => 'Mostrando apenas contestações',
	'deletequeue-showvotes-none' => 'Não há suportes ou objeções à eliminação desta página.',
	'deletequeue-showvotes-none-endorse' => 'Não há suportes à eliminação desta página.',
	'deletequeue-showvotes-none-object' => 'Não há objeções à eliminação desta página.',
	'deletequeue' => 'Fila de eliminações',
	'deletequeue-list-text' => 'Esta página mostra todas as páginas que estão no sistema de exclusão.',
	'deletequeue-list-search-legend' => 'Pesquisar páginas',
	'deletequeue-list-queue' => 'Fila:',
	'deletequeue-list-status' => 'Estado:',
	'deletequeue-list-expired' => 'Mostrar apenas nomeações que necessitam de fecho.',
	'deletequeue-list-search' => 'Pesquisar',
	'deletequeue-list-anyqueue' => '(qualquer)',
	'deletequeue-list-votes' => 'Lista de votos',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|suporte|suportes}}, $2 {{PLURAL:$2|objeção|objeções}}',
	'deletequeue-list-header-page' => 'Página',
	'deletequeue-list-header-queue' => 'Fila',
	'deletequeue-list-header-votes' => 'Suportes e objeções',
	'deletequeue-list-header-expiry' => 'Validade',
	'deletequeue-list-header-discusspage' => 'Página de discussão',
	'deletequeue-case-intro' => 'Esta página lista informação sobre um caso de eliminação específico.',
	'deletequeue-list-header-reason' => 'Motivo de eliminação',
	'deletequeue-case-votes' => 'Suportes/objeções:',
	'deletequeue-case-title' => 'Detalhes do caso de eliminação',
	'deletequeue-case-details' => 'Detalhes básicos',
	'deletequeue-case-page' => 'Página:',
	'deletequeue-case-reason' => 'Motivo:',
	'deletequeue-case-expiry' => 'Validade:',
	'deletequeue-case-needs-review' => 'Este caso requer [[$1|revisão]].',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'deletequeue-desc' => 'Cria um [[Special:DeleteQueue|sistema baseado em fila para gerenciar eliminações]]',
	'deletequeue-action-queued' => 'Eliminação',
	'deletequeue-action' => 'Sugerir eliminação',
	'deletequeue-action-title' => 'Sugerir eliminação de "$1"',
	'deletequeue-action-text' => "{{SITENAME}} tem vários procedimentos para eliminação de páginas:
*Se você acredita que esta página se enquadra como ''eliminação rápida'', você pode sugerir isto [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} aqui].
*Se esta página não se enquadra como eliminação rápida, mas ''sua exclusão não gerará controvérsias'', você deve [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} propor eliminação incontestada].
*Se a eliminação desta página ''pode ser contestada'', você deve [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} abrir uma discussão].",
	'deletequeue-action-text-queued' => 'Você pode ver as seguintes páginas sobre este caso de eliminação:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Ver suportes e objeções e atuais ].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Suporte ou conteste a eliminação desta página].',
	'deletequeue-permissions-noedit' => 'Você precisa ser capaz de editar uma página para poder alterar o status desta eliminação.',
	'deletequeue-generic-reasons' => '* Motivos genéricos
  ** Vandalismo
  ** Spam
  ** Manutenção
  ** Fora do escopo do projeto',
	'deletequeue-nom-alreadyqueued' => 'Esta página já está entre as tarefas de eliminação.',
	'deletequeue-speedy-title' => 'Marcar "$1" para eliminação rápida',
	'deletequeue-speedy-text' => "Você pode usar este formulário para marcar a página \"'''\$1'''\" para eliminação rápida.

Um administrador irá rever seu pedido, e, se ele estiver bem fundamentado, eliminará a página.
Você deve selecionar um motivo para a eliminação na caixa de seleção abaixo, e incluir quaisquer outras informações relevantes.",
	'deletequeue-speedy-reasons' => '-',
	'deletequeue-prod-title' => 'Propor eliminação de "$1"',
	'deletequeue-prod-text' => "Você pode usar este formulário para propor que \"'''\$1'''\" seja eliminada.

Se, depois de cinco dias, ninguém contestar esta eliminação, ela será eliminada depois de uma última revisão do pedido por um administrador.",
	'deletequeue-prod-reasons' => '-',
	'deletequeue-delnom-reason' => 'Motivo para a proposta:',
	'deletequeue-delnom-otherreason' => 'Outro motivo',
	'deletequeue-delnom-extra' => 'Informação adicional:',
	'deletequeue-delnom-submit' => 'Submeter proposta',
	'deletequeue-log-nominate' => "proposta a eliminação de [[$1]] na fila '$2'.",
	'deletequeue-log-rmspeedy' => 'rejeitada a eliminação rápida de [[$1]].',
	'deletequeue-log-requeue' => "transferido [[$1]] para uma fila de eliminação diferente: de '$2' para '$3'.",
	'deletequeue-log-dequeue' => "removido [[$1]] da fila de eliminações '$2'.",
	'right-speedy-nominate' => 'Propor páginas para eliminação rápida',
	'right-speedy-review' => 'Rever propostas de eliminação rápida',
	'right-prod-nominate' => 'Propor eliminação de páginas',
	'right-prod-review' => 'Rever propostas de eliminação não contestadas',
	'right-deletediscuss-nominate' => 'Iniciar discussões sobre eliminação',
	'right-deletediscuss-review' => 'Encerrar discussões sobre eliminação',
	'right-deletequeue-vote' => 'Apoiar ou fazer objeção à eliminações',
	'deletequeue-queue-speedy' => 'Eliminação rápida',
	'deletequeue-queue-prod' => 'Eliminação proposta',
	'deletequeue-queue-deletediscuss' => 'Discussão sobre eliminação',
	'deletequeue-page-speedy' => "Esta página foi proposta para eliminação rápida.
O motivo dado para esta eliminação é ''$1''.",
	'deletequeue-page-prod' => "Foi proposto que esta página seja eliminada.
A razão dada foi ''$1''.
Se esta proposta não for contestada até ''$2'', esta página será eliminada.
Você pode contestar a eliminação desta página [{{fullurl:{{FULLPAGENAME}}|action=delvote}} objetando a eliminação].",
	'deletequeue-page-deletediscuss' => "Esta página foi proposta para eliminação, e a proposta foi contestada.
A razão dada foi ''$1''.
Uma discussão está acontecendo em [[$5]], e será encerrada em ''$2''.",
	'deletequeue-notqueued' => 'A página que você selecionou não está na fila de eliminação no momento',
	'deletequeue-review-action' => 'Ação a tomar:',
	'deletequeue-review-delete' => 'Eliminar a página.',
	'deletequeue-review-change' => 'Eliminar esta página, mas por uma razão diferente.',
	'deletequeue-review-requeue' => 'Transferir esta página para a seguinte fila:',
	'deletequeue-review-dequeue' => 'Nenhuma. Apenas remover a página da fila de eliminação.',
	'deletequeue-review-reason' => 'Comentários:',
	'deletequeue-review-newreason' => 'Novo motivo:',
	'deletequeue-review-newextra' => 'Informação adicional:',
	'deletequeue-review-submit' => 'Salvar revisão',
	'deletequeue-review-original' => 'Motivo para a proposta',
	'deletequeue-actiondisabled-involved' => 'A seguinte ação está desabilitada porque você não tomou parte nesta eliminação nos papeis $1:',
	'deletequeue-actiondisabled-notexpired' => 'A seguinte ação está desabilitada porque a proposta de eliminação não expirou ainda:',
	'deletequeue-review-badaction' => 'Você especificou uma ação inválida',
	'deletequeue-review-actiondenied' => 'Você especificou uma ação que está desabilitada para esta página',
	'deletequeue-review-objections' => "'''Aviso''': A eliminação desta página tem [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} objeções].
Por favor, certifique-se de que as objeções foram levadas em conta antes de eliminar esta página.",
	'deletequeue-reviewspeedy-tab' => 'Rever eliminação rápida',
	'deletequeue-reviewspeedy-title' => 'Rever proposta de eliminação rápida de "$1"',
	'deletequeue-reviewspeedy-text' => "Você pode usar este formulário para rever a proposta eliminação rápida de \"'''\$1'''\".
Por favor, certifique-se de que as políticas permitem que seja feita a eliminação rápida desta página.",
	'deletequeue-reviewprod-tab' => 'Rever eliminação proposta',
	'deletequeue-reviewprod-title' => 'Rever proposta de eliminação de "$1"',
	'deletequeue-reviewprod-text' => "Você pode usar este formulário para rever a proposta não contestada de eliminação de \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Rever eliminação',
	'deletequeue-reviewdeletediscuss-title' => 'Rever discussão sobre a eliminação de "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Você pode usar este formulário para rever a discussão sobre a eliminação de \"'''\$1'''\".

Uma [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] de apoios e objeções a esta eliminação está disponível, e a discussão propriamente dita pode ser encontrada em [[\$2]].
Por favor, certifique-se de ter tomado uma decisão de acordo com o consenso presente na discussão.",
	'deletequeue-review-success' => 'Você analisou com sucesso a eliminação desta página',
	'deletequeue-review-success-title' => 'Revisão completa',
	'deletequeue-deletediscuss-discussionpage' => 'Esta é a página de discussão para a eliminação de [[$1]].
No momento há $2 {{PLURAL:$2|usuário|usuários}} que apóiam a eliminação, e $3 {{PLURAL:$3|usuário|usuários}} que se opõe a mesma.
Você pode [{{fullurl:$1|action=delvote}} apoiar ou se opor] a eliminação, ou [{{fullurl:$1|action=delviewvotes}} ver todas as opiniões contra e a favor].',
	'deletequeue-discusscreate-summary' => 'Criando discussão sobre a eliminação de [[$1]].',
	'deletequeue-discusscreate-text' => 'Eliminação proposta pelo seguinte motivo: $2',
	'deletequeue-role-nominator' => 'Responsável pela proposta original da eliminação',
	'deletequeue-role-vote-endorse' => 'apóia a eliminação',
	'deletequeue-role-vote-object' => 'não concorda com a eliminação',
	'deletequeue-vote-tab' => 'Vote sobre a eliminação',
	'deletequeue-vote-title' => 'Apóie ou objete a eliminação de "$1"',
	'deletequeue-vote-text' => "Você pode usar este formulário para apoiar ou objetar a eliminação de \"'''\$1'''\".
Esta ação irá sobrescrever quaisquer apoio ou objeção feitos por você sobre a eliminação desta página.
Você pode [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ver] o apoio e as objeções atuais.
A razão dada ao propor a eliminação foi ''\$2''.",
	'deletequeue-vote-legend' => 'Apoie/objete a eliminação',
	'deletequeue-vote-action' => 'Recomendação:',
	'deletequeue-vote-endorse' => 'Apóia a eliminação',
	'deletequeue-vote-object' => 'Objeta a eliminação',
	'deletequeue-vote-reason' => 'Comentários:',
	'deletequeue-vote-submit' => 'Submeter',
	'deletequeue-vote-success-endorse' => 'O seu apoio a esta eliminação foi registrado com sucesso.',
	'deletequeue-vote-success-object' => 'A sua objeção a esta eliminação foi registrada com sucesso.',
	'deletequeue-vote-requeued' => 'A sua objeção a eliminação desta página foi registrada com sucesso.
Devido a sua objeção, a página foi movida para a fila $1.',
	'deletequeue-showvotes' => 'Apoio e objeções a eliminação de "$1"',
	'deletequeue-showvotes-text' => "Abaixo está o apoio e as objeções feitas sobre a eliminação da página \"'''\$1'''\".
Você pode registrar que também apóia, ou oferecer objeção a essa eliminação [{{fullurl:{{FULLPAGENAME}}|action=delvote}} aqui].",
	'deletequeue-showvotes-restrict-endorse' => 'Mostrar apenas favoráveis',
	'deletequeue-showvotes-restrict-object' => 'Mostrar apenas objeções',
	'deletequeue-showvotes-restrict-none' => 'Mostrar apoio e objeções',
	'deletequeue-showvotes-vote-endorse' => "'''Apoiou''' a eliminação em $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Objetou''' a eliminação em $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Mostrando apenas o apoio',
	'deletequeue-showvotes-showingonly-object' => 'Mostrando apenas as objeções',
	'deletequeue-showvotes-none' => 'Não há apoio nem objeção contra a eliminação desta página.',
	'deletequeue-showvotes-none-endorse' => 'Não há apoio para a eliminação desta página.',
	'deletequeue-showvotes-none-object' => 'Não há objeções contra a eliminação desta página.',
	'deletequeue' => 'Fila de eliminação',
	'deletequeue-list-text' => 'Esta página mostra todas as páginas que estão no sistema de eliminação.',
	'deletequeue-list-search-legend' => 'Buscar páginas',
	'deletequeue-list-queue' => 'Fila:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Mostrar apenas propostas exigindo fechamento.',
	'deletequeue-list-search' => 'Buscar',
	'deletequeue-list-anyqueue' => '(qualquer)',
	'deletequeue-list-votes' => 'Lista de votos',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|favorável|favoráveis}}, $2 {{PLURAL:$2|objeção|objeções}}',
	'deletequeue-list-header-page' => 'Página',
	'deletequeue-list-header-queue' => 'Fila',
	'deletequeue-list-header-votes' => 'Apoio e objeções',
	'deletequeue-list-header-expiry' => 'Expira',
	'deletequeue-list-header-discusspage' => 'Página de discussão',
	'deletequeue-case-intro' => 'Esta página lista informações sobre um caso de eliminação específico.',
	'deletequeue-list-header-reason' => 'Motivo da eliminação',
	'deletequeue-case-votes' => 'Suportes/objeções:',
	'deletequeue-case-title' => 'Detalhes do caso de eliminação',
	'deletequeue-case-details' => 'Detalhes básicos',
	'deletequeue-case-page' => 'Página:',
	'deletequeue-case-reason' => 'Motivo:',
	'deletequeue-case-expiry' => 'Validade:',
	'deletequeue-case-needs-review' => 'Este caso requer [[$1|revisão]].',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'deletequeue-delnom-reason' => 'Motiv pentru nominalizare:',
	'deletequeue-delnom-otherreason' => 'Alt motiv',
	'deletequeue-queue-speedy' => 'Ştergere rapidă',
	'deletequeue-review-reason' => 'Comentarii:',
	'deletequeue-review-newreason' => 'Motiv nou:',
	'deletequeue-review-original' => 'Motiv pentru nominalizare',
	'deletequeue-vote-action' => 'Recomandare:',
	'deletequeue-vote-reason' => 'Comentarii:',
	'deletequeue-list-header-page' => 'Pagină',
	'deletequeue-list-header-discusspage' => 'Pagină de discuţii',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'deletequeue-review-action' => 'Azione da pigghijà:',
	'deletequeue-list-queue' => 'Code:',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'deletequeue-action-queued' => 'Удаление',
	'deletequeue-action' => 'Предложить удаление',
	'deletequeue-action-title' => 'Предложить удаление "$1"',
	'deletequeue-generic-reasons' => '* Типовые причины
  ** Вандализм
  ** Спам
  ** Поддержка
  ** Вне сферы проекта',
	'deletequeue-nom-alreadyqueued' => 'Эта страница уже находится в очереди удаления.',
	'deletequeue-speedy-title' => 'Отметить "$1" к быстрому удалению',
	'deletequeue-speedy-text' => "Вы можете использовать эту форму для пометки страницы «'''$1'''» к быстрому удалению.

Администратор рассмотрит этот запрос и, если он обоснован, удалит эту страницу.
Вам следует выбрать причину удаления из выпадающего списка, добавить любую другую существенную информацию.",
	'deletequeue-prod-title' => 'Предложить удаление «$1»',
	'deletequeue-delnom-reason' => 'Причина номинации:',
	'deletequeue-delnom-otherreason' => 'Другие причины',
	'deletequeue-delnom-extra' => 'Дополнительная информация:',
	'deletequeue-delnom-submit' => 'Подтвердить номинацию',
	'deletequeue-log-nominate' => "номинирована [[$1]] для удаления в очереди '$2'.",
	'deletequeue-log-dequeue' => "удалено [[$1]] из очереди удаления '$2'.",
	'right-speedy-nominate' => 'Номинация страниц к быстрому удалению',
	'right-prod-nominate' => 'Предложение страниц к удалению',
	'right-prod-review' => 'Просмотр неоспоренных предложений к удалению',
	'right-deletediscuss-nominate' => 'Начать обсуждение удаления',
	'right-deletediscuss-review' => 'Закрыть обсуждение удаления',
	'right-deletequeue-vote' => 'Одобрение или отклонение удаления',
	'deletequeue-queue-speedy' => 'Быстрое удаление',
	'deletequeue-queue-prod' => 'Предлагаемые удаления',
	'deletequeue-queue-deletediscuss' => 'Обсуждение удаления',
	'deletequeue-page-speedy' => "Эта страница была номинирована на быстрое удаление.
Причина для этого удаления - ''$1''.",
	'deletequeue-review-delete' => 'Удалить страницу.',
	'deletequeue-review-change' => 'Удалить эту страницу, но по другой причине.',
	'deletequeue-review-requeue' => 'Переместить эту страницу в следующую очередь:',
	'deletequeue-review-reason' => 'Комментарии:',
	'deletequeue-review-newreason' => 'Новая причина:',
	'deletequeue-review-newextra' => 'Дополнительные сведения:',
	'deletequeue-review-original' => 'Причина номинации',
	'deletequeue-review-badaction' => 'Вы указали неправильное действие',
	'deletequeue-reviewprod-tab' => 'Просмотр предлагаемых удалений',
	'deletequeue-reviewprod-title' => 'Просмотр предлагаемого удаления «$1»',
	'deletequeue-discusscreate-summary' => 'Создание обсуждения удаления [[$1]].',
	'deletequeue-discusscreate-text' => 'Удаление предлагается по следующей причине: $2',
	'deletequeue-role-nominator' => 'оригинальный номинатор к удалению',
	'deletequeue-vote-legend' => 'Одобрение/Отказ удаления',
	'deletequeue-vote-action' => 'Рекомендация:',
	'deletequeue-vote-endorse' => 'Одобрить удаление.',
	'deletequeue-vote-object' => 'Отказать в удалении.',
	'deletequeue-vote-reason' => 'Комментарии:',
	'deletequeue-vote-submit' => 'Отправить',
	'deletequeue' => 'Очередь удаления',
	'deletequeue-list-search-legend' => 'Поиск по страницам',
	'deletequeue-list-queue' => 'Очередь:',
	'deletequeue-list-status' => 'Статус:',
	'deletequeue-list-search' => 'Поиск',
	'deletequeue-list-votes' => 'Список голосований',
	'deletequeue-list-header-page' => 'Страница',
	'deletequeue-list-header-queue' => 'Очередь',
	'deletequeue-list-header-expiry' => 'Истёкшие',
	'deletequeue-list-header-discusspage' => 'Страница обсуждения',
);

/** Serbo-Croatian (Srpskohrvatski / Српскохрватски)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'deletequeue-delnom-otherreason' => 'Ostali razlog/zi',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'deletequeue-desc' => 'Vytvára systém [[Special:DeleteQueue|frontu na správu mazaní]]',
	'deletequeue-action-queued' => 'Zmazanie',
	'deletequeue-action' => 'Navrhnúť zmazanie',
	'deletequeue-action-title' => 'Navrhnúť zmazanie „$1”',
	'deletequeue-action-text' => "{{SITENAME}} má niekoľko procesov mazania stránok:
* Ak sa domnievate, že táto stránka je kandidátom na ''rýchle zmazanie'', môžete ho [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} navrhnúť].
*Ak táto stránka nie je kandidátom na rýchle zmazanie, ale ''zmazanie bude pravdepodobne nekontroverzné'', mali by ste [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} navrhnúť jej zmazanie].
*Ak bude zmazanie tejto stránky ''pravdepodobne kontroverzné'', mali by ste o tom [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} začať diskusiu].",
	'deletequeue-action-text-queued' => 'Nasledovné stránky obsahujú informácie týkajúce sa tohto prípadu na zmazanie:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Zobraziť aktuálne odporúčania a námietky].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Odporučiť alebo namietnuť proti zmazaniu tejto strány].',
	'deletequeue-permissions-noedit' => 'Aby ste mohli ovplyvniť stav zmazania stránky, musíte mať oprávnenie upravovať stránku.',
	'deletequeue-generic-reasons' => '* Všeobecné dôvody
  ** Vandalizmus
  ** Spam
  ** Údržba
  ** Mimo rozsahu projektu',
	'deletequeue-nom-alreadyqueued' => 'Táto stránka sa už nachádza vo fronte na správu mazaní.',
	'deletequeue-speedy-title' => 'Označiť „$1” na rýchle zmazanie',
	'deletequeue-speedy-text' => "Tento formulár slúži na označenie stránky „'''$1'''” na rýchle zmazanie.

Správca túto požiadavku preverí a aj je podložená, stránku zmaže.
Musíte uviesť dôvod zmazania z dolu uvedeného zoznamu a poskytnúť ďalšie relevantné informácie.",
	'deletequeue-speedy-reasons' => '-',
	'deletequeue-prod-title' => 'Navrhnúť zmazanie „$1”',
	'deletequeue-prod-text' => 'Pomocou tohto formulára môžete navrhnúť zmazanie stránky „$1”.

Ak po piatich dňoch nikto nenapadne návrh na zmazanie tejto stránky, zmaže ju po konečnej kontrole správca.',
	'deletequeue-prod-reasons' => '-',
	'deletequeue-delnom-reason' => 'Dôvod návrhu:',
	'deletequeue-delnom-otherreason' => 'Iný dôvod',
	'deletequeue-delnom-extra' => 'Ďalšie informácie:',
	'deletequeue-delnom-submit' => 'Odoslať návrh',
	'deletequeue-log-nominate' => 'navrhol na zmazanie [[$1]]  vo fronte „$2”.',
	'deletequeue-log-rmspeedy' => 'zamietol rýchle zmazanie [[$1]].',
	'deletequeue-log-requeue' => 'preniesol [[$1]] do iného frontu mazaní: z „$2” do „$3”.',
	'deletequeue-log-dequeue' => 'odstránil [[$1]] z frontu mazaní „$2”.',
	'right-speedy-nominate' => 'Navrhnúť stránky na rýchle zmazanie',
	'right-speedy-review' => 'Skontrolovať návrhy na rýchle zmazanie',
	'right-prod-nominate' => 'Navrhnúť zmazanie stránky',
	'right-prod-review' => 'Skontrolovať návrhy na zmazanie bez komentárov proti',
	'right-deletediscuss-nominate' => 'Začať diskusiu o zmazaní',
	'right-deletediscuss-review' => 'Uzavrieť diskusiu o zmazaní',
	'right-deletequeue-vote' => 'Odporučiť alebo namietnuť proti zmazaniu',
	'deletequeue-queue-speedy' => 'Rýchle zmazanie',
	'deletequeue-queue-prod' => 'Navrhované zmazanie',
	'deletequeue-queue-deletediscuss' => 'Diskusia o zmazaní',
	'deletequeue-page-speedy' => "Táto stránka bola navrhnutá na rýchle zmazanie.
Ako dôvod návrhu bolo uvedené ''$1''.",
	'deletequeue-page-prod' => "Bolo navrhnuté zmazanie tejto stránky.
Ako dôvod návrhu bolo uvedené ''$1''.
Ak nebude tento návrh napadnutý ''$2'', táto stránka bude zmazaná.
Návrh môžete napadnúť [{{fullurl:{{FULLPAGENAME}}|action=delvote}} námietkou proti zmazaniu].",
	'deletequeue-page-deletediscuss' => "Bolo navrhnuté zmazanie tejto stránky a tento návrh bol napadnutý.
Ako dôvod bolo uvedené ''$1''.
Na [[$5]] prebieha diskusia, ktorá skončí ''$2''.",
	'deletequeue-notqueued' => 'Stránka, ktorú ste vybrali, momentálne nie je vo fronte na zmazanie',
	'deletequeue-review-action' => 'Vykonať operáciu:',
	'deletequeue-review-delete' => 'Zmazať stránku.',
	'deletequeue-review-change' => 'Zmazať stránku, ale s iným zdôvodnením.',
	'deletequeue-review-requeue' => 'Preniesť túto stránku do iného frontu:',
	'deletequeue-review-dequeue' => 'Nrobiť nič a odstrániť stránku z frontu na zmazanie.',
	'deletequeue-review-reason' => 'Komentáre:',
	'deletequeue-review-newreason' => 'Nový dôvod:',
	'deletequeue-review-newextra' => 'Ďalšie informácie:',
	'deletequeue-review-submit' => 'Uložiť kontrolu',
	'deletequeue-review-original' => 'Dôvod návrhu',
	'deletequeue-actiondisabled-involved' => 'Nasledovná činnosť je vypnutá, pretože ste sa podieľali na tomto prípade zmazania v úlohách $1:',
	'deletequeue-actiondisabled-notexpired' => 'Nasledovná činnosť je vypnutá, pretože zatiaľ nevypršal návrh na zmazanie:',
	'deletequeue-review-badaction' => 'Zadali ste neplatnú operáciu',
	'deletequeue-review-actiondenied' => 'Zadali ste operáciu, ktorá je pre túto stránku vypnutá',
	'deletequeue-review-objections' => "'''Upozornenie''': Existujú [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} námietky] proti zmazaniu tejto stránky.
Prosím, uistite sa, že ste tieto námietky zvážili, než sa rozhodnete stránku zmazať.",
	'deletequeue-reviewspeedy-tab' => 'Skontrolovať rýchle zmazanie',
	'deletequeue-reviewspeedy-title' => 'Skontrolovať návrh na rýchle zmazanie „$1”',
	'deletequeue-reviewspeedy-text' => "Tento formulár môžete použiť na kontrolu návrhu stránky „'''$1'''” na rýchle zmazanie.
Prosím, uistite sa, že je možné túto stránku rýchlo zmazať v súlade s pravidlami.",
	'deletequeue-reviewprod-tab' => 'Skontrolovať návrh na zmazanie',
	'deletequeue-reviewprod-title' => 'Skontrolovať návrh na zmazanie „$1”',
	'deletequeue-reviewprod-text' => "Tento formulár môžete použiť na kontrolu nenapadnutého návrhu stránky „'''$1'''” na zmazanie.",
	'deletequeue-reviewdeletediscuss-tab' => 'Skontrolovať zmazanie',
	'deletequeue-reviewdeletediscuss-title' => 'Skontrolovať diskusiu o zmazaní „$1”',
	'deletequeue-reviewdeletediscuss-text' => "Tento formulár môžete použiť na kontrolu diskusie o zmazaní stránky „'''$1'''”.

Existuje [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} zoznam] podporení zmazania a námietok proti zmazaniu tejto stránky a samotnú diskusiu nájdete na [[$2]].
Prosím, uistite sa, že sa rozhodnete v súlade s konsenzom v diskusii.",
	'deletequeue-review-success' => 'Úspešne ste skontrolovali zmazanie tejto stránky',
	'deletequeue-review-success-title' => 'Kontrola dokončená',
	'deletequeue-deletediscuss-discussionpage' => 'Toto je diskusná stránka o zmazaní stránky [[$1]].
Momentálne {{PLURAL:$2|existuje $2 používateľ|existujú $2 používatelia|existuje $2 používateľov}} podporujúcich zmazanie a {{PLURAL:$3|$3 používateľ|$3 používatelia|$3 používateľov}} namietajúcich proti zmazaniu.
Môžete [{{fullurl:$1|action=delvote}} podporiť alebo namietať proti] zmazaniu alebo [{{fullurl:$1|action=delviewvotes}} si pozrieť všetky podporujúce a namietajúce príspevky].',
	'deletequeue-discusscreate-summary' => 'Vytvára sa diskusia o zmazaní stránky [[$1]].',
	'deletequeue-discusscreate-text' => 'Zmazanie bolo navrhnuté z nasledovného dôvodu: $2',
	'deletequeue-role-nominator' => 'pôvodný navrhovateľ zmazania',
	'deletequeue-role-vote-endorse' => 'podporujúci zmazanie',
	'deletequeue-role-vote-object' => 'namietajúci proti zmazaniu',
	'deletequeue-vote-tab' => 'Podporiť/namietať proti zmazaniu',
	'deletequeue-vote-title' => 'Podporiť alebo namietať proti zmazaniu stránky „$1”',
	'deletequeue-vote-text' => "Tento formulár môžete použiť na podporenie alebo namietnutie proti návrhu na zmazanie stránky „'''$1'''”.
Táto činnosť bude mať prednosť pred všetkými podporeniami/námietkami, ktoré ste už mohli k zmazaniu tejto stránky uviesť.
Môžete [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} si pozrieť] zoznam podporení zmazania a námietok proti zmazaniu tejto stránky.

Ako dôvod návrhu na zmazanie bolo uvedené: ''$2''.",
	'deletequeue-vote-legend' => 'Podporiť/namietať proti zmazaniu',
	'deletequeue-vote-action' => 'Odporúčanie:',
	'deletequeue-vote-endorse' => 'Podporiť zmazanie.',
	'deletequeue-vote-object' => 'Namietať proti zmazaniu.',
	'deletequeue-vote-reason' => 'Komentáre:',
	'deletequeue-vote-submit' => 'Odoslať',
	'deletequeue-vote-success-endorse' => 'Úspešne ste podporili zmazanie tejto stránky.',
	'deletequeue-vote-success-object' => 'Úspešne ste podali námietku proti zmazaniu tejto stránky.',
	'deletequeue-vote-requeued' => 'Úspešne ste podali námietku proti zmazaniu tejto stránky.
Vďaka vašej námietke bola táto stránka presunutá do frontu $1.',
	'deletequeue-showvotes' => 'Podpora a námietky prosti zmazaniu stránky „$1”',
	'deletequeue-showvotes-text' => "Tu sa nachádza podpora a námietky prosti zmazaniu stránky „'''$1'''”.
Môžete [{{fullurl:{{FULLPAGENAME}}|action=delvote}} pridať] svoju vlastnú podporu alebo námietku proti zmazaniu.",
	'deletequeue-showvotes-restrict-endorse' => 'Zobraziť iba podporu',
	'deletequeue-showvotes-restrict-object' => 'Zobraziť iba námietky',
	'deletequeue-showvotes-restrict-none' => 'Zobraziť všetky podporu a námietky',
	'deletequeue-showvotes-vote-endorse' => "'''Podporil''' zmazanie $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Namietal proti''' zmazaniu $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Zobrazuje sa iba podpora',
	'deletequeue-showvotes-showingonly-object' => 'Zobrazujú sa iba námietky',
	'deletequeue-showvotes-none' => 'Neexistuje podpora ani námietky proti zmazaniu tejto stránky.',
	'deletequeue-showvotes-none-endorse' => 'Neexistuje podpora zmazania tejto stránky.',
	'deletequeue-showvotes-none-object' => 'Neexistujú námietky proti zmazaniu tejto stránky.',
	'deletequeue' => 'Front mazaní',
	'deletequeue-list-text' => 'Táto stránka obsahuje zoznam všetkých stránok v systéme mazania.',
	'deletequeue-list-search-legend' => 'Hľadať stránky',
	'deletequeue-list-queue' => 'Front:',
	'deletequeue-list-status' => 'Stav:',
	'deletequeue-list-expired' => 'Zobraziť iba návrhy čakajúce na uzavretie.',
	'deletequeue-list-search' => 'Hľadať',
	'deletequeue-list-anyqueue' => '(všetky)',
	'deletequeue-list-votes' => 'Zoznam hlasov',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|podporenie|podporenia|podporení}}, $2 {{PLURAL:$2|námietka|námietky|námietok}}',
	'deletequeue-list-header-page' => 'Stránka',
	'deletequeue-list-header-queue' => 'Front',
	'deletequeue-list-header-votes' => 'Podpora a námietky',
	'deletequeue-list-header-expiry' => 'Vyprší',
	'deletequeue-list-header-discusspage' => 'Diskusná stránka',
	'deletequeue-case-intro' => 'Táto stránka uvádza informácie o konkrétnom prípade zmazania.',
	'deletequeue-list-header-reason' => 'Dôvod zmazania',
	'deletequeue-case-votes' => 'Podpora/námietky:',
	'deletequeue-case-title' => 'Podrobnosti prípadu zmazania:',
	'deletequeue-case-details' => 'Základné podrobnosti',
	'deletequeue-case-page' => 'Stránka:',
	'deletequeue-case-reason' => 'Dôvod:',
	'deletequeue-case-expiry' => 'Uzatvorenie:',
	'deletequeue-case-needs-review' => 'Tento prípad vyžaduje [[$1|kontrolu]].',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'deletequeue-reviewdeletediscuss-tab' => 'Läskenge wröigje',
	'deletequeue-reviewdeletediscuss-title' => 'Läskdiskussion foar „$1“ wröigje',
	'deletequeue-reviewdeletediscuss-text' => "Ap disse Siede koast du ju Läskdiskussion fon „'''$1'''“ wröigje.

Dät rakt  ne [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Lieste] mäd Stimmen foar un juun ju Läskenge; ju eegentelke Diskussion is unner [[$2]] tou fienden.
Oachtje deerap, dät ne Äntscheedenge mäd dän Konsens fon ju Diskussion fereenboar is.",
	'deletequeue-deletediscuss-discussionpage' => 'Dit is ju Diskussionssiede foar ju Läskenge fon [[$1]].
Apstuuns {{PLURAL:$2|unnerstutset aan Benutser|unnerstutsje $2 Benutsere}} ju Läskenge, wülst $3 {{PLURAL:$3|Benutser|Benutsere}} hier ouliene.
Du koast ju Läskenge [{{fullurl:$1|action=delvote}} unnerstutsje of ouliene] of [{{fullurl:$1|action=delviewvotes}} aal Stimme bekiekje].',
	'deletequeue-discusscreate-summary' => 'Läskdiskussion foar [[$1]] wäd moaked.',
	'deletequeue-discusscreate-text' => 'Ju Läskenge wuud uut foulgjenden Gruund foarsloain: $2',
	'deletequeue-role-nominator' => 'uursproangelken Läskandraachstaaler',
	'deletequeue-role-vote-endorse' => 'Unnerstutser fon ju Läskenge',
	'deletequeue-role-vote-object' => 'Juun de Läskenge',
	'deletequeue-vote-title' => 'Läskenge fon „$1“ unnerstutsje of ouliene',
	'deletequeue-vote-text' => "Ap disse Siede koast du ju Läskenge fon „'''$1'''“ unnerstutsje of ouliene.
Disse Aktion uurschrift aal Stimmen, do du foartied tou ju Läskenge fon disse Siede ouroat hääst.
Du koast do al ouroate Stimmen [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} bekiekje].
Die Läskandraachsgruund waas ''$2''.",
	'deletequeue-vote-legend' => 'Läskenge unnerstutsje/ouliene',
	'deletequeue-vote-action' => 'Ämpfeelenge:',
	'deletequeue-vote-endorse' => 'Läskenge unnerstutsje.',
	'deletequeue-vote-object' => 'Läskenge ouliene.',
	'deletequeue-vote-reason' => 'Kommentoare:',
	'deletequeue-vote-submit' => 'Ouseende',
	'deletequeue-vote-success-endorse' => 'Du hääst mäd Ärfoulch ju Läskenge fon disse Siede unnerstutsed.',
	'deletequeue-vote-success-object' => 'Du hääst mäd Ärfoulch ju Läskenge fon disse Siede ouliend.',
	'deletequeue-vote-requeued' => 'Du hääst mäd Ärfoulch ju Läskenge fon disse Siede ouliend.
Truch dien Wierspruch wuud ju Siede in ju Läsk-Täiweslange $1 ferschäuwen.',
	'deletequeue-showvotes' => 'Unnerstutsengen un Oulienengen fon ju Läskenge fon „$1“',
	'deletequeue-showvotes-text' => "Unnerstoundend sunt do Unnerstutsengen un Oulienengen fon ju Läskenge fon „'''$1'''“ .
Du koast dien oaine Unnerstutsenge of Oulienenge fon ju Läskenge [{{fullurl:{{FULLPAGENAME}}|action=delvote}} hier] iendreege.",
	'deletequeue-showvotes-restrict-object' => 'Bloot Oulienengen ounwiese',
	'deletequeue-showvotes-restrict-none' => 'Aal Unnerstutsengen un Oulienengen ounwiese',
	'deletequeue-showvotes-vote-endorse' => "Läskenge uum $1 $2 '''unnerstutsed'''",
	'deletequeue-showvotes-vote-object' => "Läskenge uum $1 $2 '''ouliend'''",
	'deletequeue-showvotes-showingonly-endorse' => 'Bloot Unnerstutsengen wuuden ounwiesd',
	'deletequeue-showvotes-showingonly-object' => 'Bloot Oulienengen wuuden ounwiesd',
	'deletequeue-showvotes-none' => 'Dät rakt neen Unnerstutsengen of Oulienengen fon ju Läskenge fon disse Siede.',
	'deletequeue-showvotes-none-endorse' => 'Dät rakt neen Unnerstutsengen fon ju Läskenge fon disse Siede.',
	'deletequeue-showvotes-none-object' => 'Dät rakt neen Oulienengen fon ju Läskenge fon disse Siede.',
	'deletequeue' => 'Läsk-Täiweslange',
	'deletequeue-list-text' => 'Disse Siede wiest aal Sieden an, do sik in dät Läsksystem befiende.',
	'deletequeue-list-search-legend' => 'Säik ätter Sieden',
	'deletequeue-list-queue' => 'Täiweslange:',
	'deletequeue-list-status' => 'Stoatus:',
	'deletequeue-list-expired' => 'Wies bloot tou sluutende Läskandraage',
	'deletequeue-list-search' => 'Säik',
	'deletequeue-list-anyqueue' => '(irgendeen)',
	'deletequeue-list-votes' => 'Stimmenlieste',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|Unnerstutsenge|Unnerstutsengen}}, $2 {{PLURAL:$2|Oulienenge|Oulienengen}}',
	'deletequeue-list-header-page' => 'Siede',
	'deletequeue-list-header-queue' => 'Täiweslange',
	'deletequeue-list-header-votes' => 'Unnerstutsengen un Oulienengen',
	'deletequeue-list-header-expiry' => 'Ouloopdoatum',
	'deletequeue-list-header-discusspage' => 'Diskussionssiede',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Leo Johannes
 * @author M.M.S.
 * @author Najami
 * @author StefanB
 */
$messages['sv'] = array(
	'deletequeue-desc' => 'Skapar en [[Special:DeleteQueue|köbaserat system för att hantera raderingar]]',
	'deletequeue-action-queued' => 'Radering',
	'deletequeue-action' => 'Föreslå radering',
	'deletequeue-action-title' => 'Föreslå radering av "$1"',
	'deletequeue-permissions-noedit' => 'Du måste kunna redigera en sida för att kunna påverka dess raderingsstatus.',
	'deletequeue-generic-reasons' => '* Vanliga anledningar
  ** Vandalisering
  ** Spam
  ** Underhåll
  ** Inte relevant för projektet',
	'deletequeue-nom-alreadyqueued' => 'Den här sidan ligger redan i raderingskön.',
	'deletequeue-speedy-title' => 'Märk "$1" för snabbradering',
	'deletequeue-speedy-text' => "Du kan använda det här formuläret för att märka sidan \"'''\$1'''\" för snabbradering.

En administratör kommer granska begäran, och om den är rimlig, radera sidan.
Du måste ange en anledning från listan nedan, och lägga till annan relevant information.",
	'deletequeue-prod-title' => 'Föreslå radering av "$1"',
	'deletequeue-prod-text' => "Du kan använda det här formuläret för att föreslå att \"'''\$1'''\" raderas.

Om ingen har några motsättningar mot raderingen inom fem dagar, kommer raderingen granskas av en administratör.",
	'deletequeue-delnom-reason' => 'Anledning till nominering:',
	'deletequeue-delnom-otherreason' => 'Annan anledning',
	'deletequeue-delnom-extra' => 'Extrainformation:',
	'deletequeue-delnom-submit' => 'Nominera',
	'deletequeue-queue-speedy' => 'Snabbradering',
	'deletequeue-queue-prod' => 'Föreslagen radering',
	'deletequeue-queue-deletediscuss' => 'Raderingsdiskussion',
	'deletequeue-page-speedy' => "Denna sida har nominerats för snabbradering.
Anledningen som givits för denna radering är ''$1''.",
	'deletequeue-review-delete' => 'Radera sidan.',
	'deletequeue-review-reason' => 'Kommentarer:',
	'deletequeue-review-newreason' => 'Ny anledning:',
	'deletequeue-review-newextra' => 'Extrainformation:',
	'deletequeue-discusscreate-text' => 'Radering föreslagen på grund av följande anledning: $2',
	'deletequeue-vote-reason' => 'Kommentarer:',
	'deletequeue-vote-submit' => 'Skicka',
	'deletequeue' => 'Raderingskö',
	'deletequeue-list-search-legend' => 'Sök efter sidor',
	'deletequeue-list-queue' => 'Kö:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Sök',
	'deletequeue-list-anyqueue' => '(någon)',
	'deletequeue-list-votes' => 'Lista över röster',
	'deletequeue-list-header-page' => 'Sida',
	'deletequeue-list-header-queue' => 'Kö',
	'deletequeue-list-header-expiry' => 'Utgår',
	'deletequeue-list-header-discusspage' => 'Diskussionssida',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'deletequeue-delnom-otherreason' => 'ఇతర కారణం',
	'deletequeue-review-reason' => 'వ్యాఖ్యలు:',
	'deletequeue-review-newreason' => 'కొత్త కారణం:',
	'deletequeue-review-newextra' => 'అదనపు సమాచారం:',
	'deletequeue-vote-reason' => 'వ్యాఖ్యలు:',
	'deletequeue-list-status' => 'స్థితి:',
	'deletequeue-list-header-page' => 'పేజీ',
	'deletequeue-list-header-discusspage' => 'చర్చా పేజీ',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'deletequeue-delnom-otherreason' => 'Motivu seluk',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'deletequeue-list-search-legend' => 'Ҷустуҷӯи саҳифаҳо',
	'deletequeue-list-search' => 'Ҷустуҷӯ',
	'deletequeue-list-header-page' => 'Саҳифа',
	'deletequeue-list-header-discusspage' => 'Саҳифаи баҳс',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'deletequeue-list-search' => 'ค้นหา',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'deletequeue-desc' => 'Lumilikha ng isang [[Special:DeleteQueue|sistema ng pamamahala sa pagbura na nakabatay sa pila]]',
	'deletequeue-action-queued' => 'Pagbubura',
	'deletequeue-action' => 'Magmungkahi ng pagbura',
	'deletequeue-action-title' => 'Imungkahi ang pagbura ng "$1"',
	'deletequeue-action-text' => "Ang {{SITENAME}} ay may isang bilang ng mga pamamalakad sa pagbubura ng mga pahina:
*Kung naniniwala kang ang pahinang ito ay nangangailangan ng ''mabilisang pagbura'', maaari mong imungkahi iyan [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} dito].
*Kung hindi nangangailangan ng mabilisang pagbura ang pahinang ito, subalit ''ang pagbubura ay maaaring hindi naman pagtalunan'', dapat mong [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} imungkahi ang pagbuburang walang pagtutol].
*Kung ang pagbubura ng pahinang ito ay ''maaaring magkaroon ng pagtutol'', dapat kang [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} magbukas ng isang usapan].",
	'deletequeue-action-text-queued' => 'Maaari mong tingnan ang sumusunod na mga pahina para sa kasong ito ng pagbura:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Tingnan ang kasalukuyang mga pagsang-ayon at mga pagtutol].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Sumang-ayon o tumutol sa pagbura ng pahinang ito].',
	'deletequeue-permissions-noedit' => 'Dapat na may kakayahan kang magbago ng pahina upang makayanan mong maapektuhan ang katayuan ng pagbura nito.',
	'deletequeue-generic-reasons' => "* Pangkalahatang mga dahilan
  ** Pambababoy/Bandalismo
  ** Manlulusob (''spam'')
  ** Pagpapanatili
  ** Hindi sakop ng proyekto",
	'deletequeue-nom-alreadyqueued' => 'Ang pahinang ito ay nasa pila na ng pagbura.',
	'deletequeue-speedy-title' => 'Tatakan ang "$1" para sa mabilisang pagbura',
	'deletequeue-speedy-text' => "Maaari mong gamitin ang pormularyong ito upang tatakan ang pahinang \"'''\$1'''\" para sa mabilisang pagbura.

Susuriin ng isang tagapangasiwa ang kahilingang ito, at, buburahin ang pahina kung talagang mapagtitibay ito.
Dapat kang pumili ng isang dahilan sa pagbura mula sa nasa ibabang talaang naibabagsak pababa, magdagdag ng anumang iba pang mahalagang kabatiran.",
	'deletequeue-prod-title' => 'Imungkahi ang pagbura ng "$1"',
	'deletequeue-prod-text' => "Maaari mong gamitin ang pormularyong ito upang imungkahing burahin ang \"'''\$1'''\".

Kung, pagkaraan ng limang mga araw, walang tumututol sa pagbura ng pahinang ito, buburahin ito pagkaraan ng huling pagsusuri ng isang tagapangasiwa.",
	'deletequeue-delnom-reason' => 'Dahilan para sa nominasyon/paghaharap:',
	'deletequeue-delnom-otherreason' => 'Iba pang dahilan',
	'deletequeue-delnom-extra' => 'Dagdag na kabatiran:',
	'deletequeue-delnom-submit' => 'Ipasa ang nominasyon',
	'deletequeue-log-nominate' => "iniharap ang [[$1]] para sa pagbura sa loob ng pilang '$2'.",
	'deletequeue-log-rmspeedy' => 'tinanggihang mabilisang burahin ang [[$1]].',
	'deletequeue-log-requeue' => "inilipat ang [[$1]] papunta sa isang naiibang pila ng pagbura: mula '$2' hanggang '$3'.",
	'deletequeue-log-dequeue' => "tinanggal ang [[$1]] mula sa pila ng pagburang '$2'.",
	'right-speedy-nominate' => 'Magharap ng mga pahina para sa mabilisang pagbura',
	'right-speedy-review' => 'Suriing muli ang mga paghaharap para sa mabilisang pagbura',
	'right-prod-nominate' => 'Magmungkahi ng pagbura ng pahina',
	'right-prod-review' => 'Suriing muli ang hindi tinututulang mga mungkahi ng pagbura',
	'right-deletediscuss-nominate' => 'Simulan ang mga usapan ng pagbura',
	'right-deletediscuss-review' => 'Isara ang mga usapan ng pagbura',
	'right-deletequeue-vote' => 'Sumang-ayon o tumutol sa mga pagbura',
	'deletequeue-queue-speedy' => 'Mabilisang pagbura',
	'deletequeue-queue-prod' => 'Iminungkahing pagbura',
	'deletequeue-queue-deletediscuss' => 'Usapan ng pagbura',
	'deletequeue-page-speedy' => "Ang pahinang ito ay iniharap para sa mabilisang pagbura.
Ang ibinigay na dahilan para sa pagburang ito ay ''$1''.",
	'deletequeue-page-prod' => "Iminungkahing burahin ang pahinang ito.
Ang ibinigay na dahilan ay ''$1''.
Kapag hindi tinutulan ang mungkahing ito sa ''$2'', buburahin na ang pahinang ito.
Maaari mong tutulan ang pagbura ng pahinang ito sa pamamagitan [{{fullurl:{{FULLPAGENAME}}|action=delvote}} ng pagtutol sa pagbura].",
	'deletequeue-page-deletediscuss' => "Iminungkahing burahin ang pahinang ito, at may tumututol sa mungkahing ito.
Ang ibinigay na dahilan ay ''$1''.
Kasalukuyang nagaganap ang isang usapan sa [[$5]], na magtatapos sa ''$2''.",
	'deletequeue-notqueued' => 'Kasalukuyang hindi nakahanay para sa pagbura ang pahinang napili mo',
	'deletequeue-review-action' => 'Kilos na gagawin:',
	'deletequeue-review-delete' => 'Burahin ang pahina.',
	'deletequeue-review-change' => 'Burahin ang pahina, ngunit may ibang batayang katwiran.',
	'deletequeue-review-requeue' => 'Ilipat ang pahinang ito papunta sa sumusunod na pila:',
	'deletequeue-review-dequeue' => 'Walang gagawing kilos, at tanggalin ang pahina mula sa pila ng pagbura.',
	'deletequeue-review-reason' => 'Mga puna:',
	'deletequeue-review-newreason' => 'Bagong dahilan:',
	'deletequeue-review-newextra' => 'Dagdag kabatiran:',
	'deletequeue-review-submit' => 'Sagipin ang Muling Pagsuri',
	'deletequeue-review-original' => 'Dahilan ng paghaharap',
	'deletequeue-actiondisabled-involved' => 'Hindi pinapagana ang sumusunod na galaw dahil nakilahok ka sa kasong ito ng pagbura sa loob ng mga gampaning $1:',
	'deletequeue-actiondisabled-notexpired' => 'Hindi pinapagana ang sumusunod na galaw sapagkat hindi pa lumilipas ang paghaharap ng pagbura:',
	'deletequeue-review-badaction' => 'Tinukoy mo ang isang hindi tanggap na galaw',
	'deletequeue-review-actiondenied' => 'Tinukoy mo ang isang galaw na hindi pinapagana para sa pahinang ito',
	'deletequeue-review-objections' => "'''Babala''': May [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} mga pagtutol] sa pagbura ng pahinang ito.
Pakitiyak na isinaalang-alang mo ang ganitong mga pagtutol bago burahin ang pahinang ito.",
	'deletequeue-reviewspeedy-tab' => 'Suriin ang mabilisang pagbura',
	'deletequeue-reviewspeedy-title' => 'Suriin ang paghaharap ng mabilisang pagbura ng "$1"',
	'deletequeue-reviewspeedy-text' => "Magagamit mo ang pormularyong ito upang suriin ang paghaharap ng \"'''\$1'''\" para sa mabilisang pagbura.
Pakitiyak na maaari ngang mabilisang burahin ang pahinang ito ayon sa patakaran.",
	'deletequeue-reviewprod-tab' => 'Suriin ang iminungkahing pagbura',
	'deletequeue-reviewprod-title' => 'Suriin ang iminungkahing pagbura ng "$1"',
	'deletequeue-reviewprod-text' => "Magagamit mo ang pormularyong ito upang suriin ang hindi tinututulang mungkahi para sa pagbura ng \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Muling suriin ang pagbura',
	'deletequeue-reviewdeletediscuss-title' => 'Suriin ang usapan hinggil sa pagbubura ng "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Magagamit mo ang pormularyong ito upang suriin ang usapan hinggil sa pagbura ng \"'''\$1'''\".

Makakakuha ng isang [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} talaan] ng mga pagsang-ayon at mga pagtutol sa pagburang ito, at ang mismong usapan ay matatagpuan sa [[\$2]].
Pakitiyak na gagawa ka ng isang pasyang alinsunod sa napagkasunduan sa usapan.",
	'deletequeue-review-success' => 'Matagumpay mong nasuri ang pagkakabura ng pahinang ito',
	'deletequeue-review-success-title' => 'Nabuo na ang pagsusuri',
	'deletequeue-deletediscuss-discussionpage' => 'Ito ang pahina ng usapan para sa pagbura ng [[$1]].
Kasalukuyang may $2 {{PLURAL:$2|tagagamit|mga tagagamit}} na sumasang-ayon sa pagbura, at $3 {{PLURAL:$3|tagagamit|mga tagagamit}} na tumututol sa pagbura.
Maaari kang [{{fullurl:$1|action=delvote}} sumang-ayon o tumutol] sa pagbura, o [{{fullurl:$1|action=delviewvotes}} tingnan ang lahat ng mga pagsang-ayon at mga pagtutol].',
	'deletequeue-discusscreate-summary' => 'Nililikha ang usapan para sa pagbura ng [[$1]].',
	'deletequeue-discusscreate-text' => 'Iminungkahi ang pagbura para sa sumusunod na dahilan: $2',
	'deletequeue-role-nominator' => 'orihinal na tagapagharap ng pagbura',
	'deletequeue-role-vote-endorse' => 'tagapagsang-ayon sa pagbura',
	'deletequeue-role-vote-object' => 'tagapagtutol sa pagbura',
	'deletequeue-vote-tab' => 'Bumoto hinggil sa pagbubura',
	'deletequeue-vote-title' => 'Sumang-ayon o tumutol sa pagbura ng "$1"',
	'deletequeue-vote-text' => "Magagamit mo ang pormularyong ito upang sumang-ayon o tumutol sa pagbura ng \"'''\$1'''\".
Dadaigin ng galaw na ito ang anumang dati nang mga pagsang-ayon/pagtutol na ibinigay mo hinggil sa pagbura ng pahinang ito.
Maaari mong [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} tingnan] ang umiiral na mga pagsang-ayon at mga pagtutol.
Ang ibinigay na dahilan hinggil sa paghaharap para sa pagbura ay ''\$2''.",
	'deletequeue-vote-legend' => 'Pagsang-ayon/Pagtutol sa pagbura',
	'deletequeue-vote-action' => 'Rekomendasyon:',
	'deletequeue-vote-endorse' => 'Sumang-ayon sa pagbura.',
	'deletequeue-vote-object' => 'Tumutol sa pagbura.',
	'deletequeue-vote-reason' => 'Mga puna:',
	'deletequeue-vote-submit' => 'Ipasa',
	'deletequeue-vote-success-endorse' => 'Matagumpay mong nasang-ayunan ang pagbura ng pahinang ito.',
	'deletequeue-vote-success-object' => 'Matagumpay kang nakatutol sa pagbura ng pahinang ito.',
	'deletequeue-vote-requeued' => 'Matagumpay mong natutulan ang pagbura ng pahinang ito.
Dahil sa iyong pagtutol, inilapat ang pahinang ito sa pila ng $1.',
	'deletequeue-showvotes' => 'Mga pagsang-ayon at mga pagtutol sa pagbura ng "$1"',
	'deletequeue-showvotes-text' => "Nasa ibaba ang mga pagsang-ayon at mga pagtutol na ginawa hinggil sa pagbura ng pahinang \"'''\$1'''\".
Maaari mong [{{fullurl:{{FULLPAGENAME}}|action=delvote}} itala ang sarili mong pagsang-ayon dito, o pagtutol] sa pagburang ito.",
	'deletequeue-showvotes-restrict-endorse' => 'Ipakita ang mga pagsang-ayon lamang',
	'deletequeue-showvotes-restrict-object' => 'Ipakita ang mga pagtutol lamang',
	'deletequeue-showvotes-restrict-none' => 'Ipakita ang lahat ng mga pagsang-ayon at mga pagtutol',
	'deletequeue-showvotes-vote-endorse' => "'''Sinang-ayunan''' ang pagbura sa $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Tinutulan''' ang pagbura sa $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Ipinapakita lamang ang mga pagsang-ayon',
	'deletequeue-showvotes-showingonly-object' => 'Ipinapakita lamang ang mga pagtutol',
	'deletequeue-showvotes-none' => 'Walang mga pagsang-ayon o mga pagtutol sa pagbura ng pahinang ito.',
	'deletequeue-showvotes-none-endorse' => 'Walang mga pagsang-ayon sa pagbura ng pahinang ito.',
	'deletequeue-showvotes-none-object' => 'Walang mga pagtutol sa pagbura ng pahinang ito.',
	'deletequeue' => 'Pila ng pagbura',
	'deletequeue-list-text' => 'Ipinapakita ng pahinang ito ang lahat ng mga pahinang nasa loob ng sistema ng pagbubura.',
	'deletequeue-list-search-legend' => 'Maghanap ng mga pahina',
	'deletequeue-list-queue' => 'Pila:',
	'deletequeue-list-status' => 'Kalagayan:',
	'deletequeue-list-expired' => 'Ipakita lamang ang mga paghaharap/nominasyon na nangangailangan ng pagsasara.',
	'deletequeue-list-search' => 'Maghanap',
	'deletequeue-list-anyqueue' => '(kahit ano)',
	'deletequeue-list-votes' => 'Talaan ng mga paghalal',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|pagsang-ayon|mga pagsang-ayon}}, $2 {{PLURAL:$2|pagtutol|mga pagtutol}}',
	'deletequeue-list-header-page' => 'Pahina',
	'deletequeue-list-header-queue' => 'Pila',
	'deletequeue-list-header-votes' => 'Mga pagsang-ayon at mga pagtutol',
	'deletequeue-list-header-expiry' => 'Pagwawakas',
	'deletequeue-list-header-discusspage' => 'Pahina ng usapan',
	'deletequeue-case-intro' => 'Nagtatala ang pahinang ito ng kabatiran hinggil sa isang partikular na kaso ng pagbura.',
	'deletequeue-list-header-reason' => 'Dahilan ng pagbura',
	'deletequeue-case-votes' => 'Mga pagsang-ayon/mga pagtutol:',
	'deletequeue-case-title' => 'Mga detalye ng kaso ng pagbura',
	'deletequeue-case-details' => 'Payak na mga detalye',
	'deletequeue-case-page' => 'Pahina:',
	'deletequeue-case-reason' => 'Dahilan:',
	'deletequeue-case-expiry' => 'Katapusan:',
	'deletequeue-case-needs-review' => 'Nangangailangan ng [[$1|pagsusuri]] ang kasong ito.',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Mach
 */
$messages['tr'] = array(
	'deletequeue-delnom-otherreason' => 'Diğer nedenler',
	'deletequeue-queue-speedy' => 'Hızlı silme',
	'deletequeue-queue-deletediscuss' => 'Silme tartışması',
	'deletequeue-review-reason' => 'Yorumlar',
	'deletequeue-review-newreason' => 'Yeni gerekçe:',
	'deletequeue-list-header-page' => 'Sayfa',
);

/** Uighur (Latin) (Uyghurche‎ / ئۇيغۇرچە (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'deletequeue-list-header-page' => 'Bet',
	'deletequeue-case-page' => 'Bet:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'deletequeue-desc' => 'Tạo [[Special:DeleteQueue|hệ thống hàng đợi xóa]]',
	'deletequeue-action' => 'Đề nghị xóa',
	'deletequeue-action-title' => 'Đề nghị xóa “$1”',
	'deletequeue-prod-title' => 'Đề nghị xóa “$1”',
	'deletequeue-delnom-reason' => 'Lý do đề nghị',
	'deletequeue-delnom-otherreason' => 'Lý do khác',
	'deletequeue-delnom-extra' => 'Bổ sung:',
	'deletequeue-delnom-submit' => 'Đề nghị',
	'deletequeue-log-nominate' => 'đã đề nghị xóa [[$1]] trong hàng “$2”.',
	'deletequeue-log-rmspeedy' => 'từ chối xóa nhanh [[$1]].',
	'deletequeue-log-requeue' => 'chuyển [[$1]] qua hàng đợi xóa khác, từ “$2” đến “$3”.',
	'deletequeue-log-dequeue' => 'dời [[$1]] khỏi hàng đợi xóa “$2”.',
	'right-speedy-nominate' => 'Đề nghị xóa nhanh trang',
	'right-speedy-review' => 'Duyệt các trang chờ xóa nhanh',
	'right-prod-nominate' => 'Đề nghị xóa trang',
	'right-prod-review' => 'Duyệt trang chờ xóa',
	'right-deletediscuss-nominate' => 'Bắt đầu thảo luận về trang chờ xóa',
	'right-deletediscuss-review' => 'Kết thúc thảo luận về trang chờ xóa',
	'deletequeue-queue-speedy' => 'Xóa nhanh',
	'deletequeue-queue-prod' => 'Đề nghị xóa',
	'deletequeue-queue-deletediscuss' => 'Thảo luận về trang chờ xóa',
	'deletequeue-review-delete' => 'Xóa trang này.',
	'deletequeue-review-change' => 'Xóa trang này nhưng vì lý do khác.',
	'deletequeue-review-requeue' => 'Chuyển trang này qua hàng sau:',
	'deletequeue-review-dequeue' => 'Không làm gì và dời trang khỏi hàng đợi xóa.',
	'deletequeue-review-reason' => 'Ghi chú:',
	'deletequeue-review-newreason' => 'Lý do mới:',
	'deletequeue-review-newextra' => 'Bổ sung:',
	'deletequeue-review-submit' => 'Lưu thông tin',
	'deletequeue-review-original' => 'Lý do đề nghị',
	'deletequeue-reviewspeedy-tab' => 'Duyệt đề nghị xóa nhanh',
	'deletequeue-reviewspeedy-title' => 'Duyệt đề nghị xóa nhanh “$1”',
	'deletequeue-reviewprod-tab' => 'Duyệt đề nghị xóa',
	'deletequeue-reviewprod-title' => 'Duyệt đề nghị xóa “$1”',
	'deletequeue-reviewdeletediscuss-tab' => 'Duyệt đề nghị xóa',
	'deletequeue-reviewdeletediscuss-title' => 'Duyệt thảo luận về việc xóa “$1”',
	'deletequeue-discusscreate-summary' => 'Đang tạo trang thảo luận về việc xóa [[$1]].',
	'deletequeue-discusscreate-text' => 'Trang bị đề nghị xóa vì lý do sau: $2',
	'deletequeue-role-nominator' => 'người đầu tiên đề nghị xóa',
	'deletequeue-role-vote-endorse' => 'người ủng hộ việc xóa',
	'deletequeue-role-vote-object' => 'người phản đối việc xóa',
	'deletequeue-vote-tab' => 'Ủng hộ/phản đối xóa',
	'deletequeue-vote-title' => 'Ủng hộ hay phản đối việc xóa “$1”',
	'deletequeue-vote-legend' => 'Ủng hộ/phản đối xóa',
	'deletequeue-vote-action' => 'Lựa chọn:',
	'deletequeue-vote-endorse' => 'Ủng hộ việc xóa.',
	'deletequeue-vote-object' => 'Phản đối việc xóa.',
	'deletequeue-vote-reason' => 'Ghi chú:',
	'deletequeue-vote-submit' => 'Bỏ phiếu',
	'deletequeue-showvotes-vote-endorse' => "'''Ủng hộ''' xóa $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Phản đối''' xóa $1 $2",
	'deletequeue' => 'Hàng đợi xóa',
	'deletequeue-list-text' => 'Trang này liệt kê các trang đang chờ xóa.',
	'deletequeue-list-search-legend' => 'Tìm kiếm trang',
	'deletequeue-list-queue' => 'Hàng:',
	'deletequeue-list-status' => 'Tình trạng:',
	'deletequeue-list-search' => 'Tìm kiếm',
	'deletequeue-list-anyqueue' => '(tất cả)',
	'deletequeue-list-votes' => 'Danh sách lá phiếu',
	'deletequeue-list-votecount' => '$1 phiếu ủng hộ, $2 phiếu phản đối',
	'deletequeue-list-header-page' => 'Trang',
	'deletequeue-list-header-queue' => 'Hàng',
	'deletequeue-list-header-votes' => 'Số phiếu',
	'deletequeue-list-header-expiry' => 'Thời hạn',
	'deletequeue-list-header-discusspage' => 'Trang thảo luận',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'deletequeue-action-queued' => 'Moükam',
	'deletequeue-action' => 'Mobön moükami',
	'deletequeue-action-title' => 'Mobön moükami pada: „$1“',
	'deletequeue-permissions-noedit' => 'Mutol dalön redakön padi ad fägön ad votükön moükamastadi onik.',
	'deletequeue-prod-title' => 'Mobön moükami pada: „$1“',
	'deletequeue-delnom-otherreason' => 'Kod votik',
	'right-prod-nominate' => 'Mobön padimoükami',
	'right-deletediscuss-nominate' => 'Primön moükamibespiki',
	'right-deletediscuss-review' => 'Finükön moükamibespikis',
	'deletequeue-queue-deletediscuss' => 'Moükamibespik',
	'deletequeue-review-delete' => 'Moükön padi.',
	'deletequeue-review-reason' => 'Küpets:',
	'deletequeue-review-newreason' => 'Kod nulik:',
	'deletequeue-review-newextra' => 'Nüns pluik:',
	'deletequeue-discusscreate-summary' => 'Jafam bespika moükama pada: [[$1]].',
	'deletequeue-discusscreate-text' => 'Moükam pemobon sekü kods fovik: $2',
	'deletequeue-vote-reason' => 'Küpets:',
	'deletequeue-vote-submit' => 'Sedön:',
	'deletequeue-list-status' => 'Stad:',
	'deletequeue-list-header-page' => 'Pad',
	'deletequeue-list-header-discusspage' => 'Bespikapad',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'deletequeue-list-search' => 'זוכן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'deletequeue-action-queued' => '删除',
	'deletequeue-delnom-otherreason' => '其他原因',
	'deletequeue-delnom-extra' => '附加信息：',
	'deletequeue-queue-speedy' => '快速删除',
	'deletequeue-review-delete' => '删除页面。',
	'deletequeue-vote-tab' => '投票删除',
	'deletequeue-vote-endorse' => '赞成删除。',
	'deletequeue-vote-object' => '反对删除。',
	'deletequeue-vote-submit' => '提交',
	'deletequeue-showvotes-restrict-endorse' => '只显示赞成票',
	'deletequeue-showvotes-restrict-object' => '只显示反对票。',
	'deletequeue-list-status' => '状态：',
	'deletequeue-list-search' => '搜索',
	'deletequeue-list-anyqueue' => '（任何）',
	'deletequeue-list-votes' => '投票列表',
	'deletequeue-list-header-page' => '页面',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'deletequeue-action-queued' => '刪除',
	'deletequeue-delnom-otherreason' => '其他原因',
	'deletequeue-delnom-extra' => '附加資料：',
	'deletequeue-queue-speedy' => '快速刪除',
	'deletequeue-review-delete' => '刪除頁面。',
	'deletequeue-vote-tab' => '投票刪除',
	'deletequeue-vote-endorse' => '贊成刪除。',
	'deletequeue-vote-object' => '反對刪除。',
	'deletequeue-vote-submit' => '提交',
	'deletequeue-showvotes-restrict-endorse' => '只顯示贊成票',
	'deletequeue-showvotes-restrict-object' => '只顯示反對票',
	'deletequeue-list-search' => '搜尋',
	'deletequeue-list-anyqueue' => '（任何）',
	'deletequeue-list-votes' => '投票清單',
);

