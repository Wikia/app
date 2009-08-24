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
It must:',
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
 */
$messages['qqq'] = array(
	'securepasswords-desc' => 'Short desciption of this extension.
Shown in [[Special:Version]].
Do not translate or change tag names, or link anchors.',
	'securepasswords-username' => '{{gender}}
* (optional) $1 is the user name',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Ouda
 */
$messages['ar'] = array(
	'securepasswords-desc' => 'ينشئ هاشات كلمة سر أكثر أمنا ويضيف متحقق من قوة كلمة السر',
	'securepasswords-valid' => 'كلمة السر غير صحيحة أو قصيرة جدا.
يجب:',
	'securepasswords-minlength' => 'تكون على الأقل $1 {{PLURAL:$1|حرف|حرف}} طولا',
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
الباسورد لازم:',
	'securepasswords-minlength' => 'لازم طولها يكون ع الاقل $1 {{PLURAL:$1|حرف|حرف}}',
	'securepasswords-lowercase' => 'تحتوى على الأقل على حرف واحد صغير',
	'securepasswords-uppercase' => 'تحتوى على الأقل على حرف واحد كبير',
	'securepasswords-digit' => 'يحتوى على رقم واحد على الأقل',
	'securepasswords-special' => 'بتحتوى على رمز خاص واحد ع الاقل (الرموز الخاصه هما:$1)',
	'securepasswords-username' => 'تكون مختلفة عن اسم المستخدم',
	'securepasswords-word' => 'لا تكون كلمة',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'securepasswords-desc' => 'Стварае больш бясьпечныя хэшы пароляў і дадае палепшаную праверку сакрэтнасьці пароляў',
	'securepasswords-valid' => 'Ваш пароль няслушны ці занадта кароткі.
Павінен:',
	'securepasswords-minlength' => 'складацца хаця б $1 {{PLURAL:$1|сымбаль|сымбалі|сымбаляў}}',
	'securepasswords-lowercase' => 'утрымліваць хаця бы адну малую літару',
	'securepasswords-uppercase' => 'утрымліваць хаця бы адну вялікую літару',
	'securepasswords-digit' => 'утрымліваць хаця бы адну лічбу',
	'securepasswords-special' => 'утрымліваць хаця бы адзін спэцыяльны сымбаль (такі як: $1)',
	'securepasswords-username' => 'адрозьнівацца ад Вашага імя ўдзельніка',
	'securepasswords-word' => 'ня быць словам',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'securepasswords-desc' => 'Pravljenje mnogo sigurnijih haševa za šifre i dodaje provjeru jačine šifre',
	'securepasswords-valid' => 'Vaša šifra je nevaljana ili je prekratka.
Mora:',
	'securepasswords-minlength' => 'biti duga najmanje $1 {{PLURAL:$1|znak|znaka|znakova}}',
	'securepasswords-lowercase' => 'sadržavati najmanje 1 malo slovo',
	'securepasswords-uppercase' => 'sadržavati najmanje 1 veliko slovo',
	'securepasswords-digit' => 'sadržavati najmanje 1 cifru',
	'securepasswords-special' => 'sadržavati najmanje 1 specijalni znak (specijalni znakovi su: $1)',
	'securepasswords-username' => 'biti različita od Vašeg korisničkog imena',
	'securepasswords-word' => 'ne bude riječ',
);

/** German (Deutsch)
 * @author Melancholie
 * @author Umherirrender
 */
$messages['de'] = array(
	'securepasswords-desc' => 'Erzeugt sicherere Passwort-Hashes und fügt eine Passwortstärkenprüfung hinzu',
	'securepasswords-valid' => 'Dein Passwort ist ungültig oder zu kurz.
Es muss:',
	'securepasswords-minlength' => 'mindestens $1 {{PLURAL:$1|Zeichen|Zeichen}} lang sein',
	'securepasswords-lowercase' => 'mindestens einen Kleinbuchstaben enthalten',
	'securepasswords-uppercase' => 'mindestens einen Großbuchstaben enthalten',
	'securepasswords-digit' => 'mindestens eine Ziffer enthalten',
	'securepasswords-special' => 'mindestens ein Sonderzeichen enthalten (Sonderzeichen sind: $1)',
	'securepasswords-username' => 'sich von deinem Benutzernamen unterscheiden',
	'securepasswords-word' => 'etwas anderes sein als ein Wort',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'securepasswords-desc' => 'Napórajo wěsćejše gronidłowe hašy a pśidawa funkciju za kontrolěrowanje mócy gronidła.',
	'securepasswords-valid' => 'Twójo gronidło jo njepłaśiwe abo pśekrotko. Musy:',
	'securepasswords-minlength' => 'nanejmjenjej $1 {{PLURAL:$1|znamuško|znamušce|znamuška|znamuškow}} dłujke byś',
	'securepasswords-lowercase' => 'nanejmjenjej 1 mały pismik wopśimjeś',
	'securepasswords-uppercase' => 'nanejmjenjej 1 wjeliki pismik wopśimjeś',
	'securepasswords-digit' => 'nanejmjenjej 1 cyfru wopśimjeś',
	'securepasswords-special' => 'nanejmjenjej 1 specialne znamuško wopśimjeś (Specialne znamuška su: $1)',
	'securepasswords-username' => 'se wót twójogo wužywarske mjenja rozeznawaś',
	'securepasswords-word' => 'něco druge byś ako słowo',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'securepasswords-valid' => 'Tu contraseña es inválida o demasiado corta.
Debe ser:',
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
Honelakoa izan behar du:',
	'securepasswords-minlength' => 'Gutxienez, {{PLURAL:$1|karaktere $1|$1 karaktere}} luze izan behar du',
	'securepasswords-lowercase' => 'gutxienez hizki bat minuskulaz izan',
	'securepasswords-uppercase' => 'gutxienez letra larri bat izan',
	'securepasswords-digit' => 'gutxienez digitu bat izan',
	'securepasswords-special' => 'gutxienez karaktere berezi bat izan (Hauek dira karaktere bereziak: $1)',
	'securepasswords-username' => 'erabiltzaile izenetik desberdina izan',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'securepasswords-desc' => 'Luo turvallisempia salasanatiivisteitä ja lisää salasanan vahvuuden tarkistajan.',
	'securepasswords-valid' => 'Salasanasi ei kelpaa tai on liian lyhyt.
Sen pitää täyttää seuraavat ehdot:',
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
	'securepasswords-valid' => 'Votre mot de passe est invalide ou trop court. Il doit :',
	'securepasswords-minlength' => 'être long d’au moins $1 {{PLURAL:$1|caractère|caractères}}',
	'securepasswords-lowercase' => 'contenir au moins 1 lettre minuscule',
	'securepasswords-uppercase' => 'contenir au moins 1 lettre majuscule',
	'securepasswords-digit' => 'contenir au moins 1 chiffre',
	'securepasswords-special' => 'contenir au moins 1 caractère spécial (les caractères spéciaux sont : $1)',
	'securepasswords-username' => "être différent de votre nom d'utilisateur",
	'securepasswords-word' => 'ne pas être un mot',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'securepasswords-desc' => 'Crea un contrasinal cardinal máis seguro e engade un comprobador da fortaleza deste',
	'securepasswords-valid' => 'O seu contrasinal é inválido ou moi curto.
Debe:',
	'securepasswords-minlength' => 'ter, polo menos, {{PLURAL:$1|un carácter|$1 caracteres}}',
	'securepasswords-lowercase' => 'conter, polo menos, unha letra minúscula',
	'securepasswords-uppercase' => 'conter, polo menos, unha letra maiúscula',
	'securepasswords-digit' => 'conter, polo menos, un díxito',
	'securepasswords-special' => 'conter, polo menos, un carácter especial (caracteres especiais son: $1)',
	'securepasswords-username' => 'ser diferente do seu nome de usuario',
	'securepasswords-word' => 'non ser unha palabra',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'securepasswords-desc' => 'יצירת גיבובי סיסמאות מאובטחים יותר והוספת בודק חוזק סיסמאות',
	'securepasswords-valid' => 'הסיסמה שלכם אינה תקינה או קצרה מדי. עליה:',
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
	'securepasswords-valid' => 'Twoje hesło je njepłaćiwe abo překrótke. Dyrbi:',
	'securepasswords-minlength' => 'znajmjeńša $1 {{PLURAL:$1|znamješko|znamješce|znamješka|znamješkow}} dołhe być',
	'securepasswords-lowercase' => 'znajmjeńša 1 mały pismik wobsahować',
	'securepasswords-uppercase' => 'znajmjeńša 1 wulki pismik wobsahować',
	'securepasswords-digit' => 'znajmjeńša 1 cyfru wobsahować',
	'securepasswords-special' => 'znajmjeńša 1 specialne znamješko wobsahować (Specialne znamješka su: $1)',
	'securepasswords-username' => 'so wot twojeho wužywarskeho mjena rozeznać',
	'securepasswords-word' => 'něšto druhe być hač słowo',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'securepasswords-desc' => 'Crea hashes plus secur del contrasignos e adde un verificator de complexitate de contrasignos',
	'securepasswords-valid' => 'Tu contrasigno es invalide o troppo curte.
Illo debe:',
	'securepasswords-minlength' => 'esser al minus $1 {{PLURAL:$1|character|characteres}} de longitude',
	'securepasswords-lowercase' => 'continer al minus 1 littera minuscule',
	'securepasswords-uppercase' => 'continer al minus 1 littera majuscule',
	'securepasswords-digit' => 'continer al minus 1 digito',
	'securepasswords-special' => 'continer al minus 1 character special (le characteres special es: $1)',
	'securepasswords-username' => 'esser differente de tu nomine de usator',
	'securepasswords-word' => 'non esser un parola',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Mizusumashi
 */
$messages['ja'] = array(
	'securepasswords-desc' => 'より安全なパスワードのハッシュを生成し、パスワード強度検査器を追加する',
	'securepasswords-valid' => 'あなたのパスワードは不正であるか、または短すぎます。
以下を充たさなければなりません:',
	'securepasswords-minlength' => '$1文字以上の長さである',
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
វា​ត្រូវតែ:',
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
비밀번호는 반드시:',
	'securepasswords-minlength' => '적어도 $1글자 이상이어야 합니다.',
	'securepasswords-lowercase' => '적어도 1개의 소문자가 있어야 합니다.',
	'securepasswords-uppercase' => '적어도 1개의 대문자를 포함해야 합니다.',
	'securepasswords-digit' => '적어도 1개의 숫자를 포함해야 합니다.',
	'securepasswords-special' => '적어도 1개의 특수 문자를 포함해야 합니다. (특수 문자: $1)',
	'securepasswords-username' => '당신의 계정 이름과 달라야 합니다.',
	'securepasswords-word' => '단어가 아니어야 합니다.',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'securepasswords-desc' => 'Deiht en Pröfung för de Passwoote ier Qualiteit em Wiki dobei, un määt en besser (seechere) Verschlößelung för de Passwoote.',
	'securepasswords-valid' => 'Ding Paßwoot is onjöltisch udder ze koot.
Et mööt:',
	'securepasswords-minlength' => 'winnishßtens {{PLURAL:$1|ei|$1|kei}} Zeiche lang sin',
	'securepasswords-lowercase' => 'winnischßdens eine kleine Bochstabe enthallde',
	'securepasswords-uppercase' => 'winnischßdens eine jroße Bochstabe enthallde',
	'securepasswords-digit' => 'winnischßdens ein Zeffer enthallde',
	'securepasswords-special' => 'winnischßdens ei Sönderzeiche enthallde. De Sönderzeiche sinn_er: $1',
	'securepasswords-username' => 'anders wi Dinge Metmaachername sinn',
	'securepasswords-word' => 'kein nomaal Woot sin',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'securepasswords-desc' => "Mécht méi sécher Paswuert-''Hashes'' a setzt eng Iwwerpréifung vun der Sécherheet vun de Passwierder derbäi",
	'securepasswords-valid' => 'Ärt Passwuert ass net valabel oder ze kuerz.
Et:',
	'securepasswords-minlength' => 'muss mindestens $1 {{PLURAL:$1|Zeeche|Zeeche}} laang sinn',
	'securepasswords-lowercase' => 'muss mindestens 1 klenge Buchstaw dra sinn',
	'securepasswords-uppercase' => 'muss mindestens 1 grousse Buchstaw dra sinn',
	'securepasswords-digit' => 'muss mindestens 1 Ziffer dra sinn',
	'securepasswords-special' => 'muss mndestens 1 Spezialzeechen dra sinn (Spezialzeeche sinn: $1)',
	'securepasswords-username' => 'muss verschidde vun Ärem Benotzernumm sinn',
	'securepasswords-word' => 'däerf kee Wuert sinn',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'securepasswords-word' => 'ahmo tlahtōl',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'securepasswords-desc' => 'Gebruikt veiliger wachtwoordhashes en voegt een wachtwoordsterktecontrole toe',
	'securepasswords-valid' => 'Uw wachtwoord voldoet niet aan de voorwaarden.
Het moet:',
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
Det må:',
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
Deu :',
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
	'securepasswords-valid' => 'Twoje hasło jest nieprawidłowe lub zbyt krótkie.
Musi:',
	'securepasswords-minlength' => 'składać się z co najmniej $1 {{PLURAL:$1|znaku|znaków}}',
	'securepasswords-lowercase' => 'zawierać co najmniej 1 małą literę',
	'securepasswords-uppercase' => 'zawierać co najmniej 1 wielką literę',
	'securepasswords-digit' => 'zawierać co najmniej 1 cyfrę',
	'securepasswords-special' => 'zawierać co najmniej 1 znak specjalny (taki jak: $1)',
	'securepasswords-username' => 'różnić się od Twojej nazwy użytkownika',
	'securepasswords-word' => 'nie być słowem',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'securepasswords-desc' => 'Cria hashes de palavras-chaves mais seguros e adiciona um verificador da força da palavra-chave',
	'securepasswords-valid' => 'A sua palavra-chave é inválida ou demasiado curta.
Tem de:',
	'securepasswords-minlength' => 'ter pelo menos $1 {{PLURAL:$1|caracter|caracteres}} de comprimento',
	'securepasswords-lowercase' => 'conter pelo menos 1 letra minúscula',
	'securepasswords-uppercase' => 'conter pelo menos 1 letra maiúscula',
	'securepasswords-digit' => 'conter pelo menos 1 dígito',
	'securepasswords-special' => 'conter pelo menos 1 caracter especial (caracteres especiais são: $1)',
	'securepasswords-username' => 'ser diferente do seu nome de utilizador',
	'securepasswords-word' => 'não ser uma palavra',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'securepasswords-desc' => 'Cria "hashes" de palavras-chaves mais seguros e adiciona um verificador da força da palavra-chave',
	'securepasswords-valid' => 'A sua palavra-chave é inválida ou muito curta.
Tem de:',
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
Aceasta trebuie:',
	'securepasswords-minlength' => 'să fie de cel puţin $1 {{PLURAL:$1|caracter|caractere}} lungime',
	'securepasswords-lowercase' => 'să conţină cel puţin o literă mică',
	'securepasswords-uppercase' => 'să conţină cel puţin o literă mare',
	'securepasswords-digit' => 'să conţină cel puţin o cifră',
	'securepasswords-special' => 'să conţină cel puţin un caracter special (caracterele speciale sunt: $1)',
	'securepasswords-username' => 'să fie diferită de numele de utilizator',
	'securepasswords-word' => 'să nu fie un cuvânt',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'securepasswords-valid' => "'A password toje jè invalida o troppe cuciule.
Adda essere:",
	'securepasswords-username' => "differende da 'u nome utende tue",
	'securepasswords-word' => "non g'addà essere 'na parole",
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'securepasswords-username' => 'будет отличаться от вашего имени участника',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Rudko
 */
$messages['sk'] = array(
	'securepasswords-desc' => 'Vytvára bezpečnejšie haše hesiel a pridáva kontrolu sily hesla',
	'securepasswords-valid' => 'Vaše heslo je nesprávne alebo príliš krátke.',
	'securepasswords-minlength' => 'musí byť dlhé aspoň $1 {{PLURAL:$1|znak|znaky|znakov}}',
	'securepasswords-lowercase' => 'musí obsahovať aspoň jedno malé písmeno',
	'securepasswords-uppercase' => 'musí obsahovať aspoň jedno veľké písmeno',
	'securepasswords-digit' => 'musí obsahovať aspoň jednu číslicu',
	'securepasswords-special' => 'musí obsahovať aspoň jeden špeciálny znak (povolené špeciálne znaky: $1)',
	'securepasswords-username' => 'musí byť iné ako vaše používateľské meno',
	'securepasswords-word' => 'nesmie to byť slovo zo slovníka',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'securepasswords-desc' => 'Moaket sicherere Paaswoud-Hashes un föiget ne Paaswoudstäärken-Wröige bietou',
	'securepasswords-valid' => 'Dien Paaswoud is uungultich of tou kuut.
Et mout:',
	'securepasswords-minlength' => 'ap minste $1 Teekene loang weese',
	'securepasswords-lowercase' => 'ap minste ne Littikbouksteeuwe änthoolde',
	'securepasswords-uppercase' => 'ap minste ne Grootbouksteeuwe änthoolde',
	'securepasswords-digit' => 'ap minste een Ziffer änthoolde',
	'securepasswords-special' => 'ap minste een Sunnerteeken änthoolde (Sunnerteekene sunt: $1)',
	'securepasswords-username' => 'sik fon din Benutsernoome unnerscheede',
	'securepasswords-word' => 'wät uurs weese as n Woud',
);

/** Swedish (Svenska)
 * @author Najami
 */
$messages['sv'] = array(
	'securepasswords-desc' => 'Skapar säkrare lösenordshashar och lägger till en funktion för att kontrollera lösenordets styrka',
	'securepasswords-valid' => 'Ditt lösenord är ogiltigt eller för kort.
Det måste:',
	'securepasswords-minlength' => 'ha en längd på minst {{PLURAL:$1|ett tecken|$1 tecken}}',
	'securepasswords-lowercase' => 'innehålla minst en liten bokstav',
	'securepasswords-uppercase' => 'innehålla minst en stor bokstav',
	'securepasswords-digit' => 'innehålla minst en siffra',
	'securepasswords-special' => 'innehålla minst ett specialtecken (specialtecknen är: $1)',
	'securepasswords-username' => 'inte vara samma som ditt användarnamn',
	'securepasswords-word' => 'inte vara ett ord',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'securepasswords-valid' => 'మీ సంకేతపదం సరైనది కాదు లేదా మరీ చిన్నగా ఉంది.
అది:',
	'securepasswords-minlength' => 'కనీసం $1 {{PLURAL:$1|అక్షరం|అక్షరాల}} పొడవుండాలి',
	'securepasswords-lowercase' => 'కనీసం ఒక్క చిన్న బడి అక్షరాన్నైనా కలిగివుండాలి.',
	'securepasswords-uppercase' => 'కనీసం ఒక్క పెద్దబడి అక్షరాన్నైనా కలిగివుండాలి.',
	'securepasswords-digit' => 'కనీసం ఒక్క అంకెనైనా కలిగివుండాలి.',
	'securepasswords-special' => 'కనీసం 1 ప్రత్యేక అక్షరాన్నైనా కలిగివుండాలి (ప్రత్యేక అక్షరాలు ఇవీ: 1)',
	'securepasswords-username' => 'మీ వాడుకరిపేరు అయివుండకూడదు',
	'securepasswords-word' => 'ఒక పదం అయివుండకూడదు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'securepasswords-desc' => "Lumilikha ng mas higit na ligtas na mga panghalo (''hash'') ng hudyat at nagdaragdag ng isang tagapasuri ng lakas ng hudyat",
	'securepasswords-valid' => 'Hindi tanggap ang hudyat mo o napakaikli.
Dapat itong:',
	'securepasswords-minlength' => 'may kahit na $1 {{PLURAL:$1|panitik|mga panitik}} ang haba',
	'securepasswords-lowercase' => 'maglaman ng kahit na 1 maliit na titik',
	'securepasswords-uppercase' => 'maglaman ng kahit na 1 malaking titik',
	'securepasswords-digit' => 'maglaman ng kahit na 1 tambilang (bilang)',
	'securepasswords-special' => 'maglaman ng kahit na 1 natatanging panitik (ang natatanging mga panitik ay: $1)',
	'securepasswords-username' => 'naiiba/kaiba mula sa iyong pangalan ng tagagamit',
	'securepasswords-word' => 'hindi isang salita',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'securepasswords-valid' => 'Letavöd olik no lonöfon u binon tu brefik.
Muton:',
	'securepasswords-minlength' => 'labon lunoti {{PLURAL:$1|malata pu bala|malatas pu $1}}',
	'securepasswords-lowercase' => 'ninädön minudi pu bali',
	'securepasswords-uppercase' => 'ninädon mayudi pu bali',
	'securepasswords-digit' => 'ninädön numati pu bali',
	'securepasswords-special' => 'ninädon malati patik pu bali (malats patik binons: $1)',
	'securepasswords-username' => 'difön de gebananem olik',
	'securepasswords-word' => 'no binön vöd',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'securepasswords-minlength' => '长度至少需要$1个字符',
	'securepasswords-lowercase' => '包含最少一个小写字母',
	'securepasswords-uppercase' => '包含最少一个大写字母',
	'securepasswords-digit' => '包含最少一个数字',
	'securepasswords-username' => '不与您的用户名相同',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'securepasswords-minlength' => '長度需要最少$1個字元',
	'securepasswords-lowercase' => '包含最少1個小寫字母',
	'securepasswords-uppercase' => '包含最少1個大寫字母',
	'securepasswords-digit' => '包含最少1個數字',
	'securepasswords-username' => '不與您的使用者名稱相同',
);

