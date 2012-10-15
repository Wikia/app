<?php
/**
 * Internationalisation file for WikimediaIncubator extension.
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author SPQRobin
 */
$messages['en'] = array(
	'wminc-infopage-enter' => 'go to the Main Page',
	'wminc-unknownlang' => '(unknown language with code "$1")',
	'wminc-logo-wikipedia' => 'Wikipedia-logo-v2-en.svg', # only translate if necessary
	'wminc-logo-wiktionary' => 'Wiktionary-logo-en.svg', # only translate if necessary
	'wminc-logo-wikibooks' => 'Wikibooks-logo-en-noslogan.svg', # only translate if necessary
	'wminc-logo-wikinews' => 'Wikinews-logo-en.png', # only translate if necessary
	'wminc-logo-wikiquote' => 'Wikiquote-logo-en.svg', # only translate if necessary
	'wminc-logo-wikisource' => 'Wikisource-newberg-de.png', # only translate if necessary
	'wminc-logo-wikiversity' => 'Wikiversity-logo-en.svg', # only translate if necessary
	'wminc-logo-meta-wiki' => 'Metawiki.svg', # only translate if necessary
	'wminc-logo-wikimedia-commons' => 'Commons-logo-en.svg', # only translate if necessary
	'wminc-logo-wikispecies' => 'WikiSpecies.svg', # only translate if necessary
	'wminc-logo-mediawiki' => 'MediaWiki.svg', # only translate if necessary
	'wminc-manual-url' => 'Help:Manual', # only translate if necessary
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikibooks $1',
	'wminc-infopage-title-t' => 'Wiktionary $1',
	'wminc-infopage-title-q' => 'Wikiquote $1',
	'wminc-infopage-title-n' => 'Wikinews $1',
	'wminc-infopage-title-s' => 'Wikisource $1',
	'wminc-infopage-title-v' => 'Wikiversity $1',
	'wminc-infopage-welcome' => 'Welcome to the Wikimedia Incubator, a project of the Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|About]])',

	'wminc-infopage-missingwiki-text' => 'A $1 in this language does not yet exist.',
	'wminc-infopage-option-startwiki' => 'If you want to start this wiki,
you can [{{fullurl:{{FULLPAGENAME}}|action=edit}} create the page] and follow [[{{MediaWiki:Wminc-manual-url}}|our manual]].',
	'wminc-infopage-option-startsister' => 'If you want to start this wiki, you can go to <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'You can search for [//www.$1.org existing language editions of $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'You can search for existing projects in this language:',
	'wminc-infopage-option-sisterprojects-other' => 'You can search for other projects in this language:',
	'wminc-infopage-option-multilingual' => 'You can go to a multilingual wiki:',
	'wminc-infopage-createmainpage' => 'Enter the word "Main Page" in this language:',
	'wminc-infopage-prefill' => '{{test wiki
| status = tocreate
| language = Language name in English
| meta = <!-- is there a request on Meta-Wiki? -->
}}', # do not translate
	'wminc-infopage-contribute' => 'If you know this language, you are encouraged to contribute!',

	'wminc-infopage-status-imported' => 'This Incubator wiki has been imported from $1 after the wiki was closed.',
	'wminc-infopage-status-closedsister' => 'This subdomain was closed. Go to <b>$2</b> to contribute to this wiki.',
	'wminc-infopage-status-created' => 'This project has been approved by the language committee and is now available at $1.',
	'wminc-infopage-status-beforeincubator' => 'This project was created before Wikimedia Incubator started and is available at $1.',
);

/** Message documentation (Message documentation)
 * @author SPQRobin
 */
$messages['qqq'] = array(
	'wminc-infopage-enter' => 'Text of a link to the Main Page of a test wiki at Incubator.',
	'wminc-infopage-title-p' => "This is the main title of the info page. $1 is the language name from CLDR, i.e. it takes the name in your language if available. Otherwise, it's in English.",
	'wminc-infopage-title-b' => "This is the main title of the info page. $1 is the language name from CLDR, i.e. it takes the name in your language if available. Otherwise, it's in English.",
	'wminc-infopage-title-t' => "This is the main title of the info page. $1 is the language name from CLDR, i.e. it takes the name in your language if available. Otherwise, it's in English.",
	'wminc-infopage-title-q' => "This is the main title of the info page. $1 is the language name from CLDR, i.e. it takes the name in your language if available. Otherwise, it's in English.",
	'wminc-infopage-title-n' => "This is the main title of the info page. $1 is the language name from CLDR, i.e. it takes the name in your language if available. Otherwise, it's in English.",
	'wminc-infopage-title-s' => "This is the main title of the info page. $1 is the language name from CLDR, i.e. it takes the name in your language if available. Otherwise, it's in English.",
	'wminc-infopage-title-v' => "This is the main title of the info page. $1 is the language name from CLDR, i.e. it takes the name in your language if available. Otherwise, it's in English.",
	'wminc-infopage-welcome' => 'Do not change <tt><nowiki>{{MediaWiki:Aboutpage}}</nowiki></tt>.',
	'wminc-infopage-missingwiki-text' => "'''$1''' is a project: Wikipedia/Wiktionary/...",
	'wminc-infopage-option-startwiki' => 'Do not change <code><nowiki>{{fullurl:{{FULLPAGENAME}}|action=edit}}</nowiki></code> or <code><nowiki>{{MediaWiki:Wminc-manual-url}}</nowiki></code>',
	'wminc-infopage-option-startsister' => '$2 is a link to either Wikisource or Wikiversity, and $1 is that project name.',
	'wminc-infopage-option-languages-existing' => "'''$1''' is the project name (Wikipedia, Wikinews, ...).",
	'wminc-infopage-option-sisterprojects-existing' => 'Followed by clickable logos of projects Wikipedia, Wiktionary, Wikibooks, ...',
	'wminc-infopage-option-sisterprojects-other' => 'Followed by clickable logos of projects Wikipedia, Wiktionary, Wikibooks, ...',
	'wminc-infopage-option-multilingual' => 'Followed by clickable logos of Meta, Commons, Wikispecies and MediaWiki.',
	'wminc-infopage-createmainpage' => 'Followed by an input box to enter the translation for "Main Page".',
	'wminc-infopage-status-imported' => "'''$1''' is a URL to the closed wiki.",
	'wminc-infopage-status-closedsister' => 'Used for closed Wikisources or Wikiversities. $2 is a link to either project.',
	'wminc-infopage-status-created' => "'''$1''' is a URL to the existing wiki.",
	'wminc-infopage-status-beforeincubator' => "'''$1''' is a URL to the existing wiki.",
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wminc-unknownlang' => '(onbekende taal met kode "$1")',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikiboeke $1',
	'wminc-infopage-title-t' => 'Wiktionary $1',
	'wminc-infopage-title-q' => 'Wikiaanhalings $1',
	'wminc-infopage-title-n' => 'Wikinuus $1',
	'wminc-infopage-title-s' => 'Wikibron $1',
	'wminc-infopage-title-v' => 'Wikiversity $1',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'wminc-infopage-enter' => 'dir a la páxina principal',
	'wminc-unknownlang' => '(llingua desconocida con códigu "$1")',
	'wminc-infopage-welcome' => 'Bienveníos a Wikimedia Incubator, un proyeutu de la Fundación Wikimedia ([[{{MediaWiki:Aboutpage}}|Tocante a...]])',
	'wminc-infopage-missingwiki-text' => 'Inda nun esiste $1 nesta llingua.',
	'wminc-infopage-option-startwiki' => 'Si quies principiar esta wiki,
pues [{{fullurl:{{FULLPAGENAME}}|action=edit}} crear la páxina] y siguir [[{{MediaWiki:Wminc-manual-url}}|el nuesu manual]].',
	'wminc-infopage-option-startsister' => 'Si quies principiar esta wiki, pues dir a <b>[$1 en $2]</b>.',
	'wminc-infopage-option-languages-existing' => "Pues guetar les [//www.$1.org ediciones de les llingües nes qu'esiste $1].",
	'wminc-infopage-option-sisterprojects-existing' => 'Pues guetar proyeutos esistentes nesta llingua:',
	'wminc-infopage-option-sisterprojects-other' => 'Pues guetar otros proyeutos nesta llingua:',
	'wminc-infopage-option-multilingual' => 'Pues dir a una wiki multillingüe:',
	'wminc-infopage-createmainpage' => 'Escribi les pallabres "Páxina principal" nesta llingua:',
	'wminc-infopage-contribute' => '¡Si entiendes esta llingua, te afalamos a que collabores!',
	'wminc-infopage-status-imported' => "Esta wiki d'Incubator s'importó de $1 dempués de que la wiki zarrara.",
	'wminc-infopage-status-closedsister' => 'Esti subdominiu se zarró. Visita <b>$2</b> pa collaborar nesta wiki.',
	'wminc-infopage-status-created' => "Esti proyeutu s'aprobó pol comité de llingües y agora ta disponible en $1.",
	'wminc-infopage-status-beforeincubator' => 'Esti proyeutu se creó enantes que principiara Wikimedia Incubator y ta disponible en $1.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'wminc-infopage-enter' => 'Ana Səhifəyə get',
	'wminc-infopage-title-p' => 'Vikipediya $1',
	'wminc-infopage-title-b' => 'Vikikitab $1',
	'wminc-infopage-title-t' => 'Vikilüğət $1',
	'wminc-infopage-title-q' => 'Vikisitat $1',
	'wminc-infopage-title-n' => 'Vikixəbər $1',
	'wminc-infopage-title-s' => 'Vikimənbə $1',
	'wminc-infopage-title-v' => 'Vikiversitet $1',
);

/** Bashkir (Башҡортса)
 * @author Haqmar
 */
$messages['ba'] = array(
	'wminc-infopage-title-p' => 'Википедия $1',
	'wminc-infopage-title-b' => 'Викикитаптар $1',
	'wminc-infopage-title-t' => 'Викиһүҙлек $1',
	'wminc-infopage-title-q' => 'Викиөҙөмтә $1',
	'wminc-infopage-title-n' => 'Викияңылыҡтар $1',
	'wminc-infopage-title-s' => 'Викитека $1',
	'wminc-infopage-title-v' => 'Викиверситет $1',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'wminc-infopage-enter' => 'Gee zua da Hauptseiten',
	'wminc-unknownlang' => '(néd bekånnte Sprooch mid Code „$1“)',
	'wminc-infopage-welcome' => 'Servas im Wikimedia Incubator, am Prójekt voh da Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|Ywer]])',
	'wminc-infopage-missingwiki-text' => 'A $1 in derer Sprooch is nó néd vurhånden.',
	'wminc-infopage-option-startwiki' => 'Wånn du dés Wiki starten mecherdst,
kåst du [{{fullurl:{{FULLPAGENAME}}|action=edit}} dé Seiten erstön] und noch [[{{MediaWiki:Wminc-manual-url}}|unserner Åloattung]] vurgeh.',
	'wminc-infopage-option-languages-existing' => 'Du kåst auf [//www.$1.org noch vurhånderne Sproochausgom voh $1] suachen.',
	'wminc-infopage-option-sisterprojects-existing' => 'Du kåst noch vurhånderne Prójektt in derer Sprooch suachen:',
	'wminc-infopage-option-sisterprojects-other' => 'Du kåst noch ånderne Prójektt in derer Sprooch suachen:',
	'wminc-infopage-option-multilingual' => 'Du kåst zuaram mersprooching Wiki geh:',
	'wminc-infopage-createmainpage' => 'Gibs Wort fyr „Hauptseiten“ in derer Sprooch eih:',
	'wminc-infopage-contribute' => 'Wånnst du dé Sprooch bherrschst, bist dert oiwei gern eihgloon, midzmochen!',
	'wminc-infopage-status-imported' => 'Dés Wiki vom Incubator is voh $1 importird worn, nochdéms gschlóssen worn is.',
	'wminc-infopage-status-created' => 'Dés Prójekt is vom Sproochkómmitee gnemigt worn und is iatz unter $1 vafiagbor.',
	'wminc-infopage-status-beforeincubator' => "Dés Prójekt is erstöd worn, bevurs 'n Wikimedia Incubator geem hod und is unter $1 vafiagbor.",
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Renessaince
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'wminc-infopage-enter' => 'перайсьці на Галоўную старонку',
	'wminc-unknownlang' => '(невядомая мова з кодам «$1»)',
	'wminc-infopage-title-p' => 'Вікіпэдыя $1',
	'wminc-infopage-title-b' => 'ВікіКнігі $1',
	'wminc-infopage-title-t' => 'ВікіСлоўнік $1',
	'wminc-infopage-title-q' => 'ВікіЦытаты $1',
	'wminc-infopage-title-n' => 'ВікіНавіны $1',
	'wminc-infopage-title-s' => 'ВікіКрыніца $1',
	'wminc-infopage-title-v' => 'Віківэрсытэт $1',
	'wminc-infopage-welcome' => 'Вітаем у Інкубатары Вікімэдыя, праекце Фундацыі «Вікімэдыя» ([[{{MediaWiki:Aboutpage}}|Падрабязьней]])',
	'wminc-infopage-missingwiki-text' => '$1 на гэтай мове яшчэ не існуе.',
	'wminc-infopage-option-startwiki' => 'Калі Вы жадаеце распачаць гэтую вікі,
Вы можаце [{{fullurl:{{FULLPAGENAME}}|action=edit}} стварыць старонку] і выканаць [[{{MediaWiki:Wminc-manual-url}}|нашыя інструкцыі]].',
	'wminc-infopage-option-startsister' => 'Калі Вы хочаце пачаць гэтую вікі, перайдзіце на <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Вы можаце пашукаць [//www.$1.org існуючыя моўныя варыянты $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Вы можаце пашукаць існуючыя праекты на гэтай мове:',
	'wminc-infopage-option-sisterprojects-other' => 'Вы можаце пашукаць іншыя праекты на гэтай мове:',
	'wminc-infopage-option-multilingual' => 'Вы можаце перайсьці ў шматмоўную вікі:',
	'wminc-infopage-createmainpage' => 'Увядзіце словы «Галоўная старонка» на гэтай мове:',
	'wminc-infopage-contribute' => 'Калі Вы ведаеце гэтую мову, Вы можаце рабіць унёсак!',
	'wminc-infopage-status-imported' => 'Гэтая вікі ў інкубатары была імпартаваная з $1 пасьля таго, як вікі была закрытая.',
	'wminc-infopage-status-closedsister' => 'Гэты паддамэн закрыты. Перайдзіце на <b>$2</b>, каб напісаць у гэтую вікі.',
	'wminc-infopage-status-created' => 'Гэты праект быў зацьверджаны моўным камітэтам, і цяпер ён даступны на $1.',
	'wminc-infopage-status-beforeincubator' => 'Гэты праект быў створаны перад пачаткам функцыянаваньня Інкубатара фундацыі «Вікімэдыя» і ён даступны на $1.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'wminc-infopage-enter' => "mont d'ar Bajenn Degemer",
	'wminc-unknownlang' => '(yezh dianav dezhi ar c\'hod "$1")',
	'wminc-infopage-title-p' => 'Wikipedia e $1',
	'wminc-infopage-title-b' => 'Wikilevrioù e $1',
	'wminc-infopage-title-t' => 'Wikeriadur e $1',
	'wminc-infopage-title-q' => 'Wikiarroud e $1',
	'wminc-infopage-title-n' => 'Wikikeloù e $1',
	'wminc-infopage-title-s' => 'Wikimammenn e $1',
	'wminc-infopage-title-v' => 'Wikiskol-veur e $1',
	'wminc-infopage-welcome' => 'Degemer mat er Wikimedia Incubator, ur raktres eus Diazezadur Wikimedia ([[{{MediaWiki:Aboutpage}}|Diwar-benn]])',
	'wminc-infopage-missingwiki-text' => "N'eus ket a $1 er yezh-mañ.",
	'wminc-infopage-option-startwiki' => "Mar fell deoc'h sevel ar wiki-mañ,
e c'hallit [{{fullurl:{{FULLPAGENAME}}|action=edit}} kouiñ ar bajenn] ha heuliañ [[{{MediaWiki:Wminc-manual-url}}|hon dornlevr]].",
	'wminc-infopage-option-startsister' => "Mar fell deoc'h boulc'hañ ar wiki-mañ e c'hallit mont da <b>[$2 $1]</b>.",
	'wminc-infopage-option-languages-existing' => 'Gallout a rit klask [//www.$1.org stummoù yezh zo anezho eus $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Gallout a rit klask raktresoù zo anezho er yezh-mañ :',
	'wminc-infopage-option-sisterprojects-other' => 'Gallout a rit klask raktresoù all er yezh-mañ :',
	'wminc-infopage-option-multilingual' => "Gallout a rit mont d'ur wiki liesyezhek :",
	'wminc-infopage-createmainpage' => 'Merkit ar ger "Pajenn degemer" er yezh-mañ :',
	'wminc-infopage-contribute' => "Mard anavezit ar yezh-mañ e vroudomp ac'hanoc'h da gemer perzh !",
	'wminc-infopage-status-imported' => "Enporzhiet eo bet ar rakwiki-mañ eus $1 p'eo bet serret ar wiki.",
	'wminc-infopage-status-closedsister' => 'Serr eo an isdomani-mañ. Mont da <b>$2</b> evit kemer perzh er wiki-mañ.',
	'wminc-infopage-status-created' => "Aprouet eo bet ar raktres-mañ gant ar c'huzul yezh hag ez a en-dro bremañ war $1.",
	'wminc-infopage-status-beforeincubator' => "Savet e oa bet ar raktres-mañ a-raok na loc'hfe gorerez Wikimedia hag hegerz eo war $1.",
);

/** Czech (Česky)
 * @author Koo6
 * @author Mormegil
 */
$messages['cs'] = array(
	'wminc-infopage-option-startsister' => 'Chcete-li začít tuto wiki, můžete jít na <b>[$2 {{grammar:4sg|$1}}]</b>.',
);

/** German (Deutsch)
 * @author Kghbln
 * @author MF-Warburg
 * @author Polletfa
 */
$messages['de'] = array(
	'wminc-infopage-enter' => 'Geh zur Haupseite',
	'wminc-unknownlang' => '(unbekannte Sprache mit Code „$1“)',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikibooks $1',
	'wminc-infopage-title-t' => 'Wiktionary $1',
	'wminc-infopage-title-q' => 'Wikiquote $1',
	'wminc-infopage-title-n' => 'Wikinews $1',
	'wminc-infopage-title-s' => 'Wikisource $1',
	'wminc-infopage-title-v' => 'Wikiversity $1',
	'wminc-infopage-welcome' => 'Willkommen beim Wikimedia Incubator, einem Projekt der Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|Über]])',
	'wminc-infopage-missingwiki-text' => 'Ein $1 in dieser Sprache ist noch nicht vorhanden.',
	'wminc-infopage-option-startwiki' => 'Sofern du dieses Wiki starten möchtest,
kannst du [{{fullurl:{{FULLPAGENAME}}|action=edit}} die Seite erstellen] und gemäß [[{{MediaWiki:Wminc-manual-url}}|unserer Anleitung]] vorgehen.',
	'wminc-infopage-option-startsister' => 'Sofern du dieses Wiki starten möchtest, geh zu <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Du kannst auf [//www.$1.org nach vorhandenen Sprachausgaben von $1] suchen.',
	'wminc-infopage-option-sisterprojects-existing' => 'Du kannst nach vorhandenen Projekten in dieser Sprache suchen:',
	'wminc-infopage-option-sisterprojects-other' => 'Du kannst nach anderen Projekten in dieser Sprache suchen:',
	'wminc-infopage-option-multilingual' => 'Du kannst zu einem mehrsprachigen Wiki gehen:',
	'wminc-infopage-createmainpage' => 'Gib das Wort für „Hauptseite“ in dieser Sprache ein:',
	'wminc-infopage-contribute' => 'Sofern du diese Sprache beherrschst, bist du herzlich willkommen, mitzumachen!',
	'wminc-infopage-status-imported' => 'Dieses Wiki des Incubators wurde von $1 importiert, nachdem es geschlossen wurde.',
	'wminc-infopage-status-closedsister' => 'Diese Subdomain wurde geschlossen. Geh zu <b>$2</b>, um zu diesem Wiki beizutragen.',
	'wminc-infopage-status-created' => 'Dieses Projekt wurde vom Sprachkomitee genehmigt und ist nun unter $1 verfügbar..',
	'wminc-infopage-status-beforeincubator' => 'Dieses Projekt wurde erstellt, bevor es den Wikimedia Incubator gab und ist unter $1 verfügbar.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author Polletfa
 */
$messages['de-formal'] = array(
	'wminc-infopage-option-startwiki' => 'Sofern Sie dieses Wiki starten möchten,
können Sie [{{fullurl:{{FULLPAGENAME}}|action=edit}} die Seite erstellen] und gemäß [[{{MediaWiki:Wminc-manual-url}}|unserer Anleitung]] vorgehen.',
	'wminc-infopage-option-startsister' => 'Sofern Sie dieses Wiki starten möchten, gehen Sie zu <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Sie können auf [//www.$1.org nach vorhandenen Sprachausgaben von $1] suchen.',
	'wminc-infopage-option-sisterprojects-existing' => 'Sie können nach vorhandenen Projekten in dieser Sprache suchen:',
	'wminc-infopage-option-sisterprojects-other' => 'Sie können nach anderen Projekten in dieser Sprache suchen:',
	'wminc-infopage-option-multilingual' => 'Sie können ein mehrsprachiges Wiki aufsuchen:',
	'wminc-infopage-createmainpage' => 'Geben Sie das Wort für „Hauptseite“ in dieser Sprache ein:',
	'wminc-infopage-contribute' => 'Wenn Sie diese Sprache beherrschen, sind Sie herzlich willkommen, mitzumachen!',
	'wminc-infopage-status-closedsister' => 'Diese Subdomain wurde geschlossen. Gehen Sie zu <b>$2</b>, um zu diesem Wiki beizutragen.',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 */
$messages['el'] = array(
	'wminc-infopage-enter' => 'Πηγαίνετε στην κύρια σελίδα',
	'wminc-infopage-title-p' => 'Βικιπαίδεια $1',
	'wminc-infopage-title-b' => 'Βικιβιβλία $1',
	'wminc-infopage-title-t' => 'Βικιλεξικό $1',
	'wminc-infopage-title-q' => 'Βικιφθέγματα $1',
	'wminc-infopage-title-n' => 'Βικινέα $1',
	'wminc-infopage-title-s' => 'Βικιθήκη $1',
	'wminc-infopage-title-v' => 'Βικιεπιστήμιο $1',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'wminc-unknownlang' => '(nekonata lingvo kun kodo "$1")',
	'wminc-infopage-title-p' => 'Vikipedio $1',
	'wminc-infopage-title-b' => 'Vikilibroj $1',
	'wminc-infopage-title-t' => 'Vikivortaro $1',
	'wminc-infopage-title-q' => 'Vikicitaro $1',
	'wminc-infopage-title-n' => 'Vikinovaĵoj $1',
	'wminc-infopage-title-s' => 'Vikifontaro $1',
	'wminc-infopage-title-v' => 'Vikiversitio $1',
	'wminc-infopage-missingwiki-text' => '$1 en ĉi tiu linvo ne jam ekzistas.',
	'wminc-infopage-option-sisterprojects-other' => 'Vi povas serĉi aliajn projektojn en ĉi tiu lingvo:',
	'wminc-infopage-createmainpage' => 'Eniru la vorton "Ĉefpaĝon" laŭ ĉi tiu lingvo:',
	'wminc-infopage-contribute' => 'Se vi scipovas ĉi tiun lingvon, vi estas kuraĝigita por kontribui!',
);

/** Spanish (Español)
 * @author Diotime
 * @author Drini
 * @author Fitoschido
 * @author Imre
 */
$messages['es'] = array(
	'wminc-infopage-enter' => 'ir a la página principal',
	'wminc-unknownlang' => '(idioma desconocido con código «$1»)',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikilibros $1',
	'wminc-infopage-title-t' => 'Wikcionario $1',
	'wminc-infopage-title-q' => 'Wikiquote $1',
	'wminc-infopage-title-n' => 'Wikinoticias $1',
	'wminc-infopage-title-s' => 'Wikisource $1',
	'wminc-infopage-title-v' => 'Wikiversidad $1',
	'wminc-infopage-welcome' => 'Bienvenidos a la Incubadora de Wikimedia, un proyecto de la Fundación Wikimedia ([[{{MediaWiki:Aboutpage}}|Acerca de]])',
	'wminc-infopage-missingwiki-text' => 'Un $1 en este idioma todavía no existe.',
	'wminc-infopage-option-startwiki' => 'Si deseas comenzar este wiki,
puedes [{{fullurl:{{FULLPAGENAME}}|action=edit}} crear la página] y seguir [[{{MediaWiki:Wminc-manual-url}}|nuestro manual]].',
	'wminc-infopage-option-startsister' => 'Si deseas iniciar esta wiki, puedes ir a <b>[$2 $1].</b>',
	'wminc-infopage-option-languages-existing' => 'Puede buscar [//www.$1.org ediciones existentes en el idioma $1 ].',
	'wminc-infopage-option-sisterprojects-existing' => 'Puedes buscar proyectos existentes en este idioma:',
	'wminc-infopage-option-sisterprojects-other' => 'Puedes buscar otros proyectos en este idioma:',
	'wminc-infopage-option-multilingual' => 'Puedes ir a un wiki multilingüe:',
	'wminc-infopage-createmainpage' => 'Introduce las palabras «Página principal» en este idioma:',
	'wminc-infopage-contribute' => '¡Si entiendes esta lengua, te animamos a contribuir!',
	'wminc-infopage-status-imported' => 'Este wiki de la Incubadora se importó desde $1 después de que el wiki fuera cerrado.',
	'wminc-infopage-status-closedsister' => 'Este subdominio se cerró. Ir a <b>$2</b> para contribuir a este wiki.',
	'wminc-infopage-status-created' => 'Este proyecto ha sido aprobado por el Comité de idiomas y ahora está disponible en $1.',
	'wminc-infopage-status-beforeincubator' => 'Este proyecto fue creado antes de que la Incubadora de Wikimedia comenzara y está disponible en $1.',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'wminc-infopage-enter' => 'mine esilehele',
	'wminc-unknownlang' => '(tundmatu keel koodiga "$1")',
	'wminc-infopage-title-p' => '$1 Vikipeedia',
	'wminc-infopage-title-b' => '$1 Vikiõpikud',
	'wminc-infopage-title-t' => '$1 Vikisõnastik',
	'wminc-infopage-title-q' => '$1 Vikitsitaadid',
	'wminc-infopage-title-n' => '$1 Vikiuudised',
	'wminc-infopage-title-s' => '$1 Vikitekstid',
	'wminc-infopage-title-v' => '$1 Vikiülikool',
	'wminc-infopage-welcome' => 'Tere tulemast Wikimedia Inkubaatorisse. Tegu on Wikimedia Foundationi projektiga ([[{{MediaWiki:Aboutpage}}|teave]]).',
	'wminc-infopage-missingwiki-text' => '$1-projekt puudub seni selles keeles.',
	'wminc-infopage-option-startwiki' => 'Kui soovid vikit alustada,
saad [{{fullurl:{{FULLPAGENAME}}|action=edit}} lehekülje luua] ja järgida [[{{MediaWiki:Wminc-manual-url}}|meie juhendit]].',
	'wminc-infopage-option-startsister' => 'Kui soovid seda vikit alustada, tee seda leheküljel <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Saad otsida [//www.$1.org $1-projekti olemasolevaid keeleversioone].',
	'wminc-infopage-option-sisterprojects-existing' => 'Saad otsida olemasolevaid samakeelseid projekte:',
	'wminc-infopage-option-sisterprojects-other' => 'Saad otsida teisi samakeelseid projekte:',
	'wminc-infopage-option-multilingual' => 'Saad minna mitmekeelsetesse vikidesse:',
	'wminc-infopage-createmainpage' => 'Sisesta sõna "Esileht" selles keeles:',
	'wminc-infopage-contribute' => 'Kui oskad seda keelt, on sinu kaastöö oodatud!',
	'wminc-infopage-status-imported' => 'See inkubaatori viki on pärast selle sulgemist imporditud asukohast $1.',
	'wminc-infopage-status-closedsister' => 'See alamdomeen suleti. Sellele vikile saad kaastööd teha asukohas <b>$2</b>.',
	'wminc-infopage-status-created' => 'Keelekomitee on selle projekti heaks kiitnud ja see on nüüd saadaval asukohas $1.',
	'wminc-infopage-status-beforeincubator' => 'Selle projektiga alustati enne Wikimedia Inkubaatori avamist ja see on saadaval asukohas $1.',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'wminc-infopage-enter' => 'رفتن به صفحهٔ اصلی',
	'wminc-unknownlang' => '(کد زبان ناشناخته: «$1»)',
	'wminc-infopage-welcome' => 'به ویکی‌رشد، پروژه‌ای از بنیاد ویکی‌مدیا خوش‌آمدید ([[{{MediaWiki:Aboutpage}}|درباره]])',
	'wminc-infopage-missingwiki-text' => 'یک $1 از این زبان، هنوز وجود ندارد.',
	'wminc-infopage-option-startwiki' => 'اگر شما می‌خواهید این ویکی را شروع کنید،
شما می‌توانید [{{fullurl:{{FULLPAGENAME}}|action=edit}} صفحه را ایجاد کنید] و از [[{{MediaWiki:Wminc-manual-url}}|راهنمای ما]] پیروی کنید.',
	'wminc-infopage-option-languages-existing' => 'شما می‌توانید به دنبال [//www.$1.org نسخه‌های زبان موجود از $1] بگردید.',
	'wminc-infopage-option-sisterprojects-existing' => 'شما می‌توانید به دنبال پروژه‌های موجود از این زبان بگردید:',
	'wminc-infopage-option-sisterprojects-other' => 'شما می‌توانید به دنبال پروژه‌های دیگر این زبان بگردید:',
	'wminc-infopage-option-multilingual' => 'شما می‌توانید به ویکی چند زبانه بروید:',
	'wminc-infopage-createmainpage' => 'کلمه «صفحهٔ اصلی» برای این زبان را وارد کنید:',
	'wminc-infopage-contribute' => 'اگر شما این زبان را می‌دانید، شما به مشارکت در آن تشویق شده‌اید!',
	'wminc-infopage-status-imported' => 'این ویکی در حال رشد پس از بسته شدن از نشانی $1 وارد شده است.',
	'wminc-infopage-status-created' => 'این پروژه توسط کمیته زبان تصویب شده است و در نشانی $1 در دسترس است.',
	'wminc-infopage-status-beforeincubator' => 'این پروژه قبل از شروع ویکی‌رشد، ایجاد شده است و در نشانی $1 در دسترس است.',
);

/** Finnish (Suomi)
 * @author Nedergard
 * @author Nike
 * @author Olli
 */
$messages['fi'] = array(
	'wminc-infopage-enter' => 'siirry etusivulle',
	'wminc-unknownlang' => '(tuntematon kieli, jonka koodi on ”$1”)',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikikirjasto $1',
	'wminc-infopage-title-t' => 'Wikisanakirja $1',
	'wminc-infopage-title-q' => 'Wikisitaatit $1',
	'wminc-infopage-title-n' => 'Wikiuutiset $1',
	'wminc-infopage-title-s' => 'Wikiaineisto $1',
	'wminc-infopage-title-v' => 'Wikiopisto $1',
	'wminc-infopage-welcome' => 'Tervetuloa Wikimedia Hautomoon, Wikimedia Foundationin projektiin ([[{{MediaWiki:Aboutpage}}|tietoja]])',
	'wminc-infopage-missingwiki-text' => '$1-hanketta ei ole vielä tällä kielellä.',
	'wminc-infopage-option-startwiki' => 'Jos haluat aloittaa tämän wikin, voit [{{fullurl:{{FULLPAGENAME}}|action=edit}} luoda sivun] ja seurata [[{{MediaWiki:Wminc-manual-url}}|käsikirjamme ohjeita]].',
	'wminc-infopage-option-startsister' => 'Jos haluat aloittaa tämän wikin, voit mennä sivulle <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Voit etsiä [//www.$1.org sivuston $1 muita kieliversioita].',
	'wminc-infopage-option-sisterprojects-existing' => 'Voit etsiä nykyisiä hankkeita tällä kielellä:',
	'wminc-infopage-option-sisterprojects-other' => 'Voit etsiä muita hankkeita tällä kielellä:',
	'wminc-infopage-option-multilingual' => 'Voit siirtyä monikieliseen wikiin:',
	'wminc-infopage-createmainpage' => 'Syötä sana "Etusivu" tällä kielellä:',
	'wminc-infopage-contribute' => 'Jos osaat tätä kieltä, muokkaa rohkeasti!',
	'wminc-infopage-status-imported' => 'Tämä Incubator-wiki on tuotu osoitteesta $1, kun wiki suljettiin.',
	'wminc-infopage-status-closedsister' => 'Tämä aliverkkotunnus on suljettu. Siirry osoitteeseen <b>$2</b> muokataksesi wikiä.',
	'wminc-infopage-status-created' => 'Kielikomitea on hyväksynyt tämän projektin ja se on nyt saatavilla osoitteessa $1.',
	'wminc-infopage-status-beforeincubator' => 'Tämä projekti luotiin ennen kuin Wikimedia Incubator käynnistettiin ja se on saatavilla osoitteessa $1.',
);

/** French (Français)
 * @author Crochet.david
 * @author Hashar
 * @author Seb35
 */
$messages['fr'] = array(
	'wminc-infopage-enter' => 'aller à la page principale',
	'wminc-unknownlang' => '(langue inconnue avec le code « $1 »)',
	'wminc-infopage-title-p' => 'Wikipédia $1',
	'wminc-infopage-title-b' => 'Wikibooks $1',
	'wminc-infopage-title-t' => 'Wiktionnaire $1',
	'wminc-infopage-title-q' => 'Wikiquote $1',
	'wminc-infopage-title-n' => 'Wikinews $1',
	'wminc-infopage-title-s' => 'Wikisource $1',
	'wminc-infopage-title-v' => 'Wikiversité $1',
	'wminc-infopage-welcome' => 'Bienvenue sur l’Incubateur Wikimedia, un projet de la Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|à propos]])',
	'wminc-infopage-missingwiki-text' => '$1 dans cette langue n’existe pas.',
	'wminc-infopage-option-startwiki' => 'Si vous voulez démarrer ce wiki, vous pouvez [{{fullurl:{{FULLPAGENAME}}|action=edit}} créer cette page] et suivre [[{{MediaWiki:Wminc-manual-url}}|notre manuel]].',
	'wminc-infopage-option-startsister' => 'Si vous voulez commencer ce wiki, vous pouvez vous rendre sur <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Vous pouvez chercher des [//www.$1.org versions linguistiques existantes de $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Vous pouvez chercher des projets existants dans cette langue :',
	'wminc-infopage-option-sisterprojects-other' => 'Vous pouvez chercher d’autres projets dans cette langue :',
	'wminc-infopage-option-multilingual' => 'Vous pouvez aller vers un wiki multilingue :',
	'wminc-infopage-createmainpage' => 'Entrez le mot « Page principale » dans votre langue :',
	'wminc-infopage-contribute' => 'Si vous parlez cette langue, vous êtes invités à contribuer !',
	'wminc-infopage-status-imported' => 'Ce wiki Incubateur a été importé depuis $1 après que le wiki ait été fermé.',
	'wminc-infopage-status-closedsister' => 'Ce sous-domaine a été fermé. Veuillez vous rendre sur <b>$2</b> pour contribuer à ce wiki.',
	'wminc-infopage-status-created' => 'Ce projet a été approuvé par le comité linguistique et est maintenant disponible sur $1.',
	'wminc-infopage-status-beforeincubator' => 'Ce projet a été créé avant que l’Incubateur Wikimedia ait été lancé et est disponible sur $1.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'wminc-infopage-enter' => 'alar a la pâge principâla',
	'wminc-unknownlang' => '(lengoua encognua avouéc lo code « $1 »)',
	'wminc-infopage-title-p' => 'Vouiquipèdia $1',
	'wminc-infopage-title-b' => 'Vouiquilévros $1',
	'wminc-infopage-title-t' => 'Vouiccionèro $1',
	'wminc-infopage-title-q' => 'Vouiquicitacions $1',
	'wminc-infopage-title-n' => 'Vouiquinovèles $1',
	'wminc-infopage-title-s' => 'Vouiquisôrsa $1',
	'wminc-infopage-title-v' => 'Vouiquivèrsitât $1',
	'wminc-infopage-welcome' => 'Benvegnua sur la Covosa Wikimedia, un projèt de la Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|A propôs]])',
	'wminc-infopage-missingwiki-text' => '$1 dens cela lengoua ègziste pas.',
	'wminc-infopage-option-startwiki' => 'Se vos voléd emmodar cél vouiqui,
vos pouede [{{fullurl:{{FULLPAGENAME}}|action=edit}} fâre la pâge] et pués siuvre [[{{MediaWiki:Wminc-manual-url}}|noutron manuâl]].',
	'wminc-infopage-option-languages-existing' => 'Vos pouede chèrchiér des [//www.$1.org vèrsions lengouistiques ègzistentes de $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Vos pouede chèrchiér des projèts ègzistents dens cela lengoua :',
	'wminc-infopage-option-sisterprojects-other' => 'Vos pouede chèrchiér d’ôtros projèts dens cela lengoua :',
	'wminc-infopage-option-multilingual' => 'Vos pouede alar vers un vouiqui multilingo :',
	'wminc-infopage-createmainpage' => 'Buchiéd lo mot « Pâge principâla » dens voutra lengoua :',
	'wminc-infopage-status-imported' => 'Ceti vouiqui Covosa at étâ importâ dês $1 aprés que lo vouiqui èye étâ cllôs.',
	'wminc-infopage-status-created' => 'Ceti projèt at étâ aprovâ per lo comitât lengouistico et est ora disponiblo dessus $1.',
	'wminc-infopage-status-beforeincubator' => 'Ceti projèt at étâ fêt aprés que la Covosa Wikimedia èye étâ lanciê et est disponiblo dessus $1.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wminc-infopage-enter' => 'ir á páxina principal',
	'wminc-unknownlang' => '(lingua descoñecida co código "$1")',
	'wminc-infopage-title-p' => 'Wikipedia en $1',
	'wminc-infopage-title-b' => 'Wikibooks en $1',
	'wminc-infopage-title-t' => 'Wiktionary en $1',
	'wminc-infopage-title-q' => 'Wikiquote en $1',
	'wminc-infopage-title-n' => 'Wikinews en $1',
	'wminc-infopage-title-s' => 'Wikisource en $1',
	'wminc-infopage-title-v' => 'Wikiversity en $1',
	'wminc-infopage-welcome' => 'Benvido á Incubadora da Wikimedia, un proxecto da Fundación Wikimedia ([[{{MediaWiki:Aboutpage}}|acerca de]])',
	'wminc-infopage-missingwiki-text' => 'Aínda non existe $1 nesta lingua.',
	'wminc-infopage-option-startwiki' => 'Se quere comezar este wiki,
pode [{{fullurl:{{FULLPAGENAME}}|action=edit}} crear esta páxina] e seguir [[{{MediaWiki:Wminc-manual-url}}|o noso manual]].',
	'wminc-infopage-option-startsister' => 'Se quere comezar este wiki, pode ir a <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Pode ollar [//www.$1.org as linguas nas que hai $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Pode ollar os proxectos que hai nesta lingua:',
	'wminc-infopage-option-sisterprojects-other' => 'Pode ollar outros proxectos que hai nesta lingua:',
	'wminc-infopage-option-multilingual' => 'Pode ir a un wiki multilingüe:',
	'wminc-infopage-createmainpage' => 'Escriba as palabras "Páxina principal" nesta lingua:',
	'wminc-infopage-contribute' => 'Se coñece esta lingua, animámolo a contribuír!',
	'wminc-infopage-status-imported' => 'Este wiki da Incubadora foi importado desde $1 despois de que o wiki pechase.',
	'wminc-infopage-status-closedsister' => 'Este subdominio foi pechado. Vaia a <b>$2</b> para contribuír neste wiki.',
	'wminc-infopage-status-created' => 'Este proxecto foi aprobado polo comité de linguas e agora está dispoñible en $1.',
	'wminc-infopage-status-beforeincubator' => 'Este proxecto foi creado antes ca a Incubadora da Wikimedia e está dispoñible en $1.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'wminc-infopage-title-p' => 'Βικιπαιδεία $1',
	'wminc-infopage-title-b' => 'Βικιβιβλία $1',
	'wminc-infopage-title-t' => 'Βικιλεξικόν $1',
	'wminc-infopage-title-q' => 'Βικιφθέγματα $1',
	'wminc-infopage-title-n' => 'Βικιεπίκαιρα $1',
	'wminc-infopage-title-s' => 'Βικιθήκη $1',
	'wminc-infopage-title-v' => 'Βικιεπιστήμιον $1',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'wminc-infopage-enter' => 'אל הדף הראשי',
	'wminc-unknownlang' => '(שפה לא ידועה עם הקוד "$1")',
	'wminc-infopage-title-p' => 'ויקיפדיה ב$1',
	'wminc-infopage-title-b' => 'ויקיספר ב$1',
	'wminc-infopage-title-t' => 'ויקימילון ב$1',
	'wminc-infopage-title-q' => 'ויקיציטוט ב$1',
	'wminc-infopage-title-n' => 'ויקיחדשות ב$1',
	'wminc-infopage-title-s' => 'ויקיטקסט ב$1',
	'wminc-infopage-title-v' => 'ויקיברסיטה ב$1',
	'wminc-infopage-welcome' => 'ברוכים הבאים לאינקובטור של ויקימדיה, מיזם של קרן ויקימדיה ([[{{MediaWiki:Aboutpage}}|אודות]])',
	'wminc-infopage-missingwiki-text' => 'מיזם $1 בשפה הזאת טרם נוצר.',
	'wminc-infopage-option-startwiki' => 'אם אתם רוצים להתחיל את הוויקי הזה,
אתם יכולים [{{fullurl:{{FULLPAGENAME}}|action=edit}} ליצור דף] ולעקום אחר [[{{MediaWiki:Wminc-manual-url}}|ספר ההוראות שלנו]].',
	'wminc-infopage-option-startsister' => 'אם אתם רוצים להתחיל את הוויקי הזה, תוכלו ללכת ל־<b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'אפשר לחפש [//www.$1.org מהדורות לשוניות קיימות של $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'אפשר לחפש מיזמים קיימים בשפה הזאת:',
	'wminc-infopage-option-sisterprojects-other' => 'אפשר לחפש מיזמים אחרים בשפה הזאת:',
	'wminc-infopage-option-multilingual' => 'אפשר ללכת לוויקי רב־לשוני:',
	'wminc-infopage-createmainpage' => 'כתבו את המילה "דף ראשי" בשפתכם:',
	'wminc-infopage-contribute' => 'אם אתם יודעים את השפה הזאת, אנו מפצירים בכם לתרום למיזם!',
	'wminc-infopage-status-imported' => 'ויקי האינקובטור הזה יובא מ{{GRAMMAR:תחילית|$1}} אחרי שהוויקי ההוא נסגר.',
	'wminc-infopage-status-closedsister' => 'התת־מתחם הזה נסגר. לכו אל <b>$2</b> כדי לתרום לוויקי הזה.',
	'wminc-infopage-status-created' => 'הוועדה הלשונית אישרה את המיזם הזה ואפשר למצוא אותו ב{{GRAMMAR:תחילית|$1}}.',
	'wminc-infopage-status-beforeincubator' => 'המיזם הזה נוצר לפני שהוקם האינקובטור של ויקימדיה והוא זמין ב{{GRAMMAR:תחילית|$1}}.',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Vibhijain
 */
$messages['hi'] = array(
	'wminc-infopage-enter' => 'मुख्य पृष्ठ पर जाएँ',
	'wminc-infopage-title-p' => 'विकिपीड़िया $1',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'wminc-infopage-enter' => 'dźi k hłownej stronje',
	'wminc-unknownlang' => '(njeznata rěč z kodom "$1")',
	'wminc-infopage-title-p' => 'Wikipedija $1',
	'wminc-infopage-title-b' => 'Wikiknihi $1',
	'wminc-infopage-title-t' => 'Wikisłownik $1',
	'wminc-infopage-title-q' => 'Wikicitat $1',
	'wminc-infopage-title-n' => 'Wikinowinki $1',
	'wminc-infopage-title-s' => 'Wikižórło $1',
	'wminc-infopage-title-v' => 'Wikiwersita $1',
	'wminc-infopage-welcome' => 'Witaj do inkubatora Wikimedije, projekt załožby Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|Wo]])',
	'wminc-infopage-missingwiki-text' => '$1 w tutej rěči hišće njeeksistuje.',
	'wminc-infopage-option-startwiki' => 'Jeli chceš tutón wiki startować,
móžeš [{{fullurl:{{FULLPAGENAME}}|action=edit}} stronu wutworić] a po [[{{MediaWiki:Wminc-manual-url}}|našim nawodźe]] postupować.',
	'wminc-infopage-option-startsister' => 'Jeli chceš tutón wiki startować, móžeš k <b>[$2 $1]</b> hić.',
	'wminc-infopage-option-languages-existing' => 'Móžeš za [//www.$1.org eksistowacymi rěčnymi wudaćemi projekta $1] pytać.',
	'wminc-infopage-option-sisterprojects-existing' => 'Móžeš za eksistowacymi projektami w tutej rěči pytać:',
	'wminc-infopage-option-sisterprojects-other' => 'Móžeš za druhimi projektami w tutej rěči pytać:',
	'wminc-infopage-option-multilingual' => 'Móžeš k wjacerěčnemu wikijej hić:',
	'wminc-infopage-createmainpage' => 'Zapodaj wuraz za "Hłowna strona" w tutej rěči:',
	'wminc-infopage-contribute' => 'Jeli tutu rěč wobknježiš, budź witany a čiń sobu!',
	'wminc-infopage-status-imported' => 'Tutón wiki inkubatora je so z $1 importował, po tym zo bě so wiki začinił.',
	'wminc-infopage-status-closedsister' => 'Tuta poddomena je so začiniła. Dźi k <b>$2</b>, zo by k tutomu wikijej přinošował.',
	'wminc-infopage-status-created' => 'Tutón projekt je so wot rěčneho komiteja schwalił a steji nětko pod $1 k dispoziciji.',
	'wminc-infopage-status-beforeincubator' => 'Tutón projekt je so wutworił, prjedy hač inkubator Wikimedije je so startował a steji pod $1 k dispoziciji.',
);

/** Hungarian (Magyar)
 * @author Dj
 * @author Xbspiro
 */
$messages['hu'] = array(
	'wminc-infopage-enter' => 'Tovább',
	'wminc-unknownlang' => '(ismeretlen nyelvkód „$1”)',
	'wminc-infopage-title-p' => '$1 Wikipédia',
	'wminc-infopage-title-b' => '$1 Wikikönyvek',
	'wminc-infopage-title-t' => '$1 Wikiszótár',
	'wminc-infopage-title-q' => '$1 Wikidézet',
	'wminc-infopage-title-n' => '$1 Wikihírek',
	'wminc-infopage-title-s' => '$1 Wikiforrás',
	'wminc-infopage-title-v' => '$1 Wikiegyetem',
	'wminc-infopage-welcome' => 'Üdvözöljük a Wikimédia Inkubátorban, amely a Wikimédia Alapítvány projektje ([[{{MediaWiki:Aboutpage}}|Névjegy]])',
	'wminc-infopage-missingwiki-text' => '$1 nem létezik ezen a nyelven.',
	'wminc-infopage-option-startwiki' => 'Ha el akarod kezdeni ezt a wikit,
[{{fullurl:{{FULLPAGENAME}}|action=edit}} hozd létre az oldalt] és kövesd a [[{{MediaWiki:Wminc-manual-url}}|felhasználói kézikönyvet]].',
	'wminc-infopage-option-startsister' => 'Ha el akarod kezdeni ezt a wikit, menj ide: <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Keresheted [//www.$1.org $1 létező nyelvi változatát].',
	'wminc-infopage-option-sisterprojects-existing' => 'Kereshetsz létező projekteket ezen a nyelven:',
	'wminc-infopage-option-sisterprojects-other' => 'Kereshetsz más projekteket ezen a nyelven:',
	'wminc-infopage-option-multilingual' => 'Mehetsz egy többnyelvű wikibe:',
	'wminc-infopage-createmainpage' => 'Add meg a „Főoldal” nevét ezen a nyelven:',
	'wminc-infopage-contribute' => 'Ha ismered ezt a nyelvet, akkor bátran működj közre a szerkesztésben!',
	'wminc-infopage-status-imported' => 'Ez az Inkubátor wiki innen lett importálva, miután lezárásra került: $1.',
	'wminc-infopage-status-closedsister' => 'Ez az aldomén lezárva. Az alábbi helyen tudsz közreműködni: <b>$2</b>.',
	'wminc-infopage-status-created' => 'Ez a projekt a nyelvi bizottság által elfogadásra került és most hozzáférhető itt: $1.',
	'wminc-infopage-status-beforeincubator' => 'Ez a projekt a Wikimedia Inkubátor előtt indult és elérhet itt: $1.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wminc-infopage-enter' => 'vader al pagina principal',
	'wminc-unknownlang' => '(lingua incognite con codice "$1")',
	'wminc-infopage-title-p' => 'Wikipedia in $1',
	'wminc-infopage-title-b' => 'Wikibooks in $1',
	'wminc-infopage-title-t' => 'Wiktionary in $1',
	'wminc-infopage-title-q' => 'Wikiquote in $1',
	'wminc-infopage-title-n' => 'Wikinews in $1',
	'wminc-infopage-title-s' => 'Wikisource in $1',
	'wminc-infopage-title-v' => 'Wikiversity in $1',
	'wminc-infopage-welcome' => 'Benvenite a Wikimedia Incubator, un projecto del Fundation Wikimedia ([[{{MediaWiki:Aboutpage}}|a proposito]])',
	'wminc-infopage-missingwiki-text' => 'Un $1 in iste lingua non existe ancora.',
	'wminc-infopage-option-startwiki' => 'Si tu vole comenciar iste wiki,
tu pote [{{fullurl:{{FULLPAGENAME}}|action=edit}} crear le pagina] e sequer [[{{MediaWiki:Wminc-manual-url}}|nostre manual]].',
	'wminc-infopage-option-startsister' => 'Si tu vole comenciar iste wiki, tu pote vader a <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Tu pote cercar [//www.$1.org existente editiones de lingua de $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Tu pote cercar projectos existente in iste lingua:',
	'wminc-infopage-option-sisterprojects-other' => 'Tu pote cercar altere projectos in iste lingua:',
	'wminc-infopage-option-multilingual' => 'Tu pote vader a un wiki multilingue:',
	'wminc-infopage-createmainpage' => 'Entra le parola(s) pro "pagina principal" in iste lingua:',
	'wminc-infopage-contribute' => 'Si tu cognosce iste lingua, tu es incoragiate a contribuer!',
	'wminc-infopage-status-imported' => 'Iste wiki incubator ha essite importate ex $1 post le clausura del wiki.',
	'wminc-infopage-status-closedsister' => 'Iste subdominio ha essite claudite. Vade a <b>$2</b> pro contribuer a iste wiki.',
	'wminc-infopage-status-created' => 'Iste projecto ha essite approbate per le comité linguistic e es ora disponibile a $1.',
	'wminc-infopage-status-beforeincubator' => 'Iste projecto ha essite create ante le comenciamento de Wikimedia Incubator e es disponibile a $1.',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Nemo bis
 */
$messages['it'] = array(
	'wminc-infopage-enter' => 'vai alla pagina principale',
	'wminc-unknownlang' => '(lingua ignota, codice "$1")',
	'wminc-infopage-title-p' => 'Wikipedia in $1',
	'wminc-infopage-title-b' => 'Wikibooks in $1',
	'wminc-infopage-title-t' => 'Wiktionary in $1',
	'wminc-infopage-title-q' => 'Wikiquote in $1',
	'wminc-infopage-title-n' => 'Wikinews in $1',
	'wminc-infopage-title-s' => 'Wikisource in $1',
	'wminc-infopage-title-v' => 'Wikiversity in $1',
	'wminc-infopage-welcome' => 'Benvenuto nel Wikimedia Incubator, un progetto della Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|informazioni]])',
	'wminc-infopage-missingwiki-text' => '$1 in questa lingua non esiste ancora.',
	'wminc-infopage-option-startwiki' => 'Se vuoi cominciare questo wiki, puoi [{{fullurl:{{FULLPAGENAME}}|action=edit}} creare la pagina] e seguire [[{{MediaWiki:Wminc-manual-url}}|il manuale]].',
	'wminc-infopage-option-startsister' => 'Se vuoi cominciare questo wiki, puoi andare in <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Puoi fare una ricerca nelle [//www.$1.org versioni linguistiche di $1 esistenti].',
	'wminc-infopage-option-sisterprojects-existing' => 'Puoi cercare nei progetti esistenti in questa lingua:',
	'wminc-infopage-option-sisterprojects-other' => 'Puoi cercare altri progetti in questa lingua:',
	'wminc-infopage-option-multilingual' => 'Puoi andare in un wiki multilingue:',
	'wminc-infopage-createmainpage' => 'Inserisci la traduzione di "Pagina principale" in questa lingua:',
	'wminc-infopage-contribute' => 'Se conosci questa lingua, sei invitato a contribuire!',
	'wminc-infopage-status-imported' => 'Questo wiki di Incubator è stato importato da $1 dopo che il wiki era stato chiuso.',
	'wminc-infopage-status-closedsister' => 'Questo sottodominio è stato chiuso. Vai a <b>$2</b> per partecipare a questo wiki.',
	'wminc-infopage-status-created' => "Questo progetto è stato approvato dal language committee ed è ora disponibile all'indirizzo $1",
	'wminc-infopage-status-beforeincubator' => "Questo progetto è stato creato prima della nascita di Wikimedia Incubator ed è disponibile all'indirizzo $1.",
);

/** Korean (한국어)
 * @author Albamhandae
 */
$messages['ko'] = array(
	'wminc-infopage-contribute' => '이 시험판에 쓰여진 언어를 아신다면, 기여를 부탁드립니다!',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'wminc-infopage-enter' => 'jangk op de Houpsigg',
	'wminc-unknownlang' => '(en onbikannte Schprooch met dämm Köözel „$1“)',
	'wminc-infopage-welcome' => 'Wellkumme em Wikimedia Inkubator, enem Projäk vun der [[{{MediaWiki:Aboutpage}}|Wikimedija Schteftong]]',
	'wminc-infopage-missingwiki-text' => '{{ucfirst:{{GRAMMAR:en|$1}}}} en dä Schprooch jidd et noch nit.
',
	'wminc-infopage-option-multilingual' => 'Do kann noh enem Wiki en etlijje Schprooche jonn:',
	'wminc-infopage-createmainpage' => 'Jif dat Woot för „Houpsigg“ en dä Shprooch en:',
	'wminc-infopage-contribute' => 'Wann De di Shprooch kanns, dann bes De opjeroofe, beizedraare!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'wminc-infopage-enter' => "Gitt op d'Haaptsäit",
	'wminc-unknownlang' => '(onbekannte Sprooch mam Code "$1")',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikibooks $1',
	'wminc-infopage-missingwiki-text' => '$1 gëtt et an dëser Sprooch nach net',
	'wminc-infopage-option-startsister' => 'Wann Dir dës Wiki ufänke wëllt, da gitt w.e.g. op <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Dir kënnt no [//www.$1.org Sproochversiounen, déi et vun $1 gëtt, sichen].',
	'wminc-infopage-option-sisterprojects-existing' => 'Dir kënnt no Projeten an dëser Sprooch sichen (déi et scho gëtt):',
	'wminc-infopage-option-sisterprojects-other' => 'Dir kënnt no anere Projeten an dëser Sprooch sichen:',
	'wminc-infopage-option-multilingual' => 'Dir kënnt op eng méisproocheg Wiki goen:',
	'wminc-infopage-createmainpage' => 'Gitt d\'Wuert "Haaptsäit" fir dës Sprooch an:',
	'wminc-infopage-contribute' => 'Wann Dir dës Sprooch beherrscht, sidd Dir häerzlech wëllkomm fir matzemaachen!',
	'wminc-infopage-status-imported' => "Dës Incubator-Wiki gouf vun $1 importéiert wéi d'Wiki zougemaach gouf.",
	'wminc-infopage-status-closedsister' => 'Dës Subdomain gouf zougemaach. Gitt op <b>$2</b> fir un dëser Wiki matzeschaffen.',
	'wminc-infopage-status-created' => 'Dëse Projet gouf vum Sproochecomité akzeptéiert an ass elo op $1 disponibel.',
	'wminc-infopage-status-beforeincubator' => 'Dëse Projet gouf ugeluecht ier et Wikimedia Incubator gouf an ass op $1 disponibel.',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'wminc-infopage-enter' => "gank achter g'm veurblaaje",
	'wminc-unknownlang' => '(ónbekèndj spraok mid g\'r koeaj "$1")',
	'wminc-infopage-welcome' => "Wèlkóm bie g'm Wikimedia Incubator, e perjèk dèr Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|mieër info]])",
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Matasg
 */
$messages['lt'] = array(
	'wminc-infopage-enter' => 'eiti į Pagrindinį Puslapį',
	'wminc-unknownlang' => '(nežinoma kalba su kodu "$1")',
	'wminc-infopage-title-p' => 'Vikipedija $1',
	'wminc-infopage-title-b' => 'Viki knygos $1',
	'wminc-infopage-title-t' => 'Viki žodynas $1',
	'wminc-infopage-title-q' => 'Viki citatos $1',
	'wminc-infopage-title-n' => 'Viki naujienos $1',
	'wminc-infopage-title-s' => 'Viki šaltiniai $1',
	'wminc-infopage-welcome' => 'Sveiki atvykę i Wikipedia Incubator, Wikipedia fondo projektą ([[{{MediaWiki:Aboutpage}}|Apie]])',
	'wminc-infopage-missingwiki-text' => '$1 šia kalba dar neegzistuoja.',
	'wminc-infopage-option-startsister' => 'Jei norite pradėti šia wiki, galite eiti į <b>[$2 $1] </b>.',
	'wminc-infopage-option-sisterprojects-existing' => 'Jūs galite ieškoti egzistuojančiu projektų, šia kalba:',
	'wminc-infopage-option-sisterprojects-other' => 'Jūs galite ieškoti kitų projektų, šia kalba:',
	'wminc-infopage-contribute' => 'Jei suprantate, ar kalbate šią kalba, esate kviečiama(s) prisidėti!',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'wminc-infopage-title-p' => 'Vikipēdija $1',
	'wminc-infopage-title-b' => 'Wikibooks $1',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wminc-infopage-enter' => 'оди на Главна страница',
	'wminc-unknownlang' => '(непознат јазик со код „$1“)',
	'wminc-infopage-title-p' => 'Википедија $1',
	'wminc-infopage-title-b' => 'Викикниги $1',
	'wminc-infopage-title-t' => 'Викиречник $1',
	'wminc-infopage-title-q' => 'Викицитат $1',
	'wminc-infopage-title-n' => 'Викивести $1',
	'wminc-infopage-title-s' => 'Викиизвор $1',
	'wminc-infopage-title-v' => 'Викиверзитет $1',
	'wminc-infopage-welcome' => 'Добредојдовте на Инкубаторот на Викимедија - проект на Фондацијата Викимедија ([[{{MediaWiki:Aboutpage}}|За проектот]])',
	'wminc-infopage-missingwiki-text' => 'На овој јазик сè уште не постои $1.',
	'wminc-infopage-option-startwiki' => 'Ако сакате да го започнете ова вики,
тогаш можете да ја [{{fullurl:{{FULLPAGENAME}}|action=edit}} создадете страницата] и да го проследите [[{{MediaWiki:Wminc-manual-url}}|нашиот прирачник]].',
	'wminc-infopage-option-startsister' => 'Ако сакате да го започнете ова вики, појдете на <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Можете да ги пребарате [//www.$1.org постоечките јазични изданија на $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Можете да ги пребарате постоечките проекти на овој јазик:',
	'wminc-infopage-option-sisterprojects-other' => 'Можете да пребарате други проекти на овој јазик:',
	'wminc-infopage-option-multilingual' => 'Можете да појдете на повеќејазично вики:',
	'wminc-infopage-createmainpage' => 'Внесете го зборот „Главна страница“ на овој јазик:',
	'wminc-infopage-contribute' => 'Ако имате познавања од овој јазик, ви препорачуваме да учествувате!',
	'wminc-infopage-status-imported' => 'Ова вики на Инкубаторот е увезено од $1, по затворањето на викито.',
	'wminc-infopage-status-closedsister' => 'Овој поддомен е затворен. Појдете на <b>$2</b> за да учествувате на ова вики.',
	'wminc-infopage-status-created' => 'Овој проект е одобрен од јазичната комисија и сега е достапен на $1.',
	'wminc-infopage-status-beforeincubator' => 'Овој проект е создаден пред започнувањето на Инкубаторот на Викимедија и е достапен на $1.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'wminc-infopage-enter' => 'പ്രധാന താളിലേയ്ക്ക് പോവുക',
	'wminc-unknownlang' => '("$1" എന്ന കോഡോടു കൂടിയ അപരിചിതമായ ഭാഷ)',
	'wminc-infopage-title-p' => 'വിക്കിപീഡിയ $1',
	'wminc-infopage-title-b' => 'വിക്കിപാഠശാല $1',
	'wminc-infopage-title-t' => 'വിക്കിനിഘണ്ടു $1',
	'wminc-infopage-title-q' => 'വിക്കിചൊല്ലുകൾ $1',
	'wminc-infopage-title-n' => 'വിക്കിവാർത്തകൾ $1',
	'wminc-infopage-title-s' => 'വിക്കിഗ്രന്ഥശാല $1',
	'wminc-infopage-title-v' => 'വിക്കിസർവ്വകലാശാല $1',
	'wminc-infopage-welcome' => 'വിക്കിമീഡിയ ഫൗണ്ടേഷൻ സംരംഭമായ വിക്കിമീഡിയ ഇൻകുബേറ്ററിലേയ്ക്ക് സ്വാഗതം ([[{{MediaWiki:Aboutpage}}|വിവരണം]])',
	'wminc-infopage-missingwiki-text' => 'ഈ ഭാഷയിൽ $1 നിലവിലില്ല.',
	'wminc-infopage-option-startwiki' => 'താങ്കൾക്ക് ഈ വിക്കി തുടങ്ങണമെന്നുണ്ടെങ്കിൽ [{{fullurl:{{FULLPAGENAME}}|action=edit}} താൾ സൃഷ്ടിച്ച ശേഷം] [[{{MediaWiki:Wminc-manual-url}}|ഞങ്ങളുടെ വഴികാട്ടി]] പിന്തുടരുക.',
	'wminc-infopage-option-startsister' => 'താങ്കൾക്ക് ഈ വിക്കി തുടങ്ങണമെന്നുണ്ടെങ്കിൽ, <b>[$2 $1]</b> എന്ന താളിൽ ചെല്ലുക.',
	'wminc-infopage-option-languages-existing' => '[//www.$1.org $1 പദ്ധതിയുടെ നിലവിലുള്ള ഭാഷാപതിപ്പുകൾ] താങ്കൾക്ക് തിരയാവുന്നതാണ്.',
	'wminc-infopage-option-sisterprojects-existing' => 'ഈ ഭാഷയിൽ നിലവിലുള്ള സംരംഭങ്ങൾ താങ്കൾക്ക് തിരയാവുന്നതാണ്:',
	'wminc-infopage-option-sisterprojects-other' => 'ഈ ഭാഷയിൽ നിലവിലുള്ള ഇതര സംരംഭങ്ങൾ താങ്കൾക്ക് തിരയാവുന്നതാണ്:',
	'wminc-infopage-option-multilingual' => 'താങ്കൾക്ക് ബഹുഭാഷാവിക്കിയിലേയ്ക്ക് പോകാവുന്നതാണ്:',
	'wminc-infopage-createmainpage' => 'ഈ ഭാഷയിൽ "പ്രധാന താൾ" എന്നതിനു സമാനമായ പദം നൽകുക:',
	'wminc-infopage-contribute' => 'താങ്കൾക്ക് ഈ ഭാഷ അറിയാമെങ്കിൽ, അതിൽ സംഭാവന ചെയ്യാൻ താത്പര്യപ്പെടുന്നു!',
	'wminc-infopage-status-imported' => 'ഈ ഇൻകുബേറ്റർ വിക്കി $1 എന്നതിൽ നിന്നും വിക്കി അടച്ചശേഷം ഇറക്കുമതി ചെയ്തതാണ്.',
	'wminc-infopage-status-closedsister' => 'ഈ ഉപഡൊമൈൻ അടച്ചിരിക്കുന്നു. ഈ വിക്കിയിൽ സംഭാവന ചെയ്യാൻ <b>$2</b> എന്നതിലേയ്ക്ക് പോവുക.',
	'wminc-infopage-status-created' => 'ഈ സംരംഭം ഭാഷാ കമ്മിറ്റി അംഗീകരിച്ചിരിക്കുന്നു, അതിപ്പോൾ $1 എന്നു ലഭ്യമാണ്.',
	'wminc-infopage-status-beforeincubator' => 'ഈ പദ്ധതി, വിക്കിമീഡിയ ഇൻകുബേറ്റർ തുടങ്ങുന്നതിനു മുമ്പേയുള്ളതാണ്, അത് $1-ൽ ലഭ്യമാണ്.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wminc-infopage-enter' => 'pergi ke Laman Utama',
	'wminc-unknownlang' => '(bahasa yang tidak diketahui dengan kod "$1")',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikibuku $1',
	'wminc-infopage-title-t' => 'Wikikamus $1',
	'wminc-infopage-title-q' => 'Wikiquote $1',
	'wminc-infopage-title-n' => 'Wikiberita $1',
	'wminc-infopage-title-s' => 'Wikisumber $1',
	'wminc-infopage-title-v' => 'Wikiversiti $1',
	'wminc-infopage-welcome' => 'Selamat datang ke Wikimedia Incubator, satu projek Yayasan Wikimedia ([[{{MediaWiki:Aboutpage}}|Perihal]])',
	'wminc-infopage-missingwiki-text' => '$1 dalam bahasa ini belum wujud.',
	'wminc-infopage-option-startwiki' => 'Jika anda mahu memulakan wiki ini,
anda boleh [{{fullurl:{{FULLPAGENAME}}|action=edit}} mencipta lamannya] dan mengikuti [[{{MediaWiki:Wminc-manual-url}}|panduan kami]].',
	'wminc-infopage-option-startsister' => 'Jika anda ingin membuka wiki ini, anda boleh pergi ke <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Anda boleh mencari [//www.$1.org edisi-edisi bahasa sedia ada bagi $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Anda boleh mencari projek-projek yang sedia ada dalam bahasa ini:',
	'wminc-infopage-option-sisterprojects-other' => 'Anda boleh mencari projek-projek lain dalam bahasa ini:',
	'wminc-infopage-option-multilingual' => 'Anda boleh pergi ke wiki berbilang bahasa:',
	'wminc-infopage-createmainpage' => 'Isikan perkataan "Laman Utama" dalam bahasa ini:',
	'wminc-infopage-contribute' => 'Jika anda fasih dalam bahasa ini, anda dialu-alukan untuk menyumbang!',
	'wminc-infopage-status-imported' => 'Wiki Incubator ini telah diimport dari $1 setelah wiki itu ditutup.',
	'wminc-infopage-status-closedsister' => 'Subdomain ini ditutup. Pergi ke <b>$2</b> untuk menyumbang kepada wiki ini.',
	'wminc-infopage-status-created' => 'Projek ini telah diluluskan oleh jawatankuasa bahasa dan kini boleh didapati di $1.',
	'wminc-infopage-status-beforeincubator' => 'Projek ini dibuka sebelum Wikimedia Incubator dimulakan, dan boleh didapati di $1.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'wminc-infopage-enter' => 'ga naar de Hoofdpagina',
	'wminc-unknownlang' => '(onbekende taal met code "$1")',
	'wminc-infopage-title-p' => 'Wikipedia in het $1',
	'wminc-infopage-title-b' => 'Wikibooks in het $1',
	'wminc-infopage-title-t' => 'Wikiwoordenboek in het $1',
	'wminc-infopage-title-q' => 'Wikiquote in het $1',
	'wminc-infopage-title-n' => 'Wikinews in het $1',
	'wminc-infopage-title-s' => 'Wikisource in het $1',
	'wminc-infopage-title-v' => 'Wikiversity in het $1',
	'wminc-infopage-welcome' => 'Welkom bij de Wikimedia Incubator, een project van de Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|Meer info]])',
	'wminc-infopage-missingwiki-text' => 'Een $1 in deze taal bestaat nog niet.',
	'wminc-infopage-option-startwiki' => 'Als u deze wiki wilt starten, kunt u [{{fullurl:{{FULLPAGENAME}}|action=edit}} de pagina aanmaken] en [[{{MediaWiki:Wminc-manual-url}}|onze handleiding]] volgen.',
	'wminc-infopage-option-startsister' => 'Als u deze wiki wilt starten, kunt u naar <b>[$2 $1]</b> gaan.',
	'wminc-infopage-option-languages-existing' => 'U kunt naar [//www.$1.org bestaande taalversies van $1] zoeken.',
	'wminc-infopage-option-sisterprojects-existing' => 'U kunt naar bestaande projecten in deze taal zoeken:',
	'wminc-infopage-option-sisterprojects-other' => 'U kunt naar andere projecten in deze taal zoeken:',
	'wminc-infopage-option-multilingual' => 'U kunt naar een meertalige wiki gaan:',
	'wminc-infopage-createmainpage' => 'Geef het woord "Hoofdpagina" op in deze taal:',
	'wminc-infopage-contribute' => 'Als u deze taal kent, wordt u aangemoedigd om bij te dragen!',
	'wminc-infopage-status-imported' => 'Deze Incubator-wiki werd geïmporteerd van $1 nadat die wiki is gesloten.',
	'wminc-infopage-status-closedsister' => 'Dit subdomein is gesloten. Ga naar <b>$2</b> om bij te dragen aan deze wiki.',
	'wminc-infopage-status-created' => 'Dit project werd goedgekeurd door het taalcomité en is nu beschikbaar op $1.',
	'wminc-infopage-status-beforeincubator' => 'Dit project is gemaakt voordat Wikimedia Incubator begon en is beschikbaar op $1.',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'wminc-infopage-enter' => 'ପ୍ରଧାନ ପୃଷ୍ଠାକୁ ଯିବେ',
	'wminc-infopage-title-p' => 'ଉଇକିପିଡ଼ିଆ $1',
);

/** Polish (Polski)
 * @author Bartek50003
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'wminc-infopage-enter' => 'przejdź do strony głównej',
	'wminc-unknownlang' => '(nieznany język o kodzie „$1“)',
	'wminc-infopage-welcome' => 'Witaj w Inkubatorze Wikimedia, projekcie Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|o inkubatorze]])',
	'wminc-infopage-createmainpage' => 'Wpisz „Strona główna“ w tym języku',
	'wminc-infopage-contribute' => 'Jeśli znasz ten język zachęcamy Cię do wzięcia udziału w tworzeniu tej wiki!',
	'wminc-infopage-status-imported' => 'Do inkubatora wiki zaimportowano treść z $1 po tym jak wiki została zamknięta.',
	'wminc-infopage-status-closedsister' => 'Ta domena podrzędna została zamknięta. Przejdź pod adres <b>$2</b> jeśli chcesz współtworzyć tę wiki.',
	'wminc-infopage-status-created' => 'Projekt został zatwierdzony przez komisję językową i jest już dostępny pod adresem $1.',
	'wminc-infopage-status-beforeincubator' => 'Ten projekt został utworzony zanim został uruchomiony Inkubator Wikimedia i jest dostępny pod adresem $1.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'wminc-infopage-enter' => 'andé a la pàgina Prinsipal',
	'wminc-unknownlang' => '(lenga pa conossùa con còdes "$1")',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikibooks $1',
	'wminc-infopage-title-t' => 'Wiktionary $1',
	'wminc-infopage-title-q' => 'Wikiquote $1',
	'wminc-infopage-title-n' => 'Wikinews $1',
	'wminc-infopage-title-s' => 'Wikisource $1',
	'wminc-infopage-title-v' => 'Wikiversity $1',
	'wminc-infopage-welcome' => "Bin ëvnù a l'Incubator ëd Wikimedia, un proget ëd la Fondassion Wikimedia ([[{{MediaWiki:Aboutpage}}|A propòsit]])",
	'wminc-infopage-missingwiki-text' => 'Un $1 an costa lenga a esist ancor nen.',
	'wminc-infopage-option-startwiki' => "S'a veule ancaminé costa wiki,
a peul [{{fullurl:{{FULLPAGENAME}}|action=edit}} creé la pàgina] e andeje dapress a [[{{MediaWiki:Wminc-manual-url}}|nòstr manual]].",
	'wminc-infopage-option-startsister' => "S'it veule ancaminé sta wiki, it peule andé a <b>[$2 $1]</b>.",
	'wminc-infopage-option-languages-existing' => "It peule serché [//www.$1.org j'edission esistente an lenga ëd $1].",
	'wminc-infopage-option-sisterprojects-existing' => 'A peul sërché dij proget esistent an costa lenga:',
	'wminc-infopage-option-sisterprojects-other' => "A peul sërché d'àutri proget an costa lenga:",
	'wminc-infopage-option-multilingual' => 'It peule andé a na wiki multilenga:',
	'wminc-infopage-createmainpage' => "Ch'a anserissa le paròle «Pàgina Prinsipal» an costa lenga:",
	'wminc-infopage-contribute' => "S'a conòss costa lenga, a l'é ancoragià a contribuì!",
	'wminc-infopage-status-imported' => "Costa wiki Incubator a l'é stàita amportà da $1 apress che la wiki a l'é stàita sarà.",
	'wminc-infopage-status-closedsister' => "Ës sot-domini a l'é stàit sarà. Ch'a vada a <b>$2</b> për contribuì a costa wiki.",
	'wminc-infopage-status-created' => "Ës proget a l'é stàit aprovà dal comità lenghìstich e a l'é adess disponìbil a $1.",
	'wminc-infopage-status-beforeincubator' => "Ës proget a l'é stàit creà prima che l'Incubator ëd Wikipedia a partèissa e a l'é disponìbil a $1.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wminc-infopage-enter' => 'آرنی مخ ته ورتلل',
	'wminc-infopage-title-p' => '$1 ويکيپېډيا',
	'wminc-infopage-title-b' => '$1 ويکيتابونه',
	'wminc-infopage-title-t' => '$1 ويکيسيند',
	'wminc-infopage-title-n' => '$1 ويکيخبرونه',
	'wminc-infopage-title-v' => '$1 ويکيپوهنتون',
	'wminc-infopage-option-multilingual' => 'تاسې يوې څوژبنيزې ويکي ته ورتللی شی:',
);

/** Portuguese (Português)
 * @author Carla404
 * @author Hamilton Abreu
 * @author SandroHc
 */
$messages['pt'] = array(
	'wminc-infopage-enter' => 'ir para a Página principal',
	'wminc-unknownlang' => '(língua desconhecida, com o código "$1")',
	'wminc-infopage-welcome' => 'Bem-vindo(a) Incubadora Wikimedia, um projecto da Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|Sobre]])',
	'wminc-infopage-missingwiki-text' => 'Ainda não existe um projecto $1 nesta língua.',
	'wminc-infopage-option-startwiki' => 'Se pretende iniciar esta wiki,
pode [{{fullurl:{{FULLPAGENAME}}|action=edit}} criar a página] e seguir o [[{{MediaWiki:Wminc-manual-url}}|manual]].',
	'wminc-infopage-option-startsister' => 'Se queres começar esta wiki, podes ir a <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Pode pesquisar as [//www.$1.org edições de $1 nas línguas existentes].',
	'wminc-infopage-option-sisterprojects-existing' => 'Pode pesquisar os projectos existentes nesta língua:',
	'wminc-infopage-option-sisterprojects-other' => 'Pode pesquisar outros projectos nesta língua:',
	'wminc-infopage-option-multilingual' => 'Pode visitar uma wiki multilingue:',
	'wminc-infopage-createmainpage' => 'Introduza o termo "Página principal" nesta língua:',
	'wminc-infopage-contribute' => 'Se conhece esta língua, está convidado a colaborar!',
	'wminc-infopage-status-imported' => 'Esta wiki da Incubadora foi importada de $1 após a wiki ter sido fechada.',
	'wminc-infopage-status-closedsister' => 'Este subdomínio foi fechado. Vá a <b>$2</b> para contribuír nesta wiki.',
	'wminc-infopage-status-created' => 'Este projecto foi aprovado pelo comité linguístico e está agora disponível em $1.',
	'wminc-infopage-status-beforeincubator' => 'Este projecto foi criado antes do início da Incubadora Wikimedia e está disponível em $1.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author MetalBrasil
 * @author Pedroca cerebral
 */
$messages['pt-br'] = array(
	'wminc-infopage-enter' => 'Vá para a página principal',
	'wminc-unknownlang' => '(língua desconhecida com código "$1")',
	'wminc-infopage-welcome' => 'Bem vindo à Wikimedia Incubator, um projeto da Wikimedia Fundation ([[{{MediaWiki:Aboutpage}}|Sobre]])',
	'wminc-infopage-missingwiki-text' => 'Ainda não existe um projeto $1 nesta língua.',
	'wminc-infopage-option-startwiki' => 'Se você quiser começar esta wiki, você pode [{{fullurl:{{FULLPAGENAME}}|action=edit}} criar a página] e seguir [[{{MediaWiki:Wminc-manual-url}}|nosso manual]].',
	'wminc-infopage-option-startsister' => 'Se você quer começar esta wiki, você pode ir a <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Você pode pesquisar por [//www.$1.org edições de $1 línguas existentes].',
	'wminc-infopage-option-sisterprojects-existing' => 'Você pode pesquisar por projetos existentes nesta língua.',
	'wminc-infopage-option-sisterprojects-other' => 'Você pode pesquisar por outros projetos nessa língua.',
	'wminc-infopage-option-multilingual' => 'Você pode ir a uma wiki multilíngue.',
	'wminc-infopage-createmainpage' => 'Digite a palavra "Página principal" nesta língua.',
	'wminc-infopage-contribute' => 'Se você conhece esta língua, você é convidado a contribuir!',
	'wminc-infopage-status-imported' => 'Essa Incubator wiki foi importada de $1 depois que a wiki foi fechada.',
	'wminc-infopage-status-closedsister' => 'Este subdomínio foi fechado. Vá a <b>$2</b> para contribuir nesta wiki.',
	'wminc-infopage-status-created' => 'Esse projeto foi aprovado pela comitê linguístico e agora é avaliável em $1.',
	'wminc-infopage-status-beforeincubator' => 'Esse projeto foi criado antes do inicio da Wikimedia Incubator e está avaliável em $1.',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author Minisarm
 */
$messages['ro'] = array(
	'wminc-infopage-enter' => 'mergi la Pagina principală',
	'wminc-unknownlang' => '(limbă necunoscută asociată codului „$1”)',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikimanuale $1',
	'wminc-infopage-title-t' => 'Wikționar $1',
	'wminc-infopage-title-q' => 'Wikicitat $1',
	'wminc-infopage-title-n' => 'Wikiștiri $1',
	'wminc-infopage-title-s' => 'Wikisursă $1',
	'wminc-infopage-title-v' => 'Wikiversitate $1',
	'wminc-infopage-missingwiki-text' => '$1 în această limbă nu există.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'wminc-infopage-enter' => "scè ad 'a Pagene Prengepále",
	'wminc-unknownlang' => '(lènga scanosciute c\'u codece "$1")',
	'wminc-infopage-title-p' => 'Uicchipèdie $1',
	'wminc-infopage-title-b' => 'Uicchibooks $1',
	'wminc-infopage-title-t' => 'Uicchitionary $1',
	'wminc-infopage-title-q' => 'Uicchiquote $1',
	'wminc-infopage-title-n' => 'Uicchinews $1',
	'wminc-infopage-title-s' => 'Uicchisource $1',
	'wminc-infopage-title-v' => 'Uicchiversity $1',
	'wminc-infopage-welcome' => "Bovègne sus a Uicchimèdie Incubatore, 'nu pruggette d'a Funnazione Uicchimèdie ([[{{MediaWiki:Aboutpage}}|About]])",
	'wminc-infopage-missingwiki-text' => "'Nu $1 jndre 'stà lènga non ge 'stè angore.",
	'wminc-infopage-option-startwiki' => "Ce vuè ccrejà 'stà uicchi,
puè [{{fullurl:{{FULLPAGENAME}}|action=edit}} ccrejà 'a pagene] e seguì [[{{MediaWiki:Wminc-manual-url}}|'u manuale nuèstre]].",
	'wminc-infopage-option-startsister' => "Ce vuè ccrejà 'stà uicchi, puè scè a <b>[$2 $1]</b>.",
	'wminc-infopage-option-languages-existing' => "Tu puè acchijà pe' le [//www.$1.org versione lènguisteche esistende de $1].",
	'wminc-infopage-option-sisterprojects-existing' => "Tu puè acchijà pe' le pruggette esistende jndre 'stà lènga:",
	'wminc-infopage-option-sisterprojects-other' => "Tu puè acchijà pe' l'otre pruggette jndre 'stà lènga:",
	'wminc-infopage-option-multilingual' => "Puè scè jndre 'na uicchi multelènghe:",
	'wminc-infopage-createmainpage' => 'Sckaffe \'a parole "Pagene Prengepále" jndre \'stà lènga:',
	'wminc-infopage-contribute' => "Ce tu canosce 'stà lènga, sìnde 'ngoraggiate a condrebbuì!",
	'wminc-infopage-status-imported' => "Quèste uicchi de l'Incubatore ha state 'mbortade da $1 nnande c'a uicchi ha state chiuse.",
	'wminc-infopage-status-closedsister' => "'Stù subdominie jè state chiuse. Scè a <b>$2</b> pe' conrebbuì a 'stà uicchi.",
	'wminc-infopage-status-created' => "'Stù pruggette ha state approvate da 'u language committee e mò se pòte acchijà sus a $1.",
	'wminc-infopage-status-beforeincubator' => "'Stù pruggette jè state ccrejète apprìme ca Uicchimèdie Incubatore accumenzasse a fatijà e jè disponibbele sus a $1.",
);

/** Russian (Русский)
 * @author Amdf
 * @author Eugrus
 * @author Kaganer
 */
$messages['ru'] = array(
	'wminc-infopage-enter' => 'перейти на заглавную страницу',
	'wminc-unknownlang' => '(неизвестный язык с кодом «$1»)',
	'wminc-infopage-title-p' => 'Википедия $1',
	'wminc-infopage-title-b' => 'Викиучебник $1',
	'wminc-infopage-title-t' => 'Викисловарь $1',
	'wminc-infopage-title-q' => 'Викицитатник $1',
	'wminc-infopage-title-n' => 'Викиновости $1',
	'wminc-infopage-title-s' => 'Викитека $1',
	'wminc-infopage-title-v' => 'Викиверситет $1',
	'wminc-infopage-welcome' => 'Добро пожаловать в Инкубатор Викимедиа, проект Фонда Викимедиа ([[{{MediaWiki:Aboutpage}}|о проекте]])',
	'wminc-infopage-missingwiki-text' => 'У $1 еще ​​нет раздела на этом языке.',
	'wminc-infopage-option-startwiki' => 'Если вы хотите начать этот вики-проект,
вы можете [{{fullurl:{{FULLPAGENAME}}|action=edit}} создать страницу] и следовать [[{{MediaWiki:Wminc-manual-url}}|нашему руководству]].',
	'wminc-infopage-option-startsister' => 'Если вы хотите начать этот вики-проект, вы можете перейти к <b>[ $2  $1 ] </b>.',
	'wminc-infopage-option-languages-existing' => 'Вы можете поискать [//www.$1.org существующие языковые разделы для $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Вы можете поискать существующие проекты на этом языке:',
	'wminc-infopage-option-sisterprojects-other' => 'Вы можете поискать другие проекты на этом языке:',
	'wminc-infopage-option-multilingual' => 'Вы можете перейти к многоязычным вики-проектам:',
	'wminc-infopage-createmainpage' => 'Введите на этом языке выражение, означающее «Заглавная страница»:',
	'wminc-infopage-contribute' => 'Если вы понимаете этот язык, вы можете внести свой вклад!',
	'wminc-infopage-status-imported' => 'Эта вики была импортирована в Инкубатор из $1 после того, как была закрыта.',
	'wminc-infopage-status-closedsister' => 'Этот поддомен был закрыт. Перейти к <b>$2</b>, чтобы сделать свой вклад в эту вики.',
	'wminc-infopage-status-created' => 'Этот проект был одобрен языковым комитетом и теперь доступен по адресу $1 .',
	'wminc-infopage-status-beforeincubator' => 'Этот проект, созданный до запуска Инкубатора Викимедиа, доступен по адресу $1 .',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'wminc-infopage-contribute' => 'Кідь розумієте тот язык, рекомендуєме, жебы сьте приспівали!',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'wminc-infopage-title-p' => 'विकिपीड़िया $1',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'wminc-infopage-enter' => 'මුල් පිටුව වෙත යන්න',
	'wminc-unknownlang' => '("$1" කේතය සමඟ හදුනා නොගත් භාෂාව)',
	'wminc-infopage-title-p' => 'විකිපීඩියා $1',
	'wminc-infopage-title-b' => 'විකිපොත් $1',
	'wminc-infopage-title-t' => 'විකිෂනරි $1',
	'wminc-infopage-title-q' => 'විකීඋදෘත $1',
	'wminc-infopage-title-n' => 'විකිපුවත් $1',
	'wminc-infopage-title-s' => 'විකිමුලාශ්‍ර $1',
	'wminc-infopage-title-v' => 'විකිවර්සිටි $1',
	'wminc-infopage-welcome' => 'විකිමාධ්‍ය ඉන්කිව්බේටර වෙත පිළිගනිමු, විකිමාධ්‍ය පදනමෙහි ව්‍යාපෘතියකි ([[{{MediaWiki:Aboutpage}}|පිලිබඳ]])',
	'wminc-infopage-missingwiki-text' => 'මෙම භාෂාවෙහි තිබෙන $1 තවම නොපවතියි.',
	'wminc-infopage-option-startwiki' => 'ඔබට මෙම විකිය ආරම්භ කිරීමට අවශ්‍යනම්,
[{{fullurl:{{FULLPAGENAME}}|action=edit}} පිටුව තනා] [[{{MediaWiki:Wminc-manual-url}}|අපගේ අත්පොත]]  අනුගමනය කල හැක.',
	'wminc-infopage-option-startsister' => 'ඔබට මෙම විකිය ඇරඹීමට අවශ්‍ය නම්, ඔබට <b>[$2 $1]</b>වෙත යා හැකියි.',
	'wminc-infopage-option-languages-existing' => 'ඔබ හට [//www.$1.org $1 හී දැනටමත් පවත්නා භාෂා අනුවාදයන්] සඳහා ගවේෂණය කල හැක.',
	'wminc-infopage-option-sisterprojects-existing' => 'මෙම භාෂාවෙහි දැනටමත් පවතින ව්‍යාපෘතියන් ඔබට ගවේශනය කල හැක:',
	'wminc-infopage-option-sisterprojects-other' => 'මෙම භාෂාවෙහි වෙනත් ව්‍යාපෘතියන් ඔබට ගවේශනය කල හැක:',
	'wminc-infopage-option-multilingual' => 'ඔබට බහුභාෂාමය විකියකට යා හැකියි:',
	'wminc-infopage-createmainpage' => "මෙම භාෂාවෙහිදී ''මුල් පිටුව'' යන වචනය යොදන්න:",
	'wminc-infopage-contribute' => 'ඔබ මෙම භාෂාව ගැන දන්නවානම්, දායකත්වය ලබා දීමට ඔබට අපි අනුබල දෙනවා!',
	'wminc-infopage-status-imported' => 'විකිය වැසීමෙන් පසුව මෙම ඉන්කිව්බේටර විකිය $1 වෙතින් ආයාත කර ඇත.',
	'wminc-infopage-status-closedsister' => 'මෙම උපවසම වසා ඇත. මෙම විකියට දායකවීමට <b>$2</b> වෙත යන්න.',
	'wminc-infopage-status-created' => 'භාෂා කමිටුව විසින් මෙම ව්‍යාපෘතිය අනුමත කල අතර $1 හීදී ලබාගත හැක.',
	'wminc-infopage-status-beforeincubator' => 'මෙම ව්‍යාපෘතිය තැනී ඇත්තේ විකිමාධ්‍ය ඉන්කිව්බේටරය ආරම්භ කිරීමට පෙර වන අතර $1 හීදී ලබා ගත හැක.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'wminc-infopage-enter' => 'pojdi na glavno stran',
	'wminc-unknownlang' => '(neznan jezik s kodo »$1«)',
	'wminc-infopage-title-p' => 'Wikipedija $1',
	'wminc-infopage-title-b' => 'Wikiknjige $1',
	'wminc-infopage-title-t' => 'Wikislovar $1',
	'wminc-infopage-title-q' => 'Wikinavedek $1',
	'wminc-infopage-title-n' => 'Wikinovice $1',
	'wminc-infopage-title-s' => 'Wikivir $1',
	'wminc-infopage-title-v' => 'Wikiverza $1',
	'wminc-infopage-welcome' => 'Dobrodošli na Wikimediinem Inkubatorju, projektu Fundacije Wikimedia ([[{{MediaWiki:Aboutpage}}|O projektu]])',
	'wminc-infopage-missingwiki-text' => '$1 v tem jeziku še ne obstaja.',
	'wminc-infopage-option-startwiki' => 'Če želite zagnati ta wiki,
lahko [{{fullurl:{{FULLPAGENAME}}|action=edit}} ustvarite stran] in sledite [[{{MediaWiki:Wminc-manual-url}}|našemu priročniku]].',
	'wminc-infopage-option-startsister' => 'Če želite zagnati ta wiki, pojdite na <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Iščete lahko [//www.$1.org obstoječe jezikovne izdaje $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Iščete lahko obstoječe projekte v tem jeziku:',
	'wminc-infopage-option-sisterprojects-other' => 'Iščete lahko druge projekte v tem jeziku:',
	'wminc-infopage-option-multilingual' => 'Greste lahko na večjezikovni wiki:',
	'wminc-infopage-createmainpage' => 'Vnesite besedi »Glavna stran« v tem jeziku:',
	'wminc-infopage-contribute' => 'Če znate ta jezik, ste vabljeni k prispevanju!',
	'wminc-infopage-status-imported' => 'Ta wiki Inkubatorja je bil uvožen iz $1 po zaprtju wikija.',
	'wminc-infopage-status-closedsister' => 'Poddomena je zaprta. Pojdite na <b>$2</b>, da prispevate k temu wikiju.',
	'wminc-infopage-status-created' => 'Projekt je odobril  jezikovni odbor in je sedaj na voljo na $1.',
	'wminc-infopage-status-beforeincubator' => 'Projekt je nastal pred zagonom Wikimediinega Inkubatorja in je na voljo na $1.',
);

/** Albanian (Shqip)
 * @author Olsi
 */
$messages['sq'] = array(
	'wminc-infopage-contribute' => 'Nëse e dini këtë gjuhë, jeni të inkurajuar të kontribuoni!',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'wminc-infopage-enter' => 'иди на Главну страну',
	'wminc-unknownlang' => '(непознат језик с кодом „$1“)',
	'wminc-infopage-welcome' => 'Добро дошли на Викимедијин Инкубатор — пројекат Задужбине Викимедија ([[{{MediaWiki:Aboutpage}}|О пројекту]])',
	'wminc-infopage-missingwiki-text' => 'На овом језику још не постоји $1.',
	'wminc-infopage-option-startwiki' => 'Ако желите да започнете овај вики,
онда можете да [{{fullurl:{{FULLPAGENAME}}|action=edit}} направите страницу] и да погледате [[{{MediaWiki:Wminc-manual-url}}|наш приручник]].',
	'wminc-infopage-option-startsister' => 'Ако желите да започнете овај вики, идите на <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Можете да претражите [//www.$1.org постојећа језичка издања пројекта $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Можете да претражите постојеће пројекте на овом језику:',
	'wminc-infopage-option-sisterprojects-other' => 'Можете да претражите друге пројекте на овом језику:',
	'wminc-infopage-option-multilingual' => 'Можете да одете на вишејезички вики:',
	'wminc-infopage-createmainpage' => 'Унесите реч „Главна страна“ на овом језику:',
	'wminc-infopage-contribute' => 'Ако познајете овај језик, препоручујемо вам да учествујете!',
	'wminc-infopage-status-imported' => 'Овај вики Инкубатор је увезен из $1, по затварању викија.',
	'wminc-infopage-status-closedsister' => 'Овај поддомен је затворен. Идите на <b>$2</b> да учествујете на овом викију.',
	'wminc-infopage-status-created' => 'Овај пројекат је одобрен од језичког одбора и сада је доступан на $1.',
	'wminc-infopage-status-beforeincubator' => 'Овај пројекат је направљен пре почетка рада Викимедијиног Инкубатора и доступан је на $1.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'wminc-infopage-enter' => 'idi na Glavnu stranu',
	'wminc-unknownlang' => '(nepoznat jezik s kodom „$1“)',
	'wminc-infopage-welcome' => 'Dobro došli na Vikimedijin Inkubator — projekat Zadužbine Vikimedija ([[{{MediaWiki:Aboutpage}}|O projektu]])',
	'wminc-infopage-missingwiki-text' => 'Na ovom jeziku još ne postoji $1.',
	'wminc-infopage-option-startwiki' => 'Ako želite da započnete ovaj viki,
onda možete da [{{fullurl:{{FULLPAGENAME}}|action=edit}} napravite stranicu] i da pogledate [[{{MediaWiki:Wminc-manual-url}}|naš priručnik]].',
	'wminc-infopage-option-startsister' => 'Ako želite da započnete ovaj viki, idite na <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Možete da pretražite [//www.$1.org postojeća jezička izdanja projekta $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Možete da pretražite postojeće projekte na ovom jeziku:',
	'wminc-infopage-option-sisterprojects-other' => 'Možete da pretražite druge projekte na ovom jeziku:',
	'wminc-infopage-option-multilingual' => 'Možete da odete na višejezički viki:',
	'wminc-infopage-createmainpage' => 'Unesite reč „Glavna strana“ na ovom jeziku:',
	'wminc-infopage-contribute' => 'Ako poznajete ovaj jezik, preporučujemo vam da učestvujete!',
	'wminc-infopage-status-imported' => 'Ovaj viki Inkubator je uvezen iz $1, po zatvaranju vikija.',
	'wminc-infopage-status-closedsister' => 'Ovaj poddomen je zatvoren. Idite na <b>$2</b> da učestvujete na ovom vikiju.',
	'wminc-infopage-status-created' => 'Ovaj projekat je odobren od jezičkog odbora i sada je dostupan na $1.',
	'wminc-infopage-status-beforeincubator' => 'Ovaj projekat je napravljen pre početka rada Vikimedijinog Inkubatora i dostupan je na $1.',
);

/** Swedish (Svenska)
 * @author Lokal Profil
 * @author Warrakkk
 */
$messages['sv'] = array(
	'wminc-infopage-enter' => 'gå till huvudsidan',
	'wminc-unknownlang' => '(okänt språk med koden "$1")',
	'wminc-infopage-welcome' => 'Välkommen till Wikimedia Incubator, ett projekt av Wikimedia Foundation ([[{{MediaWiki:Aboutpage}}|Om]])',
	'wminc-infopage-missingwiki-text' => 'En $1 på detta språk existerar inte ännu.',
	'wminc-infopage-option-startwiki' => 'Om du vill starta denna wiki kan du [{{fullurl:{{FULLPAGENAME}}|action=edit}} skapa sidan] och följa [[{{MediaWiki:Wminc-manual-url}}|vår manual]].',
	'wminc-infopage-option-startsister' => 'Om du vill starta denna wiki, kan du gå till <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Du kan söka efter [//www.$1.org befintliga språkversioner av $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Du kan söka efter befintliga projekt på detta språk:',
	'wminc-infopage-option-sisterprojects-other' => 'Du kan söka efter andra projekt på detta språk:',
	'wminc-infopage-option-multilingual' => 'Du kan gå till en flerspråkig wiki:',
	'wminc-infopage-createmainpage' => 'Ange ordet "Huvudsida" i detta språk:',
	'wminc-infopage-contribute' => 'Om du kan detta språk, uppmuntras du att bidra!',
	'wminc-infopage-status-imported' => 'Denna Incubator-wiki har importerats från $1 efter det att wikin stängdes.',
	'wminc-infopage-status-closedsister' => 'Denna underdomän har stängts. Gå till <b>$2</b> för att bidra till denna wiki.',
	'wminc-infopage-status-created' => 'Detta projekt har godkänts av språkkommittén och finns nu på $1.',
	'wminc-infopage-status-beforeincubator' => 'Detta projekt skapades före Wikimedia Incubator startade och finns på $1.',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 */
$messages['ta'] = array(
	'wminc-infopage-title-p' => 'விக்கிப்பீடியா $1',
	'wminc-infopage-title-b' => 'விக்கிபுத்தகங்கள் $1',
	'wminc-infopage-title-t' => 'விக்சனரி$1',
	'wminc-infopage-title-q' => 'விக்கிமேற்கோள்$1',
	'wminc-infopage-title-n' => 'விக்கிசெய்திகள் $1',
	'wminc-infopage-title-s' => 'விக்கிமூலம் $1',
	'wminc-infopage-missingwiki-text' => 'A  $1  இந்த மொழியில் இதுவரை இல்லை.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'wminc-infopage-enter' => 'bá Pájina Mahuluk',
);

/** Turkish (Türkçe)
 * @author Emperyan
 */
$messages['tr'] = array(
	'wminc-infopage-enter' => 'Ana sayfaya git',
	'wminc-unknownlang' => '("$1" bilinmeyen bir dil kodu)',
	'wminc-infopage-title-p' => 'Vikipedi $1',
	'wminc-infopage-title-b' => 'Vikikitap $1',
	'wminc-infopage-title-t' => 'Vikisözlük $1',
	'wminc-infopage-title-q' => 'Vikisöz $1',
	'wminc-infopage-title-n' => 'Vikihaber $1',
	'wminc-infopage-title-s' => 'Vikikaynak $1',
	'wminc-infopage-title-v' => 'Vikiversite $1',
	'wminc-infopage-welcome' => "Bir Wikimedia Vakfı projesi olan Wikimedia Incubator'e hoş geldiniz. ([[{{MediaWiki:Aboutpage}}|Hakkında]])",
	'wminc-infopage-missingwiki-text' => '$1, bu dilde henüz mevcut değil.',
	'wminc-infopage-option-startsister' => 'Bu vikiyi başlatmak istiyorsanız, <b>[$2 $1]</b> gidebilirsiniz.',
	'wminc-infopage-option-languages-existing' => '[//www.$1.org Mevcut dil sürümü $1] için arama yapabilirsiniz.',
	'wminc-infopage-option-sisterprojects-existing' => 'Bu dilde diğer projeler için arama yapabilirsiniz:',
	'wminc-infopage-option-sisterprojects-other' => 'Bu dilde diğer projeler için arama yapabilirsiniz:',
	'wminc-infopage-createmainpage' => 'Bu dilde "Ana Sayfa" sözcüğünü girin:',
	'wminc-infopage-contribute' => 'Eğer bu dili biliyorsanız, sizi katkıda bulunmaya davet ediyoruz!',
	'wminc-infopage-status-closedsister' => "Bu alt etki alanı kapatılmıştır. Bu vikiye katkıda bulunmak için <b>$2</b>'ye/ya gidin.",
);

/** Ukrainian (Українська)
 * @author Andrijko Z.
 * @author Dim Grits
 */
$messages['uk'] = array(
	'wminc-infopage-enter' => 'до Головної сторінки',
	'wminc-unknownlang' => '(Невідома мова з кодом "$1")',
	'wminc-infopage-welcome' => 'Ласкаво просимо до Інкубатора Вікімедіа. [[{{MediaWiki:Aboutpage}}|Інформація]] про цей проект Фонду Вікімедіа',
	'wminc-infopage-missingwiki-text' => '$1 ще не має розділу даною мовою.',
	'wminc-infopage-option-startwiki' => 'Якщо ви бажаєте започаткувати цей вікіпроект,
можете [{{fullurl:{{FULLPAGENAME}}|action=edit}} створити сторінку] та дотримуватись порад [[{{MediaWiki:Wminc-manual-url}}|нашої інструкції]].',
	'wminc-infopage-option-startsister' => 'Якщо ви хочете започаткувати цей вікіпроект, ви можете звернутися до <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Ви можете пошукати серед [//www.$1.org існуючих мовних розділів $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Ви можете пошукати існуючі проекти цією мовою:',
	'wminc-infopage-option-sisterprojects-other' => 'Ви можете пошукати інші проекти цією мовою:',
	'wminc-infopage-option-multilingual' => 'Ви можете перейти до багатомовних вікіпроектів:',
	'wminc-infopage-createmainpage' => 'Введіть фразу «Головна сторінка» на цій мові:',
	'wminc-infopage-contribute' => 'Якщо ви розумієте цю мову, ви можете внести свій вклад!',
	'wminc-infopage-status-imported' => 'Ця вікі була перенесена до Інкубатору з $1 після її закриття.',
	'wminc-infopage-status-closedsister' => 'Цей піддомен було закрито. Перейти до <b>$2</b>, щоб зробити внесок до цієї вікі.',
	'wminc-infopage-status-created' => 'Цей проект було схвалено мовним комітетом і тепер він доступний на $1.',
	'wminc-infopage-status-beforeincubator' => 'Цей проект було створено до існування Інкубатора Вікімедіа, доступний $1.',
);

/** Vietnamese (Tiếng Việt)
 * @author Kimkha
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'wminc-infopage-enter' => 'đi đến Trang Chính',
	'wminc-unknownlang' => '(ngôn ngữ không rõ với mã “$1”)',
	'wminc-infopage-title-p' => 'Wikipedia $1',
	'wminc-infopage-title-b' => 'Wikibooks $1',
	'wminc-infopage-title-t' => 'Wiktionary $1',
	'wminc-infopage-title-q' => 'Wikiquote $1',
	'wminc-infopage-title-n' => 'Wikinews $1',
	'wminc-infopage-title-s' => 'Wikisource $1',
	'wminc-infopage-title-v' => 'Wikiversity $1',
	'wminc-infopage-welcome' => 'Hoan nghênh bạn đến với Wikimedia Incubator, một dự án của Quỹ Wikimedia ([[{{MediaWiki:Aboutpage}}|Giới thiệu]])',
	'wminc-infopage-missingwiki-text' => '$1 chưa có sẵn trong ngôn ngữ này.',
	'wminc-infopage-option-startwiki' => 'Nếu bạn muốn bắt đầu xây dựng wiki này, [{{fullurl:{{FULLPAGENAME}}|action=edit}} tạo ra trang này] và thực hiện theo [[{{MediaWiki:Wminc-manual-url}}|sách hướng dẫn của chúng ta]].',
	'wminc-infopage-option-startsister' => 'Để bắt đầu wiki này, hãy ghé vào <b>[$2 $1]</b>.',
	'wminc-infopage-option-languages-existing' => 'Bạn có thể tìm kiếm [//www.$1.org phiên bản ngôn ngữ hiện có của $1].',
	'wminc-infopage-option-sisterprojects-existing' => 'Bạn có thể tìm kiếm các dự án hiện có trong ngôn ngữ này:',
	'wminc-infopage-option-sisterprojects-other' => 'Bạn có thể tìm kiếm các dự án khác dùng ngôn ngữ này:',
	'wminc-infopage-option-multilingual' => 'Bạn có thể ghé vào một wiki đa ngôn ngữ:',
	'wminc-infopage-createmainpage' => 'Nhập từ “Trang Chính” trong ngôn ngữ này:',
	'wminc-infopage-contribute' => 'Nếu bạn biết ngôn ngữ này, rất hoan nghênh bạn đóng góp cho nó!',
	'wminc-infopage-status-imported' => 'Wiki Incubator này đã được nhập từ $1 sau khi wiki đó bị đóng cửa.',
	'wminc-infopage-status-closedsister' => 'Tên miền phụ này đã bị đóng cửa. Hãy ghé vào <b>$2</b> để đóng góp vào wiki này.',
	'wminc-infopage-status-created' => 'Dự án đã được ủy ban ngôn ngữ chấp thuận và hiện có sẵn tại $1.',
	'wminc-infopage-status-beforeincubator' => 'Dự án này được tạo trước khi Wikimedia Incubator mở cửa và hiện có sẵn tại $1.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'wminc-infopage-title-p' => 'וויקיפעדיע $1',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Anakmalaysia
 * @author Dalt
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'wminc-infopage-enter' => '转至主页',
	'wminc-unknownlang' => '（具有“$1”代码的未明语言）',
	'wminc-infopage-title-p' => '$1维基百科',
	'wminc-infopage-title-b' => '$1维基教科书',
	'wminc-infopage-title-t' => '$1维基词典',
	'wminc-infopage-title-q' => '$1维基语录',
	'wminc-infopage-title-n' => '$1维基新闻',
	'wminc-infopage-title-s' => '$1维基文库',
	'wminc-infopage-title-v' => '$1维基学院',
	'wminc-infopage-welcome' => '欢迎来到维基孵育场，维基媒体基金会各有项目之一
（[[{{MediaWiki:Aboutpage}}|关于我们]]）',
	'wminc-infopage-missingwiki-text' => '这种语言的$1尚未存在。',
	'wminc-infopage-option-startwiki' => '若想创建这个维基项目，您可以[{{fullurl:{{FULLPAGENAME}}|action=edit}} 创建该页面]并按照我们所提供的[[{{MediaWiki:Wminc-manual-url}}|手册]]。',
	'wminc-infopage-option-startsister' => '若想创建这个维基项目，请转到<b>[$2 $1]</b>。',
	'wminc-infopage-option-languages-existing' => '您可以搜索[//www.$1.org $1所现有的语言版本]。',
	'wminc-infopage-option-sisterprojects-existing' => '您可以在这种语言中搜索现有项目：',
	'wminc-infopage-option-sisterprojects-other' => '您可以在这种语言搜索其他项目：',
	'wminc-infopage-option-multilingual' => '您可以转到一个多语种的维基项目：',
	'wminc-infopage-createmainpage' => '输入“主页”此词在这种语言的翻译：',
	'wminc-infopage-contribute' => '如果您会这门语言，欢迎您做出贡献！',
	'wminc-infopage-status-imported' => '该维基项目关闭后，这个孵育场维基已从$1导入。',
	'wminc-infopage-status-closedsister' => '此子域名已关闭。请转到<b>$2</b>为此维基项目作出贡献。',
	'wminc-infopage-status-created' => '此项目已经受语言委员会批准，现已在$1可以使用。',
	'wminc-infopage-status-beforeincubator' => '此项目已在维基孵育场开场之前创建，而在$1可以使用。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 */
$messages['zh-hant'] = array(
	'wminc-infopage-enter' => '轉到主頁',
	'wminc-unknownlang' => '（具有“$1”代碼的未明語言）',
	'wminc-infopage-title-p' => '$1維基百科',
	'wminc-infopage-title-b' => '$1維基教科書',
	'wminc-infopage-title-t' => '$1維基詞典',
	'wminc-infopage-title-q' => '$1維基語錄',
	'wminc-infopage-title-n' => '$1維基新聞',
	'wminc-infopage-title-s' => '$1維基文庫',
	'wminc-infopage-title-v' => '$1維基學院',
	'wminc-infopage-welcome' => '歡迎來到維基孵育場，維基媒體基金會各有項目之一
（[[{{MediaWiki:Aboutpage}}|關於我們]]）',
	'wminc-infopage-missingwiki-text' => '這種語言的$1尚未存在。',
	'wminc-infopage-option-startwiki' => '若想創建這個維基項目，您可以[{{fullurl:{{​​FULLPAGENAME}}|action=edit}} 創建該頁面]並按照我們所提供的[[{{MediaWiki:Wminc-manual-url}}|手冊]]。',
	'wminc-infopage-option-startsister' => '若想創建這個維基項目，請轉到<b>[$2 $1]</b>。',
	'wminc-infopage-option-languages-existing' => '您可以搜尋[//www.$1.org $1所現有的語言版本]。',
	'wminc-infopage-option-sisterprojects-existing' => '您可以在這種語言中搜尋現有項目：',
	'wminc-infopage-option-sisterprojects-other' => '您可以在這種語言中搜尋其他項目：',
	'wminc-infopage-option-multilingual' => '您可以轉到一個多語種的維基項目：',
	'wminc-infopage-createmainpage' => '輸入「主頁」此詞在這種語言的翻譯：',
	'wminc-infopage-contribute' => '如果您會這門語言，歡迎您做出貢獻！',
	'wminc-infopage-status-imported' => '該維基項目關閉後，這個孵育場維基已從$1導入。',
	'wminc-infopage-status-closedsister' => '此子域名已關閉。請轉到<b>$2</b>為此維基項目作出貢獻。',
	'wminc-infopage-status-created' => '此項目已經受語言委員會批准，現已在$1可以使用。',
	'wminc-infopage-status-beforeincubator' => '此項目已在維基孵育場開場之前創建，而在$1可以使用。',
);

