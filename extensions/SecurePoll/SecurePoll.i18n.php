<?php
/**
 * Internationalisation file for SecurePoll extension.
 *
 * @file
 * @ingroup Extensions
*/

$messages = array();

/** English
 * @author Tim Starling
 */
$messages['en'] = array(
	# Top-level
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Extension for elections and surveys',
	'securepoll-invalid-page' => 'Invalid subpage "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'You need to be an election administrator to perform this action.',
	
	# Vote (most important to translate)
	'securepoll-too-few-params' => 'Not enough subpage parameters (invalid link).',
	'securepoll-invalid-election' => '"$1" is not a valid election ID.',
	'securepoll-welcome' => '<strong>Welcome $1!</strong>',
	'securepoll-not-started' => 'This election has not yet started.
It is scheduled to start on $2 at $3.',
	'securepoll-finished' => 'This election has finished, you can no longer vote.',
	'securepoll-not-qualified' => 'You are not qualified to vote in this election: $1',
	'securepoll-change-disallowed' => 'You have voted in this election before.
Sorry, you may not vote again.',
	'securepoll-change-allowed' => '<strong>Note: You have voted in this election before.</strong>
You may change your vote by submitting the form below.
Note that if you do this, your original vote will be discarded.',
	'securepoll-submit' => 'Submit vote',
	'securepoll-gpg-receipt' => 'Thank you for voting.

If you wish, you may retain the following receipt as evidence of your vote:

<pre>$1</pre>',
	'securepoll-thanks' => 'Thank you, your vote has been recorded.',
	'securepoll-return' => 'Return to $1',
	'securepoll-encrypt-error' => 'Failed to encrypt your vote record.
Your vote has not been recorded!

$1',
	'securepoll-no-gpg-home' => 'Unable to create GPG home directory.',
	'securepoll-secret-gpg-error' => 'Error executing GPG.
Use $wgSecurePollShowErrorDetail=true; in LocalSettings.php to show more detail.',
'securepoll-full-gpg-error' => 'Error executing GPG:

Command: $1

Error:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG keys are configured incorrectly.',
	'securepoll-gpg-parse-error' => 'Error interpreting GPG output.',
	'securepoll-no-decryption-key' => 'No decryption key is configured.
Cannot decrypt.',
	'securepoll-jump' => 'Go to the voting server',
	'securepoll-bad-ballot-submission' => 'Your vote was invalid: $1',
	'securepoll-unanswered-questions' => 'You must answer all questions.',
	'securepoll-invalid-rank' => 'Invalid rank. You must give candidates a rank between 1 and 999.',
	'securepoll-unranked-options' => 'Some options were not ranked.
You must give all options a rank between 1 and 999.',
	'securepoll-invalid-score' => 'The score must be a number between $1 and $2.',
	'securepoll-unanswered-options' => 'You must give a response for every question.',

	# Authorisation related
	'securepoll-remote-auth-error' => 'Error fetching your account information from the server.',
	'securepoll-remote-parse-error' => 'Error interpreting the authorisation response from the server.',
	
	'securepoll-api-invalid-params' => 'Invalid parameters.',
	'securepoll-api-no-user' => 'No user was found with the given ID.',
	'securepoll-api-token-mismatch' => 'Security token mismatch, cannot log in.',
	'securepoll-not-logged-in' => 'You must log in to vote in this election',
	'securepoll-too-few-edits' => 'Sorry, you cannot vote. You need to have made at least $1 {{PLURAL:$1|edit|edits}} to vote in this election, you have made $2.',
	'securepoll-blocked' => 'Sorry, you cannot vote in this election if you are currently blocked from editing.',
	'securepoll-bot' => 'Sorry, accounts with the bot flag are not allowed to vote in this election.',
	'securepoll-not-in-group' => 'Only members of the "$1" group can vote in this election.',
	'securepoll-not-in-list' => 'Sorry, you are not in the predetermined list of users authorised to vote in this election.',
	'securepoll-custom-unqualified' => '$1',

	# List page
	# Mostly for admins
	'securepoll-list-title' => 'List votes: $1',
	'securepoll-header-timestamp' => 'Time',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domain',
	'securepoll-header-ip' => 'IP',
	'securepoll-header-xff' => 'XFF',
	'securepoll-header-ua' => 'User agent',
	'securepoll-header-token-match' => 'CSRF',
	'securepoll-header-cookie-dup' => 'Dup', # Duplicate user with same session
	'securepoll-header-strike' => 'Strike',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Strike',
	'securepoll-unstrike-button' => 'Unstrike',
	'securepoll-strike-reason' => 'Reason:',
	'securepoll-strike-cancel' => 'Cancel',
	'securepoll-strike-error' => 'Error performing strike/unstrike: $1',
	'securepoll-strike-token-mismatch' => 'Session data lost',
	'securepoll-details-link' => 'Details',
	'securepoll-voter-name-local' => '[[User:$1|$1]]',
	'securepoll-voter-name-remote' => '$1',

	# Details page
	# Mostly for admins
	'securepoll-details-title' => 'Vote details: #$1',
	'securepoll-invalid-vote' => '"$1" is not a valid vote ID',
	'securepoll-header-id' => 'ID',
	'securepoll-header-voter-type' => 'Voter type',
	'securepoll-header-url' => 'URL',
	'securepoll-voter-properties' => 'Voter properties',
	'securepoll-strike-log' => 'Strike log',
	'securepoll-header-action' => 'Action',
	'securepoll-header-reason' => 'Reason',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Cookie duplicate users',

	# Dump page
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'No encrypted election record is available for this election, because the election is not configured to use encryption.',
	'securepoll-dump-not-finished' => 'Encrypted election records are only available after the finish date on $1 at $2',
	'securepoll-dump-no-urandom' => 'Cannot open /dev/urandom. 
To maintain voter privacy, encrypted election records are only publically available when they can be shuffled with a secure random number stream.',
	'securepoll-urandom-not-supported' => 'This server does not support cryptographic random number generation.
To maintain voter privacy, encrypted election records are only publically available when they can be shuffled with a secure random number stream.',

	# Translate page
	'securepoll-translate-title' => 'Translate: $1',
	'securepoll-invalid-language' => 'Invalid language code "$1"',
	'securepoll-header-trans-id' => 'ID',
	'securepoll-submit-translate' => 'Update',
	'securepoll-language-label' => 'Select language:',
	'securepoll-submit-select-lang' => 'Translate',

	# Entry page
	'securepoll-entry-text' => 'Below is the list of polls.',
	'securepoll-header-title' => 'Name',
	'securepoll-header-start-date' => 'Start date',
	'securepoll-header-end-date' => 'End date',
	'securepoll-subpage-vote' => 'Vote',
	'securepoll-subpage-translate' => 'Translate',
	'securepoll-subpage-list' => 'List',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Tally',

	# Tally page (admin-only)
	'securepoll-tally-title' => 'Tally: $1',
	'securepoll-tally-not-finished' => 'Sorry, you cannot tally the election until after voting is complete.',
	'securepoll-can-decrypt' => 'The election record has been encrypted, but the decryption key is available. 
	You can choose to either tally the results present in the database, or to tally encrypted results from an uploaded file.',
	'securepoll-tally-no-key' => 'You cannot tally this election, because the votes are encrypted, and the decryption key is not available.',
	'securepoll-tally-local-legend' => 'Tally stored results',
	'securepoll-tally-local-submit' => 'Create tally',
	'securepoll-tally-upload-legend' => 'Upload encrypted dump',
	'securepoll-tally-upload-submit' => 'Create tally',
	'securepoll-tally-error' => 'Error interpreting vote record, cannot produce a tally.',
	'securepoll-no-upload' => 'No file was uploaded, cannot tally results.',
	'securepoll-dump-corrupt' => 'The dump file is corrupt and cannot be processed.',
	'securepoll-tally-upload-error' => 'Error tallying dump file: $1',
	'securepoll-pairwise-victories' => 'Pairwise victory matrix',
	'securepoll-strength-matrix' => 'Path strength matrix',
	'securepoll-ranks' => 'Final ranking',
	'securepoll-average-score' => 'Average score',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author IAlex
 * @author Kiranmayee
 * @author Kwj2772
 * @author Lloffiwr
 * @author Mormegil
 * @author Purodha
 * @author Raymond
 * @author Saper
 * @author Siebrand
 */
$messages['qqq'] = array(
	'securepoll-desc' => '{{desc}}',
	'securepoll-not-started' => '* $2 is the date of it
* $3 is its time.',
	'securepoll-submit' => '{{Identical|Submit}}',
	'securepoll-return' => '{{Identical|Return to $1}}',
	'securepoll-no-gpg-home' => 'GPG stands for [http://en.wikipedia.org/wiki/GNU_Privacy_Guard GNU Privacy Guard].',
	'securepoll-secret-gpg-error' => "<span style=\"color:red\">'''DO <u>NOT</u> translate LocalSettings.php and \$wgSecurePollShowErrorDetail=true;'''</span>

GPG stands for [http://en.wikipedia.org/wiki/GNU_Privacy_Guard GNU Privacy Guard].",
	'securepoll-full-gpg-error' => 'GPG stands for [http://en.wikipedia.org/wiki/GNU_Privacy_Guard GNU Privacy Guard].',
	'securepoll-gpg-config-error' => 'GPG stands for [http://en.wikipedia.org/wiki/GNU_Privacy_Guard GNU Privacy Guard].',
	'securepoll-gpg-parse-error' => 'GPG stands for [http://en.wikipedia.org/wiki/GNU_Privacy_Guard GNU Privacy Guard].',
	'securepoll-header-timestamp' => '{{Identical|Time}}',
	'securepoll-header-voter-name' => '{{Identical|Name}}',
	'securepoll-header-ip' => '{{optional}}',
	'securepoll-header-xff' => '{{optional}}',
	'securepoll-header-token-match' => '{{optional}}',
	'securepoll-header-cookie-dup' => 'Column caption above the table of voters shown at [[Special:SecurePoll/list/1]]. The column displays whether the vote is a duplicate (detected by a cookie). See also {{msg-mw|securepoll-cookie-dup-list}}. This translation should be as short as possible (an abbreviation for "duplicate").',
	'securepoll-header-strike' => '{{Identical|Strike}}

"Strike" here means to strikout a vote (slash it) so as to mark is as not being counted. E.g. a user voted a second time; a user was not elegible for voting because of an insufficient edit count; a known sockpuppet was used, and the puppetmaster also voted; a bot user vote, etc.',
	'securepoll-header-details' => '{{Identical|Details}}',
	'securepoll-strike-button' => '{{Identical|Strike}}',
	'securepoll-unstrike-button' => '{{Identical|Unstrike}}',
	'securepoll-strike-reason' => '{{Identical|Reason}}',
	'securepoll-strike-cancel' => '{{Identical|Cancel}}',
	'securepoll-details-link' => '{{Identical|Details}}',
	'securepoll-details-title' => '$1 identifies a single vote of a single voter.',
	'securepoll-invalid-vote' => 'The vote ID identifies a specific voting process.',
	'securepoll-header-id' => '{{optional}}',
	'securepoll-header-url' => '{{optional}}',
	'securepoll-header-action' => '{{Identical|Action}}',
	'securepoll-header-reason' => '{{Identical|Reason}}',
	'securepoll-cookie-dup-list' => 'Header of a list on [[Special:SecurePoll/details/1]]. The list shows duplicate voters detected by having a cookie from the first voting.',
	'securepoll-dump-not-finished' => '* $1 is the date
* $2 is the time',
	'securepoll-dump-no-urandom' => 'Do not translate "/dev/urandom".

Servers running Microsoft Windows will present [[MediaWiki:Securepoll-urandom-not-supported/en|Securepoll-urandom-not-supported]] instead.',
	'securepoll-urandom-not-supported' => "As to the meaning of ''cryptographic random number'', see [[:wikipedia:Cryptographically secure pseudorandom number generator]] for reference.

The /dev/urandom cryptographic random number generation device is not supported on servers running Microsoft Windows. On other platforms the [[MediaWiki:Securepoll-dump-no-urandom/en|Securepoll-dump-no-urandom]] message is generated if opening of the /dev/urandom device fails.",
	'securepoll-translate-title' => '{{Identical|Translate}}',
	'securepoll-header-trans-id' => '{{optional}}',
	'securepoll-submit-translate' => '{{Identical|Update}}',
	'securepoll-submit-select-lang' => '{{Identical|Translate}}',
	'securepoll-header-title' => '{{Identical|Name}}',
	'securepoll-header-start-date' => '{{Identical|Start date}}',
	'securepoll-header-end-date' => '{{Identical|End date}}',
	'securepoll-subpage-vote' => '{{Identical|Vote}}',
	'securepoll-subpage-translate' => '{{Identical|Translate}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'securepoll' => 'VeiligStem',
	'securepoll-desc' => 'Uitbreiding vir stemmings en opnames',
	'securepoll-invalid-page' => 'Ongeldige subbladsy "<nowiki>$1</nowiki>"',
	'securepoll-invalid-election' => '"$1" is nie \'n geldig ID vir \'n stemmig nie.',
	'securepoll-welcome' => '<strong>Welkom, $1!</strong>',
	'securepoll-finished' => 'Hierdie stemming is afgehandel, u kan nie meer stem nie.',
	'securepoll-submit' => 'Dien stem in',
	'securepoll-gpg-receipt' => 'Baie dankie vir u stem.

As u wil, kan u kan die volgende kwitansie as bewys hou:

<pre>$1</pre>',
	'securepoll-thanks' => 'Dankie, u stem is ontvang en vasgelê.',
	'securepoll-return' => 'Keer terug na $1',
	'securepoll-no-gpg-home' => 'Nie in staat om GPG-tuisgids te skep nie.',
	'securepoll-full-gpg-error' => 'Fout met die uitvoer van GPG:

Bevel: $1

Fout: <pre>$2</pre>',
	'securepoll-jump' => 'Gaan na die stemming-bediener',
	'securepoll-bad-ballot-submission' => 'U stem is ongeldig: $1',
	'securepoll-unanswered-questions' => 'U moet alle vrae beantwoord.',
	'securepoll-invalid-score' => "Die telling moet 'n getal tussen $1 en $2 wees.",
	'securepoll-unanswered-options' => 'U moet al die vrae beantwoord.',
	'securepoll-remote-auth-error' => "'n Fout het voorgekom met die opkyk van u rekening se inligting vanaf die bediener.",
	'securepoll-api-invalid-params' => 'Ongeldige parameters.',
	'securepoll-api-no-user' => 'Geen gebruiker met die gegewe ID gevind nie.',
	'securepoll-bot' => "Jammer, gebruikers met 'n botvlag word nie toegelaat om aan die stemming deel te neem nie.",
	'securepoll-not-in-group' => 'Slegs lede van die groep "$1" kan aan hierdie stemming deelneem.',
	'securepoll-list-title' => 'Wys stemme: $1',
	'securepoll-header-timestamp' => 'Tyd',
	'securepoll-header-voter-name' => 'Naam',
	'securepoll-header-voter-domain' => 'Domein',
	'securepoll-header-ua' => 'Gebruikers-agent',
	'securepoll-header-cookie-dup' => 'Duplikaat',
	'securepoll-header-strike' => 'Trek dood',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Trek dood',
	'securepoll-unstrike-button' => 'Maak doodtrek ongedaan',
	'securepoll-strike-reason' => 'Rede',
	'securepoll-strike-cancel' => 'Kanselleer',
	'securepoll-strike-token-mismatch' => 'Sessie-data het verlore gegaan',
	'securepoll-details-link' => 'Details',
	'securepoll-details-title' => 'Stemdetails: #$1',
	'securepoll-invalid-vote' => '"$1" is nie \'n geldig stem-ID nie',
	'securepoll-header-voter-type' => 'Gebruikerstipe',
	'securepoll-voter-properties' => 'Kieserseienskappe',
	'securepoll-strike-log' => 'Logboek van doodgetrekte stemme',
	'securepoll-header-action' => 'Handeling',
	'securepoll-header-reason' => 'Rede',
	'securepoll-header-admin' => 'Beheer',
	'securepoll-cookie-dup-list' => 'Gebruikers met duplikaat koekies',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-translate-title' => 'Vertaal: $1',
	'securepoll-invalid-language' => 'Ongeldige taalkode "$1"',
	'securepoll-submit-translate' => 'Opdateer',
	'securepoll-language-label' => 'Kies taal:',
	'securepoll-submit-select-lang' => 'Vertaal',
	'securepoll-entry-text' => 'Hieronder is die lys van stemmings.',
	'securepoll-header-title' => 'Naam',
	'securepoll-header-start-date' => 'Begindatum',
	'securepoll-header-end-date' => 'Einddatum',
	'securepoll-subpage-vote' => 'Stem',
	'securepoll-subpage-translate' => 'Vertaal',
	'securepoll-subpage-list' => 'Lys',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Telling',
	'securepoll-tally-title' => 'Telling: $1',
	'securepoll-tally-local-submit' => 'Skep telling',
	'securepoll-tally-upload-submit' => 'Skep telling',
	'securepoll-no-upload' => 'Geen lêer is opgelaai nie.
Die resultate kan nie getel word nie.',
	'securepoll-ranks' => 'Eindstand',
	'securepoll-average-score' => 'Gemiddelde punt',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Orango
 * @author OsamaK
 * @author Shipmaster
 */
$messages['ar'] = array(
	'securepoll' => 'استطلاع رأي آمن',
	'securepoll-desc' => 'امتداد لأجل الانتخابات و استطلاعات الرأي',
	'securepoll-invalid-page' => 'صفحة فرعية غير صحيحة "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'يجب أن تكون إداري انتخابات للقيام بهذا الفعل.',
	'securepoll-too-few-params' => 'قيم وسيطة صفحة فرعية غير كافية (وصلة غير صحيحة).',
	'securepoll-invalid-election' => '"$1" ليس رمز تعريف انتخابات صحيح.',
	'securepoll-welcome' => '<strong>مرحبا $1!</strong>',
	'securepoll-not-started' => 'هذه الانتخابات لم تبدأ بعد.
من المقرر لها ان تبدأ في  $2 ب $3.',
	'securepoll-finished' => 'انتهت هذه الانتخابات، لم تعد قادرا على التصويت.',
	'securepoll-not-qualified' => 'أنت غير مؤهل للتصويت في هذه الانتخابات: $1',
	'securepoll-change-disallowed' => 'لقد قمت بالتصويت في هذه الانتخابات من قبل.
عذرا، لا يمكنك التصويت مرة أخرى.',
	'securepoll-change-allowed' => '<strong>ملاحظة: لقد قمت بالتصويت في هذه الانتخابات من قبل</strong>
يمكنك تغيير صوتك باستخدام النموذج بالأسفل.
لاحظ انه اذا قمت بذلك، سيتم اهمال تصويتك السابق.',
	'securepoll-submit' => 'قدم صوتك',
	'securepoll-gpg-receipt' => 'شكرا لتصويتك

لو اردت، يمكنك الاحتفاظ بالايصال التالي كدليل على تصويتك:

<pre>$1</pre>',
	'securepoll-thanks' => 'شكرا لك، تم تسجيل تصويتك.',
	'securepoll-return' => 'ارجع الي $1',
	'securepoll-encrypt-error' => 'قد فشل تشفير سجل تصويتك.
تصويتك لم يتم تسجيله!

$1',
	'securepoll-no-gpg-home' => 'لم يمكن خلق دليل الموطن ل GPG.',
	'securepoll-secret-gpg-error' => 'خطأ أثناء تشغيل GPG.
قم باستخدام $wgSecurePollShowErrorDetail=true; في LocalSettings.php لاظهار المزيد من التفاصيل.',
	'securepoll-full-gpg-error' => 'خطأ أثناء تشغيل GPG:

الأمر: $1

الخطأ:

<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'مفاتيح GPG مهيئة بشكل غير صحيح.',
	'securepoll-gpg-parse-error' => 'خطأ بتفسير نتيجة GPG .',
	'securepoll-no-decryption-key' => 'لا توجد مفاتيح فك تعمية مهيئة.
لا يمكن فك التعمية.',
	'securepoll-jump' => 'اذهب إلى خادم التصويت',
	'securepoll-bad-ballot-submission' => 'تصويتك ليس صحيحا: $1',
	'securepoll-unanswered-questions' => 'يجب أن تجيب على كل الأسئلة.',
	'securepoll-invalid-rank' => 'رتبة غير مقبولة. يجب أن تعطي المرشحين رتبة بين 1 و 999.',
	'securepoll-unranked-options' => 'لم يتم اعطاء رتبة لبعض الخيارات.
يجب أن تعطي كل الخيارات رتبة ما بين 1 و 999.',
	'securepoll-invalid-score' => 'الناتج يجب أن يكون عددا بين $1 و $2.',
	'securepoll-unanswered-options' => 'يجب أن تعطي ردا لكل سؤال.',
	'securepoll-remote-auth-error' => 'خطأ عند جلب معلومات حسابك من الخادوم.',
	'securepoll-remote-parse-error' => 'خطأ عند تفسير رد التصريح من الخادوم.',
	'securepoll-api-invalid-params' => 'محددات غير صحيحة.',
	'securepoll-api-no-user' => 'لم يوجد أي مستخدم بالهوية المعطاة.',
	'securepoll-api-token-mismatch' => 'نص الأمان لا يطابق، لا يمكن تسجيل الدخول.',
	'securepoll-not-logged-in' => 'يجب أن تدخل لتصوت في هذه الانتخابات',
	'securepoll-too-few-edits' => 'عذرا لا يمكنك التصويت. يجب أن تقوم ب{{PLURAL:$1||تعديل واحد|تعديلين|$1 تعديلات|$1 تعديلًا|$1 تعديل}} على الأقل لتصوت في هذه الانتخابات، بينما قمت ب$2.',
	'securepoll-blocked' => 'عذرا، لا تستطيع التصويت في هذه الانتخابات إذا كنت ممنوعا حاليا من التعديل.',
	'securepoll-bot' => 'عذرا، الحسابات ذات أعلام البوت غير مسموح لها بالتصويت في هذه الانتخابات.',
	'securepoll-not-in-group' => 'فقط المستخدمين من المجموعة "$1" يمكنهم التصويت في هذه الانتخابات.',
	'securepoll-not-in-list' => 'عذرا، لست في القائمة المُعدّة للمستخدمين المصرح لهم بالتصويت في هذه الانتخابات.',
	'securepoll-list-title' => 'قائمة التصويتات: $1',
	'securepoll-header-timestamp' => 'الوقت',
	'securepoll-header-voter-name' => 'الاسم',
	'securepoll-header-voter-domain' => 'النطاق',
	'securepoll-header-ip' => 'أيبي',
	'securepoll-header-xff' => 'إكس إف إف',
	'securepoll-header-ua' => 'وكيل المستخدم',
	'securepoll-header-token-match' => 'سي إس آر إف',
	'securepoll-header-cookie-dup' => 'مزدوج',
	'securepoll-header-strike' => 'اشطب',
	'securepoll-header-details' => 'التفاصيل',
	'securepoll-strike-button' => 'اشطب',
	'securepoll-unstrike-button' => 'الغاء الشطب',
	'securepoll-strike-reason' => 'السبب:',
	'securepoll-strike-cancel' => 'ألغِ',
	'securepoll-strike-error' => 'خطأ اثناء القيام بالشطب/الغاء الشطب: $1',
	'securepoll-strike-token-mismatch' => 'فقدت بيانات الجلسة',
	'securepoll-details-link' => 'التفاصيل',
	'securepoll-details-title' => 'تفاصيل التصويت: #$1',
	'securepoll-invalid-vote' => '"$1" ليس رمز تعريف تصويت صحيح.',
	'securepoll-header-id' => 'رقم',
	'securepoll-header-voter-type' => 'نوع المستخدم',
	'securepoll-header-url' => 'مسار',
	'securepoll-voter-properties' => 'خصائص التصويت',
	'securepoll-strike-log' => 'سجل الشطب',
	'securepoll-header-action' => 'الاجراء',
	'securepoll-header-reason' => 'السبب',
	'securepoll-header-admin' => 'الادارة',
	'securepoll-cookie-dup-list' => 'المستخدمون مزدوجو الكوكي',
	'securepoll-dump-title' => 'النتيجة: $1',
	'securepoll-dump-no-crypt' => 'لا يوجد سجل انتخابات مشفر متاح لهذه الانتخابات، بسبب ان الانتخابات غير مهيئة لاستخدام التشفير.',
	'securepoll-dump-not-finished' => 'سجلات الانتخابات المشفرة متاحة فقط بعد تاريخ الانتهاء في $1 ب $2',
	'securepoll-dump-no-urandom' => 'لا يمكن فتح /dev/urandom.
للحفاظ على خصوصية المصوتين، سجلات الانتخابات المشفرة تتاح على الملأ عندما يمكن خلطهم عن طريق سيل ارقام عشوائية آمن.',
	'securepoll-urandom-not-supported' => 'هذا الخادم لا يدعم توليد أرقام عن طريق الترميز العشوائي.
للحفاظ على خصوصية الناخبين ، سجلات الانتخابات المشفرة ليست متاحة علانية الا عندما يمكن خلطهم عن طريق دفق رقمي عشوائي آمن  .',
	'securepoll-translate-title' => 'ترجم: $1',
	'securepoll-invalid-language' => 'كود لغة غير صحيح "$1"',
	'securepoll-header-trans-id' => 'رقم',
	'securepoll-submit-translate' => 'تحديث',
	'securepoll-language-label' => 'اختر اللغة:',
	'securepoll-submit-select-lang' => 'ترجم',
	'securepoll-entry-text' => 'بالأسفل قائمة بالاقتراعات.',
	'securepoll-header-title' => 'اسم',
	'securepoll-header-start-date' => 'تاريخ البدء',
	'securepoll-header-end-date' => 'تاريخ الانتهاء',
	'securepoll-subpage-vote' => 'صوت',
	'securepoll-subpage-translate' => 'ترجم',
	'securepoll-subpage-list' => 'قائمة',
	'securepoll-subpage-dump' => 'تخزين',
	'securepoll-subpage-tally' => 'المحصلة',
	'securepoll-tally-title' => 'المحصلة: $1',
	'securepoll-tally-not-finished' => 'عذرا، لن تستطيع تحصيل الانتخابات حتى يكتمل التصويت.',
	'securepoll-can-decrypt' => 'لقد عُمّي سجل الانتخابات، لكن مفتاح فك التعمية متوفر.
تستطيع الاختيار بين تحصيل الانتخابات في  قاعدة البيانات مباشرة، أو تحصيل نتائج معماة من ملفٍ مرفوع.',
	'securepoll-tally-no-key' => 'لا تستطيع تحصيل هذه الانتخابات، لأن التصويتات مُعمّاة، ومفتاح فك التعمية غير متوفر.',
	'securepoll-tally-local-legend' => 'محصلة النتائج المخزنة',
	'securepoll-tally-local-submit' => 'أنشئ محصلة',
	'securepoll-tally-upload-legend' => 'رفع خزين مشفر',
	'securepoll-tally-upload-submit' => 'أنشئ محصلة',
	'securepoll-tally-error' => 'خطأ في تفسير سجل التصويت، تعذّر توليد محصلة.',
	'securepoll-no-upload' => 'لم يرفع ملف، تعذّر تحصيل النتائج.',
	'securepoll-dump-corrupt' => 'ملف التفريغ تالف و لا يمكن معالجته.',
	'securepoll-tally-upload-error' => 'خطأ أثناء فرز ملف التفريغ: $1',
	'securepoll-pairwise-victories' => 'مصفوفة انتصار الثنائيات',
	'securepoll-strength-matrix' => 'مصفوفة قوة المسار',
	'securepoll-ranks' => 'الترتيب النهائي',
	'securepoll-average-score' => 'نتيجة متوسطة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'securepoll-strike-reason' => 'ܥܠܬܐ:',
	'securepoll-strike-cancel' => 'ܒܛܘܠ',
	'securepoll-header-reason' => 'ܥܠܬܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'securepoll' => 'استطلاع رأى آمن',
	'securepoll-desc' => 'امتداد لأجل الانتخابات و استطلاعات الرأي',
	'securepoll-invalid-page' => 'صفحه فرعيه غير صحيحه "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'يجب أن تكون إدارى انتخابات للقيام بهذا الفعل.',
	'securepoll-too-few-params' => 'قيم وسيطه صفحه فرعيه غير كافيه (وصله غير صحيحة).',
	'securepoll-invalid-election' => '"$1" ليس رمز تعريف انتخابات صحيح.',
	'securepoll-welcome' => '<strong>مرحبا $1!</strong>',
	'securepoll-not-started' => 'هذه الانتخابات لم تبدأ بعد.
من المقرر لها ان تبدأ فى  $2 ب $3.',
	'securepoll-finished' => 'انتهت هذه الانتخابات، لم تعد قادرا على التصويت.',
	'securepoll-not-qualified' => 'أنت غير مؤهل للتصويت فى هذه الانتخابات: $1',
	'securepoll-change-disallowed' => 'لقد قمت بالتصويت فى هذه الانتخابات من قبل.
عذرا، لا يمكنك التصويت مره أخرى.',
	'securepoll-change-allowed' => '<strong>ملاحظة: لقد قمت بالتصويت فى هذه الانتخابات من قبل</strong>
يمكنك تغيير صوتك باستخدام النموذج بالأسفل.
لاحظ انه اذا قمت بذلك، سيتم اهمال تصويتك السابق.',
	'securepoll-submit' => 'قدم صوتك',
	'securepoll-gpg-receipt' => 'شكرا لتصويتك

لو اردت، يمكنك الاحتفاظ بالايصال التالى كدليل على تصويتك:

<pre>$1</pre>',
	'securepoll-thanks' => 'شكرا لك، تم تسجيل تصويتك.',
	'securepoll-return' => 'ارجع الى $1',
	'securepoll-encrypt-error' => 'قد فشل تشفير سجل تصويتك.
تصويتك لم يتم تسجيله!

$1',
	'securepoll-no-gpg-home' => 'لم يمكن خلق دليل الموطن ل GPG.',
	'securepoll-secret-gpg-error' => 'خطأ أثناء تشغيل GPG.
قم باستخدام $wgSecurePollShowErrorDetail=true; فى LocalSettings.php لاظهار المزيد من التفاصيل.',
	'securepoll-full-gpg-error' => 'خطأ أثناء تشغيل GPG:

الأمر: $1

الخطأ:

<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'مفاتيح GPG مهيئه بشكل غير صحيح.',
	'securepoll-gpg-parse-error' => 'خطأ بتفسير نتيجه GPG .',
	'securepoll-no-decryption-key' => 'لا توجد مفاتيح فك تعميه مهيئه.
لا يمكن فك التعميه.',
	'securepoll-jump' => 'اذهب إلى خادم التصويت',
	'securepoll-bad-ballot-submission' => 'تصويتك ليس صحيحا: $1',
	'securepoll-unanswered-questions' => 'يجب أن تجيب على كل الأسئله.',
	'securepoll-invalid-rank' => 'رتبه غير مقبوله. يجب أن تعطى المرشحين رتبه بين 1 و 999.',
	'securepoll-unranked-options' => 'لم يتم اعطاء رتبه لبعض الخيارات.
يجب أن تعطى كل الخيارات رتبه ما بين 1 و 999.',
	'securepoll-invalid-score' => 'الناتج يجب أن يكون عددا بين $1 و $2.',
	'securepoll-unanswered-options' => 'يجب أن تعطى ردا لكل سؤال.',
	'securepoll-remote-auth-error' => 'خطأ عند جلب معلومات حسابك من الخادوم.',
	'securepoll-remote-parse-error' => 'خطأ عند تفسير رد التصريح من الخادوم.',
	'securepoll-api-invalid-params' => 'محددات غير صحيحه.',
	'securepoll-api-no-user' => 'لم يوجد أى مستخدم بالهويه المعطاه.',
	'securepoll-api-token-mismatch' => 'نص الأمان لا يطابق، لا يمكن تسجيل الدخول.',
	'securepoll-not-logged-in' => 'يجب أن تدخل لتصوت فى هذه الانتخابات',
	'securepoll-too-few-edits' => 'عذرا لا يمكنك التصويت. يجب أن تقوم ب{{PLURAL:$1||تعديل واحد|تعديلين|$1 تعديلات|$1 تعديلًا|$1 تعديل}} على الأقل لتصوت فى هذه الانتخابات، بينما قمت ب$2.',
	'securepoll-blocked' => 'عذرا، لا تستطيع التصويت فى هذه الانتخابات إذا كنت ممنوعا حاليا من التعديل.',
	'securepoll-bot' => 'عذرا، الحسابات ذات أعلام البوت غير مسموح لها بالتصويت فى هذه الانتخابات.',
	'securepoll-not-in-group' => 'فقط المستخدمين من المجموعه "$1" يمكنهم التصويت فى هذه الانتخابات.',
	'securepoll-not-in-list' => 'عذرا، لست فى القائمه المُعدّه للمستخدمين المصرح لهم بالتصويت فى هذه الانتخابات.',
	'securepoll-list-title' => 'قائمه التصويتات: $1',
	'securepoll-header-timestamp' => 'الوقت',
	'securepoll-header-voter-name' => 'الاسم',
	'securepoll-header-voter-domain' => 'النطاق',
	'securepoll-header-ua' => 'وكيل المستخدم',
	'securepoll-header-cookie-dup' => 'مزدوج',
	'securepoll-header-strike' => 'اشطب',
	'securepoll-header-details' => 'التفاصيل',
	'securepoll-strike-button' => 'اشطب',
	'securepoll-unstrike-button' => 'الغاء الشطب',
	'securepoll-strike-reason' => 'السبب:',
	'securepoll-strike-cancel' => 'ألغِ',
	'securepoll-strike-error' => 'خطأ اثناء القيام بالشطب/الغاء الشطب: $1',
	'securepoll-strike-token-mismatch' => 'فقدت بيانات الجلسة',
	'securepoll-details-link' => 'التفاصيل',
	'securepoll-details-title' => 'تفاصيل التصويت: #$1',
	'securepoll-invalid-vote' => '"$1" ليس رمز تعريف تصويت صحيح.',
	'securepoll-header-voter-type' => 'نوع المستخدم',
	'securepoll-voter-properties' => 'خصائص التصويت',
	'securepoll-strike-log' => 'سجل الشطب',
	'securepoll-header-action' => 'الاجراء',
	'securepoll-header-reason' => 'السبب',
	'securepoll-header-admin' => 'الادارة',
	'securepoll-cookie-dup-list' => 'المستخدمون مزدوجو الكوكي',
	'securepoll-dump-title' => 'النتيجة: $1',
	'securepoll-dump-no-crypt' => 'لا يوجد سجل انتخابات مشفر متاح لهذه الانتخابات، بسبب ان الانتخابات غير مهيئه لاستخدام التشفير.',
	'securepoll-dump-not-finished' => 'سجلات الانتخابات المشفره متاحه فقط بعد تاريخ الانتهاء فى $1 ب $2',
	'securepoll-dump-no-urandom' => 'لا يمكن فتح /dev/urandom.
للحفاظ على خصوصيه المصوتين، سجلات الانتخابات المشفره تتاح على الملأ عندما يمكن خلطهم عن طريق سيل ارقام عشوائيه آمن.',
	'securepoll-urandom-not-supported' => 'هذا الخادم لا يدعم توليد أرقام عن طريق الترميز العشوائى.
للحفاظ على خصوصيه الناخبين ، سجلات الانتخابات المشفره ليست متاحه علانيه الا عندما يمكن خلطهم عن طريق دفق رقمى عشوائى آمن  .',
	'securepoll-translate-title' => 'ترجم: $1',
	'securepoll-invalid-language' => 'كود لغه غير صحيح "$1"',
	'securepoll-submit-translate' => 'تحديث',
	'securepoll-language-label' => 'اختر اللغة:',
	'securepoll-submit-select-lang' => 'ترجم',
	'securepoll-entry-text' => 'بالأسفل قائمه بالاقتراعات.',
	'securepoll-header-title' => 'اسم',
	'securepoll-header-start-date' => 'تاريخ البدء',
	'securepoll-header-end-date' => 'تاريخ الانتهاء',
	'securepoll-subpage-vote' => 'صوت',
	'securepoll-subpage-translate' => 'ترجم',
	'securepoll-subpage-list' => 'قائمة',
	'securepoll-subpage-dump' => 'تخزين',
	'securepoll-subpage-tally' => 'المحصلة',
	'securepoll-tally-title' => 'المحصلة: $1',
	'securepoll-tally-not-finished' => 'عذرا، لن تستطيع تحصيل الانتخابات حتى يكتمل التصويت.',
	'securepoll-can-decrypt' => 'لقد عُمّى سجل الانتخابات، لكن مفتاح فك التعميه متوفر.
تستطيع الاختيار بين تحصيل الانتخابات فى  قاعده البيانات مباشره، أو تحصيل نتائج معماه من ملفٍ مرفوع.',
	'securepoll-tally-no-key' => 'لا تستطيع تحصيل هذه الانتخابات، لأن التصويتات مُعمّاه، ومفتاح فك التعميه غير متوفر.',
	'securepoll-tally-local-legend' => 'محصله النتائج المخزنة',
	'securepoll-tally-local-submit' => 'أنشئ محصلة',
	'securepoll-tally-upload-legend' => 'رفع خزين مشفر',
	'securepoll-tally-upload-submit' => 'أنشئ محصلة',
	'securepoll-tally-error' => 'خطأ فى تفسير سجل التصويت، تعذّر توليد محصله.',
	'securepoll-no-upload' => 'لم يرفع ملف، تعذّر تحصيل النتائج.',
	'securepoll-dump-corrupt' => 'ملف التفريغ تالف و لا يمكن معالجته.',
	'securepoll-tally-upload-error' => 'خطأ أثناء فرز ملف التفريغ: $1',
	'securepoll-pairwise-victories' => 'مصفوفه انتصار الثنائيات',
	'securepoll-strength-matrix' => 'مصفوفه قوه المسار',
	'securepoll-ranks' => 'الترتيب النهائي',
	'securepoll-average-score' => 'نتيجه متوسطة',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'securepoll' => 'Бясьпечнае галасаваньне',
	'securepoll-desc' => 'Пашырэньне для выбараў і апытаньняў',
	'securepoll-invalid-page' => 'Няслушная падстаронка «<nowiki>$1</nowiki>»',
	'securepoll-need-admin' => 'Вам неабходна мець правы адміністратара выбараў, каб выканаць гэтае дзеяньне.',
	'securepoll-too-few-params' => 'Недастаткова парамэтраў падстаронкі (няслушная спасылка).',
	'securepoll-invalid-election' => '«$1» — няслушны ідэнтыфікатар выбараў.',
	'securepoll-welcome' => '<strong>Вітаем, $1!</strong>',
	'securepoll-not-started' => 'Гэтыя выбары яшчэ не пачаліся.
Яны павінны пачацца $2 у $3.',
	'securepoll-finished' => 'Гэтае галасаваньне скончанае, Вы ўжо ня можаце прагаласаваць.',
	'securepoll-not-qualified' => 'Вы не адпавядаеце крытэрам удзелу ў гэтых выбарах: $1',
	'securepoll-change-disallowed' => 'Вы ўжо галасавалі ў гэтых выбарах.
Прабачце, Вам нельга галасаваць паўторна.',
	'securepoll-change-allowed' => '<strong>Заўвага: Вы ўжо галасавалі ў гэтых выбарах.</strong>
Вы можаце зьмяніць Ваш голас, запоўніўшы форму ніжэй.
Заўважце, што калі Вы гэта зробіце, Ваш першапачатковы голас будзе ануляваны.',
	'securepoll-submit' => 'Даслаць голас',
	'securepoll-gpg-receipt' => 'Дзякуй за ўдзел ў галасаваньні.

Калі Вы жадаеце, Вы можаце атрымаць наступнае пацьверджаньне Вашага голасу:

<pre>$1</pre>',
	'securepoll-thanks' => 'Дзякуем, Ваш голас быў прыняты.',
	'securepoll-return' => 'Вярнуцца да $1',
	'securepoll-encrypt-error' => 'Памылка шыфраваньня Вашага голасу для запісу.
Ваш голас ня быў прыняты!

$1',
	'securepoll-no-gpg-home' => 'Немагчыма стварыць хатнюю дырэкторыю GPG.',
	'securepoll-secret-gpg-error' => 'Памылка выкананьня GPG.
Устанавіце $wgSecurePollShowErrorDetail=true; у LocalSettings.php каб паглядзець падрабязнасьці.',
	'securepoll-full-gpg-error' => 'Памылка выкананьня GPG:

Каманда: $1

Памылка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Ключы GPG былі няслушна сканфігураваны.',
	'securepoll-gpg-parse-error' => 'Памылка інтэрпрэтацыі вынікаў GPG.',
	'securepoll-no-decryption-key' => 'Няма скафігураваных ключоў для расшыфраваньня.
Немагчыма расшыфраваць.',
	'securepoll-jump' => 'Перайсьці на сэрвэр галасаваньня',
	'securepoll-bad-ballot-submission' => 'Ваш голас ня быў залічаны: $1',
	'securepoll-unanswered-questions' => 'Вам неабходна адказаць на ўсе пытаньні.',
	'securepoll-invalid-rank' => 'Няслушны ранг. Вам неабходна даць кандыдатам ранг паміж 1 і 999.',
	'securepoll-unranked-options' => 'Некаторыя пункты ня маюць рангу.
Вам неабходна даць усім пунктам ранг паміж 1 і 999.',
	'securepoll-invalid-score' => 'Адзнака павінна быць лікай паміж $1 і $2.',
	'securepoll-unanswered-options' => 'Вам неабходна даць адказ на кожнае пытаньне.',
	'securepoll-remote-auth-error' => 'Памылка атрыманьня інфармацыі пра Ваш рахунак з сэрвэра.',
	'securepoll-remote-parse-error' => 'Памылка інтэрпрэтацыі адказу аўтарызацыі з сэрвэра.',
	'securepoll-api-invalid-params' => 'Няслушныя парамэтры.',
	'securepoll-api-no-user' => 'Ня знойдзены ўдзельнік з пададзеным ідэнтыфікатарам.',
	'securepoll-api-token-mismatch' => 'Неадпаведнасьць меткі бясьпекі, немагчыма ўвайсьці ў сыстэму.',
	'securepoll-not-logged-in' => 'Вам неабходна ўвайсьці ў сыстэму, каб галасаваць на гэтых выбарах',
	'securepoll-too-few-edits' => 'Прабачце, Вы ня можаце галасаваць. Вам неабходна зрабіць хаця б {{PLURAL:$1|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}, каб галасаваць на гэтых выбарах, Вы зрабілі толькі $2.',
	'securepoll-blocked' => 'Прабачце, Вы ня можаце галасаваць на гэтых выбарах, калі Вы заблякаваны.',
	'securepoll-bot' => 'Прабачце, рахункі са статусам робата ня могуць галасаваць ў гэтых выбараў.',
	'securepoll-not-in-group' => 'Толькі ўдзельнікі групы $1 могуць галасаваць на гэтых выбарах.',
	'securepoll-not-in-list' => 'Прабачце, Вы не ўключаны ў сьпіс удзельнікаў, якія могуць галасаваць на гэтых выбарах.',
	'securepoll-list-title' => 'Сьпіс галасоў: $1',
	'securepoll-header-timestamp' => 'Час',
	'securepoll-header-voter-name' => 'Імя',
	'securepoll-header-voter-domain' => 'Дамэн',
	'securepoll-header-ua' => 'Агент удзельніка',
	'securepoll-header-cookie-dup' => 'Дублікат',
	'securepoll-header-strike' => 'Закрэсьліваньне',
	'securepoll-header-details' => 'Падрабязнасьці',
	'securepoll-strike-button' => 'Закрэсьліць',
	'securepoll-unstrike-button' => 'Адкрэсьліць',
	'securepoll-strike-reason' => 'Прычына:',
	'securepoll-strike-cancel' => 'Адмяніць',
	'securepoll-strike-error' => 'Памылка пад час закрэсьліваньня/адкрэсьліваньня: $1',
	'securepoll-strike-token-mismatch' => 'Зьвесткі сэсіі страчаныя',
	'securepoll-details-link' => 'Падрабязнасьці',
	'securepoll-details-title' => 'Падрабязнасьці галасаваньня: #$1',
	'securepoll-invalid-vote' => '«$1» не зьяўляецца слушным ідэнтыфікатарам голасу',
	'securepoll-header-voter-type' => 'Тып выбаршчыка',
	'securepoll-voter-properties' => 'Зьвесткі пра выбаршчыка',
	'securepoll-strike-log' => 'Журнал закрэсьліваньняў',
	'securepoll-header-action' => 'Дзеяньне',
	'securepoll-header-reason' => 'Прычына',
	'securepoll-header-admin' => 'Адміністратар',
	'securepoll-cookie-dup-list' => 'Дублікаты ўдзельнікаў па Cookie',
	'securepoll-dump-title' => 'Выбарчыя запісы: $1',
	'securepoll-dump-no-crypt' => 'Для гэтых выбараў няма зашыфраваных выбарчых запісаў, таму што ў гэтых выбарах ня прадугледжана шыфраваньне.',
	'securepoll-dump-not-finished' => 'Зашыфраваныя выбарчыя запісы даступны толькі пасьля $1 у $2.',
	'securepoll-dump-no-urandom' => 'Не магчыма адкрыць /dev/urandom.
Каб захаваць прыватнасьць галасоў, зашыфраваныя выбарчыя запісы будуць даступныя для грамадзкасьці, толькі калі іх парадак будуць будзе зьменены з дапамогай бясьпечнай крыніцы выпадковых лікаў.',
	'securepoll-urandom-not-supported' => 'Гэты сэрвэр не падтрымлівае генэрацыю крыптаграфічных выпадковых лікаў.
У мэтах захаваньня прыватнасьці галасаваўшых, зашыфраваныя запісы выбараў будуць агульнадаступнымі толькі калі яны могуць быць зьмешаныя са струменем выпадковых лікаў.',
	'securepoll-translate-title' => 'Пераклад: $1',
	'securepoll-invalid-language' => 'Няслушны код мовы «$1»',
	'securepoll-submit-translate' => 'Абнавіць',
	'securepoll-language-label' => 'Выбар мовы:',
	'securepoll-submit-select-lang' => 'Перакласьці',
	'securepoll-entry-text' => 'Ніжэй пададзены сьпіс апытаньняў.',
	'securepoll-header-title' => 'Назва',
	'securepoll-header-start-date' => 'Дата пачатку',
	'securepoll-header-end-date' => 'Дата заканчэньня',
	'securepoll-subpage-vote' => 'Голас',
	'securepoll-subpage-translate' => 'Перакласьці',
	'securepoll-subpage-list' => 'Сьпіс',
	'securepoll-subpage-dump' => 'Дамп',
	'securepoll-subpage-tally' => 'Падлік',
	'securepoll-tally-title' => 'Падлік: $1',
	'securepoll-tally-not-finished' => 'Прабачце, Вы ня можаце падлічваць галасы да сканчэньня галасаваньня.',
	'securepoll-can-decrypt' => 'Запіс голасу быў зашыфраваны, але маецца ключ расшыфроўкі.
Вы можаце выбраць падлік бягучых вынікаў у базе зьвестак, ці падлік зашыфраваных вынікаў з загружанага файла.',
	'securepoll-tally-no-key' => 'Вы ня можаце падлічыць вынікі гэтых выбараў, таму што яны зашыфраваныя, а ключа расшыфроўкі няма.',
	'securepoll-tally-local-legend' => 'Падлік захаваных вынікаў',
	'securepoll-tally-local-submit' => 'Падлічыць',
	'securepoll-tally-upload-legend' => 'Загрузка зашыфраванага дампу',
	'securepoll-tally-upload-submit' => 'Падлічыць',
	'securepoll-tally-error' => 'Памылка інтэрпрэтацыі запісу голасу, немагчыма падлічыць.',
	'securepoll-no-upload' => 'Файл не загружаны, немагчыма падлічыць.',
	'securepoll-dump-corrupt' => 'Вывадны файл пашкоджаны і ня можа быць апрацаваны.',
	'securepoll-tally-upload-error' => 'Памылка цэласнасьці вываднога файла: $1',
	'securepoll-pairwise-victories' => 'Матрыца падвойных перамогаў',
	'securepoll-strength-matrix' => 'Матрыца моцы шляхоў',
	'securepoll-ranks' => 'Канчатковыя вынікі',
	'securepoll-average-score' => 'Сярэдні вынік',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'securepoll-desc' => 'Разширение за провеждане на избори и допитвания',
	'securepoll-invalid-page' => 'Невалидна подстраница "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Това действие може да се извърши само от потребители със статут на администратор на гласуването.',
	'securepoll-too-few-params' => 'Недостатъчно параметри на подстраница (грешна препратка).',
	'securepoll-invalid-election' => '"$1" не е допустим идентификатор на гласуване.',
	'securepoll-welcome' => '<strong>Добре дошли, $1!</strong>',
	'securepoll-not-started' => 'Тези избори все още не са започнали.
Планира се гласуването да започне на $2 от $3.',
	'securepoll-finished' => 'Гласуването за тези избори е приключило, не можете да гласувате вече.',
	'securepoll-not-qualified' => 'Нямате право да гласувате на тези избори: $1',
	'securepoll-change-disallowed' => 'Вие вече сте участвали в това гласуване. 
За съжаление, не можете повторно да гласувате.',
	'securepoll-change-allowed' => '<strong>Забележка: Вие вече сте участвали в това гласуване.</strong>
Можете да промените подадения вече глас, като попълните формуляра по-долу.
По този начин първоначално подаденият ви глас ще бъде анулиран.',
	'securepoll-submit' => 'Гласуване',
	'securepoll-gpg-receipt' => 'Благодарим ви за участието в гласуването.

Ако желаете, можете да запазите следния код като доказателство за вашето гласуване:

<pre>$1</pre>',
	'securepoll-thanks' => 'Благодарим ви, вашият глас беше отчетен.',
	'securepoll-return' => 'Връщане към $1',
	'securepoll-encrypt-error' => 'Неуспешен опит за криптиране на подадения от вас глас.
Гласът ви не беше отчетен!

$1',
	'securepoll-no-gpg-home' => 'Грешка при създаване на домашна директория за GPG.',
	'securepoll-secret-gpg-error' => 'Грешка при изпълнението на GNU Privacy Guard.
За повече подробности, използвайте $wgSecurePollShowErrorDetail=true; в LocalSettings.php.',
	'securepoll-full-gpg-error' => 'Грешка при изпълнение на GNU Privacy Guard:

Команда: $1

Грешка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG ключовете са неправилно конфигурирани.',
	'securepoll-gpg-parse-error' => 'Грешка при интерпретирането на изхода на GNU Privacy Guard.',
	'securepoll-no-decryption-key' => 'Не е конфигуриран ключ за разшифроване.
Разшифроването на може да се изпълни.',
	'securepoll-jump' => 'Към сървъра за гласуване',
	'securepoll-bad-ballot-submission' => 'Гласът ви беше невалиден: $1',
	'securepoll-unanswered-questions' => 'Трябва да отговорите на всички въпроси.',
	'securepoll-invalid-rank' => 'Невалиден ранг. За рангове на кандидатите трябва да посочвате цели числа между 1 и 999.',
	'securepoll-unranked-options' => 'Някои от опциите не бяха ранжирани.
На всяка от опциите трябва да поставите ранг цяло число между 1 и 999.',
	'securepoll-invalid-score' => 'Оценката трябва да е число между $1 и $2.',
	'securepoll-unanswered-options' => 'Трябва да отговорите на всеки от въпросите.',
	'securepoll-remote-auth-error' => 'Грешка при извличане от сървъра на информация за потребителската ви сметка.',
	'securepoll-remote-parse-error' => 'Грешка в интерпретирането на отговора от сървъра при оторизация.',
	'securepoll-api-invalid-params' => 'Неправилни параметри.',
	'securepoll-api-no-user' => 'Не е открит потребител, отговарящ на посочения идентификатор.',
	'securepoll-api-token-mismatch' => 'Невалидна идентификация, неуспешен опит за влизане в системата.',
	'securepoll-not-logged-in' => 'Трябва да сте влезли в системата с потребителското си име, за да участвате в това гласуване.',
	'securepoll-too-few-edits' => 'За съжаление, не можете да гласувате. Трябва да сте направили най-малко $1 {{PLURAL:$1|редакция|редакции}}, за да имате право да участвате в гласуването, а вие сте направили $2.',
	'securepoll-blocked' => 'За съжаление, не можете да участвате в това гласуване, защото в момента сте блокирани.',
	'securepoll-bot' => 'За съжаление, потребителски сметки, отбелязани като ботове, не могат да вземат участие в това гласуване.',
	'securepoll-not-in-group' => 'Само членове на потребителска група "$1" могат да вземат участие в това гласуване.',
	'securepoll-not-in-list' => 'За съжаление, вашето потребителско име не фигурира в предварително определения списък на потребителите с право на участие в това гласуване.',
	'securepoll-list-title' => 'Списък на гласуванията: $1',
	'securepoll-header-timestamp' => 'Време',
	'securepoll-header-voter-name' => 'Име',
	'securepoll-header-voter-domain' => 'Домейн',
	'securepoll-header-ua' => 'Браузър',
	'securepoll-header-details' => 'Подробности',
	'securepoll-strike-reason' => 'Причина:',
	'securepoll-strike-cancel' => 'Отмяна',
	'securepoll-strike-token-mismatch' => 'Данните от сесията са изгубени',
	'securepoll-details-link' => 'Подробности',
	'securepoll-details-title' => 'Подробности за гласуването: #$1',
	'securepoll-invalid-vote' => '"$1" не е допустим идентификатор на гласуване',
	'securepoll-header-voter-type' => 'Тип гласоподатели',
	'securepoll-voter-properties' => 'Характеристики на гласоподавателите',
	'securepoll-header-action' => 'Действие',
	'securepoll-header-reason' => 'Причина',
	'securepoll-header-admin' => 'Админ',
	'securepoll-dump-no-crypt' => 'За тези избори не са достъпни криптирани записи от гласуването, тъй като изборната процедура не е била конфигурирана да използва криптиране.',
	'securepoll-dump-not-finished' => 'Криптираните записи от изборите ще бъдат достъпни едва след края на гласуването на $1 в $2',
	'securepoll-invalid-language' => 'Невалиден езиков код „$1“',
	'securepoll-submit-translate' => 'Актуализиране',
	'securepoll-language-label' => 'Избиране на език:',
	'securepoll-submit-select-lang' => 'Превеждане',
	'securepoll-entry-text' => 'По-долу следва списък с анкетите.',
	'securepoll-header-title' => 'Име',
	'securepoll-header-start-date' => 'Начална дата',
	'securepoll-header-end-date' => 'Крайна дата',
	'securepoll-subpage-vote' => 'Гласуване',
	'securepoll-subpage-translate' => 'Превеждане',
	'securepoll-subpage-list' => 'Списък',
	'securepoll-ranks' => 'Крайно класиране',
	'securepoll-average-score' => 'Средна оценка',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'securepoll-submit' => 'ভোট প্রদান করুন',
	'securepoll-thanks' => 'ধন্যবাদ, আপনার ভোট সংরক্ষণ করা হয়েছে।',
	'securepoll-return' => '$1 এ ফিরে যাও।',
	'securepoll-jump' => 'ভোটিং সার্ভারে যাও',
	'securepoll-header-timestamp' => 'সময়',
	'securepoll-header-voter-name' => 'নাম',
	'securepoll-header-voter-domain' => 'ডোমেইন',
	'securepoll-header-details' => 'বিস্তারিত',
	'securepoll-strike-reason' => 'কারণ:',
	'securepoll-strike-cancel' => 'বাতিল',
	'securepoll-details-link' => 'বিস্তারিত',
	'securepoll-details-title' => 'ভোট বিস্তারিত: #$1',
	'securepoll-invalid-vote' => '"$1" সঠিক ভোট আইডি নয়',
	'securepoll-header-voter-type' => 'ভোটারের ধরন',
	'securepoll-header-reason' => 'কারণ',
	'securepoll-header-admin' => 'প্রশাসক',
	'securepoll-translate-title' => 'অনুবাদ: $1',
	'securepoll-submit-translate' => 'খালনাগাদ',
	'securepoll-language-label' => 'ভাষা নির্বাচন:',
	'securepoll-submit-select-lang' => 'অনুবাদ',
	'securepoll-header-title' => 'নাম',
	'securepoll-header-start-date' => 'শুরুর তারিখ',
	'securepoll-header-end-date' => 'শেষের তারিখ',
	'securepoll-subpage-vote' => 'ভোট',
	'securepoll-subpage-translate' => 'অনুবাদ করুন',
	'securepoll-subpage-list' => 'তালিকা',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'securepoll' => 'Mouezhiadeg suraet',
	'securepoll-desc' => 'Astenn evit dilennadegoù ha sontadegoù',
	'securepoll-invalid-page' => 'Ispajenn "<nowiki>$1</nowiki>" direizh',
	'securepoll-need-admin' => "Ret eo deoc'h bezañ unan eus merourien an dilennadeg evit gellout seveniñ an ober-mañ.",
	'securepoll-too-few-params' => 'Diouer a arventennoù ispajenn (liamm fall)',
	'securepoll-invalid-election' => 'N\'eo ket "$1" un ID mouezhiañ degemeret.',
	'securepoll-welcome' => '<strong>Degemer mat $1!</strong>',
	'securepoll-not-started' => "N'eo ket kroget ar vouezhiadeg evit c'hoazh.
Emañ da gregiñ d'an $2 da $3.",
	'securepoll-finished' => "Serr eo ar vouezhiadeg-mañ, n'hallit ket votiñ ken.",
	'securepoll-not-qualified' => "N'hallit ket kemer perzh er votadeg-mañ : $1",
	'securepoll-change-disallowed' => "Votet hoc'h eus c'hoazh er vouezhiadeg-mañ.
Ho tigarez, met n'hallit ket votiñ ur wezh all.",
	'securepoll-change-allowed' => "<strong>Notenn : Votet eo bet ganeoc'h en dilennadeg-mañ c'hoazh.</strong>
Gallout a rit distreiñ war ho vot en ur gas ar furmskrid a-is.
Notit mat e vo distaolet ho vot kentañ ma rit kement-se.",
	'securepoll-submit' => 'Kas ar vot',
	'securepoll-gpg-receipt' => "Trugarez deoc'h da vezañ votet.

Mar karit, e c'hallit mirout ar bomm-degemer-mañ zo test hoc'h eus votet :

<pre>$1</pre>",
	'securepoll-thanks' => "Trugarez deoc'h, enrollet eo bet ho vot.",
	'securepoll-return' => 'Distreiñ da $1',
	'securepoll-encrypt-error' => "C'hwitet eo bet rinegañ ho vot.
N'eo ket bet kemeret ho vot e kont !

$1",
	'securepoll-no-gpg-home' => "Dibosupl krouiñ ar c'havlec'h gwrizienn GPG.",
	'securepoll-secret-gpg-error' => 'Fazi en ur erounit GPG.
Ouzhpennit $wgSecurePollShowErrorDetail=true; e LocalSettings.php evit diskouez muioc\'h a ditouroù.',
	'securepoll-full-gpg-error' => 'Fazi en ur erounit GPG:

Urzhad : $1

Fazi :
<pre>$2</pre>',
	'securepoll-gpg-config-error' => "N'eo ket kefluniet mat an alc'hwezioù GPG.",
	'securepoll-gpg-parse-error' => 'Fazi dielfennañ an ezmont GPG',
	'securepoll-no-decryption-key' => "N'eus bet spisaet alc'hwez disrinegañ ebet.
Dibosupl disrinegañ.",
	'securepoll-jump' => "Mont d'ar servijer mouezhiañ",
	'securepoll-bad-ballot-submission' => 'Direizh eo ho vot : $1',
	'securepoll-unanswered-questions' => "Ret eo deoc'h respont d'an holl c'houlennoù.",
	'securepoll-invalid-rank' => 'Renk direizh. Rankout a rit renkañ an emstriverien etre 1 ha 999.',
	'securepoll-unranked-options' => "Dibarzhioù zo n'int ket bet urzhiet.
Ret deoc'h renkañ pep dibarzh etre 1 ha 999.",
	'securepoll-invalid-score' => 'Rankout a ra ar skor bezan un niver etre $1 ha $2.',
	'securepoll-unanswered-options' => 'Ur respont a rankit reiñ evit kement goulenn zo.',
	'securepoll-remote-auth-error' => 'Ur fazi zo bet e-ser adtapout roadennoù ho kont digant ar servijer.',
	'securepoll-remote-parse-error' => 'Ur fazi zo bet e-ser dielfennañ ar respont aotren gant ar servijer.',
	'securepoll-api-invalid-params' => 'Arventennoù direizh.',
	'securepoll-api-no-user' => "N'eus bet kavet implijer ebet dezhañ an ID merket.",
	'securepoll-api-token-mismatch' => 'Ne glot ket ar jedouer surentez, dibosupl emlugañ',
	'securepoll-not-logged-in' => 'Rankout a rin en em lugañ a-benn votiñ en dilennadeg-mañ',
	'securepoll-too-few-edits' => "Ho tigarez, n'hallit ket votiñ. Ret eo bezañ graet da nebeutañ $1 {{PLURAL:$1|degasadenn|degasadenn}} a-benn gallout mouezhiañ en dilennadeg-mañ, ha graet hoc'h eus $2.",
	'securepoll-blocked' => "Ho tigarez, n'oc'h ket evit votiñ en dilennadeg-mañ pa'z eo stanket ho tegasadennoù evit ar mare.",
	'securepoll-bot' => "Ho tigarez, n'hall ket ar c'hontoù dezho ar statud robod votiñ en dilennadeg-mañ",
	'securepoll-not-in-group' => 'N\'eus nemet izili ar strollad "$1" a c\'hall kemer perzh ar votadeg-mañ.',
	'securepoll-not-in-list' => "Ho tigarez, n'emaoc'h ket war roll raktermenet an implijerien aotreet da vouezhiañ er votadeg-mañ.",
	'securepoll-list-title' => 'Roll ar mouezhioù : $1',
	'securepoll-header-timestamp' => 'Eur',
	'securepoll-header-voter-name' => 'Anv',
	'securepoll-header-voter-domain' => 'Domani',
	'securepoll-header-ua' => 'Gwazour implijer',
	'securepoll-header-cookie-dup' => 'Eilskrid',
	'securepoll-header-strike' => 'Barrenniñ',
	'securepoll-header-details' => 'Munudoù',
	'securepoll-strike-button' => 'Barrenniñ',
	'securepoll-unstrike-button' => 'Divarrenniñ',
	'securepoll-strike-reason' => 'Abeg :',
	'securepoll-strike-cancel' => 'Nullañ',
	'securepoll-strike-error' => 'Ur fazi zo bet e-ser barrenniñ/divarrenniñ : $1',
	'securepoll-strike-token-mismatch' => 'Kollet eo bet roadennoù an estez',
	'securepoll-details-link' => 'Munudoù',
	'securepoll-details-title' => 'Munudoù ar vouezhiadeg : #$1',
	'securepoll-invalid-vote' => 'N\'eo ket "$1" un ID votiñ reizh',
	'securepoll-header-voter-type' => 'Doare ar voter',
	'securepoll-voter-properties' => 'Perzhioù ar voter',
	'securepoll-strike-log' => 'Marilh ar barrenniñ',
	'securepoll-header-action' => 'Ober',
	'securepoll-header-reason' => 'Abeg',
	'securepoll-header-admin' => 'Merour',
	'securepoll-cookie-dup-list' => "Implijerien dezho toupinoù bet kavet c'hoazh",
	'securepoll-dump-title' => 'Enrolladenn : $1',
	'securepoll-dump-no-crypt' => "N'haller ket kaout ar roadennoù enrineget evit ar votadeg-mañ rak n'eo ket bet kefluniet ar vouezhiadeg evit bezañ enrineget.",
	'securepoll-dump-not-finished' => "N'hallor gwelet ar roadennoù enrineget nemet goude ma vo kloz an dilennadeg d'an $1 da $2",
	'securepoll-dump-no-urandom' => "Dibosupl digeriñ /dev/urandom.
A-benn mirout prevezded ar voterien n'haller tapout ar roadennoù enrineget nemet ma c'hallont bezañ strafuilhet gant ur ganer niveroù dargouezhek.",
	'securepoll-urandom-not-supported' => "N'eo ket skoret gant ar servijer-mañ ganadur enrineget dargouezhek an niveroù.
A-benn mirout prevezded ar voterien ne vez embannet ar roadennoù enrineget nemet pa c'hallont bezañ strafuilhet gant ul lanvad niveroù dargouezhek.",
	'securepoll-translate-title' => 'Treiñ : $1',
	'securepoll-invalid-language' => 'Kod yezh direizh : "$1"',
	'securepoll-submit-translate' => 'Hizivaat',
	'securepoll-language-label' => 'Dibab ar yezh :',
	'securepoll-submit-select-lang' => 'Treiñ',
	'securepoll-entry-text' => 'A-is emañ roll ar mouezhiadegoù.',
	'securepoll-header-title' => 'Anv',
	'securepoll-header-start-date' => 'Deiziad kregiñ',
	'securepoll-header-end-date' => 'Deiziad termen',
	'securepoll-subpage-vote' => 'Mouezhiañ',
	'securepoll-subpage-translate' => 'Treiñ',
	'securepoll-subpage-list' => 'Roll',
	'securepoll-subpage-dump' => 'Dilezel',
	'securepoll-subpage-tally' => 'Kontadur',
	'securepoll-tally-title' => 'Kontadur : $1',
	'securepoll-tally-not-finished' => "Ho tigarez, n'haller ket kontañ an disoc'hoù a-raok na vefe echuet ar vouezhiadeg.",
	'securepoll-can-decrypt' => "Enrineget eo bet enrolladenn an dilennadeg, hegerz eo an alc'hwez disrinegañ avat.
Gallout a rit kontañ an disoc'hoù adal an diaz roadennoù pe adal ur restr enporzhiet.",
	'securepoll-tally-no-key' => "N'hallit ket kontañ disoc'hoù an dilennadeg-mañ pa n'eo ket enrineget ar votoù ha n'eo ket hegerz an alc'hwez disrinegañ",
	'securepoll-tally-local-legend' => "Kontañ an disoc'hoù bet enrollet",
	'securepoll-tally-local-submit' => "Sevel ur c'hontadur",
	'securepoll-tally-upload-legend' => 'Enporzhiañ un enrolladenn enrineget',
	'securepoll-tally-upload-submit' => "Sevel ur c'hontadur",
	'securepoll-tally-error' => "Fazi e-ser dielfennañ enrolladennoù votiñ; disobupl ezteuler un disoc'h.",
	'securepoll-no-upload' => "N'eus bet pellgarget restr ebet, dibosupl eo kontañ an disoc'hoù.",
	'securepoll-dump-corrupt' => "Brein eo ar restr savete, n'haller ket ober ganti.",
	'securepoll-tally-upload-error' => 'Fazi e-ser kontañ ar restr savete : $1',
	'securepoll-pairwise-victories' => "Matris an trec'hoù dre goubladoù",
	'securepoll-strength-matrix' => 'Matris nerzh an hentoù moned',
	'securepoll-ranks' => 'Renkadur diwezhañ',
	'securepoll-average-score' => 'Skor keitat',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Seha
 */
$messages['bs'] = array(
	'securepoll' => 'Sigurno glasanje',
	'securepoll-desc' => 'Proširenje za izbore i ankete',
	'securepoll-invalid-page' => 'Nevaljana podstranica "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Morate biti administrator izbora da bi ste izvršili ovu akciju.',
	'securepoll-too-few-params' => 'Nema dovoljno parametara podstranice (nevaljan link).',
	'securepoll-invalid-election' => '"$1" nije valjan izborni ID.',
	'securepoll-welcome' => '<strong>Dobrodošao $1!</strong>',
	'securepoll-not-started' => 'Ovo glasanje još nije počelo.
Planirani početak glasanja je $2 u $3 sati.',
	'securepoll-finished' => 'Ovi izbori su završeni, ne možete više glasati.',
	'securepoll-not-qualified' => 'Niste kvalificirani da učestvujete na ovom glasanju: $1',
	'securepoll-change-disallowed' => 'Već ste ranije glasali na ovom glasanju.
Žao nam je, ne možete više glasati.',
	'securepoll-change-allowed' => '<strong>Napomena: Već ste ranije glasali na ovom glasanju.</strong>
Možete promijeniti Vaš glas slanjem obrasca ispod.
Zapamtite da ako ovo učinite, Vaš prvobitni glas će biti nevažeći.',
	'securepoll-submit' => 'Pošalji glas',
	'securepoll-gpg-receipt' => 'Hvala Vam za glasanje.

Ako želite, možete zadržati slijedeću potvrdu kao dokaz Vašeg glasanja:

<pre>$1</pre>',
	'securepoll-thanks' => 'Hvala Vam, Vaš glas je zapisan.',
	'securepoll-return' => 'Nazad na $1',
	'securepoll-encrypt-error' => 'Šifriranje Vašeg zapisa glasanja nije uspjelo.
Vaš glas nije sačuvan!

$1',
	'securepoll-no-gpg-home' => 'Nemoguće napraviti GPG početni direktorijum.',
	'securepoll-secret-gpg-error' => 'Greška pri izvršavanju GPG.
Koristite $wgSecurePollShowErrorDetail=true; u LocalSettings.php za više detalja.',
	'securepoll-full-gpg-error' => 'Greška pri izvršavanju GPG:

Komanda: $1

Grešaka:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG ključevi nisu pravilno podešeni.',
	'securepoll-gpg-parse-error' => 'Greška pri obradi GPG izlaza.',
	'securepoll-no-decryption-key' => 'Nijedan dekripcijski ključ nije podešen.
Ne može se dekriptovati.',
	'securepoll-jump' => 'Idi na server za glasanje',
	'securepoll-bad-ballot-submission' => 'Vaš glas nije valjan: $1',
	'securepoll-unanswered-questions' => 'Morate odgovoriti na sva pitanja.',
	'securepoll-invalid-rank' => 'Nevaljan rang. Morate dati kandidatima rang između 1 i 999.',
	'securepoll-unranked-options' => 'Neke opcije nisu rangirane.
Morate dati svim opcijama rang između 1 i 999.',
	'securepoll-invalid-score' => 'Rezultat mora biti broj između $1 i $2.',
	'securepoll-unanswered-options' => 'Morate odgovoriti na svako pitanje.',
	'securepoll-remote-auth-error' => 'Greška pri preuzimanju podataka o Vašem računu sa servera.',
	'securepoll-remote-parse-error' => 'Greška pri interpretaciji autentifikacijskog odgovora sa servera.',
	'securepoll-api-invalid-params' => 'Nevaljani parametri.',
	'securepoll-api-no-user' => 'Nije pronađen korisnik sa navedenim ID.',
	'securepoll-api-token-mismatch' => 'Nepodudata se sigurnosni token, ne može se prijaviti.',
	'securepoll-not-logged-in' => 'Morate se prijaviti za glasanje na ovim izborima',
	'securepoll-too-few-edits' => 'Žao nam je, ne možete glasati. Morate imati najmanje $1 {{PLURAL:$1|izmjenu|izmjene|izmjena}} da glasate na ovim izborima, Vi ste dosad napravili $2 izmjena.',
	'securepoll-blocked' => 'Žao nam je, ne možete trenutno glasati na ovim izborima ako ste trenutno blokirani za uređivanje.',
	'securepoll-bot' => 'Žao nam je, računima sa oznakom bota nije dopušteno da glasaju na ovim izborima.',
	'securepoll-not-in-group' => 'Samo članovi iz grupe $1 mogu učestovavati na ovim izborima.',
	'securepoll-not-in-list' => 'Žao nam je, niste na spisku korisnika kojima je odobreno glasanje na ovim izborima.',
	'securepoll-list-title' => 'Spisak glasova: $1',
	'securepoll-header-timestamp' => 'Vrijeme',
	'securepoll-header-voter-name' => 'Ime',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Korisnički agent',
	'securepoll-header-cookie-dup' => 'Otvaranje',
	'securepoll-header-strike' => 'Precrtaj',
	'securepoll-header-details' => 'Detalji',
	'securepoll-strike-button' => 'Precrtaj',
	'securepoll-unstrike-button' => 'Poništi precrtavanje',
	'securepoll-strike-reason' => 'Razlog:',
	'securepoll-strike-cancel' => 'Odustani',
	'securepoll-strike-error' => 'Greška izvšavanja precrtavanja/uklanjanja: $1',
	'securepoll-strike-token-mismatch' => 'Izgubljeni podaci sesije',
	'securepoll-details-link' => 'Detalji',
	'securepoll-details-title' => 'Detalji glasanja: #$1',
	'securepoll-invalid-vote' => '"$1" nije valjan glasački ID',
	'securepoll-header-voter-type' => 'Tip glasača',
	'securepoll-voter-properties' => 'Svojstva glasača',
	'securepoll-strike-log' => 'Zapisnik precrtavanja',
	'securepoll-header-action' => 'Akcija',
	'securepoll-header-reason' => 'Razlog',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Kolačić dvostrukih korisnika',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Ne postoji dešifrirana varijanta ovog izbora, zato što izbor nije konfiguriran za korištenje šifriranja.',
	'securepoll-dump-not-finished' => 'Dešifrirani rezultati izbora su vidljivi tek poslije datuma završetka izbora $1 u $2 sati',
	'securepoll-dump-no-urandom' => 'Da bi se sačuvala privatnost glasača, dešifrirani rezultati glasanja su dostupni kada bude dostupna mogućnost prenosa slučajnim izborom brojki.',
	'securepoll-urandom-not-supported' => 'Ovaj server ne podržava generisanje kriptografskih nasumičnih brojeva.
Da bi se zadržala privatnost glasača, šifrirani podaci o izborima su dostupni javno kada se mogu izmiješati putem sigurnog toka nasumičnih brojeva.',
	'securepoll-translate-title' => 'Prevedi: $1',
	'securepoll-invalid-language' => 'Pogrešan kod jezika "$1"',
	'securepoll-submit-translate' => 'Ažuriranje',
	'securepoll-language-label' => 'Izaberi jezik:',
	'securepoll-submit-select-lang' => 'Prevedi',
	'securepoll-entry-text' => 'Ispod je spisak glasanja.',
	'securepoll-header-title' => 'Ime',
	'securepoll-header-start-date' => 'Datum početka',
	'securepoll-header-end-date' => 'Datum završetka',
	'securepoll-subpage-vote' => 'Glasanje',
	'securepoll-subpage-translate' => 'Prijevod',
	'securepoll-subpage-list' => 'Spisak',
	'securepoll-subpage-dump' => 'Izvod',
	'securepoll-subpage-tally' => 'Prebrojavanje',
	'securepoll-tally-title' => 'Prebrojavanje: $1',
	'securepoll-tally-not-finished' => 'Žao nam je, ne možete prebrojavati glasove dok se ne završi glasanje.',
	'securepoll-can-decrypt' => 'Zapis izbora je šifriran, ali je dostupan ključ za otključavanje.
Možete da izvršite prebrojavanje glasova koji su prisutni u bazi podataka ili da prebrojite šifrirane rezultate iz postavljene datoteke.',
	'securepoll-tally-no-key' => 'Ne možete prebrojavati glasove, jer su šifrirani a nije dostupan ključ za otvaranje.',
	'securepoll-tally-local-legend' => 'Spremljeni rezultati glasanja',
	'securepoll-tally-local-submit' => 'Izvrši prebrojavanje',
	'securepoll-tally-upload-legend' => 'Postavi šifriranu arhivu',
	'securepoll-tally-upload-submit' => 'Napravi prebrojavanje',
	'securepoll-tally-error' => 'Greška pri interpretaciji zapisa glasanja, ne može se izvršiti prebrojavanje.',
	'securepoll-no-upload' => 'Nijedna datoteka nije postavljena, ne mogu se prebrojati rezultati.',
	'securepoll-dump-corrupt' => 'Dump datoteka je pokvarena i ne može biti obrađena.',
	'securepoll-tally-upload-error' => 'Greška pri ažuriranju dump datoteke: $1',
	'securepoll-pairwise-victories' => 'Parna matrica pobjednika',
	'securepoll-strength-matrix' => 'Matriks snage putanje',
	'securepoll-ranks' => 'Konačni poredak',
	'securepoll-average-score' => 'Prosječan rezultat',
);

/** Catalan (Català)
 * @author Cbrown1023
 * @author Góngora
 * @author Jordi Roqué
 * @author Paucabot
 * @author SMP
 * @author Solde
 * @author Ssola
 * @author Vriullop
 */
$messages['ca'] = array(
	'securepoll' => 'Vot segur',
	'securepoll-desc' => 'Extensió per a eleccions i enquestes',
	'securepoll-invalid-page' => 'Subpàgina «<nowiki>$1</nowiki>» invàlida',
	'securepoll-need-admin' => 'Heu de ser administrador electoral per a realitzar aquesta acció.',
	'securepoll-too-few-params' => 'No hi ha prou paràmetres de subpàgina (enllaç invàlid).',
	'securepoll-invalid-election' => "«$1» no és un identificador d'elecció vàlid.",
	'securepoll-welcome' => '<strong>Benvingut $1!</strong>',
	'securepoll-not-started' => 'Aquesta elecció encara no ha començat.
Està programada per a que comenci el $2 a $3.',
	'securepoll-finished' => "Aquesta elecció s'ha acabat, ja no podeu votar més.",
	'securepoll-not-qualified' => 'No esteu qualificat per votar en aquesta elecció: $1',
	'securepoll-change-disallowed' => 'Ja heu votat en aquesta elecció.
Disculpeu, no podeu tornar a votar.',
	'securepoll-change-allowed' => '<strong>Nota: Ja heu votat en aquesta elecció.</strong>
Podeu canviar el vostre vot trametent el següent formulari.
Si ho feu, el vostre vot anterior serà descartat.',
	'securepoll-submit' => 'Tramet el vot',
	'securepoll-gpg-receipt' => 'Gràcies per votar.

Si ho desitgeu, podeu conservar el següent comprovant del vostre vot:

<pre>$1</pre>',
	'securepoll-thanks' => 'Gràcies, el vostre vot ha estat enregistrat.',
	'securepoll-return' => 'Torna a $1',
	'securepoll-encrypt-error' => "No s'ha aconseguit encriptar el registre del vostre vot.
El vostre vot no ha estat enregistrat!

$1",
	'securepoll-no-gpg-home' => 'No es pot crear el directori de GPG.',
	'securepoll-secret-gpg-error' => 'Error en l\'execució de GPG.
Useu $wgSecurePollShowErrorDetail=true; al LocalSettings.php per a mostrar més detalls.',
	'securepoll-full-gpg-error' => "Error en l'execució del GPG:

Comanda: $1

Error:
<pre>$2</pre>",
	'securepoll-gpg-config-error' => 'Les claus GPG estan mal configurades.',
	'securepoll-gpg-parse-error' => 'Error en la interpretació de la sortida de GPG',
	'securepoll-no-decryption-key' => 'No està configurada la clau de desxifrat.
No es pot desencriptar.',
	'securepoll-jump' => 'Tornar al servidor de votació',
	'securepoll-bad-ballot-submission' => 'El vostre vot no és vàlid: $1',
	'securepoll-unanswered-questions' => 'Heu de respondre totes les qüestions.',
	'securepoll-invalid-rank' => "Rang no vàlid.
Heu d'introduir a cada candidat un valor entre 1 i 999.",
	'securepoll-unranked-options' => 'Algunes opcions no han estat qualificades.
Heu de donar a totes les opcions, un rang entre 1 i 999.',
	'securepoll-remote-auth-error' => "S'ha produit un eror en recuperar del servidor la informació del vostre compte .",
	'securepoll-remote-parse-error' => "S'ha produit un error en la recepció de la resposta d'autorització des del servidor.",
	'securepoll-api-invalid-params' => 'Paràmetres invàlids.',
	'securepoll-api-no-user' => "No s'ha trobat cap usuari amb aquesta identificació.",
	'securepoll-api-token-mismatch' => "El token de seguretat no coincideix. No s'ha pogut accedir.",
	'securepoll-not-logged-in' => "Heu d'estar connectats en un compte per a votar en aquesta elecció",
	'securepoll-too-few-edits' => "Ho sentim, però no podeu votar.
Per a votar en aquesta elecció cal haver fet un mínim {{PLURAL:$1|d'una modificació|de $1 modificacions}}, i n'heu fet $2.",
	'securepoll-blocked' => "Ho sentim però no podeu votar en aquesta elecció perquè el vostre compte està blocat a l'edició.",
	'securepoll-bot' => 'Ho sentim, però els comptes de bot no poden votar en aquestes eleccions.',
	'securepoll-not-in-group' => 'Només els membres del grup «$1» poden votar en aquesta elecció.',
	'securepoll-not-in-list' => 'Ho sentim, però no esteu en la llista dels usuaris autoritzats a votar en aquesta elecció.',
	'securepoll-list-title' => 'Llista de vots: $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nom',
	'securepoll-header-voter-domain' => 'Domini',
	'securepoll-header-ua' => '<em>Useragent</em>',
	'securepoll-header-cookie-dup' => 'Duplicat',
	'securepoll-header-strike' => 'Anuŀlació',
	'securepoll-header-details' => 'Detalls',
	'securepoll-strike-button' => 'Anuŀla',
	'securepoll-unstrike-button' => "Desfés l'anuŀlació",
	'securepoll-strike-reason' => 'Motiu:',
	'securepoll-strike-cancel' => 'Canceŀla',
	'securepoll-strike-error' => "Error en anuŀlar o en desfer l'anuŀlació: $1",
	'securepoll-strike-token-mismatch' => 'Pèrdua de dades de la sessió',
	'securepoll-details-link' => 'Detalls',
	'securepoll-details-title' => 'Detalls de vot: #$1',
	'securepoll-invalid-vote' => '«$1» no és una ID de vot vàlida',
	'securepoll-header-voter-type' => "Tipus d'usuari",
	'securepoll-voter-properties' => 'Propietats del votant',
	'securepoll-strike-log' => "Registre d'anuŀlacions",
	'securepoll-header-action' => 'Acció',
	'securepoll-header-reason' => 'Motiu',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-cookie-dup-list' => 'Usuaris amb galetes duplicades',
	'securepoll-dump-title' => 'Abocament: $1',
	'securepoll-dump-no-crypt' => 'No existeix cap registre encriptat en aquesta elecció perquè no està configurada per usar encriptació.',
	'securepoll-dump-not-finished' => "Els registres encriptats de l'elecció només estaran disponibles després de la seva conclusió, a $1 del $2",
	'securepoll-dump-no-urandom' => "No es pot obrir /dev/urandom.
Per mantenir la privacitat dels votants, els registres encriptats de l'elecció es fan públics només quan poden ser barrejats amb un generador segur de nombres aleatoris.",
	'securepoll-urandom-not-supported' => "Aquest servidor no suporta la generació criptogràfica de nombres aleatoris.
Per mantenir la privacitat del votant, els registres d'elecció encriptats només són públicament disponibles quan es poden emetre amb un flux segur de nombres aleatoris.",
	'securepoll-translate-title' => 'Traducció: $1',
	'securepoll-invalid-language' => "Codi d'idioma «$1» no vàlid",
	'securepoll-submit-translate' => 'Actualitza',
	'securepoll-language-label' => 'Escolliu idioma:',
	'securepoll-submit-select-lang' => 'Tradueix',
	'securepoll-header-title' => 'Nom',
	'securepoll-header-start-date' => "Data d'inici",
	'securepoll-header-end-date' => 'Data de finalització',
	'securepoll-subpage-vote' => 'Votació',
	'securepoll-subpage-translate' => 'Traducció',
	'securepoll-subpage-list' => 'Llista',
	'securepoll-subpage-dump' => 'Abocament',
	'securepoll-subpage-tally' => 'Compte',
	'securepoll-tally-title' => 'Compte: $1',
	'securepoll-tally-not-finished' => 'Les dades de la votació no estaran disponibles fins que hagi finalitzat.',
	'securepoll-can-decrypt' => "El registre de l'elecció ha estat encriptat, però la clau de desxifratge està disponible.
Podeu triar entre comptar els resultats presents a la base de dades, o de comptar-ne els encriptats a partir d'un fitxer carregat.",
	'securepoll-tally-no-key' => "No podeu comptar els vots d'aquesta elecció, perquè estan encriptats i la clau de desxifratge no està disponible.",
	'securepoll-tally-local-legend' => 'Comptar els resultats arxivats.',
	'securepoll-tally-local-submit' => 'Comptar els vots.',
	'securepoll-tally-upload-legend' => 'Carrega un abocament encriptat',
	'securepoll-tally-upload-submit' => 'Crea un compte',
	'securepoll-tally-error' => "Error en interpretar l'arxiu de votació, no es poden comptar els resultats.",
	'securepoll-no-upload' => "No s'ha carregat cap arxiu, no s'en poden comptar els resultats.",
	'securepoll-dump-corrupt' => 'El fitxer bolcat es troba danyat i no pot ser processat.',
	'securepoll-tally-upload-error' => 'Error al contar el fitxer bolcat: $1',
	'securepoll-ranks' => 'Classificació final',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'securepoll' => 'Bezpečné hlasování',
	'securepoll-desc' => 'Rozšíření pro hlasování a průzkumy',
	'securepoll-invalid-page' => 'Neplatná podstránka „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'K provedení této operace byste {{GENDER:|musel|musela|musel}} být volební správce.',
	'securepoll-too-few-params' => 'Nedostatek parametrů pro podstránku (neplatný odkaz).',
	'securepoll-invalid-election' => '„$1“ není platný identifikátor hlasování.',
	'securepoll-welcome' => '<strong>Vítejte, {{GENDER:$1|uživateli|uživatelko|uživateli}} $1!</strong>',
	'securepoll-not-started' => 'Toto hlasování dosud nebylo zahájeno.
Mělo by začít v $3, $2.',
	'securepoll-finished' => 'Toto hlasování skončilo, už nemůžete hlasovat.',
	'securepoll-not-qualified' => 'Nesplňujete podmínky pro účast v tomto hlasování: $1',
	'securepoll-change-disallowed' => 'Tohoto hlasování jste se již {{GENDER:|zúčastnil|zúčastnila|zúčastnil}}.
Je mi líto, ale znovu hlasovat nemůžete.',
	'securepoll-change-allowed' => '<strong>Poznámka: Tohoto hlasování jste se již {{GENDER:|zúčastnil|zúčastnila|zúčastnil}}.</strong>
Pokud chcete svůj hlas změnit, odešlete níže uvedený formulář.
Uvědomte si, že pokud to uděláte, váš původní hlas bude zahozen.',
	'securepoll-submit' => 'Odeslat hlas',
	'securepoll-gpg-receipt' => 'Děkujeme za váš hlas.

Pokud chcete, můžete si uschovat následující potvrzení vašeho hlasování:

<pre>$1</pre>',
	'securepoll-thanks' => 'Děkujeme vám, váš hlas byl zaznamenán.',
	'securepoll-return' => 'Vrátit se na stránku $1',
	'securepoll-encrypt-error' => 'Nepodařilo se zašifrovat záznam o vašem hlasování.
Váš hlas nebyl zaznamenán!

$1',
	'securepoll-no-gpg-home' => 'Nepodařilo se vytvořit domácí adresář pro GPG.',
	'securepoll-secret-gpg-error' => 'Chyba při provádění GPG.
Pokud chcete zobrazit podrobnosti, nastavte <code>$wgSecurePollShowErrorDetail=true;</code> v <tt>LocalSettings.php</tt>.',
	'securepoll-full-gpg-error' => 'Chyba při provádění GPG:

Příkaz: $1

Chyba:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Jsou chybně nakonfigurovány klíče pro GPG.',
	'securepoll-gpg-parse-error' => 'Chyba při zpracovávání výstupu GPG.',
	'securepoll-no-decryption-key' => 'Nebyl nakonfigurován dešifrovací klíč.
Nelze dešifrovat.',
	'securepoll-jump' => 'Přejít na hlasovací server',
	'securepoll-bad-ballot-submission' => 'Váš hlas je neplatný: $1',
	'securepoll-unanswered-questions' => 'Musíte zodpovědět všechny otázky.',
	'securepoll-invalid-rank' => 'Neplatné pořadí. Kandidátům musíte přidělit pořadí mezi 1 a 999.',
	'securepoll-unranked-options' => 'Některé možnosti nebyly ohodnoceny.
Musíte všem možnostem přidělit pořadí mezi 1 a 999.',
	'securepoll-invalid-score' => 'Hodnocením musí být číslo v rozsahu $1 až $2.',
	'securepoll-unanswered-options' => 'Musíte vyplnit odpověď na všechny otázky.',
	'securepoll-remote-auth-error' => 'Při čtení informací o vašem uživatelském účtu ze serveru nastala chyba.',
	'securepoll-remote-parse-error' => 'Při zpracovávání autorizační odpovědi od serveru nastala chyba.',
	'securepoll-api-invalid-params' => 'Chybné parametry.',
	'securepoll-api-no-user' => 'Nebyl nalezen uživatel s uvedeným ID.',
	'securepoll-api-token-mismatch' => 'Nesouhlasí bezpečnostní kód, nelze se přihlásit.',
	'securepoll-not-logged-in' => 'Abyste mohl(a) hlasovat, musíte se přihlásit.',
	'securepoll-too-few-edits' => 'Promiňte, ale nemůžete hlasovat. V těchto volbách mohou hlasovat jen uživatelé s nejméně $1 {{PLURAL:$1|editací|editacemi}}, vy máte $2.',
	'securepoll-blocked' => 'Promiňte, ale nemůžete se zúčastnit tohoto hlasování, pokud je vám momentálně zablokována editace.',
	'securepoll-bot' => 'Promiňte, ale účty s příznakem bot se nemohou tohoto hlasování účastnit.',
	'securepoll-not-in-group' => 'Tohoto hlasování se mohou účastnit pouze uživatelé ve skupině „$1“.',
	'securepoll-not-in-list' => 'Promiňte, ale nejste v předpřipraveném seznamu uživatelů oprávněných zúčasnit se tohoto hlasování.',
	'securepoll-list-title' => 'Seznam hlasů – $1',
	'securepoll-header-timestamp' => 'Čas',
	'securepoll-header-voter-name' => 'Jméno',
	'securepoll-header-voter-domain' => 'Doména',
	'securepoll-header-ua' => 'Prohlížeč',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Přeškrtnutí',
	'securepoll-header-details' => 'Podrobnosti',
	'securepoll-strike-button' => 'Přeškrtnout',
	'securepoll-unstrike-button' => 'Neškrtat',
	'securepoll-strike-reason' => 'Důvod:',
	'securepoll-strike-cancel' => 'Storno',
	'securepoll-strike-error' => 'Nepodařilo se provést přeškrtnutí či jeho zrušení: $1',
	'securepoll-strike-token-mismatch' => 'Data z relace byla ztracena',
	'securepoll-details-link' => 'Podrobnosti',
	'securepoll-details-title' => 'Podrobnosti hlasu #$1',
	'securepoll-invalid-vote' => '„$1“ není platný identifikátor hlasu',
	'securepoll-header-voter-type' => 'Typ hlasujícího',
	'securepoll-voter-properties' => 'Vlastnosti hlasujícího',
	'securepoll-strike-log' => 'Záznam škrtání hlasu',
	'securepoll-header-action' => 'Operace',
	'securepoll-header-reason' => 'Důvod',
	'securepoll-header-admin' => 'Správce',
	'securepoll-cookie-dup-list' => 'Duplicitní uživatelé podle cookie',
	'securepoll-dump-title' => 'Záznam – $1',
	'securepoll-dump-no-crypt' => 'U těchto voleb není k dispozici šifrovaný záznam hlasování, neboť v jejich konfiguraci není šifrování zapnuto.',
	'securepoll-dump-not-finished' => 'Šifrovaný záznam hlasování bude k dispozici až po skončení voleb, $1, $2',
	'securepoll-dump-no-urandom' => 'Nelze otevřít <tt>/dev/urandom</tt>.
Kvůli tajnosti hlasování je šifrovaný záznam hlasování veřejně dostupný pouze v případě, že hlasy mohou být zamíchány pomocí bezpečného zdroje náhodných čísel.',
	'securepoll-urandom-not-supported' => 'Tento server nepodporuje kryptografické generování náhodných čísel.
Kvůli tajnosti hlasování je šifrovaný záznam hlasování veřejně dostupný pouze v případě, že hlasy mohou být zamíchány pomocí bezpečného zdroje náhodných čísel.',
	'securepoll-translate-title' => 'Překlad – $1',
	'securepoll-invalid-language' => 'Neplatný kód jazyka „$1“',
	'securepoll-submit-translate' => 'Uložit',
	'securepoll-language-label' => 'Zvolte jazyk:',
	'securepoll-submit-select-lang' => 'Překládat',
	'securepoll-entry-text' => 'Níže je zobrazen seznam hlasování.',
	'securepoll-header-title' => 'Název',
	'securepoll-header-start-date' => 'Datum začátku',
	'securepoll-header-end-date' => 'Datum ukončení',
	'securepoll-subpage-vote' => 'Hlasovat',
	'securepoll-subpage-translate' => 'Překlad',
	'securepoll-subpage-list' => 'Seznam',
	'securepoll-subpage-dump' => 'Záznam',
	'securepoll-subpage-tally' => 'Sečíst',
	'securepoll-tally-title' => 'Součet hlasů – $1',
	'securepoll-tally-not-finished' => 'Promiňte, ale nemůžete sčítat hlasy, dokud hlasování ještě probíhá.',
	'securepoll-can-decrypt' => 'Záznam hlasování byl zašifrován, ale dešifrovací klíč je k dispozici.
Můžete si vybrat, zda chcete sečíst výsledky v databázi, nebo sečíst šifrované výsledky z načteného souboru.',
	'securepoll-tally-no-key' => 'Toto hlasování nemůžete sečíst, protože hlasy jsou zašifrované a dešifrovací klíč není dostupný.',
	'securepoll-tally-local-legend' => 'Sečíst uložené hlasy',
	'securepoll-tally-local-submit' => 'Provést sčítání',
	'securepoll-tally-upload-legend' => 'Načíst šifrovaný záznam',
	'securepoll-tally-upload-submit' => 'Provést sčítání',
	'securepoll-tally-error' => 'Chyba při zpracovávání záznamu hlasování, hlasování nelze sečíst.',
	'securepoll-no-upload' => 'Nebyl načten žádný soubor, hlasování nelze sečíst.',
	'securepoll-dump-corrupt' => 'Soubor se záznamem je poškozený a nelze ho zpracovat.',
	'securepoll-tally-upload-error' => 'Chyba při sčítání záznamu: $1',
	'securepoll-pairwise-victories' => 'Matice vzájemných vítězství',
	'securepoll-strength-matrix' => 'Matice síly cest',
	'securepoll-ranks' => 'Konečné pořadí',
	'securepoll-average-score' => 'Průměrné hodnocení',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'securepoll' => 'Etholiad diogel',
	'securepoll-desc' => 'Estyniad ar gyfer etholiadau ac arolygon',
	'securepoll-invalid-page' => 'Isdudalen annilys "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => "Mae'n rhaid bod yn weinyddwr etholiad i wneud y weithred hon.",
	'securepoll-too-few-params' => 'Dim digon o baramedrau isdudalen (cywllt annilys).',
	'securepoll-invalid-election' => 'Nid yw "$1" yn ID dilys ar gyfer yr etholiad.',
	'securepoll-welcome' => '<strong>Croeso $1!</strong>',
	'securepoll-not-started' => "Nid yw'r etholiad wedi dechrau eto.
Bydd yn dechrau ar $2 am $3.",
	'securepoll-finished' => "Mae'r etholiad wedi dod i ben; ni allwch bleidleisio rhagor.",
	'securepoll-not-qualified' => 'Nid ydych yn gymwys i bleidleisio yn yr etholiad hwn: $1',
	'securepoll-change-disallowed' => "Yr ydych eisoes wedi bwrw'ch pleidlais.
Ni allwch bleidleisio eto.",
	'securepoll-change-allowed' => "<strong>Nodyn: Rydych eisoes wedi pleidleisio yn yr etholiad hwn.</strong>
Gallwch newid eich pleidlais drwy ddefnyddio'r ffurflen isod.
Sylwch y bydd eich pleidlais gwreiddiol yn cael ei ddiddymu pan gaiff yr un newydd ei derbyn.",
	'securepoll-submit' => "Bwrw'r bleidlais",
	'securepoll-gpg-receipt' => "Diolch am bleidleisio.

Os dymunwch, gallwch gadw'r derbynneb sy'n dilyn yn brawf o'ch pleidlais:

<pre>$1</pre>",
	'securepoll-thanks' => 'Diolch, mae eich pleidlais wedi cael ei gofnodi.',
	'securepoll-return' => 'Yn ôl i $1',
	'securepoll-encrypt-error' => "Wedi methu amgryptio'r cofnod o'ch pleidlais.
Ni gofnodwyd eich pleidlais!

$1",
	'securepoll-no-gpg-home' => 'Wedi methu creu cyfeiriadur cartref GPG.',
	'securepoll-secret-gpg-error' => 'Cafwyd gwall wrth weithredu GPG.
Defnyddiwch $wgSecurePollShowErrorDetail=true; yn LocalSettings.php i weld rhagor o fanylion.',
	'securepoll-full-gpg-error' => 'Cafwyd gwall wrth weithredu GPG:

Gorchymyn: $1

Gwall:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => "Nid yw'r allweddau GPG wedi eu ffurweddu'n gywir.",
	'securepoll-gpg-parse-error' => "Cafwyd gwall wrth ddehongli'r allbwn GPG.",
	'securepoll-no-decryption-key' => "Nid yw'r allwedd dadgryptio wedi ei ffurfweddu.
Ni ellir dadgryptio.",
	'securepoll-jump' => 'Mynd i weinydd y pleidleisio',
	'securepoll-bad-ballot-submission' => 'Nid oedd eich pleidlais yn ddilys: $1',
	'securepoll-unanswered-questions' => 'Rhaid ateb pob cwestiwn.',
	'securepoll-invalid-rank' => "Gradd annilys yn y drefn restrol. Rhaid ichi roi gradd rhwng 1 a 999 i'r ymgeiswyr.",
	'securepoll-unranked-options' => 'Gadawyd rhai dewisiadau heb eu rhestru.
Rhaid ichi roi gradd rhwng 1 a 999 i bob dewis.',
	'securepoll-invalid-score' => "Rhaid i'r sgôr fod yn rif rhwng $1 a $2.",
	'securepoll-unanswered-options' => 'Rhaid ateb pob cwestiwn.',
	'securepoll-remote-auth-error' => "Cafwyd gwall wrth nôl gwybodaeth eich cyfrif o'r gweinydd.",
	'securepoll-remote-parse-error' => "Cafwyd gwall wrth ddehongli ymateb y gweinydd i'r cais awdurdodi.",
	'securepoll-api-invalid-params' => 'Paramedrau annilys.',
	'securepoll-api-no-user' => "Ni chafwyd hyd i ddefnyddiwr gyda'r ID hwn.",
	'securepoll-api-token-mismatch' => "Nid yw'r taleb gwarchod yn cydweddu; ni allwch fewngofnodi.",
	'securepoll-not-logged-in' => 'Rhaid i chi fewngofnodi er mwyn pleidleisio yn yr etholiad hwn',
	'securepoll-too-few-edits' => 'Ni allwch bleidleisio, ysywaeth. Rhaid eich bod wedi cyfrannu o leiaf $1 {{PLURAL:$1|golygiad|golygiad|olygiad|golygiad|o olygiadau|o olygiadau}} er mwyn pleidleisio yn yr etholiad; rydych wedi golygu $2 o weithiau.',
	'securepoll-blocked' => 'Ni allwch bleidleisio yn yr etholiad hwn, ysywaeth, gan eich wedi eich atal rhag golygu ar hyn o bryd.',
	'securepoll-bot' => 'Ni chaiff cyfrifon bot bleidleisio yn yr etholiad hwn, ysywaeth.',
	'securepoll-not-in-group' => 'Dim ond aelodau o\'r grŵp "$1" caiff bleidleisio yn yr etholiad hwn.',
	'securepoll-not-in-list' => 'Nid ydych ar restr y defnyddwyr, wedi ei bennu ymlaenllaw, sydd wedi eu hawdurdodi i bleidleisio yn yr etholiad hwn, ysywaeth.',
	'securepoll-list-title' => 'Rhestr y pleidleisiau: $1',
	'securepoll-header-timestamp' => 'Amser',
	'securepoll-header-voter-name' => 'Enw',
	'securepoll-header-voter-domain' => 'Parth',
	'securepoll-header-ua' => 'Asiant y defnyddiwr',
	'securepoll-header-cookie-dup' => 'Dyb',
	'securepoll-header-strike' => 'Annilysu',
	'securepoll-header-details' => 'Manylion',
	'securepoll-strike-button' => 'Annilysu',
	'securepoll-unstrike-button' => 'Ail-ddilysu',
	'securepoll-strike-reason' => 'Rheswm:',
	'securepoll-strike-cancel' => 'Canslo',
	'securepoll-strike-error' => 'Gwall wrth geisio annilysu/ail-ddilysu: $1',
	'securepoll-strike-token-mismatch' => "Collwyd data'r sesiwn",
	'securepoll-details-link' => 'Manylion',
	'securepoll-details-title' => 'Manylion y bleidlais: #$1',
	'securepoll-invalid-vote' => 'Nid yw "$1" yn ID dilys ar gyfer y bleidlais',
	'securepoll-header-voter-type' => 'Math y pleidleisiwr',
	'securepoll-voter-properties' => "Priodweddau'r pleidleisiwr",
	'securepoll-strike-log' => 'Lòg annilysu',
	'securepoll-header-action' => 'Gweithred',
	'securepoll-header-reason' => 'Rheswm',
	'securepoll-header-admin' => 'Gweinyddwr',
	'securepoll-cookie-dup-list' => 'Defnyddwyr dyblyg (dyb) o ran cwcis',
	'securepoll-dump-title' => 'Dymp: $1',
	'securepoll-dump-no-crypt' => "Nid oes cofnod amgryptiedig o'r etholiad hwn ar gael, oherwydd nid yw'r etholiad wedi ei ffurfweddu i ddefnyddio amgryptio.",
	'securepoll-dump-not-finished' => "Ni fydd y cofnodion amgryptiedig o'r etholiad ar gael hyd at ddiwedd yr etholiad am $2 ar $1",
	'securepoll-dump-no-urandom' => "Ni ellir agor /dev/urandom.
Er mwyn diogelu cyfrinachedd pleidleiswyr, nid yw cofnodion yr etholiad ar gael i'r cyhoedd ond pan y gellir eu cymysgu trwy ddefnyddio llif haprifau diogel.",
	'securepoll-urandom-not-supported' => "Nid yw'r gweinydd hwn yn gallu cynhyrchu haprifau ar gyfer amgryptio.
Er mwyn diogelu cyfrinachedd y pleidleiswyr, nid yw cofnodion amgryptiedig yr etholiad ar gael i'r cyhoedd ond pan fo modd eu cymysgu'n ddi-ôl trwy ddefnyddio ffrwd diogel o haprifau.",
	'securepoll-translate-title' => 'Cyfieithu: $1',
	'securepoll-invalid-language' => 'Côd iaith annilys, "$1"',
	'securepoll-submit-translate' => 'Diweddaru',
	'securepoll-language-label' => 'Dewis iaith:',
	'securepoll-submit-select-lang' => 'Cyfieithu',
	'securepoll-entry-text' => 'Dyma restr yr etholiadau.',
	'securepoll-header-title' => 'Enw',
	'securepoll-header-start-date' => 'Dyddiad dechrau',
	'securepoll-header-end-date' => 'Dyddiad gorffen',
	'securepoll-subpage-vote' => 'Pleidleisio',
	'securepoll-subpage-translate' => 'Cyfieithu',
	'securepoll-subpage-list' => 'Rhestr',
	'securepoll-subpage-dump' => 'Dymp',
	'securepoll-subpage-tally' => 'Cyfrif',
	'securepoll-tally-title' => 'Cyfrif: $1',
	'securepoll-tally-not-finished' => 'Ni allwch gyfrif yr etholiad hyd nes bod y pleidleisio wedi ei gwblhau.',
	'securepoll-can-decrypt' => "Mae cofnodion yr etholiad wedi eu hamgryptio, ond mae'r allwedd dadgryptio ar gael.
Gallwch naill ai gyfrif y canlyniadau sydd yn y bas data, neu gallwch gyfrif y canlyniadau amgryptiedig mewn ffeil wedi ei huwchlwytho.",
	'securepoll-tally-no-key' => "Ni allwch gyfrif canlyniad yr etholiad, oherwydd bod y pleidleisiau wedi eu hamgryptio, ac nid yw'r allwedd dadgryptio ar gael.",
	'securepoll-tally-local-legend' => 'Cyfrif y canlyniadau sydd ar gadw',
	'securepoll-tally-local-submit' => 'Cadw cyfrif',
	'securepoll-tally-upload-legend' => "Uwchlwytho'r dymp amgryptiedig",
	'securepoll-tally-upload-submit' => 'Cadw cyfrif',
	'securepoll-tally-error' => "Cafwyd gwall wrth ddehongli'r cofnod pleidleisio, ni ellir cadw cyfrif.",
	'securepoll-no-upload' => 'Ni uwchlwythwyd unrhyw ffeil, ni ellir cyfrif y canlyniadau.',
	'securepoll-dump-corrupt' => 'Mae ffeil y dymp yn llygredig ac ni ellir weithredu arno.',
	'securepoll-tally-upload-error' => 'Cafwyd gwall wrth gyfrif y ffeil dymp: $1',
	'securepoll-pairwise-victories' => 'Matrics cymharu buddugoliaethau fesul dau',
	'securepoll-strength-matrix' => 'Matrics cryfder y llwybr',
	'securepoll-ranks' => 'Y drefn rhestrol terfynol',
	'securepoll-average-score' => 'Cyfartaledd y sgôr',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Kaare
 * @author Masz
 * @author Sir48
 */
$messages['da'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'En udvidelse til valg og undersøgelser',
	'securepoll-invalid-page' => 'Ugyldig underside "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Du skal være valgadministrator for at udføre denne handling.',
	'securepoll-too-few-params' => 'Ikke tilstrækkeligt mange undersideparametre (ugyldigt link).',
	'securepoll-invalid-election' => '"$1" er ikke en gyldig valg-id.',
	'securepoll-welcome' => '<strong>Velkommen $1!</strong>',
	'securepoll-not-started' => 'Dette valg er endnu ikke begyndt.
Det er planlagt til at begynde den $2 klokken $3.',
	'securepoll-finished' => 'Dette valg er afsluttet, du kan ikke længere stemme.',
	'securepoll-not-qualified' => 'Du er kvalificeret til at afgive din stemme ved dette valg: $1',
	'securepoll-change-disallowed' => 'Du har allerede afgivet din stemme ved dette valg.
Desværre kan du ikke stemme igen.',
	'securepoll-change-allowed' => '<strong>Bemærk: Du har allerede afgivet din stemme ved dette valg.</strong>
Du kan ændre din stemme ved at indsende formularen herunder.
Vær opmærksom på, at hvis du gør det, vil din oprindelige stemme blive smidt væk.',
	'securepoll-submit' => 'Afgiv stemme',
	'securepoll-gpg-receipt' => 'Tak fordi du stemte.

Hvis du ønsker det, kan du gemme følgende kvittering som bevis på din stemme:

<pre>$1</pre>',
	'securepoll-thanks' => 'Tak, din stemme er registreret.',
	'securepoll-return' => 'Tilbage til $1',
	'securepoll-encrypt-error' => 'Kunne ikke kryptere din stemme.
Din stemme er ikke registreret!

$1',
	'securepoll-no-gpg-home' => 'Kunne ikke oprette GPG-hjemmemappe.',
	'securepoll-secret-gpg-error' => 'Fejl ved udførelse af GPG.
Anvend $wgSecurePollShowErrorDetail=true; i LocalSettings.php for at se flere oplysninger.',
	'securepoll-full-gpg-error' => 'Fejl ved udførelse af GPG:

Kommando: $1

Fejl:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-nøglerne er opsat forkert.',
	'securepoll-gpg-parse-error' => 'Fejl ved fortolkning af uddata fra GPG.',
	'securepoll-no-decryption-key' => 'Ingen dekrypteringsnøgle opsat.
Kan ikke dekryptere.',
	'securepoll-jump' => 'Gå til stemmeserveren',
	'securepoll-bad-ballot-submission' => 'Din stemme var ugyldig: $1',
	'securepoll-unanswered-questions' => 'Du skal besvare alle spørgsmålene.',
	'securepoll-invalid-rank' => 'Ugyldig rangorden. Du skal give kandidaterne en rangorden mellem 1 og 999.',
	'securepoll-unranked-options' => 'Nogle muligheder blev ikke rangordnet.
Du skal give alle muligheder en rangordning mellem 1 og 999.',
	'securepoll-remote-auth-error' => 'Der opstod en fejl under hentning af dine kontoinformationer fra serveren.',
	'securepoll-remote-parse-error' => 'Der opstod en fejl under læsning af autorisationssvarene fra serveren.',
	'securepoll-api-invalid-params' => 'Ugyldige parametere.',
	'securepoll-api-no-user' => 'Ingen brugere med den angivne ID blev fundet.',
	'securepoll-api-token-mismatch' => 'Sikkerhedskoden er forkert, du kan ikke logge ind.',
	'securepoll-not-logged-in' => 'Du skal logge ind for at stemme i dette valg',
	'securepoll-too-few-edits' => 'Beklager, men du kan ikke stemme. Du skal lave mindst $1 {{PLURAL:$1|redigering|redigeringer}}. Du har kun lavet $2.',
	'securepoll-blocked' => 'Du kan ikke stemme, fordi du i øjeblikket er blokeret fra at redigere.',
	'securepoll-bot' => 'Beklager, men konti med botflag kan ikke stemme i dette valg.',
	'securepoll-not-in-group' => 'Kun brugere af gruppen "$1" kan stemme.',
	'securepoll-not-in-list' => 'Du er desværre ikke på listen over brugere, som kan stemme i dette valg.',
	'securepoll-list-title' => 'Vis stemmer: $1',
	'securepoll-header-timestamp' => 'Tid',
	'securepoll-header-voter-name' => 'Navn',
	'securepoll-header-voter-domain' => 'Domæne',
	'securepoll-header-ua' => 'Useragent',
	'securepoll-header-cookie-dup' => 'Dublet',
	'securepoll-header-strike' => 'Fjern',
	'securepoll-header-details' => 'Oplysninger',
	'securepoll-strike-button' => 'Fjern',
	'securepoll-unstrike-button' => 'Ophæv fjernelse',
	'securepoll-strike-reason' => 'Årsag:',
	'securepoll-strike-cancel' => 'Annuller',
	'securepoll-strike-error' => 'Fejl ved fjernelse eller ophævelse af fjernelse: $1',
	'securepoll-strike-token-mismatch' => 'Sessionsdata mistet',
	'securepoll-details-link' => 'Oplysninger',
	'securepoll-details-title' => 'Valgoplysninger: #$1',
	'securepoll-invalid-vote' => '"$1" er ikke en gyldig valg-id',
	'securepoll-header-voter-type' => 'Brugertype',
	'securepoll-voter-properties' => 'Stemmegiveregenskaber',
	'securepoll-strike-log' => 'Fjernelseslog',
	'securepoll-header-action' => 'Handling',
	'securepoll-header-reason' => 'Årsag',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Cooke-dubletbrugere',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Ingen krypterede valgregistreringer er tilgængelige til dette valg, fordi valget ikke er opsat til at anvende kryptering.',
	'securepoll-dump-not-finished' => 'Krypterede valgregistreringer er kun tilgængelige efter afstemningen den $1 klokken $2.',
	'securepoll-dump-no-urandom' => 'Kan ikke åbne /dev/urandom.
For at sikre en hemmelig afstemning er de krypterede valgregistrering kun offentligt  tilgængelige, når de kan blandes med en sikker strøm af tilfældige tal.',
	'securepoll-urandom-not-supported' => 'Denne server understøtter ikke generering af tilfældige kryptografiske tal.
For at vedligeholde personlige oplysninger om vælgeren, er krypterede valgregistreringer kun offentligt tilgængelige, når de kan blandes med en strøm af sikre tilfældige tal.',
	'securepoll-translate-title' => 'Oversæt: $1',
	'securepoll-invalid-language' => 'Ugyldig sprogkode "$1"',
	'securepoll-submit-translate' => 'Opdater',
	'securepoll-language-label' => 'Vælg sprog:',
	'securepoll-submit-select-lang' => 'Oversæt',
	'securepoll-header-title' => 'Navn',
	'securepoll-header-start-date' => 'Startsdato',
	'securepoll-header-end-date' => 'Slutsdato',
	'securepoll-subpage-vote' => 'Stem',
	'securepoll-subpage-translate' => 'Oversæt',
	'securepoll-subpage-list' => 'Liste',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Optælling',
	'securepoll-tally-title' => 'Optælling: $1',
	'securepoll-tally-not-finished' => 'Du kan desværre ikke optælle valgresultatet før afstemningen er slut.',
	'securepoll-can-decrypt' => 'Valgregisteret er blevet krypteret, men en dekrypteringsnøgle er tilgængelig.
Du kan enten optælle de nuværende stemmer i databasen, eller optælle krypterede resultater fra et oplagt fil.',
	'securepoll-tally-no-key' => 'Du kan ikke tælle resultatet op, fordi stemmerne er krypterede, og dekrypteringsnøglen er utilgængelig.',
	'securepoll-tally-local-legend' => 'Optællig af stemmerne',
	'securepoll-tally-local-submit' => 'Opret en optælling',
	'securepoll-tally-upload-legend' => 'Læg en krypteret dump op',
	'securepoll-tally-upload-submit' => 'Opret optælling',
	'securepoll-tally-error' => 'Fejl under læsning af stemmeregisteret, kan ikke oprette en optælling.',
	'securepoll-no-upload' => 'Ingen fil blev lagt op; kan ikke tælle resultatet op.',
	'securepoll-dump-corrupt' => 'Dumpfilen er korrupt og kan ikke behandles.',
	'securepoll-tally-upload-error' => 'Fejl ved optælling af dumpfilen: $1',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Metalhead64
 * @author Pill
 * @author Umherirrender
 */
$messages['de'] = array(
	'securepoll' => 'Sichere Abstimmung',
	'securepoll-desc' => 'Erweiterung für Wahlen und Umfragen',
	'securepoll-invalid-page' => 'Ungültige Unterseite „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Du musst ein Wahl-Administrator sein, um diese Aktion durchzuführen.',
	'securepoll-too-few-params' => 'Nicht genügend Unterseitenparameter (ungültiger Link).',
	'securepoll-invalid-election' => '„$1“ ist keine gültige Abstimmungs-ID.',
	'securepoll-welcome' => '<strong>Willkommen $1!</strong>',
	'securepoll-not-started' => 'Die Wahl hat noch nicht begonnen.
Ihr Start ist für den $2 um $3 Uhr geplant.',
	'securepoll-finished' => 'Diese Wahl ist beendet, du kannst nicht mehr abstimmen.',
	'securepoll-not-qualified' => 'Du bist nicht qualifiziert, bei dieser Wahl abzustimmen: $1',
	'securepoll-change-disallowed' => 'Du hast bei dieser Wahl bereits abgestimmt.
Du darfst nicht erneut abstimmen.',
	'securepoll-change-allowed' => '<strong>Hinweis: Du hast bei dieser Wahl bereits abgestimmt.</strong>
Du kannst deine Stimme ändern, indem du das untere Formular abschickst.
Wenn du dies tust, wird deine ursprüngliche Stimme überschrieben.',
	'securepoll-submit' => 'Stimme abgeben',
	'securepoll-gpg-receipt' => 'Vielen Dank.

Es folgt eine Bestätigung als Beweis für deine Stimmabgabe:

<pre>$1</pre>',
	'securepoll-thanks' => 'Vielen Dank, deine Stimme wurde gespeichert.',
	'securepoll-return' => 'Zurück zu $1',
	'securepoll-encrypt-error' => 'Beim Verschlüsseln deiner Stimme ist ein Fehler aufgetreten.
Deine Stimme wurde nicht gespeichert!

$1',
	'securepoll-no-gpg-home' => 'GPG-Benutzerverzeichnis kann nicht erstellt werden.',
	'securepoll-secret-gpg-error' => 'Fehler beim Ausführen von GPG.
$wgSecurePollShowErrorDetail=true; in LocalSettings.php einfügen, um mehr Details anzuzeigen.',
	'securepoll-full-gpg-error' => 'Fehler beim Ausführen von GPG:

Befehl: $1

Fehler:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-Schlüssel sind nicht korrekt konfiguriert.',
	'securepoll-gpg-parse-error' => 'Fehler beim Interpretieren der GPG-Ausgabe.',
	'securepoll-no-decryption-key' => 'Es ist kein Entschlüsselungsschlüssel konfiguriert.
Entschlüsselung nicht möglich.',
	'securepoll-jump' => 'Gehe zum Abstimmungsserver',
	'securepoll-bad-ballot-submission' => 'Deine Stimme war ungültig: $1',
	'securepoll-unanswered-questions' => 'Du musst alle Fragen beantworten.',
	'securepoll-invalid-rank' => 'Ungültige Rangfolge. Du musst den Kandidaten eine Rangnummer zwischen 1 und 999 geben.',
	'securepoll-unranked-options' => 'Einige Optionen wurden nicht mit einer Rangnummer versehen.
Du musst allen Optionen eine Rangnummer zwischen 1 und 999 geben.',
	'securepoll-invalid-score' => 'Das Ergebnis muss eine Zahl zwischen $1 und $2 sein.',
	'securepoll-unanswered-options' => 'Du musst zu jeder Frage eine Antwort geben.',
	'securepoll-remote-auth-error' => 'Fehler beim Abruf deiner Benutzerkonteninformationen vom Server.',
	'securepoll-remote-parse-error' => 'Fehler beim Interpretieren der Berechtigungsantwort des Servers.',
	'securepoll-api-invalid-params' => 'Ungültige Parameter.',
	'securepoll-api-no-user' => 'Es wurde kein Benutzer mit der angegebenen ID gefunden.',
	'securepoll-api-token-mismatch' => 'Falsche Sicherheitstoken, Anmeldung fehlgeschlagen.',
	'securepoll-not-logged-in' => 'Du musst angemeldet sein, um bei dieser Wahl abstimmen zu können',
	'securepoll-too-few-edits' => 'Du darfst leider nicht abstimmen. Du brauchst mindestens $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}}, um bei dieser Wahl abzustimmen, du hast jedoch $2.',
	'securepoll-blocked' => 'Du kannst bei dieser Wahl leider nicht abstimmen, wenn du gesperrt bist.',
	'securepoll-bot' => 'Konten mit Botstatus sind leider nicht berechtigt, bei dieser Wahl abzustimmen.',
	'securepoll-not-in-group' => 'Nur Mitglieder der Gruppe „$1“ können bei dieser Wahl abstimmen.',
	'securepoll-not-in-list' => 'Du bist leider nicht auf der Liste der Benutzer, die bei dieser Wahl abstimmen dürfen.',
	'securepoll-list-title' => 'Stimmen auflisten: $1',
	'securepoll-header-timestamp' => 'Zeit',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domäne',
	'securepoll-header-ua' => 'Benutzeragent',
	'securepoll-header-cookie-dup' => 'Duplikat',
	'securepoll-header-strike' => 'Streichen',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Streichen',
	'securepoll-unstrike-button' => 'Streichung zurücknehmen',
	'securepoll-strike-reason' => 'Grund:',
	'securepoll-strike-cancel' => 'Abbrechen',
	'securepoll-strike-error' => 'Fehler bei der Streichung/Streichungsrücknahme: $1',
	'securepoll-strike-token-mismatch' => 'Sitzungsdaten verloren',
	'securepoll-details-link' => 'Details',
	'securepoll-details-title' => 'Abstimmungsdetails: #$1',
	'securepoll-invalid-vote' => '„$1“ ist keine gültige Abstimmungs-ID',
	'securepoll-header-voter-type' => 'Wählertyp',
	'securepoll-voter-properties' => 'Wählereigenschaften',
	'securepoll-strike-log' => 'Streichungs-Logbuch',
	'securepoll-header-action' => 'Aktion',
	'securepoll-header-reason' => 'Grund',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => 'Benutzer, die doppelt abgestimmt haben',
	'securepoll-dump-title' => 'Auszug: $1',
	'securepoll-dump-no-crypt' => 'Für diese Wahl sind keine verschlüsselten Abstimmungsaufzeichnungen verfügbar, da die Wahl nicht für Verschlüsselung konfiguriert wurde.',
	'securepoll-dump-not-finished' => 'Verschlüsselte Abstimmungsaufzeichnungen sind nur nach dem Endtermin am $1 um $2 Uhr verfügbar',
	'securepoll-dump-no-urandom' => '/dev/urandom kann nicht geöffnet werden.
Um den Wählerdatenschutz zu wahren, sind verschlüsselte Abstimmungsaufzeichnungen nur öffentlich verfügbar, wenn sie mit einem sicheren Zufallszahlenstrom gemischt werden können.',
	'securepoll-urandom-not-supported' => 'Dieser Server unterstützt keine kryptographische Zufallszahlenerzeugung.
Zur Sicherstellung des Wahlgeheimnisses sind verschlüsselte Wahlaufzeichnungen nur öffentlich verfügbar, sofern sie mit einer sicheren Zufallszahlenreihenfolge vermischt werden konnten.',
	'securepoll-translate-title' => 'Übersetzen: $1',
	'securepoll-invalid-language' => 'Ungültiger Sprachcode „$1“',
	'securepoll-submit-translate' => 'Aktualisieren',
	'securepoll-language-label' => 'Sprache auswählen:',
	'securepoll-submit-select-lang' => 'Übersetzen',
	'securepoll-entry-text' => 'Nachfolgend die Liste der Wahlen.',
	'securepoll-header-title' => 'Name',
	'securepoll-header-start-date' => 'Beginn',
	'securepoll-header-end-date' => 'Ende',
	'securepoll-subpage-vote' => 'Abstimmen',
	'securepoll-subpage-translate' => 'Übersetzen',
	'securepoll-subpage-list' => 'Liste',
	'securepoll-subpage-dump' => 'Auszug',
	'securepoll-subpage-tally' => 'Zählung',
	'securepoll-tally-title' => 'Zählung: $1',
	'securepoll-tally-not-finished' => 'Du kannst leider keine Stimmen auszählen, bevor die Abstimmung beendet wurde.',
	'securepoll-can-decrypt' => 'Die Wahlaufzeichnung wurde verschlüsselt, aber der Entschlüsselungsschlüssel ist verfügbar.
Du kannst wählen zwischen der Zählung der aktuellen Ergebnisse in der Datenbank und der Zählung der verschlüsselten Ergebnisse einer hochgeladenen Datei.',
	'securepoll-tally-no-key' => 'Du kannst die Stimmen nicht auszählen, da die Stimmen verschlüsselt sind und der Entschlüsselungsschlüssel nicht verfügbar ist.',
	'securepoll-tally-local-legend' => 'Gespeicherte Ergebnisse zählen',
	'securepoll-tally-local-submit' => 'Zählung erstellen',
	'securepoll-tally-upload-legend' => 'Verschlüsselten Auszug hochladen',
	'securepoll-tally-upload-submit' => 'Zählung erstellen',
	'securepoll-tally-error' => 'Fehler beim Interpretieren der Abstimmungsaufzeichnung, Auszählungserstellung nicht möglich.',
	'securepoll-no-upload' => 'Es wurde keine Datei hochgeladen, Ergebniszählung nicht möglich.',
	'securepoll-dump-corrupt' => 'Die Dump-Datei ist korrupt und kann nicht verarbeitet werden.',
	'securepoll-tally-upload-error' => 'Fehler beim Zählen der Dump-Datei: $1',
	'securepoll-pairwise-victories' => 'Paarweise Siegesmatrix',
	'securepoll-strength-matrix' => 'Wegstärkenmatrix',
	'securepoll-ranks' => 'Schlussranking',
	'securepoll-average-score' => 'Durchschnittliches Ergebnis',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author ChrisiPK
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'securepoll-need-admin' => 'Sie müssen ein Wahl-Administrator sein, um diese Aktion durchzuführen.',
	'securepoll-finished' => 'Diese Wahl ist beendet, Sie können nicht mehr abstimmen.',
	'securepoll-not-qualified' => 'Sie sind nicht qualifiziert, bei dieser Wahl abzustimmen: $1',
	'securepoll-change-disallowed' => 'Sie haben bei dieser Wahl bereits abgestimmt.
Sie dürfen nicht erneut abstimmen.',
	'securepoll-change-allowed' => '<strong>Hinweis: Sie haben in dieser Wahl bereits abgestimmt.</strong>
Sie können Ihre Stimme ändern, indem Sie das untere Formular abschicken.
Wenn Sie dies tun, wird Ihre ursprüngliche Stimme überschrieben.',
	'securepoll-gpg-receipt' => 'Vielen Dank.

Es folgt eine Bestätigung als Beweis für Ihre Stimmabgabe:

<pre>$1</pre>',
	'securepoll-thanks' => 'Vielen Dank, Ihre Stimme wurde gespeichert.',
	'securepoll-encrypt-error' => 'Beim Verschlüsseln Ihrer Stimme ist ein Fehler aufgetreten.
Ihre Stimme wurde nicht gespeichert!

$1',
	'securepoll-bad-ballot-submission' => 'Ihre Stimme war ungültig: $1',
	'securepoll-unanswered-questions' => 'Sie müssen alle Fragen beantworten.',
	'securepoll-invalid-rank' => 'Ungültige Rangfolge. Sie müssen den Kandidaten eine Rangnummer zwischen 1 und 999 geben.',
	'securepoll-unranked-options' => 'Einige Optionen wurden nicht mit einer Rangnummer versehen.
Sie müssen allen Optionen eine Rangnummer zwischen 1 und 999 geben.',
	'securepoll-unanswered-options' => 'Sie müssen für jede Frage eine Antwort geben.',
	'securepoll-remote-auth-error' => 'Fehler beim Abruf Ihrer Benutzerkonteninformationen vom Server.',
	'securepoll-not-logged-in' => 'Sie müssen angemeldet sein, um bei dieser Wahl abstimmen zu können',
	'securepoll-too-few-edits' => 'Sie dürfen leider nicht abstimmen. Sie brauchen mindestens $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}}, um bei dieser Wahl abzustimmen, Sie haben jedoch $2.',
	'securepoll-blocked' => 'Sie können bei dieser Wahl leider nicht abstimmen, wenn Sie gesperrt sind.',
	'securepoll-not-in-list' => 'Sie sind leider nicht auf der Liste der Benutzer, die bei dieser Wahl abstimmen dürfen.',
	'securepoll-tally-not-finished' => 'Sie können leider keine Stimmen auszählen, bevor die Abstimmung beendet wurde.',
	'securepoll-can-decrypt' => 'Die Wahlaufzeichnung wurde verschlüsselt, aber der Entschlüsselungsschlüssel ist verfügbar.
Sie können wählen zwischen der Zählung der aktuellen Ergebnisse in der Datenbank und der Zählung der verschlüsselten Ergebnisse einer hochgeladenen Datei.',
	'securepoll-tally-no-key' => 'Sie können die Stimmen nicht auszählen, da die Stimmen verschlüsselt sind und der Entschlüsselungsschlüssel nicht verfügbar ist.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'securepoll' => 'anketo bawerbiyayeyi',
	'securepoll-desc' => 'Qe weçinayîşan u anketan extensiyon',
	'securepoll-invalid-page' => 'pelo bıni yo nemeqbul: $1',
	'securepoll-need-admin' => 'qey no kari şıma gani serkaribi',
	'securepoll-too-few-params' => 'Yeterli altsayfa parametresi yok (geçersiz bağlantı).',
	'securepoll-invalid-election' => '"$1" terciheko nemeqbul o ID.',
	'securepoll-welcome' => '<strong>Ti xeyr ameyî $1!</strong>',
	'securepoll-not-started' => 'Bu seçim henüz başlamadı.
$2 tarihinde $3 saatinde başlaması planlanıyor.',
	'securepoll-finished' => 'no tercih temam bı, şıma hıni nêeşkeni rey bıdi.',
	'securepoll-not-qualified' => 'no vıcinayiş de şıma muqtedirê reydayişi niyi: $1',
	'securepoll-change-disallowed' => 'şıma tiya de cıwa ver rey da, 
ma meluli şıma hıni nêşkeni rey bıdi',
	'securepoll-change-allowed' => '<strong>Not: şıma no vıcinayiş de reyê xo da.</strong>
şıma eşkeni pê dekerdışê formê cêrıni reyê xo bıvurni.
Eke şıma ın kerd bızane ke reyo şıma verin ibtal beno.',
	'securepoll-submit' => 'rey bışaw',
	'securepoll-gpg-receipt' => 'qey reydayişi ma tekkur keni.

qey delaletê reydayişi meqbuzo cêrın muhefeze bıkerê, eke şıma wazeni:

<pre>$1</pre>',
	'securepoll-thanks' => 'ma teşekkur keni reyê şıma qeyd bı',
	'securepoll-return' => 'agêr no pel $1',
	'securepoll-encrypt-error' => 'şifre biyayişê qeydê reyê şıma serkewte nêbı.
reyê şıma qeyd nêbı!

$1',
	'securepoll-no-gpg-home' => 'rêza keyeyê GPGyi nêvıraziyeno .',
	'securepoll-secret-gpg-error' => 'GPG xebiıtyenê xeta da.
qey teferruati LocalSettings.php\'de $wgSecurePollShowErrorDetail=true bışuxulnê.',
	'securepoll-full-gpg-error' => 'GPG çalıştırırken hata:

Komut: $1

Hata:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'kılitê GPGyi şaş eyar biyo',
	'securepoll-gpg-parse-error' => 'wexta ke raporê GPGyi mışore bene xeta da.',
	'securepoll-no-decryption-key' => 'çı mefteyê deşifreyi eyar nêbı.
Deşifre biyayiş nebeno.',
	'securepoll-jump' => 'şo pêşkeşwanê reydayişi',
	'securepoll-bad-ballot-submission' => 'reyê şima nemeqbulo: $1',
	'securepoll-unanswered-questions' => 'gani şıma heme sualan re cewab bıdi.',
	'securepoll-invalid-rank' => 'Dereceya nemeqbul. şima gani nazedan re benatê 1 u 999  de yew derece bıdi.',
	'securepoll-unranked-options' => 'tayê tercihi derece nêbiyi.
heme tercihan re gani şıma benateyê 1 u 999  de yew derece bıdi.',
	'securepoll-invalid-score' => 'Puan benateyê $1 u $2 de gani yew amar bo.',
	'securepoll-unanswered-options' => 'her suali re gani şıma yew cewab bıdi.',
	'securepoll-remote-auth-error' => 'wexta pêşkeşwani ra malumatê hesabê şıma geriyayene xeta vıraziya.',
	'securepoll-remote-parse-error' => 'wexta cewabê desthelatiyê pêşkeşwani mışore bêne xeta bı.',
	'securepoll-api-invalid-params' => 'parametreyê nemeqbuli.',
	'securepoll-api-no-user' => 'ID nişan biyo wina yew karber çino.',
	'securepoll-api-token-mismatch' => 'simgeya pawıtışi zepê niyo, cıkewtış nêbeno',
	'securepoll-not-logged-in' => 'na vıcinayiş de qey reydayişi gani şıma cıkewe.',
	'securepoll-too-few-edits' => 'ma meluli, şıma nêşkeni rey bıdi. çunke qey reydayişi gani şıma tewr tay  $1 {{PLURAL:$1|vuriyayiş|vuriyayiş}} bıkeri. vuriyayişê şıma ındeko  $2.',
	'securepoll-blocked' => 'Üma meluli, eke şıma bloke biyi şıma nêşkeni rey bıdi.',
	'securepoll-bot' => 'ma meluli, hesabê ke pê boti işaret biyê nêşkeni rey bıdi.',
	'securepoll-not-in-group' => 'na vıcinayiş de tena azayê na $1 grubi eşkeni rey bıdi.',
	'securepoll-not-in-list' => 'Üma meluli, na vıcinayiş de rey3e şıma çino, çunke şıma karberê şınasnaye niyê, desthelati şıma çino.',
	'securepoll-list-title' => 'reyan liste ker: $1',
	'securepoll-header-timestamp' => 'wext',
	'securepoll-header-voter-name' => 'name',
	'securepoll-header-voter-domain' => 'domain',
	'securepoll-header-ua' => 'teösilkarê karberi',
	'securepoll-header-cookie-dup' => 'kopya',
	'securepoll-header-strike' => 'serê ey de xetek bıanc.',
	'securepoll-header-details' => 'teferruati',
	'securepoll-strike-button' => 'serê ey de xetek bıanc.',
	'securepoll-unstrike-button' => 'serê ey de xetek meanc.',
	'securepoll-strike-reason' => 'Sebep:',
	'securepoll-strike-cancel' => 'İptal',
	'securepoll-strike-error' => 'serê ey de xeta bıanc/meanc ardene ca  xeta da: $1',
	'securepoll-strike-token-mismatch' => 'datayê hesabi vindbiyayeyo',
	'securepoll-details-link' => 'teferruati',
	'securepoll-details-title' => 'teferruatê reyi: #$1',
	'securepoll-invalid-vote' => '"$1" IDyê reyi yo nemeqbul',
	'securepoll-header-voter-type' => 'tipa reydayoxi',
	'securepoll-voter-properties' => 'xususiyetê reydayoxi',
	'securepoll-strike-log' => 'rocaneyê xet antışi',
	'securepoll-header-action' => 'kar/gure',
	'securepoll-header-reason' => 'Sebep',
	'securepoll-header-admin' => 'serkar',
	'securepoll-cookie-dup-list' => 'karberê çerezi',
	'securepoll-dump-title' => 'belge: $1',
	'securepoll-dump-no-crypt' => 'qey no vıcinayişi, qeydê vıcinayişi yo şifrebiyayeyi çino, çunke eyar nêbo.',
	'securepoll-dump-not-finished' => 'qeydê vıcinayişi yo şifrebiyayeyi tena tarixê qediyayişi ey seet $1 ra heta $2 yo .',
	'securepoll-dump-no-urandom' => '/dêw/urandom a nêbeno.
qey idame kerdışi pinaniyê reydayoxi, eke pawıte bo a beno.',
	'securepoll-urandom-not-supported' => 'no pêşkeşwan amarê kriptografiki yo raştameye qebul nêkerdo.
qey idame kerdışi pinaniyê reydayoxi, eke pawıte bo a beno.',
	'securepoll-translate-title' => 'açarn: $1',
	'securepoll-invalid-language' => 'kodê zıwani yo nemeqbul "$1"',
	'securepoll-submit-translate' => 'rocane bıker',
	'securepoll-language-label' => 'zıwan bıvıcin:',
	'securepoll-submit-select-lang' => 'açarn',
	'securepoll-entry-text' => 'Binê de listeyê anketan estê.',
	'securepoll-header-title' => 'name',
	'securepoll-header-start-date' => 'tarixê destpêkerdışi',
	'securepoll-header-end-date' => 'tarixê qediyayişi',
	'securepoll-subpage-vote' => 'rey bıd.',
	'securepoll-subpage-translate' => 'açarn',
	'securepoll-subpage-list' => 'liste bıker',
	'securepoll-subpage-dump' => 'belge',
	'securepoll-subpage-tally' => 'amartış',
	'securepoll-tally-title' => 'amartış: $1',
	'securepoll-tally-not-finished' => 'ma meluli, heya reydayiş temam nêbo şıma nêeşkeni bıamari.',
	'securepoll-can-decrypt' => 'qeydê vıcinayişi şifre biyo labele kılitê ey mewcudo.',
	'securepoll-tally-no-key' => 'Bu seçimişıma nêşkeni nê reyan bıamari, çunke reyi şifre biyê u mefteyê deşifreyi mewcud niyo.',
	'securepoll-tally-local-legend' => 'neticeyê ke qeydbiyê bıamar.',
	'securepoll-tally-local-submit' => 'bıamar',
	'securepoll-tally-upload-legend' => 'ewraqo şifrebiyayeyi bar ker.',
	'securepoll-tally-upload-submit' => 'bıamar',
	'securepoll-tally-error' => 'qeydê reyi mışpre bene xeta vıraziya,',
	'securepoll-no-upload' => 'dosyayi bar nêbeni, neticeyi nêamariyeni',
	'securepoll-dump-corrupt' => 'dosyaya kombiyaye xerepnaye yo u pê kar nêbeno.',
	'securepoll-tally-upload-error' => 'amartışê dosyaya kombiyayeyan de xeta: $1',
	'securepoll-pairwise-victories' => 'matrisê dı zaferın',
	'securepoll-strength-matrix' => 'matrisê quwwetê rayi',
	'securepoll-ranks' => 'rêzkerdışa peyin',
	'securepoll-average-score' => 'Puanê miyanin',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'securepoll' => 'Wěste wótgłosowanje',
	'securepoll-desc' => 'Rozšyrjenje za wólby a napšašowanja',
	'securepoll-invalid-page' => 'Njepłaśiwy pódbok "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Musyš wólbny administrator byś, aby pśewjadł toś tu akciju.',
	'securepoll-too-few-params' => 'Nic dosć pódbokowych parametrow (njepłaśiwy wótkaz)',
	'securepoll-invalid-election' => '"$1" njejo płaśiwy wólbny ID.',
	'securepoll-welcome' => '<strong>Witaj $1!</strong>',
	'securepoll-not-started' => 'Toś ta wólba hyšći njejo se zachopiła.
Zachopijo nejskerjej $2 $3.',
	'securepoll-finished' => 'Toś ta wólba jo skóńcona, njamóžoš wěcej wótgłosowaś.',
	'securepoll-not-qualified' => 'Njejsy wopšawnjony w toś tej wólbje wótgłosowaś: $1',
	'securepoll-change-disallowed' => 'Sy južo wótgłosował w toś tej wólbje.
Njesmějoš hyšći raz wótgłosowaś.',
	'securepoll-change-allowed' => '<strong>Pokazka: Sy južo wótgłosował w toś tej wólbje.</strong>
Móžoš swój głos změniś, z tym až wótpósćelaš slědujucy formular.
Źiwaj na to, až, jolic to cyniš, se twój original pśepišo.',
	'securepoll-submit' => 'Głos daś',
	'securepoll-gpg-receipt' => 'Źěkujomy se za wótgłosowanje.

Jolic coš, móžoš slědujuce wobkšuśenje ako dokład za swójo wótedaśe głosa wobchowaś:

<pre>$1</pre>',
	'securepoll-thanks' => 'Źěkujomy se, twój głos jo se zregistrěrował.',
	'securepoll-return' => 'Slědk k $1',
	'securepoll-encrypt-error' => 'Twóje wótgłosowańske zapise njejsu se dali koděrowaś.
Twój głos njejo se składował!

$1',
	'securepoll-no-gpg-home' => 'Domacny zapis GPG njedajo se napóraś.',
	'securepoll-secret-gpg-error' => 'Zmólka pśi wuwjeźenju GPG.
Wužyj $wgSecurePollShowErrorDetail=true; w LocalSettings.php, aby pokazał dalšne drobnostki.',
	'securepoll-full-gpg-error' => 'Zmólka pśi wuwjeźenju GPG:

Pśikaz: $1

Zmólka:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-kluce su wopak konfigurěrowane.',
	'securepoll-gpg-parse-error' => 'Zmólka pśi interpretěrowanju wudaśa GPG.',
	'securepoll-no-decryption-key' => 'Dešifrěrowański kluc njejo konfigurěrowany.
Njejo móžno dešifrěrowaś.',
	'securepoll-jump' => 'K serweroju wótgłosowanja',
	'securepoll-bad-ballot-submission' => 'Twój głos jo njepłaśiwy był: $1',
	'securepoll-unanswered-questions' => 'Musyš na wše pšašanja wótegroniś.',
	'securepoll-invalid-rank' => 'Njepłaśiwe pódaśe pozicije. Dejš kandidatam poziciju mjazy 1 a 999 daś.',
	'securepoll-unranked-options' => 'Někotare opcije njamaju pódaśe pozicije.
Dejš wšyknym opcijam pódaśe pozicije mjazy 1 a 999 daś.',
	'securepoll-invalid-score' => 'Wuslědk musy licba mjazy $1 a $2 byś.',
	'securepoll-unanswered-options' => 'Musyš na kužde pšašanje wótegroniś.',
	'securepoll-remote-auth-error' => 'Zmólka pśi wótwołowanju twójich kontowych informacijow ze serwera.',
	'securepoll-remote-parse-error' => 'Zmólka pśi interpretěrowanju awtorizěrowańskego wótegrona serwera.',
	'securepoll-api-invalid-params' => 'Njepłaśiwe parametry.',
	'securepoll-api-no-user' => 'Wužywaŕ z pódanym ID njejo.',
	'securepoll-api-token-mismatch' => 'Wěstotnej tokena se njemakajotej, pśizjawjenje njemóžno.',
	'securepoll-not-logged-in' => 'Musyš se pśizjawiś, aby w toś tej wólbje wótgłosował.',
	'securepoll-too-few-edits' => 'Wódaj, njamóžoš wótgłosowaś. Musyš nanejmjenjej $1 {{PLURAL:$1|změnu|změnje|změny|změnow}} cyniś, aby wótgłosował w toś tej wólbje, sy $2 cynił.',
	'securepoll-blocked' => 'Wódaj, njamóžoš w toś tej wólbje wótgłosowaś, jolic wobźěłowanje jo śi tuchylu zakazane.',
	'securepoll-bot' => 'Wódaj, konta z botoweju chórgojcku njesměju w toś tej wólbje wótgłosowaś.',
	'securepoll-not-in-group' => 'Jano cłonki kupki $1 mógu w toś tej wólbje wótgłosowaś.',
	'securepoll-not-in-list' => 'Wódaj, njejsy w lisćinje wužywarjow, kótarež su za wótgłosowanje w toś tej wólbje awtorizěrowane.',
	'securepoll-list-title' => 'Głose nalicyś: $1',
	'securepoll-header-timestamp' => 'Cas',
	'securepoll-header-voter-name' => 'Mě',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Identifikator wobglědowaka',
	'securepoll-header-cookie-dup' => 'Duplikat',
	'securepoll-header-strike' => 'Wušmarnuś',
	'securepoll-header-details' => 'Drobnostki',
	'securepoll-strike-button' => 'Wušmarnuś',
	'securepoll-unstrike-button' => 'Wušmarnjenje anulěrowaś',
	'securepoll-strike-reason' => 'Pśicyna:',
	'securepoll-strike-cancel' => 'Pśetergnuś',
	'securepoll-strike-error' => 'Zmólka pśi wušmarnjenju/anulěrowanju wušmarnjenja: $1',
	'securepoll-strike-token-mismatch' => 'Daty pósejźenja su se zgubili',
	'securepoll-details-link' => 'Drobnostki',
	'securepoll-details-title' => 'Wótgłosowańske drobnostki: #$1',
	'securepoll-invalid-vote' => '"$1" njejo płaśiwy wótgłosowański ID',
	'securepoll-header-voter-type' => 'Wólarski typ',
	'securepoll-voter-properties' => 'Kakosći wólarja',
	'securepoll-strike-log' => 'Protokol wušmarnjenjow',
	'securepoll-header-action' => 'Akcija',
	'securepoll-header-reason' => 'Pśicyna',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => 'Dwójne wužywarje z cookiejom',
	'securepoll-dump-title' => 'Wuśěg: $1',
	'securepoll-dump-no-crypt' => 'Skoděrowane wólbne zapise njestoje k dispoziciji, dokulaž wólba njejo konfigurěrowana, aby wužywała  skoděrowanje.',
	'securepoll-dump-not-finished' => 'Skóděrowane wólbne zapise stoje jano pó kóńcnem datumje $1 $2 k dispoziciji.',
	'securepoll-dump-no-urandom' => '/dev/urandom njedajo se wócyniś.
Aby zarucył šćit datow wólarja, skoděrowane wólbne zapise stoje jano zjawnje k dispoziciji, gaž daju se z wěsteju tšugu pśipadnych licbow měšaś.',
	'securepoll-urandom-not-supported' => 'Toś ten serwer njepódpěra kryptografiske napóranje pśipadnych licbow.
Aby se priwatnosć wólarja šćitała, skoděrowane wólbne datowe zapise stoje jano zjawnje k dispozciji, gaž daju se z wěsteju tšugu pśipadnych licbow měšaś.',
	'securepoll-translate-title' => 'Pśełožyś: $1',
	'securepoll-invalid-language' => 'Njepłaśiwy rěcny kod "$1"',
	'securepoll-submit-translate' => 'Aktualizěrowaś',
	'securepoll-language-label' => 'Rěc wubraś:',
	'securepoll-submit-select-lang' => 'Přełožyś',
	'securepoll-entry-text' => 'Dołojce jo lisćina wótgłosowanjow.',
	'securepoll-header-title' => 'Mě',
	'securepoll-header-start-date' => 'Zachopny datum',
	'securepoll-header-end-date' => 'Kóńcny datum',
	'securepoll-subpage-vote' => 'Wótgłosowaś',
	'securepoll-subpage-translate' => 'Pśełožyś',
	'securepoll-subpage-list' => 'Lisćina',
	'securepoll-subpage-dump' => 'Wuśěg',
	'securepoll-subpage-tally' => 'Licenje',
	'securepoll-tally-title' => 'Licenje: $1',
	'securepoll-tally-not-finished' => 'Wódaj, njamóžoš wólbu pśelicyś, až wótgłosowanje njejo skóńcone.',
	'securepoll-can-decrypt' => 'Wólbny zapis jo se skoděrował, ale dešifrěrowański kluc stoj k dispoziciji.
Móžoš pak wuslědki licyś, kótarež su w datowej bance pak skoděrowane wuslědki z nagrateje dataje.',
	'securepoll-tally-no-key' => 'Njamóžoš toś tu wólbu pśelicyś, dokulaž głose su skoděrowane a dešifrěrowański kluc njestoj k dispoziciji.',
	'securepoll-tally-local-legend' => 'Składowane wuslědki licyś',
	'securepoll-tally-local-submit' => 'Licenje napóraś',
	'securepoll-tally-upload-legend' => 'Skoděrowany wuśěg nagraś',
	'securepoll-tally-upload-submit' => 'Licenje napóraś',
	'securepoll-tally-error' => 'Zmólka pśi interpretěrowanju wótgłosowańskego zapisa, licenje njedajo se napóraś.',
	'securepoll-no-upload' => 'Žedna dataja nagrata, wuslědki njedaju se licyś.',
	'securepoll-dump-corrupt' => 'Dataja składowańskego wopśimjeśa jo wobškóźona a njedajo se pśeźěłaś.',
	'securepoll-tally-upload-error' => 'Zmólka pśi pśelicowanju dataje składowańskego wopśimjeśa: $1',
	'securepoll-pairwise-victories' => 'Matriks dobyśa pó dwěma',
	'securepoll-strength-matrix' => 'Matriks mócy drogi',
	'securepoll-ranks' => 'Kóńcny slědowy pórěd',
	'securepoll-average-score' => 'Pśerězne pógódnośenje',
);

/** Greek (Ελληνικά)
 * @author Assassingr
 * @author Badseed
 * @author Consta
 * @author Crazymadlover
 * @author Geraki
 * @author Omnipaedista
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Επέκταση για εκλογές και δημοσκοπήσεις',
	'securepoll-invalid-page' => 'Άκυρη υποσελίδα "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Πρέπει να είστε διαχειριστής εκλογών για να κάνετε αυτή την ενέργεια.',
	'securepoll-too-few-params' => 'Μη αρκετές παράμετροι υποσελίδας (άκυρος σύνδεσμος).',
	'securepoll-invalid-election' => '"$1" δεν είναι ένα αποδεκτό ID ψηφοφορίας.',
	'securepoll-welcome' => '<strong>Καλωσήρθατε $1!</strong>',
	'securepoll-not-started' => 'Η ψηφοφορία δεν έχει ξεκινήσει ακόμη.
Είναι προγραμματισμένη να ξεκινήσει στις $2 στις $3.',
	'securepoll-finished' => 'Αυτή η ψηφοφορία έχει τελειώσει, δεν μπορείτε πλέον να ψηφίσετε.',
	'securepoll-not-qualified' => 'Δεν καλύπτετε τα κριτήρια για να ψηφίσετε σε αυτή την ψηφοφορία: $1',
	'securepoll-change-disallowed' => 'Έχετε ψηφίσει προηγουμένως σε αυτή την ψηφοφορία.
Λυπούμαστε, δεν μπορείτε να ψηφίσετε ξανά.',
	'securepoll-change-allowed' => '<strong>Σημείωση: Έχετε ψηφίσει προηγουμένως σε αυτή την ψηφοφορία.</strong>
Μπορείτε να αλλάξετε την ψήφο σας αποστέλλοντας την φόρμα παρακάτω.
Λάβετε υπόψη ότι αν κάνετε αυτό, η αρχική ψήφος σας θα ακυρωθεί.',
	'securepoll-submit' => 'Καταχώρηση ψήφου',
	'securepoll-gpg-receipt' => 'Ευχαριστούμε που ψηφίσατε.

Αν επιθυμείτε, μπορείτε να διατηρήσετε την παρακάτω απόδειξη ως πειστήριο της ψήφου σας:

<pre>$1</pre>',
	'securepoll-thanks' => 'Ευχαριστούμε, η ψήφος σας καταγράφηκε.',
	'securepoll-return' => 'Επιστροφή στη σελίδα $1',
	'securepoll-encrypt-error' => 'Αποτυχία κρυπτογράφησης της εγγραφής ψήφου σας.
Η ψήφος σας δεν έχει καταγραφεί!

$1',
	'securepoll-no-gpg-home' => 'Αποτυχία δημιουργίας καταλόγου αρχείων του GPG.',
	'securepoll-secret-gpg-error' => 'Σφάλμα εκτέλεσης GPG. 
Χρησιμοποιήστε $wgSecurePollShowErrorDetail=true; στο LocalSettings.php για εμφάνιση περισσότερων λεπτομερειών.',
	'securepoll-full-gpg-error' => 'Σφάλμα εκτέλεσης GPG:

Εντολή: $1

Σφάλμα:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Τα κλειδιά GPG είναι ρυθμισμένα λανθασμένα.',
	'securepoll-gpg-parse-error' => 'Σφάλμα διερμηνείας εξόδου GPG.',
	'securepoll-no-decryption-key' => 'Δεν έχει ρυθμιστεί κλειδί αποκρυπτογράφησης.
Δεν είναι δυνατή η αποκρυπτογράφηση.',
	'securepoll-jump' => 'Μετάβαση στον διακομιστή ψηφοφορίας',
	'securepoll-bad-ballot-submission' => 'Η ψήφος σας ήταν άκυρη: $1',
	'securepoll-unanswered-questions' => 'Πρέπει να απαντήσετε σε όλες τις ερωτήσεις.',
	'securepoll-invalid-rank' => 'Εσφαλμένη κατάταξη. Πρέπει να δώσετε στους υποψηφίους μια κατάταξη μεταξύ 1 και 999.',
	'securepoll-unranked-options' => 'Ορισμένες επιλογές δεν κατατάχθηκαν.
Πρέπει να δώσετε σε όλες τις επιλογές μια κατάταξη μεταξύ 1 και 999.',
	'securepoll-remote-auth-error' => 'Σφάλμα κατά την ανάκτηση των πληροφοριών για τον λογαριασμό σας από τον διακομιστή.',
	'securepoll-remote-parse-error' => 'Σφάλμα στην ερμηνεία της απάντησης για άδεια πρόβασης από τον διακομιστή.',
	'securepoll-api-invalid-params' => 'Άκυρες παράμετροι.',
	'securepoll-api-no-user' => 'Δεν βρέθηκε χρήστης με το συγκεκριμένο ID.',
	'securepoll-api-token-mismatch' => 'Μη ταυτοποίηση κουπονιού ασφαλείας, δεν μπορείτε να συνδεθείτε.',
	'securepoll-not-logged-in' => 'Πρέπει να συνδεθείτε για να ψηφίσετε σε αυτές τις εκλογές',
	'securepoll-too-few-edits' => 'Λυπούμαστε, δεν μπορείτε να ψηφίσετε. Χρειάζεται να έχετε κάνει τουλάχιστον $1 {{PLURAL:$1|επεξεργασία|επεξεργασίες}} για να ψηφίσετε σε αυτή την ψηφοφορία, έχετε κάνει $2.',
	'securepoll-blocked' => 'Λυπούμαστε, δεν μπορείτε να ψηφίσετε σε αυτή την ψηφοφορία αν είστε επί του παρόντος υπό φραγή από την επεξεργασία.',
	'securepoll-bot' => 'Λυπούμαστε, οι λογαριασμοί με ιδιότητα bot δεν επιτρέπεται να ψηφίσουν σε αυτήν την ψηφοφορία.',
	'securepoll-not-in-group' => "Μόνο τα μέλη της ομάδας $1 μπορούν να ψηφίσουν σ' αυτές τις εκλογές.",
	'securepoll-not-in-list' => 'Λυπούμαστε, αλλά δεν βρίσκεστε στην προκαθορισμένη λίστα χρηστών που επιτρέπεται να ψηφίσουν στις εκλογές αυτές.',
	'securepoll-list-title' => 'Λίστα ψήφων: $1',
	'securepoll-header-timestamp' => 'Ώρα',
	'securepoll-header-voter-name' => 'Όνομα',
	'securepoll-header-voter-domain' => 'Περιοχή',
	'securepoll-header-ua' => 'Αντιπρόσωπος χρήστη',
	'securepoll-header-cookie-dup' => 'Διπλότυπες',
	'securepoll-header-strike' => 'Διαγραφή',
	'securepoll-header-details' => 'Λεπτομέρειες',
	'securepoll-strike-button' => 'Διαγραφή',
	'securepoll-unstrike-button' => 'Αναίρεση διαγραφής',
	'securepoll-strike-reason' => 'Λόγος:',
	'securepoll-strike-cancel' => 'Άκυρο',
	'securepoll-strike-error' => 'Σφάλμα κατά τη διαγραφή/την αναίρεση διαγραφής: $1',
	'securepoll-strike-token-mismatch' => 'Χάθηκαν τα δεδομένα συνεδρίας',
	'securepoll-details-link' => 'Λεπτομέρειες',
	'securepoll-details-title' => 'Λεπτομέρειες ψήφου: #$1',
	'securepoll-invalid-vote' => 'Το "$1" δεν είναι έγκυρο ID ψήφου',
	'securepoll-header-voter-type' => 'Τύπος ψηφοφόρου',
	'securepoll-voter-properties' => 'Ιδιότητες ψηφοφόρου',
	'securepoll-strike-log' => 'Καταγραφές διαγραφών',
	'securepoll-header-action' => 'Ενέργεια',
	'securepoll-header-reason' => 'Λόγος',
	'securepoll-header-admin' => 'Διαχειριστής',
	'securepoll-cookie-dup-list' => 'Χρήστες που έχουν διπλότυπο cookie',
	'securepoll-dump-title' => 'Αποτύπωση: $1',
	'securepoll-dump-no-crypt' => 'Κανένα κρυπτογραφημένο εκλογικό αρχείο δεν είναι διαθέσιμο για αυτήν την εκλογή, επειδή αυτή δεν είναι ρυθμισμένη για χρήση κρυπτογράφησης.',
	'securepoll-dump-not-finished' => 'Τα κρυπτογραφημένα αρχεία των εκλογών θα είναι μόνο διαθέσιμα μετά την τελευταία μέρα της ψηφοφορίας την $1 στις $2',
	'securepoll-dump-no-urandom' => 'Αδύνατο το άνοιγμα του /dev/urandom.  
Για να διατηρηθεί η ιδιωτικότητα των ψηφοφόρων, οι κρυπτογραφημένες εγγραφές της ψηφοφορίας γίνονται δημόσια διαθέσιμες μόνο όταν μπορούν να ανακατευτούν με μια ασφαλή ακολουθία τυχαίων αριθμών.',
	'securepoll-urandom-not-supported' => 'Αυτός ο διακομιστής δεν υποστηρίζει την κρυπτογραφικά ασφαλή παραγωγή τυχαίων αριθμών. Για να διατηρηθεί η ιδιωτικότητα των ψηφοφόρων, οι κρυπτογραφημένες εγγραφές γίνονται δημόσια διαθέσιμες μόνο όταν μπορούν να ανακατευτούν με μία ασφαλή ακολουθία τυχαίων αριθμών.',
	'securepoll-translate-title' => 'Μετάφραση: $1',
	'securepoll-invalid-language' => 'Άκυρος κώδικας γλώσσας "$1"',
	'securepoll-submit-translate' => 'Ενημέρωση',
	'securepoll-language-label' => 'Επιλογή γλώσσας:',
	'securepoll-submit-select-lang' => 'Μετάφραση',
	'securepoll-entry-text' => 'Παρακάτω είναι η λίστα των δημοσκοπήσεων.',
	'securepoll-header-title' => 'Όνομα',
	'securepoll-header-start-date' => 'Ημερομηνία έναρξης',
	'securepoll-header-end-date' => 'Ημερομηνία λήξης',
	'securepoll-subpage-vote' => 'Ψηφοφορία',
	'securepoll-subpage-translate' => 'Μετάφραση',
	'securepoll-subpage-list' => 'Λίστα',
	'securepoll-subpage-dump' => 'Αποτύπωση',
	'securepoll-subpage-tally' => 'Καταμέτρηση',
	'securepoll-tally-title' => 'Καταμέτρηση: $1',
	'securepoll-tally-not-finished' => 'Λυπούμαστε, δεν είναι δυνατή η καταμέτρηση των ψήφων μέχρι να ολοκληρωθεί η ψηφοφορία.',
	'securepoll-can-decrypt' => 'Η εγγραφή ψηφοφορίας έχει κρυποτογραφηθεί, αλλά το κλειδί αποκρυπτογράφησης είναι διαθέσιμο.  
Μπορείτε να επιλέξετε είτε να καταμετρήσετε τα αποτελέσματα που υπάρχουν στη βάση δεδομένων ή να καταμετρήσετε κρυπτογραφημένα αποτελέσματα από ένα επιφορτωμένο αρχείο.',
	'securepoll-tally-no-key' => 'Δεν μπορείτε να καταμετρήσετε τις ψήφους σε αυτές τις εκλογές διότι οι ψήφοι είναι κρυπτογραφημένες και το κλειδί αποκρυπτογράφησης δεν είναι διαθέσιμο.',
	'securepoll-tally-local-legend' => 'Καταμέτρηση αποθηκευμένων αποτελεσμάτων',
	'securepoll-tally-local-submit' => 'Δημιουργία καταμέτρησης',
	'securepoll-tally-upload-legend' => 'Επιφόρτωση κρυπτογραφημένου αρχείου ψήφων',
	'securepoll-tally-upload-submit' => 'Δημιουργία καταμέτρησης',
	'securepoll-tally-error' => 'Σφάλμα κατά την ερμηνεία του αρχείου ψήφων· αδύνατη η καταμέτρηση.',
	'securepoll-no-upload' => 'Κανένα αρχείο δεν επιφορτίστηκε· τα αποτελέσματα δεν μπορούν να καταμετρηθούν',
	'securepoll-dump-corrupt' => 'Το αρχείο ψήφων είναι κατεστραμμένο και δεν μπορεί να υποστεί επεξεργασία.',
	'securepoll-tally-upload-error' => 'Σφάλμα στην καταμέτρηση του αρχείου ψήφων: $1',
	'securepoll-pairwise-victories' => 'Πίνακας νικών ανά ζεύγος',
	'securepoll-strength-matrix' => 'Πίνακας ισχύος διαδρομών',
	'securepoll-ranks' => 'Τελική κατάταξη',
	'securepoll-average-score' => 'Μέσο σκορ',
);

/** Esperanto (Esperanto)
 * @author ArnoLagrange
 * @author Marcos
 * @author Yekrats
 */
$messages['eo'] = array(
	'securepoll' => 'Sekura Enketo',
	'securepoll-desc' => 'Kromprogramo por voĉdonadoj kaj enketoj',
	'securepoll-invalid-page' => 'Nevalida subpaĝo "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Vi devas esti voĉdona administranto por fari ĉi tiun agon.',
	'securepoll-too-few-params' => 'Ne sufiĉaj subpaĝaj parametroj (nevalida ligilo).',
	'securepoll-invalid-election' => '"$1" ne estas valida voĉdonada identigo.',
	'securepoll-welcome' => '<strong>Bonvenon, $1!</strong>',
	'securepoll-not-started' => 'Ĉi tiu voĉdonado ne jam pretas.
Ĝi estos komencata je $2, $3.',
	'securepoll-finished' => 'Ĉi tiu voĉdono estas finita; vi ne plu povas voĉdoni.',
	'securepoll-not-qualified' => 'Vi ne rajtas voĉdoni en ĉi tiu voĉdonado: $1',
	'securepoll-change-disallowed' => 'Vi antaŭe voĉdonis en ĉi tiu voĉdonado.
Bedaŭrinde vi ne rajtas revoĉdoni.',
	'securepoll-change-allowed' => '<strong>Notu: Vi voĉdonis en ĉi tiu voĉdonado antaŭe.</strong>
Vi povas ŝanĝi vian voĉdonon de sendi la jenan formularon.
Notu, ke se vi farus ĉi tiel, via originala voĉdono estos forviŝita.',
	'securepoll-submit' => 'Enmeti voĉdonon',
	'securepoll-gpg-receipt' => 'Dankon por via voĉdono.

Laŭvole, vi povas konservi la jenan konfirmon de via voĉdono:

<pre>$1</pre>',
	'securepoll-thanks' => 'Dankon, via voĉdono estis registrita.',
	'securepoll-return' => 'Reiri al $1',
	'securepoll-encrypt-error' => 'Malsukcesis enĉifri vian voĉdonan rekordon.
Via voĉdono ne estis rekordita!

$1',
	'securepoll-no-gpg-home' => 'Ne eblas krei GPG hejman dosierujon.',
	'securepoll-secret-gpg-error' => 'Eraro funkciigante GPG.
Uzu $wgSecurePollShowErrorDetail=true; en LocalSettings.php por montri pliajn detalojn.',
	'securepoll-full-gpg-error' => 'Eraro funkciigante GPG:

Komando: $1

Eraro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-ŝlosiloj estas konfiguritaj malĝuste.',
	'securepoll-gpg-parse-error' => 'Eraro interpretante GPG-eligon.',
	'securepoll-no-decryption-key' => 'Neniu malĉifra ŝlosilo estas konfigurita.
Ne eblas malĉifri.',
	'securepoll-jump' => 'Iri al la voĉdona servilo',
	'securepoll-bad-ballot-submission' => 'Via voĉdono estis malvalida: $1',
	'securepoll-unanswered-questions' => 'Vi devas respondi al ĉiuj demandoj.',
	'securepoll-invalid-rank' => 'Nevalida loko. Vi devas doni al kandidatoj lokon inter 1 kaj 999.',
	'securepoll-unranked-options' => 'Kelkaj opcioj ne estis ordigitaj. 
Vi devas doni al ĉiuj opcioj lokon inter 1 kaj 999.',
	'securepoll-invalid-score' => 'La poentaro devas esti nombro inter $1 kaj $2.',
	'securepoll-unanswered-options' => 'Vi devas respondi ĉiun demandon.',
	'securepoll-remote-auth-error' => 'Eraro akirante vian kontinformon de la servilo.',
	'securepoll-remote-parse-error' => 'Eraro interpretante la aŭtoritadan respondon de la servilo.',
	'securepoll-api-invalid-params' => 'Malvalidaj parametroj.',
	'securepoll-api-no-user' => 'Neniu uzanto estis trovita kun tiu identigo.',
	'securepoll-api-token-mismatch' => 'Nekongrua sekurecmarkilo. Neeblas ensaluti.',
	'securepoll-not-logged-in' => 'Vi devas ensaluti por voĉdoni en ĉi tiu voĉdonado',
	'securepoll-too-few-edits' => 'Bedaŭrinde, vi ne povas voĉdoni. Vi nepre havas almenaŭ $1 {{PLURAL:$1|redakto|redaktoj}} por voĉdoni en ĉi tiu voĉdonado; vi faris $2 redaktojn.',
	'securepoll-blocked' => 'Bedaŭrinde, vi ne povas voĉdoni en ĉi tiu voĉdonado se vi nune estas forbarita de redaktado.',
	'securepoll-bot' => 'Bedaŭrinde, kontoj kun la robotflago nen estas permesata voĉdoni en ĉi tiu voĉdonado.',
	'securepoll-not-in-group' => 'Nur membroj de la grupo "$1" povas voĉdoni en ĉi tiu elekto.',
	'securepoll-not-in-list' => 'Bedaŭrinde, vi ne estas unu el la antaŭdetermitaj uzantoj kiuj estas permesitaj voĉdoni dum ĉi tiu voĉdono.',
	'securepoll-list-title' => 'Listigi voĉdonojn: $1',
	'securepoll-header-timestamp' => 'Tempo',
	'securepoll-header-voter-name' => 'Nomo',
	'securepoll-header-voter-domain' => 'Domajno',
	'securepoll-header-ua' => 'Klienta aplikaĵo',
	'securepoll-header-cookie-dup' => 'Duplikato',
	'securepoll-header-strike' => 'Forstreki',
	'securepoll-header-details' => 'Detaloj',
	'securepoll-strike-button' => 'Forstreki',
	'securepoll-unstrike-button' => 'Malforstreki',
	'securepoll-strike-reason' => 'Kialo:',
	'securepoll-strike-cancel' => 'Nuligi',
	'securepoll-strike-error' => 'Eraro farante forstrekadon/malforstrekadon: $1',
	'securepoll-strike-token-mismatch' => 'Sesiaj datenoj perditaj',
	'securepoll-details-link' => 'Detaloj',
	'securepoll-details-title' => 'Detaloj de voĉdono: #$1',
	'securepoll-invalid-vote' => '"$1" ne estas valida voĉdona identigo',
	'securepoll-header-voter-type' => 'Speco de voĉdonanto',
	'securepoll-voter-properties' => 'Atribuoj de voĉdonantoj',
	'securepoll-strike-log' => 'Protokolo pri forstrekado',
	'securepoll-header-action' => 'Ago',
	'securepoll-header-reason' => 'Kialo',
	'securepoll-header-admin' => 'Administranto',
	'securepoll-cookie-dup-list' => 'Uzi seancan kuketon por duplikataj uzantoj',
	'securepoll-dump-title' => 'Elŝuto: $1',
	'securepoll-dump-no-crypt' => 'Neniu ĉifrita registraĵo havebla por tiu ĉi baloto, ĉar la baloto ne estas aranĝita por uzi ĉifradon.',
	'securepoll-dump-not-finished' => 'Ĉifrita registraĵo estos havebla por tiu ĉi baloto nur post la findato $1 je $2',
	'securepoll-dump-no-urandom' => 'Ne eblas malfermi /dev/urandom
Por garantii privatecon de balotinto, ĉifrita balotregistraĵo estas publike havebla nur kiam ĝi povas esti malnetigita per sekura hazarda nombrofluo.',
	'securepoll-urandom-not-supported' => 'Ĉi tiu servilo ne eltenas generadon de ĉifrhazardnombroj. 
Por garantii privatecon de balotinto, ĉifrita balotregistraĵo estas publike havebla nur kiam ĝi povas esti malnetigita per sekura hazarda nombrofluo.',
	'securepoll-translate-title' => 'Traduki: $1',
	'securepoll-invalid-language' => 'Malvalida lingva kodo "$1"',
	'securepoll-submit-translate' => 'Ĝisdatigi',
	'securepoll-language-label' => 'Elekti lingvon:',
	'securepoll-submit-select-lang' => 'Traduki',
	'securepoll-entry-text' => 'Jen listo de opinisondoj',
	'securepoll-header-title' => 'Nomo',
	'securepoll-header-start-date' => 'Komenca dato',
	'securepoll-header-end-date' => 'Fina dato',
	'securepoll-subpage-vote' => 'Voĉdono',
	'securepoll-subpage-translate' => 'Traduki',
	'securepoll-subpage-list' => 'Listigi',
	'securepoll-subpage-dump' => 'Elŝuto',
	'securepoll-subpage-tally' => 'Kalkuli',
	'securepoll-tally-title' => 'Kalkulo: $1',
	'securepoll-tally-not-finished' => 'Bedaŭrinde vi ne povas kalkuli la voĉdonado ĝis post voĉdonado finas.',
	'securepoll-can-decrypt' => 'La balotregistraĵo estis ĉifita, sed la malĉifra ŝlosilo haveblas.
Vi povas elekti nombri ĉu la rezultojn el la datumbazo, ĉu ĉifritajn rezultojn el elŝutita dosiero.',
	'securepoll-tally-no-key' => 'Vi ne povas nombri la rezulton de ĉi tiu baloto, ĉar ĝi estas ĉifrita kaj la malĉifra ŝlosilo malhaveblas.',
	'securepoll-tally-local-legend' => 'Konservitaj nombrorezultoj',
	'securepoll-tally-local-submit' => 'Krei nombradon',
	'securepoll-tally-upload-legend' => 'Elŝuti ĉifritan dosieron',
	'securepoll-tally-upload-submit' => 'Krei nombradon',
	'securepoll-tally-error' => 'Eraro dum interpretado de balotregistraĵo, ne eblas krei nombradon.',
	'securepoll-no-upload' => 'Neniu dosiero estis elŝutita, ne eblas nombri rezulton.',
	'securepoll-dump-corrupt' => 'La elŝutdosiero estas difektita kaj ne povas esti traktita.',
	'securepoll-tally-upload-error' => 'Eraro dum nombrado de elŝutdosiero: $1',
	'securepoll-pairwise-victories' => 'Matrico de paraj venkoj',
	'securepoll-strength-matrix' => 'Matrico de vojforteco',
	'securepoll-ranks' => 'Fina rangigo',
	'securepoll-average-score' => 'Averaĝa poentaro',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author DoveBirkoff
 * @author Galio
 * @author Góngora
 * @author Imre
 * @author Remember the dot
 * @author Translationista
 */
$messages['es'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Extensiones para elecciones y encuentas',
	'securepoll-invalid-page' => 'Subpágina inválida "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Necesitas ser un administrador de elecciones para realizar esta acción.',
	'securepoll-too-few-params' => 'Parámetros de subpágina insuficientes (vínculo inválido).',
	'securepoll-invalid-election' => '"$1" no es un identificador de elección valido.',
	'securepoll-welcome' => '<strong>¡Bienvenido $1!</strong>',
	'securepoll-not-started' => 'Esta elección aún no ha comenzado.
Está programada de comenzar en $2 de $3.',
	'securepoll-finished' => 'Esta elección ha concluido, no puedes votar más.',
	'securepoll-not-qualified' => 'No cumples los requisitos para votar en esta elección: $1',
	'securepoll-change-disallowed' => 'Ya has votado antes en esta elección.
Lo siento, no puede votar de nuevo.',
	'securepoll-change-allowed' => '<strong>Nota: Has votado en esta elección antes.</strong>
Puedes cambiar tu voto enviando el formulario de abajo.
Nota que si haces esto, tu voto original será descartado.',
	'securepoll-submit' => 'Enviar voto',
	'securepoll-gpg-receipt' => 'Gracias por votar.

Si deseas, puedes retener el siguiente comprobante como evidencia de tu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Gracias, tu voto ha sido guardado.',
	'securepoll-return' => 'Retornar a $1',
	'securepoll-encrypt-error' => 'Fracasaste en encriptar tu registro de voto.
¡Tu voto no ha sido registrado!

$1',
	'securepoll-no-gpg-home' => 'Imposible crear un directorio hogar GPG.',
	'securepoll-secret-gpg-error' => 'Error ejecutando GPG.
Usar $wgSecurePollShowErrorDetail=true; en LocalSettings.php para mostrar más detalle.',
	'securepoll-full-gpg-error' => 'Error ejecutando GPG:

Comando: $1

Error:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Teclas GPG están configuradas incorrectamente.',
	'securepoll-gpg-parse-error' => 'Error interpretando salida GPG.',
	'securepoll-no-decryption-key' => 'No se ha especificado ninguna clave de desencriptación.
No se puede desencriptar.',
	'securepoll-jump' => 'Ir al servidor de votación',
	'securepoll-bad-ballot-submission' => 'Tu voto fue inválido: $1',
	'securepoll-unanswered-questions' => 'Debes responder todas las preguntas.',
	'securepoll-invalid-rank' => 'Rango inválido. Debes clasificar a los candidatos con un rango entre 1 y 999.',
	'securepoll-unranked-options' => 'Algunas opciones no fueron clasificadas.
Debes clasificar a todas las opciones con un rango entre 1 y 999.',
	'securepoll-invalid-score' => 'La puntuación debe ser un valor entre $1 y $2.',
	'securepoll-unanswered-options' => 'Debes dar una respuesta a cada pregunta.',
	'securepoll-remote-auth-error' => 'Se ha producido un error al obtener su información de cuenta del servidor.',
	'securepoll-remote-parse-error' => 'Se ha producido un error al interpretar la respuesta de autorización del servidor.',
	'securepoll-api-invalid-params' => 'Parámetros inválidos.',
	'securepoll-api-no-user' => 'Ningún usuario fue encontrado con el ID dado.',
	'securepoll-api-token-mismatch' => 'Clave de seguridad no coincidente, no se puede iniciar sesión.',
	'securepoll-not-logged-in' => 'Debes iniciar sesión para votar en esta elección',
	'securepoll-too-few-edits' => 'Perdón, no puedes votar. Necesitas haber hecho al menos $1 {{PLURAL:$1|edición|ediciones}} para votar en esta elección, has hecho $2.',
	'securepoll-blocked' => 'Perdón, no puedes votar en esta elección si estás actualmente bloqueado para ediciones.',
	'securepoll-bot' => 'Lo sentimos, las cuentas con flag de bot no están autorizadas a votar en esta elección.',
	'securepoll-not-in-group' => 'Solamente mimbros del grupo $1 pueden votar en esta elección.',
	'securepoll-not-in-list' => 'Perdón, no estás en el lista predetermindad de usuarios autorizados a votar en esta elección.',
	'securepoll-list-title' => 'Lista votos: $1',
	'securepoll-header-timestamp' => 'Tiempo',
	'securepoll-header-voter-name' => 'Nombre',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Agente de usuario',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Tachar',
	'securepoll-header-details' => 'Detalles',
	'securepoll-strike-button' => 'Trachar',
	'securepoll-unstrike-button' => 'Validar',
	'securepoll-strike-reason' => 'Razón:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-strike-error' => 'Se ha producido un error al invalidar/validar: $1',
	'securepoll-strike-token-mismatch' => 'Pérdida de información de la sesión',
	'securepoll-details-link' => 'Detalles',
	'securepoll-details-title' => 'Detalles de voto: #$1',
	'securepoll-invalid-vote' => '"$1" no es una identidad de voto válida',
	'securepoll-header-voter-type' => 'Tipo de votante',
	'securepoll-voter-properties' => 'Propiedades de votante',
	'securepoll-strike-log' => 'Registro de votos invalidados',
	'securepoll-header-action' => 'Acción',
	'securepoll-header-reason' => 'Razón',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-cookie-dup-list' => 'Usuarios con cookies duplicadas',
	'securepoll-dump-title' => 'Volcado: $1',
	'securepoll-dump-no-crypt' => 'No se dispone de un registro encriptado para esta votación dado que esta votación no ha sido configurada para usar encriptación.',
	'securepoll-dump-not-finished' => 'Los registros encriptados de la votación están únicamente disponibles después de la fecha de finalización en $1 de $2',
	'securepoll-dump-no-urandom' => 'Imposible abrir /dev/urandom.
Para preservar la privacidad de los votantes, sólo son publicados los resultados encriptados de la elección cuando pueden ser mezclados con un flujo de números aleatorio.',
	'securepoll-urandom-not-supported' => 'Este servidor no posee capacidad de generación criptográfica de números aleatorios.
Para preservar la privacidad de los votantes, sólo son publicados los resultados encriptados de la elección cuando pueden ser mezclados con un flujo de números aleatorio.',
	'securepoll-translate-title' => 'Traducir: $1',
	'securepoll-invalid-language' => 'Código de lenguaje inválido "$1"',
	'securepoll-submit-translate' => 'Actualizar',
	'securepoll-language-label' => 'Seleccionar lenguaje:',
	'securepoll-submit-select-lang' => 'Traducir',
	'securepoll-entry-text' => 'Debajo está la lista de encuestas.',
	'securepoll-header-title' => 'Nombre',
	'securepoll-header-start-date' => 'Fecha de comienzo',
	'securepoll-header-end-date' => 'Fecha de término',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traducir',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Volcar',
	'securepoll-subpage-tally' => 'Contador',
	'securepoll-tally-title' => 'Contador: $1',
	'securepoll-tally-not-finished' => 'Lo sentimos, no puede actualizar los contadores de la elección hasta que la votación no haya finalizado.',
	'securepoll-can-decrypt' => 'El registro de elección ha sido encriptado pero la clave de desencriptación está disponible.
Puede escoger entre escrutar los resultados de la base de datos, o escrutar los resultados encriptados desde un fichero subido.',
	'securepoll-tally-no-key' => 'No puede actualizar el contador de la elección, debido a que los votos están encriptados y la clave de desencriptación no está disponible.',
	'securepoll-tally-local-legend' => 'Cuenta de resultados actualizada',
	'securepoll-tally-local-submit' => 'Crear cuenta',
	'securepoll-tally-upload-legend' => 'Subir dump encriptado',
	'securepoll-tally-upload-submit' => 'Crear cuenta',
	'securepoll-tally-error' => 'Se ha producido un error interpretando el registro de votos, no se puede crear un contador.',
	'securepoll-no-upload' => 'No se ha subido ningún fichero, no se pueden contar los resultados.',
	'securepoll-dump-corrupt' => 'El archivo volcado se encuentra dañado y no puede ser procesado.',
	'securepoll-tally-upload-error' => 'Error al contar el archivo volcado: $1',
	'securepoll-pairwise-victories' => 'Resultados de las encuestas en este sitio',
	'securepoll-strength-matrix' => 'Organizar por cantidad de encuestas',
	'securepoll-ranks' => 'Rango final',
	'securepoll-average-score' => 'Puntuación media',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author WikedKentaur
 */
$messages['et'] = array(
	'securepoll' => 'Turvahääletus',
	'securepoll-desc' => 'Hääletuste ja küsitluste laiendus',
	'securepoll-invalid-page' => 'Vigane alamlehekülg "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Selle tegevuse sooritamiseks pead sa olema valimise ülem.',
	'securepoll-too-few-params' => 'Alamlehekülg on puudulikult kirjeldatud (vigane link).',
	'securepoll-invalid-election' => '"$1" pole õige hääletus-ID.',
	'securepoll-welcome' => '<strong>Tere tulemast $1!</strong>',
	'securepoll-not-started' => 'Hääletus pole veel alanud.
See algab $2 kell $3.',
	'securepoll-finished' => 'Hääletus on lõppenud, enam ei saa hääletada.',
	'securepoll-not-qualified' => 'Sa ei ole kvalifitseerunud siin valimistel hääletama: $1',
	'securepoll-change-disallowed' => 'Sa oled oma hääle juba andnud.
Teistkorda hääletada ei saa.',
	'securepoll-change-allowed' => '<strong>Teade: Sa oled oma hääle juba andnud.</strong>
Sa võid allpool oma antud häält muuta.
Kui sa seda teed, siis sinu eelmine hääl tühistub.',
	'securepoll-submit' => 'Hääleta',
	'securepoll-gpg-receipt' => 'Täname hääletamast.

Soovi korral võid talletada järgneva kinnituse antud hääle kohta:

<pre>$1</pre>',
	'securepoll-thanks' => 'Täname, sinu hääl on talletatud.',
	'securepoll-return' => 'Pöördu tagasi $1',
	'securepoll-encrypt-error' => 'Sinu antud hääle andmeid ei õnnestunud krüpteerida.
Sinu häält pole talletatud!

$1',
	'securepoll-no-gpg-home' => 'GPG-kodukataloogi ei saa luua.',
	'securepoll-secret-gpg-error' => 'Tõrge GPG täitmisel.
Üksikasjade jaoks kasuta $wgSecurePollShowErrorDetail=true failis LocalSettings.php.',
	'securepoll-full-gpg-error' => 'Tõrge GPG täitmisel.

Käsk: $1

Tõrge:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-võtmed on valesti üles seatud.',
	'securepoll-no-decryption-key' => 'Dekrüptimise võtit ei ole valmis seatud.
Ei saa dekrüptida.',
	'securepoll-jump' => 'Mine hääletamise serverisse',
	'securepoll-bad-ballot-submission' => 'Sinu hääl oli vigane: $1',
	'securepoll-unanswered-questions' => 'Vastata tuleb kõigile küsimustele.',
	'securepoll-unanswered-options' => 'Pead kõigile küsimustele vastama.',
	'securepoll-remote-auth-error' => 'Tõrge serverist sinu andmete saamisel.',
	'securepoll-remote-parse-error' => 'Tõrge serverist saadud volitusvastuse tõlgendamisel.',
	'securepoll-api-invalid-params' => 'Vigased parameetrid.',
	'securepoll-api-no-user' => 'Etteantud ID-ga kasutajat ei leidu.',
	'securepoll-api-token-mismatch' => 'Turvatunnus ei klapi, ei saa sisse logida.',
	'securepoll-not-logged-in' => 'Hääletamiseks pead olema sisse logitud.',
	'securepoll-too-few-edits' => 'Sa ei saa hääletada. Hääletamiseks pead olema teinud vähemalt $1 {{PLURAL:$1|muudatuse|muudatust}}. Oled teinud $2.',
	'securepoll-blocked' => 'Vabandust, sa ei saa hääletada, kui oled hetkel blokeeritud.',
	'securepoll-bot' => 'Vabandust, boti staatusega kontod ei saa hääletada neil valimistel.',
	'securepoll-not-in-group' => 'Ainult rühma $1 liikmed saavad hääletada neil valimistel.',
	'securepoll-not-in-list' => 'Sa ei ole sellel hääletusel osalema volitatud kasutajate nimekirjas.',
	'securepoll-list-title' => 'Häälte loend: $1',
	'securepoll-header-timestamp' => 'Aeg',
	'securepoll-header-voter-name' => 'Nimi',
	'securepoll-header-voter-domain' => 'Domeen',
	'securepoll-header-strike' => 'Mahatõmbamine',
	'securepoll-header-details' => 'Üksikasjad',
	'securepoll-strike-button' => 'Tõmba maha',
	'securepoll-unstrike-button' => 'Tühista mahatõmbamine',
	'securepoll-strike-reason' => 'Põhjus:',
	'securepoll-strike-cancel' => 'Loobu',
	'securepoll-strike-error' => 'Tõrge mahatõmbamisel või mahatõmbamise tühistamisel: $1',
	'securepoll-strike-token-mismatch' => 'Seansiandmed kaotsiläinud',
	'securepoll-details-link' => 'Üksikasjad',
	'securepoll-details-title' => 'Hääletuse andmed: #$1',
	'securepoll-invalid-vote' => '"$1" pole õige hääle-ID.',
	'securepoll-header-voter-type' => 'Hääletajatüüp',
	'securepoll-voter-properties' => 'Hääletaja omadused',
	'securepoll-strike-log' => 'Mahatõmbamislogi',
	'securepoll-header-action' => 'Toiming',
	'securepoll-header-reason' => 'Põhjus',
	'securepoll-header-admin' => 'Administraator',
	'securepoll-cookie-dup-list' => 'Sama küpsisega kasutajad',
	'securepoll-dump-title' => 'Tõmmis: $1',
	'securepoll-dump-no-crypt' => 'Selle valimise kohta ei ole krüptitud valimiskirjet saadaval, sest valimine ei ole seatud krüptimist kasutama.',
	'securepoll-dump-not-finished' => 'Krüptitud valimiskirje on saadaval alles pärast valimise lõppu $1 kell $2',
	'securepoll-dump-no-urandom' => 'Toimingut /dev/urandom ei saa avada.
Hääletaja privaatsuse säilitamiseks on krüptitud valimiskirjed avalikult saadaval vaid siis, kui neid on võimalik turvalise juhusliku numbrivooga segi ajada.',
	'securepoll-urandom-not-supported' => 'See server ei toeta juhusliku krüptograafilise numbri tekitamist. Hääletaja privaatsuse säilitamiseks on krüptitud valimiskirjed avalikult saadaval vaid siis, kui neid on võimalik turvalise juhusliku numbrivooga segi ajada.',
	'securepoll-translate-title' => 'Tõlkimine: $1',
	'securepoll-invalid-language' => 'Vigane keelekood  "$1"',
	'securepoll-submit-translate' => 'Uuenda',
	'securepoll-language-label' => 'Vali keel:',
	'securepoll-submit-select-lang' => 'Tõlgi',
	'securepoll-header-title' => 'Nimi',
	'securepoll-header-start-date' => 'Alguse kuupäev',
	'securepoll-header-end-date' => 'Lõpu kuupäev',
	'securepoll-subpage-vote' => 'Hääleta',
	'securepoll-subpage-translate' => 'Tõlgi',
	'securepoll-subpage-list' => 'Loend',
	'securepoll-subpage-dump' => 'Tõmmis',
	'securepoll-subpage-tally' => 'Arvestus',
	'securepoll-tally-title' => 'Arvestus: $1',
	'securepoll-tally-not-finished' => 'Enne valimise lõppu ei saa hääli üle lugeda.',
	'securepoll-can-decrypt' => 'Valimiskirje on krüptitud, aga dekrüptimisvõti on saadaval.

Sa võid üle lugeda kas andmebaasis olevad tulemused või üleslaaditavas failis olevad tulemused.',
	'securepoll-tally-no-key' => 'Sa ei saa selle valimise hääli üle lugeda, sest hääled on krüptitud ja dekrüptimisvõtit ei ole saadaval.',
	'securepoll-tally-local-legend' => 'Loe talletatud tulemused üle',
	'securepoll-tally-local-submit' => 'Loe üle',
	'securepoll-tally-upload-legend' => 'Laadi üles krüptitud tõmmis',
	'securepoll-tally-upload-submit' => 'Loe üle',
	'securepoll-tally-error' => 'Tõrge hääletuskirje tõlgendamisel, ei saa üle lugeda.',
	'securepoll-no-upload' => 'Faili ei laaditud üles, tulemusi ei saa üle lugeda.',
	'securepoll-dump-corrupt' => 'Tõmmisfail on rikutud ja seda ei saa kasutada.',
	'securepoll-tally-upload-error' => 'Tõrge tõmmisfaili arvestamisel: $1',
	'securepoll-ranks' => 'Lõplik pingerida',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 * @author Unai Fdz. de Betoño
 */
$messages['eu'] = array(
	'securepoll' => 'BozketaSegurua',
	'securepoll-invalid-page' => '"<nowiki>$1</nowiki>" azpiorrialde okerra',
	'securepoll-need-admin' => 'Ekintza hori burutzeko hauteskundeetako administratzailea izan behar duzu.',
	'securepoll-welcome' => '<strong>Ongi etorri $1!</strong>',
	'securepoll-finished' => 'Hauteskundeak bukatu dira, beraz, ezin duzu bozkatu.',
	'securepoll-not-qualified' => 'Ez zara bozketa honetan bozkatzen gai: $1',
	'securepoll-change-disallowed' => 'Hauteskundean jada bozkatu duzu.
Barkatu, baina ezin duzu berriro bozkatu.',
	'securepoll-change-allowed' => '<strong>Oharra: Bozketa honetan aurretik bozkatu duzu.</strong>
Zure bozka alda dezakezu azpi orria betez.
Kontuan izan hau egiten baduzu, zure jatorrizko bozka aldatuko dela.',
	'securepoll-submit' => 'Bozka eman',
	'securepoll-gpg-receipt' => 'Milesker bozkatzeagatik.

Nahi baduzu, ondorengo agiria gorde dezakezu zure bozkaren frogabide bezala:

<pre>$1</pre>',
	'securepoll-thanks' => 'Eskerrik asko, zure bozka gorde egin da.',
	'securepoll-return' => '$1-(e)ra itzuli',
	'securepoll-full-gpg-error' => 'Errorea GPG exekutatzen:

Komandoa: $1

Errorea:
<pre>$2</pre>',
	'securepoll-jump' => 'Joan bozketa zerbitzarira',
	'securepoll-bad-ballot-submission' => 'Zure bozka ez da zuzena: $1',
	'securepoll-unanswered-questions' => 'Galdera guztiak erantzun behar dituzu.',
	'securepoll-api-invalid-params' => 'Parametro okerrak.',
	'securepoll-not-logged-in' => 'Bozketa honetan parte hartzeko saioa hasi behar duzu',
	'securepoll-list-title' => 'Bozken zerrenda: $1',
	'securepoll-header-timestamp' => 'Ordua',
	'securepoll-header-voter-name' => 'Izena',
	'securepoll-header-details' => 'Xehetasunak',
	'securepoll-strike-reason' => 'Arrazoia:',
	'securepoll-strike-cancel' => 'Utzi',
	'securepoll-strike-token-mismatch' => 'Saioko informazioa galdu da',
	'securepoll-details-link' => 'Xehetasunak',
	'securepoll-details-title' => 'Bozkaren xehetasunak: #$1',
	'securepoll-header-voter-type' => 'Hautesle mota',
	'securepoll-voter-properties' => 'Hauteslearen hobespenak',
	'securepoll-header-action' => 'Ekintza',
	'securepoll-header-reason' => 'Arrazoia',
	'securepoll-header-admin' => 'Admin',
	'securepoll-translate-title' => 'Itzuli: $1',
	'securepoll-invalid-language' => '"$1" hizkuntza kodea okerra',
	'securepoll-submit-translate' => 'Eguneratu',
	'securepoll-language-label' => 'Hikuntza aukeratu:',
	'securepoll-submit-select-lang' => 'Itzuli',
	'securepoll-header-title' => 'Izena',
	'securepoll-header-start-date' => 'Hasiera data',
	'securepoll-header-end-date' => 'Bukaera data',
	'securepoll-subpage-vote' => 'Bozkatu',
	'securepoll-subpage-translate' => 'Itzuli',
	'securepoll-subpage-list' => 'Zerrenda',
	'securepoll-ranks' => 'Azken rankinga',
);

/** Persian (فارسی)
 * @author Mardetanha
 * @author Meisam
 */
$messages['fa'] = array(
	'securepoll' => 'رای‌گیری امن',
	'securepoll-desc' => 'افزونه برای رای‌گیری‌ها و جمع‌آوری اطلاعات',
	'securepoll-invalid-page' => 'زیرسفحه نامعتبر "<nowiki>$1</nowiki>"',
	'securepoll-not-qualified' => 'شما واجد شرایط شرکت در این رای‌گیری نیستید: $1',
	'securepoll-submit' => 'ارسال رای',
	'securepoll-return' => 'بازگشت به $1',
	'securepoll-unanswered-questions' => 'شما باید به تمامی سوالات پاسخ دهید.',
	'securepoll-header-timestamp' => 'زمان',
	'securepoll-header-voter-name' => 'نام',
	'securepoll-header-voter-domain' => 'دامین',
	'securepoll-header-details' => 'جزئیات',
	'securepoll-strike-reason' => 'دلیل:',
	'securepoll-strike-cancel' => 'لغو',
	'securepoll-details-link' => 'جزئیات',
	'securepoll-details-title' => 'جزییات رای: #$1',
	'securepoll-header-voter-type' => 'نوع کاربر',
	'securepoll-header-reason' => 'دلیل',
	'securepoll-header-admin' => 'مدیر',
	'securepoll-submit-translate' => 'به‌روزآوری',
	'securepoll-language-label' => 'انتخاب زبان:',
	'securepoll-submit-select-lang' => 'ترجمه',
	'securepoll-header-title' => 'نام',
	'securepoll-header-start-date' => 'تاریخ آغاز',
	'securepoll-header-end-date' => 'تاریخ پایان',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Silvonen
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'securepoll' => 'Turvattu äänestys',
	'securepoll-desc' => 'Laajennus vaaleille ja kyselyille.',
	'securepoll-invalid-page' => 'Virheellinen alasivu ”<nowiki>$1</nowiki>”',
	'securepoll-need-admin' => 'Sinun täytyy olla vaalien ylläpitäjä suorittaaksesi tämän toiminnon.',
	'securepoll-too-few-params' => 'Ei tarpeeksi alasivuparametrejä (linkki ei toimi).',
	'securepoll-invalid-election' => '"$1" ei ole kelvollinen vaalitunniste.',
	'securepoll-welcome' => '<strong>Tervetuloa $1!</strong>',
	'securepoll-not-started' => 'Tämä vaali ei ole vielä alkanut.
Sen on määrä alkaa $2 kello $3.',
	'securepoll-finished' => 'Äänestys on päättynyt, et voi enää äänestää.',
	'securepoll-not-qualified' => 'Et täytä ehtoja näiden vaalien äänestäjäksi: $1',
	'securepoll-change-disallowed' => 'Olet jo äänestänyt näissä vaaleissa.
Et voi äänestää uudestaan.',
	'securepoll-change-allowed' => '<strong>Huomio: Olet jo äänestänyt näissä vaaleissa.</strong>
Voit muuttaa ääntäsi tallentamalla alla olevan lomakkeen.
Huomioi, että siinä tapauksessa edellinen äänesi hylätään.',
	'securepoll-submit' => 'Tallenna ääni',
	'securepoll-gpg-receipt' => 'Kiitos äänestäsi.

Jos haluat, voit säilyttää seuraavan todisteena äänestäsi:

<pre>$1</pre>',
	'securepoll-thanks' => 'Kiitos, äänesi on rekisteröity.',
	'securepoll-return' => 'Palaa kohteeseen $1',
	'securepoll-encrypt-error' => 'Äänestystietueesi salakirjoitus epäonnistui.
Ääntäsi ei ole tallennettu!

$1',
	'securepoll-no-gpg-home' => 'GPG-kotihakemistoa ei voitu luoda.',
	'securepoll-secret-gpg-error' => 'Virhe GPG:n suorittamisessa.
Käytä asetusta $wgSecurePollShowErrorDetail=true; tiedostossa LocalSettings.php nähdäksesi tarkemmat tiedot.',
	'securepoll-full-gpg-error' => 'Virhe GPG:n suorittamisessa:

Komento: $1

Virhe:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-avaimet ovat virheellisesti asetettu.',
	'securepoll-gpg-parse-error' => 'Virhe tulkittaessa GPG:n tietoja.',
	'securepoll-no-decryption-key' => 'Salauksen purkuavainta ei ole asetettu.
Salausta ei voi purkaa.',
	'securepoll-jump' => 'Siirry äänestyspalvelimelle.',
	'securepoll-bad-ballot-submission' => 'Äänesi oli epäkelpo: $1',
	'securepoll-unanswered-questions' => 'Sinun täytyy vastata kaikkiin kysymyksiin.',
	'securepoll-invalid-rank' => 'Virheellinen sijanumero. Ehdokkaille antamasi sijanumeron on sijaittava välillä 1 ja 999.',
	'securepoll-unranked-options' => 'Joitain vaihtoehtoja ei asetettu paremmuusjärjestykseen. Jokaiselle vaihtoehdolle pitää tarjota sijoitus väliltä 1 ja 999.',
	'securepoll-invalid-score' => 'Pisteiden tulee olla välillä $1 ja $2.',
	'securepoll-unanswered-options' => 'Sinun täytyy antaa vastaus kaikkiin kysymyksiin.',
	'securepoll-remote-auth-error' => 'Virhe hakiessa käyttäjätilisi tietoja palvelimelta.',
	'securepoll-remote-parse-error' => 'Virhe tulkittaessa lupavastausta palvelimelta.',
	'securepoll-api-invalid-params' => 'Virheellisiä parametreja.',
	'securepoll-api-no-user' => 'Annetulla tunnisteella ei löytynyt käyttäjää.',
	'securepoll-api-token-mismatch' => 'Turvallisuusmerkintä ei täsmää, joten sisäänkirjautuminen ei onnistu.',
	'securepoll-not-logged-in' => 'Sinun pitää kirjautua sisään voidaksesi äänestää.',
	'securepoll-too-few-edits' => 'Valitettavasti et voi äänestää. Sinulla täytyy olla vähintään $1 {{PLURAL:$1|muokkaus|muokkausta}} voidaksesi äänestää näissä vaaleissa. Olet tehnyt $2.',
	'securepoll-blocked' => 'Et voi äänestää näissä vaaleissa, jos sinulla on muokkausesto tällä hetkellä.',
	'securepoll-bot' => 'Käyttäjätilit, joilla on bottimerkintä eivät saa äänestää näissä vaaleissa.',
	'securepoll-not-in-group' => 'Vain jäsenet jotka kuuluvat ryhmään $1, voivat äänestää näissä vaaleissa.',
	'securepoll-not-in-list' => 'Et ole etukäteen valitussa listassa käyttäjiä, jotka ovat oikeutettuja äänestämään tässä vaalissa.',
	'securepoll-list-title' => 'Luettelo äänistä: $1',
	'securepoll-header-timestamp' => 'Aika',
	'securepoll-header-voter-name' => 'Nimi',
	'securepoll-header-voter-domain' => 'Verkkotunnus',
	'securepoll-header-ua' => 'Selaintunniste',
	'securepoll-header-cookie-dup' => 'Kaksoiskappale',
	'securepoll-header-strike' => 'Poisto',
	'securepoll-header-details' => 'Tiedot',
	'securepoll-strike-button' => 'Poisto',
	'securepoll-unstrike-button' => 'Palautus',
	'securepoll-strike-reason' => 'Syy',
	'securepoll-strike-cancel' => 'Peruuta',
	'securepoll-strike-error' => 'Tapahtui virhe poistossa/palautuksessa: $1',
	'securepoll-strike-token-mismatch' => 'Istuntotiedot hävinneet',
	'securepoll-details-link' => 'Tiedot',
	'securepoll-details-title' => 'Äänestystiedot: #$1',
	'securepoll-invalid-vote' => '"$1" ei ole kelvollinen tunniste.',
	'securepoll-header-voter-type' => 'Äänestäjätyyppi',
	'securepoll-voter-properties' => 'Äänestäjän asetukset',
	'securepoll-strike-log' => 'Poistoloki',
	'securepoll-header-action' => 'Toiminto',
	'securepoll-header-reason' => 'Syy',
	'securepoll-header-admin' => 'Ylläpitäjä',
	'securepoll-cookie-dup-list' => 'Käyttäjät, joilla on yhtäläinen eväste.',
	'securepoll-dump-title' => 'Vedos: $1',
	'securepoll-dump-no-crypt' => 'Salattua vaalitiedostoa ei ole saatavilla tälle äänestykselle, koska vaaleja ei ole asetuksissa säädetty käyttämään salausta.',
	'securepoll-dump-not-finished' => 'Salauksin suojatut vaalitiedot ovat saatavilla vaalien päättymispäivän jälkeen $1 kello $2',
	'securepoll-dump-no-urandom' => 'Toimintoa /dev/urandom ei voitu avata.
Äänestyssalaisuuden varmistamiseksi salatut tietueet ovat julkisesti saatavilla ainoastaan silloin, kun niiden järjestys voidaan sekoittaa turvallisella satunnaislukuvirralla.',
	'securepoll-urandom-not-supported' => 'Tämä palvelin ei tue satunnaislukujen tuottoa salauksen alla. Jotta äänestäjien yksityisyys säilytetään, vaalien salauksenalaiset tiedostot ovat julkisesti saatavilla ainoastaan, kun niiden järjestys voidaan sekoittaa turvatusta satunnaislukulähteestä.',
	'securepoll-translate-title' => 'Käännä: $1',
	'securepoll-invalid-language' => 'Virheellinen kielikoodi ”$1”',
	'securepoll-submit-translate' => 'Päivitä',
	'securepoll-language-label' => 'Valitse kieli',
	'securepoll-submit-select-lang' => 'Käännä',
	'securepoll-entry-text' => 'Alla on lista kyselyistä.',
	'securepoll-header-title' => 'Nimi',
	'securepoll-header-start-date' => 'Alkamispäivä',
	'securepoll-header-end-date' => 'Päättymispäivä',
	'securepoll-subpage-vote' => 'Äänestä',
	'securepoll-subpage-translate' => 'Käännä',
	'securepoll-subpage-list' => 'Luettelo',
	'securepoll-subpage-dump' => 'Vedos',
	'securepoll-subpage-tally' => 'Laskenta',
	'securepoll-tally-title' => 'Laskenta: $1',
	'securepoll-tally-not-finished' => 'Valitettavasti et voi suorittaa laskentaa vaalille ennen kuin äänestys on päättynyt.',
	'securepoll-can-decrypt' => 'Äänestystiedot on salakirjoitettu, mutta salauksenpurkuavain on saatavilla.
Voit valita tuloslaskennan tietokantatiedoista, tai salakirjoitetuista tuloksista, jotka ovat peräisin lähetettävästä tiedostosta.',
	'securepoll-tally-no-key' => 'Et voi suorittaa laskentaa näille vaaleille, koska äänet on suojattu salauksella, eikä salauksen avainkoodia ole tarjottu.',
	'securepoll-tally-local-legend' => 'Laske tallenetuista tuloksista',
	'securepoll-tally-local-submit' => 'Tuota laskenta',
	'securepoll-tally-upload-legend' => 'Tallenna salakirjoitettu vedos',
	'securepoll-tally-upload-submit' => 'Luo laskenta',
	'securepoll-tally-error' => 'Virhe äänestystiedoston tulkinnassa, joten ei voitu tuottaa laskentaa.',
	'securepoll-no-upload' => 'Tiedostoa ei lähetettynä, joten laskenta ei onnistunut.',
	'securepoll-dump-corrupt' => 'Vedostiedosto on vioittunut eikä sitä voida käsitellä.',
	'securepoll-tally-upload-error' => 'Virhe vedostiedoston tarkistamisessa: $1',
	'securepoll-pairwise-victories' => 'Parittaisten voittojen matriisi',
	'securepoll-strength-matrix' => 'Polun vahvuuden matriisi',
	'securepoll-ranks' => 'Lopullinen sijoitus',
	'securepoll-average-score' => 'Keskiarvopisteet',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Jean-Frédéric
 * @author Louperivois
 * @author Omnipaedista
 * @author PieRRoMaN
 * @author Verdy p
 * @author Yann
 */
$messages['fr'] = array(
	'securepoll' => 'Sondage sécurisé',
	'securepoll-desc' => 'Extension pour des élections et sondages',
	'securepoll-invalid-page' => 'Sous-page « <nowiki>$1</nowiki> » invalide',
	'securepoll-need-admin' => "Vous devez être un administrateur de l'élection pour exécuter cette action.",
	'securepoll-too-few-params' => 'Pas assez de paramètres de sous-page (lien invalide).',
	'securepoll-invalid-election' => '« $1 » n’est pas un identifiant d’élection valide.',
	'securepoll-welcome' => '<strong>Bienvenue $1 !</strong>',
	'securepoll-not-started' => 'L’élection n’a pas encore commencé.
Elle débutera le $2 à $3.',
	'securepoll-finished' => 'Cette élection est terminée, vous ne pouvez plus voter.',
	'securepoll-not-qualified' => 'Vous n’êtes pas qualifié pour voter dans cette élection : $1',
	'securepoll-change-disallowed' => 'Vous avez déjà voté pour cette élection.
Désolé, vous ne pouvez pas voter une nouvelle fois.',
	'securepoll-change-allowed' => '<strong>Note : Vous avez déjà voté pour cette élection.</strong>
Vous pouvez changer votre vote en soumettant le formulaire ci-dessous.
Si vous faites ceci, votre ancien vote sera annulé.',
	'securepoll-submit' => 'Soumettre le vote',
	'securepoll-gpg-receipt' => 'Merci d’avoir voté.

Si vous le souhaitez, vous pouvez garder le reçu ci-après comme preuve de votre vote :

<pre>$1</pre>',
	'securepoll-thanks' => 'Merci, votre vote a été enregistré.',
	'securepoll-return' => 'Revenir à $1',
	'securepoll-encrypt-error' => 'Le cryptage de votre vote a échoué.
Votre vote n’a pas été enregistré !

$1',
	'securepoll-no-gpg-home' => 'Impossible de créer le dossier de base de GPG.',
	'securepoll-secret-gpg-error' => 'Erreur lors de l’exécution de GPG.
Ajoutez $wgSecurePollShowErrorDetail=true; à LocalSettings.php pour afficher plus de détails.',
	'securepoll-full-gpg-error' => 'Erreur lors de l’exécution de GPG :

Commande : $1

Erreur :
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Les clés de GPG ne sont pas correctement configurées.',
	'securepoll-gpg-parse-error' => 'Erreur lors de l’interprétation de la sortie de GPG.',
	'securepoll-no-decryption-key' => 'Aucune clé de décryptage n’a été configurée.
Impossible de décrypter.',
	'securepoll-jump' => 'Aller au serveur de vote',
	'securepoll-bad-ballot-submission' => 'Votre vote est invalide : $1',
	'securepoll-unanswered-questions' => 'Vous devez répondre à toutes les questions.',
	'securepoll-invalid-rank' => 'Rang invalide. Vous devez donner aux candidats un rang entre 1 et 999.',
	'securepoll-unranked-options' => "Certaines options n'ont pas reçu de rang.
Vous devez donner un rang entre 1 et 999 à toutes les options.",
	'securepoll-invalid-score' => 'Le score doit être un nombre compris entre $1 et $2.',
	'securepoll-unanswered-options' => 'Vous devez donner une réponse pour toutes les questions.',
	'securepoll-remote-auth-error' => 'Erreur lors de la récupération des informations de votre compte depuis le serveur.',
	'securepoll-remote-parse-error' => 'Erreur lors de l’interprétation de la réponse d’autorisation du serveur.',
	'securepoll-api-invalid-params' => 'Paramètres invalides.',
	'securepoll-api-no-user' => 'Aucun utilisateur avec l’identifiant donné n’a été trouvé.',
	'securepoll-api-token-mismatch' => 'Jeton de sécurité différent, connexion impossible.',
	'securepoll-not-logged-in' => 'Vous devez vous connecter pour voter dans cette élection.',
	'securepoll-too-few-edits' => 'Désolé, vous ne pouvez pas voter. Vous devez avoir effectué au moins {{PLURAL:$1|une modification|$1 modifications}} pour voter dans cette élection, vous en totalisez $2.',
	'securepoll-blocked' => 'Désolé, vous ne pouvez pas voter dans cette élection car vous êtes bloqué en écriture.',
	'securepoll-bot' => 'Désolé, les comptes avec le statut de robot ne sont pas autorisés à voter à cette élection.',
	'securepoll-not-in-group' => 'Seuls les membres du groupe « $1 » peuvent voter dans cette élection.',
	'securepoll-not-in-list' => 'Désolé, vous n’êtes pas sur la liste prédéterminée des utilisateurs autorisés à voter dans cette élection.',
	'securepoll-list-title' => 'Liste des votes : $1',
	'securepoll-header-timestamp' => 'Heure',
	'securepoll-header-voter-name' => 'Nom',
	'securepoll-header-voter-domain' => 'Domaine',
	'securepoll-header-ua' => 'User agent',
	'securepoll-header-cookie-dup' => 'Duplicata',
	'securepoll-header-strike' => 'Biffer',
	'securepoll-header-details' => 'Détails',
	'securepoll-strike-button' => 'Biffer',
	'securepoll-unstrike-button' => 'Débiffer',
	'securepoll-strike-reason' => 'Raison :',
	'securepoll-strike-cancel' => 'Annuler',
	'securepoll-strike-error' => 'Erreur lors du (dé)biffage : $1',
	'securepoll-strike-token-mismatch' => 'Perte des données de session',
	'securepoll-details-link' => 'Détails',
	'securepoll-details-title' => 'Détails du vote : #$1',
	'securepoll-invalid-vote' => '« $1 » n’est pas un ID de vote valide',
	'securepoll-header-voter-type' => 'Type du votant',
	'securepoll-voter-properties' => 'Propriétés du votant',
	'securepoll-strike-log' => 'Journal des biffages',
	'securepoll-header-action' => 'Action',
	'securepoll-header-reason' => 'Raison',
	'securepoll-header-admin' => 'Administrateur',
	'securepoll-cookie-dup-list' => 'Utilisateurs ayant un cookie déjà rencontré',
	'securepoll-dump-title' => 'Dump : $1',
	'securepoll-dump-no-crypt' => 'Les données chiffrées ne sont pas disponibles pour cette élection, car l’élection n’est pas configurée pour utiliser un chiffrement.',
	'securepoll-dump-not-finished' => 'Les données cryptées ne sont disponibles qu’après la clôture de l’élection le $1 à $2',
	'securepoll-dump-no-urandom' => 'Impossible d’ouvrir /dev/urandom.
Pour maintenir la confidentialité des votants, les données cryptées ne sont disponibles que si elles peuvent être brouillées avec un nombre de caractères aléatoires.',
	'securepoll-urandom-not-supported' => 'Ce serveur ne supporte pas la génération cryptographique aléatoire de nombres.
Pour assurer la confidentialité des votants, les données cryptées ne sont publiés uniquement quand ils peuvent être brouillés avec un flux de nombres aléatoires.',
	'securepoll-translate-title' => 'Traduire : $1',
	'securepoll-invalid-language' => 'Code de langue « $1 » invalide.',
	'securepoll-submit-translate' => 'Mettre à jour',
	'securepoll-language-label' => 'Sélectionner la langue :',
	'securepoll-submit-select-lang' => 'Traduire',
	'securepoll-entry-text' => 'Ci-dessous la liste des sondages.',
	'securepoll-header-title' => 'Nom',
	'securepoll-header-start-date' => 'Date de début',
	'securepoll-header-end-date' => 'Date de fin',
	'securepoll-subpage-vote' => 'Vote',
	'securepoll-subpage-translate' => 'Traduire',
	'securepoll-subpage-list' => 'Liste',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Comptage',
	'securepoll-tally-title' => 'Comptage : $1',
	'securepoll-tally-not-finished' => 'Désolé, vous ne pouvez pas compter les résultats de l’élection avant qu’elle ne soit terminée.',
	'securepoll-can-decrypt' => 'L’enregistrement de l’élection a été crypté, mais la clé de décryptage est disponible.
Vous pouvez choisir de compter les résultats depuis la base de données ou depuis un fichier téléversé.',
	'securepoll-tally-no-key' => 'Vous ne pouvez pas faire le décompte des résultats de cette élection parce que les votes sont cryptés et que la clé de décryptage n’est pas disponible.',
	'securepoll-tally-local-legend' => 'Compter les résultats sauvegardés',
	'securepoll-tally-local-submit' => 'Créer un comptage',
	'securepoll-tally-upload-legend' => 'Téléverser une sauvegarde cryptée',
	'securepoll-tally-upload-submit' => 'Créer une comptage',
	'securepoll-tally-error' => 'Erreur lors de l’interprétation des enregistrements de vote, impossible de produire un résultat.',
	'securepoll-no-upload' => 'Aucun fichier n’a été téléchargé, impossible de compter les résultats.',
	'securepoll-dump-corrupt' => 'Le fichier de sauvegarde est corrompu et ne peut pas être utilisé.',
	'securepoll-tally-upload-error' => 'Erreur lors du dépouillement du fichier de sauvegarde : $1',
	'securepoll-pairwise-victories' => 'Matrice des victoires par pair',
	'securepoll-strength-matrix' => 'Matrice de force des chemins',
	'securepoll-ranks' => 'Classement final',
	'securepoll-average-score' => 'Score moyen',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'securepoll' => 'Sondâjo sècurisâ',
	'securepoll-desc' => 'Èxtension por des èlèccions et sondâjos',
	'securepoll-invalid-page' => 'Sot-pâge « <nowiki>$1</nowiki> » envalida',
	'securepoll-need-admin' => 'Vos dête étre un administrator de l’èlèccion por ègzécutar ceta accion.',
	'securepoll-too-few-params' => 'Pas prod de paramètres de sot-pâge (lim envalido).',
	'securepoll-invalid-election' => '« $1 » est pas un identifiant d’èlèccion valido.',
	'securepoll-welcome' => '<strong>Benvegnua $1 !</strong>',
	'securepoll-not-started' => 'L’èlèccion at p’oncor comenciê.
Comencierat lo $2 a $3.',
	'securepoll-finished' => 'Ceta èlèccion est chavonâ, vos pouede pas més votar.',
	'securepoll-not-qualified' => 'Vos éte pas qualifiâ por votar dens ceta èlèccion : $1',
	'securepoll-change-disallowed' => 'Vos éd ja votâ por ceta èlèccion.
Dèsolâ, vos pouede pas tornar votar.',
	'securepoll-change-allowed' => '<strong>Nota : vos éd ja votâ por ceta èlèccion.</strong>
Vos pouede changiér voutron voto en sometent lo formulèro ce-desot.
Se vos féte cen, voutron viely voto serat anulâ.',
	'securepoll-submit' => 'Sometre lo voto',
	'securepoll-gpg-receipt' => 'Grant-marci d’avêr votâ.

Se vos lo souhètâd, vos pouede gouardar ceti reçu coment prôva de voutron voto :

<pre>$1</pre>',
	'securepoll-thanks' => 'Grant-marci, voutron voto at étâ encartâ.',
	'securepoll-return' => 'Tornar a $1',
	'securepoll-encrypt-error' => 'Lo criptâjo de voutron voto at pas reussi.
Voutron voto at pas étâ encartâ !

$1',
	'securepoll-no-gpg-home' => 'Empossiblo de fâre lo dossiér de bâsa de GPG.',
	'securepoll-secret-gpg-error' => 'Èrror pendent l’ègzécucion de GPG.
Apondéd $wgSecurePollShowErrorDetail=true; a LocalSettings.php por fâre vêre més de dètalys.',
	'securepoll-full-gpg-error' => 'Èrror pendent l’ègzécucion de GPG :

Comanda : $1

Èrror :
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Les cllâfs de GPG sont pas bien configurâs.',
	'securepoll-gpg-parse-error' => 'Èrror pendent l’entèrprètacion de la sortia de GPG.',
	'securepoll-no-decryption-key' => 'Niona cllâf de dècriptâjo at étâ configurâ.
Empossiblo de dècriptar.',
	'securepoll-jump' => 'Alar u sèrvor de voto',
	'securepoll-bad-ballot-submission' => 'Voutron voto est envalido : $1',
	'securepoll-unanswered-questions' => 'Vos dête rèpondre a totes les quèstions.',
	'securepoll-invalid-rank' => 'Rang envalido. Vos dête balyér ux candidats un rang entre-mié 1 et 999.',
	'securepoll-unranked-options' => 'Quârques chouèx ont pas reçu de rang.
Vos dête balyér un rang entre-mié 1 et 999 a tôs los chouèx.',
	'securepoll-invalid-score' => 'La mârca dêt étre un nombro comprês entre-mié $1 et $2.',
	'securepoll-unanswered-options' => 'Vos dête balyér una rèponsa por totes les quèstions.',
	'securepoll-remote-auth-error' => 'Èrror pendent la rècupèracion de les enformacions de voutron compto dês lo sèrvor.',
	'securepoll-remote-parse-error' => 'Èrror pendent l’entèrprètacion de la rèponsa d’ôtorisacion du sèrvor.',
	'securepoll-api-invalid-params' => 'Paramètres envalidos.',
	'securepoll-api-no-user' => 'Nion utilisator avouéc l’identifiant balyê at étâ trovâ.',
	'securepoll-api-token-mismatch' => 'Jeton de sècuritât difèrent, branchement empossiblo.',
	'securepoll-not-logged-in' => 'Vos vos dête branchiér por votar dens ceta èlèccion.',
	'securepoll-too-few-edits' => 'Dèsolâ, vos pouede pas votar. Vos dête avêr fêt u muens {{PLURAL:$1|yon changement|$1 changements}} por votar dens ceta èlèccion, vos en totalisâd $2.',
	'securepoll-blocked' => 'Dèsolâ, vos pouede pas votar dens ceta èlèccion perce que vos éte blocâ en ècritura.',
	'securepoll-bot' => 'Dèsolâ, los comptos avouéc lo statut de bot sont pas ôtorisâs a votar a ceta èlèccion.',
	'securepoll-not-in-group' => 'Solament los membros a la tropa « $1 » pôvont votar dens ceta èlèccion.',
	'securepoll-not-in-list' => 'Dèsolâ, vos éte pas sur la lista prèdètèrmenâ ux utilisators ôtorisâs a votar dens ceta èlèccion.',
	'securepoll-list-title' => 'Lista des votos : $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nom',
	'securepoll-header-voter-domain' => 'Domêno',
	'securepoll-header-ua' => 'Agent utilisator',
	'securepoll-header-cookie-dup' => 'Doblo',
	'securepoll-header-strike' => 'Traciér',
	'securepoll-header-details' => 'Dètalys',
	'securepoll-strike-button' => 'Traciér',
	'securepoll-unstrike-button' => 'Dètraciér',
	'securepoll-strike-reason' => 'Rêson :',
	'securepoll-strike-cancel' => 'Anular',
	'securepoll-strike-error' => 'Èrror pendent lo (dè)traçâjo : $1',
	'securepoll-strike-token-mismatch' => 'Pèrta de les balyês de sèance',
	'securepoll-details-link' => 'Dètalys',
	'securepoll-details-title' => 'Dètalys du voto : #$1',
	'securepoll-invalid-vote' => '« $1 » est pas un ID de voto valido',
	'securepoll-header-voter-type' => 'Tipo u votent',
	'securepoll-voter-properties' => 'Propriètâts u votent',
	'securepoll-strike-log' => 'Jornal des traçâjos',
	'securepoll-header-action' => 'Accion',
	'securepoll-header-reason' => 'Rêson',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => "Utilisators qu’ont un tèmouen (''cookie'') ja rencontrâ",
	'securepoll-dump-title' => 'Èxtrèt : $1',
	'securepoll-dump-no-crypt' => 'Les balyês criptâs sont pas disponibles por ceta èlèccion, perce que l’èlèccion est pas configurâ por utilisar un criptâjo.',
	'securepoll-dump-not-finished' => 'Les balyês criptâs sont disponibles ren qu’aprés la cllotura de l’èlèccion lo $1 a $2',
	'securepoll-translate-title' => 'Traduire : $1',
	'securepoll-invalid-language' => 'Code lengoua « $1 » envalido.',
	'securepoll-submit-translate' => 'Betar a jorn',
	'securepoll-language-label' => 'Chouèsir la lengoua :',
	'securepoll-submit-select-lang' => 'Traduire',
	'securepoll-entry-text' => 'Ce-desot la lista des sondâjos.',
	'securepoll-header-title' => 'Nom',
	'securepoll-header-start-date' => 'Dâta de comencement',
	'securepoll-header-end-date' => 'Dâta de fin',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traduire',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Èxtrèt',
	'securepoll-subpage-tally' => 'Comptâjo',
	'securepoll-tally-title' => 'Comptâjo : $1',
	'securepoll-tally-not-finished' => 'Dèsolâ, vos pouede pas comptar los rèsultats de l’èlèccion devant que seye chavonâ.',
	'securepoll-tally-no-key' => 'Vos pouede pas fâre lo dècompto des rèsultats de ceta èlèccion perce que los votos sont criptâs et que la cllâf de dècriptâjo est pas disponibla.',
	'securepoll-tally-local-legend' => 'Comptar los rèsultats encartâs',
	'securepoll-tally-local-submit' => 'Fâre un comptâjo',
	'securepoll-tally-upload-legend' => 'Tèlèchargiér un èxtrèt criptâ',
	'securepoll-tally-upload-submit' => 'Fâre un comptâjo',
	'securepoll-tally-error' => 'Èrror pendent l’entèrprètacion des encartâjos de voto, empossiblo de balyér un rèsultat.',
	'securepoll-no-upload' => 'Nion fichiér at étâ tèlèchargiê, empossiblo de comptar los rèsultats.',
	'securepoll-dump-corrupt' => 'Lo fichiér d’èxtrèt est corrompu et pôt pas étre utilisâ.',
	'securepoll-tally-upload-error' => 'Èrror pendent lo dèpolyement du fichiér d’èxtrèt : $1',
	'securepoll-pairwise-victories' => 'Matrice de les victouères per cobla',
	'securepoll-strength-matrix' => 'Matrice de fôrce des chemins',
	'securepoll-ranks' => 'Cllassement final',
	'securepoll-average-score' => 'Mârca moyena',
);

/** Western Frisian (Frysk)
 * @author SK-luuut
 */
$messages['fy'] = array(
	'securepoll-strike-cancel' => 'Ofbrekke',
);

/** Irish (Gaeilge)
 * @author Alison
 * @author Stifle
 */
$messages['ga'] = array(
	'securepoll-not-started' => 'Níl an toghchán seo tosaithe fós.
De réir an sceidil, tosnóidh sé ag $2 ar $3.',
	'securepoll-not-qualified' => 'Níl tú cáilithe vótáil sa thoghchán seo: $1',
	'securepoll-change-disallowed' => 'Vótail tú sa thoghchán seo roimhe seo.
Níl cead agat vótáil arís.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'securepoll' => 'Sondaxe de seguridade',
	'securepoll-desc' => 'Extensión para as eleccións e sondaxes',
	'securepoll-invalid-page' => 'Subpáxina "<nowiki>$1</nowiki>" inválida',
	'securepoll-need-admin' => 'Ten que ser un administrador de eleccións para poder levar a cabo esta acción.',
	'securepoll-too-few-params' => 'Non hai parámetros de subpáxina suficientes (ligazón inválida).',
	'securepoll-invalid-election' => '"$1" non é un número de identificación das eleccións válido.',
	'securepoll-welcome' => '<strong>Dámoslle a benvida, $1!</strong>',
	'securepoll-not-started' => 'Estas eleccións aínda non comezaron.
Están programadas para empezar o $2 ás $3.',
	'securepoll-finished' => 'Estas eleccións xa remataron, non se pode votar máis.',
	'securepoll-not-qualified' => 'Non está cualificado para votar nestas eleccións: $1',
	'securepoll-change-disallowed' => 'Xa votou nestas eleccións.
Sentímolo, non pode votar de novo.',
	'securepoll-change-allowed' => '<strong>Nota: xa votou nestas eleccións.</strong>
Pode cambiar o seu voto enviando o formulario de embaixo.
Déase conta de que se fai isto o seu voto orixinal será descartado.',
	'securepoll-submit' => 'Enviar o voto',
	'securepoll-gpg-receipt' => 'Grazas por votar.

Se o desexa, pode gardar o seguinte recibo como proba do seu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Grazas, o seu voto foi rexistrado.',
	'securepoll-return' => 'Voltar a $1',
	'securepoll-encrypt-error' => 'Non se puido encriptar o rexistro do seu voto.
O seu voto non foi gardado!

$1',
	'securepoll-no-gpg-home' => 'Non se pode crear directorio principal GPG.',
	'securepoll-secret-gpg-error' => 'Erro ao executar o directorio GPG.
Use $wgSecurePollShowErrorDetail=true; en LocalSettings.php para obter máis detalles.',
	'securepoll-full-gpg-error' => 'Erro ao executar o directorio GPG:

Comando: $1

Erro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'As chaves GPG están configuradas incorrectamente.',
	'securepoll-gpg-parse-error' => 'Erro de interpretación do GPG de saída.',
	'securepoll-no-decryption-key' => 'Non hai unha chave de desencriptar configurada.
Non se pode desencriptar.',
	'securepoll-jump' => 'Ir ao servidor de votos',
	'securepoll-bad-ballot-submission' => 'O seu voto foi inválido: $1',
	'securepoll-unanswered-questions' => 'Debe responder a todas as preguntas.',
	'securepoll-invalid-rank' => 'Clasificación inválida. Debe darlles aos candidatos unha clasificación que estea entre 1 e 999.',
	'securepoll-unranked-options' => 'Algunhas opcións non foron clasificadas.
Debe darlles a todas as opcións unha clasificación que estea entre 1 e 999.',
	'securepoll-invalid-score' => 'A puntuación debe ser un número entre $1 e $2.',
	'securepoll-unanswered-options' => 'Ten que dar unha resposta para cada pregunta.',
	'securepoll-remote-auth-error' => 'Erro ao enviar a información da súa conta desde o servidor.',
	'securepoll-remote-parse-error' => 'Erro ao interpretar a autorización de resposta desde o servidor.',
	'securepoll-api-invalid-params' => 'Parámetros inválidos.',
	'securepoll-api-no-user' => 'Non se atopou ningún usuario co ID introducido.',
	'securepoll-api-token-mismatch' => 'Desaxuste dun token de seguridade, non pode acceder ao sistema.',
	'securepoll-not-logged-in' => 'Debe acceder ao sistema para votar nestas eleccións',
	'securepoll-too-few-edits' => 'Sentímolo, non pode votar nestas eleccións. Debe ter feito, polo menos, {{PLURAL:$1|unha edición|$1 edicións}}, e só ten feito $2.',
	'securepoll-blocked' => 'Sentímolo, non pode votar nestas eleccións se está actualmente bloqueado fronte á edición.',
	'securepoll-bot' => 'Sentímolo, as contas con dereitos de bot non están autorizadas a votar nestas eleccións.',
	'securepoll-not-in-group' => 'Só os membros pertencentes ao grupo dos $1 poden votar nestas eleccións.',
	'securepoll-not-in-list' => 'Sentímolo, non está na lista predeterminada de usuarios autorizados a votar nestas eleccións.',
	'securepoll-list-title' => 'Lista de votos: $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Axente usuario',
	'securepoll-header-cookie-dup' => 'Dupl.',
	'securepoll-header-strike' => 'Riscar',
	'securepoll-header-details' => 'Detalles',
	'securepoll-strike-button' => 'Riscar',
	'securepoll-unstrike-button' => 'Retirar o risco',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-strike-error' => 'Erro ao levar a cabo o risco/a retirada do risco: $1',
	'securepoll-strike-token-mismatch' => 'Perdéronse os datos da sesión',
	'securepoll-details-link' => 'Detalles',
	'securepoll-details-title' => 'Detalles do voto: #$1',
	'securepoll-invalid-vote' => '"$1" non é un ID de voto válido',
	'securepoll-header-voter-type' => 'Tipo de votante',
	'securepoll-voter-properties' => 'Propiedades do elector',
	'securepoll-strike-log' => 'Rexistro de riscos',
	'securepoll-header-action' => 'Acción',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-cookie-dup-list' => 'Usuarios cunha cookie duplicada',
	'securepoll-dump-title' => 'Desbotar: $1',
	'securepoll-dump-no-crypt' => 'Non hai dispoñible ningún rexistro das eleccións encriptado, porque as eleccións non están configuradas para usar encriptación.',
	'securepoll-dump-not-finished' => 'Os rexistros das eleccións encriptados só están dispoñibles despois da data de fin o $1 ás $2',
	'securepoll-dump-no-urandom' => 'Non se pode abrir /dev/urandom.  
Para manter a protección dos datos, os rexistros das eleccións encriptados só están dispoñibles publicamente cando poden ser baraxados cunha secuencia de números aleatorios.',
	'securepoll-urandom-not-supported' => 'Este servidor non soporta a xeración criptográfica de números aleatorios.
Para manter a confidencialidade dos votantes, os rexistros cifrados das eleccións só están dispoñibles publicamente cando se poden barallar cun fluxo de números aleatorios.',
	'securepoll-translate-title' => 'Traducir: $1',
	'securepoll-invalid-language' => 'Código de lingua inválido "$1"',
	'securepoll-submit-translate' => 'Actualizar',
	'securepoll-language-label' => 'Seleccione a lingua:',
	'securepoll-submit-select-lang' => 'Traducir',
	'securepoll-entry-text' => 'A continuación hai unha lista coas enquisas.',
	'securepoll-header-title' => 'Nome',
	'securepoll-header-start-date' => 'Data de inicio',
	'securepoll-header-end-date' => 'Data de fin',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traducir',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Desbotar',
	'securepoll-subpage-tally' => 'Escrutinio',
	'securepoll-tally-title' => 'Escrutinio: $1',
	'securepoll-tally-not-finished' => 'Sentímolo, non pode escrutar os votos das eleccións antes de que a votación remate.',
	'securepoll-can-decrypt' => 'O rexistro electoral foi codificado, pero a clave para desencriptalo está dispoñible.  
Pode optar por escrutar os resultados presentes na base de datos ou por escrutar os resultados encriptados nun ficheiro cargado.',
	'securepoll-tally-no-key' => 'Non pode escrutar os votos destas eleccións, porque estes votos están encriptados e clave para desencriptalos non está dispoñible.',
	'securepoll-tally-local-legend' => 'Resultados almacenados do escrutinio',
	'securepoll-tally-local-submit' => 'Crear o escrutinio',
	'securepoll-tally-upload-legend' => 'Cargar unha copia de seguridade codificada',
	'securepoll-tally-upload-submit' => 'Crear o escrutinio',
	'securepoll-tally-error' => 'Erro de interpretación no rexistro da votación, non se pode producir un escrutinio.',
	'securepoll-no-upload' => 'Non foi cargado ningún ficheiro, non se poden escrutar os resultados.',
	'securepoll-dump-corrupt' => 'O ficheiro de descarga está danado e non pode ser procesado.',
	'securepoll-tally-upload-error' => 'Erro ao enumerar o ficheiro de descarga: $1',
	'securepoll-pairwise-victories' => 'Matriz de vitoria por parellas',
	'securepoll-strength-matrix' => 'Matriz da fortaleza de ruta',
	'securepoll-ranks' => 'Valoración final',
	'securepoll-average-score' => 'Puntuación media',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'securepoll' => 'Ἠσφαλισμένη Κάλπη',
	'securepoll-header-timestamp' => 'Χρόνος',
	'securepoll-header-voter-name' => 'Ὄνομα',
	'securepoll-header-voter-domain' => 'Περιοχή',
	'securepoll-header-details' => 'Λεπτομέρειαι',
	'securepoll-strike-reason' => 'Αἰτία:',
	'securepoll-strike-cancel' => 'Ἀκυροῦν',
	'securepoll-details-link' => 'Λεπτομέρειαι',
	'securepoll-header-action' => 'Δρᾶσις',
	'securepoll-header-reason' => 'Αἰτία',
	'securepoll-submit-translate' => 'Ἐνημέρωσις',
	'securepoll-language-label' => 'Ἐπιλέγειν γλῶτταν:',
	'securepoll-submit-select-lang' => 'Μεταγλωττίζειν',
	'securepoll-header-title' => 'Ὄνομα',
	'securepoll-subpage-vote' => 'Ψηφίζειν',
	'securepoll-subpage-list' => 'Κατάλογος',
	'securepoll-subpage-tally' => 'Ψηφομέτρησις',
	'securepoll-tally-title' => 'Ψηφομέτρησις: $1',
	'securepoll-ranks' => 'Τελικὴ κατάταξις',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'securepoll' => 'Sicheri Abstimmig',
	'securepoll-desc' => 'Erwyterig fir Wahlen un Umfroge',
	'securepoll-invalid-page' => 'Nit giltigi Untersyte „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Du muesch e Wahl-Ammann syy go die Aktion durzfiere.',
	'securepoll-too-few-params' => 'Nit gnue Untersyteparameter (nit giltig Gleich).',
	'securepoll-invalid-election' => '„$1“ isch kei giltigi Abstimmigs-ID.',
	'securepoll-welcome' => '<strong>Willchuu $1!</strong>',
	'securepoll-not-started' => 'Die Wahl het nonig aagfange.
Si fangt wahrschyns aa am $2 am $3.',
	'securepoll-finished' => 'D Wahl isch umme, du chasch nimmi abstimme.',
	'securepoll-not-qualified' => 'Du bisch nit qualifiziert zum in däre Wahl abzstimme: $1',
	'securepoll-change-disallowed' => 'Du hesch in däre Wahl scho abgstimmt.
Du derfsch nit nomol abstimme.',
	'securepoll-change-allowed' => '<strong>Hiiwys: Du hesch in däre Wahl scho abgstimmt.</strong>
Du chasch Dyyn Stimm ändere, indäm s unter Formular abschicksch.
Wänn Du des machsch, wird Dyy urspringligi Stimm iberschribe.',
	'securepoll-submit' => 'Stimm abgee',
	'securepoll-gpg-receipt' => 'Dankschen.

S chunnt e Bstetigung as Bewyys fir Dyy Stimmabgab:

<pre>$1</pre>',
	'securepoll-thanks' => 'Dankschen, Dyy Stimm isch gspycheret wore.',
	'securepoll-return' => 'Zruck zue $1',
	'securepoll-encrypt-error' => 'Bim Verschlissle vu Dyynere Stimm het s e Fähler gee.
Dyy Stimm isch nit gspycheret wore!

$1',
	'securepoll-no-gpg-home' => 'GPG-Heimverzeichnis cha nit aagleit wäre.',
	'securepoll-secret-gpg-error' => 'Fähler bim Uusfiere vu GPG.
$wgSecurePollShowErrorDetail=true; in LocalSettings.php yyfiege go meh Detail aazeige.',
	'securepoll-full-gpg-error' => 'Fähler bim Uusfiere vu GPG:

Befähl: $1

Fähler:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-Schlissel sin nit korrekt konfiguriert.',
	'securepoll-gpg-parse-error' => 'Fähler bim Interpretiere vu dr Uusgab vu GPG.',
	'securepoll-no-decryption-key' => 'S isch kei Entschlisseligsschlissel konfiguriert.
Entschlisselig nit megli.',
	'securepoll-jump' => 'Gang zum Stimm-Server',
	'securepoll-bad-ballot-submission' => 'Dyy Stimm isch nit giltig: $1',
	'securepoll-unanswered-questions' => 'Du muesch uf alli Froge Antwort gee.',
	'securepoll-invalid-rank' => 'Nit giltigi Rangfolg. Du muesch dr Kandidate e Rangnummere zwische 1 un 999 gee.',
	'securepoll-unranked-options' => 'E Teil Optione hän kei Rangnummere.
Du muesch allene Optione e Rangnummere zwische 1 un 999 gee.',
	'securepoll-invalid-score' => 'S Ergebnis muess e Zahl zwische $1 un $2 syy.',
	'securepoll-unanswered-options' => 'Du muesch uf jedi Frog e Antwort gee.',
	'securepoll-remote-auth-error' => 'Fähler bim Abruefe vu Dyyne Benutzerkontoinformatione vum Server.',
	'securepoll-remote-parse-error' => 'Fähler bim Dyte vu dr Autorisierigsantwort vum Server',
	'securepoll-api-invalid-params' => 'Nit giltigi Parameter.',
	'securepoll-api-no-user' => 'S isch kei Benutzer gfunde wore mit däre ID.',
	'securepoll-api-token-mismatch' => 'Fähler bi dr Sicherheitsabfrog, cha Di nit aamälde.',
	'securepoll-not-logged-in' => 'Du muesch aagmäldet syy zum abstimme bi däre Wahl',
	'securepoll-too-few-edits' => 'Excusez, Du chasch nit abstimme. Du muesch zmindescht $1 {{PLURAL:$1|Bearbeitig|Bearbeitige}} haa zum Abstimme bi däre Wahl, Du hesch $2.',
	'securepoll-blocked' => 'Excusez, Du derfsch nit abstimme bi däre Wahl, wänn Du grad fir Bearbeitige gsperrt bisch.',
	'securepoll-bot' => 'Excusez, Benutzerkonte mit Botstatus derfe nit abstimme bi däre Wahl.',
	'securepoll-not-in-group' => 'Numme Benutzer, wu Mitglid in dr $1 Gruppesin, chenne bi däre Wahl abstimme.',
	'securepoll-not-in-list' => 'Excusez, Du bisch nit in dr feschtgleite Lischt vu autorisierte Benutzer, wu bi däre Wahl derfe abstimme.',
	'securepoll-list-title' => 'Stimmen uflischte: $1',
	'securepoll-header-timestamp' => 'Zyt',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domäne',
	'securepoll-header-ua' => 'Benutzeragent',
	'securepoll-header-cookie-dup' => 'Verdopple',
	'securepoll-header-strike' => 'Stryche',
	'securepoll-header-details' => 'Detail',
	'securepoll-strike-button' => 'Stryche',
	'securepoll-unstrike-button' => 'Strychig zruckneh',
	'securepoll-strike-reason' => 'Grund:',
	'securepoll-strike-cancel' => 'Abbräche',
	'securepoll-strike-error' => 'Fähler bi dr Strychig/Strychigsrucknahm: $1',
	'securepoll-strike-token-mismatch' => 'Sitzígsdate verlore',
	'securepoll-details-link' => 'Detail',
	'securepoll-details-title' => 'Abstimmigsdetail: #$1',
	'securepoll-invalid-vote' => '„$1“ isch kei giltigi Abstimmigs-ID',
	'securepoll-header-voter-type' => 'Wehlertyp',
	'securepoll-voter-properties' => 'Wehlereigeschafte',
	'securepoll-strike-log' => 'Strychigs-Logbuech',
	'securepoll-header-action' => 'Aktion',
	'securepoll-header-reason' => 'Grund',
	'securepoll-header-admin' => 'Ammann',
	'securepoll-cookie-dup-list' => 'Dopplteti Benutzer (Cookie)',
	'securepoll-dump-title' => 'Uuszug: $1',
	'securepoll-dump-no-crypt' => 'Fir die Wahl sin kei verschlissleti Abstimmigsufzeichnige verfiegbar, wel d Wahl nit fir e Verschlisslig konfiguriert woren isch.',
	'securepoll-dump-not-finished' => 'Verschlissleti Abstimmigsufzeichnige sin nume noch em Ändtermin am $1 am $2 verfiegbar',
	'securepoll-dump-no-urandom' => '/dev/urandom cha nit ufgmacht wäre.
Go dr Wehlerdateschutz wohre, sin verschlissleti Abstimmigsufzeichnige nume effentli verfiebar, wänn si mit eme sichere  Zuefallszahlestrom chenne gmischt wäre.',
	'securepoll-urandom-not-supported' => 'Dää Server unterstitzt kei kryptografischi Zuefallszahlegenerierig.
Ass es Wahlgheimnis sicher gstellt isch, sin verschlssleti Wahlufzeichnige nume effetlig verfiegbar, wänn si mit ere sichere Zuefallszahlereihefolg chenne vermischt wäre.',
	'securepoll-translate-title' => 'Ibersetze: $1',
	'securepoll-invalid-language' => 'Nit giltige Sprochcode „$1“',
	'securepoll-submit-translate' => 'Aktualisiere',
	'securepoll-language-label' => 'Sproch uuswehle:',
	'securepoll-submit-select-lang' => 'Ibersetze',
	'securepoll-entry-text' => 'Do unte het s e Lischt mit Abstimmige.',
	'securepoll-header-title' => 'Name',
	'securepoll-header-start-date' => 'Aafangsdatum',
	'securepoll-header-end-date' => 'Änddatum',
	'securepoll-subpage-vote' => 'Abstimme',
	'securepoll-subpage-translate' => 'Iberseze',
	'securepoll-subpage-list' => 'Lischt',
	'securepoll-subpage-dump' => 'Uusgab',
	'securepoll-subpage-tally' => 'Uuszellig',
	'securepoll-tally-title' => 'Uuszellig: $1',
	'securepoll-tally-not-finished' => 'Excusez, Du chasch kei Stimme uuszelle, bis d Abstimmig umme isch.',
	'securepoll-can-decrypt' => 'D Wahlufzeichnig isch verschlisslet wore, aber dr Entschlisslingsschlissel isch verfiegbar.
Du chasch wehle zwische dr Uuszellig vu dr aktuällen Ergebnis in dr Datebank un dr Uuszellig vu dr verschlissleten Ergebnis us ere ufegladene Datei.',
	'securepoll-tally-no-key' => 'Du chasch d Stimme nit uuszelle, wel d Stimme verschlisslet sin un dr Entschlissligsschlissel nit verfiegbar isch.',
	'securepoll-tally-local-legend' => 'Gspychereti Ergebnis uuszelle',
	'securepoll-tally-local-submit' => 'Uuszellig aalege',
	'securepoll-tally-upload-legend' => 'Verschlisslete Uuszug ufelade',
	'securepoll-tally-upload-submit' => 'Uuszellig aalege',
	'securepoll-tally-error' => 'Fähler bim Interpretiere vu dr Abstimmigsufzeichnig, Uuszellig cha nit aagleit wäre.',
	'securepoll-no-upload' => 'S isch kei Datei ufeglade wore, cha d Ergebnis nit uuszelle.',
	'securepoll-dump-corrupt' => 'D Uusgabe-Datei isch fählerhaft un cha nit verarbeitet wäre.',
	'securepoll-tally-upload-error' => 'Fähler in dr gwichtete Uusgabe-Datei: $1',
	'securepoll-pairwise-victories' => 'Paarwys Siigmatrix',
	'securepoll-strength-matrix' => 'Pfad Sterkimatrix',
	'securepoll-ranks' => 'Schlussreihefolg',
	'securepoll-average-score' => 'Durschnittlige Stand',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 * @author Rotemliss
 * @author YaronSh
 * @author דניאל ב.
 */
$messages['he'] = array(
	'securepoll' => 'הצבעה מאובטחת',
	'securepoll-desc' => 'הרחבה המאפשרת הצבעות וסקרים',
	'securepoll-invalid-page' => 'דף משנה בלתי תקין: "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'עליכם להיות מנהלי ההצבעה כדי לבצע פעולה זו.',
	'securepoll-too-few-params' => 'אין מספיק פרמטרים של דפי משנה (קישור בלתי תקין).',
	'securepoll-invalid-election' => '"$1" אינו מספר הצבעה תקין.',
	'securepoll-welcome' => '<strong>ברוכים הבאים, $1!</strong>',
	'securepoll-not-started' => 'הצבעה זו טרם התחילה.
היא מיועדת להתחיל ב־$3, $2.',
	'securepoll-finished' => 'הצבעה זו הסתיימה, אינכם יכולים עוד להצביע.',
	'securepoll-not-qualified' => 'אינכם רשאים להצביע בהצבעה זו: $1',
	'securepoll-change-disallowed' => 'הצבעתם כבר בהצבעה זו.
מצטערים, אינכם רשאים להצביע שוב.',
	'securepoll-change-allowed' => '<strong>הערה: כבר הצבעתם בהצבעה זו בעבר.</strong>
באפשרותכם לשנות את הצבעתכם באמצעות שליחת הטופס להלן.
אם תעשו זאת, הצבעתכם המקורית תימחק.',
	'securepoll-submit' => 'שליחת ההצבעה',
	'securepoll-gpg-receipt' => 'תודה על ההצבעה.

אם תרצו, תוכלו לשמור את הקבלה הבאה כהוכחה להצבעתכם:

<pre>$1</pre>',
	'securepoll-thanks' => 'תודה לכם, הצבעתכם נרשמה.',
	'securepoll-return' => 'בחזרה ל$1',
	'securepoll-encrypt-error' => 'הצפנת רשומת ההצבעה שלכם לא הצליחה.
הצבעתכם לא נרשמה!

$1',
	'securepoll-no-gpg-home' => 'לא ניתן ליצור את תיקיית הבית של GPG.',
	'securepoll-secret-gpg-error' => 'שגיאה בהרצת GPG.
הגדירו את $wgSecurePollShowErrorDetail=true; בקובץ LocalSettings.php להצגת פרטים נוספים.',
	'securepoll-full-gpg-error' => 'שגיאה בהרצת GPG:

פקודה: $1

שגיאה:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'מפתחות GPG אינם מוגדרים כהלכה.',
	'securepoll-gpg-parse-error' => 'שגיאה בפענוח הפלט של GPG.',
	'securepoll-no-decryption-key' => 'לא הוגדר מפתח פיענוח.
לא ניתן לפענח.',
	'securepoll-jump' => 'מעבר לשרת ההצבעה',
	'securepoll-bad-ballot-submission' => 'הצבעתכם הייתה בלתי תקינה: $1',
	'securepoll-unanswered-questions' => 'עליכם לענות על כל השאלות.',
	'securepoll-invalid-rank' => 'הדירוג אינו תקין. יש לתת למועמדים דירוג בין 1 ל־999.',
	'securepoll-unranked-options' => 'כמה מהאפשרויות לא דורגו.
יש לקבוע לכל האפשרויות דירוג בין 1 ל־999.',
	'securepoll-invalid-score' => 'הדירוג חייב להיות מספר בין $1 ל־$2.',
	'securepoll-unanswered-options' => 'עליכם להשיב לכל שאלה.',
	'securepoll-remote-auth-error' => 'שגיאה בקבלת פרטי החשבון שלכם מהשרת.',
	'securepoll-remote-parse-error' => 'שגיאה בפענוח התגובה על מידע הכניסה מהשרת.',
	'securepoll-api-invalid-params' => 'פרמטרים בלתי תקינים.',
	'securepoll-api-no-user' => 'לא נמצא משתמש עם מספר זה.',
	'securepoll-api-token-mismatch' => 'אסימון האבטחה לא מתאים, לא ניתן להיכנס לחשבון.',
	'securepoll-not-logged-in' => 'עליכם להיכנס לחשבון כדי להצביע בהצבעה זו',
	'securepoll-too-few-edits' => 'מצטערים, אינכם יכולים להצביע. היה עליכם לערוך לפחות {{PLURAL:עריכה אחת|$1 עריכות}} כדי להצביע בהצבעה זו, וערכתם רק {{PLURAL:$2|אחת|$2}}.',
	'securepoll-blocked' => 'מצטערים, אינכם יכולים להצביע בהצבעה זו אם אתם חסומים כרגע מעריכה.',
	'securepoll-bot' => 'מצטערים, חשבונות עם דגל בוט אינם רשאים להצביע בהצבעה זו.',
	'securepoll-not-in-group' => 'רק חברים בקבוצה "$1" יכולים להצביע בהצבעה זו.',
	'securepoll-not-in-list' => 'מצטערים, אינכם ברשימת המשתמשים שהוגדרו מראש כרשאים להצביע בהצבעה זו.',
	'securepoll-list-title' => 'רשימת הצבעות: $1',
	'securepoll-header-timestamp' => 'זמן',
	'securepoll-header-voter-name' => 'שם',
	'securepoll-header-voter-domain' => 'דומיין',
	'securepoll-header-ua' => 'זיהוי דפדפן',
	'securepoll-header-cookie-dup' => 'יצירת עותק',
	'securepoll-header-strike' => 'מחיקה',
	'securepoll-header-details' => 'פרטים',
	'securepoll-strike-button' => 'מחיקה',
	'securepoll-unstrike-button' => 'ביטול מחיקה',
	'securepoll-strike-reason' => 'סיבה:',
	'securepoll-strike-cancel' => 'ביטול',
	'securepoll-strike-error' => 'שגיאה בביצוע הסתרה או בביטול הסתרה: $1',
	'securepoll-strike-token-mismatch' => 'מידע הכניסה אבד',
	'securepoll-details-link' => 'פרטים',
	'securepoll-details-title' => 'פרטי ההצבעה: #$1',
	'securepoll-invalid-vote' => '"$1" אינו מספר הצבעה תקין',
	'securepoll-header-id' => 'מספר',
	'securepoll-header-voter-type' => 'סוג המצביע',
	'securepoll-voter-properties' => 'מאפייני המצביע',
	'securepoll-strike-log' => 'יומן הסתרת הצבעות',
	'securepoll-header-action' => 'פעולה',
	'securepoll-header-reason' => 'סיבה',
	'securepoll-header-admin' => 'מנהל',
	'securepoll-cookie-dup-list' => 'משתמשים שנוצר עותק של העוגיה שלהם',
	'securepoll-dump-title' => 'העתק מוצפן: $1',
	'securepoll-dump-no-crypt' => 'לא נמצאה רשומת הצבעה מוצפנת עבור הצבעה זו, כיוון שההצבעה אינה מוגדרת לשימוש בהצפנה.',
	'securepoll-dump-not-finished' => 'רשומות ההצבעה המוצפנות זמינות רק לאחר תאריך הסיום ב־$2, $1',
	'securepoll-dump-no-urandom' => 'לא ניתן לפתוח את /dev/urandom. 
כדי לשמור על פרטיות המצביעים, רשומות ההצבעה המוצפנות זמינותת באופן ציבורי רק כאשר ניתן לערבב אותן באמצעות זרם המשתמש במספר אקראי מאובטח.',
	'securepoll-urandom-not-supported' => 'שרת זה אינו תומך ביצירת מספרים אקראיים לצורך הצפנה.
כדי לשמור על פרטיות הבוחרים, רשומות ההצבעה המוצפנות תהיינה זמינות לציבור רק כאשר ניתן יהיה לערבלן באמצעות זרם מספרים אקראיים מאובטח.',
	'securepoll-translate-title' => 'תרגום: $1',
	'securepoll-invalid-language' => 'קוד שפה בלתי תקין "$1"',
	'securepoll-header-trans-id' => 'מספר',
	'securepoll-submit-translate' => 'עדכון',
	'securepoll-language-label' => 'בחירת שפה:',
	'securepoll-submit-select-lang' => 'תרגום',
	'securepoll-entry-text' => 'להלן רשימת הסקרים.',
	'securepoll-header-title' => 'שם',
	'securepoll-header-start-date' => 'תאריך התחלה',
	'securepoll-header-end-date' => 'תאריך סיום',
	'securepoll-subpage-vote' => 'הצבעה',
	'securepoll-subpage-translate' => 'תרגום',
	'securepoll-subpage-list' => 'רשימה',
	'securepoll-subpage-dump' => 'העתק מוצפן',
	'securepoll-subpage-tally' => 'חישוב תוצאות',
	'securepoll-tally-title' => 'חישוב תוצאות: $1',
	'securepoll-tally-not-finished' => 'מצטערים, אינכם יכולים לחשב את תוצאות ההצבעה עד שיושלם תהליך ההצבעה.',
	'securepoll-can-decrypt' => 'רישום ההצבעה הוצפן, אך מפתח הפענוח זמין.
	באפשרותכם לחשב את התוצאות המאוחסנות בבסיס הנתונים, או לחשב את התוצאות המוצפנות מקובץ מועלה.',
	'securepoll-tally-no-key' => 'אין באפשרותכם לחשב את התוצאות של הצבעה זו, כיוון שההצבעות מוצפנות, ומפתח הפענוח אינו זמין.',
	'securepoll-tally-local-legend' => 'חישוב התוצאות המוצפנות',
	'securepoll-tally-local-submit' => 'חישוב התוצאות',
	'securepoll-tally-upload-legend' => 'העלאת עותק מוצפן',
	'securepoll-tally-upload-submit' => 'חישוב התוצאות',
	'securepoll-tally-error' => 'שגיאה בפענוח ההצבעה, לא ניתן לחשב את התוצאות.',
	'securepoll-no-upload' => 'לא הועלה קובץ, לא ניתן לחשב את התוצאות.',
	'securepoll-dump-corrupt' => 'העותק המוצפן הוא פגום ולא ניתן לעבדו.',
	'securepoll-tally-upload-error' => 'שגיאה בחישוב התוצאות מתוך ההעתק המוצפן: $1',
	'securepoll-pairwise-victories' => 'טבלת הניצחון בזוגות',
	'securepoll-strength-matrix' => 'טבלת חוזק הנתיב',
	'securepoll-ranks' => 'דירוג סופי',
	'securepoll-average-score' => 'ניקוד ממוצע',
);

/** Hindi (हिन्दी)
 * @author Vsrawat
 * @author आलोक
 */
$messages['hi'] = array(
	'securepoll' => 'सुरक्षितनिर्वाचन',
	'securepoll-desc' => 'निर्वाचनों और सर्वेक्षणों के लिए विस्तार',
	'securepoll-invalid-page' => 'अवैध उपपृष्ठ "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'यह क्रिया करने के लिए आपको एक एडमिन होना चाहिए।',
	'securepoll-too-few-params' => 'उपपृष्ठ के समुचित प्राचलक नहीं है (अमान्य कड़ी).',
	'securepoll-invalid-election' => '"$1" कोई वैध निर्वाचन आई डी नहीं है।',
	'securepoll-welcome' => '<strong>स्वागत $1!</strong>',
	'securepoll-not-started' => 'यह निर्वाचन अभी प्रारंभ नहीं हुआ है।
$3 तिथि को $2 बजे प्रारंभ होने के लिए समयबद्धीकृत है।',
	'securepoll-finished' => 'यह निर्वाचन समाप्त हो चुका है, अब आप मत नहीं दे सकते हैं।',
	'securepoll-not-qualified' => 'आप इस निर्वाचन में मतदान करने के लिए सुपात्र नहीं है: $1',
	'securepoll-change-disallowed' => 'आप इस निर्वाचन में पहले मत दे चुके हैं।
क्षमा करें, आप फिर से मत नहीं दे सकते हैं।',
	'securepoll-change-allowed' => '<strong>टिप्पणी: आप इस निर्वाचन में पहले मत दे चुके हैं।</strong>
आप नीचे दिए प्रपत्र को जमा कर के अपना मत बदल सकते हैं।
ध्यान दें कि यदि आप ऐसा करते हैं, तो आपका पिछला मत अलग हटा दिया जाएगा।',
	'securepoll-submit' => 'मत जमा करें',
	'securepoll-gpg-receipt' => 'मतदान के लिए धन्यवाद।



यदि आप चाहते हैं, तो आप इस निम्नलिखित पावती को अपने मत के प्रमाण के रुप में रख सकते हैं:

<pre>$1</pre>',
	'securepoll-thanks' => 'आपका धन्यवाद, आपका मत दर्ज कर लिया गया है।',
	'securepoll-return' => '$1 पर वापस जायें।',
	'securepoll-encrypt-error' => 'आपके मत का रिकॉर्ड कूटबद्ध करने में असफल हो गए।

आपका मत दर्ज नहीं किया गया है!

$1',
	'securepoll-no-gpg-home' => 'जी पी जी गृह डाइरेक्टरी बनाने में असमर्थ।',
	'securepoll-secret-gpg-error' => 'जी पी जी को चलाने में त्रुटि।

अधिक विवरण दिखाने के लिए LocalSettings.php में $wgSecurePollShowErrorDetail=true; का प्रयोग करें।',
	'securepoll-full-gpg-error' => 'जी पी जी को चलाने में त्रुटि:

आदेश: $1

त्रुटि:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'जी पी जी कुंजियाँ गलत प्रकार से विन्यासित हैं।',
	'securepoll-gpg-parse-error' => 'जी पी जी आउटपुट को बाँचने में त्रुटि।',
	'securepoll-no-decryption-key' => 'कोई कूटमुक्तिकरण कुँजी विन्यासित नहीं है।
कूटमुक्त नहीं कर सकते।',
	'securepoll-jump' => 'मतदान सर्वर पर जाएँ',
	'securepoll-bad-ballot-submission' => 'आपका मत अवैध है: $1',
	'securepoll-unanswered-questions' => 'आपको सभी प्रश्नों के उत्तर देने चाहिएँ।',
	'securepoll-invalid-rank' => 'अवैध क्रम। आपको प्रत्याशियों को 1 से 999 के बीच में कोई क्रम देना चाहिए।',
	'securepoll-unranked-options' => 'कुछ विकल्पों को क्रम नहीं दिया गया था।

आपको सभी विकल्पों को 1 से 999 के बीच में कोई क्रम देना चाहिए।',
	'securepoll-remote-auth-error' => 'इस सर्वर से आपके खाते की जानकारी ले के आने में त्रुटि।',
	'securepoll-remote-parse-error' => 'इस सर्वर से इस अधिकृतिकरण के उत्तर को बाँचने में त्रुटि।',
	'securepoll-api-invalid-params' => 'अवैध प्राचलक।',
	'securepoll-api-no-user' => 'दी गई आई डी के साथ कोई प्रयोक्ता नहीं मिला।',
	'securepoll-api-token-mismatch' => 'सुरक्षा बिल्ले का मिलान नहीं हुआ, लॉग नहीं कर सकते।',
	'securepoll-not-logged-in' => 'आपको इस निर्वाचन में मतदान करने के लिए लॉग इन अवश्य करना चाहिए।',
	'securepoll-too-few-edits' => 'क्षमा कीजिए, आप मतदान नहीं कर सकते। इस निर्वाचन में मतदान करने के लिए आपको न्यूनतम $1 संपादन {{PLURAL:$1|किया होना चाहिए|संपादन किए होने चाहिएँ}}, परंतु आपने $2 {{PLURAL:$2|किया है|किए हैं}}।',
	'securepoll-blocked' => 'क्षमा कीजिए, आप इस निर्वाचन में मतदान नहीं कर सकते यदि आप वर्तमान में संपादन करने से बाधित हैं।',
	'securepoll-bot' => 'क्षमा कीजिए, बोट झंडे वाले खातों को इस निर्वाचन में मतदान करने की अनुमति नहीं है।',
	'securepoll-not-in-group' => 'केवल समूह "$1" के सदस्य ही इस निर्वाचन में मतदान कर सकते हैं।',
	'securepoll-not-in-list' => 'क्षमा कीजिए, आपका नाम इस निर्वाचन में मतदान करने के लिए अधिकृत प्रयोक्ताओं की पूर्वनिर्धारित सूची में नहीं है।',
	'securepoll-list-title' => 'मतों की सूचि दिखाएँ: $1',
	'securepoll-header-timestamp' => 'समय',
	'securepoll-header-voter-name' => 'नाम',
	'securepoll-header-voter-domain' => 'डोमेन',
	'securepoll-header-ip' => 'आई पी',
	'securepoll-header-xff' => 'एक्स एफ़ एफ़',
	'securepoll-header-ua' => 'सदस्य कर्ता',
	'securepoll-header-token-match' => 'सी एस आर एफ़',
	'securepoll-header-cookie-dup' => 'दोहरा',
	'securepoll-header-strike' => 'मोहर लगाएँ',
	'securepoll-header-details' => 'विवरण',
	'securepoll-strike-button' => 'मोहर लगाएँ',
	'securepoll-unstrike-button' => 'मोहर हटाएँ',
	'securepoll-strike-reason' => 'कारण:',
	'securepoll-strike-cancel' => 'रद्द करें',
	'securepoll-strike-error' => 'मोहर लगाने/मोहर हटाने में त्रुटि: $1',
	'securepoll-strike-token-mismatch' => 'सत्र के आँकड़े खो गए',
	'securepoll-details-link' => 'विवरण',
	'securepoll-details-title' => 'मत के विवरण: #$1',
	'securepoll-invalid-vote' => '"$1" कोई वैध मत आई डी नहीं हैं',
	'securepoll-header-id' => 'आई डी',
	'securepoll-header-voter-type' => 'मतदाता का प्रकार',
	'securepoll-header-url' => 'यू आर एल',
	'securepoll-voter-properties' => 'मतदाता के गुणधर्म',
	'securepoll-strike-log' => 'मोहर की बही',
	'securepoll-header-action' => 'क्रिया',
	'securepoll-header-reason' => 'कारण',
	'securepoll-header-admin' => 'एडमिन',
	'securepoll-cookie-dup-list' => 'कुकी दोहरे प्रयोक्ता',
	'securepoll-dump-title' => 'ढेर: $1',
	'securepoll-dump-no-crypt' => 'इस निर्वाचन के लिए कोई कूटबद्ध निर्वाचन रिकॉर्ड उपलब्ध नहीं है, क्योंकि यह निर्वाचन कूटबद्धीकरण का प्रयोग करने के लिए तैयार नहीं किया गया है।',
	'securepoll-dump-not-finished' => 'कूटबद्धीकृत निर्वाचन रिकॉर्ड केवल समाप्ति तिथि $1 पर $2 समय के बाद ही उपलब्ध हैं',
	'securepoll-dump-no-urandom' => '/dev/urandom को खोल नहीं सकते।

मतदाताओं की निजता बनाए रखने के लिए, कूटबद्धीकृत निर्वाचन रिकॉर्ड केवल तभी सार्वजनिक रुप से उपलब्ध हैं जब उन्हें किसी सुरक्षित बेतरतीबवार (रैंडम) संख्या धारा के साथ फेंटा जा सकता है।',
	'securepoll-urandom-not-supported' => 'यह सर्वर गूढ़लेखनीय (क्रिप्टोग्राफ़िक) बेतरतीबवार (रैंडम) संख्या उत्पन्न करने को सहयोग नहीं देता है।

मतदाताओं की निजता बनाए रखने के लिए, कूटबद्धीकृत निर्वाचन रिकॉर्ड केवल तभी सार्वजनिक रुप से उपलब्ध हैं जब उन्हें किसी सुरक्षित बेतरतीबवार (रैंडम) संख्या धारा के साथ फेंटा जा सकता है।',
	'securepoll-translate-title' => 'अनुवाद करें: $1',
	'securepoll-invalid-language' => 'अवैध भाषा कूट "$1"',
	'securepoll-header-trans-id' => 'आई डी',
	'securepoll-submit-translate' => 'अद्यतनित करें',
	'securepoll-language-label' => 'भाषा का चयन करें:',
	'securepoll-submit-select-lang' => 'अनुवाद करें',
	'securepoll-header-title' => 'नाम',
	'securepoll-header-start-date' => 'प्रारंभ समय',
	'securepoll-header-end-date' => 'समाप्ति समय',
	'securepoll-subpage-vote' => 'मत दें',
	'securepoll-subpage-translate' => 'अनुवाद करें',
	'securepoll-subpage-list' => 'सूची देखें',
	'securepoll-subpage-dump' => 'ढेर करें',
	'securepoll-subpage-tally' => 'मिलान करें',
	'securepoll-tally-title' => 'मिलान करें: $1',
	'securepoll-tally-not-finished' => 'क्षमा कीजिए, आप इस निर्वाचन का मिलान तब नहीं कर सकते जब तक मतदान पूरा नहीं हो जाता है।',
	'securepoll-can-decrypt' => 'यह निर्वाचन जानकारी कूटबद्धीकृत की गई है, परंतु इसकी कूटमुक्तिकरण कुंजी उपलब्ध नहीं है।
या तो आप आँकड़ाकोष में मौजूद परिणामों का मिलान कर सकते हैं, या किसी चढ़ाई गई संचिका से कूटबद्धीकृत परिणामों का मिलान कर सकते हैं।',
	'securepoll-tally-no-key' => 'आप इस निर्वाचन का मिलान नहीं कर सकते हैं, क्योंकि ये मत कूटबद्धीकृत हैं, और इसकी कूटमुक्तिकरण कुंजी उपलब्ध नहीं है।',
	'securepoll-tally-local-legend' => 'भंडारित परिणामों का मिलान करें',
	'securepoll-tally-local-submit' => 'मिलान बनाएँ',
	'securepoll-tally-upload-legend' => 'कूटबद्धीकृत ढेर अपलोड करें',
	'securepoll-tally-upload-submit' => 'मिलान बनाएँ',
	'securepoll-tally-error' => 'मत के रिकॉर्ड को बाँचने में त्रुटि, किसी मिलान का निर्माण नहीं कर सकते।',
	'securepoll-no-upload' => 'कोई संचिका अपलोड नहीं की गई, परिणामों का मिलान नहीं कर सकते।',
	'securepoll-dump-corrupt' => 'यह निपात संचिका भ्रष्ट है और प्रक्रियाकृत नहीं की जा सकती है।',
	'securepoll-tally-upload-error' => 'निपात संचिका का मिलान करने में त्रुटि: $1',
	'securepoll-pairwise-victories' => 'जोड़ीबद्ध विजय मैट्रिक्स',
	'securepoll-strength-matrix' => 'पथ की शक्ति का मैट्रिक्स',
	'securepoll-ranks' => 'अंतिम क्रम',
);

/** Croatian (Hrvatski)
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'securepoll' => 'SigurnoGlasovanje',
	'securepoll-desc' => 'Mediawiki ekstenzija za izbore i ankete',
	'securepoll-invalid-page' => 'Nevaljana podstranica "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Morate biti administrator izbora za izvršenje ove radnje.',
	'securepoll-too-few-params' => 'Nema dovoljno parametara podstranice (neispravna poveznica).',
	'securepoll-invalid-election' => '"$1" nije valjani izborni ID.',
	'securepoll-welcome' => '<strong>Dobrodošli $1!</strong>',
	'securepoll-not-started' => 'Izbori nisu još počeli.
Počinju dana $2 u $3 sati.',
	'securepoll-finished' => 'Ovi izbori su okončani, ne možete više glasovati.',
	'securepoll-not-qualified' => 'Niste kvalificirani za glasovanje na ovim izborima: $1',
	'securepoll-change-disallowed' => 'Već ste glasovali na ovim izborima.
Žalimo, ne možete glasovati opet.',
	'securepoll-change-allowed' => '<strong>Napomena: Vi ste već glasovali na ovim izborima.</strong>
Možete promijeniti svoj glas/svoje glasove ispunjavanjem donjeg obrasca.
No ako to učinite, vaše će prvo glasovanje biti poništeno.',
	'securepoll-submit' => 'Glasuj',
	'securepoll-gpg-receipt' => 'Hvala vam na glasovanju.

Ako želite, možete zadržati (snimiti) slijedeći izraz kao dokaz vašeg glasovanja:

<pre>$1</pre>',
	'securepoll-thanks' => 'Hvala, Vaš glas je zaprimljen.',
	'securepoll-return' => 'Vrati se na $1',
	'securepoll-encrypt-error' => 'Neuspjela enkripcija vašeg glasa.
Vaš glas nije zabilježen!

$1',
	'securepoll-no-gpg-home' => "Nije moguće napraviti GPG ''home'' direktorij.",
	'securepoll-secret-gpg-error' => 'Greška pri izvršavanju GPG-a.
Postavite $wgSecurePollShowErrorDetail=true; u LocalSettings.php datoteci da bi vidjeli više detalja.',
	'securepoll-full-gpg-error' => 'Pogreška pri izvršavanju GPG-a:

Naredba: $1

Pogreška:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG ključevi nisu pravilno konfigurirani.',
	'securepoll-gpg-parse-error' => 'Pogreška pri prijevodu izlaza iz GPG-a.',
	'securepoll-no-decryption-key' => 'Dekripcijski ključ nije konfiguriran.
Dekripcija nije moguća.',
	'securepoll-jump' => 'Idi na poslužitelj za glasovanje',
	'securepoll-bad-ballot-submission' => 'Vaš glas je bio nevažeći: $1',
	'securepoll-unanswered-questions' => 'Morate odgovoriti na sva pitanja.',
	'securepoll-invalid-rank' => 'Pogrešan rang. Kandidatima morate dati rang između 1 i 999.',
	'securepoll-unranked-options' => 'Neke opcije nisu rangirane.
Morate dati svim opcijama rang između 1 i 999.',
	'securepoll-remote-auth-error' => 'Pogreška pri dobavljanje informacije o Vašem računu s poslužitelja.',
	'securepoll-remote-parse-error' => 'Pogreška pri tumačenju autorizacijskog odgovora s poslužitelja.',
	'securepoll-api-invalid-params' => 'Nevažeći parametri.',
	'securepoll-api-no-user' => 'Nema suradnika s tim ID brojem.',
	'securepoll-api-token-mismatch' => 'Neslaganje sigurnosnog tokena, neuspjela prijava.',
	'securepoll-not-logged-in' => 'Morate se prijaviti da bi mogli glasovati na ovim izborima',
	'securepoll-too-few-edits' => 'Nažalost, ne možete glasovati. Morate imati najmanje $1 {{PLURAL:$1|uređivanje|uređivanja|uređivanja}} da bi mogli glasovati na ovim izborima, vi ih imate $2.',
	'securepoll-blocked' => 'Nažalost, ne možete glasovati na ovim izborima ako ste trenutačno blokirani',
	'securepoll-bot' => 'Nažalost, računi s bot statusom ne mogu glasovati na ovim izborima.',
	'securepoll-not-in-group' => 'Samo članovi "$1" grupe mogu glasovati na ovim izborima.',
	'securepoll-not-in-list' => 'Nažalost, niste na popisu ovlaštenih suradnika koji mogu glasovati na ovim izborima.',
	'securepoll-list-title' => 'Popis glasova: $1',
	'securepoll-header-timestamp' => 'Vrijeme',
	'securepoll-header-voter-name' => 'Ime',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Suradnički posrednik',
	'securepoll-header-cookie-dup' => 'Dupl',
	'securepoll-header-strike' => 'Prekriži',
	'securepoll-header-details' => 'Detalji',
	'securepoll-strike-button' => 'Prekriži',
	'securepoll-unstrike-button' => 'Ukloni prekriženo',
	'securepoll-strike-reason' => 'Razlog:',
	'securepoll-strike-cancel' => 'Odustani',
	'securepoll-strike-error' => 'Pogreška tijekom izvođenja prekriži/ukloni prekriženo: $1',
	'securepoll-strike-token-mismatch' => 'Izgubljeni su podaci o sesiji',
	'securepoll-details-link' => 'Detalji',
	'securepoll-details-title' => 'Detalji glasovanja: #$1',
	'securepoll-invalid-vote' => '"$1" nije valjan glasački ID',
	'securepoll-header-voter-type' => 'Vrsta glasača',
	'securepoll-voter-properties' => 'Svojstva glasača',
	'securepoll-strike-log' => 'Evidencija križanja',
	'securepoll-header-action' => 'Radnja',
	'securepoll-header-reason' => 'Razlog',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Suradnici s dvostrukim kolačićima',
	'securepoll-dump-title' => 'Ispis: $1',
	'securepoll-dump-no-crypt' => 'Enkriptirani zapis ovih izbora nije dostupan, jer enkripcija nije postavljena.',
	'securepoll-dump-not-finished' => 'Enkriptirani zapisi izbora dostupni su samo poslije datuma okončanja - $1 u $2 sati',
	'securepoll-dump-no-urandom' => 'Ne mogu otvoriti /dev/urandom.
Da biste zadržali privatnost glasača, enkriptirani zapisi izbora su javno dostupni samo kad ih se može izmiješati uporabom niza sigurnih slučajnih brojeva.',
	'securepoll-urandom-not-supported' => 'Ovaj poslužitelj ne podržava kriptografsko generiranje slučajnog broja.
Kako bi se očuvala privatnost glasača, enkriptirani zapisi izbora javno su dostupni jedino kad ih se može izmiješati sa sigurnim nizom slučajnih brojeva.',
	'securepoll-translate-title' => 'Prevedi: $1',
	'securepoll-invalid-language' => 'Neispravan jezični kôd "$1"',
	'securepoll-submit-translate' => 'Ažuriraj',
	'securepoll-language-label' => 'Odaberite jezik:',
	'securepoll-submit-select-lang' => 'Prevedi',
	'securepoll-header-title' => 'Ime',
	'securepoll-header-start-date' => 'Početni datum',
	'securepoll-header-end-date' => 'Krajnji datum',
	'securepoll-subpage-vote' => 'Glasuj',
	'securepoll-subpage-translate' => 'Prevedi',
	'securepoll-subpage-list' => 'Popis',
	'securepoll-subpage-dump' => 'Ispis',
	'securepoll-subpage-tally' => 'Rezultat',
	'securepoll-tally-title' => 'Rezultat: $1',
	'securepoll-tally-not-finished' => 'Nažalost, ne možete vidjeti rezultate izbora za trajanja glasovanja.',
	'securepoll-can-decrypt' => 'Izborni zapis je enkriptiran, ali dekripcijski ključ je dostupan.
Možete odabrati bilo prikaz rezultata iz baze podataka, ili prikaz enkriptiranih rezultata iz učitane datoteke.',
	'securepoll-tally-no-key' => 'Ne možete prikazati rezultate ovih izbore, jer su glasovi enkriptirani a dekripcijski ključ nije dostupan.',
	'securepoll-tally-local-legend' => 'Prikaži raspodjelu glasova pohranjenih izbora',
	'securepoll-tally-local-submit' => 'Napravi prikaz rezultata',
	'securepoll-tally-upload-legend' => 'Učitaj enkriptirani ispis',
	'securepoll-tally-upload-submit' => 'Napravi prikaz rezultata (raspodjelu glasova)',
	'securepoll-tally-error' => 'Pogreška pri prijevodu zapisa glasa, nije moguće prikazati raspodjelu glasova.',
	'securepoll-no-upload' => 'Datoteka nije učitana, ne mogu prikazati raspodjelu rezultata.',
	'securepoll-dump-corrupt' => 'Ispisana datoteka je oštećena i ne može biti obrađena.',
	'securepoll-tally-upload-error' => 'Pogreška pri prikazu rezultata iz ispisane datoteke: $1',
	'securepoll-pairwise-victories' => 'Udvoji pobjedničku matricu',
	'securepoll-strength-matrix' => 'Putanja ojačane matrice',
	'securepoll-ranks' => 'Završno rangiranje',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'securepoll' => 'Wěste hłosowanje',
	'securepoll-desc' => 'Rozšěrjenje za wólby a naprašniki',
	'securepoll-invalid-page' => 'Njepłaćiwa podstrona "<nowiki>$1</nowiki>',
	'securepoll-need-admin' => 'Dyrbiš wólbny administrator być, zo by tutu akciju přewjedł.',
	'securepoll-too-few-params' => 'Nic dosć parametrow podstrony (njepłaćiwy wotkaz).',
	'securepoll-invalid-election' => '"$1" płaćiwy wólbny ID njeje.',
	'securepoll-welcome' => '<strong>Witaj $1!</strong>',
	'securepoll-not-started' => 'Wólba hišće njeje započała.
Započnje najskerje $2 $3.',
	'securepoll-finished' => 'Wólba je skónčena, njemóžeš hižo wothłosować.',
	'securepoll-not-qualified' => 'Njejsy woprawnjeny w tutej wólbje hłosować: $1',
	'securepoll-change-disallowed' => 'Sy hižo w tutej wólbje wothłosował.
Njesměš znowa wothłosować.',
	'securepoll-change-allowed' => '<strong>Pokazka: Sy hižo w tutej wólbje wothłosował.</strong>
Móžeš swój hłós změnić, hdyž slědowacy formular wotpósćeleš.
Kedźbu: jeli to činiš, budźe so twój prěnjotny hłós přepisować.',
	'securepoll-submit' => 'Hłós wotedać',
	'securepoll-gpg-receipt' => 'Dźakuju za wothłosowanje.

Jeli chceš, móžeš slědowace wobkrućenje jako dokład za swój hłós wobchować:

<pre>$1$</pre>',
	'securepoll-thanks' => 'Dźakujemy so, twój hłós bu zregistrowany.',
	'securepoll-return' => 'Wróćo k $1',
	'securepoll-encrypt-error' => 'Zaklučowanje twojeho wotedaća hłosa je so njeporadźiło.
Twój hłós njeje so zregistrował!

$1',
	'securepoll-no-gpg-home' => 'Njemóžno domjacy zapis GPG wutworić.',
	'securepoll-secret-gpg-error' => 'Zmylk při wuwjedźenju GPG.
Wužij $wgSecurePollShowErrorDetail=true; w LocalSettings.php, zo by dalše podrobnosće pokazał.',
	'securepoll-full-gpg-error' => 'Zmylk při wuwjedźenju GPG:

Přikaz: $1

Zmylk:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-kluče su wopak konfigurowane.',
	'securepoll-gpg-parse-error' => 'Zmylk při interpretowanju wudaća GPG.',
	'securepoll-no-decryption-key' => 'Žadyn dešifrowanski kluč konfigurowany.
Dešifrowanje njemóžno.',
	'securepoll-jump' => 'K serwerej wothłosowanja',
	'securepoll-bad-ballot-submission' => 'Twój hłós bě njepłaćiwy: $1',
	'securepoll-unanswered-questions' => 'Dyrbiš na wšě prašenja wotmołwić.',
	'securepoll-invalid-rank' => 'Njepłaćiwy rjad. Dyrbiš kandidatam rjad mjez 1 a 999 dać.',
	'securepoll-unranked-options' => 'Někotre opcije rjad nimaja.
Dyrbiš wšěm opcijam rjad mjez 1 a 999 dać.',
	'securepoll-invalid-score' => 'Wuslědk dyrbi ličba mjez $1 a $2 być.',
	'securepoll-unanswered-options' => 'Dyrbiš na kóžde prašenje wotmołwić.',
	'securepoll-remote-auth-error' => 'Zmylk při wotwołowanju kontowych informacijow ze serwera.',
	'securepoll-remote-parse-error' => 'Zmylk při interpretowanju awtorizaciskeje wotmołwy serwera.',
	'securepoll-api-invalid-params' => 'Njepłaćiwe parametry.',
	'securepoll-api-no-user' => 'Wužiwar z podatym ID njeje.',
	'securepoll-api-token-mismatch' => 'Wěstotne tokeny so njerunaja, přizjewjenje njemóžno.',
	'securepoll-not-logged-in' => 'Dyrbiš so přizjewić, zo by w tutej wólbje wothłosował.',
	'securepoll-too-few-edits' => 'Wodaj, njemóžeš wothłosować. Dyrbiš znajmjeńša $1 {{PLURAL:$1|změnu|změnje|změny|změnow}} činić, zo by w tutej wólbje wothłosował, sy $2 činił.',
	'securepoll-blocked' => 'Wodaj, njemóžeš w tutej wólbhje wothłosować, dokelž sy za wobdźěłowanje zablokowany.',
	'securepoll-bot' => 'Wodaj, ale konta z botowej chorhojčku  njesmědźa w tutej wólbje wothłosować.',
	'securepoll-not-in-group' => 'Jenož čłony skupiny $1 móžeja w tutej wólbje wothłosować.',
	'securepoll-not-in-list' => 'Wodaj, njejsy w lisćinje woprawnjenych wužiwarjow, kotřiž smědźa w tutej wólbje wothłosować.',
	'securepoll-list-title' => 'Hłosy nalistować: $1',
	'securepoll-header-timestamp' => 'Čas',
	'securepoll-header-voter-name' => 'Mjeno',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Identifikator wobhladowaka',
	'securepoll-header-cookie-dup' => 'Duplikat',
	'securepoll-header-strike' => 'Šmórnyć',
	'securepoll-header-details' => 'Podrobnosće',
	'securepoll-strike-button' => 'Šmórnyć',
	'securepoll-unstrike-button' => 'Šmórnjenje cofnyć',
	'securepoll-strike-reason' => 'Přičina:',
	'securepoll-strike-cancel' => 'Přetorhnyć',
	'securepoll-strike-error' => 'Zmylk při přewjedźenju šmórnjenja/cofnjenja šmórnjenja: $1',
	'securepoll-strike-token-mismatch' => 'Daty posedźenja zhubjene',
	'securepoll-details-link' => 'Podrobnosće',
	'securepoll-details-title' => 'Podrobnosće hłosowanja: #$1',
	'securepoll-invalid-vote' => '"$1" płaćiwy hłosowanski ID njeje.',
	'securepoll-header-voter-type' => 'Wolerski typ',
	'securepoll-voter-properties' => 'Kajkosće wolerja',
	'securepoll-strike-log' => 'Protokol šmórnjenjow',
	'securepoll-header-action' => 'Akcija',
	'securepoll-header-reason' => 'Přičina',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => 'Dwójni wužiwarjo z plackom',
	'securepoll-dump-title' => 'Wućah: $1',
	'securepoll-dump-no-crypt' => 'Za tutu wólbu žana zaklučowana lisćina wólby k dispoziciji njesteji, dokelž wólba njeje konfigurowana, zo by zaklučowanje wužiwała.',
	'securepoll-dump-not-finished' => 'Zaklučowane zapiski wólby jenož po kónčnym datumje $1 $2 k dispoziciji steja',
	'securepoll-dump-no-urandom' => '/dev/urandom njeda so wočinić.
Zo by so škit datow wolerja wobchował, zaklučowane zapisy jenož zjawnje k dispoziciji steja, hdyž hodźa so   z wěstotnym prudom připadnych ličbow měšeć.',
	'securepoll-urandom-not-supported' => 'Tutón serwer kryptografiske płodźenje připadnych ličbow njepodpěruje.
Zo by so priwatnosć wolerja wobchowała, su zaklučowane wólbne zapiski jenož zjawnje k dispoziciji, hdyž  dadźa so z wěstym prudom připadnych ličbow měšeć.',
	'securepoll-translate-title' => 'Přełožić: $1',
	'securepoll-invalid-language' => 'Njepłaćiwy rěčny kod "$1"',
	'securepoll-submit-translate' => 'Aktualizować',
	'securepoll-language-label' => 'Rěč wubrać:',
	'securepoll-submit-select-lang' => 'Přełožić',
	'securepoll-entry-text' => 'Deleka je lisćina wothłosowanjow.',
	'securepoll-header-title' => 'Mjeno',
	'securepoll-header-start-date' => 'Spočatny datum',
	'securepoll-header-end-date' => 'Kónčny datum',
	'securepoll-subpage-vote' => 'Wothłosować',
	'securepoll-subpage-translate' => 'Přełožić',
	'securepoll-subpage-list' => 'Lisćina',
	'securepoll-subpage-dump' => 'Wućah',
	'securepoll-subpage-tally' => 'Ličenje',
	'securepoll-tally-title' => 'Ličenje: $1',
	'securepoll-tally-not-finished' => 'Wodaj, njemóžeš wílbu wuličić, doniž wothłosowanje njeje skónčene.',
	'securepoll-can-decrypt' => 'Wólbne zapisy su zaklučowane, ale dešifrowanski kluč k dispoziciji steji.
Móžeš pak wuslědki w datowej bance ličić pak zaklučowane wuslědki z nahrateje dataje ličić.',
	'securepoll-tally-no-key' => 'Njemóžeš tutu wólbu wuličić, dokelž hłosy su zaklučowane a dešufrowanski kluč k dispoziciji njesteji.',
	'securepoll-tally-local-legend' => 'Składowane wuslědki ličić',
	'securepoll-tally-local-submit' => 'Ličenje wutworić',
	'securepoll-tally-upload-legend' => 'Zaklučowany wućah nahrać',
	'securepoll-tally-upload-submit' => 'Ličenje wutworić',
	'securepoll-tally-error' => 'Zmylk při interpretowanju zapisow wothłosowanja, ličenje njeda so wutworić.',
	'securepoll-no-upload' => 'Njeje so žana dataja nahrała, wuslědki njehodźa so ličić.',
	'securepoll-dump-corrupt' => 'Dataja składowakoweho wobsaha je poškodźeny a njeda so předźěłać.',
	'securepoll-tally-upload-error' => 'Zmylk při wuličowanju dataje składowakeho wobsaha: $1',
	'securepoll-pairwise-victories' => 'Dobyćerski matriks po porach',
	'securepoll-strength-matrix' => 'Šćežka matriksa sylnosće',
	'securepoll-ranks' => 'Kónčny porjad',
	'securepoll-average-score' => 'Přerězne pohódnoćenje',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Cassandro
 * @author Cbrown1023
 * @author Dani
 * @author Glanthor Reviol
 * @author Tgr
 */
$messages['hu'] = array(
	'securepoll' => 'BiztonságosSzavazás',
	'securepoll-desc' => 'Kiegészítő választások és közvéleménykutatások lebonyolítására',
	'securepoll-invalid-page' => 'Érvénytelen allap: „"<nowiki>$1</nowiki>"”',
	'securepoll-need-admin' => 'Csak választási adminisztrátorok hajthatják végre ezt a műveletet.',
	'securepoll-too-few-params' => 'Nincs elég paraméter az allaphoz (érvénytelen hivatkozás).',
	'securepoll-invalid-election' => '„$1” nem érvényes választási azonosító.',
	'securepoll-welcome' => '<strong>Üdvözlünk $1!</strong>',
	'securepoll-not-started' => 'Ez a választás még nem kezdődött el.
Tervezett indulása: $2 $3.',
	'securepoll-finished' => 'A választás lezárult, már nem tudsz szavazni.',
	'securepoll-not-qualified' => 'Nincs jogod szavazni ezen a választáson: $1',
	'securepoll-change-disallowed' => 'Már szavaztál ezen a választáson.
Sajnáljuk, nem szavazhatsz újra.',
	'securepoll-change-allowed' => '<strong>Megjegyzés: korábban már szavaztál ezen a választáson.</strong>
Az alábbi űrlap elküldésével módosíthatod a szavazatodat.
Amennyiben ezt teszed, a korábbi szavazatod semmisnek minősül.',
	'securepoll-submit' => 'Szavazat elküldése',
	'securepoll-gpg-receipt' => 'Köszönjük, hogy szavaztál.

Ha szeretnéd, megtarthatod ezt az elismervényt, mint bizonyítékot, hogy szavaztál:

<pre>$1</pre>',
	'securepoll-thanks' => 'Köszönjük, a szavazatodat rögzítettük.',
	'securepoll-return' => 'Vissza ide: $1',
	'securepoll-encrypt-error' => 'Nem sikerült titkosítani a szavazatodat.
A szavazat nem lett rögzítve!

$1',
	'securepoll-no-gpg-home' => 'A GPG könyvtárát nem sikerült elkészíteni.',
	'securepoll-secret-gpg-error' => 'Hiba történt a GPG futtatásakor.
Használd a $wgSecurePollShowErrorDetail=true; parancsot a LocalSettings.php-ben a hiba részleteinek megjelenítéséhez.',
	'securepoll-full-gpg-error' => 'Hiba történt a GPG futtatásakor:

Parancs: $1

Hiba:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'A GPG-kulcsok hibásan vannak beállítva.',
	'securepoll-gpg-parse-error' => 'Hiba történt a GPG kimenetének értelmezése közben.',
	'securepoll-no-decryption-key' => 'Nincs visszafejtő kulcs beállítva.
Nem lehet visszafejteni.',
	'securepoll-jump' => 'Irány a szavazás-szerverre',
	'securepoll-bad-ballot-submission' => 'A szavazatod érvénytelen volt: $1',
	'securepoll-unanswered-questions' => 'Minden kérdésre válaszolnod kell.',
	'securepoll-invalid-rank' => 'Érvénytelen helyezés. A jelölteknek csak 1 és 999 közötti helyezést adhatsz.',
	'securepoll-unranked-options' => 'Néhány javaslatra nem adtál helyezést.
Minden javaslathoz egy 1 és 999 közötti helyezést kell adnod.',
	'securepoll-invalid-score' => 'A pontszámnak $1 és $2 közti számnak kell lennie.',
	'securepoll-unanswered-options' => 'Minden kérdést meg kell válaszolnod.',
	'securepoll-remote-auth-error' => 'Nem sikerült lekérdezni a felhasználói fiókod adatait a szerverről.',
	'securepoll-remote-parse-error' => 'Nem sikerült értelmezni a szerver autorizációs válaszát.',
	'securepoll-api-invalid-params' => 'Érvénytelen paraméterek.',
	'securepoll-api-no-user' => 'Nem található az adott ID-hez tartozó felhasználó.',
	'securepoll-api-token-mismatch' => 'Sikertelen bejelentkezés, nem egyezik a biztonsági token.',
	'securepoll-not-logged-in' => 'Be kell jelentkezned, hogy szavazhass.',
	'securepoll-too-few-edits' => 'Sajnos nem szavazhatsz. A részvételhez legalább $1 szerkesztés kell, neked csak $2 van.',
	'securepoll-blocked' => 'Nem szavazhatsz ezen a választáson, amíg blokkolva vagy.',
	'securepoll-bot' => 'Botnak jelölt felhasználók nem szavazhatnak ezen a választáson.',
	'securepoll-not-in-group' => 'Csak a „$1” csoport tagjai szavazhatnak ezen a választáson.',
	'securepoll-not-in-list' => 'Nem szerepelsz azoknak a felhasználóknak a listáján, akik szavazhatnak ezen a választáson.',
	'securepoll-list-title' => 'Szavazatok listázása: $1',
	'securepoll-header-timestamp' => 'Idő',
	'securepoll-header-voter-name' => 'Név',
	'securepoll-header-voter-domain' => 'Domain',
	'securepoll-header-ua' => 'Böngésző',
	'securepoll-header-cookie-dup' => 'Duplikátum',
	'securepoll-header-strike' => 'Törlés',
	'securepoll-header-details' => 'Részletek',
	'securepoll-strike-button' => 'Törlés',
	'securepoll-unstrike-button' => 'Törlés visszavonása',
	'securepoll-strike-reason' => 'Ok:',
	'securepoll-strike-cancel' => 'Mégse',
	'securepoll-strike-error' => 'Hiba történt a törléskor vagy a törlés visszavonásakor: $1',
	'securepoll-strike-token-mismatch' => 'A munkafázis adatai elvesztek.',
	'securepoll-details-link' => 'Részletek',
	'securepoll-details-title' => 'A szavazás részletei: #$1',
	'securepoll-invalid-vote' => 'A(z) „$1” nem érvényes szavazatazonosító',
	'securepoll-header-voter-type' => 'Szerkesztő típusa',
	'securepoll-voter-properties' => 'Szavazó tulajdonságai',
	'securepoll-strike-log' => 'Törlési napló',
	'securepoll-header-action' => 'Művelet',
	'securepoll-header-reason' => 'Ok',
	'securepoll-header-admin' => 'Adminisztrátor',
	'securepoll-cookie-dup-list' => 'Többször szavazók (süti alapján)',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'A szavazáshoz nem érhető el titkosított szavazatjegyzőkönyv, mert nem lett hozzá titkosítás beállítva.',
	'securepoll-dump-not-finished' => 'A titkosított szavazatjegyzőkönyvek csak a befejezési dátum ($1 $2) után érhetőek el.',
	'securepoll-dump-no-urandom' => 'Nem nyitható meg a /dev/urandom.
A szavazók névtelenségének megőrzése érdekében a titkosított szavazójegyzőkönyv csak akkor érhető el nyilvánosan, ha egy biztonságos véletlenszám-sorozattal lehet keverni.',
	'securepoll-urandom-not-supported' => 'Ez a szerver nem képes titkosításra alkalmas véletlenszámokat generálni.
A szavazás titkosságának megőrzésére a titkosított szavazatok csak akkor válnak nyilvánossá, ha rendelkezésre áll olyan egy biztonságos véletlenszámforrás, amivel a sorrendjük megkeverhető.',
	'securepoll-translate-title' => 'Fordítás: $1',
	'securepoll-invalid-language' => 'Érvénytelen nyelvkód: „$1”',
	'securepoll-submit-translate' => 'Frissítés',
	'securepoll-language-label' => 'Nyelv kiválasztása:',
	'securepoll-submit-select-lang' => 'Fordítás',
	'securepoll-entry-text' => 'Alább látható a szavazások listája.',
	'securepoll-header-title' => 'Név',
	'securepoll-header-start-date' => 'Kezdődátum',
	'securepoll-header-end-date' => 'Záródátum',
	'securepoll-subpage-vote' => 'Szavazás',
	'securepoll-subpage-translate' => 'Fordítás',
	'securepoll-subpage-list' => 'Listázás',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Összesítés',
	'securepoll-tally-title' => 'Összesítés: $1',
	'securepoll-tally-not-finished' => 'Sajnos nem tudod összesíteni a választást amíg a szavazás le nem zárult.',
	'securepoll-can-decrypt' => 'A szavazási jegyzőkönyvet titkosították, de a feloldókulcs elérhető.
Választhatod az adatbázisban szereplő eredmények összesítését vagy a titkosított eredmények összesítését egy feltöltött fájlból.',
	'securepoll-tally-no-key' => 'Nem lehet a szavazást összesíteni, mert a szavazatokat titkosították és a feloldókulcs nem elérhető.',
	'securepoll-tally-local-legend' => 'Tárolt eredmények összesítése',
	'securepoll-tally-local-submit' => 'Összesítés készítése',
	'securepoll-tally-upload-legend' => 'Titkosított dump feltöltése',
	'securepoll-tally-upload-submit' => 'Összesítés készítése',
	'securepoll-tally-error' => 'Hiba a szavazási jegyzőkönyv értelmezésében, nem lehetett összesítést készíteni.',
	'securepoll-no-upload' => 'Semmilyen fájlt nem töltöttek fel, az eredményt így nem lehet összesíteni.',
	'securepoll-dump-corrupt' => 'A dump fájl hibás, nem sikerült feldolgozni.',
	'securepoll-tally-upload-error' => 'Hiba a dump fájl összesítésekor: $1',
	'securepoll-pairwise-victories' => 'Páronkénti győzelmi mátrix',
	'securepoll-strength-matrix' => 'Útvonalerősség-mátrix',
	'securepoll-ranks' => 'Végső rangsor',
	'securepoll-average-score' => 'Átlagpontszám',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'securepoll' => 'Voto secur',
	'securepoll-desc' => 'Extension pro electiones e inquestas',
	'securepoll-invalid-page' => 'Subpagina  "<nowiki>$1</nowiki>" invalide',
	'securepoll-need-admin' => 'Tu debe esser un administrator de electiones pro poter executar iste action.',
	'securepoll-too-few-params' => 'Non satis de parametros del subpagina (ligamine invalide).',
	'securepoll-invalid-election' => '"$1" non es un identificator valide de un election.',
	'securepoll-welcome' => '<strong>Benvenite, $1!</strong>',
	'securepoll-not-started' => 'Iste election non ha ancora comenciate.
Le initio es programmate pro le $2 a $3.',
	'securepoll-finished' => 'Iste election ha finite. Tu non pote plus votar.',
	'securepoll-not-qualified' => 'Tu non es qualificate pro votar in iste election: $1',
	'securepoll-change-disallowed' => 'Tu ha ja votate in iste election.
Non es possibile votar de novo.',
	'securepoll-change-allowed' => '<strong>Nota: Tu ha ja votate in iste election.</strong>
Tu pote cambiar tu voto per submitter le formulario in basso.
Nota que si tu face isto, le voto original essera cancellate.',
	'securepoll-submit' => 'Submitter voto',
	'securepoll-gpg-receipt' => 'Gratias pro votar.

Si tu vole, tu pote retener le sequente recepta como prova de tu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Gratias, tu voto ha essite registrate.',
	'securepoll-return' => 'Retornar a $1',
	'securepoll-encrypt-error' => 'Impossibile cryptar le registro de tu voto.
Tu voto non ha essite registrate!

$1',
	'securepoll-no-gpg-home' => 'Impossibile crear le directorio de base pro GPG.',
	'securepoll-secret-gpg-error' => 'Error durante le execution de GPG.
Usa $wgSecurePollShowErrorDetail=true; in LocalSettings.php pro revelar plus detalios.',
	'securepoll-full-gpg-error' => 'Error durante le execution de GPG:

Commando: $1

Error:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Le claves GPG non es configurate correctemente.',
	'securepoll-gpg-parse-error' => 'Error durante le interpretation del output de GPG.',
	'securepoll-no-decryption-key' => 'Nulle clave de decryptation es configurate.
Impossibile decryptar.',
	'securepoll-jump' => 'Ir al servitor de votation',
	'securepoll-bad-ballot-submission' => 'Tu voto esseva invalide: $1',
	'securepoll-unanswered-questions' => 'Tu debe responder a tote le questiones.',
	'securepoll-invalid-rank' => 'Rango invalide. Tu debe dar al candidatos un rango inter 1 e 999.',
	'securepoll-unranked-options' => 'Alcun optiones non ha un rango.
Tu debe dar a tote le optiones un rango inter 1 e 999.',
	'securepoll-invalid-score' => 'Le score debe esser un numero inter $1 e $2.',
	'securepoll-unanswered-options' => 'Tu debe dar un responsa a cata question.',
	'securepoll-remote-auth-error' => 'Error durante le lectura del informationes de tu conto ab le servitor.',
	'securepoll-remote-parse-error' => 'Error durante le interpretation del responsa de autorisation ab le servitor.',
	'securepoll-api-invalid-params' => 'Parametros invalide.',
	'securepoll-api-no-user' => 'Nulle usator ha essite trovate con le ID specificate.',
	'securepoll-api-token-mismatch' => 'Le indicio de securitate non corresponde; non pote aperir session.',
	'securepoll-not-logged-in' => 'Tu debe aperir un session pro votar in iste election.',
	'securepoll-too-few-edits' => 'Pardono, tu non pote votar. Tu debe haber facite al minus $1 {{PLURAL:$1|modification|modificationes}} pro votar in iste election, e tu ha facite $2.',
	'securepoll-blocked' => 'Pardono, tu non pote votar in iste election durante que tu es blocate de facer modificationes.',
	'securepoll-bot' => 'Pardono, le contos marcate como robot non es autorisate a votar in iste election.',
	'securepoll-not-in-group' => 'Solmente le membros del gruppo $1 pote votar in iste election.',
	'securepoll-not-in-list' => 'Pardono, tu non es in le lista predeterminate del usatores autorisate a votar in iste election.',
	'securepoll-list-title' => 'Lista del votos: $1',
	'securepoll-header-timestamp' => 'Tempore',
	'securepoll-header-voter-name' => 'Nomine',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Agente usator',
	'securepoll-header-cookie-dup' => 'Dupl.',
	'securepoll-header-strike' => 'Cancellation',
	'securepoll-header-details' => 'Detalios',
	'securepoll-strike-button' => 'Cancellar voto',
	'securepoll-unstrike-button' => 'Restaurar voto',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Cancellar',
	'securepoll-strike-error' => 'Error durante le cancellation/restauration: $1',
	'securepoll-strike-token-mismatch' => 'Datos de session perdite',
	'securepoll-details-link' => 'Detalios',
	'securepoll-details-title' => 'Detalios del voto: #$1',
	'securepoll-invalid-vote' => '"$1" non es un identificator valide de un voto',
	'securepoll-header-voter-type' => 'Typo de usator',
	'securepoll-voter-properties' => 'Proprietates del votator',
	'securepoll-strike-log' => 'Registro de cancellationes',
	'securepoll-header-action' => 'Action',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Usatores con cookie duplice',
	'securepoll-dump-title' => 'Extracto: $1',
	'securepoll-dump-no-crypt' => 'Nulle registro cryptate es disponibile pro iste election, proque le election non es configurate pro usar cryptation.',
	'securepoll-dump-not-finished' => 'Le registro cryptate del election non essera disponibile usque le data final: le $1 a $2',
	'securepoll-dump-no-urandom' => 'Impossibile aperir /dev/urandom.
Pro mantener le confidentialitate del votatores, le registro cryptate del election non essera disponibile al publico usque illo pote esser miscite con un fluxo secur de numeros aleatori.',
	'securepoll-urandom-not-supported' => 'Iste servitor non supporta le generation de numeros aleatori cryptographic.
Pro assecurar le confidentialitate del votatores, le datos cryptate del election es solo publicamente disponibile si illos pote esser miscite con un fluxo de numeros aleatori secur.',
	'securepoll-translate-title' => 'Traducer: $1',
	'securepoll-invalid-language' => 'Le codice de lingua "$1" es invalide',
	'securepoll-submit-translate' => 'Actualisar',
	'securepoll-language-label' => 'Selige lingua:',
	'securepoll-submit-select-lang' => 'Traducer',
	'securepoll-entry-text' => 'Ci infra es le lista de votationes.',
	'securepoll-header-title' => 'Nomine',
	'securepoll-header-start-date' => 'Data de initio',
	'securepoll-header-end-date' => 'Data de fin',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traducer',
	'securepoll-subpage-list' => 'Listar',
	'securepoll-subpage-dump' => 'Discargar',
	'securepoll-subpage-tally' => 'Contar',
	'securepoll-tally-title' => 'Conto: $1',
	'securepoll-tally-not-finished' => 'Pardono, tu non pote contar le resultatos del election ante que le illo ha finite.',
	'securepoll-can-decrypt' => 'Le registro del election ha essite cryptate, ma le clave de decryptation es disponibile.
Tu pote optar pro contar le resultatos presente in le base de datos, o pro contar le resultatos cryptate ab un file que tu cargara.',
	'securepoll-tally-no-key' => 'Tu non pote contar le resultatos de iste election proque le votos es cryptate e le clave de decryptation non es disponibile.',
	'securepoll-tally-local-legend' => 'Contar le resulatos immagazinate',
	'securepoll-tally-local-submit' => 'Contar resultatos',
	'securepoll-tally-upload-legend' => 'Incargar un file de datos cryptate',
	'securepoll-tally-upload-submit' => 'Contar resultatos',
	'securepoll-tally-error' => 'Error durante le interpretation del registro de voto; non pote producer un conto.',
	'securepoll-no-upload' => 'Nulle file ha essite cargate; non pote contar le resultatos.',
	'securepoll-dump-corrupt' => 'Le file de dump es corrumpite e non pote esser processate.',
	'securepoll-tally-upload-error' => 'Error de contar ex le file de dump: $1',
	'securepoll-pairwise-victories' => 'Matrice de vincimento in pares',
	'securepoll-strength-matrix' => 'Matrice de fortia de cammino',
	'securepoll-ranks' => 'Rango final',
	'securepoll-average-score' => 'Score medie',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Pengaya untuk pemungutan suara dan survei',
	'securepoll-invalid-page' => 'Subhalaman tidak sah "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Anda harus menjadi seorang pengurus pemilihan untuk dapat melakukan tindakan ini.',
	'securepoll-too-few-params' => 'Parameter subhalaman tidak lengkap (pranala tidak sah).',
	'securepoll-invalid-election' => 'ID pemilihan tidak sah: "$1"',
	'securepoll-welcome' => '<strong>Selamat datang $1!</strong>',
	'securepoll-not-started' => 'Pemungutan suara ini belum dimulai
dan baru akan berlangsung pada $3, $2.',
	'securepoll-finished' => 'Pemungutan suara telah selesai, Anda sudah tidak dapat memberikan suara.',
	'securepoll-not-qualified' => 'Anda belum memenuhi syarat untuk memberikan suara dalam pemungutan suara ini: $1',
	'securepoll-change-disallowed' => 'Anda telah memberikan suara dalam pemilihan ini sebelumnya.
Maaf, Anda tidak dapat memberikan suara lagi.',
	'securepoll-change-allowed' => '<strong>Catatan: Anda sudah pernah memberikan suara dalam pemilihan kali ini.</strong>
Anda dapat mengganti suara Anda dengan menggunakan formulir di bawah ini. Suara Anda sebelumnya akan dibatalkan jika Anda mengirimkan suara baru.',
	'securepoll-submit' => 'Kirim suara',
	'securepoll-gpg-receipt' => 'Terima kasih atas suara Anda.

Jika diperlukan, Anda dapat menyimpan bukti penerimaan suara Anda di bawah ini:

<pre>$1</pre>',
	'securepoll-thanks' => 'Terima kasih, suara Anda telah dicatat.',
	'securepoll-return' => 'Kembali ke $1',
	'securepoll-encrypt-error' => 'Gagal meng-enkripsi catatan suara Anda.
Voting Anda belum tercatat!

$1',
	'securepoll-no-gpg-home' => 'Gagal membuat direktori utama GPG.',
	'securepoll-secret-gpg-error' => 'Gagal menjalankan GPG.
Gunakan $wgSecurePollShowErrorDetail=true; di LocalSettings.php untuk menampilkan rincian lebih lanjut.',
	'securepoll-full-gpg-error' => 'Gagal menjalankan GPG:

Perintah: $1

Galat:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Kesalahan konfigurasi kunci GPG.',
	'securepoll-gpg-parse-error' => 'Gagal meng-interpretasikan hasil keluaran GPG.',
	'securepoll-no-decryption-key' => 'Kunci dekripsi belum dikonfigurasikan.
Tidak dapat melakukan dekripsi.',
	'securepoll-jump' => 'Pergi ke peladen pemungutan suara',
	'securepoll-bad-ballot-submission' => 'Suara Anda tidak sah: $1',
	'securepoll-unanswered-questions' => 'Anda harus menjawab semua pertanyaan.',
	'securepoll-invalid-rank' => 'Peringkat tidak sah. Anda harus memberi peringkat kandidat antara 1 dan 99.',
	'securepoll-unranked-options' => 'Beberapa pilihan tidak diberi peringkat.
Anda harus memberi peringkat antara 1 dan 99 untuk semua pilihan.',
	'securepoll-invalid-score' => 'Nilai haruslah nomor antara $1 dan $2.',
	'securepoll-unanswered-options' => 'Anda harus memberi tanggapan terhadap setiap pertanyaan.',
	'securepoll-remote-auth-error' => 'Terjadi kesalahan ketika mengambil informasi akun Anda dari peladen.',
	'securepoll-remote-parse-error' => 'Terjadi kesalahan interpretasi atas respon otorisasi dari peladen.',
	'securepoll-api-invalid-params' => 'Parameter tidak sah.',
	'securepoll-api-no-user' => 'Tidak ditemukan nama pengguna dengan ID tersebut.',
	'securepoll-api-token-mismatch' => 'Kode keamanan tidak sesuai, tidak dapat masuk log.',
	'securepoll-not-logged-in' => 'Anda harus masuk log untuk dapat memberikan suara dalam pemilihan ini',
	'securepoll-too-few-edits' => 'Maaf, Anda tidak dapat memberikan suara. Anda harus memiliki minimal $1 {{PLURAL:$1|suntingan|suntingan}} untuk dapat memberikan suara dalam pemilihan ini, Anda hanya memiliki $2.',
	'securepoll-blocked' => 'Maaf, Anda tidak dapat memberikan suara karena akun Anda sedang diblokir.',
	'securepoll-bot' => 'Maaf, akun dengan status bot tidak diperbolehkan untuk memberikan suara dalam pemilihan ini.',
	'securepoll-not-in-group' => 'Hanya anggota kelompok "$1" yang dapat memberikan suara pada pemilihan ini.',
	'securepoll-not-in-list' => 'Maaf, Anda tidak terdaftar dalam daftar pemilih yang dapat memberikan suara.',
	'securepoll-list-title' => 'Daftar suara: $1',
	'securepoll-header-timestamp' => 'Waktu',
	'securepoll-header-voter-name' => 'Nama',
	'securepoll-header-voter-domain' => 'Domain',
	'securepoll-header-ua' => 'Aplikasi pengguna',
	'securepoll-header-cookie-dup' => 'Duplikat',
	'securepoll-header-strike' => 'Coret',
	'securepoll-header-details' => 'Rincian',
	'securepoll-strike-button' => 'Coret',
	'securepoll-unstrike-button' => 'Hapus coretan',
	'securepoll-strike-reason' => 'Alasan:',
	'securepoll-strike-cancel' => 'Batalkan',
	'securepoll-strike-error' => 'Gagal mencoret/membatalkan pencoretan: $1',
	'securepoll-strike-token-mismatch' => 'Data sesi terhilang',
	'securepoll-details-link' => 'Rincian',
	'securepoll-details-title' => 'Rincian suara: #$1',
	'securepoll-invalid-vote' => 'ID suara tidak sah: "$1"',
	'securepoll-header-voter-type' => 'Jenis pengguna',
	'securepoll-voter-properties' => 'Properti pengguna',
	'securepoll-strike-log' => 'Log pencoretan',
	'securepoll-header-action' => 'Tindakan',
	'securepoll-header-reason' => 'Alasan',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => "''Cookie'' pengguna duplikat",
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Tidak ada catatan pemilihan yang ter-enkripsi untuk pemilihan ini, karena pemilihan ini tidak dikonfigurasikan untuk menggunakan enkripsi.',
	'securepoll-dump-not-finished' => 'Catatan pemilihan ter-enkripsi hanya tersedia setelah selesainya pemungutan suara pada $2, $1.',
	'securepoll-dump-no-urandom' => 'Tidak dapat membuka /dev/urandom.
Untuk memastikan kerahasiaan pemberi suara, catatan pemilihan ter-enkripsi hanya akan tersedia secara publik jika menggunakan sebuah rangkaian nomor keamanan acak.',
	'securepoll-urandom-not-supported' => 'Peladen ini tidak mendukung kriptografi pembuatan angka acak.
Untuk menjaga kerahasiaan pemilih, catatan pemilihan ter-enkripsi hanya tersedia secara publik jika catatan tersebut dapat diacak dengan angka acak yang aman.',
	'securepoll-translate-title' => 'Terjemahkan: $1',
	'securepoll-invalid-language' => 'Kode bahasa tidak sah "$1"',
	'securepoll-submit-translate' => 'Perbarui',
	'securepoll-language-label' => 'Pilih bahasa:',
	'securepoll-submit-select-lang' => 'Terjemahkan',
	'securepoll-entry-text' => 'Berikut adalah daftar pemungutan suara',
	'securepoll-header-title' => 'Nama',
	'securepoll-header-start-date' => 'Tanggal mulai',
	'securepoll-header-end-date' => 'Tanggal selesai',
	'securepoll-subpage-vote' => 'Voting',
	'securepoll-subpage-translate' => 'Terjemahkan',
	'securepoll-subpage-list' => 'Daftar',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Penghitungan suara',
	'securepoll-tally-title' => 'Penghitungan suara: $1',
	'securepoll-tally-not-finished' => 'Maaf, Anda tidak dapat menghitung suara sampai pemungutan selesai.',
	'securepoll-can-decrypt' => 'Catatan pemilihan telah di-enkripsi, tapi kunci dekripsi tersedia.
Anda dapat memilih antara menghitung dari hasil suara yang terdapat di basis data, atau untuk menghitung hasil yang ter-enkripsi dari berkas yang dimuatkan.',
	'securepoll-tally-no-key' => 'Anda tidak dapat melakukan penghitungan suara, karena suara-suaranya ter-enkripsi dan kunci dekripsinya tidak tersedia.',
	'securepoll-tally-local-legend' => 'Menghitung hasil yang tersimpan',
	'securepoll-tally-local-submit' => 'Lakukan penghitungan',
	'securepoll-tally-upload-legend' => 'Muat dump ter-enkripsi',
	'securepoll-tally-upload-submit' => 'Melakukan penghitungan',
	'securepoll-tally-error' => 'Terjadi kesalahan dalam meng-interpretasikan catatan pemungutan suara, tidak dapat melakukan penghitungan.',
	'securepoll-no-upload' => 'Tidak ada berkas yang dimuatkan, tidak dapat melakukan penghitungan hasil.',
	'securepoll-dump-corrupt' => 'Berkas dump terkorupsi dan tidak dapat diproses.',
	'securepoll-tally-upload-error' => 'Kesalahan pada saat menjumlah berkas dump: $1',
	'securepoll-pairwise-victories' => 'Matriks kemenangan berpasangan',
	'securepoll-strength-matrix' => 'Matriks kekuatan jalan',
	'securepoll-ranks' => 'Peringkat akhir',
	'securepoll-average-score' => 'Nilai rerata',
);

/** Ido (Ido)
 * @author Malafaya
 * @author Wyvernoid
 */
$messages['io'] = array(
	'securepoll' => 'SekuraVoto',
	'securepoll-desc' => 'Extensilo por elekti e voti',
	'securepoll-header-voter-name' => 'Nomo',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-subpage-list' => 'Listo',
);

/** Icelandic (Íslenska)
 * @author Spacebirdy
 */
$messages['is'] = array(
	'securepoll-header-voter-name' => 'Nafn',
	'securepoll-header-voter-domain' => 'Lén',
	'securepoll-header-ua' => 'Aðgangsbúnaður',
	'securepoll-header-url' => 'Veffang',
	'securepoll-language-label' => 'Velja tungumál:',
	'securepoll-submit-select-lang' => 'Þýða',
	'securepoll-header-title' => 'Nafn',
	'securepoll-subpage-translate' => 'Þýða',
);

/** Italian (Italiano)
 * @author Aushulz
 * @author BrokenArrow
 * @author Capmo
 * @author Darth Kule
 * @author Massimiliano Lincetto
 * @author Melos
 * @author Nemo bis
 * @author Pietrodn
 * @author Stefano-c
 */
$messages['it'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Estensione per le elezioni e le indagini',
	'securepoll-invalid-page' => 'Sottopagina non valida "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => "Devi essere un amministratore dell'elezione per compiere questa azione.",
	'securepoll-too-few-params' => 'Parametri della sottopagina non sufficienti (collegamento non valido).',
	'securepoll-invalid-election' => '"$1" non è un ID valido per l\'elezione.',
	'securepoll-welcome' => '<strong>Benvenuto $1!</strong>',
	'securepoll-not-started' => "L'elezione non è ancora iniziata.
L'inizio è programmato per il giorno $2 alle $3.",
	'securepoll-finished' => 'Questa elezione è terminata, non è più possibile votare.',
	'securepoll-not-qualified' => 'Non sei qualificato per votare in questa elezione: $1',
	'securepoll-change-disallowed' => 'Hai già votato in questa elezione.
Non è possibile votare nuovamente.',
	'securepoll-change-allowed' => '<strong>Nota: hai già votato in questa elezione.</strong>
È possibile modificare il voto compilando il modulo seguente.
Si noti che così facendo il voto originale verrà scartato.',
	'securepoll-submit' => 'Invia il voto',
	'securepoll-gpg-receipt' => 'Grazie per aver votato.

È possibile mantenere la seguente ricevuta come prova della votazione:

<pre>$1</pre>',
	'securepoll-thanks' => 'Grazie, il tuo voto è stato registrato.',
	'securepoll-return' => 'Torna a $1',
	'securepoll-encrypt-error' => 'Impossibile cifrare le informazioni di voto.
Il voto non è stato registrato.

$1',
	'securepoll-no-gpg-home' => 'Impossibile creare la directory principale di GPG.',
	'securepoll-secret-gpg-error' => 'Errore durante l\'esecuzione di GPG.
Usare $wgSecurePollShowErrorDetail=true; in LocalSettings.php per mostrare maggiori dettagli.',
	'securepoll-full-gpg-error' => "Errore durante l'esecuzione di GPG:

Comando: $1

Errore:
<pre> $2 </pre>",
	'securepoll-gpg-config-error' => 'Le chiavi GPG non sono configurate correttamente.',
	'securepoll-gpg-parse-error' => "Errore nell'interpretazione dell'output di GPG.",
	'securepoll-no-decryption-key' => 'Nessuna chiave di decrittazione è configurata.
Impossibile decifrare.',
	'securepoll-jump' => 'Vai al server della votazione',
	'securepoll-bad-ballot-submission' => 'Il tuo voto non era valido: $1',
	'securepoll-unanswered-questions' => 'È necessario rispondere a tutte le domande.',
	'securepoll-invalid-rank' => 'Voto non valido. Devi dare ai candidati un voto compreso tra 1 e 999.',
	'securepoll-unranked-options' => 'Alcune voci sono prive di voto.
Devi assegnare a ciascuna voce un voto compreso tra 1 e 999.',
	'securepoll-unanswered-options' => 'Devi rispondere a tutte le domande.',
	'securepoll-remote-auth-error' => 'Errore durante il recupero delle informazioni sul tuo account dal server.',
	'securepoll-remote-parse-error' => "Errore nell'interpretare la risposta di autorizzazione dal server.",
	'securepoll-api-invalid-params' => 'Parametri non validi.',
	'securepoll-api-no-user' => "Non è stato trovato alcun utente con l'ID fornito.",
	'securepoll-api-token-mismatch' => 'I token di sicurezza non coincidono, non puoi entrare.',
	'securepoll-not-logged-in' => "È necessario eseguire l'accesso per votare il questa elezione",
	'securepoll-too-few-edits' => 'Spiacente, non puoi votare. Devi aver effettuato almeno $1 {{PLURAL:$1|modifica|modifiche}} per votare in questa elezione, tu ne hai fatte $2.',
	'securepoll-blocked' => 'Spiacente, non puoi votare in questa elezione se sei stato bloccato dalla modifica.',
	'securepoll-bot' => 'Spiacente, gli account con lo status di bot non sono ammessi a votare in questa elezione.',
	'securepoll-not-in-group' => 'Solo i membri del gruppo "$1" possono votare in questa elezione.',
	'securepoll-not-in-list' => 'Spiacente, non sei nella lista predeterminata degli utenti autorizzati a votare in questa elezione.',
	'securepoll-list-title' => 'Elenco voti: $1',
	'securepoll-header-timestamp' => 'Data e ora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Agente utente',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Annulla',
	'securepoll-header-details' => 'Dettagli',
	'securepoll-strike-button' => 'Annulla questo voto',
	'securepoll-unstrike-button' => 'Elimina annullamento',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Annulla',
	'securepoll-strike-error' => "Errore durante l'annullamento o ripristino del voto: $1",
	'securepoll-strike-token-mismatch' => 'I dati della sessione sono andati perduti.',
	'securepoll-details-link' => 'Dettagli',
	'securepoll-details-title' => 'Dettagli del voto: #$1',
	'securepoll-invalid-vote' => '"$1" non è l\'ID di un voto valido',
	'securepoll-header-voter-type' => 'Tipo di utente',
	'securepoll-voter-properties' => 'Proprietà del votante',
	'securepoll-strike-log' => 'Registro degli annullamenti',
	'securepoll-header-action' => 'Azione',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Amministratore',
	'securepoll-cookie-dup-list' => 'Utenti doppi per cookie',
	'securepoll-dump-title' => 'File di dump: $1',
	'securepoll-dump-no-crypt' => "Per questa elezione non è disponibile nessuna registrazione criptata, perché l'elezione non è impostata per usare la crittazione.",
	'securepoll-dump-not-finished' => "Le registrazioni criptate dell'elezione sono disponibili solo dopo la data di conclusione: $1 alle $2",
	'securepoll-dump-no-urandom' => "Impossibile aprire /dev/urandom. 
Per proteggere la riservatezza dei votanti, le registrazioni criptate dell'elezione sono disponibili pubblicamente solo quando potranno essere mescolate con un flusso sicuro di numeri casuali.",
	'securepoll-urandom-not-supported' => 'Questo server non supporta la generazione di numeri casuali per la crittografia.
Al fine di garantire la privacy dei votanti, la procedura di votazione cifrata è pubblicamente utilizzabile quando è disponibile un generatore di numeri casuali per la crittografia del flusso di dati.',
	'securepoll-translate-title' => 'Traduci: $1',
	'securepoll-invalid-language' => 'Codice lingua non valido: "$1"',
	'securepoll-submit-translate' => 'Aggiorna',
	'securepoll-language-label' => 'Scegli lingua:',
	'securepoll-submit-select-lang' => 'Traduci',
	'securepoll-entry-text' => 'Di seguito si trova la lista dei sondaggi.',
	'securepoll-header-title' => 'Nome',
	'securepoll-header-start-date' => 'Data di inizio',
	'securepoll-header-end-date' => 'Data di fine',
	'securepoll-subpage-vote' => 'Vota',
	'securepoll-subpage-translate' => 'Traduci',
	'securepoll-subpage-list' => 'Elenca',
	'securepoll-subpage-dump' => 'File di dump',
	'securepoll-subpage-tally' => 'Conteggio',
	'securepoll-tally-title' => 'Conteggio: $1',
	'securepoll-tally-not-finished' => 'Non puoi effettuare il conteggio dei voti prima che la votazione sia terminata.',
	'securepoll-can-decrypt' => "Le informazioni relative all'elezione sono state cifrate, ma è disponibile la chiave di decifratura.
Puoi scegliere di effettuare il conteggio dei risultati presenti nel database o di effettuare il conteggio dei risultati cifrati contenuti in un file caricato.",
	'securepoll-tally-no-key' => 'Non puoi effettuare il conteggio dei risultati di questa elezione poiché i voti sono cifrati e la chiave di decifrazione non è disponibile.',
	'securepoll-tally-local-legend' => 'Effettua il conteggio dei risultati memorizzati.',
	'securepoll-tally-local-submit' => 'Crea conteggio',
	'securepoll-tally-upload-legend' => 'Carica un file di dump cifrato',
	'securepoll-tally-upload-submit' => 'Crea conteggio',
	'securepoll-tally-error' => "Errore nell'elaborazione delle informazioni del voto, non è possibile effettuare il conteggio.",
	'securepoll-no-upload' => 'Nessun file è stato caricato, non è possibile effettuare il conteggio.',
	'securepoll-dump-corrupt' => 'Il file di dump è corrotto e non può essere elaborato.',
	'securepoll-tally-upload-error' => "Errore nell'effettuare il conteggio sul file di dump: $1",
	'securepoll-pairwise-victories' => 'Matrice di vittoria a due a due',
	'securepoll-strength-matrix' => 'Matrice di fortezza del percorso',
	'securepoll-ranks' => 'Classifica finale',
	'securepoll-average-score' => 'Media dei punteggi',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author 青子守歌
 */
$messages['ja'] = array(
	'securepoll' => '暗号投票',
	'securepoll-desc' => '選挙と意識調査のための拡張機能',
	'securepoll-invalid-page' => '「<nowiki>$1</nowiki>」は無効なサブページです',
	'securepoll-need-admin' => 'この操作を行うにはあなたが選挙管理者である必要があります。',
	'securepoll-too-few-params' => 'サブページ引数が足りません(リンクが無効です)。',
	'securepoll-invalid-election' => '「$1」は有効な選挙IDではありません。',
	'securepoll-welcome' => '<strong>$1さん、ようこそ！</strong>',
	'securepoll-not-started' => 'この選挙はまだ始まっていません。$2 $3 に開始する予定です。',
	'securepoll-finished' => 'この選挙は終了しました。もう投票することはできません。',
	'securepoll-not-qualified' => 'あなたはこの選挙に投票する資格がありません: $1',
	'securepoll-change-disallowed' => 'あなたはこの選挙で既に投票しています。申し訳ありませんが、二度の投票はできません。',
	'securepoll-change-allowed' => '<strong>注: あなたはこの選挙で既に投票しています。</strong>下のフォームから投稿することで票を変更できます。これを行う場合、以前の票は破棄されることに留意してください。',
	'securepoll-submit' => '投票',
	'securepoll-gpg-receipt' => '投票ありがとうございます。

必要ならば、以下の受理証をあなたの投票の証しとしてとっておくことができます。

<pre>$1</pre>',
	'securepoll-thanks' => 'ありがとうございます。あなたの投票は記録されました。',
	'securepoll-return' => '$1 に戻る',
	'securepoll-encrypt-error' => 'あなたの投票記録の暗号化に失敗しました。あなたの投票は記録されませんでした。

$1',
	'securepoll-no-gpg-home' => 'GPG ホームディレクトリが作成できません。',
	'securepoll-secret-gpg-error' => 'GPG の実行に失敗しました。より詳しい情報を表示するには、LocalSettings.php で $wgSecurePollShowErrorDetail=true; としてください。',
	'securepoll-full-gpg-error' => 'GPG の実行に失敗しました:

コマンド: $1

エラー:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG 鍵の設定が誤っています。',
	'securepoll-gpg-parse-error' => 'GPG 出力の解釈に失敗しました。',
	'securepoll-no-decryption-key' => '復号鍵が設定されておらず、復号できません。',
	'securepoll-jump' => '投票サーバへ移動',
	'securepoll-bad-ballot-submission' => 'あなたの投票は無効でした: $1',
	'securepoll-unanswered-questions' => 'すべての質問に答えなくてはなりません。',
	'securepoll-invalid-rank' => '順位が無効です。各候補に対しては1から999の間で順位を付けなければなりません。',
	'securepoll-unranked-options' => '順位が付けられていない選択肢があります。すべての選択肢に1から999の間で順位を付けなければなりません。',
	'securepoll-invalid-score' => '点数は$1と$2の間の数値でなければなりません。',
	'securepoll-unanswered-options' => 'すべての質問に回答しなければなりません。',
	'securepoll-remote-auth-error' => 'エラー：サーバからあなたのアカウント情報を取得できませんでした',
	'securepoll-remote-parse-error' => 'サーバーからの認証応答の解釈に失敗しました。',
	'securepoll-api-invalid-params' => 'パラメータが不正です。',
	'securepoll-api-no-user' => '指定されたIDをもつ利用者が見つかりません。',
	'securepoll-api-token-mismatch' => 'セキュリティ・トークンが一致しないのでログインできません。',
	'securepoll-not-logged-in' => 'この投票に参加するためにはログインしていなければいけません',
	'securepoll-too-few-edits' => '申し訳ありませんが、あなたは投票できません。この投票に参加するためには少なくとも$1{{PLURAL:$1|回}}の編集を行なっていなければなりません。現在の編集回数は$2です。',
	'securepoll-blocked' => '申し訳ありませんが、あなたは投稿ブロックを受けているためこの投票に参加できません。',
	'securepoll-bot' => '申し訳ありませんが、ボットフラグのあるアカウントはこの選挙で投票することが許可されていません。',
	'securepoll-not-in-group' => '$1グループに属する利用者のみがこの投票に参加できます。',
	'securepoll-not-in-list' => '申し訳ありませんが、あなたはあらかじめ決められた投票メンバーではないのでこの投票に参加できません。',
	'securepoll-list-title' => '票を一覧する: $1',
	'securepoll-header-timestamp' => '時刻',
	'securepoll-header-voter-name' => '名前',
	'securepoll-header-voter-domain' => 'ドメイン',
	'securepoll-header-ua' => 'ユーザーエージェント',
	'securepoll-header-cookie-dup' => '重複',
	'securepoll-header-strike' => '抹消',
	'securepoll-header-details' => '詳細',
	'securepoll-strike-button' => '抹消',
	'securepoll-unstrike-button' => '抹消撤回',
	'securepoll-strike-reason' => '理由:',
	'securepoll-strike-cancel' => '中止',
	'securepoll-strike-error' => '抹消あるいは抹消撤回の実行に失敗: $1',
	'securepoll-strike-token-mismatch' => 'セッション情報消失',
	'securepoll-details-link' => '詳細',
	'securepoll-details-title' => '票の詳細: #$1',
	'securepoll-invalid-vote' => '"$1"は有効な票IDではありません',
	'securepoll-header-voter-type' => '投票者の種類',
	'securepoll-voter-properties' => '投票者情報',
	'securepoll-strike-log' => '抹消記録',
	'securepoll-header-action' => '操作',
	'securepoll-header-reason' => '理由',
	'securepoll-header-admin' => '管理者',
	'securepoll-cookie-dup-list' => 'cookie が重複している利用者',
	'securepoll-dump-title' => 'ダンプ: $1',
	'securepoll-dump-no-crypt' => 'この選挙は暗号化を利用するように設定されていないため、暗号化された選挙記録は入手できません。',
	'securepoll-dump-not-finished' => '暗号化された選挙記録は終了日の$1 $2以降にのみ入手できます',
	'securepoll-dump-no-urandom' => '/dev/urandom を開けません。投票者のプライバシーを守るため、暗号化された選挙記録は暗号用乱数ストリームでシャッフルできる場合のみ公に入手できます。',
	'securepoll-urandom-not-supported' => 'このサーバーは暗号学的乱数生成に対応していません。投票者のプライバシーを守るため、暗号化された選挙記録は暗号用乱数ストリームでシャッフルできる場合のみ公に入手できます。',
	'securepoll-translate-title' => '翻訳: $1',
	'securepoll-invalid-language' => '「$1」は無効な言語コードです',
	'securepoll-submit-translate' => '更新',
	'securepoll-language-label' => '言語を選択:',
	'securepoll-submit-select-lang' => '翻訳',
	'securepoll-entry-text' => '以下は投票の一覧です。',
	'securepoll-header-title' => '名前',
	'securepoll-header-start-date' => '開始日時',
	'securepoll-header-end-date' => '終了日時',
	'securepoll-subpage-vote' => '投票',
	'securepoll-subpage-translate' => '翻訳',
	'securepoll-subpage-list' => '一覧',
	'securepoll-subpage-dump' => 'ダンプ',
	'securepoll-subpage-tally' => '集計',
	'securepoll-tally-title' => '集計: $1',
	'securepoll-tally-not-finished' => '申し訳ありませんが、投票が終了するまで票の集計はできません。',
	'securepoll-can-decrypt' => '選挙記録の暗号化が完了し、復号鍵を入手できます。データベース中の結果か、あるいは、アップロードされたファイルから取り出した暗号化済みの結果のどちらを集計するか選ぶことができます。',
	'securepoll-tally-no-key' => 'この投票は暗号化されており、復号鍵が取得できないため、あなたは票の集計を行うことができません。',
	'securepoll-tally-local-legend' => '保存されている記録の集計',
	'securepoll-tally-local-submit' => '集計開始',
	'securepoll-tally-upload-legend' => '暗号化された記録のアップロード',
	'securepoll-tally-upload-submit' => '集計開始',
	'securepoll-tally-error' => '投票記録の解析に失敗し、集計結果を出力できません。',
	'securepoll-no-upload' => 'ファイルがアップロードされておらず、結果を集計できません。',
	'securepoll-dump-corrupt' => 'ダンプファイルが破損しており、処理できません。',
	'securepoll-tally-upload-error' => 'ダンプファイルの集計中にエラー: $1',
	'securepoll-pairwise-victories' => '対勝利行列',
	'securepoll-strength-matrix' => 'パス強度行列',
	'securepoll-ranks' => '最終順位',
	'securepoll-average-score' => '平均点',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Èkstènsi tumrap pamilihan lan survé',
	'securepoll-invalid-page' => 'Anak kaca ora sah "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Pratingkah iki mung bisa diayahi déning pangurus.',
	'securepoll-too-few-params' => 'Parameter anak kaca ora pepak (pranala ora sah).',
	'securepoll-invalid-election' => 'ID pamilihan ora sah: "$1"',
	'securepoll-welcome' => '<strong>Sugeng rawuh $1!</strong>',
	'securepoll-not-started' => 'Pamilihan iki durung diwiwiti.
Pamilihan bakal diwiwiti ing tanggal $2, jam $3.',
	'securepoll-finished' => 'Pamilihan iki wis rampung, panjenengan ora bisa milih manèh.',
	'securepoll-not-qualified' => 'Panjenengan durung ngebaki sarat kanggo milih ing pamilihan iki: $1',
	'securepoll-change-disallowed' => 'Panjenengan wis milih sadurungé jroning pamilihan iki.
Nyuwun ngapura, panjenengan ora bisa milih manèh.',
	'securepoll-change-allowed' => '<strong>Cathetan: Panjenengan wis milih sadurungé ing pamilihan iki.</strong>
Panjenengan bisa ngowahi pilihan migunakaké formulir ing ngisor.
Kanthi mangkono, pilihan asli panjenengan bakal dibusak.',
	'securepoll-submit' => 'Kirim swara',
	'securepoll-gpg-receipt' => 'Matur nuwun wis mèlu milih.

Yèn perlu panjenengan bisa nyimpen resi pangiriman ing ngisor iki minangka bukti pamilihan:

<pre>$1</pre>',
	'securepoll-thanks' => 'Matur nuwun, swara panjenengan wis dicathet.',
	'securepoll-return' => 'Bali menyang $1',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author David1010
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'securepoll' => 'უსაფრთხო კეჭისყრა',
	'securepoll-too-few-params' => 'არ არის საკმარისი ქვეკატეგორიების პარამეტრები (არასწორი ბმული).',
	'securepoll-invalid-election' => '"$1" არ წარმოადგენს არჩევნებისათვის დასაშვებ იდენტიფიკატორს.',
	'securepoll-welcome' => '<strong>კეთილი იყოს თქვენი მობრძანება $1!</strong>',
	'securepoll-not-qualified' => 'თქვენ არ შეგიძლიათ ამ არჩევნებში ხმის მიცემა: $1',
	'securepoll-submit' => 'ხმის მიცემა',
	'securepoll-thanks' => 'გმადლობთ, თქვენი ხმა მიღებულია.',
	'securepoll-return' => 'დაბრუნება $1–ზე',
	'securepoll-full-gpg-error' => 'შეცდომა GPG შესრულებისას:

ბრძანება: $1

შეცდომა:
<pre>$2</pre>',
	'securepoll-jump' => 'ხმის მიცემის სერვერზე გადასვლა',
	'securepoll-bad-ballot-submission' => 'თქვენი ხმა ძალადაკარგულია: $1',
	'securepoll-unanswered-questions' => 'თქვენ უნდა უპასუხოთ ყველა შეკითხვას.',
	'securepoll-unanswered-options' => 'თქვენ უნდა გასცეთ პასუხი ყოველ კითხვაზე.',
	'securepoll-remote-auth-error' => 'შეცდომა ანგარიშზე ინფორმაციის მიღებისას სერვერიდან.',
	'securepoll-api-invalid-params' => 'არასწორი პარამეტრები.',
	'securepoll-api-no-user' => 'მომხმარებელი მითითებული იდენტიფიკატორით ვერ მოიძებნა.',
	'securepoll-not-logged-in' => 'ხმის მისაცემად თქვენ უნდა შეხვიდეთ სისტემაში',
	'securepoll-list-title' => 'ხმების სია: $1',
	'securepoll-header-timestamp' => 'დრო',
	'securepoll-header-voter-name' => 'სახელი',
	'securepoll-header-voter-domain' => 'დომენი',
	'securepoll-header-ua' => 'მომხმარებლის აგენტი',
	'securepoll-header-details' => 'დეტალები',
	'securepoll-strike-reason' => 'მიზეზი:',
	'securepoll-strike-cancel' => 'გაუქმება',
	'securepoll-strike-token-mismatch' => 'სესიის მონაცემების დაკარგვა',
	'securepoll-details-link' => 'დეტალები',
	'securepoll-details-title' => 'ხმის მიცემის დეტალები: #$1',
	'securepoll-invalid-vote' => '"$1" არ წარმოადგენს ხმის მიცემისთვის დასაშვებ იდენტიფიკატორს',
	'securepoll-header-voter-type' => 'ხმის მიმცემის ტიპი',
	'securepoll-header-url' => 'URL',
	'securepoll-header-action' => 'მოქმედება',
	'securepoll-header-reason' => 'მიზეზი',
	'securepoll-header-admin' => 'ადმინი',
	'securepoll-translate-title' => 'თარგმნა: $1',
	'securepoll-submit-translate' => 'განახლება',
	'securepoll-language-label' => 'ენის არჩევა:',
	'securepoll-submit-select-lang' => 'თარგმნა',
	'securepoll-header-title' => 'სახელი',
	'securepoll-header-start-date' => 'დაწყების თარიღი',
	'securepoll-header-end-date' => 'დასრულების თარიღი',
	'securepoll-subpage-vote' => 'ხმის მიცემა',
	'securepoll-subpage-translate' => 'თარგმნა',
	'securepoll-subpage-list' => 'სია',
	'securepoll-subpage-tally' => 'დათვლა',
	'securepoll-tally-title' => 'დათვლა: $1',
	'securepoll-tally-local-submit' => 'დათვლის წარმოება',
	'securepoll-tally-upload-submit' => 'დათვლის წარმოება',
);

/** Khmer (ភាសាខ្មែរ)
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'securepoll' => 'បោះ​ឆ្នោត​សុវត្ថិភាព​ (SecurePoll)',
	'securepoll-need-admin' => 'អ្នក​ចាំបាច់ត្រូវមានមុខងារ​ជា​អ្នកអភិបាល​ដើម្បី​អនុវត្ត​សកម្មភាពនេះ​។',
	'securepoll-invalid-election' => '"$1" មិនមែន​ជា​លេខ ID បោះឆ្នោត​​មានសុពលភាពទេ​។',
	'securepoll-welcome' => '<strong>សូមស្វាគមន៍ $1!</strong>',
	'securepoll-not-started' => 'ការ​បោះ​ឆ្នោត​នេះ​មិនទាន់​បាន​ចាប់​ផ្ដើម​ទេ​។
វា​នឹង​ចាប់​ផ្ដើម​នៅ $2 វេលា​ម៉ោង​ $3 ។',
	'securepoll-gpg-receipt' => 'សូម​អរគុណ​ចំពោះ​ការ​ចូលរួម​បោះ​ឆ្នោត​។
ប្រសិន​បើ​អ្នក​ចង់ទទួល​បាន​បង្កាន់​ដៃ​ខាង​ក្រោម​នេះ​ជា​ផស្តុតាង​នៃ​ឆ្នោត​របស់​អ្នក​៖
<pre>$1</pre>',
	'securepoll-thanks' => 'សូម​អរគុណ​ ឆ្នោត​របស់​អ្នក​ត្រូវ​បាន​កត់​ត្រា​ចូល​ហើយ​។',
	'securepoll-return' => 'ត្រឡប់ទៅ $1 វិញ',
	'securepoll-header-timestamp' => 'ពេលវេលា',
	'securepoll-header-voter-name' => 'ឈ្មោះ',
	'securepoll-header-details' => 'ព័ត៌មាន​លម្អិត​',
	'securepoll-strike-reason' => 'មូលហេតុ៖',
	'securepoll-strike-cancel' => 'បោះបង់',
	'securepoll-details-link' => 'ព័ត៌មាន​លម្អិត​',
	'securepoll-header-action' => 'សកម្មភាព',
	'securepoll-header-reason' => 'មូលហេតុ',
	'securepoll-translate-title' => 'បកប្រែ៖ $1',
	'securepoll-submit-translate' => 'បន្ទាន់សម័យ',
	'securepoll-language-label' => 'ជ្រើសរើស​ភាសា​៖',
	'securepoll-submit-select-lang' => 'បកប្រែ',
	'securepoll-header-title' => 'ឈ្មោះ',
	'securepoll-header-start-date' => 'កាលបរិច្ឆេទចាប់ផ្តើម',
	'securepoll-header-end-date' => 'កាលបរិច្ឆេទបញ្ចប់',
	'securepoll-subpage-vote' => 'បោះឆ្នោត',
	'securepoll-subpage-translate' => 'បកប្រែ',
	'securepoll-subpage-list' => 'បញ្ជី',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'securepoll-header-voter-name' => 'ಹೆಸರು',
	'securepoll-strike-reason' => 'ಕಾರಣ:',
	'securepoll-header-reason' => 'ಕಾರಣ',
	'securepoll-header-title' => 'ಹೆಸರು',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author Mhha
 * @author Yknok29
 */
$messages['ko'] = array(
	'securepoll' => '비밀 투표',
	'securepoll-desc' => '선거와 여론 조사를 위한 확장 기능',
	'securepoll-invalid-page' => '"<nowiki>$1</nowiki>" 하위 문서가 잘못되었습니다.',
	'securepoll-need-admin' => '해당 동작을 수행하려면 선거 관리자 권한이 필요합니다.',
	'securepoll-too-few-params' => '하위 문서 변수가 충분하지 않습니다 (잘못된 링크).',
	'securepoll-invalid-election' => '"$1"은 유효한 선거 ID가 아닙니다.',
	'securepoll-welcome' => '<strong>$1님, 환영합니다!</strong>',
	'securepoll-not-started' => '투표가 아직 시작되지 않았습니다.
투표는 $2 $3부터 시작될 예정입니다.',
	'securepoll-finished' => '이 선거가 이미 종료되었기 때문에, 당신은 더 이상 투표할 수 없습니다.',
	'securepoll-not-qualified' => '당신에게는 이번 선거에서 투표권이 부여되지 않았습니다: $1',
	'securepoll-change-disallowed' => '당신은 이미 투표하였습니다.
죄송하지만 다시 투표할 수 없습니다.',
	'securepoll-change-allowed' => '<strong>참고: 당신은 이전에 투표한 적이 있습니다.</strong>
당신은 아래 양식을 이용해 투표를 변경할 수 있습니다.
그렇게 할 경우 이전의 투표는 무효 처리될 것입니다.',
	'securepoll-submit' => '투표하기',
	'securepoll-gpg-receipt' => '투표해 주셔서 감사합니다.

당신이 원하신다면 당신의 투표에 대한 증거로 다음 투표증을 보관할 수 있습니다:

<pre>$1</pre>',
	'securepoll-thanks' => '감사합니다. 당신의 투표가 기록되었습니다.',
	'securepoll-return' => '$1로 돌아가기',
	'securepoll-encrypt-error' => '당신의 투표를 암호화하는 데 실패했습니다.
당신의 투표가 기록되지 않았습니다.

$1',
	'securepoll-no-gpg-home' => 'GPG 홈 디렉토리를 생성할 수 없습니다.',
	'securepoll-secret-gpg-error' => 'GPG를 실행하는 데 오류가 발생하였습니다.
자세한 정보를 보려면 LocalSettings.php에 $wgSecurePollShowErrorDetail=true; 를 사용하십시오.',
	'securepoll-full-gpg-error' => 'GPG를 실행하는 데 오류가 발생하였습니다.

명령: $1

오류:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG 키가 잘못 설정되었습니다.',
	'securepoll-gpg-parse-error' => 'GPG 출력을 해석하는 데 오류가 발생했습니다.',
	'securepoll-no-decryption-key' => '암호 해독 키가 설정되지 않았습니다.
암호를 해독할 수 없습니다.',
	'securepoll-jump' => '선거 서버로 이동하기',
	'securepoll-bad-ballot-submission' => '투표가 무효 처리 되었습니다: $1',
	'securepoll-unanswered-questions' => '모든 질문에 답을 입력해 주셔야 합니다.',
	'securepoll-invalid-rank' => '순위를 잘못 입력하였습니다. 당신은 후보자의 순위를 1부터 999까지 매겨야 합니다.',
	'securepoll-unranked-options' => '어떤 선택 사항에 대한 순위가 매겨지지 않았습니다.
당신은 모든 선택 사항에 대해 1부터 999까지 순위를 매겨야 합니다.',
	'securepoll-invalid-score' => '점수는 $1과 $2 사이의 숫자이어야 합니다.',
	'securepoll-unanswered-options' => '당신은 모든 질문에 응답해야 합니다.',
	'securepoll-remote-auth-error' => '귀하의 계정 정보를 불러오는 중에 오류가 발생하였습니다.',
	'securepoll-remote-parse-error' => '서버로부터 권한 응답에 따른 해석 오류가 발생',
	'securepoll-api-invalid-params' => '명령 변수가 잘못되었습니다.',
	'securepoll-api-no-user' => '등록되어 있지 않은 ID 입니다.',
	'securepoll-api-token-mismatch' => '암호화 통신상의 오류가 발생하여 로그인하지 못했습니다.',
	'securepoll-not-logged-in' => '이 선거에 투표를 하시려면 먼저 로그인하셔야 합니다.',
	'securepoll-too-few-edits' => '죄송하지만, 투표에 참여하실 수 없습니다. 투표에 참여하시려면 최소 $1{{PLURAL:$1|회}}의 편집기여를 하셔야 하지만 귀하의 편집 수는 $2회 입니다.',
	'securepoll-blocked' => '죄송하지만, 귀하의 계정은 차단당한 상태이므로 이 선거에 투표하실 수 없습니다.',
	'securepoll-bot' => '죄송합니다. 봇 권한을 가진 계정으로는 투표할 수 없습니다.',
	'securepoll-not-in-group' => '이 선거에는 "$1" 모임에 속하는 회원만 투표하실 수 있습니다.',
	'securepoll-not-in-list' => '죄송하지만, 귀하는 이 선거에 투표하실 수 있는 선거인단명부에 등록되어 있지 않습니다.',
	'securepoll-list-title' => '표 목록: $1',
	'securepoll-header-timestamp' => '시간',
	'securepoll-header-voter-name' => '이름',
	'securepoll-header-voter-domain' => '도메인',
	'securepoll-header-ua' => '유저 에이전트',
	'securepoll-header-cookie-dup' => '중복',
	'securepoll-header-strike' => '무효화',
	'securepoll-header-details' => '세부 사항',
	'securepoll-strike-button' => '무효화',
	'securepoll-unstrike-button' => '무효화 해제',
	'securepoll-strike-reason' => '이유:',
	'securepoll-strike-cancel' => '취소',
	'securepoll-strike-error' => '무효화/해제 과정에서 오류가 발생하였습니다: $1',
	'securepoll-strike-token-mismatch' => '세션 데이터가 손실되었습니다.',
	'securepoll-details-link' => '세부 사항',
	'securepoll-details-title' => '표 세부 사항: #$1',
	'securepoll-invalid-vote' => '‘$1’은 정상적인 ID가 아닙니다',
	'securepoll-header-voter-type' => '투표자 유형',
	'securepoll-voter-properties' => '투표자 정보',
	'securepoll-strike-log' => '무효화 기록',
	'securepoll-header-action' => '실행',
	'securepoll-header-reason' => '이유',
	'securepoll-header-admin' => '관리자',
	'securepoll-cookie-dup-list' => '쿠키가 중복된 사용자 목록',
	'securepoll-dump-title' => '덤프: $1',
	'securepoll-dump-no-crypt' => '선거가 암호화를 사용하지 않도록 설정되어 있어, 암호화된 항목을 얻을 수 없습니다.',
	'securepoll-dump-not-finished' => '암호화 선거 기록은 $1 $2 이후가 되어야만 볼 수 있습니다.',
	'securepoll-dump-no-urandom' => '/dev/urandom 파일을 열 수 없습니다.
투표자를 보호하기 위해, 암호화 선거 항목은 안전한 난수 생성기가 있을 때만 사용이 가능합니다.',
	'securepoll-urandom-not-supported' => '이 서버는 암호화 난수 생성을 지원하지 않습니다.
투표자의 개인 정보를 유지하기 위해, 선거 기록이 안전한 무작위 수열로 변환될 수 있을 경우에만 암호화된 선거 기록이 공개될 것입니다.',
	'securepoll-translate-title' => '번역: $1',
	'securepoll-invalid-language' => '‘$1’ 언어 코드가 잘못되었습니다.',
	'securepoll-submit-translate' => '갱신',
	'securepoll-language-label' => '언어 선택:',
	'securepoll-submit-select-lang' => '번역',
	'securepoll-entry-text' => '다음은 투표의 목록입니다.',
	'securepoll-header-title' => '이름',
	'securepoll-header-start-date' => '시작일',
	'securepoll-header-end-date' => '종료일',
	'securepoll-subpage-vote' => '투표',
	'securepoll-subpage-translate' => '번역',
	'securepoll-subpage-list' => '목록',
	'securepoll-subpage-dump' => '기록 내용',
	'securepoll-subpage-tally' => '개표',
	'securepoll-tally-title' => '개표: $1',
	'securepoll-tally-not-finished' => '죄송합니다. 투표가 끝나기 전까지는 개표할 수 없습니다.',
	'securepoll-can-decrypt' => '투표가 암호화되었지만, 복호화 키가 사용 가능합니다. 개표할 때 데이터베이스에 저장되어 있는 키를 사용할지 혹은 직접 키를 업로드할지 선택할 수 있습니다.',
	'securepoll-tally-no-key' => '투표가 암호화되었으나 복호화 키가 없기 때문에 개표할 수 없습니다.',
	'securepoll-tally-local-legend' => '저장된 결과 집계하기',
	'securepoll-tally-local-submit' => '집계 시작하기',
	'securepoll-tally-upload-legend' => '암호화된 기록 내용을 올리기',
	'securepoll-tally-upload-submit' => '개표하기',
	'securepoll-tally-error' => '투표 기록을 해석하는 중에 오류가 발생했습니다. 집계 결과를 만들 수 없습니다.',
	'securepoll-no-upload' => '파일이 올라가지 않아, 결과 집계를 할 수 없습니다.',
	'securepoll-dump-corrupt' => '기록 파일에 문제가 있어서 처리할 수 없습니다.',
	'securepoll-tally-upload-error' => '기록 파일을 개표하는 중 오류 발생: $1',
	'securepoll-pairwise-victories' => '조합비교 행렬',
	'securepoll-strength-matrix' => 'Path strength 행렬',
	'securepoll-ranks' => '최종 순위',
	'securepoll-average-score' => '평균 점수',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 */
$messages['krc'] = array(
	'securepoll-header-timestamp' => 'Заман',
	'securepoll-header-voter-name' => 'Ат',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-reason' => 'Чурум',
	'securepoll-header-admin' => 'Админ',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'securepoll' => 'Sescher Afshtemme',
	'securepoll-desc' => 'E Zohsatz-Projramm för Wahle, Meinunge, un Afstemmunge.',
	'securepoll-invalid-page' => '„<nowiki>$1</nowiki>“ es en onjöltijje Ongersigg',
	'securepoll-need-admin' => 'Do moß ene Betreuer för de Wahl sin, öm dat maache ze dörve.',
	'securepoll-too-few-params' => 'Dä Lengk es verkeht, et sin nit jenooch Parrameetere för Ongersigge do dren.',
	'securepoll-invalid-election' => '„$1“ es kein jöltije Kennung för en Afshtemmung',
	'securepoll-welcome' => '<strong>Hallo $1,</strong>',
	'securepoll-not-started' => 'Hee di Afshtemmung hät noch jaa nit aanjefange.
Et sull aam $2 aff $3 Uhr loß jonn.',
	'securepoll-finished' => 'Die Afshtemmung es eröm, hee kanns De nix mieh bei donn.',
	'securepoll-not-qualified' => 'Do brengks nit alles met, wat nüdesch es, öm bei hee dä Afshtemmung met_ze_maache: $1',
	'securepoll-change-disallowed' => 'Do häs ald afjeshtemmpt.
Noch ens Afshtemme es nit müjjelesch.',
	'securepoll-change-allowed' => '<strong>Opjepaß: Do häs zo däm Teema ald afjeshtemmp.</strong>
Ding Shtemm kanns De ändere. Donn doför tat Fommullaa hee drunge namme. Wann De dat määs, weet Ding vörher afjejovve Shtemm fott jeschmeße.',
	'securepoll-submit' => 'De Shtemm afjävve',
	'securepoll-gpg-receipt' => 'Häs Dangk för et Afshtemme.

Wann De wells donn Der dat hee als en Quittung för Ding Shtemm faßhaale:

<pre>$1</pre>',
	'securepoll-thanks' => 'Mer donn uns bedangke. Ding Shtemm es faßjehallde.',
	'securepoll-return' => 'Jangk retuur noh $1',
	'securepoll-encrypt-error' => 'Kunnt Ding Shtemm nit verschlößele.
Ding Shtemm es nit jezallt, un weed nit faßjehallde!

$1',
	'securepoll-no-gpg-home' => 'Kann dat Verzeichnis för GPG nit aanlääje.',
	'securepoll-secret-gpg-error' => 'Ene Fähler es opjetrodde bem Ußföhre vun GPG.
Donn <code>$wgSecurePollShowErrorDetail=true;</code>
en <code>LocalSettings.php</code>
endraare, öm mieh Einzelheite ze sinn ze krijje.',
	'securepoll-full-gpg-error' => 'Ene Fähler es opjetrodde bem Ußföhre vun GPG:

Kommando: $1

Fähler:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'De Schlössel för GPG sen verkeeht enjeshtallt.',
	'securepoll-gpg-parse-error' => 'Ene Fähler es opjetrodde bemm Beärbeide vun dämm, wat GPG ußjejovve hät.',
	'securepoll-no-decryption-key' => 'Mer han keine Schlößel för et Äntschlößele, un et es och keine enjeshtallt. Alsu künne mer nix Äntschlößele.',
	'securepoll-jump' => 'Jangk op dä Server för de Afshtemmung',
	'securepoll-bad-ballot-submission' => 'Ding Shtemm woh nit jöltesch: $1',
	'securepoll-unanswered-questions' => 'Do moß op alle Froore en Antwoot jävve.',
	'securepoll-invalid-rank' => 'Dat es ene verkeehte Rang. Do moß Dinge Kandidaate ene Rang zwesche 1 un 999 jävve.',
	'securepoll-unranked-options' => 'Ene Deil vun dä Müjjeleschkeite hät keine Rang.
Do moß alle Müjjeleschkeite ene Rang zwesche 1 un 999 jevve.',
	'securepoll-invalid-score' => 'Wad_eruß küt moß en Zahl zwesche $1 un $2 sin.',
	'securepoll-unanswered-options' => 'Do moss_en Antwoot oop jeede Frooch jävve.',
	'securepoll-remote-auth-error' => 'Ene Fähler es opjetrodde, wi mer däm Server öm Ding Daate jefrooch hann.',
	'securepoll-remote-parse-error' => 'Ene Fähler es opjetrodde. Mer kunnte met däm Server singem Zoshtemmungs_Kood nix aanfange.',
	'securepoll-api-invalid-params' => 'Verkeehte Parrameeterre.',
	'securepoll-api-no-user' => 'Mer han keine Metmaacher jefonge jehatt met dä aanjejovve Kännong.',
	'securepoll-api-token-mismatch' => 'Dä Sesherheitß_Kood deiht nit paße, do kanns De Desch nit ennlogge.',
	'securepoll-not-logged-in' => 'Do moß Desch ald enlogge, för bei dää Afshtemmung metzemaache!',
	'securepoll-too-few-edits' => 'Schadt: Do kanns diß Mol nit affshtemme. En dämm Fall mööts De ald {{PLURAL:$1|einmol|$1 Mol|övverhou noch nie}} en Sigg em Wiki jeändert han, Do häß ävver {{PLURAL:$2|blooß eimol|blooß $2 Mol|övverhoup noch nie}} en Sigg em Wiki jeändert.',
	'securepoll-blocked' => 'Schahdt: Do kanns diß Mol nit affshtemme, weil jraadt för et Ändere aam Wiki jeshperrt beß.',
	'securepoll-bot' => 'Hee en dä Afshtemmung kann bloß met metmaache, wä keine Bots es.',
	'securepoll-not-in-group' => 'Schadt: Do kanns diß Mol nit affshtemme. Bloß de Metmaacher en dä {{NS:Category}} $1 künne hee en Shtemm afjevve!',
	'securepoll-not-in-list' => 'Schadt: Do kanns diß Mol nit affshtemme. De beß nit en de su jenannte Wähler_Leß met de Metmaacher, die hee afshtemme dörve.',
	'securepoll-list-title' => 'Shtemme Opleßte: $1',
	'securepoll-header-timestamp' => 'Zick',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domähn',
	'securepoll-header-ip' => '<code lang="en">IP</code>-Addreß',
	'securepoll-header-ua' => 'Däm Metmaacher singe Brauser',
	'securepoll-header-cookie-dup' => 'Dubbelt Afjeshtemmp',
	'securepoll-header-strike' => 'Ußshtrieshe?',
	'securepoll-header-details' => 'Einzelheite',
	'securepoll-strike-button' => 'Ußshtriische',
	'securepoll-unstrike-button' => 'nit mieh jeschtresche',
	'securepoll-strike-reason' => 'Aaanlaß o Jrund:',
	'securepoll-strike-cancel' => 'Ophüre!',
	'securepoll-strike-error' => 'Ene Fähler is opjetrodde beim Ußshtriishe odder widder zerök holle: $1',
	'securepoll-strike-token-mismatch' => 'De Sezungsdaate sin fott',
	'securepoll-details-link' => 'Einzelheite',
	'securepoll-details-title' => 'Einzelheite vun dä Shtemm met dä Kennong: „$1“',
	'securepoll-invalid-vote' => '„$1“ kein reschtijje Kännong för en Afshtemmung',
	'securepoll-header-id' => 'Kennong',
	'securepoll-header-voter-type' => 'Zoot Affshtemmer',
	'securepoll-voter-properties' => 'Dem Metmaacher sing Eijeschaffte för et Afshtemme',
	'securepoll-strike-log' => 'Logboch övver de ußjeshtersche un widder jehollte Shtemme en Afshtemmunge',
	'securepoll-header-action' => 'Akßjuhn',
	'securepoll-header-reason' => 'Woröm?',
	'securepoll-header-admin' => '{{int:group-sysop-member}}',
	'securepoll-cookie-dup-list' => 'Dubbel Affjeschtemmp',
	'securepoll-dump-title' => 'Erus jeschmeße: $1',
	'securepoll-dump-no-crypt' => 'Mer han kei verschlößelte Daate för di Afshtemmung, di löüf nämmlesch der oohne, weil dat esu enjeshtallt es.',
	'securepoll-dump-not-finished' => 'Verschlößelte Opzeishnunge vun dä Afshtemmung sin eetz noh_m Engk aam $1 noh $2 Uhr ze han.',
	'securepoll-dump-no-urandom' => 'Mer künne <code>/dev/random</code> nit opmaache.
Öm dä Afshtemmer ze schötze, don mer verschlößelte Datesäz bloß dann ußjävve,
wann mer se met enem seschere, zohfällije Dateshtrom verwörfelle künne.',
	'securepoll-urandom-not-supported' => 'Hee dä ßööver kann kein Zohfallszahle för et Verschößele maache.
Öm et Wahljeheimnis ze bewaahre, sin de verschößelte Opzeichnunge vun der Stemme bloß dann öffentlich ze han, wann mer se en ene seshere zofällije Reijefollsh zeije künne.',
	'securepoll-translate-title' => 'Övveräze: $1',
	'securepoll-invalid-language' => '„<code>$1</code>“ es enne onjöltijje Shprooche_Kood',
	'securepoll-header-trans-id' => 'Kennong',
	'securepoll-submit-translate' => 'Neu maache!',
	'securepoll-language-label' => 'Shprooch ußwähle:',
	'securepoll-submit-select-lang' => 'Övversätze!',
	'securepoll-entry-text' => 'Heh dronger kütt en Leß met de Afschtemmunge.',
	'securepoll-header-title' => 'Name',
	'securepoll-header-start-date' => 'Aanfangsdattum',
	'securepoll-header-end-date' => 'Et Dattum vum Engk',
	'securepoll-subpage-vote' => 'Afshtemme',
	'securepoll-subpage-translate' => 'Övversezze',
	'securepoll-subpage-list' => 'Leß',
	'securepoll-subpage-dump' => 'Erus jeschmeße',
	'securepoll-subpage-tally' => 'Ußzälle',
	'securepoll-tally-title' => 'Ußzälle: $1',
	'securepoll-tally-not-finished' => 'Do kanns nit et Ußzälle aanfange, wann de Afshtemmung noch aam Loufe es.',
	'securepoll-can-decrypt' => 'De Opzeishnunge för di Afshtemmung sen verschlößeldt, ävver de Schlößel för et Äntschlößelle ham_mer.
Donn Desch entscheide doh zwesche, de neuste Zahle en de Datebangk uß_ze_zälle, udder de Shtemme en en huhjelaade, verschlößelte Datei uß_ze_zälle.',
	'securepoll-tally-no-key' => 'Do kanns de Shtemme vun dä Afshtemmung nit ußzälle. De Shtemme sen verschlößeldt, u dä Schlößel ham_mer nit.',
	'securepoll-tally-local-legend' => 'De jespeisherte Shtemme uß de Datebangk ußzälle',
	'securepoll-tally-local-submit' => 'Lohß Jonn!',
	'securepoll-tally-upload-legend' => 'Donn en verschlößelte Datei huhlaade',
	'securepoll-tally-upload-submit' => 'Lohß Jonn!',
	'securepoll-tally-error' => 'Beim Ungersöke vun ene Shtemm es jet donevve jejange, dröm künne mer nix ußzälle.',
	'securepoll-no-upload' => 'Nix huhjelaade, do künne mer kein Shtemme ußzälle.',
	'securepoll-dump-corrupt' => 'De <i lang="en">dump</i>-Dattei es kappoott un kann nit verärbeidt wääde.',
	'securepoll-tally-upload-error' => 'Ene Fähler es opjetrodde beim Ußzälle noh dä <i lang="en">dump</i>-Dattei: $1',
	'securepoll-pairwise-victories' => 'Krüztabäll mer de paawiiß Jewenner',
	'securepoll-strength-matrix' => 'De Krüztabäll mem Jeweesch fun jedem Pat',
	'securepoll-ranks' => 'De Rangfollesch zom Afschloß',
	'securepoll-average-score' => 'Dorschschnettlesche Treffer',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'securepoll' => 'Securiséiert Ëmfro',
	'securepoll-desc' => 'Erweiderung fir Walen an Ëmfroen',
	'securepoll-invalid-page' => 'Net-valabel Ënnersäit "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Dir musst Admnistrateur vun de Wale si fir dëst kënnen ze maachen.',
	'securepoll-too-few-params' => 'Net genuch Ënnersäite-Parameter (net valbele Link).',
	'securepoll-invalid-election' => '"$1" ass keng ID déi fir d\'Wale gëlteg ass.',
	'securepoll-welcome' => '<strong>Wëllkomm $1!</strong>',
	'securepoll-not-started' => 'Dës Walen hunn nach net ugefaang.
Si fänke viraussiichtlech den $2 ëm $3 un.',
	'securepoll-finished' => 'Dës Wale sinn eriwwer, Dir kënnt net méi ofstëmmen.',
	'securepoll-not-qualified' => 'Dir sidd net qualifizéiert fir bäi dëse Walen ofzestëmmen: $1',
	'securepoll-change-disallowed' => 'Dir hutt bäi dëse Walen virdru schonn ofgestëmmt.
Pardon, mee dir däerft net nach eng Kéier ofstëmmen.',
	'securepoll-change-allowed' => '<strong>Hiweis: Dir hutt bei dëse Wale schonn ofgestëmmt</strong>
Dir kënnt Är Stëmm änneren, andeems Dir de Formulaire heiënnendrënner fortschéckt.
Wann Dir dat maacht, gëtt Är vireg Stëmm iwwerschriwwen.',
	'securepoll-submit' => 'Stëmm ofginn',
	'securepoll-gpg-receipt' => 'Merci datt Dir Iech un de Wale bedeelegt huet.

Wann Dir wëllt, kënnt Dir dës Confirmatioun vun Ärem Vote behalen:

<pre>$1</pre>',
	'securepoll-thanks' => 'Merci, Är Stëmm gouf gespäichert.',
	'securepoll-return' => 'Zréck op $1',
	'securepoll-encrypt-error' => 'Bei der Verschlëselung vun Ärer Stëmm ass a Feeler geschitt.
Är Stëmm gouf net gespäichert!

$1',
	'securepoll-no-gpg-home' => 'De Basis-Repertoire GPG konnt net ugeluecht ginn.',
	'securepoll-secret-gpg-error' => 'Feeler beim Ausféiere vun GPG.
Benotzt $wgSecurePollShowErrorDetail=true; op LocalSettings.php fir méi Detailer ze gesinn.',
	'securepoll-full-gpg-error' => 'Feeler beim Ausféiere vun GPG:

Kommando: $1

Feeler:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => "D'GPG-Schlëssele sinn net korrekt konfiguréiert.",
	'securepoll-gpg-parse-error' => 'Feeler beim Interpretéieren vum GPG-Ouput',
	'securepoll-no-decryption-key' => 'Et ass keen Ëntschlësungsschlëssel agestallt.
Ëntschlësselung onméiglech.',
	'securepoll-jump' => 'Op den Ofstëmmungs-Server goen',
	'securepoll-bad-ballot-submission' => 'Är Stëmm ass net valabel: $1',
	'securepoll-unanswered-questions' => 'Dir musst all Froe beäntwerten',
	'securepoll-invalid-rank' => 'Ongëltegt Classement. Dir musst de Kandidaten e Classement tëschent 1 an 999 ginn.',
	'securepoll-unranked-options' => 'E puer Optioune krute kee Classement.
Dir musst allen optiounen e Classement tëschent 1 an 999 ginn.',
	'securepoll-invalid-score' => 'De Score muss eng Zuel tëschent $1 a(n) $2 sinn.',
	'securepoll-unanswered-options' => 'Dir musst op all Fro eng Äntwert ginn.',
	'securepoll-remote-auth-error' => 'Feeler beim Ofruf vun Äre Benotzerkontinformatioune vum Server.',
	'securepoll-remote-parse-error' => 'Feeler beim Interpretéiere vun der Autorisatioun déi de Server geschéckt huet.',
	'securepoll-api-invalid-params' => 'Parameter déi net valabel sinn.',
	'securepoll-api-no-user' => 'Et gouf kee Benotzer mat der ID fonnt déi ugi war.',
	'securepoll-api-token-mismatch' => 'Falsche Sécerheeets-Token, Aloggen ass net méiglech.',
	'securepoll-not-logged-in' => 'Dir musst Iech alogge fir bäi dëse Walen ofstëmmen ze kënnen',
	'securepoll-too-few-edits' => 'Pardon, Dir däerft net ofstëmmen. Dir musst mindestens $1 {{PLURAL:$1|Ännerung|Ännerunge}} gemaacht hunn, fir bäi dëse Walen ofstëmmen ze kënnen, Dir hutt der $2 gemaach.',
	'securepoll-blocked' => 'Pardon, Dir kënnt net bäi dëse Walen ofstëmmen wann dir elo fir Ännerunge gespaart sidd.',
	'securepoll-bot' => 'Pardon, Benotzerkonte matt engem Bottefändel (bot flag) däerfe bäi dëse Walen net ofstëmmen.',
	'securepoll-not-in-group' => 'Nëmme Membere vum Grupp $1 kënne bäi dëse Walen ofstëmmen.',
	'securepoll-not-in-list' => 'Pardon, awer Dir stitt op der Lëscht vun de Benotzer déi autoriséiert si fir bäi dëse Walen ofzestëmmen.',
	'securepoll-list-title' => 'Lëscht vun de Stëmmen: $1',
	'securepoll-header-timestamp' => 'Zäit',
	'securepoll-header-voter-name' => 'Numm',
	'securepoll-header-voter-domain' => 'Domaine',
	'securepoll-header-ua' => 'Benotzeragent',
	'securepoll-header-cookie-dup' => 'Duplikat',
	'securepoll-header-strike' => 'Duerchsträichen',
	'securepoll-header-details' => 'Detailer',
	'securepoll-strike-button' => 'Duerchsträichen',
	'securepoll-unstrike-button' => 'Duerchsträichen ewechhuelen',
	'securepoll-strike-reason' => 'Grond:',
	'securepoll-strike-cancel' => 'Ofbriechen',
	'securepoll-strike-error' => 'Feeler beim Sträiche respektiv Ophiewe vum Sträichen: $1',
	'securepoll-strike-token-mismatch' => 'Verloscht vun den Donnéeë vun der Verbindung',
	'securepoll-details-link' => 'Detailer',
	'securepoll-details-title' => 'Detailer vun der Ofstëmmung: #$1',
	'securepoll-invalid-vote' => '"$1" ass keng valabel Ofstëmmngs-ID',
	'securepoll-header-voter-type' => 'Typ vu Wieler',
	'securepoll-voter-properties' => 'Eegeschafte vum Wieler',
	'securepoll-strike-log' => 'Logbuch vun de Sträichungen',
	'securepoll-header-action' => 'Aktioun',
	'securepoll-header-reason' => 'Grond',
	'securepoll-header-admin' => 'Administrateur',
	'securepoll-cookie-dup-list' => 'Benotzer matt engem Cookie deen duebel ass',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => "Fir dës Wale gëtt et keng verschlësselt Donnéeë vun der Ofstëmmung, well d'Walen net esou agestallt sinn fir d'Verschlësselung ze benotzen.",
	'securepoll-dump-not-finished' => 'Verschlësselt Donnéeë vun de Wale sinn eréischt nom Enn vun de Walen den $1 ëm $2 disponibel',
	'securepoll-dump-no-urandom' => "/dev/urandom kann net opgemaach ginn.
Fir d'Konfidentialitéit vun de Wieler z'assuréieren, si verschlësselt Opzeechnunge vun de Walen nëmmen disponibel wa se mat engem sécheren Zoufallszuelestroum kënne gemescht ginn.",
	'securepoll-urandom-not-supported' => 'Dëse Server ënnerstëtzt keng krypotgrfesch Zoufallszuelen.
Fir Är privat Donnéeën ze schützen si verschlësselt Opzeechnunge vun de Walen nëmmen ëfentlech disponibel wa si mat enger Rei vu  sécheren Zoufallszuele geméccht kënne ginn.',
	'securepoll-translate-title' => 'Iwwersetzen: $1',
	'securepoll-invalid-language' => 'Net valabele Sproochecode "$1"',
	'securepoll-submit-translate' => 'Aktualiséieren',
	'securepoll-language-label' => 'Sprooch eraussichen:',
	'securepoll-submit-select-lang' => 'Iwwersetzen',
	'securepoll-entry-text' => "Ënnedrèenner ass d'L!escht vun den Ëmfroen.",
	'securepoll-header-title' => 'Numm',
	'securepoll-header-start-date' => 'Ufanksdatum',
	'securepoll-header-end-date' => 'Schlussdatum',
	'securepoll-subpage-vote' => 'Stëmm',
	'securepoll-subpage-translate' => 'Iwwersetzen',
	'securepoll-subpage-list' => 'Lëscht',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Auszielung',
	'securepoll-tally-title' => 'Auszielung: $1',
	'securepoll-tally-not-finished' => "Pardon, Dir kënnt d'Walen net auszielen bis d'Ofstëmmung fäerdeg ass.",
	'securepoll-can-decrypt' => "D'Opzeechnung vun de Walen gouf verschlësselt, awer den Ëntschlësselungscode ass disponibel.
Dir kënnt wielen tëschent der Auswäertung vun den aktuelle Resultater an der Datebank oder der Auswäertung an engem erofgeluedene Fichier.",
	'securepoll-tally-no-key' => "Dir kënnt dës Walen net auszielen, well d'Stëmme verschlësselt sinn, a den Entschlësselungs-Schlëssel net disponibel ass.",
	'securepoll-tally-local-legend' => 'Déi gespäichert Resultater auszielen',
	'securepoll-tally-local-submit' => 'Auszielung uleeën',
	'securepoll-tally-upload-legend' => 'Verschlësselten Dump eroplueden',
	'securepoll-tally-upload-submit' => 'Auszielung uleeën',
	'securepoll-tally-error' => "Feeler bäi der Interpretatioun vun de gespäicherten Donnéeë vun de Walen, d'Auszieleung kann net gemaach ginn.",
	'securepoll-no-upload' => "Et gouf kee Fichier eropgelueden, d'Resultater kënnen net ausgezielt ginn.",
	'securepoll-dump-corrupt' => 'Den Dump-Fichier ass futti a kann net verschafft ginn.',
	'securepoll-tally-upload-error' => 'Feeler bei der Auswertung vum Dump-Fichier: $1',
	'securepoll-pairwise-victories' => 'Matrice vun de Gewënner pro Koppel',
	'securepoll-strength-matrix' => 'Matrice vun der Stäerkt vum Pad',
	'securepoll-ranks' => 'Schlussclassement',
	'securepoll-average-score' => 'Duerchschnëttleche Score',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Benopat
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'securepoll' => 'VeiligSjtömme',
	'securepoll-desc' => 'Oetbreiding veur verkeziginge en vraogelieste',
	'securepoll-invalid-page' => 'Óngeldige subpagina "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => "Doe mós 'ne beheerder zeen óm dees hanjeling te moge oetveure.",
	'securepoll-too-few-params' => 'Óngenóg subpaasjparamaeters (óngeljige verwiezing).',
	'securepoll-invalid-election' => '"$1" is gein geljig verkezigingsnómmer.',
	'securepoll-welcome' => '<strong>Wèlkóm $1!</strong>',
	'securepoll-not-started' => 'Dees sjtömming is nag neet gesjtart.
De sjtömming vank op $2 aan óm $3.',
	'securepoll-finished' => 'Dees sjtömming is aafgeloupe, doe kins neet meer sjtömme.',
	'securepoll-not-qualified' => 'Doe bös neet bevoog óm te sjtömme in dees sjtömming: $1',
	'securepoll-change-disallowed' => 'Doe höbs al gesjtömp in dees sjtömming.
Doe moogs neet opnuuj sjtömme.',
	'securepoll-change-allowed' => "<strong>Opmèrking: Doe höbs al gesjtömp in dees sjtömming.</strong>
Doe kins dien sjtöm wiezige door 't óngersjtäönde formeleer op te sjlaon.
As se daoveur keus, wörd diene edere sjtöm verwiederd.",
	'securepoll-submit' => 'Sjlaon sjtöm op',
	'securepoll-gpg-receipt' => 'Danke veur diene sjtöm.

Doe kins de óngersjtäönde gegaeves beware as bewies van dien deilnaam aan dees sjtömming;

<pre>$1</pre>',
	'securepoll-thanks' => 'Danke, dien sjtöm is óntvange en opgesjlage.',
	'securepoll-return' => 'trök nao $1',
	'securepoll-encrypt-error' => "'t Codere van dien sjtöm is misluk.
Dien sjtöm is neet opgesjlage!

$1",
	'securepoll-no-gpg-home' => "'t Waas neet meugelik óm de thoesmap veur GPG aan te make.",
	'securepoll-secret-gpg-error' => "d'r Is 'n fout opgetraoje bie 't oetveure van GPG.
Gebroek \$wgSecurePollShowErrorDetail=true; in LocalSettings.php óm meer details waer te gaeve.",
	'securepoll-full-gpg-error' => "d'r Is 'n fout opgetraoje bie 't oetveure van GPG:

Beveel: $1

Fotmeljing:
<pre>$2</pre>",
	'securepoll-gpg-config-error' => 'De GPG-sjleutels zeen ónjuus ingesjteld.',
	'securepoll-gpg-parse-error' => "d'r Is 'n fout opgetraoje bie 't interpretere van GPG-oetveur.",
	'securepoll-no-decryption-key' => "d'r Is geine decryptiesjleutel ingesjteld.
Decodere is neet meugelik.",
	'securepoll-jump' => 'Gank nao de sjtömserver',
	'securepoll-bad-ballot-submission' => 'Dien sjtöm is óngeldig: $1',
	'securepoll-unanswered-questions' => 'Doe mós alle vraoge beantjwaorde.',
	'securepoll-remote-auth-error' => "d'r Is 'n fout opgetraoje bie 't ophaole van dien gebroekersinformatie van de server.",
	'securepoll-remote-parse-error' => "d'r Is 'n fout opgetraoje bie 't interpretere van 't antjwaord van de server.",
	'securepoll-api-invalid-params' => 'Óngeldige paramaeters.',
	'securepoll-api-no-user' => "d'r Is geine gebroeker gevónje mit 't opgegaeve ID.",
	'securepoll-api-token-mismatch' => 'Beveiligingstoke kömp neet euverein, inlogge is neet meugelik.',
	'securepoll-not-logged-in' => 'Doe mós aanmelde óm aan dees sjtömming deil te nömme',
	'securepoll-too-few-edits' => "Sorry, doe kins neet deilnömme aan de sjtömming. Doe mós temisnte $1 bewèrkinge höbbe gemaak óm te kinne sjtömme in dees verkeziging en doe höbs d'r $2.",
	'securepoll-blocked' => 'Sorry, doe kins neet deilnömme aan de sjtömming ómdet se geblokkeerd bös.',
	'securepoll-bot' => "Sorry, gebroekers mit 'ne botvlag moge neet sjtömme in dees sjtömming.",
	'securepoll-not-in-group' => 'Allein lede van de groep "$1" kinne aan dees sjtömming deilnömme.',
	'securepoll-not-in-list' => 'Sorry, doe sjteis neet op de veuraafvasgesjtelde lies van sjtömgerechtigde veur dees sjtömming.',
	'securepoll-list-title' => 'Sóm sjtömme op: $1',
	'securepoll-header-timestamp' => 'Tied',
	'securepoll-header-voter-name' => 'Naom',
	'securepoll-header-voter-domain' => 'Domein',
	'securepoll-header-ua' => 'Gebroekeragent',
	'securepoll-header-cookie-dup' => 'Dóbbel',
	'securepoll-header-strike' => 'Haol door',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Haol door',
	'securepoll-unstrike-button' => 'Haol neet door',
	'securepoll-strike-reason' => 'Raej:',
	'securepoll-strike-cancel' => 'Braek aaf',
	'securepoll-strike-error' => "Fout bie 't (neet) doorhaole: $1",
	'securepoll-details-link' => 'Details',
	'securepoll-details-title' => 'Sjtömdetails: #$1',
	'securepoll-invalid-vote' => '"$1" is gein geljig sjtömnómmer',
	'securepoll-header-voter-type' => 'Gebroekerstype',
	'securepoll-voter-properties' => 'Sjtömbeneudighede',
	'securepoll-strike-log' => 'Doorhaolingslogbook',
	'securepoll-header-action' => 'Hanjeling',
	'securepoll-header-reason' => 'Raej',
	'securepoll-header-admin' => 'Beheer',
	'securepoll-cookie-dup-list' => 'Gebroekers mit dóbbel cookies',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => "d'r Is gein versjleutelde sjtömmingsinformatie besjikbaar veur dees sjtömming, went de sjtömming is neet ingesjteld veur 't gebroek van versjleuteling.",
	'securepoll-dump-not-finished' => "De versjleutelde sjtömgegaeves zeen pas besjikbaar nao 't eindige van de sjtömming op $1 óm $2",
	'securepoll-dump-no-urandom' => "Kin /dev/urandom neet äöpene.
Óm de sjtömmersprivacy te behaje, zeen de sjtömmingsgegaeves pas besjikbaar es ze willekeurig gesorteerd kinne waere mit behölp van 'ne willekeurige nómmerreiks.",
	'securepoll-translate-title' => 'Vertaol: $1',
	'securepoll-invalid-language' => 'Óngeljige taolcode "$1"',
	'securepoll-submit-translate' => 'Wèrk bie',
	'securepoll-language-label' => 'Selecteer taol:',
	'securepoll-submit-select-lang' => 'Vertaol',
	'securepoll-header-title' => 'Naom',
	'securepoll-header-start-date' => 'Begindatum',
	'securepoll-header-end-date' => 'Einddatum',
	'securepoll-subpage-vote' => 'Sjtöm',
	'securepoll-subpage-translate' => 'Vertaal',
	'securepoll-subpage-list' => 'Lies',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Telling',
	'securepoll-tally-title' => 'Telling: $1',
	'securepoll-tally-not-finished' => 'Doe kins gein telling oetveure totdet de sjtömming is aafgeloupe.',
	'securepoll-no-upload' => "d'r Is gei besjtandj opgelaje, resultate kinne neet geteld waere.",
);

/** Lithuanian (Lietuvių)
 * @author Homo
 * @author Matasg
 */
$messages['lt'] = array(
	'securepoll' => 'Saugus balsavimas',
	'securepoll-desc' => 'Priemonė rinkimams ir apklausoms',
	'securepoll-invalid-page' => 'Netinkamas subpuslapis "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Jei norite atlikti šį veiksmą, Jums reikia administratoriumi.',
	'securepoll-too-few-params' => 'Nepakanka subpuslapio parametrų (negalioja nuoroda).',
	'securepoll-invalid-election' => '"$1" nėra tinkamas rinkimų ID.',
	'securepoll-welcome' => '<strong>Sveiki $1!</strong>',
	'securepoll-not-started' => 'Šie rinkimai dar nėra prasidėję.
Jie turėtų prasidėti $2 $3.',
	'securepoll-finished' => 'Šie rinkimai baigėsi, jūs nebegalite balsuoti.',
	'securepoll-not-qualified' => 'Jūs nesate kvalifikuotas balsuoti šiuose rinkimuose: $1',
	'securepoll-change-disallowed' => 'Jūs balsavote šiuose rinkimuose anksčiau.
Atsiprašome, jūs negalite balsuoti dar kartą.',
	'securepoll-change-allowed' => '<strong>Pastaba: Jūs balsavote anksčiau.</strong>
Galite pakeisti savo balsą, pasinaudodamas forma žemiau.
Jei tai padarysite, jūsų originalus balsavimas bus atmestas.',
	'securepoll-submit' => 'Balsuoti',
	'securepoll-gpg-receipt' => 'Dėkojame už balsą.

Jei norite, galite nusikopijuoti išrašą, kaip įrodymą, kad balsavote: 

<pre>$1</pre>',
	'securepoll-thanks' => 'Ačiū, jūsų balsas buvo įrašytas.',
	'securepoll-return' => 'Grįžti į $1',
	'securepoll-encrypt-error' => 'Nepavyko užšifruoti jūsų balsavimo įrašo.
Jūsų balsavimas nebuvo užregistruotas! 

$1',
	'securepoll-no-gpg-home' => 'Nepavyko sukurti GPG katalogo.',
	'securepoll-secret-gpg-error' => 'GPG vykdymo klaida.
Naudokite $wgSecurePollShowErrorDetail=true; skripte LocalSettings.php jei norite sužinoti daugiau informacijos.',
	'securepoll-full-gpg-error' => 'GPG vykdymo klaida: 

Komanda: $1

Klaida: 
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG raktai sukonfigūruoti netinkamai.',
	'securepoll-gpg-parse-error' => 'Klaida interpretuojant GPG išeigą.',
	'securepoll-no-decryption-key' => 'Nėra sukonfigūruoto atkodavimo rakto.
Negalima iššifruoti.',
	'securepoll-jump' => 'Eiti į balsavimo serverį',
	'securepoll-bad-ballot-submission' => 'Jūsų balsas netinkamas: $1',
	'securepoll-unanswered-questions' => 'Turite atsakyti į visus klausimus.',
	'securepoll-remote-auth-error' => 'Įvyko klaida pristatant jūsų paskyros informaciją iš serverio.',
	'securepoll-remote-parse-error' => 'Klaida interpretuojant leidimo atsakymą iš serverio.',
	'securepoll-api-invalid-params' => 'Netinkami parametrai',
	'securepoll-api-no-user' => 'Nerastas naudotojas su duotu ID.',
	'securepoll-api-token-mismatch' => 'Saugos žymės nesutampa, negalite prisijungti',
	'securepoll-not-logged-in' => 'Jūs turite prisijungti, norėdami balsuoti šiuose rinkimuose',
	'securepoll-too-few-edits' => 'Atsiprašome, Jūs negalite balsuoti. Jūs privalote atlikti bent $1 {{PLURAL:$1|redagavimą|redagavimų}}, norėdami balsuoti šiuose rinkimuose. Jūs atlikote $2.',
	'securepoll-blocked' => 'Atsiprašome, Jūs negalite balsuoti šiuose rinkimuose jei dabar esate užblokuotas.',
	'securepoll-bot' => 'Atsiprašome, sąskaitos su boto statusu negali balsuoti šiuose rinkimuose.',
	'securepoll-not-in-group' => 'Tik nariai iš grupės "$1" gali balsuoti šiuose rinkimuose.',
	'securepoll-not-in-list' => 'Atsiprašome, Jūs nesate vartotojų sąraše, kuriems leidžiama balsuoti šiuose rinkimuose.',
	'securepoll-list-title' => 'Rodyti balsus: $1',
	'securepoll-header-timestamp' => 'Laikas',
	'securepoll-header-voter-name' => 'Vardas',
	'securepoll-header-voter-domain' => 'Domenas',
	'securepoll-header-ua' => 'Naudotojo agentas',
	'securepoll-header-cookie-dup' => 'Nuor.',
	'securepoll-header-strike' => 'Uždrausti',
	'securepoll-header-details' => 'Detalės',
	'securepoll-strike-button' => 'Uždrausti',
	'securepoll-unstrike-button' => 'Nebedrausti',
	'securepoll-strike-reason' => 'Priežastis:',
	'securepoll-strike-cancel' => 'Atšaukti',
	'securepoll-strike-error' => 'Klaida atliekant uždraudimą/nebedraudimą: $1',
	'securepoll-details-link' => 'Detalės',
	'securepoll-details-title' => 'Balsavimo detalės: #$1',
	'securepoll-invalid-vote' => '"$1" nėra teisingas balsavimo ID',
	'securepoll-header-voter-type' => 'Balsavusiojo tipas',
	'securepoll-voter-properties' => 'Balsuotojo savybės',
	'securepoll-strike-log' => 'Uždraudimo sąrašas',
	'securepoll-header-action' => 'Veiksmas',
	'securepoll-header-reason' => 'Priežastis',
	'securepoll-header-admin' => 'Administratorius',
	'securepoll-cookie-dup-list' => 'Cookie dublikuoti naudotojai',
	'securepoll-dump-title' => 'Išmestas: $1',
	'securepoll-dump-no-crypt' => 'Nėra prieinamas nė vienas šifruotas rinkimų įrašas, nes rinkimai nėra sukonfigūruoti naudoti kodavimą.',
	'securepoll-dump-not-finished' => 'Šifruoti rinkimų įrašai prieinami tik po $1 $2',
	'securepoll-dump-no-urandom' => 'Nepavyko atidaryti /dev/urandom.  
Siekiant išlaikyti balsuotojų privatumą, šifruoti rinkimų įrašai viešai prieinami tik kai jie sumaišyti su saugiu atsitiktinių skaičių srautu.',
	'securepoll-translate-title' => 'Išversti: $1',
	'securepoll-invalid-language' => 'Neleistinas kalbos kodas "$1"',
	'securepoll-submit-translate' => 'Atnaujinti',
	'securepoll-language-label' => 'Pasirinkite kalbą:',
	'securepoll-submit-select-lang' => 'Išversti',
	'securepoll-header-title' => 'Pavadinimas',
	'securepoll-header-start-date' => 'Pradžios data',
	'securepoll-header-end-date' => 'Pabaigos data',
	'securepoll-subpage-vote' => 'Balsavimas',
	'securepoll-subpage-translate' => 'Vertimas',
	'securepoll-subpage-list' => 'Sąrašas',
	'securepoll-subpage-dump' => 'Perrašymas',
	'securepoll-subpage-tally' => 'Rezultatas',
	'securepoll-tally-title' => 'Rezultatas: $1',
	'securepoll-tally-not-finished' => 'Atsiprašome, Jūs negalite paskelbti rinkimų rezultato iki balsavimo baigties.',
	'securepoll-can-decrypt' => 'Rinkimų įrašas buvo šifruotas, tačiau iššifravimo raktas prieinamas. 
Galite pasirinkti, ar sutampa rezultatai, esantys duomenų bazėje bei rezultatuoti šifruotus rezultatus iš įkelto failo.',
	'securepoll-tally-no-key' => 'Jūs negalite paskelbti šių rinkimų rezultatų, nes balsai yra koduoti ir iššifravimo rakto nėra.',
	'securepoll-tally-local-legend' => 'Paskelbti išsaugotus rezultatus',
	'securepoll-tally-local-submit' => 'Sukurti rezultatus',
	'securepoll-tally-upload-legend' => 'Įkelti šifruotą turinį',
	'securepoll-tally-upload-submit' => 'Sukurti rezultatus',
	'securepoll-tally-error' => 'Klaida interpretuojant balsavimo įrašą, negalima sukurti suvestinių.',
	'securepoll-no-upload' => 'Failas nebuvo įkeltas, negalima skaičiuoti rezultatų.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Проширување за избори и истражувања',
	'securepoll-invalid-page' => 'Неважечка потстраница „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Треба да бидете изборен администратор за да можете да го сторите тоа.',
	'securepoll-too-few-params' => 'Нема доволно параметри за потстраници (неважечка врска).',
	'securepoll-invalid-election' => '„$1“ не претставува важечки идентификационен број.',
	'securepoll-welcome' => '<strong>Добредојдовте $1!</strong>',
	'securepoll-not-started' => 'Изборите сè уште не се започнати.
Предвидено е да започнат на $2 во $3.',
	'securepoll-finished' => 'Изборите завршија, повеќе не можете да гласате.',
	'securepoll-not-qualified' => 'Не сте квалификувани да гласате на овие избори: $1',
	'securepoll-change-disallowed' => 'Веќе имате гласано на овие избори.
Жалиме, но не ви е дозволено да гласате повторно.',
	'securepoll-change-allowed' => '<strong>Белешка: На овие избори сте гласале претходно.</strong>
Можете да гопромените вашиот глас со тоа што ќе го пополните долунаведениот образец.
Имајте в предвид дека ако го сторите тоа, вашиот првичен глас ќе биде поништен.',
	'securepoll-submit' => 'Поднеси глас',
	'securepoll-gpg-receipt' => 'Ви благодариме што гласавте.

Доколку сакате, можете да ја задржите оваа потврда како доказ дека сте гласале:

<pre>$1</pre>',
	'securepoll-thanks' => 'Ви благодариме, вашиот глас е заведен.',
	'securepoll-return' => 'Врати се на $1',
	'securepoll-encrypt-error' => 'Не можев да го шифрирам вашиот гласачки запис.
Вашиот глас не беше регистриран!

$1',
	'securepoll-no-gpg-home' => 'Не можам да создадам GPG именик.',
	'securepoll-secret-gpg-error' => 'Грешка при извршување на GPG.
Употребете $wgSecurePollShowErrorDetail=true; во LocalSettings.php за да се прикажат повеќе детали.',
	'securepoll-full-gpg-error' => 'Грешка при извршување на GPG:

Наредба: $1

Грешка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG клучевите се погрешно конфигурирани.',
	'securepoll-gpg-parse-error' => 'Грешка при толкувањето на излезните информации за GPG.',
	'securepoll-no-decryption-key' => 'Не е конфигуриран описниот клуч.
Не можам да дешифрирам.',
	'securepoll-jump' => 'Оди на гласачкиот сервер',
	'securepoll-bad-ballot-submission' => 'Вашиот глас е неважечки: $1',
	'securepoll-unanswered-questions' => 'Морате да одговорите на сите прашања.',
	'securepoll-invalid-rank' => 'Погрешен ранг. Кандидадите морате да ги рангирате со бројка помеѓу 1 и 999.',
	'securepoll-unranked-options' => 'Некои опции не беа рангирани.
Морате на сите опции да им доделите ранг помеѓу 1 и 999.',
	'securepoll-invalid-score' => 'Оцената мора да биде број од $1 до $2.',
	'securepoll-unanswered-options' => 'Мора да дадете одговор на секое прашање.',
	'securepoll-remote-auth-error' => 'Грешка при преземање на информациите за вашата сметка од серверот.',
	'securepoll-remote-parse-error' => 'Грешка при толкувањето на одговорот при барањето на дозвола за пристап на серверот.',
	'securepoll-api-invalid-params' => 'Неважечки параметри.',
	'securepoll-api-no-user' => 'Не бепе пронајден корисник со зададениот идентификационен број.',
	'securepoll-api-token-mismatch' => 'Не се совпаѓаат безбедносните кодови, не можам да ве најавам.',
	'securepoll-not-logged-in' => 'Морате да сте најавени за да гласате',
	'securepoll-too-few-edits' => 'Жалиме, но не можете да гласате. Треба да имате барем $1 {{PLURAL:$1|уредување|уредувања}} за да можете да гласате, а вие имате $2.',
	'securepoll-blocked' => 'Жалиме, но немате право да гласате ако сте моментално блокирани од уредување.',
	'securepoll-bot' => 'Жалиме, но сметките со бот-знаменце не се дозволени на изборите.',
	'securepoll-not-in-group' => 'На овие избори можат да гласаат само припадници на групата „$1“.',
	'securepoll-not-in-list' => 'Жалиме, но вие не сте на предодредената листа на корисници овластени да гласаат на овие избори.',
	'securepoll-list-title' => 'Наведи гласови: $1',
	'securepoll-header-timestamp' => 'Време',
	'securepoll-header-voter-name' => 'Име',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Кориснички агент',
	'securepoll-header-cookie-dup' => 'Дуп',
	'securepoll-header-strike' => 'Црта',
	'securepoll-header-details' => 'Детали',
	'securepoll-strike-button' => 'Црта',
	'securepoll-unstrike-button' => 'Врати црта',
	'securepoll-strike-reason' => 'Причина:',
	'securepoll-strike-cancel' => 'Откажи',
	'securepoll-strike-error' => 'Грешка при извршување на црта/врати црта: $1',
	'securepoll-strike-token-mismatch' => 'Сесиските податоци се изгубени',
	'securepoll-details-link' => 'Детали',
	'securepoll-details-title' => 'Детали за гласот: #$1',
	'securepoll-invalid-vote' => '„$1“ е неважечки гласачки идентификационен број',
	'securepoll-header-voter-type' => 'Тип на гласач',
	'securepoll-voter-properties' => 'Својства на гласачот',
	'securepoll-strike-log' => 'Дневник на ставање црти',
	'securepoll-header-action' => 'Дејство',
	'securepoll-header-reason' => 'Причина',
	'securepoll-header-admin' => 'Админ',
	'securepoll-cookie-dup-list' => 'Колачиња за дуплирани гласачи',
	'securepoll-dump-title' => 'Отпад: $1',
	'securepoll-dump-no-crypt' => 'Нема шифрирана гласачка евиденција за овие избори, бидејќи изборите не се конфигурирани да користат шифрирање.',
	'securepoll-dump-not-finished' => 'Шифрираната гласачка евиденција е достапна дури откога ќе завршат изборите ($1 во $2)',
	'securepoll-dump-no-urandom' => 'Не можам да отворам /dev/urandom.  
За да се одржи приватноста на гласачот, шифрираната гласачка евиденција станува достапна за јавноста само кога податоците од евиденцијата ќе можат да се мешаат со помош на безбедна низа на случајни броеви.',
	'securepoll-urandom-not-supported' => 'Овој сервер не поддржува криптографско создавање на случајни броеви.
За да се одржи приватноста на гласачите, шифрираните избирачки податоци стануваат достапни за јавноста само кога ќе можат да се мешаат со безбедна низа случајни броеви.',
	'securepoll-translate-title' => 'Преведи: $1',
	'securepoll-invalid-language' => 'Неважечки јазичен код „$1“',
	'securepoll-submit-translate' => 'Ажурирање',
	'securepoll-language-label' => 'Избери јазик:',
	'securepoll-submit-select-lang' => 'Преведување',
	'securepoll-entry-text' => 'Подолу е наведена листата на гласањата.',
	'securepoll-header-title' => 'Име',
	'securepoll-header-start-date' => 'Почетен датум',
	'securepoll-header-end-date' => 'Завршен датум',
	'securepoll-subpage-vote' => 'Глас',
	'securepoll-subpage-translate' => 'Преведи',
	'securepoll-subpage-list' => 'Листа',
	'securepoll-subpage-dump' => 'Отпаднати гласови',
	'securepoll-subpage-tally' => 'Преброј',
	'securepoll-tally-title' => 'Пребројување: $1',
	'securepoll-tally-not-finished' => 'Жалиме, но не можете да ги пребројувате изборите додека прво не заврши гласањето.',
	'securepoll-can-decrypt' => 'Изборната евиденција е шифрирана, но клучот за дешифрирање е на располагање.  
Можете да одберете да ги преброите резултатите кои се во базата на податоци, или пак да ги преброите шифрираните резултати од подигната податотека.',
	'securepoll-tally-no-key' => 'Не можете да ги пребројувате овие избори бидејќи гласовите се шифрирани, а клучот за дешифрирање не е достапен.',
	'securepoll-tally-local-legend' => 'Преброј ги складираните резултати',
	'securepoll-tally-local-submit' => 'Создај пребројување',
	'securepoll-tally-upload-legend' => 'Подигни шифрирана отпадна податотека',
	'securepoll-tally-upload-submit' => 'Создај пребројување',
	'securepoll-tally-error' => 'Грешка при толкување на гласовите, не можам да создадам пребројување.',
	'securepoll-no-upload' => 'Не беше подигната податотека, па не може да се пребројуваат резултатите.',
	'securepoll-dump-corrupt' => 'Отпадната податотека е расипана и не може да се обработи.',
	'securepoll-tally-upload-error' => 'Грешка при пребројување на отпаднатите гласови: $1',
	'securepoll-pairwise-victories' => 'Спарена матрица за пресметка на победникот',
	'securepoll-strength-matrix' => 'Матрица за јачина на патеката',
	'securepoll-ranks' => 'Конечно рангирање',
	'securepoll-average-score' => 'Просечна оценка',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'securepoll' => 'സുരക്ഷിതവോട്ടെടുപ്പ്',
	'securepoll-desc' => 'തിരഞ്ഞെടുപ്പുകൾക്കും അഭിപ്രായശേഖരണത്തിനുമുള്ള അനുബന്ധം',
	'securepoll-invalid-page' => 'അസാധുവായ ഉപതാൾ "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'ഈ പ്രവൃത്തി ചെയ്യാൻ തിരഞ്ഞെടുപ്പ് കാര്യനിർവാഹകൻ ഉണ്ടായിരിക്കണം.',
	'securepoll-too-few-params' => 'ആവശ്യമുള്ളത്ര ഉപതാൾ ചരങ്ങൾ ഇല്ല (അസാധുവായ കണ്ണി).',
	'securepoll-invalid-election' => '"$1" ഒരു സാധുവായ തിരഞ്ഞെടുപ്പ് ഐ.ഡി. അല്ല.',
	'securepoll-welcome' => '<strong>സ്വാഗതം $1!</strong>',
	'securepoll-not-started' => 'ഈ തിരഞ്ഞെടുപ്പ് ആരംഭിച്ചിട്ടില്ല.
$2-ൽ $3 മുതലാണ് ആരംഭിക്കുന്നത്.',
	'securepoll-finished' => 'തിരഞ്ഞെടുപ്പ് അവസാനിച്ചിരിക്കുന്നു, താങ്കൾക്ക് ഇനി വോട്ട് ചെയ്യാൻ കഴിയില്ല.',
	'securepoll-not-qualified' => 'ഈ തിരഞ്ഞെടുപ്പിൽ വോട്ട് ചെയ്യാൻ താങ്കൾ യോഗ്യത തെളിയിച്ചിട്ടില്ല: $1',
	'securepoll-change-disallowed' => 'ഈ തിരഞ്ഞെടുപ്പിൽ താങ്കൾ മുമ്പ് വോട്ട് ചെയ്തിരിക്കുന്നു.
ക്ഷമിക്കുക, വീണ്ടും വോട്ട് ചെയ്യാൻ താങ്കൾക്കവകാശമില്ല.',
	'securepoll-change-allowed' => '<strong>ശ്രദ്ധിക്കുക:താങ്കൾ ഈ തിരഞ്ഞെടുപ്പിൽ മുമ്പ് വോട്ട് ചെയ്തിരിക്കുന്നു.</strong>
താഴെയുള്ള ഫോം സമർപ്പിച്ച് താങ്കളുടെ വോട്ട് താങ്കൾക്ക് മാറ്റാവുന്നതാണ്.
ശ്രദ്ധിക്കുക, താങ്കൾ ഇപ്രകാരം ചെയ്യുകയാണെങ്കിൽ, ആദ്യം ചെയ്ത വോട്ട് ഒഴിവാക്കപ്പെടുന്നതാണ്.',
	'securepoll-submit' => 'വോട്ട് സമർപ്പിക്കുക',
	'securepoll-gpg-receipt' => 'വോട്ട് ചെയ്തതിനു നന്ദി.

താങ്കളുടെ വോട്ടിനു തെളിവായി താഴെ കൊടുത്തിരിക്കുന്ന രശീതി താങ്കൾക്കാഗ്രഹമുണ്ടെങ്കിൽ എടുക്കാവുന്നതാണ്:

<pre>$1</pre>',
	'securepoll-thanks' => 'നന്ദി, താങ്കളുടെ വോട്ട് ശേഖരിക്കപ്പെട്ടിരിക്കുന്നു.',
	'securepoll-return' => '$1 -ലേയ്ക്കു തിരിച്ചു പോവുക',
	'securepoll-encrypt-error' => 'താങ്കളുടെ വോട്ട് രേഖപ്പെടുത്തുവാനായി നിഗൂഢമാക്കാൻ കഴിഞ്ഞില്ല.
താങ്കളുടെ വോട്ട് രേഖപ്പെടുത്തിയില്ല!

$1',
	'securepoll-no-gpg-home' => 'അടിസ്ഥാന ജി.പി.ജി. ഡയറക്ടറി സൃഷ്ടിക്കാൻ കഴിയില്ല.',
	'securepoll-secret-gpg-error' => 'ജി.പി.ജി. ഉപയോഗിക്കുന്നതിൽ പിഴവ്.
കൂടുതൽ വിവരങ്ങൾക്ക് LocalSettings.php എന്നതിൽ $wgSecurePollShowErrorDetail=true; എന്നു നൽകുക.',
	'securepoll-full-gpg-error' => 'ജി.പി.ജി. പ്രവർത്തിപ്പിക്കുമ്പോൾ പിഴവ്:
നിർദ്ദേശം: $1

പിഴവ്:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG താക്കോലുകൾ തെറ്റായാണ് ക്രമീകരിക്കപ്പെട്ടിരിക്കുന്നത്.',
	'securepoll-no-decryption-key' => 'ഗൂഢീകരണം മാറ്റാനുള്ള ചാവി ക്രമീകരിച്ചിട്ടില്ല.
ഗൂഢീകരണം മാറ്റാൻ കഴിയില്ല.',
	'securepoll-jump' => 'വോട്ടിങ് സെർവറിലേയ്ക്ക് പോവുക',
	'securepoll-bad-ballot-submission' => 'താങ്കളുടെ വോട്ട് അസാധുവാണ്: $1',
	'securepoll-unanswered-questions' => 'താങ്കൾ എല്ലാ ചോദ്യങ്ങൾക്കും ഉത്തരം നൽകേണ്ടതാണ്.',
	'securepoll-invalid-rank' => 'അസാധുവായ റാങ്ക്. സ്ഥാനാർത്ഥികൾക്ക് 1 മുതൽ 999 വരെയുള്ള റാങ്കുകളിലൊന്നാണ് കൊടുക്കേണ്ടത്.',
	'securepoll-unranked-options' => 'ചിലവയ്ക്ക് റാങ്ക് നൽകിയിട്ടില്ല.
താങ്കൾ 1 മുതൽ 999 വരെയുള്ളതിനിടയ്ക്കുള്ള റാങ്ക് എല്ലാത്തിനും നൽകേണ്ടതാണ്.',
	'securepoll-invalid-score' => 'നൽകുന്ന വില $1, $2 എന്നിവയുടെ ഇടയിലുള്ളതായിരിക്കണം.',
	'securepoll-unanswered-options' => 'എല്ലാ ചോദ്യങ്ങൾക്കും താങ്കൾ പ്രതികരിക്കേണ്ടതാണ്.',
	'securepoll-remote-auth-error' => 'താങ്കളുടെ അംഗത്വ വിവരങ്ങൾ സെർവറിൽ നിന്ന് ശേഖരിക്കുമ്പോൾ പിഴവ് സംഭവിച്ചിരിക്കുന്നു.',
	'securepoll-remote-parse-error' => 'സെർവറിൽ നിന്നുള്ള അംഗീകരണ പ്രതികരണം വ്യാഖ്യാനിക്കുന്നതിൽ പിഴവുണ്ടായി.',
	'securepoll-api-invalid-params' => 'അസാധുവായ ചരങ്ങൾ.',
	'securepoll-api-no-user' => 'ലഭ്യമാക്കിയ ഐ.ഡി.യിൽ ഉപയോക്താക്കളെ ഒന്നും കണ്ടെത്താനായില്ല.',
	'securepoll-api-token-mismatch' => 'സുരക്ഷാ ചീട്ട് ഒത്തുപോകുന്നില്ല, പ്രവേശിക്കാൻ കഴിയില്ല.',
	'securepoll-not-logged-in' => 'ഈ തിരഞ്ഞെടുപ്പിൽ വോട്ട് ചെയ്യാൻ താങ്കൾ ലോഗിൻ ചെയ്യേണ്ടതാകുന്നു',
	'securepoll-too-few-edits' => 'ക്ഷമിക്കുക, താങ്കൾക്ക് വോട്ട് ചെയ്യാനാവില്ല. ഈ തിരഞ്ഞെടുപ്പിൽ വോട്ട് ചെയ്യാൻ താങ്കൾക്ക് $1 {{PLURAL:$1|തിരുത്തൽ|തിരുത്തലുകൾ}} ആവശ്യമാണ്, താങ്കൾക്ക് $2 എണ്ണമേയുള്ളു.',
	'securepoll-blocked' => 'ക്ഷമിക്കുക, താങ്കളെ ഇപ്പോൾ തിരുത്തുന്നതിൽ നിന്നും തടഞ്ഞിരിക്കുന്നതിനാൽ താങ്കൾക്ക് വോട്ട് ചെയ്യാൻ കഴിയില്ല.',
	'securepoll-bot' => 'ക്ഷമിക്കുക, ബോട്ട് പദവി ലഭിച്ച അംഗത്വങ്ങളെ ഈ തിരഞ്ഞെടുപ്പിൽ വോട്ട് ചെയ്യാൻ അനുവദിക്കുന്നില്ല.',
	'securepoll-not-in-group' => 'ഈ തിരഞ്ഞെടുപ്പിൽ "$1" ഗണത്തിൽ പെടുന്ന അംഗങ്ങൾക്കു മാത്രമേ വോട്ട് ചെയ്യാൻ കഴിയൂ.',
	'securepoll-not-in-list' => 'ക്ഷമിക്കുക, ഈ തിരഞ്ഞെടുപ്പിൽ വോട്ടു ചെയ്യാനായി മുൻകൂട്ടി നിശ്ചയിക്കപ്പെട്ട പട്ടികയിൽ താങ്കൾ ഇല്ല.',
	'securepoll-list-title' => 'വോട്ടുകളുടെ പട്ടിക: $1',
	'securepoll-header-timestamp' => 'സമയം',
	'securepoll-header-voter-name' => 'പേര്',
	'securepoll-header-voter-domain' => 'ഡൊമൈൻ',
	'securepoll-header-ua' => 'ഉപയോക്തൃ പ്രതിനിധി',
	'securepoll-header-cookie-dup' => 'അപര(ൻ)',
	'securepoll-header-strike' => 'വെട്ടുക',
	'securepoll-header-details' => 'വിവരങ്ങൾ',
	'securepoll-strike-button' => 'വെട്ടുക',
	'securepoll-unstrike-button' => 'വെട്ടൽ നീക്കുക',
	'securepoll-strike-reason' => 'കാരണം:',
	'securepoll-strike-cancel' => 'റദ്ദാക്കുക',
	'securepoll-strike-error' => 'വെട്ടൽ/അതൊഴിവാക്കൽ ചെയ്തതിൽ പിഴവ്: $1',
	'securepoll-strike-token-mismatch' => 'സെഷൻ വിവരങ്ങൾ നഷ്ടപ്പെട്ടിരിക്കുന്നു',
	'securepoll-details-link' => 'വിശദവിവരങ്ങൾ',
	'securepoll-details-title' => 'വോട്ടിന്റെ വിവരങ്ങൾ: #$1',
	'securepoll-invalid-vote' => '"$1" ഒരു സാധുവായ വോട്ട് ഐ.ഡി. അല്ല',
	'securepoll-header-voter-type' => 'വോട്ടർ തരം',
	'securepoll-voter-properties' => 'വോട്ടർ വിശേഷതകൾ',
	'securepoll-strike-log' => 'വെട്ടലുകൾ ചെയ്തതിന്റെ രേഖ',
	'securepoll-header-action' => 'പ്രവൃത്തി',
	'securepoll-header-reason' => 'കാരണം',
	'securepoll-header-admin' => 'കാര്യനിർവാഹകൻ',
	'securepoll-cookie-dup-list' => 'ഒരേ ഉപയോക്താക്കൾക്കായുള്ള കുക്കി',
	'securepoll-dump-title' => 'ഡമ്പ്: $1',
	'securepoll-dump-no-crypt' => 'തിരഞ്ഞെടുപ്പിൽ ഗൂഢീകരണം ക്രമീകരിച്ചിട്ടില്ലാത്തതിനാൽ, ഈ തിരഞ്ഞെടുപ്പിൽ ഗൂഢീകരിച്ച തിരഞ്ഞെടുപ്പ് വിവരങ്ങളൊന്നും ലഭ്യമല്ല.',
	'securepoll-dump-not-finished' => 'നിഗൂഢമാക്കപ്പെട്ട തിരഞ്ഞെടുപ്പ് രേഖകൾ തിരഞ്ഞെടുപ്പ് പൂർണ്ണമാകുന്ന $1 $2 -വിനു ശേഷം മാത്രമേ ലഭ്യമാവുകയുള്ളു',
	'securepoll-dump-no-urandom' => '/dev/urandom തുറക്കാൻ കഴിഞ്ഞില്ല.
വോട്ടു ചെയ്യുന്നയാളുടെ സ്വകാര്യത സൂക്ഷിക്കാനായി, നിഗൂഢമാക്കപ്പെട്ട തിരഞ്ഞെടുപ്പ് രേഖകൾ സുരക്ഷിത ക്രമരഹിത സംഖ്യാ ശ്രേണിയുമായി കശക്കിയ ശേഷം മാത്രമേ പൊതു ലഭ്യമാവുകയുള്ളു.',
	'securepoll-urandom-not-supported' => 'ഈ സെർവർ ഗൂഢീകരിച്ച ക്രമരഹിത സംഖ്യാ സൃഷ്ടി പിന്തുണയ്ക്കുന്നില്ല.
വോട്ട് ചെയ്യുന്നയാളിന്റെ സ്വകാര്യത സംരക്ഷിക്കാനായി, സുരക്ഷിതമായ ഒരു ക്രമരഹിത സംഖ്യാ ശ്രേണിയുമായി കശക്കി ഗൂഢീകരിച്ച വോട്ടെടുപ്പ് വിവരങ്ങൾ മാത്രമേ പുറത്തു വിടുകയുള്ളു.',
	'securepoll-translate-title' => 'തർജ്ജമ ചെയ്യുക:$1',
	'securepoll-invalid-language' => 'അസാധുവായ ഭാഷാ കോഡ് "$1"',
	'securepoll-submit-translate' => 'പുതുക്കുക',
	'securepoll-language-label' => 'ഭാഷ തിരഞ്ഞെടുക്കുക:',
	'securepoll-submit-select-lang' => 'തർജ്ജമ ചെയ്യുക',
	'securepoll-entry-text' => 'വോട്ടെടുപ്പുകളുടെ പട്ടികയാണ് താഴെ.',
	'securepoll-header-title' => 'പേര്',
	'securepoll-header-start-date' => 'തുടങ്ങുന്ന തീയതി',
	'securepoll-header-end-date' => 'അവസാനിക്കുന്ന തീയതി',
	'securepoll-subpage-vote' => 'വോട്ട്',
	'securepoll-subpage-translate' => 'തർജ്ജമ ചെയ്യുക',
	'securepoll-subpage-list' => 'ലിസ്റ്റ്',
	'securepoll-subpage-dump' => 'ഡമ്പ്',
	'securepoll-subpage-tally' => 'തുലനം ചെയ്യുക',
	'securepoll-tally-title' => 'തുലനം ചെയ്യുക: $1',
	'securepoll-tally-not-finished' => 'ക്ഷമിക്കുക, വോട്ടിങ് പൂർണ്ണമാകുന്നതുവരെ തിരഞ്ഞെടുപ്പ് തുലനം ചെയ്ത് നോക്കാൻ താങ്കൾക്ക് കഴിയില്ല.',
	'securepoll-tally-local-legend' => 'ശേഖരിക്കപ്പെട്ടിട്ടുള്ള ഫലങ്ങൾ തുലനം ചെയ്യുക',
	'securepoll-tally-local-submit' => 'ഒത്തുനോക്കൽ സൃഷ്ടിക്കുക',
	'securepoll-tally-upload-legend' => 'നിഗൂഢീകരിക്കപ്പെട്ട ഡമ്പ് അപ്‌‌ലോഡ് ചെയ്യുക',
	'securepoll-tally-upload-submit' => 'ഒത്തുനോക്കുക',
	'securepoll-no-upload' => 'യാതൊരു പ്രമാണവും അപ്‌‌ലോഡ് ചെയ്തിട്ടില്ല, ഫലങ്ങൾ തുലനം ചെയ്യാൻ കഴിയില്ല.',
	'securepoll-dump-corrupt' => 'ഡമ്പ് പ്രമാണം കേടാണ്, അതുകൊണ്ട് മുന്നോട്ടുപോകാൻ കഴിയില്ല.',
	'securepoll-tally-upload-error' => 'ഒത്തുനോക്കുന്നതിൽ പിഴവുണ്ടായ ഡമ്പ് പ്രമാണം: $1',
	'securepoll-pairwise-victories' => 'ജോഡിയായുള്ള വിജയ മട്രിക്സ്',
	'securepoll-ranks' => 'അന്തിമ റാങ്കിങ്',
	'securepoll-average-score' => 'ശരാശരി സ്കോർ',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 * @author Izzudin
 */
$messages['ms'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Sambungan untuk pemilihan dan tinjauan',
	'securepoll-invalid-page' => 'Sublaman tidak sah "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Anda perlu menjadi penyelia pilihan raya untuk melakukan ini.',
	'securepoll-too-few-params' => 'Parameter sublaman tidak cukup (pautan tidak sah).',
	'securepoll-invalid-election' => '"$1" bukan merupakan ID pemilihan yang sah.',
	'securepoll-welcome' => '<strong>Selamat datang $1!</strong>',
	'securepoll-not-started' => 'Pemilihan ini belum lagi bermula.
Ia dijadualkan bermula pada $2 pukul $3.',
	'securepoll-finished' => 'Pemilihan ini telah tamat, anda tidak lagi boleh mengundi.',
	'securepoll-not-qualified' => 'Anda tidak layak mengundi di dalam pemilihan ini: $1',
	'securepoll-change-disallowed' => 'Anda telah mengundi di dalam pemilihan ini sebelum ini.
Maaf, anda tidak boleh mengundi sekali lagi.',
	'securepoll-change-allowed' => '<strong>Nota: Anda telah mengundi di dalam pemilihan ini sebelum ini.</strong>
Anda boleh menukar undi anda dengan menyerahkan borang di bawah.
Perhatikan bahawa jika anda berbuat demikian, undi asal anda akan dimansuhkan.',
	'securepoll-submit' => 'Serah undian',
	'securepoll-gpg-receipt' => 'Terima kasih kerana mengundi.

Jika anda mahu, anda boleh menyimpan resit yang berikut sebagai bukti undian anda:

<pre>$1</pre>',
	'securepoll-thanks' => 'Terima kasih, undi anda telah direkodkan.',
	'securepoll-return' => 'Kembali ke $1',
	'securepoll-encrypt-error' => 'Gagal menyulitkan rekod undian anda.
Undi anda tidak direkodkan!

$1',
	'securepoll-no-gpg-home' => 'Tidak dapat mencipta direktori rumah GPG.',
	'securepoll-secret-gpg-error' => 'Ralat melakukan GPG.
Gunakan $wgSecurePollShowErrorDetail=true; dalam LocalSettings.php untuk menunjukkan butiran lebih.',
	'securepoll-full-gpg-error' => 'Ralat melakukan GPG:

Arahan: $1

Ralat:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Kunci GPG tidak dibentuk dengan betul.',
	'securepoll-gpg-parse-error' => 'Ralat mentafsirkan output GPG.',
	'securepoll-no-decryption-key' => 'Tiada kunci penyahsulitan dibentuk.
Tidak dapat menyahsulit.',
	'securepoll-jump' => 'Pergi ke pelayan undian',
	'securepoll-bad-ballot-submission' => 'Undi anda tak sah: $1',
	'securepoll-unanswered-questions' => 'Anda perlu jawab kesemua soalan.',
	'securepoll-invalid-rank' => 'Pangkat tidak sah. Anda mesti memberi calon pangkat di antara 1 dan 999.',
	'securepoll-unranked-options' => 'Ada pilihan yang tidak diberi pangkat.
Semua pilihan perlu diberikan pangkat di antara 1 dan 999.',
	'securepoll-invalid-score' => 'Mata mestilah nombor di antara $1 dan $2.',
	'securepoll-unanswered-options' => 'Anda mesti memberikan jawapan untuk setiap soalan.',
	'securepoll-remote-auth-error' => 'Ralat dalam mengambil maklumat akaun anda dari pelayan.',
	'securepoll-remote-parse-error' => 'Ralat menafsirkan jawapan kebenaran dari pelayan.',
	'securepoll-api-invalid-params' => 'Parameter tidak sah.',
	'securepoll-api-no-user' => 'Tiada pengguna dengan ID yang diberi dijumpai.',
	'securepoll-api-token-mismatch' => 'Token keselamatan tidak serasi, tidak dapat log masuk.',
	'securepoll-not-logged-in' => 'Anda mesti log masuk untuk mengundi dalam pemilihan ini',
	'securepoll-too-few-edits' => 'Maaf, anda tak boleh undi. Anda perlu mempunyai sekurang-kurangnya $1 suntingan untuk undi dalam pemilihan ini, anda kini ada $2 sahaja.',
	'securepoll-blocked' => 'Maaf, anda tak boleh mengundi jika anda kini telah disekat daripada menyunting.',
	'securepoll-bot' => 'Maaf, akaun dengan bendera bot tak dibenarkan untuk mengundi dalam pemilihan ini.',
	'securepoll-not-in-group' => 'Hanya ahli kumpulan "$1" sahaja boleh undi dalam pemilihan ini.',
	'securepoll-not-in-list' => 'Maaf, anda tidak berada dalam senarai pengguna yang dibenarkan untuk undi dalam pemilihan ini.',
	'securepoll-list-title' => 'Senarai undi: $1',
	'securepoll-header-timestamp' => 'Waktu',
	'securepoll-header-voter-name' => 'Nama',
	'securepoll-header-voter-domain' => 'Domain',
	'securepoll-header-ua' => 'Ejen pengguna',
	'securepoll-header-cookie-dup' => 'Bgd',
	'securepoll-header-strike' => 'Buang',
	'securepoll-header-details' => 'Lanjut',
	'securepoll-strike-button' => 'Buang',
	'securepoll-unstrike-button' => 'Kembalikan',
	'securepoll-strike-reason' => 'Alasan:',
	'securepoll-strike-cancel' => 'Batal',
	'securepoll-strike-error' => 'Ralat membuang/kembalikan: $1',
	'securepoll-strike-token-mismatch' => 'Data sesi hilang',
	'securepoll-details-link' => 'Lanjut',
	'securepoll-details-title' => 'Maklumat undi: #$1',
	'securepoll-invalid-vote' => '"$1" bukan ID undian yang sah',
	'securepoll-header-voter-type' => 'Jenis pengundi',
	'securepoll-voter-properties' => 'Sifat pengundi',
	'securepoll-strike-log' => 'Log pemotongan',
	'securepoll-header-action' => 'Tindakan',
	'securepoll-header-reason' => 'Sebab',
	'securepoll-header-admin' => 'Pentadbir',
	'securepoll-cookie-dup-list' => 'Pengguna salinan cookie',
	'securepoll-dump-title' => 'Longgokan: $1',
	'securepoll-dump-no-crypt' => 'Tiada rekod sulit pemilihan yang ada untuk pemilihan ini, kerana pemilihan tidak disusun untuk menggunakan penyulitan.',
	'securepoll-dump-not-finished' => 'Rekod sulit pemilihan hanya ada setelah tarikh tamat pada $1 pukul $2',
	'securepoll-dump-no-urandom' => 'Gagal membuka /dev/urandom.  
Untuk mengekalkan privasi pengundi, rekod sulit pemilihan hanya tersedia untuk awam apabila ia dirombak dengan aliran nombor rawak yang selamat.',
	'securepoll-urandom-not-supported' => 'Pelayan ini tidak menyokong penjanaan nombor rawak kriptografi.
Untuk mengekalkan keadaan berahsia pengundi, rekod pemilihan tersulit cuma boleh didapati umum apabila ia boleh diubah dengan aliran nombor rawak selamat.',
	'securepoll-translate-title' => 'Terjemah: $1',
	'securepoll-invalid-language' => 'Kod bahasa tidak sah "$1"',
	'securepoll-submit-translate' => 'Kemas kini',
	'securepoll-language-label' => 'Pilih bahasa:',
	'securepoll-submit-select-lang' => 'Terjemah',
	'securepoll-entry-text' => 'Di bawah ialah senarai undian.',
	'securepoll-header-title' => 'Nama',
	'securepoll-header-start-date' => 'Tarikh mula',
	'securepoll-header-end-date' => 'Tarikh tamat',
	'securepoll-subpage-vote' => 'Undi',
	'securepoll-subpage-translate' => 'Terjemah',
	'securepoll-subpage-list' => 'Senarai',
	'securepoll-subpage-dump' => 'Longgokan',
	'securepoll-subpage-tally' => 'Semak',
	'securepoll-tally-title' => 'Semak: $1',
	'securepoll-tally-not-finished' => 'Maaf, anda tidak dapat menyemak pemilihan sehingga selepas undian selesai.',
	'securepoll-can-decrypt' => 'Rekod pemilihan telah disulitkan, tetapi kunci penyulitan dapat diperoleh. 
Anda boleh memilih untuk menyemak keputusan yang ada dalam pangkalan data, atau menyemak keputusan yang disulitkan daripada fail yang dimuat naik.',
	'securepoll-tally-no-key' => 'Anda tidak boleh menyemak pemilihan ini, kerana undian disulitkan, dan kunci penyulitan tidak dapat diperoleh.',
	'securepoll-tally-local-legend' => 'Semak keputusan tersimpan',
	'securepoll-tally-local-submit' => 'Cipta semakan',
	'securepoll-tally-upload-legend' => 'Muat naik longgakan bersulit',
	'securepoll-tally-upload-submit' => 'Cipta semakan',
	'securepoll-tally-error' => 'Ralat mentafsir rekod undian, tidak dapat menghasilkan semakan.',
	'securepoll-no-upload' => 'Tiada fail dimuat naik, tidak dapat menyemak keputusan.',
	'securepoll-dump-corrupt' => 'Fail longgokan tercemar dan tidak dapat diproses.',
	'securepoll-tally-upload-error' => 'Ralat menyemak fail longgokan: $1',
	'securepoll-pairwise-victories' => 'Matriks kemenangan berpasangan',
	'securepoll-strength-matrix' => 'Matriks kekuatan laluan',
	'securepoll-ranks' => 'Kedudukan akhir',
	'securepoll-average-score' => 'Mata purataba',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Estensjoni għall-elezzjonijiet u s-sondaġġi',
	'securepoll-invalid-page' => 'Sottopaġna invalida "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Trid tkun amministratur tal-elezzjoni biex tesegwixxi din l-azzjoni.',
	'securepoll-too-few-params' => 'Parametri mhux biżżejjed tas-sottopaġna (ħolqa invalida)0.',
	'securepoll-invalid-election' => '"$1" mhijiex ID valida għall-elezzjoni.',
	'securepoll-welcome' => '<strong>Merħba $1!</strong>',
	'securepoll-not-started' => 'Din l-elezzjoni għadha ma bdietx.
Hi skedata li tibda nhar $2 fil-$3.',
	'securepoll-finished' => 'Din l-elezzjoni spiċċat, mhuwiex aktar possibbli li tivvota.',
	'securepoll-not-qualified' => "Ma tikwalifikax biex tivvota f'din l-elezzjoni: $1",
	'securepoll-change-disallowed' => "Diġà vvutajt f'din l-elezzjoni.
Mhuwiex possibbli li terġa' tivvota.",
	'securepoll-change-allowed' => "<strong>Nota: Inti diġà vvutajt f'din l-elezzjoni.</strong>
Tista' tbiddel il-vot tiegħek billi tibgħat il-formola t'hawn taħt.
Kun af li jekk tagħmel dan, il-vot oriġinali tiegħek jiġi skartat.",
	'securepoll-submit' => 'Ibgħat il-vot',
	'securepoll-gpg-receipt' => "Grazzi talli tajt l-vot tiegħek.

Jekk tixtieq tista' żżomm ir-riċevuta segwenti bħala evidenza tal-vot tiegħek:

<pre>$1</pre>",
	'securepoll-thanks' => 'Grazzi, il-vot tiegħek ġie reġistrat.',
	'securepoll-return' => "Erġa' lura lejn $1.",
	'securepoll-encrypt-error' => 'Impossibbli li l-voti tiegħek jiġi reġistrat.
Il-vot ma ġiex reġistrat!

$1',
	'securepoll-no-gpg-home' => "Impossibbli toħloq id-direttorju tad-destinazzjoni ta' GPG.",
	'securepoll-secret-gpg-error' => "Żball waqt l-eżekuzzjoni ta' GPG.
Uża \$wgSecurePollShowErrorDetail=true; f'LocalSettings.php biex turi aktar dettalji.",
	'securepoll-full-gpg-error' => "Żball waqt l-eżekuzzjoni ta' GPG:

Kmanda: $1

Żball:
<pre> $2 </pre>",
	'securepoll-gpg-config-error' => 'Iċ-ċwievet GPG ma ġew konfigurati sewwa.',
	'securepoll-gpg-parse-error' => "Żball fl-interpretazzjoni tar-riżultat ta' GPG.",
	'securepoll-no-decryption-key' => "L-ebda ċavetta ta' dekritazzjoni ma ġiet konfigurata.
Impossibbli li tiġi deċifrata.",
	'securepoll-jump' => 'Mur fis-server tal-votazzjoni',
	'securepoll-bad-ballot-submission' => 'Il-vot tiegħek kien invalidu: $1',
	'securepoll-unanswered-questions' => 'Trid tirrispondi kull mistoqsija.',
	'securepoll-remote-auth-error' => 'Żball waqt ir-ripristinaġġ mis-server tal-informazzjoni fuq il-kont tiegħek.',
	'securepoll-remote-parse-error' => "Żball fl-interpretazzjoni mis-server tar-risposta ta' awtorizzazzjoni.",
	'securepoll-api-invalid-params' => 'Parametri invalidi.',
	'securepoll-api-no-user' => 'L-ebda utent ma nstab bl-ID li ngħatat.',
	'securepoll-api-token-mismatch' => "It-token ta' sigurtà ma jaqbilx, ma tistax tidħol.",
	'securepoll-not-logged-in' => "Trid teffettwa l-login qabel ma tivvota f'din l-elezzjoni",
	'securepoll-too-few-edits' => "Jiddispjaċina, ma tistax tivvota. Trid tal-anqas tkun għamilt $1 {{PLURAL:$1|modifika|modifika}} biex tivvota f'din l-elezzjoni, inti għamilt $2.",
	'securepoll-blocked' => "Jiddispjaċina, ma tistax tivvota f'din l-elezzjoni jekk inti attwalment imblukkat milli timmodifika.",
	'securepoll-bot' => "Jiddispjaċina, il-kontijiet li għandhom l-istatus ta' bot ma jistgħux jivvutaw f'din l-elezzjoni.",
	'securepoll-not-in-group' => 'Il-membri biss tal-grupp "$1" jistgħu jivvutaw f\'din l-elezzjoni.',
	'securepoll-not-in-list' => "Jiddispjaċina, mintix fil-lista predeterminata tal-utenti awtorizzati li jivvutaw f'din l-elezzjoni.",
	'securepoll-list-title' => 'Lista tal-voti: $1',
	'securepoll-header-timestamp' => 'Ħin',
	'securepoll-header-voter-name' => 'Isem',
	'securepoll-header-voter-domain' => 'Dominju',
	'securepoll-header-ua' => 'Aġent tal-utent',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Annulla',
	'securepoll-header-details' => 'Dettalji',
	'securepoll-strike-button' => 'Annulla dan il-vot',
	'securepoll-unstrike-button' => 'Neħħi l-annulament',
	'securepoll-strike-reason' => 'Raġuni:',
	'securepoll-strike-cancel' => 'Annulla',
	'securepoll-strike-error' => 'Żball waqt l-annulament jew ir-ripristinaġġ tal-vot: $1',
	'securepoll-details-link' => 'Dettalji',
	'securepoll-details-title' => 'Dettalji tal-vot: #$1',
	'securepoll-invalid-vote' => '"$1" mhijiex ID ta\' vot validu',
	'securepoll-header-voter-type' => "Tip ta' votant",
	'securepoll-voter-properties' => 'Proprjetajiet tal-votant',
	'securepoll-strike-log' => 'Reġistru tal-annulamenti',
	'securepoll-header-action' => 'Azzjoni',
	'securepoll-header-reason' => 'Raġuni',
	'securepoll-header-admin' => 'Amministratur',
	'securepoll-cookie-dup-list' => 'Utenti doppji skont il-cookie',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => "Għal din l-elezzjoni mhi disponibbli l-ebda reġistrazzjoni kriptata, minħabba li l-elezzjoni mhix imposta li tuża' l-kritazzjoni.",
	'securepoll-dump-not-finished' => "Ir-reġistrazzjonijiet kriptati tal-elezzjoni huma disponibbli biss wara d-data ta' konklużjoni: $1 fil-$2",
	'securepoll-dump-no-urandom' => "Ma jistax jinfetaħ /dev/urandom.
Biex tinżamm il-privatezza tal-votant, ir-reġistrazzjonijieet kriptati tal-elezzjoni huma disponibbli pubblikament biss meta jistgħu jkunu mħawwda b'influss sigur ta' numru każwali.",
	'securepoll-translate-title' => 'Ittraduċi: $1',
	'securepoll-invalid-language' => 'Kodiċi tal-lingwa invalidu: "$1"',
	'securepoll-submit-translate' => 'Aġġorna',
	'securepoll-language-label' => 'Agħżel lingwa:',
	'securepoll-submit-select-lang' => 'Ittraduċi',
	'securepoll-header-title' => 'Isem',
	'securepoll-header-start-date' => 'Data tal-bidu',
	'securepoll-header-end-date' => 'Data tat-tmiem',
	'securepoll-subpage-vote' => 'Ivvota',
	'securepoll-subpage-translate' => 'Ittraduċi',
	'securepoll-subpage-list' => 'Elenka',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Talja',
	'securepoll-tally-title' => 'Talja: $1',
	'securepoll-tally-not-finished' => 'Jiddispjaċina, ma tisgtħux tgħoddu r-riżultati tal-elezzjoni qabel mal-votazzjoni tispiċċa.',
	'securepoll-can-decrypt' => "Ir-reġistru tal-elezzjoni ġie kriptat, però ċ-ċavetta ta' dekritazzjoni hija disponibbli.
Inti tista' tagħżel jew li tgħodd ir-riżultati preżenti fid-databażi, jew li tgħodd ir-riżultati kriptati minn fajl imtella'.",
	'securepoll-tally-no-key' => 'Ma tistax tgħodd ir-riżultati tal-elezzjoni, minħabba li l-voti huma kriptati, u ċ-ċavetta tad-dekritazzjoni mhix disponibbli.',
	'securepoll-tally-local-legend' => 'L-għadd tar-riżultati salvati',
	'securepoll-tally-local-submit' => 'Oħloq talja',
	'securepoll-tally-upload-legend' => "Tella' riserva kriptata",
	'securepoll-tally-upload-submit' => 'Oħloq talja',
	'securepoll-tally-error' => 'Żball fl-interpretazzjoni tar-reġistrazzjoni tal-vot, ir-riżultati ma jistgħux jingħaddu.',
	'securepoll-no-upload' => "L-ebda fajl ma ġie mtella', ir-riżultati ma jistgħux jingħaddu.",
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'securepoll' => 'SekerAfstimmen',
	'securepoll-desc' => 'Extension för Wahlen un Ümfragen',
	'securepoll-invalid-page' => 'Ungüllige Ünnersied „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Du musst Administrater wesen, dat du dat doon kannst.',
	'securepoll-too-few-params' => 'Nich noog Ünnersiedenparameters (Lenk verkehrt).',
	'securepoll-invalid-election' => '„$1“ is keen güllige Wahl-ID.',
	'securepoll-welcome' => '<strong>Willkamen $1!</strong>',
	'securepoll-not-started' => 'De Wahl hett noch nich anfungen.
De Wahl schall an’n $2 üm $3 anfangen.',
	'securepoll-finished' => 'De Wahl is toenn, du kannst nich mehr afstimmen.',
	'securepoll-not-qualified' => 'Du dröffst bi disse Wahl nich mit afstimmen: $1',
	'securepoll-change-disallowed' => 'Du hest bi disse Wahl al afstimmt.
Du dröffst nich noch wedder afstimmen.',
	'securepoll-change-allowed' => '<strong>Henwies: Du hest bi disse Wahl al afstimmt.</strong>
Du kannst dien Stimm ännern, wenn du dat Formular ünnen afschickst.
Wenn du dat deist, denn warrt dien ole Stimm överschreven.',
	'securepoll-submit' => 'Stimm afgeven',
	'securepoll-gpg-receipt' => 'Wees bedankt dat du bi de Wahl mitmaakt hest.

Wenn du wullt, kannst du disse Quittung opbewohren as Nawies, dat du bi de Wahl mitmaakt hest:

<pre>$1</pre>',
	'securepoll-thanks' => 'Wees bedankt, dien Stimm is optekent.',
	'securepoll-return' => 'Trüch na $1',
	'securepoll-encrypt-error' => 'Fehler bi’t Verslöteln vun dien Stimm.
Dien Stimm is nich spiekert worrn!

$1',
	'securepoll-no-gpg-home' => 'Kann de GPG-Tohuus-Mapp nich opstellen.',
	'securepoll-secret-gpg-error' => 'Fehler bi’t Utföhren vun GPG.
Du kannst $wgSecurePollShowErrorDetail=true; in LocalSettings.php infögen, mehr Details to wiesen.',
	'securepoll-full-gpg-error' => 'Fehler bi’t Utföhren vun GPG:

Befehl: $1

Fehler:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'De GPG-Slötels sünd verkehrt instellt.',
	'securepoll-gpg-parse-error' => 'Fehler bi’t Interpreteren vun de GPG-Utgaav.',
	'securepoll-no-decryption-key' => 'Keen Opslötel-Slötel instellt.
Opslöteln geiht nich.',
	'securepoll-jump' => 'Na’n Afstimmserver gahn',
	'securepoll-bad-ballot-submission' => 'Dien Stimm weer ungüllig: $1',
	'securepoll-unanswered-questions' => 'Du musst all Fragen antern.',
	'securepoll-remote-auth-error' => 'Fehler bi’t Afropen vun dien Brukerkonteninfos vun’n Server.',
	'securepoll-remote-parse-error' => 'Fehler bi’t Interpreteren vun de Antwoord vun’n Server to de Rechten.',
	'securepoll-api-invalid-params' => 'Ungüllige Parameters.',
	'securepoll-api-no-user' => 'Keen Bruker mit de angeven ID funnen.',
	'securepoll-api-token-mismatch' => 'Verkehrt Sekerheitstoken, Anmellen hett nich klappt.',
	'securepoll-not-logged-in' => 'Du musst anmellt wesen, dat du bi disse Wahl afstimmen dröffst',
	'securepoll-too-few-edits' => 'Du dröffst nich afstimmen. Du musst opminnst $1 {{PLURAL:$1|Ännern|Ännern}}, dat du bi disse Wahl afstimmen dröffst, du hest aver blot $2.',
	'securepoll-blocked' => 'Du dröffst bi disse Wahl nich afstimmen. Du büst opstunns as Bruker sperrt.',
	'securepoll-bot' => 'Du dröffst bi disse Wahl nich afstimmen. Dien Brukerkonto is as Bot kenntekent.',
	'securepoll-not-in-group' => 'Blot Maten vun de Grupp „$1“ dröfft bi de Wahl afstimmen.',
	'securepoll-not-in-list' => 'Du büst nich op de List vun Brukers, de bi disse Wahl afstimmen dröfft.',
	'securepoll-list-title' => 'Stimmen wiesen: $1',
	'securepoll-header-timestamp' => 'Tied',
	'securepoll-header-voter-name' => 'Naam',
	'securepoll-header-voter-domain' => 'Domään',
	'securepoll-header-ua' => 'Brukeragent',
	'securepoll-header-cookie-dup' => 'Dubbel',
	'securepoll-header-strike' => 'Strieken',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Strieken',
	'securepoll-unstrike-button' => 'Strieken trüchnehmen',
	'securepoll-strike-reason' => 'Grund:',
	'securepoll-strike-cancel' => 'Afbreken',
	'securepoll-strike-error' => 'Fehler bi’t Strieken/Strieken rutnehmen: $1',
	'securepoll-details-link' => 'Details',
	'securepoll-details-title' => 'Afstimmdetails: #$1',
	'securepoll-invalid-vote' => '„$1“ is keen güllige Afstimm-ID',
	'securepoll-header-voter-type' => 'Wählertyp',
	'securepoll-voter-properties' => 'Wähleregenschoppen',
	'securepoll-strike-log' => 'Striek-Logbook',
	'securepoll-header-action' => 'Akschoon',
	'securepoll-header-reason' => 'Grund',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Brukers, de dubbelt afstimmt hebbt',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Dat gifft för disse Wahl keen verslötelt Stimmopteeknungen, för disse Wahl is keen Slötel instellt.',
	'securepoll-dump-not-finished' => 'Verslötelt Stimmopteeknungen sünd eerst verföögbor, nadem de Wahl toenn is (an’n $1 üm $2)',
	'securepoll-dump-no-urandom' => 'Kann /dev/urandom nixh apen maken.
Dat de Wählerdatenschutz sekerstellt is, sünd verslötelt Stimmopteeknungen blot denn apen to sehn, wenn se mit en sekern Tofallstallenstroom dörmengelt warrn köönt.',
	'securepoll-translate-title' => 'Översetten: $1',
	'securepoll-invalid-language' => 'Verkehrt Spraakkood „$1“',
	'securepoll-submit-translate' => 'Aktuell maken',
	'securepoll-language-label' => 'Spraak utwählen:',
	'securepoll-submit-select-lang' => 'Översetten',
	'securepoll-header-title' => 'Naam',
	'securepoll-header-start-date' => 'Starttied',
	'securepoll-header-end-date' => 'Enntied',
	'securepoll-subpage-vote' => 'Afstimmen',
	'securepoll-subpage-translate' => 'Översetten',
	'securepoll-subpage-list' => 'List',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Tell',
	'securepoll-tally-title' => 'Tell: $1',
	'securepoll-tally-not-finished' => 'Du kannst keen Tell opstellen, solang de Wahl nich toenn is.',
	'securepoll-can-decrypt' => 'De Stimmopteeknungen sünd verslötelt, aver de Opslötel-Slötel is verföögbor.  
Du kannst de Resultaten in de Datenbank tohooptellen laten, oder de verslötelt Resultaten ut en hoochlaadt Datei.',
	'securepoll-tally-no-key' => 'Du kannst keen Tell opstellen laten. De Stimmen sünd verslötelt un de Opslötel-Slötel is nich verföögbor.',
	'securepoll-tally-local-legend' => 'Spiekert Resultaten tohooptellen',
	'securepoll-tally-local-submit' => 'Tell opstellen',
	'securepoll-tally-upload-legend' => 'Verslötelt Dump hoochladen',
	'securepoll-tally-upload-submit' => 'Tell opstellen',
	'securepoll-tally-error' => 'Fehler bi’t Interpreteren vun de Stimmopteeknungen, kann keen Tell opstellen.',
	'securepoll-no-upload' => 'Keen Datei hoochlaadt, kann keen Tell opstellen.',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'securepoll-translate-title' => 'Vertalen: $1',
	'securepoll-submit-select-lang' => 'Vertalen',
	'securepoll-subpage-translate' => 'Vertalen',
);

/** Dutch (Nederlands)
 * @author Mwpnl
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'securepoll' => 'VeiligStemmen',
	'securepoll-desc' => 'Uitbreiding voor stemmingen en enquêtes',
	'securepoll-invalid-page' => 'Ongeldige subpagina "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'U moet een stemmingenbeheerder zijn om deze handeling te mogen uitvoeren.',
	'securepoll-too-few-params' => 'Onvoldoende subpaginaparameters (ongeldige verwijzing).',
	'securepoll-invalid-election' => '"$1" is geen geldig stemmingsnummer.',
	'securepoll-welcome' => '<strong>Welkom $1!</strong>',
	'securepoll-not-started' => 'Deze stemming is nog niet gestart.
De stemming begint op $2 om $3.',
	'securepoll-finished' => 'Deze stemming is afgelopen, u kunt niet meer stemmen.',
	'securepoll-not-qualified' => 'U bent niet bevoegd om te stemmen in deze stemming: $1',
	'securepoll-change-disallowed' => 'U hebt al gestemd in deze stemming.
U mag niet opnieuw stemmen.',
	'securepoll-change-allowed' => '<strong>Opmerking: U hebt al gestemd in deze stemming.</strong>
U kunt uw stem wijzigigen door het onderstaande formulier op te slaan.
Als u daarvoor kiest, wordt uw eerdere stem verwijderd.',
	'securepoll-submit' => 'Stem opslaan',
	'securepoll-gpg-receipt' => 'Dank u voor uw stem.

U kunt de onderstaande gegevens bewaren als bewijs van uw deelname aan deze stemming:

<pre>$1</pre>',
	'securepoll-thanks' => 'Dank u wel. Uw stem is ontvangen en opgeslagen.',
	'securepoll-return' => 'terug naar $1',
	'securepoll-encrypt-error' => 'Het coderen van uw stem is mislukt.
Uw stem is niet opgeslagen!

$1',
	'securepoll-no-gpg-home' => 'Het was niet mogelijk om de thuismap voor GPG aan te maken.',
	'securepoll-secret-gpg-error' => 'Er is een fout opgetreden bij het uitvoeren van GPG.
Gebruik $wgSecurePollShowErrorDetail=true; in LocalSettings.php om meer details weer te geven.',
	'securepoll-full-gpg-error' => 'Er is een fout opgetreden bij het uitvoeren van GPG:

Commando: $1

Foutmelding:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'De GPG-sleutels zijn onjuist ingesteld.',
	'securepoll-gpg-parse-error' => 'Er is een fout opgetreden bij het interpreteren van GPG-uitvoer.',
	'securepoll-no-decryption-key' => 'Er is geen decryptiesleutel ingesteld.
Decoderen is niet mogelijk.',
	'securepoll-jump' => 'Naar de stemserver gaan',
	'securepoll-bad-ballot-submission' => 'Uw stem is ongeldig: $1',
	'securepoll-unanswered-questions' => 'U moet alle vragen beantwoorden.',
	'securepoll-invalid-rank' => 'Ongeldige rang.
U moet de kandidaten een rang geven tussen 1 en 999.',
	'securepoll-unranked-options' => 'Sommige stemmogelijkheden hebben geen rang.
U moet alle mogelijkheden een rang geven tussen 1 en 999.',
	'securepoll-invalid-score' => 'De score moet een getal tussen $1 en $2 zijn.',
	'securepoll-unanswered-options' => 'U moet iedere vraag beantwoorden.',
	'securepoll-remote-auth-error' => 'Er is een fout opgetreden bij het ophalen van uw gebruikersinformatie van de server.',
	'securepoll-remote-parse-error' => 'Er is een fout opgetreden bij het interpreteren van het antwoord van de server.',
	'securepoll-api-invalid-params' => 'Ongeldige parameters.',
	'securepoll-api-no-user' => 'Er is geen gebruiker gevonden met de opgegeven ID.',
	'securepoll-api-token-mismatch' => 'Het beveiligingstoken kwam niet overeen met wat verwacht werd.
Aanmelden is niet mogelijk.',
	'securepoll-not-logged-in' => 'U moet aanmelden om aan deze stemming deel te nemen',
	'securepoll-too-few-edits' => 'Sorry, u kunt niet deelnemen aan de stemming.
U moet ten minste $1 {{PLURAL:$1|bewerking|bewerkingen}} hebben gemaakt om te kunnen stemmen in deze stemming, en u hebt er $2.',
	'securepoll-blocked' => 'Sorry, u kunt niet deelnemen aan de stemming omdat u geblokkeerd bent.',
	'securepoll-bot' => 'Sorry, gebruikers met een botvlag mogen niet stemmen in deze stemming.',
	'securepoll-not-in-group' => 'Alleen leden van de groep "$1" kunnen aan deze stemming deelnemen.',
	'securepoll-not-in-list' => 'Sorry, u staat niet op de vooraf vastgestelde lijst van stemgerechtigden voor deze stemming.',
	'securepoll-list-title' => 'Stemmen weergeven: $1',
	'securepoll-header-timestamp' => 'Tijd',
	'securepoll-header-voter-name' => 'Naam',
	'securepoll-header-voter-domain' => 'Domein',
	'securepoll-header-ua' => 'User-agent',
	'securepoll-header-cookie-dup' => 'Dubbel',
	'securepoll-header-strike' => 'Doorhalen',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Doorhalen',
	'securepoll-unstrike-button' => 'Doorhalen ongedaan maken',
	'securepoll-strike-reason' => 'Reden:',
	'securepoll-strike-cancel' => 'Annuleren',
	'securepoll-strike-error' => 'Er is een fout opgetreden bij het uitvoeren doorhalen/doorhalen ongedaan maken: $1',
	'securepoll-strike-token-mismatch' => 'De sessiegegevens zijn verloren gegaan.',
	'securepoll-details-link' => 'Details',
	'securepoll-details-title' => 'Stemdetails: #$1',
	'securepoll-invalid-vote' => '"$1" is geen geldig stemnummer',
	'securepoll-header-voter-type' => 'Gebruikerstype',
	'securepoll-voter-properties' => 'Kiezerseigenschappen',
	'securepoll-strike-log' => 'Logboek stemmen doorhalen',
	'securepoll-header-action' => 'Handeling',
	'securepoll-header-reason' => 'Reden',
	'securepoll-header-admin' => 'Beheer',
	'securepoll-cookie-dup-list' => 'Gebruikers met dubbele cookies',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Er is geen versleutelde stemmingsinformatie beschikbaar voor deze stemming, want de stemming is niet ingesteld voor het gebruik van versleuteling.',
	'securepoll-dump-not-finished' => 'De versleutelde stemgegevens zijn pas beschikbaar na het eindigen van de stemming op $1 om $2',
	'securepoll-dump-no-urandom' => 'Het was niet mogelijk om /dev/urandom te openen.
Om de privacy van de stemmers te beschermen, zijn de stemmingsgegevens pas beschikbaar als ze willekeurig gesorteerd kunnen worden met behulp van een willekeurige nummerreeks.',
	'securepoll-urandom-not-supported' => 'Deze server biedt geen ondersteuning voor het versleuteld aanmaken van willekeurige getallen.
Om de anonimiteit van stemmers te handhaven, zijn de versleutelde stemresultaten pas beschikbaar als ze zijn herordend via een veilige reeks van willekeurige getallen.',
	'securepoll-translate-title' => 'Vertalen: $1',
	'securepoll-invalid-language' => 'Ongeldige taalcode "$1"',
	'securepoll-submit-translate' => 'Bijwerken',
	'securepoll-language-label' => 'Taal selecteren:',
	'securepoll-submit-select-lang' => 'Vertalen',
	'securepoll-entry-text' => 'Hieronder wordt een lijst met stemmingen weergegeven.',
	'securepoll-header-title' => 'Naam',
	'securepoll-header-start-date' => 'Begindatum',
	'securepoll-header-end-date' => 'Einddatum',
	'securepoll-subpage-vote' => 'Stemmen',
	'securepoll-subpage-translate' => 'Vertalen',
	'securepoll-subpage-list' => 'Lijst',
	'securepoll-subpage-dump' => 'Dumpen',
	'securepoll-subpage-tally' => 'Telling',
	'securepoll-tally-title' => 'Telling: $1',
	'securepoll-tally-not-finished' => 'U kunt geen telling uitvoeren totdat de stemming is afgelopen.',
	'securepoll-can-decrypt' => 'De resultaten van de stemming zijn versleuteld, maar de coderingssleutel is beschikbaar.
U kunt de in de database beschikbare resultaten tellen, of de resultaten uit een bestandsupload tellen.',
	'securepoll-tally-no-key' => 'U kunt geen telling uitvoeren voor deze stemming, omdat de stemmen versleuteld zijn en de sleutel niet beschikbaar is.',
	'securepoll-tally-local-legend' => 'Opgeslagen resultaten',
	'securepoll-tally-local-submit' => 'Telling uitvoeren',
	'securepoll-tally-upload-legend' => 'Versleutelde dump uploaden',
	'securepoll-tally-upload-submit' => 'Telling uitvoeren',
	'securepoll-tally-error' => 'Er is een fout opgetreden bij het interpreteren van resulaten van de stemming.
Het is niet mogelijk een telling uit te voeren.',
	'securepoll-no-upload' => 'Er is geen bestand geüpload.
De resultaten kunnen niet geteld worden.',
	'securepoll-dump-corrupt' => 'Het dumpbestand is beschadigd en kan niet worden verwerkt.',
	'securepoll-tally-upload-error' => 'Er is een fout opgetreden bij het tellen uit de dump: $1',
	'securepoll-pairwise-victories' => 'Paarsgewijze overwinningsmatrix',
	'securepoll-strength-matrix' => 'Padgesterkte matrix',
	'securepoll-ranks' => 'Definitieve rangschikking',
	'securepoll-average-score' => 'Gemiddelde score',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'securepoll' => 'TrygtVal',
	'securepoll-desc' => 'Ei utviding for val og undersøkingar',
	'securepoll-invalid-page' => 'Ugyldig underside «<nowiki>$1</nowiki>»',
	'securepoll-need-admin' => 'Du må vera ein administrator for å kunna utføra denne handlinga.',
	'securepoll-too-few-params' => 'Ikkje nok undersideparametrar (ugyldig lenkje)',
	'securepoll-invalid-election' => '«$1» er ikkje ein gyldig val-ID.',
	'securepoll-welcome' => '<strong>Velkomen, $1!</strong>',
	'securepoll-not-started' => 'Dette valet har ikkje starta enno.
Det gjer det etter planen på $2 ved $3.',
	'securepoll-finished' => 'Dette valet er avslutta, du kan ikkje lenger røysta.',
	'securepoll-not-qualified' => 'Du er ikkje kvalifisert til å røysta i dette valet: $1',
	'securepoll-change-disallowed' => 'Du har alt røysta i dette valet og kan ikkje røysta på nytt.',
	'securepoll-change-allowed' => '<strong>Merk: Du har alt røysta i dette valet.</strong>
Du kan endra røysta di gjennom å senda inn skjemaet under.
Merk at om du gjer dette, vil den opphavlege røysta di verta sletta.',
	'securepoll-submit' => 'Røyst',
	'securepoll-gpg-receipt' => 'Takk for at du gav røysta di.

Om du ynskjer det, kan du ta vare på den fylgjande kvitteringa som eit prov på røysta di:

<pre>$1</pre>',
	'securepoll-thanks' => 'Takk, røysta di er vorten registrert.',
	'securepoll-return' => 'Attende til $1',
	'securepoll-encrypt-error' => 'Klarte ikkje kryptera røysta di.
Ho har ikkje vorte registrert!

$1',
	'securepoll-no-gpg-home' => 'Kunne ikkje oppretta heimekatalog for GPG',
	'securepoll-secret-gpg-error' => 'Feil ved køyring av GPG.
Bruk $wgSecurePollShowErrorDetail=true; i LocalSettings.php for å sjå fleire detaljar.',
	'securepoll-full-gpg-error' => 'Feil ved køyring av GPG:

Kommando: $1

Feil:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-nøklane er ikkje sette opp rett.',
	'securepoll-gpg-parse-error' => 'Feil ved tolking av utdata frå GPG.',
	'securepoll-no-decryption-key' => 'Ingen dekrypteringsnøkkel er sett opp.
Kan ikkje dekryptera.',
	'securepoll-jump' => 'Gå til stemmetenaren',
	'securepoll-bad-ballot-submission' => 'Di stemme var ugyldig: $1',
	'securepoll-unanswered-questions' => 'Du må svara på alle spørsmåla.',
	'securepoll-invalid-rank' => 'Ugyldig rangering. Du må gje kandidatane ei rangering mellom 1 og 999.',
	'securepoll-remote-auth-error' => 'Feil oppstod ved henting av kontoinformasjonen din frå filtenaren.',
	'securepoll-remote-parse-error' => 'Feil oppsto i samband med tolking av autorisasjonssvar frå tenaren',
	'securepoll-api-invalid-params' => 'Ugyldige parametrar.',
	'securepoll-api-no-user' => 'Ingen brukar var funnen med oppgjeven ID.',
	'securepoll-not-logged-in' => 'Du må vera innlogga for å kunna røysta i dette valet',
	'securepoll-too-few-edits' => 'Orsak, du kan ikkje røysta. Du lyt ha gjort minst {{PLURAL:$1|éi endring|$1 endringar}} for å kunna røysta ved dette valet. Du har gjort {{PLURAL:$2|éi|$2}}.',
	'securepoll-blocked' => 'Du kan diverre ikkje røysta i dette valet om du for tida er blokkert frå å gjera endringar',
	'securepoll-not-in-group' => 'Berre brukarar som er med i gruppa $1 kan røysta i denne avrøystinga.',
	'securepoll-not-in-list' => 'Du er diverre ikkje på lista over brukarar som har løyve til å røysta i denne avrøystinga.',
	'securepoll-list-title' => 'Vis stemmer: $1',
	'securepoll-header-timestamp' => 'Tid',
	'securepoll-header-voter-name' => 'Namn',
	'securepoll-header-voter-domain' => 'Domene',
	'securepoll-header-ua' => 'Brukaragent',
	'securepoll-header-cookie-dup' => 'Dublett',
	'securepoll-header-strike' => 'Stryk',
	'securepoll-header-details' => 'Opplysingar',
	'securepoll-strike-button' => 'Fjern',
	'securepoll-unstrike-button' => 'Opphev strykinga',
	'securepoll-strike-reason' => 'Grunngjeving:',
	'securepoll-strike-cancel' => 'Avbryt',
	'securepoll-strike-error' => 'Feil ved fjerning eller ved oppheving av fjerning: $1',
	'securepoll-details-link' => 'Detaljar',
	'securepoll-details-title' => 'Stemmedetaljar: #$1',
	'securepoll-invalid-vote' => '«$1» er ikkje ein gyldig røyst-ID',
	'securepoll-header-voter-type' => 'Stemmegjevartype',
	'securepoll-voter-properties' => 'Eigenskapar for røystaren',
	'securepoll-strike-log' => 'Strykingslogg',
	'securepoll-header-action' => 'Handling',
	'securepoll-header-reason' => 'Grunn',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => 'Cookie duplikatbrukar',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Inga kryptert valregistrering er tilgjengeleg for dette valet, på grunn av at valet ikkje er sett opp til å nytta kryptering.',
	'securepoll-dump-not-finished' => 'Krypterte valregister er berre tilgjengelege etter avsluttinga den $1 klokka $2',
	'securepoll-translate-title' => 'Set om: $1',
	'securepoll-invalid-language' => 'Ugyldig språkode "$1"',
	'securepoll-submit-translate' => 'Oppdater',
	'securepoll-language-label' => 'Vél språk',
	'securepoll-submit-select-lang' => 'Set om',
	'securepoll-header-title' => 'Namn',
	'securepoll-header-start-date' => 'Start dato',
	'securepoll-header-end-date' => 'Sluttdato',
	'securepoll-subpage-vote' => 'Stem',
	'securepoll-subpage-translate' => 'Set om',
	'securepoll-subpage-list' => 'Utslisting',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Oppteljing',
	'securepoll-tally-title' => 'Oppteljing: $1',
	'securepoll-tally-not-finished' => 'Diverre, du kan ikkje telja opp valresultatet før valet er fullført.',
	'securepoll-can-decrypt' => 'Valregisteret har vorte kryptert, men dekrypteringsnøkkelen er tilgjengeleg.
Du kan velja å anten telja opp resultata tilgjengelege i databasen, eller å telja opp dei krypterte resultata frå ei opplasta fil.',
	'securepoll-tally-no-key' => 'Du kan ikkje telja opp dette valet fordi stemmene er krypterte og dekrypteringsnøkkelen er utilgjengeleg.',
	'securepoll-tally-local-submit' => 'Opprett ei oppteljing',
	'securepoll-tally-upload-submit' => 'Opprett ei oppteljing',
	'securepoll-no-upload' => 'Ingen fil vart lasta opp, kan ikkje summera resultata.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Finnrind
 * @author Guaca
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 * @author Stigmj
 */
$messages['no'] = array(
	'securepoll' => 'SikkertValg',
	'securepoll-desc' => 'En utvidelse for valg og undersøkelser',
	'securepoll-invalid-page' => 'Ugyldig underside «<nowiki>$1</nowiki>»',
	'securepoll-need-admin' => 'Du må være valgadministrator for å kunne utføre dette.',
	'securepoll-too-few-params' => 'Ikke mange nok undersideparametre (ugyldig lenke).',
	'securepoll-invalid-election' => '"$1" er ikke en gyldig valg-id.',
	'securepoll-welcome' => '<strong>Velkommen $1!</strong>',
	'securepoll-not-started' => 'Dette valget har enda ikke startet.
Det starter etter planen $2 kl. $3.',
	'securepoll-finished' => 'Dette valget er avsluttet, du kan ikke lenger stemme.',
	'securepoll-not-qualified' => 'Du er ikke kvalifisert til å stemme i dette valget: $1',
	'securepoll-change-disallowed' => 'Du har allerede stemt i dette valget.
Du kan desverre ikke stemme på nytt.',
	'securepoll-change-allowed' => '<strong>Bemerk: Du har allerede stemt i dette valget.</strong>
Du kan endre stemmen din ved å sende inn skjemaet nedenfor.
Bemerk at dersom du gjør dette vil den opprinnelige stemmen din bli forkastet.',
	'securepoll-submit' => 'Avgi stemme',
	'securepoll-gpg-receipt' => 'Takk for at du avga stemme.

Dersom du ønsker det kan du ta vare på følgende kvittering som bevis på din stemme:

<pre>$1</pre>',
	'securepoll-thanks' => 'Takk, stemmen din har blitt registrert.',
	'securepoll-return' => 'Tilbake til $1',
	'securepoll-encrypt-error' => 'Klarte ikke å kryptere din stemme.
Stemmen har ikke blitt registrert!

$1',
	'securepoll-no-gpg-home' => 'Kunne ikke opprette hjemmekatalog for GPG',
	'securepoll-secret-gpg-error' => 'Feil ved kjøring av GPG.
bruk $wgSecurePollShowErrorDetail=true; i LocalSettings.php for å se flere detaljer.',
	'securepoll-full-gpg-error' => 'Feil under kjøring av GPG:

Kommando: $1

Feil:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-nøklene er ikke satt opp riktig.',
	'securepoll-gpg-parse-error' => 'Feil under tolking av utdata fra GPG.',
	'securepoll-no-decryption-key' => 'Ingen dekrypteringsnøkkel er konfigurert.
Kan ikke dekryptere.',
	'securepoll-jump' => 'Gå til stemmetjeneren',
	'securepoll-bad-ballot-submission' => 'Din stemme var ugyldig: $1',
	'securepoll-unanswered-questions' => 'Du må besvare alle spørsmålene.',
	'securepoll-invalid-rank' => 'Ugyldig rangering. Du må gi kandidatene en rangering mellom 1 og 999.',
	'securepoll-unranked-options' => 'Noen valg var urangerte.
Du må gi alle alternativene en rangering mellom 1 og 999.',
	'securepoll-invalid-score' => 'Karakteren må være et tall mellom $1 og $2.',
	'securepoll-unanswered-options' => 'Du må gi et svar på hver spørsmål.',
	'securepoll-remote-auth-error' => 'Feil oppsto ved henting av din kontoinformasjon fra tjeneren.',
	'securepoll-remote-parse-error' => 'Feil oppsto ved tolkning av autorisasjonssvar fra tjeneren.',
	'securepoll-api-invalid-params' => 'Ugyldige parametere.',
	'securepoll-api-no-user' => 'Det ble ikke funnet noen bruker med den oppgitte IDen.',
	'securepoll-api-token-mismatch' => 'Sikkerhetsnøkkel manglet, kan ikke logge inn.',
	'securepoll-not-logged-in' => 'Du må logge inn for å kunne stemme i dette valget.',
	'securepoll-too-few-edits' => 'Beklager, du kan ikke stemme. Du må ha gjort minst $1 {{PLURAL:$1|redigering|redigeringer}} for å delta i denne avstemningen. Du har gjort $2.',
	'securepoll-blocked' => 'Beklager, du kan ikke stemme i dette valget hvis du er blokkert fra å redigere.',
	'securepoll-bot' => 'Beklager, kontoer med botflagg kan ikke stemme i dette valget.',
	'securepoll-not-in-group' => 'Kun brukere i gruppen «$1» kan delta i denne avstemningen.',
	'securepoll-not-in-list' => 'Du er desverre ikke i lista over brukere som kan stemme i dette valget.',
	'securepoll-list-title' => 'Vis stemmer: $1',
	'securepoll-header-timestamp' => 'Tid',
	'securepoll-header-voter-name' => 'Navn',
	'securepoll-header-voter-domain' => 'Domene',
	'securepoll-header-ua' => 'Brukeragent',
	'securepoll-header-cookie-dup' => 'Dupl',
	'securepoll-header-strike' => 'Stryk',
	'securepoll-header-details' => 'Detaljer',
	'securepoll-strike-button' => 'Stryk',
	'securepoll-unstrike-button' => 'Opphev strykning',
	'securepoll-strike-reason' => 'Årsak:',
	'securepoll-strike-cancel' => 'Avbryt',
	'securepoll-strike-error' => 'Feil ved fjerning eller ved opphevelse av fjerning: $1',
	'securepoll-strike-token-mismatch' => 'Sesjonsdata tapt',
	'securepoll-details-link' => 'Detaljer',
	'securepoll-details-title' => 'Stemmedetaljer: #$1',
	'securepoll-invalid-vote' => '«$1» er ikke en gyldig stemme-ID',
	'securepoll-header-voter-type' => 'Stemmegivertype',
	'securepoll-voter-properties' => 'Stemmegiveregenskaper',
	'securepoll-strike-log' => 'Strykningslogg',
	'securepoll-header-action' => 'Handling',
	'securepoll-header-reason' => 'Årsak',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Cookie duplikatbruker',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Ingen kryptert valgregistrering er tilgjengelig for dette valget, på grunn av at valget ikke er satt opp til å benytte kryptering.',
	'securepoll-dump-not-finished' => 'Krypterte valgregistre er kun tilgjengelige etter avsluttningen den $1 klokken $2',
	'securepoll-dump-no-urandom' => 'Kan ikke åpne /dev/urandom.
For å sikre en hemmelig avstemning er de krypterte valgregistrene kun offentlig tilgjengelig når de kan blandes med en sikker strøm av tilfeldige tall.',
	'securepoll-urandom-not-supported' => 'Denne tjeneren støtter ikke kryptografisk generering av tilfeldige tall.
For å opprettholde velgernes anonymitet vil de enkelte stemmene kun offentliggjøres når de kan anonymiseres med en generator for tilfeldige tall.',
	'securepoll-translate-title' => 'Oversett: $1',
	'securepoll-invalid-language' => 'Ugyldig språkkode «$1»',
	'securepoll-submit-translate' => 'Oppdater',
	'securepoll-language-label' => 'Velg språk:',
	'securepoll-submit-select-lang' => 'Oversett',
	'securepoll-entry-text' => 'Under er listen over avstemninger',
	'securepoll-header-title' => 'Navn',
	'securepoll-header-start-date' => 'Startdato',
	'securepoll-header-end-date' => 'Sluttdato',
	'securepoll-subpage-vote' => 'Stemme',
	'securepoll-subpage-translate' => 'Oversett',
	'securepoll-subpage-list' => 'List opp',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Opptelling',
	'securepoll-tally-title' => 'Opptelling: $1',
	'securepoll-tally-not-finished' => 'Beklager, du kan ikke telle opp valgresultatet før valget er fullført.',
	'securepoll-can-decrypt' => 'Valgregisteret har blitt kryptert, men dekrypteringsnøkkelen er tilgjengelig.
Du kan velge å enten telle opp resultatene tilgjengelig i databasen, eller å telle opp de krypterte resultatene fra en opplastet fil.',
	'securepoll-tally-no-key' => 'Du kan ikke telle opp dette valget fordi stemmene er kryptert og dekrypteringsnøkkelen er utilgjengelig.',
	'securepoll-tally-local-legend' => 'Opptelling lagret resultatene',
	'securepoll-tally-local-submit' => 'Opprett en opptelling',
	'securepoll-tally-upload-legend' => 'Last opp en kryptert dump',
	'securepoll-tally-upload-submit' => 'Opprett en opptelling',
	'securepoll-tally-error' => 'Feil ved tolking av stemmeregisteret, kan ikke opprette en opptelling.',
	'securepoll-no-upload' => 'Ingen fil ble lastet opp, kan ikke summere opp resultatene.',
	'securepoll-dump-corrupt' => 'Dumpfila er ødelagt og kan ikke behandles.',
	'securepoll-tally-upload-error' => 'Feil ved opptelling av dumpfila: $1',
	'securepoll-pairwise-victories' => 'Matrise over parvis seier',
	'securepoll-strength-matrix' => 'Matrise over stistyrke',
	'securepoll-ranks' => 'Endelig resultat',
	'securepoll-average-score' => 'Gjennomsnittlig karakter',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'securepoll' => 'Sondatge securizat',
	'securepoll-desc' => "Extension per d'eleccions e de sondatges",
	'securepoll-invalid-page' => 'Sospagina « <nowiki>$1</nowiki> » invalida',
	'securepoll-need-admin' => "Vos cal èsser un administrator de l'eleccion per executar aquesta accion.",
	'securepoll-too-few-params' => 'Pas pro de paramètres de sospagina (ligam invalid).',
	'securepoll-invalid-election' => "« $1 » es pas un identificant d'eleccion valid.",
	'securepoll-welcome' => '<strong>Benvenguda $1 !</strong>',
	'securepoll-not-started' => "L'eleccion a pas encara començat.
Lo començament es programat pel $2 a $3.",
	'securepoll-finished' => 'Aquesta eleccion es acabada, Podètz pas pus votar.',
	'securepoll-not-qualified' => 'Sètz pas qualificat(ada) per votar dins aquesta eleccion : $1',
	'securepoll-change-disallowed' => 'Ja avètz votat per aquesta eleccion.
O planhèm, podètz pas votar tornamai.',
	'securepoll-change-allowed' => '<strong>Nòta : Ja avètz votat per aquesta eleccion.</strong>
Podètz cambiar vòstre vòte en sometent lo formulari çaijós.
Se fasètz aquò, vòstre vòte ancian serà anullat.',
	'securepoll-submit' => 'Sometre lo vòte',
	'securepoll-gpg-receipt' => "Mercés per vòstre vòte.

S'o desiratz, podètz gardar aquò coma pròva de vòstre vòte :

<pre>$1</pre>",
	'securepoll-thanks' => 'Mercés, vòstre vòte es estat enregistrat.',
	'securepoll-return' => 'Tornar a $1',
	'securepoll-encrypt-error' => 'Lo criptatge de vòstre vòte a fracassat.
Vòstre vòte es pas estat enregistrat !

$1',
	'securepoll-no-gpg-home' => 'Impossible de crear lo dorsièr de basa de GPG.',
	'securepoll-secret-gpg-error' => 'Error al moment de l\'execucion de GPG.
Apondètz $wgSecurePollShowErrorDetail=true; a LocalSettings.php per afichar mai de detalhs.',
	'securepoll-full-gpg-error' => "Error al moment de l'execucion de GPG :

Comanda : $1

Error :
<pre>$2</pre>",
	'securepoll-gpg-config-error' => 'Las claus de GPG son pas configuradas corrèctament.',
	'securepoll-gpg-parse-error' => "Error al moment de l'interpretacion de la sortida de GPG.",
	'securepoll-no-decryption-key' => 'Cap de clau de descriptatge es pas estada configurada.
Impossible de descriptar.',
	'securepoll-jump' => 'Anar al servidor de vòte',
	'securepoll-bad-ballot-submission' => 'Vòstre vòte es invalid : $1',
	'securepoll-unanswered-questions' => 'Vos cal respondre a totas las questions.',
	'securepoll-invalid-rank' => 'Reng invalid. Vos cal balhar als candidats un reng entre 1 e 999.',
	'securepoll-unranked-options' => "D'unas opcions an pas recebut de reng.
Vos cal balhar un reng entre 1 e 999 a totas las opcions.",
	'securepoll-invalid-score' => 'La marca deu èsser un nombre comprés entre $1 e $2.',
	'securepoll-unanswered-options' => 'Vos cal balhar una responsa per totas las questions.',
	'securepoll-remote-auth-error' => 'Error al moment de la recuperacion de las informacions de vòstre compte dempuèi lo servidor.',
	'securepoll-remote-parse-error' => 'Error al moment de l’interpretacion de la responsa d’autorizacion del servidor.',
	'securepoll-api-invalid-params' => 'Paramètres invalids.',
	'securepoll-api-no-user' => "Cap d'utilizaire amb l’identificant balhat es pas estat trobat.",
	'securepoll-api-token-mismatch' => 'Geton de seguretat diferent, connexion impossibla.',
	'securepoll-not-logged-in' => 'Vos cal vos connectar per votar dins aquesta eleccion.',
	'securepoll-too-few-edits' => 'O planhèm, podètz pas votar. Vos cal aver efectuat al mens {{PLURAL:$1|una modificacion|$1 modificacions}} per votar dins aquesta eleccion, ne totalizatz $2.',
	'securepoll-blocked' => 'O planhèm, podètz pas votar dins aquesta eleccion perque sètz blocat(ada) en escritura.',
	'securepoll-bot' => "O planhèm, los comptes amb l'estatut de robòt son pas autorizats a votar a aquesta eleccion.",
	'securepoll-not-in-group' => 'Sonque los membres del grop « $1 » pòdon votar dins aquesta eleccion.',
	'securepoll-not-in-list' => 'O planhèm, sètz pas sus la lista predeterminada dels utilizaires autorizats a votar dins aquesta eleccion.',
	'securepoll-list-title' => 'Lista dels vòtes : $1',
	'securepoll-header-timestamp' => 'Ora',
	'securepoll-header-voter-name' => 'Nom',
	'securepoll-header-voter-domain' => 'Domeni',
	'securepoll-header-ua' => "Agent d'utilizaire",
	'securepoll-header-cookie-dup' => 'Duplicata',
	'securepoll-header-strike' => 'Raiar',
	'securepoll-header-details' => 'Detalhs',
	'securepoll-strike-button' => 'Raiar',
	'securepoll-unstrike-button' => 'Desraiar',
	'securepoll-strike-reason' => 'Rason :',
	'securepoll-strike-cancel' => 'Anullar',
	'securepoll-strike-error' => 'Error al moment del (des)raiatge : $1',
	'securepoll-strike-token-mismatch' => 'Pèrta de donadas de sesilha',
	'securepoll-details-link' => 'Detalhs',
	'securepoll-details-title' => 'Detalhs del vòte : #$1',
	'securepoll-invalid-vote' => '« $1 » es pas un ID de vòte valid',
	'securepoll-header-voter-type' => "Tipe de l'utilizaire",
	'securepoll-voter-properties' => 'Proprietats del votant',
	'securepoll-strike-log' => 'Jornal dels raiatges',
	'securepoll-header-action' => 'Accion',
	'securepoll-header-reason' => 'Rason',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => "Utilizaires qu'an un cookie ja rencontrat",
	'securepoll-dump-title' => 'Extrach : $1',
	'securepoll-dump-no-crypt' => 'Las donadas chifradas son pas disponiblas per aquesta eleccion, perque l’eleccion es pas configurada per utilizar un chiframent.',
	'securepoll-dump-not-finished' => "Las donadas criptadas son disponiblas solament aprèp la clausura de l'eleccion lo $1 a $2",
	'securepoll-dump-no-urandom' => 'Impossible de dobrir /dev/urandom.
Per manténer la confidencialitat dels votants, las donadas criptadas son disponiblas sonque se pòdon èsser reboladas amb un nombre de caractèrs aleatòris.',
	'securepoll-urandom-not-supported' => 'Aqueste servidor supòrta pas la generacion criptografica aleatòri de nombres.
Per assegurar la confidencialitat dels votants, las donadas criptadas son publicadas unicament quand pòdon trebolar un flus aleatòri de nombres.',
	'securepoll-translate-title' => 'Traduire : $1',
	'securepoll-invalid-language' => 'Còde de lenga « $1 » invalid.',
	'securepoll-submit-translate' => 'Metre a jorn',
	'securepoll-language-label' => 'Seleccionar la lenga :',
	'securepoll-submit-select-lang' => 'Traduire',
	'securepoll-entry-text' => 'Çaijós la lista dels sondatges.',
	'securepoll-header-title' => 'Nom',
	'securepoll-header-start-date' => 'Data de començament',
	'securepoll-header-end-date' => 'Data de fin',
	'securepoll-subpage-vote' => 'Vòte',
	'securepoll-subpage-translate' => 'Traduire',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Comptatge',
	'securepoll-tally-title' => 'Comptatge : $1',
	'securepoll-tally-not-finished' => "O planhèm, podètz pas comptar los resultats de l'eleccion abans que siá acabada.",
	'securepoll-can-decrypt' => "L'enregistrament de l'eleccion es estat criptat, mas la clau de descriptatge es disponibla.
Podètz causir de comptar los resultats dempuèi la banca de donadas o dempuèi un fichièr telecargat.",
	'securepoll-tally-no-key' => "Podètz pas far lo descompte dels resultats d'aquesta eleccion perque los vòtes son criptats e que la clau de descriptatge es pas disponibla.",
	'securepoll-tally-local-legend' => 'Comptar los resultats salvats',
	'securepoll-tally-local-submit' => 'Crear un comptatge',
	'securepoll-tally-upload-legend' => 'Telecargar un salvament criptat',
	'securepoll-tally-upload-submit' => 'Crear un comptatge',
	'securepoll-tally-error' => "Error al moment de l'interpretacion dels enregistaments de vòte, impossible de produire un resultat.",
	'securepoll-no-upload' => 'Cap de fichièr es pas estat telecargat, impossible de comptar los resultats.',
	'securepoll-dump-corrupt' => 'Lo fichièr de salvament es corromput e pòt pas èsser utilizat.',
	'securepoll-tally-upload-error' => 'Error al moment del decargament del fichièr de salvament : $1',
	'securepoll-pairwise-victories' => 'Matritz de las victòrias per par',
	'securepoll-strength-matrix' => 'Matritz de fòrça dels camins',
	'securepoll-ranks' => 'Classament final',
	'securepoll-average-score' => 'Marca mejana',
);

/** Papiamento (Papiamentu)
 * @author Sdm1985
 */
$messages['pap'] = array(
	'securepoll' => 'Enkuesta protehá',
	'securepoll-desc' => 'Ekstenshonnan pa elekshon i enkuestanan',
	'securepoll-invalid-page' => 'E pagina no ta balido "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Bo mester ta un administradó pa por skohe e akshon aki.',
	'securepoll-too-few-params' => 'No tin sufisiente parámetro (e lenk no ta balido)',
	'securepoll-invalid-election' => '"$1" no ta un ID di eskoho balido.',
	'securepoll-welcome' => '<strong>Bon Bini $1!</strong>',
	'securepoll-not-started' => 'E elekshon aki no a kuminsá ainda.
E ta programá pa kuminsá $3 dia $2',
	'securepoll-finished' => ' E elekshon aki kaba, bo no por vota mas.',
	'securepoll-not-qualified' => 'Bo no por vota den e elekshon aki: $1',
	'securepoll-change-disallowed' => 'Bo a vota den e elekshon aki kaba.
Despensa, pero no ta posibel pa vota atrobe.',
	'securepoll-change-allowed' => '<strong>Nota: Bo a vota den e elekshon aki kaba.</strong>
Bo por kambia e voto ku bo a manda usando e formulario akibou.
Si bo hasi esaki bo voto original lo no koknta mas.',
	'securepoll-submit' => 'Manda bo voto',
	'securepoll-gpg-receipt' => 'Danki pa bo voto.

Si bo ta deseá esei, bo por keda ku e resibu aki ku ta verifiká ku bo a vota:

<pre>$1</pre>',
	'securepoll-thanks' => 'Danki, bo voto a wòrdu prosesá.',
	'securepoll-return' => 'Bolbe bèk na $1',
	'securepoll-encrypt-error' => 'No por a encrypt bo voto.
Bo voto no a wòrdu prosesá!

$1',
	'securepoll-no-gpg-home' => 'No por a krea e direktorio di GPG home.',
	'securepoll-secret-gpg-error' => 'Tabatin un eror na momentu di ehekuta GPG.
Usa $wgSecurePollShowErrorDetail=true; den LocalSettings.php pa haña mas detaye.',
	'securepoll-full-gpg-error' => 'Eror den ehekushon di GPG:

command: $1

Eror:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'E konfigurashon di e klavenan di GPG no ta korekto.',
	'securepoll-gpg-parse-error' => 'Tabatin un eror na ora di interpretá e output di GPG.',
	'securepoll-no-decryption-key' => 'No tin un klave deskriptivó konfigurá.
No por decrypt.',
	'securepoll-jump' => 'Bai na e server di votashon',
	'securepoll-bad-ballot-submission' => 'Bo voto no ta balido: $1',
	'securepoll-unanswered-questions' => 'Bo mester kontestá tur e preguntanan.',
	'securepoll-remote-auth-error' => 'Tabatin problema na ora di buska informashonnan tokante di bo kuenta riba e server.',
	'securepoll-remote-parse-error' => 'Tabatin problema na ora di interpretá e derechinan for di riba e server.',
	'securepoll-api-invalid-params' => 'Parámetronan no ta balido',
	'securepoll-api-no-user' => 'Nos no por a haña un usuario bo di e ID aki.',
	'securepoll-api-token-mismatch' => 'Tabating un problema di seguridad, no por hasi e log in.',
	'securepoll-not-logged-in' => 'Bo mester hasi e log in pa vota den e elekshon aki',
	'securepoll-too-few-edits' => 'Despensa, pero bo no por vota. Bo mester a hasi por lo menos $1 {{PLURAL:$1|kambio|kambionan}} pa vota den e elekshon aki, abo a hasi $2.',
	'securepoll-blocked' => 'Despensa, pero bo no por vota den e elekshon aki si bo derechi pa hasi kambionan ta blòkia.',
	'securepoll-bot' => 'Despensa, kuentanan ku marká ku e `bot flag´ no por vota den e elekshon aki.',
	'securepoll-not-in-group' => 'Solamente miembronan di e grupo "$1" por vota den e elekshon aki.',
	'securepoll-not-in-list' => 'Despensa, pero abo no ta den e lista di usuarionan ku ta outorisá pa vota den e elekshon aki.',
	'securepoll-list-title' => 'Lista di votonan: $1',
	'securepoll-header-timestamp' => 'Tempu',
	'securepoll-header-voter-name' => 'Nòmber',
	'securepoll-header-voter-domain' => 'Dominio/Domain',
	'securepoll-header-ua' => 'Usuario',
	'securepoll-header-cookie-dup' => 'Dupliká',
	'securepoll-header-strike' => 'Pone',
	'securepoll-header-details' => 'Detaye',
	'securepoll-strike-button' => 'Pone',
	'securepoll-unstrike-button' => 'Kita',
	'securepoll-strike-reason' => 'Motibu:',
	'securepoll-strike-cancel' => 'Kanselá',
	'securepoll-strike-error' => 'Eror na momentu di pone/kita: $1',
	'securepoll-details-link' => 'Detaye',
	'securepoll-details-title' => 'Detayenan di voto: #$1',
	'securepoll-invalid-vote' => '"$1" no ta un ID di voto balido',
	'securepoll-header-voter-type' => 'Tipo di votadó',
	'securepoll-voter-properties' => 'Propiedatnan di votadó',
	'securepoll-strike-log' => 'Resumen di kuantu biaha algu a wòrdu poní',
	'securepoll-header-action' => 'Akshon',
	'securepoll-header-reason' => 'Motibu',
	'securepoll-header-admin' => 'Administrashon',
	'securepoll-cookie-dup-list' => 'Kantidat di usuarionan ku a bai vota un di dos biaha',
	'securepoll-dump-title' => 'Laga numa: $1',
	'securepoll-dump-no-crypt' => 'No tin ningun encryption stipulá pa e elekshon aki, pasobra e elekshon aki no ta konfigurá pa husa encryptions.',
	'securepoll-dump-not-finished' => 'Resultadonan encrypt di elekshon no ta aksesibel promé ku e fecha di klousura ku ta $2 riba $1',
	'securepoll-dump-no-urandom' => 'No por habri /dev/urandom.
Pa mantené e privasidat di kada votadó, elekshonnan encrypt por wòrdu mirá dor di publiko solamente ora ku nan por wòrdu di shòbel dor di otro ku un stream di numbernan bruá dor di otro.',
	'securepoll-translate-title' => 'Tradusí: $1',
	'securepoll-invalid-language' => 'E kodigo di idioma no ta balido "$1"',
	'securepoll-submit-translate' => 'Aktualisá',
	'securepoll-language-label' => 'Skohe un idioma:',
	'securepoll-submit-select-lang' => 'Tradusí',
	'securepoll-header-title' => 'Nòmber',
	'securepoll-header-start-date' => 'Fecha di kuminsamentu',
	'securepoll-header-end-date' => 'Fecha ku e ta terminá',
	'securepoll-subpage-vote' => 'Voto',
	'securepoll-subpage-translate' => 'Tradusí',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Laga numa',
	'securepoll-subpage-tally' => 'Konteo',
	'securepoll-tally-title' => 'Konteo: $1',
	'securepoll-tally-not-finished' => 'Despensa, pero bo no por krea e konteo di e votonan promé ku e elekshon sera.',
	'securepoll-can-decrypt' => 'E elekshon a wòrdu encrypt, pero e klave di deskripshon ta disponibel.
Bo por skohe pa sea konta e resultadonan di e votona ya risibí òf konta e resultadonan encrypy di un file ku bo por load.',
	'securepoll-tally-no-key' => 'Bo no por hasi e konteo di e elekshon aki, pasobra e votonan ta encrypt i e klave deskriptivo no ta disponibel.',
	'securepoll-tally-local-legend' => 'Konta e resultadonan di votonan warda',
	'securepoll-tally-local-submit' => 'Krea konteo',
	'securepoll-tally-upload-legend' => 'Trese dumpnan encrypted',
	'securepoll-tally-upload-submit' => 'Krea konteo',
	'securepoll-tally-error' => 'Tabatin un eror  den e interpretashon di e votonan wardá, no por krea un konteo.',
	'securepoll-no-upload' => 'Ningun dokumento no a wòrdu di load, no por kalkulá resultadonan.',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'securepoll-welcome' => '<strong>Willkum $1!</strong>',
	'securepoll-return' => 'Zerick zu $1',
	'securepoll-jump' => 'Geh zum Waddefresser fer die Leckschen',
	'securepoll-header-timestamp' => 'Zeit',
	'securepoll-header-voter-name' => 'Naame',
	'securepoll-strike-reason' => 'Grund:',
	'securepoll-header-reason' => 'Grund',
	'securepoll-header-admin' => 'Verwalter',
	'securepoll-translate-title' => 'Iwwersetze: $1',
	'securepoll-submit-select-lang' => 'Iwwersetze',
	'securepoll-header-title' => 'Naame',
	'securepoll-header-start-date' => 'Beginn',
	'securepoll-header-end-date' => 'End',
	'securepoll-subpage-translate' => 'Iwwersetze',
	'securepoll-subpage-list' => 'Lischt',
);

/** Polish (Polski)
 * @author Leinad
 * @author Saper
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'securepoll' => 'Bezpieczne głosowanie',
	'securepoll-desc' => 'Rozszerzenie do realizacji wyborów oraz sondaży',
	'securepoll-invalid-page' => 'Nieprawidłowa podstrona „<nowiki>$1</nowiki>”',
	'securepoll-need-admin' => 'Musisz być administratorem wyborów, aby wykonać tę operację.',
	'securepoll-too-few-params' => 'Niewystarczające parametry podstrony (nieprawidłowy link).',
	'securepoll-invalid-election' => '„$1” nie jest prawidłowym identyfikatorem głosowania.',
	'securepoll-welcome' => '<strong>Witamy Cię $1!</strong>',
	'securepoll-not-started' => 'Wybory jeszcze się nie rozpoczęły.
Planowane rozpoczęcie $2 o $3.',
	'securepoll-finished' => 'Te wybory są zakończone, nie można zagłosować.',
	'securepoll-not-qualified' => 'Nie jesteś upoważniony do głosowania w wyborach $1',
	'securepoll-change-disallowed' => 'W tych wyborach już głosowałeś.
Nie możesz ponownie zagłosować.',
	'securepoll-change-allowed' => '<strong>Uwaga – głosowałeś już w tych wyborach.</strong>
Możesz zmienić swój głos poprzez zapisanie poniższego formularza.
Jeśli to zrobisz, Twój poprzedni głos zostanie anulowany.',
	'securepoll-submit' => 'Zapisz głos',
	'securepoll-gpg-receipt' => 'Dziękujemy za oddanie głosu.

Jeśli chcesz, możesz zachować poniższe pokwitowanie jako dowód.

<pre>$1</pre>',
	'securepoll-thanks' => 'Twój głos został zarejestrowany.',
	'securepoll-return' => 'Wróć do $1',
	'securepoll-encrypt-error' => 'Nie można zaszyfrować rekordu głosowania.
Twój głos nie został zarejestrowany! 

$1',
	'securepoll-no-gpg-home' => 'Nie można utworzyć katalogu domowego GPG.',
	'securepoll-secret-gpg-error' => 'Błąd podczas uruchamiania GPG.
Ustaw $wgSecurePollShowErrorDetail=true; w LocalSettings.php aby zobaczyć szczegóły.',
	'securepoll-full-gpg-error' => 'Błąd podczas uruchamiania GPG:

Polecenie – $1

Błąd:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Klucze GPG zostały nieprawidłowo skonfigurowane.',
	'securepoll-gpg-parse-error' => 'Błąd interpretacji wyników GPG.',
	'securepoll-no-decryption-key' => 'Klucz odszyfrowujący nie został skonfigurowany.
Odszyfrowanie nie jest możliwe.',
	'securepoll-jump' => 'Przejdź do serwera obsługującego głosowanie',
	'securepoll-bad-ballot-submission' => 'Twój głos był nieważny – $1',
	'securepoll-unanswered-questions' => 'Musisz odpowiedzieć na wszystkie pytania.',
	'securepoll-invalid-rank' => 'Błąd w rankingu kandydatów. Musisz przypisać kandydatom rangę z przedziału od 1 do 999.',
	'securepoll-unranked-options' => 'Niektóre pola nie otrzymały rangi.
Każde pole musi mieć przypisaną rangę z przedziału od 1 do 999.',
	'securepoll-invalid-score' => 'Ocena musi być liczbą pomiędzy $1 a $2.',
	'securepoll-unanswered-options' => 'Musisz udzielić odpowiedzi na każde z pytań.',
	'securepoll-remote-auth-error' => 'Wystąpił błąd podczas pobierania informacji z serwera o Twoim koncie.',
	'securepoll-remote-parse-error' => 'Wystąpił błąd interpretacji odpowiedzi autoryzującej z serwera.',
	'securepoll-api-invalid-params' => 'Nieprawidłowe parametry.',
	'securepoll-api-no-user' => 'Nie znaleziono użytkownika o podanym ID.',
	'securepoll-api-token-mismatch' => 'Nieprawidłowy żeton bezpieczeństwa, nie można się zalogować.',
	'securepoll-not-logged-in' => 'Musisz się zalogować, aby głosować w tych wyborach',
	'securepoll-too-few-edits' => 'Niestety, nie możesz głosować. Musisz mieć przynajmniej $1 {{PLURAL:$1|edycję|edycje|edycji}} aby głosować w tych wyborach, wykonane $2.',
	'securepoll-blocked' => 'Niestety, nie możesz głosować w tych wyborach, ponieważ masz zablokowaną możliwość edytowania.',
	'securepoll-bot' => 'Niestety, użytkownicy z flagą bota nie mogą głosować w tych wyborach.',
	'securepoll-not-in-group' => 'Tylko członkowie grupy $1 mogą głosować w tych wyborach.',
	'securepoll-not-in-list' => 'Niestety nie ma Cię na wstępnie przygotowanej liście użytkowników uprawnionych do głosowania w tych wyborach.',
	'securepoll-list-title' => 'Lista głosów – $1',
	'securepoll-header-timestamp' => 'Czas',
	'securepoll-header-voter-name' => 'Nazwa',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Aplikacja klienta',
	'securepoll-header-cookie-dup' => 'Podwójny',
	'securepoll-header-strike' => 'Skreślony',
	'securepoll-header-details' => 'Szczegóły',
	'securepoll-strike-button' => 'Skreśl',
	'securepoll-unstrike-button' => 'Usuń skreślenie',
	'securepoll-strike-reason' => 'Powód',
	'securepoll-strike-cancel' => 'Zrezygnuj',
	'securepoll-strike-error' => 'Błąd podczas skreślania lub usuwania skreślenia – $1',
	'securepoll-strike-token-mismatch' => 'Sesja użytkownika została utracona',
	'securepoll-details-link' => 'Szczegóły',
	'securepoll-details-title' => 'Szczegóły głosu nr $1',
	'securepoll-invalid-vote' => '„$1” nie jest poprawnym identyfikatorem głosu',
	'securepoll-header-voter-type' => 'Typ wyborcy',
	'securepoll-voter-properties' => 'Dane wyborcy',
	'securepoll-strike-log' => 'Rejestr skreślania',
	'securepoll-header-action' => 'Czynność',
	'securepoll-header-reason' => 'Powód',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => 'Użytkownicy których ciasteczko świadczy o tym, że głosowali dwukrotnie',
	'securepoll-dump-title' => 'Zrzut $1',
	'securepoll-dump-no-crypt' => 'Brak zaszyfrowanego rekordu głosu w tych wyborach ponieważ wybory nie zostały skonfigurowane do wykorzystywania szyfrowania.',
	'securepoll-dump-not-finished' => 'Zaszyfrowane rekordy głosów dostępne będą dopiero po zakończeniu wyborów $1 o $2',
	'securepoll-dump-no-urandom' => 'Nie można otworzyć /dev/urandom. 
Dla zapewnienia wyborcom poufności, zaszyfrowane rekordy głosów są publicznie dostępne wyłącznie wymieszane z danymi losowymi.',
	'securepoll-urandom-not-supported' => 'Serwer nie umożliwia generowania liczb pseudolosowych spełniających wymagania kryptografii. 
Dla zapewnienia wyborcom poufności, zaszyfrowane rekordy głosów są publicznie dostępne wyłącznie wymieszane z danymi losowymi.',
	'securepoll-translate-title' => 'Tłumaczenie $1',
	'securepoll-invalid-language' => 'Nieprawidłowy kod języka „$1”',
	'securepoll-submit-translate' => 'Uaktualnij',
	'securepoll-language-label' => 'Wybierz język',
	'securepoll-submit-select-lang' => 'Przetłumacz',
	'securepoll-entry-text' => 'Poniżej znajduje się lista głosowań.',
	'securepoll-header-title' => 'Nazwa',
	'securepoll-header-start-date' => 'Data rozpoczęcia',
	'securepoll-header-end-date' => 'Data zakończenia',
	'securepoll-subpage-vote' => 'Głos',
	'securepoll-subpage-translate' => 'Tłumacz',
	'securepoll-subpage-list' => 'Wykaz',
	'securepoll-subpage-dump' => 'Zrzut',
	'securepoll-subpage-tally' => 'Rejestr',
	'securepoll-tally-title' => 'Rejestr $1',
	'securepoll-tally-not-finished' => 'Nie można podliczać głosów dopóki wybory trwają.',
	'securepoll-can-decrypt' => 'Rekord głosu został zaszyfrowany, ale klucz odszyfrowujący jest dostępny.
Można podliczyć wyniki obecne w bazie danych lub podliczyć wyniki z przesłanego zaszyfrowanego pliku.',
	'securepoll-tally-no-key' => 'Nie możesz podliczyć wyniku wyborów, ponieważ głosy są zaszyfrowane, a klucz odszyfrowujący jest niedostępny.',
	'securepoll-tally-local-legend' => 'Wyniki zapisane w rejestrze',
	'securepoll-tally-local-submit' => 'Utwórz rejestr',
	'securepoll-tally-upload-legend' => 'Prześlij zaszyfrowany zrzut',
	'securepoll-tally-upload-submit' => 'Utwórz rejestr',
	'securepoll-tally-error' => 'Błąd interpretacji rekordu głosu, nie można wykonać podliczenia.',
	'securepoll-no-upload' => 'Żaden plik nie został przesłany, nie można podliczyć głosów.',
	'securepoll-dump-corrupt' => 'Plik ze zrzutem danych jest uszkodzony i nie być przetworzony.',
	'securepoll-tally-upload-error' => 'Podczas podliczania pliku ze zrzutem danych wystąpił błąd: $1',
	'securepoll-pairwise-victories' => 'Wybór spośród pary kandydatów',
	'securepoll-strength-matrix' => 'Wybór poprzez ustawienie w kolejności',
	'securepoll-ranks' => 'Ranking końcowy',
	'securepoll-average-score' => 'Wynik średni',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Estension për elession e arserche',
	'securepoll-invalid-page' => 'Sotpàgina nen vàlida "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => "It deuve esse n'aministrador ëd l'elession për fé st'assion-sì",
	'securepoll-too-few-params' => 'Ij paràmetr ëd la sotpàgina a basto pa (anliura nen vàlida)',
	'securepoll-invalid-election' => '"$1" a l\'é pa n\'ID vàlid për l\'elession',
	'securepoll-welcome' => '<strong>Bin ëvnù $1!</strong>',
	'securepoll-not-started' => "St'elession-sì a l'é ancó pa partìa.
A l'é programà për parte ël $2 a $3.",
	'securepoll-finished' => "St'elession-sì a l'é finìa, it peule pa pì voté.",
	'securepoll-not-qualified' => "It ses pa qualifià për voté an st'elession-sì: $1",
	'securepoll-change-disallowed' => "It l'has già votà an st'elession-sì.
It peule pa torna voté.",
	'securepoll-change-allowed' => "<strong>Nòta: it l'has già votà an st'elession-sì.</strong>
It peule cambié tò vot an compiland la form sota.
Nòta che s'it faras sòn-sì, tò vot original a sarà scartà.",
	'securepoll-submit' => 'Spediss ël vot',
	'securepoll-gpg-receipt' => "Mersì për avèj votà.

S'it veule, it peule conservé l'arseivuda sota com evidensa ëd tò vot:

<pre>$1</pre>",
	'securepoll-thanks' => "Mersì, tò vot a l'é stàit registrà.",
	'securepoll-return' => 'Torna a $1',
	'securepoll-encrypt-error' => "Eror an cifrand le anformassion dël vot.
Tò vot a l'é pa stàit memorisà!

$1",
	'securepoll-no-gpg-home' => 'Ampossìbil creé la directory prinsipal ëd GPG.',
	'securepoll-secret-gpg-error' => 'Eror fasend giré GPG.
Dòvra $wgSecurePollShowErrorDetail=true; an LocalSettings.php për mosté pì ëd detaj.',
	'securepoll-full-gpg-error' => 'Eror fasend giré GPG:

Comand: $1

Eror:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Le ciav GPG a son configurà nen giuste.',
	'securepoll-gpg-parse-error' => "Eror an antërpretand l'output ëd GPG.",
	'securepoll-no-decryption-key' => 'Pa gnun-e ciav ëd decifrassion a son configurà.
As peul pa decifré.',
	'securepoll-jump' => 'Va al server ëd la votassion',
	'securepoll-bad-ballot-submission' => "Tò vot a l'era pa vàlid: $1",
	'securepoll-unanswered-questions' => 'It deuve arsponde a tute le custion.',
	'securepoll-invalid-rank' => 'Vot pa bon. It deuve dé ai candidà un vot tra 1 e 999.',
	'securepoll-unranked-options' => 'Cheich opsion a son pa stàite votà.
It deuve deje a minca vos un vot tra 1 e 999.',
	'securepoll-invalid-score' => 'Ël pontegi a deuv esse un nùmer an tra $1 e $2.',
	'securepoll-unanswered-options' => "A dev dé n'arspòsta për minca chestion.",
	'securepoll-remote-auth-error' => 'Eror an lesend le anformassion ëd tò cont dal server.',
	'securepoll-remote-parse-error' => "Eror an antërpretand l'arspòsta d'autorisassion dal server.",
	'securepoll-api-invalid-params' => 'Paràmetr pa vàlid.',
	'securepoll-api-no-user' => "Pa gnun utent trovà con l'ID fornì.",
	'securepoll-api-token-mismatch' => 'Ij token ëd sicurëssa a corispondo pa, it peule pa intré.',
	'securepoll-not-logged-in' => "It deuve intré për voté an st'elession-sì",
	'securepoll-too-few-edits' => "Spiasent, it peule pa voté. It deuve avèj fàit almanch $1 {{PLURAL:$1|modìfica|modìfiche}} për voté an st'elession-sì, ti it l'has fane $2.",
	'securepoll-blocked' => "Spiasent, it peule pa voté an st'elession-sì se it ses blocà.",
	'securepoll-bot' => "Spiasent, ij cont lë stat ëd bot a peulo pa voté an st'elession-sì.",
	'securepoll-not-in-group' => 'Mach ij mèmber dël grup "$1" a peulo voté an st\'elession-sì.',
	'securepoll-not-in-list' => "Spiasent, it ses pa ant la lista predeterminà d'utent autorisà a voté an st'elession-sì.",
	'securepoll-list-title' => 'Lista dij vot: $1',
	'securepoll-header-timestamp' => 'Ora',
	'securepoll-header-voter-name' => 'Nòm',
	'securepoll-header-voter-domain' => 'Domini',
	'securepoll-header-ua' => 'Agent utent',
	'securepoll-header-cookie-dup' => 'Duplicà',
	'securepoll-header-strike' => 'Anulà',
	'securepoll-header-details' => 'Detaj',
	'securepoll-strike-button' => 'Anulà',
	'securepoll-unstrike-button' => 'Scansela anulament',
	'securepoll-strike-reason' => 'Rason:',
	'securepoll-strike-cancel' => 'Scancela',
	'securepoll-strike-error' => 'Eror an fasend anula/scansela anulament: $1',
	'securepoll-strike-token-mismatch' => 'Përdù ij dat ëd session',
	'securepoll-details-link' => 'Detaj',
	'securepoll-details-title' => 'Detaj dël vot: #$1',
	'securepoll-invalid-vote' => '"$1" a l\'é pa l\'ID d\'un vot vàlid',
	'securepoll-header-voter-type' => 'Rasa ëd votant',
	'securepoll-voter-properties' => 'Proprietà dël votant',
	'securepoll-strike-log' => "Registr ëd j'anulament",
	'securepoll-header-action' => 'Assion',
	'securepoll-header-reason' => 'Rason',
	'securepoll-header-admin' => 'Aministrador',
	'securepoll-cookie-dup-list' => 'Utent dobi për cookie',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => "Pa gnun-e registrassion cifrà dl'elession a-i son për st'elession-sì, përchè l'elession a l'é pa configurà për dovré la cifradura.",
	'securepoll-dump-not-finished' => "Le registrassion cifrà dl'elession a son mach disponìbij d'apress la data ëd fin ël $1 a $2",
	'securepoll-dump-no-urandom' => "As peul pa deurbe /dev/urandom.
Për manten-e la privacy dij votant, le registrassion cifrà dl'elession a saran disponibij publicament mach quand a saran cifrà con un fluss sicur ëd nùmer casuaj.",
	'securepoll-urandom-not-supported' => "Sto server-sì a përmëtt pa la generassion casual ëd nùmer critogràfich.
Për manten-e la privacy dij votant, le registrassion criptà dl'elession a son publicament dicponìbij mach quand che a peulo esse stërmà con un fluss sicur ëd nùmer casuaj.",
	'securepoll-translate-title' => 'Traduv: $1',
	'securepoll-invalid-language' => 'Còdes lenga pa vàlid "$1"',
	'securepoll-submit-translate' => 'Agiorna',
	'securepoll-language-label' => 'Sern lenga:',
	'securepoll-submit-select-lang' => 'Traduv',
	'securepoll-entry-text' => 'Sota a-i é la lista dij sondagi.',
	'securepoll-header-title' => 'Nòm',
	'securepoll-header-start-date' => 'Data inissi',
	'securepoll-header-end-date' => 'Data fin',
	'securepoll-subpage-vote' => 'Vòta',
	'securepoll-subpage-translate' => 'Traduv',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Puntegi',
	'securepoll-tally-title' => 'Puntegi: $1',
	'securepoll-tally-not-finished' => "Spiasent, it peule pa contegé l'elession fin a che ël vot a sia nen complet.",
	'securepoll-can-decrypt' => "La registrassion ëd l'elession a l'é stàita cifrà, ma la ciav ëd decifrassion a l'é disponìbila.
It peule serne sia ëd conté j'arzultà present ant ël database, sia ëd conté j'arzultà cifrà da un file carià.",
	'securepoll-tally-no-key' => "It peule pa conté st'elession-sì, përchè ij vot a son cifrà, e la ciav ëd decifrassion a l'é pa disponìbil.",
	'securepoll-tally-local-legend' => "Conta j'arzultà memorisà",
	'securepoll-tally-local-submit' => 'Crea ël contegi',
	'securepoll-tally-upload-legend' => 'Caria ël dump cifrà',
	'securepoll-tally-upload-submit' => 'Crea ël contegi',
	'securepoll-tally-error' => 'Eror an antërpretand la registrassion dij vot, a peul pa prodove un contegi.',
	'securepoll-no-upload' => "pa gnun file a l'é stàit carià, as peul pa conté j'arzultà.",
	'securepoll-dump-corrupt' => "Ël dump file a l'é corot e a peul pa esse prossessà.",
	'securepoll-tally-upload-error' => 'Eror an contand ël file ëd dump: $1',
	'securepoll-pairwise-victories' => 'Matris ëd vìnsita a cobie',
	'securepoll-strength-matrix' => 'Matris ëd fòrsa dël path',
	'securepoll-ranks' => 'Votassion final',
	'securepoll-average-score' => 'Pontegi medi',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'securepoll-header-timestamp' => 'وخت',
	'securepoll-header-voter-name' => 'نوم',
	'securepoll-header-details' => 'تفصيلات',
	'securepoll-strike-reason' => 'سبب:',
	'securepoll-strike-cancel' => 'ناګارل',
	'securepoll-header-reason' => 'سبب',
	'securepoll-header-admin' => 'پازوال',
	'securepoll-submit-translate' => 'اوسمهاله کول',
	'securepoll-language-label' => 'ژبه ټاکل:',
	'securepoll-submit-select-lang' => 'ژباړل',
	'securepoll-header-title' => 'نوم',
	'securepoll-header-start-date' => 'د پيل نېټه',
	'securepoll-header-end-date' => 'د پای نېټه',
	'securepoll-subpage-vote' => 'رايه ورکول',
	'securepoll-subpage-translate' => 'ژباړل',
	'securepoll-subpage-list' => 'لړليک',
);

/** Portuguese (Português)
 * @author Capmo
 * @author Crazymadlover
 * @author Everton137
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'securepoll' => 'Sondagem Segura',
	'securepoll-desc' => 'Extensão para eleições e sondagens',
	'securepoll-invalid-page' => 'Subpágina inválida: "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Precisa de ser um administrador de eleições para realizar esta operação.',
	'securepoll-too-few-params' => 'Parâmetros de subpágina insuficientes (ligação inválida).',
	'securepoll-invalid-election' => '"$1" não é um identificador de eleição válido.',
	'securepoll-welcome' => '<strong>Bem-vindo(a) $1!</strong>',
	'securepoll-not-started' => 'Esta eleição ainda não começou.
Está programado iniciar-se a $2 às $3.',
	'securepoll-finished' => 'Esta eleição terminou, já não pode votar.',
	'securepoll-not-qualified' => 'Não cumpre os requisitos para votar nesta eleição: $1',
	'securepoll-change-disallowed' => 'Já votou nesta eleição.
Desculpe, mas não pode votar de novo.',
	'securepoll-change-allowed' => '<strong>Nota: Já votou nesta eleição.</strong>
Pode alterar o seu voto, enviando o formulário abaixo.
Note que, se o fizer, o voto original será descartado.',
	'securepoll-submit' => 'Enviar voto',
	'securepoll-gpg-receipt' => 'Obrigado por ter votado.

Se desejar, guarde o seguinte recibo como prova do seu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Obrigado, o seu voto foi registado.',
	'securepoll-return' => 'Voltar para $1',
	'securepoll-encrypt-error' => 'Não foi possível codificar o registo do seu voto.
O voto não foi registado!

$1',
	'securepoll-no-gpg-home' => 'Não foi possível criar o directório de raiz do GNU Privacy Guard.',
	'securepoll-secret-gpg-error' => 'Erro de execução do GNU Privacy Guard.
Adicione $wgSecurePollShowErrorDetail=true; ao ficheiro LocalSettings.php para mostrar mais detalhes.',
	'securepoll-full-gpg-error' => 'Erro de execução do GNU Privacy Guard:

Comando: $1

Erro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'As chaves GNU Privacy Guard estão mal configuradas.',
	'securepoll-gpg-parse-error' => 'Erro ao interpretar os dados gerados pelo GNU Privacy Guard.',
	'securepoll-no-decryption-key' => 'Não está configurada nenhuma chave criptográfica.
Não é possível descodificar.',
	'securepoll-jump' => 'Ir para o servidor de votação',
	'securepoll-bad-ballot-submission' => 'O seu voto foi inválido: $1',
	'securepoll-unanswered-questions' => 'Tem de responder a todas as perguntas.',
	'securepoll-invalid-rank' => 'Classificação inválida. Deve atribuir aos candidatos uma classificação entre 1 e 999.',
	'securepoll-unranked-options' => 'Algumas opções não foram classificadas.
Deve atribuir a todas as opções uma classificação entre 1 e 999.',
	'securepoll-invalid-score' => 'A pontuação deve ser um número entre $1 e $2.',
	'securepoll-unanswered-options' => 'Tem de dar uma resposta a todas as perguntas.',
	'securepoll-remote-auth-error' => 'Erro ao tentar obter do servidor as informações da sua conta.',
	'securepoll-remote-parse-error' => 'Erro ao interpretar a resposta de autorização do servidor.',
	'securepoll-api-invalid-params' => 'Parâmetros inválidos.',
	'securepoll-api-no-user' => 'Nenhum utilizador foi encontrado com a identificação fornecida.',
	'securepoll-api-token-mismatch' => 'Token de segurança não corresponde, não foi possível autenticar.',
	'securepoll-not-logged-in' => 'Precisa de se autenticar para votar nesta eleição',
	'securepoll-too-few-edits' => 'Desculpe, mas não pode votar. É necessário ter-se feito pelo menos {{PLURAL:$1|uma edição|$1 edições}} para votar nesta eleição e fez apenas $2.',
	'securepoll-blocked' => 'Desculpe, mas não pode votar nesta eleição se foi bloqueado de efectuar edições.',
	'securepoll-bot' => 'Desculpe, mas contas com de robôs não estão autorizadas a votar nesta eleição.',
	'securepoll-not-in-group' => 'Só os membros do grupo "$1" podem votar nesta eleição.',
	'securepoll-not-in-list' => 'Desculpe, mas não consta da lista de utilizadores previamente autorizados a votar nesta eleição.',
	'securepoll-list-title' => 'Listar votos: $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Domínio',
	'securepoll-header-ua' => 'Agente de utilizador',
	'securepoll-header-cookie-dup' => 'Dupl.',
	'securepoll-header-strike' => 'Riscar',
	'securepoll-header-details' => 'Detalhes',
	'securepoll-strike-button' => 'Riscar',
	'securepoll-unstrike-button' => 'Remover risco',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-strike-error' => 'Erro ao riscar/remover risco: $1',
	'securepoll-strike-token-mismatch' => 'Dados da sessão perdidos.',
	'securepoll-details-link' => 'Detalhes',
	'securepoll-details-title' => 'Detalhes do voto: #$1',
	'securepoll-invalid-vote' => '"$1" não é um ID de voto válido',
	'securepoll-header-voter-type' => 'Tipo de utilizador',
	'securepoll-voter-properties' => 'Propriedades do votante',
	'securepoll-strike-log' => 'Registo de riscos',
	'securepoll-header-action' => 'Acção',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => "Utilizadores com ''cookie'' duplicado",
	'securepoll-dump-title' => 'Depositar: $1',
	'securepoll-dump-no-crypt' => 'Nenhum registo codificado de eleição está disponível para esta eleição, porque a eleição não está configurada para usar encriptação.',
	'securepoll-dump-not-finished' => 'Registos de eleição encriptados estarão disponíveis apenas após a eleição terminar a $1 às $2',
	'securepoll-dump-no-urandom' => 'Não é possível abrir /dev/urandom.
Para manter a privacidade do votante, registos de eleição codificados são tornados públicos apenas quando podem ser encriptados com uma fonte segura de números aleatórios.',
	'securepoll-urandom-not-supported' => 'Este servidor não suporta geração criptográfica de números aleatórios.
Para manter a privacidade dos votantes, os resultados criptografados da eleição são tornados públicos apenas quando podem ser embaralhados com uma sequência de números aleatórios.',
	'securepoll-translate-title' => 'Traduzir: $1',
	'securepoll-invalid-language' => 'Código de língua "$1" inválido',
	'securepoll-submit-translate' => 'Actualizar',
	'securepoll-language-label' => 'Escolha a língua:',
	'securepoll-submit-select-lang' => 'Traduzir',
	'securepoll-entry-text' => 'Encontra abaixo a lista de eleições.',
	'securepoll-header-title' => 'Nome',
	'securepoll-header-start-date' => 'Data de início',
	'securepoll-header-end-date' => 'Data de fim',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traduzir',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Depositar',
	'securepoll-subpage-tally' => 'Apurar',
	'securepoll-tally-title' => 'Apurar: $1',
	'securepoll-tally-not-finished' => 'Desculpe, mas não pode apurar os resultados da eleição até que a votação esteja terminada.',
	'securepoll-can-decrypt' => 'O registo da eleição foi encriptado, mas a chave de descodificação está disponível.
Pode escolher entre apurar os resultados presentes na base de dados, ou apurar resultados encriptados de um ficheiro carregado.',
	'securepoll-tally-no-key' => 'Não pode apurar esta eleição, porque os votos estão encriptados e a chave de descodificação não está disponível.',
	'securepoll-tally-local-legend' => 'Apurar resultados armazenados',
	'securepoll-tally-local-submit' => 'Criar apuramento',
	'securepoll-tally-upload-legend' => 'Carregar depósito encriptado',
	'securepoll-tally-upload-submit' => 'Criar apuramento',
	'securepoll-tally-error' => 'Erro na interpretação de registo de voto, não é possível produzir apuramento.',
	'securepoll-no-upload' => 'Nenhum ficheiro foi carregado, não é possível apurar resultados.',
	'securepoll-dump-corrupt' => 'O ficheiro de depósito está corrompido e não pode ser processado.',
	'securepoll-tally-upload-error' => 'Erro ao contar o ficheiro de depósito: $1',
	'securepoll-pairwise-victories' => 'Matriz de vitórias par a par',
	'securepoll-strength-matrix' => 'Matriz de forças de caminho',
	'securepoll-ranks' => 'Classificação final',
	'securepoll-average-score' => 'Pontuação média',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Capmo
 * @author Eduardo.mps
 * @author Everton137
 * @author GKnedo
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'securepoll' => 'VotaçãoSegura',
	'securepoll-desc' => 'Extensão para eleições e pesquisas',
	'securepoll-invalid-page' => 'Subpágina inválida "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Você precisa ser um administrador de eleição para realizar esta ação',
	'securepoll-too-few-params' => 'Sem parâmetros de subpágina suficientes (ligação inválida).',
	'securepoll-invalid-election' => '"$1" não é um ID de eleição válido.',
	'securepoll-welcome' => '<strong>Bem vindo(a) $1!</strong>',
	'securepoll-not-started' => 'Esta eleição ainda não começou.
Ela está programada para se iniciar em $2, às $3.',
	'securepoll-finished' => 'Esta eleição terminou, você não pode mais votar.',
	'securepoll-not-qualified' => 'Você não está qualificado(a) para votar nesta eleição: $1',
	'securepoll-change-disallowed' => 'Você já votou nesta eleição previamente.
Desculpe, mas você não pode votar novamente.',
	'securepoll-change-allowed' => '<strong>Nota: Você já votou nesta eleição anteriormente.</strong>
Você pode mudar seu voto enviando o formulário abaixo.
Note que se fizer isso, seu voto original será descartado.',
	'securepoll-submit' => 'Enviar voto',
	'securepoll-gpg-receipt' => 'Obrigado por votar.

Se desejar, você pode ter o seguinte recibo como evidência do seu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Obrigado, seu voto foi registrado.',
	'securepoll-return' => 'Retornar a $1',
	'securepoll-encrypt-error' => 'Falha ao criptografar seu registro de voto.
Seu voto não foi registrado!

$1',
	'securepoll-no-gpg-home' => 'Não foi possível criar o diretório raiz do GPG',
	'securepoll-secret-gpg-error' => 'Erro ao executar o GPG.
Utilize $wgSecurePollShowErrorDetail=true; no LocalSettings.php para exibir mais detalhes.',
	'securepoll-full-gpg-error' => 'Erro ao executar GPG:

Comando: $1

Erro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'As chaves GPG estão configuradas incorretamente.',
	'securepoll-gpg-parse-error' => 'Erro ao interpretar os dados de saída do GPG.',
	'securepoll-no-decryption-key' => 'Nenhuma chave de descriptografia está configurada.
Não foi possível descriptografar.',
	'securepoll-jump' => 'Ir para o servidor de votação',
	'securepoll-bad-ballot-submission' => 'Seu voto foi inválido: $1',
	'securepoll-unanswered-questions' => 'Você deve responder todas as questões.',
	'securepoll-invalid-rank' => 'Nota inválida. Você deve classificar os candidatos com notas entre 1 e 999.',
	'securepoll-unranked-options' => 'Algumas opções não foram classificadas.
Você deve classificar todas as opções com uma nota entre 1 e 999.',
	'securepoll-remote-auth-error' => 'Erro ao tentar obter suas informações de conta do servidor.',
	'securepoll-remote-parse-error' => 'Erro ao interpretar a resposta de autorização do servidor.',
	'securepoll-api-invalid-params' => 'Parâmetros inválidos.',
	'securepoll-api-no-user' => 'Nenhum usuário foi encontrado com a ID fornecida.',
	'securepoll-api-token-mismatch' => 'Token de segurança não confere, não foi possível autenticar.',
	'securepoll-not-logged-in' => 'Você deve se registrar para votar nesta eleição',
	'securepoll-too-few-edits' => 'Desculpe, você não pode votar. É preciso ter feito no mínimo $1 {{PLURAL:$1|edição|edições}} para votar nesta eleição, você fez $2.',
	'securepoll-blocked' => 'Desculpe, você não pode votar nesta eleição se no momento você está bloqueado de editar.',
	'securepoll-bot' => "Desculpe, contas de programas robôs (marcadas como ''bot'') não podem votar nesta eleição.",
	'securepoll-not-in-group' => 'Apenas os membros do grupo "$1" podem votar nesta eleição.',
	'securepoll-not-in-list' => 'Desculpe, você não está na lista predeterminada de usuários autorizados a votar nesta eleição.',
	'securepoll-list-title' => 'Lista de votos: $1',
	'securepoll-header-timestamp' => 'Data',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Domínio',
	'securepoll-header-ua' => 'Agente utilizador',
	'securepoll-header-cookie-dup' => 'Dupl.',
	'securepoll-header-strike' => 'Riscados',
	'securepoll-header-details' => 'Detalhes',
	'securepoll-strike-button' => 'Riscar',
	'securepoll-unstrike-button' => 'Remover risco',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-strike-error' => 'Erro ao riscar/remover risco: $1',
	'securepoll-strike-token-mismatch' => 'Dados da sessão perdidos',
	'securepoll-details-link' => 'Detalhes',
	'securepoll-details-title' => 'Detalhes do voto: #$1',
	'securepoll-invalid-vote' => '"$1" não é um ID de voto válido',
	'securepoll-header-voter-type' => 'Tipo de usuário',
	'securepoll-voter-properties' => 'Propriedades do votante',
	'securepoll-strike-log' => 'Registro de riscados',
	'securepoll-header-action' => 'Ação',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-cookie-dup-list' => "Usuários com ''cookie'' duplicado",
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Nenhum registro criptografado de eleição está disponível para esta eleição, porque a eleição não está configurada para usar criptografia.',
	'securepoll-dump-not-finished' => 'Registros criptografados da eleição estarão disponíveis apenas após a data de encerramento em $1 às $2',
	'securepoll-dump-no-urandom' => 'Não foi possível abrir /dev/urandom.
Para mantes a privacidade do eleitor, os registros criptografados da eleição são disponibilizados publicamente quando eles podem ser embaralhados com uma sequência segura de números aleatórios.',
	'securepoll-urandom-not-supported' => 'Este servidor não suporta geração criptográfica de números aleatórios.
Para manter a privacidade dos votantes, os resultados criptografados da eleição são tornados públicos apenas quando podem ser embaralhados com uma sequência de números aleatórios.',
	'securepoll-translate-title' => 'Traduzir: $1',
	'securepoll-invalid-language' => 'Código de língua "$1" inválido',
	'securepoll-submit-translate' => 'Atualizar',
	'securepoll-language-label' => 'Selecionar língua:',
	'securepoll-submit-select-lang' => 'Traduzir',
	'securepoll-header-title' => 'Título',
	'securepoll-header-start-date' => 'Data do Início',
	'securepoll-header-end-date' => 'Data do Encerramento',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traduzir',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Apuração',
	'securepoll-tally-title' => 'Contagem de votos: $1',
	'securepoll-tally-not-finished' => 'Desculpe, você não pode apurar os resultados da eleição antes do término da votação.',
	'securepoll-can-decrypt' => 'O registro de eleição foi criptografado, mas a chave de descriptografia está disponível.
Você pode escolher entre realizar a contagem de votos dos resultados presentes na base de dados, ou realizá-la a partir de resultados criptografados de um arquivo carregado.',
	'securepoll-tally-no-key' => 'Você não pode realizar a apuração de votos desta eleição, pois os votos estão criptografados, e a chave de descriptografia não está disponível.',
	'securepoll-tally-local-legend' => 'Apurar resultados armazenados',
	'securepoll-tally-local-submit' => 'Criar contagem de votos',
	'securepoll-tally-upload-legend' => 'Carregar dump criptografado',
	'securepoll-tally-upload-submit' => 'Criar contagem de votos',
	'securepoll-tally-error' => 'Erro ao interpretar registro de votos, não foi possível produzir uma contagem.',
	'securepoll-no-upload' => 'Nenhum arquivo foi carregado, não foi possível contar os votos para o resultado.',
	'securepoll-dump-corrupt' => 'O arquivo de dump está corrompido e não pode ser processado.',
	'securepoll-tally-upload-error' => 'Erro ao contar o arquivo de dump: $1',
	'securepoll-pairwise-victories' => 'Matriz de vitórias par a par',
	'securepoll-strength-matrix' => 'Matriz de forças de caminho',
	'securepoll-ranks' => 'Classificação final',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'securepoll' => 'SondajSecurizat',
	'securepoll-desc' => 'Extensie pentru alegeri şi anchete',
	'securepoll-invalid-page' => 'Subpagină invalidă „<nowiki>$1</nowiki>”',
	'securepoll-need-admin' => 'Trebuie să fiţi un administrator de alegeri pentru a efectua această acţiune.',
	'securepoll-invalid-election' => '„$1” nu este un ID valid de alegeri.',
	'securepoll-welcome' => '<strong>Bun venit $1 !</strong>',
	'securepoll-not-started' => 'Aceste elegeri nu au început încă.
Sunt programate pentru a începe pe $2 la $3.',
	'securepoll-finished' => 'Alegerile s-au sfârşit, nu mai puteţi vota.',
	'securepoll-not-qualified' => 'Nu sunteţi calificat să votaţi în aceste alegeri: $1',
	'securepoll-change-disallowed' => 'Aţi votat în aceste alegeri înainte.
Ne pare rău, nu puteţi vota din nou.',
	'securepoll-submit' => 'Trimite votul',
	'securepoll-gpg-receipt' => 'Mulţumesc pentru vot.

Dacă doriţi aţi putea păstra următorul bon ca dovadă a votului dvs:

<pre>$1</pre>',
	'securepoll-thanks' => 'Mulţumim, votul tău a fost înregistrat,',
	'securepoll-return' => 'Înapoi la $1',
	'securepoll-encrypt-error' => 'A eşuat să se cripteze înregistrarea votului dvs.
Votul dvs nu a fost înregistrat ! 

$1',
	'securepoll-full-gpg-error' => 'Eroare la executarea GPG:

Comandă: $1

Eroare:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Cheile GPG sunt configurate greşit.',
	'securepoll-no-decryption-key' => 'Nicio cheie de decriptare nu este configurată.
Nu se poate decripta.',
	'securepoll-jump' => 'Mergeţi la serverul de votare',
	'securepoll-bad-ballot-submission' => 'Votul dvs a fost invalid: $1',
	'securepoll-unanswered-questions' => 'Trebuie să răspunzi la toate întrebările.',
	'securepoll-invalid-rank' => 'Rang invalid. Trebuie să daţi candidaţilor un rang între 1 şi 999.',
	'securepoll-unranked-options' => 'Unele opţiuni nu au fost clasate.
Trebuie să oferi tuturor opţiunilor un rang între 1 şi 999.',
	'securepoll-invalid-score' => 'Scorul trebuie să fie un număr între $1 şi $2.',
	'securepoll-unanswered-options' => 'Trebuie să daţi un răspuns pentru fiecare întrebare.',
	'securepoll-remote-auth-error' => 'Eroare la preluarea informaţilor contului dvs de pe server.',
	'securepoll-api-invalid-params' => 'Parametri incorecţi.',
	'securepoll-api-no-user' => 'Niciun  utilizator cu acest ID nu a fost găsit.',
	'securepoll-api-token-mismatch' => 'Semnul de securitate s-a dereglat, nu te poţi loga.',
	'securepoll-not-logged-in' => 'Trebuie să vă autentificaţi pentru a vota în aceste alegeri',
	'securepoll-too-few-edits' => 'Ne pare rău, nu puteţi vota. Trebuie să aveţi făcute cel puţin $1 {{PLURAL:$1|modificare|modificări}} pentru a vota în aceste alegeri, dvs aveţi făcute $2.',
	'securepoll-blocked' => 'Ne pare rău, nu puteţi vota în aceste elegeri dacă sunteţi blocat la editare.',
	'securepoll-bot' => 'Ne pare rău, conturile cu steagul de bot nu li se permit să voteze în aceste alegeri.',
	'securepoll-not-in-group' => 'Doar membrii grupului „$1” pot vota în aceste alegeri.',
	'securepoll-not-in-list' => 'Ne pare rău, nu sunteţi în lista predeterminată de utilizatori autorizaţi să voteze în aceste alegeri.',
	'securepoll-list-title' => 'Listă voturi: $1',
	'securepoll-header-timestamp' => 'Timp',
	'securepoll-header-voter-name' => 'Nume',
	'securepoll-header-voter-domain' => 'Domeniu',
	'securepoll-header-ua' => 'Agent utilizator',
	'securepoll-header-cookie-dup' => '',
	'securepoll-header-strike' => 'Ştergeţi',
	'securepoll-header-details' => 'Detalii',
	'securepoll-unstrike-button' => 'Anulare ştergere',
	'securepoll-strike-reason' => 'Motiv:',
	'securepoll-strike-cancel' => 'Anulare',
	'securepoll-strike-error' => 'Eroare la efectuarea ştergerii/anulării ştergerii: $1',
	'securepoll-strike-token-mismatch' => 'Informaţiile despre sesiune s-au pierdut',
	'securepoll-details-link' => 'Detalii',
	'securepoll-details-title' => 'Detalii vot: #$1',
	'securepoll-invalid-vote' => '„$1” nu este o identitate a unui vot valid',
	'securepoll-header-voter-type' => 'Tipuri de votanţi',
	'securepoll-voter-properties' => 'Proprietăţi votanţi',
	'securepoll-strike-log' => 'Jurnal de ştergere',
	'securepoll-header-action' => 'Acţiune',
	'securepoll-header-reason' => 'Motiv',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => 'utilizatori duplicaţi prin cookie',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Nu există o înregistrare a alegerilor criptată valabilă pentru aceste alegeri, deoarece alegerile nu sunt configurate pentru a folosi criptarea.',
	'securepoll-dump-not-finished' => 'Înregistrările alegerilor criptate sunt valabile doar după data de încheiere în $1 la $2',
	'securepoll-translate-title' => 'Traducere: $1',
	'securepoll-invalid-language' => 'Cod de limbă incorect "$1"',
	'securepoll-submit-translate' => 'Actualizează',
	'securepoll-language-label' => 'Marchează limba:',
	'securepoll-submit-select-lang' => 'Traducere',
	'securepoll-entry-text' => 'Mai jos este lista de sondaje.',
	'securepoll-header-title' => 'Nume',
	'securepoll-header-start-date' => 'Dată început',
	'securepoll-header-end-date' => 'Dată sfârşit',
	'securepoll-subpage-vote' => 'Vot',
	'securepoll-subpage-translate' => 'Traducere',
	'securepoll-subpage-list' => 'Listă',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Copiere',
	'securepoll-tally-title' => 'Copiere: $1',
	'securepoll-tally-not-finished' => 'Ne pare rău, nu puteţi copia alegerile până după ce votarea nu e completă.',
	'securepoll-tally-no-key' => 'Nu puteţi copia aceste alegeri, deoarece voturile sunt criptate, iar cheia de decriptare nu e valabilă.',
	'securepoll-tally-local-legend' => 'Copia a stocat rezultatele',
	'securepoll-tally-local-submit' => 'Creaţi o copiere',
	'securepoll-tally-upload-legend' => 'Încărcaţi un dump criptat',
	'securepoll-tally-upload-submit' => 'Creaţi copie',
	'securepoll-tally-error' => 'Eroare la interpretarea înregistrării voturilor, nu se poate produce o copie.',
	'securepoll-no-upload' => 'Niciun fişier n-a fost încărcat, nu se pot copia rezultatele.',
	'securepoll-tally-upload-error' => 'Eroare la copierea fişierului dump: $1',
	'securepoll-ranks' => 'Clasament final',
	'securepoll-average-score' => 'Scorul mediu',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'securepoll' => 'SondaggeSecure',
	'securepoll-desc' => 'Estenziune pe eleziune e sondagge',
	'securepoll-invalid-page' => 'Sottepàgene invalide "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => "Tu è abbesogne de essere 'n'amministratore de eleziune pe fà st'azione.",
	'securepoll-too-few-params' => 'Non ge stonne abbastazne parametre de le sottopàggene (collegamende invalide).',
	'securepoll-invalid-election' => '"$1" non g\'è \'n\'ID valide de elezione.',
	'securepoll-welcome' => '<strong>Bovègne $1!</strong>',
	'securepoll-not-started' => "Sta elezione non g'à partute angore.<br />
L'inizie sue jè schedulate 'u $2 a le $3.",
	'securepoll-finished' => 'Sta elezione ha spicciate, tu non ge puè cchiù vutà.',
	'securepoll-not-qualified' => 'Tu non ge puè vutà pe sta elezione: $1',
	'securepoll-change-disallowed' => "Tu è ggià vutate jndr'à sta elezione.<br />
Ne dispiace, non ge puè vutà 'n'otra vote.",
	'securepoll-change-allowed' => "<strong>Vide Bbuene: Tu è ggià vutate jndr'à sta elezione.</strong><br />
Tu puè cangià 'u vote tune confermanne cu 'u module aqquà sotte.<br />
Vide bbuene ca ce tu face quiste, 'u vote origgenale tune avène scettate.",
	'securepoll-submit' => "Conferme 'u vote",
	'securepoll-gpg-receipt' => 'Grazie pu vote

Ce tu vuè, tu puè conzervà sta ricevute cumme evidenze ca è vutate:

<pre>$1</pre>',
	'securepoll-thanks' => "Grazie, 'u vote tune ha state reggistrate.",
	'securepoll-return' => 'Tuèrne a $1',
	'securepoll-encrypt-error' => "Fallimende quanne s'à criptate 'a reggistrazione d'u vote tune.<br />
'U vote tune non g'à state reggistrate!

$1",
	'securepoll-no-gpg-home' => "'Mbossibbele ccrejà 'na cartella de partenze GPG.",
	'securepoll-secret-gpg-error' => 'Errore eseguenne GPG.<br />
Ause $wgSecurePollShowErrorDetail=true; in LocalSettings.php pe vedè cchiù dettaglie.',
	'securepoll-full-gpg-error' => 'Errore eseguenne GPG:

Comande: $1

Errore:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Le chiave GPG non ge sonde configurate correttamende.',
	'securepoll-gpg-parse-error' => "Errore inderpretanne 'u resultate GPG.",
	'securepoll-no-decryption-key' => 'Nisciuna chiave de decriptazione ha state configurate.<br />
Non ge pozze decriptà.',
	'securepoll-jump' => "Vèje a 'u server de le vote",
	'securepoll-bad-ballot-submission' => "'U vote tune ere invalide: $1",
	'securepoll-unanswered-questions' => 'Tu a responnere a tutte le domande.',
	'securepoll-invalid-rank' => "Poziione invalide. Tu a dà candidate e posiziune 'mbrà l'1 e 'u 999.",
	'securepoll-unranked-options' => "Quacche opzione non ge tenève 'a posizione.<br />
Tu a dà a tutte le opziune 'na posizione 'mbrà 1 e 999.",
	'securepoll-invalid-score' => "'U pundegge adda essere 'nu numere 'mbrà $1 e $2.",
	'securepoll-unanswered-options' => "Tu a dà 'na resposte pe ogne domande.",
	'securepoll-remote-auth-error' => "Errore pigghianne le 'mbormaziune d'u cunde utende tune da 'u server.",
	'securepoll-remote-parse-error' => "Errore inderpretanne l'a resposte de autorizzazzione da 'u server.",
	'securepoll-api-invalid-params' => 'Parametre invalide.',
	'securepoll-api-no-user' => "Nisciune utnde ha state acchite cu l'ID date.",
	'securepoll-api-token-mismatch' => "'U token de securezze non ge quadre, non ge puè trasè.",
	'securepoll-not-logged-in' => "Tu a trasè pe vutà jndr'à sta elezione",
	'securepoll-too-few-edits' => "Ne dispiace, tu non ge puè vutà. Tu è abbesogne de fà almene $1 {{PLURAL:$1|cangiamende|cangiaminde}} pe vutà jndr'à sta elezione, tu invece n'è fatte $2.",
	'securepoll-blocked' => "Ne dispiace, tu non ge puè vutà jndr'à sta elezione purcé tu è state bloccate da fà le cangiaminde.",
	'securepoll-bot' => "Ne dispiace, le cunde utinde cu 'u flag pe le bot non ge ponne vutà jndr'à sta elezione.",
	'securepoll-not-in-group' => 'Sulamende le mobre d\'u gruppe "$1" ponne vutà jndr\'à sta elezione.',
	'securepoll-not-in-list' => "Ne dispiace, tu non ge ste jndr'à 'n'elenghe predeterminate de utinde autorizzate pe vutà jndr'à sta elezione.",
	'securepoll-list-title' => 'Elenghe de le vote: $1',
	'securepoll-header-timestamp' => 'Orarie',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominie',
	'securepoll-header-ua' => 'Utende agente',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Annulle',
	'securepoll-header-details' => 'Dettaglie',
	'securepoll-strike-button' => 'Annulle stu vote',
	'securepoll-unstrike-button' => "Repristine 'u vote",
	'securepoll-strike-reason' => 'Mutive:',
	'securepoll-strike-cancel' => 'Annulle',
	'securepoll-strike-error' => 'Errore eseguenne annulle/repristine: $1',
	'securepoll-strike-token-mismatch' => 'Sessione de date perdute',
	'securepoll-details-link' => 'Detaglie',
	'securepoll-details-title' => "Dettaglie d'u vote: #$1",
	'securepoll-invalid-vote' => '"$1" non g\'è \'n\'ID di vote valide',
	'securepoll-header-voter-type' => 'Tipe de elettore',
	'securepoll-voter-properties' => "Proprietà de l'elettore",
	'securepoll-strike-log' => 'Archivije de le annullaminde de vote',
	'securepoll-header-action' => 'Azione',
	'securepoll-header-reason' => 'Mutive',
	'securepoll-header-admin' => 'Amministratore',
	'securepoll-cookie-dup-list' => 'Utinde cu le cookie duplicate',
	'securepoll-dump-title' => 'File de dump: $1',
	'securepoll-dump-no-crypt' => "Nisciuna reggistrazzione criptate pe sta elezione jè disponibbele, purcé l'elezione non g'è configurate pe ausà le criptaziune.",
	'securepoll-dump-not-finished' => "Le reggistraziune de l'elezione sonde disponibele sulamende apprisse 'a date de fine: 'u $1 a le $2",
	'securepoll-dump-no-urandom' => "No se pò aprì /dev/urandom.<br />
Pe mandenè 'a privacy de le eletture, le reggistraziune de le eleziune criptate ponne essere disponibbele pubblecamende quanne ponne essere mesckate cu 'nu flusse secure de numere a uecchie.",
	'securepoll-urandom-not-supported' => "Stu server non ge supporte 'na generazione criptografeche de numere a uecchie.<br />
Pe mandenè 'a privacy de le eletture, le reggistraziune de le eleziune criptate ponne essere disponibbele pubblecamende quanne ponne essere mesckate cu 'nu flusse secure de numere a uecchie.",
	'securepoll-translate-title' => 'Traduce: $1',
	'securepoll-invalid-language' => 'Codece d\'a lènghe "$1" invalide',
	'securepoll-submit-translate' => 'Aggiorne',
	'securepoll-language-label' => "Scacchie 'a lènghe:",
	'securepoll-submit-select-lang' => 'Traduce',
	'securepoll-entry-text' => "Aqquà sotte ste l'elenghe de le sondagge.",
	'securepoll-header-title' => 'Nome',
	'securepoll-header-start-date' => 'Date de inizie',
	'securepoll-header-end-date' => 'Date de fine',
	'securepoll-subpage-vote' => 'Vote',
	'securepoll-subpage-translate' => 'Traduce',
	'securepoll-subpage-list' => 'Elenghe',
	'securepoll-subpage-dump' => 'File de Dump',
	'securepoll-subpage-tally' => 'Condegge',
	'securepoll-tally-title' => 'Condegge: $1',
	'securepoll-tally-not-finished' => "Ne dispiace, tu non ge puè cundà le vote 'mbonde ca 'a votazione jè combletate.",
	'securepoll-can-decrypt' => "Le 'mbormaziune de l'elezione onne state criptate, ma 'a chiave de decriptazione jè disponibbele.<br />
Tu puè scacchià o de fà 'u condegge de le vote da 'u database oppure ausanne le date criptate ca stonne sus a 'nu file carecate.",
	'securepoll-tally-no-key' => "Tu non ge puè cundà le vote, purcé le vote sonde criptate e non ge ste 'na chiave de decriptazione disponibbele.",
	'securepoll-tally-local-legend' => "Resultate d'u condegge reggistrate",
	'securepoll-tally-local-submit' => "Ccreje 'u condegge",
	'securepoll-tally-upload-legend' => "Careche 'nu file de dump criptate",
	'securepoll-tally-upload-submit' => "Ccreje 'u condegge",
	'securepoll-tally-error' => "Errore inderpretanne 'u vote reggistrate, non ge se pò fà 'nu condegge.",
	'securepoll-no-upload' => 'Nisciune file ha state carecate, non ge se ponne cundà le resultate.',
	'securepoll-dump-corrupt' => "'U file de dump è scuasciate o non ge pò essere processate.",
	'securepoll-tally-upload-error' => "Errore cundanne da 'u file de dump: $1",
	'securepoll-pairwise-victories' => "Matrice d'a vittorie a doje a doje",
	'securepoll-strength-matrix' => "Matrice de fortezze d'u percorse",
	'securepoll-ranks' => 'Posizione finale',
	'securepoll-average-score' => 'Pundegge medie',
);

/** Russian (Русский)
 * @author HalanTul
 * @author Kv75
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'securepoll' => 'БезопасноеГолосование',
	'securepoll-desc' => 'Расширение для проведения выборов и опросов',
	'securepoll-invalid-page' => 'Ошибочная подстраница «<nowiki>$1</nowiki>»',
	'securepoll-need-admin' => 'Чтобы выполнить это действие, вы должны быть администратором выборов.',
	'securepoll-too-few-params' => 'Не хватает параметров подстраницы (ошибочная ссылка).',
	'securepoll-invalid-election' => '«$1» не является допустимым идентификатором выборов.',
	'securepoll-welcome' => '<strong>Добро пожаловать, $1!</strong>',
	'securepoll-not-started' => 'Эти выборы ещё не начались.
Начало запланировано на $2 $3.',
	'securepoll-finished' => 'Это голосование завершено, вы уже не можете проголосовать.',
	'securepoll-not-qualified' => 'Вы не правомочны голосовать на этих выборах: $1',
	'securepoll-change-disallowed' => 'Вы уже голосовали на этих выборах ранее.
Извините, вы не можете проголосовать ещё раз.',
	'securepoll-change-allowed' => '<strong>Примечание. Вы уже голосовали на этих выборах ранее.</strong>
Вы можете изменить свой голос, отправив приведённую ниже форму.
Если вы сделаете это, то ваш предыдущий голос не будет учтён.',
	'securepoll-submit' => 'Отправить голос',
	'securepoll-gpg-receipt' => 'Благодарим за участие в голосовании.

При желании вы можете сохранить следующие строки в качестве подтверждения вашего голоса:

<pre>$1</pre>',
	'securepoll-thanks' => 'Спасибо, ваш голос записан.',
	'securepoll-return' => 'Вернуться к $1',
	'securepoll-encrypt-error' => 'Не удалось зашифровать запись о вашем голосе.
Ваш голос не был записан!

$1',
	'securepoll-no-gpg-home' => 'Невозможно создать домашний каталог GPG.',
	'securepoll-secret-gpg-error' => 'Ошибка при выполнении GPG.
Задайте настройку $wgSecurePollShowErrorDetail=true; в файле LocalSettings.php чтобы получить более подробное сообщение.',
	'securepoll-full-gpg-error' => 'Ошибка при выполнении GPG:

Команда: $1

Ошибка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-ключи настроены неправильно.',
	'securepoll-gpg-parse-error' => 'Ошибка при интерпретации вывода GPG.',
	'securepoll-no-decryption-key' => 'Не настроен ключ расшифровки.
Невозможно  расшифровать.',
	'securepoll-jump' => 'Перейти на сервер голосований',
	'securepoll-bad-ballot-submission' => 'Ваш голос не действителен: $1',
	'securepoll-unanswered-questions' => 'Вы должны ответить на все вопросы.',
	'securepoll-invalid-rank' => 'Недействительный ранг. Вы должны указать для кандидата ранг от 1 до 999.',
	'securepoll-unranked-options' => 'Некоторые записи не проранжированы.
Вам необходимо указать ранг от 1 до 999 для всех записей.',
	'securepoll-invalid-score' => 'Оценка должна быть числом от $1 до $2.',
	'securepoll-unanswered-options' => 'Вы должны дать ответ на каждый вопрос.',
	'securepoll-remote-auth-error' => 'Ошибка получения информации об учётной записи с сервера.',
	'securepoll-remote-parse-error' => 'Ошибка интерпретации ответа авторизации с сервера.',
	'securepoll-api-invalid-params' => 'Ошибочные параметры.',
	'securepoll-api-no-user' => 'Не найдено участника с заданным идентификатором.',
	'securepoll-api-token-mismatch' => 'Несоответствие признака безопасности, невозможно войти в систему.',
	'securepoll-not-logged-in' => 'Вы должны представиться системе, чтобы принять участие в голосовании',
	'securepoll-too-few-edits' => 'Извините, вы не можете проголосовать. Вам необходимо иметь не менее $1 {{PLURAL:$1|правки|правок|правок}} для участия в этом голосовании, за вами числится $2.',
	'securepoll-blocked' => 'Извините, вы не можете голосовать на выборах, если учётная запись была заблокирована.',
	'securepoll-bot' => 'Извините, учётные записи с флагом бота не допускаются для участия в голосовании.',
	'securepoll-not-in-group' => 'Только члены группы $1 могут голосовать на этих выборах.',
	'securepoll-not-in-list' => 'Извините, вы не входите в список участников, допущенных для голосования на этих выборах.',
	'securepoll-list-title' => 'Список голосов: $1',
	'securepoll-header-timestamp' => 'Время',
	'securepoll-header-voter-name' => 'Имя',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Агент пользователя',
	'securepoll-header-cookie-dup' => 'Дубли',
	'securepoll-header-strike' => 'Вычёркивание',
	'securepoll-header-details' => 'Подробности',
	'securepoll-strike-button' => 'Вычеркнуть',
	'securepoll-unstrike-button' => 'Снять вычёркивание',
	'securepoll-strike-reason' => 'Причина:',
	'securepoll-strike-cancel' => 'Отмена',
	'securepoll-strike-error' => 'Ошибка при вычёркивании или снятии вычёркивания: $1',
	'securepoll-strike-token-mismatch' => 'Потеря данных сессии',
	'securepoll-details-link' => 'Подробности',
	'securepoll-details-title' => 'Подробности голосования: #$1',
	'securepoll-invalid-vote' => '«$1» не является допустимым идентификатором голосования',
	'securepoll-header-voter-type' => 'Тип голосующего',
	'securepoll-voter-properties' => 'Свойства избирателя',
	'securepoll-strike-log' => 'Журнал вычёркиваний',
	'securepoll-header-action' => 'Действие',
	'securepoll-header-reason' => 'Причина',
	'securepoll-header-admin' => 'Админ',
	'securepoll-cookie-dup-list' => 'Дубликаты участников по Cookie',
	'securepoll-dump-title' => 'Дамп: $1',
	'securepoll-dump-no-crypt' => 'Незашифрованные записи подачи голоса доступны на этих выборах, так как выборы не настроены на использование шифрования.',
	'securepoll-dump-not-finished' => 'Зашифрованные записи подачи голосов доступны только после окончания голосования $1 $2',
	'securepoll-dump-no-urandom' => 'Не удаётся открыть /dev/urandom.
Для обеспечения конфиденциальности избирателей, зашифрованные записи подачи голосов можно делать общедоступными, когда порядок их следования изменён с использованием безопасного источника случайных чисел.',
	'securepoll-urandom-not-supported' => 'Этот сервер не поддерживает криптографические генерирование случайных чисел.
Чтобы сохранить конфиденциальность голосующих, закодированные записи голосования станут общедоступными только после того, как они смогут быть перемешаны безопасным потоком случайных чисел.',
	'securepoll-translate-title' => 'Перевод: $1',
	'securepoll-invalid-language' => 'Ошибочный код языка «$1»',
	'securepoll-submit-translate' => 'Обновить',
	'securepoll-language-label' => 'Выбор языка:',
	'securepoll-submit-select-lang' => 'Перевести',
	'securepoll-entry-text' => 'Ниже приведён список голосований.',
	'securepoll-header-title' => 'Имя',
	'securepoll-header-start-date' => 'Дата начала',
	'securepoll-header-end-date' => 'Дата окончания',
	'securepoll-subpage-vote' => 'Голосование',
	'securepoll-subpage-translate' => 'Перевод',
	'securepoll-subpage-list' => 'Список',
	'securepoll-subpage-dump' => 'Дамп',
	'securepoll-subpage-tally' => 'Подсчёт',
	'securepoll-tally-title' => 'Подсчёт: $1',
	'securepoll-tally-not-finished' => 'Извините, вы можете производить подсчёт итогов только после завершения голосования.',
	'securepoll-can-decrypt' => 'Запись голоса была зашифрована, но имеется ключ расшифровки.
Вы можете выбрать либо подсчёт текущих результатов в базе данных, либо подсчёт зашифрованных результатов из загруженного файла.',
	'securepoll-tally-no-key' => 'Вы можете не подсчитывать голоса на этих выборах, так как они были зашифрованы, а ключ расшифровки отсутствует.',
	'securepoll-tally-local-legend' => 'Подсчёт сохранённых результатов',
	'securepoll-tally-local-submit' => 'Произвести подсчёт',
	'securepoll-tally-upload-legend' => 'Загрузка зашифрованного дампа',
	'securepoll-tally-upload-submit' => 'Произвести подсчёт',
	'securepoll-tally-error' => 'Ошибка интерпретации записи голоса, невозможно произвести подсчёт.',
	'securepoll-no-upload' => 'Файл не был загружен, невозможно подсчитать результаты.',
	'securepoll-dump-corrupt' => 'Файл дампа повреждён и не может быть обработан.',
	'securepoll-tally-upload-error' => 'Ошибка согласованности файла дампа: $1',
	'securepoll-pairwise-victories' => 'Матрица попарных побед',
	'securepoll-strength-matrix' => 'Матрица сил путей',
	'securepoll-ranks' => 'Окончательное ранжирование',
	'securepoll-average-score' => 'Средняя оценка',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'securepoll' => 'КөмүскэммитКуоластааһын',
	'securepoll-desc' => 'Быыбар уонна ыйытыы ыытарга аналлаах тупсарыы',
	'securepoll-invalid-page' => 'Алҕастаах алын сирэй "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Маны оҥорорго быыбар дьаһабыла буолуоххун наада.',
	'securepoll-too-few-params' => 'Алын сирэй туруоруулара (параметрадара) тиийбэттэр (сыыһа сигэ).',
	'securepoll-invalid-election' => '"$1" быыбар дьиҥнээх нүөмэрэ буолбатах.',
	'securepoll-welcome' => '<strong>Нөрүөн нөргүй, $1!</strong>',
	'securepoll-not-started' => 'Бу быыбар өссө саҕалана илик.
Баччаҕа саҕаланар: $2, $3.',
	'securepoll-finished' => 'Куоластааһын түмүктэммитэ, онон куоластыыр кыах суох.',
	'securepoll-not-qualified' => 'Бу быыбарга куоластыыр кыаҕыҥ суох: $1',
	'securepoll-change-disallowed' => 'Бу быыбарга куолатсаабыт эбиккин.
Баалаама, иккистээн куоластыыр кыаҕыҥ суох.',
	'securepoll-change-allowed' => '<strong>Быһаарыы. Эн урут бу быыбарга куоластаабыт эбиккин.</strong>
Аллара баар фуорманы толорон урут эппиккин уларытыаххын сөп.
Инньэ гыннаххына урукку куоластаабытыҥ аахсыллыа суоҕа.',
	'securepoll-submit' => 'Куолаһы биэрии',
	'securepoll-gpg-receipt' => 'Куолстааһыҥҥа кыттыбытыҥ иһин махтал.

Куолстаабыккын бигэргэтиэххин баҕарар буоллаххына бу устуруокалары бэйэҕэр хаалларыаххын сөп:

<pre>$1</pre>',
	'securepoll-thanks' => 'Махтал, эн куолаһыҥ сурулунна.',
	'securepoll-return' => 'Манна $1 төнүн',
	'securepoll-encrypt-error' => 'Эн куоластаабытын туһунан сурук кыайан оҥоһуллубата.
Эн куолаһыҥ суруллубата!

$1',
	'securepoll-no-gpg-home' => 'GPG дьиэтээҕи каталога оҥоһуллар кыаҕа суох.',
	'securepoll-secret-gpg-error' => 'GPG-ны толорго алҕас таҕыста.
$wgSecurePollShowErrorDetail=true; туруоруутун LocalSettings.php билэҕэ уган бу туһунан сиһилии көр.',
	'securepoll-full-gpg-error' => 'GPG-ны оҥорорго алҕас таҕыста:

Хамаанда:  $1

Алҕас:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG күлүүстэрэ сыыһа туруоруллубуттар.',
	'securepoll-gpg-parse-error' => 'GPG тахсыытыгар ааҕыыга алҕас таҕыста.',
	'securepoll-no-decryption-key' => 'Расшифровка күлүүһэ настройкаламматах.
Расшифровкалыыр табыллыбат.',
	'securepoll-jump' => 'Куоластааһын сиэрбэригэр көһүү',
	'securepoll-bad-ballot-submission' => 'Эн куолаһыҥ ааҕыллыбат: $1',
	'securepoll-unanswered-questions' => 'Бары ыйытыыларга хоруйдуохтааххын.',
	'securepoll-invalid-rank' => 'Рангата алҕастаах. Бииртэн 999 дылы раанганы ыйыахтааххын.',
	'securepoll-unranked-options' => 'Сорохторугар раангаларын нүөмэрэ турбатах.
Барыларыгар бииртэн 999 дылы раанганы туруоруохтааххын.',
	'securepoll-invalid-score' => 'Сыана мантан $1 маныаха дылы $2 чыыһыла буолуохтаах.',
	'securepoll-unanswered-options' => 'Хас биирдии ыйытыкка хоруй биэриэхтээххин.',
	'securepoll-remote-auth-error' => 'Аат-суол туһунан сибидиэнньэлэри сиэрбэртэн ылыыга алҕас таҕыста.',
	'securepoll-remote-parse-error' => 'Сиэрбэртэн авторизацияны сыыһа көрүү буолбутун туһунан хоруй кэллэ.',
	'securepoll-api-invalid-params' => 'Сыыһа туруоруулар.',
	'securepoll-api-no-user' => 'Маннык нүөмэрдээх киһи көстүбэтэ.',
	'securepoll-api-token-mismatch' => 'Куттала суох буолууга сөп түбэспэт буолан тиһиликкэ киирии табыллыбата.',
	'securepoll-not-logged-in' => 'Куоластыаххын баҕарар буоллаххына ааккын этиэххин наада.',
	'securepoll-too-few-edits' => 'Баалаама, куоластыыр кыаҕыҥ суох эбит. Бачча $1 {{PLURAL:$1|көннөрүүнү|көннөрүүлэри}} оҥорбут эрэ дьон куоластыыллар, эн $2 көннөрүүлээххин.',
	'securepoll-blocked' => 'Баалаама, аатыҥ бобуллубут/хааччахтаммыт буоллаҕына куоластыыр кыаҕыҥ суох.',
	'securepoll-bot' => 'Баалаама, руобат былаахтаах кыттааччылар куоластыыр кыахтара суох.',
	'securepoll-not-in-group' => '$1 бөлөххө эрэ киирэр кыттааччылар куоластыыллар.',
	'securepoll-not-in-list' => 'Баалаама, куоластыан сөптөөх кыттааччылар тиһиктэригэр киирбэтэх эбиккин.',
	'securepoll-list-title' => 'Куоластааһын тиһигэ: $1',
	'securepoll-header-timestamp' => 'Кэм',
	'securepoll-header-voter-name' => 'Аат',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Кыттааччы агена',
	'securepoll-header-cookie-dup' => 'Хос',
	'securepoll-header-strike' => 'Сотуу',
	'securepoll-header-details' => 'Сиһилии',
	'securepoll-strike-button' => 'Сот',
	'securepoll-unstrike-button' => 'Сотууну устуу',
	'securepoll-strike-reason' => 'Төрүөтэ:',
	'securepoll-strike-cancel' => 'Төннөрүү',
	'securepoll-strike-error' => 'Сотууга / сотуутун устууга алҕас таҕыста: $1',
	'securepoll-strike-token-mismatch' => 'Сиэссийэ дааннайдара сүттүлэр',
	'securepoll-details-link' => 'Сиһилии',
	'securepoll-details-title' => 'Куоластааһын туһунан сиһилии: #$1',
	'securepoll-invalid-vote' => '"$1" куоластааһын көнүллэммит нүөмэрэ буолбатах',
	'securepoll-header-voter-type' => 'Кыттааччы көрүҥэ',
	'securepoll-voter-properties' => 'Быыбардааччы туруоруута',
	'securepoll-strike-log' => 'Сотуу сурунаала',
	'securepoll-header-action' => 'Дьайыы',
	'securepoll-header-reason' => 'Төрүөтэ',
	'securepoll-header-admin' => 'Дьаһабыл',
	'securepoll-cookie-dup-list' => 'Cookie көмөтүнэн оҥоһуллубут кыттааччылар дубликааттара',
	'securepoll-dump-title' => 'Дамп: $1',
	'securepoll-dump-no-crypt' => 'Быыбар шифрованиены туһанарга туруоруллубатах, онон бу быыбарга кистэммэтэх куоластааһын көҥүллэнэр.',
	'securepoll-dump-not-finished' => 'Куоластааһын хаамыытын быыбар бүппүтүн кэннэ баччаҕа көрүөххүн сөп: $1, $2',
	'securepoll-dump-no-urandom' => '/dev/urandom кыайан аһыллыбат.
Быыбар хаамыытын аһаҕас гыныахха сөп, ол гынан баран ким хайдах куоластаабытын көрдөрбөт туһуттан куоластааччылар бэрээдэктэрин түбэспиччэ чыыһылалары туруоран уларытыллар.',
	'securepoll-urandom-not-supported' => 'Бу сиэрбэр түбэспиччэ чыыһылалары оҥорор криптография генератора суох.
Куоластаабыт дьон кистэлэҥнэрин көмүскүүр соруктаах куоластааһын туһунан куодтаммыт суруктары түбэспиччэ чыыһылалар көмөлөрүнэн буккуллубуттарын эрэ кэннэ уопсай көрүүгэ таһаарыахтара.',
	'securepoll-translate-title' => 'Тылбаас: $1',
	'securepoll-invalid-language' => 'Тыл куода алҕастаах: "$1"',
	'securepoll-submit-translate' => 'Саҥардан биэр',
	'securepoll-language-label' => 'Тылы талыы:',
	'securepoll-submit-select-lang' => 'Тылбаас',
	'securepoll-entry-text' => 'Аллара куоластааһыннар тиһиктэрэ көстөр.',
	'securepoll-header-title' => 'Аат',
	'securepoll-header-start-date' => 'Саҕаланыытын ыйа-күнэ',
	'securepoll-header-end-date' => 'Бүтүүтүн ыйа-күнэ',
	'securepoll-subpage-vote' => 'Куоластааһын',
	'securepoll-subpage-translate' => 'Тылбаас',
	'securepoll-subpage-list' => 'Тиһик',
	'securepoll-subpage-dump' => 'Дамп',
	'securepoll-subpage-tally' => 'Ааҕыы',
	'securepoll-tally-title' => 'Ааҕыы: $1',
	'securepoll-tally-not-finished' => 'Балаама, түмүгү куоластааһын бүттэҕинэ эрэ таһаарыаххын сөп.',
	'securepoll-can-decrypt' => 'Куоластааһын шифрдаммыт, ол гынан баран ону ааҕар күлүүс баар.
Билиҥҥи түмүк ааҕыллыытын талыаххын сөп, ол эбэтэр шифрдаммыт түмүктэрин билэтин хачайдаан ылыаххын сөп.',
	'securepoll-tally-no-key' => 'Бу быыбарга куолаһы ааҕар сатаммат, тоҕо диэтэххэ куоластааһын шифрдаммыт, оттон шифрын күлүүһэ суох.',
	'securepoll-tally-local-legend' => 'Бигэргэтиллибит түмүктэри ааҕыы',
	'securepoll-tally-local-submit' => 'Аах',
	'securepoll-tally-upload-legend' => 'Шифрдаммыт дампы хачайдааһын',
	'securepoll-tally-upload-submit' => 'Куолаһы аах',
	'securepoll-tally-error' => 'Куолас суруллуута алҕастаах буолан куолас ахсаанын ааҕар табыллыбата.',
	'securepoll-no-upload' => 'Билэ хачайдамматах буолан быыбар түмүгүн ааҕар табыллыбата.',
	'securepoll-dump-corrupt' => 'Дамп билэтэ буорту буолбут, онон кыайан ааҕыллыбат.',
	'securepoll-tally-upload-error' => 'Дамп билэтэ сөпсөспөтө: $1',
	'securepoll-pairwise-victories' => 'Пааранан кыайыылар матрицалара',
	'securepoll-ranks' => 'Раанганан бүтэһиктээх наардааһын',
	'securepoll-average-score' => 'Ортоку сыана',
);

/** Sardinian (Sardu)
 * @author Marzedu
 */
$messages['sc'] = array(
	'securepoll-header-voter-name' => 'Nòmene',
	'securepoll-header-title' => 'Nòmene',
);

/** Sicilian (Sicilianu)
 * @author Melos
 */
$messages['scn'] = array(
	'securepoll-list-title' => 'Elencu voti: $1',
	'securepoll-header-voter-name' => 'Nomu',
	'securepoll-header-voter-domain' => 'Dominiu',
	'securepoll-header-ua' => 'Agente utenti',
	'securepoll-strike-button' => 'Annulla stu votu',
	'securepoll-unstrike-button' => 'Elimina annullamentu',
	'securepoll-strike-reason' => 'Mutivu:',
	'securepoll-strike-cancel' => 'Annulla',
	'securepoll-header-action' => 'Azzioni',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'securepoll-thanks' => 'ස්තුතියි,ඔබේ ඡන්දය ‍පටිගත වී ඇත.',
	'securepoll-jump' => 'ඡන්දය දෙන සේවාදායකයට යන්න',
	'securepoll-bad-ballot-submission' => 'ඔබගේ ඡන්දය අවලංගුයි :$1',
	'securepoll-unanswered-questions' => 'ඔබ සියලුම ප්‍රශ්නවලට පිළිතුරු සැපයිය යුතුය.',
	'securepoll-unanswered-options' => 'සෑම ප්‍රශ්නයක් සඳහාම ඔබ ප්‍රතිචාරයක් දිය යුතුය.',
	'securepoll-remote-auth-error' => 'සේවාදායකයෙන් ඔබේ ගිණුම් තොරතුරු ගෙනයෑමේ දෝෂය.',
	'securepoll-remote-parse-error' => 'සේවාදායකයෙන් අවසරදීමේ ප්‍රතිචාරය පහදාදීමේ දෝෂය.',
	'securepoll-api-invalid-params' => 'අවලංගු පරාමිති.',
	'securepoll-not-logged-in' => 'මෙම ඡන්ද විමසීමේදී ඡන්දය දීම සඳහා ඔබ ප්‍රවිෂ්ට විය යුතුය.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Rudko
 */
$messages['sk'] = array(
	'securepoll' => 'Zabezpečené hlasovanie',
	'securepoll-desc' => 'Rozšírenie pre voľby a dotazníky',
	'securepoll-invalid-page' => 'Neplatná podstránka „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Aby ste mohli vykonať túto operáciu musíte byť správca volieb.',
	'securepoll-too-few-params' => 'Nedostatok parametrov podstránky (neplatný odkaz).',
	'securepoll-invalid-election' => '„$1“ nie je platný ID hlasovania.',
	'securepoll-welcome' => '<strong>Vitajte $1!</strong>',
	'securepoll-not-started' => 'Tieto voľby zatiaľ nezačali.
Začiatok je naplánovaný na $2 $3.',
	'securepoll-finished' => 'Toto hlasovanie skončilo. Už nemôžete hlasovať.',
	'securepoll-not-qualified' => 'Nekvalifikujete sa do tohto hlasovania: $1',
	'securepoll-change-disallowed' => 'V tomto hlasovaní ste už hlasovali.
Je mi ľúto, nemôžete znova voliť.',
	'securepoll-change-allowed' => '<strong>Pozn.: V tomto hlasovaní ste už hlasovali.</strong>
Svoj hlas môžete zmeniť zaslaním dolu uvedeného formulára.
Ak tak spravíte, váš pôvodný hlas sa zahodí.',
	'securepoll-submit' => 'Poslať hlas',
	'securepoll-gpg-receipt' => 'Ďakujeme za hlasovanie.

Ak chcete, môžete si ponechať nasledovné potvrdenie ako dôkaz o tom, že ste hlasovali:

<pre>$1</pre>',
	'securepoll-thanks' => 'Ďakujeme, váš hlas bol zaznamenaný.',
	'securepoll-return' => 'Späť na $1',
	'securepoll-encrypt-error' => 'Nepodarilo sa zašifrovať záznam o vašom hlasovaní.
Váš hlas nebol zaznamenaný!

$1',
	'securepoll-no-gpg-home' => 'Chyba pri vytváraní domovského adresára GPG.',
	'securepoll-secret-gpg-error' => 'Chyba pri spúšťaní GPG.
Ďalšie podrobnosti zobrazíte nastavením $wgSecurePollShowErrorDetail=true; v súbore LocalSettings.php.',
	'securepoll-full-gpg-error' => 'Chyba pri súpšťaní GPG:

Príkaz: $1

Chyba:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG kľúče sú nesprávne nakonfigurované.',
	'securepoll-gpg-parse-error' => 'Chyba pri interpretácii výstupu GPG.',
	'securepoll-no-decryption-key' => 'Nie je nakonfigurovaný žiadny dešifrovací kľúč.
Nie je možné dešifrovať.',
	'securepoll-jump' => 'Prejsť na hlasovací server',
	'securepoll-bad-ballot-submission' => 'Váš hlas bol neplatný: $1',
	'securepoll-unanswered-questions' => 'Musíte zodpovedať všetky otázky.',
	'securepoll-invalid-rank' => 'Neplatné hodnotenie. Musíte zadať kandidátov s hodnotením medzi 1 a 999.',
	'securepoll-unranked-options' => 'Niektoré možnosti neboli ohodnotené.
Musíte dať každej možnosti hodnotenie medzi 1 a 999.',
	'securepoll-invalid-score' => 'Skóre musí byť číslo medzi $1 a $2.',
	'securepoll-unanswered-options' => 'Musíte dať odpoveď na každú otázku.',
	'securepoll-remote-auth-error' => 'Pri zisťovaní vašich prihlasovacích informácií zo servera nastala chyba.',
	'securepoll-remote-parse-error' => 'Pri interpretácii odpovede o autorizácii od servera nastala chyba.',
	'securepoll-api-invalid-params' => 'Neplatné parametre.',
	'securepoll-api-no-user' => 'Nebol nájdený žiadny používateľ so zadaným ID.',
	'securepoll-api-token-mismatch' => 'Bezpečnostné identifikátory sa nezhodujú, nie je možné prihlásiť.',
	'securepoll-not-logged-in' => 'Aby ste mohli hlasovať, musíte sa prihlásiť',
	'securepoll-too-few-edits' => 'Prepáčte, nemôžete hlasovať. Aby ste sa mohli zúčastniť tohto hlasovania, museli by ste mať aspoň $1 {{PLURAL:$1|úpravu|úpravy|úprav}}. Máte $2 {{PLURAL:$2|úpravu|úpravy|úprav}}.',
	'securepoll-blocked' => 'Prepáčte, tohto hlasovania sa nemôžete zúčastniť, pretože ste momentálne zablokovaný.',
	'securepoll-bot' => 'Ľutujem, účty s príznakom bot nemôžu v tomto hlasovaní hlasovať.',
	'securepoll-not-in-group' => 'Tohto hlasovania sa môžu zúčastniť iba členovia skuupiny $1.',
	'securepoll-not-in-list' => 'Prepáčte, nenáchádzate sa na vopred určenom zozname používateľov oprávnených zúčastniť sa tohto hlasovania.',
	'securepoll-list-title' => 'Zoznam hlasov: $1',
	'securepoll-header-timestamp' => 'Čas',
	'securepoll-header-voter-name' => 'Meno',
	'securepoll-header-voter-domain' => 'Doména',
	'securepoll-header-ua' => 'Prehliadač',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Škrtnúť',
	'securepoll-header-details' => 'Podrobnosti',
	'securepoll-strike-button' => 'Škrtnúť',
	'securepoll-unstrike-button' => 'Zrušiť škrtnutie',
	'securepoll-strike-reason' => 'Dôvod:',
	'securepoll-strike-cancel' => 'Zrušiť',
	'securepoll-strike-error' => 'Chyba operácie škrtnutie/zrušenie škrtnutia: $1',
	'securepoll-strike-token-mismatch' => 'Údaje o relácii boli stratené',
	'securepoll-details-link' => 'Podrobnosti',
	'securepoll-details-title' => 'Podrobnosti hlasovania: #$1',
	'securepoll-invalid-vote' => '„$1“ nie je platný ID hlasovania',
	'securepoll-header-voter-type' => 'Typ hlasujúceho',
	'securepoll-voter-properties' => 'Vlastnosti hlasujúceho',
	'securepoll-strike-log' => 'Záznam škrtnutí',
	'securepoll-header-action' => 'Operácia',
	'securepoll-header-reason' => 'Dôvod',
	'securepoll-header-admin' => 'Správca',
	'securepoll-cookie-dup-list' => 'Cookie duplicitným používateľom',
	'securepoll-dump-title' => 'Výpis: $1',
	'securepoll-dump-no-crypt' => 'Pre tieto voľby nie je dostupný žiadny šifrovaný záznam o voľbách, pretože nebolo nastavené aby tieto voľby používali šifrovanie.',
	'securepoll-dump-not-finished' => 'Šifrované záznamy o voľbách sú dostupné len po dátume ich skončenia: $1 $2',
	'securepoll-dump-no-urandom' => 'Nie je možné otvoriť /dev/urandom.
Aby bola zabezpečená anonymita hlasujúceho, šifrované záznamy o voľbách sú dostupné verejne len keď bôžu byť zamiešané náhodným tokom čísel.',
	'securepoll-urandom-not-supported' => 'Tento server nepodporuje tvorbu kryptograficky náhodných čísiel.
Aby sa zachovalo súkromie hlasujúcich, šifrovaný záznam o voľbách je verejne dostupný iba keď ho možno kryptograficky zabezpečiť tokom náhodných čísiel.',
	'securepoll-translate-title' => 'Preložiť: $1',
	'securepoll-invalid-language' => 'Neplatný kód jazyka „$1“',
	'securepoll-submit-translate' => 'Aktualizovať',
	'securepoll-language-label' => 'Vyberte jazyk:',
	'securepoll-submit-select-lang' => 'Preložiť',
	'securepoll-entry-text' => 'Dolu je zoznam hlasovaní.',
	'securepoll-header-title' => 'Meno',
	'securepoll-header-start-date' => 'Dátum začiatku',
	'securepoll-header-end-date' => 'Dátum ukončenia',
	'securepoll-subpage-vote' => 'Hlasovať',
	'securepoll-subpage-translate' => 'Preložiť',
	'securepoll-subpage-list' => 'Zoznam',
	'securepoll-subpage-dump' => 'Výpis',
	'securepoll-subpage-tally' => 'Zistiť výsledok',
	'securepoll-tally-title' => 'Zistiť výsledok: $1',
	'securepoll-tally-not-finished' => 'Ľutujem, nemôžete zistiť výsledok hlasovania, kým nebude dokončené.',
	'securepoll-can-decrypt' => 'Záznam o hlasovaní bol zašifrovaný, ale dešifrovací kľúč je k dispozícii.
Môžete buď zistiť výsledok hlasovania z výsledkov dostupných v databáze alebo zo zašifrovaných výsledkov v nahranom súbore.',
	'securepoll-tally-no-key' => 'Nemôžete zistiť výsledok hlasovania, pretože hlasy sú zašifrované a dešifrovací kľúč nie je k dispozícii.',
	'securepoll-tally-local-legend' => 'Zistiť výsledok uložených hlasov',
	'securepoll-tally-local-submit' => 'Vytvoriť vyhodnotenie',
	'securepoll-tally-upload-legend' => 'Nahrať zašifrovaný výpis',
	'securepoll-tally-upload-submit' => 'Vytvoriť vyhodnotenie',
	'securepoll-tally-error' => 'Chyba pri interpretácii záznamu o hlasovaní, nemožno vyhodnotiť hlasovanie.',
	'securepoll-no-upload' => 'Nebol nahraný súbor, nemožno vyhodnotiť hlasovanie.',
	'securepoll-dump-corrupt' => 'Súbor s výpisom je poškodený a nemožno ho spracovať.',
	'securepoll-tally-upload-error' => 'Chyba pri kontrole súboru výpisu: $1',
	'securepoll-pairwise-victories' => 'Párová matica víťazstiev',
	'securepoll-strength-matrix' => 'Párová matica sily',
	'securepoll-ranks' => 'Finálne hodnotenie',
	'securepoll-average-score' => 'Priemerné skóre',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'securepoll-desc' => 'Екстензија за изборе и анкете',
	'securepoll-invalid-page' => 'Немогућа подстрана „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Морате бити администратор да бисте извели ову акцију.',
	'securepoll-too-few-params' => 'Недовољно параметара подстране (неисправна веза).',
	'securepoll-invalid-election' => '„$1“ није валидан ID за изборе.',
	'securepoll-welcome' => '<strong>Добро дошли, $1!</strong>',
	'securepoll-not-started' => 'Ово су избори, који још увек нису почели.
Почетак је планиран за $2 у $3.',
	'securepoll-finished' => 'Ови избори су завршени. Не можете више да гласате.',
	'securepoll-not-qualified' => 'Не квалификујете се за гласача у овим изборима: $1',
	'securepoll-change-disallowed' => 'Већ сте гласали на овим изборима.
Жао нам је, не можете да гласате опет.',
	'securepoll-submit' => 'Пошаљи глас',
	'securepoll-thanks' => 'Хвала Вам. Ваш глас је снимљен.',
	'securepoll-return' => 'Врати се на $1',
	'securepoll-gpg-config-error' => 'GPG кључеви су погрешно подешени.',
	'securepoll-gpg-parse-error' => 'Грешка приликом интерпретације GPG излаза.',
	'securepoll-jump' => 'Иди на сервер за гласање',
	'securepoll-bad-ballot-submission' => 'Ваш глас је неисправан: $1',
	'securepoll-unanswered-questions' => 'Морате одговорити на сва питања.',
	'securepoll-invalid-rank' => 'Погрешно рангирање. Кнадидате можете рангирати бројевима између 1 и 999.',
	'securepoll-remote-auth-error' => 'Грешка приликом преузимања информација о Вашем налогу са сервера.',
	'securepoll-api-invalid-params' => 'Погрешни параметри.',
	'securepoll-api-no-user' => 'Није нађен корисник са датим ID.',
	'securepoll-not-logged-in' => 'Морате се улоговати да бисте гласали на овим изборима',
	'securepoll-list-title' => 'Прикажи гласове: $1',
	'securepoll-header-timestamp' => 'Време',
	'securepoll-header-voter-name' => 'Име',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Кориснички клијент',
	'securepoll-header-details' => 'Појединости',
	'securepoll-strike-reason' => 'Разлог:',
	'securepoll-strike-cancel' => 'Поништи',
	'securepoll-strike-token-mismatch' => 'Изгубљени подаци о сесији',
	'securepoll-details-link' => 'Појединости',
	'securepoll-details-title' => 'Појединости о гласу: #$1',
	'securepoll-invalid-vote' => '„$1“ није валидан ID за гласање',
	'securepoll-header-voter-type' => 'Тип гласача',
	'securepoll-header-action' => 'Акција',
	'securepoll-header-reason' => 'Разлог',
	'securepoll-header-admin' => 'Админ',
	'securepoll-cookie-dup-list' => 'Корисници са дупликатима колачића',
	'securepoll-dump-title' => 'Дамп: $1',
	'securepoll-translate-title' => 'Преведи: $1',
	'securepoll-invalid-language' => 'Непрепознатљив код језика: „$1“',
	'securepoll-submit-translate' => 'Ажурирај',
	'securepoll-language-label' => 'Изабери језик:',
	'securepoll-submit-select-lang' => 'Преведи',
	'securepoll-header-title' => 'Име',
	'securepoll-header-start-date' => 'Датум почетка',
	'securepoll-header-end-date' => 'Датум краја',
	'securepoll-subpage-vote' => 'Глас',
	'securepoll-subpage-translate' => 'Преведи',
	'securepoll-subpage-list' => 'Списак',
	'securepoll-subpage-dump' => 'Дамп',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'securepoll-desc' => 'Ekstenzija za izbore i ankete',
	'securepoll-invalid-page' => 'Nemoguća podstrana „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Morate biti administrator da biste izveli ovu akciju.',
	'securepoll-too-few-params' => 'Nedovoljno parametara podstrane (neispravna veza).',
	'securepoll-invalid-election' => '„$1“ nije validan ID za izbore.',
	'securepoll-welcome' => '<strong>Dobro došli, $1!</strong>',
	'securepoll-not-started' => 'Ovo su izbori, koji još uvek nisu počeli.
Početak je planiran za $2 u $3.',
	'securepoll-finished' => 'Ovi izbori su završeni. Ne možete više da glasate.',
	'securepoll-not-qualified' => 'Ne kvalifikujete se za glasača u ovim izborima: $1',
	'securepoll-change-disallowed' => 'Već ste glasali na ovim izborima.
Žao nam je, ne možete da glasate opet.',
	'securepoll-submit' => 'Pošalji glas',
	'securepoll-thanks' => 'Hvala Vam. Vaš glas je snimljen.',
	'securepoll-return' => 'Vrati se na $1',
	'securepoll-gpg-config-error' => 'GPG ključevi su pogrešno podešeni.',
	'securepoll-gpg-parse-error' => 'Greška prilikom interpretacije GPG izlaza.',
	'securepoll-jump' => 'Idi na server za glasanje',
	'securepoll-bad-ballot-submission' => 'Vaš glas je neispravan: $1',
	'securepoll-unanswered-questions' => 'Morate odgovoriti na sva pitanja.',
	'securepoll-invalid-rank' => 'Pogrešno rangiranje. Knadidate možete rangirati brojevima između 1 i 999.',
	'securepoll-remote-auth-error' => 'Greška prilikom preuzimanja informacija o Vašem nalogu sa servera.',
	'securepoll-api-invalid-params' => 'Pogrešni parametri.',
	'securepoll-api-no-user' => 'Nije nađen korisnik sa datim ID.',
	'securepoll-not-logged-in' => 'Morate se ulogovati da biste glasali na ovim izborima',
	'securepoll-list-title' => 'Prikaži glasove: $1',
	'securepoll-header-timestamp' => 'Vreme',
	'securepoll-header-voter-name' => 'Ime',
	'securepoll-header-voter-domain' => 'Domen',
	'securepoll-header-ua' => 'Korisnički klijent',
	'securepoll-header-details' => 'Pojedinosti',
	'securepoll-strike-reason' => 'Razlog:',
	'securepoll-strike-cancel' => 'Poništi',
	'securepoll-strike-token-mismatch' => 'Izgubljeni podaci o sesiji',
	'securepoll-details-link' => 'Pojedinosti',
	'securepoll-details-title' => 'Pojedinosti o glasu: #$1',
	'securepoll-invalid-vote' => '„$1“ nije validan ID za glasanje',
	'securepoll-header-voter-type' => 'Tip glasača',
	'securepoll-header-action' => 'Akcija',
	'securepoll-header-reason' => 'Razlog',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Korisnici sa duplikatima kolačića',
	'securepoll-dump-title' => 'Damp: $1',
	'securepoll-translate-title' => 'Prevedi: $1',
	'securepoll-invalid-language' => 'Neprepoznatljiv kod jezika: „$1“',
	'securepoll-submit-translate' => 'Ažuriraj',
	'securepoll-language-label' => 'Izaberi jezik:',
	'securepoll-submit-select-lang' => 'Prevedi',
	'securepoll-header-title' => 'Ime',
	'securepoll-header-start-date' => 'Datum početka',
	'securepoll-header-end-date' => 'Datum kraja',
	'securepoll-subpage-vote' => 'Glas',
	'securepoll-subpage-translate' => 'Prevedi',
	'securepoll-subpage-list' => 'Spisak',
	'securepoll-subpage-dump' => 'Damp',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'securepoll-strike-reason' => 'Alesan:',
	'securepoll-header-reason' => 'Alesan',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Fluff
 * @author Gabbe.g
 * @author Micke
 * @author Najami
 * @author Per
 * @author Poxnar
 * @author StefanB
 */
$messages['sv'] = array(
	'securepoll' => 'SäkerOmröstning',
	'securepoll-desc' => 'Ett programtillägg för omröstningar och enkäter',
	'securepoll-invalid-page' => 'Ogiltig undersida "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Du måste vara valadministratör för att kunna utföra denna handling.',
	'securepoll-too-few-params' => 'Ej tillräckligt många undersideparametrar (ogiltig länk).',
	'securepoll-invalid-election' => '"$1" är inte ett giltigt omröstnings-ID.',
	'securepoll-welcome' => '<strong>Välkommen $1!</strong>',
	'securepoll-not-started' => 'Den här omröstningen är inte startat ännu.
Den planeras starta den $2 kl $3.',
	'securepoll-finished' => 'Valet är avslutat, så du kan inte längre rösta.',
	'securepoll-not-qualified' => 'Du är inte kvalificerad att rösta i den här omröstningen: $1',
	'securepoll-change-disallowed' => 'Du har redan deltagit i den här omröstningen.
Du kan tyvärr inte rösta igen.',
	'securepoll-change-allowed' => '<strong>Observera att du redan har röstat i den här omröstningen.</strong>
Du kan ändra din röst genom att skicka in formuläret nedan.
Observera att om du gör det här, kommer din ursprungliga röst att slängas.',
	'securepoll-submit' => 'Spara röst',
	'securepoll-gpg-receipt' => 'Tack för din röst.

Om du vill kan du behålla följande kvitto som ett bevis på din röst:

<pre>$1</pre>',
	'securepoll-thanks' => 'Tack, din röst har registrerats.',
	'securepoll-return' => 'Tillbaka till $1',
	'securepoll-encrypt-error' => 'Misslyckades att kryptera din röst.
Din röst har inte registrerats!

$1',
	'securepoll-no-gpg-home' => 'Kunde inte skapa en GPG-hemkatalog.',
	'securepoll-secret-gpg-error' => 'Ett fel uppstod när GPG exekverades.
Använd $wgSecurePollShowErrorDetail=true; i LocalSettings.php för mer information.',
	'securepoll-full-gpg-error' => 'Ett fel uppstod när GPG exekverades:

Kommando: $1

Fel:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-nycklar har kofigurerats fel.',
	'securepoll-gpg-parse-error' => 'Ett fel uppstod när GPG-utdatan interpreterades.',
	'securepoll-no-decryption-key' => 'Ingen dekrypteringsnyckel är konfigurerad.
Kan inte dekryptera.',
	'securepoll-jump' => 'Gå till röstnings-servern.',
	'securepoll-bad-ballot-submission' => 'Din röst var ogiltig: $1',
	'securepoll-unanswered-questions' => 'Du måste svara på alla frågor.',
	'securepoll-invalid-rank' => 'Ogiltig rangordning. Du måste rangordna kandidater mellan 1 och 999.',
	'securepoll-unranked-options' => 'Något eller några valmöjligheter rangordnades inte.
Du måste rangordna alla valmöjligheter mellan 1 och 999.',
	'securepoll-invalid-score' => 'Betyget måste vara ett tal mellan $1 och $2.',
	'securepoll-unanswered-options' => 'Du måste ge ett svar på varje fråga.',
	'securepoll-remote-auth-error' => 'Fel uppstod vid hämtning av din kontoinformation från servern.',
	'securepoll-remote-parse-error' => 'Fel uppstod vid tolkning av auktorisationssvar från servern.',
	'securepoll-api-invalid-params' => 'Felaktig parameter.',
	'securepoll-api-no-user' => 'Ingen användare hittades med det angivna ID:t.',
	'securepoll-api-token-mismatch' => 'Säkerhetsnyckel saknas, kan inte logga in.',
	'securepoll-not-logged-in' => 'Du måste logga in för att kunna rösta i det här valet.',
	'securepoll-too-few-edits' => 'Ledsen, men du kan inte rösta. Du måste ha minst $1 {{PLURAL:$1|redigering|redigeringar}} för att rösta i det här valet. Du har gjort $2 {{PLURAL:$2|redigering|redigeringar}}.',
	'securepoll-blocked' => 'Ledsen, men du kan inte rösta om du är blockerad från redigering.',
	'securepoll-bot' => 'Tyvärr, konton med botflaga tillåts inte att rösta i denna omröstning.',
	'securepoll-not-in-group' => 'Endast meddlemmar i gruppen "$1" kan rösta i denna omröstning.',
	'securepoll-not-in-list' => 'Du ligger tyvärr inte på listan över användare som kan rösta i den här omröstningen.',
	'securepoll-list-title' => 'Visa röster: $1',
	'securepoll-header-timestamp' => 'Tid',
	'securepoll-header-voter-name' => 'Namn',
	'securepoll-header-voter-domain' => 'Domän',
	'securepoll-header-ua' => 'Användaragent',
	'securepoll-header-cookie-dup' => 'Dubblett',
	'securepoll-header-strike' => 'Stryk',
	'securepoll-header-details' => 'Detaljer',
	'securepoll-strike-button' => 'Stryk',
	'securepoll-unstrike-button' => 'Ta bort strykningen',
	'securepoll-strike-reason' => 'Anledning:',
	'securepoll-strike-cancel' => 'Avbryt',
	'securepoll-strike-error' => 'Fel vid borttagning eller upphävning av borttagning: $1',
	'securepoll-strike-token-mismatch' => 'Tappade sessionsdata',
	'securepoll-details-link' => 'Detaljer',
	'securepoll-details-title' => 'Röstningsdetaljer: #$1',
	'securepoll-invalid-vote' => '"$1" är inte en giltig röst.',
	'securepoll-header-voter-type' => 'Röstningstyp',
	'securepoll-voter-properties' => 'Väljaregenskaper',
	'securepoll-strike-log' => 'Borttagningslogg',
	'securepoll-header-action' => 'Åtgärd',
	'securepoll-header-reason' => 'Anledning',
	'securepoll-header-admin' => 'Administratör',
	'securepoll-cookie-dup-list' => 'Cookie dubblettanvändare',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Ingen krypterad valregistrering finns tillgänglig för den här omröstningen, på grund av att omröstningen inte har konfigurerats att använda kryptering.',
	'securepoll-dump-not-finished' => 'Krypterade valregister finns endast tillgängliga efter avslutandet den $1 klockan $2',
	'securepoll-dump-no-urandom' => 'Kan inte öppna /dev/urandom.
För att säkra en hemlig omröstning är de krypterade valregisterna endast tillgängliga offentligt när de kan blandas av en säker ström av tillfälliga tal.',
	'securepoll-urandom-not-supported' => 'Den här servern har inte stöd för att generera slumpmässiga tal för kryptering. 
För att säkerställa väljarnas integritet så kan krypterade valresultat enbart göras allmänt tillgängliga om de kan blandas med en säker slumptalsgenerator.',
	'securepoll-translate-title' => 'Översätt: $1',
	'securepoll-invalid-language' => 'Felaktig språkkod "$1"',
	'securepoll-submit-translate' => 'Uppdatera',
	'securepoll-language-label' => 'Välj språk:',
	'securepoll-submit-select-lang' => 'Översätt',
	'securepoll-entry-text' => 'Nedan finns listan över omröstningar.',
	'securepoll-header-title' => 'Namn',
	'securepoll-header-start-date' => 'Startdatum',
	'securepoll-header-end-date' => 'Slutdatum',
	'securepoll-subpage-vote' => 'Rösta',
	'securepoll-subpage-translate' => 'Översätt',
	'securepoll-subpage-list' => 'Listning',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Uppräkning',
	'securepoll-tally-title' => 'Uppräkning: $1',
	'securepoll-tally-not-finished' => 'Beklagar, du kan inte räkna upp valresultatet innan omröstningen är slutförd.',
	'securepoll-can-decrypt' => 'Valregistret har krypterats, men dekrypteringsnyckeln finns tillgänglig.
Du kan välja att antingen räkna upp resultaten som finns tillgängliga i databasen eller räkna upp de krypterade resultaten från en uppladdad fil.',
	'securepoll-tally-no-key' => 'Du kan inte kontrollräkna det här valet eftersom rösterna är krypterade, och det finns ingen tillgänglig nyckel för att dekryptera dem.',
	'securepoll-tally-local-legend' => 'Kontrollräkna lagrat resultat.',
	'securepoll-tally-local-submit' => 'Skapa rösträkning',
	'securepoll-tally-upload-legend' => 'Ladda upp krypterad dump.',
	'securepoll-tally-upload-submit' => 'Skapa rösträkning',
	'securepoll-tally-error' => 'Fel vid läsning av röstlängd, kan inte skapa rösträkning.',
	'securepoll-no-upload' => 'Ingen fil laddades upp, kan inte räkna fram ett resultat.',
	'securepoll-dump-corrupt' => 'Dumpningsfilen är korrupt och kan inte bearbetas.',
	'securepoll-tally-upload-error' => 'Fel vid rösträkning av dumpfil: $1',
	'securepoll-pairwise-victories' => 'Matris över parvis vinnare',
	'securepoll-strength-matrix' => 'Matris över vägstyrka',
	'securepoll-ranks' => 'Slutgilltig rankning',
	'securepoll-average-score' => 'Genomsnittligt betyg',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'securepoll' => 'సంరక్షితఎన్నిక',
	'securepoll-desc' => 'ఎన్నికలకు, సర్వేలకు పొడగింపు',
	'securepoll-invalid-page' => 'తప్పుడు ఉపపేజీ "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'ఈ పని పూర్తి చేయటకు మీరు ఎన్నికల అధికారి అయి వుండాలి.',
	'securepoll-invalid-election' => '"$1" అన్నది సరైన ఎన్నిక గుర్తింపు కాదు.',
	'securepoll-welcome' => '<strong>స్వాగతం $1!</strong>',
	'securepoll-not-started' => 'ఈ ఎన్నిక ఇంకా మొదలు అవ్వలేదు. 
$2 న, $3 లకు మోదలు అవుతుంది',
	'securepoll-finished' => 'ఈ ఎన్నిక పూర్తి అయినది. 
తమరు ఇంక వోటు వేయలేరు.',
	'securepoll-not-qualified' => 'తమరికి ఈ ఎన్నికలలో వుతూ వినియోగించుకునే అర్హత లేదు: $1',
	'securepoll-change-disallowed' => 'తమరు ఇదివరకే ఈ ఎన్నికలలో వోటు వేసారు.
క్షమించండి, తమరు మళ్లీ వోటు వేయలేరు.',
	'securepoll-change-allowed' => '<strong>తమరు ఇదివరకే ఈ ఎన్నికలలో వోటు వేసారు.</strong>
తమ వోటుని మార్చుకోవడానికి క్రింది ఫాంను పూర్తి చేసి పంపండి. 
గుర్తుంచుకోండి, కొత్త ఫాంను పంపిస్తే,తమ పాత వోటుకి విలువ వుండదు.',
	'securepoll-submit' => 'వోటు వేయి',
	'securepoll-gpg-receipt' => 'వోటు వేసినందుకు ధన్యవాదాలు. మీకు అవసరము అనుకుంటే, క్రింది రసీదుని మీ వోటుకి గుర్తుగా భద్రపరచుకోండి. 
<pre>$1</pre>',
	'securepoll-thanks' => 'ధన్యవాదాలు! మీ వోటుని భద్రపరచడమైనది.',
	'securepoll-return' => 'తిరిగి $1కి',
	'securepoll-jump' => 'వోటింగ్ సర్వరుకు వెళ్ళుము',
	'securepoll-bad-ballot-submission' => 'మీ వోటు చెల్లదు: $1',
	'securepoll-unanswered-questions' => 'మీరు అన్ని ప్రశ్నలకి సమాధానము ఇవ్వవలెను.',
	'securepoll-invalid-rank' => 'చెల్లని ర్యాంకు. మీరు అభ్యర్ధులకి రాంకులని 1 మరియు 999 మధ్యలో ఇవ్వాలి.',
	'securepoll-unranked-options' => 'కొన్ని వికల్పాలకి మీరు ర్యాంకులు ఇవ్వలేదు.
మీరు తప్పనిసరిగా అన్ని వికల్పాలకీ 1 మరియు 999 మధ్యలో ఒక ర్యాంకుని ఇవ్వాలి.',
	'securepoll-invalid-score' => 'స్కోరు తప్పనిసరిగా $1 మరియు $2 ల మధ్యనున్న సంఖ్య అయివుండాలి.',
	'securepoll-unanswered-options' => 'మీరు తప్పనిసరిగా ప్రతీ ప్రశ్నకీ ఒక స్పందనని ఇవ్వాలి.',
	'securepoll-remote-auth-error' => 'మీ ఖాతా సమాచారాన్ని సేవకి నుండి తేవడంలో పొరపాటు జరిగింది.',
	'securepoll-api-no-user' => 'ఇచ్చిన IDతో వాడుకరులు ఎవరూ లేరు.',
	'securepoll-not-logged-in' => 'ఈ ఎన్నికలో తమ వోటు హక్కును వినియోగించుకునేందుకు తమరు లోనికి ప్రవేశించి ఉండాలి',
	'securepoll-too-few-edits' => 'క్షమించండి, తమరు వోటు వేయలేరు. ఈ ఎన్నికలో వోటు వేసేందుకు తమరు కనీసము $1 {{PLURAL:$1|మార్పు|మార్పులు}} చేసివుండాలి, కాని తమరు $2 చేసారు.',
	'securepoll-blocked' => 'క్షమించండి, మిమ్మల్ని మార్చడం నుండి నిరోధించినందున మీరు ఈ ఎన్నికలో వోటు వేయలేరు.',
	'securepoll-bot' => 'క్షమించండి, బాటు గుర్తుతో ఉన్న ఖాతాలకు ఈ ఎన్నికలో వోటేయడానికి అనుమతి లేదు.',
	'securepoll-not-in-group' => 'ఈ ఎన్నికలలో "$1" గుంపు యొక్క సభ్యులు మాత్రమే వోటువేయగలరు.',
	'securepoll-not-in-list' => 'క్షమించండి, ఈ ఎన్నికలో వోటేయడానికి ముందే నిర్ణయించిన అధీకృత వాడుకరుల జాబితాలో మీరు లేరు.',
	'securepoll-list-title' => 'వోట్లను చూపించు: $1',
	'securepoll-header-timestamp' => 'సమయం',
	'securepoll-header-voter-name' => 'పేరు',
	'securepoll-header-voter-domain' => 'డొమైన్',
	'securepoll-header-ua' => 'వాడుకరి తరుపు ఏజంటు',
	'securepoll-header-cookie-dup' => 'నకలు',
	'securepoll-header-strike' => 'కొట్టివేయి',
	'securepoll-header-details' => 'వివరాలు',
	'securepoll-strike-button' => 'కొట్టివేయి',
	'securepoll-unstrike-button' => 'కొట్టివేత తుడుపు',
	'securepoll-strike-reason' => 'కారణం:',
	'securepoll-strike-cancel' => 'రద్దు',
	'securepoll-details-link' => 'వివరాలు',
	'securepoll-details-title' => 'వోటు వివరాలు: #$1',
	'securepoll-invalid-vote' => '"$1" అనేది సరైన వోటు ID కాదు',
	'securepoll-header-voter-type' => 'వోటర్ టైపు',
	'securepoll-voter-properties' => 'వోటరు లక్షణాలు',
	'securepoll-strike-log' => 'కొట్టివేతల చిట్టా',
	'securepoll-header-action' => 'చర్య',
	'securepoll-header-reason' => 'కారణం',
	'securepoll-header-admin' => 'నిర్వహణాధికారి',
	'securepoll-translate-title' => 'అనువదించు: $1',
	'securepoll-invalid-language' => 'తప్పుడు భాషా సంకేతం "$1"',
	'securepoll-submit-translate' => 'అప్డేట్',
	'securepoll-language-label' => 'భాషను ఎన్నుకో:',
	'securepoll-submit-select-lang' => 'అనువదించు',
	'securepoll-header-title' => 'పేరు',
	'securepoll-header-start-date' => 'ఆరంభ తేదీ',
	'securepoll-header-end-date' => 'ముగింపు తేదీ',
	'securepoll-subpage-vote' => 'వోటు',
	'securepoll-subpage-translate' => 'అనువదించు',
	'securepoll-subpage-list' => 'జాబితా',
	'securepoll-subpage-tally' => 'సరిచూడు',
	'securepoll-tally-title' => 'సరిచూడు: $1',
	'securepoll-tally-not-finished' => 'క్షమించండి, వోటింగు పూర్తి అయ్యే దాకా ఎన్నికను సరిచూడలేరు.',
	'securepoll-tally-local-legend' => 'భద్రపరిచిన ఫలితాలను సరిచూడు',
	'securepoll-tally-error' => 'వోటు రికార్డును అర్ధం చేసుకోవదములో తప్పు దొర్లినది, లెక్కలను సరిచూడలేము.',
	'securepoll-no-upload' => 'ఫైల్ ఏమి అప్లోడ్ అవ్వబడలేదు, ఫలితాలను సరి చూడలేము.',
	'securepoll-ranks' => 'అంతిమ మూల్యాంకనం',
	'securepoll-average-score' => 'సగటు స్కోరు',
);

/** Thai (ไทย)
 * @author Ans
 * @author Octahedron80
 * @author Passawuth
 * @author Watcharakorn
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'securepoll' => 'การลงคะแนนลับ',
	'securepoll-desc' => 'ส่วนขยายสำหรับการลงคะแนนและการสำรวจ',
	'securepoll-invalid-page' => 'ไม่มีหน้าย่อย "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'คุณต้องเป็นผู้ดูแลระบบการเลือกตั้งในการกระทำสิ่งนี้',
	'securepoll-too-few-params' => 'พารามิเตอร์ของหน้าย่อยไม่เพียงพอ (ไม่มีลิงก์ดังกล่าว)',
	'securepoll-invalid-election' => '"$1" ไม่ใช่ไอดีลงคะแนนที่ถูกต้อง',
	'securepoll-welcome' => '<strong>ยินดีต้อนรับ $1!</strong>',
	'securepoll-not-started' => 'การลงคะแนนครั้งนี้ยังไม่เริ่มเปิดลงคะแนน
การลงคะแนนจะเริ่มในวันที่ $2 เวลา $3',
	'securepoll-finished' => 'การเลือกตั้งเสร็จสิ้นแล้ว คุณไม่สามารถลงคะแนนได้อีก',
	'securepoll-not-qualified' => 'คุณไม่มีสิทธิ์ในการลงคะแนนในการเลือกตั้งดังนี้: $1',
	'securepoll-change-disallowed' => 'คุณเคยทำการออกเสียงในการลงคะแนนครั้งนี้ไปแล้ว
ขออภัย คุณไม่สามารถออกเสียงใหม่ได้อีก',
	'securepoll-change-allowed' => '<strong>หมายเหตุ: คุณเคยทำการออกเสียงในการลงคะแนนครั้งนี้ไปแล้ว</strong>
คุณสามารถเปลี่ยนคะแนนเสียงได้โดยการเลือกจากแบบฟอร์มด้านล่าง
หากคุณกระทำเช่นนี้ คะแนนเสียงเดิมของคุณจะไม่ถูกนำมาพิจารณา',
	'securepoll-submit' => 'ยอมรับการออกเสียง',
	'securepoll-gpg-receipt' => 'ขอขอบคุณสำหรับการลงคะแนน

คุณสามารถเก็บใบเสร็จด้านล่างนี้ไว้เป็นหลักฐานการลงคะแนนตามต้องการ

<pre>$1</pre>',
	'securepoll-thanks' => 'ขอบคุณ, คะแนนเสียงของคุณได้รับการบันทึกแล้ว',
	'securepoll-return' => 'ย้อนกลับไปยัง $1',
	'securepoll-encrypt-error' => 'การเข้ารหัสในการบันทึกการลงคะแนนของคุณล้มเหลว
การลงคะแนนของคุณยังไม่ได้ถูกบันทึก!

$1',
	'securepoll-no-gpg-home' => 'ไม่สามารถสร้างไดเร็กทอรีหลักของ GPG ได้',
	'securepoll-secret-gpg-error' => 'เกิดความผิดพลาดในการเข้าถึง GPG
กรุณาใช้ $wgSecurePollShowErrorDetail=true; ใน LocalSettings.php เพิ่อแสดงรายละเอียดเพิ่มเติม',
	'securepoll-full-gpg-error' => 'เกิดความผิดพลาดในการเข้าถึง GPG:

คำสั่ง: $1

ความผิดพลาด:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'รหัสกุญแจของ GPG ไม่ได้ถูกตั้งค่าอย่างถูกต้อง',
	'securepoll-gpg-parse-error' => 'ผิดพลาดในการแปลรหัส GPG ขาออก',
	'securepoll-no-decryption-key' => 'ไม่ได้ตั้งค่ากุญแจถอดรหัสไว้
ไม่สามารถถอดรหัสได้',
	'securepoll-jump' => 'ไปยังเซิร์ฟเวอร์ลงคะแนน',
	'securepoll-bad-ballot-submission' => 'การลงคะแนนของคุณไม่ถูกต้อง: $1',
	'securepoll-unanswered-questions' => 'คุณต้องตอบคำถามให้ครบทุกข้อ',
	'securepoll-invalid-rank' => 'เรียงอันดับไม่ถูกต้อง คุณต้องให้อันดับแก่ผู้สมัครตั้งแต่ 1 ถึง 999',
	'securepoll-unranked-options' => 'ตัวเลือกบางอย่างไม่ได้ถูกจัดอันดับ
คุณต้องจัดอันดับตัวเลือกทุกตัวระหว่าง 1 ถึง 999',
	'securepoll-invalid-score' => 'คะแนนต้องเป็นตัวเลขระหว่าง $1 และ $2',
	'securepoll-unanswered-options' => 'คุณต้องตอบคำถามทุกข้อ',
	'securepoll-remote-auth-error' => 'เิกิดความผิดพลา่ดในการดึงข้อมูลของชื่อบัญชีของคุณจากเซิร์ฟเวอร์',
	'securepoll-remote-parse-error' => 'ผิดพลาดในการแปลข้อมูลการอนุญาตตอบกลับจากเซิร์ฟเวอร์',
	'securepoll-api-invalid-params' => 'ค่าตัวแปรไม่ถูกต้อง',
	'securepoll-api-no-user' => 'ไม่พบผู้ใช้ที่มีรหัส ID ที่กำหนด',
	'securepoll-api-token-mismatch' => 'รหัสรักษาความปลอดภัยไม่ตรงกัน ไม่สามารถลงชื่อเข้าใช้ได้',
	'securepoll-not-logged-in' => 'คุณต้องลงชื่อเข้าระบบเพื่อลงคะแนนในการเลือกตั้งครั้งนี้',
	'securepoll-too-few-edits' => 'ขออภัย คุณไม่สามารถลงคะแนนได้ คุณต้องเข้าร่วมแก้ไขอย่างน้อย $1 ครั้ง จึงจะสามารถเข้าร่่วมลงคะแนนในการเลือกตั้งครั้งนี้ได้ ซึ่งที่ผ่านมาคุณได้เข้าร่วมแก้ไขจำนวน $2 ครั้ง',
	'securepoll-blocked' => 'ขออภัย คุณไม่สามารถลงคะแนนในการเลือกตั้งครั้งนี้ได้ หากคุณกำลังอยู่ในระหว่างการถูกห้ามการแก้ไข',
	'securepoll-bot' => 'ขออภัย ชื่อผู้ใช้ที่ถูกขึ้นบัญชีเป็นบอตไม่ได้รับอนุญาตในการลงคะแนนในการเลือกตั้งครั้งนี้',
	'securepoll-not-in-group' => 'เฉพาะสมาชิกของกลุ่ม "$1" เท่านั้นที่สามารถลงคะแนนในการเลือกตั้งครั้งนี้ได้',
	'securepoll-not-in-list' => 'ขออภัย คุณไม่ได้อยู่ในรายชื่อที่คัดเลือกให้ได้รับอนุญาตให้เลือกตั้งในครั้งนี้',
	'securepoll-header-timestamp' => 'เวลา',
	'securepoll-header-voter-name' => 'ชื่อ',
	'securepoll-header-strike' => 'ขีดฆ่า',
	'securepoll-header-details' => 'รายละเอียด',
	'securepoll-strike-button' => 'ขีดฆ่า',
	'securepoll-unstrike-button' => 'ยกเลิกการขีดฆ่า',
	'securepoll-strike-reason' => 'เหตุผล:',
	'securepoll-strike-cancel' => 'ยกเลิก',
	'securepoll-strike-error' => 'เกิดความผิดพลาดในการขีดฆ่า/ยกเลิกขีดฆ่า: $1',
	'securepoll-strike-token-mismatch' => 'ข้อมูลของภาคนี้สูญหาย',
	'securepoll-details-link' => 'รายละเอียด',
	'securepoll-details-title' => 'รายละเอียดการลงคะแนน: #$1',
	'securepoll-invalid-vote' => '"$1" ไม่ใช่รหัสประจำการลงคะแนนที่ถูกต้อง',
	'securepoll-header-voter-type' => 'ประเภทของผู้ลงคะแนน',
	'securepoll-voter-properties' => 'คุณสมบัติของผู้ลงคะแนน',
	'securepoll-header-action' => 'การกระทำ',
	'securepoll-header-reason' => 'เหตุผล',
	'securepoll-header-admin' => 'ผู้ดูแลระบบ',
	'securepoll-cookie-dup-list' => 'ผู้ใช้ที่มี Cookie ซ้ำกัน',
	'securepoll-dump-no-crypt' => 'ไม่มีบันทึกการเลือกตั้งที่ถูกเข้ารหัสไว้สำหรับการเลือกตั้งนี้ เพราะการเลือกตั้งนี้ไม่ได้ถูกตั้งให้เข้ารหัสไว้',
	'securepoll-dump-not-finished' => 'บันทึกการเลือกตั้งที่ถูกเข้ารหัสไว้ จะมีหลังจากเสร็จสิ้นการเลือกตั้งวันที่ $1 เวลา $2',
	'securepoll-dump-no-urandom' => 'ไม่สามารถเปิด /dev/urandom ได้
เพื่อรักษาความเป็นส่วนตัวของผู้ลงคะแนน บันทึกการเลือกตั้งที่ถูกเข้ารหัสไว้จะเปิดเผยต่อสาธารณะเมื่อบันทึกเหล่านั้นได้ถูกสุ่มเลือกด้วยระบบสุ่มหมายเลขลับ',
	'securepoll-translate-title' => 'แปลภาษา: $1',
	'securepoll-invalid-language' => 'รหัสภาษา "$1" ไม่ถูกต้อง',
	'securepoll-language-label' => 'เลือกภาษา:',
	'securepoll-submit-select-lang' => 'แปลภาษา',
	'securepoll-header-title' => 'ชื่อ',
	'securepoll-header-start-date' => 'วันที่เริ่มต้น',
	'securepoll-header-end-date' => 'วันที่สิ้นสุด',
	'securepoll-subpage-vote' => 'ลงคะแนน',
	'securepoll-subpage-translate' => 'แปลภาษา',
	'securepoll-subpage-list' => 'รายการ',
	'securepoll-subpage-dump' => 'รวบรวม',
	'securepoll-tally-not-finished' => 'ขออภัย คุณไม่สามารถนับคะแนนเลือกตั้งได้จนกว่าการลงคะแนนจะเสร็จสิ้น',
	'securepoll-can-decrypt' => 'บันทึกการเลือกตั้งได้ถูกเข้ารหัสไว้ แต่ไม่มีรหัสสำหรับการถอดรหัส
คุณสามารถเลือกที่จะนับผลการเลือกตั้งที่ปรากฎในฐานข้อมูล หรือนับคะแนนของบันทึกที่ถูกเข้ารหัสจากไฟล์ที่ถูกอัพโหลดไว้',
	'securepoll-tally-no-key' => 'คุณไม่สามารถนับคะแนนเลือกตั้งนี้ได้ เพราะการลงคะแนนได้ถูกเข้ารหัสไว้ และไม่มีกุญแจถอดรหัส',
	'securepoll-tally-local-legend' => 'ผลการนับคะแนนที่ถูกเก็บไว้',
	'securepoll-tally-local-submit' => 'สร้างผลการนับคะแนน',
	'securepoll-tally-upload-submit' => 'สร้างผลการนับคะแนน',
	'securepoll-tally-error' => 'ผิดพลาดในการแปลบันทึกการลงคะแนน ไม่สามารถนับคะแนนได้',
	'securepoll-no-upload' => 'ไม่มีไฟล์ใดๆ ถูกอัพโหลด ไม่สามารถนับคะแนนได้',
	'securepoll-ranks' => 'อันดับอย่างเป็นทางการ',
	'securepoll-average-score' => 'คะแนนเฉลี่ย',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'securepoll' => 'HowpsuzSesberişlik',
	'securepoll-desc' => 'Saýlawlar we anketalar üçin giňeltmeler',
	'securepoll-invalid-page' => 'Nädogry kiçi sahypa "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Bu hereketi amala aşyrmak üçin saýlaw administratory bolmagyňyz gerek.',
	'securepoll-too-few-params' => 'Kiçi sahypa parametrleri ýeterlik däl (nädogry çykgyt).',
	'securepoll-invalid-election' => '"$1" dogry saylaw ID-si däl',
	'securepoll-welcome' => '<strong>Hoş geldiň, $1!</strong>',
	'securepoll-finished' => 'Bu saýlaw gutardy, indi ses berip bilmeýärsiňiz.',
	'securepoll-not-qualified' => 'Bu saýlawda ses bermäge hukugyňyz ýok: $1',
	'securepoll-submit' => 'Sesi tabşyr',
	'securepoll-return' => '$1 sahypasyna gaýdyp bar',
	'securepoll-no-gpg-home' => 'GPG öý direktoriýasyny döredip bilmeýär.',
	'securepoll-gpg-config-error' => 'GPG açarlary nädogry konfigurirlenipdir.',
	'securepoll-gpg-parse-error' => 'GPG önümi interpretasiýasynda säwlik.',
	'securepoll-no-decryption-key' => 'Rasşifrowka açary konfigurirlenmändir.
Rasşifrowka edip bolmaýar.',
	'securepoll-jump' => 'Ses beriş serwerine git',
	'securepoll-bad-ballot-submission' => 'Sesiňiz hasap edilmeýär: $1',
	'securepoll-unanswered-questions' => 'Ähli soraglara jogap bermelisiňiz.',
	'securepoll-invalid-rank' => 'Nädogry rang. 1 bilen 999 arasynda bir rang bermeli',
	'securepoll-invalid-score' => 'Bahalandyrma $1 bilen $2 aralygynda bolmalydyr.',
	'securepoll-unanswered-options' => 'Her soraga jogap bermelisiňiz.',
	'securepoll-remote-auth-error' => 'Serwerden hasap maglumatyny almak säwligi.',
	'securepoll-remote-parse-error' => 'Serweriň ygtyýarlandyrma jogabynyň interpretasiýasynda säwlik.',
	'securepoll-api-invalid-params' => 'Nädogry parametrler',
	'securepoll-api-no-user' => 'Berlen ID-de hiç hili ulanyjy tapylmady',
	'securepoll-api-token-mismatch' => 'Howpsuzlyk belligi gabat gelmeýär, sessiýa açyp bolmaýar.',
	'securepoll-not-logged-in' => 'Saýlawda ses bermek üçin sessiýa açmaly',
	'securepoll-too-few-edits' => 'Gynansak-da, ses berip bilmeýärsiňiz. Bu saýlawda ses bermek üçin iň bolmanda $1 sany {{PLURAL:$1|özgerdiş|özgerdiş}} etmegiňiz zerurdyr, siziň $2 özgerdişiňiz bar.',
	'securepoll-blocked' => 'Bagyşlaň, redkatirlemez ýaly blokirlenen bolsaňyz onda ses berip bilmeýärsiňiz.',
	'securepoll-bot' => 'Gynansak-da, bot diýlip belenilen hasaplar bu saýlawda ses berip bilmeýär.',
	'securepoll-not-in-group' => 'Bu saýlawda diňe "$1" toparynyň agzalary ses berip bilýär.',
	'securepoll-list-title' => 'Sesleriň sanawy: $1',
	'securepoll-header-timestamp' => 'Wagt',
	'securepoll-header-voter-name' => 'At',
	'securepoll-header-voter-domain' => 'Domen',
	'securepoll-header-ua' => 'Ulanyjy agenti',
	'securepoll-header-cookie-dup' => 'Dubl',
	'securepoll-header-strike' => 'Üstüni çyz',
	'securepoll-header-details' => 'Jikme-jiklikler',
	'securepoll-strike-button' => 'Üstüni çyz',
	'securepoll-unstrike-button' => 'Üstüni çyzma',
	'securepoll-strike-reason' => 'Sebäp:',
	'securepoll-strike-cancel' => 'Goýbolsun et',
	'securepoll-strike-error' => 'Üstüni çyz/çyzma ýerine ýetirilende säwlik: $1',
	'securepoll-strike-token-mismatch' => 'Sessiýa maglumatlary ýitdi',
	'securepoll-details-link' => 'Jikme-jiklikler',
	'securepoll-details-title' => 'Ses berişlik jikme-jiklikleri: #$1',
	'securepoll-invalid-vote' => '"$1" dogry ses beriş ID-si däl',
	'securepoll-header-voter-type' => 'Saýlawçy tipi',
	'securepoll-voter-properties' => 'Saýlawçy aýratynlyklary',
	'securepoll-strike-log' => 'Üstüni çyzma gündeligi',
	'securepoll-header-action' => 'Hereket',
	'securepoll-header-reason' => 'Sebäp',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Kuki dublikat uanyjylary',
	'securepoll-dump-title' => 'Damp: $1',
	'securepoll-translate-title' => 'Terjime et: $1',
	'securepoll-invalid-language' => 'Nädogry dil kody "$1"',
	'securepoll-submit-translate' => 'Täzele',
	'securepoll-language-label' => 'Dil saýla:',
	'securepoll-submit-select-lang' => 'Terjime et',
	'securepoll-entry-text' => 'Aşakdaky ses berişlikleriň sanawydyr.',
	'securepoll-header-title' => 'At',
	'securepoll-header-start-date' => 'Başlangyç senesi',
	'securepoll-header-end-date' => 'Gutaryş senesi',
	'securepoll-subpage-vote' => 'Ses',
	'securepoll-subpage-translate' => 'Terjime et',
	'securepoll-subpage-list' => 'Sanaw',
	'securepoll-subpage-dump' => 'Damp',
	'securepoll-subpage-tally' => 'Sanama',
	'securepoll-tally-title' => 'Sanama: $1',
	'securepoll-tally-not-finished' => 'Gynansak-da, saýlaw gutarýança sesleri sanap bilmeýärsiňiz.',
	'securepoll-tally-local-legend' => 'Ýazdyrylan sesleri sana',
	'securepoll-tally-local-submit' => 'Sanama döret',
	'securepoll-tally-upload-legend' => 'Şifrli dampy ýükle',
	'securepoll-tally-upload-submit' => 'Sanama döret',
	'securepoll-no-upload' => 'Hiç hili faýl ýüklenmedi, netijeleri sanap bolmaýar.',
	'securepoll-dump-corrupt' => 'Damp faýly zeperli we ony işledip bolanok.',
	'securepoll-tally-upload-error' => 'Damp faýl sanamakda säwlik: $1',
	'securepoll-pairwise-victories' => 'Jübüt ýeňiş matrisasy',
	'securepoll-strength-matrix' => 'Ýol güýji matrisasy',
	'securepoll-ranks' => 'Ahyrky derejelendirme',
	'securepoll-average-score' => 'Ortaça baha',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'securepoll' => 'Ligtas na Halalan',
	'securepoll-desc' => 'Karugtong para sa mga halalan at mga pagtatanung-tanong',
	'securepoll-invalid-page' => 'Hindi tanggap na kabahaging pahinang "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Kailangan mong maging isang tagapangasiwa upang maisagawa ang galaw na ito.',
	'securepoll-too-few-params' => 'Hindi sapat na mga parametro ng kabahaging pahina (hindi tanggap na kawing).',
	'securepoll-invalid-election' => 'Ang "$1" ay hindi isang tanggap na ID ng halalan.',
	'securepoll-welcome' => '<strong>Maligayang pagdating, $1!</strong>',
	'securepoll-not-started' => 'Hindi pa nagsisimula ang halalang ito.
Nakatakdang magsimula ito sa $2 sa $3.',
	'securepoll-finished' => 'Natapos na ang halalang ito, hindi ka na makaboboto.',
	'securepoll-not-qualified' => 'Hindi ka pa karapat-dapat na bumoto sa halalang ito: $1',
	'securepoll-change-disallowed' => 'Bumoto ka na dati sa halalang ito.
Paumanhin, hindi ka na maaaring bumoto uli.',
	'securepoll-change-allowed' => '<strong>Paunawa: Bumoto ka na dati sa halalang ito.</strong>
Maaari mong baguhin ang iyong boto sa pamamagitan ng pagpasa ng pormularyong nasa ibaba.
Pakitandaan na kapag ginawa mot ito, itatapon ang nauna mong boto.',
	'securepoll-submit' => 'Ipasa ang boto',
	'securepoll-gpg-receipt' => 'Salamat sa pagboto mo.

Kung nais mo, maaari mong itabi ang sumusunod na resibo bilang katibayan ng pagboto mo:

<pre>$1</pre>',
	'securepoll-thanks' => 'Salamat sa iyo, naitala na ang boto mo.',
	'securepoll-return' => 'Bumalik sa $1',
	'securepoll-encrypt-error' => 'Nabigong ikodigo ang iyong tala ng pagboto.
Hindi naitala ang boto mo!

$1',
	'securepoll-no-gpg-home' => 'Hindi nagawang likhain ang tahanang direktoryong GPG.',
	'securepoll-secret-gpg-error' => 'Kamalian sa pagpapatupad ng GPG.
Gamitin ang $wgSecurePollShowErrorDetail=true; sa loob ng LocalSettings.php upang makapagpakita ng marami pang detalye.',
	'securepoll-full-gpg-error' => 'Kamalian sa pagpapatupad ng GPG:

Utos: $1

Kamalian:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Hindi nakaayos ng tama ang mga susi ng GPG.',
	'securepoll-gpg-parse-error' => 'Kamalian sa pagpapaliwanag ng kinalabasan ng GPG.',
	'securepoll-no-decryption-key' => 'Walang nakaayos na susing pangtanggal ng kodigo.
Hindi matanggal ang kodigo.',
	'securepoll-jump' => 'Pumunta sa tagapaghain ng pagboto',
	'securepoll-bad-ballot-submission' => 'Hindi tinanggap ang boto mo: $1',
	'securepoll-unanswered-questions' => 'Dapat mong sagutin ang lahat ng mga katanungan.',
	'securepoll-remote-auth-error' => 'Kamalian sa pagpulot ng kabatiran ng akawnt mo mula sa tagapaghain.',
	'securepoll-remote-parse-error' => 'Kamalian sa pagpapaliwanag ng tugon ng pagpapahintulot mula sa tagapaghain.',
	'securepoll-api-invalid-params' => 'Hindi tanggap na mga parametro.',
	'securepoll-api-no-user' => 'Walang tagagamit na natagpuang may ibinigay na ID.',
	'securepoll-api-token-mismatch' => 'Maling pagtutugma ng tandang pangkaligtasan, hindi makalalagdang papasok.',
	'securepoll-not-logged-in' => 'Kailangan mong lumagdang papasok upang makaboto sa halalang ito',
	'securepoll-too-few-edits' => 'Paumanhin, hindi ka makakaboto. Kailangan mong maging nakagawa ng kahit na mga $1 {{PLURAL:$1|pamamatnugot|mga pamamatnugot}} upang makaboto sa halalang ito, nakagawa ka na ng $2.',
	'securepoll-blocked' => 'Paumanhin, hindi ka makakaboto sa halalang ito kung pangkasalukuyan kang hinahadlangan mula sa pamamatnugot.',
	'securepoll-bot' => 'Paumanhin, ang mga akawnt na may watawat ng robot ay hindi pinapayagang bumoto sa halalang ito.',
	'securepoll-not-in-group' => 'Mga kasapi lamang ng pangkat na "$1" ang makakaboto sa halalang ito.',
	'securepoll-not-in-list' => 'Paumanhin, wala ka sa loob ng mga natiyak na talaan ng mga tagagamit na pinapayagang bumoto sa halalang ito.',
	'securepoll-list-title' => 'Itala ang mga boto: $1',
	'securepoll-header-timestamp' => 'Oras',
	'securepoll-header-voter-name' => 'Pangalan',
	'securepoll-header-voter-domain' => 'Nasasakupan',
	'securepoll-header-ua' => 'Ahente ng tagagamit',
	'securepoll-header-cookie-dup' => 'Sipi',
	'securepoll-header-strike' => 'Kalusin',
	'securepoll-header-details' => 'Mga detalye',
	'securepoll-strike-button' => 'Kalusin',
	'securepoll-unstrike-button' => 'Huwag kalusin',
	'securepoll-strike-reason' => 'Dahilan:',
	'securepoll-strike-cancel' => 'Huwag ipagpatuloy',
	'securepoll-strike-error' => 'Kamalian sa pagsasagawa ng kalusin/huwag kalusin: $1',
	'securepoll-details-link' => 'Mga detalye',
	'securepoll-details-title' => 'Mga detalye ng boto: #$1',
	'securepoll-invalid-vote' => 'Ang "$1" ay hindi isang tanggap na ID ng boto',
	'securepoll-header-voter-type' => 'Uri ng tagapaghalal',
	'securepoll-voter-properties' => 'Mga pag-aari ng botante',
	'securepoll-strike-log' => 'Talaan ng pagkalos',
	'securepoll-header-action' => 'Galaw',
	'securepoll-header-reason' => 'Dahilan',
	'securepoll-header-admin' => 'Tagapangasiwa',
	'securepoll-cookie-dup-list' => "Mga tagagamit ng dalawahang \"otap\" o ''cookie''",
	'securepoll-dump-title' => 'Itapon: $1',
	'securepoll-dump-no-crypt' => 'Walang makuhang nakakodigong tala ng halalan para sa halalang ito, dahil ang halalan ay hindi nakaayos na gumamit ng kodigo.',
	'securepoll-dump-not-finished' => 'Makakakuha lamang ng nakakodigong mga tala ng halalan pagkalipas ng petsa ng katapusang $1 sa $2',
	'securepoll-dump-no-urandom' => 'Hindi mabuksan /dev/urandom.
Upang mapanitili ang paglilihim ng manghahalal, makukuha lamang ng madla ang nakakodigong mga talaan ng halalan kapag mababalasa na sila sa isang ligtas na daloy ng alin mang bilang.',
	'securepoll-translate-title' => 'Isalinwika: $1',
	'securepoll-invalid-language' => 'Hindi tanggap na kodigo ng wikang "$1"',
	'securepoll-submit-translate' => 'Isapanahon',
	'securepoll-language-label' => 'Piliin ang wika:',
	'securepoll-submit-select-lang' => 'Isalinwika',
	'securepoll-header-title' => 'Pangalan',
	'securepoll-header-start-date' => 'Petsa ng simula',
	'securepoll-header-end-date' => 'Petsa ng katapusan',
	'securepoll-subpage-vote' => 'Bumoto',
	'securepoll-subpage-translate' => 'Isalinwika',
	'securepoll-subpage-list' => 'Itala',
	'securepoll-subpage-dump' => 'Itapon',
	'securepoll-subpage-tally' => 'Itala ang bilang',
	'securepoll-tally-title' => 'Talaan ng bilang: $1',
	'securepoll-tally-not-finished' => "Paumanhin, hindi mo maitatala ang bilang ng halalan hangga't hindi pa natatapos ang halalan.",
	'securepoll-can-decrypt' => 'Nakakodigo ang talaan ng halalan, subalit makukuha ang susing pantanggal ng kodigo.
Maaari mong piliin ang itala ang bilang ng mga kinalabasang naroroon sa loob ng kalipunan ng dato, o kaya itala ang bilang ng nakakodigong mga kinalabasan mula sa talaksang ikinargang papasok.',
	'securepoll-tally-no-key' => 'Hindi mo maitatala ang bilang ng halalang ito, dahil nakakodigo ang mga boto, at ang susi ng pagtanggal ng kodigo ay hindi makukuha.',
	'securepoll-tally-local-legend' => 'Itala ang nakatabing mga kinalabasan',
	'securepoll-tally-local-submit' => 'Likhain ang talaan ng mga bilang',
	'securepoll-tally-upload-legend' => 'Ikargang paitaas ang nakakodigong pagtapon',
	'securepoll-tally-upload-submit' => 'Likhain ang talaan ng mga bilang',
	'securepoll-tally-error' => 'Kamalian sa pagpapaliwanag ng talaan ng boto, hindi malikha ang isang talaan ng bilang.',
	'securepoll-no-upload' => 'Walang naikargang talaksan, hindi maitatala ang mga kinalabasan.',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Noumenon
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'securepoll' => 'GüvenliAnket',
	'securepoll-desc' => 'Seçimler ve anketler için eklenti',
	'securepoll-invalid-page' => 'Geçersiz altsayfa "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Bu eylemi gerçekleştirebilmek için bir seçim yöneticisi olmanız gerekir.',
	'securepoll-too-few-params' => 'Yeterli altsayfa parametresi yok (geçersiz bağlantı).',
	'securepoll-invalid-election' => '"$1" geçerli bir seçim IDsi değil.',
	'securepoll-welcome' => '<strong>Hoş Geldin $1!</strong>',
	'securepoll-not-started' => 'Bu seçim henüz başlamadı.
$2 tarihinde $3 saatinde başlaması planlanıyor.',
	'securepoll-finished' => 'Bu seçim tamamlandı, artık oy veremezsiniz.',
	'securepoll-not-qualified' => 'Bu seçimlerde oy kullanmak için yetkili değilsiniz: $1',
	'securepoll-change-disallowed' => 'Bu seçimde daha önce oy kullandınız.
Üzgünüz, tekrar oy kullanamayabilirsiniz.',
	'securepoll-change-allowed' => '<strong>Not: Bu seçimde daha önce oy kullandınız.</strong>
Aşağıdaki formu göndererek oyunuzu değiştirebilirsiniz.
Eğer bunu yaparsanız, orjinal oyunuzun iptal edileceğini unutmayın.',
	'securepoll-submit' => 'Oyu gönder',
	'securepoll-gpg-receipt' => 'Oy verdiğiniz için teşekkürler.

Eğer dilerseniz, aşağıdaki makbuzu oyunuzun delili olarak muhafaza edebilirsiniz:

<pre>$1</pre>',
	'securepoll-thanks' => 'Teşekkürler, oyunuz kaydedildi.',
	'securepoll-return' => '$1 sayfasına geri dön',
	'securepoll-encrypt-error' => 'Oy kaydınızın şifrelenmesi başarısız oldu.
Oyunuz kaydedilmedi!

$1',
	'securepoll-no-gpg-home' => 'GPG ev dizini oluşturulamıyor.',
	'securepoll-secret-gpg-error' => 'GPG çalıştırırken hata.
Daha fazla ayrıntı göstermek için LocalSettings.php\'de $wgSecurePollShowErrorDetail=true kullanın.',
	'securepoll-full-gpg-error' => 'GPG çalıştırırken hata:

Komut: $1

Hata:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG anahtarları yanlış yapılandırılmış.',
	'securepoll-gpg-parse-error' => 'GPG çıktısı yorumlanırken hata.',
	'securepoll-no-decryption-key' => 'Hiç deşifre anahtarı ayarlanmamış.
Deşifrelenemiyor.',
	'securepoll-jump' => 'Oylama sunucusuna git',
	'securepoll-bad-ballot-submission' => 'Oyunuz geçersiz: $1',
	'securepoll-unanswered-questions' => 'Tüm sorulara cevap vermelisiniz.',
	'securepoll-invalid-rank' => 'Geçersiz derece. Adaylara 1 ile 999 arasında bir derece vermelisiniz.',
	'securepoll-unranked-options' => 'Bazı seçenekler derecelendirilmemiş.
Tüm seçeneklere 1 ile 999 arasında bir derece vermelisiniz.',
	'securepoll-invalid-score' => 'Puan $1 ile $2 arasında bir sayı olmalıdır.',
	'securepoll-unanswered-options' => 'Her soruya bir cevap vermelisiniz.',
	'securepoll-remote-auth-error' => 'Sunucudan hesap bilgileriniz alınırken hata.',
	'securepoll-remote-parse-error' => 'Sunucunun yetkilendirme cevabı değerlendirilirken hata.',
	'securepoll-api-invalid-params' => 'Geçersiz değişkenler.',
	'securepoll-api-no-user' => 'Verilen ID ile hiçbir kullanıcı bulunamadı.',
	'securepoll-api-token-mismatch' => 'Güvenlik simgesi uyuşmuyor, giriş yapılamıyor.',
	'securepoll-not-logged-in' => 'Bu seçimde oy kullanmak için giriş yapmanız gerekiyor',
	'securepoll-too-few-edits' => 'Üzgünüz, oy veremezsiniz. Bu seçimlerde oy kullanmak için en az $1 {{PLURAL:$1|değişiklik|değişiklik}} yapmanız gerekir, sizin $2 değişikliğiniz var.',
	'securepoll-blocked' => 'Üzgünüz, eğer şu anda değişiklik yapmaya engellenmiş iseniz bu seçimlerde oy kullanamazsınız.',
	'securepoll-bot' => 'Üzgünüz, bot olarak işaretli hesaplar bu seçimde oy kullanamaz.',
	'securepoll-not-in-group' => 'Bu seçimlerde sadece $1 grubu üyeleri oy verebilir.',
	'securepoll-not-in-list' => 'Üzgünüz, bu seçimde oy kullanmaya yetkili öntanımlı kullanıcılar listesinde değilsiniz.',
	'securepoll-list-title' => 'Oyları listele: $1',
	'securepoll-header-timestamp' => 'Zaman',
	'securepoll-header-voter-name' => 'Ad',
	'securepoll-header-voter-domain' => 'Etki alanı',
	'securepoll-header-ua' => 'Kullanıcı temsilcisi',
	'securepoll-header-cookie-dup' => 'Kopya',
	'securepoll-header-strike' => 'Üstünü çiz',
	'securepoll-header-details' => 'Ayrıntılar',
	'securepoll-strike-button' => 'Üstünü çiz',
	'securepoll-unstrike-button' => 'Üstünü çizme',
	'securepoll-strike-reason' => 'Sebep:',
	'securepoll-strike-cancel' => 'İptal',
	'securepoll-strike-error' => 'Üsütünü çiz/çizme yerine getirilirken hata: $1',
	'securepoll-strike-token-mismatch' => 'Oturum verileri kayıp',
	'securepoll-details-link' => 'Ayrıntılar',
	'securepoll-details-title' => 'Oy ayrıntıları: #$1',
	'securepoll-invalid-vote' => '"$1" geçerli bir oy IDsi değil',
	'securepoll-header-voter-type' => 'Seçmen tipi',
	'securepoll-voter-properties' => 'Seçmen özellikleri',
	'securepoll-strike-log' => 'Üstünü çizme günlüğü',
	'securepoll-header-action' => 'Eylem',
	'securepoll-header-reason' => 'Sebep',
	'securepoll-header-admin' => 'Yönetici',
	'securepoll-cookie-dup-list' => 'Çerez yinelenen kullanıcıları',
	'securepoll-dump-title' => 'Döküm: $1',
	'securepoll-dump-no-crypt' => 'Bu seçim için şifrelenmiş seçim kaydı yok, çünkü seçim şifreleme kullanacak şekilde ayarlanmamış.',
	'securepoll-dump-not-finished' => "Şifreli seçim kayıtları sadece bitiş tarihi $1 saat $2'den sonra mevcut olur",
	'securepoll-dump-no-urandom' => '/dev/urandom açılamıyor.
Seçmen gizliliğini idame etmek için, şifreli seçim kayıtları sadece güvenli bir rasgele sayı akıntısıyla karıştırılabilirse umumen mevcut olur.',
	'securepoll-urandom-not-supported' => 'Bu sunucu kriptografik rastgele sayı üretimini desteklememektedir.
Oy veren gizliliğini sağlamak için, şifrelenmiş oylama kayıtları sadece güvenli bir rastgele sayı akışıyla karıştırılabilecekleri durumda alenen erişilebilirdirler.',
	'securepoll-translate-title' => 'Çevir: $1',
	'securepoll-invalid-language' => 'Geçersiz dil kodu "$1"',
	'securepoll-submit-translate' => 'Güncelle',
	'securepoll-language-label' => 'Dili seç:',
	'securepoll-submit-select-lang' => 'Çevir',
	'securepoll-entry-text' => 'Aşağıdaki, anketlerin listesidir.',
	'securepoll-header-title' => 'Ad',
	'securepoll-header-start-date' => 'Başlangıç tarihi',
	'securepoll-header-end-date' => 'Bitiş tarihi',
	'securepoll-subpage-vote' => 'Oy ver',
	'securepoll-subpage-translate' => 'Çevir',
	'securepoll-subpage-list' => 'Listele',
	'securepoll-subpage-dump' => 'Döküm',
	'securepoll-subpage-tally' => 'Sayım',
	'securepoll-tally-title' => 'Sayım: $1',
	'securepoll-tally-not-finished' => 'Üzgünüz, seçim tamamlanmadan oyları sayamazsınız.',
	'securepoll-can-decrypt' => 'Seçim kaydı şifrelenmiş, ama deşifre anahtarı mevcut.
Veritabanında mevcut sonuçları saymayı, ya da yüklenen bir dosyadan şifreli sonuçları saymayı seçebilirsiniz.',
	'securepoll-tally-no-key' => 'Bu seçimi sayamazsınız, çünkü oylar şifrelenmiş, ve deşifre anahtarı mevcut değil.',
	'securepoll-tally-local-legend' => 'Kaydedilmiş sonuçları say',
	'securepoll-tally-local-submit' => 'Sayım oluştur',
	'securepoll-tally-upload-legend' => 'Şifreli dökümü yükle',
	'securepoll-tally-upload-submit' => 'Sayım oluştur',
	'securepoll-tally-error' => 'Oy kaydı yorumlanırken hata, bir sayım üretilemiyor.',
	'securepoll-no-upload' => 'Hiçbir dosya yüklenmedi, sonuçlar sayılamıyor.',
	'securepoll-dump-corrupt' => 'Yığın dosyası bozuk ve işlenebilir değil.',
	'securepoll-tally-upload-error' => 'Yığın dosyası sayımında hata: $1',
	'securepoll-pairwise-victories' => 'İkili zafer matrisi',
	'securepoll-strength-matrix' => 'Yol gücü matrisi',
	'securepoll-ranks' => 'Son sıralama',
	'securepoll-average-score' => 'Ortalama skor',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author KhayR
 */
$messages['tt-cyrl'] = array(
	'securepoll-header-timestamp' => 'Вакыт',
	'securepoll-header-voter-name' => 'Исем',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Кулланучы агенты',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Ilyaroz
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'securepoll' => 'Безпечне голосування',
	'securepoll-desc' => 'Розширення для проведення виборів і опитувань',
	'securepoll-invalid-page' => 'Помилкова підсторінка "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Вам потрібно бути адміністратором виборів, щоб виконати цю дію.',
	'securepoll-too-few-params' => 'Не вистачає параметрів підсторінки (помилкове посилання).',
	'securepoll-invalid-election' => '«$1» не є допустимим виборчим ідентифікатором.',
	'securepoll-welcome' => '<strong>Ласкаво просимо, $1!</strong>',
	'securepoll-not-started' => 'Ці вибори ще не розпочалися.
Початок запланований на $2 $3.',
	'securepoll-finished' => 'Ці вибори зкінчились, ви вже не можете проголосувати.',
	'securepoll-not-qualified' => 'Ви не уповноважені голосувати на цих виборах: $1',
	'securepoll-change-disallowed' => 'Ви вже голосували на цих виборах раніше.
Даруйте, ви не можете проголосувати ще раз.',
	'securepoll-change-allowed' => '<strong>Примітка: ви вже проголосували на цих виборах.</strong>
Ви можете змінити свій голос, відправивши приведену нижче форму.
Якщо ви зробите це, то ваш попередній голос не буде врахований.',
	'securepoll-submit' => 'Відправити голос',
	'securepoll-gpg-receipt' => 'Дякуємо за участь в голосуванні.

При бажання ви можете зберегти наступні рядки як підтвердження вашого голосу:

<pre>$1</pre>',
	'securepoll-thanks' => 'Спасибі, ваш голос записаний.',
	'securepoll-return' => 'Повернутись до $1',
	'securepoll-encrypt-error' => 'Не вдалося зашифрувати запис про ваш голос.
Ваш голос не був записаний!

$1',
	'securepoll-no-gpg-home' => 'Не в змозі створити домашню теку GPG.',
	'securepoll-secret-gpg-error' => 'Помилка виконання GPG.
Задайте $wgSecurePollShowErrorDetail=true; в файлі LocalSettings.php щоб отримати докладніше повідомлення.',
	'securepoll-full-gpg-error' => 'Помилка виконання GPG:

Команда: $1

Помилка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-ключі налаштовані неправильно.',
	'securepoll-gpg-parse-error' => 'Помилка при інтерпретації результату GPG.',
	'securepoll-no-decryption-key' => 'Не налаштований ключ розшифрування.
Не в змозі розшифрувати.',
	'securepoll-jump' => 'Перейти на сервер голосувань',
	'securepoll-bad-ballot-submission' => 'Ваш голос не дійсний: $1',
	'securepoll-unanswered-questions' => 'Ви повинні відповісти на всі запитання.',
	'securepoll-invalid-rank' => 'Неправильне місце. Ви повинні вказати для кандидата місце від 1 до 999.',
	'securepoll-unranked-options' => 'Для деяких записів не зазначені місця.
Вам слід вказати місця від 1 до 999 для кожного запису.',
	'securepoll-invalid-score' => 'Оцінка повинна бути числом від $1 до $2.',
	'securepoll-unanswered-options' => 'Ви повинні дати відповідь на кожне питання.',
	'securepoll-remote-auth-error' => 'Помилка отримання інформації з сервера про ваш обліковий запис.',
	'securepoll-remote-parse-error' => 'Помилка інтерпретації відповіді від авторизації з сервера.',
	'securepoll-api-invalid-params' => 'Помилкові параметри.',
	'securepoll-api-no-user' => 'Не знайдений користувач із заданим ідентифікатором.',
	'securepoll-api-token-mismatch' => 'Невідповідність коду безпеки, не в змозі ввійти до системи.',
	'securepoll-not-logged-in' => 'Ви маєте ввійти до системи, щоб взяти участь в голосуванні',
	'securepoll-too-few-edits' => 'Вибачте, ви не можете проголосувати. Вам треба мати не менше $1 {{PLURAL:$1|редагування|редагувань|редагувань}} для участі в цьому голосуванні, у вас є $2.',
	'securepoll-blocked' => 'Вибачте, ви не можете голосувати на виборах, оскільки вас заблоковано.',
	'securepoll-bot' => 'Вибачте, облікові записи зі статусом бота не допускаються до участі в голосуванні.',
	'securepoll-not-in-group' => 'Тільки члени групи "$1" можуть голосувати на цих виборах.',
	'securepoll-not-in-list' => 'Вибачте, ви не входите в список користувачів, допущених до голосування на цих виборах.',
	'securepoll-list-title' => 'Список голосів: $1',
	'securepoll-header-timestamp' => 'Час',
	'securepoll-header-voter-name' => "Ім'я",
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Програма клієнта',
	'securepoll-header-cookie-dup' => 'Дубл.',
	'securepoll-header-strike' => 'Закреслення',
	'securepoll-header-details' => 'Деталі',
	'securepoll-strike-button' => 'Закреслити',
	'securepoll-unstrike-button' => 'Зняти закреслення',
	'securepoll-strike-reason' => 'Причина:',
	'securepoll-strike-cancel' => 'Скасувати',
	'securepoll-strike-error' => 'Помилка при викреслюванні/знятті викреслювання: $1',
	'securepoll-strike-token-mismatch' => 'Дані сеансу втрачені',
	'securepoll-details-link' => 'Докладніше',
	'securepoll-details-title' => 'Деталі голосування: #$1',
	'securepoll-invalid-vote' => '«$1» — неправильний ідентифікатор голосування',
	'securepoll-header-voter-type' => 'Тип виборця',
	'securepoll-voter-properties' => 'Властивості виборця',
	'securepoll-strike-log' => 'Журнал викреслювань',
	'securepoll-header-action' => 'Дія',
	'securepoll-header-reason' => 'Причина',
	'securepoll-header-admin' => 'Адміністратор',
	'securepoll-cookie-dup-list' => 'Дублікати користувачів за куками',
	'securepoll-dump-title' => 'Дамп: $1',
	'securepoll-dump-no-crypt' => 'Незашифровані записи подачі голосу доступні на цих виборах, оскільки вибори не налаштовані на використання шифрування.',
	'securepoll-dump-not-finished' => 'Зашифровані записи голосів доступні тільки після закінчення голосування $1 о $2',
	'securepoll-dump-no-urandom' => 'Не вдається відкрити /dev/urandom.
Для забезпечення конфіденційності виборців, зашифровані записи подачі голосів можна робити загальнодоступними, тільки коли порядок їх слідування можна змінити з використанням безпечного джерела випадкових чисел.',
	'securepoll-urandom-not-supported' => 'Цей сервер не підтримує криптографічні генерування випадкових чисел.
Щоб зберегти конфіденційність голосуючих, закодовані записи голосування стануть загальнодоступними тільки після того, як вони зможуть бути перемішані за допомогою безпечного потоку випадкових чисел.',
	'securepoll-translate-title' => 'Переклад: $1',
	'securepoll-invalid-language' => 'Неправильний код мови «$1»',
	'securepoll-submit-translate' => 'Оновити',
	'securepoll-language-label' => 'Вибір мови:',
	'securepoll-submit-select-lang' => 'Перекласти',
	'securepoll-entry-text' => 'Нижче наведений список голосувань.',
	'securepoll-header-title' => "Ім'я",
	'securepoll-header-start-date' => 'Дата початку',
	'securepoll-header-end-date' => 'Дата закінчення',
	'securepoll-subpage-vote' => 'Голосування',
	'securepoll-subpage-translate' => 'Переклад',
	'securepoll-subpage-list' => 'Список',
	'securepoll-subpage-dump' => 'Дамп',
	'securepoll-subpage-tally' => 'Підрахунок',
	'securepoll-tally-title' => 'Підрахунок: $1',
	'securepoll-tally-not-finished' => 'Вибачте, ви можете проводити підрахунок підсумків тільки після завершення голосування.',
	'securepoll-can-decrypt' => 'Запис голосування був зашифрований, але є ключ розшифровки.
Ви можете обрати або підрахунок поточних результатів в базі даних, або підрахунок зашифрованих результатів з завантаженого файлу.',
	'securepoll-tally-no-key' => 'Ви можете не підраховувати голоси на цих виборах, так як вони були зашифровані, а ключ розшифровки відсутній.',
	'securepoll-tally-local-legend' => 'Підрахунок збережених результатів',
	'securepoll-tally-local-submit' => 'Зробити підрахунок',
	'securepoll-tally-upload-legend' => 'Завантаження зашифрованого скиду (дампу)',
	'securepoll-tally-upload-submit' => 'Зробити підрахунок',
	'securepoll-tally-error' => 'Помилка інтерпретації запису голосу, неможливо провести підрахунок.',
	'securepoll-no-upload' => 'Файл не був завантажений, неможливо підрахувати результати.',
	'securepoll-dump-corrupt' => 'Файл скиду (дампу) пошкоджений і не може бути обробленим.',
	'securepoll-tally-upload-error' => 'Помилка під час підрахунків у файлі скиду (дампу): $1',
	'securepoll-pairwise-victories' => 'Матриця попарних перемог',
	'securepoll-strength-matrix' => 'Матриця сил шляхів',
	'securepoll-ranks' => 'Остаточний рейтинг',
	'securepoll-average-score' => 'Середня оцінка',
);

/** Urdu (اردو)
 * @author محبوب عالم
 */
$messages['ur'] = array(
	'securepoll-desc' => 'توسیعہ برائے انتخابات و مساحات',
	'securepoll-invalid-page' => 'غیرصحیح ذیلی‌صفحہ "<nowiki>$1</nowiki>"',
	'securepoll-invalid-election' => '"$1" کوئی معتبر انتخابی شناخت نہیں ہے.',
	'securepoll-welcome' => '<strong>خوش آمدید $1!</strong>',
	'securepoll-not-started' => 'چناؤ ابھی شروع نہیں ہوا.

اِس کا آغاز $1 کو ہوگا.',
	'securepoll-not-qualified' => 'آپ اِس چناؤ میں رائےدہندگی کے اہل نہیں: $1',
	'securepoll-change-disallowed' => 'آپ اِس چناؤ میں پہلے رائے دے چکے ہیں.

معذرت، آپ دوبارہ رائے نہیں دے سکتے.',
	'securepoll-change-allowed' => '<strong>یاددہانی: آپ اِس چناؤ میں پہلے رائے دے چکے ہیں.</strong>

آپ درج ذیل تشکیلہ بھیج کر اپنی رائے تبدیل کرسکتے ہیں.

یاد رہے کہ ایسا کرنے سے آپ کی اصل رائے ختم ہوجائے گی.',
	'securepoll-submit' => 'رائے بھیجئے',
	'securepoll-gpg-receipt' => 'رائےدہندگی کا شکریہ.

اگر آپ چاہیں تو درج ذیل رسید کو اپنی رائےدہندگی کے ثبوت کے طور پر رکھ سکتے ہیں:

<pre>$1</pre>',
	'securepoll-thanks' => 'شکریہ، آپ کی رائے محفوظ کرلی گئی.',
	'securepoll-return' => 'واپس بطرف $1',
);

/** Vèneto (Vèneto)
 * @author Candalua
 * @author Nick1915
 */
$messages['vec'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Estension par le elession e i sondagi',
	'securepoll-invalid-page' => 'Sotopàxena mia vàlida: "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => "Ti gà da èssar un aministrador de l'elession par poder far sta azion.",
	'securepoll-too-few-params' => 'Paràmetri de la sotopàxena mia suficenti (colegamento mia vàlido).',
	'securepoll-invalid-election' => '"$1" no xe un ID vàlido par l\'elession.',
	'securepoll-welcome' => '<strong>Benvegnù $1!</strong>',
	'securepoll-not-started' => "L'elession no la xe gnancora tacà.
L'inissio el xe programà par el $2 a le $3.",
	'securepoll-finished' => 'Sta elesion ła xe finìa, no se pol pi votar.',
	'securepoll-not-qualified' => 'No te sì mia qualificà par votar in sta elession: $1',
	'securepoll-change-disallowed' => 'Ti gà xà votà in sta elession.
No ti podi votar da novo.',
	'securepoll-change-allowed' => '<strong>Ocio: ti gà xà votà in sta elession.</strong>
Ti podi canbiar el voto conpilando el mòdulo qua soto.
Ocio che fasendo cussì el voto orijinale el vegnarà scartà.',
	'securepoll-submit' => 'Manda el voto',
	'securepoll-gpg-receipt' => 'Grassie de aver votà.

Sta chì xe la riçevuta de la votassion:

<pre>$1</pre>',
	'securepoll-thanks' => 'Grassie, el to voto el xe stà rejistrà.',
	'securepoll-return' => 'Torna a $1',
	'securepoll-encrypt-error' => "No se riesse a cifrar le informassion de voto.
El voto no'l xe mia stà rejistrà.

$1",
	'securepoll-no-gpg-home' => 'NO se riesse a crear la cartèla prinsipale de GPG.',
	'securepoll-secret-gpg-error' => 'Eròr durante l\'esecussion de GPG.
Dòpara $wgSecurePollShowErrorDetail=true; in LocalSettings.php par védar majori detagli.',
	'securepoll-full-gpg-error' => "Eròr durante l'esecussion de GPG:

Comando: $1

Eròr:
<pre> $2 </pre>",
	'securepoll-gpg-config-error' => 'Le ciave GPG no le xe mia configurà juste.',
	'securepoll-gpg-parse-error' => "Eròr in tel'interpretassion de l'output de GPG.",
	'securepoll-no-decryption-key' => 'No xe stà configurà nissuna ciave de decritassion.
No se pole decritar.',
	'securepoll-jump' => 'Và al server de ła votasion',
	'securepoll-bad-ballot-submission' => "El to voto no'l xe mia vàłido: $1",
	'securepoll-unanswered-questions' => 'Ti gà da rispóndar a tute le domande.',
	'securepoll-unanswered-options' => 'Te ghè da rispondar a tute le domande.',
	'securepoll-remote-auth-error' => 'Eròr durante el recupero de le informassion su la to utensa dal server.',
	'securepoll-remote-parse-error' => 'Se gà verificà un eròr interpretando la risposta de autorixassion dal server.',
	'securepoll-api-invalid-params' => 'Paràmetri mia vàlidi.',
	'securepoll-api-no-user' => 'No xe stà catà nissun utente co sto ID.',
	'securepoll-api-token-mismatch' => 'I token de sicuressa no i coincide, no te podi entrar.',
	'securepoll-not-logged-in' => 'Ti gà da far el login par votar in sta elession',
	'securepoll-too-few-edits' => "Me dispiase, no te pol mia votar. Te ghè da ver fato almanco $1 {{PLURAL:$1|modifica|modifiche}} par votar in sta elession, ti te ghe n'è fate $2.",
	'securepoll-blocked' => 'Me dispiase, no te pol mia votar in sta elession se te sì stà blocà dal far le modifiche.',
	'securepoll-bot' => 'Me dispiase, le utense col stato de bot no le xe amesse a votar in sta elession.',
	'securepoll-not-in-group' => 'Solo i menbri del grupo "$1" i pol votar in sta elession.',
	'securepoll-not-in-list' => 'Me dispiase, no te sì mia in te la lista predeterminada dei utenti autorixà a votar in sta elession.',
	'securepoll-list-title' => 'Elenco voti: $1',
	'securepoll-header-timestamp' => 'Data e ora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Agente utente',
	'securepoll-header-cookie-dup' => 'Dopio',
	'securepoll-header-strike' => 'Anùla',
	'securepoll-header-details' => 'Detagli',
	'securepoll-strike-button' => 'Anùla sta voto',
	'securepoll-unstrike-button' => 'Recupera sto voto',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Anùla',
	'securepoll-strike-error' => "Eròr durante l'anulamento o el ripristino del voto: $1",
	'securepoll-strike-token-mismatch' => 'I dati de la session i xe ndà persi',
	'securepoll-details-link' => 'Detagli',
	'securepoll-details-title' => 'Detagli del voto: #$1',
	'securepoll-invalid-vote' => '"$1" no xe l\'ID de un voto vàlido',
	'securepoll-header-voter-type' => 'Tipo de utente',
	'securepoll-voter-properties' => 'Proprietà del votante',
	'securepoll-strike-log' => 'Registro dei anulamenti',
	'securepoll-header-action' => 'Assion',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Aministrador',
	'securepoll-cookie-dup-list' => 'Utenti duplici par cookie',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => "Par sta elession no xe disponibile nissuna registrassion criptada, parché l'elession no la xe inpostà par doparar la critassion.",
	'securepoll-dump-not-finished' => "Le registrasion criptade de l'elesion le xe disponibiłi solo dopo ła data de conclusion: $1 a łe $2",
	'securepoll-dump-no-urandom' => "No se riesse a vèrzar /dev/urandom.  
Par protègiare la riservatessa dei votanti, le registrassion criptade de l'elession le xe disponibili publicamente solo quando le podarà vegner smissià con un flusso sicuro de nùmari casuali.",
	'securepoll-translate-title' => 'Tradusi: $1',
	'securepoll-invalid-language' => 'Còdese lengua mia vàlido: "$1"',
	'securepoll-submit-translate' => 'Ajorna',
	'securepoll-language-label' => 'Siegli lengua:',
	'securepoll-submit-select-lang' => 'Tradusi',
	'securepoll-entry-text' => 'Qua ghe xe la lista de le votassion.',
	'securepoll-header-title' => 'Nome',
	'securepoll-header-start-date' => 'Data de scominsio',
	'securepoll-header-end-date' => 'Data de fine',
	'securepoll-subpage-vote' => 'Vota',
	'securepoll-subpage-translate' => 'Traduxi',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Conta',
	'securepoll-tally-title' => 'Conta: $1',
	'securepoll-tally-not-finished' => 'Ne dispiase, ma no se pole contar i voti prima che la votassion la sia finìa.',
	'securepoll-tally-local-submit' => 'Fà na conta',
	'securepoll-tally-upload-legend' => 'Carga su un dump criptà',
	'securepoll-tally-upload-submit' => 'Fà la conta',
	'securepoll-ranks' => 'Classifica final',
	'securepoll-average-score' => 'Puntejo medio',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'securepoll-submit' => "Oigeta än'",
	'securepoll-api-invalid-params' => 'Värad parametrad',
	'securepoll-header-timestamp' => 'Aig',
	'securepoll-header-voter-name' => 'Nimi',
	'securepoll-header-voter-domain' => 'Domen',
	'securepoll-header-ua' => 'Kävutajan agent',
	'securepoll-header-details' => 'Detalid',
	'securepoll-strike-reason' => 'Sü:',
	'securepoll-strike-cancel' => 'Heitta pätand',
	'securepoll-details-link' => 'Detalid',
	'securepoll-header-action' => 'Tego',
	'securepoll-header-reason' => 'Sü',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Kävutajad, kudambad kävutadas ühten "cookie"-n',
	'securepoll-submit-translate' => 'Udištada',
	'securepoll-language-label' => "Valiče kel':",
	'securepoll-submit-select-lang' => 'Käta',
	'securepoll-header-title' => 'Nimi',
	'securepoll-header-start-date' => 'Augotiždat',
	'securepoll-header-end-date' => 'Lopdat',
	'securepoll-subpage-vote' => 'Änesta',
	'securepoll-subpage-translate' => 'Käta',
	'securepoll-subpage-list' => 'Nimikirjutez',
	'securepoll-subpage-tally' => 'Lugemine',
	'securepoll-tally-title' => 'Lugemine: $1',
	'securepoll-tally-local-submit' => 'Säta lugemine',
	'securepoll-tally-upload-submit' => 'Säta lugemine',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'securepoll' => 'Bỏ phiếu An toàn',
	'securepoll-desc' => 'Bộ mở rộng dành cho bầu cử và thăm dò ý kiến',
	'securepoll-invalid-page' => 'Trang con không hợp lệ “<nowiki>$1</nowiki>”',
	'securepoll-need-admin' => 'Chỉ các quản lý viên được bầu mới có quyền thực hiện tác vụ này.',
	'securepoll-too-few-params' => 'Không đủ thông số trang con (liên kết không hợp lệ).',
	'securepoll-invalid-election' => '“$1” không phải là mã số bầu cử hợp lệ.',
	'securepoll-welcome' => '<strong>Xin chào $1!</strong>',
	'securepoll-not-started' => 'Cuộc bầu cử này chưa bắt đầu.
Dự kiến nó sẽ bắt đầu vào ngày $2 lúc $3.',
	'securepoll-finished' => 'Cuộc bầu cử này đã kết thúc, bạn không thể bỏ phiếu được nữa.',
	'securepoll-not-qualified' => 'Bạn không đủ tiêu chuẩn để bỏ phiếu trong cuộc bầu cử này: $1',
	'securepoll-change-disallowed' => 'Bạn đã bỏ phiếu cho cuộc bầu cử này rồi.
Rất tiếc, bạn không thể bỏ phiếu được nữa.',
	'securepoll-change-allowed' => '<strong>Chú ý: Bạn đã bỏ phiếu trong cuộc bầu cử này rồi.</strong>
Bạn có thể thay đổi lá phiếu bằng cách điền vào mẫu đơn phía dưới.
Ghi nhớ rằng nếu bạn làm điều này, lá phiếu trước đây của bạn sẽ bị hủy.',
	'securepoll-submit' => 'Gửi lá phiếu',
	'securepoll-gpg-receipt' => 'Cảm ơn bạn đã tham gia bỏ phiếu.

Nếu muốn, bạn có thể nhận biên lai sau để làm bằng chứng cho lá phiếu của mình:

<pre>$1</pre>',
	'securepoll-thanks' => 'Cảm ơn, phiếu bầu của bạn đã được ghi nhận.',
	'securepoll-return' => 'Trở về $1',
	'securepoll-encrypt-error' => 'Không thể mã hóa phiếu bầu của bạn.
Việc bỏ phiếu của bạn chưa được ghi lại!

$1',
	'securepoll-no-gpg-home' => 'Không thể khởi tạo thư mục chủ GPG',
	'securepoll-secret-gpg-error' => 'Có lỗi khi xử lý GPG.
Hãy dùng $wgSecurePollShowErrorDetail=true; trong LocalSettings.php để hiển thị thêm chi tiết.',
	'securepoll-full-gpg-error' => 'Có lỗi khi xử lý GPG:

Lệnh: $1

Lỗi:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Khóa GPG không được cấu hình đúng.',
	'securepoll-gpg-parse-error' => 'Có lỗi khi thông dịch dữ liệu xuất GPG.',
	'securepoll-no-decryption-key' => 'Chưa cấu hình khóa giải mã.
Không thể giải mã.',
	'securepoll-jump' => 'Đi đến máy chủ bỏ phiếu',
	'securepoll-bad-ballot-submission' => 'Phiếu bầu của bạn không hợp lệ: $1',
	'securepoll-unanswered-questions' => 'Bạn phải trả lời tất cả các câu hỏi.',
	'securepoll-invalid-rank' => 'Xếp hạng không hợp lệ. Bạn phải xếp hạng cho ứng viên trong khoảng từ 1 đến 999.',
	'securepoll-unranked-options' => 'Một số ứng viên chưa được xếp hạng.
Bạn phải xếp hạng từ 1 đến 999 cho tất cả các ứng viên.',
	'securepoll-invalid-score' => 'Số điểm phải nằm giữa $1 và $2.',
	'securepoll-unanswered-options' => 'Bạn phải cung cấp phản hồi cho mỗi câu hỏi.',
	'securepoll-remote-auth-error' => 'Lỗi khi truy xuất thông tin tài khoản của bạn từ máy chủ.',
	'securepoll-remote-parse-error' => 'Lỗi khi thông dịch phản hồi ủy quyền từ máy chủ.',
	'securepoll-api-invalid-params' => 'Thông số không hợp lệ.',
	'securepoll-api-no-user' => 'Không có thành viên nào khớp với ID cung cấp.',
	'securepoll-api-token-mismatch' => 'Dấu hiệu bảo mật không trùng, không thể đăng nhập.',
	'securepoll-not-logged-in' => 'Bạn phải đăng nhập để bỏ phiếu trong cuộc bầu cử này',
	'securepoll-too-few-edits' => 'Xin lỗi, bạn không thể bỏ phiếu. Bạn cần thực hiện tối thiểu $1 {{PLURAL:$1|sửa đổi|sửa đổi}} để bỏ phiếu trong cuộc bầu cử này, bạn chỉ mới thực hiện $2 sửa đổi.',
	'securepoll-blocked' => 'Xin lỗi, bạn không thể bỏ phiếu trong cuộc bầu cử này nếu bạn đang bị cấm không được sửa đổi.',
	'securepoll-bot' => 'Xin lỗi, tài khoản có cờ bot không được phép bỏ phiếu trong cuộc bầu cử này.',
	'securepoll-not-in-group' => 'Chỉ có những thành viên của nhóm “$1” mới có thể bỏ phiếu trong cuộc bầu cử này.',
	'securepoll-not-in-list' => 'Xin lỗi, bạn không nằm trong danh sách các thành viên được phép bỏ phiếu trong cuộc bầu cử này.',
	'securepoll-list-title' => 'Liệt kê lá phiếu: $1',
	'securepoll-header-timestamp' => 'Thời điểm',
	'securepoll-header-voter-name' => 'Tên',
	'securepoll-header-voter-domain' => 'Tên miền',
	'securepoll-header-ua' => 'Trình duyệt',
	'securepoll-header-cookie-dup' => 'Trùng',
	'securepoll-header-strike' => 'Gạch bỏ',
	'securepoll-header-details' => 'Chi tiết',
	'securepoll-strike-button' => 'Gạch bỏ',
	'securepoll-unstrike-button' => 'Phục hồi',
	'securepoll-strike-reason' => 'Lý do:',
	'securepoll-strike-cancel' => 'Hủy bỏ',
	'securepoll-strike-error' => 'Lỗi khi gạch bỏ hay phục hồi: $1',
	'securepoll-strike-token-mismatch' => 'Mất dữ liệu phiên',
	'securepoll-details-link' => 'Chi tiết',
	'securepoll-details-title' => 'Chi tiết lá phiếu: #$1',
	'securepoll-invalid-vote' => '“$1” không phải là mã lá phiếu hợp lệ',
	'securepoll-header-voter-type' => 'Loại cử tri',
	'securepoll-voter-properties' => 'Thuộc tính cử tri',
	'securepoll-strike-log' => 'Nhật trình gạch bỏ',
	'securepoll-header-action' => 'Tác vụ',
	'securepoll-header-reason' => 'Lý do',
	'securepoll-header-admin' => 'Quản lý viên',
	'securepoll-cookie-dup-list' => 'Các thành viên trùng cookie',
	'securepoll-dump-title' => 'Kết xuất: $1',
	'securepoll-dump-no-crypt' => 'Không có sẵn bản ghi đã mã hóa cho cuộc bầu cử này, vì cuộc bầu cử không được thiết lập tính năng mã hóa.',
	'securepoll-dump-not-finished' => 'Hồ sơ bầu cử đã mã hóa chỉ có sau khi kết thúc vào ngày $1 lúc $2',
	'securepoll-dump-no-urandom' => 'Không thể mở /dev/urandom.
Để bảo đảm quyền riêng tư của cử tri, các bản ghi bầu cử đã mã hóa cần được xáo trộn bằng dòng số ngẫu nhiên mã hóa trước khi công khai.',
	'securepoll-urandom-not-supported' => 'Máy chủ này không hỗ trợ tạo số ngẫu nhiên mã hóa.
Để duy trì bí mật danh tính cho người bỏ phiếu, các bản ghi bầu cử mã hóa chỉ hiển thị cho mọi người một khi chúng được xáo bằng một chuỗi số ngẫu nhiên an toàn.',
	'securepoll-translate-title' => 'Biên dịch: $1',
	'securepoll-invalid-language' => 'Mã ngôn ngữ “$1” không hợp lệ',
	'securepoll-submit-translate' => 'Cập nhật',
	'securepoll-language-label' => 'Chọn ngôn ngữ:',
	'securepoll-submit-select-lang' => 'Biên dịch',
	'securepoll-entry-text' => 'Danh sách này liệt kê các thăm dò ý kiến.',
	'securepoll-header-title' => 'Tên',
	'securepoll-header-start-date' => 'Ngày bắt đầu',
	'securepoll-header-end-date' => 'Ngày kết thúc',
	'securepoll-subpage-vote' => 'Lá phiếu',
	'securepoll-subpage-translate' => 'Biên dịch',
	'securepoll-subpage-list' => 'Danh sách',
	'securepoll-subpage-dump' => 'Kết xuất',
	'securepoll-subpage-tally' => 'Kiểm phiếu',
	'securepoll-tally-title' => 'Kiểm phiếu: $1',
	'securepoll-tally-not-finished' => 'Xin lỗi, bạn không thể kiểm phiếu cho đến khi kết thúc bỏ phiếu.',
	'securepoll-can-decrypt' => 'Bản ghi bầu cử đã được mã hóa, nhưng đã có sẵn khóa giải mã.
Bạn có thể lựa chọn hoặc kiểm kết quả hiện có trong cơ sở dữ liệu, hoặc kiểm kết quả đã mã hóa từ một tập tin được tải lên.',
	'securepoll-tally-no-key' => 'Bạn không thể kiểm phiếu cho cuộc bầu cử này, vì các lá phiếu được mã hóa, và khóa giải mã hiện chưa có.',
	'securepoll-tally-local-legend' => 'Kiểm các kết quả lưu trữ',
	'securepoll-tally-local-submit' => 'Tạo cuộc kiểm phiếu',
	'securepoll-tally-upload-legend' => 'Tải kết xuất đã mã hóa lên',
	'securepoll-tally-upload-submit' => 'Tạo cuộc kiểm phiếu',
	'securepoll-tally-error' => 'Lỗi khi thông dịch bản ghi lá phiếu, không thể tạo cuộc kiểm phiếu.',
	'securepoll-no-upload' => 'Không có tập tin nào được tải lên, không thể kiểm phiếu.',
	'securepoll-dump-corrupt' => 'Tập tin kho bị hư và không thể được xử lý.',
	'securepoll-tally-upload-error' => 'Có lỗi khi kiểm tập tin kho: $1',
	'securepoll-pairwise-victories' => 'Ma trận chiến thắng theo cặp',
	'securepoll-strength-matrix' => 'Ma trận độ mạnh đường đi',
	'securepoll-ranks' => 'Xếp hạng sau cùng',
	'securepoll-average-score' => 'Điểm số trung bình',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'securepoll-welcome' => '<strong>Benokömö, $1!</strong>',
	'securepoll-header-voter-name' => 'Nem',
	'securepoll-strike-reason' => 'Kod:',
	'securepoll-header-reason' => 'Kod',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'securepoll-invalid-page' => 'אומגילטיקער אונטערבלאט "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'איר דארפט זיין א וואלן אדמיניסטראטאר אדורכצופירן די פעולה.',
	'securepoll-too-few-params' => 'נישט גענוג אונטערבלאט פאראמעטערס (אומגילטיקער לינק).',
	'securepoll-invalid-election' => '"$1" איז נישט קיין גילטיקער אפשטימונג  ID.',
	'securepoll-welcome' => '<strong>ברוך הבא, $1!</strong>',
	'securepoll-not-started' => 'די אפשטימונג האט נאך נישט אנגעהויבן.
זי איז באשטימט אנצוהייבן אום $2 אזייגער $3.',
	'securepoll-finished' => 'די אפשטימונג האט שוין געקאנטשעט, איר קענט מער נישט אפשטימען.',
	'securepoll-gpg-receipt' => 'א דאנק פארן שטימען.

ווען איר ווילט, קענט איר היטן דעם פאלגנדן קוויט אלס ראיה פון אייער שטים.

<pre>$1</pre>',
	'securepoll-return' => 'צוריק צו $1',
	'securepoll-bad-ballot-submission' => 'אייער שטים איז געווען אומגילטיג.',
	'securepoll-unanswered-questions' => 'איר מוזט ענטפערן אלע שאלות.',
	'securepoll-api-invalid-params' => 'אומגילטיגע פאראמעטערס',
	'securepoll-not-logged-in' => 'איר מוזט אריינלאגירן צו שטימען אין דער אפשטימונג',
	'securepoll-blocked' => 'אנטשולדיגט, איר קענט נישט שטימען אין די וואלן אויב איר זענט אצינד בלאקירט פון רעדאקטירן.',
	'securepoll-not-in-group' => 'נאר מיטגלידער פון דער "$1" גרופע קענען שטימען אין די וואלן. ',
	'securepoll-header-timestamp' => 'צײַט',
	'securepoll-header-voter-name' => 'נאָמען',
	'securepoll-strike-reason' => 'אורזאַך:',
	'securepoll-header-reason' => 'אורזאַך',
	'securepoll-header-admin' => 'אַדמיניסטראַטאר',
	'securepoll-translate-title' => 'פֿארטייטשן : $1',
	'securepoll-invalid-language' => 'אומגילטיקער שפראך קאד  "$1"',
	'securepoll-submit-translate' => 'דערהײַנטיקן',
	'securepoll-language-label' => 'אויסקלייבן שפראך:',
	'securepoll-submit-select-lang' => 'פארטייטשן',
	'securepoll-header-title' => 'נאָמען',
	'securepoll-subpage-list' => 'ליסטע',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'securepoll' => '安全投票',
	'securepoll-desc' => '選舉同調查嘅擴展',
	'securepoll-invalid-page' => '無效嘅細頁 "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => '你需要係一位管理員去做呢個動作。',
	'securepoll-too-few-params' => '唔夠細頁參數（無效連結）。',
	'securepoll-invalid-election' => '"$1"唔係一個有效嘅選舉ID。',
	'securepoll-welcome' => '<strong>歡迎$1！</strong>',
	'securepoll-not-started' => '個選舉重未開始。
佢將會響$2 $3開始。',
	'securepoll-finished' => '個選舉已經結束，你唔可以再投票。',
	'securepoll-not-qualified' => '你未有資格響呢次選舉度投票: $1',
	'securepoll-change-disallowed' => '你之前已經響呢次選舉度投咗票。
對唔住，你唔可以再投。',
	'securepoll-change-allowed' => '<strong>注意: 你之前已經響呢次選舉度投咗票。</strong>
你可以用下面嘅表格去改你嘅投票。
要留意如果你做呢個，噉你原先嘅投票就會捨棄。',
	'securepoll-submit' => '遞交投票',
	'securepoll-gpg-receipt' => '多謝你嘅投票。

如果你想嘅話，你可以留底下面嘅收條去證明咗你已經投咗票:

<pre>$1</pre>',
	'securepoll-thanks' => '多謝，你嘅一票已經紀錄咗。',
	'securepoll-return' => '返去$1',
	'securepoll-encrypt-error' => '加密你嘅投票紀錄失敗。
你嘅投票無紀錄到！

$1',
	'securepoll-no-gpg-home' => '開唔到GPG home目錄。',
	'securepoll-secret-gpg-error' => '執行GPG出錯。
響LocalSettings.php用$wgSecurePollShowErrorDetail=true;去顯示更多資料。',
	'securepoll-full-gpg-error' => '執行GPG出錯:

指令: $1

錯:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG匙未能正班噉設定。',
	'securepoll-gpg-parse-error' => '處理GPG輸出出錯。',
	'securepoll-no-decryption-key' => '未設定解密匙。
唔可以解密。',
	'securepoll-jump' => '去緊投票伺服器',
	'securepoll-bad-ballot-submission' => '<div class="securepoll-error-box">
	你嘅投票無效: $1
	</div>',
	'securepoll-unanswered-questions' => '你一定要答全部嘅問題。',
	'securepoll-remote-auth-error' => '由伺服器度擷取你戶口時出錯。',
	'securepoll-remote-parse-error' => '由伺服器處理認證回應時出錯。',
	'securepoll-api-invalid-params' => '無效嘅參數。',
	'securepoll-api-no-user' => '呢個ID搵唔到用戶。',
	'securepoll-api-token-mismatch' => '安全幣唔對，唔可以登入。',
	'securepoll-not-logged-in' => '你一定要登入咗先可以響呢次選舉度投票',
	'securepoll-too-few-edits' => '對唔住，你唔可以投票。你需要有最少$1次編輯先可以投票，你而家有$2次。',
	'securepoll-blocked' => '對唔住，當你而家被封鎖嗰陣唔可以響呢次選舉度投票。',
	'securepoll-bot' => '對唔住，有機械人旗嘅戶口係唔容許響呢次選舉度投票。',
	'securepoll-not-in-group' => '只有『$1』組嘅成員先可以響呢次選舉度投票。',
	'securepoll-not-in-list' => '對唔住，你唔係響呢個認可用戶表響呢次選舉度投票。',
	'securepoll-list-title' => '列票: $1',
	'securepoll-header-timestamp' => '時間',
	'securepoll-header-voter-name' => '名',
	'securepoll-header-voter-domain' => '網域',
	'securepoll-header-ua' => '用戶客戶',
	'securepoll-header-cookie-dup' => '重覆',
	'securepoll-header-strike' => '刪除綫',
	'securepoll-header-details' => '細節',
	'securepoll-strike-button' => '刪除綫',
	'securepoll-unstrike-button' => '反刪除綫',
	'securepoll-strike-reason' => '原因:',
	'securepoll-strike-cancel' => '取消',
	'securepoll-strike-error' => '進行刪除／反刪除時出錯: $1',
	'securepoll-details-link' => '細節',
	'securepoll-details-title' => '投票細節: #$1',
	'securepoll-invalid-vote' => '"$1"唔係一個有效嘅投票ID',
	'securepoll-header-voter-type' => '投票者類型',
	'securepoll-voter-properties' => '投票者屬性',
	'securepoll-strike-log' => '刪除紀錄',
	'securepoll-header-action' => '動作',
	'securepoll-header-reason' => '原因',
	'securepoll-header-admin' => '管理',
	'securepoll-cookie-dup-list' => '重覆cookie嘅用戶',
	'securepoll-dump-title' => ' 傾印: $1',
	'securepoll-dump-no-crypt' => '呢次選舉無加密選舉紀錄，因為選舉未設定去用加密。',
	'securepoll-dump-not-finished' => '加密選舉紀錄只會響 $1 $2 投票結束之後先至會提供',
	'securepoll-dump-no-urandom' => '開唔到 /dev/urandom。 
去維持投票者嘅私隱，加密咗嘅紀錄只會響佢哋用亂數重整之後先會公開。',
	'securepoll-translate-title' => '翻譯: $1',
	'securepoll-invalid-language' => '無效嘅語言碼"$1"',
	'securepoll-submit-translate' => '更新',
	'securepoll-language-label' => '揀語言:',
	'securepoll-submit-select-lang' => '翻譯',
	'securepoll-header-title' => '名',
	'securepoll-header-start-date' => '開始日',
	'securepoll-header-end-date' => '結束日',
	'securepoll-subpage-vote' => '投票',
	'securepoll-subpage-translate' => '翻譯',
	'securepoll-subpage-list' => '表',
	'securepoll-subpage-dump' => '傾印',
	'securepoll-subpage-tally' => '記數',
	'securepoll-tally-title' => '記數: $1',
	'securepoll-tally-not-finished' => '對唔住，響投票完成之前，你唔可以將選舉記數。',
	'securepoll-can-decrypt' => '個選舉紀錄加密咗，但係有解密匙。 
	你可以揀個記數響個資料庫做，或者衵一個上載檔案度記數個加密咗嘅結果。',
	'securepoll-tally-no-key' => '你唔可以響呢次選舉度記數，因為投票加密咗，又有解密匙。',
	'securepoll-tally-local-legend' => '記數存咗嘅結果',
	'securepoll-tally-local-submit' => '整記數',
	'securepoll-tally-upload-legend' => '上載加密咗嘅傾印',
	'securepoll-tally-upload-submit' => '整記數',
	'securepoll-tally-error' => '處理投票紀錄時出錯，整唔到記數。',
	'securepoll-no-upload' => '無檔案上載，整唔到記數結果。',
);

/** Zhuang (Vahcuengh)
 * @author Biŋhai
 */
$messages['za'] = array(
	'securepoll' => 'Douzbiuq Ancienz',
	'securepoll-desc' => 'senjgij caez gyahung douzbiuq',
	'securepoll-invalid-page' => 'bienj fouzyauq "<nowiki>$1</nowiki>"',
	'securepoll-welcome' => '<strong>Vanhyingz $1!</strong>',
	'securepoll-return' => 'baema $1',
	'securepoll-header-admin' => 'guenjleixguenj',
	'securepoll-submit-translate' => 'swnggaep',
	'securepoll-header-title' => 'Mingz',
	'securepoll-subpage-vote' => 'Douzbiuq',
	'securepoll-subpage-list' => 'Biuj',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Biŋhai
 * @author FireJackey
 * @author Liangent
 * @author PhiLiP
 * @author Skjackey tse
 */
$messages['zh-hans'] = array(
	'securepoll' => '安全投票',
	'securepoll-desc' => '选举和投票扩展',
	'securepoll-invalid-page' => '无效的子页面「<nowiki>$1</nowiki>」',
	'securepoll-need-admin' => '您必须是选举管理员才能进行此操作。',
	'securepoll-too-few-params' => '缺少子页面参数（无效链接）。',
	'securepoll-invalid-election' => '「$1」不是有效的选举投票编号。',
	'securepoll-welcome' => '<strong>欢迎$1！</strong>',
	'securepoll-not-started' => '这个投票尚未开始。
按计划将于$2 $3开始。',
	'securepoll-finished' => '投票已经结束，您无法再投下选票。',
	'securepoll-not-qualified' => '您不具有参与投票的资格：$1',
	'securepoll-change-disallowed' => '您已经参与过本次投票。对不起，您不能再次投票。',
	'securepoll-change-allowed' => '<strong>注意：您曾经在本次投票中投下一票。</strong>您可以提交下面的表格并更改您的选票。请注意若您更改选票，原先的选票将作废。',
	'securepoll-submit' => '提交投票',
	'securepoll-gpg-receipt' => '感谢您的投票。

您可以保留下面的回执作为您参与投票的证据：

<pre>$1</pre>',
	'securepoll-thanks' => '谢谢您，您的投票已被记录。',
	'securepoll-return' => '回到$1',
	'securepoll-encrypt-error' => '投票记录加密失败。
您的投票未被记录。

$1',
	'securepoll-no-gpg-home' => '无法创建GPG主目录。',
	'securepoll-secret-gpg-error' => '执行GPG出错。
在LocalSettings.php中使用$wgSecurePollShowErrorDetail=true;以查看更多细节。',
	'securepoll-full-gpg-error' => '执行GPG错误：

命令：$1

错误：
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG密匙配置错误。',
	'securepoll-gpg-parse-error' => '解释GPG输出时出错。',
	'securepoll-no-decryption-key' => '解密密匙未配置。
无法解密。',
	'securepoll-jump' => '进入投票服务器',
	'securepoll-bad-ballot-submission' => '您的投票无效：$1',
	'securepoll-unanswered-questions' => '您必须回答所有问题。',
	'securepoll-invalid-rank' => '评级无效。给候选人的评级分数必须在1到999之间。',
	'securepoll-unranked-options' => '部分选项尚未评级。所有选项均应评级，且分数应在1到999之间。',
	'securepoll-invalid-score' => '分数必须介于$1和$2之间。',
	'securepoll-unanswered-options' => '您必须回答每一个问题。',
	'securepoll-remote-auth-error' => '从服务器提取您的用户信息时出错。',
	'securepoll-remote-parse-error' => '服务器验证出错。',
	'securepoll-api-invalid-params' => '参数无效。',
	'securepoll-api-no-user' => '无法找到指定ID的用户。',
	'securepoll-api-token-mismatch' => '安全标记不符，无法登录。',
	'securepoll-not-logged-in' => '您必须登录后方可投票。',
	'securepoll-too-few-edits' => '对不起，您不能投票。您必须至少进行$1{{PLURAL:$1|次|次}}编辑才能参与本次投票。您目前的编辑次数为$2。',
	'securepoll-blocked' => '对不起，您目前被封禁因此无法参与本次投票。',
	'securepoll-bot' => '对不起，拥有机器人权限的账户不能参与本次投票。',
	'securepoll-not-in-group' => '只有属于“$1”用户组的用户可以投票。',
	'securepoll-not-in-list' => '对不起，您不在投票人名单中，无法参与本次投票。',
	'securepoll-list-title' => '投票列表：$1',
	'securepoll-header-timestamp' => '时间',
	'securepoll-header-voter-name' => '名称',
	'securepoll-header-voter-domain' => '域名',
	'securepoll-header-ua' => '用户代理',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => '删除选票',
	'securepoll-header-details' => '细节',
	'securepoll-strike-button' => '删除选票',
	'securepoll-unstrike-button' => '恢复选票',
	'securepoll-strike-reason' => '原因：',
	'securepoll-strike-cancel' => '取消',
	'securepoll-strike-error' => '进行删除选票/恢复被删除选票时出错：$1',
	'securepoll-strike-token-mismatch' => '丢失会话数据',
	'securepoll-details-link' => '细节',
	'securepoll-details-title' => '投票细节：#$1',
	'securepoll-invalid-vote' => '“$1”不是有效的投票ID',
	'securepoll-header-voter-type' => '投票用户类型',
	'securepoll-voter-properties' => '投票人属性',
	'securepoll-strike-log' => '删除选票日志',
	'securepoll-header-action' => '动作',
	'securepoll-header-reason' => '原因',
	'securepoll-header-admin' => '管理员',
	'securepoll-cookie-dup-list' => 'Cookie重复的用户',
	'securepoll-dump-title' => 'Dump：$1',
	'securepoll-dump-no-crypt' => '本次投票没有被加密的投票记录，因为它被配置为不须加密。',
	'securepoll-dump-not-finished' => '加密的投票记录只有在截止日期$1 $2后方可获得',
	'securepoll-dump-no-urandom' => '无法打开/dev/urandom。为了保证投票者的隐私，经过加密的投票记录只有在经随机数据串干涉后方可公开。',
	'securepoll-urandom-not-supported' => '本服务器并不支持密文随机数生成。
为了保证投票者的隐私，经过加密的投票记录只有在经随机数据串干涉后方可公开。',
	'securepoll-translate-title' => '翻译：$1',
	'securepoll-invalid-language' => '无效的语言代码“$1”',
	'securepoll-submit-translate' => '更新',
	'securepoll-language-label' => '选择语言：',
	'securepoll-submit-select-lang' => '翻译',
	'securepoll-entry-text' => '下面是所有选举的列表。',
	'securepoll-header-title' => '名称',
	'securepoll-header-start-date' => '开始日期',
	'securepoll-header-end-date' => '结束日期',
	'securepoll-subpage-vote' => '投票',
	'securepoll-subpage-translate' => '翻译',
	'securepoll-subpage-list' => '列表',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => '计票',
	'securepoll-tally-title' => '计票：$1',
	'securepoll-tally-not-finished' => '对不起，您只有在投票完成后方可计票。',
	'securepoll-can-decrypt' => '投票记录已被加密，但可获得密匙。您可以选择对当前数据库中的数据进行点票，或上传一个包含加密结果的文件以进行点票。',
	'securepoll-tally-no-key' => '您无法对本次投票进行点票，因为选票已被加密，并无法获得解密密匙。',
	'securepoll-tally-local-legend' => '点票结果',
	'securepoll-tally-local-submit' => '新建点票数据',
	'securepoll-tally-upload-legend' => '上传已加密的数据',
	'securepoll-tally-upload-submit' => '创建点票数据',
	'securepoll-tally-error' => '处理投票记录时出错，无法创建点票数据。',
	'securepoll-no-upload' => '没有上传文件。',
	'securepoll-dump-corrupt' => '无法处理损坏的转储文件。',
	'securepoll-tally-upload-error' => '转储文件记录错误：$1',
	'securepoll-pairwise-victories' => '对比矩阵',
	'securepoll-strength-matrix' => 'Path strength矩阵',
	'securepoll-ranks' => '最终排名',
	'securepoll-average-score' => '平均分',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Bencmq
 * @author FireJackey
 * @author Gaoxuewei
 * @author Liangent
 * @author Mark85296341
 * @author PhiLiP
 * @author Skjackey tse
 * @author Wong128hk
 */
$messages['zh-hant'] = array(
	'securepoll' => '安全投票',
	'securepoll-desc' => '投票及選舉擴展',
	'securepoll-invalid-page' => '無效的子頁面「<nowiki>$1</nowiki>」',
	'securepoll-need-admin' => '您必須是選舉管理員才能進行此操作。',
	'securepoll-too-few-params' => '缺少子頁面參數（無效鏈接）。',
	'securepoll-invalid-election' => '「$1」不是有效的選舉編號。',
	'securepoll-welcome' => '<strong>歡迎$1！</strong>',
	'securepoll-not-started' => '這個選舉尚未開始。
按計劃將於$2 $3開始。',
	'securepoll-finished' => '投票已經結束，無法投票。',
	'securepoll-not-qualified' => '您不具有於是次選舉中參與表決的資格︰$1',
	'securepoll-change-disallowed' => '您已於是次選舉中投票。
閣下恕未可再次投票。',
	'securepoll-change-allowed' => '<strong>請注意您已於較早前於是次選舉中投票。</strong>
您可以透過遞交以下的表格改動您的投票。
惟請注意，若然閣下作出此番舉動，閣下原先所投之票將變為廢票。',
	'securepoll-submit' => '遞交投票',
	'securepoll-gpg-receipt' => '多謝您參與投票。

閣下可以保留以下收條以作為參與過是次投票的憑證︰

<pre>$1</pre>',
	'securepoll-thanks' => '感謝，閣下的投票已被紀錄。',
	'securepoll-return' => '回到$1',
	'securepoll-encrypt-error' => '投票紀錄加密失敗。
您的投票未被紀錄。

$1',
	'securepoll-no-gpg-home' => '無法建立GPG主目錄。',
	'securepoll-secret-gpg-error' => '執行GPG出錯。
於LocalSettings.php中使用$wgSecurePollShowErrorDetail=true;以展示更多細節。',
	'securepoll-full-gpg-error' => '執行GPG錯誤：

命令：$1

錯誤：
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG密匙配置錯誤。',
	'securepoll-gpg-parse-error' => '解釋GPG輸出時出錯。',
	'securepoll-no-decryption-key' => '解密密匙未配置。
無法解密。',
	'securepoll-jump' => '進入投票伺服器',
	'securepoll-bad-ballot-submission' => '您的投票無效︰$1',
	'securepoll-unanswered-questions' => '您必須回答所有問題。',
	'securepoll-invalid-rank' => '評級無效。給候選人的評級分數必須在1到999之間。',
	'securepoll-unranked-options' => '部分選項尚未評級。所有選項均應評級，且分數應在1到999之間。',
	'securepoll-invalid-score' => '分數必須介於$1和$2之間。',
	'securepoll-unanswered-options' => '您必須回答每一個問題。',
	'securepoll-remote-auth-error' => '在投票伺服器提取您的用户資訊時出錯',
	'securepoll-remote-parse-error' => '伺服器驗證錯誤',
	'securepoll-api-invalid-params' => '參數無效',
	'securepoll-api-no-user' => '無法找到此指定ID的用戶。',
	'securepoll-api-token-mismatch' => '安全信物不符，無法登入。',
	'securepoll-not-logged-in' => '您必須在投票前登錄。',
	'securepoll-too-few-edits' => '對不起，您未能參與投票。您必須最少進行$1次編輯才能參與是次投票，而您目前的編輯次數為$2。',
	'securepoll-blocked' => '對不起，因為您目前已被封禁所以您無法參與本之投票。',
	'securepoll-bot' => '抱歉，擁有機器人權限的用戶不能參與本投票。',
	'securepoll-not-in-group' => '只有屬於用戶組「$1」的用戶才可以投票。',
	'securepoll-not-in-list' => '對不起，由於您不在投票人名單，所以您無權參與是次投票。',
	'securepoll-list-title' => '投票列表︰$1',
	'securepoll-header-timestamp' => '時間',
	'securepoll-header-voter-name' => '名稱',
	'securepoll-header-voter-domain' => '域名',
	'securepoll-header-ua' => '用戶代理',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => '刪除投票',
	'securepoll-header-details' => '詳情',
	'securepoll-strike-button' => '刪除',
	'securepoll-unstrike-button' => '恢復選票',
	'securepoll-strike-reason' => '理由：',
	'securepoll-strike-cancel' => '取消',
	'securepoll-strike-error' => '進行刪除選票/恢復被刪除選票時出錯：$1',
	'securepoll-strike-token-mismatch' => '丟失會話資料',
	'securepoll-details-link' => '細節',
	'securepoll-details-title' => '投票詳情︰#$1',
	'securepoll-invalid-vote' => '「$1」不是有效的投票ID',
	'securepoll-header-voter-type' => '投票用戶類型',
	'securepoll-voter-properties' => '投票人資訊',
	'securepoll-strike-log' => '刪除選票日誌',
	'securepoll-header-action' => '動作',
	'securepoll-header-reason' => '原因',
	'securepoll-header-admin' => '管理員',
	'securepoll-cookie-dup-list' => 'Cookie重複的用戶',
	'securepoll-dump-title' => '傾卸：$1',
	'securepoll-dump-no-crypt' => '本次投票沒有被加密的投票記錄，因為它被設定為不須加密。',
	'securepoll-dump-not-finished' => '被加密的投票記錄只有在截止日期$1 $2後方可取得',
	'securepoll-dump-no-urandom' => '無法打開/dev/urandom。
為了保證投票者的隱私，經過加密的投票記錄只有在經隨機數據串干擾後方可公開。',
	'securepoll-urandom-not-supported' => '本伺服器並不支持密文隨機數生成。
為了保證投票者的隱私，經過加密的投票記錄只有在經隨機數據串干擾後方可公開。',
	'securepoll-translate-title' => '翻譯：$1',
	'securepoll-invalid-language' => '錯誤的語言代碼：「$1」',
	'securepoll-submit-translate' => '更新',
	'securepoll-language-label' => '請選擇語言：',
	'securepoll-submit-select-lang' => '翻譯',
	'securepoll-entry-text' => '下面是所有選舉的列表。',
	'securepoll-header-title' => '名稱',
	'securepoll-header-start-date' => '開始日期',
	'securepoll-header-end-date' => '結束日期',
	'securepoll-subpage-vote' => '投票',
	'securepoll-subpage-translate' => '翻譯',
	'securepoll-subpage-list' => '列表',
	'securepoll-subpage-dump' => '傾卸',
	'securepoll-subpage-tally' => '計票',
	'securepoll-tally-title' => '計票：$1',
	'securepoll-tally-not-finished' => '抱歉，您只能在投票完成後才可計票',
	'securepoll-can-decrypt' => '投票記錄已被加密，但可獲得金鑰。您可以選擇對目前資料庫中的數據進行計票，或上傳一個包含加密結果的文件以進行計票。',
	'securepoll-tally-no-key' => '您無法對本次投票進行計票，因為選票已被加密，並且無法取得解密金鑰。',
	'securepoll-tally-local-legend' => '計票結果',
	'securepoll-tally-local-submit' => '新增計票數據',
	'securepoll-tally-upload-legend' => '上傳已加密的數據',
	'securepoll-tally-upload-submit' => '新增計票數據',
	'securepoll-tally-error' => '投票記錄發生錯誤，無法新增計票數據。',
	'securepoll-no-upload' => '沒有上傳文件。',
	'securepoll-dump-corrupt' => '無法處理損壞的轉儲檔案。',
	'securepoll-tally-upload-error' => '轉儲檔案記錄錯誤：$1',
	'securepoll-pairwise-victories' => '對比矩陣',
	'securepoll-strength-matrix' => 'Path strength矩陣',
	'securepoll-ranks' => '最終排名',
	'securepoll-average-score' => '平均分',
);

/** Chinese (Hong Kong) (‪中文(香港)‬)
 * @author FireJackey
 * @author Skjackey tse
 */
$messages['zh-hk'] = array(
	'securepoll-dump-no-urandom' => '無法打開/dev/urandom。
為了保證投票者的私隱，經過加密的投票記錄只有在經隨機數據串干擾後方可公開。',
);

