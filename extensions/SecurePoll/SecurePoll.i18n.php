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
	'securepoll-too-new' => 'Sorry, you cannot vote.  Your account needs to have been registered before $1 at $3 to vote in this election, you registered on $2 at $4.',
	'securepoll-blocked' => 'Sorry, you cannot vote in this election if you are currently blocked from editing.',
	'securepoll-blocked-centrally' => 'Sorry, you cannot vote in this election as you are blocked on at least $1 {{PLURAL:$1|wiki|wikis}}.',
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
	'securepoll-round' => 'Round $1',
	'securepoll-spoilt' => '(Spoilt)',
	'securepoll-exhausted' => '(Exhausted)',
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
	'securepoll-too-new' => 'Parameters:
* $1 is the required registration date
* $2 is the actual registration date
* $3 is the required registration time
* $4 is the actual registration time',
	'securepoll-header-timestamp' => '{{Identical|Time}}',
	'securepoll-header-voter-name' => '{{Identical|Name}}',
	'securepoll-header-voter-domain' => '{{Identical|Domain}}',
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
	'securepoll-subpage-vote' => '{{Identical|Vote}}
Link text to a sub page in the SecurePoll extension where users can vote.',
	'securepoll-subpage-translate' => '{{Identical|Translate}}
Link text to a sub page in the SecurePoll extension where users can translate poll related texts.',
	'securepoll-subpage-list' => 'Link text to a sub page in the SecurePoll extension where users can list poll information.',
	'securepoll-subpage-dump' => 'Link text to a sub page in the SecurePoll extension where users can dump results.',
	'securepoll-subpage-tally' => 'Link text to a sub page in the SecurePoll extension where users can tally.',
	'securepoll-round' => 'Column header for tables on tallies which take place over multiple rounds; parameter is a roman numeral.',
	'securepoll-spoilt' => 'Row label for counting ballots which were spoilt, that is not correctly filled in or indecipherable.',
	'securepoll-exhausted' => 'Row label for counting ballots which have been exhausted in a multi-round counting system',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'securepoll' => 'VeiligStem',
	'securepoll-desc' => 'Uitbreiding vir stemmings en opnames',
	'securepoll-invalid-page' => 'Ongeldige subbladsy "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => "Jy moet 'n verkiesing administrateur om hierdie aksie uit te voer.",
	'securepoll-too-few-params' => 'Nie genoeg subpagina parameters (ongeldige skakel).',
	'securepoll-invalid-election' => '"$1" is nie \'n geldig ID vir \'n stemmig nie.',
	'securepoll-welcome' => '<strong>Welkom, $1!</strong>',
	'securepoll-finished' => 'Hierdie stemming is afgehandel, u kan nie meer stem nie.',
	'securepoll-change-disallowed' => 'Jy het stemme in hierdie verkiesing voor.
Jammer, kan jy nie weer stem nie.',
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
	'securepoll-gpg-config-error' => 'GPG-sleutels word verkeerd ingestel.',
	'securepoll-gpg-parse-error' => 'Fout met die interpretasie van GPG uitset.',
	'securepoll-no-decryption-key' => 'Geen dekripsiesleutel is ingestel.
Kan nie decrypt.',
	'securepoll-jump' => 'Gaan na die stemming-bediener',
	'securepoll-bad-ballot-submission' => 'U stem is ongeldig: $1',
	'securepoll-unanswered-questions' => 'U moet alle vrae beantwoord.',
	'securepoll-unranked-options' => "Sommige opsies is nie ingedeel.
Jy moet alle opsies om 'n rang tussen 1 en 999.",
	'securepoll-invalid-score' => "Die telling moet 'n getal tussen $1 en $2 wees.",
	'securepoll-unanswered-options' => 'U moet al die vrae beantwoord.',
	'securepoll-remote-auth-error' => "'n Fout het voorgekom met die opkyk van u rekening se inligting vanaf die bediener.",
	'securepoll-api-invalid-params' => 'Ongeldige parameters.',
	'securepoll-api-no-user' => 'Geen gebruiker met die gegewe ID gevind nie.',
	'securepoll-api-token-mismatch' => 'Sekuriteit gebrand mismatch, kan nie inteken.',
	'securepoll-not-logged-in' => 'Jy moet in teken om te stem in hierdie verkiesing',
	'securepoll-blocked' => 'Jammer, kan jy nie stem in hierdie verkiesing As jy tans geblokkeer.',
	'securepoll-bot' => "Jammer, gebruikers met 'n botvlag word nie toegelaat om aan die stemming deel te neem nie.",
	'securepoll-not-in-group' => 'Slegs lede van die groep "$1" kan aan hierdie stemming deelneem.',
	'securepoll-not-in-list' => 'Jammer, jy is nie in die voorafbepaalde lys van gebruikers wat gemagtig is om te stem in hierdie verkiesing.',
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
	'securepoll-dump-no-crypt' => 'Geen geïnkripteer verkiesing rekord is beskikbaar vir hierdie verkiesing, want die verkiesing is nie ingestel om die enkripsie te gebruik.',
	'securepoll-urandom-not-supported' => "Hierdie bediener ondersteun nie kriptografiese lukraakgetalgenerasie.
Kieser privaatheid te handhaaf, is geïnkripteer verkiesing rekords is slegs publiek beskikbaar is wanneer hulle skuifel kan word met 'n veilige ewekansige getal stroom.",
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
	'securepoll-tally-not-finished' => 'Jammer, kan jy nie kerfstok die verkiesing tot na die stem is voltooi.',
	'securepoll-can-decrypt' => "Die verkiesing rekord is geïnkripteer, maar die dekripsie sleutel is beskikbaar.
Jy kan kies om óf kerfstok die resultate wat in die databasis teenwoordig is, of aan kerfstok geïnkripteer resultate van 'n opgelaai lêer.",
	'securepoll-tally-no-key' => 'Jy kan nie kerfstok hierdie verkiesing, omdat die stemme word geïnkripteer, en die dekripsiesleutel nie beskikbaar is nie nie.',
	'securepoll-tally-local-legend' => 'Telling gestoor resultate',
	'securepoll-tally-local-submit' => 'Skep telling',
	'securepoll-tally-upload-legend' => 'Foto geïnkripteer dump',
	'securepoll-tally-upload-submit' => 'Skep telling',
	'securepoll-no-upload' => 'Geen lêer is opgelaai nie.
Die resultate kan nie getel word nie.',
	'securepoll-pairwise-victories' => 'Twee-oorwinning matriks',
	'securepoll-strength-matrix' => 'Pad krag Matrix',
	'securepoll-ranks' => 'Eindstand',
	'securepoll-average-score' => 'Gemiddelde punt',
	'securepoll-round' => 'Ronde $1',
	'securepoll-spoilt' => '(Bedorwe)',
	'securepoll-exhausted' => '(Uitgeput)',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'securepoll-remote-parse-error' => 'Gabim gjatë interpretimit përgjigje autorizim nga serveri.',
	'securepoll-api-invalid-params' => 'parametrat e pavlefshme.',
	'securepoll-api-no-user' => 'Asnjë përdorues u gjet me ID e dhënë.',
	'securepoll-api-token-mismatch' => 'dhëna të dëmtuara në shenjë të Sigurimit, nuk mund të hyni in',
	'securepoll-not-logged-in' => 'Ju duhet të identifikoheni për të votuar në këto zgjedhje',
	'securepoll-too-few-edits' => 'Na vjen keq, ju nuk mund të votojnë. Ju duhet të keni bërë së paku $1 {{PLURAL:$1||redaktim|redaktimet}} për të votuar në këto zgjedhje, ju keni bërë $2.',
	'securepoll-blocked' => 'Na vjen keq, ju nuk mund të votojnë në këto zgjedhje, nëse ju jeni bllokuar për momentin nga redaktimi.',
	'securepoll-bot' => 'Na vjen keq, llogaritë me flamurin bot nuk lejohen të votojnë në këto zgjedhje.',
	'securepoll-not-in-group' => 'Vetëm anëtarët e "$1 grup" mund të votojnë në këto zgjedhje.',
	'securepoll-not-in-list' => 'Na vjen keq, ju nuk jeni në listën e të paracaktuar të përdoruesve të autorizuar për të votuar në këto zgjedhje.',
	'securepoll-list-title' => 'vota List: $1',
	'securepoll-header-timestamp' => 'Kohë',
	'securepoll-header-voter-name' => 'Emër',
	'securepoll-header-voter-domain' => 'Sferë',
	'securepoll-header-ua' => 'Agjent Përdoruesi',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Grevë',
	'securepoll-header-details' => 'Detaje',
	'securepoll-strike-button' => 'Grevë',
	'securepoll-unstrike-button' => 'Unstrike',
	'securepoll-strike-reason' => 'Arsyeja:',
	'securepoll-strike-cancel' => 'Anuloj',
	'securepoll-strike-error' => 'Greva Gabim kryerjes / unstrike: $1',
	'securepoll-strike-token-mismatch' => 'Të dhënat Sesioni humbur',
	'securepoll-details-link' => 'Detaje',
	'securepoll-details-title' => 'Voto detajet: #$1',
	'securepoll-invalid-vote' => '"$1" nuk është një votë të vlefshme ID',
	'securepoll-header-voter-type' => 'Lloji i votuesve',
	'securepoll-voter-properties' => 'pronat e votuesve',
	'securepoll-strike-log' => 'log Strike',
	'securepoll-header-action' => 'Veprim',
	'securepoll-header-reason' => 'Arsye',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Cookie kopjuar përdoruesit',
	'securepoll-dump-title' => 'Derdhin: $1',
	'securepoll-dump-no-crypt' => 'Nuk ka rekord Encrypted zgjedhore është në dispozicion për këtë zgjedhje, sepse zgjedhjet nuk është i konfiguruar të përdorë encryption.',
	'securepoll-dump-not-finished' => 'Encrypted zgjedhjeve të dhënat janë në dispozicion vetëm pas datës përfundojë më $1 tek $2',
	'securepoll-dump-no-urandom' => 'Nuk mund te hap / dev / urandom. Për të ruajtur fshehtësinë e votuesve, Encrypted të dhënat e zgjedhjeve janë vetëm publikisht në dispozicion kur ato mund të jenë riorganizoi me një lumë të rastit numër të sigurt.',
	'securepoll-urandom-not-supported' => 'Ky server nuk suporton kriptografike numër të brezit të rastit. Për të ruajtur fshehtësinë e votuesve, Encrypted të dhënat e zgjedhjeve janë vetëm publikisht në dispozicion kur ato mund të jenë riorganizoi me një lumë të rastit numër të sigurt.',
	'securepoll-translate-title' => 'Translate: $1',
	'securepoll-invalid-language' => 'kod i pavlefshëm gjuhën "$1"',
	'securepoll-submit-translate' => 'Update',
	'securepoll-language-label' => 'Zgjidh gjuhën:',
	'securepoll-submit-select-lang' => 'Përkthej',
	'securepoll-entry-text' => 'Më poshtë është lista e votimit.',
	'securepoll-header-title' => 'Emër',
	'securepoll-header-start-date' => 'Data Fillim',
	'securepoll-header-end-date' => 'Data Fundi',
	'securepoll-subpage-vote' => 'Votim',
	'securepoll-subpage-translate' => 'Përkthej',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Extensions ta esleccions y encuentas',
	'securepoll-invalid-page' => 'Subpachina invalida «<nowiki>$1</nowiki>»',
	'securepoll-need-admin' => "Cal que sía un administrador d'eslecions ta fer ista acción.",
	'securepoll-too-few-params' => 'Parametros de subpágina insuficients (vinclo invalido).',
	'securepoll-invalid-election' => "«$1» no ye un identificador d'esleción valido.",
	'securepoll-welcome' => '<strong>Bienplegau $1!</strong>',
	'securepoll-not-started' => 'Ista esleción encara no ha prencipiau.
Ye programada ta prencipiar en $2 de $3.',
	'securepoll-finished' => 'Ista esleción ha concluiu, no puet votar mas.',
	'securepoll-not-qualified' => 'No cumple as condicions ta poder votar en ista eslección: $1',
	'securepoll-change-disallowed' => 'Ya ha votau denantes en ista eslección.
Lo siento, no puede tornar a votar.',
	'securepoll-change-allowed' => "<strong>Nota: Ya ha votau en ista eslección.</strong>
Puet cambiar o suyo voto ninviando o formulario d'abaixo.
Note que si fa isto, o suyo voto orichinal será descartau.",
	'securepoll-submit' => 'Ninviar voto',
	'securepoll-gpg-receipt' => "Gracias por votar.

Si lo deseya, puet alzar o siguient recibo como evidencia d'o suyo voto:

<pre>$1</pre>",
	'securepoll-thanks' => "Gracias, o suyo voto s'ha rechistrau.",
	'securepoll-return' => 'Tornar ta $1.',
	'securepoll-encrypt-error' => "No s'ha puesto zifrar o suyo rechistro de voto.
O tuyo voto no s'ha rechistrau!

$1",
	'securepoll-no-gpg-home' => 'Ye imposible de creyar un directorio-casa GPG.',
	'securepoll-secret-gpg-error' => 'Error entre que s\'executando GPG.
Usar $wgSecurePollShowErrorDetail=true; en LocalSettings.php ta amostrar mas detalles.',
	'securepoll-full-gpg-error' => 'Error en executar GPG:

Comando: $1

Error:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'As teclas GPG no son bien configuradas.',
	'securepoll-gpg-parse-error' => 'Error en interpretar a salida GPG.',
	'securepoll-no-decryption-key' => "No s'ha especificau garra clau de deszifrau.
No se puede deszifrar.",
	'securepoll-jump' => 'Ir ta o servidor de votación',
	'securepoll-bad-ballot-submission' => 'O suyo voto yera invalido: $1',
	'securepoll-unanswered-questions' => 'Ha de responder todas as preguntas.',
	'securepoll-invalid-rank' => 'Rango invalido. Ha de clasificar a os candidatos con un rango entre 1 y 999.',
	'securepoll-unranked-options' => 'No ha clasificau qualques opcions.
Ha de clasificar a todas as opcions con un rango entre 1 y 999.',
	'securepoll-invalid-score' => "A puntuación ha d'estar una valura entre $1 y $2.",
	'securepoll-unanswered-options' => 'Ha de dar una respuesta ta cada pregunta.',
	'securepoll-remote-auth-error' => "S'ha produciu una error en obtener a suya información de cuenta d'o servidor.",
	'securepoll-remote-parse-error' => "S'ha produciu una error en interpretar a respuesta d'autorización d'o servidor.",
	'securepoll-api-invalid-params' => 'Parametros invalidos.',
	'securepoll-api-no-user' => "No s'ha trobau garra usuario con ixe ID.",
	'securepoll-api-token-mismatch' => 'No coincide a clau de seguranza, no se puede encetar a sesión.',
	'securepoll-not-logged-in' => "Ha d'encetar sesión ta votar en ista esleción",
	'securepoll-too-few-edits' => 'Perdón, no puet votar. Amenista haber feito a lo menos $1 {{PLURAL:$1|edición|edicions}} ta votar en ista eslección, ha feito $2.',
	'securepoll-too-new' => "Desincuse, pero no puede votar.  A suya cuenta ha d'estar rechistrada antes de $1 a las $3 ta poder votar en ista eslección, y vusté se rechistró o $2 a las $4.",
	'securepoll-blocked' => 'Perdón, no puet votar en ista eslección si yes actualment bloqueyau ta editar.',
	'securepoll-blocked-centrally' => 'Desincuse, pero no puede votar en ista eslección en estar bloqueyau en a lo menos $1 {{PLURAL:$1|wiki|wikis}}.',
	'securepoll-bot' => 'Lo sentimos, as cuentas con flag de bot no son autorizadas a votar en ista eslección.',
	'securepoll-not-in-group' => "Solament os miembros d'o grupo «$1» pueden votar en ista eslección.",
	'securepoll-not-in-list' => "Lo sentimos, no ye en a lista predeterminada d'usuarios autorizaus a votar en ista eslección.",
	'securepoll-list-title' => 'Lista de votos: $1',
	'securepoll-header-timestamp' => 'Tiempo',
	'securepoll-header-voter-name' => 'Nombre',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => "Achent d'usuario",
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Invalidar',
	'securepoll-header-details' => 'Detalles',
	'securepoll-strike-button' => 'Inalidar',
	'securepoll-unstrike-button' => 'Revalidar',
	'securepoll-strike-reason' => 'Razón:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-strike-error' => "S'ha produciu una error en invalidar/revalidar: $1",
	'securepoll-strike-token-mismatch' => "S'ha perdiu a información d'a sesión",
	'securepoll-details-link' => 'Detalles',
	'securepoll-details-title' => "Detalles d'o voto: #$1",
	'securepoll-invalid-vote' => '«$1» no ye un identificador de voto valido',
	'securepoll-header-voter-type' => 'Tipo de votant',
	'securepoll-voter-properties' => 'Propiedatz de votant',
	'securepoll-strike-log' => 'Rechistro de votos invalidaus',
	'securepoll-header-action' => 'Acción',
	'securepoll-header-reason' => 'Razón',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-cookie-dup-list' => 'Usuarios con cookies duplicadas',
	'securepoll-dump-title' => 'Vulcau: $1',
	'securepoll-dump-no-crypt' => "No se disposa d'un rechistro zifrau ta ista votación dau que ista votación no s'ha configurada ta fer servir zifrau.",
	'securepoll-dump-not-finished' => "Se disposa d'os rechistros zifraus d'a votación nomás dimpués d'a calendata de finalización en $1 de $2",
	'securepoll-dump-no-urandom' => "No se podió ubrir /dev/urandom.
Ta preservar a privacidat d'os votantes, nomás se publican os resultaus zifraus d'a eslección quan pueden estar mezclaus con un fluxo de numeros aleatorio.",
	'securepoll-urandom-not-supported' => "Iste servidor no poseye capacidat de cheneración criptografica de numeros aleatorios.
Ta preservar a privacidat d'os votantes, solament son publicaus os resultaus encriptados d'a eslección quan pueden estar mezclaus con un fluxo de numeros aleatorio.",
	'securepoll-translate-title' => 'Traducir: $1',
	'securepoll-invalid-language' => "Codigo d'idioma no valido «$1»",
	'securepoll-submit-translate' => 'Esviellar',
	'securepoll-language-label' => 'Trigar idioma:',
	'securepoll-submit-select-lang' => 'Traducir',
	'securepoll-entry-text' => "Contino ye a lista d'enqüestas.",
	'securepoll-header-title' => 'Nombre',
	'securepoll-header-start-date' => 'Calendata de prencipio',
	'securepoll-header-end-date' => 'Calendata de fin',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traducir',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Vulcar',
	'securepoll-subpage-tally' => 'Contador',
	'securepoll-tally-title' => 'Contador: $1',
	'securepoll-tally-not-finished' => "Lo sentimos, no puede actualizar os contadors d'a eslección dica que a votación no haiga finalizau.",
	'securepoll-can-decrypt' => "O rechistro d'eslección s'han zifrau pero la clave de desencriptación ye disponible.
Puede trigar entre escrutar os resultaus de la base de datos, u escrutar os resultaus zifraus dende un fichero cargau.",
	'securepoll-tally-no-key' => "No puede actualizar o contador d'a eslección, ya que os votos son zifraus y a clau de desenzifrau no ye disponible.",
	'securepoll-tally-local-legend' => 'Recuento de resultaus esviellau',
	'securepoll-tally-local-submit' => 'Creyar recuento',
	'securepoll-tally-upload-legend' => "Puyar vulcau d'o zifrau",
	'securepoll-tally-upload-submit' => 'Creyar recuento',
	'securepoll-tally-error' => "S'ha produciu una error interpretando o rechistro de votos, no se puede creyar un recuento.",
	'securepoll-no-upload' => "No s'ha puyau garra fichero, no se pueden recontar os resultaus.",
	'securepoll-dump-corrupt' => 'O fichero de vulcau ye danyau y no se puede procesar.',
	'securepoll-tally-upload-error' => 'Error en recontar o fichero de vulcau: $1',
	'securepoll-pairwise-victories' => "Resultaus d'as enqüestas en iste puesto",
	'securepoll-strength-matrix' => "Organizar por cantidat d'enqüestas",
	'securepoll-ranks' => 'Rango final',
	'securepoll-average-score' => 'Puntuación meya',
	'securepoll-round' => 'Tongada $1',
	'securepoll-spoilt' => '(Nulos)',
	'securepoll-exhausted' => '(Emplegau)',
);

/** Arabic (العربية)
 * @author Aiman titi
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
	'securepoll-submit' => 'أرسل صوتك',
	'securepoll-gpg-receipt' => 'شكرا لتصويتك

لو اردت، يمكنك الاحتفاظ بالايصال التالي كدليل على تصويتك:

<pre>$1</pre>',
	'securepoll-thanks' => 'شكرا لك، تم تسجيل تصويتك.',
	'securepoll-return' => 'ارجع إلى $1',
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
	'securepoll-too-new' => 'عذراً، لا يمكنك التصويت. يسمح فقط بالتصويت للحسابات المسجلة قبل $1 في $3 في هذه الانتخابات، أنت سجلت $2 في $4.',
	'securepoll-blocked' => 'عذرا، لا تستطيع التصويت في هذه الانتخابات إذا كنت ممنوعا حاليا من التعديل.',
	'securepoll-blocked-centrally' => 'عذراً، لا يمكنك التصويت في هذه الانتخابات بسبب منعك على الأقل في $1 {{PLURAL:$1|ويكي|ويكيات}}.',
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
	'securepoll-submit-translate' => 'حدّث',
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
	'securepoll-round' => 'الجولة $1',
	'securepoll-spoilt' => '(محيرة)',
	'securepoll-exhausted' => '(منهك)',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 * @author Michaelovic
 */
$messages['arc'] = array(
	'securepoll-submit' => 'ܫܕܪ ܩܠܐ',
	'securepoll-header-timestamp' => 'ܙܒܢܐ',
	'securepoll-header-voter-name' => 'ܫܡܐ',
	'securepoll-header-ua' => 'ܩܝܝܘܡܐ ܕܡܦܠܚܢܐ',
	'securepoll-header-details' => 'ܐܪ̈ܝܟܬܐ',
	'securepoll-strike-reason' => 'ܥܠܬܐ:',
	'securepoll-strike-cancel' => 'ܒܛܘܠ',
	'securepoll-details-link' => 'ܐܪ̈ܝܟܬܐ',
	'securepoll-header-action' => 'ܥܒܕܐ',
	'securepoll-header-reason' => 'ܥܠܬܐ',
	'securepoll-translate-title' => 'ܬܪܓܡ: $1',
	'securepoll-submit-translate' => 'ܚܘܕܬܐ',
	'securepoll-language-label' => 'ܓܒܝ ܠܫܢܐ:',
	'securepoll-submit-select-lang' => 'ܬܪܓܡ',
	'securepoll-header-title' => 'ܫܡܐ',
	'securepoll-subpage-vote' => 'ܝܗܒ ܩܠܐ',
	'securepoll-subpage-translate' => 'ܬܪܓܡ',
	'securepoll-subpage-list' => 'ܡܟܬܒܘܬܐ',
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

/** Assamese (অসমীয়া)
 * @author Chaipau
 * @author Gitartha.bordoloi
 */
$messages['as'] = array(
	'securepoll' => 'সুৰক্ষিত ভোটদান',
	'securepoll-desc' => 'নিৰ্বাচন আৰু জৰীপৰ বাবে প্ৰয়োজনীয় এক্সটেনচন',
	'securepoll-invalid-page' => 'অপ্ৰযোজ্য উপপৃষ্ঠা "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => "এই কামটো কৰিবলৈ আপুনি নিৰ্বাচন প্ৰশাসক হ'ব লাগিব ।",
	'securepoll-too-few-params' => 'যথেষ্ট পৰিমাণৰ উপপৃষ্ঠা পাৰামিটাৰ নাই (অপ্ৰযোজ্য সংযোগ)',
	'securepoll-welcome' => '<strong>স্বাগতম $1!</strong>',
	'securepoll-not-started' => "এই নিৰ্বাচন এতিয়াও আৰম্ভ হোৱা নাই ।
$2 তাৰিখে $3 টা বজাত আৰম্ভ হ'ব ।",
	'securepoll-finished' => 'এই নিৰ্বাচন সমাপ্ত হৈছে, আপুনি এতিয়া আৰু ভোট দিব নোৱাৰে ।',
	'securepoll-not-qualified' => 'আপুনি এই নিৰ্বাচনত ভোটদানৰ বাবে উপযুক্ত নহয়: $1',
	'securepoll-change-disallowed' => 'আপুনি পূৰ্বে এই নিৰ্বাচনত ভোটদান কৰিছে ।
দুঃখিত, আপুনি পুনৰ ভোট দিব নোৱাৰে ।',
	'securepoll-change-allowed' => "<strong>টোকা: আপুনি পূৰ্বে এই নিৰ্বাচনত ভোটদান কৰিছে ।</strong>
তলৰ প্ৰপত্ৰ জমা কৰি আপুনি আপোনাৰ ভোট সলাব পাৰে ।
মন কৰক যে, এনে কৰিলে আপোনাৰ মূল ভোটটো আঁতৰাই পেলোৱা হ'ব ।",
	'securepoll-submit' => 'ভোট প্ৰদান কৰক',
	'securepoll-gpg-receipt' => "ভোট দিয়াৰ বাবে ধন্যবাদ ।

আপুনি ইচ্ছা কৰিলে ভোটদানৰ প্ৰমাণ স্বৰূপে তলৰ ৰচিদখন সাঁচি থ'ব পাৰে ।

<pre>$1</pre>",
	'securepoll-thanks' => 'ধন্যবাদ, আপোনাৰ ভোট সংৰক্ষণ কৰা হৈছে ।',
	'securepoll-return' => '$1 লৈ ঘূৰি যাওক',
	'securepoll-encrypt-error' => 'আপোনাৰ ভোটৰ অভিলেখৰ এনক্ৰিপ্ট কৰা ব্যৰ্থ হৈছে ।
আপোনাৰ ভোট সংৰক্ষণ কৰা হোৱা নাই !

$1',
	'securepoll-no-gpg-home' => "জি.পি.জি. হ'ম ডিৰেক্টৰি সৃষ্টি কৰিব পৰা নগ'ল ।",
	'securepoll-secret-gpg-error' => 'জি.পি.জি সম্পন্ন কৰাত ত্ৰুটি দেখা দিছে ।
সবিশেষ জানিবলৈ আপোনাৰ LocalSettings.phpত $wgSecurePollShowErrorDetail=true; ব্যৱহাৰ কৰক ।',
	'securepoll-full-gpg-error' => 'জি.পি.জি. সম্পন্ন কৰাত ত্ৰুটি দেখা দিছে :

কমাণ্ড: $1

ত্ৰুটি:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'জি.পি.জি. কী-সমূহ ভুলকৈ কনফিগাৰ কৰা হৈছে ।',
	'securepoll-gpg-parse-error' => 'জিপিজি আউটপুট বিশ্লেষণ কৰোঁতে ত্ৰুটি পোৱা গৈছে ।',
	'securepoll-no-decryption-key' => 'কোনো ডিক্ৰিপছন কী কনফিগাৰ কৰা হোৱা নাই ।
ডিক্ৰিপ্ট কৰিব পৰা নাযাব ।',
	'securepoll-jump' => 'ভোটিং চাৰ্ভাৰলৈ যাওক',
	'securepoll-bad-ballot-submission' => 'আপোনাৰ ভোটটো অবৈধ: $1',
	'securepoll-unanswered-questions' => 'আপুনি সকলো প্ৰশ্নৰ উত্তৰ দিবই লাগিব ।',
	'securepoll-invalid-rank' => 'অপ্ৰযোজ্য স্থান । আপুনি প্ৰাৰ্থীক ১-ৰ পৰা ৯৯৯-ৰ ভিতৰত স্থান দিব লাগিব ।',
	'securepoll-api-invalid-params' => 'অপ্ৰযোজ্য পাৰামিটাৰ ।',
	'securepoll-header-timestamp' => 'সময়',
	'securepoll-header-voter-name' => 'নাম',
	'securepoll-strike-reason' => 'কাৰণ:',
	'securepoll-strike-cancel' => 'বাতিল কৰক',
	'securepoll-header-title' => 'নাম',
	'securepoll-subpage-translate' => 'ভাঙনি কৰক',
	'securepoll-subpage-list' => 'তালিকা',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Estensión pa eleiciones y encuestes',
	'securepoll-invalid-page' => 'Subpáxina non válida "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Has de ser un alministrador de la eleición pa facer esto.',
	'securepoll-too-few-params' => 'Nun hai parámetros de subpáxina bastantes (enllaz inválidu).',
	'securepoll-invalid-election' => '"$1" nun ye una ID d\'eleición válida.',
	'securepoll-welcome' => '<strong>¡Bienveníu $1!</strong>',
	'securepoll-not-started' => "Esta eleición entá nun principió.
Ta programada p'aniciase'l $2 a les $3.",
	'securepoll-finished' => 'Esta eleición finó, yá nun pues votar.',
	'securepoll-not-qualified' => 'Nun tas cualificáu pa votar nesta eleición: $1',
	'securepoll-change-disallowed' => 'Yá votasti antes nesta eleición.
Lo siento, nun pues volver a votar.',
	'securepoll-change-allowed' => "<strong>Nota: Yá votasti antes nesta eleición.</strong>
Pues camudar el to votu unviando'l formulariu d'abaxo.
Atalanta que si faes esto, se desaniciará'l to votu orixinal.",
	'securepoll-submit' => 'Unviar el votu',
	'securepoll-gpg-receipt' => 'Gracies por votar.

Si quies, pues quedate col recibu darréu como prueba del to votu:

<pre>$1</pre>',
	'securepoll-thanks' => 'Gracies, el to votu quedó rexistráu.',
	'securepoll-return' => 'Tornar a $1.',
	'securepoll-encrypt-error' => 'Falló cifrar el to rexistru de votu.
¡El to votu nun se rexistró!

$1',
	'securepoll-no-gpg-home' => 'Nun se pue crear el direutoriu pa GPG.',
	'securepoll-secret-gpg-error' => 'Fallu al executar GPG.
Usa $wgSecurePollShowErrorDetail=true; en LocalSettings.php pa una vista más detallada.',
	'securepoll-full-gpg-error' => 'Fallu al executar GPG:

Comandu: $1

Fallu:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Les claves GPG tan configuraes de mou incorreutu.',
	'securepoll-gpg-parse-error' => 'Fallu al interpretar la salida de GPG.',
	'securepoll-no-decryption-key' => 'Nun ta configurada denguna clave de descifráu.
Nun se pue descifrar.',
	'securepoll-jump' => 'Dir al sirvidor de votaciones',
	'securepoll-bad-ballot-submission' => 'El to votu foi inválidu: $1',
	'securepoll-unanswered-questions' => 'Has de responder toles entrugues.',
	'securepoll-invalid-rank' => 'Rangu inválidu. Has de dar a los candidatos un rangu ente 1 y 999.',
	'securepoll-unranked-options' => 'Delles opciones nun se puntuaron.
Has de dar a toles opciones un rangu ente 1 y 999.',
	'securepoll-invalid-score' => 'La puntuación tien de ser un númberu ente $1 y $2.',
	'securepoll-unanswered-options' => 'Tienes de dar una rempuesta a cada entruga.',
	'securepoll-remote-auth-error' => 'Fallu al traer del sirvidor la información de la to cuenta.',
	'securepoll-remote-parse-error' => "Fallu al interpretar la rempuesta d'autorización del sirvidor.",
	'securepoll-api-invalid-params' => 'Parámetros inválidos.',
	'securepoll-api-no-user' => "Nun s'alcontró un usuariu cola ID dada.",
	'securepoll-api-token-mismatch' => 'El token de seguridá nun concuaya, nun pues entrar.',
	'securepoll-not-logged-in' => "Tienes d'aniciar sesión pa votar nesta eleición",
	'securepoll-too-few-edits' => 'Perdona, pero nun pues votar. Necesites tener feches polo menos $1 {{PLURAL:$1|edición|ediciones}} pa votar nesta eleición, pero tienes feches $2.',
	'securepoll-too-new' => "Sentímoslo, pero nun pues votar. Hai que tener una cuenta rexistrada enantes del $1 a les $3 pa votar nestes eleiciones; la to data de rexistru ye'l $2 a les $4.",
	'securepoll-blocked' => 'Perdona, nun pues votar nesta eleición mientres tengas bloquiaes les ediciones.',
	'securepoll-blocked-centrally' => 'Sentímoslo, nun pues votar nestes eleiciones porque tas bloquiáu en polo menos $1 {{PLURAL:$1|wiki|wikis}}.',
	'securepoll-bot' => 'Perdona, les cuentes marcaes como de bot nun tienen permisu pa votar nesta eleición.',
	'securepoll-not-in-group' => 'Namái los miembros del grupu «$1» puen votar nesta eleición.',
	'securepoll-not-in-list' => "Perdona, nun tas na llista predeterminada d'usuarios con permisu pa votar nesta eleición.",
	'securepoll-list-title' => 'Llista de votos: $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominiu',
	'securepoll-header-ua' => "Axente d'usuariu",
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Tachar',
	'securepoll-header-details' => 'Detalles',
	'securepoll-strike-button' => 'Tachar',
	'securepoll-unstrike-button' => 'Destachar',
	'securepoll-strike-reason' => 'Motivu:',
	'securepoll-strike-cancel' => 'Encaboxar',
	'securepoll-strike-error' => 'Fallu al tachar/destachar: $1',
	'securepoll-strike-token-mismatch' => 'Perdiéronse los datos de sesión',
	'securepoll-details-link' => 'Detalles',
	'securepoll-details-title' => 'Detalles del votu: #$1',
	'securepoll-invalid-vote' => '"$1" nun ye una ID de votu válida.',
	'securepoll-header-voter-type' => 'Triba de votante',
	'securepoll-voter-properties' => 'Propiedaes del votante',
	'securepoll-strike-log' => 'Rexistru de tachaos',
	'securepoll-header-action' => 'Aición',
	'securepoll-header-reason' => 'Motivu',
	'securepoll-header-admin' => 'Almin',
	'securepoll-cookie-dup-list' => 'Usuarios con cookies duplicaes',
	'securepoll-dump-title' => 'Volcáu: $1',
	'securepoll-dump-no-crypt' => 'Nun ta disponible dengún rexistru cifráu pa esta eleición, porque la eleición nun ta configurada pa usar cifráu.',
	'securepoll-dump-not-finished' => 'Los rexistros cifraos de la eleición namái tan disponibles dempués de la data de finalización el $1 a les $2',
	'securepoll-dump-no-urandom' => "Nun se pudo abrir /dev/urandom.
Pa caltener la intimidá de los votantes, sólo s'asoleyen los resultaos cifraos de la eleición cuando se pueden amestar con un fluxu seguru de númberos al debalu.",
	'securepoll-urandom-not-supported' => "Esti sirvidor nun tien capacidá de xeneración criptográfica de númberos al debalu.
Para protexer la intimidá de los votantes, sólo s'asoleyen los resultaos cifraos de la eleición cuando se pueden amestar con un fluxu seguru de númberos al debalu.",
	'securepoll-translate-title' => 'Traducir: $1',
	'securepoll-invalid-language' => 'Códigu de llingua inválidu "$1"',
	'securepoll-submit-translate' => 'Anovar',
	'securepoll-language-label' => 'Escueyi llingua:',
	'securepoll-submit-select-lang' => 'Traducir',
	'securepoll-entry-text' => "Abaxo ta la llista d'encuestes.",
	'securepoll-header-title' => 'Nome',
	'securepoll-header-start-date' => "Data d'aniciu",
	'securepoll-header-end-date' => 'Data final',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traducir',
	'securepoll-subpage-list' => 'Llistar',
	'securepoll-subpage-dump' => 'Volcar',
	'securepoll-subpage-tally' => 'Recuentu',
	'securepoll-tally-title' => 'Recuentu: $1',
	'securepoll-tally-not-finished' => 'Perdona, nun pues facer un recuentu de la eleición fasta que termine la votación.',
	'securepoll-can-decrypt' => 'El rexistru de la eleición ta cifráu, pero ta disponible la clave de descifralu.
Puedes escoyer ente escrutar los resultaos de la base de datos, o escrutar los resultaos cifraos dende un ficheru xubíu.',
	'securepoll-tally-no-key' => 'Nun puedes escrutar esta eleición, porque los votos tan cifraos y la clave pa descifrar nun ta disponible.',
	'securepoll-tally-local-legend' => 'Facer recuentu de los resultaos guardaos',
	'securepoll-tally-local-submit' => 'Crear recuentu',
	'securepoll-tally-upload-legend' => 'Xubir volcáu cifráu',
	'securepoll-tally-upload-submit' => 'Crear recuentu',
	'securepoll-tally-error' => "Fallu d'interpretación del rexistru de votos, nun se pue producir un recuentu.",
	'securepoll-no-upload' => 'Nun se xubió dengún ficheru, nun se puen contar los resultaos.',
	'securepoll-dump-corrupt' => 'El ficheru de volcáu ta corrompíu y nun se pue procesar.',
	'securepoll-tally-upload-error' => 'Fallu al facer el recuentu del ficheru de volcáu: $1',
	'securepoll-pairwise-victories' => 'Cuadru de victories por pareyes',
	'securepoll-strength-matrix' => 'Cuadru de fuerza del camín',
	'securepoll-ranks' => 'Clasificación final',
	'securepoll-average-score' => 'Puntuación media',
	'securepoll-round' => 'Ronda $1',
	'securepoll-spoilt' => '(Nulos)',
	'securepoll-exhausted' => '(Agotaos)',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 * @author Vugar 1981
 */
$messages['az'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-welcome' => '<strong>Xoş gəlmisiniz $1!</strong>',
	'securepoll-change-disallowed' => 'Siz bu seçkidə artıq səs vermisiniz. 
Üzr istəyirik, yenidən səs verə bilməzsiniz.',
	'securepoll-submit' => 'Səs ver',
	'securepoll-return' => '$1 səhifəsinə qayıt.',
	'securepoll-bad-ballot-submission' => '$1: Səsiniz keçərsizdir',
	'securepoll-api-invalid-params' => 'Yanlış nizamlamalar.',
	'securepoll-list-title' => '$1: Səslərin siyahısı',
	'securepoll-header-timestamp' => 'Zaman',
	'securepoll-header-voter-name' => 'Ad',
	'securepoll-header-voter-domain' => 'Domen',
	'securepoll-header-ip' => 'IP',
	'securepoll-header-xff' => 'XFF',
	'securepoll-header-token-match' => 'CSRF',
	'securepoll-header-cookie-dup' => 'Surət',
	'securepoll-header-strike' => 'İşarələ',
	'securepoll-header-details' => 'Detallar',
	'securepoll-strike-button' => 'İşarələ',
	'securepoll-unstrike-button' => 'İşarələmə',
	'securepoll-strike-reason' => 'Səbəb:',
	'securepoll-strike-cancel' => 'Ləğv et',
	'securepoll-details-link' => 'Detallar',
	'securepoll-header-id' => 'ID',
	'securepoll-header-url' => 'URL',
	'securepoll-strike-log' => 'İşarələmə gündəliyi',
	'securepoll-header-action' => 'Fəaliyyət',
	'securepoll-header-reason' => 'Səbəb',
	'securepoll-header-admin' => 'İdarəçi',
	'securepoll-dump-title' => 'Tullantı: $1',
	'securepoll-translate-title' => 'Tərcümə et: $1',
	'securepoll-invalid-language' => '"$1" yanlış dil kodu',
	'securepoll-header-trans-id' => 'ID',
	'securepoll-submit-translate' => 'Yenilə',
	'securepoll-language-label' => 'Dili seçin:',
	'securepoll-submit-select-lang' => 'Tərcümə et',
	'securepoll-header-title' => 'Ad',
	'securepoll-header-start-date' => 'Başlanğıc tarixi',
	'securepoll-header-end-date' => 'Son tarix',
	'securepoll-subpage-vote' => 'Səs',
	'securepoll-subpage-translate' => 'Tərcümə et',
	'securepoll-subpage-list' => 'Siyahı',
	'securepoll-subpage-dump' => 'Xam',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'securepoll' => 'ХәүефһеҙТауышБиреү',
	'securepoll-desc' => 'Һайлауҙар үткәреү һәм һорауҙар алыу өсөн киңәйтеү',
	'securepoll-invalid-page' => '"<nowiki>$1</nowiki>" эске бите дөрөҫ түгел',
	'securepoll-need-admin' => 'Был ғәмәлде башҡарыу өсөн, һеҙ һайлауҙың етәксеһе булырға тейешһегеҙ.',
	'securepoll-too-few-params' => 'Эксе бит параметрҙары етмәй (һылтанма дөрөҫ түгел).',
	'securepoll-invalid-election' => '"$1" — дөрөҫ һайлау идентификаторы түгел.',
	'securepoll-welcome' => '<strong>Рәхим итегеҙ, $1!</strong>',
	'securepoll-not-started' => 'Был һайлауҙар башланманы әле.
Уның башланыу ваҡыты тип $2 $3 билдәләнгән.',
	'securepoll-finished' => 'Был һайлауҙар тамамланған, һеҙ тауыш бирә алмайһығыҙ инде.',
	'securepoll-not-qualified' => 'Һеҙҙең был һайлауҙарҙа тауыш биреү хоҡуғығыҙ юҡ: $1',
	'securepoll-change-disallowed' => 'Һеҙ был һайлауҙарҙа тауыш биргәнһегеҙ инде.
Ғәфү итегеҙ, һеҙ башҡа тауыш бирә алмайһығыҙ.',
	'securepoll-change-allowed' => '<strong>Иҫкәрмә: Һеҙ был һайлауҙарҙа тауыш биргәнһегеҙ инде.</strong>
Һеҙ, түбәндә килтерелгән форманы ебәреп, тауышығыҙҙы үҙгәртә алаһығыҙ.
Әгәр быны эшләһәгеҙ, бығаса биргән тауышығыҙ иҫәпкә алынмаясаҡ икәнен иғтибарға алығыҙ.',
	'securepoll-submit' => 'Тауышты ебәрергә',
	'securepoll-gpg-receipt' => 'Тауыш биреүегеҙ өсөн рәхмәт.

Әгәр теләһәгеҙ, тауышығыҙҙы раҫлау өсөн, түбәндәге юлдарҙы һаҡлай алаһығыҙ:

<pre>$1</pre>',
	'securepoll-thanks' => 'Рәхмәт, һеҙҙең тауышығыҙ яҙҙырып ҡуйылды.',
	'securepoll-return' => '$1 битенә ҡайтырға',
	'securepoll-encrypt-error' => 'Һеҙҙең тауышығыҙ тураһындағы яҙманы уҡыу мөмкин түгел.
Һеҙҙең тауышығыҙ яҙҙырылманы!

$1',
	'securepoll-no-gpg-home' => 'GPG баш директорияһын булдырыу мөмкин түгел.',
	'securepoll-secret-gpg-error' => 'GPG башҡарылыу хатаһы.
Тулыраҡ мәғлүмәт алыр өсөн, LocalSettings.php файлында $wgSecurePollShowErrorDetail=true; ҡулланығыҙ.',
	'securepoll-full-gpg-error' => 'GPG башҡарылыу хатаһы:

Фарман: $1

Хата:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG асҡыстары дөрөҫ көйләнмәгән.',
	'securepoll-gpg-parse-error' => 'GPG сығарған мәғлүмәтте уҡыу хатаһы.',
	'securepoll-no-decryption-key' => 'Шифрҙы уҡыу асҡысы көйләнмәгән.
Шифрҙы уҡыу мөмкин түгел.',
	'securepoll-jump' => 'Тауыш биреү серверына күсергә',
	'securepoll-bad-ballot-submission' => 'Һеҙҙең тауышығыҙ дөрөҫ түгел: $1',
	'securepoll-unanswered-questions' => 'Һеҙ бөтә һорауҙарға ла яуап бирергә тейешһегеҙ.',
	'securepoll-invalid-rank' => 'Тәртип һаны дөрөҫ түгел. Һеҙ кандидаттар өсөн 1 менән 999 араһындағы тәртип һанын бирергә тейешһегеҙ.',
	'securepoll-unranked-options' => 'Ҡайһы бер яҙмаларға тәртип һаны бирелмәгән. Һеҙ бөтә яҙмалар өсөн 1 менән 999 араһындағы тәртип һанын бирергә тейешһегеҙ.',
	'securepoll-invalid-score' => 'Баһа — $1 менән $2 араһындағы һан булырға тейеш.',
	'securepoll-unanswered-options' => 'Һеҙ һәр һорауға яуап бирергә тейешһегеҙ.',
	'securepoll-remote-auth-error' => 'Һеҙҙең иҫәп яҙмағыҙ тураһында серверҙан мәғлүмәт алыу хатаһы.',
	'securepoll-remote-parse-error' => 'Серверҙан алынған танылыу яуабын уҡыу хатаһы.',
	'securepoll-api-invalid-params' => 'Параметрҙар дөрөҫ түгел.',
	'securepoll-api-no-user' => 'Бирелгән идентификаторлы ҡатнашыусы табылманы.',
	'securepoll-api-token-mismatch' => 'Хәүефһеҙлек токены тап килмәй, танылыу мөмкин түгел.',
	'securepoll-not-logged-in' => 'Был һайлауҙарҙа тауыш биреү өсөн, һеҙ танылырға тейешһегеҙ.',
	'securepoll-too-few-edits' => 'Ғәфү итегеҙ, һеҙ тауыш бирә алмайһығыҙ. Һеҙгә был һайлауҙарҙа ҡатнашыу өсөн, кәмендә $1 {{PLURAL:$1|үҙгәртеү}} яһарға кәрәк, һеҙ $2 үҙгәртеү эшләгәнһегеҙ.',
	'securepoll-blocked' => 'Ғәфү итегеҙ, һеҙ бикле булған ваҡытта был һайлауҙарҙа тауыш бирә алмайһығыҙ.',
	'securepoll-bot' => 'Ғәфү итегеҙ, бот флагы булған иҫәп яҙмалары был һайлауҙарҙа тауыш бирә алмай.',
	'securepoll-not-in-group' => '"$1" төркөмө ағзалары ғына был һайлауҙарҙа тауыш бирә ала.',
	'securepoll-not-in-list' => 'Ғәфү итегеҙ, һеҙ был һайлауҙарҙа тауыш бирә алған ҡатнашыусылар исемлегенә кермәйһегеҙ.',
	'securepoll-list-title' => 'Тауыштар исемлеге: $1',
	'securepoll-header-timestamp' => 'Ваҡыт',
	'securepoll-header-voter-name' => 'Исем',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Ҡулланыусы агенты',
	'securepoll-header-cookie-dup' => 'Ҡабатлау',
	'securepoll-header-strike' => 'Һыҙыу',
	'securepoll-header-details' => 'Ентеклерәк',
	'securepoll-strike-button' => 'Һыҙырға',
	'securepoll-unstrike-button' => 'Һыҙмаҫҡа',
	'securepoll-strike-reason' => 'Сәбәп:',
	'securepoll-strike-cancel' => 'Кире алырға',
	'securepoll-strike-error' => 'Һыҙыу/Һыҙмау ғәмәлен башҡарғанда хата: $1',
	'securepoll-strike-token-mismatch' => 'Ултырыш мәғлүмәттәре юғалған',
	'securepoll-details-link' => 'Ентеклерәк',
	'securepoll-details-title' => 'Тауыш биреү мәғлүмәттәре: $1',
	'securepoll-invalid-vote' => '"$1" — дөрөҫ тауыш биреү идентификаторы түгел',
	'securepoll-header-voter-type' => 'Тауыш биреүсе төрө',
	'securepoll-voter-properties' => 'Тауыш биреүсе үҙенсәлектәре',
	'securepoll-strike-log' => 'Һыҙыу яҙмалары журналы',
	'securepoll-header-action' => 'Ғәмәл',
	'securepoll-header-reason' => 'Сәбәп',
	'securepoll-header-admin' => 'Хәким',
	'securepoll-cookie-dup-list' => 'Ҡатнашыусыларҙың ҡабатланыуы Cookie буйынса',
	'securepoll-dump-title' => 'Дамп: $1',
	'securepoll-dump-no-crypt' => 'Шифрланмаған тауыш биреү яҙмаһы был һайлауҙарҙа ғәмәлгә эйә, сөнки һайлауҙар шифр ҡулланыуға көйләнмәгән.',
	'securepoll-dump-not-finished' => 'Шифрланған тауыш биреү яҙмалары $1 $2 тауыш биреү тамамланғандандан һуң ғына ғәмәлгә эйә',
	'securepoll-dump-no-urandom' => '/dev/urandom асылмай.
Тауыш биреүселәрҙең йәшеренлеген тәьмин итеү өсөн, шифрланған тауыш биреү яҙмалары тик уларҙың тәртибе хәүефһеҙ осраҡлы һандар теҙмәһе ярҙамында үҙгәртелгәндә генә дөйөм күренә.',
	'securepoll-urandom-not-supported' => 'Серверҙа криптографик осраҡлы һандар булдырыу мөмкин түгел.
Тауыш биреүселәрҙең йәшеренлеген тәьмин итеү өсөн, шифрланған тауыш биреү яҙмалары тик уларҙың тәртибе хәүефһеҙ осраҡлы һандар теҙмәһе ярҙамында үҙгәртелгәндә генә дөйөм күренә.',
	'securepoll-translate-title' => 'Тәржемә: $1',
	'securepoll-invalid-language' => 'Хаталы тел коды "$1"',
	'securepoll-submit-translate' => 'Яңыртырға',
	'securepoll-language-label' => 'Тел һайлау:',
	'securepoll-submit-select-lang' => 'Тәржемә итергә:',
	'securepoll-entry-text' => 'Түбәндә һайлауҙар исемлеге килтерелгән.',
	'securepoll-header-title' => 'Исем',
	'securepoll-header-start-date' => 'Башланыу ваҡыты',
	'securepoll-header-end-date' => 'Тамамланыу ваҡыты',
	'securepoll-subpage-vote' => 'Тауыш биреү',
	'securepoll-subpage-translate' => 'Тәржемә итергә',
	'securepoll-subpage-list' => 'Исемлек',
	'securepoll-subpage-dump' => 'Ҡабатлау',
	'securepoll-subpage-tally' => 'Иҫәпләү',
	'securepoll-tally-title' => 'Иҫәпләү: $1',
	'securepoll-tally-not-finished' => 'Ғәфү итегеҙ, һеҙ тауыш биреү тамамланмайынса һөҙөмтәне иҫәпләй алмайһығыҙ.',
	'securepoll-can-decrypt' => 'Тауыш биреү яҙмаһы шифрланған, әммә шифрҙы асҡысы бар.
Һеҙ йә мәғлүмәттәр базаһындағы хәҙерге һөҙөмтәләрҙе иҫәпләүҙе, йә тейәлгән файлдан шифрланған һөҙөмтәләрҙе иҫәпләүҙе һайлай алаһығыҙ.',
	'securepoll-tally-no-key' => 'Һеҙ был һайлауҙарҙың һөҙөмтәләрен иҫәпләй алмайһығыҙ, сөнки тауыштар шифрланған, һәм шифр асҡысы юҡ.',
	'securepoll-tally-local-legend' => 'Һаҡланған һөҙөмтәләрҙе иҫәпләү',
	'securepoll-tally-local-submit' => 'Иҫәпләү булдырырға',
	'securepoll-tally-upload-legend' => 'Шифрланған дампты тейәү',
	'securepoll-tally-upload-submit' => 'Иҫәпләү булдырырға',
	'securepoll-tally-error' => 'Тауыш яҙмаһын уҡыу хатаһы, иҫәпләү булдырыу мөмкин түгел.',
	'securepoll-no-upload' => 'Бер файл да тейәлмәгән, һөҙөмтәләрҙе иҫәпләү мөмкин түгел.',
	'securepoll-dump-corrupt' => 'Дамп файлы боҙолған һәм эшкәртелә алмай.',
	'securepoll-tally-upload-error' => 'Дамп файлын иҫәпләү хатаһы: $1',
	'securepoll-pairwise-victories' => 'Парлы еңеүҙәр матрицаһы',
	'securepoll-strength-matrix' => 'Юл көсө матрицаһы',
	'securepoll-ranks' => 'Һуңғы тәртип',
	'securepoll-average-score' => 'Уртаса баһа',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'securepoll-strike-reason' => 'Прычына:',
	'securepoll-header-reason' => 'Прычына',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Renessaince
 * @author Wizardist
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
	'securepoll-too-new' => 'На жаль, Вы ня можаце галасаваць. Ваш рахунак мусіў быць створаны да $1 $3, а Вы стварылі рахунак $2 $4.',
	'securepoll-blocked' => 'Прабачце, Вы ня можаце галасаваць на гэтых выбарах, калі Вы заблякаваны.',
	'securepoll-blocked-centrally' => 'На жаль, Вы ня можаце галасаваць у гэтых выбарах, бо заблякаваныя прынамсі ў $1 {{PLURAL:$1|вікі|вікі|вікі}}.',
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
	'securepoll-strike-cancel' => 'Скасаваць',
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
	'securepoll-round' => '$1 тур',
	'securepoll-spoilt' => '(забракаваныя)',
	'securepoll-exhausted' => '(вычарпаныя)',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'securepoll' => 'Защитено гласуване',
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
	'securepoll-too-new' => 'За съжаление, не можете да гласувате.  Вашата потребителска сметка е регистрирана на $2, а е трябвало да бъде регистрирана преди $1, за да имате право на глас.',
	'securepoll-blocked' => 'За съжаление, не можете да участвате в това гласуване, защото в момента сте блокирани.',
	'securepoll-blocked-centrally' => 'За съжаление, не можe да гласувате в тези избори, тъй като сте блокирани в поне $1 {{PLURAL:$1|уики|уикита}}.',
	'securepoll-bot' => 'За съжаление, потребителски сметки, отбелязани като ботове, не могат да вземат участие в това гласуване.',
	'securepoll-not-in-group' => 'Само членове на потребителска група "$1" могат да вземат участие в това гласуване.',
	'securepoll-not-in-list' => 'За съжаление, вашето потребителско име не фигурира в предварително определения списък на потребителите с право на участие в това гласуване.',
	'securepoll-list-title' => 'Списък на гласуванията: $1',
	'securepoll-header-timestamp' => 'Време',
	'securepoll-header-voter-name' => 'Име',
	'securepoll-header-voter-domain' => 'Домейн',
	'securepoll-header-ua' => 'Браузър',
	'securepoll-header-strike' => 'Анулиране на глас',
	'securepoll-header-details' => 'Подробности',
	'securepoll-strike-button' => 'Анулиране на глас',
	'securepoll-unstrike-button' => 'Възстановяване на анулиран глас',
	'securepoll-strike-reason' => 'Причина:',
	'securepoll-strike-cancel' => 'Отмяна',
	'securepoll-strike-error' => 'Грешка при анулиране на глас или възстановяване на анулиран глас: $1',
	'securepoll-strike-token-mismatch' => 'Данните от сесията са изгубени',
	'securepoll-details-link' => 'Подробности',
	'securepoll-details-title' => 'Подробности за гласуването: #$1',
	'securepoll-invalid-vote' => '"$1" не е допустим идентификатор на гласуване',
	'securepoll-header-voter-type' => 'Тип гласоподатели',
	'securepoll-voter-properties' => 'Характеристики на гласоподавателите',
	'securepoll-strike-log' => 'Дневник на анулираните гласове',
	'securepoll-header-action' => 'Действие',
	'securepoll-header-reason' => 'Причина',
	'securepoll-header-admin' => 'Админ',
	'securepoll-cookie-dup-list' => 'Засечени дублирани гласове',
	'securepoll-dump-title' => 'Дъмп: $1',
	'securepoll-dump-no-crypt' => 'За тези избори не са достъпни криптирани записи от гласуването, тъй като изборната процедура не е била конфигурирана да използва криптиране.',
	'securepoll-dump-not-finished' => 'Криптираните записи от изборите ще бъдат достъпни едва след края на гласуването на $1 в $2',
	'securepoll-dump-no-urandom' => 'Грешка при отварянето на /dev/urandom. 
За да се осигури тайната на вота, криптираните записи от гласуването могат да станат публично достъпни само ако бъдат разбъркани с поток от случайни данни.',
	'securepoll-urandom-not-supported' => 'Този сървър не поддържа генерирането на криптографски случайни числа.
За да се осигури тайната на вота, криптираните записи от гласуването могат да станат публично достъпни само ако бъдат разбъркани с поток от случайни данни.',
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
	'securepoll-subpage-dump' => 'Дъмп',
	'securepoll-subpage-tally' => 'Преброяване',
	'securepoll-tally-title' => 'Преброяване: $1',
	'securepoll-tally-not-finished' => 'Не можете да се извърши преброяване на изборите преди да е приключило гласуването.',
	'securepoll-can-decrypt' => 'Записът от гласуването е бил криптиран, но е налице дешифриращ ключ. 
	Имате избор дали да преброите резултатите, налични в базата данни, или да преброите криптираните резултати от качения файл.',
	'securepoll-tally-no-key' => 'Не можете да извършите преброяване на това гласуване, защото гласовете са криптирани и не е наличен дешифриращ ключ.',
	'securepoll-tally-local-legend' => 'Преброяване на съхранените резултати',
	'securepoll-tally-local-submit' => 'Извършване на преброяването',
	'securepoll-tally-upload-legend' => 'Качване на криптиран дъмп',
	'securepoll-tally-upload-submit' => 'Извършване на преброяването',
	'securepoll-tally-error' => 'Грешка при интерпретирането на записа с гласовете. Не може да се извърши преброяване.',
	'securepoll-no-upload' => 'Няма качен файл, не може да се пристъпи към преброяване на гласовете.',
	'securepoll-dump-corrupt' => 'Дъмп файлът е повреден и не може да бъде обработен.',
	'securepoll-tally-upload-error' => 'Грешка при преброяването на дъмп файла: $1',
	'securepoll-ranks' => 'Крайно класиране',
	'securepoll-average-score' => 'Средна оценка',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'securepoll' => 'সিকিউরপোল',
	'securepoll-desc' => 'নির্বাচন ও জরিপের জন্য প্রয়োজনীয় এক্সটেনশন',
	'securepoll-invalid-page' => 'অপ্রযোজ্য উপপাতা "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'এই অ্যাকশনটি গ্রহণ করার জন্য আপনার নির্বাচন প্রশাসক হওয়া প্রয়োজন',
	'securepoll-too-few-params' => 'যথেষ্ট পরিমাণ উপপাতা প্যারামিটার নেই (অপ্রযোজ্য সংযোগ)',
	'securepoll-invalid-election' => '"$1" সঠিক ভোট আইডি নয়।',
	'securepoll-welcome' => '<strong>স্বাগতম $1!</strong>',
	'securepoll-not-started' => 'এই নির্বাচন এখনও শুরু হয়নি।
$2 তারিখ $3টার সময় এটি শুরু হবে।',
	'securepoll-finished' => 'এই নির্বাচন কার্যক্রম সমাপ্ত হয়েছে, আপনি আর ভোট প্রদান করতে পারবেন না।',
	'securepoll-not-qualified' => 'আপনি এই নির্বাচনে ভোট প্রদানের জন্য উপযুক্ত নন: $1',
	'securepoll-change-disallowed' => 'আপনি পূর্বেই এই নির্বাচনে ভোট প্রদান করেছেন।
দুঃখিত, আপনি পুনরায় ভোট প্রদান করতে পারবেন না।',
	'securepoll-change-allowed' => '<strong>পুনশ্চ: আপনি এই নির্বাচনে আগেও ভোট প্রদান করেছেন।</strong>
আপনি নিচের ফর্মটি পূরণ করে জমা দেওয়ার মাধ্যমে আপনার পরিবর্তন করতে পারেন।
খেয়াল করুন যে, এটা করলে আপনার মূল ভোটটি পরিবর্তিত হয়ে যাবে।',
	'securepoll-submit' => 'ভোট প্রদান করুন',
	'securepoll-gpg-receipt' => 'ভোট দেওয়ার জন্য ধন্যবাদ।

আপনি চাইলে, ভোটের প্রমাণ সরূপ এই রিসিপ্টটি সংরক্ষণ করতে পারেন:

<pre>$1</pre>',
	'securepoll-thanks' => 'ধন্যবাদ, আপনার ভোট সংরক্ষণ করা হয়েছে।',
	'securepoll-return' => '$1 এ ফিরে যাও।',
	'securepoll-encrypt-error' => 'আপনার ভোটের রেকর্ড এনক্রিপ্ট করে ব্যর্থ হয়েছে।
আপনার ভোট সংরক্ষণ করা হয়নি!

$1',
	'securepoll-no-gpg-home' => 'জিপিজ হোম ডিরেক্টরি তৈরি করতে ব্যর্থ হয়েছে।',
	'securepoll-secret-gpg-error' => 'জিপিজি এক্সিকিউটের সময় ত্রুটি দেখা দিয়েছে।
বিস্তারিত জানতে আপনার LocalSettings.php-তে $wgSecurePollShowErrorDetail=true; ব্যবহার করুন।',
	'securepoll-full-gpg-error' => 'জিপিজি এক্সিকিউটের সময় ত্রুটি দেখা দিয়েছে:

কমান্ড: $1

ত্রুটি:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'জিপিজি কিগুলো ভুলভাবে কনফিগার করা হয়েছে।',
	'securepoll-gpg-parse-error' => 'জিপিজি আউটপুট বিশ্লেষণ করার সময় ত্রুটি দেখা দিয়েছে।',
	'securepoll-no-decryption-key' => 'কোনো ডিক্রিপশন কি ঠিক করা হয়নি।
ডিক্রিপ্ট করা সম্ভব নয়।',
	'securepoll-jump' => 'ভোটিং সার্ভারে যাও',
	'securepoll-bad-ballot-submission' => 'আপনার ভোট ঠিক নয়: $1',
	'securepoll-unanswered-questions' => 'আপনাকে অবশ্যই সব প্রশ্নের উত্তর দিতে হবে।',
	'securepoll-invalid-rank' => 'অপ্রযোজ্য র্যাং। আপনাকে অবশ্যই প্রার্থীদেরকে ১ থেকে ৯৯৯-এর মধ্যে র্যাংকিং করতে হবে।',
	'securepoll-unranked-options' => 'কিছু অপশন র্যাংকিং করা হয়নি।
আপনাকে অবশ্যই সকল অপশন ১ থেকে ৯৯৯-এর মধ্যে র্যাংকিং করতে হবে।',
	'securepoll-invalid-score' => 'স্কোর অবশ্যই $1 এবং $2 মধ্যে একটি সংখ্যা হবে।',
	'securepoll-unanswered-options' => 'আপনাকে প্রতিটি প্রশ্নের জন্যই একটি করে উত্তর প্রদান করতে হবে।',
	'securepoll-remote-auth-error' => 'সার্ভার থেকে আপনার অ্যাকাউন্টের তথ্যাদি গ্রহণ করার সময় ত্রুটি দেখা দিয়েছে।',
	'securepoll-remote-parse-error' => 'সার্ভারের কাছ থেকে নিশ্চিতকরণ বার্তা পাবার সময় ত্রুটি দেখা দিয়েছে।',
	'securepoll-api-invalid-params' => 'অপ্রযোজ্য প্যারামিটার',
	'securepoll-api-no-user' => 'প্রদানকৃত আইডি সাথে সংশ্লিষ্ট কোনো ব্যবহারকারী খুঁজে পাওয়া যায়নি।',
	'securepoll-api-token-mismatch' => 'নিরাপত্তা টোকেন ঠিকভাবে মেলেনি। লগ-ইন করা সম্ভব নয়।',
	'securepoll-not-logged-in' => 'এই নির্বাচনে ভোট প্রদান করতে আপনাকে অবশ্যই লগইন করতে হবে',
	'securepoll-too-few-edits' => 'দুঃখিত, আপনি ভোট দিতে পারবেন না। ভোট প্রদানের জন্য আপনার অবশ্যই $1টি {{PLURAL:$1|সম্পাদনা|সম্পাদনা}} থাকা প্রয়োজন, আপনার রয়েছে $2টি।',
	'securepoll-blocked' => 'দুঃখিত, আপনি যদি বর্তমানে সম্পাদনা থেকে বাধাদানকৃত অবস্থায় থাকেন, তবে আপনি এই নির্বাচনে ভোট প্রদান করতে পারবেন না।',
	'securepoll-bot' => 'দুঃখিত, বট ফ্ল্যাগযুক্ত অ্যাকাউন্ট এই নির্বাচনে ভোট প্রদানের জন্য উপযুক্ত নয়।',
	'securepoll-not-in-group' => 'শুধুমাত্র "$1" অধিকারপ্রাপ্ত ব্যবহারকারীরাই এই নির্বাচনে ভোট প্রদান করতে পারবেন।',
	'securepoll-not-in-list' => 'দুঃখিত, এই নির্বাচনে ভোট দিতে সক্ষম এমন ব্যবহারকারীদের পূর্ব গঠিত তালিকায় আপনার নাম নেই।',
	'securepoll-list-title' => 'ভোটের তালিকা: $1',
	'securepoll-header-timestamp' => 'সময়',
	'securepoll-header-voter-name' => 'নাম',
	'securepoll-header-voter-domain' => 'ডোমেইন',
	'securepoll-header-ua' => 'ব্যবহারকারী এজেন্ট',
	'securepoll-header-cookie-dup' => 'ডাপ',
	'securepoll-header-strike' => 'স্ট্রাইক',
	'securepoll-header-details' => 'বিস্তারিত',
	'securepoll-strike-button' => 'স্ট্রাইক',
	'securepoll-unstrike-button' => 'আনস্ট্রাইক',
	'securepoll-strike-reason' => 'কারণ:',
	'securepoll-strike-cancel' => 'বাতিল',
	'securepoll-strike-error' => 'স্ট্রাইক/আনস্ট্রাইক করার সময় ত্রুটি দেখা দিয়েছে: $1',
	'securepoll-strike-token-mismatch' => 'সেশনের ডেটা হারিয়ে গেছে',
	'securepoll-details-link' => 'বিস্তারিত',
	'securepoll-details-title' => 'ভোট বিস্তারিত: #$1',
	'securepoll-invalid-vote' => '"$1" সঠিক ভোট আইডি নয়',
	'securepoll-header-voter-type' => 'ভোটারের ধরন',
	'securepoll-voter-properties' => 'ভোটারের তথ্যাদি',
	'securepoll-strike-log' => 'স্ট্রাইক লগ',
	'securepoll-header-action' => 'অ্যাকশন',
	'securepoll-header-reason' => 'কারণ',
	'securepoll-header-admin' => 'প্রশাসক',
	'securepoll-cookie-dup-list' => 'প্রতিলিপি ব্যবহারকারীর কুকি',
	'securepoll-dump-title' => 'ডাম্প: $1',
	'securepoll-translate-title' => 'অনুবাদ: $1',
	'securepoll-invalid-language' => 'অপ্রযোজ্য ভাষা কোড "$1"',
	'securepoll-submit-translate' => 'হালনাগাদ',
	'securepoll-language-label' => 'ভাষা নির্বাচন:',
	'securepoll-submit-select-lang' => 'অনুবাদ',
	'securepoll-entry-text' => 'নিচে ভোটের তালিকা প্রদান করা হলো।',
	'securepoll-header-title' => 'নাম',
	'securepoll-header-start-date' => 'শুরুর তারিখ',
	'securepoll-header-end-date' => 'শেষের তারিখ',
	'securepoll-subpage-vote' => 'ভোট',
	'securepoll-subpage-translate' => 'অনুবাদ করুন',
	'securepoll-subpage-list' => 'তালিকা',
	'securepoll-subpage-dump' => 'ডাম্প',
	'securepoll-subpage-tally' => 'টালি',
	'securepoll-tally-title' => 'টালি: $1',
	'securepoll-tally-not-finished' => 'দুঃখতি, ভোট গ্রহণ শেষ না হওয়ার পূর্ব পর্যন্ত আপনি এই নির্বাচনের ভোট গণনা করতে পারবেন না।',
	'securepoll-tally-no-key' => 'আপনি এই নির্বাচন হিসাব করতে পারবেন না, কারণ ভোটগুলো এনক্রিপ্ট করা, এবং ডিক্রিপশন কি লভ্য নয়।',
	'securepoll-tally-local-legend' => 'সংরক্ষণকৃত ফলাফল হিসাব করো',
	'securepoll-tally-local-submit' => 'টালি তৈরি',
	'securepoll-tally-upload-legend' => 'এনক্রিপ্ট ডাম্প আপলোড',
	'securepoll-tally-upload-submit' => 'টালি তৈরি',
	'securepoll-tally-error' => 'ভোট রেকর্ড বিশ্লেষণের সময় ত্রুটি দেখা দিয়েছে, হিসাব তৈরি করা সম্ভব নয়।',
	'securepoll-no-upload' => 'কোনো ফাইল আপলোড করা হয়নি, ফলাফল গণনা করা সম্ভব নয়।',
	'securepoll-dump-corrupt' => 'ডাম্প ফাইলে ত্রুটি দেখা দিয়েছে এবং আর প্রক্রিয়াকরণ চালিয়ে যাওয়া সম্ভব নয়।',
	'securepoll-tally-upload-error' => 'ডাম্প ফাইল গণনার সময় ত্রুটি দেখা দিয়েছে: $1',
	'securepoll-ranks' => 'চূড়ান্ত র‌্যাঙ্কিং',
	'securepoll-average-score' => 'গড় স্কোর',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
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
	'securepoll-not-logged-in' => 'Rankout a rit kevreañ a-benn votiñ en dilennadeg-mañ.',
	'securepoll-too-few-edits' => "Ho tigarez, n'hallit ket votiñ. Ret eo bezañ graet da nebeutañ $1 {{PLURAL:$1|degasadenn|degasadenn}} a-benn gallout mouezhiañ en dilennadeg-mañ, ha graet hoc'h eus $2.",
	'securepoll-too-new' => "Ho tigarez, votiñ, n'hallit ket. Ret eo d'ho kont bezañ bet enrollet kent an $1 da $3 da c'hallout votiñ en dilennadeg-mañ. Enrollet oc'h bet d'an $2 da $4.",
	'securepoll-blocked' => "Ho tigarez, n'oc'h ket evit votiñ en dilennadeg-mañ pa'z eo stanket ho tegasadennoù evit ar mare.",
	'securepoll-blocked-centrally' => "Ho tigarez, n'hallit ket votiñ en dilennadeg-mañ rak stanket oc'h war $1 da nebeutañ pe war {{PLURAL:$1|ur wiki|wikioù}} all.",
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
	'securepoll-header-end-date' => 'Deiziad echuiñ',
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
	'securepoll-round' => 'Tro $1',
	'securepoll-spoilt' => '(Gwenn pe null)',
	'securepoll-exhausted' => '(Diviet)',
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
	'securepoll-too-new' => 'Žao nam je, ne možete glasati.  Vaš račun treba biti registrovan prije $1 da biste glasali na ovim izborima, vi ste registrovani dana $2.',
	'securepoll-blocked' => 'Žao nam je, ne možete trenutno glasati na ovim izborima ako ste trenutno blokirani za uređivanje.',
	'securepoll-blocked-centrally' => 'Žao nam je, vi ne možete glasati na ovim izborima ako ste blokirani na $1 ili više {{PLURAL:$1|wikija|wikija}}.',
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
	'securepoll-round' => 'Runda $1',
	'securepoll-spoilt' => '(Nevaljano)',
	'securepoll-exhausted' => '(Iskorišteno)',
);

/** Catalan (Català)
 * @author Aleator
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
	'securepoll-jump' => 'Anau al servidor de votació',
	'securepoll-bad-ballot-submission' => 'El vostre vot no és vàlid: $1',
	'securepoll-unanswered-questions' => 'Heu de respondre totes les qüestions.',
	'securepoll-invalid-rank' => "Rang no vàlid.
Heu d'introduir a cada candidat un valor entre 1 i 999.",
	'securepoll-unranked-options' => 'Algunes opcions no han estat qualificades.
Heu de donar a totes les opcions, un rang entre 1 i 999.',
	'securepoll-invalid-score' => 'La valoració ha de ser un nombre entre $1 i $2.',
	'securepoll-unanswered-options' => 'Heu de donar una resposta per cada qüestió.',
	'securepoll-remote-auth-error' => "S'ha produit un eror en recuperar del servidor la informació del vostre compte .",
	'securepoll-remote-parse-error' => "S'ha produit un error en la recepció de la resposta d'autorització des del servidor.",
	'securepoll-api-invalid-params' => 'Paràmetres invàlids.',
	'securepoll-api-no-user' => "No s'ha trobat cap usuari amb aquesta identificació.",
	'securepoll-api-token-mismatch' => "El token de seguretat no coincideix. No s'ha pogut accedir.",
	'securepoll-not-logged-in' => "Heu d'estar connectats en un compte per a votar en aquesta elecció",
	'securepoll-too-few-edits' => "Ho sentim, però no podeu votar.
Per a votar en aquesta elecció cal haver fet un mínim {{PLURAL:$1|d'una modificació|de $1 modificacions}}, i n'heu fet $2.",
	'securepoll-too-new' => "Sentint-ho molt no podeu votar. Per a poder participar en aquesta votació cal que el vostre compte s'hagi registrat abans del $1 a les $3. La vostra data de registre és $2 a les $4.",
	'securepoll-blocked' => "Ho sentim però no podeu votar en aquesta elecció perquè el vostre compte està blocat a l'edició.",
	'securepoll-blocked-centrally' => 'Ho sentim, però no podeu votar en aquestes eleccions perquè esteu blocats com a mínim en $1 {{PLURAL:$1|wikis|wikis}}.',
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
Per mantenir la privadesa dels votants, els registres encriptats de l'elecció es fan públics només quan poden ser barrejats amb un generador segur de nombres aleatoris.",
	'securepoll-urandom-not-supported' => "Aquest servidor no suporta la generació criptogràfica de nombres aleatoris.
Per mantenir la privadesa del votant, els registres d'elecció encriptats només són públicament disponibles quan es poden emetre amb un flux segur de nombres aleatoris.",
	'securepoll-translate-title' => 'Traducció: $1',
	'securepoll-invalid-language' => "Codi d'idioma «$1» no vàlid",
	'securepoll-submit-translate' => 'Actualitza',
	'securepoll-language-label' => 'Escolliu idioma:',
	'securepoll-submit-select-lang' => 'Tradueix',
	'securepoll-entry-text' => 'A sota hi ha la llista de votacions.',
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
	'securepoll-pairwise-victories' => 'Matriu de victòries parell a parell',
	'securepoll-strength-matrix' => 'Matriu de força del camí',
	'securepoll-ranks' => 'Classificació final',
	'securepoll-average-score' => 'Puntuació mitjana',
	'securepoll-round' => 'Ronda $1',
	'securepoll-spoilt' => '(Nul)',
	'securepoll-exhausted' => '(Esgotat)',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'securepoll-strike-reason' => 'Бахьан:',
	'securepoll-header-reason' => 'Бахьан',
	'securepoll-header-admin' => 'Адманкуьйгалхо',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'securepoll-strike-reason' => 'هۆکار:',
	'securepoll-header-reason' => 'هۆکار',
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
	'securepoll-too-new' => 'Je nám líto, ale nemůžete hlasovat. Pro účast v tomto hlasování by váš účet musel být založen před $3, $1, {{gender:|zaregistroval|zaregistrovala|zaregistrovali}} jste se však v $4, $2.',
	'securepoll-blocked' => 'Promiňte, ale nemůžete se zúčastnit tohoto hlasování, pokud je vám momentálně zablokována editace.',
	'securepoll-blocked-centrally' => 'Je nám líto, ale tohoto hlasování se nemůžete zúčastnit, neboť jste {{gender:|blokován|blokována|blokováni}} na nejméně $1 wiki.',
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
	'securepoll-round' => '$1. kolo',
	'securepoll-spoilt' => '(neplatné)',
	'securepoll-exhausted' => '(vyčerpané)',
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
	'securepoll-too-new' => "Mae'n ddrwg gennym, ni allwch bleidleisio. Roedd angen i chi gofrestri cyn $3 ar $1 i bleidleisio yn yr etholiad hwn; cafodd eich cyfrif ei gofrestri am $4 ar $2.",
	'securepoll-blocked' => 'Ni allwch bleidleisio yn yr etholiad hwn, ysywaeth, gan eich wedi eich atal rhag golygu ar hyn o bryd.',
	'securepoll-blocked-centrally' => "Mae'n ddrwg gennym, ni allwch bleidleisio yn yr etholiad hwn gan eich bod wedi cael eich blocio ar $1 {{PLURAL:$1|wici}} o leiaf.",
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
	'securepoll-round' => 'Rownd $1',
	'securepoll-spoilt' => '(A Ddifethwyd)',
	'securepoll-exhausted' => '(Wedi dihysbyddu)',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Christian List
 * @author Kaare
 * @author Masz
 * @author Peter Alberti
 * @author Sir48
 */
$messages['da'] = array(
	'securepoll' => 'SikkertValg',
	'securepoll-desc' => 'En udvidelse til valg og undersøgelser',
	'securepoll-invalid-page' => 'Ugyldig underside "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Du skal være valgadministrator for at udføre denne handling.',
	'securepoll-too-few-params' => 'Ikke tilstrækkeligt mange undersideparametre (ugyldigt link).',
	'securepoll-invalid-election' => '"$1" er ikke et gyldigt valg-ID.',
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
	'securepoll-invalid-rank' => 'Ugyldig rang. Du skal give kandidaterne en rang mellem 1 og 999.',
	'securepoll-unranked-options' => 'Nogle muligheder blev ikke rangordnet.
Du skal give alle muligheder en rangordning mellem 1 og 999.',
	'securepoll-invalid-score' => 'Karakteren skal være et tal mellem $1 og $2.',
	'securepoll-unanswered-options' => 'Du skal give et svar ved hvert spørgsmål.',
	'securepoll-remote-auth-error' => 'Der opstod en fejl under hentning af dine kontoinformationer fra serveren.',
	'securepoll-remote-parse-error' => 'Der opstod en fejl under læsning af autorisationssvarene fra serveren.',
	'securepoll-api-invalid-params' => 'Ugyldige parametere.',
	'securepoll-api-no-user' => 'Ingen brugere med den angivne ID blev fundet.',
	'securepoll-api-token-mismatch' => 'Sikkerhedskoden er forkert, du kan ikke logge ind.',
	'securepoll-not-logged-in' => 'Du skal logge ind for at stemme i dette valg',
	'securepoll-too-few-edits' => 'Beklager, men du kan ikke stemme. Du skal have gennemført mindst $1 {{PLURAL:$1|redigering|redigeringer}}. Du har kun gennemført $2.',
	'securepoll-too-new' => 'Beklager, men du kan ikke stemme. Din konto skal være oprettet før den $1 $3 for at deltage i denne afstemning. Du oprettede din konto den $2 $4.',
	'securepoll-blocked' => 'Du kan ikke stemme, fordi du i øjeblikket er blokeret fra at redigere.',
	'securepoll-blocked-centrally' => 'Beklager, men du kan ikke deltage i denne afstemning, fordi du er blokeret på mindst $1 {{PLURAL:$1|wiki|wikier}}.',
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
	'securepoll-cookie-dup-list' => 'Cookie dubletbrugere',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Ingen krypterede valgregistreringer er tilgængelige ved dette valg, fordi valget ikke er opsat til at anvende kryptering.',
	'securepoll-dump-not-finished' => 'Krypterede valgregistreringer er kun tilgængelige efter afstemningen den $1 klokken $2.',
	'securepoll-dump-no-urandom' => 'Kan ikke åbne /dev/urandom.
For at sikre en hemmelig afstemning er de krypterede valgregistreringer kun offentligt tilgængelige, når de kan blandes med en strøm af sikre tilfældige tal.',
	'securepoll-urandom-not-supported' => 'Denne server understøtter ikke generering af tilfældige kryptografiske tal.
For at vedligeholde personlige oplysninger om vælgeren, er krypterede valgregistreringer kun offentligt tilgængelige, når de kan blandes med en strøm af sikre tilfældige tal.',
	'securepoll-translate-title' => 'Oversæt: $1',
	'securepoll-invalid-language' => 'Ugyldig sprogkode "$1"',
	'securepoll-submit-translate' => 'Opdater',
	'securepoll-language-label' => 'Vælg sprog:',
	'securepoll-submit-select-lang' => 'Oversæt',
	'securepoll-entry-text' => 'Nedenfor er listen over afstemninger.',
	'securepoll-header-title' => 'Navn',
	'securepoll-header-start-date' => 'Startdato',
	'securepoll-header-end-date' => 'Slutdato',
	'securepoll-subpage-vote' => 'Stem',
	'securepoll-subpage-translate' => 'Oversæt',
	'securepoll-subpage-list' => 'Liste',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Optælling',
	'securepoll-tally-title' => 'Optælling: $1',
	'securepoll-tally-not-finished' => 'Du kan desværre ikke optælle valgresultatet før afstemningen er slut.',
	'securepoll-can-decrypt' => 'Valgregisteret er blevet krypteret, men en dekrypteringsnøgle er tilgængelig.
Du kan enten optælle de nuværende stemmer i databasen, eller optælle krypterede resultater fra en oplagt fil.',
	'securepoll-tally-no-key' => 'Du kan ikke tælle resultatet op, fordi stemmerne er krypterede, og dekrypteringsnøglen er utilgængelig.',
	'securepoll-tally-local-legend' => 'Optællig af stemmerne',
	'securepoll-tally-local-submit' => 'Opret en optælling',
	'securepoll-tally-upload-legend' => 'Læg et krypteret dump op',
	'securepoll-tally-upload-submit' => 'Opret optælling',
	'securepoll-tally-error' => 'Fejl under læsning af stemmeregisteret, kan ikke oprette en optælling.',
	'securepoll-no-upload' => 'Ingen fil blev lagt op; kan ikke tælle resultatet op.',
	'securepoll-dump-corrupt' => 'Dumpfilen er korrupt og kan ikke behandles.',
	'securepoll-tally-upload-error' => 'Fejl ved optælling af dumpfilen: $1',
	'securepoll-pairwise-victories' => 'Matrix over parvise vindere',
	'securepoll-strength-matrix' => 'Matrix over stistyrke',
	'securepoll-ranks' => 'Endeligt resultat',
	'securepoll-average-score' => 'Gennemsnitlig karakter',
	'securepoll-round' => 'Runde $1',
	'securepoll-spoilt' => '(Ugyldig)',
	'securepoll-exhausted' => '(Udtømt)',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Kghbln
 * @author MF-Warburg
 * @author Metalhead64
 * @author Pill
 * @author Umherirrender
 */
$messages['de'] = array(
	'securepoll' => 'Sichere Abstimmung',
	'securepoll-desc' => 'Ermöglicht sichere Wahlen, Abstimmungen und Umfragen',
	'securepoll-invalid-page' => 'Ungültige Unterseite „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Du musst ein Wahl-Administrator sein, um diese Aktion durchzuführen.',
	'securepoll-too-few-params' => 'Nicht genügend Unterseitenparameter (ungültiger Link).',
	'securepoll-invalid-election' => '„$1“ ist keine gültige Abstimmungskennung.',
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
	'securepoll-unanswered-options' => 'Du musst jede Frage beantworten.',
	'securepoll-remote-auth-error' => 'Fehler beim Abruf deiner Benutzerkonteninformationen vom Server.',
	'securepoll-remote-parse-error' => 'Fehler beim Interpretieren der Berechtigungsantwort des Servers.',
	'securepoll-api-invalid-params' => 'Ungültige Parameter.',
	'securepoll-api-no-user' => 'Es wurde kein Benutzer mit der angegebenen Kennung gefunden.',
	'securepoll-api-token-mismatch' => 'Falsche Sicherheitstoken, Anmeldung fehlgeschlagen.',
	'securepoll-not-logged-in' => 'Du musst angemeldet sein, um bei dieser Wahl abstimmen zu können',
	'securepoll-too-few-edits' => 'Du darfst leider nicht abstimmen. Du musst mindestens $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} gemacht haben, um bei dieser Wahl abstimmen zu dürfen. Du hast $2 Bearbeitungen gemacht.',
	'securepoll-too-new' => 'Du darfst leider nicht abstimmen. Dein Benutzerkonto hätte vor dem $1 auf $3 registriert werden müssen, um bei dieser Wahl abstimmen zu dürfen. Du hast dich hingegen am $2 auf $4 registriert.',
	'securepoll-blocked' => 'Du darfst leider nicht abstimmen, da dein Benutzerkonto derzeit gesperrt bist.',
	'securepoll-blocked-centrally' => 'Du darfst leider nicht abstimmen, da dein Benutzerkonto derzeit auf mindestens $1 {{PLURAL:$1|Wiki|Wikis}} gesperrt ist.',
	'securepoll-bot' => 'Konten mit Botstatus sind leider nicht berechtigt, bei dieser Wahl abzustimmen.',
	'securepoll-not-in-group' => 'Nur Mitglieder der Benutzergruppe „$1“ können bei dieser Wahl abstimmen.',
	'securepoll-not-in-list' => 'Du befindest Dich leider nicht auf der Liste der Benutzer, die bei dieser Wahl abstimmen dürfen.',
	'securepoll-list-title' => 'Stimmen auflisten: $1',
	'securepoll-header-timestamp' => 'Zeit',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domäne',
	'securepoll-header-ua' => 'Browser',
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
	'securepoll-invalid-vote' => '„$1“ ist keine gültige Abstimmungskennung',
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
	'securepoll-round' => 'Runde $1',
	'securepoll-spoilt' => '(Ungültig)',
	'securepoll-exhausted' => '(Beendet)',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author ChrisiPK
 * @author Imre
 * @author Kghbln
 * @author The Evil IP address
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
	'securepoll-unanswered-options' => 'Sie müssen jede Frage beantworten.',
	'securepoll-remote-auth-error' => 'Fehler beim Abruf Ihrer Benutzerkonteninformationen vom Server.',
	'securepoll-not-logged-in' => 'Sie müssen angemeldet sein, um bei dieser Wahl abstimmen zu können.',
	'securepoll-too-few-edits' => 'Sie dürfen leider nicht abstimmen. Sie müssen mindestens $1 {{PLURAL:$1|Bearbeitung|Bearbeitungen}} gemacht haben, um bei dieser Wahl abstimmen zu dürfen. Sie haben $2 Bearbeitungen gemacht.',
	'securepoll-too-new' => 'Sie dürfen leider nicht abstimmen. Ihr Benutzerkonto hätte vor dem $1 auf $3 registriert werden müssen, um bei dieser Wahl abstimmen zu dürfen. Sie haben sich hingegen am $2 auf $4 registriert.',
	'securepoll-blocked' => 'Sie dürfen leider nicht abstimmen, da Ihr Benutzerkonto derzeit gesperrt bist.',
	'securepoll-blocked-centrally' => 'Sie dürfen leider nicht abstimmen, da Ihr Benutzerkonto derzeit auf mindestens $1 {{PLURAL:$1|Wiki|Wikis}} gesperrt ist.',
	'securepoll-not-in-list' => 'Sie befinden sich leider nicht auf der Liste der Benutzer, die bei dieser Wahl abstimmen dürfen.',
	'securepoll-tally-not-finished' => 'Sie können leider keine Stimmen auszählen, bevor die Abstimmung beendet wurde.',
	'securepoll-can-decrypt' => 'Die Wahlaufzeichnung wurde verschlüsselt, aber der Entschlüsselungsschlüssel ist verfügbar.
Sie können zwischen der Zählung der aktuellen Ergebnisse in der Datenbank und der Zählung der verschlüsselten Ergebnisse einer hochgeladenen Datei wählen.',
	'securepoll-tally-no-key' => 'Sie können die Stimmen nicht auszählen, da die Stimmen verschlüsselt sind und der Entschlüsselungsschlüssel nicht verfügbar ist.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Mirzali
 * @author Xoser
 */
$messages['diq'] = array(
	'securepoll' => 'Anketo bawerbiyaye',
	'securepoll-desc' => 'Seba weçinıtışan u anketan dergkerdış',
	'securepoll-invalid-page' => 'Pela nêvêrdiya bınêne "<nowiki>$1</nowiki>"',
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
	'securepoll-not-logged-in' => 'Nê weçinışi de seba rey gani cıkewê',
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
	'securepoll-strike-reason' => 'Sebeb:',
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
	'securepoll-too-new' => 'Bóžko njesmějoš wótgłosowaś. Twójo konto musy se do $1 $3 registrěrowaś, aby ty mógał w tos tej wólbje wótgłosował, sy se pakk $2 $4 zregistrěrował.',
	'securepoll-blocked' => 'Wódaj, njamóžoš w toś tej wólbje wótgłosowaś, jolic wobźěłowanje jo śi tuchylu zakazane.',
	'securepoll-blocked-centrally' => 'Bóžko njesmějoš w toś tej wólbje wótgłosowaś, dokulaž sy w nanejmjenjej $1 {{PLURAL:$1|wikiju|wikijoma|wikijach|wikijach}} zablokěrowany.',
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
	'securepoll-submit-select-lang' => 'Pśełožyś',
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
	'securepoll-round' => 'Runda $1',
	'securepoll-spoilt' => '(Njepłaśiwy)',
	'securepoll-exhausted' => '(Pśetrjebany)',
);

/** Greek (Ελληνικά)
 * @author Assassingr
 * @author Badseed
 * @author Consta
 * @author Crazymadlover
 * @author Evropi
 * @author Geraki
 * @author Glavkos
 * @author Omnipaedista
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Επέκταση για εκλογές και δημοσκοπήσεις',
	'securepoll-invalid-page' => 'Άκυρη υποσελίδα "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Πρέπει να είστε διαχειριστής εκλογών για να το κάνετε αυτό.',
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
	'securepoll-invalid-score' => 'Η βαθμολογία πρέπει να είναι ένας αριθμός μεταξύ $1 και $2.',
	'securepoll-unanswered-options' => 'Πρέπει να δώσετε μια απάντηση για κάθε ερώτηση.',
	'securepoll-remote-auth-error' => 'Σφάλμα κατά την ανάκτηση των πληροφοριών για τον λογαριασμό σας από τον διακομιστή.',
	'securepoll-remote-parse-error' => 'Σφάλμα στην ερμηνεία της απάντησης για άδεια πρόβασης από τον διακομιστή.',
	'securepoll-api-invalid-params' => 'Άκυρες παράμετροι.',
	'securepoll-api-no-user' => 'Δεν βρέθηκε χρήστης με το συγκεκριμένο ID.',
	'securepoll-api-token-mismatch' => 'Μη ταυτοποίηση κουπονιού ασφαλείας, δεν μπορείτε να συνδεθείτε.',
	'securepoll-not-logged-in' => 'Πρέπει να συνδεθείτε για να ψηφίσετε σε αυτές τις εκλογές',
	'securepoll-too-few-edits' => 'Λυπούμαστε, δεν μπορείτε να ψηφίσετε. Χρειάζεται να έχετε κάνει τουλάχιστον $1 {{PLURAL:$1|επεξεργασία|επεξεργασίες}} για να ψηφίσετε σε αυτή την ψηφοφορία, έχετε κάνει $2.',
	'securepoll-too-new' => 'Συγνώμη, δεν μπορείτε να ψηφίσετε.  Ο λογαριασμός σας πρέπει να έχει δημιουργηθεί πριν από την $1 για να ψηφίσει σε αυτή την εκλογή, εσείς έχετε εγγραφεί την $2.',
	'securepoll-blocked' => 'Λυπούμαστε, δεν μπορείτε να ψηφίσετε σε αυτή την ψηφοφορία αν είστε επί του παρόντος υπό φραγή από την επεξεργασία.',
	'securepoll-blocked-centrally' => 'Συγγνώμη, δεν έχετε δικαίωμα ψήφου στην παρούσα εκλογή, αν είστε αποκλεισμένοι από τη $1 ή περισσότερα {{PLURAL:$1|wiki|wikis}}.',
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
	'securepoll-round' => 'Γύρος $1',
	'securepoll-spoilt' => '(Άκυρα)',
	'securepoll-exhausted' => '(Εξαντλημένα)',
);

/** Esperanto (Esperanto)
 * @author ArnoLagrange
 * @author Marcos
 * @author ThomasPusch
 * @author Yekrats
 */
$messages['eo'] = array(
	'securepoll' => 'Sekura Enketo',
	'securepoll-desc' => 'Kromprogramo por voĉdonadoj kaj enketoj',
	'securepoll-invalid-page' => 'Malvalida subpaĝo "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Vi devas esti voĉdona administranto por fari ĉi tiun agon.',
	'securepoll-too-few-params' => 'Ne sufiĉaj subpaĝaj parametroj (malvalida ligilo).',
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
	'securepoll-no-gpg-home' => 'Ne povas krei GPG hejman dosierujon.',
	'securepoll-secret-gpg-error' => 'Eraro funkciigante GPG.
Uzu $wgSecurePollShowErrorDetail=true; en LocalSettings.php por montri pliajn detalojn.',
	'securepoll-full-gpg-error' => 'Eraro funkciigante GPG:

Komando: $1

Eraro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-ŝlosiloj estas konfiguritaj malĝuste.',
	'securepoll-gpg-parse-error' => 'Eraro interpretante GPG-eligon.',
	'securepoll-no-decryption-key' => 'Neniu malĉifra ŝlosilo estas konfigurita.
Ne povas malĉifri.',
	'securepoll-jump' => 'Iri al la voĉdona servilo',
	'securepoll-bad-ballot-submission' => 'Via voĉdono estis malvalida: $1',
	'securepoll-unanswered-questions' => 'Vi devas respondi al ĉiuj demandoj.',
	'securepoll-invalid-rank' => 'Malvalida loko. Vi devas doni al kandidatoj lokon inter 1 kaj 999.',
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
	'securepoll-too-new' => 'Pardonu, vi ne rajtas voĉdoni. Por rajti je voĉdono en tiu ĉi baloto, via uzantokonto devas esti registrita antaŭ $1 $3, sed vi registriĝis nur je $2, $4.',
	'securepoll-blocked' => 'Bedaŭrinde, vi ne povas voĉdoni en ĉi tiu voĉdonado se vi nune estas forbarita de redaktado.',
	'securepoll-blocked-centrally' => 'Pardonu, vi ne rajtas voĉdoni pro vi estas blokata en almenaŭ $1 {{PLURAL:$1|vikio|vikioj}}.',
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
	'securepoll-dump-no-urandom' => 'Ne povas malfermi /dev/urandom.
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
	'securepoll-tally-error' => 'Eraro dum interpretado de balotregistraĵo, ne povas krei nombradon.',
	'securepoll-no-upload' => 'Neniu dosiero estis elŝutita, ne povas nombri rezulton.',
	'securepoll-dump-corrupt' => 'La elŝutdosiero estas difektita kaj ne povas esti traktita.',
	'securepoll-tally-upload-error' => 'Eraro dum nombrado de elŝutdosiero: $1',
	'securepoll-pairwise-victories' => 'Matrico de paraj venkoj',
	'securepoll-strength-matrix' => 'Matrico de vojforteco',
	'securepoll-ranks' => 'Fina rangigo',
	'securepoll-average-score' => 'Averaĝa poentaro',
	'securepoll-round' => 'Balota parto $1',
	'securepoll-spoilt' => 'voĉdono ne valida',
	'securepoll-exhausted' => '(Finita)',
);

/** Spanish (Español)
 * @author Armando-Martin
 * @author Crazymadlover
 * @author Dferg
 * @author DoveBirkoff
 * @author Fitoschido
 * @author Galio
 * @author Góngora
 * @author Imre
 * @author Remember the dot
 * @author Translationista
 */
$messages['es'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Extensiones para elecciones y encuentas',
	'securepoll-invalid-page' => 'Subpágina inválida «<nowiki>$1</nowiki>»',
	'securepoll-need-admin' => 'Necesitas ser un administrador de elecciones para realizar esta acción.',
	'securepoll-too-few-params' => 'Parámetros de subpágina insuficientes (vínculo inválido).',
	'securepoll-invalid-election' => '«$1» no es un identificador de elección valido.',
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
	'securepoll-encrypt-error' => 'No se pudo cifrar tu registro de voto.
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
	'securepoll-too-new' => 'Lo sentimos, pero no puede votar. Su cuenta debió registrarse antes del $1 a las $3 para poder votar en esta elección. Usted se registró el $2 a las $4.',
	'securepoll-blocked' => 'Perdón, no puedes votar en esta elección si estás actualmente bloqueado para ediciones.',
	'securepoll-blocked-centrally' => 'Lo sentimos, no puede votar en esta elección pues usted está bloqueado al menos hasta el $1 {{PLURAL:$1|wiki|wikis}}.',
	'securepoll-bot' => 'Lo sentimos, las cuentas con flag de bot no están autorizadas a votar en esta elección.',
	'securepoll-not-in-group' => 'Solo los miembros del grupo «$1» pueden votar en esta elección.',
	'securepoll-not-in-list' => 'Lo sentimos, no estás en la lista predeterminada de usuarios autorizados a votar en esta elección.',
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
	'securepoll-invalid-vote' => '«$1» no es un identificador de voto válido',
	'securepoll-header-voter-type' => 'Tipo de votante',
	'securepoll-voter-properties' => 'Propiedades de votante',
	'securepoll-strike-log' => 'Registro de votos invalidados',
	'securepoll-header-action' => 'Acción',
	'securepoll-header-reason' => 'Razón',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-cookie-dup-list' => 'Usuarios con cookies duplicadas',
	'securepoll-dump-title' => 'Volcado: $1',
	'securepoll-dump-no-crypt' => 'No se dispone de un registro encriptado para esta votación dado que esta votación no ha sido configurada para usar encriptación.',
	'securepoll-dump-not-finished' => 'Los registros cifrados de la votación están únicamente disponibles después de la fecha de finalización en $1 de $2',
	'securepoll-dump-no-urandom' => 'No se pudo abrir /dev/urandom.
Para preservar la privacidad de los votantes, sólo son publicados los resultados cifrados de la elección cuando pueden ser mezclados con un flujo de números aleatorio.',
	'securepoll-urandom-not-supported' => 'Este servidor no posee capacidad de generación criptográfica de números aleatorios.
Para preservar la privacidad de los votantes, sólo son publicados los resultados encriptados de la elección cuando pueden ser mezclados con un flujo de números aleatorio.',
	'securepoll-translate-title' => 'Traducir: $1',
	'securepoll-invalid-language' => 'Código de idioma no válido «$1»',
	'securepoll-submit-translate' => 'Actualizar',
	'securepoll-language-label' => 'Seleccionar idioma:',
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
	'securepoll-tally-upload-legend' => 'Subir volcado cifrado',
	'securepoll-tally-upload-submit' => 'Crear cuenta',
	'securepoll-tally-error' => 'Se ha producido un error interpretando el registro de votos, no se puede crear un contador.',
	'securepoll-no-upload' => 'No se ha subido ningún archivo, no se pueden contar los resultados.',
	'securepoll-dump-corrupt' => 'El archivo de volcado está dañado y no se puede procesar.',
	'securepoll-tally-upload-error' => 'Error al contar el archivo de volcado: $1',
	'securepoll-pairwise-victories' => 'Resultados de las encuestas en este sitio',
	'securepoll-strength-matrix' => 'Organizar por cantidad de encuestas',
	'securepoll-ranks' => 'Rango final',
	'securepoll-average-score' => 'Puntuación media',
	'securepoll-round' => 'Ronda $1',
	'securepoll-spoilt' => '(Blancos o Nulos)',
	'securepoll-exhausted' => '(Agotado)',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author WikedKentaur
 */
$messages['et'] = array(
	'securepoll' => 'Turvaline hääletus',
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
	'securepoll-entry-text' => 'Allpool on küsitluste loend.',
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
 * @author Joxemai
 * @author Kobazulo
 * @author Theklan
 * @author Unai Fdz. de Betoño
 */
$messages['eu'] = array(
	'securepoll' => 'BozketaSegurua',
	'securepoll-desc' => 'Hauteskunde eta galdeketak egiteko estentsioa',
	'securepoll-invalid-page' => '"<nowiki>$1</nowiki>" azpiorrialde okerra',
	'securepoll-need-admin' => 'Ekintza hori burutzeko hauteskundeetako administratzailea izan behar duzu.',
	'securepoll-too-few-params' => 'Ez dago azpiorrialde parametro nahikorik (lotura ez baliagarria).',
	'securepoll-invalid-election' => '"$1" ez da hauteskunde ID baliagarria.',
	'securepoll-welcome' => '<strong>Ongi etorri $1!</strong>',
	'securepoll-not-started' => 'Bozketa ez da oraindik hasi. $2 ko $3 etan hastekoa da.',
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
	'securepoll-encrypt-error' => 'Ezin izan da zure bozka enkriptatua gorde.
Zure bozka ez da jaso!

$1',
	'securepoll-no-gpg-home' => 'Ezin izan da GPG oinarrizko direktorioa sortu.',
	'securepoll-secret-gpg-error' => 'GPG exekutatzen akatsa egon da.
Erabil ezazu $wgSecurePollShowErrorDetail=true; LocalSettings.php fitxategiak detaile gehiago erakusteko.',
	'securepoll-full-gpg-error' => 'Errorea GPG exekutatzen:

Komandoa: $1

Errorea:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG giltzak ez daude ondo konfiguratuta.',
	'securepoll-gpg-parse-error' => 'GPG irteera interpretatzen akatsa egon da.',
	'securepoll-no-decryption-key' => 'Ez dago dekriptatze giltza konfiguratuta.
Ezin da dekriptatu.',
	'securepoll-jump' => 'Joan bozketa zerbitzarira',
	'securepoll-bad-ballot-submission' => 'Zure bozka ez da zuzena: $1',
	'securepoll-unanswered-questions' => 'Galdera guztiak erantzun behar dituzu.',
	'securepoll-invalid-rank' => 'Tarte ez baliagarria. Hautagaiei 1etik 999rako balorea eman behar diezu.',
	'securepoll-unranked-options' => 'Aukera batzuk ez daude sailkaturik.
Aukera guztiei 1etik 999ra arteko balio bat eman behar diezu.',
	'securepoll-invalid-score' => 'Emaitza $1(e)tik $2(e)ra arteko zenbakia izan behar du.',
	'securepoll-unanswered-options' => 'Konfiantzazko lankideak.',
	'securepoll-remote-auth-error' => 'Zure kontuari buruzko informazioa ezin izan da zerbitzaritik lortu.',
	'securepoll-remote-parse-error' => 'Zerbitzariaren autorizazio emaitza interpretatzen akatsa egon da.',
	'securepoll-api-invalid-params' => 'Parametro okerrak.',
	'securepoll-api-no-user' => 'Emandako ID horrekin ez da erabiltzailerik aurkitu.',
	'securepoll-api-token-mismatch' => 'Segurtasun kodea ez da berdina, ezin izan da sartu.',
	'securepoll-not-logged-in' => 'Bozketa honetan parte hartzeko saioa hasi behar duzu',
	'securepoll-too-few-edits' => 'Barka, bain ezin duzu bozkatu. Gutxienez {{PLURAL:$1|aldaketa 1|$ aldaketa}} behar dituzu hauteskunde hauetan bozkatu ahal izateko, eta zuk $2 egin dituzu.',
	'securepoll-blocked' => 'Barkatu, ezin duzu hauteskunde hauetan bozkatu edizioak egiteko blokeo bat duzulako.',
	'securepoll-bot' => 'Barkatu, baina blot etiketa duten kontuek ezin dute hauteskundetan parte hartu.',
	'securepoll-not-in-group' => '"$1" taldeko kideek bakarrik bozka dezakete hauteskunde hauetan.',
	'securepoll-not-in-list' => 'Barkatu, ez zaude hauteskunde hauetan bozka emateko baimena duten erabiltzaileen zerrendaren barruan.',
	'securepoll-list-title' => 'Bozken zerrenda: $1',
	'securepoll-header-timestamp' => 'Ordua',
	'securepoll-header-voter-name' => 'Izena',
	'securepoll-header-voter-domain' => 'Domeinua',
	'securepoll-header-ua' => 'Lankide agentea',
	'securepoll-header-cookie-dup' => 'Bik',
	'securepoll-header-strike' => 'Baliogabetu',
	'securepoll-header-details' => 'Xehetasunak',
	'securepoll-strike-button' => 'Baliogabetu',
	'securepoll-unstrike-button' => 'Balioztatu',
	'securepoll-strike-reason' => 'Arrazoia:',
	'securepoll-strike-cancel' => 'Utzi',
	'securepoll-strike-error' => 'Akatsa egon da balioa aldatzen: $1',
	'securepoll-strike-token-mismatch' => 'Saioko informazioa galdu da',
	'securepoll-details-link' => 'Xehetasunak',
	'securepoll-details-title' => 'Bozkaren xehetasunak: #$1',
	'securepoll-invalid-vote' => '"$1" ez da bozka ID baliagarria',
	'securepoll-header-voter-type' => 'Hautesle mota',
	'securepoll-voter-properties' => 'Hauteslearen hobespenak',
	'securepoll-strike-log' => 'Baliogabetze historia',
	'securepoll-header-action' => 'Ekintza',
	'securepoll-header-reason' => 'Arrazoia',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Erabiltzaile bikoiztuen cookia',
	'securepoll-dump-title' => 'Bota: $1',
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
	'securepoll-average-score' => 'Batez besteko puntuazioa',
);

/** Persian (فارسی)
 * @author Americophile
 * @author Bersam
 * @author Ebraminio
 * @author Huji
 * @author Ladsgroup
 * @author Mardetanha
 * @author Meisam
 * @author Mjbmr
 * @author Sahim
 * @author Wayiran
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'securepoll' => 'رای‌گیری امن',
	'securepoll-desc' => 'افزونه برای رای‌گیری‌ها و جمع‌آوری اطلاعات',
	'securepoll-invalid-page' => 'زیرسفحه نامعتبر «<nowiki>$1</nowiki>»',
	'securepoll-need-admin' => 'نیاز است که شما یک مدیر انتخابات باشید که چنین کاری را بتوانید انجام دهید.',
	'securepoll-too-few-params' => 'پارامترهای ناکافی در زیرصفحه (پیوند نامعتبر)',
	'securepoll-invalid-election' => '«$1» یک شناسهٔ معتبر رای‌گیری نیست.',
	'securepoll-welcome' => '<strong>$1 خوش آمدید!</strong>',
	'securepoll-not-started' => 'این رای‌گیری هنوز آغاز نشده است.
قرار است در تاریخ $2 در ساعت $3 آغاز شود.',
	'securepoll-finished' => 'رای‌گیری به پایان رسیده‌است، شما دیگر نمی‌توانید رای دهید.',
	'securepoll-not-qualified' => 'شما واجد شرایط شرکت در این رای‌گیری نیستید: $1',
	'securepoll-change-disallowed' => 'شما پیش‌تر در این رای‌گیری رای داده‌اید.
متاسفیم، نمی‌توانید دوباره رای دهید.',
	'securepoll-change-allowed' => '<strong>نکته:شما قبلا در این رای‌گیری رای داده‌اید.</strong>
شما ممکن است مایل باشید رایتان را تغییر دهید.در این صورت فرم زیر را پر کنید.
توجه داشته باشید که اگر رای دهید.رای قبلی باطل خواهد شد.',
	'securepoll-submit' => 'ارسال رای',
	'securepoll-gpg-receipt' => 'سپاس از شما بابت رای‌دادن.

اگر تمایل دارید، می‌توانید رسید زیر را به عنوان گواه رای‌تان حفظ کنید:

<pre>$1</pre>',
	'securepoll-thanks' => 'متشکریم، رای شما ثبت شده‌است.',
	'securepoll-return' => 'بازگشت به $1',
	'securepoll-encrypt-error' => 'ثبت رای شما شکست خورد.
رای شما ثبت نشده‌است!

$1',
	'securepoll-no-gpg-home' => 'قادر به ایجاد دایرکتوری مرکزی GPG نبود.',
	'securepoll-secret-gpg-error' => 'خطا در اجرای GPG.
از <span style="direction:ltr;">$wgSecurePollShowErrorDetail=true;</span> استفاده کنید، در LocalSettings.php اطلاعات بیشتری موجود است.',
	'securepoll-full-gpg-error' => 'خطا در اجرای GPG:
فرمان: $1
خطا:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'کلیدهای GPG درست پیکربندی نشده‌اند.',
	'securepoll-gpg-parse-error' => 'خطا در تفسیر خروجی GPG.',
	'securepoll-no-decryption-key' => 'کلید رمزگشایی تنظیم نشده‌است.
نمی‌توان رمزگشایی کرد.',
	'securepoll-jump' => 'برو به سرور رای‌گیری',
	'securepoll-bad-ballot-submission' => 'رای شما نامعتبر بود: $1',
	'securepoll-unanswered-questions' => 'شما باید به تمامی سوالات پاسخ دهید.',
	'securepoll-invalid-rank' => 'رتبهٔ نامعتبر. شما باید به نامزدها رتبه‌ای بین ۱ و ۹۹۹ بدهید.',
	'securepoll-unranked-options' => 'برخی گزینه‌ها امتیاز نگرفته‌اند.
شما باید به همهٔ گزینه‌ها امتیازی بین ۱ تا ۹۹۹ بدهید.',
	'securepoll-invalid-score' => 'نمره باید عددی بین $1 و $2 باشد.',
	'securepoll-unanswered-options' => 'باید به هر سوال پاسخ دهید.',
	'securepoll-remote-auth-error' => 'خطا در واکشی اطلاعات حساب شما از سرور.',
	'securepoll-remote-parse-error' => 'خطا در تفسیر پاسخ مجازشناسی از سرور.',
	'securepoll-api-invalid-params' => 'پارامترهای نامعتبر.',
	'securepoll-api-no-user' => 'هیچ کاربری با شناسهٔ داده‌شده پیدا نشد.',
	'securepoll-api-token-mismatch' => 'توکن امنیتی تطابق ندارد، نمی‌توان وارد شد.',
	'securepoll-not-logged-in' => 'شما باید برای رای‌دادن در این رای‌گیری وارد سیستم شوید.',
	'securepoll-too-few-edits' => 'متاسفیم، شما نمی‌توانید رای دهید. برای رای‌دادن در این رای‌گیری لازم است تا حداقل $1 ویرایش داشته باشید، اما شما $2 ویرایش دارید.',
	'securepoll-too-new' => 'با عرض پوزش، شما نمی‌توانید رأی دهید. برای شرکت در این رأی‌گیری، حساب کاربری شما می‌بایست پیش از تاریخ $1، ساعت $3 ثبت می‌شد، حال آن‌که در تاریخ $2، ساعت $4 ثبت شده‌است.',
	'securepoll-blocked' => 'متاسفیم، اگر دچار محدودیت ویرایشی هستید نمی‌توانید در این رای‌گیری رای دهید.',
	'securepoll-blocked-centrally' => 'متأسفم، به خاطر اینکه حساب کاربری شما در حداقل $1 ویکی بسته شده است، شما نمی‌تواند در این رأی‌گیری شرکت کنید.',
	'securepoll-bot' => 'متاسفیم، حساب‌های با پرچم روبات اجازهٔ رای دادن در این رای‌گیری را ندارند.',
	'securepoll-not-in-group' => 'فقط اعضای گروه «$1» می‌توانند در این رای‌گیری رای دهند.',
	'securepoll-not-in-list' => 'متاسفیم، شما در فهرست ازپیش‌تعیین‌شدهٔ کاربران مجاز برای رای دادن در این رای‌گیری نیستید.',
	'securepoll-list-title' => 'فهرست رای‌ها: $1',
	'securepoll-header-timestamp' => 'زمان',
	'securepoll-header-voter-name' => 'نام',
	'securepoll-header-voter-domain' => 'دامنه',
	'securepoll-header-ua' => 'مرورگر کاربر',
	'securepoll-header-cookie-dup' => 'تکراری',
	'securepoll-header-strike' => 'خط‌زدن',
	'securepoll-header-details' => 'جزئیات',
	'securepoll-strike-button' => 'خط‌زدن',
	'securepoll-unstrike-button' => 'خط‌نازدن',
	'securepoll-strike-reason' => 'دلیل:',
	'securepoll-strike-cancel' => 'لغو',
	'securepoll-strike-error' => 'خطا در انجام خط‌زدن/خط‌نازدن: $1',
	'securepoll-strike-token-mismatch' => 'داده‌های جلسه از دست رفت',
	'securepoll-details-link' => 'جزئیات',
	'securepoll-details-title' => 'جزییات رای: #$1',
	'securepoll-invalid-vote' => '«$1» شناسهٔ رایِ معتبری نیست.',
	'securepoll-header-id' => 'شناسه',
	'securepoll-header-voter-type' => 'نوع کاربر',
	'securepoll-voter-properties' => 'خصوصیت‌های رای دهندگان',
	'securepoll-strike-log' => 'لاگ خط‌زدن',
	'securepoll-header-action' => 'اقدام',
	'securepoll-header-reason' => 'دلیل',
	'securepoll-header-admin' => 'مدیر',
	'securepoll-cookie-dup-list' => 'کاربران تکراری کوکی',
	'securepoll-dump-title' => 'روگرفت: $1',
	'securepoll-dump-no-crypt' => 'هیچ رکورد رای‌گیری رمزگذاری‌شده‌ای برای این رای‌گیری در دسترس نیست، چراکه رای‌گیری برای استفاده از رمزگذاری، پیکربندی نشده است.',
	'securepoll-dump-not-finished' => 'رکوردهای رمزگذاری‌شدهٔ رای‌گیری تنها پس از پایان تاریخ $1 در $2 قابل دسترس خواهد بود.',
	'securepoll-dump-no-urandom' => 'نمی‌توان /dev/urandom را باز کرد.
برای حفظ حریم شخصی رای‌دهنده، رکوردهای رمزگذاری‌شدهٔ رای‌گیری تنها هنگامی به صورت عمومی در دسترس خواهند بود که با یک جریان عددی تصادفی امن به‌هم‌زده شده باشند.',
	'securepoll-urandom-not-supported' => 'این میزبان تولید اعداد تصادفی رمزنگاری شده را پشتیبانی نمی‌کند. 
برای حفظ حریم خصوصی رای‌دهندگان، مدارک رمزنگاری‌شدهٔ رای‌گیری فقط زمانی عمومی خواهند شد که بتوان آن‌ها را با یک سری اعداد تصادفی جاری در هم ریخته کرد.',
	'securepoll-translate-title' => 'ترجمه: $1',
	'securepoll-invalid-language' => 'کد زبانی نامعتبر «$1»',
	'securepoll-submit-translate' => 'به روز رسانی',
	'securepoll-language-label' => 'انتخاب زبان:',
	'securepoll-submit-select-lang' => 'ترجمه',
	'securepoll-entry-text' => 'در زیر فهرستی از رای‌گیری‌ها موجود است.',
	'securepoll-header-title' => 'نام',
	'securepoll-header-start-date' => 'تاریخ آغاز',
	'securepoll-header-end-date' => 'تاریخ پایان',
	'securepoll-subpage-vote' => 'رای',
	'securepoll-subpage-translate' => 'ترجمه',
	'securepoll-subpage-list' => 'فهرست',
	'securepoll-subpage-dump' => 'روگرفت',
	'securepoll-subpage-tally' => 'شمارش',
	'securepoll-tally-title' => 'شمارش: $1',
	'securepoll-tally-not-finished' => 'شرمنده، شما نمی‌توانید رای‌ها را قبل از کامل شدن رای‌گیری شمارش کنید.',
	'securepoll-can-decrypt' => 'این انتخابات رمزنگاری شده‌است، ولی کلید رمزگشایی موجود است.
شما می‌توانید انتخاب که یا نتایج فعلی شمارش شوند، یا نتایج رمزگذاری شدهٔ بارگذاری شده، شمارش شوند.',
	'securepoll-tally-no-key' => 'شما نمی‌توانید این رای‌گیری را شمارش کنید، چراکه رای‌ها رمزگذاری‌شده هستند، و کلید رمزگشایی در دسترس نیست.',
	'securepoll-tally-local-legend' => 'نتایج ذخیره‌شدهٔ شمارش',
	'securepoll-tally-local-submit' => 'ایجاد شمارش',
	'securepoll-tally-upload-legend' => 'بارگذاری روگرفت رمزگذاری‌شده',
	'securepoll-tally-upload-submit' => 'ایجاد شمارش',
	'securepoll-tally-error' => 'خطا در تفسیر رکورد رای، نمی‌توان شمارش تولید کرد.',
	'securepoll-no-upload' => 'هیچ پرونده‌ای بارگذاری نشده، نمی‌توان نتایج را شمارش کرد.',
	'securepoll-dump-corrupt' => 'پروندهٔ روگرفت خراب است و نمی‌تواند پردازش شود.',
	'securepoll-tally-upload-error' => 'خطا در شمارش پروندهٔ روگرفت: $1',
	'securepoll-pairwise-victories' => 'ماتریس پیشروی جفت‌جفت',
	'securepoll-strength-matrix' => 'ماتریس نقاط قوت مسیر',
	'securepoll-ranks' => 'رتبه‌بندی نهایی',
	'securepoll-average-score' => 'میانگین نمره',
	'securepoll-round' => 'دور $1',
	'securepoll-spoilt' => '(معیوب)',
	'securepoll-exhausted' => '(خسته)',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Olli
 * @author Ronja Addams-Moring
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
	'securepoll-too-new' => 'Et voi äänestää, koska olet rekisteröitynyt vasta $2 kello $4. Vain käyttäjät, jotka ovat rekisteröityneet ennen $1 kello $3 voivat äänestää.',
	'securepoll-blocked' => 'Et voi äänestää näissä vaaleissa, jos sinulla on muokkausesto tällä hetkellä.',
	'securepoll-blocked-centrally' => 'Et voi äänestää, koska sinut on estetty ainakin {{PLURAL:$1|$1}} wikissä.',
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
	'securepoll-round' => 'Kierros $1',
	'securepoll-spoilt' => '(Väärin)',
	'securepoll-exhausted' => '(Ei käytetty)',
);

/** Faroese (Føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'securepoll-finished' => 'Hetta valið er liðugt, tú kanst ikki atkvøða longur.',
	'securepoll-submit' => 'Send atkvøðu',
	'securepoll-return' => 'Far aftur til $1',
	'securepoll-unanswered-questions' => 'Tú mást svara øllum spurningunum.',
	'securepoll-header-voter-name' => 'Navn',
	'securepoll-header-voter-domain' => 'Umdømi (domæne)',
	'securepoll-header-details' => 'Meira kunning',
	'securepoll-strike-reason' => 'Orsøk:',
	'securepoll-strike-cancel' => 'Ógilda',
	'securepoll-header-reason' => 'Orsøk',
	'securepoll-header-admin' => 'Admin',
	'securepoll-translate-title' => 'Umset: $1',
	'securepoll-submit-translate' => 'Dagfør',
	'securepoll-language-label' => 'Vel mál:',
	'securepoll-submit-select-lang' => 'Umset',
	'securepoll-entry-text' => 'Niðanfyri sæst listin við atkvøðum.',
	'securepoll-header-title' => 'Navn',
	'securepoll-header-start-date' => 'Byrjunardagur',
	'securepoll-header-end-date' => 'Endar dag',
	'securepoll-subpage-vote' => 'Atkvøð',
	'securepoll-subpage-translate' => 'Umset',
	'securepoll-subpage-list' => 'Listi',
);

/** French (Français)
 * @author Crochet.david
 * @author Gomoko
 * @author IAlex
 * @author Jean-Frédéric
 * @author Louperivois
 * @author Omnipaedista
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author TouzaxA
 * @author Urhixidur
 * @author Verdy p
 * @author Wyz
 * @author Yann
 */
$messages['fr'] = array(
	'securepoll' => 'Sondage sécurisé',
	'securepoll-desc' => 'Extension pour des élections et sondages',
	'securepoll-invalid-page' => 'Sous-page « <nowiki>$1</nowiki> » invalide',
	'securepoll-need-admin' => 'Vous devez être un administrateur électoral pour exécuter cette action.',
	'securepoll-too-few-params' => 'Pas assez de paramètres de sous-page (lien invalide).',
	'securepoll-invalid-election' => '« $1 » n’est pas un identifiant d’élection valide.',
	'securepoll-welcome' => '<strong>Bienvenue $1 !</strong>',
	'securepoll-not-started' => 'L’élection n’a pas encore commencé.
Elle débutera le $2 à $3.',
	'securepoll-finished' => 'Cette élection est terminée, vous ne pouvez plus voter.',
	'securepoll-not-qualified' => 'Vous n’êtes pas qualifié pour voter pour cette élection : $1',
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
	'securepoll-unranked-options' => 'Certaines options n’ont pas reçu de rang.
Vous devez donner un rang entre 1 et 999 (inclus) à toutes les options.',
	'securepoll-invalid-score' => 'Le score doit être un nombre compris entre $1 et $2.',
	'securepoll-unanswered-options' => 'Vous devez donner une réponse pour toutes les questions.',
	'securepoll-remote-auth-error' => 'Erreur lors de la récupération des informations de votre compte depuis le serveur.',
	'securepoll-remote-parse-error' => 'Erreur lors de l’interprétation de la réponse d’autorisation du serveur.',
	'securepoll-api-invalid-params' => 'Paramètres invalides.',
	'securepoll-api-no-user' => 'Aucun utilisateur avec l’identifiant donné n’a été trouvé.',
	'securepoll-api-token-mismatch' => 'Jeton de sécurité différent, connexion impossible.',
	'securepoll-not-logged-in' => 'Vous devez vous connecter pour participer à cette élection',
	'securepoll-too-few-edits' => 'Désolé, vous ne pouvez pas voter. Vous devez avoir effectué au moins {{PLURAL:$1|une modification|$1 modifications}} pour voter pour cette élection, vous en totalisez $2.',
	'securepoll-too-new' => 'Désolé, vous ne pouvez pas voter. Votre compte devait avoir été enregistré avant le $1à  $3 pour voter pour cette élection, vous vous êtes enregistré ​​le $2 à $4.',
	'securepoll-blocked' => 'Désolé, vous ne pouvez pas voter pour cette élection car vous êtes bloqué en écriture.',
	'securepoll-blocked-centrally' => 'Désolé, vous ne pouvez pas voter pour cette élection car vous êtes bloqué sur au moins $1 {{PLURAL:$1|wiki|wikis}}.',
	'securepoll-bot' => 'Désolé, les comptes avec le statut de robot (bot) ne sont pas autorisés à voter pour cette élection.',
	'securepoll-not-in-group' => 'Seuls les membres du groupe « $1 » peuvent voter pour cette élection.',
	'securepoll-not-in-list' => 'Désolé, vous n’êtes pas sur la liste prédéterminée des utilisateurs autorisés à voter pour cette élection.',
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
	'securepoll-strike-reason' => 'Motif :',
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
	'securepoll-cookie-dup-list' => 'Utilisateurs ayant un témoin déjà rencontré',
	'securepoll-dump-title' => 'Vidage : $1',
	'securepoll-dump-no-crypt' => 'Les données chiffrées ne sont pas disponibles pour cette élection, car l’élection n’est pas configurée pour utiliser un chiffrement.',
	'securepoll-dump-not-finished' => 'Les données chiffrées ne sont disponibles qu’après la clôture de l’élection le $1 à $2',
	'securepoll-dump-no-urandom' => 'Impossible d’ouvrir /dev/urandom.
Pour maintenir la confidentialité des votants, les données chiffrées ne sont disponibles que si elles peuvent être brassées à l’aide d’une suite de nombres aléatoires.',
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
	'securepoll-subpage-dump' => 'Vidage',
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
	'securepoll-round' => 'Tour $1',
	'securepoll-spoilt' => '(Blancs ou nuls)',
	'securepoll-exhausted' => '(Épuisé)',
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
	'securepoll-invalid-election' => '« $1 » est pas un numerô d’èlèccion valido.',
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
	'securepoll-api-no-user' => 'Nion usanciér avouéc lo numerô balyê at étâ trovâ.',
	'securepoll-api-token-mismatch' => 'Jeton de sècuritât difèrent, branchement empossiblo.',
	'securepoll-not-logged-in' => 'Vos vos dête branchiér por votar dens ceta èlèccion.',
	'securepoll-too-few-edits' => 'Dèsolâ, vos pouede pas votar. Vos dête avêr fêt u muens {{PLURAL:$1|yon changement|$1 changements}} por votar dens ceta èlèccion, vos en totalisâd $2.',
	'securepoll-too-new' => 'Dèsolâ, vos pouede pas votar.  Voutron compto devéve avêr étâ encartâ devant lo $1 a $3 por votar por ceta èlèccion, vos vos éte encartâ ​​lo $2 a $4.',
	'securepoll-blocked' => 'Dèsolâ, vos pouede pas votar dens ceta èlèccion perce que vos éte blocâ en ècritura.',
	'securepoll-blocked-centrally' => 'Dèsolâ, vos pouede pas votar por ceta èlèccion perce que vos éte blocâ sur u muens $1 {{PLURAL:$1|vouiqui|vouiquis}}.',
	'securepoll-bot' => 'Dèsolâ, los comptos avouéc lo statut de bot sont pas ôtorisâs a votar a ceta èlèccion.',
	'securepoll-not-in-group' => 'Solament los membros a la tropa « $1 » pôvont votar dens ceta èlèccion.',
	'securepoll-not-in-list' => 'Dèsolâ, vos éte pas sur la lista prèdètèrmenâ ux usanciérs ôtorisâs a votar dens ceta èlèccion.',
	'securepoll-list-title' => 'Lista des votos : $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nom',
	'securepoll-header-voter-domain' => 'Domêno',
	'securepoll-header-ua' => 'Agent usanciér',
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
	'securepoll-invalid-vote' => '« $1 » est pas un numerô de voto valido',
	'securepoll-header-id' => 'Numerô',
	'securepoll-header-voter-type' => 'Tipo u votent',
	'securepoll-voter-properties' => 'Propriètâts u votent',
	'securepoll-strike-log' => 'Jornal des traçâjos',
	'securepoll-header-action' => 'Accion',
	'securepoll-header-reason' => 'Rêson',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => "Usanciérs qu’ont un tèmouen (''cookie'') ja rencontrâ",
	'securepoll-dump-title' => 'Èxtrèt : $1',
	'securepoll-dump-no-crypt' => 'Les balyês criptâs sont pas disponibles por ceta èlèccion, perce que l’èlèccion est pas configurâ por utilisar un criptâjo.',
	'securepoll-dump-not-finished' => 'Les balyês criptâs sont disponibles ren qu’aprés la cllotura de l’èlèccion lo $1 a $2',
	'securepoll-dump-no-urandom' => 'Empossiblo d’uvrir /dev/urandom. 
Por mantegnir la confidencialitât ux votents, les balyês criptâs sont disponibles u publico ren que se pôvont étre braciês avouéc una suita de nombros a l’hasârd.',
	'securepoll-urandom-not-supported' => 'Ceti sèrvor recognêt pas la g·ènèracion criptografica de nombros a l’hasârd.
Por mantegnir la confidencialitât ux votents, les balyês criptâs sont disponibles u publico ren que se pôvont étre braciês avouéc una suita de nombros a l’hasârd.',
	'securepoll-translate-title' => 'Traduire : $1',
	'securepoll-invalid-language' => 'Code lengoua « $1 » envalido.',
	'securepoll-header-trans-id' => 'Numerô',
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
	'securepoll-can-decrypt' => 'L’encartâjo de l’èlèccion at étâ criptâ, mas la cllâf de dècriptâjo est disponibla. 
Vos pouede chouèsir de comptar los rèsultats dês la bâsa de balyês ou ben dês un fichiér tèlèchargiê.',
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
	'securepoll-round' => 'Tôrn $1',
	'securepoll-spoilt' => '(Blancs ou ben nuls)',
	'securepoll-exhausted' => '(Èpouesiê)',
);

/** Friulian (Furlan)
 * @author Akaahdudeson
 * @author Klenje
 */
$messages['fur'] = array(
	'securepoll' => '↓SecurePoll',
	'securepoll-welcome' => '↓<strong>Benvignût! $1!</strong>',
	'securepoll-not-started' => '↓Cheste elezion no je ancjemò començade.
La elezion e començarà il $2 a lis $3.',
	'securepoll-finished' => 'Chiste elezion a jè finide, i no ti pòs plui votâ.',
	'securepoll-not-qualified' => '↓I no ti âs la cualifiche par votâ in cheste elezion: $1',
	'securepoll-change-disallowed' => '↓ I tu as bielzà votât par cheste elezion.
Scuse, i no ti puedis plui votâ.',
	'securepoll-thanks' => '↓Graciis, il to vôt al è stât regjistrât',
	'securepoll-return' => '↓Torne a $1',
	'securepoll-encrypt-error' => '↓Impussibil codificâ lis informazions dal vôt.
Il to vôt nol è stât regjistrât!

$1',
	'securepoll-header-timestamp' => '↓Ore',
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
	'securepoll' => 'Sondaxe segura',
	'securepoll-desc' => 'Extensión para as eleccións e sondaxes',
	'securepoll-invalid-page' => 'Subpáxina "<nowiki>$1</nowiki>" inválida',
	'securepoll-need-admin' => 'Ten que ser administrador das eleccións para poder levar a cabo esta acción.',
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
	'securepoll-return' => 'Volver a $1',
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
	'securepoll-api-token-mismatch' => 'Desaxuste dun pase de seguridade; non pode acceder ao sistema.',
	'securepoll-not-logged-in' => 'Debe acceder ao sistema para votar nestas eleccións',
	'securepoll-too-few-edits' => 'Sentímolo, non pode votar nestas eleccións. Debe ter feito, polo menos, {{PLURAL:$1|unha edición|$1 edicións}}, e só ten feito $2.',
	'securepoll-too-new' => 'Sentímolo, non pode votar nestas eleccións. Debe ter unha conta rexistrada antes do $1 ás $3 para poder votar; a data do seu rexistro é o $2 ás $4.',
	'securepoll-blocked' => 'Sentímolo, non pode votar nestas eleccións se está actualmente bloqueado fronte á edición.',
	'securepoll-blocked-centrally' => 'Sentímolo, non pode votar nestas eleccións porque está bloqueado, polo menos, {{PLURAL:$1|nun wiki|en $1 wikis}}.',
	'securepoll-bot' => 'Sentímolo, as contas con dereitos de bot non están autorizadas a votar nestas eleccións.',
	'securepoll-not-in-group' => 'Só os membros pertencentes ao grupo dos $1 poden votar nestas eleccións.',
	'securepoll-not-in-list' => 'Sentímolo, non está na lista predeterminada de usuarios autorizados a votar nestas eleccións.',
	'securepoll-list-title' => 'Lista de votos: $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Axente de usuario',
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
	'securepoll-round' => 'Ronda $1',
	'securepoll-spoilt' => '(Nulos)',
	'securepoll-exhausted' => '(Esgotados)',
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
	'securepoll-too-new' => 'Du derfsch leider nit abstimme. Dyy Benutzerkonto hätt vor em $1 uf $3 mieße regischtriert wäre go bi däre Wahl abstimme z derfe. Du hesch Di aber am $2 uf $4 regischtriert.',
	'securepoll-blocked' => 'Excusez, Du derfsch nit abstimme bi däre Wahl, wänn Du grad fir Bearbeitige gsperrt bisch.',
	'securepoll-blocked-centrally' => 'Du derfsch leider nit abstimme, wel Dyy Benutzerkonto zurzyt uf zmindescht $1 {{PLURAL:$1|Wiki|Wiki}} gsperrt isch.',
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
	'securepoll-subpage-translate' => 'Ibersetze',
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
	'securepoll-round' => 'Rundi $1',
	'securepoll-spoilt' => '(Uugiltig)',
	'securepoll-exhausted' => '(Fertig)',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'securepoll' => 'સુરક્ષિત ચૂંટણી',
	'securepoll-desc' => 'ચૂંટણી અને સર્વેક્ષણ ના વિસ્તારકો (Extension)',
	'securepoll-invalid-page' => 'અયોગ્ય ઉપપાનું "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'આ કાર્ય કરવા માટે તમે વ્યવસ્થાપક હોવા જોઈએ',
	'securepoll-too-few-params' => 'અપુરતા ઉપપાનાં પરિમાણો (અક્ષમ કડી)',
	'securepoll-invalid-election' => '"$1" એ યોગ્ય ચૂંટણી ID નથી.',
	'securepoll-welcome' => '<strong>સ્વાગતમ્ $1!</strong>',
	'securepoll-not-started' => 'મતદાન હજી શરૂ થયું નથી
તે $2 ના દિવસે $3 વાગ્યે શરૂ થશે.',
	'securepoll-finished' => 'આ ચૂંટણી સમાપ્ત થઈ ગઈ છે તમે તેમાં ભાગ નહીં લઈ શકો',
	'securepoll-not-qualified' => 'તમે આ ચૂંટણીમાં મત આપવા માટે લાયક નથી: $1',
	'securepoll-change-disallowed' => 'તમે આ ચૂંટણીમાં પહેલાં ભાગ લીધો છે.
ખેદ છે, તમે આ ચૂંટણીમાં ફરી મતદાન નહીં કરી શકો.',
	'securepoll-submit' => 'મત જમા કરો',
	'securepoll-gpg-receipt' => 'મતદાન માટે ધન્યવાદ
તમે ધારો તો તમારા સંદર્ભ માટે નીચેની રસીસ રાખી શકો છો.
<pre>$1</pre>',
	'securepoll-thanks' => 'તમારો આભાર, તમારો મત અંકિત કરી દેવામાં આવ્યો છે.',
	'securepoll-return' => '$1 પર પાછા જાઓ',
	'securepoll-encrypt-error' => 'તમારા મતદાનને એનક્રીપ્ટ કરવા નિષ્ફળતા.
તમારો મત નોંધાયો નથી.

$1',
	'securepoll-no-gpg-home' => 'GPG ગૃહ ડીરેક્ટરી નિર્માણ કરી ન શકાઇ',
	'securepoll-secret-gpg-error' => 'GPG ચલાવતા ક્ષતિ આવી.
વધુ વિગતો માટે LocalSettings.php માં $wgSecurePollShowErrorDetail=true; વાપરો.',
	'securepoll-full-gpg-error' => 'GPG ચલાવતી વખતે ક્ષતિ આવી:

આદેશ: $1

ક્ષતિ:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG ચાવીઓ ખોટી રીતે ગોઠવાયા હતાં.',
	'securepoll-gpg-parse-error' => 'GPG પ્રત્યુત્ત્ર માહિતીને ઉકેલવામાં તૃટી',
	'securepoll-no-decryption-key' => 'કોઈ ડિક્રિપ્શન કળ રુપરેખાંકિત કરેલ નથી.
ડિક્રિપ્ટ કરી શકશે નહી.',
	'securepoll-jump' => 'ચૂંટણી સર્વર પર જાવ',
	'securepoll-bad-ballot-submission' => 'તમારો મત અવૈધ છે : $1',
	'securepoll-unanswered-questions' => 'તમારે બધા સવાલના જવાબ આપેલા હોવા જોઇએ.',
	'securepoll-invalid-rank' => 'અ વૈધ ક્રમાંક. તમારે ઉમેદવારને ૧ અને ૯૯૯ વચ્ચે ક્રમાંક આપવોજોઈએ.',
	'securepoll-unranked-options' => 'અમુક વિકલ્પોને ક્રમ અપાયો નથી.
તમારે દરેક વિકલ્પને ૧ થી ૯૯૯ સુધીનો ક્રમ આપવો જોઈએ',
	'securepoll-invalid-score' => 'ગુણાંક $1 અને $2 ચચ્ચેની સંખ્યા હોવી જોઈએ',
	'securepoll-unanswered-options' => 'તમારે દરેક પ્રશ્ન પર ઉત્તર આપવો જ પડશે.',
	'securepoll-api-invalid-params' => 'અયોગ્ય પરિમાણો.',
	'securepoll-api-no-user' => 'આપેલ ઓળખ પર કોઈ સભ્ય મળ્યો નહી.',
	'securepoll-api-token-mismatch' => 'સુરક્ષા ટોકન અસંગતી, પ્રવેશ નહીં કરી શકાય',
	'securepoll-not-logged-in' => 'આ ચૂટણીમાં મત આપવા લોગીન કરેલુઁ હોવું જોઇએ',
	'securepoll-too-few-edits' => 'ખેદ છે, તમે મતદાન કરી શકશો નહીં.  તમે આ ચૂંટની માં ભાગ લેવા માટે કમસેકમ $1 {{PLURAL:$1|ફેરફાર|ફેરફારો}} કરેલા હોવાં જોઈએ તમે $2 ફેરફાર કર્યાં છે. .',
	'securepoll-too-new' => 'અફસોસ, તમે મતદાન કરી શકશો નહી. આ ચૂંટણીમાં ભાગ લેવા માટે $1 તારીખે $3 વાગ્યા પહેલા તમારા ખાતાની નોંધણી થઈ હોવી જોઈએ. તમે  $2 તારીખે $4 વાગ્યે તમારૂં ખાતું ખોલ્યું હતું.',
	'securepoll-blocked' => 'ખેદ છે જો તમારા પર ફેરફાર કરવાનો પ્રતિબણ્ધ હશે તો તમે આ ચૂંટણીમાં મતદાન નહીં કરી શકો .',
	'securepoll-blocked-centrally' => 'ખેદ છે, તમે મતદાનમાં ભગ નહીં લઈ શકો કેમકે તમારા પર કમસે કમ $1 {{PLURAL:$1|વિકી|વિકીઓ}} પર પ્રતિબંધ મૂકાયો છે.',
	'securepoll-bot' => 'ખેદ છે, બૉટ વિસ્તારક ધરાવતાં સભ્યનામ આ ચૂંટણીમાં ભાગ લઈ શકશે નહીં',
	'securepoll-not-in-group' => 'માત્ર "$1" જૂથના સભ્યો જ આ ચૂંટણીમાં મત આપી શકે છે.',
	'securepoll-list-title' => 'મતોની યાદી: $1',
	'securepoll-header-timestamp' => 'સમય',
	'securepoll-header-voter-name' => 'નામ',
	'securepoll-header-voter-domain' => 'ડોમેઈન',
	'securepoll-header-ua' => 'સભ્ય ઍજન્ટ',
	'securepoll-header-cookie-dup' => 'નકલી',
	'securepoll-header-strike' => 'છેકો',
	'securepoll-header-details' => 'વિગતો',
	'securepoll-strike-button' => 'છેકો',
	'securepoll-unstrike-button' => 'છેકો હટાવો',
	'securepoll-strike-reason' => 'કારણ:',
	'securepoll-strike-cancel' => 'રદ કરો',
	'securepoll-strike-token-mismatch' => 'સત્ર માહિતી ખોઇ દીધી',
	'securepoll-details-link' => 'વિગતો',
	'securepoll-details-title' => 'મત વિગતો: #$1',
	'securepoll-invalid-vote' => '"$1" એ યોગ્ય ચૂંટણી ID નથી',
	'securepoll-header-voter-type' => 'મતદાતા પ્રકાર',
	'securepoll-voter-properties' => 'મતદાતા ના ગુણધર્મો',
	'securepoll-strike-log' => 'લોગ છેકો',
	'securepoll-header-action' => 'ક્રિયા',
	'securepoll-header-reason' => 'કારણ',
	'securepoll-header-admin' => 'સંચાલક',
	'securepoll-cookie-dup-list' => 'કૂકી ડ્યુપ્લીકેટ સભ્ય',
	'securepoll-dump-title' => 'કાટમાળ: $1',
	'securepoll-translate-title' => 'ભાષાંતર કરો: $1',
	'securepoll-invalid-language' => 'અયોગ્ય ભાષા કોડ "$1"',
	'securepoll-submit-translate' => 'અદ્યતન કરો',
	'securepoll-language-label' => 'ભાષા પસંદ કરો:',
	'securepoll-submit-select-lang' => 'ભાષાંતર કરો',
	'securepoll-entry-text' => 'નીચે ચૂંટણીઓની યાદી છે.',
	'securepoll-header-title' => 'નામ',
	'securepoll-header-start-date' => 'આરંભ તારીખ',
	'securepoll-header-end-date' => 'અંતિમ તારીખ',
	'securepoll-subpage-vote' => 'મત',
	'securepoll-subpage-translate' => 'ભાષાંતર કરો',
	'securepoll-subpage-list' => 'યાદી',
	'securepoll-subpage-dump' => 'કાટમાળ',
	'securepoll-subpage-tally' => 'તાળો',
	'securepoll-tally-title' => 'તાળો : $1',
	'securepoll-tally-not-finished' => 'ખેદ છે, તમે મતદાન પૂર્ણ થયાં પહેલાં તાળો ન મેળવી શકો',
	'securepoll-tally-local-legend' => 'સંઘરેલા પરિણમો તાળો મેળવો',
	'securepoll-tally-local-submit' => 'તાળો નિર્માણ કરો',
	'securepoll-tally-upload-legend' => 'ઍન્ક્રીપ્ટેડ કટમાળ ચઢાવો',
	'securepoll-tally-upload-submit' => 'તાળો નિર્માણ કરો',
	'securepoll-no-upload' => 'કોઈ પણ ફાઈલ ચઢાવી નથી, પરિણામ નો તાળો ન મેળવી શકાયો',
	'securepoll-dump-corrupt' => 'કાટમાળ ફાઈલ ખરાબ થઈ ગઈ છે તેન પર પ્રક્રિયા નહીં કરી શકાય',
	'securepoll-tally-upload-error' => 'કાટમાળ ફાઈલ નો તાળો મેળવવામાં ત્રુટી: $1',
	'securepoll-pairwise-victories' => 'જોડી અનુસાર વિજય જૂથ',
	'securepoll-strength-matrix' => 'પાથ સ્ટ્રેંથ મેટ્રીક્સ',
	'securepoll-ranks' => 'અંતિમ ક્રમ યાદી',
	'securepoll-average-score' => 'સરેરાશ ગુણ',
	'securepoll-round' => 'ચરણ $1',
	'securepoll-spoilt' => '(બગડી ગયેલ)',
	'securepoll-exhausted' => '(સમાપ્ત)',
);

/** Manx (Gaelg)
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'securepoll-strike-reason' => 'Fa:',
	'securepoll-header-reason' => 'Fa:',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'securepoll-strike-cancel' => 'Soke',
	'securepoll-header-reason' => 'Dalili',
);

/** Hebrew (עברית)
 * @author Amire80
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
	'securepoll-welcome' => '<strong>ברוך בואך, $1!</strong>',
	'securepoll-not-started' => 'הצבעה זו טרם התחילה.
תחילתה נקבעה ל־$3, $2.',
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
	'securepoll-return' => 'בחזרה ל{{GRAMMAR:תחילית|$1}}',
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
	'securepoll-too-few-edits' => 'מצטערים, אינכם יכולים להצביע. היה עליכם לעשות לפחות {{PLURAL:עריכה אחת|$1 עריכות}} כדי להצביע בהצבעה זו, ועשיתם רק {{PLURAL:$2|אחת|$2}}.',
	'securepoll-too-new' => 'סליחה, אין באפשרותך להצביע. חשבונך היה צריך להיווצר לפני $1 בשעה $3 כדי להצביע בבחירות האלו והוא נוצר ב־$2 בשעה $4.',
	'securepoll-blocked' => 'מצטערים, אינכם יכולים להצביע בהצבעה זו אם אתם חסומים כרגע מעריכה.',
	'securepoll-blocked-centrally' => 'סליחה, אין באפשרותך להצביע בבחירות האלו אם חשבונך חסום ב{{PLURAL:$1|אתר ויקי אחד או יותר|$1 אתרי ויקי או יותר}}.',
	'securepoll-bot' => 'מצטערים, חשבונות עם דגל בוט אינם רשאים להצביע בהצבעה זו.',
	'securepoll-not-in-group' => 'רק חברים בקבוצה "$1" יכולים להצביע בהצבעה זו.',
	'securepoll-not-in-list' => 'מצטערים, אינכם ברשימת המשתמשים שהוגדרו מראש כרשאים להצביע בהצבעה זו.',
	'securepoll-list-title' => 'רשימת הצבעות: $1',
	'securepoll-header-timestamp' => 'זמן',
	'securepoll-header-voter-name' => 'שם',
	'securepoll-header-voter-domain' => 'מתחם',
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
	'securepoll-dump-no-urandom' => 'לא ניתן לפתוח את ‎/dev/urandom. 
כדי לשמור על פרטיות המצביעים, רשומות ההצבעה המוצפנות זמינות לציבור רק כאשר ניתן לערבלן באמצעות זרם מספרים אקראיים מאובטח.',
	'securepoll-urandom-not-supported' => 'שרת זה אינו תומך ביצירת מספרים אקראיים לצורך הצפנה.
כדי לשמור על פרטיות המצביעים, רשומות ההצבעה המוצפנות זמינות לציבור רק כאשר ניתן לערבלן באמצעות זרם מספרים אקראיים מאובטח.',
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
	'securepoll-round' => 'סיבוב $1',
	'securepoll-spoilt' => '(פסולות)',
	'securepoll-exhausted' => '(מוצו)',
);

/** Hindi (हिन्दी)
 * @author Sau6402
 * @author Shyam
 * @author Vsrawat
 * @author आलोक
 */
$messages['hi'] = array(
	'securepoll' => 'सुरक्षितनिर्वाचन',
	'securepoll-desc' => 'निर्वाचनों और सर्वेक्षणों के लिए विस्तार',
	'securepoll-invalid-page' => 'अवैध उपपृष्ठ "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'यह क्रिया करने के लिए आपको एक चुनाव व्यवस्थापक होना चाहिए।',
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
	'securepoll-invalid-score' => 'आपके गुण $1 और $2 संख्या के बीचमे होनी चाहिए',
	'securepoll-unanswered-options' => 'आपको हर सवाल के लिए प्रतिसाद देना आवश्यक है।',
	'securepoll-remote-auth-error' => 'इस सर्वर से आपके खाते की जानकारी ले के आने में त्रुटि।',
	'securepoll-remote-parse-error' => 'इस सर्वर से इस अधिकृतिकरण के उत्तर को बाँचने में त्रुटि।',
	'securepoll-api-invalid-params' => 'अवैध प्राचलक।',
	'securepoll-api-no-user' => 'दी गई आई डी के साथ कोई प्रयोक्ता नहीं मिला।',
	'securepoll-api-token-mismatch' => 'सुरक्षा बिल्ले का मिलान नहीं हुआ, लॉग नहीं कर सकते।',
	'securepoll-not-logged-in' => 'आपको इस निर्वाचन में मतदान करने के लिए लॉग इन अवश्य करना चाहिए।',
	'securepoll-too-few-edits' => 'क्षमा कीजिए, आप मतदान नहीं कर सकते। इस निर्वाचन में मतदान करने के लिए आपको न्यूनतम $1 संपादन {{PLURAL:$1|किया होना चाहिए|संपादन किए होने चाहिएँ}}, परंतु आपने $2 {{PLURAL:$2|किया है|किए हैं}}।',
	'securepoll-too-new' => 'क्षमा करें, आप मतदान नहीं कर सकते हैं। आपके खाते को $1 के पहले पंजीकृत होने कि आवश्यकता थी, आप $2 को पंजीकृत किये गए थे।',
	'securepoll-blocked' => 'क्षमा कीजिए, आप इस निर्वाचन में मतदान नहीं कर सकते यदि आप वर्तमान में संपादन करने से बाधित हैं।',
	'securepoll-blocked-centrally' => 'यदि आप पर अवरुद्ध कर रहे हैं खेद है, आप इस चुनाव में वोट नहीं कर सकते $1 या एक से अधिक {{PLURAL:$1| विकि | विकि}}',
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
	'securepoll-entry-text' => 'नीचे चुनावों की सूची है ।',
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
	'securepoll-average-score' => 'औसत गुण',
	'securepoll-round' => 'दौर $1',
	'securepoll-spoilt' => '(खराब)',
	'securepoll-exhausted' => '(समाप्त)',
);

/** Croatian (Hrvatski)
 * @author Anton008
 * @author Bugoslav
 * @author Ex13
 * @author Roberta F.
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
	'securepoll-invalid-score' => 'Rezultat mora biti broj između $1 i $2.',
	'securepoll-unanswered-options' => 'Morate dati odgovor na svako pitanje.',
	'securepoll-remote-auth-error' => 'Pogreška pri dobavljanje informacije o Vašem računu s poslužitelja.',
	'securepoll-remote-parse-error' => 'Pogreška pri tumačenju autorizacijskog odgovora s poslužitelja.',
	'securepoll-api-invalid-params' => 'Nevažeći parametri.',
	'securepoll-api-no-user' => 'Nema suradnika s tim ID brojem.',
	'securepoll-api-token-mismatch' => 'Neslaganje sigurnosnog tokena, neuspjela prijava.',
	'securepoll-not-logged-in' => 'Morate se prijaviti da bi mogli glasovati na ovim izborima',
	'securepoll-too-few-edits' => 'Nažalost, ne možete glasovati. Morate imati najmanje $1 {{PLURAL:$1|uređivanje|uređivanja|uređivanja}} da bi mogli glasovati na ovim izborima, vi ih imate $2.',
	'securepoll-too-new' => 'Nažalost, ne možete glasovati. Vaš suradnički račun je morao biti registriran prije $1 za glasovanje na ovim izborima, Vi ste se registrirali $2.',
	'securepoll-blocked' => 'Nažalost, ne možete glasovati na ovim izborima ako ste trenutačno blokirani',
	'securepoll-blocked-centrally' => 'Nažalost, ne možete glasovati na ovim izborima ako ste blokirani na $1 ili više {{PLURAL:$1| wiki|wikija}}.',
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
	'securepoll-entry-text' => 'Ispod je popis glasovanja.',
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
	'securepoll-average-score' => 'Prosječni rezultat',
	'securepoll-round' => 'Izborni krug $1',
	'securepoll-spoilt' => '(Nevrijedeće glasovanje)',
	'securepoll-exhausted' => '(Iscrpljen)',
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
	'securepoll-too-new' => 'Bojužel njesměš wothłosować. Twoje konto dyrbi so do $1 $3 registrować, zo by móhł w tutej wólbje wothłosował, sy so wšak $2 $4 zregistrował.',
	'securepoll-blocked' => 'Wodaj, njemóžeš w tutej wólbhje wothłosować, dokelž sy za wobdźěłowanje zablokowany.',
	'securepoll-blocked-centrally' => 'Bohužel njesměš w tutej wólbje wothłosować, dokelž sy w znajmjeńša $1 {{PLURAL:$1|wikiju|wikijomaj|wikijach|wikijach}} zablokowany.',
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
	'securepoll-round' => 'Koło $1',
	'securepoll-spoilt' => '(Njepłaćiwy)',
	'securepoll-exhausted' => '(Wučerpany)',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Cassandro
 * @author Cbrown1023
 * @author Dani
 * @author Dj
 * @author Glanthor Reviol
 * @author Hunyadym
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
	'securepoll-too-new' => 'Sajnos nem szavazhatsz. A szavazáshoz $1, $3 előtt kellett volna regisztrálnod, a te regisztrációd időpontod: $2, $4.',
	'securepoll-blocked' => 'Nem szavazhatsz ezen a választáson, amíg blokkolva vagy.',
	'securepoll-blocked-centrally' => 'Sajnos nem szavazhatsz a választáson, mivel blokkolva vagy $1 vagy több wikin.',
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
	'securepoll-round' => '$1. forduló',
	'securepoll-spoilt' => '(Rontott)',
	'securepoll-exhausted' => '(Kiesett)',
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
	'securepoll-bad-ballot-submission' => 'Tu voto es invalide: $1',
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
	'securepoll-too-new' => 'Pardono, tu non pote votar. Un conto debe haber essite create ante le $1 a $3 pro poter votar in iste election, ma tu conto ha essite create le $2 a $4.',
	'securepoll-blocked' => 'Pardono, tu non pote votar in iste election durante que tu es blocate de facer modificationes.',
	'securepoll-blocked-centrally' => 'Pardono, tu non pote votar in iste election proque tu es blocate in al minus $1 {{PLURAL:$1|wiki|wikis}}.',
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
	'securepoll-voter-properties' => 'Proprietates del votante',
	'securepoll-strike-log' => 'Registro de cancellationes',
	'securepoll-header-action' => 'Action',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Usatores con cookie duplice',
	'securepoll-dump-title' => 'Extracto: $1',
	'securepoll-dump-no-crypt' => 'Nulle registro cryptate es disponibile pro iste election, proque le election non es configurate pro usar cryptation.',
	'securepoll-dump-not-finished' => 'Le registro cryptate del election non essera disponibile usque le data final: le $1 a $2',
	'securepoll-dump-no-urandom' => 'Impossibile aperir /dev/urandom.
Pro assecurar le confidentialitate del votantes, le datos cryptate del election es solmente disponibile al publico si illos pote esser miscite con un fluxo de numeros aleatori secur.',
	'securepoll-urandom-not-supported' => 'Iste servitor non supporta le generation de numeros aleatori cryptographic.
Pro assecurar le confidentialitate del votantes, le datos cryptate del election es solmente disponibile al publico si illos pote esser miscite con un fluxo de numeros aleatori secur.',
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
Tu pote optar pro contar le resultatos presente in le base de datos, o pro contar le resultatos cryptate ab un file incargate.',
	'securepoll-tally-no-key' => 'Tu non pote contar le resultatos de iste election proque le votos es cryptate e le clave de decryptation non es disponibile.',
	'securepoll-tally-local-legend' => 'Contar le resulatos immagazinate',
	'securepoll-tally-local-submit' => 'Contar resultatos',
	'securepoll-tally-upload-legend' => 'Incargar un file de datos cryptate',
	'securepoll-tally-upload-submit' => 'Contar resultatos',
	'securepoll-tally-error' => 'Error durante le interpretation del registro de voto; non pote producer un conto.',
	'securepoll-no-upload' => 'Nulle file ha essite incargate; non pote contar le resultatos.',
	'securepoll-dump-corrupt' => 'Le file de dump es corrumpite e non pote esser processate.',
	'securepoll-tally-upload-error' => 'Error de contar ex le file de dump: $1',
	'securepoll-pairwise-victories' => 'Matrice de vincimento in pares',
	'securepoll-strength-matrix' => 'Matrice de fortia de cammino',
	'securepoll-ranks' => 'Rango final',
	'securepoll-average-score' => 'Score medie',
	'securepoll-round' => 'Ronda $1',
	'securepoll-spoilt' => '(Invalide)',
	'securepoll-exhausted' => '(Exhaurite)',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Kenrick95
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
	'securepoll-jump' => 'Pergi ke server pemungutan suara',
	'securepoll-bad-ballot-submission' => 'Suara Anda tidak sah: $1',
	'securepoll-unanswered-questions' => 'Anda harus menjawab semua pertanyaan.',
	'securepoll-invalid-rank' => 'Peringkat tidak sah. Anda harus memberi peringkat kandidat antara 1 dan 99.',
	'securepoll-unranked-options' => 'Beberapa pilihan tidak diberi peringkat.
Anda harus memberi peringkat antara 1 dan 99 untuk semua pilihan.',
	'securepoll-invalid-score' => 'Nilai haruslah nomor antara $1 dan $2.',
	'securepoll-unanswered-options' => 'Anda harus memberi tanggapan terhadap setiap pertanyaan.',
	'securepoll-remote-auth-error' => 'Terjadi kesalahan ketika mengambil informasi akun Anda dari server.',
	'securepoll-remote-parse-error' => 'Terjadi kesalahan interpretasi atas respons otorisasi dari server.',
	'securepoll-api-invalid-params' => 'Parameter tidak sah.',
	'securepoll-api-no-user' => 'Tidak ditemukan nama pengguna dengan ID tersebut.',
	'securepoll-api-token-mismatch' => 'Kode keamanan tidak sesuai, tidak dapat masuk log.',
	'securepoll-not-logged-in' => 'Anda harus masuk log untuk dapat memberikan suara dalam pemilihan ini',
	'securepoll-too-few-edits' => 'Maaf, Anda tidak dapat memberikan suara. Anda harus memiliki minimal $1 {{PLURAL:$1|suntingan|suntingan}} untuk dapat memberikan suara dalam pemilihan ini, Anda hanya memiliki $2.',
	'securepoll-too-new' => 'Maaf, Anda tidak dapat memilih. Akun Anda harus terdaftar sebelum $1 pada $3 untuk memilih dalam pemilu ini, Anda mendaftar di $2 pada $4',
	'securepoll-blocked' => 'Maaf, Anda tidak dapat memberikan suara karena akun Anda sedang diblokir.',
	'securepoll-blocked-centrally' => 'Maaf, Anda tidak dapat memberikan suara dalam pemilihan ini jika Anda diblokir pada $1 atau lebih {{PLURAL:$1| wiki | wiki}}.',
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
	'securepoll-urandom-not-supported' => 'Server ini tidak mendukung kriptografi pembuatan angka acak.
Untuk menjaga kerahasiaan pemilih, catatan pemilihan terenkripsi hanya tersedia secara publik jika catatan tersebut dapat diacak dengan angka acak yang aman.',
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
	'securepoll-round' => 'Ronde $1',
	'securepoll-spoilt' => '(Rusak)',
	'securepoll-exhausted' => '(Habis)',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'securepoll-header-timestamp' => 'Ógẹ',
	'securepoll-header-voter-name' => 'Áhà',
	'securepoll-strike-reason' => 'Mgbághapụtà:',
	'securepoll-strike-cancel' => 'Kàchá',
	'securepoll-details-link' => 'Nkȯwa',
	'securepoll-header-action' => 'Ọmé',
	'securepoll-header-reason' => 'Mgbaghaputa',
	'securepoll-submit-translate' => 'Dịnwanye mmā',
	'securepoll-language-label' => 'Nwèré asụsụ:',
	'securepoll-submit-select-lang' => 'Kuwaria na asụsụ ozor',
	'securepoll-header-title' => 'Áhà',
	'securepoll-subpage-vote' => 'Votu',
	'securepoll-subpage-list' => 'Ndetu',
	'securepoll-subpage-dump' => 'Nkwáfù',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'securepoll' => 'Natalged a panagbotos',
	'securepoll-desc' => 'Pagpaatiddog para dagiti panagbubutos ken panagala',
	'securepoll-invalid-page' => 'Imbalido nga apo ti panid "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Masapul nga administrador ka ti panagbubutos ti agtungpal daytoy nga aramid.',
	'securepoll-too-few-params' => 'Awan ti umanay nga apo ti panid kadagiti parametro (imbalido a panilpo) .',
	'securepoll-invalid-election' => '"$1" ket saan nga umisu a panagbubutos nga ID.',
	'securepoll-welcome' => '<strong>Kablaaw $1!</strong>',
	'securepoll-not-started' => 'Daytoy a panagbubutos ket saan pay nairugi.
Agrugin to no $2 iti $3.',
	'securepoll-finished' => 'Nalpasen daytoy a panagbubutos, saan kan a makabutos.',
	'securepoll-not-qualified' => 'Saan mo a mabalin ti agbutos iti daytoy a panagbubutusan: $1',
	'securepoll-change-disallowed' => 'Nagbutos kan iti daytoy nga panagbubutosan idin.
Pasensia, saan ka a makabutos manen.',
	'securepoll-change-allowed' => '<strong>Paammo: Nagbutos ka iti daytoy a panagbubutos idin.</strong>
Mabalin mo a sukatan ti butos mo babaen ti panagited ti kinabuklan dita baba.
Paammo a no aramidem daytoy, ti sigud  a butos mo ket maibelleng ton.',
	'securepoll-submit' => 'Ited ti butos',
	'securepoll-gpg-receipt' => 'Agyamanak ti panagbutos mo.

No kayatmo, mabalin mo a taginayonen ti resibo a kas pamaneknek ti butos mo:

<pre>$1</pre>',
	'securepoll-thanks' => 'Agyamanak, ti butos mo ket nairehistron.',
	'securepoll-return' => 'Agsubli idiay $1.',
	'securepoll-encrypt-error' => 'Napaay ti panag-encrypt ti rehistro ti butos mo.
Ti butos mo ket saan pay a nairehistro!

$1',
	'securepoll-no-gpg-home' => 'Napaay ti panagaramid ti GPG a balay ti direktorio.',
	'securepoll-secret-gpg-error' => 'Biddut ti panagtungpal ti GPG.
Usaren ti $wgSecurePollShowErrorDetail=true; idiay LocalSettings.php ti agiparang ti adu pay a detalye.',
	'securepoll-full-gpg-error' => 'Biddut ti panagtungpal ti GPG:

Bilinen: $1

Biddut:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Dagiti tulbek ti GPG ket saan nga husto a naaramid.',
	'securepoll-gpg-parse-error' => 'Biddut ti panagibuksilan ti GPG a rimmuar.',
	'securepoll-no-decryption-key' => 'Awan ti naaramid decryption a tulbek.
Saan a madecrypt.',
	'securepoll-jump' => 'Mapan ka dita  pagbutosan a server',
	'securepoll-bad-ballot-submission' => 'Imbalido  ti butos mo: $1',
	'securepoll-unanswered-questions' => 'Masapul a sungbatam amin dagiti saludsod.',
	'securepoll-invalid-rank' => 'Imbalido a ranggo. Masapul nga ikkam dagiti kandidato iti ranggo a nagbaetan ti 1 ken 999.',
	'securepoll-unranked-options' => 'Adda dagiti pagpilian a saan a nairanggo.
Masapul nga ikkam amin dagiti pagpilian ti ranggo a nagbaetan ti 1 ken 999.',
	'securepoll-invalid-score' => 'Ti iskor ket masapul a numero a nagbaetan ti $1 ken $2.',
	'securepoll-unanswered-options' => 'Masapul nga agited ka ti sungbat para iti tunggal maysa a saludsod.',
	'securepoll-remote-auth-error' => 'Bidddut ti pinagala ti pakabilangam a pakaammo manipud idiay server.',
	'securepoll-remote-parse-error' => 'Biddut ti panagibuksilan ti pammalubos a sungbat manipud idiay server.',
	'securepoll-api-invalid-params' => 'Imbalido dagiti parametro.',
	'securepoll-api-no-user' => 'Awan ti agar-aramat a nabirukan nga addaan ti naited nga ID.',
	'securepoll-api-token-mismatch' => 'Ti seguridad a tandaan ket saan nga agpadpada, saan a makastrek.',
	'securepoll-not-logged-in' => 'Masapul a nakastrek ka tapno makabutos ka ditoy a panagbubutosan.',
	'securepoll-too-few-edits' => 'Pasensia, saan ka a makabutos. Masapul nga addaan ka ti $1 {{PLURAL:$1|urnos|ur-urnos}} ti agbutos iti daytoy a panagbubutosan, nakaaramid ka ti $2.',
	'securepoll-too-new' => 'Pasensia, saan ka a makabutos. Ti pakabilangam ket masapul a nakarehistro sakbayan idi $1 iti $3 ti agbutos iti daytoy a panagbubutosan, nakarehistro ka idi $2 iti $4.',
	'securepoll-blocked' => 'Pasensia, saan ka a makabutos iti daytoy a panagbubutosan no agdama ka a naserraan manipud ti pinagurnos.',
	'securepoll-blocked-centrally' => 'Pasensia, saan ka a makabutos iti daytoy a panagbubutosan ngamin ket naserraan ka iti $1 {{PLURAL:$1|a wiki|a dagiti wiki}}.',
	'securepoll-bot' => 'Pasensia, dagiti pakabilangan nga addan ti bandera a bot ket saan a mabalin nga agbutos iti daytoy a panagbubutosan.',
	'securepoll-not-in-group' => 'Dagiti kameng laeng iti "$1" a bunggoy ti makabutos iti daytoy a panagbubutosan.',
	'securepoll-not-in-list' => 'Pasensia, awan ka ditat naipilian a listaan kadagiti agar-aramat a malubosan nga agbutos iti daytoy a panagbubutosan.',
	'securepoll-list-title' => 'Ilista dagiti butos: $1',
	'securepoll-header-timestamp' => 'Oras',
	'securepoll-header-voter-name' => 'Nagan',
	'securepoll-header-voter-domain' => 'Pagturayan',
	'securepoll-header-ua' => 'Ahente ti agar-aramat',
	'securepoll-header-cookie-dup' => 'Duplikado',
	'securepoll-header-strike' => 'Ikkaten',
	'securepoll-header-details' => 'Dagiti detalye',
	'securepoll-strike-button' => 'Ikkaten',
	'securepoll-unstrike-button' => 'Isubli',
	'securepoll-strike-reason' => 'Rason:',
	'securepoll-strike-cancel' => 'Ukasen',
	'securepoll-strike-error' => 'Biddut ti panagaramid ti panag-ikkat/panagisubli: $1',
	'securepoll-strike-token-mismatch' => 'Napukaw ti gimong ti linaon',
	'securepoll-details-link' => 'Dagiti detalye',
	'securepoll-details-title' => 'Dagiti detalye ti butos: #$1',
	'securepoll-invalid-vote' => '"$1" ket saan nga umisu a butos nga  ID',
	'securepoll-header-voter-type' => 'Kita ti nagbutos',
	'securepoll-voter-properties' => 'Dagiti sanikua ti nagbutos',
	'securepoll-strike-log' => 'Listaan ti panag-ikkat',
	'securepoll-header-action' => 'Aramid',
	'securepoll-header-reason' => 'Rason',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Galietas duplikado dagiti agar-aramat',
	'securepoll-dump-title' => 'Ipakbo: $1',
	'securepoll-dump-no-crypt' => 'Awan ti naencrypt a nairehistro a panagbubutosan  a magun-od iti daytoy a panagbubutosan, ngamin ket ti panagbubutosan ket saan a naaramid nga agusar ti encrypsion.',
	'securepoll-dump-not-finished' => 'Dagiti naencrypt a rehistro ti panagbubutosan ket magun-od laeng kalpasan ti gibus a petsa ti $1 iti $2',
	'securepoll-dump-no-urandom' => 'Saan a maluktan /dev/urandom.
Tapno mataripatuen ti kinapribado ti nagbutos, dagiti naencrypt a rehistro ti panagbubutosan ket publiko a magun-od laeng no mayakar-yakar nga addaan ti nasalakniban a pugto a numero a waig.',
	'securepoll-urandom-not-supported' => 'Daytoy a server ket saan na a tapayaen ti panagaramid ti cryptographic a pugto a numero.
Tapno mataripatuen ti kinapribado ti nagbutos, ti naencrypt a rehistro ti panagbubutosan ket publiko a magun-od laeng no mayakar-yakar nga addaan ti nasalakniban  a pugto a numero a waig.',
	'securepoll-translate-title' => 'Ipatarus: $1',
	'securepoll-invalid-language' => 'Imbalido a kodigo ti pagsasao "$1"',
	'securepoll-submit-translate' => 'Pabaro',
	'securepoll-language-label' => 'Agpili ti pagsasao:',
	'securepoll-submit-select-lang' => 'Ipatarus',
	'securepoll-entry-text' => 'Dita baba ket listaan kadagiti pinagala.',
	'securepoll-header-title' => 'Nagan',
	'securepoll-header-start-date' => 'Petsa a mangrugi',
	'securepoll-header-end-date' => 'Lippasan a petsa',
	'securepoll-subpage-vote' => 'Agbutos',
	'securepoll-subpage-translate' => 'Ipatarus',
	'securepoll-subpage-list' => 'Listaan',
	'securepoll-subpage-dump' => 'Ipakbo',
	'securepoll-subpage-tally' => 'Tarkasan',
	'securepoll-tally-title' => 'Tarkasan: $1',
	'securepoll-tally-not-finished' => 'Pasensia, saan mo a mabalin a tarkasan ti panagbubutosan agingga ti kalpasan ti panagbutos.',
	'securepoll-can-decrypt' => 'Ti rehistro ti panagbubutosan ket naencrypt, ngem ti decryption a tulbek ket saan a magun-od.
Mabalin mo ti agpili a tarkasan dagiti nagbanagan nga addaan idiay database, wenno tarkasan dagiti naencrypted a nagbanagan manipud iti naipan a papeles.',
	'securepoll-tally-no-key' => 'Saan mo a mabalina tarkasan daytoy a panagbubutosan, ngamin ket dagiti butos ket naencrypted, ken ti decryption a tulbet ket saan a magun-od.',
	'securepoll-tally-local-legend' => 'Taarkasan dagiti naidulin a nagbanagan',
	'securepoll-tally-local-submit' => 'Agaramid ti tarkasan',
	'securepoll-tally-upload-legend' => 'Agipan ti naencrypted a naipakbo',
	'securepoll-tally-upload-submit' => 'Agaramid ti tarkasan',
	'securepoll-tally-error' => 'Biddut ti panagipatarus ti rehistro ti butos, saan a napaadda ti tarkasan.',
	'securepoll-no-upload' => 'Awan ti naipan a papeles, saan a matarkasan dagiti nagbanagan.',
	'securepoll-dump-corrupt' => 'Ti naipakbo a papeles ket naibalitungeg ken saan a maipatuloy.',
	'securepoll-tally-upload-error' => 'Biddut ti panagtarkasan ti pinakbo a papeles: $1',
	'securepoll-ranks' => 'Pangileppas a ranngo',
	'securepoll-average-score' => 'Pagtengngaan nga iskor',
	'securepoll-round' => 'Nagbukel $1',
	'securepoll-spoilt' => '(Nadadael)',
	'securepoll-exhausted' => '(Naibusen)',
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
	'securepoll-header-reason' => 'Motivo',
	'securepoll-language-label' => 'Selektez linguo:',
	'securepoll-header-title' => 'Nomo',
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
 * @author Beta16
 * @author BrokenArrow
 * @author Capmo
 * @author Darth Kule
 * @author Massimiliano Lincetto
 * @author Melos
 * @author Nemo bis
 * @author Pietrodn
 * @author Stefano-c
 * @author Vituzzu
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
	'securepoll-invalid-score' => 'Il voto deve essere un numero compreso tra $1 e $2.',
	'securepoll-unanswered-options' => 'Devi rispondere a tutte le domande.',
	'securepoll-remote-auth-error' => 'Errore durante il recupero delle informazioni sul tuo account dal server.',
	'securepoll-remote-parse-error' => "Errore nell'interpretare la risposta di autorizzazione dal server.",
	'securepoll-api-invalid-params' => 'Parametri non validi.',
	'securepoll-api-no-user' => "Non è stato trovato alcun utente con l'ID fornito.",
	'securepoll-api-token-mismatch' => 'I token di sicurezza non coincidono, non puoi entrare.',
	'securepoll-not-logged-in' => "È necessario eseguire l'accesso per votare in queste elezioni",
	'securepoll-too-few-edits' => 'Spiacente, non puoi votare. Devi aver effettuato almeno $1 {{PLURAL:$1|modifica|modifiche}} per votare in questa elezione, tu ne hai fatte $2.',
	'securepoll-too-new' => 'Spiacente ma non puoi votare. Per farlo devi essere esserti registrato prima del $1, $3 mentre invece ti sei registrato il $2 alle $4.',
	'securepoll-blocked' => 'Spiacente, non puoi votare in questa elezione se sei stato bloccato dalla modifica.',
	'securepoll-blocked-centrally' => "Spiacente ma non puoi votare in quest'elezione poiché sei bloccato su almeno $1 {{PLURAL:$1|wiki|wiki}}.",
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
	'securepoll-round' => 'Turno numero $1.',
	'securepoll-spoilt' => '(imbarazzante)',
	'securepoll-exhausted' => '(Esaurito)',
);

/** Japanese (日本語)
 * @author Akaniji
 * @author Aotake
 * @author Fryed-peach
 * @author Miya
 * @author Schu
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
	'securepoll-too-new' => '申し訳ありませんが、あなたは投票できません。この選挙で投票するには、$1 $3 より前にアカウント登録されている必要がありますが、あなたは、$2 $4 にアカウント登録しています。',
	'securepoll-blocked' => '申し訳ありませんが、あなたは投稿ブロックを受けているためこの投票に参加できません。',
	'securepoll-blocked-centrally' => '申し訳ありませんが、少なくとも$1 {{PLURAL:$1|ウィキ|ウィキ}}でブロックされているとして、あなたはこの選挙で投票することはできません。',
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
	'securepoll-strike-reason' => '理由：',
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
	'securepoll-round' => '第$1回',
	'securepoll-spoilt' => '(無効票)',
	'securepoll-exhausted' => '(白票)',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Èkstènsi tumrap pamilihan lan survé',
	'securepoll-invalid-page' => 'Anak kaca ora sah "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Tumindak punika namung saged dipunayahi déning pangurus.',
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
	'securepoll-encrypt-error' => 'Gagal nyandi cathetan swanten (vote) panjenengan.
Swanten panjenengan dèrèng kacathet!

$1',
	'securepoll-no-gpg-home' => "Boten saged damel GPG ''home directory''",
	'securepoll-secret-gpg-error' => 'Gagal nglampahaken GPG.
Ginakaken $wgSecurePollShowErrorDetail=true; ing LocalSettings.php kanggé nampilaken princén langkung pepak.',
	'securepoll-full-gpg-error' => 'Gagal nglampahaken GPG.

Printah:$1

Kasalahan:
<pre>$2</pre>',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author David1010
 * @author Dawid Deutschland
 * @author ITshnik
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'securepoll' => 'უსაფრთხო კეჭისყრა',
	'securepoll-desc' => 'არჩევნებისა და გამოკითხვის გახანგრძლივება',
	'securepoll-invalid-page' => 'არასწორი ქვეგვერდი „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'თქვენ უნდა იყოთ საარჩევნო ადმინისტრატორი, რომ შეასრულოთ ეს ქმედება.',
	'securepoll-too-few-params' => 'არ არის საკმარისი ქვეკატეგორიების პარამეტრები (არასწორი ბმული).',
	'securepoll-invalid-election' => '"$1" არ წარმოადგენს არჩევნებისათვის დასაშვებ იდენტიფიკატორს.',
	'securepoll-welcome' => '<strong>კეთილი იყოს თქვენი მობრძანება $1!</strong>',
	'securepoll-not-started' => 'ხმიც მიცემა ჯერ არ დაწყებულა.
დაიწყება $3-ის $2-ზე.',
	'securepoll-finished' => 'ეს არჩევნები დასრულებულია, თქვენ აღარ შეგიძლიათ ხმის მიცემა.',
	'securepoll-not-qualified' => 'თქვენ არ შეგიძლიათ ამ არჩევნებში ხმის მიცემა: $1',
	'securepoll-change-disallowed' => 'თქვენ უკვე გავქვთ ხმა მიცემული ამ არჩევნებში. 
ვწუხვართ, მაგრამ თქვენ ვეღარ მისცემთ ხმას მეორედ.',
	'securepoll-change-allowed' => '<strong>შენიშვნა: თქვენ უკვე გაქვთ მიცემული ხმა ამ არჩევნებში.</strong> თქვენ შეგიძლიათ შეცვალოთ თქვენი არჩევანი ქვემოთ მოცემული ფორმის შევსებით. გაითვალისწინეთ, რომ თუ თქვენ ასე მოიქცევით, თქვენი პირვანდელი არჩევანი გაუქმდება.',
	'securepoll-submit' => 'ხმის მიცემა',
	'securepoll-thanks' => 'გმადლობთ, თქვენი ხმა მიღებულია.',
	'securepoll-return' => 'დაბრუნება $1–ზე',
	'securepoll-encrypt-error' => 'თქვენი ხმის დაშიფრვისას მოხდა შეცდომა.
თქვენი ხმა ვერ შეინახა!

$1',
	'securepoll-no-gpg-home' => 'შეუძლებელია GPG საშინაო კატალოგის შექმნა.',
	'securepoll-secret-gpg-error' => 'შეცდომა GPG-ის შესრულებისას.
$wgSecurePollShowErrorDetail=true; LocalSettings.php-ში დამატება მეტი დეტალის სანახავად.',
	'securepoll-full-gpg-error' => 'შეცდომა GPG შესრულებისას:

ბრძანება: $1

შეცდომა:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-კოდი არასწორადაა კონფიგურირებული.',
	'securepoll-no-decryption-key' => 'დეშიფრაციის კოდი კონფიგურირებული არაა.
დეშიფრაცია შეუძლებელია.',
	'securepoll-jump' => 'ხმის მიცემის სერვერზე გადასვლა',
	'securepoll-bad-ballot-submission' => 'თქვენი ხმა ძალადაკარგულია: $1',
	'securepoll-unanswered-questions' => 'თქვენ უნდა უპასუხოთ ყველა შეკითხვას.',
	'securepoll-invalid-rank' => 'არასწორი ადგილი. თქვენ უნდა მიუთითოთ კანდიდატის ადგილი 1-დან 999-მდე.',
	'securepoll-invalid-score' => 'ანგარიში უნდა იყოს რიცხვ $1-სა და $2-ს შორის.',
	'securepoll-unanswered-options' => 'თქვენ უნდა გასცეთ პასუხი ყოველ კითხვაზე.',
	'securepoll-remote-auth-error' => 'შეცდომა ანგარიშზე ინფორმაციის მიღებისას სერვერიდან.',
	'securepoll-remote-parse-error' => 'შეცდომა სერვერის ავტორიზაციის პასუხის ინტერპრეტირებისას.',
	'securepoll-api-invalid-params' => 'არასწორი პარამეტრები.',
	'securepoll-api-no-user' => 'მომხმარებელი მითითებული იდენტიფიკატორით ვერ მოიძებნა.',
	'securepoll-not-logged-in' => 'ხმის მისაცემად თქვენ უნდა შეხვიდეთ სისტემაში',
	'securepoll-too-few-edits' => 'უკაცრავად, თქვენ არ შეგიძლიათ ხმის მიცემა. თქვენ განხორციელებული უნდა გქონდეთ მინიმუმ $1 {{PLURAL:$1|რედაქტირება|რედაქტირება}} ამ არჩევნებში ხმის მისაცემად, თქვენ გაქვთ $2.',
	'securepoll-blocked' => 'უკაცრავად, თქვენ არ შეგიძლიათ ხმის მიცემა ამ არჩევნებში, თუკი თქვენ ამჟამად დაბლოკილი ხართ.',
	'securepoll-bot' => 'უკაცრავად, ანგარიშებს, ბოტის სტატუსით, არ შეუძლიათ ამ არჩევნებში ხმის მიცემა.',
	'securepoll-not-in-group' => 'მხოლოდ ჯგუფ "$1"-ის წევრებს შეუძლიათ ამ არჩევნებში ხმის მიცემა.',
	'securepoll-not-in-list' => 'სამწუხაროდ თქვენ არ ხართ იმ მომხმარებელთა სიაში, რომლებსაც ამ არჩევნებში მონაწილეობა შეუძლიათ.',
	'securepoll-list-title' => 'ხმების სია: $1',
	'securepoll-header-timestamp' => 'დრო',
	'securepoll-header-voter-name' => 'სახელი',
	'securepoll-header-voter-domain' => 'დომენი',
	'securepoll-header-ua' => 'მომხმარებლის აგენტი',
	'securepoll-header-cookie-dup' => 'დუბლიკატი',
	'securepoll-header-strike' => 'გადახაზვა',
	'securepoll-header-details' => 'დეტალები',
	'securepoll-strike-button' => 'გადახაზვა',
	'securepoll-strike-reason' => 'მიზეზი:',
	'securepoll-strike-cancel' => 'გაუქმება',
	'securepoll-strike-token-mismatch' => 'სესიის მონაცემების დაკარგვა',
	'securepoll-details-link' => 'დეტალები',
	'securepoll-details-title' => 'ხმის მიცემის დეტალები: #$1',
	'securepoll-invalid-vote' => '"$1" არ წარმოადგენს ხმის მიცემისთვის დასაშვებ იდენტიფიკატორს',
	'securepoll-header-voter-type' => 'ხმის მიმცემის ტიპი',
	'securepoll-header-url' => 'URL',
	'securepoll-voter-properties' => 'ამომრჩეველთა თვისებები',
	'securepoll-header-action' => 'მოქმედება',
	'securepoll-header-reason' => 'მიზეზი',
	'securepoll-header-admin' => 'ადმინი',
	'securepoll-cookie-dup-list' => 'მომხმარებლები, რომლებმაც ორჯერ მისცეს ხმა',
	'securepoll-dump-title' => 'დამპი: $1',
	'securepoll-translate-title' => 'თარგმნა: $1',
	'securepoll-invalid-language' => 'არასწორი ენობრივი კოდი «$1»',
	'securepoll-submit-translate' => 'განახლება',
	'securepoll-language-label' => 'ენის არჩევა:',
	'securepoll-submit-select-lang' => 'თარგმნა',
	'securepoll-entry-text' => 'ქვემოთ წარმოდგენილია კენჭისყრათა სია.',
	'securepoll-header-title' => 'სახელი',
	'securepoll-header-start-date' => 'დაწყების თარიღი',
	'securepoll-header-end-date' => 'დასრულების თარიღი',
	'securepoll-subpage-vote' => 'ხმის მიცემა',
	'securepoll-subpage-translate' => 'თარგმნა',
	'securepoll-subpage-list' => 'სია',
	'securepoll-subpage-dump' => 'დამპი',
	'securepoll-subpage-tally' => 'დათვლა',
	'securepoll-tally-title' => 'დათვლა: $1',
	'securepoll-tally-not-finished' => 'ბოდიში, მაგრამ შედეგი ჩაიწერება მხოლოდ კენჭისყრის დასრულებისას.',
	'securepoll-can-decrypt' => 'ხმის ჩანაწერი ჩაიშიფრა, თუმცა არსებობს შიფრის მოხსნის გასაღები.
თქვენ შეგიძლიათ აირჩიოთ ან ამჟამინდელი ხმებისდათვლა, ან ჩაშიფრული ხმების დათვლა ატვირთული ფაილიდან.',
	'securepoll-tally-no-key' => 'თქვენ ვერ დათვლით ამ არჩევნების შედეგებს, რადგანაც ისინი ჩაიშიფრა, ხოლო გასაღები არ არის მითითებული.',
	'securepoll-tally-local-legend' => 'შენახული რეზულტატების დათვლა',
	'securepoll-tally-local-submit' => 'დათვლის წარმოება',
	'securepoll-tally-upload-legend' => 'ატვირთეთ ჩაშიფრული დამპი',
	'securepoll-tally-upload-submit' => 'დათვლის წარმოება',
	'securepoll-tally-error' => 'ხმის ინტერპრიტაციის შეცდომა, კენჭისყრის დათვლა ვერ მოხერხდა.',
	'securepoll-no-upload' => 'ფილტრი არ ჩატვირთულა, შეუძლებელია ხმების დათვლა.',
	'securepoll-dump-corrupt' => 'დამპ ფაილი დაზიანებულია და ვერ მოხერხდება მისი გაანალიზება.',
	'securepoll-tally-upload-error' => 'შეცდომა დამპ ფაილთან სინქრონიზაციისას: $1',
	'securepoll-pairwise-victories' => 'მოგებათა ტაბულა',
	'securepoll-strength-matrix' => 'გზის სიმძლავრის მატრიცა',
	'securepoll-ranks' => 'საბოლოო ადგილები',
	'securepoll-average-score' => 'საშუალო შედეგი',
	'securepoll-spoilt' => '(არასწორი)',
	'securepoll-exhausted' => '(დასრულდა)',
);

/** Khowar (کھوار)
 * @author Rachitrali
 */
$messages['khw'] = array(
	'securepoll-gpg-receipt' => 'رائےدہندگیو بچے شکریہ.

تو درج ذیل رسیدو تان رائےدہندگیو ثبوتو طورا لاکھیکو بوس:

<pre>$1</pre>',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'securepoll' => 'បោះ​ឆ្នោត​សុវត្ថិភាព​ (SecurePoll)',
	'securepoll-need-admin' => 'អ្នក​ចាំបាច់ត្រូវមានមុខងារ​ជា​អ្នកអភិបាល​ការបោះឆ្នោតដើម្បី​អនុវត្ត​សកម្មភាពនេះ​។',
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
	'securepoll-invalid-language' => 'កូដភាសា "$1" មិនត្រឹមត្រូវ',
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
	'securepoll-strike-cancel' => 'ರದ್ದು ಮಾಡು',
	'securepoll-header-reason' => 'ಕಾರಣ',
	'securepoll-header-title' => 'ಹೆಸರು',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Freebiekr
 * @author Gjue
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
	'securepoll-return' => '$1(으)로 돌아가기',
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
	'securepoll-too-new' => '미안하지만, 당신은 투표할 수 없습니다. 이 선거에서 투표하려면 $1  $3 이전에 당신의 계정이 등록되어 있어야 합니다. 당신은 $2 $4에 계정을 등록하였습니다.',
	'securepoll-blocked' => '죄송하지만, 귀하의 계정은 차단당한 상태이므로 이 선거에 투표하실 수 없습니다.',
	'securepoll-blocked-centrally' => '죄송합니다. 귀하는 $1개 이상의 위키에서 차단되었기 때문에 이 선거에 투표할 수 없습니다.',
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
	'securepoll-round' => '약 $1',
	'securepoll-spoilt' => '(투표권 무효)',
	'securepoll-exhausted' => '(투표권 만료)',
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

/** Colognian (Ripoarisch)
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
	'securepoll-too-few-edits' => 'Schadt: Do kanns diß Mol nit affshtemme. En dämm Fall mööts De ald {{PLURAL:$1|einmol|$1 Mol|övverhoup noch nie}} en Sigg em Wiki jeändert han, Do häß ävver {{PLURAL:$2|blooß eimol|blooß $2 Mol|övverhoup noch nie}} en Sigg em Wiki jeändert.',
	'securepoll-too-new' => 'Schahdt: Do kanns diß Mol nit affshtemme. Do mööts Desch ald vör dem $1öm $3 Uhr heh aanjemöldt han, et es ävver der $2 öm $4 Uhr jewääse.',
	'securepoll-blocked' => 'Schahdt: Do kanns diß Mol nit affshtemme, weil De jraadt för et Ändere aam Wiki jeshperrt beß.',
	'securepoll-blocked-centrally' => 'Schahdt: Do kanns diß Mol nit affshtemme, weil De jraadt för et Ändere en {{PLURAL:$1|einem Wiki udder mih|$1 udder mih Wikis|keinem Wiki}} jeshperrt beß.',
	'securepoll-bot' => 'Hee en dä Afshtemmung kann bloß met metmaache, wä keine Bots es.',
	'securepoll-not-in-group' => 'Schadt: Do kanns diß Mol nit affshtemme. Bloß de Metmaacher en dä {{NS:Category}} $1 künne hee en Shtemm afjevve!',
	'securepoll-not-in-list' => 'Schadt: Do kanns diß Mol nit affshtemme. De beß nit en de su jenannte Wähler_Leß met de Metmaacher, die hee afshtemme dörve.',
	'securepoll-list-title' => 'Shtemme Opleßte: $1',
	'securepoll-header-timestamp' => 'Zick',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domähn',
	'securepoll-header-ip' => '<code lang="en">IP</code>-Addreß',
	'securepoll-header-xff' => '<i lang="en">XFF</i>',
	'securepoll-header-ua' => 'Däm Metmaacher singe Brauser',
	'securepoll-header-token-match' => '<i lang="en">CSRF</i>',
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
	'securepoll-header-url' => '<i lang="en">URL</i>',
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
	'securepoll-urandom-not-supported' => 'Hee dä ẞööver kann kein Zohfallszahle för et Verschößele maache.
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
	'securepoll-round' => 'Der $1-te Rötsch',
	'securepoll-spoilt' => '(onjöltesch)',
	'securepoll-exhausted' => '(aam Engk)',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'securepoll-header-timestamp' => 'Dem',
	'securepoll-header-voter-name' => 'Nav',
	'securepoll-strike-reason' => 'Sedem:',
	'securepoll-strike-cancel' => 'Betal bike',
	'securepoll-header-reason' => 'Sedem',
	'securepoll-language-label' => 'Ziman bijêre:',
	'securepoll-submit-select-lang' => 'Wergerîne',
	'securepoll-header-title' => 'Nav',
	'securepoll-subpage-vote' => 'Dengdan',
	'securepoll-subpage-translate' => 'Wergerîne',
	'securepoll-subpage-list' => 'Lîste',
);

/** Latin (Latina)
 * @author Tutleman
 */
$messages['la'] = array(
	'securepoll-header-title' => 'Nomen',
	'securepoll-header-start-date' => 'Satus diem',
	'securepoll-header-end-date' => 'Ultima diem',
	'securepoll-subpage-vote' => 'Suffragium Fero',
	'securepoll-subpage-translate' => 'Traducere',
	'securepoll-subpage-list' => 'Index',
	'securepoll-subpage-dump' => 'Effundite',
	'securepoll-subpage-tally' => 'Numera',
	'securepoll-tally-title' => 'Numerat: $1',
	'securepoll-tally-not-finished' => 'Paenitet, tu ne posse numerare electio quamdiu suffragium non est finis.',
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
	'securepoll-too-new' => 'Pardon, Dir däerft net ofstëmmen. Äre Benotzerkont hätt misse virum $1 ëm $3 registréiert si fir bäi dëse Walen ofstëmmen ze däerfen. Dir sidd zënter dem $2 ëm $4 registréiert.',
	'securepoll-blocked' => 'Pardon, Dir kënnt net bäi dëse Walen ofstëmmen wann dir elo fir Ännerunge gespaart sidd.',
	'securepoll-blocked-centrally' => "Pardon, Dir däerft bäi dëse Walen net ofstëmme well Dir an op d'mannst $1 {{PLURAL:$1|Wiki|Wikië}} gespaart sidd.",
	'securepoll-bot' => 'Pardon, Benotzerkonte matt engem Bottefändel (bot flag) däerfe bäi dëse Walen net ofstëmmen.',
	'securepoll-not-in-group' => 'Nëmme Membere vum Grupp $1 kënne bäi dëse Walen ofstëmmen.',
	'securepoll-not-in-list' => 'Pardon, awer Dir stitt op der Lëscht vun de Benotzer déi autoriséiert si fir bäi dëse Walen ofzestëmmen.',
	'securepoll-list-title' => 'Lëscht vun de Stëmmen: $1',
	'securepoll-header-timestamp' => 'Zäit',
	'securepoll-header-voter-name' => 'Numm',
	'securepoll-header-voter-domain' => 'Domaine',
	'securepoll-header-ua' => 'Browser',
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
	'securepoll-entry-text' => "Ënnendrënner ass d'Lëscht vun den Ëmfroen.",
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
	'securepoll-round' => '$1. Tour',
	'securepoll-spoilt' => '(Net valabel)',
	'securepoll-exhausted' => '(Eriwwer)',
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
	'securepoll-need-admin' => "Doe mós 'ne stömmingbeheerder zeen óm dees hanjeling te moge oetveure.",
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
	'securepoll-invalid-rank' => 'Ongeldige rang.
Doe mós de kandidate n rang gaeve tusse 1 en 999.',
	'securepoll-unranked-options' => "Sommige stummeugelikhede höbbe gein rang.
Doe mos alle meugelikhede 'n rang gaeve tösse 1 en 999.",
	'securepoll-invalid-score' => 'De score mot e getal tusse $1 en $2 zeen.',
	'securepoll-unanswered-options' => 'Doe mos eder vraog beantjwaorde.',
	'securepoll-remote-auth-error' => "d'r Is 'n fout opgetraoje bie 't ophaole van dien gebroekersinformatie van de server.",
	'securepoll-remote-parse-error' => "d'r Is 'n fout opgetraoje bie 't interpretere van 't antjwaord van de server.",
	'securepoll-api-invalid-params' => 'Óngeldige paramaeters.',
	'securepoll-api-no-user' => "d'r Is geine gebroeker gevónje mit 't opgegaeve ID.",
	'securepoll-api-token-mismatch' => 'Beveiligingstoke kömp neet euverein, inlogge is neet meugelik.',
	'securepoll-not-logged-in' => 'Doe mós aanmelde óm aan dees sjtömming deil te nömme',
	'securepoll-too-few-edits' => "Sorry, doe kins neet deilnömme aan de sjtömming. Doe mós temisnte $1 {{PLURAL:$1|bewèrking|bewèrkinger}} höbbe gemaak óm te kinne sjtömme in dees verkeziging en doe höbs d'r $2.",
	'securepoll-too-new' => 'Doe kins neet deilnömme aan dees stömming. Doe mós veur $1 óm $3 geregistreerd zeen óm det te kinne, meh doe woors det óp $2 óm $4.',
	'securepoll-blocked' => 'Sorry, doe kins neet deilnömme aan de sjtömming ómdet se geblokkeerd bös.',
	'securepoll-blocked-centrally' => "Doe kins neet deilnömme aan dees stömming ómdes se geblok bös óp minstes $1 {{PLURAL:$1|wiki|wiki's}}.",
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
	'securepoll-strike-reason' => 'Reeje:',
	'securepoll-strike-cancel' => 'Braek aaf',
	'securepoll-strike-error' => "Fout bie 't (neet) doorhaole: $1",
	'securepoll-strike-token-mismatch' => 'Sessiegegaeves zeen verlaore gegange',
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
	'securepoll-urandom-not-supported' => "Deze server beet gein ongersteuning veur 't versleuteld aanmake van willekeurige getalle.
Om de anonimiteit van stömmers te handjhave, zeen de versleutelde stömresultate pas besjikbaar es ze zeen herordend via 'n veilige reeks van willekeurige getalle.",
	'securepoll-translate-title' => 'Vertaol: $1',
	'securepoll-invalid-language' => 'Óngeljige taolcode "$1"',
	'securepoll-submit-translate' => 'Wèrk bie',
	'securepoll-language-label' => 'Selecteer taol:',
	'securepoll-submit-select-lang' => 'Vertaol',
	'securepoll-entry-text' => "Hierónger is 'n stömmingslies.",
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
	'securepoll-can-decrypt' => "De resultate van de stömming zeen versleuteld, mer de coderingssleutel is besjikbaar.
Doe kins de in de database besjikbare resultate telle, of de resultate oet 'n bestandjsupload telle.",
	'securepoll-tally-no-key' => 'De kins gein telling uutveure veur dees stumming, omdet de stumme versleuteld zeen en de sleutel neet besjikbaar is.',
	'securepoll-tally-local-legend' => 'Ópgeslage resultare',
	'securepoll-tally-local-submit' => 'Veur telling oet',
	'securepoll-tally-upload-legend' => 'Laaj versleutelde dump óp',
	'securepoll-tally-upload-submit' => 'Veur telling oet',
	'securepoll-tally-error' => 'Fout bie stömmingsresultate-interpretaie. Kèn gein tèlling oetveure.',
	'securepoll-no-upload' => "d'r Is gei besjtandj opgelaje, resultate kinne neet geteld waere.",
	'securepoll-dump-corrupt' => 'Dumpbestandj is besjadig en kin neet verwerk waere.',
	'securepoll-tally-upload-error' => 'Fout bie tellen oete dump: $1',
	'securepoll-pairwise-victories' => 'Paarsgewies euverwinningsmatrix',
	'securepoll-strength-matrix' => 'Padgestèrk matrix',
	'securepoll-ranks' => 'Definitief ranksjikking',
	'securepoll-average-score' => 'Gemiddeldje skore',
	'securepoll-round' => 'Rönj $1',
	'securepoll-spoilt' => '(Óngeljig)',
	'securepoll-exhausted' => '(Verloupe)',
);

/** Lithuanian (Lietuvių)
 * @author Homo
 * @author Matasg
 * @author Perkunas
 */
$messages['lt'] = array(
	'securepoll' => 'Saugus balsavimas',
	'securepoll-desc' => 'Priemonė rinkimams ir apklausoms',
	'securepoll-invalid-page' => 'Netinkamas subpuslapis "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Jei norite atlikti šį veiksmą, Jums reikia būti rinkimų administratoriumi.',
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
	'securepoll-invalid-rank' => 'Neteisingas įvertinimas. Kandidatų įvertinimas turi būti tarp 1 ir 999.',
	'securepoll-unranked-options' => 'Kai kurios parinktys nebuvo įvertintos.
Visoms parinktims turite skirti įvertinimą tarp 1 ir 999.',
	'securepoll-invalid-score' => 'Įvertinimas turi būti skaičius tarp $1 ir $2.',
	'securepoll-unanswered-options' => 'Jūs turite įvertinti kiekvieną klausimą.',
	'securepoll-remote-auth-error' => 'Įvyko klaida pristatant jūsų paskyros informaciją iš serverio.',
	'securepoll-remote-parse-error' => 'Klaida interpretuojant leidimo atsakymą iš serverio.',
	'securepoll-api-invalid-params' => 'Netinkami parametrai',
	'securepoll-api-no-user' => 'Nerastas naudotojas su duotu ID.',
	'securepoll-api-token-mismatch' => 'Saugos žymės nesutampa, negalite prisijungti',
	'securepoll-not-logged-in' => 'Jūs turite prisijungti, norėdami balsuoti šiuose rinkimuose',
	'securepoll-too-few-edits' => 'Atsiprašome, Jūs negalite balsuoti. Jūs privalote atlikti bent $1 {{PLURAL:$1|redagavimą|redagavimų}}, norėdami balsuoti šiuose rinkimuose. Jūs atlikote $2.',
	'securepoll-too-new' => 'Atsiprašome, Jūs negalite balsuoti. Jei norite balsuoti šiuose rinkimuose, Jūsų sąskaita turi būti sukurta iki $1, tačiau Jūsų sąskaita yra sukurta $2.',
	'securepoll-blocked' => 'Atsiprašome, Jūs negalite balsuoti šiuose rinkimuose jei dabar esate užblokuotas.',
	'securepoll-blocked-centrally' => 'Atsiprašome, Jūs negalite balsuoti šiuose rinkimuose, jei esate blokuotas $1 {{PLURAL:$1|wiki-projekte|wiki-projektuose}} ar daugiau.',
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
	'securepoll-strike-token-mismatch' => 'Prarasti sesijos duomenys',
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
	'securepoll-urandom-not-supported' => 'Šis serveris nepalaiko šifruotų atsitiktinių skaičių generavimo.
Kad užtikrintume balsuojančiųjų slaptumą, šifruoti rinkimų rezultatai viešai pateikiami tik po to, kai jie sumaišomi su saugia atsitiktinių skaičių seka.',
	'securepoll-translate-title' => 'Išversti: $1',
	'securepoll-invalid-language' => 'Neleistinas kalbos kodas "$1"',
	'securepoll-submit-translate' => 'Atnaujinti',
	'securepoll-language-label' => 'Pasirinkite kalbą:',
	'securepoll-submit-select-lang' => 'Išversti',
	'securepoll-entry-text' => 'Žemiau pateikiamas balsavimų sąrašas.',
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
	'securepoll-dump-corrupt' => 'Iškelties failas nekorektiškas, todėl negali būti apdorotas.',
	'securepoll-tally-upload-error' => 'Klaida kuriant iškelties failą: $1',
	'securepoll-pairwise-victories' => 'Porinės pergalės matrica',
	'securepoll-strength-matrix' => 'Kelio stiprumo matrica',
	'securepoll-ranks' => 'Galutinis įvertinimas',
	'securepoll-average-score' => 'Vidutinis rezultatas',
	'securepoll-round' => 'Turas $1',
	'securepoll-spoilt' => '(Sugadinta)',
	'securepoll-exhausted' => '(Išnaudota)',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'securepoll-submit-translate' => 'Atjaunynuot',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 * @author Papuass
 */
$messages['lv'] = array(
	'securepoll-desc' => 'Paplašinājums vēlēšanām un aptaujām',
	'securepoll-invalid-page' => 'Nederīga apakšlapa "<nowiki>$1</nowiki>"',
	'securepoll-finished' => 'Šīs vēlēšanas ir beigušās, Jūs vars nedrīkstat balsot.',
	'securepoll-submit' => 'Iesniegt balsojumu',
	'securepoll-thanks' => 'Paldies, jūsu balsojums tika reģistrēts.',
	'securepoll-return' => 'Atgriezties uz $1',
	'securepoll-unanswered-questions' => 'Tev ir jāatbild uz visiem jautājumiem.',
	'securepoll-api-invalid-params' => 'Nederīgi parametri.',
	'securepoll-header-timestamp' => 'Laiks',
	'securepoll-header-voter-name' => 'Vārds',
	'securepoll-header-voter-domain' => 'Domēns',
	'securepoll-header-ua' => 'Lietotāja aģents',
	'securepoll-strike-reason' => 'Iemesls:',
	'securepoll-strike-cancel' => 'Atcelt',
	'securepoll-strike-token-mismatch' => 'Sesijas dati zaudēti',
	'securepoll-header-action' => 'Darbība',
	'securepoll-header-reason' => 'Iemesls',
	'securepoll-translate-title' => 'Tulkot: $1',
	'securepoll-invalid-language' => 'Nederīgs valodas kods "$1"',
	'securepoll-submit-translate' => 'Atjaunināt',
	'securepoll-language-label' => 'Izvēlēties valodu:',
	'securepoll-submit-select-lang' => 'Tulkot',
	'securepoll-entry-text' => 'Saraksts ar balsojumiem ir apakšā.',
	'securepoll-header-title' => 'Nosaukums',
	'securepoll-header-start-date' => 'Sākuma datums',
	'securepoll-header-end-date' => 'Beigu datums',
	'securepoll-subpage-vote' => 'Balsot',
	'securepoll-subpage-translate' => 'Tulkot',
	'securepoll-subpage-list' => 'Saraksts',
	'securepoll-average-score' => 'Vidējais rezultāts',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 * @author Rancher
 */
$messages['mk'] = array(
	'securepoll' => 'БезбедноГласање',
	'securepoll-desc' => 'Додаток за избори и анкети',
	'securepoll-invalid-page' => 'Неважечка потстраница „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Треба да бидете изборен администратор за да можете да го сторите тоа.',
	'securepoll-too-few-params' => 'Нема доволно параметри за потстраници (неважечка врска).',
	'securepoll-invalid-election' => '„$1“ не претставува важечка назнака.',
	'securepoll-welcome' => '<strong>Добредојдовте $1!</strong>',
	'securepoll-not-started' => 'Изборите сè уште не се започнати.
Предвидено е да започнат на $2 во $3 ч.',
	'securepoll-finished' => 'Изборите завршија - повеќе не можете да гласате.',
	'securepoll-not-qualified' => 'Не сте квалификувани да гласате на овие избори: $1',
	'securepoll-change-disallowed' => 'Веќе имате гласано на овие избори.
Жалиме, но не ви е дозволено да гласате повторно.',
	'securepoll-change-allowed' => '<strong>Напомена: На овие избори сте гласале претходно.</strong>
Можете да го промените вашиот глас со тоа што ќе го пополните долунаведениот образец.
Имајте предвид дека ако го сторите тоа, вашиот првичен глас ќе биде поништен.',
	'securepoll-submit' => 'Поднеси глас',
	'securepoll-gpg-receipt' => 'Ви благодариме што гласавте.

Доколку сакате, можете да ја задржите оваа потврда како доказ дека сте гласале:

<pre>$1</pre>',
	'securepoll-thanks' => 'Ви благодариме, вашиот глас е заведен.',
	'securepoll-return' => 'Назад на $1',
	'securepoll-encrypt-error' => 'Не можев да го шифрирам вашиот гласачки запис.
Вашиот глас не беше регистриран!

$1',
	'securepoll-no-gpg-home' => 'Не можам да создадам GPG именик.',
	'securepoll-secret-gpg-error' => 'Грешка при извршување на GPG.
Поставете го $wgSecurePollShowErrorDetail=true; во LocalSettings.php за да добиете повеќе подробности.',
	'securepoll-full-gpg-error' => 'Грешка при извршување на GPG:

Наредба: $1

Грешка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-клучевите се погрешно наместени.',
	'securepoll-gpg-parse-error' => 'Грешка при толкувањето на излезните информации за GPG.',
	'securepoll-no-decryption-key' => 'Не е поставен клуч за дешифрирање.
Не можам да дешифрирам.',
	'securepoll-jump' => 'Оди на опслужувачот за гласање',
	'securepoll-bad-ballot-submission' => 'Вашиот глас е неважечки: $1',
	'securepoll-unanswered-questions' => 'Морате да одговорите на сите прашања.',
	'securepoll-invalid-rank' => 'Погрешен ранг. Кандидадите морате да ги рангирате со бројка помеѓу 1 и 999.',
	'securepoll-unranked-options' => 'Некои избори не беа рангирани.
На сите избори мора да им доделите ранг помеѓу 1 и 999.',
	'securepoll-invalid-score' => 'Оцената мора да биде број од $1 до $2.',
	'securepoll-unanswered-options' => 'Мора да дадете одговор на секое прашање.',
	'securepoll-remote-auth-error' => 'Грешка при преземање на информациите за вашата сметка од опслужувачот.',
	'securepoll-remote-parse-error' => 'Грешка при толкувањето на одговорот при барањето на дозвола за пристап од опслужувачот.',
	'securepoll-api-invalid-params' => 'Неважечки параметри.',
	'securepoll-api-no-user' => 'Не бепе пронајден корисник со зададената назнака.',
	'securepoll-api-token-mismatch' => 'Не се совпаѓаат безбедносните кодови, не можам да ве најавам.',
	'securepoll-not-logged-in' => 'Морате да сте најавени за да гласате',
	'securepoll-too-few-edits' => 'Жалиме, но не можете да гласате. Треба да имате барем $1 {{PLURAL:$1|уредување|уредувања}} за да можете да гласате, а вие имате $2.',
	'securepoll-too-new' => 'Нажалост, не можете да гласате. За да гласате, сметката треба да ви е регистрирана пред $1 во $3, а вие сте ја регистрирале на $2 во $4.',
	'securepoll-blocked' => 'Жалиме, но немате право да гласате ако сте моментално блокирани од уредување.',
	'securepoll-blocked-centrally' => 'Нажалост, не можете да гласате на овие избори ако сте блокирани на барем $1 {{PLURAL:$1|вики|викија}}.',
	'securepoll-bot' => 'Жалиме, но сметките со ботовско знаменце не се дозволени на изборите.',
	'securepoll-not-in-group' => 'На овие избори можат да гласаат само припадници на групата „$1“.',
	'securepoll-not-in-list' => 'Жалиме, но вие не сте на предодредениот список на корисници овластени да гласаат на овие избори.',
	'securepoll-list-title' => 'Наведи гласови: $1',
	'securepoll-header-timestamp' => 'Време',
	'securepoll-header-voter-name' => 'Име',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ip' => 'IP-адреса',
	'securepoll-header-ua' => 'Кориснички агент',
	'securepoll-header-cookie-dup' => 'Дуп',
	'securepoll-header-strike' => 'Прецртување',
	'securepoll-header-details' => 'Подробно',
	'securepoll-strike-button' => 'Прецртувај',
	'securepoll-unstrike-button' => 'Врати црта',
	'securepoll-strike-reason' => 'Причина:',
	'securepoll-strike-cancel' => 'Откажи',
	'securepoll-strike-error' => 'Грешка при извршување на црта/врати црта: $1',
	'securepoll-strike-token-mismatch' => 'Сесиските податоци се изгубени',
	'securepoll-details-link' => 'Подробно',
	'securepoll-details-title' => 'Детали за гласот: #$1',
	'securepoll-invalid-vote' => '„$1“ е претставува важечка гласачка назнака',
	'securepoll-header-id' => 'Назнака',
	'securepoll-header-voter-type' => 'Тип на гласач',
	'securepoll-header-url' => 'URL-адреса',
	'securepoll-voter-properties' => 'Својства на гласачот',
	'securepoll-strike-log' => 'Дневник на ставање црти',
	'securepoll-header-action' => 'Дејство',
	'securepoll-header-reason' => 'Причина',
	'securepoll-header-admin' => 'Админ',
	'securepoll-cookie-dup-list' => 'Колачиња за дуплирани гласачи',
	'securepoll-dump-title' => 'Базна резерва: $1',
	'securepoll-dump-no-crypt' => 'Нема шифрирана гласачка евиденција за овие избори, бидејќи изборите не се поставени да користат шифрирање.',
	'securepoll-dump-not-finished' => 'Шифрираната гласачка евиденција е достапна дури откога ќе завршат изборите ($1 во $2)',
	'securepoll-dump-no-urandom' => 'Не можам да отворам /dev/urandom.  
За да се одржи приватноста на гласачот, шифрираната гласачка евиденција станува достапна за јавноста само кога податоците од евиденцијата ќе можат да се промешаат со помош на безбедна низа на случајни броеви.',
	'securepoll-urandom-not-supported' => 'Овој опслужувач не поддржува криптографско создавање на случајни броеви.
За да се одржи приватноста на гласачите, шифрираните избирачки податоци стануваат достапни за јавноста само кога ќе можат да се мешаат со безбедна низа случајни броеви.',
	'securepoll-translate-title' => 'Преведи: $1',
	'securepoll-invalid-language' => 'Неважечки јазичен код „$1“',
	'securepoll-header-trans-id' => 'Назнака',
	'securepoll-submit-translate' => 'Поднови',
	'securepoll-language-label' => 'Избери јазик:',
	'securepoll-submit-select-lang' => 'Преведување',
	'securepoll-entry-text' => 'Подолу е наведен списокот на гласања.',
	'securepoll-header-title' => 'Име',
	'securepoll-header-start-date' => 'Почетен датум',
	'securepoll-header-end-date' => 'Завршен датум',
	'securepoll-subpage-vote' => 'Глас',
	'securepoll-subpage-translate' => 'Преведи',
	'securepoll-subpage-list' => 'Список',
	'securepoll-subpage-dump' => 'Базна резерва од гласовите',
	'securepoll-subpage-tally' => 'Преброј',
	'securepoll-tally-title' => 'Пребројување: $1',
	'securepoll-tally-not-finished' => 'Жалиме, но не можете да ги пребројувате изборите додека прво не заврши гласањето.',
	'securepoll-can-decrypt' => 'Изборната евиденција е шифрирана, но клучот за дешифрирање е на располагање.  
Можете да одберете да ги преброите резултатите кои се во базата на податоци, или пак да ги преброите шифрираните резултати од подигната податотека.',
	'securepoll-tally-no-key' => 'Не можете да ги пребројувате овие избори бидејќи гласовите се шифрирани, а клучот за дешифрирање не е достапен.',
	'securepoll-tally-local-legend' => 'Преброј ги складираните резултати',
	'securepoll-tally-local-submit' => 'Создај пребројување',
	'securepoll-tally-upload-legend' => 'Подигни шифрирана резрвна складишна податотека',
	'securepoll-tally-upload-submit' => 'Создај пребројување',
	'securepoll-tally-error' => 'Грешка при толкување на гласовите, не можам да создадам пребројување.',
	'securepoll-no-upload' => 'Не беше подигната податотека, па не може да се пребројуваат резултатите.',
	'securepoll-dump-corrupt' => 'Податотеката со базната резерва е оштетена и не може да се обработи.',
	'securepoll-tally-upload-error' => 'Грешка при пребројување на отпаднатите гласови: $1',
	'securepoll-pairwise-victories' => 'Спарена матрица за пресметка на победникот',
	'securepoll-strength-matrix' => 'Матрица за јачина на патеката',
	'securepoll-ranks' => 'Конечно рангирање',
	'securepoll-average-score' => 'Просечна оценка',
	'securepoll-round' => 'Коло $1',
	'securepoll-spoilt' => '(Расипани)',
	'securepoll-exhausted' => '(Исцрпени)',
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
	'securepoll-gpg-parse-error' => 'ജി.പി.ജി. ഔട്ട്പുട്ട് മനസ്സിലാക്കുന്നതിൽ പിഴവുണ്ടായിരിക്കുന്നു.',
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
	'securepoll-too-new' => 'ക്ഷമിക്കണം, താങ്കൾക്ക് വോട്ട് ചെയ്യാനാവില്ല. ഈ തിരഞ്ഞെടുപ്പിൽ വോട്ട് ചെയ്യാൻ $1 $3-യ്ക്കു മുമ്പ് അംഗത്വമെടുത്തിരിക്കണം, താങ്കൾ അംഗത്വമെടുത്തത് $2 $4-നു് ആണ്.',
	'securepoll-blocked' => 'ക്ഷമിക്കുക, താങ്കളെ ഇപ്പോൾ തിരുത്തുന്നതിൽ നിന്നും തടഞ്ഞിരിക്കുന്നതിനാൽ താങ്കൾക്ക് വോട്ട് ചെയ്യാൻ കഴിയില്ല.',
	'securepoll-blocked-centrally' => 'ക്ഷമിക്കണം, കുറഞ്ഞത് {{PLURAL:$1|ഒരു|$1}} {{PLURAL:$1|വിക്കിയിൽ|വിക്കികളിൽ}} തടയപ്പെട്ടിരിക്കുകയാണെങ്കിൽ താങ്കൾക്ക് വോട്ട് ചെയ്യാനാവില്ല.',
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
	'securepoll-can-decrypt' => 'തിരഞ്ഞെടുപ്പ് വിവരങ്ങൾ ഗൂഢീകരിക്കപ്പെട്ടിരിക്കുന്നു, പക്ഷേ ഗൂഢീകരണം നീക്കാനുള്ള ചാവി ലഭ്യമല്ല.
ഇപ്പോൾ ഡേറ്റാബേസിലുള്ള ഫലങ്ങളുമായി താങ്കൾക്ക് ഒത്തുനോക്കാവുന്നതാണ്, അല്ലെങ്കിൽ അപ്‌‌ലോഡ് ചെയ്യുന്ന ഒരു പ്രമാണത്തിലെ ഗൂഢീകരിക്കപ്പെട്ട ഫലങ്ങൾ ഒത്തുനോക്കാവുന്നതാണ്.',
	'securepoll-tally-no-key' => 'വോട്ടുകളെല്ലാം ഗൂഢീകരിച്ചിരിക്കുന്നു, ഗൂഢീകരണം മാറ്റാനുള്ള ചാവി ലഭ്യമല്ലാത്തതിനാൽ ഈ തിരഞ്ഞെടുപ്പിന്റെ വിവരങ്ങൾ ഒത്തുനോക്കാൻ താങ്കൾക്ക് കഴിയില്ല.',
	'securepoll-tally-local-legend' => 'ശേഖരിക്കപ്പെട്ടിട്ടുള്ള ഫലങ്ങൾ തുലനം ചെയ്യുക',
	'securepoll-tally-local-submit' => 'ഒത്തുനോക്കൽ സൃഷ്ടിക്കുക',
	'securepoll-tally-upload-legend' => 'നിഗൂഢീകരിക്കപ്പെട്ട ഡമ്പ് അപ്‌‌ലോഡ് ചെയ്യുക',
	'securepoll-tally-upload-submit' => 'ഒത്തുനോക്കുക',
	'securepoll-tally-error' => 'തിരഞ്ഞെടുപ്പ് വിവരങ്ങൾ മനസ്സിലാക്കുന്നതിൽ പിഴവുണ്ടായിരിക്കുന്നു, ഫലം നൽകാൻ സാധിക്കുകയില്ല.',
	'securepoll-no-upload' => 'യാതൊരു പ്രമാണവും അപ്‌‌ലോഡ് ചെയ്തിട്ടില്ല, ഫലങ്ങൾ തുലനം ചെയ്യാൻ കഴിയില്ല.',
	'securepoll-dump-corrupt' => 'ഡമ്പ് പ്രമാണം കേടാണ്, അതുകൊണ്ട് മുന്നോട്ടുപോകാൻ കഴിയില്ല.',
	'securepoll-tally-upload-error' => 'ഒത്തുനോക്കുന്നതിൽ പിഴവുണ്ടായ ഡമ്പ് പ്രമാണം: $1',
	'securepoll-pairwise-victories' => 'ജോഡിയായുള്ള വിജയ മട്രിക്സ്',
	'securepoll-ranks' => 'അന്തിമ റാങ്കിങ്',
	'securepoll-average-score' => 'ശരാശരി സ്കോർ',
	'securepoll-round' => 'ഘട്ടം  1',
	'securepoll-spoilt' => '(അസ്പഷ്ടം)',
	'securepoll-exhausted' => '(തീർന്നവ)',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'securepoll-strike-reason' => 'Шалтгаан:',
	'securepoll-strike-cancel' => 'Цуцлах',
	'securepoll-header-reason' => 'Шалтгаан',
);

/** Marathi (मराठी)
 * @author Harishmr
 * @author Kaajawa
 * @author Mahitgar
 * @author Rahuldeshmukh101
 * @author Sau6402
 * @author V.narsikar
 */
$messages['mr'] = array(
	'securepoll' => 'सुरक्षित मतदान',
	'securepoll-desc' => 'सर्वेक्षणे आणि निवडणूकांकरीता विस्तार',
	'securepoll-invalid-page' => 'अवैध उपपान "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'हे कार्य करण्यासाठी आपण निवडणूक अधिकारी असणे आवशक आहे',
	'securepoll-too-few-params' => 'उपपान पॅरामीटर्स पुरेशा  नाहीत (अग्राह्य दुवा).',
	'securepoll-invalid-election' => '"$1" हे योग्य  निवडनुक ओळखपत्र नाही.',
	'securepoll-welcome' => '<strong>$1 चे स्वागत ! </strong>',
	'securepoll-not-started' => 'अजुन निवडणुक सुरु झालेली नाही. ती $2 ला $3 वाजता आयोजित केली गेली आहे.',
	'securepoll-finished' => 'निवडणुका संपल्या आहेत.आपण मतदान करू चाकात नाही.',
	'securepoll-not-qualified' => 'आपण या निवडणुकीत मत देण्यास पात्र नाही आहात :$1',
	'securepoll-change-disallowed' => 'तुम्ही या मतदानात अगोदर  भाग घेतला आहे.
तुम्ही परत मत देऊ शकत नाही.',
	'securepoll-change-allowed' => '<strong>सूचना : तुम्ही या निवडणुकीत आधी मतदान केलेले आहे. </strong>
खालील फॉर्म भरून, तुम्ही आपले आधीचे मत बदलू शकतात.
असे केल्यास तुमचे आधीचे मत बाद करण्यात येईल.',
	'securepoll-submit' => 'मत नोंदवा',
	'securepoll-gpg-receipt' => 'मतदान केल्या बद्दल धन्यवाद.
आपली इच्छा असल्यास, आपण आपल्या मताचा पुरावा म्हणून  खालील पावती आपल्या जवळ ठेऊ शकता :
<pre>$1</pre>',
	'securepoll-thanks' => 'धन्यावाद ,आपले मत नोंदवले गेले आहेत.',
	'securepoll-return' => '$1 कडे परत चला.',
	'securepoll-encrypt-error' => 'आपले मत रेकॉर्ड एनक्रीप्ट करण्यात अयश्स्वी.
तुमचे मत रेकॉर्ड केले गेले नाही

$1',
	'securepoll-no-gpg-home' => 'GPG home directory तयार करण्यात अयशस्वी.',
	'securepoll-secret-gpg-error' => 'GPG एक्झीक्यूटींग त्रूटी.
अधिक माहिती दर्शविण्याकरीता LocalSettings.php मध्ये $wgSecurePollShowErrorDetail=true वापरा;',
	'securepoll-full-gpg-error' => 'GPG चलवण्यात त्रुटी:

कमांड: $1

त्रुटी:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG keys चुकीच्या पद्धतीने कॉन्फीगर झालेल्या आहेत',
	'securepoll-gpg-parse-error' => 'जी पी जी आउटपुट interpret करण्यात त्रुटी',
	'securepoll-no-decryption-key' => 'कोणतीही  कूटमुक्तिकरण कुँजी विन्यासित नाहीं .(No decryption key is configured)
कूटमुक्त  करू शकत नाही',
	'securepoll-jump' => 'मतदान सर्वरला जा',
	'securepoll-bad-ballot-submission' => 'आपले मत अयोग्य होते : $1',
	'securepoll-unanswered-questions' => 'आपणास सर्व प्रश्नांची उत्तरे द्यायची आहेत.',
	'securepoll-invalid-rank' => 'चुकीचा क्रमांक. उमेदवारांना १ ते ९९९ मधील क्रमांक देणे अपेक्षीत आहे.',
	'securepoll-unranked-options' => 'काही विकल्प गुणानुक्रमित नाहीत.
आपण सर्व विकल्पांना १ ते ९९९ मधील गुणानुक्रम द्यावयास हवा.',
	'securepoll-invalid-score' => 'आपले गुण $1 ते $2 या आकड्यान मधेच पाहिजे.',
	'securepoll-unanswered-options' => 'आपल्याला प्रत्येक प्रश्नाला काहीतरी प्रतिक्रिया द्यायचीच आहे.',
	'securepoll-remote-auth-error' => 'विदागारातून आपल्या खात्याची माहिती शेंदण्यात त्रुटी.(Error fetching your account information from the server)',
	'securepoll-remote-parse-error' => 'दातावर प्रमाणीकरण पडताळणीत त्रूटी आलेली आहे',
	'securepoll-api-invalid-params' => 'अमान्य मापदंड',
	'securepoll-api-no-user' => 'या नावाचा कोणीही सदस्य अस्तित्वात नाही.',
	'securepoll-api-token-mismatch' => 'सुरक्षा निशाणी जुळलेली नाही , आपण प्रवेश करू शकत नाही',
	'securepoll-not-logged-in' => 'या मतदानात भाग घेण्यापूर्वी तुम्ही सदस्य खात्याद्वारे प्रवेश करणे अनिवार्य आहे.',
	'securepoll-too-few-edits' => 'क्षमस्व, तुम्ही मतदान करू शकत नाहीत. या मतदानात भाग घेण्यास कमीत कमी $1 {{PLURAL:$1|संपादन|संपादने}} केलेली असणे आवश्यक आहे. तुम्ही आजवर $2 {{PLURAL:$2|संपादन केले आहे|संपादने केली आहेत}}.',
	'securepoll-too-new' => 'माफकरा आपणास मतदान करता येणार नाही. ह्या निवडणुकीत मतदानासाठी  आपले खाते $1  ला $3  पूर्वी नोंदीकृत असायला हवे आहे. आपले खाते $2 ला $4   नोंदविले आहे.',
	'securepoll-blocked' => 'माफ करा, आपण या मतदानात भाग घेऊ शकत नाही जर आपण संपादण्यास प्रतिरोधित असाल.',
	'securepoll-blocked-centrally' => 'माफ करा, आपण या निवडणुकीत मतदान करू शकत नाही कारण आपण कमीतकमी $1 {{PLURAL:$1|विकिवर|विकिंवर}} प्रतिरोधित आहात.',
	'securepoll-bot' => 'माफ करा, सांगकाम्या नामशीर्ष असणाऱ्या खात्यांना या निवडणुकीत मतदानाची परवानगी नाही.',
	'securepoll-not-in-group' => 'फक्त "$1" गटातील सदस्यच या निवडणुकीत मतदान करू शकतात.',
	'securepoll-not-in-list' => 'माफ करा, आपले नाव  ह्या निवडणुकीत मतदान करू शकणाऱ्या मतदातांच्या  मतदार यादीत स्वविष्ट नाही.',
	'securepoll-list-title' => 'मत यादी: $1',
	'securepoll-header-timestamp' => 'वेळ',
	'securepoll-header-voter-name' => 'नाव',
	'securepoll-header-voter-domain' => 'डोमेन (प्रक्षेत्र)',
	'securepoll-header-ua' => 'सदस्य प्रतिनीधी',
	'securepoll-header-cookie-dup' => 'उघडणे',
	'securepoll-header-strike' => 'बहिशाल',
	'securepoll-header-details' => 'तपशील',
	'securepoll-strike-button' => 'बहिशाल',
	'securepoll-unstrike-button' => 'निशाणी नसलेले',
	'securepoll-strike-reason' => 'कारण:',
	'securepoll-strike-cancel' => 'रद्द करा',
	'securepoll-strike-error' => 'खोडणे / खोडणे-रद्द करताना  आलेली त्रुटी : $1',
	'securepoll-strike-token-mismatch' => 'कार्यकाळाची माहिती गाहाळ झाली आहे.',
	'securepoll-details-link' => 'तपशील',
	'securepoll-details-title' => 'मताचा तपशील: #$1',
	'securepoll-invalid-vote' => '"$1" हे योग्य  निवडनुक ओळखपत्र नाही.',
	'securepoll-header-voter-type' => 'उमेद्वाराचे प्रकार',
	'securepoll-voter-properties' => 'उमेद्वाराचे गुणधर्म',
	'securepoll-strike-log' => 'बहिशाल विवरण',
	'securepoll-header-action' => 'क्रिया',
	'securepoll-header-reason' => 'कारण',
	'securepoll-header-admin' => 'प्रच्यालक',
	'securepoll-cookie-dup-list' => 'स्मृतिशेषनुसार (Cookieनुसार) दुहेरी अथवा दुबार सदस्य',
	'securepoll-dump-title' => 'राशिपात : $1',
	'securepoll-dump-no-crypt' => 'हि  मतदान  प्रक्रिया सांकेतिक भाषेत जतन करण्यासाठी आखणी केली नसल्याने ह्या निवडणुकीचे कोणतेही सांकेतिक दस्तावेज उपलब्ध नाहीत',
	'securepoll-dump-not-finished' => 'निवडणुकीचे सांकेतिक दस्तावेज अंतिम तारखे नंतर  $1  ला  $2     वाजता   उपलब्ध होतील',
	'securepoll-dump-no-urandom' => ' /dev/urandom उघडू शकत नाही. 
 मतदात्याची गोपनीयता जपण्याच्या दृष्टीने, encrypted election records,  सुरक्षीत अविशीष्ट नंबर स्ट्रीम ने शफल झाल्यानंतरच  सार्वजनिकरीत्या उपलब्ध होतील.',
	'securepoll-urandom-not-supported' => 'हा विदादाता (सर्वर) cryptographic random number generation ला सपोर्ट करत नाही
 मतदात्याची गोपनीयता जपण्याच्या दृष्टीने, encrypted election records,  सुरक्षीत अविशीष्ट नंबर स्ट्रीम ने शफल झाल्यानंतरच  सार्वजनिकरीत्या उपलब्ध होतील.',
	'securepoll-translate-title' => '$1 या भाषेत भाषांतर करा',
	'securepoll-invalid-language' => 'अयोग्य भाषा क्रमांक "$1"',
	'securepoll-submit-translate' => 'अद्ययावत',
	'securepoll-language-label' => 'भाषा निवडा :',
	'securepoll-submit-select-lang' => 'भाषांतर करा',
	'securepoll-entry-text' => ' मतांची यादी खालील प्रमाणे आहे.',
	'securepoll-header-title' => 'नाव',
	'securepoll-header-start-date' => 'सुरूवात दिनांक',
	'securepoll-header-end-date' => 'अंतिम दिनांक',
	'securepoll-subpage-vote' => 'मत',
	'securepoll-subpage-translate' => 'भाषांतर करा',
	'securepoll-subpage-list' => 'यादी',
	'securepoll-subpage-dump' => 'राशिपात',
	'securepoll-subpage-tally' => 'जुळणे',
	'securepoll-tally-title' => 'जुळले: $1',
	'securepoll-tally-not-finished' => 'माफकरा, आपण मतदान प्रक्रिया पूर्ण होई पर्यंत निवडणूक मते जुळवू शकत नाहीत',
	'securepoll-tally-local-legend' => 'पूर्वी केलेले निकाल जुळवा',
	'securepoll-tally-local-submit' => ' गिनती तयार करा',
	'securepoll-tally-upload-submit' => ' गिनती तयार करा',
	'securepoll-tally-error' => 'मतदान दस्तावेज समजण्यात त्रूटी आलेली आहे. मते जुळत नाहीत',
	'securepoll-dump-corrupt' => 'राशिपात माहितीची संचिका दुषित झाल्यामुळे पुढील कार्य करता येत नाही',
	'securepoll-tally-upload-error' => 'राशीपाताच्या संचीकेस जुळवणी करतांना त्रूटी आलेल्या आहेत : $1',
	'securepoll-ranks' => 'अंतिम क्रमवारी',
	'securepoll-average-score' => 'सारासरी गुण',
	'securepoll-round' => 'फेरी $1',
	'securepoll-spoilt' => '(खराब होणे)',
	'securepoll-exhausted' => '(थकून जाणे)',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
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
	'securepoll-too-new' => 'Maaf, anda tidak boleh mengundi. Akaun mesti didaftarkan sebelum $1, $3 untuk mengundi di pemilihan ini; anda berdaftar pada $2, $4.',
	'securepoll-blocked' => 'Maaf, anda tak boleh mengundi jika anda kini telah disekat daripada menyunting.',
	'securepoll-blocked-centrally' => 'Maaf, anda tidak boleh mengundi dalam pemilihan ini kerana anda disekat di sekurang-kurangnya $1 {{PLURAL:$1|wiki|wiki}}.',
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
	'securepoll-strike-cancel' => 'Batalkan',
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
	'securepoll-round' => 'Pusingan $1',
	'securepoll-spoilt' => '(Rosak)',
	'securepoll-exhausted' => '(Lupus)',
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
	'securepoll-entry-text' => 'Hawn taħt hawn il-lista tas-sondaġġi.',
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

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'securepoll-submit' => 'Каямс вайгель',
	'securepoll-header-strike' => 'Черькстамс',
	'securepoll-strike-button' => 'Черькстамс',
	'securepoll-unstrike-button' => 'Саемс черькстамонть',
	'securepoll-strike-reason' => 'Тувталось:',
	'securepoll-details-link' => 'Мезде моли кортамось',
	'securepoll-header-reason' => 'Тувтал',
	'securepoll-language-label' => 'Кочкамс келенть:',
	'securepoll-submit-select-lang' => 'Ютавтомс',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Finnrind
 * @author Guaca
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 * @author Ronja Addams-Moring
 * @author Stigmj
 */
$messages['nb'] = array(
	'securepoll' => 'Sikkert valg',
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
	'securepoll-too-new' => 'Du kan desssverre ikke stemme. Kontoen din må ha vært registrert før $1 på $3 for å kunne stemme i dette valget, og du registrerte deg $2 på $4.',
	'securepoll-blocked' => 'Beklager, du kan ikke stemme i dette valget hvis du er blokkert fra å redigere.',
	'securepoll-blocked-centrally' => 'Du kan dessverre ikke stemme i dette valget fordi du er blokkert på minst $1 {{PLURAL:$1|wiki|wikier}}.',
	'securepoll-bot' => 'Beklager, kontoer med botflagg kan ikke stemme i dette valget.',
	'securepoll-not-in-group' => 'Kun brukere i gruppen «$1» kan delta i denne avstemningen.',
	'securepoll-not-in-list' => 'Du er dessverre ikke i lista over brukere som kan stemme i dette valget.',
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
	'securepoll-subpage-vote' => 'Stem',
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
	'securepoll-round' => 'Runde $1',
	'securepoll-spoilt' => '(Ugyldig)',
	'securepoll-exhausted' => '(Oppbrukt)',
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

/** Nepali (नेपाली)
 * @author Bhawani Gautam
 * @author RajeshPandey
 * @author सरोज कुमार ढकाल
 */
$messages['ne'] = array(
	'securepoll' => 'सुरक्षित चुनाव',
	'securepoll-desc' => 'चुनाव र सर्वेक्षणको लागि विस्तार',
	'securepoll-invalid-page' => 'अमान्य उपपृष्ठ "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'यो कार्य गर्न तपाईं चुनाव प्रवन्धक हुनुपर्छ।',
	'securepoll-too-few-params' => 'पर्याप्त  उपपृष्ठ मानक नभएको (अमान्य लिंक)।',
	'securepoll-invalid-election' => '"$1"  मान्य चुनाव परिचय भएन।',
	'securepoll-welcome' => '<strong>स्वागत $1!</strong>',
	'securepoll-not-started' => 'यो चुनाव अहिले सुरु भएको छैन।
यो  $2 को $3 बजे सुरु हुने कार्यक्रम छ।',
	'securepoll-finished' => 'चुनाव समाप्त भएको छ, अब तपाईंले मत दिन सक्नुहुन्न।',
	'securepoll-not-qualified' => 'तपाईं $1 चुनावको निम्ति मत दिन योग्य हुनुहुन्न।',
	'securepoll-change-disallowed' => 'तपाईंले पहिले नैं मत दि सक्नु भएकोछ।
माफ गर्नुहोला, तपाईं फेरि मत दिन सक्नुहुन्न।',
	'securepoll-change-allowed' => '<strong>सूचना:तपाईंले पहिलेबाट मत दिसक्नु भएकोछ।</strong>
तपाईंले निम्न फारम भरेर आफ्नो मत परिवर्तन गर्न सक्नुहुन्छ।
याद राख्नुहोस् यदि तपाईंले यसो गरे तपाईंको पहिलाको मत रद्द हुनेछ।',
	'securepoll-submit' => 'मत बुझाउने',
	'securepoll-gpg-receipt' => 'मत दिनु भएको धन्यबाद

यदि तपाईंले चाहे मत दिएको सबूतको लागि निम्न रसिद लिन सक्नुहुन्छ।:

<pre>$1</pre>',
	'securepoll-thanks' => 'धन्यवाद, तपाईंको मत रिकर्ड गरियो।',
	'securepoll-return' => '$1मा फर्कने',
	'securepoll-encrypt-error' => 'तपाईंको मत रिकर्ड गर्न असफल।
तपाईको मत रिकर्ड भएन!

$1',
	'securepoll-no-gpg-home' => 'GPG होम डाइरेक्ट्री बनाउन असफल।',
	'securepoll-secret-gpg-error' => 'GPG सञ्चालनमा त्रुटि।
LocalSettings.phpमा $wgSecurePollShowErrorDetail=true; को प्रयोग जानकारी बढाउन  गर्नुहोस्।',
	'securepoll-full-gpg-error' => 'GPG सञ्चालनमा त्रुटि:

कमाण्ड: $1

त्रुटि:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG की(keys) हरु  गलत ढंगले कन्फिगर गरिएको।',
	'securepoll-gpg-parse-error' => 'GPG उत्पादनको व्याख्यामा त्रुटि।',
	'securepoll-no-decryption-key' => 'ड़िक्रिप्शन कुंजी विन्यास नभएको।
डिक्रिप्ट गर्न सकिंदैन।',
	'securepoll-jump' => 'मतदान सर्वरतर्फ जाने',
	'securepoll-bad-ballot-submission' => 'तपाईंको मत अमान्य: $1',
	'securepoll-unanswered-questions' => 'तपाईले सबै प्रश्नहरुको उत्तर दिनुपर्छ।',
	'securepoll-invalid-rank' => 'अमान्य स्तर (rank)। तपाईंले उम्मेदवारको स्तर 1 देखि  999 सम्मको दिनु पर्छ।',
	'securepoll-unranked-options' => 'केहि प्रश्नहरुलाई स्तर प्रदान गरिएन।
तपाईंले सब विकल्पहरुलाई 1 देखि 999 सम्मको कुनै एउटा स्तर दिनुपर्छ।',
	'securepoll-invalid-score' => 'स्कोर $1 र $2 बिचको कुनै एउटा संख्या हुनुपर्छ।',
	'securepoll-unanswered-options' => 'प्रत्येक प्रश्नहरुको उत्तर तपाईंले दिनु पर्छ।',
	'securepoll-remote-auth-error' => 'सर्भर बाट तपाईको खाता सम्बन्धी जानकारी निकाल्दा गल्ती भयो ।',
	'securepoll-remote-parse-error' => 'सर्भर बाट प्राप्त अधिकार प्रदान गर्न लाई प्रतिक्रिया बुझ्दा गल्ती भयो ।',
	'securepoll-api-invalid-params' => 'अमान्य प्यारामिटर।',
	'securepoll-api-no-user' => 'यो परिचय भएको प्रयोगकर्ता पाइएन।',
	'securepoll-api-token-mismatch' => 'सुरक्षा टोकन मिलेन, प्रवेश गर्न सकिंदैन।',
	'securepoll-not-logged-in' => 'तपाईंले यस चुनावमा मत दिन प्रवेश गरेको हुनुपर्छ',
	'securepoll-too-few-edits' => 'माफ गर्नुहोस्, तपाईंले मत दिन सक्नुहुन्न। तपाईंले मत दिन निम्नतम $1 {{PLURAL:$1|सम्पादन|सम्पादनहरु}} गरेको हुनुपर्छ, तपाईंले $2 मात्र  गर्नु भएकोछ।',
	'securepoll-too-new' => 'माफ गर्नुहोला । तपाईले भोट दिन सक्नुहुन्न।  यस मतदान मा भोट दिनलाई  तपाईको खाता $1 भन्दा पहिले दर्ता गरिएको हुनुपर्छ भने तपाईले $2 मा दर्ता गर्नुभएको थियो।',
	'securepoll-blocked' => 'माफ गर्नुहोस्, तपाईंले यस चुनावमा मत दिन सक्नुहुन्न। तपाईंलाई सम्पादन गर्न बन्देज गरिएकोछ।',
	'securepoll-blocked-centrally' => 'माफ गर्नुहोला, जब तपाइलाई $1 वा बढि{{PLURAL:$1|विकीi|विकीहरु}}.मा निषेध गरिएको हुन्छ, तपाइले यस चुनावमा तपाईले भोट दिन पाउुनुहुन्न  ।',
	'securepoll-bot' => 'माफ गर्नुहोस्, बोटको ध्वजा भएको खातालाई यस चुनावमा मत दिने अनुमति छैन।',
	'securepoll-not-in-group' => '"$1" समूहका सदस्यहरुले मात्र यस चुनावमा मत दिन सक्नेछन्।',
	'securepoll-not-in-list' => 'माफ गर्नुहोला, तपाईं यस चुनावको लागि मतदानको अधिकार प्राप्त सदस्यहरुको पूर्वनिर्धारित सूचीमा पर्नुहुन्न।',
	'securepoll-list-title' => 'मतहरुको सूची: $1',
	'securepoll-header-timestamp' => 'समय',
	'securepoll-header-voter-name' => 'नाम',
	'securepoll-header-voter-domain' => 'डोमेन',
	'securepoll-header-ua' => 'प्रयोगकर्ता एजेन्ट(ब्राउजर)',
	'securepoll-header-cookie-dup' => 'दोहोरिएको',
	'securepoll-header-strike' => 'काट्ने',
	'securepoll-header-details' => 'विवरणहरु',
	'securepoll-strike-button' => 'काट्ने',
	'securepoll-unstrike-button' => 'काटेको हटाउने',
	'securepoll-strike-reason' => 'कारण:',
	'securepoll-strike-cancel' => 'रद्द गर्ने',
	'securepoll-strike-error' => 'त्रुटि काट्ने/ काटेको हटाउनेमा: $1',
	'securepoll-strike-token-mismatch' => 'सेसन डेटा हरायो',
	'securepoll-details-link' => 'विवरणहरु',
	'securepoll-details-title' => 'मत विवरणहरु: #$1',
	'securepoll-invalid-vote' => '"$1"  मान्य चुनाव परिचय भएन।',
	'securepoll-header-id' => 'आईडी(ID)',
	'securepoll-header-voter-type' => 'मतदाता प्रकार',
	'securepoll-voter-properties' => 'मतदाताको विवरणहरु',
	'securepoll-strike-log' => 'काटेको लग',
	'securepoll-header-action' => 'कार्य',
	'securepoll-header-reason' => 'कारण',
	'securepoll-header-admin' => 'प्रबन्धक',
	'securepoll-cookie-dup-list' => 'प्रतिलिपि कुकी प्रयोगकर्ताहरु',
	'securepoll-dump-title' => 'थाक: $1',
	'securepoll-translate-title' => 'अनुवाद गर्ने: $1',
	'securepoll-invalid-language' => 'अमान्य भाषा कोड "$1"',
	'securepoll-header-trans-id' => 'आईडी(ID)',
	'securepoll-submit-translate' => 'अद्यतन गर्ने(अपडेट)',
	'securepoll-language-label' => 'भाषा छान्ने:',
	'securepoll-submit-select-lang' => 'अनुवाद गर्ने',
	'securepoll-entry-text' => 'चुनावको सूची तल दिइएकोछ।',
	'securepoll-header-title' => 'नाम',
	'securepoll-header-start-date' => 'आरम्भ मिति',
	'securepoll-header-end-date' => 'समाप्ति तिथि',
	'securepoll-subpage-vote' => 'मत',
	'securepoll-subpage-translate' => 'अनुवाद गर्ने',
	'securepoll-subpage-list' => 'सूची',
	'securepoll-subpage-dump' => 'थाक',
	'securepoll-subpage-tally' => 'ट्याली',
	'securepoll-tally-title' => 'ट्याली: $1',
	'securepoll-tally-local-legend' => 'संग्रहित गरिएका टैली परिणामहरु',
	'securepoll-tally-local-submit' => 'ट्याली बनाउने',
	'securepoll-tally-upload-submit' => 'ट्याली बनाउने',
	'securepoll-ranks' => 'अन्तिम र्‌याङ्किङ्ग',
	'securepoll-average-score' => 'औसत स्कोर',
	'securepoll-round' => 'चरण $1',
);

/** Dutch (Nederlands)
 * @author Lolsimon
 * @author Mwpnl
 * @author Ronja Addams-Moring
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
	'securepoll-too-new' => 'U kunt niet deelnemen aan deze stemming. U moet voor $1 om $3 geregistreerd zijn om te mogen stemmen, terwijl u geregistreerd bent op $2 om $4.',
	'securepoll-blocked' => 'Sorry, u kunt niet deelnemen aan de stemming omdat u geblokkeerd bent.',
	'securepoll-blocked-centrally' => "U kunt niet deelnemen aan deze stemming omdat u geblokkeerd bent op minstens $1 {{PLURAL:$1|wiki|wiki's}}.",
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
	'securepoll-round' => 'Ronde $1',
	'securepoll-spoilt' => '(Ongeldig)',
	'securepoll-exhausted' => '(Verlopen)',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Gunnernett
 * @author Harald Khan
 * @author Ranveig
 */
$messages['nn'] = array(
	'securepoll' => 'TrygtVal',
	'securepoll-desc' => 'Ei utviding for val og undersøkingar',
	'securepoll-invalid-page' => 'Ugyldig underside «<nowiki>$1</nowiki>»',
	'securepoll-need-admin' => 'Du må vera valadministrator for å kunna utføra denne handlinga.',
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

/** Occitan (Occitan)
 * @author Boulaur
 * @author Cedric31
 * @author Jfblanc
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
	'securepoll-not-logged-in' => 'Vos cal connectar per votar dins aquesta eleccion.',
	'securepoll-too-few-edits' => 'O planhèm, podètz pas votar. Vos cal aver efectuat al mens {{PLURAL:$1|una modificacion|$1 modificacions}} per votar dins aquesta eleccion, ne totalizatz $2.',
	'securepoll-blocked' => 'O planhèm, podètz pas votar dins aquesta eleccion perque sètz blocat(ada) en escritura.',
	'securepoll-blocked-centrally' => 'O planhèm, podètz pas votar dins aquesta eleccion perque sètz blocat(ada) sus  almens $1 {{PLURAL:$1|wiki|wikis}}.',
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
Per assegurar la confidencialitat dels votants, las donadas criptadas son publicadas unicament quand pòdon trebolar un flux aleatòri de nombres.',
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

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'securepoll' => 'ନିରାପଦ ମତଦାନ',
	'securepoll-desc' => 'ନିର୍ବାଚନ ଓ ସର୍ବେକ୍ଷଣମାନଙ୍କ ନିମନ୍ତେ ଏକ୍ସଟେନସନ',
	'securepoll-invalid-page' => 'ଅଚଳ ଉପପୃଷ୍ଠା "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'ଏହି କମତିକୁଇ କରିବା ନିମନ୍ତେ ଆପଣଙ୍କୁ ଜଣେ ନିର୍ବାଚନ ପରିଛା ହେବାକୁ ପଡ଼ିବ ।',
	'securepoll-too-few-params' => 'ସେତେ ଅଧିକ ଉପପୃଷ୍ଠା ପାରାମିଟର ନାହିଁ (ଅଚଳ ଲିଙ୍କ)',
	'securepoll-invalid-election' => '"$1" ଏକ ବୈଧ ମତଦାନ ପରିଚୟ ନୁହେଁ ।',
	'securepoll-welcome' => '<strong>$1, ପାଛୋଟା!</strong>',
	'securepoll-not-started' => 'ଏହି ନିର୍ବାଚନ ଏବେ ଯାଏଁ ଆରମ୍ଭ ହୋଇନାହିଁ ।
ଏହା $2 ଦିନ $3 ବେଳେ ଆରମ୍ଭ ହେବ ବୋଲି ସ୍ଥିର କରାଯାଇଅଛି ।',
	'securepoll-finished' => 'ଏହି ନିର୍ବାଚନ ଶେଷ ହେଲା, ଆପଣ ଆଉ ମତ ଦେଇ ପାରିବେ ନାହିଁ ।',
	'securepoll-not-qualified' => 'ଆପଣ ଏଠାରେ ମତ ଦେବା ନିମନ୍ତେ ଯୋଗ୍ୟ ନୁହନ୍ତି: $1',
	'securepoll-change-disallowed' => 'ଆପଣ ଏହି ଏକା ନିର୍ବାଚନରେ ଆଗରୁ ମତ ଦେଇ ସାରିଛନ୍ତି ।
କ୍ଷମା କରିବେ, ଆପଣ ଆଉଥରେ ମତ ଦେଇପାରିବେ ନାହିଁ ।',
	'securepoll-change-allowed' => '<strong>ଜାଣିରଖନ୍ତୁ: ଆପଣ ଆଗରୁ ଏହି ନିର୍ବାଚନରେ ମତଦାନ କରିଛନ୍ତି ।</strong>
ତଳେ ଥିବା ଆବେଦନ ପତ୍ରରେ ଆପଣ ନିଜର ମତ ବଦଳାଇପାରିବେ ।
ଜାଣିରଖନ୍ତୁ ଏହା କରିସାରିଲା ପରେ ଆପଣଙ୍କ ମୂଳ ମତଟି ଖାରଜ ହୋଇଯିବ ।',
	'securepoll-submit' => 'ମତ ଦିଅନ୍ତୁ',
	'securepoll-gpg-receipt' => 'ମତଦାନ ନିମନ୍ତେ ଧନ୍ୟବାଦ।

ଆପଣ ଚାହିଁଲେ ଆପଣ ଏହି ତଳ ରସିଦଟି ଆପଣଙ୍କ ମତଦାନର ପ୍ରମାଣ ରୂପେ ରଖିପାରିବେ:

<pre>$1</pre>',
	'securepoll-thanks' => 'ଧନ୍ୟବାଦ, ଆପଣଙ୍କ ମତଦାନ ନଥିଭୁକ୍ତ କରାଗଲା ।',
	'securepoll-return' => '$1କୁ ଫେରିଯାନ୍ତୁ',
	'securepoll-encrypt-error' => 'ଆପଣଙ୍କ ମତଦାନର ଇତିହାସକୁ ଗୋପନ ରଖିବାରେ ବିଫଳ ହେଲୁ ।
ଆପଣଙ୍କର ମତ ସାଇତାଯାଇନାହିଁ!

$1',
	'securepoll-no-gpg-home' => 'GPG ମୂଳ ସୂଚି ତିଆରିବାରେ ବିଫଳ ହେଲୁ ।',
	'securepoll-secret-gpg-error' => 'GPG ସଞ୍ଚାଳନରେ ବିଫଳ ହେଲୁ ।
ଅଧିକ ଦେଖାଇବା ନିମନ୍ତେ LocalSettings.php ରେ $wgSecurePollShowErrorDetail=true;  ବ୍ୟବହାର କରନ୍ତୁ ।',
	'securepoll-full-gpg-error' => 'GPG ସଞ୍ଚାଲନରେ ଅସୁବିଧା:

ଆଦେଶ: $1

ଭୁଲ:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG କି ସବୁ ଆପେଆପେ ସଜାଇଦିଆଗଲା ।',
	'securepoll-gpg-parse-error' => 'GPG ଆଉଟପୁଟ ପଢ଼ିବାରେ ବିଫଳ ।',
	'securepoll-no-decryption-key' => 'ବିବରଣୀ ପୃଷ୍ଠା ସଜାଯାଇନାହିଁ ।
ଗୋପନ ତଥ୍ୟ ଖୋଲି ପାରିଲୁଁ ନାହିଁ ।',
	'securepoll-jump' => 'ମତାମତ ସର୍ଭରକୁ ଯିବେ',
	'securepoll-bad-ballot-submission' => 'ଆପଣଙ୍କ ମତଦାନ ଅବୈଧ ଅଟେ: $1',
	'securepoll-unanswered-questions' => 'ଆପଣଙ୍କୁ ସବୁଯାକ ପ୍ରଶ୍ନର ଉତ୍ତର ଦେବାକୁ ପଡ଼ିବ ।',
	'securepoll-invalid-rank' => 'ଅସଙ୍ଗତ କ୍ରମାଙ୍କ । ଆପଣ ୧ ରୁ ୯୯୯ ଭିତରେ ଏକ କ୍ରମାଙ୍କ ଦେଇପାରିବେ ।',
	'securepoll-unranked-options' => 'କେତେଗୁଡ଼ିଏ ବିକଳ୍ପ କ୍ରମଅନୁସାରେ ସଜାଯାଇ ନାହିଁ ।
ଆପଣ ସବୁଯାକ ବିକଳ୍ପକୁ ୧ ରୁ ୯୯୯ ଭିତରେ ଏକ କ୍ରମାଙ୍କ ଦେଇପାରିବେ ।',
	'securepoll-invalid-score' => 'ଫଳାଫଳ $1 ରୁ $2 ଭିତରେ ଏକ ସଙ୍ଖ୍ୟା ହେବ ଦରକାର ।',
	'securepoll-unanswered-options' => 'ଆପଣଙ୍କୁ ସବୁଜକ ପ୍ରଶ୍ନର ଉତ୍ତର ଦେବାକୁ ପଡ଼ିବ ।',
	'securepoll-remote-auth-error' => 'ସର୍ଭରରୁ ଆପଣଙ୍କ ଖାତାର ତଥ୍ୟ ବାହାର କରିବାରେ ଅସୁବିଧା ହେଲା ।',
	'securepoll-remote-parse-error' => 'ସର୍ଭରରୁ ଅନୁମୋଦନକୁ ବୁଝିବାରେ ଅସୁବିଧା ।',
	'securepoll-api-invalid-params' => 'ଭୁଲ ପାରାମିଟର ।',
	'securepoll-api-no-user' => 'ଏହି ପରିଚୟ ଦିଆଯାଇଥିବା ଜଣେ ବି ସଭ୍ୟ ମିଳିଲେ ନାହିଁ ।',
	'securepoll-api-token-mismatch' => 'ପ୍ରତିରକ୍ଷା ଚିହ୍ନ ଅମେଳ, ଲଗ ଇନ୍ନ କରିପାରିବେ ନାହିଁ ।',
	'securepoll-not-logged-in' => 'ଏହି ନିର୍ବାଚନନରେ ମତ ଦେବା ନିମନ୍ତେ ଆପଣଙ୍କୁ ଲଗ ଇନ କରିବାକୁ ପଡ଼ିବ',
	'securepoll-too-few-edits' => 'କ୍ଷମା କରିବେ, ଆପଣ ମତ ଦେଇପାରିବେ ନାହିଁ । ଏହି ନିର୍ବାଚନରେ ମତଦାନ ନିମନ୍ତେ ଆପଣଙ୍କୁ ଅତି କମରେ $1 {{PLURAL:$1|ଗୋଟି ବଦଳ|ଗୋଟି ବଦଳ} } କରିବାକୁ ପଡ଼ିବ, ଆପଣ ଏବେ ଯାଏଁ $2 ଗୋଟି ବଦଳ କରିଛନ୍ତି ।',
	'securepoll-too-new' => 'କ୍ଷମା କରିବେ, ଆପଣ ମତ ଦେଇପାରିବେ ନାହିଁ । ଆପଣଙ୍କ ଖାତାଟି $1 ଆଗରୁ $3 ବେଳେ ତିଆରି ହୋଇଥିବା ଲୋଡ଼ା, ଆପଣ $2 ଦିନ $4 ବେଳେ ଖାତାଟି ଖୋଲିଛନ୍ତି ।',
	'securepoll-blocked' => 'କ୍ଷମା କରିବେ, ଆପଣଙ୍କୁ ସମ୍ପାଦନାରୁ ଅଟକ କରାଯାଇଥିବାରୁ ଆପଣ ମତ ଦେଇପାରିବେ ନାହିଁ ।',
	'securepoll-blocked-centrally' => 'କ୍ଷମା କରିବେ, ଆପଣଙ୍କୁ ଅତିକମରେ $1 {{PLURAL:$1|ଗୋଟି ଉଇକି|ଗୋଟି ଉଇକି}}ରେ ଅଟକ କରାଯାଇଥିବାରୁ ଆପଣ ଏହି ନିର୍ବାଚନରେ ମତ ଦେଇ ପାରିବେ ନାହିଁ ।',
	'securepoll-bot' => 'କ୍ଷମା କରିବେ, ସ୍ଵୟଂଚାଳିତ ଚିହ୍ନିତ ଖାତା ଥିବା ଲୋକେ ଏହି ନିର୍ବାଚନରେ ମତ ଦେଇପାରିବେ ନାହିଁ ।',
	'securepoll-not-in-group' => 'କେବଳ "$1" ଗୋଠର ସଭ୍ୟଗଣ ଏହି ନିର୍ବାଚନରେ ମତ ଦେଇପାରିବେ ।',
	'securepoll-not-in-list' => 'କ୍ଷମା କରିବେ, ଏହି ନିର୍ବାଚନ ପାଇଁ ମତଦାନଯୋଗ୍ୟ ତାଲିକାରେ ଆପଣ ନାହାନ୍ତି ।',
	'securepoll-list-title' => 'ମତ ତାଲିକ: $1',
	'securepoll-header-timestamp' => 'ସମୟ',
	'securepoll-header-voter-name' => 'ନାମ',
	'securepoll-header-voter-domain' => 'ଡୋମେନ',
	'securepoll-header-ua' => 'ସଭ୍ୟ ପ୍ରତିନିଧି',
	'securepoll-header-cookie-dup' => 'ନକଲ',
	'securepoll-header-strike' => 'ନାମ କାଟିଦେବା',
	'securepoll-header-details' => 'ବିସ୍ତୃତ ବିବରଣୀ',
	'securepoll-strike-button' => 'ନାମ କାଟିଦେବା',
	'securepoll-unstrike-button' => 'ଚିହ୍ନଟ କରିବା',
	'securepoll-strike-reason' => 'କାରଣ:',
	'securepoll-strike-cancel' => 'ନାକଚ',
	'securepoll-strike-error' => 'ନାମ କାଟିବା/ଚିହ୍ନଟ କରିବାରେ ଅସୁବିଧା: $1',
	'securepoll-strike-token-mismatch' => 'ସମୟକାଳ ଡାଟା ହଜିଗଲା',
	'securepoll-details-link' => 'ଆହୁରି ଅଧିକ',
	'securepoll-details-title' => 'ମତଦାନ ସବିଶେଷ: #$1',
	'securepoll-invalid-vote' => '"$1" ଏକ ବୈଧ ମତଦାନ ପରିଚୟ ନୁହେଁ',
	'securepoll-header-voter-type' => 'ମତଦାନକାରୀ ପ୍ରକାର',
	'securepoll-voter-properties' => 'ମତଦାନକାରୀ ସବିଶେଷ',
	'securepoll-strike-log' => 'ନାମକାଟିବା ଇତିହାସ',
	'securepoll-header-action' => 'କାମ',
	'securepoll-header-reason' => 'କାରଣ',
	'securepoll-header-admin' => 'ପ୍ରଶାସକ',
	'securepoll-cookie-dup-list' => 'କୁକି ନକଲ ବ୍ୟବହାରକାରୀ',
	'securepoll-dump-title' => 'ଫୋପାଡ଼ିଦେବେ: $1',
	'securepoll-dump-no-crypt' => 'ଏହି ମତଦାନ ନିମନ୍ତେ କୌଣସିଟି ଗୋପନ ମତଦାନ ନଥି ମିଳୁନାହିଁ, କାରଣ ଏହି ମତଦାନଟିରେ ଗୋପନରେ ପରିଚାଳିତ ହେବ ଲାଗି ସଜାଣି ହୋଇନାହିଁ ।',
	'securepoll-dump-not-finished' => 'କେବଳ $1 ଦିନ $2 ଟା ପରେ ମତଦାନର ଗୋପନ ନଥି ଉପଲବ୍ଧ ହେବ ।',
	'securepoll-dump-no-urandom' => '/dev/urandom ଖୋଲିପାରିଲୁଁ ନାହିଁ ।
ମତଦାନକାରୀ ଗୋପନୀୟତା ରଖିବା ନିମନ୍ତେ, ଏକ ସୁରକ୍ଷିତ ଭାବେ ସଙ୍ଖ୍ୟାସବୁ ଇଆଡୁ ସିଆଡୁ ଅସଜଡ଼ା କରିସାରିଲା ପରେ ଗୋପନ ମତଦାନ ନଥି ସାଧାରଣରେ ମିଳିବ ।',
	'securepoll-urandom-not-supported' => 'ଏହି ସର୍ଭର ଗୋପନ କୋଡ଼ଥିବା ଯାହିତାହି ସଙ୍ଖ୍ୟା ଗଢ଼ିବାକୁ ଅନୁମତି ଦିଏନାହିଁ ।
ଭୋଟରଙ୍କ ଗୋପନୀୟତା ରଖିବା ନିମନ୍ତେ ଗୋପନ ମତଦାନର ନଥିସମୂହ ସୁରକ୍ଷିତ ଯାହିତାହି ସଙ୍ଖ୍ୟା ସୁଅରେ ପୁରାପୁରି ଗୋଳାଇ ଜନସାଧାରଣଙ୍କ ପାଇଁ ମିଳିଥାଏ ।',
	'securepoll-translate-title' => 'ଅନୁବାଦ: $1',
	'securepoll-invalid-language' => 'ଅଜଣା ଭାଷା କୋଡ଼ "$1"',
	'securepoll-submit-translate' => 'ଅପଡେଟ',
	'securepoll-language-label' => 'ଭାଷା ବାଛିବେ:',
	'securepoll-submit-select-lang' => 'ଅନୁବାଦ',
	'securepoll-entry-text' => 'ତଳେ ମତଦାନର ତାଲିକା ଦିଆଗଲା ।',
	'securepoll-header-title' => 'ନାମ',
	'securepoll-header-start-date' => 'ଆରମ୍ଭ ତାରିଖ',
	'securepoll-header-end-date' => 'ଶେଷ ତାରିଖ',
	'securepoll-subpage-vote' => 'ମତଦାନ',
	'securepoll-subpage-translate' => 'ଅନୁବାଦ',
	'securepoll-subpage-list' => 'ତାଲିକା',
	'securepoll-subpage-dump' => 'ଫୋପାଡ଼ିଦେବା',
	'securepoll-subpage-tally' => 'ଗଣନା',
	'securepoll-tally-title' => 'ଗଣନା: $1',
	'securepoll-tally-not-finished' => 'କ୍ଷମା କରିବେ, ମତଦାନ ଶେଷ ନହେବା ଯାଏଁ ଆପଣ ଗଣନା କରିପାରିବେ ନାହିଁ ।',
	'securepoll-can-decrypt' => 'ମତଦାନର ଫଳାଫଳକୁ ଗୋପନ କୋଡ଼ରେ ପରିଣତ କରାଯାଇପାରିବ, କିନ୍ତୁ ତାହାକୁ ଫିଟାଇବାର ଉପାୟ ମିଳୁଅଛି ।
ଆପଣ ଫଳାଫଳକୁ ସାଧାରଣ ଭାବରେ ଦେଖିପାରିବେ କିମ୍ବା ଏକ ଅପଲୋଡ଼ କରାୟାଇଥିବା ଫାଇଲରେ ଗୋପନ କୋଡ଼ ଭାବରେ ଗଣନା କରିପାରିବେ ।',
	'securepoll-tally-no-key' => 'ଆପଣ ମତଦାନକୁ ଗଣିପାରିବେ ନାହିଁ, କାରଣ ଏହା ଗୋପନ କୋଡ଼ ଭାବରେ ରହିଛି ଓ ତାହାକୁ ଫିଟାଇବାର ବାଟ ନାହିଁ ।',
	'securepoll-tally-local-legend' => 'ଗଣନା ଫଳାଫଳ',
	'securepoll-tally-local-submit' => 'ଗଣିବେ',
	'securepoll-tally-upload-legend' => 'ଗୋପନ କୋଡ଼ ଦିଆ ଅଳିଆ ଅପଲୋଡ଼ କରିବେ',
	'securepoll-tally-upload-submit' => 'ଗଣିବେ',
	'securepoll-tally-error' => 'ମତଦାନ ଅନୁମାନ କରିବାରେ ଭୁଲ ହେଲା, ଏକ ଗଣନା ତିଆରି କରାଯାଇ ପାରିବ ନାହିଁ ।',
	'securepoll-no-upload' => 'ଗୋଟିଏ ବି ଫାଇଲ ଅପଲୋଡ଼ ହେଲାନାହିଁ, ଫଳାଫଳ ଗଣି ପାରିବୁଁ‍‍ ନାହିଁ ।',
	'securepoll-dump-corrupt' => 'ଡମ୍ପ ଫାଇଲଟି ଖରାପ ଓ ତାହାକୁ ଆଗକୁ ବଢ଼ାଯାଇପାରିବ ନାହିଁ ।',
	'securepoll-tally-upload-error' => 'ଫୋପଡ଼ାଯିବା ଫାଇଲର ନକଲ କରିବାରେ ବିଫଳ: $1',
	'securepoll-pairwise-victories' => 'ଯୋଡ଼ା ଜିତିବା ମ୍ୟାଟ୍ରିକ୍ସ',
	'securepoll-strength-matrix' => 'ପଥ ଶକ୍ତି ମ୍ୟାଟ୍ରିକ୍ସ',
	'securepoll-ranks' => 'ଅନ୍ତିମ କ୍ରମାଙ୍କ',
	'securepoll-average-score' => 'ହାରାହାରି ଫଳ',
	'securepoll-round' => '$1 ରାଉଣ୍ଡ',
	'securepoll-spoilt' => '(ବିଗିଡ଼ିଯାଇଥିବା)',
	'securepoll-exhausted' => '(ଅବସନ୍ନ)',
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
	'securepoll-invalid-rank' => 'E forma di klasifiká aki no ta bálido. Bo mester klasifiká kandidatonan ku un number entre 1 i 999.',
	'securepoll-unranked-options' => 'Bo mester klasifiká tur opshon ku un number entre 1 i 999.',
	'securepoll-invalid-score' => 'E skor mester ta un number entre $1 i $2.',
	'securepoll-unanswered-options' => 'Bo mester respondé tur e preguntanan.',
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
	'securepoll-strike-token-mismatch' => 'E informashon di e seshon aki a wordu pèrdí',
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
	'securepoll-entry-text' => 'Aki bounan bo ta haña un lista di tur e enkuestanan.',
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
	'securepoll-dump-corrupt' => 'E "dump file" a wòrdu korumpí i no por wòrdu prosesá.',
	'securepoll-tally-upload-error' => 'Fout na ora di konta "dump file": $1',
	'securepoll-ranks' => 'Klasifikashon final',
	'securepoll-average-score' => 'Average',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'securepoll-welcome' => '<strong>Willkum $1!</strong>',
	'securepoll-return' => 'Zerick zu $1',
	'securepoll-jump' => 'Geh zum Waddefresser fer die Leckschen',
	'securepoll-unanswered-questions' => 'Du settsch fer alle Froge e Antwatt gewwe',
	'securepoll-unanswered-options' => 'Du settsch zu jedere Frog een Antwatt gewwe.',
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
 * @author Renessaince
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
	'securepoll-too-new' => 'Niestety nie możesz głosować. Aby wziąć udział w głosowaniu musisz mieć konto zarejestrowane przed $1 o $3, a zarejestrowałeś się $2 o $4.',
	'securepoll-blocked' => 'Niestety, nie możesz głosować w tych wyborach, ponieważ masz zablokowaną możliwość edytowania.',
	'securepoll-blocked-centrally' => 'Niestety nie możesz brać udziału w głosowaniu ponieważ jesteś zablokowany na co najmniej $1 wiki.',
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
	'securepoll-cookie-dup-list' => 'Użytkownicy, których ciasteczko świadczy o tym, że głosowali dwukrotnie',
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
	'securepoll-round' => '$1 tura',
	'securepoll-spoilt' => '(nieważny)',
	'securepoll-exhausted' => '(wyczerpany)',
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
	'securepoll-not-logged-in' => 'A dev intré ant ël sistema për voté an costa elession',
	'securepoll-too-few-edits' => "Spiasent, it peule pa voté. It deuve avèj fàit almanch $1 {{PLURAL:$1|modìfica|modìfiche}} për voté an st'elession-sì, ti it l'has fane $2.",
	'securepoll-too-new' => "An dëspias, ma a peul pa voté. Sò cont a l'ha da manca esse stàit duvertà prima dij $1 a $3 për voté an coste elession, chiel a l'é argistrasse ai $2 a $4.",
	'securepoll-blocked' => "Spiasent, it peule pa voté an st'elession-sì se it ses blocà.",
	'securepoll-blocked-centrally' => "An dëspias, a peul pa voté për costa elession përchè a l'é blocà ansima almanch $1 {{PLURAL:$1|wiki|wiki}}.",
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
	'securepoll-round' => 'Vira nùmer $1',
	'securepoll-spoilt' => '(Darmagi)',
	'securepoll-exhausted' => '(Esaurì)',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'securepoll' => 'سیکیورپول',
	'securepoll-desc' => 'چنوتی تے سروے لئی ایکسٹنشن',
	'securepoll-invalid-page' => 'ناںمنیا جان والا نکا صفہ "<نوکی>$1</nowiki>"',
	'securepoll-need-admin' => 'اے کم کرن لئی تواڈا الیکشن ایدمنسٹریٹر ہونا چائیدا اے۔',
	'securepoll-too-few-params' => 'کافی نکے صفیاں دے پیرامیٹر نئیں (جوڑ کم نئیں کردا)',
	'securepoll-invalid-election' => '"$1" کوئی پکی چنوتی آئی ڈی نئیں اے۔',
	'securepoll-welcome' => '<strong>جی آیاں نوں $1!</strong>',
	'securepoll-not-started' => 'اے چنوتی ہلے شروع نئیں ہوئی۔
اے $2 نوں $3 بجے شروغ ہووے گی۔',
	'securepoll-finished' => 'ایہ چنوتی ہن مک گئی اے تسیں ہن ووٹ نئیں پاسکدے۔',
	'securepoll-not-qualified' => 'تسیں ایس چنوتی چ ووٹ نئیں پاسکدے : $1',
	'securepoll-change-disallowed' => 'تسیں ایس چنوتی چ پہلے ووٹ پاچکے او۔
تسیں ہن ووٹ نئیں پاسکدے۔',
	'securepoll-change-allowed' => '<strong>نوٹ: تساں پہلے وی ایس چنوتی چ ووٹ پایا اے</strong>
تھلے دتا گیا فارم پعر کے تسیں اپنا ووٹ بدل سکدے او.
نوٹ: پر ایہ گل یاد رکھنا جے تواڈا پہلا ووٹ مک جائیگا۔.',
	'securepoll-submit' => 'ووٹ پاؤ',
	'securepoll-gpg-receipt' => 'ووٹ پان دا شکریہ۔
اگر تواڈا دل کرے تے تسیں تھلے دتیاں گیاں رسیداں اپنے دے ثبوت لئی رکھ سکدے او۔
<pre>$1</pre>',
	'securepoll-thanks' => 'شکریہ تواڈا ووٹ گنتی چ آگیا اے۔',
	'securepoll-return' => 'واپس $1 چلو',
	'securepoll-encrypt-error' => 'تواڈے ووٹ رکارڈ نوں پڑھن چ ہار۔
تواڈا ووٹ گنتی چ نئیں آیا۔
$1',
	'securepoll-no-gpg-home' => 'جی پی جی کعر ڈائرکٹری بنان چ ہار۔',
	'securepoll-secret-gpg-error' => 'جی پی جی چلاندیاں غلطی۔
ورتو $wgSecurePollShowErrorDetail=true ؛ LocalSettings.php ہور گلاں دسن لئی۔',
	'securepoll-full-gpg-error' => 'جی پی جی کردیاں غلطی:
کمانڈ: $1

غلطی:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'جی پی جی چابیاں ٹھیک ںغیں ّرھیاں گیاں',
	'securepoll-gpg-parse-error' => 'جی پی جی آوٹ پٹ نوں پڑھن چ غلطی۔',
	'securepoll-no-decryption-key' => 'کوئی ڈیکرٹشن چابی کنفگرڈ نئیں ہوئی۔ ڈیکرپٹ نئیں کرسکدا۔',
	'securepoll-jump' => 'چنوتی سرور کول جاؤ',
	'securepoll-bad-ballot-submission' => 'تواڈا ووٹ نئیں نئیں منیا گیا: $1',
	'securepoll-unanswered-questions' => 'تسیں لازمی سارے سوالاں دے جواب دیو۔',
	'securepoll-invalid-rank' => 'ناں منیا جان والا رینک۔  توانوں لازمی 1 تے 999 دے وشکار دینا پویگا۔',
	'securepoll-unranked-options' => 'کج چنوتیاں نئیں گنیاں گیاں۔
تساں نوں 1 توں 999 دے وشکار ساریاں چنوتیاں دینیاں پین گیاں۔',
	'securepoll-invalid-score' => 'گنتی $1 تے $2 دے نمبر دے وشکار ہونی چاسیدی اے۔',
	'securepoll-unanswered-options' => 'توانوں ہرسوال تے جواب دینا پویگا۔',
	'securepoll-remote-auth-error' => 'تواڈے کھاتہ دی جانکاری سرور توں لین چ غلطی۔',
	'securepoll-remote-parse-error' => 'سرور توں آتھورائیزیشن رسپونس سمجنے چ غلطی۔',
	'securepoll-api-invalid-params' => 'ناں منے جان والے پیرامیٹر',
	'securepoll-api-no-user' => 'ایس دتی ہوئی آئی ڈی نال کوئی ورتن والا نئیں لبیا۔',
	'securepoll-api-token-mismatch' => 'راکھی نشانی نئیں رلدی، لاگ ان نئیں ہوسکدے۔',
	'securepoll-not-logged-in' => 'تسیں لازمی [[خاص:ورتنلاگان|لاگ ان]] چنوتی چ ووٹ پان لئی۔
اگر تواڈا کوئی کھاتہ نئیں تسیں [[خاص:ورتنلاگان|بناؤ]]',
	'securepoll-too-few-edits' => 'اوہو، تسیں ووٹ نئیں پاسکدے۔ تسیں $1 {{PLURAL:$1|تبدیلی|تبدیلیاں}} ایس چنوتی چ ووٹ پان لئی تے تسیں $2 بنائی نئیں۔',
	'securepoll-too-new' => 'تسیں ووٹ نئیں پاےکدے۔ تواڈا کھاتہ پہلے سعاب کتاب چ آوے گا $1 توں پہلے تے $3 بجے چنوتی چ ووٹ پان لئی۔ تسیں $2 نوں $4 بجے رجسٹر ہووۓ سی۔',
	'securepoll-blocked' => 'معاف کرنا تسیں ایس چنوتی چ ووٹ نئیں پاسکدے اگر تسیں تبدیلی توں روک دتے گۓ او۔',
	'securepoll-blocked-centrally' => 'معاف کرنا تسیں ایس چوتی چ ووٹ ںغیں پاسکدے  کیوں جے توانوں $1 {{انیک:$1|وکی|وکیاں}} تے روکیا گیا جے۔',
	'securepoll-bot' => 'معاف کرنا کھاتے جناں نال بوٹ دا نشان ہووے اوناں نوں چنوتی چ ووٹ دی اجازت نئیں۔',
	'securepoll-not-in-group' => '"$1" ٹولی دے سنگی ایس چنوتی چ ووٹ پاسکدے نيں۔',
	'securepoll-not-in-list' => 'معاف کرنا تسیں اوناں ورتن والیاں دی لسٹ چ نئیں او جناں نوں ایس چنوتی ج ووٹ پان دی اجازت اے۔',
	'securepoll-list-title' => 'ووٹ لسٹ: $1',
	'securepoll-header-timestamp' => 'ویلہ',
	'securepoll-header-voter-name' => 'ناں',
	'securepoll-header-voter-domain' => 'ڈومین',
	'securepoll-header-ua' => 'ورتن آلا اجنٹ',
	'securepoll-header-cookie-dup' => 'سٹو',
	'securepoll-header-strike' => 'سٹرائک',
	'securepoll-header-details' => 'معلومات',
	'securepoll-strike-button' => 'سٹرائک',
	'securepoll-unstrike-button' => 'انسٹرائک',
	'securepoll-strike-reason' => 'وجہ:',
	'securepoll-strike-cancel' => 'ختم',
	'securepoll-strike-error' => 'غلطی سٹرائیک/ناں سٹرائیک کردیاں ہویاں: $1',
	'securepoll-strike-token-mismatch' => 'سیشن ڈیٹا گم گیا۔',
	'securepoll-details-link' => 'معلومات',
	'securepoll-details-title' => 'ووٹ گل بات: #$1',
	'securepoll-invalid-vote' => '"$1" اک پکا ووٹ آئی ڈی نغیں',
	'securepoll-header-voter-type' => 'ووٹر ٹائپ',
	'securepoll-voter-properties' => 'ووٹر پروپرٹیز',
	'securepoll-strike-log' => 'سٹرائیک لاگ',
	'securepoll-header-action' => 'کم',
	'securepoll-header-reason' => 'وجہ',
	'securepoll-header-admin' => 'ایڈمن',
	'securepoll-cookie-dup-list' => 'کوکی ڈپلیکیٹ ورتن والے',
	'securepoll-dump-title' => 'سٹو: $1',
	'securepoll-dump-no-crypt' => 'کوئی انکرپثڈ چنوتی رکارڈ ہیگا اے ایس چنوتی لئی کیوں چ چنوتی نوں ایس دے رکارڈ رکھن لئی تیار نئیں کیتا گیا۔',
	'securepoll-dump-not-finished' => 'اینکرپٹڈ چنوتی رکارڈ چنوتیاں ہون مگروں $1 تریخ تے $2 بجے ملیگا۔',
	'securepoll-dump-no-urandom' => 'کھول نئیں سکدا/ڈیو/یورینڈم۔
ووٹ پان دی لکائی رکھن لئی ، انکریپٹڈ چنوتی رکارڈ عام لوکاں نوں اودوں دسے جان گے جدوں اوناں نوں سانبے گۓ نمبر نال شفل کیتا جاۓ۔',
	'securepoll-urandom-not-supported' => 'ایہ سرور کرپٹوگرافک رینڈم نمبر جنریشن۔
ووٹ پان والیاں دی لکائی لئی، انکرپثڈ چنوتی رکارڈ عام لوکاں نوں اوروں دسے جان گے جدون اوناں نوں پکے نمبراں وچ رلایا جاۓ گا۔',
	'securepoll-translate-title' => 'التھاؤ : $1',
	'securepoll-invalid-language' => "ناں منیا جان والا بولی کوڈ '$1'",
	'securepoll-submit-translate' => 'نواں کرو',
	'securepoll-language-label' => 'بولی چنو',
	'securepoll-submit-select-lang' => 'بولی التھاؤ',
	'securepoll-entry-text' => 'تھلے چنوتیاں دی لسٹ اے۔',
	'securepoll-header-title' => 'ناں',
	'securepoll-header-start-date' => 'ٹرن تریخ',
	'securepoll-header-end-date' => 'انت تریخ',
	'securepoll-subpage-vote' => 'ووٹ دیو',
	'securepoll-subpage-translate' => 'بولی التھاؤ',
	'securepoll-subpage-list' => 'لسٹ',
	'securepoll-subpage-dump' => 'سٹو',
	'securepoll-subpage-tally' => 'گنو',
	'securepoll-tally-title' => 'گنتی: $1',
	'securepoll-tally-not-finished' => 'معاف کرنا، تسیں اودوں تک چنوتیاں دی گنتی نئیں کرسکدے جدوں تک سارے ووٹ ناں پے جان۔',
	'securepoll-can-decrypt' => 'چنوتی رکارڈ نوں خفیا کرلیاگیا اے پر اینوں پڑھن دی کنجی ہیگی اے۔
تسیں یا تے ڈیٹابیس چ نتیجے ویکھ سکدے اے یا کسے چڑھائی گئی فائل نال رلا کے ویکھ سکدے او۔',
	'securepoll-tally-no-key' => 'تسیل چنوتی دی گنتی نئیں کرسکدے کیوں جے ووٹ لکی بولی ج نیں تے ایس بولی نوں سمجن دی چابی نئیں ہیگی۔',
	'securepoll-tally-local-legend' => 'کٹھے کیتے گۓ نتارے',
	'securepoll-tally-local-submit' => 'گنتی بناؤ',
	'securepoll-tally-upload-legend' => 'لکی بولی دا ٹعیر چڑھاؤ',
	'securepoll-tally-upload-submit' => 'گنتی بناؤ',
	'securepoll-tally-error' => 'ووٹ رکارڈ سمجن چ غلطی، گنتی نئيں دتی جاسکدی۔',
	'securepoll-no-upload' => 'کوئی فائل نئیں چرھائی کئی، نتارے نئیں کنے جاسکدے',
	'securepoll-dump-corrupt' => 'ڈمپ فائل خراب اے تے چلائی نئیں جاسکدی۔',
	'securepoll-tally-upload-error' => 'ڈمپ فائل دی کنتی کردیاں ہویاں غلطی: $1',
	'securepoll-pairwise-victories' => 'پیروائز وکٹری میٹرکس',
	'securepoll-strength-matrix' => 'پاتھ سٹرینگتھ میٹرکس',
	'securepoll-ranks' => 'فائینل رینکنگ',
	'securepoll-average-score' => 'ایورج سکور',
	'securepoll-round' => 'راؤنڈ $1',
	'securepoll-spoilt' => '(سپویلٹ)',
	'securepoll-exhausted' => '(مک چکیا)',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'securepoll-submit' => 'رايه سپارل',
	'securepoll-thanks' => 'له تاسې نه مننه، ستاسې رايه ثبته شوه.',
	'securepoll-return' => '$1 ته ورګرځېدل',
	'securepoll-jump' => 'د رايو پالنګر ته ورشۍ',
	'securepoll-bad-ballot-submission' => 'ستاسې رايه سمه نه وه: $1',
	'securepoll-unanswered-questions' => 'تاسې بايد ټولې پوښتنې ځواب کړۍ.',
	'securepoll-header-timestamp' => 'وخت',
	'securepoll-header-voter-name' => 'نوم',
	'securepoll-header-voter-domain' => 'شپول',
	'securepoll-header-ua' => 'د کارن پلاوی',
	'securepoll-header-details' => 'تفصيلات',
	'securepoll-strike-reason' => 'سبب:',
	'securepoll-strike-cancel' => 'ناګارل',
	'securepoll-details-link' => 'ځانګړنې',
	'securepoll-header-reason' => 'سبب',
	'securepoll-header-admin' => 'پازوال',
	'securepoll-submit-translate' => 'اوسمهالول',
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
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author SandroHc
 * @author Waldir
 */
$messages['pt'] = array(
	'securepoll' => 'Sondagem Segura',
	'securepoll-desc' => 'Extensão para eleições e sondagens',
	'securepoll-invalid-page' => 'Subpágina inválida: "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Precisa de ser um administrador de eleições para realizar esta operação.',
	'securepoll-too-few-params' => 'Parâmetros de subpágina insuficientes (link inválido).',
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
	'securepoll-too-new' => 'Desculpe, mas não pode votar. A sua conta teria de ter sido registada antes de $1 de $3 para votar nesta eleição, mas registou-se em $2 de $4.',
	'securepoll-blocked' => 'Desculpe, mas não pode votar nesta eleição se foi bloqueado de efectuar edições.',
	'securepoll-blocked-centrally' => 'Desculpe, mas não pode votar nesta eleição quando estiver bloqueado em pelo menos $1 {{PLURAL:$1|wiki|wikis}}.',
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
	'securepoll-dump-title' => 'Copiar para ficheiro: $1',
	'securepoll-dump-no-crypt' => 'Nenhum registo codificado de eleição está disponível para esta eleição, porque a eleição não está configurada para usar encriptação.',
	'securepoll-dump-not-finished' => 'Registos de eleição encriptados estarão disponíveis apenas após a eleição terminar a $1 às $2',
	'securepoll-dump-no-urandom' => 'Não é possível abrir /dev/urandom.
Para manter a privacidade dos votantes, os registos de eleição encriptados só são tornados públicos quando podem ser reordenados usando uma fonte segura de números aleatórios.',
	'securepoll-urandom-not-supported' => 'Este servidor não sustenta a geração de números aleatórios para uso criptográfico.
Para manter a privacidade dos votantes, os registos de eleição encriptados só são tornados públicos quando podem ser reordenados usando uma fonte segura de números aleatórios.',
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
	'securepoll-subpage-dump' => 'Copiar para ficheiro',
	'securepoll-subpage-tally' => 'Apurar',
	'securepoll-tally-title' => 'Apurar: $1',
	'securepoll-tally-not-finished' => 'Desculpe, mas não pode apurar os resultados da eleição até que a votação esteja terminada.',
	'securepoll-can-decrypt' => 'O registo da eleição foi encriptado, mas a chave de descodificação está disponível.
Pode escolher entre apurar os resultados presentes na base de dados, ou apurar resultados encriptados de um ficheiro carregado.',
	'securepoll-tally-no-key' => 'Não pode apurar esta eleição, porque os votos estão encriptados e a chave de descodificação não está disponível.',
	'securepoll-tally-local-legend' => 'Apurar resultados armazenados',
	'securepoll-tally-local-submit' => 'Criar apuramento',
	'securepoll-tally-upload-legend' => 'Upload da cópia em ficheiro encriptada',
	'securepoll-tally-upload-submit' => 'Criar apuramento',
	'securepoll-tally-error' => 'Erro na interpretação de registo de voto, não é possível produzir apuramento.',
	'securepoll-no-upload' => 'Nenhum ficheiro foi carregado, não é possível apurar resultados.',
	'securepoll-dump-corrupt' => 'A cópia em ficheiro está corrompida e não pode ser processada.',
	'securepoll-tally-upload-error' => 'Erro ao contar a cópia em ficheiro: $1',
	'securepoll-pairwise-victories' => 'Matriz de vitórias par a par',
	'securepoll-strength-matrix' => 'Matriz de forças de caminho',
	'securepoll-ranks' => 'Classificação final',
	'securepoll-average-score' => 'Pontuação média',
	'securepoll-round' => 'Ronda $1',
	'securepoll-spoilt' => '(Danificadas)',
	'securepoll-exhausted' => '(Esgotadas)',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Capmo
 * @author Eduardo.mps
 * @author Everton137
 * @author GKnedo
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author MetalBrasil
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
	'securepoll-invalid-score' => 'A pontuação deve ser um número entre $1 e $2.',
	'securepoll-unanswered-options' => 'Você tem que responder todas as perguntas.',
	'securepoll-remote-auth-error' => 'Erro ao tentar obter suas informações de conta do servidor.',
	'securepoll-remote-parse-error' => 'Erro ao interpretar a resposta de autorização do servidor.',
	'securepoll-api-invalid-params' => 'Parâmetros inválidos.',
	'securepoll-api-no-user' => 'Nenhum usuário foi encontrado com a ID fornecida.',
	'securepoll-api-token-mismatch' => 'Token de segurança não confere, não foi possível autenticar.',
	'securepoll-not-logged-in' => 'Você deve se registrar para votar nesta eleição',
	'securepoll-too-few-edits' => 'Desculpe, você não pode votar. É preciso ter feito no mínimo $1 {{PLURAL:$1|edição|edições}} para votar nesta eleição, você fez $2.',
	'securepoll-too-new' => 'Desculpe-nos, mas você não pode votar. A sua conta precisaria ser registrada antes de $1 no $3 para votar nesta eleição, mas registrou-se em $2 no $4',
	'securepoll-blocked' => 'Desculpe, você não pode votar nesta eleição se no momento você está bloqueado de editar.',
	'securepoll-blocked-centrally' => 'Desculpe-nos, você não pode votar nesta eleição quando está bloqueado em pelo menos $1 {{PLURAL:$1|wiki|wikis}}.',
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
	'securepoll-entry-text' => 'Encontra-se abaixo a lista de eleições.',
	'securepoll-header-title' => 'Título',
	'securepoll-header-start-date' => 'Data do Início',
	'securepoll-header-end-date' => 'Data de fim',
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
	'securepoll-average-score' => 'Pontuação média',
	'securepoll-round' => 'Ronda $1',
	'securepoll-spoilt' => '(Danificadas)',
	'securepoll-exhausted' => '(Esgotadas)',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'securepoll-list-title' => 'Akllasqakunata sutisuyunchay: $1',
	'securepoll-header-timestamp' => 'Pacha',
	'securepoll-header-voter-name' => 'Suti',
	'securepoll-header-strike' => 'Sikwipuy',
	'securepoll-header-details' => 'Imaymana',
	'securepoll-strike-button' => 'Sikwipuy',
	'securepoll-details-link' => 'Imaymana',
	'securepoll-header-voter-type' => 'Akllaq laya',
	'securepoll-voter-properties' => 'Akllaqpa kaqninkuna',
	'securepoll-strike-log' => "Sikwipuy hallch'a",
	'securepoll-header-action' => 'Ruray',
	'securepoll-header-reason' => 'Kayrayku',
	'securepoll-header-admin' => 'Kamachiq',
	'securepoll-translate-title' => "T'ikray: $1",
	'securepoll-invalid-language' => 'Mana kaq rimay tuyru "$1"',
	'securepoll-submit-translate' => 'Musuqchay',
	'securepoll-language-label' => 'Rimayta akllay:',
	'securepoll-submit-select-lang' => "T'ikray",
	'securepoll-header-title' => 'Suti',
	'securepoll-header-start-date' => "Qallarisqanpa p'unchawnin",
	'securepoll-header-end-date' => "Puchukana p'unchaw",
	'securepoll-subpage-vote' => 'Akllay',
	'securepoll-subpage-translate' => "T'ikray",
	'securepoll-subpage-list' => 'Sutisuyu',
	'securepoll-subpage-dump' => "K'uktiy",
	'securepoll-subpage-tally' => 'Yupaq',
	'securepoll-tally-title' => 'Yupaq: $1',
	'securepoll-tally-local-submit' => 'Yupaqta kamariy',
	'securepoll-tally-upload-submit' => 'Yupaqta kamariy',
	'securepoll-average-score' => 'Kuskanchaku taripasqakuna',
);

/** Romanian (Română)
 * @author AdiJapan
 * @author Cin
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'securepoll' => 'SondajSecurizat',
	'securepoll-desc' => 'Extensie pentru alegeri și anchete',
	'securepoll-invalid-page' => 'Subpagina „<nowiki>$1</nowiki>” este invalidă',
	'securepoll-need-admin' => 'Trebuie să fiți un administrator de alegeri pentru a efectua această acțiune.',
	'securepoll-too-few-params' => 'Insuficienți parametri pentru subpagină (legătură invalidă).',
	'securepoll-invalid-election' => '„$1” nu este un ID valid de alegeri.',
	'securepoll-welcome' => '<strong>Bun venit $1!</strong>',
	'securepoll-not-started' => 'Aceste alegeri nu au început încă.
Sunt programate să pornească pe $2 la $3.',
	'securepoll-finished' => 'Alegerile s-au sfârșit, nu mai puteți vota.',
	'securepoll-not-qualified' => 'Nu sunteți eligibil să votați în cadrul acestor alegeri: $1',
	'securepoll-change-disallowed' => 'V-ați exprimat deja votul în cadrul acestor alegeri.
Ne pare rău, nu puteți vota din nou.',
	'securepoll-change-allowed' => '<strong>V-ați exprimat deja votul în cadrul acestor alegeri.</strong>
Vă puteți schimba opțiunea completând formularul de mai jos.
Vă rugăm să rețineți că, în urma acestei operațiuni, votul dumneavoastră inițial nu va mai conta.',
	'securepoll-submit' => 'Trimite votul',
	'securepoll-gpg-receipt' => 'Vă mulțumim pentru vot.

Dacă doriți, puteți păstra următorul bon ca dovadă a votului dumneavoastră:

<pre>$1</pre>',
	'securepoll-thanks' => 'Vă mulțumim, votul dumneavoastră a fost înregistrat.',
	'securepoll-return' => 'Înapoi la $1',
	'securepoll-encrypt-error' => 'Criptarea votului dumneavoastră a eșuat.
Acesta nu a fost înregistrat! 

$1',
	'securepoll-no-gpg-home' => 'Nu s-a putut crea directorul personal GPG.',
	'securepoll-secret-gpg-error' => 'Eroare la executarea GPG.
Adăugați $wgSecurePollShowErrorDetail=true; în LocalSettings.php pentru a afișa mai multe detalii.',
	'securepoll-full-gpg-error' => 'Eroare la executarea GPG:

Comandă: $1

Eroare:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Cheile GPG sunt greșit configurate.',
	'securepoll-gpg-parse-error' => 'Eroare la interpretarea datelor de ieșire GPG.',
	'securepoll-no-decryption-key' => 'Nicio cheie de decriptare nu este configurată.
Nu se poate decripta.',
	'securepoll-jump' => 'Mergi la serverul de votare',
	'securepoll-bad-ballot-submission' => 'Votul dumneavoastră a fost incorect: $1',
	'securepoll-unanswered-questions' => 'Trebuie să răspundeți la toate întrebările.',
	'securepoll-invalid-rank' => 'Grad incorect. Trebuie să acordați candidaților un grad cuprins între 1 și 999.',
	'securepoll-unranked-options' => 'Unele opțiuni nu au fost clasate.
Trebuie să oferiți tuturor opțiunilor un grad cuprins între 1 și 999.',
	'securepoll-invalid-score' => 'Scorul trebuie să fie un număr cuprins între $1 și $2.',
	'securepoll-unanswered-options' => 'Trebuie să dați un răspuns fiecărei întrebări.',
	'securepoll-remote-auth-error' => 'Eroare la preluarea de pe server a informaților contului dumneavoastră.',
	'securepoll-remote-parse-error' => 'Eroare la interpretarea răspunsului de autorizație primit de la server.',
	'securepoll-api-invalid-params' => 'Parametri incorecți.',
	'securepoll-api-no-user' => 'Niciun utilizator cu acest ID nu a fost găsit.',
	'securepoll-api-token-mismatch' => 'Jetonul de securitate nu se potrivește. Nu se poate efectua autentificarea.',
	'securepoll-not-logged-in' => 'Trebuie să vă autentificați pentru a vota în cadrul acestor alegeri.',
	'securepoll-too-few-edits' => 'Ne pare rău, dar nu puteți vota. Trebuie să fi contribuit cu cel puțin $1 {{PLURAL:$1|modificare|modificări}} pentru a vota în cadrul acestor alegeri. Dumneavoastră ați efectuat doar $2.',
	'securepoll-too-new' => 'Ne pare rău, dar nu puteți vota. Pentru a vă exprima votul în cadrul acestor alegeri este necesar ca contul dumneavoastră să fi fost înregistrat înainte de $1 la $3. Dumneavoastră v-ați înregistrat pe $2 la $4.',
	'securepoll-blocked' => 'Ne pare rău, dar nu puteți vota în cadrul acestor alegeri deoarece sunteți blocat (nu puteți face modificări).',
	'securepoll-blocked-centrally' => 'Ne pare rău, dar nu puteți vota în cadrul acestor alegerilor întrucât sunteți blocat pe cel puțin $1 {{PLURAL:$1|wiki|wikiuri}}.',
	'securepoll-bot' => 'Ne pare rău, dar conturilor cu statut de robot nu li se permite să voteze în cadrul acestor alegeri.',
	'securepoll-not-in-group' => 'Doar membrii grupului „$1” pot vota în cadrul acestor alegeri.',
	'securepoll-not-in-list' => 'Ne pare rău, nu sunteți în lista predeterminată de utilizatori autorizați să voteze în aceste alegeri.',
	'securepoll-list-title' => 'Listă voturi: $1',
	'securepoll-header-timestamp' => 'Dată',
	'securepoll-header-voter-name' => 'Nume',
	'securepoll-header-voter-domain' => 'Domeniu',
	'securepoll-header-ua' => 'User agent',
	'securepoll-header-cookie-dup' => 'Duplicat',
	'securepoll-header-strike' => 'Eliminare',
	'securepoll-header-details' => 'Detalii',
	'securepoll-strike-button' => 'Elimină',
	'securepoll-unstrike-button' => 'Anulare eliminare',
	'securepoll-strike-reason' => 'Motiv:',
	'securepoll-strike-cancel' => 'Revocare',
	'securepoll-strike-error' => 'Eroare la efectuarea operațiunii de eliminare/anulare a eliminării: $1',
	'securepoll-strike-token-mismatch' => 'Informațiile despre sesiune s-au pierdut',
	'securepoll-details-link' => 'Detalii',
	'securepoll-details-title' => 'Detalii vot: #$1',
	'securepoll-invalid-vote' => '„$1” nu este un ID al unui vot valid',
	'securepoll-header-voter-type' => 'Tipuri de votanți',
	'securepoll-voter-properties' => 'Însușirile votanților',
	'securepoll-strike-log' => 'Jurnal de eliminare',
	'securepoll-header-action' => 'Acțiune',
	'securepoll-header-reason' => 'Motiv',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-cookie-dup-list' => 'Utilizatori reveniți, identificați după cookie',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Nicio înregistrare criptată nu este disponibilă pentru aceste alegeri, deoarece acest scrutin nu a fost configurat în vederea folosirii criptării.',
	'securepoll-dump-not-finished' => 'Înregistrările criptate ale alegerilor sunt disponibile doar după momentul închiderii votului, în data de $1, ora $2',
	'securepoll-dump-no-urandom' => 'Nu se poate deschide /dev/urandom.
Pentru a respecta confidențialitatea votanților, înregistrările criptate ale alegerilor sunt disponibile public doar atunci când pot fi amestecate folosind o secvență securizată de numere aleatoare.',
	'securepoll-urandom-not-supported' => 'Acest server nu acceptă generarea criptografică de numere aleatoare.
Pentru a respecta confidențialitatea votanților, înregistrările criptate ale alegerilor sunt disponibile public doar atunci când pot fi amestecate folosind o secvență securizată de numere aleatoare.',
	'securepoll-translate-title' => 'Traducere: $1',
	'securepoll-invalid-language' => 'Codul de limbă „$1” este incorect',
	'securepoll-submit-translate' => 'Actualizează',
	'securepoll-language-label' => 'Selectați limba:',
	'securepoll-submit-select-lang' => 'Traducere',
	'securepoll-entry-text' => 'Mai jos se află lista cu sondaje.',
	'securepoll-header-title' => 'Nume',
	'securepoll-header-start-date' => 'Dată începere',
	'securepoll-header-end-date' => 'Dată finalizare',
	'securepoll-subpage-vote' => 'Vot',
	'securepoll-subpage-translate' => 'Traducere',
	'securepoll-subpage-list' => 'Listă',
	'securepoll-subpage-dump' => 'Dump',
	'securepoll-subpage-tally' => 'Numărătoare',
	'securepoll-tally-title' => 'Numărătoare: $1',
	'securepoll-tally-not-finished' => 'Ne pare rău, dar nu puteți efectua numărătoarea voturilor până când procesul de votare nu se va fi finalizat.',
	'securepoll-can-decrypt' => 'Înregistrarea alegerilor a fost criptată, însă cheia de decriptare este disponibilă.
Puteți alege fie să efectuați numărătoarea rezultatelor din baza de date, fie să efectuați numărătoarea unor rezultate criptate dintr-un fișier încărcat.',
	'securepoll-tally-no-key' => 'Ne pare rău, dar nu puteți efectua numărătoarea voturilor acestor alegeri, deoarece acestea sunt criptate, iar cheia de decriptare nu este disponibilă.',
	'securepoll-tally-local-legend' => 'Numărătoarea rezultatele stocate',
	'securepoll-tally-local-submit' => 'Creează o numărătoare',
	'securepoll-tally-upload-legend' => 'Încarcă un dump criptat',
	'securepoll-tally-upload-submit' => 'Creează o numărătoare',
	'securepoll-tally-error' => 'Eroare la interpretarea înregistrării voturilor. Nu se poate efectua o numărătoare.',
	'securepoll-no-upload' => 'Niciun fișier nu a fost încărcat. Nu se poate face numărătoarea rezultatelor.',
	'securepoll-dump-corrupt' => 'Fișierul dump este corupt și nu poate fi procesat.',
	'securepoll-tally-upload-error' => 'Eroare în timpul efectuării numărătorii din fișierul dump: $1',
	'securepoll-ranks' => 'Clasament final',
	'securepoll-average-score' => 'Scor mediu',
	'securepoll-round' => 'Runda $1',
	'securepoll-spoilt' => '(Anulate)',
	'securepoll-exhausted' => '(Epuizate)',
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
	'securepoll-round' => 'Turne $1',
	'securepoll-spoilt' => '(Spoilt)',
	'securepoll-exhausted' => '(Esaurite)',
);

/** Russian (Русский)
 * @author Dim Grits
 * @author HalanTul
 * @author Kaganer
 * @author Kv75
 * @author Rave
 * @author Renessaince
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
	'securepoll-bad-ballot-submission' => 'Ваш голос недействителен: $1',
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
	'securepoll-too-new' => 'К сожалению, вы не можете голосовать. Для участия в выборах ваша учётная запись должна была быть зарегистрирована до $1 $3, вы зарегистрированы $2 $4.',
	'securepoll-blocked' => 'Извините, вы не можете голосовать на выборах, если учётная запись была заблокирована.',
	'securepoll-blocked-centrally' => 'К сожалению, вы не можете голосовать на этих выборах, так как вы заблокированы по меньшей мере в $1 {{PLURAL:$1|вики|вики}}.',
	'securepoll-bot' => 'Извините, учётные записи с флагом бота не допускаются для участия в голосовании.',
	'securepoll-not-in-group' => 'Только члены группы $1 могут голосовать на этих выборах.',
	'securepoll-not-in-list' => 'Извините, вы не входите в список участников, допущенных для голосования на этих выборах.',
	'securepoll-list-title' => 'Список голосов: $1',
	'securepoll-header-timestamp' => 'Время',
	'securepoll-header-voter-name' => 'Имя',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ip' => 'IP',
	'securepoll-header-xff' => 'XFF',
	'securepoll-header-ua' => 'Агент пользователя',
	'securepoll-header-token-match' => 'CSRF',
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
	'securepoll-header-id' => 'ID',
	'securepoll-header-voter-type' => 'Тип голосующего',
	'securepoll-header-url' => 'URL-адрес',
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
	'securepoll-header-trans-id' => 'ID',
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
	'securepoll-round' => '$1 тур',
	'securepoll-spoilt' => '(Испорченные)',
	'securepoll-exhausted' => '(Исчерпаны)',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'securepoll' => 'Безпечне голосованя',
	'securepoll-desc' => 'Росшырїня про голосованя і вызвідованя',
	'securepoll-invalid-page' => 'Неплатна підсторінка „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Треба, жебы сьте  {{GENDER:|быв|была|быв}} адміністратор волеб, жебы сьте могли выконати тоту дїю.',
	'securepoll-too-few-params' => 'Недостаток параметрів про підсторінку (неплатный одказ).',
	'securepoll-invalid-election' => '«$1» — неправилный ідентіфікатор голосованя',
	'securepoll-welcome' => '<strong>Витайте, $1!</strong>',
	'securepoll-not-started' => 'Тото голосованя дотеперь не зачало.
Мало бы зачати в  $3, $2.',
	'securepoll-finished' => 'Тото голосованя скінчіло, уж не можете голосовати.',
	'securepoll-not-qualified' => 'Не сповнюєте условія про участь у тім голосованю: $1',
	'securepoll-change-disallowed' => 'У того голосованя сьте уж {{GENDER:|брав|брала|брав}} участь.
Перебачте, но знову голосовати не можете.',
	'securepoll-change-allowed' => '<strong>Позначка: Того голосованя сьте ся уж {{GENDER:|участнив|участнила|участнив}}.</strong>
Кідь хочете змінити свій голос, пошлите ниже уведеный формуларь.
Усвідомте собі, же кідь то зробите, ваш попередній голос не буде врахованый.',
	'securepoll-submit' => 'Одослати голос',
	'securepoll-gpg-receipt' => 'Дякуєме за ваше голосованя.

Кідь хочете, можете собі усховати наслїдне підтверджіня вашого голосованя:

<pre>$1</pre>',
	'securepoll-thanks' => 'Дякуєме вам, ваш голос быв записаный.',
	'securepoll-return' => 'Вернути ся на $1',
	'securepoll-encrypt-error' => 'Не подарило зашіфровати запис про ваш голос.
Ваш голос не быв записаный!

$1',
	'securepoll-no-gpg-home' => 'Не подарило ся створити домашнїй адресарь про GPG.',
	'securepoll-secret-gpg-error' => 'Хыба почас выконаня GPG.
Кідь хочете указати детайлы, наставте <code>$wgSecurePollShowErrorDetail=true;</code> в <tt>LocalSettings.php</tt>.',
	'securepoll-full-gpg-error' => 'Хыба выконаня GPG:

Команд: $1

Хыба:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG ключі суть неправилно наконфіґурованы.',
	'securepoll-gpg-parse-error' => 'Хыба інтерпретації выступу GPG.',
	'securepoll-no-decryption-key' => 'Не быв конфіґурованый ключ росшіфрованя.
Не годен росшіфровати.',
	'securepoll-jump' => 'Перейти на сервер голосованя',
	'securepoll-bad-ballot-submission' => 'Ваш голос не є платный: $1',
	'securepoll-unanswered-questions' => 'Мусите одповісти на вшыткы вопросы.',
	'securepoll-invalid-rank' => 'Неправилне місце. Кандідатам мусите дати місце міджі 1 і 999.',
	'securepoll-unranked-options' => 'Дакотры можности не были оцінены.
Мусите вшыткым можностям задати місце міджі 1 і 999.',
	'securepoll-invalid-score' => 'Оцінка мусить быти чісло од $1 до $2.',
	'securepoll-unanswered-options' => 'Мусите выповнити одповідь на вшыткы вопросы.',
	'securepoll-remote-auth-error' => 'Почас чітаня інформацій о вашім хосновательскім конту із сервера настала хыба.',
	'securepoll-remote-parse-error' => 'Почас інтерпретації одповідї од сервера настала хыба.',
	'securepoll-api-invalid-params' => 'Хыбны параметры.',
	'securepoll-api-no-user' => 'Не нашов ся хоснователь із заданым ID.',
	'securepoll-api-token-mismatch' => 'Незгодує ся безпечностный код, не годен ся приголосити.',
	'securepoll-not-logged-in' => 'Жебы сьте міг(могла) голосовати, мусите ся приголосити.',
	'securepoll-too-few-edits' => 'Перебачте, але не можете голосовати. У тых вольбах можуть голосовати лем хоснователї з найменєй $1 {{PLURAL:$1|едітованя|едітованями}}, у вас є $2.',
	'securepoll-too-new' => 'На жаль не можете голосовати. Про участь у тім голосованю бы ваше конто мусило быти основане перед $3, $1, {{gender:|зареґістровав|зареґістровала|зареґістровали}} сьте ся але в $4, $2.',
	'securepoll-blocked' => 'Перебачте, але не можете голосовати, покы є вам заблоковане едітованя.',
	'securepoll-blocked-centrally' => 'На жаль не можете голосовати, бо сьте {{gender:|блокованый|блокована|блокованы}} принайменшім на $1 {{PLURAL:$1|вікі|вікі}}..',
	'securepoll-bot' => 'Перебачте, але конта із статусом бота ся не можуть брати участь у тім голосованю.',
	'securepoll-not-in-group' => 'Лем члены ґрупы "$1" можуть брати участь у тім голосованює',
	'securepoll-not-in-list' => 'Перебачте, але не сьте в пририхтованім списку хоснователїв припущеных до участи на тім голосованю.',
	'securepoll-list-title' => 'Список голосів: $1',
	'securepoll-header-timestamp' => 'Час',
	'securepoll-header-voter-name' => 'Мено',
	'securepoll-header-voter-domain' => 'Домена',
	'securepoll-header-ua' => 'Переглядач кліента',
	'securepoll-header-cookie-dup' => 'Дуп.',
	'securepoll-header-strike' => 'Перечаркнути',
	'securepoll-header-details' => 'Детайлы:',
	'securepoll-strike-button' => 'Перечаркнути',
	'securepoll-unstrike-button' => 'Зняти перечаркнутя',
	'securepoll-strike-reason' => 'Причіна:',
	'securepoll-strike-cancel' => 'Сторно',
	'securepoll-strike-error' => 'Не подарило ся выконати перечаркнутя ці ёго зрушіня: $1',
	'securepoll-strike-token-mismatch' => 'Дата сеансу страчены',
	'securepoll-details-link' => 'Детайлы',
	'securepoll-details-title' => 'Детайлы голосованя: #$1',
	'securepoll-invalid-vote' => '«$1» — неправилный ідентіфікатор голосованя',
	'securepoll-header-voter-type' => 'Тіп голосуючого',
	'securepoll-voter-properties' => 'Властности голосуючого',
	'securepoll-strike-log' => 'Список перечаркнутых голосів',
	'securepoll-header-action' => 'Дїя',
	'securepoll-header-reason' => 'Причіна',
	'securepoll-header-admin' => 'Адміністратор',
	'securepoll-cookie-dup-list' => 'Дупліцітны хоснователї подля кукіс',
	'securepoll-dump-title' => 'Дамп: $1',
	'securepoll-dump-no-crypt' => 'У тых волеб не є про діспозіцію шіфрованый запис голосованя, бо у їх конфіґурації не є шіфрованя запнуте.',
	'securepoll-dump-not-finished' => 'Шіфрованый запис голосованя буде про діспозіцію аж по укончіню волеб, $1, $2',
	'securepoll-dump-no-urandom' => 'Не годен отворити<tt>/dev/urandom</tt>.
Про забезпечіня утаїня голосованя є шіфрованый запис голосованя доступный публічности лем тогды, же голосы можуть быти помішаны за помочі жрідла нагодных чісел.',
	'securepoll-urandom-not-supported' => 'Тот сервер не підпорує кріптоґрафічне ґенерованя нагодных чісел.
Про притаїня голосованя є шіфрованый запис голосованя публічный лем тогды, кідь голосы можуть быти замішаны за помочі безпечного жрідла нагодных чісел.',
	'securepoll-translate-title' => 'Переклад: $1',
	'securepoll-invalid-language' => 'Неправилный код языка «$1»',
	'securepoll-submit-translate' => 'Обновити',
	'securepoll-language-label' => 'Выбер языка:',
	'securepoll-submit-select-lang' => 'Перекласти',
	'securepoll-entry-text' => 'Ниже указаный список голосовань.',
	'securepoll-header-title' => 'Назва',
	'securepoll-header-start-date' => 'Датум початку',
	'securepoll-header-end-date' => 'Датум закінчіня',
	'securepoll-subpage-vote' => 'Голосовати',
	'securepoll-subpage-translate' => 'Переклад',
	'securepoll-subpage-list' => 'Список',
	'securepoll-subpage-dump' => 'Дамп',
	'securepoll-subpage-tally' => 'Зраховати',
	'securepoll-tally-title' => 'Почет голосів: $1',
	'securepoll-tally-not-finished' => 'Перебачте, не можете зраховати голосы, кідь голосованя іщі не скінчіло.',
	'securepoll-can-decrypt' => 'Запис голосованя быв зашіфрованый, але ключ про дешіфрованя є к діспозіції.
Можете собі выбрати, ці хочете зраховати резултаты в датабазї, або зраховати резултаты з начітаного файлу.',
	'securepoll-tally-no-key' => 'Тото голосованя не можете зраховати, бо голосы суть зашіфрованы і ключ про дешіфрованя не є доступный.',
	'securepoll-tally-local-legend' => 'Зраховати уложены резултаты',
	'securepoll-tally-local-submit' => 'Зробити зрахованя',
	'securepoll-tally-upload-legend' => 'Начітати шіфрованый запис (дамп)',
	'securepoll-tally-upload-submit' => 'Зробити зрахованя',
	'securepoll-tally-error' => 'Хыба почас спрацованя запису голосованя, голосованя ся не дасть зраховати.',
	'securepoll-no-upload' => 'Не быв начітаный жаден файл, голосованя ся не дасть зраховати.',
	'securepoll-dump-corrupt' => 'Файл із записом (дамп) є пошкодженый і не дасть за спрацовати.',
	'securepoll-tally-upload-error' => 'Хыба рахованя запису: $1',
	'securepoll-pairwise-victories' => 'Матріця взаємных выгер',
	'securepoll-strength-matrix' => 'Матріця силы стежок',
	'securepoll-ranks' => 'Конечный рейтінґ',
	'securepoll-average-score' => 'Середнє оцінїня',
	'securepoll-round' => '$1. коло',
	'securepoll-spoilt' => '(Неплатне)',
	'securepoll-exhausted' => '(Вычерпаны)',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 * @author Vibhijain
 */
$messages['sa'] = array(
	'securepoll-api-invalid-params' => 'अपुष्ट प्राचलक।',
	'securepoll-header-timestamp' => 'समय',
	'securepoll-header-voter-name' => 'नाम',
	'securepoll-header-voter-domain' => 'डोमेन',
	'securepoll-strike-reason' => 'कारणम् :',
	'securepoll-strike-cancel' => 'निवर्तयते',
	'securepoll-header-reason' => 'कारण',
	'securepoll-header-admin' => 'प्रबंधकाः',
	'securepoll-translate-title' => 'अनुवदति: $1',
	'securepoll-language-label' => 'वर भाषा:',
	'securepoll-submit-select-lang' => 'अनुवदति',
	'securepoll-header-title' => 'नाम',
	'securepoll-header-start-date' => 'प्रारंभ दिनाङ्क',
	'securepoll-header-end-date' => 'समाप्ति दिनाङ्क',
	'securepoll-subpage-vote' => 'मत',
	'securepoll-subpage-list' => 'सूची',
);

/** Sakha (Саха тыла)
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
	'securepoll-strength-matrix' => 'Матрица сил путей',
	'securepoll-ranks' => 'Раанганан бүтэһиктээх наардааһын',
	'securepoll-average-score' => 'Ортоку сыана',
);

/** Sardinian (Sardu)
 * @author Andria
 * @author Marzedu
 */
$messages['sc'] = array(
	'securepoll-header-voter-name' => 'Nùmene',
	'securepoll-header-title' => 'Nùmene',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 * @author Melos
 */
$messages['scn'] = array(
	'securepoll-list-title' => 'Elencu voti: $1',
	'securepoll-header-timestamp' => 'Tempu',
	'securepoll-header-voter-name' => 'Nomu',
	'securepoll-header-voter-domain' => 'Dominiu',
	'securepoll-header-ua' => 'Agente utenti',
	'securepoll-strike-button' => 'Annulla stu votu',
	'securepoll-unstrike-button' => 'Elimina annullamentu',
	'securepoll-strike-reason' => 'Mutivu:',
	'securepoll-strike-cancel' => 'Annulla',
	'securepoll-header-action' => 'Azzioni',
	'securepoll-header-reason' => 'Mutivu',
	'securepoll-header-title' => 'Nomu',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'securepoll' => 'Sigurno glasanje',
	'securepoll-desc' => 'Proširenje za izbore i ankete',
	'securepoll-invalid-page' => 'Nevaljana podstranica "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Morate biti administrator izbora da bi ste izvršili ovu akciju.',
	'securepoll-too-few-params' => 'Nema dovoljno parametara podstranice (nevaljan link).',
	'securepoll-invalid-election' => '"$1" nije valjan izborni ID.',
	'securepoll-welcome' => '<strong>Dobrodošli $1!</strong>',
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
	'securepoll-api-token-mismatch' => 'Ne podudara se sigurnosni token, ne može se prijaviti.',
	'securepoll-not-logged-in' => 'Morate se prijaviti za glasanje na ovim izborima',
	'securepoll-too-few-edits' => 'Žao nam je, ne možete glasati. Morate imati najmanje $1 {{PLURAL:$1|izmjenu|izmjene|izmjena}} da glasate na ovim izborima, Vi ste dosad napravili $2 izmjena.',
	'securepoll-too-new' => 'Žao nam je, ne možete glasati.  Vaš račun treba biti registrovan prije $1 da biste glasali na ovim izborima, vi ste registrovani dana $2.',
	'securepoll-blocked' => 'Žao nam je, ne možete trenutno glasati na ovim izborima ako ste trenutno blokirani za uređivanje.',
	'securepoll-blocked-centrally' => 'Žao nam je, vi ne možete glasati na ovim izborima ako ste blokirani na $1 ili više {{PLURAL:$1|wikija|wikija}}.',
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
	'securepoll-header-action' => 'Radnja',
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
	'securepoll-submit-translate' => 'Ažuriraj',
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
	'securepoll-tally-local-submit' => 'Napravi prikaz rezultata',
	'securepoll-tally-upload-legend' => 'Postavi šifriranu arhivu',
	'securepoll-tally-upload-submit' => 'Napravi prikaz rezultata (raspodjelu glasova)',
	'securepoll-tally-error' => 'Pogreška pri prijevodu zapisa glasa, nije moguće prikazati raspodjelu glasova.',
	'securepoll-no-upload' => 'Nijedna datoteka nije postavljena, ne mogu se prebrojati rezultati.',
	'securepoll-dump-corrupt' => 'Ispisana datoteka je oštećena i ne može biti obrađena.',
	'securepoll-tally-upload-error' => 'Pogreška pri prikazu rezultata iz ispisane datoteke: $1',
	'securepoll-pairwise-victories' => 'Parna matrica pobjednika',
	'securepoll-strength-matrix' => 'Matriks snage putanje',
	'securepoll-ranks' => 'Konačni poredak',
	'securepoll-average-score' => 'Prosječan rezultat',
	'securepoll-round' => 'Runda $1',
	'securepoll-spoilt' => '(Nevaljano)',
	'securepoll-exhausted' => '(Iskorišteno)',
);

/** Sinhala (සිංහල)
 * @author Budhajeewa
 * @author Calcey
 * @author Singhalawap
 * @author තඹරු විජේසේකර
 * @author පසිඳු කාවින්ද
 * @author බිඟුවා
 */
$messages['si'] = array(
	'securepoll' => 'සුරක්ෂිත ඡන්ද විමසීම',
	'securepoll-desc' => 'ඡන්ද හා සමීක්ෂණ සඳහා දිඟුව',
	'securepoll-invalid-page' => '"<nowiki>$1</nowiki>" වැරදි උපපිටුව',
	'securepoll-need-admin' => 'මෙම ක්‍රියාව සිදු කිරීම සඳහා ඔබ ඡන්ද පරිපාලකයෙකු විය යුතුය.',
	'securepoll-too-few-params' => 'අවැසි තරම් උපපිටු පරාමිති නොමැ. (වරදි සබැඳියකි).',
	'securepoll-invalid-election' => '"$1" යනු නිවැරදි ඡන්ද හැඳුනුමක් නොවේ',
	'securepoll-welcome' => '<strong>ආයුබෝවන් $1!</strong>',
	'securepoll-not-started' => 'මෙම මැතිවරණය තවම ආරම්භ කර නොමැත.
එය $2 වනදා $3ට ආරම්භවීමට නියමිතය.',
	'securepoll-finished' => 'මෙම ඡන්ද අවසන් වී ඇත,ඔබට තව දුරටත් ඡන්දය ලබා දිය නොහැකිය.',
	'securepoll-not-qualified' => 'මෙම ඡන්දයේදී ඡන්දය දීමට ඔබ සුදුසුකම් ලබා නැත: $1',
	'securepoll-change-disallowed' => 'ඔබ වරක් මෙහි මනාපය පළ කර තිබේ.
කනගාටුයි, නැවත ඊට ඉඩදිය නොහැක.',
	'securepoll-change-allowed' => '<strong>සටහන: ඔබ මෙම ඡන්ද විමසුමේ මීට පෙර මනාපය පළ කර ඇත.</strong>
පහත ෆෝරමය පුරවා එවීමෙන් ඔබේ මනාපය වෙනස් කළ හැක.
ඔබ මෙය කළහොත් ඔබේ පෙර මනාපය නොසලකා හැරෙන බව සලකන්න.',
	'securepoll-submit' => 'ඡන්දය ලබාදෙන්න',
	'securepoll-gpg-receipt' => 'ඡන්දය දීම ගැන ස්තුතියි.

ඔබ කැමතිනම්,ඔබේ ඡන්දයේ සාක්ෂියක් ලෙස පහත රිසිට්ටුව ඔබ ළඟ තබා ගත හැක:

<pre>$1</pre>',
	'securepoll-thanks' => 'ස්තුතියි,ඔබේ ඡන්දය ‍වාර්තාගවිය.',
	'securepoll-return' => '$1 ට නැවත යන්න',
	'securepoll-encrypt-error' => 'ඡන්ද පළකෙරුම් වාර්තාව ගුප්ත-කේතනය කෙරුමට නොහැකි විය.
ඔබේ ඡන්ද පළ කෙරුම වාර්තාගත නොවිනි!

$1',
	'securepoll-no-gpg-home' => 'GPG නිවස්න නාමාවලිය තැනුමට නොහැකිවිය.',
	'securepoll-secret-gpg-error' => 'GPG ය ක්‍රියාත්මක කිරීමේ දෝෂයකි.
වැඩි විස්තර සඳහා LocalSettings.phpහි $wgSecurePollShowErrorDetail=true; භාවිතා කරන්න.',
	'securepoll-full-gpg-error' => 'GPG ය ක්‍රියාත්මක කෙරුමේ දෝෂයකි:

විධානය: $1

දෝෂය:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG යතුරු වැරදි ලෙස සකසා ඇත.',
	'securepoll-gpg-parse-error' => 'GPG ප්‍රතිදානය අර්ථ-පැහැදුමේ දෝෂයකි.',
	'securepoll-no-decryption-key' => 'No decryption key is configured.
Cannot decrypt.',
	'securepoll-jump' => 'ඡන්දය දෙන සේවාදායකයට යන්න',
	'securepoll-bad-ballot-submission' => 'ඔබගේ ඡන්දය අවලංගුයි :$1',
	'securepoll-unanswered-questions' => 'ඔබ සියලුම ප්‍රශ්නවලට පිළිතුරු සැපයිය යුතුය.',
	'securepoll-invalid-rank' => 'වැරදි තරාතිරමකි. ඔබ අපේක්‍ෂකයන්ට 1 හා 999 අතර තරාතිරමක් ලබාදිය යුතුය.',
	'securepoll-unranked-options' => 'ඇතැම් විකල්ප තරාතිරම් කොට නොමැත
ඔබ සියළු විකල්ප වලට 1 හා 999 අතර තරාතිරමක් ලබාදිය යුතුය.',
	'securepoll-invalid-score' => 'ලකුණ $1 හා $2 අතර අංකයක් විය යුතුය.',
	'securepoll-unanswered-options' => 'සෑම ප්‍රශ්නයක් සඳහාම ඔබ ප්‍රතිචාරයක් දිය යුතුය.',
	'securepoll-remote-auth-error' => 'සේවාදායකයෙන් ඔබේ ගිණුම් තොරතුරු ගෙනයෑමේ දෝෂය.',
	'securepoll-remote-parse-error' => 'සේවාදායකයෙන් අවසරදීමේ ප්‍රතිචාරය පහදාදීමේ දෝෂය.',
	'securepoll-api-invalid-params' => 'අවලංගු පරාමිති.',
	'securepoll-api-no-user' => 'දෙන ලද හැඳුනුම සහිත පරිශීලකයන් කිසිවෙකු හමු නොවිනි.',
	'securepoll-api-token-mismatch' => 'ආරක්‍ෂණ සංකේතය නොගැලපෙන බැවින් ඇතුළුවිය නොහැක.',
	'securepoll-not-logged-in' => 'මෙම ඡන්ද විමසීමේදී ඡන්දය දීම සඳහා ඔබ ප්‍රවිෂ්ට විය යුතුය.',
	'securepoll-too-few-edits' => 'සමාවෙන්න, ඔබට ඡන්දය පළ කළ නොහැක. මෙම ඡන්දයේදී ඡන්දය පළ කෙරුමට අවම වශයෙන් සංස්කරණ $1 {{PLURAL:$1|ක්|ක්}} හෝ කර තිබිය යුතුය, ඔබ කර ඇත්තේ $2 කි.',
	'securepoll-too-new' => 'කණගාටුයි, ඔබට මනාප දිය නොහැක. මෙම ඡන්දය සඳහා මනාප ලබා දීමට නම් ඔබේ ගිණුම $1 ට පෙර $3 හී ලියාපදිංචි කර තිබිය යුතුය, ඔබ ලියාපදිංචි වුයේ $2 දින $4 දීය.',
	'securepoll-blocked' => 'කනගාටුයි, ඔබ සංස්කරණ වාරණයකට ලක්ව ඇති බැවින් මෙහි ඡන්‍දය පළ කළ නොහැක.',
	'securepoll-blocked-centrally' => 'කණගාටුයි, ඔබ විසින් $1 {{PLURAL:$1|විකියක|විකිවල}} වාරණය වී නම් මෙම ඡන්දය සඳහා මනාප ලබා දිය නොහැක.',
	'securepoll-bot' => 'කනගාටුයි, රොබෝවරුන් සහිත පරිශීලක ගිණුම් හිමියනට මෙහි ඡන්‍දය පළ කළ නොහැක.',
	'securepoll-not-in-group' => '“$1“ කණ්ඩායමේ අයට මෙහි මනාපය පළ කළ හැක.',
	'securepoll-not-in-list' => 'සමාවෙන්න, ඡන්දය පළ කිරීමට අවසර ලබා ඇති පරිශීලක ලයිස්තුවේ ඔබ නැත.',
	'securepoll-list-title' => 'මනාප සංඛ්‍යාව: $1',
	'securepoll-header-timestamp' => 'වේලාව',
	'securepoll-header-voter-name' => 'නම',
	'securepoll-header-voter-domain' => 'වසම:',
	'securepoll-header-ua' => 'පරිශීලක නියෝජිත',
	'securepoll-header-cookie-dup' => 'ඩප්',
	'securepoll-header-strike' => 'කපා හරින්න',
	'securepoll-header-details' => 'විස්තර',
	'securepoll-strike-button' => 'කපා හරින්න',
	'securepoll-unstrike-button' => 'නොකපාහරින්න',
	'securepoll-strike-reason' => 'හේතුව:',
	'securepoll-strike-cancel' => 'අත් හරින්න',
	'securepoll-strike-error' => 'කපාහැරුම්/නොකපාහැරුම් දෝෂයකි: $1',
	'securepoll-strike-token-mismatch' => 'සැසි දත්ත අහිමිවිය',
	'securepoll-details-link' => 'විස්තර',
	'securepoll-details-title' => 'ඡන්ද තොරතුරු: #$1',
	'securepoll-invalid-vote' => '"$1" යනු නිවැරදි ඡන්ද හැඳුනුමක් නොවේ',
	'securepoll-header-voter-type' => 'ඡන්ද දායක වර්ගය',
	'securepoll-voter-properties' => 'ඡන්ද දායක වත්කම්',
	'securepoll-strike-log' => 'කපාහැරුම් ලොගය',
	'securepoll-header-action' => 'කාර්යය',
	'securepoll-header-reason' => 'හේතුව',
	'securepoll-header-admin' => 'පරිපාලක',
	'securepoll-cookie-dup-list' => 'කුකී පිටපත් පරිශීලකයින්',
	'securepoll-dump-title' => 'නික්ෂේපය: $1',
	'securepoll-dump-no-crypt' => 'ගුප්ත කේතනය යොදාගැනුමට මෙම ඡන්ද විමසුම සකසා නොමැති නිසා, ගුප්ත-කේතිත ඡන්ද විමසුම් වාර්තාවක් මෙම ඡන්ද විමසුම සඳහා ලබාගත නොහැක.',
	'securepoll-dump-not-finished' => 'ගුප්ත-කේතිත ඡන්ද විමසුම් වාර්තා ලබාගත හැක්කේ $1දා $2 ට පසුව පමණි',
	'securepoll-dump-no-urandom' => '/dev/urandom විවෘත කළ නොහැක.
ඡන්ද දායක පෞද්ගලිකත්වය ආරක්‍ෂා කෙරුම සඳහා ගුප්ත-කේතිත ඡන්ද විමසුම් වාර්තා ප්‍රසිද්ධයේ ලබාගත හැක්කේ ඒවා අහඹු සංඛ්‍යා සමූහයක් සමග මිශ්‍ර කළ හැකි අවස්ථාවල පමණි.',
	'securepoll-urandom-not-supported' => 'මෙම සේවාදායකය ගුප්ත-කේතන අහඹු සංඛ්‍යා ජනනයට සහය නොදක්වයි.
ඡන්ද දායක පෞද්ගලිකත්වය ආරක්‍ෂා කෙරුම සඳහා ගුප්ත-කේතිත ඡන්ද විමසුම් වාර්තා ප්‍රසිද්ධයේ ලබාගත හැක්කේ ඒවා අහඹු සංඛ්‍යා සමූහයක් සමග මිශ්‍ර කළ හැකි අවස්ථාවල පමණි.',
	'securepoll-translate-title' => 'පරිවර්තනය කරන්න: $1',
	'securepoll-invalid-language' => '"$1" වැරදි භාෂා කේතය',
	'securepoll-submit-translate' => 'යාවත්කාලීනය',
	'securepoll-language-label' => 'භාෂාව තෝරන්න:',
	'securepoll-submit-select-lang' => 'පරිවර්තනය කරන්න',
	'securepoll-entry-text' => 'පහත දැක්වෙන්නේ ඡන්ද විමසුම් ලයිස්තුවයි.',
	'securepoll-header-title' => 'නම',
	'securepoll-header-start-date' => 'ආරම්භක දිනය',
	'securepoll-header-end-date' => 'අවසන් දිනය',
	'securepoll-subpage-vote' => 'ඡන්දය දෙන්න',
	'securepoll-subpage-translate' => 'පරිවර්තනය කරන්න',
	'securepoll-subpage-list' => 'ලැයිස්තුව',
	'securepoll-subpage-dump' => 'අත්හරින්න',
	'securepoll-subpage-tally' => 'සැසඳෙයි',
	'securepoll-tally-title' => 'සැසඳුම: $1',
	'securepoll-tally-not-finished' => 'සමාවන්න, ඡන්දය පළ කෙරුම නිමවනතෙක් ඔබට ඡන්දය සැසඳිය නොහැක.',
	'securepoll-can-decrypt' => 'ඡන්ද විමසුම් වාර්තා ගුප්ත-කේතිත නමුත්, විකේතන යතුර ලබාගත හැකිව පවතී.
ඔබට එක්කෝ දත්ත මූලයේ මේ වන විට පවතින ප්‍රතිඵල සැසඳුම, හෝ පටවන ලද ගොනුවක ගුප්ත-කේතිත ප්‍රතිඵල සැසඳුම හෝ කළ හැක.',
	'securepoll-tally-no-key' => 'ගුප්ත-කේත-විකේතන යතුර ලබාගත නොහැකි නිසා ඔබට මෙම ඡන්දය සැසඳිය නොහැක, මන්ද ඡන්ද ප්‍රකාශකිරීම් ගුප්ත-කේතිතය.',
	'securepoll-tally-local-legend' => 'තැන්පත් කළ ප්‍රතිඵල සසඳන්න',
	'securepoll-tally-local-submit' => 'සැසඳුම තනන්න',
	'securepoll-tally-upload-legend' => 'සුරක්ෂිත ඩම්ප් එකක් උඩුගත කරන්න',
	'securepoll-tally-upload-submit' => 'සැසඳුම තනන්න',
	'securepoll-tally-error' => 'ඡන්ද වාර්තා අර්ථ-පැහැදුමේ දෝෂයකි, සැසඳුමක් තැනිය නොහැක.',
	'securepoll-no-upload' => 'ගොනුවක් පටවා නැත, ප්‍රතිඵල සැසඳිය නොහැක.',
	'securepoll-dump-corrupt' => 'නික්ෂේප ගොනුව දෝෂ සහගත බැවින් ක්‍රියාවට බඳුන් කළ නොහැක.',
	'securepoll-tally-upload-error' => 'නික්ෂේප ගොනුව සැසඳුමේ දෝෂයකි: $1',
	'securepoll-pairwise-victories' => 'යුගලානුකූල ජයග්‍රහන න්‍යාසය',
	'securepoll-strength-matrix' => 'මාර්ග ශක්ති න්‍යාසය',
	'securepoll-ranks' => 'අවසන් ශ්‍රේණිගතකෙරුම',
	'securepoll-average-score' => 'සාමාන්‍ය ලකුණ',
	'securepoll-round' => '$1 වන වටය',
	'securepoll-spoilt' => '(නරක් වූ)',
	'securepoll-exhausted' => '(හිස් වූ)',
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

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'securepoll' => 'VarnoGlasovanje',
	'securepoll-desc' => 'Razširitev za volitve in ankete',
	'securepoll-invalid-page' => 'Neveljavna podstran »<nowiki>$1</nowiki>«',
	'securepoll-need-admin' => 'Za izvedbo tega dejanja morate biti administrator volitev.',
	'securepoll-too-few-params' => 'Ni dovolj parametrov podstrani (neveljavna povezava).',
	'securepoll-invalid-election' => '»$1« ni veljaven volilni ID.',
	'securepoll-welcome' => '<strong>Dobrodošli, $1!</strong>',
	'securepoll-not-started' => 'Volitve se še niso začele.
Začetek je načrtovan dne $2 ob $3.',
	'securepoll-finished' => 'Volitve so zaključene, zato ne morete več glasovati.',
	'securepoll-not-qualified' => 'Niste primerni za glasovanje na teh volitvah: $1',
	'securepoll-change-disallowed' => 'Na teh volitvah ste že glasovali.
Žal ne morete ponovno glasovati.',
	'securepoll-change-allowed' => '<strong>Opomba: V teh volitvah ste že volili.</strong>
Svoj glas lahko spremenite s potrditvijo spodnjega obrazca.
Pomnite, da če to storite, bo vaš prvotni glas zavržen.',
	'securepoll-submit' => 'Pošlji glas',
	'securepoll-gpg-receipt' => 'Hvala za glasovanje.

Če želite, lahko obdržite spodnje potrdilo kot dokaz o vašem glasovanju:

<pre>$1</pre>',
	'securepoll-thanks' => 'Hvala, vaš glas je bil zabeležen.',
	'securepoll-return' => 'Vrnitev na $1',
	'securepoll-encrypt-error' => 'Šifriranje zapisa vašega glasu je spodletelo.
Vaš glas ni bil zabeležen!

$1',
	'securepoll-no-gpg-home' => 'Ne morem ustvariti domače mape GPG.',
	'securepoll-secret-gpg-error' => 'Napaka pri izvajanju GPG.
Uporabite $wgSecurePollShowErrorDetail=true; v LocalSettings.php za prikaz več informacij.',
	'securepoll-full-gpg-error' => 'Napaka pri izvajanju GPG:

Ukaz: $1

Napaka:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Ključi GPG so konfigurirani nepravilno.',
	'securepoll-gpg-parse-error' => 'Napaka pri tolmačenju izhoda GPG.',
	'securepoll-no-decryption-key' => 'Konfiguriran ni noben dešifrirni ključ.
Ne morem dešifrirati.',
	'securepoll-jump' => 'Pojdi na glasovalni strežnik',
	'securepoll-bad-ballot-submission' => 'Vaš glas je bil neveljaven: $1',
	'securepoll-unanswered-questions' => 'Odgovoriti morate na vsa vprašanja.',
	'securepoll-invalid-rank' => 'Neveljavna uvrstitev. Kandidatom morate določiti uvrstitev med 1 in 999.',
	'securepoll-unranked-options' => 'Nekatere možnosti niso bile uvrščene.
Vsem možnostim morate določiti uvrstitev med 1 in 999.',
	'securepoll-invalid-score' => 'Ocena mora biti število med $1 in $2.',
	'securepoll-unanswered-options' => 'Odgovoriti morate na vsako vprašanje.',
	'securepoll-remote-auth-error' => 'Napaka pri pridobivanju informacij o vašem računu s strežnika.',
	'securepoll-remote-parse-error' => 'Napaka pri tolmačenju pooblastitvenega odgovora od strežnika.',
	'securepoll-api-invalid-params' => 'Neveljavni parametri.',
	'securepoll-api-no-user' => 'Najden ni bil noben uporabnik z danim ID.',
	'securepoll-api-token-mismatch' => 'Neujemanje varnostnega žetona; ne morem vas prijaviti.',
	'securepoll-not-logged-in' => 'Za glasovanje na teh volitvah se morate prijaviti.',
	'securepoll-too-few-edits' => 'Oprostite, ne morete voliti. Morali bi storiti najmanj $1 {{PLURAL:$1|urejanje|urejanji|urejanja|urejanj}} za voljenje na teh volitvah; naredili ste jih $2.',
	'securepoll-too-new' => 'Oprostite, ne morete glasovati. Za glasovanje mora biti vaš račun registriran pred dnem $1 ob $3; registrirali ste se dne $2 ob $4.',
	'securepoll-blocked' => 'Oprostite, ne morete voliti na teh volitvah, če vam je urejanje trenutno preprečeno.',
	'securepoll-blocked-centrally' => 'Oprostite, na teh volitvah ne morete glasovati, ker ste blokirani na vsaj $1 {{PLURAL:$1|wikiju|wikijih}}.',
	'securepoll-bot' => 'Oprostite, računom z oznako robota ni dovoljeno voliti na teh volitvah.',
	'securepoll-not-in-group' => 'Samo člani skupine »$1« lahko volijo na teh volitvah.',
	'securepoll-not-in-list' => 'Oprostite, vendar niste na predpripravljenem seznamu uporabnikov, ki so pooblaščeni za voljenje na teh volitvah.',
	'securepoll-list-title' => 'Seznam glasov: $1',
	'securepoll-header-timestamp' => 'Čas',
	'securepoll-header-voter-name' => 'Uporabnik',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Uporabniški agent',
	'securepoll-header-cookie-dup' => 'Dvoj',
	'securepoll-header-strike' => 'Prečrtaj',
	'securepoll-header-details' => 'Podrobnosti',
	'securepoll-strike-button' => 'Prečrtaj',
	'securepoll-unstrike-button' => 'Odčrtaj',
	'securepoll-strike-reason' => 'Razlog:',
	'securepoll-strike-cancel' => 'Prekliči',
	'securepoll-strike-error' => 'Napaka pri izvajanju prečrtanja/odčrtanja: $1',
	'securepoll-strike-token-mismatch' => 'Podatki seje so izgubljeni',
	'securepoll-details-link' => 'Podrobnosti',
	'securepoll-details-title' => 'Podrobnosti glasovanja: #$1',
	'securepoll-invalid-vote' => '»$1« ni veljaven volilni ID',
	'securepoll-header-voter-type' => 'Vrsta volivca',
	'securepoll-voter-properties' => 'Podrobnosti volivca',
	'securepoll-strike-log' => 'Dnevnik črtanja',
	'securepoll-header-action' => 'Dejanje',
	'securepoll-header-reason' => 'Razlog',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Piškotki podvojenih uporabnikov',
	'securepoll-dump-title' => 'Odloži: $1',
	'securepoll-dump-no-crypt' => 'Za te volitve ni na voljo šifriranega volilnega zapisa, ker volitve niso konfigurirane tako, da bi uporabljale šifriranje.',
	'securepoll-dump-not-finished' => 'Šifrirani volilni zapisi so na voljo šele po datumu zaključka dne $1 ob $2',
	'securepoll-dump-no-urandom' => 'Ne morem odpreti /dev/urandom. 
Za zagotavljanje zasebnosti volivcev so šifrirani volilni zapisi javno vidni šele po tem, ko so lahko premešani z varnim tokom naključnih števil.',
	'securepoll-urandom-not-supported' => 'Ta strežnik ne podpira kriptografskega ustvarjanja naključnih števil.
Za zagotavljanje zasebnosti volivcev so šifrirani volilni zapisi javno vidni šele po tem, ko so lahko premešani z varnim tokom naključnih števil.',
	'securepoll-translate-title' => 'Prevedi: $1',
	'securepoll-invalid-language' => 'Neveljavna koda jezika »$1«',
	'securepoll-submit-translate' => 'Posodobi',
	'securepoll-language-label' => 'Izberite jezik:',
	'securepoll-submit-select-lang' => 'Prevedi',
	'securepoll-entry-text' => 'Spodaj je seznam glasovnic.',
	'securepoll-header-title' => 'Ime',
	'securepoll-header-start-date' => 'Datum začetka',
	'securepoll-header-end-date' => 'Datum zaključka',
	'securepoll-subpage-vote' => 'Glasuj',
	'securepoll-subpage-translate' => 'Prevedi',
	'securepoll-subpage-list' => 'Seznam',
	'securepoll-subpage-dump' => 'Odloži',
	'securepoll-subpage-tally' => 'Evidentiraj',
	'securepoll-tally-title' => 'Evidenca: $1',
	'securepoll-tally-not-finished' => 'Žal ne morete evidentirati volitev preden se glasovanje zaključi.',
	'securepoll-can-decrypt' => 'Volitveni zapis je šifriran, vendar je na voljo ključ za dešifriranje.
	Izberete lahko da ali združite trenutne rezultate v zbirki podatkov ali da združite šifrirane rezultate iz naložene datoteke.',
	'securepoll-tally-no-key' => 'Ne morete evidentirati teh volitev, saj so glasovi šifrirani in dešifrirni ključ ni na voljo.',
	'securepoll-tally-local-legend' => 'Evidentiraj shranjene rezultate',
	'securepoll-tally-local-submit' => 'Ustvari evidenco',
	'securepoll-tally-upload-legend' => 'Naloži šifriran odložek',
	'securepoll-tally-upload-submit' => 'Ustvari evidenco',
	'securepoll-tally-error' => 'Napaka pri tolmačenju zapisov glasovanja, ne morem ustvariti evidence.',
	'securepoll-no-upload' => 'Nobena datoteka ni bila naložena, ni mogoče evidentirati rezultatov.',
	'securepoll-dump-corrupt' => 'Odložena datoteka je poškodovana in je ni mogoče obdelati.',
	'securepoll-tally-upload-error' => 'Napaka pri evidentiranju odložene datoteke: $1',
	'securepoll-pairwise-victories' => 'Matrica zmage parov',
	'securepoll-strength-matrix' => 'Matrica moči poti',
	'securepoll-ranks' => 'Končna uvrstitev',
	'securepoll-average-score' => 'Povprečni rezultat',
	'securepoll-round' => 'Krog $1',
	'securepoll-spoilt' => '(Neveljavno)',
	'securepoll-exhausted' => '(Izkoriščeno)',
);

/** Albanian (Shqip)
 * @author Mikullovci11
 * @author Olsi
 * @author Vinie007
 */
$messages['sq'] = array(
	'securepoll' => 'SondazhiSigurt',
	'securepoll-desc' => 'Shtesë për zgjedhje dhe anketa',
	'securepoll-invalid-page' => 'Nënfaqe e pavlefshme: "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Ju duhet të jeni një administrues zgjedhor për të kryer këtë veprim.',
	'securepoll-too-few-params' => 'Parametra të pamjaftueshëm për nënfaqen (lidhje e pavlefshme).',
	'securepoll-invalid-election' => '"$1" nuk është një zgjedhje ID e vlefshme.',
	'securepoll-welcome' => '<strong>Mirë se vini $1!</strong>',
	'securepoll-not-started' => 'Kjo zgjedhje nuk ka filluar akoma.
Është planifikuar të fillojë më $2 në orën $3.',
	'securepoll-finished' => 'Kjo zgjedhje ka përfunduar, ju nuk mund të votoni më.',
	'securepoll-not-qualified' => 'Ju nuk jeni i kualifikuar për të votuar në këtë zgjedhje: $1',
	'securepoll-change-disallowed' => 'Ju keni votuar në këtë zgjedhje më parë.
Na vjen keq, ju nuk mund të të votoni përsëri.',
	'securepoll-change-allowed' => '<strong>Vini re: Ju keni votuar në këtë zgjedhje më parë.</strong>
Ju mund ta ndryshoni votën tuaj duke paraqitur formularin e mëposhtëm.
Vini re se nëse e bëni këtë, vota juaj origjinale do të humbasë.',
	'securepoll-submit' => 'Paraqitni votën',
	'securepoll-gpg-receipt' => 'Faleminderit për votimin.

Nëse dëshironi, ju mund të mbani një faturë si provë për votën tuaj:

<pre>$1</pre>',
	'securepoll-thanks' => 'Falemnderit, vota juaj është regjistruar.',
	'securepoll-return' => 'Kthehuni tek $1',
	'securepoll-encrypt-error' => 'Dështoi regjistrimi i votës suaj.
vota juaj nuk është regjistruar!

$1',
	'securepoll-no-gpg-home' => 'Nuk mund të krijojë drejtorinë PGP.',
	'securepoll-secret-gpg-error' => 'Gabim gjatë ekzekutimit të GPG.
Përdorni $wgSecurePollShowErrorDetail=true; në LocalSettings.php për të treguar më shumë detaje.',
	'securepoll-full-gpg-error' => 'Gabim gjatë ekzekutimit GPG:

Komanda: $1

Gabimi:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Çelësat GPG janë konfiguruar gabimisht.',
	'securepoll-gpg-parse-error' => 'Gabim gjatë interpretimit të GPG.',
	'securepoll-no-decryption-key' => 'Asnjë çelës nuk është i konfiguruar.
Nuk mund të decrypt.',
	'securepoll-jump' => 'Shkoni tek serveri i votimit',
	'securepoll-bad-ballot-submission' => 'Vota juaj ishte e pavlefshme: $1',
	'securepoll-unanswered-questions' => 'Ju duhet tu përgjigjeni të gjitha pyetjeve.',
	'securepoll-invalid-rank' => 'Rank i pavlefshëm. Ju duhet tu jepni kandidatëve një rank ndërmjet 1 dhe 999.',
	'securepoll-unranked-options' => 'Disa opsione nuk u renditën.
Ju  duhet tu jepni të gjitha opsioneve një renditej ndërmjet 1 dhe 999.',
	'securepoll-invalid-score' => 'Rezultati duhet të jetë një numër ndërmjet $1 dhe $2.',
	'securepoll-unanswered-options' => 'Ju duhet të jepni një përgjigje për çdo pyetje.',
	'securepoll-remote-auth-error' => 'Gabim gjatë ngarkimit të të dhlnave tuaja të llogarisë nga serveri.',
	'securepoll-remote-parse-error' => 'Gabim gjatë interpretimit të përgjigjes së autorizuar nga serveri.',
	'securepoll-api-invalid-params' => 'Parametra të pavlefshëm.',
	'securepoll-api-no-user' => 'Asnjë përdorues nuk u gjet me ID-në e dhënë.',
	'securepoll-api-token-mismatch' => 'Shenja e sigurisë mungon, nuk mund të hyjë brenda.',
	'securepoll-not-logged-in' => 'Ju duhet të hyni brenda për të votuar në këtë zgjedhje',
	'securepoll-too-few-edits' => 'Na vjen keq, ju nuk mund të votoni. Ju duhe të keni bërë të paktën $1 {{PLURAL:$1|redaktim|redaktime}} për të votuar në këtë zgjedhje, ju keni bërë $2.',
	'securepoll-too-new' => 'Na vjen keq, ju nuk mund të votoni. Llogaria juaj duhet të jetë e regjistruar përpara datës $1 ora $3 për të votuar në këto zgjedhje, ju u regjistruat më datë $2 në orën $4.',
	'securepoll-blocked' => 'Na vjen keq, ju nuk mund të votoni në këtë zgjedhje nëse jeni aktualisht bllokuar nga redaktimi.',
	'securepoll-blocked-centrally' => 'Na vjen keq, ju nuk mund të votoni në këto zgjedhje përderisa ju jeni bllokuar në të paktën $1 {{PLURAL:$1|wiki|wiki}}.',
	'securepoll-bot' => 'Na vjen keq, llogaritë me flamur robori nuk lejohen që të votojnë në këtë zgjedhje.',
	'securepoll-not-in-group' => 'Vetëm anëtarët e grupit "$1" mund të votojnë në këtë zgjedhje.',
	'securepoll-not-in-list' => 'Na vjen keq, ju nuk listën e paracaktuar të përdoruesve të autorizuar për të votuar në këtë zgjedhje.',
	'securepoll-list-title' => 'Lista e Votave: $1',
	'securepoll-header-timestamp' => 'Kohë',
	'securepoll-header-voter-name' => 'Emri',
	'securepoll-header-voter-domain' => 'Domen',
	'securepoll-header-ua' => 'Agjent përdorues',
	'securepoll-header-cookie-dup' => 'Dublikatë',
	'securepoll-header-strike' => 'Nënvizoj',
	'securepoll-header-details' => 'Detajet',
	'securepoll-strike-button' => 'Nënvizoj',
	'securepoll-unstrike-button' => 'Zhbëje nënvizojën',
	'securepoll-strike-reason' => 'Arsyeja:',
	'securepoll-strike-cancel' => 'Anulo',
	'securepoll-strike-error' => 'Gabim gjatë performimit strike/unstrike: $1',
	'securepoll-strike-token-mismatch' => 'Sesioni i të dhënave humbi',
	'securepoll-details-link' => 'Detajet',
	'securepoll-details-title' => 'Detajet e votës: #$1',
	'securepoll-invalid-vote' => '"$1" nuk është ID e vlefshme',
	'securepoll-header-voter-type' => 'Lloji i votuesit',
	'securepoll-voter-properties' => 'Vetitë e votuesit',
	'securepoll-strike-log' => 'Regjistri strike',
	'securepoll-header-action' => 'Veprimet',
	'securepoll-header-reason' => 'Arsyeja',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Cookie kopjuar përdoruesit',
	'securepoll-dump-title' => 'Largo: $1',
	'securepoll-dump-no-crypt' => 'Asnjë regjistrim i kriptuar nuk është i munshëm për këtë zgjedhje, sepse zgjedhja nuk është konfiguruar të përdorë kriptimin.',
	'securepoll-dump-not-finished' => 'Regjistrimet e zgjedhjes së kriptuar janë të mundshme vetëm pas datës së përfundimit më $1 në orën $2',
	'securepoll-dump-no-urandom' => 'Nuk mund të hapet /dev/urandom.
Për të ruajtur fshehtësinë e votusve, regjistrimet e zgjedhjeve të kriptuara janë të mundshme publikisht vetëm ata mund të riorganizohen me një numër rastësor të sigurt.',
	'securepoll-urandom-not-supported' => 'Ky server nuk mbështet gjenerimin e numrit të rastësishëm kriptografik.
Për të ruajtur fshehtësinë e votuesve, regjistrimet e zgjedhjeve të kriptuara janë të mundshme publikisht vetëm kur ata mund të riorganizohen më një numër rastësor të sigurt.',
	'securepoll-translate-title' => 'Përkthime: $1',
	'securepoll-invalid-language' => 'Kod gjuhe i pavlefshëm "$1"',
	'securepoll-submit-translate' => 'Përditësime të reja',
	'securepoll-language-label' => 'Zgjidh gjuhën',
	'securepoll-submit-select-lang' => 'Përkthime',
	'securepoll-entry-text' => 'Më poshtë është lista e sondazheve.',
	'securepoll-header-title' => 'Emri',
	'securepoll-header-start-date' => 'Data e fillimit',
	'securepoll-header-end-date' => 'Data e përfundimit',
	'securepoll-subpage-vote' => 'Voto',
	'securepoll-subpage-translate' => 'Përkthime',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Largo',
	'securepoll-subpage-tally' => 'Grup',
	'securepoll-tally-title' => 'Grupi: $1',
	'securepoll-tally-not-finished' => 'Na vjen keq, ju nuk mund ta shënoni këtë zgjedhje pa mbaruar votimi.',
	'securepoll-can-decrypt' => 'Regjistrimi i zgjedhjeve është kriptuar, por çelësi i dekriptimit është i mundshëm.
Ju mund të zgjidhni ose të shënoni rezultatin e tanishëm në bazën e të dhënave, ose të shënoni rezultatet nga një skedë e ngarkuar.',
	'securepoll-tally-no-key' => 'Ju nuk mund ta shënoni këtë zgjedhje, sepse votat janë të kriptuara dhe çelësi i dekriptimit nuk është i mundshëm.',
	'securepoll-tally-local-legend' => 'Shënoni rezultatet e ruajtura',
	'securepoll-tally-local-submit' => 'Krijo grup',
	'securepoll-tally-upload-legend' => 'Upload encrypted dump',
	'securepoll-tally-upload-submit' => 'Krijo grup',
	'securepoll-tally-error' => 'Gabim gjatë interpretimit së regjistrimit të votës, nuk mund të prodhojë një grup.',
	'securepoll-no-upload' => 'Asnjë skedë nuk u ngarkua, nuk mund të shënohen rezultatet.',
	'securepoll-dump-corrupt' => 'Skeda e larguar është e prishur dhe nuk mund të procesohet.',
	'securepoll-tally-upload-error' => 'Gabim gjatë shënimit të skedës së larguar: $1',
	'securepoll-pairwise-victories' => 'Pairwise victory matrix',
	'securepoll-strength-matrix' => 'Path strength matrix',
	'securepoll-ranks' => 'Rendtija përfundimtare',
	'securepoll-average-score' => 'Rezultati mesatar',
	'securepoll-round' => 'Round $1',
	'securepoll-spoilt' => '(Spoilt)',
	'securepoll-exhausted' => '(Lodhur)',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Милан Јелисавчић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'securepoll' => 'Безбедно гласање',
	'securepoll-desc' => 'Проширење за изборе и анкете',
	'securepoll-invalid-page' => 'Неисправна подстраница „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Треба да будете изборни администратор да бисте извршили ову радњу.',
	'securepoll-too-few-params' => 'Нема довољно параметара подстранице (неисправна веза).',
	'securepoll-invalid-election' => '„$1“ не представља исправну назнаку.',
	'securepoll-welcome' => '<strong>Добро дошли, $1!</strong>',
	'securepoll-not-started' => 'Избори још нису започети.
Предвиђено је да почну $2 у $3.',
	'securepoll-finished' => 'Избори су завршени. Више не можете да гласате.',
	'securepoll-not-qualified' => 'Нисте квалификовани да гласате на овим изборима: $1',
	'securepoll-change-disallowed' => 'Већ сте гласали на овим изборима.
Нажалост, не можете да гласате опет.',
	'securepoll-change-allowed' => '<strong>Напомена: већ сте гласали на овим изборима.</strong>
Можете да промените глас тако што ћете попунити образац испод.
Ако то урадите, ваш првобитни глас ће бити поништен.',
	'securepoll-submit' => 'Пошаљи глас',
	'securepoll-gpg-receipt' => 'Хвала вам што сте гласали.

Ако желите, можете да задржите ову потврду као доказ да сте гласали:

<pre>$1</pre>',
	'securepoll-thanks' => 'Хвала, ваш глас је заведен.',
	'securepoll-return' => 'Назад на $1',
	'securepoll-encrypt-error' => 'Не могу да шифрујем гласачки запис.
Ваш глас није заведен!

$1',
	'securepoll-no-gpg-home' => 'Не могу да направим основну фасциклу за GPG.',
	'securepoll-secret-gpg-error' => 'Грешка при извршавању GPG-а.
Поставите $wgSecurePollShowErrorDetail=true; у LocalSettings.php да добијете више детаља.',
	'securepoll-full-gpg-error' => 'Грешка при извршавању GPG-а:

Наредба: $1

Грешка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Кључеви GPG су погрешно подешени.',
	'securepoll-gpg-parse-error' => 'Грешка при тумачењу излазних података за GPG.',
	'securepoll-no-decryption-key' => 'Није постављен кључ за дешифровање.
Не могу да дешифрујем.',
	'securepoll-jump' => 'Иди на сервер за гласање',
	'securepoll-bad-ballot-submission' => 'Ваш глас је неисправан: $1',
	'securepoll-unanswered-questions' => 'Морате да одговорите на сва питања.',
	'securepoll-invalid-rank' => 'Неисправан ранг. Кандидате морате да рангирате с бројем између 1 и 999.',
	'securepoll-unranked-options' => 'Неки избори нису рангирани.
Свим изборима морате доделити ранг између 1 и 999.',
	'securepoll-invalid-score' => 'Оцена мора бити број између $1 и $2.',
	'securepoll-unanswered-options' => 'Морате одговорити на свако питање.',
	'securepoll-remote-auth-error' => 'Грешка при преузимању података о вашем налогу са сервера.',
	'securepoll-remote-parse-error' => 'Грешка при тумачењу одговора за проверу идентитета са сервера.',
	'securepoll-api-invalid-params' => 'Неисправни параметри.',
	'securepoll-api-no-user' => 'Нема корисника с том назнаком.',
	'securepoll-api-token-mismatch' => 'Безбедносни кодови се не поклапају. Не могу да вас пријавим.',
	'securepoll-not-logged-in' => 'Морате да будете пријављени да бисте гласали',
	'securepoll-too-few-edits' => 'Нажалост, не можете да гласате. Треба да имате барем $1 {{PLURAL:$1|измену|измене|измена}} да бисте гласали на овим изборима, а ви имате $2.',
	'securepoll-too-new' => 'Нажалост, не можете да гласате. Да бисте гласали, налог треба да вам је отворен пре $1 у $3, а ви сте га отворили $2 у $4.',
	'securepoll-blocked' => 'Нажалост, не можете да гласате ако вам је тренутно забрањено уређивање.',
	'securepoll-blocked-centrally' => 'Нажалост, не можете да гласате на овим изборима ако сте блокирани на барем $1 {{PLURAL:$1|викију|викија|викија}}.',
	'securepoll-bot' => 'Нажалост, налози с ботовском ознаком нису дозвољени на овим изборима.',
	'securepoll-not-in-group' => 'На овим изборима могу да гласају само припадници групе „$1“.',
	'securepoll-not-in-list' => 'Нажалост, нисте на предодређеном списку корисника којима је одобрено гласање на овим изборима.',
	'securepoll-list-title' => 'Прикажи гласове: $1',
	'securepoll-header-timestamp' => 'Време',
	'securepoll-header-voter-name' => 'Име',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ip' => 'ИП адреса',
	'securepoll-header-xff' => 'XFF',
	'securepoll-header-ua' => 'Кориснички агент',
	'securepoll-header-token-match' => 'CSRF',
	'securepoll-header-cookie-dup' => 'Дуп',
	'securepoll-header-strike' => 'Прецртавање',
	'securepoll-header-details' => 'Детаљи',
	'securepoll-strike-button' => 'Прецртај',
	'securepoll-unstrike-button' => 'Поништи прецртавање',
	'securepoll-strike-reason' => 'Разлог:',
	'securepoll-strike-cancel' => 'Откажи',
	'securepoll-strike-error' => 'Грешка при прецртавању/уклањању црте: $1',
	'securepoll-strike-token-mismatch' => 'Подаци о сесији су изгубљени',
	'securepoll-details-link' => 'Детаљи',
	'securepoll-details-title' => 'Детаљи о гласу: #$1',
	'securepoll-invalid-vote' => '„$1“ не представља исправну назнаку за гласање',
	'securepoll-header-id' => 'Назнака',
	'securepoll-header-voter-type' => 'Врста гласача',
	'securepoll-header-url' => 'Адреса',
	'securepoll-voter-properties' => 'Својства гласача',
	'securepoll-strike-log' => 'Историја прецртавања',
	'securepoll-header-action' => 'Радња',
	'securepoll-header-reason' => 'Разлог',
	'securepoll-header-admin' => 'Администратор',
	'securepoll-cookie-dup-list' => 'Колачић за дуплиране гласаче',
	'securepoll-dump-title' => 'Испис: $1',
	'securepoll-dump-no-crypt' => 'Шифрована гласачка евиденција није доступна за ове изборе, јер избори нису подешени да користе шифровање.',
	'securepoll-dump-not-finished' => 'Шифрована гласачка евиденција је доступна након што се заврше избори ($1 у $2)',
	'securepoll-dump-no-urandom' => 'Не могу да отворим /dev/urandom.
Да бисте одржали приватност гласача, шифрована гласачка евиденција постаје доступна за јавност након што се подаци евиденције промешају уз помоћ безбедног низа случајних бројева.',
	'securepoll-urandom-not-supported' => 'Овај сервер не подржава криптографско стварање случајних бројева.
Да бисте одржали приватност гласача, шифровани подаци избора постају доступни за јавност након што се промешају уз помоћ безбедног низа случајних бројева.',
	'securepoll-translate-title' => 'Преведи: $1',
	'securepoll-invalid-language' => 'Неисправан језички код: „$1“',
	'securepoll-header-trans-id' => 'Назнака',
	'securepoll-submit-translate' => 'Ажурирај',
	'securepoll-language-label' => 'Изабери језик:',
	'securepoll-submit-select-lang' => 'Преведи',
	'securepoll-entry-text' => 'Испод је наведен списак гласања.',
	'securepoll-header-title' => 'Име',
	'securepoll-header-start-date' => 'Почетни датум',
	'securepoll-header-end-date' => 'Завршни датум',
	'securepoll-subpage-vote' => 'Глас',
	'securepoll-subpage-translate' => 'Преведи',
	'securepoll-subpage-list' => 'Списак',
	'securepoll-subpage-dump' => 'Испис',
	'securepoll-subpage-tally' => 'Преброј',
	'securepoll-tally-title' => 'Пребројавање: $1',
	'securepoll-tally-not-finished' => 'Нажалост, не можете да пребројите изборе док се прво не заврши гласање.',
	'securepoll-can-decrypt' => 'Евиденција избора је шифрована, али кључ за дешифровање није доступан. 
Можете да изаберете да пребројите резултате који су у бази, или пак да пребројите шифроване резултате из отпремљене датотеке.',
	'securepoll-tally-no-key' => 'Не можете да пребројите гласове јер су шифровани, а кључ за дешифровање није доступан.',
	'securepoll-tally-local-legend' => 'Преброј смештене резултате',
	'securepoll-tally-local-submit' => 'Преброј',
	'securepoll-tally-upload-legend' => 'Отпреми шифровани испис',
	'securepoll-tally-upload-submit' => 'Преброј',
	'securepoll-tally-error' => 'Грешка при тумачењу гласова. Не могу да пребројим.',
	'securepoll-no-upload' => 'Датотека није отпремљена. Не могу да пребројим резултате.',
	'securepoll-dump-corrupt' => 'Исписана датотека је оштећена и не може да се обради.',
	'securepoll-tally-upload-error' => 'Грешка при пребројавању гласова из исписане датотеке: $1',
	'securepoll-pairwise-victories' => 'Упарена матрица за израчунавање победника',
	'securepoll-strength-matrix' => 'Матрица за јачину путање',
	'securepoll-ranks' => 'Коначно рангирање',
	'securepoll-average-score' => 'Просечна оцена',
	'securepoll-round' => 'Коло $1',
	'securepoll-spoilt' => '(оштећени)',
	'securepoll-exhausted' => '(исцрпени)',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'securepoll' => 'Bezbedno glasanje',
	'securepoll-desc' => 'Ekstenzija za izbore i ankete',
	'securepoll-invalid-page' => 'Nemoguća podstrana „<nowiki>$1</nowiki>“',
	'securepoll-need-admin' => 'Morate biti izborni administrator da biste izveli ovu akciju.',
	'securepoll-too-few-params' => 'Nedovoljno parametara podstrane (neispravna veza).',
	'securepoll-invalid-election' => '„$1“ nije validan ID za izbore.',
	'securepoll-welcome' => '<strong>Dobro došli, $1!</strong>',
	'securepoll-not-started' => 'Ovo su izbori, koji još uvek nisu počeli.
Početak je planiran za $2 u $3.',
	'securepoll-finished' => 'Ovi izbori su završeni. Ne možete više da glasate.',
	'securepoll-not-qualified' => 'Ne kvalifikujete se za glasača u ovim izborima: $1',
	'securepoll-change-disallowed' => 'Već ste glasali na ovim izborima.
Žao nam je, ne možete da glasate opet.',
	'securepoll-change-allowed' => '<strong>Napomena: već ste glasali na ovim izborima.</strong>
Možete da promenite glas tako što ćete popuniti obrazac ispod.
Ako to uradite, vaš prvobitni glas će biti poništen.',
	'securepoll-submit' => 'Pošalji glas',
	'securepoll-gpg-receipt' => 'Hvala vam što ste glasali.

Ako želite, možete da zadržite ovu potvrdu kao dokaz da ste glasali:

<pre>$1</pre>',
	'securepoll-thanks' => 'Hvala Vam. Vaš glas je snimljen.',
	'securepoll-return' => 'Vrati se na $1',
	'securepoll-encrypt-error' => 'Ne mogu da šifrujem glasački zapis.
Vaš glas nije zaveden!

$1',
	'securepoll-no-gpg-home' => 'Ne mogu da napravim osnovnu fasciklu za GPG.',
	'securepoll-secret-gpg-error' => 'Greška pri izvršavanju GPG-a.
Postavite $wgSecurePollShowErrorDetail=true; u LocalSettings.php da dobijete više detalja.',
	'securepoll-full-gpg-error' => 'Greška pri izvršavanju GPG-a:

Naredba: $1

Greška:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG ključevi su pogrešno podešeni.',
	'securepoll-gpg-parse-error' => 'Greška prilikom interpretacije GPG izlaza.',
	'securepoll-no-decryption-key' => 'Nije postavljen ključ za dešifrovanje.
Ne mogu da dešifrujem.',
	'securepoll-jump' => 'Idi na server za glasanje',
	'securepoll-bad-ballot-submission' => 'Vaš glas je neispravan: $1',
	'securepoll-unanswered-questions' => 'Morate odgovoriti na sva pitanja.',
	'securepoll-invalid-rank' => 'Pogrešno rangiranje. Knadidate možete rangirati brojevima između 1 i 999.',
	'securepoll-unranked-options' => 'Neki izbori nisu rangirani.
Svim izborima morate dodeliti rang između 1 i 999.',
	'securepoll-invalid-score' => 'Ocena mora biti broj između $1 i $2.',
	'securepoll-unanswered-options' => 'Morate odgovoriti na svako pitanje.',
	'securepoll-remote-auth-error' => 'Greška prilikom preuzimanja informacija o Vašem nalogu sa servera.',
	'securepoll-remote-parse-error' => 'Greška pri tumačenju odgovora za proveru identiteta sa servera.',
	'securepoll-api-invalid-params' => 'Pogrešni parametri.',
	'securepoll-api-no-user' => 'Nije nađen korisnik sa datim ID.',
	'securepoll-api-token-mismatch' => 'Bezbednosni kodovi se ne poklapaju. Ne mogu da vas prijavim.',
	'securepoll-not-logged-in' => 'Morate se ulogovati da biste glasali na ovim izborima',
	'securepoll-too-few-edits' => 'Nažalost, ne možete da glasate. Treba da imate barem $1 {{PLURAL:$1|izmenu|izmene|izmena}} da biste glasali na ovim izborima, a vi imate $2.',
	'securepoll-too-new' => 'Nažalost, ne možete da glasate. Da biste glasali, nalog treba da vam je otvoren pre $1 u $3, a vi ste ga otvorili $2 u $4.',
	'securepoll-blocked' => 'Nažalost, ne možete da glasate ako vam je trenutno zabranjeno uređivanje.',
	'securepoll-blocked-centrally' => 'Nažalost, ne možete da glasate na ovim izborima ako ste blokirani na barem $1 {{PLURAL:$1|vikiju|vikija|vikija}}.',
	'securepoll-bot' => 'Nažalost, nalozi s botovskom oznakom nisu dozvoljeni na ovim izborima.',
	'securepoll-not-in-group' => 'Na ovim izborima mogu da glasaju samo pripadnici grupe „$1“.',
	'securepoll-not-in-list' => 'Nažalost, niste na predodređenom spisku korisnika kojima je odobreno glasanje na ovim izborima.',
	'securepoll-list-title' => 'Prikaži glasove: $1',
	'securepoll-header-timestamp' => 'Vreme',
	'securepoll-header-voter-name' => 'Ime',
	'securepoll-header-voter-domain' => 'Domen',
	'securepoll-header-ip' => 'IP adresa',
	'securepoll-header-xff' => 'XFF',
	'securepoll-header-ua' => 'Korisnički klijent',
	'securepoll-header-token-match' => 'CSRF',
	'securepoll-header-cookie-dup' => 'Dup',
	'securepoll-header-strike' => 'Precrtavanje',
	'securepoll-header-details' => 'Pojedinosti',
	'securepoll-strike-button' => 'Precrtaj',
	'securepoll-unstrike-button' => 'Poništi precrtavanje',
	'securepoll-strike-reason' => 'Razlog:',
	'securepoll-strike-cancel' => 'Otkaži',
	'securepoll-strike-error' => 'Greška pri precrtavanju/uklanjanju crte: $1',
	'securepoll-strike-token-mismatch' => 'Izgubljeni podaci o sesiji',
	'securepoll-details-link' => 'Pojedinosti',
	'securepoll-details-title' => 'Pojedinosti o glasu: #$1',
	'securepoll-invalid-vote' => '„$1“ nije validan ID za glasanje',
	'securepoll-header-id' => 'Naznaka',
	'securepoll-header-voter-type' => 'Tip glasača',
	'securepoll-header-url' => 'Adresa',
	'securepoll-voter-properties' => 'Svojstva glasača',
	'securepoll-strike-log' => 'Istorija precrtavanja',
	'securepoll-header-action' => 'Radnja',
	'securepoll-header-reason' => 'Razlog',
	'securepoll-header-admin' => 'Admin',
	'securepoll-cookie-dup-list' => 'Korisnici sa duplikatima kolačića',
	'securepoll-dump-title' => 'Damp: $1',
	'securepoll-dump-no-crypt' => 'Šifrovana glasačka evidencija nije dostupna za ove izbore, jer izbori nisu podešeni da koriste šifrovanje.',
	'securepoll-dump-not-finished' => 'Šifrovana glasačka evidencija je dostupna nakon što se završe izbori ($1 u $2)',
	'securepoll-dump-no-urandom' => 'Ne mogu da otvorim /dev/urandom.
Da biste održali privatnost glasača, šifrovana glasačka evidencija postaje dostupna za javnost nakon što se podaci evidencije promešaju uz pomoć bezbednog niza slučajnih brojeva.',
	'securepoll-urandom-not-supported' => 'Ovaj server ne podržava kriptografsko stvaranje slučajnih brojeva.
Da biste održali privatnost glasača, šifrovani podaci izbora postaju dostupni za javnost nakon što se promešaju uz pomoć bezbednog niza slučajnih brojeva.',
	'securepoll-translate-title' => 'Prevedi: $1',
	'securepoll-invalid-language' => 'Neprepoznatljiv kod jezika: „$1“',
	'securepoll-header-trans-id' => 'Naznaka',
	'securepoll-submit-translate' => 'Ažuriraj',
	'securepoll-language-label' => 'Izaberi jezik:',
	'securepoll-submit-select-lang' => 'Prevedi',
	'securepoll-entry-text' => 'Ispod je naveden spisak glasanja.',
	'securepoll-header-title' => 'Ime',
	'securepoll-header-start-date' => 'Datum početka',
	'securepoll-header-end-date' => 'Datum kraja',
	'securepoll-subpage-vote' => 'Glas',
	'securepoll-subpage-translate' => 'Prevedi',
	'securepoll-subpage-list' => 'Spisak',
	'securepoll-subpage-dump' => 'Damp',
	'securepoll-subpage-tally' => 'Prebroj',
	'securepoll-tally-title' => 'Prebrojavanje: $1',
	'securepoll-tally-not-finished' => 'Nažalost, ne možete da prebrojite izbore dok se prvo ne završi glasanje.',
	'securepoll-can-decrypt' => 'Evidencija izbora je šifrovana, ali ključ za dešifrovanje nije dostupan. 
Možete da izaberete da prebrojite rezultate koji su u bazi, ili pak da prebrojite šifrovane rezultate iz otpremljene datoteke.',
	'securepoll-tally-no-key' => 'Ne možete da prebrojite glasove jer su šifrovani, a ključ za dešifrovanje nije dostupan.',
	'securepoll-tally-local-legend' => 'Prebroj smeštene rezultate',
	'securepoll-tally-local-submit' => 'Prebroj',
	'securepoll-tally-upload-legend' => 'Otpremi šifrovani ispis',
	'securepoll-tally-upload-submit' => 'Prebroj',
	'securepoll-tally-error' => 'Greška pri tumačenju glasova. Ne mogu da prebrojim.',
	'securepoll-no-upload' => 'Datoteka nije otpremljena. Ne mogu da prebrojim rezultate.',
	'securepoll-dump-corrupt' => 'Ispisana datoteka je oštećena i ne može da se obradi.',
	'securepoll-tally-upload-error' => 'Greška pri prebrojavanju glasova iz ispisane datoteke: $1',
	'securepoll-pairwise-victories' => 'Uparena matrica za izračunavanje pobednika',
	'securepoll-strength-matrix' => 'Matrica za jačinu putanje',
	'securepoll-ranks' => 'Konačno rangiranje',
	'securepoll-average-score' => 'Prosečna ocena',
	'securepoll-round' => 'Kolo $1',
	'securepoll-spoilt' => '(oštećeni)',
	'securepoll-exhausted' => '(iscrpeni)',
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
 * @author Lokal Profil
 * @author Micke
 * @author Najami
 * @author Per
 * @author Poxnar
 * @author Ronja Addams-Moring
 * @author StefanB
 * @author WikiPhoenix
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
	'securepoll-too-new' => 'Du kan tyvärr inte rösta. Ditt konto måste ha varit registrerat före den $1 kl. $3 för att rösta i detta val; du registrerade dig den $2 kl. $4.',
	'securepoll-blocked' => 'Ledsen, men du kan inte rösta om du är blockerad från redigering.',
	'securepoll-blocked-centrally' => 'Du kan tyvärr inte rösta i detta val eftersom du är blockerad på minst $1 {{PLURAL:$1|wiki|wikier}}.',
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
	'securepoll-round' => 'Omgång $1',
	'securepoll-spoilt' => '(Ogiltig)',
	'securepoll-exhausted' => '(Uttömd)',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'securepoll-header-voter-name' => 'Jina',
	'securepoll-strike-reason' => 'Sababu:',
	'securepoll-strike-cancel' => 'Batilisha',
	'securepoll-header-reason' => 'Sababu',
	'securepoll-submit-translate' => 'Sasisha',
	'securepoll-submit-select-lang' => 'Kutafsiri',
	'securepoll-header-title' => 'Jina',
	'securepoll-header-start-date' => 'Tarehe ya kuanza',
	'securepoll-header-end-date' => 'Tarehe ya kumaliza',
	'securepoll-subpage-translate' => 'Kutafsiri',
	'securepoll-subpage-list' => 'Orodha',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 * @author TRYPPN
 * @author පසිඳු කාවින්ද
 */
$messages['ta'] = array(
	'securepoll' => 'செகிறேபோல்',
	'securepoll-welcome' => '<strong>வரவேற்பு  $1 !</strong>',
	'securepoll-submit' => 'வாக்கை சமர்ப்பிக்கவும்',
	'securepoll-thanks' => 'நன்றி,உங்கள் வாக்கு பதிவு செய்யப்பட்டது.',
	'securepoll-return' => '$1 க்கு திரும்பு.',
	'securepoll-encrypt-error' => 'உங்கள் வாக்கு பதிவை மறையாக்குவதில் தோல்வியடைந்தது.
உங்கள் வாக்கு பதிவு செய்யப்படவில்லை.

$1',
	'securepoll-no-gpg-home' => 'GPG உள் கோப்புறை உருவாக்க இயலவில்லை.',
	'securepoll-full-gpg-error' => 'GPG செயலாக்குவதில் பிழை:

கட்டளை: $1

பிழை:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG விசைகள் தவறாக உள்ளமைக்கப்பட்டுள்ளன',
	'securepoll-api-invalid-params' => 'செல்லாத அளவுருக்கள்.',
	'securepoll-header-timestamp' => 'நேரம்',
	'securepoll-header-voter-name' => 'பெயர்',
	'securepoll-header-voter-domain' => 'டொமைன்',
	'securepoll-header-details' => 'விளக்கம்',
	'securepoll-strike-reason' => 'காரணம்:',
	'securepoll-strike-cancel' => 'விட்டுவிடு',
	'securepoll-details-link' => 'விளக்கம்',
	'securepoll-header-action' => 'செயல்',
	'securepoll-header-reason' => 'காரணம்',
	'securepoll-header-admin' => 'நிர்வாகி',
	'securepoll-translate-title' => 'மொழிபெயர்ப்பு செய்யவும்: $1',
	'securepoll-submit-translate' => 'புதுப்பி',
	'securepoll-language-label' => 'மொழியை தேர்வு செய்:',
	'securepoll-submit-select-lang' => 'மொழிபெயர்ப்பு செய்யவும்',
	'securepoll-header-title' => 'பெயர்',
	'securepoll-header-start-date' => 'ஆரம்பத்தேதி',
	'securepoll-header-end-date' => 'முடிவுத்தேதி',
	'securepoll-subpage-vote' => 'வோடே',
	'securepoll-subpage-translate' => 'மொழி பெயர்ப்பு',
	'securepoll-subpage-list' => 'பட்டியல்',
	'securepoll-ranks' => 'இறுதி மதிப்பீடுகள்',
	'securepoll-average-score' => 'சராசரி மதிப்பு',
	'securepoll-round' => 'சுற்று $1',
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
	'securepoll-api-invalid-params' => 'తప్పుడు పరామితులు.',
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
	'securepoll-submit-translate' => 'తాజాకరించు',
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

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'securepoll-header-voter-name' => 'Naran',
	'securepoll-header-title' => 'Naran',
);

/** Thai (ไทย)
 * @author Ans
 * @author Korrawit
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
คุณสามารถเลือกที่จะนับผลการเลือกตั้งที่ปรากฏในฐานข้อมูล หรือนับคะแนนของบันทึกที่ถูกเข้ารหัสจากไฟล์ที่ถูกอัพโหลดไว้',
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
	'securepoll-not-started' => 'Bu saýlaw heniz başlamady.
Ol $2 senesinde $3 sagatynda başlaýar.',
	'securepoll-finished' => 'Bu saýlaw gutardy, indi ses berip bilmeýärsiňiz.',
	'securepoll-not-qualified' => 'Bu saýlawda ses bermäge hukugyňyz ýok: $1',
	'securepoll-change-disallowed' => 'Bu saýlawda ozal ses beripsiňiz.
Bagyşlaň, gaýtadan ses berip bilmeýärsiňiz.',
	'securepoll-submit' => 'Sesi tabşyr',
	'securepoll-thanks' => 'Sag boluň, sesiňiz hasaba alyndy.',
	'securepoll-return' => '$1 sahypasyna gaýdyp bar',
	'securepoll-no-gpg-home' => 'GPG öý direktoriýasyny döredip bilmeýär.',
	'securepoll-full-gpg-error' => 'GPG işleýärkä säwlik:

Buýruk: $1

Säwlik:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG açarlary nädogry konfigurirlenipdir.',
	'securepoll-gpg-parse-error' => 'GPG önümi interpretasiýasynda säwlik.',
	'securepoll-no-decryption-key' => 'Rasşifrowka açary konfigurirlenmändir.
Rasşifrowka edip bolmaýar.',
	'securepoll-jump' => 'Ses beriş serwerine git',
	'securepoll-bad-ballot-submission' => 'Sesiňiz hasap edilmeýär: $1',
	'securepoll-unanswered-questions' => 'Ähli soraglara jogap bermelisiňiz.',
	'securepoll-invalid-rank' => 'Nädogry rang. 1 bilen 999 arasynda bir rang bermeli',
	'securepoll-unranked-options' => 'Käbir opsiýalar derejelendirilmändir.
Ähli opsiýalara 1 bilen 999 aralygynda bir dereje bermeli.',
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
	'securepoll-dump-no-urandom' => '/dev/urandom açylmaýar.
Saýlawçynyň gizlinligini üpjün etmek üçin, şifrli saýlaw ýazgylary diňe ynamdar bir duş gelen san akymy arkaly garylan ýagdaýynda, ol köpçülige elýeterli bolup bilýär.',
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
 * @author Sky Harbor
 */
$messages['tl'] = array(
	'securepoll' => 'Ligtas na Halalan',
	'securepoll-desc' => 'Karugtong para sa mga halalan at mga pagtatanung-tanong',
	'securepoll-invalid-page' => 'Hindi tanggap na kabahaging pahinang "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'Kailangan mong maging isang tagapangasiwa ng halalan upang maisagawa ang galaw na ito.',
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
Pakitandaan na kapag ginawa mo ito, itatapon ang nauna mong boto.',
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
	'securepoll-invalid-rank' => 'Hindi wastong ranggo. Kailangan mong magbigay sa mga kandidato ng isang ranggo sa pagitan ng 1 at 999.',
	'securepoll-unranked-options' => 'Ang ilang mga opsyon ay hindi niraranggo. 
Ikaw ay dapat magbigay ng lahat ng mga mapagpipilian ng isang ranggo sa pagitan ng 1 at 999.',
	'securepoll-invalid-score' => 'Ang mga iskor ay kailangang isang bilang sa pagitan ng $1 at $2.',
	'securepoll-unanswered-options' => 'Kailangan mong magbigay ng sagot para sa bawat tanong.',
	'securepoll-remote-auth-error' => 'Kamalian sa pagpulot ng kabatiran ng iyong kuwenta mula sa serbidor.',
	'securepoll-remote-parse-error' => 'Kamalian sa pagpapaliwanag ng tugon ng pagpapahintulot mula sa tagapaghain.',
	'securepoll-api-invalid-params' => 'Hindi tanggap na mga parametro.',
	'securepoll-api-no-user' => 'Walang tagagamit na natagpuang may ibinigay na ID.',
	'securepoll-api-token-mismatch' => 'Maling pagtutugma ng tandang pangkaligtasan, hindi makalalagdang papasok.',
	'securepoll-not-logged-in' => 'Kailangan mong lumagdang papasok upang makaboto sa halalang ito',
	'securepoll-too-few-edits' => 'Paumanhin, hindi ka makakaboto. Kailangan mong maging nakagawa ng kahit na mga $1 {{PLURAL:$1|pamamatnugot|mga pamamatnugot}} upang makaboto sa halalang ito, nakagawa ka na ng $2.',
	'securepoll-too-new' => 'Paumanhin, ngunit hindi ka maaaring bumoto.  Dapat itinala ang kuwenta mo bago ng $1 upang makaboto sa halalang ito; nagpatala ko noong $2.',
	'securepoll-blocked' => 'Paumanhin, hindi ka makakaboto sa halalang ito kung kasalukuyan kang hinaharangan mula sa pamamatnugot.',
	'securepoll-blocked-centrally' => 'Paumanhin, ngunit hindi ka maaaring bumoto sa halalang ito kung hinarangan ka sa $1 o {{PLURAL:$1|wiki|mga wiki}}.',
	'securepoll-bot' => 'Paumanhin, ang mga kuwentang may watawat ng bot ay hindi pinapayagang bumoto sa halalang ito.',
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
	'securepoll-strike-token-mismatch' => 'Nawalang dato ng pulong',
	'securepoll-details-link' => 'Mga detalye',
	'securepoll-details-title' => 'Mga detalye ng boto: #$1',
	'securepoll-invalid-vote' => 'Ang "$1" ay hindi isang tanggap na ID ng boto',
	'securepoll-header-voter-type' => 'Uri ng tagapaghalal',
	'securepoll-voter-properties' => 'Mga pag-aari ng botante',
	'securepoll-strike-log' => 'Talaan ng pagkalos',
	'securepoll-header-action' => 'Galaw',
	'securepoll-header-reason' => 'Dahilan',
	'securepoll-header-admin' => 'Tagapangasiwa',
	'securepoll-cookie-dup-list' => 'Mga tagagamit ng dalawahang kuki',
	'securepoll-dump-title' => 'Itapon: $1',
	'securepoll-dump-no-crypt' => 'Walang makuhang nakakodigong tala ng halalan para sa halalang ito, dahil ang halalan ay hindi nakaayos na gumamit ng kodigo.',
	'securepoll-dump-not-finished' => 'Makakakuha lamang ng nakakodigong mga tala ng halalan pagkalipas ng petsa ng katapusang $1 sa $2',
	'securepoll-dump-no-urandom' => 'Hindi mabuksan /dev/urandom.
Upang mapanitili ang paglilihim ng manghahalal, makukuha lamang ng madla ang nakakodigong mga talaan ng halalan kapag mababalasa na sila sa isang ligtas na daloy ng alin mang bilang.',
	'securepoll-urandom-not-supported' => 'Hindi nagsusuporta ang tagapaghaing ito ng paglikha ng kriptograpikong bilang na bigay ng pagkakataon.
Upang mapanatili ang pagkapribado ng botante, makukuha lamang ng madla ang nakakodigong mga tala ng halalan kapag mababalasa sila ng isang ligtas na sibol ng bilang na bigay ng pagkakataon.',
	'securepoll-translate-title' => 'Isalinwika: $1',
	'securepoll-invalid-language' => 'Hindi tanggap na kodigo ng wikang "$1"',
	'securepoll-submit-translate' => 'Isapanahon',
	'securepoll-language-label' => 'Piliin ang wika:',
	'securepoll-submit-select-lang' => 'Isalinwika',
	'securepoll-entry-text' => 'Nasa ibaba ang talaan ng mga paghalal.',
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
	'securepoll-dump-corrupt' => 'Sira ang  talaksang tambakan at hindi maaaring isagawa.',
	'securepoll-tally-upload-error' => 'Kamalian sa paglalapat ng talaksang tambakan: $1',
	'securepoll-pairwise-victories' => 'Pangmatagumpay na matris sa gawi ng tambalan',
	'securepoll-strength-matrix' => 'Matris ng lakas ng landas',
	'securepoll-ranks' => 'Pinakahuling pag-aantas',
	'securepoll-average-score' => 'Pangkaraniwang kutab',
	'securepoll-round' => 'Yugto $1',
	'securepoll-spoilt' => '(Nasayang)',
	'securepoll-exhausted' => '(Naubos)',
);

/** Tok Pisin (Tok Pisin)
 * @author Iketsi
 */
$messages['tpi'] = array(
	'securepoll-header-timestamp' => 'Taim',
	'securepoll-subpage-translate' => 'Tantok',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Joseph
 * @author Koc61
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
	'securepoll-too-new' => 'Üzgünüz, oyunuz kabul edilmedi. Bu oylamada oy kullanabilmek için hesabınızın $1 tarihinden önce açılmış olması gerekiyor. Siz $2 tarihinde kayıt olmuşsunuz.',
	'securepoll-blocked' => 'Üzgünüz, eğer şu anda değişiklik yapmaya engellenmiş iseniz bu seçimlerde oy kullanamazsınız.',
	'securepoll-blocked-centrally' => 'Üzgünüz, eğer $1 ya da daha fazla vikide engelliyseniz, bu oylamada oy kullanamazsınız.',
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
	'securepoll-round' => 'Raunt $1',
	'securepoll-spoilt' => '(Bozuk)',
	'securepoll-exhausted' => '(Bitkin)',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Bulatbulat
 * @author KhayR
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'securepoll-not-started' => 'Бу тавыш бирүләр әле башланмаганнар.
Башлану вакыты:$2 $3',
	'securepoll-finished' => 'Бу тавыш бирү тәмамланган, хәзер сез тавыш бирә алмыйсыз.',
	'securepoll-header-timestamp' => 'Вакыт',
	'securepoll-header-voter-name' => 'Исем',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Кулланучы агенты',
	'securepoll-header-cookie-dup' => 'Дублләр',
	'securepoll-header-strike' => 'Сызу',
	'securepoll-header-details' => 'Тулырак',
	'securepoll-strike-button' => 'Сызу',
	'securepoll-unstrike-button' => 'Сызуны алу',
	'securepoll-strike-reason' => 'Сәбәп:',
	'securepoll-strike-cancel' => 'Баш тарту',
);

/** Tuvinian (Тыва дыл)
 * @author Sborsody
 */
$messages['tyv'] = array(
	'securepoll-strike-reason' => 'Чылдагаан:',
	'securepoll-header-reason' => 'Чылдагаан',
	'securepoll-header-title' => 'Ат',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Dim Grits
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
	'securepoll-not-logged-in' => 'Ви маєте ввійти до системи, щоб взяти участь у голосуванні',
	'securepoll-too-few-edits' => 'Вибачте, ви не можете проголосувати. Вам треба мати не менше $1 {{PLURAL:$1|редагування|редагувань|редагувань}} для участі в цьому голосуванні, у вас є $2.',
	'securepoll-too-new' => 'На жаль, ви не можете голосувати.  Ваш обліковий запис повинен були зареєстрований до $1 $3 для голосування на цих виборах, ви зареєстровані $2 $4.',
	'securepoll-blocked' => 'Вибачте, ви не можете голосувати на виборах, оскільки вас заблоковано.',
	'securepoll-blocked-centrally' => 'На жаль, ви не може голосувати в цих виборах, так як ви заблоковані у $1 {{PLURAL:$1|вікіпроекті|вікіпроектах}}.',
	'securepoll-bot' => 'Вибачте, облікові записи зі статусом бота не допускаються до участі в голосуванні.',
	'securepoll-not-in-group' => 'Тільки члени групи "$1" можуть голосувати на цих виборах.',
	'securepoll-not-in-list' => 'Вибачте, ви не входите в список користувачів, допущених до голосування на цих виборах.',
	'securepoll-list-title' => 'Список голосів: $1',
	'securepoll-header-timestamp' => 'Час',
	'securepoll-header-voter-name' => "Ім'я",
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ip' => 'IP',
	'securepoll-header-xff' => 'XFF',
	'securepoll-header-ua' => 'Програма клієнта',
	'securepoll-header-token-match' => 'CSRF',
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
	'securepoll-header-id' => 'ID',
	'securepoll-header-voter-type' => 'Тип виборця',
	'securepoll-header-url' => 'URL-адреса',
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
	'securepoll-header-trans-id' => 'ID',
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
	'securepoll-round' => '$1 тур',
	'securepoll-spoilt' => '(Зіпсовані)',
	'securepoll-exhausted' => '(Вичерпані)',
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
	'securepoll-strike-reason' => 'وجہ:',
	'securepoll-strike-cancel' => 'منسوخ',
	'securepoll-header-reason' => 'وجہ',
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
	'securepoll-invalid-rank' => 'Voto mia valido. Te ghè da dare un voto tra 1 e 999.',
	'securepoll-unranked-options' => 'Alcuni voci le xe sensa voto.
Te devi dare a tute le voci un voto da 1 a 999.',
	'securepoll-invalid-score' => 'El voto el ga da essare un numaro tra $1 e $2.',
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
	'securepoll-urandom-not-supported' => 'Sto server no suporta la generazion de numari casuali par la critografia.
Al fine de garantire la privacy dei votanti, la procedura de votazion cifrata xe publicamente utilizabile quando xe disponibile un generator de numari casuali par la critografia del flusso de dati.',
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
	'securepoll-can-decrypt' => "Le informazion relative a l'elezion le xe stà cifrate, ma xe disponibile la ciave de decifratura.
Te poli far la conta dei risultati presenti nel database o far la conta dei risultati cifrati contenuti in un file caricà.",
	'securepoll-tally-no-key' => 'No te poli far la conta dei risultati de sta elezione parché i voti i xe cifrati e la ciave de decifrazion no la xe disponibile.',
	'securepoll-tally-local-legend' => 'Conta dei risultati memorizà',
	'securepoll-tally-local-submit' => 'Fà na conta',
	'securepoll-tally-upload-legend' => 'Carga su un dump criptà',
	'securepoll-tally-upload-submit' => 'Fà la conta',
	'securepoll-tally-error' => 'Eror elaborando le informassion de voto, no se pol far la conta.',
	'securepoll-no-upload' => 'Nissun file caricà, no se pol far la conta.',
	'securepoll-dump-corrupt' => 'El file de dump el xe roto e no se pole elaborarlo.',
	'securepoll-tally-upload-error' => 'Eror fasendo la conta del file de dump: $1',
	'securepoll-pairwise-victories' => 'Matrice de vitoria a do a do',
	'securepoll-strength-matrix' => 'Matrice de fortezza del percorso',
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
 * @author Trần Nguyễn Minh Huy
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'securepoll' => 'Bỏ phiếu an toàn',
	'securepoll-desc' => 'Bộ mở rộng dành cho bầu cử và thăm dò ý kiến',
	'securepoll-invalid-page' => 'Trang con không hợp lệ “<nowiki>$1</nowiki>”',
	'securepoll-need-admin' => 'Chỉ các quản trị viên được bầu mới có quyền thực hiện tác vụ này.',
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
Lưu ý rằng nếu bạn làm điều này, lá phiếu trước đây của bạn sẽ bị hủy.',
	'securepoll-submit' => 'Gửi phiếu',
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
	'securepoll-too-new' => 'Rất tiếc, bạn không được phép bỏ phiếu. Để được phép tham gia cuộc bầu cử này, bạn cần phải mở tài khoản trước $3 $1, nhưng bạn đăng ký vào lúc $4 $2.',
	'securepoll-blocked' => 'Xin lỗi, bạn không thể bỏ phiếu trong cuộc bầu cử này nếu bạn đang bị cấm không được sửa đổi.',
	'securepoll-blocked-centrally' => 'Rất tiếc, bạn không được phép tham gia cuộc bầu cử này vì bị cấm tại $1 wiki trở lên.',
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
	'securepoll-header-admin' => 'Quản trị viên',
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
	'securepoll-dump-corrupt' => 'Tập tin kết xuất bị hỏng và không thể xử lý được.',
	'securepoll-tally-upload-error' => 'Có lỗi khi kiểm tập tin kết xuất: $1',
	'securepoll-pairwise-victories' => 'Ma trận chiến thắng theo cặp',
	'securepoll-strength-matrix' => 'Ma trận độ mạnh đường đi',
	'securepoll-ranks' => 'Xếp hạng sau cùng',
	'securepoll-average-score' => 'Điểm số trung bình',
	'securepoll-round' => 'Vòng $1',
	'securepoll-spoilt' => '(Hỏng)',
	'securepoll-exhausted' => '(Quá hạn)',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'securepoll-welcome' => '<strong>Benokömö, $1!</strong>',
	'securepoll-header-timestamp' => 'Tim',
	'securepoll-header-voter-name' => 'Nem',
	'securepoll-strike-reason' => 'Kod:',
	'securepoll-header-reason' => 'Kod',
	'securepoll-submit-select-lang' => 'Tradutön',
	'securepoll-header-title' => 'Nem',
	'securepoll-subpage-translate' => 'Tradutön',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'securepoll-strike-reason' => '理由：',
	'securepoll-strike-cancel' => '取消',
	'securepoll-header-reason' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'securepoll' => 'זיכערע שטימונג',
	'securepoll-desc' => 'פֿאַרברייטונג פֿאַר וואַלן און אַרומפֿרעגן',
	'securepoll-invalid-page' => 'אומגילטיקער אונטערבלאט "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => 'איר דארפט זיין א וואלן אדמיניסטראטאר אדורכצופירן די פעולה.',
	'securepoll-too-few-params' => 'נישט גענוג אונטערבלאט פאראמעטערס (אומגילטיקער לינק).',
	'securepoll-invalid-election' => '"$1" איז נישט קיין גילטיקער אפשטימונג  ID.',
	'securepoll-welcome' => '<strong>ברוך הבא, $1!</strong>',
	'securepoll-not-started' => 'די אפשטימונג האט נאך נישט אנגעהויבן.
זי איז באשטימט אנצוהייבן אום $2 אזייגער $3.',
	'securepoll-finished' => 'די אפשטימונג האט שוין געקאנטשעט, איר קענט מער נישט אפשטימען.',
	'securepoll-not-qualified' => 'איר זענט נישט קוואליפֿיצירט צו שטימען אין די וואלן: $1',
	'securepoll-change-disallowed' => 'איר האט שוין געשטימט אין די דאָזיקע וואַלן.
אַנטשולדיקט, איר טאָר נישט שטימען נאכאַמאָל.',
	'securepoll-change-allowed' => '<strong> באַמערקונג: איר האט שוין געשטימט אין די וואַלן.</strong>
איר מעגט ענדערן אײַער שטים דורך דער פֿארעם אונטן.
ווען איר טוט דאָס, וועט מען אויסמעקן אײַער פֿריערדיקן שטים.',
	'securepoll-submit' => 'אָפגעבן שטים',
	'securepoll-gpg-receipt' => 'א דאנק פארן שטימען.

ווען איר ווילט, קענט איר היטן דעם פאלגנדן קוויט אלס ראיה פון אייער שטים.

<pre>$1</pre>',
	'securepoll-thanks' => ' ייש"כ, אײַער שטים איז געווארן פֿאַרשריבן.',
	'securepoll-return' => 'צוריק צו $1',
	'securepoll-encrypt-error' => 'האט נישט געקענט אויסבאהאלטן אייער שטים רעקארד.
אייער שטים איז נישט געווארן איינגעשפייכלערט!

$1',
	'securepoll-no-gpg-home' => 'נישט געקענט שאפן GPG היים טעקע־האלטער',
	'securepoll-secret-gpg-error' => 'גרײַז ביים אויספירן GPG.
ניצט $wgSecurePollShowErrorDetail=true; אין LocalSettings.php צו ווייזן נאך פרטים.',
	'securepoll-full-gpg-error' => 'גרײַז ביים אויספירן GPG:

באפעל: $1

גרײַז:
<pre>$2</pre>',
	'securepoll-jump' => 'גייט צום אָפּשטימונג סערווירער',
	'securepoll-bad-ballot-submission' => 'אײַער שטים איז געווען אומגילטיג: $1',
	'securepoll-unanswered-questions' => 'איר מוזט ענטפערן אלע שאלות.',
	'securepoll-invalid-rank' => 'אומגילטיקער ראנג. איר מוזט געבן די קאנדידאטן א ראנג צווישן  1 און 999.',
	'securepoll-unanswered-options' => 'איר דאַרפֿט געבן אַן ענטפער פֿאַר יעדער פֿראַגע.',
	'securepoll-api-invalid-params' => 'אומגילטיגע פאראמעטערס',
	'securepoll-api-no-user' => 'קיין באַניצער נישט געפֿונען מיט דעם נומער.',
	'securepoll-not-logged-in' => 'איר מוזט אריינלאגירן צו שטימען אין דער אפשטימונג',
	'securepoll-too-few-edits' => 'איר קענט ליידער ניט שטימען. איר דאַרפֿט האָבן מינדסטערטנס $1 {{PLURAL:$1| רעדאַקטירונג| רעדאַקטירונגען}} צו שטימען אין די וואַלן; איר האָט נאר $2 .',
	'securepoll-too-new' => 'אנטשולדיגט, איר קענט נישט שטימען. אייער קאנטע דאַרף צו האָבן געווען אײַנגעשריבן פֿאַר $1 בי $3 צו שטימען אין די וואַלן, איר האט זיך אבער אײַנגעשריבן אום $2 בײַ $4 .',
	'securepoll-blocked' => 'אנטשולדיגט, איר קענט נישט שטימען אין די וואלן אויב איר זענט אצינד בלאקירט פון רעדאקטירן.',
	'securepoll-blocked-centrally' => 'אנטשולדיגט, איר קענט ניט שטימען אין די וואַלן ווײַל איר זענט בלאקירט אויף מינדערסטן $1 {{PLURAL:$1|וויקי|וויקיס}}.',
	'securepoll-bot' => 'אנטשולדיגט, קאנטעס מיטן באָט פאָן זענען נישט ערלויבט צו שטימען אין די וואַלן.',
	'securepoll-not-in-group' => 'נאר מיטגלידער פון דער "$1" גרופע קענען שטימען אין די וואלן. ',
	'securepoll-list-title' => 'רשימה פֿון שטימען: $1',
	'securepoll-header-timestamp' => 'צײַט',
	'securepoll-header-voter-name' => 'נאָמען',
	'securepoll-header-voter-domain' => 'פֿעלד',
	'securepoll-header-ua' => 'באַניצער אַגענט',
	'securepoll-header-cookie-dup' => 'דופליקאַט',
	'securepoll-header-strike' => 'אויסשטרײַכן',
	'securepoll-header-details' => 'פרטים',
	'securepoll-strike-button' => 'אויסשטרײַכן',
	'securepoll-unstrike-button' => 'אומאויסשטרײַכן',
	'securepoll-strike-reason' => 'אורזאַך:',
	'securepoll-strike-cancel' => 'אַנולירן',
	'securepoll-strike-error' => 'גרײַז בײַם אויסשטרײַכן/אומאויסשטרײַכן: $1',
	'securepoll-strike-token-mismatch' => 'סעסיע דאַטן פאַרלוירן',
	'securepoll-details-link' => 'פרטים',
	'securepoll-details-title' => 'שטימען פרטים: #$1',
	'securepoll-invalid-vote' => '"$1" איז נישט קיין גילטיקע אפשטימונג  ID.',
	'securepoll-header-voter-type' => 'וויילער טיפּ',
	'securepoll-voter-properties' => 'וויילער אייגנשאַפֿטן',
	'securepoll-strike-log' => 'אויסשטרײַכן לאגבוך',
	'securepoll-header-action' => 'אַקציע',
	'securepoll-header-reason' => 'אורזאַך',
	'securepoll-header-admin' => 'אַדמיניסטראַטאר',
	'securepoll-cookie-dup-list' => 'פֿאַרטאפלט קיכל באַניצער',
	'securepoll-dump-title' => 'לאַגער: $1',
	'securepoll-translate-title' => 'פֿאַרטײַטשן : $1',
	'securepoll-invalid-language' => 'אומגילטיקער שפראך קאד  "$1"',
	'securepoll-submit-translate' => 'דערהײַנטיקן',
	'securepoll-language-label' => 'אויסקלײַבן שפראַך:',
	'securepoll-submit-select-lang' => 'פֿאַרטײַטשן',
	'securepoll-entry-text' => 'אונטן איז די רשימה פון די וואלן.',
	'securepoll-header-title' => 'נאָמען',
	'securepoll-header-start-date' => 'אָנהייב דאַטע',
	'securepoll-header-end-date' => 'סוף דאַטע',
	'securepoll-subpage-vote' => 'שטימען',
	'securepoll-subpage-translate' => 'פֿאַרטײַטשן',
	'securepoll-subpage-list' => 'ליסטע',
	'securepoll-subpage-dump' => 'לאַגער',
	'securepoll-subpage-tally' => 'רעכענען',
	'securepoll-tally-title' => 'רעכענען: $1',
	'securepoll-tally-not-finished' => 'אנטשולדיגט, איר קענען נישט רעכענען די וואַלן ביז נאָך די אָפּשטימונג האט געקאנטשעט.',
	'securepoll-average-score' => 'דורכשניטלעכע פונקטן',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-invalid-page' => 'Ojúewéabẹ́ àìtọ́ "<nowiki>$1</nowiki>"',
	'securepoll-welcome' => '<strong>$1 Ẹkúàbọ̀!</strong>',
	'securepoll-return' => 'Padà sí $1',
	'securepoll-header-timestamp' => 'Àsìkò',
	'securepoll-header-voter-name' => 'Orúkọ',
	'securepoll-strike-reason' => 'Ìdíẹ̀:',
	'securepoll-strike-cancel' => 'Fagilé',
	'securepoll-details-link' => 'Ẹ̀kúnrẹ́rẹ́',
	'securepoll-header-action' => 'Ìgbéṣe',
	'securepoll-header-reason' => 'Ìdíẹ̀',
	'securepoll-header-admin' => 'Olùmójútó',
	'securepoll-translate-title' => 'Yédèpadà: $1',
	'securepoll-language-label' => 'Àṣàyàn èdè:',
	'securepoll-submit-select-lang' => 'Yédèpadà',
	'securepoll-header-title' => 'Orúkọ',
	'securepoll-header-start-date' => 'Ọjọ́ọdún ìbẹ̀rẹ̀',
	'securepoll-header-end-date' => 'Ọjọ́ọdún ìparí',
	'securepoll-subpage-vote' => 'Dìbò',
	'securepoll-subpage-translate' => 'Yédèpadà',
	'securepoll-subpage-list' => 'Àkójọ',
);

/** Cantonese (粵語)
 * @author Deryck Chan
 * @author Horacewai2
 * @author Lauhenry
 * @author Shinjiman
 * @author Waihorace
 */
$messages['yue'] = array(
	'securepoll' => '安全投票',
	'securepoll-desc' => '選舉同調查嘅擴展',
	'securepoll-invalid-page' => '無效嘅細頁 "<nowiki>$1</nowiki>"',
	'securepoll-need-admin' => '你需要係投票一位管理員去做呢個動作。',
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
	'securepoll-invalid-rank' => '錯嘅評分。你嘅評分必須要係1-999之間。',
	'securepoll-unranked-options' => '有啲項目未比分。
所有項目都要比一個介於1-999之間的分。',
	'securepoll-invalid-score' => '呢個分一定要係$1同$2之間。',
	'securepoll-unanswered-options' => '你一定要答全部問題',
	'securepoll-remote-auth-error' => '由伺服器度擷取你戶口時出錯。',
	'securepoll-remote-parse-error' => '由伺服器處理認證回應時出錯。',
	'securepoll-api-invalid-params' => '無效嘅參數。',
	'securepoll-api-no-user' => '呢個ID搵唔到用戶。',
	'securepoll-api-token-mismatch' => '安全幣唔對，唔可以登入。',
	'securepoll-not-logged-in' => '你一定要登入咗先可以響呢次選舉度投票',
	'securepoll-too-few-edits' => '對唔住，你唔可以投票。你需要有最少$1次編輯先可以投票，你而家有$2次。',
	'securepoll-too-new' => '對唔住，你唔投得票。$1之前註冊嘅用戶先有資格喺今次選舉投票，而你註冊嘅時間係$2。',
	'securepoll-blocked' => '對唔住，當你而家被封鎖嗰陣唔可以響呢次選舉度投票。',
	'securepoll-blocked-centrally' => '對唔住啦，你係$1個{{PLURAL:$1|wiki|wikis}}度俾人封咗，所以冇得投票啦。',
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
	'securepoll-strike-token-mismatch' => '部份資料唔見左',
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
	'securepoll-urandom-not-supported' => '呢個服務器唔支持加密嘅隨機數生成。
為左維護選民嘅隱私，只有公開提供洗牌時先會提供加密嘅選舉記錄，佢地可以用安全嘅隨機數流。',
	'securepoll-translate-title' => '翻譯: $1',
	'securepoll-invalid-language' => '無效嘅語言碼"$1"',
	'securepoll-submit-translate' => '更新',
	'securepoll-language-label' => '揀語言:',
	'securepoll-submit-select-lang' => '翻譯',
	'securepoll-entry-text' => '下面係投票一覽。',
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
	'securepoll-dump-corrupt' => 'Dump檔案唔能夠繼續',
	'securepoll-tally-upload-error' => '錯嘅dump檔案：$1',
	'securepoll-pairwise-victories' => '成對勝利矩陣',
	'securepoll-strength-matrix' => '實力矩陣嘅路徑',
	'securepoll-ranks' => '最後評分',
	'securepoll-average-score' => '平均分',
	'securepoll-round' => '第$1輪',
	'securepoll-spoilt' => '(廢票)',
	'securepoll-exhausted' => '(用盡)',
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
 * @author Anakmalaysia
 * @author Bencmq
 * @author Biŋhai
 * @author Deryck Chan
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
	'securepoll-too-new' => '对不起，您不能投票。$1，$3之前登记的帐户才能在这次选举中投票，而您登记的日期是$2，$4。',
	'securepoll-blocked' => '对不起，您目前被封禁因此无法参与本次投票。',
	'securepoll-blocked-centrally' => '对不起，由于你的帐户在至少一个{{PLURAL:$1|维基项目|维基项目}}被封禁，所以你并不能在这次选举中投票。',
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
	'securepoll-round' => '第$1轮',
	'securepoll-spoilt' => '(废票)',
	'securepoll-exhausted' => '(用尽)',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Anakmalaysia
 * @author Bencmq
 * @author Deryck Chan
 * @author FireJackey
 * @author Gaoxuewei
 * @author Liangent
 * @author Mark85296341
 * @author PhiLiP
 * @author Skjackey tse
 * @author Wong128hk
 * @author Yuyu
 */
$messages['zh-hant'] = array(
	'securepoll' => '安全投票',
	'securepoll-desc' => '投票及選舉擴充套件',
	'securepoll-invalid-page' => '無效子頁「<nowiki>$1</nowiki>」',
	'securepoll-need-admin' => '閣下須為選舉管理員才可進行此操作。',
	'securepoll-too-few-params' => '缺乏子頁參數（無效連結）。',
	'securepoll-invalid-election' => '「$1」並非有效之選舉編號。',
	'securepoll-welcome' => '<strong>歡迎$1！</strong>',
	'securepoll-not-started' => '這個選舉尚未開始。
按計畫將於 $2 $3 開始。',
	'securepoll-finished' => '投票已經結束，無法投票。',
	'securepoll-not-qualified' => '您不具有於是次選舉中參與表決的資格︰$1',
	'securepoll-change-disallowed' => '您已於是本次選舉中投票。
閣下恕未可再次投票。',
	'securepoll-change-allowed' => '<strong>注意：您曾經在本次投票中投下一票。
您可以提交下面的表格並更改您的選票。
請注意若您更改選票，原先的選票將作廢。',
	'securepoll-submit' => '遞交投票',
	'securepoll-gpg-receipt' => '多謝您參與投票。

閣下可以保留以下收條以作為參與過是次投票的憑證︰

<pre>$1</pre>',
	'securepoll-thanks' => '感謝，閣下的投票已被紀錄。',
	'securepoll-return' => '回到$1',
	'securepoll-encrypt-error' => '投票紀錄加密失敗。
您的投票未被紀錄。

$1',
	'securepoll-no-gpg-home' => '無法建立 GPG 主目錄。',
	'securepoll-secret-gpg-error' => '執行 GPG 出錯。
於 LocalSettings.php 中使用 $wgSecurePollShowErrorDetail=true; 以展示更多細節。',
	'securepoll-full-gpg-error' => '執行 GPG 錯誤：

命令：$1

錯誤：
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG 密匙配置錯誤。',
	'securepoll-gpg-parse-error' => '解釋 GPG 輸出時出錯。',
	'securepoll-no-decryption-key' => '解密密匙未配置。
無法解密。',
	'securepoll-jump' => '進入投票伺服器',
	'securepoll-bad-ballot-submission' => '您的投票無效︰$1',
	'securepoll-unanswered-questions' => '您必須回答所有問題。',
	'securepoll-invalid-rank' => '評級無效。給候選人的評級分數必須在 1 到 999 之間。',
	'securepoll-unranked-options' => '部分選項尚未評級。所有選項均應評級，且分數應在 1 到 999 之間。',
	'securepoll-invalid-score' => '分數必須介於 $1 和 $2 之間。',
	'securepoll-unanswered-options' => '您必須回答每一個問題。',
	'securepoll-remote-auth-error' => '在投票伺服器提取您的用戶資訊時出錯',
	'securepoll-remote-parse-error' => '伺服器驗證錯誤',
	'securepoll-api-invalid-params' => '參數無效',
	'securepoll-api-no-user' => '無法找到此指定 ID 的用戶。',
	'securepoll-api-token-mismatch' => '安全標記不符，無法登入。',
	'securepoll-not-logged-in' => '您必須在投票前登入。',
	'securepoll-too-few-edits' => '對不起，您未能參與投票。您必須最少進行 $1 次編輯才能參與本次投票，而您目前的編輯次數為 $2。',
	'securepoll-too-new' => '對不起，您不能投票。 $1，$3之前登記的帳戶才能在這次選舉中投票，而您登記的日期是$2，$4。',
	'securepoll-blocked' => '對不起，因為您目前已被封禁所以您無法參與本次投票。',
	'securepoll-blocked-centrally' => '對不起，由於你的帳戶在至少一個{{PLURAL:$1|維基項目|維基項目}}被封禁，所以你並不能在這次選舉中投票。',
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
	'securepoll-strike-token-mismatch' => '會話資料遺失',
	'securepoll-details-link' => '細節',
	'securepoll-details-title' => '投票詳情︰#$1',
	'securepoll-invalid-vote' => '「$1」不是有效的投票 ID',
	'securepoll-header-voter-type' => '投票用戶類型',
	'securepoll-voter-properties' => '投票人資訊',
	'securepoll-strike-log' => '刪除選票日誌',
	'securepoll-header-action' => '動作',
	'securepoll-header-reason' => '原因',
	'securepoll-header-admin' => '管理員',
	'securepoll-cookie-dup-list' => 'Cookie 重複的用戶',
	'securepoll-dump-title' => 'Dump：$1',
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
	'securepoll-no-upload' => '沒有上傳檔案。',
	'securepoll-dump-corrupt' => '無法處理損壞的轉儲檔案。',
	'securepoll-tally-upload-error' => '轉儲檔案記錄錯誤：$1',
	'securepoll-pairwise-victories' => '對比矩陣',
	'securepoll-strength-matrix' => 'Path strength 矩陣',
	'securepoll-ranks' => '最終排名',
	'securepoll-average-score' => '平均分',
	'securepoll-round' => '第$1輪',
	'securepoll-spoilt' => '(廢票)',
	'securepoll-exhausted' => '(用盡)',
);

/** Chinese (Hong Kong) (‪中文(香港)‬)
 * @author FireJackey
 * @author Skjackey tse
 */
$messages['zh-hk'] = array(
	'securepoll-dump-no-urandom' => '無法打開/dev/urandom。
為了保證投票者的私隱，經過加密的投票記錄只有在經隨機數據串干擾後方可公開。',
);

