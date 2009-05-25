<?php

/**
 * AddNewTalkSection
 *
 * A AddNewTalkSection extension for MediaWiki
 * Make long talk pages easier to use, by adding an "add new section" link to the page end.
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-05-19
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AddNewTalkSection/AddNewTalkSection.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named AddNewTalkSection.\n";
	exit(1) ;
}

$messages = array(
	'ace' => array(
		'addnewtalksection-link' => 'Peutamah tapeusé u ôn peugah haba nyoë.',
	),
	'af' => array(
		'addnewtalksection-link' => 'Lewer kommentaar by hierdie bespreking.',
	),
	'aln' => array(
		'addnewtalksection-link' => "Nis një temë t're diskutimi.",
	),
	'am' => array(
		'addnewtalksection-link' => 'ለዚሁ ውይይት ገጽ አዲስ አርዕስት ለመጨምር',
	),
	'an' => array(
		'addnewtalksection-link' => 'Enzetar una nueba sezión',
	),
	'ar' => array(
		'addnewtalksection-link' => 'ابدأ قسما جديدا',
	),
	'arz' => array(
		'addnewtalksection-link' => 'ابتدى قسم جديد',
	),
	'as' => array(
		'addnewtalksection-link' => 'এই আলোচনাত আপোনাৰ মন্তব্য দিয়ক|',
	),
	'ast' => array(
		'addnewtalksection-link' => 'Emprima una seición nueva',
	),
	'avk' => array(
		'addnewtalksection-link' => 'Bokara va warzaf gabot',
	),
	'az' => array(
		'addnewtalksection-link' => 'Bu müzakirə səhifəsində iştirak edin.',
	),
	'bat_smg' => array(
		'addnewtalksection-link' => 'Pradietė nauja skīriu',
	),
	'bcc' => array(
		'addnewtalksection-link' => 'یک نوکین بخشی شر کن',
	),
	'bcl' => array(
		'addnewtalksection-link' => 'Magdugang nin komento sa orólay na ini.',
	),
	'be' => array(
		'addnewtalksection-link' => 'Дадаць новы раздзел',
	),
	'be_tarask' => array(
		'addnewtalksection-link' => 'Пачаць новую сэкцыю',
	),
	'bg' => array(
		'addnewtalksection-link' => 'Започване на нов раздел',
	),
	'bn' => array(
		'addnewtalksection-link' => 'এই আলোচনায় একটি মন্তব্য যোগ করো।',
	),
	'bpy' => array(
		'addnewtalksection-link' => 'য়্যারী এহাত তর মতহান তিলকর।',
	),
	'bqi' => array(
		'addnewtalksection-link' => 'اضاف کردن یه توضیح به ای مبحث',
	),
	'br' => array(
		'addnewtalksection-link' => 'Kregiñ gant ur rann nevez.',
	),
	'bs' => array(
		'addnewtalksection-link' => 'Započnite novu sekciju.',
	),
	'ca' => array(
		'addnewtalksection-link' => 'Comença una nova secció',
	),
	'ceb' => array(
		'addnewtalksection-link' => 'Pagdugang og komento niining panaghisgot-hisgot.',
	),
	'ch' => array(
		'addnewtalksection-link' => "Nå'ye komentu gi kometsasion.",
	),
	'crh_cyrl' => array(
		'addnewtalksection-link' => 'Янъы болюк ач',
	),
	'crh_latn' => array(
		'addnewtalksection-link' => 'Yañı bölük aç',
	),
	'cs' => array(
		'addnewtalksection-link' => 'Začít novou sekci',
	),
	'cv' => array(
		'addnewtalksection-link' => 'Кӗске ӑнлантару хушма пултаратӑр.',
	),
	'cy' => array(
		'addnewtalksection-link' => 'Ychwanegu adran newydd',
	),
	'da' => array(
		'addnewtalksection-link' => 'Tilføj en kommentar til denne diskussion.',
	),
	'de' => array(
		'addnewtalksection-link' => 'Neuen Abschnitt beginnen',
	),
	'de_weigsbrag' => array(
		'addnewtalksection-link' => 'Eines Gomendar su dose Disgusion dasugeb.',
	),
	'dsb' => array(
		'addnewtalksection-link' => 'Nowy wótrězk zachopiś',
	),
	'dz' => array(
		'addnewtalksection-link' => 'གྲོས་བསྡུར་འདི་ལུ་ བསམ་བཀོད་ཅིག་ཁ་སྐོང་རྐྱབས།',
	),
	'el' => array(
		'addnewtalksection-link' => 'Προσθέστε ένα νέο τμήμα',
	),
	'en' => array(
		'addnewtalksection-link' => 'Add new section',
	),
	'eo' => array(
		'addnewtalksection-link' => 'Starti novan sekcion',
	),
	'es' => array(
		'addnewtalksection-link' => 'Inicie una nueva sección',
	),
	'et' => array(
		'addnewtalksection-link' => 'Algata uus alajaotis',
	),
	'eu' => array(
		'addnewtalksection-link' => 'Iruzkin berria erantsi',
	),
	'ext' => array(
		'addnewtalksection-link' => 'Prencipial una nueva seción',
	),
	'fa' => array(
		'addnewtalksection-link' => 'یک بخش جدید ایجاد کنید',
	),
	'fi' => array(
		'addnewtalksection-link' => 'Lisää uusi osio',
	),
	'fiu_vro' => array(
		'addnewtalksection-link' => 'Jätäq taalõ lehele kommõntaar.',
	),
	'fo' => array(
		'addnewtalksection-link' => 'Skriva viðmerking til hesa umrøðuna.',
	),
	'fr' => array(
		'addnewtalksection-link' => 'Commencer une nouvelle section',
	),
	'frp' => array(
		'addnewtalksection-link' => 'Apondre un comentèro a ceta discussion',
	),
	'fur' => array(
		'addnewtalksection-link' => 'Scomence une gnove sezion',
	),
	'fy' => array(
		'addnewtalksection-link' => 'In opmerking tafoegje oan de oerlis-side.',
	),
	'ga' => array(
		'addnewtalksection-link' => 'Cuir trácht leis an plé seo..',
	),
	'gag' => array(
		'addnewtalksection-link' => 'Bu diskussiya için kommentariya ekleyin.',
	),
	'gan' => array(
		'addnewtalksection-link' => '開隻新嗰討論',
	),
	'gl' => array(
		'addnewtalksection-link' => 'Comezar unha nova sección',
	),
	'grc' => array(
		'addnewtalksection-link' => 'Ἄρχειν νέον τμῆμα',
	),
	'gsw' => array(
		'addnewtalksection-link' => 'Neje Abschnitt aafange',
	),
	'gu' => array(
		'addnewtalksection-link' => 'આ ચર્ચામાં તમારી ટીપ્પણી ઉમેરો.',
	),
	'gv' => array(
		'addnewtalksection-link' => 'Cur baght er y resoonaght shoh.',
	),
	'hak' => array(
		'addnewtalksection-link' => 'Chhai-yî pún thó-lun chông chen-kâ sîn-ke thó-lun chú-thì',
	),
	'he' => array(
		'addnewtalksection-link' => 'הוספת פסקה חדשה',
	),
	'hi' => array(
		'addnewtalksection-link' => 'इस वार्तालापमें अपनी राय दें ।',
	),
	'hif_latn' => array(
		'addnewtalksection-link' => 'Ii bahas me aapan bichar do.',
	),
	'hr' => array(
		'addnewtalksection-link' => 'Dodaj novi odlomak',
	),
	'hsb' => array(
		'addnewtalksection-link' => 'Nowy wotrězk započeć',
	),
	'ht' => array(
		'addnewtalksection-link' => 'Ajoute yon komantè nan diskisyon sa a.',
	),
	'hu' => array(
		'addnewtalksection-link' => 'Új szakasz nyitása',
	),
	'hy' => array(
		'addnewtalksection-link' => 'Ավելացնել մեկնաբանություն այս քննարկմանը',
	),
	'ia' => array(
		'addnewtalksection-link' => 'Initiar un nove section',
	),
	'id' => array(
		'addnewtalksection-link' => 'Mulai bagian baru',
	),
	'ilo' => array(
		'addnewtalksection-link' => 'Manginayon iti komento iti daytoy a diskusion.',
	),
	'io' => array(
		'addnewtalksection-link' => 'Komencar nova seciono',
	),
	'is' => array(
		'addnewtalksection-link' => 'Bæta athugasemd við þessa umræðu.',
	),
	'it' => array(
		'addnewtalksection-link' => 'Inizia una nuova sezione',
	),
	'ja' => array(
		'addnewtalksection-link' => '新しいセクションを開始する',
	),
	'jut' => array(
		'addnewtalksection-link' => 'Tilføj en biskrevselenge til denne diskusje.',
	),
	'jv' => array(
		'addnewtalksection-link' => 'Miwiti bagèyan anyar',
	),
	'ka' => array(
		'addnewtalksection-link' => 'ახალი სექციის შექმნა',
	),
	'kaa' => array(
		'addnewtalksection-link' => "Jan'a bo'lim jaratıw.",
	),
	'kab' => array(
		'addnewtalksection-link' => 'Rnu awennit i amyannan-agi.',
	),
	'kk_arab' => array(
		'addnewtalksection-link' => 'بۇل تالقىلاۋ بەتىندە جاڭا تاراۋ باستاۋ.',
	),
	'kk_cyrl' => array(
		'addnewtalksection-link' => 'Бұл талқылау бетінде жаңа тарау бастау.',
	),
	'kk_latn' => array(
		'addnewtalksection-link' => 'Bul talqılaw betinde jaña taraw bastaw.',
	),
	'km' => array(
		'addnewtalksection-link' => 'បន្ថែមមួយវិចារទៅការពិភាក្សានេះ។',
	),
	'kn' => array(
		'addnewtalksection-link' => 'ಈ ಚರ್ಚೆಗೆ ನಿಮ್ಮ ಅಭಿಪ್ರಾಯವನ್ನು ಸೇರಿಸಿ.',
	),
	'ko' => array(
		'addnewtalksection-link' => '내용 추가하기',
	),
	'kri' => array(
		'addnewtalksection-link' => 'Lehf yu-yon opinyon na dis diskohshohn.',
	),
	'ksh' => array(
		'addnewtalksection-link' => 'Donn hee enne neue Afschnett opmaache.',
	),
	'ku_arab' => array(
		'addnewtalksection-link' => 'بەشێکی نوێ دەست پێ بکە',
	),
	'ku_latn' => array(
		'addnewtalksection-link' => 'Beşekê zêde bike.',
	),
	'la' => array(
		'addnewtalksection-link' => 'Novam partem creare',
	),
	'lb' => array(
		'addnewtalksection-link' => 'En neien Abschnitt ufänken.',
	),
	'lfn' => array(
		'addnewtalksection-link' => 'Inisia un sesion nova',
	),
	'lg' => array(
		'addnewtalksection-link' => 'Nyiga wano oba oyagala okuwayo ekirowozo mu kuwanyisigana ebirowozo kuno.',
	),
	'li' => array(
		'addnewtalksection-link' => "Begin 'n nuuj sectie",
	),
	'lij' => array(
		'addnewtalksection-link' => "Azzonze 'n commento a 'sta discûscion chì.",
	),
	'lmo' => array(
		'addnewtalksection-link' => 'Taca un cument a questa discüssiun',
	),
	'lo' => array(
		'addnewtalksection-link' => 'ເພີ່ມ ຄຳເຫັນ ໃສ່ ການສົນທະນານີ້.',
	),
	'loz' => array(
		'addnewtalksection-link' => 'Lyangutukezi bye bulelezi.',
	),
	'lt' => array(
		'addnewtalksection-link' => 'Pradėti naują aptariamą temą',
	),
	'lv' => array(
		'addnewtalksection-link' => 'Sākt jaunu sadaļu',
	),
	'mdf' => array(
		'addnewtalksection-link' => 'Ушедомс од пакш',
	),
	'mk' => array(
		'addnewtalksection-link' => 'Започни нова секција',
	),
	'ml' => array(
		'addnewtalksection-link' => 'ഈ സംവാദത്തിനു ഒരു കുറിപ്പ് ചേര്‍ക്കുക.',
	),
	'mn' => array(
		'addnewtalksection-link' => 'Энэ хэлэлцүүлэгт санал бодлоо нэмж оруулах.',
	),
	'mr' => array(
		'addnewtalksection-link' => 'या चर्चेमध्ये मत नोंदवा.',
	),
	'ms' => array(
		'addnewtalksection-link' => 'Buka bahagian baru',
	),
	'mt' => array(
		'addnewtalksection-link' => "Żid kumment f'din id-diskussjoni.",
	),
	'mwl' => array(
		'addnewtalksection-link' => 'Ajuntar cometairo a esta çcuçon.',
	),
	'myv' => array(
		'addnewtalksection-link' => 'Топавтодо мельполадкс кортавтоманьте.',
	),
	'nah' => array(
		'addnewtalksection-link' => 'Tiquihcuilōz itlah inīn tēixnāmiquilizhuīc.',
	),
	'nds' => array(
		'addnewtalksection-link' => 'En Afsnidd tofögen',
	),
	'nds_nl' => array(
		'addnewtalksection-link' => 'Niej oonderwearp toovoogen',
	),
	'nl' => array(
		'addnewtalksection-link' => 'Nieuw kopje toevoegen',
	),
	'nn' => array(
		'addnewtalksection-link' => 'Start ein ny bolk',
	),
	'no' => array(
		'addnewtalksection-link' => 'Start ny seksjon',
	),
	'nso' => array(
		'addnewtalksection-link' => 'Lokela pono ya gago/Ahlaahla go poledišano ye.',
	),
	'oc' => array(
		'addnewtalksection-link' => 'Començar una seccion novèla',
	),
	'pam' => array(
		'addnewtalksection-link' => 'Mangibili kang komentu kaniting pisasabian.',
	),
	'pdt' => array(
		'addnewtalksection-link' => 'Eenen Kommentar to dise Diskussioon biedroage.',
	),
	'pl' => array(
		'addnewtalksection-link' => 'Dodaj nowy wątek.',
	),
	'pms' => array(
		'addnewtalksection-link' => 'Gionteje un coment a sta discussion-sì.',
	),
	'pnb' => array(
		'addnewtalksection-link' => 'اس گل بات وچ حصہ لے لو۔',
	),
	'pnt' => array(
		'addnewtalksection-link' => "Αρχίνεστε καινούρεον κομμάτ'.",
	),
	'ps' => array(
		'addnewtalksection-link' => 'يوه نوې برخه پيلول',
	),
	'pt' => array(
		'addnewtalksection-link' => 'Iniciar uma nova secção',
	),
	'pt_br' => array(
		'addnewtalksection-link' => 'Iniciar uma nova seção',
	),
	'qqq' => array(
		'addnewtalksection-link' => 'Tooltip shown when hovering over the "addsection" tab (shown on talk pages).',
	),
	'qu' => array(
		'addnewtalksection-link' => 'Musuq rakita qallariy',
	),
	'rif' => array(
		'addnewtalksection-link' => 'Arni tinit deg usiwl a.',
	),
	'rm' => array(
		'addnewtalksection-link' => 'Cumenzar nov paragraf',
	),
	'rmy' => array(
		'addnewtalksection-link' => 'Kathe shai te thos ek komentaryo ki kadaya diskuciya.',
	),
	'ro' => array(
		'addnewtalksection-link' => 'Adaugă o nouă secţiune.',
	),
	'roa_tara' => array(
		'addnewtalksection-link' => "Fà accumenzà 'na seziona nove",
	),
	'ru' => array(
		'addnewtalksection-link' => 'Создать новый раздел',
	),
	'sah' => array(
		'addnewtalksection-link' => 'Саҥа салааны саҕалааһын',
	),
	'scn' => array(
		'addnewtalksection-link' => 'Agghiunci un cummentu a sta discussioni.',
	),
	'sd' => array(
		'addnewtalksection-link' => 'هن بحث تي تاثرات درج ڪرايو',
	),
	'sdc' => array(
		'addnewtalksection-link' => 'Aggiungi un cummentu a chistha dischussioni',
	),
	'se' => array(
		'addnewtalksection-link' => 'Lasit kommeantta dán siidui',
	),
	'si' => array(
		'addnewtalksection-link' => 'නව ඡේදයක් අරඹන්න',
	),
	'sk' => array(
		'addnewtalksection-link' => 'Začať novú sekciu',
	),
	'sl' => array(
		'addnewtalksection-link' => 'Začnite novo razpravo',
	),
	'sma' => array(
		'addnewtalksection-link' => 'Lissiehtidh lahtestimmie gåajkoe dïhte dïjveldidh.',
	),
	'so' => array(
		'addnewtalksection-link' => 'Ku darso fikrad wadahadalkaan.',
	),
	'sq' => array(
		'addnewtalksection-link' => 'Fillo një temë të re diskutimi.',
	),
	'srn' => array(
		'addnewtalksection-link' => 'Poti wan boskopu ini a kruderi disi.',
	),
	'sr_ec' => array(
		'addnewtalksection-link' => 'Почните нову секцију',
	),
	'sr_el' => array(
		'addnewtalksection-link' => 'Dodajte komentar na ovu diskusiju',
	),
	'stq' => array(
		'addnewtalksection-link' => 'Näi Stuk ounfange',
	),
	'su' => array(
		'addnewtalksection-link' => 'Tambihan koméntar kana sawala ieu.',
	),
	'sv' => array(
		'addnewtalksection-link' => 'Starta ett nytt avsnitt',
	),
	'sw' => array(
		'addnewtalksection-link' => 'Anzisha fungu jipya.',
	),
	'szl' => array(
		'addnewtalksection-link' => 'Dodej kůmyntoř do godki',
	),
	'ta' => array(
		'addnewtalksection-link' => 'இவ்வுரையாடலுக்கு உங்கள் கருத்துக்களை சேர்க்க',
	),
	'tcy' => array(
		'addnewtalksection-link' => 'ಪೊಸ ಸೆಶನ್ನ್ ಶರು ಮಲ್ಪುಲೆ',
	),
	'te' => array(
		'addnewtalksection-link' => 'కొత్త విభాగాన్ని మొదలుపెట్టండి',
	),
	'tet' => array(
		'addnewtalksection-link' => 'Tau tan seksaun foun ida.',
	),
	'tg_cyrl' => array(
		'addnewtalksection-link' => 'Илова кардани эзоҳот ба ин баҳс',
	),
	'th' => array(
		'addnewtalksection-link' => 'เริ่มส่วนย่อยใหม่',
	),
	'tl' => array(
		'addnewtalksection-link' => 'Magsimula ng isang bagong seksyon',
	),
	'tr' => array(
		'addnewtalksection-link' => 'Yeni bir bölüm başlat.',
	),
	'tt_cyrl' => array(
		'addnewtalksection-link' => 'Бу фикер алышуда шәрех калдырырга.',
	),
	'tt_latn' => array(
		'addnewtalksection-link' => 'Bu bäxästä yazma östäw.',
	),
	'uk' => array(
		'addnewtalksection-link' => 'Створити новий розділ',
	),
	'uz' => array(
		'addnewtalksection-link' => 'Yangi boʻlim och',
	),
	'val' => array(
		'addnewtalksection-link' => 'Afegir un comentari a esta discussió.',
	),
	'vec' => array(
		'addnewtalksection-link' => 'Intaca na sezion nova',
	),
	'vi' => array(
		'addnewtalksection-link' => 'Bắt đầu một đề mục mới',
	),
	'vo' => array(
		'addnewtalksection-link' => 'Primön dilädi nulik',
	),
	'wa' => array(
		'addnewtalksection-link' => 'Radjouter on comintaire a cisse copene ci.',
	),
	'wo' => array(
		'addnewtalksection-link' => 'Tambali xaaj bu bees',
	),
	'wuu' => array(
		'addnewtalksection-link' => '加个评论到搿个讨论里向',
	),
	'xmf' => array(
		'addnewtalksection-link' => 'ქოგეუძინით კომენტარ თე სხუნუას.',
	),
	'yi' => array(
		'addnewtalksection-link' => 'הייב אן א נייער שמועס אפטיילונג',
	),
	'yo' => array(
		'addnewtalksection-link' => "Ṣ'àríwí sínú ìfọ̀rọ̀wérọ̀.",
	),
	'yue' => array(
		'addnewtalksection-link' => '開始新嘅小節',
	),
	'zh_classical' => array(
		'addnewtalksection-link' => '有言議，添新要',
	),
	'zh_hans' => array(
		'addnewtalksection-link' => '开始一个新小节',
	),
	'zh_hant' => array(
		'addnewtalksection-link' => '開始一個新小節',
	),
	'zh_tw' => array(
		'addnewtalksection-link' => '於本討論頁增加新的討論主題',
	)
);