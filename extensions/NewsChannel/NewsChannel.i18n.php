<?php
/**
* News Channel extension 1.6
* This MediaWiki extension represents a RSS 2.0/Atom 1.0 news channel for wiki project.
* 	The channel is implemented as a dynamic [[Special:NewsChannel|special page]].
* 	All pages from specified category (e.g. "Category:News") are considered
* 	to be articles about news and published on the site's news channel.
* Internationalization file, containing message strings for extension.
* Requires MediaWiki 1.8 or higher.
* Extension's home page: http://www.mediawiki.org/wiki/Extension:News_Channel
*
* Distributed under GNU General Public License 2.0 or later (http://www.gnu.org/copyleft/gpl.html)
*/

$messages = array();

/** English
 * @author Iaroslav Vassiliev
 */
$messages['en'] = array(
	'newschannel' => 'News channel',
	'newschannel-desc' => 'Implements a news channel as a dynamic [[Special:NewsChannel|special page]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Additional category:',
	'newschannel_exclude_category' => 'Exclude category:',
	'newschannel_submit_button' => 'Create feed',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Purodha
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'newschannel-desc' => '{{desc}}',
	'newschannel_format' => '{{Identical|Format}}',
	'newschannel_limit' => '{{Identical|Limit}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'newschannel_format' => 'Formaat:',
	'newschannel_limit' => 'Limiet:',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'newschannel' => 'قناة أخبار',
	'newschannel-desc' => 'يطبق قناة أخبار [[Special:NewsChannel|كصفحة خاصة]] ديناميكية',
	'newschannel_format' => 'الصيغة:',
	'newschannel_limit' => 'الحد:',
	'newschannel_include_category' => 'تصنيف إضافي:',
	'newschannel_exclude_category' => 'استبعد التصنيف:',
	'newschannel_submit_button' => 'إنشاء التلقيم',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'newschannel' => 'قناة أخبار',
	'newschannel-desc' => 'يطبق قناة أخبار [[Special:NewsChannel|كصفحة خاصة]] ديناميكية',
	'newschannel_format' => 'الصيغة:',
	'newschannel_limit' => 'الحد:',
	'newschannel_include_category' => 'تصنيف إضافي:',
	'newschannel_exclude_category' => 'استبعد التصنيف:',
	'newschannel_submit_button' => 'إنشاء التلقيم',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'newschannel' => "Canal d'anuncies",
	'newschannel-desc' => "Implementa una canal d'anuncies como una [[Special:NewsChannel|páxina especial]] dinámica",
	'newschannel_format' => 'Formatu:',
	'newschannel_limit' => 'Llímite:',
	'newschannel_include_category' => 'Categoría adicional:',
	'newschannel_exclude_category' => 'Escluyir categoría:',
	'newschannel_submit_button' => "Crear fonte d'anuncies",
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'newschannel-desc' => 'Bir xəbər kanalını dinamik bir [[Special:NewsChannel|xüsusi səhifə]] olaraq uygulamaya qoyar',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_exclude_category' => 'Bu kateqoriyanı kanarda saxla:',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'newschannel_format' => 'Фармат:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'newschannel' => 'Канал навінаў',
	'newschannel-desc' => 'Стварае канал навінаў на дынамічнай [[Special:NewsChannel|спэцыяльнай старонцы]]',
	'newschannel_format' => 'Фармат:',
	'newschannel_limit' => 'Ліміт:',
	'newschannel_include_category' => 'Дадатковая катэгорыя:',
	'newschannel_exclude_category' => 'Выключыць катэгорыю:',
	'newschannel_submit_button' => 'Стварыць канал',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'newschannel-desc' => 'Създава емисия с новини като [[Special:NewsChannel|специална страница]]',
	'newschannel_format' => 'Формат:',
	'newschannel_limit' => 'Лимит:',
	'newschannel_include_category' => 'Допълнителна категория:',
	'newschannel_exclude_category' => 'Изключване на категория:',
	'newschannel_submit_button' => 'Създаване на емисия',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'newschannel' => 'খবরের চ্যানেল',
	'newschannel_format' => 'বিন্যাস:',
	'newschannel_limit' => 'সীমা:',
	'newschannel_include_category' => 'অতিরিক্ত বিষয়শ্রেণী:',
	'newschannel_submit_button' => 'ফিড তৈরি',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'newschannel' => 'Kanol geleier',
	'newschannel-desc' => 'Emplementiñ a ra ur ganol geleier evel [[Special:NewsChannel|ur bajenn dibar]] dinamek',
	'newschannel_format' => 'Furmad :',
	'newschannel_limit' => 'Bevenn :',
	'newschannel_include_category' => 'Rummad ouzhpenn :',
	'newschannel_exclude_category' => 'Rummad lezet a-gostez :',
	'newschannel_submit_button' => 'Krouiñ al lanvad',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'newschannel' => 'Kanal novosti',
	'newschannel-desc' => 'Koristi kanal za novosti kao dinamičku [[Special:NewsChannel|posebnu stranicu]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Ograničenje:',
	'newschannel_include_category' => 'Dodatna kategorija:',
	'newschannel_exclude_category' => 'Isključi kategoriju:',
	'newschannel_submit_button' => 'Napravi fid',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'newschannel' => 'Хааман зlе',
	'newschannel-desc' => 'Кхуллу хааман аса башхонца [[Special:NewsChannel|белха агlо санна]]',
	'newschannel_format' => 'Хааман барам:',
	'newschannel_limit' => 'Тlаьхьара хааман дукхалла:',
	'newschannel_include_category' => 'Кхин тlе кадегар:',
	'newschannel_exclude_category' => 'Юкъараяккха кадегар:',
	'newschannel_submit_button' => 'Араяккха',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'newschannel' => 'Kanál novinek',
	'newschannel-desc' => 'Implementuje kanál novinek jako dynamickou [[Special:NewsChannel|speciální stránku]]',
	'newschannel_format' => 'Formát:',
	'newschannel_limit' => 'Omezení:',
	'newschannel_include_category' => 'Další kategorie:',
	'newschannel_exclude_category' => 'Kromě kategorií:',
	'newschannel_submit_button' => 'Vytvořit kanál',
);

/** German (Deutsch)
 * @author Cornelius Sicker
 */
$messages['de'] = array(
	'newschannel' => 'Nachrichten',
	'newschannel-desc' => 'Ergänzt einen Nachrichtenkanal als dynamische [[Special:NewsChannel|Spezialseite]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Zusätzliche Kategorie:',
	'newschannel_exclude_category' => 'Auszuschließende Kategorie:',
	'newschannel_submit_button' => 'Feed erstellen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'newschannel' => 'Kanal powěsćow',
	'newschannel-desc' => 'Implementěrujo kanal powěsćow ako dynamiski [[Special:NewsChannel|specialny bok]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Pśidatna kategorija:',
	'newschannel_exclude_category' => 'Kategorija, kótaraž ma se wuzamknuś:',
	'newschannel_submit_button' => 'Kanal napóraś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'newschannel' => 'Κανάλι νέων',
	'newschannel-desc' => 'Υλοποεί ένα κανάλι νέων ως μία δυναμική [[Special:NewsChannel|ειδική σελίδα]]',
	'newschannel_format' => 'Μορφή:',
	'newschannel_limit' => 'Όριο:',
	'newschannel_include_category' => 'Πρόσθετη κατηγορία:',
	'newschannel_exclude_category' => 'Εξαίρεση κατηγορίας:',
	'newschannel_submit_button' => 'Δημιουργία ροής',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'newschannel' => 'Aktualaĵa kanelo',
	'newschannel_format' => 'Formato:',
	'newschannel_limit' => 'Limo:',
	'newschannel_include_category' => 'Aldona kategorio:',
	'newschannel_exclude_category' => 'Ekskludi kategorion:',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Sanbec
 */
$messages['es'] = array(
	'newschannel' => 'Canal de noticias',
	'newschannel-desc' => 'Implementa un canal de noticias como una [[Special:NewsChannel|página especial]] dinámica',
	'newschannel_format' => 'Formato:',
	'newschannel_limit' => 'Límite:',
	'newschannel_include_category' => 'Categoría adicional:',
	'newschannel_exclude_category' => 'Excluir categoría:',
	'newschannel_submit_button' => 'Crear sindicación',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'newschannel' => 'Uudistekanal',
	'newschannel_format' => 'Formaat:',
	'newschannel_include_category' => 'Lisakategooria:',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'newschannel' => 'Albisteen kanala',
	'newschannel_format' => 'Formatua:',
	'newschannel_limit' => 'Muga:',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Str4nd
 */
$messages['fi'] = array(
	'newschannel' => 'Uutiskanava',
	'newschannel-desc' => 'Toteuttaa uutiskanavan dynaamisena [[Special:NewsChannel|toimintosivuna]].',
	'newschannel_format' => 'Muoto',
	'newschannel_limit' => 'Rajoitus',
	'newschannel_include_category' => 'Lisäluokka:',
	'newschannel_exclude_category' => 'Poissulkeva luokka:',
	'newschannel_submit_button' => 'Luo syöte',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author Mauro Bornet
 * @author McDutchie
 */
$messages['fr'] = array(
	'newschannel' => 'Chaîne d’information',
	'newschannel-desc' => 'Implémente une chaîne de nouvelles comme une [[Special:NewsChannel|page spéciale]] dynamique',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limite:',
	'newschannel_include_category' => 'Catégorie(s) additionnelle(s):',
	'newschannel_exclude_category' => 'Catégorie(s) exclue(s):',
	'newschannel_submit_button' => 'Créer le flux',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'newschannel' => 'Chêna de novèles',
	'newschannel_format' => 'Format :',
	'newschannel_limit' => 'Limita :',
	'newschannel_include_category' => 'Catègorie(s) de ples :',
	'newschannel_exclude_category' => 'Catègorie èxcllua :',
	'newschannel_submit_button' => 'Fâre lo flux',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'newschannel_format' => 'Formáid:',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'newschannel' => 'Canle de novas',
	'newschannel-desc' => 'Insire unha canle de novas como unha [[Special:NewsChannel|páxina especial]] dinámica',
	'newschannel_format' => 'Formato:',
	'newschannel_limit' => 'Límite:',
	'newschannel_include_category' => 'Categoría adicional:',
	'newschannel_exclude_category' => 'Excluír a categoría:',
	'newschannel_submit_button' => 'Crear a fonte de novas',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'newschannel_format' => 'Μορφή:',
	'newschannel_limit' => 'Ὅριον:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'newschannel' => 'Nochrichte',
	'newschannel-desc' => 'Ergänzt e Nochrichtekanal as dynamischi [[Special:NewsChannel|Spezialsyte]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Zuesätzligi Kategorii:',
	'newschannel_exclude_category' => 'Kategorii, wu uusgschlosse soll wäre:',
	'newschannel_submit_button' => 'Feed aalege',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'newschannel' => 'ערוץ חדשות',
	'newschannel-desc' => 'הטמעת ערוץ חדשות בתור [[Special:NewsChannel|דף מיוחד]] דינאמי',
	'newschannel_format' => 'מבנה:',
	'newschannel_limit' => 'מגבלה:',
	'newschannel_include_category' => 'קטגוריה נוספת:',
	'newschannel_exclude_category' => 'התעלמות מהקטגוריה:',
	'newschannel_submit_button' => 'יצירת הזנה',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'newschannel' => 'Powěsćowy kanal',
	'newschannel-desc' => 'Implementuje powěsćowy kanal jako dynamisku [[Special:NewsChannel|specialnu stronu]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Přidatna kategorija:',
	'newschannel_exclude_category' => 'Kategoriju wuzamknyć:',
	'newschannel_submit_button' => 'Kanal wutworić',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'newschannel' => 'Hírcsatorna',
	'newschannel-desc' => 'Hírcsatorna megvalósítás dinamikus [[Special:NewsChannel|speciális lapként]]',
	'newschannel_format' => 'Formátum:',
	'newschannel_limit' => 'Korlát:',
	'newschannel_include_category' => 'További kategória:',
	'newschannel_exclude_category' => 'Kategória kihagyása:',
	'newschannel_submit_button' => 'Hírcsatorna készítése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'newschannel' => 'Canal de novas',
	'newschannel-desc' => 'Implementa un canal de novas como un [[Special:NewsChannel|pagina special]] dynamic',
	'newschannel_format' => 'Formato:',
	'newschannel_limit' => 'Limite:',
	'newschannel_include_category' => 'Categoria additional:',
	'newschannel_exclude_category' => 'Excluder categoria:',
	'newschannel_submit_button' => 'Crear syndication',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'newschannel' => 'Saluran berita',
	'newschannel-desc' => 'Memasang sebuah saluran berita sebagai [[Special:NewsChannel|halaman istimewa]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Batas:',
	'newschannel_include_category' => 'Kategori tambahan:',
	'newschannel_exclude_category' => 'Jangan masukkan kategori:',
	'newschannel_submit_button' => 'Buat sindikasi',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'newschannel' => 'Nkushi Akíkó Uwà',
	'newschannel_format' => 'Udi:',
	'newschannel_limit' => 'Érúrú:',
	'newschannel_exclude_category' => 'Kúfù na uzor ebe ihe nor:',
	'newschannel_submit_button' => 'Ké ntá',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'newschannel' => 'Canale di informazione',
	'newschannel-desc' => 'Implementa un canale di notizie come una [[Special:NewsChannel|pagina speciale]] dinamica',
	'newschannel_format' => 'Formato:',
	'newschannel_limit' => 'Limite:',
	'newschannel_include_category' => 'Ulteriori categorie:',
	'newschannel_exclude_category' => 'Escludi categoria:',
	'newschannel_submit_button' => 'Crea feed',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'newschannel' => 'ニュース・チャンネル',
	'newschannel-desc' => '動的な[[Special:NewsChannel|特別ページ]]としてニュース・チャンネルを実装する',
	'newschannel_format' => 'ファイル形式:',
	'newschannel_limit' => '最大項目数:',
	'newschannel_include_category' => '追加するカテゴリ:',
	'newschannel_exclude_category' => '除外するカテゴリ:',
	'newschannel_submit_button' => 'フィード作成',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'newschannel_format' => 'ទ្រង់ទ្រាយ​៖',
	'newschannel_limit' => 'លីមីត:',
	'newschannel_include_category' => 'ចំណាត់ថ្នាក់ក្រុម​បន្ថែម:',
	'newschannel_exclude_category' => 'ចំណាត់ថ្នាក់មិនរាប់បញ្ចូល:',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'newschannel' => 'Neueschkeite-Kanaal',
	'newschannel-desc' => 'Määt ene Neueschkeite-Kanaal als en dünamesch [[Special:NewsChannel|Söndersigg]] op.',
	'newschannel_format' => 'Fomaat:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Zosätzlijje Saachjropp:',
	'newschannel_exclude_category' => 'Ußjeschloße Saachjrupp:',
	'newschannel_submit_button' => 'Kanaal opmaache',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Sînor:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'newschannel' => 'Neiegkeeten',
	'newschannel-desc' => 'Implementéiert e Noriichtekanal als dynamesch [[Special:NewsChannel|Spezialsäit]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Zousätzlech Kategorie:',
	'newschannel_exclude_category' => 'Kategorie ausschléissen:',
	'newschannel_submit_button' => 'Rubrik uleeën',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'newschannel' => 'Канал за вести',
	'newschannel-desc' => 'Имплементира канал за вести како динамична [[Special:NewsChannel|специјална страница]]',
	'newschannel_format' => 'Формат:',
	'newschannel_limit' => 'Ограничување:',
	'newschannel_include_category' => 'Дополнителна категорија:',
	'newschannel_exclude_category' => 'Исклучи ја категоријата:',
	'newschannel_submit_button' => 'Создај емитување',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'newschannel_limit' => 'പരിധി:',
	'newschannel_include_category' => 'കൂടുതൽ വർഗ്ഗം:',
	'newschannel_exclude_category' => 'വർഗ്ഗം ഒഴിവാക്കുക:',
	'newschannel_submit_button' => 'ഫീഡ് സൃഷ്ടിക്കുക',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'newschannel' => 'Saluran berita',
	'newschannel-desc' => 'Melaksanakan satu saluran berita dalam bentuk [[Special:NewsChannel|laman khas]] yang dinamik',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Had:',
	'newschannel_include_category' => 'Kategori tambahan:',
	'newschannel_exclude_category' => 'Kategori terkecuali:',
	'newschannel_submit_button' => 'Cipta suapan',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'newschannel' => 'Nyhtskanal',
	'newschannel-desc' => 'Implementerer en nyhetskanal som en dynamisk [[Special:NewsChannel|spesialside]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Grense:',
	'newschannel_include_category' => 'Ekstra kategori:',
	'newschannel_exclude_category' => 'Ekskluder kategori:',
	'newschannel_submit_button' => 'Opprett nyhetskilde',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'newschannel' => 'Nieuwskanaal',
	'newschannel-desc' => 'Voegt een nieuwskanaal toe als een dynamische [[Special:NewsChannel|speciale pagina]]',
	'newschannel_format' => 'Formaat:',
	'newschannel_limit' => 'Limiet:',
	'newschannel_include_category' => 'Additionele categorie:',
	'newschannel_exclude_category' => 'Uitgesloten categorie:',
	'newschannel_submit_button' => 'Feed aanmaken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'newschannel' => 'Nyhendekanal',
	'newschannel-desc' => 'Implementerer ein nyhendekanal som ei dynamisk [[Special:NewsChannel|spesialsida]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Grensa:',
	'newschannel_include_category' => 'Ekstra kategori:',
	'newschannel_exclude_category' => 'Ekskluder kategori:',
	'newschannel_submit_button' => 'Opprett nyhendekjelda',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'newschannel' => "Cadena d'informacion",
	'newschannel-desc' => 'Implementa un canal novèl coma una [[Special:NewsChannel|pagina especiala]] dinamica',
	'newschannel_format' => 'Format :',
	'newschannel_limit' => 'Limit :',
	'newschannel_include_category' => 'Categoria(s) addicionala(s) :',
	'newschannel_exclude_category' => 'Categoria(s) excluida(s) :',
	'newschannel_submit_button' => 'Crear lo flux',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'newschannel' => 'Nuus',
);

/** Polish (Polski)
 * @author Leinad
 */
$messages['pl'] = array(
	'newschannel' => 'Kanał informacyjny',
	'newschannel-desc' => 'Implementuje kanał informacyjny jako dynamiczną [[Special:NewsChannel|stronę specjalną]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Dodatkowa kategoria:',
	'newschannel_exclude_category' => 'Wyklucz z kategorii:',
	'newschannel_submit_button' => 'Utwórz kanał',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'newschannel' => 'Canal ëd neuve',
	'newschannel-desc' => 'A amplementa un canal ëd neuve con na [[Special:NewsChannel|pàgina special]] dinàmica',
	'newschannel_format' => 'Formà:',
	'newschannel_limit' => 'Lìmit:',
	'newschannel_include_category' => 'Categorìa adissional:',
	'newschannel_exclude_category' => 'Categorìa scartà:',
	'newschannel_submit_button' => 'Crea un feed',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'newschannel' => 'خبري کانال',
	'newschannel_format' => 'بڼه:',
	'newschannel_limit' => 'بريد:',
	'newschannel_include_category' => 'اضافه وېشنيزه:',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'newschannel' => 'Canal de notícias',
	'newschannel-desc' => 'Implementa um canal de notícias como uma [[Special:NewsChannel|página especial]] dinâmica',
	'newschannel_format' => 'Formato:',
	'newschannel_limit' => 'Limite:',
	'newschannel_include_category' => 'Categoria adicional:',
	'newschannel_exclude_category' => 'Excluir categoria:',
	'newschannel_submit_button' => 'Criar feed',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'newschannel' => 'Canal de notícias',
	'newschannel-desc' => 'Implementa um canal de notícias como uma [[Special:NewsChannel|página especial]] dinâmica',
	'newschannel_format' => 'Formato:',
	'newschannel_limit' => 'Limite:',
	'newschannel_include_category' => 'Categoria adicional:',
	'newschannel_exclude_category' => 'Excluir categoria:',
	'newschannel_submit_button' => 'Criar "feed"',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'newschannel' => 'Canal de știri',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limită:',
	'newschannel_include_category' => 'Categorie adițională:',
	'newschannel_exclude_category' => 'Exclude categoria:',
	'newschannel_submit_button' => 'Creați flux',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'newschannel_format' => 'Formate:',
	'newschannel_limit' => 'Limite:',
);

/** Russian (Русский)
 * @author Iaroslav Vassiliev
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'newschannel' => 'Канал новостей',
	'newschannel-desc' => 'Создаёт новостной канал в виде динамической [[Special:NewsChannel|служебной страницы]]',
	'newschannel_format' => 'Формат новостей:',
	'newschannel_limit' => 'Кол-во последних новостей:',
	'newschannel_include_category' => 'Дополнительная категория:',
	'newschannel_exclude_category' => 'Исключить категорию:',
	'newschannel_submit_button' => 'Вывести',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'newschannel' => 'Kanál noviniek',
	'newschannel-desc' => 'Implementuje kanál noviniek ako dynamickú [[Special:NewsChannel|špeciálnu stránku]]',
	'newschannel_format' => 'Formát:',
	'newschannel_limit' => 'Obmedzenie:',
	'newschannel_include_category' => 'Ďalšia kategória:',
	'newschannel_exclude_category' => 'Okrem kategórie:',
	'newschannel_submit_button' => 'Vytvoriť kanál',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'newschannel_format' => 'Формат:',
	'newschannel_limit' => 'Ограничење:',
	'newschannel_include_category' => 'Додатна категорија:',
	'newschannel_exclude_category' => 'Изузми категорију:',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Limit:',
	'newschannel_include_category' => 'Dodatna kategorija:',
	'newschannel_exclude_category' => 'Isključi kategoriju:',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'newschannel' => 'Nyhetskanal',
	'newschannel-desc' => 'Implementerar en nyhetskanal som en dynamisk [[Special:NewsChannel|specialsida]]',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Gräns:',
	'newschannel_include_category' => 'Ytterligare kategori:',
	'newschannel_exclude_category' => 'Exkluderar kategori:',
	'newschannel_submit_button' => 'Skapa nyhetskanal',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'newschannel' => 'వార్తా వాహిని',
	'newschannel_limit' => 'పరిమితి:',
	'newschannel_include_category' => 'అదనపు వర్గం:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'newschannel' => 'Istasyon ng mga Bagong Balita',
	'newschannel-desc' => 'Nagpapatupad ng isang estasyon ng mga bagong balita bilang isang masiglang [[Special:NewsChannel|natatanging pahina]]',
	'newschannel_format' => 'Anyo/Pormat:',
	'newschannel_limit' => 'Hangganan:',
	'newschannel_include_category' => 'Karagdagang kaurian:',
	'newschannel_exclude_category' => 'Huwag isali ang kaurian:',
	'newschannel_submit_button' => 'Lumikha ng pasubo/pakain',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'newschannel' => 'Haber kanalı',
	'newschannel-desc' => 'Bir haber kanalını dinamik bir [[Special:NewsChannel|özel sayfa]] olarak uygulamaya koyar',
	'newschannel_format' => 'Format:',
	'newschannel_limit' => 'Sınır:',
	'newschannel_include_category' => 'Ek kategori:',
	'newschannel_exclude_category' => 'Şu kategoriyi hariç tut:',
	'newschannel_submit_button' => 'Besleme oluştur',
);

/** Ukrainian (Українська)
 * @author AS
 */
$messages['uk'] = array(
	'newschannel' => 'Канал новин',
	'newschannel-desc' => 'Забезпечує канал новин, як динамічну [[Special:NewsChannel|спеціальну сторінку]]',
	'newschannel_format' => 'Формат:',
	'newschannel_limit' => 'Ліміт:',
	'newschannel_include_category' => 'Додаткова категорія:',
	'newschannel_exclude_category' => 'Виключити категорію:',
	'newschannel_submit_button' => 'Вивести',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'newschannel' => 'Uzištusiden kanal',
	'newschannel-desc' => "Sädab uzištusiden kanalan, kudamb nägub kuti [[Special:NewsChannel|specialine lehtpol']].",
	'newschannel_format' => 'Uzištusiden format:',
	'newschannel_limit' => 'Tantoižiden uzištusiden lugumär:',
	'newschannel_include_category' => 'Ližakategorii:',
	'newschannel_exclude_category' => 'Heitta poiš kategorii:',
	'newschannel_submit_button' => 'Ozutada',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'newschannel' => 'Đài tin tức',
	'newschannel-desc' => 'Cung cấp đài tin tức tại [[Special:NewsChannel|trang đặc biệt]] động',
	'newschannel_format' => 'Định dạng:',
	'newschannel_limit' => 'Giới hạn:',
	'newschannel_include_category' => 'Thể loại khác:',
	'newschannel_exclude_category' => 'Trừ thể loại:',
	'newschannel_submit_button' => 'Tạo nguồn tin',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'newschannel' => 'Nunakanad',
	'newschannel_format' => 'Fomät:',
	'newschannel_limit' => 'Mied:',
	'newschannel_include_category' => 'Klad pluik:',
	'newschannel_exclude_category' => 'Plödakipön kladi:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'newschannel' => '新闻频道',
	'newschannel_format' => '格式：',
	'newschannel_limit' => '限制：',
	'newschannel_exclude_category' => '排除分类：',
	'newschannel_submit_button' => '创建供稿',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'newschannel' => '新聞頻道',
	'newschannel_format' => '格式：',
	'newschannel_limit' => '限制：',
	'newschannel_exclude_category' => '排除分類：',
	'newschannel_submit_button' => '建立供稿',
);

