<?php
/*
*
*   WikiBhasha
*   Copyright (C) 2010, Microsoft
*   
*   This program is free software; you can redistribute it and/or
*   modify it under the terms of the GNU General Public License version 2
*   as published by the Free Software Foundation.
*   
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*   
*   You should have received a copy of the GNU General Public License
*   along with this program; if not, write to the Free Software
*   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*
*/

/*
*
*	If you want your extension to be used on wikis that have a multi-lingual readership, we will need to add internationalization support to the extension. 
*
*	1.For any text string displayed to the user, define a message. MediaWiki supports parameterized messages and that feature should be used when a message is dependent on information generated at runtime. Assign each message a lowercase message id.
*	2.In the setup and implementation code, replace each literal use of the message with a call to wfMsg( $msgID, $param1, $param2, ... ). Example : wfMsg( 'addition', '1', '2', '3' )
*	3.Store the message definition in the internalization file (WikiBhasha.i18n.php) . This is normally done by setting up an array that maps language and message id to each string. Each message id should be lowercase and they may not contain spaces
*
*
*/
$messages = array();

/**
 * English
 */
$messages['en'] = array(
	'wikibhasha' => 'WikiBhasha',
	'wikibhasha-desc' => 'Application to create multilingual content leveraging the English Wikipedia content',
	'wikiBhashaLink' => 'WikiBhasha (Beta)',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Raymond
 */
$messages['qqq'] = array(
	'wikibhasha' => '{{Optional}}',
	'wikibhasha-desc' => '{{desc}}',
	'wikiBhashaLink' => '{{Optional}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wikibhasha-desc' => 'Toepassing om inhoud in verskeie tale te skep en sodoende die inhoud van die Engelse Wikipedia beter te gebruik',
);

/** Arabic (العربية)
 * @author Ciphers
 * @author Meno25
 */
$messages['ar'] = array(
	'wikibhasha' => 'ويكي باشا',
	'wikibhasha-desc' => 'تطبيق لإنشاء محتوى متعدد اللغات بالاستفادة من محتوى ويكيبيديا الإنجليزية',
	'wikiBhashaLink' => 'ويكي باشا (بيتا)',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'wikibhasha-desc' => "Aplicación pa crear conteníu multilingüe a partir del conteníu de la Wikipedia n'inglés",
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'wikibhasha-desc' => 'Дастасаваньне для стварэньня шматмоўнага зьместу, які выкарыстоўвае зьмест ангельскай Вікіпэдыі',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'wikibhasha-desc' => 'Ur poellad evit krouiñ danvez liesyezhek, diazezet war danvez ar Wikipedia saoznek',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'wikibhasha-desc' => 'Program koji pravi višejezični sadržaj tako da bi se bolje iskoristio sadržaj Wikipedije na engleskom jeziku',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'wikibhasha-desc' => 'Aplikace pro tvorbu mnohojazyčného obsahu s využitím anglické Wikipedie',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Kghbln
 */
$messages['de'] = array(
	'wikibhasha-desc' => 'Stellt eine Anwendung bereit, mit der vielsprachige Inhalte erstellt und so die der englischsprachigen Wikipedia besser genutzt werden können',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'wikibhasha-desc' => 'Aplikacija za zgótowanje wěcejrěcnego wopśimjeśa, ab se wopśimjeśe engelskeje Wikipedije lěpjej zwužytkowało',
);

/** Greek (Ελληνικά)
 * @author Geraki
 */
$messages['el'] = array(
	'wikibhasha-desc' => 'Εφαρμογή για τη δημιουργία πολυγλωσσικού περιεχομένου αξιοποιώντας το περιεχόμενο της αγγλική Wikipedia',
);

/** French (Français)
 * @author Jean-Frédéric
 */
$messages['fr'] = array(
	'wikibhasha-desc' => 'Application pour créer du contenu multilingue, en se basant sur le contenu de la Wikipédia en langue anglaise',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wikibhasha-desc' => 'Aplicación para crear contidos multilingües a partir dos presentes na Wikipedia en inglés',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'wikibhasha-desc' => 'Aawändig, wu mer Inhalt in vile Sproche cha aalege un eso d Inhalt vu dr änglische Wikipedia besser cha nutze',
);

/** Hebrew (עברית)
 * @author YaronSh
 */
$messages['he'] = array(
	'wikibhasha-desc' => 'יישום ליצירת תוכן רב־לשוני על ידי שימוש בתוכן של הוויקיפדיה האנגלית',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'wikibhasha-desc' => 'Aplikacija za wutworjenje wjelerěčneho wobsaha za lěpše zwužitkowanje jendźelskeje Wikipedije',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wikibhasha-desc' => 'Application pro crear contento multilingue a base del contento de Wikipedia in anglese',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'wikibhasha-desc' => 'Aplikasi untuk membuat konten multibahasa dengan memanfaatkan isi Wikipedia bahasa Inggris',
);

/** Italian (Italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'wikibhasha-desc' => 'Applicazione per creare contenuti multilingua sfruttando il contenuto della Wikipedia in inglese',
);

/** Japanese (日本語)
 * @author 青子守歌
 */
$messages['ja'] = array(
	'wikibhasha-desc' => 'ウィキペディア英語版の記事を利用して、多言語記事を作成するアプリケーション',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'wikibhasha-desc' => 'En Aanwendung, öm Enhallde en mieh wi eine Shprooch ze schaffe un esu de Wikipedija op Änglesch mieh Ennfommazjuhne zohzeföhre.',
);

/** Kirghiz (Кыргызча)
 * @author AidaBishkek
 */
$messages['ky'] = array(
	'wikibhasha-desc' => 'Англис тилиндеги Уикипедиянын мазмунунун негизинде көп тилдүү мазмун түзүү үчүн тиркеме',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'wikibhasha-desc' => 'Applicatioun fir méisproocheg Inhalter op Basis vun der englescher Wikipedia ze schafen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wikibhasha' => 'WikiBhasha',
	'wikibhasha-desc' => 'Програм за создавање на повеќејазични содржини користејќи ги содржините на англиската Википедија',
	'wikiBhashaLink' => 'WikiBhasha (Бета)',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wikibhasha-desc' => 'Aplikasi untuk mewujudkan kandungan berbilang bahasa berasaskan kandungan Wikipedia Bahasa Inggeris',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'wikibhasha-desc' => 'Program for å opprette mangespråklig innhold som har innflytelse over innholdet på den engelske Wikipedia',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'wikibhasha-desc' => 'Toepassing om inhoud te maken in meerdere talen om zo de inhoud van de Engelstalige Wikipedia beter te gebruiken',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'wikibhasha-desc' => 'Aplikacja do tworzenia wielojęzycznych treści wykorzystująca zawartość angielskiej Wikipedii',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'wikibhasha-desc' => 'Aplicassion për creé dël contnù multilenga an pogiand-se an sël contnù dla Wikipedia anglèisa',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'wikibhasha-desc' => 'Aplicação para criar conteúdos multilingues a partir do conteúdo da Wikipédia em inglês',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'wikibhasha-desc' => 'Aplicação para criar conteúdos multilingues a partir do conteúdo da Wikipédia em inglês',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'wikibhasha-desc' => "Applicazione pe ccrejà condenute multi-lènghe partenne da le condenute d'a Uicchipedìe Inglese",
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'wikibhasha-desc' => 'Приложение для создания многоязычных произведений на основе материалов английской Википедии',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'wikibhasha' => 'WikiBhasha',
	'wikiBhashaLink' => 'WikiBhasha (бета)',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'wikibhasha' => 'WikiBhasha',
	'wikiBhashaLink' => 'WikiBhasha (beta)',
);

/** Telugu (తెలుగు)
 * @author రహ్మానుద్దీన్
 */
$messages['te'] = array(
	'wikibhasha-desc' => 'ఆంగ్ల వికీపీడియా మద్దతుతో బహుభాషా విషయాన్ని తయారుచేయుటకు అనువర్తనము',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'wikibhasha-desc' => 'Додаток для створення багатомовного змісту використовуючи зміст англійської Вікіпедії',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'wikibhasha-desc' => 'Ứng dụng để biên tập nội dung đa ngôn ngữ dựa trên nội dung của Wikipedia tiếng Anh',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'wikibhasha-desc' => '应用程序创建多语言内容，利用英语维基百科的内容',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'wikibhasha-desc' => '利用英文維基百科，創建多語言內容的工具',
);

