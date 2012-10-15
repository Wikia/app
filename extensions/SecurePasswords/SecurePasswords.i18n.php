<?php
/**
 * Internationalisation file for SecurePasswords extension.
 */

$messages = array();

/** English
 * @author Ryan Schmidt
 */
$messages['en'] = array(
	'securepasswords-desc' => 'Creates more secure password hashes and adds a password strength checker',
	'securepasswords-valid' => 'Your password is invalid or too short.
It must: $1.',
	'securepasswords-minlength' => 'be at least $1 {{PLURAL:$1|character|characters}} long',
	'securepasswords-lowercase' => 'contain at least 1 lowercase letter',
	'securepasswords-uppercase' => 'contain at least 1 uppercase letter',
	'securepasswords-digit' => 'contain at least 1 digit',
	'securepasswords-special' => 'contain at least 1 special character (special characters are: $1)',
	'securepasswords-username' => 'be different from your username', # This message supports {{GENDER}} using $1
	'securepasswords-word' => 'not be a word',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'securepasswords-desc' => '{{desc}}',
	'securepasswords-username' => '{{gender}}
* (optional) $1 is the user name',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'securepasswords-desc' => 'ينشئ هاشات كلمة سر أكثر أمنا ويضيف متحقق من قوة كلمة السر',
	'securepasswords-valid' => 'كلمة السر غير صحيحة أو قصيرة جدا.
يجب: $1.',
	'securepasswords-minlength' => 'يكون طولها على الأقل {{PLURAL:$1||حرفًا واحدًا|حرفين|$1 حروف|$1 حرفًا|$1 حرف}}',
	'securepasswords-lowercase' => 'تحتوي على الأقل على حرف واحد صغير',
	'securepasswords-uppercase' => 'تحتوي على الأقل على حرف واحد كبير',
	'securepasswords-digit' => 'يحتوى على رقم واحد على الأقل',
	'securepasswords-special' => 'تحتوى على الأقل على رمز خاص (الرموز الخاصة مثل : $1)',
	'securepasswords-username' => 'تكون مختلفة عن اسم المستخدم',
	'securepasswords-word' => 'لا تكون كلمة',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ouda
 * @author Ramsis II
 */
$messages['arz'] = array(
	'securepasswords-desc' => 'ينشئ هاشات كلمة سر أكثر أمنا ويضيف متحقق من قوة كلمة السر',
	'securepasswords-valid' => 'الباسورد بتاعتك ماتنفعش او قصيره خالص.
الباسورد لازم: $1.',
	'securepasswords-minlength' => 'لازم طولها يكون ع الاقل $1 {{PLURAL:$1|حرف|حرف}}',
	'securepasswords-lowercase' => 'تحتوى على الأقل على حرف واحد صغير',
	'securepasswords-uppercase' => 'تحتوى على الأقل على حرف واحد كبير',
	'securepasswords-digit' => 'يحتوى على رقم واحد على الأقل',
	'securepasswords-special' => 'بتحتوى على رمز خاص واحد ع الاقل (الرموز الخاصه هما:$1)',
	'securepasswords-username' => 'تكون مختلفة عن اسم المستخدم',
	'securepasswords-word' => 'لا تكون كلمة',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'securepasswords-desc' => 'Стварае больш бясьпечныя хэшы пароляў і дадае палепшаную праверку сакрэтнасьці пароляў',
	'securepasswords-valid' => 'Ваш пароль няслушны ці занадта кароткі.
Павінен: $1.',
	'securepasswords-minlength' => 'складацца хаця б $1 {{PLURAL:$1|сымбаль|сымбалі|сымбаляў}}',
	'securepasswords-lowercase' => 'утрымліваць хаця бы адну малую літару',
	'securepasswords-uppercase' => 'утрымліваць хаця бы адну вялікую літару',
	'securepasswords-digit' => 'утрымліваць хаця бы адну лічбу',
	'securepasswords-special' => 'утрымліваць хаця бы адзін спэцыяльны сымбаль (такі як: $1)',
	'securepasswords-username' => 'адрозьнівацца ад Вашага імя ўдзельніка',
	'securepasswords-word' => 'ня быць словам',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'securepasswords-desc' => "Sevel a ra hacherezh gerioù-tremen suroc'h hag ouzhpennañ a ra ur gwirier kemplezhder ar gerioù-tremen.",
	'securepasswords-valid' => 'Direizh pe re verr eo ho ker-tremen.
Ret eo dezhañ : $1.',
	'securepasswords-minlength' => 'bezañ $1 {{PLURAL:$1|arouezenn|arouezenn}} hir da nebeutañ',
	'securepasswords-lowercase' => 'ennañ ul lizherenn vunut da nebeutañ',
	'securepasswords-uppercase' => 'ennañ ur bennlizherenn da nebeutañ',
	'securepasswords-digit' => '1 sifr ennañ da nebeutañ',
	'securepasswords-special' => "Enderc'hel 1 arouezenn dibar da nebeutañ (an arouezennoù dibar zo : $1)",
	'securepasswords-username' => "bezañ disheñvel eus hoc'h anv implijer",
	'securepasswords-word' => 'arabat eo e vefe ur ger',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'securepasswords-desc' => 'Pravljenje mnogo sigurnijih haševa za šifre i dodaje provjeru jačine šifre',
	'securepasswords-valid' => 'Vaša šifra je nevaljana ili je prekratka.
Mora: $1.',
	'securepasswords-minlength' => 'biti duga najmanje $1 {{PLURAL:$1|znak|znaka|znakova}}',
	'securepasswords-lowercase' => 'sadržavati najmanje 1 malo slovo',
	'securepasswords-uppercase' => 'sadržavati najmanje 1 veliko slovo',
	'securepasswords-digit' => 'sadržavati najmanje 1 cifru',
	'securepasswords-special' => 'sadržavati najmanje 1 specijalni znak (specijalni znakovi su: $1)',
	'securepasswords-username' => 'biti različita od Vašeg korisničkog imena',
	'securepasswords-word' => 'ne bude riječ',
);

/** Catalan (Català)
 * @author Aleator
 */
$messages['ca'] = array(
	'securepasswords-valid' => 'La seva contrasenya no és vàlida o és massa curta: $1.
Ha de: $1.',
	'securepasswords-minlength' => 'ser com a mínim de $1 {{PLURAL:$1|caràcter|caràcters}}',
	'securepasswords-lowercase' => 'contenir com a mínim 1 lletra en minúscula',
	'securepasswords-uppercase' => 'contenir com a mínim 1 lletra en majúscula',
	'securepasswords-digit' => 'contenir com a mínim 1 dígit',
	'securepasswords-special' => 'contenir com a mínim 1 caràcter especial (són caràcters especials els següents: $1)',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Melancholie
 * @author Umherirrender
 */
$messages['de'] = array(
	'securepasswords-desc' => 'Ermöglicht die Generierung sichererer Passwortstreuwerte und fügt eine Passwortstärkenprüfung hinzu',
	'securepasswords-valid' => 'Das Passwort ist entweder ungültig oder zu kurz.
Es muss: $1.',
	'securepasswords-minlength' => 'mindestens {{PLURAL:$1|ein Zeichen|$1 Zeichen}} lang sein',
	'securepasswords-lowercase' => 'mindestens einen Kleinbuchstaben enthalten',
	'securepasswords-uppercase' => 'mindestens einen Großbuchstaben enthalten',
	'securepasswords-digit' => 'mindestens eine Ziffer enthalten',
	'securepasswords-special' => 'mindestens ein Sonderzeichen enthalten (Sonderzeichen sind: $1)',
	'securepasswords-username' => 'sich von deinem Benutzernamen unterscheiden',
	'securepasswords-word' => 'etwas anderes als ein Wort sein',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'securepasswords-username' => 'sich von Ihrem Benutzernamen unterscheiden',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'securepasswords-desc' => 'Napórajo wěsćejše gronidłowe hašy a pśidawa funkciju za kontrolěrowanje mócy gronidła.',
	'securepasswords-valid' => 'Twójo gronidło jo njepłaśiwe abo pśekrotko. Musy: $1.',
	'securepasswords-minlength' => 'nanejmjenjej $1 {{PLURAL:$1|znamuško|znamušce|znamuška|znamuškow}} dłujke byś',
	'securepasswords-lowercase' => 'nanejmjenjej 1 mały pismik wopśimjeś',
	'securepasswords-uppercase' => 'nanejmjenjej 1 wjeliki pismik wopśimjeś',
	'securepasswords-digit' => 'nanejmjenjej 1 cyfru wopśimjeś',
	'securepasswords-special' => 'nanejmjenjej 1 specialne znamuško wopśimjeś (Specialne znamuška su: $1)',
	'securepasswords-username' => 'se wót twójogo wužywarske mjenja rozeznawaś',
	'securepasswords-word' => 'něco druge byś ako słowo',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Dada
 * @author Omnipaedista
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'securepasswords-valid' => 'Ο κωδικός σας είναι ακατάλληλος ή πολύ μικρός. Πρέπει: $1.',
	'securepasswords-minlength' => 'να έχει τουλάχιστον $1 {{PLURAL:$1|χαρακτήρα|χαρακτήρες}}',
	'securepasswords-lowercase' => 'να περιλαμβάνει τουλάχιστον 1 πεζό γράμμα',
	'securepasswords-uppercase' => 'να περιλαμβάνει τουλάχιστον 1 κεφαλαίο γράμμα',
	'securepasswords-digit' => 'περίληψη τουλάχιστον 1 ψηφίου',
	'securepasswords-special' => 'να περιλαμβάνει τουλάχιστον 1 ειδικό χαρακτήρα (οι ειδικοί χαρακτήρες είναι: $1)',
	'securepasswords-username' => 'να είναι διαφορετικός από το όνομα χρήστη',
	'securepasswords-word' => 'να μην είναι μία λέξη',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'securepasswords-valid' => 'Via pasvorto estas malvalida aŭ tro mallonga.
Ĝi devas: $1.',
	'securepasswords-minlength' => 'esti longa almenaŭ $1 {{PLURAL:$1|signo|signoj}}',
	'securepasswords-lowercase' => 'enhavi almenaŭ 1 minusklan signon',
	'securepasswords-uppercase' => 'enhavi almenaŭ 1 majusklan signon',
	'securepasswords-digit' => 'enhavi almenaŭ 1 ciferon',
	'securepasswords-special' => 'enhavi almenaŭ 1 specialan signon (specialaj signoj estas: $1)',
	'securepasswords-username' => 'esti malsama de via salutnomo',
	'securepasswords-word' => 'ne esti vorto',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Sanbec
 */
$messages['es'] = array(
	'securepasswords-desc' => 'Crea cifrados de contraseñas más seguras y añade un comprobador de su fortaleza',
	'securepasswords-valid' => 'Tu contraseña es inválida o demasiado corta.
Debe ser: $1.',
	'securepasswords-minlength' => 'ser al menos $1 {{PLURAL:$1|caracter|caracteres}} de largo',
	'securepasswords-lowercase' => 'Contener al menos 1 letra minúscula',
	'securepasswords-uppercase' => 'Contener al menos 1 letra mayúscula',
	'securepasswords-digit' => 'Contener al menos 1 dígito',
	'securepasswords-special' => 'Contener al menos 1 carácter especial (carácteres especiales son: $1)',
	'securepasswords-username' => 'ser diferente de su nombre de usuario',
	'securepasswords-word' => 'no ser una palabra',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'securepasswords-valid' => 'Zure pasahitza oker dago edo motzegia da.
Honelakoa izan behar du: $1.',
	'securepasswords-minlength' => 'Gutxienez, {{PLURAL:$1|karaktere $1|$1 karaktere}} luze izan behar du',
	'securepasswords-lowercase' => 'gutxienez hizki bat minuskulaz izan',
	'securepasswords-uppercase' => 'gutxienez letra larri bat izan',
	'securepasswords-digit' => 'gutxienez digitu bat izan',
	'securepasswords-special' => 'gutxienez karaktere berezi bat izan (Hauek dira karaktere bereziak: $1)',
	'securepasswords-username' => 'erabiltzaile izenetik desberdina izan',
);

/** Persian (فارسی)
 * @author Americophile
 */
$messages['fa'] = array(
	'securepasswords-word' => 'کلمه نباشد.',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'securepasswords-desc' => 'Luo turvallisempia salasanatiivisteitä ja lisää salasanan vahvuuden tarkistajan.',
	'securepasswords-valid' => 'Salasanasi ei kelpaa tai on liian lyhyt.
Sen pitää täyttää seuraavat ehdot: $1.',
	'securepasswords-minlength' => 'olla vähintään $1 {{PLURAL:$1|merkkiä|merkkiä}}',
	'securepasswords-lowercase' => 'sisältää vähintään yhden pienaakkosen',
	'securepasswords-uppercase' => 'sisältää vähintään yksi suuraakkonen',
	'securepasswords-digit' => 'sisältää vähintään yksi numero',
	'securepasswords-special' => 'sisältää vähintään yksi erikoismerkki (erikoismerkkejä ovat: $1)',
	'securepasswords-username' => 'olla eri kuin käyttäjänimesi',
	'securepasswords-word' => 'ei saa olla sana',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 */
$messages['fr'] = array(
	'securepasswords-desc' => 'Crée des hachages de mots de passe plus sûrs et ajoute un vérificateur de complexité de mots de passe',
	'securepasswords-valid' => 'Votre mot de passe est invalide ou trop court. Il doit : $1.',
	'securepasswords-minlength' => 'être long d’au moins $1 caractère{{PLURAL:$1||s}}',
	'securepasswords-lowercase' => 'contenir au moins 1 lettre minuscule',
	'securepasswords-uppercase' => 'contenir au moins 1 lettre majuscule',
	'securepasswords-digit' => 'contenir au moins 1 chiffre',
	'securepasswords-special' => 'contenir au moins 1 caractère spécial (les caractères spéciaux sont : $1)',
	'securepasswords-username' => 'être différent de votre nom d’utilisateur',
	'securepasswords-word' => 'ne pas être un mot',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'securepasswords-word' => 'pas étre un mot',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'securepasswords-desc' => 'Crea un contrasinal cardinal máis seguro e engade un comprobador da fortaleza deste',
	'securepasswords-valid' => 'O seu contrasinal é inválido ou moi curto.
Debe: $1.',
	'securepasswords-minlength' => 'ter, polo menos, {{PLURAL:$1|un carácter|$1 caracteres}}',
	'securepasswords-lowercase' => 'conter, polo menos, unha letra minúscula',
	'securepasswords-uppercase' => 'conter, polo menos, unha letra maiúscula',
	'securepasswords-digit' => 'conter, polo menos, un díxito',
	'securepasswords-special' => 'conter, polo menos, un carácter especial (caracteres especiais son: $1)',
	'securepasswords-username' => 'ser diferente do seu nome de usuario',
	'securepasswords-word' => 'non ser unha palabra',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'securepasswords-desc' => 'Legt sichereri Passwort-Hashes aa un fiegt e Passwortstärchipriefieg zue',
	'securepasswords-valid' => 'Dyy Passwort isch nit giltig oder z churz.
S muess: $1.',
	'securepasswords-minlength' => 'zmindescht $1 {{PLURAL:$1|Zeiche|Zeiche}} lang syy',
	'securepasswords-lowercase' => 'zmindescht ei Chleibuechstab din haa',
	'securepasswords-uppercase' => 'zmindescht ei Großbuechstab din haa',
	'securepasswords-digit' => 'zmindescht ei Ziffer din haa',
	'securepasswords-special' => 'zmindescht ei Sonderzeiche din haa (Sonderzeiche sin: $1)',
	'securepasswords-username' => 'sich vu Dynem Benutzernamen unterscheide',
	'securepasswords-word' => 'ebis anderes syy wie ne Wort',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'securepasswords-desc' => 'יצירת גיבובי סיסמאות מאובטחים יותר והוספת בודק חוזק סיסמאות',
	'securepasswords-valid' => 'הסיסמה שלכם אינה תקינה או קצרה מדי. עליה: $1.',
	'securepasswords-minlength' => 'להיות לפחות באורך של {{PLURAL:$1|ספרה אחת|$1 ספרות}}',
	'securepasswords-lowercase' => 'להכיל לפחות אות קטנה אחת',
	'securepasswords-uppercase' => 'להכיל לפחות אות גדולה אחת',
	'securepasswords-digit' => 'להכיל לפחות ספרה אחת',
	'securepasswords-special' => 'להכיל לפחות תו מיוחד אחד (התווים המיוחדים הם: $1)',
	'securepasswords-username' => 'להיות שונה משם המשתמש שלכם',
	'securepasswords-word' => 'לא להיות מילה',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'securepasswords-desc' => 'iše hesłowe haše a přidawa funkciju za kontrolowanje hesłoweje mocy',
	'securepasswords-valid' => 'Twoje hesło je njepłaćiwe abo překrótke. Dyrbi: $1.',
	'securepasswords-minlength' => 'znajmjeńša $1 {{PLURAL:$1|znamješko|znamješce|znamješka|znamješkow}} dołhe być',
	'securepasswords-lowercase' => 'znajmjeńša 1 mały pismik wobsahować',
	'securepasswords-uppercase' => 'znajmjeńša 1 wulki pismik wobsahować',
	'securepasswords-digit' => 'znajmjeńša 1 cyfru wobsahować',
	'securepasswords-special' => 'znajmjeńša 1 specialne znamješko wobsahować (Specialne znamješka su: $1)',
	'securepasswords-username' => 'so wot twojeho wužywarskeho mjena rozeznać',
	'securepasswords-word' => 'něšto druhe być hač słowo',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'securepasswords-desc' => 'Biztonságosabb jelszó-hasheket készít, és jelszó megadásakor ellenőrzi annak erősségét',
	'securepasswords-valid' => 'A jelszavad érvénytelen, vagy túl rövid.
Követelmények: $1.',
	'securepasswords-minlength' => 'legalább {{PLURAL:$1|egy|$1}} karakter hosszú',
	'securepasswords-lowercase' => 'legalább egy kisbetűt tartalmaz',
	'securepasswords-uppercase' => 'legalább egy nagybetűt tartalmaz',
	'securepasswords-digit' => 'legalább egy számot tartalmaz',
	'securepasswords-special' => 'legalább egy speciális karaktert tartalmaz (speciális karakterek: $1)',
	'securepasswords-username' => 'különböznie kell a felhasználói nevedtől',
	'securepasswords-word' => 'nem lehet egy szó',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'securepasswords-desc' => 'Crea hashes plus secur del contrasignos e adde un verificator de complexitate de contrasignos',
	'securepasswords-valid' => 'Tu contrasigno es invalide o troppo curte.
Illo debe: $1.',
	'securepasswords-minlength' => 'esser al minus $1 {{PLURAL:$1|character|characteres}} de longitude',
	'securepasswords-lowercase' => 'continer al minus 1 littera minuscule',
	'securepasswords-uppercase' => 'continer al minus 1 littera majuscule',
	'securepasswords-digit' => 'continer al minus 1 digito',
	'securepasswords-special' => 'continer al minus 1 character special (le characteres special es: $1)',
	'securepasswords-username' => 'esser differente de tu nomine de usator',
	'securepasswords-word' => 'non esser un parola',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'securepasswords-desc' => 'Membuat sebuah pengacakan kata sandi yang lebih aman dan menambah pemeriksaan kekuatan kata sandi',
	'securepasswords-valid' => 'Kata sandi Anda tidak sah atau terlalu pendek.
Kata sandi Anda harus: $1.',
	'securepasswords-minlength' => 'memiliki panjang paling tidak $1 {{PLURAL:$1|karakter|karakter}}',
	'securepasswords-lowercase' => 'memiliki huruf kecil paling tidak 1',
	'securepasswords-uppercase' => 'memiliki huruf besar paling tidak 1',
	'securepasswords-digit' => 'memiliki angka paling tidak 1',
	'securepasswords-special' => 'memiliki karakter istimewa ($1) paling tidak 1',
	'securepasswords-username' => 'berbeda dari nama pengguna Anda',
	'securepasswords-word' => 'tidak boleh sebuah kata (dalam bahasa Inggris)',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'securepasswords-desc' => 'Crea hash password più sicuri e aggiunge un controllore della complessità delle password',
	'securepasswords-valid' => 'La password non è valida o è troppo corta.
Deve: $1.',
	'securepasswords-minlength' => 'essere lunga almeno $1 {{PLURAL:$1|carattere|caratteri}}',
	'securepasswords-lowercase' => 'contenere almeno 1 lettera minuscola',
	'securepasswords-uppercase' => 'contenere almeno 1 lettera maiuscola',
	'securepasswords-digit' => 'contenere almeno 1 cifra',
	'securepasswords-special' => 'contenere almeno 1 carattere speciale (caratteri speciali sono: $1)',
	'securepasswords-username' => 'essere diversa dal proprio nome utente',
	'securepasswords-word' => 'non essere una parola',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Mizusumashi
 */
$messages['ja'] = array(
	'securepasswords-desc' => 'より安全なパスワードのハッシュを生成し、パスワード強度検査器を追加する',
	'securepasswords-valid' => 'あなたのパスワードは不正であるか、または短すぎます。
以下を充たさなければなりません: $1.',
	'securepasswords-minlength' => '$1{{PLURAL:$1|文字}}以上の長さである',
	'securepasswords-lowercase' => '最低1文字は小文字を含む',
	'securepasswords-uppercase' => '最低1文字は大文字を含む',
	'securepasswords-digit' => '最低1文字は数字を含む',
	'securepasswords-special' => '最低1文字は特殊文字を含む (特殊文字: $1)',
	'securepasswords-username' => '利用者名とは異なる',
	'securepasswords-word' => '単語ではない',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'securepasswords-valid' => 'ពាក្យសំងាត់​របស់​អ្នក​មិន​ត្រឹមត្រូវ ឬ ខ្លី​ពេក​។
វា​ត្រូវតែ: $1.',
	'securepasswords-minlength' => 'ត្រូវតែ​យ៉ាង​តិច​ណាស់​ត្រូវ​មាន $1 {{PLURAL:$1|តួអក្សរ|តួអក្សរ}}',
	'securepasswords-lowercase' => 'មាន​យ៉ាង​តិច ១ តួអក្សរ​តូច',
	'securepasswords-uppercase' => 'មាន​យ៉ាង​តិច ១ តួអក្សរ​ធំ',
	'securepasswords-digit' => 'មាន​យ៉ាង​តិច ១ តួ​លេខ',
	'securepasswords-special' => 'មាន​យ៉ាង​តិច ១ តួ​អក្សរ​ពិសេស (តួអក្សរ​ពិសេស​មាន: $1)',
	'securepasswords-username' => 'ត្រូវតែ​ខុសពី​ឈ្មោះអ្នកប្រើប្រាស់​របស់​អ្នក',
	'securepasswords-word' => 'មិនមែន​ជា​ពាក្យ',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'securepasswords-desc' => '안전한 비밀번호 해쉬를 만들고 비밀번호 강도 검사를 실시',
	'securepasswords-valid' => '당신의 비밀번호가 잘못되었거나 너무 짧습니다.
비밀번호는 반드시: $1.',
	'securepasswords-minlength' => '적어도 $1글자 이상이어야 합니다.',
	'securepasswords-lowercase' => '적어도 1개의 소문자가 있어야 합니다.',
	'securepasswords-uppercase' => '적어도 1개의 대문자를 포함해야 합니다.',
	'securepasswords-digit' => '적어도 1개의 숫자를 포함해야 합니다.',
	'securepasswords-special' => '적어도 1개의 특수 문자를 포함해야 합니다. (특수 문자: $1)',
	'securepasswords-username' => '당신의 계정 이름과 달라야 합니다.',
	'securepasswords-word' => '단어가 아니어야 합니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'securepasswords-desc' => 'Deiht en Pröfung för de Passwoote ier Qualiteit em Wiki dobei, un määt en besser (seechere) Verschlößelung för de Passwoote.',
	'securepasswords-valid' => 'Ding Paßwoot is onjöltisch udder ze koot.
Et mööt: $1.',
	'securepasswords-minlength' => 'winnishßtens {{PLURAL:$1|ei|$1|kei}} Zeiche lang sin',
	'securepasswords-lowercase' => 'winnischßdens eine kleine Bochstabe enthallde',
	'securepasswords-uppercase' => 'winnischßdens eine jroße Bochstabe enthallde',
	'securepasswords-digit' => 'winnischßdens ein Zeffer enthallde',
	'securepasswords-special' => 'winnischßdens ei Sönderzeiche enthallde. De Sönderzeiche sinn_er: $1',
	'securepasswords-username' => 'anders wi Dinge Metmaachername sinn',
	'securepasswords-word' => 'kein nomaal Woot sin',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'securepasswords-desc' => "Mécht méi sécher Paswuert-''Hashes'' a setzt eng Iwwerpréifung vun der Sécherheet vun de Passwierder derbäi",
	'securepasswords-valid' => 'Äert Passwuert ass net valabel oder ze kuerz.
Et: $1.',
	'securepasswords-minlength' => "muss op d'mannst $1 {{PLURAL:$1|Zeeche|Zeeche}} laang sinn",
	'securepasswords-lowercase' => "muss op d'mannst 1 klenge Buschstaf dra sinn",
	'securepasswords-uppercase' => "muss op d'mannst 1 grousse Buschstaf dra sinn",
	'securepasswords-digit' => "muss op d'mannst 1 Ziffer dra sinn",
	'securepasswords-special' => "muss op d'mannst 1 Spezialzeechen dra sinn (Spezialzeeche sinn: $1)",
	'securepasswords-username' => 'muss verschidde vun Ärem Benotzernumm sinn',
	'securepasswords-word' => 'däerf kee Wuert sinn',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'securepasswords-desc' => 'Создава повеќе тараби за безбедна лозинка и додава проверувач на јачината на лозинката',
	'securepasswords-valid' => 'Вашата лозинка е неважечка или прекратка.
Лозинката мора да: $1.',
	'securepasswords-minlength' => 'содржи барем  $1 {{PLURAL:$1|знак|знаци}}',
	'securepasswords-lowercase' => 'содржи барем 1 мала буква',
	'securepasswords-uppercase' => 'содржи барем 1 голема буква',
	'securepasswords-digit' => 'содржи барем 1 цифра',
	'securepasswords-special' => 'содржи барем 1 специјален знак (специјални знаци се: $1)',
	'securepasswords-username' => 'се разликува од вашето корисничко име',
	'securepasswords-word' => 'не биде збор',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'securepasswords-desc' => 'കൂടുതൽ സുരക്ഷിതമായ രഹസ്യവാക്ക് ഹാഷുകളും, രഹസ്യവാക്കിന്റെ ശേഷി പരിശോധനോപകരണവും സൃഷ്ടിക്കുന്നു',
	'securepasswords-valid' => 'താങ്കളുടെ രഹസ്യവാക്ക് അസാധുവാണ് അല്ലെങ്കിൽ തീരെ ചെറുതാണ്.
അത്: $1.',
	'securepasswords-minlength' => 'കുറഞ്ഞത് {PLURAL:$1|ഒരക്ഷരം|$1 അക്ഷരങ്ങൾ}} നീളമുള്ളതാവണം',
	'securepasswords-lowercase' => 'കുറഞ്ഞത് ഒരു ലോവർകേസ് അക്ഷരം ഉൾക്കൊള്ളുന്നു',
	'securepasswords-uppercase' => 'കുറഞ്ഞത് ഒരു അപ്പർകേസ് അക്ഷരം ഉൾക്കൊള്ളുന്നു',
	'securepasswords-digit' => 'ഒരു അക്കമെങ്കിലും ഉൾക്കൊള്ളണം',
	'securepasswords-special' => 'ഒരു പ്രത്യേകാക്ഷരമെങ്കിലും ഉൾക്കൊള്ളണം (പ്രത്യേകാക്ഷരങ്ങൾ: $1)',
	'securepasswords-username' => 'താങ്കളുടെ ഉപയോക്തൃനാമത്തിൽ നിന്നും വ്യത്യസ്തമായിരിക്കണം',
	'securepasswords-word' => 'ഒരു വാക്ക് ആയിരിക്കരുത്',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'securepasswords-word' => 'ahmo tlahtōl',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'securepasswords-desc' => 'Oppretter sikrere passordhasher og legger til en funksjon for sjekking av passordstyrke',
	'securepasswords-valid' => 'Passordet ditt er ugyldig eller for kort.
Det må: $1.',
	'securepasswords-minlength' => 'være minst {{PLURAL:$1|ett tegn|$1 tegn}} langt',
	'securepasswords-lowercase' => 'inneholde minst én liten bokstav',
	'securepasswords-uppercase' => 'inneholde minst én stor bokstav',
	'securepasswords-digit' => 'inneholde minst ett tall',
	'securepasswords-special' => 'inneholde minst ett spesialtegn (spesialtegnene er: $1)',
	'securepasswords-username' => 'være forskjellig fra brukernavnet ditt',
	'securepasswords-word' => 'ikke være et ord',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'securepasswords-desc' => 'Gebruikt veiliger wachtwoordhashes en voegt een wachtwoordsterktecontrole toe',
	'securepasswords-valid' => 'Uw wachtwoord voldoet niet aan de voorwaarden.
Het moet: $1.',
	'securepasswords-minlength' => 'tenminste $1 {{PLURAL:$1|karakter|karakters}} bevatten',
	'securepasswords-lowercase' => 'tenminste 1 kleine letter bevatten',
	'securepasswords-uppercase' => 'tenminste 1 hoofdletter bevatten',
	'securepasswords-digit' => 'tenminste 1 cijfer bevatten',
	'securepasswords-special' => 'tenminste 1 speciaal karakter bevatten (speciale karakters zijn: $1)',
	'securepasswords-username' => 'verschillen van uw gebruikersnaam',
	'securepasswords-word' => 'geen woord zijn',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'securepasswords-desc' => 'Opprettar meir sikre passordhashar og legg til ein funksjon for sjekking av passordstyrke',
	'securepasswords-valid' => 'Passordet ditt er ugyldig eller for kort.
Det må: $1.',
	'securepasswords-minlength' => 'ha ei lengd på minst {{PLURAL:$1|eitt teikn|$1 teikn}}',
	'securepasswords-lowercase' => 'innehalda minst éin liten bokstav',
	'securepasswords-uppercase' => 'innehalda minst éin stor bokstav',
	'securepasswords-digit' => 'innehalda minst eitt tal',
	'securepasswords-special' => 'innehalda minst eitt spesialteikn (spesialteikna er: $1)',
	'securepasswords-username' => 'ikkje vera det same som brukarnamnet ditt',
	'securepasswords-word' => 'ikkje vera eit ord',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'securepasswords-desc' => "Crèa d'hachages de senhals mai segurs e apond un verificator de complexitat de senhal",
	'securepasswords-valid' => 'Vòstre senhal es invalid o tròp cort.
Deu : $1.',
	'securepasswords-minlength' => 'èsser long d’al mens $1 {{PLURAL:$1|caractèr|caractèrs}}',
	'securepasswords-lowercase' => 'conténer al mens 1 letra minuscula',
	'securepasswords-uppercase' => 'conténer al mens 1 letra majuscula',
	'securepasswords-digit' => 'conténer al mens 1 chifra',
	'securepasswords-special' => 'conténer al mens 1 caractèr especial (los caractèrs especials son : $1)',
	'securepasswords-username' => "èsser diferent de vòstre nom d'utilizaire",
	'securepasswords-word' => 'pas èsser un mot',
);

/** Polish (Polski)
 * @author Matma Rex
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'securepasswords-desc' => 'Tworzy bezpieczniejszy skrót hasła oraz poprawia jego weryfikację',
	'securepasswords-valid' => 'Hasło jest nieprawidłowe lub zbyt krótkie.
Musi ono: $1.',
	'securepasswords-minlength' => 'składać się z co najmniej $1 {{PLURAL:$1|znaku|znaków}}',
	'securepasswords-lowercase' => 'zawierać co najmniej 1 małą literę',
	'securepasswords-uppercase' => 'zawierać co najmniej 1 wielką literę',
	'securepasswords-digit' => 'zawierać co najmniej 1 cyfrę',
	'securepasswords-special' => 'zawierać co najmniej 1 znak specjalny (taki jak: $1)',
	'securepasswords-username' => 'różnić się od Twojej nazwy użytkownika',
	'securepasswords-word' => 'nie być słowem',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'securepasswords-desc' => 'A crea ciav casuaj pì sicure e a gionta un controlor ëd la fòrsa dla ciav',
	'securepasswords-valid' => "Toa ciav a l'é pa bon-a o tròp curta.
A deuv: $1.",
	'securepasswords-minlength' => 'esse almanch longa $1 {{PLURAL:$1|caràter|caràter}}',
	'securepasswords-lowercase' => 'conten-e almanch 1 litra minùscula',
	'securepasswords-uppercase' => 'conten-e almanch 1 litra maiùscola',
	'securepasswords-digit' => 'conten almanch 1 sifra',
	'securepasswords-special' => 'conten-e almanch 1 caràter special (caràter speciaj a son: $1)',
	'securepasswords-username' => 'esse diferen da tò stranòm',
	'securepasswords-word' => 'pa esse na paròla',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'securepasswords-desc' => 'Cria resumos criptográficos mais seguros para as palavras-chave e adiciona um verificador da segurança da palavra-chave',
	'securepasswords-valid' => 'A sua palavra-chave é inválida ou demasiado curta.
Tem de: $1.',
	'securepasswords-minlength' => 'ter pelo menos $1 {{PLURAL:$1|carácter|caracteres}} de comprimento',
	'securepasswords-lowercase' => 'conter pelo menos 1 letra minúscula',
	'securepasswords-uppercase' => 'conter pelo menos 1 letra maiúscula',
	'securepasswords-digit' => 'conter pelo menos 1 dígito',
	'securepasswords-special' => 'conter pelo menos 1 carácter especial (os caracteres especiais são: $1)',
	'securepasswords-username' => 'ser diferente do seu nome de utilizador',
	'securepasswords-word' => 'não ser uma palavra',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'securepasswords-desc' => 'Cria "hashes" de palavras-chaves mais seguros e adiciona um verificador da força da palavra-chave',
	'securepasswords-valid' => 'A sua palavra-chave é inválida ou muito curta.
Tem de: $1.',
	'securepasswords-minlength' => 'ter pelo menos $1 {{PLURAL:$1|caracter|caracteres}} de comprimento',
	'securepasswords-lowercase' => 'conter pelo menos 1 letra minúscula',
	'securepasswords-uppercase' => 'conter pelo menos 1 letra maiúscula',
	'securepasswords-digit' => 'conter pelo menos 1 dígito',
	'securepasswords-special' => 'conter pelo menos 1 caracter especial (caracteres especiais são: $1)',
	'securepasswords-username' => 'ser diferente do seu nome de utilizador',
	'securepasswords-word' => 'não ser uma palavra',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'securepasswords-valid' => 'Parola dumneavoastră este incorectă sau prea scurtă.
Aceasta trebuie: $1.',
	'securepasswords-minlength' => 'să fie de cel puțin $1 {{PLURAL:$1|caracter|caractere}} lungime',
	'securepasswords-lowercase' => 'să conțină cel puțin o literă mică',
	'securepasswords-uppercase' => 'să conțină cel puțin o literă mare',
	'securepasswords-digit' => 'să conțină cel puțin o cifră',
	'securepasswords-special' => 'să conțină cel puțin un caracter special (caracterele speciale sunt: $1)',
	'securepasswords-username' => 'să fie diferită de numele de utilizator',
	'securepasswords-word' => 'să nu fie un cuvânt',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'securepasswords-valid' => "'A password toje jè invalida o troppe cuciule.
Adda essere: $1.",
	'securepasswords-username' => "differende da 'u nome utende tue",
	'securepasswords-word' => "non g'addà essere 'na parole",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'securepasswords-desc' => 'Создаёт защищённые хеши паролей и добавляет проверку силы пароля',
	'securepasswords-valid' => 'Вам пароль неверный или слишком короткий.
Он должен: $1.',
	'securepasswords-minlength' => 'быть, по крайней мере, длиной $1 {{PLURAL:$1|символ|символа|символов}}',
	'securepasswords-lowercase' => 'содержит минимум 1 строчную букву',
	'securepasswords-uppercase' => 'содержит минимум 1 прописную букву',
	'securepasswords-digit' => 'содержать минимум одну цифру',
	'securepasswords-special' => 'содержать минимум 1 служебный символ (служебные символы: $1)',
	'securepasswords-username' => 'будет отличаться от вашего имени участника',
	'securepasswords-word' => 'не слово',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Rudko
 */
$messages['sk'] = array(
	'securepasswords-desc' => 'Vytvára bezpečnejšie haše hesiel a pridáva kontrolu sily hesla',
	'securepasswords-valid' => 'Vaše heslo je nesprávne alebo príliš krátke. $1',
	'securepasswords-minlength' => 'musí byť dlhé aspoň $1 {{PLURAL:$1|znak|znaky|znakov}}',
	'securepasswords-lowercase' => 'musí obsahovať aspoň jedno malé písmeno',
	'securepasswords-uppercase' => 'musí obsahovať aspoň jedno veľké písmeno',
	'securepasswords-digit' => 'musí obsahovať aspoň jednu číslicu',
	'securepasswords-special' => 'musí obsahovať aspoň jeden špeciálny znak (povolené špeciálne znaky: $1)',
	'securepasswords-username' => 'musí byť iné ako vaše používateľské meno',
	'securepasswords-word' => 'nesmie to byť slovo zo slovníka',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'securepasswords-desc' => 'Ствара безбедније дисперзије лозинки и додаје проверу снаге лозинке',
	'securepasswords-valid' => 'Ваша лозинка је неисправна или прекратка.
Она мора: $1.',
	'securepasswords-minlength' => 'бити дугачка најмање $1 {{PLURAL:$1|знак|знакова}}.',
	'securepasswords-lowercase' => 'садржи најмање једно мало слово',
	'securepasswords-uppercase' => 'садржи најмање једно велико слово',
	'securepasswords-digit' => 'садржати најмање 1 цифру',
	'securepasswords-special' => 'садржати најмање 1 специјални знак (специјални знаци су: $1)',
	'securepasswords-username' => 'да се разликује од корисничког имена',
	'securepasswords-word' => 'не може да буде реч',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'securepasswords-desc' => 'Stvara bezbednije disperzije lozinki i dodaje proveru snage lozinke',
	'securepasswords-valid' => 'Vaša lozinka je neispravna ili prekratka.
Ona mora: $1.',
	'securepasswords-minlength' => 'biti dugačka najmanje $1 {{PLURAL:$1|znak|znakova}}.',
	'securepasswords-lowercase' => 'sadrži najmanje jedno malo slovo',
	'securepasswords-uppercase' => 'sadrži najmanje jedno veliko slovo',
	'securepasswords-digit' => 'sadržati najmanje 1 cifru',
	'securepasswords-special' => 'sadržati najmanje 1 specijalni znak (specijalni znaci su: $1)',
	'securepasswords-username' => 'da se razlikuje od korisničkog imena',
	'securepasswords-word' => 'ne može da bude reč',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'securepasswords-desc' => 'Moaket sicherere Paaswoud-Hashes un föiget ne Paaswoudstäärken-Wröige bietou',
	'securepasswords-valid' => 'Dien Paaswoud is uungultich of tou kuut.
Et mout: $1.',
	'securepasswords-minlength' => 'ap minste $1 {{PLURAL:$1|Teeken|Teekene}} loang weese',
	'securepasswords-lowercase' => 'ap minste ne Littikbouksteeuwe änthoolde',
	'securepasswords-uppercase' => 'ap minste ne Grootbouksteeuwe änthoolde',
	'securepasswords-digit' => 'ap minste een Ziffer änthoolde',
	'securepasswords-special' => 'ap minste een Sunnerteeken änthoolde (Sunnerteekene sunt: $1)',
	'securepasswords-username' => 'sik fon din Benutsernoome unnerskeede',
	'securepasswords-word' => 'wät uurs weese as n Woud',
);

/** Swedish (Svenska)
 * @author Najami
 */
$messages['sv'] = array(
	'securepasswords-desc' => 'Skapar säkrare lösenordshashar och lägger till en funktion för att kontrollera lösenordets styrka',
	'securepasswords-valid' => 'Ditt lösenord är ogiltigt eller för kort.
Det måste: $1.',
	'securepasswords-minlength' => 'ha en längd på minst {{PLURAL:$1|ett tecken|$1 tecken}}',
	'securepasswords-lowercase' => 'innehålla minst en liten bokstav',
	'securepasswords-uppercase' => 'innehålla minst en stor bokstav',
	'securepasswords-digit' => 'innehålla minst en siffra',
	'securepasswords-special' => 'innehålla minst ett specialtecken (specialtecknen är: $1)',
	'securepasswords-username' => 'inte vara samma som ditt användarnamn',
	'securepasswords-word' => 'inte vara ett ord',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'securepasswords-desc' => 'మరికొన్ని సంరక్షిత పాసువార్డు హాషులను సృష్టించి, పాసువార్డు బలము చూసే పనిముట్టుని కలుపుతుంది',
	'securepasswords-valid' => 'మీ సంకేతపదం సరైనది కాదు లేదా మరీ చిన్నగా ఉంది.
అది: $1.',
	'securepasswords-minlength' => 'కనీసం $1 {{PLURAL:$1|అక్షరం|అక్షరాల}} పొడవుండాలి',
	'securepasswords-lowercase' => 'కనీసం ఒక్క చిన్న బడి అక్షరాన్నైనా కలిగివుండాలి.',
	'securepasswords-uppercase' => 'కనీసం ఒక్క పెద్దబడి అక్షరాన్నైనా కలిగివుండాలి.',
	'securepasswords-digit' => 'కనీసం ఒక్క అంకెనైనా కలిగివుండాలి.',
	'securepasswords-special' => 'కనీసం 1 ప్రత్యేక అక్షరాన్నైనా కలిగివుండాలి (ప్రత్యేక అక్షరాలు ఇవీ: $1)',
	'securepasswords-username' => 'మీ వాడుకరిపేరు అయివుండకూడదు',
	'securepasswords-word' => 'ఒక పదం అయివుండకూడదు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'securepasswords-desc' => "Lumilikha ng mas higit na ligtas na mga panghalo (''hash'') ng hudyat at nagdaragdag ng isang tagapasuri ng lakas ng hudyat",
	'securepasswords-valid' => 'Hindi tanggap ang hudyat mo o napakaikli.
Dapat itong: $1.',
	'securepasswords-minlength' => 'may kahit na $1 {{PLURAL:$1|panitik|mga panitik}} ang haba',
	'securepasswords-lowercase' => 'maglaman ng kahit na 1 maliit na titik',
	'securepasswords-uppercase' => 'maglaman ng kahit na 1 malaking titik',
	'securepasswords-digit' => 'maglaman ng kahit na 1 tambilang (bilang)',
	'securepasswords-special' => 'maglaman ng kahit na 1 natatanging panitik (ang natatanging mga panitik ay: $1)',
	'securepasswords-username' => 'naiiba/kaiba mula sa iyong pangalan ng tagagamit',
	'securepasswords-word' => 'hindi isang salita',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'securepasswords-lowercase' => 'en az bir küçük harf içermektedir',
	'securepasswords-uppercase' => 'en az 1 büyük harf içermektedir',
	'securepasswords-digit' => 'en az 1 rakam içermektedir',
	'securepasswords-username' => 'kullanıcı adınızan farklı olacak',
	'securepasswords-word' => 'kelime olmayacak',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 */
$messages['uk'] = array(
	'securepasswords-desc' => 'Створює більш безпечний хеш для паролю і додає перевірку паролю на надійність',
	'securepasswords-valid' => 'Ваш пароль недійсний або надто короткий. 
Він повинен: $1.',
	'securepasswords-minlength' => 'Бути не менше $1 {{PLURAL:$1|символ|символа|символів}} в довжину.',
	'securepasswords-lowercase' => 'Повинен містить не менше 1 літери в нижньому реєстрі.',
	'securepasswords-uppercase' => 'Повинен містити не менше 1 літери в верхньому реєстрі.',
	'securepasswords-digit' => 'Повинен містити як мінімум 1 цифру.',
	'securepasswords-special' => 'Повинен містити як мінімум 1 спеціальний символ (допустимі спецсимволи: $1).',
	'securepasswords-username' => 'Повинен відрізнятись від імені вашого облікового запису.',
	'securepasswords-word' => 'Не повинен бути словниковим словом.',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'securepasswords-valid' => 'Teiden peitsana om vär vai lühüdahk.
Pidab säta se neniden käskusiden mödhe: $1.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'securepasswords-desc' => 'Tạo ra những bảng băm mật khẩu an toàn hơn và bổ sung một bộ kiểm tra độ mạnh mật khẩu',
	'securepasswords-valid' => 'Mật khẩu của bạn không hợp lệ hay ngắn quá.
Nó phải: $1.',
	'securepasswords-minlength' => 'tối thiểu là $1 {{PLURAL:$1|ký tự|ký tự}}',
	'securepasswords-lowercase' => 'có ít nhất một chữ nhỏ',
	'securepasswords-uppercase' => 'có ít nhất một chữ hoa',
	'securepasswords-digit' => 'có ít nhất một chữ số',
	'securepasswords-special' => 'có ít nhất một ký tự đặc biệt (tức là: $1)',
	'securepasswords-username' => 'khác với tên hiệu',
	'securepasswords-word' => 'không phải là từ',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'securepasswords-valid' => 'Letavöd olik no lonöfon u binon tu brefik.
Muton: $1.',
	'securepasswords-minlength' => 'labon lunoti {{PLURAL:$1|malata pu bala|malatas pu $1}}',
	'securepasswords-lowercase' => 'ninädön minudi pu bali',
	'securepasswords-uppercase' => 'ninädon mayudi pu bali',
	'securepasswords-digit' => 'ninädön numati pu bali',
	'securepasswords-special' => 'ninädon malati patik pu bali (malats patik binons: $1)',
	'securepasswords-username' => 'difön de gebananem olik',
	'securepasswords-word' => 'no binön vöd',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'securepasswords-desc' => '生成更安全的密码哈希值，并添加密码强度检测',
	'securepasswords-valid' => '您的密码无效或者太短。
它必须：$1。',
	'securepasswords-minlength' => '长度至少需要$1个字符',
	'securepasswords-lowercase' => '包含最少一个小写字母',
	'securepasswords-uppercase' => '包含最少一个大写字母',
	'securepasswords-digit' => '包含最少一个数字',
	'securepasswords-special' => '包含至少一个特殊字符 （特殊字符是：$1）',
	'securepasswords-username' => '不与您的用户名相同',
	'securepasswords-word' => '不是一个单词',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'securepasswords-desc' => '生成更安全的密碼哈希值，並添加密碼強度檢測',
	'securepasswords-valid' => '您的密碼無效或者太短。
它必須：$1。',
	'securepasswords-minlength' => '長度需要最少 $1 個字元',
	'securepasswords-lowercase' => '包含最少一個小寫字母',
	'securepasswords-uppercase' => '包含最少一個大寫字母',
	'securepasswords-digit' => '包含最少一個數字',
	'securepasswords-special' => '包含至少一個特殊字符 （特殊字符是：$1）',
	'securepasswords-username' => '不與您的使用者名稱相同',
	'securepasswords-word' => '不是一個單詞',
);

