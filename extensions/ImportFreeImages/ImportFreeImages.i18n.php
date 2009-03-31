<?php
/**
 * Internationalisation file for the ImportFreeImages extension.
 *
 * @file
 * @ingroup Extensions
*/

$messages = array();

/** English
 * @author Travis Derouin
 */
$messages['en'] = array(
	'importfreeimages'                => 'Import free images',
	'importfreeimages-desc'           => 'Provides a way of [[Special:ImportFreeImages|importing properly licensed photos]] from [http://www.flickr.com flickr]',
	'importfreeimages_description'    => 'This page allows you to search properly licensed photos from flickr and import them into your wiki.',
	'importfreeimages_noapikey'       => 'You have not configured your Flickr API Key.
To do so, please obtain a API key from  [http://www.flickr.com/services/api/misc.api_keys.html here] and set wgFlickrAPIKey in ImportFreeImages.php.',
	'importfreeimages_nophotosfound'  => 'No photos were found for your search criteria \'$1\', please try again.',
	'importfreeimages_invalidurl'     => 'The URL "$1" is not a valid Flickr image.',
	'importfreeimages_owner'          => 'Author',
	'importfreeimages_importthis'     => 'import this',
	'importfreeimages_next'           => 'Next $1',
	'importfreeimages_filefromflickr' => '$1 by user <b>[$2]</b> from flickr. Original URL',
	'importfreeimages_promptuserforfilename' => 'Please enter a destination filename:',
	'importfreeimages_returntoform'   => 'Or, click <a href=\'$1\'>here</a> to return to your search results',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Purodha
 */
$messages['qqq'] = array(
	'importfreeimages-desc' => 'Short description of this extension, shown on [[Special:Version]]. Do not translate or change links.',
	'importfreeimages_owner' => '{{Identical|Author}}',
	'importfreeimages_next' => '{{Identical|Next $1}}',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 */
$messages['af'] = array(
	'importfreeimages_owner' => 'Outeur',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'importfreeimages' => 'استيراد صور حرة',
	'importfreeimages-desc' => 'يوفر طريقة [[Special:ImportFreeImages|لاستيراد صور مرخصة بشكل سليم]] من [http://www.flickr.com فليكر]',
	'importfreeimages_description' => 'هذه الصفحة تسمح لك بالبحث في الصور المرخصة جيدا من فليكر واستيرادها إلى الويكي الخاص بك.',
	'importfreeimages_noapikey' => 'لم تقم بضبط مفتاح API فليكر الخاص بك.
لفعل هذا، من فضلك احصل على مفتاح API من  [http://www.flickr.com/services/api/misc.api_keys.html هنا] واضبط wgFlickrAPIKey في ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "لا صور تم العثور عليها لمدخلة البحث الخاصة بك '$1'، من فضلك حاول مرة ثانية.",
	'importfreeimages_invalidurl' => 'المسار "$1" ليس صورة فليكر صحيحة.',
	'importfreeimages_owner' => 'المؤلف',
	'importfreeimages_importthis' => 'استورد هذا',
	'importfreeimages_next' => '$1 التالي',
	'importfreeimages_filefromflickr' => '$1 بواسطة المستخدم <b>[$2]</b> من فليكر. المسار الأصلي',
	'importfreeimages_promptuserforfilename' => 'من فضلك أدخل اسما لتخزين الملف به:',
	'importfreeimages_returntoform' => "أو، اضغط <a href='$1'>هنا</a> للعودة إلى نتائج بحثك",
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'importfreeimages' => 'استيراد صور حرة',
	'importfreeimages-desc' => 'يوفر طريقة [[Special:ImportFreeImages|لاستيراد صور مرخصة بشكل سليم]] من [http://www.flickr.com فليكر]',
	'importfreeimages_description' => 'هذه الصفحة تسمح لك بالبحث فى الصور المرخصة جيدا من فليكر واستيرادها إلى الويكى الخاص بك.',
	'importfreeimages_noapikey' => 'لم تقم بضبط مفتاح API فليكر الخاص بك.
لفعل هذا، من فضلك احصل على مفتاح API من  [http://www.flickr.com/services/api/misc.api_keys.html هنا] واضبط wgFlickrAPIKey فى ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "لا صور تم العثور عليها لمدخلة البحث الخاصة بك '$1'، من فضلك حاول مرة ثانية.",
	'importfreeimages_invalidurl' => 'المسار "$1" ليس صورة فليكر صحيحة.',
	'importfreeimages_owner' => 'المؤلف',
	'importfreeimages_importthis' => 'استورد هذا',
	'importfreeimages_next' => '$1 التالي',
	'importfreeimages_filefromflickr' => '$1 بواسطة المستخدم <b>[$2]</b> من فليكر. المسار الأصلي',
	'importfreeimages_promptuserforfilename' => 'من فضلك أدخل اسما لتخزين الملف به:',
	'importfreeimages_returntoform' => "أو، اضغط <a href='$1'>هنا</a> للعودة إلى نتائج بحثك",
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'importfreeimages' => 'Внасяне на свободни картинки',
	'importfreeimages-desc' => 'Позволява [[Special:ImportFreeImages|внасянето на подходящо лицензирани картинки]] от [http://www.flickr.com flickr].',
	'importfreeimages_description' => 'Тази страница позволява търсенето на подходящо лицензирани картинки от flickr и качването им в уикито.',
	'importfreeimages_noapikey' => 'Не е конфигуриран Flickr API ключ. Такъв API ключ може да се получи [http://www.flickr.com/services/api/misc.api_keys.html оттук], след което е необходимо да се настрои wgFlickrAPIKey в ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Не бяха открити резултати за търсенето ви по критерия '$1'. Моля, опитайте отново.",
	'importfreeimages_invalidurl' => 'Адресът „$1“ не е валидна картинка във Flickr.',
	'importfreeimages_owner' => 'Автор',
	'importfreeimages_next' => 'Следващи $1',
	'importfreeimages_filefromflickr' => '$1 от потребител <b>[$2]</b> от flickr. Оригинален адрес',
	'importfreeimages_promptuserforfilename' => 'Моля, въведете целево име на файла:',
	'importfreeimages_returntoform' => "Или щракнете <a href='$1'>тук</a> за да се върнете към резултати от търсенето си",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'importfreeimages_owner' => 'Autor',
);

/** Catalan (Català)
 * @author Toniher
 */
$messages['ca'] = array(
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importa-ho',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'importfreeimages' => 'Importovat svobodné obrázky',
	'importfreeimages-desc' => 'Umožňuje [[Special:ImportFreeImages|imprtování obrázků se správnou licencí]] z [http://www.flickr.com Flickru]',
	'importfreeimages_description' => 'Tato stránka vám umožní importovat správně licencované obrázky z Flickru na vaši wiki',
	'importfreeimages_noapikey' => 'Nenastavili jste API klíč Flickru. Uděláte tak po získání API klíče [http://www.flickr.com/services/api/misc.api_keys.html odtud] a nastavením proměnné <tt>$wgFlickrAPIKey</tt> v ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Nebyly nalezeny žádné obrázky odpovídající vašim kritériím „$1“. Prosím, zkuste to znovu.',
	'importfreeimages_invalidurl' => '„$1“ není platný obrázek na Flickru.',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importovat toto',
	'importfreeimages_next' => 'Dalších $1',
	'importfreeimages_filefromflickr' => '$1 od uživatele <b>[$2]</b> z Flickru. Původní URL',
	'importfreeimages_promptuserforfilename' => 'Prosím, zadejte název cílového souboru:',
	'importfreeimages_returntoform' => "Nebo se vraťte na <a href='$1'>výsledky vašeho vyhledávání</a>",
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'importfreeimages_owner' => 'творь́ць',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'importfreeimages_next' => 'Næste $1',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'importfreeimages' => 'Import freier Bilder',
	'importfreeimages-desc' => 'Ermöglicht den [[Special:ImportFreeImages|Import freier Bilder]] von [http://www.flickr.com Flickr]',
	'importfreeimages_description' => 'Diese Seite erlaubt dir, in Flickr nach Bildern unter einer freien Lizenz zu suchen und diese in dein Wiki zu importieren.',
	'importfreeimages_noapikey' => 'Du hast noch keinen Flickr-API-Schlüssel konfiguriert. Bitte beantrage ihn [http://www.flickr.com/services/api/misc.api_keys.html hier] und setze ihn in $wgFlickrAPIKey in ImportFreeImages.php ein.',
	'importfreeimages_nophotosfound' => 'Es wurden keine Fotos mit den Suchkriterien „$1“ gefunden.',
	'importfreeimages_invalidurl' => 'Die URL „$1“ ist kein gültiges Flickr-Bild.',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importieren',
	'importfreeimages_next' => 'Nächste $1',
	'importfreeimages_filefromflickr' => '$1 von Benutzer <b>[$2]</b> von flickr. Original URL',
	'importfreeimages_promptuserforfilename' => 'Bitte gebe einen Ziel-Dateinamen ein:',
	'importfreeimages_returntoform' => "Oder klicke <a href='$1'>hier</a>, um zu der Seite mit den Suchergebnissen zurückzukommen.",
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Raimond Spekking
 */
$messages['de-formal'] = array(
	'importfreeimages_description' => 'Diese Seite erlaubt Ihnen, in Flickr nach Bildern unter einer freien Lizenz zu suchen und diese in Ihr Wiki zu importieren.',
	'importfreeimages_noapikey' => 'Sie haben noch keinen Flickr-API-Schlüssel konfiguriert. Bitte beantragen Sie ihn [http://www.flickr.com/services/api/misc.api_keys.html hier] und setzen Sie ihn in $wgFlickrAPIKey in ImportFreeImages.php ein.',
	'importfreeimages_promptuserforfilename' => 'Bitte geben Sie einen Ziel-Dateinamen ein:',
	'importfreeimages_returntoform' => "Oder klicken Sie <a href='$1'>hier</a>, um zu der Seite mit den Suchergebnissen zurückzukommen.",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'importfreeimages' => 'Liche wobraze importěrowaś',
	'importfreeimages-desc' => 'Zmóžnja [[Special:ImportFreeImages|import pórědnje licencěrowanych fotow]] z [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Toś ten bok śi zmóžnja, na Flickrje pórědnje licencěrowane fota pytaś a je do twójogo wikija importěrowaś.',
	'importfreeimages_noapikey' => 'Njejsy konfigurěrował swój API-kluc za Flickr.
Aby to cynił, wobstaraj se pšosym API-kluc wót [http://www.flickr.com/services/api/misc.api_keys.html how]',
	'importfreeimages_nophotosfound' => "Za twóje pytańske kriteriumy '$1' njejsu žedne fota namakali, pšosym wopytaj hyšći raz.",
	'importfreeimages_invalidurl' => 'URL "$1" njejo płaśiwy Flickr-wobraz.',
	'importfreeimages_owner' => 'Awtor',
	'importfreeimages_importthis' => 'to importěrowaś',
	'importfreeimages_next' => 'Pśiducy $1',
	'importfreeimages_filefromflickr' => '$1 wót wužywarja <b>[$2]</b> z flickr. Originalny URL',
	'importfreeimages_promptuserforfilename' => 'Pšosym zapódaj mě celowego dataje:',
	'importfreeimages_returntoform' => "Abo klikni < a href='$1'>sem</a>, aby se wróśił k swójim pytańskim wuslědkam",
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'importfreeimages' => 'Importi Senpagajn Bildojn',
	'importfreeimages-desc' => 'Ebligas fojon [[Special:ImportFreeImages|importi ĝuste permesmarkitajn fotojn]] de [http://www.flickr.com Flickr]',
	'importfreeimages_description' => 'Ĉi paĝo ebligas al vi serĉi ĝuste permesmarkitajn fotojn de Flickr kaj importi ilin al vian vikion.',
	'importfreeimages_noapikey' => 'Vi ne konfiguris vian Flickr API-ŝlosilo. Fari tiel, bonvolu akiri API-ŝlosilon de 
[http://www.flickr.com/services/api/misc.api_keys.html ĉi tie] kaj baskuli wgFlickrAPIKey en ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Neniaj fotoj estis trovitaj por via serĉesprimo '$1'; bonvolu reprovi.",
	'importfreeimages_invalidurl' => 'La URL-o "$1" ne estas valida bildo de Flickr.',
	'importfreeimages_owner' => 'Aŭtoro',
	'importfreeimages_importthis' => 'importi ĉi tiun',
	'importfreeimages_next' => 'Sekvaj $1',
	'importfreeimages_filefromflickr' => '$1 de uzanto <b>[$2]</b> de Flickr. Originala URL-o',
	'importfreeimages_promptuserforfilename' => 'Bonvolu enigi celan dosiernomon:',
	'importfreeimages_returntoform' => "Aŭ, klaku <a href='$1'>ĉi tien</a> reveni al viaj serĉrezultoj.",
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'importfreeimages_owner' => 'Autor',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'importfreeimages' => 'وارد کردن تصاویر آزاد',
	'importfreeimages-desc' => 'راهی برای [[Special:ImportFreeImages|وارد کردن تصاویر با اجازه‌نامهٔ مناسب]] از [http://www.flickr.com فلیکر] فراهم می‌آورد',
	'importfreeimages_description' => 'این صفحه به شما اجازه می‌دهد که در فلیکر به دنبال تصاویر با اجازه‌نامهٔ مناسب بگردید و آن‌ها را در ویکی خود وارد کنید.',
	'importfreeimages_noapikey' => 'شما کلید API فلیکر خود را تنظیم نکرده‌اید.
برای این کار، لطفاً یک کلید از [http://www.flickr.com/services/api/misc.api_keys.html این‌جا] دریافت کنید و wgFlickrAPIKey را در ImportFreeImages.php تنظیم کنید.',
	'importfreeimages_nophotosfound' => "صفحه‌ای برای عبارت جستجوی شما ('$1') پیدا نشد، لطفاً دوباره تلاش کنید.",
	'importfreeimages_invalidurl' => 'نشانی اینترنتی «$1» یک تصویر مجاز فلیکر نیست.',
	'importfreeimages_owner' => 'خالق',
	'importfreeimages_importthis' => 'این را وارد کن',
	'importfreeimages_next' => '$1 بعدی',
	'importfreeimages_filefromflickr' => '$1 توسط کاربر <b>[$2]</b> از فلیکر. نشانی اینترنتی اصلی',
	'importfreeimages_promptuserforfilename' => 'لطفاً یک نام مقصد برای پرونده وارد کنید:',
	'importfreeimages_returntoform' => "یا <a href='$1'>این‌جا</a> کلیک کنید تا به نتایج جستجوی خود باز گردید",
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'importfreeimages' => 'Tuo vapaita kuvia',
	'importfreeimages-desc' => 'Mahdollistaa [[Special:ImportFreeImages|sopivasti lisensoitujen valokuvien tuonnin]] [http://www.flickr.com Flickristä].',
	'importfreeimages_description' => 'Tämän sivun kautta pystyt etsimään asianomaisesti lisensoituja kuvia flickr:sta ja tuomaan niitä wikiisi.',
	'importfreeimages_noapikey' => 'Et ole asettanut Flickr API-avaintasi.
Tehdäksesi niin, hanki API-avain [http://www.flickr.com/services/api/misc.api_keys.html täältä] ja aseta wgFlickrAPIKey ImportFreeImages.php-tiedostossa.',
	'importfreeimages_nophotosfound' => "Mitkään valokuvat eivät täsmänneet hakukriteeriisi '$1', ole hyvä ja koita uudestaan.",
	'importfreeimages_invalidurl' => 'URL "$1" ei ole kelvollinen Flickr-kuva.',
	'importfreeimages_owner' => 'Tekijä',
	'importfreeimages_importthis' => 'tuo tämä',
	'importfreeimages_next' => 'Seuraavat $1',
	'importfreeimages_filefromflickr' => '$1 käyttäjän <b>[$2]</b> toimesta flickr:sta. Alkuperäinen URL',
	'importfreeimages_promptuserforfilename' => 'Ole hyvä ja anna kohdenimi:',
	'importfreeimages_returntoform' => "Tai napsauta <a href='$1'>tästä</a> palataksesi hakusi tuloksiin",
);

/** French (Français)
 * @author Grondin
 * @author Urhixidur
 */
$messages['fr'] = array(
	'importfreeimages' => 'Importer des Images Libres',
	'importfreeimages-desc' => 'Fournit un moyen d’importer des photographies sous licence appropriée depuis flickr.',
	'importfreeimages_description' => 'Cette page vous permet de rechercher des images sous licences appropriées depuis flickr et de les importer dans votre wiki.',
	'importfreeimages_noapikey' => 'Vous n’avez pas configuré votre Clef API Flickr. Pour ce faire, vous êtes prié d’obtenir une clef API à partir de [http://www.flickr.com/services/api/misc.api_keys.html ce lien] et de configurer wgFlickrAPIKey dans ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Aucune photo n’a été trouvée à partir de vos critères de recherches  '$1', veuillez essayer à nouveau.",
	'importfreeimages_invalidurl' => "L'adresse « $1 » n’est pas une image Flickr correcte.",
	'importfreeimages_owner' => 'Auteur',
	'importfreeimages_importthis' => 'l’importer',
	'importfreeimages_next' => ' $1 suivants',
	'importfreeimages_filefromflickr' => '$1 par l’utilisateur <b>[$2]</b> depuis flickr. URL d’origine',
	'importfreeimages_promptuserforfilename' => 'Veuillez indiquer le nom du fichier de destination :',
	'importfreeimages_returntoform' => "ou, cliquez <a href='$1'>ici</a> pour revenir à votre liste de résultats.",
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'importfreeimages_owner' => 'Auteur',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'importfreeimages' => 'Importar imaxes libres',
	'importfreeimages-desc' => 'Proporciona unha ruta para [[Special:ImportFreeImages|importar adecuadamente fotografías con licenza]] dende o [http://www.flickr.com Flickr]',
	'importfreeimages_description' => 'Esta páxina permítelle procurar fotos de flickr con licenza correcta e importalos ao seu wiki.',
	'importfreeimages_noapikey' => 'Non configurou a súa clave Flickr API.
Para facelo, por favor, obteña a clave API [http://www.flickr.com/services/api/misc.api_keys.html aquí] e fixe wgFlickrAPIKey en ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Ningunhas fotos foron atopadas cos criterios '$1' de procura, ténteo de novo.",
	'importfreeimages_invalidurl' => 'A URL "$1" non é unha imaxe válida de Flickr',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importar isto',
	'importfreeimages_next' => 'Seguinte $1',
	'importfreeimages_filefromflickr' => '$1 polo usuario <b>[$2]</b> de flickr. Orixinal URL',
	'importfreeimages_promptuserforfilename' => 'Introduza un nome de ficheiro de destino:',
	'importfreeimages_returntoform' => "Ou prema <a href='$1'>aquí</a> para voltar á súa procura de resultados",
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'importfreeimages_owner' => 'Δημιουργός',
	'importfreeimages_importthis' => 'τόδε εἰσάγειν',
	'importfreeimages_next' => 'Ἑπόμεναι $1',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'importfreeimages_owner' => 'Ughtar',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'importfreeimages' => 'ייבוא תמונות חופשיות',
	'importfreeimages-desc' => 'אפשרות ל[[Special:ImportFreeImages|ייבוא תמונות בעלות רשיון מתאים]] מ־[http://www.flickr.com Flickr]',
	'importfreeimages_description' => 'דף זה מאפשר לכם לחפש תמונות בעלות רשיון מתאים מ־Flickr ולייבא אותן אל הוויקי שלכם.',
	'importfreeimages_noapikey' => 'לא הוגדר מפתח ה־API של Flickr.
כדי לעשות זאת, אנא ייבאו את מפתח ה־API מהכתובת [http://www.flickr.com/services/api/misc.api_keys.html הזו] והגדירו את wgFlickrAPIKey בקובץ ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'לא נמצאו תמונות לפי קריטריון החיפוש "$1", אנא נסו שנית.',
	'importfreeimages_invalidurl' => 'הכתובת "$1" אינה תמונה תקינה של Flickr.',
	'importfreeimages_owner' => 'יוצר',
	'importfreeimages_importthis' => 'ייבוא תמונה זו',
	'importfreeimages_next' => '$1 הבאות',
	'importfreeimages_filefromflickr' => '$1 על ידי המשתמש <b>[$2]</b> מ־Flickr. כתובת מקורית',
	'importfreeimages_promptuserforfilename' => 'אנא הקלידו את שם קובץ היעד:',
	'importfreeimages_returntoform' => "או, לחצו <a href='$1'>כאן</a> כדי לחזור לתוצאות החיפוש",
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'importfreeimages' => 'मुक्त चित्र आयात करें',
	'importfreeimages_nophotosfound' => "'$1' से मिलने वाले फ़ोटो मिले नहीं, कृपया फिरसे यत्न करें।",
	'importfreeimages_invalidurl' => 'URL "$1" यह वैध फ्लिकर चित्र नहीं हैं।',
	'importfreeimages_owner' => 'लेखक',
	'importfreeimages_importthis' => 'इसे आयात करें',
	'importfreeimages_next' => 'अगले $1',
	'importfreeimages_filefromflickr' => 'फ्लिकर से $1 <b>[$2]</b> सदस्यने दिया हुआ। मूल URL',
	'importfreeimages_promptuserforfilename' => 'कॄपया लक्ष्य फ़ाईलनाम दें:',
	'importfreeimages_returntoform' => "या फिर, आपके खोज रिज़ल्टपर वापिस जाने के लिये <a href='$1'>यहां</a> क्लिक करें",
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'importfreeimages' => 'Uvezi slobodne slike',
	'importfreeimages-desc' => 'Omogućava [[Special:ImportFreeImages|uvoženje pravilno licenciranih fotografija]] iz [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Ova stranica vam omogućava traženje pravilno licenciranih fotografija na flickr-u i njihovo uvoženje na wiki.',
	'importfreeimages_noapikey' => 'Niste konfigurirali svoj Flickr API ključ.
Da biste to napravili, potražite API ključ [http://www.flickr.com/services/api/misc.api_keys.html ovdje] i postavite wgFlickrAPIKey u ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Za vaš traženi pojam '$1' nije pronađena ni jedna fotografija, molimo pokušajte ponovo.",
	'importfreeimages_invalidurl' => "URL '$1' nije valjana Flickr slika.",
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'uvezi ovo',
	'importfreeimages_next' => 'Slijedeće $1',
	'importfreeimages_filefromflickr' => '$1 suradnika <b>[$2]</b> iz flickr. Originalni URL',
	'importfreeimages_promptuserforfilename' => 'Molimo upišite naziv odredišne datoteke:',
	'importfreeimages_returntoform' => "Ili, kliknite <a href='$1'>ovdje</a> za povratak na rezultate pretrage",
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'importfreeimages' => 'Swobodne wobrazy importować',
	'importfreeimages-desc' => 'Zmóžnja [[Special:ImportFreeImages|import wobrazow z prawej licencu]] z [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Tuta strona ći dowola na Flickr za wobrazami z prihódnej ličencu pytać a je do swojeho wiki importować.',
	'importfreeimages_noapikey' => 'Njejsy swój kluč Flickr API konfigurował. Prošu požadaj jón [http://www.flickr.com/services/api/misc.api_keys.html jowle] a nastaj $wgFlickrAPIKey w ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Njejsu so žane fota za twoje pytanske kriterije "$1" namakali.',
	'importfreeimages_invalidurl' => 'URL "$1" płaćiwy wobraz Flickr njeje.',
	'importfreeimages_owner' => 'Awtor',
	'importfreeimages_importthis' => 'importować',
	'importfreeimages_next' => 'Přichodny $1',
	'importfreeimages_filefromflickr' => '$1 wot wužiwarja <b>[$2]</b> z flickra. Originalny URL',
	'importfreeimages_promptuserforfilename' => 'Prošu zapodaj mjeno ciloweje dataje:',
	'importfreeimages_returntoform' => "Abo klikń <a href='$1'>sem</a>, zo by k stronje z pytanskimi wuslědkami wróćił.",
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'importfreeimages' => 'Szabad képek importálása',
	'importfreeimages-desc' => 'Lehetővé teszi a [[Special:ImportFreeImages|megfelelően licencelt képek importálását]] a [http://www.flickr.com flickr-ről]',
	'importfreeimages_description' => 'Ez az oldal lehetővé teszi számodra megfelelően licencelt flickr képek keresését és importálását a wikidbe.',
	'importfreeimages_noapikey' => 'Nem állítottad be a Flickr API kulcsodat. Ahhoz, hogy ezt megtedd, kérj egy API kulcsot
[http://www.flickr.com/services/api/misc.api_keys.html innen], majd állítsd be a wgFlickrAPIKey értékét a ImportFreeImages.php-ben.',
	'importfreeimages_nophotosfound' => 'Nem találtam a keresési feltételeidnek ($1) megfelelő képet, próbáld újra.',
	'importfreeimages_invalidurl' => 'A megadott URL „$1” nem egy érvényes Flickr-kép címe.',
	'importfreeimages_owner' => 'Szerző',
	'importfreeimages_importthis' => 'importálás',
	'importfreeimages_next' => 'Következő $1',
	'importfreeimages_filefromflickr' => '$1 <b>[$2]</b> felhasználótól a flickr-ről. Eredeti URL',
	'importfreeimages_promptuserforfilename' => 'Add meg a cél fájlnevet:',
	'importfreeimages_returntoform' => "Vagy kattints <a href='$1'>ide</a>, hogy visszatérj az eredmények listájához",
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'importfreeimages' => 'Importar imagines libere',
	'importfreeimages-desc' => 'Forni un modo de [[Special:ImportFreeImages|importar photos propriemente licentiate]] ab [http://www.flickr.com Flickr]',
	'importfreeimages_description' => 'Iste pagina permitte cercar photos propriemente licentiate in Flickr e importar los in tu wiki.',
	'importfreeimages_noapikey' => 'Tu non ha configurate tu clave API de Flickr.
Pro facer isto, per favor obtene un clave API ab [http://www.flickr.com/services/api/misc.api_keys.html iste pagina] e defini wgFlickrAPIKey in ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Nulle photo corresponde a tu criterios de recerca '$1'. Per favor reprova.",
	'importfreeimages_invalidurl' => 'Le adresse URL "$1" non corresponde a un imagine de Flickr valide.',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importar isto',
	'importfreeimages_next' => '$1 {{PLURAL:$1|sequente|sequentes}}',
	'importfreeimages_filefromflickr' => '$1 per le usator <b>[$2]</b> ab Flickr. Adresse URL original',
	'importfreeimages_promptuserforfilename' => 'Per favor entra le nomine del file de destination:',
	'importfreeimages_returntoform' => "O clicca <a href='$1'>hic</a> pro retornar al resultatos del recerca",
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'importfreeimages' => 'Impor gambar bebas',
	'importfreeimages-desc' => 'Menambahkan halaman istimewa untuk [[Special:ImportFreeImages|mengimpor foto-foto dengan lisensi yang benar]] dari [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Halaman ini mengizinkan Anda untuk mencari foto-foto dengan lisensi yang benar dan mengimpornya ke wiki Anda.',
	'importfreeimages_noapikey' => 'Anda belum mengkonfigurasi Kunci API Flickr Anda.
Untuk melakukannya, Anda harus mendapatkan sebuah kunci API dari [http://www.flickr.com/services/api/misc.api_keys.html sini] dan mengeset wgFlickrAPIKey di ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Tidak ditemukan foto yang memenuhi kriteria pencarian '$1', silakan coba lagi.",
	'importfreeimages_invalidurl' => 'URL "$1" bukanlah gambar Flickr yang valid.',
	'importfreeimages_owner' => 'Pembuat',
	'importfreeimages_importthis' => 'impor',
	'importfreeimages_next' => 'Berikutnya $1',
	'importfreeimages_filefromflickr' => '$1 oleh pengguna <b>[$2]</b> dari flickr. URL asli',
	'importfreeimages_promptuserforfilename' => 'Harap masukkan nama berkas tujuan:',
	'importfreeimages_returntoform' => "Atau, klik <a href='$1'>di sini</a> untuk kembali ke hasil pencarian Anda",
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'importfreeimages' => 'Importa immagini libere',
	'importfreeimages-desc' => 'Fornisce un modo per [[Special:ImportFreeImages|importare foto con la giusta licenza]] da [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Questa pagina ti permette di cercare immagini con la giusta licenza su flickr e importarle sulla tua wiki.',
	'importfreeimages_noapikey' => 'Non hai configurato la tua chiave API Flickr.
Per farlo richiedi una chiave API [http://www.flickr.com/services/api/misc.api_keys.html qui] e imposta wgFlickrAPIKey in ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Nessuna foto soddisfa il criterio di ricerca '$1', prova di nuovo.",
	'importfreeimages_invalidurl' => 'L\'URL "$1" non corrisponde a un\'immagine di Flickr valida.',
	'importfreeimages_owner' => 'Autore',
	'importfreeimages_importthis' => 'importa questo',
	'importfreeimages_next' => 'Successivi $1',
	'importfreeimages_filefromflickr' => "$1 dall'utente <b>[$2]</b> da flickr. URL originale",
	'importfreeimages_promptuserforfilename' => 'Inserisci un nome per il file di destinazione:',
	'importfreeimages_returntoform' => "Oppure fai clic <a href='$1'>qui</a> per tornare ai risultati della tua ricerca",
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'importfreeimages_owner' => '著者',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'importfreeimages' => 'Impor Gambar-Gambar Bébas',
	'importfreeimages_invalidurl' => 'URL "$1" iku dudu gambar Flickr sing absah.',
	'importfreeimages_owner' => 'Pangripta',
	'importfreeimages_importthis' => 'impor iki',
	'importfreeimages_promptuserforfilename' => 'Tulung lebokna jeneng berkas tujuan:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'importfreeimages' => 'នាំចូល រូបភាព សេរី',
	'importfreeimages-desc' => 'ផ្ដល់នូវរបៀបមួយក្នុងការ[[Special:ImportFreeImages|នាំចូលរូបភាពដែលមានអាជ្ញាប័ណ្ណត្រឹមត្រូវ]] ពី [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'ទំព័រនេះផ្ដល់លទ្ឋភាពឱ្យអ្នកស្វែងរករូបភាពដែលមានអាជ្ញាប័ណ្ណត្រឹមត្រូវពី flickr ហើយនាំចូលពូកវាមកក្នុងវិគីរបស់អ្នក។',
	'importfreeimages_noapikey' => 'អ្នកមិនបាន​ធ្វើទម្រង់​សោ Flickr API របស់អ្នក​។ ដើម្បីធ្វើវា, ត្រូវយក​សោ​ API ពី [http://www.flickr.com/services/api/misc.api_keys.html here] រួច​កំណត់​ wgFlickrAPIKey ក្នុង ImportFreeImages.php ។',
	'importfreeimages_invalidurl' => 'URL "$1" មិនមែនជា​រូបភាព​ត្រឹមត្រូវ​របស់ Flickr ។',
	'importfreeimages_owner' => 'អ្នកនិពន្ធ',
	'importfreeimages_importthis' => 'នាំចូល នេះ',
	'importfreeimages_next' => 'បន្ទាប់ $1',
	'importfreeimages_filefromflickr' => '$1 ដោយអ្នកប្រើប្រាស់ <b>[$2]</b> ពី flickr។ URL ដើម',
	'importfreeimages_promptuserforfilename' => 'សូមបញ្ចូល ឈ្មោះឯកសារ គោលដៅ ៖',
	'importfreeimages_returntoform' => "ឬក៏ចុច<a href='$1'>ទីនេះ</a>ដើម្បីត្រឡប់ទៅកាន់លទ្ឋផលស្វែងរករបស់អ្នក",
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'importfreeimages_noapikey' => '당신은 당신의 Flickr API 키를 설정하지 않았습니다.
계속하시려면 [http://www.flickr.com/services/api/misc.api_keys.html 이곳]에서 API 키를 다운로드하고 ImportFreeImages.php에 wgFlickrAPIKey를 설정하십시오.',
	'importfreeimages_invalidurl' => 'URL "$1"은 유효한 Flickr 그림이 아닙니다.',
	'importfreeimages_owner' => '만든이',
	'importfreeimages_importthis' => '이 그림 가져오기',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'importfreeimages' => 'Frei Belder Empotteere',
	'importfreeimages-desc' => '[[Special:ImportFreeImages|Frei Belder Empotteere]] fun [http://www.flickr.com Flickr]',
	'importfreeimages_description' => "Hee di Sigg määt et müjjelesch, de Bellder met zopass Lizenze fun ''flickr'' tirek in dat Wiki hee ze empotteere.",
	'importfreeimages_noapikey' => "Et es noch keine ''flickr''-API-Schlößel enshtalleet.
[http://www.flickr.com/services/api/misc.api_keys.html Jangk Der eine holle],
un dann donn <code>\$wgFlickrAPIKey</code>
en <code>ImportFreeImages.php</code> udder
en <code>LocalSettings.php</code> setze.",
	'importfreeimages_nophotosfound' => "Kei Fottos jefonge beim Söke noh '$1', do donn et norr_ens versöke.",
	'importfreeimages_invalidurl' => "Dä URL „$1“ jeit nit op e reschtesch ''flickr'' Beld.",
	'importfreeimages_owner' => 'Dä Maacher',
	'importfreeimages_importthis' => 'Donn et empotteere!',
	'importfreeimages_next' => 'Näx $1',
	'importfreeimages_filefromflickr' => "$1 vum ''flickr''-Metmaacher <b>[$2]</b> — der ojinaal-URL es—",
	'importfreeimages_promptuserforfilename' => 'Bes esu joot, un jif ene Dateiname aan, för dat Beld do dronger afzeschpeischere:',
	'importfreeimages_returntoform' => 'udder <a href="$1">jangk zerök op di Sigg met dä jefonge Bellder</a>.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'importfreeimages' => 'Fräi Biller importéieren',
	'importfreeimages-desc' => "Erméiglecht et fir [[Special:ImportFreeImages|ordentlich lizenzéiert Fotoen]] vu [http://www.flickr.com flickr] z'importéieren",
	'importfreeimages_description' => "Dës Säit erlaabt iech et fir no uerdentlech lizenzéierte Biller vu flickr ze sichen an dës an är Wiki z'importéieren.",
	'importfreeimages_nophotosfound' => "Et goufe keng Photoen no ärer Sich '$1' fonnt, versicht et w.e.g. nach eng Kéier.",
	'importfreeimages_invalidurl' => 'D\'URL "$1" ass kee gëltegt Flickr-Bild.',
	'importfreeimages_owner' => 'Auteur:',
	'importfreeimages_importthis' => 'importéieren',
	'importfreeimages_next' => 'Nächst $1',
	'importfreeimages_filefromflickr' => '$1 vum Benotzer <b>[$2]</b> vun flickr. Original URL',
	'importfreeimages_promptuserforfilename' => 'Gitt w.e.g een Numm fir den neie fichier un:',
	'importfreeimages_returntoform' => "oder, klickt <a href='$1'>heihinn</a> fir op d'Resultat vun ärer Sich zréckzegoen",
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'importfreeimages' => 'സൗജന്യ ചിത്രങ്ങള്‍ ഇറക്കുമതി ചെയ്യുക',
	'importfreeimages_nophotosfound' => "'$1' എന്ന തിരച്ചില്‍ ക്രൈറ്റീയ ഉപയോഗിച്ച് ചിത്രങ്ങള്‍ ഒന്നും കണ്ടെത്താന്‍ കഴിഞ്ഞില്ല. ഒന്നു കൂടി ശ്രമിക്കൂ.",
	'importfreeimages_invalidurl' => '"$1" എന്ന URL സാധുവായ ഒരു ഫ്ലിക്കര്‍ ചിത്രം അല്ല.',
	'importfreeimages_owner' => 'ലേഖകന്‍',
	'importfreeimages_importthis' => 'ഇതു ഇറക്കുമതി ചെയ്യുക',
	'importfreeimages_next' => 'അടുത്ത $1',
	'importfreeimages_filefromflickr' => '<b>[$2]</b> എന്ന ഉപയോക്താവിന്റെ  ഫ്ലിക്കറില്‍ നിന്നുള്ള $1. ചിത്രത്തിലേക്കുള്ള URL',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'importfreeimages' => 'मुक्त चित्रे मागवा',
	'importfreeimages-desc' => '[http://www.flickr.com फ्लिकर] वरील [[Special:ImportFreeImages|मुक्त चित्रे मागविण्याचा]] मार्ग',
	'importfreeimages_description' => 'हे पान आपल्याला फ्लिकर वरील मुक्त चित्रे मागविण्याची तसेच त्यांना तुमच्या विकिमध्ये चढविण्याची सुविधा देते.',
	'importfreeimages_noapikey' => 'तुम्ही तुमची फ्लिकर API चावी बनविलेली नाही. तसे करण्यासाठी, [http://www.flickr.com/services/api/misc.api_keys.html इथून] एक API चावी मागवा व ImportFreeImages.php मध्ये wgFlickrAPIKey टाका.',
	'importfreeimages_nophotosfound' => "'$1' ला जुळणारी छायाचित्रे सापडली नाहीत, कृपया पुन्हा प्रयत्न करा.",
	'importfreeimages_invalidurl' => 'URL "$1" ही योग्य फ्लिकर चित्र नाही.',
	'importfreeimages_owner' => 'लेखक',
	'importfreeimages_importthis' => 'हे घ्या',
	'importfreeimages_next' => 'पुढील $1',
	'importfreeimages_filefromflickr' => 'फ्लिकर कडून $1 <b>[$2]</b> सदस्याने दिलेले. मूळ URL',
	'importfreeimages_promptuserforfilename' => 'कॄपया लक्ष्य संचिकानाव द्या:',
	'importfreeimages_returntoform' => "किंवा, तुमच्या शोध निकालांकडे परत जाण्यासाठी <a href='$1'>इथे</a> टिचकी द्या",
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'importfreeimages' => 'Import imej bebas',
	'importfreeimages-desc' => 'Membekalkan laluan untuk [[Special:ImportFreeImages|mengimport gambar dengan lesen yang sewajarnya]] dari [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Laman ini membolehkan anda mencari gambar dengan lesen yang sewajarnya dari flickr dan mengimportnya ke dalam wiki ini.',
	'importfreeimages_noapikey' => 'Anda belum menetapkan Kekunci API Flickr anda. Untuk melakukan sedemikian, sila dapatkan sebuah kekunci API dari [http://www.flickr.com/services/api/misc.api_keys.html sini] dan tetapkan nilai wgFlickrAPIKey dalam ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Tiada gambar yang sepadan dengan kriteria '$1'. Sila cuba lagi.",
	'importfreeimages_invalidurl' => 'URL "$1" bukan imej Flickr yang sah.',
	'importfreeimages_owner' => 'Pemilik',
	'importfreeimages_importthis' => 'import ini',
	'importfreeimages_next' => '$1 berikutnya',
	'importfreeimages_filefromflickr' => '$1 oleh pengguna <b>[$2]</b> dari flickr. URL asal',
	'importfreeimages_promptuserforfilename' => 'Sila masukkan nama fail sasaran:',
	'importfreeimages_returntoform' => "Atau klik <a href='$1'>di sini</a> untuk kembali ke keputusan carian anda",
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'importfreeimages_next' => '$1 li jmiss',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'importfreeimages_owner' => 'Теицязо',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'importfreeimages' => 'Tiquincōhuāz yōllōxoxouhqui īxiptli',
	'importfreeimages-desc' => 'Tihuelīti tiquincōhua [[Special:ImportFreeImages|ōnahuatīli īxiptli]] īhuīcpa [http://www.flickr.com flickr].',
	'importfreeimages_description' => 'Tihuelīti inīn zāzanilca tiquincōhua īxiptli īhuīcpa flickr īhuīc mohuiqui.',
	'importfreeimages_owner' => 'Chīhualōni',
	'importfreeimages_importthis' => 'tiquicōhuāz inīn',
	'importfreeimages_next' => 'Niman $1',
	'importfreeimages_promptuserforfilename' => 'Timitztlātlauhtia xiquihcuiloa cē tōcāitl:',
	'importfreeimages_returntoform' => "Nozo, xiclica <a href='$1'>nicān</a>; ticcuepāz tlatēmoalizhuīc",
);

/** Nedersaksisch (Nedersaksisch) */
$messages['nds-nl'] = array(
	'importfreeimages_next' => 'Volgende $1',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'importfreeimages' => 'Vrije afbeeldingen importeren',
	'importfreeimages-desc' => 'Maakt het mogelijk om [[Special:ImportFreeImages|correct gelicenseerde afbeeldingen]] van [http://www.flickr.com  Flickr] te importeren',
	'importfreeimages_description' => "Deze pagina laat u toe om juist gelicenseerde foto's van flickr te zoeken and die te importeren naar uw wiki.",
	'importfreeimages_noapikey' => 'U hebt geen Flickr API Key ingesteld.
U kunt een API-sleutel [http://www.flickr.com/services/api/misc.api_keys.html hier] verkrijgen en instellen als wgFlickrAPIKey in ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Er zijn geen foto's gevonden voor uw zoekcriteria '$1', probeer opniew.",
	'importfreeimages_invalidurl' => 'De URL "$1" is geen geldige afbeelding op Flickr.',
	'importfreeimages_owner' => 'Auteur',
	'importfreeimages_importthis' => 'dit importeren',
	'importfreeimages_next' => 'Volgende $1',
	'importfreeimages_filefromflickr' => '$1 door gebruiker <b>[$2]</b> van flickr. Oorspronkelijke URL',
	'importfreeimages_promptuserforfilename' => 'Gelieve een bestandsnaam op te geven:',
	'importfreeimages_returntoform' => "Of, klik <a href='$1'>hier</a> om terug te keren naar uw zoekresultaten",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'importfreeimages' => 'Importer frie bilete',
	'importfreeimages-desc' => 'Gjev høve til å [[Special:ImportFreeImages|importere frie bilete]] frå [http://flickr.com flickr]',
	'importfreeimages_description' => 'Denne sida lar deg søke i bilete med riktig lisens på Flickr og importere dei til wikien din.',
	'importfreeimages_noapikey' => 'Du har ikkje konfigurert API-nøkkelen din for Flickr. For å gjere det må du skaffe ein API-nøkkel [http://www.flickr.com/services/api/misc.api_keys.html frå her] og sette wgFlickrAPIKey i ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Ingen bilete vart funne for søket «$1». Prøv igjen.',
	'importfreeimages_invalidurl' => 'URL-en «$1» er ikkje eit gyldig Flickr-bilete',
	'importfreeimages_owner' => 'Skapar',
	'importfreeimages_importthis' => 'importer',
	'importfreeimages_next' => 'Neste $1',
	'importfreeimages_filefromflickr' => '$1 av brukaren <b>[$2]</b> frå Flickr. Original URL',
	'importfreeimages_promptuserforfilename' => 'Skriv inn eit målnamn for fila:',
	'importfreeimages_returntoform' => 'Eller klikk <a href="$1">her</a> for å gå tilbake til søkeresultata',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'importfreeimages' => 'Imperter frie bilder',
	'importfreeimages-desc' => 'Gir muligheten til å [[Special:ImportFreeImages|importere fri bilder]] fra [http://flickr.com flickr]',
	'importfreeimages_description' => 'Denne siden lar deg søke i bilder med riktig lisens på Flickr og importere dem til wikien din.',
	'importfreeimages_noapikey' => 'Du har ikke konfigurert API-nøkkelen din for Flickr. For å gjøre det må du skaffe en API-nøkkel [http://www.flickr.com/services/api/misc.api_keys.html herfra] og sette wgFlickrAPIKey i ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Ingen bilder ble funnet for søket «$1». Prøv igjen.',
	'importfreeimages_invalidurl' => 'URL-en «$1» er ikke et gyldig Flickr-bilde',
	'importfreeimages_owner' => 'Skaper',
	'importfreeimages_importthis' => 'importer',
	'importfreeimages_next' => 'Neste $1',
	'importfreeimages_filefromflickr' => '$1 av brukeren <b>[$2]</b> fra Flickr. Original URL',
	'importfreeimages_promptuserforfilename' => 'Skriv inn et målnavn for filen:',
	'importfreeimages_returntoform' => 'Elle rklikk <a href="$1">her</a> for å gå tilbake til søkeresultatene',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'importfreeimages_owner' => 'Mongwadi',
	'importfreeimages_next' => 'Latela $1',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'importfreeimages' => "Importar d'Imatges Liures",
	'importfreeimages-desc' => 'Provesís un mejan d’[[Special:ImportFreeImages|importar de fotografias pròpriament jos licéncia]] dempuèi flickr.',
	'importfreeimages_description' => "Aquesta pagina vos permet de recercar propriament d'imatges jos licéncias dempuèi flickr e de los importar dins vòstre wiki.",
	'importfreeimages_noapikey' => "Avètz pas configurat vòstra Clau API Flickr. Per o far, obtengatz una clau API a partir d' [http://www.flickr.com/services/api/misc.api_keys.html aqueste ligam] e configuratz wgFlickrAPIKey dins ImportFreeImages.php.",
	'importfreeimages_nophotosfound' => "Cap de fòto es pas estada trobada a partir de vòstres critèris de recèrcas '$1', ensajatz tornamai.",
	'importfreeimages_invalidurl' => "L'adreça « $1 » es pas un imatge Flickr corrècte.",
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'l’importar',
	'importfreeimages_next' => '$1 seguents',
	'importfreeimages_filefromflickr' => '$1 per l’utilizaire <b>[$2]</b> dempuèi flickr. URL d’origina',
	'importfreeimages_promptuserforfilename' => 'Indicatz lo nom del fichièr de destinacion',
	'importfreeimages_returntoform' => "o, clicatz <a href='$1'>aicí</a> per tornar a vòstra lista de resultats.",
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'importfreeimages_owner' => 'Автор',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'importfreeimages' => 'Import grafik z odpowiednią licencją.',
	'importfreeimages-desc' => 'Umożliwia [[Special:ImportFreeImages|import grafik z odpowiednią licencją]] z [http://www.flickr.com flickra]',
	'importfreeimages_description' => 'Ta strona pozwala na wyszukiwanie na serwisie flickr zdjęć z odpowiednią licencją i na ich import do wiki.',
	'importfreeimages_nophotosfound' => 'Żadne zdjęcie nie zostało odnalezione na podstawie kryterium „$1”. Spróbuj ponownie.',
	'importfreeimages_invalidurl' => 'Adres URL „$1” nie jest prawidłowym odwołaniem do obrazka w serwisie Flickr.',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importuj',
	'importfreeimages_next' => 'Następne $1',
	'importfreeimages_filefromflickr' => '$1 przez użytkownika <b>[$2]</b> z serwisu flickr. Oryginalny adres URL to',
	'importfreeimages_promptuserforfilename' => 'Wprowadź nazwę pliku docelowego',
	'importfreeimages_returntoform' => "Kliknij <a href='$1'>tutaj</a> żeby powrócić do wyników wyszukiwania",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'importfreeimages_owner' => 'ليکوال',
	'importfreeimages_next' => 'راتلونکي $1',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'importfreeimages' => 'Importar Imagens Livres',
	'importfreeimages-desc' => 'Providencia uma forma de [[Special:ImportFreeImages|importar fotografias devidamente licenciadas]] do [http://www.flickr.com flickr].',
	'importfreeimages_description' => 'Esta página permite-lhe procurar fotografias devidamente licenciadas no flickr e importá-las para o seu wiki.',
	'importfreeimages_noapikey' => 'Você não configurou a sua chave de API Flickr. Para o fazer, por favor obtenha uma chave de API [http://www.flickr.com/services/api/misc.api_keys.html aqui] e atribua-a a wgFlickrAPIKey em ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Nenhuma fotografia foi encontrada segundo o seu critério de busca '$1'; por favor, tente de novo.",
	'importfreeimages_invalidurl' => 'A URL "$1" não é uma imagem Flickr válida.',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importar isto',
	'importfreeimages_next' => 'Próximas $1',
	'importfreeimages_filefromflickr' => '$1 pelo utilizador <b>[$2]</b> do flickr. URL original',
	'importfreeimages_promptuserforfilename' => 'Por favor, introduza um nome de ficheiro destino:',
	'importfreeimages_returntoform' => "Ou clique <a href='$1'>aqui</a> para voltar aos resultados da sua pesquisa",
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'importfreeimages_owner' => 'Autor',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'importfreeimages' => 'Импортирование свободных изображений',
	'importfreeimages-desc' => 'Позволяет [[Special:ImportFreeImages|импортировать должным образом лицензированные фотографии]] с [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'С помощью этой страницы вы можете искать должным образом лицензированные фотографии с Flickr и импортировать их в эту вики.',
	'importfreeimages_noapikey' => 'Вы не настроили ваш Flickr API-ключ. Чтобы это сделать, пожалуйста, получите API-ключ [http://www.flickr.com/services/api/misc.api_keys.html здесь] и установите wgFlickrAPIKey в ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Не найдено фотографий по условию «$1», попробуйте ещё раз.',
	'importfreeimages_invalidurl' => 'Адрес «$1» не является допустимым именем изображения с Flickr.',
	'importfreeimages_owner' => 'Автор',
	'importfreeimages_importthis' => 'Импортировать это',
	'importfreeimages_next' => 'Следующие $1',
	'importfreeimages_filefromflickr' => '$1 авторства <b>[$2]</b> с Flickr. Исходный адрес',
	'importfreeimages_promptuserforfilename' => 'Пожалуйста, введите новое имя файла:',
	'importfreeimages_returntoform' => "Или нажмите <a href='$1'>здесь</a>, чтобы вернуться к вашим результатам поиска.",
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'importfreeimages' => 'Metti mmàggini lìbbiri',
	'importfreeimages-desc' => 'Prucura nu modu pi [[Special:ImportFreeImages|mpurtari futugràfìi câ licenza giusta ]] di [http://www.flickr.com flickr]',
	'importfreeimages_description' => "Sta pàggina ti pirmetti di circari mmàggini câ licenza giusta supr'a flickr e mpurtàrili ntâ tò wiki.",
	'importfreeimages_noapikey' => "Non cunfigurasti la tò chiavi API Flickr.
Pi fàrilu addumanna na chiavi [http://www.flickr.com/services/api/misc.api_keys.html ccà] e mposta wgFlickrAPIKey 'n ImportFreeImages.php.",
	'importfreeimages_nophotosfound' => "Nudda futugrafìa suddisfa lu critèriu di circata $1', prova n'àutra vota.",
	'importfreeimages_invalidurl' => 'L\'URL "$1" nun currispunni a na mmàggini di Flickr vàlida.',
	'importfreeimages_owner' => 'Auturi',
	'importfreeimages_importthis' => 'mporta chistu',
	'importfreeimages_next' => 'Succissivi $1',
	'importfreeimages_filefromflickr' => "$1 di l'utenti <b>[$2]</b> di flickr. URL urigginali",
	'importfreeimages_promptuserforfilename' => 'Nzirisci nu nomu pi lu file di distinazzioni:',
	'importfreeimages_returntoform' => "Oppuru fà clic <a href='$1'>ccà</a> pi turnari a li risurtati di la tò circata",
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'importfreeimages' => 'Importovať slobodné obrázky',
	'importfreeimages-desc' => 'Umožňuje [[Special:ImportFreeImages|importovanie obrázkov so správnou licenciou]] z [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Táto stránka vám umožní importovať správne licencované obrázky z flickr a importovať ich na vašu wiki.',
	'importfreeimages_noapikey' => 'Nenakonfigurovali ste kľúč API Flickr. Urobíte tak po získaní kľúča API [http://www.flickr.com/services/api/misc.api_keys.html odtiaľto] a nastavení premennej wgFlickrAPIKey v ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Neboli nájdené žiadne obrázky zodpovedajúce vašim kritériám vyhľadávania „$1“. Prosím, skúste to znova.',
	'importfreeimages_invalidurl' => '„$1“ nie je platný obrázok Flickr.',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importovať toto',
	'importfreeimages_next' => 'Ďalších $1',
	'importfreeimages_filefromflickr' => '$1 od používateľa <b>[$2]</b> z flickr. Pôvodný URL',
	'importfreeimages_promptuserforfilename' => 'prosím, zadajte cieľový názov súboru:',
	'importfreeimages_returntoform' => "Alebo sa vráťte na <a href='$1'>výsledky vášho vyhľadávania</a>",
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'importfreeimages' => 'Import fon fräie Bielden',
	'importfreeimages-desc' => 'Moaket dän [[Special:ImportFreeImages|Import fon fräie Bielden]] muugelk fon [http://www.flickr.com Flickr]',
	'importfreeimages_description' => 'Disse Siede ferlööwet die, ap Flickr ätter Bielden unner ne fräie Lizenz tou säiken un do in dien Wiki tou importierjen.',
	'importfreeimages_noapikey' => 'Du hääst noch naan Flickr-API-Koai konfigurierd. Jädden beandraach him [http://www.flickr.com/services/api/misc.api_keys.html hier] un sät him in $wgFlickrAPIKey in ImportFreeImages.php ien.',
	'importfreeimages_nophotosfound' => 'Der wuuden neen Fotos mäd do Säikkriterien „$1“ fuunen.',
	'importfreeimages_invalidurl' => 'Ju URL "$1" is neen gultige Flickr-Bielde.',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'importierje',
	'importfreeimages_next' => 'Naiste $1',
	'importfreeimages_filefromflickr' => '$1 fon Benutser <b>[$2]</b> fon flickr. Originoal URL',
	'importfreeimages_promptuserforfilename' => 'Reek n Siel-Doatäinoome ien:',
	'importfreeimages_returntoform' => "Of klik <a href='$1'>hier</a>, uum tou ju Siede mäd do Säikresultoate touräächtoukuumen.",
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'importfreeimages' => 'Impor Gambar Bébas',
	'importfreeimages-desc' => 'Muka jalan pikeun [[Special:ImportFreeImages|ngimpor poto-poto]] ti  [http://www.flickr.com flickr] anu lisénsina loyog.',
	'importfreeimages_description' => 'Ieu kaca méré jalan ka anjeun pikeun nyiar poto-poto ti flickr anu lisénsina loyog sarta langsung diimpor ka wiki anjeun.',
	'importfreeimages_noapikey' => 'Anjeun can nyetél konfigurasi Flickr API Key. Mangga nyungkeun heula konci API ti [http://www.flickr.com/services/api/misc.api_keys.html dieu], lajeng sét wgFlickrAPIKey dina ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Euweuh poto nu loyog jeung kriteria '$1', mangga cobian deui.",
	'importfreeimages_owner' => 'Karya',
	'importfreeimages_importthis' => 'impor ieu',
	'importfreeimages_next' => '$1 salajengna',
	'importfreeimages_filefromflickr' => '$1 ku <b>[$2]</b> ti flickr. URL asalna',
	'importfreeimages_promptuserforfilename' => 'Jieun ngaran koropak nu ditujul:',
	'importfreeimages_returntoform' => "Atawa, klik <a href='$1'>di dieu</a> pikeun balik deui ka hasil nyusud",
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Sannab
 */
$messages['sv'] = array(
	'importfreeimages' => 'Importera fria bilder',
	'importfreeimages-desc' => 'Ger möjlighet att [[Special:ImportFreeImages|importera bilder med lämplig licens]] från [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Denna sida låter dig söka efter bilder med riktig licens på Flickr och importera dem till din wiki.',
	'importfreeimages_noapikey' => 'Du har inte konfigurerat din nyckel för Flickrs API. För att göra det måste du skaffa en API-nyckel [http://www.flickr.com/services/api/misc.api_keys.html härifrån] och sätta wgFlickrAPIKey i ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Inga bilder hittades för dina sökkriterier '$1', försök igen.",
	'importfreeimages_invalidurl' => 'URL:en "$1" är inte en giltig Flickr-bild.',
	'importfreeimages_owner' => 'Upphovsman',
	'importfreeimages_importthis' => 'importera',
	'importfreeimages_next' => 'Nästa $1',
	'importfreeimages_filefromflickr' => '$1 av användaren <b>[$2]</b> från Flickr. Orginal URL',
	'importfreeimages_promptuserforfilename' => 'Var god skriv in ett destinationsnamn för filen:',
	'importfreeimages_returntoform' => "Eller klicka <a href='$1'>här</a> för att gå tillbaka till dina sökresultat",
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'importfreeimages_nophotosfound' => "'$1' అనే మీ అన్వేషణా ప్రశ్నకి ఫొటోలు ఏమీ దొరకలేదు, మళ్ళీ ప్రయత్నించండి.",
	'importfreeimages_owner' => 'కృతికర్త',
	'importfreeimages_next' => 'తర్వాతి $1',
	'importfreeimages_promptuserforfilename' => 'గమ్యస్థానపు ఫైలు పేరుని ఇవ్వండి:',
	'importfreeimages_returntoform' => "లేదా, తిరిగి మీ అన్వేషణ ఫలితాలకు వెళ్ళడానికి <a href='$1'>ఇక్కడ</a> నొక్కండి",
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'importfreeimages_owner' => 'Autór',
	'importfreeimages_next' => 'Oinmai $1',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'importfreeimages' => 'Ворид кардани Аксҳои Озод',
	'importfreeimages_owner' => 'Муаллиф',
	'importfreeimages_importthis' => 'инро ворид кунед',
	'importfreeimages_next' => 'Баъдӣ $1',
	'importfreeimages_promptuserforfilename' => 'Лутфан номи парвандаи мақсадро ворид кунед:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'importfreeimages' => 'Mag-angkat ng malalayang mga larawan',
	'importfreeimages-desc' => 'Nagbibigay ng isang paraan ng [[Special:ImportFreeImages|pagaangkat ng mga larawang may tamang paglalagay/pagbibigay ng lisensya]] mula sa [http://www.flickr.com flickr]',
	'importfreeimages_description' => "Nagpapahintulot sa iyo ang pahinang ito upang makapaghanap ng mga litratong nabigyan ng tamang lisensya mula sa ''flickr'' at angkatin ang mga ito papunta sa iyong wiki.",
	'importfreeimages_noapikey' => "Hindi mo pa naiaayos ang iyong Susi na pang-Flickr API (''API key'').
Upang magawa ito, kumuha lamang ng isang susi ng API mula [http://www.flickr.com/services/api/misc.api_keys.html rito] at itakda ang wgFlickrAPIKey sa ImportFreeImages.php.",
	'importfreeimages_nophotosfound' => "Walang mga litratong natagpuan para sa iyong kauriang panghanap na '$1', pakisubok uli.",
	'importfreeimages_invalidurl' => 'Ang URL na "$1" ay isang hindi tanggap na larawan ng Flickr.',
	'importfreeimages_owner' => 'May-akda',
	'importfreeimages_importthis' => 'angkatin ito',
	'importfreeimages_next' => 'Susunod na $1',
	'importfreeimages_filefromflickr' => '$1 ni tagagamit na <b>[$2]</b> mula sa flickr. Orihinal na URL',
	'importfreeimages_promptuserforfilename' => 'Pakipasok (maglagay) ng isang kapupuntahang pangalan ng talaksan:',
	'importfreeimages_returntoform' => "O kaya, pindutin <a href='$1'>dito</a> upang makabalik sa mga resulta ng iyong paghahanap",
);

/** Turkish (Türkçe)
 * @author Mach
 */
$messages['tr'] = array(
	'importfreeimages_next' => 'Sonraki $1',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Aleksandrit
 */
$messages['uk'] = array(
	'importfreeimages' => 'Імпорт вільних зображень',
	'importfreeimages-desc' => 'Дозволяє [[Special:ImportFreeImages|імпортувати ліцензовані належним чином фотографії]] з [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Ця сторінка дозволяє вам шукати фотографії з Flickr, ліцензовані належним чином, та імпортувати їх до вікі.',
	'importfreeimages_noapikey' => 'Ви не налаштували ваш Flickr API-ключ.
Щоб це зробити, отримайте API-ключ [http://www.flickr.com/services/api/misc.api_keys.html тут] і встановіть wgFlickrAPIKey в ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Не знайдено фотографій за умовою «$1», спробуйте ще раз.',
	'importfreeimages_invalidurl' => "URL «$1» не є правильним ім'ям зображення з Flickr.",
	'importfreeimages_owner' => 'Автор',
	'importfreeimages_importthis' => 'імпортувати це',
	'importfreeimages_next' => 'Наступні $1',
	'importfreeimages_filefromflickr' => '$1 авторства <b>[$2]</b> з Flickr. Оригінальний URL',
	'importfreeimages_promptuserforfilename' => "Будь-ласка, введіть нове ім'я файлу:",
	'importfreeimages_returntoform' => "Або натисніть <a href='$1'>тут</a>, щоб повернутися до ваших результатів пошуку.",
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'importfreeimages' => 'Inporta imagini lìbare',
	'importfreeimages-desc' => "Fornisse un modo par [[Special:ImportFreeImages|inportar foto co' la justa licensa]] da [http://www.flickr.com flickr]",
	'importfreeimages_description' => "Sta pàxena la te permete de sercar imagini co' la justa licensa su flickr e inportarle su la to wiki.",
	'importfreeimages_noapikey' => 'No te ghè configurà la to ciave API Flickr.
Par farlo domanda na chiave API [http://www.flickr.com/services/api/misc.api_keys.html qua] e inposta wgFlickrAPIKey in ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => "Nissuna foto la sodisfa el criterio de riçerca '$1', próa da novo.",
	'importfreeimages_invalidurl' => 'L\'URL "$1" no\'l corisponde mia a na imagine de Flickr valida.',
	'importfreeimages_owner' => 'Autor',
	'importfreeimages_importthis' => 'inporta sto qua',
	'importfreeimages_next' => 'Sucessivi $1',
	'importfreeimages_filefromflickr' => "$1 da l'utente <b>[$2]</b> da flickr. URL originale",
	'importfreeimages_promptuserforfilename' => 'Inserissi un nome par el file de destinassion:',
	'importfreeimages_returntoform' => "O senò struca <a href='$1'>chì</a> par tornar indrìo ai risultati de la to riçerca",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'importfreeimages' => 'Nhập khẩu hình tự do',
	'importfreeimages-desc' => 'Là một cách để [[Special:ImportFreeImages|nhập khẩu những hình ảnh được cấp phép thích hợp]] từ [http://www.flickr.com Flickr]',
	'importfreeimages_description' => 'Trang này cho phép bạn tìm những hình ảnh được cấp phép thích hợp từ Flickr và truyền chúng vào wiki của bạn.',
	'importfreeimages_noapikey' => 'Bạn chưa cấu hình Khóa API Flickr của bạn.
Để làm điều đó, hãy lấy một khóa API từ [http://www.flickr.com/services/api/misc.api_keys.html đây] và thiết lập biến wgFlickrAPIKey trong ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Không tìm thấy hình nào phù hợp với tiêu chí tìm kiếm ‘$1’ của bạn, xin hãy thử lại.',
	'importfreeimages_invalidurl' => 'Địa chỉ URL “$1” không phải hình Flickr hợp lệ.',
	'importfreeimages_owner' => 'Tác giả',
	'importfreeimages_importthis' => 'nhập cái này',
	'importfreeimages_next' => '$1 sau',
	'importfreeimages_filefromflickr' => '$1 bởi người dùng <b>[$2]</b> của Flickr. Địa chỉ URL gốc',
	'importfreeimages_promptuserforfilename' => 'Xin hãy nhập vào tên tập tin đích:',
	'importfreeimages_returntoform' => "Hoặc, nhấn vào <a href='$1'>đây</a> để quay trở lại kết quả tìm kiếm",
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'importfreeimages' => 'Nüveigön magodis libik',
	'importfreeimages-desc' => 'Mögükon [[Special:ImportFreeImages|nüveigi magodas labü däl pötik]] se [http://www.flickr.com flickr]',
	'importfreeimages_description' => 'Pad at dälon ole ad sukön magodis labü däl pötik se el flickr ed ad nuveigön onis ini vük olik.',
	'importfreeimages_noapikey' => 'No evälol parametis kika-API olik pro el Flickr.
Ad dunön osi, dagetolös kiki-API [http://www.flickr.com/services/api/misc.api_keys.html isao] e parametükolös eli wgFlickrAPIKey in el ImportFreeImages.php.',
	'importfreeimages_nophotosfound' => 'Magods nonik petuvons ma sukaparamets: „$1“. Steifülolös nogna.',
	'importfreeimages_invalidurl' => 'El URL „$1“ no labon magodi lonöföl ela Flickr.',
	'importfreeimages_owner' => 'Lautan',
	'importfreeimages_importthis' => 'nüveigön atosi',
	'importfreeimages_next' => 'Sököl $1',
	'importfreeimages_filefromflickr' => "$1 fa geban: <b>[$2]</b> de 'flickr'. 'URL' rigik",
	'importfreeimages_promptuserforfilename' => 'Penolös zeilaragivanem:',
	'importfreeimages_returntoform' => "U välolös <a href='$1'>is</a> me mugaparat ad geikön lü sukaseks olik",
);

