<?php
/**
 * Internationalisation file for FlaggedRevs extension, section RevisionReview
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English (en)
 * @author Purodha
 * @author Raimond Spekking
 * @author Siebrand
 */

$messages['en'] = array(
	'revisionreview'               => 'Review revisions',
	'revreview-failed'             => "'''Unable to review this revision.'''",
	'revreview-submission-invalid' => "The submission was incomplete or otherwise invalid.",

	'review_page_invalid'      => 'The target page title is invalid.',
	'review_page_notexists'    => 'The target page does not exist.',
	'review_page_unreviewable' => 'The target page is not reviewable.',
	'review_no_oldid'          => 'No revision ID specified.',
	'review_bad_oldid'         => 'The target revision does not exist.',
	'review_conflict_oldid'    => 'Someone already accepted or unaccepted this revision while you were viewing it.',
	'review_not_flagged'       => 'The target revision is not currently marked as reviewed.',
	'review_too_low'           => 'Revision cannot be reviewed with some fields left "inadequate".',
	'review_bad_key'           => 'Invalid inclusion parameter key.',
	'review_bad_tags'          => 'Some of the specified tag values are invalid.',
	'review_denied'            => 'Permission denied.',
	'review_param_missing'     => 'A parameter is missing or invalid.',
	'review_cannot_undo'       => 'Cannot undo these changes because further pending edits changed the same areas.',
	'review_cannot_reject'     => 'Cannot reject these changes because someone already accepted some (or all) of the edits.',
	'review_reject_excessive'  => 'Cannot reject this many edits at once.',
	'review_reject_nulledits'  => 'Cannot reject these changes because all the revisions are null edits.',

	'revreview-check-flag-p'       => 'Accept this version (includes $1 pending {{PLURAL:$1|change|changes}})',
	'revreview-check-flag-p-title' => 'Accept the result of the pending changes and the changes you made here. Use this only if you have already seen the entire pending changes diff.',
	'revreview-check-flag-u'       => 'Accept this unreviewed page',
	'revreview-check-flag-u-title' => 'Accept this version of the page. Only use this if you have already seen the entire page.',
	'revreview-check-flag-y'       => 'Accept my changes',
	'revreview-check-flag-y-title' => 'Accept all the changes that you have made here.',

	'revreview-flag'               => 'Review this revision',
	'revreview-reflag'             => 'Re-review this revision',
	'revreview-invalid'            => '\'\'\'Invalid target:\'\'\' no [[{{MediaWiki:Validationpage}}|reviewed]] revision corresponds to the given ID.',
	'revreview-log'                => 'Comment:',
	'revreview-main'               => 'You must select a particular revision of a content page in order to review.

See the [[Special:Unreviewedpages|list of unreviewed pages]].',
	'revreview-stable1'            => 'You may want to view [{{fullurl:$1|stableid=$2}} this flagged version] and see if it is now the [{{fullurl:$1|stable=1}} stable version] of this page.',
	'revreview-stable2'            => 'You may want to view the [{{fullurl:$1|stable=1}} stable version] of this page.',
	'revreview-submit'             => 'Submit',
	'revreview-submitting'         => 'Submitting...',
	'revreview-submit-review'      => 'Accept revision',
	'revreview-submit-unreview'    => 'Unaccept revision',
	'revreview-submit-reject'      => 'Reject changes',
	'revreview-submit-reviewed'    => 'Done. Accepted!',
	'revreview-submit-unreviewed'  => 'Done. Unaccepted!',
	'revreview-successful'         => '\'\'\'Revision of [[:$1|$1]] successfully flagged. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} view reviewed versions])\'\'\'',
	'revreview-successful2'        => '\'\'\'Revision of [[:$1|$1]] successfully unflagged.\'\'\'',
	'revreview-poss-conflict-p'    => '\'\'\'Warning: [[User:$1|$1]] started reviewing this page on $2 at $3.\'\'\'',
	'revreview-poss-conflict-c'    => '\'\'\'Warning: [[User:$1|$1]] started reviewing these changes on $2 at $3.\'\'\'',
	'revreview-adv-reviewing-p'    => 'Notice: Other reviewers can see that you are reviewing this page.',
	'revreview-adv-reviewing-c'    => 'Notice: Other reviewers can see that you are reviewing these changes.',
	'revreview-sadv-reviewing-p'   => 'You can $1 yourself as reviewing this page to other users.',
	'revreview-sadv-reviewing-c'   => 'You can $1 yourself as reviewing these changes to other users.',
	'revreview-adv-start-link'     => 'advertise',
	'revreview-adv-stop-link' 	   => 'de-advertise',
	'revreview-toolow'             => '\'\'\'You must rate each of the attributes higher than "inadequate" in order for a revision to be considered reviewed.\'\'\'

To remove the review status of a revision, click "unaccept".

Please hit the "back" button in your browser and try again.',
	'revreview-update'             => '\'\'\'Please [[{{MediaWiki:Validationpage}}|review]] any pending changes \'\'(shown below)\'\' made since the stable version.\'\'\'',
	'revreview-update-edited'      => '<span class="flaggedrevs_important">Your changes are not yet in the stable version.</span>

Please review all the changes shown below to make your edits appear in the stable version.',
	'revreview-update-edited-prev'  => '<span class="flaggedrevs_important">Your changes are not yet in the stable version. There are previous changes pending review.</span>

Please review all the changes shown below to make your edits appear in the stable version.',
	'revreview-update-includes'    => 'Templates/files updated (unreviewed pages in bold):',

	'revreview-reject-text-list'   => 'By completing this action you will be \'\'\'rejecting\'\'\' the source text changes from the following {{PLURAL:$1|revision|revisions}} of [[:$2|$2]]:',
	'revreview-reject-text-revto'  => 'This will revert the page back to the [{{fullurl:$1|oldid=$2}} version as of $3].',
	'revreview-reject-summary'     => 'Summary:',
	'revreview-reject-confirm'     => 'Reject these changes',
	'revreview-reject-cancel'      => 'Cancel',
	'revreview-reject-summary-cur' => 'Rejected the last {{PLURAL:$1|text change|$1 text changes}} (by $2) and restored revision $3 by $4',
	'revreview-reject-summary-old' => 'Rejected the first {{PLURAL:$1|text change|$1 text changes}} (by $2) that followed revision $3 by $4',
	'revreview-reject-summary-cur-short' => 'Rejected the last {{PLURAL:$1|text change|$1 text changes}} and restored revision $2 by $3',
	'revreview-reject-summary-old-short' => 'Rejected the first {{PLURAL:$1|text change|$1 text changes}} that followed revision $2 by $3',

	'revreview-tt-flag'            => 'Accept this revision by marking it as "checked"',
	'revreview-tt-unflag'		   => 'Unaccept this revision by marking it as "unchecked"',
	'revreview-tt-reject'		   => 'Reject these source text changes by reverting them',
);

/** Message documentation (Message documentation)
 * @author Aaron Schulz
 * @author Amire80
 * @author Bennylin
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Huji
 * @author IAlex
 * @author Jon Harald Søby
 * @author Lloffiwr
 * @author Raymond
 * @author SPQRobin
 * @author Siebrand
 * @author Umherirrender
 * @author Yekrats
 */
$messages['qqq'] = array(
	'revisionreview' => '{{Flagged Revs}}
Name of the Special:RevisionReview page.',
	'revreview-failed' => '{{Flagged Revs}}
Used on Special:RevisionReview.',
	'revreview-submission-invalid' => '{{Flagged Revs}}
Used on Special:RevisionReview.',
	'review_page_invalid' => '{{Flagged Revs}}
Used when reviewing a revision.',
	'review_page_notexists' => '{{Flagged Revs}}
Used when reviewing a revision.',
	'review_page_unreviewable' => '{{Flagged Revs}}
Used when reviewing a revision.',
	'review_no_oldid' => '{{Flagged Revs}}
Used when reviewing a revision.',
	'review_bad_oldid' => '{{Flagged Revs}}
Used when reviewing a revision.',
	'review_conflict_oldid' => '{{Flagged Revs}}
Used when reviewing a revision where someone else already accepted or removed acceptance status from that revision.',
	'review_not_flagged' => '{{Flagged Revs}}
Used when removing acceptance status from a revision were it was already removed (or was never there).',
	'review_too_low' => '{{Flagged Revs}}
Used when reviewing a revision.',
	'review_bad_key' => '{{Flagged Revs}}
Used when reviewing a revision.
When you review, you specify the template/file versions to use. The key given by the user must match a special hash salted with those parameters. This makes it so users can only use the template/file versions as shown on the form they submitted on, rather than sending their own arbitrary values.',
	'review_bad_tags' => '{{Flagged Revs}}
Used when reviewing a revision.
Error message given if tag values are missing or out of range.',
	'review_denied' => '{{Flagged Revs}}
{{Identical|Permission denied}}
Used when reviewing a revision.',
	'review_param_missing' => '{{Flagged Revs}}
Used when reviewing a revision.
A mostly generic error message.',
	'review_cannot_undo' => '{{Flagged Revs}}
Used when edit conflict occurs with the "reject" feature',
	'review_cannot_reject' => '{{Flagged Revs}}
Used when using the "reject" feature on a (set) of revisions where someone else already accepted some of them.',
	'review_reject_excessive' => '{{Flagged Revs}}
Used when using the "reject" feature.',
	'review_reject_nulledits' => '{{Flagged Revs}}
Used when using the "reject" feature.',
	'revreview-check-flag-p' => '{{Flagged Revs}}
Label of a checkbox shown on the edit form of a page that already has pending changes.
* $1 The number of pending changes.',
	'revreview-check-flag-p-title' => '{{Flagged Revs}}
Title of a checkbox shown on the edit form of a page that already has pending changes.',
	'revreview-check-flag-u' => '{{Flagged Revs}}
This is a label for the  checkbox that appears under the edit box next to "This is a minor edit" and "Watch this page". This shown on pages with no stable version.',
	'revreview-check-flag-u-title' => '{{Flagged Revs}}
Title of a checkbox on the edit form that shows on pages with no stable version.',
	'revreview-check-flag-y' => '{{Flagged Revs}}
Label of a checkbox that shows on the edit form of pages with no stable version.',
	'revreview-check-flag-y-title' => '{{Flagged Revs}}
{{Gender}}',
	'revreview-flag' => '{{Flagged Revs-small}}
* Title of the review box shown below a page (when you have the permission to review pages). This is used for un-accepted revisions.',
	'revreview-reflag' => '{{Flagged Revs-small}}
* Title of the review box shown below a page (when you have the permission to review pages). This is used for already accepted revisions.',
	'revreview-invalid' => '{{Flagged Revs}}
Used when viewing a page with a bad ?stableid=x parameter (similar to ?oldid= parameter)',
	'revreview-log' => '{{Flagged Revs}}
{{Identical|Comment}}
Shown on review form.',
	'revreview-main' => '{{Flagged Revs}}
{{Identical|Content page}}
Shown on Special:RevisionReview.',
	'revreview-stable1' => '{{Flagged Revs}}
Shown after accepting a revision of a page.
* $1 Name of the page
* $2 Number, revision ID just reviewed',
	'revreview-stable2' => '{{Flagged Revs}}
Shown after de-accepting a revision of a page.',
	'revreview-submit' => '{{Flagged Revs-small}}
The text on the submit button in the form used to review pages.

{{Identical|Submit}}',
	'revreview-submitting' => '{{flaggedrevs}}
{{identical|submitting}}',
	'revreview-submit-review' => '{{Flagged Revs}}
Shown on the form to review pages.',
	'revreview-submit-unreview' => '{{Flagged Revs}}
Shown on the form to review pages.',
	'revreview-submit-reject' => '{{Flagged Revs}}
Shown on the form to review pages, but only on diff pages. This is the text of a button that acts similar to undo.',
	'revreview-submit-reviewed' => '{{Flagged Revs}}
Shown on the form to review pages.',
	'revreview-submit-unreviewed' => '{{Flagged Revs}}
Shown on the form to review pages.',
	'revreview-successful' => '{{Flagged Revs-small}}
Shown when a reviewer/editor has marked a revision as stable/checked/... See also {{msg|revreview-successful2|pl=yes}}.
* $1 The page name
* $2 The page name (url escaped)',
	'revreview-successful2' => '{{Flagged Revs-small}}
Shown when a reviewer/editor has marked a stable/checked/... revision as unstable/unchecked/... After that, it can normally be reviewed again. See also {{msg|revreview-successful|pl=yes}}.
* $1 The page name',
	'revreview-poss-conflict-p' => '{{Flagged Revs}}
Shown on the form to review pages. Not shown on diffs.
Parameters:
* $1 is a username
* $2 is a date
* $3 is a time',
	'revreview-poss-conflict-c' => '{{Flagged Revs}}
Shown on the form to review pages. Only shown on diffs.
Parameters:
* $1 is a username
* $2 is a date
* $3 is a time',
	'revreview-adv-reviewing-p' => '{{Flagged Revs}}
Shown on the form to review pages. Indicates that other reviewers will get a notice that this user is already reviewing this revision of the page. Not shown on diffs.

This message is followed by {{msg-mw|revreview-adv-stop-link}} as link in parenthesis.',
	'revreview-adv-reviewing-c' => '{{Flagged Revs}}
Shown on the form to review pages. Indicates that other reviewers will get a notice that this user is already reviewing this revision of the page. Shown on diffs.

This message is followed by {{msg-mw|revreview-adv-stop-link}} as link in parenthesis.',
	'revreview-sadv-reviewing-p' => '{{Flagged Revs}}
Shown on the form to review pages. Not shown on diffs.
$1 is {{msg-mw|revreview-adv-start-link}} as a link. It displays as "advertise".',
	'revreview-sadv-reviewing-c' => '{{Flagged Revs}}
Shown on the form to review pages on diffs.
$1 is {{msg-mw|revreview-adv-start-link}} as a link. It displays as "advertise".',
	'revreview-adv-start-link' => '{{Flagged Revs}}
Shown on the form to review pages. This is the text of a link.
Used as parameter in {{msg-mw|Revreview-sadv-reviewing-c}} or {{msg-mw|Revreview-sadv-reviewing-p}}',
	'revreview-adv-stop-link' => '{{Flagged Revs}}
Shown on the form to review pages. This is the text of a link, which is enclosed in parenthesis itself.
It stands behind {{msg-mw|Revreview-adv-reviewing-c}} or {{msg-mw|Revreview-adv-reviewing-p}}.',
	'revreview-toolow' => '{{Flagged Revs-small}}
A kind of error shown when trying to review a revision with some settings on "unapproved".',
	'revreview-update' => '{{Flagged Revs}}
Shown on the form to review pages, on diffs.',
	'revreview-update-edited' => '{{Flagged Revs}}
Shown on the form to review pages, on diffs.',
	'revreview-update-edited-prev' => '{{Flagged Revs}}
Shown on the form to review pages, on diffs.
This message is shown after a user saves a version after another user made changes that were not reviewed yet.',
	'revreview-update-includes' => '{{Flagged Revs}}
Shown on the form to review pages, on diffs.',
	'revreview-reject-text-list' => '{{Flagged Revs}}
Shown on the change reject form (after the review form).
* $1 Number of revisions
* $2 The page name',
	'revreview-reject-text-revto' => '{{Flagged Revs}}
Shown on the reject form (user clicked "reject" on review form).
* $1 Page name
* $2 Number, revisions ID that would be restored
* $3 Timestamp of that revision',
	'revreview-reject-summary' => '{{Flagged Revs}}
{{Identical|Summary}}
Shown on the reject form.',
	'revreview-reject-confirm' => '{{Flagged Revs}}
Shown on the reject form. Confirmation button.',
	'revreview-reject-cancel' => '{{Flagged Revs}}
{{Identical|Cancel}}
Shown on the reject form.',
	'revreview-reject-summary-cur' => '{{Flagged Revs-small}}
Default summary shown when rejecting pending changes, and they are the latest revisions to a page
* $1 is the number of rejected revisions
* $2 is the list of (one or more) users who are being rejected
* $3 is the revision ID of the revision being reverted to',
	'revreview-reject-summary-old' => '{{Flagged Revs-small}}
Default summary shown when rejecting pending changes.
* $1 is the number of rejected revisions
* $2 is the list of (one or more) users who are being rejected
* $3 is the revision ID of the revision before the first pending change',
	'revreview-reject-summary-cur-short' => '{{Flagged Revs-small}}
Default summary shown when rejecting pending changes, and they are the latest revisions to a page
* $1 is the number of rejected revisions
* $2 is the revision ID of the revision being reverted to',
	'revreview-reject-summary-old-short' => '{{Flagged Revs-small}}
Default summary shown when rejecting pending changes.
* $1 is the number of rejected revisions
* $3 is the revision ID of the revision before the first pending change

Alternative sentences which mean the same as the above message are:
* Rejected the next {{PLURAL:$1|change|$1 changes}} that followed revision $2 by $3
* Rejected the {{PLURAL:$1|change|$1 changes}} that immediately followed revision $2 by $3',
	'revreview-tt-flag' => '{{Flagged Revs}}
Title attribute of the accept button on the review form.',
	'revreview-tt-unflag' => '{{Flagged Revs}}
Title attribute of the un-accept button on the review form.',
	'revreview-tt-reject' => '{{Flagged Revs}}
Title attribute of the reject button on the review form.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'revisionreview' => 'Review hersienings',
	'revreview-submission-invalid' => 'Die voorlegging was onvolledig of andersins ongeldig.',
	'review_page_invalid' => 'Die titel van die artikel teiken is ongeldig.',
	'review_page_notexists' => 'Die teiken bladsy bestaan ​​nie.',
	'review_page_unreviewable' => 'Die doel is nie hersien nie.',
	'review_no_oldid' => 'Geen hersiening ID gespesifiseer.',
	'review_bad_oldid' => 'Die doel weergawe bestaan ​​nie.',
	'review_conflict_oldid' => 'Iemand het reeds aanvaar of unaccepted hierdie hersiening terwyl jy lees dit.',
	'review_not_flagged' => 'Die doel weergawe is tans nie gemerk soos hersien.',
	'review_denied' => 'Geen toegang.',
	'review_param_missing' => "'N parameter ontbreek of is ongeldig.",
	'review_cannot_undo' => 'Kan nie ongedaan maak hierdie veranderinge omdat verder hangende wysigings dieselfde gebiede verander nie.',
	'review_reject_excessive' => "Kan nie verwerp hierdie baie wysigings in 'n keer.",
	'review_reject_nulledits' => 'Kan nie verwerp hierdie veranderinge, omdat al die hersienings is null wysigings.',
	'revreview-check-flag-p-title' => 'Aanvaar die gevolg van die hangende veranderinge en die veranderinge wat jy hier gemaak. Gebruik dit net as jy reeds gesien hoe die hele hangende veranderinge verskil.',
	'revreview-check-flag-u' => 'Aanvaar hierdie beoordeelde bladsy',
	'revreview-check-flag-u-title' => 'Aanvaar hierdie weergawe van die bladsy. Slegs gebruik as jy reeds die hele bladsy gesien.',
	'revreview-check-flag-y-title' => 'Aanvaar al die veranderinge wat jy hier gemaak het.',
	'revreview-flag' => 'Hersien hierdie revisie',
	'revreview-reflag' => 'Re-hersiening van hierdie hersiening',
	'revreview-log' => 'Opmerking:',
	'revreview-submit' => 'Dien in',
	'revreview-submitting' => 'Besig om in te stuur...',
	'revreview-submit-review' => 'Aanvaar hersiening',
	'revreview-submit-unreview' => 'onaanvaardbare hersiening',
	'revreview-submit-reject' => 'Verwerp veranderinge',
	'revreview-submit-reviewed' => 'Gedoen. Is aanvaar!',
	'revreview-submit-unreviewed' => 'Gedoen. Nie aanvaar nie!',
	'revreview-adv-start-link' => 'adverteer',
	'revreview-update-includes' => 'Sommige sjablone/lêers is bygewerk:',
	'revreview-reject-summary' => 'Opsomming:',
	'revreview-reject-confirm' => 'Keur hierdie veranderinge af',
	'revreview-reject-cancel' => 'Kanselleer',
	'revreview-tt-reject' => 'Verwerp hierdie bron teks verander deur reverting hulle',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'revreview-submit' => 'Submit',
	'revreview-submitting' => 'Dorëzimi ...',
	'revreview-submit-review' => 'Miratoj',
	'revreview-submit-unreview' => 'De-miratojë',
	'revreview-submit-reviewed' => 'Done. Aprovuar!',
	'revreview-submit-unreviewed' => 'Done. De-aprovuar!',
	'revreview-successful' => "'''Rishikimi i [[:$1|$1]] flamur me sukses. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} parë shqyrtuar versionet ])'''",
	'revreview-successful2' => "'''Rishikimi i [[:$1|$1]] paflamur me sukses.'''",
	'revreview-toolow' => '\'\'\'Ju duhet të kursit të secilit prej atributeve më të larta se "paaprovuar" në mënyrë që për një rishikim të merren parasysh rishikohet.\'\'\' Për të hequr statusin shqyrtimin e rishikimit, i vendosur të gjitha fushat për të "paaprovuar". Ju lutem goditi "mbrapa "butonin e shfletuesit tuaj dhe provoni përsëri.',
	'revreview-update' => "Ju lutem [[{{MediaWiki:Validationpage}}|rishikim]] ndonjë ndryshim në pritje''(treguar më poshtë),''e bëra në versionin e botuar.",
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Ndryshimet juaja ende nuk janë botuar.</span> Ka redaktimet e mëparshme në pritje të shqyrtimit. Për të publikojë ndryshimet tuaj, ju lutemi shqyrtimin e të gjitha ndryshimet e treguar më poshtë.',
	'revreview-update-includes' => 'Disa templates / Fotografi të ishin më të azhornuara:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'revreview-log' => 'ማጠቃለያ፦',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'revisionreview' => 'Revisar versions',
	'revreview-flag' => 'Revisar ista versión',
	'revreview-invalid' => "'''Destín no conforme:''' no bi ha garra [[{{MediaWiki:Validationpage}}|versión revisata]] que corresponda con ixe ID.",
	'revreview-log' => 'Comentario:',
	'revreview-main' => "Ha de trigar una versión particular d'una pachina de conteniu ta poder revisar-la.

Mire-se a [[Special:Unreviewedpages|lista de pachinas sin revisar]].",
	'revreview-stable1' => "Si quiere puede veyer [{{fullurl:$1|stableid=$2}} ista versión marcada] ta mirar si ye agora a [{{fullurl:$1|stable=1}} versión acceptata] d'ista pachina.",
	'revreview-stable2' => "Talment quiera veyer a [{{fullurl:$1|stable=1}} versión acceptata] d'ista pachina.",
	'revreview-submit' => 'Ninviar',
	'revreview-successful' => "'''S'ha sinyalato a versión trigata de [[:$1|$1]]. ([{{fullurl:{{#Special:Stableversions}}|page=$2}} amostrar todas as versions sinyalatas])'''",
	'revreview-successful2' => "'''S'ha sacato o sinyal d'as versions trigatas de [[:$1|$1]]'''",
	'revreview-toolow' => "'''Ha d'avaluar totz os atributos con una calificación mayor que \"inadequato\" ta que una versión se considere revisata.''' 

Ta sacar o status de revisato d'una versión, faiga click en \"no acceptar\". 

Por favor, prete o botón de \"enta zaga\" d'o suyo navegador y torne a intentar-lo.",
	'revreview-update' => "Por favor [[{{MediaWiki:Validationpage}}|revise]] os cambios pendients ''(que s'amuestran en o cobaixo)'' feitos sobre a versión acceptata.",
	'revreview-update-includes' => "S'han esviellato bellas plantillas u fichers:",
);

/** Arabic (العربية)
 * @author ;Hiba;1
 * @author Abanima
 * @author Ciphers
 * @author Meno25
 * @author OsamaK
 * @author زكريا
 */
$messages['ar'] = array(
	'revisionreview' => 'مراجعة المراجعات',
	'revreview-failed' => "'''تعذرت مراجعة هذه المراجعة.'''",
	'revreview-submission-invalid' => 'لم يتم الإرسال أو بالتالي لم يقبل',
	'review_page_invalid' => 'عنوان الصفحة الهدف غير صالح.',
	'review_page_notexists' => 'الصفحة الهدف غير موجودة.',
	'review_page_unreviewable' => 'الصفحة الهدف غير قابلة للمراجعة.',
	'review_no_oldid' => 'لم يتم تحديد معرف المراجعة.',
	'review_bad_oldid' => 'المراجعة المستهدفة غير موجودة.',
	'review_conflict_oldid' => 'شخص ما قبل أو رفض هذه النسخة بينما كنت تقوم بعرضها.',
	'review_not_flagged' => 'لم يتم التعليم على المراجعة الهدف على أنها مراجعة.',
	'review_too_low' => 'لا يمكن مراجعة التعديلات بوجود بعض الحقول "غير كافية".',
	'review_bad_key' => 'مفتاح مؤشر إدراج غير صالح.',
	'review_bad_tags' => 'بعض قيم الوسوم المحددة غير صالحة.',
	'review_denied' => 'تم رفض الإذن.',
	'review_param_missing' => 'المؤشر مفقود أو غير صالح.',
	'review_cannot_undo' => 'لا يمكن الرجوع عن هذه التغييرات بسب وجود تغييرات في الانتظار على ذات المقاطع.',
	'review_cannot_reject' => 'لا يمكن رفض هذه التعديلات بسبب أن أحدهم قبل بعض (أو جميع) هذه التعديلات.',
	'review_reject_excessive' => 'لا يمكن رفض جميع هذه التعديلات في وقت واحد.',
	'review_reject_nulledits' => 'لا يمكن رفض هذه التغييرات لأن كل مراجعاتك ليست فيها أي تعديل.',
	'revreview-check-flag-p' => 'اقبل هذه النسخة (تتضمن {{PLURAL:$1||تعديلا واحدا معلقا|تعديلان معلقان|$1 تعديلات معلقة|$1 تعديل معلق|$1 تعديلا معلقا}})',
	'revreview-check-flag-p-title' => 'قبول كل التغييرات المعلقة حاليا بالإضافة إلى التحرير الخاص بك. استخدم هذا فقط إذا كنت قد سبق و رأيت فرق التغييرات المعلقة.',
	'revreview-check-flag-u' => 'اقبل هذه الصفحة غير المراجعة',
	'revreview-check-flag-u-title' => 'قبول هذه النسخة من الصفحة. يستخدم فقط إن كنت قد استعرضت كامل الصفحة.',
	'revreview-check-flag-y' => 'قبول هذه التغييرات',
	'revreview-check-flag-y-title' => 'قبول كل التغييرات التي قمت بها في هذا التعديل',
	'revreview-flag' => 'راجع هذه المراجعة',
	'revreview-reflag' => 'أعد مراجعة هذه المراجعة',
	'revreview-invalid' => "'''هدف غير صحيح:''' لا مراجعة [[{{MediaWiki:Validationpage}}|مراجعة]] تتطابق مع الرقم المعطى.",
	'revreview-log' => 'تعليق:',
	'revreview-main' => 'يجب أن تختار مراجعة معينة من صفحة محتوى لمراجعتها.

انظر [[Special:Unreviewedpages|قائمة الصفحات غير المراجعة]].',
	'revreview-stable1' => 'ربما ترغب في رؤية [{{fullurl:$1|stableid=$2}} هذه النسخة المعلمة] لترى ما إذا كانت [{{fullurl:$1|stable=1}} النسخة المنشورة] لهذه الصفحة.',
	'revreview-stable2' => 'قد ترغب في مشاهدة [{{fullurl:$1|stable=1}} النسخة المستقرة] لهذه الصفحة.',
	'revreview-submit' => 'أرسل',
	'revreview-submitting' => 'يرسل...',
	'revreview-submit-review' => 'اقبل المراجعة',
	'revreview-submit-unreview' => 'لا تقبل المراجعة',
	'revreview-submit-reject' => 'ارفض التغييرات',
	'revreview-submit-reviewed' => 'تم. قبلت!',
	'revreview-submit-unreviewed' => 'تم. لم يتم القبول!',
	'revreview-successful' => "'''عُلّمت مراجعة [[:$1|$1]] بنجاح. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} اعرض النسخ المستقرة])'''",
	'revreview-successful2' => "'''مراجعة [[:$1|$1]] تمت إزالة علمها بنجاح.'''",
	'revreview-poss-conflict-p' => "'''تحذير: بدأ [[User:$1|$1]] مراجعة هذه الصفحة في $2 عند $3.'''",
	'revreview-poss-conflict-c' => "'''تحذير: بدأ [[User:$1|$1]] مراجعة هذه النغييرات في $2 عند $3.'''",
	'revreview-adv-reviewing-p' => 'تبصرة: سيكون المراجعون الآخرون على علم بمراجعتك لهذه الصفحة.',
	'revreview-adv-reviewing-c' => 'تبصرة: سيكون المراجعون الآخرون على علم بمراجعتك لهذه التعديلات.',
	'revreview-sadv-reviewing-p' => '$1 للمستخدمين الآخرين مراجعتك لهذه الصفحة.',
	'revreview-sadv-reviewing-c' => '$1 للمستخدمين الآخرين مراجعتك لهذه التعديلات.',
	'revreview-adv-start-link' => 'أعلن',
	'revreview-adv-stop-link' => 'لا تعلن',
	'revreview-toolow' => '\'\'\'يجب عليك تقييم كل من المحددات بالأسفل أعلى من "غير مقبولة" لكي تعتبر المراجعة مراجعة.\'\'\'

لسحب حالة المراجعة لمراجعة، اضغط "غير موافق".

من فضلك اضغط زر "رجوع" في متصفحك وحاول مجددا.',
	'revreview-update' => "'''من فضلك [[{{MediaWiki:Validationpage}}|راجع]] أية تغييرات موقفة ''(معروضة بالأسفل)'' أجريت منذ النسخة المستقرة.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">تغييراتك ليست إلى الآن في النسخة المستقرة.</span>

من فضلك راجع كل الغييرات المعروضة أدناه لتظهر تعديلاتك في النسخة المستقرة.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important"> لم تضف تعديلات بعد إلى النسخة المستقرة. هناك تعديلات مسبقة تنتظر المراجعة. </span>
رجاء راجع جميع التغييرات الظاهرة أدناه من أجل أن تظهر تعديلاتك في النسخة المستقرة.',
	'revreview-update-includes' => 'تم تحديث بعض القوالب/الملفات (الصفحات غير المراجعة مكتوبة بالعريض):',
	'revreview-reject-text-list' => "بإتمام هذا الفعل، سوف يتم '''رفض''' التعديلات النصية على المصدر من {{PLURAL:$1||المراجعة التالية|المراجعتين التاليتين|المراجعات التالية}} ل‍[[:$2|$2]]:",
	'revreview-reject-text-revto' => 'هذا سوف يعيد الصفحة إلى [{{fullurl:$1|oldid=$2}} النسخة $3]',
	'revreview-reject-summary' => 'ملخص التعديل:',
	'revreview-reject-confirm' => 'ارفض هذه التعديلات',
	'revreview-reject-cancel' => 'ألغِ',
	'revreview-reject-summary-cur' => 'رفض {{PLURAL:$1||التغيير النصي الأخير|التغييرين النصيين الأخيرين|ال‍$1 تغييرات نصية الأخيرة|ال‍$1 تغييرا نصيا أخيرا|ال‍$1 تغيير نصي أخير}} (ل‍$2) واستعادة المراجعة $3 ل‍$4',
	'revreview-reject-summary-old' => 'رفض أول {{PLURAL:$1||تغيير نصي|تغييرين نصيين|$1 تغييرات نصية|$1 تغييرا نصيا|$1 تغيير نصي}} (ل‍$2) {{PLURAL:$1||تلى|تليا|تلت|تلى}} المراجعة $3 ل‍$4',
	'revreview-reject-summary-cur-short' => 'رفض {{PLURAL:$1||التغيير النصي الأخير|التغييرين النصيين الأخيرين|ال‍$1 تغييرات نصية الأخيرة|ال‍$1 تغييرا نصيا أخيرا|ال‍$1 تغيير نصي أخير}} واستعادة المراجعة $2 ل‍$3',
	'revreview-reject-summary-old-short' => 'رفض أول {{PLURAL:$1||تغيير نصي تلا|تغييرين نصيين تليا|$1 تغييرات نصية تلت|$1 تغييرا نصيا تلا|$1 تغيير نصي تلا}} المراجعة $2 ل‍$3',
	'revreview-tt-flag' => 'اقبل هذه المراجعة بتعليمها "مفحوصة"',
	'revreview-tt-unflag' => 'لا تقبل هذه المراجعة بتعليمها "مفحوصة"',
	'revreview-tt-reject' => 'ارفض التغييرات النصية على المصدر باسترجاعها',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'revreview-submit' => 'ܫܕܪ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Dudi
 * @author Meno25
 */
$messages['arz'] = array(
	'revisionreview' => 'مراجعه المراجعات',
	'revreview-failed' => "'''غير قادر على مراجعه هذه المراجعه.''' الإرسال غير مكتمل أو غير هذا غير صحيح.",
	'revreview-flag' => 'راجع هذه المراجعة',
	'revreview-reflag' => 'راجع تانى المراجعه دى',
	'revreview-invalid' => "'''هدف غير صحيح:''' لا مراجعه [[{{MediaWiki:Validationpage}}|مراجعة]] تتطابق مع الرقم المعطى.",
	'revreview-log' => 'تعليق:',
	'revreview-main' => 'يجب أن تختار مراجعه معينه من صفحه محتوى لمراجعتها.

انظر [[Special:Unreviewedpages|قائمه الصفحات غير المراجعة]].',
	'revreview-stable1' => 'ممكن تكون عاوز تشوف [{{fullurl:$1|stableid=$2}} النسخه المتعلّم عليها دى] و تشوف لو بقت دلوقتى [{{fullurl:$1|stable=1}} النسخه المنشوره] بتاعة الصفحه دى.',
	'revreview-stable2' => 'ممكن تكون عاوز تشوف [{{fullurl:$1|stable=1}} النسخه المنشوره] بتاعة الصفحه دى (لو لسه فيه واحده).',
	'revreview-submit' => 'أرسل',
	'revreview-submitting' => 'جارى التنفيذ...',
	'revreview-submit-review' => 'علم كمراجعة',
	'revreview-submit-unreview' => 'علم كغير مراجعة',
	'revreview-successful' => "'''عُلّمت مراجعه [[:$1|$1]] بنجاح. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} اعرض النسخ المستقرة])'''",
	'revreview-successful2' => "'''مراجعه [[:$1|$1]] تمت إزاله علمها بنجاح.'''",
	'revreview-toolow' => '\'\'\'لازم تقيّم كل المحددات اللى تحت أكتر من "مش متأكد عليها" علشان المراجعه تعتبر متراجعه.\'\'\'
علشان يتنفض لمراجعه, اعمل عليهم كلهم بـ "مش متأكد عليها".

لو سمحت دوس على زرار "back" فى البراوزر بتاعتك و جرّب تانى.',
	'revreview-update' => "لو سمحت [[{{MediaWiki:Validationpage}}|راجع]] اى تغييرات ''(باينه تحت)'' معموله من وقت النسخه المنشوره ما [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} اتأكد عليها].<br />
'''شوية قوالب/فايلات اتجددت:'''",
	'revreview-update-includes' => 'بعض القوالب/الملفات تم تحديثها:',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'revisionreview' => 'Revisar revisiones',
	'revreview-failed' => "'''Nun se pudo revisar esta revisión.'''",
	'revreview-submission-invalid' => "L'unviu taba incompletu o era inválidu",
	'review_page_invalid' => 'El títulu de la páxina de destín nun ye válidu.',
	'review_page_notexists' => 'La páxina de destín nun esiste.',
	'review_page_unreviewable' => 'Nun se puede revisar la páxina de destín.',
	'revreview-flag' => 'Revisar esta revisión',
	'revreview-log' => 'Comentariu:',
	'revreview-main' => "Tienes que seleicionar una revisión concreta d'una páxina de conteníos pa revisala.

Vete a la [[Special:Unreviewedpages|llista de páxines ensin revisar]].",
	'revreview-submit' => 'Unviar',
	'revreview-toolow' => "'''Tienes de calificar caún de los atributos más alto que \"non afayadizu\" pa qu'una revisión se considere revisada.'''

Pa desaniciar l'estáu d'una revisión, calca \"nun aceutar\".

Calca nel botón \"atrás\" del restolador y téntalo otra vuelta.",
	'revreview-update' => "'''Por favor [[{{MediaWiki:Validationpage}}|revisa]] tolos cambeos pendientes ''(que s'amuesen abaxo)'' fechos dende la versión estable.'''",
	'revreview-update-includes' => "S'anovaron delles plantíes/ficheros (páxines ensin revisar en negrina):",
	'revreview-reject-summary' => 'Resume:',
	'revreview-reject-cancel' => 'Encaboxar',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vugar 1981
 * @author Wertuose
 */
$messages['az'] = array(
	'revisionreview' => 'Redaktələri yoxlayar',
	'revreview-log' => 'Şərh:',
	'revreview-submit' => 'Təsdiq et',
	'revreview-submitting' => 'Yollamaq',
	'revreview-reject-summary' => 'Xülasə:',
	'revreview-reject-cancel' => 'Ləğv et',
);

/** Bashkir (Башҡортса)
 * @author Haqmar
 */
$messages['ba'] = array(
	'revisionreview' => 'Өлгөләрҙе тикшереү',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'revisionreview' => 'بازبینی اصلاحات',
	'revreview-flag' => 'ای بازبینی اصلاح کن',
	'revreview-invalid' => "'''نامعتبراین هدف:''' هچ [[{{MediaWiki:Validationpage}}|بازبینی بوتگین]] نسخه مطابق انت گون داتگین شناسگ.",
	'revreview-log' => 'نظر:',
	'revreview-stable2' => 'شما شاید بلوٹیت بگندیت [{{fullurl:$1|stable=1}} نسخه ثابتی]چه ای صفحه (اگر که هستن).',
	'revreview-submit' => 'بازبینی دیم دی',
	'revreview-successful' => "'''انتخابی بازبینی [[:$1|$1]]گون موفقیت نشان بوت. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} بچار کل نسخ نشان بوتگینء])'''",
	'revreview-successful2' => "'''انتخاب بوتگین باز بینی [[:$1|$1]] گون موفقیت بی نشان بوت.'''",
	'revreview-toolow' => 'شما بایدن حداقل هر یکی چه جهلگین نشانانء درجه بللیت گیشتر چه "unapproved" تا یک بازبینیء په داب چارتگین بیت.
په نسخ کتن یک بازبینی کل فیلدانء په داب "unapproved" نشان کن.',
	'revreview-update-includes' => 'لهتی تمپلتان/تصاویر په روچ بیتگین:',
);

/** Belarusian (Беларуская)
 * @author Хомелка
 */
$messages['be'] = array(
	'revisionreview' => 'Праверка версій',
	'revreview-failed' => "Немагчыма праверыць версію.''' Уведзеныя дадзеныя няпоўныя або некарэктныя.",
	'revreview-submission-invalid' => 'Дадзенае прадстаўленне было няпоўным або ўтрымлівала іншы недахоп.',
	'review_page_invalid' => 'Недапушчальная назва мэтавай старонкі.',
	'review_page_notexists' => 'Мэтавая старонка не існуе.',
	'review_page_unreviewable' => "Мэтавая старонка не з'яўляецца правяраемай.",
	'review_no_oldid' => 'Не паказана ID версіі.',
	'review_bad_oldid' => 'Не існуе такой мэтавай версіі.',
	'review_conflict_oldid' => 'Нехта ўжо пацвердзіў або зняў пацверджанне з гэтай версіі, пакуль вы праглядалі яе.',
	'review_not_flagged' => 'Мэтавая версія цяпер не пазначана як правераная.',
	'review_too_low' => 'Версія не можа быць праверана, не паказаныя значэнні некаторых палёў.',
	'review_bad_key' => 'недапушчальны ключ параметра ўключэння.',
	'review_denied' => 'Доступ забаронены.',
	'review_param_missing' => 'Параметр не паказаны ці пазначаны няправільна.',
	'review_cannot_undo' => 'Не ўдаецца адмяніць гэтыя змены, паколькі далейшыя змены, якія чакаюць праверкі, закранаюць той жа ўчастак.',
	'review_cannot_reject' => 'Не ўдаецца адхіліць гэтыя змены, таму што нехта ўжо пацвердзіў некаторыя з іх.',
	'review_reject_excessive' => 'Немагчыма адхіліць такую вялікую колькасць змяненняў адразу.',
	'revreview-check-flag-p' => 'Пацвердзіць неправераныя змены',
	'revreview-check-flag-p-title' => 'Пацвердзіць ўсе змены, якія чакаюць праверкі, разам з вашай праўкай. Выкарыстоўвайце, толькі калі вы ўжо прагледзелі ўсе змены, якія чакаюць праверкі.',
	'revreview-check-flag-u' => 'Пацвердзіць гэтую версію неправеранай старонкі',
	'revreview-check-flag-u-title' => 'Пацвердзіць гэтую версію старонкі. Ужывайце толькі ў выпадку, калі вы цалкам прагледзелі старонку.',
	'revreview-check-flag-y' => 'Пацвердзіць гэтыя змены',
	'revreview-check-flag-y-title' => 'Пацвердзіць ўсе змены, зробленыя вамі ў гэтай праўцы',
	'revreview-flag' => 'Праверыць гэтую версію',
	'revreview-reflag' => 'Пераправерыць гэтую версію',
	'revreview-invalid' => "'''Памылковая мэта:''' не існуе [[{{MediaWiki:Validationpage}}|праверанай]] версіі старонкі, якая адпавядае паказанаму ідэнтыфікатару.",
	'revreview-log' => 'Заўвага:',
	'revreview-main' => 'Вы павінны выбраць адну з версій старонкі для праверкі.

Гл. [[Special:Unreviewedpages|пералік неправераных старонак]].',
	'revreview-stable1' => 'Магчыма, вы хочаце прагледзець [{{fullurl:$1|stableid=$2}} гэтую адзначаную версію] ці [{{fullurl:$1|stable=1}} апублікаваную версію] гэтай старонкі, калі такая існуе.',
	'revreview-stable2' => 'Вы можаце прагледзець [{{fullurl:$1|stable=1}} апублікаваную версію] гэтай старонкі.',
	'revreview-submit' => 'Адправіць',
	'revreview-submitting' => 'Адпраўка ...',
	'revreview-submit-review' => 'Пацвердзіць версію',
	'revreview-submit-unreview' => 'Зняць пацверджанне',
	'revreview-submit-reject' => 'Адхіліць змены',
	'revreview-submit-reviewed' => 'Гатова. Пацверджана!',
	'revreview-submit-unreviewed' => 'Гатова. Адменена пацверджанне!',
	'revreview-successful' => "'''Абраная версия [[:$1|$1]] паспяхова адзначана. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} прагляд стабільных версій])'''",
	'revreview-successful2' => "'''З выбранай версіі [[:$1|$1]] знята пазнака.'''",
	'revreview-toolow' => "'''Вы павінны паказаць для ўсіх значэнняў ўзровень вышэй, чым «недастатковы», каб версія старонкі лічылася праверанай.'''

Каб скінуць прыкмету праверкі гэтай версіі, націсніце «Зняць пацвярджэнне».

Калі ласка, націсніце ў браўзэры кнопку «назад», каб паказаць значэнні зноўку.",
	'revreview-update' => "'''Калі ласка, [[{{MediaWiki:Validationpage}}|праверце]] змены ''(гл. ніжэй)'', якія зроблены ў прынятай версіі.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Вашы змены яшчэ не ўключаны ў стабільную версію.</span>

Калі ласка, праверце ўсе паказаныя ніжэй змены, каб забяспечыць з\'яўленне вашых правак у стабільнай версіі.
Магчыма, вам спатрэбіцца прайсці па гісторыі правак або «адмяніць» змены.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Вашы змены яшчэ не ўключаны ў стабільную версію. Існуюць больш раннія праўкі, якія патрабуюць праверкі.</span>

Каб уключыць вашы праўкі ў стабільную версію, калі ласка, праверце ўсе змены, паказаныя ніжэй.
Магчыма, вам спатрэбіцца спачатку прайсці па праўках ці адмяніць іх.',
	'revreview-update-includes' => 'Некаторыя шаблоны ці файлы былі абноўленыя:',
	'revreview-reject-text-list' => "Выконваючы гэта дзеянне, вы '''адхіляеце''' {{PLURAL:$1|наступную змену|наступныя змены}}:",
	'revreview-reject-text-revto' => 'Вяртае старонку назад да [{{fullurl:$1|oldid=$2}} версіі ад $3].',
	'revreview-reject-summary' => 'Апісанне праўкі',
	'revreview-reject-confirm' => 'Адхіліць гэтыя змены',
	'revreview-reject-cancel' => 'Адмена',
	'revreview-reject-summary-cur' => '	{{PLURAL:$1|Адхілена апошняя $1 змена|Адхілены апошнія $1 змены|Адхілены апошнія $1 змен}} ($2) і адноўлена версія $3 $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Адхілена першая $1 змена|Адхілены першыя $1 змены|Адхілены апошнія $1 змен}} ($2), {{PLURAL:$1|якая ішла|якія ішлі}} за версіяй $3 $4',
	'revreview-tt-flag' => 'Пацвердзіце гэтую версію, адзначыўшы яе як правераную',
	'revreview-tt-unflag' => 'Зняць пацверджанне з гэтай версіі, адзначыўшы яе як неправераную',
	'revreview-tt-reject' => 'Адхіліць гэтыя змены, адкаціць іх',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'revisionreview' => 'Рэцэнзаваць вэрсіі',
	'revreview-failed' => "'''Немагчыма праверыць гэту вэрсію.'''",
	'revreview-submission-invalid' => 'Дасылка была няпоўнай ці няслушнай.',
	'review_page_invalid' => 'Няслушная назва мэтавай старонкі.',
	'review_page_notexists' => 'Мэтавая старонка не існуе.',
	'review_page_unreviewable' => 'Мэтавая старонка ня можа быць прарэцэнзаваная.',
	'review_no_oldid' => 'Ідэнтыфікатар вэрсіі не пазначаны.',
	'review_bad_oldid' => 'Няма такіх мэтавых вэрсіяў.',
	'review_conflict_oldid' => 'Нехта ўжо прыняў ці адмяніў прыняцьце гэтай вэрсіі, пакуль Вы яе праглядалі.',
	'review_not_flagged' => 'Мэтавая вэрсія ў цяперашні момант не пазначаная як рэцэнзаваная.',
	'review_too_low' => 'Вэрсія ня можа быць прарэцэнзаваная, таму што некаторыя палі былі пакінутыя «неадпаведнымі».',
	'review_bad_key' => 'Няслушны ключ парамэтру ўключэньня.',
	'review_bad_tags' => 'Некаторыя значэньні пазначаных тэгаў няслушныя.',
	'review_denied' => 'Доступ забаронены.',
	'review_param_missing' => 'Парамэтар адсутнічае альбо няслушны.',
	'review_cannot_undo' => 'Немагчыма адмяніць гэтыя зьмены, таму што чакаючыя рэцэнзіі рэдагаваньні закранаюць гэтыя ж фрагмэнты.',
	'review_cannot_reject' => 'Немагчыма адхіліць зьмены, таму што нехта ўжо прарэцэнзаваў некаторыя зь іх (ці ўсе).',
	'review_reject_excessive' => 'Немагчыма адхіліць так шмат зьменаў адразу.',
	'review_reject_nulledits' => 'Немагчыма адхіліць гэтыя зьмены, таму што ўсе вэрсіі ня маюць рэдагаваньняў.',
	'revreview-check-flag-p' => 'Прыняць гэтую вэрсію (утрымлівае $1 {{PLURAL:$1|непрынятую зьмену|непрынятыя зьмены|непрынятых зьменаў}})',
	'revreview-check-flag-p-title' => 'Прыняць усе цяперашнія зьмены, якія чакаюць рэцэнзіі разам з Вашым рэдагаваньнем.
Выкарыстоўвайце толькі калі Вы ўжо праглядзелі зьмены, якія чакаюць праверкі.',
	'revreview-check-flag-u' => 'Прыняць гэтую нерэцэнзаваную старонку',
	'revreview-check-flag-u-title' => 'Прыняць гэтую вэрсію старонкі. Выкарыстоўвайце гэтую магчымасьць, толькі калі Вы праглядзелі ўвесь зьмест старонкі.',
	'revreview-check-flag-y' => 'Прыняць гэтыя зьмены',
	'revreview-check-flag-y-title' => 'Прыняць усе зьмены, якія Вы зрабілі ў гэтым рэдагаваньні.',
	'revreview-flag' => 'Праверыць гэту вэрсію',
	'revreview-reflag' => 'Пераправерыць гэтую вэрсію',
	'revreview-invalid' => "'''Няслушная мэта:''' няма [[{{MediaWiki:Validationpage}}|рэцэнзаванай]] вэрсіі, якая адпавядае пададзенаму ідэнтыфікатару.",
	'revreview-log' => 'Камэнтар:',
	'revreview-main' => 'Вам неабходна выбраць адну з вэрсіяў старонкі для рэцэнзаваньня.

Глядзіце [[Special:Unreviewedpages|сьпіс нерэцэнзаваных старонак]].',
	'revreview-stable1' => 'Верагодна, Вы жадаеце праглядзець [{{fullurl:$1|stableid=$2}} гэтую пазначаную вэрсію] і праверыць, ці зьяўляецца яна [{{fullurl:$1|stable=1}} апублікаванай вэрсіяй] гэтай старонкі.',
	'revreview-stable2' => 'Верагодна, Вы жадаеце праглядзець [{{fullurl:$1|stable=1}} апублікаваную вэрсію] гэтай старонкі.',
	'revreview-submit' => 'Даслаць',
	'revreview-submitting' => 'Адпраўка…',
	'revreview-submit-review' => 'Зацьвердзіць вэрсію',
	'revreview-submit-unreview' => 'Зьняць зацьверджаньне вэрсіі',
	'revreview-submit-reject' => 'Скасаваць зьмены',
	'revreview-submit-reviewed' => 'Выканана. Зацьверджана!',
	'revreview-submit-unreviewed' => 'Выканана. Зацьверджаньне зьнятае!',
	'revreview-successful' => "'''Вэрсія [[:$1|$1]] пасьпяхова пазначана. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} паказаць стабільныя вэрсіі])'''",
	'revreview-successful2' => "'''З вэрсіі [[:$1|$1]] было пасьпяхова зьнятае пазначэньне.'''",
	'revreview-poss-conflict-p' => "'''Папярэджаньне: [[User:$1|$1]] пачаў рэцэнзаваньне гэтай старонкі $2 у $3.'''",
	'revreview-poss-conflict-c' => "'''Папярэджаньне: [[User:$1|$1]] пачаў рэцэнзаваньне гэтых зьменаў $2 у $3.'''",
	'revreview-adv-reviewing-p' => 'Заўвага: Іншыя рэцэнзэнты могуць бачыць, што Вы рэцэнзуеце гэтую старонку.',
	'revreview-adv-reviewing-c' => 'Заўвага: Іншыя рэцэнзэнты могуць бачыць, што Вы рэцэнзуеце гэтыя зьмены.',
	'revreview-sadv-reviewing-p' => 'Вы можаце $1 усім, што Вы рэцэнзуеце гэтую старонку.',
	'revreview-sadv-reviewing-c' => 'Вы можаце $1 усім, што Вы рэцэнзуеце гэтыя зьмены.',
	'revreview-adv-start-link' => 'рэклямаваць',
	'revreview-adv-stop-link' => 'прыбраць рэкляму',
	'revreview-toolow' => "'''Вам неабходна адзначыць кожны атрыбут адзнакай вышэй за «недастатковая», каб вэрсія старонкі лічылася рэцэнзаванай.'''

Каб зьняць адзнаку з вэрсіі, націсьніце «зьняць зацьверджаньне».

Калі ласка, націсьніце ў Вашым браўзэры кнопку «вярнуцца» і паспрабуйце зноў.",
	'revreview-update' => "'''Калі ласка, [[{{MediaWiki:Validationpage}}|прарэцэнзуйце]] ўсе зьмены ''(паказаныя ніжэй)'', зробленыя ў апублікаванай вэрсіі.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Вашыя зьмены яшчэ не былі далучаныя да стабільнай вэрсіі.</span>

Калі ласка, прарэцэнзуйце ўсе пададзеныя ніжэй зьмены, каб Вашыя зьмены былі далучаныя да стабільнай вэрсіі.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Вашыя зьмены яшчэ не былі далучаныя да стабільнай вэрсіі. Існуюць зьмены, якія чакаюць рэцэнзаваньня.</span>

Калі ласка, прарэцэнзуйце ўсе зьмены пададзеныя ніжэй, каб Вашыя рэдагаваньні былі далучаныя да стабільнай вэрсіі.',
	'revreview-update-includes' => 'Абноўленыя шаблёны/файлы (нерэцэнзаваныя старонкі выдзеленыя тлустым шрыфтам):',
	'revreview-reject-text-list' => "Выканаўшы гэтае дзеяньне, Вы '''адхіліце''' зьмены крынічнага тэксту ў {{PLURAL:$1|наступнай зьмене|наступных зьменах}} [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Гэта адкаціць назад старонку да [{{fullurl:$1|oldid=$2}} вэрсіі $3].',
	'revreview-reject-summary' => 'Апісаньне:',
	'revreview-reject-confirm' => 'Адмяніць гэтыя зьмены',
	'revreview-reject-cancel' => 'Адмяніць',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Адхіленая $1 апошняя тэкставая зьмена зробленая|Адхіленыя $1 апошнія тэкставыя зьмены зробленыя|Адхіленыя $1 апошніх тэкставых зьменаў зробленых}} ($2) і адноўленая вэрсія $3 зробленая $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Адхіленая $1 першая тэкставая зьмена зробленая|Адхіленыя $1 першыя тэкставыя зьмены зробленыя|Адхіленыя $1 першых тэкставых зьменаў зробленыя}} ($2) наступных пасьля вэрсіі $3 зробленай $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Адхіленая $1 апошняя тэкставая зьмена|Адхіленыя $1 апошнія тэкставыя зьмены|Адхіленыя $1 апошніх тэкставых зьменаў}} і адноўленая вэрсія $2 зробленая $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Адхіленая $1 першая тэкставая зьмена наступная|Адхіленыя $1 першыя тэкставыя зьмены наступных|Адхіленыя $1 першых тэкставых зьменаў наступных}} пасьля вэрсіі $2 зробленай $3',
	'revreview-tt-flag' => 'Зацьвердзіць гэтую вэрсію пазначыўшы як правераную',
	'revreview-tt-unflag' => 'Зьняць зацьверджаньне вэрсіі, пазначыўшы яе як «неправеранаю»',
	'revreview-tt-reject' => 'Адхіліць гэтыя зьмены, скасаваўшы іх',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'review_page_invalid' => 'Заглавието на целевата страница е невалидно.',
	'review_page_notexists' => 'Целевата страница не съществува.',
	'review_no_oldid' => 'Не е указан идентификатор на версията.',
	'review_bad_oldid' => 'Целевата версия не съществува.',
	'review_conflict_oldid' => 'Някой вече е приел или отхвърлил тази версия, докато вие я преглеждахте.',
	'review_denied' => 'Достъпът е отказан.',
	'review_param_missing' => 'Липсващ или неправилен параметър.',
	'review_reject_excessive' => 'Не могат да се отхвърлят толкова много редакции наведнъж.',
	'revreview-log' => 'Коментар:',
	'revreview-submit' => 'Изпращане',
	'revreview-submitting' => 'Изпращане...',
	'revreview-submit-review' => 'Приемане на версията',
	'revreview-submit-unreview' => 'Неприемане на версията',
	'revreview-submit-reject' => 'Отхвърляне на промените',
	'revreview-submit-reviewed' => 'Готово. Прието!',
	'revreview-submit-unreviewed' => 'Готово. Неприето!',
	'revreview-update-includes' => 'Актуализирани шаблони/файлове (непрегледаните страници са в получер шрифт):',
	'revreview-reject-summary' => 'Резюме:',
	'revreview-reject-cancel' => 'Отказване',
	'revreview-tt-flag' => 'Приемете тази версия, като я отбележите като "проверена"',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'revisionreview' => 'সংশোধনগুলি পর্যালোচনা করুন',
	'review_denied' => 'অনুমতি প্রত্যাখ্যাত হয়েছে।',
	'revreview-check-flag-y' => 'আমার পরিবর্তনসমূহ গ্রহণ',
	'revreview-flag' => 'এই সংশোধনটি পর্যালোচনা করুন',
	'revreview-log' => 'মন্তব্য:',
	'revreview-main' => 'আপনাকে অবশ্যই কোন একটি বিষয়বস্তু পাতা থেকে একটি নির্দিষ্ট সংশোধন পর্যালোচনা করার জন্য বাছাই করতে হবে।

পর্যালোচনা করা হয়নি এমন পাতাগুলির একটি তালিকার জন্য [[Special:Unreviewedpages]] দেখুন।',
	'revreview-submit' => 'জমা দাও',
	'revreview-submitting' => 'জমা হচ্ছে …',
	'revreview-submit-review' => 'সংশোধন গ্রহণ',
	'revreview-submit-unreview' => 'সংশোধন প্রত্যাখান',
	'revreview-submit-reject' => 'পরিবর্তন প্রত্যাখান',
	'revreview-toolow' => 'কোন সংশোধনকে পর্যালোচিত গণ্য করতে চাইলে আপনাকে নিচের বৈশিষ্ট্যগুলির প্রতিটিকে কমপক্ষে "অননুমোদিত" থেকে উচ্চতর কোন রেটিং দিতে হবে। কোন সংশোধনকে অবনমিত করতে চাইলে, সবগুলি ক্ষেত্র "অননুমোদিত"-তে সেট করুন।',
	'revreview-reject-summary' => 'সারাংশ:',
	'revreview-reject-cancel' => 'বাতিল',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'revisionreview' => 'Adwelet ar reizhadennoù',
	'revreview-failed' => "'''N'eus ket tu da wiriañ an adweladenn-mañ.'''",
	'revreview-submission-invalid' => 'Direizh pe diglok e oa an urzh kas.',
	'review_page_invalid' => 'Fall eo titl ar bajenn tal.',
	'review_page_notexists' => "N'eus ket eus ar bajenn buket.",
	'review_page_unreviewable' => "Ar bajenn da dizhout ne c'hell ket bezañ adlennet.",
	'review_no_oldid' => "N'eus bet diferet ID adweladenn ebet.",
	'review_bad_oldid' => "N'eus ket eus an adweladenn klasket.",
	'review_conflict_oldid' => "Unan bennak en deus aprouet pe distaolet an adweladenn e-keit ha ma oac'h o lenn anezhi.",
	'review_not_flagged' => "An adweladenn pal n'emañ ket merket e-giz adwelet.",
	'review_too_low' => 'Ne c\'hell ket an adweladenn bezañ adlennet gant maeziennoù laosket "nann-aprouet".',
	'review_bad_key' => "Alc'hwez arventenn enklozadur direizh.",
	'review_bad_tags' => 'Direizh eo lod eus talvoudoù ar balizennoù spisaet',
	'review_denied' => "Aotre nac'het.",
	'review_param_missing' => 'Un arventenn a vank pe a zo direizh.',
	'review_cannot_undo' => "N'eus ket tu da zizober ar c'hemmoù peogwir ez eus kemmoù all o c'hortoz er memes lec'h.",
	'review_cannot_reject' => "N'haller ket tisteuler ar c'hemmoù-mañ rak unan bennak all en deus degemeret lod (pe an holl) anezho dija.",
	'review_reject_excessive' => "N'haller ket disteuler kement a gemmoù war un dro.",
	'revreview-check-flag-p' => "Degemer ar stumm-mañ (e-barzh $1 {{PLURAL:$1|c'hemm|kemm}} da zont)",
	'revreview-check-flag-p-title' => "Asantiñ pep kemm o c'hortoz gant ho kemmoù deoc'h. Implijit an dra-se nemet m'ho peus gwelet an difoc'h eus hollad ar c'hemmoù o c'hortoz.",
	'revreview-check-flag-u' => "Degemer ar bajenn-mañ n'eo ket bet adlennet",
	'revreview-check-flag-u-title' => "Degemer ar stumm-mañ eus ar bajenn. Na implijit an kement-mañ nemet m'hoc'h eus gwelet dija ar bajenn en he fezh.",
	'revreview-check-flag-y' => "Degemer ar c'hemmoù-mañ",
	'revreview-check-flag-y-title' => "Degemer an holl gemmoù hoc'h eus graet er c'hemm-mañ.",
	'revreview-flag' => 'Adwelet an adweladenn',
	'revreview-reflag' => 'Adlenn adarre an adweladenn-mañ',
	'revreview-invalid' => "'''Pal direizh :''' n'eus [[{{MediaWiki:Validationpage}}|stumm adwelet ebet]] o klotañ gant an niverenn merket.",
	'revreview-log' => 'Notenn :',
	'revreview-main' => 'Rankout a rit diuzañ ur stumm resis eus ar bajenn evit ober un adlenn.
Gwelet [[Special:Unreviewedpages|roll ar pajennoù nann-adlennet]].',
	'revreview-stable1' => "Marteze hoc'h eus c'hoant gwelet [{{fullurl:$1|stableid=$2}} ar stumm merket] a-benn gouzout ma 'z eo bremañ [{{fullurl:$1|stable=1}} ar stumm embannet] eus ar bajenn-mañ.",
	'revreview-stable2' => "Marteze hoc'h eus c'hoant gwelet [{{fullurl:$1|stable=1}} ar stumm embannet] eus ar bajenn-mañ.",
	'revreview-submit' => 'Kas',
	'revreview-submitting' => 'O kas...',
	'revreview-submit-review' => 'Aprouiñ ar stumm',
	'revreview-submit-unreview' => 'Disaprouiñ ar stumm',
	'revreview-submit-reject' => "Disteurel ar c'hemmoù",
	'revreview-submit-reviewed' => 'Graet. Aprouet !',
	'revreview-submit-unreviewed' => 'Graet. Diaprouet !',
	'revreview-successful' => "'''An adweladenn eus [[:$1|$1]] a zo bet merket ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} gwelet ar stummoù stabil])'''",
	'revreview-successful2' => "'''Stumm eus [[:$1|$1]] diwiriekaat.'''",
	'revreview-poss-conflict-p' => "'''Diwallit : kroget en doa [[User:$1|$1]] da adwelet ar bajenn-mañ d'an $2 da $3.'''",
	'revreview-poss-conflict-c' => "'''Diwallit : kroget en doa [[User:$1|$1]] da adwelet ar c'hemmoù-mañ d'an $2 da $3.'''",
	'revreview-adv-start-link' => 'Ober bruderezh',
	'revreview-adv-stop-link' => 'Paouez gant ar bruderezh',
	'revreview-toolow' => "'''Rankout a rit reiñ ur briziadenn uheloc'h eget \"ket aprouet\" evit ma 'vefe dalc'het kont eus an adweladenn.'''

Evit tennañ kuit statud adlenn ur stumm, klikit war \"diaprouiñ\".

Implijit bouton \"distreiñ\" ho merdeer ha klaskit en-dro.",
	'revreview-update' => "'''Mar plij [[{{MediaWiki:Validationpage}}|adlennit]] an holl gemmoù ''(diskouezet a-is)'' bet graet d'ar stumm degemeret.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">N\'emañ ket ho kemmoù er stumm stabil c\'hoazh.</span>

Adlennit an holl gemmoù diskouezet a-is evit ma teufe war wel ho kemmoù er stumm stabil.',
	'revreview-update-edited-prev' => "<span class=\"flaggedrevs_important\">N'emañ ket ho kemmoù er stumm stabil c'hoazh. Kemmoù all a c'hortoz bezañ aprouet.</span>

Adlennit an holl gemmoù diskouezet a-is evit ma teufe war wel ho kemmoù er stumm stabil.",
	'revreview-update-includes' => "patromoù/restroù bet hizivaet (e tev ar pajennoù n'int ket bet adwelet) :",
	'revreview-reject-text-list' => "Ma rit se e '''tistaolot''' ar c'hemmoù an destenn orin evit an {{PLURAL:$1|adweladenn|adweladenn}} da-heul eus [[:$2|$2]] :",
	'revreview-reject-text-revto' => 'Kement-mañ a adlakao ar bajenn en he [{{fullurl:$1|oldid=$2}} stumm eus an $3].',
	'revreview-reject-summary' => 'Diverrañ :',
	'revreview-reject-confirm' => "Disteuler ar c'hemmoù-mañ",
	'revreview-reject-cancel' => 'Nullañ',
	'revreview-reject-summary-cur' => "Distaolet {{PLURAL:$1|ar c'hemm testenn|an $1 kemm testenn}} diwezhañ (gant $2) hag assavet ar stumm $3 gant $4",
	'revreview-reject-summary-old' => "Distaolet {{PLURAL:$1|ar c'hemm testenn|an $1 kemm testenn}} kentañ (gant $2) a heulie ar stumm adwelet $3 gant $4",
	'revreview-reject-summary-cur-short' => "Distaolet {{PLURAL:$1|ar c'hemm testenn|an $1 kemm testenn}} diwezhañ (gant $2) hag assavet ar stumm $2 gant $3",
	'revreview-reject-summary-old-short' => "Distaolet {{PLURAL:$1|ar c'hemm testenn|an $1 kemm testenn}} kentañ a heulie ar stumm adwelet $2 gant $3",
	'revreview-tt-flag' => 'Aprouiñ ar stumm-mañ en ur merkañ anezhañ evel gwiriekaet',
	'revreview-tt-unflag' => 'Diaprouiñ ar stumm-mañ en ur merkañ anezhañ evel "nann-gwiriekaet"',
	'revreview-tt-reject' => "Dizober ar c'hemmoù-se en destenn orin en ur zisteurel anezho",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'revisionreview' => 'Pregledaj revizije',
	'revreview-failed' => "'''Ne može se pregledati ova revizija.'''",
	'revreview-submission-invalid' => 'Slanje je nekompletno ili na drugi način nevaljano.',
	'review_page_invalid' => 'Naslov ciljne datoteke nije valjan',
	'review_page_notexists' => 'Ciljna stranica ne postoji.',
	'review_page_unreviewable' => 'Ciljna stranica se ne može provjeravati.',
	'review_no_oldid' => 'Nije naveden ID revizije.',
	'review_bad_oldid' => 'Ciljna revizija ne postoji.',
	'review_conflict_oldid' => 'Neko je već prihvatio ili odbio ovu reviziju dok ste je vi pregledali.',
	'review_not_flagged' => 'Ciljna revizija nije trenutno označena kao pregledana.',
	'review_too_low' => "Revizije ne mogu biti pregledane ako su neka polja ostavljena ''neadekvatna''.",
	'review_bad_key' => 'Nevaljan ključ parametra uključivanja.',
	'review_bad_tags' => 'Određene navedene vrijednosti oznaka su nevaljane.',
	'review_denied' => 'Pristup odbijen.',
	'review_param_missing' => 'Parametar nedostaje ili je nevaljan.',
	'review_cannot_undo' => 'Ne mogu vratiti ove promjene jer su ostale izmjene na čekanju promjenenje u istom području.',
	'review_cannot_reject' => 'Ne možete odbiti ove promjene jer je neko već prihvatio neke (ili sve) izmjene.',
	'review_reject_excessive' => 'Ne možete odbiti ovoliki broj izmjena odjednom.',
	'review_reject_nulledits' => 'Ne mogu odbiti ove promjene jer su sve revizije bez izmjena.',
	'revreview-check-flag-p' => 'Prihvati ovu verziju (uključujući $1 {{PLURAL:$1|izmjenu|izmjene|izmjena}} na čekanju)',
	'revreview-check-flag-p-title' => 'Prihvati sve trenutne izmjene na čekanju zajedno sa vašim vlastitim izmjenama. Koristite ovo samo ako ste već pregledali sve razlike izmjena na čekanju.',
	'revreview-check-flag-u' => 'Prihvati ovu nepregledanu stranicu',
	'revreview-check-flag-u-title' => 'Prihvati ovu verziju stranice. Koristite ovo samo ako ste pregledali cijelu stranicu.',
	'revreview-check-flag-y' => 'Prihvati ove izmjene',
	'revreview-check-flag-y-title' => 'Prihvati sve izmjene koje ste napravili u ovom uređivanju.',
	'revreview-flag' => 'Provjerite ovu reviziju',
	'revreview-reflag' => 'Ponovo provjeri ovu reviziju',
	'revreview-invalid' => "'''Nevaljan cilj:''' nijedna [[{{MediaWiki:Validationpage}}|pregledana]] revizija ne odgovara navedenom ID.",
	'revreview-log' => 'Komentar:',
	'revreview-main' => 'Morate odabrati određenu reviziju stranice sadržaja da biste je provjerili.

Pogledajte [[Special:Unreviewedpages|spisak nepregledanih stranica]].',
	'revreview-stable1' => 'Možda želite vidjeti [{{fullurl:$1|stableid=$2}} ovu označenu verziju] i provjeriti da li sada postoji [{{fullurl:$1|stable=1}} stabilna verzija] ove stranice.',
	'revreview-stable2' => 'Možda bi htjeli pogledati [{{fullurl:$1|stable=1}} stabilnu verziju] ove stranice.',
	'revreview-submit' => 'Pošalji',
	'revreview-submitting' => 'Šaljem...',
	'revreview-submit-review' => 'Prihvati reviziju',
	'revreview-submit-unreview' => 'Odbij reviziju',
	'revreview-submit-reject' => 'Odbij izmjene',
	'revreview-submit-reviewed' => 'Završeno. Prihvaćeno!',
	'revreview-submit-unreviewed' => 'Završeno. Neprihvaćeno!',
	'revreview-successful' => "'''Revizija od [[:$1|$1]] je uspješno označena. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} vidi stabilne verzije])'''",
	'revreview-successful2' => "'''Reviziji od [[:$1|$1]] je uspješno uklonjena oznaka.'''",
	'revreview-poss-conflict-p' => "'''Upozorenje: [[User:$1|$1]] je započeo pregled ove stranice dana $2 u $3.'''",
	'revreview-poss-conflict-c' => "'''Upozorenje: [[User:$1|$1]] je započeo pregled ovih izmjena dana $2 u $3.'''",
	'revreview-adv-reviewing-p' => "'''Napomena: Savjetuje vam se da započnete pregled ove stranice na $1 u $2.'''",
	'revreview-adv-reviewing-c' => "'''Napomena: Savjetuje vam se da započnete pregled ovih izmjena na $1 u $2.'''",
	'revreview-toolow' => "'''Morate ocijeniti svaku od ispod navedenih ocjena više od ''neadekvatno'' da bi se revizija smatrala pregledanom.'''

Da bi uklonili status ocjene revizije, kliknite na ''odbij''.

Molimo pritisnite dugme \"natrag\" u Vašem pregledniku i pokušajte ponovo.",
	'revreview-update' => "'''Molimo [[{{MediaWiki:Validationpage}}|pregledajte]] sve promjene na čekanju ''(pokazane ispod)'' načinjene od stabilne verzije.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Vaše izmjene još uvijek nisu u stabilnoj verziji.</span>

Molimo provjerite sve izmjene prikazane ispod da bi se vaše izmjene prikazale u stabilnoj verziji.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Vaše izmjene još uvijek nisu u stabilnoj verziji. Postoje ranije izmjene koje su na čekanju za provjeru</span>

Molimo provjerite sve izmjene prikazane ispod da bi se vaše izmjene prikazale u stabilnoj verziji.',
	'revreview-update-includes' => "''Šabloni/datoteke su ažurirani (nepregledane stranice su bodirane):",
	'revreview-reject-text-list' => "Dovršavanjem ove akcije, vi ćete '''odbiti'''  izmjene izvornog teksta od {{PLURAL:$1|slijedeće revizije|slijedećih revizija}} od [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Ovim ćete vratiti nazad stranicu na [{{fullurl:$1|oldid=$2}} verziju od $3].',
	'revreview-reject-summary' => 'Sažetak:',
	'revreview-reject-confirm' => 'Odbij ove izmjene',
	'revreview-reject-cancel' => 'Odustani',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Odbijena zadnja izmjena teksta|Odbijene zadnje $1 izmjene teksta|Odbijeno zadnjih $1 izmjena teksta}} (od strane $2) i vraćena revizija $3 od $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Odbijena prva izmjena|Odbijene prve $1 izmjene|Odbijeno prvih $1 izmjena}} teksta (od strane $2) koje su načinjene nakon revizije $3 od $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Odbijena zadnja izmjena|Odbijene zadnje $1 izmjene|Odbijeno zadnjih $1 izmjena}} teksta i vraćena revizija $2 od $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Odbijena prva izmjena|Odbijene prve $1 izmjene|Odbijeno prvih $1 izmjena}} teksta koje su načinjene nakon revizije $2 od $3',
	'revreview-tt-flag' => "Prihvati ovu reviziju označavajući je ''provjerenom''",
	'revreview-tt-unflag' => "Ne prihvati ovu reviziju označavajući je ''neprovjerenom''",
	'revreview-tt-reject' => 'Odbij promjene ovog izvornog teksta tako što ćete ih vratiti',
);

/** Catalan (Català)
 * @author Qllach
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'revisionreview' => 'Revisa les revisions',
	'revreview-flag' => 'Revisa aquesta revisió',
	'revreview-log' => 'Comentari:',
	'revreview-submit' => 'Tramet',
	'revreview-update' => "Si us plau, [[{{MediaWiki:Validationpage}}|reviseu]] els canvis ''(indicats a sota)'' fets des que la versió estable va ser [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} aprovada].

'''Algunes plantilles o imatges han canviat:'''",
	'revreview-update-includes' => "S'han actualitzat algunes plantilles o fitxers:",
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'revisionreview' => 'Варсийшка хьажар',
	'revreview-failed' => "'''Ца хьажало варсийга.'''",
	'revreview-submission-invalid' => 'Хlоттам бара бузанза йа кхачам боцуш чулацамца.',
	'review_page_invalid' => 'Агlонан чулацамца йогlуш йоцу цlе.',
	'review_page_notexists' => 'Iалаше хьажийна агlо йа йац.',
	'review_page_unreviewable' => 'Iалаше хьажийна агlо йу хьажаман.',
	'review_no_oldid' => 'Ца хоттийна ID варси.',
	'review_bad_oldid' => 'Йоцуш йу ишта lалаше хьажийна варси.',
	'review_conflict_oldid' => 'Хьо цуьнга хьожушехь, цхьаммо къобал йина, йа къобал йара дlа даьккхина кху варси.',
	'review_not_flagged' => 'Iалаше хьажийна варси хьаьжин санна билгал ца йина.',
	'review_too_low' => 'Хьажанза хила мега варси, хотта ца йина цхьац йолу метигlаш.',
	'review_bad_key' => 'барам лато мегаш доцу дlогlа.',
	'review_denied' => 'Тlекхача цамагийна.',
	'review_param_missing' => 'Барам хlоттийна бац йа нийса ца хlоттийна.',
	'review_cannot_undo' => 'Гlулакх ца хуьлу хицамаш йуху баха, хlунда аьлча, кхин дlа хьоьжуш lаш болу хьажна хийцамаш бу оцун чохь.',
	'review_cannot_reject' => 'Гlулакх ца хуьлу хицамаш йуху баха, хlунда аьлча хlинц цхьам къобал бина церах цхьац берг.',
	'review_reject_excessive' => 'Гlулакх ца хуьлу оцул дукха хийцамаш сиха йуху баха.',
	'revreview-check-flag-p' => 'Къобал йой хlара варси ($1 {{PLURAL:$1|хьажанза хийцам|хьажанза хийцамаш}})',
	'revreview-check-flag-p-title' => 'Къобал бой массо хьоьжаш болу хийцамаш хьан нисдарца. Лелайе, нагахьсан хьо хьаьжнехь массо хьоьжаш болучу хийцамашка.',
	'revreview-check-flag-u' => 'Къобал йе хlара варси хьажанза агlон',
	'revreview-check-flag-u-title' => 'Къобал йе хlара агlон варси. Лела йе, нагахьсан хьо билгалла хьаьжнехь агlоне.',
	'revreview-check-flag-y' => 'Къобал бе хlара хийцамаш',
	'revreview-check-flag-y-title' => 'Къобал бе массо хийцамаш, ахьа бинарш оцу нисдарехь.',
	'revreview-flag' => 'Хьажа оцу варсига',
	'revreview-reflag' => 'Йуха хьажа оцу варсига',
	'revreview-invalid' => "'''Гlалатца хьажор:''' йоцуш йу [[{{MediaWiki:Validationpage}}|хьаьжна]] йогlуш йолу оцу цlарца агlонан варси.",
	'revreview-log' => 'Билгалдар:',
	'revreview-main' => 'Ахьа харжа церах цхьа варсийн агlо, нийса йуй хьажарна.

Хьажа. [[Special:Unreviewedpages|хьажанза агlонан могlам]].',
	'revreview-stable1' => 'Хила мега хьо хьажа лууш [{{fullurl:$1|stableid=$2}} хlокх къастам биначу башхоне] йа хlокху агlона [{{fullurl:$1|stable=1}} чутоьхначу башхоне], нагахь исаннаг йалахь.',
	'revreview-stable2' => 'Хьо хьажалур ву [{{fullurl:$1|stable=1}} чутоьхначу башхоне] хlокху агlон.',
	'revreview-submit' => 'Дlадахьийта',
	'revreview-submitting' => 'Дlайахьийтар…',
	'revreview-submit-review' => 'Къобал йе варси',
	'revreview-submit-unreview' => 'Дlадаккха къобал йар',
	'revreview-submit-reject' => 'Йуха баха хийцамаш',
	'revreview-submit-reviewed' => 'Йели. Къобал йи!',
	'revreview-submit-unreviewed' => 'Йели. Къобал дар дlадаьккхи!',
	'revreview-successful' => "'''Хьаржина башхо [[:$1|$1]] кхиамца билгалло йира. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} хьажар цхьан эшшара йолу башхонашка])'''",
	'revreview-successful2' => "'''Хаьржиначу варсийн тlийра [[:$1|$1]] дlайаькхин билгалло.'''",
	'revreview-toolow' => "'''Аша локхаллийн билгалло хlотто йеза лакхахьа, хlу «тlе цатоьа», агlонан варсий хилийта хьаьжинчарна йукъехь.'''

Варсийга хьаьжна аьлла билгалло дlайаккха, тlе таlайе «Къобал йар дlадаккха».

Дехар до, хьожуш гlодириг чохь (browser) тlе таlайе «йуха йаккхар», йуха а мах хотта ба.",
	'revreview-update' => "'''Дехар до, [[{{MediaWiki:Validationpage}}|хьажа]] хийцамашка ''(гойту лахахьа)'', бина болу тlелаьцчу варсийн.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Хьан хийцамаш хlинца ца латийна цхьан эшара йолу варсийн.</span>

Дехар до, хьовсийша массо лахахьа гойтуш болучу хийцамашка, цхьан эшар йолу варсийца хилийта шу хийцамаш.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Хьан хийцамаш хlинца ца латийна цхьан эшара йолу варсийн. Кхий хьалхара хийцамаш бу, хьажа дезаш.</span>

Шу хийцамаш латаба, цхьан эшар йолучу варсийца, дехар до, хьовсийша массо хийцамашка, гойтуш болу лахахьа.',
	'revreview-update-includes' => 'Цхьа долу куцкепаш йа хlумнаш а карла даьхна:',
	'revreview-reject-summary' => 'Хийцамех лаьцна:',
	'revreview-reject-confirm' => 'Йуха баха иза хийцамаш',
	'revreview-reject-cancel' => 'Цаоьшу',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Йуха баькхина тlаьххьара $1 хийцам|Йуха баькхина тlаьххьара $1 хийцамаш}} ($2) а, варсий метта хlоттош $3 $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Йуха баькхина дуьхьаралера $1 хийцам|Йуха баькхина дуьхьаралера $1 хийцамаш}} ($2), {{PLURAL:$1|тlехьа богlаш|тlехьа богlаш}} болу оцу варсийн $3 $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Йуха баькхина тlаьххьара $1 хийцам|Йуха баькхина тlаьххьара $1 хийцамаш}} а, варсий метта хlоттош $2 $3',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'revreview-submit' => 'ناردن',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Jkjk
 * @author Li-sung
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'revisionreview' => 'Posouzení verzí',
	'revreview-failed' => "'''Nelze posoudit tuto revizi.''' Zadané údaje jsou neúplné nebo nesprávné.",
	'revreview-submission-invalid' => 'Příspěvek by nekompletní nebo jinak chybný.',
	'review_page_invalid' => 'Cílová stránka je neplatná.',
	'review_page_notexists' => 'Cílová stránka neexistuje.',
	'review_page_unreviewable' => 'Cílová stránka není posouditená.',
	'review_no_oldid' => 'Nebylo uvedeno číslo revize',
	'review_bad_oldid' => 'Cílová verze neexistuje.',
	'review_not_flagged' => 'Cílová revize nyní není označena jako posouzená.',
	'review_too_low' => 'Revizi nelze posoudit, pokud některá pole ponechaná "neadekvátní".',
	'review_bad_key' => 'Neplatný klíč parametru zařazení',
	'review_denied' => 'Přístup odmítnut.',
	'review_param_missing' => 'Parametr chybí nebo je nesprávný',
	'review_cannot_undo' => 'Nelze vrátit tyto změny protože čekající editace změnily stejnou oblast.',
	'revreview-check-flag-p' => 'Akceptovat čekající změny',
	'revreview-check-flag-p-title' => 'Přijmout všechny čekající změny spolu vaší editací. Použijte, jen pokud jste již viděli rozdíl čekajících změn.',
	'revreview-check-flag-u' => 'Přimout tuto neposouzenou stránku',
	'revreview-check-flag-u-title' => 'Přijmout tuto verzi stránky. Použijte jen pokud jste již viděli celou stránku.',
	'revreview-check-flag-y' => 'Akceptovat tyto změny',
	'revreview-check-flag-y-title' => 'Akceptovat všechny změny vaší editace.',
	'revreview-flag' => 'Posoudit tuto verzi',
	'revreview-reflag' => 'Označit tuto revizi za neposouzenou',
	'revreview-invalid' => "'''Neplatný cíl:''' žádná [[{{MediaWiki:Validationpage}}|posouzená]] verze neodpovídá zadanému ID.",
	'revreview-log' => 'Komentář:',
	'revreview-main' => 'Pro posouzení musíte vybrat určitou verzi stránky. 

Vizte [[Special:Unreviewedpages|seznam neposouzených stránek]].',
	'revreview-stable1' => 'Můžete zobrazit [{{fullurl:$1|stableid=$2}} tuto označenou verzi] nebo se podívat, jestli je to teď [{{fullurl:$1|stable=1}} stabilní verze] této stránky.',
	'revreview-stable2' => 'Můžete zobrazit [{{fullurl:$1|stable=1}} stabilní verzi] této stránky (pokud ještě existuje).',
	'revreview-submit' => 'Odeslat',
	'revreview-submitting' => 'Odesílá se',
	'revreview-submit-review' => 'Přijmout revizi',
	'revreview-submit-unreview' => 'Nepřijmout revizi',
	'revreview-submit-reject' => 'Odmítnout změny',
	'revreview-submit-reviewed' => 'Hotovo. Akceptováno!',
	'revreview-submit-unreviewed' => 'Hotovo. Neakceptováno!',
	'revreview-successful' => "'''Vybraná revize stránky [[:$1|$1]] byla úspěšně označena. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} zobrazit stabilní verze])'''",
	'revreview-successful2' => "'''Označení revize stránky [[:$1|$1]] bylo úspěšně zrušeno.'''",
	'revreview-toolow' => 'Aby byla verze označena jako posouzená, musíte označit každou vlastnost lepším hodnocením než "neschváleno". Pokud chcete verzi odmítnout nechte ve všech polích hodnocení "neschváleno".',
	'revreview-update' => "[[{{MediaWiki:Validationpage}}|Posuďte]] prosím všechny změny ''(zobrazené níže)'' provedené od posledního [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} schválení] stabilní verze.<br />
'''Některé šablony nebo soubory byly změněny:'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Vaše změny zatím nejsou ve stabilní verzi.</span>

Aby se tam mohly dostat, posuďte prosím nejdříve všechny změny zobrazené níže.
Bude nutné tyto editace začlenit nebo zamítnout.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Vaše změny zatím nejsou ve stabilní verzi. Některé starší změny ještě čekají na posouzení.</span>

Aby se tam mohly dostat, posuďte prosím nejdříve všechny změny zobrazené níže.
Bude nutné tyto editace začlenit nebo zamítnout.',
	'revreview-update-includes' => 'Některé šablony/soubory se změnily:',
	'revreview-reject-text-list' => "Dokončením této akce, '''zamítnete''' následující {{PLURAL:$1|zmněnu|změny|změn}}:",
	'revreview-reject-text-revto' => 'Toto se vrátí zpět stránku do [{{fullurl:$1|oldid = $2}} revize z $3].',
	'revreview-reject-summary' => 'Shrnutí:',
	'revreview-reject-confirm' => 'Odmítnout tyto změny',
	'revreview-reject-cancel' => 'Zrušit',
	'revreview-tt-flag' => 'Schválit tuto verzi jejím označením za "zkontrolovanou"',
	'revreview-tt-unflag' => 'Zamítnout tuto verzi jejím označením za "nezkontrolovanou"',
	'revreview-tt-reject' => 'Odmítnout tyto změny jejich vrácením',
);

/** Danish (Dansk)
 * @author Peter Alberti
 */
$messages['da'] = array(
	'revreview-submit' => 'Indsend',
	'revreview-submitting' => 'Indsender…',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Kghbln
 * @author Merlissimo
 * @author Metalhead64
 * @author Purodha
 * @author Umherirrender
 */
$messages['de'] = array(
	'revisionreview' => 'Versionen markieren',
	'revreview-failed' => "'''Diese Version konnte nicht markiert werden.'''",
	'revreview-submission-invalid' => 'Die Übertragung war unvollständig oder ungültig.',
	'review_page_invalid' => 'Der Zielseitentitel ist ungültig.',
	'review_page_notexists' => 'Die Zielseite existiert nicht.',
	'review_page_unreviewable' => 'Die Zielseite ist nicht prüfbar.',
	'review_no_oldid' => 'Keine Versionsnummer angegeben.',
	'review_bad_oldid' => 'Die angegebene Zielversionskennung existiert nicht.',
	'review_conflict_oldid' => 'Jemand hat bereits diese Version akzeptiert oder verworfen während du sie gelesen hast.',
	'review_not_flagged' => 'Die Zielversion ist derzeit nicht markiert.',
	'review_too_low' => 'Version kann nicht markiert werden, solange Felder noch als „unzureichend“ gekennzeichnet sind.',
	'review_bad_key' => 'Der Wert des Markierungsparameters ist ungültig.',
	'review_bad_tags' => 'Einige der angegebenen Kennzeichen sind ungültig.',
	'review_denied' => 'Zugriff verweigert.',
	'review_param_missing' => 'Ein Parameter fehlt oder ist ungültig.',
	'review_cannot_undo' => 'Diese Änderungen können nicht rückgängig gemacht werden, da weitere ausstehende Änderungen in den gleichen Bereichen gemacht wurden.',
	'review_cannot_reject' => 'Diese Änderungen können nicht verworfen werden, da ein anderer Benutzer bereits ein paar oder alle Bearbeitungen akzeptiert hat.',
	'review_reject_excessive' => 'So viele Bearbeitungen können nicht auf einmal verworfen werden.',
	'review_reject_nulledits' => 'Diese Änderungen können nicht verworfen werden, da all diese Versionen keine Änderungsbearbeitungen enthielten.',
	'revreview-check-flag-p' => 'Diese Version akzeptieren (inklusive {{PLURAL:$1|einer ausstehenden Änderung|$1 ausstehender Änderungen}})',
	'revreview-check-flag-p-title' => 'Alle noch nicht markierten Änderungen, zusammen mit deiner Bearbeitung, akzeptieren. Dies sollte nur gemacht werden, sofern bereits alle bislang noch nicht markierten Änderungen angesehen wurden.',
	'revreview-check-flag-u' => 'Diese unmarkierte Seite akzeptieren',
	'revreview-check-flag-u-title' => 'Diese Seitenversion akzeptieren. Dies sollte nur gemacht werden, wenn vorher die gesamte Seite angeschaut wurde.',
	'revreview-check-flag-y' => 'Diese Änderungen markieren',
	'revreview-check-flag-y-title' => 'Markieren alle Änderungen, die du mit dieser Bearbeitung gemacht hast.',
	'revreview-flag' => 'Markiere Version',
	'revreview-reflag' => 'Diese Version erneut markieren',
	'revreview-invalid' => "'''Ungültiges Ziel:''' keine [[{{MediaWiki:Validationpage}}|markierte]] Version zur angegebenen Versionsnummer gefunden.",
	'revreview-log' => 'Kommentar:',
	'revreview-main' => 'Du musst eine Version zur Markierung auswählen.

Siehe die [[Special:Unreviewedpages|Liste unmarkierter Versionen]].',
	'revreview-stable1' => 'Vielleicht möchtest du [{{fullurl:$1|stableid=$2}} die markierte Version] aufrufen, um zu sehen, ob es nunmehr die [{{fullurl:$1|stable=1}} stabile Version] dieser Seite ist?',
	'revreview-stable2' => 'Vielleicht möchtest du die [{{fullurl:$1|stable=1}} stabile Version] dieser Seite sehen?',
	'revreview-submit' => 'Speichern',
	'revreview-submitting' => 'Übertragung …',
	'revreview-submit-review' => 'Markiere Version',
	'revreview-submit-unreview' => 'Versionsmarkierung entfernen',
	'revreview-submit-reject' => 'Änderungen verwerfen',
	'revreview-submit-reviewed' => 'Erledigt und markiert!',
	'revreview-submit-unreviewed' => 'Erledigt und Markierung aufgehoben!',
	'revreview-successful' => "'''Die Version der Seite ''[[:$1|$1]]'' wurde erfolgreich markiert ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} alle markierten Versionen dieser Seite])'''.",
	'revreview-successful2' => "'''Die Markierung der Version von [[:$1|$1]] wurde erfolgreich aufgehoben.'''",
	'revreview-poss-conflict-p' => "'''Warnung: Ein anderer Benutzer ([[User:$1|$1]]) hat am $2 um $3 Uhr damit begonnen, diese Seite zu überprüfen.'''",
	'revreview-poss-conflict-c' => "'''Warnung: Ein anderer Benutzer ([[User:$1|$1]]) hat am $2 um $3 Uhr damit begonnen, diese Änderungen zu überprüfen.'''",
	'revreview-adv-reviewing-p' => 'Hinweis: Andere Benutzer werden nun darauf hingewiesen, dass du diese Seite überprüfst.',
	'revreview-adv-reviewing-c' => 'Hinweis: Andere Benutzer werden nun darauf hingewiesen, dass du diese Änderungen überprüfst.',
	'revreview-sadv-reviewing-p' => 'Du kannst andere Benutzer darauf hinweisen, dass du diese Seite $1.',
	'revreview-sadv-reviewing-c' => 'Du kannst andere Benutzer darauf hinweisen, dass du diese Änderungen $1.',
	'revreview-adv-start-link' => 'überprüfst',
	'revreview-adv-stop-link' => 'Hinweis zurücknehmen',
	'revreview-toolow' => "'''Du musst jedes der Attribute besser als „unzureichend“ einstufen, damit eine Version als markiert angesehen werden kann.'''

Um den Markierungstatus einer Version aufzuheben, muss auf „Markierung entfernen“ geklickt werden.

Klicke auf die „Zurück“-Schaltfläche deines Browsers und versuche es erneut.",
	'revreview-update' => "'''Bitte [[{{MediaWiki:Validationpage}}|markiere]] alle Änderungen ''(siehe unten)'', die seit der letzten stabilen Version getätigt wurden.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Deine Änderungen wurden bislang noch nicht als stabile Version gekennzeichnet.</span>

Bitte markiere alle unten angezeigten Änderungen, damit deine Bearbeitungen zur stabilen Version werden.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Deine Änderungen wurden bislang noch nicht als stabile Version gekennzeichnet. Es gibt ältere Bearbeitungen, die noch markiert werden müssen.</span>

Bitte markiere alle unten angezeigten Änderungen, damit deine Bearbeitungen zur stabilen Version werden.',
	'revreview-update-includes' => 'Vorlagen/Dateien wurden aktualisiert (nicht markierte Seiten sind in fett gekennzeichnet):',
	'revreview-reject-text-list' => "Mit Abschluss dieser Aktion {{PLURAL:$1|wird die folgende Änderung|werden die folgenden Änderungen}} an [[:$2|$2]] '''verworfen''':",
	'revreview-reject-text-revto' => 'Dies wird die Seite auf die [{{fullurl:$1|oldid=$2}} Version vom $3] zurücksetzen.',
	'revreview-reject-summary' => 'Zusammenfassung:',
	'revreview-reject-confirm' => 'Diese Änderungen verwerfen',
	'revreview-reject-cancel' => 'Abbrechen',
	'revreview-reject-summary-cur' => 'Die {{PLURAL:$1|letzte Textänderung|$1 letzten Textänderungen}} von $2 {{PLURAL:$1|wurde|wurden}} verworfen und die Version $3 von $4 wiederhergestellt',
	'revreview-reject-summary-old' => 'Die {{PLURAL:$1|erste Textänderung|$1 ersten Textänderungen}} von $2, die auf die Version $3 von $4  {{PLURAL:$1|folgte, wurde|folgten, wurden}} verworfen',
	'revreview-reject-summary-cur-short' => 'Die {{PLURAL:$1|letzte Textänderung wurde|$1 letzten Textänderungen wurden}} verworfen und die Version $2 von $3 wiederhergestellt',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Die erste Textänderung|ersten $1 Textänderungen}}, die auf die Version $2 von $3 {{PLURAL:$1|folgte, wurde|folgten, wurden}} verworfen',
	'revreview-tt-flag' => 'Diese Version akzeptieren, indem du die Änderungen als „überprüft“ markierst',
	'revreview-tt-unflag' => 'Diese Version nicht mehr anzeigen lassen, indem du die Markierung entfernst',
	'revreview-tt-reject' => 'Diese Textänderungen durch Zurücksetzen verwerfen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'review_conflict_oldid' => 'Jemand hat bereits diese Version akzeptiert oder verworfen während Sie sie gelesen haben.',
	'revreview-check-flag-p-title' => 'Alle noch nicht markierten Änderungen, zusammen mit Ihrer Bearbeitung, akzeptieren. Dies sollte nur gemacht werden, sofern bereits alle bislang noch nicht markierten Änderungen angesehen wurden.',
	'revreview-check-flag-y-title' => 'Markieren aller Änderungen, die Sie mit dieser Bearbeitung gemacht haben.',
	'revreview-main' => 'Sie müssen eine Version zur Markierung auswählen.

Siehe die [[Special:Unreviewedpages|Liste unmarkierter Versionen]].',
	'revreview-stable1' => 'Vielleicht möchten Sie [{{fullurl:$1|stableid=$2}} die markierte Version] aufrufen, um zu sehen, ob es nunmehr die [{{fullurl:$1|stable=1}} freigegebene Version] dieser Seite ist?',
	'revreview-stable2' => 'Vielleicht möchten Sie die [{{fullurl:$1|stable=1}} freigegebene Version] dieser Seite sehen?',
	'revreview-adv-reviewing-p' => 'Hinweis: Andere Benutzer werden nun darauf hingewiesen, dass Sie diese Seite überprüfen.',
	'revreview-adv-reviewing-c' => 'Hinweis: Andere Benutzer werden nun darauf hingewiesen, dass Sie diese Änderungen überprüfen.',
	'revreview-sadv-reviewing-p' => 'Sie können andere Benutzer darauf hinweisen, dass Sie diese Seite $1.',
	'revreview-sadv-reviewing-c' => 'Sie können andere Benutzer darauf hinweisen, dass Sie diese Änderungen $1.',
	'revreview-adv-start-link' => 'überprüfen',
	'revreview-toolow' => "'''Sie müssen jedes der Attribute besser als „unzureichend“ einstufen, damit eine Version als markiert angesehen werden kann.'''

Um den Markierungstatus einer Version aufzuheben, muss auf „Markierung entfernen“ geklickt werden.

Klicken Sie auf die „Zurück“-Schaltfläche Ihres Browsers und versuchen Sie es erneut.",
	'revreview-update' => "'''Bitte [[{{MediaWiki:Validationpage}}|überprüfen]] Sie alle Änderungen ''(siehe unten)'', die seit der neuesten freigegebenen Version getätigt wurden.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Ihre Änderungen wurden bislang noch nicht als stabile Version gekennzeichnet.</span>

Bitte markieren Sie alle unten angezeigten Änderungen, damit Ihre Bearbeitungen zur stabilen Version werden.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Ihre Änderungen wurden bislang noch nicht als stabile Version gekennzeichnet. Es gibt ältere Bearbeitungen, die noch markiert werden müssen.</span>

Bitte markieren Sie alle unten angezeigten Änderungen, damit Ihre Bearbeitungen zur stabilen Version werden.',
	'revreview-tt-flag' => 'Diese Version akzeptieren, indem Sie sie als „überprüft“ markieren',
	'revreview-tt-unflag' => 'Diese Version nicht mehr anzeigen lassen, indem Sie die Markierung entfernen',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Mirzali
 * @author Xoser
 */
$messages['diq'] = array(
	'revisionreview' => 'revizyonanê ser çım bıçarn',
	'revreview-failed' => "'''Eno versiyon tedqiq nêbeno.''' Mırecaet ya temam niyo ya zi sewbina nêvêreno.",
	'review_page_invalid' => 'Nameyê pele ya hedefi meqbul niyo.',
	'review_page_notexists' => 'Pele ke hedef biya eka cini ya.',
	'review_page_unreviewable' => 'Pele ke hedef biya eka eka kontrol nibena.',
	'review_no_oldid' => 'Ye kimikê revizyon belli niya.',
	'review_bad_oldid' => 'Revizyon ke hedef biya eka cini ya.',
	'review_too_low' => 'Revizyon kontrol nibena cunki tay cayan "tam niya".',
	'review_bad_key' => 'Tuşê parametre raşt niya.',
	'review_denied' => 'Destur nedano.',
	'review_param_missing' => 'Yew parametrevini biya ya zi raşt niya.',
	'revreview-check-flag-p' => 'Vurnayışanê ke hama cap nibiyê inan kebul ke',
	'revreview-check-flag-p-title' => 'Vurnayişê xo u vurnayişan ke hama kebul nibiya inan kebul bike. Ena xacet teyna şuxulne ci wext ke ti diffê vurnayişê hemi kontrol kerd.',
	'revreview-check-flag-u' => 'Ena pele ke qontrol nibiya ke ay kebul bike',
	'revreview-check-flag-u-title' => 'Versiyon ena pele kebul bike. Ena pele şuxulne eka teyna ena pele temamen diye.',
	'revreview-check-flag-y' => 'Ena vurnayişan kebul bike',
	'revreview-check-flag-y-title' => 'Vurnayişê hemi ke ti ena nuşte de kerde inan qebul bike.',
	'revreview-flag' => 'nop revizyon ser çım bıçarn',
	'revreview-reflag' => 'Enê çımraviyarnayışi qontrol ke',
	'revreview-invalid' => "'''hedefo nemeqbul:''' yew revizyono [[{{MediaWiki:Validationpage}}|konrol biyaye]] zi ID de pê nêgıneni.",
	'revreview-log' => 'beyanat:',
	'revreview-main' => 'qey çım ser çarnayişi, şıma gani pelê muhtewayi ra yew revizyon bıvıcini.

bıewnê [[Special:Unreviewedpages|listeya pelê konrol nêbiyayeyan]].',
	'revreview-stable1' => '[{{fullurl:$1|stableid=$2}} Ena versiyanê nişan biye] bivini, ena pele [{{fullurl:$1|stable=1}} versiyonşê sebiti] eka este ya zi cino bivini.',
	'revreview-stable2' => 'Ena pele de [{{fullurl:$1|stable=1}} versiyonê sebiti] (eka este) ti eşkena bivini.',
	'revreview-submit' => 'bışaw',
	'revreview-submitting' => 'şawiyeno...',
	'revreview-submit-review' => 'Tesdiq ke',
	'revreview-submit-unreview' => 'Tesdiq meke',
	'revreview-submit-reviewed' => 'Temam. Tesdiq bi!',
	'revreview-submit-unreviewed' => 'Temam. Tesdiq nêbi!',
	'revreview-successful' => "'''qey [[:$1|$1]] revizyon bı serkewte işaret bı. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} revizyonê istiqarınan bıvin])'''",
	'revreview-successful2' => "'''qey [[:$1|$1]] işaretê revizyoni bı serkewte wera diya.'''",
	'revreview-toolow' => "'''Ti gani her nitelikan \"tam niya\" zafyer rate bike ke seba revizyon gani qontrol bibo.'''

Seba statuyê qontroli wedarnayişi, eyaranê ''hemi'' her ca de \"tam niya\" bike.

Ma rica keni \"peyser\" şu ra klik bike reyna deneme bike.",
	'revreview-update' => "'''Kerem ke, vurnayışanê teberi pêro ''(cêr mocniyenê)'' [[{{MediaWiki:Validationpage}}|tekrar bıvêne]] heta ke verziyono qayım vıraciya.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Vurnayişanê tu hama zerrê versiyonê sebiti de niya.</span>

Ma rica keni vurnayişanê xo peran versiyonê sebit biki bade kontrolê vurnayişi.
Ti belki tewr verni de vurnayişan teqib biki ya zi "peyser biyeri".',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Vurnayişanê tu hama zerrê versiyonê sebiti de niya. Hama vurnayişanê binan ho sira de.</span>

Ma rica keni vurnayişanê xo peran versiyonê sebit biki bade kontrolê vurnayişi.
Ti belki tewr verni de vurnayişan teqib biki ya zi "peyser biyeri".',
	'revreview-update-includes' => 'Şabloni/dosyey biy rocaney (pelê etudkerdey qalındê):',
	'revreview-tt-flag' => '"Qontrol" nişan bike ke ena revizyon qebul bike',
	'revreview-tt-unflag' => '"Qontrol nibiyo" nişan bike ke ena revizyon qebul meke',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'revisionreview' => 'wersije pśespytowaś',
	'revreview-failed' => "'''Njejo móžno toś tu wersiju pśeglědaś.'''",
	'revreview-submission-invalid' => 'Toś to wótpósłanje jo njedopołne było abo hynacej njepłaśiwe.',
	'review_page_invalid' => 'Titel celowego boka jo njepłaśiwy.',
	'review_page_notexists' => 'Celowy bok njeeksistěrujo.',
	'review_page_unreviewable' => 'Celowy bok njejo pśeglědujobny',
	'review_no_oldid' => 'Žeden wersijowy ID pódany.',
	'review_bad_oldid' => 'Celowa wersija njeeksistěrujo.',
	'review_conflict_oldid' => 'Něchten jo toś tu wersiju akceptěrował abo wótpokazał, gaž sy se ju woglědał.',
	'review_not_flagged' => 'Celowa wersija njejo tuchylu ako pśeglědana markěrowana.',
	'review_too_low' => 'Wersija njedajo se pśeglědowaś, tak dłujko ako někotare póla su hyšći "njepśiměrjone".',
	'review_bad_key' => 'Njepłaśiwy kluc zapśimjeśowego parametra.',
	'review_bad_tags' => 'Někotare pódanych znamjenjow su njepłaśiwe.',
	'review_denied' => 'Pšawo wótpokazane.',
	'review_param_missing' => 'Parameter felujo abo jo njepłaśiwy.',
	'review_cannot_undo' => 'Toś te změny njedaje so anulěrowaś, dokulaž dalšne njedocynjone změny su te same wobcerki změnili.',
	'review_cannot_reject' => 'Toś te změny njedaju se wótpokazaś, dokulaž něchten jo južo akceptěrował někotare (abo wšykne) změny.',
	'review_reject_excessive' => 'Tak wjele změnow njedajo se naraz wótpokazaś.',
	'review_reject_nulledits' => 'Toś te změny njamógu se wótpokazaś, dokulaž wšykne toś te wersije njewopśimuju žedne změny.',
	'revreview-check-flag-p' => 'Toś tu wersiju akceptěrowaś (wopśimujo $1 {{PLURaL:$1|njedocynjonu změnu|njedocynjonej změnje|njedocynjone změny|njedocynjonych změnow}})',
	'revreview-check-flag-p-title' => 'Wšykne tuchylu njepśeglědane změny gromaźe ze swójsku změnu akceptěrowaś.
Wužywaj to jano, jolic sy južo wšykne njepśeglědane změny wiźeł.',
	'revreview-check-flag-u' => 'Toś ten njepśeglědany bok akceptěrowaś',
	'revreview-check-flag-u-title' => 'Akceptěruj toś tu wersiju boka. Wužyj ju jano, jolic sy južo ceły bok wiźeł.',
	'revreview-check-flag-y' => 'Toś te změny akceptěrowaś',
	'revreview-check-flag-y-title' => 'Wšykne změny akceptěrowaś, kótarež sy cynił pśi toś tom wobźěłanju.',
	'revreview-flag' => 'Toś tu wersiju pśespytowaś',
	'revreview-reflag' => 'Toś tu wersiju znowego pśeglědaś',
	'revreview-invalid' => "'''Njepłaśiwy cel:''' žedna [[{{MediaWiki:Validationpage}}|pśeglědana]] wersija njewótpowědujo danemu ID.",
	'revreview-log' => 'Komentar:',
	'revreview-main' => 'Musyš jadnotliwu wersiju wopśimjeśowego boka za pśeglědanje wubraś.

Glědaj [[Special:Unreviewedpages|lisćinu njepśeglědanych bokow]].',
	'revreview-stable1' => 'Snaź coš se [{{fullurl:$1|stableid=$2}} toś tu markěrowanu wersiju] woglědaś a wiźeś, lěc jo něnto [{{fullurl:$1|stable=1}} wózjawjona wersija] toś togo boka.',
	'revreview-stable2' => 'Snaź coš se [{{fullurl:$1|stable=1}} wózjawjonu wersiju] toś togo boka woglědaś.',
	'revreview-submit' => 'Wótpósłaś',
	'revreview-submitting' => 'Wótpósćeła se...',
	'revreview-submit-review' => 'Wersiju akceptěrowaś',
	'revreview-submit-unreview' => 'Wersiju wótpokazaś',
	'revreview-submit-reject' => 'Změny wótpokazaś',
	'revreview-submit-reviewed' => 'Gótowo. Pśizwólony!',
	'revreview-submit-unreviewed' => 'Gótowo. Pśizwólenje zajmjone!',
	'revreview-successful' => "'''Wersija nastawka [[:$1|$1]] jo se wuspěšnje markěrowała. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} stabilne wersije se woglědaś])'''",
	'revreview-successful2' => "'''Markěrowanje [[:$1|$1]] jo se wuspěšnje wótpórało.'''",
	'revreview-poss-conflict-p' => "'''Warnowanje: [[User:$1|$1]] jo zachopił toś ten bok $2, $3 pśeglědaś.'''",
	'revreview-poss-conflict-c' => "'''Warnowanje: [[User:$1|$1]] jo zachopił toś te změny $2, $3 pśeglědaś.'''",
	'revreview-adv-reviewing-p' => 'Glědaj: Druge pśeglědarje mógu wiźeś, až pśeglědujoš toś ten bok.',
	'revreview-adv-reviewing-c' => 'Glědaj: Druge pśeglědarje mógu wiźeś, až pśeglědujoš toś te změny.',
	'revreview-sadv-reviewing-p' => 'Móžoš drugich wužywarjow na to $1, až pśeglědujoš toś ten bok.',
	'revreview-sadv-reviewing-c' => 'Móžoš sam drugich wužywarjow $1, až pśeglědujoš toś te změny.',
	'revreview-adv-start-link' => 'dopomnjeś',
	'revreview-adv-stop-link' => 'wěcej njedopomnjeś',
	'revreview-toolow' => '\'\'\'Musyš nanejmjenjej kuždy z atributow wušej ako "njepśiměrjony" pógódnośiś, aby wersija płaśeła ako pśeglědana.\'\'\'

Aby pśeglědowański status wersije wótpórał, klikni na  "wótpokazaś".

Pšosym klikni na tłocašk "Slědk" w swójom wobglědowaku a wopytaj hyšći raz.',
	'revreview-update' => "'''Pšosym [[{{MediaWiki:Validationpage}}|pśeglědaj]] ''(slědujuce)'' njepśeglědane změny, kótarež su se na akceptěrowanej wersiji pśewjedli.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Twóje změny hyšći njejsu w stabilnej wersiji.</span>

Pšosym pśeglědaj wšykne slědujuce změny, aby se twóje změny w stabilnej wersiji pokazowali.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Twóje změny hyšći njejsu w stabilnej wersiji. Su hyšći njepśeglědane změny.</span>

Pšosym pśeglědaj wšykne slědujuce změny, aby je w stabilnej wersiji pokazali.',
	'revreview-update-includes' => 'Pśedłogi/dataje su se zaktualizěrowali (njepśeglědane boki su tucnje wóznamjenjone):',
	'revreview-reject-text-list' => "Jolic pśewjeźoš toś tu akciju, buźoš {{PLURAL:$1|slědujucu wersiju|slědujucej wersiju|slědujuce wersije|slědujuce wersije}} [[:$2|$2]] '''wótpokazowaś''':",
	'revreview-reject-text-revto' => 'To buźo bok na [{{fullurl:$1|oldid=$2}} wersiju dnja $3] slědk stajaś.',
	'revreview-reject-summary' => 'Zespominanje:',
	'revreview-reject-confirm' => 'Toś te změny wótpokazaś',
	'revreview-reject-cancel' => 'Pśetergnuś',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Slědna tekstowa změna|$1 slědnej tekstowej změnje|$1 slědne tekstowe změny|$1 slědnych změnow}} (wót $2) {{PLURAL:$1|jo se wótpokazała|stej se wótpokazałej|su se wótpokazali|jo se wótpokazało}} a wersija $3 wót $4 jo se wótnowiła.',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Prědna tekstowa změna|$1 prědnej tekstowej změnje|$1 prědne tekstowe změny|$1 prědnych tekstowych změnow}} (wót $2), {{PLURAL:$1|kótaraž|kótarejž|kótarež|kótarež}} {{PLURAL:$1|jo slědowała|stej slědowałej|su slědowali|jo slědowało}} wersiji $3 wót $4, {{PLURAL:$1|jo se wótpokazała|stej se wótpokazałej|su se wótpokazali|jo se wótpokazało}}.',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Sledna tekstowa změna|$1 slědnej tekstowej změnje|$1 slědne tekstowe změny|$1 slědnych tekstowych změnow}} {{PLURAL:$1|jo se wótpokazała|stej se wótpokazałej|su se wótpokazali|jo se wótpokazało}} a wersija $2 wót $3 jo se wótnowiła.',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Prědna tekstowa změna|$1 prědnej tekstowej změnje|$1 prědne tekstowe změny|$1 prědnych tekstowych změnow}} {{PLURAL:$1|jo se wótpokazała|stej se wótpokazałej|su se wótpokazali|jo se wótpokazało}}, {{PLURAL:$1|kótaraž|kótarejž|kótarež|kótarež}} {{PLURAL:$1|jo slědowała|stej slědowałej|su slědowali|jo slědowało}} wersiji $2 wót $3',
	'revreview-tt-flag' => 'Toś tu wersiju pśez markěrowanje ako pśekontrolěrowanu pśizwóliś',
	'revreview-tt-unflag' => 'Toś tu wersiju pśez jeje markěrowanje ako "njepśekontrolěrowanu" wótpokazaś',
	'revreview-tt-reject' => 'Toś te změny žrědłowego teksta pśez slědkstajanje wótpokazaś',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Dead3y3
 * @author Glavkos
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'revisionreview' => 'Κριτική αναθεωρήσεων',
	'revreview-failed' => 'Η επιθεώρηση απέτυχε!',
	'revreview-submission-invalid' => 'Η υποβολή ήταν ελλιπής  ή άλλως άκυρη.',
	'review_page_invalid' => 'Ο τίτλος της σελίδας προορισμού δεν είναι έγκυρος.',
	'review_page_notexists' => 'Η σελίδα προορισμού δεν υπάρχουν.',
	'review_page_unreviewable' => 'Η σελίδα προορισμού δεν είναι επανεξετάσιμη.',
	'review_no_oldid' => 'Δεν καθορίστηκε Ταυτότητα έκδοσης.',
	'review_bad_oldid' => 'Ο στόχος έκδοσης δεν υπάρχει.',
	'review_conflict_oldid' => 'Κάποιος έχει ήδη κάνει αποδεκτή ή μη αποδεκτή αυτή την αναθεώρηση, ενώ τη βλέπατε.',
	'review_denied' => 'Δεν έχετε δικαίωμα πρόσβασης.',
	'review_param_missing' => 'Μια παράμετρος λείπει ή δεν είναι έγκυρη.',
	'review_reject_excessive' => 'Δεν είναι δυνατό να απορριφθούν τόσο πολλές επεξεργασίες με τη μια.',
	'revreview-check-flag-u' => 'Αποδοχή αυτής της μη ελεγμένης σελίδας',
	'revreview-check-flag-y' => 'Αποδοχή των αλλαγών μου',
	'revreview-check-flag-y-title' => 'Αποδοχή όλων των αλλαγών που έχετε κάνει εδώ.',
	'revreview-flag' => 'Επιθεώρησε αυτή την τροποποίηση',
	'revreview-reflag' => 'Αναίρεση επισκόπησης αυτής της έκδοσης',
	'revreview-log' => 'Σχόλιο:',
	'revreview-submit' => 'Υποβολή',
	'revreview-submitting' => 'Υποβολή ...',
	'revreview-submit-review' => 'Σήμανση ως επισκοπημένο',
	'revreview-submit-unreview' => 'Σήμανση ως μη επισκοπημένο',
	'revreview-submit-reject' => 'Απόρριψη αλλαγών',
	'revreview-submit-reviewed' => 'Έγινε. Αποδεκτή!',
	'revreview-submit-unreviewed' => 'Έγινε. Μη αποδεκτή!',
	'revreview-reject-summary' => 'Σύνοψη:',
	'revreview-reject-confirm' => 'Απόρριψη αυτών των αλλαγών',
	'revreview-reject-cancel' => 'Ακύρωση',
	'revreview-tt-reject' => 'Απορρίψετε αυτές τις αλλαγές κειμένου πηγής  με αναστροφή τους',
);

/** Esperanto (Esperanto)
 * @author AVRS
 * @author ArnoLagrange
 * @author Yekrats
 */
$messages['eo'] = array(
	'revisionreview' => 'Kontroli versiojn',
	'revreview-failed' => "'''Ne povas kontroli ĉi tiun revizion.'''",
	'revreview-submission-invalid' => 'La enigo estis malkompleta aŭ alimaniere malvalida.',
	'review_page_invalid' => 'La cela paĝtitolo estas malvalida.',
	'review_page_notexists' => 'La cela paĝo ne ekzistas.',
	'review_page_unreviewable' => 'La cela paĝo ne estas kontrolebla.',
	'review_no_oldid' => 'Mankas identigo de revizio.',
	'review_bad_oldid' => 'La cela revizio ne ekzistas.',
	'review_conflict_oldid' => 'Iu jam akceptis aŭ malakceptis ĉi tiun revizion dum vi legis ĝin.',
	'review_not_flagged' => 'La cela revizio ne estas nuntempe markita kiel reviziita.',
	'review_too_low' => 'Revizio ne povas esti reviziita kun kelkaj kampoj lasita kiel "maladekvata".',
	'review_bad_key' => 'Malvalida ŝlosilo de inkluziva parametro.',
	'review_bad_tags' => 'Iom da la petitaj etikedvaloroj estas malvalida.',
	'review_denied' => 'Malpermesita.',
	'review_param_missing' => 'Parametro mankas aŭ estas malvalida.',
	'review_cannot_undo' => 'Ne povas malfari ĉi tiujn ŝanĝojn ĉar aliaj forataj redaktoj ŝanĝis la samajn partojn.',
	'review_cannot_reject' => 'Ne povas malakcepti ĉi tiujn ŝanĝojn ĉar iu jam akceptis iom (aŭ ĉiom) da la redaktoj.',
	'review_reject_excessive' => 'Ne povas malaprobi ĉi tiom de redaktoj samtempe.',
	'review_reject_nulledits' => 'Ne eblas forrifuzi ĉi tiujn ŝanĝojn ĉar ĉiuj revizioj estas nulaj redaktoj.',
	'revreview-check-flag-p' => 'Aprobi ĉi tiun version (kiu inkluzivas {{PLURAL:$1|unu kontrolendan ŝanĝon|$1 kontrolendajn ŝanĝojn}})',
	'revreview-check-flag-p-title' => 'Aprobi ĉiom da la kontrolendaj ŝanĝoj kune kun via propra redakto. Nur uzu ĉi tiun se vi jam vidis la tutan diferencon de kontrolendaj ŝanĝoj.',
	'revreview-check-flag-u' => 'Akcepti ĉi tiun ne jam reviziitan paĝon',
	'revreview-check-flag-u-title' => 'Aprobi ĉi tiun version de la paĝo. Nur uzu ĉi tiun se vi jam vidis la tutan paĝon.',
	'revreview-check-flag-y' => 'Validigi ĉi tiujn ŝanĝojn',
	'revreview-check-flag-y-title' => 'Aprobi ĉiujn ŝanĝoj tiujn vi faris ĉi tie.',
	'revreview-flag' => 'Marki ĉi tiun version',
	'revreview-reflag' => 'Rekontroli ĉi tiun redakton',
	'revreview-invalid' => "'''Malvalida celo:''' neniu [[{{MediaWiki:Validationpage}}|kontrolita]] versio kongruas la enigitan identigon.",
	'revreview-log' => 'Komento:',
	'revreview-main' => 'Vi devas elekti apartan version de enhava paĝo por revizii.

Vidu la [[Special:Unreviewedpages|liston de nereviziitaj paĝoj]] .',
	'revreview-stable1' => 'Eble vi volas rigardi [{{fullurl:$1|stableid=$2}} la ĵus markitan version] por vidi, ĉu ĝi nun estas la [{{fullurl:$1|stable=1}} publikigita versio] de ĉi tiu paĝo.',
	'revreview-stable2' => 'Eble vi volas rigardi la [{{fullurl:$1|stable=1}} publikigitan version] de ĉi tiu paĝo.',
	'revreview-submit' => 'Konservi',
	'revreview-submitting' => 'Sendante...',
	'revreview-submit-review' => 'Aprobi revizion',
	'revreview-submit-unreview' => 'Malaprobi revizion',
	'revreview-submit-reject' => 'Malaprobi ŝanĝojn',
	'revreview-submit-reviewed' => 'Farite. Aprobita!',
	'revreview-submit-unreviewed' => 'Farita. Malaprobita!',
	'revreview-successful' => "'''Tiu ĉi versio de [[:$1|$1]] estas markita kiel reviziita. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} vidi ĉiujn markitajn versiojn])'''",
	'revreview-successful2' => "'''Versio de [[:$1|$1]] sukcese malmarkita.'''",
	'revreview-poss-conflict-p' => "'''Atentu: [[User:$1|$1]] ekkontrolis ĉi tiun paĝon je $2 $3.'''",
	'revreview-poss-conflict-c' => "'''Atentu: [[User:$1|$1]] ekkontrolis ĉi tiujn paĝojn je $2 $3.'''",
	'revreview-adv-reviewing-p' => 'Notu: aliaj reviziantoj povas vidi ke vi revizias ĉi tiun paĝon.',
	'revreview-adv-reviewing-c' => 'Notu: aliaj reviziantoj povas vidi ke vi revizias ĉi tiujn ŝanĝojn.',
	'revreview-sadv-reviewing-p' => 'Vi povas $1 al aliaj uzantoj ke vi revizias ĉi tiun paĝon.',
	'revreview-sadv-reviewing-c' => 'Vi povas $1 al aliaj uzantoj ke vi revizias ĉi tiujn ŝanĝojn.',
	'revreview-adv-start-link' => 'anonci',
	'revreview-adv-stop-link' => 'malanonci',
	'revreview-toolow' => '\'\'\'Vi devas taksi ĉiun el la jenaj atribuoj almenaŭ pli alta ol "adekvata" por revizio esti konsiderata kiel kontrolita.\'\'\'

Forigi reviziatan statuson de revizio, klaku "malaprobi".

Bonvolu klaki la "reiri" butonon en via retumilo kaj reprovu.',
	'revreview-update' => "Bonvolu [[{{MediaWiki:Validationpage}}|kontroli]] iujn kontrolendajn ŝanĝojn ''(montritajn suben)'' faritajn ekde la aprobita versio:'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Viaj ŝanĝoj ankoraŭ ne estas en la stabila versio.</span>

Bonvolu kontroli ĉiujn jenajn ŝanĝojn por aperigi viajn redaktojn en la stabila versio.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Viaj ŝanĝoj ankoraŭ ne estas en la stabila versio. Ekzistas antaŭaj kontrolendaj ŝanĝoj.</span>

Bonvolu kontroli ĉiujn jenajn ŝanĝojn por aperigi viajn redaktojn en la stabila versio.',
	'revreview-update-includes' => 'Ŝablonoj/dosieroj estis ĝisdatigitaj (nekontrolitaj paĝoj estas dikigitaj):',
	'revreview-reject-text-list' => "Farante ĉi tiun agon, vi '''malaprobos''' la informofontaj ŝanĝoj de la {{PLURAL:$1|jenan revizion|jenajn reviziojn}} de [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Tio ĉi restarigos la paĝon al la [{{fullurl:$1|oldid=$2}} versio ekde $3].',
	'revreview-reject-summary' => 'Resumo:',
	'revreview-reject-confirm' => 'Malaprobi ĉi tiujn ŝanĝojn',
	'revreview-reject-cancel' => 'Nuligi',
	'revreview-reject-summary-cur' => 'Malaprobis la {{PLURAL:$1|lastan tekstan ŝanĝon|$1 lastajn tekstajn ŝanĝojn}} (de $2) kaj restarigis revizion $3 de $4',
	'revreview-reject-summary-old' => 'Malaprobis la {{PLURAL:$1|unuan tekstan ŝanĝon, kiu|unuajn $1 tekstajn ŝanĝojn, kiuj}} (de $2) sekvante revizion $3 de $4',
	'revreview-reject-summary-cur-short' => 'Malaprobis la {{PLURAL:$1|lastan tekstan ŝanĝon|$1 lastajn tekstajn ŝanĝojn}} kaj restarigis revizion $2 de $3',
	'revreview-reject-summary-old-short' => 'Malaprobis la {{PLURAL:$1|unuan tekstan ŝanĝon, kiu|unuajn tekstajn $1 ŝanĝojn, kiuj}} sekvante revizion $2 de $3',
	'revreview-tt-flag' => 'Aprobi ĉi tiun revizion per markado kontrolita',
	'revreview-tt-unflag' => 'Malaprobi ĉi tiun revizion per markado "ne-kontrolita"',
	'revreview-tt-reject' => 'Malaprobi ĉi tiujn ŝanĝojn de informo-fontoj, malfarante ilin',
);

/** Spanish (Español)
 * @author Armando-Martin
 * @author Crazymadlover
 * @author Dferg
 * @author Drini
 * @author Fitoschido
 * @author Imre
 * @author Jurock
 * @author Locos epraix
 * @author MetalBrasil
 * @author Mor
 * @author Translationista
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'revisionreview' => 'Revisar versiones',
	'revreview-failed' => "'''No se pudo revisar esta versión.'''",
	'revreview-submission-invalid' => 'El envío estaba incompleto o era inválido',
	'review_page_invalid' => 'El título de página destino es inválida.',
	'review_page_notexists' => 'La página destino no existe.',
	'review_page_unreviewable' => 'La página destino no es revisable.',
	'review_no_oldid' => 'Ningún ID de revisión especificado.',
	'review_bad_oldid' => 'No hay tal revisión de objetivo.',
	'review_conflict_oldid' => 'Alguien ya ha aceptado o rechazado esta revisión mientras la leías',
	'review_not_flagged' => 'La revisión de destino no está marcada como revisada.',
	'review_too_low' => 'La revisión no puede ser revisada con algunos campos dejados "inadecuados".',
	'review_bad_key' => 'Clave de parámetro de inclusión inválido.',
	'review_bad_tags' => 'Algunos de los valores de las variables especificadas son válidas.',
	'review_denied' => 'Permiso denegado.',
	'review_param_missing' => 'Un parámetro está perdido o es inválido.',
	'review_cannot_undo' => 'No es posible deshacer estos cambio, ya que otras ediciones pendientes han cambiado estas áreas.',
	'review_cannot_reject' => 'No se pudo rechazar estos cambios porque alguien aceptó algunas (o todas) las modificaciones.',
	'review_reject_excessive' => 'No se puede rechazar esta cantidad de modificaciones a la vez.',
	'review_reject_nulledits' => 'No se puede rechazar estos cambios, porque todas las revisiones son nulas modificaciones.',
	'revreview-check-flag-p' => 'Aceptar esta versión (incluye {{PLURAL:$1|un cambio pendiente|$1 cambios pendientes}})',
	'revreview-check-flag-p-title' => 'Aceptar todos los cambios actualmente pendientesjunto con tu propia edición.
Solamente usar esto si ya has visto por completo las diferencias de los cambios pendientes.',
	'revreview-check-flag-u' => 'Aceptar esta página sin revisar',
	'revreview-check-flag-u-title' => 'Aceptar esta versión de la página. Solamente usa esto si ya has visto la página completa.',
	'revreview-check-flag-y' => 'Aceptar esos cambios',
	'revreview-check-flag-y-title' => 'Aceptar todos los cambios que ha realizado en esta edición.',
	'revreview-flag' => 'Verificar esta revisión',
	'revreview-reflag' => 'Volver a verificar esta revisión',
	'revreview-invalid' => "'''Destino inválido:''' no hay  [[{{MediaWiki:Validationpage}}|versión revisada]] que corresponda a tal ID.",
	'revreview-log' => 'Comentario:',
	'revreview-main' => 'Debes seleccionar una revisión particular de una página de contenido para verificar.

Mira la [[Special:Unreviewedpages|lista de páginas no revisadas]].',
	'revreview-stable1' => 'Puedes desear ver [{{fullurl:$1|stableid=$2}} esta versión verificada] y ver si esta es ahora la [{{fullurl:$1|stable=1}} versión publicada]',
	'revreview-stable2' => 'Puedes desear ver la [{{fullurl:$1|stable=1}} versión publicada] de esta página.',
	'revreview-submit' => 'Enviar',
	'revreview-submitting' => 'Enviando...',
	'revreview-submit-review' => 'Aceptar versión',
	'revreview-submit-unreview' => 'Desaprobar versión',
	'revreview-submit-reject' => 'Rechazar los cambios',
	'revreview-submit-reviewed' => 'Hecho. Aceptado.',
	'revreview-submit-unreviewed' => 'Hecho. Desaprobado.',
	'revreview-successful' => "'''La versión de [[:$1|$1]] ha sido marcada correctamente. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} ver versiones estables])'''",
	'revreview-successful2' => "'''Se ha desmarcado la revisión de [[:$1|$1]] correctamente.'''",
	'revreview-poss-conflict-p' => "'''Aviso: [[User:$1|$1]] empezó a revisar esta página el $2 a las $3.'''",
	'revreview-poss-conflict-c' => "'''Aviso: [[User:$1|$1]] empezó a revisar estos cambios el $2 a las $3.'''",
	'revreview-adv-reviewing-p' => 'Aviso: Otros revisores pueden ver que usted está revisando esta página.',
	'revreview-adv-reviewing-c' => 'Aviso: Otros revisores pueden ver que usted está revisando estos cambios.',
	'revreview-sadv-reviewing-p' => 'Usted puede $1 a usted mismo como revisor de esta página a otros usuarios.',
	'revreview-sadv-reviewing-c' => 'Usted puede $1 a usted mismo como revisor de esta página a otros usuarios.',
	'revreview-adv-start-link' => 'anunciar',
	'revreview-adv-stop-link' => 'anular la publicidad',
	'revreview-toolow' => "'''Debes valorar cada uno de los atributos más alto que \"inadecuado\" para que la revisión sea considerada verificada.'''

Para quitar el estado de verificación de una revisión, clic \"no aceptar\".

Por favor presiona el botón ''atrás'' en tu navegador e intentalo de nuevo.",
	'revreview-update' => "'''Por favor,[[{{MediaWiki:Validationpage}}|revisa]] los cambios pendientes ''(que se muestran a continuación)'' hechos en la versión aceptada.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Tus cambios aún no han sido incorporados en la versión estable.</span>

Por favor revisa todos los cambios mostrados debajo para hacer que tus ediciones aparezcan en la versión estable.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Tus cambios no está en la versión estable aún. Hay ediciones previas pendientes de ser revisadas.</span>

Por favor, revisa todos los cambios mostrados a continuación para que se acepten tus ediciones.',
	'revreview-update-includes' => 'Plantilla/archivos actualizados (páginas sin revisar en negrita):',
	'revreview-reject-text-list' => "Al completar esta acción, estarás '''rechazando''' los cambios del texto fuente de las siguientes {{PLURAL:$1|revisión|revisiones}} de [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'La página será revertida a su [{{*fullurl:$1|*oldid=$2}} versión de $3].',
	'revreview-reject-summary' => 'Resumen:',
	'revreview-reject-confirm' => 'Rechazar estos cambios',
	'revreview-reject-cancel' => 'Cancelar',
	'revreview-reject-summary-cur' => 'Rechazados los últimos {{PLURAL:$1|cambio de texto|$1 cambios de texto}} (por $2) y restaurada la revisión $3 de $4.',
	'revreview-reject-summary-old' => 'Rechazados los primeros {{PLURAL:$1|cambio de texto|$1 cambios de texto}} (de $2) que seguían a la revisión $3 de $4.',
	'revreview-reject-summary-cur-short' => 'Rechazados los últimos {{PLURAL:$1|cambio de texto|$1 cambios de texto}} y restaurada la revisión $2 de $3',
	'revreview-reject-summary-old-short' => 'Rechazados los primeros {{PLURAL:$1|cambio de texto|$1 cambios de texto}} que seguían la revisión $2 de $3',
	'revreview-tt-flag' => 'Aprobar esta revisión marcándola como revisada',
	'revreview-tt-unflag' => 'Desaprobar esta revisión marcándola como "no-verificada"',
	'revreview-tt-reject' => 'Rechazar estos cambios del texto fuente revirtiendolos',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'revisionreview' => 'Redaktsioonide ülevaatus',
	'revreview-failed' => "'''Seda redaktsiooni ei õnnestu üle vaadata.'''",
	'revreview-submission-invalid' => 'Esitamine oli puudulik või muul moel vigane.',
	'review_page_invalid' => 'Sihtlehekülje pealkiri on vigane.',
	'review_page_notexists' => 'Sihtlehekülge pole olemas.',
	'review_page_unreviewable' => 'Sihtlehekülge pole ülevaadatav.',
	'review_no_oldid' => 'Redaktsiooni ID pole määratud.',
	'review_bad_oldid' => 'Sellist sihtredaktsiooni pole.',
	'review_not_flagged' => 'Sihtredaktsioon pole praegu ülevaadatuks märgitud.',
	'review_too_low' => 'Jättes mõnele väljale väärtuse "ebarahuldav", ei saa redaktsiooni ülevaadatuks märkida.',
	'review_denied' => 'Luba tagasi lükatud.',
	'review_param_missing' => 'Parameeter puudub või on vigane.',
	'revreview-check-flag-p' => 'Kiida see redaktsioon heaks (sisaldab {{PLURAL:$1|üht|$1}} ootel muudatust)',
	'revreview-check-flag-p-title' => 'Kiida kõik praegu ootel olevad muudatused heaks, kaasa arvatud su enda muudatus. Kasuta seda ainult siis, kui oled juba kõiki erinevusi ootel muudatuste ja püsiva versiooni vahel näinud.',
	'revreview-check-flag-u' => 'Kiida see ülevaatamata lehekülg heaks',
	'revreview-check-flag-u-title' => 'Kiida käesolev lehekülje versioon heaks. Kasuta seda ainult siis, kui oled juba kogu lehekülge näinud.',
	'revreview-check-flag-y' => 'Kiida need muudatused heaks',
	'revreview-check-flag-y-title' => 'Kiida kõik enda tehtud muudatused selles redaktsioonis heaks.',
	'revreview-flag' => 'Redaktsiooni ülevaatamine',
	'revreview-invalid' => "'''Vigane sihtkoht:''' antud ID-le ei vasta ükski [[{{MediaWiki:Validationpage}}|ülevaadatud]] redaktsioon.",
	'revreview-log' => 'Kommentaar:',
	'revreview-main' => 'Selleks üle vaadata, pead valima sisulehekülje kindla redaktsiooni.

Vaata [[Special:Unreviewedpages|ülevaatamata lehekülgede loendit]].',
	'revreview-stable1' => 'Ehk tahad vaadata, kas [{{fullurl:$1|stableid=$2}} see vaadatud versioon] on praegu selle lehekülje [{{fullurl:$1|stable=1}} püsiv versioon]?',
	'revreview-stable2' => 'Võib-olla tahad vaadata [{{fullurl:$1|stable=1}} püsivat versiooni] sellest leheküljest.',
	'revreview-submit' => 'Esita',
	'revreview-submitting' => 'Esitan...',
	'revreview-submit-review' => 'Kiida redaktsioon heaks',
	'revreview-submit-unreview' => 'Lükka redaktsioon tagasi',
	'revreview-submit-reviewed' => 'Tehtud ja heaks kiidetud!',
	'revreview-submit-unreviewed' => 'Tehtud ja tagasi lükatud!',
	'revreview-successful' => "'''Lehekülje [[:$1|$1]] redaktsioon edukalt vaadatud. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} vaata ülevaadatud versioone])'''",
	'revreview-successful2' => "'''Lehekülje [[:$1|$1]] redaktsioonilt vaatamismärkus edukalt eemaldatud.'''",
	'revreview-poss-conflict-p' => "'''Hoiatus: [[User:$1|$1]] hakkas seda lehekülge üle vaatama ($2, kell $3).'''",
	'revreview-poss-conflict-c' => "'''Hoiatus: [[User:$1|$1]] hakkas neid muudatusi üle vaatama ($2, kell $3).'''",
	'revreview-adv-reviewing-p' => 'Märkus: Teised ülevaatajad näevad, et seda lehekülge üle vaatad.',
	'revreview-adv-reviewing-c' => 'Märkus: Teised ülevaatajad näevad, et neid muudatusi üle vaatad.',
	'revreview-sadv-reviewing-p' => 'Saad teistele kasutajatele $1, et vaatad seda lehekülge üle.',
	'revreview-sadv-reviewing-c' => 'Saad teistele kasutajatele $1, et vaatad neid muudatusi üle.',
	'revreview-adv-start-link' => 'teatada',
	'revreview-adv-stop-link' => 'jäta teatamata',
	'revreview-toolow' => '\'\'\'Lehekülje ülevaadatuks arvamiseks pead hindama kõiki tunnuseid kõrgemini kui "ebarahuldav".\'\'\'

Redaktsioonilt ülevaadatu seisundi eemaldamiseks klõpsa "lükka tagasi".

Palun klõpsa oma võrgulehitseja "Tagasi"-nuppu ja proovi uuesti.',
	'revreview-update' => "'''Palun [[{{MediaWiki:Validationpage}}|vaata üle]] kõik alates püsivast versioonist tehtud ootel muudatused ''(näidatud allpool)''.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Sinu muudatused pole veel püsivas versioonis.</span>

Oma muudatuste püsivas versioonis kuvamiseks vaata palun kõik allpool näidatud muudatused üle.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Sinu muudatused pole veel püsivas versioonis. Osa varasemaid muudatusi ootab ülevaatamist.</span>

Oma muudatuste püsivas versioonis kuvamiseks vaata palun kõik allpool näidatud muudatused üle.',
	'revreview-update-includes' => 'Malle või faile on uuendatud (ülevaatamata leheküljed rasvaselt):',
	'revreview-reject-summary' => 'Resümee:',
	'revreview-reject-cancel' => 'Loobu',
	'revreview-tt-flag' => 'Kiida see redaktsioon heaks, märkides selle kui "kord vaadatud"',
	'revreview-tt-unflag' => 'Lükka see redaktsioon tagasi, märkides selle kui "kord vaatamata"',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'revreview-log' => 'Iruzkina:',
	'revreview-submit' => 'Bidali',
	'revreview-submitting' => 'Bidaltzen...',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Ladsgroup
 * @author Mjbmr
 * @author Sahim
 * @author Wayiran
 */
$messages['fa'] = array(
	'revisionreview' => 'نسخه‌های بررسی',
	'revreview-failed' => "''امکان بازبینی این نسخه وجود ندارد.'''",
	'revreview-submission-invalid' => 'فرآیند ناقض انجام شد یا به عنوان دیگر نامعتبر است.',
	'review_page_invalid' => 'عنوان صفحهٔ مقصد نامعتبر است.',
	'review_page_notexists' => 'صفحهٔ مقصد وجود ندارد.',
	'review_page_unreviewable' => 'صفحهٔ مقصد بازبین‌پذیر نیست.',
	'review_no_oldid' => 'شناسهٔ هیچ نسخه‌ای مشخص نشده است.',
	'review_bad_oldid' => 'نسخهٔ مقصد وجود ندارد.',
	'review_conflict_oldid' => 'در هنگام مشاهده این نسخه، شخص دیگری آن را رد کرده و یا پذیرفته است.',
	'review_not_flagged' => 'نسخهٔ مقصد تاکنون به عنوان بازبینی‌شده علامت‌گذاری نشده است.',
	'review_too_low' => 'در حالی که برخی فیلدها «نابسنده» رها شده‌اند، نمی‌توان نسخه را بازبینی کرد.',
	'review_bad_key' => 'کلید پارامتر گنجایش نامعتبر.',
	'review_bad_tags' => 'برخی از مقادیر مشخص شده برچسب نامعتبر هستند.',
	'review_denied' => 'اجازه داده نشد.',
	'review_param_missing' => 'یک پارامتر وارد نشده یا نادرست وارد شده‌است',
	'review_cannot_undo' => 'نمی‌توان این تغییرات را خنثی کرد چرا که ویرایش‌های دیگری در انتظار است که نواحی مشابهی را تغییر می‌دهد.',
	'review_cannot_reject' => 'نمی‌توان این تغییرات را رد کرد، زیرا در حال حاضر شخص دیگری تمام یا بخشی از این تغییرات را پذیرفته است.',
	'review_reject_excessive' => 'چند ویرایش را نمی‌توان یک جا رد کرد.',
	'review_reject_nulledits' => 'نمی‌توان این تغییرات را رد کرد، زیرا تمامی نسخه‌ها ویرایش‌های خالی هستند.',
	'revreview-check-flag-p' => 'پذیرفتن این نسخه (شامل $1 {{PLURAL:$1|تغییر|تغییرات}} در حال انتظار)',
	'revreview-check-flag-p-title' => 'پذیرش همهٔ تغییرات در حال انتظار کنونی بعلاوهٔ ویرایش خودتان. تنها در صورتی از این استفاده کنید که همهٔ تفاوت‌های تغییرات در حال انتظار را دیده باشید.',
	'revreview-check-flag-u' => 'این صفحهٔ بازبینی‌نشده را بپذیر',
	'revreview-check-flag-u-title' => 'این نسخهٔ صفحه را بپذیر. تنها در صورتی از این استفاده کنید که قبلاً تمام صفحه را دیده باشید.',
	'revreview-check-flag-y' => 'این تغییرات را بپذیر',
	'revreview-check-flag-y-title' => 'پذیرش همهٔ تغییراتی که شما در این ویرایش انجام داده‌اید.',
	'revreview-flag' => 'بررسی این نسخه',
	'revreview-reflag' => 'این نسخه را دوباره بازبینی کن',
	'revreview-invalid' => "'''هدف غیر مجاز:''' نسخهٔ [[{{MediaWiki:Validationpage}}|بازبینی شده‌ای]] با این شناسه وجود ندارد.",
	'revreview-log' => 'توضیح:',
	'revreview-main' => 'شما باید یک نسخه خاص از یک صفحه را برگزینید تا بررسی کنید.

[[Special:Unreviewedpages|فهرست صفحه‌های بررسی نشده]] را ببینید.',
	'revreview-stable1' => 'شما می‌توانید [{{fullurl:$1|stableid=$2}} نسخه علامت‌دار] را مشاهده کنید و هم‌اکنون از این صفحه [{{fullurl:$1|stable=1}} نسخه پایدار] را ببینید.',
	'revreview-stable2' => 'شما می‌توانید برای نمایش [{{fullurl:$1|stable=1}} نسخه پایدار]این صفحه را ببینید.',
	'revreview-submit' => 'ارسال',
	'revreview-submitting' => 'در حال ارسال...',
	'revreview-submit-review' => 'پذیرفتن نسخه',
	'revreview-submit-unreview' => 'نپذیرفتن نسخه',
	'revreview-submit-reject' => 'رد تغییرات',
	'revreview-submit-reviewed' => 'انجام شد. پذیرفته شد!',
	'revreview-submit-unreviewed' => 'انجام شد. پذیرفته نشد!',
	'revreview-successful' => "'''نسخهٔ انتخابی از [[:$1|$1]] با موفقیت علامت زده شد.
([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} مشاهدهٔ تمام نسخه‌های علامت‌دار])'''",
	'revreview-successful2' => "'''پرچم نسخه‌های انتخابی از [[:$1|$1]] با موفقیت برداشته شد.'''",
	'revreview-poss-conflict-p' => "'''هشدار: [[User:$1|$1]] شروع به بازبینی این صفحه در تاریخ $2، ساعت $3 کرده است.'''",
	'revreview-poss-conflict-c' => "'''هشدار: [[User:$1|$1]] شروع به بازبینی این تغییرات در تاریخ $2، ساعت $3 کرده است.'''",
	'revreview-adv-reviewing-p' => 'توجه: دیگر بازبینان می‌توانند ببینند که شما در حال بازبینی این صفحه هستید.',
	'revreview-adv-reviewing-c' => 'توجه: دیگر بازبینان می‌توانند ببینند که شما در حال بازبینی این تغییرات هستید.',
	'revreview-sadv-reviewing-p' => 'شما می‌توانید خودتان را به عنوان بازبین این صفحه به دیگر کاربران، $1.',
	'revreview-sadv-reviewing-c' => 'شما می‌توانید خودتان را به عنوان بازبین این تغییرات به دیگر کاربران، $1.',
	'revreview-adv-start-link' => 'اعلان کنید',
	'revreview-adv-stop-link' => 'از حالت اعلان بدر آورید',
	'revreview-toolow' => "'''برای درنظرگرفته‌شدن یک نسخه به‌عنوان بازبینی‌شده، باید هر یک از موارد بالاتر از «نابسنده» را امتیازدهی کنید.'''

به منظور حذف وضعیت بازبینی یک نسخه، روی «نپذیرفتن» کلیک کنید.

لطفاً دکمهٔ «بازگشت» را در مرورگرتان بفشارید و دوباره تلاش کنید.",
	'revreview-update' => "'''لطفاً هرگونه تغییر درحال‌انتظاری ''(در زیر نشان داده شده)'' را که از آخرین نسخهٔ پایدار صورت گرفته، [[{{MediaWiki:Validationpage}}|بازبینی کنید]].",
	'revreview-update-edited' => '<span class="flaggedrevs_important">تغییرات شما هنوز در نسخهٔ پایدار نیستند.</span>

لطفاً همهٔ تغییرات نشان‌داده‌شده در زیر را به‌منظور نمایاندن ویرایش‌هایتان در نسخهٔ پایدار بازبینی کنید.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">تغییرات شما هنوز در نسخهٔ پایدار نیستند. تغییرات پیشین در انتظار بازبینی هستند.</span>

لطفاً همهٔ تغییرات نشان‌داده‌شده در زیر را به‌منظور نمایاندن ویرایش‌هایتان در نسخهٔ پایدار بازبینی کنید.',
	'revreview-update-includes' => 'الگوها/پرونده‌ها به روز رسانی شدند (صفحات بازبینی نشده به صورت پررنگ نمایش داده شده‌اند):',
	'revreview-reject-text-list' => "با تکمیل این اقدام، شما {{PLURAL:$1|نسخه|نسخه‌های}} مقابل از [[:$2|$2]] را '''رد خواهید کرد''':",
	'revreview-reject-text-revto' => 'این صفحه را برمی‌گرداند به [{{fullurl:$1|oldid=$2}} نسخه $3].',
	'revreview-reject-summary' => 'ْخلاصه ویرایش:',
	'revreview-reject-confirm' => 'رد کردن این تغییرات',
	'revreview-reject-cancel' => 'انصراف',
	'revreview-reject-summary-cur' => 'آخرین {{PLURAL:$1|تغییر متن|$1 تغییرات متن}} رد شد (توسط $2) و برگردانده شد به نسخه مرور شده $3 توسط $4',
	'revreview-reject-summary-old' => 'اولین {{PLURAL:$1|تغییر متن|$1 تغییرات متن}} رد شد (توسط $2) که در ادامه نسخه مرور شده $3 توسط $4',
	'revreview-reject-summary-cur-short' => 'آخرین {{PLURAL:$1|تغییر متن|$1 تغییرات متن}} رد شد و برگردانده شد به نسخه مرور شده $2 توسط $3',
	'revreview-reject-summary-old-short' => 'اولین {{PLURAL:$1|تغییر متن|$1 تغییرات متن}} رد شد که ادامه نسخه مرور شده $2 توسط $3 بود',
	'revreview-tt-flag' => 'با برچسب‌زده به این نسخه به‌عنوان «بررسی‌شده» آن را بپذیر',
	'revreview-tt-unflag' => 'با برچسب زدن به این نسخه به‌عنوان «بررسی‌نشده» آن را نپذیر',
	'revreview-tt-reject' => 'این تغییرات متن مبدأ را با واگردانی مردود کنید',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Mies
 * @author Nedergard
 * @author Nike
 * @author Olli
 * @author Pxos
 * @author Str4nd
 */
$messages['fi'] = array(
	'revisionreview' => 'Versioiden arviointi',
	'revreview-failed' => "'''Tätä versiota ei voitu arvioida.'''",
	'revreview-submission-invalid' => 'Lisäys oli puutteellinen tai muutoin kelvoton.',
	'review_page_invalid' => 'Kohdesivun nimi ei kelpaa.',
	'review_page_notexists' => 'Kohdesivua ei ole olemassa.',
	'review_page_unreviewable' => 'Kohdesivua ei voi arvioida.',
	'review_no_oldid' => 'Versiotunnistetta ei määritelty.',
	'review_bad_oldid' => 'Kohdemuokkausta ei löydy.',
	'review_conflict_oldid' => 'Joku on jo ehtinyt hyväksyä tai hylätä tämän version sillä aikaa, kun katselit sitä.',
	'review_not_flagged' => 'Kohdeversiota ei ole tällä hetkellä merkitty arvioiduksi.',
	'review_too_low' => 'Versiota ei voida arvioida, koska joitakin kenttiä on jätetty tasolle ”puutteellinen”.',
	'review_bad_key' => 'Kelpaamaton säilytysparametrin avain.',
	'review_bad_tags' => 'Jotkut määritetyistä tunnusarvoista ovat virheellisiä.',
	'review_denied' => 'Ei oikeutta.',
	'review_param_missing' => 'Parametri puuttuu tai on kelpaamaton.',
	'review_cannot_undo' => 'Muutoksia ei voitu kumota, koska myöhemmät arviointia odottavat muokkaukset ovat muuttaneet samoja alueita.',
	'review_cannot_reject' => 'Näitä muutoksia ei voida nyt hylätä, koska joku muu on jo hyväksynyt osan muutoksista tai ne kaikki.',
	'review_reject_excessive' => 'Näin monta muokkausta ei voida hylätä kerralla.',
	'review_reject_nulledits' => 'Näitä muutoksia ei voitu hylätä, koska kaikki versiot ovat nollamuokkauksia.',
	'revreview-check-flag-p' => 'Hyväksy tämä versio (sisältää {{PLURAL:$1|odottavan muutoksen|$1 odottavaa muutosta}})',
	'revreview-check-flag-p-title' => 'Hyväksy kaikki arviointia odottavat muutokset oman muokkauksesi yhteydessä. 
Käytä tätä vain, jos olet jo käynyt läpi kaikki muokkaukset.',
	'revreview-check-flag-u' => 'Hyväksy tämä arvioimaton sivu',
	'revreview-check-flag-u-title' => 'Hyväksy tämä versio tästä sivusta. Käytä tätä vain, jos olet jo nähnyt koko sivun.',
	'revreview-check-flag-y' => 'Hyväksy omat muutokset',
	'revreview-check-flag-y-title' => 'Hyväksy kaikki muutokset, jotka teit tässä muokkauksessa.',
	'revreview-flag' => 'Arvioi tämä versio',
	'revreview-reflag' => 'Arvioi uudelleen tämä versio',
	'revreview-invalid' => "'''Kelpaamaton kohde:''' mikään [[{{MediaWiki:Validationpage}}|arvioitu]] versio ei vastaa annettua tunnistenumeroa.",
	'revreview-log' => 'Kommentti',
	'revreview-main' => 'Sinun täytyy valita tietty versio sivusta, jotta voit arvioida sen.

Katso [[Special:Unreviewedpages|lista sivuista, joita ei ole arvioitu]].',
	'revreview-stable1' => 'Haluat ehkä nähdä [{{fullurl:$1|stableid=$2}} tämän merkityn version] ja katsoa, onko se nyt [{{fullurl:$1|stable=1}} vakaa versio] tästä sivusta.',
	'revreview-stable2' => 'Haluat ehkä nähdä [{{fullurl:$1|stable=1}} vakaan version] tästä sivusta.',
	'revreview-submit' => 'Tallenna',
	'revreview-submitting' => 'Lähetetään...',
	'revreview-submit-review' => 'Hyväksy versio',
	'revreview-submit-unreview' => 'Poista version arviointi',
	'revreview-submit-reject' => 'Hylkää muutokset',
	'revreview-submit-reviewed' => 'Valmis. Hyväksytty!',
	'revreview-submit-unreviewed' => 'Valmis. Arviointi poistettu!',
	'revreview-successful' => "'''Sivun [[:$1|$1]] versio on arvioitu onnistuneesti. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} näytä arvioidut versiot])'''",
	'revreview-successful2' => "'''Sivun [[:$1|$1]] version arviointimerkintä on nyt poistettu.'''",
	'revreview-poss-conflict-p' => "'''Varoitus: Käyttäjä [[User:$1|$1]] on aloittanut tämän sivun arvioinnin $2 kello $3.'''",
	'revreview-poss-conflict-c' => "'''Varoitus: Käyttäjä [[User:$1|$1]] on aloittanut näiden muutosten arvioinnin $2 kello $3.'''",
	'revreview-adv-reviewing-p' => 'Huomautus: Muut seulojat näkevät, että arvioit tätä sivua.',
	'revreview-adv-reviewing-c' => 'Huomautus: Muut seulojat näkevät, että arvioit näitä muutoksia.',
	'revreview-sadv-reviewing-p' => 'Voit $1 muille käyttäjille, että arvioit tätä sivua.',
	'revreview-sadv-reviewing-c' => 'Voit $1 muille käyttäjille, että olet arvioimassa näitä muutoksia.',
	'revreview-adv-start-link' => 'ilmoittaa',
	'revreview-adv-stop-link' => 'älä ilmoita muille',
	'revreview-toolow' => "'''Sinun täytyy arvioida kaikki alla olevat kohdat paremmalla arvolla kuin ”puutteellinen”, jotta versio katsottaisiin arvioiduksi.'''

Poistaaksesi version arviointitilan napsauta ”Poista version arviointi”.

Palaa selaimen takaisin-painikkeella ja yritä uudelleen.",
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Arvioi]] kaikki odottavat muutokset (näytetään alla), jotka on tehty vakaan version jälkeen.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Muutoksesi eivät ole vielä näkyvissä vakaassa versiossa.</span>

Arvioi kaikki alla olevat muutokset, jotta muutoksesi näkyisivät vakaassa versiossa.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Muutoksesi eivät ole vielä näkyvissä vakaassa versiossa. Edelliset muutokset odottavat arviointia.</span>

Arvioi kaikki alla olevat muutokset, jotta muokkauksesi näkyisivät vakaassa versiossa.',
	'revreview-update-includes' => 'Mallineita tai tiedostoja on päivitetty (arvioimattomat sivut on lihavoitu):',
	'revreview-reject-text-list' => "Suorittamalla tämän toiminnon '''hylkäät''' alla {{PLURAL:$1|olevan muutoksen|olevat muutokset}} sivun [[:$2|$2]] lähdetekstiin:",
	'revreview-reject-text-revto' => 'Tämä palauttaa sivun takaisin [{{fullurl:$1|oldid=$2}} ajankohdan $3 versioon].',
	'revreview-reject-summary' => 'Yhteenveto:',
	'revreview-reject-confirm' => 'Vahvista näiden muutosten hylkääminen',
	'revreview-reject-cancel' => 'Peruuta',
	'revreview-reject-summary-cur' => 'Hylättiin {{PLURAL:$1|viimeisin tekstimuutos|viimeisimmät $1 tekstimuutosta}} (käyttäjältä $2) ja palautettiin versio $3 käyttäjältä $4',
	'revreview-reject-summary-old' => 'Hylättiin {{PLURAL:$1|ensimmäinen tekstimuutos (käyttäjältä $2), joka|ensimmäiset $1 tekstimuutosta (käyttäjältä $2), jotka}} tehtiin versioon $3 käyttäjältä $4',
	'revreview-reject-summary-cur-short' => 'Hylättiin {{PLURAL:$1|viimeinen tekstimuutos|viimeiset $1 tekstimuutosta}} ja palautettiin versio $2, jonka on tehnyt käyttäjä $3.',
	'revreview-reject-summary-old-short' => 'Hylättiin {{PLURAL:$1|ensimmäinen tekstimuutos, joka|ensimmäiset $1 tekstimuutosta, jotka}} tehtiin käyttäjän $3 versioon $2.',
	'revreview-tt-flag' => 'Hyväksy tämä versio merkitsemällä se katsotuksi.',
	'revreview-tt-unflag' => 'Poista tämän version hyväksyntä merkitsemällä se arvioimattomaksi.',
	'revreview-tt-reject' => 'Hylkää nämä lähdetekstiin tehdyt muutokset kumoamalla ne.',
);

/** French (Français)
 * @author Crochet.david
 * @author Gomoko
 * @author Grondin
 * @author IAlex
 * @author Jean-Frédéric
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'revisionreview' => 'Relire les versions',
	'revreview-failed' => "'''Impossible de relire cette révision.'''",
	'revreview-submission-invalid' => 'L’envoi était incomplet ou non valide.',
	'review_page_invalid' => 'Le titre de la page cible est invalide.',
	'review_page_notexists' => "La page cible n'existe page.",
	'review_page_unreviewable' => 'La page cible ne peut pas être relue.',
	'review_no_oldid' => "Aucun ID de révision n'a été spécifié.",
	'review_bad_oldid' => "La révision cible n'existe pas.",
	'review_conflict_oldid' => 'Quelqu’un a déjà accepté ou rejeté cette révision, pendant que vous la relisiez.',
	'review_not_flagged' => "La révision cible n'est actuellement pas marquée comme relue.",
	'review_too_low' => 'La révision ne peut pas être relue avec des champs laissés à « insuffisant ».',
	'review_bad_key' => "Clé de paramètre d'inclusion invalide.",
	'review_bad_tags' => 'Certaines valeurs de balise spécifiées sont invalides.',
	'review_denied' => 'Permission refusée.',
	'review_param_missing' => 'Un paramètre est manquant ou invalide.',
	'review_cannot_undo' => 'Impossible de défaire ces modifications parce que d’autres modifications en attente concernent les mêmes zones.',
	'review_cannot_reject' => 'Impossible de rejeter ces changements car quelqu’un a déjà accepté tout ou partie des modifications.',
	'review_reject_excessive' => 'Impossible de rejeter autant de modifications en une seule fois.',
	'review_reject_nulledits' => 'Impossible de rejeter ces changements car toutes les révisions sont des modifications vides.',
	'revreview-check-flag-p' => 'Accepter cette version (inclut $1 {{PLURAL:$1|modification|modifications}} en attente)',
	'revreview-check-flag-p-title' => "Accepter toutes les modifications en attente en même temps que votre propre modification.
Ne l'utilisez que si vous avez déjà vu le diff de l'ensemble des modifications en attente.",
	'revreview-check-flag-u' => 'Accepter cette page non relue',
	'revreview-check-flag-u-title' => "Accepter cette version de la page. N'utilisez ceci que si vous avez déjà vu la page en entier.",
	'revreview-check-flag-y' => 'Accepter ces changements',
	'revreview-check-flag-y-title' => 'Accepter tous les changements que vous avez effectués dans cette modification.',
	'revreview-flag' => 'Relire cette version',
	'revreview-reflag' => 'Relire cette révision de nouveau',
	'revreview-invalid' => "'''Cible incorrecte :''' aucune version [[{{MediaWiki:Validationpage}}|relue]] ne correspond au numéro indiqué.",
	'revreview-log' => 'Commentaire :',
	'revreview-main' => "Vous devez choisir une version précise d'une page pour effectuer une relecture.

Voir la [[Special:Unreviewedpages|liste des pages non relues]].",
	'revreview-stable1' => 'Vous souhaitez peut-être consulter [{{fullurl:$1|stableid=$2}} cette version marquée] pour voir si c’est maintenant la [{{fullurl:$1|stable=1}} version publiée] de cette page.',
	'revreview-stable2' => 'Vous souhaitez peut-être consulter [{{fullurl:$1|stable=1}} la version publiée] de cette page.',
	'revreview-submit' => 'Soumettre',
	'revreview-submitting' => 'Soumission…',
	'revreview-submit-review' => 'Accepter la version',
	'revreview-submit-unreview' => 'Désapprouver la version',
	'revreview-submit-reject' => 'Révoquer les modifications',
	'revreview-submit-reviewed' => 'Fait. Approuvé !',
	'revreview-submit-unreviewed' => 'Fait. Désapprouvé !',
	'revreview-successful' => "'''La version sélectionnée de [[:$1|$1]] a été marquée avec succès ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} voir les versions stables])'''",
	'revreview-successful2' => "'''Version de [[:$1|$1]] invalidée.'''",
	'revreview-poss-conflict-p' => "'''Attention : [[User:$1|$1]] a commencé à relire cette page le $2 à $3.'''",
	'revreview-poss-conflict-c' => "'''Attention : [[User:$1|$1]] a commencé à relire ces modifications le $2 à $3.'''",
	'revreview-adv-reviewing-p' => "Remarque: D'autres relecteurs peuvent voir que vous examinez cette page.",
	'revreview-adv-reviewing-c' => "Remarque: D'autres relecteurs peuvent voir que vous examinez ces modifications.",
	'revreview-sadv-reviewing-p' => 'Vous pouvez vous $1 vous-mêmes comme relecteur de cette page pour les autres utilisateurs.',
	'revreview-sadv-reviewing-c' => 'Vous pouvez vous $1 vous-mêmes comme relecteur de ces changements aux autres utilisateurs.',
	'revreview-adv-start-link' => 'faire de la publicité',
	'revreview-adv-stop-link' => 'annuler la publicité',
	'revreview-toolow' => "'''Vous devez affecter à chacun des attributs une évaluation plus élevée que « inappropriée » pour que la relecture soit prise en compte comme acceptée.'''

Pour enlever l’état de relecture d’une version, cliquez sur « Ne pas accepter ».

Veuillez utiliser le bouton « Retour » de votre navigateur puis essayez de nouveau.",
	'revreview-update' => "Veuillez [[{{MediaWiki:Validationpage}}|relire]] toutes les modifications ''(voir ci-dessous)'' apportées à la version acceptée.",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Vos modifications ne sont pas encore dans la version stable.</span>

Veuillez vérifier toutes les modifications affichées ci-dessous pour que la vôtre apparaisse dans la version stable.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Vos modifications ne sont pas encore dans la version stable. Il y a de précédentes modifications en attente de relecture.</span>

Vous devez relire toutes les modifications affichées ci-dessous pour la votre apparaisse dans la version stable.',
	'revreview-update-includes' => 'Modèles/fichiers mis à jour (pages non relues en gras) :',
	'revreview-reject-text-list' => "En effectuant cette action, vous allez '''rejeter''' les modifications sur le texte source {{PLURAL:$1|de la révision suivante|des révisions suivantes}} de [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Ceci remettra cette page dans sa [{{fullurl:$1|oldid=$2}} version du $3].',
	'revreview-reject-summary' => 'Résumé :',
	'revreview-reject-confirm' => 'Rejeter ces changements',
	'revreview-reject-cancel' => 'Annuler',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|La dernière modification du texte|Les dernières modifications du texte}} (par $2) ont été rejetées et la version $3 a été restaurée par $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|La première modification du texte|Les premières modifications du texte}} (par $2) qui suivaient la révision $3 ont été rejetées par $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|La dernière modification du texte|Les $1 dernières modifications du texte}} ont été rejetées et la version $2 a été restaurée par $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|La première modification du texte|Les $1 premières modifications du texte}} qui suivaient la révision $2 ont été rejetées par $3',
	'revreview-tt-flag' => 'Approuver cette version en la marquant comme vérifiée',
	'revreview-tt-unflag' => 'Désapprouver cette version en la marquant comme non-vérifiée',
	'revreview-tt-reject' => 'Rejeter ces modifications dans le texte source en les révoquant',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'revisionreview' => 'Revêre les vèrsions',
	'revreview-failed' => "'''Empossiblo de revêre ceta vèrsion.'''",
	'revreview-submission-invalid' => 'L’èxpèdicion ére encomplèta ou ben envalida.',
	'review_page_invalid' => 'Lo titro de la pâge ciba est fôx.',
	'review_page_notexists' => 'La pâge ciba ègziste pas.',
	'review_page_unreviewable' => 'La pâge ciba pôt pas étre revua.',
	'review_no_oldid' => 'Nion numerô de la vèrsion at étâ spècefiâ.',
	'review_bad_oldid' => 'La vèrsion ciba ègziste pas.',
	'review_conflict_oldid' => 'Quârqu’un at ja accèptâ ou ben refusâ cela vèrsion pendent que vos la reveyévâd.',
	'review_not_flagged' => 'Ora, la vèrsion ciba est pas marcâ coment revua.',
	'review_too_low' => 'La vèrsion pôt pas étre revua avouéc des champs lèssiês a « ensufisent ».',
	'review_bad_key' => 'Cllâf de paramètre d’encllusion envalida.',
	'review_bad_tags' => 'Quârques valors de balisa spècefiâs sont envalides.',
	'review_denied' => 'Pèrmission refusâ.',
	'review_param_missing' => 'Un paramètre est manquent ou ben envalido.',
	'review_cannot_undo' => 'Empossiblo de dèfâre celos changements perce que d’ôtros changements en atenta regârdont les mémes zones.',
	'review_cannot_reject' => 'Empossiblo de refusar celos changements perce que quârqu’un at ja accèptâ tot ou ben partia des changements.',
	'review_reject_excessive' => 'Empossiblo de refusar atant de changements en un solèt côp.',
	'review_reject_nulledits' => 'Empossiblo de refusar celos changements perce que totes les vèrsions sont des changements vouedos.',
	'revreview-check-flag-p' => 'Accèptar cela vèrsion ($1 changement{{PLURAL:$1||s}} en atenta avouéc)',
	'revreview-check-flag-p-title' => 'Accèptar tôs los changements en atenta en mémo temps que voutron prôpro changement. L’utilisâd ren que se vos éd ja vu lo dif de l’ensemblo des changements en atenta.',
	'revreview-check-flag-u' => 'Accèptar cela pâge pas revua',
	'revreview-check-flag-u-title' => 'Accèptar cela vèrsion de la pâge. Utilisâd cen ren que se vos éd ja vu la pâge tot entiér.',
	'revreview-check-flag-y' => 'Accèptar celos changements',
	'revreview-check-flag-y-title' => 'Accèptar tôs los changements que vos éd fêts dens ceti changement.',
	'revreview-flag' => 'Revêre ceta vèrsion',
	'revreview-reflag' => 'Tornar revêre ceta vèrsion',
	'revreview-invalid' => "'''Ciba fôssa :''' niona vèrsion [[{{MediaWiki:Validationpage}}|revua]] corrèspond u numerô balyê.",
	'revreview-log' => 'Comentèro :',
	'revreview-main' => 'Vos dête chouèsir una vèrsion spècefica d’una pâge de contegnu por fâre una rèvision.

Vêde la [[Special:Unreviewedpages|lista de les pâges pas revues]].',
	'revreview-stable1' => 'Vos souhètâd pôt-étre vêre ceta [{{fullurl:$1|stableid=$2}} vèrsion marcâ] por vêre s’o est ora la [{{fullurl:$1|stable=1}} vèrsion stâbla] de cela pâge.',
	'revreview-stable2' => 'Vos souhètâd pôt-étre vêre la [{{fullurl:$1|stable=1}} vèrsion stâbla] de ceta pâge.',
	'revreview-submit' => 'Sometre',
	'revreview-submitting' => 'Somission...',
	'revreview-submit-review' => 'Aprovar la vèrsion',
	'revreview-submit-unreview' => 'Dèsaprovar la vèrsion',
	'revreview-submit-reject' => 'Refusar los changements',
	'revreview-submit-reviewed' => 'Fât. Aprovâ !',
	'revreview-submit-unreviewed' => 'Fât. Dèsaprovâ !',
	'revreview-successful' => "'''La vèrsion chouèsia de [[:$1|$1]] at étâ marcâ avouéc reusséta ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} vêde totes les vèrsions stâbles]).'''",
	'revreview-successful2' => "'''La vèrsion chouèsia de [[:$1|$1]] at étâ envalidâ avouéc reusséta.'''",
	'revreview-poss-conflict-p' => "'''Atencion : [[User:$1|$1]] s’at betâ a revêre cela pâge lo $2 a $3.'''",
	'revreview-poss-conflict-c' => "'''Atencion : [[User:$1|$1]] s’at betâ a revêre celos changements lo $2 a $3.'''",
	'revreview-adv-reviewing-p' => 'Nota : d’ôtros rèvisors pôvont vêre que vos ègzamenâd cela pâge.',
	'revreview-adv-reviewing-c' => 'Nota : d’ôtros rèvisors pôvont vêre que vos ègzamenâd celos changements.',
	'revreview-adv-start-link' => 'fâre de recllâma',
	'revreview-adv-stop-link' => 'anular la recllâma',
	'revreview-toolow' => "'''Vos dête afèctar una èstimacion ples hôta que « ensufisent » por que la vèrsion seye considèrâ coment revua.'''

Por enlevar lo statut de rèvision d’una vèrsion, clicâd dessus « dèsaprovar ».

Volyéd utilisar lo boton « Devant » de voutron navigator et pués tornâd èprovar.",
	'revreview-update' => "'''Volyéd [[{{MediaWiki:Validationpage}}|revêre]] tôs los changements en atenta ''(vêde ce-desot)'' fêts a la vèrsion stâbla.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Voutros changements sont p’oncor dens la vèrsion stâbla.</span>

Volyéd controlar tôs los changements montrâs ce-desot por que los voutros aparéssont dens la vèrsion stâbla.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Voutros changements sont p’oncor dens la vèrsion stâbla. Y at de vielys changements en atenta de rèvision.</span>

Volyéd controlar tôs los changements montrâs ce-desot por que los voutros aparéssont dens la vèrsion stâbla.',
	'revreview-update-includes' => 'Modèlos/fichiérs betâs a jorn (pâges pas revues en grâs) :',
	'revreview-reject-text-list' => "En fassent cela accion, vos voléd '''refusar''' los changements sur lo tèxto sôrsa {{PLURAL:$1|de ceta vèrsion|de cetes vèrsions}} de [[:$2|$2]] :",
	'revreview-reject-text-revto' => 'Cen remetrat cela pâge dens sa [{{fullurl:$1|oldid=$2}} vèrsion du $3].',
	'revreview-reject-summary' => 'Rèsumâ :',
	'revreview-reject-confirm' => 'Refusar celos changements',
	'revreview-reject-cancel' => 'Anular',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Lo dèrriér changement|Los dèrriérs changements}} du tèxto (per $2) ont étâ refusâs et pués la vèrsion $3 at étâ refêta per $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Lo dèrriér changement|Los dèrriérs changements}} du tèxto (per $2) que siuvévont la vèrsion $3 ont étâ refusâs per $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Lo dèrriér changement|Los dèrriérs changements}} du tèxto ont étâ refusâs et pués la vèrsion $2 at étâ refêta per $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Lo dèrriér changement|Los dèrriérs changements}} du tèxto que siuvévont la vèrsion $2 ont étâ refusâs per $3',
	'revreview-tt-flag' => 'Aprovar ceta vèrsion en la marquent coment « controlâ »',
	'revreview-tt-unflag' => 'Dèsaprovar ceta vèrsion en la marquent coment « pas controlâ »',
	'revreview-tt-reject' => 'Refusar celos changements dens lo tèxto sôrsa en los rèvoquent',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'revreview-log' => 'Oanmerking:',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'revreview-log' => 'Nóta tráchta:',
);

/** Galician (Galego)
 * @author Gallaecio
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'revisionreview' => 'Examinar as revisións',
	'revreview-failed' => "'''Non se puido rematar a revisión.'''",
	'revreview-submission-invalid' => 'O envío foi incompleto ou inválido.',
	'review_page_invalid' => 'O título da páxina de destino non é correcto.',
	'review_page_notexists' => 'A páxina de destino non existe.',
	'review_page_unreviewable' => 'Non se pode revisar a páxina de destino.',
	'review_no_oldid' => 'Non se especificou ningún ID de revisión.',
	'review_bad_oldid' => 'Non existe tal revisión de destino.',
	'review_conflict_oldid' => 'Alguén xa aceptou ou rexeitou esta revisión mentres a estaba a ollar.',
	'review_not_flagged' => 'A revisión de destino non está marcada como revisada.',
	'review_too_low' => 'Non se pode revisar a revisión deixando algúns campos fixados en "inadecuado".',
	'review_bad_key' => 'A clave do parámetro de inclusión é incorrecta.',
	'review_bad_tags' => 'Algunhas das etiquetas especificadas non eran válidas.',
	'review_denied' => 'Permisos rexeitados.',
	'review_param_missing' => 'Falta un parámetro ou é incorrecto.',
	'review_cannot_undo' => 'Non se poden desfacer estas modificacións porque aínda hai cambios pendentes que editaron o mesmo texto.',
	'review_cannot_reject' => 'Non se poden rexeitar estes cambios porque alguén xa aceptou algunhas (ou todas as) edicións.',
	'review_reject_excessive' => 'Non se poden rexeitar tantas edicións dunha vez.',
	'review_reject_nulledits' => 'Non pode rexeitar estes cambios porque todas as revisións son edicións nulas.',
	'revreview-check-flag-p' => 'Aceptar esta versión (inclúe {{PLURAL:$1|1 cambio pendente|$1 cambios pendentes}})',
	'revreview-check-flag-p-title' => 'Aceptar todos os cambios pendentes xunto á súa propia edición.
Use isto soamente en canto olle o conxunto de todas as diferenzas dos cambios pendentes.',
	'revreview-check-flag-u' => 'Publicar esta páxina non revisada',
	'revreview-check-flag-u-title' => 'Aceptar esta versión da páxina. Use isto soamente en canto olle o conxunto de todo o texto.',
	'revreview-check-flag-y' => 'Aceptar estes cambios',
	'revreview-check-flag-y-title' => 'Aceptar todos os cambios que fixo nesta edición.',
	'revreview-flag' => 'Revisar esta revisión',
	'revreview-reflag' => 'Volver revisar esta revisión',
	'revreview-invalid' => "'''Obxectivo inválido:''' ningunha revisión [[{{MediaWiki:Validationpage}}|revisada]] se corresponde co ID dado.",
	'revreview-log' => 'Comentario para o rexistro:',
	'revreview-main' => 'Debe seleccionar unha revisión particular dunha páxina de contido de cara á revisión.

Vexa a [[Special:Unreviewedpages|lista de páxinas sen revisar]].',
	'revreview-stable1' => 'Pode que queira ver [{{fullurl:$1|stableid=$2}} esta versión analizada] para comprobar se agora é [{{fullurl:$1|stable=1}} a versión publicada] desta páxina.',
	'revreview-stable2' => 'Quizais queira ver a [{{fullurl:$1|stable=1}} versión publicada] desta páxina.',
	'revreview-submit' => 'Enviar',
	'revreview-submitting' => 'Enviando...',
	'revreview-submit-review' => 'Aprobar a revisión',
	'revreview-submit-unreview' => 'Suspender a revisión',
	'revreview-submit-reject' => 'Rexeitar os cambios',
	'revreview-submit-reviewed' => 'Feito. Aprobada!',
	'revreview-submit-unreviewed' => 'Feito. Retiróuselle a aprobación!',
	'revreview-successful' => "'''Examinouse con éxito a revisión de \"[[:\$1|\$1]]\". ([{{fullurl:{{#Special:ReviewedVersions}}|page=\$2}} ver as versións estábeis])'''",
	'revreview-successful2' => "'''Retiouse con éxito o exame da revisión de \"[[:\$1|\$1]]\".'''",
	'revreview-poss-conflict-p' => "'''Atención: [[User:$1|$1]] comezou a revisar este artigo o $2 ás $3.'''",
	'revreview-poss-conflict-c' => "'''Atención: [[User:$1|$1]] comezou a revisar estes cambios o $2 ás $3.'''",
	'revreview-adv-reviewing-p' => 'Aviso: Os outros revisores poden ver que está a revisar esta páxina.',
	'revreview-adv-reviewing-c' => 'Aviso: Os outros revisores poden ver que está a revisar estes cambios.',
	'revreview-sadv-reviewing-p' => 'Pode $1 aos demais usuarios de que está a revisar esta páxina.',
	'revreview-sadv-reviewing-c' => 'Pode $1 aos demais usuarios de que está a revisar estes cambios.',
	'revreview-adv-start-link' => 'advertir',
	'revreview-adv-stop-link' => 'retirar a advertencia',
	'revreview-toolow' => '\'\'\'Debe, polo menos, valorar cada un dos atributos cunha puntuación maior que "inadecuado" para que unha revisión sexa considerada como revisada.\'\'\'

Para retirar o estado de aprobación dunha revisión, prema sobre "suspender".

Por favor, prema sobre o botón "Volver" do seu navegador e inténteo de novo.',
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Revise]] os cambios pendentes ''(móstranse a continuación)'' feitos á versión aceptada.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Os seus cambios aínda non se atopan na versión estable.</span>

Revise todos os cambios listados a continuación para que as súas edicións aparezan na versión estable.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Os seus cambios aínda non se atopan na versión estable. Hai edicións previas pendentes de revisión.</span>

Revise todos os cambios listados a continuación para que as súas edicións aparezan na versión estable.',
	'revreview-update-includes' => 'Actualizáronse algúns modelos ou ficheiros (as páxinas non revisadas van en negra):',
	'revreview-reject-text-list' => "Ao completar esta acción, '''rexeitará''' os cambios no texto fonte {{PLURAL:\$1|da seguinte revisión|das seguintes revisións}} de \"[[:\$2|\$2]]\":",
	'revreview-reject-text-revto' => 'Isto reverterá a páxina ata a [{{fullurl:$1|oldid=$2}} versión do $3].',
	'revreview-reject-summary' => 'Resumo:',
	'revreview-reject-confirm' => 'Rexeitar estes cambios',
	'revreview-reject-cancel' => 'Cancelar',
	'revreview-reject-summary-cur' => 'Rexeitou {{PLURAL:$1|o último cambio|os últimos $1 cambios}} no texto (de $2) e recuperou a revisión $3 de $4',
	'revreview-reject-summary-old' => 'Rexeitou {{PLURAL:$1|o primeiro cambio|os primeiros $1 cambios}} no texto (de $2) que seguen á revisión $3 de $4',
	'revreview-reject-summary-cur-short' => 'Rexeitou {{PLURAL:$1|o último cambio|os últimos $1 cambios}} no texto e recuperou a revisión $2 de $3',
	'revreview-reject-summary-old-short' => 'Rexeitou {{PLURAL:$1|o primeiro cambio|os primeiros $1 cambios}} no texto que seguen á revisión $2 de $3',
	'revreview-tt-flag' => 'Aprobar esta revisión marcándoa como comprobada',
	'revreview-tt-unflag' => 'Suspender esta revisión marcándoa como non comprobada',
	'revreview-tt-reject' => 'Rexeitar estes cambios no texto reverténdoos',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'revisionreview' => 'ἐπιθεωρεῖν ἀναθεωρήσεις',
	'revreview-log' => 'Σχόλιον:',
	'revreview-submit' => 'Ὑποβάλλειν',
	'revreview-submitting' => 'Ὑποβἀλλειν...',
	'revreview-reject-cancel' => 'Ἀκυροῦν',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 * @author Melancholie
 */
$messages['gsw'] = array(
	'revisionreview' => 'Versionspriefig',
	'revreview-failed' => "'''Die Version het nit chenne markiert wäre.'''",
	'revreview-submission-invalid' => 'D Ibertragig isch nit vollständig oder nit giltig gsi.',
	'review_page_invalid' => 'Dää Sytename isch nit giltig.',
	'review_page_notexists' => 'Ziilsyte git s nit.',
	'review_page_unreviewable' => 'Ziilsyte isch nit priefbar.',
	'review_no_oldid' => 'Kei Versions-ID aagee.',
	'review_bad_oldid' => 'D Ziilversion, wu aagee isch, git s nit.',
	'review_conflict_oldid' => 'Eber het die Version scho akzeptiert oder verworfe, derwylscht Du si gläse hesch.',
	'review_not_flagged' => 'D Ziilversion isch zurzyt nit markiert.',
	'review_too_low' => 'Version cha nit prieft wäre, solang Fälder no as „längt nit“ gchännzeichnet sin.',
	'review_bad_key' => 'Dr Wärt vum Priefparameter isch not giltig.',
	'review_bad_tags' => 'Mangi vo de Kennzeiche, wo aagee worde sin, sin nit gültig',
	'review_denied' => 'Zuegriff verweigeret.',
	'review_param_missing' => 'E Parameter fählt oder isch nit giltig.',
	'review_cannot_undo' => 'Die Änderige chenne nit ruckgängig gmacht wäre, wel no meh hängigi Änderige in dr nämlige Beryych gmacht wore sin.',
	'review_cannot_reject' => 'Die Änderige chenne nit furtghejt wäre, wel e andere Benutzer scho ne paar oder alli Bearbeitige akzeptiert het.',
	'review_reject_excessive' => 'Eso vil Bearbeitige chenne nit uf eimol furtghejt wäre.',
	'review_reject_nulledits' => 'Die Bearbeitige chönne nit furtgheit worde, wyl keini devo Änderige het.',
	'revreview-check-flag-p' => 'Die Version akzeptiere (mitsamt dr $1 hängige {{PLURAL:$1|Änderig|Änderige}})',
	'revreview-check-flag-p-title' => 'Alli hängige Änderige akzeptiere zämme mit Dyyre eigene Bearbeitig.
Mache des nume, wänn Du dir alli hängige Änderige aagluegt hesch.',
	'revreview-check-flag-u' => 'Die nit iberprieft Syte akzeptiere',
	'revreview-check-flag-u-title' => 'Die Syteversion akzeptiere. Mach des nume, wänn Du di ganz Syte aagluegt hesch.',
	'revreview-check-flag-y' => 'Die Änderige markiere',
	'revreview-check-flag-y-title' => 'Alli Änderige akzäptiere, wu Du mit däre Bearbeitig gmacht hesch.',
	'revreview-flag' => 'Die Version priefe',
	'revreview-reflag' => 'Die Version nomol priefe',
	'revreview-invalid' => "'''Nit giltig Ziil:''' kei [[{{MediaWiki:Validationpage}}|gsichteti]] Artikelversion vu dr Versions-ID wu aagee isch.",
	'revreview-log' => 'Kommentar:',
	'revreview-main' => 'Du muesch e Artikelversion uswehle go si markiere.

Lueg au d [[Special:Unreviewedpages|Lischt vu nit markierte Versione]].',
	'revreview-stable1' => 'Villicht mechtsch [{{fullurl:$1|stableid=$2}} die markiert Version] aaluege un luege, eb s jetz di [{{fullurl:$1|stable=1}} vereffetligt Version] vu däre Syten isch.',
	'revreview-stable2' => 'Witt di [{{fullurl:$1|stable=1}} vereffetligt Version] vu däre Syte säh?',
	'revreview-submit' => 'Vèrsion markiere',
	'revreview-submitting' => '… bitte warte …',
	'revreview-submit-review' => 'Version akzeptiere',
	'revreview-submit-unreview' => 'Versionsmarkierig uusenee',
	'revreview-submit-reject' => 'Änderige zrucknee',
	'revreview-submit-reviewed' => 'Erledigt. Aagluegt!',
	'revreview-submit-unreviewed' => 'Erledigt. Nit aagluegt!',
	'revreview-successful' => "'''Di usgwehlt Version vum Artikel ''[[:\$1|\$1]]'' isch as \"vum Fäldhieter gsäh\" markiert wore ([{{fullurl:{{#Special:ReviewedVersions}}|page=\$2}} alli aagluegte Versione vu däm Artikel])'''.",
	'revreview-successful2' => "'''D Markierig vu dr Version vu [[:$1|$1]] isch ufghobe wore.'''",
	'revreview-poss-conflict-p' => "'''Obacht: De Benutzer [[User:$1|$1]] het am $2 um $3 Uhr demit aagfange die Syte z überpriefe.'''",
	'revreview-poss-conflict-c' => "'''Obacht: De Benutzer [[User:$1|$1]] het am $2 um $3 Uhr demit aagfange die Änderige z überpriefe.'''",
	'revreview-adv-reviewing-p' => 'Hyywys: Andri Bentzer wärde ab jetz druf hyygwyse, dass du die Syte überpriefe duesch.',
	'revreview-adv-reviewing-c' => 'Hyywys: Andri Bentzer wärde ab jetz druf hyygwyse, dass du die Änderige überpriefe duesch.',
	'revreview-sadv-reviewing-p' => 'Du chasch andri Benutzer $1 dass du die Syte überpriefe duesch.',
	'revreview-sadv-reviewing-c' => 'Du chasch andri Benutzer $1 dass du die Änderige überpriefe duesch.',
	'revreview-adv-start-link' => 'druff hyywyse',
	'revreview-adv-stop-link' => 'nümm druff hyywyse',
	'revreview-toolow' => "'''Du muesch fir e jedes vu däne Attribut e Wärt yystelle, wu hecher isch wie „längt nit“, ass e Version as \"prieft\" giltet.''' 

Zum dr Priefigsstatus vun ere Version z ändere, durkc uf „Versionsmarkierig uuseneh“.

Bitte druck uf dr „Zruck“-Chnopf un versuech s nonemol.",
	'revreview-update' => "'''Bitte [[{{MediaWiki:Validationpage}}|prief]] di hängige Änderige ''(lueg unte)'', wu syt dr letschte vereffetligte Version gmacht wore sin.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Dyyni Änderige sin nonig in di stabil Version ibernuu wore.</span>

Bitte iberprief alli unte aazeigte Änderige, ass Dyyni Bearbeite chenne ibernuu wäre.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Dyy Änderige sin nonig in di stabil Version ibernuu wore. S het no vorigi Änderige, wu hängig sin. </span>

Bitte iberprief alli unte aazeigte Änderige, ass Dyyni Bearbeite chenne ibernuu wäre.',
	'revreview-update-includes' => 'Vorlage/Dateie sin aktualisiert worde (nit markierti Syte sin fett gkennzeichnet):',
	'revreview-reject-text-list' => "Mit Abschluss vu däre Aktion {{PLURAL:$1|wird die Änderig|wäre die Änderige}} aa [[:$2|$2]]  '''furtghejt''':",
	'revreview-reject-text-revto' => 'Des setzt d Syte uf d [{{fullurl:$1|oldid=$2}} Version vum $3] zruck.',
	'revreview-reject-summary' => 'Zämefassig:',
	'revreview-reject-confirm' => 'Die Änderige furtgheje',
	'revreview-reject-cancel' => 'Abbräche',
	'revreview-reject-summary-cur' => 'Di {{PLURAL:$1|letscht Teggständerig|$1 letschten Teggständerige}} vu $2 {{PLURAL:$1|isch|sin}} furtghejt wore un d Version $3 vu $4 widerhärgstellt',
	'revreview-reject-summary-old' => 'Di {{PLURAL:$1|erscht Teggständerig|$1 erschten Teggständerige}} vu $2, wu uf d Version $3 vu $4  {{PLURAL:$1|chuu isch, isch|chuu sin, sin}} furtghejt wore',
	'revreview-reject-summary-cur-short' => 'Di {{PLURAL:$1|letscht Teggständerig isch|$1 letschten Teggständerig sin}} furtgehjt wore un d Version $2 vu $3 widerhärgstellt',
	'revreview-reject-summary-old-short' => 'Di {{PLURAL:$1|erscht Teggständerig|$1 erschten Teggständerig}}, wu uf d Version $2 vu $3 {{PLURAL:$1|chuu isch, isch|chuu sin, sin}} furtghejt wore',
	'revreview-tt-flag' => "Die Version zueloo dur Markiere as ''aagluegt''",
	'revreview-tt-unflag' => "Die Version ablähne dur Markiere as ''nit aagluegt''",
	'revreview-tt-reject' => 'Die Teggtsänderige dur zruggsetze zruggwyse',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'revreview-log' => 'Bahasi:',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author StuB
 * @author YaronSh
 */
$messages['he'] = array(
	'revisionreview' => 'סקירת גרסאות',
	'revreview-failed' => "'''לא ניתן לסקור גרסה זו.'''",
	'revreview-submission-invalid' => 'המידע שנשלח היה לא שלם או לא תקין בצורה כלשהי.',
	'review_page_invalid' => 'כותרת דף היעד אינה תקינה.',
	'review_page_notexists' => 'דף היעד אינו קיים.',
	'review_page_unreviewable' => 'לא ניתן לסקור את דף היעד.',
	'review_no_oldid' => 'לא צוין מספר גרסה.',
	'review_bad_oldid' => 'גרסת היעד אינה קיימת.',
	'review_conflict_oldid' => 'מישהו כבר קיבל או דחה את הגרסה הזאת בזמן שהצגת אותה.',
	'review_not_flagged' => 'גרסת היעד אינה מסומנת כעת כגרסה שנסקרה.',
	'review_too_low' => 'לא ניתן לסמן גרסה של דף כ"נסקרת" כשהדף אינו קביל לפי מדד כלשהו.',
	'review_bad_key' => 'מפתח פרמטר הכללה שגוי.',
	'review_bad_tags' => 'חלק מתערכי התגים שניתנו אינם תקינים.',
	'review_denied' => 'ההרשאה נדחתה.',
	'review_param_missing' => 'פרמטר חסר או בלתי־תקין.',
	'review_cannot_undo' => 'לא ניתן לבטל שינויים אלה כי עריכות ממתינות נוספות שינו את אותם האזורים.',
	'review_cannot_reject' => 'לא ניתן לדחות שינויים אלה כי מישהו כבר קיבל חלק מהעריכות (או את כולן).',
	'review_reject_excessive' => 'לא ניתן לדחות כמות כזאת של עריכות בבת אחת.',
	'review_reject_nulledits' => 'לא ניתן לדחות שינויים אלה מכיוון שכל הגרסאות הן עריכות ריקות.',
	'revreview-check-flag-p' => 'לקבל את הגרסה הזאת (לרבות {{PLURAL:$1|השינוי הממתין|$1 השינויים הממתינים}})',
	'revreview-check-flag-p-title' => 'לקבל את התוצאה של כל השינויים הממתינים ושל השינויים שעשיתם כאן. עשו זאת רק עם כבר ראיתם את כל ההשוואות של השינויים הממתינים.',
	'revreview-check-flag-u' => 'לקבל את הדף הזה, שטרם נסקר',
	'revreview-check-flag-u-title' => 'לקבל את הגרסה הזאת של הדף. עשו זאת רק אם ראיתם כבר את הדף כולו.',
	'revreview-check-flag-y' => 'לקבל את השינויים שלי',
	'revreview-check-flag-y-title' => 'לקבל את כל השינויים שעשיתם בעריכה זו.',
	'revreview-flag' => 'סקירה של גרסה זו',
	'revreview-reflag' => 'סקירה חוזרת של גרסה זו',
	'revreview-invalid' => "'''יעד בלתי תקין:''' מספר הגרסה שניתן אינו מצביע לגרסה [[{{MediaWiki:Validationpage}}|שנסקרה]].",
	'revreview-log' => 'הערה:',
	'revreview-main' => 'כדי לסקור, יש לבחור גרסה מסוימת של דף תוכן.

ראו את [[Special:Unreviewedpages|רשימת הדפים שלא נסקרו]].',
	'revreview-stable1' => 'ייתכן שתרצו לצפות ב[{{fullurl:$1|stableid=$2}} גרסה מסומנת זו] ולראות האם היא עכשיו [{{fullurl:$1|stable=1}} הגרסה היציבה] של הדף הזה.',
	'revreview-stable2' => 'ייתכן שתרצו לצפות ב[{{fullurl:$1|stable=1}} גרסה היציבה] של הדף הזה.',
	'revreview-submit' => 'שליחה',
	'revreview-submitting' => 'נשלח...',
	'revreview-submit-review' => 'קבלת הגרסה',
	'revreview-submit-unreview' => 'דחיית הגרסה',
	'revreview-submit-reject' => 'דחיית השינויים',
	'revreview-submit-reviewed' => 'בוצע. התקבל!',
	'revreview-submit-unreviewed' => 'בוצע. נדחה!',
	'revreview-successful' => "'''הגרסה של [[:$1|$1]] סומנה בהצלחה. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} צפייה בגרסאות שנסקרו])'''",
	'revreview-successful2' => "'''סימון הגרסה [[:$1|$1]] הוסר בהצלחה.'''",
	'revreview-poss-conflict-p' => "'''אזהרה: [[User:$1|$1]] התחיל לסקור את הדף הזה ב־$2 בשעה $3.'''",
	'revreview-poss-conflict-c' => "'''אזהרה: [[User:$1|$1]] התחיל לסקור את השינויים האלה ב־$2 בשעה $3.'''",
	'revreview-adv-reviewing-p' => 'לתשומת לבכם: סוקרים אחרים יכולים לראות שאתם סוקרים את הדף הזה.',
	'revreview-adv-reviewing-c' => 'לתשומת לבכם: סוקרים אחרים יכולים לראות שאתם סוקרים את השינויים האלה.',
	'revreview-sadv-reviewing-p' => 'לתשומת לבך: אפשר $1 על עצמך למשתמשים אחרים בתור סוקר הדף הזה.',
	'revreview-sadv-reviewing-c' => 'לתשומת לבך: אפשר $1 על עצמך בתור סוקר השינויים האלה למשתמשים אחרים.',
	'revreview-adv-start-link' => 'להודיע',
	'revreview-adv-stop-link' => 'לבטל את ההודעה',
	'revreview-toolow' => 'יש לדרג כל אחת מהתכונות הבאות גבוה יותר מ"בלתי קבילה" כדי שהגרסה תיחשב לגרסה שנסקרה.

כדי להסיר מגרסה את הגדרת מצב הסקירה שלה, יש ללחוץ על "דחיית הגרסה".

נא ללחוץ על כפתור "אחורה" בדפדפן ולנסות שוב.',
	'revreview-update' => "נא [[{{MediaWiki:Validationpage}}|לסקור]] את כל השינויים הממתינים '''(מוצגים להלן)''' שנעשו מאז הגרסה היציבה האחרונה.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">השינויים שלכם עדיין אינם בגרסה היציבה.</span>

נא לסקור את כל השינויים המופיעים להלן כדי שהעריכות שלכם תופענה בגרסה היציבה.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">השינויים שלכם עדיין אינם בגרסה היציבה. יש שינויים קודמים שממתינים לסקירה.</span>

נא לסקור את כל השינויים המופיעים להלן כדי שהעריכות שלכם תופענה בגרסה היציבה.',
	'revreview-update-includes' => 'עודכנו תבניות או קבצים (הדפים שלא נסקרו מובלטים):',
	'revreview-reject-text-list' => "השלמת פעולה זו '''תדחה''' את השינויים בקוד המקור של {{PLURAL:$1|הגרסה הבאה|הגרסאות הבאות}} של [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'פעולה זו תשחזר את העמוד בחזרה לגרסה [{{fullurl:$1|oldid=$2}} מתאריך $3].',
	'revreview-reject-summary' => 'תקציר העריכה:',
	'revreview-reject-confirm' => 'דחיית שינויים אלה',
	'revreview-reject-cancel' => 'ביטול',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|נדחה שינוי הטקסט האחרון|נדחו $1 שינוי הטקסט האחרונים}} (מאת $2) ושוחזרה גרסה $3 מאת $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|נדחה שינוי הטקסט הראשון|נדחו $1 שינוי הטקסט הראשונים}} (מאת $2) אחרי גרסה $3 מאת $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|נדחה שינוי הטקסט האחרון|נדחו $1 שינויי הטקסט האחרונים}} ושוחזרה גרסה $2 מאת $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|נדחה שינוי הטקסט הראשון|נדחו $1 שינויי הטקסט הראשונים}} אחרי גרסה $2 מאת $3',
	'revreview-tt-flag' => 'קבלת גרסה זו באמצעות סימונה כ"בדוקה"',
	'revreview-tt-unflag' => 'דחיית הגרסה הזאת באמצעות סימונה כ"לא בדוקה"',
	'revreview-tt-reject' => 'דחיית שינויים אלה על ידי שחזורם',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Kaustubh
 */
$messages['hi'] = array(
	'revisionreview' => 'अवतरण परखें',
	'revreview-failed' => "'''इस संशोधन की समिक्षा संभव नहीं ।'''",
	'revreview-submission-invalid' => 'सबमिशन असंपूर्ण है या अमान्य है ।',
	'review_page_invalid' => 'लक्ष्य पृष्ठ की शीर्षक अमान्य है ।',
	'review_page_notexists' => 'लक्ष्य पृष्ठ मौजूद नहीं है ।',
	'review_page_unreviewable' => 'लक्ष्य पृष्ठ समिक्षायोग्य नहीं है ।',
	'review_no_oldid' => 'कोई संशोधन आईड़ि विनिर्दिष्ट नहीं है ।',
	'review_bad_oldid' => 'लक्ष्य संशोधन मौजूद नहीं है ।',
	'review_denied' => 'अनुमति नहीं मिली ।',
	'review_param_missing' => 'प्राचल लापता या अमान्य है ।',
	'review_reject_excessive' => 'इतने सारे सम्पादन एक ही बार में अस्वीकार नहीं हो सकता ।',
	'revreview-check-flag-u' => 'पृष्ठ जो जांच नहीं हुई है उसे स्वीकार करें',
	'revreview-check-flag-y' => 'मेरी बदलाव स्वीकार करें',
	'revreview-check-flag-y-title' => 'सारे बदलाव स्वीकार करें जो आप यहाँ किया हैं ।',
	'revreview-flag' => 'यह अवतरण परखें',
	'revreview-reflag' => 'इस संशोधन को पुनःसमिक्षा करें',
	'revreview-invalid' => "'''गलत लक्ष्य:''' कोईभी [[{{MediaWiki:Validationpage}}|परिक्षण]] हुआ अवतरण दिये हुए क्रमांक से मिलता नहीं।",
	'revreview-log' => 'टिप्पणी:',
	'revreview-main' => 'परिक्षण के लिये एक अवतरण चुनना अनिवार्य हैं।

परिक्षण ना हुए अवतरणोंकी सूची के लिये [[Special:Unreviewedpages]] देखें।',
	'revreview-stable1' => 'आप शायद इस पन्नेका [{{fullurl:$1|stableid=$2}} यह मार्क किया हुआ अवतरण] अब [{{fullurl:$1|stable=1}} स्थिर अवतरण] बन चुका हैं या नहीं यह देखना चाहतें हैं।',
	'revreview-stable2' => 'आप इस पन्नेका [{{fullurl:$1|stable=1}} स्थिर अवतरण] देख सकतें हैं (अगर उपलब्ध है तो)।',
	'revreview-submit' => 'जमा करें',
	'revreview-submitting' => 'दाखिला...',
	'revreview-submit-review' => 'संशोधन स्वीकार',
	'revreview-submit-unreview' => 'संशोधन अस्वीकार',
	'revreview-submit-reject' => 'बदलाव असीकृत',
	'revreview-submit-reviewed' => 'पूर्ण हुई । स्वीकृत!',
	'revreview-submit-unreviewed' => 'पूर्ण हुई । अस्वीकृत!',
	'revreview-successful' => "[[:$1|$1]] के चुने हुए अवतरणको मार्क किया गया हैं।
([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} सभी मार्क किये हुए अवतरण देखें])'''",
	'revreview-successful2' => "'''[[:$1|$1]] के चुने हुए अवतरण का मार्क हटाया।'''",
	'revreview-adv-start-link' => 'विज्ञापन',
	'revreview-toolow' => 'एक अवतरण को जाँचने का मार्क करने के लिये आपको नीचे लिखे हर पॅरॅमीटरको "अप्रमाणित" से उपरी दर्जा देना आवश्यक हैं।
एक अवतरणका गुणांकन कम करने के लिये, निम्नलिखित सभी कॉलममें "अप्रमाणित" चुनें।',
	'revreview-update' => "कृपया किये हुए बदलाव ''(नीचे दिये हुए)'' [[{{MediaWiki:Validationpage}}|जाँचे]] क्योंकी स्थिर अवतरण [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} प्रमाणित] कर दिया गया हैं।<br />
'''कुछ साँचा/चित्र बदले हैं:'''",
	'revreview-update-includes' => 'कुछ साँचा/चित्र बदले हैं:',
	'revreview-reject-summary' => 'सारांश:',
	'revreview-reject-confirm' => 'ये संशोधन अस्वीकार करें',
	'revreview-reject-cancel' => 'रद्द करें',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'revisionreview' => 'Ocijeni inačice',
	'revreview-failed' => "'''Ocjenjivanje nije uspjelo.'''",
	'revreview-submission-invalid' => 'Slanje je nekompletno ili na drugi način nevaljano.',
	'review_page_invalid' => 'Naslov ciljne stranice nije valjan',
	'review_page_notexists' => 'Ciljna stranica ne postoji.',
	'review_page_unreviewable' => 'Ciljna stranica se ne može pregledati.',
	'review_no_oldid' => 'Nije naveden identikikacijski broj inačice.',
	'review_bad_oldid' => 'Ciljna inačica ne postoji.',
	'review_conflict_oldid' => 'Netko je već prihvatio ili odbio ovu reviziju dok ste je vi gledali.',
	'review_not_flagged' => 'Ciljna inačica nije trenutačno označena kao pregledana.',
	'review_too_low' => "Inačica ne može biti pregledane ako su neka polja ostavljena s ocjenom ''ne zadovoljava''.",
	'review_bad_key' => 'Nevaljan ključ parametra uključivanja.',
	'review_denied' => 'Pristup odbijen.',
	'review_param_missing' => 'Parametar nedostaje ili nije valjan.',
	'review_cannot_undo' => 'Ne mogu vratiti ove promjene jer su ostale izmjene na čekanju mijenjale isti odlomak stranice.',
	'review_cannot_reject' => 'Ne možete odbiti ove promjene jer je netko već prihvatio neke (ili sve) izmjene.',
	'review_reject_excessive' => 'Ne možete odbiti tako velik broj uređivanja odjednom.',
	'revreview-check-flag-p' => 'Prihvati ovu verziju (uključujući $1 {{PLURAL:$1|izmjenu|izmjene|izmjena}} na čekanju)',
	'revreview-check-flag-p-title' => 'Prihvati sve trenutne promjene na čekanju zajedno s vašim vlastitim izmjenama. Rabite ovo samo ako ste već pregledali sve razlike promjena na čekanju.',
	'revreview-check-flag-u' => 'Prihvati ovu nepregledanu stranicu',
	'revreview-check-flag-u-title' => 'Prihvati ovu inačicu stranice. Rabite ovo samo ako ste pregledali cijelu stranicu.',
	'revreview-check-flag-y' => 'Prihvati ove izmjene',
	'revreview-check-flag-y-title' => 'Prihvati sve izmjene koje ste napravili u ovom uređivanju.',
	'revreview-flag' => 'Ocijeni izmjenu',
	'revreview-reflag' => 'Ponovo ocijeni ovu inačicu',
	'revreview-invalid' => "'''Nevaljani cilj:''' nema [[{{MediaWiki:Validationpage}}|ocijenjene]] izmjene koja odgovara danom ID-u.",
	'revreview-log' => 'Komentar:',
	'revreview-main' => 'Morate odabrati neku izmjenu stranice sa sadržajem za ocjenjivanje.

Pogledajte [[Special:Unreviewedpages|popis neocijenjenih stranica]].',
	'revreview-stable1' => 'Možda želite vidjeti [{{fullurl:$1|stableid=$2}} ovu označenu inačicu] i vidjeti da li je ovo [{{fullurl:$1|stable=1}} važeća inačica] ove stranice.',
	'revreview-stable2' => 'Možda želite vidjeti [{{fullurl:$1|stable=1}} važeću inačicu] ove stranice.',
	'revreview-submit' => 'Podnesi',
	'revreview-submitting' => 'Šaljem ...',
	'revreview-submit-review' => 'Prihvati inačicu',
	'revreview-submit-unreview' => 'Poništi prihvaćanje inačice',
	'revreview-submit-reject' => 'Odbaci promjene',
	'revreview-submit-reviewed' => 'Gotovo. Provjereno!',
	'revreview-submit-unreviewed' => 'Gotovo. Neprovjereno!',
	'revreview-successful' => "'''Inačica od [[:$1|$1]] uspješno je označena. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} vidi važeće inačice])'''",
	'revreview-successful2' => "'''Inačica od [[:$1|$1]] uspješno je označena.'''",
	'revreview-toolow' => "'''Morate ocijeniti svaki atribut članka višom ocjenom od \"Ne zadovoljava\" kako bi inačica bila pregledana/ocijenjena.'''

Za uklanjanje pregledanog statusa inačice, kliknite na ''unaccept''.

Molimo kliknite gumb \"natrag\" u Vašem web pregledniku i pokušajte opet.",
	'revreview-update' => "'''Molimo [[{{MediaWiki:Validationpage}}|ocijenite]] sve promjene ''(prikazane dolje)'' učinjene nakon važeće inačice.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Vaše izmjene još uvijek nisu u stabilnoj inačici.</span>

Molimo provjerite sve izmjene prikazane ispod da bi se vaše izmjene prikazale u stabilnoj inačici.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Vaše izmjene još uvijek nisu u stabilnoj inačici. Postoje ranije izmjene koje su na čekanju za provjeru</span>

Molimo provjerite sve izmjene prikazane ispod da bi se vaše izmjene prikazale u stabilnoj inačici.',
	'revreview-update-includes' => 'Neki predlošci/datoteke su ažurirane:',
	'revreview-reject-text-list' => "Dovršavanjem ove akcije, vi ćete '''odbiti''' {{PLURAL:$1|sljedeću promjenu|sljedeće promjene|sljedeće promjene}}:",
	'revreview-reject-text-revto' => 'Ovime ćete vratiti stranicu natrag na [{{fullurl:$1|oldid=$2}} inačicu od $3].',
	'revreview-reject-summary' => 'Uredi sažetak:',
	'revreview-reject-confirm' => 'Odbaci ove promjene',
	'revreview-reject-cancel' => 'Otkazati',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Odbijena zadnja izmjena|Odbijene zadnje $1 izmjene|Odbijeno zadnjih $1 izmjena}} (od strane $2) i vraćena inačica $3 suradnika $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Odbijena prva izmjena|Odbijene prve $1 izmjene|Odbijeno prvih $1 izmjena}} (od strane $2) koje su načinjene nakon inačice $3 suradnika $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Odbijena zadnja izmjena|Odbijene zadnje $1 izmjene|Odbijeno zadnjih $1 izmjena}} i vraćena inačica $2 suradnika $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Odbijena prva izmjena|Odbijene prve $1 izmjene|Odbijeno prvih $1 izmjena}} koje su načinjene nakon inačice $2 suradnika $3',
	'revreview-tt-flag' => "Prihvati ovu inačicu označavajući je ''provjerenom''",
	'revreview-tt-unflag' => "Poništi ovu inačicu označavajući je ''neprovjerenom''",
	'revreview-tt-reject' => 'Odbaci ove promjene tako što ćete ih ukloniti',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 * @author Tlustulimu
 */
$messages['hsb'] = array(
	'revisionreview' => 'Wersije přepruwować',
	'revreview-failed' => "'''Njeje móžno tutu wersiju přepruwować.'''",
	'revreview-submission-invalid' => 'Wotpósłanje bě njedospołne abo někak njepłaćiwe.',
	'review_page_invalid' => 'Titul ciloweje strony je njepłaćiwy.',
	'review_page_notexists' => 'Cilowa strona njeeksistuje.',
	'review_page_unreviewable' => 'Cilowa strona přepruwujomna njeje.',
	'review_no_oldid' => 'Žadyn wersijowy ID podaty.',
	'review_bad_oldid' => 'Cilowa wersija njeeksistuje.',
	'review_conflict_oldid' => 'Něchtó je tutu wersiju hižo akceptował abo wotpokazał, hdyž sy sej ju wobhladał.',
	'review_not_flagged' => 'Cilowa wersija njeje tuchwilu jako přepruwowana markěrowana.',
	'review_too_low' => 'Wersija njeda so přepruwować, hdyž někotre pola su hišće "njepřiměrjene".',
	'review_bad_key' => 'Njepłaćiwy kluč za zapřijimowanski parameter.',
	'review_bad_tags' => 'Někotre podatych znamjenjow su njepłaćiwe.',
	'review_denied' => 'Prawo zapowědźene.',
	'review_param_missing' => 'Parameter faluje abo je njepłaćiwy.',
	'review_cannot_undo' => 'Tute změny njehodźa so cofnyć, dokelž dalše njesčinjene změny su samsne městna změnili.',
	'review_cannot_reject' => 'Tute změny njedadźa so wotpokazać, dokelž něchtó je někotre z nich abo wšě akceptował.',
	'review_reject_excessive' => 'Tute wjele změnow njedadźo so naraz wotpokazać.',
	'review_reject_nulledits' => 'Tute změny so njemóžeja wotpokazować, dokelž wšě tute wersije žane změny njewobsahuja.',
	'revreview-check-flag-p' => 'Tutu wersiju akceptować (zapřijima $1 njesčinjene {{PLURAL:$1|změna|změnje|změny|změnow}})',
	'revreview-check-flag-p-title' => 'Akceptowanje wšěch tuchwilu njepřepruwowanych změnow hromadźe z twojej swójskej změnu.
Wužij to jenož, jeli sy hižo wšě hišće njepřepruwowane změny widźał.',
	'revreview-check-flag-u' => 'Tutu njepřepruwowanu stronu akceptować',
	'revreview-check-flag-u-title' => 'Akceptuj tutu wersiju strony. Wužij ju jenož, jeli sy hižo cyłu stronu widźał',
	'revreview-check-flag-y' => 'Tute změny akceptować',
	'revreview-check-flag-y-title' => 'Wšě změny akceptować, kotrež sće při tutym wobdźěłanju činił.',
	'revreview-flag' => 'Tutu wersiju přepruwować',
	'revreview-reflag' => 'Tutu wersiju znowa přepruwować',
	'revreview-invalid' => "'''Njepłaćiwy cil:''' žana [[{{MediaWiki:Validationpage}}|skontrolowana]] wersija podatemu ID njewotpowěduje.",
	'revreview-log' => 'Protokolowy zapisk:',
	'revreview-main' => 'Dyrbiš wěstu wersiju nastawka za přepruwowanje wubrać.

Hlej [[Special:Unreviewedpages|za lisćinu njepřepruwowanych stronow]].',
	'revreview-stable1' => 'Snano chceš sej [{{fullurl:$1|stableid=$2}} tutu woznamjenjenu wersiju] wobhladać a widźeć, hač je wona nětko [{{fullurl:$1|stable=1}} wozjewjena wersija] tuteje strony.',
	'revreview-stable2' => 'Snano chceš sej [{{fullurl:$1|stable=1}} wozjewjenu wersiju] tuteje strony wobhladać.',
	'revreview-submit' => 'Wotpósłać',
	'revreview-submitting' => 'Sćele so...',
	'revreview-submit-review' => 'Wersiju akceptować',
	'revreview-submit-unreview' => 'Wersiju zakazać',
	'revreview-submit-reject' => 'Změny wotpokazać',
	'revreview-submit-reviewed' => 'Hotowo. Schwalene!',
	'revreview-submit-unreviewed' => 'Hotowo. Schwalenje zebrane!',
	'revreview-successful' => "'''Wersija [[:$1|$1]] je so wuspěšnje woznamjeniła. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} stabilne wersije wobhladać])'''",
	'revreview-successful2' => "'''Woznamjenjenje wersije [[:$1|$1]] je so wuspěšnje wotstroniło.'''",
	'revreview-poss-conflict-p' => "'''Warnowanje: [[User:$1|$1]] započa tutu stronu $2, $3 přepruwować.'''",
	'revreview-poss-conflict-c' => "'''Warnowanje: [[User:$1|$1]] započa tute změny $2, $3 přepruwować.'''",
	'revreview-adv-reviewing-p' => 'Kedźbu: Druzy přepruwowarjo móža widźeć, zo tutu stronu přepruwuješ.',
	'revreview-adv-reviewing-c' => 'Kedźbu: Druzy přepruwowarjo móža widźeć, zo tute změny přepruwuješ.',
	'revreview-sadv-reviewing-p' => 'Móžeš druhich wužiwarjow na to $1, zo tutu stronu přepruwuješ.',
	'revreview-sadv-reviewing-c' => 'Móžeš druhich wužiwarjow na to $1, zo tute změny přepruwuješ.',
	'revreview-adv-start-link' => 'skedźbnić',
	'revreview-adv-stop-link' => 'wjace njeskedźbnić',
	'revreview-toolow' => '\'\'\'Dyrbiš kóždy z atributow wyše hač "njepřiměrjeny" pohódnoćić, zo by so wersija jako přepruwowana wobkedźbowała.\'\'\'

Zo by přepruwowanski status wersije wotstronił, klikń na "njeakceptować".

Prošu klikń na tłóčatko "Wróćo" w swojim wobhladowaku a spytaj hišće raz.',
	'revreview-update' => "'''Prošu [[{{MediaWiki:Validationpage}}|přepruwuj]] njepřepruwowane změny ''(hlej deleka)'', kotrež buchu na akceptowanej wersiji přewjedźene.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Twoje změny hišće w stabilnej wersiji njeje.</span>

Prošu přepruwuj wšě slědowace změny, zo bychu so twoje změny w stabilnej wersiji jewili.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Twoje změny hišće w stabilnej wersiji njeje. Su hišće njepřepruwowane změny.</span>

Přepruwuj prošu wšě změny, kotrež so deleka pokazuja, zo bychu so twoje změny w stabilnej wersiji jewili.',
	'revreview-update-includes' => 'Předłohi/dataje su so zaktualizowali (njepřepruwowane strony su tučnje woznamjenjene):',
	'revreview-reject-text-list' => "Při kónčenju tuteje akcije, budźeš změny žórłoweho teksta ze {{PLURAL:$1|slědowaceje wersije|slědowaceju wersijow|slědowacych wersijow|slědowacych wersijow}} strony [[:$2|$2]] '''wotpokazować''':",
	'revreview-reject-text-revto' => 'To stronu na [{{fullurl:$1|oldid=$2}} wersiju wot dnja $3] wróćo staji.',
	'revreview-reject-summary' => 'Zjeće:',
	'revreview-reject-confirm' => 'Tute změny wotpokazać',
	'revreview-reject-cancel' => 'Přetorhnyć',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Poslednja tekstowa změna|$1 poslednjej tekstowej změnje|$1 poslednje tekstowe změny|$1 poslednich tekstowych změnow}} wot $2 {{PLURAL:$1|bu wotpokazana|buštej wotpokazanej|buchu wotpokazane|bu wotpokazane}} a wersija $3 wot $4 je so wobnowiła.',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Prěnja tekstowa změna|$1 prěnjej tekstowej změnje|$1 prěnje tekstowe změny|$1 prěnich tekstowych změnow}} wot $2, {{PLURAL:$1|kotraž|kotrejž|kontrež|kotrež}} wersiji $3 wot $4 {{PLURAL:$1|slědowaše|slědowaštej|slědowachu|slědowachu}}, {{PLURAL:$1|je so wotpokazała|stej so wotpokazałoj|su so wotpokazali|je so wotpokazało}}.',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Poslednja tekstowa změna|$1 poslednjej tekstowej změnje|$1 poslednje tekstowe změny|$1 poslednich tekstowych změnow}} {{PLURAL:$1|bu wotpokazana|buštej wotpokazanej|buchu wotpokazane|bu wotpokazane}} a wersija $2 wot $3 je so wobnowiła.',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Prěnja tekstowa změna|$1 prěnjej tekstowej změnje|$1 prěnje tekstowe změny|$1 prěnich tekstowych změnow}} {{PLURAL:$1|bu wotpokazana|buštej wotpokazanej|buchu wotpokazane|bu wotpokazane}}, {{PLURAL:$1|kotraž|kotrejž|kontrež|kotrež}} wersiji $2 wot $3 {{PLURAL:$1|slědowaše|slědowaštej|slědowachu|slědowaše}},',
	'revreview-tt-flag' => 'Tutu wersiju přez markěrowanje jako skontrolowanu schwalić',
	'revreview-tt-unflag' => 'Tutu wersiju přez markěrowanje jako njeskontrolowanu zakazać',
	'revreview-tt-reject' => 'Tute změny žórłoweho teksta přez wróćostajenje wotpokazać',
);

/** Hungarian (Magyar)
 * @author Bean49
 * @author BáthoryPéter
 * @author Dani
 * @author Dj
 * @author Glanthor Reviol
 * @author Hunyadym
 * @author Misibacsi
 * @author Tgr
 */
$messages['hu'] = array(
	'revisionreview' => 'Változatok ellenőrzése',
	'revreview-failed' => "'''A változat ellenőrzése meghiúsult.'''",
	'revreview-submission-invalid' => 'A változtatás hiányos, vagy érvénytelen.',
	'review_page_invalid' => 'Érvénytelen cím.',
	'review_page_notexists' => 'Nincs ilyen lap.',
	'review_page_unreviewable' => 'Ezt a lapot nem lehet ellenőrizni.',
	'review_no_oldid' => 'Nem adtad meg a lapváltozatot.',
	'review_bad_oldid' => 'Nincs ilyen lapváltozat.',
	'review_conflict_oldid' => 'Valaki már elfogadta, vagy elutasította ezt a változatot, amíg te olvastad.',
	'review_not_flagged' => 'A célváltozat jelenleg nincs ellenőrzöttnek jelölve.',
	'review_too_low' => 'A változat nem jelölhető ellenőrzöttnek, ha néhány tulajdonság „nem megfelelő” jelöléssel van ellátva.',
	'review_bad_key' => 'Érvénytelen paraméterkulcs a beillesztésnél.',
	'review_bad_tags' => 'A megadott címke értékek némelyike érvénytelen.',
	'review_denied' => 'Engedély megtagadva.',
	'review_param_missing' => 'Egy paraméter hiányzik vagy hibás.',
	'review_cannot_undo' => 'A változtatások nem vonhatóak vissza, mert további függőben lévő szerkesztések történtek ugyanezen a területen.',
	'review_cannot_reject' => 'Nem lehet elutasítani a változtatásokat, mert valaki közben elfogadott egy szerkesztést (vagy mindet).',
	'review_reject_excessive' => 'Nem utasíthatsz el egyszerre ennyi szerkesztést.',
	'review_reject_nulledits' => 'Ezeket a változtatásokat nem tudod visszavonni, mert valamennyi változtatás üres szerkesztés.',
	'revreview-check-flag-p' => 'Változat közzététele ({{PLURAL:$1|Egy|$1}} függő változtatást tartalmaz)',
	'revreview-check-flag-p-title' => 'Az összes ellenőrzésre váró változtatás megtekintettnek jelölése, beleértve ezt a szerkesztésedet is. Csak akkor használd ezt, ha végignézted az utolsó ellenőrzött változathoz képest az összes eltérést.',
	'revreview-check-flag-u' => 'Ellenőrizetlen lap közzététele',
	'revreview-check-flag-u-title' => 'A lap ezen változatának megtekintettnek jelölése. Csak akkor használd, ha az egész lapot leellenőrizted.',
	'revreview-check-flag-y' => 'Változások elfogadása',
	'revreview-check-flag-y-title' => 'Az összes olyan változtatás megtekintettnek jelölése, amit ebben a szerkesztésben végeztél.',
	'revreview-flag' => 'Változat ellenőrzése',
	'revreview-reflag' => 'Változat újraellenőrzése',
	'revreview-invalid' => "'''Érvénytelen cél:''' a megadott azonosító nem egy [[{{MediaWiki:Validationpage}}|ellenőrzött]] változat.",
	'revreview-log' => 'Megjegyzés:',
	'revreview-main' => 'Ki kell választanod egy lap adott változatát az ellenőrzéshez.

Lásd az [[Special:Unreviewedpages|ellenőrizetlen lapok listáját]].',
	'revreview-stable1' => 'Megnézheted [{{fullurl:$1|stableid=$2}} ezt a jelölt változatot], vagy a lap [{{fullurl:$1|stable=1}} közzétett változatát].',
	'revreview-stable2' => 'Megnézheted a lap [{{fullurl:$1|stable=1}} közzétett változatát].',
	'revreview-submit' => 'Értékelés elküldése',
	'revreview-submitting' => 'Küldés…',
	'revreview-submit-review' => 'Ellenőrzöttnek jelölés',
	'revreview-submit-unreview' => 'Ellenőrizetlennek jelölés',
	'revreview-submit-reject' => 'Változások elutasítása',
	'revreview-submit-reviewed' => 'Kész. Ellenőrizve!',
	'revreview-submit-unreviewed' => 'Kész. A változat nem ellenőrzött!',
	'revreview-successful' => "'''A(z) [[:$1|$1]] változatát sikeresen megjelölted. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} ellenőrzött változatok megjelenítése])'''",
	'revreview-successful2' => "'''A(z) [[:$1|$1]] változatáról sikeresen eltávolítottad a jelölést.'''",
	'revreview-poss-conflict-p' => "'''Figyelem: [[User:$1|$1]] elkezdte ellenőrizni a lapot ekkor: $2   $3'''",
	'revreview-poss-conflict-c' => "'''Figyelem: [[User:$1|$1]] elkezdte ellenőrizni a lapon történt változásokat ekkor: $2   $3'''",
	'revreview-adv-reviewing-p' => 'Figyelem: A többi szerkesztő láthatja, hogy te ellenőrzöd ezeket a változásokat.',
	'revreview-adv-reviewing-c' => 'Figyelem: A többi szerkesztő láthatja, hogy te ellenőrzöd ezeket a változásokat.',
	'revreview-sadv-reviewing-p' => '$1 az ellenőrzést, a többi szerkesztő ezt láthatja.',
	'revreview-sadv-reviewing-c' => '$1 a szerkesztőnevedet a többi szerkesztő számára mint aki ellenőrzi ezeket a változásokat.',
	'revreview-adv-start-link' => 'Közzéteheted',
	'revreview-adv-stop-link' => 'hirdetés visszavonása',
	'revreview-toolow' => "'''Ahhoz, hogy egy változat ellenőrzöttnek tekinthető legyen, minden tulajdonságot magasabbra kell értékelned a „nem ellenőrzött” szintnél.'''

Nem ellenőrzöttnek való visszaminősítéshez állítsd az összes mezőt „nem ellenőrzött” értékre.

Kattints a böngésződ „Vissza” gombjára, majd próbáld újra.",
	'revreview-update' => "'''Kérlek [[{{MediaWiki:Validationpage}}|ellenőrizd]] a közzétett változat utáni, még függőben lévő változtatásokat ''(lásd alább)''.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">A változtatásaid még nincsenek közzétéve.</span>

Kérlek ellenőrizd az alább látható változtatásokat, hogy a szerkesztéseid megjelenhessenek a közzétett változatban.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">A változtatásaid még nincsenek közzétéve. Korábbi változtatások várnak ellenőrzésre.</span>

Kérlek ellenőrizd az alább látható változtatásokat, hogy a szerkesztéseid megjelenhessenek a közzétett változatban.',
	'revreview-update-includes' => 'Néhány sablon vagy fájl megváltozott (az ellenőrzésre várók félkövérrel szedve):',
	'revreview-reject-text-list' => 'Ezzel a művelettel visszavonsz {{PLURAL:$1|módosítást|módosítást}} a(z) [[:$2|$2]] oldalon:',
	'revreview-reject-text-revto' => 'Ezzel visszaállítod a lapot a [{{fullurl:$1|oldid=$2}} $3-i változatra].',
	'revreview-reject-summary' => 'Összefoglaló:',
	'revreview-reject-confirm' => 'Változtatások visszaállítása',
	'revreview-reject-cancel' => 'Mégse',
	'revreview-reject-summary-cur' => 'Visszavontam az utolsó {{PLURAL:$1||$1}} változtatást (szerk: $2); ezzel visszaállítottam a(z) $3 változatot (szerk: $4)',
	'revreview-reject-summary-old' => 'Visszavontam az első {{PLURAL:$1||$1}} változtatást (szerk: $2); ami a(z) $3  (szerk: $4) változatot követte',
	'revreview-reject-summary-cur-short' => 'Visszavontam az utolsó {{PLURAL:$1||$1}} változtatást; előző változat: $2 ($3)',
	'revreview-reject-summary-old-short' => 'Visszavontam az első {{PLURAL:$1|szövegmódosítást|$1szövegmódosítást}}, ami a $3 által szerkesztett  $2 ellenőrzött változatot követte',
	'revreview-tt-flag' => 'Változat elfogadása (ellenőrzöttnek jelölés)',
	'revreview-tt-unflag' => 'Változat elfogadásának visszavonása ellenőrizetlennek jelöléssel.',
	'revreview-tt-reject' => 'Változtatások elutasítása visszaállítással',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'revisionreview' => 'Revider versiones',
	'revreview-failed' => "'''Impossibile revider iste version.'''",
	'revreview-submission-invalid' => 'Le submission esseva incomplete o alteremente invalide.',
	'review_page_invalid' => 'Le titulo del pagina de destination es invalide.',
	'review_page_notexists' => 'Le pagina de destination non existe.',
	'review_page_unreviewable' => 'Le pagina de destination non es revisibile.',
	'review_no_oldid' => 'Nulle numero de version specificate.',
	'review_bad_oldid' => 'Non existe tal version de destination.',
	'review_conflict_oldid' => 'Qualcuno jam acceptava o rejectava iste version durante que tu lo legeva.',
	'review_not_flagged' => 'Le version de destination non es actualmente marcate como revidite.',
	'review_too_low' => 'Le version non pote esser revidite con alcun campos lassate "inadequate".',
	'review_bad_key' => 'Clave de parametro de inclusion invalide.',
	'review_bad_tags' => 'Alcunes del valores de etiquetta specificate es invalide.',
	'review_denied' => 'Permission refusate.',
	'review_param_missing' => 'Un parametro es mancante o invalide.',
	'review_cannot_undo' => 'Non pote disfacer iste modificationes proque altere modificationes pendente cambiava le mesme areas.',
	'review_cannot_reject' => 'Non pote rejectar iste modificationes proque alcuno jam acceptava alcunes (o totes) de iste modificationes.',
	'review_reject_excessive' => 'Non pote rejectar iste numero de modificationes a un vice.',
	'review_reject_nulledits' => 'Non pote rejectar iste cambiamentos proque tote iste versiones contine nulle modification.',
	'revreview-check-flag-p' => 'Acceptar iste version (incluse $1 {{PLURAL:$1|modification|modificationes}} pendente)',
	'revreview-check-flag-p-title' => 'Acceptar tote le modificationes actualmente pendente con tu proprie modification. Usa isto solmente si tu ha ja vidite tote le diff de modificationes pendente.',
	'revreview-check-flag-u' => 'Acceptar iste pagina non revidite',
	'revreview-check-flag-u-title' => 'Acceptar iste version del pagina. Solmente usa isto si tu ha ja vidite tote le pagina.',
	'revreview-check-flag-y' => 'Acceptar iste modificationes',
	'revreview-check-flag-y-title' => 'Acceptar tote le alterationes que tu ha facite in iste modification.',
	'revreview-flag' => 'Revider iste version',
	'revreview-reflag' => 'Re-revider iste version',
	'revreview-invalid' => "'''Destination invalide:''' nulle version [[{{MediaWiki:Validationpage}}|revidite]] corresponde al ID specificate.",
	'revreview-log' => 'Commento:',
	'revreview-main' => 'Tu debe seliger un version particular de un pagina de contento pro poter revider lo.

Vide le [[Special:Unreviewedpages|lista de paginas non revidite]].',
	'revreview-stable1' => 'Es suggerite vider [{{fullurl:$1|stableid=$2}} iste version marcate] pro determinar si illo es ora le [{{fullurl:$1|stable=1}} version publicate] de iste pagina.',
	'revreview-stable2' => 'Tu pote vider le [{{fullurl:$1|stable=1}} version publicate] de iste pagina.',
	'revreview-submit' => 'Submitter',
	'revreview-submitting' => 'Invio in curso…',
	'revreview-submit-review' => 'Acceptar version',
	'revreview-submit-unreview' => 'Non plus acceptar version',
	'revreview-submit-reject' => 'Rejectar modificationes',
	'revreview-submit-reviewed' => 'Facite. Approbate!',
	'revreview-submit-unreviewed' => 'Facite. Disapprobate!',
	'revreview-successful' => "'''Le version de [[:$1|$1]] ha essite marcate con successo. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} vider versiones stabile])'''",
	'revreview-successful2' => "'''Le version de [[:$1|$1]] ha essite dismarcate con successo.'''",
	'revreview-poss-conflict-p' => "'''Attention: [[User:$1|$1]] comenciava a revider iste pagina le $2 a $3.'''",
	'revreview-poss-conflict-c' => "'''Attention: [[User:$1|$1]] comenciava a revider iste modificationes le $2 a $3.'''",
	'revreview-adv-reviewing-p' => 'Nota: Altere revisores pote vider que tu revide iste pagina.',
	'revreview-adv-reviewing-c' => 'Nota: Altere revisores pote vider que tu revide iste cambiamentos.',
	'revreview-sadv-reviewing-p' => 'Tu pote $1 al altere usatores que tu revide iste pagina.',
	'revreview-sadv-reviewing-c' => 'Tu pote $1 al altere usatores que tu revide iste cambiamentos.',
	'revreview-adv-start-link' => 'annunciar',
	'revreview-adv-stop-link' => 'non plus annunciar',
	'revreview-toolow' => '\'\'\'Tu debe evalutar cata un del attributos como plus alte que "inadequate" a fin que un version sia considerate como revidite.\'\'\'

Pro remover le stato de revision de un version, clicca super "non plus acceptar".

Per favor preme le button "retro" in tu navigator e reproba.',
	'revreview-update' => "'''Per favor [[{{MediaWiki:Validationpage}}|revide]] omne modificationes pendente ''(monstrate hic infra)'' facite al version acceptate.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Tu modificationes non es ancora in le version stabile.</span>

Per favor revide tote le modificationes monstrate hic infra pro facer tu modificationes apparer in le version stabile.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Tu modificationes non es ancora in le version stabile. Il ha previe modificationes attendente revision.</span>

Per favor revide tote le modificationes monstrate hic infra pro facer tu modificationes apparer in le version stabile.',
	'revreview-update-includes' => 'Patronos/files actualisate (paginas non revidite in grasse):',
	'revreview-reject-text-list' => "Per exequer iste action, tu '''rejecta''' le modificationes in le texto-fonte del sequente {{PLURAL:$1|version|versiones}} de [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Isto revertera le pagina al [{{fullurl:$1|oldid=$2}} version del $3].',
	'revreview-reject-summary' => 'Summario:',
	'revreview-reject-confirm' => 'Rejectar iste modificationes',
	'revreview-reject-cancel' => 'Cancellar',
	'revreview-reject-summary-cur' => 'Rejectava le ultime {{PLURAL:$1|modification|$1 modificationes}} de texto (per $2) e restaurava le version $3 per $4',
	'revreview-reject-summary-old' => 'Rejectava le prime {{PLURAL:$1|modification|$1 modificationes}} de texto (per $2) que sequeva le version $3 per $4',
	'revreview-reject-summary-cur-short' => 'Rejectava le ultime {{PLURAL:$1|modification|$1 modificationes}} de texto e restaurava le version $2 per $3',
	'revreview-reject-summary-old-short' => 'Rejectava le prime {{PLURAL:$1|modification|$1 modificationes}} de texto que sequeva le version $2 per $3',
	'revreview-tt-flag' => 'Approbar iste version per marcar lo como verificate',
	'revreview-tt-unflag' => 'Cessar de acceptar iste version per marcar lo como como "non verificate"',
	'revreview-tt-reject' => 'Rejectar iste modificationes de texto per reverter los',
);

/** Indonesian (Bahasa Indonesia)
 * @author ArdWar
 * @author Bennylin
 * @author Farras
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Kenrick95
 * @author Rex
 */
$messages['id'] = array(
	'revisionreview' => 'Tinjau revisi',
	'revreview-failed' => "'''Tidak dapat meninjau revisi ini.'''",
	'revreview-submission-invalid' => 'Kiriman tidak lengkap atau tidak sah.',
	'review_page_invalid' => 'Judul halaman tujuan tidak sah.',
	'review_page_notexists' => 'Halaman yang dituju tidak ditemukan',
	'review_page_unreviewable' => 'Halaman yang dituju tidak dapat ditinjau.',
	'review_no_oldid' => 'Tidak ada ID revisi yang disebutkan.',
	'review_bad_oldid' => 'Revisi yang dituju tidak ditemukan.',
	'review_conflict_oldid' => 'Seseorang telah menerima atau menolak revisi ini sewaktu Anda melihatnya.',
	'review_not_flagged' => 'Revisi yang dituju saat ini tidak ditandai sebagai tertinjau.',
	'review_too_low' => 'Revisi tidak dapat ditinjau bila sejumlah kotak bertuliskan "tidak mencukupi".',
	'review_bad_key' => 'Kunci parameter masukan tidak sah.',
	'review_bad_tags' => 'Beberapa nilai tag yang diberikan tidak sah.',
	'review_denied' => 'Izin ditolak.',
	'review_param_missing' => 'Sebuah parameter hilang atau tidak sah.',
	'review_cannot_undo' => 'Tidak dapat membatalkan perubahan ini karena suntingan tunda selanjutnya mengubah daerah yang sama.',
	'review_cannot_reject' => 'Tidak dapat menolak perubahan ini karena seseorang telah menerima sebagian (atau semua) suntingan.',
	'review_reject_excessive' => 'Tidak bisa menolak begitu banyak suntingan sekaligus.',
	'revreview-check-flag-p' => 'Terima versi ini (termasuk $1 {{PLURAL:$1|perubahan|perubahan}} tunda)',
	'revreview-check-flag-p-title' => 'Terima semua perubahan tertunda saat ini bersama suntingan Anda. Gunakan ini hanya bila Anda telah meliaht keseluruhan perbedaan perubahan tertunda.',
	'revreview-check-flag-u' => 'Terima halaman yang belum diperiksa ini',
	'revreview-check-flag-u-title' => 'Terima versi halaman ini. Gunakan ini hanya bila Anda telah melihat keseluruhan halaman.',
	'revreview-check-flag-y' => 'setujui perubahan',
	'revreview-check-flag-y-title' => 'Setujui semua perubahan yang Anda buat dalam suntingan ini.',
	'revreview-flag' => 'Tinjau revisi ini',
	'revreview-reflag' => 'Tinjau kembali revisi ini',
	'revreview-invalid' => "'''Tujuan tidak ditemukan:''' tidak ada revisi [[{{MediaWiki:Validationpage}}|tertinjau]] yang cocok dengan nomor revisi yang diminta.",
	'revreview-log' => 'Komentar:',
	'revreview-main' => 'Anda harus memilih suatu revisi tertentu dari halaman isi untuk ditinjau.

Lihat [[Special:Unreviewedpages]] untuk daftar halaman yang belum ditinjau.',
	'revreview-stable1' => 'Anda mungkin ingin melihat [{{fullurl:$1|stableid=$2}} versi yang ditandai ini] untuk melihat apakah sudah ada [{{fullurl:$1|stable=1}} versi stabil] dari halaman ini.',
	'revreview-stable2' => 'Anda mungkin ingin melihat [{{fullurl:$1|stable=1}} versi stabil] halaman ini.',
	'revreview-submit' => 'Kirim',
	'revreview-submitting' => 'Mengirimkan...',
	'revreview-submit-review' => 'Terima revisi',
	'revreview-submit-unreview' => 'Tolak revisi',
	'revreview-submit-reject' => 'Tolak perubahan',
	'revreview-submit-reviewed' => 'Selesai. Diterima!',
	'revreview-submit-unreviewed' => 'Selesai. Tidak diterima!',
	'revreview-successful' => "'''Revisi [[:$1|$1]] berhasil ditandai. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} lihat revisi stabil])'''",
	'revreview-successful2' => "'''Penandaan revisi [[:$1|$1]] berhasil dibatalkan.'''",
	'revreview-poss-conflict-p' => "'''Peringatan: [[User:$1|$1]] mulai meninjau halaman ini pada $2 $3.'''",
	'revreview-poss-conflict-c' => "'''Peringatan: [[User:$1|$1]] mulai meninjau perubahan ini pada $2 $3.'''",
	'revreview-toolow' => '\'\'\'Anda harus menilai setiap atribut lebih tinggi daripada "tidak memadai" agar revisi dianggap telah ditinjau.\'\'\' 

Untuk menghapus status tinjauan revisi, klik "tolak". 

Silakan tekan tombol "back" pada peramban Anda dan coba lagi.',
	'revreview-update' => "'''Mohon [[{{MediaWiki:Validationpage}}|tinjau]] semua perubahan tertunda ''(ditampilkan di bawah)'' yang dibuat sejak versi stabil dimuat.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Perubahan Anda belum masuk versi stabil.</span> 

Harap tinjau semua perubahan yang ditunjukkan di bawah ini untuk membuat suntingan Anda muncul dalam versi stabil.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Perubahan Anda belum masuk versi stabil. Ada perubahan terdahulu yang menunggu tinjauan.</span> 

Harap tinjau semua perubahan yang ditunjukkan di bawah ini untuk membuat suntingan Anda muncul dalam versi stabil.',
	'revreview-update-includes' => 'Beberapa templat/berkas telah diperbaharui:',
	'revreview-reject-text-list' => "Dengan melakukan tindakan ini, Anda akan '''menolak''' {{PLURAL:$1|perubahan|perubahan}} berikut:",
	'revreview-reject-text-revto' => 'Ini akan mengembalikan halaman kepada [{{fullurl:$1|oldid=$2}} versi per $3].',
	'revreview-reject-summary' => 'Ringkasan:',
	'revreview-reject-confirm' => 'Tolak perubahan ini',
	'revreview-reject-cancel' => 'Batalkan',
	'revreview-reject-summary-cur' => 'Menolak {{PLURAL:$1|perubahan|$1 perubahan}} terakhir (oleh $2) dan mengembalikan revisi $3 oleh $4',
	'revreview-reject-summary-old' => 'Menolak {{PLURAL:$1|perubahan|$1 perubahan}} pertama (oleh $2) setelah revisi $3 oleh $4',
	'revreview-reject-summary-cur-short' => 'Menolak {{PLURAL:$1|perubahan|$1 perubahan}} terakhir dan mengembalikan revisi $2 oleh $3',
	'revreview-reject-summary-old-short' => 'Menolak {{PLURAL:$1|perubahan|$1 perubahan}} pertama setelah revisi $2 oleh $3',
	'revreview-tt-flag' => 'Terima revisi dengan status "terperiksa"',
	'revreview-tt-unflag' => 'Tolak revisi ini dengan status "belum diperiksa"',
	'revreview-tt-reject' => 'Tolak perubahan dengan mengembalikan perubahan',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'revreview-submit' => 'Dànyé',
	'revreview-submitting' => 'Nà dànyé...',
	'revreview-submit-review' => 'Kwelụ',
	'revreview-submit-unreview' => 'Ékwèlụ',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'revreview-log' => 'Komento:',
);

/** Icelandic (Íslenska)
 * @author Spacebirdy
 */
$messages['is'] = array(
	'revreview-flag' => 'Endurskoða þessa útgáfu',
	'revreview-log' => 'Athugasemd:',
	'revreview-submit' => 'Staðfesta',
	'revreview-submitting' => 'Staðfesta …',
);

/** Italian (Italiano)
 * @author Aushulz
 * @author Beta16
 * @author Blaisorblade
 * @author Darth Kule
 * @author EdoDodo
 * @author F. Cosoleto
 * @author Gianfranco
 * @author Pietrodn
 */
$messages['it'] = array(
	'revisionreview' => 'Revisiona versioni',
	'revreview-failed' => "'''Non è possibile esaminare questa revisione.'''",
	'review_page_invalid' => 'Il titolo della pagina di destinazione non è valido.',
	'review_page_notexists' => 'La pagina di destinazione non esiste.',
	'review_page_unreviewable' => 'La pagina di destinazione non è revisionabile.',
	'review_no_oldid' => 'ID di revisione non specificato.',
	'review_bad_oldid' => 'La revisione di destinazione non esiste.',
	'review_conflict_oldid' => 'Qualcuno ha già accettato o respinto questa revisione mentre la stavi esaminando.',
	'review_not_flagged' => 'La revisione di destinazione non è attualmente segnata come revisionata.',
	'review_denied' => 'Permesso negato.',
	'review_param_missing' => 'Un parametro è mancante o non valido.',
	'review_cannot_undo' => 'Questi cambiamenti non possono essere annullati perché susseguenti modifiche in sospeso hanno cambiato le stesse parti.',
	'review_cannot_reject' => 'Questi cambiamenti non sono stati respinti perché qualcuno ha già accettato alcune o tutte le modifiche in esame.',
	'review_reject_excessive' => 'Non è possibile rifiutare tutte queste modifiche in una volta.',
	'review_reject_nulledits' => 'Non è possibile rifiutare questi cambiamenti perché tali revisioni risultano essere senza un contenuto.',
	'revreview-check-flag-p' => 'Accetta questa versione ({{PLURAL:$1|inclusa una modifica|incluse $1 modifiche}} in sospeso)',
	'revreview-check-flag-p-title' => "Accettare tutte le modifiche attualmente in sospeso assieme con le vostre. Utilizzare solo se hai già visto l'intera diff delle modifiche in sospeso.",
	'revreview-check-flag-u' => 'Accetta questa pagina non revisionata',
	'revreview-check-flag-u-title' => "Accettare questa versione della pagina. Utilizzare solo se hai già visto l'intera pagina.",
	'revreview-check-flag-y' => 'Accettare queste modifiche',
	'revreview-check-flag-y-title' => 'Accetta tutti i cambiamenti che hai fatto in questa modifica.',
	'revreview-flag' => 'Revisiona questa versione',
	'revreview-invalid' => "'''Errore:''' nessuna versione [[{{MediaWiki:Validationpage}}|revisionata]] corrisponde all'ID fornito.",
	'revreview-log' => 'Commento:',
	'revreview-main' => "Devi selezionare una particolare revisione di una pagina di contenuti per revisionarla.

Vedi l'[[Special:Unreviewedpages|elenco delle pagine non revisionate]].",
	'revreview-stable1' => 'Puoi visualizzare [{{fullurl:$1|stableid=$2}} questa versione verificata] e vedere se adesso è la [{{fullurl:$1|stable=1}} versione stabile] di questa pagina.',
	'revreview-stable2' => 'Puoi visualizzare la [{{fullurl:$1|stable=1}} versione stabile] di questa pagina.',
	'revreview-submit' => 'Invia',
	'revreview-submitting' => 'Invio in corso...',
	'revreview-submit-review' => 'Accetta revisione',
	'revreview-submit-unreview' => 'Non accetta versione',
	'revreview-submit-reject' => 'Rifiuta modifiche',
	'revreview-submit-reviewed' => 'Fatto. Accettata!',
	'revreview-submit-unreviewed' => 'Fatto. Non accettata!',
	'revreview-successful' => "'''Versione di [[:$1|$1]] verificata con successo. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} visualizza versione stabile])'''",
	'revreview-successful2' => "'''Versione di [[:$1|$1]] marcata come non verificata con successo.'''",
	'revreview-poss-conflict-p' => "'''Attenzione: [[User:$1|$1]] ha iniziato a revisionare questa pagina in data $2 alle $3.'''",
	'revreview-poss-conflict-c' => "'''Attenzione: [[User:$1|$1]] ha iniziato a revisionare queste modifiche in data $2 alle $3.'''",
	'revreview-adv-reviewing-p' => 'Nota: altri revisori sono in grado di vedere che esamini questa pagina.',
	'revreview-adv-reviewing-c' => 'Nota: altri revisori sono in grado di vedere che esamini questi cambiamenti.',
	'revreview-sadv-reviewing-p' => 'Puoi $1 che stai revisionando questa pagina agli altri utenti.',
	'revreview-sadv-reviewing-c' => 'Puoi $1 che stai revisionando queste modifiche agli altri utenti.',
	'revreview-adv-start-link' => 'segnalare',
	'revreview-adv-stop-link' => 'annulla',
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Revisiona]] le modifiche in sospeso ''(mostrate di seguito)'' apportate dalla versione stabile.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Le tue modifiche non sono ancora nella versione stabile.</span> 

 Si prega di rivedere tutte le modifiche di seguito riportate perché le tue modifiche vengano visualizzate nella versione stabile. 
 Potrebbe essere necessario prima proseguire o "annullare" modifiche.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Le tue modifiche non sono ancora nella versione stabile. Ci sono precedenti modifiche che aspettano una revisione.</span> 

 Si prega di rivedere tutte le modifiche di seguito riportate perché le tue modifiche vengano visualizzate nella versione stabile. 
 Potrebbe essere necessario prima proseguire o "annullare" modifiche.',
	'revreview-update-includes' => 'Alcuni Template/file sono stati aggiornati (pagine non revisionate in grassetto):',
	'revreview-reject-text-list' => "Confermando quest'azione verranno '''respinte''' le modifiche testuali {{PLURAL:$1|dalla seguente versione|dalle seguenti versioni}} di [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Questo ripristinerà la pagina alla [{{fullurl:$1|oldid=$2}} versione datata $3].',
	'revreview-reject-summary' => 'Sommario:',
	'revreview-reject-confirm' => 'Rifiuta queste modifiche',
	'revreview-reject-cancel' => 'Annulla',
	'revreview-reject-summary-cur' => "{{PLURAL:$1|Respinta l'ultima modifica al|Respinte le ultime $1 modifiche al}} testo (di $2) e ripristinata la versione $3 di $4",
	'revreview-tt-flag' => 'Accetta questa versione marcandola come "verificata"',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Ohgi
 * @author Schu
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'revisionreview' => '特定版の査読',
	'revreview-failed' => "'''この版を査読できません。'''",
	'revreview-submission-invalid' => '送信内容は不完全か、もしくは不正なものでした。',
	'review_page_invalid' => '指定されたページ名は無効です。',
	'review_page_notexists' => '指定されたページは存在していません。',
	'review_page_unreviewable' => '指定されたページは閲覧できません。',
	'review_no_oldid' => '版IDが指定されていません。',
	'review_bad_oldid' => '指定した版は存在しません。',
	'review_conflict_oldid' => '閲覧中に誰かが、この版を既に承認または非承認にしました。',
	'review_not_flagged' => '対象の版は、現在、査読済になっていません。',
	'review_too_low' => '「不十分」となったフィールドが残っていると、版の査読を実行できません。',
	'review_bad_key' => '無効な包含パラメータキーです。',
	'review_bad_tags' => '指定したタグの値のいくつかが無効です。',
	'review_denied' => '許可されていません。',
	'review_param_missing' => 'パラメータが不足、もしくは無効です。',
	'review_cannot_undo' => '次の保留中の編集が同じ領域を変更したため、これらの変更を戻すことができません。',
	'review_cannot_reject' => '既に誰かがいくつか（あるいはすべての）編集を承認したため、これらの変更を却下できませんでした。',
	'review_reject_excessive' => 'これほど多くの編集を一度に却下することはできません。',
	'review_reject_nulledits' => 'すべてのリビジョンが空の編集なので、これらの変更を拒否することはできません。',
	'revreview-check-flag-p' => 'この版を承認する（保留中の$1コの{{PLURAL:$1|変更}}を含む）',
	'revreview-check-flag-p-title' => '自身の編集とともに現在保留中の変更をすべて承認する。
これは、あなたが既に保留中の変更全体の差分表示を確認した場合のみに使用してください。',
	'revreview-check-flag-u' => 'この未査読ページを受理する',
	'revreview-check-flag-u-title' => 'ページのこの版を受理する。この機能は既にページ全体を確認し終わった場合にのみ使用してください。',
	'revreview-check-flag-y' => 'これらの変更を受理',
	'revreview-check-flag-y-title' => 'この編集で行った変更をすべて受理します。',
	'revreview-flag' => 'この特定版の査読',
	'revreview-reflag' => 'この版を再査読',
	'revreview-invalid' => "'''無効な対象:''' 指定されたIDに対応する[[{{MediaWiki:Validationpage}}|査読済み]]版はありません。",
	'revreview-log' => '査読内容の要約:',
	'revreview-main' => '査読のためには対象記事から特定の版を選択する必要があります。

[[Special:Unreviewedpages|未査読ページ一覧]]を参照してください。',
	'revreview-stable1' => '[{{fullurl:$1|stableid=$2}} この判定版]を閲覧し、それがこのページの現在の[{{fullurl:$1|stable=1}} 公開版]であるかどうかを確かめることができます。',
	'revreview-stable2' => 'このページの[{{fullurl:$1|stable=1}} 公開版]を閲覧することができます。',
	'revreview-submit' => '送信',
	'revreview-submitting' => '送信中…',
	'revreview-submit-review' => '版を承認',
	'revreview-submit-unreview' => '版の承認を取り消し',
	'revreview-submit-reject' => '変更を却下',
	'revreview-submit-reviewed' => '完了。承認されました！',
	'revreview-submit-unreviewed' => '完了。未承認になりました！',
	'revreview-successful' => "'''[[:$1|$1]] の特定版の判定に成功しました。([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} 固定版を閲覧])'''",
	'revreview-successful2' => "'''[[:$1|$1]] の特定版の判定取り消しに成功しました。'''",
	'revreview-poss-conflict-p' => "'''警告：[[User:$1|$1]]がこのページの査読を $2 $3 に開始しました。'''",
	'revreview-poss-conflict-c' => "'''警告：[[User:$1|$1]]がこの変更の査読を $2 $3 に開始しました。'''",
	'revreview-toolow' => "'''版を査読済みとするには、すべての判定要素を「不十分」より高い評価にする必要があります。'''

版の査読評価を消す場合は、「未承認」をクリックしてください。

ブラウザの「戻る」ボタンを押して再試行してください。",
	'revreview-update' => "'''承認版に加えられた保留中の変更 (''下記参照'') を[[{{MediaWiki:Validationpage}}|査読]]してください。'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">変更はまだ安定版に組み込まれていません。</span>

安定版として表示するためには、以下に示した変更すべてを査読し承認してください。',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">変更はまだ安定版に反映されていません。この編集よりも前になされた査読待ちの編集があります。</span>

変更を安定版に反映するには、下記の変更をすべて査読してください。',
	'revreview-update-includes' => '更新されたテンプレートやファイルがあります:',
	'revreview-reject-text-list' => "この操作を完了すると、以下の{{PLURAL:$1|変更}}を、次の理由で'''却下'''します：",
	'revreview-reject-text-revto' => 'ページを[{{fullurl:$1|oldid=$2}} $3版]へ差し戻します。',
	'revreview-reject-summary' => '要約:',
	'revreview-reject-confirm' => 'これらの変更を拒否',
	'revreview-reject-cancel' => '中止',
	'revreview-reject-summary-cur' => '最新の{{PLURAL:$1|テキストの変更| $1 のテキストの変更}}は $2 によって却下され、$4 による $3 版が復旧されました。',
	'revreview-reject-summary-old' => '最新の{{PLURAL:$1|テキストの変更| $1 のテキストの変更}}は $2 によって却下され、$4 による $3 版となりました',
	'revreview-reject-summary-cur-short' => '最新の{{PLURAL:$1|テキストの変更| $1 のテキストの変更}}は却下され、$3 による $2 版へ復旧されました',
	'revreview-reject-summary-old-short' => '最新の{{PLURAL:$1|テキストの変更| $1 のテキストの変更}}は却下され、$3 による $2 版となりました',
	'revreview-tt-flag' => 'この版に確認済みの印を付けて承認する',
	'revreview-tt-unflag' => 'この版に「未確認」の印を付けて未承認とする',
	'revreview-tt-reject' => 'ソーステキストへの変更を差し戻して却下する',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'revreview-log' => 'Bemærkenge:',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author David1010
 * @author Dawid Deutschland
 * @author Nodar Kherkheulidze
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'revisionreview' => 'ვერსიების შემოწმება',
	'revreview-failed' => "'''ამ ვერსიის შემოწმება შეუძლებელია.'''",
	'revreview-submission-invalid' => 'გადაცემა არასაკმარისი იყო ან არასწორი.',
	'review_page_invalid' => 'გვერდის საბოლოო სახელი არასწორია.',
	'review_page_notexists' => 'სამიზნე გვერდი არ არსებობს.',
	'review_page_unreviewable' => 'სამიზნე გვერდი შემოწმებადი არაა.',
	'review_no_oldid' => 'ვერსიის ID მოცემული არაა.',
	'review_bad_oldid' => 'მოცემული სამიზნე ვერსიის ID არ არსებობს.',
	'review_conflict_oldid' => 'სანამ თქვენ კითხულობდით, ვიღაცამ ეს ვერსია უკვე შეამოწმა ან უარყო.',
	'review_not_flagged' => 'სამიზნე ვერსია ამ დროსიათვის შემოწმებული არაა.',
	'review_too_low' => 'ვერსიის შემოწმება შეუძლებელია მანამ, სანამ ველები მნიშნულია, როგორც „არასაკმარისი“.',
	'review_bad_key' => 'მონიშვნის პარამეტრები არასწორია.',
	'review_denied' => 'თხოვნა უარყოფილია.',
	'review_param_missing' => 'პარამეტრი დაკარგულია ან არასწორია.',
	'review_cannot_undo' => 'ამ ცვლილების გაუქმება შეუძლებელია, რადგან ამავე სივრცეში სხვა შემდგომი ცვლილებებიც მოხდა.',
	'review_cannot_reject' => 'ამ ცვლილებების გაუქმება შეუძლებელია, რადგან სხვა მომხმარებელმა მათი ნაწილი ან ყველა მათგანი დამაკმაყოფილებლად ჩათვალა.',
	'review_reject_excessive' => 'ამდენი ცვლილების გაუქმება ერთ ჯერზე შეუძლებელია.',
	'revreview-check-flag-p' => 'შემოწმების მომლოდინე გადაუმოწმებელი რედაქტირების გამოქვეყნება.',
	'revreview-check-flag-u' => 'ამ შეუმოწმებელი გვერდის მიღება',
	'revreview-check-flag-u-title' => 'გვერდის ამ ვერსიის დამოწმება. ეს მხოლოდ მაშინ შეიძლება გაკეთდეს, როდესაც მთლიან სტატიას გადახედავთ.',
	'revreview-check-flag-y' => 'ჩემი ცვლილებების დამოწმება',
	'revreview-check-flag-y-title' => 'ყველა იმ ცვლილების მონიშვნა შემოწმებულად, რომელიც თქვენ ამ რედაქტირებით მოახდინეთ.',
	'revreview-flag' => 'შეამოწმეთ გვერდის ეს ვერსია',
	'revreview-reflag' => 'გადაამოწმეთ ეს ვერსია',
	'revreview-invalid' => "'''არასწორი მიზანი:''' არ არსებობს გვერდების [[{{MediaWiki:Validationpage}}|შემოწმებული]] ვერსიები, რომლებიც შეესაბამებიან ამ იდენტიფიკატორს.",
	'revreview-log' => 'კომენტარი:',
	'revreview-main' => 'თქვენ უნდა აირჩიოთ გვერდების ერთ-ერთი ვერსია შემოწმებისათვის.

იხილეთ [[Special:Unreviewedpages|შეუმოწმებელი გვერდების სია]].',
	'revreview-stable1' => 'სავარაუდოდ, თქვენ გსურთ [{{fullurl:$1|stableid=$2}} ამ შემოწმებული ვერსიის] ხილვა ან ამავე გვერდის [{{fullurl:$1|stable=1}}გამოქვეყნებული ვერსიის] (თუ იგი არსებობს).',
	'revreview-stable2' => 'იქნებ თქვენ გსურთ ამ გვერდის [{{fullurl:$1|stable=1}} გამოქვეყნებული ვერსიის] ხილვა?',
	'revreview-submit' => 'გაგზავნა',
	'revreview-submitting' => 'იგზავნება...',
	'revreview-submit-review' => 'ვერსიის შემოწმება',
	'revreview-submit-unreview' => 'შემოწმების უარყოფა',
	'revreview-submit-reject' => 'ცვლილებების გაუქმება',
	'revreview-submit-reviewed' => 'გაკეთდა, დამოწმდა!',
	'revreview-submit-unreviewed' => 'გაკეთდა, უარყოფილ იქნა!',
	'revreview-successful' => "'''არჩეული ვერსია [[:$1|$1]] წარმატებით მოინიშნა. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} სტაბილური ვერსიების ხილვა])'''",
	'revreview-successful2' => "'''არჩეული ვერსიისგან [[:$1|$1]] მონიშვნა მოხსნილია.'''",
	'revreview-adv-reviewing-p' => 'შენიშვნა: სხვა შემმოწმებლები ხედავენ, რომ თქვენ ამოწმებთ ამ გვერდს.',
	'revreview-adv-reviewing-c' => 'შენიშვნა: სხვა შემმოწმებლები ხედავენ, რომ თქვენ ამოწმებთ ამ ცვლილებებს.',
	'revreview-sadv-reviewing-p' => 'თქვენ შეგიძლაით იმის $1, რომ ამოწმებთ ამ გვერდს.',
	'revreview-sadv-reviewing-c' => 'თქვენ შეგიძლიათ იმის $1, რომ ამოწმებთ ამ ცვლილებებს.',
	'revreview-adv-start-link' => 'გამოცხადება',
	'revreview-adv-stop-link' => 'გამოცხადების გაუქმება',
	'revreview-update' => "'''გთხოვთ, [[{{MediaWiki:Validationpage}}|შეამოწმოთ]] ცვლილებები ''(ნაჩვენებია ქვემოთ)'', შეტანილი მიღებულ ვერსიაში.'''",
	'revreview-update-includes' => 'ზოგი თარგი ან ფაილი განახლდა:',
	'revreview-reject-summary' => 'რეზიუმე:',
	'revreview-reject-confirm' => 'ამ ცვლილების გაუქმება',
	'revreview-reject-cancel' => 'გაუქმება',
	'revreview-reject-summary-cur' => '$2-ის {{PLURAL:$1|ბოლო ცვლილება|$1 ბოლო ცვლილებები}} {{PLURAL:$1|გაუქმდება|გაუქმდება}} და $3 ვერსია შეიცვლება წინა $4 ვერსიით',
	'revreview-reject-summary-old' => '$2-ის {{PLURAL:$1|ბოლო ცვლილება|$1 ბოლო ცვლილებები}}, ვერსია $3, რომელიც ვერსია $4-ს მოსდევდა, {{PLURAL:$1|გაუქმდება|გაუქმდება}}',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|ბოლო ცვლილება|$1 ბოლო ცვლილებები}} გაუქმდება და $2 ვერსია დაბრუნდება $3 ვერსიაზე',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|პირველი ცვლილება|$1 ცვლილება}}, ვერსია $2, რომელიც ვერსია $3-ს მოსდევდა, გაუქმდება',
	'revreview-tt-flag' => 'მონიშნეთ როგორც შემოწმებული',
	'revreview-tt-unflag' => 'აღარ მაჩვენო ის ვერსია, რომელშიც მე მონიშვნა უარვყავი',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'revisionreview' => 'نۇسقالارعا سىن بەرۋ',
	'revreview-flag' => 'بۇل نۇسقاعا (#$1) سىن بەرۋ',
	'revreview-log' => 'ماندەمەسى:',
	'revreview-main' => 'سىن بەرۋ ٴۇشىن ماعلۇمات بەتىنىڭ ەرەكشە نۇسقاسىن بولەكتەۋىڭىز كەرەك.

سىن بەرىلمەگەن بەت ٴتىزىمى ٴۇشىن [[{{ns:special}}:Unreviewedpages]] بەتىن قاراڭىز.',
	'revreview-submit' => 'سىن جىبەرۋ',
	'revreview-toolow' => 'نۇسقاعا سىن بەرىلگەن دەپ سانالۋى ٴۇشىن تومەندەگى قاسىيەتتەردىڭ قاي-قايسىسىن «بەكىتىلمەگەن»
دەگەننەن جوعارى دەڭگەي بەرۋىڭىز كەرەك. نۇسقانى كەمىتۋ ٴۇشىن, بارلىق ورىستەردى «بەكىتىلمەگەن» دەپ تاپسىرىلسىن.',
	'revreview-update' => 'تىياناقتى نۇسقا بەكىتىلگەننەن بەرى جاسالعان وزگەرىستەرگە (تومەندە كورسەتىلگەن) سىن بەرىپ شىعىڭىز.
كەيبىر جاڭارتىلعان ۇلگىلەر/سۋرەتتەر:',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'revisionreview' => 'Нұсқаларға сын беру',
	'revreview-flag' => 'Бұл нұсқаға сын беру',
	'revreview-log' => 'Мәндемесі:',
	'revreview-main' => 'Сын беру үшін мағлұмат бетінің ерекше нұсқасын бөлектеуіңіз керек.

Сын берілмеген бет тізімі үшін [[{{ns:special}}:Unreviewedpages]] бетін қараңыз.',
	'revreview-submit' => 'Сын жіберу',
	'revreview-toolow' => 'Нұсқаға сын берілген деп саналуы үшін төмендегі қасиеттердің қай-қайсысын «бекітілмеген»
дегеннен жоғары деңгей беруіңіз керек. Нұсқаны кеміту үшін, барлық өрістерді «бекітілмеген» деп тапсырылсын.',
	'revreview-update' => 'Тиянақты нұсқа бекітілгеннен бері жасалған өзгерістерге (төменде көрсетілген) сын беріп шығыңыз.',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'revisionreview' => 'Nusqalarğa sın berw',
	'revreview-flag' => 'Bul nusqağa sın berw',
	'revreview-log' => 'Mändemesi:',
	'revreview-main' => 'Sın berw üşin mağlumat betiniñ erekşe nusqasın bölektewiñiz kerek.

Sın berilmegen bet tizimi üşin [[{{ns:special}}:Unreviewedpages]] betin qarañız.',
	'revreview-submit' => 'Sın jiberw',
	'revreview-toolow' => 'Nusqağa sın berilgen dep sanalwı üşin tömendegi qasïetterdiñ qaý-qaýsısın «bekitilmegen»
degennen joğarı deñgeý berwiñiz kerek. Nusqanı kemitw üşin, barlıq öristerdi «bekitilmegen» dep tapsırılsın.',
	'revreview-update' => 'Tïyanaqtı nusqa bekitilgennen beri jasalğan özgeristerge (tömende körsetilgen) sın berip şığıñız.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'revreview-log' => 'យោបល់៖',
	'revreview-submit' => 'ដាក់ស្នើ',
	'revreview-submitting' => 'កំពុង​ដាក់ស្នើ...',
	'revreview-update-includes' => 'ទំព័រគំរូ/រូបភាពមួយចំនួនត្រូវបានបន្ទាន់សម័យរួចហើយ៖',
);

/** Korean (한국어)
 * @author Gapo
 * @author Kwj2772
 */
$messages['ko'] = array(
	'revisionreview' => '편집들을 검토하기',
	'revreview-failed' => "'''이 판을 검토하지 못했습니다.''' 요청이 완전하지 못하거나 잘못되었습니다.",
	'review_page_invalid' => '대상 문서 제목이 잘못되었습니다.',
	'review_page_notexists' => '대상 문서가 존재하지 않습니다.',
	'review_page_unreviewable' => '대상 문서가 검토 가능한 문서가 아닙니다.',
	'review_no_oldid' => '판 번호가 정의되지 않았습니다.',
	'review_bad_oldid' => '해당 판이 존재하지 않습니다.',
	'review_not_flagged' => '해당 판이 아직 검토되지 않았습니다.',
	'review_too_low' => '어떤 입력 사항을 "부적절"으로 남겨 둔 채로 검토할 수 없습니다.',
	'review_bad_key' => '틀/파일 포함 변수 키가 잘못되었습니다.',
	'review_denied' => '권한 없음',
	'review_param_missing' => '매개 변수가 없거나 잘못되었습니다.',
	'review_reject_excessive' => '이렇게 많은 편집을 한꺼번에 거부할 수는 없습니다.',
	'revreview-check-flag-p' => '검토를 기다리고 있는 판 배포하기',
	'revreview-check-flag-p-title' => '당신의 편집과 함께 지금 검토를 기다리고 있는 모든 편집을 승인합니다. 모든 검토 대기 중인 편집을 확인한 후에만 이 기능을 사용해주세요.',
	'revreview-check-flag-u' => '이 검토하지 않은 페이지를 승인',
	'revreview-check-flag-u-title' => '이 판을 승인합니다. 전체 문서를 다 보았을 때만 사용하십시오.',
	'revreview-check-flag-y' => '다음 변경 사항을 승인',
	'revreview-check-flag-y-title' => '현재 편집에서 행한 모든 변경 사항을 승인합니다.',
	'revreview-flag' => '이 판을 검토하기',
	'revreview-reflag' => '이 판을 다시 검토하기',
	'revreview-invalid' => "'''대상이 잘못됨:''' 주어진 ID와 대응되는 [[{{MediaWiki:Validationpage}}|검토된 판]]이 없습니다.",
	'revreview-log' => '의견:',
	'revreview-main' => '검토하려면 문서의 특정 판을 선택해야 합니다.

[[Special:Unreviewedpages|검토되지 않은 문서 목록]]을 참조하십시오.',
	'revreview-stable1' => '[{{fullurl:$1|stableid=$2}} 검토된 버전]을 읽어보고 지금 이 문서의 [{{fullurl:$1|stable=1}} 배포판]인 지 확인해보실 수 있습니다.',
	'revreview-stable2' => '이 문서의 [{{fullurl:$1|stable=1}} 배포판]을 보기를 원하실 수 있습니다.',
	'revreview-submit' => '보내기',
	'revreview-submitting' => '보내는 중...',
	'revreview-submit-review' => '편집 승인',
	'revreview-submit-unreview' => '편집 승인 철회',
	'revreview-submit-reject' => '편집 거부',
	'revreview-submit-reviewed' => '완료. 승인하였습니다!',
	'revreview-submit-unreviewed' => '완료. 승인 취소하였습니다!',
	'revreview-successful' => "'''[[:$1|$1]] 문서의 편집이 성공적으로 검토되었습니다. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} 안정 버전 보기])'''",
	'revreview-successful2' => "'''[[:$1|$1]] 문서의 편집이 성공적으로 검토 철회되었습니다.'''",
	'revreview-toolow' => '\'\'\'당신은 문서를 검토하려면 등급을 모두 "부적절"보다 높게 매겨야 합니다.\'\'\'

판의 검토를 철회하려면 모든 란을 "부적절"으로 설정하십시오.

브라우저의 "뒤로" 버튼을 눌러 다시 시도하십시오.',
	'revreview-update' => "'''승인된 판에 이루어진 아래의 검토를 기다리고 있는 편집을 [[{{MediaWiki:Validationpage}}|검토]]해주십시오.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">당신의 편집은 아직 승인되지 않았습니다.</span>

당신의 편집을 승인하려면 아래에 표시된 모든 편집을 검토해주십시오.
먼저 문서 내용을 보충하거나 편집을 되돌려야 할 수도 있습니다.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">당신의 편집은 아직 승인되지 않았습니다. 검토를 기다리고 있는 이전의 편집이 있습니다.</span>

당신의 편집을 승인하려면 아래에 보이는 모든 편집 사항을 검토해주십시오.
필요하다면 내용을 보충하거나 편집을 되돌리십시오.',
	'revreview-update-includes' => '일부 틀이나 파일이 수정되었습니다:',
	'revreview-reject-cancel' => '취소',
	'revreview-tt-flag' => '이 판을 검토하기',
	'revreview-tt-unflag' => '이 판에 대한 검토 취소하기',
	'revreview-tt-reject' => '편집을 되돌려 편집 승인을 거부',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'revisionreview' => 'Versione nohkike',
	'revreview-failed' => "'''Mer kunnte di Version nit nohkike.'''",
	'revreview-submission-invalid' => 'De Einjaab wohr nit kummplätt udder sönßwi nit jöltesch.',
	'review_page_invalid' => 'Dä Ziel-Tittel för di Sigg es onjöltesch',
	'review_page_notexists' => 'Di Ziel_Sigg jitt et nit.',
	'review_page_unreviewable' => 'Di Ziel_Sigg kam_mer nit nohkike.',
	'review_no_oldid' => 'Kein Kännong för en Version es aanjejovve',
	'review_bad_oldid' => 'Esu en Kännong för en Version jidd et nit.',
	'review_conflict_oldid' => 'Sönßwää hät alld heh di Version jootjeheiße udder afjelehnt, derwiel Do se noch aam Beloore wohß.',
	'review_denied' => 'Zohjang verbodde.',
	'review_param_missing' => 'Ene Parrameeter fählt, udder es nit jöltesch.',
	'review_cannot_undo' => 'Mer künne di Änderonge nit retuur nämme weil noch ander Änderonge aan dersellve Shtelle nohjekik wääde möße.',
	'review_cannot_reject' => 'Do kanns di Änderonge nit mieh aflehne, weil Eine alld ene Aandeil udder alle dovun joodjeheiße hät.',
	'review_reject_excessive' => 'Esu vill Änderonge op eijmohl kam_mer nit aflehne.',
	'review_reject_nulledits' => 'Heh di Änderonge künne nit retuur jemaat wääde, weil domet jaa nix verändert woode es.',
	'revreview-check-flag-p' => 'Don heh di Version aanämme, {{PLURAL:$1|ein noh_nit aanjenumme Änderong|$1 noh_nit aanjenumme Änderonge}}
enjeschloßße',
	'revreview-check-flag-y' => 'Donn ming Änderonge aannämme',
	'revreview-check-flag-y-title' => 'Donn all de Änderonge aannämme, di De heh jemaat häs.',
	'revreview-flag' => 'Donn heh di Version nohkike!',
	'revreview-reflag' => 'Donn heh di Version norr_ens nohkike',
	'revreview-invalid' => "Dat es e '''onjöltesch Ziihl:''' kei [[{{MediaWiki:Validationpage}}|nohjekik]] Version paß met dä aanjejovve Kännong zesamme.",
	'revreview-log' => 'Koot zosamme jefaß:',
	'revreview-main' => 'Do moß en beschtemmpte Version vun en Enhalts_Sigg ußsöhke, öm se ze
nohzekike.

Looer noh de [[Special:Unreviewedpages|Leß met de nit nohjekikte Sigge]].',
	'revreview-stable1' => 'Velleisch wells De joh [{{fullurl:$1|stableid=$2}} heh di nohjekik Version] aankike un looere of se jez de [{{fullurl:$1|stable=1}} aktoälle {{int:stablepages-stable}}] vun dä Sigg es?',
	'revreview-stable2' => 'Velleisch wells De joh de [{{fullurl:$1|stableid=1}} {{int:stablepages-stable}}] aankike, wann noch ein doh es?',
	'revreview-submit' => 'Lohß Jonn!',
	'revreview-submitting' => 'Am Övverdraare&nbsp;…',
	'revreview-submit-review' => 'Heh di Version joodheiße',
	'revreview-submit-unreview' => 'Heh di Version nit joodheiße',
	'revreview-submit-reject' => 'Donn de Änderonge nit joodheiße',
	'revreview-submit-reviewed' => 'Jedonn. Aanjenumme.',
	'revreview-submit-unreviewed' => 'Jedonn. Afjelehnt.',
	'revreview-successful' => "'''Di Version vun dä Sigg „[[:$1|$1]]“ es jäz {{lcfirst:{{int:revreview-approved}}}}. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} De {{int:stablepages-stable}} aanloore])'''",
	'revreview-successful2' => "'''Di Version vun dä Sigg „[[:$1|$1]]“ es jäz wider zeröck jeshtoof.'''",
	'revreview-poss-conflict-p' => "'''Opjepaß: {{GENDER:$2|Dä|Et|Dä Metmaacher|De|Dat}} [[User:$1|$1]] hät aam $2 öm $3 Uhr aanjefange, heh di Sigg nohzekike.'''",
	'revreview-poss-conflict-c' => "'''Opjepaß: {{GENDER:$2|Dä|Et|Dä Metmaacher|De|Dat}} [[User:$1|$1]] hät aam $2 öm $3 Uhr aanjefange, heh di Änderonge nohzekike.'''",
	'revreview-toolow' => 'Do moß för jeede vun dä Eijeschaffte unge en Not udder Präddikaat jävve, wat bäßer wi „{{lcfirst:{{int:revreview-style-0}}}}“ es, domet di Version als nohjekik jeldt. Öm en Version widder zeröckzeshtoofe, donn alle Präddikaate op „{{lcfirst:{{int:revreview-style-0}}}}“ säze.',
	'revreview-update' => "Bes esu joot, un donn all de Änderunge ''(unge sin se opjeliß)'' [[{{MediaWiki:Validationpage}}|nohkike]], di jemaat woodte, zick däm de {{int:stablepages-stable}} et letz [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} {{lcfirst:{{int:revreview-approved}}}}] woode es.<br />
'''E paa Schablohne, Datteije, udder beeds, sin jeändert woode:'''",
	'revreview-update-includes' => 'E paa Schabloone udder Dateije udder beeds sin jeändert woode:',
	'revreview-reject-summary' => 'Koot Zosammejefass, Quell:',
	'revreview-reject-confirm' => 'Donn heh di Änderonge aflehne',
	'revreview-reject-cancel' => 'Stopp! Avbreche!',
	'revreview-tt-flag' => 'Donn heh di Versino aannämme, endämm dat De sähß, dat De se jeprööv häß.',
	'revreview-tt-reject' => 'Donn heh di Änderonge aflehne un uß dä Sigg widder eruß nämme',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'revreview-log' => 'Sententia:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'revisionreview' => 'Versiounen nokucken',
	'revreview-failed' => "'''Dës Versioun konnt net nogekuckt ginn.'''",
	'revreview-submission-invalid' => 'Dat wat geschéckt gouf war net komplett oder net valabel.',
	'review_page_invalid' => 'Den Titel vun der Zilsäit ass net valabel.',
	'review_page_notexists' => "D'Zilsäit gëtt et net",
	'review_page_unreviewable' => "D'Zilsäit kann net nogekuckt ginn.",
	'review_no_oldid' => 'Keng Versiounsnummer (ID) uginn.',
	'review_bad_oldid' => 'Déi Versioun vun der Zilsäit gëtt et net.',
	'review_conflict_oldid' => 'Et huet en Aneren et akzeptéiert wéi dir am gaang waart nozekucken.',
	'review_not_flagged' => "D'Zilversioun ass elo net als nogekuckt markéiert.",
	'review_too_low' => 'D\'Versioun kann net nogekuckt ginn esoulaang wéi e puer Felder als "inadequat" markéiert sinn',
	'review_bad_key' => 'De Wäert vum Préifparameter ass net valabel',
	'review_bad_tags' => 'Et puer vun de Wäerter an de spezifizéierten Tagen sinn net valabel.',
	'review_denied' => 'Erlaabnes refuséiert',
	'review_param_missing' => 'E Paramter feelt oder en ass net valabel.',
	'review_cannot_undo' => 'Dës Ännerunge kënnen net zeréckgesat ginn well aner Ännerungen déi am Suspens sinn de selwechte Beräich änneren.',
	'review_cannot_reject' => 'Dës Ännerunge kënnen net refuséiert ginn well schonn een e puer (oder all) Ännerungen akzeptéiert huet.',
	'review_reject_excessive' => 'Souvill Ännerunge kënnen net mateneen refuséiert ginn.',
	'review_reject_nulledits' => "Dës Ännerungen kënnen net refuséiert ginn wëll all d'Ännerungen eidel sinn.",
	'revreview-check-flag-p' => 'Dës Versioun (mat {{PLURAL:$1|enger Ännerungen déi elo am Suspens ass|$1 Ännerungen déi elo am Suspens sinn}}) akzeptéieren  publizéieren',
	'revreview-check-flag-p-title' => 'All déi Ännerungen déi elo am Suspens sinn zesumme mat Ärer Ännerung akzeptéieren. Benotzt dëst nëmme wann Dir Iech all Ännerungen déi am Suspens sinn ugekuckt hutt.',
	'revreview-check-flag-u' => 'Dës net nogekuckte Säit akzeptéieren',
	'revreview-check-flag-u-title' => 'Dës Versioun vun der Säit akzeptéieren. Benotzt dëst nëmme wann Dir schonn déi ganz Säit gesinn hutt.',
	'revreview-check-flag-y' => 'Dës Ännerungen akzeptéieren',
	'revreview-check-flag-y-title' => 'All Ännerungen akzeptéieren déi Dir bei dëser Ännerung gemaach hutt.',
	'revreview-flag' => 'Dës Versioun nokucken',
	'revreview-reflag' => 'Dës Versioun nach emol nokucken oder als net nogekuckt markéieren',
	'revreview-invalid' => "'''Zil ass net valabel:''' keng [[{{MediaWiki:Validationpage}}|nogekuckte]] Versioun entsprécht der ID déi Dir uginn hutt.",
	'revreview-log' => 'Bemierkung:',
	'revreview-main' => "Dir musst eng prezis Versioun vun enger Inhaltssäit eraussichen fir se nokucken ze kënnen.

Kuckt d'[[Special:Unreviewedpages|Lëscht vun den net nogekuckte Sàiten]].",
	'revreview-stable1' => 'Dir wëllt eventuel [{{fullurl:$1|stableid=$2}} dës markéiert Versioun] gesinn a kucken ob et elo déi [{{fullurl:$1|stable=1}} publizéiert Versioun] vun dëser Säit ass.',
	'revreview-stable2' => 'Dir wëllt vläicht déi [{{fullurl:$1|stable=1}} publizéiert Versioun] vun dëser Säit gesinn.',
	'revreview-submit' => 'Späicheren',
	'revreview-submitting' => 'Iwwerdroen …',
	'revreview-submit-review' => 'Versioun akzeptéieren',
	'revreview-submit-unreview' => 'Versioun net akzeptéieren',
	'revreview-submit-reject' => 'Ännerungen zréckweisen',
	'revreview-submit-reviewed' => 'Fäerdeg. Nogekuckt!',
	'revreview-submit-unreviewed' => 'Fäerdeg. Net méi nogekuckt!',
	'revreview-successful' => "'''D'Versioun [[:$1|$1]] gouf nogekuckt. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} Déi nogekuckte Versioune weisen])'''",
	'revreview-successful2' => "'''D'Markéierung vun der Versioun vu(n) [[:$1|$1]] gouf ewechgeholl.'''",
	'revreview-poss-conflict-p' => "'''Opgepasst: [[User:$1|$1]] huet den $2 ëm $3 ugefaang dës Säit nozekucken.'''",
	'revreview-poss-conflict-c' => "'''Opgepasst: [[User:$1|$1]] huet den $2 ëm $3 ugefaang dës Ännerungen nozekucken.'''",
	'revreview-adv-reviewing-p' => 'Notiz: Aner Benotzer gesinn datt Dir dës Säit nokuckt.',
	'revreview-adv-reviewing-c' => 'Notiz: Aner Benotzer gesinn datt Dir dës Ännerungen nokuckt',
	'revreview-sadv-reviewing-p' => 'Dir kënnt $1 datt Dir dës Säit nokuckt.',
	'revreview-sadv-reviewing-c' => 'Dir kënnt $1 bekanntginn</a> datt Dir dës Ännerungen nokuckt.',
	'revreview-adv-start-link' => 'bekanntginn',
	'revreview-adv-stop-link' => 'bekanntginn zréckzéien',
	'revreview-toolow' => "'''Dir musst fir all Attribut hei drënner eng Bewäertung ofginn déi besser ass wéi \"net adequat\" fir datt eng Versioun als nogekuckt betruecht ka ginn.'''

Fir de Statut nogekuckt vun enger Versioun ewechzehuelen klickt op \"net akzeptéieren\".

Klickt w.e.g op den ''Zréck''-Knäppche vun Ärem Browser a versicht et nach eng Kéier.",
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Kuckt]] w.e.g. all Ännerungen no ''(déi ënnendrënner gewise sinn)'' déi no der publizéiert Versioun gemaach goufen.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Är Ännerunge sinn nach net an der stabiler Versioun.</span>

Kuckt w.e.g. all d\'Ännerungen hei drënner no fir datt Är Ännerungen an der stabiler Versioun opdauchen.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Är Ännerunge sinn nach net an der stabiler Versioun. Et gëtt vireg Ännerungen déi drop waarde fir nogekuckt ze ginn.</span>

Kuckt w.e.g. all d\'Ännerungen hei drënner no fir datt Är Ännerungen akzeptéiert ginn.',
	'revreview-update-includes' => 'Schablounen/Fichiere aktualiséiert (net nogekuckte Säite si fettgegréckt):',
	'revreview-reject-text-list' => "Wann Dir dës Aktioun ofschléisst, da '''verwerft''' Dir d'Ännerunge vum Quelltext vun {{PLURAL:$1|der Versioun|de Versioune}} vum [[:$2|$2]]:",
	'revreview-reject-text-revto' => "Dëst setzt d'Säit zréck op d'[{{fullurl:$1|oldid=$2}} Versioun vum $3].",
	'revreview-reject-summary' => 'Resumé:',
	'revreview-reject-confirm' => 'Dës Ännerungen rejetéieren',
	'revreview-reject-cancel' => 'Ofbriechen',
	'revreview-reject-summary-cur' => "Déi lescht {{PLURAL:$1|Textännerung|$1 Textännerunge}} vum/vu(n) $2 {{PLURAL:$1|gouf|goufe}} refuséiert an d'Versioun $3 vum $4 gouf restauréiert",
	'revreview-reject-summary-old' => 'Déi lescht {{PLURAL:$1|Textännerung|$1 Textännerunge}} (vum $2) déi no der Versioun $3 vum $4 koum {{PLURAL:$1|gouf|goufe}} refuséiert',
	'revreview-reject-summary-cur-short' => "Déi lescht {{PLURAL:$1|Textännerung gouf|$1 Textännerunge goufe}} refuséiert an d'Versioun $2 vum $3 gouf restauréiert",
	'revreview-reject-summary-old-short' => 'Déi éischt {{PLURAL:$1|Textännerung|$1 Textännerungen}} déi no der Versioun $2 vum $3 {{PLURAL:$1|koum, gouf|koumen, goufe}} refuséiert',
	'revreview-tt-flag' => 'Dës Versioun als nogekuckt markéieren',
	'revreview-tt-unflag' => 'Dës Versioun net akzeptéieren andeem se als "net méi nogekuckt" markéiert gëtt',
	'revreview-tt-reject' => 'Dës Ännerungen vum Quelltext zeréckweisen an deem ze zréckgesat ginn',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'revisionreview' => 'Versies beoordeile',
	'revreview-failed' => "''''t Waas neet meugelik dees versie es gecontroleerd in te stelle.'''
't Formuleer waas incompleet of bevatde óngeljige waerd.",
	'review_page_invalid' => 'De doelpaginanaam is ongeldig.',
	'review_page_notexists' => 'De doelpagina besteit neet.',
	'review_page_unreviewable' => 'De doelpagina kan neet gecontroleerd waere.',
	'review_no_oldid' => "d'r Is gein versienummer opgegaeve.",
	'review_bad_oldid' => 'De opgegaeve doelversie besteit neet.',
	'review_not_flagged' => 'De doelversie is neet gemarkeerd es gecontroleerd.',
	'review_too_low' => "De versie kin neet es gecontroleerd waere gemarkeerd es neet alle veljer 'n anger waerd es {{int:Revreview-accuracy-0}} höbbe.",
	'review_bad_key' => 'Ongeljige paramaetersleutel.',
	'review_denied' => 'Geinen toegank.',
	'review_param_missing' => "d'r Óntbrik 'ne paramaeter of de opgegaeve paramaeter is ongeldig.",
	'revreview-check-flag-p' => 'Markeer óngecontroleerde wieziginge',
	'revreview-check-flag-p-title' => 'Publiceer alle ongecontroleerde wieziginge same mit dien wieziginge.
Gebroek dit allein es se de ongecontroleerde wieziginge haes bekeke.',
	'revreview-check-flag-u' => 'Aanvaard dees óngecontroleerde pagina',
	'revreview-check-flag-u-title' => 'Aaanvaard dees paginaversie.
Gebroek dit slechs wen se de ganse pagina al gezeen hes.',
	'revreview-check-flag-y' => 'Aanvaard dees verangering',
	'revreview-check-flag-y-title' => 'Aanvaarde alle bewirkingsverangeringe.',
	'revreview-flag' => 'Deze versie beoordeile',
	'revreview-reflag' => 'Hèrcontroleer dees versie',
	'revreview-invalid' => "'''Óngeljig bestömming:''' d'r is gein [[{{MediaWiki:Validationpage}}|gecontroleerde]] versie die euvereinkump mit 't ópgegaeve nómmer.",
	'revreview-log' => 'Opmerking:',
	'revreview-main' => "De mós 'n specifieke versie van 'n pagina keze die se wils controlere.

Zuuch de [[Special:Unreviewedpages|lies mit ongecontroleerde pagina's]].",
	'revreview-submit' => 'Slaon óp',
	'revreview-submitting' => 'Ópslaondje...',
	'revreview-submit-review' => 'Käör good',
	'revreview-submit-unreview' => 'Käör aaf',
	'revreview-submit-reject' => 'Wèrp aaf',
	'revreview-submit-reviewed' => 'Klaor. Gedaon!',
	'revreview-submit-unreviewed' => 'Gedaon. Neet gecontroleerd!',
	'revreview-successful2' => "'''De versie van [[:$1|$1]] is es neet gepubliceerd aangemerk.'''",
	'revreview-toolow' => "'''Doe mós tenminste alle ongerstaonde eigesjappe hoeger instelle es \"{{int:Revreview-accuracy-0}}\" om veur 'n versie aan te gaeve det dees is gecontroleerd.'''
Stel alle velje in op \"{{int:Revreview-accuracy-0}}\" om de waardering van 'n versie te verwiedere.

Klik op de knoep \"Trök\" in diene browser en probeer  t opnúuj.",
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Controleer]] e.t.b. de ''ongerstaonde'' wieziginge ten opzichte van de gepubliceerde versie.'''",
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Matasg
 */
$messages['lt'] = array(
	'review_page_invalid' => 'Taikinio puslapio pavadinimas yra neteisingas.',
	'review_page_notexists' => 'Taikinio puslapis neegzistuoja.',
	'revreview-log' => 'Komentaras:',
	'revreview-submit' => 'Siųsti',
	'revreview-submitting' => 'Siunčiama...',
	'revreview-submit-review' => 'Priimti peržiūrą',
	'revreview-submit-unreview' => 'nepriimti peržiūros',
	'revreview-submit-reviewed' => 'Atlikta. Priimta!',
	'revreview-submit-unreviewed' => 'Atlikta. Nepriimta!',
	'revreview-reject-cancel' => 'Atšaukti',
);

/** Literary Chinese (文言)
 * @author Itsmine
 */
$messages['lzh'] = array(
	'revreview-submit' => '成',
	'revreview-submitting' => '在處理',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brainmachine
 * @author Brest
 */
$messages['mk'] = array(
	'revisionreview' => 'Оценка на ревизии',
	'revreview-failed' => "'''Ревизијата не може да се оцени.'''",
	'revreview-submission-invalid' => 'Поднесеното е нецелосно или на друг начин неважечко.',
	'review_page_invalid' => 'Насловот на целната страница е неважечки.',
	'review_page_notexists' => 'Целната страница не постои.',
	'review_page_unreviewable' => 'Целната страница не е проверлива.',
	'review_no_oldid' => 'Нема назначено ID на ревизијата.',
	'review_bad_oldid' => 'Нема таква целна ревизија.',
	'review_conflict_oldid' => 'Некој друг ја прифатил/отприфатил ревизијава додека ја прегледувавте.',
	'review_not_flagged' => 'Целната ревизија моментално не е означена како прегледана.',
	'review_too_low' => 'Ревизијата не може да се провери без да оставите некои полиња како „несоодветна“.',
	'review_bad_key' => 'Неважечки параметарски клуч за вклучување.',
	'review_bad_tags' => 'Некои од наведените вредности на ознаката се неважечки.',
	'review_denied' => 'Пристапот е забранет.',
	'review_param_missing' => 'Недостасува параметар или зададениот е неважечки.',
	'review_cannot_undo' => 'Не можам да ги вратам овие промени бидејќи подоцнежните уредувања во исчекување ги имаат изменето истите делови.',
	'review_cannot_reject' => 'Не можете да ги одбиете овие промени бидејќи некој веќе прифатил некои (или сите) уредувања.',
	'review_reject_excessive' => 'Не можам да одбијам волку уредувања наеднаш.',
	'review_reject_nulledits' => 'Не можам да ги одбијам промениве бидејќи сите ревизии се уредувања без измени.',
	'revreview-check-flag-p' => 'Прифати ја оваа верзија (содржи $1 {{PLURAL:$1|промена|промени}} во исчекување)',
	'revreview-check-flag-p-title' => 'Прифаќање на сите тековни промени во исчекување заедно со сопственото уредување.
Користете го ова само ако веќе ги имате видено сите разлики со промените во исчекување.',
	'revreview-check-flag-u' => 'Прифати ја оваа непроверена страница',
	'revreview-check-flag-u-title' => 'Прифати ја оваа верзија на страницата. Користете го ова само ако веќе ја имате видено целата страница..',
	'revreview-check-flag-y' => 'Прифати ги овие промени',
	'revreview-check-flag-y-title' => 'Прифати ги сите промени направени при ова уредување.',
	'revreview-flag' => 'Оценка на оваа ревизија',
	'revreview-reflag' => 'Преоцени ја оваа ревизија',
	'revreview-invalid' => "'''Погрешна цел:''' нема [[{{MediaWiki:Validationpage}}|оценети]] ревизии кои соодветствуваат на наведениот ид. бр.",
	'revreview-log' => 'Забелешка:',
	'revreview-main' => 'Мора да изберете конкретна ревизија на страницата за проверка.

Погледајте го [[Special:Unreviewedpages|списокот на неоценети страници]].',
	'revreview-stable1' => 'Препорачуваме да ја погледате [{{fullurl:$1|stableid=$2}} оваа означена верзија] и да проверите дали таа сега е [{{fullurl:$1|stable=1}} објавената верзија] на оваа страница.',
	'revreview-stable2' => 'Ви препорачуваме да ја погледате [{{fullurl:$1|stable=1}} објавената верзија] на оваа страница.',
	'revreview-submit' => 'Поднеси',
	'revreview-submitting' => 'Поднесувам ...',
	'revreview-submit-review' => 'Прифати',
	'revreview-submit-unreview' => 'Неприфатливо',
	'revreview-submit-reject' => 'Одбиј промени',
	'revreview-submit-reviewed' => 'Готово. Одобрено!',
	'revreview-submit-unreviewed' => 'Готово. Тргнато одобрение!',
	'revreview-successful' => "'''Ревизијата на [[:$1|$1]] e успешно означена. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} прегледани верзии])'''",
	'revreview-successful2' => "'''Успешно отстранета ознака од ревизијата на [[:$1|$1]].'''",
	'revreview-poss-conflict-p' => "'''Предупредување: [[User:$1|$1]] почна да ја проверува страницава на $2 во $3 ч.'''",
	'revreview-poss-conflict-c' => "'''Предупредување: [[User:$1|$1]] почна да ги проверува промениве на $2 во $3.'''",
	'revreview-adv-reviewing-p' => 'Напомена: Другите прегледувачи можат да видат дека ја прегледувате страницава.',
	'revreview-adv-reviewing-c' => 'Напомена: Другите прегледувачи можат да видат дека ги прегледувате овие промени..',
	'revreview-sadv-reviewing-p' => 'Можете да $1 дека ја проверувате страницава, за да знаат другите.',
	'revreview-sadv-reviewing-c' => 'Можете да $1 дека ги проверувате промениве, за да знаат другите.',
	'revreview-adv-start-link' => 'разгласите',
	'revreview-adv-stop-link' => 'повлечи разглас',
	'revreview-toolow' => "'''Атрибутите мора да ги оцените со нешто повисоко од „недоволно“ за ревизијата да се смета за проверена.'''

За да го отстраните статусот на ревизијата, поставете ги сите полиња како „неприфатливо“.

Притиснете на копчето „назад“ во вашиот прелистувач и обидете се повторно.",
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|проверете]] ги промените ''(прикажани подолу)'' направени на прифатената верзија.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Вашите измени сè уште не се вклучени во стабилната верзија.</span>

За да се појават во верзијата, најпрвин прегледате ги сите долунаведени промени.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Вашите измени сè уште не се вклучени во стабилната верзија.</span> Има претходни уредувања што чекаат проверка.</span>

За да се појават во верзијата, најпрвин прегледате ги сите долунаведени промени.',
	'revreview-update-includes' => 'Подновени шаблони/податотеки (непроверените страници се задебелени):',
	'revreview-reject-text-list' => "Довршувајќи ја оваа постапка, ќе ги  '''отфрлите''' измените во изворниот текст на {{PLURAL:$1|скеднава ревизија|следниве ревизии}} на [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Ова ќе ја врати страницата на [{{fullurl:$1|oldid=$2}} верзијата од $3].',
	'revreview-reject-summary' => 'Опис:',
	'revreview-reject-confirm' => 'Отфрли ги промениве',
	'revreview-reject-cancel' => 'Откажи',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Одбиена последната промена|Одбиени последните $1 промени}} во текстот (од $2) и вратена ревизијата $3 на $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Одбиена првата промена во текстот (од $2), извршена|Одбиени првите $1 промени во текстот (од $2), извршени}} по ревизијата $3 на $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Одбиена последната промена|Одбиени последните $1 промени}} во текстот и вратена ревизијата $2 на $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Одбиена првата промена во текстот (од $2), извршена|Одбиени првите $1 промени во во текстот (од $2), извршена}} по ревизијата $2 на $3',
	'revreview-tt-flag' => 'Одобри ја оваа верзија означувајќи ја како проверена',
	'revreview-tt-unflag' => 'Направете ја оваа верзија неприфатлива означувајќи ја како „непроверена“',
	'revreview-tt-reject' => 'Одбијте ги овие промени во текстот, враќајќи ги',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'revisionreview' => 'പതിപ്പുകൾ സംശോധനം ചെയ്യുക',
	'revreview-failed' => "'''ഈ നാൾപ്പതിപ്പ് സംശോധനം ചെയ്യാൻ കഴിയില്ല.'''",
	'revreview-submission-invalid' => 'ഈ സമർപ്പിക്കൽ അപൂർണ്ണമോ മറ്റുവിധത്തിൽ അസാധുവോ ആണ്.',
	'review_page_invalid' => 'താളിനു ലക്ഷ്യമിട്ട പേര് അസാധുവാണ്.',
	'review_page_notexists' => 'ലക്ഷ്യമിട്ട താൾ നിലവിലില്ല.',
	'review_page_unreviewable' => 'ലക്ഷ്യമിട്ട താൾ സംശോധനം ചെയ്യാനാവില്ല.',
	'review_no_oldid' => 'നാൾപ്പതിപ്പിന്റെ ഐ.ഡി. വ്യക്തമാക്കിയിട്ടില്ല.',
	'review_bad_oldid' => 'ലക്ഷ്യം വെച്ച നാൾപ്പതിപ്പ് നിലവിലില്ല.',
	'review_conflict_oldid' => 'താങ്കൾ കണ്ടുകൊണ്ടിരുന്നപ്പോൾ ആരോ ഈ നാൾപ്പതിപ്പ് സ്വീകരിക്കുകയോ നിരാകരിക്കുകയോ ചെയ്തിരിക്കുന്നു.',
	'review_not_flagged' => 'ലക്ഷ്യ നാൾപ്പതിപ്പ് ഇപ്പോൾ സംശോധനം ചെയ്തതായി അടയാളപ്പെടുത്തിയിട്ടില്ല.',
	'review_too_low' => 'ചില മണ്ഡലങ്ങൾ "അപര്യാപ്തം" എന്നു കുറിച്ചിരിക്കെ നാൾപ്പതിപ്പ് സംശോധനം ചെയ്യാൻ കഴിയില്ല.',
	'review_bad_key' => 'ഉൾപ്പെടുത്താനുള്ള ചരം അസാധുവാണ്.',
	'review_bad_tags' => 'നൽകിയിരിക്കുന്ന റ്റാഗ് വിലകളിൽ ചിലവ അസാധുവാണ്.',
	'review_denied' => 'അനുമതി നിഷേധിച്ചിരിക്കുന്നു.',
	'review_param_missing' => 'ചരം ലഭ്യമല്ല അല്ലെങ്കിൽ അസാധുവാണ്.',
	'review_cannot_undo' => 'ഈ മാറ്റങ്ങൾ അവശേഷിക്കുന്ന ചില മാറ്റങ്ങൾ അതേ മേഖലയിലുള്ളവയായതിനാൽ തിരസ്കരിക്കാനാവില്ല.',
	'review_cannot_reject' => 'ആരോ ചില മാറ്റങ്ങൾ (ചിലപ്പോൾ എല്ലാ മാറ്റങ്ങളും) സ്വീകരിച്ചിട്ടുള്ളതിനാൽ ഈ മാറ്റങ്ങൾ നിരാകരിക്കാനാവില്ല.',
	'review_reject_excessive' => 'ഇത്രയധികം മാറ്റങ്ങൾ ഒറ്റയടിക്ക് നിരാകരിക്കാനാവില്ല.',
	'review_reject_nulledits' => 'എല്ലാ നാൾപ്പതിക്കുകളും ശൂന്യ തിരുത്തലുകളായതിനാൽ ഈ മാറ്റങ്ങൾ നിരാകരിക്കാനാവില്ല.',
	'revreview-check-flag-p' => 'ഈ പതിപ്പ് സ്വീകരിക്കുക (അവശേഷിക്കുന്ന {{PLURAL:$1|ഒരു മാറ്റം|$1 മാറ്റങ്ങൾ}} ഉൾക്കൊള്ളുന്നു)',
	'revreview-check-flag-p-title' => 'താങ്കളുടെ തിരുത്തലിനൊപ്പം അവശേഷിക്കുന്ന മാറ്റങ്ങളും സ്വീകരിക്കുക.
അവശേഷിക്കുന്ന മാറ്റങ്ങൾ സൃഷ്ടിച്ച വ്യത്യാസം കണ്ടിട്ടുണ്ടെങ്കിൽ മാത്രമേ ഇതുപയോഗിക്കാവൂ.',
	'revreview-check-flag-u' => 'സംശോധനം ചെയ്യാത്ത ഈ താൾ അംഗീകരിക്കുക',
	'revreview-check-flag-u-title' => 'താളിന്റെ ഈ പതിപ്പ് അംഗീകരിക്കുക. താൾ പൂർണ്ണമായും പരിശോധിച്ചിട്ടുണ്ടെങ്കിൽ മാത്രം ഇതുപയോഗിക്കുക.',
	'revreview-check-flag-y' => 'ഈ മാറ്റങ്ങൾ സ്വീകരിക്കുക',
	'revreview-check-flag-y-title' => 'ഈ തിരുത്തലിൽ താങ്കൾ വരുത്തിയ എല്ലാ മാറ്റങ്ങളും സ്വീകരിക്കുക.',
	'revreview-flag' => 'ഈ പതിപ്പ് സംശോധനം ചെയ്യുക',
	'revreview-reflag' => 'ഈ നാൾപ്പതിപ്പ് പുനർസംശോധനം ചെയ്യുക',
	'revreview-invalid' => "'''അസാധുവായ ലക്ഷ്യം:''' തന്ന IDക്കു ചേരുന്ന [[{{MediaWiki:Validationpage}}|സംശോധനം ചെയ്ത പതിപ്പുകൾ]] ഒന്നും തന്നെയില്ല.",
	'revreview-log' => 'അഭിപ്രായം:',
	'revreview-main' => 'സംശോധനം ചെയ്യാനായി ഉള്ളടക്ക താളിന്റെ ഒരു പ്രത്യേക നാൾപ്പതിപ്പ് താങ്കൾ തിരഞ്ഞെടുക്കേണ്ടതാണ്.

[[Special:Unreviewedpages|സംശോധനം ചെയ്യാത്ത താളുകളുടെ പട്ടിക]] കാണുക.',
	'revreview-stable1' => '[{{fullurl:$1|stableid=$2}} പതാക ചേർത്ത ഈ പതിപ്പ്] ആയിരിക്കാം താങ്കൾക്ക് കാണേണ്ടത് ഒപ്പം അത് ഇപ്പോൾ [{{fullurl:$1|stable=1}} പ്രസിദ്ധീകരിക്കപ്പെട്ട പതിപ്പ്] ആയോ എന്നും കാണുക.',
	'revreview-stable2' => 'ഈ താളിന്റെ [{{fullurl:$1|stable=1}} പ്രസിദ്ധീകരിക്കപ്പെട്ട പതിപ്പ്] താങ്കൾക്ക് കാണാവുന്നതാണ്.',
	'revreview-submit' => 'സമർപ്പിക്കുക',
	'revreview-submitting' => 'സമർപ്പിക്കുന്നു...',
	'revreview-submit-review' => 'നാൾപ്പതിപ്പ് അംഗീകരിക്കുക',
	'revreview-submit-unreview' => 'നാൾപ്പതിപ്പ് തിരസ്കരിക്കുക',
	'revreview-submit-reject' => 'മാറ്റങ്ങൾ നിരാകരിക്കുക',
	'revreview-submit-reviewed' => 'ചെയ്തുകഴിഞ്ഞു. അംഗീകരിക്കപ്പെട്ടിരിക്കുന്നു!',
	'revreview-submit-unreviewed' => 'ചെയ്തുകഴിഞ്ഞു. അംഗീകാരം നീക്കംചെയ്തിരിക്കുന്നു!',
	'revreview-successful' => "'''[[:$1|$1]] താളിന്റെ നാൾപ്പതിപ്പിൽ പതാക വിജയകരമായി ചേർത്തിരിക്കുന്നു. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} സ്ഥിരതയുള്ള പതിപ്പുകൾ കാണുക])'''",
	'revreview-successful2' => "'''[[:$1|$1]] താളിന്റെ നാൾപ്പതിപ്പിൽ നിന്നും പതാക വിജയകരമായി നീക്കിയിരിക്കുന്നു.'''",
	'revreview-poss-conflict-p' => "'''ശ്രദ്ധിക്കുക: $2, $3-നു ഈ താൾ സംശോധനം ചെയ്യാൻ [[User:$1|$1]] ആരംഭിച്ചിരിക്കുന്നു.'''",
	'revreview-poss-conflict-c' => "'''ശ്രദ്ധിക്കുക: $2, $3-നു ഈ മാറ്റങ്ങൾ സംശോധനം ചെയ്യാൻ [[User:$1|$1]] ആരംഭിച്ചിരിക്കുന്നു.'''",
	'revreview-adv-reviewing-p' => 'ശ്രദ്ധിക്കുക: മറ്റ് സംശോധകർക്ക് താങ്കൾ ഈ താൾ സംശോധനം ചെയ്യുന്നുണ്ടെന്ന് കാണാവുന്നതാണ്.',
	'revreview-adv-reviewing-c' => 'ശ്രദ്ധിക്കുക: മറ്റ് സംശോധകർക്ക് താങ്കൾ ഈ മാറ്റങ്ങൾ സംശോധനം ചെയ്യുന്നുണ്ടെന്ന് കാണാവുന്നതാണ്.',
	'revreview-adv-start-link' => 'പരസ്യമിടുക',
	'revreview-adv-stop-link' => 'പരസ്യം കളയുക',
	'revreview-toolow' => '\'\'\'നാൾപ്പതിപ്പ് സംശോധനം ചെയ്തതാണെന്ന് കണക്കാക്കാൻ താഴെ കൊടുത്തിരിക്കുന്ന ഓരോന്നിലും താങ്കൾ "അപര്യാപ്തം" എന്ന നിലയ്ക്ക് മുകളിലുള്ള ഒരു നിലവാരമിടേണ്ടതാണ്.\'\'\'

ഒരു നാൾപ്പതിപ്പിന്റെ സംശോധിത പദവി ഒഴിവാക്കാൻ എല്ലാ മണ്ഡലങ്ങളും "അസ്വീകാര്യം" എന്നു കുറിക്കുക.

താങ്കളുടെ ബ്രൗസറിന്റെ "ബാക്ക്" ബട്ടൺ ഞെക്കി പിന്നോട്ട് പോയി വീണ്ടും ശ്രമിക്കുക.',
	'revreview-update' => "'''ദയവായി അവശേഷിക്കുന്ന മാറ്റങ്ങൾ ''(താഴെ കൊടുത്തിരിക്കുന്നു)'' [[{{MediaWiki:Validationpage}}|സംശോധനം ചെയ്ത്]] അംഗീകരിക്കപ്പെട്ട പതിപ്പ് ആക്കുക.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">താങ്കൾ വരുത്തിയ മാറ്റങ്ങൾ സ്ഥിരപ്പെടുത്തിയ പതിപ്പിൽ ഉൾപ്പെടുത്തിയിട്ടില്ല.</span>

താങ്കളുടെ തിരുത്തലുകൾ സ്ഥിരപ്പെടുത്താൻ, ദയവായി താഴെ നൽകിയിരിക്കുന്ന എല്ലാ മാറ്റങ്ങളും സംശോധനം ചെയ്യുക.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">താങ്കൾ വരുത്തിയ മാറ്റങ്ങൾ ഇതുവരെ സ്ഥിരപ്പെടുത്തിയ പതിപ്പിൽ ഉൾപ്പെട്ടിട്ടില്ല, പഴയ മാറ്റങ്ങൾ സംശോധനത്തിന് അവശേഷിക്കുന്നു.</span>

താങ്കളുടെ തിരുത്തലുകൾ സ്ഥിരപ്പെടുത്താൻ, താഴെ കൊടുത്തിരിക്കുന്ന മാറ്റങ്ങൾ സംശോധനം ചെയ്യുക.',
	'revreview-update-includes' => 'ചില ഫലകങ്ങൾ/പ്രമാണങ്ങൾ പുതുക്കിയിരിക്കുന്നു (സംശോധനം ചെയ്യാത്ത താളുകൾ കട്ടികൂട്ടി കാണിച്ചിരിക്കുന്നു):',
	'revreview-reject-text-list' => "ഈ പ്രവൃത്തി പൂർത്തിയാകുമ്പോൾ, താങ്കൾ താഴെ കൊടുത്തിരിക്കുന്ന {PLURAL:$1|നാൾപ്പതിപ്പിൽ|നാൾപ്പതിപ്പുകളിൽ}} സ്രോതസ്സ് എഴുത്തിനു [[:$2|$2]]-ൽ ഉണ്ടായ മാറ്റങ്ങൾ '''നിരാകരിച്ചിരിക്കും''':",
	'revreview-reject-text-revto' => 'ഇത് താളിനെ അതിന്റെ [{{fullurl:$1|oldid=$2}} $3 തീയതിയിലെ പതിപ്പിലേയ്ക്ക്] മുൻപ്രാപനം ചെയ്യും.',
	'revreview-reject-summary' => 'ചുരുക്കം:',
	'revreview-reject-confirm' => 'ഈ മാറ്റങ്ങൾ നിരാകരിക്കുക',
	'revreview-reject-cancel' => 'റദ്ദാക്കുക',
	'revreview-reject-summary-cur' => 'എഴുത്തിൽ വരുത്തിയ അവസാന {{PLURAL:$1|മാറ്റം|$1 മാറ്റങ്ങൾ}} ($2 ചെയ്തത്) നിരാകരിക്കുകയും $4 സൃഷ്ടിച്ച നാൾപ്പതിപ്പ് $3 പുനഃസ്ഥാപിക്കുകയും ചെയ്തിരിക്കുന്നു',
	'revreview-reject-summary-old' => '$4 സൃഷ്ടിച്ച $3 എന്ന നാൾപ്പതിപ്പിനെ തുടർന്ന് ചെയ്ത ആദ്യഎഴുത്ത്  {{PLURAL:$1|മാറ്റം|$1 മാറ്റങ്ങൾ}} ($2 ചെയ്തത്) നിരാകരിച്ചിരിക്കുന്നു',
	'revreview-reject-summary-cur-short' => 'എഴുത്തിലെ അവസാന {{PLURAL:$1|മാറ്റം|$1 മാറ്റങ്ങൾ}} നിരാകരിക്കുകയും $3 സൃഷ്ടിച്ച നാൾപ്പതിപ്പ് $2 പുനഃസ്ഥാപിക്കുകയും ചെയ്തിരിക്കുന്നു',
	'revreview-reject-summary-old-short' => '$3 സൃഷ്ടിച്ച $2 എന്ന നാൾപ്പതിപ്പിനെ തുടർന്ന് എഴുത്തിൽ ചെയ്ത ആദ്യ {{PLURAL:$1|മാറ്റം|$1 മാറ്റങ്ങൾ}} നിരാകരിച്ചിരിക്കുന്നു',
	'revreview-tt-flag' => 'ഈ നാൾപ്പതിപ്പ് പരിശോധിച്ചതായി അടയാളപ്പെടുത്തി അംഗീകരിക്കുക',
	'revreview-tt-unflag' => 'ഈ നാൾപ്പതിപ്പ് "പരിശോധിച്ചതല്ല" എന്നടയാളപ്പെടുത്തി അംഗീകാരം നീക്കുക',
	'revreview-tt-reject' => 'എഴുത്തിൽ വന്ന ഈ മാറ്റങ്ങൾ പുനഃപ്രാപനം ചെയ്ത് നിരാകരിക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'revreview-log' => 'Тайлбар:',
	'revreview-submit' => 'Явуулах',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'revisionreview' => 'आवृत्त्या तपासा',
	'revreview-flag' => 'ही आवृत्ती तपासा',
	'revreview-invalid' => "'''चुकीचे टारगेट:''' कुठलीही [[{{MediaWiki:Validationpage}}|तपासलेली]] आवृत्ती दिलेल्या क्रमांकाशी जुळत नाही.",
	'revreview-log' => 'प्रतिक्रीया:',
	'revreview-main' => 'तपासण्यासाठी एखादी आवृत्ती निवडणे गरजेचे आहे.

न तपासलेल्या पानांची यादी पहाण्यासाठी [[Special:Unreviewedpages]] इथे जा.',
	'revreview-stable1' => 'तुम्ही कदाचित या पानाची [{{fullurl:$1|stableid=$2}} ही खूण केलेली आवृत्ती] आता [{{fullurl:$1|stable=1}} स्थिर आवृत्ती] झाली आहे किंवा नाही हे पाहू इच्छिता.',
	'revreview-stable2' => 'तुम्ही या पानाची [{{fullurl:$1|stable=1}} स्थिर आवृत्ती] पाहू शकता (जर उपलब्ध असेल तर).',
	'revreview-submit' => 'पाठवा',
	'revreview-successful' => "'''[[:$1|$1]] च्या निवडलेल्या आवृत्तीवर यशस्वीरित्या तपासल्याची खूण केलेली आहे.
([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} सर्व खूणा केलेल्या आवृत्त्या पहा])'''",
	'revreview-successful2' => "'''[[:$1|$1]] च्या निवडलेल्या आवृत्तीची खूण काढली.'''",
	'revreview-toolow' => 'एखादी आवृत्ती तपासलेली आहे अशी खूण करण्यासाठी तुम्ही खालील प्रत्येक पॅरॅमीटर्सना "अप्रमाणित" पेक्षा वरचा दर्जा देणे आवश्यक आहे.
एखाद्या आवृत्तीचे गुणांकन कमी करण्यासाठी, खालील सर्व रकान्यांमध्ये "अप्रमाणित" भरा.',
	'revreview-update' => "कृपया केलेले बदल ''(खाली दिलेले)'' [[{{MediaWiki:Validationpage}}|तपासा]] कारण स्थिर आवृत्ती [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} प्रमाणित] करण्यात आलेली आहे.<br />
'''काही साचे/चित्रे बदललेली आहेत:'''",
	'revreview-update-includes' => 'काही साचे/चित्र बदलण्यात आलेले आहेत:',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'revisionreview' => 'Kaji semula semakan',
	'revreview-failed' => "'''Semakan ini tidak dapat dikaji semula.'''",
	'revreview-submission-invalid' => 'Penyerahan ini tidak lengkap atau tidak sah atas sebab-sebab tertentu.',
	'review_page_invalid' => 'Tajuk laman sasaran tidak sah.',
	'review_page_notexists' => 'Laman sasaran tidak wujud.',
	'review_page_unreviewable' => 'Laman sasaran tidak boleh dikaji semula.',
	'review_no_oldid' => 'ID semakan tidak dinyatakan.',
	'review_bad_oldid' => 'Semakan sasaran tidak wujud.',
	'review_conflict_oldid' => 'Semakan ini telah diterima atau ditarik balik penerimaannya oleh pihak lain semasa anda melihatnya.',
	'review_not_flagged' => 'Semakan sasaran kini tidak ditandai sebagai sudah dikaji semula.',
	'review_too_low' => 'Semakan tidak boleh dikaji semula kerana sesetengah ruangan dibiarkan "tidak memadai".',
	'review_bad_key' => 'Kunci parameter penyertaan tidak sah.',
	'review_bad_tags' => 'Sesetengah nilai tag yang dinyatakan adalah tidak sah.',
	'review_denied' => 'Kebenaran ditolak.',
	'review_param_missing' => 'Kekurangan parameter, atau adanya parameter yang tidak sah.',
	'review_cannot_undo' => 'Perubahan ini tidak boleh dibatalkan kerana suntingan tergantung yang selanjutnya telah mengubah bahagian-bahagian yang sama.',
	'review_cannot_reject' => 'Perubahan ini tidak boleh ditolak kerana sesetengah (atau semua) suntingan telah diterima oleh seseorang.',
	'review_reject_excessive' => 'Tidak boleh menolak begini banyak suntingan dalam sekali.',
	'review_reject_nulledits' => 'Perubahan ini tidak boleh ditolak kerana semua semakan adalah suntingan nol.',
	'revreview-check-flag-p' => 'Terima versi ini (termasuk $1 perubahan tergantung)',
	'revreview-check-flag-p-title' => 'Terima hasil perubahan tergantung dan perubahan yang anda lakukan di sini. Gunakan yang ini hanya jika anda sudah melihat seluruh laman perbezaan semakan tergantung.',
	'revreview-check-flag-u' => 'Terima laman yang belum dikaji semula ini',
	'revreview-check-flag-u-title' => 'Terima versi laman yang ini. Gunakannya hanya jika anda sudah menyemak seluruh laman.',
	'revreview-check-flag-y' => 'Terima perubahan saya',
	'revreview-check-flag-y-title' => 'Terima segala perubahan yang anda telah buat di sini.',
	'revreview-flag' => 'Kaji semula semakan ini',
	'revreview-reflag' => 'Kaji semula semakan ini sekali lagi',
	'revreview-invalid' => "'''Sasaran tidak sah:''' tiada semakan [[{{MediaWiki:Validationpage}}|dikaji semula]] yang berpadan dengan ID yang diberikan.",
	'revreview-log' => 'Komen:',
	'revreview-main' => 'Anda hendaklah memilih sebuah semakan tertentu daripada sesebuah laman kandungan untuk diperiksa.

Sila lihat [[Special:Unreviewedpages|senarai laman yang belum diperiksa]].',
	'revreview-stable1' => 'Anda boleh melihat [{{fullurl:$1|stableid=$2}} versi bertanda ini] dan melihat sama ada ia sekarang [{{fullurl:$1|stable=1}} versi stabil] bagi laman ini.',
	'revreview-stable2' => 'Mungkin anda ingin melihat [{{fullurl:$1|stable=1}} versi stabil] laman ini.',
	'revreview-submit' => 'Hantar',
	'revreview-submitting' => 'Sedang menyerahkan...',
	'revreview-submit-review' => 'Terima semakan',
	'revreview-submit-unreview' => 'Tarik balik penerimaan semakan',
	'revreview-submit-reject' => 'Tolak perubahan',
	'revreview-submit-reviewed' => 'Selesai. Diterima!',
	'revreview-submit-unreviewed' => 'Selesai. Penerimaan ditarik balik!',
	'revreview-successful' => "'''Semakan bagi [[:$1|$1]] berjaya ditanda. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} lihat semua versi stabil])'''",
	'revreview-successful2' => "'''Tanda semakan bagi [[:$1|$1]] berjaya dibuang.'''",
	'revreview-poss-conflict-p' => "'''Amaran: [[User:$1|$1]] mula mengkaji semula laman ini pada $2, $3.'''",
	'revreview-poss-conflict-c' => "'''Amaran: [[User:$1|$1]] mula mengkaji semula perubahan-perubahan ini pada $2, $3.'''",
	'revreview-adv-reviewing-p' => 'Peringatan: Peninjau lain boleh melihat anda mengkaji semula laman ini.',
	'revreview-adv-reviewing-c' => 'Peringatan: Peninjau lain boleh melihat anda mengkaji semula perubahan ini.',
	'revreview-sadv-reviewing-p' => 'Anda boleh $1 diri anda mengkaji semula laman ini kepada para pengguna lain.',
	'revreview-sadv-reviewing-c' => 'Anda boleh $1 diri anda mengkaji semula perubahan ini kepada para pengguna lain.',
	'revreview-adv-start-link' => 'hebahkan',
	'revreview-adv-stop-link' => 'jangan hebahkan',
	'revreview-toolow' => '\'\'\'Anda mesti menilai setiap satu atribut itu sebagai lebih tinggi daripada "tidak memadai" supaya semakan itu dianggap sudah dikaji semula.\'\'\'

Untuk membatalkan status kaji semula semakan itu, klik "tarik balik penerimaan".

Sila tekan butang "←" pada pelayar anda dan cuba lagi.',
	'revreview-update' => "'''Sila [[{{MediaWiki:Validationpage}}|kaji semula]] sebarang perubahan tergantung ''(ditunjukkan di bawah)'' yang dilakukan sejak versi stabil.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Perubahan anda belum lagi dalam versi stabil.</span>

Sila kaji semula segala perubahan yang ditunjukkan di bawah untuk memastikan agar suntingan anda muncul dalam versi stabil.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Perubahan anda belum lagi dalam versi stabil. Terdapat perubahan terdahulu yang masih menunggu untuk dikaji semula.</span>

Sila kaji semula segala perubahan yang ditunjukkan di bawah untuk memastikan agar suntingan anda muncul dalam versi stabil.',
	'revreview-update-includes' => 'Templat/fail dikemaskini (laman yang belum dikaji semula berhuruf tebal):',
	'revreview-reject-text-list' => "Dengan melengkapkan tindakan ini, anda akan '''menolak''' perubahan teks sumber daripada {{PLURAL:$1|semakan|semakan-semakan}} [[:$2|$2]] yang berikut:",
	'revreview-reject-text-revto' => 'Ini akan membalikkan laman ini kepada [versi {{fullurl:$1|oldid=$2}} seperti pada $3].',
	'revreview-reject-summary' => 'Ringkasan:',
	'revreview-reject-confirm' => 'Tolak perubahan ini',
	'revreview-reject-cancel' => 'Batalkan',
	'revreview-reject-summary-cur' => 'Menolak {{PLURAL:$1|perubahan|$1 perubahan}} teks terbaru (oleh $2) dan memulihkan semakan $3 oleh $4',
	'revreview-reject-summary-old' => 'Menolak {{PLURAL:$1|perubahan|$1 perubahan}} teks pertama (oleh $2) yang menyusuli semakan $3 oleh $4',
	'revreview-reject-summary-cur-short' => 'Menolak {{PLURAL:$1|perubahan|$1 perubahan}} teks terbaru dan memulihkan semakan $2 oleh $3',
	'revreview-reject-summary-old-short' => 'Menolak {{PLURAL:$1|perubahan|$1 perubahan}} teks pertama yang menyusuli semakan $2 oleh $3',
	'revreview-tt-flag' => 'Terima semakan ini dengan menandainya sebagai "diperiksa"',
	'revreview-tt-unflag' => 'Tarik balik penerimaan semakan ini dengan menandainya sebagai "tidak diperiksa"',
	'revreview-tt-reject' => 'Tolak perubahan teks sumber ini dengan membalikkannya',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author EivindJ
 * @author Event
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'revisionreview' => 'Anmeld sideversjoner',
	'revreview-failed' => "'''Kunne ikke revidere denne revisjonen.'''",
	'revreview-submission-invalid' => 'Innsendingen var ufullstendig eller på en annen måte ugyldig.',
	'review_page_invalid' => 'Målsidetittelen er ugyldig.',
	'review_page_notexists' => 'Målsiden finnes ikke.',
	'review_page_unreviewable' => 'Målsiden er ikke reviderbar.',
	'review_no_oldid' => 'Ingen revisjons-ID spesifisert.',
	'review_bad_oldid' => 'Det er ingen slik målrevisjon.',
	'review_conflict_oldid' => 'Noen har allerede godkjent eller ikke godkjent denne revisjonen mens du så på den.',
	'review_not_flagged' => 'Målrevisjonen er foreløpig ikke merket som revidert.',
	'review_too_low' => 'Revisjonen kan ikke revideres med enkelte felt markert som «utilstrekkelig».',
	'review_bad_key' => 'Ugyldig inkluderingsparameternøkkel.',
	'review_bad_tags' => 'Enkelte av de angitte merkelappverdiene er ugyldige.',
	'review_denied' => 'Ingen tillatelse.',
	'review_param_missing' => 'En parameter mangler eller er ugyldig.',
	'review_cannot_undo' => 'Kan ikke omgjøre disse endringene fordi ventende endringer endret i samme område.',
	'review_cannot_reject' => 'Kunne ikke forkaste endringene fordi noen allerede har godkjent noen av (eller alle) redigeringene.',
	'review_reject_excessive' => 'Kan ikke forkaste så mange endringer på en gang.',
	'review_reject_nulledits' => 'Kan ikke avvise disse endringene fordi alle revisjoner er tomme.',
	'revreview-check-flag-p' => 'Godta denne versjonen (inkluderer $1 ventende {{PLURAL:$1|endring|endringer}})',
	'revreview-check-flag-p-title' => 'Godta alle nåværende ventende endringer sammen med din egen endring. Bare bruk denne om du allerede har sett på hele diffen for ventende endringer.',
	'revreview-check-flag-u' => 'Godta denne ureviderte siden',
	'revreview-check-flag-u-title' => 'Godta denne versjonen av siden. Bare bruk denne om du allerede har sett hele siden.',
	'revreview-check-flag-y' => 'Godta disse endringene',
	'revreview-check-flag-y-title' => 'Godta alle endringene som du har gjort i denne redigeringen.',
	'revreview-flag' => 'Anmeld denne sideversjonen',
	'revreview-reflag' => 'Revider denne revisjonen på nytt',
	'revreview-invalid' => "'''Ugyldig mål:''' ingen [[{{MediaWiki:Validationpage}}|anmeldte]] versjoner tilsvarer den angitte ID-en.",
	'revreview-log' => 'Kommentar:',
	'revreview-main' => 'Du må velge en viss revisjon av en innholdsside for å anmelde den.

Se [[Special:Unreviewedpages|listen over ikke-anmeldte sider]].',
	'revreview-stable1' => 'Du vil kanskje se [{{fullurl:$1|stableid=$2}} denne flaggede versjonen] og se om den nå er den [{{fullurl:$1|stable=1}} publiserte versjonen] av denne siden.',
	'revreview-stable2' => 'Du vil kanskje se den [{{fullurl:$1|stable=1}} publiserte versjonen] av denne siden.',
	'revreview-submit' => 'Send',
	'revreview-submitting' => 'Leverer …',
	'revreview-submit-review' => 'Godkjenn revisjon',
	'revreview-submit-unreview' => 'Ikke godkjenn revisjon',
	'revreview-submit-reject' => 'Avvis endringer',
	'revreview-submit-reviewed' => 'Ferdig. Godkjent.',
	'revreview-submit-unreviewed' => 'Ferdig. Ikke godkjent.',
	'revreview-successful' => "'''Valgt versjon av [[:$1|$1]] har blitt merket. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} se alle stabile versjoner])'''",
	'revreview-successful2' => "'''Valgt versjon av [[:$1|$1]] ble degradert.'''",
	'revreview-poss-conflict-p' => "'''Advarsel: [[User:$1|$1]] begynte å revidere denne siden den $2, $3.'''",
	'revreview-poss-conflict-c' => "'''Advarsel: [[User:$1|$1]] begynte å revidere disse endringene den $2, $3.'''",
	'revreview-adv-reviewing-p' => "'''Merk: Du har nå startet gjennomgang av denne siden på  $1 ved $2.'''",
	'revreview-toolow' => "'''Du må vurdere hver av egenskapene til høyere enn «utilstrekkelig» for at revisjonen skal bli vurdert som revidert.'''

For å fjerne vurderingsstatusen til en revisjon, klikk på «underkjenn».

Klikk på «tilbake»-knappen i nettleseren din og prøv igjen.",
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Revider]] ventende endringer ''(vist nedenfor)'' som har blitt gjort på den aksepterte versjonen.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Endringene dine er ikke i den stabile versjonen ennå.</span>

Revider alle endringene vist nedenfor for å gjøre redigeringene dine synlige i den stabile versjonen.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Endringene dine er ikke i den stabile versjonen ennå. Det finnes tidligere endringer som venter på revidering.</span>

Revider alle endringene vist nedenfor for å gjøre redigeringene dine synlige i den stabile versjonen.',
	'revreview-update-includes' => 'Noen maler eller filer ble oppdatert:',
	'revreview-reject-text-list' => "Ved å fullføre denne handlingen vil du '''avvise''' følgende {{PLURAL:$1|endring|endringer}}:",
	'revreview-reject-text-revto' => 'Dette vil tilbakestille siden til [{{fullurl:$1|oldid=$2}} versjonen fra $3].',
	'revreview-reject-summary' => 'Sammendrag:',
	'revreview-reject-confirm' => 'Avvis disse endringene',
	'revreview-reject-cancel' => 'Avbryt',
	'revreview-reject-summary-cur' => 'Forkastet {{PLURAL:$1|den siste endringen|de siste $1 endringene}} (av $2) og gjenopprettet revisjon $3 av $4.',
	'revreview-reject-summary-old' => 'Forkastet {{PLURAL:$1|den første endringen|de første $1 endringene}} (av $2) som fulgte revisjon $3 av $4',
	'revreview-reject-summary-cur-short' => 'Forkastet {{PLURAL:$1|den siste endringen|de siste $1 endringene}} og gjenopprettet revisjon $2 av $3',
	'revreview-reject-summary-old-short' => 'Forkastet {{PLURAL:$1|den første endringen|de første $1 endringene}} som fulgte revisjon $2 av $3',
	'revreview-tt-flag' => 'Godkjenn denne revisjonen ved å merke den som kontrollert',
	'revreview-tt-unflag' => 'Underkjenn denne revisjonen ved å merke den som «ukontrollert»',
	'revreview-tt-reject' => 'Avvis disse endringene ved å tilbakestille dem',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'revreview-log' => 'Kommentar:',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'revisionreview' => 'Versies controleren',
	'revreview-failed' => "'''Het was niet mogelijk deze versie te controleren.'''",
	'revreview-submission-invalid' => 'De ingezonden gegevens waren incompleet of op een andere manier ongeldig.',
	'review_page_invalid' => 'De doelpaginanaam is ongeldig.',
	'review_page_notexists' => 'De doelpagina bestaat niet.',
	'review_page_unreviewable' => 'De doelpagina kan niet gecontroleerd worden.',
	'review_no_oldid' => 'Er is geen versienummer opgegeven.',
	'review_bad_oldid' => 'De opgegeven doelversie bestaat niet.',
	'review_conflict_oldid' => 'Iemand heeft deze versie al goedgekeurd of afgekeurd terwijl u de versie aan het beoordelen was.',
	'review_not_flagged' => 'De doelversie is niet gemarkeerd als gecontroleerd.',
	'review_too_low' => 'De versie kan niet als gecontroleerd worden gemarkeerd als niet alle velden een andere waarde dan {{int:Revreview-accuracy-0}} hebben.',
	'review_bad_key' => 'Ongeldige parametersleutel.',
	'review_bad_tags' => 'Een aantal van de opgegeven labels zijn ongeldig.',
	'review_denied' => 'Geen toegang.',
	'review_param_missing' => 'Er ontbreekt een parameter of de opgegeven parameter is ongeldig.',
	'review_cannot_undo' => 'Het is niet mogelijk deze wijzigingen ongedaan te maken omdat andere wijzigingen invloed hebben op dezelfde plaatsen.',
	'review_cannot_reject' => 'Deze wijzigingen kunnen niet afgekeurd worden omdat een aantal van de wijzigingen al geaccepteerd is.',
	'review_reject_excessive' => 'Het is niet mogelijk zoveel wijzigingen tegelijk af te keuren.',
	'review_reject_nulledits' => 'Kan deze wijzigingen niet verwerpen omdat alle versies nulbewerkingen zijn.',
	'revreview-check-flag-p' => 'Deze versie accepteren (inclusief $1 ongecontroleerde {{PLURAL:$1|bewerking|bewerkingen}})',
	'revreview-check-flag-p-title' => 'Alle ongecontroleerde wijzigingen samen met uw wijzigingen publiceren.
Gebruik dit alleen als u de ongecontroleerde wijzigingen hebt bekeken.',
	'revreview-check-flag-u' => 'Deze ongecontroleerde pagina accepteren',
	'revreview-check-flag-u-title' => 'Deze versie van de pagina accepteren.
Gebruik dit alleen als u de hele pagina al gezien hebt.',
	'revreview-check-flag-y' => 'Deze wijzigingen accepteren',
	'revreview-check-flag-y-title' => 'Alle wijzigingen uit deze bewerking accepteren.',
	'revreview-flag' => 'Versie controleren',
	'revreview-reflag' => 'Versie opnieuw controleren',
	'revreview-invalid' => "'''Ongeldige bestemming:''' er is geen [[{{MediaWiki:Validationpage}}|gecontroleerde]] versie die overeenkomt met het opgegeven nummer.",
	'revreview-log' => 'Opmerking:',
	'revreview-main' => "U moet een specifieke versie van een pagina kiezen die u wilt controleren.

Zie  de [[Special:Unreviewedpages|lijst met ongecontroleerde pagina's]].",
	'revreview-stable1' => 'U kunt van deze pagina [{{fullurl:$1|stableid=$2}} deze gecontroleerde versie] bekijken om te beoordelen of dit nu de [{{fullurl:$1|stable=1}} gepubliceerde versie] is.',
	'revreview-stable2' => 'Wellicht wilt u de [{{fullurl:$1|stable=1}} gepubliceerde versie] van deze pagina bekijken.',
	'revreview-submit' => 'Opslaan',
	'revreview-submitting' => 'Bezig met opslaan…',
	'revreview-submit-review' => 'Versie accepteren',
	'revreview-submit-unreview' => 'Versie afkeuren',
	'revreview-submit-reject' => 'Wijzigingen afwijzen',
	'revreview-submit-reviewed' => 'Klaar. Gecontroleerd!',
	'revreview-submit-unreviewed' => 'Klaar. Niet gecontroleerd!',
	'revreview-successful' => "'''De versie van [[:$1|$1]] is gecontroleerd. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} gepubliceerde versies bekijken])'''",
	'revreview-successful2' => "'''De versie van [[:$1|$1]] is als niet gepubliceerd aangemerkt.'''",
	'revreview-poss-conflict-p' => "'''Waarschuwing: [[User:$1|$1]] is begonnen met de controle van deze pagina op $2 om $3.'''",
	'revreview-poss-conflict-c' => "'''Waarschuwing: [[User:$1|$1]] is begonnen met de controle van deze wijzigingen op $2 om $3.'''",
	'revreview-adv-reviewing-p' => 'Let op: andere gebruikers zien dat u bezig bent met het beoordelen van deze pagina.',
	'revreview-adv-reviewing-c' => 'Let op: andere gebruikers zien dat u bezig bent met het beoordelen van deze wijzigingen.',
	'revreview-sadv-reviewing-p' => 'U kunt aan andere gebruikers aangeven dat u deze pagina $1.',
	'revreview-sadv-reviewing-c' => 'U kunt aan andere gebruikers aangeven dat u deze wijzigingen $1.',
	'revreview-adv-start-link' => 'aan het controleren bent',
	'revreview-adv-stop-link' => 'niet aan het controleren bent',
	'revreview-toolow' => '\'\'\'U moet tenminste alle eigenschappen hoger instellen dan "{{int:Revreview-accuracy-0}}" om voor een versie aan te geven dat deze is gecontroleerd.\'\'\'

Klik op "Versie afkeuren" om de waardering van een versie te verwijderen.

Klik op de knop "Terug" in uw browser en probeer het opnieuw.',
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Controleer]] alstublieft de ''onderstaande'' wijzigingen ten opzichte van de gepubliceerde versie.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Uw wijzigingen zijn nog niet zichtbaar in de stabiele versie.</span>

Controleer alle wijzigingen hieronder om uw bewerkingen zichtbaar te maken in de stabiele versie.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Uw wijzigingen zijn nog niet opgenomen in de stabiele versie. Er moeten nog bewerkingen gecontroleerd worden.</span>

Controleer alle hieronder weergegeven wijzigingen om ook uw bewerking zichtbaar te maken in de stabiele versie.',
	'revreview-update-includes' => "Sommige sjablonen/bestanden zijn bijgewerkt (ongecontroleerde pagina's in vet):",
	'revreview-reject-text-list' => "Door deze handeling uit te voeren, '''keurt u de brontekstwijzingen af''' van de volgende {{PLURAL:$1|versie|versies}} van [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Hiermee wordt de [{{fullurl:$1|oldid=$2}} versie per $3] teruggeplaatst.',
	'revreview-reject-summary' => 'Samenvatting:',
	'revreview-reject-confirm' => 'Deze wijzigingen afkeuren',
	'revreview-reject-cancel' => 'Annuleren',
	'revreview-reject-summary-cur' => 'Heeft de laatste {{PLURAL:$1|tekstwijziging|$1 tekstwijzigingen}} (door $2) afgekeurd en versie $3 van $4 teruggeplaatst',
	'revreview-reject-summary-old' => 'Heeft de eerste {{PLURAL:$1|tekstwijziging|$1 |tekstwijzigingen}} (door $2) na versie $3 door $4 afgekeurd',
	'revreview-reject-summary-cur-short' => 'Heeft de laatste {{PLURAL:$1||tekstwijziging|$1 |tekstwijzigingen}} afgekeurd en versie $2 door $3 teruggeplaatst',
	'revreview-reject-summary-old-short' => 'Heeft de eerste {{PLURAL:$1||tekstwijziging|$1 |tekstwijzigingen}} na versie $2 door $3 afgekeurd',
	'revreview-tt-flag' => 'Deze versie goedkeuren door haar als gecontroleerd te markeren',
	'revreview-tt-unflag' => "Keur deze versie af door haar als '''ongecontroleerd''' te markeren",
	'revreview-tt-reject' => 'Deze wijzigingen afkeuren door te terug te draaien',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'revisionreview' => 'Vurder sideversjonar',
	'review_page_invalid' => 'Målsidetittelen er ugyldig.',
	'review_page_notexists' => 'Målsida finst ikkje.',
	'revreview-flag' => 'Vurder denne versjonen',
	'revreview-invalid' => "'''Ugyldig mål:''' ingen [[{{MediaWiki:Validationpage}}|vurderte]] versjonar svarer til den oppgjevne ID-en.",
	'revreview-log' => 'Kommentar:',
	'revreview-main' => 'Du lyt velja ein viss versjon av ei innhaldssida for å kunna gjera ei vurdering.

Sjå [[Special:Unreviewedpages|lista over sider som manglar vurdering]].',
	'revreview-stable1' => 'Du ynskjer kanskje å sjå [{{fullurl:$1|stableid=$2}} denne merkte versjonen] og sjå om han er den [{{fullurl:$1|stable=1}} stabile versjonen] av denne sida.',
	'revreview-stable2' => 'Du ynskjer kanskje å sjå den [{{fullurl:$1|stable=1}} stabile versjoen] av sida (om det enno finst ein).',
	'revreview-submit' => 'Utfør',
	'revreview-submitting' => 'Leverer …',
	'revreview-successful' => "'''Vald versjon av [[:$1|$1]] har vorte merkt. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} sjå alle stabile versjonar])'''",
	'revreview-successful2' => "'''Vald versjon av [[:$1|$1]] vart degradert.'''",
	'revreview-toolow' => 'Vurderinga di av sida lyt minst vera over «ikkje godkjend» for alle eigenskapane nedanfor for at versjonen skal kunna vera vurdert. For å degradera ein versjon, oppgje «ikkje godkjend» for alle eigenskapane.',
	'revreview-update' => "[[{{MediaWiki:Validationpage}}|Vurder]] endringar ''(synte nedanfor)'' som er vortne gjort sidan den stabile versjonen vart [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} godkjend].<br />
'''Nokre malar eller bilete vart oppdaterte:'''",
	'revreview-update-includes' => 'Nokre malar/bilete vart oppdaterte:',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'revisionreview' => 'Tornar veire las versions',
	'revreview-failed' => 'La relectura a fracassat !',
	'revreview-flag' => 'Avalorar aquesta version',
	'revreview-invalid' => "'''Cibla incorrècta :''' cap de version [[{{MediaWiki:Validationpage}}|relegida]] correspond pas al numèro indicat.",
	'revreview-log' => 'Comentari al jornal :',
	'revreview-main' => 'Vos cal causir una version precisa a partir del contengut en règla de la pagina per revisar. Vejatz [[Special:Unreviewedpages|Versions pas revisadas]] per una tièra de paginas.',
	'revreview-stable1' => "Podètz voler visionar aquesta [{{fullurl:$1|stableid=$2}} version marcada] o veire se es ara la [{{fullurl:$1|stable=1}} version establa] d'aquesta pagina.",
	'revreview-stable2' => "Podètz voler visionar [{{fullurl:$1|stable=1}} la version establa] d'aquesta pagina (se n'existís una).",
	'revreview-submit' => 'Salvar',
	'revreview-submitting' => 'Somission…',
	'revreview-submit-review' => 'Aprovar',
	'revreview-submit-unreview' => 'Desaprovar',
	'revreview-submit-reviewed' => 'Fach. Aprovat !',
	'revreview-submit-unreviewed' => 'Fach. Desaprovat!',
	'revreview-successful' => "'''La version seleccionada de [[:$1|$1]], es estada marcada d'una bandièra amb succès ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} Vejatz totas las versions establas])'''",
	'revreview-successful2' => "La version de [[:$1|$1]] a pogut se veire levar son drapèu amb succès.'''",
	'revreview-toolow' => 'Pels atributs çaijós, vos cal donar un puntatge mai elevat que « non aprobat » per que la version siá considerada coma revista. Per depreciar una version, metètz totes los camps a « non aprobat ».',
	'revreview-update' => "[[{{MediaWiki:Validationpage}}|Relegissètz]] totas las modificacions ''(vejatz çaijós)'' efectuadas dempuèi l’[{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} aprovacion] de la version establa.
'''Qualques fichièrs o modèls son estats meses a jorn :'''",
	'revreview-update-includes' => 'Qualques modèls o fichièrs son estats meses a jorn :',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'revisionreview' => 'ସମୀକ୍ଷା ସଂଶୋଧନସବୁ',
	'revreview-submit' => 'ଦାଖଲ କରିବା',
	'revreview-submitting' => 'ଦାଖଲ ହେଉଛି...',
	'revreview-submit-reject' => 'ଅସ୍ଵୀକାର ବଦଳଗୁଡ଼ିକ',
	'revreview-adv-start-link' => 'ବିଜ୍ଞାପନ',
	'revreview-reject-summary' => 'ସାରକଥା:',
	'revreview-reject-cancel' => 'ବାତିଲ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'revreview-log' => 'Aamaericking:',
);

/** Polish (Polski)
 * @author Fizykaa
 * @author Holek
 * @author Leinad
 * @author Masti
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'revisionreview' => 'Oznaczenie wersji',
	'revreview-failed' => "'''Nie udało się oznaczyć tej wersji.'''",
	'revreview-submission-invalid' => 'Zapisywany formularz był niekompletny lub z jakiegoś innego powodu nieprawidłowy.',
	'review_page_invalid' => 'Podany tytuł strony jest nieprawidłowy.',
	'review_page_notexists' => 'Wskazana strona nie istnieje.',
	'review_page_unreviewable' => 'Brak możliwości przeglądnięcia wskazanej strony.',
	'review_no_oldid' => 'Nie podano ID wersji.',
	'review_bad_oldid' => 'Wskazana wersja nie istnieje.',
	'review_conflict_oldid' => 'Ktoś już zaakceptował lub odrzucił tę wersję w czasie gdy nad nią się zastanawiałeś.',
	'review_not_flagged' => 'Wybrana wersja nie jest oznaczona.',
	'review_too_low' => 'Wersja nie może zostać oznaczona jeśli niektóre pola pozostały „nieadekwatne”.',
	'review_bad_key' => 'Nieprawidłowy klucz identyfikujący parametry.',
	'review_bad_tags' => 'Niektóre z wymienionych wartości znacznika są nieprawidłowe.',
	'review_denied' => 'Brak dostępu.',
	'review_param_missing' => 'Nie podano parametru lub jest on nieprawidłowy.',
	'review_cannot_undo' => 'Nie można cofnąć tych zmian, ponieważ te same fragmenty tekstu były później modyfikowane.',
	'review_cannot_reject' => 'Nie można wycofać tych zmian, ponieważ ktoś już zaakceptował niektóre lub wszystkie zmiany.',
	'review_reject_excessive' => 'Nie można wycofać tak wielu zmian równocześnie.',
	'review_reject_nulledits' => 'Nie można wycofać tych edycji ponieważ ani jedna z nich nie wprowadziła żadnej zmiany.',
	'revreview-check-flag-p' => 'Zaakceptuj tę wersję (włącznie z $1 {{PLURAL:$1|oczekującą zmianą|oczekującymi zmianami}})',
	'revreview-check-flag-p-title' => 'Zostanie zaakceptowana Twoja edycja wraz ze wszystkimi oczekującymi zmianami. Użyj tej opcji tylko w przypadku, gdy uprzednio zostały przejrzane oczekujące zmiany.',
	'revreview-check-flag-u' => 'Zaakceptuj tę nieprzejrzaną stronę',
	'revreview-check-flag-u-title' => 'Zostanie zaakceptowana strona, którą właśnie edytujesz. Użyj tej opcji tylko w przypadku, gdy zapoznano się z całą zawartością strony.',
	'revreview-check-flag-y' => 'Zaakceptuj moje zmiany',
	'revreview-check-flag-y-title' => 'Zostaną zaakceptowane wszystkie zmiany, które tutaj wykonałeś.',
	'revreview-flag' => 'Oznacz tę wersję',
	'revreview-reflag' => 'Ponownie przejrzyj tę wersję',
	'revreview-invalid' => "'''Niewłaściwy obiekt:''' brak [[{{MediaWiki:Validationpage}}|wersji przejrzanej]] odpowiadającej podanemu ID.",
	'revreview-log' => 'Komentarz:',
	'revreview-main' => 'Musisz wybrać konkretną wersję strony w celu przejrzenia.

Zobacz [[Special:Unreviewedpages|listę nieprzejrzanych stron]].',
	'revreview-stable1' => 'Możesz zobaczyć [{{fullurl:$1|stableid=$2}} wersję oznaczoną] i sprawdzić, czy jest ona [{{fullurl:$1|stable=1}} wersją zweryfikowaną] tej strony.',
	'revreview-stable2' => 'Możesz zobaczyć [{{fullurl:$1|stable=1}} wersję zweryfikowaną] tej strony.',
	'revreview-submit' => 'Oznacz wersję',
	'revreview-submitting' => 'Zapisywanie...',
	'revreview-submit-review' => 'Zaakceptuj wersję',
	'revreview-submit-unreview' => 'Cofnij akceptację wersji',
	'revreview-submit-reject' => 'Wycofaj zmiany',
	'revreview-submit-reviewed' => 'Gotowe. Zaakceptowano!',
	'revreview-submit-unreviewed' => 'Gotowe. Wycofano akceptację!',
	'revreview-successful' => "'''Wersja [[:$1|$1]] została pomyślnie oznaczona. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} zobacz wszystkie wersje przejrzane])'''",
	'revreview-successful2' => "'''Wersja [[:$1|$1]] została pomyślnie odznaczona.'''",
	'revreview-poss-conflict-p' => "'''Uwaga – [[User:$1|$1]] rozpoczął przeglądanie tej strony $2 o $3.'''",
	'revreview-poss-conflict-c' => "'''Uwaga – [[User:$1|$1]] rozpoczął przeglądanie tych zmian $2 o $3.'''",
	'revreview-adv-reviewing-p' => 'Uwaga – inni redaktorzy mogą zobaczyć, że rozpocząłeś przeglądanie tej strony.',
	'revreview-adv-reviewing-c' => 'Uwaga – inni redaktorzy mogą zobaczyć, że rozpocząłeś przeglądanie tych zmian.',
	'revreview-sadv-reviewing-p' => 'Możesz $1 innych użytkowników, o tym że jesteś w trakcie przeglądania tej strony.',
	'revreview-sadv-reviewing-c' => 'Możesz $1 innych użytkowników, o tym że jesteś w trakcie przeglądania tych zmian.',
	'revreview-adv-start-link' => 'poinformować',
	'revreview-adv-stop-link' => 'wycofaj informowanie',
	'revreview-toolow' => "'''Musisz ocenić każdy z atrybutów wyżej niż „nieakceptowalny“, aby oznaczyć wersję jako zweryfikowaną.'''

Aby wycofać zweryfikowanie kliknij na „Cofnij akceptację wersji”.

Kliknij przycisk „Wstecz” w przeglądarce i spróbuj ponownie.",
	'revreview-update' => "'''Proszę [[{{MediaWiki:Validationpage}}|przejrzeć]] zmiany ''(patrz niżej)'' dokonane od momentu ostatniego oznaczenia wersji.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Wykonane przez Ciebie zmiany nie są widoczne w wersji oznaczonej.</span>

Przejrzyj wszystkie poniższe zmiany, a Twoje edycje zostaną zamieszczone w wersji oznaczonej.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Wykonane przez Ciebie zmiany nie są widoczne w wersji oznaczonej, ponieważ inne wcześniejsze zmiany oczekują na przejrzenie.</span>

Przejrzyj wszystkie poniższe zmiany, a Twoje edycje zostaną zamieszczone w wersji oznaczonej.',
	'revreview-update-includes' => 'Niektóre szablony lub pliki zostały uaktualnione (nieprzejrzane strony są wytłuszczone):',
	'revreview-reject-text-list' => "Zatwierdzając tę akcję '''wycofasz''' zmiany zrobione w {{PLURAL:$1|wersji|wersjach}} [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Ta akcja spowoduje przywrócenie strony do [{{fullurl:$1|oldid=$2}} wersji z $3].',
	'revreview-reject-summary' => 'Podsumowanie',
	'revreview-reject-confirm' => 'Wycofaj te zmiany',
	'revreview-reject-cancel' => 'Anuluj',
	'revreview-reject-summary-cur' => 'Wycofano {{PLURAL:$1|ostatnią zmianę|ostatnie $1 zmiany|ostatnich $1 zmian}} treści ({{PLURAL:$1|zrobioną|zrobione|zrobionych}} przez $2) i przywrócono wersję $3 autorstwa $4',
	'revreview-reject-summary-old' => 'Wycofano {{PLURAL:$1|pierwszą zmianę|pierwsze $1 zmiany|pierwszych $1 zmian}} treści ({{PLURAL:$1|zrobioną|zrobione|zrobionych}} przez $2), {{PLURAL:$1|którą wykonano|które wykonano}} po wersji $3 autorstwa $4',
	'revreview-reject-summary-cur-short' => 'Wycofano {{PLURAL:$1|ostatnią zmianę|ostatnie $1 zmiany|ostatnich $1 zmian}} treści i przywrócono wersję $2 autorstwa $3',
	'revreview-reject-summary-old-short' => 'Wycofano {{PLURAL:$1|pierwszą zmianę|pierwsze $1 zmiany|pierwszych $1 zmian}} treści, {{PLURAL:$1|którą wykonano|które wykonano}} po wersji $2 autorstwa $3',
	'revreview-tt-flag' => 'Zaakceptuj tę wersję poprzez oznaczenie jej jako „przejrzaną”',
	'revreview-tt-unflag' => 'Wycofaj akceptację tej wersji poprzez oznaczenie jej jako „nieprzejrzaną”',
	'revreview-tt-reject' => 'Odrzuć te zmiany w tekście poprzez ich wycofanie',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'revisionreview' => 'Revisioné le version',
	'revreview-failed' => "'''As peul pa revisioné sta revision-sì.'''",
	'revreview-submission-invalid' => "La spedission a l'era incompleta o comsëssìa pa bon-a.",
	'review_page_invalid' => "Ël tìtol ëd la pàgina pontà a l'é pa vàlid.",
	'review_page_notexists' => 'La pàgina pontà a esist pa.',
	'review_page_unreviewable' => "La pàgina pontà a l'é pa revisionàbil.",
	'review_no_oldid' => 'Pa gnun ID ëd revision spessificà.',
	'review_bad_oldid' => 'La revision pontà a esist pa.',
	'review_conflict_oldid' => "Quaidun a l'ha già acetà o arfudà sta revision ant mente ch'it la vardave.",
	'review_not_flagged' => "La revision pontà a l'é pa al moment marcà com revisionàbil.",
	'review_too_low' => 'La revision a peul pa esse revisionà con dij camp lassà coma "pa adeguà".',
	'review_bad_key' => "Ciav dël paràmetr d'inclusion pa bon-a.",
	'review_bad_tags' => 'Quaidun dij valor ëd tichëtta spessificà a son pa bon.',
	'review_denied' => 'Përmess arfudà.',
	'review_param_missing' => "Un paràmetr a l'é mancant o pa bon.",
	'review_cannot_undo' => "As peul pa butesse andré sti cambi a motiv d'àutre modìfiche ch'a speto e ch'a rësguardo j'istesse zòne.",
	'review_cannot_reject' => "As peul pa arfudesse sti cambi përchè quaidun a l'ha già acetà quaidun-e (o tute) dle modìfiche.",
	'review_reject_excessive' => 'As peul pa arfudesse tute ste modìfiche ant na vira.',
	'review_reject_nulledits' => 'As peulo pa arfudé costi cangiament përchè tute le revision a son dle modìfiche veujde.',
	'revreview-check-flag-p' => "Aceté costa version (a comprend $1 {{PLURAL:$1|modìfica ch'a speta|modìfiche ch'a speto}})",
	'revreview-check-flag-p-title' => "Aceté tùit ij cambi ch'a speto al moment ansema con soa modìfica. Ch'a Deuvra sossì mach s'a l'ha già vardà tute le diferense dij cambi ch'a speto.",
	'revreview-check-flag-u' => 'Aceta sta pàgina pa revisionà',
	'revreview-check-flag-u-title' => "Aceté sta version ëd la pàgina. Ch'a deuvra sossì mach s'a l'ha già vardà tuta la pàgina.",
	'revreview-check-flag-y' => 'Aceta sti cambi',
	'revreview-check-flag-y-title' => "Aceta tùit ij cambi ch'it l'has fàit an sta modìfica-sì.",
	'revreview-flag' => 'Revisioné sta version',
	'revreview-reflag' => 'Revision-a torna sta revision-sì',
	'revreview-invalid' => "'''Obietiv pa bon:000 pa gnun-e revision [[{{MediaWiki:Validationpage}}|revisionà]] a corispondo a l'ID dàit.",
	'revreview-log' => 'Coment për ël registr:',
	'revreview-main' => 'A deuv selessioné na revision particolar ëd na pàgina ëd contnù për revisionela.

Vardé la [[Special:Unreviewedpages|lista dle pàgine pa revisionà]].',
	'revreview-stable1' => "Peul desse a veul vardé [{{fullurl:$1|stableid=$2}} sta version signalà-sì] e vëdde s'a l'é adess la [{{fullurl:$1|stable=1}} version publicà] ëd costa pàgina.",
	'revreview-stable2' => 'Peul desse a veul vardé la [{{fullurl:$1|stable=1}} version publicà] dë sta pàgina-sì.',
	'revreview-submit' => 'Spediss',
	'revreview-submitting' => 'Spedì ...',
	'revreview-submit-review' => 'Aceté la revision',
	'revreview-submit-unreview' => 'Revision pa acetà',
	'revreview-submit-reject' => 'Revoché le modìfiche',
	'revreview-submit-reviewed' => 'Fàit. Aprovà!',
	'revreview-submit-unreviewed' => "Fàit. Gavà l'aprovassion!",
	'revreview-successful' => "'''Revision ëd [[:$1|$1]] signalà da bin. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} vardé le version revisionà])'''",
	'revreview-successful2' => "'''Gavà për da bin la marca a la revision ëd [[:$1|$1]].'''",
	'revreview-poss-conflict-p' => "'''Avis: [[User:$1|$1]] a l'ha ancaminà a revisioné costa pàgina ël $2 a $3.'''",
	'revreview-poss-conflict-c' => "'''Avis: [[User:$1|$1]] a l'ha ancaminà a revisioné sti cambiament ël $2 a $3.'''",
	'revreview-adv-reviewing-p' => "Nòta: D'àutri revisor a peulo vëdde che chiel a l'é an camin ch'a revision-a sta pàgina.",
	'revreview-adv-reviewing-c' => "Nòta: D'àutri revisor a peulo vëdde ch'a l'é an camin ch'a revision-a coste modìfiche.",
	'revreview-sadv-reviewing-p' => "A peul $1 chiel-midem com revisor ëd costa pàgina për j'àutri utent.",
	'revreview-sadv-reviewing-c' => "A peul $1 chiel-midem com revisor ëd se modìfiche a d'àutri utent.",
	'revreview-adv-start-link' => 'propon-se',
	'revreview-adv-stop-link' => 'publicisa nen',
	'revreview-toolow' => "'''A venta ch'a stima mincadun ëd j'atribù pi àut che \"pa adeguà\" përchè na revision a sia considerà revisionà.'''

Për gavé lë stat ëd revision ëd na revision, sgnaca \"pa acetà\".

Për piasì, ch'a sgnaca ël boton \"andré\" an sò navigador e ch'a preuva torna.",
	'revreview-update' => "'''Për piasì [[{{MediaWiki:Validationpage}}|ch'a revision-a]] tuti ij cangiament an cors ''(smonù ambelessì-sota)'' fàit a la version publicà.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Soe modìfiche a son pa anco\' ant la version stàbil.</span>

Për piasì ch\'a revision-a tùit ij cambi smonù sì-sota përchè soe modìfiche a intro ant la version stàbil.',
	'revreview-update-edited-prev' => "<span class=\"flaggedrevs_important\">Soe modìfiche a son anco' pa ant la version stàbil. A-i é dle modìfiche precedente ch'a speto na revision.</span>

Për piasì ch'a revision-a tùit ij cambiament mostrà sì-sota përchè soe modìfiche a intro ant la version stàbil.",
	'revreview-update-includes' => 'Stamp/archivi agiornà (pàgine nen revisionà an grassèt):',
	'revreview-reject-text-list' => "An completand cost'assion a '''arfudrà''' le modìfiche an sël test sorgiss ëd {{PLURAL:$1|la modìfica|le modìfiche}} sì-dapress ëd [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Sòn a porterà andré la pàgina a la [{{fullurl:$1|oldid=$2}} version ëd $3].',
	'revreview-reject-summary' => 'Resumé:',
	'revreview-reject-confirm' => 'Arfuda sti cambi',
	'revreview-reject-cancel' => 'Scancela',
	'revreview-reject-summary-cur' => "Arfudà {{PLURAL:$1|l'ùltim cambi ëd test|j'ùltim $1 cambi ëd test}} (da $2) e ripristinà la revision $3 da $4",
	'revreview-reject-summary-old' => "Arfudà {{PLURAL:$1|la prima modìfica ëd test|le prime $1 modìfiche ëd test}} (ëd $2) ch'a son ëvnùite apress la revision $3 da $4",
	'revreview-reject-summary-cur-short' => "Arfudà {{PLURAL:$1|l'ùltim cambi ëd test|j'ùltim $1 cambi ëd test}} e ripristinà la revision $2 da $3",
	'revreview-reject-summary-old-short' => "Arfudà {{PLURAL:$1|la prima modìfica ëd test|le prime $1 modìfiche ëd test}} ch'a son ëvnùite apress la revision $2 da $3",
	'revreview-tt-flag' => 'Apreuva sta revision-sì an marcandla com revisionà',
	'revreview-tt-unflag' => 'Gava da aprovà sta revision-sì an marcandla com pa controlà',
	'revreview-tt-reject' => 'Arfudé coste modìfiche ant ël test sorgiss an tirandje andré',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'revreview-check-flag-y' => 'زما بدلونونه دې ومنل شي',
	'revreview-log' => 'تبصره:',
	'revreview-submit' => 'سپارل',
	'revreview-submitting' => 'د سپارلو په حال کې ...',
	'revreview-submit-review' => 'مخکتنه منل',
	'revreview-submit-reject' => 'بدلونونه ردول',
	'revreview-reject-summary' => 'لنډيز:',
	'revreview-reject-confirm' => 'همدا بدلونونه ردول',
	'revreview-reject-cancel' => 'ناګارل',
);

/** Portuguese (Português)
 * @author 555
 * @author Giro720
 * @author Hamilton Abreu
 * @author Helder.wiki
 * @author Waldir
 */
$messages['pt'] = array(
	'revisionreview' => 'Rever edições',
	'revreview-failed' => "'''Não foi possível rever esta edição.'''",
	'revreview-submission-invalid' => 'Os dados submetidos estão incompletos ou são inválidos.',
	'review_page_invalid' => 'O título da página de destino é inválido.',
	'review_page_notexists' => 'A página de destino não existe.',
	'review_page_unreviewable' => 'A página de destino não está sujeita a revisão.',
	'review_no_oldid' => 'Não foi especificado nenhum ID de revisão.',
	'review_bad_oldid' => 'Essa edição de destino não existe.',
	'review_conflict_oldid' => 'Enquanto visionava esta edição, alguém aprovou-a ou anulou a aprovação.',
	'review_not_flagged' => 'A edição de destino não está neste momento marcada como revista.',
	'review_too_low' => 'A edição não pode ser revista com alguns campos classificados "inadequada".',
	'review_bad_key' => 'A chave do parâmetro de inclusão é inválida.',
	'review_bad_tags' => 'Algumas das etiquetas de edição especificadas são inválidas.',
	'review_denied' => 'Permissão negada.',
	'review_param_missing' => 'Um parâmetro está em falta ou é inválido.',
	'review_cannot_undo' => 'Não é possível desfazer estas alterações, porque outras alterações pendentes alteraram as mesmas áreas.',
	'review_cannot_reject' => 'Não pode rejeitar estas mudanças porque alguém já aceitou algumas (ou todas) as edições.',
	'review_reject_excessive' => 'Não pode rejeitar esta quantidade de edições de uma só vez.',
	'review_reject_nulledits' => 'Não pode rejeitar estas alterações porque todas as edições são nulas.',
	'revreview-check-flag-p' => 'Aceitar esta versão (inclui $1 {{PLURAL:$1|alteração pendente|alterações pendentes}})',
	'revreview-check-flag-p-title' => 'Aceitar todas as alterações pendentes em conjunto com a sua própria edição.
Faça-o só se já viu a lista completa de diferenças das alterações pendentes.',
	'revreview-check-flag-u' => 'Aceitar esta página não revista',
	'revreview-check-flag-u-title' => 'Aceitar esta versão da página. Faça-o só se já viu a página completa.',
	'revreview-check-flag-y' => 'Aceitar estas alterações',
	'revreview-check-flag-y-title' => 'Aceitar todas as alterações que realizou nesta edição.',
	'revreview-flag' => 'Rever esta edição',
	'revreview-reflag' => 'Voltar a rever esta edição',
	'revreview-invalid' => "'''Destino inválido:''' não há [[{{MediaWiki:Validationpage}}|edições revistas]] que correspondam ao ID fornecido.",
	'revreview-log' => 'Comentário:',
	'revreview-main' => 'Tem de seleccionar uma edição específica de uma página, para revê-la.

Veja a [[Special:Unreviewedpages|lista de páginas não revistas]].',
	'revreview-stable1' => 'Talvez deseje verificar se [{{fullurl:$1|stableid=$2}} esta versão marcada] é agora a [{{fullurl:$1|stable=1}} versão publicada] desta página.',
	'revreview-stable2' => 'Talvez deseje ver a [{{fullurl:$1|stable=1}} versão publicada] desta página.',
	'revreview-submit' => 'Enviar',
	'revreview-submitting' => 'Enviando...',
	'revreview-submit-review' => 'Aprovar a edição',
	'revreview-submit-unreview' => 'Anular aprovação da edição',
	'revreview-submit-reject' => 'Rejeitar as alterações',
	'revreview-submit-reviewed' => 'Terminado. Aprovada!',
	'revreview-submit-unreviewed' => 'Terminado. Aprovação anulada!',
	'revreview-successful' => "'''A edição de [[:$1|$1]] foi marcada com sucesso. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} ver as versões revistas])'''",
	'revreview-successful2' => "'''A edição de [[:$1|$1]] foi desmarcada com sucesso.'''",
	'revreview-poss-conflict-p' => "'''Aviso: O utilizador [[User:$1|$1]] começou a rever esta página às $3 de $2.'''",
	'revreview-poss-conflict-c' => "'''Aviso: O utilizador [[User:$1|$1]] começou a rever estas alterações às $3 de $2.'''",
	'revreview-adv-reviewing-p' => 'Aviso: Os outros revisores podem ver que está a revisar esta página.',
	'revreview-adv-reviewing-c' => 'Aviso: Os outros revisores podem ver que está a revisar estas alterações.',
	'revreview-sadv-reviewing-p' => 'Você pode $1 aos outros utilizadores que está a revisar esta página.',
	'revreview-sadv-reviewing-c' => 'Você pode $1 aos outros usuários que está a revisar estas alterações.',
	'revreview-adv-start-link' => 'informar',
	'revreview-adv-stop-link' => 'parar de informar',
	'revreview-toolow' => '\'\'\'Para uma edição ser considerada revista, tem de avaliar cada atributo com valores acima de "inadequada".\'\'\'

Para anular a revisão de uma edição, clique "anular revisão".

Clique o botão "voltar" do seu browser e tente novamente, por favor.',
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Reveja]] quaisquer alterações pendentes ''(mostradas abaixo)'' que tenham sido feitas à versão publicada, por favor.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">As suas alterações ainda não estão na versão publicada.</span>

Para que as suas edições apareçam na versão publicada, reveja todas as alterações mostradas abaixo, por favor.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">As suas alterações ainda não estão na versão publicada. Existem edições anteriores à espera de revisão.</span> 

Para que as suas edições apareçam na versão publicada, reveja todas as alterações mostradas abaixo, por favor.',
	'revreview-update-includes' => 'Foram actualizados ficheiros ou predefinições (as páginas não revistas aparecem a negrito):',
	'revreview-reject-text-list' => 'Ao executar esta operação, irá "rejeitar" {{PLURAL:$1|a seguinte mudança|as seguintes mudanças}} a [[:$2|$2]]:',
	'revreview-reject-text-revto' => 'A página será revertida para a [{{fullurl:$1|oldid=$2}} versão de $3].',
	'revreview-reject-summary' => 'Resumo:',
	'revreview-reject-confirm' => 'Rejeitar estas mudanças',
	'revreview-reject-cancel' => 'Cancelar',
	'revreview-reject-summary-cur' => 'Rejeitou {{PLURAL:$1|a última alteração|as últimas $1 alterações}} do texto (de $2) e reverteu para a edição $3 de $4',
	'revreview-reject-summary-old' => 'Rejeitou {{PLURAL:$1|a primeira alteração|as primeiras $1 alterações}} do texto (de $2) {{PLURAL:$1|feita|feitas}} após a edição $3 de $4',
	'revreview-reject-summary-cur-short' => 'Rejeitou {{PLURAL:$1|a última alteração|as últimas $1 alterações}} do texto e reverteu para a edição $2 de $3',
	'revreview-reject-summary-old-short' => 'Rejeitou {{PLURAL:$1|a primeira alteração do texto feita|as primeiras $1 mudanças do texto feitas}} após a edição $2 de $3',
	'revreview-tt-flag' => 'Aprovar esta edição, marcando-a como "verificada"',
	'revreview-tt-unflag' => 'Anular a aprovação desta edição, marcando-a como "não verificada"',
	'revreview-tt-reject' => 'Rejeitar estas alterações ao texto, revertendo-as',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Helder.wiki
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'revisionreview' => 'Rever edições',
	'revreview-failed' => "'''Não foi possível revisar esta edição.'''",
	'revreview-submission-invalid' => 'Os dados submetidos estão incompletos ou são inválidos.',
	'review_page_invalid' => 'O título da página de destino é inválido.',
	'review_page_notexists' => 'A página de destino não existe.',
	'review_page_unreviewable' => 'A página de destino não está sujeita a revisão.',
	'review_no_oldid' => 'Não foi especificado nenhum ID de revisão.',
	'review_bad_oldid' => 'Essa edição de destino não existe.',
	'review_conflict_oldid' => 'Enquanto você visualizava esta edição, alguém aprovou-a ou anulou a aprovação.',
	'review_not_flagged' => 'A edição de destino não está neste momento marcada como revista.',
	'review_too_low' => 'A edição não pode ser revisada com alguns campos classificados "inadequada".',
	'review_bad_key' => 'A chave do parâmetro de inclusão é inválida.',
	'review_bad_tags' => 'Algumas das etiquetas de edição especificadas são inválidas.',
	'review_denied' => 'Permissão negada.',
	'review_param_missing' => 'Um parâmetro está em falta ou é inválido.',
	'review_cannot_undo' => 'Não é possível desfazer estas alterações porque outras alterações pendentes alteraram as mesmas áreas.',
	'review_cannot_reject' => 'Não pode rejeitar estas mudanças porque alguém já aceitou algumas (ou todas) as edições.',
	'review_reject_excessive' => 'Não pode rejeitar esta quantidade de edições de uma só vez.',
	'review_reject_nulledits' => 'Não pode rejeitar estas alterações porque todas as edições são nulas.',
	'revreview-check-flag-p' => 'Aceitar esta versão (inclui $1 {{PLURAL:$1|alteração pendente|alterações pendentes}})',
	'revreview-check-flag-p-title' => 'Aceitar todas as alterações pendentes em conjunto com a sua própria edição.
Faça-o só se já viu a lista completa de diferenças das alterações pendentes.',
	'revreview-check-flag-u' => 'Aceitar esta página não revisada',
	'revreview-check-flag-u-title' => 'Aceitar esta versão da página. Faça-o só se já viu a página completa.',
	'revreview-check-flag-y' => 'Aceitar estas alterações',
	'revreview-check-flag-y-title' => 'Aceitar todas as alterações que realizou nesta edição.',
	'revreview-flag' => 'Rever esta edição',
	'revreview-reflag' => 'Voltar a revisar esta edição',
	'revreview-invalid' => "'''Destino inválido:''' não há [[{{MediaWiki:Validationpage}}|edições revisadas]] que correspondam ao ID fornecido.",
	'revreview-log' => 'Comentário:',
	'revreview-main' => 'Você tem de selecionar uma edição específica de uma página, para revisá-la.

Veja a [[Special:Unreviewedpages|lista de páginas não revisadas]].',
	'revreview-stable1' => 'Talvez você deseje verificar se [{{fullurl:$1|stableid=$2}} esta versão marcada] é agora a [{{fullurl:$1|stable=1}} versão publicada] desta página.',
	'revreview-stable2' => 'Talvez você deseje ver a [{{fullurl:$1|stable=1}} versão publicada] desta página.',
	'revreview-submit' => 'Enviar',
	'revreview-submitting' => 'Enviando...',
	'revreview-submit-review' => 'Aceitar edição',
	'revreview-submit-unreview' => 'Não aceitar edição',
	'revreview-submit-reject' => 'Rejeitar as alterações',
	'revreview-submit-reviewed' => 'Feito. Aprovada!',
	'revreview-submit-unreviewed' => 'Feito. Aprovação anulada!',
	'revreview-successful' => "'''A edição de [[:$1|$1]] foi marcada com sucesso. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} ver as versões revisadas])'''",
	'revreview-successful2' => "'''A edição de [[:$1|$1]] foi desmarcada com sucesso.'''",
	'revreview-poss-conflict-p' => "'''Aviso: O usuário [[User:$1|$1]] começou a revisar esta página às $3 de $2.'''",
	'revreview-poss-conflict-c' => "'''Aviso: O usuário [[User:$1|$1]] começou a revisar estas alterações às $3 de $2.'''",
	'revreview-adv-reviewing-p' => 'Aviso: Os outros revisores podem ver que está revisando esta página.',
	'revreview-adv-reviewing-c' => 'Aviso: Os outros revisores podem ver que está revisando estas alterações.',
	'revreview-sadv-reviewing-p' => 'Você pode $1 aos outros usuários que está revisando esta página.',
	'revreview-sadv-reviewing-c' => 'Você pode $1 aos outros usuários que está revisando estas alterações.',
	'revreview-adv-start-link' => 'informar',
	'revreview-adv-stop-link' => 'parar de informar',
	'revreview-toolow' => '\'\'\'Para uma edição ser considerada revisada, você deve avaliar cada atributo com valores acima de "inadequada".\'\'\'

Para anular a revisão de uma edição, clique "anular revisão".

Clique o botão "voltar" do seu navegador e tente novamente, por favor.',
	'revreview-update' => "'''[[{{MediaWiki:Validationpage}}|Reveja]] quaisquer alterações pendentes ''(mostradas abaixo)'' que tenham sido feitas à versão publicada, por favor.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">As suas alterações ainda não estão na versão publicada.</span>

Para que as suas edições apareçam na versão publicada, revise todas as alterações mostradas abaixo, por favor.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">As suas alterações ainda não estão na versão publicada. Existem edições anteriores à espera de revisão.</span> 

Para que as suas edições apareçam na versão publicada, revise todas as alterações mostradas abaixo, por favor.',
	'revreview-update-includes' => 'Foram atualizados arquivos ou predefinições (as páginas não revistas aparecem a negrito):',
	'revreview-reject-text-list' => "Ao executar esta operação, você irá '''rejeitar''' {{PLURAL:$1|a seguinte mudança|as seguintes mudanças}} de [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Isto irá reverter a página para a [{{fullurl:$1|oldid=$2}} versão de $3].',
	'revreview-reject-summary' => 'Resumo:',
	'revreview-reject-confirm' => 'Rejeitar estas mudanças',
	'revreview-reject-cancel' => 'Cancelar',
	'revreview-reject-summary-cur' => 'Rejeitou {{PLURAL:$1|a última alteração|as últimas $1 alterações}} do texto (de $2) e reverteu para a edição $3 de $4',
	'revreview-reject-summary-old' => 'Rejeitou {{PLURAL:$1|a primeira alteração|as primeiras $1 alterações}} do texto (de $2) {{PLURAL:$1|feita|feitas}} após a edição $3 de $4',
	'revreview-reject-summary-cur-short' => 'Rejeitou {{PLURAL:$1|a última alteração|as últimas $1 alterações}} do texto e reverteu para a edição $2 de $3',
	'revreview-reject-summary-old-short' => 'Rejeitou {{PLURAL:$1|a primeira alteração do texto feita|as primeiras $1 mudanças do texto feitas}} após a edição $2 de $3',
	'revreview-tt-flag' => 'Aprovar esta edição, marcando-a como "verificada"',
	'revreview-tt-unflag' => 'Anular a aprovação desta edição, marcando-a como "não verificada"',
	'revreview-tt-reject' => 'Rejeitar estas alterações do texto, revertendo-as',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'review_denied' => 'Manam saqillasqachu.',
);

/** Romanian (Română)
 * @author Cin
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'revisionreview' => 'Revizuire revizii',
	'revreview-failed' => "'''Imposibil de revizuit această revizie.'''",
	'revreview-submission-invalid' => 'Trimiterea a fost incompletă sau nevalidă.',
	'review_page_invalid' => 'Titlul paginii țintă este nevalid.',
	'review_page_notexists' => 'Pagina țintă nu există.',
	'review_page_unreviewable' => 'Pagina țintă nu se poate revizui.',
	'review_no_oldid' => 'Niciun ID de revizie specificat.',
	'review_bad_oldid' => 'Revizia țintă nu există.',
	'review_conflict_oldid' => 'Cineva a acceptat sau a respins deja acestă revizie în timp ce dumneavoastră o vizualizați.',
	'review_not_flagged' => 'Revizia țintă nu este marcată în prezent ca revizuită.',
	'review_too_low' => 'Revizia nu poate fi revizuită cu unele câmpuri lăsate ca „insuficient”.',
	'review_bad_key' => 'Cheie de parametru de includere nevalidă.',
	'review_bad_tags' => 'Unele valori de etichetă specificate sunt nevalide.',
	'review_denied' => 'Permisiune refuzată.',
	'review_param_missing' => 'Un parametru lipsește sau este invalid.',
	'review_cannot_undo' => 'Nu se pot anula aceste modificări deoarece modificări ulterioare au schimbat aceleași zone.',
	'review_cannot_reject' => 'Imposibil de respins aceste modificări deoarece cineva a acceptat deja unele modificări (sau toate).',
	'review_reject_excessive' => 'Nu se pot respinge atât de multe modificări deodată.',
	'review_reject_nulledits' => 'Imposibil de respins aceste schimbări deoarece toate reviziile sunt modificări nule.',
	'revreview-check-flag-p' => 'Acceptă această versiune (include $1 {{PLURAL:$1|modificare|modificări|de modificări}} în așteptare)',
	'revreview-check-flag-u' => 'Acceptă această pagină nerevizuită',
	'revreview-check-flag-u-title' => 'Acceptă această versiune a paginii. Folosiți asta doar dacă ați văzut deja întreaga pagină.',
	'revreview-check-flag-y' => 'Acceptă aceste schimbări',
	'revreview-check-flag-y-title' => 'Acceptați toate modificările pe care le-ați efectuat aici.',
	'revreview-flag' => 'Recenzează această versiune',
	'revreview-log' => 'Comentariu:',
	'revreview-submit' => 'Trimite',
	'revreview-submitting' => 'Se trimite...',
	'revreview-submit-review' => 'Acceptați revizuirea',
	'revreview-submit-unreview' => 'Dezabrobați revizuirea',
	'revreview-submit-reject' => 'Respinge modificările',
	'revreview-submit-reviewed' => 'Gata. Acceptat!',
	'revreview-submit-unreviewed' => 'Gata. Neacceptat!',
	'revreview-successful' => "'''Versiunea [[:$1|$1]] marcată cu succes. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} vedeți versiunile revizuite])'''",
	'revreview-successful2' => "'''Revizuirea [[:$1|$1]] invalidată cu succes.'''",
	'revreview-poss-conflict-p' => "'''Avertisment: [[User:$1|$1]] a început revizuirea acestei pagini pe $2 la $3.'''",
	'revreview-poss-conflict-c' => "'''Avertisment: [[User:$1|$1]] a început revizuirea acestor schimbări pe $2 la $3.'''",
	'revreview-reject-text-revto' => 'Acesta va reveni pagina înapoi la [{{fullurl:$1|oldid=$2}} versiunea din $3].',
	'revreview-reject-summary' => 'Rezumat:',
	'revreview-reject-confirm' => 'Respinge aceste modificări',
	'revreview-reject-cancel' => 'Revocare',
	'revreview-tt-flag' => 'Acceptă această revizie marcând-o ca „verificată”',
	'revreview-tt-unflag' => 'Dezaprobă această revizie marcând-o ca „neverificată”',
	'revreview-tt-reject' => 'Respinge aceste schimbări ale textului prin restaurarea versiunii anterioare lor',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'revisionreview' => 'Revide le revisiune',
	'revreview-failed' => "'''None ge se pò rivedè sta revisione.'''",
	'review_page_invalid' => "'U titele d'a pàgene de destinazzione jè invalide.",
	'review_page_notexists' => "'A pàgene de destinazzione non g'esiste.",
	'review_page_unreviewable' => "'A pàgene de destinazione non g'è revisitabbele.",
	'review_no_oldid' => 'Nisciune ID de revisione ha state specificate.',
	'review_bad_oldid' => "'A versione de destinazzione non g'esiste.",
	'review_not_flagged' => "'A versione de destinazione non g'è pe mò signate cumme reviste.",
	'review_too_low' => '\'A revisione non ge pò essere reviste cu quacche cambe lassate "inadeguate".',
	'review_bad_key' => "Inglusione invalide d'u parametre chiave.",
	'review_denied' => 'Permesse vietate.',
	'review_param_missing' => "'Nu parametre ha state zumbate o jè invalide.",
	'review_reject_excessive' => "Non ge pozze refiutà troppe cangiaminde tutte 'na vote.",
	'revreview-check-flag-p' => 'Accette sta versione (inglude $1 {{PLURAL:$1|cangiamende|cangiaminde}} appese)',
	'revreview-check-flag-u' => 'Accette sta pàgene none reviste',
	'revreview-check-flag-y' => 'Accette ste cangiaminde',
	'revreview-check-flag-y-title' => 'Accette tutte le cangiaminde ca tu è fatte aqquà.',
	'revreview-flag' => 'Revide sta revisione',
	'revreview-reflag' => 'Revide arrete sta revisione',
	'revreview-invalid' => "'''Destinazione invalide:''' nisciuna revisiona  [[{{MediaWiki:Validationpage}}|reviste]] corresponne a 'u codece (ID) inzerite.",
	'revreview-log' => 'Commende:',
	'revreview-main' => "Tu a selezionà ìna particolera revisione da 'na vosce pe fà 'na revisitazione.

Vide 'a [[Special:Unreviewedpages|liste de le pàggene ca non g'onne state rivisitete]].",
	'revreview-stable1' => "Tu puè vulè vedè [{{fullurl:$1|stableid=$2}} sta versiona marcate] e vide ce ijedde ète 'a [{{fullurl:$1|stable=1}} versiona pubblecate] de sta pàgene.",
	'revreview-stable2' => "Tu puè vulè vedè 'a [{{fullurl:$1|stable=1}} versiona secure] de sta pàgene.",
	'revreview-submit' => 'Conferme',
	'revreview-submitting' => 'Stoche a conferme',
	'revreview-submit-review' => "Accette 'a revisione",
	'revreview-submit-unreview' => "None accettà 'a revisione",
	'revreview-submit-reject' => 'Refiute le cangiaminde',
	'revreview-submit-reviewed' => 'Apposte. Accettate!',
	'revreview-submit-unreviewed' => 'Apposte. None accettate!',
	'revreview-successful' => "'''Revisione de [[:$1|$1]] ha state mise 'u flag.''' ([{{fullurl:{{#Special:ReviewedVersions}}|pàgene=$2}} vide le versiune secure])'''",
	'revreview-successful2' => "'''Revisione de [[:$1|$1]] ha state luete 'u flag.'''",
	'revreview-adv-start-link' => 'pubblecizze',
	'revreview-adv-stop-link' => 'no-pubblecezzà',
	'revreview-toolow' => "'''Tu ninde ninde a valutà ognedune de le attrebbute cchiù ierte de ''inadeguate'' purcé 'na revisione pò essere considerate reviste.'''

Pe luà 'u state de reviste de 'na revisione, cazze sus a \"none accettà\".

Pe piacere cazze 'u buttone \"back\" d'u browser tune e pruève arrete.",
	'revreview-update' => "'''Pe piacere [[{{MediaWiki:Validationpage}}|revide]] ogne cangiamende pendende ''(le vide aqquà sotte)'' fatte da 'a versiona secure.'''",
	'revreview-update-includes' => "''Certe template/file onne state aggiornate (pàggene none reviste in grascette):",
	'revreview-reject-text-revto' => "Quiste annulle 'a pàgene turnanne a 'a [{{fullurl:$1|oldid=$2}} versione de $3].",
	'revreview-reject-summary' => 'Riepileghe:',
	'revreview-reject-confirm' => 'Scitte ste cangiaminde',
	'revreview-reject-cancel' => 'Annulle',
	'revreview-reject-summary-cur' => "Scettate l'urteme {{PLURAL:$1|cangiamende d'u teste|$1 cangiaminde d'u teste}} (by $2) e repristinate 'a revisione $3 da $4",
	'revreview-reject-summary-old' => "Scettate {{PLURAL:$1|'a prime cangiamende d'u teste|le prime $1 cangiaminde d'u teste}} (by $2) apprisse 'a revisione $3 da $4",
	'revreview-reject-summary-cur-short' => "Scettate l'urteme {{PLURAL:$1|cangiamende d'u teste|$1 cangiaminde d'u teste}} e repristinate 'a revisione $2 da $3",
	'revreview-reject-summary-old-short' => "Scettate {{PLURAL:$1|'a prime cangiamende d'u teste|le prime $1 cangiaminde d'u teste}} apprisse 'a revisione $2 da $3",
	'revreview-tt-flag' => 'Appruève sta revisione marcannele cumme verificate',
	'revreview-tt-unflag' => 'Non accettà sta revisione marcannele cumme "none verificate"',
	'revreview-tt-reject' => 'Refiute ste cangiaminde de sorgende de teste annullannele',
);

/** Russian (Русский)
 * @author AlexSm
 * @author Ferrer
 * @author Jackie
 * @author KPu3uC B Poccuu
 * @author Kaganer
 * @author Lockal
 * @author MaxSem
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'revisionreview' => 'Проверка версий',
	'revreview-failed' => "'''Невозможно проверить версию.'''",
	'revreview-submission-invalid' => 'Представление было неполным или содержало другой недочёт.',
	'review_page_invalid' => 'Недопустимое название целевой страницы.',
	'review_page_notexists' => 'Целевой страницы не существует.',
	'review_page_unreviewable' => 'Целевая страница не является проверяемой.',
	'review_no_oldid' => 'Не указан ID версии.',
	'review_bad_oldid' => 'Не существует такой целевой версии.',
	'review_conflict_oldid' => 'Кто-то уже подтвердил или снял подтверждение с этой версии, пока вы просматривали её.',
	'review_not_flagged' => 'Целевая версия сейчас не отмечена как проверенная.',
	'review_too_low' => 'Версия не может быть проверена, не указаны значения некоторых полей.',
	'review_bad_key' => 'недопустимый ключ параметра включения.',
	'review_bad_tags' => 'Некоторые из указанных значений тега являются недопустимыми.',
	'review_denied' => 'Доступ запрещён.',
	'review_param_missing' => 'Параметр не указан или указан неверно.',
	'review_cannot_undo' => 'Не удаётся отменить эти изменения, поскольку дальнейшие ожидающие проверки изменения затрагивают тот же участок.',
	'review_cannot_reject' => 'Не удаётся отклонить эти изменения, потому что кто-то уже подтвердил некоторые из их.',
	'review_reject_excessive' => 'Невозможно отклонить такое большое количество изменений сразу.',
	'review_reject_nulledits' => 'Невозможно отменить эти изменения, так как все правки являются пустыми.',
	'revreview-check-flag-p' => 'Подтвердить эту версию ($1 {{PLURAL:$1|непроверенное изменения|непроверенных изменения|непроверенных изменений}})',
	'revreview-check-flag-p-title' => 'Подтвердить все ожидающие проверки изменения вместе с вашей правкой. Используйте, только если вы уже просмотрели все ожидающие проверки изменения.',
	'revreview-check-flag-u' => 'Подтвердить эту версию непроверенной страницы',
	'revreview-check-flag-u-title' => 'Подтвердить эту версию страницы. Применяйте только в случае, если вы полностью просмотрели страницу.',
	'revreview-check-flag-y' => 'Подтвердить эти изменения',
	'revreview-check-flag-y-title' => 'Подтвердить все изменения, сделанные вами в этой правке',
	'revreview-flag' => 'Проверить эту версию',
	'revreview-reflag' => 'Перепроверить эту версию',
	'revreview-invalid' => "'''Ошибочная цель:''' не существует [[{{MediaWiki:Validationpage}}|проверенной]] версии страницы, соответствующей указанному идентификатору.",
	'revreview-log' => 'Примечание:',
	'revreview-main' => 'Вы должны выбрать одну из версий страницы для проверки.

См. [[Special:Unreviewedpages|список непроверенных страниц]].',
	'revreview-stable1' => 'Возможно, вы хотите просмотреть [{{fullurl:$1|stableid=$2}} эту отмеченную версию] или [{{fullurl:$1|stable=1}} опубликованную версию] этой страницы, если такая существует.',
	'revreview-stable2' => 'Вы можете просмотреть [{{fullurl:$1|stable=1}} опубликованную версию] этой страницы.',
	'revreview-submit' => 'Отправить',
	'revreview-submitting' => 'Отправка…',
	'revreview-submit-review' => 'Подтвердить версию',
	'revreview-submit-unreview' => 'Снять подтверждение',
	'revreview-submit-reject' => 'Отклонить изменения',
	'revreview-submit-reviewed' => 'Готово. Подтверждено!',
	'revreview-submit-unreviewed' => 'Готово. Отменено подтверждение!',
	'revreview-successful' => "'''Выбранная версия [[:$1|$1]] успешно отмечена. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} просмотр стабильных версий])'''",
	'revreview-successful2' => "'''С выбранной версии [[:$1|$1]] снята пометка.'''",
	'revreview-poss-conflict-p' => "'''Предупреждение. [[User:$1|$1]] приступил к проверке этой страницы $2 в $3.'''",
	'revreview-poss-conflict-c' => "'''Предупреждение. [[User:$1|$1]] приступил к проверке этих изменений $2 в $3.'''",
	'revreview-adv-reviewing-p' => 'Примечание. Другие рецензенты могут видеть, что вы проверяете эту страницу.',
	'revreview-adv-reviewing-c' => 'Примечание. Другие рецензенты могут видеть, что вы проверяете эти изменения.',
	'revreview-sadv-reviewing-p' => 'Вы можете $1, что вы проверяете эту страницу.',
	'revreview-sadv-reviewing-c' => 'Вы можете $1 других пользователей, что проверяете эти изменения.',
	'revreview-adv-start-link' => 'уведомить',
	'revreview-adv-stop-link' => 'снять объявление',
	'revreview-toolow' => "'''Вы должны указать для всех значений уровень выше, чем «недостаточный», чтобы версия страницы считалась проверенной.'''

Чтобы сбросить признак проверки этой версии, нажмите «Снять подтверждение».

Пожалуйста, нажмите в браузере кнопку «назад», чтобы указать значения заново.",
	'revreview-update' => "'''Пожалуйста, [[{{MediaWiki:Validationpage}}|проверьте]] изменения ''(показаны ниже)'', сделанные в принятой версии.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Ваши изменения ещё не включены в стабильную версию.</span>

Пожалуйста, проверьте все показанные ниже изменения, чтобы обеспечить появление ваших правок в стабильной версии.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Ваши изменения ещё не включены в стабильную версию. Существуют более ранние правки, требующие проверки.</span>

Чтобы включить ваши правки в стабильную версию, пожалуйста, проверьте все изменения, показанные ниже.',
	'revreview-update-includes' => 'Обновлённые шаблоны или файлы (непроверенные выделены жирным):',
	'revreview-reject-text-list' => "Выполняя это действие, вы '''отвергаете''' изменение исходного кода в {{PLURAL:$1|следующей версии|следующих версиях}}:",
	'revreview-reject-text-revto' => 'Возвращает страницу назад к [{{fullurl:$1|oldid=$2}} версии от $3].',
	'revreview-reject-summary' => 'Описание:',
	'revreview-reject-confirm' => 'Отклонить эти изменения',
	'revreview-reject-cancel' => 'Отмена',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Отклонено последнее $1 текстовое изменение|Отклонены последние $1 текстовых изменения|Отклонены последние $1 текстовых изменений}} ($2) и восстановлена версия $3 $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Отклонено первое $1 текстовое изменение|Отклонены первые $1 текстовых изменения|Отклонены первые $1 текстовых изменений}} ($2), {{PLURAL:$1|следовавшее|следовавшие}} за версией $3 $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Отклонено последнее $1 текстовое изменение|Отклонены последние $1 текстовых изменения|Отклонены последние $1 текстовых изменений}} и восстановлена версия $2 $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Отклонено первое $1 текстовое изменение|Отклонены первые $1 текстовых изменения|Отклонены первые $1 текстовых изменений}}, {{PLURAL:$1|следовавшее|следовавшие}} за версией $2 $3',
	'revreview-tt-flag' => 'Подтвердите эту версию, отметив её как проверенную',
	'revreview-tt-unflag' => 'Снять подтверждение с этой версии, отметив её как непроверенную',
	'revreview-tt-reject' => 'Отклонить эти текстовые изменения, откатить их',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'revisionreview' => 'Перевірка верзій',
	'revreview-failed' => "'''Не годен перевірити тоту верзію.'''",
	'revreview-submission-invalid' => 'Приспевок быв некомплетный або інакше хыбный.',
	'review_page_invalid' => 'Назва цілёвой сторінкы не є платна',
	'review_page_notexists' => 'Цілёвой сторінкы не є.',
	'review_page_unreviewable' => 'Цілёва сторінка не є рецензовательна.',
	'review_no_oldid' => 'Незазначеный ідентіфікатор ревізії.',
	'review_bad_oldid' => 'Цілёвой ревізії не є.',
	'review_conflict_oldid' => 'Хтось уж потвердив або зняв потверджіня з той ревізії, покы вы єй перезерали.',
	'review_not_flagged' => 'Цілёва верзія сторінкы теперь не є означена як перевірена.',
	'review_too_low' => 'Ревізія не може быти рецензована, покы дакотры поля суть охаблены "неадекватны".',
	'review_bad_key' => 'Неприпустный ключ параметра включіня.',
	'review_bad_tags' => 'Даякы значіня вказаного таґу суть неприпустны.',
	'review_denied' => 'Приступ забороненый.',
	'review_param_missing' => 'Параметер хыбить або є неправилный.',
	'review_cannot_undo' => 'Не може вернути тоты зміны, зато же далшы чекаючі едітованя змінили тоты  фраґменты.',
	'review_cannot_reject' => 'Не може вернути тоты зміны, зато же дахто уж акцептовав дакотры з них.',
	'review_reject_excessive' => 'Не може нараз вернути тілько велё едітовань.',
	'review_reject_nulledits' => 'Не може вернути тоты зміны, бо вшыткы ревізії мають нуловы едітованя.',
	'revreview-check-flag-p' => 'Акцептовати тоту верзію (обсягує $1 чекаючіх {{PLURAL:$1|зміна|змін}})',
	'revreview-check-flag-p-title' => 'Потвердити вшыткы зміны, якы в даный час чекають на перевірку, вєдно з вашов властнов змінов, Хоснуйте лем в припадї, кідь сьте уж попозерали зміны, внесены тыма змінами.',
	'revreview-check-flag-u' => 'Прияти тоту неперевірену сторінку',
	'revreview-check-flag-u-title' => 'Прияти тоту верзію сторінкы. Хоснуйте лем кідь сьте уж відїли цалу сторінку.',
	'revreview-check-flag-y' => 'Прияти тоты зміны',
	'revreview-check-flag-y-title' => 'Прияти вшыткы зміны вашого едітованя.',
	'revreview-flag' => 'Перевірити тоту ревізію',
	'revreview-reflag' => 'Перевірити тоту ревізію',
	'revreview-invalid' => "'''Неправилный ціль:''' жадна [[{{MediaWiki:Validationpage}}|посуджена]] ревізія не одповідать заданому ID.",
	'revreview-log' => 'Коментарь:',
	'revreview-main' => 'Про посуджіня мусите выбрати єдну із верзій сторінкы.
Відь [[Special:Unreviewedpages|список неперевіреных сторінок]].',
	'revreview-stable1' => 'Може хочете відїти [{{fullurl:$1|stableid=$2}} тоту позначену верзію] і дізнати ся, ці она є теперь [{{fullurl:$1|stable=1}} опублікованов верзіёв] той сторінкы.',
	'revreview-stable2' => 'Може хочете відїти [{{fullurl:$1|stable=1}} опубліковану верзію] той сторінкы.',
	'revreview-submit' => 'Одослати',
	'revreview-submitting' => 'Одосылать ся...',
	'revreview-submit-review' => 'Акцептовати ревізію',
	'revreview-submit-unreview' => 'Зняти акцептованя ревізії',
	'revreview-submit-reject' => 'Не прияти зміны',
	'revreview-submit-reviewed' => 'Выконано. Підтверджена!',
	'revreview-submit-unreviewed' => 'Выконано. Не підтверджена!',
	'revreview-successful' => "'''Выбрана верзія [[:$1|$1]] успішно позначена. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} перегляд вшыткых стабілных верзій])'''",
	'revreview-successful2' => "'''Позначіня ревізії сторінкы [[:$1|$1]] было успішно зняте.'''",
	'revreview-poss-conflict-p' => "'''Варованя: [[User:$1|$1]] почав перевіряти тоту сторінку $2 о $3.'''",
	'revreview-poss-conflict-c' => "'''Варованя: [[User:$1|$1]] почав перевіряти тоты зміны $2 о $3.'''",
	'revreview-adv-reviewing-p' => "'''Позначка: Сьте оголошеный, же сьте зачали перевірёвати тоту сторінку дня $1 о $2.'''",
	'revreview-adv-reviewing-c' => "'''Позначка: Сьте оголошеный, же сьте зачали перевірёвати тоты зміны дня $1 о $2.'''",
	'revreview-toolow' => "'''Мусите становити каждый з атрібутів у значіня высше, як \"недостаточный\", одповідно до процедуры позначіня верзії рецензованов.'''

Жебы зняти статус рецензованя, стисните \"зняти\".

Просиме, стисните клапку «Назад» у перезерачі і спробуйте щі раз.",
	'revreview-update' => "Просиме, [[{{MediaWiki:Validationpage}}|перевірьте]] вшыткы нерецензованы зміны ''(указаны ниже)'', зроблены з моменту встановлїня стабілной верзії.",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Вашы зміны іщі не включены до стабілной верзії.</span> 

Просиме, перевіртье вшыткы зміны, указаны ниже, жебы включіти вашы едітованя до стабілной верзії.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Вашы зміны іщі не включены до стабілной верзії. Опереднї зміны чекають на перевірку</span> 

Просиме, перевіртье вшыткы зміны, указаны ниже, жебы включіти вашы едітованя до стабілной верзії.',
	'revreview-update-includes' => 'Дакотры шаблоны або файлы были обновены (неперевірены суть тучным писмом):',
	'revreview-reject-text-list' => "Докончінём той дїї '''рушыте''' зміны жрідлового тексту з наслїдных {{PLURAL:$1|ревізія|ревізій}} [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'Тото верне сторінку назад до [{{fullurl:$1|oldid = $2}} ревізії $3].',
	'revreview-reject-summary' => 'Згорнутя:',
	'revreview-reject-confirm' => 'Вернути тоты зміны',
	'revreview-reject-cancel' => 'Сторно',
	'revreview-reject-summary-cur' => 'Зрушена остатня {{PLURAL:$1|зміна тексту|$1 змін тексту}} (з $2) і обновлена ревізія $3 од $4',
	'revreview-reject-summary-old' => 'Зрушена перша {{PLURAL:$1|зміна тексту|$1 змін тексту}} (з $2) і обновлена ревізія $3 од $4',
	'revreview-reject-summary-cur-short' => 'Зрушена остатня {{PLURAL:$1|зміна тексту|$1 змін тексту}} (з $2) і обновлена ревізія $2 од $3',
	'revreview-reject-summary-old-short' => 'Зрушена перша {{PLURAL:$1|зміна тексту|$1 змін тексту}} (з $2) котра была по ревізії $2 од $3',
	'revreview-tt-flag' => 'Схвалити тоту верзію єй означінём за "перевірену"',
	'revreview-tt-unflag' => 'Неакцептовати тоту верзію єй означінём за "неперевірену"',
	'revreview-tt-reject' => 'Зрушыти тоты зміны жрідлового тексту їх навернутём',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'revreview-reject-summary' => 'सारांश:',
	'revreview-reject-cancel' => 'निवर्तयते',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'revisionreview' => 'Торумнары ырытыы',
	'revreview-failed' => "'''Барылы тургутуу сатаммата.'''",
	'revreview-submission-invalid' => 'Толорута суох эбэтэр туох эрэ атын алҕастаах эбит.',
	'review_page_invalid' => 'Сорук-сирэй аата сыыһалаах.',
	'review_page_notexists' => 'Сорук-сирэй суох эбит.',
	'review_page_unreviewable' => 'Сорук-сирэй тургутуллубат эбит.',
	'review_no_oldid' => 'Барыл ID-та ыйыллыбатах.',
	'review_bad_oldid' => 'Маннык сорук-сирэй суох эбит.',
	'review_conflict_oldid' => 'Эн көрө олордоххуна ким эрэ бу сирэйи бигэргэппит (эбэтэр бигэргэтиитин устубут).',
	'review_not_flagged' => 'Сорук-барыл билигин көрүллүбүт курдук бэлиэтэммэтэх.',
	'review_bad_key' => 'Холбуур параметр күлүүһэ алҕастаах.',
	'review_denied' => 'Киирии хааччахтаммыт.',
	'review_param_missing' => 'Параметра ыйыллыбатах эбэтэр сыыһа ыйыллыбыт.',
	'review_cannot_undo' => 'Бу уларытыылары төннөрөр табыллыбата, тоҕо диэтэххэ аныгыскы тургутуллуохтаах уларытыылар маны эмиэ таарыйаллар эбит.',
	'review_cannot_reject' => 'Бу уларытыылартан аккаастанар табыллыбата, тоҕо диэтэххэ ким эрэ хайыы үйэ сорҕотун бигэргэтэн кэбиспит.',
	'review_reject_excessive' => 'Бачча элбэх уларытыыттан биирдэ аккаастанар табыллыбат.',
	'revreview-check-flag-p' => '($1 {{PLURAL:$1|Тургутуллубатах уларытыы бу барылын|Тургутуллубутах уларытыылар бу барылларын}}) бигэргэтэргэ',
	'revreview-check-flag-p-title' => 'Туох баар тургутуллуохтаах уларытыылары бэйэҥ уларытыыгын кытта бигэргэт. Маны тургутуллуохтаах уларытыылары көрөн эрэ баран туттуҥ.',
	'revreview-check-flag-u' => 'Тургутуллубатах сирэй бу барылын бигэргэт',
	'revreview-check-flag-u-title' => 'Сирэй бу барылын бигэргэтии. Сирэйи барытын көрөн эрэ баран тутун.',
	'revreview-check-flag-y' => 'Бэйэм уларытыыларбын бигэргэтэбин',
	'revreview-check-flag-y-title' => 'Бу уларытыыга оҥорбут көннөрүүлэргин барытын бигэргэтэҕин.',
	'revreview-flag' => 'торуму ырытыы',
	'revreview-reflag' => 'Барылы хат көрүү',
	'revreview-invalid' => "'''Алҕас сорук:''' Бу ID-га сөп түбэһэр сирэй [[{{MediaWiki:Validationpage}}|бигэ]] барыла суох эбит.",
	'revreview-log' => 'Ырытыы:',
	'revreview-main' => 'Бэрэбиэркэлииргэ сирэй биир эмит барылын талыахтааххын. 

[[Special:Unreviewedpages|Бэрэбиэркэлэммэтэх сирэйдэр тиһиктэрин]] көр.',
	'revreview-stable1' => 'Баҕар эн [{{fullurl:$1|stableid=$2}} бу бэлиэтэммит барылы]  эбэтэр, баар буоллаҕына, сирэй [{{fullurl:$1|stable=1}} бэчээттэммит барылын] көрүөххүн баҕарарыҥ буолуо.',
	'revreview-stable2' => 'Эн өссө бу сирэй [{{fullurl:$1|stable=1}} бэчээттэммит барылын] көрүөххүн сөп.',
	'revreview-submit' => 'Ыыт',
	'revreview-submitting' => 'Ыытыы...',
	'revreview-submit-review' => 'Барылы бигэргэт',
	'revreview-submit-unreview' => 'Бигэргэтиини суох гын',
	'revreview-submit-reject' => 'Уларытыылары сот',
	'revreview-submit-reviewed' => 'Бэлэм. Бигэргэтилиннэ!',
	'revreview-submit-unreviewed' => 'Бэлэм. Бигэргэтии уһулунна!',
	'revreview-successful' => "'''Талыллыбыт [[:$1|$1]] барыл сөпкө бэлиэтэннэ. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} бигэ барыллары көрүү])'''",
	'revreview-successful2' => "'''Талыллыбыт [[:$1|$1]] барылтан бэлиэ уһулунна.'''",
	'revreview-toolow' => "'''Бу барылы ырытыллыбыт диир буоллаххына «бигэргэтиллибэтэх» диэнтэн үөһээ таһымы туруоруохтааххын. '''

Ырытыллыбатах оҥорорго «Бигэргэтиитин уһул» диэни баттаа.

Суолталарын хос туруоруоххун баҕарар буоллаххына браузерыҥ «төнүн» тимэҕин баттаа.",
	'revreview-update' => "'''Бука диэн, бигэ барыл манна көстүбүт уларыйыыларын ''(аллара)'' [[{{MediaWiki:Validationpage}}|тургут эрэ]].'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Эн уларытыыларыҥ бигэ барылга киирэ иликтэр.</span>

Бука диэн, аллара көрдөрүллүбүт уларытыылары көрөн бэйэҥ уларытыыларгын ыстатыйа бигэ барылыгар киллэр.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Эн уларытыыларыҥ бигэ барылга киирэ иликтэр. Ол иннинээҕи көннөрүүлэр тургутуллуохтаахтар.</span>

Бука диэн, аллара көрдөрүллүбүт туох баар уларытыылары көрөн кинилэри ыстатыйа бигэ барылыгар киллэр.',
	'revreview-update-includes' => 'Саҥардыллыбыт халыыптар/билэлэр (тургутуллубатахтар модьу бичигинэн):',
	'revreview-reject-text-list' => "Бу дьайыыны оҥорон Эн {{PLURAL:$1|бу уларытыыны|бу уларытыылары}} '''суох гынаҕын''':",
	'revreview-reject-text-revto' => 'Сирэйи бу барылга [{{fullurl:$1|oldid=$2}} ($3) төннөрөҕүн].',
	'revreview-reject-summary' => 'Түмүк:',
	'revreview-reject-confirm' => 'Бу уларытыылары суох гынарга',
	'revreview-reject-cancel' => 'Салҕаама',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Бүтэһик $1 уларытыы суох оҥоһуллан|Бүтэһик $1 уларытыылар суох оҥоһулланнар}} ($2) бу $3 $4 барыл төннөрүлүннэ.',
	'revreview-tt-flag' => 'Бу барылы бигэргэтэн тургутуллубут курдук бэлиэтээ',
	'revreview-tt-unflag' => 'Бу барыл бигэргэтиитин устан тургутуллубатах курдук бэлиэтээ',
	'revreview-tt-reject' => 'Бу уларытыылары суох гынан ыстатыйаны урукку барылыгар төннөр',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'revreview-log' => 'Cummentu:',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'revisionreview' => 'සංශෝධන නිරීක්ෂණය කරන්න',
	'revreview-failed' => "'''මෙම සංශෝධනය නිරීක්ෂණය කල නොහැක.'''",
	'review_page_invalid' => 'ඉලක්කගත පිටුවේ මාතෘකාව අනීතිකයි.',
	'review_page_notexists' => 'ඉලක්කගත පිටුව නොපවතියි.',
	'review_page_unreviewable' => 'ඉලක්කගත පිටුව නිරික්ෂණමය නොවේ.',
	'review_no_oldid' => 'සංශෝධන හැඳුනුමක් විශේෂණය කර නොමැත.',
	'review_bad_oldid' => 'ඉලක්කගත සංශෝධනය නොපවතියි.',
	'review_bad_key' => 'වලංගු නොවන අන්තහ්කරණ පරාමිති යතුර.',
	'review_denied' => 'අවසරදීමට නොහැක.',
	'review_param_missing' => 'පරාමිතිය මඟහැරී ඇත හෝ වලංගු නොවේ.',
	'review_reject_excessive' => 'එක් වතාවකට මෙවැනි සංස්කරණ රාශියක් ප්‍රතික්ෂේප කල නොහැක.',
	'revreview-check-flag-u' => 'මෙම නිරීක්ෂණය නොකළ පිටුව පිළිගන්න',
	'revreview-check-flag-y' => 'මගේ වෙනස්කම් බාරගන්න',
	'revreview-check-flag-y-title' => 'ඔබ මෙතැනදී සිදුකල සියලුම වෙනස්කම් පිළිගන්න.',
	'revreview-flag' => 'මෙම සංශෝධනය නිරීක්ෂණය කරන්න',
	'revreview-reflag' => 'මෙම සංශෝධනය නැවත-නිරීක්ෂණය කරන්න',
	'revreview-log' => 'පරිකථනය:',
	'revreview-submit' => 'යොමන්න',
	'revreview-submitting' => 'යොමු කරමින් …',
	'revreview-submit-review' => 'සංශෝධනය පිළිගන්න',
	'revreview-submit-unreview' => 'සංශෝධනය පිළිනොගන්න',
	'revreview-submit-reject' => 'වෙනස්කම් ප්‍රතික්ෂේප කරන්න',
	'revreview-submit-reviewed' => 'හරි. බාරගත්තා!',
	'revreview-submit-unreviewed' => 'හරි. බාරගත්තේ නෑ!',
	'revreview-adv-start-link' => 'ප්‍රචාරණය කරන්න',
	'revreview-adv-stop-link' => 'ප්‍රචාරණය නොකිරීම',
	'revreview-reject-summary' => 'සාරාංශය:',
	'revreview-reject-confirm' => 'මෙම වෙනස්කම් ප්‍රතික්ෂේප කරන්න',
	'revreview-reject-cancel' => 'අවලංගු කරන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'revisionreview' => 'Prezrieť kontroly',
	'revreview-failed' => "'''Nebolo možné skontrolovať túto revíziu.''' Príspevok je neúplný alebo inak neplatný.",
	'review_page_invalid' => 'Názov cieľovej stránky nie je platný.',
	'review_page_notexists' => 'Cieľová stránka neexistuje.',
	'review_page_unreviewable' => 'Cieľovú stránku nie je možné kontrolovať.',
	'review_no_oldid' => 'Nebol uvedený ID revízie.',
	'review_bad_oldid' => 'Cieľová revízia neexistuje.',
	'review_not_flagged' => 'Cieľová revízia momentálne nie je označená ako skontrolovaná.',
	'review_too_low' => 'Revíziu nemožno označiť za skontrolovanú, keď sú niektoré polia ponechané ako „neadekvátne“.',
	'review_bad_key' => 'Neplatný kľúč parametra.',
	'review_denied' => 'Nedostatočné oprávnenie.',
	'review_param_missing' => 'Parameter je neplatný alebo chýba.',
	'review_cannot_undo' => 'Nie je možné vrátiť tieto zmeny, pretože ďalšie čakajúce úpravy zmenili rovnaké oblasti.',
	'revreview-check-flag-p' => 'Označiť čakajúce úpravy ako skontrolované',
	'revreview-check-flag-p-title' => 'Prijať všetky momentálne čakajúce zmeny spolu s vašou vlastnou úpravy. Toto použite, iba ak ste už videli celý rozdiel čakajúcich zmien.',
	'revreview-check-flag-u' => 'Prijať túto neskontrolovanú stránku',
	'revreview-check-flag-u-title' => 'Prijať túto verziu stránky. Použite, iba ak ste už videli celú stránku.',
	'revreview-check-flag-y' => 'Prijať tieto zmeny',
	'revreview-check-flag-y-title' => 'Prijať všetky zmeny, ktoré ste vykonali v tejto úprave.',
	'revreview-flag' => 'Skontrolovať túto verziu',
	'revreview-reflag' => 'Znova skontrolovať/zrušiť skontrolovanie tejto revízie',
	'revreview-invalid' => "'''Neplatný cieľ:''' zadanému ID nezodpovedá žiadna [[{{MediaWiki:Validationpage}}|skontrolovaná]] revízia.",
	'revreview-log' => 'Komentár záznamu:',
	'revreview-main' => 'Musíte vybrať konkrétnu verziu stránky s obsahom, aby ste ju mohli skontrolovať. 

Pozri zoznam [[Special:Unreviewedpages|neskontrolovaných stránok]].',
	'revreview-stable1' => 'Môžete zobraziť [{{fullurl:$2|stableid=$2}} túto označenú verziu] alebo sa pozrieť, či je teraz [{{fullurl:$1|stable=1}} stabilná verzia] tejto stránky.',
	'revreview-stable2' => 'Môžete zobraziť [{{fullurl:$1|stable=1}} stabilnú verziu] tejto stránky (ak ešte existuje).',
	'revreview-submit' => 'Odoslať',
	'revreview-submitting' => 'Odosiela sa...',
	'revreview-submit-review' => 'Označiť ako skontrolované',
	'revreview-submit-unreview' => 'Označiť ako neskontrolované',
	'revreview-submit-reject' => 'Odmietnuť zmeny',
	'revreview-submit-reviewed' => 'Hotovo. Prijaté!',
	'revreview-submit-unreviewed' => 'Hotovo. Neprijaté!',
	'revreview-successful' => "'''Vybraná revízia [[:$1|$1]] bola úspešne označená. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} zobraziť stabilné verzie])'''",
	'revreview-successful2' => "'''Označenie vybranej revízie [[:$1|$1]] bolo úspešne zrušené.'''",
	'revreview-toolow' => "'''Musíte ohodnotiť každý z nasledujúcich atribútov minimálne vyššie ako „neschválené“, aby bolo možné verziu považovať za skontrolovanú.'''
Ak chcete učiniť verziu zavrhovanou, nastavte všetky polia na „neschválené“.

Prosím, stlačte tlačidlo „Späť“ vo svojom prehliadači a skúste to znova.",
	'revreview-update' => "Prosím, [[{{MediaWiki:Validationpage}}|skontrolujte]] všetky zmeny ''(zobrazené nižšie)'', ktoré boli vykonané od [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} schválenia].<br />
'''Niektoré šablóny/súbory sa zmenili:'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Vaše zmeny zatiaľ nie sú v stabilnej verzii.</span> 

Prosím, prečítajte si všetky nižšie uvedené zmeny, aby sa vaše úpravy sa objaví v stabilnej verzii. 
Možno budete musieť pokračovať alebo „vrátiť“ úpravy.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Vaše zmeny zatiaľ nie sú v stabilnej verzii. Existujú predchádzajúce zmeny čakajúce na kontrolu.</span> 

Prosím, prečítajte si všetky nižšie uvedené zmeny, aby sa vaše úpravy sa objaví v stabilnej verzii. 
Možno budete musieť pokračovať alebo „vrátiť“ úpravy.',
	'revreview-update-includes' => 'Niektoré šablóny/súbory sa zmenili:',
	'revreview-tt-flag' => 'Označiť túto revíziu ako skontrolovanú',
	'revreview-tt-unflag' => 'Označiť túto revíziu ako neskontrolovanú',
	'revreview-tt-reject' => 'Odmietnuť tieto zmeny ich vrátením',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'revisionreview' => 'Preglej redakcije',
	'revreview-failed' => "'''Ne morem pregledati te redakcije.'''",
	'revreview-submission-invalid' => 'Oddaja je bila nepopolna ali kako drugače neveljavna.',
	'review_page_invalid' => 'Naslov ciljne strani je neveljaven.',
	'review_page_notexists' => 'Ciljna stran ne obstaja.',
	'review_page_unreviewable' => 'Ciljne strani ni mogoče pregledati.',
	'review_no_oldid' => 'ID redakcije ni določen.',
	'review_bad_oldid' => 'Ciljna redakcija ne obstaja.',
	'review_conflict_oldid' => 'Nekdo je že sprejel ali zavrnil redakcijo, medtem ko ste si jo ogledovali.',
	'review_not_flagged' => 'Ciljna redakcija trenutno ni označena kot pregledana.',
	'review_too_low' => 'Redakcija ne more biti pregledana z nekaterimi polji izpoljenimi »neustrezno«.',
	'review_bad_key' => 'Neveljavni parameter vključitvenega ključa.',
	'review_bad_tags' => 'Nekatere od navedenih vrednosti oznak so neveljavne.',
	'review_denied' => 'Dovoljenje je zavrnjeno.',
	'review_param_missing' => 'Parameter manjka ali ni veljaven.',
	'review_cannot_undo' => 'Teh sprememb ni mogoče razveljaviti, ker so nadaljnja urejanja v teku spremenila ista področja.',
	'review_cannot_reject' => 'Ne morem zavrniti teh sprememb, ker je nekdo že sprejel nekatera (ali vsa) urejanja.',
	'review_reject_excessive' => 'Naenkrat ni mogoče zavrniti toliko urejanj.',
	'review_reject_nulledits' => 'Teh sprememb ne morem zavrniti, ker so vse redakcije ničelna urejanja.',
	'revreview-check-flag-p' => 'Sprejmi to različico (vključuje $1 {{PLURAL:$1|spremembo|spremembi|spremembe|sprememb}} v teku)',
	'revreview-check-flag-p-title' => 'Sprejmi vse trenutne spremembe v teku skupaj z mojim urejanjem. To uporabite samo, če ste si že ogledali celotno primerjavo sprememb v teku.',
	'revreview-check-flag-u' => 'Sprejmi to nepregledano stran',
	'revreview-check-flag-u-title' => 'Sprejmi to različico strani. To uporabite samo, če ste si že ogledali celotno stran.',
	'revreview-check-flag-y' => 'Sprejmi te spremembe',
	'revreview-check-flag-y-title' => 'Sprejmite vse spremembe, ki ste jih narediti v tem urejanju.',
	'revreview-flag' => 'Ocenite to redakcijo',
	'revreview-reflag' => 'Ponovno ocenite to redakcijo',
	'revreview-invalid' => "'''Neveljavni cilj:''' nobena [[{{MediaWiki:Validationpage}}|pregledana]] redakcija ne ustreza danemu ID-ju.",
	'revreview-log' => 'Komentar:',
	'revreview-main' => 'Izbrati morate določeno redakcijo vsebinske strani, če jo želite pregledati.

Oglejte si [[Special:Unreviewedpages|seznam nepregledanih strani]].',
	'revreview-stable1' => 'Morda si želite ogledati [{{fullurl:$1|stableid=$2}} to označeno različico] in videti, če je zdaj [{{fullurl:$1|stable=1}} ustaljena različica] strani.',
	'revreview-stable2' => 'Morda si želite ogledati [{{fullurl:$1|stable=1}} ustaljeno različico] strani.',
	'revreview-submit' => 'Potrdi',
	'revreview-submitting' => 'Potrjevanje ...',
	'revreview-submit-review' => 'Sprejmi redakcijo',
	'revreview-submit-unreview' => 'Redakcije ne sprejmi',
	'revreview-submit-reject' => 'Zavrni spremembe',
	'revreview-submit-reviewed' => 'Končano. Potrjeno!',
	'revreview-submit-unreviewed' => 'Končano. Od-potrjeno!',
	'revreview-successful' => "'''Redakcija [[:$1|$1]] je bila uspešno označena. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} ogled pregledanih različic])'''",
	'revreview-successful2' => "'''Redakcija [[:$1|$1]] je uspešno odznačena.'''",
	'revreview-poss-conflict-p' => "'''Opozorilo: [[User:$1|$1]] je pričel(-a) pregledovati to stran dne $2 ob $3.'''",
	'revreview-poss-conflict-c' => "'''Opozorilo: [[User:$1|$1]] je pričel(-a) pregledovati te spremembe dne $2 ob $3.'''",
	'revreview-adv-reviewing-p' => 'Obvestilo: Drugi pregledovalci lahko vidijo, da pregledujete to stran.',
	'revreview-adv-reviewing-c' => 'Obvestilo: Drugi pregledovalci lahko vidijo, da pregledujete te spremembe.',
	'revreview-sadv-reviewing-p' => 'Drugim uporabnikom lahko $1, da pregledujete to stran.',
	'revreview-sadv-reviewing-c' => 'Drugim uporabnikom lahko $1, da pregledujete te spremembe.',
	'revreview-adv-start-link' => 'razglasi',
	'revreview-adv-stop-link' => 'prenehaj razglaševati',
	'revreview-toolow' => "'''Vse atribute morate oceniti višje od »neustrezno«, če želite redakcijo označiti kot pregledano.'''

Za odstranitev stanja pregleda redakcije kliknite »ne sprejmi«.

Prosimo, kliknite gumb »nazaj« v vašem brskalniku in poskusite znova.",
	'revreview-update' => "'''Prosimo, [[{{MediaWiki:Validationpage}}|preglejte]] kakršne koli spremembe v teku ''(prikazane spodaj)'', ki so bile narejene po ustaljeni različici.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Vaše spremembe še niso v ustaljeni različici.</span>

Prosimo, preglejte vse spremembe prikazane podaj, da prikažete vaše spremembe v ustaljeni različici.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Vaše spremembe še niso v ustaljeni različici. Obstajajo pretekle spremembe, ki čakajo na pregled.</span>

Prosimo, preglejte vse spremembe prikazane podaj, da prikažete vaše spremembe v ustaljeni različici.',
	'revreview-update-includes' => 'Predloge/datoteke so posodobljene (nepregledane strani so zapisane krepko):',
	'revreview-reject-text-list' => "Z izvedbo tega dejanja boste '''zavrnili''' spremembe izvornega besedila od {{PLURAL:$1|naslednje redakcije|naslednjih redakcij}} [[:$2|$2]]:",
	'revreview-reject-text-revto' => 'To bo povrnilo stran nazaj na [{{fullurl:$1|oldid=$2}} različico dne $3].',
	'revreview-reject-summary' => 'Povzetek:',
	'revreview-reject-confirm' => 'Zavrni te spremembe',
	'revreview-reject-cancel' => 'Prekliči',
	'revreview-reject-summary-cur' => 'Zavrnil {{PLURAL:$1|zadnjo spremembo|zadnji $1 spremembi|zadnje $1 spremembe|zadnjih $1 sprememb}} besedila (od $2) in obnovil redakcije $3 do $4',
	'revreview-reject-summary-old' => 'Zavrnil {{PLURAL:$1|prvo spremembo besedila, ki je sledila|prvi $1 spremembi besedila, ki sta sledili|prve $1 spremembe besedila, ki so sledile|prvih $1 sprememb besedila, ki so sledile}} (od $2) redakciji $3 do $4',
	'revreview-reject-summary-cur-short' => 'Zavrnil {{PLURAL:$1|zadnjo spremembo|zadnji $1 spremembi|zadnje $1 spremembe|zadnjih $1 sprememb}} besedila in obnovil redakcije $2 do $3',
	'revreview-reject-summary-old-short' => 'Zavrnil {{PLURAL:$1|prvo spremembo besedila, ki je sledila|prvi $1 spremembi besedila, ki sta sledili|prve $1 spremembe besedila, ki so sledile|prvih $1 sprememb besedila, ki so sledile}} redakciji $2 do $3',
	'revreview-tt-flag' => 'Sprejmite to redakcijo tako, da jo označite kot »preverjeno«',
	'revreview-tt-unflag' => 'Odsprejmite to redakcijo tako, da jo označite kot »nepreverjeno«',
	'revreview-tt-reject' => 'Zavrnite te spremembe besedila tako, da jih vrnete',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'revisionreview' => 'Преглед измена',
	'review_page_invalid' => 'Наслов циљане стране је неисправан.',
	'review_page_notexists' => 'Циљана страна не постоји.',
	'review_page_unreviewable' => 'Циљана страна се не може прегледати.',
	'revreview-flag' => 'Преглед ове верзије',
	'revreview-invalid' => "'''Лош циљ:''' ниједна [[{{MediaWiki:Validationpage}}|прегледана]] верзије не поседује дати редни број.",
	'revreview-log' => 'Коментар:',
	'revreview-main' => 'Морате изабрати одређену измену странице са садржајем да бисте је проверили.
Погледајте [[Special:Unreviewedpages|списак непрегледаних страница]].',
	'revreview-stable2' => 'Можда бисте хтели да видите [{{fullurl:$1|stable=1}} прихваћену верзију] ове стране.',
	'revreview-submit' => 'Пошаљи',
	'revreview-submitting' => 'Шаљем…',
	'revreview-submit-review' => 'Прихвати измену',
	'revreview-submit-unreview' => 'Поништи измену',
	'revreview-submit-reviewed' => 'Готово. Усвојено!',
	'revreview-submit-unreviewed' => 'Готово. Није усвојено!',
	'revreview-successful2' => "'''Успешно је скинута ознака са означене верзије стране [[:$1|$1]].'''",
	'revreview-update-includes' => 'Ажурирани шаблони/датотеке (непрегледане странице су подебљане):',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'revisionreview' => 'Pregled verzija',
	'review_page_invalid' => 'Naslov ciljane strane je neispravan.',
	'review_page_notexists' => 'Ciljana strana ne postoji.',
	'review_page_unreviewable' => 'Ciljana strana se ne može pregledati.',
	'revreview-flag' => 'Pregled ove verzije',
	'revreview-invalid' => "'''Loš cilj:''' nijedna [[{{MediaWiki:Validationpage}}|pregledana]] verzije ne poseduje dati redni broj.",
	'revreview-log' => 'Komentar:',
	'revreview-main' => 'Morate izabrati određenu izmenu stranice sa sadržajem da biste je proverili.
Pogledajte [[Special:Unreviewedpages|spisak nepregledanih stranica]].',
	'revreview-stable2' => 'Možda biste hteli da vidite [{{fullurl:$1|stable=1}} prihvaćenu verziju] ove strane.',
	'revreview-submit' => 'Pošalji',
	'revreview-submitting' => 'Slanje...',
	'revreview-submit-review' => 'Prihvati izmenu',
	'revreview-submit-unreview' => 'Poništi izmenu',
	'revreview-submit-reviewed' => 'Gotovo. Usvojeno!',
	'revreview-submit-unreviewed' => 'Gotovo. Nije usvojeno!',
	'revreview-successful2' => "'''Uspešno je skinuta oznaka sa označene verzije strane [[:$1|$1]].'''",
	'revreview-update-includes' => 'Ažurirani šabloni/datoteke (nepregledane stranice su podebljane):',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'revisionreview' => 'Versionswröigenge',
	'revreview-flag' => 'Wröig Version',
	'revreview-log' => 'Logbouk-Iendraach:',
	'revreview-main' => 'Du moast ne Artikkelversion tou Wröigenge uutwääle.

Sjuch [[Special:Unreviewedpages]] foar ne Lieste fon nit pröiwede Versione.',
	'revreview-submit' => 'Wröigenge spiekerje',
	'revreview-toolow' => 'Du moast foar älk fon do unnerstoundende Attribute n Wäid haager as „{{int:revreview-accuracy-0}}“ ienstaale, 
deermäd ne Version as wröiged jält. Uum ne Version tou fersmieten, mouten aal Attribute ap „{{int:revreview-accuracy-0}}“ stounde.',
	'revreview-update' => "[[{{MediaWiki:Validationpage}}|Wröig]] älke Annerenge ''(sjuch hierunner)'' siet ju lääste stoabile Version [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} fräiroat] wuude.

'''Do foulgjende Foarloagen un Bielden wuuden ferannerd:'''",
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'revreview-log' => 'Kamandang:',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Cohan
 * @author Dafer45
 * @author GameOn
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Nghtwlkr
 * @author Rotsee
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'revisionreview' => 'Granska sidversioner',
	'revreview-failed' => "'''Kunde inte granska denna sidversion.'''",
	'revreview-submission-invalid' => 'Inlämningen var ofullständig eller på annat sätt ogiltig.',
	'review_page_invalid' => 'Målsidans titel är ogiltig.',
	'review_page_notexists' => 'Målsidan existerar inte.',
	'review_page_unreviewable' => 'Målsidan är inte granskningsbar.',
	'review_no_oldid' => 'Inget versions-ID angavs.',
	'review_bad_oldid' => 'Det finns ingen sådan målversion.',
	'review_not_flagged' => 'Målrevisionen är inte markerad som granskad.',
	'review_too_low' => 'Sidversion kan inte granskas med några kvarvarande fält "otillräckliga".',
	'review_bad_key' => 'Ogiltig nyckel för inkluderingsparameter.',
	'review_bad_tags' => 'Några av de angivna taggvärdena är ogiltiga.',
	'review_denied' => 'Tillstånd nekat.',
	'review_param_missing' => 'En parameter saknas eller är ogiltig.',
	'review_cannot_undo' => 'Kan inte ångra dessa ändringar eftersom ytterligare väntande redigeringar har ändrat i samma områden.',
	'review_reject_excessive' => 'Kan inte avvisa så många ändringar på en gång.',
	'revreview-check-flag-p' => 'Accept this version (includes $1 pending {{PLURAL:$1|change|changes}})',
	'revreview-check-flag-p-title' => 'Acceptera alla nuvarande väntande ändringar tillsammans med din egen redigering. Använd endast detta om du redan har sett hela diffen för väntande ändringar.',
	'revreview-check-flag-u' => 'Acceptera denna ogranskade sida',
	'revreview-check-flag-u-title' => 'Acceptera den här versionen av sidan. Använd endast detta om du redan sett hela sidan.',
	'revreview-check-flag-y' => 'Acceptera dessa ändringar',
	'revreview-check-flag-y-title' => 'Acceptera alla ändringarna som du har gjort i denna redigering.',
	'revreview-flag' => 'Granska denna sidversion',
	'revreview-reflag' => 'Återgranska denna sidversion',
	'revreview-invalid' => "'''Ogiltigt mål:''' inga [[{{MediaWiki:Validationpage}}|granskade]] versioner motsvarar den angivna IDn.",
	'revreview-log' => 'Kommentar:',
	'revreview-main' => 'Du måste välja en viss version av en innehållssida för att kunna granska den.

Se [[Special:Unreviewedpages|listan över ogranskade sidor]].',
	'revreview-stable1' => 'Du kanske vill se [{{fullurl:$1|stableid=$2}} den här flaggade versionen] för att se om den nu är den [{{fullurl:$1|stable=1}} accepterade versionen] av den här sidan.',
	'revreview-stable2' => 'Du vill kanske se den [{{fullurl:$1|stable=1}} accepterade versionen] av denna sida.',
	'revreview-submit' => 'Spara',
	'revreview-submitting' => 'Levererar...',
	'revreview-submit-review' => 'Godkänn revision',
	'revreview-submit-unreview' => 'Acceptera inte revision',
	'revreview-submit-reject' => 'Avvisa ändringar',
	'revreview-submit-reviewed' => 'Klar. Godkänd!',
	'revreview-submit-unreviewed' => 'Klar. Inte accepterad!',
	'revreview-successful' => "'''Vald sidversion av [[:$1|$1]] har flaggats. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} visa alla stabila sidversioner])'''",
	'revreview-successful2' => "'''Vald sidversion av [[:$1|$1]] har avflaggats.'''",
	'revreview-poss-conflict-p' => "'''Varning: [[User:$1|$1]] började granska denna sida den $2 kl. $3.'''",
	'revreview-poss-conflict-c' => "'''Varning: [[User:$1|$1]] började granska dessa ändringar den $2 kl. $3.'''",
	'revreview-adv-reviewing-p' => 'OBS: Andra granskare kan se att du granskar denna sida.',
	'revreview-adv-reviewing-c' => 'OBS: Andra granskare kan se att du granskar dessa ändringar.',
	'revreview-sadv-reviewing-p' => 'Du kan $1 dig själv som att du granskar denna sida till andra användare.',
	'revreview-sadv-reviewing-c' => 'Du kan $1 dig själv som att du granskar dessa ändringar till andra användare.',
	'revreview-adv-start-link' => 'annonsera',
	'revreview-adv-stop-link' => 'av-annonsera',
	'revreview-toolow' => '\'\'\'Du måste bedöma varje attribut högre än "otillräcklig" för att en sidversion ska anses som granskad.\'\'\'

För att ta bort granskningsstatusen för en version, klicka på "oacceptera".

Klicka på "tillbaka"-knappen i din webbläsare och försök igen.',
	'revreview-update' => "'''Vänligen [[{{MediaWiki:Validationpage}}|granska]] några väntande ändringar ''(visas nedan)'' på den accepterade versionen.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Dina ändringar är ännu inte i den stabila versionen.</span>

Vänligen granska alla ändringar som visas nedan för att göra så att dina redigeringar visas i den stabila versionen.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Dina ändringar är ännu inte i den stabila versionen. Det finns tidigare ändringar som väntar på granskning</span>

Vänligen granska alla ändringar som visas nedan för att göra så att dina redigeringar visas i den stabila versionen.',
	'revreview-update-includes' => 'Mallar/filer har uppdaterats (ogranskade sidor i fet text):',
	'revreview-reject-text-revto' => 'Detta kommer att återställa sidan tillbaka till [{{fullurl:$1|oldid=$2}} versionen från $3].',
	'revreview-reject-summary' => 'Sammanfattning:',
	'revreview-reject-confirm' => 'Avvisa dessa ändringar',
	'revreview-reject-cancel' => 'Avbryt',
	'revreview-reject-summary-cur' => 'Avvisade {{PLURAL:$1|den senaste textändringen|de $1 senaste textändringarna}} (av $2) och återställd sidversion $3 av $4',
	'revreview-reject-summary-old' => 'Avvisade {{PLURAL:$1|den första textändringen|de $1 första textändringarna}} (av $2) som följde sidversion $3 av $4',
	'revreview-reject-summary-cur-short' => 'Avvisade {{PLURAL:$1|den senaste textändringen|de $1 senaste textändringarna}} och återställd sidversion $2 av $3',
	'revreview-reject-summary-old-short' => 'Avvisade {{PLURAL:$1|den första textändringen|de $1 första textändringarna}} som följde sidversion $2 av $3',
	'revreview-tt-flag' => 'Acceptera denna sidversion genom att markera den "kontrollerad"',
	'revreview-tt-unflag' => 'Oacceptera denna sidversion genom att markera den som "okontrollerad"',
	'revreview-tt-reject' => 'Avslå dessa källtext-ändringar genom att återställa dem',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'revreview-log' => 'Sababu:',
	'revreview-submit' => 'Wasilisha',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Badiliko la kwanza lililofuata|Mabadiliko ya $1 yaliyofuata}} pitio la $2 lililoandikwa na $3',
);

/** Tamil (தமிழ்)
 * @author Mahir78
 * @author TRYPPN
 */
$messages['ta'] = array(
	'revisionreview' => 'மறுஆய்வின் மதிப்பீடுகள்',
	'review_page_invalid' => 'இலக்கு பக்கத்தின் தலைப்பு சரியானதாக இல்லை.',
	'review_page_notexists' => 'இந்த இலக்குப் பக்கம் இல்லை.',
	'review_page_unreviewable' => 'இந்த இலக்குப் பக்கத்தை மதிப்பீடு செய்ய இயலாது.',
	'review_no_oldid' => 'மதிப்பீடு அடையாள எண் கொடுக்கப்படவில்லை.',
	'review_bad_oldid' => 'இந்த இலக்குப் மதிப்பீடு பதிப்பு இல்லை.',
	'review_not_flagged' => 'இந்த இலக்கு திருத்தப் பதிப்பு தற்போது மதிப்பிடப்பட்டதாக குறிக்கப்படவில்லை.',
	'review_denied' => 'அனுமதி தடைசெய்யப்பட்டது.',
	'review_param_missing' => 'ஒரு காரணி காணப்படவில்லை அல்லது தவறானது',
	'revreview-check-flag-p' => 'நிலுவை மாற்றங்களை ஏற்றுக்கொள்க',
	'revreview-check-flag-p-title' => 'தற்போதுள்ள எல்லா நிலுவை மாற்றங்களையும் நீங்கள் தொகுத்தவைகளுடன் ஏற்றுக்கொள்ளுங்கள். நீங்கள் ஏற்கெனவே முழு நிலுவையில் உள்ள மாற்றங்களை சரிபார்த்திருந்தால் மட்டுமே.',
	'revreview-check-flag-u' => 'மதிப்பீடு செய்யாத இந்தப் பக்கத்தை ஏற்றுக்கொள்க',
	'revreview-check-flag-y' => 'இந்த மாற்றங்களை ஏற்றுக்கொள்க',
	'revreview-check-flag-y-title' => 'நீங்கள் தொகுத்த எல்லா மாற்றங்களையும் ஏற்றுக்கொள்க.',
	'revreview-flag' => 'இந்த மறுபதிப்பை மதிப்பிடுக',
	'revreview-reflag' => 'இந்த மறுபதிப்பை மீண்டும் மதிப்பிடுக',
	'revreview-invalid' => "'''தவறான இலக்கு:''' no [[{{MediaWiki:Validationpage}}|reviewed]] revision corresponds to the given ID.",
	'revreview-log' => 'கருத்து:',
	'revreview-submit' => 'சமர்ப்பி',
	'revreview-submitting' => 'சமர்பிக்கப்படுகிறது ...',
	'revreview-submit-review' => 'திருத்தங்களை ஏற்றுக்கொள்',
	'revreview-submit-unreview' => 'திருத்தங்கள் ஏற்றுக்கொள்ளப்படமாட்டாது',
	'revreview-submit-reject' => 'மாற்றங்களைத் தள்ளுபடிசெய்க',
	'revreview-submit-reviewed' => 'முடிந்தது. ஏற்றுக்கொள்ளப்பட்டது!',
	'revreview-submit-unreviewed' => 'முடிந்தது. ஏற்றுக்கொள்ளப்படவில்லை!',
	'revreview-tt-flag' => "''சரிபார்க்கப்பட்டது'' என்று குறிப்பிட்டுவிட்டு, இந்த மாற்றத்தை ஒத்துக்கொள்ளவும்.",
	'revreview-tt-unflag' => "''சரிபார்க்கப்படவில்லை'' என்று குறிப்பிட்டுவிட்டு பின் இந்த மாற்றத்தை ஒத்துக்கொள்ளவேண்டாம்",
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Kiranmayee
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'revisionreview' => 'కూర్పులను సమీక్షించు',
	'revreview-failed' => 'రివ్యూ తప్పింది',
	'review_page_invalid' => 'లక్ష్యిత పుట శీర్షిక చెల్లనిది.',
	'review_page_notexists' => 'లక్ష్యిత పుట లేనే లేదు.',
	'review_denied' => 'అనుమతిని నిరాకరించారు.',
	'revreview-flag' => 'ఈ కూర్పుని సమీక్షించండి',
	'revreview-log' => 'వ్యాఖ్య:',
	'revreview-main' => 'సమీక్షించడానికి మీరు విషయపు పేజీ యొక్క ఓ నిర్ధిష్ట కూర్పుని ఎంచుకోవాలి.

[[Special:Unreviewedpages|సమీక్షించని పేజీల జాబితా]]ని చూడండి.',
	'revreview-stable2' => 'మీరు ఈ పేజీ యొక్క [{{fullurl:$1|stable=1}} సుస్థిర కూర్పు]ని (అది ఉండి ఉంటే) చూడొచ్చు.',
	'revreview-submit' => 'దాఖలుచెయ్యి',
	'revreview-submitting' => 'దాఖలుచేస్తున్నాం...',
	'revreview-submit-review' => 'కూర్పుని అంగీకరించు',
	'revreview-submit-reject' => 'మార్పులను తిరస్కరించండి',
	'revreview-submit-reviewed' => 'పూర్తియ్యింది. అంగీకరించారు!',
	'revreview-toolow' => 'ఓ కూర్పును సమీక్షించినట్లుగా భావించాలంటే కింద ఇచ్చిన గుణాలన్నిటినీ "సమ్మతించలేదు" కంటే ఉన్నతంగా రేటు చెయ్యాలి.',
	'revreview-update' => "సుస్థిర కూర్పుని [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} అనుమతించిన] తర్వాత జరిగిన ''(క్రింద చూపించిన)'' మార్పులను [[{{MediaWiki:Validationpage}}|సమీక్షించండి]].

'''కొన్ని మూసలు/ఫైళ్లను  తాజాకరించారు:'''",
	'revreview-update-includes' => 'కొన్ని మూసలు/ఫైళ్లను తాజాకరించారు:',
	'revreview-reject-text-list' => 'ఈ చర్యను పూర్తి చేస్తే మీరు కింది {{PLURAL:$1|మార్పు|మార్పుల}}ను ’’’తిరస్కరిస్తున్నట్లే’’’:',
	'revreview-reject-text-revto' => 'ఇది ఈ పేజీని తిరిగి [{{fullurl:$1|oldid=$2}} $3 నాటి వెర్షను]కు తీసుకెళ్తుంది.',
	'revreview-reject-summary' => 'సారాంశం:',
	'revreview-reject-confirm' => 'ఈ మార్పులను తిరస్కరించు',
	'revreview-reject-cancel' => 'రద్దుచేయి',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|మార్పు|$1 మార్పుల}}ను  ($2 చేసినవి) తిరస్కరించి, $4 చేసిన  కూర్పు $3 ను పునస్థాపించాం.',
	'revreview-reject-summary-old' => '$4 చేసిన  కూర్పు $3 తరువాత చేసిన మొదటి {{PLURAL:$1|మార్పు|$1 మార్పుల}}ను  ($2 చేసినవి) తిరస్కరించాం.',
	'revreview-reject-summary-cur-short' => 'చివరి {{PLURAL:$1|మార్పు|$1 మార్పుల}}ను  తిరస్కరించి, $3 చేసిన  కూర్పు $2 ను పునస్థాపించాం.',
	'revreview-reject-summary-old-short' => '$3 చేసిన కూర్పు $2 తరువాత చేసిన మొదటి {{PLURAL:$1|మార్పు|$1 మార్పుల}}ను తిరస్కరించాం.',
	'revreview-tt-reject' => 'ఈ మార్పులను౮ వెనక్కి తీసుకుపోయి, వాటిని తిరస్కరించు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'revreview-reject-summary' => 'Rezumu:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'revisionreview' => 'Нусхаҳои баррасӣ',
	'revreview-flag' => 'Ин нусхаро барраси кунед',
	'revreview-log' => 'Тавзеҳ:',
	'revreview-main' => 'Шумо бояд як нусхаи хосро аз саҳифаи мӯҳтаво барои баррасӣ кардан, интихоб кунед.

Барои дарёфт кардани саҳифаҳои баррасинашуда ба [[Special:Unreviewedpages]] нигаред.',
	'revreview-submit' => 'Сабти баррасӣ',
	'revreview-toolow' => 'Шумо бояд ҳар як аз мавориди зеринро ба дараҷаи беш аз  "таъйиднашуда" аломат бизанед, то он нусха баррасишуда ба ҳисоб равад. Барои бебаҳо кардани як нусха, тамоми маворидро "таъйиднашуда" аломат бизанед.',
	'revreview-update' => "Лутфан тамоми тағйироте (дар зер оварда шудааст), ки пас аз охирин нусхаи пойдор амалӣ шударо  [[{{MediaWiki:Validationpage}}|барраси кунед]], ки аз замоне, ки нусхаи пойдор  [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} таъйидшуда] буд.

'''Бархе аз шаблонҳо/аксҳо барӯз шудаанд:'''",
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'revisionreview' => 'Nusxahoi barrasī',
	'revreview-flag' => 'In nusxaro barrasi kuned',
	'revreview-log' => 'Tavzeh:',
	'revreview-toolow' => 'Şumo bojad har jak az mavoridi zerinro ba daraçai beş az  "ta\'jidnaşuda" alomat bizaned, to on nusxa barrasişuda ba hisob ravad. Baroi bebaho kardani jak nusxa, tamomi mavoridro "ta\'jidnaşuda" alomat bizaned.',
);

/** Thai (ไทย)
 * @author Horus
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'review_page_notexists' => 'ไม่มีหน้าเป้าหมาย',
	'revreview-check-flag-y' => 'ยอมรับการเปลี่ยนแปลงของฉัน',
	'revreview-submit' => 'ส่ง',
	'revreview-submitting' => 'กำลังส่ง...',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'revisionreview' => 'Wersiýalary gözden geçir',
	'revreview-failed' => "'''Bu wersiýany gözden geçirip bolmaýar.''' Tabşyrma doly däl ýa-da nädogry.",
	'review_page_invalid' => 'Niýetlenilýän sahypa ady nädogry.',
	'review_page_notexists' => 'Niýetlenilýän sahypa ýok.',
	'review_page_unreviewable' => 'Niýetlenilýän sahypany gözden geçirip bolmaýar.',
	'review_no_oldid' => 'Hiç hili wersiýa ID-si görkezilmändir.',
	'review_bad_oldid' => 'Niýetlenilýän wersiýa ýok.',
	'review_not_flagged' => 'Niýetlenilýän wersiýa häzirki wagtda gözden geçirilen diýlip bellenilmändir.',
	'review_denied' => 'Rugsat ret edildi.',
	'review_param_missing' => 'Parametr ýok ýa-da nädogry.',
	'revreview-check-flag-p' => 'Garaşýan özgerdişleri gözden geçirilen diýip belle',
	'revreview-check-flag-u' => 'Bu gözden geçirilmedik sahypany kabul et',
	'revreview-check-flag-u-title' => 'Sahypanyň bu wersiýasyny abul et. Muny diňe tutuş sahypany gören bolsaňyz ulanyň.',
	'revreview-check-flag-y' => 'Bu üýtgeşmeleri kabul et',
	'revreview-check-flag-y-title' => 'Bu özgerdişde eden ähli üýtgeşmeleriňizi kabul ediň.',
	'revreview-flag' => 'Bu wersiýany gözden geçir',
	'revreview-reflag' => 'Bu wersiýany gaýtadan gözden geçir/gözden geçirme',
	'revreview-invalid' => "'''Nädogry niýetlenilýän:''' hiç bir [[{{MediaWiki:Validationpage}}|gözden geçirilen]] wersiýa berlen ID-ä laýyk gelmeýär.",
	'revreview-log' => 'Teswir:',
	'revreview-main' => 'Gözden geçirmek üçin, mazmunly sahypanyň belli bir wersiýasyny saýlamaly.

[[Special:Unreviewedpages|Gözden geçirilmedik sahyplaryň sanawyna]] serediň.',
	'revreview-stable1' => '[{{fullurl:$1|stableid=$2}} Bu baýdakly wersiýany] görüp, belkem bu sahypanyň [{{fullurl:$1|stable=1}} durnukly wersiýadygyny] ýa-da däldigini görmek isleýänsiňiz.',
	'revreview-stable2' => 'Belkem bu sahypanyň [{{fullurl:$1|stable=1}} durnukly wersiýasyny] görmek isleýänsiňiz (eger henizem duran bolsa).',
	'revreview-submit' => 'Tabşyr',
	'revreview-submitting' => 'Tabşyrylýar...',
	'revreview-submit-review' => 'Gözden geçirilen diýip belle',
	'revreview-submit-unreview' => 'Gözden geçirilmedik diýip belle',
	'revreview-submit-reject' => 'Üýtgeşmeleri ret et',
	'revreview-submit-reviewed' => 'Boldy. Kabul edildi!',
	'revreview-submit-unreviewed' => 'Boldy. Kabul edilmedi!',
	'revreview-successful' => "'''[[:$1|$1]] wersiýasy şowly baýdaklandy. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} durnukly wersiýalary gör])'''",
	'revreview-successful2' => "'''[[:$1|$1]] wersiýasynyň baýdagy şowly aýryldy.'''",
	'revreview-toolow' => '\'\'\'Bir wersiýanyň gözden geçirilen diýlip hasap edilmegi üçin aşakdaky aýratynlyklardan iň bolmanda birine "tassyklanmadyk"dan ýokary ses bermeli\'\'\'. 
Bir wersiýany köneltmek üçin ähli meýdançalary "tassyklanmadyk" diýip belläň.

Brauzeriňizde "yza" düwmesine basyň we gaýtadan synanyşyň.',
	'revreview-update' => "Durnukly wersiýa [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} tassyklanandan] bäri edilen islendik üýtgeşmäni ''(aşakda görkezilen)'' [[{{MediaWiki:Validationpage}}|gözden geçiriň]].<br />
'''Käbir şablonlar/faýllar täzelenilipdir:'''",
	'revreview-update-includes' => 'Käbir şablonlar/faýllar täzelendi:',
	'revreview-tt-flag' => 'Bu wersiýany gözden geçirilen diýip belle',
	'revreview-tt-unflag' => 'Bu wersiýany gözden geçirilmedik diýip belle',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'revisionreview' => 'Suriing muli ang mga pagbabago',
	'revreview-failed' => "'''Hindi nagawang masuri ang rebisyong ito.'''",
	'revreview-submission-invalid' => 'Hindi buo ang pagpapassa o kaya ay hindi tanggap.',
	'review_page_invalid' => 'Hindi tanggap ang puntiryang pahina ng pamagat.',
	'review_page_notexists' => 'Hindi umiiral ang pinupukol na pahina.',
	'review_page_unreviewable' => 'Hindi masusuri ang puntiryang pahina.',
	'review_no_oldid' => 'Walang tinukoy na ID ng rebisyon.',
	'review_bad_oldid' => 'Walang ganyang puntiryang rebisyon.',
	'review_conflict_oldid' => 'May ibang tao na tumanggap o hindi tumanggap ng rebisyong ito habang sinusuri mo ito.',
	'review_not_flagged' => 'Ang puntiryang rebisyon ay kasalukuyang hindi natatakan bilang nasuri na.',
	'review_too_low' => 'Hindi masusuri ang rebisyon kung may ilang mga lugar na iniwang "hindi sapat".',
	'review_bad_key' => 'Hindi tanggap na paramentrong susi ng pagsama.',
	'review_bad_tags' => 'Hindi katanggap-tanggap ang ilan sa tinukoy na mga halaga ng tatak.',
	'review_denied' => 'Ipinagkait ang pahintulot.',
	'review_param_missing' => 'Nawawala o hindi tanggap ang isang parametro.',
	'review_cannot_undo' => 'Hindi maibabalik sa dati ang mga pagbabago dahil ang kasunod na iba pang nakabinbing mga pamamatnugot ay nagbago ng katulad na mga lugar.',
	'review_cannot_reject' => 'Hindi matatanggihan ang mga pagbabagong ito dahil may ibang tao nang tumanggap sa ilan (o lahat) ng mga pagbabago.',
	'review_reject_excessive' => 'Hindi matanggihan sa isang pagkakataon ang ganito karaming mga pagbabago.',
	'revreview-check-flag-p' => 'Tanggapin ang bersyong ito (kabilang ang $1 na naghihintay na {{PLURAL:$1|pagbabago|mga pagbabago}})',
	'revreview-check-flag-p-title' => 'Tanggapin ang lahat ng pangkasalukuyang nakabinbing mga pagbabago kasama ang binago mo.
Gamitin lamang ito kapag nakita mo na ang buong pagkakaiba ng mga pagbabagong nakabinbin.',
	'revreview-check-flag-u' => 'Tanggapin ang hindi nasuring pahinang ito',
	'revreview-check-flag-u-title' => 'Tanggapin ang bersyong ito ng pahina.  Gamitin lamang ito kung nakita mo na ang buong pahina.',
	'revreview-check-flag-y' => 'Tanggapin ang mga pagbabagong ito',
	'revreview-check-flag-y-title' => 'Tanggapin ang lahat ng mga pagbabagong ginawa mo sa pamamatnugot na ito.',
	'revreview-flag' => 'Suriing muli ang pagbabagong ito',
	'revreview-reflag' => 'Muling suriin ang rebisyong ito.',
	'revreview-invalid' => "'''Hindi tanggap na puntirya:''' walang [[{{MediaWiki:Validationpage}}|muling nasuring]] pagbabagong tumutugma sa ibinigay na ID.",
	'revreview-log' => 'Kumento/puna:',
	'revreview-main' => 'Dapat kang pumili ng isang partikular na pagbabago mula sa isang pahinan ng nilalaman upang makapagsuri.

Tingnan ang [[Special:Unreviewedpages|talaan ng mga pahina hindi pa nasusuring muli]].',
	'revreview-stable1' => 'Maaaring naisin mong tingnan ang [{{fullurl:$1|stableid=$2}} ibinandilang bersyong ito] at tingnan kung ito na ngayon ang [{{fullurl:$1|stable=1}} tanggap na bersyon] ng pahinang ito.',
	'revreview-stable2' => 'Baka nais mong tingnan ang [{{fullurl:$1|stable=1}} matatag na bersyon] ng pahinang ito.',
	'revreview-submit' => 'Ipasa',
	'revreview-submitting' => 'Ipinapasa...',
	'revreview-submit-review' => 'Tanggapin ang pagbabago',
	'revreview-submit-unreview' => 'Huwag tanggapin ang pagbabago',
	'revreview-submit-reject' => 'Tanggihan ang mga pagbabago',
	'revreview-submit-reviewed' => 'Gawa na. Tinanggap na!',
	'revreview-submit-unreviewed' => 'Ginawa na. Hindi tinanggap!',
	'revreview-successful' => "'''Matagumpay na ang pagbabandila (pagtatatak) sa pagbabago ng [[:$1|$1]]. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} tingnan ang matatatag na mga bersyon])'''",
	'revreview-successful2' => "'''Matagumpay ang pagtatanggal ng bandila (pagaalis ng tatak) sa pagbabago ng [[:$1|$1]].'''",
	'revreview-poss-conflict-p' => "'''Babala: Nagsimula si [[User:$1|$1]] na magsuring muli ng pahinang ito noong $2 noong $3.'''",
	'revreview-poss-conflict-c' => "'''Babala: Nagsimula si [[User:$1|$1]] na magsuring muli ng mga pagbabagong ito noong $2 noong $3.'''",
	'revreview-toolow' => '\'\'\'Dapat mong antasan ang bawat isang katangian na mas mataas kaysa "hindi sapat" upang maisaalang-alang ang pagbabago bilang nasuri na.\'\'\'

Upang matanggal ang katayuan ng pagsusuri ng isang rebisyon, pindutin ang "huwag tanggapin".

Pakipindot ang pindutang "bumalik" sa iyong pantingin-tingin at subukang muli.',
	'revreview-update' => "''' Mangyaring [[{{MediaWiki:Validationpage}}|pakisuri]] ang anumang nakabinbing mga pagbabago ''(ipinapakita sa ibaba)'' na ginawa magmula noong magkaroon ng matatag ang bersyon.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Ang mga binago mo ay hindi pa nasa loob ng matatag na bersyon.</span>

Pakisuri ang lahat ng mga pagbabagong ipinakikita sa ibaba upang magawang lumitaw ang mga binago mo sa loob ng matatag na bersyon.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Ang mga binago mo ay hindi pa nasa loob ng matatag na bersyon.  May mga naunang mga pagbabago naghihintay ng pagsusuri.</span>

Pakisuri ang lahat ng mga pagbabagong ipinapakita sa ibaba upang magawang lumitaw ng mga binago mo sa loob ng matatag na bersyon.',
	'revreview-update-includes' => 'Naisapanahon na ang ilang mga suleras/talaksan:',
	'revreview-reject-text-list' => "Sa pamamagitan ng pagbuo sa galaw na ito, '''tatanggihan''' mo ang sumusunod na {{PLURAL:$1|pagbabago|mga pagbabago}}:",
	'revreview-reject-text-revto' => 'Magpapabalik ito ng pahina sa dati papunta sa [{{fullurl:$1|oldid=$2}} bersyon ng $3].',
	'revreview-reject-summary' => 'Buod:',
	'revreview-reject-confirm' => 'Tanggihan ang mga pagbabagong ito',
	'revreview-reject-cancel' => 'Huwag ituloy',
	'revreview-reject-summary-cur' => 'Tinanggihan ang huling {{PLURAL:$1|pagbabago|$1 mga pagbabago}} (ni $2) at ibinalik ang rebisyong $3 ni $4',
	'revreview-reject-summary-old' => 'Tinanggihan ang unang {{PLURAL:$1|pagbabago|$1 mga pagbabago}} (ni $2) na sinundan ng rebisyong $3 ni $4',
	'revreview-reject-summary-cur-short' => 'Tinanggihan ang huling {{PLURAL:$1|pagbabago|$1 mga pagbabago}} at naibalik ang rebisyong $2 ni $3',
	'revreview-reject-summary-old-short' => 'Tinanggihana ng unang {{PLURAL:$1|pagbabago|$1 mga pagbabago}} na sumundo sa rebisyong $2 ni $3',
	'revreview-tt-flag' => 'Tanggapin ang rebisyong ito sa pamamagitan ng pagtatatak dito bilang "nasuri"',
	'revreview-tt-unflag' => 'Huwag tanggapin ang rebisyong ito sa pamamagitan ng pagtatatak dito bilang "hindi nasuri"',
	'revreview-tt-reject' => 'Tanggihan ang mga pagbabagong ito sa pamamagitan ng pagpapabalik sa mga ito',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Joseph
 * @author Khutuck
 * @author Srhat
 * @author Szoszv
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'revisionreview' => 'Revizyonları incele',
	'revreview-failed' => "'''Bu revizyon incelenemiyor.'''",
	'revreview-submission-invalid' => 'Eksik veya başka bir şekilde geçersiz gönderim.',
	'review_page_invalid' => 'Hedef sayfa başlığı geçersiz.',
	'review_page_notexists' => 'Hedef sayfa mevcut değil.',
	'review_page_unreviewable' => 'Hedef sayfa incelenebilir değil.',
	'review_no_oldid' => 'Revizyon no belirtilmedi.',
	'review_bad_oldid' => 'Hedef revizyon mevcut değil.',
	'review_conflict_oldid' => 'Birisi siz sayfayı görüntülerken bu revizyonu kabul ya da reddetti.',
	'review_not_flagged' => 'Hedef revizyon, şu an için incelenmiş olarak işaretlenmemiş.',
	'review_too_low' => "Revizyon, bazı alanlar ''yetersiz'' olarak bırakılmışken incelenemez.",
	'review_bad_key' => 'Geçersiz kapsama parametresi anahtarı',
	'review_bad_tags' => 'Belirtilen etiket değerlerinin bazıları geçersizdir.',
	'review_denied' => 'İzin reddedildi.',
	'review_param_missing' => 'Bir parametre eksik veya geçersiz.',
	'review_cannot_undo' => 'Bu değişiklikler geri alınamıyor, çünkü bekleyen düzenlemeler aynı alanları değiştirmiş.',
	'review_cannot_reject' => 'Bu değişiklikler reddedilemiyor, çünkü biri düzenlemelerin bazılarını (ya da tamamını) zaten kabul etmiş.',
	'review_reject_excessive' => 'Bu kadar fazla düzenleme tek seferde reddedilemez.',
	'review_reject_nulledits' => 'Tüm değişiklikler boş (geçersiz) olduğu için bu değişiklikler reddedildi.',
	'revreview-check-flag-p' => 'Bu sürümü kabul et (bekleyen $1 değişiklik içeriyor)',
	'revreview-check-flag-p-title' => 'Kendi değişikliğinle birlikte beklemekte olan tüm değişiklikleri kabul et. Bu özelliği yalnızca tüm bekleyen değişiklik farklarını gördüyseniz kullanın.',
	'revreview-check-flag-u' => 'Bu incelenmemiş sayfayı kabul et',
	'revreview-check-flag-u-title' => 'Sayfanın bu sürümünü kabul et. Bunu yalnızca tüm sayfayı gördüyseniz kullanın.',
	'revreview-check-flag-y' => 'Değişikliklerimi kabul et',
	'revreview-check-flag-y-title' => 'Burada yaptığın tüm değişiklikleri kabul et.',
	'revreview-flag' => 'Bu revizyonu incele',
	'revreview-reflag' => 'Bu revizyonu tekrar incele',
	'revreview-invalid' => "'''Geçersiz hedef:''' hiçbir [[{{MediaWiki:Validationpage}}|incelenmiş]] revizyon verilen no.ya uymuyor.",
	'revreview-log' => 'Yorum:',
	'revreview-main' => 'İncelemek için içerik sayfasından belirli bir revizyon seçmelisiniz.

[[Special:Unreviewedpages|İncelenmemiş sayfalar listesine]] göz atın.',
	'revreview-stable1' => '[{{fullurl:$1|stableid=$2}} Bu bayraklanmış sürümü] görerek bu sayfanın [{{fullurl:$1|stable=1}} kararlı sürümü] olup olmadığını görmek isteyebilirsiniz.',
	'revreview-stable2' => 'Bu sayfanın [{{fullurl:$1|stable=1}} kararlı sürümünü] görmek isteyebilirsiniz.',
	'revreview-submit' => 'Gönder',
	'revreview-submitting' => 'Gönderiliyor...',
	'revreview-submit-review' => 'Revizyonu kabul et',
	'revreview-submit-unreview' => 'Revizyonu kabul etme',
	'revreview-submit-reject' => 'Değişiklikleri reddet',
	'revreview-submit-reviewed' => 'Tamam. Kabul edildi!',
	'revreview-submit-unreviewed' => 'Tamam. Kabul edilmedi!',
	'revreview-successful' => "'''[[:$1|$1]] sayfasının revizyonu başarıyla bayraklandı. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} kararlı sürümleri gör])'''",
	'revreview-successful2' => "'''[[:$1|$1]] sayfasının revizyon bayrağı başarıyla kaldırıldı.'''",
	'revreview-poss-conflict-p' => "''' Uyarı: [[User:$1|$1]] Bu sayfa üzerinde inceleme başlattı: $2 $3 .'' '",
	'revreview-poss-conflict-c' => "''' Uyarı: [[User:$1|$1]] Bu değişiklikler üzerinde inceleme başlattı: $2 $3 .'' '",
	'revreview-adv-reviewing-p' => 'Bilgi: Diğer kullanıcılar bu değişikliği incelediğinizi görebilirler.',
	'revreview-adv-reviewing-c' => 'Bilgi: Diğer kullanıcılar bu değişiklikleri incelediğinizi görebilirler.',
	'revreview-sadv-reviewing-p' => 'Bu sayfayı incelemekte olduğunuzu diğer kullanıcılara $1bilirsiniz.',
	'revreview-sadv-reviewing-c' => 'Bu değişiklikleri incelemekte olduğunuzu diğer kullanıcılara $1bilirsiniz.',
	'revreview-adv-start-link' => 'bildire',
	'revreview-adv-stop-link' => 'Bildirme!',
	'revreview-toolow' => '\'\'\'Bir revizyonun incelenmiş sayılabilmesi için özniteliklerin hepsini "yetersiz" düzeyden yüksek derecelendirmelisiniz.\'\'\'

Bir revizyonun inceleme durumunu kaldırmak için, "kabul etme" seçeneğine tıklayın.

Lütfen tarayıcınızdaki "geri" tuşuna basın ve tekrar deneyin.',
	'revreview-update' => "'''Lütfen kararlı sürümden sonra yapılmış olan ve aşağıda yer alan tüm bekleyen değişiklikleri [[{{MediaWiki:Validationpage}}|inceleyin]].'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Değişiklikleriniz henüz kararlı sürüm içinde değildir.</span>

Değişikliklerinizin kararlı sürümde yer alması için lütfen aşağıda gösterilen tüm değişiklikleri inceleyin.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Değişiklikleriniz henüz kararlı sürüm için değildir. İnceleme bekleyen eski değişiklikler bulunmaktadır.</span>

Değişikliklerinizin kararlı sürümde yer alması için, lütfen aşağıda gösterilen tüm değişiklikleri inceleyin.',
	'revreview-update-includes' => 'Sablonlar/dosyalar güncellenmiş (gözden geçirilmemiş sayfalar koyu renkli):',
	'revreview-reject-text-list' => "Bu eylemi tamamlayarak, aşağıdaki {{PLURAL:$1|değişiklik|değişiklikleri}} '''reddetmiş''' olacaksınız:",
	'revreview-reject-text-revto' => 'Bu sayfa [{{fullurl:$1|oldid=$2}} $3 tarihli] revizyona geri dönecektir.',
	'revreview-reject-summary' => 'Özet:',
	'revreview-reject-confirm' => 'Bu değişiklikleri reddet',
	'revreview-reject-cancel' => 'İptal',
	'revreview-tt-flag' => 'Bu revizyonu kontrol edilmiş olarak işaretleyerek onayla',
	'revreview-tt-unflag' => 'Bu revizyonu "kontrol edilmemiş" olarak işaretleyerek kabul etme',
	'revreview-tt-reject' => 'Değişiklikleri geri alarak reddet',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author Dim Grits
 * @author JenVan
 * @author NickK
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'revisionreview' => 'Перевірка версій',
	'revreview-failed' => "'''Не вдалося перевірити цю версію.'''",
	'revreview-submission-invalid' => 'Дане подання було неповним або іншим чином недійсним.',
	'review_page_invalid' => 'Неприпустима назва цільової сторінки.',
	'review_page_notexists' => 'Цільової сторінки не існує.',
	'review_page_unreviewable' => 'Цільова сторінка не підлягає рецензуванню.',
	'review_no_oldid' => 'Незазначений ідентифікатор версії.',
	'review_bad_oldid' => 'Немає такої цільової версії.',
	'review_conflict_oldid' => 'Хтось вже підтвердив або зняв підтвердження з цієї версії, поки ви переглядали її.',
	'review_not_flagged' => 'Цільова версія сторінки зараз не позначена перевіреною.',
	'review_too_low' => 'Версію не може бути рецензовано через невстановлені значення деяких полів.',
	'review_bad_key' => 'неприпустимий ключ параметра включення.',
	'review_bad_tags' => 'Деякі значення вказаного тега неприпустимі.',
	'review_denied' => 'Доступ заборонено.',
	'review_param_missing' => 'Параметр не зазначено або зазначено невірно.',
	'review_cannot_undo' => 'Не можна скасувати ці зміни, тому що подальші редагування, що очікують перевірки, змінили ці фрагменти.',
	'review_cannot_reject' => 'Неможливо скасувати ці зміни, тому, що хтось вже перевірив деякі з них.',
	'review_reject_excessive' => 'Неможливо скасувати таку велику кількість редагувань відразу.',
	'review_reject_nulledits' => 'Не можна відмовитися від цих змін, тому що всі редагування порожні.',
	'revreview-check-flag-p' => 'Позначити цю версію перевіреною (включає $1 {{PLURAL:$1|неперевірену версію|неперевірені версії|неперевірених версій}})',
	'revreview-check-flag-p-title' => 'Підтвердити всі зміни, що в даний час очікують перевірки, разом з вашою власною зміною. Використовуйте тільки у випадку, якщо ви вже переглянули відмінності, внесені цими змінами.',
	'revreview-check-flag-u' => 'Позначити цю сторінку перевіреною',
	'revreview-check-flag-u-title' => 'Позначити цю версію сторінки перевіреною. Використовуйте тільки у випадку, якщо ви переглянули сторінку повністю.',
	'revreview-check-flag-y' => 'Прийняти ці зміни',
	'revreview-check-flag-y-title' => 'Підтвердити всі зміни, які ви зробили в цьому редагуванні.',
	'revreview-flag' => 'Перевірити цю версію',
	'revreview-reflag' => 'Переперевірити цю версію',
	'revreview-invalid' => "'''Неправильна ціль:''' нема [[{{MediaWiki:Validationpage}}|перевіреної]] версії сторінки, яка відповідає даному ідентифікатору.",
	'revreview-log' => 'Коментар:',
	'revreview-main' => 'Ви повинні обрати одну з версій сторінки для перевірки.

Див. також [[Special:Unreviewedpages|список неперевірених сторінок]].',
	'revreview-stable1' => 'Можливо, ви хочете переглянути [{{fullurl:$1|stableid=$2}} цю позначену версію] і дізнатись, чи є вона зараз [{{fullurl:$1|stable=1}} опублікованою версією] цієї сторінки.',
	'revreview-stable2' => 'Ви можете переглянути [{{fullurl:$1|stable=1}} опубліковану версію] цієї сторінки.',
	'revreview-submit' => 'Позначити',
	'revreview-submitting' => 'Надсилання...',
	'revreview-submit-review' => 'Затвердити версію',
	'revreview-submit-unreview' => 'Зняти затвердження версії',
	'revreview-submit-reject' => 'Відхилити зміни',
	'revreview-submit-reviewed' => 'Виконано. Затверджена!',
	'revreview-submit-unreviewed' => 'Виконано. Не затверджена!',
	'revreview-successful' => "'''Обрана версія [[:$1|$1]] успішно позначена. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} перегляд усіх стабільних версій])'''",
	'revreview-successful2' => "'''Із обраної версії [[:$1|$1]] успішно знята позначка.'''",
	'revreview-poss-conflict-p' => "'''Попередження: [[User:$1|$1]] почав перевіряти цю сторінку $2 о $3.'''",
	'revreview-poss-conflict-c' => "'''Попередження: [[User:$1|$1]] почав перевіряти цю сторінку $2 о $3.'''",
	'revreview-adv-reviewing-p' => 'Примітка: Інші рецензенти можуть бачити, що ви рецензуєте цю сторінку.',
	'revreview-adv-reviewing-c' => 'Примітка: Інші рецензенти можуть бачити, що ви рецензуєте ці редагування.',
	'revreview-sadv-reviewing-p' => 'Ви можете $1 для інших користувачів, що рецензуєте цю сторінку.',
	'revreview-sadv-reviewing-c' => 'Ви можете $1 для інших користувачів, що рецензуєте ці редагування.',
	'revreview-adv-start-link' => 'показувати',
	'revreview-adv-stop-link' => 'не показувати',
	'revreview-toolow' => "'''Ви повинні встановити кожен з атрибутів у значення вище, ніж \"недостатній\", відповідно до процедури позначення версії рецензованою.'''

Щоб зняти статус рецензування, натисніть \"зняти\".

Будь ласка, натисніть кнопку «Назад» у браузері і спробуйте ще раз.",
	'revreview-update' => "Будь ласка, [[{{MediaWiki:Validationpage}}|перевірте]] всі нерецензовані зміни ''(показані нижче)'', зроблені з моменту встановлення стабільної версії.",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Ваші зміни ще не включені до стабільної версії.</span> 

Будь ласка, перевірте усі зміни, наведені нижче, щоб включити ваші редагування до стабільної версії.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Ваші зміни ще не включені до стабільної версії. Попередні зміни очікують на перевірку.</span>

Будь ласка, перевірте усі зміни, наведені нижче, щоб включити ваші редагування до стабільної версії.',
	'revreview-update-includes' => 'Деякі шаблони або файли були оновлені (неперевірені виділені жирним шрифтом):',
	'revreview-reject-text-list' => "Виконуючи цю дію, ви '''відкидаєте''' зміну вихідного коду в {{PLURAL:$1|наступній редакції|наступних редакціях}} [[:$2|$2]] :",
	'revreview-reject-text-revto' => 'Відкидає сторінку назад до [{{fullurl:$1|oldid=$2}} версії від $3].',
	'revreview-reject-summary' => 'Опис:',
	'revreview-reject-confirm' => 'Скасувати ці зміни',
	'revreview-reject-cancel' => 'Скасувати',
	'revreview-reject-summary-cur' => '{{PLURAL:$1|Скасовано останнє редагування|Скасовані останні $1 редагування|Скасовано останні $1 редагувань}} ($2) і відновлена версія $3 $4',
	'revreview-reject-summary-old' => '{{PLURAL:$1|Скасовано перше редагування|Скасовані перші $1 редагування|Скасовані перші $1 редагувань}} ($2), {{PLURAL:$1|слідуюче|слідуючі}} за версією $3 $4',
	'revreview-reject-summary-cur-short' => '{{PLURAL:$1|Скасовано останнє редагування|Скасовані останні $1 редагування|Скасовано останні $1 редагувань}} і відновлена версія $2 $3',
	'revreview-reject-summary-old-short' => '{{PLURAL:$1|Скасовано перше редагування|Скасовані перші $1 редагування|Скасовані перші $1 редагувань}}, {{PLURAL:$1|наступне|наступні}} за версією $2 $3',
	'revreview-tt-flag' => 'Затвердити цю версію з позначенням її перевіреною',
	'revreview-tt-unflag' => 'Зняти затвердження цієї версії шляхом позначення її як "неперевірена"',
	'revreview-tt-reject' => 'Відхилити ці зміни вихідного тексту, повернувшись до попередньої версії',
);

/** Vèneto (Vèneto)
 * @author Candalua
 * @author Frigotoni
 */
$messages['vec'] = array(
	'revisionreview' => 'Riesamina versioni',
	'revreview-failed' => "'''Inpossibile controlar la revision.''' La proposta la xe inconpleta o invalida.",
	'review_page_invalid' => 'La pagina de destinassion no la xe valida.',
	'review_page_notexists' => 'La pagina de destinassion no la esiste.',
	'review_page_unreviewable' => 'La pagina de destinassion no la xe revisionabile.',
	'review_no_oldid' => 'Nessun ID de revision indicà.',
	'review_bad_oldid' => 'La revision de destinassion no la esiste.',
	'review_not_flagged' => 'La revision de destinassion no la atualmente segnà come revisionà.',
	'review_too_low' => 'La revision no se pole controlarla se dei canpi i xe ancora "inadeguà".',
	'review_bad_key' => "Ciave del parametro d'inclusion sbalià.",
	'review_denied' => 'Parmesso negà.',
	'review_param_missing' => 'Un parametro el xe mancante o invalido.',
	'review_cannot_undo' => 'No se pole anular sti canbiamenti parché altri canbiamenti pendenti i gà canbià i stessi tochi.',
	'revreview-check-flag-p' => 'Pùblica i canbiamenti atualmente in atesa',
	'revreview-check-flag-p-title' => 'Aceta tuti i canbiamenti pendenti insieme co la to modifica. Falo solo che te ghè zà visto tuta la difarensa de i canbiamenti in sospeso.',
	'revreview-check-flag-u' => 'Aceta sta pagina mia revisionà',
	'revreview-check-flag-u-title' => 'Aceta sta version de la pagina. Falo solo se te ghè zà visto la pagina intiera.',
	'revreview-check-flag-y' => 'Aceta sti canbiamenti',
	'revreview-check-flag-y-title' => 'Aceta tuti i cambiamenti che te ghè fato in sta modifica.',
	'revreview-flag' => 'Riesamina sta version',
	'revreview-reflag' => 'Ricontrola da novo sta revision',
	'revreview-invalid' => "'''Destinassion mìa valida:''' el nùmaro fornìo no'l corisponde a nissuna version [[{{MediaWiki:Validationpage}}|riesaminà]].",
	'revreview-log' => 'Comento:',
	'revreview-main' => 'Ti gà da selessionar na version in particolare de la pagina par esaminarla.

Varda la [[Special:Unreviewedpages|lista de pagine da riesaminar]].',
	'revreview-stable1' => 'Ti pol vardar sta [{{fullurl:$1|stableid=$2}} version marcàda] par védar se desso la xe la [{{fullurl:$1|stable=1}} version publicà] de sta pagina.',
	'revreview-stable2' => 'Te pol vardar la [{{fullurl:$1|stable=1}} version stabile] de sta pagina.',
	'revreview-submit' => 'Manda',
	'revreview-submitting' => "So' drio mandarlo...",
	'revreview-submit-review' => 'Aceta la revision',
	'revreview-submit-unreview' => 'Disaprova la revision',
	'revreview-submit-reject' => 'Rifiuta i canbiamenti',
	'revreview-submit-reviewed' => 'Finìo. Aprovà!',
	'revreview-submit-unreviewed' => 'Finìo. Rifiutà!',
	'revreview-successful' => "'''La revision de [[:$1|$1]] la xe stà verificà. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} varda tute le version stabili])'''",
	'revreview-successful2' => "'''Cavà el contrassegno a la version selessionà de [[:$1|$1]].'''",
	'revreview-adv-reviewing-p' => 'Ocio: Altri contribudori i pol vedare che sito drio riesaminare sta pajina.',
	'revreview-adv-reviewing-c' => 'Ocio: Altri contribudori i pol vedare che sito drio riesaminare sti canbiamenti.',
	'revreview-toolow' => '\'\'\'Ti gà da segnar ognuno dei atributi qua soto piessè alto de "Non aprovà" parché la revision la sia considerà verificà.\'\'\'

Par anular el stato de na revision, struca "disaprova".

Par piaser struca el boton "indrìo" del to browser e pròa da novo.',
	'revreview-update' => "'''Par piaser [[{{MediaWiki:Validationpage}}|verifica]] tuti i canbiamenti ''(mostrà qua soto)'' fati rispeto a la version stabile.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Le to modifiche no le xe gnancora ne la version stabile.</span> 

Par piaser rivarda tute le modifiche qua soto parché le to modifiche le vegna mostrà ne la version stabile. 
Podarìa esser necessario proseguire o "anulare" modifiche.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Le to modifiche no le xe gnancora ne la version stabile. Ghe xe canbiamenti precedenti pendenti.</span> 

Par piaser rivarda tute le modifiche qua soto parché le to modifiche le vegna mostrà ne la version stabile. 
Podarìa esser necessario proseguire o "anulare" modifiche.',
	'revreview-update-includes' => 'Alcuni modèi o file i xe stà agiornà:',
	'revreview-reject-text-revto' => 'Questo riporterà ła pajina ała [{{fullurl:$1|oldid=$2}} version de $3]',
	'revreview-reject-summary' => 'Comento:',
	'revreview-reject-confirm' => 'Rifiuta sti canbiamenti',
	'revreview-reject-cancel' => 'Lascia stare',
	'revreview-reject-summary-cur' => 'Rifiutae {{PLURAL:$1|łe modifeghe|$1 text changes}} (aportà da $2) e confermà ła version $3 de $4',
	'revreview-reject-summary-old' => 'Rifiutà {{PLURAL:$1|ła prima modifegà|$1 text changes}} (aportà da $2) e confermà ła version $3 de $4',
	'revreview-tt-flag' => 'Aceta sta revision segnandola come "controlà"',
	'revreview-tt-unflag' => 'Disaprova sta revision segnandola come "mia controlà"',
	'revreview-tt-reject' => 'Rifiuta ste modifiche tirandole indrio',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'revisionreview' => 'Versijoiden kodvind',
	'revreview-failed' => "'''Ei voi kodvda versijad.'''",
	'review_denied' => 'Ei sa tulda.',
	'revreview-check-flag-p' => 'Kodvda nece versii ($1 {{PLURAL:$1|kodvmatoi toižetuz|$1 kodvmatont toižetust}})',
	'revreview-flag' => 'Kodvda nece versii',
	'revreview-reflag' => 'Kodvda nece versii udes',
	'revreview-invalid' => "'''Petuzline met:''' ei ole lehtpolen [[{{MediaWiki:Validationpage}}|kodvdud]] versijad, kudamb sättub ozutadud identifikatoranke.",
	'revreview-log' => 'Homaičend:',
	'revreview-main' => 'Pidab valita lehtpolen versii arvostelendan täht.

Kc. [[Special:Unreviewedpages|kodvmatomiden lehtpoliden nimikirjutez]].',
	'revreview-stable1' => 'Voib olda, teil linneb taht lugeda necen lehtpolen [{{fullurl:$1|stableid=$2}} znamoitud versijad] vai [{{fullurl:$1|stable=1}} publikoitud versijad], ku se om wikiš.',
	'revreview-stable2' => 'Sab kacta necen lehtpolen [{{fullurl:$1|stable=1}} publikuidud versii].',
	'revreview-submit' => 'Oigeta',
	'revreview-submitting' => 'Oigendamine...',
	'revreview-submit-review' => 'Vahvištoitta versii',
	'revreview-submit-unreview' => 'Heitta vahvištoitand',
	'revreview-successful' => "'''Valitud [[:$1|$1]]-versii om znamoitud satusekahas. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} stabiližiden versijoiden kacund])'''",
	'revreview-successful2' => "'''Virg om heittud [[:$1|$1]]-versijaspäi.'''",
	'revreview-adv-start-link' => 'reklamiruida',
	'revreview-toolow' => 'Pidab kirjutada kaikuččiden znamoičedoiden täht korktemb tazopind, mi "vähehk", miše versii lugetihe kodvdud.
Miše heitta necen versijan kodvindan tunduz, paingat "ei ole znamoitud".
Olgat hüväd, paingat kaclimes "Tagaze"-painim, miše kirjutada znamoičendad udes.',
	'revreview-update' => 'Olgat hüväd, [[{{MediaWiki:Validationpage}}|kodvgat]] toižetused "(alemba ozutadud)" vahvištoittud versijaha.',
	'revreview-update-includes' => 'Udištadud šablonad/failad (kodvmatomad oma anttud sanktal šriftal):',
	'revreview-reject-cancel' => 'Heitta pätand',
	'revreview-tt-flag' => 'Vahvištoitkat nece versii i znamoikat se kut kodvdud',
	'revreview-tt-unflag' => 'Heitkat poiš necen versijan vahvištoitand  i znamoikat se kut kodvmatoi',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Trần Nguyễn Minh Huy
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'revisionreview' => 'Các bản đã duyệt',
	'revreview-failed' => "'''Không thể duyệt phiên bản này.'''",
	'revreview-submission-invalid' => 'Dữ liệu được gửi không đầy đủ hay không hợp lệ.',
	'review_page_invalid' => 'Tựa trang đích không hợp lệ.',
	'review_page_notexists' => 'Trang đích không tồn tại.',
	'review_page_unreviewable' => 'Các trang đích không duyệt được.',
	'review_no_oldid' => 'Không định rõ ID phiên bản.',
	'review_bad_oldid' => 'Phiên bản đích không tồn tại.',
	'review_conflict_oldid' => 'Người khác đã chấp nhận hoặc rút chấp nhận phiên bản này trong khi bạn đang xem nó.',
	'review_not_flagged' => 'Phiên bản đích hiện không được đánh dấu cần duyệt.',
	'review_too_low' => 'Không thể duyệt phiên bản có thuộc tính “kém”.',
	'review_bad_key' => 'Từ khóa tham số nhúng không hợp lệ.',
	'review_bad_tags' => 'Một số giá trị nhãn không hợp lệ.',
	'review_denied' => 'Không cho phép.',
	'review_param_missing' => 'Một tham số bị thiếu hoặc không hợp lệ.',
	'review_cannot_undo' => 'Không thể lùi lại những thay dổi này vì những thay đổi về sau ở cùng phần đang chờ được duyệt.',
	'review_cannot_reject' => 'Không có thể từ chối những thay đổi này vì ai đó đã chấp nhận một số (hoặc tất cả) các sửa đổi.',
	'review_reject_excessive' => 'Không thể từ chối nhiều sửa đổi này cùng một lúc.',
	'review_reject_nulledits' => 'Không thể từ chối những thay đổi này bởi vì các phiên bản này không khác nhau tí nào.',
	'revreview-check-flag-p' => 'Chấp nhận phiên bản này (bao gồm $1 thay đổi đang chờ duyệt)',
	'revreview-check-flag-p-title' => 'Chấp nhận tất cả những thay đổi đang chờ cùng với sửa đổi của bạn. Chỉ chọn cái này sau khi xem qua tất cả bản so sánh thay đổi đang chờ.',
	'revreview-check-flag-u' => 'Chấp nhận trang chưa duyệt này',
	'revreview-check-flag-u-title' => 'Chấp nhận phiên bản này của trang. Chỉ chọn khoản này sau khi đọc cả trang.',
	'revreview-check-flag-y' => 'Chấp nhận những thay đổi này',
	'revreview-check-flag-y-title' => 'Chấp nhận tất cả những thay đổi của bạn trong sửa đổi này.',
	'revreview-flag' => 'Duyệt phiên bản này',
	'revreview-reflag' => 'Duyệt lại phiên bản này',
	'revreview-invalid' => "'''Không hợp lệ:''' không có bản [[{{MediaWiki:Validationpage}}|đã duyệt]] tương ứng với ID được cung cấp.",
	'revreview-log' => 'Nhận xét:',
	'revreview-main' => 'Bạn phải chọn một phiên bản cụ thể từ một trang nội dung để duyệt.

Mời xem [[Special:Unreviewedpages|danh sách các trang chưa được duyệt]].',
	'revreview-stable1' => 'Bạn có thể muốn xem [{{fullurl:$1|stableid=$2}} phiên bản có cờ này] để xem nó mới có phải là [{{fullurl:$1|stable=1}} phiên bản ổn định] của trang này hay chưa.',
	'revreview-stable2' => 'Bạn có thể muốn xem [{{fullurl:$1|stable=1}} phiên bản ổn định] của trang này.',
	'revreview-submit' => 'Đăng bản duyệt',
	'revreview-submitting' => 'Đang gửi thông tin…',
	'revreview-submit-review' => 'Chấp nhận phiên bản',
	'revreview-submit-unreview' => 'Rút chấp nhận phiên bản',
	'revreview-submit-reject' => 'Từ chối các thay đổi',
	'revreview-submit-reviewed' => 'Chấp nhận xong.',
	'revreview-submit-unreviewed' => 'Rút lui xong.',
	'revreview-successful' => "'''Phiên bản của [[:$1|$1]] đã được gắn cờ. ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} xem các phiên bản có cờ])'''",
	'revreview-successful2' => "'''Phiên bản của [[:$1|$1]] đã được bỏ cờ thành công.'''",
	'revreview-poss-conflict-p' => "'''Cảnh báo: [[User:$1|$1]] đã bắt đầu duyệt trang này vào $2 lúc $3.'''",
	'revreview-poss-conflict-c' => "'''Cảnh báo: [[User:$1|$1]] đã bắt đầu duyệt các thay đổi này vào $2 lúc $3.'''",
	'revreview-adv-reviewing-p' => 'Chú ý: Những người duyệt bài khác có thể xem rằng bạn đang duyệt trang này.',
	'revreview-adv-reviewing-c' => 'Chú ý: Những người duyệt bài khác có thể xem rằng bạn đang duyệt các thay đổi này.',
	'revreview-sadv-reviewing-p' => 'Bạn có thể $1 cho người ta biết rằng bạn đang duyệt trang này.',
	'revreview-sadv-reviewing-c' => 'Bạn có thể $1 cho người ta biết rằng bạn đang duyệt các thay đổi này.',
	'revreview-adv-start-link' => 'báo',
	'revreview-adv-stop-link' => 'ngừng báo',
	'revreview-toolow' => "'''Mỗi thuộc tính cần phải cao hơn “kém” để cho phiên bản có thể được xem là được duyệt.'''

Để rút cờ được duyệt của một phiên bản, hãy bấm “Rút chấp nhận”.

Xin hãy bấm nút “Lùi” trong trình duyệt và thử lại.",
	'revreview-update' => "'''Xin hãy [[{{MediaWiki:Validationpage}}|duyệt]] những thay đổi đang chờ ''(dưới đây)'' đã được thực hiện từ khi phiên bản ổn định.'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">Các thay đổi của bạn chưa được đưa vào phiên bản ổn định.</span>

Xin hãy duyệt các thay đổi ở dưới để đưa các sửa đổi của bạn vào phiên bản ổn định.',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">Các thay đổi của bạn chưa được đưa vào phiên bản ổn định. Hiện có những thay đổi từ trước đang chờ được duyệt.</span>

Xin hãy duyệt các thay đổi ở dưới để đưa các sửa đổi của bạn vào phiên bản ổn định.',
	'revreview-update-includes' => 'Bản mẫu hay tập tin được cập nhật (các trang chưa duyệt được in đậm):',
	'revreview-reject-text-list' => "Bằng tác vụ này, bạn sẽ '''từ chối''' {{PLURAL:$1|thay đổi|những thay đổi}} văn bản tại [[:$2|$2]] sau:",
	'revreview-reject-text-revto' => 'Trang sẽ được quay về [{{fullurl:$1|oldid=$2}} phiên bản lúc $3].',
	'revreview-reject-summary' => 'Tóm lược:',
	'revreview-reject-confirm' => 'Từ chối những thay đổi này',
	'revreview-reject-cancel' => 'Hủy bỏ',
	'revreview-reject-summary-cur' => 'Đã từ chối {{PLURAL:$1|thay đổi|$1 thay đổi}} văn bản cuối cùng (của $2) quay về phiên bản $3 của $4',
	'revreview-reject-summary-old' => 'Đã từ chối {{PLURAL:$1|thay đổi|$1 thay đổi}} văn bản đầu tiên (của $2) tiếp theo phiên bản $3 của $4',
	'revreview-reject-summary-cur-short' => 'Đã từ chối {{PLURAL:$1|thay đổi|$1 thay đổi}} văn bản cuối cùng quay về phiên bản $2 của $3',
	'revreview-reject-summary-old-short' => 'Đã từ chối {{PLURAL:$1|thay đổi|$1 thay đổi}} văn bản đầu tiên tiếp theo phiên bản $2 của $3',
	'revreview-tt-flag' => 'Chấp nhận thay đổi này bằng cách đánh dấu nó là “đã xem qua”',
	'revreview-tt-unflag' => 'Rút chấp nhận phiên bản này bằng cách đánh dấu nó là “chưa xem qua”',
	'revreview-tt-reject' => 'Từ chối các thay đổi văn bản này bằng cách lùi lại chúng',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'revisionreview' => 'Logön krütamis',
	'revreview-flag' => 'Krütön fomami at',
	'revreview-log' => 'Küpet:',
	'revreview-main' => 'Mutol välön fomami semik pada ninädilabik ad krütön oni.

Logolös padi: [[Special:Unreviewedpages]], su kel dabinon lised padas no nog pekrütölas.',
	'revreview-submit' => 'Sedön',
	'revreview-update' => "[[{{MediaWiki:Validationpage}}|Reidolös e krütolös]] votükamis valik ''(dono pejonölis)'', kels pedunons sis fomam fümöfik [{{fullurl:{{#Special:Log}}|type=review&page={{FULLPAGENAMEE}}}} päzepon].

'''Samafomots e/u magods aniks pekoräkons:'''",
);

/** Yiddish (ייִדיש)
 * @author Imre
 * @author פוילישער
 */
$messages['yi'] = array(
	'revreview-log' => 'הערה:',
	'revreview-main' => 'איר מוזט אויסקלויבן א געוויסע ווערסיע פֿון אַן אינהאַלט בלאַט צו רעוויזירן.

זעט די  [[Special:Unreviewedpages|ליסטע פֿון אומרעוויזירטע בלעטער]].',
	'revreview-submit' => 'אײַנגעבן',
	'revreview-reject-summary' => 'רעזומע',
	'revreview-reject-cancel' => 'אַנולירן',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'revisionreview' => '複審修訂',
	'revreview-flag' => '複審呢次修訂',
	'revreview-invalid' => "'''無效嘅目標:''' 無[[{{MediaWiki:Validationpage}}|複審過]]嘅修訂跟仕已經畀咗嘅ID。",
	'revreview-log' => '記錄註解:',
	'revreview-main' => '你一定要響一版內容頁度揀一個個別嘅修訂去複審。

	睇[[Special:Unreviewedpages]]去拎未複審嘅版。',
	'revreview-stable1' => '你可能想去睇[{{fullurl:$1|stableid=$2}} 呢個加咗旗嘅版本]去睇呢一版而家係唔係[{{fullurl:$1|stable=1}} 穩定版]。',
	'revreview-stable2' => '你可能想去睇呢一版嘅[{{fullurl:$1|stable=1}} 穩定版] (如果嗰度仍然有一個嘅話)。',
	'revreview-submit' => '遞交',
	'revreview-successful' => "'''[[:$1|$1]]所選擇嘅修訂已經成功噉加旗。 ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} 去睇全部加旗版])'''",
	'revreview-successful2' => "'''[[:$1|$1]]所選擇嘅修訂已經成功噉減旗。'''",
	'revreview-toolow' => '你一定要最少將下面每一項嘅屬性評定高過"未批准"，去將一個修訂複審。
	要捨棄一個修訂，設定全部格做"未批准"。',
	'revreview-update' => '請複審自從響呢版嘅穩定版以來嘅任何更改 (響下面度顯示) 。模同圖亦可能同時更改。',
	'revreview-update-includes' => '有啲模/圖更新咗:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Chenxiaoqino
 * @author Gaoxuewei
 * @author Hydra
 * @author PhiLiP
 * @author Waihorace
 * @author 阿pp
 */
$messages['zh-hans'] = array(
	'revisionreview' => '复审修订',
	'revreview-failed' => "'''无法查看此修订。'''",
	'revreview-submission-invalid' => '提交的表单不完整或非法。',
	'review_page_invalid' => '目标页面名称无效。',
	'review_page_notexists' => '目标页面不存在。',
	'review_page_unreviewable' => '目标页面无法复审。',
	'review_no_oldid' => '没有指定修订ID。',
	'review_bad_oldid' => '目标修订不存在。',
	'review_conflict_oldid' => '在您审阅时，其他人已经接受或拒绝了该修订。',
	'review_not_flagged' => '目标修订当前未被标记为已复审。',
	'review_too_low' => '当部分字段为“不足”时无法将修订标记为已复审。',
	'review_bad_key' => '非法包含参数键。',
	'review_bad_tags' => '部分指定的标记值是无效的。',
	'review_denied' => '权限错误',
	'review_param_missing' => '参数丢失或无效。',
	'review_cannot_undo' => '无法撤消这些更改，因为有其他待复审的编辑修改了相同区域。',
	'review_cannot_reject' => '无法拒绝这些更改，因为其他人已经接受了一些（或所有）的编辑。',
	'review_reject_excessive' => '无法一次拒绝过多编辑。',
	'review_reject_nulledits' => '无法拒绝这些更改，因为所有修订都是空编辑。',
	'revreview-check-flag-p' => '接受此版本（包括$1个待复审的{{PLURAL:$1|更改|更改}}）',
	'revreview-check-flag-p-title' => '接受此页面的所有待复审更改以及你的更改。请只在完整审阅了所有复审更改差异后，才使用此功能。',
	'revreview-check-flag-u' => '接受此未复审页面',
	'revreview-check-flag-u-title' => '接受此页面的该版本。请只在审阅了整个页面后才使用此功能。',
	'revreview-check-flag-y' => '接受我的更改',
	'revreview-check-flag-y-title' => '接受你在此页面的所有更改',
	'revreview-flag' => '复审此修订',
	'revreview-reflag' => '重新复审此修订',
	'revreview-invalid' => "'''无效的目标：'''没有与指定ID对应的[[{{MediaWiki:Validationpage}}|已复审]]修订。",
	'revreview-log' => '注释：',
	'revreview-main' => '您必须选择内容页的特定修订以复审。

参见[[Special:Unreviewedpages|未复审页面列表]]。',
	'revreview-stable1' => '您可能想要查看[{{fullurl:$1|stableid=$2}} 此已标记的版本]，并检查现在是否已有该页面的[{{fullurl:$1|stable=1}} 稳定版本]。',
	'revreview-stable2' => '你可能想要查看该页面的[{{fullurl:$1|stable=1}} 稳定版本]。',
	'revreview-submit' => '提交',
	'revreview-submitting' => '提交中……',
	'revreview-submit-review' => '接受修订',
	'revreview-submit-unreview' => '不接受修订',
	'revreview-submit-reject' => '拒绝更改',
	'revreview-submit-reviewed' => '完成。接受！',
	'revreview-submit-unreviewed' => '完成。不接受！',
	'revreview-successful' => "'''已成功标记[[:$1|$1]]的修订。（[{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} 查看已复审版本]）'''",
	'revreview-successful2' => "'''已成功去掉[[:$1|$1]]修订的标记。'''",
	'revreview-poss-conflict-p' => "'''警告：[[User:$1|$1]]在$2$3时开始审阅此页面。'''",
	'revreview-poss-conflict-c' => "'''警告：[[User:$1|$1]]在$2$3时开始审阅这些更改。'''",
	'revreview-adv-reviewing-p' => '注意：其他复审员可以看到您正在审阅本页。',
	'revreview-adv-reviewing-c' => '注意：其他复审员可以看到您正在审阅这些更改。',
	'revreview-sadv-reviewing-p' => '您可以$1您正在审阅本页面。',
	'revreview-sadv-reviewing-c' => '您可以$1您正在审阅这些更改。',
	'revreview-adv-start-link' => '告知其他用户',
	'revreview-adv-stop-link' => '取消告知其他用户',
	'revreview-toolow' => "'''您必须将所有字段标记为“不足”以上才能将修订标记为已复审。'''

要去掉修订的复审状态，请点击“不接受”。

请点击您浏览器中的“后退”按钮后重试。",
	'revreview-update' => "'''请[[{{MediaWiki:Validationpage}}|复审]]自稳定版本后的所有待复审更改（如下所示）。'''",
	'revreview-update-edited' => '<span class="flaggedrevs_important">您的更改尚未成为稳定版本。</span>

请审阅如下所有更改，以使您的编辑出现在稳定版本中。',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">您的更改尚未成为稳定版本。还有更早的更改正在等待复审。</span>

请审阅如下所有更改，以使您的编辑出现在稳定版本中。',
	'revreview-update-includes' => '模板或文件已更新（未复审页面以粗体显示）：',
	'revreview-reject-text-list' => "完成此操作后，您将'''拒绝'''在[[:$2|$2]]的{{PLURAL:$1|修订|修订}}中对源文本的更改：",
	'revreview-reject-text-revto' => '此操作将把页面恢复到[{{fullurl:$1|oldid=$2}} $3时的版本]。',
	'revreview-reject-summary' => '摘要：',
	'revreview-reject-confirm' => '拒绝这些更改',
	'revreview-reject-cancel' => '取消',
	'revreview-reject-summary-cur' => '拒绝由$2作出的后{{PLURAL:$1|次文字更改|$1次文字更改}}，并由$4恢复到修订$3',
	'revreview-reject-summary-old' => '拒绝由$2作出的前{{PLURAL:$1|次文字更改|$1次文字更改}}，并由$4恢复到修订$3',
	'revreview-reject-summary-cur-short' => '拒绝后{{PLURAL:$1|次文字更改|$1次文字更改}}，并由$3恢复到修订$2',
	'revreview-reject-summary-old-short' => '拒绝前{{PLURAL:$1|次文字更改|$1次文字更改}}，并由$3恢复到修订$2',
	'revreview-tt-flag' => '接受该修订并将其标记为“已检查”',
	'revreview-tt-unflag' => '不接受该修订并将其标记为“未检查”',
	'revreview-tt-reject' => '拒绝这些对源文本的修改并撤消它们',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 * @author Liangent
 * @author Mark85296341
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'revisionreview' => '複審修訂',
	'revreview-failed' => "'''複審失敗。'''",
	'revreview-submission-invalid' => '提交不完整或因其他原因而無效。',
	'review_page_invalid' => '目標頁面名稱是無效的',
	'review_page_notexists' => '目標頁面不存在',
	'review_page_unreviewable' => '目標網頁無法複審。',
	'review_no_oldid' => '沒有指定修改 ID。',
	'review_bad_oldid' => '沒有這樣的目標修訂。',
	'review_conflict_oldid' => '在你閱讀本文的同時，有人已經接受或拒絕了本版本。',
	'review_not_flagged' => '該目標修訂目前沒有標記為已審查。',
	'review_too_low' => '修訂不能進行審查，因為部份內容是未經批准。',
	'review_bad_key' => '錯誤參數。',
	'review_bad_tags' => '部分指定的標記值是無效的。',
	'review_denied' => '權限錯誤',
	'review_param_missing' => '一個參數遺失或無效。',
	'review_cannot_undo' => '無法取消這些更改，因為在其他待審核的編輯對這些地方更改了。',
	'review_cannot_reject' => '由於有人已經接受部份或所有更改，因此無法拒絕。',
	'review_reject_excessive' => '不能一次拒絕過多編輯。',
	'review_reject_nulledits' => '這些更改無法拒絕，因為所有修訂都是空編輯。',
	'revreview-check-flag-p' => '接受此版本（包括$1個正在待審核的{{PLURAL:$1|編輯|編輯}}）',
	'revreview-check-flag-p-title' => '接受所有目前正等待審核的編輯 (包括自己的編輯)，只能在你已檢視差異的情況之下使用此項。',
	'revreview-check-flag-u' => '接受這個未經審查的頁面',
	'revreview-check-flag-u-title' => '接受這個版本的頁面。只有在你閱讀完整個頁面才應使用。',
	'revreview-check-flag-y' => '接受這些更改',
	'revreview-check-flag-y-title' => '接受你在此次編輯中的所有變化。',
	'revreview-flag' => '複審這次修訂',
	'revreview-reflag' => '重新複審這次修訂',
	'revreview-invalid' => "'''無效的目標：'''沒有 [[{{MediaWiki:Validationpage}}|審核]]修改對應於指定的ID。",
	'revreview-log' => '記錄註解:',
	'revreview-main' => '您一定要在一頁的內容頁中選擇一個個別的修訂去複審。

	參看[[Special:Unreviewedpages]]去擷取未複審的頁面。',
	'revreview-stable1' => '您可能要查看[{{fullurl:$1|stableid=$2}} 此標記的版本]，看看是否現在此頁的[{{fullurl:$1|stable=1}} 穩定版本]。',
	'revreview-stable2' => '你可能想使用本頁的[{{fullurl:$1|stable=1}} 已審核版本]。',
	'revreview-submit' => '遞交',
	'revreview-submitting' => '正在提交…',
	'revreview-submit-review' => '接受修訂',
	'revreview-submit-unreview' => '拒絕修訂',
	'revreview-submit-reject' => '拒絕更改',
	'revreview-submit-reviewed' => '完成。批准！',
	'revreview-submit-unreviewed' => '完成。已取消批准！',
	'revreview-successful' => "'''[[:$1|$1]]的指定版本已被標記。 ([{{fullurl:{{#Special:ReviewedVersions}}|page=$2}} 檢視已審核版本])'''",
	'revreview-successful2' => "'''[[:$1|$1]]的指定版本已成功移除標記。'''",
	'revreview-poss-conflict-p' => "'''警告：[[User:$1|$1]]在$2$3時開始審閱此頁面。 '''",
	'revreview-poss-conflict-c' => "'''警告：[[User:$1|$1]]在$2$3時開始審閱這些更改。 '''",
	'revreview-adv-reviewing-p' => '注意：其他複審員可以看到您正在審閱本頁。',
	'revreview-adv-reviewing-c' => '注意：其他複審員可以看到您正在審閱這些更改。',
	'revreview-sadv-reviewing-p' => '您可以$1您正在審閱本頁面。',
	'revreview-sadv-reviewing-c' => '您可以$1您正在審閱這些更改。',
	'revreview-adv-start-link' => '告知其他用戶',
	'revreview-adv-stop-link' => '取消告知其他用戶',
	'revreview-toolow' => '您一定要最少將下面每一項的屬性評定高於「不足」，才可將一個修訂設定為已複審。

要捨棄一個修訂，請點選「拒絕」。

請在您的瀏覽器點擊「返回」按鈕，然後再試一次。',
	'revreview-update' => "請[[{{MediaWiki:Validationpage}}|複審]]自從於這頁的穩定版以來的任何更改''（在下面顯示）''。",
	'revreview-update-edited' => '<span class="flaggedrevs_important">所做的更改不是尚未是穩定版本。</span>

请檢查下面所列示的所有改變，以令到你的編輯在穩定頁面中出現。',
	'revreview-update-edited-prev' => '<span class="flaggedrevs_important">您的變更尚未發佈。在你的編輯之前還有未審核的版本。</span>

請檢查以下所有的修訂，以令你的編輯出現在穩定版本中。',
	'revreview-update-includes' => '模板或文件已更新（未復審頁面以粗體顯示）：',
	'revreview-reject-text-list' => "完成此操作後，您將'''拒絕'''在[[:$2|$2]]的{{PLURAL:$1|修訂|修訂}}中對源文本的更改：",
	'revreview-reject-text-revto' => '這將恢復頁面回[{{fullurl:$1|oldid=$2}} $3的版本]。',
	'revreview-reject-summary' => '摘要：',
	'revreview-reject-confirm' => '拒絕這些更改',
	'revreview-reject-cancel' => '取消',
	'revreview-reject-summary-cur' => '拒絕由$2作出的後{{PLURAL:$1|次文字更改|$1次文字更改}}，並由$4恢復到修訂$3',
	'revreview-reject-summary-old' => '拒絕由$2作出的前{{PLURAL:$1|次文字更改|$1次文字更改}}，並由$4恢復到修訂$3',
	'revreview-reject-summary-cur-short' => '拒絕後{{PLURAL:$1|次文字更改|$1次文字更改}}，並由$3恢復到修訂$2',
	'revreview-reject-summary-old-short' => '拒絕前{{PLURAL:$1|次文字更改|$1次文字更改}}，並由$3恢復到修訂$2',
	'revreview-tt-flag' => '透過這項修訂通過標記它作為已審核',
	'revreview-tt-unflag' => '將這個修訂標記為「未檢查」以取消批准這一修正。',
	'revreview-tt-reject' => '拒絕這些對源文本的修改並撤消它們',
);

