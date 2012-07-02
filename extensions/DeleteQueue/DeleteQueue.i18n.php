<?php
/**
 * Internationalisation file for extension DeleteQueue.
 *
 * @file
 * @ingroup Extensions
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
	'deletequeue-generic-reasons' => "* Generic reasons
** Vandalism
** Spam
** Maintenance
** Out of project scope",
	'deletequeue-nom-alreadyqueued' => 'This page is already in a deletion queue.',

	// Speedy deletion
	'deletequeue-speedy-title' => 'Mark "$1" for speedy deletion',
	'deletequeue-speedy-text' => "You can use this form to mark the page \"'''$1'''\" for speedy deletion.

An administrator will review this request, and, if it is well-founded, delete the page.
You must select a reason for deletion from the drop-down list below, and add any other relevant information.",
	'deletequeue-speedy-reasons' => "-",

	// Proposed deletion
	'deletequeue-prod-title' => "Propose deletion of \"$1\"",
	'deletequeue-prod-text' => "You can use this form to propose that \"'''$1'''\" is deleted.

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
	// Generic
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
	// Speedy deletion
	'deletequeue-reviewspeedy-tab' => 'Review speedy deletion',
	'deletequeue-reviewspeedy-title' => 'Review speedy deletion nomination of "$1"',
	'deletequeue-reviewspeedy-text' => "You can use this form to review the nomination of \"'''$1'''\" for speedy deletion.
Please ensure that this page can be speedily deleted in accordance with policy.",
	// Proposed deletion
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
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'deletequeue-desc' => '{{desc}}',
	'deletequeue-generic-reasons' => 'Delete reasons in a dropdown menu. Lines prepended with "*" are a category separator. Lines prepended with "**" can be used as a reason. Please do not add additional reasons. This should be customised on wikis where the extension is actually being used.',
	'deletequeue-speedy-reasons' => '{{optional}}',
	'deletequeue-prod-reasons' => '{{optional}}',
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
	'right-speedy-nominate' => '{{doc-right|speedy-nominate}}',
	'right-speedy-review' => '{{doc-right|speedy-review}}',
	'right-prod-nominate' => '{{doc-right|prod-nominate}}',
	'right-prod-review' => '{{doc-right|prod-review}}',
	'right-deletediscuss-nominate' => '{{doc-right|deletediscuss-nominate}}',
	'right-deletediscuss-review' => '{{doc-right|deletediscuss-review}}',
	'right-deletequeue-vote' => '{{doc-right|deletequeue-vote}}',
	'deletequeue-page-speedy' => '$1 is the reason that the proposer entered.',
	'deletequeue-page-prod' => '* $1 is the reason that the proposer entered
* $2 is a date/time,
* $3 is a date (optional)
* $4 is a time (optional)',
	'deletequeue-page-deletediscuss' => '* $1 is the reason that the proposer entered
* $2 is a date/time,
* $3 is a date (optional)
* $4 is a time (optional) 
* $5 is a page title',
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
	'deletequeue-list-header-reason' => '{{Identical|Reason for deletion}}',
	'deletequeue-case-page' => '{{Identical|Page}}',
	'deletequeue-case-reason' => '{{Identical|Reason}}',
	'deletequeue-case-expiry' => '{{Identical|Expiry}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'deletequeue-delnom-otherreason' => 'Ander rede',
	'deletequeue-delnom-extra' => 'Ekstra inligting:',
	'deletequeue-review-reason' => 'Opmerkings:',
	'deletequeue-review-newreason' => 'Nuwe rede:',
	'deletequeue-review-newextra' => 'Ekstra inligting:',
	'deletequeue-vote-reason' => 'Opmerkings:',
	'deletequeue-vote-submit' => 'Dien in',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Soek',
	'deletequeue-list-anyqueue' => '(alle)',
	'deletequeue-list-votes' => 'Lys van stemme',
	'deletequeue-list-header-page' => 'Bladsy',
	'deletequeue-list-header-expiry' => 'Vervaldatum',
	'deletequeue-case-page' => 'Bladsy:',
	'deletequeue-case-reason' => 'Rede:',
	'deletequeue-case-expiry' => 'Verval:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'deletequeue-list-search' => 'ፍለጋ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 * @author Remember the dot
 */
$messages['an'] = array(
	'deletequeue-delnom-otherreason' => 'Atra razón',
	'deletequeue-vote-submit' => 'Ninviar',
	'deletequeue-list-header-page' => 'Pachina',
	'deletequeue-case-page' => 'Pachina:',
	'deletequeue-case-reason' => 'Razón:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
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
	'deletequeue-review-submit' => 'احفظ المراجعة',
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
	'deletequeue-vote-submit' => 'أرسل',
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
	'deletequeue-list-search' => 'ابحث',
	'deletequeue-list-anyqueue' => '(أي)',
	'deletequeue-list-votes' => 'قائمة الأصوات',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|تأييد|تأييد}}، $2 {{PLURAL:$2|اعتراض|اعتراض}}',
	'deletequeue-list-header-page' => 'صفحة',
	'deletequeue-list-header-queue' => 'طابور',
	'deletequeue-list-header-votes' => 'التأييد والاعتراضات',
	'deletequeue-list-header-expiry' => 'تاريخ الانتهاء',
	'deletequeue-list-header-discusspage' => 'صفحة نقاش',
	'deletequeue-case-intro' => 'هذه الصفحة تعرض المعلومات حول حالة حذف معينة.',
	'deletequeue-list-header-reason' => 'سبب الحذف:',
	'deletequeue-case-votes' => 'التأييد/المعارضة:',
	'deletequeue-case-title' => 'تفاصيل حالة الحذف',
	'deletequeue-case-details' => 'التفاصيل الأساسية',
	'deletequeue-case-page' => 'الصفحة:',
	'deletequeue-case-reason' => 'السبب:',
	'deletequeue-case-expiry' => 'الانتهاء:',
	'deletequeue-case-needs-review' => 'هذه الحالة تتطلب [[$1|المراجعة]].',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'deletequeue-delnom-otherreason' => 'ܥܠܬܐ ܐܚܪܬܐ',
	'deletequeue-delnom-extra' => 'ܝܕ̈ܥܬܐ ܝܬܝܪ:',
	'deletequeue-review-newreason' => 'ܥܠܬܐ ܚܕܬܐ:',
	'deletequeue-review-newextra' => 'ܝܕ̈ܥܬܐ ܝܬܝܪ:',
	'deletequeue-review-submit' => 'ܠܒܘܟ ܬܢܝܬܐ',
	'deletequeue-vote-submit' => 'ܫܕܪ',
	'deletequeue-list-search-legend' => 'ܒܨܝܐ ܥܠ ܦܐܬܬ̈ܐ',
	'deletequeue-list-status' => 'ܐܝܟܢܝܘܬܐ:',
	'deletequeue-list-search' => 'ܒܨܝܐ',
	'deletequeue-list-header-page' => 'ܦܐܬܐ',
	'deletequeue-list-header-discusspage' => 'ܦܐܬܐ ܕܕܘܪܫܐ',
	'deletequeue-list-header-reason' => 'ܥܠܬܐ ܕܫܝܦܐ',
	'deletequeue-case-details' => 'ܐܪ̈ܝܟܬܐ ܪ̈ܫܝܬܐ',
	'deletequeue-case-page' => 'ܕܦܐ:',
	'deletequeue-case-reason' => 'ܥܠܬܐ:',
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

لو، بعد خمسة أيام، لا أحد اعترض على حذف هذه الصفحة، سيتم حذفها بعد مراجعة نهائية بواسطة إدارى.",
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

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'deletequeue-delnom-otherreason' => 'Otru motivu',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 * @author Wertuose
 */
$messages['az'] = array(
	'deletequeue-action-queued' => 'Silinmə',
	'deletequeue-delnom-otherreason' => 'Digər səbəb',
	'deletequeue-delnom-extra' => 'Ekstra məlumatlar',
	'deletequeue-review-delete' => 'Bu səhifəni sil',
	'deletequeue-review-reason' => 'Şərhlər:',
	'deletequeue-review-newextra' => 'Ekstra məlumatlar',
	'deletequeue-vote-reason' => 'Şərhlər:',
	'deletequeue-vote-submit' => 'Təsdiq et',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Axtar',
	'deletequeue-list-header-page' => 'Səhifə',
	'deletequeue-list-header-discusspage' => 'Müzakirə səhifəsi',
	'deletequeue-case-page' => 'Səhifə:',
	'deletequeue-case-reason' => 'Səbəb:',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'deletequeue-list-search' => 'Suacha',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'deletequeue-case-reason' => 'Прычына:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'deletequeue-desc' => 'Стварае [[Special:DeleteQueue|чаргу для кіраваньня выдаленьнямі]]',
	'deletequeue-action-queued' => 'Выдаленьне',
	'deletequeue-action' => 'Прапанаваць выдаленьне',
	'deletequeue-action-title' => 'Прапанаваць выдаленьне «$1»',
	'deletequeue-action-text' => "У {{GRAMMAR:родны|{{SITENAME}}}} ёсьць некалькі працэсаў выдаленьня старонак:
* Калі Вы ўпэўнены, што гэта старонка вартая выдаленьня, Вы можаце [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} прапанаваць яе на ''хуткае выдаленьне''].
* Калі гэта старонка ня вартая хуткага выдаленьня, але ''выдаленьня ня будзе аспрэчвацца'', Вам неабходна [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} прапанаваць бясспрэчнае выдаленьне].
* Калі выдаленьне гэтай старонкі ''хутчэй за ўсё будзе аспрэчанае'', Вам неабходна [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} распачаць абмеркаваньне].",
	'deletequeue-action-text-queued' => 'Вы можаце паглядзець наступныя старонкі па гэтай прычыне выдаленьня:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Паглядзець цяперашнія пацьверджаньні і аспрэчваньні].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Пацьвердзіць ці аспрэчыць выдаленьне гэтай старонкі].',
	'deletequeue-permissions-noedit' => 'Вам неабходна мець магчымасьць рэдагаваць старонку, каб уплываць на статус выдаленьня.',
	'deletequeue-generic-reasons' => '* Агульныя прычыны
  ** Вандалізм
  ** Спам
  ** Падтрымка
  ** Па-за межамі праекту',
	'deletequeue-nom-alreadyqueued' => 'Гэтая старонка ўжо знаходзіцца ў чарзе выдаленьня.',
	'deletequeue-speedy-title' => 'Пазначыць «$1» да хуткага выдаленьня',
	'deletequeue-speedy-text' => "Вы можаце выкарыстоўваць гэтую форму для пазнакі старонкі «'''$1'''» да хуткага выдаленьня.

Адміністратар разгледзіць гэты запыт і, калі ён абгрунтаваны, выдаліць старонку.
Вам неабходна выбраць прычыну выдаленьня з выпадаючага сьпісу ніжэй, і дадаць любую іншую інфармацыю, якая датычыцца выдаленьня.",
	'deletequeue-prod-title' => 'Прапанаваць выдаленьне «$1»',
	'deletequeue-prod-text' => "Вы можаце выкарыстоўваць гэтую форму для прапановы «'''$1'''» да выдаленьня.

Калі, праз пяць дзён, ніхто не аспрэчыў выдаленьне гэтай старонкі, яна будзе выдалена пасьля апошняй рэцэнзаваньня адміністратарам.",
	'deletequeue-delnom-reason' => 'Прычына прапановы:',
	'deletequeue-delnom-otherreason' => 'Іншая прычына',
	'deletequeue-delnom-extra' => 'Дадатковая інфармацыя:',
	'deletequeue-delnom-submit' => 'Пацьвердзіць прапанову',
	'deletequeue-log-nominate' => "[[$1]] прапанаваная да выдаленьня ў чарзе '$2'.",
	'deletequeue-log-rmspeedy' => 'адхіленае хуткае выдаленьне [[$1]].',
	'deletequeue-log-requeue' => "[[$1]] перанесеная ў іншую чаргу выдаленьня: з '$2' у '$3'.",
	'deletequeue-log-dequeue' => "[[$1]] выдаленая з чаргі выдаленьня '$2'.",
	'right-speedy-nominate' => 'прапанова старонак да хуткага выдаленьня',
	'right-speedy-review' => 'рэцэнзаваньне прапановаў да хуткага выдаленьня',
	'right-prod-nominate' => 'прапанова выдаленьня старонак',
	'right-prod-review' => 'рэцэнзаваньне не аспрэчаных прапановаў да выдаленьня',
	'right-deletediscuss-nominate' => 'стварэньне абмеркаваньняў выдаленьняў',
	'right-deletediscuss-review' => 'закрыцьцё абмеркаваньняў выдаленьняў',
	'right-deletequeue-vote' => 'пацьверджаньне альбо аспрэчваньне выдаленьняў',
	'deletequeue-queue-speedy' => 'Хуткае выдаленьне',
	'deletequeue-queue-prod' => 'Прапанаванае выдаленьне',
	'deletequeue-queue-deletediscuss' => 'Абмеркаваньне выдаленьня',
	'deletequeue-page-speedy' => "Гэтая старонка была прапанаваная да хуткага выдаленьня.
Пададзеная прычына гэтага выдаленьня — ''$1''.",
	'deletequeue-page-prod' => "Існуе прапанова выдаленьня гэтай старонкі.
Прададзеная прычына — ''$1''.
Калі гэта прапанова ня будзе аспрэчаная да ''$2'', старонка будзе выдаленая.
Вы можаце аспрэчыць выдаленьне гэтай старонкі на [{{fullurl:{{FULLPAGENAME}}|action=delvote}} адпаведнай старонцы].",
	'deletequeue-page-deletediscuss' => "Гэтая старонка была прапанавана на выдаленьне, і гэта прапанова была аспрэчаная.
Пададзеная прычына — ''$1''.
Абмеркаваньне вядзецца на [[$5]] і павінна скончыцца ''$2''.",
	'deletequeue-notqueued' => 'Старонка, якую Вы выбралі, не знаходзіцца ў чарзе выдаленьня',
	'deletequeue-review-action' => 'Дзеяньне на выбар:',
	'deletequeue-review-delete' => 'Выдаліць старонку.',
	'deletequeue-review-change' => 'Выдаліць гэту старонку, але па іншай прычыне.',
	'deletequeue-review-requeue' => 'Перанесьці гэту старонку ў іншую чаргу:',
	'deletequeue-review-dequeue' => 'Нічога не рабіць і выдаліць старонку з чаргі выдаленьня.',
	'deletequeue-review-reason' => 'Камэнтары:',
	'deletequeue-review-newreason' => 'Новая прычына:',
	'deletequeue-review-newextra' => 'Дадатковая інфармацыя:',
	'deletequeue-review-submit' => 'Захаваць рэцэнзію',
	'deletequeue-review-original' => 'Прычына прапановы',
	'deletequeue-actiondisabled-involved' => 'Наступнае дзеяньне забароненае, таму што Вы прынялі ўдзел у гэтай прапанове выдаленьня ў ролі $1:',
	'deletequeue-actiondisabled-notexpired' => 'Наступнае дзеяньне забароненае, таму што прапанова на выдаленьне яшчэ дзейнічае:',
	'deletequeue-review-badaction' => 'Вы пазначылі няслушнае дзеяньне',
	'deletequeue-review-actiondenied' => 'Вы пазначылі дзеяньне, якое забароненае для гэтай старонкі',
	'deletequeue-review-objections' => "'''Увага''': Выдаленьне гэтай старонкі было [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} аспрэчана].
Калі ласка, упэўніцеся, што Вы разгледзелі гэтыя пярэчаньні перад выдаленьнем гэтай старонкі.",
	'deletequeue-reviewspeedy-tab' => 'Рэцэнзаваць хуткае выдаленьне',
	'deletequeue-reviewspeedy-title' => 'Рэцэнзаваньне прапанову на хуткае выдаленьне «$1»',
	'deletequeue-reviewspeedy-text' => "Вы можаце выкарыстоўваць гэтую форму для рэцэнзіі прапановы на хуткае выдаленьне «'''$1'''».
Калі ласка, упэўніцеся, што гэтая старонка можа быць хутка выдаленая ў адпаведнасьці з правіламі.",
	'deletequeue-reviewprod-tab' => 'Рэцэнзаваць прапанаваныя выдаленьні',
	'deletequeue-reviewprod-title' => 'Рэцэнзаваньне прапанаванага выдаленьня «$1»',
	'deletequeue-reviewprod-text' => "Вы можаце выкарыстоўваць гэтую форму для рэцэнзаваньня не аспрэчанай прапановы на выдаленьне «'''$1'''».",
	'deletequeue-reviewdeletediscuss-tab' => 'Рэцэнзаваць выдаленьне',
	'deletequeue-reviewdeletediscuss-title' => 'Рэцэнзаваньне абмеркаваньня выдаленьня «$1»',
	'deletequeue-reviewdeletediscuss-text' => "Вы можаце выкарыстоўваць гэтую форму для рэцэнзаваньня абмеркаваньня выдаленьня «'''$1'''».

[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Сьпіс] галасоў у падтрымку і супраць гэтага выдаленьня даступны, а абмеркаваньне можна знайсьці на [[$2]].
Калі ласка, упэўніцеся, што Ваша рашэньне адпавядае кансэнсусу ў абмеркаваньні.",
	'deletequeue-review-success' => 'Вы пасьпяхова прарэцэнзавалі выдаленьне гэтай старонкі',
	'deletequeue-review-success-title' => 'Рэцэнзаваньне скончанае',
	'deletequeue-deletediscuss-discussionpage' => 'Гэта старонка абмеркаваньня для выдаленьня [[$1]].
У цяперашні момант $2 {{PLURAL:$2|удзельнік|удзельнікі|удзельнікаў}} падтрымліваюць выдаленьне, і $3 {{PLURAL:$3|удзельнік|удзельнікі|удзельнікаў}} аспрэчваюць выдаленьне.
Вы можаце [{{fullurl:$1|action=delvote}} падтрымаць альбо аспрэчыць] выдаленьне, альбо [{{fullurl:$1|action=delviewvotes}} праглядзець усе галасы за і супраць].',
	'deletequeue-discusscreate-summary' => 'Стварэньне абмеркаваньня выдаленьня [[$1]].',
	'deletequeue-discusscreate-text' => 'Выдаленьне прапануецца па наступнай прычыне: $2',
	'deletequeue-role-nominator' => 'удзельнік, які прапанаваў выдаленьне',
	'deletequeue-role-vote-endorse' => 'за выдаленьне',
	'deletequeue-role-vote-object' => 'супраць выдаленьня',
	'deletequeue-vote-tab' => 'Галасаваць у працэсе выдаленьня',
	'deletequeue-vote-title' => 'Падтрымаць альбо аспрэчыць выдаленьне «$1»',
	'deletequeue-vote-text' => "Вы можаце выкарыстоўваць гэтую форму для таго каб падтрымаць альбо аспрэчыць выдаленьне «'''$1'''».
Гэтае дзеяньне заменіць усе папярэднія падтрымкі/пярэчаньні, якія Вы зрабілі ў выдаленьне гэтай старонкі.
Вы можаце [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} праглядзець] існуючыя падтрымкі і пярэчаньні.
Прычына, якая была пададзеная ў прапанове на выдаленьне была ''$2''.",
	'deletequeue-vote-legend' => 'Падтрымка/Аспрэчваньне выдаленьня',
	'deletequeue-vote-action' => 'Рэкамэндацыя:',
	'deletequeue-vote-endorse' => 'Падтрымаць выдаленьне.',
	'deletequeue-vote-object' => 'Аспрэчыць выдаленьне.',
	'deletequeue-vote-reason' => 'Камэнтары:',
	'deletequeue-vote-submit' => 'Даслаць',
	'deletequeue-vote-success-endorse' => 'Вы пасьпяхова падтрымалі выдаленьне гэтай старонкі.',
	'deletequeue-vote-success-object' => 'Вы пасьпяхова аспрэчылі выдаленьне гэтай старонкі.',
	'deletequeue-vote-requeued' => 'Вы пасьпяхова аспрэчылі выдаленьне гэтай старонкі.
Згодна з Вашым аспрэчваньнем, старонка была перанесена ў чаргу $1.',
	'deletequeue-showvotes' => 'Падтрымкі і аспрэчваньні выдаленьня «$1»',
	'deletequeue-showvotes-text' => "Ніжэй пададзеныя падтрымкі і аспрэчваньні пададзеныя ў выдаленьні старонкі «'''$1'''».
Вы можаце [{{fullurl:{{FULLPAGENAME}}|action=delvote}} выказаць Вашую падтрымку альбо аспрэчваньне] гэтага выдаленьня.",
	'deletequeue-showvotes-restrict-endorse' => 'Паказаць толькі падтрымкі',
	'deletequeue-showvotes-restrict-object' => 'Паказаць толькі аспрэчваньні',
	'deletequeue-showvotes-restrict-none' => 'Паказаць усе падтрымкі і аспрэчваньні',
	'deletequeue-showvotes-vote-endorse' => "'''Падтрыманае''' выдаленьне $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Аспрэчанае''' выдаленьне $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Паказаныя толькі падтрымкі',
	'deletequeue-showvotes-showingonly-object' => 'Паказаныя толькі аспрэчваньні',
	'deletequeue-showvotes-none' => 'Няма ні падтрымак, ні аспрэчваньняў выдаленьня гэтай старонкі.',
	'deletequeue-showvotes-none-endorse' => 'Няма падтрымак выдаленьня гэтай старонкі.',
	'deletequeue-showvotes-none-object' => 'Няма аспрэчваньняў выдаленьня гэтай старонкі.',
	'deletequeue' => 'Чарга выдаленьняў',
	'deletequeue-list-text' => 'Гэтая старонка паказвае ўсе старонкі, якія знаходзяцца ў сыстэме выдаленьня.',
	'deletequeue-list-search-legend' => 'Пошук старонак',
	'deletequeue-list-queue' => 'Чарга:',
	'deletequeue-list-status' => 'Статус:',
	'deletequeue-list-expired' => 'Паказваць толькі прапановы, якія патрабуюць закрыцьця.',
	'deletequeue-list-search' => 'Пошук',
	'deletequeue-list-anyqueue' => '(любое)',
	'deletequeue-list-votes' => 'Сьпіс галасоў',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|падтрымка|падтрымкі|падтрымак}}, $2 {{PLURAL:$2|аспрэчваньне|аспрэчваньні|аспрэчваньняў}}',
	'deletequeue-list-header-page' => 'Старонка',
	'deletequeue-list-header-queue' => 'Чарга',
	'deletequeue-list-header-votes' => 'Падтрымкі і аспрэчваньні',
	'deletequeue-list-header-expiry' => 'Скончаныя',
	'deletequeue-list-header-discusspage' => 'Старонка абмеркаваньня',
	'deletequeue-case-intro' => 'Гэтая старонка ўтрымлівае інфармацыю пра выдаленьне.',
	'deletequeue-list-header-reason' => 'Прычына выдаленьня',
	'deletequeue-case-votes' => 'Падтрымкі/аспрэчваньні:',
	'deletequeue-case-title' => 'Падрабязнасьці пра запыт на выдаленьне',
	'deletequeue-case-details' => 'Асноўныя падрабязнасьці',
	'deletequeue-case-page' => 'Старонка:',
	'deletequeue-case-reason' => 'Прычына:',
	'deletequeue-case-expiry' => 'Тэрмін:',
	'deletequeue-case-needs-review' => 'Гэты запыт патрабуе [[$1|рэцэнзаваньня]].',
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
	'deletequeue-queue-speedy' => 'Бързо изтриване',
	'deletequeue-review-action' => 'Действие за предприемане:',
	'deletequeue-review-delete' => 'Изтриване на страницата.',
	'deletequeue-review-reason' => 'Коментари:',
	'deletequeue-review-newreason' => 'Нова причина:',
	'deletequeue-review-newextra' => 'Допълнителна информация:',
	'deletequeue-review-original' => 'Причина за номинирането',
	'deletequeue-vote-action' => 'Препоръка:',
	'deletequeue-vote-reason' => 'Коментари:',
	'deletequeue-vote-submit' => 'Изпращане',
	'deletequeue' => 'Опашка за изтриване',
	'deletequeue-list-search-legend' => 'Търсене за страници',
	'deletequeue-list-queue' => 'Опашка:',
	'deletequeue-list-status' => 'Статут:',
	'deletequeue-list-search' => 'Търсене',
	'deletequeue-list-votes' => 'Списък на гласовете',
	'deletequeue-list-header-page' => 'Страница',
	'deletequeue-list-header-queue' => 'Опашка',
	'deletequeue-list-header-expiry' => 'Срок на изтичане',
	'deletequeue-list-header-discusspage' => 'Дискусионна страница',
	'deletequeue-list-header-reason' => 'Причина за изтриване',
	'deletequeue-case-details' => 'Основна информация',
	'deletequeue-case-page' => 'Страница:',
	'deletequeue-case-reason' => 'Причина:',
	'deletequeue-case-expiry' => 'Срок на изтичане:',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'deletequeue-action-queued' => 'অপসারণ',
	'deletequeue-action' => 'অপসারণের পরামর্শ',
	'deletequeue-action-title' => '"$1" অপসারণের পরামর্শ দাও',
	'deletequeue-delnom-otherreason' => 'অন্যান্য কারণ',
	'deletequeue-delnom-extra' => 'অতিরিক্ত তথ্যাদি:',
	'deletequeue-delnom-submit' => 'মনোনয়ন জমা দাও',
	'deletequeue-log-nominate' => "'$2' লাইনে [[$1]]-কে অপসারণের জন্য মনোনয়ন দেওয়া হয়েছে",
	'right-prod-nominate' => 'পাতার প্রস্তাবিত অপসারণ',
	'deletequeue-queue-speedy' => 'দ্রুত অপসারণ',
	'deletequeue-queue-prod' => 'প্রস্তাবিত অপসারণ',
	'deletequeue-queue-deletediscuss' => 'অপসারণের আলোচনা',
	'deletequeue-page-speedy' => "এই পাতাটি দ্রুত অপসারণের জন্য মনোনয়ন দেওয়া হয়েছে।
অপসারণের কারণ হিসেবে উল্লেখ করা হয়েছে ''$1''।",
	'deletequeue-notqueued' => 'আপনি যে পাতাটি নির্বাচন করেছেন তা বর্তমানে অপসারণের জন্য তালিকাভুক্ত হয়নি',
	'deletequeue-review-action' => 'যে অ্যাকশন নেওয়া হবে:',
	'deletequeue-review-delete' => 'এই পাতাটি অপসারণ করুন।',
	'deletequeue-review-requeue' => 'এই পাতাটি নিচের তালিকায় স্থানান্তর করুন:',
	'deletequeue-review-dequeue' => 'কোনো অ্যাকশন নেবেন না, এবং পাতাটি অপসারণের তালিকা থেকে বাদ দিন।',
	'deletequeue-review-reason' => 'মন্তব্য:',
	'deletequeue-review-newreason' => 'নতুন কারণ:',
	'deletequeue-review-newextra' => 'অতিরিক্ত তথ্যাদি:',
	'deletequeue-review-submit' => 'পর্যবেক্ষণ সংরক্ষণ',
	'deletequeue-review-original' => 'মনোনয়নের কারণ',
	'deletequeue-review-badaction' => 'আপনি একটি অগ্রহণযোগ্য অ্যাকশন নির্বাচন করেছেন',
	'deletequeue-review-actiondenied' => 'আপনি এমন একটি অ্যাকশন নির্বাচন করেছেন যা এই পাতার জন্য প্রযোজ্য নয়',
	'deletequeue-reviewspeedy-tab' => 'দ্রুত অপসারণ পর্যবেক্ষণ',
	'deletequeue-reviewspeedy-title' => '"$1"-এর দ্রুত অপসারণ মনোনয়ন পর্যবেক্ষণ করুন',
	'deletequeue-reviewprod-tab' => 'প্রস্তাবিত অপসারণ পর্যবেক্ষণ',
	'deletequeue-reviewprod-title' => '"$1"-এর প্রস্তাবিত অপসারণ পর্যবেক্ষণ',
	'deletequeue-review-success' => 'আপনি সফলভাবে এই পাতার পর্যবেক্ষণ সম্পন্ন করেছেন',
	'deletequeue-review-success-title' => 'পর্যবেক্ষণ সম্পূর্ণ',
	'deletequeue-discusscreate-summary' => '[[$1]]-এর অপসারণের আলোচনা শুরু করুন।',
	'deletequeue-discusscreate-text' => 'নিম্নোক্ত কারণে অপসারণ প্রস্তাব করা হয়েছে: $2',
	'deletequeue-role-nominator' => 'অপসারণের প্রকৃত প্রস্তাবক',
	'deletequeue-role-vote-endorse' => 'অপসারণের সমর্থনকারী',
	'deletequeue-role-vote-object' => 'অপসারণের বিরোধীতাকারী',
	'deletequeue-vote-tab' => 'অপসারণের ভোট',
	'deletequeue-vote-title' => '"$1"-এ অপসারণের পক্ষে সমর্থন বা বিরোধিতা ব্যক্ত করুন',
	'deletequeue-vote-legend' => 'অপসারণের সমর্থন/বিরোধিতা',
	'deletequeue-vote-action' => 'সুপারিশ:',
	'deletequeue-vote-endorse' => 'অপসারণের পক্ষে মত দিন।',
	'deletequeue-vote-object' => 'অপসারণের বিরোধিতা করুন।',
	'deletequeue-vote-reason' => 'মন্তব্য:',
	'deletequeue-vote-submit' => 'জমা দাও',
	'deletequeue-vote-success-endorse' => 'আপনি সফলভাবে এই পাতার অপসারণের পক্ষে মত দিয়েছেন।',
	'deletequeue-vote-success-object' => 'আপনি সফলভাবে এই পাতার অপসারণের বিপক্ষে মত দিয়েছেন।',
	'deletequeue-showvotes' => '"$1"-এর অপসারণের প্রসঙ্গে সমর্থন ও বিরোধিতা',
	'deletequeue-showvotes-restrict-endorse' => 'শুধুমাত্র সমর্থনসমূহ দেখাও',
	'deletequeue-showvotes-restrict-object' => 'শুধুমাত্র বিরোধীতাসমূহ দেখাও',
	'deletequeue-showvotes-restrict-none' => 'সকল সমর্থন ও বিরোধিতাসমূহ দেখাও',
	'deletequeue-showvotes-showingonly-endorse' => 'শুধুমাত্র সমর্থনগুলো দেখানো হচ্ছে',
	'deletequeue-showvotes-showingonly-object' => 'শুধুমাত্র বিরোধিতাগুলো দেখোনো হচ্ছে',
	'deletequeue' => 'অপসারণ তালিকা',
	'deletequeue-list-text' => 'এই পাতাটি অপসারণ সিস্টেমে থাকা সকল পাতাকে প্রদর্শন করছে।',
	'deletequeue-list-search-legend' => 'পাতার জন্য অনুসন্ধান',
	'deletequeue-list-queue' => 'তালিকা:',
	'deletequeue-list-status' => 'অবস্থা:',
	'deletequeue-list-search' => 'অনুসন্ধান',
	'deletequeue-list-anyqueue' => '(যে-কোনো)',
	'deletequeue-list-votes' => 'ভোটের তালিকা',
	'deletequeue-list-header-page' => 'পাতা',
	'deletequeue-list-header-queue' => 'তালিকা:',
	'deletequeue-list-header-votes' => 'সমর্থন ও বিরোধিতা',
	'deletequeue-list-header-expiry' => 'যখন মেয়াদোত্তীর্ণ হবে:',
	'deletequeue-list-header-discusspage' => 'আলোচনা পাতা',
	'deletequeue-list-header-reason' => 'অপসারণের কারণ',
	'deletequeue-case-votes' => 'সমর্থন/বিরোধিতা:',
	'deletequeue-case-title' => 'অপসারণ কেসের বিস্তারিত',
	'deletequeue-case-details' => 'সাধারণ বিস্তারিত',
	'deletequeue-case-page' => 'পাতা:',
	'deletequeue-case-reason' => 'কারণ:',
	'deletequeue-case-expiry' => 'যখন মেয়াদোত্তীর্ণ হবে:',
	'deletequeue-case-needs-review' => 'এই কেসটির [[$1|পর্যবেক্ষণ]] প্রয়োজন।',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'deletequeue-desc' => 'Krouiñ ur [[Special:DeleteQueue|sistem a steudad gortoz evit merañ an dilamadurioù]]',
	'deletequeue-action-queued' => 'Dilammadenn',
	'deletequeue-action' => 'Kinnig un dilammadenn',
	'deletequeue-action-title' => 'Kinnig diverkañ "$1"',
	'deletequeue-action-text' => "Meur a bazenn zo war ar wiki-mañ evit gallout diverkañ pajennoù :
*Mar kav deoc'h emañ danvez ar bajenn-mañ diouti e c'hallit [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} kinnig ma vo \"diverket raktal''].
*Mar ne gav ket deoc'h emañ danvez ar bajenn diouzh dezverkoù un diverkadenn brim met emañ \"dellezek da vezañ diverket digudenn\", e c'hallit [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} kinnig ma vo diverket hep tabut].
*Mar kav deoc'h e c'hall bezañ \"sach-blev\" a-zivout kinnig diverkañ ar bajenn e tlefec'h [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} digeriñ ur gaoz].",
	'deletequeue-action-text-queued' => 'Gallout a rit sellet ouzh ar pajennoù da-heul evit ar pezh a sell ouzh an diverkadenn-mañ :
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Gwelet an aprouadennoù hag ar soñjoù enep].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Aprouiñ diverkadenn ar bajenn-mañ pe sevel a-enep].',
	'deletequeue-permissions-noedit' => "Ret eo deoc'h bezañ gouest da gemmañ ur bajenn a-benn reiñ d'ur bajenn he statud da zilemel.",
	'deletequeue-generic-reasons' => "* Abegoù boutinañ
** Vandalerezh
** Strob
** Trezalc'h
** E maez ar raktres",
	'deletequeue-nom-alreadyqueued' => 'Emañ ar bajenn-mañ en ul lostad dilemel dija.',
	'deletequeue-speedy-title' => 'Merkañ "$1" evit un diverkadenn brim',
	'deletequeue-speedy-text' => "Gallout a rit ober gan tar furmskrid-mañ evit merkañ ar bajenn \"'''\$1'''\" evel unan da vezañ diverket raktal.

Sellet e vo ouzh ar goulenn gant ur merour ha diverkañ ar raio ar bajenn ma kav dezhañ ez eus d'en ober.
Ret eo deoc'h dibab un abeg diverkañ e-touez ar re kinniget er roll desachañ a-is; ouzhpennit titouroù ouzhpenn diouzh an ezhomm.",
	'deletequeue-prod-title' => 'Kinnig diverkañ "$1"',
	'deletequeue-prod-text' => "Gallout a rit ober gant ar furmskrid-mañ evit kinnig ma vefe diverket \"'''\$1'''\".

Ma ne gav den ebet abeg ebet er goulenn goude pemp devezh e vo diverket gant ur merour war-lerc'h un adsell diwezhañ graet gantañ.",
	'deletequeue-delnom-reason' => "Abeg ar c'hinnig :",
	'deletequeue-delnom-otherreason' => 'Abeg all',
	'deletequeue-delnom-extra' => 'Titouroù ouzhpenn :',
	'deletequeue-delnom-submit' => 'Kas an anvadur',
	'deletequeue-log-nominate' => 'Lakaet eo bet [[$1]] war ar renk evit bezañ diverket el lostennad "$2".',
	'deletequeue-log-rmspeedy' => "nac'het evit an dilammadenn prim [[$1]].",
	'deletequeue-log-requeue' => 'Dilec\'hiet eo bet [[$1]] davet ur steudad dilammadenn disheñvel : eus "$2" da "$3".',
	'deletequeue-log-dequeue' => 'Lamet eo bet [[$1]] eus al lostad dilemel « $2 ».',
	'right-speedy-nominate' => 'Kinnig a ra pajennoù evit un dilammadenn prim',
	'right-speedy-review' => "Adwelet ar c'hinnigoù evit an dilammadenn prim",
	'right-prod-nominate' => 'Kinnig diverkañ pajennoù',
	'right-prod-review' => "Adwelet ar c'hinnigoù diverkañ n'eus ket tabut warno",
	'right-deletediscuss-nominate' => "Kegiñ gant ar c'haozeadennoù war an diverkañ",
	'right-deletediscuss-review' => 'Klozañ an divizoù dilemel',
	'right-deletequeue-vote' => 'Aprouiñ pe enebiñ ouzh an dilamadurioù',
	'deletequeue-queue-speedy' => 'Dilamadenn brim',
	'deletequeue-queue-prod' => 'Diverkadenn kinniget',
	'deletequeue-queue-deletediscuss' => 'Kaozeadenn war an diverkañ',
	'deletequeue-page-speedy' => "Kinniget ez eus bet diverkañ ar bajenn-mañ raktal.
Setu an abeg roet ''$1''.",
	'deletequeue-page-prod' => "Kinniget ez eus bet diverkañ ar bajenn-mañ. 
Ha setu perak ''$1''.
Ma ne vez ket dizarbennet ar c'hinnig-mañ a-benn an ''$2'', e vo diverket ar bajenn.
Gallout a rit dizarbenn ar c'hinnig diverkañ en ur [{{fullurl:{{FULLPAGENAME}}|action=delvote}} sevel a-enep d'an diverkañ].",
	'deletequeue-page-deletediscuss' => "Kinniget e oa bet diverkañ ar bajenn-mañ ha tud zo zo savet a-enep.
Abalamour da gement-mañ ''$1''.
Boulc'het ez eus bet ur gaoz war an divoud war [[$5]]; klozet e vo d'an ''$2''.",
	'deletequeue-notqueued' => "Ar bajenn hoc'h eus diuzet n'emañ ket en ul lostennad dilemel evit bremañ",
	'deletequeue-review-action' => 'Ober da seveniñ :',
	'deletequeue-review-delete' => 'Dilemel ar bajenn.',
	'deletequeue-review-change' => 'Dilemel ar bajenn-mañ, met gant un abeg all.',
	'deletequeue-review-requeue' => 'Treuzkas ar bajenn-mañ davet ar lostennad da-heul :',
	'deletequeue-review-dequeue' => 'Chom hep ober netra, ha lemel ar bajenn eus al lostad dilemel.',
	'deletequeue-review-reason' => 'Addisplegoù :',
	'deletequeue-review-newreason' => 'Abeg nevez :',
	'deletequeue-review-newextra' => 'Titouroù ouzhpenn :',
	'deletequeue-review-submit' => 'Enrollañ an adweladenn',
	'deletequeue-review-original' => 'Abeg da lakaat war ar renk',
	'deletequeue-actiondisabled-involved' => "Diweredekaet eo an ober da-heul en degouezh-mañ peogwir hoc'h eus kemeret perzh en diverkadenn evel $1 :",
	'deletequeue-actiondisabled-notexpired' => "Diweredekaet eo an ober da-heul peogwir n'eo ket aet d'he zermen an enskrivadenn d'an diverkadenn evit c'hoazh :",
	'deletequeue-review-badaction' => "Un obererezh fall hoc'h eus dibabet",
	'deletequeue-review-actiondenied' => "Meneget hoc'h eus un obererezh hag a zo diweredekaet evit ar bajenn-mañ.",
	'deletequeue-review-objections' => "'''Diwallit''' : [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} Soñjoù a-enep] diverkañ ar bajenn-mañ zo.
Bezit sur da vezañ priziet ar soñjoù-se a-raok kas an diverkadenn da benn.",
	'deletequeue-reviewspeedy-tab' => 'Gwiriañ an dilamadenn brim',
	'deletequeue-reviewspeedy-title' => 'Adwelet dilammadenn prim "$1"',
	'deletequeue-reviewspeedy-text' => "Implijout ar furmskrid-mañ a c'hallit ober evit adwelet enskrivadur \"'''\$1'''\" en un diverkadenn brim.
Gwiriit mat e c'hall ar bajenn-mañ bezañ diverket raktal hervez reolennoù ar raktres.",
	'deletequeue-reviewprod-tab' => 'Adwelet an dilamadurioù kinniget',
	'deletequeue-reviewprod-title' => 'Adwelet an dilammadenn kinniget evit "$1"',
	'deletequeue-reviewprod-text' => "Gallout a rit implijout ar furmskrid-mañ evit adwelet ar c'hinnig diverkañ \"'''\$1'''\" n'eus bet savet den a-enep dezhañ.",
	'deletequeue-reviewdeletediscuss-tab' => 'Adwelet an dilammadenn',
	'deletequeue-reviewdeletediscuss-title' => 'Adwelet ar gaozeadenn war an dilamadenn eus "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Gallout a rit ober gant ar furmskrid-mañ evit adwelet ar gaoz diwar-benn diverkañ \"'''\$1'''\".

Ur [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} roll] eus ar soñjoù a-du hag a-enep diverkañ a c'haller da gaout hag emañ ar c'haozeadennoù war [[\$2]].
Bezit sur emañ ho tiviz diouzh ar c'henasant deuet war wel da-heul ar gaozeadenn.",
	'deletequeue-review-success' => "Adwelet hoc'h eus dilammadenn ar bajenn",
	'deletequeue-review-success-title' => 'Graet eo bet an adweladenn',
	'deletequeue-deletediscuss-discussionpage' => 'Ur bajenn gaozeal diwar-benn diverkadenn [[$1]] eo ar bajenn-mañ.
Evit ar poent ez eus $2 {{PLURAL:$2|implijer|implijer}} o sevel a-du gant an diverkañ ha $3 {{PLURAL:$3|implijer|implijer}} o sevel a-enep.
Gallout a rit [{{fullurl:$1|action=delvote}} harpañ pe sevel a-enep] an diverkañ pe [{{fullurl:$1|action=delviewvotes}} sellet ouzh an holl aprouadennoù ha soñjoù kontrol].',
	'deletequeue-discusscreate-summary' => 'Ho krouiñ ar gaozeadenn diwar-benn dilamadenn [[$1]].',
	'deletequeue-discusscreate-text' => 'Dilammadenn kinniget evit an abeg-mañ : $2',
	'deletequeue-role-nominator' => 'deraouer orin an dilammadenn',
	'deletequeue-role-vote-endorse' => 'den a-du gant an dilemel',
	'deletequeue-role-vote-object' => "enebour d'an dilemel",
	'deletequeue-vote-tab' => 'Votiñ diwar-benn an dilammadenn',
	'deletequeue-vote-title' => 'Aprouiñ pe enebiñ ouzh dilammadenn "$1"',
	'deletequeue-vote-text' => "Gallout a rit ober gant ar furmskrid-mañ da aprouiñ pe da sevel a-enep diverkañ \"'''\$1'''\".
Flastrañ a raio an oberiadenn-mañ kement aprouadenn pe enebadenn embannet ganeoc'h a-raok war ar fed da ziverkañ ar bajenn-mañ.
Gallout a rit [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} gwelet] an aprouadennoù hag enebadennoù bet embannet c'hoazh.
''\$2'' a oa an abeg lakaet evit an anvadenn pe an diverkadenn.",
	'deletequeue-vote-legend' => 'Aprouiñ pe enebiñ ouzh an diverkañ',
	'deletequeue-vote-action' => 'Kuzulioù :',
	'deletequeue-vote-endorse' => 'Aprouiñ a ra an diverkañ.',
	'deletequeue-vote-object' => 'Enebiñ a ra ouzh an diverkañ.',
	'deletequeue-vote-reason' => 'Evezhiadennoù :',
	'deletequeue-vote-submit' => 'Kas',
	'deletequeue-vote-success-endorse' => "Aprouet hoc'h eus dilammadenn ar bajenn-mañ.",
	'deletequeue-vote-success-object' => "Enebet oc'h ouzh dilammadenn ar bajenn-mañ.",
	'deletequeue-vote-requeued' => "Savet oc'h a-enep d'ar goulenn diverkañ ar bajenn-mañ, hag ar gwir zo bet roet deoc'h.
Abalamour d'hoc'h abegadenn eo bet kaset ar bajenn d'al lostennad $1.",
	'deletequeue-showvotes' => 'Asantoù hag eneboù d\'an dilamadenn eus "$1"',
	'deletequeue-showvotes-text' => "Setu aze an aprouadennoù hag an abegadennoù renablet evit ar goulenn diverkañ ar bajenn \"'''\$1'''\".
Gallout a rit [{{FULLURL:{{FULLPAGENAME}}|action=delvote}} merkañ amañ] ho soñj deoc'h-c'hwi diwar-benn ar goulenn-mañ.",
	'deletequeue-showvotes-restrict-endorse' => 'Diskouez an aprouadennoù hepken',
	'deletequeue-showvotes-restrict-object' => 'Diskouez an enebadennoù hepken',
	'deletequeue-showvotes-restrict-none' => 'Diskouez an holl aprouadennoù hag enebadennoù',
	'deletequeue-showvotes-vote-endorse' => "'''Aprouet''' an diverkañ $2 d'an $1",
	'deletequeue-showvotes-vote-object' => "'''Enebet''' ouzh an diverkañ $2 d'an $1",
	'deletequeue-showvotes-showingonly-endorse' => 'Diskouez an asantoù hepken',
	'deletequeue-showvotes-showingonly-object' => 'Diskouez an enebadurioù hepken',
	'deletequeue-showvotes-none' => "N'en deus den nag asantet na nac'het dilammadenn ar bajenn-mañ.",
	'deletequeue-showvotes-none-endorse' => "N'eo savet den ebet a-du gant dilammadenn ar bajenn-mañ.",
	'deletequeue-showvotes-none-object' => "N'eo savet den ebet a-enep gant dilammadenn ar bajenn-mañ.",
	'deletequeue' => 'Steudad dilemel',
	'deletequeue-list-text' => 'Ar bajenn-mañ a ziskouez an holl bajennoù hag a zo en steudad dilemel.',
	'deletequeue-list-search-legend' => 'Klask pajennoù',
	'deletequeue-list-queue' => 'Lostennad :',
	'deletequeue-list-status' => 'Statud :',
	'deletequeue-list-expired' => 'Diskouez hepken an anvadurioù zo da vezañ serret.',
	'deletequeue-list-search' => 'Klask',
	'deletequeue-list-anyqueue' => '(forzh pehini)',
	'deletequeue-list-votes' => 'Roll votoù',
	'deletequeue-list-votecount' => "$1 asant{{PLURAL:$1||}}, $2 nac'h{{PLURAL:$2||}}",
	'deletequeue-list-header-page' => 'Pajenn',
	'deletequeue-list-header-queue' => 'Lostad',
	'deletequeue-list-header-votes' => 'Aprouadennoù hag enebadennoù',
	'deletequeue-list-header-expiry' => 'Termen',
	'deletequeue-list-header-discusspage' => 'Pajenn gaozeal',
	'deletequeue-case-intro' => 'Bodañ a ra ar bajenn-mañ an titouroù a-zivout un diverkadenn resis.',
	'deletequeue-list-header-reason' => 'Abeg diverkañ :',
	'deletequeue-case-votes' => 'A-du/a-enep :',
	'deletequeue-case-title' => 'Munudoù an dilammadenn',
	'deletequeue-case-details' => 'Titouroù diazez',
	'deletequeue-case-page' => 'Pajenn :',
	'deletequeue-case-reason' => 'Abeg :',
	'deletequeue-case-expiry' => 'Termen :',
	'deletequeue-case-needs-review' => 'Rankout a ra an darvoud-mañ bezañ [[$1|adwelet]].',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'deletequeue-desc' => 'Kreira [[Special:DeleteQueue|sistem zasnovan na redu za čekanje za upravljanje brisanjem]]',
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
	'deletequeue-prod-text' => "Možete koristiti ovaj obrazac za predlaganje stranice \"'''\$1'''\" za brisanje.

Ako, nakon pet dana, niko ne bude imao sugestija za brisanje ove stranice, ona će biti obrisana nakon posljednjeg pregleda od strane administratora.",
	'deletequeue-delnom-reason' => 'Razlog za nominaciju:',
	'deletequeue-delnom-otherreason' => 'Ostali razlozi',
	'deletequeue-delnom-extra' => 'Dodane informacije:',
	'deletequeue-delnom-submit' => 'Pošalji nominaciju',
	'deletequeue-log-nominate' => "nominirana stranica [[$1]] za brisanje u redu za čekanje '$2'.",
	'deletequeue-log-dequeue' => "uklonjena [[$1]] iz reda za brisanje '$2'.",
	'right-speedy-nominate' => 'Nominiranje stranica za brzo brisanje',
	'right-speedy-review' => 'Pregled prijedloga za brzo brisanje',
	'right-prod-nominate' => 'Predlaganje brisanja stranice',
	'right-deletediscuss-nominate' => 'Započinjanje razgovora o brisanju',
	'right-deletediscuss-review' => 'Zatvaranje diskusija o brisanju',
	'deletequeue-queue-speedy' => 'Brzo brisanje',
	'deletequeue-queue-prod' => 'Predloženo brisanje',
	'deletequeue-queue-deletediscuss' => 'Brisanje razgovora',
	'deletequeue-notqueued' => 'Stranica koju ste odabrali trenutno nije u redu za brisanje',
	'deletequeue-review-action' => 'Akcija koja se preduzima:',
	'deletequeue-review-delete' => 'Brisanje stranice.',
	'deletequeue-review-requeue' => 'Prebaci ovu stranicu u slijedeći red:',
	'deletequeue-review-dequeue' => 'Ne radi ništa i ukloni stranicu iz reda za brisanje.',
	'deletequeue-review-reason' => 'Komentari:',
	'deletequeue-review-newreason' => 'Novi razlog:',
	'deletequeue-review-newextra' => 'Dodatne informacije:',
	'deletequeue-review-submit' => 'Sačuvaj pregled',
	'deletequeue-review-original' => 'Razlog za nominaciju',
	'deletequeue-actiondisabled-notexpired' => 'Slijedeća akcija je onemogućena jer prijedlog za brisanje još nije istekao:',
	'deletequeue-review-badaction' => 'Naveli ste nevaljanu akciju',
	'deletequeue-review-actiondenied' => 'Naveli ste akciju koja je onemogućena na ovoj stranici',
	'deletequeue-role-nominator' => 'prvobitni predlagač brisanja',
	'deletequeue-vote-tab' => 'Glasanje o brisanju',
	'deletequeue-vote-action' => 'Preporuke:',
	'deletequeue-vote-reason' => 'Komentari:',
	'deletequeue-vote-submit' => 'Pošalji',
	'deletequeue-list-search-legend' => 'Pretraga stranica',
	'deletequeue-list-queue' => 'Red:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Traži',
	'deletequeue-list-anyqueue' => '(bilo koji)',
	'deletequeue-list-votes' => 'Spisak glasova',
	'deletequeue-list-header-page' => 'Stranica',
	'deletequeue-list-header-queue' => 'Red',
	'deletequeue-list-header-expiry' => 'Istek',
	'deletequeue-list-header-discusspage' => 'Stranica za razgovor',
	'deletequeue-list-header-reason' => 'Razlog za brisanje',
	'deletequeue-case-details' => 'Osnovni detalji',
	'deletequeue-case-page' => 'Stranica:',
	'deletequeue-case-reason' => 'Razlog:',
	'deletequeue-case-expiry' => 'Ističe:',
);

/** Catalan (Català)
 * @author Loupeter
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'deletequeue-desc' => "Crea un [[Special:DeleteQueue|sistema de coa per gestionar l'eliminació de pàgines]]",
	'deletequeue-action-queued' => 'Supressió',
	'deletequeue-generic-reasons' => '* Motius genèrics
** Vandalisme
** Publicitat
** Manteniment
** Fora dels objectius del projecte',
	'deletequeue-speedy-title' => 'Marqueu "$1" per a supressió ràpida',
	'deletequeue-delnom-otherreason' => 'Un altre motiu',
	'deletequeue-delnom-extra' => 'Informació addicional:',
	'deletequeue-delnom-submit' => 'Presentar candidatura',
	'deletequeue-queue-speedy' => 'Supressió ràpida',
	'deletequeue-queue-deletediscuss' => "Discussió d'esborrat",
	'deletequeue-review-reason' => 'Comentaris:',
	'deletequeue-vote-reason' => 'Comentaris:',
	'deletequeue-vote-submit' => 'Tramet',
	'deletequeue-list-search-legend' => 'Cerca pàgines',
	'deletequeue-list-queue' => 'Cua:',
	'deletequeue-list-status' => 'Estat:',
	'deletequeue-case-reason' => 'Motiu:',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'deletequeue-list-search-legend' => 'Лаха агIонашца',
	'deletequeue-list-search' => 'Лаха',
	'deletequeue-case-reason' => 'Бахьан:',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'deletequeue-delnom-otherreason' => 'هۆکاری دیکە',
	'deletequeue-vote-submit' => 'ناردن',
	'deletequeue-list-search' => 'گەڕان',
	'deletequeue-case-reason' => 'هۆکار:',
);

/** Czech (Česky)
 * @author Jkjk
 */
$messages['cs'] = array(
	'deletequeue-desc' => 'Vytvoří [[Special:DeleteQueue|na frontách založený systém na správu mazání]]',
	'deletequeue-action-queued' => 'Smazání',
	'deletequeue-action' => 'Navrhnout smazání',
	'deletequeue-action-title' => 'Navrhnou smazání "$1"',
	'deletequeue-delnom-reason' => 'Důvod návrhu:',
	'deletequeue-delnom-otherreason' => 'Jiný důvod',
	'deletequeue-delnom-extra' => 'Další informace:',
	'deletequeue-delnom-submit' => 'Odeslat návrh',
	'deletequeue-log-nominate' => ' navrhl [[$1]]  na smazání ve frontě „$2”.',
	'deletequeue-log-rmspeedy' => 'zamítl rychlé smazání [[$1]].',
	'deletequeue-log-requeue' => 'přesunul [[$1]] do jiné fronty mazání: z „$2” do „$3”.',
	'deletequeue-log-dequeue' => 'odstranil [[$1]] z fronty mazání „$2”.',
	'right-speedy-nominate' => 'Navrhout stránky na rychlé smazání',
	'right-speedy-review' => 'Posuzovat návrhy na rychlé smazání',
	'right-prod-nominate' => 'Navrhnout smazání stránky',
	'right-prod-review' => 'Posouzovat návrhy na smazání bez nesouhlasu',
	'right-deletediscuss-nominate' => 'Vytvořit diskuzi o smazání',
	'right-deletediscuss-review' => 'Uzavřít diskuzi o smazání',
	'right-deletequeue-vote' => 'Doporučit nebo nesouhlasit se smazáním',
	'deletequeue-queue-speedy' => 'Rychlé smazání',
	'deletequeue-queue-prod' => 'Navrhované smazání',
	'deletequeue-queue-deletediscuss' => 'Diskuze o smazání',
	'deletequeue-page-speedy' => "Tato stránka byla navržena na rychlé smazání.
Jako důvod návrh byu uveden  ''$1''.",
	'deletequeue-notqueued' => 'Stránka, kterou jste vybrali nyní není ve frontě na smazání',
	'deletequeue-review-action' => 'Vykonat:',
	'deletequeue-review-delete' => 'Smazat stránku.',
	'deletequeue-review-change' => 'Smazat tuto stránku, ale s jiným zdůvodněním.',
	'deletequeue-review-requeue' => 'Přenést tuto stránku do následující fronty:',
	'deletequeue-review-dequeue' => 'Nic nedělat a odstranit stránku z fronty na smazání.',
	'deletequeue-review-reason' => 'Komentáře:',
	'deletequeue-review-newreason' => 'Nový důvod:',
	'deletequeue-review-newextra' => 'Další informace:',
	'deletequeue-review-original' => 'Důvod návrhu',
	'deletequeue-actiondisabled-notexpired' => 'Následující akce není možná, protože návrh na smazání ještě nevypršel:',
	'deletequeue-review-badaction' => 'Zadali jste neplatnou akci',
	'deletequeue-review-actiondenied' => 'Zadali jste akci, která je pro tuto stránku vypnuta',
	'deletequeue-reviewspeedy-tab' => 'Posoudit rychlé smazání',
	'deletequeue-reviewspeedy-title' => 'Posoudit návrh na rychlé smazání „$1”',
	'deletequeue-reviewprod-tab' => 'Posoudit navržené smazání',
	'deletequeue-reviewprod-title' => 'Posoudit navržené smazání „$1”',
	'deletequeue-reviewprod-text' => "Můžete použit tento formulár na posouzení návrhu na smazání \"'''\$1'''\" bez nesouhlasu.",
	'deletequeue-reviewdeletediscuss-tab' => 'Posoudit smazání',
	'deletequeue-reviewdeletediscuss-title' => 'Posoudit diskuzi o smazání „$1”',
	'deletequeue-review-success' => 'Úspěšně jste pousoudili smazání této stránky',
	'deletequeue-review-success-title' => 'Posouzení dokončeno',
	'deletequeue-discusscreate-summary' => 'Vytvoření diskuze o smazání [[$1]].',
	'deletequeue-discusscreate-text' => 'Smazání bylo navrhnuto z následujícího důvodu: $2',
	'deletequeue-role-nominator' => 'původní navrhovatel smazání',
	'deletequeue-role-vote-endorse' => 'podporovatel smazání',
	'deletequeue-role-vote-object' => 'odpůrce smazání',
	'deletequeue-vote-tab' => 'Volba v tomto smazání',
	'deletequeue-vote-title' => 'Souhlasit nebo nesouhlasit se smazáním "$1"',
	'deletequeue-vote-legend' => 'Souhlasit/nesouhlasit se smazáním',
	'deletequeue-vote-action' => 'Doporučení:',
	'deletequeue-vote-endorse' => 'Souhlasit se smazáním.',
	'deletequeue-vote-object' => 'Nesouhlasit se smazáním.',
	'deletequeue-vote-reason' => 'Komentáře:',
	'deletequeue-vote-submit' => 'Odeslat',
	'deletequeue-vote-success-endorse' => 'Podpořili jste smazání této stránky.',
	'deletequeue-vote-success-object' => 'Nesouhlasili jste se smazáním této stránky.',
	'deletequeue-vote-requeued' => 'Nesouhlasili jste se smazáním této stránky.
Vzhledem k vašemu nesouhlasu byla stránka přesunuta do fronty $1.',
	'deletequeue-showvotes' => 'Souhlasy a nesouhlasy se smazáním "$1"',
	'deletequeue-showvotes-restrict-endorse' => 'Zobrazit jen souhlasy',
	'deletequeue-showvotes-restrict-object' => 'Zobrazit jen nesouhlasy',
	'deletequeue-showvotes-restrict-none' => 'Zobrazit všechny souhlasy a nesouhlasy',
	'deletequeue-showvotes-vote-endorse' => '"Schválená" smazání na $1 $2',
	'deletequeue-showvotes-vote-object' => '"Nesouhlasil" se smazáním na $1 $2',
	'deletequeue-showvotes-showingonly-endorse' => 'Zobrazují se jen souhlasy',
	'deletequeue-list-queue' => 'Zvolená fronta:',
	'deletequeue-list-status' => 'Stav:',
	'deletequeue-list-search' => 'Hledat',
	'deletequeue-list-header-page' => 'Stránka',
	'deletequeue-list-header-queue' => 'Zvolená fronta',
	'deletequeue-list-header-expiry' => 'Čas vypršení',
	'deletequeue-list-header-reason' => 'Zdůvodnění smazání',
	'deletequeue-case-page' => 'Stránka:',
	'deletequeue-case-reason' => 'Důvod:',
	'deletequeue-case-expiry' => 'Čas vypršení:',
);

/** Danish (Dansk)
 * @author Lhademmor
 */
$messages['da'] = array(
	'deletequeue-action-queued' => 'Sletning',
	'deletequeue-action' => 'Foreslå sletning',
	'deletequeue-action-title' => 'Foreslå sletning af "$1"',
	'deletequeue-permissions-noedit' => 'Du skal kunne redigere en side for at kunne påvirke dens sletningsstatus.',
	'deletequeue-nom-alreadyqueued' => 'Denne side er allerede i en sletningskø.',
	'deletequeue-speedy-title' => 'Marker "$1" til hurtig sletning',
	'deletequeue-prod-title' => 'Foreslå sletning af "$1"',
	'deletequeue-delnom-reason' => 'Begrundelse for nominering:',
	'deletequeue-delnom-otherreason' => 'Anden grund',
	'deletequeue-delnom-extra' => 'Ekstra information:',
	'deletequeue-delnom-submit' => 'Indsend nominering',
	'deletequeue-log-nominate' => "nominerede [[$1]] til sletning i køen '$2'.",
	'deletequeue-log-rmspeedy' => 'afviste at hurtigslette [[$1]].',
	'deletequeue-log-requeue' => "overførte [[$1]] til en anden sletningskø: fra '$2' til '$3'.",
	'deletequeue-log-dequeue' => "fjernede [[$1]] fra sletningskøen '$2'.",
	'right-speedy-nominate' => 'Nominer sider til hurtigsletning',
	'right-speedy-review' => 'Gennemse nomineringer til hurtigsletning',
	'right-prod-nominate' => 'Foreslå sletning af side',
	'right-deletediscuss-nominate' => 'Start sletningsdiskussioner',
	'right-deletediscuss-review' => 'Luk sletningsdiskussioner',
	'right-deletequeue-vote' => 'Støt eller indvend mod sletninger',
	'deletequeue-queue-speedy' => 'Hurtigsletning',
	'deletequeue-queue-prod' => 'Foreslået sletning',
	'deletequeue-queue-deletediscuss' => 'Sletningsdiskussion',
	'deletequeue-page-speedy' => "Denne side er blevet nomineret til hurtigsletning.
Grunden givet til denne sletning er ''$1''.",
	'deletequeue-review-action' => 'Handling:',
	'deletequeue-review-delete' => 'Slet siden.',
	'deletequeue-review-change' => 'Slet denne side, men med en anden begrundelse.',
	'deletequeue-review-requeue' => 'Overfør denne side til den følgende kø:',
	'deletequeue-review-dequeue' => 'Gør intet, og fjern siden fra sletningskøen.',
	'deletequeue-review-reason' => 'Kommentarer:',
	'deletequeue-review-newreason' => 'Ny begrundelse:',
	'deletequeue-review-newextra' => 'Ekstra information:',
	'deletequeue-review-original' => 'Begrundelse for nominering',
	'deletequeue-review-badaction' => 'Du angav en ugyldig handling',
	'deletequeue-role-vote-endorse' => 'støtter sletning',
	'deletequeue-role-vote-object' => 'modsætter sig sletning',
	'deletequeue-vote-tab' => 'Stem om sletningen',
	'deletequeue-vote-title' => 'Støt eller indvend mod sletningen af "$1"',
	'deletequeue-vote-legend' => 'Støt/indvend mod sletning',
	'deletequeue-vote-endorse' => 'Støt sletning.',
	'deletequeue-vote-object' => 'Modsæt dig sletning.',
	'deletequeue-vote-reason' => 'Kommentarer:',
	'deletequeue-vote-submit' => 'Indsend',
	'deletequeue-vote-success-endorse' => 'Du har støttet sletningen af denne side.',
	'deletequeue-vote-success-object' => 'Du har modsat dig sletningen af denne side.',
	'deletequeue-vote-requeued' => 'Du har modsat dig sletningen af denne side.
På grund af din indvending er siden blevet flyttet til køen $1.',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author ChrisiPK
 * @author Imre
 * @author Kghbln
 * @author Umherirrender
 */
$messages['de'] = array(
	'deletequeue-desc' => 'Ermöglicht ein auf einer [[Special:DeleteQueue|Auftragswarteschlange]] basierendes System zu Verwaltung von Löschungen',
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
Wenn hiergegen bis zum ''$3, $4 Uhr'' kein Widerspruch eingelegt wird, wird diese Seite gelöscht werden.
Du kannst gegen diesen Löschantrag [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Widerspruch einlegen].",
	'deletequeue-page-deletediscuss' => "Diese Seite wurde zur Löschung vorgeschlagen und hiergegen wurde Widerspruch eingelegt.
Der angegebene Grund lautet ''$1''.
Die [[$5|Löschdiskussion]] läuft noch bis zum ''$3, $4 Uhr''.",
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
	'deletequeue-vote-submit' => 'Speichern',
	'deletequeue-vote-success-endorse' => 'Du hast erfolgreich die Löschung dieser Seite befürwortet.',
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
	'deletequeue-case-reason' => 'Grund:',
	'deletequeue-case-expiry' => 'Ablaufdatum:',
	'deletequeue-case-needs-review' => 'Dieser Fall braucht eine [[$1|Überprüfung]].',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'deletequeue-action-text-queued' => 'Sie können die folgenden Seiten für den Löschantrag aufrufen:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Pros und Contras].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Stimme zu diesem Löschantrag abgeben].',
	'deletequeue-permissions-noedit' => 'Sie müssen eine Seite bearbeiten können, um ihren Löschstatus zu verändern.',
	'deletequeue-speedy-text' => "Auf dieser Seite können Sie „'''$1'''“ zur Schnelllöschung vorschlagen.

Ein Administrator wird den Antrag begutachten und, wenn er gut begründet ist, die Seite löschen.
Sie müssen einen Löschgrund aus dem untenstehenden Dropdown-Menü auswählen und alle weiteren relevanten Informationen hinzufügen.",
	'deletequeue-prod-text' => "Auf dieser Seite können Sie „'''$1'''“ zur Löschung vorschlagen.

Wenn nach fünf Tagen niemand Einspruch gegen die Löschung eingelegt hat, wird die Seite nach Begutachtung durch einen Administrator gelöscht.",
	'deletequeue-page-prod' => "Diese Seite wurde zur Löschung vorgeschlagen.
Der angegebene Grund lautet ''$1''.
Wenn hiergegen bis zum ''$3, $4 Uhr'' kein Widerspruch eingelegt wird, wird diese Seite gelöscht werden.
Sie können gegen diesen Löschantrag [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Widerspruch einlegen].",
	'deletequeue-notqueued' => 'Die von Ihnen ausgewählte Seite ist momentan in keiner Lösch-Warteschlange',
	'deletequeue-actiondisabled-involved' => 'Die folgende Aktion ist deaktiviert, weil Sie in dieser Löschsache bereits als $1 teilgenommen haben:',
	'deletequeue-review-badaction' => 'Sie haben eine ungültige Aktion angegeben',
	'deletequeue-review-actiondenied' => 'Sie haben eine Aktion angegeben, die für diese Seite deaktiviert ist',
	'deletequeue-review-objections' => "'''Warnung''': Gegen die Löschung dieser Seite wurde [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} Widerspruch eingelegt].
Bitte prüfen Sie die Widerspruchs-Argumente, bevor Sie diese Seite löschen.",
	'deletequeue-reviewspeedy-text' => "Auf dieser Seite können Sie den Schnelllöschantrag für „'''$1'''“ überprüfen.
Bitte stellen Sie sicher, dass diese Seite in Übereinstimmung mit den Richtlinien schnellgelöscht werden kann.",
	'deletequeue-reviewprod-text' => "Auf dieser Seite können Sie den unumstrittenen Löschantrag für „'''$1'''“ prüfen.",
	'deletequeue-reviewdeletediscuss-text' => "Auf dieser Seite können Sie die Löschdiskussion von „'''$1'''“ prüfen.

Es gibt eine [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Liste] mit Stimmen für und gegen die Löschung; die eigentliche Diskussion ist unter [[$2]] zu finden.
Bitte achten Sie darauf, dass Ihre Entscheidung mit dem Konsens der Diskussion vereinbar ist.",
	'deletequeue-review-success' => 'Sie haben erfolgreich die Löschung dieser Seite geprüft',
	'deletequeue-deletediscuss-discussionpage' => 'Dies ist die Diskussionsseite für die Löschung von [[$1]].
Momentan {{PLURAL:$2|unterstützt ein|unterstützen $2}} Benutzer die Löschung, während $3 Benutzer sie ablehnen.
Sie können die Löschung [{{fullurl:$1|action=delvote}} befürworten oder ablehnen] oder [{{fullurl:$1|action=delviewvotes}} alle Stimmen ansehen].',
	'deletequeue-vote-text' => "Auf dieser Seite können Sie die Löschung von „'''$1'''“ befürworten oder ablehnen.
Diese Aktion überschreibt alle Stimmen, die Sie vorher zur Löschung dieser Seite abgegeben haben.
Sie können die bereits abgegebenen Stimmen [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ansehen].
Der Löschantragsgrund war ''$2''.",
	'deletequeue-vote-success-endorse' => 'Sie haben erfolgreich die Löschung dieser Seite befürwortet.',
	'deletequeue-vote-success-object' => 'Sie haben erfolgreich die Löschung dieser Seite abgelehnt.',
	'deletequeue-vote-requeued' => 'Sie haben erfolgreich die Löschung dieser Seite abgelehnt.
Durch Ihren Widerspruch wurde die Seite in die Lösch-Warteschlange $1 verschoben.',
	'deletequeue-showvotes-text' => "Untenstehend sind die Befürwortungen und Ablehnungen der Löschung von „'''$1'''“.
Sie können Ihre eigene Befürwortung oder Ablehnung der Löschung [{{fullurl:{{FULLPAGENAME}}|action=delvote}} hier] eintragen.",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'deletequeue-desc' => 'Napórajo [[Special:DeleteQueue|system za zastojanje wulašowanjow na zakłaźe cakajucego rěda]]',
	'deletequeue-action-queued' => 'Wulašowanje',
	'deletequeue-action' => 'Wulašowanje naraźiś',
	'deletequeue-action-title' => 'Wulašowanje boka "$1" naraźiś',
	'deletequeue-action-text' => "Toś ten wiki ma licbu procesow za lašowanje bokow:
*Jolic wěriš, až toś ten bok jo wobpšawja, móžoš [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} jen za ''spěšne wulašowanje'' naraźiś].
*Jolic toś ten bok njewobpšawja spěšne wulašowanje, ale ''wulašowanje by nejskerjej njezwadne'', ty by měł [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} pśipoznate wulašowanje naraźiś].
*Jolic wulašowanje toś togo boka se ''nejskerjej wóteprěwa'', ty by měł [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} diskusiju wótwóriś].",
	'deletequeue-action-text-queued' => 'Móžoš se slědujuce boki za toś ten lašowański pad woglědaś:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Aktualne pódpěranja a znapśeśiwjenja se woglědaś].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Wulašowanje toś togo boka pódprěś abo wótpokazaś].',
	'deletequeue-permissions-noedit' => 'Musyš bok wobźěłaś móc, aby wobwliwował jogo lašowański status.',
	'deletequeue-generic-reasons' => '* Powšykne pśicyny
  ** Wandalizm
  ** Spam
  ** Wótwardowanje
  ** Zwenka projektowego cela',
	'deletequeue-nom-alreadyqueued' => 'Toś ten bok jo južo w lašowańskem cakajucem rěźe.',
	'deletequeue-speedy-title' => '"$1" za spěšne wulašowanje markěrowaś',
	'deletequeue-speedy-text' => "Móžoš toś ten formular wužywaś, aby markěrował bok \"'''\$1'''\" za spěšne wulašowanje.

Administrator buźo toś to pominanje pśekontrolěrowaś a, jolic jo wopšawnjone, bok wulašowaś.
Musyš z padajuceje lisćiny dołojce pśicynu za wulašowanje wubraś a druge relewantne informacije pśidaś.",
	'deletequeue-prod-title' => 'Wulašowanje boka "$1" naraźiś',
	'deletequeue-prod-text' => "Móžoš toś ten formular wužywaś, aby naraźił, až by se \"'''\$1'''\" wulašował.

Jolic pó pěś dnjach nichten njejo wótpokazał wulašowanje boka, buźo se pó dokóńcnem pśeglědanju pśez administratora lašowaś.",
	'deletequeue-delnom-reason' => 'Pśicyna za lašowańske póžedanje:',
	'deletequeue-delnom-otherreason' => 'Druga pśicyna',
	'deletequeue-delnom-extra' => 'Pśidatne informacije:',
	'deletequeue-delnom-submit' => 'Póžedanje stajiś',
	'deletequeue-log-nominate' => "jo naraźił [[$1]] za wulašowanje w cakajucem rěźe '$2'.",
	'deletequeue-log-rmspeedy' => 'jo spěšne wulašowanje za [[$1]] wótpokazał.',
	'deletequeue-log-requeue' => "Jo pśenjasł [[$1]] do drugego lašowańskego cakajucego rěda: wót '$2' do '$3'.",
	'deletequeue-log-dequeue' => "jo wótpórał [[$1]] z lašowańskego cakajucego rěda '$2'.",
	'right-speedy-nominate' => 'Boki za spěšne wulašowanje naraźiś',
	'right-speedy-review' => 'Póžedanja za spěšne wulašowanje pśeglědaś',
	'right-prod-nominate' => 'Bok za wulašowanje naraźiś',
	'right-prod-review' => 'Pśipóznate naraźenja za wulašowanje pśeglědaś',
	'right-deletediscuss-nominate' => 'Lašowańske diskusije zachopiś',
	'right-deletediscuss-review' => 'Lašowańske diskusije skóńcyś',
	'right-deletequeue-vote' => 'Wulašowanja pódprěś abo wótpokazaś',
	'deletequeue-queue-speedy' => 'Spěšne wulašowanje',
	'deletequeue-queue-prod' => 'Naraźone wulašowanje',
	'deletequeue-queue-deletediscuss' => 'Lašowańska diskusija',
	'deletequeue-page-speedy' => "Toś ten bok jo se za spěšne wulašowanje naraźił.
Pódana pśicyna za toś to wulašowanje jo ''$1''.",
	'deletequeue-page-prod' => "Jo se naraźiło, až ten bok se lašujo.
Pódana pśicyna jo była ''$1''.
Jolic toś to naraźenje jo ''$2'' píspóznate, toś ten bok buźo se lašowaś.
Móžoš wulašowanje toś togo boka pśez [{{fullurl:{{FULLPAGENAME}}|action=delvote}} wótpokazowanje wulašowanja] wóteprěś.",
	'deletequeue-page-deletediscuss' => "Toś ten bok jo se naraźił za wulašowanje a to naraźenje jo se spśeśiwił.
Pódana pśicyna jo była ''$1''.
Diskusija wó boku [[$5]] běžy, kótaraž skóńcyjo se ''$2''.",
	'deletequeue-notqueued' => 'Bok, kótaryž sy wubrał, njejo tuchylu w cakajucem rěźe za wulašowanje',
	'deletequeue-review-action' => 'Akcija, kótaraž ma se wuwjasć:',
	'deletequeue-review-delete' => 'Bok wulašowaś.',
	'deletequeue-review-change' => 'Toś ten bok lašowaś, ale z drugim wobtwarźenim.',
	'deletequeue-review-requeue' => 'Toś ten bok do slědujucego cakajucego rěda pśenjasć:',
	'deletequeue-review-dequeue' => 'Žednu akciju wuwjasć a bok z lašowańskego cakajucego rěda wótpóraś.',
	'deletequeue-review-reason' => 'Komentary:',
	'deletequeue-review-newreason' => 'Nowa pśicyna:',
	'deletequeue-review-newextra' => 'Pśidatne informacije:',
	'deletequeue-review-submit' => 'Pśeglědanje składowaś',
	'deletequeue-review-original' => 'Pśicyna za póžedanje',
	'deletequeue-actiondisabled-involved' => 'Slědujuca akcija jo znjemóžnjona, dokulaž sy južo wobźělił na toś tom wulašenju ako $1:',
	'deletequeue-actiondisabled-notexpired' => 'Slědujuca akcija jo znjemóžnjona, dokulaž lašowańske póžedanje hyšći njejo pśepadnjone:',
	'deletequeue-review-badaction' => 'Sy pódał njepłaśiwu akciju',
	'deletequeue-review-actiondenied' => 'Sy pódał akciju, kótaraž jo za toś ten bok znjemóžnjona.',
	'deletequeue-review-objections' => "'''Warnowanje''': Wulašowanje toś togo boka ma [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} znapśeśiwjenja].
Pšosym pśeznań se, až sy źiwał na toś te znapśeśiwjenja, pjerwjej až lašujoš toś ten bok.",
	'deletequeue-reviewspeedy-tab' => 'Spěšne wulašowanje pśeglědaś',
	'deletequeue-reviewspeedy-title' => 'Póžedanje za spěšne wulašowanje boka "$1" pśeglědaś',
	'deletequeue-reviewspeedy-text' => "Móžoš toś ten formular wužywaś, aby pśeglědał póžedanje za spěšne wulašowanje za \"'''\$1'''\".
Pšosym pśeznań se, až toś ten bok móžo se pó zasadach spěšnje lašowaś.",
	'deletequeue-reviewprod-tab' => 'Naraźone wulašowanje pśeglědaś',
	'deletequeue-reviewprod-title' => 'Naraźone wulašowanje boka "$1" pśeglědaś',
	'deletequeue-reviewprod-text' => "Móžoš toś ten formular wužywaś, aby pśeglědał pśipóznate naraźenje za wulašowanje boka \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Wulašowanje pśeglědaś',
	'deletequeue-reviewdeletediscuss-title' => 'Lašowańsku diskusiju za "$1" pśeglědaś',
	'deletequeue-reviewdeletediscuss-text' => "Móžoš toś ten formular wužywaś, aby lašowańsku diskusiju boka \"'''\$1'''\" pśeglědaś.

[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Lisćina] pódpěranjow a wótpokazanjow toś togo wulašowanja stoj k dispoziciji a diskusija sama dajo se na [[\$2]] namakaś.
Pšosym pśeznań se, až rozsuśijoš pó konsensu diskusije.",
	'deletequeue-review-success' => 'Sy wuspěšnje pśeglědał wulašowanje toś togo boka.',
	'deletequeue-review-success-title' => 'Pśeglědanje skóńcone',
	'deletequeue-deletediscuss-discussionpage' => 'To jo diskusijny bok za lašowanje boka [[$1]].
Tuchylu {{PLURAL:$2|jo $2 wužywaŕ|stej $2 wužiwarja|su $2 wužiwarje|jo $2 wužiwarjow}}, kótarež pódpěraju wulašowanje a $3 {{PLURAL:$3|wužiwaŕ|wužiwarja|wužiwarje|wužiwarjow}}, kótarež wótpokazuju wulašowanje.
Móžoš wulašowanje [{{fullurl:$1|action=delvote}} pódprěś abo wótpokazaś] abo [{{fullurl:$1|action=delviewvotes}} se wše pódpěranja a wótpokazanja woglědaś].',
	'deletequeue-discusscreate-summary' => 'Diskusija wó wulašowanju boka [[$1]] se zarědujo.',
	'deletequeue-discusscreate-text' => 'Wulašowanje jo se naraźiło ze slědujuceje pśicyny: $2',
	'deletequeue-role-nominator' => 'spócetny póžedaŕ wulašowanja',
	'deletequeue-role-vote-endorse' => 'Pódpěraŕ wulašowanja',
	'deletequeue-role-vote-object' => 'pśeśiwnik wulašowanja',
	'deletequeue-vote-tab' => 'Wó wulašowanju wótgłosowaś',
	'deletequeue-vote-title' => 'Wulašowanje boka "$1" pódprěś abo wótpokazaś',
	'deletequeue-vote-text' => "Móžoš toś ten formular wužywaś, aby pódpěrał abo wótpokazał wulašowanje \"'''\$1'''\".
Toś ta akcija buźo pjerwjejšne pódpěranja/znapśeśiwjenja pśepisowaś, kótarež sy gronił k wulašowanjeju toś togo boka.
Móžoš se eksistěrujuce pódpěranja a znapśeśiwjenja [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} woglědaś].
Pódana pśicyna w póžedanju za wulašowanje jo była ''\$2''.",
	'deletequeue-vote-legend' => 'Wulašowanje pódprěś/wótpokazaś',
	'deletequeue-vote-action' => 'Pórucenje:',
	'deletequeue-vote-endorse' => 'Wulašowanje pódprěś.',
	'deletequeue-vote-object' => 'Wulašowanje wótpokazaś.',
	'deletequeue-vote-reason' => 'Komentary:',
	'deletequeue-vote-submit' => 'Wótpósłaś',
	'deletequeue-vote-success-endorse' => 'Sy wuspěšnje pódprěł wulašowanje tós togo boka.',
	'deletequeue-vote-success-object' => 'Sy wuspěšnje wótpokazał wulašowanje toś togo boka.',
	'deletequeue-vote-requeued' => 'Sy wuspěšnje wótpokazał wulašowanje toś togo boka.
Pśez twójo wótpokazanje jo se bok do cakajucego rěda $1 psésunuł.',
	'deletequeue-showvotes' => 'Pódpěranja a znapśeśiwjenja za wulašowanje boka "$1"',
	'deletequeue-showvotes-text' => "Dołojce su pódpěranja a znapśeśiwjenja k wulašowanjeju boka \"'''\$1'''\".
Móžoš k toś tomu wulašowanjeju [{{fullurl:{{FULLPAGENAME}}|action=delvote}} swójo pódpěranje abo znapśeśiwjenje registrěrowaś].",
	'deletequeue-showvotes-restrict-endorse' => 'Jano pódpěranja pokazaś',
	'deletequeue-showvotes-restrict-object' => 'Jano wótpokazanje pokazaś',
	'deletequeue-showvotes-restrict-none' => 'Wšykne pódpěranja a znapśeśiwjenja pokazaś',
	'deletequeue-showvotes-vote-endorse' => "Wulašowanje $1 $2 '''pódprěte'''",
	'deletequeue-showvotes-vote-object' => "Wulašowanje $1 $2 '''wótpokazane'''",
	'deletequeue-showvotes-showingonly-endorse' => 'Jano pódpěranja se pokazuju',
	'deletequeue-showvotes-showingonly-object' => 'Jano znapśeśiwjenja se pokazuju',
	'deletequeue-showvotes-none' => 'Njejsu žedne pódpěranja abo znapśeśiwjenja k wulašowanjeju toś togo boka.',
	'deletequeue-showvotes-none-endorse' => 'Njejsu žedne pódpěranja wulašowanja toś togo boka.',
	'deletequeue-showvotes-none-object' => 'Njejsu žedne znapśeśiwjenja k wulašowanjeju toś togo boka.',
	'deletequeue' => 'Lašowański cakajucy rěd',
	'deletequeue-list-text' => 'Toś ten bok zwobraznjujo wše boki, kótarež su w systemje wulašowanja.',
	'deletequeue-list-search-legend' => 'Boki pytaś',
	'deletequeue-list-queue' => 'Cakajucy rěd:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Jano póžedanja pokazaś, kótarež maju se zacyniś.',
	'deletequeue-list-search' => 'Pytaś',
	'deletequeue-list-anyqueue' => '(někaki)',
	'deletequeue-list-votes' => 'Lisćina głosow',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|pódpěranje|pódpěrani|pódpěranja|pódpěranjow}}, $2 {{PLURAL:$2|wótpokazanje|wótpokazani|wótpokazanja|wótpokazanjow}}',
	'deletequeue-list-header-page' => 'Bok',
	'deletequeue-list-header-queue' => 'Cakajucy rěd',
	'deletequeue-list-header-votes' => 'Pódpěranja a znapśeśiwjenja',
	'deletequeue-list-header-expiry' => 'Spadnjenje',
	'deletequeue-list-header-discusspage' => 'Diskusijny bok',
	'deletequeue-case-intro' => 'Toś ten bok zwobraznjujo informacije wó wěstem lašowańskem paźe.',
	'deletequeue-list-header-reason' => 'Pśicyna za wulašowanje',
	'deletequeue-case-votes' => 'Pódpěranja/zanpśeśiwjenja',
	'deletequeue-case-title' => 'Drobnostki wó lašowańskem paźe',
	'deletequeue-case-details' => 'Zakładne drobnostki',
	'deletequeue-case-page' => 'Bok:',
	'deletequeue-case-reason' => 'Pśicyna:',
	'deletequeue-case-expiry' => 'Spadnjenje:',
	'deletequeue-case-needs-review' => 'Toś ten pad trjeba [[$1|pśeglědanje]].',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'deletequeue-list-search' => 'Dii',
	'deletequeue-list-header-page' => 'Axa',
	'deletequeue-list-header-expiry' => 'Nuwuwu',
	'deletequeue-case-page' => 'Axa:',
	'deletequeue-case-expiry' => 'Nuwuwu:',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['el'] = array(
	'deletequeue-action-queued' => 'Διαγραφή',
	'deletequeue-action' => 'Πρόταση για διαγραφή',
	'deletequeue-action-title' => 'Πρόταση για διαγραφή του "$1"',
	'deletequeue-speedy-title' => 'Σήμανση του "$1" για ταχεία διαγραφή',
	'deletequeue-prod-title' => 'Πρόταση για διαγραφή του "$1"',
	'deletequeue-delnom-reason' => 'Λόγος υποψηφιότητας:',
	'deletequeue-delnom-otherreason' => 'Άλλος λόγος',
	'deletequeue-delnom-extra' => 'Επιπλέον πληροφορίες:',
	'deletequeue-delnom-submit' => 'Υποβολή υποψηφιότητας',
	'right-prod-nominate' => 'Πρόταση για διαγραφή σελίδων',
	'deletequeue-queue-speedy' => 'Ταχεία διαγραφή',
	'deletequeue-queue-prod' => 'Προτεινόμενη διαγραφή',
	'deletequeue-queue-deletediscuss' => 'Συζήτηση διαγραφής',
	'deletequeue-review-action' => 'Ενέργεια που είναι να παρθεί:',
	'deletequeue-review-delete' => 'Διαγραφή αυτής της σελίδας.',
	'deletequeue-review-reason' => 'Σχόλια:',
	'deletequeue-review-newreason' => 'Νέος λόγος:',
	'deletequeue-review-newextra' => 'Επιπλέον πληροφορίες:',
	'deletequeue-review-submit' => 'Αποθήκευση Επιθεώρησης',
	'deletequeue-review-original' => 'Αιτιολογία υποψηφιότητας',
	'deletequeue-reviewspeedy-tab' => 'Επιθεώρηση ταχείας διαγραφής',
	'deletequeue-reviewprod-tab' => 'Επιθεώρηση προτεινόμενης διαγραφής',
	'deletequeue-reviewprod-title' => 'Επιθεώρηση προτεινόμενης διαγραφής του "$1"',
	'deletequeue-reviewdeletediscuss-tab' => 'Επιθεώρηση διαγραφής',
	'deletequeue-reviewdeletediscuss-title' => 'Επιθεώρηση της συζήτησης διαγραφής του "$1"',
	'deletequeue-review-success-title' => 'Η επιθεώρηση ολοκληρώθηκε',
	'deletequeue-vote-tab' => 'Ψήφος υπέρ της διαγραφής',
	'deletequeue-vote-action' => 'Υπόδειξη:',
	'deletequeue-vote-reason' => 'Σχόλια:',
	'deletequeue-vote-submit' => 'Υποβολή',
	'deletequeue-list-search-legend' => 'Αναζήτηση σελίδων',
	'deletequeue-list-queue' => 'Ουρά:',
	'deletequeue-list-status' => 'Κατάσταση:',
	'deletequeue-list-search' => 'Αναζήτηση',
	'deletequeue-list-anyqueue' => '(οποιοδήποτε)',
	'deletequeue-list-votes' => 'Λίστα των ψήφων',
	'deletequeue-list-header-page' => 'Σελίδα',
	'deletequeue-list-header-queue' => 'Ουρά',
	'deletequeue-list-header-expiry' => 'Λήξη',
	'deletequeue-list-header-discusspage' => 'Σελίδα συζήτησης',
	'deletequeue-list-header-reason' => 'Λόγος διαγραφής',
	'deletequeue-case-details' => 'Βασικές λεπτομέρειες',
	'deletequeue-case-page' => 'Σελίδα:',
	'deletequeue-case-reason' => 'Αιτία:',
	'deletequeue-case-expiry' => 'Λήξη:',
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
	'deletequeue-list-header-reason' => 'Kialo por forigado',
	'deletequeue-case-details' => 'Bazaj detaloj',
	'deletequeue-case-page' => 'Paĝo:',
	'deletequeue-case-reason' => 'Kialo:',
	'deletequeue-case-expiry' => 'Findaŭro:',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Fitoschido
 * @author Imre
 * @author Mor
 * @author Remember the dot
 * @author Sanbec
 * @author Translationista
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
	'deletequeue-speedy-text' => "Puedes usar este formulario para marcar la página \"'''\$1'''\" para borrado rápido.

Un administrador revisará esta solicitud, y, si está bien fundamentado, borrará la página.
Debes seleccionar una razón para el borrado de la lista desplegable de abajo, y agregar alguna otra información relevante.",
	'deletequeue-prod-title' => 'Proponer borrado de "$1"',
	'deletequeue-prod-text' => "Puedes usar este formulario para proponer que \"'''\$1'''\" sea borrado.

Si, después de cinco días, nadie ha contestado el borrado de esta página, será borrado después de una revisión final por un administrador.",
	'deletequeue-delnom-reason' => 'Razón para nominación:',
	'deletequeue-delnom-otherreason' => 'Otra razón',
	'deletequeue-delnom-extra' => 'Información extra:',
	'deletequeue-delnom-submit' => 'Enviar nominación',
	'deletequeue-log-nominate' => "nominado [[$1]] para borrado en la cola '$2'.",
	'deletequeue-log-rmspeedy' => 'se negó a eliminar rápidamente [[$1]].',
	'deletequeue-log-requeue' => "transferido [[$1]] a una cola de borrado diferente: de '$2' a '$3'.",
	'deletequeue-log-dequeue' => "quitado [[$1]] de la cola de borrado '$2'.",
	'right-speedy-nominate' => 'Nominar páginas para borrado rápido',
	'right-speedy-review' => 'Revisar nominaciones para borrado rápido',
	'right-prod-nominate' => 'Proponer borrado de página',
	'right-prod-review' => 'Revisar propuestas no contestadas de borrado',
	'right-deletediscuss-nominate' => 'Comenzar discusiones de borrado',
	'right-deletediscuss-review' => 'Cerrar discusiones de borrado',
	'right-deletequeue-vote' => 'Apoyar u objetar los borrados',
	'deletequeue-queue-speedy' => 'Borrado rápido',
	'deletequeue-queue-prod' => 'Borrado propuesto',
	'deletequeue-queue-deletediscuss' => 'Discusión de borrado',
	'deletequeue-page-speedy' => "Esta página ha sido nominada para borrado rápido.
La razón dada para este borrado es ''$1''.",
	'deletequeue-page-prod' => "Se ha propuesto que esta página sea borrada.
La razón dad fue ''$1''.
Si esta propuesta no es contestada en ''$2'', está página será borrada.
Puedes contestar el borrado de esta página por [{{fullurl:{{FULLPAGENAME}}|action=delvote}} objetando el borrado].",
	'deletequeue-page-deletediscuss' => "Esta página ha sido propuesta para borrado, y esta propuesta ha sido contestada.
La razón dada fue ''$1''.
Una discusión está en curso en [[$5]], la cual concluirá en ''$2''.",
	'deletequeue-notqueued' => 'La página que ha seleccionado no está actualmente en espera de borrado',
	'deletequeue-review-action' => 'Acción a tomar:',
	'deletequeue-review-delete' => 'Borrar la página.',
	'deletequeue-review-change' => 'Borrar esta página, pero con una diferente razón.',
	'deletequeue-review-requeue' => 'Transferir esta página a la siguiente cola:',
	'deletequeue-review-dequeue' => 'No realizar ninguna acción, y quitar la página de la cola de borrado.',
	'deletequeue-review-reason' => 'Comentarios:',
	'deletequeue-review-newreason' => 'Nueva razón:',
	'deletequeue-review-newextra' => 'Información extra:',
	'deletequeue-review-submit' => 'Grabar Revisión',
	'deletequeue-review-original' => 'Razón para nominación',
	'deletequeue-actiondisabled-involved' => 'La siguiente acción se ha inhabilitado porque has participado en este caso de borrado como $1:',
	'deletequeue-actiondisabled-notexpired' => 'la siguiente acción está deshabilitada porque la nominación para borrado aun no ha expirado:',
	'deletequeue-review-badaction' => 'Usted especificó una acción inválida',
	'deletequeue-review-actiondenied' => 'Usted ha especificado una acción la cual está dehabilitada para esta página',
	'deletequeue-review-objections' => "'''Advertencia''': El borrado de esta página tiene [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} objeciones].
Por favor asegúrese que has considerado estas objeciones antes de borrar esta página.",
	'deletequeue-reviewspeedy-tab' => 'Revisar borrado rápido',
	'deletequeue-reviewspeedy-title' => 'Revisar nominación de borrado rápido de "$1"',
	'deletequeue-reviewspeedy-text' => "Puedes usar este formulario para revisar la nominación de \"'''\$1'''\" para borrado rápido.
por favor asegúrese que esta página puede ser rápidamente borrada de acuerdo con la política.",
	'deletequeue-reviewprod-tab' => 'revisar borrado propuesto',
	'deletequeue-reviewprod-title' => 'Revisar borrado propuesto de "$1"',
	'deletequeue-reviewprod-text' => "Puedes usar este formulario para revisar la propuesta no contestada para el borrado de \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Revisar borrado',
	'deletequeue-reviewdeletediscuss-title' => 'Revisar discusión de borrado para "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Puedes usar este formulario para revisar la discusión sobre borrado de \"'''\$1'''\".

Una [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] de apoyos y objeciones de este borrado está disponible, y la discusión por si misma puede ser encontrada en [[\$2]].
Por favor asegúrate que tomas una decisión de acuerdo con el consenso en la discusión.",
	'deletequeue-review-success' => 'Has revisado exitosamente el borrado de esta página',
	'deletequeue-review-success-title' => 'Revisión completa',
	'deletequeue-deletediscuss-discussionpage' => 'Esta es la página de discusión para el borrado de [[$1]].
Hay actualmente $2 {{PLURAL:$2|usuario|usuarios}} apoyando el borrado, y $3 {{PLURAL:$3|usuario|usuarios}} objetando el borrado.
Puedes [{{fullurl:$1|action=delvote}} apoyar u objetar] el borrado, o [{{fullurl:$1|action=delviewvotes}} ver todos los apoyos y objeciones].',
	'deletequeue-discusscreate-summary' => 'creando discusión para el borrado de [[$1]].',
	'deletequeue-discusscreate-text' => 'Borrado propuesto por las siguientes razones: $2',
	'deletequeue-role-nominator' => 'nominador original para el borrado',
	'deletequeue-role-vote-endorse' => 'Apoyante del borrado',
	'deletequeue-role-vote-object' => 'Objetante del borrado',
	'deletequeue-vote-tab' => 'Votar en el borrado',
	'deletequeue-vote-title' => 'Apoyar u objetar el borrado de "$1"',
	'deletequeue-vote-text' => "Puedes usar este formulario para apoyar u objetar el borrado de \"'''\$1'''\".
Esta acción reescribirá cualquiera de los apoyos/objeciones que hayas dado al borrado de esta página.
Puedes [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ver] los apoyos y objeciones existentes.
La razón dada en la nominación para el borrado fue ''\$2''.",
	'deletequeue-vote-legend' => 'Apoyar/objetar el borrado',
	'deletequeue-vote-action' => 'Recomendación:',
	'deletequeue-vote-endorse' => 'Apoyar borrado.',
	'deletequeue-vote-object' => 'Objetar el borrado.',
	'deletequeue-vote-reason' => 'Comentarios:',
	'deletequeue-vote-submit' => 'Enviar',
	'deletequeue-vote-success-endorse' => 'Has apoyado exitosamente el borrado de esta página.',
	'deletequeue-vote-success-object' => 'Has objetado exitosamente el borrado de esta página.',
	'deletequeue-vote-requeued' => 'Has objetado exitosamente el borrado de esta página.
A causa de tu objeción, la página ha sido movida a la cola $1.',
	'deletequeue-showvotes' => 'Apoyos y objeciones al borrado de "$1"',
	'deletequeue-showvotes-text' => "Debajo están los apoyos y objeciones hechas al borrado de la página \"'''\$1'''\".
Puedes [{{fullurl:{{FULLPAGENAME}}|action=delvote}} registrar tu propio apoyo, u objeción] a este borrado.",
	'deletequeue-showvotes-restrict-endorse' => 'Mostrar apoyos solamente',
	'deletequeue-showvotes-restrict-object' => 'Mostrar objeciones solamente',
	'deletequeue-showvotes-restrict-none' => 'Mostrar todos los apoyos y objeciones',
	'deletequeue-showvotes-vote-endorse' => "'''Apoyado''' borrado en $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Objetado''' borrado en $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Mostrando solamente apoyos',
	'deletequeue-showvotes-showingonly-object' => 'Mostrando sólo objeciones',
	'deletequeue-showvotes-none' => 'No hay apoyos u objeciones al borrado de esta página.',
	'deletequeue-showvotes-none-endorse' => 'No hay apoyos al borrado de esta página.',
	'deletequeue-showvotes-none-object' => 'No hay objeciones al borrado de esta página.',
	'deletequeue' => 'Cola de borrado',
	'deletequeue-list-text' => 'Esta página muestra todas la páginas la cuales están en el sistema de borrado.',
	'deletequeue-list-search-legend' => 'Buscar páginas',
	'deletequeue-list-queue' => 'Cola:',
	'deletequeue-list-status' => 'Estatus:',
	'deletequeue-list-expired' => 'Mostrar solamente nominaciones que requieren cerrado.',
	'deletequeue-list-search' => 'Buscar',
	'deletequeue-list-anyqueue' => '(cualquiera)',
	'deletequeue-list-votes' => 'Lista de votos',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|apoyo|apoyos}}, $2 {{PLURAL:$2|objeción|objeciones}}',
	'deletequeue-list-header-page' => 'Página',
	'deletequeue-list-header-queue' => 'Cola',
	'deletequeue-list-header-votes' => 'Apoyos y objeciones',
	'deletequeue-list-header-expiry' => 'Expirar',
	'deletequeue-list-header-discusspage' => 'Página de discusión',
	'deletequeue-case-intro' => 'Esta página lista información sobre un caso específico de borrado.',
	'deletequeue-list-header-reason' => 'Razón para borrado',
	'deletequeue-case-votes' => 'Apoyos/objeciones:',
	'deletequeue-case-title' => 'Detalles del caso de borrado',
	'deletequeue-case-details' => 'Detalles básicos',
	'deletequeue-case-page' => 'Página:',
	'deletequeue-case-reason' => 'Motivo:',
	'deletequeue-case-expiry' => 'Expiración:',
	'deletequeue-case-needs-review' => 'Este caso requiere [[$1|revisión]].',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'deletequeue-delnom-otherreason' => 'Muu põhjus',
	'deletequeue-delnom-extra' => 'Lisainfo:',
	'deletequeue-review-delete' => 'Kustuta lehekülg.',
	'deletequeue-review-reason' => 'Kommentaarid:',
	'deletequeue-review-newreason' => 'Uus põhjus:',
	'deletequeue-review-newextra' => 'Lisainfo:',
	'deletequeue-vote-reason' => 'Kommentaarid:',
	'deletequeue-list-search' => 'Otsi',
	'deletequeue-list-votes' => 'Häälte loend',
	'deletequeue-list-header-page' => 'Lehekülg',
	'deletequeue-list-header-expiry' => 'Aegumistähtaeg',
	'deletequeue-list-header-discusspage' => 'Aruteluleht',
	'deletequeue-list-header-reason' => 'Kustutamise põhjus',
	'deletequeue-case-page' => 'Lehekülg:',
	'deletequeue-case-reason' => 'Põhjus:',
	'deletequeue-case-expiry' => 'Aegub:',
);

/** Basque (Euskara)
 * @author An13sa
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
	'deletequeue-list-votes' => 'Bozken zerrenda',
	'deletequeue-list-header-page' => 'Orrialdea',
	'deletequeue-list-header-queue' => 'Ilara',
	'deletequeue-list-header-expiry' => 'Epemuga',
	'deletequeue-list-header-discusspage' => 'Eztabaida orrialdea',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'deletequeue-list-status' => 'وضعیت:',
	'deletequeue-list-search' => 'جستجو',
	'deletequeue-case-details' => 'اطلاعات پایه',
	'deletequeue-case-page' => 'صفحه:',
	'deletequeue-case-reason' => 'دلیل:',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 * @author ZeiP
 */
$messages['fi'] = array(
	'deletequeue-desc' => 'Luo [[Special:DeleteQueue|jonopohjaisen järjestelmän poistojen hallintaan]].',
	'deletequeue-action-queued' => 'Poisto',
	'deletequeue-action' => 'Ehdota poistoa',
	'deletequeue-action-title' => 'Ehdota sivun ”$1” poistoa',
	'deletequeue-action-text' => "Tällä wikillä on useita prosesseja sivujen poistamiseen:
* Jos uskot että se on aiheellista tälle sivulle, voit [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} ehdottaa sitä ''pikapoistettavaksi''].
* Jos tämä sivu ei ole pikapoistettava, mutta ''poistolle ei ole todennäköisesti vastustusta'', sinun tulisi [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} ehdottaa kyseenalaistamatonta poistoa].
* Jos sivun poistoa ''todennäköisesti vastustetaan'', sinun tulisi [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} avata keskustelu].",
	'deletequeue-action-text-queued' => 'Voit katsoa nämä sivut tälle poistotapaukselle:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Katso annetut tuet ja vastustukset].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Tue tai vastusta tämän sivun poistoa].',
	'deletequeue-permissions-noedit' => 'Sivun poistamiseen vaikuttaminen edellyttää, että pystyt muokkaamaan sivua.',
	'deletequeue-generic-reasons' => '* Yleiset poistosyyt
  ** Häiriköinti
  ** Mainostaminen
  ** Ylläpito
  ** Epäoleellinen projektille',
	'deletequeue-nom-alreadyqueued' => 'Sivu on valmiiksi poistojonossa.',
	'deletequeue-speedy-title' => 'Merkitse ”$1” poistettavaksi',
	'deletequeue-speedy-text' => "Voit käyttää tätä lomaketta merkitäksesi sivun \"'''\$1'''\" pikapoistettavaksi.

Ylläpitäjä tarkistaa pyynnön, ja jos se on perusteltu, poistaa sivun.
Sinun tulee valita syy alla olevasta alasvetovalikosta ja lisätä muu olennainen tieto.",
	'deletequeue-prod-title' => 'Ehdota sivun ”$1” poistoa',
	'deletequeue-prod-text' => "Voit ehdottaa sivun '''$1''' poistamista tällä lomakkeella.

Jos viiden päivän jälkeen kukaan ei ole kyseenalaistanut sivun poistamista, ylläpitäjän tarkastaa ja poistaa sen.",
	'deletequeue-prod-reasons' => '-',
	'deletequeue-delnom-reason' => 'Syy ehdollepanoon:',
	'deletequeue-delnom-otherreason' => 'Muu syy',
	'deletequeue-delnom-extra' => 'Lisätiedot',
	'deletequeue-delnom-submit' => 'Lähetä ehdollepano',
	'deletequeue-log-nominate' => 'ehdotettu sivua [[$1]] poistettavaksi jonossa $2.',
	'deletequeue-log-rmspeedy' => 'kieltäytyi pikapoistamasta sivua [[$1]].',
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
	'deletequeue-page-prod' => "Tämän sivun poistoa on ehdotettu.
Annettu syy oli ''$1''.
Jos tätä ehdotusta ei ole kyseenalaistettu ''$2'' mennessä, sivu poistetaan.
Voit kyseenalaistaa sivun poiston [{{fullurl:{{FULLPAGENAME}}|action=delvote}} vastustamalla poistoa].",
	'deletequeue-page-deletediscuss' => "Tätä sivua on ehdotettu poistettavaksi, ja poisto on kyseenalaistettu.
Annettu syy oli ''$1''.
''$2'' päättyvä keskustelu on käynnissä sivulla [[$5]].",
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
	'deletequeue-actiondisabled-involved' => 'Seuraava toiminto ei ole käytettävissä, koska olet osallisena tässä poistotapauksessa rooleissa $1:',
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
	'deletequeue-reviewprod-text' => "Voit käyttää tätä lomaketta vastustamattoman poistoehdotuksen ”'''$1'''” tarkistamiseen.",
	'deletequeue-reviewdeletediscuss-tab' => 'Tarkasta poisto',
	'deletequeue-reviewdeletediscuss-title' => 'Tarkasta sivun ”$1” poistokeskustelu',
	'deletequeue-reviewdeletediscuss-text' => "Voit käyttää tätä lomaketta katsoaksesi sivun \"'''\$1'''\" poistokeskustelun.

[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] tämän sivun poiston tuista ja vastustuksista on saatavilla, ja keskustelu itsessään löytyy sivulta [[\$2]].
Varmistathan, että teet päätöksen keskustelun konsensuksen mukaisesti.",
	'deletequeue-review-success' => 'Olet onnistuneesti arvioinut tämän sivun poiston',
	'deletequeue-review-success-title' => 'Tarkistus valmis',
	'deletequeue-deletediscuss-discussionpage' => 'Tämä on sivun [[$1]] poiston keskustelusivu.
Tällä hetkellä poistoa tukee $2 {{PLURAL:$2|käyttäjä|käyttäjää}} ja vastustaa $3 {{PLURAL:$3|käyttäjä|käyttäjää}}.
Voit [{{fullurl:$1|action=delvote}} tukea tai vastustaa] poistoa tai [{{fullurl:$1|action=delviewvotes}} katsoa kaikki tuet ja vastustukset].',
	'deletequeue-discusscreate-summary' => 'Luodaan keskustelusivua sivun [[$1]] poistosta.',
	'deletequeue-discusscreate-text' => 'Poistoa ehdotettiin seuraavan syyn takia: $2',
	'deletequeue-role-nominator' => 'alkuperäinen poiston ehdottaja',
	'deletequeue-role-vote-endorse' => 'poiston siirtäjä',
	'deletequeue-role-vote-object' => 'poiston vastustaja',
	'deletequeue-vote-tab' => 'Äänestä poistosta',
	'deletequeue-vote-title' => 'Myötäile tai vastusta sivun ”$1” poistoa',
	'deletequeue-vote-text' => "Voit käyttää tätä lomaketta sivun \"'''\$1'''\" poiston tukemiseen tai vastustamiseen.
Tämä toiminto korvaa kaikki aiemmat tuet ja vastustukset, joita olet antanut tämän sivun poistamiselle.
Voit [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} katsoa] kaikki nykyiset tuet ja vastustukset.
Ehdotukseen annettu syy oli ''\$2''.",
	'deletequeue-vote-legend' => 'Tue tai vastusta poistoa',
	'deletequeue-vote-action' => 'Suositus:',
	'deletequeue-vote-endorse' => 'Hyväksy poisto.',
	'deletequeue-vote-object' => 'Vastusta poistoa.',
	'deletequeue-vote-reason' => 'Kommentit:',
	'deletequeue-vote-submit' => 'Lähetä',
	'deletequeue-vote-success-endorse' => 'Äänesi sivun poiston puolesta on kirjattu.',
	'deletequeue-vote-success-object' => 'Äänesi sivun säilyttämisen puolesta on kirjattu.',
	'deletequeue-vote-requeued' => 'Olet onnistuneesti vastustanut tämän sivun poistoa.
Vastustuksesi johdosta sivu on siirretty jonoon $1.',
	'deletequeue-showvotes' => 'Sivun ”$1” vastustajat ja hyväksyjät',
	'deletequeue-showvotes-text' => "Alla ovat sivun \"'''\$1'''\" poistolle annetut tuet ja vastustukset.
Voit [{{fullurl:{{FULLPAGENAME}}|action=delvote}} merkitä oman tukesi tai vastustuksesi] tähän poistoon.",
	'deletequeue-showvotes-restrict-endorse' => 'Näytä vain hyväksyjät',
	'deletequeue-showvotes-restrict-object' => 'Näytä vain vastustajat',
	'deletequeue-showvotes-restrict-none' => 'Näytä kaikki vastustajat ja hyväksyjät',
	'deletequeue-showvotes-vote-endorse' => "'''Tuettu''' poistoa $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Vastustettu''' poistoa $1 $2",
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
	'deletequeue-list-header-votes' => 'Tukemiset ja vastustukset',
	'deletequeue-list-header-expiry' => 'Päättyminen',
	'deletequeue-list-header-discusspage' => 'Keskustelusivu',
	'deletequeue-case-intro' => 'Tämä sivu listaa tietoa tietystä poistotapauksesta.',
	'deletequeue-list-header-reason' => 'Syy poistolle',
	'deletequeue-case-votes' => 'Kannatukset/vastustukset',
	'deletequeue-case-title' => 'Poistotapauksen tiedot',
	'deletequeue-case-details' => 'Perustiedot',
	'deletequeue-case-page' => 'Sivu',
	'deletequeue-case-reason' => 'Syy',
	'deletequeue-case-expiry' => 'Päättyminen',
	'deletequeue-case-needs-review' => 'Tämä tapaus vaatii [[$1|tarkistusta]].',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Meno25
 * @author Peter17
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'deletequeue-desc' => 'Crée un [[Special:DeleteQueue|système de files d’attente pour gérer les suppressions]]',
	'deletequeue-action-queued' => 'Suppression',
	'deletequeue-action' => 'Suggérer la suppression',
	'deletequeue-action-title' => 'Suggérer la suppression de « $1 »',
	'deletequeue-action-text' => "{{SITENAME}} dispose d’un nombre de processus pour la suppression des pages :
* Si vous croyez que le contenu de cette page le garantit, vous pouvez [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} en suggérer la ''suppression immédiate''].
* Si cette page ne relève pas de la suppression immédiate,mais ''cette suppression ne posera aucune controverse'', vous devriez [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} proposer une suppression incontestée].
* Si la suppression de la page est ''sujette à controverses'', vous devriez [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} ouvrir une discussion].",
	'deletequeue-action-text-queued' => 'Vous pouvez visionner les pages suivantes concernant cette suppression :
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Consulter les approbations et contestations actuelles].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Approuver ou contester la suppression de cette page].',
	'deletequeue-permissions-noedit' => 'Vous devez être capable de modifier une page pour pourvoir affecter son statut de suppression.',
	'deletequeue-generic-reasons' => '* Motifs les plus courants
** Vandalisme
** Pourriel
** Maintenance
** Hors des critères du projet',
	'deletequeue-nom-alreadyqueued' => 'Cette page est déjà dans une file de suppression.',
	'deletequeue-speedy-title' => 'Marquer « $1 » pour une suppression immédiate',
	'deletequeue-speedy-text' => "Vous pouvez utiliser ce formulaire pour marquer la page « '''$1''' » pour une suppression immédiate.

Un administrateur étudiera cette requête et, si elle est bien fondée, supprimera la page.
Vous devez sélectionner un motif à partir de la liste déroulante ci-dessous et ajouter toute autre information appropriée.",
	'deletequeue-prod-title' => 'Proposer la suppression de « $1 »',
	'deletequeue-prod-text' => "Vous pouvez utiliser ce formulaire pour proposer que « '''$1''' » soit supprimée.

Si, après cinq jours, personne n’a émis d’objection concernant cette page, elle sera supprimée après un examen final par un administrateur.",
	'deletequeue-delnom-reason' => 'Motif pour la nomination :',
	'deletequeue-delnom-otherreason' => 'Autre raison',
	'deletequeue-delnom-extra' => 'Informations supplémentaires :',
	'deletequeue-delnom-submit' => 'Soumettre la nomination',
	'deletequeue-log-nominate' => '[[$1]] nominé pour la suppression dans la file « $2 ».',
	'deletequeue-log-rmspeedy' => 'refusé pour la suppression immédiate de [[$1]].',
	'deletequeue-log-requeue' => '[[$1]] transféré vers une file de suppression différente : de « $2 » vers « $3 ».',
	'deletequeue-log-dequeue' => '[[$1]] enlevé de la file de suppression « $2 ».',
	'right-speedy-nominate' => 'Nomine des pages pour une suppression immédiate',
	'right-speedy-review' => 'Revoir les nominations de suppression immédiate',
	'right-prod-nominate' => 'Proposer la suppression de pages',
	'right-prod-review' => 'Revoir les propositions de suppression incontestée',
	'right-deletediscuss-nominate' => 'Commencer les discussions sur la suppression',
	'right-deletediscuss-review' => 'Clôturer les discussions sur la suppression',
	'right-deletequeue-vote' => 'Approuver ou vous opposer aux suppressions',
	'deletequeue-queue-speedy' => 'Suppression immédiate',
	'deletequeue-queue-prod' => 'Suppression proposée',
	'deletequeue-queue-deletediscuss' => 'Discussion sur la suppression',
	'deletequeue-page-speedy' => "Cette page a été nominée pour une suppression immédiate.
La raison invoquée pour cela est ''« $1 »''.",
	'deletequeue-page-prod' => "Il a été proposé la suppression de cette page.
La raison invoquée est « ''$1'' ».
Si la proposition ne rencontre aucune contestation avant le ''$2'', la page sera supprimée.
Vous pouvez vous contester cette proposition en [{{fullurl:{{FULLPAGENAME}}|action=delvote}} vous opposant à la suppression].",
	'deletequeue-page-deletediscuss' => "Cette page a été proposée à la suppression, mais cette requête a été contestée.
Le motif invoqué était « $1 ».
Une discussion est en cours sur [[$5]], qui se conclura le ''$2''.",
	'deletequeue-notqueued' => 'La page que vous avez sélectionnée n’est pas actuellement dans une file de suppression',
	'deletequeue-review-action' => 'Action à prendre :',
	'deletequeue-review-delete' => 'Supprimer la page.',
	'deletequeue-review-change' => 'Supprimer cette page, mais avec une autre raison.',
	'deletequeue-review-requeue' => 'Transférer cette page vers la file suivante :',
	'deletequeue-review-dequeue' => 'Ne rien faire et retirer la page de la file de suppression.',
	'deletequeue-review-reason' => 'Commentaires :',
	'deletequeue-review-newreason' => 'Nouveau motif :',
	'deletequeue-review-newextra' => 'Information supplémentaire :',
	'deletequeue-review-submit' => 'Sauvegarder la relecture',
	'deletequeue-review-original' => 'Motif de la nomination',
	'deletequeue-actiondisabled-involved' => 'L’action suivante est désactivée dans ce cas de suppression car vous avez y pris part avec le(s) rôle(s) de $1 :',
	'deletequeue-actiondisabled-notexpired' => 'L’action suivante a été désactivée car le délai suite à la nomination pour la suppression de cette page n’a pas encore expiré :',
	'deletequeue-review-badaction' => 'Vous avez indiqué une action incorrecte',
	'deletequeue-review-actiondenied' => 'Vous avez indiqué une action qui est désactivée pour cette page.',
	'deletequeue-review-objections' => "'''Attention''' : la suppression de cette page est [{{FULLURL:{{FULLPAGENAME}}|action=delvoteview|votetype=object}} contestée]. Veuillez vous assurer d’avoir examiné ces objections avant d’effectuer cette suppression.",
	'deletequeue-reviewspeedy-tab' => 'Revoir la suppression immédiate',
	'deletequeue-reviewspeedy-title' => 'Revoir la suppression immédiate de « $1 »',
	'deletequeue-reviewspeedy-text' => "Vous pouvez utiliser ce formulaire pour revoir la nomination de « '''$1''' » en suppression immédiate.
Veuillez vous assurer que cette page peut être supprimée de la sorte conformément aux règles du projet.",
	'deletequeue-reviewprod-tab' => 'Revoir les suppressions proposées',
	'deletequeue-reviewprod-title' => 'Revoir la suppression proposée pour « $1 »',
	'deletequeue-reviewprod-text' => "Vous pouvez utiliser ce formulaire pour revoir la proposition non contestée de suppression de « '''$1''' ».",
	'deletequeue-reviewdeletediscuss-tab' => 'Revoir la suppression',
	'deletequeue-reviewdeletediscuss-title' => 'Revoir la discussion sur la suppression de « $1 »',
	'deletequeue-reviewdeletediscuss-text' => "Vous pouvez utiliser ce formulaire pour revoir la discussion concernant la suppression de « ''$1''».

Une [{{FULLURL:{{FULLPAGENAME}}|action=delviewvotes}} liste] des approbations et oppositions est disponible et la discussion est elle-même disponible sur [[$2]].
Veuillez vous assurer de prendre votre décision conformément au consensus issu de la discussion.",
	'deletequeue-review-success' => 'Vous avez revu avec succès la suppression de cette page',
	'deletequeue-review-success-title' => 'Révision complète',
	'deletequeue-deletediscuss-discussionpage' => 'Ceci est la page de discussion concernant la suppression de [[$1]].
Il y a actuellement $2 {{PLURAL:$2|utilisateur qui l’approuve|utilisateurs qui l’approuvent}} et $3 {{PLURAL:$3|utilisateur qui s’y oppose|utilisateurs qui s’y opposent}}.
Vous pouvez [{{FULLURL:$1|action=delvote}} approuver ou vous opposer] à la suppression, ou [{{FULLURL:$1|action=delviewvotes}} voir toutes les approbations et oppositions].',
	'deletequeue-discusscreate-summary' => 'Création de la discussion concernant la suppression de [[$1]].',
	'deletequeue-discusscreate-text' => 'Suppression proposée pour la raison suivante : $2',
	'deletequeue-role-nominator' => 'initiateur original de la suppression',
	'deletequeue-role-vote-endorse' => 'partisan pour la suppression',
	'deletequeue-role-vote-object' => 'opposant à la suppression',
	'deletequeue-vote-tab' => 'Voter sur la suppression',
	'deletequeue-vote-title' => 'Approuver ou vous opposer à la suppression de « $1 »',
	'deletequeue-vote-text' => "Vous pouvez utiliser ce formulaire pour approuver ou vous opposer à la suppression de « '''$1''' ».
Cette action écrasera toute approbation ou opposition que vous avez émise auparavant concernant cette suppression.
Vous pouvez [{{FULLURL:{{FULLPAGENAME}}|action=delviewvotes}} voir les approbations et oppositions] déjà émises.
Le motif indiqué pour la nomination à la suppression était ''« $2 »''.",
	'deletequeue-vote-legend' => 'Approuver/Vous opposer à la suppression',
	'deletequeue-vote-action' => 'Recommandation :',
	'deletequeue-vote-endorse' => 'Approuve la suppression',
	'deletequeue-vote-object' => 'S’oppose à la suppression.',
	'deletequeue-vote-reason' => 'Commentaires :',
	'deletequeue-vote-submit' => 'Soumettre',
	'deletequeue-vote-success-endorse' => 'Vous avez approuvé, avec succès, la demande de suppression de cette page.',
	'deletequeue-vote-success-object' => 'Vous vous êtes opposé, avec succès, à la demande de suppression de cette page.',
	'deletequeue-vote-requeued' => 'Vous vous êtes opposé, avec succès, à la demande de suppression de cette page.
Par votre opposition, la page été déplacée dans la file $1.',
	'deletequeue-showvotes' => 'Approbations et oppositions concernant la suppression de « $1 »',
	'deletequeue-showvotes-text' => "Voici, ci-dessous, les approbations et oppositions enregistrées concernant la demande de suppression de la page « '''$1''' ».
Vous pouvez [{{FULLURL:{{FULLPAGENAME}}|action=delvote}} enregistrer ici] votre propre approbation ou opposition concernant cette demande.",
	'deletequeue-showvotes-restrict-endorse' => 'Afficher uniquement les approbations',
	'deletequeue-showvotes-restrict-object' => 'Afficher uniquement les oppositions',
	'deletequeue-showvotes-restrict-none' => 'Afficher toutes les approbations et oppositions',
	'deletequeue-showvotes-vote-endorse' => "'''A approuvé''' la suppression $2 le $1",
	'deletequeue-showvotes-vote-object' => "'''S’est opposé à''' la suppression $2 le $1",
	'deletequeue-showvotes-showingonly-endorse' => 'Affichage uniquement des approbations',
	'deletequeue-showvotes-showingonly-object' => 'Affichage uniquement des oppositions',
	'deletequeue-showvotes-none' => 'Personne n’a approuvé ni ne s’est opposé à la demande de suppression de cette page.',
	'deletequeue-showvotes-none-endorse' => 'Personne n’a approuvé la demande de suppression de cette page.',
	'deletequeue-showvotes-none-object' => 'Personne ne s’est opposé à la demande de suppression de cette page.',
	'deletequeue' => 'File de suppression',
	'deletequeue-list-text' => 'Cette page affiche toutes les pages qui sont dans une file de suppression.',
	'deletequeue-list-search-legend' => 'Rechercher des pages',
	'deletequeue-list-queue' => 'File :',
	'deletequeue-list-status' => 'État :',
	'deletequeue-list-expired' => 'Afficher uniquement les nominations qui requièrent leur clôture.',
	'deletequeue-list-search' => 'Rechercher',
	'deletequeue-list-anyqueue' => '(plusieurs)',
	'deletequeue-list-votes' => 'Liste des votes',
	'deletequeue-list-votecount' => '$1 accord{{PLURAL:$1||s}}, $2 refus{{PLURAL:$2||}}',
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
	'deletequeue-case-reason' => 'Motif :',
	'deletequeue-case-expiry' => 'Expiration :',
	'deletequeue-case-needs-review' => 'Ce cas requiert une [[$1|revue]].',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'deletequeue-action-queued' => 'Suprèssion',
	'deletequeue-action' => 'Conselyér la suprèssion',
	'deletequeue-action-title' => 'Conselyér la suprèssion de « $1 »',
	'deletequeue-generic-reasons' => '* Rêsons les ples corentes
** Vandalismo
** Spame
** Mantegnence
** En defôr des critèros du projèt',
	'deletequeue-nom-alreadyqueued' => 'Ceta pâge est ja dens una fela de suprèssion.',
	'deletequeue-speedy-title' => 'Marcar « $1 » por una suprèssion drêta',
	'deletequeue-prod-title' => 'Proposar la suprèssion de « $1 »',
	'deletequeue-delnom-reason' => 'Rêson por lo chouèx :',
	'deletequeue-delnom-otherreason' => 'Ôtra rêson',
	'deletequeue-delnom-extra' => 'Enformacions de ples :',
	'deletequeue-delnom-submit' => 'Sometre lo chouèx',
	'deletequeue-log-nominate' => 'at chouèsi [[$1]] por la suprèssion dens la fela « $2 ».',
	'deletequeue-log-rmspeedy' => 'refusâ por la suprèssion drêta de [[$1]].',
	'deletequeue-log-dequeue' => 'at enlevâ [[$1]] de la fela de suprèssion « $2 ».',
	'right-speedy-nominate' => 'Chouèsir des pâges por una suprèssion drêta',
	'right-speedy-review' => 'Revêre los chouèx de suprèssions drêtes',
	'right-prod-nominate' => 'Proposar la suprèssion de pâges',
	'right-prod-review' => 'Revêre les proposicions de suprèssions encontèstâs',
	'right-deletediscuss-nominate' => 'Comenciér les discussions sur la suprèssion',
	'right-deletediscuss-review' => 'Cllôre les discussions sur la suprèssion',
	'right-deletequeue-vote' => 'Aprovar ou ben refusar les suprèssions',
	'deletequeue-queue-speedy' => 'Suprèssion drêta',
	'deletequeue-queue-prod' => 'Suprèssion proposâ',
	'deletequeue-queue-deletediscuss' => 'Discussion sur la suprèssion',
	'deletequeue-review-action' => 'Accion a prendre :',
	'deletequeue-review-delete' => 'Suprimar la pâge.',
	'deletequeue-review-reason' => 'Comentèros :',
	'deletequeue-review-newreason' => 'Novèla rêson :',
	'deletequeue-review-newextra' => 'Enformacions de ples :',
	'deletequeue-review-submit' => 'Sôvar la rèvision',
	'deletequeue-review-original' => 'Rêson por lo chouèx',
	'deletequeue-reviewspeedy-tab' => 'Revêre la suprèssion drêta',
	'deletequeue-reviewspeedy-title' => 'Revêre lo chouèx de la suprèssion drêta de « $1 »',
	'deletequeue-reviewprod-tab' => 'Revêre la suprèssion proposâ',
	'deletequeue-reviewprod-title' => 'Revêre la suprèssion proposâ de « $1 »',
	'deletequeue-reviewdeletediscuss-tab' => 'Revêre la suprèssion',
	'deletequeue-reviewdeletediscuss-title' => 'Revêre la discussion sur la suprèssion de « $1 »',
	'deletequeue-review-success-title' => 'Rèvision complèta',
	'deletequeue-discusscreate-summary' => 'Crèacion de la discussion sur la suprèssion de [[$1]].',
	'deletequeue-discusscreate-text' => 'Suprèssion proposâ por ceta rêson : $2',
	'deletequeue-role-nominator' => 'iniciator originâl de la suprèssion',
	'deletequeue-role-vote-endorse' => 'partisan por la suprèssion',
	'deletequeue-role-vote-object' => 'oposent a la suprèssion',
	'deletequeue-vote-tab' => 'Votar sur la suprèssion',
	'deletequeue-vote-title' => 'Aprovar ou ben refusar la suprèssion de « $1 »',
	'deletequeue-vote-legend' => 'Aprovar / refusar la suprèssion',
	'deletequeue-vote-action' => 'Recomandacion :',
	'deletequeue-vote-endorse' => 'Aprovar la suprèssion.',
	'deletequeue-vote-object' => 'Refusar la suprèssion.',
	'deletequeue-vote-reason' => 'Comentèros :',
	'deletequeue-vote-submit' => 'Sometre',
	'deletequeue-showvotes-restrict-endorse' => 'Fâre vêre ren que les aprobacions',
	'deletequeue-showvotes-restrict-object' => 'Fâre vêre ren que les oposicions',
	'deletequeue-showvotes-restrict-none' => 'Fâre vêre totes les aprobacions et les oposicions',
	'deletequeue-showvotes-vote-endorse' => "'''At aprovâ''' la suprèssion $2 lo $1",
	'deletequeue-showvotes-vote-object' => "'''At refusâ''' la suprèssion $2 lo $1",
	'deletequeue-showvotes-showingonly-endorse' => 'Visualisacion solament de les aprobacions',
	'deletequeue-showvotes-showingonly-object' => 'Visualisacion solament de les oposicions',
	'deletequeue' => 'Fela de suprèssion',
	'deletequeue-list-search-legend' => 'Rechèrchiér des pâges',
	'deletequeue-list-queue' => 'Fela :',
	'deletequeue-list-status' => 'Ètat :',
	'deletequeue-list-search' => 'Rechèrchiér',
	'deletequeue-list-anyqueue' => '(un mouél)',
	'deletequeue-list-votes' => 'Lista des votos',
	'deletequeue-list-votecount' => '$1 acôrd{{PLURAL:$1||s}}, $2 refus{{PLURAL:$2||}}',
	'deletequeue-list-header-page' => 'Pâge',
	'deletequeue-list-header-queue' => 'Fela',
	'deletequeue-list-header-votes' => 'Acôrds et refus',
	'deletequeue-list-header-expiry' => 'Èxpiracion',
	'deletequeue-list-header-discusspage' => 'Pâge de discussion',
	'deletequeue-list-header-reason' => 'Rêson de la suprèssion',
	'deletequeue-case-votes' => 'Por / contre :',
	'deletequeue-case-title' => 'Dètalys du câs de suprèssion',
	'deletequeue-case-details' => 'Dètalys de bâsa',
	'deletequeue-case-page' => 'Pâge :',
	'deletequeue-case-reason' => 'Rêson :',
	'deletequeue-case-expiry' => 'Èxpiracion :',
	'deletequeue-case-needs-review' => 'Ceti câs at fôta d’una [[$1|rèvision]].',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'deletequeue-review-reason' => 'Nótaí tráchta:',
	'deletequeue-vote-reason' => 'Nótaí tráchta:',
);

/** Simplified Gan script (‪赣语(简体)‬) */
$messages['gan-hans'] = array(
	'deletequeue-list-search' => '寻吖',
);

/** Traditional Gan script (‪贛語(繁體)‬)
 * @author Symane
 */
$messages['gan-hant'] = array(
	'deletequeue-list-search' => '尋吖',
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
	'deletequeue-delnom-reason' => 'Motivo para o nomeamento:',
	'deletequeue-delnom-otherreason' => 'Outro motivo',
	'deletequeue-delnom-extra' => 'Información adicional:',
	'deletequeue-delnom-submit' => 'Enviar o nomeamento',
	'deletequeue-log-nominate' => 'nomeou "[[$1]]" para a súa eliminación da cola "$2".',
	'deletequeue-log-rmspeedy' => 'declinou a eliminación rápida de "[[$1]]".',
	'deletequeue-log-requeue' => 'transferiu "[[$1]]" a unha cola de borrados diferente: de "$2" a "$3".',
	'deletequeue-log-dequeue' => 'eliminou "[[$1]]" da cola de borrados "$2".',
	'right-speedy-nominate' => 'Nomear páxinas para a súa eliminación rápida',
	'right-speedy-review' => 'Revisar os nomeamentos das eliminacións rápidas',
	'right-prod-nominate' => 'Propor o borrado dunha páxina',
	'right-prod-review' => 'Revisar as propostas de borrado non respostadas',
	'right-deletediscuss-nominate' => 'Comezar discusións de borrado',
	'right-deletediscuss-review' => 'Pechar discusións de borrado',
	'right-deletequeue-vote' => 'Apoiar os borrados ou obxectar nos mesmos',
	'deletequeue-queue-speedy' => 'Eliminación rápida',
	'deletequeue-queue-prod' => 'Borrado proposto',
	'deletequeue-queue-deletediscuss' => 'Discusión do borrado',
	'deletequeue-page-speedy' => "Esta páxina foi nomeada para a súa eliminación rápida.
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
	'deletequeue-review-original' => 'Motivo para o nomeamento',
	'deletequeue-actiondisabled-involved' => 'A seguinte acción está deshabilitada porque formou parte neste caso de borrado no papel de $1:',
	'deletequeue-actiondisabled-notexpired' => 'A seguinte acción está deshabilitada porque o nomeamento para o seu borrado aínda non caducou:',
	'deletequeue-review-badaction' => 'Especificou unha acción inválida',
	'deletequeue-review-actiondenied' => 'Especificou unha acción que foi deshabilitada para esta páxina',
	'deletequeue-review-objections' => "'''Aviso:''' a eliminación desta páxina ten [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} obxeccións].
Por favor, asegúrese que considerou estas obxeccións antes de borrar a páxina.",
	'deletequeue-reviewspeedy-tab' => 'Revisar a eliminación rápida',
	'deletequeue-reviewspeedy-title' => 'Revisar o nomeamento da eliminación rápida de "$1"',
	'deletequeue-reviewspeedy-text' => "Pode usar este formulario para revisar o nomeamento de \"'''\$1'''\" para a súa eliminación.
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
	'deletequeue-role-nominator' => 'nomeador orixinal da eliminación',
	'deletequeue-role-vote-endorse' => 'partícipe da eliminación',
	'deletequeue-role-vote-object' => 'obxector da eliminación',
	'deletequeue-vote-tab' => 'Votar na eliminación',
	'deletequeue-vote-title' => 'Apoiar a/Obxectar na eliminación de "$1"',
	'deletequeue-vote-text' => "Pode usar este formulario para apoiar ou obxectar na páxina de eliminación de \"'''\$1'''\".
Esta acción ignorará calquera apoio/obxección anterior que teña dado na eliminación desta páxina.
Pode [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ver] os apoios e obxeccións existentes.
O motivo dado no nomeamento para a eliminación foi ''\$2''.",
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
	'deletequeue-showvotes-restrict-endorse' => 'Mostrar só os apoios',
	'deletequeue-showvotes-restrict-object' => 'Mostrar só as obxeccións',
	'deletequeue-showvotes-restrict-none' => 'Mostrar todos os apoios e obxeccións',
	'deletequeue-showvotes-vote-endorse' => "'''Apoiou''' a eliminación o $2 ás $1",
	'deletequeue-showvotes-vote-object' => "'''Obxectou''' na eliminación o $2 ás $1",
	'deletequeue-showvotes-showingonly-endorse' => 'Mostrando só os apoios',
	'deletequeue-showvotes-showingonly-object' => 'Mostrando só as obxeccións',
	'deletequeue-showvotes-none' => 'Non hai apoios ou obxeccións na eliminación desta páxina.',
	'deletequeue-showvotes-none-endorse' => 'Non hai apoios na eliminación desta páxina.',
	'deletequeue-showvotes-none-object' => 'Non hai obxeccións na eliminación desta páxina.',
	'deletequeue' => 'Cola de borrados',
	'deletequeue-list-text' => 'Esta páxina amosa todas as páxinas que están no sistema de eliminación.',
	'deletequeue-list-search-legend' => 'Procurar páxinas',
	'deletequeue-list-queue' => 'Cola:',
	'deletequeue-list-status' => 'Estado:',
	'deletequeue-list-expired' => 'Mostrar só as nomeamentos que requiren ser pechadas.',
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
	'deletequeue-review-newreason' => 'Νέα αἰτία:',
	'deletequeue-review-newextra' => 'Ἐπὶ πλέον πύστις:',
	'deletequeue-review-submit' => 'Μεταγράφειν Ἐπιθεώρησιν',
	'deletequeue-vote-reason' => 'Σχόλια:',
	'deletequeue-vote-submit' => 'Ὑποβάλλειν',
	'deletequeue-list-queue' => 'Οὐρά:',
	'deletequeue-list-status' => 'Καθεστώς:',
	'deletequeue-list-search' => 'Ζητεῖν',
	'deletequeue-list-anyqueue' => '(οἱαδήποτε)',
	'deletequeue-list-header-page' => 'Δέλτος',
	'deletequeue-list-header-queue' => 'Οὐρά',
	'deletequeue-case-page' => 'Δέλτος:',
	'deletequeue-case-reason' => 'Αἰτία:',
	'deletequeue-case-expiry' => 'Λῆξις:',
	'deletequeue-case-needs-review' => 'Ἥδε ἡ περίστασις ἀπαιτεῖ [[$1|ἐπιθεώρησιν]].',
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

/** Manx (Gaelg)
 * @author MacTire02
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'deletequeue-list-header-discusspage' => 'Duillag resoonaght',
	'deletequeue-case-reason' => 'Fa:',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'deletequeue-delnom-otherreason' => 'Wani dalili',
	'deletequeue-list-search' => 'Nema',
	'deletequeue-list-header-page' => 'Shafi',
	'deletequeue-case-page' => 'Shafi:',
	'deletequeue-case-reason' => 'Dalili:',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 */
$messages['haw'] = array(
	'deletequeue-list-search' => 'Huli',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'deletequeue-desc' => 'יצירת [[Special:DeleteQueue|מערכת מבוססת תורים לניהול המחיקות]]',
	'deletequeue-action-queued' => 'מחיקה',
	'deletequeue-action' => 'הצעת מחיקה',
	'deletequeue-action-title' => 'הצעת מחיקה של "$1"',
	'deletequeue-action-text' => "בוויקי הזה יש מספר תהליכים למחיקת דפים:
* אם נראה לכם שצריך לעשות את זה, אתם יכולים [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} להציע '''מחיקה מהירה''' שלו].
* אם הדף הזה אינו אמור להימחק במחיקה מהירה, אבל '''מחיקת הדף אינה צפויה לעורר מחלוקת''', כדאי [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} להציע מחיקה ללא דיון].
* אם אפשר לצפות להתנגדות למחיקת הדף הזה, כדאי [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} לפתוח דיון מחיקה].",
	'deletequeue-action-text-queued' => 'ניתן לצפות בדפים הבאים הנוגעים למחיקה הזאת:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} לצפות בתמיכות ובהתנגדויות הנוכחיות].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} להביע את דעתכם בעד או נגד המחיקה].',
	'deletequeue-permissions-noedit' => 'רק משתמש שיכול לערוך דף, יכול להשפיע על מצב המחיקה שלו',
	'deletequeue-generic-reasons' => '* סיבות כלליות
  ** השחתה
  ** ספאם
  ** תחזוקה
  ** מחוץ לטווח המיזם',
	'deletequeue-nom-alreadyqueued' => 'דף זה נמצא כבר בתור המחיקה.',
	'deletequeue-speedy-title' => 'סימון "$1" למחיקה מהירה',
	'deletequeue-speedy-text' => "אפשר להשתמש בטופס הזה כדי לסמן את הדף \"'''\$1'''\" למחיקה מהירה.

מפעיל יסקור את הבקשה הזאת ואם היא יש לה יסוד, ימחק אותו.
יש לבחור סיבה למחיקה מהרשימה להלן ולהוסיף כל מידע מועיל נוסף.",
	'deletequeue-prod-title' => 'הצעת מחיקה של "$1"',
	'deletequeue-prod-text' => "אפשר להשתמש בטופס הזה כדי להציע מחיקה של \"'''\$1'''\".

אם אחרי חמישה ימים איש לא יתנגד למחיקת הדף הזה, ,הוא יימחק לאחר סקירה סופית על־ידי מפעיל.",
	'deletequeue-delnom-reason' => 'הסיבה להצעת המחיקה:',
	'deletequeue-delnom-otherreason' => 'סיבה אחרת',
	'deletequeue-delnom-extra' => 'מידע נוסף:',
	'deletequeue-delnom-submit' => 'הגשת הצעה',
	'deletequeue-log-nominate' => "הציע מחיקה של [[$1]] בתור '$2'",
	'deletequeue-log-rmspeedy' => 'סירב למחיקה מהירה של [[$1]]',
	'deletequeue-log-requeue' => "העביר את [[$1]] מתור '$2' לתור '$3'",
	'deletequeue-log-dequeue' => "הסיר את [[$1]] מתור המחיקה '$2'",
	'right-speedy-nominate' => 'הצעת דפים למחיקה מהירה',
	'right-speedy-review' => 'לסקור מועמדויות למחיקה מהירה',
	'right-prod-nominate' => 'הצעת מחיקה של דף',
	'right-prod-review' => 'לסקור הצעות מחיקה שלא הובעה להן התנגדות',
	'right-deletediscuss-nominate' => 'פתיחת דיוני מחיקה',
	'right-deletediscuss-review' => 'סגירת דיוני מחיקה',
	'right-deletequeue-vote' => 'לתמוך במחיקות ולהתנגד להן',
	'deletequeue-queue-speedy' => 'מחיקה מהירה',
	'deletequeue-queue-prod' => 'מחיקה מוצעת',
	'deletequeue-queue-deletediscuss' => 'דיון מחיקה',
	'deletequeue-page-speedy' => "הדף הזה מועמד למחיקה מהירה.
הסיבה שניתנה לכך היא '''$1'''.",
	'deletequeue-page-prod' => "הוצע למחוק את הדף הזה.
הסיבה שניתנה לכך היא '''$1'''.
אם לא תובע התנגדות למחיקתו עד '''$2''', הדף הזה יימחק.
אפשר [{{fullurl:{{FULLPAGENAME}}|action=delvote}} להתנגד למחיקת הדף הזה].",
	'deletequeue-page-deletediscuss' => "הדף הזה הוצע למחיקה וההצעה נתקלה בהתנגדויות.
הסיבה לכך היא '''$1'''.
מתקיים דיון בדף [[$5]], והוא צפוי להסתיים ב־'''$2'''.",
	'deletequeue-notqueued' => 'הדף שבחרתם אינו מועמד למחיקה',
	'deletequeue-review-action' => 'פעולה בה יש לנקוט:',
	'deletequeue-review-delete' => 'מחיקת הדף.',
	'deletequeue-review-change' => 'למחוק את הדף, אבל עם הסבר אחר.',
	'deletequeue-review-requeue' => 'העברת דף זה לתור הבא:',
	'deletequeue-review-dequeue' => 'לא לעשות דבר, ולהוציא את הדף מתור המחיקה.',
	'deletequeue-review-reason' => 'הערות:',
	'deletequeue-review-newreason' => 'סיבה חדשה:',
	'deletequeue-review-newextra' => 'מידע נוסף:',
	'deletequeue-review-submit' => 'שמירת הסקירה',
	'deletequeue-review-original' => 'הסיבה להצעת המחיקה',
	'deletequeue-actiondisabled-involved' => 'הפעולה הבאה אינה פעילה כי השתתפתם במחיקה הזאת בתור $1:',
	'deletequeue-actiondisabled-notexpired' => 'הפעולה הבאה אינה פעילה כי המועמדות למחיקה טרם פגה:',
	'deletequeue-review-badaction' => 'ציינתם פעולה בלתי חוקית',
	'deletequeue-review-actiondenied' => 'ציינתם פעולה שאינה פעילה עבור דף זה',
	'deletequeue-review-objections' => "'''אזהרה''': יש [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} התנגדויות] למחיקת הדף הזה.
נא לוודא שההתנגדויות האלו נשקלו כראוי לפני מחיקת הדף הזה.",
	'deletequeue-reviewspeedy-tab' => 'בדיקת המחיקה המהירה',
	'deletequeue-reviewspeedy-title' => 'בדיקת המועמדות של "$1" למחיקה מהירה',
	'deletequeue-reviewspeedy-text' => "אפשר להשתמש בטופס הזה כדי לסקור את העמדת הדף \"'''\$1'''\" למחיקה מהירה.
נא לוודא שהדף הזה יכול להימחק במחיקה מהירה בהתאם למדיניות.",
	'deletequeue-reviewprod-tab' => 'בדיקת הצעות מחיקה',
	'deletequeue-reviewprod-title' => 'בדיקת ההצעה למחיקת "$1"',
	'deletequeue-reviewprod-text' => "אפשר להשתמש בטופס הזה כדי לסקור את ההצעה למחוק את הדף \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'סקירת המחיקה',
	'deletequeue-reviewdeletediscuss-title' => 'סקירת דיון המחיקה עבור "$1"',
	'deletequeue-reviewdeletediscuss-text' => "אפשר להשתמש הטופס הזה כדי לסקור את דיון המחיקה של \"'''\$1'''\".

ניתן לצפות ב[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} רשימה] של תמיכות במחיקה והתנגדויות לה, והדיון המלא נמצא בדף [[\$2]]. יש לקבל את ההחלטה רק אם יש בדיון הסכמה רחבה.",
	'deletequeue-review-success' => 'סקרתם בהצלחה את מחיקת דף זה',
	'deletequeue-review-success-title' => 'הסקירה הושלמה',
	'deletequeue-deletediscuss-discussionpage' => 'זהו דף הדיון למחיקה של [[$1]].
כעת {{PLURAL:$2|משתמש אחד תומך|$2 משתמשים תומכים}} במחיקה ו{{PLURAL:$3|משתמש אחד מתנגד|־$3 משתמשים מתנגדים}} למחיקה.
אפשר [{{fullurl:$1|action=delvote}} להביע דעה בעד או נגד המחיקה] או [{{fullurl:$1|action=delviewvotes}} להציע את כל התמיכות וההתנגדויות].',
	'deletequeue-discusscreate-summary' => 'יצירת דיון למחיקת [[$1]].',
	'deletequeue-discusscreate-text' => 'המחיקה הוצעה מהסיבה הבאה: $2',
	'deletequeue-role-nominator' => 'המציע המקורי למחיקה',
	'deletequeue-role-vote-endorse' => 'בעד המחיקה',
	'deletequeue-role-vote-object' => 'נגד המחיקה',
	'deletequeue-vote-tab' => 'הצבעה על המחיקה',
	'deletequeue-vote-title' => 'לתמוך במחיקה או להתנגד למחיקה של "$1"',
	'deletequeue-vote-text' => "בטופס הזה אפשר להביע דעה בעד או נגד המחיקה של \"'''\$1'''\".
הפעולה הזאת תדרוס כל הבעה קודמת של דעתכם על מחיקת הדף הזה.
אפשר [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} להציג] תמיכות והתנגדויות נוכחיות.
הסיבה שניתנה להצעת המחיקה היא '''\$2'''.",
	'deletequeue-vote-legend' => 'לתמוך במחיקה/להתנגד למחיקה',
	'deletequeue-vote-action' => 'המלצה:',
	'deletequeue-vote-endorse' => 'תמיכה במחיקה.',
	'deletequeue-vote-object' => 'התנגדות למחיקה.',
	'deletequeue-vote-reason' => 'הערות:',
	'deletequeue-vote-submit' => 'שליחה',
	'deletequeue-vote-success-endorse' => 'תמכתם בהצלחה במחיקת דף זה.',
	'deletequeue-vote-success-object' => 'התנגדתם בהצלחה למחיקת דף זה.',
	'deletequeue-vote-requeued' => 'התנגדתם בהצלחה למחיקת הדף הזה.
בשל התנגדותכם, הדף הועבר לתור $1.',
	'deletequeue-showvotes' => 'דעות בעד ונגד המחיקה של "$1"',
	'deletequeue-showvotes-text' => "להלן הדעות בעד ונגד המחיקה של הדף \"'''\$1'''\".
אפשר [{{fullurl:{{FULLPAGENAME}}|action=delvote}} להביע את דעתכם בעד או נגד] המחיקה הזאת.",
	'deletequeue-showvotes-restrict-endorse' => 'להציג רק תמיכות',
	'deletequeue-showvotes-restrict-object' => 'הצגת התנגדויות בלבד',
	'deletequeue-showvotes-restrict-none' => 'הצגת כל התמיכות וההתנגדויות',
	'deletequeue-showvotes-vote-endorse' => "'''בעד''' המחיקה ב־$1 $2",
	'deletequeue-showvotes-vote-object' => "'''התנגד''' למחיקה ב־$1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'מוצגות רק התמיכות',
	'deletequeue-showvotes-showingonly-object' => 'מוצגות רק ההתנגדויות',
	'deletequeue-showvotes-none' => 'אין תמיכות במחיקת דף זה או התנגדויות לה.',
	'deletequeue-showvotes-none-endorse' => 'אין תמיכות במחיקת דף זה.',
	'deletequeue-showvotes-none-object' => 'אין התנגדויות למחיקת דף זה.',
	'deletequeue' => 'תור המחיקות',
	'deletequeue-list-text' => 'דף זה מציג את כל הדפים שנמצאים במערכת המחיקה.',
	'deletequeue-list-search-legend' => 'חיפוש דפים',
	'deletequeue-list-queue' => 'תור:',
	'deletequeue-list-status' => 'מצב:',
	'deletequeue-list-expired' => 'הצגת מועמדויות הדורשות סגירה בלבד.',
	'deletequeue-list-search' => 'חיפוש',
	'deletequeue-list-anyqueue' => '(כלשהו)',
	'deletequeue-list-votes' => 'רשימת ההצבעות',
	'deletequeue-list-votecount' => '{{PLURAL:$1|תמיכה אחת|$1 תמיכות}}, {{PLURAL:$2|התנגדות אחת|$2 התנגדויות}}',
	'deletequeue-list-header-page' => 'דף',
	'deletequeue-list-header-queue' => 'תור',
	'deletequeue-list-header-votes' => 'תמיכות והתנגדויות',
	'deletequeue-list-header-expiry' => 'תפוגה',
	'deletequeue-list-header-discusspage' => 'דף השיחה',
	'deletequeue-case-intro' => 'דף זה מציג מידע אודות מקרה מחיקה מסוים.',
	'deletequeue-list-header-reason' => 'סיבת המחיקה',
	'deletequeue-case-votes' => 'תמיכות/התנגדויות:',
	'deletequeue-case-title' => 'פרטי מקרה המחיקה',
	'deletequeue-case-details' => 'פרטים בסיסיים',
	'deletequeue-case-page' => 'דף:',
	'deletequeue-case-reason' => 'סיבה:',
	'deletequeue-case-expiry' => 'תפוגה:',
	'deletequeue-case-needs-review' => 'מקרה זה דורש [[$1|סקירה]].',
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
	'deletequeue-reviewprod-title' => 'Namjetowane wušmórnjenje za "$1" přepruwować',
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
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'deletequeue-desc' => '[[Special:DeleteQueue|Várakozási soron alapuló rendszer a törlések kezelésére]]',
	'deletequeue-action-queued' => 'Törlés',
	'deletequeue-action' => 'Törlés javasolása',
	'deletequeue-action-title' => '„$1” törlésre javasolása',
	'deletequeue-action-text' => "Ezen a wikin több menete is lehet a lapok törlésének:
* ha úgy hiszed, hogy indokolt, akkor [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} javasolhatod ''azonanli törlés''re],
* ha nem indokolt az azonnali törlés, de a ''lap törlése várhatóan nem lesz vita tárgya'', [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} ajánld egyértelmű törlésre],
* ha pedig egy lap törlése ''várhatóan vitatható'', akkor [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} nyiss róla megbeszélést].",
	'deletequeue-action-text-queued' => 'Ebben a törlési ügyben releváns lapok:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} aktuális jóváhagyások és ellenvetések megjelenítése],
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} lap törlésének jóváhagyása vagy ellenzése].',
	'deletequeue-permissions-noedit' => 'Képesnek kell lenned szerkeszteni egy lapot, hogy befolyásolni tudd a törlési állapotát.',
	'deletequeue-generic-reasons' => '* Általános indokok
** Vandalizmus
** Spam
** Karbantartás
** Nem a projekthez kapcsolódó',
	'deletequeue-nom-alreadyqueued' => 'Ez a lap már a törlési várakozási sorban van.',
	'deletequeue-speedy-title' => '„$1” jelölése azonnali törlésre',
	'deletequeue-speedy-text' => 'Ezen az űrlapon jelölheted a(z) „$1” lapot azonnali törlésre.

Egy adminisztrátor megvizsgálja a kérésed, és ha megalapozott, törölni fogja a lapot.
Ki kell választanod egy okot a törlésre a lenti legördülő listából alább, és adj meg minden további releváns információt.',
	'deletequeue-prod-title' => '„$1” ajánlása törlésre',
	'deletequeue-prod-text' => "Ezen az űrlapon ajánlhatod a(z) „'''$1'''” lapot törlésre.

Ha öt nap után sem vonta kétségbe a törlést, egy végső ellenőrzés során eltávolítja valamelyik adminisztrátor.",
	'deletequeue-delnom-reason' => 'A jelölés oka:',
	'deletequeue-delnom-otherreason' => 'Más indok',
	'deletequeue-delnom-extra' => 'További információ:',
	'deletequeue-delnom-submit' => 'Jelölés elküldése',
	'deletequeue-log-nominate' => '[[$1]] törlésre jelölve vár a(z) „$2” várakozási sorban',
	'deletequeue-log-rmspeedy' => 'elutasította [[$1]] azonnali törlését.',
	'deletequeue-log-requeue' => 'áthelyezte a(z) [[$1]] lapot egy másik várakozási sorba? „$2” → „$3”',
	'deletequeue-log-dequeue' => 'eltávolította a(z) [[$1]] lapot a következő várakozási sorból: „$2”.',
	'right-speedy-nominate' => 'lapok jelölése azonnali törlésre',
	'right-speedy-review' => 'azonnali törlésre jelölések elbírálása',
	'right-prod-nominate' => 'lap törlésének ajánlása',
	'right-prod-review' => 'egyértelmű törlési ajánlások elbírálása',
	'right-deletediscuss-nominate' => 'Törlési megbeszélések elkezdése',
	'right-deletediscuss-review' => 'Törlési megbeszélések lezárása',
	'right-deletequeue-vote' => 'törlések jóváhagyása vagy ellenzése',
	'deletequeue-queue-speedy' => 'Azonnali törlés',
	'deletequeue-queue-prod' => 'Javasolt törlés',
	'deletequeue-queue-deletediscuss' => 'Törlési megbeszélés',
	'deletequeue-page-speedy' => "Ezt a lapot jelölték azonnali törlésre.
A megadott indoklás a következő: ''$1''.",
	'deletequeue-page-prod' => "Ezt a lapot törlésre ajánlották.
Indoklás: ''$1''.
Ha a javaslatot nem vitatják eddig: ''$2'', akkor a lapot töröljük.
Megkérdőjelezheted a lap törlését, [{{fullurl:{{FULLPAGENAME}}|action=delvote}} ha itt ellenzed azt].",
	'deletequeue-page-deletediscuss' => "Ezt a lapot ajánlották törlésre, és az ajánlást vitatják.
Indoklás: ''$1''.
Folyamatban lévő megbeszélés: [[$5]], lezárás: ''$2''.",
	'deletequeue-notqueued' => 'A kiválasztott lap jelenleg nem vár törlésre',
	'deletequeue-review-action' => 'Elvégzendő művelet:',
	'deletequeue-review-delete' => 'A lap törlése.',
	'deletequeue-review-change' => 'Lap törlése más indokkal.',
	'deletequeue-review-requeue' => 'Lap áthelyezése a következő várakozási sorba:',
	'deletequeue-review-dequeue' => 'Nincs művelet, és a lap eltávolítása a törlési várakozási sorból.',
	'deletequeue-review-reason' => 'Megjegyzések:',
	'deletequeue-review-newreason' => 'Új indok:',
	'deletequeue-review-newextra' => 'További információ:',
	'deletequeue-review-submit' => 'Bírálat mentése',
	'deletequeue-review-original' => 'Jelölés indoklása',
	'deletequeue-actiondisabled-involved' => 'A következő művelet letiltva, mivel már részt vettél ebben a törlési ügyben mint $1:',
	'deletequeue-actiondisabled-notexpired' => 'A következő művelet letiltva, mivel a törlésre jelölés még nem járt le:',
	'deletequeue-review-badaction' => 'Érvénytelen műveletet adtál meg',
	'deletequeue-review-actiondenied' => 'A művelet letiltva ezen a lapon',
	'deletequeue-review-objections' => "'''Figyelmeztetés''': a lap törlésének [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} vannak ellenzői].
Fontold meg alaposan ezeket az ellenvetéseket a lap törlése előtt.",
	'deletequeue-reviewspeedy-tab' => 'Azonnali törlés elbírálása',
	'deletequeue-reviewspeedy-title' => '„$1” azonnali törlésre jelölésének elbírálása',
	'deletequeue-reviewspeedy-text' => "Ennek az űrlapnak a segítségével ellenőrizheted a(z) „'''$1'''” lap azonnali törlésre jelölését.
Bizonyosodj meg róla, hogy a lap az irányelvek szerint azonnal törölhető-e.",
	'deletequeue-reviewprod-tab' => 'Törlési ajánlás elbírálása',
	'deletequeue-reviewprod-title' => '„$1” ajánlott törlésének elbírálása',
	'deletequeue-reviewprod-text' => "Az űrlap segítségével elbírálhatod a(z) „'''$1'''” törlésének egyértelmű jelölését.",
	'deletequeue-reviewdeletediscuss-tab' => 'Törlés elbírálása',
	'deletequeue-reviewdeletediscuss-title' => '„$1” törlési megbeszélésének ellenőrzése',
	'deletequeue-reviewdeletediscuss-text' => "Ennek az űrlapnak a segítségével ellenőrizheted a(z) „'''$1'''”  törlési megbeszélését.

Elérhető a jóváhagyások és ellenvetések [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} listája], a megbeszélés pedig a(z) [[$2]] lapon folyik.
A döntésednél gondold át, hogy összhangban van-e a törlési megbeszélésen kialakult konszenzussal.",
	'deletequeue-review-success' => 'Sikeresen ellenőrizted a lap törlését',
	'deletequeue-review-success-title' => 'Ellenőrzés kész',
	'deletequeue-deletediscuss-discussionpage' => 'A(z) [[$1]] lap törlésének vitalapja.
Jelenleg $2 felhasználó jóváhagyta és $3 ellenzi a törlést.
[{{fullurl:$1|action=delvote}} Támogathatod vagy ellenezheted] a törlést, vagy [{{fullurl:$1|action=delviewvotes}} megnézheted az eddigi jóváhagyásokat és ellenzéseket].',
	'deletequeue-discusscreate-summary' => 'Vitalap létrehozása a(z) [[$1]] lap törléséhez.',
	'deletequeue-discusscreate-text' => 'Törlési ajánlás a következő indokkal: $2',
	'deletequeue-role-nominator' => 'az eredeti törlésre jelölő',
	'deletequeue-role-vote-endorse' => 'a törlés jóváhagyója',
	'deletequeue-role-vote-object' => 'a törlés ellenzője',
	'deletequeue-vote-tab' => 'Szavazás a törlésen',
	'deletequeue-vote-title' => '„$1” törlésének jóváhagyása vagy ellenzése',
	'deletequeue-vote-text' => "Ennek az űrlapnak a segítségével támogathatod vagy ellenezheted a(z) „'''$1'''” lap törlését.
Ez felülbírálja minden korábbi jóváhagyásod/ellenvetésed a lap törlésével kapcsolatban.
[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Itt megnézheted] az eddigi jóváhagyásokat és ellenvetéseket.
A törlésre jelölés indoklása a következő volt: ''$2''.",
	'deletequeue-vote-legend' => 'Törlés jóváhagyása/ellenzése',
	'deletequeue-vote-action' => 'Javaslat:',
	'deletequeue-vote-endorse' => 'Törlés jóváhagyása.',
	'deletequeue-vote-object' => 'Törlés ellenzése.',
	'deletequeue-vote-reason' => 'Megjegyzések:',
	'deletequeue-vote-submit' => 'Elküldés',
	'deletequeue-vote-success-endorse' => 'Sikeresen támogattad a lap törlését.',
	'deletequeue-vote-success-object' => 'Sikeresen ellenezted a lap törlését.',
	'deletequeue-vote-requeued' => 'Sikeresen ellenezted a lap törlését.
Emiatt a lap átkerült a(z) $1 várakozási sorba.',
	'deletequeue-showvotes' => 'a(z) „$1” lap törlésének támogatói és ellenzői',
	'deletequeue-showvotes-text' => "A(z) „'''$1'''” lap törlésének jóváhagyásai és ellenvetései alább láthatóak.
[{{fullurl:{{FULLPAGENAME}}|action=delvote}} Magad is jóváhagyhatod vagy ellenezheted] a törlést.",
	'deletequeue-showvotes-restrict-endorse' => 'Csak a jóváhagyások megjelenítése',
	'deletequeue-showvotes-restrict-object' => 'Csak az ellenvetések megjelenítése',
	'deletequeue-showvotes-restrict-none' => 'Az összes jóváhagyás és ellenvetés megjelenítése',
	'deletequeue-showvotes-vote-endorse' => "'''Jóváhagyta''' a törlést ($1 $2)",
	'deletequeue-showvotes-vote-object' => "'''Ellenezte''' a törlést ($1 $2)",
	'deletequeue-showvotes-showingonly-endorse' => 'Csak a jóváhagyások mutatása',
	'deletequeue-showvotes-showingonly-object' => 'Csak az ellenvetések mutatása',
	'deletequeue-showvotes-none' => 'A lap törlésének nincsenek se támogatói, se ellenzői.',
	'deletequeue-showvotes-none-endorse' => 'A lap törlésének nincsenek támogatói.',
	'deletequeue-showvotes-none-object' => 'A lap törlésének nincsenek ellenzői.',
	'deletequeue' => 'Törlési várakozási sor',
	'deletequeue-list-text' => 'Az összes törlési rendszerben szereplő lap megjelenítése.',
	'deletequeue-list-search-legend' => 'Lapok keresése',
	'deletequeue-list-queue' => 'Várakozási sor:',
	'deletequeue-list-status' => 'Állapot:',
	'deletequeue-list-expired' => 'Csak a lezárásra váró jelölések megjelenítése.',
	'deletequeue-list-search' => 'Keresés',
	'deletequeue-list-anyqueue' => '(bármelyik)',
	'deletequeue-list-votes' => 'Szavazatok listázása',
	'deletequeue-list-votecount' => '$1 jóváhagyás, $2 ellenvetés',
	'deletequeue-list-header-page' => 'Lap',
	'deletequeue-list-header-queue' => 'Várakozási sor',
	'deletequeue-list-header-votes' => 'Jóváhagyások és ellenvetések',
	'deletequeue-list-header-expiry' => 'Lejárat',
	'deletequeue-list-header-discusspage' => 'Vitalap',
	'deletequeue-case-intro' => 'Információk listázása konkrét törlési ügyről.',
	'deletequeue-list-header-reason' => 'A törlés oka:',
	'deletequeue-case-votes' => 'Jóváhagyások/ellenvetések:',
	'deletequeue-case-title' => 'Törlési ügy részletei',
	'deletequeue-case-details' => 'Alapvető részletek',
	'deletequeue-case-page' => 'Lap:',
	'deletequeue-case-reason' => 'Indoklás:',
	'deletequeue-case-expiry' => 'Lejárat:',
	'deletequeue-case-needs-review' => 'Ez az ügy [[$1|ellenőrzésre]] vár.',
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
	'deletequeue-review-submit' => 'Salveguardar revision',
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
Iste action ignorara omne previe declarationes pro/contra que tu ha date a proposito del deletion de iste pagina.
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
 * @author Bennylin
 * @author Farras
 * @author IvanLanin
 * @author Kandar
 * @author Rex
 */
$messages['id'] = array(
	'deletequeue-desc' => 'Membuat [[Special:DeleteQueue|sistem berbasis antrean untuk mengelola penghapusan]]',
	'deletequeue-action-queued' => 'Penghapusan',
	'deletequeue-action' => 'Usulkan penghapusan',
	'deletequeue-action-title' => 'Usulkan penghapusan untuk "$1"',
	'deletequeue-action-text' => "Wiki ini memiliki sejumlah proses untuk menghapus halaman:
* Jika Anda yakin bahwa halaman ini layak dihapus, Anda dapat [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} menyarankan '' penghapusan cepat''].
* Jika halaman ini tidak memenuhi kriteria penghapusan cepat, tetapi ''penghapusan kemungkinan tidak kontroversial '', Anda harus [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} menyarankan penghapusan tanpa tentangan].
* Jika penghapusan halaman ini ''kemungkinan diperdebatkan'', Anda harus [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} membuka diskusi penghapusan].",
	'deletequeue-action-text-queued' => 'Anda dapat melihat halaman berikut untuk kasus penghapusan ini:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Lihat dukungan dan penolakan terbaru].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Dukung atau tolak penghapusan halaman ini].',
	'deletequeue-permissions-noedit' => 'Anda harus mampu menyunting halaman untuk mengubah status penghapusan.',
	'deletequeue-generic-reasons' => '* Alasan umum
** Vandalisme
** Spam
** Perawatan
** Di luar cakupan proyek',
	'deletequeue-nom-alreadyqueued' => 'Halaman ini sudah masuk daftar penghapusan.',
	'deletequeue-speedy-title' => 'Tandai "$1" untuk penghapusan cepat',
	'deletequeue-speedy-text' => "Anda dapat menggunakan formulir ini untuk menandai halaman \"'''\$1'''\" untuk penghapusan cepat.

Administrator akan meninjau permintaan ini dan menghapus halaman jika alasannya tepat.
Anda harus memilih alasan penghapusan dari daftar tarik-turun di bawah dan menambahkan informasi terkait lainnya.",
	'deletequeue-prod-title' => 'Ajukan penghapusan "$1"',
	'deletequeue-prod-text' => "Anda dapat menggunakan formulir ini untuk mengusulkan penghapusan \"'''\$1'''\".

Jika, setelah lima hari, tidak seorang pun menentang penghapusan halaman ini, penghapusan akan dilakukan setelah peninjauan akhir oleh pengurus.",
	'deletequeue-delnom-reason' => 'Alasan pengusulan:',
	'deletequeue-delnom-otherreason' => 'Alasan lain',
	'deletequeue-delnom-extra' => 'Informasi tambahan:',
	'deletequeue-delnom-submit' => 'Kirimkan usulan',
	'deletequeue-log-nominate' => "mengusulkan penghapusan [[$1]] pada antrean '$2'.",
	'deletequeue-log-rmspeedy' => 'menolak menghapus cepat [[$1]].',
	'deletequeue-log-requeue' => "memindahkan [[$1]] ke daftar penghapusan lain: dari '$2' ke '$3'.",
	'deletequeue-log-dequeue' => "menghapus [[$1]] dari daftar penghapusan '$2'.",
	'right-speedy-nominate' => 'Usulkan halaman untuk penghapusan segera',
	'right-speedy-review' => 'Tinjau pencalonan penghapusan cepat',
	'right-prod-nominate' => 'Usulkan penghapusan halaman',
	'right-prod-review' => 'Tinjau proposal penghapusan tanpa tentangan',
	'right-deletediscuss-nominate' => 'Mulai pembicaraan penghapusan',
	'right-deletediscuss-review' => 'Tutup pembicaraan penghapusan',
	'right-deletequeue-vote' => 'Dukungan atau tolakan terhadap penghapusan',
	'deletequeue-queue-speedy' => 'Penghapusan segera',
	'deletequeue-queue-prod' => 'Penghapusan yang diusulkan',
	'deletequeue-queue-deletediscuss' => 'Pembicaraan penghapusan',
	'deletequeue-page-speedy' => "Halaman ini telah dicalonkan untuk penghapusan cepat.
Alasan yang diberikan untuk penghapusan ini adalah ''$1''.",
	'deletequeue-page-prod' => "Halaman ini telah disarankan untuk dihapus.
Alasan yang diberikan adalah ''\$1''.
Jika proposal ini tidak ditentang di ''\$ 2'', halaman akan dihapus.
Anda dapat menentang penghapusan halaman ini dengan [{{fullurl:{{FULLPAGENAME}}|action=delvote}} memberikan alasan penolakan].",
	'deletequeue-page-deletediscuss' => "Halaman ini telah diusulkan untuk dihapus dan usulan tersebut telah ditentang.
Alasan yang diberikan adalah ''$1''.
Diskusi sedang berlangsung di [[$5]] dan akan disimpulkan di ''$2''.",
	'deletequeue-notqueued' => 'Halaman yang Anda pilih saat ini tidak masuk dalam daftar penghapusan',
	'deletequeue-review-action' => 'Langkah yang diambil:',
	'deletequeue-review-delete' => 'Hapus halaman.',
	'deletequeue-review-change' => 'Hapus halaman ini, tapi dengan alasan berbeda.',
	'deletequeue-review-requeue' => 'Pindahkan halaman ini ke daftar berikut:',
	'deletequeue-review-dequeue' => 'Tidak mengambil langkah apa pun, dan hapus halaman dari daftar penghapusan.',
	'deletequeue-review-reason' => 'Komentar:',
	'deletequeue-review-newreason' => 'Alasan baru:',
	'deletequeue-review-newextra' => 'Informasi tambahan:',
	'deletequeue-review-submit' => 'Simpan Tinjauan',
	'deletequeue-review-original' => 'Alasan pencalonan',
	'deletequeue-actiondisabled-involved' => 'Tindakan berikut dinonaktifkan karena Anda telah mengambil bagian dalam kasus penghapusan ini sebagai $1:',
	'deletequeue-actiondisabled-notexpired' => 'Langkah berikut dilarang karena pencalonan penghapusan belum kedaluwarsa:',
	'deletequeue-review-badaction' => 'Anda melakukan tindakan yang tidak sah',
	'deletequeue-review-actiondenied' => 'Anda melakukan tindakan yang dilarang untuk halaman ini',
	'deletequeue-review-objections' => "'''Perhatian''': Penghapusan halaman ini memiliki [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} penolakan].
Pastikan bahwa Anda telah mempertimbangkan penolakan tersebut sebelum menghapus halaman ini.",
	'deletequeue-reviewspeedy-tab' => 'Tinjau penghapusan cepat',
	'deletequeue-reviewspeedy-title' => 'Tinjau pencalonan penghapusan cepat "$1".',
	'deletequeue-reviewspeedy-text' => "Anda dapat menggunakan formulis ini untuk meninjau pencalonan \"'''\$1'''\" untuk penghapusan cepat.
Pastikan bahwa halaman ini dihapus cepat sesuai dengan kebijakan.",
	'deletequeue-reviewprod-tab' => 'Tinjau penghapusan yang diajukan',
	'deletequeue-reviewprod-title' => 'Tinjau penghapusan yang diajukan kepada "$1"',
	'deletequeue-reviewprod-text' => "Anda dapat menggunakan formulir ini untuk meninjau proposal tanpa tentangan untuk penghapusan \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Tinjau penghapusan',
	'deletequeue-reviewdeletediscuss-title' => 'Tinjau pembicaraan penghapusan "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Anda dapat menggunakan formulis ini untuk meninjau pembicaraan penghapusan \"'''\$1'''\".

[{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Daftar] dukungan dan penolakan penghapusan ini tersedia, dan pembicaraannya bisa dilihat di [[\$2]].
Parstikan bahwa Anda membuat keputusan sesuai konsensus di halaman pembicaraan.",
	'deletequeue-review-success' => 'Anda selesai memeriksa peninjauan halaman ini',
	'deletequeue-review-success-title' => 'Peninjauan selesai',
	'deletequeue-deletediscuss-discussionpage' => 'Ini adalah halaman diskusi untuk penghapusan [[$1]].
Saat ini ada $2 {{PLURAL:$2|pengguna|pengguna}} yang mendukung penghapusan dan $3 {{PLURAL:$3|pengguna|pengguna}} yang menolak.
Anda dapat [{{fullurl:$1|action=delvote}} mendukung atau menolak] penghapusan, atau [{{fullurl:$1|action=delviewvotes}} melihat semua dukungan dan penolakan].',
	'deletequeue-discusscreate-summary' => 'Membuat pembicaraan untuk penghapusan [[$1]].',
	'deletequeue-discusscreate-text' => 'Penghapusan diajukan karena alasan berikut: $2',
	'deletequeue-role-nominator' => 'pencalon penghapusan',
	'deletequeue-role-vote-endorse' => 'pendorong penghapusan',
	'deletequeue-role-vote-object' => 'penolak penghapusan',
	'deletequeue-vote-tab' => 'Pilih pada penghapusan',
	'deletequeue-vote-title' => 'Dukung atau tolak penghapusan "$1"',
	'deletequeue-vote-text' => "Anda dapat menggunakan formulir ini untuk mendukung atau menolak penghapusan \"'''\$1'''\".
Tindakan ini akan mengganti semua dukungan/penolakan telah Anda berikan kepada penghapusan halaman ini.
Anda dapat [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} melihat] dukungan dan penolakan yang sudah ada.
Alasan yang diberikan dalam saran penghapusan adalah ''\$2''.",
	'deletequeue-vote-legend' => 'Dukungan/Keberatan terhadap penghapusan',
	'deletequeue-vote-action' => 'Rekomendasi:',
	'deletequeue-vote-endorse' => 'Dukung penghapusan.',
	'deletequeue-vote-object' => 'Tolak penghapusan.',
	'deletequeue-vote-reason' => 'Komentar:',
	'deletequeue-vote-submit' => 'Kirim',
	'deletequeue-vote-success-endorse' => 'Anda berhasil mendukung penghapusan halaman ini.',
	'deletequeue-vote-success-object' => 'Anda berhasil menolak penghapusan halaman ini.',
	'deletequeue-vote-requeued' => 'Anda berhasil menolak penghapusan halaman ini.
Karena penolakan Anda, halaman ini telah dipindahkan ke daftar $1.',
	'deletequeue-showvotes' => 'Dukungan dan penolakan terhadap penghapusan "$1"',
	'deletequeue-showvotes-text' => "Di bawah adalah dukungan dan penolakan terhadap penghapusan halaman \"'''\$1'''\".
Anda dapat [{{fullurl:{{FULLPAGENAME}}|action=delvote}} mendaftarkan dukungan atau penolakan Anda] terhadap penghapusan ini.",
	'deletequeue-showvotes-restrict-endorse' => 'Tampilkan dukungan saja',
	'deletequeue-showvotes-restrict-object' => 'Tampilkan penolakan saja',
	'deletequeue-showvotes-restrict-none' => 'Tampilkan semua dukungan dan penolakan',
	'deletequeue-showvotes-vote-endorse' => "'''Dukungan''' penghapusan di $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Penolakan''' penghapusan di $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Hanya perlihatkan dukungan',
	'deletequeue-showvotes-showingonly-object' => 'Hanya perlihatkan penolakan',
	'deletequeue-showvotes-none' => 'Tidak ada dukungan atau penolakan penghapusan halaman ini.',
	'deletequeue-showvotes-none-endorse' => 'Tidak ada dukungan penghapusan halaman ini.',
	'deletequeue-showvotes-none-object' => 'Tidak ada penolakan penghapusan halaman ini.',
	'deletequeue' => 'Daftar penghapusan',
	'deletequeue-list-text' => 'Halaman ini menampilkan semua halaman yang berada dalam sistem penghapusan.',
	'deletequeue-list-search-legend' => 'Cari halaman',
	'deletequeue-list-queue' => 'Antrean:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Hanya perlihatkan pencalonan yang membutuhkan penutupan.',
	'deletequeue-list-search' => 'Cari',
	'deletequeue-list-anyqueue' => '(apa pun)',
	'deletequeue-list-votes' => 'Daftar suara',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|dukungan|dukungan}}, $2 {{PLURAL:$2|penolakan|penolakan}}',
	'deletequeue-list-header-page' => 'Halaman',
	'deletequeue-list-header-queue' => 'Antrean',
	'deletequeue-list-header-votes' => 'Dukungan dan penolakan',
	'deletequeue-list-header-expiry' => 'Kedaluwarsa',
	'deletequeue-list-header-discusspage' => 'Halaman pembicaraan',
	'deletequeue-case-intro' => 'Halaman ini berisi informasi mengenai kasus penghapusan tertentu.',
	'deletequeue-list-header-reason' => 'Alasan penghapusan',
	'deletequeue-case-votes' => 'Dukungan/penolakan:',
	'deletequeue-case-title' => 'Rincian kasus penghapusan',
	'deletequeue-case-details' => 'Rincian dasar',
	'deletequeue-case-page' => 'Halaman:',
	'deletequeue-case-reason' => 'Alasan:',
	'deletequeue-case-expiry' => 'Kedaluwarsa:',
	'deletequeue-case-needs-review' => 'Kasus ini membutuhkan [[$1|tinjauan]].',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'deletequeue-list-search' => 'Chọwa',
	'deletequeue-case-reason' => 'Mgbághapụtà:',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'deletequeue-list-search' => 'Biroken',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'deletequeue-delnom-otherreason' => 'Altra motivo',
	'deletequeue-list-header-expiry' => 'Expiro',
	'deletequeue-case-expiry' => 'Expiro:',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 * @author Melos
 * @author Nemo bis
 */
$messages['it'] = array(
	'deletequeue-desc' => 'Crea un [[Special:DeleteQueue|sistema per gestire le cancellazioni basato su code]]',
	'deletequeue-action-queued' => 'Cancellazione',
	'deletequeue-action' => 'Proponi cancellazione',
	'deletequeue-action-title' => 'Proponi la cancellazione di "$1"',
	'deletequeue-action-text' => "{{SITENAME}} ha una serie di processi per la cancellazione delle pagine:
*Se si crede che questa pagina debba essere ''cancellata immediatamente'', lo si può suggerire [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} qui].
*Se questa pagina non può essere cancellata immediatamente ma la sua ''cancellazione sarà probabilmente incontroversa'', dovrebbe essere [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} proposta per la cancellazione].
*Se la cancellazione di questa pagina è ''probabilmente discutibile'', si dovrebbe [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} aprire una discussione].",
	'deletequeue-action-text-queued' => 'È possibile visualizzare le pagine seguenti per questa cancellazione:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Visualizza i supporti e le obiezioni attuali].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Supporta o opponiti alla cancellazione di questa pagina].',
	'deletequeue-permissions-noedit' => 'Si deve essere in grado di modificare una pagina per modificarne lo stato di cancellazione.',
	'deletequeue-generic-reasons' => '*Motivazioni generiche
** Vandalismo
** Spam
** Manutenzione
** Al di fuori degli scopi del progetto',
	'deletequeue-nom-alreadyqueued' => 'Questa pagina è già in cancellazione.',
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
	'right-deletequeue-vote' => 'Supporta o si oppone alle cancellazioni',
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
	'deletequeue-review-success' => 'Hai correttamente verificato la cancellazione di questa pagina',
	'deletequeue-review-success-title' => 'Verifica completa',
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
	'deletequeue-showvotes-showingonly-endorse' => 'Mostra solo i supporti',
	'deletequeue-showvotes-showingonly-object' => 'Mostra solo le opposizioni',
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
	'deletequeue-case-intro' => 'Questa pagina elenca le informazioni su una specifica cancellazione',
	'deletequeue-list-header-reason' => 'Motivazione per la cancellazione',
	'deletequeue-case-votes' => 'Supporti/opposizioni:',
	'deletequeue-case-title' => 'Dettagli sulla cancellazione',
	'deletequeue-case-details' => 'Informazioni di base',
	'deletequeue-case-page' => 'Pagina:',
	'deletequeue-case-reason' => 'Motivo:',
	'deletequeue-case-expiry' => 'Scadenza:',
	'deletequeue-case-needs-review' => 'Questo caso richiede una [[$1|verifica]].',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author 青子守歌
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
	'deletequeue-deletediscuss-discussionpage' => 'これは [[$1]] の削除について議論するページです。現時点で、$2人の{{PLURAL:$2|利用者}}が削除に賛成し、$3人の{{PLURAL:$3|利用者}}が削除に反対しています。あなたは削除に[{{fullurl:$1|action=delvote}} 賛成または反対]をするか、[{{fullurl:$1|action=delviewvotes}} すべての賛成と反対を見る]ことができます。',
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
	'deletequeue-list-votecount' => '賛成$1{{PLURAL:$1|票}}、反対$2{{PLURAL:$2|票}}',
	'deletequeue-list-header-page' => 'ページ',
	'deletequeue-list-header-queue' => 'キュー',
	'deletequeue-list-header-votes' => '賛成と反対',
	'deletequeue-list-header-expiry' => '有効期限',
	'deletequeue-list-header-discusspage' => '議論ページ',
	'deletequeue-case-intro' => 'このページでは特定の削除事例の情報を一覧しています。',
	'deletequeue-list-header-reason' => '削除理由',
	'deletequeue-case-votes' => '賛成/反対:',
	'deletequeue-case-title' => '削除事例詳細',
	'deletequeue-case-details' => '概要',
	'deletequeue-case-page' => 'ページ:',
	'deletequeue-case-reason' => '理由：',
	'deletequeue-case-expiry' => '有効期限：',
	'deletequeue-case-needs-review' => 'この事例には[[$1|審査]]が必要です。',
);

/** Georgian (ქართული)
 * @author David1010
 */
$messages['ka'] = array(
	'right-speedy-nominate' => 'გვერდების ნომინირება სწრაფი წაშლისათვის',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬)
 * @author GaiJin
 */
$messages['kk-cyrl'] = array(
	'deletequeue-list-search' => 'Іздеу',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
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
	'right-prod-nominate' => 'ការស្នើសុំលុបចោលទំព័រ',
	'right-deletediscuss-nominate' => 'ចាប់ផ្ដើម​កិច្ចពិភាក្សា​អំពី​ការលុប',
	'right-deletediscuss-review' => 'បិទ​កិច្ចពិភាក្សា​អំពី​ការលុប',
	'right-deletequeue-vote' => 'យល់ស្រប ឬ ជំទាស់​ចំពោះ​ការលុប',
	'deletequeue-queue-speedy' => 'លុប​ឱ្យ​បាន​លឿន',
	'deletequeue-queue-prod' => 'ការលុបចោលដែលត្រូវបានស្នើ',
	'deletequeue-queue-deletediscuss' => 'កិច្ចពិភាក្សា​អំពី​ការលុប',
	'deletequeue-review-action' => 'សកម្មភាពត្រូវ​អនុវត្ត​៖',
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
	'deletequeue-list-header-expiry' => 'ផុតកំណត់​',
	'deletequeue-list-header-discusspage' => 'ទំព័រ​ពិភាក្សា',
	'deletequeue-list-header-reason' => 'មូលហេតុនៃការលុប៖',
	'deletequeue-case-details' => 'ព័ត៌មាន​លម្អិត​មូលដ្ឋាន',
	'deletequeue-case-page' => 'ទំព័រ៖',
	'deletequeue-case-reason' => 'មូលហេតុ៖',
	'deletequeue-case-expiry' => 'ផុតកំណត់​៖',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'deletequeue-delnom-otherreason' => 'ಇತರ ಕಾರಣ',
	'deletequeue-list-status' => 'ಸ್ಥಾನಮಾನ:',
	'deletequeue-list-search' => 'ಹುಡುಕು',
	'deletequeue-case-reason' => 'ಕಾರಣ:',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'deletequeue-list-search' => 'Luk foh am',
);

/** Colognian (Ripoarisch)
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
Der Klaaf do drövver op [[$5]] jeiht bes aam $3 öm $4 Uhr.",
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
	'deletequeue-vote-submit' => 'Lohß Jonn!',
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

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'deletequeue-action-queued' => 'Jêbirin',
	'deletequeue-review-newreason' => 'Sedema nû:',
	'deletequeue-list-header-reason' => 'Sdema jêbirinê',
	'deletequeue-case-reason' => 'Sedem:',
);

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'deletequeue-list-search' => 'Whila',
	'deletequeue-list-anyqueue' => '(veth)',
	'deletequeue-case-page' => 'Folen:',
);

/** Latin (Latina)
 * @author Omnipaedista
 */
$messages['la'] = array(
	'deletequeue-action-queued' => 'Deletio',
	'deletequeue-delnom-otherreason' => 'Causa alia',
	'deletequeue-list-search-legend' => 'Quaerere paginas',
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
	'deletequeue-speedy-title' => '"$1" fir séier ze läsche markéieren',
	'deletequeue-prod-title' => 'D\'Läsche vu(n) "$1" virschloen',
	'deletequeue-delnom-reason' => "Grond fir d'Ufro (fir ze läschen):",
	'deletequeue-delnom-otherreason' => 'Anere Grond',
	'deletequeue-delnom-extra' => 'Zousätzlech Informatioun:',
	'deletequeue-delnom-submit' => 'Nominatioun fortschécken',
	'deletequeue-log-rmspeedy' => 'huet ofgelehnt fir [[$1]] séier ze läschen.',
	'right-speedy-nominate' => 'Säite virschloe fir séier ze läschen',
	'right-speedy-review' => 'Nominatioune fir e séiert Läschen nokucken',
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
	'deletequeue-review-submit' => 'Nokucke späicheren',
	'deletequeue-review-original' => "Grond fir d'Nominatioun",
	'deletequeue-review-badaction' => 'Dir hut eng Aktioun uginn déi net valabel ass',
	'deletequeue-review-actiondenied' => 'dir hutt eng Aktioun uginn déi fir dës Säit ausgeschalt ass',
	'deletequeue-reviewspeedy-tab' => 'Séier läschen iwwerpréifen',
	'deletequeue-reviewprod-tab' => 'Virgeschloe Läschung nokucken',
	'deletequeue-reviewdeletediscuss-tab' => 'Läschen iwwerpréifen',
	'deletequeue-reviewdeletediscuss-title' => 'Diskussioun iwwer d\'Läsche vu(n) "$1" nokucken',
	'deletequeue-review-success' => "Dir hutt d'Läsche vun dëser Säit elo nogekuckt",
	'deletequeue-review-success-title' => 'Komplett nogekuckt',
	'deletequeue-discusscreate-summary' => "Diskussioun fir d'Läsche vun [[$1]] gëtt ugeluecht.",
	'deletequeue-discusscreate-text' => "D'Läsche gouf aus dësem Grond virgeschlo: $2",
	'deletequeue-role-vote-endorse' => "Fir d'Läschen",
	'deletequeue-role-vote-object' => "Géint d'Läschen",
	'deletequeue-vote-tab' => "Iwwer d'Läschen ofstëmmen",
	'deletequeue-vote-legend' => "Dem Läschen zoustëmmen/Géint d'Läsche stëmmen",
	'deletequeue-vote-action' => 'Rot:',
	'deletequeue-vote-endorse' => 'Läschen ënnerstëtzen',
	'deletequeue-vote-object' => "Géint d'Läschen",
	'deletequeue-vote-reason' => 'Bemierkungen:',
	'deletequeue-vote-success-endorse' => 'Dir hutt dem läsche vun dëser Säit zougestëmmt.',
	'deletequeue-showvotes-restrict-endorse' => 'Nëmmem Zoustëmmunge weisen',
	'deletequeue-showvotes-showingonly-endorse' => "Nëmmen d'Zoustëmmunge gi gewisen",
	'deletequeue-showvotes-none-object' => 'Et gëtt keng Objectioune fir dës Säit ze läschen.',
	'deletequeue' => 'Läsch-Queue',
	'deletequeue-list-text' => 'Op dëser Säit stinn all déi Säiten déi am Läschsystem dra sinn.',
	'deletequeue-list-search-legend' => 'Säite sichen:',
	'deletequeue-list-queue' => 'Queue:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-search' => 'Sichen',
	'deletequeue-list-anyqueue' => '(iergendeng)',
	'deletequeue-list-votes' => 'Lëscht vun de Stëmmen',
	'deletequeue-list-header-page' => 'Säit',
	'deletequeue-list-header-queue' => 'Queue',
	'deletequeue-list-header-discusspage' => 'Diskussiounssäit',
	'deletequeue-list-header-reason' => "Grond fir d'Läschen",
	'deletequeue-case-details' => 'Basisinformatiounen',
	'deletequeue-case-page' => 'Säit:',
	'deletequeue-case-reason' => 'Grond:',
	'deletequeue-case-needs-review' => 'Dëse Fall muss [[$1|nogekuckt]] ginn.',
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

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'deletequeue-desc' => 'Создава [[Special:DeleteQueue|систем за раководење со бришења заснован на редици]]',
	'deletequeue-action-queued' => 'Бришење',
	'deletequeue-action' => 'Предложи бришење',
	'deletequeue-action-title' => 'Предложи бришење на „$1“',
	'deletequeue-action-text' => "Ова вики има неколку процедури за бришење на страници:
*Ако сметате дека оваа страница треба да се избрише, тогаш можете да ја [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} предложите за ''брзо бришење''].
*Ако сметате дека оваа страница не е за брзо бришење, но бришењето ''веројатно нема да биде оспорено'', тогаш треба да [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} предложите неоспорено бришење].
*Ако бришењето на оваа страница ''веројатно ќе биде оспорено'', тогаш треба да [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} отворите дискусија].",
	'deletequeue-action-text-queued' => 'Можете да ги погледате следниве страници за овој случај за бришење:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Преглед на тековните одобренија и приговори].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Одобрете го или приговорете на бришењето на оваа страница].',
	'deletequeue-permissions-noedit' => 'Мора да имате можност за уредување на страници, за да можете да влијаете врз нивниот статус на бришење.',
	'deletequeue-generic-reasons' => '* Основни причини
** Вандализам
** Спам
** Одржување
** Вон тематиката на проектот',
	'deletequeue-nom-alreadyqueued' => 'Оваа страница веќе се наоѓа во редицата за бришење.',
	'deletequeue-speedy-title' => 'Означи го „$1“ за брзо бришење',
	'deletequeue-speedy-text' => "Овој образец служи за означување на страницата „'''$1'''“ за брзо бришење.

Барањето ќе го разгледа администратор и, ако има добра основа, ќе ја избрише страницата.
Мора да одберете причина за бришење од паѓачкиот список подолу, и да додадете други релевантни информации.",
	'deletequeue-prod-title' => 'Предложи бришење на „$1“',
	'deletequeue-prod-text' => "Овој образец служи за предлагање на „'''$1'''“ за бришење.

Ако во рок од пет дена никој не го оспори бришењето, страницата ќе биде избришана откако администратор ќе изврши последна проверка.",
	'deletequeue-delnom-reason' => 'Причина за предложувањето:',
	'deletequeue-delnom-otherreason' => 'Друга причина',
	'deletequeue-delnom-extra' => 'Дополнителни информации:',
	'deletequeue-delnom-submit' => 'Поднеси предлог',
	'deletequeue-log-nominate' => 'предложена страницата [[$1]] за бришење во редицата „$2“.',
	'deletequeue-log-rmspeedy' => 'одбиено брзо бришење на [[$1]].',
	'deletequeue-log-requeue' => 'префрлена страницата [[$1]] во друга редица за бришење: од „$2“ во „$3“.',
	'deletequeue-log-dequeue' => 'отстрането [[$1]] од редицата за бришење „$2“.',
	'right-speedy-nominate' => 'Предлагање на страници за брзо бришење',
	'right-speedy-review' => 'Прегледување на предлози за брзо бришење',
	'right-prod-nominate' => 'Предлагање на страници за бришење',
	'right-prod-review' => 'Прегледување на неоспорени предлози за бришење',
	'right-deletediscuss-nominate' => 'Започнување на разговори за бришење',
	'right-deletediscuss-review' => 'Затворање на разговори за бришење',
	'right-deletequeue-vote' => 'Одобрување или приговарање на бришења',
	'deletequeue-queue-speedy' => 'Брзо бришење',
	'deletequeue-queue-prod' => 'Предложено бришење',
	'deletequeue-queue-deletediscuss' => 'Разговор за бришење',
	'deletequeue-page-speedy' => "Оваа страница е предложена за брзо бришење.
Наведената причина за бришење е ''$1''.",
	'deletequeue-page-prod' => "Предложено е бришење на оваа страница.
Наведената причина е ''$1''.
Ако предлогот пројде неоспорен на ''$2'', тогаш оваа страница ќе биде избришана.
Можете да го оспорите бришењето на оваа страница со тоа што ќе [{{fullurl:{{FULLPAGENAME}}|action=delvote}} приговорите на него].",
	'deletequeue-page-deletediscuss' => "Оваа страница е предложена за бришење, но предлогот е оспорен.
Наведената причина е ''$1''.
Во тек е дискусија на [[$5]], која ќе заврши во ''$2''.",
	'deletequeue-notqueued' => 'Страницата која ја одбравте моментално не се наоѓа во редица за бришење',
	'deletequeue-review-action' => 'Мерка за преземање:',
	'deletequeue-review-delete' => 'Избриши ја страницата.',
	'deletequeue-review-change' => 'Избриши ја страницава, но со друга причина.',
	'deletequeue-review-requeue' => 'Префрли ја страницава во следнава редица:',
	'deletequeue-review-dequeue' => 'Не преземај мерки и отстрани ја страницата од редот за бришење.',
	'deletequeue-review-reason' => 'Коментари:',
	'deletequeue-review-newreason' => 'Нова причина:',
	'deletequeue-review-newextra' => 'Дополнителни информации:',
	'deletequeue-review-submit' => 'Зачувај преглед',
	'deletequeue-review-original' => 'Причина за предложувањето',
	'deletequeue-actiondisabled-involved' => 'Следново дејство е оневозможено бидејќи имате учествувано во овој случај за бришење во својство на $1:',
	'deletequeue-actiondisabled-notexpired' => 'Следното дејство е оневозможено бидејќи сè уште нема истечено предлогот за бришење:',
	'deletequeue-review-badaction' => 'Назначивте неважечко дејство',
	'deletequeue-review-actiondenied' => 'Назначивте дејство што е оневозможено за оваа страница',
	'deletequeue-review-objections' => "'''Предупредување''': Има [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} приговори] против предлогот за бришењето на оваа страница.
Внимателно разгледајте ги овие приговори пред да ја бришете страницата.",
	'deletequeue-reviewspeedy-tab' => 'Прегледај брзо бришење',
	'deletequeue-reviewspeedy-title' => 'Прегледување на предлогот за брзо бришење на „$1“',
	'deletequeue-reviewspeedy-text' => "Овој образец служи за прегледување на предлогот на „'''$1'''“ за брзо бришење.
Проверете дали оваа страница може да биде брзо избришана во согласност со правилата.",
	'deletequeue-reviewprod-tab' => 'Прегледај предложено бришење',
	'deletequeue-reviewprod-title' => 'Прегледај го предложеното бришење на „$1“',
	'deletequeue-reviewprod-text' => "Ово образец служи за прегледување на неоспорениот предлог за бришење на „'''$1'''“.",
	'deletequeue-reviewdeletediscuss-tab' => 'Прегледај бришење',
	'deletequeue-reviewdeletediscuss-title' => 'Прегледување на разговорот за бришење на „$1“',
	'deletequeue-reviewdeletediscuss-text' => "Овој образец служи за прегледување на разговорот за бришење на „'''$1'''“.

На располагање ви е [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} список] на одобренија и приговори, а самиот разговор ќе го најдете на [[$2]].
Имајте на ум дека одлука што ќе ја донесете треба да биде во согласност со консензусот во разговорот.",
	'deletequeue-review-success' => 'Успешно го прегледавте бришењето на оваа страница',
	'deletequeue-review-success-title' => 'Прегледот е завршен',
	'deletequeue-deletediscuss-discussionpage' => 'Ова е страницата за разговор по повод бришењето на [[$1]].
Моментално има $2 {{PLURAL:$2|корисник што го одобрува|корисници што го одобруваат}} бришењето, и $3 {{PLURAL:$3|корисник кој приговара|кои приговараат}} на истото.
You may [{{fullurl:$1|action=delvote}} endorse or object] to deletion, or [{{fullurl:$1|action=delviewvotes}} view all endorsements and objections].',
	'deletequeue-discusscreate-summary' => 'Создавање на разговор за бришење на [[$1]].',
	'deletequeue-discusscreate-text' => 'Бришењето се предлага од следнава причина: $2',
	'deletequeue-role-nominator' => 'првичен предлагач на бришењето',
	'deletequeue-role-vote-endorse' => 'одобрувач на бришењето',
	'deletequeue-role-vote-object' => 'приговарач на бришењето',
	'deletequeue-vote-tab' => 'Глас за бришењето',
	'deletequeue-vote-title' => 'Одобри или приговори на бришењето на „$1“',
	'deletequeue-vote-text' => "Овој образец служи за одобрување или приговарање за бришењето на „'''$1'''“.
Ова дејство ги заменува сите ваши претходни одобренија/приговори за бришењето на оваа страница.
Можете да [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ги погледате] постоечките одобренија и приговори.
Наведената причина во предлогот за бришење е ''$2''.",
	'deletequeue-vote-legend' => 'Одобри/приговори за бришење',
	'deletequeue-vote-action' => 'Препорака:',
	'deletequeue-vote-endorse' => 'Одобри бришење.',
	'deletequeue-vote-object' => 'Приговори на бришење.',
	'deletequeue-vote-reason' => 'Коментари:',
	'deletequeue-vote-submit' => 'Поднеси',
	'deletequeue-vote-success-endorse' => 'Успешно го одобривте бришењето на оваа страница.',
	'deletequeue-vote-success-object' => 'Успешно приговоривте на бришењето на оваа страница.',
	'deletequeue-vote-requeued' => 'Успешно приговоривте на бришењето на оваа страница.
Заради приговорот, страницата е префрлена во редицата $1.',
	'deletequeue-showvotes' => 'Одобренија и приговори на бришењето на „$1“',
	'deletequeue-showvotes-text' => "Подолу се наведени одобренијата и приговорите за бришењето на страницата „'''$1'''“.
Можете да [{{fullurl:{{FULLPAGENAME}}|action=delvote}} го одобрите или да приговорите] на ова бришење.",
	'deletequeue-showvotes-restrict-endorse' => 'Прикажи само одобренија',
	'deletequeue-showvotes-restrict-object' => 'Прикажи само приговори',
	'deletequeue-showvotes-restrict-none' => 'Прикажи ги сите одобренија и приговори',
	'deletequeue-showvotes-vote-endorse' => "'''Одобрено''' бришењето во $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Приговорено''' на бришењето во $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Прикажани се само одобренија',
	'deletequeue-showvotes-showingonly-object' => 'Прикажани се само приговори',
	'deletequeue-showvotes-none' => 'Нема одобрувања или приговори на бришењето на оваа страница.',
	'deletequeue-showvotes-none-endorse' => 'Нема одобрувања на бришењето на оваа страница.',
	'deletequeue-showvotes-none-object' => 'Нема приговори на бришењето на оваа страница.',
	'deletequeue' => 'Редица за бришење',
	'deletequeue-list-text' => 'Оваа страница ги прикажува сите страници кои се наоѓаат во системот за бришење.',
	'deletequeue-list-search-legend' => 'Пребарај страници',
	'deletequeue-list-queue' => 'Редица:',
	'deletequeue-list-status' => 'Статус:',
	'deletequeue-list-expired' => 'Прикажи само предложени што треба да се затвораат.',
	'deletequeue-list-search' => 'Пребарување',
	'deletequeue-list-anyqueue' => '(било кој)',
	'deletequeue-list-votes' => 'Список на гласови',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|одобрение|одобренија}}, $2 {{PLURAL:$2|приговор|приговори}}',
	'deletequeue-list-header-page' => 'Страница',
	'deletequeue-list-header-queue' => 'Редица',
	'deletequeue-list-header-votes' => 'Одобренија и приговори',
	'deletequeue-list-header-expiry' => 'Истекување',
	'deletequeue-list-header-discusspage' => 'Страница за разговор',
	'deletequeue-case-intro' => 'Оваа страница наведува информации за поединечен случај за бришење.',
	'deletequeue-list-header-reason' => 'Причина за бришење',
	'deletequeue-case-votes' => 'Одобренија/приговори:',
	'deletequeue-case-title' => 'Податоци за случајот за бришење',
	'deletequeue-case-details' => 'Основни податоци',
	'deletequeue-case-page' => 'Страница:',
	'deletequeue-case-reason' => 'Причина:',
	'deletequeue-case-expiry' => 'Истекува:',
	'deletequeue-case-needs-review' => 'Овој случај бара [[$1|прегледување]].',
);

/** Malayalam (മലയാളം)
 * @author Junaidpv
 * @author Praveenp
 */
$messages['ml'] = array(
	'deletequeue-action-queued' => 'മായ്ക്കൽ',
	'deletequeue-action' => 'മായ്ക്കൽ നിർദ്ദേശിക്കുക',
	'deletequeue-action-title' => '"$1" മായ്ക്കാൻ ശുപാർശ ചെയ്യുക',
	'deletequeue-nom-alreadyqueued' => 'ഈ താൾ നിലവിൽ മായ്ക്കപ്പെടാനുള്ള താളുകളുടെ ക്യൂവിലുണ്ട്',
	'deletequeue-delnom-reason' => 'നിർദ്ദേശിക്കാനുള്ള കാരണം:',
	'deletequeue-delnom-otherreason' => 'മറ്റ് കാരണം',
	'deletequeue-delnom-extra' => 'കൂടുതൽ വിവരങ്ങൾ:',
	'deletequeue-delnom-submit' => 'നിർദ്ദേശം സമർപ്പിക്കുക',
	'deletequeue-queue-speedy' => 'അതിവേഗ മായ്ക്കൽ',
	'deletequeue-review-delete' => 'താൾ മായ്ക്കുക.',
	'deletequeue-review-reason' => 'അഭിപ്രായം:',
	'deletequeue-review-newreason' => 'പുതിയ കാരണം:',
	'deletequeue-review-newextra' => 'കൂടുതൽ വിവരങ്ങൾ:',
	'deletequeue-review-submit' => 'സംശോധനം സേവ് ചെയ്യുക',
	'deletequeue-review-original' => 'നിർദ്ദേശിക്കാനുള്ള കാരണം',
	'deletequeue-review-success' => 'താങ്കൾ വിജയകരമായി ഈ താളിന്റെ മായ്ക്കൽ സംശോധനം ചെയ്തിരിക്കുന്നു',
	'deletequeue-review-success-title' => 'സംശോധനം സമ്പൂർണ്ണം',
	'deletequeue-vote-reason' => 'അഭിപ്രായങ്ങൾ:',
	'deletequeue-vote-submit' => 'സമർപ്പിക്കുക',
	'deletequeue-list-header-page' => 'താൾ',
	'deletequeue-list-header-expiry' => 'കാലാവധി',
	'deletequeue-list-header-discusspage' => 'സംവാദം താൾ',
	'deletequeue-list-header-reason' => 'മായ്ക്കാനുള്ള കാരണം',
	'deletequeue-case-details' => 'അടിസ്ഥാന വിവരങ്ങൾ',
	'deletequeue-case-page' => 'താൾ:',
	'deletequeue-case-reason' => 'കാരണം:',
	'deletequeue-case-expiry' => 'കാലാവധി:',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'deletequeue-delnom-otherreason' => 'Өөр шалтгаан',
	'deletequeue-review-reason' => 'Тайлбар:',
	'deletequeue-vote-reason' => 'Тайлбар:',
	'deletequeue-vote-submit' => 'Явуулах',
	'deletequeue-list-search' => 'Хайх',
	'deletequeue-list-header-page' => 'Хуудас',
	'deletequeue-case-page' => 'Хуудас:',
	'deletequeue-case-reason' => 'Шалтгаан:',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 */
$messages['ms'] = array(
	'deletequeue-delnom-otherreason' => 'Sebab lain',
	'deletequeue-review-reason' => 'Komen:',
	'deletequeue-vote-reason' => 'Komen:',
	'deletequeue-vote-submit' => 'Serahkan',
	'deletequeue-list-queue' => 'Baris gilir:',
	'deletequeue-list-search' => 'Cari',
	'deletequeue-list-header-page' => 'Laman',
	'deletequeue-list-header-queue' => 'Baris gilir',
	'deletequeue-list-header-expiry' => 'Tamat:',
	'deletequeue-list-header-reason' => 'Sebab penghapusan',
	'deletequeue-case-page' => 'Laman:',
	'deletequeue-case-reason' => 'Sebab:',
	'deletequeue-case-expiry' => 'Tamat:',
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
	'deletequeue-delnom-otherreason' => 'Лия тувтал',
	'deletequeue-delnom-extra' => 'Поладкс информациясь:',
	'deletequeue-review-delete' => 'Нардамс те лопанть.',
	'deletequeue-review-reason' => 'Арсемат-мельть:',
	'deletequeue-review-newreason' => 'Од тувталось:',
	'deletequeue-review-newextra' => 'Поладкс информациясь:',
	'deletequeue-vote-reason' => 'Арсемат-мельть:',
	'deletequeue-list-queue' => 'Чиполань пулось:',
	'deletequeue-list-status' => 'Статусозо:',
	'deletequeue-list-search' => 'Вешнэмс',
	'deletequeue-list-header-page' => 'Лопа',
	'deletequeue-list-header-queue' => 'Чиполань пуло',
	'deletequeue-list-header-expiry' => 'Таштомома шказо',
	'deletequeue-list-header-discusspage' => 'Кортнема лопа',
	'deletequeue-case-reason' => 'Тувталось:',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'deletequeue-review-newreason' => 'Yancuīc īxtlamatiliztli:',
	'deletequeue-list-header-expiry' => 'Motlamia',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 * @author Simny
 */
$messages['nb'] = array(
	'deletequeue-desc' => 'Skaper et [[Special:DeleteQueue|købasert system for å håndtere sletting]]',
	'deletequeue-action-queued' => 'Sletting',
	'deletequeue-action' => 'Foreslå sletting',
	'deletequeue-action-title' => 'Foreslå sletting av «$1»',
	'deletequeue-action-text' => "{{SITENAME}} har flere prosesser for sletting av sider:
* Om du mener at denne siden kvalifiserer for ''hurtigsletting'', kan du foreslå det [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=speedy}} her].
* Om siden ikke kvalifserer for hurtigsletting, men ''sletting likevel vil være ukontroversielt'', kan du [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=prod}} foreslå sletting her].
* Om det er sannsynlig at sletting av siden ''vil bli omdiskutert'', burde du [{{fullurl:{{FULLPAGENAMEE}}|action=delnom&queue=deletediscuss}} åpne en diskusjon].",
	'deletequeue-action-text-queued' => 'Du kan se de følgende sidene for denne slettekandidaten:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Se nåværande støtte og motstand].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Støtt eller gå imot sletting av siden].',
	'deletequeue-permissions-noedit' => 'Du må kunne redigere en side for å kunne påvirke dens slettingsstatus.',
	'deletequeue-generic-reasons' => '* Vanlige årsaker
  ** Hæverk
  ** Søppel
  ** Reklame
  ** Vedlikehold
  ** Ikke relevant for prosjektet',
	'deletequeue-nom-alreadyqueued' => 'Denne siden er allerede i en sletningskø.',
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
	'right-deletequeue-vote' => 'Støtt eller gå imot sletteforslag',
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
	'deletequeue-reviewdeletediscuss-tab' => 'Revider sletting',
	'deletequeue-reviewdeletediscuss-title' => 'Revider slettediskusjonen for «$1»',
	'deletequeue-reviewdeletediscuss-text' => "Du kan bruke dette skjemaet for å revidere slettediskusjonen til «'''$1'''».

En [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} liste] over bifall av og innvendinger mot denne slettingen er tilgjengelig og selve diskusjonen kan bli funnet på [[$2]].
Forsikre deg om at du tar en avgjørelse i samsvar med konsensus i diskusjonen.",
	'deletequeue-review-success' => 'Du har revidert slettingen av denne siden',
	'deletequeue-review-success-title' => 'Revidering fullført',
	'deletequeue-deletediscuss-discussionpage' => 'Dette er diskusjonssiden for sletting av [[$1]].
Det er nå {{PLURAL:$2|én bruker|$2 brukere}} som er for sletting og {{PLURAL:$3|én bruker|$3 brukere}} som er imot.
Du ønsker kanskje å [{{fullurl:$1|action=delvote}} støtte eller gå imot] en sletting, eller [{{fullurl:$1|action=delvoiewvotes}} vise alle bifall og innvendinger].',
	'deletequeue-discusscreate-summary' => 'Opprett diskusjon for sletting av [[$1]].',
	'deletequeue-discusscreate-text' => 'Sletting foreslått på grunn av følgende årsaker: $2',
	'deletequeue-role-nominator' => 'opprinnelig nominert av',
	'deletequeue-role-vote-endorse' => 'støtter sletting',
	'deletequeue-role-vote-object' => 'er imot sletting',
	'deletequeue-vote-tab' => 'Stem over slettinga',
	'deletequeue-vote-title' => 'Støtt eller gå imot sletting av «$1»',
	'deletequeue-vote-text' => "Du kan bruke dette skjemaet for å støtte eller gå imot slettingen av «'''$1'''».
Denne handligen vil overskrive eventuelle tidligere bifall/innvendinger du har gitt mot slettingen av denne siden.
Du kan [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} vise] eksisterende bifall og innvendinger.
Oppgitt grunn for nominasjonen var ''$2''.",
	'deletequeue-vote-legend' => 'Støtt/gå imot sletting',
	'deletequeue-vote-action' => 'Anbefaling:',
	'deletequeue-vote-endorse' => 'Støtt sletting.',
	'deletequeue-vote-object' => 'Gå imot sletting.',
	'deletequeue-vote-reason' => 'Kommentarer:',
	'deletequeue-vote-submit' => 'Send',
	'deletequeue-vote-success-endorse' => 'Du har støttet forslaget om sletting av denne sida.',
	'deletequeue-vote-success-object' => 'Du har gått imot sletting av denne sida',
	'deletequeue-vote-requeued' => 'Du har gått imot slettingen av denne siden.
På grunn av din motstand har siden blitt flyttet til køen $1.',
	'deletequeue-showvotes' => 'Bifall av og innvendinger mot sletting av «$1»',
	'deletequeue-showvotes-text' => "Under er bifall og innvendinger mot sletting av siden «'''$1'''».
Du kan [{{fullurl:{{FULLPAGENAME}}|action=delvote}} legge inn ditt eget bifall av eller innvending mot] denne slettingen.",
	'deletequeue-showvotes-restrict-endorse' => 'Bare vis bifall',
	'deletequeue-showvotes-restrict-object' => 'Bare vis innvendinger',
	'deletequeue-showvotes-restrict-none' => 'Vis alle bifall og innvendinger',
	'deletequeue-showvotes-vote-endorse' => "'''Bifalt''' sletting den $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Innvendte mot''' sletting den $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Viser bare støtte',
	'deletequeue-showvotes-showingonly-object' => 'Viser bare innvendinger',
	'deletequeue-showvotes-none' => 'Det er ingen bifall av eller innvendinger mot slettingen av denne siden.',
	'deletequeue-showvotes-none-endorse' => 'Det er ingen bifall av slettingen av denne siden.',
	'deletequeue-showvotes-none-object' => 'Det er ingen innvendinger mot slettingen av denne siden.',
	'deletequeue' => 'Slettingskø',
	'deletequeue-list-text' => 'Denne siden viser alle sider som er i slettesystemet.',
	'deletequeue-list-search-legend' => 'Søk etter sider',
	'deletequeue-list-queue' => 'Kø:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Bare vis nominasjoner som må avsluttes.',
	'deletequeue-list-search' => 'Søk',
	'deletequeue-list-anyqueue' => '(noen)',
	'deletequeue-list-votes' => 'Liste over stemmer',
	'deletequeue-list-votecount' => '{{PLURAL:$1|Ett bifall|$1 bifall}}, {{PLURAL:$2|en innvending|$2 innvendinger}}',
	'deletequeue-list-header-page' => 'Side',
	'deletequeue-list-header-queue' => 'Kø',
	'deletequeue-list-header-votes' => 'Bifall og innvendinger',
	'deletequeue-list-header-expiry' => 'Varighet',
	'deletequeue-list-header-discusspage' => 'Diskusjonsside',
	'deletequeue-case-intro' => 'Denne siden lister opp informasjon om en spesifikk slettesak.',
	'deletequeue-list-header-reason' => 'Slettingsårsak:',
	'deletequeue-case-votes' => 'Bifall/innvendinger:',
	'deletequeue-case-title' => 'Slettesakdeltajer',
	'deletequeue-case-details' => 'Grunnleggende detaljer',
	'deletequeue-case-page' => 'Side:',
	'deletequeue-case-reason' => 'Årsak:',
	'deletequeue-case-expiry' => 'Utløp:',
	'deletequeue-case-needs-review' => 'Denne saken krever [[$1|revidering]].',
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
	'deletequeue-desc' => 'Crèa un [[Special:DeleteQueue|sistèma de coa per gerir las supressions]]',
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
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'deletequeue-list-search' => 'ଖୋଜିବା',
	'deletequeue-list-header-expiry' => 'ଅଚଳ ହେବ',
	'deletequeue-case-page' => 'ପୃଷ୍ଠା:',
	'deletequeue-case-reason' => 'କାରଣ:',
	'deletequeue-case-expiry' => 'ଅଚଳ ହେବ:',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'deletequeue-delnom-otherreason' => 'Æндæр аххостæ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'deletequeue-delnom-otherreason' => 'Annerer Grund',
	'deletequeue-review-reason' => 'Aamaerickinge:',
	'deletequeue-review-newreason' => 'Neier Grund:',
	'deletequeue-vote-reason' => 'Aamaerickinge:',
	'deletequeue-list-search' => 'Guck uff',
	'deletequeue-list-header-page' => 'Blatt',
	'deletequeue-case-page' => 'Blatt:',
	'deletequeue-case-reason' => 'Grund:',
);

/** Polish (Polski)
 * @author Jwitos
 * @author Leinad
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'deletequeue-desc' => 'Tworzy [[Special:DeleteQueue|oparty na kolejce system zarządzania usuwaniem]]',
	'deletequeue-action-queued' => 'Usunięcie',
	'deletequeue-action' => 'Zaproponuj do usunięcia',
	'deletequeue-action-title' => 'Zaproponuj usunięcie „$1”',
	'deletequeue-action-text' => "Wiki ma kilka procedur usuwania stron: 
* Jeśli uważasz za uzasadnione, możesz tę stronę [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} oznaczyć do ''ekspresowego usunięcia''].
* Jeśli zawartość strony nie gwarantuje kwalifikacji jej do ekspresowego usunięcia, a ''usunięcie prawdopodobnie będzie niekontrowersyjne'', należy [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} zaproponować usunięcie bezspornych].
* Jeśli usunięcie tej strony ''może wywołać czyjeś protesty'', należy [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} otworzyć dyskusję].",
	'deletequeue-action-text-queued' => 'Następujące strony związane są z tym zgłoszeniem:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Zobacz głosy zwolenników i przeciwników usunięcia].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Zagłosuj za lub przeciw usunięciu].',
	'deletequeue-permissions-noedit' => 'Musisz być w stanie edytować stronę, aby móc wpływać na jej status usunięcia.',
	'deletequeue-generic-reasons' => '* Najczęstsze powody
** Wandalizm
** Spam
** Porządki
** Treść nie przystaje do projektu',
	'deletequeue-nom-alreadyqueued' => 'Ta strona jest już w kolejce do usunięcia.',
	'deletequeue-speedy-title' => 'Oznacz „$1” do ekspresowego skasowania',
	'deletequeue-speedy-text' => "Możesz użyć tego formularza do oznaczenia strony „'''$1'''” do ekspresowego usunięcia.

Administrator zweryfikuje to zgłoszenie i jeśli uzna zgłoszenie za zasadne usunie stronę.
Musisz wybrać powód usunięcia z poniższej listy rozwijalnej i dodać wszelkie istotne informacje.",
	'deletequeue-prod-title' => 'Zaproponuj usunięcie „$1”',
	'deletequeue-prod-text' => "Możesz użyć tego formularza aby zgłosić „'''$1'''” do usunięcia.

Jeśli w ciągu pięciu dni nikt nie zakwestionuje usunięcia tej strony zostanie usunięta po końcowym sprawdzeniu przez administratora.",
	'deletequeue-delnom-reason' => 'Powód zgłoszenia',
	'deletequeue-delnom-otherreason' => 'Inny powód',
	'deletequeue-delnom-extra' => 'Dodatkowe informacje',
	'deletequeue-delnom-submit' => 'Zapisz zgłoszenie',
	'deletequeue-log-nominate' => 'zgłoszono [[$1]] do usunięcia w kolejce „$2”',
	'deletequeue-log-rmspeedy' => 'zmieniono na ekspresowe usuwanie [[$1]]',
	'deletequeue-log-requeue' => 'przeniesiono [[$1]] do innej kolejki usuwania – z „$2” do „$3”',
	'deletequeue-log-dequeue' => 'usunięto [[$1]] z kolejki usuwania „$2”',
	'right-speedy-nominate' => 'Oznaczanie stron do ekspresowego skasowania',
	'right-speedy-review' => 'Zatwierdzanie stron oznaczonych do ekspresowego skasowania',
	'right-prod-nominate' => 'Proponowanie usunięcia strony',
	'right-prod-review' => 'Zatwierdzanie bezspornych propozycji usunięć',
	'right-deletediscuss-nominate' => 'Rozpoczęcie dyskusji nad usunięciem',
	'right-deletediscuss-review' => 'Zamknięcie dyskusji nad usunięciem',
	'right-deletequeue-vote' => 'Wyrażenie poparcia lub sprzeciwu dla usunięcia',
	'deletequeue-queue-speedy' => 'Ekspresowe usuwanie',
	'deletequeue-queue-prod' => 'Propozycje usunięcia',
	'deletequeue-queue-deletediscuss' => 'Dyskusja usuwania',
	'deletequeue-page-speedy' => "Ta strona została zgłoszona do ekspresowego usunięcia.
Powód podany jako uzasadnienie zgłoszenia to ''$1''.",
	'deletequeue-page-prod' => "Strona została zgłoszona do usunięcia.
Powód podany przy zgłoszeniu to ''$1''.
Jeśli nikt nie będzie miał zastrzeżeń do ''$2'' strona zostanie usunięta.
Możesz w kwestii usunięcia strony [{{fullurl:{{FULLPAGENAME}}|action=delvote}} zgłosić sprzeciw].",
	'deletequeue-page-deletediscuss' => "Ta strona została zgłoszona do usunięcia lecz ktoś zgłosił sprzeciw.
Podany powód to ''$1''.
Dyskusja trwa na stronie [[$5]], a zakończy się ''$2''.",
	'deletequeue-notqueued' => 'Strona, którą wybrałeś nie znajduje się w kolejce do usunięcia',
	'deletequeue-review-action' => 'Cel działania',
	'deletequeue-review-delete' => 'Usuń stronę.',
	'deletequeue-review-change' => 'Usuń tę stronę, ale z innym uzasadnieniem.',
	'deletequeue-review-requeue' => 'Przenieś tę stronę do kolejki',
	'deletequeue-review-dequeue' => 'Nie podejmuj żadnej akcji i usuń tę stronę z kolejki stron do usunięcia.',
	'deletequeue-review-reason' => 'Komentarze:',
	'deletequeue-review-newreason' => 'Nowy powód',
	'deletequeue-review-newextra' => 'Dodatkowe informacje:',
	'deletequeue-review-submit' => 'Zapisz decyzję',
	'deletequeue-review-original' => 'Powód zgłoszenia',
	'deletequeue-actiondisabled-involved' => 'Następująca działanie nie jest możliwe ponieważ bierzesz udział w tym zgłoszeniu do usunięcia jako $1',
	'deletequeue-actiondisabled-notexpired' => 'Następująca działanie nie jest możliwe ponieważ to czas trwania zgłoszenia do usunięcia jeszcze nie upłynął',
	'deletequeue-review-badaction' => 'Wybrałeś nieprawidłowe działanie',
	'deletequeue-review-actiondenied' => 'Wybrałeś działanie, które jest wyłączone dla tej strony',
	'deletequeue-review-objections' => "'''Uwaga''' – usunięcie tej strony [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} wywołało czyjś sprzeciw].
Upewnij się przed usunięciem tej strony, że zapoznałeś się z ich argumentami.",
	'deletequeue-reviewspeedy-tab' => 'Zatwierdzanie ekspresowego usuwania',
	'deletequeue-reviewspeedy-title' => 'Zatwierdzanie zgłoszenia do ekspresowego usunięcia „$1”',
	'deletequeue-reviewspeedy-text' => "Możesz użyć tego formularza do zaakceptowania zgłoszenia „'''$1'''” do ekspresowego usunięcia.
Upewnij się, że usunięcie strony w tym trybie będzie zgodne z obowiązującą polityką.",
	'deletequeue-reviewprod-tab' => 'Zatwierdzanie zgłoszeń do usunięcia',
	'deletequeue-reviewprod-title' => 'Zatwierdzanie zgłoszenia do usunięcia „$1”',
	'deletequeue-reviewprod-text' => "Możesz użyć tego formularza do zatwierdzania bezspornego zgłoszenia do usunięcia „'''$1'''”.",
	'deletequeue-reviewdeletediscuss-tab' => 'Zatwierdzam usunięcie',
	'deletequeue-reviewdeletediscuss-title' => 'Sprawdzenie dyskusji nad usunięciem „$1”',
	'deletequeue-reviewdeletediscuss-text' => "Możesz użyć tego formularza do podsumowania dyskusji o usunięciu „'''$1'''”.

Dostępna jest [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] głosów poparcia i sprzeciwu w sprawie usunięcia tej strony oraz dyskusja na [[$2]].
Upewnij się, że podejmujesz decyzję zgodną z ustalonym w toku dyskusji konsensusem.",
	'deletequeue-review-success' => 'Zweryfikowałeś potrzebę usunięcia tej strony.',
	'deletequeue-review-success-title' => 'Weryfikacja zakończona',
	'deletequeue-deletediscuss-discussionpage' => 'To jest strona dyskusji usunięcia [[$1]].
Obecnie $2 {{PLURAL:$2|użytkownik|użytkowników}} popiera usunięcie, a $3 {{PLURAL:$3|użytkownik|użytkowników}} jest przeciwnych usunięciu.
Możesz [{{fullurl:$1|action=delvote}} zająć stanowisko] w sprawie usunięcia lub [{{fullurl:$1|action=delviewvotes}} zobaczyć przebieg głosowania].',
	'deletequeue-discusscreate-summary' => 'Tworzenie strony dyskusji dla usuwania [[$1]].',
	'deletequeue-discusscreate-text' => 'Zgłoszono usunięcie podając powód – $2',
	'deletequeue-role-nominator' => 'pierwszy zgłaszający do usunięcia',
	'deletequeue-role-vote-endorse' => 'za usunięciem',
	'deletequeue-role-vote-object' => 'przeciwny usunięciu',
	'deletequeue-vote-tab' => 'Głosowanie nad usunięciem',
	'deletequeue-vote-title' => 'Wyrażenie poparcia lub sprzeciwu dla usunięcia „$1”',
	'deletequeue-vote-text' => "Możesz użyć tego formularza aby poprzeć lub sprzeciwić się usunięciu „'''$1'''”.
Działanie to nadpisze wcześniejsze głosy, które oddałeś w tej sprawie.
Możesz [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} sprawdzić] wszystkie dotychczasowe głosy.
Powodem zgłoszenia do usunięcia było ''$2''.",
	'deletequeue-vote-legend' => 'Wyrażenie poparcia lub sprzeciwu dla usunięcia',
	'deletequeue-vote-action' => 'Rekomendacja',
	'deletequeue-vote-endorse' => 'za usunięciem',
	'deletequeue-vote-object' => 'przeciwny usunięciu',
	'deletequeue-vote-reason' => 'Komentarze:',
	'deletequeue-vote-submit' => 'Zapisz',
	'deletequeue-vote-success-endorse' => 'Potwierdziłeś, że jesteś za usunięciem tej strony.',
	'deletequeue-vote-success-object' => 'Sprzeciwiłeś się usunięciu tej strony.',
	'deletequeue-vote-requeued' => 'Zgłosiłeś sprzeciw przeciwko usunięciu tej strony.
Ponieważ się sprzeciwiłeś strona została przeniesiona do kolejki $1.',
	'deletequeue-showvotes' => 'Potwierdzenia i sprzeciwy dotyczące usunięcia strony „$1”',
	'deletequeue-showvotes-text' => "Poniżej znajdują się potwierdzenia i sprzeciwy dotyczące usunięcia strony „'''$1'''”.
Możesz [{{fullurl:{{FULLPAGENAME}}|action=delvote}} zająć stanowisko] w tej sprawie.",
	'deletequeue-showvotes-restrict-endorse' => 'Pokaż wyłącznie zwolenników',
	'deletequeue-showvotes-restrict-object' => 'Pokaż wyłącznie przeciwników',
	'deletequeue-showvotes-restrict-none' => 'Pokaż wszystkich, zarówno zwolenników i przeciwników',
	'deletequeue-showvotes-vote-endorse' => "'''Poprzeć''' usunięcie na $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Sprzeciw''' przeciwko usunięciu na $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Wyświetlanie wyłącznie zwolenników',
	'deletequeue-showvotes-showingonly-object' => 'Wyświetlanie wyłącznie przeciwników',
	'deletequeue-showvotes-none' => 'Brak zarówno zwolenników jak i przeciwników usunięcia tej strony.',
	'deletequeue-showvotes-none-endorse' => 'Brak zwolenników usunięcia tej strony.',
	'deletequeue-showvotes-none-object' => 'Brak przeciwników usunięcia tej strony.',
	'deletequeue' => 'Kolejka usuwania',
	'deletequeue-list-text' => 'Na tej stronie wyświetlane są wszystkie strony, które są przetwarzane przez system usuwania stron.',
	'deletequeue-list-search-legend' => 'Szukaj stron',
	'deletequeue-list-queue' => 'Kolejka:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Pokaż wyłącznie zgłoszenia wymagające zamknięcia.',
	'deletequeue-list-search' => 'Szukaj',
	'deletequeue-list-anyqueue' => '(dowolna)',
	'deletequeue-list-votes' => 'Lista głosów',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|zwolennik|zwolenników}}, $2 {{PLURAL:$2|przeciwnik|przeciwników}}',
	'deletequeue-list-header-page' => 'Strona',
	'deletequeue-list-header-queue' => 'Kolejka',
	'deletequeue-list-header-votes' => 'Poparcia i sprzeciwy',
	'deletequeue-list-header-expiry' => 'Upływa',
	'deletequeue-list-header-discusspage' => 'Strona dyskusji',
	'deletequeue-case-intro' => 'Na tej stronie znajdziesz informacje na temat konkretnego przypadku usunięcia.',
	'deletequeue-list-header-reason' => 'Powód usunięcia',
	'deletequeue-case-votes' => 'Głosy za i przeciw',
	'deletequeue-case-title' => 'Szczegóły dotyczące zgłoszenia',
	'deletequeue-case-details' => 'Podstawowe informacje',
	'deletequeue-case-page' => 'Strona',
	'deletequeue-case-reason' => 'Powód',
	'deletequeue-case-expiry' => 'Wygaśnięcie',
	'deletequeue-case-needs-review' => 'To zgłoszenie wymaga [[$1|zatwierdzenia]].',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'deletequeue-desc' => 'A crea un [[Special:DeleteQueue|sistema ëd coe për gestì jë scancelament]]',
	'deletequeue-action-queued' => 'Scancelassion',
	'deletequeue-action' => 'Sugerì la scancelassion',
	'deletequeue-action-title' => 'Sugerì la scancelassion ëd "$1"',
	'deletequeue-action-text' => "Sta wiki-sì a l'ha un sert nùmer ëd process për scancelé dle pàgine:
*S'a chërd che sta pàgina-sì a-j garantissa, a peul [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} sugerila për la ''scancelassion lesta''].
*Se sta pàgina-sì a garantiss pa na scancelassion lesta, ma la ''scancelassion a sarà pa discutìbil'', chiel a dovrìa [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} propon-e na scancelassion pa discutìbil].
*Se la scancelassion dë sta pàgina-sì a l'é ''bel fé ch'a sia contestà'', a dovrìa [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} deurbe na discussion].",
	'deletequeue-action-text-queued' => "A peul visualisé le pàgine sì-dapress për cost cas dë scancelassion:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Visualisé j'aprovassion e j'obiession al moment],
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Apreuvé o contesté la scancelassion dë sta pàgina].",
	'deletequeue-permissions-noedit' => 'A deuv podèj modifiché na pàgina për podèj modifiché sò stat dë scancelassion.',
	'deletequeue-generic-reasons' => "* Rason genérica
** Vandalism
** Rumenta
** Manutension
** Fòra d'ij but dël proget",
	'deletequeue-nom-alreadyqueued' => "Sta pàgina-sì a l'é già ant na coa dë scancelassion.",
	'deletequeue-speedy-title' => 'Marché "$1" për na scancelassion lesta',
	'deletequeue-speedy-text' => "A peul dovré sto formolari-sì për marché la pàgina '''$1''' për na scancelassion lesta.

N'aministrator a revisionërà st'arcesta-sì, e, s'a fussa bin fondà, a scancelërà la pàgina.
A deuv selessioné na rason për la scancelassion da la lista a ridò sì-dapress, e gionté tuta àutra anformassion rilevanta.",
	'deletequeue-prod-title' => 'Propon-e la scancelassion ëd "$1"',
	'deletequeue-prod-text' => "A peul dovré sto formolari-sì për propon-e che \"'''\$1'''\" a sia scancelà.

Se, apress sinch di, gnun a l'ha contestà la scancelassion dë sta pàgina-sì, a sarà scancelà da n'aministrator apress na revision final.",
	'deletequeue-delnom-reason' => 'Rason për la segnalassion:',
	'deletequeue-delnom-otherreason' => 'Àutra rason',
	'deletequeue-delnom-extra' => 'Anformassion suplementar:',
	'deletequeue-delnom-submit' => 'Spediss la segnalassion',
	'deletequeue-log-nominate' => "segnalà [[$1]] për la scancelassion ant la coa '$2'.",
	'deletequeue-log-rmspeedy' => 'arfudà dë scancelé an pressa [[$1]].',
	'deletequeue-log-requeue' => "tramudà [[$1]] a na coa dë scancelassion diferenta: da '$2' a '$3'.",
	'deletequeue-log-dequeue' => "gavà [[$1]] da la coa dë scancelassion '$2'.",
	'right-speedy-nominate' => 'Signala dle pàgine për na scancelassion lesta',
	'right-speedy-review' => 'Revisioné le signalassion dë scancelassion lesta',
	'right-prod-nominate' => 'Propon-e la scancelassion ëd pàgine',
	'right-prod-review' => 'Revisioné le propòste dë scancelassion nen contestàbil',
	'right-deletediscuss-nominate' => 'Ancaminé le discussion an sla scancelassion',
	'right-deletediscuss-review' => 'Saré le discussion an sla scancelassion',
	'right-deletequeue-vote' => 'Aprové o critiché le scancelassion',
	'deletequeue-queue-speedy' => 'Scancelassion lesta',
	'deletequeue-queue-prod' => 'Scancelassion proponùa',
	'deletequeue-queue-deletediscuss' => 'Discussion an sla scancelassion',
	'deletequeue-page-speedy' => "Sta pàgina-sì a l'é stàita signalà për na scancelassion lesta.
La rason dàita për la scancelassion a l'é ''$1''.",
	'deletequeue-page-prod' => "A l'é proponusse che sta pàgina-sì a sia scancelà.
La rason dàita a l'era ''$1''.
Se sta propòsta a l'é pa contestà nen pì an là che ij ''$2'', sta pàgina-sì a sarà scancelà.
A peul contesté la scancelassion dë sta pàgina-sì an [{{fullurl:{{FULLPAGENAME}}|action=delvote}} criticand la scancelassion].",
	'deletequeue-page-deletediscuss' => "Sta pàgina-sì a l'é stàita proponùa për la scancelassion, e cola propòsta a l'é stàita contestà.
La rason dàita a l'era ''$1''.
Na discussion a l'é an cors su [[$5]], e a finirà ai ''$2''.",
	'deletequeue-notqueued' => "La pàgina ch'it l'has selessionà al moment a l'é pa signalà për la scancelassion",
	'deletequeue-review-action' => 'Assion da fé:',
	'deletequeue-review-delete' => 'Scancelé la pàgina.',
	'deletequeue-review-change' => 'Scancelé costa pàgina, ma con na rason diferenta.',
	'deletequeue-review-requeue' => 'Tramuda sta pàgina-sì a la coa sota:',
	'deletequeue-review-dequeue' => 'Fé gnun-e assion, e gavé la pàgina da la coa dje scancelassion.',
	'deletequeue-review-reason' => 'Coment:',
	'deletequeue-review-newreason' => 'Neuva rason:',
	'deletequeue-review-newextra' => 'Anformassion suplementar:',
	'deletequeue-review-submit' => 'Salvé la Revision',
	'deletequeue-review-original' => 'Rason për la segnalassion',
	'deletequeue-actiondisabled-involved' => "L'assion sì-dapress a l'é disabilità përchè chiel a l'ha partissipà a cost cas dë scancelassion ant le part ëd $1:",
	'deletequeue-actiondisabled-notexpired' => "L'assion si-dapress a l'é disabilità përchè la signalassion dë scancelassion a l'é pa ancor passà:",
	'deletequeue-review-badaction' => "A l'ha spessificà n'assion nen bon-a",
	'deletequeue-review-actiondenied' => "A l'has spessificà n'assion che a l'é disabilità për sta pàgina-sì",
	'deletequeue-review-objections' => "'''Atension''': La scancelassion dë sta pàgina-sì a l'ha dj'[{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} obiession].
Për piasì ch'as sicura d'avèj considerà coste obiession prima dë scancelé la pàgina.",
	'deletequeue-reviewspeedy-tab' => 'Revisioné la scancelassion lesta',
	'deletequeue-reviewspeedy-title' => 'Revisioné la signalassion për la scancelassion lesta ëd "$1"',
	'deletequeue-reviewspeedy-text' => "A peul dovré cost formolari-sì për revisioné la signalassion ëd \"'''\$1'''\" për la scancelassion lesta.
Për piasì, ch'as sicura che sta pàgina-sì a peussa esse scancelà an pressa d'acòrdi con ij deuit.",
	'deletequeue-reviewprod-tab' => 'Revisioné la scancelassion proponùa',
	'deletequeue-reviewprod-title' => 'Revisioné la scancelassion proponùa ëd "$1"',
	'deletequeue-reviewprod-text' => "A peul dovré cost formolari-sì për revisioné la propòsta pa contestà për la scancelassion ëd \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Revisioné la scancelassion',
	'deletequeue-reviewdeletediscuss-title' => 'Revisioné la discussion an sla scancelassion ëd "$1"',
	'deletequeue-reviewdeletediscuss-text' => "A peul dovré sto formolari-sì për revisioné la discussion an sla scancelassion ëd \"'''\$1'''\".

Na [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] d'aprovassion e d'obiession a costa scancelassion a l'é disponìbil, e la discussion midema as peul trovesse a [[\$2]].
Për piasì, ch'as sicura ëd pijé na decision d'acòrdi con l'arzultà dla discussion.",
	'deletequeue-review-success' => "A l'ha revisionà da bin la scancelassion ëd costa pàgina",
	'deletequeue-review-success-title' => 'Revision completa',
	'deletequeue-deletediscuss-discussionpage' => "Costa a l'é la pàgina ëd discussion për la scancelassion ëd [[$1]].
A-i é al moment $2 {{PLURAL:$2|utent|utent}} ch'a apògio la scancelassion, e $3  {{PLURAL:$2|utent|utent}} ch'a crìtico la scancelassion.
Chiel a peul [{{fullurl:$1|action=delvote}} apogé o critiché] la scancelassion, o  [{{fullurl:$1|action=delviewvotes}} visualisé tute j'aprovassion e le crìtiche].",
	'deletequeue-discusscreate-summary' => 'Creé na discussion për la scancelassion ëd [[$1]].',
	'deletequeue-discusscreate-text' => 'Scancelassion proponùa për la rason sì-sota: $2',
	'deletequeue-role-nominator' => 'anandiator original ëd la scancelassion',
	'deletequeue-role-vote-endorse' => 'a pro dla scancelassion',
	'deletequeue-role-vote-object' => 'contra la scancelassion',
	'deletequeue-vote-tab' => 'Voté an sla scancelassion',
	'deletequeue-vote-title' => 'Apogé o critiché la scancelassion ëd "$1"',
	'deletequeue-vote-text' => "A peul dovré cost formolari për apogé o critiché la scancelassion ëd \"'''\$1'''\".
St'assion-sì a coatrà tùit j'apògg/critiche che chiel a l'ha dàit an sla scancelassion dë sta pàgina.
A peul [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} visualisé] j'apògg e le crìtiche esistente.
La rason dàita ant la signalassion për la scancelassion a l'era ''\$2''.",
	'deletequeue-vote-legend' => 'Apogé/Critiché la scancelassion',
	'deletequeue-vote-action' => 'Racomandassion:',
	'deletequeue-vote-endorse' => 'A apreuva la scancelassion.',
	'deletequeue-vote-object' => 'As opon a la scancelassion.',
	'deletequeue-vote-reason' => 'Coment:',
	'deletequeue-vote-submit' => 'Spediss',
	'deletequeue-vote-success-endorse' => "A l'ha aprovà da bin la scancelassion dë sta pàgina-sì.",
	'deletequeue-vote-success-object' => "A l'é oponusse da bin a la scancelassion dë sta pàgina-sì.",
	'deletequeue-vote-requeued' => "A l'ha criticà da bin la scancelassion dë sta pàgina-sì.
Për soa obiession, la pàgina a l'é stàita tramudà a la coa $1.",
	'deletequeue-showvotes' => 'Apògg e obiession a la scancelassion ëd "$1".',
	'deletequeue-showvotes-text' => "Sota a-i son apògg e obiession fàit a la scancelassin ëd la pàgina \"'''\$1'''\".
A peul [{{fullurl:{{FULLPAGENAME}}|action=delvote}} registré sò apogg, o obiession] a la scancelassion.",
	'deletequeue-showvotes-restrict-endorse' => "Mostré mach j'apògg",
	'deletequeue-showvotes-restrict-object' => "Mostré mach j'obiession",
	'deletequeue-showvotes-restrict-none' => "Smon-e tùit j'apògg e j'obiession",
	'deletequeue-showvotes-vote-endorse' => "'''A l'ha aprovà''' la scancelassion a $1 $2",
	'deletequeue-showvotes-vote-object' => "'''A l'é oponusse''' a la scancelassion a $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => "Visualisassion mach ëd j'aprovassion",
	'deletequeue-showvotes-showingonly-object' => "Visualisassion mach ëd j'obiession",
	'deletequeue-showvotes-none' => "A-i son pa d'aprovassion o d'obiession a la scancelassion dë sta pàgina-sì",
	'deletequeue-showvotes-none-endorse' => "A-i son pa d'apògg a la scancelassion dë sta pàgina-sì.",
	'deletequeue-showvotes-none-object' => "A-i son pa d'obiession a la scancelassion dë sta pàgina-sì.",
	'deletequeue' => 'Coa dë scancelassion',
	'deletequeue-list-text' => 'Sta pàgina-sì a smon tute le pàgine che a-i son ant ël sistema dë scancelassion.',
	'deletequeue-list-search-legend' => 'Sërché dle pàgine',
	'deletequeue-list-queue' => 'Coa:',
	'deletequeue-list-status' => 'Stat:',
	'deletequeue-list-expired' => "Smon-e mach le signalassion ch'a ciamo d'esse sarà.",
	'deletequeue-list-search' => 'Sërca',
	'deletequeue-list-anyqueue' => '(tuti)',
	'deletequeue-list-votes' => 'Lista dij vot',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|apògg|apògg}}, $2 {{PLURAL:$2|obiession|obiession}}',
	'deletequeue-list-header-page' => 'Pàgina',
	'deletequeue-list-header-queue' => 'Coa',
	'deletequeue-list-header-votes' => 'Apògg e obiession',
	'deletequeue-list-header-expiry' => 'Fin',
	'deletequeue-list-header-discusspage' => 'Pàgina ëd discussion',
	'deletequeue-case-intro' => "Costa pàgina a lista dj'anformassion ansima a 'n cas spessìfich dë scancelassion.",
	'deletequeue-list-header-reason' => 'Rason për la scancelassion',
	'deletequeue-case-votes' => 'Apògg/Obiession:',
	'deletequeue-case-title' => 'Detaj dël cas dë scancelassion',
	'deletequeue-case-details' => 'Detaj base',
	'deletequeue-case-page' => 'Pàgina:',
	'deletequeue-case-reason' => 'Rason:',
	'deletequeue-case-expiry' => 'Fin:',
	'deletequeue-case-needs-review' => 'Cost cas-sì a ciama na [[$1|revision]].',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'deletequeue-action-queued' => 'ړنګېدنه',
	'deletequeue-action' => 'د ړنګولو وړانديز کول',
	'deletequeue-action-title' => 'د "$1" د ړنګولو وړانديز کول',
	'deletequeue-delnom-otherreason' => 'بل سبب',
	'deletequeue-delnom-extra' => 'نور مالومات:',
	'deletequeue-queue-speedy' => 'چټکه ړنګېدنه',
	'deletequeue-queue-deletediscuss' => 'د ړنګولو خبرې اترې',
	'deletequeue-review-delete' => 'دا مخ ړنګول.',
	'deletequeue-review-reason' => 'تبصرې:',
	'deletequeue-review-newreason' => 'نوی سبب:',
	'deletequeue-vote-action' => 'سپارښتنه:',
	'deletequeue-vote-reason' => 'تبصرې:',
	'deletequeue-vote-submit' => 'سپارل',
	'deletequeue-list-search-legend' => 'د مخونو پلټنه',
	'deletequeue-list-status' => 'دريځ:',
	'deletequeue-list-search' => 'پلټل',
	'deletequeue-list-anyqueue' => '(هر يو)',
	'deletequeue-list-votes' => 'د رايو لړليک',
	'deletequeue-list-header-page' => 'مخ',
	'deletequeue-list-header-expiry' => 'د پای نېټه',
	'deletequeue-list-header-discusspage' => 'د خبرو اترو مخ',
	'deletequeue-list-header-reason' => 'د ړنګولو سبب',
	'deletequeue-case-page' => 'مخ:',
	'deletequeue-case-reason' => 'سبب:',
	'deletequeue-case-expiry' => 'د پای نېټه:',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Heldergeovane
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'deletequeue-desc' => 'Cria um [[Special:DeleteQueue|sistema baseado em fila para gerir eliminações]]',
	'deletequeue-action-queued' => 'Eliminação',
	'deletequeue-action' => 'Sugerir eliminação',
	'deletequeue-action-title' => 'Sugerir eliminação de "$1"',
	'deletequeue-action-text' => "A {{SITENAME}} tem vários processos para eliminar páginas:
*Se acredita que esta página justifica uma ''eliminação rápida'', poderá sugeri-la [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} aqui].
*Se esta página não justifica uma eliminação rápida, mas ''a eliminação provavelmente será incontroversa'', deverá [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} propôr uma eliminação incontestada].
*Se a eliminação desta página será ''provavelmente contestada'', deverá [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} iniciar uma discussão].",
	'deletequeue-action-text-queued' => 'Pode ver as seguintes páginas para este caso de eliminação:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Ver apoios e objecções actuais].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Apoiar ou objectar à eliminação desta página].',
	'deletequeue-permissions-noedit' => 'Tem de poder editar uma página para poder afectar o seu estado de eliminação.',
	'deletequeue-generic-reasons' => '* Motivos genéricos
** Vandalismo
** Spam
** Manutenção
** Fora do âmbito do projeto',
	'deletequeue-nom-alreadyqueued' => 'Esta página já se encontra numa fila de eliminação.',
	'deletequeue-speedy-title' => 'Marcar "$1" para eliminação rápida',
	'deletequeue-speedy-text' => "Pode usar este formulário para marcar a página \"'''\$1'''\" para eliminação rápida.

Um administrador irá rever este pedido e, se for bem fundamentado, eliminar a página.
Deverá seleccionar um motivo de eliminação da lista de opções abaixo, e adicionar qualquer outra informação relevante.",
	'deletequeue-prod-title' => 'Propor eliminação de "$1"',
	'deletequeue-prod-text' => "Pode usar este formulário para propor que a página \"'''\$1'''\" seja eliminada.

Se, após cinco dias, ninguém tiver objectado à eliminação desta página, ela será eliminada após revisão final por um administrador.",
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
Se esta proposta não tiver objecções em ''$2'', a página será eliminada.
Pode opor-se à eliminação desta página [{{fullurl:{{FULLPAGENAME}}|action=delvote}} objectando à eliminação].",
	'deletequeue-page-deletediscuss' => "Esta página foi proposta para eliminação, e essa proposta foi contestada.
O motivo dado foi ''$1''.
Uma discussão encontra-se em curso em [[$5]], e que será concluída em ''$2''.",
	'deletequeue-notqueued' => 'A página que seleccionou não está neste momento na fila para eliminação',
	'deletequeue-review-action' => 'Acção a tomar:',
	'deletequeue-review-delete' => 'Eliminar a página.',
	'deletequeue-review-change' => 'Eliminar esta página, mas com uma justificação diferente.',
	'deletequeue-review-requeue' => 'Transferir esta página para a seguinte fila:',
	'deletequeue-review-dequeue' => 'Não tomar nenhuma acção e remover a página da fila de eliminação.',
	'deletequeue-review-reason' => 'Comentários:',
	'deletequeue-review-newreason' => 'Novo motivo:',
	'deletequeue-review-newextra' => 'Informação extra:',
	'deletequeue-review-submit' => 'Gravar Revisão',
	'deletequeue-review-original' => 'Motivo da nomeação',
	'deletequeue-actiondisabled-involved' => 'A seguinte acção está desactivada porque tomou parte neste caso de eliminação, nos papéis $1:',
	'deletequeue-actiondisabled-notexpired' => 'A seguinte acção está desactivada porque a nomeação para eliminação ainda não expirou:',
	'deletequeue-review-badaction' => 'Especificou uma acção inválida',
	'deletequeue-review-actiondenied' => 'Especificou uma acção que está desactivada para esta página',
	'deletequeue-review-objections' => "'''Aviso''': A eliminação desta página tem [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} objeções].
Por favor, assegure-se de que considerou estas objeções antes de eliminar esta página.",
	'deletequeue-reviewspeedy-tab' => 'Rever eliminação rápida',
	'deletequeue-reviewspeedy-title' => 'Rever a nomeação para eliminação rápida de "$1"',
	'deletequeue-reviewspeedy-text' => "Pode usar este formulário para rever a proposta de \"'''\$1'''\" para eliminação rápida.
Por favor, assegure-se de que esta página pode ser eliminada rapidamente de acordo com as normas.",
	'deletequeue-reviewprod-tab' => 'Rever eliminação proposta',
	'deletequeue-reviewprod-title' => 'Rever eliminação proposta de "$1"',
	'deletequeue-reviewprod-text' => "Pode usar este formulário para rever a proposta incontestada de eliminação de \"'''\$1'''\".",
	'deletequeue-reviewdeletediscuss-tab' => 'Rever eliminação',
	'deletequeue-reviewdeletediscuss-title' => 'Rever discussão de eliminação de "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Pode usar este formulário para rever a discussão da eliminação de \"'''\$1'''\".

Está disponível uma [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] de apoios e objecções desta eliminação e a discussão pode ser encontrada em [[\$2]].
Por favor, assegure-se de que toma uma decisão de acordo com o consenso patente na discussão.",
	'deletequeue-review-success' => 'Reviu com sucesso a eliminação desta página',
	'deletequeue-review-success-title' => 'Revisão completa',
	'deletequeue-deletediscuss-discussionpage' => 'Esta é a página de discussão para a eliminação de [[$1]].
Há actualmente $2 {{PLURAL:$2|utilizador|utilizadores}} a apoiar a eliminação, e $3 {{PLURAL:$3|utilizador|utilizadores}} a objectar à eliminação.
Pode [{{fullurl:$1|action=delvote}} apoiar ou objectar] à eliminação, ou [{{fullurl:$1|action=delviewvotes}} ver todos os apoios e objecções].',
	'deletequeue-discusscreate-summary' => 'A criar discussão para a eliminação de [[$1]].',
	'deletequeue-discusscreate-text' => 'Eliminação proposta pelo seguinte motivo: $2',
	'deletequeue-role-nominator' => 'nomeador original da eliminação',
	'deletequeue-role-vote-endorse' => 'apoiante da eliminação',
	'deletequeue-role-vote-object' => 'objector à eliminação',
	'deletequeue-vote-tab' => 'Votar na eliminação',
	'deletequeue-vote-title' => 'Apoiar ou objectar à eliminação de "$1"',
	'deletequeue-vote-text' => "Pode usar este formulário para apoiar ou objectar à eliminação de \"'''\$1'''\".
Esta acção sobrepõe-se a quaisquer apoios/objecções que tenha dado anteriormente à eliminação da página.
Pode [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} ver] os apoios e objecções existentes.
O motivo apresentado para a nomeação para eliminação foi ''\$2''.",
	'deletequeue-vote-legend' => 'Apoiar/Objectar à eliminação',
	'deletequeue-vote-action' => 'Recomendação:',
	'deletequeue-vote-endorse' => 'Apoiar eliminação.',
	'deletequeue-vote-object' => 'Objectar à eliminação.',
	'deletequeue-vote-reason' => 'Comentários:',
	'deletequeue-vote-submit' => 'Enviar',
	'deletequeue-vote-success-endorse' => 'Apoiou com sucesso a eliminação desta página.',
	'deletequeue-vote-success-object' => 'Objectou com sucesso à eliminação desta página.',
	'deletequeue-vote-requeued' => 'Objectou com sucesso à eliminação desta página.
Devido à sua objecção, a página foi movida para a fila $1.',
	'deletequeue-showvotes' => 'Apoios e objecções à eliminação de "$1"',
	'deletequeue-showvotes-text' => "Abaixo estão os apoios e objecções à eliminação da página \"'''\$1'''\".
Pode [{{fullurl:{{FULLPAGENAME}}|action=delvote}} registar o seu próprio apoio ou objecção] a esta eliminação.",
	'deletequeue-showvotes-restrict-endorse' => 'Mostrar apenas os apoios',
	'deletequeue-showvotes-restrict-object' => 'Mostrar apenas as objecções',
	'deletequeue-showvotes-restrict-none' => 'Mostrar todos os apoios e objecções',
	'deletequeue-showvotes-vote-endorse' => "'''Apoiou''' a eliminação em $1, às $2",
	'deletequeue-showvotes-vote-object' => "'''Objectou''' à eliminação em $1, às $2",
	'deletequeue-showvotes-showingonly-endorse' => 'A mostrar apenas os apoios',
	'deletequeue-showvotes-showingonly-object' => 'A mostrar apenas as objecções',
	'deletequeue-showvotes-none' => 'Não há apoios ou objecções à eliminação desta página.',
	'deletequeue-showvotes-none-endorse' => 'Não há apoios à eliminação desta página.',
	'deletequeue-showvotes-none-object' => 'Não há objecções à eliminação desta página.',
	'deletequeue' => 'Fila de eliminações',
	'deletequeue-list-text' => 'Esta página mostra todas as páginas que estão no sistema de eliminações.',
	'deletequeue-list-search-legend' => 'Pesquisar páginas',
	'deletequeue-list-queue' => 'Fila:',
	'deletequeue-list-status' => 'Estado:',
	'deletequeue-list-expired' => 'Mostrar apenas nomeações que necessitam de ser fechadas.',
	'deletequeue-list-search' => 'Pesquisar',
	'deletequeue-list-anyqueue' => '(qualquer)',
	'deletequeue-list-votes' => 'Lista de votos',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|apoio|apoios}}, $2 {{PLURAL:$2|objecção|objecções}}',
	'deletequeue-list-header-page' => 'Página',
	'deletequeue-list-header-queue' => 'Fila',
	'deletequeue-list-header-votes' => 'Apoios e objecções',
	'deletequeue-list-header-expiry' => 'Validade',
	'deletequeue-list-header-discusspage' => 'Página de discussão',
	'deletequeue-case-intro' => 'Esta página lista informação sobre um caso de eliminação específico.',
	'deletequeue-list-header-reason' => 'Motivo de eliminação',
	'deletequeue-case-votes' => 'Apoios/objecções:',
	'deletequeue-case-title' => 'Detalhes do caso de eliminação',
	'deletequeue-case-details' => 'Detalhes básicos',
	'deletequeue-case-page' => 'Página:',
	'deletequeue-case-reason' => 'Motivo:',
	'deletequeue-case-expiry' => 'Validade:',
	'deletequeue-case-needs-review' => 'Este caso requer [[$1|revisão]].',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Helder.wiki
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
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'deletequeue-action-queued' => 'Ştergeri',
	'deletequeue-generic-reasons' => '* Motive generice
** Vandalism
** Spam
** Întreținere
** În afara scopului proiectului',
	'deletequeue-nom-alreadyqueued' => 'Această pagină se află deja într-o listă de ștergere.',
	'deletequeue-speedy-title' => 'Marchează "$1" pentru ștergere rapidă',
	'deletequeue-prod-title' => 'Propune ștergerea lui "$1"',
	'deletequeue-delnom-reason' => 'Motiv pentru nominalizare:',
	'deletequeue-delnom-otherreason' => 'Alt motiv',
	'deletequeue-delnom-submit' => 'Trimite nominalizarea',
	'right-prod-nominate' => 'Propune ștergerea paginii',
	'deletequeue-queue-speedy' => 'Ştergere rapidă',
	'deletequeue-queue-prod' => 'Ştergere propusă',
	'deletequeue-page-speedy' => "Această pagină a fost nominalizată pentru ştergere rapidă.
Motivul invocat pentru această ştergere este ''$1''.",
	'deletequeue-notqueued' => 'Pagina care aţi selectat-o nu este în aşteptare pentru ştergere',
	'deletequeue-review-action' => 'Acțiune de întreprins:',
	'deletequeue-review-delete' => 'Șterge pagina.',
	'deletequeue-review-requeue' => 'Transferă această pagină în coada următoare:',
	'deletequeue-review-reason' => 'Comentarii:',
	'deletequeue-review-newreason' => 'Motiv nou:',
	'deletequeue-review-newextra' => 'Informații suplimentare:',
	'deletequeue-review-submit' => 'Salvați recenzie',
	'deletequeue-review-original' => 'Motiv pentru nominalizare',
	'deletequeue-review-badaction' => 'Ați specificat o acțiune invalidă',
	'deletequeue-review-actiondenied' => 'Ați specificat o acțiune care este dezactivată pentru această pagină',
	'deletequeue-vote-action' => 'Recomandare:',
	'deletequeue-vote-reason' => 'Comentarii:',
	'deletequeue-vote-submit' => 'Trimite',
	'deletequeue-list-queue' => 'În listă:',
	'deletequeue-list-status' => 'Stare:',
	'deletequeue-list-search' => 'Căutare',
	'deletequeue-list-anyqueue' => '(orice)',
	'deletequeue-list-votes' => 'Lista de voturi',
	'deletequeue-list-header-page' => 'Pagină',
	'deletequeue-list-header-expiry' => 'Expirare',
	'deletequeue-list-header-discusspage' => 'Pagină de discuții',
	'deletequeue-case-details' => 'Detalii de bază',
	'deletequeue-case-page' => 'Pagina:',
	'deletequeue-case-reason' => 'Motiv:',
	'deletequeue-case-expiry' => 'Expirare:',
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
 * @author Innv
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'deletequeue-desc' => 'Создаёт [[Special:DeleteQueue|основанную на очереди систему управления удалениями]]',
	'deletequeue-action-queued' => 'Удаление',
	'deletequeue-action' => 'Предложить удаление',
	'deletequeue-action-title' => 'Предложить удаление "$1"',
	'deletequeue-action-text' => "В этой вики действуют следующие способы удаления страниц:
* Если вы уверены, что страница должна быть удалена, вы можете [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} предложить её к ''быстрому удалению''].
* Если эта страница не подходит под быстрое удаление, но её ''удаление, вероятно, не будет оспорено'', вам следует [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} предложить неспоренное удаление].
* Если удаление этой страницы ''может быть оспорено'', вам следует [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} открыть обсуждение].",
	'deletequeue-action-text-queued' => 'Вы можете просмотреть следующие страницы для этого запроса удаления:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Просмотреть текущих сторонников и противников].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Поддержать или отклонить удаление этой страницы].',
	'deletequeue-permissions-noedit' => 'Вы должны иметь возможность редактировать страницы, чтобы иметь возможность влиять на их состояние удаления.',
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
	'deletequeue-prod-text' => "Вы можете использовать эту форму чтобы предложить на удаление '''«$1»'''

Если по истечении пяти дней, никто не оспорит предложение по удалению, страница будет удалена после последней проверки администратором.",
	'deletequeue-delnom-reason' => 'Причина номинации:',
	'deletequeue-delnom-otherreason' => 'Другие причины',
	'deletequeue-delnom-extra' => 'Дополнительная информация:',
	'deletequeue-delnom-submit' => 'Подтвердить номинацию',
	'deletequeue-log-nominate' => "номинирована [[$1]] для удаления в очереди '$2'.",
	'deletequeue-log-rmspeedy' => 'отклонена для быстрого удаления [[$1]].',
	'deletequeue-log-requeue' => 'перенёс [[$1]] в другую очередь удаления: из «$2» в «$3».',
	'deletequeue-log-dequeue' => "удалено [[$1]] из очереди удаления '$2'.",
	'right-speedy-nominate' => 'Номинация страниц к быстрому удалению',
	'right-speedy-review' => 'досмотр номинаций к быстрому удалению',
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
	'deletequeue-page-prod' => "Было предложено удаление этой страницы.
Указана следующая причина — ''$1''.
Если это предложение не будет оспорено в течение ''$2'', эта страница может быть удалена.
Вы можете прочитать обсуждение удалению этой страницы [{{fullurl:{{FULLPAGENAME}}|action=delvote}} сторонниками и противниками].",
	'deletequeue-page-deletediscuss' => "Эта страница была предложена к удалению, и это предложение было оспорено.
Указана следующая причина: ''$1''.
Обсуждение продолжается на [[$5]], которое завершится в ''$2''.",
	'deletequeue-notqueued' => 'Выбранная вами страница на данный момент не находится в очереди к удалению',
	'deletequeue-review-action' => 'Принять меры:',
	'deletequeue-review-delete' => 'Удалить страницу.',
	'deletequeue-review-change' => 'Удалить эту страницу, но по другой причине.',
	'deletequeue-review-requeue' => 'Переместить эту страницу в следующую очередь:',
	'deletequeue-review-dequeue' => 'Не принимать мер и убрать страницу из очереди на удаление.',
	'deletequeue-review-reason' => 'Комментарии:',
	'deletequeue-review-newreason' => 'Новая причина:',
	'deletequeue-review-newextra' => 'Дополнительные сведения:',
	'deletequeue-review-submit' => 'Сохранить досмотр',
	'deletequeue-review-original' => 'Причина номинации',
	'deletequeue-actiondisabled-involved' => 'Следующее действие отключено, так как вы приняли участие в данном предложении удаления в качестве $1:',
	'deletequeue-actiondisabled-notexpired' => 'Следующее действие отключено, поскольку срок номинации на удаление ещё не истёк:',
	'deletequeue-review-badaction' => 'Вы указали неправильное действие',
	'deletequeue-review-actiondenied' => 'Вы указали действие, которое отключено для этой страницы',
	'deletequeue-review-objections' => "'''Предупреждение.''' Есть [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} возражения] против удаления этой страницы.
Пожалуйста, убедитесь, что ознакомились с этими возражениями перед удалением этой страницы.",
	'deletequeue-reviewspeedy-tab' => 'Досмотр быстрого удаления',
	'deletequeue-reviewspeedy-title' => 'Досмотр быстрого удаления номинации «$1»',
	'deletequeue-reviewspeedy-text' => "Вы можете использовать эту форму для досмотра номинации '''«$1»''' к быстрому удалению.
Пожалуйста, проверьте, что эта страница может быть быстро удалена в соответствии с правилами.",
	'deletequeue-reviewprod-tab' => 'Просмотр предлагаемых удалений',
	'deletequeue-reviewprod-title' => 'Просмотр предлагаемого удаления «$1»',
	'deletequeue-reviewprod-text' => "Вы можете использовать эту форму для досмотра неоспоренного предложения на удаление '''«$1»'''.",
	'deletequeue-reviewdeletediscuss-tab' => 'Досмотр удаления',
	'deletequeue-reviewdeletediscuss-title' => 'Досмотр обсуждения удаления для «$1»',
	'deletequeue-reviewdeletediscuss-text' => "Вы можете использовать эту форму для досмотра обсуждения удаления '''«$1»'''.

Доступен [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} список] сторонников и противников этого удаления. Обсуждение удаления можно найти на странице [[$2]].
Пожалуйста, убедитесь, что вы принимаете решение согласно консенсусу в обсуждении.",
	'deletequeue-review-success' => 'Вы успешно досмотрели удаление этой страницы',
	'deletequeue-review-success-title' => 'Досмотр завершён',
	'deletequeue-deletediscuss-discussionpage' => 'Это страница обсуждения удаления [[$1]].
Сейчас есть $2 {{PLURAL:$2|участник, поддерживающий|участника, поддерживающих|участников, поддерживающих}} удаление и $3 {{PLURAL:$3|участник, отклоняющий|участника, отклоняющих|участников, отклоняющих}} удаление.
Вы можете [{{fullurl:$1|action=delvote}} поддержать или отклонить] удаление, или [{{fullurl:$1|action=delviewvotes}} просмотреть всех сторонников и противников].',
	'deletequeue-discusscreate-summary' => 'Создание обсуждения удаления [[$1]].',
	'deletequeue-discusscreate-text' => 'Удаление предлагается по следующей причине: $2',
	'deletequeue-role-nominator' => 'оригинальный номинатор к удалению',
	'deletequeue-role-vote-endorse' => 'сторонники удаления',
	'deletequeue-role-vote-object' => 'противники удаления',
	'deletequeue-vote-tab' => 'Голос за удаление',
	'deletequeue-vote-title' => 'Поддержать или отклонить удаление «$1»',
	'deletequeue-vote-text' => "Вы можете использовать эту форму, чтобы поддержать или отклонить удаление '''«$1»'''.
Это действие переопределяет любые предыдущие поддержания/возрожения, которые вы высказывали об удалении этой страницы.
Вы можете [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} просмотреть] существующих сторонников и противников.
Причина, указанная в номинации к удалению — ''$2''.",
	'deletequeue-vote-legend' => 'Одобрение/Отказ удаления',
	'deletequeue-vote-action' => 'Рекомендация:',
	'deletequeue-vote-endorse' => 'Одобрить удаление.',
	'deletequeue-vote-object' => 'Отказать в удалении.',
	'deletequeue-vote-reason' => 'Комментарии:',
	'deletequeue-vote-submit' => 'Отправить',
	'deletequeue-vote-success-endorse' => 'Вы успешно поддержали удаление этой страницы.',
	'deletequeue-vote-success-object' => 'Вы успешно возразили против удаления этой страницы.',
	'deletequeue-vote-requeued' => 'Вы успешно отклонили удаление этой страницы.
После вашего отклонения, эта страница перенесена в очередь $1.',
	'deletequeue-showvotes' => 'Сторонники и противники удаления «$1»',
	'deletequeue-showvotes-text' => "Ниже приведены сторонники и противники удаления страницы '''«$1»'''.
Вы можете [{{fullurl:{{FULLPAGENAME}}|action=delvote}} поддержать это удаление или возразить против него].",
	'deletequeue-showvotes-restrict-endorse' => 'Просмотр только сторонников',
	'deletequeue-showvotes-restrict-object' => 'Просмотр только противников',
	'deletequeue-showvotes-restrict-none' => 'Просмотр всех сторонников и противников',
	'deletequeue-showvotes-vote-endorse' => "'''Поддержать''' удаление на $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Отклонить''' удаление на $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Показать только сторонников',
	'deletequeue-showvotes-showingonly-object' => 'Показать только противников',
	'deletequeue-showvotes-none' => 'Нет сторонников или противников удаления этой страницы.',
	'deletequeue-showvotes-none-endorse' => 'Нет сторонников удаления этой страницы.',
	'deletequeue-showvotes-none-object' => 'Нет противников удаления этой страницы.',
	'deletequeue' => 'Очередь удаления',
	'deletequeue-list-text' => 'Эта страница отображается все страницы в системе удаления.',
	'deletequeue-list-search-legend' => 'Поиск по страницам',
	'deletequeue-list-queue' => 'Очередь:',
	'deletequeue-list-status' => 'Статус:',
	'deletequeue-list-expired' => 'Показывать только номинации, требующие закрытия.',
	'deletequeue-list-search' => 'Поиск',
	'deletequeue-list-anyqueue' => '(любой)',
	'deletequeue-list-votes' => 'Список голосований',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|сторонник|сторонника|сторонников}}, $2 {{PLURAL:$2|противник|противника|противников}}',
	'deletequeue-list-header-page' => 'Страница',
	'deletequeue-list-header-queue' => 'Очередь',
	'deletequeue-list-header-votes' => 'Сторонники и противники',
	'deletequeue-list-header-expiry' => 'Истёкшие',
	'deletequeue-list-header-discusspage' => 'Страница обсуждения',
	'deletequeue-case-intro' => 'На этой странице представлены информационные списки по конкретному запросу на удаление.',
	'deletequeue-list-header-reason' => 'Причина для удаления',
	'deletequeue-case-votes' => 'Сторонники/противники:',
	'deletequeue-case-title' => 'Подробности запроса на удаление',
	'deletequeue-case-details' => 'Основные подробности',
	'deletequeue-case-page' => 'Страница:',
	'deletequeue-case-reason' => 'Причина:',
	'deletequeue-case-expiry' => 'Истекает:',
	'deletequeue-case-needs-review' => 'Этот запрос требует [[$1|досмотра]].',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'deletequeue-list-search' => "Va' cerca",
	'deletequeue-case-page' => 'Pàggina:',
	'deletequeue-case-reason' => 'Mutivu:',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'deletequeue-delnom-otherreason' => 'Ostali razlog/zi',
	'deletequeue-vote-submit' => 'Unesi',
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

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'deletequeue-list-status' => 'Stanje:',
	'deletequeue-list-header-page' => 'Stran',
	'deletequeue-case-page' => 'Stran:',
	'deletequeue-case-reason' => 'Razlog:',
);

/** Somali (Soomaaliga)
 * @author Maax
 */
$messages['so'] = array(
	'deletequeue-list-search-legend' => 'Raadi boggaga',
	'deletequeue-list-search' => 'Raadi',
	'deletequeue-list-anyqueue' => '(wax kasto)',
	'deletequeue-list-header-expiry' => 'Waxuu dhacaa',
	'deletequeue-case-reason' => 'Sababta:',
	'deletequeue-case-expiry' => 'Wuxuu dhacaa:',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'deletequeue-generic-reasons' => '* Генерички разлози
** Вандализам
** Спам
** Одржавање
** Није за пројекат',
	'deletequeue-nom-alreadyqueued' => 'Ова страница се већ налази у реду за брисање.',
	'deletequeue-speedy-title' => 'Означи "$1" за брзо брисање',
	'deletequeue-speedy-reasons' => '-',
	'deletequeue-prod-reasons' => '-',
	'deletequeue-delnom-reason' => 'Разлог за предлог:',
	'deletequeue-delnom-otherreason' => 'Други разлог',
	'deletequeue-delnom-extra' => 'Додатне информације:',
	'deletequeue-delnom-submit' => 'Пошаљи предлог',
	'deletequeue-log-nominate' => "[[$1]] је предложен за брисање у реду '$2'.",
	'deletequeue-log-rmspeedy' => 'брзо брисање [[$1]] је одбијено.',
	'deletequeue-log-dequeue' => "обрисао [[$1]] из реда за брисање '$2'.",
	'right-speedy-nominate' => 'Предлагање страна за брзо брисање',
	'right-prod-nominate' => 'Предложите брисање стране',
	'right-deletediscuss-nominate' => 'Започни расправе о брисању',
	'right-deletediscuss-review' => 'Затвори расправе о брисњу',
	'deletequeue-queue-speedy' => 'Брзо брисање',
	'deletequeue-queue-prod' => 'Предложено брисање',
	'deletequeue-queue-deletediscuss' => 'Дискусија о брисању',
	'deletequeue-page-speedy' => "Ова страница је била означена за брзо брисање.
Разлог дат за ово брисање је ''$1''.",
	'deletequeue-page-prod' => "Ова страница је предложена за брисање.
Дати разлог је ''$1''.
Ако овај разлог не буде доведен у питање до ''$2'', ова страница ће бити обрисана.
Можете спречити брисање ове странице [{{fullurl:{{FULLPAGENAME}}|action=delvote}} изношењем противних аргумената].",
	'deletequeue-page-deletediscuss' => "Ова страница је предложена за брисање, и предлог је био доведен у питање.
Дати разлог је био ''$1''.
Дискусија се води на [[$5]], и завршиће се на ''$2''.",
	'deletequeue-notqueued' => 'Страница коју сте изабрали тренутно није у реду за брисање',
	'deletequeue-review-action' => 'Акција за извршавање:',
	'deletequeue-review-delete' => 'Брисање стране.',
	'deletequeue-review-change' => 'Обриши ово страну, али са другим образложењем.',
	'deletequeue-review-requeue' => 'Пренеси ову страну на следећи ред:',
	'deletequeue-review-dequeue' => 'Не подузимај никакву акцију, и склони страну из реда за брисање.',
	'deletequeue-review-reason' => 'Коментари:',
	'deletequeue-review-newreason' => 'Нови разлог:',
	'deletequeue-review-newextra' => 'Додатне информације:',
	'deletequeue-review-submit' => 'Сними преглед',
	'deletequeue-review-original' => 'Разлог номинације',
	'deletequeue-review-badaction' => 'Изабрали сте акцију која не стоји на располагању',
	'deletequeue-review-actiondenied' => 'Изабрали сте акцију која је онемогућена над овом страном',
	'deletequeue-discusscreate-summary' => 'Прављење дискусије о брисању [[$1]].',
	'deletequeue-discusscreate-text' => 'Брисање предложено из следећег разлога: $2',
	'deletequeue-role-nominator' => 'оригинални предлагач брисања',
	'deletequeue-role-vote-endorse' => 'присталица брисања',
	'deletequeue-role-vote-object' => 'противник брисања',
	'deletequeue-vote-tab' => 'Глас за брисање',
	'deletequeue-vote-title' => 'Подржи или се противи брисању „$1“',
	'deletequeue-vote-legend' => 'Подржи/противи се брисању',
	'deletequeue-vote-action' => 'Препорука:',
	'deletequeue-vote-endorse' => 'Подржи брисање.',
	'deletequeue-vote-object' => 'Противи се брисању.',
	'deletequeue-vote-reason' => 'Коментари:',
	'deletequeue-vote-submit' => 'Пошаљи',
	'deletequeue-vote-success-endorse' => 'Успешно сте подржали брисање ове стране.',
	'deletequeue-vote-requeued' => 'Успешно сте се успротивили брисању ове странице.
Због Вашег противљења, страница је премештена у следећи ред: $1.',
	'deletequeue-showvotes' => 'Подршка и противљење брисању "$1".',
	'deletequeue-showvotes-restrict-endorse' => 'Прикажи само подршке',
	'deletequeue-showvotes-restrict-object' => 'Прикажи само противљења',
	'deletequeue-showvotes-restrict-none' => 'Прикажи све подршке и противљења',
	'deletequeue-showvotes-vote-endorse' => "'''Подржао''' брисање на $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Противио''' се брисању на $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Приказане су само подршке',
	'deletequeue-showvotes-showingonly-object' => 'Приказана су само противљења',
	'deletequeue-showvotes-none' => 'Нема подршки или притвљења брисању ове стране.',
	'deletequeue-showvotes-none-endorse' => 'Нема подршке брисању ове стране.',
	'deletequeue-showvotes-none-object' => 'Нема противљења брисању ове стране.',
	'deletequeue' => 'Ред за брисање',
	'deletequeue-list-text' => 'Ова страна приказује све стране, које су у систему за брисање.',
	'deletequeue-list-search-legend' => 'Претрага страница',
	'deletequeue-list-queue' => 'Ред:',
	'deletequeue-list-status' => 'Статус:',
	'deletequeue-list-expired' => 'Прикажи само номиновања, која треба затворити.',
	'deletequeue-list-search' => 'Претрага',
	'deletequeue-list-anyqueue' => '(било које)',
	'deletequeue-list-votes' => 'Списак гласова',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|подршка|подршки}}, $2 {{PLURAL:$2|противљење|противљења}}',
	'deletequeue-list-header-page' => 'Страница',
	'deletequeue-list-header-queue' => 'Ред',
	'deletequeue-list-header-votes' => 'Подршке и противљења',
	'deletequeue-list-header-expiry' => 'Истек',
	'deletequeue-list-header-discusspage' => 'Страница за разговор',
	'deletequeue-case-intro' => 'Ова страна приказује информацију о појединачном случају брисања.',
	'deletequeue-list-header-reason' => 'Разлог',
	'deletequeue-case-votes' => 'Подршке/противљења:',
	'deletequeue-case-title' => 'Детаљи о случају брисања',
	'deletequeue-case-details' => 'Основни детаљи',
	'deletequeue-case-page' => 'Страна:',
	'deletequeue-case-reason' => 'Разлог:',
	'deletequeue-case-expiry' => 'Истек:',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'deletequeue-generic-reasons' => '* Generički razlozi
** Vandalizam
** Spam
** Održavanje
** Nije za projekat',
	'deletequeue-nom-alreadyqueued' => 'Ova strana se već nalazi u redu za brisanje.',
	'deletequeue-speedy-title' => 'Označi "$1" za brzo brisanje',
	'deletequeue-speedy-reasons' => '-',
	'deletequeue-prod-reasons' => '-',
	'deletequeue-delnom-reason' => 'Razlog za predlog:',
	'deletequeue-delnom-otherreason' => 'Drugi razlog',
	'deletequeue-delnom-extra' => 'Dodatne informacije:',
	'deletequeue-delnom-submit' => 'Pošalji predlog',
	'deletequeue-log-nominate' => "[[$1]] je predložen za brisanje u redu '$2'.",
	'deletequeue-log-rmspeedy' => 'brzo brisanje [[$1]] je odbijeno.',
	'deletequeue-log-dequeue' => "obrisao [[$1]] iz reda za brisanje '$2'.",
	'right-speedy-nominate' => 'Predlaganje strana za brzo brisanje',
	'right-prod-nominate' => 'Predložite brisanje strane',
	'right-deletediscuss-nominate' => 'Započni rasprave o brisanju',
	'right-deletediscuss-review' => 'Zatvori rasprave o brisnju',
	'deletequeue-queue-speedy' => 'Brzo brisanje',
	'deletequeue-queue-prod' => 'Predloženo brisanje',
	'deletequeue-queue-deletediscuss' => 'Diskusija o brisanju',
	'deletequeue-page-speedy' => "Ova strana je bila označena za brzo brisanje.
Razlog dat za ovo brisanje je ''$1''.",
	'deletequeue-page-prod' => "Ova strana je predložena za brisanje.
Dati razlog je ''$1''.
Ako ovaj razlog ne bude doveden u pitanje do ''$2'', ova strana će biti obrisana.
Možete sprečiti brisanje ove strane [{{fullurl:{{FULLPAGENAME}}|action=delvote}} iznošenjem protivnih argumenata].",
	'deletequeue-page-deletediscuss' => "Ova strana je predložena za brisanje, i predlog je bio doveden u pitanje.
Dati razlog je bio ''$1''.
Diskusija se vodi na [[$5]], i završiće se na ''$2''.",
	'deletequeue-notqueued' => 'Strana koju ste izabrali trenutno nije u redu za brisanje',
	'deletequeue-review-action' => 'Akcija za izvršavanje:',
	'deletequeue-review-delete' => 'Brisanje strane.',
	'deletequeue-review-change' => 'Obriši ovo stranu, ali sa drugim obrazloženjem.',
	'deletequeue-review-requeue' => 'Prenesi ovu stranu na sledeći red:',
	'deletequeue-review-dequeue' => 'Ne poduzimaj nikakvu akciju, i skloni stranu iz reda za brisanje.',
	'deletequeue-review-reason' => 'Komentari:',
	'deletequeue-review-newreason' => 'Novi razlog:',
	'deletequeue-review-newextra' => 'Dodatne informacije:',
	'deletequeue-review-submit' => 'Snimi pregled',
	'deletequeue-review-original' => 'Razlog nominacije',
	'deletequeue-review-badaction' => 'Izabrali ste akciju koja ne stoji na raspolaganju',
	'deletequeue-review-actiondenied' => 'Izabrali ste akciju koja je onemogućena nad ovom stranom',
	'deletequeue-discusscreate-summary' => 'Pravljenje diskusije o brisanju [[$1]].',
	'deletequeue-discusscreate-text' => 'Brisanje predloženo iz sledećeg razloga: $2',
	'deletequeue-role-nominator' => 'originalni predlagač brisanja',
	'deletequeue-role-vote-endorse' => 'pristalica brisanja',
	'deletequeue-role-vote-object' => 'protivnik brisanja',
	'deletequeue-vote-tab' => 'Glas za brisanje',
	'deletequeue-vote-title' => 'Podrži ili se protivi brisanju „$1“',
	'deletequeue-vote-legend' => 'Podrži/protivi se brisanju',
	'deletequeue-vote-action' => 'Preporuka:',
	'deletequeue-vote-endorse' => 'Podrži brisanje.',
	'deletequeue-vote-object' => 'Protivi se brisanju.',
	'deletequeue-vote-reason' => 'Komentari:',
	'deletequeue-vote-submit' => 'Pošalji',
	'deletequeue-vote-success-endorse' => 'Uspešno ste podržali brisanje ove strane.',
	'deletequeue-vote-requeued' => 'Uspešno ste se usprotivili brisanju ove strane.
Zbog Vašeg protivljenja, strana je premeštena u sledeći red: $1.',
	'deletequeue-showvotes' => 'Podrška i protivljenje brisanju "$1".',
	'deletequeue-showvotes-restrict-endorse' => 'Prikaži samo podrške',
	'deletequeue-showvotes-restrict-object' => 'Prikaži samo protivljenja',
	'deletequeue-showvotes-restrict-none' => 'Prikaži sve podrške i protivljenja',
	'deletequeue-showvotes-vote-endorse' => "'''Podržao''' brisanje na $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Protivio''' se brisanju na $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Prikazane su samo podrške',
	'deletequeue-showvotes-showingonly-object' => 'Prikazana su samo protivljenja',
	'deletequeue-showvotes-none' => 'Nema podrški ili pritvljenja brisanju ove strane.',
	'deletequeue-showvotes-none-endorse' => 'Nema podrške brisanju ove strane.',
	'deletequeue-showvotes-none-object' => 'Nema protivljenja brisanju ove strane.',
	'deletequeue' => 'Red za brisanje',
	'deletequeue-list-text' => 'Ova strana prikazuje sve strane, koje su u sistemu za brisanje.',
	'deletequeue-list-search-legend' => 'Potraži strane',
	'deletequeue-list-queue' => 'Red:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Prikaži samo nominovanja, koja treba zatvoriti.',
	'deletequeue-list-search' => 'Pretraga',
	'deletequeue-list-anyqueue' => '(bilo koje)',
	'deletequeue-list-votes' => 'Spisak glasova',
	'deletequeue-list-votecount' => '$1 {{PLURAL:$1|podrška|podrški}}, $2 {{PLURAL:$2|protivljenje|protivljenja}}',
	'deletequeue-list-header-page' => 'Strana',
	'deletequeue-list-header-queue' => 'Red',
	'deletequeue-list-header-votes' => 'Podrške i protivljenja',
	'deletequeue-list-header-expiry' => 'Istek',
	'deletequeue-list-header-discusspage' => 'Strana diskusije',
	'deletequeue-case-intro' => 'Ova strana prikazuje informaciju o pojedinačnom slučaju brisanja.',
	'deletequeue-list-header-reason' => 'Razlog brisanja',
	'deletequeue-case-votes' => 'Podrške/protivljenja:',
	'deletequeue-case-title' => 'Detalji o slučaju brisanja',
	'deletequeue-case-details' => 'Osnovni detalji',
	'deletequeue-case-page' => 'Strana:',
	'deletequeue-case-reason' => 'Razlog:',
	'deletequeue-case-expiry' => 'Istek:',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'deletequeue-reviewdeletediscuss-tab' => 'Läskenge wröigje',
	'deletequeue-reviewdeletediscuss-title' => 'Läskdiskussion foar „$1“ wröigje',
	'deletequeue-reviewdeletediscuss-text' => "Ap disse Siede koast du ju Läskdiskussion fon „'''$1'''“ wröigje.

Dät rakt  ne [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Lieste] mäd Stimmen foar un juun ju Läskenge; ju eegentelke Diskussion is unner [[$2]] tou fienden.
Oachtje deerap, dät ne Äntskeedenge mäd dän Konsens fon ju Diskussion fereenboar is.",
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
Disse Aktion uurskrift aal Stimmen, do du foartied tou ju Läskenge fon disse Siede ouroat hääst.
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
Truch dien Wierspruch wuud ju Siede in ju Läsk-Täiweslange $1 ferskäuwen.',
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

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'deletequeue-case-reason' => 'Alesan:',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Leo Johannes
 * @author M.M.S.
 * @author Najami
 * @author Njaelkies Lea
 * @author Per
 * @author Rotsee
 * @author StefanB
 */
$messages['sv'] = array(
	'deletequeue-desc' => 'Skapar en [[Special:DeleteQueue|köbaserat system för att hantera raderingar]]',
	'deletequeue-action-queued' => 'Radering',
	'deletequeue-action' => 'Föreslå radering',
	'deletequeue-action-title' => 'Föreslå radering av "$1"',
	'deletequeue-action-text' => "Denna wiki har flera processer för att radera sidor:
*Om du anser att denna sida bör snabbraderas kan du [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} föreslå detta här].
*Om denna sida inte kvalificerar för snabbradering, men ''radering sannolikt ändå är okontroversiellt'', kan du [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} föreslå radering här].
*Om sidans radering ''sannolikt kommer att bli diskuterad'', bör du [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} starta en diskussion] om saken.",
	'deletequeue-action-text-queued' => 'Följande sidor behandlar raderingsärendet:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Bifall och invändningar].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Ge ditt eget bifall eller invänd mot radering].',
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
	'deletequeue-log-nominate' => 'nominerade [[$1]] för radering i kön "$2".',
	'deletequeue-log-rmspeedy' => 'tillät inte snabbradering av [[$1]].',
	'deletequeue-log-requeue' => "[[$1]] flyttad till en ny raderingskö: Från '$2' till '$3'.",
	'deletequeue-log-dequeue' => "[[$1]] borttagen från raderingskön '$2'.",
	'right-speedy-nominate' => 'Anmäl sidor för snabbradering',
	'right-speedy-review' => 'Behandla anmälningar för snabbradering',
	'right-prod-nominate' => 'Föreslå radering',
	'right-prod-review' => 'Behandla raderingsförslag utan invändningar',
	'right-deletediscuss-nominate' => 'Starta raderingsdiskussion',
	'right-deletediscuss-review' => 'Avsluta raderingsdiskussion',
	'right-deletequeue-vote' => 'Stöd eller invänd mot radering',
	'deletequeue-queue-speedy' => 'Snabbradering',
	'deletequeue-queue-prod' => 'Föreslagen radering',
	'deletequeue-queue-deletediscuss' => 'Raderingsdiskussion',
	'deletequeue-page-speedy' => "Denna sida har nominerats för snabbradering.
Anledningen som givits för denna radering är ''$1''.",
	'deletequeue-page-prod' => "Den här sidan har föreslagits för radering på följande grund: ''$1''.
Om ingen motsatt sig radering före ''$2'' kommer sidan att raderas.
Du kan [{{fullurl:{{FULLPAGENAME}}|action=delvote}} invända mot radering här].",
	'deletequeue-page-deletediscuss' => "Den här sidan har varit föreskagen för radering, men förslaget har mötts av invändningar. 
Radering föreslogs på följande grund: ''$1''.
En diskussion om ärendet förs på [[$5]]. Diskussionen pågår till ''$2''.",
	'deletequeue-notqueued' => 'Sidan du har vald ligger inte i någon raderingskö',
	'deletequeue-review-action' => 'Åtgärd:',
	'deletequeue-review-delete' => 'Radera sidan.',
	'deletequeue-review-change' => 'Radera sidan, men på andra grunder.',
	'deletequeue-review-requeue' => 'Flytta den här sidan till följande raderingskö:',
	'deletequeue-review-dequeue' => 'Låt stå, och ta bort sidan från raderingskön.',
	'deletequeue-review-reason' => 'Kommentarer:',
	'deletequeue-review-newreason' => 'Ny anledning:',
	'deletequeue-review-newextra' => 'Extrainformation:',
	'deletequeue-review-submit' => 'Spara granskning',
	'deletequeue-review-original' => 'Skäl för radering',
	'deletequeue-actiondisabled-involved' => 'Du kan inte utföra den här handlingen, eftersom du har varit delaktig i raderingsärendet som $1',
	'deletequeue-actiondisabled-notexpired' => 'Du kan inte utföra den här handlingen efter som raderingsärendet ännu inte är avslutat:',
	'deletequeue-review-badaction' => 'Du har angivit en ogiltig åtgärd',
	'deletequeue-review-actiondenied' => 'Funktionen du försökte använda är avaktiverad för den här sidan.',
	'deletequeue-review-objections' => "'''Varning''': Det finns [{{fullurl:{{FULLPAGENAME}}|action=delvoteview&votetype=object}} invändningar] mot den här raderingen.
Försäkra dig om att du tagit del av och ställning till dessa innan du raderar sidan.",
	'deletequeue-reviewspeedy-tab' => 'Granska snabbradering',
	'deletequeue-reviewspeedy-title' => 'Granska snabbradering av "$1"',
	'deletequeue-reviewspeedy-text' => "Du kan använda det här formuläret för att granska anmälan av \"'''\$1'''\" för snabbradering.
Försäkra dig om att sidan kan raderas enligt gällande riktlinjer.",
	'deletequeue-reviewprod-tab' => 'Granska raderingsförslag',
	'deletequeue-reviewprod-title' => 'Granska förslaget till radering av "$1"',
	'deletequeue-reviewprod-text' => "Du kan använda det här formuläret för att granska förslaget till radering av \"'''\$1'''\". Förslaget har inte mött några invändningar.",
	'deletequeue-reviewdeletediscuss-tab' => 'Granska radering',
	'deletequeue-reviewdeletediscuss-title' => 'Granska raderingsdiskussionen för "$1"',
	'deletequeue-reviewdeletediscuss-text' => "Du kan använda det här formuläret för att granska raderingsdiskussionen för \"'''\$1'''\".

Det finns en [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} lista] över bifall och invändningar mot raderingen, samt en diskussion här: [[\$2]].
Försäkra dig om att följa konsensus i diskussionen.",
	'deletequeue-review-success' => 'Du har nu handlagt raderingen av den här sidan.',
	'deletequeue-review-success-title' => 'Granskningen genomförd',
	'deletequeue-deletediscuss-discussionpage' => 'Detta är diskussionssidan om den förslagna raderingen av [[$1]].
$2 {{PLURAL:$2|användare}} bifaller raderingsförslaget, och $3 {{PLURAL:$3|motsätter}} sig det.
Du kan [{{fullurl:$1|action=delvote}} bifalla eller invända] mot radering, eller [{{fullurl:$1|action=delviewvotes}} studera alla synpunkter].',
	'deletequeue-discusscreate-summary' => 'Skapar diskussion för raderingen av [[$1]].',
	'deletequeue-discusscreate-text' => 'Radering föreslagen på grund av följande anledning: $2',
	'deletequeue-role-nominator' => 'anmälde ursprungligen artikeln för radering',
	'deletequeue-role-vote-endorse' => 'förespråkar radering',
	'deletequeue-role-vote-object' => 'motsätter sig radering',
	'deletequeue-vote-tab' => 'Rösta om radering',
	'deletequeue-vote-title' => 'Bifall eller invänd mot förslaget om radering av "$1"',
	'deletequeue-vote-text' => "Du kan använda det här formuläret för att bifalla eller invända mot förslaget till radering av \"'''\$1'''\".
Eventuella tidigare ställningstaganden i ärendet kommer att ersättas.
Du kan [{{fullurl:\$1|action=delviewvotes}} studera alla hittillsvarande synpunkter]. Motiveringen till radering var ursprungligen ''\$2''.",
	'deletequeue-vote-legend' => 'Bifall/invänd mot radering',
	'deletequeue-vote-action' => 'Rekommendation:',
	'deletequeue-vote-endorse' => 'Bifall radering.',
	'deletequeue-vote-object' => 'Invänd mot radering.',
	'deletequeue-vote-reason' => 'Kommentarer:',
	'deletequeue-vote-submit' => 'Skicka',
	'deletequeue-vote-success-endorse' => 'Du har bifallit förslaget om radering av den här sidan.',
	'deletequeue-vote-success-object' => 'Du har motsatt dig radering av den här sidan.',
	'deletequeue-vote-requeued' => 'Det har motsatt dig radering av den här sidan.
Till följd av din invändning har sidan flyttats till kön $1.',
	'deletequeue-showvotes' => 'Bifall och invändningar mot radering av "$1"',
	'deletequeue-showvotes-text' => "Nedan står bifall och invändningar mot radering av sidan \"'''\$1'''\".
Du kan själv [{{fullurl:\$1|action=delvote}} bifalla eller invända] mot radering.",
	'deletequeue-showvotes-restrict-endorse' => 'Visa endast bifall',
	'deletequeue-showvotes-restrict-object' => 'Vi endast invändningar',
	'deletequeue-showvotes-restrict-none' => 'Visa alla bifall och invändningar',
	'deletequeue-showvotes-vote-endorse' => "'''Bifaller''' förslaget om radering den $1 $2",
	'deletequeue-showvotes-vote-object' => "'''Invände mot''' radering den $1 $2",
	'deletequeue-showvotes-showingonly-endorse' => 'Visar endast bifall',
	'deletequeue-showvotes-showingonly-object' => 'Visar endast invändningar',
	'deletequeue-showvotes-none' => 'Det finns inga bifall eller invändningar mot radering av den här sidan.',
	'deletequeue-showvotes-none-endorse' => 'Det finns inga bifall för radering av den här sidan.',
	'deletequeue-showvotes-none-object' => 'Det finns inga invändningar mot radering av den här sidan.',
	'deletequeue' => 'Raderingskö',
	'deletequeue-list-text' => 'Den här sidan visar alla sidor i raderingssystemet.',
	'deletequeue-list-search-legend' => 'Sök efter sidor',
	'deletequeue-list-queue' => 'Kö:',
	'deletequeue-list-status' => 'Status:',
	'deletequeue-list-expired' => 'Vi endast anmälningar som behöver avslutas.',
	'deletequeue-list-search' => 'Sök',
	'deletequeue-list-anyqueue' => '(någon)',
	'deletequeue-list-votes' => 'Lista över röster',
	'deletequeue-list-votecount' => '$1 bifall, $2 {{PLURAL:$2|invändning|invändningar}}',
	'deletequeue-list-header-page' => 'Sida',
	'deletequeue-list-header-queue' => 'Kö',
	'deletequeue-list-header-votes' => 'Bifall och invändningar',
	'deletequeue-list-header-expiry' => 'Utgår',
	'deletequeue-list-header-discusspage' => 'Diskussionssida',
	'deletequeue-case-intro' => 'Den här sidan visar information om ett enskilt raderingsärende.',
	'deletequeue-list-header-reason' => 'Grund för radering:',
	'deletequeue-case-votes' => 'Bifall/invändningar:',
	'deletequeue-case-title' => 'Detaljer om raderingsärendet',
	'deletequeue-case-details' => 'Grundläggande detaljer',
	'deletequeue-case-page' => 'Sida:',
	'deletequeue-case-reason' => 'Anledning:',
	'deletequeue-case-expiry' => 'Går ut:',
	'deletequeue-case-needs-review' => 'Det här ärendet kräver [[$1|behandling]].',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'deletequeue-action-queued' => 'நீக்குதல்',
	'deletequeue-delnom-otherreason' => 'வேறு காரணம்',
	'deletequeue-delnom-extra' => 'மேலதிகத்தகவல்:',
	'deletequeue-queue-speedy' => 'விரைந்து நீக்குதல்',
	'deletequeue-queue-prod' => 'நீக்கப்படவேண்டியவை',
	'deletequeue-review-delete' => 'பக்கத்தை நீக்கவும்.',
	'deletequeue-review-reason' => 'கருத்துரைகள்:',
	'deletequeue-review-newreason' => 'புதிய காரணம்:',
	'deletequeue-review-newextra' => 'மேலதிகத்தகவல்:',
	'deletequeue-vote-submit' => 'சமர்ப்பி',
	'deletequeue-list-status' => 'நிலைமை:',
	'deletequeue-list-search' => 'தேடுக',
	'deletequeue-list-anyqueue' => '(ஏதாவது)',
	'deletequeue-list-header-page' => 'பக்கம்',
	'deletequeue-list-header-queue' => 'வரிசை',
	'deletequeue-case-page' => 'பக்கம்:',
	'deletequeue-case-reason' => 'காரணம்:',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'deletequeue-action-queued' => 'తొలగింపు',
	'deletequeue-nom-alreadyqueued' => 'ఈ పుట ఇప్పటికే తొలగింపు వరుసలో ఉంది.',
	'deletequeue-delnom-otherreason' => 'ఇతర కారణం',
	'deletequeue-delnom-extra' => 'అదనపు సమాచారం:',
	'deletequeue-queue-prod' => 'ప్రతిపాదిత తొలగింపు',
	'deletequeue-queue-deletediscuss' => 'తొలగింపు చర్చ',
	'deletequeue-review-action' => 'తీసుకోవాల్సిన చర్య:',
	'deletequeue-review-delete' => 'ఈ పేజీని తొలగించు.',
	'deletequeue-review-change' => 'ఈ పేజీని తొలగించు, కానీ వేరే కారణంతో.',
	'deletequeue-review-dequeue' => 'ఏమీ చేయకు, మరియు ఈ పేజీని తొలగింపు వరుస నుండి తీసేయి.',
	'deletequeue-review-reason' => 'వ్యాఖ్యలు:',
	'deletequeue-review-newreason' => 'కొత్త కారణం:',
	'deletequeue-review-newextra' => 'అదనపు సమాచారం:',
	'deletequeue-review-success' => 'మీరు విజయవంతంగా ఈ పేజీ యొక్క తొలగింపుని సమీక్షించారు',
	'deletequeue-review-success-title' => 'సమీక్ష పూర్తి',
	'deletequeue-discusscreate-text' => 'ఈ కారణం వల్ల తొలగింపుని ప్రతిపాదించారు: $2',
	'deletequeue-vote-reason' => 'వ్యాఖ్యలు:',
	'deletequeue-vote-submit' => 'దాఖలుచెయ్యి',
	'deletequeue-showvotes-none-object' => 'ఈ పేజీని తొలగించడానికి అభ్యంతరాలు ఏమీ లేవు.',
	'deletequeue' => 'తొలగింపు వరుస',
	'deletequeue-list-text' => 'తొలగింపు వ్యవస్థలో ఉన్న అన్నీ పేజీలనూ ఈ పేజీ చూపిస్తుంది.',
	'deletequeue-list-status' => 'స్థితి:',
	'deletequeue-list-search' => 'వెతుకు',
	'deletequeue-list-anyqueue' => '(ఏదైనా)',
	'deletequeue-list-header-page' => 'పేజీ',
	'deletequeue-list-header-discusspage' => 'చర్చా పేజీ',
	'deletequeue-case-intro' => 'ఈ పేజీ ఒక ప్రత్యేక తొలగింపు కేసుపై సమాచారాన్ని చూపిస్తుంది.',
	'deletequeue-list-header-reason' => 'తొలగింపుకి కారణం',
	'deletequeue-case-votes' => 'సమ్మతులు/అభ్యంతరాలు:',
	'deletequeue-case-details' => 'ప్రాధమిక వివరాలు',
	'deletequeue-case-page' => 'పేజీ:',
	'deletequeue-case-reason' => 'కారణం:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'deletequeue-delnom-otherreason' => 'Motivu seluk',
	'deletequeue-list-search' => 'Buka',
	'deletequeue-list-header-page' => 'Pájina',
	'deletequeue-case-page' => 'Pájina:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'deletequeue-list-search-legend' => 'Ҷустуҷӯи саҳифаҳо',
	'deletequeue-list-search' => 'Ҷустуҷӯ',
	'deletequeue-list-header-page' => 'Саҳифа',
	'deletequeue-list-header-discusspage' => 'Саҳифаи баҳс',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'deletequeue-list-search-legend' => 'Çustuçūi sahifaho',
	'deletequeue-list-search' => 'Çustuçū',
	'deletequeue-list-header-page' => 'Sahifa',
	'deletequeue-list-header-discusspage' => 'Sahifai bahs',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'deletequeue-list-search' => 'สืบค้น',
	'deletequeue-case-reason' => 'เหตุผล:',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'deletequeue-vote-submit' => 'Tabşyr',
	'deletequeue-list-header-page' => 'Sahypa',
	'deletequeue-case-page' => 'Sahypa:',
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
 * @author Homonihilis
 * @author Karduelis
 * @author Mach
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'deletequeue-desc' => '[[Special:DeleteQueue|Silme yönetimi için kuyruk temelli bir sistem]] oluşturur',
	'deletequeue-action-queued' => 'Silme',
	'deletequeue-action' => 'Silinmesini öner',
	'deletequeue-action-title' => '"$1" sayfasının silinmesini öner',
	'deletequeue-action-text' => "Bu viki, sayfaların silinmesi için birkaç sürece sahiptir:
*Bir sayfanın gerekli şartları sağladığını düşünüyorsanız, [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=speedy}} ''hızlı silinmesini'' önerin].
*Bir sayfanın hızlı silinme için uygun olduğunu, ancak ''silinmesinin tartışma yaratmamasının olası olduğunu'' düşünüyorsanız, [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=prod}} itirazsız silme önerebilirsiniz].
*Bu sayfanın silinmesine ''itiraz edilmesi olası'' ise, [{{fullurl:{{FULLPAGENAME}}|action=delnom&queue=deletediscuss}} bir tartışma açmalısınız].",
	'deletequeue-action-text-queued' => 'Bu silme durumu için aşağıdaki sayfaları inceleyebilirsiniz:
* [{{fullurl:{{FULLPAGENAME}}|action=delviewvotes}} Mevcut destek ve itirazları görün].
* [{{fullurl:{{FULLPAGENAME}}|action=delvote}} Bu sayfanın silinmesini destekleyin ya da itiraz edin]',
	'deletequeue-permissions-noedit' => 'Silinme durumunu etkileyebilmek için bir sayfada değişiklik yapabiliyor olmalısınız.',
	'deletequeue-generic-reasons' => '* Genel nedenler
** Vandalizm
** Reklam
** Bakım
** Proje kapsamı dışında',
	'deletequeue-nom-alreadyqueued' => 'Bu sayfa zaten bir silme kuyruğunda.',
	'deletequeue-speedy-title' => '"$1" sayfasını hızlı silinmesi için işaretle',
	'deletequeue-prod-title' => '"$1" adlı sayfanın silinmesini öner',
	'deletequeue-delnom-reason' => 'Adaylık gerekçesi:',
	'deletequeue-delnom-otherreason' => 'Diğer nedenler',
	'deletequeue-delnom-extra' => 'Ekstra bilgiler:',
	'deletequeue-delnom-submit' => 'Adaylığı gönder',
	'deletequeue-log-nominate' => "[[$1]] sayfası '$2' kuyruğunda silinmesi için aday gösterildi.",
	'deletequeue-log-rmspeedy' => '[[$1]] sayfasının hızlı silinmesi reddedildi.',
	'right-speedy-nominate' => 'Sayfaları hızlı silinmesi için önerir',
	'right-speedy-review' => 'Hızlı silme önerilerini inceler',
	'right-prod-nominate' => 'Sayfanın silinmesini önerir',
	'right-prod-review' => 'İtirazsız silinme isteklerini inceler',
	'right-deletediscuss-nominate' => 'Silme tartışmalarını başlatır',
	'right-deletediscuss-review' => 'Silme tartışmalarını kapatır',
	'right-deletequeue-vote' => 'Silinmeyi destekler ya da itiraz eder',
	'deletequeue-queue-speedy' => 'Hızlı silme',
	'deletequeue-queue-prod' => 'Silme önerisi',
	'deletequeue-queue-deletediscuss' => 'Silme tartışması',
	'deletequeue-review-action' => 'Uygulanacak işlem:',
	'deletequeue-review-delete' => 'Sayfayı sil.',
	'deletequeue-review-change' => 'Bu sayfayı sil, ancak farklı bir gerekçe kullan.',
	'deletequeue-review-requeue' => 'Bu sayfayı aşağıdaki kuyruğa aktar:',
	'deletequeue-review-dequeue' => 'İşlem yapma ve sayfayı silinme kuyruğundan çıkar.',
	'deletequeue-review-reason' => 'Yorumlar',
	'deletequeue-review-newreason' => 'Yeni gerekçe:',
	'deletequeue-review-newextra' => 'Ekstra bilgiler:',
	'deletequeue-review-submit' => 'İncelemeyi Kaydet',
	'deletequeue-review-original' => 'Adaylık nedeni',
	'deletequeue-actiondisabled-involved' => 'Aşağıdaki işlem devre dışı bırakıldı, zira $1 rollerinin silinme konularına katılımınız tespit edildi:',
	'deletequeue-actiondisabled-notexpired' => 'Aşağıdaki işlem devre dışı bırakıldı, zira silme tartışmasının süresiz henüz dolmadı:',
	'deletequeue-review-badaction' => 'Geçersiz bir işlem belirttiniz',
	'deletequeue-reviewspeedy-tab' => 'Hızlı silmeyi incele',
	'deletequeue-reviewspeedy-title' => '"$1" sayfasının hızlı silinme adaylığını incele',
	'deletequeue-reviewprod-tab' => 'Silme önerisini incele',
	'deletequeue-reviewdeletediscuss-tab' => 'Silmeyi incele',
	'deletequeue-reviewdeletediscuss-title' => '"$1" için silme tartışmasını incele',
	'deletequeue-review-success' => 'Bu sayfanın silinmesini başarıyla incelediniz',
	'deletequeue-review-success-title' => 'İnceleme tamamlandı',
	'deletequeue-role-nominator' => 'silinmeye aday gösteren asıl kişi',
	'deletequeue-role-vote-endorse' => 'silinmeyi destekleyen',
	'deletequeue-role-vote-object' => 'silinmeye karşı çıkan',
	'deletequeue-vote-tab' => 'Silinme konusunda oy ver',
	'deletequeue-vote-title' => '"$1" sayfasının silinmesini destekle ya da karşı çık',
	'deletequeue-vote-legend' => 'Silinmeyi destekle/itiraz et',
	'deletequeue-vote-action' => 'Öneri:',
	'deletequeue-vote-endorse' => 'Silinmeyi destekle.',
	'deletequeue-vote-object' => 'Silinmeye itiraz et.',
	'deletequeue-vote-reason' => 'Yorumlar:',
	'deletequeue-vote-submit' => 'Gönder',
	'deletequeue-vote-success-endorse' => 'Bu sayfanın silinmesini başarıyla desteklediniz.',
	'deletequeue-vote-success-object' => 'Bu sayfanın silinmesine başarıyla itiraz ettiniz.',
	'deletequeue-showvotes-restrict-endorse' => 'Sadece destekleri göster',
	'deletequeue-showvotes-restrict-object' => 'Sadece itirazları göster',
	'deletequeue-showvotes-showingonly-endorse' => 'Sadece destekler gösteriliyor',
	'deletequeue-showvotes-showingonly-object' => 'Sadece itirazlar gösteriliyor',
	'deletequeue-showvotes-none' => 'Bu sayfanın silinmesine destek ya da itiraz gelmemiş',
	'deletequeue-showvotes-none-endorse' => 'Bu sayfanın silinmesine destek gelmemiş.',
	'deletequeue-showvotes-none-object' => 'Bu sayfanın silinmesine itiraz gelmemiş.',
	'deletequeue' => 'Silme kuyruğu',
	'deletequeue-list-text' => 'Bu sayfa, silme sisteminde olan tüm sayfaları göstermektedir.',
	'deletequeue-list-search-legend' => 'Sayfa ara',
	'deletequeue-list-queue' => 'Kuyruk:',
	'deletequeue-list-status' => 'Durum:',
	'deletequeue-list-expired' => 'Sadece kapanması gereken adaylıkları göster.',
	'deletequeue-list-search' => 'Ara',
	'deletequeue-list-anyqueue' => '(herhangi)',
	'deletequeue-list-votes' => 'Oy listesi',
	'deletequeue-list-header-page' => 'Sayfa',
	'deletequeue-list-header-queue' => 'Kuyruk',
	'deletequeue-list-header-votes' => 'Destek ve itirazlar',
	'deletequeue-list-header-expiry' => 'Bitiş süresi',
	'deletequeue-list-header-discusspage' => 'Tartışma sayfası',
	'deletequeue-case-intro' => 'Bu sayfa, spesifik bir silme durumu hakkındaki bilgileri listelemektedir.',
	'deletequeue-list-header-reason' => 'Silinme için gerekçe',
	'deletequeue-case-votes' => 'Destekler/itirazlar:',
	'deletequeue-case-title' => 'Silinme durum detayları',
	'deletequeue-case-details' => 'Temel detaylar',
	'deletequeue-case-page' => 'Sayfa:',
	'deletequeue-case-reason' => 'Gerekçe:',
	'deletequeue-case-expiry' => 'Bitiş süresi:',
	'deletequeue-case-needs-review' => 'Bu durum [[$1|inceleme]] gerektirmektedir.',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'deletequeue-list-header-page' => 'Bet',
	'deletequeue-case-page' => 'Bet:',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'deletequeue-desc' => 'Створює [[Special:DeleteQueue|побудовану на черзі систему управління вилученням]]',
	'deletequeue-action-queued' => 'Вилучення',
	'deletequeue-action' => 'Запропонувати вилучення',
	'deletequeue-action-title' => 'Запропонувати вилучення "$1"',
	'deletequeue-nom-alreadyqueued' => 'Ця сторінку вже включено у чергу на вилучення.',
	'deletequeue-speedy-title' => 'Позначити "$1" для швидкого вилучення',
	'deletequeue-delnom-reason' => 'Причина номінації:',
	'deletequeue-delnom-otherreason' => 'Інша причина',
	'deletequeue-delnom-extra' => 'Додаткова інформація:',
	'deletequeue-delnom-submit' => 'Надіслати номінацію',
	'right-speedy-nominate' => 'Номінація сторінок для швидкого вилучення',
	'deletequeue-queue-speedy' => 'Швидке вилучення',
	'deletequeue-review-delete' => 'Вилучити сторінку.',
	'deletequeue-review-reason' => 'Коментарі:',
	'deletequeue-review-newreason' => 'Нова причина:',
	'deletequeue-review-newextra' => 'Додаткова інформація:',
	'deletequeue-review-original' => 'Причина номінації',
	'deletequeue-vote-action' => 'Рекомендація:',
	'deletequeue-vote-reason' => 'Коментарі:',
	'deletequeue-vote-submit' => 'Відправити',
	'deletequeue' => 'Черга вулучення',
	'deletequeue-list-search-legend' => 'Пошук сторінок',
	'deletequeue-list-queue' => 'Черга:',
	'deletequeue-list-status' => 'Статус:',
	'deletequeue-list-search' => 'Пошук',
	'deletequeue-list-anyqueue' => '(будь-яка)',
	'deletequeue-list-votes' => 'Список голосів',
	'deletequeue-list-header-page' => 'Сторінка',
	'deletequeue-list-header-queue' => 'Черга',
	'deletequeue-list-header-discusspage' => 'Сторінка обговорення',
	'deletequeue-list-header-reason' => 'Причина вилучення',
	'deletequeue-case-details' => 'Основні подробиці',
	'deletequeue-case-page' => 'Сторінка:',
	'deletequeue-case-reason' => 'Причина:',
	'deletequeue-case-expiry' => 'Закінчується:',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'deletequeue-case-reason' => 'وجہ:',
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

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'deletequeue-desc' => 'Tạo [[Special:DeleteQueue|hệ thống hàng đợi xóa]]',
	'deletequeue-action-queued' => 'Xóa',
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
	'right-prod-review' => 'Duyệt các trang có đề xuất xóa không ai tranh luận',
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
	'deletequeue-review-success-title' => 'Duyệt xong',
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
	'deletequeue-list-status' => 'Trạng thái:',
	'deletequeue-list-search' => 'Tìm kiếm',
	'deletequeue-list-anyqueue' => '(tất cả)',
	'deletequeue-list-votes' => 'Danh sách lá phiếu',
	'deletequeue-list-votecount' => '$1 phiếu ủng hộ, $2 phiếu phản đối',
	'deletequeue-list-header-page' => 'Trang',
	'deletequeue-list-header-queue' => 'Hàng',
	'deletequeue-list-header-votes' => 'Số phiếu',
	'deletequeue-list-header-expiry' => 'Thời hạn',
	'deletequeue-list-header-discusspage' => 'Trang thảo luận',
	'deletequeue-list-header-reason' => 'Lý do xóa',
	'deletequeue-case-title' => 'Chi tiết về vụ xóa',
	'deletequeue-case-details' => 'Chi tiết cơ bản',
	'deletequeue-case-page' => 'Trang:',
	'deletequeue-case-reason' => 'Lý do:',
	'deletequeue-case-expiry' => 'Thời hạn:',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'deletequeue-action-queued' => 'Moükam',
	'deletequeue-action' => 'Mobön moükami',
	'deletequeue-action-title' => 'Mobön moükami pada: „$1“',
	'deletequeue-permissions-noedit' => 'Mutol dalön redakön padi ad fägön ad votükön moükamastadi onik.',
	'deletequeue-prod-title' => 'Mobön moükami pada: „$1“',
	'deletequeue-delnom-otherreason' => 'Kod votik',
	'deletequeue-delnom-extra' => 'Nüns pluik:',
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

/** Wu (吴语) */
$messages['wuu'] = array(
	'deletequeue-case-reason' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'deletequeue-review-delete' => 'אויסמעקן דעם בלאַט',
	'deletequeue-list-search' => 'זוכן',
	'deletequeue-list-header-expiry' => 'אויסגיין',
	'deletequeue-case-reason' => 'אורזאַך:',
	'deletequeue-case-expiry' => 'אויסגיין:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Hydra
 * @author PhiLiP
 * @author Wmr89502270
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'deletequeue-action-queued' => '删除',
	'deletequeue-action' => '建议删除',
	'deletequeue-action-title' => '建议删除 "$1"',
	'deletequeue-permissions-noedit' => '您必须能够编辑页面，使其能够影响其删除状态。',
	'deletequeue-nom-alreadyqueued' => '本页面已经被删除队列。',
	'deletequeue-speedy-title' => '商标 "$1" 为快速刪除',
	'deletequeue-prod-title' => '建议删除 "$1"',
	'deletequeue-delnom-reason' => '提名的理由：',
	'deletequeue-delnom-otherreason' => '其他原因',
	'deletequeue-delnom-extra' => '附加信息：',
	'deletequeue-delnom-submit' => '提交提名',
	'right-speedy-nominate' => '快速刪除提名页',
	'right-speedy-review' => '提名快速刪除进行审查',
	'right-prod-nominate' => '建议删除页',
	'right-prod-review' => '检讨自动当选的删除操作建议',
	'right-deletediscuss-nominate' => '开始删除讨论',
	'right-deletediscuss-review' => '关闭删除讨论',
	'right-deletequeue-vote' => '赞成或反对删除',
	'deletequeue-queue-speedy' => '快速删除',
	'deletequeue-queue-prod' => '建议的删除',
	'deletequeue-queue-deletediscuss' => '删除讨论',
	'deletequeue-page-speedy' => "此页已获提名为快速删除。
为此删除操作的理由 ''$1''。",
	'deletequeue-notqueued' => '您所选的页面删除当前不排队',
	'deletequeue-review-action' => '要执行的操作：',
	'deletequeue-review-delete' => '删除页面。',
	'deletequeue-review-change' => '删除此页上，但具有不同的理由。',
	'deletequeue-review-requeue' => '将此页转接到以下队列：',
	'deletequeue-review-dequeue' => '不采取行动，并从删除队列中删除该页面。',
	'deletequeue-review-reason' => '评论：',
	'deletequeue-review-newreason' => '新的原因：',
	'deletequeue-review-newextra' => '额外的信息：',
	'deletequeue-review-submit' => '保存审查',
	'deletequeue-review-original' => '提名的理由',
	'deletequeue-actiondisabled-notexpired' => '下列行动被禁用是因为删除提名尚未过期：',
	'deletequeue-review-badaction' => '您指定了一个无效的操作',
	'deletequeue-review-actiondenied' => '指定已禁用此页的行动',
	'deletequeue-reviewspeedy-tab' => '查看快速刪除',
	'deletequeue-reviewspeedy-title' => '为 "$1" 查看快速刪除提名',
	'deletequeue-reviewprod-tab' => '建议删除的审查',
	'deletequeue-reviewdeletediscuss-tab' => '审查删除',
	'deletequeue-review-success' => '您已成功地检讨删除此页',
	'deletequeue-review-success-title' => '完整的审查',
	'deletequeue-role-nominator' => '原提名人为删除的',
	'deletequeue-role-vote-endorse' => '代言人的删除',
	'deletequeue-role-vote-object' => '要删除的反对者',
	'deletequeue-vote-tab' => '投票删除',
	'deletequeue-vote-legend' => '要删除批注/对象',
	'deletequeue-vote-action' => '建议：',
	'deletequeue-vote-endorse' => '赞成删除。',
	'deletequeue-vote-object' => '反对删除。',
	'deletequeue-vote-reason' => '评论：',
	'deletequeue-vote-submit' => '提交',
	'deletequeue-vote-success-endorse' => '您已成功赞同此页删除。',
	'deletequeue-vote-success-object' => '您已成功地反对此页删除。',
	'deletequeue-showvotes-restrict-endorse' => '只显示赞成票',
	'deletequeue-showvotes-restrict-object' => '只显示反对票。',
	'deletequeue-showvotes-showingonly-endorse' => '显示仅背书',
	'deletequeue-showvotes-showingonly-object' => '显示只是反对',
	'deletequeue-showvotes-none' => '没有背书或删除此页的反对意见。',
	'deletequeue-showvotes-none-endorse' => '没有删除此页的背书。',
	'deletequeue-showvotes-none-object' => '没有人反对此页删除。',
	'deletequeue' => '删除队列',
	'deletequeue-list-text' => '此页显示删除系统中的所有页面。',
	'deletequeue-list-search-legend' => '搜索页',
	'deletequeue-list-queue' => '队列：',
	'deletequeue-list-status' => '状态：',
	'deletequeue-list-expired' => '显示仅需要关闭的提名。',
	'deletequeue-list-search' => '搜索',
	'deletequeue-list-anyqueue' => '（任何）',
	'deletequeue-list-votes' => '投票列表',
	'deletequeue-list-header-page' => '页面',
	'deletequeue-list-header-queue' => '队列',
	'deletequeue-list-header-expiry' => '期限',
	'deletequeue-case-page' => '页面：',
	'deletequeue-case-reason' => '原因：',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'deletequeue-action-queued' => '刪除',
	'deletequeue-action' => '建議刪除',
	'deletequeue-action-title' => '建議刪除 "$1"',
	'deletequeue-permissions-noedit' => '您必須能夠編輯頁面，使其能夠影響其刪除狀態。',
	'deletequeue-nom-alreadyqueued' => '本頁面已經被刪除隊列。',
	'deletequeue-speedy-title' => '商標 "$1" 為快速刪除',
	'deletequeue-prod-title' => '建議刪除 "$1"',
	'deletequeue-delnom-reason' => '提名的理由：',
	'deletequeue-delnom-otherreason' => '其他原因',
	'deletequeue-delnom-extra' => '附加資料：',
	'deletequeue-delnom-submit' => '提交提名',
	'right-speedy-nominate' => '快速刪除提名頁',
	'right-speedy-review' => '提名快速刪除進行審查',
	'right-prod-nominate' => '建議刪除頁',
	'right-prod-review' => '檢討自動當選的刪除操作建議',
	'right-deletediscuss-nominate' => '開始刪除討論',
	'right-deletediscuss-review' => '關閉刪除討論',
	'right-deletequeue-vote' => '贊成或反對刪除',
	'deletequeue-queue-speedy' => '快速刪除',
	'deletequeue-queue-prod' => '建議的刪除',
	'deletequeue-queue-deletediscuss' => '刪除討論',
	'deletequeue-page-speedy' => "此頁已獲提名為快速刪除。
為此刪除操作的理由 ''$1''。",
	'deletequeue-notqueued' => '您所選的頁面刪除當前不排隊',
	'deletequeue-review-action' => '要執行的操作：',
	'deletequeue-review-delete' => '刪除頁面。',
	'deletequeue-review-change' => '刪除此頁上，但具有不同的理由。',
	'deletequeue-review-requeue' => '將此頁轉接到以下隊列：',
	'deletequeue-review-dequeue' => '不採取行動，並從刪除隊列中刪除該頁面。',
	'deletequeue-review-reason' => '評論：',
	'deletequeue-review-newreason' => '新的原因：',
	'deletequeue-review-newextra' => '額外的信息：',
	'deletequeue-review-submit' => '保存審查',
	'deletequeue-review-original' => '提名的理由',
	'deletequeue-actiondisabled-notexpired' => '下列行動被禁用是因為刪除提名尚未過期：',
	'deletequeue-review-badaction' => '您指定了一個無效的操作',
	'deletequeue-review-actiondenied' => '指定已禁用此頁的行動',
	'deletequeue-reviewspeedy-tab' => '查看快速刪除',
	'deletequeue-reviewspeedy-title' => '為 "$1" 查看快速刪除提名',
	'deletequeue-reviewprod-tab' => '建議刪除的審查',
	'deletequeue-reviewdeletediscuss-tab' => '審查刪除',
	'deletequeue-review-success' => '您已成功地檢討刪除此頁',
	'deletequeue-review-success-title' => '完整的審查',
	'deletequeue-role-nominator' => '原提名人為刪除的',
	'deletequeue-role-vote-endorse' => '代言人的刪除',
	'deletequeue-role-vote-object' => '要刪除的反對者',
	'deletequeue-vote-tab' => '投票刪除',
	'deletequeue-vote-legend' => '要刪除批註/對象',
	'deletequeue-vote-action' => '建議：',
	'deletequeue-vote-endorse' => '贊成刪除。',
	'deletequeue-vote-object' => '反對刪除。',
	'deletequeue-vote-reason' => '評論：',
	'deletequeue-vote-submit' => '提交',
	'deletequeue-vote-success-endorse' => '您已成功贊同此頁刪除。',
	'deletequeue-vote-success-object' => '您已成功地反對此頁刪除。',
	'deletequeue-showvotes-restrict-endorse' => '只顯示贊成票',
	'deletequeue-showvotes-restrict-object' => '只顯示反對票',
	'deletequeue-showvotes-showingonly-endorse' => '顯示僅背書',
	'deletequeue-showvotes-showingonly-object' => '顯示只是反對',
	'deletequeue-showvotes-none' => '沒有背書或刪除此頁的反對意見。',
	'deletequeue-showvotes-none-endorse' => '沒有刪除此頁的背書。',
	'deletequeue-showvotes-none-object' => '沒有人反對此頁刪除。',
	'deletequeue' => '刪除隊列',
	'deletequeue-list-text' => '此頁顯示刪除系統中的所有頁面。',
	'deletequeue-list-search-legend' => '搜索頁',
	'deletequeue-list-queue' => '隊列：',
	'deletequeue-list-status' => '狀態：',
	'deletequeue-list-expired' => '顯示僅需要關閉的提名。',
	'deletequeue-list-search' => '搜尋',
	'deletequeue-list-anyqueue' => '（任何）',
	'deletequeue-list-votes' => '投票清單',
	'deletequeue-list-header-page' => '頁面',
	'deletequeue-list-header-queue' => '隊列',
	'deletequeue-list-header-expiry' => '期限',
	'deletequeue-case-page' => '頁面：',
	'deletequeue-case-reason' => '原因：',
);

