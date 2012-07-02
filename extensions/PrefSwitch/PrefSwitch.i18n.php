<?php
/**
 * Internationalisation for Usability Initiative PrefSwitch extension
 *
 * @file
 * @ingroup Extensions
 */
$messages = array();

/** English
 * @author Roan Kattouw
 */
$messages['en'] = array(
	'prefswitch' => 'Usability Initiative preference switch',
	'prefswitch-desc' => 'Allow users to switch sets of preferences',
	/* User Tools Links */
	'prefswitch-link-anon' => 'New features',
	'tooltip-pt-prefswitch-link-anon' => 'Learn about new features',
	'prefswitch-link-on' => 'Take me back',
	'tooltip-pt-prefswitch-link-on' => 'Disable new features',
	'prefswitch-link-off' => 'New features',
	'tooltip-pt-prefswitch-link-off' => 'Try out new features',
	/* Page Content */
	'prefswitch-jswarning' => 'Remember that with the skin change, your [[User:$1/$2.js|$2 JavaScript]] will need to be copied to [[{{ns:user}}:$1/vector.js]] <!-- or [[{{ns:user}}:$1/common.js]]--> to continue working.',
	'prefswitch-csswarning' => 'Your [[User:$1/$2.css|custom $2 styles]] will no longer be applied. You can add custom CSS for vector in [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Yes',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Turn new features off',
	'prefswitch-survey-cancel-off' => 'If you would like to continue using the new features, you can return to $1.',
	'prefswitch-survey-submit-feedback' => 'Send feedback',
	'prefswitch-survey-cancel-feedback' => 'If you do not want to provide feedback, you can return to $1.',
	'prefswitch-survey-question-like' => 'What did you like about the new features?',
	'prefswitch-survey-question-dislike' => 'What did you dislike about the features?',
	'prefswitch-survey-question-whyoff' => 'Why are you turning off the new features?
Please select all that apply.',
	'prefswitch-survey-question-globaloff' => 'Do you want the features turned off globally?',
	'prefswitch-survey-answer-whyoff-hard' => 'The features were too hard to use.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'The features did not function properly.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'The features did not perform predictably.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'I did not like the way the features looked.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'I did not like the new tabs and layout.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'I did not like the new toolbar.',
	'prefswitch-survey-answer-whyoff-other' => 'Other reason:',
	'prefswitch-survey-question-browser' => 'Which browser do you use?',
	'prefswitch-survey-answer-browser-ie5' => 'Internet Explorer 5',
	'prefswitch-survey-answer-browser-ie6' => 'Internet Explorer 6',
	'prefswitch-survey-answer-browser-ie7' => 'Internet Explorer 7',
	'prefswitch-survey-answer-browser-ie8' => 'Internet Explorer 8',
	'prefswitch-survey-answer-browser-ie9' => 'Internet Explorer 9',
	'prefswitch-survey-answer-browser-ffb' => 'Firefox Beta',
	'prefswitch-survey-answer-browser-ff1' => 'Firefox 1',
	'prefswitch-survey-answer-browser-ff2' => 'Firefox 2',
	'prefswitch-survey-answer-browser-ff3' => 'Firefox 3',
	'prefswitch-survey-answer-browser-ff4' => 'Firefox 4',
	'prefswitch-survey-answer-browser-cb' => 'Google Chrome Beta',
	'prefswitch-survey-answer-browser-cd' => 'Google Chrome Dev',
	'prefswitch-survey-answer-browser-c1' => 'Google Chrome 1',
	'prefswitch-survey-answer-browser-c2' => 'Google Chrome 2',
	'prefswitch-survey-answer-browser-c3' => 'Google Chrome 3',
	'prefswitch-survey-answer-browser-c4' => 'Google Chrome 4',
	'prefswitch-survey-answer-browser-c5' => 'Google Chrome 5',
	'prefswitch-survey-answer-browser-c5' => 'Google Chrome 6',
	'prefswitch-survey-answer-browser-c5' => 'Google Chrome 7',
	'prefswitch-survey-answer-browser-c5' => 'Google Chrome 8',
	'prefswitch-survey-answer-browser-c5' => 'Google Chrome 9',
	'prefswitch-survey-answer-browser-c5' => 'Google Chrome 10',
	'prefswitch-survey-answer-browser-s3' => 'Safari 3',
	'prefswitch-survey-answer-browser-s4' => 'Safari 4',
	'prefswitch-survey-answer-browser-s5' => 'Safari 5',
	'prefswitch-survey-answer-browser-o9' => 'Opera 9',
	'prefswitch-survey-answer-browser-o9.5' => 'Opera 9.5',
	'prefswitch-survey-answer-browser-o10' => 'Opera 10',
	'prefswitch-survey-answer-browser-other' => 'Other browser:',
	'prefswitch-survey-question-os' => 'Which operating system do you use?',
	'prefswitch-survey-answer-os-windows' => 'Windows',
	'prefswitch-survey-answer-os-windowsmobile' => 'Windows Mobile',
	'prefswitch-survey-answer-os-macos' => 'Mac OS',
	'prefswitch-survey-answer-os-iphoneos' => 'iPhone OS',
	'prefswitch-survey-answer-os-ios' => 'iOS',
	'prefswitch-survey-answer-os-linux' => 'Linux',
	'prefswitch-survey-answer-os-other' => 'Other operating system:',
	'prefswitch-survey-answer-globaloff-yes' => 'Yes, turn the features off on all wikis',
	'prefswitch-survey-question-res' => 'What is the resolution of your screen?',
	'prefswitch-title-on' => 'New features',
	'prefswitch-title-switched-on' => 'Enjoy!',
	'prefswitch-title-off' => 'Turn new features off',
	'prefswitch-title-switched-off' => 'Thanks',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'New features are now turned on. We hope you enjoy using the new features. You may always turn them back off by clicking on the "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" link at the top of the page.',
	'prefswitch-success-off' => 'New features are now turned off. Thanks for trying the new features. You may always turn them back on by clicking on the "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" link at the top of the page.',
	'prefswitch-success-feedback' => 'Your feedback has been sent.',
	'prefswitch-return' => '<hr style="clear:both">
Return to <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| A screenshot of Wikipedia's new navigation interface <small>[[Media:VectorNavigation-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| A screenshot of the basic page editing interface <small>[[Media:VectorEditorBasic-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| A screenshot of the new dialog box for entering links
|}
|}
The Wikimedia Foundation's User Experience Team has been working with volunteers from the community to make things easier for you. We are excited to share some improvements, including a new look and feel and simplified editing features. These changes are intended to make it easier for new contributors to get started, and are based on our [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study usability testing conducted over the last year]. Improving the usability of our projects is a priority of the Wikimedia Foundation and we will be sharing more updates in the future. For more details, visit the related Wikimedia [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog post].

=== Here's what we have changed ===
* '''Navigation:''' We have improved the navigation for reading and editing pages. Now, the tabs at the top of each page more clearly define whether you are viewing the page or discussion page, and whether you are reading or editing a page.
* '''Editing toolbar improvements:''' We have reorganized the editing toolbar to make it easier to use. Now, formatting pages is simpler and more intuitive.
* '''Link wizard:''' An easy-to-use tool allows you to add links to other wiki pages as well as links to external sites.
* '''Search improvements:''' We have improved search suggestions to get you to the page you are looking for more quickly.
* '''Other new features:''' We have also introduced a table wizard to make creating tables easier and a find and replace feature to simplify page editing.
* '''Wikipedia logo:''' We have updated our logo. Read more at the [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog].",
	'prefswitch-main-logged-changes' => "* The '''{{int:watch}} tab''' is now a star.
* The '''{{int:move}} tab''' is now in the dropdown next to the search bar.",
	'prefswitch-main-feedback' => "===Feedback?===
We would love to hear from you. Please visit our [[$1|feedback page]] or, if you are interested in our ongoing efforts to improve the software, visit our [http://usability.wikimedia.org usability wiki] for more information.",
	'prefswitch-main-anon' => "===Take me back===
[$1 Click here to turn off the new features]. You will be asked to login or create an account first.",
	'prefswitch-main-on' => "===Take me back!===
[$2 Click here to turn off the new features].",
	'prefswitch-main-off' => "===Try them out!===
[$1 Click here to enable the new features].",
	'prefswitch-survey-intro-feedback' => 'We would love to hear from you.
Please fill out the optional survey below before clicking "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Thanks for trying out our new features.
To help us improve them, please fill out the optional survey below before clicking "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Message documentation (Message documentation)
 * @author Deadelf
 * @author EugeneZelenko
 * @author Hamilton Abreu
 * @author Lloffiwr
 * @author McDutchie
 * @author Mormegil
 * @author Platonides
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'prefswitch-desc' => '{{desc}}',
	'prefswitch-link-anon' => 'A link in the personal tools menu which takes users to a page where they can learn more about the new features.',
	'prefswitch-link-on' => 'A link in the personal tools menu which takes users to a page where they can turn the new features off',
	'prefswitch-link-off' => 'A link in the personal tools menu which takes users to a page where they can turn the new features on',
	'prefswitch-jswarning' => 'Warning about copying the custom javascript. Only shown if the user has a monobook.js file.',
	'prefswitch-csswarning' => 'Warning about monobook CSS no longer being applied. Only shown if the user has a monobook.css file.',
	'prefswitch-survey-true' => 'Used in a form where it is a radio button label from the PrefSwitch questionnaire module to answer Yes or No to a question ([http://commons.wikimedia.org/w/index.php?title=Special:UsabilityInitiativePrefSwitch&mode=feedback example]).

It is not in used at the referred page, as of 16 May 2010.

{{Identical|Yes}}',
	'prefswitch-survey-false' => 'Used in a form where it is a radio button label from the PrefSwitch questionnaire module to answer Yes or No to a question ([http://commons.wikimedia.org/w/index.php?title=Special:UsabilityInitiativePrefSwitch&mode=feedback example]).

It is not in used at the referred page, as of 16 May 2010.

{{Identical|No}}',
	'prefswitch-survey-cancel-feedback' => '$1 is a link to the main page of the wiki in question.',
	'prefswitch-survey-answer-whyoff-hard' => 'Should be generic enough to be used as an option for questions:
*{{msg-mw|Optin-survey-question-whyoptout}}
*{{msg-mw|Prefswitch-survey-question-whyoff}}.',
	'prefswitch-survey-answer-whyoff-didntwork' => '{{MediaWiki:Prefswitch-survey-answer-whyoff-hard/qqq}}',
	'prefswitch-survey-answer-whyoff-notpredictable' => '{{MediaWiki:Prefswitch-survey-answer-whyoff-hard/qqq}}',
	'prefswitch-survey-answer-whyoff-other' => '{{Identical|Other reason}}',
	'prefswitch-return' => 'Parameters:
* $1 is a URL to the page came from
* $2 is the title of the page came from',
	'prefswitch-main' => 'The three default screenshots are in English and kept on Wikimedia Commons. If you want them to be in your language you will either need to create them yourself, and upload them onto Wikimedia Commons, or ask for help to make these from colleagues on your home wiki.',
	'prefswitch-main-feedback' => 'Entry asking for feedback in a local page.',
	'prefswitch-main-anon' => 'Is used on Special:UsabilityInitiativePrefSwitch at Wikimedia.org.',
	'prefswitch-feedbackpage' => '{{doc-important|The name of the user experience feedback page on this wiki. Should only be translated for ja, es, de, fr, it, ru, pl, pt, nl for now. Do not translate "Project:"}}',
);

/** Afrikaans (Afrikaans)
 * @author Adriaan
 * @author Deadelf
 * @author Naudefj
 */
$messages['af'] = array(
	'prefswitch' => 'Voorkeure vir Bruikbaarheidsinisiatief wissel',
	'prefswitch-desc' => 'Laat gebruikers toe om voorkeurstelle te kies.',
	'prefswitch-link-anon' => 'Nuwe funksies',
	'tooltip-pt-prefswitch-link-anon' => 'Vind meer uit aangaande die nuwe funksies',
	'prefswitch-link-on' => 'Neem my terug',
	'tooltip-pt-prefswitch-link-on' => 'Skakel nuwe funksies af',
	'prefswitch-link-off' => 'Nuwe funksies',
	'tooltip-pt-prefswitch-link-off' => 'Probeer die nuwe funksies',
	'prefswitch-jswarning' => 'Onthou dat by skin-verandering sal u [[User:$1/$2.js|$2 JavaScript]] na [[{{ns:user}}:$1/vector.js]] <!-- of [[{{ns:user}}:$1/common.js]]--> gekopieer moet word om dit nog steeds te laat werk.',
	'prefswitch-csswarning' => 'U [[User:$1/$2.css|persoonlike $2-style]] sal nie meer toegepas word nie. U kan persoonlike CSS vir Vector by [[{{ns:user}}:$1/vector.css]] wysig.',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nee',
	'prefswitch-survey-submit-off' => 'Skakel nuwe funksies af',
	'prefswitch-survey-cancel-off' => 'Indien u wil aanhou om die nuwe funksies te gebruik, kan u terugkeer na $1.',
	'prefswitch-survey-submit-feedback' => 'Stuur terugvoer',
	'prefswitch-survey-cancel-feedback' => 'As u nie wil terguvoer gee nie, kan u terugkeer na $1 toe.',
	'prefswitch-survey-question-like' => 'Waarvan het u gehou betreffende die nuwe funksies?',
	'prefswitch-survey-question-dislike' => 'Waarvan het u nie gehou nie betreffende die nuwe funksies?',
	'prefswitch-survey-question-whyoff' => 'Om watse rede is u besig om die nuwe funksies af te skakel?
Kies asseblief alles wat van toepassing is.',
	'prefswitch-survey-answer-whyoff-hard' => 'Die nuwe funksies was te moeilik om te gebruik.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Die nuwe funksies het nie korrek gewerk nie.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Die nuwe funksies het nie gewerk soos verwag was nie.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Ek het nie gehou van hoe die nuwe funkies lyk nie.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Ek hou nie van die nuwe oortjies en uitleg nie.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ek hou nie van die nuwe wysigingsbalk nie.',
	'prefswitch-survey-answer-whyoff-other' => 'Ander rede:',
	'prefswitch-survey-question-browser' => 'Watter webblaaier gebruik u?',
	'prefswitch-survey-answer-browser-other' => 'Ander webblaaier:',
	'prefswitch-survey-question-os' => 'Watter bedryfstelsel gebruik u?',
	'prefswitch-survey-answer-os-other' => 'Ander bedryfstelsel:',
	'prefswitch-survey-question-res' => 'Wat is die resolusie van u skerm?',
	'prefswitch-title-on' => 'Nuwe funksies',
	'prefswitch-title-switched-on' => 'Geniet dit!',
	'prefswitch-title-off' => 'Skakel nuwe funksies af',
	'prefswitch-title-switched-off' => 'Dankie',
	'prefswitch-title-feedback' => 'Terugvoer',
	'prefswitch-success-on' => 'Die nuwe funkies is nou aangeskakel. Ons hoop u geniet dit om die nuwe funksies te gebruik. U kan hulle enige tyd afsit deur op die "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" skakel bo-aan die bladsy te klik.',
	'prefswitch-success-off' => 'Nuwe funksies is nou afgeskakel. Dankie dat u die nuwe funksies probeer het. U kan hulle enige tyd weer aanskakel deur op die "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" skakel bo-aan die bladsy te klik.',
	'prefswitch-success-feedback' => 'U terugvoer is gestuur.',
	'prefswitch-return' => '<hr style="clear:both">
Keer terug na <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| 'n Skermkiekie van Wikipedia se nuwe navigasiekoppelvlak <small>[[Media:VectorNavigation-en.png|(vergroot)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| 'n Skermkiekie van die basiese bladsywysigingskoppevlak <small>[[Media:VectorEditorBasic-en.png|(vergroot)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| 'n Skermkiekie van die nuwe dialoog vir die invoer van skakels.
|}
|}
Die Wikimedia Foundation se Gebruikerervarings Span (User Experience Team) in samewerking met vrywilligers van die gemeenskap, het gewerk daaraan om dinge makliker te maak. Ons is opgewonde om 'n paar van die verbeteringe te deel met u, insluitende 'n nuwe voorkoms en gevoel, sowel as eenvoudige redegeringsfunksies. Die bedoeling van hierdie veranderinge is om dit makliker te maak vir nuwe gebruikers om aan die gang te kom, en is gebaseer op ons [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study bruikbaarheidstoetse, uitgevoer deur die loop van die laaste jaar]. Die verbetering van die bruikbaarheid van ons projekte is 'n prioriteit vir Wikimedia Foundation en ons sal in die toekoms meer opgraderings met u deel. Vir meer besonderhede, besoek gerus die verwante Wikimedia [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia webjoernaalinskrywing].

=== Hier is wat ons verander het ===
* '''Navigasie:''' Ons het die navigase vir die lees en redegering van bladsye verbeter. Nou is die oortjies bo-aan elke bladsy beter gedefiniëer óf u nou besig is om die bladsy of sy besprekingsblad te beskou, óf die bladsy deur lees of te wysig.
* '''Redigeringsnutsbalk verbeteringe:''' Ons het die redegeringsnutbalk hergeörganiseer, sodat dit makliker is om te gebruik. Dit is nou meer eenvoudig en intuïtief om bladsye se formaat te wysig.
* '''Skakel assistent:''' 'n Maklik om te gebruik stukkie gereedskap wat jou toelaat om skakels na ander wiki bladsye sowel as skakels na eksterne webwerve by te voeg.
* '''Soektog verbeteringe:''' Ons het soektogvoorstelle verbeter, sodat jy vinniger by die bladsy kan uitkom waarvoor jy soek.
* '''Ander nuwe funksies:''' Ons het 'n assistent bygevoeg wat die maak van tabelle makliker maak en 'n vind-en-vervang funksie om die redigering van bladsye te vereenvoudig.
* '''Wikipedia logo:''' Ons het ons logo opdateer. Lees meer daaroor in die [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia webjoernaal].",
	'prefswitch-main-logged-changes' => "* Die '''{{int:watch}}'''-oortjie is nou in die vorm van 'n stêr.
* Die '''{{int:move}}'''-oortjie kan nou gevind word in die opsielys langs die soekveld.",
	'prefswitch-main-feedback' => '===Terugvoer?===
Ons sal dit waardeer om van jou af te hoor. Besoek asseblief ons [[$1|terugvoer bladsy]] of, as u belangstel in ons aanhoudende pogings om die sagteware te verbeter, besoek gerus ons [http://usability.wikimedia.org bruikbaarheids-wiki] vir meer inligting.',
	'prefswitch-main-anon' => "===Neem my terug===
[$1 Klik hier om die nuwe funkies af te skakel]. U sal gevra word om in te teken of om eerstens 'n nuwe rekening te skep.",
	'prefswitch-main-on' => '===Vat my terug!===
[$2 Klik hier om die nuwe funksies af te skakel].',
	'prefswitch-main-off' => '===Probeer die nuwe funksies!===
[$1 Klik hier om die nuwe funksies aan te skakel].',
	'prefswitch-survey-intro-feedback' => 'Ons sal regtig waardeer om van u te hoor.
Vul asseblief die opsionele vraelys in voordat u "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" klik.',
	'prefswitch-survey-intro-off' => 'Dankie dat u die nuwe funksies uitprobeer het.
Om ons te help met die verbetering daarvan kan u gerus die opsionele vraelys invul, voor u "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" klik.',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'prefswitch' => 'Përdorshmërisë kaloni Nisma preferencë',
	'prefswitch-desc' => 'Lejo përdoruesit të kaloni grupe të preferencave',
	'prefswitch-link-anon' => 'Tipare të reja',
	'tooltip-pt-prefswitch-link-anon' => 'Mësoni rreth karakteristika të reja',
	'prefswitch-link-on' => 'Merrni më mbrapa',
	'tooltip-pt-prefswitch-link-on' => 'Disable karakteristika të reja',
	'prefswitch-link-off' => 'Tipare të reja',
	'tooltip-pt-prefswitch-link-off' => 'Provoni karakteristika të reja',
	'prefswitch-survey-true' => 'Po',
	'prefswitch-survey-false' => 'Jo',
	'prefswitch-survey-submit-off' => 'Turn off karakteristika të reja',
	'prefswitch-survey-cancel-off' => 'Nëse dëshironi të vazhdoni përdorimin e tipare të reja, ju mund të ktheheni tek $1.',
	'prefswitch-survey-submit-feedback' => 'Send feedback',
	'prefswitch-survey-cancel-feedback' => 'Nëse ju nuk dëshironi të japin mendimet, ju mund të ktheheni tek $1.',
	'prefswitch-survey-question-like' => 'Çfarë ju pëlqen në lidhje me tipare të reja?',
	'prefswitch-survey-question-dislike' => 'Çfarë keni antipati për tiparet?',
	'prefswitch-survey-question-whyoff' => 'Pse jeni kthyer tek pjesa e tipare të reja? Ju lutemi zgjidhni të gjitha që aplikohet.',
	'prefswitch-survey-answer-whyoff-hard' => "Karakteristika ishin tepër të vështirë për t'u përdorur.",
	'prefswitch-survey-answer-whyoff-didntwork' => 'Karakteristika nuk funksionojnë siç duhet.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Karakteristika nuk ka kryer parashikueshme.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Unë nuk e pëlqen mënyra tiparet e shikuar.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Unë nuk e kam si skedat e reja dhe layout.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Unë nuk e kam si toolbar re.',
	'prefswitch-survey-answer-whyoff-other' => 'arsye të tjera:',
	'prefswitch-survey-question-browser' => 'Cili browser do you use?',
	'prefswitch-survey-answer-browser-other' => 'browser tjera:',
	'prefswitch-survey-question-os' => 'Cili sistem operativ do you use?',
	'prefswitch-survey-answer-os-other' => 'sistemit të tjera operative:',
	'prefswitch-survey-question-res' => 'Cila është zgjidhja e ekranit tuaj?',
	'prefswitch-title-on' => 'Tipare të reja',
	'prefswitch-title-switched-on' => 'Enjoy!',
	'prefswitch-title-off' => 'Turn off karakteristika të reja',
	'prefswitch-title-switched-off' => 'Falënderim',
	'prefswitch-title-feedback' => 'Reagim',
	'prefswitch-success-on' => 'Tipare të reja janë kthyer tani në. Ne shpresojmë që të gëzojnë duke përdorur tipare të reja. Ju mund gjithmonë të kthehet prapa atyre jashtë duke klikuar mbi "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" në krye të faqes.',
	'prefswitch-success-off' => 'Tipare të reja janë kthyer tani off. Faleminderit për përpjekjen tipare të reja. Ju mund gjithmonë të kthehet përsëri në ato duke klikuar mbi "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" në krye të faqes.',
	'prefswitch-success-feedback' => 'Your feedback është dërguar.',
	'prefswitch-return' => '<hr style="clear:both"> Kthehuni tek <span class="plainlinks">[$1 $2].</span>',
	'prefswitch-main' => "Ne kemi punuar shumë për të bërë gjërat më të lehtë për përdoruesit tanë. Ne jemi të ngazëllyer për të ndarë disa përmirësime, duke përfshirë një vështrim të ri dhe të ndjehen dhe të thjeshtuar karakteristika redaktimi. Përmirësimi i përdorshmërisë e projekteve tona është një përparësi e Fondacionit Wikimedia dhe ne do të jetë ndarja rejat më shumë në të ardhmen. Për më shumë detaje, vizitoni lidhur [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Wikimedia blog] post.[[File:UsabilityNavigation.png|right|link=|Screenshot i navigacion ri]][[File:UsabilityToolbar.png|right|link=|pamjen e zgjeruar toolbar redakto]][[File:UsabilityDialogs.png|right|link=|pamjen e përmbajtjes dialogs brezi i ri]]
=== Ja se çfarë ne kemi ndryshuar ===
* '''Navigation''': Ne kemi përmirësuar navigacion për lexim dhe të redaktoni. Tani, në skedat në krye të secilës faqe më të përcaktojë qartë nëse ju jeni duke shfletuar faqe apo faqe diskutimi, dhe nëse ju jeni duke lexuar ose redaktoni një faqe.
* '''Redaktimi përmirësime toolbar''': Ne kemi riorganizuar toolbar editing për të bërë më të lehtë për t'u përdorur. Tani, formatimit faqe është e thjeshtë dhe më i kuptueshëm.",
	'prefswitch-main-anon' => '=== Merrni Me Kthehu ===
Nëse dëshironi të fikur tipare të reja, [$1 klikoni këtu]. Ju do të pyeteni për të identifikoheni ose krijoni një llogari të parë.',
	'prefswitch-main-on' => '=== Çoni përsëri! ===
Nëse dëshironi të fikur tipare të reja, ju lutem [$2 klikoni këtu].',
	'prefswitch-main-off' => '=== Provo ato! ===
Nëse ju dëshironi të kthehet në tipare të reja, ju lutem [$1 klikoni këtu].',
	'prefswitch-survey-intro-feedback' => 'Ne do të duan të dëgjojmë nga ju. Ju lutem plotësoni këtë anketë opsional më poshtë para se të klikoni "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Faleminderit për përpjekje të reja nga karakteristikat tona. Për të na ndihmuar në përmirësimin e tyre, ju lutemi plotësoni këtë anketë opsional më poshtë para se të klikoni "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'prefswitch' => "Commutador de preferencias d'a Iniciativa d'Usabilitat",
	'prefswitch-desc' => 'Permite a os usuarios de cambiar conchuntos de preferencias',
	'prefswitch-link-anon' => 'Nuevas caracteristicas',
	'tooltip-pt-prefswitch-link-anon' => 'Más información sobre as nuevas caracteristicas',
	'prefswitch-link-on' => 'Tornar enta zaga',
	'tooltip-pt-prefswitch-link-on' => 'Desactivar as nuevas caracteristicas',
	'prefswitch-link-off' => 'Nuevas caracteristicas',
	'tooltip-pt-prefswitch-link-off' => 'Prebe as nuevas caracteristicas',
	'prefswitch-jswarning' => "Recuerde que con o cambio d'aparencia habrá de copiar o suyo JavaScript de [[User:$1/$2.js|$2]] enta [[{{ns:user}}:$1/vector.js]] <!-- o [[{{ns:user}}:$1/common.js]]--> ta que contine funcionando.",
	'prefswitch-csswarning' => "O suyo [[User:$1/$2.css|estilo personalizato $2]] ya no s'aplicará. Puet adhibir CSS personalitzatos ta un vector en [[{{ns:user}}:$1/vector.css]].",
	'prefswitch-survey-true' => 'Sí',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Desactivar as nuevas caracteristicas',
	'prefswitch-survey-cancel-off' => 'Si deseya continar emplegando as nuevas caracteristicas puet tornar ta $1.',
	'prefswitch-survey-submit-feedback' => 'Ninviar a suya opinión',
	'prefswitch-survey-cancel-feedback' => 'Si no quiere fer garra comentario puet tornar ta $1.',
	'prefswitch-survey-question-like' => "Que li ha feito goyo d'as nuevas funcionalidatz?",
	'prefswitch-survey-question-dislike' => "Que no li ha feito goyo d'as nuevas funcionalidatz?",
	'prefswitch-survey-question-whyoff' => 'Por qué quiere desactivar as nuevas funcionalidatz? 
Por favor, trigue todas as opcions que correspondan.',
	'prefswitch-survey-question-globaloff' => 'Deseya desactivar as nuevas funcionalidatz globalment?',
	'prefswitch-survey-answer-whyoff-hard' => "As funcionalidatz yeran muit dificils d'usar.",
	'prefswitch-survey-answer-whyoff-didntwork' => 'As funcionalidatz no funcionoron como cal.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'As funcionalidatz tenioron comportamientos impredictibles.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "No me'n ha feito goyo l'aspecto.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "No me'n han feito goyo as nuevas pestanyas ni o nuevo formato.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => "No me'n ha feito goyo a nueva barra de ferramientas.",
	'prefswitch-survey-answer-whyoff-other' => 'Atra razón:',
	'prefswitch-survey-question-browser' => 'Que navegador emplega?',
	'prefswitch-survey-answer-browser-other' => 'Belatro navegador:',
	'prefswitch-survey-question-os' => 'Qué sistema operativo fa servir?',
	'prefswitch-survey-answer-os-other' => 'Belatro sistema operativo:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sí, desactivar as nuevas caracteristicas en totz os wikis',
	'prefswitch-survey-question-res' => "Quál ye a resolución d'a suya pantalla?",
	'prefswitch-title-on' => 'Nuevas caracteristicas',
	'prefswitch-title-switched-on' => 'Disfrute!',
	'prefswitch-title-off' => 'Desactivar as nuevas caracteristicas',
	'prefswitch-title-switched-off' => 'Gracias',
	'prefswitch-title-feedback' => 'Comentarios',
	'prefswitch-success-on' => "S'han activato as nuevas caracteristicas. Esperamos que li faigan goyo. Siempre puede tornar enta zaga fendo clic en o vinclo «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» en o cobalto d'a pachina.",
	'prefswitch-success-off' => "S'han desactivato as nuevas caracteristicas. Gracias por prebar-las. Siempre puede tornar enta zaga fendo clic en o vinclo «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» en o cobalto d'a pachina.",
	'prefswitch-success-feedback' => "S'ha ninviato a suya opinión",
	'prefswitch-return' => '<hr style="clear:both">
Tornar ta <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Muestra d'a nueva interficie de navegación d'a Wikipedia <small>[[Media:VectorNavigation-en.png|(ampliar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Muestra d'a interficie d'edición basica de pachinas <small>[[Media:VectorEditorBasic-en.png|(ampliar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Muestra d'a nueva caixa de dialogo ta introducir vinclos
|}
|}

L'equipo d'experiencia d'usuario (''User Experience Team'') d'a Fundación Wikimedia ha estato treballando con voluntarios d'a comunidat ta fer-li as cosas más sencillas. Somos ansiosos por compartir qualques milloras, incluyindo-ie un nuevo aspecto y a simplificación d'as funcions d'edición. Istos cambios son pensatos ta que os nuevos colaborador lo tiengan más fácil ta escomenzar y se basan en as nuestras [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study prebas d'usabilidat feitas entre l'anyo pasato]. A millora d'a usabilidat d'os nuestros prochectos ye una prioridat d'a Fundación Wikipedia y compartiremos más actualizacions en o futuro. Ta trobar más información leiga o mensache publicato en o [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ blog de Wikimedia].

===O que hemos cambiato===
* '''Navegación''': Hemos amillorato a navegación por a lectura y edición de pachinas. Agora, as pestanyas d'a parte superior de cada pachina definen más clarament si ye mirando a pachina prencipal u a de discusión, u si ye leyendo u editando una pachina.
* '''Milloras en a barra de ferramientas d'edición''': Hemos reorganizato a barra de ferramientas d'edición ta que sía más fácil d'emplegar. Agora, dar formato a las pachinas ye más fácil y intuitivo.
* '''Asistent ta vinclos''': Una ferramienta de buen usar li permite d'adhibir vinclos ta atras pachinas wiki, asinas como vinclos a sitios externos.
* '''Milloras en a busca''': Hemos amillorato as sucherencias de busca ta trobar más rapidament a pachian que ye mirando.
* '''Atras caracteristicas nuevas''': Tamién hemos introduciu un asistent ta fer más fácil a creyación de tablas y una función de trobar y substituir ta simplificar a modificación de pachinas.
* '''Logotipo de Wikipedia''': Hemos esviellato o nuestro logotipo. En trobará más información en o  [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blog de Wikimedia].",
	'prefswitch-main-logged-changes' => "* A '''pestanya {{int:watch}}''' ye agora una estrela.
* A '''pestanya {{int:move}}''' ye agora en un menú desplegable a canto d'a barra de busca.",
	'prefswitch-main-feedback' => "===Tien comentarios a fer?===
Nos fería goyo de conoixer-los. Puede vesitar a nuestra [[$1|pachina de comentarios]] u, si ye intresato en as fayenas en marcha por amillorar o software, vesite o nuestro [http://usability.wikimedia.org wiki d'usabilitat] ta más información.",
	'prefswitch-main-anon' => '===Tornar enta zaga===
Si deseya desactivar as nuevas caracteristicas [$1 faiga clic aquí]. Habrá de rechistrar-se u creyar una cuenta.',
	'prefswitch-main-on' => '===Tornar enta zaga!===
[$2 Faiga clic aquí ta desactivar as nuevas caracteristicas].',
	'prefswitch-main-off' => '===Prebe-lo!===
Si deseya activar as nuevas funcionalidatz [$1 faiga clic aquí].',
	'prefswitch-survey-intro-feedback' => "Nos fería goyo de saber as suyas impresions.
Por favor, replene o formulario opcional d'aquí abaixo antes de fer clic en «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]».",
	'prefswitch-survey-intro-off' => "Gracias por prebar as nuevas caracteristicas.
Ta duyar-nos a amillorar-las, replene por favor o formulario opcional d'aquí abaixo antes de fer clic en «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».",
	'prefswitch-feedbackpage' => "Project:Comentarios sobre a experiencia de l'usuario",
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author عمرو
 */
$messages['ar'] = array(
	'prefswitch' => 'مُبدّل تفضيلات مبادرة الاستخدامية',
	'prefswitch-desc' => 'اسمح للمستخدمين بتبديل أجزاء من تفضيلاتهم',
	'prefswitch-link-anon' => 'المزايا الجديدة',
	'tooltip-pt-prefswitch-link-anon' => 'اعرف المزايا الجديدة',
	'prefswitch-link-on' => 'أرجعني',
	'tooltip-pt-prefswitch-link-on' => 'عطّل المزايا الجديدة',
	'prefswitch-link-off' => 'المزايا الجديدة',
	'tooltip-pt-prefswitch-link-off' => 'جرّب المزايا الجديدة',
	'prefswitch-jswarning' => 'تذكر أنه بعد التغير للشكل الجديد، سيتعين عليك نقل [[User:$1/$2.js|جافاسكربت $2]] إلى [[{{ns:user}}:$1/vector.js]] <!-- أو [[{{ns:user}}:$1/common.js]]--> ليستمر عملها.',
	'prefswitch-csswarning' => 'لن تطبق [[User:$1/$2.css|أساليبك ل$2]]. يمكنك إضافة CSS مخصصة لفكتور في [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'نعم',
	'prefswitch-survey-false' => 'لا',
	'prefswitch-survey-submit-off' => 'عطّل المزايا الجديدة',
	'prefswitch-survey-cancel-off' => 'إذا أردت الاستمرار في استخدام المزايا الجديدة، فإمكانك الرجوع إلى $1.',
	'prefswitch-survey-submit-feedback' => 'أرسل ملاحظات',
	'prefswitch-survey-cancel-feedback' => 'إذا لم ترغب في تقديم الملاحظات، فبإمكانك الرجوع إلى $1.',
	'prefswitch-survey-question-like' => 'ماذا أحببت في المميزات الجديدة؟',
	'prefswitch-survey-question-dislike' => 'ما الذي لم يعجبك في المميزات الجديدة؟',
	'prefswitch-survey-question-whyoff' => 'لماذا ستعطل المزايا الجديدة؟
من فضلك اختر كل ما يناسب.',
	'prefswitch-survey-answer-whyoff-hard' => 'كان استخدامها صعبًا جدًا.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'لم تؤدِ مهمتها كما ينبغي.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'لم تعمل كما توقّعت.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'لم يعجبني شكلها.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'لم تعجبني الألسنة الجديدة ولا التصميم الجديد.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'لم يعجبني شريط الأدوات الجديد.',
	'prefswitch-survey-answer-whyoff-other' => 'سبب آخر:',
	'prefswitch-survey-question-browser' => 'ما المتصفح الذي تستخدمه؟',
	'prefswitch-survey-answer-browser-other' => 'متصفح آخر:',
	'prefswitch-survey-question-os' => 'ما نظام التشغيل الذي تستخدمه؟',
	'prefswitch-survey-answer-os-other' => 'نظام تشغيل آخر:',
	'prefswitch-survey-question-res' => 'ما أبعاد شاشتك؟',
	'prefswitch-title-on' => 'مزايا جديدة',
	'prefswitch-title-switched-on' => 'استمتع!',
	'prefswitch-title-off' => 'عطّل المزايا الجديدة.',
	'prefswitch-title-switched-off' => 'شكرًا',
	'prefswitch-title-feedback' => 'ملاحظات',
	'prefswitch-success-on' => 'المزايا الجديدة مُفعلة. نتمنى أن تعجبك المزايا الجديدة. في حال أردت أن تعود للعمل بالمميزات القدمة، قم بالضغط على [[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]] في أعلى الصفحة.',
	'prefswitch-success-off' => 'لقد عُطلّت المزايا الجديدة. شكرا لك على تجربتها. لك أن تُمكّنها في أي لحظة بالنقر مجدّدًا على وصلة "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" في أعلى الصفحة.',
	'prefswitch-success-feedback' => 'لقد أُرسلت ملاحظاتك.',
	'prefswitch-return' => '<hr style="clear:both">
عُد إلى <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "<div dir=\"rtl\">
{| border=\"0\" align=\"left\" style=\"margin-right:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| لقطة شاشة لواجهة تصفح ويكيبيديا الجديدة <small>[[Media:VectorNavigation-en.png|(كبّر)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| لقطة شاشة لواجهة صفحة التحرير الأساسية <small>[[Media:VectorEditorBasic-en.png|(كبّر)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| لقطة شاشة لصندوق حوار إدخال الوصلات الجديد
|}
|}
عمل فريق تجربة الاستخدام في مؤسسة ويكيميديا مع متطوعين من المجتمع على جعل الأمور أسهل عليك. إننا متحمسون لمشاركة بعض التحسينات التي من بينها شكل جديد ومبسّط لواجهة التحرير. يراد بهذه التغييرات تسهيل انضمام المساهمين الجدد، وهي مبنية على [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study اختبارات استخدامية أجريناها طوال السنة الماضية]. إن تحسين استخدامية مشاريعنا أحد أولويات مؤسسة ويكيميديا وسنعلن عن تحديثات في المستقبل. لمزيد من التفاصيل، زُر [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia تدوينة] ويكيميديا (بالإنجليزية) بهذا الخصوص.

=== أدناه ما غيرنا ===
* '''التصفح:''' لقد حسّنا تصفح صفحات القراءة والتحرير. توضح الألسنة في أعلى الصفحات فيما إذا كنت في صفحة أو في صفحة نقاش، وفيما إذا كنت تقرأ صفحة أو تُعدّلها.
* '''تحسينات في شريط أدوات التحرير:''' أعدنا تنظيم شريط أدوات التحرير ليصبح أسهل استخدامًا. لقد أصبح تنسيق الصفحات أسهل وأوضح.
* '''معالج الوصلات:''' وهي أداة سهلة الاستخدام تسمح لك بإضافة وصلات لصفحات ويكي أخرى أو صفحات مواقع خارجية.
* '''تحسين البحث:''' لقد حسّنا اقتراحات البحث لتصل إلى الصفحة التي تريدها بشكل أسرع.
* '''مزايا جديدة أخرى:''' أضفنا أيضًا معالج جداول ليصبح إنشاء الجداول أسهل وأضفنا خاصية بحث واستبدال لتيسير تحرير الصفحات.
* '''شعار ويكيبيديا''': لقد حدثنا شعارنا. اقرأ المزيد عن ذلك في [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d مدونة ويكيمييديا] (بالإنجليزية).
</div>",
	'prefswitch-main-logged-changes' => "* '''لسان {{int:watch}}''' الآن عبارة عن نجمة.
* '''لسان {{int:move}}''' الآن موجود في القائمة المنسدلة المجاورة لصندوق البحث.",
	'prefswitch-main-feedback' => '=== ألديك ملاحظات؟ ===
سوف نسعد بسماع رأيك. من فضلك زُر صفحة [[$1|الملاحظات]] أو -إن كنت مهتمًا بالمساعي المتواصلة لتحسين البرنامج- فزر [http://usability.wikimedia.org ويكي الاستخدامية] لمزيد من المعلومات.',
	'prefswitch-main-anon' => '== أرجعني ==
[$1 انقر هنا لتعطيل المزايا الجديدة]. سوف يُطلب منك الدخول أو إنشاء حساب أولا.',
	'prefswitch-main-on' => '=== أرجعني! ===
[$2 انقر هنا لتعطيل المزايا الجديدة]',
	'prefswitch-main-off' => '=== جرّبها! ===
إذا أردت تفعيل المزايا الجديدة، [$1 فانقر هنا] من فضلك.',
	'prefswitch-survey-intro-feedback' => 'يسعدنا سماع صوتك.
من فضلك عبّئ الاستبيان الاختياري أدناه قبل نقر [[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]].',
	'prefswitch-survey-intro-off' => 'شكرا لك على تجربة المزايا الجديدة.
لتساعدنا في تحسين هذه المزايا، من فضلك عبّئ الاستبيان الاختياري أدناه قبل نقر [[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]',
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 * @author Michaelovic
 */
$messages['arc'] = array(
	'prefswitch-link-anon' => 'ܦܪ̈ܘܫܝܐ ܚܕ̈ܬܐ',
	'prefswitch-link-on' => 'ܦܢܝ ܠܝ ܠܒܬܪܐ',
	'prefswitch-link-off' => 'ܦܪ̈ܘܫܝܐ ܚܕ̈ܬܐ',
	'prefswitch-survey-true' => 'ܐܝܢ',
	'prefswitch-survey-false' => 'ܠܐ',
	'prefswitch-survey-submit-feedback' => 'ܫܕܪ ܡܥܝܪ̈ܢܘܬܐ',
	'prefswitch-survey-answer-whyoff-other' => 'ܥܠܬܐ ܐܚܪܬܐ:',
	'prefswitch-survey-answer-browser-other' => 'ܡܦܐܬܢܐ ܐܚܪܢܐ:',
	'prefswitch-title-on' => 'ܦܪ̈ܘܫܝܐ ܚܕ̈ܬܐ',
	'prefswitch-title-switched-on' => 'ܚܕܘ!',
	'prefswitch-title-switched-off' => 'ܬܘܕܝ',
	'prefswitch-title-feedback' => 'ܡܥܝܪ̈ܢܘܬܐ',
);

/** Bashkir (Башҡорт)
 * @author Assele
 */
$messages['ba'] = array(
	'prefswitch' => 'Юзабилити инициативаһы мөмкинлектәрен көйләү',
	'prefswitch-desc' => 'Ҡатнашыусыларға көйләүҙәр йыйынтығын үҙгәртергә мөмкинлек бирә',
	'prefswitch-link-anon' => 'Яңы мөмкинлектәр',
	'tooltip-pt-prefswitch-link-anon' => 'Яңы мөмкинлектәр тураһында',
	'prefswitch-link-on' => 'Элекке торошҡа ҡайтарырға',
	'tooltip-pt-prefswitch-link-on' => 'Яңы мөмкинлектәрҙе һүндерергә',
	'prefswitch-link-off' => 'Яңы мөмкинлектәр',
	'tooltip-pt-prefswitch-link-off' => 'Яңы мөмкинлектәрҙе һынап ҡарағыҙ',
	'prefswitch-jswarning' => 'Күренеш үҙгәреү менән, ул артабан эшләһен өсөн, һеҙҙең [[User:$1/$2.js|$2 JavaScript]] [[{{ns:user}}:$1/vector.js]] <!-- йәки [[{{ns:user}}:$1/common.js]]--> файлына күсерелегә тейеш икәнен иҫегеҙҙә тотоғоҙ.',
	'prefswitch-csswarning' => 'Һеҙҙең [[User:$1/$2.css| «$2» күренеше өсөн шәхси биҙәлешегеҙ]] артабан ҡулланылмаясаҡ. Һеҙ үҙегеҙҙең CSS көйләүҙәрегеҙҙе «Векторлы» күренеш өсөн [[{{ns:user}}:$1/vector.css]] файлына өҫтәй алаһығыҙ.',
	'prefswitch-survey-true' => 'Эйе',
	'prefswitch-survey-false' => 'Юҡ',
	'prefswitch-survey-submit-off' => 'Яңы мөмкинлектәрҙе һүндерергә',
	'prefswitch-survey-cancel-off' => 'Әгәр яңы мөмкинлектәрҙе артабан ҡулланырға теләһәгеҙ, $1 битенә кире ҡайта алаһығыҙ.',
	'prefswitch-survey-submit-feedback' => 'Баһалама ебәрергә',
	'prefswitch-survey-cancel-feedback' => 'Әгәр баһалама ебәрергә теләмәһәгеҙ, $1 битенә ҡайта алаһағыҙ.',
	'prefswitch-survey-question-like' => 'Һеҙгә яңы мөмкинлектәрҙә нимә оҡшаны?',
	'prefswitch-survey-question-dislike' => 'Һеҙгә яңы мөмкинлектәрҙә нимә оҡшаманы?',
	'prefswitch-survey-question-whyoff' => 'Ниңә һеҙ яңы мөмкинлектәрҙе һүндерәһегеҙ?
Бөтә тап килгән яуаптарҙы һайлағыҙ, зинһар.',
	'prefswitch-survey-question-globaloff' => 'Һеҙ яңы мөмкинлектәрҙе дөйөм һүндерергә теләйһегеҙме?',
	'prefswitch-survey-answer-whyoff-hard' => 'Уларҙы ҡулланыуы бик ауыр.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Улар тейешлесә эшләмәй.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Улар көтөлгәнсә эшләмәй.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Миңә тышҡы ҡиәфәте оҡшамай.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Миңә яңы бүлгестәр һәм төҙөлөшө оҡшаманы.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Миңә яңы мөхәррирләү панеле оҡшаманы.',
	'prefswitch-survey-answer-whyoff-other' => 'Башҡа сәбәп:',
	'prefswitch-survey-question-browser' => 'Һеҙ ниндәй браузер ҡулланаһығыҙ?',
	'prefswitch-survey-answer-browser-other' => 'Башҡа браузер:',
	'prefswitch-survey-question-os' => 'Һеҙ ниндәй операцион система ҡулланаһығыҙ?',
	'prefswitch-survey-answer-os-other' => 'Башҡа операцион система:',
	'prefswitch-survey-answer-globaloff-yes' => 'Эйе, был мөмкинлектәрҙе бөтә вики проекттарҙа һүндерергә',
	'prefswitch-survey-question-res' => 'Экранығыҙҙың киңәйтелмәһе ниндәй?',
	'prefswitch-title-on' => 'Яңы мөмкинлектәр',
	'prefswitch-title-switched-on' => 'Рәхәтләнегеҙ!',
	'prefswitch-title-off' => 'Яңы мөмкинлектәрҙе һүндерергә',
	'prefswitch-title-switched-off' => 'Рәхмәт',
	'prefswitch-title-feedback' => 'Баһалама ебәреү',
	'prefswitch-success-on' => 'Әлеге мәлдә яңы мөмкинлектәр ҡулланыла. Һеҙгә улар оҡшар, тип өмөт итәбеҙ. Һеҙ уларҙы үҙегеҙ теләгән ваҡытта, биттең өҫкө өлөшөндәге "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" һылтанмаһына баҫып, һүндерә алаһығыҙ.',
	'prefswitch-success-off' => 'Яңы мөмкинлектәр һүндерелгән. Уларҙы һынап ҡарауығыҙ өсөн рәхмәт. Һеҙ уларҙы үҙегеҙ теләгән ваҡытта, биттең өҫкө өлөшөндәге "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" һылтанмаһына баҫып, ҡабаттан ҡуллана башлай алаһығыҙ.',
	'prefswitch-success-feedback' => 'Һеҙҙең баһаламағыҙ ебәрелде.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span> битенә ҡайтырға.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-ba.png|401px|]]
|-
| Википедияның яңы бүлектәргә күсеү интерфейсы <small>[[Media:VectorNavigation-ba.png|(ҙурайтырға)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-ba.png|401px|]]
|-
| Төп биттәр мөхәррирләү интерфейсы <small>[[Media:VectorEditorBasic-ba.png|(ҙурайтырға)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-ba.png|401px|]]
|-
| Һылтанмалар өҫтәү өсөн яңы диалог
|}
|}
Викимедиа Фондының проектты ҡулланыуҙы тикшереү төркөмө берләшмәнең ирекле ҡатнашыусылары менән берлектә һеҙгә  уңайлыҡтар булдырыу өсөн төрлө эштәр башҡарҙы. Беҙ яңы интерфейс һәм еңелләштерелгән мөхәррирләү ҡоралдары һымаҡ ҡайһы бер яҡшыртыуҙарҙы һеҙҙең менән бүлешеүебеҙгә бик шатбыҙ. Был үҙгәрештәр яңы килгән ҡатнашыусыларҙың эш башлауын еңелләштереү өсөн керетелгән һәм [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study уҙған йылда үткәрелгән ҡулланыуҙы тикшереү һөҙөмтәләренә] нигеҙләнгән. Уңайлы интерфейс булдырыу - Викимедиа Фондының төп мәсьәләһе булып тора, һәм беҙ проектты артабан яҡшыртасаҡбыҙ. Күберәк мәғлүмәт алыр өсөн, [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Викимедиа блогы] битенә керегеҙ.

=== Нимәләрҙе беҙ үҙгәрттек ===
* '''Күсеү.''' Беҙ бүлектәр араһында күсеүҙе яҡшырттыҡ һәм хәҙер биттәрҙе уҡыуы һәм мөхәррирләүе уңайлыраҡ. Һәр биттең башындағы бүлгестәр һеҙ әлеге ваҡытта нимә менән булаһығыҙ — битте йәки уның буйынса фекер алышыуҙы уҡыйһығыҙмы, әллә битте мөхәррирләйһегеҙме икәнен анығыраҡ күрһәтә.
* '''Мөхәррирләү ҡоралдары.''' Беҙ ҡулланыуы уңайлы булһын өсөн, мөхәррирләү ҡоралдары панелен үҙгәрттек. Хәҙер биттәрҙе форматлау еңелерәҡ һәм аңлайышлыраҡ.
* '''Һылтанмалар өҫтәү ҡоралы.''' Ҡулланыуға ябай булған ҡорал вик-биттәргә лә, тышҡы биттәргә лә илтеүсе һылтанмалар өҫтәргә мөмкинлек бирә.
* '''Эҙләү.''' Һеҙгә кәрәкле битте тиҙерәк табырға ярҙам итер өсөн, беҙ  эҙләү ваҡытында сыҡҡан тәҡдимдәр теҙмәһен яҡшырттыҡ.  
* '''Башҡа яңы мөмкинлектәр.''' Беҙ таблицаларҙы еңел булдырырға мөмкинлек биргән таблица эшләү ҡоралын өҫтәнек, шулай уҡ мөхәррирләүҙе еңелләштергән эҙләү һәм алмаштырыу ҡоралдарын өҫтәнек.
* '''Логотип.''' Беҙ логотипты яңырттыҡ. [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Викимедиа Фонды блогы] битендә ентеклерәк уҡығыҙ.",
	'prefswitch-main-logged-changes' => "* '''«{{int:watch}}» бүлеге''' хәҙер йондоҙ формаһында.
* ''' «{{int:move}}» бүлеге''' хәҙер эҙләү юлы янындағы асыла торған менюла урынлашҡан.",
	'prefswitch-main-feedback' => '=== Баһалама ебәреү ===
Беҙ һеҙҙең баһаламағыҙҙы ишетергә теләр инек. Зинһар, [[$1|баһалама ебәреү битенә]] керегеҙ. Әгәр һеҙҙе беҙҙең программаны яҡшыртыу буйынса артабанғы эштәребеҙ ҡыҙыҡһындырһа, [http://usability.wikimedia.org вики юзабилити проекты битенә] керегеҙ.',
	'prefswitch-main-anon' => '===Элекке торошҡа ҡайтарырға===
[$1 Яңы мөмкинлектәрҙе һүндерер өсөн, ошонда баҫығыҙ]. Һеҙгә башта танылырға йәки яңы иҫәп яҙыуын булдырырға тәҡдим ителәсәк.',
	'prefswitch-main-on' => '===Элекке торошҡа ҡайтарырға===
[$2 Яңы мөмкинлектәрҙе һүндерер өсөн, ошонда баҫығыҙ].',
	'prefswitch-main-off' => '===Һынап ҡарарға===
[$1 Яңы мөмкинлектәрҙе ҡуллана башлар өсөн, ошонда баҫығыҙ].',
	'prefswitch-survey-intro-feedback' => 'Беҙ һеҙҙең фекерегеҙҙе ишетергә теләр инек. Зинһар, «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]» һылтанмаһына баҫыр алдынан, түбәндәге мөһим булмаған һорауҙарға яуап бирегеҙ.',
	'prefswitch-survey-intro-off' => 'Яңы мөмкинлектәрҙе һынап ҡарағанығыҙ өсөн рәхмәт.
Беҙгә уларҙы яҡшыртырға ярҙам итер өсөн, зинһар «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]» һылтанмаһына баҫыр алдынан, түбәндәге мөһим булмаған һорауҙарға яуап бирегеҙ.',
	'prefswitch-feedbackpage' => 'Project:Отзывы о новом оформлении',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'prefswitch-link-anon' => 'Naiche Funkzionen',
	'prefswitch-link-on' => 'Zruck zur oiden Owerflächen',
	'prefswitch-link-off' => 'Naiche Funkzionen',
);

/** Belarusian (Беларуская)
 * @author Maksim L.
 */
$messages['be'] = array(
	'prefswitch-link-on' => 'Вярнуць як было',
	'prefswitch-survey-true' => 'Так',
	'prefswitch-survey-false' => 'Не',
	'prefswitch-survey-submit-feedback' => 'Адправіць заўвагі',
	'prefswitch-survey-answer-whyoff-other' => 'Іншая прычына:',
	'prefswitch-survey-question-browser' => 'Якім браўзерам Вы карыстаецеся?',
	'prefswitch-survey-answer-browser-other' => 'Іншы браўзер:',
	'prefswitch-survey-question-os' => 'Якой аперацыйнай сістэмай Вы карыстаецеся?',
	'prefswitch-survey-answer-os-other' => 'Іншая аперацыйная сістэма:',
	'prefswitch-title-switched-off' => 'Дзякуй',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'prefswitch' => 'Пераключальнік установак Ініцыятывы па паляпшэньні зручнасьці і прастаты выкарыстаньня',
	'prefswitch-desc' => 'Дазваляе ўдзельнікам пераключаць наборы ўстановак',
	'prefswitch-link-anon' => 'Новыя магчымасьці',
	'tooltip-pt-prefswitch-link-anon' => 'Даведацца пра новыя магчымасьці',
	'prefswitch-link-on' => 'Вярнуцца',
	'tooltip-pt-prefswitch-link-on' => 'Выключыць новыя магчымасьці',
	'prefswitch-link-off' => 'Новыя магчымасьці',
	'tooltip-pt-prefswitch-link-off' => 'Паспрабуйце новыя магчымасьці',
	'prefswitch-jswarning' => 'Памятайце, што пасьля зьмены афармленьня Ваш [[User:$1/$2.js|JavaScript для $2]] мусіць быць скапіяваны да [[{{ns:user}}:$1/vector.js]] <!-- ці [[{{ns:user}}:$1/common.js]]-->, каб працаваў далей.',
	'prefswitch-csswarning' => 'Вашыя [[User:$1/$2.css|стылі для $2]] у гэтым афармленьні не працуюць. Вы можаце дадаць новыя CSS-стылі да [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Так',
	'prefswitch-survey-false' => 'Не',
	'prefswitch-survey-submit-off' => 'Выключыць новыя магчымасьці',
	'prefswitch-survey-cancel-off' => 'Калі Вы жадаеце працягваць выкарыстаньне новых магчымасьцяў, Вы можаце вярнуцца да $1.',
	'prefswitch-survey-submit-feedback' => 'Даслаць водгук',
	'prefswitch-survey-cancel-feedback' => 'Калі Вы не жадаеце дасылаць водгук, Вы можаце вярнуцца да $1.',
	'prefswitch-survey-question-like' => 'Што Вам спадабалася ў новых магчымасьцях?',
	'prefswitch-survey-question-dislike' => 'Што Вам не спадабалася ў магчымасьцях?',
	'prefswitch-survey-question-whyoff' => 'Чаму Вы выключаеце новыя магчымасьці?
Калі ласка, выберыце ўсе пасуючыя варыянты.',
	'prefswitch-survey-question-globaloff' => 'Вы жадаеце выключыць новыя магчымасьці глябальна?',
	'prefswitch-survey-answer-whyoff-hard' => 'Занадта складаны ў выкарыстаньні.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Ён не працуе належным чынам.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Ён працуе не як чакалася.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Мне не спадабаўся зьнешні выгляд.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Мне не спадабаліся новыя закладкі і кампаноўка.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Мне не спадабалася новая панэль інструмэнтаў.',
	'prefswitch-survey-answer-whyoff-other' => 'Іншая прычына:',
	'prefswitch-survey-question-browser' => 'Якім браўзэрам Вы карыстаецеся?',
	'prefswitch-survey-answer-browser-other' => 'Іншы браўзэр:',
	'prefswitch-survey-question-os' => 'Якой апэрацыйнай сыстэмай Вы карыстаецеся?',
	'prefswitch-survey-answer-os-other' => 'Іншая апэрацыйная сыстэма:',
	'prefswitch-survey-answer-globaloff-yes' => 'Так, выключыць новыя магчымасьці ва ўсіх вікі',
	'prefswitch-survey-question-res' => 'Якое разрозьненьне Вашага манітора?',
	'prefswitch-title-on' => 'Новыя магчымасьці',
	'prefswitch-title-switched-on' => 'Цешцеся!',
	'prefswitch-title-off' => 'Выключыць новыя магчымасьці',
	'prefswitch-title-switched-off' => 'Дзякуй',
	'prefswitch-title-feedback' => 'Зваротная сувязь',
	'prefswitch-success-on' => 'Новыя магчымасьці уключаныя. Мы спадзяемся, што Вам спадабаецца карыстацца новымі магчымасьцямі. Вы ў любы момант можаце іх адключыць, націснуўшы «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]», якая знаходзіцца ўверсе старонкі.',
	'prefswitch-success-off' => 'Новыя магчымасьці выключаныя. Дзякуй за выпрабаваньне новых магчымасьцяў. Вы ў любы момант можаце іх уключыць, націснуўшы «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]», якая знаходзіцца ўверсе старонкі.',
	'prefswitch-success-feedback' => 'Ваш водгук дасланы.',
	'prefswitch-return' => '<hr style="clear:both">
Вярнуцца да <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorNavigation-be-tarask.png|401px|]]
|-
| Новы навігацыйны інтэрфэйс Вікіпэдыі <small>[[Media:VectorNavigation-be-tarask.png|(павялічыць)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorEditorBasic-be-tarask.png|401px|]]
|-
| Выгляд новай старонкі рэдагаваньня <small>[[Media:VectorEditorBasic-be-tarask.png|(павялічыць)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorLinkDialog-be-tarask.png|401px|]]
|-
| Здымак акна для даданьня спасылак
|}
|}
Каманда аналізу Фундацыі «Вікімэдыя» шмат працавала з валянтэрамі ад супольнасьці, каб палегчыць вашу працу зь Вікіпэдыяй і іншымі праектамі. Мы вельмі рады паказаць вам некаторыя ўдасканаленьні, у тым ліку новае афармленьне і спрашчэньне працэсу рэдагаваньня. На гэтыя зьмены, зробленыя на аснове [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study вынікаў тэставаньня новых функцыяў за апошні год], ускладзенае палягчэньне працы для новых удзельнікаў. Паляпшэньне зручнасьці карыстаньня нашымі праектамі зьяўляецца прыярытэтам для Фундацыі «Вікімэдыя», таму мы яшчэ падзелімся абнаўленьнямі ў будучыні. Каб даведацца болей, наведайце адмысловы [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia запіс у блогу Фундацыі «Вікімэдыя»] на гэтую тэму.

=== Што мы зьмянілі ===
* '''Навігацыя:''' Мы палепшылі навігацыю для чытаньня і рэдагаваньня старонак. Цяпер закладкі ў верхняй частцы кожнай старонкі дазваляюць дакладней зразумець, што Вы праглядаеце: артыкул ці старонку абмеркаваньня, а таксама, ці Вы чытаеце, ці рэдагуеце старонку.
* '''Паляпшэньні панэлі рэдагаваньня:''' Мы перапрацавалі панэль рэдагаваньня для таго, каб зрабіць яе болей простай у выкарыстаньні. Цяпер фарматаваньне старонак робіцца болей лёгкі і інтуітыўным шляхам.
* '''Майстар стварэньня спасылак:''' Лёгкі ў выкарыстаньні інструмэнт дазваляе Вам дадаваць спасылкі на іншыя старонкі так сама, як і на вонкавыя сайты.
* '''Паляпшэньні пошуку:''' Мы палепшылі пошукавыя падказкі, каб хутчэй паказаць неабходную Вам старонку.
* '''Іншыя магчымасьці:''' Мы таксама ўвялі майстар стварэньня табліцаў для палягчэньня іх стварэньня і магчымасьць пошуку і замены для палягчэньня рэдагаваньня старонак.
* '''Лягатып Вікіпэдыі''': Мы зьмянілі лягатып. Падрабязнасьці глядзіце ў [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ блогу Фундацыі «Вікімэдыя»].",
	'prefswitch-main-logged-changes' => "* '''Закладка {{int:watch}}''' цяпер паказваецца зоркай.
* '''Закладка {{int:move}}''' цяпер у выкідным мэню каля акна пошуку.",
	'prefswitch-main-feedback' => '=== Зваротная сувязь ===
Мы жадаем пачуць ад Вас водгук. Калі ласка, пакіньце свой водгук на [[$1|старонцы зваротнай сувязі]]. Калі вы зацікаўленыя ў далейшым удасканаленьні праграмнага забесьпячэньня і карыстаньня, наведайце сайт [http://usability.wikimedia.org Ініцыятывы па паляпшэньню зручнасьці карыстаньня].',
	'prefswitch-main-anon' => '===Вярнуцца===
Калі Вы жадаеце выключыць новыя магчымасьці, [$1 націсьніце тут]. Вас папросяць спачатку увайсьці ў сыстэму альбо стварыць новы рахунак.',
	'prefswitch-main-on' => '===Вярніце ўсё назад!===
[$2 націсьніце тут, каб выключыць новыя магчымасьці].',
	'prefswitch-main-off' => '===Паспрабуйце іх!===
Калі Вы жадаеце ўключыць новыя магчымасьці, калі ласка, [$1 націсьніце тут].',
	'prefswitch-survey-intro-feedback' => 'Мы жадаем даведацца пра Вашыя меркаваньні.
Калі ласка, адкажыце на некалькі пытаньняў ніжэй, перад тым як націснуць «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]».',
	'prefswitch-survey-intro-off' => 'Дзякуй за тое, што паспрабавалі новыя магчымасьці.
Каб дапамагчы нам іх палепшыць, калі ласка, адкажыце на некалькі пытаньняў ніжэй, перад тым як націснуць «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».',
	'prefswitch-feedbackpage' => 'Project:Водгукі ўдзельнікаў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Stanqo
 * @author Turin
 */
$messages['bg'] = array(
	'prefswitch-survey-true' => 'Да',
	'prefswitch-survey-false' => 'Не',
	'prefswitch-survey-answer-whyoff-other' => 'Друга причина:',
	'prefswitch-survey-question-browser' => 'Кой браузър използвате?',
	'prefswitch-survey-answer-browser-other' => 'Друг браузър:',
	'prefswitch-survey-question-os' => 'Каква операционна система използвате?',
	'prefswitch-survey-answer-os-other' => 'Друга операционна система:',
	'prefswitch-title-on' => 'Нови функционалности',
	'prefswitch-title-switched-on' => 'Наслаждавайте се!',
	'prefswitch-title-switched-off' => 'Благодарности',
	'prefswitch-title-feedback' => 'Обратна връзка',
	'prefswitch-success-off' => 'Новите функции са изключени.',
	'prefswitch-return' => '<hr style="clear:both">
Назад към <span class="plainlinks">[$1 $2]</span>.',
);

/** Bahasa Banjar (Bahasa Banjar)
 * @author Ezagren
 * @author J Subhi
 */
$messages['bjn'] = array(
	'prefswitch-desc' => 'Ijinakan pamuruk maubah aturan kakatujuan',
	'prefswitch-link-anon' => 'Muha hanyar',
	'tooltip-pt-prefswitch-link-anon' => 'Balajar muha hanyar',
	'prefswitch-link-on' => 'Anggung ulun mantuk',
	'tooltip-pt-prefswitch-link-on' => 'Pajahakan muha hanyar',
	'prefswitch-link-off' => 'Muha hanyar',
	'tooltip-pt-prefswitch-link-off' => 'Tarai muha hanyar',
	'prefswitch-survey-true' => 'Ya',
	'prefswitch-survey-false' => 'Kada',
	'prefswitch-survey-submit-off' => 'Pajahakan muha hanyar',
	'prefswitch-survey-cancel-off' => 'Kalu Pian handak tarus mamakai muha hanyar ini, Pian hingkat mantuk ka $1.',
	'prefswitch-survey-submit-feedback' => 'Kirim kitihan mantuk',
	'prefswitch-survey-cancel-feedback' => 'Kalu Pian kada handak mambariakan kitihan mantuk, Pian hingkat mantuk ka $1.',
	'prefswitch-survey-question-like' => 'Apa nang Pian katujui pasal muha hanyar ini?',
	'prefswitch-survey-question-dislike' => 'Apa nang Pian kada katuju pasal muha hanyar ini?',
	'prefswitch-survey-question-whyoff' => 'Mangapa Pian mamajahakan muha hanyar ini?
Harap pilih samunyaan nang bujur.',
	'prefswitch-survey-answer-whyoff-hard' => 'Talalu ngalih gasan digunaakan',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Kada kawa bagawi lawan baik.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Ulun kada katuju tampaian muhanya.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Ulun kada katuju lawan tab hanyar wan tampaiannya.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ulun kada katuju kutak pakakas nang hanyar.',
	'prefswitch-survey-answer-whyoff-other' => 'Alasan lainnya:',
	'prefswitch-survey-question-res' => 'Barapa ganal ukuran layar Pian?',
	'prefswitch-title-on' => 'Muha hanyar',
	'prefswitch-title-switched-on' => 'Salamat manikmati!',
	'prefswitch-title-off' => 'Pajahakan muha hanyar',
	'prefswitch-title-switched-off' => 'Tarima kasih',
	'prefswitch-title-feedback' => 'Kitihan mantuk',
	'prefswitch-success-off' => 'Muha hanyar wayahini sudah dipajahakan. Tarima kasih sudah manarai muha hanyar. Pian hingkat manggunakannya pulang lawan manikin tautan "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" di atas tungkaran.',
	'prefswitch-success-feedback' => 'Kitihan mantuk Pian sudah takirim.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'prefswitch' => 'ইউজাবিলিটি ইনিশিয়েটিভ পছন্দের সুইচ',
	'prefswitch-desc' => 'ব্যবহারকারীদের পছন্দগুলোকে বেছে নেওয়ার সুযোগ দিন',
	'prefswitch-link-anon' => 'নতুন বৈশিষ্ট্যাবলী',
	'tooltip-pt-prefswitch-link-anon' => 'নতুন বৈশিষ্ট্যাবলী সম্পর্কে জানুন',
	'prefswitch-link-on' => 'পূর্বের অবস্থায় ফিরে যাও',
	'tooltip-pt-prefswitch-link-on' => 'নতুন বৈশিষ্ট্যাবলী নিস্ক্রিয়',
	'prefswitch-link-off' => 'নতুন বৈশিষ্ট্যাবলী',
	'tooltip-pt-prefswitch-link-off' => 'নতুন বৈশিষ্ট্যগুলো ব্যবহার করুন',
	'prefswitch-jswarning' => 'মনে রাখবেন স্কিনের পরিবর্তনের সাথে সাথে, কাজ যাবার জন্য আপনার [[User:$1/$2.js|মনোবুক জাভাস্ক্রিপ্টকে]] কপি করে [[{{ns:user}}:$1/vector.js]]-এ <!-- or [[{{ns:user}}:$1/common.js]]--> নিয়ে যাওয়া প্রয়োজন।',
	'prefswitch-csswarning' => 'আপনার [[User:$1/$2.css|পরিবর্তিত $2 স্টাইল]] আর প্রযোজ্য হবে না। আপনি ভেক্টর স্কিনে পরিবর্তিত সিএসএস-এর জন্য [[{{ns:user}}:$1/vector.css]] তৈরি করতে পারেন।',
	'prefswitch-survey-true' => 'হ্যাঁ',
	'prefswitch-survey-false' => 'না',
	'prefswitch-survey-submit-off' => 'নতুন বৈশিষ্ট্য বন্ধ করো',
	'prefswitch-survey-cancel-off' => 'আপনি যদি নতুন বৈশিষ্ট্যাবলী ব্যবহার চালিয়ে যেতে চান তবে আপনি $1-এ ফিরে যেতে পারেন।',
	'prefswitch-survey-submit-feedback' => 'প্রতিক্রিয়া পাঠান',
	'prefswitch-survey-cancel-feedback' => 'আপনি যদি প্রতিক্রিয়া দিতে না চান, তাহলে আপনি $1 -এ ফিরে যেতে পারেন।',
	'prefswitch-survey-question-like' => 'নতুন বৈশিষ্ট্যগুলোর মধ্যে আপনার কি পছন্দ হয়েছিলো?',
	'prefswitch-survey-question-dislike' => 'নতুন বৈশিষ্ট্যগুলোর মধ্যে আপনার কি পছন্দ হয়নি?',
	'prefswitch-survey-question-whyoff' => 'আপনি কেন নতুন বৈশিষ্ট্যাবলী বন্ধ করছেন?
অনুগ্রহ করে যা প্রযোজ্য তা নির্বাচন করুন।',
	'prefswitch-survey-answer-whyoff-hard' => 'এতে কাজ করা কঠিন।',
	'prefswitch-survey-answer-whyoff-didntwork' => 'এটি ঠিক মত কাজ করে না।',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'এটি আন্দাজ মত কাজ করে না।',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'এটা দেখতে যেমন তা আমার পছন্দ নয়।',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'নতুন ট্যাব এবং বিন্যাস আমার পছন্দ হয়নি।',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'নতুন টুলবার আমার পছন্দ হয়নি।',
	'prefswitch-survey-answer-whyoff-other' => 'অন্য কারণ:',
	'prefswitch-survey-question-browser' => 'আপনি কোন ব্রাউজার ব্যবহার করেন?',
	'prefswitch-survey-answer-browser-other' => 'অন্য ব্রাউজার:',
	'prefswitch-survey-question-os' => 'আপনি কোন অপারেটিং সিস্টেম ব্যবহার করেন?',
	'prefswitch-survey-answer-os-other' => 'অন্য অপারেটিং সিস্টেম:',
	'prefswitch-survey-question-res' => 'আপনার পর্দার রেজ্যুলেশন কত?',
	'prefswitch-title-on' => 'নতুন বৈশিষ্ট্যাবলী',
	'prefswitch-title-switched-on' => 'উপভোগ করুন!',
	'prefswitch-title-off' => 'নতুন বৈশিষ্ট্যাবলী বন্ধ করো',
	'prefswitch-title-switched-off' => 'ধন্যবাদ',
	'prefswitch-title-feedback' => 'প্রতিক্রিয়া',
	'prefswitch-success-on' => 'নতুন বৈশিষ্ট্যগুলো চালু হয়েছে। আমরা আশা করছি নতুন বৈশিষ্ট্যগুলো আপনি উপভোগ করবেন। আপনি যে-কোনো সময় পাতার ওপরের "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" লিংকে ক্লিক করে পূর্বের অবস্থায় ফিরে যেতে পারবেন।',
	'prefswitch-success-off' => 'নতুন বৈশিষ্ট্যাবলী বন্ধ করা হয়েছে। নতুন বৈশিষ্ট্যগুলো চেষ্টা করে দেখার জন্য ধন্যবাদ। আপনি যে-কোনো সময় পাতার ওপরে অবস্থিত "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" লিংকে ক্লিক করে পূর্বের অবস্থায় ফিরে যেতে পারবেন।',
	'prefswitch-success-feedback' => 'আপনার প্রতিক্রিয়া পাঠানো হয়েছে।',
	'prefswitch-return' => '<hr style="clear:both">
ফিরে যান <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| উইকিপিডিয়ার নতুন নেভিগেশন ইন্টারফেসের একটি স্ক্রিনশট <small>[[Media:VectorNavigation-en.png|(বড় করুন)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| মূল সম্পাদনা ইন্টারফেসের একটি স্ক্রিনশট <small>[[Media:VectorEditorBasic-en.png|(বড় করুন)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| লিংক প্রবেশের জন্য নতুন ডায়ালগ বক্স ব্যবস্থার একটি স্ক্রিনশট
|}
|}
উইকিমিডিয়া ফাউন্ডেশনের ইউজার এক্সপেরিয়েন্স টিম সম্প্রদায় থেকে আসা ব্যবহারকারীদের সাথে একসাথে আপনার জন্য সবকিছু আরও সহজ করার উদ্দেশ্যে নিয়ে কাজ করে চলেছে। আমরা উৎসাহের সাথে আমাদের উন্নয়নের কিছু নমুনা আপনার সাথে ভাগাভাগি করছি, যার মধ্যে আছে উইকিমিডিয়া প্রকল্পের নতুন অবয়ব এবং সহজ ও সমৃদ্ধ সম্পাদনা প্যানেল। এই পরিবর্তনগুলো নতুন অবদানকারীদের শুরু করার ক্ষেত্রে আরও সহজ ভূমিকা রাখবে, এবং [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study গত বছর ধরে নানা পরীক্ষা-নিরীক্ষার] মাধ্যমে এই পরিবর্তনগুলো সাধিত হয়েছে। আমাদের প্রকল্পগুলোর ব্যবহার পদ্ধতির উন্নয়ন সাধন উইকিমিডিয়া ফাউন্ডেশন অগ্রাধিকার হিসেবে বিবেচনা করে এবং আমরাও ভবিষ্যতে আরও হালনাগাদ আপনার সাথে ভাগাভাগি করবো। আরও তথ্যের জন্য এ বিষয় সম্পর্কিত উইকিমিডিয়া [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia ব্লগ পোস্ট দেখুন]।

=== যা কিছু পরিবর্তিত হয়েছে ===
* '''নেভিগেশন:''' আমরা পাতা পঠন ও সম্পাদনা পদ্ধতির আরও উন্নয়ন সাধন করেছি। এখন পাতার ওপরের ট্যাবগুলো খুব পরিষ্কারভাবে আপনাকে বুঝতে সাহায্য করবে যে আপনি মূল নাকি আলাপ পাতায় আছেন, সেই সাথে আপনি পাতাটি পড়ছেন না সম্পাদনা করছেন।
* '''সম্পাদনা প্যানেলের উন্নয়ন:''' আমরা সম্পাদনা প্যানেলকে আপনার জন্য আরও সহজভাবে উপস্থাপন করেছি। এখন কোনো পাতা সম্পাদনা পূর্বের চেয়ে আরও সহজ ও স্বজ্ঞাত।
* '''লিংক উইজার্ড:''' একটি সহজ পদ্ধতির মাধ্যমে আপনি অন্য যে-কোনো উইকির পাতায়, সেই সাথে বাইরের কোনো ওয়েবসাইটের পাতার লিংক যোগ করতে পারবেন।
* '''অনুসন্ধানের উন্নয়ন:''' আপনার অনুসন্ধানকৃত পাতাটি দ্রুত খুঁজে পেতে আমরা আমাদের অনুসন্ধান পরামর্শেরও উন্নয়ন সাধন করেছি।
* '''অন্যান্য নতুন সুবিধাদি:''' আমরা টেবিল উইজার্ড নামক একটি সুবিধা সংযোজন করেছি। এর ফলে আপনি সহজেই কোনো পাতায় টেবিল যোগ করতে পারবেন। এছাড়া আমরা লেখা অনুসন্ধান ও পরিবর্তনের সুবিধা যুক্ত করেছি, যা পাতা সম্পাদনাকে আরও সহজ করে তুলবে।
* '''উইকিপিডিয়া লোগো:''' আমরা আমাদের লোগো হালনাগাদ করেছি। [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d উইকিমিডিয়া ব্লগে] এ বিষয়ে আরও বিস্তারিত পড়ুন।",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} ট্যাবটি''' বর্তমানে তারকাখচিত।
* '''{{int:move}} ট্যাবটি''' এখন অনুসন্ধান বক্সের পাশের ড্রপডাউন অংশে রয়েছে।",
	'prefswitch-main-feedback' => '===ফিডব্যাক?===
আমরা আপনার থেকে শুনতে আগ্রহী। অনুগ্রহপূর্বক আমাদের [[$1|ফিডব্যাক পাতা]] দেখুন, এবং আপনি যদি সফটওয়্যারের উন্নয়নের জন্য আমাদের চলমান প্রচেষ্টা সম্মন্ধে আগ্রহী হয়ে থাকেন, তবে বিস্তারিত তথ্যের জন্য আমাদের [http://usability.wikimedia.org ইউজাবিলিটি উইকি] পরিদর্শন করুন।',
	'prefswitch-main-anon' => '===আমাকে ফিরিয়ে নাও===
আপনি যদি নতুন বৈশিষ্ট্যাবলী বন্ধ করতে চান তাহলে, [$1 এখানে ক্লিক করুন]। এ কাজের প্রথমেই আপনাকে লগ-ইন বা নতুন অ্যাকাউন্ট তৈরি করতে বলা হবে।',
	'prefswitch-main-on' => '===আমাকে ফেরত নাও!===
[$2 নতুন বৈশিষ্ট্যাবলী বন্ধ করতে এখানে ক্লিক করুন]।',
	'prefswitch-main-off' => '===সেগুলো ব্যবহার করুন!===
আপনি যদি নতুন বৈশিষ্ট্যাবলী চালু করতে চান, অনুগ্রহ করে [$1 এখানে ক্লিক করুন]।',
	'prefswitch-survey-intro-feedback' => 'আমরা আপনার কাছ থেকে জানতে চাই।
"[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" ক্লিক করার আগে অনুগ্রহ করে নিচের ঐচ্ছিক জরিপ ফরমটি পূরণ করুন।',
	'prefswitch-survey-intro-off' => 'আমাদের নতুন বৈশিষ্ট্যগুলো চেষ্টা করে দেখার জন্য ধন্যবাদ।
এটির উন্নয়ের ক্ষেত্রে আমাদের সাহায্য করার জন্য "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" লিংকে ক্লিক করার পূর্বে আপনি নিচের এই ঐচ্ছিক জরিপ ফর্মটি পূরণ করতে পারেন।',
	'prefswitch-feedbackpage' => 'Project:ব্যবহারকারীর অভিজ্ঞতালব্ধ মতামত',
);

/** Bishnupria Manipuri (ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী)
 * @author Usingha
 */
$messages['bpy'] = array(
	'prefswitch' => 'ইউজাবিলিটি ইনিশিয়েটিভ পছনর সুইচ',
	'prefswitch-desc' => 'আতাকুরার পছন বাসানির হের দে',
	'prefswitch-link-anon' => 'নুৱা বৈশিষ্টহানি',
	'tooltip-pt-prefswitch-link-anon' => 'নুৱা বৈশিষ্ট্যার বারে হারপা',
	'prefswitch-link-on' => 'আগর অঙতাত আলকর',
	'tooltip-pt-prefswitch-link-on' => 'নুৱা বৈশিষ্টহানি থা নাদি',
	'prefswitch-link-off' => 'নুৱা বৈশিষ্টহানি',
	'tooltip-pt-prefswitch-link-off' => 'নুৱা বৈশিষ্ট্যহানি চা',
	'prefswitch-jswarning' => 'মনে থইস স্কিনহান সিলকরানির লগে লগে, কাম যানার কা তর [[User:$1/$2.js|মনোবুক জাভাস্ক্রিপ্টরে]] কপি কর [[{{ns:user}}:$1/vector.js]]-এহান <!-- নাইলে [[{{ns:user}}:$1/common.js]]--> নেনা থক।',
	'prefswitch-csswarning' => 'তর [[User:$1/$2.css|সিলকরিসত $2 স্টাইল]] আরতা প্রযোজ্য নাইব। তি ভেক্টর স্কিনর সিলপার সিএসএস-র কা [[{{ns:user}}:$1/vector.css]] হঙকরানি পারর।',
	'prefswitch-survey-true' => 'হায়',
	'prefswitch-survey-false' => 'না',
	'prefswitch-survey-submit-off' => 'নুৱা বৈশিষ্ট্য থা নাদি',
	'prefswitch-survey-cancel-off' => 'নুৱা বৈশিষ্টহানি ব্যবহার করানি মনেইলে $1-হাত আলথকে যানা পাররাই।',
	'prefswitch-survey-submit-feedback' => 'প্রতিক্রিয়া দিয়াপেঠা',
	'prefswitch-survey-cancel-feedback' => 'প্রতিক্রিয়া দিয়াপেঠানি না মনেইলে $1 -হাত আলথকে যানা পাররাই।',
	'prefswitch-survey-question-like' => 'নুৱা বৈশিষ্ট্যহানির মা তি কিহান পছন করিসিলেতা?',
	'prefswitch-survey-question-dislike' => 'নুৱা বৈশিষ্ট্যহানির মা তি কিহান পছন না করিসিলেতা?',
	'prefswitch-survey-question-whyoff' => 'তি কিয়া নুৱা বৈশিষ্টহানি ঝিপিলেতা?
যেতা থক অতা বাস।',
	'prefswitch-survey-answer-whyoff-hard' => 'এতাল কাম করানি চিলুইসে।',
	'prefswitch-survey-answer-whyoff-didntwork' => 'এতা হবা করে কাম নাকরের।',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'এতা মি চাসিলু অসারে কাম না করের।',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'এহানর অঙতাহান মর পছন নাইল।',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'নুৱা ট্যাব বারো অঙতা মর পছন নাইল।',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'নুৱা টুলবারগ মর পছন নাইল।',
	'prefswitch-survey-answer-whyoff-other' => 'আর আর কারন:',
	'prefswitch-survey-question-browser' => 'তুমি কিসাদে ব্রাউজার ব্যবহার কররাইগ?',
	'prefswitch-survey-answer-browser-other' => 'আরাক ব্রাউজার আগ:',
	'prefswitch-survey-question-os' => 'তুমি কিসাদে অপারেটিং সিস্টেম ব্যবহার কররাইগ?',
	'prefswitch-survey-answer-os-other' => 'আরাক অপারেটিং সিস্টেম আহান:',
	'prefswitch-survey-question-res' => 'তুমার পর্দাহানর রেজ্যুলেশন কতি?',
	'prefswitch-title-on' => 'নুৱা বৈশিষ্টহানি',
	'prefswitch-title-switched-on' => 'কালাকপেলই!',
	'prefswitch-title-off' => 'নুৱা বৈশিষ্ট্যহানি ঝিপা',
	'prefswitch-title-switched-off' => 'থাকাত',
	'prefswitch-title-feedback' => 'প্রতিক্রিয়া',
	'prefswitch-success-on' => 'নুৱা বৈশিষ্ট্যহানি চালু ইল। আমি নিঙকররাঙ নুৱা বৈশিষ্ট্যহানি তুমারে পেলকরতই। তি যেপাগাউ পাতার গজর "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" লিংকহানাত ক্লিক করিয়া আগর অঙতাত আলুয়া যানা পাররাই।',
	'prefswitch-success-off' => 'নুৱা বৈশিষ্ট্যহানি ঝিপানি ইল। নুৱা বৈশিষ্ট্যহানি চা দেনার সারুকে থাকাত। তুমি যেপাগাউ পাতার গজর "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" লিংকহানাত ক্লিক করিয়া আগর অঙতাত আলুয়া যানা পাররাই।',
	'prefswitch-success-feedback' => 'তুমার প্রতিক্রিয়াহান দিয়াপেঠানি ইল।',
	'prefswitch-return' => '<hr style="clear:both">
আলথকে যাগা <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| উইকিপিডিয়ার নুৱা নেভিগেশন ইন্টারফেসের স্ক্রিনশটহান <small>[[Media:VectorNavigation-en.png|(ডাঙর কর)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| মূল পতানি ইন্টারফেসর স্ক্রিনশটহান <small>[[Media:VectorEditorBasic-en.png|(ডাঙর কর)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| লিংকর মা হমানির কা নুৱা ডায়ালগ বাক্স সিজিলর স্ক্রিনশটহান
|}
|}
উইকিমিডিয়া ফাউন্ডেশনর ইউজার এক্সপেরিয়েন্স টিম শিংলুপেত্ত আহিসে আতাকুরার লগে আকপাকে তুমার কা কামহান আরাকউ সুজা করানির কাম চলের। আমি হারৌহান্ন আমার উন্নয়নর অঙতা কতহান তুমার লগে ভাগা-ভাগি কররাঙ, অতার মা আসে উইকিমিডিয়া প্রকল্পর নুৱা অঙতা, সিদা বারো সমৃদ্ধ পতানির প্যানেল। এরে নুৱা অঙতা নুৱা অবদানকারীর কা অকরানির কা আরাকউ সিদা ভূমিকা থইতই, বারো [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study গেলগা বসরহান লয়া নানান পরীক্ষা-নিরীক্ষা]ল এরে অঙতাত আহিল। আমার প্রকল্পহানির ব্যবহারর মিমাঙে উন্নয়ন সাধন উইকিমিডিয়া ফাউন্ডেশন অগ্রাধিকার বুলিয়া বিবেচনা করের বারো আমিয়ৌ ভবিষ্যতে আরাকউ হালনাগাদ তুমার লগে ভাগাভাগি করতাঙাই। এহানর বারে আরকৌ হারপানির কা উইকিমিডিয়ার [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia ব্লগ পোস্ট চেইক]।

=== যেতা সিলুইল ===
* '''নেভিগেশন:''' আমি পাতাহানর হাজানিহান বারো পতানির অঙতাহান উন্নয়ন করলাঙ। পাতাহানর গজর ট্যাবগি ইজ্জু করে হারপানিত পাঙকরতই যে তি মূল না য়্যারীর পাতাত আসত, অতা বুলতে তি পাতাহান পাকররহান না পতারহান অহান বাগেইতই।
* '''পতানির প্যানেলর উন্নয়ন:''' আমি পতানির প্যানেলহানরে তর কা আরাকউ ইজ্জু করে হাকরলাঙ। এপাগা পাতাহানর পতানিহান আগেত্ত আরাকউ নুঙি ইল।
* '''লিংক উইজার্ড:''' ইজ্জু পদ্ধতি আহানল উইকির পাতা আহাত, লগে বারেদের ওয়েবসাইটর পাতার তুল লিংক তিলকরানি পারতেই।
* '''বিসারানির অঙতার উন্নয়ন:''' তুমি বিসারারাই পাতা অহান তরা করে পানা বারো অহানর পরামর্শের অঙতাত উন্নয়ন করানি অইল।
* '''আর আর নুৱা সুবিধাহানি:''' আমি টেবিল উইজার্ড বুলিয়া সুবিধা আহান বরিলাঙ। এহান্ন তুমি নুঙি করে পাতা আহানাত টেবিল বরানি পারতারাই। অতা বুলতেউ ইকা বিসারানি বারো সিলকরানির সুবিধা তিলকরলাঙ, যেহানে পাতা পতানি অহান নুঙা করে দিতই।
* '''উইকিপিডিয়ার লোগোগ:''' আমি আমার লোগোগ খানি আহান পতিলাঙ। [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d উইকিমিডিয়া ব্লগ]হানাত আরাকৌ হবাকরে পাকরিক।",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} ট্যাবহান''' এপাগা তারার থাপাক নাপকরিসে।
* '''{{int:move}} ট্যাবহান''' এপাগা বিসারিনর বাক্সগর কাদাহার ড্রপডাউন মাতাঙে আসে।",
	'prefswitch-main-feedback' => '===ফিডব্যাক?===
আমি তুমারাঙত হুনানির খৌরাঙ থরাঙ। তুমি আমার [[$1|ফিডব্যাক পাতা]]ত চেই, বারো তুমি যদি সফটওয়্যারর উন্নয়নর কা আমার চলের হন্নার বারে খৌরাঙ করিয়া থাইলে, মুল ফাতকরিয়া হারপানির কা [http://usability.wikimedia.org ইউজাবিলিটি উইকি]ত বুলন আহান দিক।',
	'prefswitch-main-anon' => '===মরে আলথকে নেগা===
নুৱা বৈশিষ্ট্যাহানি ঝিপানি মনেইলে, [$1 এহাত ক্লিক করিক]। কাম এহানর কা পয়লাকাই লগ-ইন নাইলে নুৱা অ্যাকাউন্ট খুলানি মাতানি অইতই।',
	'prefswitch-main-on' => '===মরে আলথকে নেইগা!===
[$2 নুৱা বৈশিষ্ট্যাহানি ঝিপানির কা এহাত ক্লিক করিক]।',
	'prefswitch-main-off' => '===অতা ব্যবহার করিক!===
নুৱা বৈশিষ্ট্যাহানি চালু করানি মনেইলে, [$1 এহাত ক্লিক করিক]।',
	'prefswitch-survey-intro-feedback' => 'আপনা আসিরাঙত হারপানি মনারাঙ।
"[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" ক্লিক করানির আগে তলর ঐচ্ছিক জরিপ ফরমহান পূরণ করিক।',
	'prefswitch-survey-intro-off' => 'নুৱা বৈশিষ্ট্যহানি চা দেনার সারুকে থাকাত।
এহানর উন্নয়নর কা আমারে পাঙলাক করানির কা "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" লিংকহানাত ক্লিক করানির আগে তলর ঐচ্ছিক জরিপ ফর্মহান পূরণ করানি পাররাঙ।',
	'prefswitch-feedbackpage' => 'Project:আতাকুরার অভিজ্ঞতাল পাসি মতামত',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'prefswitch' => 'Cheñch dibaboù an intrudu implijadusted',
	'prefswitch-desc' => "Talvezout a ra d'an implijerien da cheñch an holl benndibaboù",
	'prefswitch-link-anon' => 'Perzhioù nevez',
	'tooltip-pt-prefswitch-link-anon' => "Gouzout hiroc'h diwar-benn ar perzhioù nevez",
	'prefswitch-link-on' => 'Distreiñ',
	'tooltip-pt-prefswitch-link-on' => 'Diweredekaat ar perzhioù nevez',
	'prefswitch-link-off' => 'Perzhioù nevez',
	'tooltip-pt-prefswitch-link-off' => 'Esaeañ ar perzhioù nevez',
	'prefswitch-jswarning' => "Dalc'hit soñj e rank ho [[User:$1/$2.js|$2 JavaScript]] bezañ eilet war-du [[{{ns:user}}:$1/vector.js]] <!-- pe [[{{ns:user}}:$1/common.js]]--> evit gellout kenderc'hel da vont en-dro, abalamour d'ar cheñchamant gwiskadur.",
	'prefswitch-csswarning' => "Ne dalvezo ket ho [[User:$1/$2.css|stil personelaet $2]] ken. Termeniñ ur CSS personelaet evit vector a c'hallit e [[{{ns:user}}:$1/vector.css]].",
	'prefswitch-survey-true' => 'Ya',
	'prefswitch-survey-false' => 'Ket',
	'prefswitch-survey-submit-off' => 'Implijout ar perzhioù nevez',
	'prefswitch-survey-cancel-off' => "Mar fell deoc'h kenderc'hel d'ober gant ar perzhioù nevez e c'hallit distreiñ da $1.",
	'prefswitch-survey-submit-feedback' => 'Roit ho soñj',
	'prefswitch-survey-cancel-feedback' => "Mar ne fell ket deoc'h reiñ ho soñj e c'hallit distreiñ da $1.",
	'prefswitch-survey-question-like' => "Petra en deus plijet deoc'h en arc'hweladurioù nevez ?",
	'prefswitch-survey-question-dislike' => "Petra n'en deus ket plijet deoc'h en arc'hweladurioù nevez ?",
	'prefswitch-survey-question-whyoff' => 'Perak goulenn paouez gant ar perzhioù nevez ?
Dibabit kement tra hag a zegouezh.',
	'prefswitch-survey-question-globaloff' => "Ha c'hoant ho peus diweredekaat an arc'hweladurioù hollek-mañ ?",
	'prefswitch-survey-answer-whyoff-hard' => 'Start e oa da embreger.',
	'prefswitch-survey-answer-whyoff-didntwork' => "Ne'z ae ket plaen en-dro.",
	'prefswitch-survey-answer-whyoff-notpredictable' => "Ne'z ae ket en-dro en un doare poellek.",
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Ne blije ket din an tres anezhañ.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "N'on ket bet plijet gant an ivinelloù nevez hag an aozadur nevez.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ne blije ket din ar varrenn ostilhoù nevez.',
	'prefswitch-survey-answer-whyoff-other' => 'Abeg all :',
	'prefswitch-survey-question-browser' => 'Peseurt merdeer a rit gantañ ?',
	'prefswitch-survey-answer-browser-other' => 'Merdeer all :',
	'prefswitch-survey-question-os' => 'Peseurt reizhiad korvoiñ a rit gantañ ?',
	'prefswitch-survey-answer-os-other' => 'Reizhiad korvoiñ all :',
	'prefswitch-survey-answer-globaloff-yes' => 'Ya, diweredekaat anezho evit an holl wiki',
	'prefswitch-survey-question-res' => 'Petra eo spisder ho skramm ?',
	'prefswitch-title-on' => "Arc'hweladurioù nevez",
	'prefswitch-title-switched-on' => "Plijadur deoc'h !",
	'prefswitch-title-off' => 'Paouez gant ar perzhioù nevez',
	'prefswitch-title-switched-off' => 'Trugarez',
	'prefswitch-title-feedback' => 'Sonjoù',
	'prefswitch-success-on' => "War enaou emañ ar perzhioù nevez bremañ. Emichañs e plijint deoc'h. Mar fell deoc'h e c'hallit tennañ anezho en ur glikañ war al liamm \"[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]\" e laez ar bajenn.",
	'prefswitch-success-off' => 'Paouezet ez eus bet d\'ober gant ar perzhioù nevez. Ho trugarekaat evit bezañ amprouet anezho. Gallout a rit adenaouiñ anezho pa fell deoc\'h en ur glikañ war al liamm "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" e laez ar bajenn.',
	'prefswitch-success-feedback' => "Kaset eo bet hoc'h evezhiadennoù.",
	'prefswitch-return' => '<hr style="clear:both">
Distreiñ da <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Un dapadenn skramm tennet eus etrefas merdeiñ nevez Wikipedia <small>[[Media:VectorNavigation-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Ur skeudennskramm tennet eus an etrefas aozañ eeun <small>[[Media:VectorEditorBasic-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Un skeudenn skramm tennet eus etrefas ar prenestr skridaozañ nevez evit ouzhpennañ liammoù
|}
|}
The Wikimedia Foundation's User Experience Team has been working with volunteers from the community to make things easier for you. We are excited to share some improvements, including a new look and feel and simplified editing features. These changes are intended to make it easier for new contributors to get started, and are based on our [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study usability testing conducted over the last year]. Improving the usability of our projects is a priority of the Wikimedia Foundation and we will be sharing more updates in the future. For more details, visit the related Wikimedia [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog post].
Bet eo skipailh implijerien arroutet Diazezadur Wikimedia o labourat gant tud a youl-vat er gumuniezh evit aesaat an traoù deoc'h. Stad zo ennomp bremañ o kinnig deoc'h tammoù gwellaennoù, en o zouez un tres nevez ha doareoù kemmañ pajennoù eeunaet. Degaset eo bet ar c'hemmoù-se evit aesaat buhez an implijerien nevez. Diazezet int war [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study Ur studiadenn implijadusted kaset da benn warlene]. Aesaat implijadusted hor raktresoù zo ur priorite evit Diazezadur Wikimedia ha kenderc'hel a raimp da ginnig traoù nevez en amzer da zont. Evit muioc'h a ditouroù, kit da weladenniñ kemennadenn [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ blog Wikimedia].
===Setu ar pezh zo bet cheñchet===
* '''Merdeiñ :''' Gwellaet eo bet an doare merdeiñ evit lenn ha kemmañ pajennoù. Bremañ emañ kalz muioc'h war wel an ivinelloù e laez pep pajenn labour pe kaozeal, ha kemend-all pa vezit oc'h aozañ ur pennad pe o lenn anezhañ.
* '''Gwellaennoù er varrenn ostilhoù :''' Adframmet eo bet ar varrenn ostilhoù, dezhi da vezañ aesoc'h da implijout. Bremañ eo aesoc'h maketenniñ pajennoù ha kavout an doare d'en ober.
* '''Skoazeller liammoù :''' Un ostilh aes d'ober gantañ a dalvez deoc'h da ouzhpennañ liammoù ouzh pajennoù wiki all hag ouzh lec'hiennoù diavaez.
* '''Gwellaennoù klask :''' Gwellaet  eo bet ar c'hinnigoù klask, da gavout fonnusoc'h ar bajenn emaoc'h o klask.
* '''Perzhioù nevez all :'''  Degaset hon eus ivez un ostilh da sevel taolennoù aesoc'h hag ur vodulenn erlec'hiañ evit aesaat ar c'hemmañ pajennoù.

* '''Logo Wikipedia :''' Freskaet eo bet hol logo. Lenn hiroc'h war ar [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog].",
	'prefswitch-main-logged-changes' => "*An '''ivinell {{int:watch}}''' a zo bremañ ur steredenn
*An '''ivinell {{int:move}}''' a zo bremañ er meuz disachañ e-kichen ar maezienn klask.",
	'prefswitch-main-feedback' => "===Evezhiadennoù?===
Plijet-bras e vefemp o klevet ho toare. Kit da welet hor [[$1|pajenn evezhiadennoù]] pe, ma'z oc'h dedennet da vat gant hor strivoù dalc'hus evit gwellaat ar meziant, sellit ouzh hor [http://usability.wikimedia.org wiki implijadusted] da c'houzout hiroc'h.",
	'prefswitch-main-anon' => "===Distreiñ===
Mar fell deoc'h diweredekaat ar perzhioù nevez [$1 klikit amañ]. Ret e vo deoc'h kevreañ pe krouiñ ur gont da gentañ.",
	'prefswitch-main-on' => "===Trawalc'h gant ar jeu-se !===
[$2 Klikit amañ evit diweredekaat an arc'hweladurioù nevez].",
	'prefswitch-main-off' => "===Un taol-esae !===
MAr fell deoc'h ober gant ar barregezhioù nevez, [$1 klikit amañ].",
	'prefswitch-survey-intro-feedback' => "Plijet-bras e vefemp o kaout keloù diganeoc'h.
Mar fell deoc'h e c'hallit respont d'an tamm sontadeg a-is a-raok klikañ war [[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]",
	'prefswitch-survey-intro-off' => "Ho trugarekaat da vezañ amprouet ar perzhioù nevez.
Mard eo mat deoc'h e c'hallit hor skoazellañ en ur respont d'an tamm sontadeg a-is, a-raok klikañ war \"[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]\".",
	'prefswitch-feedbackpage' => 'Project: Soñjoù diwar-benn an implijadusted',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'prefswitch' => 'Prekidač postavki za Inicijativu upotrebljivosti',
	'prefswitch-desc' => 'Omogućava korisnicima prebacivanje seta postavki',
	'prefswitch-link-anon' => 'Nove mogućnosti',
	'tooltip-pt-prefswitch-link-anon' => 'Naučite više o novim mogućnostima',
	'prefswitch-link-on' => 'Vrati me nazad',
	'tooltip-pt-prefswitch-link-on' => 'Onemogući nove mogućnosti',
	'prefswitch-link-off' => 'Nove mogućnosti',
	'tooltip-pt-prefswitch-link-off' => 'Isprobajte nove mogućnosti',
	'prefswitch-jswarning' => 'Zapamtite da pri promjeni kože, vašu [[User:$1/$2.js|$2 JavaScriptu]] će biti neophodno kopirati u [[{{ns:user}}:$1/vector.js]] <!-- ili [[{{ns:user}}:$1/common.js]]--> za nastavak rada.',
	'prefswitch-csswarning' => 'Vaši [[User:$1/$2.css|prilagođeni $2 stilovi]] neće više moći biti upotrebljeni. Možete dodati prilagođeni CSS za vektor u [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Da',
	'prefswitch-survey-false' => 'Ne',
	'prefswitch-survey-submit-off' => 'Ugasite nove mogućnosti',
	'prefswitch-survey-cancel-off' => 'Ako biste željeli nastaviti koristiti nove mogućnosti, možete se vratiti na $1.',
	'prefswitch-survey-submit-feedback' => 'Pošaljite povratne informacije',
	'prefswitch-survey-cancel-feedback' => 'Ako ne želite poslati povratne informacije, možete se vratiti na $1.',
	'prefswitch-survey-question-like' => 'Šta vam se sviđa u vezi novih mogućnosti?',
	'prefswitch-survey-question-dislike' => 'Šta vam se ne sviđa u vezi novih mogućnosti?',
	'prefswitch-survey-question-whyoff' => 'Zašto isključujete nove mogućnosti?
Molimo odaberite sve što se može primijeniti.',
	'prefswitch-survey-question-globaloff' => 'Želite li da mogućnosti ugasite na svim projektima?',
	'prefswitch-survey-answer-whyoff-hard' => 'Veoma je teško koristiti nove mogućnosti.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Mogućnosti nisu dobro funkcionirale.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Mogućnosti nisu radile kako je predviđeno.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Ne sviđa mi se način kako ovo izgleda.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Ne sviđaju mi se novi jezičci i dizajn.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ne sviđa mi se nova alatna traka.',
	'prefswitch-survey-answer-whyoff-other' => 'Ostali razlozi:',
	'prefswitch-survey-question-browser' => 'Koji preglednik koristite?',
	'prefswitch-survey-answer-browser-other' => 'Ostali preglednici:',
	'prefswitch-survey-question-os' => 'Koji operativni sistem koristite?',
	'prefswitch-survey-answer-os-other' => 'Drugi operativni sistemi:',
	'prefswitch-survey-answer-globaloff-yes' => 'Da, ugasi mogućnosti na svim wikijima',
	'prefswitch-survey-question-res' => 'Koja je rezolucija Vašeg monitora?',
	'prefswitch-title-on' => 'Nove mogućnosti',
	'prefswitch-title-switched-on' => 'Uživajte!',
	'prefswitch-title-off' => 'Ugasite nove mogućnosti',
	'prefswitch-title-switched-off' => 'Hvala',
	'prefswitch-title-feedback' => 'Povratne informacije',
	'prefswitch-success-on' => 'Nove mogućnosti su sada omogućene. Nadamo se da ćete uživati koristeći nove mogućnosti. Uvijek ih možete ponovo ugasiti ako kliknete na link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" na vrhu stranice.',
	'prefswitch-success-off' => 'Nove mogućnosti su sada ugašene. Hvala što se probali nove mogućnosti. Uvijek ih možete ponovo omogućiti ako kliknete na link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" na vrhu stranice.',
	'prefswitch-success-feedback' => 'Vaš povratni odgovor je poslan.',
	'prefswitch-return' => '<hr style="clear:both">
Nazad na <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Datoteka:VectorNavigation-en.png|401px|]]
|-
| Snimak Wikipedijinog novog navigacionog interfejsa <small>[[Media:VectorNavigation-en.png|(povećaj)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Datoteka:VectorEditorBasic-en.png|401px|]]
|-
| Snimak osnovne stranice uređivačkog interfejsa <small>[[Media:VectorEditorBasic-en.png|(povećaj)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Datoteka:VectorLinkDialog-en.png|401px|]]
|-
| Snika novog dijaloškog okvira za unos linkova
|}
|}
Wikimedia Foundation User Experience Team (Tim za korisnička iskustva Wikimedia Fondacije) je radio sa dobrovoljcima iz zajednice da bi za vas načinio stvari lakše. Uzbuđeni smo što možemo s vama podijeliti neka poboljšanja, uključujući novi izgled i osjećaj i jednostavnije uređivačke osobine. Ove izmjene su u svrhu pojednostavljenja za nove korisnike koji započinju rad i zasnovane su na našim [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study probama korištenja koje smo proveli prošlih godina]. Poboljšavanje korisnost naših projekata je prioritet za Wikimedia Foundation i podijelićemo i više novih ažuriranja u budućnosti. Za više detalja posjetite vezane Wikimedia [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog poruke].

=== Ono što smo promijenili ===
* '''Navigacija:''' Poboljšali smo navigaciju za čitanje i uređivanje stranica. Sada, jezičci na vrhu svake stranice jasnije definiraju da li gledate stranicu ili razgovor o stranici, ili da li čitate ili uređujete stranicu.
* '''Poboljšanja trake za uređivanje:''' Reorganizirali smo traku za uređivanje da bi mogla lahko koristiti. Sada, formatiranje stranica je jednostavnije i više intuitivno.
* '''Čarobnjak za linkove:''' Alata koji je jednostavan za upotrebu kojim možete dodavati linkove na druge wiki stranice kao i linkove na vanjske stranice.
* '''Poboljšanja pretrage:''' Poboljšali smo prijedloge za pretragu gdje lahko i brzo možete naći stranicu koju tražite.
* '''Druge nove mogućnosti:''' Također smo uveli čarobnjaka za tabele za lahko pravljenje tabela i mogućnost traženja i zamjene za pojednostavljenje uređivanja stranice.
* '''Wikipedia logo:''' Ažurirali smo naš logo. Pročitajte više na [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blogu].",
	'prefswitch-main-logged-changes' => "* '''Jezičak {{int:watch}}''' je sad zvijezda.
* '''Jezičak {{int:move}}''' je sad u padajućem meniju pored trake za pretragu.",
	'prefswitch-main-feedback' => '===Povratne informacije?===
Željeli bismo čuti šta mislite. Molimo posjetite našu [[$1|stranicu za korisnička mišljenja]] ili, ako ste zainteresirani za naše stalne napore za poboljšanje softvera, posjetite našu [http://usability.wikimedia.org wiki upotrebljivosti] za više podataka.',
	'prefswitch-main-anon' => '===Vrati me nazad===
[$1 Kliknite ovdje da ugasite nove mogućnosti]. Tražit će se od vas da se prijavite ili napravite račun.',
	'prefswitch-main-on' => '===Vrati me nazad!===
[$2 Kliknite ovdje da ugasite nove mogućnosti].',
	'prefswitch-main-off' => '===Isprobajte ih!===
[$1 Kliknite ovdje da omogućite nove mogućnosti].',
	'prefswitch-survey-intro-feedback' => 'Bilo bi nam drago da nam se javite.
Molimo ispunite anketu ispod, koja nije obavezna, prije nego kliknete "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Hvala što isprobavate naše nove mogućnosti.
Da biste nam pomogli da ih poboljšamo, molimo ispunite neobaveznu anketu ispod prije nego kliknete "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Mišljenja korisnika o izgledu',
);

/** Catalan (Català)
 * @author Martorell
 * @author Paucabot
 * @author SMP
 * @author Vriullop
 */
$messages['ca'] = array(
	'prefswitch' => "Commutador de preferències de la Iniciativa d'Usabilitat",
	'prefswitch-desc' => 'Permet als usuaris canviar conjunts de preferències',
	'prefswitch-link-anon' => 'Noves característiques',
	'tooltip-pt-prefswitch-link-anon' => 'Més informació sobre les noves característiques',
	'prefswitch-link-on' => 'Torna-ho enrere',
	'tooltip-pt-prefswitch-link-on' => 'Desactiva les noves característiques',
	'prefswitch-link-off' => 'Noves característiques',
	'tooltip-pt-prefswitch-link-off' => 'Proveu les noves funcions',
	'prefswitch-jswarning' => "Recordeu que amb el canvi d'aparença haureu de copiar el vostre JavaScript de [[User:$1/$2.js|$2]] a [[{{ns:user}}:$1/vector.js]] <!-- o [[{{ns:user}}:$1/common.js]]--> per a que continuï funcionant.",
	'prefswitch-csswarning' => "El vostre [[User:$1/$2.css|estil personalitzat $2]] ja no s'aplicarà. Podeu afegir CSS personalitzats per a vector a [[{{ns:user}}:$1/vector.css]].",
	'prefswitch-survey-true' => 'Sí',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Deshabilita les noves característiques',
	'prefswitch-survey-cancel-off' => 'Si voleu continuar utilitzant les noves característiques podeu tornar a $1.',
	'prefswitch-survey-submit-feedback' => 'Donau la vostra opinió',
	'prefswitch-survey-cancel-feedback' => 'Si no voleu fer cap comentari podeu tornar a $1.',
	'prefswitch-survey-question-like' => 'Què us ha agradat de les noves funcionalitats?',
	'prefswitch-survey-question-dislike' => 'Què és el que no us ha agradat de les funcionalitats?',
	'prefswitch-survey-question-whyoff' => 'Per què desactiveu les noves funcionalitats?
Si us plau, seleccioneu tot el que correspongui',
	'prefswitch-survey-question-globaloff' => 'Voleu desactivar les característiques de manera global?',
	'prefswitch-survey-answer-whyoff-hard' => "Ha estat massa difícil d'usar.",
	'prefswitch-survey-answer-whyoff-didntwork' => 'No funcionava correctament.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'No funcionava de manera predictible.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "No m'ha agradat el seu aspecte.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "No m'han agradat les noves pestanyes ni el nou format.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => "No m'ha agradat la nova barra d'eines.",
	'prefswitch-survey-answer-whyoff-other' => 'Una altra raó:',
	'prefswitch-survey-question-browser' => 'Quin navegador emprau?',
	'prefswitch-survey-answer-browser-other' => 'Un altre navegador:',
	'prefswitch-survey-question-os' => 'Quin sistema operatiu usau?',
	'prefswitch-survey-answer-os-other' => 'Un altre sistema operatiu:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sí, desactiva les característiques en tots els wikis',
	'prefswitch-survey-question-res' => 'Quina és la resolució de la vostra pantalla?',
	'prefswitch-title-on' => 'Noves característiques',
	'prefswitch-title-switched-on' => 'Gaudiu-ne!',
	'prefswitch-title-off' => 'Deshabilita les noves característiques',
	'prefswitch-title-switched-off' => 'Gràcies',
	'prefswitch-title-feedback' => 'Avaluació',
	'prefswitch-success-on' => "S'han habilitat noves característiques. Esperem que les aprecieu. Sempre podeu tornar enrere clicant a l'enllaç «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» de dalt de tot de la pàgina.",
	'prefswitch-success-off' => "S'han deshabilitat les noves característiques. Gràcies per provar-les. Podeu sempre tornar-les a habilitar clicant en l'enllaç «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]» de dalt de tot de la pàgina.",
	'prefswitch-success-feedback' => 'Els vostres comentaris han estat enviats.',
	'prefswitch-return' => '<hr style="clear:both">
Torna a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Mostra de la nova interfície de navegació de la Viquipèdia <small>[[Media:VectorNavigation-en.png|(amplia)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Mostra de la interfície d'edició bàsica de pàgines <small>[[Media:VectorEditorBasic-en.png|(amplia)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Mostra de la nova caixa de diàleg per introduir enllaços
|}
|}

L'equip d'experiència d'usuari (''User Experience Team'') de la Fundació Wikimedia ha estat treballant amb voluntaris de la comunitat per fer-vos les coses més senzilles. Estem ansiosos per compartir algunes millores, incloent-hi un nou aspecte i la simplificació de les funcions d'edició. Aquests canvis estan pensats per a que els nous col·laboradors ho tinguin més fàcil per començar i estan basats en les nostres [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study proves d'usabilitat fetes durant l'any anterior]. La millora de la usabilitat dels nostres projectes és una prioritat de la Fundació Wikimedia i compartirem més actualitzacions en el futur. Per a més informació vegeu el missatge publicat al [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ bloc de Wikimedia].

===Això és el que hem canviat===
* '''Navegació''': Hem millorat la navegació per la lectura i modificació de pàgines. Ara, les pestanyes de la part superior de cada pàgina defineixen més clarament si esteu veient la pàgina principal o la de discussió, i si esteu llegint o modificant una pàgina.
* '''Millores en la barra d'eines d'edició''': Hem reorganitzat la barra d'eines d'edició per a que sigui més fàcil d'utilitzar. Ara, donar format a les pàgines és més senzill i més intuïtiu.
* '''Assistent per a enllaços''': Una eina fàcil d'utilitzar us permet afegir enllaços a altres pàgines wiki, així com enllaços a llocs externs.
* '''Millores en la cerca''': Hem millorat els suggeriments de cerca per trobar més ràpidament la pàgina que esteu cercant.
* '''Altres característiques noves''': També hem introduït un assistent per fer més fàcil la creació de taules i una funció de cerca i reemplaça per simplificar la modificació de pàgines.
* '''Logotip de la Viquipèdia''': Hem actualitzat el nostre logotip. Vegeu més informació al [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ bloc de Wikimedia].",
	'prefswitch-main-logged-changes' => "* La '''pestanya {{int:watch}}''' és ara una estrella.
* La '''pestanya {{int:move}}''' és ara al menú desplegable al costat de la caixa de cerca.",
	'prefswitch-main-feedback' => "===Teniu comentaris a fer?===
Ens agradaria saber-los. Podeu visitar la nostra [[$1|pàgina de comentaris]] o, si esteu interessats en les tasques en marxa per millorar el programari, visiteu el nostre [http://usability.wikimedia.org wiki d'usabilitat] per a més informació.",
	'prefswitch-main-anon' => '===Tornar enrere===
Si desitgeu desactivar les noves característiques [$1 cliqueu aquí]. Se us demanarà abans que us registreu o creeu un compte.',
	'prefswitch-main-on' => '===Tornar enrere!===
[$2 Cliqueu aquí per desactivar les noves característiques].',
	'prefswitch-main-off' => '===Proveu-les!===
Si desitgeu activar les noves funcionalitats [$1 cliqueu aquí].',
	'prefswitch-survey-intro-feedback' => "Ens agradaria saber les vostres impressions.
Si us plau, ompliu el formulari opcional d'aquí sota abans de clicar «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]».",
	'prefswitch-survey-intro-off' => "Gràcies per provar les noves característiques.
Per ajudar-nos a millorar-les, si us plau ompliu el formulari opcional d'aquí sota abans de clicar «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».",
	'prefswitch-feedbackpage' => "Project:Comentaris sobre l'experiència d'usuari",
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'prefswitch-link-anon' => 'Керла таронаш',
	'prefswitch-link-on' => 'Хьалхсанна дlахlоттор',
	'tooltip-pt-prefswitch-link-on' => 'Дlайаха керла таронаш',
	'prefswitch-link-off' => 'Керла таронаш',
	'tooltip-pt-prefswitch-link-off' => 'Муха йу хьажа керла таронаш',
	'prefswitch-survey-submit-off' => 'Дlайаха керла таронаш',
	'prefswitch-title-on' => 'Керла таронаш',
	'prefswitch-title-off' => 'Дlайаха керла таронаш',
);

/** Sorani (کوردی)
 * @author Asoxor
 * @author Marmzok
 */
$messages['ckb'] = array(
	'prefswitch' => 'سویچی ھەڵبژاردەکانی پێشھەنگاویی تواناکان',
	'prefswitch-desc' => 'ڕێگەدان بە بەکارھێنەران بۆ گۆڕانی بەکۆمەڵی ھەڵبژاردەکان',
	'prefswitch-link-anon' => 'تایبەتمەندییە نوێکان',
	'tooltip-pt-prefswitch-link-anon' => 'فێربوون سەبارەت بە تایبەتمەندییە نوێکان',
	'prefswitch-link-on' => 'بمگەڕێنەوە',
	'tooltip-pt-prefswitch-link-on' => 'لەکارخستنی تایبەتمەندییە نوێکان',
	'prefswitch-link-off' => 'تایبەتمەندییە نوێکان',
	'tooltip-pt-prefswitch-link-off' => 'تاقیکردنەوەیەکی تایبەتمەندییە نوێکان',
	'prefswitch-jswarning' => 'لەیادت بێ، کاتێ بەرگت گۆڕی، پێویستە [[User:$1/$2.js|$2 جاڤاسکریپتەکات]] کۆپی بکرێ بۆ [[{{ns:user}}:$1/vector.js]] <!-- یا [[{{ns:user}}:$1/common.js]]--> بۆ ئەوەی درێژە بدات بە کارکردن.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|$2 دڵخوازەکەت]] چی دیکە بەکارناگیرێت. دەتوانی CSSی دڵخوازت زیادبکەیتە سەر ڤێکتۆر لە [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'بەڵێ',
	'prefswitch-survey-false' => 'نەخێر',
	'prefswitch-survey-submit-off' => 'لەکارخستنی تایبەتمەندییە نوێکان',
	'prefswitch-survey-cancel-off' => 'ئەگەر دەتەوێ لە بەکارھێنانی تایبەتمەندییە نوێکان بەردەوام ببیت، دەتوانی بگەڕێیەوە بۆ $1.',
	'prefswitch-survey-submit-feedback' => 'پێڕاگەیاندنەوە',
	'prefswitch-survey-cancel-feedback' => 'ئەگەر ناتەوێ پێڕاگەیاندنەوە سازبکەیت، دەتوانی بگەڕێیەوە بۆ $1.',
	'prefswitch-survey-question-like' => 'سەبارەت بە تایبەتمەندییە نوێکان چیت بەدڵ بوو؟',
	'prefswitch-survey-question-dislike' => 'سەبارەت بە تایبەتمەندییە نوێکان چیت بەدڵ نەبوو؟',
	'prefswitch-survey-question-whyoff' => 'بۆچی تایبەتمەندییە نوێکان لەکاردەخەی؟
تکایە ھەموو ئەوانەی دەگونجێ دایانبنێ.',
	'prefswitch-survey-question-globaloff' => 'ئایا دەتەوێ تایبەتمەندییەکان لە ھەموو پڕۆژەکاندا بەگشتی لەکار بخەیت؟',
	'prefswitch-survey-answer-whyoff-hard' => 'تایبەتمەندییەکان زۆر بۆ بەکارھێنان دژواربوون.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'تایبەتمەندییەکان بەباشی کاریان نەکرد.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'تایبەتمەندییەکان بە شێوەیەکی دیاریکراو کار ناکەن.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'ڕواڵەتی تایبەتمەندییەکان بەدڵم نەبوو.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'تاب و نەخشە نوێکانم بەدڵ نەبوو.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'شریتامرازە نوێکە بەدڵم نەبوو.',
	'prefswitch-survey-answer-whyoff-other' => 'ھۆکاری دیکە:',
	'prefswitch-survey-question-browser' => 'کام گەڕۆک بەکار دەهێنی؟',
	'prefswitch-survey-answer-browser-other' => 'گەڕۆکی دیکە:',
	'prefswitch-survey-question-os' => 'کام سیستەمی کارپێکردن بەکاردێنی؟',
	'prefswitch-survey-answer-os-other' => 'سیستەمنی بەکارھێنانی دیکە:',
	'prefswitch-survey-answer-globaloff-yes' => 'بەڵێ، تایبەتمەندییەکان لە ھەموو ویکییەکان لەکار بخە',
	'prefswitch-survey-question-res' => 'رەزۆلوشنی شاشەکەت چەندە؟',
	'prefswitch-title-on' => 'تایبەتمەندییە نوێکان',
	'prefswitch-title-switched-on' => 'فەرموو!',
	'prefswitch-title-off' => 'لەکارخستنی تایبەتمەندییە نوێکان',
	'prefswitch-title-switched-off' => 'سوپاس',
	'prefswitch-title-feedback' => 'پێڕاگەیاندنەوە',
	'prefswitch-success-on' => 'ئێستا تایبەتمەندییە نوێکان چالاککراون. ھیوادارین لە بەکارھێنانیان سوودوەربگرن. ھەرکاتێ ویستتان دەتوانن بە کرتەکردنە سەر بەستەری "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]"، لەلای سەرەوەی پەڕەکە، بگەڕێنەوە بۆ شێوەی پێشوو.',
	'prefswitch-success-off' => 'ئێستا تایبەتمەندییە نوێکان ناچالاککراون. سوپاستان دەکەین بۆ بەکارھێنانیان. ھەرکاتێ ویستتان دەتوانن بە کرتەکردنە سەر بەستەری "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]"، لەلای سەرەوەی پەڕەکە، بگەڕێنەوە بۆ شێوەی پێشوو.',
	'prefswitch-success-feedback' => 'پەیامەکەت ناردرا.',
	'prefswitch-return' => '<hr style="clear:both">
بگەڕێوە بۆ <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| وێنەیەک لە ڕووکاڕی ڕێدۆزیی نوێی ویکیپیدیا <small>[[Media:VectorNavigation-en.png|(گەورەتر)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| وێنەیەک لە ڕووکاری دەستکاریی سەرەتایی پەڕەکان <small>[[Media:VectorEditorBasic-en.png|(گەورەتر)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| وێنەیەک لە چوارچێوەی نوێی دانانی بەستەر
|}
|}
ستافی ئەزموونەکانی بەکارھێنەرانی ڕێکخراوی ویکیمیدیا لەگەڵ ژمارەیەک لە ئەندامانی خۆبەخشی کۆمەڵگای ویکی تێکۆشاون شتەکان بۆ ئێوە ساکارتر بکەنەوە. خۆشحاڵین بەوەی چەن چاکسازی وەک بەرچاوکەوتنی نوێ و ئاسانکاریی تایبەتمەندییەکانتان پێشکەش دەکەین. ئامانجی ئەم نوێکارییانە، ساکارترکردنەوەی بەشداریکردنی بەکارھێنەرە نوێکانە کە لەسەر بنەمای [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study دەستکەوتەکانی تاقیکردنەوەی بەکارھێنان لە ماوەی یەکساڵی ڕابردوودایە]. باشترکردن و پێشخستنی بەکارھێنانی پڕۆژەکانمان، پێشەنگییەکی رێکخراوی ویکیمیدیایە و ھەروەھا لەداھاتوودا نوێکاری دیکەتان پێشکەش دەکەین. بۆ زانیاریی زیاتر سەردانی [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia بلاگی ویکیمیدیا] بکەن.

=== فەرموون ئەمەش ئەوانەی گۆڕاومانە ===
* '''ڕێدۆزی:''' ھەوڵمان داوە بەشی ڕێدۆزی بۆ خوێندنەوە و دەستکاریکردنی پەڕەکان باشتربکەین. ئێستا، ئەو تابەی لەلای سەرەوەی ھەموو پەڕەیەک ھەیە، ڕوونتر لەبەردەستدایە بۆ دیتنی پەڕە و پەڕەی وتووێژ یان بۆ خوێندنەوە و دەستکاریکردنی.
* '''تووڵامرازی دەستکاریکردن:''' داڕشتنێکی نوێ تووڵامراز بەکارھێنراوە بۆ ئەوەی بەکارھێنان ساکارتر بێتەوە. ئێستا، ڕازاندنەوەی پەڕەکان زۆر ئاسانترە و لەبەردەستدایە.
* '''سێحری بەستەر:''' ئامرازێکی زۆر ساکار یارمەتیت دەدات تاکوو بتوانی بەستەر دابنەی بۆ وتارەکانی دیکە ھەروا بۆ ماڵپەڕەکانی دیکە(دەرەکی).
* '''بەشی گەڕان:''' پێشنیارەکانی بەشی گەڕان باشتر کراوە بۆ ئەوەی خێراتر بە ئامانجی گەڕانەکان بگەن.
* '''خشتە:''' ئامرازێکی نوێ با دانانی و دەستکاریکردنی خشتەکان پێشکەشکراوە.
* '''لۆگۆی ویکیپیدیا:''' لۆگۆکەمان نوێ کراوەتەوە. بۆ زانیاری زیاتر دەتوانن [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d بلاگی ویکیمیدیا] بخوێننەوە.",
	'prefswitch-main-logged-changes' => "* ئێستا '''تابی {{int:watch}}''' ئەستێرەیەکە.
* ئێستا '''تابی {{int:move}}''' بۆخوارەکراوەیەکە لەپاڵ شریتی گەڕان.",
	'prefswitch-main-feedback' => '===پێڕاگەیاندنەوە؟===
ئێمە پێمان خۆشە لێتان ببیستین. تکایە سەردانی [[$1|پەڕەی پێڕاگەیاندن]] بکەن، یا ئەگەر ئامانجەکانمان بۆ باشترکردنی نەرمامێر سەرنجتانی ڕاکێشاوە، بۆ زانیاری زیاتر سەردانی [http://usability.wikimedia.org تواناکانی ویکی] بکەن.',
	'prefswitch-main-anon' => '===بمگەڕێنەوە===
[$1 بۆ لەکارخستنی تایبەتمەندییەنوێکان کرتە بکەسەر ئێرە]. بۆ ئەوە داواتان لێدەکرێ بڕۆنە ژوورەوە یان لەپێشدا ھەژمارێک درووست بکەن.',
	'prefswitch-main-on' => '===بمگەڕێنەوە!===
[$2 بۆ لەکارخستنی تایبەتمەندییەنوێکان کرتە بکەسەر ئێرە].',
	'prefswitch-main-off' => '===تاقیکردنەوەیان!===
[$1 بۆ خستنەکاری تایبەتمەندییەنوێکان کرتە بکەسەر ئێرە].',
	'prefswitch-survey-intro-feedback' => 'پێمان خۆشە لە ئێوە ببیسین.<br />
تکایە پێش کرتە کردنە سەر "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]"، ئەو ھەڵسەنگاندنە دڵخوازانەی خوارەوە پڕکەنەوە.',
	'prefswitch-survey-intro-off' => 'سوپاس بۆ تاقیکردنەوەی تایبەتمەندییە نوێکانمان.
بۆ یارمەتیدانی باشترکردن، تکایە لەخوارەوە ھەڵسەنگاندنێکی دڵخواز بکە پێش ئەوەی کرتە بکەیتە سەر "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
);

/** Czech (Česky)
 * @author Kuvaly
 * @author Mormegil
 */
$messages['cs'] = array(
	'prefswitch' => 'Přepínač nastavení Iniciativy použitelnosti',
	'prefswitch-desc' => 'Umožňuje uživatelům přepínat sady nastavení',
	'prefswitch-link-anon' => 'Nové funkce',
	'tooltip-pt-prefswitch-link-anon' => 'Informace o nových funkcích',
	'prefswitch-link-on' => 'Chci zpátky',
	'tooltip-pt-prefswitch-link-on' => 'Vypnout nové funkce',
	'prefswitch-link-off' => 'Nové funkce',
	'tooltip-pt-prefswitch-link-off' => 'Vyzkoušejte nové funkce',
	'prefswitch-jswarning' => 'Nezapomeňte, že se změnou vzhledu musíte zkopírovat svůj [[User:$1/$2.js|JavaScript pro $2]] na [[{{ns:user}}:$1/vector.js]]<!-- nebo [[{{ns:user}}:$1/common.js]]-->, pokud má i nadále fungovat.',
	'prefswitch-csswarning' => 'Váš [[User:$1/$2.css|uživatelský styl pro $2]] se nadále nebude používat. Uživatelské CSS pro Vektor si můžete nastavit na [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ano',
	'prefswitch-survey-false' => 'Ne',
	'prefswitch-survey-submit-off' => 'Vypnout nové funkce',
	'prefswitch-survey-cancel-off' => 'Pokud chcete i nadále používat nové vlastnosti, můžete se vrátit na stránku $1.',
	'prefswitch-survey-submit-feedback' => 'Odeslat názor',
	'prefswitch-survey-cancel-feedback' => 'Pokud nám nechcete sdělit svůj názor, můžete se vrátit na $1.',
	'prefswitch-survey-question-like' => 'Co se vám z nových funkcí líbilo?',
	'prefswitch-survey-question-dislike' => 'Co se vám z nových funkcí nelíbilo?',
	'prefswitch-survey-question-whyoff' => 'Proč jste vypnuli nové funkce?
Vyberte všechny relevantní možnosti.',
	'prefswitch-survey-question-globaloff' => 'Chcete funkce vypnout globálně?',
	'prefswitch-survey-answer-whyoff-hard' => 'Byla příliš složitá na používání.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Nefungovala správně.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Nechovala se předvídatelně.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Nelíbil se mi její vzhled.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Nelíbily se mi nové záložky a rozvržení.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nelíbil se mi nový panel nástrojů.',
	'prefswitch-survey-answer-whyoff-other' => 'Jiný důvod:',
	'prefswitch-survey-question-browser' => 'Jaký prohlížeč používáte?',
	'prefswitch-survey-answer-browser-other' => 'Jiný prohlížeč:',
	'prefswitch-survey-question-os' => 'Jaký operační systém používáte?',
	'prefswitch-survey-answer-os-other' => 'Jiný operační systém:',
	'prefswitch-survey-answer-globaloff-yes' => 'Ano, vypnout funkce na všech wiki',
	'prefswitch-survey-question-res' => 'Jaké je rozlišení vaší obrazovky?',
	'prefswitch-title-on' => 'Nové funkce',
	'prefswitch-title-switched-on' => 'Užijte si to!',
	'prefswitch-title-off' => 'Vypnout nové funkce',
	'prefswitch-title-switched-off' => 'Děkujeme',
	'prefswitch-title-feedback' => 'Zpětná vazba',
	'prefswitch-success-on' => 'Nové funkce jsou nyní zapnuty. Doufáme, že se vám budou líbit. Kdykoli je můžete opět vypnout kliknutím na odkaz „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]“ navrchu stránky.',
	'prefswitch-success-off' => 'Nové funkce jsou nyní vypnuty. Děkujeme za vyzkoušení nových funkcí. Kdykoli je můžete opět zapnout kliknutím na odkaz „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]“ navrchu stránky.',
	'prefswitch-success-feedback' => 'Váš názor byla odeslán.',
	'prefswitch-return' => '<hr style="clear:both">
Zpět na <span class="plainlinks">[$1 $2].</span>',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-cs.png|401px|]]
|-
| Snímek obrazovky s novým navigačním rozhraním <small>[[Media:VectorNavigation-cs.png|(zvětšit)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-cs.png|401px|]]
|-
| Snímek obrazovky se základním editačním rozhraním <small>[[Media:VectorEditorBasic-cs.png|(zvětšit)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-cs.png|401px|]]
|-
| Snímek obrazovky s novým dialogem pro vkládání odkazů
|}
|}

Tým nadace Wikimedia pro uživatelskou přívětivost pracoval s dobrovolníky z komunity, aby vám zjednodušil práci. Jsme rádi, že se s vámi můžeme podělit o několik vylepšení včetně nového vzhledu a zjednodušené editace. Cílem těchto změn je zjednodušit začátky nováčkům a jsou založeny na našich [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study testech z minulého roku]. Vylepšování použitelnosti našich projektů je prioritou Wikimedia Foundation a i v budoucnu budeme nabízet další inovace. Podrobnosti můžete najít ve [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ zprávě na blogu Wikimedia].

=== Co jsme změnili ===
* '''Navigace:''' Máme lepší navigaci pro čtení a editaci stránek. Záložky v horní části každé stránky nyní zřetelněji zobrazují, zda si prohlížíte článek či diskusi a zda stránku čtete či editujete.
* '''Vylepšení panelu nástrojů:''' Přeorganizovali jsme editační panel nástrojů, aby se snadněji používal. Formátování stránek je teď jednodušší a intuitivnější.
* '''Průvodce odkazy:''' Jednoduše použitelný nástroj vám pomůže přidávat odkazy na jiné články wiki, jako i na externí stránky.
* '''Vylepšení vyhledávání:''' Zlepšili jsme našeptávač u vyhledávání, abyste se rychleji dostali na stránku, kterou hledáte.
* '''Další nové vlastnosti:''' Také jsme zavedli průvodce tabulkou, aby bylo vytváření tabulek snadnější, a také funkci vyhledávání a nahrazování pro jednodušší editaci stránek.
* '''Logo Wikipedie:''' Modernizovali jsme naše logo. Více se dozvíte na [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blogu Wikimedia].",
	'prefswitch-main-logged-changes' => "* Místo '''záložky {{int:watch}}''' je odteď hvězdička.
* '''Záložka {{int:move}}''' je nyní umístěna v rozbalovacím menu vedle vyhledávání.",
	'prefswitch-main-feedback' => '===Komentáře?===
Uvítáme vaše názory. Navštivte naši [[$1|stránku pro komentáře]] nebo, pokud vás zajímá naše dlouhodobé úsilí o vylepšování softwaru, můžete nalézt více informací na [http://usability.wikimedia.org wiki projektu použitelnosti].',
	'prefswitch-main-anon' => '===Chci zpátky===
Pokud chcete, můžete si [$1 vypnout nové funkce]. Nejdříve se budete muset přihlásit nebo zaregistrovat.',
	'prefswitch-main-on' => '=== Chci zpátky! ===
[$2 Klikněte sem, pokud chcete vypnout nové funkce].',
	'prefswitch-main-off' => '=== Vyzkoušejte ji! ===
Pokud si chcete vyzkoušet nové funkce, prosím [$1 klikněte zde].',
	'prefswitch-survey-intro-feedback' => 'Budeme rádi, když se dozvíme váš názor.
Vyplňte prosím dotazník níže a poté klikněte na „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]“.',
	'prefswitch-survey-intro-off' => 'Děkujeme za vyzkoušení našich nových funkcí.
Chcete-li nám pomoci zlepšit je, vyplňte nepovinný dotazník níže a poté klikněte na „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]“.',
	'prefswitch-feedbackpage' => 'Project:Iniciativa použitelnosti/Reakce',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'prefswitch-survey-true' => 'да',
	'prefswitch-survey-false' => 'нѣ́тъ',
	'prefswitch-survey-answer-browser-other' => 'ино съмотри́ло :',
	'prefswitch-title-switched-off' => 'благода́рьщвлѭ',
);

/** Chuvash (Чӑвашла)
 * @author FLAGELLVM DEI
 */
$messages['cv'] = array(
	'prefswitch-link-anon' => 'Çĕнĕ мехелсем',
	'prefswitch-link-on' => 'Кивĕ интерфейс',
	'prefswitch-link-off' => 'Çĕнĕ мехелсем',
	'prefswitch-title-on' => 'Çĕнĕ мехелсем',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 * @author Malafaya
 * @author Xxglennxx
 */
$messages['cy'] = array(
	'prefswitch' => 'Switsh y Dewisiadau ar y Cynllun Defnyddioldeb',
	'prefswitch-desc' => 'Yn gadael i ddefnyddwyr newid rhwng gwahanol setiau o ddewisiadau',
	'prefswitch-link-anon' => 'Nodweddion newydd',
	'tooltip-pt-prefswitch-link-anon' => 'Darllen am y nodweddion newydd',
	'prefswitch-link-on' => 'Ewch â fi yn ôl',
	'tooltip-pt-prefswitch-link-on' => "Analluogi'r nodweddion newydd",
	'prefswitch-link-off' => 'Nodweddion newydd',
	'tooltip-pt-prefswitch-link-off' => 'Rhoi cynnig ar y nodweddion newydd',
	'prefswitch-survey-true' => 'Ydw',
	'prefswitch-survey-false' => 'Na',
	'prefswitch-survey-submit-off' => 'Diffodd y nodweddion newydd',
	'prefswitch-survey-cancel-off' => "Os ydych am barhau i ddefnyddio'r nodweddion newydd, gallwch ddychwelyd at y dudalen $1.",
	'prefswitch-survey-submit-feedback' => 'Anfon adborth',
	'prefswitch-survey-cancel-feedback' => 'Os nad ydych am anfon adborth atom, gallwch ddychwelyd i $1.',
	'prefswitch-survey-question-whyoff' => "Pam ydych chi'n diffodd y nodweddion newydd?
Dewiswch yr holl resymau dros gwneud.",
	'prefswitch-survey-question-globaloff' => 'Ydych chi am ddiffodd y nodweddion hyn yn wici-eang?',
	'prefswitch-survey-answer-whyoff-hard' => "Roedd y nodweddion yn rhy anodd i'w defnyddio.",
	'prefswitch-survey-answer-whyoff-didntwork' => "Nid oedd y nodweddion yn gweithio'n iawn.",
	'prefswitch-survey-answer-whyoff-notpredictable' => "Roedd y nodweddion yn gweithredu'n fympwyol.",
	'prefswitch-survey-answer-whyoff-didntlike-look' => "Doeddwn i ddim yn hoffi'r golwg newydd.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "Doeddwn i ddim yn hoffi'r tabiau a'r gosodiad newydd.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => "Doeddwn i ddim yn hoffi'r bar offer newydd.",
	'prefswitch-survey-question-browser' => "Pa borwr gwe ydych chi'n ei ddefnyddio?",
	'prefswitch-survey-answer-browser-other' => 'Porwr arall:',
	'prefswitch-survey-question-os' => "Pa system weithredu ydych chi'n ei defnyddio?",
	'prefswitch-survey-answer-os-other' => 'System weithredu arall:',
	'prefswitch-survey-answer-globaloff-yes' => 'Ydw. Diffodder y nodweddion hyn ar bob wici.',
	'prefswitch-survey-question-res' => "Pa gydraniad sydd i'ch sgrin?",
	'prefswitch-title-on' => 'Nodweddion newydd',
	'prefswitch-title-switched-on' => 'Mwynhewch!',
	'prefswitch-title-off' => 'Diffodd y nodweddion newydd',
	'prefswitch-title-switched-off' => 'Diolch',
	'prefswitch-title-feedback' => 'Adborth',
	'prefswitch-success-on' => 'Mae\'r nodweddion newydd ar waith. Gobeithiwn y byddwch yn mwynhau eu defnyddio. Gallwch eu diffodd drwy glicio ar y cyswllt "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" ar frig tudalen.',
	'prefswitch-success-off' => 'Diffoddwyd y nodweddion newydd. Diolch am roi tro arnynt. Gallwch eu rhoi ar waith eto trwy glicio\'r cyswllt "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" ar frig tudalen.',
	'prefswitch-success-feedback' => 'Anfonwyd eich adborth.',
	'prefswitch-return' => '<hr style="clear:both">
Dychwelyd i <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Ciplun o ryngwyneb llywio newydd Wicipedia <small>[[Media:VectorNavigation-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Ciplun o'r bar offer golygu sylfaenol<small>[[Media:VectorEditorBasic-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Ciplun o'r blwch deialog newydd ar gyfer mewnosod cysylltau
|}
|}
Mae Tîm Sefydliad Wikimedia ar gyfer Profiadau Defnyddwyr wedi bod yn cydweithio gyda gwrifoddolwyr o'r gymuned i wneud pethau'n haws i chi. Rydym am rannu rhai gwelliannau gyda chi, gan gynnwys golwg newydd, naws gwahanol a nodweddion golygu symlach. Bwriad y newidiadau yw ei gwneud yn haws i gyfranwyr newydd fwrw ati. Maent wedi eu seilio ar y gwaith [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study arbrofi ar ddefnyddioldeb a gynhaliwyd yn ystod y flwyddyn a fu]. Mae gwella defnyddioldeb ein prosiectau yn flaenoriaeth i Sefydliad Wikimedia, a byddwn yn rhannu rhagor o ddiweddariadau eto. Am fwy o fanylion, ewch i [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ flog Wikimedia].

=== Dyma'r hyn sydd wedi newid ===
*'''Llywio''': Rydym wedi gwella'r llywio ar gyfer darllen tudalennau a'u golygu. Yn awr, mae'n haws gweld o'r tabiau ar frig tudalen p'un ai'r dudalen neu ei thudalen drafod sydd o'ch blaen, a ph'un ai ydych yn darllen neu yn golygu.
*'''Gwelliannau i'r bar offer golygu''': Rydym wedi ad-drefnu'r bar offer golygu i'w wneud yn haws i'w ddefnyddio. Nawr, mae fformatio tudalennau yn symlach ac yn haws ei ddeall.
*'''Dewin cysylltu''': Teclyn hawdd i'w ddefnyddio yn eich galluogi i ychwanegu cysylltau i dudalennau eraill ar y wici yn ogystal â chysylltau i safleoedd allanol.
*'''Gwelliannau wrth chwilio''': Rydym wedi gwella'r awgrymiadau chwilio i gael hyd i'r nod yn gyflymach.
*'''Nodweddion newydd eraill''': Rydym hefyd wedi gwneud dewin tablau i'w gwneud yn haws llunio tablau, ac wedi gwneud teclyn 'canfod a disodli' i'ch cynorthwyo wrth i chi olygu.
*'''Logo Wicipedia''': Rydym wedi diweddaru ein logo. Darllenwch fwy ar [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ flog Wikimedia].",
	'prefswitch-main-logged-changes' => "* Seren sydd yn cynrychioli'r '''tab {{int:watch}}''' yn awr.
* Mae'r '''tab {{int:move}}''' yn awr yn y gwymplen wrth ymyl y bar chwilio.",
	'prefswitch-main-feedback' => "===Adborth?===
Byddem wrth ein bodd yn cael clywed gennych. Ewch i'n [[$1|tudalen adborth]] neu, os oes gennych ddiddordeb yn ein hymdrechion parhaus i wella'r meddalwedd, ewch i'n [http://usability.wikimedia.org wici ar ddefnyddioldeb] am ragor o wybodaeth.",
	'prefswitch-main-anon' => '===Ewch Nôl a Fi===
Os ydych am ddiffodd y nodweddion newydd, [$1 cliciwch fan hyn]. Fe gewch gynnig mewngofnodi neu greu cyfrif yn gyntaf.',
	'prefswitch-main-on' => '===Ewch â fi yn ôl!===
[$2 Os hoffech ddiffodd y nodweddion newydd, cliciwch fan hyn].',
	'prefswitch-main-off' => '==Rhowch gynnig arni!==
Os yr hoffech roi cynnig ar y nodweddion newydd, pwyswch [$1 fan hyn].',
	'prefswitch-survey-intro-feedback' => 'Byddem yn falch o gael eich barn.
Os y dymunwch, llenwch yr arolwg dewisol isod ac yna pwyswch ar "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Diolch am roi cynnig ar ein nodweddion newydd.
I\'n helpu ni i\'w gwella, cwblhewch yr arolwg dewisol isod, yna pwyswch ar "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Adborth ar brofiadau defnyddwyr',
);

/** Danish (Dansk)
 * @author Froztbyte
 * @author Masz
 * @author Sir48
 */
$messages['da'] = array(
	'prefswitch' => 'Præferencevælger for brugervenlighedsinitiativet',
	'prefswitch-desc' => 'Tillad brugere at udskifte sæt af præferencer',
	'prefswitch-link-anon' => 'Nye funktioner',
	'tooltip-pt-prefswitch-link-anon' => 'Læs mere om nye funktioner',
	'prefswitch-link-on' => 'Tag mig tilbage',
	'tooltip-pt-prefswitch-link-on' => 'Deaktiver nye funktioner',
	'prefswitch-link-off' => 'Nye funktioner',
	'tooltip-pt-prefswitch-link-off' => 'Prøv nye funktioner',
	'prefswitch-jswarning' => 'Husk, at ved ændring af skin skal dit [[User:$1/$2.js|$2 JavaScript]] kopieres til [[{{ns:user}}:$1/vector.js]] <!-- eller [[{{ns:user}}:$1/common.js]]--> for at blive ved med at fungere.',
	'prefswitch-csswarning' => 'Dine [[User:$1/$2.css|brugertilpassede $2-styles]] bliver ikke længere anvendt. Du kan tilføje brugertilpasset CSS til Vector i [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nej',
	'prefswitch-survey-submit-off' => 'Slå nye funktioner fra',
	'prefswitch-survey-cancel-off' => 'Hvis du vil fortsætte med at bruge de nye funktioner, kan du gå tilbage til $1.',
	'prefswitch-survey-submit-feedback' => 'Send feedback',
	'prefswitch-survey-cancel-feedback' => 'Såfremt du ikke ønsker at give feedback, kan du gå tilbage til $1.',
	'prefswitch-survey-question-like' => 'Hvad kunne du lide om de nye funktioner?',
	'prefswitch-survey-question-dislike' => '↓ Hvad kunne du ikke lide om de nye funktioner?',
	'prefswitch-survey-question-whyoff' => 'Hvorfor afbryder du de nye funktioner?
Vælg alle, som passer.',
	'prefswitch-survey-answer-whyoff-hard' => 'Funktionerne var for vanskelige at bruge.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Funktionerne fungerede ikke korrekt.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Funktionerne opførte sig ikke som man ville forvente.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Jeg kunne ikke lide den måde funktionerne så ud.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Jeg kunne ikke lide de nye faneblade og layoutet.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Jeg kunne ikke lide den nye værktøjslinje.',
	'prefswitch-survey-answer-whyoff-other' => 'Anden grund:',
	'prefswitch-survey-question-browser' => 'Hvilken browser benytter du?',
	'prefswitch-survey-answer-browser-other' => 'Anden browser:',
	'prefswitch-survey-question-os' => 'Hvilket operativsystem benytter du?',
	'prefswitch-survey-answer-os-other' => 'Andet operativsystem:',
	'prefswitch-survey-question-res' => 'Hvad er din skærmopløsning?',
	'prefswitch-title-on' => 'Nye funktioner',
	'prefswitch-title-switched-on' => 'God fornøjelse!',
	'prefswitch-title-off' => 'Slå nye funktioner fra',
	'prefswitch-title-switched-off' => 'Tak',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'De nye funktioner er nu sat til. Vi håber, du vil synes om at bruge dem, men ellers kan du altid fjerne dem igen ved at klikke på linket "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" øverst på siden.',
	'prefswitch-success-off' => 'De nye funktioner er nu fjernet. Tak fordi du prøvede dem. Du kan altid slå dem til igen ved at klikke på linket "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" øverst på siden.',
	'prefswitch-success-feedback' => 'Din feedback er blevet sendt.',
	'prefswitch-return' => '↓ <hr style="clear:both">
Tilbage til <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Et skærmbillede af Wikipedias nye navigationsgrænseflade <small>[[Media:VectorNavigation-en.png|(forstør)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Et skærmbillede af sideredigeringsgrænsefladen <small>[[Media:VectorEditorBasic-en.png|(forstør)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Et skærmbillede af den nye dialogboks til indsættelse af henvisninger
|}
|}
Wikimedia Foundations brugeroplevelsesteam har arbejdet sammen med frivillige brugere for at gøre tingene nemmere for dig. Vi glæder os til at dele nogle forbedringer med dig, heriblandt et nyt udseende og nye simplificerede redigeringsfunktioner. Disse ændringer har som formål at gøre det nemmere for nye bidragydere med at komme i gang, og er baseret på vores [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study brugeroplevelsesundersøgelser foretaget sidste år]. Forbedring af brugeroplevelsen har høj prioritet hos Wikimedia Foundation, og vi vil dele flere forbedringer med dig i fremtiden. For flere detaljer, se det relaterede [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia Wikimedia-blogindlæg].

=== Her er hvad vi har ændret ===
* '''Navigation:''' Vi har forbedret navigationen for læsning og redigering af sider. Nu definerer fanerne i toppen af vinduet mere klart om du redigerer, eller læser en side eller diskussion.
* '''Redigeringsværktøjslinje:''' Vi har reorganiseret redigeringsværktøjslinjen for at gøre den nemmere at bruge. Nu er formateringsfunktioner mere simple og mere intuitive.
* '''Trin-for-trin-linktilføjelsesdialog:''' En simpel linktilføjelsesdialog, der gør det muligt for dig at tilføje links til andre wikisider, såvel som eksterne websteder.
* '''Søgeforbedringer:''' Vi har forbedret søgeforslagene for at gøre det hurtigere for dig at finde den side du søger.
* '''Andre nye funktioner:''' Vi introducerer også en tabeltilføjelsesdialog for at gøre det nemmere at tilføje tabeller, samt en søg-og-erstat-funktion for at simplificere sideredigeringen.
* '''Wikipedia-logo:''' Vi har opdateret vores logo. Læs mere på [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedias blog].",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}}-fanen''' er nu en stjerne.
* '''{{int:move}}-fanen''' findes nu i dropdown-menuen ved siden af søgefeltet.",
	'prefswitch-main-feedback' => 'Vi vil meget gerne høre fra dig. Besøg gerne vores [[$1|feedback-side]]. Hvis du især er interesseret i vores fortsatte bestræbelser på at forbedre brugervenligheden, så besøg vores [http://usability.wikimedia.org brugervenligheds-wiki].',
	'prefswitch-main-anon' => '[$1 Klik her for at fjerne de nye funktioner]. Du vil blive bedt om at logge ind eller oprette en konto først,',
	'prefswitch-main-on' => '[$2 Klik her for at afbryde de nye funktioner].',
	'prefswitch-main-off' => '===Prøv dem!===
[$1 Klik her for at aktivere de nye funktioner].',
	'prefswitch-survey-intro-feedback' => 'Vi vil meget gerne høre fra dig.
Udfyld venligst den frivillige undersøgelse forneden før du klikker på "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Tak for at du afprøvede vores nye funktioner.
For at hjælpe os med at forbedre dem, udfyld venligst det valgfrie undersøgelsesskema nedenfor før du klikker på "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Feedback fra brugererfaring',
);

/** German (Deutsch)
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de'] = array(
	'prefswitch' => 'Usability-Einstellungen',
	'prefswitch-desc' => 'Erlaube Benutzern die Umschaltung zwischen verschiedenen Einstellungs-Sets',
	'prefswitch-link-anon' => 'Neue Funktionen',
	'tooltip-pt-prefswitch-link-anon' => 'Erfahre mehr über die neuen Funktionen',
	'prefswitch-link-on' => 'Zurück zur alten Oberfläche',
	'tooltip-pt-prefswitch-link-on' => 'Deaktivierung der neuen Funktionen',
	'prefswitch-link-off' => 'Neue Funktionen',
	'tooltip-pt-prefswitch-link-off' => 'Neue Features ausprobieren',
	'prefswitch-jswarning' => 'Bedenke, dass mit der Skin-Änderung dein [[User:$1/$2.js|$2-JavaScript]] nach [[{{ns:user}}:$1/vector.js]] <!-- oder [[{{ns:user}}:$1/common.js]] --> kopiert werden muss, um weiter funktionieren zu können.',
	'prefswitch-csswarning' => 'Deine [[User:$1/$2.css|angepassten $2-Styles]] werden nicht mehr ausgeführt. Du kannst angepasstes CSS für Vector auf [[{{ns:user}}:$1/vector.css]] einfügen.',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nein',
	'prefswitch-survey-submit-off' => 'Neue Features abschalten',
	'prefswitch-survey-cancel-off' => 'Wenn du die neuen Features weiter verwenden willst, kannst du zu $1 zurückkehren.',
	'prefswitch-survey-submit-feedback' => 'Feedback geben',
	'prefswitch-survey-cancel-feedback' => 'Wenn du kein Feedback geben möchtest, kannst du zu $1 zurückkehren.',
	'prefswitch-survey-question-like' => 'Was gefiel dir an den Features?',
	'prefswitch-survey-question-dislike' => 'Was mochtest du an den Features nicht?',
	'prefswitch-survey-question-whyoff' => 'Warum schaltest du die neuen Features ab?
Bitte wähle alle zutreffenden Punkte aus.',
	'prefswitch-survey-question-globaloff' => 'Möchtest du die neuen Features global abschalten?',
	'prefswitch-survey-answer-whyoff-hard' => 'Die Verwendung war zu kompliziert.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Es funktioniert nicht einwandfrei.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Es funktioniert nicht in vorhersehbarer Weise.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Ich mag das Aussehen nicht.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Ich mag die neuen Tabs und das Layout nicht.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ich mag die neue Werkzeugleiste nicht.',
	'prefswitch-survey-answer-whyoff-other' => 'Anderer Grund:',
	'prefswitch-survey-question-browser' => 'Welchen Browser verwendest du?',
	'prefswitch-survey-answer-browser-other' => 'Anderer Browser:',
	'prefswitch-survey-question-os' => 'Welches Betriebssystem verwendest du?',
	'prefswitch-survey-answer-os-other' => 'Anderes Betriebssystem:',
	'prefswitch-survey-answer-globaloff-yes' => 'Ja, die neuen Features sollen auf allen Wikis abgeschaltet werden',
	'prefswitch-survey-question-res' => 'Was ist deine Bildschirmauflösung?',
	'prefswitch-title-on' => 'Neue Features',
	'prefswitch-title-switched-on' => 'Viel Spaß!',
	'prefswitch-title-off' => 'Neue Features abschalten',
	'prefswitch-title-switched-off' => 'Danke',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'Die neuen Funktionalitäten sind jetzt aktiv. Wir wünschen dir viel Freude bei deren Verwendung. Du kannst sie jederzeit deaktivieren, indem du auf den Link „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]“ oben auf der Webseite klickst.',
	'prefswitch-success-off' => 'Die neuen Funktionalitäten sind jetzt inaktiv. Vielen Dank, dass du sie verwendet hast. Du kannst sie jederzeit aktivieren, indem du auf den Link „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]“ oben auf der Webseite klickst.',
	'prefswitch-success-feedback' => 'Dein Feedback wurde versandt.',
	'prefswitch-return' => '<hr style="clear:both">
Zurück zu <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-de.png|401px|]]
|-
| Ein Screenshot von Wikipedias neuer Navigationsoberfläche <small>[[Media:VectorNavigation-de.png|(vergrößern)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-de.png|401px|]]
|-
| Ein Screenshot der einfachen Bearbeitungsoberfläche <small>[[Media:VectorEditorBasic-de.png|(vergrößern)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-de.png|401px|]]
|-
| Ein Screenshot der neuen Dialoge zum Einfügen von Links
|}
|}

Das User Experience Team der Wikimedia Foundation hat zusammen mit Freiwilligen aus der Gemeinschaft daran gearbeitet, die Bedienung der Benutzeroberfläche für dich einfacher zu machen. Wir freuen uns, einige Verbesserungen zu präsentieren, unter anderem ein neues Aussehen und vereinfachte Bearbeitungsfunktionen. Diese Veränderungen sind dazu da, neuen Benutzern einen einfacheren Start zu ermöglichen, und basieren auf unseren [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study über das gesamte letzte Jahr durchgeführten Benutzbarkeits-Tests]. Die Benutzbarkeit unserer Projekte zu erhöhen ist eine Priorität der Wikimedia Foundation, welche auch in Zukunft weitere Updates präsentieren wird. Für weitere Informationen, siehe den [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia Wikimedia-Blog-Eintrag].

=== Was sich verändert hat ===
* '''Navigation:''' Wir haben die Navigation zum Lesen und zur Bearbeitung der Seiten verbessert. Die Reiter am Kopf jeder Seite zeigen klarer, ob du eine Seite oder eine Diskussionsseite liest und ob du eine Seite liest oder bearbeitest.
* '''Werkzeugleiste:''' Wir haben die Werkzeugleiste einfacher bedienbar gemacht. Die Formatierung von Seiten ist nun einfacher und intuitiver.
* '''Link-Assistent:''' Ein einfach zu bedienender Dialog ermöglicht das Hinzufügen von Links sowohl zu anderen Wiki-Seiten als auch zu externen Seiten.
* '''Suche:''' Wir haben die Suchvorschläge verbessert, damit du schneller zu der von dir gesuchten Seite kommst.
* '''Weiteres:''' Ein Tabellen-Assistent ermöglicht das einfache Erstellen von Tabellen und ein Suchen-und-Ersetzen-Dialog vereinfacht die Seitenbearbeitung.
* '''Wikipedia-Puzzle-Globus''': Wir haben den Puzzle-Globus erneuert, mehr Informationen im [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Wikimedia-Blog.]",
	'prefswitch-main-logged-changes' => '* Der „{{int:watch}}“-Tab ist nun ein Stern.
* Der „{{int:move}}“-Tab ist nun in dem Dropdown-Menü neben der Suchleiste.',
	'prefswitch-main-feedback' => '===Feedback?===
Wir würden gerne von dir hören. Bitte benutze unsere [[$1|Feedback-Seite]] oder, falls du an unserer momentanen Arbeit zur Verbesserung der Software interessiert bist, besuche das [http://usability.wikimedia.org Usability-Wiki] für weitere Informationen.',
	'prefswitch-main-anon' => '===Zurück===
Sofern du die neuen Funktionen deaktivieren möchtest, dann [$1 klicke hier]. Du wirst dann gebeten dich anzumelden oder zunächst ein neues Benutzerkonto zu erstellen.',
	'prefswitch-main-on' => '=== Bring mich zurück! ===
Wenn du die neuen Features abschalten möchtest, [$2 klicke hier].',
	'prefswitch-main-off' => '=== Probiere es aus! ===
Wenn du die neuen Features einschalten möchtest, [$1 klick hier].',
	'prefswitch-survey-intro-feedback' => 'Wir würden uns freuen, von dir zu hören.
Bitte fülle die freiwillige Umfrage aus, bevor du auf „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]“ klickst.',
	'prefswitch-survey-intro-off' => 'Danke für das Ausprobieren unserer neuen Features.
Damit wir besser werden können, fülle bitte die freiwillige Umfrage aus, bevor du auf „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]“ klickst.',
	'prefswitch-feedbackpage' => 'Project:Usability-Initiative/Feedback',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author KagerMtc
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'prefswitch' => 'Nutzerspezifische Regelungen',
	'prefswitch-desc' => 'Nutzerspezifische Regelungen',
	'prefswitch-jswarning' => 'Bedenken Sie, dass mit der Skin-Änderung Ihr [[User:$1/$2.js|$2-JavaScript]] nach [[{{ns:user}}:$1/vector.js]] <!-- oder [[{{ns:user}}:$1/common.js]] --> kopiert werden muss, um weiter funktionieren zu können.',
	'prefswitch-csswarning' => 'Ihre [[User:$1/$2.css|angepassten $2-Styles]] werden nicht mehr ausgeführt. Sie können angepasstes CSS für Vector auf [[{{ns:user}}:$1/vector.css]] einfügen.',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nein',
	'prefswitch-survey-submit-off' => 'Ohne neue Gestaltungsformen',
	'prefswitch-survey-cancel-off' => 'Wenn Sie die neuen Features weiter verwenden wollen, können Sie zu $1 zurückkehren.',
	'prefswitch-survey-submit-feedback' => 'Feedback',
	'prefswitch-survey-cancel-feedback' => 'Wenn Sie kein Feedback geben möchten, können Sie zu $1 zurückkehren.',
	'prefswitch-survey-question-like' => 'Was gefiel Ihnen an den Features?',
	'prefswitch-survey-question-dislike' => 'Was mochten Sie an den Features nicht?',
	'prefswitch-survey-question-whyoff' => 'Warum schalten Sie die neuen Features ab?
Bitte wählen Sie alle zutreffenden Punkte aus.',
	'prefswitch-survey-question-globaloff' => 'Möchten Sie die neuen Features global abschalten?',
	'prefswitch-survey-answer-whyoff-hard' => 'Die Gestaltungsformen waren zu komplex.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Die Gestaltungsformen funktionierten nicht.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Die Gestaltungsformen funktionierten nicht vorhersehbar.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Die Gestaltungsformen gefallen mir nicht.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Ich mochte die neuen Tabs und das Layout nicht.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ich mochte die neue Funktionsbar nicht',
	'prefswitch-survey-answer-whyoff-other' => 'Anderer Grund:',
	'prefswitch-survey-question-browser' => 'Welchen Browser verwenden Sie?',
	'prefswitch-survey-answer-browser-other' => 'Anderer Browser',
	'prefswitch-survey-question-os' => 'Welches Betriebssystem verwenden Sie?',
	'prefswitch-survey-answer-os-other' => 'Anderes Betriebssystem:',
	'prefswitch-survey-question-res' => 'Was ist Ihre Bildschirmauflösung?',
	'prefswitch-title-on' => 'Neue Gestaltungsformen',
	'prefswitch-title-switched-on' => 'Viel Spaß!',
	'prefswitch-title-off' => 'Ohne neue Gestatungsformen',
	'prefswitch-title-switched-off' => 'Vielen Dank',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'Die neuen Funktionalitäten sind jetzt aktiv. Wir wünschen Ihnen viel Freude bei deren Verwendung. Sie können sie jederzeit deaktivieren, indem Sie auf den Link „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]“ oben auf der Webseite klicken.',
	'prefswitch-success-off' => 'Die neuen Funktionalitäten sind jetzt inaktiv. Vielen Dank, dass Sie sie verwendet haben. Sie können sie jederzeit aktivieren, indem Sie auf den Link „[[Special:UsabilityInitiativePrefSwitch|Beta aktivieren]]“ oben auf der Webseite klicken.',
	'prefswitch-success-feedback' => 'Ihr Feedback wurde versandt.',
	'prefswitch-return' => '<hr style="clear:both">
Return to <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Ein Screenshot von Wikipedias neuer Navigationsoberfläche <small>[[Media:VectorNavigation-en.png|(vergrößern)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Ein Screenshot der einfachen Bearbeitungsoberfläche <small>[[Media:VectorEditorBasic-en.png|(vergrößern)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Ein Screenshot der neuen Dialoge zum Einfügen von Links
|}
|}

Das User Experience Team der Wikimedia Foundation hat zusammen mit Freiwilligen aus der Gemenschaft daran gearbeitet, die Sachen für Sie einfacher zu machen. Wir freuen uns, einige Verbesserungen zu präsentieren, unter anderem ein neues Aussehen und vereinfachte Bearbeitungsfunktionen. Diese Veränderungen sind dazu da, neuen Benutzern einen einfacheren Start zu ermöglichen und sind basiert auf unseren [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study über das gesamte letzte Jahr durchgeführten Benutzbarkeits-Tests]. Die Benutzbarkeit unserer Projekte zu erhöhen ist eine Priorität der Wikimedia Foundation, welche auch in Zukunft weitere Updates präsentieren wird. Für weitere Informationen, siehe den [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia Wikimedia-Blog-Eintrag].

=== Was sich verändert hat ===
* '''Navigation:''' Wir haben die Navigation zum Lesen und zur Bearbeitung der Seiten verbessert. Die Reiter am Kopf jeder Seite zeigen klarer, ob Sie eine Seite oder eine Diskussionsseite lesen und ob Sie eine Seite lesen oder bearbeiten.
* '''Werkzeugleiste:''' Wir haben die Werkzeugleiste einfacher bedienbar gemacht. Die Formatierung von Seiten ist nun einfacher und intuitiver.
* '''Link-Assistent:''' Ein einfach zu bedienender Dialog ermöglicht das Hinzufügen von Links sowohl zu anderen Wiki-Seiten als auch zu externen Seiten.
* '''Suche:''' Wir haben die Suchvorschläge verbessert, damit Sie schneller zu der von dir gesuchten Seite kommen.
* '''Weiteres:''' Ein Tabellen-Assistent ermöglicht das einfache Erstellen von Tabellen und ein Suchen-und-Ersetzen-Dialog vereinfacht die Seitenbearbeitung.
* '''Wikipedia-Puzzle-Globus''': wir haben den Puzzle-Globus erneuert, mehr Informationen im [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Wikimedia-Blog.]",
	'prefswitch-main-feedback' => '===Feedback?===
Wir würden gerne von Ihnen hören. Bitte benutzen Sie unsere [[$1|Feedback-Seite]] oder, falls Sie an unseren momentanen Arbeit zur Verbesserung der Software interessiert sind, besuchen Sie das [http://usability.wikimedia.org Usability-Wiki] für weitere Informationen.',
	'prefswitch-main-anon' => '===Zurück===
Sofern Sie die neuen Funktionen deaktivieren möchten, dann [$1 klicken Sie hier]. Sie werden dann gebeten sich anzumelden oder zunächst ein neues Benutzerkonto zu erstellen.',
	'prefswitch-main-on' => '=== Bring mich zurück! ===
Wenn Sie die neuen Features abschalten möchten, [$2 klicken Sie hier].',
	'prefswitch-main-off' => '=== Versuchen Sie es! ===
Wenn Sie die neuen Gestaltungsformen nutzen möchten, [$1 klicken Sie hier].',
	'prefswitch-survey-intro-feedback' => 'Wir würden uns freuen, von Ihnen zu hören.
Bitte füllen Sie die freiwillige Umfrage aus, bevor Sie auf „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]“ klicken.',
	'prefswitch-survey-intro-off' => 'Danke für das Ausprobieren unserer neuen Features.
Damit wir besser werden können, füllen Sie bitte die freiwillige Umfrage aus, bevor Sie auf „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]“ klicken.',
	'prefswitch-feedbackpage' => 'Project: Nutzer-Feedback-Initiative',
);

/** Zazaki (Zazaki)
 * @author Asmen
 * @author Xoser
 */
$messages['diq'] = array(
	'prefswitch' => 'Terchinê insiyative kar kerdisi a bike',
	'prefswitch-desc' => 'Destur bide karberan ke tercihi a bike',
	'prefswitch-link-anon' => 'Xısusiyetê newey',
	'tooltip-pt-prefswitch-link-anon' => 'Xısusiyetanê neweyan bımuse',
	'prefswitch-link-on' => 'Mı peyser bere',
	'tooltip-pt-prefswitch-link-on' => 'Xısusiyetanê neweyan bıqefelne (megurene)',
	'prefswitch-link-off' => 'Xısusiyetê newey',
	'tooltip-pt-prefswitch-link-off' => 'Xısusiyetanê neweyan bıcerrebne',
	'prefswitch-jswarning' => 'Xo biyer viri, eka ti deri xo vurneno [[User:$1/$2.js|$2 JavaScript]] tu gani kopye bi [[{{ns:user}}:$1/vector.js]] <!-- ya zi [[{{ns:user}}:$1/common.js]]--> gurê xo dewam bike.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|Stilê $2 yê şexsi]] tu hind nişixulyena. Ti eşkana CSS şexsi semed vector de bike [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Heya',
	'prefswitch-survey-false' => 'Nê',
	'prefswitch-survey-submit-off' => 'Xısusiyetanê neweyan megurene (bıqefelne)',
	'prefswitch-survey-cancel-off' => 'Eke şıma qayili xacetana newe bışuxulnî tede bımanî, şıma eşkeni agêri no $1 peli.',
	'prefswitch-survey-submit-feedback' => 'Feedback bıde',
	'prefswitch-survey-cancel-feedback' => 'Eke şıma qayili niya feedback bide, şıma eşkeni agêri no $1 peli.',
	'prefswitch-survey-question-like' => 'Şıma çınaê xısusiyetanê neweyan ra hez kerd?',
	'prefswitch-survey-question-dislike' => 'Şıma çınaê xısusiyetanê neweyan ra hez nêkerd?',
	'prefswitch-survey-question-whyoff' => 'Ti ci ra xecetanê newe qefilneno?
Ma rica kene hemi biwecine.',
	'prefswitch-survey-answer-whyoff-hard' => 'Xacetan ser gure kerdis zaf zahmet bi.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Xacetan hewl ni hewitiyeno.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Xecatan zaf hewl nihewtiyena.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Xısusiyetê newey mı ra rındek nêasay.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Mi ra nizam u fesalê aye rınd niyo.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ez toolbare newe hes nikeni.',
	'prefswitch-survey-answer-whyoff-other' => 'Sebebo bin:',
	'prefswitch-survey-question-browser' => 'Kamci navigator ser komputer tu sixulyena?',
	'prefswitch-survey-answer-browser-other' => 'Navigatore bini:',
	'prefswitch-survey-question-os' => 'Kamci sisteme oparatifi ser komputer tu sixulyena?',
	'prefswitch-survey-answer-os-other' => 'Sisteme Opratife bini',
	'prefswitch-survey-question-res' => 'Monitor tu de resulasyon cita ya?',
	'prefswitch-title-on' => 'Xaceto Newe',
	'prefswitch-title-switched-on' => 'Xerli bu!',
	'prefswitch-title-off' => 'Xaceto newe a bike',
	'prefswitch-title-switched-off' => 'Berxudar bu',
	'prefswitch-title-feedback' => 'Fiqir bide',
	'prefswitch-success-on' => 'Eka hacetê new a biya. Ma umid keni ti xacetanê newe hes keni. Ti her zeman eşkena eyaranê verini ser ena "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" link de reyna a bike.',
	'prefswitch-success-off' => 'Eka hacetê new a kefiliyeya. Ma umid keni ti xacetanê newe hes keni. Ti her zeman eşkena eyaranê verini ser ena "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" link de reyna a bike.',
	'prefswitch-success-feedback' => 'Fiqire tu şiya.',
	'prefswitch-return' => '<hr style="clear:both">
Reyna peyser şo <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Yew resimê nevigasyonê Wikipediya newe <small>[[Media:VectorNavigation-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Yew resimê interfaceyê nuştişi <small>[[Media:VectorEditorBasic-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Yew resimê qutiyê diyalogê newe seba dekerdişi gireyan
|}
|}
Dernegê Wikipediyayi, Grubê Deneyimê Karberi u cemaat ra yardimciyan seba  kolay kerdişê Wikipediyayi ser hewitiyeni. Ma zaf şay biya ke ma tay xacetanê neweyan viraşti. Eni xacetanê neweyan de ti hind eşkena kolay binusi. Xacetanê neweyan kaberanê newyan rê her çi kolay keni.  [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study Testê şuxulnayişi ma ra ena mocna]. Raver berdişiyê projeyanê ma Dernegê Wikipediyayi rê zaf muhim o. Ma hind şima rê xeberanê xacetanê neweyan şaweni. Seba enformasyonê zafyeri şo [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog post].


=== Çi vuriya?===
* '''Nevigasyon:''' Seba wendiş u nuştişê meqaleyan kolay kerdişi, ma nevigasyon raver berdi. Tuşan ke ser pel de hind tu ra mocneni eka ti meqele vurnen ya zi ti pela miniqeşeyi vuneni ya zi ti kamci pele wendeni.
* '''Xacetanê nuştişi ke raver biya:''' Ma xacetanê nuştişi organize kerd. Eka nuştiş u formet kerdiş hind bi zaf rehat.
* '''Wizardê gireyi:''' Eka yew tablo wikipediya esta. Hind ti kolay eşkena pel de gire bierz.
* '''Cigeyrayişi:''' Ma cigeyrayişi zaf kolay kerd. Eka ti quti de çikek binusi, ti ra tevsiye keno.
* '''Xacetanê neweyanê bini:''' Ma yew wizard viraşt  ke hind tablo viraştiş kolay biy; format kerdişi zaf rahet o.
* '''Logoyê Wikipediyayi:''' Ma logo xo vurne. Tiya de biweni [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog].",
	'prefswitch-main-logged-changes' => "* Tabê '''{{int:watch}} tab''' eka yew estareye wa..
* Tabê'''{{int:move}} tab''' eka zerrê dropdown ke kiste kutiyê cigeyrayiş de wa.",
	'prefswitch-main-feedback' => '===Fiqir bide?===
Ma wazeni şima fiqirê xo ma rê vace. Ma rica kena [[$1|pele fiqir dayişi]] ziyaret bike ya zi eka ma rê ser software yardim bike, ma rica keni pelê [http://usability.wikimedia.org wiki şuxulnayişi] de zaf enformation est ê.',
	'prefswitch-main-anon' => '===Mı peyser bere===
[$1 Eke şıma wazenê xısusiyetanê neweyan bıqefelnê/megurenê, etıya bıtıknên]. Şıma gani cı kewê ya zi hesab vırazê.',
	'prefswitch-main-on' => '===Mı peyser bere===
Şıma gani cı kewê ya zi hesab vırazê.[$2 Eke şıma wazenê xısusiyetanê neweyan bıqefelnê/megurenê, etıya bıtıknên].',
	'prefswitch-main-off' => '===Deneme bike===
[$1 Eka ti wazeni xacetanê newe a bike, itiya ra klik bike].',
	'prefswitch-survey-intro-feedback' => 'Ma wazeni şima fiqirê xo ma rê vace.
Ma rica kena anket ma biweni bine ena pele de "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Seba şuxulnayişê hacetanê newe, ma tu ra zaf teşekur keni.
Seba yardim kerdişi, ma rica keni ena anket ma a biki "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Feedback bidisê karberan',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'prefswitch' => 'Pśešaltowanje nastajenjow iniciatiwy wužywajobnosći',
	'prefswitch-desc' => 'Wužywarjam dowóliś, sajźby nastajenjow pśešaltowaś',
	'prefswitch-link-anon' => 'Nowe funkcije',
	'tooltip-pt-prefswitch-link-anon' => 'Wěcej wó nowych funkcijach zgóniś',
	'prefswitch-link-on' => 'Slědk',
	'tooltip-pt-prefswitch-link-on' => 'Nowe funkcije znjemóžniś',
	'prefswitch-link-off' => 'Nowe funkcije',
	'tooltip-pt-prefswitch-link-off' => 'Nowe funkcije wopytaś',
	'prefswitch-jswarning' => 'Źiwaj na to, až ze změnjanim suknje twój [[User:$1/$2.js|javascript $2]] musy se do [[User:$1/vector.js]] abo [[User:$1/common.js]] kopěrowaś, aby se dalej funkcioněrował.',
	'prefswitch-csswarning' => 'Twóje [[User:$1/$2.css|swójske stile $2]] wěcej njebudu se nałožowaś. Móžoš swójski CSS za Vector w [[User:$1/vector.css]] pśidaś.',
	'prefswitch-survey-true' => 'Jo',
	'prefswitch-survey-false' => 'Ně',
	'prefswitch-survey-submit-off' => 'Nowe funkcije wótšaltowaś',
	'prefswitch-survey-cancel-off' => 'Jolic coš nowe funkcije dalej wužywaś, móžoš se k $1 wrośiś.',
	'prefswitch-survey-submit-feedback' => 'Měnjenje pósłaś',
	'prefswitch-survey-cancel-feedback' => 'Jolic njocoš měnjenje pósłaś, móžoš se do $1 wrośiś.',
	'prefswitch-survey-question-like' => 'Co spódoba se śi na nowych funkcijach?',
	'prefswitch-survey-question-dislike' => 'Co njespódoba se śi na nowych funkcijach?',
	'prefswitch-survey-question-whyoff' => 'Cogodla wótšaltujoš nowe funkcije?
Pšosym wubjeŕ wšykne, kótarež maju se nałožyś.',
	'prefswitch-survey-question-globaloff' => 'Cośo funkcije globalnje wótšaltowaś?',
	'prefswitch-survey-answer-whyoff-hard' => 'Wužywanje jo było pśekomplicěrowane.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Njejo pórědnje funkcioněrowało.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Njejo ako pśedwiźone funkcioněrowało.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Naglěd se mě njespódoba.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Nowe rejtarki a layout se mi njespódobaju.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nowa rědowa kšoma se mi njespódoba.',
	'prefswitch-survey-answer-whyoff-other' => 'Druga pśicyna:',
	'prefswitch-survey-question-browser' => 'Kótary wobglědowak wužywaš?',
	'prefswitch-survey-answer-browser-other' => 'Drugi wobglědowak:',
	'prefswitch-survey-question-os' => 'Kótary źěłowy system wužywaš?',
	'prefswitch-survey-answer-os-other' => 'Drugi źěłowy system:',
	'prefswitch-survey-answer-globaloff-yes' => 'Jo, funkcije maju se na wšyknych wikijach wótšaltowaś',
	'prefswitch-survey-question-res' => 'Co jo rozeznaśe twójeje wobrazowki?',
	'prefswitch-title-on' => 'Nowe funkcije',
	'prefswitch-title-switched-on' => 'Wjele wjasela!',
	'prefswitch-title-off' => 'Nowe funkcije wótšaltowaś',
	'prefswitch-title-switched-off' => 'Źěkujomy se',
	'prefswitch-title-feedback' => 'Rezonanca',
	'prefswitch-success-on' => 'Nowe funkcije su něnto zašaltowane. Naźejamy se, až wjaseliš se nowym funkcijam. Móžoš je kuždy cas pśez kliknjenje na wótkaz "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" górjejce na bpku wušaltowaś.',
	'prefswitch-success-off' => 'Nowe funkcije su něnto wótšaltowane. Žěkujomy se, až sy nowe funkcije testował. Móžoš je kuždy cas pśez kliknjenje na wótkaz "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" górjejce na bpku zašaltowaś.',
	'prefswitch-success-feedback' => 'Twójo měnjenje jo se pósłało.',
	'prefswitch-return' => '<hr style="clear:both">
Slědk k <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-de.png|401px|]]
|-
| Wobrazkowe foto nowego nawigaciskego pówjercha Wikipedije <small>[[Media:VectorNavigation-de.png|(powětšyś)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-de.png|401px|]]
|-
| Wobrazkowe foto zakładnego pówjercha za wobźěłowanje bokow <small>[[Media:VectorEditorBasic-de.png|(powětyš)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-de.png|401px|]]
|-
| Wobrazkowe foto nowego dialogowego kašćika za zapódawanje wótkazow
|}
|}
Team za pólěpšenje wužywajobnosći załožby Wikimedia Foundation źěła z dobrowólnymi zgromaźeństwa, aby wěcy za tebje wólažcył. By my se wjaselili, sw wo pólěpšenjach wuměniś, inkluziwnje nowy naglěd a zjadnorjone wobźěłowańske funkcije. Toś te změny maju nowym sobuskutkajucym start pólažcyś a bazěruju na našom [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study testowanju wužywajobnosći, kótarež jo se bu cełe lěto pśewjeźone]. Pólěpšenje wužywajobnosći našych projektow jo priorita załožby Wikimedia foundation a rozdźělijomy wěcej aktualizacijow w pśichoźe. Za dalšne informacije, woglědaj se wótpowědny [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Wikimedia blogowy zapisk].

===Tole smy změnili===
* '''Nawigacija''': Smy pólěpšyli nawigaciju za cytanje a wobźěłowanje bokow. Něnto rejtarki górjejce na boku mógu jasnjej definěrowaś, lěc woglědujoš se nastawk abo diskusijny bok, a lěc cytaš abo wobźěłujoš bok.
* '''Pólěpšenja wobźěłowańskeje lejstwy''': Smy pśeorganizowali wobźěłowańsku lejstwu, aby wužywanje wólažcyli. Něnto jo formatěrowanje bokow lažčejše a intuitiwnjejše.
* '''Wótkazowy asistent''': Rěd, kótaryž dajo se lažko wužywaś a śi dowólujo, wótkaze drugim wikibokam ako teke wótkaze eksternym sedłam pśidaś.
* '''Pytańske pólěpšenja''' Smy pytańske naraźenja pólěpšyli, aby śi wjadli malsnjej k tomu bokoju, kótaryž pytaš.
* '''Druge nowe funkcije''': Smy teke zawjadli tabelowy asistent, aby wólažcyli napóranje tabelow a funkciju za pytanje a narownanje, aby my zjadnorili wobźěłowanje bokow.
* '''Logo wikipedije:''' Smy našo logo zaktualizěrowali. Dalšne informacije na [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blogu Wikimedije].",
	'prefswitch-main-logged-changes' => "* '''Rejtark {{int:watch}}''' jo něnto gwězda.
* '''Rejtark {{int:move}}''' jo něnto wuběrański meni pód šypku direktnje pódla pytańskego póla.",
	'prefswitch-main-feedback' => '===Měnjenja?===
My by se wjaselili, wót tebje słyšaś. Pšosym woglědaj se [[$1|bok měnjenjow]] abo, jolic zajmujoš se za naše běžne napinanja, aby se softwara pólěpšyła,  woglědaj se naš [http://usability.wikimedia.org wiki wužywajobnosći] za dalšne informacije.',
	'prefswitch-main-anon' => '===Slědk===
Jolic coš nowe funkcije znjemóžnis, [$1 klikni how].  Pšose śi se pśizjawiś abo nejpjerwjej konto załožyś.',
	'prefswitch-main-on' => '===Spóraj mě slědk!===
Jolic coš nowe funkcije wótšaltowaś, [$2 klikni pšosym how].',
	'prefswitch-main-off' => '===Wopytaj je!===
Jolic coš nowe funkcije zašaltowaś, [$1 klikni pšosym how].',
	'prefswitch-survey-intro-feedback' => 'My by se wjaselili, wót tebje słyšaś.
Pšosym wupołni slědujuce opcionalne napšašowanje, nježli až kliknjoš na "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Źěkujomy se, až sy wopytał naše nowe funkcije.
Aby nam pomogał, je pólěpšyś, wupołni pšosym slědujuce opcionalne napšašowanje, nježli až kliknjoš na "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Iniciatiwa wužywajobnosći měnjenja',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'prefswitch-survey-true' => 'Yo',
	'prefswitch-survey-false' => 'Kpao',
	'prefswitch-title-switched-off' => 'Akpe',
);

/** Greek (Ελληνικά)
 * @author Flyax
 * @author Geraki
 * @author Απεργός
 */
$messages['el'] = array(
	'prefswitch' => 'Πρωτοβουλία για τη Χρηστικότητα αλλαγή προτιμήσεων',
	'prefswitch-desc' => 'Να επιτρέπεται στους χρήστες να αλλάζουν ομάδες προτιμήσεων',
	'prefswitch-link-anon' => 'Νέα χαρακτηριστικά',
	'tooltip-pt-prefswitch-link-anon' => 'Μάθετε για τα νέα χαρακτηριστικά',
	'prefswitch-link-on' => 'Επιστροφή στις παλιές ρυθμίσεις',
	'tooltip-pt-prefswitch-link-on' => 'Απενεργοποίηση καινούριων λειτουργιών',
	'prefswitch-link-off' => 'Νέα χαρακτηριστικά',
	'tooltip-pt-prefswitch-link-off' => 'Δοκιμάστε νέα χαρακτηριστικά',
	'prefswitch-jswarning' => 'Θυμηθείτε ότι με την αλλαγή του θέματος εμφάνισης, η [[User:$1/$2.js|$2 JavaScript]] σας θα πρέπει να αντιγραφεί στο [[{{ns:user}}:$1/vector.js]] <!-- ή [[{{ns:user}}:$1/common.js]]--> για να συνεχίσει να δουλεύει.',
	'prefswitch-csswarning' => 'Τα [[User:$1/$2.css|προσαρμοσμένα στυλ $2]] δεν θα εφαρμόζονται πλέον. Μπορείτε να προσθέσετε προσαρμοσμένα CSS για το vector στο [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ναι',
	'prefswitch-survey-false' => 'Όχι',
	'prefswitch-survey-submit-off' => 'Απενεργοποίηση καινούργιων λειτουργιών',
	'prefswitch-survey-cancel-off' => 'Αν θέλετε να συνεχίσετε να χρησιμοποιείτε τα νέα χαρακτηριστικά, μπορείτε να επιστρέψετε στο $1.',
	'prefswitch-survey-submit-feedback' => 'Αποστολή σχολίων',
	'prefswitch-survey-cancel-feedback' => 'Αν δεν θέλετε να δώσετε σχόλια, μπορείτε να επιστρέψετε στο $1.',
	'prefswitch-survey-question-like' => 'Τι σας άρεσε στις καινούργιες λειτουργίες;',
	'prefswitch-survey-question-dislike' => 'Τι δεν σας άρεσε στις λειτουργίες;',
	'prefswitch-survey-question-whyoff' => 'Γιατί απενεργοποιείτε τα νέα χαρακτηριστικά; Επιλέξτε όλα όσα ισχύουν.',
	'prefswitch-survey-answer-whyoff-hard' => 'Ήταν πολύ δύσχρηστες.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Δεν λειτουργούσαν σωστά.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Δεν συμπεριφέρονταν προβλέψιμα.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Δεν μου άρεσε η εμφάνισή τους.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Δεν μου άρεσαν οι καινούριες καρτέλες και η διάταξη.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Δεν μου άρεσε η καινούρια εργαλειοθήκη.',
	'prefswitch-survey-answer-whyoff-other' => 'Άλλος λόγος:',
	'prefswitch-survey-question-browser' => 'Ποιο φυλλομετρητή ιστοσελίδων χρησιμοποιείτε;',
	'prefswitch-survey-answer-browser-other' => 'Άλλο φυλλομετρητή:',
	'prefswitch-survey-question-os' => 'Ποιο λειτουργικό σύστημα χρησιμοποιείτε;',
	'prefswitch-survey-answer-os-other' => 'Άλλο λειτουργικό σύστημα:',
	'prefswitch-survey-question-res' => 'Ποια είναι η ανάλυση της οθόνης σας;',
	'prefswitch-title-on' => 'Νέα χαρακτηριστικά',
	'prefswitch-title-switched-on' => 'Απολαύστε τες!',
	'prefswitch-title-off' => 'Απενεργοποίηση των καινούριων λειτουργιών',
	'prefswitch-title-switched-off' => 'Ευχαριστούμε',
	'prefswitch-title-feedback' => 'Σχόλια',
	'prefswitch-success-on' => 'Τα νέα χαρακτηριστικά είναι τώρα ενεργοποιημένα. Ελπίζουμε ότι απολαμβάνετε τα νέα χαρακτηριστικά.  Μπορείτε πάντα να τα απενεργοποιήσετε ξανά κάνοντας κλικ στο σύνδεσμο "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" στην κορυφή της σελίδας.',
	'prefswitch-success-off' => 'Τα νέα χαρακτηριστικά απενεργοποιήθηκαν.  Ευχαριστούμε που δοκιμάσατε τα νέα χαρακτηριστικά.  Μπορείτε πάντα να τα ενεργοποιήσετε ξανά κάνοντας κλικ στο σύνδεσμο "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" στην κορυφή της σελίδας.',
	'prefswitch-success-feedback' => 'Τα σχόλια σας αποστάλθηκαν.',
	'prefswitch-return' => '<hr style="clear:both">
Επιστροφή στο <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-el.png|401px|]]
|-
| Ένα στιγμιότυπο του νέου περιβάλλοντος πλοήγησης της Βικιπαίδειας <small>[[Media:VectorNavigation-en.png|(μεγέθυνση)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-el.png|401px|]]
|-
| Ένα στιγμιότυπο της βασικής διεπαφής για την επεξεργασία σελίδων <small>[[Media:VectorEditorBasic-en.png|(μεγέθυνση)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-el.png|401px|]]
|-
| Ένα στιγμιότυπο του νέου διαλόγου για την εισαγωγή συνδέσμων
|}
|}

Η ομάδα ''User Experience'' του Ιδρύματος Wikimedia δουλέψαμε με εθελοντές από την κοινότητα για να κάνουμε πιο εύκολα τα πράγματα για εσάς.  Είμαστε ενθουσιασμένοι που μοιραζόμαστε μαζί σας μερικές βελτιώσεις, που περιλαμβάνουν μια καινούρια εμφάνιση και αισθητική και απλοποιημένες λειτουργίες επεξεργασίας.  Οι αλλαγές σκοπεύουν να κάνουν ευκολότερο στους νέους συνεισφέροντες να ξεκινήσουν, και βασίζονται στις [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study δοκιμές χρηστικότητας που διεξήχθησαν τον τελευταίο χρόνο]. Η βελτίωση της χρηστικότητας των εγχειρημάτων μας είναι προτεραιότητα του Ιδρύματος Wikimedia και θα συνεχίσουμε να δημοσιεύουμε κι άλλες ενημερώσεις στο μέλλον. Για περισσότερες λεπτομέρειες, επισκεφτείτε το σχετικό  [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia μήνυμα στο ιστολόγιο] του Ιδρύματος Wikimedia.

===Αυτά που αλλάξαμε===
* '''Πλοήγηση:''' Έχουμε βελτιώσει την πλοήγηση για την ανάγνωση και την επεξεργασία σελίδων. Τώρα οι καρτέλες στο πάνω μέρος της κάθε σελίδας δείχνουν πιο καθαρά αν βλέπετε την ίδια τη σελίδα  ή τη σελίδα συζήτησης, και επίσης αν διαβάζετε ή αν επεξεργάζεστε μια σελίδα.
* '''Βελτιώσεις στην εργαλειοθήκη επεξεργασίας:''' Αναδιοργανώσαμε την εργαλειοθήκη επεξεργασίας ώστε να είναι πιο εύχρηστη.  Τώρα η μορφοποίηση σελίδων είναι πιο απλή και πιο διαισθητική.
* '''Οδηγός για συνδέσμους:'''  Ένα εύχρηστο εργαλείο που σας επιτρέπει να προσθέσετε συνδέσμους προς άλλες σελίδες της Βικιπαίδειας καθώς και προς εξωτερικούς ιστότοπους.
* '''Βελτιώσεις στην αναζήτηση:''' Έχουμε βελτιώσει τις συμβουλές αναζήτησης, ώστε  να οδηγηθείτε στη σελίδα που ψάχνετε πιο γρήγορα.
* '''Άλλες νέες λειτουργίες:'''  Επιπλέον έχουμε εισαγάγει έναν οδηγό που διευκολύνει τη δημιουργία πινάκων, και μια λειτουργία για αναζήτηση-αντικατάσταση που απλοποιεί την επεξεργασία σελίδων.
* '''Λογότυπο της Βικιπαίδειας:''' Ανανεώσαμε το λογότυπο. Διαβάστε περισσότερα στο [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d ιστολόγιο του Ιδρύματος Wikimedia].",
	'prefswitch-main-logged-changes' => "* Η '''{{int:watch}} καρτέλα''' είναι τώρα ένα αστέρι.
* Η ''''καρτέλα {{int:move}}'''' είναι τώρα στην αναπτυσσόμενη λίστα δίπλα στην μπάρα αναζήτησης.",
	'prefswitch-main-feedback' => '=== Ανατροφοδότηση; ===
Θα θέλαμε πολύ να ακούσουμε από εσάς. Παρακαλούμε επισκεφθείτε την [[$1|σελίδα ανατροφοδότησής]] μας, ή, αν σας ενδιαφέρουν οι συνεχιζόμενες προσπάθειές μας για τη βελτίωση του λογισμικού, επισκεφθείτε το [http://usability.wikimedia.org wiki χρηστικότητας] για περισσότερες πληροφορίες.',
	'prefswitch-main-anon' => '===Επιστροφή στις παλιές ρυθμίσεις===
[$1 Πατήστε εδώ για να απενεργοποιήσετε τη νέα χαρακτηριστικά]. Θα σας ζητηθεί να συνδεθείτε ή να δημιουργήσετε ένα λογαριασμό πρώτα.',
	'prefswitch-main-on' => '===Επιστροφή πίσω!===
[$2 Κάντε κλικ εδώ για να απενεργοποιήσετε τα νέα χαρακτηριστικά] .',
	'prefswitch-main-off' => '===Δοκιμάστε τα!===
[$1 Πατήστε εδώ για να ενεργοποιήσετε τα νέα χαρακτηριστικά].',
	'prefswitch-survey-intro-feedback' => 'Θα χαιρόμασταν να μάθουμε τη γνώμη σας.
Σας παρακαλούμε να συμπληρώσετε το παρακάτω προαιρετικό ερωτηματολόγιο πριν πατήσετε την «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]».',
	'prefswitch-survey-intro-off' => 'Ευχαριστούμε που δοκιμάσατε τα νέα χαρακτηριστικά μας.
Για να μας βοηθήσετε να τα βελτιώσουμε, σας παρακαλούμε να συμπληρώσετε το παρακάτω προαιρετικό ερωτηματολόγιο πριν πατήσετε την «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».',
	'prefswitch-feedbackpage' => 'Project:Σχόλια χρηστών',
);

/** Esperanto (Esperanto)
 * @author ArnoLagrange
 * @author Crt
 * @author Yekrats
 */
$messages['eo'] = array(
	'prefswitch' => 'Baskulo por preferencoj de Uzebleco Initiato',
	'prefswitch-desc' => 'Permesi al uzantoj ŝanĝi arojn da preferencoj',
	'prefswitch-link-anon' => 'Novaj ecoj',
	'tooltip-pt-prefswitch-link-anon' => 'Lerni pri novaj ecoj',
	'prefswitch-link-on' => 'Reveni al la antaŭa versio',
	'tooltip-pt-prefswitch-link-on' => 'Malŝalti novajn ecojn',
	'prefswitch-link-off' => 'Novaj ecoj',
	'tooltip-pt-prefswitch-link-off' => 'Provi novajn funkciojn',
	'prefswitch-jswarning' => 'Memoru ke kun la etosŝanĝo , vi devos kopii vian [[User:$1/$2.js|$2 ĴavaSkriptaĵon]] al [[{{ns:user}}:$1/vector.js]]<!-- aŭ [[{{ns:user}}:$1/common.js]] --> por ke ĝi daŭre funkciu.',
	'prefswitch-csswarning' => 'Via [[User:$1/$2.css|personigita $2-stilo]] ne plu aplikiĝos. Vi povas aldoni personigitajn CSS-ojn por vector-etoso en [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Jes',
	'prefswitch-survey-false' => 'Ne',
	'prefswitch-survey-submit-off' => 'Malŝalti novajn funkciojn',
	'prefswitch-survey-cancel-off' => 'Se vi volus daŭri uzante la novajn funkciojn, vi povus reiri al $1.',
	'prefswitch-survey-submit-feedback' => 'Sendi komenton',
	'prefswitch-survey-cancel-feedback' => 'Se vi ne volas doni komenton, vi povas reiri al $1.',
	'prefswitch-survey-question-like' => 'Kio plaĉas al vi de la novaj funkcioj?',
	'prefswitch-survey-question-dislike' => 'Kio malplaĉas al vi de la novaj funkcioj?',
	'prefswitch-survey-question-whyoff' => 'Kial vi malŝaltas la novajn funkciojn?
Bonvolu elekti ĉiujn taŭgaĵojn.',
	'prefswitch-survey-question-globaloff' => 'Ĉu vi volas por la ecoj esti malŝaltitaj trans ĉiuj vikioj?',
	'prefswitch-survey-answer-whyoff-hard' => 'Ĝi estis tro malfacila uzi.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Ĝi ne funkciis ĝuste.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Ĝi ne funkciis laŭnorme.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'La aspekto de la interfaco ne plaĉas al mi.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'La novaj etikedoj kaj dizajno ne plaĉas al mi.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'La nova ilobreto ne plaĉas al mi.',
	'prefswitch-survey-answer-whyoff-other' => 'Alia kialo:',
	'prefswitch-survey-question-browser' => 'Kiun retumilon vi uzas?',
	'prefswitch-survey-answer-browser-other' => 'Alia retumilo:',
	'prefswitch-survey-question-os' => 'Kiun operaciumon vi uzas?',
	'prefswitch-survey-answer-os-other' => 'Alia operaciumo:',
	'prefswitch-survey-answer-globaloff-yes' => 'Jes, malŝaltu la novajn ecojn en ĉiuj vikioj',
	'prefswitch-survey-question-res' => 'Kio estas la distingivo de via ekrano?',
	'prefswitch-title-on' => 'Novaj funkcioj',
	'prefswitch-title-switched-on' => 'Ĝuu!',
	'prefswitch-title-off' => 'Malŝalti novajn funkciojn',
	'prefswitch-title-switched-off' => 'Dankon',
	'prefswitch-title-feedback' => 'Komentoj',
	'prefswitch-success-on' => 'Novaj funkcioj nun estas ŝaltitaj. Ni esperas ke vi aprezas uzi ilin. Vi povas ĉiumomente malŝalti ilin alklakante la ligilon
"[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]"  en la supro de la paĝo.',
	'prefswitch-success-off' => 'Novaj funkcioj nun estas malŝaltitaj. Dankon ke vi provas la novajn ecojn. Vi povas ĉiumomente reŝalti ilin  alklakante la ligilon "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" en la supro de la paĝo.',
	'prefswitch-success-feedback' => 'Viaj komento estis sendita.',
	'prefswitch-return' => '<hr style="clear:both">
Reiri al <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Ekrankapto de la nova navigilo <small>[[Media:VectorNavigation-en.png|(pligrandigu)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Ekrankapto de la nova progresa redakto-ilobreto <small>[[Media:VectorEditorBasic-en.png|(pligrandigu)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Ekrankapto de la nova enhav-generadaj dialogujoj
|}
|}

Ni penis faciligi aferojn por niaj uzantoj. Ni ĝojas provizi iujn novajn plibonigojn, inkluzivante novan aspekton kaj simpligitan redaktilaron. Ĉi tiuj ŝanĝoj celas igi redaktadon de Vikipedio pli facila por novaj kontribuantoj kaj estas bazitaj sur nia [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study studo kaj testado de uzebleco] farita lastjare. Plibonigado de la uzebleco estas prioritato de la Vikimedia Fondaĵo kaj ni sendos pluajn ĝisdatigojn estonte. Por pluaj detaloj, bonvolu viziti [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ rilatan Vikimedia-blogeron].

===Jen kion ni ŝanĝis===
* '''Navigado:''' Ni plibonigis la navigadon por legi kaj redakti paĝojn. Nun la etikedoj ĉe la supro de ĉiu paĝo pli klare difinas ĉu vi vidas la paĝon aŭ la diskuto-paĝon, kaj ĉu vi legas aŭ redaktas la paĝon.
* '''Redakta ilobreto:''' Ni reorganizis la redaktan ilobreton por simpligi ĝin. Nun, formataj paĝoj estas pli simpla kaj pli intuicia.
* '''Ligila asistanto:''' Facila ilo por aldoni ligilojn al aliaj paĝoj de Vikipedio kaj ligiloj al eksteraj retejoj.
* '''Serĉaj plibonigoj:''' Ni plibonigis serĉsugestojn por pli rapide direkti vin al la paĝo kiun vi serĉas.
* '''Aliaj novaj funkcioj:''' Ni ankaŭ aldonis tabelan asistanton, por faciligi kreadon de tabeloj, kaj funkcio por anstataŭigi tekston en paĝoj.
* '''Vikipedia puzlo-globo''': Ni ĝisdatigis la puzloglobon. Legu plu ĉe la [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Vikimedia-blogo].",
	'prefswitch-main-logged-changes' => "* La '''{{int:watch}}-klapeto''' estas nun stelo.
* La'''{{int:move}}-klapeto''' estas nun en la malfadebla strio apud la serĉa baro.",
	'prefswitch-main-feedback' => '===Reagoj?===
Ni ŝatus aŭdi pri vi. Bonvolu viziti nian [[$1|reagopaĝon]] aŭ se vi interesiĝas pri niaj nunaj penoj por plibonigi la softvaron, vizitu nian [http://usability.wikimedia.org uzeblecovikion] por pliaj informoj.',
	'prefswitch-main-anon' => '===Revenigu min  al la antaŭa versio===
[$1 Alklaku ĉi tie por malŝalti la novajn ecojn]. Vi estos antaŭe petata esti ensalutinta aŭ kreinta konton.',
	'prefswitch-main-on' => '===Revenigu min al la antaŭa versio===
Se vi volus malŝalti la novajn funkciojn, bonvolu [$2 klaki ĉi tie].',
	'prefswitch-main-off' => '===Trovu ĝin nun!===
Se vi volus ŝalti la novajn funkciojn, bonvolu [$1 klaki ĉi tie].',
	'prefswitch-survey-intro-feedback' => 'Ni bonvenus vian opinion.
Bonvolu plenumi la jenan malnepran enketon antaŭ klakante "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Dankon pro provante niajn novajn funkciojn.
Helpi nin por plibonigi ilin, bonvolu plenumi la jenan malnepran enketon antaŭ klakante "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Sciigoj pri uzantospertoj',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author Locos epraix
 * @author Muro de Aguas
 * @author Pertile
 * @author Platonides
 */
$messages['es'] = array(
	'prefswitch' => 'Conmutador de la preferencia de Iniciativa de Usabilidad',
	'prefswitch-desc' => 'Permitir a los usuarios cambiar los conjuntos de preferencias',
	'prefswitch-link-anon' => 'Nuevas características',
	'tooltip-pt-prefswitch-link-anon' => 'Aprender acercadelasnuevas características',
	'prefswitch-link-on' => 'Volver a la versión anterior',
	'tooltip-pt-prefswitch-link-on' => 'Deshabilitar nuevas características',
	'prefswitch-link-off' => 'Nuevas características',
	'tooltip-pt-prefswitch-link-off' => 'Probar las nuevas características',
	'prefswitch-jswarning' => 'Recuerda que al cambiar de skin, tendrás que copiar a [[{{ns:user}}:$1/vector.js]] <!-- o a  [[{{ns:user}}:$1/common.js]]-->el [[User:$1/$2.js|javascript de tu $2]] para que siga funcionando.',
	'prefswitch-csswarning' => "Dejarán de mostrarse tus [[User:$1/$2.css|estilos personalizados de $2]]. Puedes añadir CSS personalizado para la piel ''vector'' en [[User:$1/vector.css]].",
	'prefswitch-survey-true' => 'Sí',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Desactivar las nuevas características',
	'prefswitch-survey-cancel-off' => 'Si desea continuar utilizando las nuevas características puede volver a $1.',
	'prefswitch-survey-submit-feedback' => 'Enviar comentario',
	'prefswitch-survey-cancel-feedback' => 'Si no desea enviar sus comentarios puede volver a $1.',
	'prefswitch-survey-question-like' => 'Qué te gustó de las nuevas características?',
	'prefswitch-survey-question-dislike' => 'Qué no te gustó de las nuevas características',
	'prefswitch-survey-question-whyoff' => '¿Por qué está desactivando las nuevas características?
Por favor seleccione todas las opciones que correspondan.',
	'prefswitch-survey-question-globaloff' => '¿Desea desactivar las nuevas características globalmente?',
	'prefswitch-survey-answer-whyoff-hard' => 'Era muy difícil de utilizar.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'No funcionó correctamente.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Tuvo comportamientos impredecibles.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'No me gustó la forma en que se veía.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'No me gustaron las nuevas solapas ni el diseño.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'No me gustó la nueva barra de herramientas.',
	'prefswitch-survey-answer-whyoff-other' => 'Otras razones:',
	'prefswitch-survey-question-browser' => '¿Qué navegador utiliza?',
	'prefswitch-survey-answer-browser-other' => 'Otro navegador:',
	'prefswitch-survey-question-os' => '¿Qué sistema operativo utiliza?',
	'prefswitch-survey-answer-os-other' => 'Otro sistema operativo:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sí, desactivar las nuevas características en todos los proyectos',
	'prefswitch-survey-question-res' => '¿Cuál es la resolución de su pantalla?',
	'prefswitch-title-on' => 'Nuevas características',
	'prefswitch-title-switched-on' => '¡Disfrute!',
	'prefswitch-title-off' => 'Desactivar las nuevas características',
	'prefswitch-title-switched-off' => 'Gracias',
	'prefswitch-title-feedback' => 'Comentarios',
	'prefswitch-success-on' => 'Se han activado las nuevas características. Esperamos que disfrutes las nuevas características. Siempre puedes desactivarlas presionando "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" en la parte superior de la página.',
	'prefswitch-success-off' => 'Se han desactivado las nuevas características. Gracias por probarlas. Siempre puedes activarlas presionando presionando "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" en la parte superior de la página.',
	'prefswitch-success-feedback' => 'Sus comentarios han sido enviados.',
	'prefswitch-return' => '<hr style="clear:both">
Volver a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-es.png|401px|]]
|-
| Nueva interfaz de navegación de Wikipedia <small>[[Media:VectorNavigation-es.png|(ampliar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-es.png|401px|]]
|-
| Nueva interfaz básica de edición <small>[[Media:VectorEditorBasic-es.png|(ampliar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-es.png|401px|]]
|-
| Nuevo cuadro de diálogo para insertar enlaces
|}
|}
El Equipo de experiencia del usuario de la fundación Wikimedia ha estado trabajando con voluntarios de la comunidad para hacer las cosas más fáciles para ti. Nos emociona poder compartir algunas de nuestras mejoras, incluyendo una nueva estética y características de edición simplificadas. Estos cambios intentan hacerlo más fácil para los contribuyentes que comienzan, y están basados en nuestro [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study test de usabilidad realizado durante el año anterior]. La usabilidad de nuestros proyectos es una de las prioridades de la Fundación Wikimedia y en un futuro estaremos compartiendo más actualizaciones al respecto. Para más información, visita [http://blog.wikimedia.org/2010/a-new-look-for-wikipedia/ el blog de Wikimedia] (en inglés).

===Aquí está lo que hemos cambiado===
* '''Navegación:''' hemos mejorado la navegación para la lectura y edición de páginas. Ahora las pestañas en la parte superior de cada página definen de forma más precisa si se está viendo una página o una página de discusión, y si se está leyendo o editando una página.
* '''Mejoras en la barra de herramientas de edición:''' hemos reorganizado la barra de herramientas de edición para que sea más sencilla de utilizar. Ahora dar formato a las páginas es más simple e intuitivo.
* '''Asistente de enlaces:''' una sencilla herramienta permite añadir enlaces ya sea a páginas de Wikipedia o a otros sitios externos.
* '''Mejoras en la búsqueda:''' hemos mejorado las sugerencias para llegar más rápido a la página que se está buscando.
* '''Otras nuevas características:''' también hemos introducido un asistente de tablas para hacer más sencilla la creación de tablas y una funcionalidad de buscar y reemplazar que simplifica la edición de páginas.
* '''Logo de Wikipedia''': Hemos actualizado nuestro logo. Encontrarás más información al respecto en el [http://blog.wikimedia.org/2010/wikipedia-in-3d/ blog de Wikimedia] (en inglés).",
	'prefswitch-main-logged-changes' => "* La '''pestaña {{int:watch}}''' ahora aparece como una estrella.
* La '''pestaña {{int:move}}''' se encuentra ahora en el menú desplegable situado junto a la barra de búsqueda.",
	'prefswitch-main-feedback' => '===¿Tienes comentarios?===
Nos encantaría escucharte. Por favor visita nuestra [[$1|página de comentarios]] o, si estás interesado en nuestros actuales esfuerzos para mejorar el software, visita nuestra [http://usability.wikimedia.org wiki de usabilidad] para mayor información.',
	'prefswitch-main-anon' => '=== Volver a la versión anterior ===
Si deseas deshabilitar las nuevas características, haz clic [$1 aquí]. Necesitarás iniciar sesión o crear una cuenta primero.',
	'prefswitch-main-on' => '===Volverme a la versión anterior!===
[$2 Haz click aquí para desactivar las nuevas características].',
	'prefswitch-main-off' => '===Pruébalos!===
Si deseas activar las nuevas características, por favor haz [$1 click aquí].',
	'prefswitch-survey-intro-feedback' => 'Nos encantaría escucharlo.
Por favor llene la encuesta opcional de abajo presionando "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Gracias por probar nuestras nuevas características.
Para ayudarnos a mejorarlas, por favor llene la encuesta de abajo presionando "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Feedback de experiencia de usuario',
);

/** Estonian (Eesti)
 * @author AivoK
 * @author Hendrik
 * @author Kyng
 * @author Pikne
 */
$messages['et'] = array(
	'prefswitch' => 'Kasutushõlpsuse algatuse eelistuse valimine',
	'prefswitch-desc' => 'Lubab kasutajal eelistuste komplekte vahetada.',
	'prefswitch-link-anon' => 'Uued funktsioonid',
	'tooltip-pt-prefswitch-link-anon' => 'Lisateave uute funktsioonide kohta',
	'prefswitch-link-on' => 'Tagasi',
	'tooltip-pt-prefswitch-link-on' => 'Keela uued funktsioonid',
	'prefswitch-link-off' => 'Uued funktsioonid',
	'tooltip-pt-prefswitch-link-off' => 'Proovi uusi funktsioone',
	'prefswitch-jswarning' => "Pea meeles, et seoses kujunduse muutumisega on sul tarvis oma [[User:$1/$2.js|''$2''-JavaScript]] toimimiseks leheküljele [[{{ns:user}}:$1/vector.js]] <!-- või [[{{ns:user}}:$1/common.js]]--> kopeerida.",
	'prefswitch-csswarning' => "Sinu [[User:$1/$2.css|kohandatud ''$2''-stiilileht]] ei rakendu enam. Kujunduse Vektor jaoks saad kohandatud CCS-i lisada lehele [[{{ns:user}}:$1/vector.css]].",
	'prefswitch-survey-true' => 'Jah',
	'prefswitch-survey-false' => 'Ei',
	'prefswitch-survey-submit-off' => 'Lülita uued funktsioonid välja',
	'prefswitch-survey-cancel-off' => 'Kui soovid uute funktsioonide kasutamist jätkata, saad naasta leheküljele $1.',
	'prefswitch-survey-submit-feedback' => 'Saada tagasiside',
	'prefswitch-survey-cancel-feedback' => 'Kui sa ei soovi tagasisidet anda, saad naasta leheküljele $1.',
	'prefswitch-survey-question-like' => 'Mis sulle uute funktsioonide juures meeldis?',
	'prefswitch-survey-question-dislike' => 'Mis sulle uute funktsioonide juures ei meeldinud?',
	'prefswitch-survey-question-whyoff' => 'Miks sa uued funktsioonid välja lülitad?
Palun vali kõik sobivad.',
	'prefswitch-survey-question-globaloff' => 'Kas soovid funktsioonid globaalselt välja lülitada?',
	'prefswitch-survey-answer-whyoff-hard' => 'Seda oli liiga keeruline kasutada.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'See ei toiminud korralikult.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'See ei toiminud oodatult.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Mulle ei meeldinud selle välimus.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Mulle ei meeldinud uued sakid ega kujundus.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Mulle ei meeldinud uus tööriistariba.',
	'prefswitch-survey-answer-whyoff-other' => 'Muu põhus:',
	'prefswitch-survey-question-browser' => 'Millist internetilehitsejat sa kasutad?',
	'prefswitch-survey-answer-browser-other' => 'Muu brauser:',
	'prefswitch-survey-question-os' => 'Millist operatsioonisüsteemi sa kasutad?',
	'prefswitch-survey-answer-os-other' => 'Muu operatsioonisüsteem:',
	'prefswitch-survey-answer-globaloff-yes' => 'Jah, lülita funktsioonid kõigis vikides välja',
	'prefswitch-survey-question-res' => 'Milline on su kuvari eraldusvõime?',
	'prefswitch-title-on' => 'Uued funktsioonid',
	'prefswitch-title-switched-on' => 'Naudi!',
	'prefswitch-title-off' => 'Uute funktsioonide väljalülitamine',
	'prefswitch-title-switched-off' => 'Aitäh',
	'prefswitch-title-feedback' => 'Tagasiside',
	'prefswitch-success-on' => 'Uued funktsioonid on nüüd sisse lülitatud. Loodame, et naudid uute funktsioonide kasutamist. Võid nad alati tagasi välja lülitada, klõpsates lehekülje ülal linki "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]".',
	'prefswitch-success-off' => 'Uued funktsioonid on nüüd välja lülitatud. Aitäh, et uusi funktsioone proovisid. Võid nad alati tagasi sisse lülitada, klõpsates lehekülje ülal linki "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]".',
	'prefswitch-success-feedback' => 'Sinu tagasiside on saadetud.',
	'prefswitch-return' => '<hr style="clear:both">
Naase leheküljele <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorNavigation-en.png|401px|]]
|-
| Kuvatõmmis Vikipeedia uuest navigeerimisliidesest <small>[[Media:VectorNavigation-en.png|(suurenda)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorEditorBasic-en.png|401px|]]
|-
| Kuvatõmmis peamisest lehekülje toimetamisliidesest <small>[[Media:VectorEditorBasic-en.png|(suurenda)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorLinkDialog-en.png|401px|]]
|-
| Kuvatõmmis uuest linkide lisamiseks mõeldud dialoogikastist
|}
|}
Wikimedia sihtasutus koos vabatahtlikega kogukonnast on töötanud selle nimel, et kõike sinu jaoks lihtsamaks teha. Meil on hea meel jagada sinuga mõningaid täiustusi, sealhulgas uut ilmet ja muljet ning lihtsustatud toimetamisfunktsioone. Nende muudatuste abil peaks olema uuel kasutajal kergem alustada. Muudatused põhinevad [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study viimase aasta jooksul läbi viidud kasutatavuskatsetel]. Kasutuskõlblikkuse parandamine on Wikimedia sihtasutuse jaoks esmatähtis ja edaspidi jagame veelgi uuendusi. Üksikasjad leiad uuendusega seotud [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia ajaveebi postitusest].

=== Mida oleme muutnud ===
* '''Navigeerimine:''' Oleme loetavad ja toimetatavad leheküljed paremini navigeeritavaks teinud. Iga lehekülje kohal olevate sakkide järgi on nüüd kergem aru saada, kas vaatad artiklit või arutelu ning kas loed lehekülge või toimetad seda.
* '''Toimetamisriba täiustused:''' Oleme toimetamisriba nii ümber korraldanud, et seda lihtsam kasutada oleks. Lehekülgede vormindamine on nüüd lihtsam ja loogilisem.
* '''Linkimisviisard:''' Kergesti kasutatav riist, mis võimaldab teha nii teistele viki lehekülgedele kui ka teistesse võrgukohtadesse suunatud linke.
* '''Otsimistäiustused:''' Oleme täiustanud otsimisvihjed, et kasutaja kiiremini otsitavale leheküljele jõuaks.
* '''Muud uued funktsioonid:''' Oleme tutvustanud ka tabeliviisardit, millega on lihtsam tabeleid luua ja otsimis- ja asendusriista, millega on kergem lehekülge toimetada.
* '''Vikipeedia logo:''' Oleme oma logo uuendanud. Täpsemalt loe [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia ajaveebist].",
	'prefswitch-main-logged-changes' => "* Sakk '''{{int:watch}}''' on nüüd täheke.
* Sakk '''{{int:move}}''' on nüüd otsimisriba kõrval rippasendis.",
	'prefswitch-main-feedback' => '=== Tagasisidet? ===
Sooviksime meeleldi sinu arvamust kuulda. Palun külasta meie [[$1|tagasiside lehekülge]] või kui oled huvitatud käimasolevast tarkvara parandamistööst, külasta täpsema teabe jaoks [http://usability.wikimedia.org kasutushõlpsuse vikit].',
	'prefswitch-main-anon' => '===Vii mind tagasi===
[$1 Uute funktsioonide väljalülitamiseks klõpsa siia]. Enne palutakse sul sisse logida või konto luua.',
	'prefswitch-main-on' => '===Vii mind tagasi!===
[$2 Uute funktsioonide väljalülitamiseks klõpsa siia].',
	'prefswitch-main-off' => '===Proovi järele!===
[$1 Uute funktsioonide lubamiseks klõpsa siia].',
	'prefswitch-survey-intro-feedback' => 'Meile meeldiks teada saada sinu arvamust.
Enne kui klõpsad "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]", täida palun alljärgnev vabatahtlik küsitlus.',
	'prefswitch-survey-intro-off' => 'Aitäh, et proovisid uusi funktsioone.
Et saaksime neid täiustada, täida palun alljärgnev vabatahtlik küsitlus, enne kui klõpsad "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Joxemai
 */
$messages['eu'] = array(
	'prefswitch' => 'Erabilgarritasun Iniziatibako hobespen aldaketa',
	'prefswitch-desc' => 'Erabiltzaile hobespenak aldatzea gaitu',
	'prefswitch-link-anon' => 'Ezaugarri berriak',
	'tooltip-pt-prefswitch-link-anon' => 'Ezaugarri berriei buruz ikasi',
	'prefswitch-link-on' => 'Atzera eraman',
	'tooltip-pt-prefswitch-link-on' => 'Ezaugarri berriak ezgaitu',
	'prefswitch-link-off' => 'Ezaugarri berriak',
	'tooltip-pt-prefswitch-link-off' => 'Ezaugarri berriak frogatu',
	'prefswitch-jswarning' => 'Gogoratu skin aldaketarekin, zure [[User:$1/$2.js|$2 JavaScript]] kopiatu beharko duzula [[{{ns:user}}:$1/vector.js]]-(e)ra <!-- edo [[{{ns:user}}:$1/common.js]]--> lanean jarraitzeko.',
	'prefswitch-csswarning' => 'Zure [[User:$1/$2.css|$2 estilo pertsonalizatuak]] ez dira gehiago aplikatuko. Vector-entzako CSS pertsonalizatua gehitu dezakezu [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Bai',
	'prefswitch-survey-false' => 'Ez',
	'prefswitch-survey-submit-off' => 'Ezaugarri berriak kendu',
	'prefswitch-survey-cancel-off' => 'Ezaugarri berriak erabiltzen jarraitu nahi baduzu, $1-(e)ra itzul zaitezke.',
	'prefswitch-survey-submit-feedback' => 'Feedbacka bidali',
	'prefswitch-survey-cancel-feedback' => 'Ez baduzu feedbacka eman nahi, $1-(e)ra itzul zaitezke.',
	'prefswitch-survey-question-like' => 'Zer zenuen ezaugarri berrietan gustuko?',
	'prefswitch-survey-question-dislike' => 'Zer ez zenuen ezaugarri berrietan gustuko?',
	'prefswitch-survey-question-whyoff' => 'Zergatik desaktibatu dituzu ezaugarri berriak?
Mesedez hautatu nahi dituzun guztiak.',
	'prefswitch-survey-question-globaloff' => 'Ezaugarri berriak ezgaitu nahi dituzu?',
	'prefswitch-survey-answer-whyoff-hard' => 'Ezaugarriak oso zailak ziren erabiltzeko.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Ezaugarri berriak ez zebitzaten behar bezala.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Ezaugarriek ez zuten ondo funtzionatzen.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Ez nuen ezaugarrien itxura berria gustatzen.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Diseinu berria ez zitzaidan gustatzen.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ez zitzaidan tresna-barra berria gustatzen.',
	'prefswitch-survey-answer-whyoff-other' => 'Bestelako arrazoiak:',
	'prefswitch-survey-question-browser' => 'Zer nabigatzaile erabiltzen duzu?',
	'prefswitch-survey-answer-browser-other' => 'Beste nabigatzaile bat:',
	'prefswitch-survey-question-os' => 'Zer sistema eragile erabiltzen duzu?',
	'prefswitch-survey-answer-os-other' => 'Beste sistema eragile bat:',
	'prefswitch-survey-answer-globaloff-yes' => 'Bao, wiki guztietan ezaugarri berriak kendu',
	'prefswitch-survey-question-res' => 'Zein da zure pantailaren erresoluzioa?',
	'prefswitch-title-on' => 'Ezaugarri berriak',
	'prefswitch-title-switched-on' => 'Ongi pasa!',
	'prefswitch-title-off' => 'Ezaugarri berriak kendu',
	'prefswitch-title-switched-off' => 'Eskerrik asko',
	'prefswitch-title-feedback' => 'Feedbacka',
	'prefswitch-success-on' => 'Ezaugarri berriak martxan daude. Ezaugarri berriak gozatzea espero dugu. Nahi duzunean kendu ditzazkezu orriaren goialdeko "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" loturan klikatuz.',
	'prefswitch-success-off' => 'Ezaugarri berriak kenduta daude. Milesker ezaugarri berriak frogatzeagatik. Nahi duzunean jarri ditzazkezu orriaren goialdeko "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" loturan klikatuz.',
	'prefswitch-success-feedback' => 'Zure feedbacka bidali da.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span> -(e)ra itzuli .',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Wikipediaren nabigazio interfaze berriaren irudia <small>[[Media:VectorNavigation-en.png|(handitu)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Edizio interfaze berriaren irudia <small>[[Media:VectorEditorBasic-en.png|(handitu)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Loturak sartzeko kutxa berriaren irudia
|}
|}
Wikimedia Fundazioaren Erabiltzaile Esperientzia Taldea komunitatearen boluntarioekin lanean aritu da zuretzako gauzak errazteko asmoz. Hobekuntzak berriak zuk froga ditzazun nahi dugu, hala nola itxura berria eta edizio tresna sinplifikatuak. Aldaketa hauen helburua Wikipediako erabiltzaile berriei lana erraztea da, eta azken urteko gure [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study erabilgarritasun frogan] oinarritzen da. Gure proiektuaren erabilera errazagoa izatea Wikimedia Fundazioaren lehentasun nagusia da eta etorkizunean are gehiago erraztea nahi dugu. Xehetasun gehiagorako bisitatu Wikimediaren [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog ofiziala].

=== Hona hemen aldatu duguna ===
* '''Nabgazioa:''' Nabigazioa hobetu dugu irakurketa eta edizio orrialdeetan. Orain, orrialde bakoitzaren goialdean fitxak garbiago ageri dira eta artikulua irakurtzen edo editatzen ari zaren garbiago definitzen dute.
* '''Edizio tresna-barrako hobekuntzak:''' Edizio barra berrantolatu dugu errazago erabiltzeko. Orain, orriei formatua jartzea errazagoa eta intuitiboagoa da.
* '''Lotura magoa:''' Erabilera errazeko tresna, barne eta kanpo loturak errazago jartzeko.
* '''Bilaketa hobekuntzak:''' Bilatzen ari zaren orrialdera azkarrago iristeko bilaketa iradokizunak hobetu ditugu.
* '''Bestelako ezaugarri berriak:''' Taulak errazago egiteko taula mago bat sartu dugu lana sinplifikatzeko.
* '''Wikipediako logoa:''' Gure logoa eguneratu dugu. Irakurri gehiago [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog ofizialean].",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} botoia''' izar bat da orain.
* '''{{int:move}} botoia''' menu irekigarriak dago bilaketa kutxaren ondoan.",
	'prefswitch-main-feedback' => '===Feedbacka?===
Atsegin handiz zure erantzuna entzun nahi dugu. Mesedez bisitatu [[$1|feedback orrialdea]] edo, softwarea hobetzeko gure ekintzetan interesatuta bazaude, bisitatu gure [http://usability.wikimedia.org erabilgarritasun wikia] informazioa gehiagorako.',
	'prefswitch-main-anon' => '===Atzera joan===
[$1 Klikatu hemen ezaugarri berriak kentzeko]. Aurretik saioa hastea edo kontu berria sortzea eskatuko zaizu.',
	'prefswitch-main-on' => '===Atzera eraman!===
[$2 Klikatu hemen ezaugarri berriak kentzeko].',
	'prefswitch-main-off' => '===Forgatu!===
[$1 Klikatu hemen ezaugarri berriak frogatzeko].',
	'prefswitch-survey-intro-feedback' => 'Zure erantzuna atseginez jasoko dugu.
Mesedez, bete aukerako inkesta "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" klikatu aurretik.',
	'prefswitch-survey-intro-off' => 'Milesker ezaugarri berriak frogatzeagatik.
Hobetzen laguntzeko, bete aukerako inkesta "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" klikatu aurretik.',
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Persian (فارسی)
 * @author Bersam
 * @author Ebraminio
 * @author Huji
 * @author Ladsgroup
 * @author Wayiran
 */
$messages['fa'] = array(
	'prefswitch' => 'کلید ترجیحات بهبود کاربردپذیری',
	'prefswitch-desc' => 'به کاربران اجازهٔ تعویض مجموعه‌ای ترجیحات را بده',
	'prefswitch-link-anon' => 'ویژگی‌های جدید',
	'tooltip-pt-prefswitch-link-anon' => 'یادگیری در مورد ویژگی‌های جدید',
	'prefswitch-link-on' => 'مرا بازگردان',
	'tooltip-pt-prefswitch-link-on' => 'غیرفعال کردن ویژگی‌های جدید',
	'prefswitch-link-off' => 'ویژگی‌های جدید',
	'tooltip-pt-prefswitch-link-off' => 'خروج از امکانات جدید',
	'prefswitch-jswarning' => 'به خاطر داشته باشید که با تغییر پوست، [[User:$1/$2.js|$2 جاوااسکریپت]] شما برای ادامهٔ کار نیاز خواهد داشت تا به [[{{ns:user}}:$1/vector.js]] <!-- یا [[{{ns:user}}:$1/common.js]]--> کپی شود.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|تنظیمات $2 شخصی]] شما دیگر قابل استفاده نیست.شما می‌توانید تنظیمات شخصی خودتان را در پوسته وکتور در [[{{ns:user}}:$1/vector.css|این صفحه]] وارد کنید.',
	'prefswitch-survey-true' => 'بله',
	'prefswitch-survey-false' => 'خیر',
	'prefswitch-survey-submit-off' => 'غیرفعال کردن ویژگی های جدید',
	'prefswitch-survey-cancel-off' => 'اگر مایل به ادامه استفاده از ویژگی‌های جدید هستید;می‌توانید به $1 بازگردید.',
	'prefswitch-survey-submit-feedback' => 'ارسال بازخورد',
	'prefswitch-survey-cancel-feedback' => 'اگر به ارائهٔ بازخورد تمایلی ندارید، می‌توانید به $1 بازگردید.',
	'prefswitch-survey-question-like' => 'از چه چیزی از ویژگی‌های جدید خوشتان آمد؟',
	'prefswitch-survey-question-dislike' => 'از چه چیزی از ویژگی‌های جدید خوشتان نیامد؟',
	'prefswitch-survey-question-whyoff' => 'چرا ویژگی‌های جدید را غیرفعال کردید؟
لطفاً همهٔ مورادی را که صدق می‌کنند، انتخاب کنید.',
	'prefswitch-survey-question-globaloff' => 'آیا می‌خواهید ویژگی‌ها را به صورت سراسری خاموش کنید؟',
	'prefswitch-survey-answer-whyoff-hard' => 'ویژگی‌ها برای استفاده خیلی سخت است.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'ویژگی فعالیت‌های لازم را انجام نمی‌دهد.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'ویژگی آن‌طور که انتظار می‌رفت نیست.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'از ظاهر ویژگی‌ها خوشم نیامد.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'من از طرح‌بندی و زبانه‌های جدید خوشم نمی‌آید.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'من از نوار ابزار جدید خوشم نمی‌آید.',
	'prefswitch-survey-answer-whyoff-other' => 'دلیل دیگر:',
	'prefswitch-survey-question-browser' => 'از کدام مرورگر استفاده می‌کنید؟',
	'prefswitch-survey-answer-browser-ie5' => 'اینترنت اکسپلورر ۵',
	'prefswitch-survey-answer-browser-ie6' => 'اینترنت اکسپلورر ۶',
	'prefswitch-survey-answer-browser-ie7' => 'اینترنت اکسپلورر ۷',
	'prefswitch-survey-answer-browser-ie8' => 'اینترنت اکسپلورر ۸',
	'prefswitch-survey-answer-browser-ie9' => 'اینترنت اکسپلورر ۹',
	'prefswitch-survey-answer-browser-ff1' => 'فایرفاکس ۱',
	'prefswitch-survey-answer-browser-ff2' => 'فایرفاکس ۲',
	'prefswitch-survey-answer-browser-ff3' => 'فایرفاکس ۳',
	'prefswitch-survey-answer-browser-cb' => 'گوگل کروم بتا',
	'prefswitch-survey-answer-browser-c1' => 'گوگل کروم ۱',
	'prefswitch-survey-answer-browser-c2' => 'گوگل کروم ۲',
	'prefswitch-survey-answer-browser-c3' => 'گوگل کروم ۳',
	'prefswitch-survey-answer-browser-c4' => 'گوگل کروم ۴',
	'prefswitch-survey-answer-browser-c5' => 'گوگل کروم ۵',
	'prefswitch-survey-answer-browser-s3' => 'سافاری ۳',
	'prefswitch-survey-answer-browser-s4' => 'سافاری ۴',
	'prefswitch-survey-answer-browser-s5' => 'سافاری ۵',
	'prefswitch-survey-answer-browser-o9' => 'اپرا ۹',
	'prefswitch-survey-answer-browser-o9.5' => 'اپرا ۹٫۵',
	'prefswitch-survey-answer-browser-o10' => 'اپرا ۱۰',
	'prefswitch-survey-answer-browser-other' => 'مرورگر دیگر:',
	'prefswitch-survey-question-os' => 'از کدام سیستم عامل استفاده می‌کنید؟',
	'prefswitch-survey-answer-os-windows' => 'ویندوز',
	'prefswitch-survey-answer-os-windowsmobile' => 'ویندوز موبایل',
	'prefswitch-survey-answer-os-linux' => 'لینوکس',
	'prefswitch-survey-answer-os-other' => 'سیستم عامل دیگر:',
	'prefswitch-survey-answer-globaloff-yes' => 'بله، ویژگی‌ها را در تمام ویکی‌ها خاموش کن',
	'prefswitch-survey-question-res' => 'وضوح صفحهٔ نمایش‌تان چیست؟',
	'prefswitch-title-on' => 'ویژگی‌های جدید',
	'prefswitch-title-switched-on' => 'لذت ببرید!',
	'prefswitch-title-off' => 'غیرفعال کردن ویژگی‌های جدید',
	'prefswitch-title-switched-off' => 'با تشکر',
	'prefswitch-title-feedback' => 'بازخورد',
	'prefswitch-success-on' => 'ویژگی‌های جدید اکنون فعال شده‌است. ما امیدواریم که از استفاده از پوسته جدید لذت ببرید. شما می‌توانید با کلیک بر روی «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» در بالای صفحه این ویژگی را غیرفعال کنید.',
	'prefswitch-success-off' => 'ویژگی‌های جدید اکنون خاموش شده است. از آزمودن ویژگی‌های جدید سپاسگذاریم. شما می‌توانید همواره آن‌ها را با کلیک بر پیوند «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]» در بالای صفحه، بازگردانید.',
	'prefswitch-success-feedback' => 'بازخورد شما ارسال شد.',
	'prefswitch-return' => '<hr style="clear:both">
بازگشت به <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => '{| border="0" align="left" style="margin-right:1em"
| align="center" |
{| border="0" style="background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| یک نما از سیستم ناوبری در پوسته وکتور <small>[[Media:VectorNavigation-en.png|(بزرگ‌نمایی)]]</small>
|}
|-
| align="center" |
{| border="0" style="background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| یک نما از سیستم ویرایش در پوسته وکتور  <small>[[Media:VectorEditorBasic-en.png|(بزرگ‌نمایی)]]</small>
|}
|-
| align="center" |
{| border="0" style="background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
|یک نما از صفحه درخواست وارد کردن پیوند
|}
|}
تیم طراحی پوسته بنیاد ویکی‌مدیا در تلاش است تا فعالیت‌ها را برای شما آسان کند. از اینکه بهبودهایی صورت داده‌ایم هیجان‌زده‌ایم، از جمله اینکه با ظاهر جدید و محیطی دیگر و ابزارهای ویرایشی ساده، کار را برای شما آسان ساخته‌ایم. این تغییرات حاصل  [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study تلاش‌های گروه در یک سال گذشته است]. بنیاد در تلاش است تا این امکانات را برای آینده بهبود ببخشد. برای اطلاعات بیشتر به پیام‌های فرستاده شده در [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia  این وبلاگ] نگاهی بیندازید.

=== این‌ها چیزهایی است که ما تغییر داده‌ایم ===
*ناوبری: سیستم ناوبری برای ویرایش و مطالعه صفحات گسترش یافته است. اکنون چند برچسب (تَب) برای دسترسی شما به صفحه بحث و تاریخچه مقاله، ایجاد شده است. 
*نوار ابزار ویرایش: سیستم ویرایش نیز بهبود یافته است. اکنون قالب ویرایش صفحه‌ها برای شما آسان‌تر شده‌است. 
*ویزارد برای پیونددهی: ابزاری ساده برای افزودن پیوندها ایجاد شده‌است. 
*بهبود موتور جستجو: ابزار پیشنهاد برای جستجوهای شما پیشرفته‌تر شده است. 
*امکانات دیگر: ابزاری برای افزودن جداول نیز ایجاد شده است.
*لوگوی بنیاد: نماد بنیاد نیز بروز شده است، برای اطلاعات بیشتر [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d این صفحه] را بخوانید.',
	'prefswitch-main-logged-changes' => "* '''برگه {{int:watch}}''' اکنون یک ستاره است.
* '''برگه {{int:move}}''' یک منوی کشویی در کنار دیگر برگه‌هاست.",
	'prefswitch-main-feedback' => '===بازخورد؟===
ما خوشحال می‌شویم نظر شما را بشنویم. لطفا در [[$1|صفحهٔ بازخورد]] نظرتان را بیان کنید یا اگر علاقه‌مندید تا ابزار را بهبود ببخشید لطفاً در [http://usability.wikimedia.org ویکی استفاده‌پذیری] بیان کنید.',
	'prefswitch-main-anon' => '===مرا بازگردان===
[$1 اینجا را کلیک کنید تا ویژگی‌های جدید را غیرفعال کنید].از شما خواسته خواهد شد که ابتدا یا وارد شوید یا حسابی بسازید.',
	'prefswitch-main-on' => '===من را بازگردان !===
[$2 در این جا کلیک کنید تا ویژگی های جدید را برگردانید].',
	'prefswitch-main-off' => '===امتحانشان کنید!===
[$1 برای فعال کردن ویژگی‌های جدید اینجا را کلیک کنید].',
	'prefswitch-survey-intro-feedback' => 'مشتاق شنیدن دیدگاه‌های شما هستیم.
لطفاً تحقیق اختیاری زیر را پیش از کلیک بر «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]» پر کنید.',
	'prefswitch-survey-intro-off' => 'به خاطر امتحان کردن ویژگی‌های جدید سیستم ما از شما تشکر می‌کنیم.
برای کمک به ما در جهت بهبود‌سازی آن‌ها، لطفا قبل از کلیک روی «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]» نظرسنجی اختیاری زیر را پر کنید.',
	'prefswitch-feedbackpage' => 'Project:بازخورد تجربه کاربر',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'prefswitch' => 'Käytettävyyshankkeen asetusvalinta',
	'prefswitch-desc' => 'Mahdollistaa käyttäjille asetussarjan vaihtamisen.',
	'prefswitch-link-anon' => 'Uudet ominaisuudet',
	'tooltip-pt-prefswitch-link-anon' => 'Lisätietoja uusista ominaisuuksista',
	'prefswitch-link-on' => 'Palaa vanhaan versioon',
	'tooltip-pt-prefswitch-link-on' => 'Poista käytöstä uudet omaisuudet',
	'prefswitch-link-off' => 'Uudet ominaisuudet',
	'tooltip-pt-prefswitch-link-off' => 'Kokeile uusia ominaisuuksia',
	'prefswitch-jswarning' => 'Muista, että ulkoasuvaihdoksen takia JavaScript-tiedostosi [[User:$1/$2.js|$2]] täytyy kopioida nimelle [[{{ns:user}}:$1/vector.js]]<!-- tai [[{{ns:user}}:$1/common.js]]-->, jotta se toimisi.',
	'prefswitch-csswarning' => 'Käyttäjäkohtaista CSS-tyylisivuasi [[User:$1/$2.css|$2]] ei enää sovelleta. Voi lisätä käyttäjäkohtaisen CSS-tyylisivun Vector-ulkoasua varten sivulle [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Kyllä',
	'prefswitch-survey-false' => 'Ei',
	'prefswitch-survey-submit-off' => 'Poista käytöstä uudet omaisuudet',
	'prefswitch-survey-cancel-off' => 'Jos haluat jatkaa uusien ominaisuuksien käyttämistä, voit palata sivulle $1.',
	'prefswitch-survey-submit-feedback' => 'Lähetä palaute',
	'prefswitch-survey-cancel-feedback' => 'Jos et halua antaa palautetta, voit palata sivulle $1.',
	'prefswitch-survey-question-like' => 'Mistä pidit uusissa ominaisuuksissa?',
	'prefswitch-survey-question-dislike' => 'Mistä et pitänyt uusissa ominaisuuksissa?',
	'prefswitch-survey-question-whyoff' => 'Miksi olet poistamassa käytöstä uusia ominaisuuksia?
Valitse kaikki sopivat.',
	'prefswitch-survey-question-globaloff' => 'Haluatko poistaa ominaisuuden käytöstä kaikissa wikeissämme?',
	'prefswitch-survey-answer-whyoff-hard' => 'Ominaisuudet olivat liian vaikeakäyttöisiä.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Ominaisuudet eivät toimineet kunnolla.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Ominaisuudet eivät toimineet odotetusti.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'En pitänyt ominaisuuksien ulkonäöstä.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'En pitänyt uusista välilehdistä ja asettelusta.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'En pitänyt uudesta työkalupalkista.',
	'prefswitch-survey-answer-whyoff-other' => 'Muu syy',
	'prefswitch-survey-question-browser' => 'Mitä selainta käytät?',
	'prefswitch-survey-answer-browser-other' => 'Muu selain',
	'prefswitch-survey-question-os' => 'Mitä käyttöjärjestelmää käytät?',
	'prefswitch-survey-answer-os-other' => 'Muu käyttöjärjestelmä',
	'prefswitch-survey-answer-globaloff-yes' => 'Kyllä, poista ominaisuus käytöstä kaikissa wikeissä',
	'prefswitch-survey-question-res' => 'Mikä on näyttösi resoluutio?',
	'prefswitch-title-on' => 'Uudet ominaisuudet',
	'prefswitch-title-switched-on' => 'Nauti!',
	'prefswitch-title-off' => 'Poista käytöstä uudet omaisuudet',
	'prefswitch-title-switched-off' => 'Kiitos',
	'prefswitch-title-feedback' => 'Palaute',
	'prefswitch-success-on' => 'Uudet ominaisuudet ovat nyt käytössä. Toivomme, että nautit uusien ominaisuuksien käytöstä. Voit aina ottaa ne pois käytöstä napsauttamalla ”[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]” -linkkiä sivun yläreunasta.',
	'prefswitch-success-off' => 'Uudet ominaisuudet ovat nyt poistettu käytöstä. Kiitos uusien ominaisuuksien kokeilusta. Voit aina ottaa ne takaisin käyttöön napsauttamalla ”[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]” -linkkiä sivun yläreunasta.',
	'prefswitch-success-feedback' => 'Palautteesi on lähetetty.',
	'prefswitch-return' => '<hr style="clear:both">
Palaa sivulle <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorNavigation-en.png|401px|]]
|-
| Kuvakaappaus uudesta navigaatiokäyttöliittymästä. <small>[[Media:VectorNavigation-en.png|(suurenna)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorEditorBasic-en.png|401px|]]
|-
| Kuvakaappaus sivujen muokkauskäyttöliittymästä. <small>[[Media:VectorEditorBasic-en.png|(suurenna)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[File:VectorLinkDialog-en.png|401px|]]
|-
| Kuvakaappaus uudesta linkkien lisäys -valintaikkunasta.
|}
|}
Wikimedia Foundationin käyttäjäkokemusryhmä on työskennellyt yhteisön vapaaehtoisten kanssa tehdäkseen asioista helpompia. Haluamme kertoa eräistä uudistuksista, kuten uudesta ilmeestä ja yksinkertaisemmista muokkaustoiminnoista. Näiden muutoksien tarkoituksena on auttaa uusia muokkaajia pääsemään helpommin alkuun. Muutokset perustuvat [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study viime vuoden aikana toteutettuun käytettävyystestaukseen]. Hankkeiden käytettävyyden parantaminen kuuluu Wikimedia Foundationin merkittävimpiin tehtäviin, ja lisää päivityksiä on tulossa. Lisätietoja saat aiheeseen liittyvästä Wikimedian [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ blogiviestistä].

=== Tässä tehtyjä muutoksia ===
* '''Navigaatio:''' Liikkumista on parannettu sivujen lukemisen ja muokkaamisen yhteydessä. Sivujen yläreunassa olevat välilehdet ovat nyt selvempiä.
* '''Muokkauspalkin parannukset:''' Muokkauspalkki on järjestetty uudelleen, jotta sitä olisi helpompi käyttää. Sivujen muotoilu on nyt yksinkertaisempaa ja havainnollisempaa.
* '''Ohjattu linkkitoiminto:''' Helppokäyttöinen työkalu mahdollistaa muille wikisivuille ja ulkoisille sivustoille vievien linkkien lisäämisen.
* '''Hakuparannukset:''' Hakuehdotuksia on parannettu, jotta sivut löytyisivät nopeammin.
* '''Muut uudet toiminnot:''' Taulukoiden lisäämisen helpottamiseksi on tehty ohjattu taulukonlisäystoiminto. Uusi etsi ja korvaa -toiminto helpottaa muokkaamista.
* '''Wikipedian logo:''' Logoa on päivitetty. Lue lisää [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedian blogista].",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}}-välilehti''' on nyt tähti.
* '''{{int:move}}-välilehti''' on nyt pudotusvalikossa hakupalkin vieressä.",
	'prefswitch-main-feedback' => '=== Palautetta? ===
Otamme mielellämme palautetta vastaan. Käy [[$1|palautesivulla]], tai jos olet kiinnostunut jatkuvasta ohjelmistokehityksestämme, katso lisätietoja [http://usability.wikimedia.org/ käytettävyyswikistä].',
	'prefswitch-main-anon' => '=== Palaa vanhaan versioon ===
[$1 Poista uudet ominaisuudet käytöstä napsauttamalla tästä]. Sinua pyydetään ensin kirjautumaan sisään tai luomaan tunnus.',
	'prefswitch-main-on' => '=== Palaa vanhaan versioon ===
[$2 Poista uudet ominaisuudet käytöstä napsauttamalla tästä].',
	'prefswitch-main-off' => '=== Kokeile ominaisuuksia ===
[$1 Napsauta tästä, jos haluat ottaa uudet ominaisuudet käyttöön].',
	'prefswitch-survey-intro-feedback' => 'Otamme mielellämme palautetta vastaan.
Täytä alla oleva valinnainen kysely ennen kuin napsautat ”[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]”.',
	'prefswitch-survey-intro-off' => 'Kiitos, kun kokeilit uusia ominaisuuksia.
Auttaaksesi parantamaan niitä – täytä alla oleva valinnainen kysely ennen kuin napsautat ”[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]”.',
	'prefswitch-feedbackpage' => 'Project:Käyttäjäkokemuspalaute',
);

/** French (Français)
 * @author AdiJapan
 * @author IAlex
 * @author Jean-Frédéric
 * @author Lucyin
 * @author Peter17
 * @author Urhixidur
 */
$messages['fr'] = array(
	'prefswitch' => "Commutateur de préférences de l'initiative d'utilisabilité",
	'prefswitch-desc' => 'Permet aux utilisateurs de modifier des ensembles de préférences',
	'prefswitch-link-anon' => 'Nouvelles fonctionnalités',
	'tooltip-pt-prefswitch-link-anon' => 'En savoir plus sur les nouvelles fonctionnalités',
	'prefswitch-link-on' => 'Retour',
	'tooltip-pt-prefswitch-link-on' => 'Désactiver les nouvelles fonctionnalités',
	'prefswitch-link-off' => 'Nouvelles fonctionnalités',
	'tooltip-pt-prefswitch-link-off' => 'Essayer les nouvelles fonctionnalités',
	'prefswitch-jswarning' => 'Veuillez noter que suite au changement d’apparence, votre [[User:$1/$2.js|JavaScript $2]] doit être copié vers [[User:$1/vector.js]] ou [[User:$1/common.js]] pour pouvoir continuer à fonctionner.',
	'prefswitch-csswarning' => 'Votre [[User:$1/$2.css|style personnalisé $2]] ne sera plus appliqué. Vous pouvez définir un CSS personnalisé pour Vector dans [[User:$1/vector.css]].',
	'prefswitch-survey-true' => 'Oui',
	'prefswitch-survey-false' => 'Non',
	'prefswitch-survey-submit-off' => 'Désactiver les nouvelles fonctionnalités',
	'prefswitch-survey-cancel-off' => 'Si vous voulez continuer à utiliser les nouvelles fonctionnalités, vous pouvez revenir à $1',
	'prefswitch-survey-submit-feedback' => 'Envoyer des commentaires',
	'prefswitch-survey-cancel-feedback' => 'Si vous ne voulez pas faire de commentaires, vous pouvez revenir à $1.',
	'prefswitch-survey-question-like' => "Qu'avez-vous apprécié dans les nouvelles fonctionnalités ?",
	'prefswitch-survey-question-dislike' => "Qu'est-ce que vous n'avez pas apprécié dans les fonctionnalités ?",
	'prefswitch-survey-question-whyoff' => 'Pourquoi voulez-vous désactiver les nouvelles fonctionnalités ?
Veuillez choisir tout ce qui convient.',
	'prefswitch-survey-question-globaloff' => 'Voulez-vous désactiver ces fonctionnalités globalement ?',
	'prefswitch-survey-answer-whyoff-hard' => 'Il était trop difficile de les utiliser.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Ça ne fonctionne pas correctement.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Cela ne s’est pas passé comme prévu.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Je n’ai pas aimé leur apparence.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Je n’ai pas aimé les nouveaux onglets et la nouvelle disposition.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Je n’ai pas aimé la nouvelle barre d’outils.',
	'prefswitch-survey-answer-whyoff-other' => 'Autre raison :',
	'prefswitch-survey-question-browser' => 'Quel navigateur utilisez-vous ?',
	'prefswitch-survey-answer-browser-other' => 'Autre navigateur :',
	'prefswitch-survey-question-os' => 'Quel système d’exploitation utilisez-vous ?',
	'prefswitch-survey-answer-os-other' => 'Autre système d’exploitation :',
	'prefswitch-survey-answer-globaloff-yes' => 'Oui, les désactiver sur tous les wikis',
	'prefswitch-survey-question-res' => 'Quelle est la résolution de votre écran ?',
	'prefswitch-title-on' => '',
	'prefswitch-title-switched-on' => 'Savourez !',
	'prefswitch-title-off' => 'Désactiver les nouvelles fonctionnalités',
	'prefswitch-title-switched-off' => 'Merci',
	'prefswitch-title-feedback' => 'Réaction',
	'prefswitch-success-on' => 'Les nouvelles fonctionnalités sont maintenant activées. Nous espérons que vous les apprécierez. Vous pouvez toujours faire marche arrière en cliquant sur le lien « [[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]] » en haut de la page.',
	'prefswitch-success-off' => 'Les nouvelles fonctionnalités sont maintenant désactivées. Merci de les avoir essayées. Vous pouvez toujours les ré-activer en cliquant sur le lien « [[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]] » en haut de la page.',
	'prefswitch-success-feedback' => 'Vos commentaires ont été envoyés.',
	'prefswitch-return' => '<hr style="clear:both">
Revenir à <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-fr.png|401px|]]
|-
| Capture d’écran de la nouvelle interface de navigation de Wikipédia <small>[[Media:VectorNavigation-fr.png|(agrandir)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-fr.png|401px|]]
|-
| Capture d’écran de l’interface simple de modification de page <small>[[Media:VectorEditorBasic-fr.png|(agrandir)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
|[[Image:UsabilityDialogs-fr.png|401px|]]
|-
| Capture d’écran de la nouvelle boîte de dialogue pour insérer des liens
|}
|}
L’équipe Expérience utilisateur de la Fondation Wikimedia (''User Experience Team'') a travaillé en collaboration avec des volontaires de la communauté pour vous rendre les choses plus simples. Nous sommes heureux de partager avec vous ces améliorations, notamment une nouvelle apparence et une simplification des fonctions de modification. Ces changements sont effectués pour que les nouveaux contributeurs puissent débuter plus facilement, et ils sont basés sur nos [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study tests utilisateurs menés l’année passée]. Améliorer l’utilisabilité de nos projets est une priorité de la Fondation Wikimédia, et nous vous ferons part de nos futures avancées. Pour plus de détails, veuillez consulter le [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia billet de blogue Wikimédia].

=== Les nouveautés ===

* '''Navigation :''' nous avons amélioré la navigation pour la lecture et la modification des pages. Maintenant, les onglets en haut de chaque page définissent plus clairement si vous voyez la page ou la page de discussion, et si vous consultez ou modifiez une page.
* '''Améliorations de la barre d’outils de modification :''' nous avons réorganisé la barre d’outils de modification pour la rendre plus facile à utiliser. Maintenant, la mise en page est plus simple et plus intuitive.
* '''Assistant de liens :''' un outil simple pour vous permettre d’ajouter des liens vers d’autres pages de wikis ainsi que des liens vers des sites externes.
* '''Amélioration de la recherche :''' nous avons amélioré les suggestions de recherche pour vous aider à trouver la page que vous recherchez plus rapidement.
* '''Autres fonctionnalités nouvelles :''' nous avons également introduit un assistant de tableaux pour créer des tableaux plus facilement et une fonctionnalité de remplacement pour simplifier la modification de page.
* '''Logo Wikipédia''': nous avons mis à jour notre logo. Pour en savoir plus, consultez le [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blogue de Wikimedia].",
	'prefswitch-main-logged-changes' => "* L’'''onglet {{int:watch}}''' est à présent une étoile.
* L’'''onglet {{int:move}}''' est à présent dans le menu déroulant à côté du champ de recherche.",
	'prefswitch-main-feedback' => '=== Retours d’expérience ===
Nous aimerions beaucoup avoir des retours de votre part. Veuillez vous rendre sur la [[$1|page de retours d’expérience]] ou bien, si vous êtes intéressés par nos efforts continus pour améliorer le logiciel, visitez notre [http://usability.wikimedia.org wiki utilisabilité] pour plus d’informations.',
	'prefswitch-main-anon' => "===C'était mieux avant===
Si vous souhaitez désactiver les nouvelles fonctionnalités, [$1 cliquez ici].  Il vous sera demandé de vous connecter ou de vous créer un compte.",
	'prefswitch-main-on' => '=== Sortez-moi de là ! ===
[$2 Cliquez ici pour désactiver les nouvelles fonctionnalités].',
	'prefswitch-main-off' => '=== Essayez-les ! ===
Si vous souhaitez activer les nouvelles fonctionnalités, veuillez [$1 cliquer ici].',
	'prefswitch-survey-intro-feedback' => 'Nous aimerions connaître vos impressions.
Si vous le désirez, vous pouvez remplir le sondage ci-dessous avant de cliquer sur « [[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]] ».',
	'prefswitch-survey-intro-off' => "Merci d'avoir essayé nos nouvelles fonctionnalités.
Pour nous aider à les améliorer, vous pouvez remplir le sondage optionnel ci-dessous avant de cliquer sur « [[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]] ».",
	'prefswitch-feedbackpage' => "Project:Retours d'expérience sur l'utilisabilité",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'prefswitch' => 'Boton de prèferences de l’iniciativa d’utilisabilitât',
	'prefswitch-desc' => 'Pèrmèt ux utilisators de changiér des ensemblos de prèferences.',
	'prefswitch-link-anon' => 'Novèles fonccionalitâts',
	'tooltip-pt-prefswitch-link-anon' => 'Nen savêr més sur les novèles fonccionalitâts',
	'prefswitch-link-on' => 'Retôrn',
	'tooltip-pt-prefswitch-link-on' => 'Dèsactivar les novèles fonccionalitâts',
	'prefswitch-link-off' => 'Novèles fonccionalitâts',
	'tooltip-pt-prefswitch-link-off' => 'Èprovar les novèles fonccionalitâts',
	'prefswitch-jswarning' => 'Volyéd notar que suita u changement d’habelyâjo, voutron code [[User:$1/$2.js|JavaScript $2]] dêt étre copiyê vers [[{{ns:user}}:$1/vector.js]] <!-- ou ben [[{{ns:user}}:$1/common.js]]--> por povêr continuar a fonccionar.',
	'prefswitch-csswarning' => 'Voutron [[User:$1/$2.css|stilo pèrsonalisâ $2]] serat pas més aplicâ. Vos pouede dèfenir un CSS pèrsonalisâ por « Vèctor » dens [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ouè',
	'prefswitch-survey-false' => 'Nan',
	'prefswitch-survey-submit-off' => 'Dèsactivar les novèles fonccionalitâts',
	'prefswitch-survey-cancel-off' => 'Se vos voléd continuar a utilisar les novèles fonccionalitâts, vos pouede tornar a $1.',
	'prefswitch-survey-submit-feedback' => 'Balyéd voutron avis',
	'prefswitch-survey-cancel-feedback' => 'Se vos voléd pas balyér voutron avis, vos pouede tornar a $1.',
	'prefswitch-survey-question-like' => 'Qu’est-o que vos éd amâ dens les novèles fonccionalitâts ?',
	'prefswitch-survey-question-dislike' => 'Qu’est-o que vos éd pas amâ dens les fonccionalitâts ?',
	'prefswitch-survey-question-whyoff' => 'Porquè voléd-vos dèsactivar les novèles fonccionalitâts ?
Volyéd chouèsir tot cen que convint.',
	'prefswitch-survey-answer-whyoff-hard' => 'O ére trop mâlésiê de l’utilisar.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Cen fonccione pas bien.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Cen s’est pas passâ coment prèvu.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'J’é pas amâ son aparence.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'J’é pas amâ les ongllètes novèles et la misa en pâge.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'J’é pas amâ la bârra d’outils novèla.',
	'prefswitch-survey-answer-whyoff-other' => 'Ôtra rêson :',
	'prefswitch-survey-question-browser' => 'Quint navigator utilisâd-vos ?',
	'prefswitch-survey-answer-browser-other' => 'Ôtro navigator :',
	'prefswitch-survey-question-os' => 'Quint sistèmo d’èxplouètacion utilisâd-vos ?',
	'prefswitch-survey-answer-os-other' => 'Ôtro sistèmo d’èxplouètacion :',
	'prefswitch-survey-question-res' => 'Quinta est la rèsolucion de voutron ècran ?',
	'prefswitch-title-on' => 'Novèles fonccionalitâts',
	'prefswitch-title-switched-on' => 'Savorâd !',
	'prefswitch-title-off' => 'Dèsactivar les novèles fonccionalitâts',
	'prefswitch-title-switched-off' => 'Grant-marci',
	'prefswitch-title-feedback' => 'Avis',
	'prefswitch-success-on' => 'Ora, les novèles fonccionalitâts sont activâs. Nos èsperens que vos les aprèciyeréd. Vos pouede adés tornar arriér en cliquent sur lo lim « [[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]] » d’amont la pâge.',
	'prefswitch-success-off' => 'Ora, les novèles fonccionalitâts sont dèsactivâs. Grant-marci de les avêr èprovâs. Vos les pouede adés reactivar en cliquent sur lo lim « [[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]] » d’amont la pâge.',
	'prefswitch-success-feedback' => 'Voutros avis ont étâ mandâs.',
	'prefswitch-return' => '<hr style="clear:both">
Tornar a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main-logged-changes' => "* L’'''ongllèta « {{int:watch}} »''' est ora una ètêla.
* L’'''ongllèta « {{int:move}} »''' est ora dens lo menu dèroulant a coutâ du champ de rechèrche.",
	'prefswitch-main-feedback' => '===Avis d’èxpèrience ?===
Nos amerians cognetre voutros avis. Volyéd visitar la [[$1|pâge d’avis]] ou ben, se vos éte entèrèssiês per noutros èfôrts continus por mèlyorar la programeria, visitâd noutron [http://usability.wikimedia.org vouiqui utilisabilitât] por més d’enformacions.',
	'prefswitch-main-anon' => '===O ére mielx devant===
[$1 Clicâd ique por dèsactivar les novèles fonccionalitâts]. Vos serat demandâ de vos branchiér ou ben de vos fâre un compto.',
	'prefswitch-main-on' => '===Sortéd-mè d’ique !===
[$2 Clicâd ique por dèsactivar les novèles fonccionalitâts].',
	'prefswitch-main-off' => '===Èprovâd-les !===
[$1 Clicâd ique por activar les novèles fonccionalitâts].',
	'prefswitch-survey-intro-feedback' => 'Nos amerians cognetre voutros avis.
Volyéd remplir lo quèstionèro u chouèx ce-desot devant que clicar dessus « [[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]] ».',
	'prefswitch-survey-intro-off' => 'Grant-marci d’èprovar noutres novèles fonccionalitâts.
Por nos édiér a les mèlyorar, volyéd remplir lo quèstionèro u chouèx ce-desot devant que clicar dessus « [[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]] ».',
	'prefswitch-feedbackpage' => 'Project:Avis d’èxpèrience sur l’utilisabilitât',
);

/** Scottish Gaelic (Gàidhlig)
 * @author Akerbeltz
 */
$messages['gd'] = array(
	'prefswitch' => 'Suids Iomairt na So-chleachdachd',
	'prefswitch-desc' => 'Leig leis na cleachdaichean suids a dhèanamh eadar seataichean de roghainnean',
	'prefswitch-link-anon' => 'Feartan ùra',
	'tooltip-pt-prefswitch-link-anon' => 'Barrachd mu na feartan ùra',
	'prefswitch-link-on' => 'Air ais leam',
	'tooltip-pt-prefswitch-link-on' => 'Cuir na feartan ùra à comas',
	'prefswitch-link-off' => 'Feartan ùra',
	'tooltip-pt-prefswitch-link-off' => 'Feuch na feartan ùra',
	'prefswitch-jswarning' => "Cuimhnich gum bi agad lethbhreac a dhèanamh dhen [[User:$1/$2.js|$2 JavaScript]] agad gu [[{{ns:user}}:$1/vector.js]] <!-- no [[{{ns:user}}:$1/common.js]]--> ma dh'atharraicheas tu a' chraiceann mus urrainn dhut leantainn ort le d' obair-dheasachaidh.",
	'prefswitch-csswarning' => "Cha bhi na [[User:$1/$2.css|custom $2 styles]] agad beò tuilleadh. 'S urrainn dhut CSS gnàthaichte airson Vector a chur ris ann an [[{{ns:user}}:$1/vector.css]].",
	'prefswitch-survey-true' => 'Tha',
	'prefswitch-survey-false' => 'Chan eil',
	'prefswitch-survey-submit-off' => 'Cuir na feartan ùra dheth',
	'prefswitch-survey-cancel-off' => "Ma tha thu airson leantainn ort leis na feartan ùra, 's urrainn dhut tilleadh a $1.",
	'prefswitch-survey-submit-feedback' => 'Cuir thugainn do bheachdan',
	'prefswitch-survey-cancel-feedback' => "Mur eil thu airson do bheachdan innse dhuinn, 's urrainn dhut tilleadh a $1.",
	'prefswitch-survey-question-like' => "Dè bha a' còrdadh riut sna feartan ùra?",
	'prefswitch-survey-question-dislike' => "Dè nach robh a' còrdadh riut sna feartan ùra?",
	'prefswitch-survey-question-whyoff' => "Carson a tha thu a' cur dheth dheth nam feartan ùra?
Tagh gach adhbhar a tha fìor.",
	'prefswitch-survey-answer-whyoff-hard' => 'Bha na feartan ùra ro dhoirbh ri an cleachdadh.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Cha robh na feartan ùra ag obair mar bu chòir.',
	'prefswitch-survey-answer-whyoff-notpredictable' => "Cha robh na feartan ùra a' dèanamh mar a bha dùil.",
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Cha bu toigh leam coltas nam feartan ùra.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "Cha bu toigh leam na tabaichean ùra 's an coltas ùr.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Cha bu toigh leam am bàr-inneil ùr.',
	'prefswitch-survey-answer-whyoff-other' => 'Adhbhar eile:',
	'prefswitch-survey-question-browser' => "Dè am brabhsair a bha thu a' cleachdadh?",
	'prefswitch-survey-answer-browser-other' => 'Brabhsair eile:',
	'prefswitch-survey-question-os' => "Dè an siostam-obrachaidh a bhios tu a' cleachdadh?",
	'prefswitch-survey-answer-os-other' => 'Siostam-obrachaidh eile:',
	'prefswitch-survey-question-res' => 'Dè an dùmhlachd-bhreacaidh a tha aig an sgrìn agad?',
	'prefswitch-title-on' => 'Feartan ùra',
	'prefswitch-title-switched-on' => 'Gabh tlachd ann!',
	'prefswitch-title-off' => 'Cuir na feartan ùra dheth',
	'prefswitch-title-switched-off' => 'Gun robh math agad',
	'prefswitch-title-feedback' => 'Dè do bheachd?',
	'prefswitch-success-on' => 'Tha na feartan ùra air a-nis. Tha sinn an dòchas gun gabh thu tlachd annta. \'S urrainn dhut an cur dheth ma bhriogas tu air a\' cheangal "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" aig barr na duilleige.',
	'prefswitch-success-off' => 'Tha na feartan ùra dheth a-nis. Gun robh math agad airson feuchainn riutha. \'S urrainn dhut an cur air a-rithist ma bhriogas tu air a\' cheangal "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" aig barr na duilleige.',
	'prefswitch-success-feedback' => 'Chaidh do bheachdan a chur thugainn.',
	'prefswitch-return' => '<hr style="clear:both">
Till a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Dealbh-sgrìn dhen eadar-aghaidh seòlaidh ùr aig Wikipedia <small>[[Media:VectorNavigation-en.png|(meudaich)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Dealbh-sgrìn de dh'eadar-aghaidh bhunaiteach airson deasachadh dhuilleagan <small>[[Media:VectorEditorBasic-en.png|(meudaich)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Dealbh-sgrìn dhen bhogsa chonaltraidh ùr a chum ceanglaichean a chur a-steach
|}
|}
Dh'obair sgioba leas nan cleachdaichean aig Fonndas Wikimedia còmhla ri saor-thoilich na coimhearsnachd gus rudan a dhèanamh nas fhasa dhut. Tha sinn fìor thoilichte gun urrainn dhuinn grunn leasachaidhean a thoirt dhut a-nis, a' gabhail a-steach coltas ùr air agus feartan deasachaidh nas simplidhe. Chruthaich sinn iad gum bi e nas fhasa do luchd-deasachaidh ùr pàirt a ghabhail ann 's tha iad stèidhichte air an [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study rannsachadh a rinn sinn air so-chleachdadh an-uraidh]. Tha e 'na phrìomhachas dhuinne aig Fonndas Wikimedia piseach a thoirt air so-chleachdachd nam pròiseactan againn agus cuiridh sinn leasachaidhean eile ri do làimh san àm ri teachd. Airson barrachd fiosrachaidh, briog air [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia post a' bhloga] Wikimedia mun chuspair seo.

=== Seo na dh'atharraich sinn ===
* '''An seòladh:''' Tha an seòladh nas fhearr a-nis airson duilleagan a leughadh 's a dheasachadh. Tha na tabaichean aig barr gach duilleige a' cur an cèill nas soilleire a-nis a bheil thu a' coimhead air an duilleag fhèin no duilleag na deasbaireachd 's a bheil thu a' leughadh no a' deasachadh duilleag.
* '''Leasachadh air bàr-inneil an deasachaidh:''' Chuir sinn cruth ùr air bàr-inneil an deasachaidh gus am bi e nas fhasa ri chleachdadh. Tha fòrmatadh nan duilleagan nas simplidhe 's nas ciallaiche a-nis.
* '''Draoidh nan ceangal:''' Gleus a tha furasta ri chleachdadh leis an urrainn dhut ceanglaichean a chur a-steach ri duilleagan wiki eile no ri làraichean air an taobh a-muigh.
* '''Leasachadh an luirg:''' Leasaich sinn na molaidhean luirg gus am faigh thu an duilleag a tha a dhìth ort nas luaithe.
* '''Feartan ùra eile:''' Chuir sinn an sàs draoidh nan clàr cuideachd gus am bi cruthachadh chlàr nas fhasa agus feart airson rud eile a chur an àite dàrna rud gus deasachadh dhuilleagan a dhèanamh nas fhasa.
* '''Suaicheantas Wikipedia:''' Dh'ùraich sinn an suaicheantas againn. Leugh barrachd mu dhèidhinn ann am [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d bloga Wikimedia].",
	'prefswitch-main-logged-changes' => "* Tha an taba '''{{int:watch}}''' 'na rionnag a-nis.
* Tha an taba '''{{int:move}}''' sa chlàr-taice tuiteamach ri taobh a' bhàir-luirg a-nis.",
	'prefswitch-main-feedback' => "===Beachdan?===
B' fhìor thoigh leinn cluinntinn uat. Tadhail air [[$1|làrach nam beachdan]] againn no, ma tha ùidh agad 'nar n-iomairt bhuan gus piseach a thoirt air a' bhathar-bhog, tadhail air [http://usability.wikimedia.org wiki na so-chleachdachd] againn airson barrachd fiosrachaidh.",
	'prefswitch-main-anon' => '===Air ais leam===
[$1 Briog an-seo gus na feartan ùra a chur dheth]. Iarrar ort logadh a-steach no cunntas a chruthachadh an toiseach.',
	'prefswitch-main-on' => '===Air ais leam!===
[$2 Briog an-seo gus na feartan ùra a chur dheth].',
	'prefswitch-main-off' => '===Feuch riutha!===
[$1 Briog an-seo gus na feartan ùra a chur an comas].',
	'prefswitch-survey-intro-feedback' => 'B\' fhìor thoigh leinn cluinntinn uat.
Nach lìon thu a-steach an t-suirbhidh shaor-thoileach gu h-ìosal mus briog thu air "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]"?',
	'prefswitch-survey-intro-off' => 'Gun robh math agad airson nam feartan ùra againn fheuchainn.
Nach cuidich thu sinn \'s tu a\' lìonadh a-steach an t-suirbhidh shaor-thoileach gu h-ìosal mus briog thu air "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"?',
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'prefswitch' => 'Conmutador de preferencias da Iniciativa de usabilidade',
	'prefswitch-desc' => 'Permitir aos usuarios cambiar conxuntos de preferencias',
	'prefswitch-link-anon' => 'Novas características',
	'tooltip-pt-prefswitch-link-anon' => 'Máis información sobre as novas características',
	'prefswitch-link-on' => 'Volver atrás',
	'tooltip-pt-prefswitch-link-on' => 'Desactivar as novas características',
	'prefswitch-link-off' => 'Novas características',
	'tooltip-pt-prefswitch-link-off' => 'Probar as novas características',
	'prefswitch-jswarning' => 'Lembre que co cambio de aparencia terá que copiar o seu [[User:$1/$2.js|JavaScript $2]] en [[{{ns:user}}:$1/vector.js]] <!-- ou [[{{ns:user}}:$1/common.js]] --> para que continúe funcionando.',
	'prefswitch-csswarning' => 'Os seus [[User:$1/$2.css|estilos personalizados $2]] xa non funcionarán. Pode engadir CSS personalizado para a aparencia vector en [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Si',
	'prefswitch-survey-false' => 'Non',
	'prefswitch-survey-submit-off' => 'Desactivar as novas características',
	'prefswitch-survey-cancel-off' => 'Se quere seguir usando as novas características, pode volver a "$1".',
	'prefswitch-survey-submit-feedback' => 'Dea a súa opinión',
	'prefswitch-survey-cancel-feedback' => 'Se non quere dar a súa opinión, pode volver a "$1".',
	'prefswitch-survey-question-like' => 'Que é o que lle gustou das novas características?',
	'prefswitch-survey-question-dislike' => 'Que é o que non lle gustou das novas características?',
	'prefswitch-survey-question-whyoff' => 'Por que está a desactivar as novas características?
Por favor, seleccione o que sexa conveniente.',
	'prefswitch-survey-question-globaloff' => 'Quere desactivar as características de xeito global?',
	'prefswitch-survey-answer-whyoff-hard' => 'Foi moi difícil de usar.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Non funcionou correctamente.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Non funcionou de modo predicible.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Non me gustou o seu aspecto.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Non me gustaron as novas lapelas e a distribución.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Non me gustou a nova barra de ferramentas.',
	'prefswitch-survey-answer-whyoff-other' => 'Outro motivo:',
	'prefswitch-survey-question-browser' => 'Que navegador usa?',
	'prefswitch-survey-answer-browser-ffb' => 'Firefox Beta',
	'prefswitch-survey-answer-browser-cd' => 'Google Chrome Dev',
	'prefswitch-survey-answer-browser-other' => 'Outro navegador:',
	'prefswitch-survey-question-os' => 'Que sistema operativo usa?',
	'prefswitch-survey-answer-os-other' => 'Outro sistema operativo:',
	'prefswitch-survey-answer-globaloff-yes' => 'Si, desactivar as características en todos os wikis',
	'prefswitch-survey-question-res' => 'Cal é a resolución da súa pantalla?',
	'prefswitch-title-on' => 'Novas características',
	'prefswitch-title-switched-on' => 'Páseo ben!',
	'prefswitch-title-off' => 'Desactivar as novas características',
	'prefswitch-title-switched-off' => 'Grazas',
	'prefswitch-title-feedback' => 'Opinión',
	'prefswitch-success-on' => 'As novas características están agora activadas. Agardamos que lle gusten. Pode desactivalas premendo sobre a ligazón "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" que aparecerá no canto superior de calquera páxina.',
	'prefswitch-success-off' => 'As novas características están agora desactivadas. Grazas por probalas. Pode activalas de novo premendo sobre a ligazón "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" que aparecerá no canto superior de calquera páxina.',
	'prefswitch-success-feedback' => 'Enviouse a súa opinión.',
	'prefswitch-return' => '<hr style="clear:both">
Volver a "<span class="plainlinks">[$1 $2]</span>".',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Captura de pantalla da nova interface de navegación da Wikipedia <small>[[Media:VectorNavigation-en.png|(ampliar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Captura de pantalla da interface de edición básica <small>[[Media:VectorEditorBasic-en.png|(ampliar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Captura de pantalla dos novos diálogos de xeración de ligazóns
|}
|}
O equipo de experiencia de usuario da Fundación Wikimedia traballou arreo con voluntarios da comunidade para facerlles as cousas máis doadas aos usuarios. Estamos encantados de compartir algunhas melloras, incluíndo entre elas unha nova aparencia e características de edición simplificadas. Estes cambios, derivados das nosas [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study probas de usabilidade feitas durante o ano pasado], teñen o obxectivo de facilitar as cousas aos novos colaboradores. A mellora da usabilidade dos nosos proxectos é unha prioridade para a Fundación Wikimedia e traeremos máis actualizacións no futuro. Para obter máis información, visite [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia esta entrada] do blogue da Wikimedia.

===Isto foi o que cambiamos===
* '''Navegación:''' melloramos a navegación para a lectura e edición de páxinas. Agora, as lapelas da parte superior de cada páxina definen máis claramente se está a ollar a páxina ou a conversa ou se está lendo ou editando a páxina.
* '''Melloras na barra de ferramentas de edición:''' fixemos unha reorganización da barra de ferramentas de edición para facer máis doado o seu uso. Agora, dar formato ás páxinas é máis sinxelo e intuitivo.
* '''Asistente para as ligazóns:''' trátase dunha simple ferramenta que permite engadir ligazóns cara a outras páxinas da Wikipedia, así como ligazóns a sitios web externos.
* '''Melloras nas procuras:''' melloramos as suxestións de busca para que dea coa páxina que está a procurar máis rapidamente.
* '''Outras novas características:''' tamén introducimos un asistente para as táboas, que fai a creación de táboas máis fácil, e unha característica para atopar e substituír elementos, que simplifica a edición da páxina.
* '''O logo da Wikipedia:''' tamén actualizamos o noso logo. Máis información no [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blogue da Wikimedia].",
	'prefswitch-main-logged-changes' => "* A '''lapela \"{{int:watch}}\"''' é agora unha estrela.
* A '''lapela \"{{int:move}}\"''' está agora no menú despregable ao carón da barra de procuras.",
	'prefswitch-main-feedback' => '===Opinións?===
Gustaríanos saber o que lle parece. Visite a nosa [[$1|páxina de comentarios]] ou o noso [http://usability.wikimedia.org wiki de usabilidade] se o que quere é involucrarse na mellora do software.',
	'prefswitch-main-anon' => '===Volver atrás===
Se quere desactivar as novas características, [$1 prema aquí]. Pediráselle que primeiro acceda ao sistema ou que cree unha conta.',
	'prefswitch-main-on' => '===Quero volver!===
[$2 Prema aquí se quere desactivar as novas características].',
	'prefswitch-main-off' => '===Próbeas!===
Se quere activar as novas características, [$1 prema aquí].',
	'prefswitch-survey-intro-feedback' => 'Gustaríanos saber o que lle parece.
Por favor, encha a enquisa opcional que aparece a continuación antes de premer en "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Grazas por probar as novas características.
Para axudarnos a melloralas, encha a enquisa opcional que aparece a continuación antes de premer en "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Comentarios dos usuarios',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'prefswitch' => 'Umschalter fir d Yystellige fir d Benutzerfrejndligkeits-Initiative',
	'prefswitch-desc' => 'Benutzer s Umschalte zwische verschidene Yystelligs-Sätsz erlaube',
	'prefswitch-link-anon' => 'Neji Funktione',
	'tooltip-pt-prefswitch-link-anon' => 'Meh erfahre iber di neje Funktione',
	'prefswitch-link-on' => 'Zruck',
	'tooltip-pt-prefswitch-link-on' => 'Di neje Funktione abschalte',
	'prefswitch-link-off' => 'Neji Funktione',
	'tooltip-pt-prefswitch-link-off' => 'Di neje Funktione uusprobiere',
	'prefswitch-jswarning' => 'Dänk draa, ass noch em Wägsel vu dr Oberflechi Dyy [[User:$1/$2.js|$2 JavaScript]] in [[{{ns:user}}:$1/vector.js]] kopiert wäre mueß <!-- oder [[{{ns:user}}:$1/common.js]]--> zum Wyterschaffe.',
	'prefswitch-csswarning' => 'Dyyni [[User:$1/$2.css|aapasste $2 Style]] sin nit lenger aktiv. Du chasch dr CSS-Style fir Vector iberneh in [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Jo',
	'prefswitch-survey-false' => 'Nei',
	'prefswitch-survey-submit-off' => 'Neji Funktione abschalte',
	'prefswitch-survey-cancel-off' => 'Wänn di neje Funktione wyter bruche witt, chasch zu $1 zruckgoh.',
	'prefswitch-survey-submit-feedback' => 'Ruckmäldig gee',
	'prefswitch-survey-cancel-feedback' => 'Wänn kei Ruckmäldig witt gee, chasch zue $1 zruckgoh.',
	'prefswitch-survey-question-like' => 'Was het Dir an dr neje Funktione gfalle?',
	'prefswitch-survey-question-dislike' => 'Was het Dir an dr neje Funktione nit gfalle?',
	'prefswitch-survey-question-whyoff' => 'Wurum schaltsch di neje Funktione ab?
Bitte wehl alli Pinkt, wu zuedräffe uus.',
	'prefswitch-survey-question-globaloff' => 'Witt di neje Funktione wältwyt abschalte?',
	'prefswitch-survey-answer-whyoff-hard' => 'D Verwändig isch z schwirig gsi.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Si het nit rächt funktioniert.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'S het nit eso funktioniert, wie s gheisse het.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Mir het s nit gfalle, wie s uussiht.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Mir gfalle di neje Tabs un s Layout nit.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Mir gfallt s nej Wärchzygchäschtli nit.',
	'prefswitch-survey-answer-whyoff-other' => 'Andere Grund:',
	'prefswitch-survey-question-browser' => 'Wele Browser bruchsch Du?',
	'prefswitch-survey-answer-browser-other' => 'Andere Browser:',
	'prefswitch-survey-question-os' => 'Wel Betribssyschtem bruchsch Du?',
	'prefswitch-survey-answer-os-other' => 'Anders Betribssyschtem:',
	'prefswitch-survey-answer-globaloff-yes' => 'Jo, di neje Funktione uf allene Wiki abschalte',
	'prefswitch-survey-question-res' => 'Was fir e Uflesig het Dyy Bildschirm?',
	'prefswitch-title-on' => 'Neji Funktione',
	'prefswitch-title-switched-on' => 'Vil Spaß!',
	'prefswitch-title-off' => 'Neji Funktione abschalte',
	'prefswitch-title-switched-off' => 'Dankschen',
	'prefswitch-title-feedback' => 'Ruckmäldig',
	'prefswitch-success-on' => 'Di neje Funktione sin jetz yygschalte. Mir winsche Dir vil Freid dermit. Du chasch si jederzyt abschalte dur e Klick uf s Gleich „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]“ obe uf dr Websyte.',
	'prefswitch-success-off' => 'Di neje Funktione sin jetz abgschalte. Dankschen fir s Uusbrobiere. Du chasch si jederzyt wider aaschalte dur e Klick uf s Gleich „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]“ obe uf dr Websyte.',
	'prefswitch-success-feedback' => 'Dyy Ruckmäldig isch gschickt wore.',
	'prefswitch-return' => '<hr style="clear:both">
Zruck zue <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Di nej Navigation. <small>[[Media:VectorNavigation-en.png|(greßer)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Di nej Bearbeitisgoberflechi. <small>[[Media:VectorEditorBasic-en.png|(greßer)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px]]
|-
| Screeenshot vum neje Dialogchäschtli zum Gleicher (Link) yygee.
|}
|}

D Bruchbarkeits-Arbetsgruppe het mit Frejwillige vu dr Gmeinschaft dra gschafft, d Sache fir unsri Benutzer eifacher z mache. Mir freien is, ass mir e baar Verbesserige chenne aabiete, derzue e nej Uussäh un vereifachti Bearbeitigsfunktione.  Die Änderige solle s Aafange un Mitmache eifacher mache fir neji Mitarbeiter un basiere uf unsre [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study Benutzerfrejndligkeits-Teschtstudie], wu in dr letschte 12 Monet duzrgfiert woren isch.
D Benutzerfrejndligkeit verbessere het Prioritet bi dr Wikimedia Foundation un mir stelle in dr Zuechumpft meh Update z Verfiegig. Fir meh Informatione, kueg dr [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Wikimedia-Blog]-Yytrag.

===Des hän mer gänderet===
* '''Navigation:''' Mir hän d Navigation verbesseret zum Läse un Bearbeite vu Syte. Jetz gän d Ryter obe an dr Syte klarer aa, eb Du d Syte aaluegsch oder e Diskussionssyte, un eb Du am Läse oder am Bearbeite vu dr Syte bisch.
* '''Verbesserige vum Wärchzyygchäschtli:''' Mir hän s Wärchzyygchäschtli umorganisiert, ass es cha eifacher brucht wäre. Jetz isch s Formatiere eifacher un intuitiver.
* '''Gleichhilf:'''  E eifach Wärchzyyg, wu Dir s megli macht, Gleicher zue andere Wikipediasyte un zue extärne Syte.
* '''Verbesserige vu dr Suechi:''' Mir hän d Suechvorschleg verbesseret, ass Du schnäller uf die Syte chunnsch, wu Du suechsch.
* '''Anderi neji Funktione:'''  Mir hän au ne Tabällehilf yygfiert, wu s Aalege vu Tabälle eifacher macht, un e Hilf zum Sueche un Ersetze, wu s Bearbeite vu Syte eifacher macht.
* '''Wikipedia-Logo''': wir hän unser Logo nej gmacht, meh Informatione im [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Wikimedia-Blog.]",
	'prefswitch-main-logged-changes' => "* Dr Chnopf '''{{int:watch}}''' isch jetz e Stärn.
* Dr Chnopf '''{{int:move}}''' isch jetz e Dropdown-Menü näb em Suechchäschtli.",
	'prefswitch-main-feedback' => '=== Ruckmäldig? ===
Mir deeten is freie, vu Dir z here.
Bitte bsuech unseri [$1 Ruckmäldigs-Syte].',
	'prefswitch-main-anon' => '===Zruck===
Wänn Du di neje Funktione witt abschalte, no [$1 druck do]. Du wirsch derno bätte Di aazmälde oder zerscht e nej Benutzerkonto aazlege.',
	'prefswitch-main-on' => '=== Bring mi zruck! ===
Wänn Du di neje Funktione witt abschalte, [$2 druck do].',
	'prefswitch-main-off' => '=== Probier s uus! ===
Wänn Du di neje Funktione witt yyschalte, [$1 druck do].',
	'prefswitch-survey-intro-feedback' => 'Mir deeten is freie, vu Dir z here.
Bitte fill di frejwillig Umfrog uus, voreb Du uf „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]“ drucksch.',
	'prefswitch-survey-intro-off' => 'Dankschen fir s Uusprobiere vu unsre neje Funktione.
Ass mir no besser chenne wäre, fill bitte di frejwillig Umfrog uus, voreb Du uf „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]“ drucksch.',
	'prefswitch-feedbackpage' => 'Project:Benutzerfrejndligkeits-Initiative/Ruckmäldig',
);

/** Manx (Gaelg)
 * @author MacTire02
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'prefswitch' => 'Corrag hosheeaght Shalee Yn-ymmydaght',
	'prefswitch-link-anon' => 'Troyn as greieyn noa',
	'tooltip-pt-prefswitch-link-anon' => 'Geddyn fys bentyn rish troyn noa',
	'prefswitch-link-on' => 'Gow mee er-ash',
	'tooltip-pt-prefswitch-link-on' => 'Lhiettal troyn noa',
	'prefswitch-link-off' => 'Troyn as greieyn noa',
	'tooltip-pt-prefswitch-link-off' => 'Prowal troyn as greieyn noa',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'prefswitch-survey-answer-whyoff-other' => 'Wani dalili:',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'prefswitch' => 'שינוי העדפות במיזם השמישות',
	'prefswitch-desc' => 'הוספת אפשרות למשתמשים לשנות קבוצות של העדפות',
	'prefswitch-link-anon' => 'תכונות חדשות',
	'tooltip-pt-prefswitch-link-anon' => 'מידע נוסף על התכונות החדשות',
	'prefswitch-link-on' => 'החזירו אותי',
	'tooltip-pt-prefswitch-link-on' => 'ביטול התכונות החדשות',
	'prefswitch-link-off' => 'תכונות חדשות',
	'tooltip-pt-prefswitch-link-off' => 'לנסות תכונות חדשות',
	'prefswitch-jswarning' => 'יש לזכור כי עם שינוי העיצוב, יש להעתיק (או להעביר) את ה[[User:$1/$2.js|סקריפטים האישיים מהעיצוב $2]] לדף [[{{ns:user}}:$1/vector.js]] <!-- או [[{{ns:user}}:$1/common.js]] --> על מנת להמשיך להשתמש בהם.',
	'prefswitch-csswarning' => 'לא ייעשה שימוש ב[[User:$1/$2.css|סגנונות האישיים של העיצוב $2]]. ניתן להוסיף CSS מותאם אישית עבור העיצוב "וקטור" בדף [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'כן',
	'prefswitch-survey-false' => 'לא',
	'prefswitch-survey-submit-off' => 'ביטול המראה החדש',
	'prefswitch-survey-cancel-off' => 'אם תרצו להמשיך להשתמש בתכונות החדשות, באפשרותכם לחזור אל $1.',
	'prefswitch-survey-submit-feedback' => 'שליחת משוב',
	'prefswitch-survey-cancel-feedback' => 'אם אינכם רוצים לתת משוב, תוכלו לחזור אל $1.',
	'prefswitch-survey-question-like' => 'מה אהבתם בתכונות החדשות?',
	'prefswitch-survey-question-dislike' => 'מה לא אהבתם בתכונות החדשות?',
	'prefswitch-survey-question-whyoff' => 'למה אתם עוזבים את הגרסה החדשה?
אנא בחרו את כל האפשרויות המתאימות.',
	'prefswitch-survey-question-globaloff' => 'האם ברצונך לכבות את התכונות באופן כללי?',
	'prefswitch-survey-answer-whyoff-hard' => 'היא הייתה קשה מדי לשימוש.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'היא לא פעלה כראוי.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'היא פעלה באופן בלתי צפוי.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'לא אהבתי את המראה החדש.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'לא אהבתי את השינויים בלשוניות ובעיצוב.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'לא אהבתי את סרגל הכלים החדש.',
	'prefswitch-survey-answer-whyoff-other' => 'סיבה אחרת:',
	'prefswitch-survey-question-browser' => 'באיזה דפדפן אתם משתמשים?',
	'prefswitch-survey-answer-browser-other' => 'דפדפן אחר:',
	'prefswitch-survey-question-os' => 'באיזו מערכת הפעלה אתם משתמשים?',
	'prefswitch-survey-answer-os-other' => 'מערכת הפעלה אחרת:',
	'prefswitch-survey-answer-globaloff-yes' => 'כן, כיבוי התכונות בכול אתרי הוויקי',
	'prefswitch-survey-question-res' => 'מהי רזולוציית המסך שלכם?',
	'prefswitch-title-on' => 'תכונות חדשות',
	'prefswitch-title-switched-on' => 'תיהנו!',
	'prefswitch-title-off' => 'ביטול המראה החדש',
	'prefswitch-title-switched-off' => 'תודה',
	'prefswitch-title-feedback' => 'משוב',
	'prefswitch-success-on' => 'התכונות החדשות מופעלות עכשיו. אנו מקווים שתיהנו מהשימוש בהן. תוכלו לכבות אותן בכל עת על ידי לחיצה על הקישור [[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]] בראש הדף.',
	'prefswitch-success-off' => 'התכונות החדשות מבוטלות עכשיו. אנו מודים לכם על כך שניסיתם אותן. תוכלו להפעיל אותן מחדש בכל עת על ידי לחיצה על הקישור "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" בראש הדף.',
	'prefswitch-success-feedback' => 'המשוב שלכם נשלח.',
	'prefswitch-return' => '<hr style="clear:both">
חזרה אל <span class="plainlinks">[$1 $2].</span>',
	'prefswitch-main' => "{| border=\"0\" align=\"left\" style=\"margin-right:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| צילום מסך של ממשק הניווט החדש של ויקיפדיה <small>[[Media:VectorNavigation-en.png|(הגדלה)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| צילום מסך של ממשק עריכת הדף הבסיסי <small>[[Media:VectorEditorBasic-en.png|(הגדלה)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| צילום מסך של תיבת הדו שיח החדשה להוספת קישורים
|}
|}

צוות חוויית המשתמש של קרן ויקימדיה עבד עם מתנדבים מהקהילה כדי שיהיה לכם קל יותר. אנו נרגשים לשתף אתכם במספר שיפורים, בהם מראה חדש ויכולות עריכה פשוטות יותר. שינויים אלה מיועדים להקל על תורמים חדשים להתחיל, ומבוססים על [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study בדיקת השמישות שבוצעה לאורך השנה שעברה]. שיפור השימושיות במיזמי ויקימדיה הוא משימה בעלת עדיפות גבוהה עבור קרן ויקימדיה ואנחנו נשתף אתכם בעדכונים נוספים בעתיד. לפרטים נוספים, בקרו בהודעה בנושא ב[http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ בלוג של ויקימדיה] (באנגלית).

===להלן השינויים שבוצעו===
* '''ניווט''': שיפרנו את הניווט לצורך קריאה ועריכה של דפים. כעת, הלשוניות בראש כל דף מבהירות האם אתם צופים בדף או בדף שיחה, והאם אתם קוראים או עורכים אותו.
* '''שיפורים בסרגל העריכה''': סידרנו מחדש את סרגל העריכה כדי שיהיה קל יותר להשתמש בו. עיצוב הדפים הוא פשוט ואינטואיטיבי יותר כעת.
* '''אשף קישורים''': כלי קל לשימוש שמאפשר לכם להוסיף קישורים לדפים אחרים בוויקיפדיה וגם קישורים לאתרים חיצוניים.
* '''שיפורים בחיפוש''': שיפרנו את ההשלמות בתיבת החיפוש כדי שתמצאו את הדף שאותו אתם מחפשים מהר יותר.
* '''תכונות חדשות אחרות''': הוספנו גם אשף טבלאות כדי שיהיה קל יותר ליצור טבלאות, ויכולת חיפוש והחלפה כדי להקל על עריכת דפים.
* '''סמל ויקיפדיה''': עדכנּו את הסמל שלנו. למידע נוסף ראו את [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ הבלוג של ויקימדיה] (באנגלית).",
	'prefswitch-main-logged-changes' => "* '''לשונית {{int:watch}}''' הוחלפה בלשונית עם כוכב.
* '''לשונית {{int:move}}''' הועברה לרשימה הנפתחת ליד תיבת החיפוש.",
	'prefswitch-main-feedback' => '===יש לכם מה לספר לנו?===
נשמח לשמוע מכם משוב. אנא בקרו ב[[$1|דף המשוב]] או בקרו ב־[http://usability.wikimedia.org Usability wiki] אם אתם מתעניינים במאמצינו הנמשכים לשיפור התוכנה.',
	'prefswitch-main-anon' => '==החזירו אותי==
אם תרצו לבטל את התכונות החדשות, [$1 לחצו כאן]. לפני כן תתבקשו להיכנס לחשבונכם או ליצור חשבון.',
	'prefswitch-main-on' => '===החזירו אותי!===
[$2 לחצו כאן כדי לבטל את התכונות החדשות].',
	'prefswitch-main-off' => '===נסו אותן!===
אם תרצו להפעיל את התכונות החדשות, אנא [$1 לחצו כאן].',
	'prefswitch-survey-intro-feedback' => 'נשמח לשמוע מכם.
אנא מלאו את הסקר שלהלן (לא חובה) לפני שאתם לוחצים על "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'תודה שניסיתם את התכונות החדשות שלנו.
כדי לעזור לנו לשפר אותן, אנא מלאו את הסקר שלהלן (לא חובה) לפני שאתם לוחצים על "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:פיתוח התשתית/וקטור',
);

/** Croatian (Hrvatski)
 * @author Excaliboor
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'prefswitch' => 'Uključivanje/isklučivanje inicijative za uporabljivost',
	'prefswitch-desc' => 'Omogući korisnicima postavljanje skupa povlastica',
	'prefswitch-link-anon' => 'Nove mogućnosti',
	'tooltip-pt-prefswitch-link-anon' => 'Saznajte više o novim mogućnostima',
	'prefswitch-link-on' => 'Vrati me natrag',
	'tooltip-pt-prefswitch-link-on' => 'Onemogući nove značajke',
	'prefswitch-link-off' => 'Nove značajke',
	'tooltip-pt-prefswitch-link-off' => 'Isprobajte nove značajke',
	'prefswitch-jswarning' => 'Ne zaboravite da s promjenom stila, vaš [[User:$1/$2.js|$2 JavaScript]] trebat će se kopirati u [[{{ns:user}}:$1/vector.js]] <!-- ili [[{{ns:user}}:$1/common.js]]--> da nastavi s radom.',
	'prefswitch-csswarning' => 'Vaši [[User:$1/$2.css|$2 prilagođeni stilovi]] više se neće primijenjivati. Možete dodati prilagođeni CSS za vektor sučelje u [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Da',
	'prefswitch-survey-false' => 'Ne',
	'prefswitch-survey-submit-off' => 'Isključi nove osobine',
	'prefswitch-survey-cancel-off' => 'Ako želite nastaviti koristiti nove mogućnosti, možete se vratiti na $1.',
	'prefswitch-survey-submit-feedback' => 'Pošaljite komentar',
	'prefswitch-survey-cancel-feedback' => 'Ako ne želite pružiti povratne informacije, možete se vratiti na $1.',
	'prefswitch-survey-question-like' => 'Što vam se sviđa kod novog sučelja?',
	'prefswitch-survey-question-dislike' => 'Što vam se ne sviđa kod novog sučelja?',
	'prefswitch-survey-question-whyoff' => 'Zašto isključujete nove mogućnosti? 
Molimo označite sve razloge.',
	'prefswitch-survey-question-globaloff' => 'Želite li isključiti novo sučelje za sve Wiki projekte?',
	'prefswitch-survey-answer-whyoff-hard' => 'Sučelje je previše komplicirano.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Sučelje nije ispravno funkcioniralo.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Sučelje nije izvršilo rečeno.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Nije mi se svidio izgled sučelja.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Nisu mi se svidjele nove kartice i raspored.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nije mi se svidio novi alatni okvir.',
	'prefswitch-survey-answer-whyoff-other' => 'Drugi razlog:',
	'prefswitch-survey-question-browser' => 'Koji internetski preglednik rabite?',
	'prefswitch-survey-answer-browser-other' => 'Drugi internetski preglednik:',
	'prefswitch-survey-question-os' => 'Koji operativni sustav rabite?',
	'prefswitch-survey-answer-os-other' => 'Drugi operativni sustav:',
	'prefswitch-survey-answer-globaloff-yes' => 'Isključi novo sučelje na svim wikiprojektima',
	'prefswitch-survey-question-res' => 'Koja je rezolucija Vašeg zaslona?',
	'prefswitch-title-on' => 'Nove mogućnosti',
	'prefswitch-title-switched-on' => 'Uživajte!',
	'prefswitch-title-off' => 'Isključi nove osobine',
	'prefswitch-title-switched-off' => 'Hvala',
	'prefswitch-title-feedback' => 'Ocjena',
	'prefswitch-success-on' => 'Nove značajke su sada uključene. Nadamo se da ćete uživati koristeći ih. Uvijek ih možete isključiti klikom na "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" poveznicu na vrhu stranice.',
	'prefswitch-success-off' => 'Nove značajke su isključene. Hvala za njihovo isprobavanje. Uvijek ih možete uključiti klikom na "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" poveznicu na vrhu stranice.',
	'prefswitch-success-feedback' => 'Vaš komentar je poslan.',
	'prefswitch-return' => '<hr style="clear:both">
Povratak na <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left: 1em\" 
| align=\"center\" | 
{| border=\"0\" style=\"background: #F3F3F3; border: 1px solid #cccccc; padding: 10px;\" 
| [[Slika:VectorNavigation-en.png|401px|]] 
|- 
| Snimak zaslona novog sučelja Wikipedije <small>[[Media:VectorNavigation-en.png|(povećaj)]]</small> 
|}
|- 
| align=\"center\" | 
{| border=\"0\" style=\"background: #F3F3F3; border: 1px solid #cccccc; padding: 10px;\" 
| [[Slika:VectorEditorBasic-en.png|401px|]] 
|- 
| Snimak zaslona uređivanja stranice <small>[[Media:VectorEditorBasic-en.png|(povećaj)]]</small> 
|} 
|- 
| align=\"center\" | 
{| border=\"0\" style=\"background: #F3F3F3; border: 1px solid #cccccc; padding: 10px;\" 
| [[Slika:VectorLinkDialog-en.png|401px|]] 
|- 
| Snimak zaslona novih dijaloških okvira za unos poveznica
|} 
|} 
Ekipa za rad na korisničkom sučelju Zaklade Wikimedia radi s volonterima zajednice da bi vam olakšali snalaženje. Uzbuđeni smo podijeliti neka poboljšanja, uključujući novi izgled i dojam i pojednostavljeni izgled uređivanja. Ove promjene imaju za cilj olakšati novim suradnicima početak rada na projektu, a temelje se na našim [http://usability.wikimedia.org/wiki/Usability, _Experience, _and_Evaluation_Study testiranju uporabljivosti provedenom tijekom posljednje godine]. Poboljšanje iskoristivosti naših projekata je prioritet Zaklade Wikimedia, biti će još novosti ubuduće. Za više detalja, posjetite povezane [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog vijesti]. 

=== Evo što smo promijenili ===
*'''Navigacija:''' Imamo poboljšanu navigaciju za čitanje i uređivanje stranice. Sada, kartice na vrhu svake stranice jasnije definiraju da li pregledavate stranica ili stranica za razgovor, i da li čitate ili uređujete stranicu. 
*'''Poboljšanja trake za uređivanje:''' Reorganizirali smo traku za uređivanje kako bi ju lakše rabili. Sada, oblikovanje stranice je jednostavnije i intuitivnije. 
*'''Čarobnjak za poveznice:''' alat lak za uporabu omogućava vam dodavanje poveznica na druge wiki stranice, kao i poveznice na vanjske stranice. 
*'''Poboljšanja tražilice:''' Poboljšali smo sustav sugestija za traženje kako bi brže došli do stranice koju tražite.
*'''Ostale nove mogućnosti:''' Također smo uveli Čarobnjak za tablice da bi kreiranje tablica bilo lakše i \"traži i zamjeni\" će pojednostaviti stranice za uređivanje. 
*'''Wikipedija logo:''' Osvježili smo i naš logo. Pročitajte više na [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedijinom blogu].",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} kartica''' sad je zvjezdica.
* '''{{int:move}} kartica''' nalazi se u padajućem izborniku kraj tražilice.",
	'prefswitch-main-feedback' => '=== Komentari? === 
Rado bi čuli vaše mišljenje. Molimo posjetite naše [[$1|stranice za vaše komentare]] ili, ako ste zainteresirani saznati više o našim stalnim naporima na poboljšanju softvera, posjetite naš [http://usability.wikimedia.org wiki za poboljšanje uporabljivosti] za više informacija.',
	'prefswitch-main-anon' => '===Vrati stare postavke===
[$1 Kliknite ovdje za isključivanje novih osobina]. Bit ćete zamoljeni da se prijavite ili prvo otvorite suradnički račun.',
	'prefswitch-main-on' => '===Vrati stare postavke=== 
[$2 Klikni ovdje za isključivanje novih osobina].',
	'prefswitch-main-off' => '===Isprobajte nove osobine=== 
[$1 Kliknite ovdje kako bi omogućili nove osobine].',
	'prefswitch-survey-intro-feedback' => 'Rado bi čuli vaše mišljenje.
Molimo ispunite neobveznu anketu ispod prije nego što kliknete "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Hvala za isprobavanje novih osobina našeg sučelja.
Kako biste nam pomogli poboljšati ih, molimo Vas da ispunite neobaveznu ankete ispod prije nego što kliknete "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'prefswitch' => 'Přepinanje za nastajenja iniciatiwy wužiwajomnosće',
	'prefswitch-desc' => 'Wužiwarjam dowolić, sadźby nastajenjow přepinać',
	'prefswitch-link-anon' => 'Nowe funkcije',
	'tooltip-pt-prefswitch-link-anon' => 'Wjace wo nowych funkcijach',
	'prefswitch-link-on' => 'Wróćo',
	'tooltip-pt-prefswitch-link-on' => 'Nowe funkcije znjemóžnić',
	'prefswitch-link-off' => 'Nowe funkcije',
	'tooltip-pt-prefswitch-link-off' => 'Nowe funkcije wupruwować',
	'prefswitch-jswarning' => 'Wobkedźbuj, zo ze měnjenju šata, twój [[User:$1/$2.js|javascript $2]]  dyrbi so do [[User:$1/vector.js]] abo [[User:$1/common.js]] kopěrować, zo by dale fungował.',
	'prefswitch-csswarning' => 'Twoje [[User:$1/$2.css|swójske stile $2]] wjace njebudu so nałožować. Móžeš swójski CSS za skin Vector w [[User:$1/vector.css]] přidać.',
	'prefswitch-survey-true' => 'Haj',
	'prefswitch-survey-false' => 'Ně',
	'prefswitch-survey-submit-off' => 'Nowe funkcije wupinyć',
	'prefswitch-survey-cancel-off' => 'Jeli by rady nowe funkcije dale wužiwał, móžeš so k $1 wróćić.',
	'prefswitch-survey-submit-feedback' => 'Měnjenje pósłać',
	'prefswitch-survey-cancel-feedback' => 'Jeli nochceš měnjenje dodać, móžeš so do $1 wróćić.',
	'prefswitch-survey-question-like' => 'Što sej ći na nowych funkcijach spodoba?',
	'prefswitch-survey-question-dislike' => 'Što sej ći na nowych funkcijach njespodoba?',
	'prefswitch-survey-question-whyoff' => 'Čehodla wupinaš nowe funkcije?
Prošu wubjer wšě, kotrež maja so nałožić.',
	'prefswitch-survey-question-globaloff' => 'Chceš tute funkcije globalnje wušaltować?',
	'prefswitch-survey-answer-whyoff-hard' => 'Njeda so lochko wužiwać.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Njeje porjadnje fungowało.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Njefunguje na předwidźomne wašnje.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Napohlad so mi njespodoba.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Nowe rajtarki a wuhotowanje njejsu so mi lubili.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nowa gratowa lajsta njeje so mi njespodobała.',
	'prefswitch-survey-answer-whyoff-other' => 'Druha přičina:',
	'prefswitch-survey-question-browser' => 'Kotry wobhladowak wužiwaš?',
	'prefswitch-survey-answer-browser-other' => 'Druhi wobhladowak:',
	'prefswitch-survey-question-os' => 'Kotry dźěłowy system wužiwaš?',
	'prefswitch-survey-answer-os-other' => 'Druhi dźěłowy system:',
	'prefswitch-survey-answer-globaloff-yes' => 'Haj, funkcije na wšěch wikijach wušaltować',
	'prefswitch-survey-question-res' => 'Kotre je rozeznaće twojeje wobrazowki?',
	'prefswitch-title-on' => 'Nowe funkcije',
	'prefswitch-title-switched-on' => 'Wjesel so!',
	'prefswitch-title-off' => 'Nowe funkcije wupinyć',
	'prefswitch-title-switched-off' => 'Dźakujemy so',
	'prefswitch-title-feedback' => 'Rezonanca',
	'prefswitch-success-on' => 'Nowe funkcije su nětko zapinjene. Nadźijamy so, zo wjeseliš so nad nowymi funkcijemi. Móžeš je kóždy čas přez kliknjenje na wotkaz "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" horjeka na stronje wupinyć.',
	'prefswitch-success-off' => 'Nowe funkcije su wupinjene. Dźakujemy so, zo sy nowe funkcije testował. Móžeš je kóždy čas přez kliknjenje na wotkaz "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" horjeka na stronje zapinyć.',
	'prefswitch-success-feedback' => 'Twoje měnjenje je so pósłało.',
	'prefswitch-return' => '<hr style="clear:both">
Wróćo do <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-de.png|401px|]]
|-
| Wobrazowkowe foto nawigaciskeho powjercha Wikipedije <small>[[Media:VectorNavigation-de.png|(powjetšić)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-de.png|401px|]]
|-
| Wobrazkowe foto zakładneho wobdźěłowanskeho powjercha <small>[[Media:VectorEditorBasic-de.png|(powjetšić)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-de.png|401px|]]
|-
| Wobrazowkowe foto noweho dialogoweho kašćika za zapodawanje wotkazow
|}
|}
Team za polěpšenje wužiwajomnosće załožby Wikimedia Foundation dźěła z dobrowólnymi zhromadźenstwa, zo by wěcy za tebje wosnadnił. Bychmy so wjeselili, so wo polěpšenjach wuměnić, inkluziwnje nowy napohlad a zjednorjene wobdźěłowanske funkcije. Tute změny maja nowym sobuskutkowarjam start wosnadnić a bazuja na našim [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study testowanju wužiwajomnosće, kotrež bu cyłe lěto přewjedźene]. Polěpšenje wužiwajomnosće našich projektow je priorita załožby Wikimedia Foundation a rozdźělimy wjace aktualizacijow w přichodźe. Za dalše podrobnosće wopytaj wotpowědny póst na [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Wikimedia blogu]

===Tole smy změnili===
* '''Nawigacija:''' Smy nawigaciju za čitanje a wobdźěłowanje stronow polěpšili. Nětko rajtarki horjeka na stronje móžeja jasnišo definować, hač sej nastawk abo diskusijnu stronu wobhladuješ, a hač čitaš abo wobdźěłuješ stronu.
* '''Polěpšenja wobdźěłowanskeje lajsty:''' Smy wobdźěłowansku lajstu přeorganizował, zo by so dała lóšo wužiwać. Nětko je formatowanje stronow jednoriše a bóle intuitiwne.
* '''Wotkazowy asistent:''' Nastroj, kotryž da so lochko wužiwać a ći dowola, wotkazy druhim wikistronam  kaž tež eksternym sydłam přidać.
* '''Pytanske polěpšenja:''' Smy pytanske namjety polěpšili, zo bychmy će spěšnišo k tej stronje wjedli, kotruž pytaš.
* '''Druhe nowe funkcije:''' Smy tež tabelowy asistent zawjedli, zo bychmy wutworjenje tabelow wosnadnili a funkciju za pytanje a narunanje, zo bychmy wobdźěłowanje strony zjednorili.
* '''Logo wikipedije:''' Smy swoje logo zaktualizowali. Dalše informacije wo tym na [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blogu Wikimedije].",
	'prefswitch-main-logged-changes' => "* '''Rajtark {{int:watch}}''' je nětko hwězda.
* '''Rajtark {{int:move}}''' je nětko wuběranski meni pod šipkom direktnjepódla pytanskeho pola.",
	'prefswitch-main-feedback' => '===Měnjenja?===
Bychmy so wjeselili wot tebje słyšeć. Prošu wopytaj našu [[$1|stronu komentarow]] abo, jeli zajimuješ za naše běžne napinanja softwaru polěpšić, wopytaj našu [http://usability.wikimedia.org wiki wužiwajomnosće] za dalše informacije.',
	'prefswitch-main-anon' => '===Wróćo===
Jeli chceće nowe funkcije znjemóžnić, [$1 klikńće tu].  Proša was, so přizjewić abo najprjedy konto załožić.',
	'prefswitch-main-on' => '===Wróćo!===
[$2 Klikń tu, zo by nowe funkcije wupinyć].',
	'prefswitch-main-off' => '===Wupruwuj je!===
Jeli chceš nowe funkcije zapinyć,  [$1 klikń prošu tu].',
	'prefswitch-survey-intro-feedback' => 'Bychmy so wjesleli, wot tebje słyšeć.
Prošu wupjelń slědowace opcionelne poszudźenje, prjedy hač kliknješ na "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Dźakujemy so za wupruwowanje našich nowych funkcijow.
Zo by nam pomhał, je polěpšić, wupjelń prošu slědowace opcionelne posudźenje, prjedy hač kliknješ na "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Iniciatiwa wužiwajomnosće měnjenja',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 * @author Glanthor Reviol
 * @author Misibacsi
 * @author Tgr
 */
$messages['hu'] = array(
	'prefswitch' => 'Usability Initiative beállítás-váltó',
	'prefswitch-desc' => 'Lehetővé teszi a felhasználóknak a különböző beállítások közötti váltást',
	'prefswitch-link-anon' => 'Új funkciók',
	'tooltip-pt-prefswitch-link-anon' => 'Ismerd meg az új funkciókat',
	'prefswitch-link-on' => 'Vissza a régire',
	'tooltip-pt-prefswitch-link-on' => 'Az új funkciók letiltása',
	'prefswitch-link-off' => 'Új funkciók',
	'tooltip-pt-prefswitch-link-off' => 'Próbáld ki az új funkciókat',
	'prefswitch-jswarning' => 'Ne feledd, hogy a felületváltás miatt a [[User:$1/$2.js|$2 felülethez tartozó JavaScriptet]]  át kell másolnod a [[{{ns:user}}:$1/vector.js]]-be vagy a [[{{ns:user}}:$1/common.js]]-be, hogy továbbra is működjenek.',
	'prefswitch-csswarning' => 'A [[User:$1/$2.css|$2 felületre alkalmazott egyéni stílusaid]] nem fognak működni ezentúl. A Vectorhoz a [[{{ns:user}}:$1/vector.css]]-ben tudsz saját CSS-t megadni.',
	'prefswitch-survey-true' => 'Igen',
	'prefswitch-survey-false' => 'Nem',
	'prefswitch-survey-submit-off' => 'Új funkciók kikapcsolása',
	'prefswitch-survey-cancel-off' => 'Ha továbbra is szeretnéd használni az új funkciókat, akkor visszatérhetsz a(z) $1 lapra.',
	'prefswitch-survey-submit-feedback' => 'Visszajelzés küldése',
	'prefswitch-survey-cancel-feedback' => 'Ha nem akarod megosztani a tapasztalataidat, visszatérhetsz a(z) $1 lapra.',
	'prefswitch-survey-question-like' => 'Mi tetszett az új funkciókból?',
	'prefswitch-survey-question-dislike' => 'Mi nem tetszett az új funkciókból?',
	'prefswitch-survey-question-whyoff' => 'Miért kapcsolod ki az új funkciókat?
Jelöld be az összes indokodat.',
	'prefswitch-survey-question-globaloff' => 'Szeretné ezeket a tulajdonságokat mindenhol kikapcsolni?',
	'prefswitch-survey-answer-whyoff-hard' => 'Túl nehéz volt használni.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Nem működött megfelelően.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Nem működött kiszámíthatóan.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Nem tetszik, ahogy kinéz.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Nem tetszenek az új fülek és az elrendezés.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nem tetszik az új szerkesztő-eszköztár.',
	'prefswitch-survey-answer-whyoff-other' => 'Egyéb indok:',
	'prefswitch-survey-question-browser' => 'Melyik böngészőt használod?',
	'prefswitch-survey-answer-browser-other' => 'Más böngésző:',
	'prefswitch-survey-question-os' => 'Melyik operációs rendszert használod?',
	'prefswitch-survey-answer-os-other' => 'Más operációs rendszer:',
	'prefswitch-survey-answer-globaloff-yes' => 'Igen, kapcsolja ki a funkciókat minden wikiben',
	'prefswitch-survey-question-res' => 'Milyen felbontású a képernyőd?',
	'prefswitch-title-on' => 'Új funkciók',
	'prefswitch-title-switched-on' => 'Jó szórakozást!',
	'prefswitch-title-off' => 'Új funkciók kikapcsolása',
	'prefswitch-title-switched-off' => 'Köszönjük',
	'prefswitch-title-feedback' => 'Visszajelzés',
	'prefswitch-success-on' => 'Az új funkciók be vannak kapcsolva. Reméljük, hogy jó használni az újdonságokat. Bármikor kikapcsolhatod őket a lap tetején található „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]” gombra kattintva.',
	'prefswitch-success-off' => 'Az új funkciók ki vannak kapcsolva. Köszönjük hogy kipróbáltad őket. Bármikor visszakapcsolhatod őket a lap tetején található „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]” gombra kattintva.',
	'prefswitch-success-feedback' => 'A visszajelzésed el lett küldve.',
	'prefswitch-return' => '<hr style="clear:both">
Vissza a(z) <span class="plainlinks">[$1 $2]</span> lapra.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-hu.png|401px|]]
|-
| A Wikipédia új navigációs felületének képe <small>[[Media:VectorNavigation-hu.png|(nagyítás)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-hu.png|401px|]]
|-
| Az alap szerkesztőfelület képe <small>[[Media:VectorEditorBasic-hu.png|(nagyítás)]]</small>
|}
|-
| align=\"center\" |ám
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-hu.png|401px|]]
|-
| A hivatkozások megadására szolgáló új párbeszédablak képe
|}
|}
A Wikimédia Alapítány felhasználói élményért felelős csapata és az őket segítő önkéntesek azon dolgoztak, hogy könnyebbé tegyék számodra a wiki használatát. Örömünkre szolgál, hogy bemutathatjuk e munka néhány eredményt, köztük egy új kinézetet és egyszerűsített szerkesztőfelületet. A változások célja az új szerkesztők bekapcsolódásának megkönnyítése, [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study a tavalyi használhatósági tesztelés] tanulságai alapján. Weboldalaink könnyű használhatósága fontos cél a Wikimédia Alapítványnak, ezért a jövőben további változatásokra számíthatsz. Részletesebben [http://huwiki.blogspot.com/2010/06/wikipedia-uj-kinezetet-kap.html?utm_source=wikipedia&utm_campaign=vector_newlook a kapcsolódó blogbejegyzésben] olvashatsz.

=== Mi változott? ===
* '''Navigáció:''' Jobb lett a navigáció a lapok olvasásánál és szerkesztésénél. A lap tetején elhelyezett fülek világosabban jelzik, hogy a szócikket vagy a vitalapot nézed, és hogy olvasod-e vagy szerkeszted a lapot.
* '''Szerkesztőgombok:'''  A szerkesztőablak feletti eszközsávban kevesebb, de könnyebben beazonosítható és ésszerűbben csoportosított gomb maradt.
* '''Hivatkozáskészítő varázsló:''' A más szócikkekre vagy külső weboldalakra mutató hivatkozás beszúrását egy párbeszédablak teszi egyszerűbbé.
* '''Fejlettebb keresés:''' Fejlesztettünk a keresési javaslatokon, hogy könnyebben megtaláld a kívánt oldalt.
* '''Más újdonságok:'''  A szerkesztőgombok közé bekerült egy táblázatkészítő varázsló és egy keresés és csere funkció.
* '''Wikipédia-logó:''' Újrarajzoltuk a logót. A változásokról a [http://huwiki.blogspot.com/2010/06/wikipedia-3d-ben.html?utm_source=wikipedia&utm_campaign=vector_logo Wikipédia-blogban] olvashatsz.",
	'prefswitch-main-logged-changes' => "* A '''{{int:watch}} fület''' ezentúl egy csillag jelöli.
* Az '''{{int:move}} fül''' egy lenyíló menüben található a keresősáv mellett.",
	'prefswitch-main-feedback' => '=== Megírnád a véleményedet? ===
Ha kipróbáltad, szívesen olvasnánk a tapasztalataidról. Írhatsz nekünk [[$1|az erre a célra fenntartott üzenőlapon]], vagy ha érdekel, milyen erőfeszítések történnek a szoftver felhasználóbarátabbá tételére, meglátogathatod a [http://usability.wikimedia.org használhatósági wikit].',
	'prefswitch-main-anon' => '===Vissza a régit===
[$1 Kattints ide az új funkciók kikapcsolásához]. Ehhez be kell jelentkezned, vagy regisztrálnod kell.',
	'prefswitch-main-on' => '===Vissza a régit===
[$2 Kattints ide az új funkciók kikapcsolásához].',
	'prefswitch-main-off' => '=== Próbáld ki! ===

Ha szeretnéd bekapcsolni az új funkciókat, [$1 kattints ide].',
	'prefswitch-survey-intro-feedback' => 'Örülnénk, ha elmondanád a véleményed.
Légyszíves töltsd ki az alábbi önkéntes kérdőívet, mielőtt a „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]”  gombra kattintanál.',
	'prefswitch-survey-intro-off' => 'Köszönjük, hogy kipróbáltad az új funkciókat.
Légyszíves segíts a továbbfejlesztésükben az alábbi önkéntes kérdőív kitöltésével, mielőtt az „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]”-ra kattintanál.',
	'prefswitch-feedbackpage' => 'Project:Felhasználói visszajelzés',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'prefswitch' => 'Activation e disactivation del Initiativa de Usabilitate',
	'prefswitch-desc' => 'Permitte al usatores de cambiar inter gruppos de preferentias',
	'prefswitch-link-anon' => 'Nove functiones',
	'tooltip-pt-prefswitch-link-anon' => 'Ulterior informationes super le nove functiones',
	'prefswitch-link-on' => 'Porta me retro',
	'tooltip-pt-prefswitch-link-on' => 'Disactivar le nove functiones',
	'prefswitch-link-off' => 'Nove functiones',
	'tooltip-pt-prefswitch-link-off' => 'Probar nove functiones',
	'prefswitch-jswarning' => 'Memora que, con le cambiamento del apparentia, tu [[User:$1/$2.js|$2 JavaScript]] debera esser copiate in [[{{ns:user}}:$1/vector.js]] <!-- o [[{{ns:user}}:$1/common.js]]--> pro continuar a functionar.',
	'prefswitch-csswarning' => 'Tu [[User:$1/$2.css|stilos personalisate de $2]] non essera plus applicate. Tu pote adder CSS personalisate pro Vector in [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Si',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Disactivar le nove functiones',
	'prefswitch-survey-cancel-off' => 'Si tu vole continuar a usar le nove functiones, tu pote retornar a $1.',
	'prefswitch-survey-submit-feedback' => 'Dar nos tu opinion',
	'prefswitch-survey-cancel-feedback' => 'Si tu non vole dar nos tu opinion, tu pote retornar a $1.',
	'prefswitch-survey-question-like' => 'Que appreciava tu in le nove functionalitate?',
	'prefswitch-survey-question-dislike' => 'Que non appreciava tu in le nove functionalitate?',
	'prefswitch-survey-question-whyoff' => 'Proque disactiva tu le nove functiones?
Per favor selige tote le motivos applicabile.',
	'prefswitch-survey-question-globaloff' => 'Vole tu disactivar iste functionalitate globalmente?',
	'prefswitch-survey-answer-whyoff-hard' => 'Esseva troppo difficile de usar.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Non functionava correctemente.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Non functionava de modo previsibile.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Non me placeva le aspecto.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Non me placeva le nove schedas e disposition.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Non me placeva le nove barra de instrumentos.',
	'prefswitch-survey-answer-whyoff-other' => 'Altere motivo:',
	'prefswitch-survey-question-browser' => 'Qual navigator usa tu?',
	'prefswitch-survey-answer-browser-other' => 'Altere navigator:',
	'prefswitch-survey-question-os' => 'Qual systema de operation usa tu?',
	'prefswitch-survey-answer-os-other' => 'Altere systema de operation:',
	'prefswitch-survey-answer-globaloff-yes' => 'Si, disactivar le functionalitate in tote le wikis',
	'prefswitch-survey-question-res' => 'Qual es le resolution de tu schermo?',
	'prefswitch-title-on' => 'Nove functionalitate',
	'prefswitch-title-switched-on' => 'Bon divertimento!',
	'prefswitch-title-off' => 'Disactivar le nove functiones',
	'prefswitch-title-switched-off' => 'Gratias',
	'prefswitch-title-feedback' => 'Tu opinion',
	'prefswitch-success-on' => 'Le nove functiones es ora active. Nos spera que illos te placera. Tu pote sempre disactivar los con un clic super le ligamine "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" in alto del pagina.',
	'prefswitch-success-off' => 'Le nove functiones non es plus active. Gratias pro haber essayate los. Tu pote sempre reactivar los con un clic super le ligamine "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" in alto del pagina.',
	'prefswitch-success-feedback' => 'Tu opinion ha essite inviate.',
	'prefswitch-return' => '<hr style="clear:both">
Retornar a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Un captura del nove interfacie de navigation de Wikipedia <small>[[Media:VectorNavigation-en.png|(aggrandir)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Un captura del interfacie basic pro modificar paginas <small>[[Media:VectorEditorBasic-en.png|(aggrandir)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Un captura del nove fenestra de dialogo pro entrar ligamines
|}
|}
Le Equipa del Experientia de Usator del Fundation Wikimedia ha collaborate con voluntarios del communitate pro render le cosas plus facile pro te. Nos es enthusiasta de demonstrar alcun meliorationes, como un nove apparentia e functiones de modification simplificate. Iste cambios ha le scopo facer que le nove contributores pote comenciar plus facilemente, e es basate in nostre [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study essayos de usabilitate conducite durante le ultime anno]. Meliorar le usabilitate de nostre projectos es un prioritate del Fundation Wikimedia e nos monstrara altere actualisationes in le futuro. Pro ulterior detalios, visita le [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia articulo relevante] del blog de Wikimedia (in anglese).

===Ecce lo que nos ha cambiate===
* '''Navigation:''' Nos ha meliorate le systema de navigation pro leger e modificar paginas. Ora, le schedas in alto de cata pagina indica plus clarmente si tu vide le articulo o su pagina de discussion, e si tu lege o modifica le pagina.
* '''Meliorationes del instrumentario de modification:'''  Nos ha reorganisate le barra de instrumentos de modification pro render lo plus facile de usar. Ora, formatar paginas es plus simple e intuitive.
* '''Assistente pro ligamines:''' Un instrumento simple permitte adder ligamines a altere paginas de Wikipedia e ligamines a sitos externe.
* '''Meliorationes de recerca:''' Nos ha meliorate le suggestiones de recerca pro portar te plus rapidemente al pagina que tu cerca.
* '''Altere nove functiones:''' Nos ha etiam introducite un assistente pro facilitar le creation de tabellas, e un function de cercar e reimplaciar pro simplificar le modification de paginas.
* '''Le logotypo de Wikipedia''': Nos ha actualisate le logotypo. Lege plus in le [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blog de Wikimedia] (in anglese).",
	'prefswitch-main-logged-changes' => "* Le '''scheda {{int:watch}}''' es ora un stella.
* Le '''scheda {{int:move}}''' es ora in le menu disrolante juxta le barra de recerca.",
	'prefswitch-main-feedback' => '===Commentarios?===
Nos amarea audir de te. Per favor visita nostre [[$1|pagina pro dar tu opinion]] o, si tu ha interesse in nostre continue effortios pro meliorar le software, visita nostre [http://usability.wikimedia.org wiki de usabilitate] pro plus information.',
	'prefswitch-main-anon' => '===Porta me retro===
Si tu vole disactivar le nove functiones, [$1 clicca hic]. Il te essera demandate de primo aperir un session o crear un conto.',
	'prefswitch-main-on' => '===Porta me retro!===
[$2 Clicca hic pro disactivar le nove functiones].',
	'prefswitch-main-off' => '===Proba los!===
Si tu vole activar le nove functiones, per favor [$1 clicca hic].',
	'prefswitch-survey-intro-feedback' => 'Nos amarea cognoscer tu opinion.
Per favor completa le questionario facultative hic infra ante de cliccar super "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Gratias pro haber probate le nove functiones.
Pro adjutar nos a meliorar los, per favor completa le questionario facultative hic infra ante de cliccar super "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Commentario re usabilitate',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Kenrick95
 */
$messages['id'] = array(
	'prefswitch' => 'Peralihan preferensi Proyek Inisiatif Kebergunaan',
	'prefswitch-desc' => 'Izinkan pengguna mengubah aturan preferensi',
	'prefswitch-link-anon' => 'Fitur baru',
	'tooltip-pt-prefswitch-link-anon' => 'Pelajari tentang fitur baru',
	'prefswitch-link-on' => 'Bawa saya kembali',
	'tooltip-pt-prefswitch-link-on' => 'Nonaktifkan fitur baru',
	'prefswitch-link-off' => 'Fitur baru',
	'tooltip-pt-prefswitch-link-off' => 'Coba fitur baru',
	'prefswitch-jswarning' => 'Ingatlah bahwa dengan adanya perubahan kulit ini, [[User:$1/$2.js|JavaScript $2]] Anda perlu disalin ke [[{{ns:user}}:$1/vector.js]] <!-- atau [[{{ns:user}}:$1/common.js]]--> agar dapat terus digunakan.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|Kulit $2 kustom]] Anda tak dapat lagi digunakan. Anda dapat menambahkan CSS untuk kulit vektor di [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ya',
	'prefswitch-survey-false' => 'Tidak',
	'prefswitch-survey-submit-off' => 'Matikan fitur baru',
	'prefswitch-survey-cancel-off' => 'Jika Anda ingin terus menggunakan fitur baru ini, Anda dapat kembali ke $1.',
	'prefswitch-survey-submit-feedback' => 'Kirim umpan balik',
	'prefswitch-survey-cancel-feedback' => 'Jika Anda tidak ingin memberikan umpan balik, Anda dapat kembali ke $1.',
	'prefswitch-survey-question-like' => 'Apa yang Anda sukai tentang fitur baru ini?',
	'prefswitch-survey-question-dislike' => 'Apa yang Anda tidak sukai tentang fitur baru ini?',
	'prefswitch-survey-question-whyoff' => 'Mengapa Anda mematikan fitur baru ini?
Harap pilih semua yang benar.',
	'prefswitch-survey-question-globaloff' => 'Anda ingin fitur dinonaktifkan secara global?',
	'prefswitch-survey-answer-whyoff-hard' => 'Terlalu sulit untuk digunakan.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Tidak berfungsi dengan baik.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Fitur tidak berjalan seperti yang diharapkan.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Saya tidak suka tampilan fiturnya.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Saya tidak suka dengan tab baru dan tampilannya.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Saya tidak menyukai kotak peralatan yang baru.',
	'prefswitch-survey-answer-whyoff-other' => 'Alasan lainnya:',
	'prefswitch-survey-question-browser' => 'Penjelajah web apa yang Anda gunakan?',
	'prefswitch-survey-answer-browser-other' => 'Penjelajah web lainnya:',
	'prefswitch-survey-question-os' => 'Sistem operasi apa yang Anda gunakan?',
	'prefswitch-survey-answer-os-other' => 'Sistem operasi lainnya:',
	'prefswitch-survey-answer-globaloff-yes' => 'Ya, nonaktifkan fitur di semua wiki',
	'prefswitch-survey-question-res' => 'Berapa besar resolusi layar Anda?',
	'prefswitch-title-on' => 'Fitur baru',
	'prefswitch-title-switched-on' => 'Selamat menikmati!',
	'prefswitch-title-off' => 'Matikan fitur baru',
	'prefswitch-title-switched-off' => 'Terima kasih',
	'prefswitch-title-feedback' => 'Umpan balik',
	'prefswitch-success-on' => 'Fitur baru sekarang telah dihidupkan. Kami harap Anda menikmati fitur baru ini. Anda dapat mematikannya dengan menekan pranala "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" di atas halaman.',
	'prefswitch-success-off' => 'Fitur baru sekarang telah dimatikan. Terima kasih telah mencoba fitur baru. Anda dapat menggunakannya kembali dengan menekan pranala "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" di atas halaman.',
	'prefswitch-success-feedback' => 'Umpan balik Anda telah terkirim.',
	'prefswitch-return' => '<hr style="clear:both">
Kembali ke <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Berkas:VectorNavigation-en.png|401px|]]
|-
| Cuplikan antarmuka navigasi baru Wikipedia <small>[[Media:VectorNavigation-en.png|(perbesar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Berkas:VectorEditorBasic-en.png|401px|]]
|-
| Cuplikan antarmuka penyuntingan halaman dasar <small>[[Media:VectorEditorBasic-en.png|(perbesar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Berkas:VectorLinkDialog-en.png|401px|]]
|-
| Cuplikan kotak dialog baru untuk memasukkan pranala
|}
|}
Tim Pengalaman Pengguna Yayasan Wikimedia telah bekerja bersama sukarelawan dari komunitas untuk membuat segalanya lebih mudah untuk Anda. Kami senang berbagi sejumlah perbaikan, termasuk tampilan dan gaya baru dan fitur penyuntingan yang lebih sederhana. Perubahan ini ditujukan untuk membuat segalanya lebih mudah bagi penyumbang baru untuk memulai pengalaman mereka, dan didasarkan kepada [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study pengujian kebergunaan yang dilakukan tahun lalu]. Memerbaiki kebergunaan proyek-proyek kami adalah sebuah keutamaan Yayasan Wikimedia dan kami akan terus berbagi pemutakhiran terkini selanjutnya. Untuk lebih lanjut, baca [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia kiriman blog] Wikimedia.

=== Inilah yang telah kami ubah ===
* '''Navigasi:''' Kami telah memerbaiki navigasi untuk membaca dan menyunting halaman. Sekarang, tab di atas masing-masing halaman lebih jelas memberitahukan apakah Anda ketika sedang menampilkan halaman atau halaman diskusi, dan ketika Anda sedang membaca atau menyunting halaman.
* '''Perbaikan kotak peralatan penyuntingan:''' Kami telah mengatur ulang kotak peralatan penyuntingan untuk membuatnya lebih mudah digunakan. Sekarang, halaman penyuntingan lebih sederhana dan lebih intuitif.
* '''Kotak pranala:''' Alat yang mudah digunakan yang membolehkan Anda menambahkan pranala ke halaman wiki lain serta situs luar.
* '''Perbaikan pencarian:''' Kami telah memerbaiki saran pencarian untuk membawa Anda ke halaman yang sedang Anda cari lebih cepat.
* '''Fitur baru lainnya:''' Kami juga memerkenalkan kotak tabel agar membuat tabel lebih mudah serta fitur cari dan gantikan untuk menyederhanakan penyuntingan halaman.
* '''Logo Wikipedia:''' Kami telah memutakhirkan logo kami. Baca lebih lanjut di [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blog Wikimedia].",
	'prefswitch-main-logged-changes' => "* Sekarang '''tab {{int:watch}}''' menjadi sebuah bintang.
* Sekarang '''tab {{int:move}}''' berada di menu turunan tepat di sebelah kotak pencarian.",
	'prefswitch-main-feedback' => '===Umpan balik?===
Kami ingin mendengar pendapat Anda. Silakan kunjungi [[$1|halaman umpan balik]] kami atau, bila Anda tertarik pada usaha kami dalam memperbaiki perangkat lunak ini, kunjungi [http://usability.wikimedia.org wiki kebergunaan] kami untuk informasi lebih lanjut.',
	'prefswitch-main-anon' => '=== Bawa saya kembali ===
[$1 Klik disini untuk menonaktifkan fitur baru]. Anda akan diminta untuk masuk log atau membuat akun terlebih dahulu.',
	'prefswitch-main-on' => '=== Bawa saya kembali! ===
[$2 Klik di sini untuk menonaktifkan fitur baru].',
	'prefswitch-main-off' => '===Cobalah!===
[$1 Klik di sini untuk mengaktifkan fitur baru].',
	'prefswitch-survey-intro-feedback' => 'Kami ingin mendengar pendapat Anda.
Silakan isi survei oposional di bawah ini sebelum menekan "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Terima kasih telah mencoba fitur baru kami.
Untuk membantu kami memperbaikinya, silakan isi survei opsional di bawah ini sebelum menekan "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Umpan balik pengalaman pengguna',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'prefswitch-survey-true' => 'Eeh',
	'prefswitch-survey-false' => 'Mbà',
	'prefswitch-title-switched-on' => 'Na nke ómá!',
	'prefswitch-title-switched-off' => 'Imẹẹla',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'prefswitch-link-anon' => 'Nova funcioni',
	'tooltip-pt-prefswitch-link-anon' => 'Lernez pri nova funcioni',
	'prefswitch-link-on' => 'Retroirez',
	'prefswitch-link-off' => 'Nova funcioni',
	'tooltip-pt-prefswitch-link-off' => 'Probez nova funcioni',
	'prefswitch-survey-true' => 'Yes',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Supresez nova funcioni',
	'prefswitch-survey-answer-whyoff-other' => 'Altra motivo:',
	'prefswitch-title-on' => 'Nova funcioni',
	'prefswitch-title-switched-on' => 'Juez!',
	'prefswitch-title-off' => 'Supresez nova funcioni',
	'prefswitch-title-switched-off' => 'Danko',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Nemo bis
 * @author Una giornata uggiosa '94
 */
$messages['it'] = array(
	'prefswitch' => "Cambiamento delle preferenze dell'iniziativa per l'usabilità",
	'prefswitch-desc' => 'Permetti agli utenti di cambiare set di preferenze',
	'prefswitch-link-anon' => 'nuove funzionalità',
	'tooltip-pt-prefswitch-link-anon' => 'Informazioni sulle nuove funzionalità',
	'prefswitch-link-on' => 'torna alla vecchia interfaccia',
	'tooltip-pt-prefswitch-link-on' => 'Disattiva le nuove funzionalità',
	'prefswitch-link-off' => 'nuove funzionalità',
	'tooltip-pt-prefswitch-link-off' => 'Prova le nuove funzioni',
	'prefswitch-jswarning' => 'Ricorda che con il cambiamento della skin, il codice [[User:$1/$2.js|JavaScript del tuo $2]] dovrà essere copiato in [[{{ns:user}}:$1/vector.js]] <!-- o [[{{ns:user}}:$1/common.js]]--> per continuare a funzionare.',
	'prefswitch-csswarning' => 'I tuoi [[User:$1/$2.css|stili personalizzati per $2]] non saranno più applicati. Puoi aggiungere CSS personalizzato per vector in [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Sì',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Disattiva le nuove funzioni',
	'prefswitch-survey-cancel-off' => 'Se vuoi continuare ad usare le nuove funzioni, puoi tornare a $1.',
	'prefswitch-survey-submit-feedback' => 'Invia feedback',
	'prefswitch-survey-cancel-feedback' => 'Se non vuoi fornire un feedback, puoi tornare a $1.',
	'prefswitch-survey-question-like' => 'Cosa ti è piaciuto delle nuove funzionalità?',
	'prefswitch-survey-question-dislike' => 'Cosa non ti è piaciuto delle nuove funzionalità?',
	'prefswitch-survey-question-whyoff' => 'Perché stai disattivando le nuove funzioni?
Si prega di selezionare tutte le motivazioni pertinenti.',
	'prefswitch-survey-question-globaloff' => 'Vuoi disattivare le funzionalità globalmente?',
	'prefswitch-survey-answer-whyoff-hard' => 'Era troppo difficile da usare.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Non funzionava correttamente.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Non si comportava in modo coerente.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "Non mi piaceva l'aspetto.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Non mi piacevano le nuove schede e il layout.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Non mi piaceva la nuova barra degli strumenti.',
	'prefswitch-survey-answer-whyoff-other' => 'Altra motivazione:',
	'prefswitch-survey-question-browser' => 'Quale browser usi?',
	'prefswitch-survey-answer-browser-other' => 'Altro browser:',
	'prefswitch-survey-question-os' => 'Quale sistema operativo usi?',
	'prefswitch-survey-answer-os-other' => 'Altro sistema operativo:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sì, disattiva le funzionalità su tutte le wiki',
	'prefswitch-survey-question-res' => 'Qual è la risoluzione del tuo schermo?',
	'prefswitch-title-on' => 'Nuove funzionalità',
	'prefswitch-title-switched-on' => 'Buon divertimento!',
	'prefswitch-title-off' => 'Disattiva le nuove funzioni',
	'prefswitch-title-switched-off' => 'Grazie',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'Le nuove funzionalità sono attive. Ci auguriamo che ti piacciano. Puoi sempre disattivarle cliccando sul link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" sulla parte superiore della pagina.',
	'prefswitch-success-off' => 'Le nuove funzionalità sono state disattivate. Grazie per averle provate. Puoi sempre riattivarle cliccando sul link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" nella parte superiore della pagina.',
	'prefswitch-success-feedback' => 'Il tuo feedback è stato inviato.',
	'prefswitch-return' => '<hr style="clear:both">
Torna a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-it.png|401px|]]
|-
| Immagine della nuova interfaccia Vector <small>[[Media:VectorNavigation-it.png|(ingrandisci)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-it.png|401px|]]
|-
| Immagine della nuova interfaccia di modifica di base <small>[[Media:VectorEditorBasic-it.png|(ingrandisci)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-it.png|401px|]]
|-
| Immagine delle nuove finestre per inserire collegamenti
|}
|}
Lo \"User Experience Team\" della Fondazione Wikimedia, insieme ai volontari della comunità, ha lavorato duramente per rendere le cose più semplici per te. Siamo entusiasti di annunciare alcuni miglioramenti, tra cui un nuovo aspetto grafico e delle funzioni di modifica semplificate.  Migliorare l'usabilità dei progetti wiki è una priorità della Fondazione Wikimedia, e daremo altri aggiornamenti in futuro. Per maggiori dettagli, visita il relativo articolo del [http://www.frontieredigitali.it/online/?p=1703 blog Wikimedia].
===Ecco cosa abbiamo cambiato===
* '''Navigazione''': Abbiamo migliorato il sistema di navigazione per leggere e modificare voci. Adesso, le schede nella parte superiore di ogni voce indicano più chiaramente se stai visualizzando la voce o la pagina di discussione, e se stai leggendo o modificando una voce.
* '''Miglioramenti alla barra degli strumenti''':  Abbiamo riorganizzato la barra degli strumenti di modifica per renderla più semplice da usare.  Adesso, formattare le voci è più semplice e intuitivo.
* '''Procedura guidata per i link''':  Uno strumento semplice da utilizzare ti permette di aggiungere link ad altre pagine di Wikipedia e link a siti esterni.
* '''Miglioramenti alla ricerca''': Abbiamo migliorato i suggerimenti della ricerca per portarti più velocemente alla pagina che stai cercando.
* '''Altre nuove funzioni''':  Abbiamo introdotto anche una procedura guidata per le tabelle per rendere la loro creazione più semplice e una funzione \"trova e sostituisci\" per semplificare la modifica delle pagine.
* '''Globo-puzzle di Wikipedia''': Abbiamo aggiornato il globo-puzzle. Leggi altre informazioni sul [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blog Wikimedia].",
	'prefswitch-main-logged-changes' => "* La '''linguetta {{int:watch}}''' adesso è una stella.
* La '''linguetta {{int:move}}''' adesso è nel menu a scomparsa vicino alla barra di ricerca.",
	'prefswitch-main-feedback' => "===Commenti?===
Non vediamo l'ora di conoscere la tua opinione. Visita la nostra [[$1|pagina di feedback]] oppure, se sei interessato nei nostri continui sforzi per migliorare la piattaforma MediaWiki, visita [http://usability.wikimedia.org la wiki del progetto usabilità] per ulteriori informazioni.",
	'prefswitch-main-anon' => '===Torna alla vecchia interfaccia===
Se vuoi disattivare le nuove funzionalità, [$1 clicca qui]. Ti sarà chiesto di entrare o di creare un account.',
	'prefswitch-main-on' => '===Torna alla vecchia interfaccia===
[$2 Clicca qui per disattivare le nuove funzionalità].',
	'prefswitch-main-off' => '===Provale!===
Se vuoi attivare le nuove funzioni, [$1 clicca qui].',
	'prefswitch-survey-intro-feedback' => 'Ci piacerebbe ascoltare il tuo parere.
Per favore, compila il seguente sondaggio facoltativo prima di cliccare "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Grazie per aver provato le nostre nuove funzioni.
Per aiutarci a migliorarle, per favore riempi il seguente questionario facoltativo prima di fare clic su "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Coordinamento/Usabilità',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Iwai.masaharu
 * @author 青子守歌
 */
$messages['ja'] = array(
	'prefswitch' => '使用性改善の設定スイッチ',
	'prefswitch-desc' => '利用者が個人設定の組み合わせを切り替えられるようにする',
	'prefswitch-link-anon' => '新機能',
	'tooltip-pt-prefswitch-link-anon' => '新機能について学ぶ',
	'prefswitch-link-on' => '以前の状態に戻す',
	'tooltip-pt-prefswitch-link-on' => '新機能を無効化する',
	'prefswitch-link-off' => '新機能',
	'tooltip-pt-prefswitch-link-off' => '新機能を試す',
	'prefswitch-jswarning' => '外装を変更した後は、自分の[[User:$1/$2.js|$2 JavaScript]]を、[[{{ns:user}}:$1/vector.js]]<!--と[[{{ns:user}}:$1/common.js]]-->へコピーするのを忘れないでください。',
	'prefswitch-csswarning' => '[[User:$1/$2.css|$2でのカスタムスタイル]]は適用されません。ベクターでのカスタムCSSは、[[{{ns:user}}:$1/vector.css]]で設定してください。',
	'prefswitch-survey-true' => 'はい',
	'prefswitch-survey-false' => 'いいえ',
	'prefswitch-survey-submit-off' => '新機能を停止する',
	'prefswitch-survey-cancel-off' => '新機能の使用を継続したい場合は、$1に戻ってください。',
	'prefswitch-survey-submit-feedback' => 'フィードバックを送る',
	'prefswitch-survey-cancel-feedback' => 'フィードバックを提供したくない場合は、$1に戻ってください。',
	'prefswitch-survey-question-like' => '新機能のどの点が気に入りましたか？',
	'prefswitch-survey-question-dislike' => '新機能のどの点が気に入りませんでしたか？',
	'prefswitch-survey-question-whyoff' => '新機能を停止する理由をお聞かせください。
あてはまるものを全てお選びください。',
	'prefswitch-survey-question-globaloff' => '全ウィキでこの機能を停止しますか？',
	'prefswitch-survey-answer-whyoff-hard' => '使用方法が難しすぎた。',
	'prefswitch-survey-answer-whyoff-didntwork' => '正常に機能しなかった。',
	'prefswitch-survey-answer-whyoff-notpredictable' => '動作が予測不能だった。',
	'prefswitch-survey-answer-whyoff-didntlike-look' => '見た目が好きではなかった。',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => '新しいタブやレイアウトが好きではなかった。',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => '新しいツールバーが好きではなかった。',
	'prefswitch-survey-answer-whyoff-other' => 'その他の理由:',
	'prefswitch-survey-question-browser' => 'ご利用のブラウザをお答えください。',
	'prefswitch-survey-answer-browser-other' => 'その他のブラウザ:',
	'prefswitch-survey-question-os' => 'ご利用のOSをお答えください。',
	'prefswitch-survey-answer-os-other' => 'その他のオペレーティングシステム:',
	'prefswitch-survey-answer-globaloff-yes' => 'はい、全ウィキでこの機能を停止してください。',
	'prefswitch-survey-question-res' => 'ご使用中の画面の解像度をお答えください。',
	'prefswitch-title-on' => '新機能',
	'prefswitch-title-switched-on' => 'お楽しみください！',
	'prefswitch-title-off' => '新機能を停止する',
	'prefswitch-title-switched-off' => 'ありがとうございました',
	'prefswitch-title-feedback' => 'フィードバック',
	'prefswitch-success-on' => '新機能を有効にしました。新機能をお楽しみください。元に戻したいときは、ページ一番上の「[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]」をクリックしてください。',
	'prefswitch-success-off' => '新機能を停止しました。新機能をお試しいただきありがとうございました。元に戻したいときは、ページ一番上の「[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]」をクリックしてください。',
	'prefswitch-success-feedback' => 'フィードバックが送信されました。',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span>に戻る。',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-ja.png|401px|]]
|-
| ウィキペディアの新しいナビゲーション・インターフェイスのスクリーンショット <small>[[Media:VectorNavigation-ja.png|(拡大)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-ja.png|401px|]]
|-
| 基本的なページ編集インターフェイスのスクリーンショット <small>[[Media:VectorEditorBasic-ja.png|(拡大)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-ja.png|401px|]]
|-
| 新しいリンク挿入用のダイアログボックスのスクリーンショット
|}
|}
ウィキメディア財団のユーザーエクスペリエンスチームはコミュニティのボランティアとともに、より使いやすいサイトを利用者の皆さまにお届けするために努力してまいりました。そして新しい外観や使い勝手、わかりやすくなった編集機能などの改善を皆さまと共有できることを大変うれしく思っています。これらの変更は新規利用者が参加しやすいようにするためのものであり、私たちが[http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study 昨年に行ったユーザビリティ検査]に基づいています。私たちのプロジェクトの操作性を改善することは、ウィキメディア財団の優先課題の一つであり、今後も更なる更新を実施していく予定です。詳細は、[http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Wikimedia blog]の関連投稿（英語）をご覧ください。

=== 今回の変更点は以下の通りです ===
* '''ナビゲーション:''' ページの閲覧・編集時のナビゲーションを改善しました。各ページの上部のタブは、閲覧中の画面がページ本体なのかそのトークページ（ノートページ）なのか、あるいは現在閲覧中なのか編集中なのかをよりはっきりと示すようになりました。
* '''編集ツールバーの改善:''' 編集ツールバーを再編して、より使いやすくしました。ページの整形がより簡単に、かつ直感的に行なえるようになっています。
* '''リンクウィザード:''' ウィキペディア内の他のページや外部サイトへのリンクを追加できる、使いやすいツールを備えました。
* '''検索機能の改善:''' 検索結果の候補予想の提示を改善し、お探しのページにより素早くたどり着けるようにしました。
* '''その他の新機能:''' その他にも、ページ編集を簡潔化するために、表の作成を簡単にする表ウィザード、検索・置換機能を追加しました。
* '''ウィキペディアのロゴ''': ロゴを更新しました。詳細は [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Wikimedia blog]（英語）をご覧ください。",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}}タブ'''は、星型のマークになっています。
* '''{{int:move}}タブ'''は、検索窓の隣にあるドロップダウンの中にあります。",
	'prefswitch-main-feedback' => '=== フィードバック ===
私たちにあなたのご意見をぜひお聞かせください。[[$1|フィードバック用のページ]]を訪れるか、もし私たちがソフトウェアを改善するために現在行っている取り組みに興味がおありならば、[http://usability.wikimedia.org ユーザビリティ・ウィキ]を訪れていただければより詳しい情報が得られます。',
	'prefswitch-main-anon' => '===以前の状態に戻す===
新機能の数々を停止したい場合、[$1 こちらをクリック]してください。まずログインするかアカウントを作るか尋ねられます。',
	'prefswitch-main-on' => '===もとに戻す===
[$2 新機能を停止したい場合は、ここをクリックしてください]。',
	'prefswitch-main-off' => '===お試しください！===
新機能を有効にしたい場合は、[$1 ここをクリック]してください。',
	'prefswitch-survey-intro-feedback' => 'ご意見をぜひお聞かせください。
「[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]」をクリックする前に、下記の調査に任意でご協力ください。',
	'prefswitch-survey-intro-off' => '新機能をお試しいただきありがとうございます。
更なる改善のために、「[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]」をクリックする前に下記の調査に任意でご協力ください。',
	'prefswitch-feedbackpage' => 'Project:WUI/F',
);

/** Lojban (Lojban)
 * @author Ruzihm
 */
$messages['jbo'] = array(
	'prefswitch-survey-true' => "go'i",
	'prefswitch-survey-false' => "na go'i",
	'prefswitch-survey-submit-off' => 'fanta le ninytcila',
	'prefswitch-survey-cancel-off' => ".i go do djica lo nu do pilno le ninytcila gi .e'o ko se'ixru $1",
	'prefswitch-survey-submit-feedback' => 'benji lo terspu',
	'prefswitch-survey-answer-whyoff-hard' => ".i lo ka le ninytcila cu nandu kei pu zunti lo pu'u mi pilno",
	'prefswitch-survey-answer-whyoff-didntwork' => '.i le ninytcila pu spofu',
	'prefswitch-survey-answer-whyoff-notpredictable' => '.i le ninytcila pu cunso',
	'prefswitch-survey-answer-whyoff-didntlike-look' => '.i mi na pu se melbi lo ninytcila',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => ".i mi pu na nelci le cnino selpla je pagyca'o",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => '.i mi pu na nelci le cnino samtcikajna',
	'prefswitch-survey-answer-whyoff-other' => ".i drata crinu zo'u",
	'prefswitch-survey-question-browser' => ".i ma cmene lo do kibyca'o",
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Crt
 * @author ITshnik
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'prefswitch' => 'გამოყენებადობის ინიციატივის კონფიგურაციის გადართვა',
	'prefswitch-desc' => 'აძლევს ნებართვას მომხმარებლებს გადართონ კონფიგურაცია',
	'prefswitch-link-anon' => 'ახალი შესაძლებლობები',
	'tooltip-pt-prefswitch-link-anon' => 'გაიგეთ მეტი ახალ შესაძლებლობებზე',
	'prefswitch-link-on' => 'გასვლა',
	'tooltip-pt-prefswitch-link-on' => 'ახალი შესაძლებლობების გამორთვა',
	'prefswitch-link-off' => 'ახალი შესაძლებლობები',
	'tooltip-pt-prefswitch-link-off' => 'სცადეთ ახალი ხელსაწყოები',
	'prefswitch-survey-true' => 'ჰო',
	'prefswitch-survey-false' => 'არა',
	'prefswitch-survey-submit-off' => 'გათიშეთ ახალი შესაძლებლობები',
	'prefswitch-survey-cancel-off' => 'თუ გსურთ გააგრძელოთ ბეტას გამოყენება, შეგიძლიათ დაბრუნდეთ  $1-ზე.',
	'prefswitch-survey-submit-feedback' => 'გამოხმაურება',
	'prefswitch-survey-cancel-feedback' => 'თუ არ გსურთ პროტოტიპზე გამოხმაურების დატოვება, უბრალოდ დაბრუნდით $1.',
	'prefswitch-survey-question-like' => 'რა მოგეწონათ ახალ შესაძლებლობებში?',
	'prefswitch-survey-question-dislike' => 'რა არ მოგეწონათ ახალ შესაძლებლობებში?',
	'prefswitch-survey-question-whyoff' => 'რატომ თიშავთ ახალ შესაძლებლობებს?
გთხოვთ აირჩიოთ პასუხი.',
	'prefswitch-survey-answer-whyoff-hard' => 'ძალიან რთული იყო გამოსაყენებლად.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'ის გაუმართავი იყო.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'იგი გაუთვალისწინებლად მოქმედებდა.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'არ მომწონდა მისი გარეგნობა.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'არ მომეწონა ახალი ყუები და განლაგება.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'მე არ მომეწონა რედაქტირების პანელი.',
	'prefswitch-survey-answer-whyoff-other' => 'სხვა მიზეზი:',
	'prefswitch-survey-question-browser' => 'რომელ ბრაუზერს იყენებთ?',
	'prefswitch-survey-answer-browser-other' => 'სხვა ბრაუზერი:',
	'prefswitch-survey-question-os' => 'რომელ ოპერაციულ სისტემას იყენებთ?',
	'prefswitch-survey-answer-os-other' => 'სხვა ოპერაციული სისტემა:',
	'prefswitch-survey-question-res' => 'თქვენი მონიტორის გაფართოება:',
	'prefswitch-title-on' => 'ახალი შესაძლებლობები',
	'prefswitch-title-switched-on' => 'ისიამოვნეთ!',
	'prefswitch-title-off' => 'გათიშეთ ახალი შესაძლებლობები',
	'prefswitch-title-switched-off' => 'მადლობა',
	'prefswitch-title-feedback' => 'კონტაქტი',
	'prefswitch-success-on' => 'ახალი შესაძლებლობები ჩაირთო. ვიმედოვნებთ, ისიამოვნებთ მათი გამოყენებით. თქვენ ყოველთვის შეგიძლიათ გამორთათ ისინი ამ გვერდის თავში მდებარე ბმულზე "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]"',
	'prefswitch-success-off' => 'ახალი ფუნქციები ამჟამად გამორთულია. მადლობთ ახალი შესაძლებლობების მოსინჯვისათვის. თქვენ ყოველთვის შეგიძლიათ ჩართათ ისინი ამ გვერდის თავში მდებარე ბმულზე "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" დაწკაპებით.',
	'prefswitch-success-feedback' => 'თქვენი გამოხმაურება გაგზავნილია.',
	'prefswitch-return' => '<hr style="clear:both">
დაბრუნება <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-ka.png|401px|]]
|-
|  ვიკიპედიის ეკრანის ახალი სანავიგაციო ინტერფეისი <small>[[Media: VectorNavigation-ka.png| (გადიდება)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-ka.png|401px|]]
|-
| გვერდის რედაქტირების ძირითადი ინტერფეისი<small>[[Media: VectorEditorBasic-ka.png | (გადიდება)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-ka.png|401px|]]
|-
|ბმულების შექმნის დიალოგიი
|}
|}

\"ფონდ ვიკიმედიაში\" მუშაობს \"ვიკიპედიის\" გამოყენების ანალიზის ჯგუფი, რომელიც ვიკიპედიის საზოგადოების მოხალისეებთან ერთად ცდილობენ ვიკიპედიაში მუშაობის გაადვილებას. ჩვენ მოხარულნი ვართ გაცნობოთ რამდენიმე ცვლილების შესახებ, მათ შორის ახალი ინტერფეისისა და რედაქტირების გამარტივებული ფუნქციების შესახებ. ეს ცვლილებები შემოტანილია ახალი მომხმარებლებისთვის სამუშაოს გასამარტივებლად, ისინი ეფუძნებიან [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study წინა წელს ჩატარებულ მოხერხებულობის ტესტირებას]. ჩვენი საიტებისთვის ახალი დიზაინის შექმნა მიიჩნევა პრიორიტეტულად, და ჩვენ გავაგრძელებთ პროექტის გაუმჯობესებას მომავალშიც. დამატებით შეგიძლიათ ნახოთ [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/  ვიკიმედიის ბლოგი].

=== ცვლილებები ===

* '''ნავიგაცია.''' ჩვენ გავაუმჯობესეთ გვერდების კითხვისა და რედაქტირების ნავიგაცია.
* '''რედაქტირების პანელის გაუმჯობესება.''' ჩვენ შევცვალეთ რედაქტირების პანელის სახე, რისი მეშვეობითაც მისი გამოყენება გამარტივდა.
* '''ბმულების ოსტატი.''' გამოსაყენებლად მარტივი ხელსაწყოს მეშვეობით გამარტივდა ბმულების ჩასმა როგორც  ვიკი გვერდებზე, ასევე გარე საიტებზე.
* '''ძიების გაუმჯობესება.''' ჩვენ გავაუმჯობესეთ ძიებისკარნახები, რათა გამარტივდეს საჭირო გვერდის პოვნა.
* '''დამატებითი ახალი ფუნქციები.''' ჩვენ ასევე გავაკეთეთ ტაბულების ოსტატი, რათა გაგიმარტივოთ ტაბულების შექმნა ვიკიპედიაში.
* '''თანამედროვე ლოგო.''' ჩვენ შევიცვალეთ ლოგო - დაწვრილებით იხილეთ [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d~~V ვიკიმედიის ბლოგში].",
	'prefswitch-main-feedback' => '=== კავშირი ===
ჩვენთვის საინტერესოა თქვენი მოსაზრებების მოსმენა. იხილეთ ჩვენთან [[$1|კავშირის გვერდი]]. თუ თქვენ გაინტერესებთ ვიკიპედიის გაუმჯობესება, ეწვიეთ [http://usability.wikimedia.org მოხერხებულობის პროექტის ვიკის].',
	'prefswitch-main-anon' => '===დაბრუნება===
თუ გსურთ გამორთოთ ბეტა, [$1 დააჭირეთ აქ]. შემდეგ კი გაიარეთ ავტორიზაცია ან შექმენით ანგარიში.',
	'prefswitch-main-on' => '==დააბრუნეთ როგორც იყო!==
[$2 აქ დააჭირეთ ახალი შესაძლებლობების გასათიშად].',
	'prefswitch-main-off' => '=== მოსინჯეთ! ===
თუ გსურთ, რომ ჩართათ ახალი ფუნქციები, [$1 აქ დააწკაპუნეთ].',
	'prefswitch-survey-intro-feedback' => 'ჩვენ გვსურს თქვენი მოსაზრებების წაკითხვა.
გთხოვთ უპასუხოთ რამდენიმე არასავლდებულო შეკითხვას ქვემოთ, სანამ დააწკაპუნებთ "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" ღილაკს.',
	'prefswitch-survey-intro-off' => 'გმადლობთ ახალი შესაძლებლობების ტესტირებისთვის.
თუ გსურთ დაგვეხმაროთ მათ გაუმჯობესებაში, გთხოვთ უპასუხოთ რამდენიმე კითხვას სანამ დააჭერთ «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».',
	'prefswitch-feedbackpage' => 'Project:ბეტა/ახალი შესაძლებლობები/გამოხმაურებები',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'prefswitch-link-anon' => 'មុខងារពិសេសថ្មីៗ',
	'prefswitch-link-on' => 'ប្រើស៊េរីចាស់វិញ',
	'tooltip-pt-prefswitch-link-on' => 'មិនប្រើមុខងារពិសេសថ្មីៗ',
	'prefswitch-link-off' => 'មុខងារពិសេសថ្មីៗ',
	'tooltip-pt-prefswitch-link-off' => 'សាកប្រើមុខងារពិសេសថ្មីៗ',
	'prefswitch-main-anon' => '===ប្រើស៊េរីចាស់វិញ===
[$1 ចុចលើទីនេះដើម្បីបិទមុខងារពិសេសថ្មីៗ]។ អ្នកនឹងត្រូវស្នើអោយកត់ឈ្មោះចូលឬបង្កើតគណនីជាមុន។',
	'prefswitch-main-on' => '===ប្រើស៊េរីចាស់វិញ===
[$2 ចុចលើទីនេះដើម្បីបិទមុខងារពិសេសថ្មីៗ]។',
	'prefswitch-main-off' => '===សាកប្រើស៊េរីថ្មី===
[$1 ចុចលើទីនេះដើម្បីប្រើមុខងារពិសេសថ្មីៗ]។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'prefswitch-survey-answer-whyoff-other' => 'ಇತರ ಕಾರಣ:',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Devunt
 * @author Gapo
 * @author IRTC1015
 * @author Kwj2772
 */
$messages['ko'] = array(
	'prefswitch' => 'Usability Initiative 환경 설정 바꾸기',
	'prefswitch-desc' => '사용자가 여러 설정을 한번에 바꿀 수 있도록 함',
	'prefswitch-link-anon' => '새 기능',
	'tooltip-pt-prefswitch-link-anon' => '새 기능에 대해 알아보기',
	'prefswitch-link-on' => '돌아가기',
	'tooltip-pt-prefswitch-link-on' => '새 기능 끄기',
	'prefswitch-link-off' => '새 기능',
	'tooltip-pt-prefswitch-link-off' => '새 기능 체험하기',
	'prefswitch-jswarning' => '스킨을 바꾸면 자신의 [[User:$1/$2.js|$2용 자바스크립트]]를 [[User:$1/vector.js]]나 [[User:$1/common.js]]에 복사해야 스크립트가 계속 동작합니다.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|사용자 $2 스타일시트]]는 더 이상 적용되지 않습니다. 벡터 스킨용 스타일시트는 [[User:$1/vector.css]]에 추가하실 수 있습니다.',
	'prefswitch-survey-true' => '예',
	'prefswitch-survey-false' => '아니오',
	'prefswitch-survey-submit-off' => '새로운 기능 끄기',
	'prefswitch-survey-cancel-off' => '새 기능을 계속 사용하시려면, $1(으)로 돌아가실 수 있습니다.',
	'prefswitch-survey-submit-feedback' => '피드백 남기기',
	'prefswitch-survey-cancel-feedback' => '피드백을 제공하고 싶지 않다면 $1(으)로 돌아가시면 됩니다.',
	'prefswitch-survey-question-like' => '새 기능에 대해서 어떤 점이 좋았습니까?',
	'prefswitch-survey-question-dislike' => '새 기능에 대해 어떤 점이 마음에 들지 않으셨습니까?',
	'prefswitch-survey-question-whyoff' => '새로운 기능을 끄는 이유가 무엇인가요?
해당하는 모든 항목을 선택해주세요.',
	'prefswitch-survey-question-globaloff' => '모든 위키에서 새 기능을 끄고 싶으십니까?',
	'prefswitch-survey-answer-whyoff-hard' => '사용하기에 너무 어렵다.',
	'prefswitch-survey-answer-whyoff-didntwork' => '기능이 제대로 작동하지 않는다.',
	'prefswitch-survey-answer-whyoff-notpredictable' => '기능이 예상한 대로 동작하지 않는다.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => '전체적인 모양이 마음에 들지 않는다.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => '새 탭과 레이아웃이 마음에 들지 않는다.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => '새 툴바가 마음에 들지 않는다.',
	'prefswitch-survey-answer-whyoff-other' => '다른 이유:',
	'prefswitch-survey-question-browser' => '어떤 웹 브라우저를 사용하고 있나요?',
	'prefswitch-survey-answer-browser-other' => '다른 브라우저:',
	'prefswitch-survey-question-os' => '어떤 운영 체제(OS)를 사용하고 있나요?',
	'prefswitch-survey-answer-os-other' => '다른 운영 체제:',
	'prefswitch-survey-answer-globaloff-yes' => '예, 모든 위키에서 새 기능을 끄겠습니다.',
	'prefswitch-survey-question-res' => '어느 정도의 모니터 해상도를 사용하고 있나요?',
	'prefswitch-title-on' => '새 기능',
	'prefswitch-title-switched-on' => '즐겁게 이용하십시오!',
	'prefswitch-title-off' => '새 기능 끄기',
	'prefswitch-title-switched-off' => '감사합니다.',
	'prefswitch-title-feedback' => '피드백',
	'prefswitch-success-on' => '새 기능이 켜졌습니다. 새 기능을 즐겁게 사용할 수 있기를 바랍니다. 페이지의 맨 위에 "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]"를 눌러 새 기능을 끌 수 있습니다.',
	'prefswitch-success-off' => '새 기능이 꺼졌습니다. 새 기능을 사용해 주셔서 감사합니다. 페이지의 맨 위에 있는 "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]"를 눌러 언제든지 새 기능을 켤 수 있습니다.',
	'prefswitch-success-feedback' => '당신의 피드백을 보냈습니다.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span>(으)로 돌아갑니다.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-ko.png|401px|]]
|-
| 새로운 둘러보기 탭의 스크린샷 <small>[[Media:VectorNavigation-ko.png|(확대)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-ko.png|401px|]]
|-
| 향상된 편집 툴바의 스크린샷 <small>[[Media:VectorEditorBasic-ko.png|(확대)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-ko.png|401px|]]
|-
| 새로운 편집 대화상자의 스크린샷
|}
|}
우리는 사용자를 더욱 편리하게 하기 위해 노력하고 있습니다. 새로운 스킨과 간단해진 편집 기능을 포함한 개선 사항을 보여 주게 되어 영광입니다. 프로젝트 이용을 편리하게 하는 것은 위키미디어 재단의 주 목표이며 나중에 더 많은 업데이트를 제공할 것입니다. 자세한 내용은 [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ 위키미디어 블로그의 게시글]을 참고하십시오.

===새롭게 바뀐 점===
* '''둘러보기''': 문서 읽기와 편집에 대한 둘러보기 메뉴가 향상되었습니다. 각 문서의 상단의 탭이 당신이 일반 문서를 보고 있는지 토론 문서를 보고 있는지, 문서를 읽고 있는지 편집하고 있는지 명확하게 나타내게 됩니다.
* '''편집 툴바 향상''':  편집 툴바를 더욱 사용하기 쉽게 재구성했습니다. 이제 문서를 꾸미는 것이 더욱 간단하고 쉬워질 것입니다.
* '''링크 마법사''':  다른 문서나 외부로 링크를 쉽게 걸 수 있도록 도와줍니다.
* '''검색 기능 향상''': 찾는 문서를 더욱 쉽게 찾을 수 있도록 검색어 제안 기능을 향상시켰습니다.
* '''다른 새로운 기능''':  표를 쉽게 만들 수 있도록 표 마법사와 문서 편집을 간단하게 하기 위해 찾아 바꾸기 기능을 도입했습니다.
* '''위키백과 로고 ''': 위키백과 로고를 새롭게 바꿨습니다. [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ 위키미디어 블로그]에서 자세히 알아보십시오.",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} 탭'''이 별로 바뀌었습니다.
* '''{{int:move}} 탭'''이 검색창 옆의 드롭다운 메뉴로 옮겨졌습니다.",
	'prefswitch-main-feedback' => '=== 의견이 있으신가요? ===
저희는 여러분의 의견을 듣고 싶습니다. 저희 [[$1|피드백 페이지]]를 방문하시거나, 만약 이 소프트웨어를 발전시키려는 저희의 노력에 관심있으시다면, 저희 [http://usability.wikimedia.org usability 위키]를 방문하셔서 더 알아보세요.',
	'prefswitch-main-anon' => '===돌아갈래요===
새 기능을 끄기를 원하신다면 [$1 여기]를 클릭해주세요. 로그인하거나 계정을 먼저 생성하여야 합니다.',
	'prefswitch-main-on' => '===돌아갈래요!===
[$2 새 기능을 끄려면 여기를 클릭하세요.]',
	'prefswitch-main-off' => '===새 기능을 써 보세요!===
새 기능을 켜려면 [$1 여기]를 클릭해주세요.',
	'prefswitch-survey-intro-feedback' => '당신에게 피드백을 받고자 합니다.
"[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]"을 누르기 전에 아래의 설문 조사에 답해주세요.',
	'prefswitch-survey-intro-off' => '새 기능을 사용해 주셔서 감사합니다.
기능을 향상시키는 것을 돕기 위해 "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"를 누르기 전에 아래 설문 조사에 답해 주세요.',
	'prefswitch-feedbackpage' => 'Project:사용자 경험 피드백',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 * @author Къарачайлы
 */
$messages['krc'] = array(
	'prefswitch' => 'Юзабилити башламчылыкъны джарашдырыуларын тюрлендириучю',
	'prefswitch-desc' => 'Къошулуучулагъа джарашдырыуланы тюрлендирирге къояды',
	'prefswitch-link-anon' => 'Джангы амалла',
	'tooltip-pt-prefswitch-link-anon' => 'Джангы амалланы таныгъыз',
	'prefswitch-link-on' => 'Мени ызыма элт',
	'tooltip-pt-prefswitch-link-on' => 'Джангы амалланы джукълат',
	'prefswitch-link-off' => 'Джангы амалла',
	'tooltip-pt-prefswitch-link-off' => 'Джангы амалланы сынагъыз',
	'prefswitch-jswarning' => 'Эсигизде болсун, интерфейсни темасын тюрлендирген бла, сизни  [[User:$1/$2.js|$2 JavaScript]] файлыгъыз, андан ары да ишлер ючюн, [[{{ns:user}}:$1/vector.js]] файлгъа копия этилирге керекди<!-- неда [[{{ns:user}}:$1/common.js]]-->.',
	'prefswitch-csswarning' => 'Сизни [[User:$1/$2.css|«$2» темагъа энчи стиллеригиз]] энди хайырланныкъ тюлдюле. «Вектор» интерфейс темагъа [[{{ns:user}}:$1/vector.css]] файлда сиз энчи CSS къошаргъа боллукъсуз.',
	'prefswitch-survey-true' => 'Хоу',
	'prefswitch-survey-false' => 'Огъай',
	'prefswitch-survey-submit-off' => 'Джангы амалланы джукълат',
	'prefswitch-survey-cancel-off' => 'Мындан ары да джангы амалланы хайырланыргъа излей эсегиз, къайтыргъа боллукъсуз: $1.',
	'prefswitch-survey-submit-feedback' => 'Оюмугъузну ийигиз',
	'prefswitch-survey-cancel-feedback' => 'Прототипни юсюнден оюмугъузну къояргъа излемей эсегиз, $1 бетге къайтыргъа боллукъсуз.',
	'prefswitch-survey-question-like' => 'Джангы амалланы несин джаратдыгъыз?',
	'prefswitch-survey-question-dislike' => 'Джангы амалланы несин джаратмадыгъыз?',
	'prefswitch-survey-question-whyoff' => 'Джангы амалланы нек джукълатдыгъыз?
Келишген вариантланы сайлагъыз.',
	'prefswitch-survey-question-globaloff' => 'Бу амалны глобал халда джукълатыргъа излеймисиз?',
	'prefswitch-survey-answer-whyoff-hard' => 'Хайырланнган асыры къыйынды.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Тюзюуюн ишлемейдиле.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Алгъадан билмезча ишлейдиле.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Кёрюнюмюн джаратмайма.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Джангы тиекле бла вёрсткасын джаратмадым.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Джангы редакторлау панелни джаратмадым.',
	'prefswitch-survey-answer-whyoff-other' => 'Башха чурум:',
	'prefswitch-survey-question-browser' => 'Къайсы браузерни хайырланасыз?',
	'prefswitch-survey-answer-browser-other' => 'Башха браузер',
	'prefswitch-survey-question-os' => 'Къайсы операция системаны хайырландырасыз?',
	'prefswitch-survey-answer-os-other' => 'Башха операция система:',
	'prefswitch-survey-answer-globaloff-yes' => 'Хоў, бу амалны бютеў викиледе да джукълат.',
	'prefswitch-survey-question-res' => 'Экраныгъызны разрешениеси къалайды?',
	'prefswitch-title-on' => 'Джангы амалла',
	'prefswitch-title-switched-on' => 'Хайырланыгъыз!',
	'prefswitch-title-off' => 'Джангы амалланы джукълат',
	'prefswitch-title-switched-off' => 'Сау болугъуз',
	'prefswitch-title-feedback' => 'Бери билдириу',
	'prefswitch-success-on' => 'Джангы амалла джандырылгъындыла. Джангы функцияланы хайырланнганны джаратырыкъсыз деб ышанабыз. Сиз хар къуру да джукълатыргъа боллукъсуз аланы бетни башында «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» джибериуге басыб.',
	'prefswitch-success-off' => 'Джангы амалла джукълатылгъандыла. Джангы функцияланы сынаб кёргенигиз ючюн сау болугъуз. Сиз хар къуру да ызына джандырыргъа боллукъсуз аланы бетни башында «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]» джибериуге басыб.',
	'prefswitch-success-feedback' => 'Сизни оюмугъуз ашырылды.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]ге къайт</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-krc.png|401px|]]
|-
| Википедияны навигациясыны джангы интерфейсини кёрюнюмю <small>[[Media:VectorNavigation-krc.png|(уллу эт)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-krc.png|401px|]]
|-
| Бетлени редакторлаўну баш интерфейсини кёрюнюмю <small>[[Media:VectorEditorBasic-krc.png|(уллу эт)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-krc.png|401px|]]
|-
| Джибериўле къурагъан джангы диалогну кёрюнюмю
|}
|}
«Викимедиа фондда» сайтны хайырланыўун анализ этген  группа ишлейди, вики-джамагъатха къатышханла бла бирге ала сизни Википедия бла эмда башха вики-проектле бла ишлеўюгюзню тынчыракъ этерге кюрешедиле. Талай джангы игилендириўню, аланы ичинде – джангы интерфейс эмда тынчыракъ этилген редакторлаў функцияла, сизге берген бизни къуўандыргъанды. Бу тюрлениўле джангы редакторланы ишлеўлерин тынчыракъ этерге деб этилгендиле, ала [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study ётген джылда бардырылгъан юзабилити-тестлениўде тамалланадыла]. Бизни сайтларыбызгъа тынчыракъ интерфейс къураў «Викимедиа фондну» преоритетлеринден бириди, биз проектни энтда игилендиргенлей турлукъбуз. Толуракъ информация [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Викимедияны блогунда] табарыкъсыз.

=== Нени тюрлендиргенбиз ===
* '''Навигация.''' Биз навигацияны игилендиргенбиз, окъургъа эмда бетлени редакторлагъа тынчыракъ этгенбиз. Энди хар бетни баш джанында вкладка бусагъатда не эте тургъаныгъызны тюзюрек ангылатады: бетгеми къарайсыз огъесе сюзюўюне, окъуй турамысыз огъесе редакторлагъанмы этесиз бетни.
* '''Редакторлаў панель.''' Инструмент панелни джангыдан этгенбиз, хайырланыўун тынчыракъ этер ючюн. Энди бетлени форматлаў тынчыракъ эмда ангыралгъа ачыкъ болгъанды.
* '''Джибериўлени мастери.''' Хайырланыўу тынч болгъан инструмент, башха вики-бетлеге элтген эмда тыш сайтлагъан элтген джибериўле къошаргъа мадар береди.
* '''Излеў.''' Излеў юретиўлени игилендиргенбиз, сизни излеген бетигизни теркирек табар мадарыгъыз болурча.
* '''Башха джангы функцияла.''' Таблицалагъа мастер этгенбиз, таблицала тынч къуралырча, дагъыда редакторлаўну тынчыракъ этген, излеў эмда алмашдырыў функция къурагъанбыз.
* '''Логотип.''' Пазл-тобну кёрюнюмюн джангыртханбыз, толуракъ къарагъыз: [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ «Викимедиа фондну» блогу].",
	'prefswitch-main-logged-changes' => "* '''«{{int:watch}}» тиек''' энди джулдуз кюрюмю бла тиекди.
* '''«{{int:move}}» тиек''' энди излеуню тизгинини къатында джайылыннган менюдады.",
	'prefswitch-main-feedback' => '=== Бери билдириу ===
Биз сизни оюмугъузну билирге излейбиз. Бизни [[$1|бери билдириу бетибизни]] кёрюгюз. Программа баджарыуну игилендириу юсюнден энди баргъан ишибизни таныргъа биле эсегиз, [http://usability.wikimedia.org вики юзабилити-проектни] кёрюгюз.',
	'prefswitch-main-anon' => '=== Мени ызыма къайтар ===
Джангы амалланы джукълатыргъа излей эсегиз, [$1 муну басыгъыз]. Сизге алгъа системагъа кирирге неда регистрацияны ётерге теджелликди.',
	'prefswitch-main-on' => '=== Мени ызыма къайтар! ===
Джангы амалланы джукълатыргъа излей эсегиз, [$2 муну басыгъыз].',
	'prefswitch-main-off' => '=== Сынаб кёрюгюз! ===
Джангы амалланы джандырыгъа излей эсегиз, [$1 муну басыгъыз].',
	'prefswitch-survey-intro-feedback' => 'Биз сизни оюмугъузну билирге излейбиз.
Тилейбиз, тюбюрекде берилген талай соруўгъа джуўаб бир беригиз, «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]» тиекни басарыгъызны аллы бла.',
	'prefswitch-survey-intro-off' => 'Джангы амалланы сынаб кёргенигиз ючюн саў болугъуз.
Аланы игилендирир ючюн, тилейбиз, талай соруўгъа джуўаб бир беригиз, «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]» тиекни басарыгъызны аллы бла.',
	'prefswitch-feedbackpage' => 'Project:Джангы интерфейсни юсюнден оюмла',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'prefswitch-title-switched-on' => 'Vill Spaß!',
	'prefswitch-title-off' => 'Donn di neue Müjjelichkheite afschallde',
	'prefswitch-title-switched-off' => 'Mer bedanke uns',
	'prefswitch-title-feedback' => 'Wat meinß_De dohzoh',
	'prefswitch-success-feedback' => 'Ding Meinung es enjescheck',
	'prefswitch-return' => '<hr style="clear:both">
Retuur noh <span class="plainlinks">[$1 $2]</span>.',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author Erdal Ronahi
 */
$messages['ku-latn'] = array(
	'prefswitch-survey-true' => 'Erê',
	'prefswitch-survey-false' => 'Na',
	'prefswitch-survey-answer-browser-other' => 'Geroka din:',
	'prefswitch-title-switched-off' => 'Spas',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'prefswitch' => "Benotzerfrëndlechkeet's-Initiative: Ëmschalte vun den Astellungen",
	'prefswitch-desc' => 'De Benotzer erlaben tësche Gruppe vun Astellungen ëmzeschalten',
	'prefswitch-link-anon' => 'Nei Fonctiounen',
	'tooltip-pt-prefswitch-link-anon' => 'Méi iwwer déi nei Fonctiounen',
	'prefswitch-link-on' => 'Zréck',
	'tooltip-pt-prefswitch-link-on' => 'Nei Fonctiounen ausschalten',
	'prefswitch-link-off' => 'Nei Fonctiounen',
	'tooltip-pt-prefswitch-link-off' => 'Probéiert déi nei Fonctionalitéiten aus',
	'prefswitch-jswarning' => 'Denkt datt mat der Ännerung vum Ausgesinn, Är [[User:$1/$2.js|$2 JavaScript]] muss op [[{{ns:user}}:$1/vector.js]] <!-- oder [[{{ns:user}}:$1/common.js]]--> kopéiert gi fir weider ze fonctionéieren.',
	'prefswitch-csswarning' => 'Är [[User:$1/$2.css|perséinlech $2 Stiler]] ginn net méi benotzt. Dir kënnt personaliséiert CSS fir Vector an  [[{{ns:user}}:$1/vector.css]] derbäisetzen.',
	'prefswitch-survey-true' => 'Jo',
	'prefswitch-survey-false' => 'Neen',
	'prefswitch-survey-submit-off' => 'Déi nei Fonctiounen ausschalten',
	'prefswitch-survey-cancel-off' => 'Wann Dir déi nei Fonctioune weiderbenotze wëllt, kënnt Dir op $1 zeréckgoen.',
	'prefswitch-survey-submit-feedback' => 'Schéckt eis Är Meenung',
	'prefswitch-survey-cancel-feedback' => 'Wann Dir Är Reaktioun net wëllt matdeelen da kënnt dir op $1 zeréckgoen.',
	'prefswitch-survey-question-like' => 'Wat fannt Dir un den neie Fonctioune gutt?',
	'prefswitch-survey-question-dislike' => 'Wat fannt Dir un den neie Fonctiounen net gutt?',
	'prefswitch-survey-question-whyoff' => 'Firwat schalt dir déi nei Fonctiounen aus?
Wielt w.e.g.alles aus wat zoutrëfft.',
	'prefswitch-survey-question-globaloff' => 'Wëllt Dir déi nei Fonctioune global ausschalten?',
	'prefswitch-survey-answer-whyoff-hard' => 'Et war ze komplizéiert fir ze benotzen.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Et huet net uerdentlech fonctionéiert.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Et huet net esou fonctionnéiert wéi  virgesinn.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Et huet mir net gefall wéi et ausgesäit.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Ech hat déi nei Ongleten an den neie  Layout net gär.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ech hunn déi nei Toolbar net gär.',
	'prefswitch-survey-answer-whyoff-other' => 'Anere Grond:',
	'prefswitch-survey-question-browser' => 'Watfir e Browser benotzt Dir?',
	'prefswitch-survey-answer-browser-other' => 'Anere Browser:',
	'prefswitch-survey-question-os' => 'Wafir e Betriibssystem benotzt Dir?',
	'prefswitch-survey-answer-os-other' => 'Anere Betriibssystem:',
	'prefswitch-survey-answer-globaloff-yes' => 'Jo. schalt déi nei Fonctiounen op alle Wikien aus',
	'prefswitch-survey-question-res' => "Wéi ass d'Opléisung vun ärem Ecran?",
	'prefswitch-title-on' => 'Nei Fonctiounen',
	'prefswitch-title-switched-on' => 'Vill Freed!',
	'prefswitch-title-off' => 'Déi nei Fonctiounen ausschalten',
	'prefswitch-title-switched-off' => 'Merci',
	'prefswitch-title-feedback' => 'Är Reaktioun',
	'prefswitch-success-on' => 'Déi nei Fonctioune sinn elo ageschalt. Mir hoffen Iech gefalen déi nei Fonctiounen. Dir kënnt se ëmmer ofschalten wann Dir op den "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" Link uewen op der Säit klickt.',
	'prefswitch-success-off' => 'Nei Fonctioune sinn elo ausgeschalt. Merci datt Dir déi nei Fonctiounen ausprobéiert hutt. Dir kënnt se ëmmer nees aschalten wann Dir op de Link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" uewen op der Säit klickt.',
	'prefswitch-success-feedback' => 'Är Reaktioun gouf geschéckt.',
	'prefswitch-return' => '<hr style="clear:both">
Zréck op <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| E Screenshot vum neien Navigatiounsinterface vu Wikipedia<small>[[Media:VectorNavigation-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| E Screenshot vun der Ännerungsfënster an hirer Basisversioun<small>[[Media:VectorEditorBasic-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| E Screenshot vun der neier Dialogkëscht fir Linken anzeginn
|}
|}
D'Equipe vun der Benotzererfarung vun der Wikimedia Foundation huet mat Fräiwëllege vun der Communautéit zesummegeschafft fir et fir Iech méi einfach ze maachen. Mir si frou fir e puer Verbesserunge bekannt ze maachen, inklusiv vun engem neie ''look and feel'' a vereinfachten Ännerungsfonctiounen. Dës Ännerungen si geduecht fir et neie Mataarbechter méi einfach ze maachen fir unzekommen a si baséieren op eisem [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study Benotzerfrëndlechkeets-Test dee mir d'lescht Joer gemaach hunn]. D'Verbessere vun der Benotzerfrëndlechkeet ass eng vun de Prioritéite vun der Wikimedia Foundation a mir wäerte weider Aktualisatiounen demnächst bekannt ginn. Fir méi Informatiounen, gitt op de Wikimedia [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia Blog].

===Hei ass dat wat geännert huet===
* '''Navigatioun:''' Mir hunn d'Navigatioun fir Säiten ze liesen an z'änneren verbessert. D'Ongleten uewen op all Säit definéiere méi kloer ob een eng Säit oder eng Diskussiounssäit kuckt an ob een eng Säit kuckt oder ännert.
* '''Verbesserunge vun der Ännerungstoolbar:''' Mir hunn d'Ännerungstoolbar reorganiséiert fir se méi einfach kënnen ze benotzen. Elo ass d'Formatéiere vu Säiten méi einfach a méi intuitiv.
* '''Linkwizard:''' En Tool den einfach ze benotzen ass fir Linken op aner Wikipedia-Säiten a Linken op aner Siten dobäizesetzen.
* '''Verbesserunge bei der Sich:''' Mir hunn d'Virschléi bei der Sich verbessert fir datt Dir déi Säit no där Dir sicht méi séier fannt.
* '''Aner nei Fonctiounen:''' Mir hunn och en Assistent fir Tabellen agefouert deen et méi einfach mécht fir Tabellen unzeleeën an eng Sich- an Ersetzungs-Fonctioun fir d'Ännere vu Säiten ze vereinfachen.
* '''Wikipedia Logo''': Mir hunn de Wikipedia-Logo aktualiséiert, liest méi doriwwer am [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Wikimedia Blog.]",
	'prefswitch-main-logged-changes' => "* Den '''{{int:watch}} Tab''' ass elo ee Stäer.
* Den '''{{int:move}} Tab''' ass elo an der Dropdown-Lëscht niewent der Sich-Këscht.",
	'prefswitch-main-feedback' => "===Feedback?===
Mir wiere frou fir vun Iech ze héieren. Kommt w.e.g. op eis [[$1|Feedback-Säit]] oder, wann dir un de weideren Efforte vun eis fir d'Software ze verbesseren, besicht eis [http://usability.wikimedia.org Benotzerfrëndlechkeets-Wiki] fir weider Informatiounen.",
	'prefswitch-main-anon' => "=== Zréck ===
Wann Dir déi nei Fonctiounen ausschalte wëllt,
[$1 klickt hei]. Dir gitt gefrot fir Iech d'éischt anzeloggen oder e Benotzerkont opzemaachen.",
	'prefswitch-main-on' => '===Bréngt mech zréck!===
[$2 klickt w.e.g. hei fir déi nei Fonctiounen auszeschalten].',
	'prefswitch-main-off' => '===Probéiert se aus!===
Wann Dir déi nei Fonctiounen ausprobéiere wëllt, da <span  class="plainlinks">[$1 klickt w.e.g. hei].',
	'prefswitch-survey-intro-feedback' => 'Mir wiere frou vun Iech ze héieren.
Fëllt w.e.g. déi fakultativ Ëmfro hei ënnendrënner aus éier Dir op "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" klickt.',
	'prefswitch-survey-intro-off' => 'Merci datt dir déi nei Fonctiounen ausprobéiert hutt.
Fir eis ze hëllefen besser ze ginn, fëllt w.e.g. déi fakultativ Ëmfro hei ënnendrënner aus éier dir op "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" klickt.',
	'prefswitch-feedbackpage' => 'Project:Benotzer Erfarung Feedback',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'prefswitch' => 'Wissel veurkäöre veur broekbaarheidsinitiatief',
	'prefswitch-desc' => "Maak 't muegelik óm groepinstèllinge te angerw",
	'prefswitch-link-anon' => 'Nuuj meugelikhede',
	'tooltip-pt-prefswitch-link-anon' => 'Info euver nuuj mäögelikhede',
	'prefswitch-link-on' => 'Trök',
	'tooltip-pt-prefswitch-link-on' => 'Zèt nuuj deil oet',
	'prefswitch-link-off' => 'Nuuj meugelikhede',
	'tooltip-pt-prefswitch-link-off' => 'Perbeer nuuj mäögelikhede',
	'prefswitch-jswarning' => "Vergaet neet det mit 't wiezige van 't oeterlik dien [[User:$1/$2.js|JavaScript veur $2]] gekopieerd mót waere nao [[{{ns:user}}:$1/vector.js]] of [[{{ns:user}}:$1/common.js]] om 't nag steeds te laote werke.",
	'prefswitch-csswarning' => 'Dien [[User:$1/$2.css|aangepasde steile veur $2]] zeen neet langer actief.
De kints de CSS-stiele veur Vector aanpasse in de pagina [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Jao',
	'prefswitch-survey-false' => 'Nein',
	'prefswitch-survey-submit-off' => 'Zèt nuuj meugelikhede oet',
	'prefswitch-survey-cancel-off' => 'Esse de nuuj deil wils haje, gank den trök nao $1',
	'prefswitch-survey-submit-feedback' => 'Gaef feedback',
	'prefswitch-survey-cancel-feedback' => 'Es se geine feedback wils gaeve, gank den nao $1',
	'prefswitch-survey-question-like' => 'Waat vónjs se good ane nuuj deil?',
	'prefswitch-survey-question-dislike' => 'Waat vónjs se slech ane nuuj deil?',
	'prefswitch-survey-question-whyoff' => 'Wrom wils se de nuuj meugelikhede oetzètte?
Vink e.t.b. alle meugelikhede die god zeeb aan.',
	'prefswitch-survey-question-globaloff' => "Wils se de meugelikhede veur alle wiki's oetzètte?",
	'prefswitch-survey-answer-whyoff-hard' => 'De meugelikhede ware te lestig int gebroek.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'De meugelikhede deje t neet tegooi.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'De meugelikhede reageerde ónveurspelbaar.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "'t Zoog neet aantrèkkelik oet.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Ich vónj de nuuj tabblajer en t oeterlik neet good.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ich vónj de nuje wirkbalk neet fijn.',
	'prefswitch-survey-answer-whyoff-other' => 'Anger reeje:',
	'prefswitch-survey-question-browser' => "Waatfer 'ne briwser haesse?",
	'prefswitch-survey-answer-browser-other' => 'Angere browser:',
	'prefswitch-survey-question-os' => 'Waatfer systeem gebroeksse?',
	'prefswitch-survey-answer-os-other' => 'Anger system:',
	'prefswitch-survey-answer-globaloff-yes' => "Jao, de meugelikhede veur alle wiki's oetzètte",
	'prefswitch-survey-question-res' => 'Wat isse sjermrizzelusie?',
	'prefswitch-title-on' => 'Nuuj meugelikhede',
	'prefswitch-title-switched-on' => 'Geneet!',
	'prefswitch-title-off' => 'Zèt nuuj meugelikhede oet',
	'prefswitch-title-switched-off' => 'Danke',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'De nuuj meugelikhede zeen noe ingesjakeldj. Weer haope det se d\'r väöl spas aan belaef. Doe kins die ömmer weer oetskakele door te klikken óp de verwiezing "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" baovenaan de pagina.',
	'prefswitch-success-off' => 'De nuuj meugelikhede zeen noe oetgesjakeldj. Danke veur \'t perbere. Doe kins die ömmer weer insjakele door te klikken óp de verwiezing De nuuj meugelikhede zeen noe oetgesjakeldj. Weer haope det se d\'r väöl spas aan belaefs. Doe kins die ömmer weer oetsjakele door te klikken óp de verwiezing "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" baovenaan de pagina.',
	'prefswitch-success-feedback' => 'Diee feedback is verzónje.',
	'prefswitch-return' => '<hr style="clear:both">
Trök nao <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main-logged-changes' => "* t item '''{{int:watch}}''' is noe e sterke.
* t item '''{{int:move}}''' steit noe in 't dropdownmenu naeve 't zeukvenster.",
	'prefswitch-main-feedback' => '=== Feedback? ===
Weer heure gaer van dich.
Bezeuk ozze [[$1|pagina veur feedback]] of gank nao de [http://usability.wikimedia.org broekbaarheidswiki] veur meer informatie es se geïnteresseerd bös in ozze toekomstige planne.',
	'prefswitch-main-anon' => "=== Trök ===
[$1 Klik óm de nuuj deil oet te zètte]. De wörs gevraog veur aanmelden óf aanmake van 'ne conto.",
	'prefswitch-main-on' => '=== Nein, danke! ===
[$2 Klik óm de nuuj deil oet te zètte].',
	'prefswitch-main-off' => '=== Perbeer! ===
[$1 Klik óm de nuuj deil aan te zètte].',
	'prefswitch-survey-intro-feedback' => 'Weer heure gaer van dich.
Vul e.t.b. de optionele vraogelies hieonger in veurdet se kliks op "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Bedank veur \'t oetprobere van de nuuj meugelikhede.
Vul e.t.b. de ongerstaonde vraogelies in om os te helpe ze wiejer te verbaetere veurdet se kliks op "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'prefswitch' => 'Naudojimo iniciatyvos nustatymai',
	'prefswitch-desc' => 'Leidžia naudotojams keisti nustatymus',
	'prefswitch-link-anon' => 'Kas pasikeitė naujoje išvaizdoje?',
	'tooltip-pt-prefswitch-link-anon' => 'Sužinokite daugiau apie naujas funkcijas',
	'prefswitch-link-on' => 'Noriu ankstesnės išvaizdos',
	'tooltip-pt-prefswitch-link-on' => 'Išjungti naujas funkcijas',
	'prefswitch-link-off' => 'Naujos funkcijos',
	'tooltip-pt-prefswitch-link-off' => 'Išbandyti naujas funkcijas',
	'prefswitch-survey-true' => 'Taip',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Išjungti naujas funkcijas',
	'prefswitch-survey-cancel-off' => 'Jei norite toliau naudotis naujomis funkcijomis, galite grįžti į $1.',
	'prefswitch-survey-submit-feedback' => 'Siųsti atsiliepimą',
	'prefswitch-survey-cancel-feedback' => 'Jei nenorite pateikti atsiliepimo, galite grįžti į $1.',
	'prefswitch-survey-question-like' => 'Kas jums patiko naujojoje sąsajoje?',
	'prefswitch-survey-question-dislike' => 'Kas jums nepatiko naujojoje sąsajoje?',
	'prefswitch-survey-question-whyoff' => 'Kodėl jūs išjungiate naujas funkcijas? 
Prašome pasirinkti tai, kas Jums tinka.',
	'prefswitch-survey-question-globaloff' => 'Ar norite, kad naujos funkcijos būtų išjungtos visuose projektuose?',
	'prefswitch-survey-answer-whyoff-hard' => 'Buvo per sunku naudoti',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Funkcijos neveikė tinkamai.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Funkcijos neveikė nuspėjamai.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Man nepatiko funkcijų išvaizda.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Man nepatiko nauji skirtukai ir išdėstymas.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Man nepatiko naujoji įrankių juosta.',
	'prefswitch-survey-answer-whyoff-other' => 'Kita priežastis:',
	'prefswitch-survey-question-browser' => 'Kurią naršyklę naudojate?',
	'prefswitch-survey-answer-browser-other' => 'Kita naršyklė:',
	'prefswitch-survey-question-os' => 'Kurią operacinę sistemą naudojate?',
	'prefswitch-survey-answer-os-other' => 'Kita operacinė sistema:',
	'prefswitch-survey-answer-globaloff-yes' => 'Taip, funkcijas išjungti visuose wiki projektuose.',
	'prefswitch-survey-question-res' => 'Kokia Jūsų ekrano rezoliucija?',
	'prefswitch-title-on' => 'Naujos funkcijos',
	'prefswitch-title-switched-on' => 'Mėgaukitės!',
	'prefswitch-title-off' => 'Išjungti naujas funkcijas',
	'prefswitch-title-switched-off' => 'Ačiū',
	'prefswitch-title-feedback' => 'Atsiliepimas',
	'prefswitch-success-on' => 'Naujos funkcijos įjungtos. Tikimės, kad Jums jos patiks. Bet kada galite jas išjungti paspaudžiant "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" nuorodą puslapio viršuje.',
	'prefswitch-success-off' => 'Naujos funkcijos išjungotos. Ačiū už funkcijų išbandymą. Bet kada galite jas įjungti paspaudžiant "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" nuorodą puslapio viršuje.',
	'prefswitch-success-feedback' => 'Jūsų atsiliepimas išsiųstas.',
	'prefswitch-return' => '<hr style="clear:both">
Grįžti į <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main-anon' => '===Noriu ankstesnės išvaizdos===
[$1 Čia paspaudus, naujos funkcijos bus išjungtos]. Pirma būsite paprašytas prisijungti ar susikurti sąskaitą.',
	'prefswitch-main-on' => '===Noriu ankstesnės išvaizdos===
[$2 Čia paspaudus, naujos funkcijos bus išjungtos].',
	'prefswitch-main-off' => '===Noriu išbandyti!===
[$1 Spauskite čia, norėdami išbandyti naujas funkcijas].',
);

/** Latvian (Latviešu)
 * @author Geimeris
 * @author Papuass
 */
$messages['lv'] = array(
	'prefswitch-link-anon' => 'Jaunas iespējas',
	'tooltip-pt-prefswitch-link-anon' => 'Uzzini vairāk par jaunajām iespējām',
	'prefswitch-link-on' => 'Vecais izskats',
	'tooltip-pt-prefswitch-link-on' => 'Atslēgt jaunās iespējas',
	'prefswitch-link-off' => 'Jaunas iespējas',
	'tooltip-pt-prefswitch-link-off' => 'Izmēģini jaunās iespējas',
	'prefswitch-survey-true' => 'Jā',
	'prefswitch-survey-false' => 'Nē',
	'prefswitch-survey-cancel-off' => 'Ja Jūs vēlaties turpināt izmantot jaunās iespējas, Jūs varat atgriezties $1.',
	'prefswitch-survey-submit-feedback' => 'Nosūtīt atsauksmi',
	'prefswitch-survey-cancel-feedback' => 'Ja Jūs nevēlaties sniegt atsauksmes, Jūs varat atgriezties $1.',
	'prefswitch-survey-question-like' => 'Kas Jums patika jaunajās iespējās?',
	'prefswitch-survey-question-dislike' => 'Kas Jums nepatika jaunajās iespējās?',
	'prefswitch-survey-question-globaloff' => 'Vai Jūs vēlaties, lai jaunās iespējas tiktu izslēgtas visiem Jūsu kontiem?',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Man nepatika jaunās cilnes un izvietojums.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Man nepatika jaunā rīkjosla.',
	'prefswitch-survey-answer-whyoff-other' => 'Cits iemesls:',
	'prefswitch-survey-question-browser' => 'Kādu pārlūkprogrammu tu izmanto?',
	'prefswitch-survey-answer-browser-other' => 'Cits pārlūks:',
	'prefswitch-survey-question-os' => 'Kuru operētājsistēmu tu izmanto?',
	'prefswitch-survey-answer-os-other' => 'Cita operētājsistēma:',
	'prefswitch-survey-question-res' => 'Kāda ir tava ekrāna izšķirtspēja?',
	'prefswitch-title-on' => 'Jaunas iespējas',
	'prefswitch-title-switched-on' => 'Izbaudi!',
	'prefswitch-title-off' => 'Atslēgt jaunās iespējas',
	'prefswitch-title-switched-off' => 'Paldies',
	'prefswitch-title-feedback' => 'Atsauksmes',
	'prefswitch-success-feedback' => 'Tavas atsauksmes ir nosūtītas.',
	'prefswitch-return' => '<hr style="clear:both">
Atgriezties uz <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main-feedback' => '===Atsauksmes?===
Mēs gribētu tās no jums dzirdēt. Lūdzu dodieties uz [[$1|atsauksmju lapu]] vai arī, ja Jūs esat ieinteresēts par mūsu nebeidzamajām pūlēm programmatūras uzlabošanā, dodaties uz mūsu "[http://usability.wikimedia.org usability wiki]" papildus informācijai.',
	'prefswitch-main-anon' => '===Atgriezties atpakaļ===
[$1 Klikšķiniet šeit, lai izslēgtu jaunās iespējas]. Jums tiks lūgts ieiet vai vispirms izveidot savu kontu.',
);

/** Minangkabau (Baso Minangkabau)
 * @author VoteITP
 */
$messages['min'] = array(
	'prefswitch' => 'Peralihan preferensi Inisiatif Kagunoaan',
	'prefswitch-desc' => 'Izinkan pangguno maubah aturan preferensi',
	'prefswitch-link-anon' => 'Corak baru',
	'tooltip-pt-prefswitch-link-anon' => 'Pelajari tentang corak baru',
	'prefswitch-link-on' => 'Bao denai baliak',
	'tooltip-pt-prefswitch-link-on' => 'Pantang corak baru',
	'prefswitch-link-off' => 'Corak baru',
	'tooltip-pt-prefswitch-link-off' => 'Cubo corak baru',
	'prefswitch-jswarning' => 'Ingeklah adonyo parubahan kulit ko, awak [[User:$1/$2.js|$2 JavaScript]] akan disalin ka [[{{ns:user}}:$1/vector.js]] <!-- atau [[{{ns:user}}:$1/common.js]]--> untuak dapek terus digunoan.',
	'prefswitch-csswarning' => 'Awak [[User:$1/$2.css|custom $2 styles]] indak akan dapek dipakai. Awak dapek manambahkab CSS untuak kulit Vektor di [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Yo',
	'prefswitch-survey-false' => 'Indak',
	'prefswitch-survey-submit-off' => 'Corak baru dimatian',
	'prefswitch-survey-cancel-off' => 'Jiko awak ingin taruih manggunoan corak baru, awak dapek baliak ka $1.',
	'prefswitch-survey-submit-feedback' => 'Kirim umpan baliak',
	'prefswitch-survey-cancel-feedback' => 'Jiko awak indak ingin memberikan umpan baliak, awak dapek baliak ka $1.',
	'prefswitch-survey-question-like' => 'Apo yang awak sukoi tentang corak baru ko?',
	'prefswitch-survey-question-dislike' => 'Apo yang awak indak sukoi tentang corak ko?',
	'prefswitch-survey-question-whyoff' => 'Kenapo awak matian corak baru ko?
Harap pilih yang tapek.',
	'prefswitch-survey-question-globaloff' => 'Apo awak ingin corak ko dimatian sejagad',
	'prefswitch-survey-answer-whyoff-hard' => 'Corak terlalu susah untuak digunoan',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Corak indak bafungsi dengan baik',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Corak indak sasuai dengan diharapkan',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Denai indak suko tampilan coraknyo',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Denai indak suko dengan tab baru dan tampilannyo',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Denai indak suko dengan bilah baru.',
	'prefswitch-survey-answer-whyoff-other' => 'Alasan lainnyo:',
	'prefswitch-survey-question-browser' => 'Penjelajah web apo yang awak gunoan?',
	'prefswitch-survey-answer-browser-other' => 'Penjelajah web lainnyo:',
	'prefswitch-survey-question-os' => 'Sistem operasi apo yang awak gunoan?',
	'prefswitch-survey-answer-os-other' => 'Sistem operasi lainnyo:',
	'prefswitch-survey-answer-globaloff-yes' => 'Yo, corak dimatian di semua wiki',
	'prefswitch-survey-question-res' => 'Barapo ukuran resolusi layar awak?',
	'prefswitch-title-on' => 'Corak baru',
	'prefswitch-title-switched-on' => 'Salamaik menikmati!',
	'prefswitch-title-off' => 'Corak baru dimatian',
	'prefswitch-title-switched-off' => 'Tarimo kasih',
	'prefswitch-title-feedback' => 'Umpan baliak',
	'prefswitch-success-on' => 'Corak baru kini lah aktif. Kami harap awak dapek menikmatinyo. Awak dapek kapan sajo mamatiannyo dengan menklik tautan ko "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" pado atas laman.',
	'prefswitch-success-off' => 'Corak baru sudah dimatian. Tarimo kasih sudah mancubonyo. Awak dapek manggunoannyo baliak kapan sajo dengan menklik tautan ko "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" pado atas laman.',
	'prefswitch-success-feedback' => 'Umpan baliak awak sudah terkirim',
	'prefswitch-return' => '<hr style="clear:both">
Baliak ka <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Cuplikan navigasi antarmuka baru Wikipedia <small>[[Media:VectorNavigation-en.png|(pagadang)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Cuplikan antarmuka laman suntingan dasar <small>[[Media:VectorEditorBasic-en.png|(pagadang)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Cuplikan kotak dialog baru untuak mamasuakkan tautan
|}
|}
Tim Berpengalaman Pangguno Yayasan Wikimedia telah bakarajo basamo relawan dari komunitas untuak mambuek sagalonyo jadi mudah untuak awak. Kami senang babagi sajumlah perbaikan, tamasuak tampilan dan gaya baru dan corak penyuntingan yang labiah sederhana. Parubahan ko ditujukan untuak mambuek sagalonyo jadi mudah pulo bagi panyumbang baru untuak mamulai pengalamannyo, dan didasarkan kapado [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study usability testing conducted over the last year]. Membaiki kagunoan proyek-proyek kami ko adolah sebuah kautamoan Yayasan Wikimedia dan kami akan terus babagi pemutakhiran terkini selanjutnya. Untuak labiah lanjut, baco [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog post].

=== Iko apo sajo yang lah kami ubah ===
* '''Navigasi:''' Kami sudah membaiki navigasi untuak laman mambaco dan suntingan. Kini, tab pado bagian atas laman lah tarang memberitahukan awak apokah awak sadang menampilkan laman atau laman ota, dan katiko awak sadang mambaco atau manyuntian laman.
* '''Perbaikan bilah suntingan:''' Kami lah maatur bilah suntingan untuak labih mudah digunoan. Kini, pemformatan laman jadi sederhana dan labiah intuitif.
* '''Sihir tautan:''' Alat yang mudah digunoan yang membolehkan manambah tautan kapado laman wiki lain sarato situs lua lainnyo.
* '''Perbaikan pencarian:''' Kami lah membaiki saran pencarian untuak mambawo awak mencari laman labiah capek.
* '''Corak baru lainnyo:''' Kami juo lah memperkenalkan tabel sihir untuak mambuek tabel labiah mudah dan mencari dan mangganti corak menjadi laman suntingan yang sederhana.
* '''Logo Wikipedia:''' Kami sudah memperbarui logo kami. Baco untuak lanjutnyo di [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog].",
	'prefswitch-main-logged-changes' => "* Kini '''tab {{int:watch}}''' jadi bintang.
* Kini '''tab {{int:move}}''' terletak di menu turunan sasudah bilah pencarian.",
	'prefswitch-main-feedback' => '===Umpan baliak?===
Kami ingin mendengar pandapek awak. Silakan kunjungi kami di [[$1|laman umpan baliak]] atau, jiko awak tertarik pado usaho kami dalam membaiki perangkat lunak ko, kunjungi kami di [http://usability.wikimedia.org usability wiki] untuak maklumat lanjut.',
	'prefswitch-main-anon' => '===Bao denai baliak===
[$1 Klik ko untuak mamatian corak baru]. Awak akan diminta untuak masuak log atau mambuek akun talabiah dulu.',
	'prefswitch-main-on' => '===Bao denai baliak!===
[$2 Klik ko untuak mamatian corak baru].',
	'prefswitch-main-off' => '===Cubolah!===
[$1 Klik ko untuak maaktifkan corak baru].',
	'prefswitch-survey-intro-feedback' => 'Kami ingin mendengar pandapek awak.
Silakah isi pilihan survei di bawah ko sabalun menklik "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Tarimo kasih sudah mancubo corak baru kami.
Untuak membantu kami membaikinyo, silakan isi pilihan survei di bawah ko sabalun menklik "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Umpan baliak pengalaman pangguno',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'prefswitch' => 'Превклучување на нагодувања на Иницијативата за употребливост',
	'prefswitch-desc' => 'Овозможува корисниците да превклучуваат групи нагодувања',
	'prefswitch-link-anon' => 'Нови функции',
	'tooltip-pt-prefswitch-link-anon' => 'Дознајте за новите функции',
	'prefswitch-link-on' => 'Врати ме',
	'tooltip-pt-prefswitch-link-on' => 'Оневозможи нови функции',
	'prefswitch-link-off' => 'Нови функции',
	'tooltip-pt-prefswitch-link-off' => 'Испробајте нови функции',
	'prefswitch-jswarning' => 'Запомнете дека со промената на рувото, вашата [[User:$1/$2.js|$2 javascript]] ќе треба да се прекопира во [[User:$1/vector.js]] или [[User:$1/common.js]] за да продолжи да работи.',
	'prefswitch-csswarning' => 'Вашите [[User:$1/$2.css|прилагодени $2 стилови]] повеќе нема да важат. Можете да додавате свои каскадни страници (CSS) за вектор во [[User:$1/vector.css]].',
	'prefswitch-survey-true' => 'Да',
	'prefswitch-survey-false' => 'Не',
	'prefswitch-survey-submit-off' => 'Исклучи нови функции',
	'prefswitch-survey-cancel-off' => 'Ако сакате да продолжите со користење на новите функции, можете да се вратите на $1.',
	'prefswitch-survey-submit-feedback' => 'Ваши примедби',
	'prefswitch-survey-cancel-feedback' => 'Ако не сакате да искажете примедби, можете да се вратите на $1.',
	'prefswitch-survey-question-like' => 'Што ви се допадна кај новите функции?',
	'prefswitch-survey-question-dislike' => 'Што не ви се допадна кај новите функции?',
	'prefswitch-survey-question-whyoff' => 'Зошто ги исклучувате новите функции?
Одберете било колку одговори.',
	'prefswitch-survey-question-globaloff' => 'Дали сакате да ги исклучите можностите глобално?',
	'prefswitch-survey-answer-whyoff-hard' => 'Беше премногу тешко за користење.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Не функционираше како што треба.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Работеше непредвидливо.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Не ми се допадна изгледот.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Не ми се допаднаа новите менија и распоредот.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Не ми се допадна новиот алатник.',
	'prefswitch-survey-answer-whyoff-other' => 'Друга причина:',
	'prefswitch-survey-question-browser' => 'Кој прелистувач го користите?',
	'prefswitch-survey-answer-browser-other' => 'Друг прелистувач:',
	'prefswitch-survey-question-os' => 'Кој оперативен систем го користите?',
	'prefswitch-survey-answer-os-other' => 'Друг оперативен систем',
	'prefswitch-survey-answer-globaloff-yes' => 'Да, исклучи хи можностите на сите викија',
	'prefswitch-survey-question-res' => 'Која ви е резолуцијата на екранот?',
	'prefswitch-title-on' => 'Нови функции',
	'prefswitch-title-switched-on' => 'Уживајте!',
	'prefswitch-title-off' => 'Исклучи нови функции',
	'prefswitch-title-switched-off' => 'Ви благодариме',
	'prefswitch-title-feedback' => 'Примедби',
	'prefswitch-success-on' => 'Новите функции се вклучени. Се надеваме дека ви беше пријатно да ги користите. Секогаш можете повторно да ги исклучите со кликнување на врската „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]“ на врвот од страницата.',
	'prefswitch-success-off' => 'Новите функции се исклучени. Ви благодариме што ги испробавте. Секогаш можете повторно да ги вклучите со кликнување на врската „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]“ на врвот од страницата.',
	'prefswitch-success-feedback' => 'Вашите примедби се испратени.',
	'prefswitch-return' => '<hr style="clear:both">
Назад кон <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:ВекторНавигација.PNG|401px|]]
|-
| Изглед на новиот навигациски посредник на Википедија <small>[[Media:VectorNavigation.png|(зголеми)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:ВекторУредување.PNG|401px|]]
|-
| Изглед на основниот посредник за уредување на страници <small>[[Media:VectorEditorBasic.png|(зголеми)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:ВекторВрски.PNG|401px|]]
|-
| Изглед на новата кутија за внесување врски
|}
|}
Екипата за корисничко искуство на Фондацијата Викимедија работеше со доброволци од заедницата за да ви ги олесни нештата. Со задоволство ве известуваме за направените подобрувања, новиот изглед и чувство, како и упростените функции за уредување. Овие промени имаат за цел да им го олеснат почетокот на новите учесници, и се засноваат на [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study ланските испитувања на употребливоста]. Подобрувањето на употребливоста на проектите претставува приоритет за Фондацијата Викимедија и во иднина ќе продолжиме да ве известуваме за воведените новини. За повеќе информации, посетете го соодветниот [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia блог-напис на Викимедија].

===Еве што променивме===
* '''Навигација:''' Ја подобривме навигацијата за читање и уредување на страниците. Сега менијата над секоја страница појасно укажуваат на тоа дали ја гледате страницата или страница за разговор, и дали ја читате или уредувате страницата.
* '''Подобрен алатник за уредување:'''  Го реорганизиравме алатникот за полесна употреба. Сега форматирањето на страниците е упростено и поинтуитивно.
* '''Помошник за врски:'''  Едноставна алатка која овозможува додавање врски до други вики-страници како и до надворешни мрежни места.
* '''Подобрено пребарување:''' Ги подобривме предлозите при пребарување за што побрзо да ви ја најдеме страницата што ја барате.
* '''Други нови функции:''' Воведовме и помошник за табели со чија помош табелите се прават полесно, а има и можност за пронаоѓање и заменување, со што се упростува уредувањето на страницата.
* '''Лого на Википедија:''' Го подновивме и логото. Прочитајте повеќе на [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d блогот на Викимедија].",
	'prefswitch-main-logged-changes' => "* Јазичето '''{{int:watch}}''' сега изгледа како ѕвезда.
* Јазичето '''{{int:move}}''' сега е сместено во паѓачкото мени веднаш со лентата за пребарување.",
	'prefswitch-main-feedback' => '===Мислења?===
Со задоволство би сакале да го чуеме вашето мислење. Посетете ја [[$1|страницата за мислења]], или пак, ако сте заинтересирани за нашите постојани напори за подобрување на програмот, одете на нашето [http://usability.wikimedia.org вики посветено на употребливоста] и дознајте повеќе.',
	'prefswitch-main-anon' => '===Врати ме===
Ако сакате да ги исклучите новите функции, [$1 кликнете тука]. Ќе ви биде побарано најпрвин да се најавите или да создадете сметка.',
	'prefswitch-main-on' => '===Врати ме!===
Ако сакате да ги исклучите новите функции, [$2 кликнете тука].',
	'prefswitch-main-off' => '===Испробајте ги!===
Ако сакате да ги вклучите новите функции, тогаш [$1 кликнете тука].',
	'prefswitch-survey-intro-feedback' => 'Со задоволство го очекуваме вашето мислење.
Пополнете ја анкетата подолу со тоа што ќе кликнете на „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]“. (незадолжително)',
	'prefswitch-survey-intro-off' => 'Ви благодариме што ги испробавте новите функции.
За да ни помогнете да ги подобриме, пополнете ја анкетата подолу со тоа што ќе кликнете на „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]“. (незадолжително)',
	'prefswitch-feedbackpage' => 'Project:Мислења за новиот изглед',
);

/** Malayalam (മലയാളം)
 * @author Junaidpv
 * @author Praveenp
 * @author Shijualex
 * @author Vssun
 */
$messages['ml'] = array(
	'prefswitch' => 'യൂസബിലിറ്റി ഇനിഷ്യേറ്റീവ് ക്രമീകരണങ്ങൾ മാറുക',
	'prefswitch-desc' => 'ക്രമീകരണങ്ങൾ കൂട്ടത്തോടെ മാറ്റാൻ ഉപയോക്താക്കളെ അനുവദിക്കുന്നു.',
	'prefswitch-link-anon' => 'പുതിയ സവിശേഷതകൾ',
	'tooltip-pt-prefswitch-link-anon' => 'പുതിയ സവിശേഷതകളെക്കുറിച്ച് കൂടുതലറിയുക',
	'prefswitch-link-on' => 'എനിക്കിതു വേണ്ട',
	'tooltip-pt-prefswitch-link-on' => 'പുതിയ സവിശേഷതകൾ പ്രവർത്തനരഹിതമാക്കുക',
	'prefswitch-link-off' => 'പുതിയ സവിശേഷതകൾ',
	'tooltip-pt-prefswitch-link-off' => 'പുതിയ സവിശേഷതകൾ പരീക്ഷിക്കുക',
	'prefswitch-jswarning' => 'ദൃശ്യരൂപം മാറുമ്പോൾ, താങ്കളുടെ  [[User:$1/$2.js|$2 ജാവാസ്ക്രിപ്റ്റ്]] തുടർന്നും പ്രവർത്തിക്കാൻ [[User:$1/vector.js]] അല്ലെങ്കിൽ [[User:$1/common.js]] താളുകളിലൊന്നിലേക്ക് പകർത്തേണ്ടതുണ്ടെന്നോർക്കുക.',
	'prefswitch-csswarning' => 'താങ്കൾ [[User:$1/$2.css|ക്രമീകരിച്ചെടുത്ത $2 സ്റ്റൈലുകൾ]] ഇനി പ്രവർത്തിക്കില്ല. താങ്കൾക്ക് വെക്റ്ററിനായി [[User:$1/vector.css]] താളിൽ ഇച്ഛാനുസരണം സ്റ്റൈലുകൾ ചേർക്കാവുന്നതാണ്.',
	'prefswitch-survey-true' => 'അതെ',
	'prefswitch-survey-false' => 'വേണ്ട',
	'prefswitch-survey-submit-off' => 'പുതിയ സവിശേഷതകൾ പ്രവർത്തനരഹിതമാക്കുക',
	'prefswitch-survey-cancel-off' => 'പുതിയ സവിശേഷതകൾ തുടർന്നും ഉപയോഗിക്കാൻ ആഗ്രഹിക്കുന്നെങ്കിൽ, $1 എന്ന താളിലേയ്ക്ക് മടങ്ങാം.',
	'prefswitch-survey-submit-feedback' => 'അഭിപ്രായം അറിയിക്കുക',
	'prefswitch-survey-cancel-feedback' => 'അഭിപ്രായങ്ങൾ പങ്ക് വെയ്ക്കാനാഗ്രഹമില്ലെങ്കിൽ, താങ്കൾക്ക് $1 എന്ന താളിലേയ്ക്ക് മടങ്ങാം.',
	'prefswitch-survey-question-like' => 'പുതിയ സവിശേഷതകളിൽ എന്താണ് താങ്കൾക്ക് ഇഷ്ടപ്പെട്ടത്?',
	'prefswitch-survey-question-dislike' => 'സവിശേഷതകളിൽ എന്താണ് താങ്കൾക്ക് ഇഷ്ടപ്പെടാതിരുന്നത്?',
	'prefswitch-survey-question-whyoff' => 'പുതിയ സവിശേഷതകൾ എന്തുകൊണ്ടാണ് താങ്കൾ വേണ്ടന്നു വെയ്ക്കുന്നത്?
ബാധകമാകുന്ന എല്ലാം തിരഞ്ഞെടുക്കുക.',
	'prefswitch-survey-question-globaloff' => 'താങ്കൾക്ക് ഈ സവിശേഷതകൾ എല്ലാ വിക്കികളിലും പ്രവർത്തനരഹിതമാക്കണോ?',
	'prefswitch-survey-answer-whyoff-hard' => 'ഇത് ഉപയോഗിക്കാൻ ഏറെ ബുദ്ധിമുട്ടായിരുന്നു.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'ഇത് ശരിയായ വിധത്തിൽ പ്രവർത്തിച്ചില്ല.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'ഇത് വിചാരിക്കുന്നതുപോലെയല്ല പ്രവർത്തിക്കുന്നത്.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'ഇത് കാണാൻ ഒരു രസമില്ല.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'പുതിയ റ്റാബുകളും ദൃശ്യവിന്യാസവും എനിക്കിഷ്ടപ്പെട്ടില്ല.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'പുതിയ റ്റൂൾബാർ എനിക്കിഷ്ടപ്പെട്ടില്ല.',
	'prefswitch-survey-answer-whyoff-other' => 'മറ്റ് കാരണം:',
	'prefswitch-survey-question-browser' => 'ഏതു ബ്രൗസറാണ് താങ്കള്‍ ഉപയോഗിക്കുന്നത്?',
	'prefswitch-survey-answer-browser-other' => 'മറ്റ് ബ്രൗസർ:',
	'prefswitch-survey-question-os' => 'ഏത് ഓപറേറ്റിങ്ങ് സിസ്റ്റമാണ് താങ്കള്‍ ഉപയോഗിക്കുന്നത്?',
	'prefswitch-survey-answer-os-other' => 'മറ്റ് ഓപറേറ്റിങ് സിസ്റ്റം:',
	'prefswitch-survey-answer-globaloff-yes' => 'വേണം, സവിശേഷതകൾ എല്ലാ വിക്കികളിലും പ്രവർത്തനരഹിതമാക്കുക',
	'prefswitch-survey-question-res' => 'താങ്കളുടെ സ്ക്രീന്‍ റെസ‌ല്യൂഷന്‍ എന്താണ്?',
	'prefswitch-title-on' => 'പുതിയത് എന്തൊക്കെ?',
	'prefswitch-title-switched-on' => 'ആസ്വദിക്കൂ!',
	'prefswitch-title-off' => 'പുതിയ സവിശേഷതകൾ പ്രവർത്തനരഹിതമാക്കുക',
	'prefswitch-title-switched-off' => 'നന്ദി',
	'prefswitch-title-feedback' => 'അഭിപ്രായങ്ങൾ',
	'prefswitch-success-on' => 'പുതിയ സവിശേഷതകൾ ഇപ്പോൾ പ്രവർത്തനസജ്ജമാണ്. പുതിയ സവിശേഷതകൾ താങ്കളാസ്വദിക്കുന്നുണ്ടെന്ന് ഞങ്ങൾ വിശ്വസിക്കുന്നു. താങ്കൾക്കവ പ്രവർത്തനരഹിതമാക്കണമെന്നുണ്ടെങ്കിൽ താളിൽ മുകളിലായുള്ള "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" എന്ന കണ്ണി ഞെക്കുക.',
	'prefswitch-success-off' => 'പുതിയ സവിശേഷതകൾ ഇപ്പോൾ പ്രവർത്തനരഹിതമാണ്. പുതിയ സവിശേഷതകൾ പരീക്ഷിച്ചതിനു നന്ദി. താങ്കൾക്ക് അവ വീണ്ടും പ്രവർത്തനസജ്ജമാക്കണമെന്നുണ്ടെങ്കിൽ താളിൽ മുകളിലായുള്ള "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]] എന്ന കണ്ണി ഞെക്കുക.',
	'prefswitch-success-feedback' => 'താങ്കളുടെ അഭിപ്രായങ്ങൾ അയച്ചു.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span> എന്ന താളിലേയ്ക്ക് മടങ്ങുക.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-ml.png|401px|]]
|-
| വിക്കിപീഡിയയുടെ പുതിയ സമ്പർക്കമുഖം, താളുകളിലേയ്ക്കെത്താൻ<br />എങ്ങനെ ഉപയോഗിക്കാം എന്നതിന്റെ സ്ക്രീൻഷോട്ട്<small>[[Media:VectorNavigation-ml.png| (വലുതാക്കുക)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-ml.png|401px|]]
|-
| താൾ തിരുത്താനുള്ള അടിസ്ഥാന സൗകര്യങ്ങളുടെ സ്ക്രീൻഷോട്ട് <small>[[Media:VectorEditorBasic-ml.png| (വലുതാക്കുക)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-ml.png|401px|]]
|-
| കണ്ണികൾ ഉൾപ്പെടുത്താനുള്ള പുതിയ സൗകര്യത്തിന്റെ സ്ക്രീൻഷോട്ട്
|}
|}
വിക്കിമീഡിയ ഫൗണ്ടേഷന്റെ ഉപയോക്തൃ സംതൃപ്തി സംഘം, വിക്കി സമൂഹത്തിൽ നിന്നുമുള്ള ഒരുകൂട്ടം സന്നദ്ധസേവകരോടോപ്പം താങ്കൾക്ക് കാര്യങ്ങൾ ലളിതമാക്കിത്തരാൻ പ്രയത്നിക്കുന്നുണ്ട്. പുതുക്കിയ ദൃശ്യാനുഭവവും ലളിതമാക്കിയ തിരുത്തൽ സൗകര്യവുമടക്കമുള്ള ചില പുതുക്കലുകൾ പങ്ക് വെയ്ക്കാൻ ഞങ്ങളാഗ്രഹിക്കുന്നു.  [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study കഴിഞ്ഞ കൊല്ലം നടത്തിയ പഠനത്തെ ആസ്പദമാക്കി] ഉപയോക്താക്കൾക്ക് കാര്യങ്ങൾ ചെയ്യൽ എളുപ്പമാക്കുക എന്ന ലക്ഷ്യത്തോടെയാണ് ഇവ ചെയ്തിരിക്കുന്നത്. നമ്മുടെ സംരംഭങ്ങളുടെ മെച്ചപ്പെട്ട ഉപയോഗ്യത വിക്കിമീഡിയ ഫൗണ്ടേഷന്റെ ലക്ഷ്യമാണ്, കൂടുതൽ മെച്ചപ്പെടുത്തലുകൾ ഭാവിയിൽ വരാനിരിക്കുന്നു. കൂടുതൽ വിവരങ്ങൾക്ക് [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ വിക്കിമീഡിയ ബ്ലോഗ്] പോസ്റ്റ് സന്ദർശിക്കുക

===ഞങ്ങൾ മാറ്റം വരുത്തിയവ===
* '''നാവിഗേഷൻ:''' താളുകൾ വായിക്കാനും തിരുത്തുവാനുമുള്ള സൗകര്യം മെച്ചപ്പെടുത്തി. ഇപ്പോൾ ഓരോ താളിന്റേയും മുകളിലുള്ള റ്റാബുകൾ താങ്കൾ താളാണോ സംവാദം താളാണോ കാണുന്നത് എന്നും, താങ്കൾ തിരുത്തുകയാണോ വായിക്കുകയാണോ എന്നും വ്യക്തമായി കാണിക്കുന്നു.
* '''തിരുത്തൽ ടൂൾബാർ മെച്ചപ്പെടുത്തലുകൾ:''' ലളിതമായി ഉപയോഗിക്കാവുന്ന വിധത്തിൽ ഞങ്ങൾ തിരുത്തൽ ടൂൾബാർ പുനഃക്രമീകരിച്ചിരിക്കുന്നു. ഇപ്പോൾ താൾ ശരിയായ വിധത്തിൽ വിന്യസിക്കുന്നത് ലളിതവും സ്വാഭാവികവുമായിരിക്കും.
* '''കണ്ണി ചേർക്കൽ:''' ലളിതമായി ഉപയോഗിക്കാവുന്ന ഉപകരണം കൊണ്ട് മറ്റ് വിക്കിപീഡിയ താളുകളിലേയ്ക്കോ പുറത്തുള്ള സൈറ്റുകളിലേയ്ക്കോ കണ്ണികൾ ചേർക്കാൻ താങ്കളെ സഹായിക്കുന്നു.
* '''തിരച്ചിൽ മെച്ചപ്പെടുത്തലുകൾ:''' താങ്കൾ തിരയുന്ന താളിലേയ്ക്ക് പെട്ടെന്ന് എത്തിച്ചേരാവുന്ന വിധത്തിൽ മെച്ചപ്പെടുത്തിയ തിരച്ചിൽ നിർദ്ദേശങ്ങൾ ഉൾപ്പെടുത്തിയിരിക്കുന്നു.
* '''മറ്റ് പുതിയ സവിശേഷതകൾ:''' പട്ടികകൾ ചേർക്കാനായി ഒരു സഹായിയും താൾ തിരുത്തൽ ലളിതമാക്കാൻ വാക്കുകളും മറ്റും കണ്ടെത്തി മാറ്റിച്ചേർക്കാനുള്ള സൗകര്യവും ഉൾപ്പെടുത്തിയിരിക്കുന്നു.
* '''വിക്കിപീഡിയ പസിൽ ഗ്ലോബ്:''' പസിൽ ഗ്ലോബ് പുതുക്കിയിരിക്കുന്നു. കൂടുതൽ [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ വിക്കിമീഡിയ ബ്ലോഗിൽ] വായിക്കുക.",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} ടാബ്''' ഇപ്പോൾ നക്ഷത്രം ആയി കാണാം.
* '''{{int:move}} ടാബ്''' തിരയാനുള്ള പെട്ടിയുടെ സമീപത്തുള്ള ഡ്രോപ്ഡൗൺ മെനുവിൽ കാണാവുന്നതാണ്.",
	'prefswitch-main-feedback' => '===അഭിപ്രായങ്ങൾ?===
താങ്കളിൽ നിന്നവ കേൾക്കാൻ ഞങ്ങൾക്കതിയായ ആഗ്രഹമുണ്ട്. ദയവായി ഞങ്ങളുടെ [[$1|അഭിപ്രായങ്ങൾക്കുള്ള താൾ]] കാണുക അല്ലെങ്കിൽ,  സോഫ്റ്റ്‌‌വേറിലുള്ള പുതിയ മെച്ചപ്പെടുത്തലുകളെ കുറിച്ചറിയാൻ [http://usability.wikimedia.org ഉപയോഗ്യത വിക്കി] സന്ദർശിക്കുക.',
	'prefswitch-main-anon' => '===എനിക്കിതു്‌ വേണ്ട===
പുതിയ സവിശേഷതകൾ ഒഴിവാക്കാൻ താങ്കൾ ആഗ്രഹിക്കുന്നുവെങ്കിൽ, ആദ്യം [$1 ഇവിടെ ഞെക്കി] ലോഗിൻ ചെയ്യുകയോ അംഗത്വമെടുക്കുകയോ ചെയ്യേണ്ടതാണ്.',
	'prefswitch-main-on' => '===എനിക്കിതു്‌ വേണ്ട!===
[$2 ഇവിടെ ഞെക്കി പുതിയ സവിശേഷതകൾ പ്രവർത്തനരഹിതമാക്കുക].',
	'prefswitch-main-off' => '===അവ പരീക്ഷിച്ചു നോക്കൂ!===
പുതിയ സവിശേഷതകൾ പരീക്ഷിച്ചു നോക്കാൻ താങ്കളാഗ്രഹിക്കുന്നുവെങ്കിൽ, ദയവായി [$1 ഇവിടെ ഞെക്കുക].',
	'prefswitch-survey-intro-feedback' => 'താങ്കളുടെ അഭിപ്രായമെന്തെന്നറിയാൻ ഞങ്ങൾക്കതിയായ ആഗ്രഹമുണ്ട്.
ദയവായി താഴെ കൊടുത്തിരിക്കുന്ന ഐച്ഛിക സർവേ പൂരിപ്പിച്ചതിനു ശേഷം "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" ഞെക്കുക.',
	'prefswitch-survey-intro-off' => 'പുതിയ സവിശേഷതകൾ പരീക്ഷിച്ചതിനു നന്ദി.
അവ മെച്ചപ്പെടുത്തുവാൻ ഞങ്ങളെ സഹായിക്കുന്നതിനായി, ദയവായി താഴെ നൽകിയിരിക്കുന്ന ഐച്ഛിക സർവേ പൂരിപ്പിച്ച ശേഷം "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" ഞെക്കുക.',
	'prefswitch-feedbackpage' => 'Project:ഉപയോക്തൃ അനുഭവ അഭിപ്രായങ്ങൾ',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'prefswitch-survey-true' => 'Тийм',
	'prefswitch-survey-false' => 'Үгүй',
	'prefswitch-survey-answer-whyoff-other' => 'Өөр шалтгаан:',
);

/** Marathi (मराठी)
 * @author Mahitgar
 * @author V.narsikar
 * @author अभय नातू
 */
$messages['mr'] = array(
	'prefswitch' => 'ऊपयोगसुलभता उपक्रम पसंती कळ',
	'prefswitch-link-anon' => 'नवीन वैशीष्ट्ये',
	'tooltip-pt-prefswitch-link-anon' => 'नविन चेहरामोहरा जाणुन घ्या',
	'prefswitch-link-on' => 'मला माघारी न्या',
	'tooltip-pt-prefswitch-link-on' => 'नविन चेहरामोहरा अक्षम करा',
	'prefswitch-link-off' => 'नवीन वैशीष्ट्ये',
	'tooltip-pt-prefswitch-link-off' => 'नवी वैशीष्ट्ये वापरून पहा',
	'prefswitch-jswarning' => 'त्वचा बदलताना काम चालू ठेवण्याकरिता तुमची [[User:$1/$2.js|$2 JavaScript]] जावास्क्रीप्ट [[{{ns:user}}:$1/vector.js]] मध्ये नकलावी लागेल <!-- or [[{{ns:user}}:$1/common.js]]--> हे लक्षात घ्या.',
	'prefswitch-csswarning' => 'तुमची [[User:$1/$2.css|custom $2 styles]] यापुढे लागू रहाणार नाही.  व्हेक्टरकरिता  [[{{ns:user}}:$1/vector.css]] मध्ये तुमची custom CSS भरू शकता.',
	'prefswitch-survey-true' => 'होय',
	'prefswitch-survey-false' => 'नाही',
	'prefswitch-survey-submit-off' => 'नविन चेहरामोहरा बंद करा',
	'prefswitch-survey-cancel-off' => 'जर आपणास नविन बीटा चेहरामोहरा वापराणे सुरू ठेवायचे असल्यास $1 कडे परत जा.',
	'prefswitch-survey-submit-feedback' => 'प्रतिसाद पाठवा',
	'prefswitch-survey-cancel-feedback' => 'जर आपणास प्रतिसाद (फिडबॅक) द्यावयाचा नसल्यास, आपण $1 कडे परत जाउ शकता.',
	'prefswitch-survey-question-like' => 'नविन चेहरामोहर्‍याबद्दल आपणास काय आवडले?',
	'prefswitch-survey-question-dislike' => 'नविन  चेहरामोहर्‍याबद्दल आपणास काय नावडले?',
	'prefswitch-survey-question-whyoff' => 'नविन चेहरामोहरा आपण कां बंद करीत आहात?
खालील जे लागु असेल ते निवडा.',
	'prefswitch-survey-answer-whyoff-hard' => 'हा चेहरामोहरा वापरावयास फार कठिण आहे',
	'prefswitch-survey-answer-whyoff-didntwork' => 'नविन चेहरामोहरा चांगल्या तर्‍हेने काम करीत नाही.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'विचार केला होता तसे ते बदल काम करीत नाही.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'मला ते ज्या तर्‍हेने प्रदर्शित झालेत ते आवडले नाही',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => ' मला नविन कळी व ठेवण्या आवडल्या नाहीत',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'मला नविन साधनपट्टी(टूलबार) आवडली नाही.',
	'prefswitch-survey-answer-whyoff-other' => 'इतर कारणे:',
	'prefswitch-survey-question-browser' => 'तुम्ही कोणता न्याहाळक (ब्राऊजर) वापरता ?',
	'prefswitch-survey-answer-browser-other' => 'इतर न्याहाळक(बाउजर):',
	'prefswitch-survey-question-os' => 'आपण कोणती कार्यन प्रणाली (ऑपरेटिंग सिस्टीम) वापरता?',
	'prefswitch-survey-answer-os-other' => 'इतर कार्यन प्रणाली (ऑपरेटिंग सिस्टीम) :',
	'prefswitch-survey-question-res' => 'आपल्या दृश्यपटलाचे पृथक्करण (स्क्रिन रिजोल्युशन) काय आहे?',
	'prefswitch-title-on' => 'नवीन वैशीष्ट्ये',
	'prefswitch-title-switched-on' => 'मजा करा!',
	'prefswitch-title-off' => 'नविन वैशिष्ट्ये बंद करा',
	'prefswitch-title-switched-off' => 'धन्यवाद',
	'prefswitch-title-feedback' => 'प्रतिक्रीया',
	'prefswitch-success-on' => 'नविन चेहरामोहरा सध्या सुरू करण्यात आलेला आहे.या नविन चेहरेपट्टीचा वापर करण्यास आपणास आनंद वाटेल अशी आम्ही आशा करतो.आपण त्यास,पानाच्या वरील भागास असलेल्या "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" या दुव्यावर कधीही टिचकी मारुन त्यास परत बंद करु शकता.',
	'prefswitch-success-off' => 'नविन चेहरामोहरा सध्या बंद करण्यात आलेला आहे.नविन चेहरेपट्टीच्या वापराबद्दल धन्यवाद.आपण पुन्हा त्यास, पानाच्या वरील भागास असलेल्या "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" या दुव्यावर कधीही टिचकी मारुन, त्यास परत सुरू करु शकता.',
	'prefswitch-success-feedback' => 'तुमची टिप्पणी पाठवली.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span>कडे परत फिरा.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| विकिपीडियाच्या नविन चेहरामोहर्‍याचे पटलदृष्य <small>[[Media:VectorNavigation-en.png|(विस्तृत)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
|पायाभूत पान संपादण्याचे पटलदृष्य  <small>[[Media:VectorEditorBasic-en.png|(विस्तृत)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
|दुवे टाकण्यासाठी असलेल्या नविन संवाद पेटीचे पटलदृष्य
|}
|}
विकिमिडिया फाउंडेशनची ’सदस्य अनुभव चमू (User Experience Team)’ ही आपणास काम करणे सोपे व्हावे म्हणुन विकिसमाजातील स्वयंसेवकासमवेत काम करीत आहे. आपल्यासमवेत, नविन चेहरामोहर्‍यासह व सोप्या संपादन तोंडवळ्यासह काही सुधारणा आदानप्रदान करण्यास आम्ही आतूर आहोत.नविन सदस्यास सुरुवात करण्यास अभिप्रेत हे बदल त्यांना सोपे पडतील व ते [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study usability testing conducted over the last year यावर]  आधारीत आहेत. आमच्या प्रकल्पांचा वापर (कोणासही) सोप्या पद्धतीने करता यावा ही विकिमिडिया फाउंडेशनची प्राथमिकता आहे आणि भविष्यात आम्ही यात आणखी अद्ययावतता आणुन ती आपल्यासह आदानप्रदान करु.अधिक विस्तृत माहितीसाठी विकिमिडियासंबंधित [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog post या] संकेतस्थळास भेट द्या.


=== आम्ही काय बदलले आहे ते येथे बघा  ===

* '''सुचालन:''' पाने वाचण्यास व संपादण्यास सोपे जावे म्हणुन आम्ही सुधारणा केल्या आहेत.सध्या, प्रत्येक पानाच्या वरील बाजूस असलेली ’टॅब’ ही जास्त स्पष्टपणे हे दर्शविते कि, आपण तेच पान पहात आहात की, त्याचे चर्चापान आणि आपण ते पान वाचत आहात की संपादन करीत आहात.
* '''संपादन साधनपट्टीतील सुधारणा:''' आम्ही, वापरात अधीक सुलभता मिळावी म्हणून, संपादन साधनपट्टी ची पुर्नरचना केली आहे . पानांची रचना करणे अधीक सुगम आणि सोपे झाले आहे.
* '''दुवे सहाय्यक:''' इतर विकिपानांना आणि बाह्य दुवे देण्याकरिता,  वापरास सोपे असे साधन, तुम्हाला अधीक सुलभता उपलब्ध व्हावी म्हणून उपलब्ध केले आहे.
* '''शोध सुधारणा:''' तुम्ही शोधत असलेले लेख/पान लवकर मिळण्याकरिता आम्ही शोध सुचवणीत सुधारणा केल्या आहेत.
* '''इतर नवीन वैशिष्ट्ये: '''सारणी (टेबल) सोपी करण्यासाठी आम्ही आता एक 'नवीन सारणी (टेबल) सहाय्यक' उपलब्ध केला आहे आणि संपादनांमध्ये सुलभता आणण्याकरिता शोधा आणि बदला (find and replace) वैशिष्ट्य सुद्धा उपलब्ध केले आहे.
* '''विकिपीडिया लोगो:''' आम्ही आमचा लोगो अद्ययावत केला आहे.  [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog येथे]  अधीक वाचा.",
	'prefswitch-main-logged-changes' => "*  '''{{int:watch}} कळ (टॅब)''' आता तारा आहे.
*  '''{{int:move}} कळ (टॅब)''' आता शोधपेटी पुढच्या अधोदर्शक बाणात ( ड्रॉपडाऊनमध्ये) आहे .",
	'prefswitch-main-feedback' => '===प्रतिक्रीया?===
आम्हाला तुमच्या कडून ऐकण्यास आवडेल. कृपया आमच्या [[$1|प्रतिक्रीया पानास]] अथवा, तुम्ही जर आमच्या संगणन प्रणाली सुधारण्याच्या चालू प्रक्रीयेत रस असल्यास ,अधीक माहिती करिता आमच्या [http://usability.wikimedia.org ऊपयोगसुलभता उपक्रम विकिस] भेट द्या.',
	'prefswitch-main-anon' => '===मला परत न्या===
[नविन चेहरामोहरा बंद करण्यास $1 येथे टिचकी मारा].आपणास दाखल होण्यास वा खाते उघडण्याबद्दल विचारण्यात येईल.',
	'prefswitch-main-on' => '===मला परत न्या===
[नविन चेहरामोहरा बंद करण्यास $2 येथे टिचकी मारा].',
	'prefswitch-main-off' => '==वापरुन पहा!==
[$1 नवीन बदल पाहण्यासाठी येथे टिचकी द्या]',
	'prefswitch-survey-intro-feedback' => 'कृपया  "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" येथे टिचकी मारण्यापूर्वी,आपणातर्फे ऐच्छिक सर्वेक्षणाचा खाली दिलेला नमूना भरुन आपली प्रतिक्रिया घेणे आम्हास जरुर आवडेल.',
	'prefswitch-survey-intro-off' => 'आमच्या नवीन वैशिष्ट्यसुविधा वापरून पहाण्याकरिता धन्यवाद.
त्यात सुधारणा करण्याकरिता,"[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" या पानाचे शेवटी दिलेल्या कळीवर टिचकी मारण्यापुर्वी कृपया खालील अबंधनकारक सर्वेक्षण भरून द्या.',
	'prefswitch-feedbackpage' => 'Project:सदस्याचे अनुभवाचा परतसंदेश',
);

/** Malay (Bahasa Melayu)
 * @author CoolCityCat
 * @author Diagramma Della Verita
 * @author Platonides
 */
$messages['ms'] = array(
	'prefswitch' => 'Keutamaan Peralihan Inisiatif Kepenggunaan',
	'prefswitch-desc' => 'Membenarkan pengguna untuk beralih ke set pilihan',
	'prefswitch-link-anon' => 'Ciri-ciri baru',
	'tooltip-pt-prefswitch-link-anon' => '↓ Ketahui lebih lanjut tentang ciri-ciri baru',
	'prefswitch-link-on' => 'Kembali',
	'tooltip-pt-prefswitch-link-on' => '↓ Padamkan ciri-ciri baru',
	'prefswitch-link-off' => '↓ Ciri-ciri baru',
	'tooltip-pt-prefswitch-link-off' => '↓ Cuba ciri-ciri baru',
	'prefswitch-jswarning' => 'Perubahan pada muka laman anda [[User:$1/$2.js|$2 JavaScript]] perlu diserta dan disimpan pada [[{{ns:user}}:$1/vector.js]] <!-- atau [[{{ns:user}}:$1/common.js]]--> untuk langkah seterusnya',
	'prefswitch-csswarning' => 'Fungsi  [[User:$1/$2.css|vector  $2 pilihan]] tidak akan digunakan. Anda boleh menggunakkan CSS pilihan anda untuk vector di [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ya',
	'prefswitch-survey-false' => 'Tidak',
	'prefswitch-survey-submit-off' => 'Padamkan ciri-ciri baru',
	'prefswitch-survey-cancel-off' => 'Seandainya anda ingin terus menggunakan Beta, sila kembali ke $1',
	'prefswitch-survey-submit-feedback' => 'Hantarkan maklumbalas',
	'prefswitch-survey-cancel-feedback' => 'Seandainya anda tidak ingin menghantar maklumbalas, kembali ke $1',
	'prefswitch-survey-question-like' => 'Apakah yang anda suka tentang cir-ciri baru yang diterapkan?',
	'prefswitch-survey-question-dislike' => 'Apakah yang anda tidak suka tentang ciri-ciri baru yang diterapkan?',
	'prefswitch-survey-question-whyoff' => 'Anda telah memadmkan semua ciri-ciri baru. Sila tandakan perkara-perkara perlu.',
	'prefswitch-survey-answer-whyoff-hard' => 'Ciri-ciri baru sukar untuk digunakan.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Ciri-ciri yang tidak berfungsi dengan baik.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Ciri-ciri baru tidak berfungsi dengan sepenuhnya.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Saya tidak suka cara dan reka bentuk ciri-ciri baru.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Saya tidak suka bahagian tab dan muka.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Saya tidak suka peralatan perkakas baru.',
	'prefswitch-survey-answer-whyoff-other' => 'Sebab-sebab lain.',
	'prefswitch-survey-question-browser' => 'Apakah pelayar web yang anda gunakan?',
	'prefswitch-survey-answer-browser-other' => 'Pelayar web lain:',
	'prefswitch-survey-question-os' => 'Apakah sistem komputer yang anda gunakan?',
	'prefswitch-survey-answer-os-other' => 'Sistem operasi lain:',
	'prefswitch-survey-question-res' => 'Apakah revolusi skrin anda?',
	'prefswitch-title-on' => 'Ciri-ciri baru',
	'prefswitch-title-switched-on' => 'Cubalah!',
	'prefswitch-title-off' => 'Padamkan fungsi ciri-ciri baru',
	'prefswitch-title-switched-off' => 'Terima kasih',
	'prefswitch-title-feedback' => 'Maklum balas',
	'prefswitch-success-on' => 'Ciri-ciri baru telah diaktifkan. Kami berharap ciri-ciri baru yang diperbaharui mudah digunakan. Anda tetap boleh memadamkan ciri-ciri beta dengan menekan  "[[Special: UsabilityInitiativePrefSwitch | ((int: prefswitch-link-link }}]]" pada bahagian atas laman.',
	'prefswitch-success-off' => 'Ciri-ciri baru telah dimatikan. Terima kasih kerana cuba menggunakan versi Beta. Anda boleh mengaktifkan semula versi ini dengan menekan "[[Special: UsabilityInitiativePrefSwitch | ((int: prefswitch }}]]" pada bahagian atas laman.',
	'prefswitch-success-feedback' => 'Maklum balas anda telah dihantar.',
	'prefswitch-return' => '<hr style="clear:both">
Kembali ke <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Tampilan navigasi laman Wikipedia baru <small>[[Media:VectorNavigation-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Tampilan bahagian kotak suntingan baru <small>[[Media:VectorEditorBasic-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Tampilan kotak dialog untuk kegunaan pautan
|}
|}
'''Wikimedia Foundation's User Experience Team''' telah bekerjasama dengan para pengguna daripada komuniti untuk memudahkan kepenggunaan Wikipedia. Kami ingin berkongsi pembaharuan yang telah dilaksanakan, termasuk bentuk muka laman yang baru, ringkas dan ciri-ciri yang padat. Pembaharuan ini bertujuan untuk memudahkan pengguna-pengguna baru untuk menyumbang dalam Wikipedia. Kami telah menjalankan [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study temu-bual dan penyelidikan] dengan para pengguna sepanjang tahun lepas. Peningkatan kepengguaan Wikipedia dan projek-projek berkembarnya merupakan keutamaan Yayasan Wikimedia dan kami akan mengumumkan sebarang pembaharuan yang akan datang. Untuk maklumat yang lebih lanjut, sila layari [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia laman blog Wikimedia].

===Antara perubahan baru===
* '''Navigasi:''' Kami telah memperbaharui sistem navigasi untuk pembacaan dan penyuntingan laman. ''Tab'' pada bahagian atas laman secara ringkas menunjukkan sama ada anda sedang melayari laman rencana atau laman perbincangan dan penyuntingan.
* '''Pembaharuan Bar perkakas (''Toolbar'') Penyuntingan:''' Kami telah menyusun semula bar perkakas penyuntingan untuk memudahkan anda. Pemformatan laman dan kepenggunaan fungsi lain kini lebih mudah.
* '''Wizard Pautan:''' Perkakas mudah diguna ini, membolehkan anda menambah pautuan pada laman wiki lain dan pautan luar.
* '''Pembaikan carian:''' Kami telah mempertingkatkan enjin carian berdasarkan cadangan untuk memudahkan anda mencari laman yang anda ingin layari.
* '''Ciri-ciri baru:''' Kami turut memperkenalkan wizard jadual untuk memudahkan penyediaan jadual dan memudahkan penyuntingan laman.
* '''Logo Wikipedia:''' Kami telah mengemaskinikan logo Wikiepdia. Untuk maklumat lanjut, sila baca [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Blog Wikimedia]",
	'prefswitch-main-logged-changes' => "* Bahagian '''tab {{int:watch}} ''' kini berbentuk bintang.
* Bahagian '''tab {{int:move}}''' kini terletak bersebelahan dengan bar carian.",
	'prefswitch-main-feedback' => '===Cadangaan?===
Kami ingin mendengar cadangan anda. Sila kemukakan [[$1|pandangan, pendapat dan cadangan]] kepada kami. Sekiranya anda ingin menyumbang kepakaran anda untuk meningkatkan mutu perisian dan Wikipedia, sila layari [http://usability.wikimedia.org Usability wiki] untuk maklumat lebih lanjut.',
	'prefswitch-main-anon' => '===Kembali===
[$1 Klik sini untuk mematikan ciri-ciri baru]. Anda perlu log masuk atau membuat akuan baru terlebih dahulu.',
	'prefswitch-main-on' => '===Kembali kepada asal===
[$2 Klik di sini untuk memadamkan ciri-ciri baru].',
	'prefswitch-main-off' => '===Cubalah!===
[$1 Klik di sini untuk mengaktifkan ciri-ciri baru].',
	'prefswitch-survey-intro-feedback' => 'Kami ingin mengetahui maklum balas anda.
Sila hantarkan soal selidk di bawah.',
	'prefswitch-survey-intro-off' => 'Terima kasih kerana cuba menggunakan ciri-ciri baru.
Untuk membantu kami meningkatkan mutu laman, sila isikan soal selidik dibawah.',
	'prefswitch-feedbackpage' => 'Project:Pendapat dan cadangan pengguna',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'prefswitch' => "Tibdil tal-preferenzi tal-Inizjattiva ta' Użabilità",
	'prefswitch-desc' => "Ippermetti lill-utenti li jbiddlu settijiet ta' preferenzi",
	'prefswitch-link-anon' => 'Funzjonijiet ġodda',
	'tooltip-pt-prefswitch-link-anon' => 'Tgħallem aktar dwar il-funzjonijiet il-ġodda',
	'prefswitch-link-on' => 'Ħudni lura',
	'tooltip-pt-prefswitch-link-on' => 'Itfi l-funzjonijiet il-ġodda',
	'prefswitch-link-off' => 'Funzjonijiet ġodda',
	'tooltip-pt-prefswitch-link-off' => 'Ipprova funzjonijiet ġodda',
	'prefswitch-jswarning' => 'Ftakar li bil-bidla tal-aspett grafiku, il-[[User:$1/$2.js|javascript tal-$2 tiegħek]] irid jiġi kkupjat lejn [[User:$1/vector.js]] jew [[User:$1/common.js]] sabiex tkompli taħdem.',
	'prefswitch-csswarning' => "L-[[User:$1/$2.css|istili personalizzati għall-$2]] mhumiex se japplikaw aktar. Tista' żżid CSS personalizzat għall-vector f'[[User:$1/vector.css]].",
	'prefswitch-survey-true' => 'Iva',
	'prefswitch-survey-false' => 'Le',
	'prefswitch-survey-submit-off' => 'Itfi l-funzjonijiet il-ġodda',
	'prefswitch-survey-cancel-off' => "Jekk tixtieq tkompli tuża' l-funzjonijiet l-ġodda, tista' tirritorna lejn $1.",
	'prefswitch-survey-submit-feedback' => 'Ibgħat ir-rispons tiegħek',
	'prefswitch-survey-cancel-feedback' => "Jekk ma tixtieq tibgħat ir-rispons tiegħek, tista' tirritorna lejn $1.",
	'prefswitch-survey-question-like' => "X'għoġbok mill-funzjonijiet il-ġodda?",
	'prefswitch-survey-question-dislike' => "X'ma għoġbokx mill-funzjonijiet il-ġodda?",
	'prefswitch-survey-question-whyoff' => 'Għaliex qiegħed titfi l-funzjonijiet l-ġodda? Jekk jogħġbok agħżel dak li japplikaw għalik.',
	'prefswitch-survey-answer-whyoff-hard' => 'Kienet wisq diffiċli biex tużaha.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Ma kinitx qed taħdem tajjeb.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Ma kinitx qed taħdem kif mixtieq.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "M'għoġobnix l-aspett tagħha.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "M'għoġbunix il-buttuni l-ġodda u t-tqassim tal-paġni.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => "M'għoġbitnix il-kaxxa tal-għodda l-ġdida.",
	'prefswitch-survey-answer-whyoff-other' => 'Raġuni oħra:',
	'prefswitch-survey-question-browser' => "Liema browżer tuża'?",
	'prefswitch-survey-answer-browser-other' => 'Browżers oħra:',
	'prefswitch-survey-question-os' => "Liema sistema operattiva tuża'?",
	'prefswitch-survey-answer-os-other' => 'Sistema operattiva oħra:',
	'prefswitch-survey-question-res' => "X'inhi r-riżoluzzjoni tal-iskrin tiegħek?",
	'prefswitch-title-on' => 'Funzjonijiet ġodda',
	'prefswitch-title-switched-on' => 'Ħu gost!',
	'prefswitch-title-off' => 'Itfi l-funzjonijiet l-ġodda',
	'prefswitch-title-switched-off' => 'Grazzi',
	'prefswitch-title-feedback' => 'Rispons',
	'prefswitch-success-on' => "Il-funzjonijiet il-ġodda ġew attivati. Nisperaw li tieħu gost tuża' dawn il-funzjonijiet il-ġodda. Tista' dejjem titfihom lura billi tagħfas fuq \"[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]\" fin-naħa ta' fuq tal-paġna.",
	'prefswitch-success-off' => 'Il-funzjonijiet il-ġodda ġew mitfija. Grazzi talli ppruvajt dawn il-funzjonijiet il-ġodda. Tista\' dejjem tattivahom lura billi tagħfas fuq "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" fin-naħa ta\' fuq tal-paġna.',
	'prefswitch-success-feedback' => 'Ir-rispons tiegħek intbagħat.',
	'prefswitch-return' => '<hr style="clear:both">
Irritorna lura lejn <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "Ħdimna ħafna sabiex nagħmlu l-affarijiet iktar faċli għall-utenti tagħna. Ninsabu entużjasti li naqsmu magħkom xi titjib li sar, fosthom aspett grafiku ġdid u funzjonijiet tal-immodifikar simplifikati. It-titjib fl-użabilità tal-proġetti tagħna hija prijorità tal-Fondazzjoni Wikimedia u fil-ġejjieni sejrin naqsmu magħkom aktar aġġornamenti. Għal aktar dettalji, żur il-post relatata fuq il-[http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ blogg tal-Wikimedia].

[[File:UsabilityNavigation.png|right|link=|Screenshot tan-navigazzjoni l-ġdida]]
[[File:UsabilityToolbar.png|right|link=|Screenshot tal-kaxxa tal-għodda mtejba]]
[[File:UsabilityDialogs.png|right|link=|Screenshot tat-twieqi l-ġodda ta' djalogu għall-ġenerazzjoni tal-kontenut]]
===Dan hu dak li biddilna===
* '''Navigazzjoni:''' Tejjibna s-sistema ta' navigazzjoni għall-qari u l-immodifikar ta' paġni. Issa, il-kaxex fin-naħa ta' fuq ta' kull paġna juruk biċ-ċar jekk intix qed tara l-paġna jew il-paġna ta' diskussjoni, jew jekk intix qiegħed taqra jew timmodifika paġna.
* '''Titjib fil-kaxxa tal-għodda tal-immodifikar:''' Irranġajna l-kaxxa tal-għodda tal-immodifikar biex issir aktar faċli biex tiġi wżata. Issa, li tifformattja l-paġni hu aktar sempliċi u aktar intuwittiv.
* '''Proċedura gwidata għall-ħoloq:''' Strument faċli biex jiġi wżat li jgħinek iżżid ħolqa lejn paġni wiki oħra kif ukoll lejn siti esterni.
* '''Titjib fit-tfittxija:''' Tejjibna s-suġġerimenti tat-tfittxija sabiex iwassluk lejn il-paġna li qiegħed tfittex aktar malajr.
* '''Funzjonijiet oħra:''' Introduċejna wkoll proċedura gwidata għat-tabelli sabiex toħloq tabelli iktar faċli u funzjoni ta' \"Fittex u biddel\" biex tissimplifika l-immodifikar tal-paġna.
* '''Globu tal-''puzzle'' tal-Wikipedija''': aġġornajna l-globu tal-''puzzle'', aqra aktar fuq il-[http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/  blogg tal-Wikimedia].",
	'prefswitch-main-logged-changes' => "* It-'''''tab'' {{int:watch}}''' issa hija stilla.
* It-'''''tab'' {{int:move}}''' issa hija fil-menu kollassabbli taħt il-kaxxa tat-tfittxija.",
	'prefswitch-main-feedback' => "===Rispons?===
Nixtiequ nisimgħu mingħandek. Żur il-[[$1|paġna ta' rispons]] jew, jekk int interessat fl-isforzi tagħna sabiex intejbu s-softwer, żur il-[http://usability.wikimedia.org wiki ta' użabilità] għal aktar informazzjoni.",
	'prefswitch-main-anon' => '===Ħudni lura===
Jekk tixtieq titfi l-funzjonijiet l-ġodda, [$1 agħfas hawnhekk]. Se tkun mistoqsi biex tagħmel il-login jew toħloq kont.',
	'prefswitch-main-on' => '===Ħudni lura===
[$2 Agħfas hawnhekk sabiex titfi l-funzjonijiet l-ġodda].',
	'prefswitch-main-off' => '===Ippruvawhom!===
Jekk tixtieq tipprova l-funzjonijiet il-ġodda, [$1 agħfas hawnhekk].',
	'prefswitch-survey-intro-feedback' => 'Nieħdu gost nisimgħu mingħandek.
Jekk jogħġbok imla l-kwestjonarju opzjonali segwenti qabel ma tagħfas "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Grazzi talli għamilt użu mill-funzjonijiet il-ġodda.
Biex tgħinna ntejbuhom, jekk jogħġbok imla l-kwestjonarju opzjonali segwenti qabel ma tagħfas "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Rispons tal-esperjenza tal-utent',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'prefswitch-link-off' => 'Од ёнкст',
	'prefswitch-survey-submit-off' => 'Пекстамс од ёнкстнэнь',
	'prefswitch-survey-submit-feedback' => 'Кучомс тевень коряс мельть-арсемат',
	'prefswitch-title-switched-off' => 'Сюкпирине',
);

/** Nahuatl (Nāhuatl)
 * @author Ricardo gs
 */
$messages['nah'] = array(
	'prefswitch-survey-true' => 'Quēmah',
	'prefswitch-survey-false' => 'Ahmo',
	'prefswitch-title-switched-off' => 'Tlazohcāmati',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'prefswitch' => 'Veurkeuren veur Bruukbaorheidsinitiatief wisselen',
	'prefswitch-desc' => 'Hierdeur ku-j een groep instellingen wiezigen',
	'prefswitch-link-anon' => 'Nieje functies',
	'tooltip-pt-prefswitch-link-anon' => 'Meer over de nieje functies',
	'prefswitch-link-on' => 'Weerumme',
	'tooltip-pt-prefswitch-link-on' => 'Nieje functies uutzetten',
	'prefswitch-link-off' => 'Nieje functies',
	'tooltip-pt-prefswitch-link-off' => 'Nieje functies uutpreberen',
	'prefswitch-jswarning' => "Vergeet neet dat mit 't wiezigen van de vormgeving joew [[User:$1/$2.js|JavaScript veur $2]] ekopieerd mut wönnen naor [[{{ns:user}}:$1/vector.js]] of [[{{ns:user}}:$1/common.js]] um 't nog te laoten doon.",
	'prefswitch-csswarning' => 'Joew [[User:$1/$2.css|an-epassen stielen veur $2]] bin neet meer actief.
Je kunnen de CSS-stielen veur Vector anpassen in de pagina [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nee',
	'prefswitch-survey-submit-off' => 'Nieje functies uutzetten',
	'prefswitch-survey-cancel-off' => 'A-j Bèta an willen laoten staon, dan ku-j weerummegaon naor $1',
	'prefswitch-survey-submit-feedback' => "Is 't wat?",
	'prefswitch-survey-cancel-feedback' => 'A-j gien zin hemmen um te laoten weten wa-j dervan vienen, dan ku-j weerummegaon naor $1.',
	'prefswitch-survey-question-like' => 'Wat vu-j van de nieje functies?',
	'prefswitch-survey-question-dislike' => 'Wat vu-j slich an de nieje functies?',
	'prefswitch-survey-question-whyoff' => 'Waorumme wi-j de nieje functies uutzetten?
Kies de meugelijkheen dee van toepassing bin.',
	'prefswitch-survey-answer-whyoff-hard' => "'t Gebruuk van de nieje functies was veulste lastig.",
	'prefswitch-survey-answer-whyoff-didntwork' => "De functies dungen 't neet goed.",
	'prefswitch-survey-answer-whyoff-notpredictable' => 'De functies reageren neet veurspelbaor.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "'t Zag der lillik uut",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "Ik vun 't mar niks dee nieje tabblaojen en vormgeving.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ik vun dee nieje warkbalke mar niks.',
	'prefswitch-survey-answer-whyoff-other' => 'Aandere reden:',
	'prefswitch-survey-question-browser' => 'Waffer webkieker he-jie dan?',
	'prefswitch-survey-answer-browser-other' => 'Aandere webkieker:',
	'prefswitch-survey-question-os' => 'Waffer besturingssysteem he-jie dan?',
	'prefswitch-survey-answer-os-other' => 'Aander besturingssysteem:',
	'prefswitch-survey-question-res' => 'Wat is de beeldscharmrisselusie?',
	'prefswitch-title-on' => 'Nieje functies',
	'prefswitch-title-switched-on' => 'Veule schik dermee!',
	'prefswitch-title-off' => 'Nieje functies uutzetten',
	'prefswitch-title-switched-off' => 'Bedank',
	'prefswitch-title-feedback' => "Is 't wat?",
	'prefswitch-main-logged-changes' => "* 't Onderwarp '''{{int:watch}}''' is noen een steerntjen.
* 't Onderwarp '''{{int:move}}''' steet noen in 't uutklapmenu naos 't zeukvienster.",
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'prefswitch' => 'Voorkeuren voor Bruikbaarheidsinitiatief wisselen',
	'prefswitch-desc' => 'Maakt het mogelijk om een groep instellingen te wijzigen',
	'prefswitch-link-anon' => 'Nieuwe functionaliteit',
	'tooltip-pt-prefswitch-link-anon' => 'Meer over nieuwe functionaliteit',
	'prefswitch-link-on' => 'Terug',
	'tooltip-pt-prefswitch-link-on' => 'Nieuwe functionaliteit uitschakelen',
	'prefswitch-link-off' => 'Nieuwe functionaliteit',
	'tooltip-pt-prefswitch-link-off' => 'Nieuwe mogelijkheden uitproberen',
	'prefswitch-jswarning' => 'Vergeet niet dat met het wijzigen van het uiterlijk uw [[User:$1/$2.js|JavaScript voor $2]] gekopieerd moet worden naar [[{{ns:user}}:$1/vector.js]] of [[{{ns:user}}:$1/common.js]] om het nog steeds te laten werken.',
	'prefswitch-csswarning' => 'Uw [[User:$1/$2.css|aangepaste stijlen voor $2]] zijn niet langer actief.
U kunt de CSS-stijlen voor Vector aanpassen in de pagina [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nee',
	'prefswitch-survey-submit-off' => 'Nieuwe mogelijkheden uitschakelen',
	'prefswitch-survey-cancel-off' => 'Als u de nieuwe mogelijkheden wilt blijven gebruiken, kunt u terugkeren naar $1',
	'prefswitch-survey-submit-feedback' => 'Terugkoppeling geven',
	'prefswitch-survey-cancel-feedback' => 'Als u geen terugkoppeling wilt geven, kunt u teruggaan naar $1.',
	'prefswitch-survey-question-like' => 'Wat beviel u aan de nieuwe functionaliteit?',
	'prefswitch-survey-question-dislike' => 'Wat beviel u niet aan de nieuwe functionaliteit?',
	'prefswitch-survey-question-whyoff' => 'Waarom wilt u de nieuwe mogelijkheden uitschakelen?
Vink alstublieft alle mogelijkheden die van toepassing zijn aan.',
	'prefswitch-survey-question-globaloff' => "Wilt u de mogelijkheden voor alle wiki's uitschakelen?",
	'prefswitch-survey-answer-whyoff-hard' => 'Het gebruik van de nieuwe functionaliteit was te lastig.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'De nieuwe functionaliteit functioneerde niet correct.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'De nieuwe functionaliteit reageerde niet voorspelbaar.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Het zag er niet zo uit als ik wilde.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Ik vond de nieuwe tabbladen en het uiterlijk niet prettig.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Ik vond de nieuwe werkbalk niet prettig werken.',
	'prefswitch-survey-answer-whyoff-other' => 'Andere reden:',
	'prefswitch-survey-question-browser' => 'Welke browser gebruikt u?',
	'prefswitch-survey-answer-browser-ffb' => 'Firefox Bèta',
	'prefswitch-survey-answer-browser-cd' => 'Google Chrome Dev',
	'prefswitch-survey-answer-browser-other' => 'Andere browser:',
	'prefswitch-survey-question-os' => 'Welk besturingssysteem gebruikt u?',
	'prefswitch-survey-answer-os-other' => 'Ander besturingssysteem:',
	'prefswitch-survey-answer-globaloff-yes' => "Ja, de mogelijkheden voor alle wiki's uitschakelen",
	'prefswitch-survey-question-res' => 'Wat is uw beeldschermresolutie?',
	'prefswitch-title-on' => 'Nieuwe functionaliteit',
	'prefswitch-title-switched-on' => 'Geniet ervan!',
	'prefswitch-title-off' => 'Nieuwe mogelijkheden uitschakelen',
	'prefswitch-title-switched-off' => 'Bedankt',
	'prefswitch-title-feedback' => 'Terugkoppeling',
	'prefswitch-success-on' => 'De nieuwe mogelijkheden zijn nu ingeschakeld. We hopen dat u er veel plezier aan beleeft. U kunt ze altijd weer uitschakelen door te klikken op de verwijzing "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" bovenaan de pagina.',
	'prefswitch-success-off' => 'De nieuwe mogelijkheden zijn nu uitgeschakeld. Dank u wel voor het proberen. U kunt ze altijd weer inschakelen door te klikken op de verwijzing De nieuwe mogelijkheden zijn nu uitgeschakeld. We hopen dat u er veel plezier aan beleeft. U kunt ze altijd weer uitschakelen door te klikken op de verwijzing "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" bovenaan de pagina.',
	'prefswitch-success-feedback' => 'Uw terugkoppeling is verzonden.',
	'prefswitch-return' => '<hr style="clear:both">
Terug naar <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-nl.png|401px|]]
|-
| De nieuwe navigatie voor Wikipedia. <small>[[Media:VectorNavigation-nl.png|(vergroten)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-nl.png|401px|]]
|-
| Het eenvoudige bewerkingsvenster. <small>[[Media:VectorEditorBasic-nl.png|(vergroten)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-nl.png|401px]]
|-
| Het nieuwe dialoogvenster voor het toevoegen van verwijzingen.
|}
|}
Het Bruikbaarheidsteam van de Wikimedia Foundation hard gewerkt om dingen makkelijker te maken voor u. We zijn verheugd om een aantal verbeteringen met u te delen, inclusief een nieuw uiterlijk en een vereenvoudigde manier om pagina's te bewerken.
De wijzigingen beogen het eenvoudiger te maken voor nieuwelingen om bij te dragen en zijn gebaseerd op onze [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study bruikbaarheidstests van het afgelopen jaar].
Het verbeteren van de gebruiksvriendelijkheid van onze projecten is een prioriteit van de Wikimedia Foundation en we verwachten in de toekomst nog verder te kunnen gaan.
In het [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blogbericht] kunt u meer lezen.

=== Dit hebben we veranderd ===
* '''Navigatie:''' We hebben de navigatie voor het lezen en bewerken van pagina's verbeterd.
De tabbladen bovenaan de pagina geven beter aan of u een pagina bekijkt of een overlegpagina, en of u een pagina aan het bekijken of aan het bewerken bent.
* '''Verbeteringen aan de werkbalk:''' We hebben de werkbalk volledig ontworpen zodat deze eenvoudiger te gebruiken is.
Nu is het bewerken van pagina's eenvoudiger en intuïtiever.
* '''Hulp bij verwijzingen:''' een hulpje voor het eenvoudig toevoegen van verwijzingen naar andere wikipagina's en externe websites.
* '''Verbeteringen in het zoeken:''' we hebben zoeksuggesties verbeterd zodat u de pagina die u zoekt sneller vindt.
* '''Andere nieuwe mogelijkheden:''' Wij hebben ook een tabelhulpmiddel toegevoegd om het maken van tabellen te vereenvoudigen en een hulpmiddel voor zoeken en vervangen om het bewerken van pagina's te vereenvoudigen.
* '''Wikipedia logo''': We hebben ons logo vernieuwd. Op de [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Wikimedia blog] kunt u meer lezen.",
	'prefswitch-main-logged-changes' => "* Het item '''{{int:watch}}''' is nu een sterretje.
* Het item '''{{int:move}}''' staat nu in het dropdownmenu naast het zoekvenster.",
	'prefswitch-main-feedback' => '=== Terugkoppeling? ===
Wij horen graag van u.
Bezoek onze [[$1|pagina voor terugkoppeling]], of ga naar de [http://usability.wikimedia.org bruikbaarheidswiki] voor meer informatie als u geïnteresseerd bent in onze toekomstige plannen.',
	'prefswitch-main-anon' => '===Terug===
[$1 U kunt de nieuwe functionaliteit uitschakelen]. U wordt dan gevraagd om aan te melden of te registreren.',
	'prefswitch-main-on' => '=== Nee, bedankt! ===
[$2 Klik om de nieuwe mogelijkheden uit te schakelen].',
	'prefswitch-main-off' => '===Uitproberen!===
[$1 Klik hier om de nieuwe mogelijkheden in te schakelen].',
	'prefswitch-survey-intro-feedback' => 'We horen graag van u.
Vul alstublieft de optionele vragenlijst hieronder in voordat u klikt op "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Bedankt voor het uitproberen van de nieuwe mogelijkheden.
Vul alstublieft de onderstaande vragenlijst in om ons te helpen ze verder te verbeteren voordat u klikt op "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Feedback voor het User Experience Team',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Harald Khan
 */
$messages['nn'] = array(
	'prefswitch-link-anon' => 'Nye funksjonar',
	'tooltip-pt-prefswitch-link-anon' => 'Lær meir om dei nye funksjonane',
	'prefswitch-link-on' => 'Tilbake til det gamle',
	'tooltip-pt-prefswitch-link-on' => 'Slå av nye funksjonar',
	'prefswitch-link-off' => 'Nye funksjonar',
	'tooltip-pt-prefswitch-link-off' => 'Prøv nye funksjonar',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nei',
	'prefswitch-survey-submit-off' => 'Slå av nye funksjonar',
	'prefswitch-survey-cancel-off' => 'Viss du vil halde fram med dei nye funksjonane, kan du gå tilbake til $1.',
	'prefswitch-survey-submit-feedback' => 'Send tilbakemelding',
	'prefswitch-survey-cancel-feedback' => 'Viss du ikkje vil gje tilbakemeldingar, kan du gå tilbake til $1.',
	'prefswitch-survey-question-like' => 'Kva likte du med dei nye funksjonane?',
	'prefswitch-survey-question-dislike' => 'Kva mislikte du med funksjonane?',
	'prefswitch-survey-question-whyoff' => 'Kvifor slår du av dei nye funksjonane?
Vel alle som passar.',
	'prefswitch-survey-answer-whyoff-hard' => 'Dei var for vanskelege å bruke.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Dei fungerte ikkje skikkeleg.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Dei oppførde seg ikkje slik ein kunne forvente.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Eg likte ikkje utsjånaden deira.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Eg lika ikkje dei nye fanene og den nye utsjånaden.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Eg lika ikkje den nye verktøylinja.',
	'prefswitch-survey-answer-whyoff-other' => 'Anna årsak:',
	'prefswitch-survey-question-browser' => 'Kva for nettlesar brukar du?',
	'prefswitch-survey-answer-browser-other' => 'Annan nettlesar:',
	'prefswitch-survey-question-os' => 'Kva for operativsystem brukar du?',
	'prefswitch-survey-answer-os-other' => 'Anna operativsystem:',
	'prefswitch-survey-question-res' => 'Kva er oppløysinga på skjermen din?',
	'prefswitch-title-on' => 'Nye funksjonar',
	'prefswitch-title-switched-on' => 'Kos deg!',
	'prefswitch-title-off' => 'Slå av dei nye funksjonane',
	'prefswitch-title-switched-off' => 'Takk',
	'prefswitch-title-feedback' => 'Tilbakemelding',
	'prefswitch-success-on' => 'Dei nye funksjonane er no slegne på. Vi håpar du likar å bruke dei, men du kan når som helst slå dei av att, ved å klikke på lenkja «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» på toppen av sida.',
	'prefswitch-success-off' => 'Dei nye funksjonane er no slegne av. Takk for at du prøvde dei, og hugs at du når som helst kan slå dei på att, ved å klikke på lenkja «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]» på toppen av sida.',
	'prefswitch-success-feedback' => 'Tilbakemeldinga di er send.',
	'prefswitch-return' => '<hr style="clear:both">
Attende til <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Ein skjermdump av det nye navigasjonsgrensesnittet til Wikipedia<small>[[Media:VectorNavigation-en.png| (større)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Ein skjermdump av det grunnleggjande sideendingsgrensesnittet<small>[[Media:VectorEditorBasic-en.png| (større)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Ein skjermdump av den nye dialogboksen for å leggja inn lenkjer
|}
|}

User Experience Team hjå Wikimedia Foundation har jobba med friviljuge brukarar for å gjera ting enklare for deg. Me er glade for å kunna dela betringar, inkludert ein ny utsjånad og enklare endringsfunksjonar. Desse endringane skal gjera det lettare for nye bidragsytarar å koma igang, og er baserte på [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study brukarvenlegheitstesting utført det siste året]. Å betra brukarvenlegheita til prosjekta er prioritert hjå Wikimedia Foundation, og me vil dela fleire oppdateringar i framtida. For fleire detaljar, vitja det relaterte [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia vevlogginnlegget] frå Wikimedia.

=== Dette har me endra ===
* '''Navigasjon:''' Me har betra navigasjonen for lesing og endring av sider. No syner fanene på toppen av kvar sida klårare om du ser på innhaldssida eller diskusjonssida, og om du les eller endrar sida.
* '''Betring av endringsverktylinja:''' Me har har omorganiserty endringsverktylinja slik at ho er enklare å nytta. No er det enklare og meir intuitivt å formatera sider.
* '''Lenkjehjelp:''' Eit verkty som er enkelt å nytta lèt ein leggja til lenkjer til andre wikisider i tillegg til eksterne sider.
* '''Søkjebetringar:''' Me har betra søkjeframlegga slik at du kjappare skal landa på sida du er ute etter.
* '''Andre nye funksjonar:'''  Me har òg introdusert tabellhjelp som gjer det enklare å oppretta tabellar og eit søk-og-erstatt-verkty som gjer det enklare å endra sider.
* '''Wikipedia-logoen:''' Me har oppdatert logoen vår. Les meir på [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia-vevloggen].",
	'prefswitch-main-feedback' => '=== Tilbakemeldingar? ===
Me vil gjerne høyra frå deg. Vitja gjerne [[$1|tilbakemeldingssida]] vår; eller, om du er interessert i det pågåande arbeidet vårt med å betra mjukvara, vitja [http://usability.wikimedia.org brukarvenlegheitswikien] for meir informasjon.',
	'prefswitch-main-anon' => '=== Før meg attende ===
[$1 Trykk her for å slå av dei nye funksjonane]. Du vil få verta beden om å logga inn eller å oppretta ein konto fyrst.',
	'prefswitch-main-on' => '=== Før meg attende ===
[$2 Trykk her for å slå av dei nye funksjonane].',
	'prefswitch-main-off' => '=== Prøv dei ===
[$1 Trykk her for å slå på dei nye funksjonane].',
	'prefswitch-survey-intro-feedback' => 'Me vil gjerne høyra frå deg.
Fyll gjerne ut den valfrie undersøkinga under før du trykkjer på «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]».',
	'prefswitch-survey-intro-off' => 'Takk for at du prøvde ut dei nye funksjonane.
For å hjelpa oss med å betra dei, fyll gjerne ut den valfrie undersøkinga under før du trykkjer på «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'prefswitch' => 'Preferansebryter for Brukervennlighetsinitiativet',
	'prefswitch-desc' => 'Tillat brukere å bytte preferansesett',
	'prefswitch-link-anon' => 'Nye funksjoner',
	'tooltip-pt-prefswitch-link-anon' => 'Lær mer om de nye funksjonene',
	'prefswitch-link-on' => 'Ta meg tilbake',
	'tooltip-pt-prefswitch-link-on' => 'Deaktiver nye funksjoner',
	'prefswitch-link-off' => 'Nye funksjoner',
	'tooltip-pt-prefswitch-link-off' => 'Prøv nye funksjoner',
	'prefswitch-jswarning' => 'Husk at med endringen av drakt må ditt [[User:$1/$2.js|$2 JavaScript]] kopieres til [[{{ns:user}}:$1/vector.js]] <!-- eller [[{{ns:user}}:$1/common.js]]--> for å fortsette å virke.',
	'prefswitch-csswarning' => 'Din [[User:$1/$2.css|egendefinerte $2 stilmal]] vil ikke lenger brukes. Du kan legge til en egendefinert CSS for vector i [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nei',
	'prefswitch-survey-submit-off' => 'Slå av nye funksjoner',
	'prefswitch-survey-cancel-off' => 'Om du vil fortsette å bruke de nye funksjonene kan du gå tilbake til $1.',
	'prefswitch-survey-submit-feedback' => 'Send tilbakemelding',
	'prefswitch-survey-cancel-feedback' => 'Hvis du ikke ønsker å gi tilbakemelding kan du gå tilbake til $1.',
	'prefswitch-survey-question-like' => 'Hva likte du med de nye funksjonene?',
	'prefswitch-survey-question-dislike' => 'Hva mislikte du med funksjonene?',
	'prefswitch-survey-question-whyoff' => 'Hvorfor slår du av de nye funksjonene?
Velg alle som passer.',
	'prefswitch-survey-question-globaloff' => 'Vil du ha funksjonene avslått globalt?',
	'prefswitch-survey-answer-whyoff-hard' => 'De var vanskelige å bruke.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'De fungerte ikke skikkelig.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'De oppførte seg ikke slik jeg skulle forvente.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Jeg likte ikke hvordan de så ut.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Jeg likte ikke de nye fanene og utseende.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Jeg likte ikke den nye verktøylinjen.',
	'prefswitch-survey-answer-whyoff-other' => 'Annen grunn:',
	'prefswitch-survey-question-browser' => 'Hvilken nettleser bruker du?',
	'prefswitch-survey-answer-browser-other' => 'Annen nettleser:',
	'prefswitch-survey-question-os' => 'Hvilket operativsystem bruker du?',
	'prefswitch-survey-answer-os-other' => 'Annet operativsystem:',
	'prefswitch-survey-answer-globaloff-yes' => 'Ja, slå av funksjonene på alle wikier',
	'prefswitch-survey-question-res' => 'Hva er oppløsningen på skjermen din?',
	'prefswitch-title-on' => 'Nye funksjoner',
	'prefswitch-title-switched-on' => 'Kos deg',
	'prefswitch-title-off' => 'Slå av nye funksjoner',
	'prefswitch-title-switched-off' => 'Takk',
	'prefswitch-title-feedback' => 'Tilbakemelding',
	'prefswitch-success-on' => 'Nye funksjoner er nå slått på. Vi håper du liker å bruke de nye funksjonene. Du kan alltids slå dem av igjen ved å klikke på lenken «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» på toppen av siden.',
	'prefswitch-success-off' => 'Nye funksjoner er nå slått av. Takk for at du prøvde de nye funksjonene. Du kan alltids slå dem på igjen ved å klikke på lenken «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]» på toppen av siden.',
	'prefswitch-success-feedback' => 'Tilbakemeldingen din er sendt.',
	'prefswitch-return' => '<hr style="clear:both">
Tilbake til <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Et skjermbilde av Wikipedias nye navigasjonsgrensesnitt <small>[[Media:VectorNavigation-en.png|(forstørr)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Et skjermbilde av det grunnleggende sideredigeringsgrensesnittet <small>[[Media:VectorEditorBasic-en.png|(forstørr)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Et skjermbilde av den nye dialogboksen for å legge til lenker
|}
|}
Wikimedia Foundations User Experience Team har jobbet med frivillige fra fellesskapet for å gjøre ting lettere for deg. Vi er glade for å dele noen forbedringer, blant annet et nytt utseende og enklere redigeringsfunksjoner. Disse endringene er ment å gjøre det lettere for nye bidragsytere å komme igang og er basert på vår [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study brukervennlighetstest som ble gjennomført i fjor]. Å forbedre brukervennligheten til prosjektene våre er en prioritet for Wikimedia Foundation og vi vil dele flere oppdateringer med dere i fremtiden. Se [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Wikimedia-bloggen] (engelsk) for mer informasjon.

===Dette har vi endret===
* '''Navigasjon:''' Vi har forbedret navigeringen for lesing og redigering av sider. Nå viser fanene på toppen av siden klarere om du ser på siden eller på en diskusjonsside, og hvorvidt du leser eller redigerer en side.
* '''Forbedring av redigeringsverktøylinja:''' Vi har omorganisert verktøyslinja for redigering for å gjøre den lettere å bruke. Nå er det lettere og mer intuitivt å formatere sider.
* '''Lenkehjelp:''' Et verktøy som er lett å bruke tillater deg å legge til lenker til andre wikisider og eksterne nettsteder.
* '''Forbedring av søk:''' Vi har forbedret søkeforslagene for å hjelpe deg til siden du leter etter raskere.
* '''Andre nye funksjoner:''' Vi har også introdusert en tabellhjelper for å gjøre det lettere å opprette tabeller og en finn og erstatt-funksjon for å gjøre sideredigering lettere.
* '''Wikipedia-logoen:''' Vi har oppdatert logoen vår. Les mer på [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Wikimedia-bloggen] (engelsk).",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}}-fanen''' er nå en stjerne.
* '''{{int:move}}-fanen''' er nå en nedfallsmeny ved siden av søkefeltet.",
	'prefswitch-main-feedback' => '===Tilbakemelding?===
Vi vil gjerne høre fra deg. Besøk vår [[$1|tilbakemeldingsside]] eller, om du er interessert i vårt kontinuerlige arbeid med å forbedre programvaren, besøk vår [http://usability.wikimedia.org brukervennlighetswiki] for mer informasjon.',
	'prefswitch-main-anon' => '===Ta meg tilbake===
Om du vil slå av de nye funksjonene, [$1 klikk her]. Du vil bli spurt om å logge inn eller opprette en konto først.',
	'prefswitch-main-on' => '===Ta meg tilbake===
[$2 Klikk her om du vil slå av de nye funksjonene].',
	'prefswitch-main-off' => '===Prøv dem===
Om du vil slå på de nye funksjonene kan du [$1 klikke her].',
	'prefswitch-survey-intro-feedback' => 'Vi vil gjerne høre fra deg.
Vennligst fyll ut den valgfrie undersøkelsen under før du klikker på «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]».',
	'prefswitch-survey-intro-off' => 'Takk for at du prøvde de nye funksjonene.
For å hjelpe oss med å forbedre dem kan du fylle ut det valgfrie skjemaet under før du klikker på «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».',
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'prefswitch-survey-true' => 'Ee',
	'prefswitch-survey-false' => 'Aowa',
);

/** Occitan (Occitan) */
$messages['oc'] = array(
	'tooltip-pt-prefswitch-link-off' => 'Ensajatz las foncionalitats novèlas',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'prefswitch-link-on' => 'Zerrick bringe',
	'prefswitch-survey-true' => 'Ya',
	'prefswitch-survey-false' => 'Nee',
	'prefswitch-survey-answer-whyoff-other' => 'Annerer Grund:',
	'prefswitch-title-on' => 'Neie Features',
	'prefswitch-title-switched-on' => 'Viel Schpass!',
	'prefswitch-title-switched-off' => 'Danke',
);

/** Polish (Polski)
 * @author Nux
 * @author Saper
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'prefswitch' => 'Włącznik preferencji inicjatywy użyteczności',
	'prefswitch-desc' => 'Pozwala użytkownikom przełączać zestawy preferencji',
	'prefswitch-link-anon' => 'Nowe funkcje',
	'tooltip-pt-prefswitch-link-anon' => 'Więcej informacji o nowych funkcjach',
	'prefswitch-link-on' => 'Stary wygląd',
	'tooltip-pt-prefswitch-link-on' => 'Wyłącz nowe funkcje',
	'prefswitch-link-off' => 'Nowe funkcje',
	'tooltip-pt-prefswitch-link-off' => 'Wypróbuj nowe funkcje',
	'prefswitch-jswarning' => 'Pamiętaj, że po zmianie skórki musisz skopiować swoje [[User:$1/$2.js|$2 dodatki w JavaScripcie]] na stronę [[{{ns:user}}:$1/vector.js]] <!-- lub [[{{ns:user}}:$1/common.js]]--> aby móc z nich nadal korzystać.',
	'prefswitch-csswarning' => 'Twoje [[User:$1/$2.css|własne style $2]] będą od tej chwili wyłączone. Możesz utworzyć własny arkusz CSS przeznaczony dla skórki „Wektor“ na stronie [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Tak',
	'prefswitch-survey-false' => 'Nie',
	'prefswitch-survey-submit-off' => 'Wyłącz nowe funkcje',
	'prefswitch-survey-cancel-off' => 'Jeśli chcesz nadal korzystać z nowych funkcji, możesz powrócić do $1.',
	'prefswitch-survey-submit-feedback' => 'Wyślij opinię',
	'prefswitch-survey-cancel-feedback' => 'Jeśli nie chcesz przesłać swojej opinii, możesz powrócić do $1.',
	'prefswitch-survey-question-like' => 'Co Ci się podoba w nowych funkcjach?',
	'prefswitch-survey-question-dislike' => 'Co Ci się nie podoba w nowych funkcjach?',
	'prefswitch-survey-question-whyoff' => 'Dlaczego rezygnujesz z korzystania z nowych funkcji?
Należy wybrać wszystkie pasujące odpowiedzi.',
	'prefswitch-survey-question-globaloff' => 'Czy chcesz globalnie wyłączyć te funkcje?',
	'prefswitch-survey-answer-whyoff-hard' => 'Korzystanie było zbyt trudne.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Nie działało poprawnie.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Działało w sposób nieprzewidywalny.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Nie podoba mi się wygląd.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Nie podobają mi się nowe zakładki i układ.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nie podoba mi się nowy pasek narzędzi.',
	'prefswitch-survey-answer-whyoff-other' => 'Inny powód',
	'prefswitch-survey-question-browser' => 'Z jakiej korzystasz przeglądarki?',
	'prefswitch-survey-answer-browser-other' => 'Inna przeglądarka',
	'prefswitch-survey-question-os' => 'Z jakiego systemu operacyjnego korzystasz?',
	'prefswitch-survey-answer-os-other' => 'Inny system operacyjny',
	'prefswitch-survey-answer-globaloff-yes' => 'Tak – wyłącz funkcje we wszystkich projektach wiki',
	'prefswitch-survey-question-res' => 'Z ekranu o jakiej rozdzielczości korzystasz?',
	'prefswitch-title-on' => 'Nowe funkcje',
	'prefswitch-title-switched-on' => 'Super!',
	'prefswitch-title-off' => 'Wyłącz nowe funkcje',
	'prefswitch-title-switched-off' => 'Dziękujemy',
	'prefswitch-title-feedback' => 'Opinia',
	'prefswitch-success-on' => 'Nowe funkcje są obecnie włączone. Mamy nadzieję, że spodobają Ci się najnowsze zmiany. W każdej chwili możesz wrócić do poprzedniej wersji klikając na link „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]” znajdujący się na górze strony.',
	'prefswitch-success-off' => 'Nowe funkcje są obecnie wyłączone. Dziękujemy za ich wypróbowanie. Jeśli zechcesz możesz z nich ponownie skorzystać klikając na link „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]” znajdujący się na górze strony.',
	'prefswitch-success-feedback' => 'Twoja opinia została przesłana.',
	'prefswitch-return' => '<hr style="clear:both">
Powrót do <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Widok ekranu nowego interfejsu nawigacyjnego Wikipedii <small>[[Media:VectorNavigation-en.png|(powiększ)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Podstawowy interfejs edycji stron <small>[[Media:VectorEditorBasic-en.png|(powiększ)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Nowe okienko dialogowe do wprowadzania linków
|}
|}
Zespół Fundacji Wikimedia zbierając doświadczenia użytkowników współpracuje z wolontariuszami ze społeczności aby ułatwić Ci korzystanie z {{GRAMMAR:D.pl|{{SITENAME}}}}. Cieszymy się, że możemy zaprezentować niektóre z udoskonaleń, wliczając w to nowy wygląd i nowe, uproszczone funkcje edycyjne. Wprowadzone zmiany mają ułatwić rozpoczęcie pracy nowym użytkownikom i są oparte na [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study doświadczeniach zebranych na przestrzeni ostatniego roku]. Zwiększanie użyteczności naszych projektów jest priorytetem dla Fundacji Wikimedia – z pewności w przyszłości przygotujemy więcej nowych funkcji. Więcej (w języku angielskim) można przeczytać na [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ blogu Wikimedia].

===Oto co zmieniliśmy===
* '''Nawigacja''' – Poprawiliśmy układ strony zarówno w czasie edycji jak i przeglądania. Zakładki na górze strony w bardziej czytelny sposób informują o tym czy oglądasz właściwą stronę czy stronę dyskusji oraz czy tylko przeglądasz czy edytujesz daną stronę.
* '''Udoskonalenia paska narzędziowego''' – Przeorganizowaliśmy pasek narzędziowy, aby łatwiej było się nim posługiwać. Formatowanie stron powinno być teraz prostsze i bardziej intuicyjne.
* '''Kreator linków''' – Łatwe w użyciu narzędzie pozwala na tworzenie linków zarówno do stron wiki, jak i zewnętrznych serwisów.
* '''Udoskonalenia wyszukiwania''' – Dzięki nowym, udoskonalonym podpowiedziom szybko odnajdziesz to czego szukasz.
* '''Inne nowe funkcje''' – Nowy kreator tworzenia tabel oraz okno wyszukiwania i zamiany ułatwiają edycję stron.
* '''Logo Wikipedii''' – Zaktualizowaliśmy logo Wikipedii. Więcej informacji (w języku angielskim) znajdziesz na [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blogu Wikimedia].",
	'prefswitch-main-logged-changes' => "* Przycisk '''{{int:watch}}''' został zastąpiony przyciskiem z gwiazdką.
* Przycisk '''{{int:move}}''' został przeniesiony do menu obok wyszukiwarki.",
	'prefswitch-main-feedback' => '===Opinia===
Bardzo nam zależy na poznaniu Twojej opinii. Odwiedź [[$1|stronę kontaktu]] lub jeśli jesteś zainteresowany zmianami w oprogramowaniu odwiedź [http://usability.wikimedia.org wiki inicjatywy użyteczności].',
	'prefswitch-main-anon' => '=== Chcę wrócić ===
[$1 Kliknij tutaj], jeśli chcesz wyłączyć nowe funkcje. Przed powrotem do starego wyglądu interfejsu musisz utworzyć konto lub zalogować się.',
	'prefswitch-main-on' => '===Chcę to wyłączyć!===
[$2 Kliknij tutaj aby wyłączyć nowe funkcje].',
	'prefswitch-main-off' => '===Wypróbuj!===
Jeśli chcesz przetestować nowe funkcje po prostu [$1 kliknij tutaj].',
	'prefswitch-survey-intro-feedback' => 'Chcielibyśmy poznać Twoją opinię.
Będziemy wdzięczni za wypełnienie poniższej ankiety zanim klikniesz „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]”.',
	'prefswitch-survey-intro-off' => 'Dziękujemy za wypróbowanie nowych funkcji.
Jeśli chcesz nam pomóc je udoskonalić, przed kliknięciem „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]” wypełnij poniższą ankietę.',
	'prefswitch-feedbackpage' => 'Project:Użyteczność – księga skarg, zażaleń i pomysłów',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'prefswitch' => "Cangiament dij gust ëd l'inissiativa d'utilisassion còmoda",
	'prefswitch-desc' => "Përmëtte a j'utent ëd cangé j'ansema dij gust",
	'prefswitch-link-anon' => 'Neuve funsionalità',
	'tooltip-pt-prefswitch-link-anon' => 'Ampara le neuve funsionalità',
	'prefswitch-link-on' => 'Pòrtme andré',
	'tooltip-pt-prefswitch-link-on' => 'Disabilité le neuve funsionalità',
	'prefswitch-link-off' => 'Neuve funsionalità',
	'tooltip-pt-prefswitch-link-off' => 'Preuva le neuve funsionalità',
	'prefswitch-jswarning' => "Ch'as visa che con ël cambi ëd pel, sò [[User:$1/$2.js|$2 JavaScript]] a dovrà esse copià su [[{{ns:user}}:$1/vector.js]] <!-- o [[{{ns:user}}:$1/common.js]]--> për continué a travajé.",
	'prefswitch-csswarning' => 'Ij tò [[User:$1/$2.css|stij utent për $2]]  a saran pa pi aplicà. It peule gionté CSS përsonalisà për vector an [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'É',
	'prefswitch-survey-false' => 'Nò',
	'prefswitch-survey-submit-off' => 'Disativa le funsionalità neuve',
	'prefswitch-survey-cancel-off' => "S'a veul continué a dovré le possibilità neuve, a peul torné a $1.",
	'prefswitch-survey-submit-feedback' => 'Mandé dij sugeriment',
	'prefswitch-survey-cancel-feedback' => "S'a veul pa dé ëd sugeriment, a peul torné a $1.",
	'prefswitch-survey-question-like' => "Lòn ch'at pias ëd le neuve funsionalità?",
	'prefswitch-survey-question-dislike' => "Lòn ch'at pias pa ëd le neuve funsionalità?",
	'prefswitch-survey-question-whyoff' => "Përchè a veul disativé le possibilità neuve?
Për piasì, ch'a selession-a tute le motivassion.",
	'prefswitch-survey-question-globaloff' => 'Veus-to che le funsion a sio dëstissà globalment?',
	'prefswitch-survey-answer-whyoff-hard' => "A l'era tròp malfé dovrelo.",
	'prefswitch-survey-answer-whyoff-didntwork' => 'A marciava nen bin.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'A marciava pa coma spetà.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Am piasìa nen sò aspet.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'A son nen piasume ij neuv quàder e la neuva disposission.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => "A l'é nen piasume la neuva bara dj'utiss.",
	'prefswitch-survey-answer-whyoff-other' => 'Àutra rason:',
	'prefswitch-survey-question-browser' => "Che navigador ch'a deuvra?",
	'prefswitch-survey-answer-browser-other' => 'Àutr navigador:',
	'prefswitch-survey-question-os' => "Che sistema operativ ch'a deuvra?",
	'prefswitch-survey-answer-os-other' => 'Àutr sistema operativ:',
	'prefswitch-survey-answer-globaloff-yes' => 'É!, dëstissa le funsion su tute le wiki',
	'prefswitch-survey-question-res' => "Cola ch'a l'é l'arzolussion ëd tò scren?",
	'prefswitch-title-on' => 'Neuve funsionalità',
	'prefswitch-title-switched-on' => 'Fate gòj!',
	'prefswitch-title-off' => 'Disativa le possibilità neuve',
	'prefswitch-title-switched-off' => 'Mersì',
	'prefswitch-title-feedback' => 'Sugeriment',
	'prefswitch-success-on' => 'Le neuve funsionalità a son adess ativà. I speroma ch\'a-j piasa dovré le neuve funsionalità. A peul sempe gaveje via an sgnacand dzora al colegament "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" an cò dla pàgina.',
	'prefswitch-success-off' => 'Le neuve funsionalità a son adess disativà. Mersì për avèj provà le neuve funsionalità. A peul sempe torna buteje an sgnacand dzora al colegament "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" an cò dla pàgina.',
	'prefswitch-success-feedback' => 'Ij sò coment a son ëstàit mandà.',
	'prefswitch-return' => '<hr style="clear:both">
Artorna a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Në scren ëd la neuva antërfacia ëd navigassion ëd Wikipedia <small>[[Media:VectorNavigation-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Në scren ëd l'antërfacia ëd modìfica dla pàgina base <small>[[Media:VectorEditorBasic-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Në scren dla neuva fnestra ëd diàlogh për anserì dj'anliure
|}
|}
L'echip User Experience ëd la Fondassion Wikimedia a l'ha travajà con ij volontari dla comunità për fé le ròbe pi belfé për vojàutri. I l'oma gòj ëd condivide chèich ameliorament, comprèis na presentassion neuva e dle possibilità ëd modìfica semplificà. Coste modìfiche a vorërìo rende pi belfé ancaminé për ij neuv contributor, e a son basà an sle nòste [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study preuve d'usage fàite ant l'ùltim ann]. Amelioré la comodità d'utilisassion dij nòstri proget a l'é na priorità dla Fondassion Wikimedia e noi i condivideroma d'àutre modìfiche ant l'avnì. Për savèjne ëd pi, ch'a vìsita ël sit colegà [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ scartari ëd Wikimedia]

===Ambelessì a-i é lòn ch'i l'oma cangià===
* '''Navigassion:''' I l'oma ameliorà la navigassion për lese e modifiché le pàgine. Adess, ij test an cò ëd minca pàgina a definisso ëd fasson pì ciàira s'a l'é an camin ch'a vëd na pàgina o na pàgina ëd discussion, e s'a l'é an camin a lese o a modifiché na pàgina.
* '''Ameliorament ëd la bara dj'utiss ëd modìfica:''' I l'oma riorganisà la bara dj'utiss ëd modìfica për ch'a fussa pi belfé dovrela. Adess, l'ampaginassion a l'é pi sempia e pi intuitiva.
* '''Assistent dij colegament:''' N'utiss bel da dovré a-j përmët ëd gionté d'anliure a d'àutre pàgine ëd Wikipedia e ëd colegament a d'àutri sit.
* '''Ameliorament ëd l'arserca:''' I l'oma ameliorà ij sugeriment d'arserca për portelo pi an pressa a la pàgina ch'a sërca.
* '''Àutre possibilità neuve:''' I l'oma ëdcò giontà n'assistent për le tàule për rende pì bel fé creé e trové le tàule e na possibilità ëd rimpiass për semplifiché la modìfica ëd le pàgine.
* '''Wikipedia puzzle globe''': I l'oma modificà ël puzzle globe. Ch'a lesa ëd pi an slë [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ scartari ëd Wikimedia].",
	'prefswitch-main-logged-changes' => "* La '''tichëtta {{int:watch}}''' adess a l'é na stèila.
* La '''tichëtta {{int:move}}''' adess a l'é ant la lista a ridò da banda dla bara d'arserca.",
	'prefswitch-main-feedback' => "===Coment?===
An piasrìa sentje da chiel. Për piasì, ch'a vìsita nòsta [[$1|pàgina ëd coment]] o, s'a l'é anteressà a jë sfòrs ch'i foma për amelioré ël programa, ch'a vìsita nòsta [http://usability.wikimedia.org wiki për la dovrabilità] për savèjne ëd pi.",
	'prefswitch-main-anon' => "===Pòrtme andré===
S'it veule disabilité le neuve funsionalità, [$1 sgnaca sì]. At sarà ciamà d'intré o ëd creé prima un cont.",
	'prefswitch-main-on' => "===Porteme andré===
[$2 Ch'a sgnaca ambelessì për disativé le neuve fonsionalità].",
	'prefswitch-main-off' => "===Preuvje!===
S'it veule ativé le possibilità neuve, për piasì [$1 sgnaca ambelessì].",
	'prefswitch-survey-intro-feedback' => 'An piasrìa sente soa opinion.
Për piasì, ch\'a ampinissa ël sondagi opsional sì-sota an sgnacand "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Mersì ëd prové nòstre neuve funsionalità.
Për giutene a amelioreje, për piasì ch\'a ampinissa ël sondagi opsional sì-sota an sgnacand "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'prefswitch-link-anon' => 'نوې ځانګړنې',
	'tooltip-pt-prefswitch-link-anon' => 'د نوؤ ځانګړنو په اړه مالومات',
	'prefswitch-link-on' => 'بېرته پر شا ستنېدل',
	'tooltip-pt-prefswitch-link-on' => 'نوې ځانګړنې ناچارنده کول',
	'prefswitch-link-off' => 'نوې ځانګړنې',
	'tooltip-pt-prefswitch-link-off' => 'نوې ځانګړنې آزمويل',
	'prefswitch-survey-true' => 'هو',
	'prefswitch-survey-false' => 'نه',
	'prefswitch-survey-question-like' => 'په نوؤ ځانګړنو کې مو څه خوښ شول؟',
	'prefswitch-survey-question-dislike' => 'په نوؤ ځانګړنو کې مو څه خوښ نه شول؟',
	'prefswitch-survey-answer-whyoff-hard' => 'د نوؤ ځانګړنو کارېدنه ډېره ستونزمنه وه.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'زما نوې توکپټه خوښه نه شوه.',
	'prefswitch-survey-answer-whyoff-other' => 'بل سبب:',
	'prefswitch-survey-question-browser' => 'تاسې کوم کتنمل کاروۍ؟',
	'prefswitch-survey-answer-browser-other' => 'بل کتنمل:',
	'prefswitch-survey-question-os' => 'تاسې کوم چليز غونډال کاروۍ؟',
	'prefswitch-survey-answer-os-other' => 'بل چليز غونډال:',
	'prefswitch-title-on' => 'نوې ځانګړنې',
	'prefswitch-title-switched-on' => 'خوند ترې واخلۍ!',
	'prefswitch-title-switched-off' => 'مننه',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author McDutchie
 */
$messages['pt'] = array(
	'prefswitch' => 'Activar ou desactivar a Iniciativa de Usabilidade',
	'prefswitch-desc' => 'Permitir que os utilizadores mudem conjuntos de preferências',
	'prefswitch-link-anon' => 'Funcionalidades novas',
	'tooltip-pt-prefswitch-link-anon' => 'Descubra as funcionalidades novas',
	'prefswitch-link-on' => 'Voltar atrás',
	'tooltip-pt-prefswitch-link-on' => 'Desactivar as funcionalidades novas',
	'prefswitch-link-off' => 'Funcionalidades novas',
	'tooltip-pt-prefswitch-link-off' => 'Experimente novas funcionalidades',
	'prefswitch-jswarning' => 'Lembre-se que com a mudança de tema o seu [[User:$1/$2.js|javascript $2]] terá de ser copiado para [[User:$1/vector.js]] ou [[User:$1/common.js]] para continuar a funcionar.',
	'prefswitch-csswarning' => 'Os seus [[User:$1/$2.css|estilos personalizados $2]] deixarão de ser aplicados. Pode adicionar CSS personalizado ao tema vector em [[User:$1/vector.css]].',
	'prefswitch-survey-true' => 'Sim',
	'prefswitch-survey-false' => 'Não',
	'prefswitch-survey-submit-off' => 'Desligar as funcionalidades novas',
	'prefswitch-survey-cancel-off' => 'Se quiser continuar a usar as funcionalidades novas, pode voltar à $1.',
	'prefswitch-survey-submit-feedback' => 'Enviar comentário',
	'prefswitch-survey-cancel-feedback' => 'Se não quiser fazer um comentário, pode voltar à $1.',
	'prefswitch-survey-question-like' => 'De que coisas gostou nas funcionalidades novas?',
	'prefswitch-survey-question-dislike' => 'De que coisas não gostou nas funcionalidades novas?',
	'prefswitch-survey-question-whyoff' => 'Por que é que quer desligar as funcionalidades novas?
Seleccione todas as opções que se aplicam, por favor.',
	'prefswitch-survey-question-globaloff' => 'Quer desligar as funcionalidades globalmente?',
	'prefswitch-survey-answer-whyoff-hard' => 'As funcionalidades foram demasiado difíceis de utilizar.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'As funcionalidades não funcionaram correctamente.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'As funcionalidades não tiveram o comportamento esperado.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Não gostei da aparência.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Não gostei dos novos separadores e da disposição dos elementos na página.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Não gostei da nova barra de ferramentas.',
	'prefswitch-survey-answer-whyoff-other' => 'Outro motivo:',
	'prefswitch-survey-question-browser' => 'Qual é o browser que usa?',
	'prefswitch-survey-answer-browser-other' => 'Outro browser:',
	'prefswitch-survey-question-os' => 'Qual é o sistema operativo que usa?',
	'prefswitch-survey-answer-os-other' => 'Outro sistema operativo:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sim, desligar as funcionalidades em todas as wikis',
	'prefswitch-survey-question-res' => 'Qual é a resolução do seu monitor?',
	'prefswitch-title-on' => 'Funcionalidades novas',
	'prefswitch-title-switched-on' => 'Desfrute!',
	'prefswitch-title-off' => 'Desligar funcionalidades novas',
	'prefswitch-title-switched-off' => 'Obrigado',
	'prefswitch-title-feedback' => 'Comentário',
	'prefswitch-success-on' => 'As funcionalidades novas estão agora activadas. Esperamos que goste de usá-las. Pode voltar a desactivá-las em qualquer altura, clicando o link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" no topo da página.',
	'prefswitch-success-off' => 'As funcionalidades novas estão agora desactivadas. Obrigado por tê-las experimentado. Pode voltar a activá-las em qualquer altura, clicando o link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" no topo da página.',
	'prefswitch-success-feedback' => 'O seu comentário foi enviado.',
	'prefswitch-return' => '<hr style="clear:both">
Voltar para <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-pt.png|401px|]]
|-
| Imagem da nova interface de navegação da Wikipédia <small>[[Media:VectorNavigation-pt.png|(aumentar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-pt.png|401px|]]
|-
| Imagem da interface de edição básica de páginas <small>[[Media:VectorEditorBasic-pt.png|(aumentar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-pt.png|401px|]]
|-
| Imagem da nova caixa de diálogo para inserir links
|}
|}
A Equipa de Experiência de Utilização (User Experience Team) da Wikimedia Foundation tem trabalhado em conjunto com voluntários da comunidade para tornar mais fácil a utilização do nosso software. É com prazer que agora partilhamos alguns melhoramentos, incluindo uma nova aparência e a simplificação das funcionalidades de edição. Estas alterações têm por objectivo tornar as primeiras edições mais fáceis para os novos utilizadores e têm por base o nosso [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study teste de usabilidade conduzido durante o ano passado]. Melhorar a usabilidade dos nossos projectos é uma prioridade para a Wikimedia Foundation e mais alterações serão comunicadas no futuro. Para mais detalhes, visite esta [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia publicação no blogue] Wikimedia.

===O que foi alterado===
* '''Navegação:''' A navegação para leitura e edição de páginas foi melhorada. Agora, os separadores no topo de cada página definem mais claramente se está a visionar a página em si ou a respectiva página de discussão, e se está a ler ou a editar a página.
* '''Melhorias na barra das ferramentas de edição:''' A barra de edição foi reorganizada para ser mais fácil de usar. Agora, a formatação de páginas é mais simples e intuitiva.
* '''Assistente para links:''' Uma ferramenta de fácil utilização permite-lhe criar tanto links para outras páginas da Wikipédia como links para outros sites externos.
* '''Melhoramentos da pesquisa:''' Melhorámos as sugestões da pesquisa para levá-lo mais rapidamente à página que procura.
* '''Outras funcionalidades novas:''' Também introduzimos um assistente para facilitar a criação de tabelas, e uma funcionalidade de procura e substituição para simplificar a edição de páginas.
* '''Logótipo da Wikipédia:''' Actualizámos o nosso logótipo. Leia mais sobre a actualização no [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blogue Wikimedia].",
	'prefswitch-main-logged-changes' => "* O '''separador {{int:watch}}''' é agora uma estrela.
* O '''separador {{int:move}}''' está agora na lista descendente ao lado da caixa de pesquisa.",
	'prefswitch-main-feedback' => '===O seu comentário?===
Gostariamos de conhecer a sua opinião. Visite a nossa [[$1|página de comentários]], por favor. Se tiver interesse em acompanhar os esforços continuados de melhoria do software, visite a nossa [http://usability.wikimedia.org wiki da usabilidade] para mais informação.',
	'prefswitch-main-anon' => '===Voltar atrás===
[$1 Clique aqui para desactivar as funcionalidades novas]. Será pedido que se autentique ou crie uma conta.',
	'prefswitch-main-on' => '===Voltar atrás!===
[$2 Clique aqui para desligar as funcionalidades novas].',
	'prefswitch-main-off' => '===Experimente-as!===
[$1 Clique aqui para activar as funcionalidades novas].',
	'prefswitch-survey-intro-feedback' => 'Gostariamos de saber a sua opinião.
Preencha o questionário opcional abaixo, antes de clicar "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]", por favor.',
	'prefswitch-survey-intro-off' => 'Obrigado por ter experimentado as funcionalidades novas.
Para ajudar-nos a melhorá-las preencha, por favor, o questionário opcional abaixo, antes de clicar "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Comentário sobre a experiência de utilização',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author 555
 * @author Giro720
 * @author Raylton P. Sousa
 */
$messages['pt-br'] = array(
	'prefswitch' => 'Preferências da Iniciativa de Usabilidade',
	'prefswitch-desc' => 'Permitir que os usuários mudem os conjuntos de preferências',
	'prefswitch-link-anon' => 'Funcionalidades novas',
	'tooltip-pt-prefswitch-link-anon' => 'Descubra as funcionalidades novas',
	'prefswitch-link-on' => 'Voltar atrás',
	'tooltip-pt-prefswitch-link-on' => 'Desativar as funcionalidades novas',
	'prefswitch-link-off' => 'Funcionalidades novas',
	'tooltip-pt-prefswitch-link-off' => 'Experimente as novas funcionalidades',
	'prefswitch-jswarning' => 'Lembre-se que com a mudança de tema o seu [[User:$1/$2.js|javascript $2]] terá de ser copiado para [[User:$1/vector.js]] ou [[User:$1/common.js]] para continuar',
	'prefswitch-csswarning' => 'Os seus [[User:$1/$2.css|estilos personalizados $2]] deixarão de ser aplicados. Você pode adicionar CSS personalizado ao tema vector em [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Sim',
	'prefswitch-survey-false' => 'Não',
	'prefswitch-survey-submit-off' => 'Desligar as funcionalidades novas',
	'prefswitch-survey-cancel-off' => 'Se quiser continuar usando as novas funcionalidades, você pode voltar à $1.',
	'prefswitch-survey-submit-feedback' => 'Enviar comentário',
	'prefswitch-survey-cancel-feedback' => 'Se não quiser fazer um comentário, pode voltar à $1.',
	'prefswitch-survey-question-like' => 'De que coisas gostou nas funcionalidades novas?',
	'prefswitch-survey-question-dislike' => 'De que coisas não gostou nas funcionalidades novas?',
	'prefswitch-survey-question-whyoff' => 'Por que você está desligando as novas funcionalidades?
Selecione todas as opções que se aplicam, por favor.',
	'prefswitch-survey-question-globaloff' => 'Quer desligar as funcionalidades globalmente?',
	'prefswitch-survey-answer-whyoff-hard' => 'As funcionalidades eram muito difíceis de utilizar.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'As funcionalidades não funcionaram corretamente.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'As funcionalidades não tiveram o comportamento esperado.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Não gostei da aparência.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Não gostei dos novos separadores e da disposição dos elementos na página.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Não gostei da nova barra de ferramentas.',
	'prefswitch-survey-answer-whyoff-other' => 'Outro motivo:',
	'prefswitch-survey-question-browser' => 'Qual é o navegador que você utiliza?',
	'prefswitch-survey-answer-browser-other' => 'Outro navegador:',
	'prefswitch-survey-question-os' => 'Qual é o sistema operacional que você usa?',
	'prefswitch-survey-answer-os-other' => 'Outro sistema operacional:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sim, desligar as funcionalidades em todas as wikis',
	'prefswitch-survey-question-res' => 'Qual é a resolução do seu monitor?',
	'prefswitch-title-on' => 'Funcionalidades novas',
	'prefswitch-title-switched-on' => 'Desfrute!',
	'prefswitch-title-off' => 'Desligar funcionalidades novas',
	'prefswitch-title-switched-off' => 'Obrigado',
	'prefswitch-title-feedback' => 'Comentários',
	'prefswitch-success-on' => 'As funcionalidades novas foram ativadas. Esperamos que goste de usá-las. Você pode desativá-las a qualquer momento, clicando no link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" no topo da página.',
	'prefswitch-success-off' => 'As funcionalidades novas foram desativadas. Obrigado por tê-las experimentado. Pode voltar a ativá-las em qualquer momento, clicando no link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" no topo da página.',
	'prefswitch-success-feedback' => 'O seu comentário foi enviado.',
	'prefswitch-return' => '<hr style="clear:both">
Voltar para <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Imagem da nova interface de navegação da Wikipédia <small>[[Media:VectorNavigation-en.png|(aumentar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Imagem da interface de edição básica de páginas <small>[[Media:VectorEditorBasic-en.png|(aumentar)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Imagem da nova caixa de diálogo para inserir links
|}
|}
A Equipe de Experiência de Utilização (User Experience Team) da Wikimedia Foundation tem trabalhado em conjunto com voluntários da comunidade para tornar mais fácil a utilização do nosso software. É com prazer que agora partilhamos alguns melhoramentos, incluindo uma nova aparência e a simplificação das funcionalidades de edição. Estas alterações têm por objectivo tornar as primeiras edições mais fáceis para os novos utilizadores e têm por base o nosso [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study teste de usabilidade conduzido durante o ano passado]. Melhorar a usabilidade dos nossos projetos é uma prioridade para a Wikimedia Foundation e mais alterações serão comunicadas no futuro. Para mais detalhes, visite esta [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia publicação no blogue] Wikimedia.

===O que foi alterado===
* '''Navegação:''' A navegação para leitura e edição de páginas foi melhorada. Agora, os separadores no topo de cada página definem mais claramente se está a visionar a página em si ou a respectiva página de discussão, e se está a ler ou a editar a página.
* '''Melhorias na barra das ferramentas de edição:''' A barra de edição foi reorganizada para ser mais fácil de usar. Agora, a formatação de páginas é mais simples e intuitiva.
* '''Assistente para links:''' Uma ferramenta de fácil utilização permite-lhe criar tanto links para outras páginas da Wikipédia como links para outros sites externos.
* '''Melhoramentos da pesquisa:''' Melhoramos as sugestões da pesquisa para levá-lo mais rapidamente à página que procura.
* '''Outras funcionalidades novas:''' Também introduzimos um assistente para facilitar a criação de tabelas, e uma funcionalidade de procura e substituição para simplificar a edição de páginas.
* '''Logotipo da Wikipédia:''' Atualizamos o nosso logotipo. Leia mais sobre a atualização no [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blogue Wikimedia].",
	'prefswitch-main-logged-changes' => "* O '''separador {{int:watch}}''' é agora uma estrela.
* O '''separador {{int:move}}''' está agora na lista descendente ao lado da barra de pesquisa.",
	'prefswitch-main-feedback' => '===O seu comentário?===
Gostaríamos de conhecer a sua opinião. Visite a nossa [[$1|página de comentários]], por favor. Se tiver interesse em acompanhar os esforços continuados de melhoria do software, visite a nossa [http://usability.wikimedia.org wiki da usabilidade] para mais informação.',
	'prefswitch-main-anon' => '===Voltar atrás===
[$1 Clique aqui para desativar as funcionalidades novas]. Será pedido que se autentique ou crie uma conta.',
	'prefswitch-main-on' => '===Voltar atrás!===
[$2 Clique aqui para desligar as funcionalidades novas].',
	'prefswitch-main-off' => '===Experimente-as!===
[$1 Clique aqui para ativar as funcionalidades novas].',
	'prefswitch-survey-intro-feedback' => 'Gostaríamos de saber a sua opinião.
Preencha o questionário opcional abaixo, antes de clicar "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]", por favor.',
	'prefswitch-survey-intro-off' => 'Obrigado por ter experimentado as funcionalidades novas.
Para ajudar-nos a melhorá-las preencha, por favor, o questionário opcional abaixo, antes de clicar "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Comentário sobre a experiência de utilização',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'prefswitch' => "Llamk'apunalla ruraykachanapaq allinkachina churana",
	'prefswitch-desc' => 'Ruraqkunata atichiy allinkachina tawqakunata churanapaq',
	'prefswitch-link-anon' => 'Musuq kaqninkuna',
	'tooltip-pt-prefswitch-link-anon' => 'Musuq kaqninkunamanta yachaqay',
	'prefswitch-link-on' => 'Kutichimuway',
	'tooltip-pt-prefswitch-link-on' => "Musuq kaqninkunata hark'ay",
	'prefswitch-link-off' => 'Musuq kaqninkuna',
	'tooltip-pt-prefswitch-link-off' => 'Musuq kaqninkunata llanchiy',
	'prefswitch-jswarning' => "Uyapura qara wakinchasqa kaptinqa, [[User:$1/$2.js|$2 JavaScript]]-niyki [[{{ns:user}}:$1/vector.js]]-man iskaychanam tiyanqa <!-- or [[{{ns:user}}:$1/common.js]]--> qhipaqtapas llamk'anaykipaq.",
	'prefswitch-csswarning' => "[[User:$1/$2.css|Kikinchasqa $2 rikch'akuyniykiqa]] manañam llamk'anqachu. Vector qarapaq kikinchasqa CSS nisqata yapayta atinki [[{{ns:user}}:$1/vector.css]]-pi.",
	'prefswitch-survey-true' => 'Arí',
	'prefswitch-survey-false' => 'Ama kachunchu',
	'prefswitch-survey-submit-off' => "Musuq kaqninkunata hark'ay",
	'prefswitch-survey-cancel-off' => "Musuq kaqninkunawan qhipaqtaraq llamk'ayta munaspaykiqa, $1-man kutimuyta atinki.",
	'prefswitch-survey-submit-feedback' => 'Musuq kaqninkunamanta rimanakuy',
	'prefswitch-survey-cancel-feedback' => 'Musuq kaqninkunamanta mana rimanakuyta munaspaykiqa, $1-man kutimuyta atinki.',
	'prefswitch-survey-question-like' => 'Imatataq musuq kaqninkunapi munanki?',
	'prefswitch-survey-question-dislike' => 'Imatataq musuq kaqninkunapi manam munankichu?',
	'prefswitch-survey-question-whyoff' => "Imaraykutaq musuq kaqninkunata hark'achkanki?
Ama hina kaspa, tukuy paqtaqta akllay.",
	'prefswitch-survey-question-globaloff' => "Musuq kaqninkunata tukuy wikikunapi hark'ayta munankichu?",
	'prefswitch-survey-answer-whyoff-hard' => "Kaqninkunataqa sasallatam llamk'achini.",
	'prefswitch-survey-answer-whyoff-didntwork' => "Kaqninkunaqa manam allinta llamk'ankuchu.",
	'prefswitch-survey-answer-whyoff-notpredictable' => "Kaqninkunap llamk'anantaqa manam qhipaqta yachanichu.",
	'prefswitch-survey-answer-whyoff-didntlike-look' => "Kaqninkunap rikch'akuynintaqa manam munanichu.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "Musuq sulapakunatapas rikch'akuynintapas manam munanichu.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => "Musuq llamk'ana sinrutaqa manam munanichu.",
	'prefswitch-survey-answer-whyoff-other' => 'Huk rayku:',
	'prefswitch-survey-question-browser' => "Mayqin llika wamp'unatataq llamk'achinki?",
	'prefswitch-survey-answer-browser-other' => "Huk llika wamp'una:",
	'prefswitch-survey-question-os' => "Mayqin llamk'aykuna llikatataq (OS nisqata) llamk'achinki?",
	'prefswitch-survey-answer-os-other' => "Huk llamk'aykuna llika (OS):",
	'prefswitch-survey-answer-globaloff-yes' => "Arí, musuq kaqninkunata tukuy wikikunapi hark'ay",
	'prefswitch-survey-question-res' => 'Qhawana pampaykiri ima huyakuyuqtaq?',
	'prefswitch-title-on' => 'Musuq kaqninkuna',
	'prefswitch-title-switched-on' => "Kusikuspalla llamk'ariy!",
	'prefswitch-title-off' => "Musuq kaqninkunata hark'ay",
	'prefswitch-title-switched-off' => 'Añañayki',
	'prefswitch-title-feedback' => 'Rimanakuy',
	'prefswitch-success-on' => "Musuq kaqninkunaqa kunan llamk'achkankum. Amalay, musuq kaqninkunaqa kusichisunkiku. Ima hayk'appas chay kaqninkunataqa hark'ayta atinki p'anqap hawanpi kaq \"[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]\" nisqa t'inkita ñit'ispa.",
	'prefswitch-success-off' => "Musuq kaqninkunaqa manañam llamk'achkankuchu. Añañayki musuq kaqninkunata llanchisqaykimanta. Ima hayk'appas chay kaqninkunataqa kutichimuyta atinki p'anqap hawanpi kaq \"[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]\" nisqa t'inkita ñit'ispa.",
	'prefswitch-success-feedback' => 'Rimanakuypaq willasqaykiqa kachasqañam.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span>-man kutimuy.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Wikipidiyap musuq wamp'una uyapuranmanta qhawanapampa rikch'a <small>[[Media:VectorNavigation-en.png|(hatunchay)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Tiksi p'anqa llamk'apuna uyapuramanta qhawanapampa rikch'a <small>[[Media:VectorEditorBasic-en.png|(hatunchay)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| T'inkikunata sat'inapaq musuq chimpapurari kahamanta qhawanapampa rikch'a
|}
|}
Wikimedia Foundation nisqap Ruraqkuna Rurayyachay Qhuchu ruraqkunap ayllunmanta munaqlla yanapaqkunawan llamk'achkan imakunatapas atinllachanapaq. Kusikuykum allinchasqakunata rakinakuspa, ahinataq musuq rikch'akuyninta, atinllayasqa llamk'apunakunatapas. Kay musuq kaqninkunataqa rurayku musuq ruraqkunapaq yanapayta atinllachanapaqmi, [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study qayna watapi ruranalla llanchiyta ruraspayku]. Ruraykamayniykupaq ruranallata allinchayqa Wikimedia Foundation nisqapaq anchayupam - hamuq pacha aswan musuqchanakunatapas rakinakusaqkum. Aswan yuyaykunapaqqa, kaymanta Wikimedia [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog post] nisqaman riy.

=== Kaykunatam musuqcharquyku ===
* '''Wamp'uy:''' Wamp'uytam allincharquyku p'anqakunata ñawirinapaqpas llamk'apunapaqpas. Kunanqa, tukuy p'anqap patanpi kaq qichiprakuna aswan ch'uyatam rikuchinku p'anqatachu rimanakuynintachu rikunkichu, icha p'anqata qhawallankichu llamk'apunkichu.
* '''Allinchasqa llamk'apunapaq butunnintin uma siq'i:''' Llamk'apunapaq butunnintin uma siq'itam musuqcharquyku aswan atinlla llamk'achinaykipaq. Kunanqa, p'anqakunata aswan sikllallata aswan sunqullamanta sumaqchanki.
* '''T'inki layqa:''' Musuq sikllalla llamk'anawanmi wikipi huk p'anqakunaman icha hawa tiyaykunaman t'inkikunata yapanki.
* '''Allinchasqa maskana:''' Maskaypi rikuriq sakumaykunatam allincharquyku maskasqayki p'anqata aswan utqaylla taripanaykipaq.
* '''Huk musuq kaqninkuna:''' Wachuchasqapaq layqatam wallparirquyku wachuchasqakunata aswan sikllallata kamarinaykipaq, tarina huknachana khillaytapas p'anqa llamk'apuyta atinllachanapaq.
* '''Wikipidiya unancha:''' Unanchaykutam musuqcharquyku. Astawan [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog] nisqapi ñawiriy.",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} qhichipra'''qa kunan quyllurmi kachkan.
* '''{{int:move}} qhichipra'''qa kunan maskana sinrup kinrayninpi rikuchinapim rikch'akun.",
	'prefswitch-main-feedback' => "===Kaymanta willaspa rimanakuy?===
Qammanta uyarispaykuqa anchata kusirikuykuman.
Ama hina kaspa, [[$1|rimanakuy p'anqaykuman]] hamuy. Kay llamp'u kaqta allinchanapaq qatinlla aypaykachayniykumanta uyariyta munaspaykiqa, [http://usability.wikimedia.org llamk'apunalla wikiykuman] hamuy astawan yachakunaykipaq.",
	'prefswitch-main-anon' => "===Kutichimuway===
[$1 Kaypi ñit'iy musuq kaqninkunata hark'anapaq]. Yaykunaykita icha rakiquna kicharinaykita ñawpaqta mañasunkiku.",
	'prefswitch-main-on' => "===Kutichimuway!===
[$2 Kaypi ñit'iy musuq kaqninkunata hark'anapaq].",
	'prefswitch-main-off' => "===Llanchiy!===
[$1 Kaypi ñit'iy musuq kaqninkunata atichinapaq].",
	'prefswitch-survey-intro-feedback' => "Qammanta uyarispaykuqa anchata kusirikuykuman.
Ama hina kaspa, kay qatiqpi munalla tapuykuy p'anqata hunt'ay \"[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]\" nisqata ñit'ispa.",
	'prefswitch-survey-intro-off' => "Añañayki musuq kaqninkunata llanchisqaykimanta.
Allinchaywan yanapawanaykipaqqa, kay qatiqpi munalla tapuykuy p'anqata hunt'ariy \"[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]\" nisqata ñit'ispa.",
	'prefswitch-feedbackpage' => 'Project:User experience feedback',
);

/** Romanian (Română)
 * @author AdiJapan
 * @author Cin
 * @author Minisarm
 */
$messages['ro'] = array(
	'prefswitch' => 'Comutarea preferințelor Inițiativei de Utilizabilitate',
	'prefswitch-desc' => 'Permite utilizatorilor să comute preferințe',
	'prefswitch-link-anon' => 'Noi funcționalități',
	'tooltip-pt-prefswitch-link-anon' => 'Aflați mai multe despre noile funcționalități',
	'prefswitch-link-on' => 'Interfața veche',
	'tooltip-pt-prefswitch-link-on' => 'Dezactivează noile funcționalități',
	'prefswitch-link-off' => 'Noi funcționalități',
	'tooltip-pt-prefswitch-link-off' => 'Încercați noile funcționalități',
	'prefswitch-jswarning' => 'Rețineți că, o dată schimbată interfața, conținutul paginii [[User:$1/$2.js|$2 JavaScript]] va trebui copiat în [[{{ns:user}}:$1/vector.js]] <!-- sau [[{{ns:user}}:$1/common.js]]--> pentru a putea funcționa în continuare.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|Stilul dv. personalizat $2]] nu va mai fi aplicat. Puteți adăuga un cod CSS personalizat pentru interfața vector în [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Da',
	'prefswitch-survey-false' => 'Nu',
	'prefswitch-survey-submit-off' => 'Dezactivează noile funcționalități',
	'prefswitch-survey-cancel-off' => 'Dacă doriți să continuați folosirea noilor funcționalități, puteți să reveniți la $1.',
	'prefswitch-survey-submit-feedback' => 'Trimite feedback',
	'prefswitch-survey-cancel-feedback' => 'Dacă nu doriți să comentați vă puteți întoarce la $1.',
	'prefswitch-survey-question-like' => 'Ce v-a plăcut la noile funcționalități?',
	'prefswitch-survey-question-dislike' => 'Ce v-a displăcut la funcționalități?',
	'prefswitch-survey-question-whyoff' => 'Ce vă face să dezactivați noile funcționalități?
Selectați toate răspunsurile care se potrivesc.',
	'prefswitch-survey-question-globaloff' => 'Doriți ca funcționalitățile să fie dezactivate global?',
	'prefswitch-survey-answer-whyoff-hard' => 'Prea greu de folosit.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Nu funcționa cum trebuie.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Funcționalitățile sînt impredictibile.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Nu mi-a plăcut aspectul.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Nu mi-au plăcut filele noi și aspectul.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nu mi-a plăcut noua bară de unelte.',
	'prefswitch-survey-answer-whyoff-other' => 'Alt motiv:',
	'prefswitch-survey-question-browser' => 'Ce navigator folosiți?',
	'prefswitch-survey-answer-browser-other' => 'Alt navigator:',
	'prefswitch-survey-question-os' => 'Ce sistem de operare folosiți?',
	'prefswitch-survey-answer-os-other' => 'Alt sistem de operare:',
	'prefswitch-survey-answer-globaloff-yes' => 'Da, dezactivează funcționalitățile de pe toate site-urile wiki',
	'prefswitch-survey-question-res' => 'Ce rezoluție are ecranul dumneavoastră?',
	'prefswitch-title-on' => 'Noi funcționalități',
	'prefswitch-title-switched-on' => 'Distracție plăcută!',
	'prefswitch-title-off' => 'Dezactivarea noilor funcționalități',
	'prefswitch-title-switched-off' => 'Mulțumim',
	'prefswitch-title-feedback' => 'Comentarii',
	'prefswitch-success-on' => 'Noile funcționalități au fost activate. Sperăm că vă vor plăcea. Le puteți dezactiva apăsînd pe „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]”, în partea de sus a paginii.',
	'prefswitch-success-off' => 'Noile funcționalități au fost dezactivate. Vă mulțumim că le-ați testat. Le puteți activa din nou apăsînd pe „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]”, în partea de sus a paginii.',
	'prefswitch-success-feedback' => 'Comentariile dumneavoastră au fost trimise.',
	'prefswitch-return' => '<hr style="clear:both">
Revenire la <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-ro.png|401px|]]
|-
| Captură de ecran cu noua interfață de la Wikipedia <small>[[Media:VectorNavigation-ro.png|(mai mare)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:UsabilityToolbar-ro.png|401px|]]
|-
| Captură de ecran cu interfața de editare simplă <small>[[Media:VectorEditorBasic-en.png|(mai mare)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:UsabilityDialogs-ro.png|401px|]]
|-
| Captură de ecran cu caseta de dialog pentru editarea legăturilor
|}
|}
Echipa ''User Experience'' a Fundației Wikimedia a colaborat cu voluntari ai comunității pentru a vă facilita lucrul. Ne bucurăm să vă putem oferi aceste îmbunătățiri, între care noul aspect și unele funcționalități de editare simplificate. Aceste modificări au ca scop să-i ajute pe noii contribuitori să se obișnuiască mai ușor cu proiectul și se bazează pe [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study testele de accesibilitate realizate în cursul ultimului an]. Creșterea ușurinței de utilizare a proiectelor noastre este o prioritate a Fundației Wikimedia și vom continua ofertele și de acum înainte. Despre aceasta găsiți detalii pe [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blogul] dedicat al Fundației Wikimedia.

=== Iată ce am schimbat ===
* '''Navigare:''' Am îmbunătățit navigarea pentru citirea și editarea paginilor. Acum filele din partea de sus a fiecărei pagini indică mai clar dacă ceea ce vedeți este pagina propriu-zisă sau pagina de discuții și dacă pagina este afișată pentru citire sau pentru editare.
* '''Unelte de editare:''' Am reorganizat bara de unelte pentru editare pentru o utilizare mai simplă. Acum formatarea paginilor este mai ușoară și mai intuitivă.
* '''Editor de legături:''' Noua unealtă este ușor de utilizat și vă permite să introduceți legături spre alte pagini ale proiectului sau spre situri externe.
* '''Funcția de căutare:''' Am perfecționat sistemul de sugestii pentru a vă ajuta să ajungeți mai repede la pagina căutată.
* '''Alte funcționalități:''' Am adăugat un editor cu care puteți crea ușor tabele și o unealtă de înlocuire de text care simplifică editarea paginilor.
* '''Noul logo al Wikipediei:''' Avem un nou logo, citiți detalii pe [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blogul] Fundației Wikimedia.",
	'prefswitch-main-logged-changes' => "*'''Fila {{int:watch}}''' este acum o stea.
*'''Fila {{int:move}}''' se află acum în meniul derulant de lîngă caseta de căutare.",
	'prefswitch-main-feedback' => '===Aveți comentarii?===
Ne-am bucura să auzim ce impresii aveți. Vă rugăm să vizitați [[$1|pagina de comentarii]] sau, dacă vă interesează eforturile noastre de a îmbunătăți continuu programul, căutați detalii la [http://usability.wikimedia.org proiectul de utilizabilitate].',
	'prefswitch-main-anon' => '===Prefer cum era înainte===
[$1 Apăsați aici pentru a dezactiva noile funcționalități]. Vi se va cere mai întîi să vă autentificați sau să vă creați un cont.',
	'prefswitch-main-on' => '===Era mai bine înainte!===
[$2 Apăsați aici pentru a dezactiva noile funcționalități.]',
	'prefswitch-main-off' => '===Testați-le!===
[$1 Apăsați aici pentru a activa noile funcționalități.]',
	'prefswitch-survey-intro-feedback' => 'Ne-am bucura să vă aflăm impresiile.
Vă rugăm să răspundeți la sondajul de mai jos și apoi să apăsați „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]”.',
	'prefswitch-survey-intro-off' => 'Vă mulțumim că ați testat noile funcționalități.
Pentru a ne ajuta să le perfecționăm vă rugăm să răspundeți la sondajul opțional de mai jos și apoi să apăsați „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]”.',
	'prefswitch-feedbackpage' => 'Project:Impresii asupra utilizabilității',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'prefswitch-link-anon' => 'Nuève funziune',
	'tooltip-pt-prefswitch-link-anon' => "Cchiù 'mbormazziune sus a le funziune nuève",
	'prefswitch-link-on' => 'Puerteme rrete',
	'tooltip-pt-prefswitch-link-on' => 'Disabbilite le funziune nuève',
	'prefswitch-link-off' => 'Nuève funziune',
	'tooltip-pt-prefswitch-link-off' => 'Pruève le funziune nuève',
	'prefswitch-survey-true' => 'Sìne',
	'prefswitch-survey-false' => 'None',
	'prefswitch-survey-submit-off' => 'Chiude le funziune nuève',
	'prefswitch-survey-submit-feedback' => 'Invie commende',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "Non ge me piace 'u mode jndre cui se vedene le caratteristeche.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "Non ge me piacene le schede nuève e 'a disposizione.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => "Non ge me piace 'a barra de le struminde nova.",
	'prefswitch-survey-answer-whyoff-other' => 'Otre mutive:',
	'prefswitch-survey-question-browser' => 'Ce browser ause?',
	'prefswitch-survey-answer-browser-other' => 'Otre browser:',
	'prefswitch-survey-question-os' => 'Ce sisteme operative ause?',
	'prefswitch-survey-answer-os-other' => 'Otre sisteme operative:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sìne, chiude le caratteristeche sus a totte le uicchi',
	'prefswitch-survey-question-res' => "Ce risoluzione tène 'u scherme tue?",
	'prefswitch-title-on' => 'Nuève funziune',
	'prefswitch-title-switched-on' => 'Devirtete!',
	'prefswitch-title-off' => 'Chiude le funziune nuève',
	'prefswitch-title-switched-off' => 'Rengraziaminde',
	'prefswitch-title-feedback' => 'Giudizie',
	'prefswitch-success-feedback' => "'U commende tue hé state inviate.",
);

/** Russian (Русский)
 * @author G0rn
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'prefswitch' => 'Переключатель настроек Инициативы юзабилити',
	'prefswitch-desc' => 'Позволяет участникам переключать наборы настроек',
	'prefswitch-link-anon' => 'Новые возможности',
	'tooltip-pt-prefswitch-link-anon' => 'Узнайте о новых возможностях',
	'prefswitch-link-on' => 'Вернуть как было',
	'tooltip-pt-prefswitch-link-on' => 'Отключить новые возможности',
	'prefswitch-link-off' => 'Новые возможности',
	'tooltip-pt-prefswitch-link-off' => 'Опробуйте новые возможности',
	'prefswitch-jswarning' => 'Помните, что вместе с изменением темы оформления, ваш [[User:$1/$2.js|$2 JavaScript]] должен быть скопирован в [[{{ns:user}}:$1/vector.js]] <!-- или [[{{ns:user}}:$1/common.js]]-->, чтобы он продолжил работать.',
	'prefswitch-csswarning' => 'Ваши [[User:$1/$2.css|собственные стили для темы «$2»]] больше не будут применяться. Вы можете добавить собственный CSS для темы оформления «Вектор» в файле [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Да',
	'prefswitch-survey-false' => 'Нет',
	'prefswitch-survey-submit-off' => 'Выключить новые возможности',
	'prefswitch-survey-cancel-off' => 'Если вы хотите продолжить использовать новые возможности, вы можете вернуться к $1.',
	'prefswitch-survey-submit-feedback' => 'Отправить отзыв',
	'prefswitch-survey-cancel-feedback' => 'Если вы не хотите оставить отзыв о прототипе, вы можете вернуться к $1.',
	'prefswitch-survey-question-like' => 'Что вам понравилось в новых возможностях?',
	'prefswitch-survey-question-dislike' => 'Что вам не понравилось в новых возможностях?',
	'prefswitch-survey-question-whyoff' => 'Почему вы отключаете новые возможности?
Пожалуйста, выберите все подходящие варианты.',
	'prefswitch-survey-question-globaloff' => 'Вы хотите глобально выключить эту возможность?',
	'prefswitch-survey-answer-whyoff-hard' => 'Слишком сложны в использовании.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Не работают должным образом.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Работают непредсказуемо.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Мне не нравится как они выглядят.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Мне не понравились новые вкладки и вёрстка.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Мне не понравилась новая панель редактирования.',
	'prefswitch-survey-answer-whyoff-other' => 'Другая причина:',
	'prefswitch-survey-question-browser' => 'Какой браузер вы используете?',
	'prefswitch-survey-answer-browser-other' => 'Другой браузер:',
	'prefswitch-survey-question-os' => 'Какую операционную систему вы используете?',
	'prefswitch-survey-answer-os-other' => 'Другая операционная система:',
	'prefswitch-survey-answer-globaloff-yes' => 'Да, выключить эту возможность во всех вики.',
	'prefswitch-survey-question-res' => 'Каково разрешение вашего экрана?',
	'prefswitch-title-on' => 'Новые возможности',
	'prefswitch-title-switched-on' => 'Наслаждайтесь!',
	'prefswitch-title-off' => 'Выключить новые возможности',
	'prefswitch-title-switched-off' => 'Спасибо',
	'prefswitch-title-feedback' => 'Обратная связь',
	'prefswitch-success-on' => 'Новые возможности включены. Надеемся, вам понравится использовать новые функции. Вы всегда можете отключить их, нажав на ссылку «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» в верхней части страницы.',
	'prefswitch-success-off' => 'Новые возможности отключены. Спасибо за проверку новых функций. Вы всегда можете включить их обратно, нажав на ссылку «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]» в верхней части страницы.',
	'prefswitch-success-feedback' => 'Ваш отзыв отправлен.',
	'prefswitch-return' => '<hr style="clear:both">
Вернуться к <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-ru.png|401px|]]
|-
| Вид нового интерфейса навигации Википедии <small>[[Media:VectorNavigation-ru.png|(увеличить)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-ru.png|401px|]]
|-
| Вид основного интерфейса редактирования страниц <small>[[Media:VectorEditorBasic-ru.png|(увеличить)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-ru.png|401px|]]
|-
| Вид нового диалога создания ссылок
|}
|}
В «Фонде Викимедиа» работает группа анализа использования сайта, совместно с добровольцами из сообщества она старается упростить вашу работу с Википедией и другими вики-проектами. Мы рады поделиться некоторыми улучшениями, в том числе новым интерфейсом и упрощёнными функциями редактирования. Эти изменения предназначены для упрощения работы новых редакторов, они основаны на [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study юзабилити-тестировании, проведённом в прошедшем году]. Задача создания более удобного интерфейса наших сайтов рассматривается «Фондом Викимедиа» как приоритетная, мы продолжим совершенствовать проект и в дальнейшем. Подробности можно узнать в [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ блоге Викимедии].

=== Что мы изменили ===
* '''Навигация.''' Мы улучшили навигацию, сделав её более удобной для чтения и редактирования страниц. Теперь вкладки в верхней части каждой страницы позволяют более чётко определить, чем вы сейчас занимаетесь: просматриваете страницу или её обсуждение, читаете или редактируете страницу.
* '''Панель редактирования.''' Мы переделали панель инструментов редактирования, чтобы упростить её использование. Теперь форматирование страниц стало проще и понятнее.
* '''Мастер ссылок.''' Простой в использовании инструмент позволяет добавлять ссылки, ведущие как на другие вики-страницы, так и на внешние сайты.
* '''Поиск.''' Мы улучшили поисковые подсказки, чтобы у вас была возможность быстрее найти требуемую страницу.
* '''Другие новые функции.''' Мы сделали мастер таблиц, позволяющий легко создавать таблицы, а также функцию поиска и замены, упрощающую редактирование.
* '''Логотип.''' Мы обновили вид шарика-пазла, подробнее см. [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ блог «Фонда Викимедиа»].",
	'prefswitch-main-logged-changes' => "* '''Вкладка «{{int:watch}}»''' теперь является иконкой в виде звезды.
* '''Вкладка «{{int:move}}»''' теперь находится в выпадающем меню около строки поиска.",
	'prefswitch-main-feedback' => '=== Обратная связь ===
Мы хотели бы услышать ваши отзывы. Пожалуйста, посетите нашу [[$1|страницу обратной связи]]. Если вам интересны наши дальнейшие работы по улучшению программного обеспечения, посетите [http://usability.wikimedia.org вики юзабилити-проекта].',
	'prefswitch-main-anon' => '=== Вернуть как было ===
Если вы хотите отключить новые возможности, [$1 нажмите здесь]. Вам будет предложено сначала представиться или зарегистрировать учётную запись.',
	'prefswitch-main-on' => '=== Верните всё обратно! ===
Если вы хотите отключить новые возможности, пожалуйста, [$2 нажмите здесь].',
	'prefswitch-main-off' => '=== Опробуйте их! ===
Если вы хотите включить новые возможности, пожалуйста, [$1 нажмите здесь].',
	'prefswitch-survey-intro-feedback' => 'Мы хотели бы получить отзывы.
Пожалуйста, ответьте на несколько необязательных вопросов ниже, прежде чем нажмёте «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]».',
	'prefswitch-survey-intro-off' => 'Спасибо, что опробовали новые возможности.
Чтобы помочь нам улучшить их, пожалуйста, ответьте на несколько необязательных вопросов, прежде чем нажмёте «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».',
	'prefswitch-feedbackpage' => 'Project:Отзывы о новом оформлении',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'prefswitch' => 'Перепинач наставлїня Ініціатівы хосновательности',
	'prefswitch-desc' => 'Уможнює хоснователям перепинати сады наставлїня',
	'prefswitch-link-anon' => 'Новы функції',
	'tooltip-pt-prefswitch-link-anon' => 'Дознайте ся о новых функціях',
	'prefswitch-link-on' => 'Зробити як было',
	'tooltip-pt-prefswitch-link-on' => 'Выпнути новы функції',
	'prefswitch-link-off' => 'Новы функції',
	'tooltip-pt-prefswitch-link-off' => 'Спробуйте новы можности',
	'prefswitch-jswarning' => 'Памятайте, жебы ваш [[User:$1/$2.js|$2 JavaScript]] працёвав під новым скіном треба го скопіровати до [[{{ns:user}}:$1/vector.js]] <!-- або [[{{ns:user}}:$1/common.js]]--> кідь має і надале фунґовати.',
	'prefswitch-csswarning' => 'Ваш [[User:$1/$2.css|хосновательскый скін $2]] ся надалей не буде хосновати. Хосновательске CSS про Вектор собі можете наставити на [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Гей',
	'prefswitch-survey-false' => 'Нє',
	'prefswitch-survey-submit-off' => 'Выпнути новы функції',
	'prefswitch-survey-cancel-off' => 'Покы хочете і далей хосновати новы властности, можете ся вернути на сторінку $1.',
	'prefswitch-survey-submit-feedback' => 'Одослати назор',
	'prefswitch-survey-cancel-feedback' => 'Покы нам не хочете послати свій назор, можете ся вернути на$1.',
	'prefswitch-survey-question-like' => 'Што з новых можностей ся вам любить?',
	'prefswitch-survey-question-dislike' => 'Што з новых можностей ся вам не любило?',
	'prefswitch-survey-question-whyoff' => 'Чом сьте выпнули новы можности?
Выберте вшыткы релевантны можности.',
	'prefswitch-survey-question-globaloff' => 'Хочете функції выпнути ґлобално?',
	'prefswitch-survey-answer-whyoff-hard' => 'Была дуже тяжка про хоснованя.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Не фунґовала коректно.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Не ховала ся предвидаво.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Не любив ся мі єй взгляд.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Не любили ся мі новы заложкы і композіція.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Не любив ся мі новый панел інштрументів.',
	'prefswitch-survey-answer-whyoff-other' => 'Інша причіна:',
	'prefswitch-survey-question-browser' => 'Якый вебовый переглядач хоснуєте?',
	'prefswitch-survey-answer-browser-other' => 'Іншый веб-переглядач:',
	'prefswitch-survey-question-os' => 'Якый операчный сістем хоснуєте?',
	'prefswitch-survey-answer-os-other' => 'Іншый операчный сістем:',
	'prefswitch-survey-answer-globaloff-yes' => 'Гей, выпнути функції на вшыткых вікі',
	'prefswitch-survey-question-res' => 'Яке є розлішіня вашой образовкы?',
	'prefswitch-title-on' => 'Новы функції',
	'prefswitch-title-switched-on' => 'Хоснуйте собі тото!',
	'prefswitch-title-off' => 'Выпнути новы функції',
	'prefswitch-title-switched-off' => 'Дякуєме',
	'prefswitch-title-feedback' => 'Одозва',
	'prefswitch-success-on' => 'Новы функції суть нынї запнуты.  Надїяме ся, же ся вам будуть любити. Хоцьколи їх можете знову выпнути кликнутём на одказ „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]“ на верьху сторінкы.',
	'prefswitch-success-off' => 'Новы функції суть нынї выпнуты.  Дякуєме за їх спробованя. Хоцьколи їх можете знову запнути кликнутём на одказ „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]“ на верьху сторінкы.',
	'prefswitch-success-feedback' => 'Ваш назор быв одосланый.',
	'prefswitch-return' => '<hr style="clear:both">
Вернути ся до <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-rue.png|401px|]]
|-
| Снимок образовкы з новым навіґачным інтерфейсом<small>[[Media:VectorNavigation-rue.png|(звекшыти)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-rue.png|401px|]]
|-
| Снимок образовкы з основным едітачным інтерфейсом <small>[[Media:VectorEditorBasic-rue.png|(звекшыти)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-rue.png|401px|]]
|-
| Снимок образовкы з новым діалоґом про вкладаня одказів
|}
|}
Тім надації Вікімедія про хосновательску приветливость працёвав з доброволниками з комуніты, жебы упростив працю. Тїшыме ся, же ся з вами можеме подїлити о пару вылїпшінь включавчі нового нового взгляду і упрощеной едітації. Цілём тых змін є злегчіти зачаткы новачком і суть заложены на нашых [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study тестох з мінулого року]. Здоконалюваня хосновательности нашых проєктів є пріорітов надації Вікімедія і в будучности будеме нукати далшы іновації. Детайлы можете найти во [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ вістї на блогу Вікімедія].

=== Што сьме змінили ===
* '''Навіґація:''' Маєме лїпшу оріентацію про чітаня і едітацію сторінок. Заложкы во верхній части сторінкы нынї ясно зображують, ці собі смотрите статю ці діскузію а ці сторінку чітаєте або едітуєте.
* '''Вылїпшіня панела інштрументів:''' Переорґанізовали сьме едітачный панел інштрументів, жебы ся лїпше хосновав. Форматованя сторінок є теперь простїше і інтуітівнїше.
* '''Проводник окдазами:''' Простїше хосновательный інштрумент вам поможе придавати одказы на іншы статї вікі, як і на екстерны сторінкы.
* '''Вылїпшіня выглядаваня:''' Злїпшыли сьме нашептавач у выглядаваня, жебы сьте ся скорше дістали на сторінку, котру глядаєте.
* '''Далшы новы можности:''' Тыж сьме завели проводника таблицёв, абы было створюваня таблиць легше, і тыж функцію выглядаваня і нагороджуваня про простїшу едітацію сторінок.
* '''Лоґо Вікіпедії:''' Модернізовали сьме наше лоґо. Веце ся дознаєте на [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ блоґу Вікімедія].",
	'prefswitch-main-logged-changes' => "* Намісто '''заложкы {{int:watch}}''' є од теперь звіздочка.
* '''Заложка {{int:move}}''' є нынї в одкрывачім меню піля выглядаваня.",
	'prefswitch-main-feedback' => '===Коментарї?===
Увитаєме вашы назоры. Навщівте нашу [[$1|сторінку про коментарї]] або пок вас інтересує наше довгочасове усиля о здоконалёваня софтверу, можете найти веце інформацій на [http://usability.wikimedia.org вікі проєктї хосновательности].',
	'prefswitch-main-anon' => '===Хочу назад===
Кідь хочете, можете собі [$1 выпнути новы функції]. Перше ся але будете мусити приголосити або реґістровати.',
	'prefswitch-main-on' => '=== Хочу назад! ===
[$2 Кликните ту, кідь хочете выпнути новы функції].',
	'prefswitch-main-off' => '=== Спробуйте їх! ===
Кідь собі хочете спробовати новы функції, просиме [$1 кликните ту].',
	'prefswitch-survey-intro-feedback' => 'Потїшыме ся, кідь ся дознаме ваш назор.
Просиме, выповните формулар ниже а потім кликните на „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]“.',
	'prefswitch-survey-intro-off' => 'Дякуєме за спробованя нашых новых функцій.
Хочете-ли нам помочі злїпшыти їх, выповните неповинный формулар ниже а потом кликните на „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]“.',
	'prefswitch-feedbackpage' => 'Project: Одозва скусености хоснователя',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 * @author Рашат Якупов
 */
$messages['sah'] = array(
	'prefswitch' => 'Юзабилити инициативатын туруорууларын уларытыы',
	'prefswitch-desc' => 'Туруоруулары талары хааччыйар',
	'prefswitch-link-anon' => 'Саҥа туруоруулар',
	'tooltip-pt-prefswitch-link-anon' => 'Саҥа туруоруулар тустарынан бил',
	'prefswitch-link-on' => 'Уруккутун төннөр',
	'tooltip-pt-prefswitch-link-on' => 'Саҥа туруоруулары араар',
	'prefswitch-link-off' => 'Саҥа туруоруулар',
	'tooltip-pt-prefswitch-link-off' => 'Саҥа туруоруулары тургутан көр',
	'prefswitch-jswarning' => 'Өйдөө, тас көстүүтүн уларытарга [[User:$1/$2.js|$2 JavaScript]] манна хатыланыахтаах [[{{ns:user}}:$1/vector.js]] <!-- эбэтэр [[{{ns:user}}:$1/common.js]]-->, оччоҕо кини үлэлиирин салгыа.',
	'prefswitch-csswarning' => 'Эн  [[User:$1/$2.css|бэйэҥ «$2» тиэмэҕэ аналлаах истииллэриҥ]] бу кэннэ туттуллубт буолуохтара. Ол гынан баран «Вектор» тиэмэҕэ анаан [[{{ns:user}}:$1/vector.css]] билэҕэ бэйэҥ CSS эбиэххин сөп.',
	'prefswitch-survey-true' => 'Сөп',
	'prefswitch-survey-false' => 'Суох',
	'prefswitch-survey-submit-off' => 'Саҥа туруоруулары араар',
	'prefswitch-survey-cancel-off' => 'Саҥа туруоруулары салгыы туттуоххун баҕардаххына манна $1 төннүөххүн сөп.',
	'prefswitch-survey-submit-feedback' => 'Сыанабылы ыытарга',
	'prefswitch-survey-cancel-feedback' => 'Сыанабыл биэриэххин баҕарбат буоллаххына, манна $1 төннүөххүн сөп.',
	'prefswitch-survey-question-like' => 'Саҥа туруорууларга тугу сөбүлээтиҥ?',
	'prefswitch-survey-question-dislike' => 'Саҥа туруорууларга тугу сөбүлээбэтиҥ?',
	'prefswitch-survey-question-whyoff' => 'Тоҕо саҥа туруоруулары араарыаххын баҕараҕын?
Бука диэн сөп түбэһэр хоруйу тал.',
	'prefswitch-survey-question-globaloff' => '',
	'prefswitch-survey-answer-whyoff-hard' => 'Туттарга наһаа ыарахан.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Сөпкө үлэлээбэт.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Күүтүллүбүтүн курдук үлэлээбэт.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Көстүүтүн сөбүлээбэтим.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Саҥа кыбытыктары уонна верстканы соччо сөбүлээбэтим.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Эрэдээксийэлиир хаптаһын саҥа барылын сөбүлээбэтим.',
	'prefswitch-survey-answer-whyoff-other' => 'Атын төрүөт:',
	'prefswitch-survey-question-browser' => 'Ханнык брааузеры туһанаҕыный?',
	'prefswitch-survey-answer-browser-other' => 'Атын брааузер:',
	'prefswitch-survey-question-os' => 'Ханнык операционнай систиэмэни туһанаҕын?',
	'prefswitch-survey-answer-os-other' => 'Атын ОС:',
	'prefswitch-survey-answer-globaloff-yes' => '',
	'prefswitch-survey-question-res' => 'Эн мониторуҥ разрешениета төһөнүй?',
	'prefswitch-title-on' => 'Саҥа туруоруулар',
	'prefswitch-title-switched-on' => 'Астын!',
	'prefswitch-title-off' => 'Саҥа туруоруулары араар',
	'prefswitch-title-switched-off' => 'Махтал',
	'prefswitch-title-feedback' => 'Айааччылардыын алтыһыы',
	'prefswitch-success-on' => 'Саҥа туруоруулар холбоннулар. Саҥа кыахтары туһанаргын сөбүлүөҥ дии саныыбыт. Сирэй үөһээ өттүгэр баар бу сигэни баттаан хаһан баҕарар араарыаххын сөп:  «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]».',
	'prefswitch-success-off' => 'Саҥа туруоруулар араҕыстылар. Тургутан көрбүккэр махтал. Хаһан баҕарар сирэй үөһээ өттүгэр баар бу сигэни баттаан төттөрү холбуоххун сөп: «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]».',
	'prefswitch-success-feedback' => 'Сыанабылыҥ ыытылынна.',
	'prefswitch-return' => '<hr style="clear:both">
Төннөргө <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-ru.png|401px|]]
|-
| Бикипиэдьийэ навигациятын саҥа интерфейса <small>[[Media:VectorNavigation-ru.png|(улаатыннар)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-ru.png|401px|]]
|-
| Сирэйдэри эрэдээксийэлээһин саҥа сүрүн интерфейса <small>[[Media:VectorEditorBasic-ru.png|(улаатыннар)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-ru.png|401px|]]
|-
| Сигэлэри оҥорооһун саҥа барыла
|}
|}
«Викимедиа Пуондатыгар» саайт үлэтин анаалыстыыр бөлөх үлэлиир. Кини волонтердары кытыннаран Бикипиэдьийэҕэ уонна атын биики-бырайыактарга үлэлээһини тупсарарга кыһанар. Сорох тупсарыылары, ол иһигэр саҥа интерфейсы уонна эрэдээксийэлээһини судургутутууну, көрдөрөбүт. Бу уларытыылар саҥа кыттааччылар үлэлэрин судургу гынарга аналлаахтар, [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study былырыын ыытыллыбыт тургутууга] өйөнөллөр. Биһиги саайтарбыт үлэлииргэ өссө табыгастаах буолалларыгар «Викимедиа Пуондата» улахан суолтаны биэрэр, онон өссө да тупсара туруохпут. Сиһилии манна  [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/ Викимедия блогугар] киирэн билиэххитин сөп.

=== Туох уларыйбыта ===
* '''Навигация.''' Навигацияны тупсардыбыт, онон ааҕарга уонна уларытарга өссө ордук буолла. Билигин хас биирдии сирэй үөһээ өттүнээҕи кыбытыктара тугу гына олороргун ордук чопчу көрдөрөр буоллулар: сирэйи эбэтэр кини ырытыытын көрөргүн, сирэйи ааҕа эбэтэр көннөрө олороргун.
* '''Эрэдээксийэ хаптаһына (панель).''' Туттарга судургу гынан биэрдибит. Билигин сирэйдэри формааттааһын ордук судургу уонна өйдөнүмтүө буолла.
* '''Сигэнии маастара.''' Судургу үнүстүрүмүөн сигэлэри атын биики-сирэйдэргэ да, атын саайтарга да, туруорары хааччыйар.
* '''Көрдөөһүн.''' Көрдөөһүн этэн биэриилэрин тупсардыбыт, онон наадыйар сирэйгин түргэнник булуоҥ.
* '''Атын саҥа кыахтар.''' Табылыыссалары оҥорор маастар олортубут. Эбии эрдээксийэни тупсарар көрдөөһүн уонна уларытыы үнүстүрүмүөнүн олортубут.
* '''Логотип.''' Шарик-пазл саҥа барылын олортубут, сиһилии манна көр: [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ «Викимедиа Пуондатын» блога].",
	'prefswitch-main-logged-changes' => "* '''«{{int:watch}}» кыбытык''' билигин сулус курдук бэлиэ (иконка) буолла.
* '''«{{int:move}}» кыбытык''' билигин көрдөөһүн устуруокатын таһыгар түһэр менюга баар.",
	'prefswitch-main-feedback' => '=== Айааччылардыын алтыһыы ===
Эн санааҕын истиэхпитин баҕарабыт. Бука диэн, биһиги [[$1|онно аналлаах сирэйбитигэр]] киирэ сырыт эрэ. Өскө салгыы тугу гыныахпытын баҕарарбытын билиэххин баҕарар буоллаххына, манна [http://usability.wikimedia.org биики юзабилити-бырайыагар] киирэ сырыт.',
	'prefswitch-main-anon' => '=== Уруккутугар төннөрүү ===
Саҥа интерфейсы араарыаххын баҕарар буоллаххына, [$1 маны баттаа]. Оччоҕо ааккын этэргин эбэтэр бэлиэтэнэргин көрдөһүөхтэрэ.',
	'prefswitch-main-on' => '=== Барытын төннөрүҥ! ===
Саҥа интерфейсы араарарга, бука диэн,  [$2 маны баттаа].',
	'prefswitch-main-off' => '=== Тургутан көр! ===
Саҥа интерфейсы холбуурга, бука диэн,  [$1 маны баттаа].',
	'prefswitch-survey-intro-feedback' => 'Эн санааҕын билиэхпитин баҕарабыт.
Бука диэн, манна баар аҕыйах булгуччута суох ыйытыыларга хоруйдаа эрэ, онтон маны баттаар «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]».',
	'prefswitch-survey-intro-off' => 'Саҥа интерфейсы тургутан көрбүккэр махтал.
Тупсарарга көмөлөһүөххүн баҕарар буоллаххына, аҕыйах булгуччута суох ыйытыыларга хоруйдаа, онтон маны баттаар: «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]».',
	'prefswitch-feedbackpage' => 'Project:Саҥа интерфейс туһунан дьон санаата',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'prefswitch-survey-true' => 'Eja',
	'prefswitch-survey-answer-whyoff-other' => 'Àteru motivu:',
	'prefswitch-survey-answer-browser-other' => 'Àteru browser:',
	'prefswitch-title-switched-off' => 'Gràtzias',
);

/** Sicilian (Sicilianu)
 * @author Gmelfi
 */
$messages['scn'] = array(
	'prefswitch-link-anon' => 'Funziunalità novi',
	'tooltip-pt-prefswitch-link-anon' => 'Nfurnazzioni supra li funziunalità novi',
	'prefswitch-link-on' => 'Arripòrtami nnarreri',
	'tooltip-pt-prefswitch-link-on' => 'Disabbìlita li funziunalità novi',
	'prefswitch-link-off' => 'Funziunalità novi',
	'tooltip-pt-prefswitch-link-off' => 'Prova li funziunalità novi',
	'prefswitch-jswarning' => "Arricòrdati ca cû canciu dâ ''skin'', lu còdici [[User:$1/$2.js|$2 JavaScript]] s'havi a cupiari comu [[{{ns:user}}:$1/vector.js]] <!-- o [[{{ns:user}}:$1/common.js]]--> pi cuntinuari a funziunari",
	'prefswitch-csswarning' => "Li tò [[User:$1/$2.css|stili pirsunalizzati pi $2]] nun sunnu applicati cchiù. Puoi junciri CSS pirsunalizzatu pi ''vector'' nti [[{{ns:user}}:$1/vector.css]].",
	'prefswitch-survey-true' => 'Sì',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Disabbìlita li funziunalità novi',
	'prefswitch-survey-cancel-off' => 'Siddu vuòi cuntinuari a usari li funziunalità novi, puoi arriturnari a $1.',
	'prefswitch-survey-submit-feedback' => 'Manna nu feedback',
	'prefswitch-survey-cancel-feedback' => 'Siddu nun vuoi mannari nu feedback, puoi arriturnari a $1.',
	'prefswitch-survey-question-like' => 'Chi è ca ti piacìu ntê funziunalità novi?',
	'prefswitch-survey-question-dislike' => 'Chi è ca nun ti piacìu ntê funziunalità novi?',
	'prefswitch-survey-question-whyoff' => 'Pirchì stai disabbilitannu lu funziunalità novi?
Pi favuri silizziunati tuttu chiddu ca ci centra',
	'prefswitch-survey-question-globaloff' => 'Vuoi disabbilitari li funziunalità glubbalmenti?',
	'prefswitch-survey-answer-whyoff-hard' => 'Era troppu difficili di usari.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Nun funziunava bonu.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Nun si cumpurtava di manera cuirenti.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Nun mi piacìva comu cumpariva',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => "Nun mi piacìvanu li schedi novi e lu ''layout''.",
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nun mi piaciva la barra dî strummenta nova.',
	'prefswitch-survey-answer-whyoff-other' => 'Àutru mutivu:',
	'prefswitch-survey-question-browser' => 'Quali browser usi?',
	'prefswitch-survey-answer-browser-other' => 'Àutru browser:',
	'prefswitch-survey-question-os' => 'Quali sistema upirativu usi?',
	'prefswitch-survey-answer-os-other' => 'Àutru sistema upirativu:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sì, disabbilita li funziunalità supra tutti li wiki',
	'prefswitch-survey-question-res' => 'Qual eni la risuluzzioni dû tò schermu?',
	'prefswitch-title-on' => 'Funziunalità novi',
	'prefswitch-title-switched-on' => 'Addivèrtiti!',
	'prefswitch-title-off' => 'Disabbìlita li funziunalità novi',
	'prefswitch-title-switched-off' => 'Grazzi',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'Li funziunalità novi sunnu attivi. Nuatri spiramu ca ti piaciunu. Puoi sempri sissabbilitàrili cliccannu supra lu link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" supra la parti di supra dâ pàggina.',
	'prefswitch-success-off' => 'Li funziunalità novi foru disabbilitati. Grazzi pi avìrilli pruvati. Puoi sempri riabbilitàrili cliccannu supra lu link "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" ntâ parti di supra dâ pàggina.',
	'prefswitch-success-feedback' => 'Lu tò feedback fu mannatu.',
	'prefswitch-return' => '<hr style="clear:both">
Arritorna a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main-logged-changes' => "* La '''linguetta {{int:watch}}''' ora è na stidda.
* La '''linguetta {{int:move}}''' ora è ntô menù a scumparuta vicinu â barra di ricerca.",
	'prefswitch-main-feedback' => "===Feedback?===
Nun videmu l'ura d'accanùsciri chiddu ca pensi. Visita la nostra [[$1|paggina di feddback]] o, siddu si ntirissatu ô travagghiu nostru pi rennriri megghiu la piattaforma MediaWiki, visita [http://usability.wikimedia.org la wiki dû prugettu usabilità] pi àutri nfurmazzioni.",
	'prefswitch-main-anon' => '===Arripòrtami nnarreri===
[$1 Clicca ccà pi disabbilitari li funziunalità novi]. Ti veni addumannatu di tràsiri o di criari nu cuntu.',
	'prefswitch-main-on' => '===Arripòrtami narreri===
[$2 Clicca ccà pi disabbilitari li funziuni novi].',
	'prefswitch-main-off' => '===Prùvali===
[$1 Clicca ccà pi abbilitari li funziunalità novi].',
	'prefswitch-survey-intro-feedback' => 'Ni piacissi sèntiri chiddu ca pensi.
Pi favuri, cumpila lu sundaggiu cassutta (facultativu) prima di cliccari "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Grazzi pi aviri pruvatu lu funziunalità novi.
Pi aiutarini a fàrili megghiu, pi favuri jinci lu questiunariu facultativu cassutta prima di cliccari supra "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Cuurdinamentu/Usabbilità',
);

/** Sinhala (සිංහල)
 * @author Pasanbhathiya2
 * @author බිඟුවා
 */
$messages['si'] = array(
	'prefswitch-link-anon' => 'බීටා අනුවාදයේ ලක්ෂණ',
	'prefswitch-link-on' => 'මා අපසු ගෙනයන්න',
	'tooltip-pt-prefswitch-link-on' => 'නව අංග බල රහිත කරන්න.',
	'prefswitch-link-off' => 'බීටා අනුවාදයේ ලක්ෂණ',
	'tooltip-pt-prefswitch-link-off' => 'නවාංගයන් අත්හදා බලන්න',
	'prefswitch-survey-true' => 'ඔව්',
	'prefswitch-survey-false' => 'නැත',
	'prefswitch-survey-submit-feedback' => 'බීටා අනුවාදය පිලිබඳ ප්‍රතිපෝෂණය',
	'prefswitch-survey-question-like' => 'නව අංග පිලිබඳව ඔබ කැමති මොනවාටද?',
	'prefswitch-survey-question-dislike' => 'නව අංග පිලිබඳව ඔබ අකමැති මොනවාටද?',
	'prefswitch-survey-answer-whyoff-hard' => 'එම අංග භාවිතවට අපහසුය.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'එම අංග නිසි ලෙස ක්‍රියා නොකරයි.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'එම අංගවල හැඩරුව මා සිත් ගත්තේ නැත.',
	'prefswitch-survey-answer-whyoff-other' => 'වෙනත් හේතුවක්:',
	'prefswitch-survey-question-browser' => 'ඔබ භාවිතා කරන්නේ කුමන බ්‍රවුසරයද?',
	'prefswitch-survey-answer-browser-other' => 'අනෙක් බ්‍රවුසරය:',
	'prefswitch-survey-question-os' => 'ඔබ භාවිතා කරනු ලබන්නේ කුමන මෙහෙයුම් පද්ධතිය ද?',
	'prefswitch-survey-answer-os-other' => 'අනෙක් මෙහෙයුම් පද්ධතිය:',
	'prefswitch-title-on' => 'බීටා අනුවාදයේ ලක්ෂණ',
	'prefswitch-title-switched-on' => 'ප්‍රීති වන්න!',
	'prefswitch-title-switched-off' => 'ස්තුතියි',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'prefswitch' => 'Prepínač nastavenia Iniciatívy použiteľnosti',
	'prefswitch-desc' => 'Umožňuje používateľom prepínať sady predvolieb',
	'prefswitch-link-anon' => 'Nové funkcie',
	'tooltip-pt-prefswitch-link-anon' => 'Vyskúšajte nové funkcie',
	'prefswitch-link-on' => 'Vrátiť späť',
	'tooltip-pt-prefswitch-link-on' => 'Vypnúť nové funkcie',
	'prefswitch-link-off' => 'Nové funkcie',
	'tooltip-pt-prefswitch-link-off' => 'Vyskúšajte nové funkcie',
	'prefswitch-jswarning' => 'Pamätajte pri zmene témy vzhľadu budete musieť skopírovať svoj [[User:$1/$2.js|JavaScriptový súbor $2]] do [[{{ns:user}}:$1/vector.js]] <!-- alebo [[{{ns:user}}:$1/common.js]]--> aby naďalej fungoval.',
	'prefswitch-csswarning' => 'Vaše [[User:$1/$2.css|vlastné štýly $2]] už nebudú požité. Vlastné CSS pre tému vzhľadu Vector môžete pridať do [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Áno',
	'prefswitch-survey-false' => 'Nie',
	'prefswitch-survey-submit-off' => 'Vypnúť nové funkcie',
	'prefswitch-survey-cancel-off' => 'Ak si želáte pokračovať v používaní nových funkcií, môžete sa vrátiť späť na $1',
	'prefswitch-survey-submit-feedback' => 'Poslať komentáre',
	'prefswitch-survey-cancel-feedback' => 'Ak nechcete poskytnúť komentáre, môžete sa vrátiť na $1.',
	'prefswitch-survey-question-like' => 'Čo sa vám páčilo na nových funkciách?',
	'prefswitch-survey-question-dislike' => 'Čo sa vám nepáčilo na nových funkciách?',
	'prefswitch-survey-question-whyoff' => 'Prečo vypínate nové funkcie? 
Vyberte prosím všetky možnosti, ktoré považujete za pravdivé.',
	'prefswitch-survey-question-globaloff' => 'Chcete nové funkcie vypnúť globálne?',
	'prefswitch-survey-answer-whyoff-hard' => 'Nové funkcie sa používali príliš ťažko.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Nové funkcie nefungovali správne.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Nové funkcie sa nesprávali predvídateľne.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Nepáčilo sa mi ako vyzerali.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Nepáčili sa mi nové záložky a rozloženie.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nepáčil sa mi nový panel nástrojov.',
	'prefswitch-survey-answer-whyoff-other' => 'Iný dôvod:',
	'prefswitch-survey-question-browser' => 'Ktorý prehliadač používate?',
	'prefswitch-survey-answer-browser-other' => 'Iný prehliadač:',
	'prefswitch-survey-question-os' => 'Ktorý operačný systém používate?',
	'prefswitch-survey-answer-os-other' => 'Iný operačný systém:',
	'prefswitch-survey-answer-globaloff-yes' => 'Áno, funkcie vypnúť na všetkých wiki',
	'prefswitch-survey-question-res' => 'Aké je rozlíšenie vašej obrazovky?',
	'prefswitch-title-on' => 'Nové funkcie',
	'prefswitch-title-switched-on' => 'Užite si to!',
	'prefswitch-title-off' => 'Vypnúť nové funkcie',
	'prefswitch-title-switched-off' => 'Ďakujeme',
	'prefswitch-title-feedback' => 'Komentáre',
	'prefswitch-success-on' => 'Nové funkcie sú teraz zapnuté. Dúfame, že sa vám budú páčiť. kedykoľvek ich môžete znova vypnúť kliknutím na odkaz „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]“ v hornej časti stránky.',
	'prefswitch-success-off' => 'Nové funkcie sú teraz vypnuté. Dúfame, že sa vám budú páčiť. kedykoľvek ich môžete znova zapnúť kliknutím na odkaz „[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]“ v hornej časti stránky.',
	'prefswitch-success-feedback' => 'Vaše komentáre boli odoslané.',
	'prefswitch-return' => '<hr style="clear:both">
Späť na <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Snímka obrazovky nového navigačného rozhrania Wikipédie <small>[[Media:VectorNavigation-en.png|(zväčšiť)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Snímka obrazovky základného rozhrania na úpravu stránky <small>[[Media:VectorEditorBasic-en.png|(zväčšiť)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Snímka obrazovky nového dialógového okna na zadávanie odkazov
|}
|}
User Experience tím Wikimedia Foundation spolupracoval dobrovoľníkmi z komunity, aby vám uľahčili prácu. Sme radi, že sa s vami môžeme podeliť o niektoré zlepšenia vrátane nového vzhľadu a správania a zjednodušených funkcií pri upravovaní. Cieľom týchto zmien je uľahčiť novým prispievateľom začať. Sú založené na našej [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study minuloročnej štúdii testovania použiteľnosti]. Zlepšovanie použiteľnosti našich projektov je prioritou Wikimedia Foundation a v budúcnosti sa s vami podelíme o ďalšie novinky. Ďalšie podrobnosti získate po navštívení [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blogového príspevku].

=== Toto sme zmenili ===
* '''Navigácia:''' Zlepšili sme navigáciu pri čítaní a upravovaní stránok. Teraz záložky na vrchu každej stránky jasnejšie definujú, či sa pozeráte na stránku alebo diskusnú stránku a či ju čítate alebo upravujete.
* '''Vylepšenia panela nástrojov úprav:''' Reorganizovali sme panel nástrojov úprav, aby sa ľahšie používal. Formátovanie je teraz jednoduchšie a intuitívnejšie.
* '''Sprievodca tvorbou odkazov:''' Ľahko použiteľný nástroj na pridávanie odkazov na ostatné stránky wiki a tiež na externé stránky.
* '''Vylepšenia hľadania:''' Vylepšili sme návrhy pri hľadaní, aby ste sa rýchlejšie dostali na stránku, ktorú hľadáte.
* '''Ostatné nové vlastnosti:''' Tiež sme predstavili sprievodcu uľahčenie tvorby tabuliek a možnost Hľadať a nahradiť na zjednodušenie úprav stránok.
* '''Logo Wikipédie:''' Aktualizovali sme naše logo. Viac sa dočítate v [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blogu Wikimedia].",
	'prefswitch-main-logged-changes' => "* '''Karta {{int:watch}}''' je teraz hviezdičkou.
* '''Karta {{int:move}}''' je teraz v roletovom menu vedľa vyhľadávacieho poľa.",
	'prefswitch-main-feedback' => '===Komentáre?===
Radi by sme počuli váš názor. Prosím, navštívte našu [[$1|stránku komentárov]] alebo ak vás zaujímajú naše prebiehajúce snahy vylepšiť softvér, navštívte [http://usability.wikimedia.org wiki o použiteľnosti].',
	'prefswitch-main-anon' => '===Vrátiť späť===
[$1 Kliknutím sem vypnete nové funkcie]. Budete požiadaný o prihlásenie alebo vytvorenie nového účtu.',
	'prefswitch-main-on' => '===Vrátiť späť!===
[$2 Kliknutím sem vypnete nové funkcie].',
	'prefswitch-main-off' => '===Vyskúšajte ich!===
 [$1 Kliknutím sem zapnete nové funkcie].',
	'prefswitch-survey-intro-feedback' => 'Radi si vypočujeme váš názor.
Prosím, vyplňte nepovinný dotazník dolu a potom kliknite na „[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]“.',
	'prefswitch-survey-intro-off' => 'Ďakujeme, že ste vyskúšali nové funkcie.
Ak nám chcete pomôcť ich vylepšiť, vyplňte nepovinný dotazník a potom kliknite na „[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]“.',
	'prefswitch-feedbackpage' => 'Project:Komentáre o použiteľnosti',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'prefswitch' => 'Stikalo nastavitev pobude za uporabnost',
	'prefswitch-desc' => 'Dovoli uporabnikom preklapljanje med nabori nastavitev',
	'prefswitch-link-anon' => 'Nove funkcije',
	'tooltip-pt-prefswitch-link-anon' => 'Izvedite več o novih funkcijah',
	'prefswitch-link-on' => 'Vodi me nazaj',
	'tooltip-pt-prefswitch-link-on' => 'Onemogoči nove funkcije',
	'prefswitch-link-off' => 'Nove funkcije',
	'tooltip-pt-prefswitch-link-off' => 'Preizkusite nove funkcije',
	'prefswitch-jswarning' => 'Ne pozabite, da je s spremembo kože potrebno skopirati vaš [[User:$1/$2.js|JavaScript $2]] na [[{{ns:user}}:$1/vector.js]]<!-- ali [[{{ns:user}}:$1/common.js]]-->, da bo deloval še naprej.',
	'prefswitch-csswarning' => 'Vaši [[User:$1/$2.css|slogi $2 po meri]] ne bodo več v uporabi. CSS po meri za kožo vector lahko dodate v [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Da',
	'prefswitch-survey-false' => 'Ne',
	'prefswitch-survey-submit-off' => 'Izklopi nove funkcije',
	'prefswitch-survey-cancel-off' => 'Če bi radi še naprej uporabljali nove funkcije, se lahko vrnete na $1.',
	'prefswitch-survey-submit-feedback' => 'Pošlji povratne informacije',
	'prefswitch-survey-cancel-feedback' => 'Če ne želite podati povratnih informacij, se lahko vrnete na $1.',
	'prefswitch-survey-question-like' => 'Kaj vam je pri novih funkcijah všeč?',
	'prefswitch-survey-question-dislike' => 'Česa pri novih funkcijah ne marate?',
	'prefswitch-survey-question-whyoff' => 'Zakaj izklapljate nove funkcije?
Prosimo, izberite vse kar ustreza.',
	'prefswitch-survey-question-globaloff' => 'Želite funkcije izklopiti globalno?',
	'prefswitch-survey-answer-whyoff-hard' => 'Bilo je pretežko uporabljati.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Ni delovalo pravilno.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Ni delovalo predvidljivo.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Izgled mi ni všeč.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Novi zavihki in postavitev mi niso všeč.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nova orodna vrstica mi ni všeč.',
	'prefswitch-survey-answer-whyoff-other' => 'Drug razlog:',
	'prefswitch-survey-question-browser' => 'Kateri brskalnik uporabljate?',
	'prefswitch-survey-answer-browser-other' => 'Drug brskalnik:',
	'prefswitch-survey-question-os' => 'Kateri operacijski sistem uporabljate?',
	'prefswitch-survey-answer-os-other' => 'Drug operacijski sistem:',
	'prefswitch-survey-answer-globaloff-yes' => 'Da, izklopi funkcije na vseh wikijih',
	'prefswitch-survey-question-res' => 'Kakšna je ločljivost vašega zaslona?',
	'prefswitch-title-on' => 'Nove funkcije',
	'prefswitch-title-switched-on' => 'Uživajte!',
	'prefswitch-title-off' => 'Izklopi nove funkcije',
	'prefswitch-title-switched-off' => 'Hvala',
	'prefswitch-title-feedback' => 'Povratne informacije',
	'prefswitch-success-on' => 'Nove funkcije so sedaj vklopljene. Upamo, da boste ob uporabi novih funkcij uživali. Vedno jih lahko nazaj izklopite s klikom na povezavo »[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]« na vrhu strani.',
	'prefswitch-success-off' => 'Nove funkcije so sedaj izklopljene. Zahvaljujemo se vam za uporabo novih funkcij. Vedno jih lahko nazaj vklopite s klikom na povezavo »[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]« na vrhu strani.',
	'prefswitch-success-feedback' => 'Vaše povratne informacije so bile poslane.',
	'prefswitch-return' => '<hr style="clear:both">
Vrnitev na <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Zaslonski posnetek novega navigacijskega vmesnika Wikipedije <small>[[Media:VectorNavigation-en.png|(povečaj)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Zaslonski posnetek osnovnega vmesnika za urejanje strani <small>[[Media:VectorEditorBasic-en.png|(povečaj)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Zaslonski posnetek novega pogovornega polja za vpisovanje povezav
|}
|}
Skupina za uporabniško izkušnjo Fundacije Wikimedia je sodelovala s prostovoljci iz skupnosti z namenom narediti stvari lažje za vas. Navdušeni smo, da lahko delimo nekatere izboljšave, vključno z novim izgledom in občutkom ter poenostavljenimi urejevalnimi funkcijami. Cilj teh sprememb je pomagati novim uporabnikom, da lahko hitreje začnejo sodelovati, in temeljijo na našem [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study opravljenem preizkušanju uporabnosti v zadnjem letu]. Izboljšanje uporabnosti naših projektov je prednostna naloga Fundacije Wikimedia in tako bomo v prihodnosti objavili še več posodobitev. Za več informacij obiščite sorodno [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia objavo na blogu] Wikimedie.

=== Kaj smo spremenili ===
* '''Navigacija:''' Izboljšali smo navigacijo pri branju in urejanju strani. Sedaj zavihki na vrhu strani jasneje kažejo ali si ogledujete stran ali pogovorno stran in ali stran berete ali urejate.
* '''Izboljšave urejevalne orodne vrstice:''' Preuredili smo urejevalno orodno vrstico za lažjo uporabo. Sedaj je oblikovanje strani preprostejše in bolj intuitivno.
* '''Čarovnik povezav:''' Preprosto orodje vam omogoča dodajanje povezav na druge wikistrani, kakor tudi povezave na zunanje strani.
* '''Izboljšave iskanja:''' Izboljšali smo iskalne predloge, da boste hitreje prišli na stran, ki jo iščete.
* '''Druge nove funkcije:''' Uvedli smo tudi čarovnik tabel, s katerim bo ustvarjanje tabel lažje, in funkcijo iskanja ter zamenjevanja, za poenostavljeno urejanje.
* '''Logotip Wikipedije:''' Posodobili smo naš logotip. Preberite več na [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blogu Wikimedie].",
	'prefswitch-main-logged-changes' => "* '''Zavihek {{int:watch}}''' je sedaj zvezdica.
* '''Zavihek {{int:move}}''' je sedaj v spustnem seznamu poleg iskalne vrstice.",
	'prefswitch-main-feedback' => '===Povratne informacije?===
Želimo slišati vaše mnenje. Prosimo, obiščite našo [[$1|stran za povratne informacije]] ali, če se zanimate za naše stalno prizadevanje za izboljšanje programja, za več informacij obiščite naš [http://usability.wikimedia.org wiki uporabnosti].',
	'prefswitch-main-anon' => '===Vodi me nazaj===
[$1 Za izklop novih funkcij kliknite tukaj]. Najprej se boste morali prijaviti ali ustvariti račun.',
	'prefswitch-main-on' => '===Vodi me nazaj!===
[$2 Za izklop novih funkcij kliknite tukaj].',
	'prefswitch-main-off' => '===Preizkusite jih!===
Če želite vklopiti nove funkcije, prosimo [$1 kliknite tukaj].',
	'prefswitch-survey-intro-feedback' => 'Radi bi slišali vaše mnenje.
Prosimo, izpolnite neobvezno anketo spodaj, preden kliknete »[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]«.',
	'prefswitch-survey-intro-off' => 'Zahvaljujemo se vam za preizkušanje naših novih funkcij.
Da nam jih pomagate izboljšati, prosimo izpolnite neobvezno anketo spodaj, preden kliknete »[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]«.',
	'prefswitch-feedbackpage' => 'Project:Povratne informacije o uporabniški izkušnji',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Helios13
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'prefswitch-desc' => 'Дозволи корисницима да измене читаве поставке',
	'prefswitch-link-anon' => 'Нове функције',
	'tooltip-pt-prefswitch-link-anon' => 'Сазнај о новим могућностима',
	'prefswitch-link-on' => 'Врати ме назад',
	'tooltip-pt-prefswitch-link-on' => 'Онемогући нове функције',
	'prefswitch-link-off' => 'Нове могућности',
	'tooltip-pt-prefswitch-link-off' => 'Пробај нове функције',
	'prefswitch-survey-true' => 'Да',
	'prefswitch-survey-false' => 'Не',
	'prefswitch-survey-submit-off' => 'Искључи нове могућности',
	'prefswitch-survey-cancel-off' => 'Ако бисте желели да продужите са коришћењем бета-верзије, можете се вратити на $1.',
	'prefswitch-survey-submit-feedback' => 'Пошаљи повратне информације',
	'prefswitch-survey-cancel-feedback' => 'Ако не желите да пошаљете повратну информацију, можете се вратити на $1.',
	'prefswitch-survey-question-like' => 'Шта вам се свидело у вези са бета верзијом?',
	'prefswitch-survey-question-dislike' => 'Шта вам се није свидело у вези са бета верзијом?',
	'prefswitch-survey-question-whyoff' => 'Зашто напуштате бета-верзију?
Молимо Вас, означите све што је на то утицало.',
	'prefswitch-survey-answer-whyoff-hard' => 'Опције су биле претешке за коришћење.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Опције нису функционисале како треба.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Опције нису радиле како се очекивало.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Није ми се свидео изглед опција.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Нису ми се свидели нови језичци и изглед.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Није ми се свидела нова алатница.',
	'prefswitch-survey-answer-whyoff-other' => 'Други разлог:',
	'prefswitch-survey-question-browser' => 'Који браузер користите?',
	'prefswitch-survey-answer-browser-other' => 'Други браузер:',
	'prefswitch-survey-question-os' => 'Који оперативни систем користите?',
	'prefswitch-survey-answer-os-other' => 'Други оперативни систем:',
	'prefswitch-survey-question-res' => 'Која је резолуција Вашег екрана?',
	'prefswitch-title-on' => 'Нове могућности',
	'prefswitch-title-switched-on' => 'Уживајте!',
	'prefswitch-title-off' => 'Искључи нове могућности',
	'prefswitch-title-switched-off' => 'Хвала',
	'prefswitch-title-feedback' => 'Повратне информације',
	'prefswitch-success-feedback' => 'Повратне информације су послате',
);

/** Serbian Latin ekavian (Srpski (latinica)) */
$messages['sr-el'] = array(
	'prefswitch-link-anon' => 'Nove funkcije',
	'tooltip-pt-prefswitch-link-on' => 'Onemogući nove funkcije',
	'tooltip-pt-prefswitch-link-off' => 'Probaj nove funkcije',
	'prefswitch-survey-true' => 'Da',
	'prefswitch-survey-false' => 'Ne',
	'prefswitch-survey-answer-whyoff-other' => 'Drugi razlog:',
	'prefswitch-survey-question-browser' => 'Koji brauzer koristite?',
	'prefswitch-survey-answer-browser-other' => 'Drugi brauzer:',
	'prefswitch-survey-question-os' => 'Koji operativni sistem koristite?',
	'prefswitch-survey-answer-os-other' => 'Drugi operativni sistem:',
	'prefswitch-survey-question-res' => 'Koja je rezolucija Vašeg ekrana?',
	'prefswitch-title-on' => 'Nove mogućnosti',
	'prefswitch-title-switched-on' => 'Uživajte!',
	'prefswitch-title-off' => 'Isključi nove mogućnosti',
	'prefswitch-title-switched-off' => 'Hvala',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'prefswitch' => 'Saklar préferénsi Inisiatif Kamangpaatan',
	'prefswitch-desc' => 'Ngawenangkeun pamaké pikeun gunta-ganti sababaraha setélan préferénsi',
	'prefswitch-link-anon' => 'Fitur anyar',
	'tooltip-pt-prefswitch-link-anon' => 'Lenyepan fitur-fitur anyar',
	'prefswitch-link-on' => 'Balik deui',
	'tooltip-pt-prefswitch-link-on' => 'Tumpurkeun fitur anyar',
	'prefswitch-link-off' => 'Fitur anyar',
	'tooltip-pt-prefswitch-link-off' => 'Cobaan fitur anyar',
	'prefswitch-jswarning' => 'Sing émut yén ku ngarobah kulit, [[User:$1/$2.js|$2 JavaScript]] anjeun perlu disalin ka [[{{ns:user}}:$1/vector.js]] <!-- or [[{{ns:user}}:$1/common.js]]--> ngarah bisa tetep jalan.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|Gaya kumadinya $2]] anjeun geus moal dilarapkeun deui. Anjeun bisa nambahkeun CSS kumadinya pikeun véktor dina [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Enya',
	'prefswitch-survey-false' => 'Teu',
	'prefswitch-survey-submit-off' => 'Tumpurkeun fitur anyar',
	'prefswitch-survey-cancel-off' => 'Mun anjeun rék neruskeun maké fitur anyar, anjeun bisa balik ka $1.',
	'prefswitch-survey-question-like' => 'Naon anu dipikaresep ti fitur anyar?',
	'prefswitch-survey-question-dislike' => 'Naon anu teu dipikaresep ti fitur anyar?',
	'prefswitch-survey-question-whyoff' => 'Naha bet mareuman fitur-fitur anyar?
Mangga pilih sadaya anu cocog.',
	'prefswitch-survey-answer-whyoff-hard' => 'Hésé teuing cara makéna.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Fungsi fiturna teu jalan.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Kinerja fiturna teu puguh.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Teu resep tab jeung pidangan anyarna.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Teu resep tulbar anyarna.',
	'prefswitch-survey-answer-whyoff-other' => 'Alesan séjén:',
	'prefswitch-survey-question-browser' => 'Panyungsi naon nu dipaké?',
	'prefswitch-survey-answer-browser-other' => 'Panyungsi lianna:',
	'prefswitch-survey-question-os' => 'Anjeun maké sistem operasi naon?',
	'prefswitch-survey-answer-os-other' => 'Sistem operasi lianna:',
	'prefswitch-survey-question-res' => 'Résolusi layar nu dipaké?',
	'prefswitch-title-on' => 'Fitur anyar',
	'prefswitch-title-off' => 'Tumpurkeun fitur anyar',
	'prefswitch-title-switched-off' => 'Nuhun',
	'prefswitch-success-on' => 'Fitur anyar geus dihurungkeun. Ieu fitur bisa dipareuman iraha baé ku cara ngaklik tutumbu "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" di punclut kaca.',
	'prefswitch-success-off' => 'Fitur anyar geus dipareuman. Hatur nuhun tos nyobian. Ieu fitur bisa dihurungkeun deui iraha baé ku cara ngaklik tutumbu "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" di punclut kaca.',
	'prefswitch-success-feedback' => 'Pamanggih anjeun tos dikirim.',
	'prefswitch-return' => '<hr style="clear:both">
Balik deui ka <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main-logged-changes' => "* Ayeuna, '''tab {{int:watch}}''' jadi maké lambang béntang.
* Ayeuna, '''tab {{int:move}}''' pindah ka dropdown gigireun kolom sungsi.",
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Boivie
 * @author Cohan
 * @author Dafer45
 * @author Knuckles
 * @author MagnusA
 */
$messages['sv'] = array(
	'prefswitch' => 'Preferensväljare för Användbarhetsiniativet.',
	'prefswitch-desc' => 'Tillåt användare att byta uppsättningar av preferenser',
	'prefswitch-link-anon' => 'Nya funktioner',
	'tooltip-pt-prefswitch-link-anon' => 'Lär dig mer om nya funktioner',
	'prefswitch-link-on' => 'Byt tillbaka',
	'tooltip-pt-prefswitch-link-on' => 'Inaktivera nya funktioner',
	'prefswitch-link-off' => 'Nya funktioner',
	'tooltip-pt-prefswitch-link-off' => 'Testa nya funktioner',
	'prefswitch-jswarning' => 'Kom ihåg att med utseendeändringen måste ditt [[User:$1/$2.js|$2 JavaScript]] kopieras till [[{{ns:user}}:$1/vector.js]] <!-- eller [[{{ns:user}}:$1/common.js]]--> för att fortsätta fungera.',
	'prefswitch-csswarning' => 'Din [[User:$1/$2.css|anpassade $2-stilmall]] kommer inte lägre användas. Du kan lägga till anpassad CSS för vector-utseendet i [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Ja',
	'prefswitch-survey-false' => 'Nej',
	'prefswitch-survey-submit-off' => 'Stäng av de nya funktionerna',
	'prefswitch-survey-cancel-off' => 'Om du vill fortsätta att använda de nya funktionerna kan du återgå till $1.',
	'prefswitch-survey-submit-feedback' => 'Skicka feedback',
	'prefswitch-survey-cancel-feedback' => 'Om du inte vill ge feedback kan du återgå till $1.',
	'prefswitch-survey-question-like' => 'Vad gillade du med de nya funktionerna?',
	'prefswitch-survey-question-dislike' => 'Vad tyckte du inte om med de nya funktionerna?',
	'prefswitch-survey-question-whyoff' => 'Varför stänger du av de nya funktionerna?
Välj alla som stämmer.',
	'prefswitch-survey-question-globaloff' => 'Vill du ha funktionerna avstängda globalt?',
	'prefswitch-survey-answer-whyoff-hard' => 'Det var för svårt att använda.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Det fungerade inte korrekt.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Det betedde sig inte förutsägbart.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Jag tyckte inte om hur det såg ut.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Jag tyckte inte om de nya flikarna och layouten.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Jag gillade inte det nya verktygsfältet.',
	'prefswitch-survey-answer-whyoff-other' => 'Annan orsak:',
	'prefswitch-survey-question-browser' => 'Vilken webbläsare använder du?',
	'prefswitch-survey-answer-browser-other' => 'Andra webbläsare:',
	'prefswitch-survey-question-os' => 'Vilket operativsystem använder du?',
	'prefswitch-survey-answer-os-other' => 'Annat operativsystem:',
	'prefswitch-survey-answer-globaloff-yes' => 'Ja, avaktivera funktionerna på alla wikis.',
	'prefswitch-survey-question-res' => 'Vad är din skärmupplösning?',
	'prefswitch-title-on' => 'Nya funktioner',
	'prefswitch-title-switched-on' => 'Njut!',
	'prefswitch-title-off' => 'Stäng av de nya funktionerna',
	'prefswitch-title-switched-off' => 'Tack',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'De nya funktionerna är nu påslagna. Vi hoppas att du gillar att använda de nya funktionerna. Du kan alltid stänga av dem genom att klicka på "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" längst upp på sidan.',
	'prefswitch-success-off' => 'De nya funktionerna är nu avstängda. Tack för att du provade dessa. Du kan alltid sätta på dem igen genom att klicka på "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" längst upp på sidan.',
	'prefswitch-success-feedback' => 'Dina kommentarer har skickats.',
	'prefswitch-return' => '<hr style="clear:both"> Återgå till <span class="plainlinks">[$1 $2].</span>',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| En skärmbild av Wikipedias nya navigeringsgränssnitt <small>[[Media:VectorNavigation-en.png|(förstora)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| En skärmbild från standardgränssnittet för sidredigering <small>[[Media:VectorEditorBasic-en.png|(förstora)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-sv.png|401px|]]
|-
| En skärmbild av den nya dialogrutan för insättning av länkar
|}
|}
Wikimedia Foundations användarupplevelseteam har arbetat med frivilliga ur gemenskapen för att underlätta för dig. Vi är glada över att kunna dela med oss av vissa förbättringar, inklusive ett nytt utseende och enklare redigeringsfunktioner. Dessa förändringar syftar till att göra det lättare för nya bidragsgivare att komma igång, och grundas på vår [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study testande av användbarhet som utförts under det senaste året]. Att förbättra användbarheten av våra projekt är en prioritet för Wikimedia Foundation och vi kommer att dela med oss av fler uppdateringar i framtiden. För mer information, besök det relaterade Wikimedia-[http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blogginlägget].

===Detta är vad vi har ändrat===
* '''Navigering''': Vi har förbättrat navigeringen för att läsa och redigera sidor. Nu definierar flikarna högst upp på varje sida tydligare om du tittar på sidan eller diskussionssidan, och om du läser eller redigerar en sida.
* '''Förbättringar av redigeringsverktygsfältet''': Vi har organiserat om redigeringsverktygsfältet att göra det lättare att använda. Nu är formatering av sidor enklare och mer intuitiv.
* '''Länk-guiden''': Ett lättanvänt verktyg låter dig lägga till länkar till andra wiki-sidor samt länkar till externa webbplatser.
* '''Sökningsförbättringar''': Vi har förbättrat sökförslag för att snabbare få dig till den sida du söker.
* '''Andra nya funktioner''': Vi har också infört en tabellguide för att göra skapandet av tabeller lättare och en sök-och-ersätt-funktion för att förenkla redigering av sidor.
* '''Wikipedia-loggan''': Vi har uppdaterat loggan. Läs mer på [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ Wikimedia-bloggen].",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}}-fliken''' är nu en stjärna.
* '''{{int:move}}-fliken''' finns nu i den nedfällbara menyn intill sökfältet.",
	'prefswitch-main-feedback' => '===Feedback?===
Vi vill gärna höra dina synpunkter. Besök vår [[$1|feedbacksida]] eller, om du är intresserad av våra pågående försök att förbättra mjukvaran, besök vår [http://usability.wikimedia.org användbarhetswiki] för mer information.',
	'prefswitch-main-anon' => '=== Byt tillbaka ===
Om du vill stänga av de nya funktionerna, [$1 klicka här]. Du kommer att bli ombedd att logga in eller skapa ett konto först.',
	'prefswitch-main-on' => '===Byt tillbaka===
[$2 Klicka här för att stänga av de nya funktionerna].',
	'prefswitch-main-off' => '===Testa dem!===
Om du vill slå på de nya funktionerna, vänligen [$1 klicka här].',
	'prefswitch-survey-intro-feedback' => 'Vi vill gärna höra din åsikt.
Vänligen fyll i den frivilliga undersökningen nedan innan du klickar på "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Tack för att du testar de nya funktionerna.
För att hjälpa oss förbättra dem, var vänlig och fyll i den frivilliga undersökningen nedan innan du klickar på "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Feedback från användarerfarenhet',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 * @author Muddyb Blast Producer
 */
$messages['sw'] = array(
	'prefswitch-link-anon' => 'Zana mpya',
	'tooltip-pt-prefswitch-link-anon' => 'Jifunze kuhusu zana mpya',
	'prefswitch-link-on' => 'Nirudishe',
	'tooltip-pt-prefswitch-link-on' => 'Zima zana mpya',
	'prefswitch-link-off' => 'Zana mpya',
	'tooltip-pt-prefswitch-link-off' => 'Jaribu kutumia mtindo na zana mpya',
	'prefswitch-survey-true' => 'Ndiyo',
	'prefswitch-survey-false' => 'Siyo',
	'prefswitch-survey-submit-off' => 'Zima zana mpya',
	'prefswitch-survey-cancel-off' => 'Ikiwa utapenda kuendelea kutumia zana mpya, basi unaweza kurudi katika $1.',
	'prefswitch-survey-submit-feedback' => 'Tuma mrejeresho',
	'prefswitch-survey-cancel-feedback' => 'Iwapo hutaki kutoa maoni, unaweza kurudi katika $1.',
	'prefswitch-survey-question-like' => 'Kipi ulichopenda kwenye hii zana mpya?',
	'prefswitch-survey-question-dislike' => 'Kipi usichokipenda kuhusu hii zana mpya?',
	'prefswitch-survey-question-whyoff' => 'Kwanini unaizima hii zana mpya?
Tafadhali chagua vifungu vyote vinavyohusika.',
	'prefswitch-survey-question-globaloff' => 'Je, unataka zana mpya izimwe katika kila wiki yenye akaunti ya kwako?',
	'prefswitch-survey-answer-whyoff-hard' => 'Ilikuwa vigumu kutumia zana hizi.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Zana hazikufanyakazi vizuri.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Zana hazikufanyakazi kitegemezi.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Sijapenda jinsi zana inavyoonekana.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Sijapenda tabo mpya na mpangilio wake.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Sijapenda mwambaa zana mpya.',
	'prefswitch-survey-answer-whyoff-other' => 'Sababu nyingine:',
	'prefswitch-survey-question-browser' => 'Kivinjari kipi unachotumia?',
	'prefswitch-survey-answer-browser-other' => 'Kivinjari kingine:',
	'prefswitch-survey-question-os' => 'Unatumia mfumo gani wa uendeshaji?',
	'prefswitch-survey-answer-os-other' => 'Mfumo mwingine wa uendeshaji:',
	'prefswitch-survey-answer-globaloff-yes' => 'Ndiyo, zana mpya izimwe katika wiki zote',
	'prefswitch-survey-question-res' => 'Je, skrini yako ina msongo upi wa piseli?',
	'prefswitch-title-on' => 'Zana mpya',
	'prefswitch-title-switched-on' => 'Furahia!',
	'prefswitch-title-off' => 'Zima zana mpya',
	'prefswitch-title-switched-off' => 'Asante',
	'prefswitch-title-feedback' => 'Mrejeresho',
	'prefswitch-success-on' => 'Sasa zana mpya imewashwa. Tunatumaini unafurahia kutumia zana mpya. Unaweza muda wowote kurudi kwa kubonyeza kwenye kiungo cha "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" juu kabisa ya ukurasa.',
	'prefswitch-success-off' => 'Sasa zana mpya imezimwa. Ahsante kwa kujaribu zana mpya. Unaweza muda wowote kurudi kwa kubonyeza kwenye kiungo cha "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" juu kabisa ya ukurasa.',
	'prefswitch-success-feedback' => 'Mwitiko wako umetumwa',
	'prefswitch-return' => '<hr style="clear:both">
Urudi <span class="plainlinks">[$1 $2]</span>.',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'prefswitch-survey-true' => 'ஆம்',
	'prefswitch-survey-false' => 'இல்லை',
	'prefswitch-survey-answer-whyoff-other' => 'வேறு காரணம்:',
	'prefswitch-title-switched-off' => 'நன்றி',
	'prefswitch-title-feedback' => 'பின்னூட்டம்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'prefswitch-desc' => 'అభిరుచుల సమితులని మార్చుకోడానికి వాడుకరులకు వీలుకల్పిస్తుంది',
	'prefswitch-link-anon' => 'కొత్త సౌలభ్యాలు',
	'tooltip-pt-prefswitch-link-anon' => 'కొత్త విశేషాల గురించి తెలుసుకోండి',
	'prefswitch-link-on' => 'నన్ను వెనక్కి తీసుకెళ్ళు',
	'tooltip-pt-prefswitch-link-on' => 'కొత్త సౌలభ్యాలని నిలిపివేసుకోండి',
	'prefswitch-link-off' => 'కొత్త సౌలభ్యాలు',
	'tooltip-pt-prefswitch-link-off' => 'కొత్త సౌలభ్యాలను ప్రయత్నించండి',
	'prefswitch-survey-true' => 'అవును',
	'prefswitch-survey-false' => 'కాదు',
	'prefswitch-survey-submit-off' => 'కొత్త సౌలభ్యాలని నిలిపివేయి',
	'prefswitch-survey-cancel-off' => 'మీరు కొత్త సౌలభ్యాలను ఉపయోగించడం కొనసాగించాలనుకుంటే, మీరు తిరిగి $1కి వెళ్ళవచ్చు.',
	'prefswitch-survey-submit-feedback' => 'ప్రతిస్పందని పంపించు',
	'prefswitch-survey-cancel-feedback' => 'మీ ప్రతిస్పందనని తెలియజేయకూడదనుకుంటే, మీరు తిరిగి $1కి వెళ్ళవచ్చు.',
	'prefswitch-survey-question-like' => 'కొత్త సౌలభ్యాలలో మీకు ఏం నచ్చింది?',
	'prefswitch-survey-question-dislike' => 'కొత్త సౌలభ్యాలలో మీకు నచ్చనిదేమిటి?',
	'prefswitch-survey-question-whyoff' => 'మీరు కొత్త సౌలభ్యాలను ఎందుకు నిలిపివేసుకుంటున్నారు?
దయచేసి వర్తించేవన్నీ ఎంచుకోండి.',
	'prefswitch-survey-question-globaloff' => 'ఈ సౌలభ్యాలని మీరు సార్వత్రికంగా నిలిపివేసుకోవాలనుకుంటున్నారా?',
	'prefswitch-survey-answer-whyoff-hard' => 'వాడడానికి చాలా కష్టంగా ఉంది.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'ఇది సరిగ్గా పనిచేయడం లేదు.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'ఇది అనుకున్నట్లుగా పనిచేయడం లేదు',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'దీని రూపు నాకు నచ్చలేదు.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'కొత్త ట్యాబులు మరియు అమరిక నాకు నచ్చలేదు.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'కొత్త పనిముట్లపట్టీ నాకు నచ్చలేదు',
	'prefswitch-survey-answer-whyoff-other' => 'ఇతర కారణం:',
	'prefswitch-survey-question-browser' => 'మీరు ఏ విహారిణిని వాడుతున్నారు?',
	'prefswitch-survey-answer-browser-other' => 'ఇతర విహారిణి:',
	'prefswitch-survey-question-os' => 'మీరు వాడుతున్న నిర్వాహక వ్యవస్థ ఏది?',
	'prefswitch-survey-answer-os-other' => 'ఇతర నిర్వాహక వ్యవస్థ:',
	'prefswitch-survey-answer-globaloff-yes' => 'అవును, అన్ని వికీలలో ఈ సౌలభ్యాలని నిలిపివేయి',
	'prefswitch-survey-question-res' => 'మీ తెర వైశాల్యం ఎంత?',
	'prefswitch-title-on' => 'కొత్త సౌలభ్యాలు',
	'prefswitch-title-switched-on' => 'ఆనందించండి!',
	'prefswitch-title-off' => 'కొత్త సౌలభ్యాలని నిలిపివేయి',
	'prefswitch-title-switched-off' => 'ధన్యవాదాలు',
	'prefswitch-title-feedback' => 'ప్రతిస్పందన',
	'prefswitch-success-on' => 'కొత్త సౌలభ్యాలని ఇప్పుడు చేతనం చేసాం. కొత్త సొలభ్యాలని మీరు ఆనందిస్తారని ఆశిస్తున్నాం. పుట పైన ఉండే "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" అనే లంకె ద్వారా మీరు వాటిని ఎప్పుడైనా నిలిపివేసుకోవచ్చు.',
	'prefswitch-success-off' => 'కొత్త సౌలభ్యాలని ఇప్పుడు నిలిపివేశాం. కొత్త సొలభ్యాలని ప్రయత్నించినందుకు ధన్యవాదాలు. పుట పైన ఉండే "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" అనే లంకె ద్వారా మీరు వాటిని ఎప్పుడైనా తిరిగి పొందవచ్చు.',
	'prefswitch-success-feedback' => 'మీ ప్రతిస్పందనని పంపించాం.',
	'prefswitch-return' => '<hr style="clear:both">
తిరిగి <span class="plainlinks">[$1 $2]</span>కి.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| వికీపీడియా కొత్త మార్గదర్శకం యొక్క తెరపట్టు <small>[[Media:VectorNavigation-en.png|(పెద్ద చిత్రం)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| పుట దిద్దుబాటు అంతవర్తి యొక్క తెరపట్టు <small>[[Media:VectorEditorBasic-en.png|(పెద్ద చిత్రం)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| లంకెలను చేర్చడానికై కొత్త సంవాద పేటిక యొక్క తెరపట్టు
|}
|}
వికీని మీకు సులభతరం చేయడానికి వికీమీడియా ఫౌండేషను యొక్క User Experience జట్టు సమాజంలోని ఇతర ఔత్సాహికులతో కలిసి పనిచేస్తూంది. కొత్త రూపురేఖలు మరియు సరళీకృత దిద్దుబాటు సౌలభ్యాలతో కూడిన కొన్ని మెరుగులను మీతో పంచుకోడానికి ఆనందిస్తున్నాం. [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study గత సంవత్సరం మేం నిర్వహించిన ఉపయోగ్యతా పరీక్షల]పై ఆధారపడిన ఈ మార్పులు కొత్త వాడుకరులు తేలికగా మొదలుపెట్టడానికి ఉద్దేశించినవి. మా ప్రాజెక్టుల ఉపయోగ్యతని మెరుగుపరచడం అన్నది వికీమీడియా ఫౌండేషను యొక్క ఒక ప్రాధాన్యత మరియు భవిష్యత్తులో మేం మరిన్ని తాజాకరణలని అందిస్తాం. మరిన్ని వివరాలకై, సంబంధిత వికీమీడియా [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia బ్లాగు టపా]ని చూడండి.

=== ఇవీ మేం మార్చినవి ===
* '''మార్గదర్శకం:''' పుటలని చదవడానికి మరియు మార్చడానికి మార్గదర్శకాన్ని మెరుగుపరిచాం. ఇప్పుడు, పుటలకి పైన ఉండే ట్యాబులు మీరు పుటలో ఉన్నారా లేదా చర్చా పుటలో ఉన్నారా, మరియు పుటని చదువుతున్నారా లేదా మారుస్తున్నారా అన్న విషయాన్ని మరింత స్పష్టంగా చూపిస్తాయి.
* '''దిద్దుబాటు పనిముట్ల పట్టీకి మెరుగులు:''' మరింత తేలికగా ఉపయోగించడానికి గానూ దిట్టుబాటు పనిముట్ల పట్టీని మేం పునర్వవస్థీకరించాం. ఇప్పుడు, పుటలని రూపుదిద్దడం తేలిక మరియు సహజం.
* '''లంకెల విజార్డ్:''' ఇతర వికీ పుటలకు మరియు బయటి సైట్లకి లంకెలు చేర్చడానికి తేలికైన పనిముట్టు.
* '''అన్వేషణ మెరుగులు:''' మీరు వెతుకుతున్న పుటలకి తొందరగా చేరుకునేందుకు గానూ మేం అన్వేషణ సూచనలని మెరుగుపరిచాం.
* '''ఇతర కొత్త సౌలభ్యాలు:''' పట్టికలని సృష్టించడాన్ని సులభతరం చేయానికి ఒక పట్టికల విజార్డ్ మరియు పుటల దిద్దుబాటుని సరళం చేయడానికి వెతుకు మరియు మార్చు సౌలభ్యాన్ని కూడా ప్రవేశపెట్టాం.
* '''వికీపీడియా చిహ్నం:''' మా చిహ్నాన్ని తాజాకరించాం. [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d వికీమీడియా బ్లాగు]లో మరింత చదవండి.",
	'prefswitch-main-feedback' => '===సలహాలూ, సూచనలూ?===
మీ నుండి వినాలనుకుంటున్నాం. దయచేసి మా [[$1|ప్రతిస్పందన పుట]]ని సందర్శించండి లేదా, సాఫ్ట్‌వేరుకి మెరుగుపరిచే మా నిరంతర ప్రయత్నాల గురించి మీకు ఆసక్తి ఉంటే, మరింత సమాచారానికై మా [http://usability.wkimedia.org ఉపయోగ్యత వికీ]ని సందర్శించండి.',
	'prefswitch-main-anon' => '===నన్ను వెనక్కి తీసుకెళ్ళు===
[$1 కొత్త సౌలభ్యాలను నిలిపివేసుకోడానికి ఇక్కడ నొక్కండి]. మీరు ముందుగా ప్రవేశించాలి లేదా ఖాతాని సృష్టించుకోవాలి.',
	'prefswitch-main-on' => '===నన్ను వెనక్కి తీసుకెళ్ళు!===
ఒకవేళ మీరు కొత్త సౌలభ్యాలని నిలిపివేసుకోవాలనుకుంటే, దయచేసి [$2 ఇక్కడ నొక్కండి].',
	'prefswitch-main-off' => '===వాటిని ఉపయోగించి చూడండి!===
మీరు కొత్త సౌలభ్యాలని చూడాలనుకుంటే, దయచేసి [$1 ఇక్కడ నొక్కండి].',
	'prefswitch-survey-intro-feedback' => 'మేం మీ నుండి వినాలనుకుంటున్నాం.
"[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]"ని నొక్కే ముందు దయచేసి ఈ ఐచ్ఛిక సర్వేని పూరించండి.',
	'prefswitch-survey-intro-off' => 'కొత్త సౌలభ్యాలని ప్రయత్నించి చూసినందుకు ధన్యవాదాలు.
"[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"ని నొక్కే ముందు, ఈ సౌలభ్యాలని మరింత మెరుగుపరిచేలా మాకు తోడ్పడటానికి దయచేసి ఈ ఐచ్ఛిక సర్వేని పూరించండి.',
);

/** Thai (ไทย)
 * @author Horus
 * @author Octahedron80
 */
$messages['th'] = array(
	'prefswitch-link-anon' => 'คุณลักษณะใหม่',
	'tooltip-pt-prefswitch-link-anon' => 'เรียนรู้เกี่ยวกับคุณลักษณะใหม่',
	'prefswitch-link-on' => 'นำฉันกลับไป',
	'tooltip-pt-prefswitch-link-on' => 'ปิดใช้งานคุณลักษณะใหม่',
	'prefswitch-link-off' => 'คุณลักษณะใหม่',
	'tooltip-pt-prefswitch-link-off' => 'ลองใช้คุณลักษณะใหม่',
	'prefswitch-jswarning' => 'พึงระลึกว่าเมื่อเปลี่ยนสกิน  [[User:$1/$2.js|จาวาสคริปต์ $2]] ของคุณจะต้องถูกคัดลอกไปยัง [[{{ns:user}}:$1/vector.js]] <!-- หรือ [[{{ns:user}}:$1/common.js]]--> เพื่อให้สคริปต์ทำงานต่อไป',
	'prefswitch-survey-true' => 'ใช่',
	'prefswitch-survey-false' => 'ไม่ใช่',
	'prefswitch-survey-submit-off' => 'ปิดคุณลักษณะใหม่',
	'prefswitch-survey-cancel-off' => 'หากคุณต้องการใช้คุณลักษณะใหม่ต่อไป คุณสามารถกลับไปที่ $1',
	'prefswitch-survey-submit-feedback' => 'ส่งผลตอบรับ',
	'prefswitch-survey-cancel-feedback' => 'หากคุณไม่ต้องการแจ้งผลตอบรับ คุณสามารถกลับไปที่ $1',
	'prefswitch-survey-question-like' => 'คุณชอบอะไรเกี่ยวกับคุณลักษณะใหม่',
	'prefswitch-survey-question-dislike' => 'คุณไม่ชอบอะไรเกี่ยวกับคุณลักษณะใหม่',
	'prefswitch-survey-question-whyoff' => 'ทำไมคุณจึงปิดคุณลักษณะใหม่
กรุณาเลือกทั้งหมดที่เกี่ยวข้อง',
	'prefswitch-survey-answer-whyoff-hard' => 'คุณลักษณะใช้งานยากเกินไป',
	'prefswitch-survey-answer-whyoff-didntwork' => 'คุณลักษณะไม่ทำงานอย่างถูกต้อง',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'คุณลักษณะไม่ทำงานตามที่คาดการณ์',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'ฉันไม่ชอบแนวทางที่คุณลักษณะปรากฏ',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'ฉันไม่ชอบแท็บและการจัดวางแบบใหม่',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'ฉันไม่ชอบแถบเครื่องมือแบบใหม่',
	'prefswitch-survey-answer-whyoff-other' => 'เหตุผลอื่น:',
	'prefswitch-survey-question-browser' => 'คุณใช้เบราว์เซอร์อะไร',
	'prefswitch-survey-answer-browser-other' => 'เบราว์เซอร์อื่น:',
	'prefswitch-survey-question-os' => 'คุณใช้ระบบปฏิบัติการอะไร',
	'prefswitch-survey-answer-os-other' => 'ระบบปฏิบัติการอื่น:',
	'prefswitch-survey-question-res' => 'คุณใช้หน้าจอความละเอียดเท่าไร',
	'prefswitch-title-on' => 'คุณลักษณะใหม่',
	'prefswitch-title-switched-on' => 'ขอให้สำราญใจ!',
	'prefswitch-title-off' => 'ปิดคุณลักษณะใหม่',
	'prefswitch-title-switched-off' => 'ขอขอบคุณ',
	'prefswitch-title-feedback' => 'ผลตอบรับ',
	'prefswitch-success-on' => 'คุณได้เปิดใช้คุณลักษณะใหม่ เราหวังว่าคุณจะมีความสุขกับการใช้คุณลักษณะใหม่ คุณยังสามารถปิดการใช้งานได้ตลอดเวลาโดยการคลิกลิงก์ "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" ที่อยู่ด้านบนของหน้า',
	'prefswitch-success-off' => 'คุณได้ยกเลิกการใช้คุณลักษณะใหม่ ขอบคุณที่ได้ทดลองใช้คุณลักษณะใหม่ คุณยังสามารถเปิดการใช้งานได้ตลอดเวลาโดยการคลิกลิงก์ "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" ที่อยู่ด้านบนของหน้า',
	'prefswitch-success-feedback' => 'ความคิดเห็นของคุณได้ถูกส่งไปแล้ว',
	'prefswitch-return' => '<hr style="clear:both">
กลับไปยัง <span class="plainlinks">[$1 $2]</span>',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| สกรีนช็อตของอินเตอร์เฟซนำทางใหม่ของวิกิพีเดีย <small>[[Media:VectorNavigation-en.png|(ขยาย)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| สกรีนช็อตของอินเตอร์เฟซแก้ไขหน้าพื้นฐาน <small>[[Media:VectorEditorBasic-en.png|(ขยาย)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| สกรีนช็อตของกล่องข้อความใหม่สำหรับการเพิ่มลิงก์
|}
|}
ทีมประสบกรณ์ผู้ใช้ของมูลนิธิวิกิมีเดียได้ทำงานร่วมกับอาสาสมัครจากประชาคมเพื่อที่จะเปลี่ยนแปลงสิ่งต่าง ๆ ให้ง่ายขึ้นสำหรับคุณ เรารู้สึกตื่นเต้นอย่างยิ่งที่จะได้แลกเปลี่ยนพัฒนาการบางอย่าง รวมไปถึงภาพลักษณ์และสัมผัสใหม่ ตลอดจนถึงคุณลักษณะการแก้ไขที่ถูกทำให้ง่ายขึ้น การเปลี่ยนแปลงเหล่านี้มีจุดประสงค์เพื่อที่จะทำให้อาสาสมัครหน้าใหม่สามารถเริ่มต้นใช้งานง่ายขึ้น และตั้งอยู่บน[http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study การทดสอบการใช้งานซึ่งได้ดำเนินการมาตั้งแต่ปีที่แล้ว]ของเรา มูลนิธิวิกิมีเดียถือการปรับปรุงการใช้งานของโครงการของเราเป็นสำคัญ และเราจะแลกเปลี่ยนการอัปเดตมากขึ้นอีกในอนาคต สำหรับรายละเอียดเพิ่มเติม ดูที่ [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia บล็อก]ของวิกิมีเดียที่เกี่ยวข้อง

=== นี่คือสิ่งที่เราได้เปลี่ยนแปลง ===
* '''การนำทาง:''' เราได้พัฒนาการนำทางสำหรับการอ่านและการแก้ไขหน้า ตอนนี้ แท็บที่อยู่ด้านบนของแต่ละหน้าจะมีการจำกัดความชัดเจนยิ่งขึ้นว่าคุณกำลังดูหน้าหรือหน้าอภิปราย หรือว่าคุณกำลังอ่านหรือแก้ไขหน้า
* '''การพัฒนาแถบเครื่องมือแก้ไข:''' เราได้จัดระเบียบแถบเครื่องมือแก้ไขเพื่อให้การใช้งานง่ายขึ้น ตอนนี้ การจัดหน้าง่ายขึ้นและเป็นธรรมชาติมากขึ้น
* '''วิซาร์ดลิงก์:''' เครื่องมือที่ง่ายต่อการใช้ทำให้คุณสามารถเพิ่มลิงก์ไปยังหน้าวิกิอื่นเช่นเดียวกับลิงก์ไปยังไซต์ภายนอก
* '''การปรับปรุงการค้นหา:''' เราได้ปรับปรุงข้อเสนอเกี่ยวกับการค้นหาเพื่อนำคุณไปยังหน้าที่ต้องการได้เร็วรวดยิ่งขึ้น
* '''คุณลักษณะใหม่อื่น ๆ:''' เราได้เพิ่มวิซาร์ดสร้างตารางเพื่อทำให้การสร้างตารางง่ายขึ้นและคุณลักษณะค้นหาและแทนที่คำเพื่อให้การแก้ไขหน้าสะดวกยิ่งขึ้น
* '''โลโก้วิกิพีเดีย:''' เราได้อัปเดตโลโก้ของเรา อ่านเพิ่มเติมได้ที่ [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d บล็อกวิกิมีเดีย]",
	'prefswitch-main-logged-changes' => "* '''แท็บ{{int:watch}}''' ถูกเปลี่ยนเป็นรูปดาวแทน
* '''แท็บ{{int:move}}''' ตอนนี้เป็นแถบ dropdown ถัดจากแถบค้นหา",
	'prefswitch-main-feedback' => '===ความคิดเห็น?===
เราต้องการทราบความคิดเห็นของคุณ โปรดเข้าไปยัง[[$1|หน้าเสนอความคิดเห็น]] หรือถ้าคุณสนใจในความพยายามของเราเพื่อที่จะปรับปรุงซอฟต์แวร์ สามารถดูรายละเอียดเพิ่มเติมได้ที่ [http://usability.wikimedia.org usability wiki]',
	'prefswitch-main-anon' => '=== นำฉันกลับไป ===
[$1 คลิกที่นี่เพื่อปิดคุณลักษณะใหม่] คุณต้องล็อกอินหรือมีบัญชีผู้ใช้ก่อน',
	'prefswitch-main-on' => '=== นำฉันกลับไป!===
[$2 คลิกที่นี่เพื่อปิดคุณลักษณะใหม่]',
	'prefswitch-main-off' => '=== ลองคุณลักษณะใหม่! ===
[$1 คลิกที่นี่เพื่อเปิดใช้คุณลักษณะใหม่]',
	'prefswitch-survey-intro-feedback' => 'เราต้องการที่จะทราบความคิดเห็นของคุณ
โปรดตอบแบบสำรวจทางเลือกด้านล่างก่อนที่จะคลิก "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]"',
	'prefswitch-survey-intro-off' => 'ขอบคุณที่ได้ทดลองใช้คุณลักษณะใหม่ของเรา
เพื่อช่วยเราปรับปรุงคุณลักษณะใหม่ โปรดตอบแบบสำรวจทางเลือกด้านล่างก่อนคลิก "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'prefswitch' => 'Oňaýlylyk Başlangyjy ileri tutma pereklýuçateli',
	'prefswitch-desc' => 'Ulanyjylaryň ileri tutma toplumlaryny çalyşmagyna rugsat berýär',
	'prefswitch-link-anon' => 'Täze funksiýalar',
	'tooltip-pt-prefswitch-link-anon' => 'Täze funksiýalary öwren',
	'prefswitch-link-on' => 'Meni yzyma äkit',
	'tooltip-pt-prefswitch-link-on' => 'Täze funksiýalary ýap',
	'prefswitch-link-off' => 'Täze funksiýalar',
	'tooltip-pt-prefswitch-link-off' => 'Täze funksiýalary synap gör',
	'prefswitch-jswarning' => 'Bezeg çalşylanyndan soň, [[User:$1/$2.js|$2 JavaScript]] kodlaryňyzyň işlemäge dowam etmegi üçin [[{{ns:user}}:$1/vector.js]] <!-- ýa-da [[{{ns:user}}:$1/common.js]]--> sahypasyna göçürilmelidir.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|Hususy $2 stilleriňiz]] indi ulanylmaz. Vector üçin ýörite CSS kodlaryňyzy [[{{ns:user}}:$1/vector.css]] sahypasynagoşup bilersiňiz.',
	'prefswitch-survey-true' => 'Hawa',
	'prefswitch-survey-false' => 'Ýok',
	'prefswitch-survey-submit-off' => 'Täze funksiýalary ýap',
	'prefswitch-survey-cancel-off' => 'Eger täze funksiýalary ulanmaga dowam etjek bolsaňyz, $1 sahypasyna dolanyp bilersiňiz.',
	'prefswitch-survey-submit-feedback' => 'Seslenme iber',
	'prefswitch-survey-cancel-feedback' => 'Eger seslenme bildiresiňiz gelmeýän bolsa, $1 sahypasyna dolanyp bilersiňiz.',
	'prefswitch-survey-question-like' => 'Täze funksiýalarda size näme ýarady?',
	'prefswitch-survey-question-dislike' => 'Täze funksiýalarda size näme ýaramady?',
	'prefswitch-survey-question-whyoff' => 'Täze funksiýalary näme üçin ýapýarsyňyz?
Ähli gabat gelýänleri saýlaň.',
	'prefswitch-survey-question-globaloff' => 'Funksiýalaryň global ýapylmagyny isleýärsiňizmi?',
	'prefswitch-survey-answer-whyoff-hard' => 'Funksiýalary ulanmak örän çylşyrymly.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Funksiýalar bolmalysy ýaly işlemeýär.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Funksiýalar öňünden çak edip bolar ýaly işlemedi.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Funksiýalaryň görünişini halamadym.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Täze salmalary we sahypalamany halamadym.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Täze gural panelini halamadym.',
	'prefswitch-survey-answer-whyoff-other' => 'Başga sebäp:',
	'prefswitch-survey-question-browser' => 'Nähili brauzer ulanýarsyňyz?',
	'prefswitch-survey-answer-browser-other' => 'Başga brauzer:',
	'prefswitch-survey-question-os' => 'Nähili operasion ulgam ulanýarsyňyz?',
	'prefswitch-survey-answer-os-other' => 'Başga operasion ulgam:',
	'prefswitch-survey-answer-globaloff-yes' => 'Hawa, funksiýalary ähli wikilerde ýap',
	'prefswitch-survey-question-res' => 'Ekran çözgüdiňiz näçe?',
	'prefswitch-title-on' => 'Täze funksiýalar',
	'prefswitch-title-switched-on' => 'Hezilini görüň!',
	'prefswitch-title-off' => 'Täze funksiýalary ýap',
	'prefswitch-title-switched-off' => 'Sag boluň',
	'prefswitch-title-feedback' => 'Seslenme',
	'prefswitch-success-on' => 'Täze funksiýalar şu wagt açyk. Täze funksiýalary halarsyňyz diýip umyt edýäris. Islän wagtyňyz sahypanyň iň ýokarsyndaky "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" çykgydyna basyp, ondan çykyp bilersiňiz.',
	'prefswitch-success-off' => 'Täze funksiýalar şu wagt ýapyk. Täze funksiýalary synap göreniňiz üçin minnetdar. Islän wagtyňyz sahypanyň iň ýokarsyndaky "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" çykgydyna basyp, oňa girip bilersiňiz.',
	'prefswitch-success-feedback' => 'Seslenmäňiz iberildi.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span> sahypasyna dolan',
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} salmasy'''nda indi ýyldyz bar.
* '''{{int:move}} salmasy''' indi gözleg paneliniň ýanyndaky açylýan menýuda.",
	'prefswitch-main-feedback' => '===Seslenme===
Seslenmeleriňize gulak asmak isleýäris. [[$1|Seslenme]] sahypamyza ýa-da programmany ösdürmek üçin alyp barýan tagallarymyz bilen gyzyklanýan bolsaňyz, giňişleýin maglumat üçin [http://usability.wikimedia.org oňaýlylyk wikimize] gelip görüň.',
	'prefswitch-main-anon' => '===Meni yzyma äkit===
Eger täze funksiýalary ýapasyňyz gelse, [$1 şu ýere basyň]. Ilki bilen sessiýa açmagyňyz ýa-da hasap döretmegiňiz soralar.',
	'prefswitch-main-on' => '===Meni yzyma äkit!===
[$2 Täze funksiýalary ýapmak üçin şu ýere basyň].',
	'prefswitch-main-off' => '===Olary synap görüň!===
[$1 Täze funksiýalary açmak üçin şu ýere basyň].',
	'prefswitch-survey-intro-feedback' => 'Seslenmeleriňize gulak asmak isleýäris.
"[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" çykgydyna basmankaňyz, ilki bilen aşakdaky hökmany däl soraglara jogap beriň.',
	'prefswitch-survey-intro-off' => 'Täze funksiýalary synap göreniňiz üçin sag boluň.
Olary ösdürmegimize kömek etmek üçin, "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" çykgydyna basmankaňyz, ilki bilen aşakdaky hökmany däl soraglara jogap beriň.',
	'prefswitch-feedbackpage' => 'Project:Ulanyjynyň tejribe seslenmesi',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'prefswitch' => 'Pindutan ng nais sa Pampanimula ng Pagkanagagamit',
	'prefswitch-desc' => 'Pahintulutan ang mga tagagamit na magpalit ng mga pangkat ng mga nais',
	'prefswitch-link-anon' => 'Bagong mga kasangkapang-katangian',
	'tooltip-pt-prefswitch-link-anon' => 'Pag-aralan ang bagong mga kasangkapang-katangian',
	'prefswitch-link-on' => 'Ibalik ako',
	'tooltip-pt-prefswitch-link-on' => 'Huwag paganahin ang bagong mga kasangkapang-katangian',
	'prefswitch-link-off' => 'Bagong mga kasangkapang-katangian',
	'tooltip-pt-prefswitch-link-off' => 'Subukan ang bagong mga kasangkapang-katangian',
	'prefswitch-jswarning' => 'Tandaan na sa pagbago ng pabalat, ang iyong [[User:$1/$2.js|$2 JavaScript]] ay kailangang kopyahin papunta sa [[{{ns:user}}:$1/vector.js]] <!-- o [[{{ns:user}}:$1/common.js]]--> upang magpatuloy sa pag-andar.',
	'prefswitch-csswarning' => 'Ang iyong [[User:$1/$2.css|custom $2 styles]] ay hindi na gagamitin.  Makapagdaragdag ka ng pinasadyang CSS para sa bektor sa loob ng [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Oo',
	'prefswitch-survey-false' => 'Huwag',
	'prefswitch-survey-submit-off' => 'Huwag buhayin ang bagong mga katasangkapang-katangian',
	'prefswitch-survey-cancel-off' => 'Kung nais mong magpatuloy sa paggamit ng bagong mga kasangkapang-katangian, maaaring kang magbalik sa $1.',
	'prefswitch-survey-submit-feedback' => 'Magpadala ng pabalik-sabi',
	'prefswitch-survey-cancel-feedback' => 'Kung ayaw mong magbigay ng balik-puna, maaaring kang magbalik sa $1.',
	'prefswitch-survey-question-like' => 'Ano ang nagustuhan mo tungkol sa bagong mga kasangkapang-katangian?',
	'prefswitch-survey-question-dislike' => 'Ano ang hindi mo naibigan tungkol sa mga kasangkapang-katangian?',
	'prefswitch-survey-question-whyoff' => 'Bakit mo hindi binubuhay ang bagong mga kasangkapang-katangian?
Mangyaring piliin ang lahat ng maaari.',
	'prefswitch-survey-question-globaloff' => 'Nais mo bang global na huwag paganahin ang mga tampok?',
	'prefswitch-survey-answer-whyoff-hard' => 'Napakahirap gamitin ng mga kasangkapang-katangian.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Hindi gumandar ng maayos ang mga kasangkapang-katangian.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Hindi maaasahan ang pagganap ng mga kasangkapang-katangian.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Hindi ko nagustuhan ang hitsura ng mga kasangkapang-katangian.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Hindi ko gusto ang bagong mga panglaylay at pagkakaayos.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Hindi ko nagustuhan ang bagong kahong ng kasangkapan.',
	'prefswitch-survey-answer-whyoff-other' => 'Ibang dahilan:',
	'prefswitch-survey-question-browser' => 'Anong pantingin-tingin ang ginagamit mo?',
	'prefswitch-survey-answer-browser-other' => 'Ibang pantingin-tingin:',
	'prefswitch-survey-question-os' => 'Anong sistema ng pagpapaandar ang ginagamit mo?',
	'prefswitch-survey-answer-os-other' => 'Ibang sistemang pampaandar:',
	'prefswitch-survey-answer-globaloff-yes' => 'Oo, patayin ang mga tampok sa lahat ng mga wiki',
	'prefswitch-survey-question-res' => 'Ano ang resolusyon ng iyong tanawan?',
	'prefswitch-title-on' => 'Bagong mga kasangkapang-katangian',
	'prefswitch-title-switched-on' => 'Lasapin!',
	'prefswitch-title-off' => 'Huwag buhayin ang bagong mga katasangkapang-katangian',
	'prefswitch-title-switched-off' => 'Salamat',
	'prefswitch-title-feedback' => 'Balik-sabi',
	'prefswitch-success-on' => 'Binuhay na ang bagong mga kasangkapang-katangian.  Umaasa kaming masisiyahan ka sa paggamit ng bagong mga tampok.  Palaging maaari mong huwag buhayin ang mga ito sa pamamagitan ng pagpindot sa kawing na "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" na nasa itaas ng pahina.',
	'prefswitch-success-off' => 'Hindi na binuhay ang mga kasangkapang-katangian.  Salamat sa pagsubok mo ng bagong mga tampok.  Palaging maaari mong silang buhaying muli sa pamamagitan ng pagpindot ng kawing na "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" na nasa itaas ng pahina.',
	'prefswitch-success-feedback' => 'Naipadala na ang iyong pabalik-sabi.',
	'prefswitch-return' => 'Bumalik sa <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Isang larawan ng bagong ugnayang-mukha ng Wikipedia <small>[[Media:VectorNavigation-en.png|(palakihin)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| Isang larawan ng payak na ugnayang-mukha na pampatnugot ng pahina <small>[[Media:VectorEditorBasic-en.png|(palakihin)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| Isang larawan ng bagong kahon ng salitaan para sa pagpapasok ng mga kawing
|}
|}
Ang Pangkat na Pangkaranasan ng Tagagamit ng Pundasyong Wikimedia ay nakikilahok sa mga nagkukusang-loob mula sa pamayanan upang mapadali ang mga bagay-bagay para sa iyo.  Nasasabik kaming ipamahagi ang ilang mga pagpapainam, kabilang ang isang bagong pagmumukha at pinapayak na mga kasangkapang-katangian sa pamamatnugot.  Ang mga pagbabago ay naglalayong magawang madali para sa bagong mga tagapag-ambag ang pagsisimula, at nakabatay sa aming [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study isinagawang pagsubok ng pagkanagagamit sa loob ng nakaraang taon].  Isang priyoridad ng Pundasyong Wikimedia ang pagpapainam ng pagkanagagamit ng aming mga proyekto at magpapamahagi kami ng mas marami pang mga pagsasapanahon sa hinaharap.  Para sa mas marami pang mga detalye, dalawin ang kaugnay na [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia ipinaskil na blog].

===Naririto ang mga binago namin===
* '''Panglibot''': Pinainam namin ang nabigasyon para sa pagbasa at pagbago ng mga pahina. Ngayon, mas malinaw na nilalarawan ng mga panglaylay na nasa itaas ng bawat pahina kung tinitingnan ba ang pahina o isang pahina ng usapan, at kung binabasa mo ba o binabago ang isang pahina.
* '''Mga pagpapainam ng kahon ng kasangkapan na pampatnugot''':  Muli naming inayos ang kahon ng kasangkapan na pampatnugot upang maging mas maginhawa ang paggamit nito.  Ngayon, mas payak na ang pag-aayos ng pahina at mas mapangpadama.
* '''Mahiwagang kawing''':  Isang kasangkapang madaling gamitin na nagpapahintulot sa iyo na magdagdag ng mga kawing sa iba pang mga pahina ng wiki pati na mga kawing sa mga sityong nasa labas.
* '''Mga pagpapainam sa paghahanap''': Pinainam namin ang mga mungkahi sa paghahanap upang mas mabilis kang makapunta sa pahinang hinahanap mo.
* '''Iba pang bagong mga kasangkapang-katangian''':  Ipinakilala rin namin ang isang mahiwagang tabla upang maging maginhawa ang paggawa ng mga tabla at kasangkapang-katangiang panghanap at pampalit upang mapapayak ang pagbago sa pahina.
* '''Logo ng Wikipedia''': Isinapanahon namin ang logo namin. Magbasa pa ng marami sa [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blog ng Wikimedia].",
	'prefswitch-main-logged-changes' => " * Ang '''laylay na {{int:watch}}''' ay isa na ngayong bituin.
* Ang '''laylay na {{int:move}}''' ay nasa pambagsak-pababa na ngayon katabi ng halang na panghanap.",
	'prefswitch-main-feedback' => '===Balik-tugon?===
Nais naming makarinig mula sa iyo.  Pakidalaw ang aming [[$1|pahina ng balik-tugon]] o, kung interesado ka sa aming nagaganap na mga gawain sa pagpapaigi ng sopwer, dalawin ang aming [http://usability.wikimedia.org wiki ng pagkanagagamit] para sa mas marami pang kabatiran.',
	'prefswitch-main-anon' => '===Ibalik ako===
Kung nais mong patayin ang bagong mga kasangkapang-katangian, [$1 pindutin dito]. Hihilingin sa iyong lumagda ka o lumikha muna ng isang akawnt.',
	'prefswitch-main-on' => '===Ibalik ako!===
[$2 Pindutin dito upang huwag buhayin ang bagong mga kasangkapang-katangian].',
	'prefswitch-main-off' => '===Subukin ang mga ito!===
Kung nais mong buhayin ang mga bagong kasangkapang-katangian, mangyaring [$1 pindutin  dito].',
	'prefswitch-survey-intro-feedback' => 'Ibig naming marinig ka.
Mangyaring sulatan ang maaaring hindi saguting pangangalap na nasa ibaba bago pindutin ang "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Salamat sa pagsubok ng bago naming mga kasangkapang-katangian.
Upang makatulong sa pagpapainam ng mga ito, mangyaring sulatan ang maaaring walang pangangalap na nasa ibaba bago pindutin ang "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project: Tugon sa karanasan ng tagagamit',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Srhat
 */
$messages['tr'] = array(
	'prefswitch' => 'Kullanılabilirlik Girişimi tercih anahtarı',
	'prefswitch-desc' => 'Kullanıcıların tercih kümelerini değiştirmesine izin ver',
	'prefswitch-link-anon' => 'Yeni özellikler',
	'tooltip-pt-prefswitch-link-anon' => 'Yeni özellikleri öğren',
	'prefswitch-link-on' => 'Beni geri götür',
	'tooltip-pt-prefswitch-link-on' => 'Yeni özellikleri devre dışı bırak',
	'prefswitch-link-off' => 'Yeni özellikler',
	'tooltip-pt-prefswitch-link-off' => 'Yeni özellikleri dene',
	'prefswitch-jswarning' => 'Tema değişikliğinden sonra [[User:$1/$2.js|$2 JavaScript]] kodlarınızın çalışmaya devam etmesi için [[{{ns:user}}:$1/vector.js]] <!-- veya [[{{ns:user}}:$1/common.js]]--> sayfasına kopyalanması gerekecektir.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|Özel $2 stilleriniz]] artık uygulanmayacaktır. Vector teması için özel CSS kodlarınızı [[{{ns:user}}:$1/vector.css]] sayfasına ekleyebilirsiniz.',
	'prefswitch-survey-true' => 'Evet',
	'prefswitch-survey-false' => 'Hayır',
	'prefswitch-survey-submit-off' => 'Yeni özellikleri kapat',
	'prefswitch-survey-cancel-off' => 'Yeni özellikleri kullanmaya devam etmek isterseniz, $1 sayfasına geri dönebilirsiniz.',
	'prefswitch-survey-submit-feedback' => 'Geribildirim verin',
	'prefswitch-survey-cancel-feedback' => 'Eğer geribildirim vermek istemiyorsanız, $1 sayfasına geri dönebilirsiniz.',
	'prefswitch-survey-question-like' => 'Yeni özellikler hakkında neleri sevdiniz?',
	'prefswitch-survey-question-dislike' => 'Özellikler hakkında neleri sevmediniz?',
	'prefswitch-survey-question-whyoff' => 'Neden yeni özellikleri kapatıyorsunuz?
Lütfen uygun olanları seçin.',
	'prefswitch-survey-question-globaloff' => 'Özellikleri küresel olarak kapatmak istiyor musunuz?',
	'prefswitch-survey-answer-whyoff-hard' => 'Kullanımı çok zor.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Düzgün çalışmadı.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Tahmin edilebilir şekilde çalışmadı.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Görünümünü beğenmedim.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Yeni sekmeleri ve düzeni beğenmedim.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Yeni araç çubuğunu beğenmedim.',
	'prefswitch-survey-answer-whyoff-other' => 'Diğer sebep:',
	'prefswitch-survey-question-browser' => 'Hangi tarayıcıyı kullanıyorsunuz?',
	'prefswitch-survey-answer-browser-other' => 'Diğer tarayıcı:',
	'prefswitch-survey-question-os' => 'Hangi işletim sistemini kullanıyorsunuz?',
	'prefswitch-survey-answer-os-other' => 'Diğer işletim sistemi:',
	'prefswitch-survey-answer-globaloff-yes' => 'Evet, tüm vikilerde özellikleri kapat',
	'prefswitch-survey-question-res' => 'Ekran çözünürlüğünüz nedir?',
	'prefswitch-title-on' => 'Yeni özellikler',
	'prefswitch-title-switched-on' => 'Tadını çıkarın!',
	'prefswitch-title-off' => 'Yeni özellikleri kapat',
	'prefswitch-title-switched-off' => 'Teşekkürler',
	'prefswitch-title-feedback' => 'Geribildirim',
	'prefswitch-success-on' => 'Yeni özellikler şimdi açıldı. Yeni özellikleri kullanmayı seveceğinizi umuyoruz. Her zaman sayfanın en üstündeki "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" bağlantısına tıklayarak kapatabilirsiniz.',
	'prefswitch-success-off' => 'Yeni özellikler şimdi kapalı. Yeni özellikleri denediğiniz için teşekkürler. Her zaman sayfanın en üstündeki "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" bağlantısına tıklayarak yeniden açabilirsiniz.',
	'prefswitch-success-feedback' => 'Geribildiriminiz gönderildi.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2]</span> sayfasına geri dön.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-tr.png|401px|]]
|-
| Vikipedinin yeni dolaşım arayüzünden bir görüntü <small>[[Media:VectorNavigation-tr.png|(genişlet)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-tr.png|401px|]]
|-
| Basit sayfa düzenleme arayüzünün görüntüsü <small>[[Media:VectorEditorBasic-tr.png|(genişlet)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-tr.png|401px|border]]
|-
| Bağlantı ekleme iletişim kutusunun görüntüsü
|}
|}
Wikimedia Vakfının Kullanıcı Deneyimi Takımı işleri sizin için kolaylaştırmak maksadıyla gönüllülerle birlikte çalışıyor. Sizinle, yeni bir görünüm ve basitleştirilmiş düzenleme özellikleri gibi, bazı geliştirmeleri paylaşmanın heyecanı içerisindeyiz. [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study Geçen yıl yaptığımız kullanılabilirlik testine] dayalı olan bu değişikliklerle, yeni katılanların kolay bir başlangıç yapabilmeleri planlanmıştır. Projelerimizin kullanılabilirliğini yükseltmek Wikimedia Vakfının önceliklerinden biridir, ileride daha çok güncelleştirme paylaşıyor olacağız. Ayrıntılı bilgi için, ilgili Wikimedia [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog yazısını] okuyun.

=== İşte değiştirdiklerimiz ===
* '''Dolaşım:''' Sayfaları okuma ve düzenlemeye yönelik dolaşımı geliştirdik. Artık her sayfanın başındaki sekmeler, sayfaya mı yoksa tartışma sayfasına mı bakıyorsunuz ya da sayfayı okuyor musunuz değiştiriyor musunuz daha açık bir şekilde gösterecek.
* '''Düzenleme araç çubuğu geliştirmeleri:''' Düzenleme araç çubuğunu daha kolay kullanım için yeniden düzenledik. Artık sayfaları düzenlemek daha kolay ve daha sezgisel.
* '''Bağlantı sihirbazı:''' Harici sitelere veya diğer viki sayfalarına bağlantı vermenizi sağlayan kullanımı kolay bir araç.
* '''Arama geliştirmeleri:''' Aradığınız sayfaya daha çabuk ulaşabilmeniz için arama önerilerimizi geliştirdik
* '''Diğer yeni özellikler:''' Ayrıca tabloların yapımını kolaylaştırmak için bir tablo sihirbazı ve sayfa düzenlenmesini kolaylaştırmak için bul ve değiştir özelliği sunuyoruz.
* '''Vikipedi logosu:''' Logomuzu güncelledik. Daha fazla bilgi için [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia bloguna] bakın.",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} sekmesi'''nde artık bir yıldız simgesi var.
* '''{{int:move}} sekmesi''' artık arama kutusunun yanındaki açılır listede.",
	'prefswitch-main-feedback' => '===Geribildirim===
Düşüncelerinizi duymak isteriz. Lütfen [[$1|geribildirim]] sayfamızı veya eğer yazılımı geliştirmek için sürdürülmekte olan çabalarımızla ilgileniyorsanız daha fazla bilgi için [http://usability.wikimedia.org kullanılabilirlik vikimizi] ziyaret edin.',
	'prefswitch-main-anon' => '===Beni geri götür===
Eğer yeni özellikleri kapatmak isterseniz, [$1 buraya tıklayın]. Öncelikle giriş yapmanız veya bir hesap oluşturmanız istenecektir.',
	'prefswitch-main-on' => '===Beni geri götür!===
[$2 Yeni özellikleri kapatmak için buraya tıklayın]',
	'prefswitch-main-off' => '===Deneyin!===
Yeni özellikleri açmak için lütfen [$1 buraya tıklayın].',
	'prefswitch-survey-intro-feedback' => 'Sizi dinlemek isteriz.
Lütfen "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]" bağlantısına tıklamadan önce aşağıdaki isteğe bağlı anketimizi doldurun.',
	'prefswitch-survey-intro-off' => 'Yeni özellikleri denediğiniz için teşekkürler.
Bunları geliştirmemize yardımcı olmak için, lütfen "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]" bağlantısına tıklamadan önce aşağıdaki isteğe bağlı anketimizi doldurun.',
	'prefswitch-feedbackpage' => 'Project:Kullanıcı deneyim geribildirimi',
);

/** Tatar (Татарча/Tatarça)
 * @author Ильнар
 */
$messages['tt'] = array(
	'prefswitch-survey-question-res' => 'Экраныгызның киңәйтелмәсе нинди?',
	'prefswitch-title-on' => 'Яңа мөмкинчелекләр',
	'prefswitch-title-switched-on' => 'Рәхәтләнегез!',
	'prefswitch-title-off' => 'Яңа мөмкинчелекләрне ябарга',
	'prefswitch-title-switched-off' => 'Рәхмәт',
	'prefswitch-title-feedback' => 'Безнең белән элемтә',
	'prefswitch-success-on' => 'Яңа мөмкинчелекләр ачылды. Сезгә ошар дип уйлыйбыз. Сез бу мөмкинчелекләрне теләсә кайсы вакытны яба аласыз, бары тик бу сылтамага гына басарга кирәк «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» .',
	'prefswitch-success-off' => 'Яңа мөмкинчелекләр ябылды. Сынап караганыгыз өчен бик зур рәхмәт. Сез бу мөмкинчелекләрне теләсә кайсы вакытны яңадан ача аласыз, бары тик бу сылтамага гына басарга кирәк «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» .',
	'prefswitch-success-feedback' => 'Сезнең фикер җибәрелде.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2] исемле биткә кире кайту</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-tt.png|401px|]]
|-
|  Википедия интерфейсының яңа бизәлеше <small>[[Media:VectorNavigation-tt.png|(зурайтырга)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-tt.png|401px|]]
|-
| Бит үзгәрткечнең төп бизәлеше <small>[[Media:VectorEditorBasic-tt.png|(зурайтырга)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-tt.png|401px|]]
|-
| Сылтама ясау өчен диалогның яңа бизәлеше
|}
|}
«Викимедиа Фондында» сәхифәне куллану буенча махсус төркем эшли, төрле илләрдән җыелган волентерлар белән алар Википедия һәм башка вики-проектларны үстерүдә зур өлеш кертәләр. Хәзергесе вакытта без сезгә яңа интерфейс бизәлеше һәм яңа төрле үзгәрткеч тәкъдим итәбез. Бу үзгәртүләр гади кулланучыларның эшен җиңеләйтү өчен кулланыла һәм алдагы елда үткәрелгән [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study сорау алуга нигезләнгән]. Яңа бизәлеш һәм уңайлылык «Викимедиа Фонды»  тарафынанбик өстенлекле проект булып тора. Тулырак мәгъләматны [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/  Викимедия блогында] карый аласыз.

=== Без ниләр үзгәрттек ===
* '''Навигация.''' Без навигацияне тулысынча үзгәрттек дисәк тә була. Без аны тагын да уңайлырак һәм матуррак эшләдек. Хәзер өстә урнаштырылган кыстыргычлар сезнең ниләр эшләгәнегезне, битне яисә бәхәс битен каравыгызны мы, әллә бөтенләй дә яңа бит ясавыгызны мы тулысынча аңлатып бирә. 
* '''Үзгәртү панеле.''' Үзгәртү панелен алмаштыру нәтиҗәсендә битләрне ясау, үзгәртү тагын да тизрк һәм уңайлырак була.
* '''Сылтама ясагыч.''' Гади сылтама ясау коралы нигезендә эчке, проект эчендә урнашкан вики-битләргә, шулай ук тышкы сәхифәләргә дә ясарга мөмкин.
* '''Эзләү.''' Без эзләүдә булган ярдәмче хәбәрләрне тулыландыра төштек, болар барсы да сезнең эзләгән битне тизрәк һәм уңайлырак табу өчен эшләнде
* '''Башка яңа функцияләр.''' Яңа табын ясау коралы сезгә вивда табыннарны ясауны җиңеләйтер дип уйлыйбыз.Шулай ук хатаны эзләү һәм алмаштыру функциясен өстәдек. 
* '''Логотип.''' Без шарик-пазлның яңа бизәлешен ясадык, тулырак мәгълүмат [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Викимедия блогында].",
	'prefswitch-main-logged-changes' => "* '''«{{int:watch}}» кыстырмасы'''  хәзер йолдыз формасында.
* ''' «{{int:move}}» кыстырмасы'''  төшерелмә менюга куелган.",
	'prefswitch-main-feedback' => '=== Элемтә ===
Без сезнең фикерләрегезне ишәтебез килә. Зинһар, безнең [[$1|элемтә битенә керегез]]. Әгәрдә сезгә безнең яңа төрле программа белән тәэмин ителеш турында күбрәк беләсегез килсә  [http://usability.wikimedia.org бизәлеш проекты сәхифәсен] карагыз.',
	'prefswitch-main-anon' => '=== Ничек бар шулай кайтарырга ===
Әгәрдә сез яңа мөмкинчелекләрне ябасагыз килсә, [$1монда басыгыз]. Сезгә башта сәхифәгә керергә яисә яңадан теркәлергә тәкъдим ителәчәк.',
	'prefswitch-main-on' => '=== Яңадан кайтарыгыз! ===
Әгәрдә сез бөтен яңа мөмкинчелекләрне ябасыгыз килсә, зинһар, [$2 монда басыгыз].',
	'prefswitch-main-off' => '=== Сынап карагыз! ===
Әгәрдә сезнең яңа мөмкинчелекләрне сынап карыйсыгыз килсә, зинһар, [$1 монда басыгыз].',
	'prefswitch-survey-intro-feedback' => 'Без сезнең фикерләрегезне беләсебез килә.
Зинһар, «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]» төймәсенә баскыйнча,  аста урнашкан сорауларга җавап бирегез.',
	'prefswitch-survey-intro-off' => "Яңа мөмкинчелекләрне сынап караганыгыз өчен бик зур рәхмәт!
Безгә аларның сыйфатын тагын да артыру өчен аста бирелгән сорауларга җавап бирегез. ''(җавап бирү мәҗбүри түгел)''
Шуннан соң «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]»  төймәсенә баса аласыз.",
	'prefswitch-feedbackpage' => 'Project:Яңа бизәлеш турында фикерләр',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author Don Alessandro
 * @author Ильнар
 * @author Рашат Якупов
 */
$messages['tt-cyrl'] = array(
	'prefswitch' => 'Юзабилити инициативасы көйләүләрен күчерү',
	'prefswitch-desc' => 'Кулланучыларга көйләүләр наборларын күчерергә мөмкинлек бирә',
	'prefswitch-link-anon' => 'Яңа мөмкинчелекләр',
	'tooltip-pt-prefswitch-link-anon' => 'Яңа мөмкинчелекләр турында',
	'prefswitch-link-on' => 'Ничек бар шулай кайтарырга',
	'tooltip-pt-prefswitch-link-on' => 'Яңа мөмкинчелекләрне ябарга',
	'prefswitch-link-off' => 'Яңа мөмкинчелекләр',
	'tooltip-pt-prefswitch-link-off' => 'Яңа мөмкинчелекләрне исбатлап карагыз',
	'prefswitch-jswarning' => 'Исегездә тотыгыз, бизәлешнең үзгәртелү нәтиҗәсендә, сезнең [[User:$1/$2.js|$2 JavaScript]]   [[{{ns:user}}:$1/vector.js]]  күчерелергә тиеш <!-- яисә [[{{ns:user}}:$1/common.js]]-->, киләчәктә эшләсен өчен.',
	'prefswitch-csswarning' => 'Сезнең [[User:$1/$2.css| «$2» өчен каралган шәхси бизәлешегез]] киләчәктә кулланылмаячак. Сез үзегезнең шәхси CSS  «Вектор»  исемле бизәлеш өчен куллана аласыз, уле [[{{ns:user}}:$1/vector.css]] файлында урнашкан.',
	'prefswitch-survey-true' => 'Әйе',
	'prefswitch-survey-false' => 'Юк',
	'prefswitch-survey-submit-off' => 'Яңа мөмкинчелекләрне сүндерергә',
	'prefswitch-survey-cancel-off' => 'Сез алга таба да яңа мөмкинчелекләрне кулланырга теләсәгез, Сез $1 кайта аласыз.',
	'prefswitch-survey-submit-feedback' => 'Фикерләрегезне җибәрү',
	'prefswitch-survey-cancel-feedback' => 'Сез прототип турында фикерләрегезне җибәрә алмасагыз, $1 кайта аласыз.',
	'prefswitch-survey-question-like' => 'Сезгә яңа мөмкинчелекләрдә нәрсә ошады?',
	'prefswitch-survey-question-dislike' => 'Сезгә яңа мөмкинчелекләрдә нәрсә ошамады?',
	'prefswitch-survey-question-whyoff' => 'Сез яңа мөмкинчелекләрне нишләп сүндерәсез?
Зинһар, бөтен уңайлы вариантларны сайлагыз.',
	'prefswitch-survey-question-globaloff' => 'Сез бу мөмкинчелекләрне глобаль рәвештә ябарга телисезме?',
	'prefswitch-survey-answer-whyoff-hard' => 'Кулланырга бик авыр.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Кирәкле иттереп эшләми.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Бик әйбәт эшли.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Миңа аның тышкы кыяфәте ошамый.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Миңа аның яңа тәрәзәләре һәм төзелеше ошамады.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Миңа яңа төзәтү панеле ошамады.',
	'prefswitch-survey-answer-whyoff-other' => 'Башка сәбәп:',
	'prefswitch-survey-question-browser' => 'Сез кайсы браузерны кулланасыз?',
	'prefswitch-survey-answer-browser-other' => 'Башка браузер:',
	'prefswitch-survey-question-os' => 'Сез кайсы операцион системасын кулланасыз?',
	'prefswitch-survey-answer-os-other' => 'Башка операцион система:',
	'prefswitch-survey-answer-globaloff-yes' => 'Әйе, барлык викиларда да мөмкинчелекләрне ачарга',
	'prefswitch-survey-question-res' => 'Экраныгызның киңәйтелмәсе нинди?',
	'prefswitch-title-on' => 'Яңа мөмкинчелекләр',
	'prefswitch-title-switched-on' => 'Рәхәтләнегез!',
	'prefswitch-title-off' => 'Яңа мөмкинчелекләрне сүндерергә',
	'prefswitch-title-switched-off' => 'Рәхмәт',
	'prefswitch-title-feedback' => 'Безнең белән элемтә',
	'prefswitch-success-on' => 'Яңа мөмкинчелекләр ачылды. Сезгә ошар дип уйлыйбыз. Сез бу мөмкинчелекләрне теләсә кайсы вакытны яба аласыз, бары тик бу сылтамага гына басарга кирәк «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» .',
	'prefswitch-success-off' => 'Яңа мөмкинчелекләр ябылды. Сынап караганыгыз өчен бик зур рәхмәт. Сез бу мөмкинчелекләрне теләсә кайсы вакытны яңадан ача аласыз, бары тик бу сылтамага гына басарга кирәк «[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]» .',
	'prefswitch-success-feedback' => 'Сезнең фикер җибәрелде.',
	'prefswitch-return' => '<hr style="clear:both">
<span class="plainlinks">[$1 $2] исемле биткә кире кайту</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-tt.png|401px|]]
|-
|  Википедия интерфейсының яңа бизәлеше <small>[[Media:VectorNavigation-tt.png|(зурайту)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-tt.png|401px|]]
|-
| Бит үзгәрткечнең төп бизәлеше <small>[[Media:VectorEditorBasic-tt.png|(зурайту)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-tt.png|401px|]]
|-
| Сылтама ясау өчен диалогның яңа бизәлеше
|}
|}
«Викимедиа Фондында» сәхифәне куллану буенча махсус төркем эшли, төрле илләрдән җыелган волонтёрлар белән алар Википедия һәм башка вики-проектларны үстерүдә зур өлеш кертәләр. Хәзергесе вакытта без сезгә яңа интерфейс бизәлеше һәм яңа төрле үзгәрткеч тәкъдим итәбез. Бу үзгәртүләр гади кулланучыларның эшен җиңеләйтү өчен кулланыла һәм алдагы елда үткәрелгән [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study сорау алуга нигезләнгән]. Яңа бизәлеш һәм уңайлылык «Викимедиа Фонды»  тарафынанбик өстенлекле проект булып тора. Тулырак мәгълүматны [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/  Викимедия блогында] карый аласыз.

=== Без ниләр үзгәрттек ===
* '''Навигация.''' Без навигацияне тулысынча үзгәрттек дисәк тә була. Без аны тагын да уңайлырак һәм матуррак эшләдек. Хәзер өстә урнаштырылган кыстыргычлар сезнең ниләр эшләгәнегезне, битне яисә бәхәс битен каравыгызны мы, әллә бөтенләй дә яңа бит ясавыгызны мы тулысынча аңлатып бирә. 
* '''Үзгәртү панеле.''' Үзгәртү панелен алмаштыру нәтиҗәсендә битләрне ясау, үзгәртү тагын да тизрк һәм уңайлырак була.
* '''Сылтама ясагыч.''' Гади сылтама ясау коралы нигезендә эчке, проект эчендә урнашкан вики-битләргә, шулай ук тышкы сәхифәләргә дә ясарга мөмкин.
* '''Эзләү.''' Без эзләүдә булган ярдәмче хәбәрләрне тулыландыра төштек, болар барсы да сезнең эзләгән битне тизрәк һәм уңайлырак табу өчен эшләнде
* '''Башка яңа функцияләр.''' Яңа табын ясау коралы сезгә вивда табыннарны ясауны җиңеләйтер дип уйлыйбыз.Шулай ук хатаны эзләү һәм алмаштыру функциясен өстәдек. 
* '''Логотип.''' Без шарик-пазлның яңа бизәлешен ясадык, тулырак мәгълүмат [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Викимедия блогында].",
	'prefswitch-main-logged-changes' => "* '''«{{int:watch}}» кыстырмасы'''  хәзер йолдыз формасында.
* ''' «{{int:move}}» кыстырмасы'''  төшерелмә менюга куелган.",
	'prefswitch-main-feedback' => '=== Элемтә ===
Без сезнең фикерләрегезне ишәтебез килә. Зинһар, безнең [[$1|элемтә битенә керегез]]. Әгәрдә сезгә безнең яңа төрле программа белән тәэмин ителеш турында күбрәк беләсегез килсә  [http://usability.wikimedia.org бизәлеш проекты сәхифәсен] карагыз.',
	'prefswitch-main-anon' => '=== Ничек бар шулай кайтарырга ===
Әгәрдә сез яңа мөмкинчелекләрне ябасагыз килсә, [$1монда басыгыз]. Сезгә башта сәхифәгә керергә яисә яңадан теркәлергә тәкъдим ителәчәк.',
	'prefswitch-main-on' => '=== Яңадан кайтарыгыз! ===
Әгәрдә сез бөтен яңа мөмкинчелекләрне ябасыгыз килсә, зинһар, [$2 монда басыгыз].',
	'prefswitch-main-off' => '=== Сынап карагыз! ===
Әгәрдә сезнең яңа мөмкинчелекләрне сынап карыйсыгыз килсә, зинһар, [$1 монда басыгыз].',
	'prefswitch-survey-intro-feedback' => 'Без сезнең фикерләрегезне беләсебез килә.
Зинһар, «[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]» төймәсенә баскыйнча,  аста урнашкан сорауларга җавап бирегез.',
	'prefswitch-survey-intro-off' => "Яңа мөмкинчелекләрне сынап караганыгыз өчен бик зур рәхмәт!
Безгә аларның сыйфатын тагын да артыру өчен аста бирелгән сорауларга җавап бирегез. ''(җавап бирү мәҗбүри түгел)''
Шуннан соң «[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]»  төймәсенә баса аласыз.",
	'prefswitch-feedbackpage' => 'Project:Яңа бизәлеш турында фикерләр',
);

/** Tatar (Latin) (Татарча/Tatarça (Latin))
 * @author Don Alessandro
 * @author Ильнар
 */
$messages['tt-latn'] = array(
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-tt.png|401px|]]
|-
|  Wikipediä interfeysınıñ yaña bizäleşe <small>[[Media:VectorNavigation-tt.png|(zuraytu)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-tt.png|401px|]]
|-
| Bit üzgärtkeçneñ töp bizäleşe <small>[[Media:VectorEditorBasic-tt.png|(zuraytu)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-tt.png|401px|]]
|-
| Sıltama yasaw öçen dialognıñ yaña bizäleşe
|}
|}
«Wikimedia Fondında» säxifäne qullanu buyınça maxsus törkem eşli, törle illärdän cıyılğan volontyorlar belän alar Wikipediä häm başqa wiki-proyektlarnı üsterüdä zur öleş kertälär. Xäzergese waqıtta bez sezgä yaña interfeys bizäleşe häm yaña törle üzgärtkeç täqdim itäbez. Bu üzgärtülär ğädi qullanuçılarnıñ eşen ciñeläytü öçen qullanıla häm aldağı yılda ütkärelgän [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study soraw aluğa nigezlängän]. Yaña bizäleş häm uñaylılıq «Wikimedia Fondı»  tarafınanbik östenlekle proyekt bulıp tora. Tulıraq mäğlümatnı [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia/  Wikimediä blogında] qarıy alasız.

=== Bez nilär üzgärttek ===
* '''Nawigatsiä.''' Bez nawigatsiäne tulısınça üzgärttek disäk tä bula. Bez anı tağın da uñaylıraq häm maturraq eşlädek. Xäzer östä urnaştırılğan qıstırğıçlar sezneñ nilär eşlägänegezne, bitne yäisä bäxäs biten qarawığıznı mı, ällä bötenläy dä yaña bit yasawığıznı mı tulısınça añlatıp birä. 
* '''Üzgärtü panele.''' Üzgärtü panelen almaştıru näticäsendä bitlärne yasaw, üzgärtü tağın da tizrk häm uñaylıraq bula.
* '''Sıltama yasağıç.''' Ğädi sıltama yasaw qoralı nigezendä eçke, proyekt eçendä urnaşqan wiki-bitlärgä, şulay uq tışqı säxifälärgä dä yasarğa mömkin.
* '''Ezläw.''' Bez ezläwdä bulğan yärdämçe xäbärlärne tulılandıra töştek, bolar barsı da sezneñ ezlägän bitne tizräk häm uñaylıraq tabu öçen eşlände
* '''Başqa yaña funksiälär.''' Yaña tabın yasaw qoralı sezgä wiwda tabınnarnı yasawnı ciñeläyter dip uylıybız. Şulay uq xatanı ezläw häm almaştıru funksiäsen östädek. 
* '''Logotip.''' Bez şarik-pazlnıñ yaña bizäleşen yasadıq, tulıraq mäğlümat [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimediä blogında].",
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
 * @author Sahran
 */
$messages['ug-arab'] = array(
	'prefswitch' => 'ئىشلىتىلىشچان مايىللىق تەڭشەك ئالماشتۇرۇش',
	'prefswitch-desc' => 'ئىشلەتكۈچىلەرنىڭ مايىللىق تەڭشىكى تەڭشەشكە يول قويىدۇ',
	'prefswitch-survey-true' => 'ھەئە',
	'prefswitch-survey-false' => 'ياق',
	'prefswitch-survey-submit-off' => 'يېڭى ئىقتىدارنى ياپ',
	'prefswitch-survey-cancel-off' => 'ئەگەر يېڭى ئىقتىدارنى داۋاملىق ئىشلەتسىڭىز، $1 غا قايتسىڭىز بولىدۇ.',
	'prefswitch-survey-submit-feedback' => 'قايتۇرما تەكلىپ يوللا',
	'prefswitch-survey-cancel-feedback' => 'ئەگەر قايتۇرما تەكلىپ  تەمىنلەشنى خالىمىسىڭىز، $1 غا قايتىپ داۋاملاشتۇرۇڭ.',
	'prefswitch-survey-question-like' => 'سىز قانداق يېڭى ئىقتىدارنى ياقتۇرىسىز؟',
	'prefswitch-survey-question-dislike' => 'سىز قانداق يېڭى ئىقتىدارنى ياقتۇرمايسىز؟',
	'prefswitch-survey-question-whyoff' => 'نېمە ئۈچۈن يېڭى ئىقتىدارنى تاقايسىز؟
ماس كېلىدىغانلىرىنىڭ ھەممىسىنى تاللاڭ.',
	'prefswitch-survey-answer-whyoff-hard' => 'يېڭى ئىقتىدارنى ئىشلىتىش بەك تەس.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'يېڭى ئىقتىدار نورمال خىزمەت قىلالمىدى.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'يېڭى ئىقتىدار ئويلىغىنىمدەك ياخشى ئەمەس.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'مەن بۇنداق يېڭى ئىقتىداردىكى كۆرۈنۈشنى ياقتۇرمايمەن.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'يېڭى بەتكۈچ ۋە ئۇسلۇب جايلاشتۇرۇشنى ياقتۇرمايمەن.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'يېڭى قورال بالداقنى ياقتۇرمايمەن.',
	'prefswitch-survey-answer-whyoff-other' => ':باشقا سەۋەب',
	'prefswitch-survey-question-browser' => 'قايسى توركۆرگۈنى ئىشلىتىسىز؟',
	'prefswitch-survey-answer-browser-other' => 'باشقا توركۆرگۈ:',
	'prefswitch-survey-question-os' => 'قايسى مەشغۇلات سىستېمىسىنى ئىشلىتىسىز؟',
	'prefswitch-survey-answer-os-other' => 'باشقا مەشغۇلات سىستېمىسى:',
	'prefswitch-survey-question-res' => 'ئېكران ئېنىقلىقى قانچە؟',
	'prefswitch-title-on' => 'يېڭى ئىقتىدار',
	'prefswitch-title-switched-on' => 'ھوزۇرلىنىڭ!',
	'prefswitch-title-off' => 'يېڭى ئىقتىدارنى ياپ',
	'prefswitch-title-switched-off' => 'رەھمەت',
	'prefswitch-title-feedback' => 'قايتما ئىنكاس',
	'prefswitch-success-on' => 'يېڭى ئىقتىدار ئېچىلدى. بىز سىزنىڭ بۇ يېڭى ئىقتىدارلارنى ئىشلىتىپ ھوزۇرلىنىشىڭىزنى ئۈمىد قىلىمىز، سىز بۇ ئىقتىدارلارنى تاقىيالايسىز، پەقەت مۇشۇ بەتنىڭ ئۈستىدىكى "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" نى چەكسىڭىزلا بولىدۇ.',
	'prefswitch-success-off' => 'يېڭى ئىقتىدار تاقالدى. يېڭى ئىقتىدارنى سىنىغانلىقىڭىزغا كۆپ رەھمەت. سىز خالىغان ۋاقىتتا يېڭى ئىقتىدارلارنى ئاچالايسىز، پەقەت مۇشۇ بەتنىڭ ئۈستىدىكى "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" نى چەكسىڭىزلا بولىدۇ.',
	'prefswitch-success-feedback' => 'قايتما ئىنكاسىڭىز يوللاندى.',
	'prefswitch-return' => '<span class="plainlinks">[$1 $2]</span> غا قايت',
	'prefswitch-main-anon' => ' ===يېڭى ئىقتىدارنى ياپ===
ئەگەر يېڭى ئىقتىدارنى تاقىماقچى بولسىڭىز، [$1 بۇ جاينى چېكىپ يېڭى ئىقتىدارنى تاقاڭ]. ئاۋال تىزىمغا كىرىشىڭىز ياكى ھېساباتتىن بىرنى قۇرۇشنى سورىشى مۇمكىن.',
	'prefswitch-main-on' => '===يېڭى ئىقتىدارنى ياپ!===
[$2 بۇ جاينى چېكىپ كونا نەشرىگە قايتىڭ].',
	'prefswitch-main-off' => '===يېڭى ئىقتىدارنى سىنا!===
يېڭى ئىقتىدانرى سىنىماقچى بولسىڭىز[$1 بۇ جاي]نى چېكىڭ.',
	'prefswitch-survey-intro-feedback' => 'بىز سىزنىڭ پىكرىڭىزنى ئاڭلاشنى بەكمۇ خالايمىز.
تۆۋەندىكى تاللاشچان تەكشۈرۈشنى تولدۇرۇڭ، ئاندىن "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]"نى چېكىڭ.',
	'prefswitch-survey-intro-off' => 'يېڭى ئىقتىدارنى سىنىغانلىقىڭىزغا كۆپ رەھمەت.
بىزنىڭ بۇ يېڭى ئىقتىدارنى ياخشىلىشىمىزغا ياردەم بېرىش ئۈچۈن تۆۋەندىكى تاللاشچان تەكشۈرۈشنى تولدۇرۇپ ئاندىن "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"نى چېكىڭ.',
	'prefswitch-feedbackpage' => 'Project:ئىشلەتكۈچى تەجرىبە قايتما ئىنكاسى',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Alex Khimich
 * @author NickK
 * @author Olvin
 * @author Riwnodennyk
 * @author Тест
 */
$messages['uk'] = array(
	'prefswitch' => 'Перемикач налаштувань Ініціативи практичності',
	'prefswitch-desc' => 'Дозволяє користувачам змінювати параметри налаштувань',
	'prefswitch-link-anon' => 'Нові можливості',
	'tooltip-pt-prefswitch-link-anon' => 'Дізнайтеся про нові можливості',
	'prefswitch-link-on' => 'Зробити як було',
	'tooltip-pt-prefswitch-link-on' => 'Вимкнути нові можливості',
	'prefswitch-link-off' => 'Нові можливості',
	'tooltip-pt-prefswitch-link-off' => 'Спробуйте нові можливості',
	'prefswitch-jswarning' => "Пам'ятайте, що при зміні теми оформлення ваш [[User:$1/$2.js|$2 JavaScript]]  треба скопіювати до [[{{ns:user}}:$1/vector.js]] <!-- або [[{{ns:user}}:$1/common.js]]-->, щоб він продовжив працювати.",
	'prefswitch-csswarning' => 'Ваші [[User:$1/$2.css|власні стилі для $2]] не працюватимуть під новим оформленням. Ви можете додати власні CSS для "векторного" оформлення на [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Так',
	'prefswitch-survey-false' => 'Ні',
	'prefswitch-survey-submit-off' => 'Вимкнути нові можливості',
	'prefswitch-survey-cancel-off' => 'Якщо ви бажаєте продовжити користуватися новими можливостями, ви можете повернутися до $1.',
	'prefswitch-survey-submit-feedback' => 'Надіслати відгук',
	'prefswitch-survey-cancel-feedback' => 'Якщо ви бажаєте надіслати відгук, ви можете повернутися до $1.',
	'prefswitch-survey-question-like' => 'Що в нових можливостях вам сподобалося?',
	'prefswitch-survey-question-dislike' => 'Що в нових можливостях вам не сподобалося?',
	'prefswitch-survey-question-whyoff' => 'Чому ви відключаєте нові можливості?
Виберіть усе, що підходить.',
	'prefswitch-survey-question-globaloff' => 'Ви хочете ці можливості вимкнути глобально?',
	'prefswitch-survey-answer-whyoff-hard' => 'Нові можливості заскладні для користування.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Нові можливості не функціонуюють коректно.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Працює непередбачувано',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Мені не подобається як воно виглядає.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Мені не подобаються нові закладки та композиція.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Мені не подобається нова панель засобів.',
	'prefswitch-survey-answer-whyoff-other' => 'Інша причина:',
	'prefswitch-survey-question-browser' => 'Який веб-оглядач ви використовуєте?',
	'prefswitch-survey-answer-browser-other' => 'Інший веб-оглядач:',
	'prefswitch-survey-question-os' => 'Яку операційну систему ви використовуєте?',
	'prefswitch-survey-answer-os-other' => 'Інша операційна система:',
	'prefswitch-survey-answer-globaloff-yes' => 'Так, вимкнути ці властивості глобально, на всіх вікі.',
	'prefswitch-survey-question-res' => 'Яка роздільна здатність вашого екрана?',
	'prefswitch-title-on' => 'Нові можливості',
	'prefswitch-title-switched-on' => 'Користуйтесь!',
	'prefswitch-title-off' => 'Відключити нові можливості',
	'prefswitch-title-switched-off' => 'Дякуємо',
	'prefswitch-title-feedback' => "Зворотний зв'язок",
	'prefswitch-success-on' => 'Нові можливості ввімкнено. Сподіваємось, що Вам сподобається. Ви можете відключитися від програми в будь-який час, натиснувши на посилання "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]"  у верхній частині екрана.',
	'prefswitch-success-off' => 'Нові можливості вимкнено. Дякуємо за випробування. Ви можете повернутися до них у будь-який час, натиснувши на посилання "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]"  у верхній частині екрана.',
	'prefswitch-success-feedback' => 'Ваш відгук відправлено.',
	'prefswitch-return' => '<hr style="clear:both">
Повернутися до <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-uk.png|401px|]]
|-
| Вигляд вікна Вікіпедії в новому оформленні <small>[[Media:VectorNavigation-uk.png|(збільшити)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-uk.png|401px|]]
|-
| Вигляд вікна редагування <small>[[Media:VectorEditorBasic-uk.png|(збільшити)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-uk.png|401px|]]
|-
| Вигляд нового інтерфейсу вставлення посилань
|}
|}
Команда користувацького досвіду з фонду Вікімедіа працювала разом із добровольцями над тим, щоб зробити Ваше користування проектом простішим. Ми раді запропонувати Вам деякі поліпшення, зокрема новий вигляд та спрощення інтерфейсу редагування. Ці зміни мають на меті полегшити перші кроки нових користувачів і ґрунтуються на наших [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study випробуваннях практичності протягом останнього року]. Покращення інтерфейсу наших проектів — один із пріоритетів фонду Вікімедіа, і ми впроваджуватимемо оновлення й у майбутньому. Для більш докладної інформації відвідайте [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia блог Вікімедіа].

=== Впроваджені зміни ===
* '''Навігація.''' Ми покращили навігацію в читанні та редагуванні сторінок. Відтепер вкладки вгорі чіткіше пояснюють, Ви переглядаєте статтю або її сторінку обговорення, а також чи Ви переглядаєте, або ж редагуєте сторінку.
* '''Поліпшена панель редагування:''' Ми переробили панель редагування, аби полегшити користування нею. Відтепер, форматування сторінок стало простішим та зрозумілішим.
* '''Майстер посилань:''' Простий у використанні інструмент надає можливість додавати посилання як на інші вікі-сторінки, так і на зовнішні сайти.
* '''Поліпшений пошук:''' Ми вдосконалили пошукові підказки, аби Ви могли швидше відшукати потрібне.
* '''Інші новинки:''' Ми впровадили майстер таблиць, щоб полегшити створення таблиць, та інструмент автозаміни для поліпшення редагування сторінки.
* '''Логотип Вікіпедії:''' Ми оновили наш логотип. Довідайтесь більше у [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d блозі Вікімедіа].",
	'prefswitch-main-logged-changes' => "* '''Вкладка «{{int:watch}}»''' відтепер у формі зірки.
* '''Вкладка «{{int:move}}»''' відтепер знаходиться у випадному меню поруч з рядком пошуку.",
	'prefswitch-main-feedback' => '=== Відгуки ===
Ми раді чути їх від Вас. Будь ласка, перейдіть на [[$1|сторінку відгуків]], або ж, якщо Ви зацікавленні у покращенні програмного забезпечення, відвідайте наш [http://usability.wikimedia.org вікі-проект «usability»] для подальшої інформації.',
	'prefswitch-main-anon' => '===Зробити як було===
[$1 Натисніть тут, аби вимкнути нові можливості]. Для цього Вам потрібно ввійти або зареєструватися.',
	'prefswitch-main-on' => '===Повернути назад===
[$2 Натисніть тут, якщо бажаєте вимкнути нові можливості].',
	'prefswitch-main-off' => '===Спробуйте!===
 [$1 Клацніть тут для увімкнення нових можливостей].',
	'prefswitch-survey-intro-feedback' => 'Нам важлива Ваша думка.
Чи не могли б Ви пройти необов\'язкове опитування, перш ніж натиснете "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Дякуємо за випробування наших нових можливостей.
Аби їх удосконалити, будь ласка, заповніть форму "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
	'prefswitch-feedbackpage' => 'Project:Відгуки щодо нового оформлення',
);

/** Vèneto (Vèneto)
 * @author Candalua
 * @author Vajotwo
 */
$messages['vec'] = array(
	'prefswitch' => "Canbiamento de łe prefarense de l'inisiativa par l'usabiłità",
	'prefswitch-desc' => 'Permeti a i utenti de canbiare set de prefarense',
	'prefswitch-link-anon' => 'nove funsionałidà',
	'tooltip-pt-prefswitch-link-anon' => 'Informasion so łe nove funsionałidà',
	'prefswitch-link-on' => 'riportame indrio',
	'tooltip-pt-prefswitch-link-on' => 'Disativa łe nove funsionałidà',
	'prefswitch-link-off' => 'nove funsionałidà',
	'tooltip-pt-prefswitch-link-off' => 'Prova łe nove funsionałidà',
	'prefswitch-jswarning' => 'Tien presente che col cambiamento de la skin, el còdese [[User:$1/$2.js|JavaScript del to $2]] el dovrà vegner copià in [[{{ns:user}}:$1/vector.js]] <!-- o [[{{ns:user}}:$1/common.js]]--> par continuar a funsionar.',
	'prefswitch-csswarning' => 'I to [[User:$1/$2.css|stili personalizà par $2]] no i sarà pi aplicai. Te poli zontare CSS personalizà par vector in [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Sì',
	'prefswitch-survey-false' => 'No',
	'prefswitch-survey-submit-off' => 'Disativa łe nove funsionałidà',
	'prefswitch-survey-cancel-off' => 'Se te vui continuar ad usare łe nove funsionałidà, te pui tornare a $1.',
	'prefswitch-survey-submit-feedback' => 'Invia feedback',
	'prefswitch-survey-cancel-feedback' => 'Se no te vui fornire on feedback, te pui tornare a $1.',
	'prefswitch-survey-question-like' => 'Cossa te xè piaxuo de łe nove funsionałidà?',
	'prefswitch-survey-question-dislike' => 'Cossa no te xè piaxuo de łe nove funsionałidà?',
	'prefswitch-survey-question-whyoff' => '↓ Parché te ste disativando łe nove funsionałidà?
Se prega de sełesionare tute łe modivasion pertinenti.',
	'prefswitch-survey-question-globaloff' => 'Vuto disativare łe funsionałidà globalmente?',
	'prefswitch-survey-answer-whyoff-hard' => 'Jera tropo difisiłe da usare.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Nol funsionava coretamente.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Nol se conportava en modo coerente.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "Nol me piaxeva l'aspeto.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'No me piaxevano łe nove schede e el layout.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Nol me piaxeva ła nova bara de i strumenti.',
	'prefswitch-survey-answer-whyoff-other' => 'Altra motivassion:',
	'prefswitch-survey-question-browser' => 'Quałe browser te ste doparando?',
	'prefswitch-survey-answer-browser-other' => 'Altro browser:',
	'prefswitch-survey-question-os' => 'Quałe sistema operativo te ste doparando?',
	'prefswitch-survey-answer-os-other' => 'Altro sistema operativo:',
	'prefswitch-survey-answer-globaloff-yes' => 'Sì, disativa łe nove funsionałidà so tute łe wiki',
	'prefswitch-survey-question-res' => 'Quała xè ła risołuxion del to schermo?',
	'prefswitch-title-on' => 'Nove funsionałidà',
	'prefswitch-title-switched-on' => 'Bon divertimento!',
	'prefswitch-title-off' => 'Disativa łe nove funsionałidà',
	'prefswitch-title-switched-off' => 'Grasie',
	'prefswitch-title-feedback' => 'Feedback',
	'prefswitch-success-on' => 'Le funsionalità nove le xe intacà. Speremo che te le piasa. Te podi destacarle strucando su "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" insima a la pagina.',
	'prefswitch-success-off' => 'Le funsionalità nove le xe destacà. Grassie de verle proà. Te podi ritacarle strucando su "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" insima a la pagina.',
	'prefswitch-success-feedback' => 'El to feedback xè sta invià.',
	'prefswitch-return' => '<hr style="clear:both">
Torna a <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-it.png|401px|]]
|-
| Imagine de la nova interfacia Vector <small>[[Media:VectorNavigation-it.png|(ingrandissi)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-it.png|401px|]]
|-
| Imagine de la nova interfacia de modifica de base <small>[[Media:VectorEditorBasic-it.png|(ingrandissi)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-it.png|401px|]]
|-
| Imagine de le nove finestre par inserire colegamenti
|}
|}
Lo \"User Experience Team\" de la Fondazion Wikimedia, insieme ai volontari de la comunità, el gà laorà duro par rendare le cose pi semplisi par ti. Semo entusiasti de anunciar alcuni mejoramenti, tra cui un novo aspeto grafico e dele funzion de modifica semplificà.  Mejorar l'usabilità dei progeti wiki la xe na priorità de la Fondazion Wikimedia, e daremo altri agiornamenti in futuro. Par magiori detagli, visita el relativo articolo del [http://www.frontieredigitali.it/online/?p=1703 blog Wikimedia].
===Ecco cosa gavemo cambià===
* '''Navigazion''': Gavemo mejorà el sistema de navigazion par lezere e modificare voci. Desso, le schede ne la parte superiore de ogni voce le indica pi ciaramente se te sì drio vardar la voce o la pagina de discussione, e se te sì drio lezar o modificar na voce.
* '''Mejoramenti a la barra dei strumenti''': Gavemo riorganizà la bara dei strumenti de modifica par renderla pi semplice da usare. Desso, formatar le voci xe pi semplise e intuitivo.
* '''Procedura guidà par i link''':  Uno strumento semplise da utilizar te permete de zontar link ad altre pagine de Wikipedia e link a siti esterni.
* '''Mejoramenti a la riserca''': Gavemo mejorà i sugerimenti de la ricerca par portarte pi velocemente a la pagina che te serchi.
* '''Altre nove funzion''': Gavemo introdoto anca na procedura guidà par le tabele par rendare la so creazion pi semplise e na funzion \"cata e sostituissi\" par semplificar la modifica de le pagine.
* '''Globo-puzzle de Wikipedia''': Gavemo agiornà el globo-puzzle. Lezi altre informazion sul [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blog Wikimedia].",
	'prefswitch-main-logged-changes' => "* La '''lengueta {{int:watch}}''' desso la xe na stela.
* La '''lengueta {{int:move}}''' desso la xe nel menu a scomparsa rente la bara de riserca.",
	'prefswitch-main-feedback' => "===Comenti?===
No vedemo l'ora di saver la to opinion. Visita la nostra [[$1|pagina de feedback]] opure, se te interessa i nostri continui sforsi par mejorar la piataforma MediaWiki, visita [http://usability.wikimedia.org la wiki del progeto usabilità] par ulteriori informassion.",
	'prefswitch-main-anon' => '===Torna a la vecia interfacia===
Se te voli disativare le nove funzionalità, [$1 struca qua]. Te sarà chiesto de entrare o de creare un account.',
	'prefswitch-main-on' => '===Torna a la vecia interfacia===
[$2 Struca qua par disativare le nove funzionalità].',
	'prefswitch-main-off' => '===Pròvale===
Se te voli provar le nove funzionalità, [$1 struca qua].',
	'prefswitch-survey-intro-feedback' => 'Ne piasarìa saver la to opinion.
Par piaser conpila sto questionario prima de strucar "[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]".',
	'prefswitch-survey-intro-off' => 'Grassie de aver provà le nostre nove funsioni.
Par jutarne a mejorarle, par piaser conpila el seguente questionario facoltativo prima de strucar su "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"',
	'prefswitch-feedbackpage' => 'Project:Coordinamento/Fruibiłidà',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'prefswitch' => 'Chuyển đổi tùy chọn Sáng kiến Khả dụng',
	'prefswitch-desc' => 'Cho phép những người dùng đổi qua lại giữa các bộ tùy chọn.',
	'prefswitch-link-anon' => 'Tính năng mới',
	'tooltip-pt-prefswitch-link-anon' => 'Tìm hiểu về các tính năng mới',
	'prefswitch-link-on' => 'Đưa tôi trở lại',
	'tooltip-pt-prefswitch-link-on' => 'Tắt các tính năng mới',
	'prefswitch-link-off' => 'Tính năng mới',
	'tooltip-pt-prefswitch-link-off' => 'Hãy thử các tính năng mới',
	'prefswitch-jswarning' => 'Lưu ý rằng khi đổi qua bề ngoài mới, bạn sẽ cần phải sao chép bản [[User:$1/$2.js|JavaScript $2]] qua [[{{ns:user}}:$1/vector.js]] <!-- hoặc [[{{ns:user}}:$1/common.js]]--> để tiếp tục có hiệu lực.',
	'prefswitch-csswarning' => 'Các [[User:$1/$2.css|kiểu tùy biến $2]] sẽ không còn được áp dụng. Có thể tùy biến CSS dành cho bề ngoài Vectơ trong [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Có',
	'prefswitch-survey-false' => 'Không',
	'prefswitch-survey-submit-off' => 'Tắt các tính năng mới',
	'prefswitch-survey-cancel-off' => 'Để tiếp tục sử dụng các tính năng mới, hãy trở về $1.',
	'prefswitch-survey-submit-feedback' => 'Gửi phản hồi',
	'prefswitch-survey-cancel-feedback' => 'Nếu bạn không muốn phản hồi, bạn có thể trở lại $1.',
	'prefswitch-survey-question-like' => 'Các tính năng mới có điểm tốt nào?',
	'prefswitch-survey-question-dislike' => 'Các tính năng mới có điều nào cần sửa không?',
	'prefswitch-survey-question-whyoff' => 'Tại sao bạn lại tắt các tính năng mới?
Xin hãy chọn tất cả các ý thích hợp.',
	'prefswitch-survey-question-globaloff' => 'Bạn có muốn tắt các tính năng này trên toàn cầu không?',
	'prefswitch-survey-answer-whyoff-hard' => 'Nó khó sử dụng quá.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Nó không hoạt động tốt.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Nó không vận hành như kỳ vọng.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Tôi không thích bề ngoài của nó.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Tôi không thích những thẻ và cách trình bày mới.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Tôi không thích thanh công cụ mới.',
	'prefswitch-survey-answer-whyoff-other' => 'Lý do khác:',
	'prefswitch-survey-question-browser' => 'Bạn hay sử dụng trình duyệt nào?',
	'prefswitch-survey-answer-browser-other' => 'Trình duyệt khác:',
	'prefswitch-survey-question-os' => 'Bạn hay sử dụng hệ điều hành nào?',
	'prefswitch-survey-answer-os-other' => 'Hệ điều hành khác:',
	'prefswitch-survey-answer-globaloff-yes' => 'Có, tắt các tính năng tại tất cả các wiki',
	'prefswitch-survey-question-res' => 'Độ phân giải màn hình của bạn là bao nhiêu?',
	'prefswitch-title-on' => 'Các tính năng mới',
	'prefswitch-title-switched-on' => 'Mời thưởng thức!',
	'prefswitch-title-off' => 'Tắt các tính năng mới',
	'prefswitch-title-switched-off' => 'Cám ơn',
	'prefswitch-title-feedback' => 'Phản hồi',
	'prefswitch-success-on' => 'Mong là bạn sẽ thích sử dụng các tính năng mới vừa được bật lên. Lúc nào có thể tắt các tính năng mới dùng liên kết “[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]” ở trên cùng trang.',
	'prefswitch-success-off' => 'Cám ơn bạn đã thử các tính năng mới vừa được tắt. Lúc nào có thể bật lên các tính năng này dùng liên kết “[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]” ở trên cùng trang.',
	'prefswitch-success-feedback' => 'Phản hồi của bạn đã được gửi.',
	'prefswitch-return' => '<hr style="clear:both">
Trở về <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| Hình chụp màn hình giao diện duyệt trang mới của Wikipedia <small>[[Media:VectorNavigation-en.png|(phóng lớn)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-vi.png|401px|]]
|-
| Hình chụp màn hình giao diện sửa đổi trang cơ bản <small>[[Media:VectorEditorBasic-en.png|(phóng lớn)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-vi.png|401px|]]
|-
| Hình chụp màn hình hộp thoại mới để chèn liên kết
|}
|}

Nhóm Trải nghiệm Người dùng của Wikimedia Foundation đã làm việc cùng với các tình nguyện viên từ cộng đồng để làm cho bạn cảm thấy mọi thứ trở nên dễ dàng hơn. Chúng tôi cảm thấy háo hức muốn chia sẻ một số cải tiến, bao gồm một giao diện hoàn toàn mới và các tính năng sửa đổi đã được đơn giản hóa. Những thay đổi này dự kiến sẽ giúp những người mới dễ làm quen hơn, và được dựa trên [{{fullurle:Usability:Usability, Experience, and Evaluation Study|uselang=vi}} nghiên cứu về tính khả dụng được thực hiện năm ngoái]. Cải tiến tính khả dụng của các dự án là ưu tiên của Quỹ Wikimedia và chúng tôi sẽ chia sẻ thêm nhiều cập nhật nữa trong tương lai. Đọc thêm chi tiết tại [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia blog của Quỹ Wikimedia].

===Dưới đây là những thay đổi===
* '''Duyệt trang:''' Chúng tôi đã cải tiến việc duyệt các mục khi đọc và sửa trang. Giờ đây, các thẻ nằm ở đầu trang đã ghi một cách rõ ràng là bạn đang xem trang hay trang thảo luận, và bạn đang đọc hay đang sửa một trang.
* '''Cải tiến thanh công cụ sửa đổi:''' Chúng tôi đã sắp xếp lại thanh công cụ sửa đổi để giúp nó dễ sử dụng hơn. Giờ đây, việc định dạng trang đã đơn giản hơn và trực giác hơn.
* '''Hướng dẫn tạo liên kết:''' Một công cụ rất dễ sử dụng giúp bạn thêm liên kết đến các trang wiki khác cũng như liên kết ra các trang bên ngoài.
* '''Cải tiến tìm kiếm:''' Chúng tôi đã cải tiến những gợi ý tìm kiếm để giúp bạn tìm được trang mình muốn nhanh chóng hơn.
* '''Các tính năng mới khác:''' Chúng tôi cũng đã giới thiệu hướng dẫn tạo bảng để giúp tạo bảng dễ dàng hơn, rồi tính năng tìm kiếm và thay thế để đơn giản hóa việc sửa trang.
* '''Biểu trưng Wikipedia:''' Chúng tôi đã cập nhật biểu trưng của chúng ta. Đọc thêm chi tiết tại [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d/ blog của Quỹ Wikimedia].",
	'prefswitch-main-logged-changes' => "* '''Thẻ {{int:watch}}''' trở thành hình sao.
* '''Thẻ {{int:move}}''' nằm trong trình đơn bên cạnh hộp tìm kiếm.",
	'prefswitch-main-feedback' => '===Phản hồi?===
Chúng tôi muốn nghe lời phản hồi từ bạn. Xin mời xem [[$1|trang phản hồi]] của chúng tôi hoặc, nếu bạn thích thú với những nỗ lực sắp tới để cải tiến phần mềm, xin mời xem [{{fullurle:Usability:|uselang=vi}} wiki khả dụng] để biết thêm thông tin.',
	'prefswitch-main-anon' => '===Đưa tôi trở lại===
Bạn có thể [$1 tắt các tính năng mới]. Bạn sẽ cần phải mở tài khoản hay đăng nhập trước tiên.',
	'prefswitch-main-on' => '===Đưa tôi trở lại!===
[$2 Nhấn vào đây để tắt các tính năng mới].',
	'prefswitch-main-off' => '===Dùng thử!===
Nếu bạn muốn bật các tính năng mới, xin [$1 nhấn vào đây].',
	'prefswitch-survey-intro-feedback' => 'Chúng tôi mong muốn được nghe bạn nói.
Xin vui lòng điền vào bảng điều tra phía dưới trước khi bấm “[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]”.',
	'prefswitch-survey-intro-off' => 'Cảm ơn bạn đã dùng thử những tính năng mới của chúng tôi.
Để giúp chúng tôi cải tiến chúng hơn nữa, xin vui lòng điền vào bảng điều tra phía dưới trước khi bấm “[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]”.',
	'prefswitch-feedbackpage' => 'Project:Phản hồi trải nghiệm của người dùng',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'prefswitch-survey-true' => 'Si!',
	'prefswitch-survey-false' => 'Nö!',
	'prefswitch-survey-answer-whyoff-other' => 'Kod votik:',
	'prefswitch-title-switched-on' => 'Fredolös!',
	'prefswitch-title-switched-off' => 'Danö!',
);

/** Walloon (Walon)
 * @author Lucyin
 */
$messages['wa'] = array(
	'prefswitch-title-on' => 'Novea prezintaedje',
	'prefswitch-title-off' => 'Diclitchî li novea prezintaedje',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'prefswitch' => 'ניצלעכקייט איניציאַטיוו פרעפֿערענץ איבערבײַט',
	'prefswitch-desc' => 'לאָזן באַניצער  איבערבײַטן גרופעס פון פרעפֿערענצן',
	'prefswitch-link-anon' => 'נײַע אייגנשאַפֿטן',
	'tooltip-pt-prefswitch-link-anon' => 'לערנען וועגן נײַע אייגנקייטן',
	'prefswitch-link-on' => 'פֿירט מיך צוריק',
	'tooltip-pt-prefswitch-link-on' => 'אַנולירן נײַע אייגנקייטן',
	'prefswitch-link-off' => 'נײַע אייגנשאַפֿטן',
	'tooltip-pt-prefswitch-link-off' => 'פרובירן נײַע אייגנקייטן',
	'prefswitch-jswarning' => 'געדענקט אז, מיט דער געשטעל ענדערונג, אײַער [[User:$1/$2.js|$2 JavaScript]] דאַרף מען קאפירן צו [[{{ns:user}}:$1/vector.js]] <!-- אדער [[{{ns:user}}:$1/common.js]]--> צו פֿונקציאנירן ווײַטער.',
	'prefswitch-csswarning' => 'אײַערע [[User:$1/$2.css|פערזענלעכע $2 סטילן]] ווערן מער נישט אויסגעפֿירט. איר קענט צושטעלן פערזענלעכן CSS פֿאַר "וועקטאר" אין [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'יא',
	'prefswitch-survey-false' => 'ניין',
	'prefswitch-survey-submit-off' => 'אַנולירן נײַע אייגנקייטן',
	'prefswitch-survey-cancel-off' => 'ווען איר ווילט ווײַטער ניצן די נײַע אייגנקייטן, קענט איר צוריקקערן צו $1.',
	'prefswitch-survey-submit-feedback' => 'שיקן פֿידבעק',
	'prefswitch-survey-cancel-feedback' => 'ווען איר ווילט נישט געבן קיין פֿידבעק, קענט איר צוריקקערן צו $1.',
	'prefswitch-survey-question-like' => 'וואָס האט אײַך געפֿאלן בײַ די נײַע אייגנקייטן?',
	'prefswitch-survey-question-dislike' => 'וואָס האט אײַך נישט געפֿאלן בײַ די נײַע אייגנקייטן?',
	'prefswitch-survey-question-whyoff' => 'פֿאַרוואָס לאזט איר איבער די נײַע אייגנקייטן?
ביטע וויילט אויס אַלע פאַסיגע פונקטן.',
	'prefswitch-survey-answer-whyoff-hard' => 'די אייגנקייטן זענען געווען צו שווער צו ניצן.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'די אייגנקייטן האבן נישט פֿונקציאָנירט געהעריג..',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'עס פֿונקציאנירט אויף א נישט פֿאראויסגעזענעם אופן.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => "ס'האט מיר נישט געפֿאלן ווי די אייגנקייטן זען אויס.",
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'די נײַע טאַבן און צעשטעל האבן מיר נישט געפֿאלן.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'דער נײַער ווערקצייגפאַס האט מיר נישט געפֿאלן.',
	'prefswitch-survey-answer-whyoff-other' => 'אַנדער טעם:',
	'prefswitch-survey-question-browser' => 'וועלכן בלעטערער ניצט איר?',
	'prefswitch-survey-answer-browser-other' => 'אנדער בלעטערער:',
	'prefswitch-survey-question-os' => 'וועלכע אפערירן סיסטעם ניצט איר?',
	'prefswitch-survey-answer-os-other' => 'אנדער אפערירן סיסטעם:',
	'prefswitch-survey-question-res' => 'וואָס איז די רעזאלוציע פֿון אײַער עקראַן?',
	'prefswitch-title-on' => 'נײַע אייגנשאַפֿטן',
	'prefswitch-title-switched-on' => 'האט הנאה!',
	'prefswitch-title-off' => 'אַנולירן נײַע אייגנקייטן',
	'prefswitch-title-switched-off' => 'א דאַנק',
	'prefswitch-title-feedback' => 'פֿידבעק',
	'prefswitch-success-on' => 'די נײַע אייגנקייטן זענען איצט אַקטיוו. מיר האָפן איר וועט האָבן הנאה פֿון ניצן די נײַע אייגנקייטן. איר קענט שטענדיק צוריקווענדן דורך געבן אַ קליק אויף דעם "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]" לינק אין דער הייך פונעם בלאַט.',
	'prefswitch-success-off' => 'די נײַע אייגנקייטן זענען מער נישט אַקטיוו. א דאַנק פֿארן אויספרובירן די נײַע אייגנקייטן. איר קענט זיי שטענדיק צוריקאַקטיוויזירן דורך געבן אַ קליק אויף דעם "[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]" לינק אין דער הייך פונעם בלאַט.',
	'prefswitch-success-feedback' => "מ'האט געשיקט אײַער פֿידבעק.",
	'prefswitch-return' => '<hr style="clear:both">
צוריק צו <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"left\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| עקראַנבילד פֿון וויקיפעדיע'ס נײַעם נאַוויגאַציע איבערפֿלאַך <small>[[Media:VectorNavigation-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| עקראַנבילד פֿונעם איינפֿאַכן באַאַרבעטן איבערפֿלאַך <small>[[Media:VectorEditorBasic-en.png|(enlarge)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| עקראַנבילד פֿונעם נײַעם דיאַלאג קעסטל פֿאר ארײַנגעבן לינקען
|}
|}
די באַניצער דערפֿאַרונגס גרופע פון דער וויקימעדיע פֿונדאַציע האט געאַרבעט צו מאַכן דעם ניץ גרינגער. מיר פֿרייען זיך צו טיילן זיך מיט עטלעכע פֿאַרבעסערונגען, כולל א נײַע אויסקוק און און מער איינפֿאַכער רעדאַקטירן אייגנקייטן. מיט די ענדערונגען זאל זײַן גרינגער פֿאר נײַע באַניצער אנצוהייבן; זיי זענען באַזירט אויף אונזער [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study ניצלעכקייט פרואוואונגען דאס פֿאריגע יאָר]. פֿאַרבעסערן די ניצלעכקייט פֿון אונזערע פראיעקטן איז א פריאריטעט פֿון דער וויקימעדיע פֿונדאַציע און מיר וועלן טיילן מיט נאך דערהײַנטיקונגען אין דער צוקונפֿט. פֿאַר נאך פרטים, באַזוכט דעם [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia וויקימעדיע בלאג].

=== וואָס מיר האבן געענדערט ===
* '''נאַוויגאַציע:''' מיר האבן פֿאַרבעסערט די נאַוויגאַציע פֿאַר ליינען און רעדאַקטירן בלעטער. אַצינד, די טאַבן אין דער הייך פֿון יעדן בלאַט  ווײַזן קלאָרער צי איר באקוקט דעם בלאַט אדער דעם שמועס בלאַט, און צי איר ליינט אדער רעדאַקטירט א בלאַט.
* '''געצייג פֿאַרבעסערונגען:''' מיר האבן ארגאָניזירט דעם רעדאַקטירונג געצייג־פאַס צו ווערן גרינגער צו ניצן. פֿארמאַטירן בלעטער איז געווארן גרינגער און מער אינטואיטיוו.
* '''לינק קונצן־מאַכער:''' א גרינג צו ניצן געצייג העלפֿט אייך צולייגן לינקען סײַ צו אַנדערע וויקי בלעטער סײַ צו דרויסנדע זײַטלעך.
* '''זוך פֿאַרבעסערונגען:''' מיר האבן פֿאַרבעסערט די זוך פֿארשלאָגן אָז איר זאלט צוקומען צום געזוכטן בלאַט גיכער.
* '''אַנדערע נײַע אייגנקייטן:''' מיר האבן אויך דערמעגלעכט א טאַבעלע קונצן־מאַכער צו מאַכן גרינגער שאַפֿן טאַבעלעס, און א זוך און פֿאַרבײַט אייגנקייט צו מאַכן מער איינפֿאַך רעדאַקטירן בלעטער.
* '''וויקיפעדיע לאגא:''' מיר האבן דערהײַנטיגט אונזער לאגא. ליינט ווײַטער אין דעם [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d וויקימעדיע בלאג].",
	'prefswitch-main-logged-changes' => "* דער '''{{int:watch}} טאַב''' איז אַצינד א שטערן.
* דער '''{{int:move}} טאַב''' איז אַצינד אין דעם אַראָפלאז־צינגל לעבן דעם זוכפאַס.",
	'prefswitch-main-feedback' => '===פֿידבעק?===
מיר ווילן גערן הערן פֿון אײַך. זײַט אזוי גוט באַזוכט אונזער [[$1|פֿידבעק בלאַט]] אדער, ווען עס אינטרעסירט  אײַך אונזערע אָנגייענדיקע אָנשטרענגונגען צו פֿאַרבעסערן דאָס ווייכוואַרג, באַזוכט אונזער [http://usability.wikimedia.org נוצבאַרקייט וויקי] פֿאַר נאך אינפֿארמאַציע.',
	'prefswitch-main-anon' => '=== פֿירט מיך צוריק ===
כדי אָפווענדן די נייע אייגנקייטן [$1 קליקט דאָ]. מען וועט אײַך ערשט בעטן אַרײַנלאָגירן אָדער שאַפֿן אַ נײַע קאנטע.',
	'prefswitch-main-on' => '=== ברענגט מיך צוריק! ===
[$2 קליקט דאָ אויסצולעשן די נײַע אייגנקייטן].',
	'prefswitch-main-off' => '=== פּרואווט אויס! ===
 [$1 דריקט דאָ כדי אַקטיווירן די נײַע אייגנקייטן].',
	'prefswitch-survey-intro-off' => 'א דאַנק פֿאַרן אויספרובירן אונזערע נײַע אייגנקייטן.
בכדי צו העלפֿן אונז פֿאַרבעסערן זיי, זײַט אזוי גוט אויספֿילן דעם אפציאנאַלן אומפֿרעג אונטער איידער איר קליקט "[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]".',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'prefswitch' => 'Ìyípadà ìfẹ́ràn Ìṣeémúlò Abẹ̀rẹ̀fúnraẹni',
	'prefswitch-desc' => 'Gbàyè àwọn oníṣe láti ṣèyípadà àwọn ìṣètò àwọn ìfẹ́ràn',
	'prefswitch-link-anon' => 'Àwọn ìní tuntun',
	'tooltip-pt-prefswitch-link-anon' => 'Mọ̀ nípa àwọn ìní tuntun',
	'prefswitch-link-on' => 'Dá mi padà',
	'tooltip-pt-prefswitch-link-on' => 'Ìdẹ́kun àwọn ìní tuntun',
	'prefswitch-link-off' => 'Àwọn ìní tuntun',
	'tooltip-pt-prefswitch-link-off' => 'Ẹ ṣàdánwò àwọn ìní tuntun',
	'prefswitch-jswarning' => 'Ẹrántí pé pẹ̀lú ìyípadà àwọ̀ ìwojú, [[User:$1/$2.js|JavaScript $2]] yín gbódọ̀ jẹ́ wíwòkọ sí [[{{ns:user}}:$1/vector.js]] <!-- tàbí [[{{ns:user}}:$1/common.js]]--> kó lè baà tẹ̀síwájú ní ṣiṣẹ́.',
	'prefswitch-csswarning' => '[[User:$1/$2.css|Àwọn ọ̀nà atòbáramu $2]] yín kò ní ṣiṣé mọ́. Ẹ le ṣàfikún CSS atòbáramu fún vector nínú [[{{ns:user}}:$1/vector.css]].

Your [[User:$1/$2.css|custom $2 styles]] will no longer be applied. You can add custom CSS for vector in [[{{ns:user}}:$1/vector.css]].',
	'prefswitch-survey-true' => 'Bẹ́ẹ̀ni',
	'prefswitch-survey-false' => 'Bẹ́ẹ̀kọ́',
	'prefswitch-survey-submit-off' => 'Ẹ dẹ́kun àwọn ìní tuntun',
	'prefswitch-survey-cancel-off' => 'Tí ẹ bá fẹ́ tẹ̀síwájú ní lílo àwọn ìní tuntun, ẹ lè padà sí $1.',
	'prefswitch-survey-submit-feedback' => 'Ẹ fi ìdáhun ránṣẹ́',
	'prefswitch-survey-cancel-feedback' => 'Tí ẹ kò bá fẹ́ pèsè ìdáhùn, ẹ lè padà sí $1.',
	'prefswitch-survey-question-like' => 'Kíni ẹ fẹ́ràn nípa àwọn ìní tuntun?',
	'prefswitch-survey-question-dislike' => 'Kíni ẹ kò fẹ́ràn nípa àwọn ìní tuntun náà?',
	'prefswitch-survey-question-whyoff' => 'Kílódé tí ẹ úndẹ́kun àwọn ìní tuntun?
Ẹ jọ̀wọ́ ẹ mú èyí tó yẹ.',
	'prefswitch-survey-answer-whyoff-hard' => 'Àwọn ìní náà ṣòro láti lò.',
	'prefswitch-survey-answer-whyoff-didntwork' => 'Àwọn ìní náà kò ṣiṣẹ́ dáadáa.',
	'prefswitch-survey-answer-whyoff-notpredictable' => 'Àwọn ìní náà kò ṣiṣẹ́ bó ṣe yẹ.',
	'prefswitch-survey-answer-whyoff-didntlike-look' => 'Un kò fẹ́ràn bí àwọn ìní náà ṣe rí.',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => 'Un kò fẹ́ràn àwọn ìpele àti ìlàkalẹ̀ tuntun náà.',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => 'Un kò fẹ́ràn pẹpẹ irinṣẹ́ tuntun náà.',
	'prefswitch-survey-answer-whyoff-other' => 'Ìdíẹ̀ míràn:',
	'prefswitch-survey-question-browser' => 'Agbétakùn wo ni ẹ únlò?',
	'prefswitch-survey-answer-browser-other' => 'Agbétakùn míràn:',
	'prefswitch-survey-question-os' => 'Sístẹ̀mù ìṣiṣẹ́ kọ̀mpútà wo ni ẹ únlò?',
	'prefswitch-survey-answer-os-other' => 'Sístẹ̀mù ìṣiṣẹ́ kọ̀mpútà mìràn:',
	'prefswitch-survey-question-res' => 'Kíni iye ìgbéhàn ẹ̀rọ ojúìran yín?',
	'prefswitch-title-on' => 'Àwọn ìní tuntun',
	'prefswitch-title-switched-on' => 'Ẹ kúùgbádùn!',
	'prefswitch-title-off' => 'Ẹ dẹ́kun àwọn ìní tuntun',
	'prefswitch-title-switched-off' => 'A dúpẹ́',
	'prefswitch-title-feedback' => 'Ìdáhùn',
	'prefswitch-success-feedback' => 'Ìdáhùn yín ti jẹ́ fífiránṣẹ́.',
	'prefswitch-return' => '<hr style="clear:both">
Ẹ padà sí <span class="plainlinks">[$1 $2]</span>.',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-yo.png|401px|]]
|-
| Àwọrán ojúìran ìtọ́ka ìfojúkojú Wikipedia tuntun <small>[[Media:VectorNavigation-en.png|(nígbàngbà)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-yo.png|401px|]]
|-
| Àwọrán ojúìran ìfojúkojú àtúnṣe ojúewé <small>[[Media:VectorEditorBasic-en.png|(nígbàngbà)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-yo.png|401px|]]
|-
| Àwọrán ojúìran pátákó àkíyèsí tuntun fún àwọn ìjápọ̀
|}
|}
Ẹgbẹ́ Ìrírí Oníṣe Wikimedia Foundation ti únṣiṣẹ́ pẹ̀lú àwọn afìfẹ́ṣe láti àgbàjọ láti múu dẹ̀rọ̀ fun yín. Inú wa dùn láti fún yín ní àwọn ìmúdára wọ̀nyí bíì iwojú àti ìṣiṣẹ́ tuntun àti àwọn ìní àtúnṣe ṣíṣọdẹ̀rọ̀. Àwọn ìyípadà tuntun wọ̀nyí wáyé láti jẹ́ kí ó dẹ̀rọ̀ fún àwọn olùfikún tuntun láti bẹ̀rẹ̀, wọ́n sì jẹ́ lórí [http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study ìdánwò ìṣeémúlò wa tó wáyé ní ọdún tó kọjá]. Mímúdára ìseémúlò àwọn iṣẹ́-ọwọ́ wa ni ohun tó jẹ Wikimedia Foundation lógún bẹ́ẹ̀sìni a ó fun yín nk ọ̀pọ̀ àwọn ìṣọdọ̀tun lọ́jọ́ iwíjú. Fún àwọn ẹ̀kúnrẹ́rẹ́, ẹ ṣèbẹ̀wò sí [http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia àgbéjade blog] Wikimedia tó yẹ.

=== Àwọn àtúnṣe tó wáyé nìyí ===
* '''Ìtọ́ka:''' A ti ṣèmúdára ìtọ́ka fún kíkà àti títúnṣe àwọn ojúewé. Nísinyìí, àwọn ìpele lórí ojúewé kọ̀ọ̀kan fihàn kedere dáadáa bóyá ẹ únwo ojúewé òhún tàbí ojúewé ìfọ̀rọ̀wérọ̀ rẹ̀, àti bóyá ẹ ùnkà tàbí ẹ ùnṣàtúnṣe ojúewé náá.
* '''Àwọn ìmúdára ìpele irinṣẹ́ ìṣàtúnṣe:''' A ti ṣàtúngbájọ ìpele irinṣẹ́ ìṣàtúnṣe láti jẹ́ kó rorùn fún lílò. Nísinyìí, Ìṣèdá àwọn ojúewé ti dẹ̀rọ̀ ó sì lóye.
* '''Olùrànwọ́ ìjápọ̀:''' Irinṣẹ́ tó dẹ́rọ̀ láti lò úngbàyín láyè láti ṣàfikún ìjápọ̀ sí àwọn ojúewé wiki míràn àti bákannáà ìjápọ̀ sí àwọn ibi ìtakùn òde.
* '''Àwọn ìmúdára ìṣàwárí:''' A ti ṣàmúdára àwọn ìmọ̀ràn ìṣàwárí láti mú yín lọ sí ojúewé tí ẹ únwá kíákíá.
* '''Àwọn ìní tuntun míràn:''' A tún ti ṣe olùránwọ́ tábìlì láti mú dídá tábìlì dẹ̀rọ̀ àti ọ̀nà síṣèrọ́pọ̀ nínú àtúnṣe ojúewé.
* '''Àmì-iléiṣẹ́ Wikipedia:''' A ti ṣọdọ̀tun àmì-iléiṣẹ́ wa. Ẹ kà nípa rẹ̀ lórí [http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d blog Wikimedia].",
	'prefswitch-main-logged-changes' => "* '''Ìpele {{int:watch}}''' nísìnyí jẹ́ ìràwọ̀.
* '''Ìpele {{int:move}}''' nísìnyí wà nínú ìsílọlẹ̀ lẹ́gbẹ pẹpẹ àwárí.",
	'prefswitch-main-feedback' => '==Ṣé ẹ ní ìdáhùn?==
A fẹ́ràn láti mọ èrò yín. Ẹ jọ̀wọ́ ẹ ṣàbẹ̀wò sí [[$1|ojúewé ìdáhùn]] wa, tàbí tó bá jẹ́ pé ipá wa láti sàmúdára atòlànà kọ́mpútà wùyín, ẹ ṣàbẹ̀wò sí [http://usability.wikimedia.org wiki ìṣeémúlò] fún ìfitọ́nilétí lẹ́kùúnrẹ́rẹ́.',
	'prefswitch-main-anon' => '===Gbé mi padà sẹ́yìn===
[$1 Ẹ tẹ klik síbí láti jáwọ́ àwọn ìní tuntun]. A ó bèrè lọ́wọ́ yín pé kí ẹ wọlé ná tàbí kí ẹ dá àpamọ́.',
	'prefswitch-main-on' => '===Gbé mi padà sẹ́yìn!===
[$2 Ẹ tẹ klik síbí láti jáwọ́ àwọn ìní tuntun].',
	'prefswitch-main-off' => '===Ẹ dán wọn wò!===
[$1 Ẹ tẹ klik síbí látí lo àwọn ìní tuntun].',
	'prefswitch-feedbackpage' => 'Project:Ìdáhùn ìrírí oníṣe',
);

/** Cantonese (粵語)
 * @author Horacewai2
 */
$messages['yue'] = array(
	'prefswitch' => '可用性倡議喜好轉用',
	'prefswitch-desc' => '容許用戶去設定喜好',
	'prefswitch-link-anon' => '新特色',
	'tooltip-pt-prefswitch-link-anon' => '知多啲關於新特色',
	'prefswitch-link-on' => '帶我返去',
	'tooltip-pt-prefswitch-link-on' => '停用新特色',
	'prefswitch-link-off' => '新特色',
	'tooltip-pt-prefswitch-link-off' => '試吓新特色',
	'prefswitch-jswarning' => '請記得改左面板，你嘅[[User:$1/$2.js|$2 JavaScript]]需要複製到[[{{ns:user}}:$1/vector.js]] <!--或者[[{{ns:user}}:$1/common.js]]-->去繼續工作。',
	'prefswitch-csswarning' => '你的[[User:$1/$2.css|自訂$2款式]]不再通用。你可以係[[{{ns:user}}:$1/vector.css]]加對Vector的自訂款式。',
	'prefswitch-survey-true' => '係',
	'prefswitch-survey-false' => '唔係',
	'prefswitch-survey-submit-off' => '閂新特色',
	'prefswitch-survey-cancel-off' => '如果你繼續去用新特色，你可以返去$1。',
	'prefswitch-survey-submit-feedback' => '傳送意見',
	'prefswitch-survey-cancel-feedback' => '如果你唔想提供意見，你可以返去$1。',
	'prefswitch-survey-question-like' => '你喜歡新特色啲咩？',
	'prefswitch-survey-question-dislike' => '你唔鍾意啲咩新特色？',
	'prefswitch-survey-question-whyoff' => '你點解要閂咗個新特色？
選擇所有你用到嘅選項。',
	'prefswitch-survey-answer-whyoff-hard' => '新特色好難用。',
	'prefswitch-survey-answer-whyoff-didntwork' => '新特色唔能夠正常去做野。',
	'prefswitch-survey-answer-whyoff-notpredictable' => '新功能無我預期好。',
	'prefswitch-survey-answer-whyoff-didntlike-look' => '唔鐘意新功能個樣。',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => '我唔鍾意個新標籤同埋排版。',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => '我唔鍾意條新工具列。',
	'prefswitch-survey-answer-whyoff-other' => '其它原因：',
	'prefswitch-survey-question-browser' => '你用咩瀏覽器？',
	'prefswitch-survey-answer-browser-other' => '其它瀏覽器：',
	'prefswitch-survey-question-os' => '你用邊套操作系統？',
	'prefswitch-survey-answer-os-other' => '其它操作系統：',
	'prefswitch-survey-question-res' => '你個螢光幕嘅解像度有幾大？',
	'prefswitch-title-on' => '新特色',
	'prefswitch-title-switched-on' => '享受使用新特色！',
	'prefswitch-title-off' => '閂個新特色',
	'prefswitch-title-switched-off' => '多謝',
	'prefswitch-title-feedback' => '意見',
	'prefswitch-success-on' => '而家新特色已經啟用咗，我地希望你享受使用呢啲新特色。你可以撳"[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]"用舊版。',
	'prefswitch-success-off' => '而家新特色已經閂咗，多謝你試用。你可以撳"[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]"用新版。',
	'prefswitch-success-feedback' => '你嘅意見已經發送咗。',
	'prefswitch-return' => '<hr style="clear:both">
番去<span class="plainlinks">[$1 $2]</span>。',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| 維基百科新嘅導航界面嘅截圖 <small>[[Media:VectorNavigation-en.png|(放大)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| 基本編輯界面嘅截圖 <small>[[Media:VectorEditorBasic-en.png|(放大)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| 插入連結對話盒嘅截圖
|}
|}

Wikimedia Foundation嘅可用性小組同社群嘅志願者一齊係列努力令你更方便去用。我哋好高興能夠分享一啲嘅改進，包括一個全新嘅外觀同簡化嘅編輯功能。呢啲變化都係為咗俾新嘅參與者更容易進行貢獻，同時我哋[http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study 響過去一年裏面進行咗大量嘅可用性測試]。改進我哋計劃嘅可用性係Wikimedia Foundation嘅重要目標，而我哋將係未來分享更多嘅更新。想知多啲，睇吓相關嘅Wikimedia[http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia Blog貼文]。

=== 我哋有啲乜嘢改咗 ===

* '''導航'''：我哋已經改善咗閱讀同編輯版嗰陣嘅導航。而家，每一版頂部上嘅標籤更加明確噉去界定你係響度閱讀內容版定係討論版，同埋你係響度閱讀緊定係改緊一版。
* '''編輯工具吧嘅改進'''：我哋已經重組咗編輯工具吧更加容易噉去用。而家，格式化網頁更加簡單同更加直觀。
* '''連結精靈'''：一個簡易使用嘅工具可以畀你加入連結到其它wiki版以及連出去外面嘅網站。
* '''搵嘢嘅改進'''：我哋改進咗搜索建議令到你可以更加快噉搵到你要用到嘅版。
* '''其它嘅新功能'''：我哋亦都推出了表格精靈去更加容易噉開表，同時搵換嘅功能來簡化嗰版嘅編輯。
* '''維基百科logo'''：我哋已經更新咗我哋個logo。詳情睇[http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog]。",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}}標籤'''而家係一粒星星。
* '''{{int:move}}標籤'''而家係一個係搜索框左邊嘅下拉式選單。",
	'prefswitch-main-feedback' => '===意見？===

我哋希望收到你的意見，請睇吓我哋嘅[[$1|意見反饋版]]，或者如果你對我哋嘅軟件改進有興趣嘅話，可以到[http://usability.wikimedia.org usability wiki]了解更多嘅詳情。',
	'prefswitch-main-anon' => '===帶我返去===
[$1 撳呢度閂咗啲新功能]。你將會有提示，需要先登入或者開戶口。',
	'prefswitch-main-on' => '===帶我返去！===
[$2 撳呢度閂咗啲新功能]。',
	'prefswitch-main-off' => '===試吓佢哋！===
[$1 撳呢度開咗啲新功能]。',
	'prefswitch-survey-intro-feedback' => '我哋希望收到你嘅意見。
請喺撳"[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]"之前做一個可選嘅問卷調查。',
	'prefswitch-survey-intro-off' => '多謝試用我哋嘅新特色。
為咗幫助我地改進佢哋，我哋希望你撳"[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"之前做一個可選嘅問卷調查。',
	'prefswitch-feedbackpage' => 'Project:用戶意見',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author Onecountry
 * @author Xiaomingyan
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'prefswitch' => '可用性倡议偏好设定',
	'prefswitch-desc' => '允许用户设定参数设定',
	'prefswitch-link-anon' => '新功能',
	'tooltip-pt-prefswitch-link-anon' => '了解更多新功能',
	'prefswitch-link-on' => '回到旧版',
	'tooltip-pt-prefswitch-link-on' => '禁用新功能',
	'prefswitch-link-off' => '新功能',
	'tooltip-pt-prefswitch-link-off' => '尝试新功能',
	'prefswitch-jswarning' => '请记住此对皮肤的变化，你[[User:$1/$2.js|$2的JavaScript]]将需要复制到[[{{ns:user}}:$1/vector.js]] <!--或 [[{{ns:user}}:$1/common.js]]-->才能继续有效。',
	'prefswitch-csswarning' => '您的 [[User:$1/$2.css|custom $2 styles]] 将不再适用。在此版本中您可以在 [[{{ns:user}}:$1/vector.css]] 添加自定义CSS。',
	'prefswitch-survey-true' => '是',
	'prefswitch-survey-false' => '否',
	'prefswitch-survey-submit-off' => '关闭新功能',
	'prefswitch-survey-cancel-off' => '如果您想继续使用新功能，您可以返回$1。',
	'prefswitch-survey-submit-feedback' => '发送反馈',
	'prefswitch-survey-cancel-feedback' => '如果你不想提供反馈，你可以回到$1继续。',
	'prefswitch-survey-question-like' => '你喜欢什么新特点？',
	'prefswitch-survey-question-dislike' => '你不喜欢什么特点？',
	'prefswitch-survey-question-whyoff' => '你为什么关闭新的功能？请选择所有适用的选择。',
	'prefswitch-survey-answer-whyoff-hard' => '新特点很难去使用。',
	'prefswitch-survey-answer-whyoff-didntwork' => '新特色无法正常工作。',
	'prefswitch-survey-answer-whyoff-notpredictable' => '新特点不及我预期的好。',
	'prefswitch-survey-answer-whyoff-didntlike-look' => '我不喜欢这些新特点的外观。',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => '我不喜欢它的新标签以及排版。',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => '我不喜欢它的新工具列。',
	'prefswitch-survey-answer-whyoff-other' => '其他原因：',
	'prefswitch-survey-question-browser' => '您用哪款浏览器？',
	'prefswitch-survey-answer-browser-cb' => '谷歌浏览器Beta',
	'prefswitch-survey-answer-browser-c1' => '谷歌浏览器1',
	'prefswitch-survey-answer-browser-c2' => '谷歌浏览器2',
	'prefswitch-survey-answer-browser-c3' => '谷歌浏览器3',
	'prefswitch-survey-answer-browser-c4' => '谷歌浏览器4',
	'prefswitch-survey-answer-browser-c5' => '谷歌浏览器5',
	'prefswitch-survey-answer-browser-other' => '其它浏览器：',
	'prefswitch-survey-question-os' => '您用哪套操作系统？',
	'prefswitch-survey-answer-os-other' => '其它操作系统：',
	'prefswitch-survey-question-res' => '您的屏幕解像度之大小有多大？',
	'prefswitch-title-on' => '新功能',
	'prefswitch-title-switched-on' => '享受！',
	'prefswitch-title-off' => '关闭新功能',
	'prefswitch-title-switched-off' => '谢谢',
	'prefswitch-title-feedback' => '反馈',
	'prefswitch-success-on' => '新功能已经打开了。我们希望你能享受使用这些新功能，你可以关闭这些新功能，只需要按本页页顶的[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]便可以了。',
	'prefswitch-success-off' => '新功能已经关闭。感谢你的试用，你可以随时开启这些新功能，只需要按本页页顶的[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]便可以了。',
	'prefswitch-success-feedback' => '您的反馈已发送。',
	'prefswitch-return' => '<hr style="clear:both">
返回<span class="plainlinks">[$1 $2]</span>。',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| 维基百科新的导航界面的截图 <small>[[Media:VectorNavigation-en.png|(放大)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| 基本编辑界面的截图 <small>[[Media:VectorEditorBasic-en.png|(放大)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| 插入链接对话框的截图
|}
|}

维基媒体基金会的用户体验团队同社群的志愿者一起在努力令你更方便的使用。我们很高兴能够分享一些改进，包括一个全新的外观和简化的编辑功能。这些变化都是为了让新的参与者更容易进行贡献，同时我们[http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study 在过去一年里进行了大量的可用性测试]。提高我们项目的可用性是维基媒体基金会的重要目标，我们将在未来分享更多的更新。欲了解更多详情，请访问相关的维基媒体[http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia 博客上的帖子]。

=== 下面是我们的改变 ===

* '''导航'''：我们已经改善了阅读和编辑网页时的导航。现在，每一页顶部上的标签更明确地界定你是正在查看页面还是讨论页，以及你是否正在阅读或编辑一个页面。
* '''编辑工具栏上的改善'''：我们已经重组了编辑工具栏，以便于更容易使用。现在，格式化网页更简单，更直观。
* '''链接向导'''：一个易于使用的工具可以让你添加链接到其他维基页面以及链接到外部网站。
* '''搜索的改进'''：我们改进了搜索建议，让你寻找网页更迅速。
* '''其他的新功能'''：我们也推出了表格向导，使创建表格更容易，同时寻找和替换功能来简化页面的编辑。
* '''维基百科logo'''：我们已经更新了我们的logo。详情见[http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog]。",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}} 标签''' 现在是一颗星。
* '''{{int:move}} 标签''' 现在是在搜索框旁边的下拉菜单中。",
	'prefswitch-main-feedback' => '===意见?===

我们希望收到你们的意见，请造访我们的[[$1|意见反馈页面]]，或者如果你对我们的软件改善有兴趣，可到[http://usability.wikimedia.org usability wiki]了解详情。',
	'prefswitch-main-anon' => '=== 取消新功能 ===
如果你想关闭的新特点，请[$1 按此]。你将需要先登入或是注册户口。',
	'prefswitch-main-on' => '=== 取消新功能 ===
[$2 按此回到旧版]',
	'prefswitch-main-off' => '===尝试新功能===
如果你想打开新的功能，请[$1 点击这里]。',
	'prefswitch-survey-intro-feedback' => "我们将非常乐意听取您的意见。请填写下面的'''可选'''的调查，然后点击[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]\"。",
	'prefswitch-survey-intro-off' => '感谢您试用我们的新功能。为了帮助我们改进，请填写下面的可选的调查，然后点击"[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"。',
	'prefswitch-feedbackpage' => 'Project:Vector用户反馈',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Horacewai2
 */
$messages['zh-hant'] = array(
	'prefswitch' => '可用性倡議偏好設定',
	'prefswitch-desc' => '允許用戶設定參數設定',
	'prefswitch-link-anon' => '新功能',
	'tooltip-pt-prefswitch-link-anon' => '了解更多關於新功能',
	'prefswitch-link-on' => '回到舊版',
	'tooltip-pt-prefswitch-link-on' => '禁用新功能',
	'prefswitch-link-off' => '新功能',
	'tooltip-pt-prefswitch-link-off' => '嘗試新功能',
	'prefswitch-jswarning' => '請記住此對皮膚的變化，你[[User:$1/$2.js|$2的JavaScript]]將需要複製到[[{{ns:user}}:$1/vector.js]] <!--或 [[{{ns:user}}:$1/common.js]]-->才能繼續有效。',
	'prefswitch-csswarning' => '你的[[User:$1/$2.css|自訂$2款式]]將不再適用，你可以在[[{{ns:user}}:$1/vector.css]]新增Vector的自訂CSS。',
	'prefswitch-survey-true' => '是',
	'prefswitch-survey-false' => '否',
	'prefswitch-survey-submit-off' => '關閉新特色',
	'prefswitch-survey-cancel-off' => '如果您想繼續使用新特色，您可以返回$1。',
	'prefswitch-survey-submit-feedback' => '發送意見',
	'prefswitch-survey-cancel-feedback' => '如果你不想提供意見，你可以回到$1繼續。',
	'prefswitch-survey-question-like' => '你喜歡什麼新特點？',
	'prefswitch-survey-question-dislike' => '你不喜歡什麼特點？',
	'prefswitch-survey-question-whyoff' => '你為什麼關閉新的功能？請選擇所有適用的選擇。',
	'prefswitch-survey-answer-whyoff-hard' => '新特點很難去使用。',
	'prefswitch-survey-answer-whyoff-didntwork' => '新特色無法正常工作。',
	'prefswitch-survey-answer-whyoff-notpredictable' => '新特點不及我預期的好。',
	'prefswitch-survey-answer-whyoff-didntlike-look' => '我不喜歡這些新特點的外觀。',
	'prefswitch-survey-answer-whyoff-didntlike-layout' => '我不喜歡它的新標籤以及排版。',
	'prefswitch-survey-answer-whyoff-didntlike-toolbar' => '我不喜歡它的新工具列。',
	'prefswitch-survey-answer-whyoff-other' => '其他原因：',
	'prefswitch-survey-question-browser' => '您用哪款瀏覽器？',
	'prefswitch-survey-answer-browser-other' => '其它瀏覽器：',
	'prefswitch-survey-question-os' => '您用哪套操作系統？',
	'prefswitch-survey-answer-os-other' => '其它操作系統：',
	'prefswitch-survey-question-res' => '您的屏幕解像度之大小有多大？',
	'prefswitch-title-on' => '新功能',
	'prefswitch-title-switched-on' => '享受！',
	'prefswitch-title-off' => '關閉新特色',
	'prefswitch-title-switched-off' => '謝謝',
	'prefswitch-title-feedback' => '反饋',
	'prefswitch-success-on' => '新功能已經打開了。我們希望你能享受使用這些新功能，你可以關閉這些新功能，只需要按本頁頁頂的[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-on}}]]便可以了。',
	'prefswitch-success-off' => '新功能已經關閉了。多謝你試用，你可以隨時開啟這些新功能，只需要按本頁頁頂的[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]便可以了。',
	'prefswitch-success-feedback' => '您的反饋已發送。',
	'prefswitch-return' => '<hr style="clear:both">
返回<span class="plainlinks">[$1 $2]</span>。',
	'prefswitch-main' => "{| border=\"0\" align=\"right\" style=\"margin-left:1em\"
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorNavigation-en.png|401px|]]
|-
| 維基百科新的導航界面的截圖 <small>[[Media:VectorNavigation-en.png|(放大)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorEditorBasic-en.png|401px|]]
|-
| 基本編輯界面的截圖 <small>[[Media:VectorEditorBasic-en.png|(放大)]]</small>
|}
|-
| align=\"center\" |
{| border=\"0\" style=\"background:#F3F3F3;border: 1px solid #CCCCCC;padding:10px;\"
| [[Image:VectorLinkDialog-en.png|401px|]]
|-
| 插入鏈接對話框的截圖
|}
|}

維基媒體基金會的用戶體驗團隊同社群的志願者一起在努力令你更方便的使用。我們很高興能夠分享一些改進，包括一個全新的外觀和簡化的編輯功能。這些變化都是為了讓新的參與者更容易進行貢獻，同時我們[http://usability.wikimedia.org/wiki/Usability,_Experience,_and_Evaluation_Study 在過去一年裡進行了大量的可用性測試]。提高我們項目的可用性是維基媒體基金會的重要目標，我們將在未來分享更多的更新。欲了解更多詳情，請訪問相關的維基媒體[http://blog.wikimedia.org/2010/05/13/a-new-look-for-wikipedia 博客上的帖子]。

=== 下面是我們的改變 ===

* '''導航'''：我們已經改善了閱讀和編輯網頁時的導航。現在，每一頁頂部上的標籤更明確地界定你是正在查看頁面還是討論頁，以及你是否正在閱讀或編輯一個頁面。
* '''編輯工具欄上的改善'''：我們已經重組了編輯工具欄，以便於更容易使用。現在，格式化網頁更簡單，更直觀。
* '''鏈接嚮導'''：一個易於使用的工具可以讓你添加鏈接到其他維基頁面以及鏈接到外部網站。
* '''搜索的改進'''：我們改進了搜索建議，讓你尋找網頁更迅速。
* '''其他的新功能'''：我們也推出了表格嚮導，使創建表格更容易，同時尋找和替換功能來簡化頁面的編輯。
* '''維基百科logo'''：我們已經更新了我們的logo。詳情見[http://blog.wikimedia.org/2010/05/13/wikipedia-in-3d Wikimedia blog]。",
	'prefswitch-main-logged-changes' => "* '''{{int:watch}}標籤'''現在是一顆星。
* '''{{int:move}}標籤'''現在是在搜索框旁邊的下拉選單中。",
	'prefswitch-main-feedback' => '===意見?===

我們希望收到你們的意見，請造訪我們的[[$1|意見反饋頁面]]，或者如果你對我們的軟件改善有興趣，可到[http://usability.wikimedia.org usability wiki]了解詳情。',
	'prefswitch-main-anon' => '=== 取消新功能 ===
如果你想關閉的新特點，請[$1 按此]。你將需要先登入或是註冊戶口。',
	'prefswitch-main-on' => '=== 取消新功能 ===
[$2 按此回到舊版]',
	'prefswitch-main-off' => '===嘗試新功能===
如果你想打開新的功能，請[$1 點擊這裡]。',
	'prefswitch-survey-intro-feedback' => "我們將非常樂意聽取您的意見。請填寫下面的'''可選'''的調查，然後點擊[[#prefswitch-survey-submit-feedback|{{int:Prefswitch-survey-submit-feedback}}]]\"。",
	'prefswitch-survey-intro-off' => '感謝您試用我們的新功能。為了幫助我們改進，請填寫下面的可選的調查，然後點擊"[[#prefswitch-survey-submit-off|{{int:Prefswitch-survey-submit-off}}]]"。',
	'prefswitch-feedbackpage' => 'Project:Vector用戶反饋',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Liangent
 */
$messages['zh-tw'] = array(
	'prefswitch-success-off' => '新功能已經關閉了。感謝您的試用，你可以隨時開啟這些新功能，只需要按本頁頁頂的[[Special:UsabilityInitiativePrefSwitch|{{int:prefswitch-link-off}}]]便可以了。',
);

