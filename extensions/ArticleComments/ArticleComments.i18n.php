<?php
/**
 * Internationalisation file for ArticleComments extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'article-comments-desc' => 'Enables comment sections on content pages',
	'article-comments-title-string' => 'title',
	'article-comments-name-string' => 'Name',
	'article-comments-name-field' => 'Name (required):',
	'article-comments-url-field' => 'Website:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comment',
	'article-comments-comment-field' => 'Comment:',
	'article-comments-submit-button' => 'Submit',
	'article-comments-leave-comment-link' => 'Leave a comment ...',
	'article-comments-invalid-field' => 'The $1 provided <nowiki>[$2]</nowiki> is invalid.',
	'article-comments-required-field' => '"$1" field is required.',
	'article-comments-submission-failed' => 'Comment submission failed',
	'article-comments-failure-reasons' => 'Sorry, your comment submission failed for the following {{PLURAL:$1|reason|reasons}}:',
	'article-comments-no-comments' => 'Sorry, the page "[[$1]]" is not accepting comments at this time.',
	'article-comments-talk-page-starter' => "<noinclude>Comments on \"[[$1]]\"\n<comments />\n----- __NOEDITSECTION__</noinclude>",
	'article-comments-commenter-said' => '$1 said ...',
	'article-comments-summary' => 'Comment provided by $1 - via ArticleComments extension',
	'article-comments-submission-succeeded' => 'Comment submission succeeded',
	'article-comments-submission-success' => 'You have successfully submitted a comment for "[[$1]]"',
	'article-comments-submission-view-all' => 'You may view [[$1|all comments on that page]]',
	'article-comments-prefilled-comment-text' => '',
	'article-comments-user-is-blocked' => 'Your user account is currently blocked from editing "[[$1]]".',
	'article-comments-new-comment-heading' => "\n== {{int:article-comments-commenter-said|\$1}} ==\n\n",
	'article-comments-comment-bad-mode' => 'Invalid mode given for comment.
Available ones are "plain", "normal" and "wiki".',
	'article-comments-comment-contents' => "<div class='commentBlock'><small>$4</small>$5--\$3</div>\n",
	'article-comments-comment-missing-name-parameter' => 'Missing name',
	'article-comments-comment-missing-date-parameter' => 'Missing comment date',
	'article-comments-no-spam' => 'At least one of the submitted fields was flagged as spam.',
	'processcomment' => 'Process page comment',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Hamilton Abreu
 * @author Hydra
 * @author Purodha
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'article-comments-desc' => '{{desc}}',
	'article-comments-title-string' => '{{Identical|Title}}',
	'article-comments-name-string' => '{{Identical|Name}}',
	'article-comments-comment-string' => '{{Identical|Comment}}',
	'article-comments-comment-field' => '{{Identical|Comment}}',
	'article-comments-submit-button' => '{{Identical|Submit}}',
	'article-comments-invalid-field' => 'Shown as a list below {{msg-mw|article-comments-failure-reasons}}. Parameters:
* $1 is {{msg-mw|article-comments-title-string}} or {{msg-mw|article-comments-url-string}}
* $2 is the incorrect value.',
	'article-comments-required-field' => 'Shown as a list below article-comments-failure-reasons. Parameters:
* $1 being is one of {{msg-mw|article-comments-title-string}}, {{msg-mw|article-comments-name-string}}, {{msg-mw|article-comments-url-string}}, {{msg-mw|article-comments-comment-string}}.',
	'article-comments-submission-failed' => 'Page title when there are errors in the comment submission',
	'article-comments-talk-page-starter' => 'Keep the wikisyntax as is.',
	'article-comments-commenter-said' => '$1 is a value filled into a form field by a commenter. It is not necessarily related to any wiki user name.',
	'article-comments-summary' => '$1 is a value filled into a form field by a commenter. It is not necessarily related to any wiki user name.',
	'article-comments-comment-bad-mode' => '{{doc-important|Do not translate the words "plain", "normal" and "wiki".}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'article-comments-desc' => 'Maak kommentaar-afdelings op artikel-bladsye beskikbaar',
	'article-comments-title-string' => 'titel',
	'article-comments-name-string' => 'Naam',
	'article-comments-name-field' => 'Naam (verpligtend):',
	'article-comments-url-field' => 'Webwerf:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Kommentaar',
	'article-comments-comment-field' => 'Kommentaar:',
	'article-comments-submit-button' => 'Dien in',
	'article-comments-leave-comment-link' => "Los 'n opmerking...",
	'article-comments-invalid-field' => 'Die $1 verskafde <nowiki>[$2]</nowiki> is ongeldig.',
	'article-comments-required-field' => 'Die veld $1 is verpligtend.',
	'article-comments-submission-failed' => 'Indien van kommentaar het gefaal',
	'article-comments-failure-reasons' => 'Jammer, u kommentaar was om die volgende {{PLURAL:$1|rede|redes}} onsuksesvol:',
	'article-comments-no-comments' => 'Jammer, die artikel "[[$1]]" aanvaar nie tans kommentaar nie.',
	'article-comments-talk-page-starter' => '<noinclude> Kommentaar op [[$1]] 
<comments />
 ----- __NOEDITSECTION__ </noinclude>',
	'article-comments-commenter-said' => '$1 het gesê...',
	'article-comments-summary' => 'Kommentaar deur $1 - via die ArticleComments-uitbreiding',
	'article-comments-submission-succeeded' => 'Indien van kommentaar was suksesvol',
	'article-comments-submission-success' => 'U het suksesvol \'n kommentaar vir "[[$1]]" ingedien',
	'article-comments-submission-view-all' => 'U kan al die antwoorde op hierdie artikel [[$1|hier]] sien',
	'article-comments-user-is-blocked' => 'U gebruiker is tans teen die redigering van "[[$1]]" geblokkeer.',
	'article-comments-comment-bad-mode' => 'Ongeldige modes is vir kommentaar verskaf.
Beskikbare modusse is: "plain", "normal" en "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Naam ontbreek',
	'article-comments-comment-missing-date-parameter' => 'Geen datum vir kommentaar',
	'article-comments-no-spam' => 'Ten minste een van die voorgelegde velde is as spam gemerk.',
	'processcomment' => 'Verwerk kommentaar op artikel',
);

/** Arabic (العربية)
 * @author OsamaK
 * @author روخو
 */
$messages['ar'] = array(
	'article-comments-url-string' => 'المسار:',
	'article-comments-submit-button' => 'أرسل',
	'article-comments-commenter-said' => '$1 قال ...',
	'article-comments-comment-missing-name-parameter' => 'اسم مفقود',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'article-comments-title-string' => 'ܟܘܢܝܐ',
	'article-comments-name-string' => 'ܫܡܐ',
	'article-comments-submit-button' => 'ܫܕܪ',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'article-comments-desc' => 'Activa les seiciones de comentarios nes páxines de conteníu',
	'article-comments-title-string' => 'títulu',
	'article-comments-name-string' => 'Nome',
	'article-comments-name-field' => 'Nome (obligatoriu):',
	'article-comments-url-field' => 'Páxina web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comentariu',
	'article-comments-comment-field' => 'Comentariu:',
	'article-comments-submit-button' => 'Unviar',
	'article-comments-leave-comment-link' => 'Dexar un comentariu...',
	'article-comments-invalid-field' => 'El $1 proporcionáu <nowiki>[$2]</nowiki> nun ye válidu.',
	'article-comments-required-field' => 'El campu «$1» ye obligatoriu.',
	'article-comments-submission-failed' => "Falló l'unviu del comentariu",
	'article-comments-failure-reasons' => 'Sentímoslo, el to comentariu nun pudo unviase {{PLURAL:$1|pol siguiente motivu|polos siguientes motivos}}:',
	'article-comments-no-comments' => 'Sentímoslo, nesti momentu la páxina «[[$1]]» nun aceuta comentarios.',
	'article-comments-talk-page-starter' => '<noinclude>Comentarios sobro «[[$1]]»
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 dixo...',
	'article-comments-summary' => 'Comentariu proporcionáu por $1 - pela estensión ArticleComments',
	'article-comments-submission-succeeded' => "El comentariu s'unvió correutamente",
	'article-comments-submission-success' => 'Unviasti correutamente un comentariu sobro "[[$1]]"',
	'article-comments-submission-view-all' => 'Pues ver [[$1|tolos los comentarios sobro esa páxina]]',
	'article-comments-user-is-blocked' => "La to cuenta d'usuariu tien torgao editar «[[$1]]».",
	'article-comments-comment-bad-mode' => 'El mou que se dio pal comentariu nun ye válidu.
Los moos disponibles son "plain", "normal" y "wiki".',
	'article-comments-comment-missing-name-parameter' => "Falta'l nome",
	'article-comments-comment-missing-date-parameter' => 'Fata la data del comentariu',
	'article-comments-no-spam' => 'Polo menos un de los campos unviaos se marcó como puxarra.',
	'processcomment' => 'Procesar el comentariu de páxina',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Wertuose
 */
$messages['az'] = array(
	'article-comments-name-string' => 'Ad',
	'article-comments-url-field' => 'Vebsayt:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Şərh',
	'article-comments-comment-field' => 'Şərh:',
	'article-comments-submit-button' => 'Təsdiq et',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'article-comments-desc' => 'Эстәлек биттәренең бүлектәренә иҫкәрмә өҫтәргә мөмкинлек бирә.',
	'article-comments-title-string' => 'исеме',
	'article-comments-name-string' => 'Исеме',
	'article-comments-name-field' => 'Исеме (мотлаҡ):',
	'article-comments-url-field' => 'Сайт:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Иҫкәрмә',
	'article-comments-comment-field' => 'Иҫкәрмә:',
	'article-comments-submit-button' => 'Ебәрергә',
	'article-comments-leave-comment-link' => 'Иҫкәрмә яҙырға...',
	'article-comments-invalid-field' => '$1 күрһәткән <nowiki>[$2]</nowiki> дөрөҫ түгел.',
	'article-comments-required-field' => '$1 юлы мотлаҡ.',
	'article-comments-submission-failed' => 'Иҫкәрмә ебәреү хатаһы',
	'article-comments-failure-reasons' => 'Ғәфү итегеҙ, иҫкәрмә ебәреү түбәндәге {{PLURAL:$1|сәбәп|сәбәптәр}} арҡаһында килеп сыҡманы:',
	'article-comments-no-comments' => 'Ғәфү итегеҙ, "[[$1]]" бите хәҙерге ваҡытта иҫкәрмәләр ҡабул итмәй.',
	'article-comments-talk-page-starter' => '<noinclude>[[$1]] битенә иҫкәрмә
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 әйткән ...',
	'article-comments-summary' => 'ArticleComments киңәйтеүе ярҙамында $1 тарафынан бирелгән иҫкәрмә',
	'article-comments-submission-succeeded' => 'Иҫкәрмә уңышлы ебәрелде',
	'article-comments-submission-success' => '"[[$1]]" бите өсөн иҫкәрмә уңышлы ебәрелде',
	'article-comments-submission-view-all' => 'Һеҙ [[$1|был бит өсөн бөтә иҫкәрмәләрҙе]] ҡарап сыға алаһығыҙ',
	'article-comments-user-is-blocked' => 'Һеҙҙең иҫап яҙмағыҙ хәҙерге ваҡытта "[[$1]]" битен мөхәррирләүҙән бикләнгән.',
	'article-comments-comment-bad-mode' => "Иҫкәрмә өсөн дөрөҫ төр бирелмәгән.
Мөмкин булған төрҙәр — ''ябай'', ''ғәҙәти'', ''вики''.",
	'article-comments-comment-missing-name-parameter' => 'Исеме күрһәтелмәгән',
	'article-comments-comment-missing-date-parameter' => 'Иҫкәрмә яҙыу ваҡыты юҡ',
	'article-comments-no-spam' => 'Кәмендә бер ебәрелгән юл спам тип билдәләнгән.',
	'processcomment' => 'Мәҡәләгә иҫкәрмә өҫтәү бара',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'article-comments-desc' => 'Erméglichts Kómmtentirn voh Inhoidsseiten',
	'article-comments-title-string' => 'Titel',
	'article-comments-name-string' => 'Nåm',
	'article-comments-name-field' => 'Nåm (erforderlich):',
	'article-comments-url-field' => 'Webseiten:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Kommentar',
	'article-comments-comment-field' => 'Kommentar:',
	'article-comments-submit-button' => 'Speichern',
	'article-comments-leave-comment-link' => 'Gib an Kommentar ob ...',
	'article-comments-invalid-field' => 'Dé Eihgob <nowiki>[$2]</nowiki> ois $1 is ungütig.',
	'article-comments-required-field' => '$1 is a Pflichtföd.',
	'article-comments-submission-failed' => 'Dé Obgob vom Kommentar is föögschlong.',
	'article-comments-failure-reasons' => 'Dé Obgob vom Kommentar is ausm {{PLURAL:$1| fóigenden Grund|dé fóigenden Grynd}} föögschlong:',
	'article-comments-no-comments' => 'Fyr dé Seiten „[[$1]]“ kennern im Móment koane Kommentare obgeem wern.',
	'article-comments-talk-page-starter' => '<noinclude>Kommentare zur da Seiten „[[$1]]“
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 sogt …',
	'article-comments-summary' => "A Kommentar is voh $1 ywer d' Prógrammdaweiterung ArticleComments obgeem worn.",
	'article-comments-submission-succeeded' => 'Dé Obgob vom Kommentar is durchgfyrd worn.',
	'article-comments-submission-success' => "Du host erfóigreich an Kommentar fyr d' Seiten „[[$1]]“ obgeem.",
	'article-comments-submission-view-all' => 'Du kåst [[$1|olle Kommentare zua derer Seiten]] åschaung',
	'article-comments-user-is-blocked' => "Du derfst d' Seiten „[[$1]]“ derzeid néd beorweiten.",
	'article-comments-comment-bad-mode' => "Fyr d' Kommentiarung is a ungütiger Módus ågeem.
Méglich san d' Módusse „plain“, „normal“ und „wiki“.",
	'article-comments-comment-missing-name-parameter' => 'Da Nåm fööd',
	'article-comments-comment-missing-date-parameter' => "'s Daatum fööd",
	'article-comments-no-spam' => "Minderstens oahne vo d' Ågom is ois Spam identifizird worn.",
	'processcomment' => 'Kommentirn voh Inhoidsseiten vaorweiten',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'article-comments-desc' => 'Дазваляе разьдзелы камэнтараў у старонках са зьместам',
	'article-comments-title-string' => 'назва',
	'article-comments-name-string' => 'Назва',
	'article-comments-name-field' => 'Назва (абавязкова):',
	'article-comments-url-field' => 'Ўэб-сайт:',
	'article-comments-url-string' => 'URL-адрас',
	'article-comments-comment-string' => 'Камэнтар',
	'article-comments-comment-field' => 'Камэнтар:',
	'article-comments-submit-button' => 'Даслаць',
	'article-comments-leave-comment-link' => 'Пакінуць камэнтар…',
	'article-comments-invalid-field' => '$1 пададзеная для <nowiki>[$2]</nowiki> зьяўляецца няслушнай.',
	'article-comments-required-field' => 'Поле $1 — абавязковае.',
	'article-comments-submission-failed' => 'Немагчыма запісаць камэнтар',
	'article-comments-failure-reasons' => 'Прабачце, але адбылася памылка запісу Вашага камэнтара па {{PLURAL:$1|наступнай прычыне|наступным прычынам}}:',
	'article-comments-no-comments' => 'Прабачце, старонка «[[$1]]» у цяперашні момант недаступная для камэнтараў.',
	'article-comments-talk-page-starter' => '<noinclude>Камэнтар да [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 {{GENDER:$1|напісаў|напісала}}…',
	'article-comments-summary' => 'Камэнтар пададзены $1 з дапамогай пашырэньня ArticleComments',
	'article-comments-submission-succeeded' => 'Камэнтар пасьпяхова запісаны',
	'article-comments-submission-success' => 'Ваш камэнтар да «[[$1]]» быў пасьпяхова запісаны',
	'article-comments-submission-view-all' => 'Вы можаце ўбачыць [[$1|усе камэнтары гэтай старонкі]]',
	'article-comments-user-is-blocked' => 'У Вашага рахунка заблякаваная магчымасьць рэдагаваньня «[[$1]]».',
	'article-comments-comment-bad-mode' => 'Пададзены няслушны рэжым для камэнтара.
Даступнымі зьяўляюцца «plain», «normal» і «wiki».',
	'article-comments-comment-missing-name-parameter' => 'Няма назвы',
	'article-comments-comment-missing-date-parameter' => 'Няма даты стварэньня камэнтара',
	'article-comments-no-spam' => 'Хаця б адно дасланае поле пазначанае як спам.',
	'processcomment' => 'Апрацоўка камэнтара артыкулу',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'article-comments-name-string' => 'Име',
	'article-comments-name-field' => 'Име (задължително):',
	'article-comments-url-field' => 'Уеб сайт:',
	'article-comments-url-string' => 'Адрес',
	'article-comments-comment-string' => 'Коментар',
	'article-comments-comment-field' => 'Коментар:',
	'article-comments-submit-button' => 'Изпращане',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'article-comments-desc' => 'বিষয়বস্তু পাতায় মন্তব্য অংশ সক্রিয় করো',
	'article-comments-title-string' => 'শিরোনাম',
	'article-comments-name-string' => 'নাম',
	'article-comments-name-field' => 'নাম (বাধ্যতামূলক)',
	'article-comments-url-field' => 'ওয়েবসাইট:',
	'article-comments-url-string' => 'ইউআরএল',
	'article-comments-comment-string' => 'মন্তব্য',
	'article-comments-comment-field' => 'মন্তব্য:',
	'article-comments-submit-button' => 'জমা দাও',
	'article-comments-leave-comment-link' => 'মন্তব্য করুন ...',
	'article-comments-invalid-field' => '$1 প্রদানকৃত <nowiki>[$2]</nowiki> গ্রহণযোগ্য নয়।',
	'article-comments-required-field' => '"$1" অংশটি প্রদান করা বাধ্যতামূলক।',
	'article-comments-submission-failed' => 'মন্তব্য জমাদান ব্যর্থ হয়েছে',
	'article-comments-failure-reasons' => 'দুঃখিত, আপনার মন্তব্য যোগ ব্যর্থ হয়েছে নিম্নোক্ত {{PLURAL:$1|কারণে|কারণে}}:',
	'article-comments-no-comments' => 'দুঃখিত, "[[$1]]" পাতাটি বর্তমানে কোনো মন্তব্য গ্রহণ করছে না।',
	'article-comments-talk-page-starter' => '<noinclude>"[[$1]]" পাতায় মন্তব্য
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 বলেছেন ...',
	'article-comments-summary' => 'মন্তব্যটি $1 দ্বারা, আর্টিকলকমেন্ট এক্সটেনশনের মাধ্যমে প্রদান করা হয়েছে',
	'article-comments-submission-succeeded' => 'মন্তব্য জমাদান সফল',
	'article-comments-submission-success' => 'আপনি "[[$1]]" পাতার জন্য সফলতার সাথে একটি মন্তব্য প্রদান করেছেন',
	'article-comments-submission-view-all' => 'আপনি [[$1|ঐ পাতায় থাকা সকল মন্তব্য]] দেখতে পারেন',
	'article-comments-user-is-blocked' => 'আপনার ব্যবহারকারী অ্যাকাউন্টে বর্তমানে "[[$1]]" পাতাটি সম্পাদনায় বাধা রয়েছে।',
	'article-comments-comment-bad-mode' => 'কমেন্টে জন্য অগ্রহণযোগ্য মোড প্রদান করা হয়েছে।
প্রযোজ্য মোডগুলোর মধ্যে রয়েছে "সরল", "সাধারণ" ও "উইকি"।',
	'article-comments-comment-missing-name-parameter' => 'হারানো নাম',
	'article-comments-comment-missing-date-parameter' => 'হারানো মন্তব্যের তারিখ',
	'article-comments-no-spam' => 'কমপক্ষে জমা প্রদান করা একটি অংশ স্প্যাম হিসেবে পরিগণিত হয়েছে।',
	'processcomment' => 'পাতার মন্তব্য প্রক্রিয়াকরণ করুন',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'article-comments-desc' => 'Gweredekaat ar pennadoù burutellañ war pajennoù ar pennadoù',
	'article-comments-title-string' => 'titl',
	'article-comments-name-string' => 'Anv',
	'article-comments-name-field' => 'Anv (ret) :',
	'article-comments-url-field' => "Lec'hienn web :",
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Evezhiadenn',
	'article-comments-comment-field' => 'Evezhiadenn :',
	'article-comments-submit-button' => 'Kas',
	'article-comments-leave-comment-link' => 'Lezel un evezhiadenn...',
	'article-comments-invalid-field' => 'An $1 roet <nowiki>[$2]</nowiki> zo direizh.',
	'article-comments-required-field' => 'Rekis eo leuniañ ar vaezienn $1.',
	'article-comments-submission-failed' => "C'hwitet eo bet kasadenn ar vurutelladenn",
	'article-comments-failure-reasons' => "Ho tigarez, n'eus ket bet gallet kas hoc'h evezhiadenn evit an {{PLURAL:$1|abeg|abegoù}} da-heul :",
	'article-comments-no-comments' => 'Ho tigarez, n\'haller ket kas burutelladennoù diwar-benn ar pennad "[[$1]]" evit c\'hoazh.',
	'article-comments-talk-page-starter' => '<noinclude>Evezhiadennoù war [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 en deus laret ...',
	'article-comments-summary' => 'Burutelladenn degaset gant $1 - dre an astenn ArticleComments',
	'article-comments-submission-succeeded' => 'Kaset eo bet ar vurutelladenn ervat',
	'article-comments-submission-success' => 'Kaset mat eo bet ho purutelladenn diwar-benn "[[$1]]"',
	'article-comments-submission-view-all' => 'Gwallout a rit gwelet an holl vurutelladennoù evit ar pennad-mañ [[$1|amañ]]',
	'article-comments-user-is-blocked' => 'Berzet eo d\'ho kont implijer skrivañ war "[[$1]]" evit ar mare.',
	'article-comments-comment-bad-mode' => 'Direizh eo ar mod burutellañ zo bet lakaet.
Gallout a reer ober gant ar modoù "plaen", "normal" ha "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Anv a vank',
	'article-comments-comment-missing-date-parameter' => 'Mankout a ra deiziad ar vurutelladenn',
	'article-comments-no-spam' => 'Merket ez eus bet evel strob da nebeutañ unan eus ar maeziennoù bet kaset.',
	'processcomment' => 'O plediñ gant burutelladenn ar pennad',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'article-comments-desc' => 'Omogućava komentiranje sekcija na stranicama sadržaja',
	'article-comments-title-string' => 'naslov',
	'article-comments-name-string' => 'Ime',
	'article-comments-name-field' => 'Ime (obavezno):',
	'article-comments-url-field' => 'Web stranica:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komentar',
	'article-comments-comment-field' => 'Komentar:',
	'article-comments-submit-button' => 'Pošalji',
	'article-comments-leave-comment-link' => 'Ostavite komentar ...',
	'article-comments-invalid-field' => 'Navedeni $1 <nowiki>[$2]</nowiki> nije valjan.',
	'article-comments-required-field' => '$1 polje je obavezno.',
	'article-comments-submission-failed' => 'Slanje komentara nije uspjelo',
	'article-comments-failure-reasons' => 'Žao nam je, vaše slanje komentara nije uspjelo iz {{PLURAL:$1|slijedećeg razloga|slijedećih razloga}}:',
	'article-comments-no-comments' => 'Žao nam je, stranica "[[$1]]" trenutno ne prima komentare.',
	'article-comments-commenter-said' => '$1 je napisao ...',
	'article-comments-submission-succeeded' => 'Slanje komentara je uspjelo',
	'article-comments-comment-missing-name-parameter' => 'Nedostaje ime',
	'article-comments-comment-missing-date-parameter' => 'Nedostaje datum komentara',
);

/** Catalan (Català)
 * @author El libre
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'article-comments-desc' => 'Permet fer comentaris de les seccions a les pàgines de contingut',
	'article-comments-title-string' => 'títol',
	'article-comments-name-string' => 'Nom',
	'article-comments-name-field' => 'Nom (requerit):',
	'article-comments-url-field' => 'Pàgina web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comentari',
	'article-comments-comment-field' => 'Comentari:',
	'article-comments-submit-button' => 'Tramet',
	'article-comments-leave-comment-link' => 'Deixa un comentari ...',
	'article-comments-invalid-field' => 'El $1 proporcionat <nowiki>[$2]</nowiki> és invàlid.',
	'article-comments-required-field' => 'El camp "$1" és obligatori.',
	'article-comments-submission-failed' => "L'enviament del comentari ha fallat",
	'article-comments-failure-reasons' => 'Ho sentim. El teu comentari no ha pogut enviar-se per {{PLURAL:$1|la següent raó|les següents raons}}:',
	'article-comments-no-comments' => 'Ho sentim. La pàgina "[[$1]]" no accepta comentaris en aquest moment.',
	'article-comments-talk-page-starter' => '<noinclude> Comentaris sobre "[[$1]]" 
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 ha dit ...',
	'article-comments-summary' => "Comentari proporcionat per $1 - a través de l'extensió ArticleComments",
	'article-comments-submission-succeeded' => 'Enviament del comentari realitzat amb èxit',
	'article-comments-submission-success' => 'Has enviat correctament un comentari sobre "[[$1]]"',
	'article-comments-submission-view-all' => 'Pots veure [[$1|tots els comentaris sobre aquesta pàgina]]',
	'article-comments-user-is-blocked' => 'El teu compte d\'usuari està bloquejat per editar  "[[$1]]".',
	'article-comments-comment-bad-mode' => 'El mode donat per al comentari no és vàlid.
Els disponibles són "plain", "normal" i "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Falta el nom',
	'article-comments-comment-missing-date-parameter' => 'Falta la data del comentari',
	'article-comments-no-spam' => "Com a mínim un dels camps enviats s'ha marcat com no desitjat.",
	'processcomment' => "Processa el comentari a l'article",
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'article-comments-name-string' => 'Nome',
);

/** Czech (Česky)
 * @author Achiles
 * @author Jkjk
 */
$messages['cs'] = array(
	'article-comments-desc' => 'Umožňuje přidat komentáře na obsahové stránky',
	'article-comments-title-string' => 'název',
	'article-comments-name-string' => 'Jméno',
	'article-comments-name-field' => 'Jméno (nezbytné):',
	'article-comments-url-field' => 'Webová stránka:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komentář:',
	'article-comments-comment-field' => 'Komentář:',
	'article-comments-submit-button' => 'Odeslat',
	'article-comments-leave-comment-link' => 'Zanechte komentář ...',
	'article-comments-invalid-field' => 'Zadaný $1 <nowiki> [$2] </nowiki> je neplatný.',
	'article-comments-required-field' => 'pole $1 je nezbytné.',
	'article-comments-submission-failed' => 'Odeslání komentáře selhalo',
	'article-comments-failure-reasons' => 'Omlouváme se, odeslání Vašeho komentáře selhalo z {{PLURAL:$1|následujícího důvodu|následujích důvodů}}',
	'article-comments-no-comments' => 'Omlouváme se, na stránku "[[$1]]" není v tuto chvíli možné umístit komentář.',
	'article-comments-talk-page-starter' => '<noinclude>Komentáře na "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 řekl ...',
	'article-comments-summary' => 'Komentáře poskytované $1 - pomocí rozšíření ArticleComments',
	'article-comments-submission-succeeded' => 'Odeslání komentáře proběhlo úspěšně',
	'article-comments-submission-success' => 'Úspěšně jste odeslali komentář pro "[[$1]]."',
	'article-comments-submission-view-all' => 'Můžete si prohlédnout [[$1|všechny komentáře na této stránce]].',
	'article-comments-user-is-blocked' => 'Na Vašem uživatelském účtu je v současné době zablokována možnost editace "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Neplatný formát komentáře.
Dostupné jsou tyto "plain", "normal" a "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Chybějící jméno',
	'article-comments-comment-missing-date-parameter' => 'Chybějící datum komentáře',
	'article-comments-no-spam' => 'Nejméně jedna odeslaná položka je označena jako spam.',
	'processcomment' => 'Zpracování komentáře',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Kghbln
 * @author Purodha
 * @author The Evil IP address
 * @author 青子守歌
 */
$messages['de'] = array(
	'article-comments-desc' => 'Ermöglicht das Kommentieren von Inhaltsseiten',
	'article-comments-title-string' => 'Titel',
	'article-comments-name-string' => 'Name',
	'article-comments-name-field' => 'Name (erforderlich):',
	'article-comments-url-field' => 'Website:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Kommentar',
	'article-comments-comment-field' => 'Kommentar:',
	'article-comments-submit-button' => 'Speichern',
	'article-comments-leave-comment-link' => 'Hinterlasse einen Kommentar …',
	'article-comments-invalid-field' => 'Die Eingabe <nowiki>[$2]</nowiki> als $1 ist ungültig.',
	'article-comments-required-field' => '$1 ist ein Pflichtfeld.',
	'article-comments-submission-failed' => 'Die Kommentierung ist fehlgeschlagen.',
	'article-comments-failure-reasons' => 'Die Kommentierung ist aus {{PLURAL:$1|dem folgenden Grund|den folgenden Gründen}} fehlgeschlagen:',
	'article-comments-no-comments' => 'Für die Seite „[[$1]]“ können momentan keine Kommentare abgegeben werden.',
	'article-comments-talk-page-starter' => '<noinclude>Kommentare zur Seite „[[$1]]“
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 meinte …',
	'article-comments-summary' => 'Ein Kommentar wurde von $1 über die Programmerweiterung ArticleComments abgegeben.',
	'article-comments-submission-succeeded' => 'Die Kommentierung wurde durchgeführt.',
	'article-comments-submission-success' => 'Du hast erfolgreich einen Kommentar für die Seite „[[$1]]“ abgegeben.',
	'article-comments-submission-view-all' => 'Du kannst [[$1|alle Kommentare zu dieser Seite]] einsehen',
	'article-comments-user-is-blocked' => 'Du darfst die Seite „[[$1]]“ derzeit nicht bearbeiten.',
	'article-comments-comment-bad-mode' => 'Für die Kommentierung wurde ein ungültiger Modus angegeben.
Möglich sind die Modi „plain“, „normal“ und „wiki“.',
	'article-comments-comment-missing-name-parameter' => 'Fehlender Name',
	'article-comments-comment-missing-date-parameter' => 'Fehlendes Datum',
	'article-comments-no-spam' => 'Mindestens eine der Angaben wurde als Spam identifiziert.',
	'processcomment' => 'Kommentieren von Inhaltsseiten verarbeiten',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'article-comments-submission-success' => 'Sie haben erfolgreich einen Kommentar für Seite „[[$1]]“ abgegeben.',
	'article-comments-submission-view-all' => 'Sie können alle Kommentare zu dieser Seite [[$1|hier]] einsehen.',
	'article-comments-user-is-blocked' => 'Sie dürfen die Seite „[[$1]]“ derzeit nicht bearbeiten.',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 */
$messages['diq'] = array(
	'article-comments-name-string' => 'Name',
	'article-comments-submit-button' => 'Qeyd ke',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'article-comments-desc' => 'Zmóžnja komentarowe wótrězki na wopsimjeśowych bokach',
	'article-comments-title-string' => 'titel',
	'article-comments-name-string' => 'Mě',
	'article-comments-name-field' => 'Mě (trěbne):',
	'article-comments-url-field' => 'Websedło:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komentar',
	'article-comments-comment-field' => 'Komentar:',
	'article-comments-submit-button' => 'Wótpósłaś',
	'article-comments-leave-comment-link' => 'Zawóstaj komentar ...',
	'article-comments-invalid-field' => 'Gódnota <nowiki>[$2]</nowiki> za $1 jo njepłaśiwa.',
	'article-comments-required-field' => 'Pólo "$1" jo trěbne.',
	'article-comments-submission-failed' => 'Wótpósłanje komentara jo se njeraźiło',
	'article-comments-failure-reasons' => 'Bóžko wótposłanje twójogo komentara jo se ze {{PLURAL:$1|slědujuceje pśicyna|slědujuceju pśicynowu|slědujucych pśicynow|slědujucych pśicynow}} njeraźiło:',
	'article-comments-no-comments' => 'Bóžko bok "[[$1]]" tuchylu njeakceptěrujo komentary.',
	'article-comments-talk-page-starter' => '<noinclude>Komentary k bokoju „[[$1]]“
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 jo gronił ...',
	'article-comments-summary' => '$1 jo dał komentar  pśez rozšyrjenje ArticleComments',
	'article-comments-submission-succeeded' => 'Wótpósłanje komentara jo se raźiło',
	'article-comments-submission-success' => 'Sy komentar za "[[$1]] wuspěšnje wótpósłał',
	'article-comments-submission-view-all' => 'Móžoš se [[$1|wšykne komentary na toś tom boku]] woglědaś',
	'article-comments-user-is-blocked' => 'Twójo wužywarske konto jo se tuchylu blokěrował pśeśiwo wobźěłowanjoju "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Za komentar jo se njepłaśiwy modus pódał.
Móžne su "plain", "normal" a "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Felujuce mě',
	'article-comments-comment-missing-date-parameter' => 'Felujucy komentarowy datum',
	'article-comments-no-spam' => 'Nanjemjenjej jadno z wótpóskanych pólow jo se ako spam markěrowało.',
	'processcomment' => 'Nastawkowy komentar pśeźěłaś',
);

/** Greek (Ελληνικά)
 * @author Aral
 * @author Glavkos
 */
$messages['el'] = array(
	'article-comments-desc' => 'Επιτρέπει ενότητες σχολίων σε σελίδες περιεχομένου',
	'article-comments-title-string' => 'Τίτλος',
	'article-comments-name-string' => 'Όνομα',
	'article-comments-name-field' => 'Όνομα (απαιτείται):',
	'article-comments-url-field' => 'Ιστότοπος:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Σχόλιο',
	'article-comments-comment-field' => 'Σχόλιο:',
	'article-comments-submit-button' => 'Υποβολή',
	'article-comments-leave-comment-link' => 'Αφήστε ένα σχόλιο ...',
	'article-comments-invalid-field' => 'Η $1 υπό τον όρο <nowiki> [ $2 ] </nowiki> είναι άκυρη.',
	'article-comments-required-field' => '" $1 "πεδίο είναι υποχρεωτικό.',
	'article-comments-submission-failed' => 'H υποβολή Σχόλιου  απέτυχε',
	'article-comments-failure-reasons' => 'Συγνώμη η υποβολή του σχόλιου σας απέτυχε για τους ακόλουθους λόγους {{PLURAL:$1|reason|reasons}}:',
	'article-comments-no-comments' => 'Δυστυχώς η σελίδα "[[$1]]" δεν δέχεται σχόλια αυτή την ώρα',
	'article-comments-talk-page-starter' => '<noinclude>Σχόλια για "[[$1]]"
<comments></comments>
-----__NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 είπε...',
	'article-comments-summary' => 'Σχόλιο από $1 - μέσω του πρόσθετου ArticleComments',
	'article-comments-submission-succeeded' => 'Υποβολή σχολίου ολοκληρώθηκε',
	'article-comments-submission-success' => 'Έχετε υποβάλει με επιτυχία ένα σχόλιο για "[[$1]]"',
	'article-comments-submission-view-all' => 'Μπορείτε να δείτε [[ $1 | όλα τα σχόλια σε αυτήν τη σελίδα]]',
	'article-comments-user-is-blocked' => 'Στον λογαριασμό χρήστη σας αυτή τη στιγμή έχει  μπλοκαριστεί η λειτουργία  επεξεργασίας "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Ο κωδικός που δόθηκε για το σχόλιο είναι άκυρος.
Έγκυροι κωδικοί είναι "plain", "normal" και "wiki"',
	'article-comments-comment-missing-name-parameter' => 'Λείπει το όνομα',
	'article-comments-comment-missing-date-parameter' => 'Λείπει η ημερομηνία του σχολίου',
	'article-comments-no-spam' => 'Τουλάχιστον ένα από τα πεδία υποβλήθηκε έχουν επισημανθεί ως ανεπιθύμητη αλληλογραφία.',
	'processcomment' => 'Επεξεργαστείτε το σχόλιο της σελίδας',
);

/** Esperanto (Esperanto)
 * @author Mihxil
 * @author Tempodivalse
 * @author Yekrats
 */
$messages['eo'] = array(
	'article-comments-title-string' => 'titolo',
	'article-comments-name-string' => 'Nomo',
	'article-comments-name-field' => 'Nomo (deviga):',
	'article-comments-url-field' => 'Retejo:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komenti:',
	'article-comments-comment-field' => 'Komenti:',
	'article-comments-submit-button' => 'Enmeti',
	'article-comments-leave-comment-link' => 'Komenti ...',
	'article-comments-invalid-field' => 'La $1 provizis <nowiki>[$2]</nowiki> estas malvalida.',
	'article-comments-required-field' => '$1 kampo estas deviga.',
	'article-comments-submission-failed' => 'Enmetado de komento malsukcesis',
	'article-comments-failure-reasons' => 'Bedaŭrinde via komentado malsukcesis pro la {{PLURAL:$1|jena kialo|jenaj kialoj}}:',
	'article-comments-no-comments' => 'Pardonu, la paĝo [[$1]] nuntempe ne akceptas komentojn.',
	'article-comments-commenter-said' => '$1 diris ...',
	'article-comments-submission-success' => 'Vi sukcese sendis komenton por "[[$1]]"',
	'article-comments-submission-view-all' => 'Vi povas vidi [[$1|ĉiujn komentojn en tiu paĝo]]',
	'article-comments-comment-missing-name-parameter' => 'Nomo mankas',
	'article-comments-comment-missing-date-parameter' => 'Mankas dato de komento',
	'article-comments-no-spam' => 'Almenaŭ unu el la senditaj kampoj estis markita kiel spamaĵo.',
	'processcomment' => 'Procezi la artikolo-komenton',
);

/** Spanish (Español)
 * @author Danke7
 * @author Fitoschido
 * @author Translationista
 * @author VegaDark
 */
$messages['es'] = array(
	'article-comments-desc' => 'Habilita secciones de comentarios en las páginas de contenido',
	'article-comments-title-string' => 'título',
	'article-comments-name-string' => 'Nombre',
	'article-comments-name-field' => 'Nombre (requerido):',
	'article-comments-url-field' => 'Sitio web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comentario',
	'article-comments-comment-field' => 'Comentario:',
	'article-comments-submit-button' => 'Enviar',
	'article-comments-leave-comment-link' => 'Deja un comentario...',
	'article-comments-invalid-field' => 'El $1 proporcionado <nowiki>[$2]</nowiki> no es válido.',
	'article-comments-required-field' => 'El campo «$1» es obligatorio.',
	'article-comments-submission-failed' => 'El envío del comentario ha fallado',
	'article-comments-failure-reasons' => 'Lo sentimos, tu comentario no pudo enviarse por {{PLURAL:$1|la siguiente razón|las siguientes razones}}:',
	'article-comments-no-comments' => 'Lo sentimos, la página «[[$1]]» no acepta comentarios en este momento.',
	'article-comments-talk-page-starter' => '<noinclude>Comentarios en «[[$1]]»
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 dijo...',
	'article-comments-summary' => 'Comentario proporcionado por $1 - a través de la extensión ArticleComments',
	'article-comments-submission-succeeded' => 'Envío del comentario realizado con éxito',
	'article-comments-submission-success' => 'Has enviado exitosamente un comentario sobre «[[$1]]»',
	'article-comments-submission-view-all' => 'Puedes ver [[$1|todos los comentarios sobre esa página]]',
	'article-comments-user-is-blocked' => 'Tu cuenta de usuario está bloqueada para editar «[[$1]]».',
	'article-comments-comment-bad-mode' => 'Se proporcionó un modo no válido para comentar.
Los disponibles son «plain», «normal» y «wiki».',
	'article-comments-comment-missing-name-parameter' => 'Falta el nombre',
	'article-comments-comment-missing-date-parameter' => 'Falta la fecha del comentario',
	'article-comments-no-spam' => 'Al menos uno de los campos enviados se ha marcado como spam.',
	'processcomment' => 'Procesar el comentario sobre la página',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'article-comments-title-string' => 'izenburua',
	'article-comments-name-string' => 'Izena',
	'article-comments-name-field' => 'Izena (beharrezkoa):',
	'article-comments-url-field' => 'Webgunea:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Iruzkina',
	'article-comments-comment-field' => 'Iruzkina:',
	'article-comments-submit-button' => 'Bidali',
	'article-comments-leave-comment-link' => 'Iruzkina egin ...',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Mjbmr
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'article-comments-title-string' => 'عنوان',
	'article-comments-name-string' => 'نام',
	'article-comments-name-field' => 'نام (اجباری):',
	'article-comments-url-field' => 'تارنما:',
	'article-comments-url-string' => 'نشانی اینترنتی',
	'article-comments-comment-string' => 'توضیح',
	'article-comments-comment-field' => 'توضیح:',
	'article-comments-submit-button' => 'ارسال',
	'article-comments-leave-comment-link' => 'ارسال نظر ...',
	'article-comments-commenter-said' => '$1 گفت ...',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nedergard
 * @author Nike
 * @author Olli
 */
$messages['fi'] = array(
	'article-comments-desc' => 'Ottaa kommenttikohdat käyttöön sisältösivuilla',
	'article-comments-title-string' => 'otsikko',
	'article-comments-name-string' => 'Nimi',
	'article-comments-name-field' => 'Nimi (vaaditaan):',
	'article-comments-url-field' => 'Kotisivu:',
	'article-comments-url-string' => 'Osoite',
	'article-comments-comment-string' => 'Kommentti',
	'article-comments-comment-field' => 'Kommentti:',
	'article-comments-submit-button' => 'Lähetä',
	'article-comments-leave-comment-link' => 'Jätä kommentti...',
	'article-comments-invalid-field' => '$1 antoi <nowiki>[$2]</nowiki>, joka ei kelpaa.',
	'article-comments-required-field' => 'Kenttä »$1» on pakollinen.',
	'article-comments-submission-failed' => 'Kommentin lähety epäonnistui',
	'article-comments-failure-reasons' => 'Kommenttisi lähetys epäonnistui {{PLURAL:$1|seuraavasta syystä|seuraavista syistä}} johtuen:',
	'article-comments-no-comments' => 'Valitettavasti sivulle [[$1]] ei sallita uusia kommentteja tällä hetkellä.',
	'article-comments-talk-page-starter' => '<noinclude>Kommentit sivulla [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 sanoi...',
	'article-comments-summary' => 'Kommentin antoi $1 - ArticleComments-lisäosan avulla',
	'article-comments-submission-succeeded' => 'Kommentin lähetys onnistui',
	'article-comments-submission-success' => 'Kommentin lähetys sivulle [[$1]] onnistui',
	'article-comments-submission-view-all' => 'Voit [[$1|katsoa kaikki sivun kommentit]]',
	'article-comments-user-is-blocked' => 'Käyttäjätunnuksesi ei tällä hetkellä voi muokata sivua [[$1]].',
	'article-comments-comment-bad-mode' => 'Kommentille annettiin kelpaamaton tila.
Saatavilla ovat "plain", "normal" ja "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Puuttuva nimi',
	'article-comments-comment-missing-date-parameter' => 'Puuttuva kommentointipäivä',
	'article-comments-no-spam' => 'Vähintään yksi lähetetyistä kentistä merkittiin roskapostiksi.',
	'processcomment' => 'Käsittele sivun kommenttia',
);

/** French (Français)
 * @author Peter17
 * @author Sherbrooke
 * @author Verdy p
 * @author 青子守歌
 */
$messages['fr'] = array(
	'article-comments-desc' => 'Active les sections de commentaires sur les pages d’articles',
	'article-comments-title-string' => 'titre',
	'article-comments-name-string' => 'Nom',
	'article-comments-name-field' => 'Nom (obligatoire) :',
	'article-comments-url-field' => 'Site web :',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Commentaire',
	'article-comments-comment-field' => 'Commentaire :',
	'article-comments-submit-button' => 'Soumettre',
	'article-comments-leave-comment-link' => 'Ajouter un commentaire...',
	'article-comments-invalid-field' => 'Le $1 fourni <nowiki>[$2]</nowiki> est invalide.',
	'article-comments-required-field' => 'Le champ $1 est obligatoire.',
	'article-comments-submission-failed' => 'L’envoi du commentaire a échoué',
	'article-comments-failure-reasons' => 'Désolé, l’envoi de votre commentaire a échoué pour {{PLURAL:$1|la raison suivante|les raisons suivantes}} :',
	'article-comments-no-comments' => 'Désolé, l’article « [[$1]] » n’accepte pas les commentaires pour le moment.',
	'article-comments-talk-page-starter' => '<noinclude>Commentaires sur [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 a dit...',
	'article-comments-summary' => 'Commentaires apportés par $1 — via l’extension ArticleComments',
	'article-comments-submission-succeeded' => 'L’envoi du commentaire a réussi',
	'article-comments-submission-success' => 'Vous avez envoyé avec succès un commentaire sur « [[$1]] »',
	'article-comments-submission-view-all' => 'Vous pouvez voir tous les commentaires sur cet article [[$1|ici]]',
	'article-comments-user-is-blocked' => 'Votre compte utilisateur est actuellement bloqué en écriture sur « [[$1]] ».',
	'article-comments-comment-bad-mode' => 'Le mode fourni pour le commentaire est invalide.
Les modes disponibles sont «plain», « normal » et « wiki ».',
	'article-comments-comment-missing-name-parameter' => 'Nom manquant',
	'article-comments-comment-missing-date-parameter' => 'Date du commentaire manquante',
	'article-comments-no-spam' => 'Au moins un des champs soumis a été marqué comme spam.',
	'processcomment' => 'Traitement du commentaire sur l’article',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'article-comments-desc' => 'Active les sèccions de comentèros sur les pâges de contegnu.',
	'article-comments-title-string' => 'titro',
	'article-comments-name-string' => 'Nom',
	'article-comments-name-field' => 'Nom (oblegatouèro) :',
	'article-comments-url-field' => 'Seto vouèbe :',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comentèro',
	'article-comments-comment-field' => 'Comentèro :',
	'article-comments-submit-button' => 'Sometre',
	'article-comments-leave-comment-link' => 'Apondre un comentèro ...',
	'article-comments-invalid-field' => 'Lo $1 balyê <nowiki>[$2]</nowiki> est envalido.',
	'article-comments-required-field' => 'Lo champ « $1 » est oblegatouèro.',
	'article-comments-submission-failed' => 'L’èxpèdicion du comentèro at pas reussia',
	'article-comments-failure-reasons' => 'Dèsolâ, l’èxpèdicion de voutron comentèro at pas reussia por {{PLURAL:$1|ceta rêson|cetes rêsons}} :',
	'article-comments-no-comments' => 'Dèsolâ, la pâge « [[$1]] » accèpte pas los comentèros por lo moment.',
	'article-comments-talk-page-starter' => '<noinclude>Comentèros sur « [[$1]] »
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 at dét ...',
	'article-comments-summary' => 'Comentèros aportâs per $1 — avouéc l’èxtension ArticleComments',
	'article-comments-submission-succeeded' => 'L’èxpèdicion du comentèro at reussia',
	'article-comments-submission-success' => 'Vos éd mandâ avouéc reusséta un comentèro sur « [[$1]] »',
	'article-comments-submission-view-all' => 'Vos pouede vêre tôs los comentèros sur cela pâge [[$1|ique]]',
	'article-comments-user-is-blocked' => 'Ora, voutron compto usanciér est blocâ en ècritura sur « [[$1]] ».',
	'article-comments-comment-bad-mode' => 'La fôrma balyê por lo comentèro est envalida.
Les fôrmes disponibles sont « plain », « normal » et « wiki ».',
	'article-comments-comment-missing-name-parameter' => 'Nom manquent',
	'article-comments-comment-missing-date-parameter' => 'Dâta du comentèro manquenta',
	'article-comments-no-spam' => 'U muens yon des champs somês at étâ marcâ coment spame.',
	'processcomment' => 'Trètament du comentèro sur la pâge',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'article-comments-desc' => 'Activa os comentarios nas seccións dos artigos',
	'article-comments-title-string' => 'título',
	'article-comments-name-string' => 'Nome',
	'article-comments-name-field' => 'Nome (obrigatorio):',
	'article-comments-url-field' => 'Páxina web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comentario',
	'article-comments-comment-field' => 'Comentario:',
	'article-comments-submit-button' => 'Enviar',
	'article-comments-leave-comment-link' => 'Deixe un comentario...',
	'article-comments-invalid-field' => 'O $1 proporcionado <nowiki>[$2]</nowiki> é inválido.',
	'article-comments-required-field' => 'O campo "$1" é obrigatorio.',
	'article-comments-submission-failed' => 'Fallou o envío do comentario',
	'article-comments-failure-reasons' => 'Sentímolo, o seu comentario non puido enviarse {{PLURAL:$1|polo seguinte motivo|polos seguintes motivos}}:',
	'article-comments-no-comments' => 'Sentímolo, nestes intres a páxina "[[$1]]" non acepta comentarios.',
	'article-comments-talk-page-starter' => '<noinclude>Comentarios sobre "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 dixo...',
	'article-comments-summary' => 'Comentario achegado por $1 mediante a extensión ArticleComments',
	'article-comments-submission-succeeded' => 'O comentario enviouse correctamente',
	'article-comments-submission-success' => 'O seu comentario sobre "[[$1]]" enviouse correctamente',
	'article-comments-submission-view-all' => 'Pode ollar [[$1|todos os comentarios sobre a páxina]]',
	'article-comments-user-is-blocked' => 'A súa conta está bloqueada e non pode editar "[[$1]]".',
	'article-comments-comment-bad-mode' => 'O modo fornecido para o comentario non é válido.
Os modos dispoñibles son "plain", "normal" e "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Falta o nome',
	'article-comments-comment-missing-date-parameter' => 'Fata a data do comentario',
	'article-comments-no-spam' => 'Un dos campos enviados marcouse como spam.',
	'processcomment' => 'Proceso de comentario dun artigo',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'article-comments-desc' => 'Macht s Kommentiere vu Inhaltssyte megli',
	'article-comments-title-string' => 'Titel',
	'article-comments-name-string' => 'Name',
	'article-comments-name-field' => 'Name (brucht s):',
	'article-comments-url-field' => 'Websyte:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Aamerkig',
	'article-comments-comment-field' => 'Aamerkig:',
	'article-comments-submit-button' => 'Ibertrage',
	'article-comments-leave-comment-link' => 'E Aamerkig hinterloo …',
	'article-comments-invalid-field' => 'D Yygab <nowiki>[$2]</nowiki> as $1 isch nit giltig.',
	'article-comments-required-field' => '$1 isch e Pflichtfäld.',
	'article-comments-submission-failed' => 'D Ibertragig vu dr Aamerkig isch fähl gschlaa',
	'article-comments-failure-reasons' => 'Excusez, d Ibertragig vu Dyyre Aamerkig isch us {{PLURAL:$1|däm Grund|däne Grind}} fähl gschlaa:',
	'article-comments-no-comments' => 'Fir d Syte „[[$1]]“ chenne zurzyt no kei Aamerkige abgee wäre.',
	'article-comments-talk-page-starter' => '<noinclude>Aamerkige zue dr Syte „[[$1]]“
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 het gmeint …',
	'article-comments-summary' => 'Aameerkig vu $1 - iber d Programmerwyterig ArticleComments.',
	'article-comments-submission-succeeded' => 'D Ibertragig vu dr Aamerkig isch erfolgryych gsi',
	'article-comments-submission-success' => 'Du hesch erfolgryych en Aamerkig fir d Syte „[[$1]]“ abgee.',
	'article-comments-submission-view-all' => 'Du chasch [[$1|alli Aamerkige zue däre Syte]] bschaue',
	'article-comments-user-is-blocked' => 'Du derfsch d Syte „[[$1]]“ zurzyt nit bearbeite.',
	'article-comments-comment-bad-mode' => 'Fir d Aamerkige isch e uugiltige Modus aagee wore.
Megli sin d Modi „plain“, „normal“ un „wiki“.',
	'article-comments-comment-missing-name-parameter' => 'Dr Name fählt',
	'article-comments-comment-missing-date-parameter' => 'S Datum fählt',
	'article-comments-no-spam' => 'Zmindescht ei Aagab isch as Spam idäntifiziert wore.',
	'processcomment' => 'Aamerkige zue Artikel verschaffe',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'article-comments-desc' => 'הפעלה של הוספת פסקאות של הערות בדפי תוכן',
	'article-comments-title-string' => 'כותרת',
	'article-comments-name-string' => 'שם',
	'article-comments-name-field' => 'שם (נחוץ):',
	'article-comments-url-field' => 'אתר:',
	'article-comments-url-string' => 'כתובת',
	'article-comments-comment-string' => 'הערה',
	'article-comments-comment-field' => 'הערה:',
	'article-comments-submit-button' => 'שליחה',
	'article-comments-leave-comment-link' => 'הוספת תגובה ...',
	'article-comments-invalid-field' => 'ה$1 <nowiki>[$2]</nowiki> אינה תקינה.',
	'article-comments-required-field' => 'חוב להזין שדה "$1".',
	'article-comments-submission-failed' => 'שליחת הערה נכשלה',
	'article-comments-failure-reasons' => 'סליחה, שליחת ההערה נכשלה {{PLURAL:$1|מהסיבה הבאה|מהסיבות הבאות}}',
	'article-comments-no-comments' => 'סליחה, הדף "[[$1]]" אינו מקבל תגובות עכשיו.',
	'article-comments-talk-page-starter' => '<noinclude>הערות על "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => 'הערה של $1...',
	'article-comments-summary' => 'הערה של $1 – דרך הרחבת ArticleComments',
	'article-comments-submission-succeeded' => 'שליחת ההערה הצליחה',
	'article-comments-submission-success' => 'שלחתם בהצלחה הערה לדף "[[$1]]"',
	'article-comments-submission-view-all' => 'אתם יכולים להציג את [[$1|כל ההערות על דף זה]]',
	'article-comments-user-is-blocked' => 'חשבון המשתמש שלכם חסום עכשיו לעריכת "[[$1]]".',
	'article-comments-comment-bad-mode' => 'מצב לא תקין הוגדר להערה.
המצבים הזמינים הם "חלק", "רגיל" ו"ויקי".',
	'article-comments-comment-missing-name-parameter' => 'שם חסר',
	'article-comments-comment-missing-date-parameter' => 'תאריך ההערה חסר',
	'article-comments-no-spam' => 'לפחות אחד מהשדות שנשלחו סומן כזבל.',
	'processcomment' => 'עיבוד הערה לדף',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'article-comments-desc' => 'Zmóžnja komentarowy wotrězki na wobsahowych stronach',
	'article-comments-title-string' => 'titul',
	'article-comments-name-string' => 'Mjeno',
	'article-comments-name-field' => 'Mjeno (trěbne)',
	'article-comments-url-field' => 'Websydło:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komentar',
	'article-comments-comment-field' => 'Komentar:',
	'article-comments-submit-button' => 'Wotpósłać',
	'article-comments-leave-comment-link' => 'Spisaj komentar ...',
	'article-comments-invalid-field' => 'Hódnota <nowiki>[$2]</nowiki> za $1 je njepłaćiwa.',
	'article-comments-required-field' => 'Polo "$1" je trěbne.',
	'article-comments-submission-failed' => 'Słanje komentara je so njeporadźiło',
	'article-comments-failure-reasons' => 'Bohužel je so słanje twojeho komentara {{PLURAL:$1|slědowaceje přičiny|slědowaceju přinčinow|slědowacych přičinow|slědoacych přičinow}} dla njeporadźiło:',
	'article-comments-no-comments' => 'Bohužel strona "[[$1]]" tuchwilu žane komentary njeakceptuje.',
	'article-comments-talk-page-starter' => '<noinclude>Komentary k "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 praješe ...',
	'article-comments-summary' => 'Komentar je so wot $1 přez rozšěrjenje ArticleComments přepodał',
	'article-comments-submission-succeeded' => 'Komentar wuspěšnje wotpósłany.',
	'article-comments-submission-success' => 'Sy wuspěšnje komentar za "[[$1]]" wotpósłał',
	'article-comments-submission-view-all' => 'Móžeš sej [[$1|wšě komentary k tej stronje]] wobhladać',
	'article-comments-user-is-blocked' => 'Twoje wužiwarske konto je tuchwilu za wobdźěłowanje strony "[[$1]]" zablokowane.',
	'article-comments-comment-bad-mode' => 'Njepłaćiwy modus za komentar podaty.
K dispoziciji steja "plain", "normal" a "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Falowace mjeno',
	'article-comments-comment-missing-date-parameter' => 'Falowacy komentarowy datum',
	'article-comments-no-spam' => 'Znajmjeńša jedne z wotpósłanych polow bu jako spam woznamjenjene.',
	'processcomment' => 'Komentary nastawkow předźěłać',
);

/** Hungarian (Magyar)
 * @author BáthoryPéter
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'article-comments-desc' => 'Megjegyzések szakasz a tartalommal rendelkező lapokra',
	'article-comments-title-string' => 'cím',
	'article-comments-name-string' => 'Név',
	'article-comments-name-field' => 'Név (kötelező):',
	'article-comments-url-field' => 'Weboldal:',
	'article-comments-url-string' => 'URL-cím',
	'article-comments-comment-string' => 'Megjegyzés',
	'article-comments-comment-field' => 'Megjegyzés:',
	'article-comments-submit-button' => 'Elküldés',
	'article-comments-leave-comment-link' => 'Hozzászólás írása ...',
	'article-comments-invalid-field' => 'A megadott $1 <nowiki>[$2]</nowiki> érvénytelen.',
	'article-comments-required-field' => '$1 mező kitöltése kötelező.',
	'article-comments-submission-failed' => 'A hozzászólás elküldése nem sikerült',
	'article-comments-failure-reasons' => 'A hozzászólás elküldése nem sikerült a következő {{PLURAL:$1|ok|okok}} miatt:',
	'article-comments-no-comments' => 'Sajnáljuk, a(z) „[[$1]]” laphoz jelenleg nem lehet hozzászólásokat írni.',
	'article-comments-talk-page-starter' => '<noinclude>Hozzászólások a(z) [[$1]] laphoz
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 írta …',
	'article-comments-submission-succeeded' => 'A hozzászólás elküldése sikerült',
	'article-comments-submission-success' => 'Sikeresen hozzászóltál a(z) „[[$1]]” című laphoz',
	'article-comments-submission-view-all' => '[[$1|A lap összes hozzászólásának]] megtekintése',
	'article-comments-comment-missing-name-parameter' => 'Hiányzik a név',
	'article-comments-comment-missing-date-parameter' => 'Hiányzik a hozzászólás dátuma',
	'article-comments-no-spam' => 'Az elküldött mezők legalább egyike spamnek lett jelölve.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'article-comments-desc' => 'Activa sectiones de commentos in paginas de articulos',
	'article-comments-title-string' => 'titulo',
	'article-comments-name-string' => 'Nomine',
	'article-comments-name-field' => 'Nomine (obligatori):',
	'article-comments-url-field' => 'Sito web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Commento',
	'article-comments-comment-field' => 'Commento:',
	'article-comments-submit-button' => 'Submitter',
	'article-comments-leave-comment-link' => 'Lassar un commento ...',
	'article-comments-invalid-field' => 'Le $1 fornite <nowiki>[$2]</nowiki> es invalide.',
	'article-comments-required-field' => 'Le campo $1 es obligatori.',
	'article-comments-submission-failed' => 'Submission de commento fallite',
	'article-comments-failure-reasons' => 'Regrettabilemente, le submission de tu commento ha fallite pro le sequente {{PLURAL:$1|motivo|motivos}}:',
	'article-comments-no-comments' => 'Regrettabilemente, le articulo "[[$1]]" non accepta commentos pro le momento.',
	'article-comments-talk-page-starter' => '<noinclude>Commentos super [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 diceva ...',
	'article-comments-summary' => 'Commento fornite per $1 - via le extension ArticleComments',
	'article-comments-submission-succeeded' => 'Submission de commento succedite',
	'article-comments-submission-success' => 'Tu ha submittite un commento super "[[$1]]" con successo.',
	'article-comments-submission-view-all' => 'Tu pote vider [[$1|hic]] tote le commentos super iste articulo',
	'article-comments-user-is-blocked' => 'Tu conto de usator es actualmente blocate contra modificar "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Modo invalide date pro commento.
Disponibile es "plain", "normal" e "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Nomine mancante',
	'article-comments-comment-missing-date-parameter' => 'Data de commento mancante',
	'article-comments-no-spam' => 'Al minus un del campos submittite esseva marcate como spam.',
	'processcomment' => 'Tractar commento de articulo',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'article-comments-desc' => 'Mengaktifkan bagian komentar pada halaman konten',
	'article-comments-title-string' => 'judul',
	'article-comments-name-string' => 'Nama',
	'article-comments-name-field' => 'Nama (wajib):',
	'article-comments-url-field' => 'Situs web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komentar',
	'article-comments-comment-field' => 'Komentar:',
	'article-comments-submit-button' => 'Kirim',
	'article-comments-leave-comment-link' => 'Berikan komentar ...',
	'article-comments-invalid-field' => '$1 <nowiki>[$2]</nowiki> yang diberikan tidak sah.',
	'article-comments-required-field' => '"$1" harus diisi.',
	'article-comments-submission-failed' => 'Pengiriman komentar gagal',
	'article-comments-failure-reasons' => 'Maaf, kiriman komentar Anda gagal karena {{PLURAL:$1|alasan|alasan}} berikut:',
	'article-comments-no-comments' => 'Maaf, halaman "[[$1]]" tidak menerima komentar saat ini.',
	'article-comments-talk-page-starter' => '<noinclude>Komentar pada "[[$1]]"
<comments />
-----__NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 berkata ...',
	'article-comments-summary' => 'Komentar diberikan oleh $1 - melalui ekstensi ArticleComments',
	'article-comments-submission-succeeded' => 'Pengiriman komentar berhasil',
	'article-comments-submission-success' => 'Anda telah berhasil mengirimkan komentar untuk "[[$1]]"',
	'article-comments-submission-view-all' => 'Anda dapat melihat [[$1|semua komentar pada halaman tersebut]]',
	'article-comments-user-is-blocked' => 'Akun pengguna Anda saat ini diblokir dari mengedit "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Modus tidak sah telah diberikan untuk komentar.
Pilihan yang tersedia adalah "plain", "normal", dan "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Nama tidak ada',
	'article-comments-comment-missing-date-parameter' => 'Tanggal komentar tidak ada',
	'article-comments-no-spam' => 'Setidaknya salah satu isian yang dimasukkan ditandai sebagai spam.',
	'processcomment' => 'Proses komentar artikel',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Minerva Titani
 * @author Rippitippi
 */
$messages['it'] = array(
	'article-comments-title-string' => 'titolo',
	'article-comments-name-string' => 'Nome',
	'article-comments-name-field' => 'Nome (obbligatorio):',
	'article-comments-url-field' => 'Sito web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Commento',
	'article-comments-comment-field' => 'Commento:',
	'article-comments-submit-button' => 'Invia',
	'article-comments-leave-comment-link' => 'Lascia un commento ...',
	'article-comments-required-field' => 'Il campo " $1 " è obbligatorio.',
	'article-comments-submission-failed' => 'Invio commento fallito',
	'article-comments-failure-reasons' => "Siamo spiacenti, l'inserimento del vostro commento non è riuscito per {{PLURAL:$1|il seguente motivo|i seguenti motivi}}",
	'article-comments-no-comments' => 'Siamo spiacenti, la pagina "[[$1]]" non accetta commenti in questo momento.',
	'article-comments-commenter-said' => '$1 ha detto ...',
	'article-comments-submission-succeeded' => 'Invio commento riuscito',
);

/** Japanese (日本語)
 * @author 青子守歌
 */
$messages['ja'] = array(
	'article-comments-desc' => 'コンテンツのページで、コメント節を有効化する',
	'article-comments-title-string' => '題名',
	'article-comments-name-string' => '名前',
	'article-comments-name-field' => '名前（必須）：',
	'article-comments-url-field' => 'ウェブサイト：',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'コメント',
	'article-comments-comment-field' => 'コメント：',
	'article-comments-submit-button' => '送信',
	'article-comments-leave-comment-link' => 'コメントを残す・・・',
	'article-comments-invalid-field' => '$1に入力された値<nowiki>[$2]</nowiki>が不正です。',
	'article-comments-required-field' => '$1項目は必須です。',
	'article-comments-submission-failed' => 'コメント投稿に失敗しました',
	'article-comments-failure-reasons' => '申し訳ありませんが、コメントの投稿が、次の{{PLURAL:$1|理由}}により失敗しました：',
	'article-comments-no-comments' => '申し訳ありませんが、ページ「[[$1]]」は、現在、コメントの投稿を受け付けていません。',
	'article-comments-talk-page-starter' => '<noinclude>[[$1]]へのコメント
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1いわく・・・',
	'article-comments-summary' => '$1によるコメント（記事コメント拡張機能による）',
	'article-comments-submission-succeeded' => 'コメント投稿に成功しました',
	'article-comments-submission-success' => '「[[$1]]」へのコメントの投稿に成功しました',
	'article-comments-submission-view-all' => '[[$1|そのページのすべてのコメント]]を見ることができます',
	'article-comments-user-is-blocked' => '利用者アカウントが、現在、「[[$1]]」の編集をブロックされています。',
	'article-comments-comment-bad-mode' => 'コメントに対して、無効な形式です。
「plain」「normal」あるいは「wiki」が有効です。',
	'article-comments-comment-missing-name-parameter' => '名前がありません',
	'article-comments-comment-missing-date-parameter' => 'コメントの日付がありません',
	'article-comments-no-spam' => '投稿された項目のうち、少なくとも1つがスパムとしてフラグが設定されました。',
	'processcomment' => '記事コメントの処理',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'article-comments-title-string' => 'ចំណងជើង',
	'article-comments-name-string' => 'ឈ្មោះ',
	'article-comments-name-field' => 'ឈ្មោះ (ចាំបាច់)៖',
	'article-comments-url-field' => 'វិបសាយ៖',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'យោបល់',
	'article-comments-comment-field' => 'យោបល់៖',
	'article-comments-submit-button' => 'ដាក់ស្នើ',
	'article-comments-leave-comment-link' => 'បញ្ចេញយោបល់...',
	'article-comments-required-field' => 'ផ្នែក "$1" ត្រូវការជាចាំបាច់។',
	'article-comments-submission-failed' => 'ការដាក់ស្នើយោបល់មិនបានសំរេច',
	'article-comments-failure-reasons' => 'សូមអភ័យទោស។ ការដាក់ស្នើយោបល់របស់អ្នកមិនបានសំរេចទេដោយសារមូលហេតុ៖',
	'article-comments-no-comments' => 'សូមអភ័យទោស។ ទំព័រ "[[$1]]" មិនទទួលយកយោបល់ណាមួយនាពេលនេះទេ។',
	'article-comments-talk-page-starter' => '<noinclude>យោបល់នៅលើ "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 មានយោបល់ថា ...',
	'article-comments-submission-succeeded' => 'ការដាក់ស្នើយោបល់បានសំរេច',
	'article-comments-submission-success' => 'អ្នកបានដាក់ស្នើយោបល់អំពី "[[$1]]" បានសំរេចហើយ',
	'article-comments-submission-view-all' => 'អ្នកអាចមើល[[$1|យោបល់អំពីទំព័រនេះទាំងអស់]]',
	'article-comments-user-is-blocked' => 'គណនីអ្នកប្រើប្រាស់របស់អ្នក​កំពុងស្ថិតក្រោមការរាំងខ្ទប់មិនអោយកែប្រែ "[[$1]]"។',
	'article-comments-comment-missing-name-parameter' => 'ខ្វះឈ្មោះ',
	'article-comments-comment-missing-date-parameter' => 'ខ្វះកាលបរិច្ឆេទ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'article-comments-desc' => 'Määt Aanmerkunge op Sigge müjjelesch.',
	'article-comments-title-string' => 'Övverschreff',
	'article-comments-name-string' => 'Naam',
	'article-comments-name-field' => 'Naam (kam_mer nit fottlohße):',
	'article-comments-url-field' => 'Websait:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Aanmerkung',
	'article-comments-comment-field' => 'Enndraach för en et Logboch:',
	'article-comments-submit-button' => 'Faßhallde!',
	'article-comments-leave-comment-link' => 'Donn en Aanmerkung maache&nbsp;…',
	'article-comments-invalid-field' => 'De aanjejovve $1 <nowiki>[$2]</nowiki> es nix wäät.',
	'article-comments-required-field' => '$1 moß aanjejovve sin.',
	'article-comments-submission-failed' => 'En Aanmerkung ze maache hät nit jeflup',
	'article-comments-failure-reasons' => 'En Aanmerkung ze maache hät nit jeflup, weil:{{PLURAL:$1||}}:',
	'article-comments-no-comments' => 'För de Sigg „[[$1]]“ künne em Momang kein Aanmerkunge jemaat wääde.',
	'article-comments-talk-page-starter' => '<noinclude>Aanmerkunge op „[[$1]]“
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => 'Ene „$1“ hät jeschrevve&nbsp;…',
	'article-comments-summary' => 'Ene „$1“ hät en Aanmerkung jeschrevve övver et Zohsaz_Programm <i lang="en">ArticleComments</i>.',
	'article-comments-submission-succeeded' => 'Di Aanmerkung es jemaat',
	'article-comments-submission-success' => 'Do häs en Aanmerkung för di Sigg „[[$1]]“ jemaat.',
	'article-comments-submission-view-all' => 'Do kanns Der [[$1|alle Aanmerkunge op dä Sigg]] beluore.',
	'article-comments-user-is-blocked' => 'Do darfs di Sigg „[[$1]]“ em Momang nit ändere.',
	'article-comments-comment-bad-mode' => 'För di Aanmerkung wood ene unbikannte Zoot Täx aanjejovve.
Müjjelesh sin bloß „<code lang="en">plain</code>“, „<code lang="en">normal</code>“, un „<code lang="en">wiki</code>“.',
	'article-comments-comment-missing-name-parameter' => 'Dä Name fählt',
	'article-comments-comment-missing-date-parameter' => 'Et Dattum fählt',
	'article-comments-no-spam' => 'En winnishsdens eine vun dä Einjabe wohd SPAM jefonge.',
	'processcomment' => 'Ben di Aanmerkung aam verärbeide',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'article-comments-title-string' => 'sernav',
	'article-comments-name-string' => 'Nav',
	'article-comments-url-field' => 'Malper:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'article-comments-desc' => 'Erméiglecht Abschnitter mat Bemierkungen op Artikelsäiten',
	'article-comments-title-string' => 'Titel',
	'article-comments-name-string' => 'Numm',
	'article-comments-name-field' => 'Numm (obligatoresch):',
	'article-comments-url-field' => 'Internetsite:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Bemierkung',
	'article-comments-comment-field' => 'Bemierkung:',
	'article-comments-submit-button' => 'Schécken',
	'article-comments-leave-comment-link' => 'Eng Bemierkung derbäisetzen ...',
	'article-comments-invalid-field' => 'Den $1 <nowiki>[$2]</nowiki> deen Dir uginn hutt ass net valabel.',
	'article-comments-required-field' => "D'Feld $1 ass obligatoresch.",
	'article-comments-submission-failed' => "D'Schécke vun der Bemierkung huet net fonctionnéiert",
	'article-comments-failure-reasons' => 'Pardon, Är Bemierkung huet aus {{PLURAL:$1|dësem Grond|dëse Grënn}} net fonctionnéiert:',
	'article-comments-no-comments' => 'Pardon, d\'Säit "[[$1]]" hëlt elo keng Bemierkungen un.',
	'article-comments-talk-page-starter' => '<noinclude>Bemierkungen iwwer [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 huet gesot ...',
	'article-comments-summary' => "Bemierkung vum $1 - iwwert d'Erweiderung ArticleComments",
	'article-comments-submission-succeeded' => "D'Bemierkung ass gespäichert",
	'article-comments-submission-success' => 'Är Bemierkung fir [[$1]] ass gespäichert.',
	'article-comments-submission-view-all' => 'Dir kënnt [[$1|all Bemierkungen zu dëser Säit]] kucken',
	'article-comments-user-is-blocked' => 'Äre Benotzerkont ass elo gespaart fir "[[$1]]" z\'änneren.',
	'article-comments-comment-bad-mode' => 'Net valabele Mode ugi fir d\'Bemierkung.
Méiglech sinn "plain", "normal" a "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Den Numm feelt',
	'article-comments-comment-missing-date-parameter' => 'Datum vun der Bemierkung feelt',
	'article-comments-no-spam' => 'Mindestens eent vun de geschéckte Felder gouf als Spam markéiert.',
	'processcomment' => "D'Bemierkung zum Artikel gëtt verschafft",
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'article-comments-desc' => "Maak 't mäögelik óm opmerkinge te plaatse bie paragrafe op pagina's",
	'article-comments-title-string' => 'titel',
	'article-comments-name-string' => 'Naam:',
	'article-comments-name-field' => 'Naam (verplich):',
	'article-comments-url-field' => 'Website:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Opmirking',
	'article-comments-comment-field' => 'Opmirking:',
	'article-comments-submit-button' => 'Opsjlaon',
	'article-comments-leave-comment-link' => 'Opmirking plaatse...',
	'article-comments-invalid-field' => 'De opgegaeve $1 <nowiki>[$2]</nowiki> is ongeljig.',
	'article-comments-required-field' => "'t Veld $1 is verplich.",
	'article-comments-submission-failed' => "'t Opsjlaon van de opmirking is mislök.",
	'article-comments-failure-reasons' => "'t Opsjlaon van dien opmirking is mislök óm de volgende {{PLURAL:$1|raej|raej}}:",
	'article-comments-no-comments' => 'Bie de pagina "[[$1]]" kinne op \'t memènt gein opmirkinge geplaats waere.',
	'article-comments-talk-page-starter' => '<noinclude>Opmirkinge bie [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 sjreef ...',
	'article-comments-summary' => 'Opmirking van $1',
	'article-comments-submission-succeeded' => 'De opmirking is opgesjlage',
	'article-comments-submission-success' => 'De höbs \'n opmirking bie "[[$1]]" opgesjlage',
	'article-comments-submission-view-all' => 'De kans [[$1|alle opmirkinge bie die pagina]] bekieke',
	'article-comments-user-is-blocked' => 'Dien gebroekers-account is op dit memènt geblokeerd veur \'t bewirke vaan "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Dao is \'n ongeljige modus opgegaeve veur de opmirking.
Besjikbaar zien "plain", "normal" en "wiki".',
	'article-comments-comment-missing-name-parameter' => 'De naam mis',
	'article-comments-comment-missing-date-parameter' => 'De datum veur de opmirking mis',
	'article-comments-no-spam' => "Tenminste ein van de opgesjlage velde had 'n inhauwd dee es spam is aangemerk.",
	'processcomment' => 'Opmirking verwirke',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Ignas693
 */
$messages['lt'] = array(
	'article-comments-desc' => 'Įgalina komentarą skirsnius turinio puslapiuose',
	'article-comments-title-string' => 'Kreipinys',
	'article-comments-name-string' => 'Vardas',
	'article-comments-name-field' => 'Vardas (privaloma):',
	'article-comments-url-field' => 'Tinklalapis:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komentaras',
	'article-comments-comment-field' => 'Komentaras:',
	'article-comments-submit-button' => 'Siųsti',
	'article-comments-leave-comment-link' => 'Palikite komentarą ...',
	'article-comments-invalid-field' => 'Į  $1  pateikti <nowiki>[ $2 ]</nowiki> yra neleistinas.',
	'article-comments-required-field' => '" $1 "laukas yra būtinas.',
	'article-comments-submission-failed' => 'Komentarų pateikimo, nepavyko',
	'article-comments-failure-reasons' => 'Deja, jūsų komentarų pateikimo nepavyko, po  {{PLURAL:$1| reason|reasons}}:',
	'article-comments-no-comments' => 'Atsiprašome, puslapio "[[ $1 ]]" yra nepriimami pastabų šiuo metu.',
	'article-comments-talk-page-starter' => '<noinclude>Komentarai į "[[ $1 ]]"
<comments></comments>
------KURIŲ __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 sakė ...',
	'article-comments-summary' => 'Komentaras pateikė  $1  - per ArticleComments pratęsimas',
	'article-comments-submission-succeeded' => 'Komentarų pateikimo, pavyko',
	'article-comments-submission-success' => 'Jūs sėkmingai pateikė komentaras apie "[[ $1 ]]"',
	'article-comments-submission-view-all' => 'Galite peržiūrėti [[ $1 |all pastabos tame puslapyje]]',
	'article-comments-user-is-blocked' => 'Jūsų vartotojo abonementas yra šiuo metu užblokuoti redaguoti "[[ $1 ]]".',
	'article-comments-comment-bad-mode' => 'Neleistinas režimas, pateikti komentarą.
Galimų yra "paprasto", "normalus" ir "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Trūksta pavadinimo',
	'article-comments-comment-missing-date-parameter' => 'Trūksta komentaro datos',
	'article-comments-no-spam' => 'Bent vieno iš pateiktų laukų buvo pažymėtas kaip šlamštas.',
	'processcomment' => 'Proceso puslapio komentarą',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 * @author Papuass
 */
$messages['lv'] = array(
	'article-comments-desc' => 'Iespējo komentāru sadaļas satura lapās',
	'article-comments-title-string' => 'nosaukums',
	'article-comments-name-string' => 'Vārds',
	'article-comments-name-field' => 'Vārds (jānorāda obligāti):',
	'article-comments-url-field' => 'Tīmekļa vietne:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komentārs',
	'article-comments-comment-field' => 'Komentārs:',
	'article-comments-submit-button' => 'Iesniegt',
	'article-comments-leave-comment-link' => 'Atstāt komentāru ...',
	'article-comments-invalid-field' => '$1 ievadītais <nowiki>[$2]</nowiki> nav derīgs.',
	'article-comments-required-field' => '"$1" lauks ir jāaizpilda obligāti.',
	'article-comments-submission-failed' => 'Komentāra iesniegšana neizdevās',
	'article-comments-failure-reasons' => 'Atvainojiet, Jūsu komentāra iesniegšana neizdevās {{PLURAL:$1|šāda iemesla|šādu iemeslu}} dēļ:',
	'article-comments-no-comments' => 'Atvainojiet, šobrīd lapa "[[$1]]" nepieņem komentārus.',
	'article-comments-talk-page-starter' => '<noinclude>Komentāri par "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 teica ...',
	'article-comments-summary' => '$1 iesniegtie komentāri, izmantojot ArticleComments paplašinājumu',
	'article-comments-submission-succeeded' => 'Komentāru iesniegšana izdevās',
	'article-comments-submission-success' => 'Jūs esat veiksmīgi iesniedzis komentāru lapai "[[$1]]"',
	'article-comments-submission-view-all' => 'Jūs varat apskatīt [[$1|visus komentārus šajā lapā]]',
	'article-comments-user-is-blocked' => 'Jūsu lietotāja konts šobrīd ir bloķēts "[[$1]] " rediģēšanai.',
	'article-comments-comment-bad-mode' => 'Komentāram piešķirts nederīgs režīms.
Pieejamie režīmi ir "plain", "normal" un "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Trūkst vārda',
	'article-comments-comment-missing-date-parameter' => 'Trūkst komentāra datuma',
	'article-comments-no-spam' => 'Vismaz viens no iesniegtajiem laukiem ir atzīmēts kā mēstule.',
	'processcomment' => 'Apstrādes lapas komentārs',
);

/** Basa Banyumasan (Basa Banyumasan)
 * @author StefanusRA
 */
$messages['map-bms'] = array(
	'article-comments-desc' => 'Ngaktifna bagiyan komentar nang halaman konten',
	'article-comments-title-string' => 'judul',
	'article-comments-name-string' => 'Jeneng',
	'article-comments-name-field' => 'Jeneng (wajib):',
	'article-comments-url-field' => 'Situs web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komentar',
	'article-comments-comment-field' => 'Komentar:',
	'article-comments-submit-button' => 'Kirim',
	'article-comments-leave-comment-link' => 'Ngaweh komentar...',
	'article-comments-invalid-field' => '$1 <nowiki>[$2]</nowiki> sing diwenehna ora sah.',
	'article-comments-required-field' => '"$1" kudu diisi.',
	'article-comments-submission-failed' => 'Pengiriman komentar gagal',
	'article-comments-failure-reasons' => 'Nuwun sewu, kiriman komentare Rika gagal amarga {{PLURAL:$1|jalaran|jalaran}} kiye:',
	'article-comments-no-comments' => 'Nuwun sewu, halaman "[[$1]]" ora teyeng nampani komentar sekiye.',
	'article-comments-talk-page-starter' => '<noinclude>Komentar nang "[[$1]]"
<comments />
-----__NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 ngomong ...',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'article-comments-desc' => "Mampandeha ny fizarana misy ny resaka eny amin'ny pejin-dahatsoratra",
	'article-comments-title-string' => 'lohateny',
	'article-comments-name-string' => 'Anarana',
	'article-comments-name-field' => 'Anarana (ilaina) :',
	'article-comments-url-field' => 'Sehatra antranonkala :',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Resaka',
	'article-comments-comment-field' => 'Resaka :',
	'article-comments-submit-button' => 'Alefa',
	'article-comments-leave-comment-link' => 'Asiana resaka...',
	'article-comments-required-field' => 'Iliana fenoina ny fanatsofohan-teny $1.',
	'article-comments-submission-failed' => 'Tsy tafalefa ny fandefasana ilay resaka',
	'article-comments-no-comments' => "Miala tsiny fa tsy mandray resaka ny lahatsoratra « [[$1]] » amin'izao fotoana izao.",
	'article-comments-talk-page-starter' => "<noinclude>Resaka mikasikan'i [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>",
	'article-comments-commenter-said' => 'Hoy i $1 ...',
	'article-comments-summary' => "Resaka nasian'i $1 — tamin'ny alàlan'ny fanitarana ArticleComments",
	'article-comments-submission-succeeded' => 'Nandeha soa aman-tsara ny fandefasana ilay resaka',
	'article-comments-submission-success' => "Nanisy resaka momban'i « [[$1]] » soa aman-tsara ianao",
	'article-comments-submission-view-all' => 'Azonao jerena [[$1|eto]] ny resaka rehetra mahakasika io lahatsoratra io',
	'article-comments-user-is-blocked' => "Voasakana tsy mahazo manoratra ny kantim-pikambanao eo amin'i « [[$1]] ».",
	'article-comments-comment-missing-name-parameter' => 'Tsy ampy ny anarana',
	'article-comments-comment-missing-date-parameter' => "Tsy ampy ny datin'ny resaka",
	'article-comments-no-spam' => "Voamarika ho spam ny iraika amin'ny fanatsofohan-teny nalefa.",
	'processcomment' => "Fikarakarana ny resaka mikasikan'ny lahatsoratra",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author 青子守歌
 */
$messages['mk'] = array(
	'article-comments-desc' => 'Дава пасуси за коментари во статиите',
	'article-comments-title-string' => 'наслов',
	'article-comments-name-string' => 'Име',
	'article-comments-name-field' => 'Име (задолжително):',
	'article-comments-url-field' => 'Мреж.место:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Коментар',
	'article-comments-comment-field' => 'Коментар:',
	'article-comments-submit-button' => 'Поднеси',
	'article-comments-leave-comment-link' => 'Напишете коментар ...',
	'article-comments-invalid-field' => 'Наведеното „$1“ е <nowiki>[$2]</nowiki> неважечко.',
	'article-comments-required-field' => 'Се бара полето $1.',
	'article-comments-submission-failed' => 'Поднесувањето на коментарот не успеа.',
	'article-comments-failure-reasons' => 'Нажалост, поднесувањето на коментарот не успеа, и тоа од {{PLURAL:$1|следнава причина|следниве причини}}:',
	'article-comments-no-comments' => 'Нажалост, статијата „[[$1]]“ моментално не прифаќа коментари.',
	'article-comments-talk-page-starter' => '<noinclude>Коментари за [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 рече ...',
	'article-comments-summary' => 'Коментар на $1 - преку додатокот ArticleComments',
	'article-comments-submission-succeeded' => 'Поднесувањето на коментарот успеа.',
	'article-comments-submission-success' => 'Успешно поднесовте коментар за „[[$1]]“',
	'article-comments-submission-view-all' => 'Сите коментари за таа статија можете да ги погледате [[$1|тука]]',
	'article-comments-user-is-blocked' => 'На вашата корисничка моментално не ѝ е дозволено да ја уредува страницата „[[$1]]“.',
	'article-comments-comment-bad-mode' => 'Зададен е неважечки режим за коментарот.
На располагање ви се „plain“, „normal“ и „wiki“.',
	'article-comments-comment-missing-name-parameter' => 'Недостасува име',
	'article-comments-comment-missing-date-parameter' => 'Недостасува датум на коментарот',
	'article-comments-no-spam' => 'Барем едно од поднесените полиња е означено како спам.',
	'processcomment' => 'Обработи го коментарот',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'article-comments-desc' => 'ഉള്ളടക്ക താളുകളിൽ അഭിപ്രായമിടാനുള്ള ഭാഗം സജ്ജമാക്കുന്നു',
	'article-comments-title-string' => 'ശീർഷകം',
	'article-comments-name-string' => 'പേര്‌',
	'article-comments-name-field' => 'പേര് (ആവശ്യമാണ്):',
	'article-comments-url-field' => 'വെബ്‌സൈറ്റ്:',
	'article-comments-url-string' => 'യൂ.ആർ.എൽ.',
	'article-comments-comment-string' => 'അഭിപ്രായം',
	'article-comments-comment-field' => 'അഭിപ്രായം:',
	'article-comments-submit-button' => 'സമർപ്പിക്കുക',
	'article-comments-leave-comment-link' => 'ഒരു കുറിപ്പിടുക ...',
	'article-comments-invalid-field' => '$1 നൽകിയ <nowiki>[$2]</nowiki> അസാധുവാണ്.',
	'article-comments-required-field' => '$1 എന്ന ഫീൽഡ് ആവശ്യമാണ്.',
	'article-comments-submission-failed' => 'അഭിപ്രായം സമർപ്പിക്കാൻ സാധിച്ചില്ല',
	'article-comments-failure-reasons' => 'ക്ഷമിക്കുക, താങ്കളുടെ അഭിപ്രായം സമർപ്പിക്കാൻ താഴെ പറയുന്ന {{PLURAL:$1|കാരണത്താൽ|കാരണങ്ങളാൽ}} സാധിച്ചില്ല:',
	'article-comments-no-comments' => 'ക്ഷമിക്കുക, ഇപ്പോൾ "[[$1]]" താളിൽ അഭിപ്രായങ്ങൾ സ്വീകരിക്കുന്നില്ല.',
	'article-comments-talk-page-starter' => '<noinclude>[[$1]] താളിലെ അഭിപ്രായങ്ങൾ
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 പറഞ്ഞു ...',
	'article-comments-summary' => '$1 ഇട്ട അഭിപ്രായം - ArticleComments അനുബന്ധം വഴി',
	'article-comments-submission-succeeded' => 'അഭിപ്രായം സമർപ്പിച്ചിരിക്കുന്നു',
	'article-comments-submission-success' => 'താങ്കൾ "[[$1]]" താളിൽ അഭിപ്രായം വിജയകരമായി സമർപ്പിച്ചിരിക്കുന്നു',
	'article-comments-submission-view-all' => '[[$1|ആ താളിലെ എല്ലാ അഭിപ്രായങ്ങളും]] താങ്കൾക്ക് കാണാവുന്നതാണ്',
	'article-comments-user-is-blocked' => 'താങ്കളുടെ അംഗത്വം തിരുത്തുന്നതിൽ നിന്നും ഇപ്പോൾ തടയപ്പെട്ടിരിക്കുകയാണ് "[[$1]]".',
	'article-comments-comment-bad-mode' => 'അഭിപ്രായത്തിനായി തിരഞ്ഞെടുത്ത സമ്പ്രദായം അസാധുവാണ്.
"plain", "normal", "wiki" എന്നിവയാണ് ലഭ്യമായിട്ടുള്ളത്.',
	'article-comments-comment-missing-name-parameter' => 'പേര് ഇല്ല',
	'article-comments-comment-missing-date-parameter' => 'അഭിപ്രായത്തിന്റെ തീയതി ഇല്ല',
	'article-comments-no-spam' => 'കുറഞ്ഞത് ഒരു ഫീൽഡ് എങ്കിലും പാഴെഴുത്ത് ആയി അടയാളപ്പെടുത്തിയിരിക്കുന്നു.',
	'processcomment' => 'ലേഖനത്തെക്കുറിച്ചുള്ള അഭിപ്രായം പാകപ്പെടുത്തുന്നു',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'article-comments-submit-button' => 'Явуулах',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'article-comments-desc' => 'Membolehkan bahagian komen dalam laman kandungan',
	'article-comments-title-string' => 'tajuk',
	'article-comments-name-string' => 'Nama',
	'article-comments-name-field' => 'Nama (diperlukan):',
	'article-comments-url-field' => 'Tapak web:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Komen',
	'article-comments-comment-field' => 'Komen:',
	'article-comments-submit-button' => 'Hantar',
	'article-comments-leave-comment-link' => 'Tinggalkan komen ...',
	'article-comments-invalid-field' => '$1 yang diberikan <nowiki>[$2]</nowiki> tidak sah.',
	'article-comments-required-field' => 'Ruangan "$1" mesti diisi.',
	'article-comments-submission-failed' => 'Komen tidak dapat dihantar.',
	'article-comments-failure-reasons' => 'Maaf, komen anda tidak dapat dihantar atas {{PLURAL:$1|sebab|sebab-sebab}} berikut:',
	'article-comments-no-comments' => 'Maaf, laman "[[$1]]" tidak menerima komen buat masa ini.',
	'article-comments-talk-page-starter' => '<noinclude>Komen di "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 berkata ...',
	'article-comments-summary' => 'Komen diberikan oleh $1 - melalui sambungan ArticleComments',
	'article-comments-submission-succeeded' => 'Komen berjaya dihantar',
	'article-comments-submission-success' => 'Anda berjaya menyerahkan komen untuk "[[$1]]"',
	'article-comments-submission-view-all' => 'Anda boleh melihat [[$1|semua komen pada laman itu]]',
	'article-comments-user-is-blocked' => 'Akaun pengguna anda sekarang disekat daripada menyunting "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Mod yang diberikan tidak sah untuk komen.
Yang ada ialah "plain", "normal" dan "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Tiada nama',
	'article-comments-comment-missing-date-parameter' => 'Tiada tarikh komen',
	'article-comments-no-spam' => 'Sekurang-kurangnya satu ruangan yang diserahkan itu disyaki sebagai spam.',
	'processcomment' => 'Proseskan komen laman',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'article-comments-title-string' => 'коняксозо',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'article-comments-desc' => 'Slå på kommentarseksjoner på innholdssider',
	'article-comments-title-string' => 'tittel',
	'article-comments-name-string' => 'Navn',
	'article-comments-name-field' => 'Navn (påkrevd):',
	'article-comments-url-field' => 'Nettsted:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Kommentar',
	'article-comments-comment-field' => 'Kommentar:',
	'article-comments-submit-button' => 'Lagre',
	'article-comments-leave-comment-link' => 'Legg igjen en kommentar ...',
	'article-comments-invalid-field' => '$1 forutsatt at <nowiki>[$2]</nowiki> er ugyldig.',
	'article-comments-required-field' => '$1-feltet er påkrevd.',
	'article-comments-submission-failed' => 'Kommentering mislyktes',
	'article-comments-failure-reasons' => 'Beklager, kommentaren din mislyktes på grunn av følgende {{PLURAL:$1|årsak|årsaker}}:',
	'article-comments-no-comments' => 'Beklager, siden «[[$1]]» er ikke åpen for kommentarer nå',
	'article-comments-talk-page-starter' => '<noinclude>Kommentarer på [[$1]]
<comments />
---- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 sa ...',
	'article-comments-summary' => 'Kommentar av $1 – via ArticleComments-utvidelsen',
	'article-comments-submission-succeeded' => 'Kommentering lyktes',
	'article-comments-submission-success' => 'Du har kommentert «[[$1]]»',
	'article-comments-submission-view-all' => 'Du kan vise [[$1|alle kommentarer på den siden]]',
	'article-comments-user-is-blocked' => 'Kontoen din er blokkert fra å redigere «[[$1]]».',
	'article-comments-comment-bad-mode' => 'Ugyldig modis for kommentarer.
Tilgjengelige moduser er «plain», «normal» og «wiki».',
	'article-comments-comment-missing-name-parameter' => 'Mangler navn',
	'article-comments-comment-missing-date-parameter' => 'Mangler kommentardato',
	'article-comments-no-spam' => 'Minst ett av feltene ble merket som spam.',
	'processcomment' => 'Prosesser artikkelkommentar',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'article-comments-comment-string' => 'टिप्पणी',
	'article-comments-comment-field' => 'टिप्पणी :',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'article-comments-desc' => "Maakt het mogelijk om opmerkingen te plaatsen bij paragrafen op pagina's",
	'article-comments-title-string' => 'titel',
	'article-comments-name-string' => 'Naam',
	'article-comments-name-field' => 'Naam (verplicht):',
	'article-comments-url-field' => 'Website:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Opmerking',
	'article-comments-comment-field' => 'Opmerking:',
	'article-comments-submit-button' => 'Opslaan',
	'article-comments-leave-comment-link' => 'Opmerking plaatsen...',
	'article-comments-invalid-field' => 'De opgegeven $1 <nowiki>[$2]</nowiki> is ongeldig.',
	'article-comments-required-field' => 'Het veld $1 is verplicht.',
	'article-comments-submission-failed' => 'Het opslaan van de opmerking is mislukt.',
	'article-comments-failure-reasons' => 'Het opslaan van uw opmerking is mislukt om de volgende {{PLURAL:$1|reden|redenen}}:',
	'article-comments-no-comments' => 'Bij de pagina "[[$1]]" kunnen op het moment geen opmerkingen geplaatst worden.',
	'article-comments-talk-page-starter' => '<noinclude>Opmerkingen bij [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 schreef ...',
	'article-comments-summary' => 'Opmerking van $1',
	'article-comments-submission-succeeded' => 'De opmerking is opgeslagen',
	'article-comments-submission-success' => 'U hebt een opmerking bij "[[$1]]" opgeslagen',
	'article-comments-submission-view-all' => 'U kunt [[$1|alle opmerkingen bij die pagina]] bekijken',
	'article-comments-user-is-blocked' => 'Uw gebruiker kan op dit moment "[[$1]]" niet bewerken.',
	'article-comments-comment-bad-mode' => 'Er is een ongeldige modus opgegeven voor de opmerking.
Beschikbaar zijn "plain", "normal" en "wiki".',
	'article-comments-comment-missing-name-parameter' => 'De naam mist',
	'article-comments-comment-missing-date-parameter' => 'De datum voor de opmerking mist',
	'article-comments-no-spam' => 'Tenminste een van de opgeslagen velden had een inhoud die als spam is aangemerkt.',
	'processcomment' => 'Opmerking verwerken',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'article-comments-failure-reasons' => 'Het opslaan van je opmerking is mislukt om de volgende {{PLURAL:$1|reden|redenen}}:',
	'article-comments-submission-success' => 'Je hebt een opmerking bij "[[$1]]" opgeslagen',
	'article-comments-submission-view-all' => 'Je kunt [[$1|alle opmerkingen bij die pagina]] bekijken',
	'article-comments-user-is-blocked' => 'Je gebruiker kan op dit moment "[[$1]]" niet bewerken.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'article-comments-title-string' => 'tittel',
	'article-comments-name-string' => 'Namn',
	'article-comments-name-field' => 'Namn (kravd):',
	'article-comments-url-field' => 'Nettstad:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Kommentar',
	'article-comments-comment-field' => 'Kommentar:',
	'article-comments-submit-button' => 'Lagre',
	'article-comments-leave-comment-link' => 'Legg igjen ein kommentar ...',
	'article-comments-commenter-said' => '$1 sa ...',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'article-comments-name-string' => 'ନାମ',
	'article-comments-url-string' => 'ଇଉ.ଆର.ଏଲ.',
	'article-comments-comment-string' => 'ମତାମତ',
	'article-comments-comment-field' => 'ମତାମତ:',
	'article-comments-submit-button' => 'ଦାଖଲକରିବା',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'article-comments-name-string' => 'Naame',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'article-comments-desc' => 'Umożliwia komentowanie poszczególnych sekcji na stronach treści',
	'article-comments-title-string' => 'tytuł',
	'article-comments-name-string' => 'Nazwa',
	'article-comments-name-field' => 'Nazwa (wymagane)',
	'article-comments-url-field' => 'Strona internetowa',
	'article-comments-url-string' => 'adres URL',
	'article-comments-comment-string' => 'Komentarz',
	'article-comments-comment-field' => 'Komentarz',
	'article-comments-submit-button' => 'Zapisz',
	'article-comments-leave-comment-link' => 'Zostaw komentarz...',
	'article-comments-invalid-field' => 'dla „$1” wartość <nowiki>[$2]</nowiki> jest nieprawidłowa',
	'article-comments-required-field' => 'wypełnienie pola „$1” jest obowiązkowe',
	'article-comments-submission-failed' => 'Nieudane zapisanie komentarza',
	'article-comments-failure-reasons' => 'Komentarz nie może zostać zapisany {{PLURAL:$1|ponieważ|z następujących powodów:}}',
	'article-comments-no-comments' => 'W tej chwili nie można komentować strony „[[$1]]”.',
	'article-comments-talk-page-starter' => '<noinclude>Komentarze do [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 napisał...',
	'article-comments-summary' => 'Komentarz dodany przez $1 za pomocą rozszerzenia ArticleComments',
	'article-comments-submission-succeeded' => 'Komentarz zapisano',
	'article-comments-submission-success' => 'Zapisano Twój komentarz dla „[[$1]]”',
	'article-comments-submission-view-all' => 'Możesz zobaczyć [[$1|wszystkie komentarze do tej strony]]',
	'article-comments-user-is-blocked' => 'Twoje konto użytkownika ma obecnie zablokowaną możliwość edycji „[[$1]]”.',
	'article-comments-comment-bad-mode' => 'Nieprawidłowy tryb dla komentarza.
Dostępne tryby to: „plain”, „normal” i „wiki”.',
	'article-comments-comment-missing-name-parameter' => 'Brak nazwy',
	'article-comments-comment-missing-date-parameter' => 'Brak daty dodania komentarza',
	'article-comments-no-spam' => 'Co najmniej treść jednego z pól rozpoznano jako spam.',
	'processcomment' => 'Komentowanie artykułu',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'article-comments-desc' => 'Abìlita le session ëd coment an sle pàgine ëd contnù',
	'article-comments-title-string' => 'tìtol',
	'article-comments-name-string' => 'Nòm',
	'article-comments-name-field' => 'Nòm (obligatòri):',
	'article-comments-url-field' => 'Sit an sla Ragnà:',
	'article-comments-url-string' => "Adrëssa an sl'aragnà",
	'article-comments-comment-string' => 'Coment',
	'article-comments-comment-field' => 'Coment:',
	'article-comments-submit-button' => 'Spediss',
	'article-comments-leave-comment-link' => 'lassa un coment ...',
	'article-comments-invalid-field' => "Ël $1 dàit <nowiki>[$2]</nowiki> a l'é pa bon.",
	'article-comments-required-field' => "Ël camp $1 a l'é obligatòri.",
	'article-comments-submission-failed' => "La spedission dël coment a l'é falìa",
	'article-comments-failure-reasons' => "An dëspias, la spedission ëd sò coment a l'é falìa për {{PLURAL:$1|la rason|le rason}} sì-dapress:",
	'article-comments-no-comments' => 'An dëspias, la pàgina «[[$1]]» a aceta pa ëd coment al moment.',
	'article-comments-talk-page-starter' => '<noinclude>Coment su [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 dit ...',
	'article-comments-summary' => "Coment fornì da $1 - a travers l'estension ArticleComments",
	'article-comments-submission-succeeded' => "La spedission dël coment a l'é andàita bin",
	'article-comments-submission-success' => 'It l\'has spedì da bin un coment për "[[$1]]"',
	'article-comments-submission-view-all' => 'It peule vëdde [[$1|tùit ij coment su sta pàgina]]',
	'article-comments-user-is-blocked' => 'Tò cont utent a l\'é al moment blocà da modifiché "[[$1]]".',
	'article-comments-comment-bad-mode' => 'La manera fornìa për ël coment a va pa bin.
Cole disponìbij a son "plain", "normal" e "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Nòm mancant',
	'article-comments-comment-missing-date-parameter' => 'Data dël coment mancanta',
	'article-comments-no-spam' => "Almanch un dij camp spedì a l'é stàit marcà com ëd rumenta.",
	'processcomment' => "Trata ël coment ëd l'artìcol",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'article-comments-title-string' => 'سرليک',
	'article-comments-name-string' => 'نوم',
	'article-comments-name-field' => 'نوم (اړين مالومات):',
	'article-comments-url-field' => 'وېبځی:',
	'article-comments-comment-string' => 'تبصره',
	'article-comments-comment-field' => 'تبصره:',
	'article-comments-submit-button' => 'سپارل',
	'article-comments-leave-comment-link' => 'تبصره پرېښودل ...',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'article-comments-desc' => 'Possibilita secções de comentários nas páginas de conteúdo',
	'article-comments-title-string' => 'título',
	'article-comments-name-string' => 'Nome',
	'article-comments-name-field' => 'Nome (obrigatório):',
	'article-comments-url-field' => 'Site:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comentário',
	'article-comments-comment-field' => 'Comentário:',
	'article-comments-submit-button' => 'Enviar',
	'article-comments-leave-comment-link' => 'Deixe um comentário ...',
	'article-comments-invalid-field' => 'O valor que forneceu como $1, <nowiki>[$2]</nowiki>, é inválido',
	'article-comments-required-field' => 'O campo "$1" é obrigatório.',
	'article-comments-submission-failed' => 'O envio do comentário falhou',
	'article-comments-failure-reasons' => 'O envio do seu comentário falhou {{PLURAL:$1|pela seguinte razão|pelas seguintes razões}}:',
	'article-comments-no-comments' => 'Neste momento, a página "[[$1]]" não aceita comentários.',
	'article-comments-talk-page-starter' => '<noinclude>Comentários a [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 comentou ...',
	'article-comments-summary' => 'Comentário de $1 - através da extensão ArticleComments',
	'article-comments-submission-succeeded' => 'Comentário enviado',
	'article-comments-submission-success' => 'Enviou um comentário a "[[$1]]"',
	'article-comments-submission-view-all' => 'Pode ver [[$1|todos os comentários dessa página]]',
	'article-comments-user-is-blocked' => 'Edições a "[[$1]]" estão neste momento bloqueadas para a sua conta.',
	'article-comments-comment-bad-mode' => 'O modo do comentário é inválido.
Os modos disponíveis são "plain" (simples), "normal" e "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Falta o nome',
	'article-comments-comment-missing-date-parameter' => 'Falta a data do comentário',
	'article-comments-no-spam' => 'Pelo menos um dos campos enviados foi identificado como spam.',
	'processcomment' => 'Processar o comentário ao artigo',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'article-comments-desc' => 'Possibilita seções de comentários nas páginas de conteúdo',
	'article-comments-title-string' => 'título',
	'article-comments-name-string' => 'Nome',
	'article-comments-name-field' => 'Nome (obrigatório):',
	'article-comments-url-field' => 'Site:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comentário',
	'article-comments-comment-field' => 'Comentário:',
	'article-comments-submit-button' => 'Enviar',
	'article-comments-leave-comment-link' => 'Deixe um comentário ...',
	'article-comments-invalid-field' => 'O valor que forneceu como $1, <nowiki>[$2]</nowiki>, é inválido',
	'article-comments-required-field' => 'O campo $1 é obrigatório.',
	'article-comments-submission-failed' => 'O envio do comentário falhou',
	'article-comments-failure-reasons' => 'O envio do seu comentário falhou {{PLURAL:$1|pela seguinte motivo|pelas seguintes motivos}}:',
	'article-comments-no-comments' => 'Neste momento, a página "[[$1]]" não aceita comentários.',
	'article-comments-talk-page-starter' => '<noinclude>Comentários em [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 comentou ...',
	'article-comments-summary' => 'Comentário de $1 - através da extensão ArticleComments',
	'article-comments-submission-succeeded' => 'Comentário enviado com sucesso',
	'article-comments-submission-success' => 'Você enviou um comentário com sucesso para "[[$1]]"',
	'article-comments-submission-view-all' => 'Você pode ver [[$1|todos os comentários dessa página]]',
	'article-comments-user-is-blocked' => 'Edições em "[[$1]]" estão, neste momento, bloqueadas para a sua conta.',
	'article-comments-comment-bad-mode' => 'O modo do comentário é inválido.
Os modos disponíveis são "plain" (simples), "normal" e "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Falta o nome',
	'article-comments-comment-missing-date-parameter' => 'Falta a data do comentário',
	'article-comments-no-spam' => 'Pelo menos um dos campos enviados foi identificado como spam.',
	'processcomment' => 'Processar o comentário do artigo',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'article-comments-title-string' => 'titlu',
	'article-comments-name-string' => 'Nume',
	'article-comments-name-field' => 'Nume (obligatoriu):',
	'article-comments-url-field' => 'Website:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Comentariu',
	'article-comments-comment-field' => 'Comentariu:',
	'article-comments-submit-button' => 'Trimite',
	'article-comments-leave-comment-link' => 'Lăsaţi un comentariu ...',
	'article-comments-required-field' => 'Câmpul $1 este obligatoriu.',
	'article-comments-submission-failed' => 'Trimiterea comentariului a eșuat',
	'article-comments-failure-reasons' => 'Ne pare rău, dar trimiterea comentariului dumneavoastră a eșuat din {{PLURAL:$1|următorul|următoarele}} {{PLURAL:$1|motiv|motive}}:',
	'article-comments-no-comments' => 'Scuze, pagina „[[$1]]” nu acceptă comentarii în acest moment.',
	'article-comments-talk-page-starter' => '<noinclude>Comentarii pe [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 a spus ...',
	'article-comments-summary' => 'Comentariu furnizat de către $1 - prin extensia ArticleComments',
	'article-comments-submission-succeeded' => 'Trimiterea comentariului s-a efectuat cu succes',
	'article-comments-submission-success' => 'Ai trimis cu succes un comentariu pentru „[[$1]]”',
	'article-comments-user-is-blocked' => 'Contului dumneavoastră de utilizator nu îi este permisă modificarea paginii „[[$1]]”.',
	'article-comments-comment-missing-name-parameter' => 'Lipseşte numele',
	'article-comments-comment-missing-date-parameter' => 'Lipseşte data comentariului',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'article-comments-title-string' => 'titele',
	'article-comments-name-string' => 'Nome',
	'article-comments-name-field' => 'Nome (obbligatorie):',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Commende',
	'article-comments-comment-field' => 'Commende:',
	'article-comments-submit-button' => 'Conferme',
	'article-comments-leave-comment-link' => "Lasse 'nu commende ...",
);

/** Russian (Русский)
 * @author MaxSem
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'article-comments-desc' => 'Добавляет на основные страницы разделы комментариев',
	'article-comments-title-string' => 'заголовок',
	'article-comments-name-string' => 'Имя',
	'article-comments-name-field' => 'Имя (обязательно):',
	'article-comments-url-field' => 'Сайт:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Комментарий',
	'article-comments-comment-field' => 'Комментарий:',
	'article-comments-submit-button' => 'Отправить',
	'article-comments-leave-comment-link' => 'Оставьте комментарий…',
	'article-comments-invalid-field' => 'Указанный ошибочный $1 <nowiki>[$2]</nowiki>.',
	'article-comments-required-field' => 'Поле $1 является обязательным.',
	'article-comments-submission-failed' => 'отправка комментария не удалась.',
	'article-comments-failure-reasons' => 'К сожалению, не удалось отправить ваш комментарий по {{PLURAL:$1|следующей причине|следующим причинам}}:',
	'article-comments-no-comments' => 'Извините, на странице «[[$1]]» в настоящий момент нельзя оставлять комментарии.',
	'article-comments-talk-page-starter' => '<noinclude>Коммантарии — [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 сказал…',
	'article-comments-summary' => 'Комментарий $1 — через расширение ArticleComments',
	'article-comments-submission-succeeded' => 'Комментарий успешно отправлен',
	'article-comments-submission-success' => 'Комментарий к «[[$1]]» успешно отправлен',
	'article-comments-submission-view-all' => 'Вы можете просмотреть [[$1|все комментарии на этой странице]]',
	'article-comments-user-is-blocked' => 'Вашей учётной записи в данный момент запрещено редактировать «[[$1]]».',
	'article-comments-comment-bad-mode' => 'Недопустимый режим комментария.
Допустимы режимы «plain», «normal» и «wiki».',
	'article-comments-comment-missing-name-parameter' => 'Отсутствует имя',
	'article-comments-comment-missing-date-parameter' => 'Отсутствует дата написания комментария',
	'article-comments-no-spam' => 'По крайней мере одно из представленных полей было помечено как спам.',
	'processcomment' => 'Обработка комментария',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'article-comments-title-string' => 'назва',
	'article-comments-name-string' => 'Імя',
	'article-comments-name-field' => 'Назва (выжадоване):',
	'article-comments-url-field' => 'Веб-сайт:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Коментарь',
	'article-comments-comment-field' => 'Коментарь:',
	'article-comments-submit-button' => 'Одослати',
	'article-comments-leave-comment-link' => 'Написати коментарь ...',
	'article-comments-commenter-said' => '$1 говорить ...',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'article-comments-title-string' => 'tìtulu',
	'article-comments-name-string' => 'Nomu',
	'article-comments-commenter-said' => '$1 dissi ...',
	'article-comments-comment-missing-name-parameter' => 'Nomu persu',
);

/** Tachelhit (Tašlḥiyt/ⵜⴰⵛⵍⵃⵉⵜ)
 * @author Dalinanir
 */
$messages['shi'] = array(
	'article-comments-desc' => 'Ssrmd (ssrɣ) ayawn n tannayin ɣ tisniwin n imlan.',
	'article-comments-title-string' => 'azwl',
	'article-comments-name-string' => 'Assaɣ',
	'article-comments-name-field' => 'Assaɣ (ism)',
	'article-comments-url-field' => 'Asml web (Asit web)',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Awnnit (aɣfawal)',
	'article-comments-comment-field' => 'Awnit (aɣfawal)',
	'article-comments-submit-button' => 'Zzugs',
	'article-comments-leave-comment-link' => 'Zayd awnit (aɣfawal)',
	'article-comments-invalid-field' => ' $1 ar takka <nowiki>[$2]</nowiki> lli ur illan',
	'article-comments-required-field' => 'Igr $1 ur iga bzzez',
	'article-comments-submission-failed' => 'afuḍ n iwnit (aɣfawal) ur issufɣ',
	'article-comments-failure-reasons' => 'Surf as, afuḍ n uwnit ur issufɣ f {{PLURAL:$1|uɣzan ad|iɣzan ad}} :',
	'article-comments-no-comments' => 'Surf as amli yad « [[$1]] »  ur ira iwnitn ɣilad.',
	'article-comments-talk-page-starter' => '<noinclude>Iɣfiwaliwn f "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 inna',
	'article-comments-summary' => 'Aɣfawal (awnit) llid yiwi  $1 - z dar  usiɣzif iwnitn n imlan',
	'article-comments-submission-succeeded' => 'Afuḍ n iwnit (aɣfawal)  issufɣ',
	'article-comments-submission-success' => 'Tuznt mzyan aɣfawal f « [[$1]] »',
	'article-comments-submission-view-all' => 'Tzḍart adark ilin iɣfawaln kullutn f umla yad [[$1|ɣid]]',
	'article-comments-user-is-blocked' => 'Amiḍan (compte) nk iqn f tirra d uẓṛig ɣ  « [[$1]] ».',
	'article-comments-comment-bad-mode' => 'Askar lli tkfit i uɣfawal urt igi. 
Iskarn lli illan gan "plain", "normal" d "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Assaɣ ur illin',
	'article-comments-comment-missing-date-parameter' => 'Asakud n uɣfawal lli ur illan',
	'article-comments-no-spam' => 'yan iɣd uggar n nigran llin illan iga gar igr (spam)',
	'processcomment' => 'Askr n uɣfawal f umla',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'article-comments-desc' => 'Omogoča razdelke s pripombami na vsebinskih straneh',
	'article-comments-title-string' => 'naslov',
	'article-comments-name-string' => 'Ime',
	'article-comments-name-field' => 'Ime (potrebno):',
	'article-comments-url-field' => 'Spletna stran:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Pripomba',
	'article-comments-comment-field' => 'Pripomba:',
	'article-comments-submit-button' => 'Pošlji',
	'article-comments-leave-comment-link' => 'Pustite pripombo ...',
	'article-comments-invalid-field' => 'Naveden $1 <nowiki>[$2]</nowiki> ni veljaven.',
	'article-comments-required-field' => 'Polje $1 je obvezno.',
	'article-comments-submission-failed' => 'Oddaja pripombe je spodletela',
	'article-comments-failure-reasons' => 'Oprostite, oddaja vaše pripombe je spodletela zaradi {{PLURAL:$1|naslednjega razloga|naslednjih razlogov}}:',
	'article-comments-no-comments' => 'Oprostite, stran »[[$1]]« v tem trenutku ne sprejema pripomb.',
	'article-comments-talk-page-starter' => '<noinclude>Komentarji na [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 pravi ...',
	'article-comments-summary' => 'Pripombo je nudil $1 – preko razširitve ArticleComments',
	'article-comments-submission-succeeded' => 'Oddaja pripombe je uspela',
	'article-comments-submission-success' => 'Uspešno ste poslali pripombo za »[[$1]]«',
	'article-comments-submission-view-all' => 'Ogledate si lahko [[$1|vse pripombe na tej strani]]',
	'article-comments-user-is-blocked' => 'Vašemu uporabniškemu računu je trenutno preprečeno urejanje »[[$1]]«.',
	'article-comments-comment-bad-mode' => 'Za pripombo je bil dan neveljavni način.
Na voljo so »plain«, »normal« in »wiki«.',
	'article-comments-comment-missing-name-parameter' => 'Manjkajoče ime',
	'article-comments-comment-missing-date-parameter' => 'Manjkajoč datum pripombe',
	'article-comments-no-spam' => 'Vsaj eno od poslanih polj je bilo označeno kot smetje.',
	'processcomment' => 'Obdelaj pripombo članka',
);

/** Swedish (Svenska)
 * @author Cohan
 * @author Lokal Profil
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'article-comments-desc' => 'Aktiverar kommentaravsnitt på innehållssidor',
	'article-comments-title-string' => 'titel',
	'article-comments-name-string' => 'Namn',
	'article-comments-name-field' => 'Namn (obligatoriskt):',
	'article-comments-url-field' => 'Webbplats:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Kommentar',
	'article-comments-comment-field' => 'Kommentar:',
	'article-comments-submit-button' => 'Skicka in',
	'article-comments-leave-comment-link' => 'Lämna en kommentar ...',
	'article-comments-required-field' => '$1-fältet är obligatoriskt.',
	'article-comments-submission-failed' => 'Kommentarinlämning misslyckades',
	'article-comments-failure-reasons' => 'Tyvärr misslyckades inskickandet av din kommentar av följande {{PLURAL:$1|skäl|skäl}}:',
	'article-comments-no-comments' => 'Tyvärr, sidan "[[$1]]" tillåter inte kommentarer just nu.',
	'article-comments-talk-page-starter' => '<noinclude>Kommentarer till [[$1]]
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 sa ...',
	'article-comments-summary' => 'Kommentar från $1 - via ArticleComments-tillägg',
	'article-comments-submission-succeeded' => 'Kommentarinlämning lyckades',
	'article-comments-submission-success' => 'Du har lämnat en kommentar på "[[$1]]"',
	'article-comments-submission-view-all' => 'Du kan visa [[$1|alla kommentarer på sidan]]',
	'article-comments-user-is-blocked' => 'Ditt användarkonto är för närvarande blockerat  från att redigera "[[$1]] ".',
	'article-comments-comment-missing-name-parameter' => 'Namn saknas',
	'article-comments-comment-missing-date-parameter' => 'Datum för kommentar saknas',
	'article-comments-no-spam' => 'Minst ett av de inlämnade fälten var flaggat som spam.',
	'processcomment' => 'Bearbetar artikelkommentar',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'article-comments-title-string' => 'శీర్షిక',
	'article-comments-name-string' => 'పేరు',
	'article-comments-name-field' => 'పేరు (తప్పనిసరి):',
	'article-comments-url-field' => 'వెబ్ సైటు:',
	'article-comments-comment-string' => 'వ్యాఖ్య',
	'article-comments-comment-field' => 'వ్యాఖ్య:',
	'article-comments-submit-button' => 'దాఖలుచెయ్యి',
	'article-comments-leave-comment-link' => 'వ్యాఖ్యానించండి ...',
	'article-comments-required-field' => '"$1" అనే ఖాళీ తప్పనిసరి.',
	'article-comments-failure-reasons' => 'ఈ క్రింది {{PLURAL:$1|కారణం|కారణాల}} వల్ల మీ వ్యాఖ్య దాఖలు విఫలమైంది:',
	'article-comments-no-comments' => 'క్షమించండి, "[[$1]]" పుటలో ప్రస్తుతం వ్యాఖ్యలని అనుమతించుటలేదు.',
	'article-comments-talk-page-starter' => '<noinclude>"[[$1]]"పై వ్యాఖ్యలు
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 అన్నారు ...',
	'article-comments-submission-view-all' => '[[$1|ఆ పుటపై అన్ని వ్యాఖ్యలని]] మీరు చూడవచ్చు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'article-comments-name-string' => 'Naran',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'article-comments-desc' => 'Nagpapagana ng mga seksyon ng puna sa mga pahina ng nilalaman',
	'article-comments-title-string' => 'pamagat',
	'article-comments-name-string' => 'Pangalan',
	'article-comments-name-field' => 'Pangalan (kailangan):',
	'article-comments-url-field' => 'Websayt:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Puna',
	'article-comments-comment-field' => 'Puna:',
	'article-comments-submit-button' => 'Ipasa',
	'article-comments-leave-comment-link' => 'Mag-iwan ng puna ...',
	'article-comments-invalid-field' => 'Hindi katanggap-tanggap ang <nowiki>[$2]</nowiki> na ibinigay ng $1.',
	'article-comments-required-field' => 'Ang hanay na "$1" ay kailangan.',
	'article-comments-submission-failed' => 'Nabigo ang pagpapasa ng puna',
	'article-comments-failure-reasons' => 'Paumahin, nabigo ang pagpapasa mo ng puna dahil sa sumusunod na {{PLURAL:$1|dahilan|mga dahilan}}:',
	'article-comments-no-comments' => 'Paumanhin, ang pahinang "[[$1]]" ay hindi tumatanggap ng mga puna sa panahong ito.',
	'article-comments-talk-page-starter' => '<noinclude>Mga puna tungkol sa "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => 'Nagsabi si $1 ng ...',
	'article-comments-summary' => 'Punang ibinigay ni $1 - sa pamamagitan ng dugtong na ArticleComments',
	'article-comments-submission-succeeded' => 'Nagtagumpay ang pagpapasa ng puna',
	'article-comments-submission-success' => 'Matagumpay kang nakapagpasa ng isang puna para sa "[[$1]]"',
	'article-comments-submission-view-all' => 'Maaari mong tingnan ang [[$1|ang lahat ng mga puna na nasa pahinang iyan]]',
	'article-comments-user-is-blocked' => 'Pangkasalukuyang hinaharangan ang akawnt mo na pangtagagamit mula sa pamamatnugot ng "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Hindi tanggap ang anyong ibinigay para sa puna.
Ang makukuha ay "payak", "pangkaraniwan" at "wiki".',
	'article-comments-comment-missing-name-parameter' => 'Nawawalang pangalan',
	'article-comments-comment-missing-date-parameter' => 'Petsa ng nawawalang puna',
	'article-comments-no-spam' => 'Hindi bababa sa isa ng ipinasang mga hanay ay ibinandila bilang basura.',
	'processcomment' => 'Puna sa pahina ng proseso',
);

/** Turkish (Türkçe)
 * @author 82-145
 * @author Emperyan
 * @author Incelemeelemani
 * @author Karduelis
 */
$messages['tr'] = array(
	'article-comments-desc' => 'İçerik sayfalarında yorum bölümlerini devreye sokar',
	'article-comments-title-string' => 'başlık',
	'article-comments-name-string' => 'Adı',
	'article-comments-name-field' => 'Adı (gerekli)',
	'article-comments-url-field' => 'Web sitesi:',
	'article-comments-url-string' => 'Bağlantı (URL)',
	'article-comments-comment-string' => 'Açıklama',
	'article-comments-comment-field' => 'Yorum:',
	'article-comments-submit-button' => 'Gönder',
	'article-comments-leave-comment-link' => 'Yorum yaz ...',
	'article-comments-required-field' => '"$1" alanı gerekiyor.',
	'article-comments-submission-failed' => 'Yorum gönderme başarısız',
	'article-comments-talk-page-starter' => '<noinclude>"[[$1]]" yazısına yapılan yorumlar 
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1dedi ki...',
	'article-comments-submission-succeeded' => 'Yorum gönderme başarılı',
	'article-comments-comment-missing-name-parameter' => 'Eksik isim',
	'article-comments-comment-missing-date-parameter' => 'Eksik yorum tarihi',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 * @author Тест
 */
$messages['uk'] = array(
	'article-comments-desc' => 'Ввімкнути розділ коментарів на змістових сторінках',
	'article-comments-title-string' => 'назва',
	'article-comments-name-string' => "Ім'я",
	'article-comments-name-field' => "Назва (обов'язково):",
	'article-comments-url-field' => 'Веб-сайт:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'Коментар',
	'article-comments-comment-field' => 'Коментар:',
	'article-comments-submit-button' => 'Відправити',
	'article-comments-leave-comment-link' => 'Написати коментар ...',
	'article-comments-invalid-field' => 'Варіант $1, запропонований <nowiki>[$2]</nowiki> є недійсний.',
	'article-comments-required-field' => "Поле $1 — обов'язкове.",
	'article-comments-submission-failed' => 'Помилка відправки коментарів',
	'article-comments-failure-reasons' => 'На жаль, додавання вашого коментаря не відбулося через {{PLURAL:$1|наступну причину|наступні причини}}:',
	'article-comments-no-comments' => 'Нажаль, на сторінці  "[[$1]]" відхилена можливість додавати коментарі на цей час.',
	'article-comments-talk-page-starter' => '<noinclude> Коментарі на [[$1]] 
<comments />
 ----- __NOEDITSECTION__ </noinclude>',
	'article-comments-commenter-said' => '$1 сказав ...',
	'article-comments-summary' => 'Коментарі надаються $1 - використовуючи додаток ArticleComments',
	'article-comments-submission-succeeded' => 'Коментар був надісланий вдало.',
	'article-comments-submission-success' => 'Ви успішно додали коментар до "[[$1]]"',
	'article-comments-submission-view-all' => 'Ви можете переглянути [[$1|всі коментарі на цій сторінці]]',
	'article-comments-user-is-blocked' => 'Обліковий запис користувача в даний момент заблокований від редагування "[[$1]]".',
	'article-comments-comment-bad-mode' => 'Ви обрали невірний вид коментарів.
Потрібно використати коментарі виду "plain", "normal" або "wiki".',
	'article-comments-comment-missing-name-parameter' => "Відсутнє ім'я",
	'article-comments-comment-missing-date-parameter' => 'Відсутня дата коментарію',
	'article-comments-no-spam' => 'Принаймні один з представлених полів було відмічено як такий, що містить спам.',
	'processcomment' => 'Переглянути коментарі до матеріалу',
);

/** Urdu (اردو)
 * @author محبوب عالم
 */
$messages['ur'] = array(
	'article-comments-title-string' => 'عنوان',
	'article-comments-name-string' => 'نام',
	'article-comments-name-field' => 'نام (ضروری):',
	'article-comments-comment-string' => 'تبصرہ',
	'article-comments-comment-field' => 'تبصرہ:',
	'article-comments-submit-button' => 'بھیجو',
	'article-comments-leave-comment-link' => 'تبصرہ چھوڑئیے ۔۔۔',
	'article-comments-required-field' => '"$1" ضروری ہے۔',
	'article-comments-submission-failed' => 'تبصرہ بھیجنا ناکام',
	'article-comments-failure-reasons' => 'معذرت، آپ کا تبصرہ درج ذیل {{PLURAL:$1|وجہ|وجوہات}} کی بناء پر نہیں بھیجا جاسکا:',
	'article-comments-no-comments' => 'معذرت، صفحہ "[[$1]]" فی الحال تبصرے قبول نہیں کررہا۔',
	'article-comments-commenter-said' => '$1 نے کہا ...',
	'article-comments-submission-succeeded' => 'تبصرہ کامیابی سے بھیج دیا گیا',
	'article-comments-submission-success' => 'آپ نے "[[$1]]" کیلئے تبصرہ کامیابی سے بھیج دیا',
	'article-comments-user-is-blocked' => 'آپ کا کھاتا فی الحال "[[$1]]" میں تدوین کرنے سے ممنوع ہے۔',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'article-comments-title-string' => 'קעפל',
	'article-comments-name-string' => 'נאָמען',
	'article-comments-name-field' => 'נאָמען (נייטיק):',
	'article-comments-url-field' => 'וועבזײַטל:',
	'article-comments-url-string' => 'URL',
	'article-comments-comment-string' => 'הערה',
	'article-comments-comment-field' => 'הערה:',
	'article-comments-submit-button' => 'אײַנגעבן',
	'article-comments-leave-comment-link' => 'לאזן א הערה …',
	'article-comments-invalid-field' => 'דאס $1 <nowiki>[$2]</nowiki> איז אומגילטיק.',
	'article-comments-no-comments' => 'אנטשולדיקט, דער בלאט "[[$1]]" נעמט נישט קיין הערות דערווײַל.',
	'article-comments-talk-page-starter' => '<noinclude>הערות אויף "[[$1]]"
<comments />
----- __NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1 זאגט ...',
	'article-comments-submission-success' => 'איר האט אײַנגעגעבן א הערה צו "[[$1]]" מיט דערפֿאלג',
	'article-comments-submission-view-all' => 'איר קענט באקוקן [[$1|אלע הערות אויף דעם בלאט]]',
	'article-comments-comment-missing-name-parameter' => 'נאמען פֿעלט',
	'article-comments-comment-missing-date-parameter' => 'הערה דאטע פֿעלט',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'article-comments-desc' => '内容页上启用注释部分',
	'article-comments-title-string' => '标题',
	'article-comments-name-string' => '名字',
	'article-comments-name-field' => '名字（必须写一个）：',
	'article-comments-url-field' => '网址：',
	'article-comments-url-string' => '互联网地止',
	'article-comments-comment-string' => '评论',
	'article-comments-comment-field' => '评论：',
	'article-comments-submit-button' => '输入',
	'article-comments-leave-comment-link' => '留言...',
	'article-comments-invalid-field' => '$1 所提供的 <nowiki>[$2]</nowiki> 是无效的。',
	'article-comments-required-field' => '“$1”字段是必需的。',
	'article-comments-submission-failed' => '评论提交失败',
	'article-comments-failure-reasons' => '对不起，您的意见提交失败是由以下的{{PLURAL:$1|原因|原因}}：',
	'article-comments-no-comments' => '抱歉，页 "[[$1]]" 在这个时候不会接受的评论。',
	'article-comments-talk-page-starter' => '<noinclude>对"[[$1]]"评论
<comments />
----__NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1说。。。',
	'article-comments-summary' => '提供由 $1 - 通过 ArticleComments 扩展名的评论',
	'article-comments-submission-succeeded' => '评论提交成功',
	'article-comments-submission-success' => '您已成功为 "[[$1]]" 提交注释',
	'article-comments-submission-view-all' => '您可以查看[[$1|所有该页上的评论]]',
	'article-comments-user-is-blocked' => '您的用户帐户当前阻止编辑 "[[$1]]"。',
	'article-comments-comment-bad-mode' => '无效的模式给予评论。
"plain"、"normal"和"wiki"的可用的。',
	'article-comments-comment-missing-name-parameter' => '缺少名称',
	'article-comments-comment-missing-date-parameter' => '缺少注释的日期',
	'article-comments-no-spam' => '提交的字段中，至少一个被标记为垃圾邮件。',
	'processcomment' => '进程文章注释',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'article-comments-desc' => '內容頁上啟用注釋部分',
	'article-comments-title-string' => '標題',
	'article-comments-name-string' => '名字',
	'article-comments-name-field' => '名字（必須寫一個）：',
	'article-comments-url-field' => '網址：',
	'article-comments-url-string' => '互聯網地止',
	'article-comments-comment-string' => '評論',
	'article-comments-comment-field' => '評論：',
	'article-comments-submit-button' => '輸入',
	'article-comments-leave-comment-link' => '留言...',
	'article-comments-invalid-field' => '$1 所提供的 <nowiki>[$2]</nowiki> 是無效的。',
	'article-comments-required-field' => '“$1”字段是必需的。',
	'article-comments-submission-failed' => '評論提交失敗',
	'article-comments-failure-reasons' => '對不起，您的意見提交失敗是由以下的{{PLURAL:$1|原因|原因}}：',
	'article-comments-no-comments' => '抱歉，頁 "[[$1]]" 在這個時候不會接受的評論。',
	'article-comments-talk-page-starter' => '<noinclude>對"[[$1]]"評論
<comments />
----__NOEDITSECTION__</noinclude>',
	'article-comments-commenter-said' => '$1說。。。',
	'article-comments-summary' => '提供由 $1 - 通過 ArticleComments 擴展名的評論',
	'article-comments-submission-succeeded' => '評論提交成功',
	'article-comments-submission-success' => '您已成功為 "[[$1]]" 提交注釋',
	'article-comments-submission-view-all' => '您可以查看[[$1|所有該頁上的評論]]',
	'article-comments-user-is-blocked' => '您的用戶帳戶當前阻止編輯 "[[$1]]"。',
	'article-comments-comment-bad-mode' => '無效的模式給予評論。
"plain"、"normal"和"wiki"的可用的。',
	'article-comments-comment-missing-name-parameter' => '缺少名稱',
	'article-comments-comment-missing-date-parameter' => '缺少注釋的日期',
	'article-comments-no-spam' => '提交的字段中，至少一個被標記為垃圾郵件。',
	'processcomment' => '進程文章注釋',
);

/** Chinese (Hong Kong) (‪中文(香港)‬)
 * @author Oapbtommy
 */
$messages['zh-hk'] = array(
	'article-comments-title-string' => '標題',
	'article-comments-name-string' => '姓名',
	'article-comments-name-field' => '姓名（必須）：',
	'article-comments-url-field' => '網站：',
	'article-comments-url-string' => '網址',
	'article-comments-submit-button' => '提交',
	'article-comments-commenter-said' => '$1 說...',
	'article-comments-no-spam' => '至少有一個提交了的欄位已被標記為垃圾。',
);

