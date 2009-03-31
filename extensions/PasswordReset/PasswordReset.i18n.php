<?php
#coding: utf-8
/** \file
* \brief Internationalization file for the Password Reset Extension.
*/

$messages = array();

$messages['en'] = array(
	'passwordreset'                    => 'Password reset',
	'passwordreset-desc'               => "[[Special:PasswordReset|Resets wiki user's passwords]] - requires 'passwordreset' privileges",
	'passwordreset-invalidusername'    => 'Invalid username',
	'passwordreset-emptyusername'      => 'Empty username',
	'passwordreset-nopassmatch'        => 'Passwords do not match',
	'passwordreset-badtoken'           => 'Invalid edit token',
	'passwordreset-username'           => 'Username:',
	'passwordreset-newpass'            => 'New password:',
	'passwordreset-confirmpass'        => 'Confirm password:',
	'passwordreset-submit'             => 'Reset password',
	'passwordreset-success'            => 'Password has been reset for user ID: $1',
	'passwordreset-disableuser'        => 'Disable user account?',
	'passwordreset-disableuserexplain' => '(sets an invalid password hash - user cannot login)',
	'passwordreset-disablesuccess'     => 'User account has been disabled for user ID: $1',
	'passwordreset-accountdisabled'    => 'Account has been disabled',
	'disabledusers'                    => 'Disabled users',
	'disabledusers-summary'            => 'This is a list of users that have been disabled via PasswordReset.',
	'right-passwordreset'              => 'Reset password of a user ([[Special:PasswordReset|special page]])',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author McDutchie
 * @author Purodha
 */
$messages['qqq'] = array(
	'passwordreset-desc' => 'Short description of this extension, shown on [[Special:Version]]. Do not translate or change links.',
	'passwordreset-badtoken' => '{{Identical|Invalid edit token}}',
	'passwordreset-username' => '{{Identical|Username}}',
	'passwordreset-newpass' => '{{Identical|New password}}',
	'passwordreset-submit' => '{{Identical|Reset password}}',
	'right-passwordreset' => '{{doc-right}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'passwordreset-username' => 'Asa',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'passwordreset-username' => 'Matahigoa he tagata',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'passwordreset-username' => 'Gebruikersnaam',
	'passwordreset-newpass' => 'Nuwe wagwoord',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'passwordreset-submit' => 'Restablir a palabra de paso',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'passwordreset' => 'تمت إعادة ضبط كلمة السر',
	'passwordreset-desc' => "[[Special:PasswordReset|يعيد ضبط كلمات سر مستخدم ويكي]] - يحتاج إلى صلاحيات 'passwordreset'",
	'passwordreset-invalidusername' => 'اسم مستخدم غير صحيح',
	'passwordreset-emptyusername' => 'اسم مستخدم فارغ',
	'passwordreset-nopassmatch' => 'كلمات السر لا تتطابق',
	'passwordreset-badtoken' => 'نص تعديل غير صحيح',
	'passwordreset-username' => 'اسم المستخدم:',
	'passwordreset-newpass' => 'كلمة سر جديدة:',
	'passwordreset-confirmpass' => 'أكد كلمة السر:',
	'passwordreset-submit' => 'أعد ضبط كلمة السر',
	'passwordreset-success' => 'كلمة السر تم ضبطها ل user_id: $1',
	'passwordreset-disableuser' => 'عطل حساب المستخدم؟',
	'passwordreset-disableuserexplain' => '(يضبط هاش كلمة سر غير صحيح - المستخدم لا يمكنه الدخول)',
	'passwordreset-disablesuccess' => 'حساب المستخدم تم تعطيله (رقم_المستخدم: $1)',
	'passwordreset-accountdisabled' => 'الحساب تم تعطيله',
	'disabledusers' => 'مستخدمون معطلون',
	'disabledusers-summary' => 'هذه قائمة بالمستخدمين الذين تم تعطيلهم من خلال إعادة ضبط كلمة السر.',
	'right-passwordreset' => 'إعادة ضبط كلمة سر مستخدم([[Special:PasswordReset|صفحة خاصة]])',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'passwordreset' => 'تمت إعادة ضبط كلمة السر',
	'passwordreset-desc' => "[[Special:PasswordReset|يعيد ضبط كلمات سر مستخدم ويكي]] - يحتاج إلى صلاحيات 'passwordreset'",
	'passwordreset-invalidusername' => 'اسم مستخدم غير صحيح',
	'passwordreset-emptyusername' => 'اسم مستخدم فارغ',
	'passwordreset-nopassmatch' => 'كلمات السر لا تتطابق',
	'passwordreset-badtoken' => 'نص تعديل غير صحيح',
	'passwordreset-username' => 'اسم اليوزر:',
	'passwordreset-newpass' => 'باسورد جديدة:',
	'passwordreset-confirmpass' => 'اكد الباسورد:',
	'passwordreset-submit' => 'أعد ضبط كلمة السر',
	'passwordreset-success' => 'كلمة السر تم ضبطها ل user_id: $1',
	'passwordreset-disableuser' => 'عطل حساب المستخدم؟',
	'passwordreset-disableuserexplain' => '(يضبط هاش كلمة سر غير صحيح - المستخدم لا يمكنه الدخول)',
	'passwordreset-disablesuccess' => 'حساب المستخدم تم تعطيله (رقم_المستخدم: $1)',
	'passwordreset-accountdisabled' => 'الحساب تم تعطيله',
	'disabledusers' => 'مستخدمون معطلون',
	'disabledusers-summary' => 'هذه قائمة بالمستخدمين الذين تم تعطيلهم من خلال إعادة ضبط كلمة السر.',
	'right-passwordreset' => 'إعادة ضبط كلمة سر مستخدم([[Special:PasswordReset|صفحة خاصة]])',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'passwordreset-invalidusername' => 'Невалидно потребителско име',
	'passwordreset-emptyusername' => 'Празно потребителско име',
	'passwordreset-nopassmatch' => 'Паролите не съвпадат',
	'passwordreset-username' => 'Потребителско име:',
	'passwordreset-newpass' => 'Нова парола:',
	'passwordreset-confirmpass' => 'Парола (повторно):',
	'passwordreset-disableuser' => 'Деактивиране на потребителската сметка?',
	'passwordreset-disablesuccess' => 'Потребителската сметка беше деактивирана (потребителски номер: $1)',
	'passwordreset-accountdisabled' => 'Потребителската сметка беше деактивирана',
	'disabledusers' => 'Деактивирани потребителски сметки',
	'disabledusers-summary' => 'Това е списък с потребителски сметки, които са били деактивирани чрез PasswordReset.',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Mormegil
 */
$messages['cs'] = array(
	'passwordreset' => 'Reset hesla',
	'passwordreset-desc' => 'Umožňuje [[Special:PasswordReset|vygenerování nového hesla uživateli]]. Vyžaduje oprávnění „passwordreset“.',
	'passwordreset-invalidusername' => 'Neplatné uživatelské jméno',
	'passwordreset-emptyusername' => 'Nevyplněné uživatelské jméno',
	'passwordreset-nopassmatch' => 'Hesla se neshodují',
	'passwordreset-badtoken' => 'Neplatný editační token',
	'passwordreset-username' => 'Uživatelské jméno:',
	'passwordreset-newpass' => 'Nové heslo:',
	'passwordreset-confirmpass' => 'Potvrdit heslo:',
	'passwordreset-submit' => 'Resetovat heslo',
	'passwordreset-success' => 'Heslo uživatele s ID $1 bylo resetováno',
	'passwordreset-disableuser' => 'Deaktivovat uživatelský účet?',
	'passwordreset-disableuserexplain' => '(nastaví neplatný hash hesla – uživatel se tak nebude moci přihlásit)',
	'passwordreset-disablesuccess' => 'Uživatelský účet pro uživatelské ID $1 byl deaktivovaný',
	'passwordreset-accountdisabled' => 'Účet byl deaktivovaný',
	'disabledusers' => 'Deaktivovaní uživatelé',
	'disabledusers-summary' => 'Toto je seznam uživatelů, kteří byli deaktivováni pomocí PasswordReset.',
	'right-passwordreset' => 'Reset hesla uživatele ([[Special:PasswordReset|speciální stránka]])',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'passwordreset-username' => 'по́льꙃєватєлꙗ и́мѧ',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'passwordreset-username' => 'Brugernavn',
	'passwordreset-newpass' => 'Ny adgangskode',
	'passwordreset-submit' => 'Nullstille passord',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'passwordreset' => 'Passwort zurücksetzen',
	'passwordreset-desc' => "[[Special:PasswordReset|Zurücksetzen eines Benutzer-Passwortes]] - ''passwordreset''-Recht notwendig",
	'passwordreset-invalidusername' => 'Ungültiger Benutzername',
	'passwordreset-emptyusername' => 'Leerer Benutzername',
	'passwordreset-nopassmatch' => 'Passwörter stimmen nicht überein',
	'passwordreset-badtoken' => 'Ungültiger „Edit Token“',
	'passwordreset-username' => 'Benutzername:',
	'passwordreset-newpass' => 'Neues Passwort:',
	'passwordreset-confirmpass' => 'Passwort bestätigen:',
	'passwordreset-submit' => 'Passwort zurücksetzen',
	'passwordreset-success' => 'Passwort für Benutzer-ID $1 wurde zurückgesetzt.',
	'passwordreset-disableuser' => 'Benutzerkonto deaktivieren?',
	'passwordreset-disableuserexplain' => '(setzen eines ungültigen Passwort-Hashs - Anmelden unmöglich)',
	'passwordreset-disablesuccess' => 'Benutzerkonto für Benutzer-ID $1 wurde deaktiviert.',
	'passwordreset-accountdisabled' => 'Benutzerkonto ist deaktiviert',
	'disabledusers' => 'Deaktivierte Benutzerkonten',
	'disabledusers-summary' => 'Dies ist die Liste der deaktivierten Benutzerkonten (via PasswordReset).',
	'right-passwordreset' => 'Passwort eines Benutzers zurücksetzen ([[Special:PasswordReset|Spezialseite]])',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'passwordreset' => 'Gronidło slědk stajiś',
	'passwordreset-desc' => "[[Special:PasswordReset|Staja gronidła wikijowego wužywarja slědk]] - pomina se priwilegije 'passwordreset'",
	'passwordreset-invalidusername' => 'Njepłaśiwe wužywarske mě',
	'passwordreset-emptyusername' => 'Prozne wužywarske mě',
	'passwordreset-nopassmatch' => 'Gronidła se njekšyju',
	'passwordreset-badtoken' => 'Njepłaśiwy wobźěłowański token',
	'passwordreset-username' => 'Wužywarske mě:',
	'passwordreset-newpass' => 'Nowe gronidło:',
	'passwordreset-confirmpass' => 'Gronidło wobkšuśiś:',
	'passwordreset-submit' => 'Gronidło slědk stajiś',
	'passwordreset-success' => 'Gronidło jo se slědk stajiło za wužywarski ID: $1',
	'passwordreset-disableuser' => 'Wužywarske konto znjemóžniś?',
	'passwordreset-disableuserexplain' => ')staja njepłaśiwy gronidłowy haš - wužywaŕ njamóžo se pśizjawiś)',
	'passwordreset-disablesuccess' => 'Wužywarske konto jo se znjemóžniło za wužywarski ID: $1',
	'passwordreset-accountdisabled' => 'Konto jo se znjemóžniło',
	'disabledusers' => 'Znjemóžnjone wužywarje',
	'disabledusers-summary' => 'To jo lisćina wužywarjow, kótarež su se znjemóžnili pśez PasswordReset.',
	'right-passwordreset' => 'Gronidło wužywarja slědk stajiś ([[Special:PasswordReset|specialny bok]])',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'passwordreset' => 'Κωδικός επαναφοράς',
	'passwordreset-invalidusername' => 'Άκυρο όνομα χρήστη',
	'passwordreset-emptyusername' => 'Κενό όνομα χρήστη',
	'passwordreset-nopassmatch' => 'Οι Κωδικοί δεν αντιστοιχούν',
	'passwordreset-username' => 'Όνομα χρήστη',
	'passwordreset-newpass' => 'Νέος Κωδικός',
	'passwordreset-confirmpass' => 'Επιβεβαιώστε τον κωδικό πρόσβασης',
	'passwordreset-submit' => 'Επαναφορά κωδικού',
	'passwordreset-success' => 'Ο κωδικός έχει επαναφερθεί για τον user_id: $1',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'passwordreset' => 'Restarigo de pasvorto',
	'passwordreset-invalidusername' => 'Nevalida Salutnomo',
	'passwordreset-emptyusername' => 'Malplena Salutnomo',
	'passwordreset-nopassmatch' => 'Pasvortoj ne estas samaj',
	'passwordreset-username' => 'Salutnomo:',
	'passwordreset-newpass' => 'Nova pasvorto:',
	'passwordreset-confirmpass' => 'Konfirmi pasvorton:',
	'passwordreset-submit' => 'Refari pasvorton',
	'passwordreset-success' => 'Pasvorto estis restarigita por user_id: $1',
	'passwordreset-disableuser' => 'Ĉu ja malebligu konton de uzanto?',
	'passwordreset-disablesuccess' => 'Konto de uzanto estis malebligita (uzanto-identigo: $1)',
	'passwordreset-accountdisabled' => 'Konto estis malŝaltita',
	'disabledusers' => 'Malebligitaj uzantoj',
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'passwordreset-username' => 'Nombre de usuario:',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Mobe
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'passwordreset' => 'Salasanan alustus',
	'passwordreset-desc' => "[[Special:PasswordReset|Alustaa käyttäjän salasanan]] – vaatii ''passwordreset''-oikeuden.",
	'passwordreset-invalidusername' => 'Virheellinen käyttäjätunnus',
	'passwordreset-emptyusername' => 'Tyhjä käyttäjätunnus',
	'passwordreset-nopassmatch' => 'Salasanat eivät vastaa toisiaan',
	'passwordreset-username' => 'Käyttäjätunnus',
	'passwordreset-newpass' => 'Uusi salasana',
	'passwordreset-confirmpass' => 'Vahvista salasana',
	'passwordreset-submit' => 'Alusta salasana',
	'passwordreset-success' => 'Käyttäjän numero $1 salasana on alustettu.',
	'passwordreset-disableuser' => 'Poista käyttäjätunnus käytöstä?',
	'passwordreset-disableuserexplain' => '(asettaa käyttäjälle virheellisen salasanatiivisteen, jolloin käyttäjä ei voi kirjautua sisään)',
	'passwordreset-disablesuccess' => 'Käyttäjätunnus on poistettu käytöstä. Käyttäjän numero on $1.',
	'passwordreset-accountdisabled' => 'Käyttäjätunnus on poistettu käytöstä',
	'disabledusers' => 'Käytöstä poistetut tunnukset',
	'disabledusers-summary' => 'Tämä on luettelo käyttäjistä, joiden tunnus on poistettu käytöstä PasswordResetillä.',
	'right-passwordreset' => 'Alustaa käyttäjän salasana ([[Special:PasswordReset|toimintosivu alustamiseen]])',
);

/** French (Français)
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'passwordreset' => 'Remise à zéro du mot de passe',
	'passwordreset-desc' => '[[Special:PasswordReset|Réinitialise le mot de passe wiki d’un utilisateur]] - nécessite les droits de « passwordreset »',
	'passwordreset-invalidusername' => "Nom d'usager inconnu",
	'passwordreset-emptyusername' => "Nom d'usager vide",
	'passwordreset-nopassmatch' => 'Les mots de passe que vous avez saisis ne sont pas identiques.',
	'passwordreset-badtoken' => 'Jeton de modification inconnu',
	'passwordreset-username' => "Nom d'utilisateur :",
	'passwordreset-newpass' => 'Nouveau mot de passe :',
	'passwordreset-confirmpass' => 'Confirmez le mot de passe :',
	'passwordreset-submit' => 'Remise à zéro du mot de passe',
	'passwordreset-success' => 'Le mot de passe a été remis à zéro pour l’usager $1.',
	'passwordreset-disableuser' => 'Désactiver le compte utilisateur ?',
	'passwordreset-disableuserexplain' => '(spécifie un hachage de mot de passe invalide - l’utilisateur ne pourra pas se connecter)',
	'passwordreset-disablesuccess' => 'Compte utilisateur désactivé (user_id : $1)',
	'passwordreset-accountdisabled' => 'Ce compte a été désactivé.',
	'disabledusers' => 'Utilisateurs désactivés',
	'disabledusers-summary' => 'Ceci est la liste des utilisateurs qui ont été désactivés par PasswordReset.',
	'right-passwordreset' => 'Réinitialise le mot de passe d’un utilisateur ([[Special:PasswordReset|page spéciale]])',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'passwordreset-username' => 'Meidoggernamme',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'passwordreset' => 'Eliminar o contrasinal',
	'passwordreset-desc' => '[[Special:PasswordReset|Restablecer o contrasinal do usuario dun wiki]] (require privilexios "passwordreset")',
	'passwordreset-invalidusername' => 'Nome de usuario non válido',
	'passwordreset-emptyusername' => 'Nome de usuario baleiro',
	'passwordreset-nopassmatch' => 'Os contrasinais non coinciden',
	'passwordreset-badtoken' => 'Sinal de edición non válido',
	'passwordreset-username' => 'Nome de usuario:',
	'passwordreset-newpass' => 'Novo contrasinal:',
	'passwordreset-confirmpass' => 'Confirme o contrasinal:',
	'passwordreset-submit' => 'Restablecer o contrasinal',
	'passwordreset-success' => 'Limpouse o contrasinal para o id de usuario: $1',
	'passwordreset-disableuser' => 'Desactivar a Conta de Usuario?',
	'passwordreset-disableuserexplain' => '(fixa un contrasinal hash inválido - o usuario non pode acceder ao sistema)',
	'passwordreset-disablesuccess' => 'Desactivouse a conta do usuario (user_id: $1)',
	'passwordreset-accountdisabled' => 'A conta foi desabilitada',
	'disabledusers' => 'Usuarios desabilitados',
	'disabledusers-summary' => 'Esta é unha listaxe dos usuarios que foron deshabilitados por medio de PasswordReset.',
	'right-passwordreset' => 'Restablecer o contrasinal dun usuario ([[Special:PasswordReset|páxina especial]])',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'passwordreset-username' => 'Ὄνομα χρωμένου:',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'passwordreset-username' => "Dt'ennym ymmydeyr",
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'passwordreset-username' => 'Yung-fu-miàng',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'passwordreset' => 'איפוס סיסמה',
	'passwordreset-desc' => '[[Special:PasswordReset|איפוס סיסמאות המשתמשים בוויקי]] - נדרשת הרשאת passwordreset',
	'passwordreset-invalidusername' => 'שם המשתמש שגוי',
	'passwordreset-emptyusername' => 'שם המשתמש ריק',
	'passwordreset-nopassmatch' => 'הסיסמאות אינן תואמות',
	'passwordreset-badtoken' => 'אסימון העריכה שגוי',
	'passwordreset-username' => 'שם משתמש:',
	'passwordreset-newpass' => 'סיסמה חדשה:',
	'passwordreset-confirmpass' => 'חזרו על הסיסמה:',
	'passwordreset-submit' => 'איפוס הסיסמה',
	'passwordreset-success' => 'הסיסמה אופסה עבור משתמש מספר: $1',
	'passwordreset-disableuser' => 'האם לבטל את חשבון המשתמש?',
	'passwordreset-disableuserexplain' => '(הגדרת גיבוב סיסמה בלתי תקין - המשתמש לא יוכל להיכנס לחשבון)',
	'passwordreset-disablesuccess' => 'חשבון המשתמש בוטל עבור משתמש מספר: $1',
	'passwordreset-accountdisabled' => 'החשבון בוטל',
	'disabledusers' => 'משתמשים שחשבונם בוטל',
	'disabledusers-summary' => 'זוהי רשימת המשתמשים שחשבונם בוטל דרך איפוס־הסיסמה (PasswordReset).',
	'right-passwordreset' => 'איפוס סיסמה של משתמש ([[Special:PasswordReset|דף מיוחד]])',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'passwordreset' => 'कूटशब्द रिसैट',
	'passwordreset-desc' => "विकिसदस्य का कूटशब्द पूर्ववत करें - इसके लिये 'passwordreset' अधिकार होना आवश्यक हैं",
	'passwordreset-invalidusername' => 'अवैध सदस्यनाम',
	'passwordreset-emptyusername' => 'खाली सदस्यनाम',
	'passwordreset-nopassmatch' => 'कूटशब्द मिलते नहीं',
	'passwordreset-badtoken' => 'गलत एडिट टोकन',
	'passwordreset-username' => 'सदस्यनाम',
	'passwordreset-newpass' => 'नया कूटशब्द',
	'passwordreset-confirmpass' => 'कूटशब्द निश्चित करें',
	'passwordreset-submit' => 'कूटशब्द रिसैट करें',
	'passwordreset-success' => 'निम्नलिखित सदस्य क्रमांक का कूटशब्द पूर्ववत कर दिया गया हैं: $1',
	'passwordreset-disableuser' => 'सदस्य खाता बंद करें?',
	'passwordreset-disableuserexplain' => '(कूटशब्दमें एक गलत हॅश लिखता हैं - सदस्य लॉग इन नहीं कर सकता)',
	'passwordreset-disablesuccess' => 'सदस्या खाता बंद कर दिया गया हैं (सदस्य क्रमांक: $1)',
	'passwordreset-accountdisabled' => 'खाता बंद कर दिया गया हैं',
	'disabledusers' => 'बंद किये हुए खाता',
	'disabledusers-summary' => 'यह ऐसे सदस्योंकी सूची हैं जिनके खाते PasswordReset का इस्तेमाल करके बंद कर दिये गये हैं।',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'passwordreset-username' => 'Ngalan sang Manog-gamit',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'passwordreset' => 'Ponovno postavi lozinku',
	'passwordreset-desc' => "[[Special:PasswordReset|Ponovo postavljanje lozinke wiki suradnika]] - zahtijeva 'passwordreset' pravo",
	'passwordreset-invalidusername' => 'Neispravno suradničko ime',
	'passwordreset-emptyusername' => 'Prazno suradničko ime',
	'passwordreset-nopassmatch' => 'Lozinke se ne poklapaju',
	'passwordreset-badtoken' => 'Neispravan edit token',
	'passwordreset-username' => 'Suradničko ime:',
	'passwordreset-newpass' => 'Nova lozinka:',
	'passwordreset-confirmpass' => 'Potvrdi lozinku:',
	'passwordreset-submit' => 'Postavi lozinku',
	'passwordreset-success' => 'Lozinka je ponovno postavljena za user_id: $1',
	'passwordreset-disableuser' => 'Onesposobi suradnički račun?',
	'passwordreset-disableuserexplain' => '(postavlja neispravni hash za lozinku - suradnik se ne može prijaviti)',
	'passwordreset-disablesuccess' => 'Suradnički račun je onesposobljen (user ID: $1)',
	'passwordreset-accountdisabled' => 'Suradnički račun je onesposobljen',
	'disabledusers' => 'Onesposobljeni suradnici',
	'disabledusers-summary' => 'Ovo je popis suradnika koji su onesposobljeni putem Ponovnog postavljanja lozinke.',
	'right-passwordreset' => 'Ponovno postavljanje lozinke za suradnika ([[Special:PasswordReset|posebna stranica]])',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'passwordreset' => 'Hesło wróćo stajić',
	'passwordreset-desc' => "[[Special:PasswordReset|Staja wužiwarske hesła wróćo]] - wužaduje prawa 'passwordreset'",
	'passwordreset-invalidusername' => 'Njepłaćiwe wužiwarske mjeno',
	'passwordreset-emptyusername' => 'Žane wužiwarske mjeno',
	'passwordreset-nopassmatch' => 'Hesle njerunatej so',
	'passwordreset-badtoken' => 'Njepłaćiwe wobdźěłanske znamjo',
	'passwordreset-username' => 'Wužiwarske mjeno:',
	'passwordreset-newpass' => 'Nowe hesło:',
	'passwordreset-confirmpass' => 'Hesło wobkrućić:',
	'passwordreset-submit' => 'Hesło wróćo stajić',
	'passwordreset-success' => 'Hesło bu za wužiwarski ID $1 wróćo stajene.',
	'passwordreset-disableuser' => 'Wužiwarske konto znjemóžnić?',
	'passwordreset-disableuserexplain' => '(nastaja njepłaćiwy hesłowy šmjat - wužiwar njemóže so přizjewić)',
	'passwordreset-disablesuccess' => 'Wužiwarske konto bu znjemóžnjene (wužiwarski_id: $1)',
	'passwordreset-accountdisabled' => 'Konto bu znjemóžnjene',
	'disabledusers' => 'Znjemóžnene wužiwarske konta',
	'disabledusers-summary' => 'To je lisćina wužiwarskich kontow, kotrež buchu přez PasswordReset znjemóžnjene.',
	'right-passwordreset' => 'Hesło wužiwarskeje ([[Special:PasswordReset|specialneje strony]]) wróćo stajić',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'passwordreset' => 'Jelszó beállítása',
	'passwordreset-invalidusername' => 'Érvénytelen felhasználói név',
	'passwordreset-emptyusername' => 'Nincs megadva felhasználói név',
	'passwordreset-nopassmatch' => 'A jelszavak nem egyeznek meg',
	'passwordreset-badtoken' => 'Hibás szerkesztési token',
	'passwordreset-username' => 'Felhasználói név',
	'passwordreset-newpass' => 'Új jelszó',
	'passwordreset-confirmpass' => 'Jelszó megerősítése',
	'passwordreset-submit' => 'Jelszó visszaállítása',
	'passwordreset-success' => 'A(z) $1 azonosítószámú felhasználó jelszava be lett állítva',
	'passwordreset-disableuser' => 'Felhasználói fiók letiltása?',
	'passwordreset-disableuserexplain' => '(egy érvénytelen hasht állít be jelszónak, így a felhasználó nem tud bejelentkezni)',
	'passwordreset-disablesuccess' => 'A felhasználói fiók le lett tiltva (azonosító: $1)',
	'passwordreset-accountdisabled' => 'A felhasználói fiók le lett tiltva',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'passwordreset' => 'Reinitiar contrasigno',
	'passwordreset-desc' => "[[Special:PasswordReset|Reinitia le contrasigno de un usator del wiki]] - require le privilegio 'passwordreset'",
	'passwordreset-invalidusername' => 'Nomine de usator invalide',
	'passwordreset-emptyusername' => 'Nomine de usator vacue',
	'passwordreset-nopassmatch' => 'Le contrasignos non es identic',
	'passwordreset-badtoken' => 'Indicio de modification invalide',
	'passwordreset-username' => 'Nomine de usator:',
	'passwordreset-newpass' => 'Nove contrasigno:',
	'passwordreset-confirmpass' => 'Confirma contrasigno:',
	'passwordreset-submit' => 'Reinitiar contrasigno',
	'passwordreset-success' => 'Le contrasigno ha essite reinitiate pro le usator con ID: $1',
	'passwordreset-disableuser' => 'Disactivar conto de usator?',
	'passwordreset-disableuserexplain' => '(impone un hash de contrasigno invalide - le usator non potera aperir un session)',
	'passwordreset-disablesuccess' => 'Le conto del usator ha essite disactivate (ID del usator: $1)',
	'passwordreset-accountdisabled' => 'Le conto ha essite disactivate',
	'disabledusers' => 'Usatores disactivate',
	'disabledusers-summary' => 'Isto es un lista de usatores que ha essite disactivate per medio de PasswordReset.',
	'right-passwordreset' => 'Reinitiar le contrasigno de un usator ([[Special:PasswordReset|pagina special]])',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'passwordreset-badtoken' => 'Token penyuntingan tidak sah',
	'passwordreset-username' => 'Nama pengguna:',
);

/** Interlingue (Interlingue) */
$messages['ie'] = array(
	'passwordreset-username' => 'Vor nómine usatori',
	'passwordreset-newpass' => 'Nov passa-parol',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'passwordreset-username' => 'Uzantonomo',
	'passwordreset-newpass' => 'Nova Kontrolajo',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'passwordreset-username' => 'Notandanafn',
	'passwordreset-submit' => 'Endurstilla lykilorð',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author McDutchie
 * @author Pietrodn
 */
$messages['it'] = array(
	'passwordreset' => 'Reimposta password',
	'passwordreset-desc' => "[[Special:PasswordReset|Reimposta le password di utenti della wiki]] - richiede dei privilegi 'passwordreset'",
	'passwordreset-invalidusername' => 'Nome utente non valido',
	'passwordreset-emptyusername' => 'Nome utente vuoto',
	'passwordreset-nopassmatch' => 'Le password non corrispondono',
	'passwordreset-badtoken' => 'Edit token non valido',
	'passwordreset-username' => 'Nome utente:',
	'passwordreset-newpass' => 'Nuova password:',
	'passwordreset-confirmpass' => 'Conferma password:',
	'passwordreset-submit' => 'Reimposta password',
	'passwordreset-success' => 'La password è stata reimpostata per user_id: $1',
	'passwordreset-disableuser' => 'Disabilitare account?',
	'passwordreset-disableuserexplain' => "(imposta una hash password non valida - l'utente non può effettuare il login)",
	'passwordreset-disablesuccess' => "L'account è stato disabilitato (ID utente: $1)",
	'passwordreset-accountdisabled' => "L'account è stato disabilitato",
	'disabledusers' => 'Utenti disabilitati',
	'disabledusers-summary' => 'Questa è la lista degli utenti che sono stati disabilitati con PasswordReset.',
	'right-passwordreset' => 'Reimposta la password di un utente ([[Special:PasswordReset|pagina speciale]])',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'passwordreset-username' => '利用者名:',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'passwordreset-invalidusername' => 'Jeneng panganggo ora absah',
	'passwordreset-emptyusername' => 'Jeneng panganggo kosong',
	'passwordreset-nopassmatch' => 'Tembung sandhiné ora cocog',
	'passwordreset-badtoken' => 'Token panyuntingan ora absah',
	'passwordreset-username' => 'Jeneng panganggo',
	'passwordreset-newpass' => 'Tembung sandhi anyar',
	'passwordreset-confirmpass' => 'Konfirmasi tembung sandhi',
	'passwordreset-submit' => 'Reset tembung sandhi',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'passwordreset' => 'កំណត់​ពាក្យសំងាត់​សាឡើងវិញ',
	'passwordreset-desc' => '[[Special:PasswordReset|ដើម្បី​កំណត់​ពាក្យសំងាត់​អ្នកប្រើប្រាស់​វិគី​សាឡើងវិញ]] ត្រូវ​ទាមទារ​ឱ្យ​មាន​សិទ្ធិ​លើ​ការកំណត់​ពាក្យសំងាត់',
	'passwordreset-invalidusername' => 'ឈ្មោះអ្នកប្រើប្រាស់ គ្មានសុពលភាព',
	'passwordreset-emptyusername' => 'ឈ្មោះអ្នកប្រើប្រាស់ ទទេ',
	'passwordreset-nopassmatch' => 'ពាក់សំងាត់​មិន​ត្រឹមត្រូវ​ទេ',
	'passwordreset-username' => 'ឈ្មោះអ្នកប្រើប្រាស់៖',
	'passwordreset-newpass' => 'ពាក្យសំងាត់​ថ្មី៖',
	'passwordreset-confirmpass' => 'បញ្ជាក់​ទទួល​ស្គាល់​ពាក្យសំងាត់៖',
	'passwordreset-submit' => 'កំណត់​ពាក្យសំងាត់​សាឡើងវិញ',
	'passwordreset-success' => 'ពាក្យសំងាត់​ត្រូវ​បាន​កំណត់​សាឡើងវិញ​សម្រាប់​អ្នកប្រើប្រាស់ ដែល​មាន​អត្តលេខ​៖ $1',
	'passwordreset-disableuser' => 'បិទ​គណនី​អ្នកប្រើប្រាស់​ឬ​?',
	'passwordreset-disableuserexplain' => '(កំណត់​ពាក្យសំងាត់​ខុស - អ្នកប្រើប្រាស់​មិន​អាច​ឡុកអ៊ីន​បាន​ទេ)',
	'passwordreset-disablesuccess' => 'គណនី​ត្រូវ​បាន​បិទ ចំពោះ​អ្នកប្រើប្រាស់​ដែល​មាន​អត្តលេខ​៖ $1',
	'passwordreset-accountdisabled' => 'គណនី​ត្រូវ​បាន​បិទ',
	'disabledusers' => 'អ្នកប្រើប្រាស់​ដែល​ត្រូវ​បាន​បិទ',
	'disabledusers-summary' => 'នេះ​គឺជា​បញ្ជី​អ្នកប្រើប្រាស់ ដែល​ត្រូវ​បាន​បិទ​តាមរយៈ​ការកំណត់​ពាក្យសំងាត់​ឡើងវិញ​។',
	'right-passwordreset' => 'កំណត់​ពាក្យសំងាត់​ឡើងវិញ​សម្រាប់​អ្នកប្រើប្រាស់ ([[Special:PasswordReset|មើល​ទំព័រ​ពិសេស]])',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'passwordreset-newpass' => '새 암호:',
	'passwordreset-confirmpass' => '암호 확인:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'passwordreset' => 'Paßwoot zeröcksetze',
	'passwordreset-desc' => '[[Special:PasswordReset|Säz enem Metmaache si Paßwoot zeröck]] — bruch et <code>passwordreset</code> Rääsch.',
	'passwordreset-invalidusername' => 'Dä Metmaacher-Name es verkeeht',
	'passwordreset-emptyusername' => 'Dä Metmaacher-Name es leddisch',
	'passwordreset-nopassmatch' => 'De Paßwööter sin unejaal',
	'passwordreset-badtoken' => 'Dat <i lang="en">edit token</i> es Kappes',
	'passwordreset-username' => 'Metmaacher Name:',
	'passwordreset-newpass' => 'Neu Paßwoot:',
	'passwordreset-confirmpass' => 'Norr_ens dat Paßwoot:',
	'passwordreset-submit' => 'Paßwoot zeröck setze',
	'passwordreset-success' => 'Dat Paßwoot för de Metmaacher-Nommer $1 wood zeröck jesatz.',
	'passwordreset-disableuser' => 'Däm Metmaacher singe Zojang still läje?',
	'passwordreset-disableuserexplain' => '(Dat setz ene onjölltijje <i lang="en">hash</i> för et Paßwoot — dat määt et Enlogge onmüjjelesch)',
	'passwordreset-disablesuccess' => 'Däm Metmaacher Nummero $1 singe Zojang es jez stilljelaat.',
	'passwordreset-accountdisabled' => 'Zojang still jelaat',
	'disabledusers' => 'Stilljelaate Metmaacher',
	'disabledusers-summary' => 'Hee es de Leß met (per Paßwoot Zeröcksetze) stilljelaate Metmaacher.',
	'right-passwordreset' => 'Dat Paßwoot fun enem Metmaacher zeröck setze ([[Special:PasswordReset|Söndersigg]])',
);

/** Latin (Latina)
 * @author UV
 */
$messages['la'] = array(
	'passwordreset-submit' => 'Tesseram mutare',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'passwordreset' => 'Passwuert zrécksetzen',
	'passwordreset-desc' => "[[Special:PasswordReset|Zrécksetzen vu Benotzerpasswierder]] - Dir braucht dofir 'Passwordreset'-Rechter",
	'passwordreset-invalidusername' => 'Onbekannte Benotzernumm',
	'passwordreset-emptyusername' => 'Eidele Benotzernumm',
	'passwordreset-nopassmatch' => 'Déi Passwierder déi Dir aginn hutt sinn net identesch',
	'passwordreset-badtoken' => 'Ännerungs-Jeton net valabel',
	'passwordreset-username' => 'Benotzernumm:',
	'passwordreset-newpass' => 'Neit Passwuert:',
	'passwordreset-confirmpass' => 'Passwuert widderhuelen:',
	'passwordreset-submit' => 'Passwuert zrécksetzen',
	'passwordreset-success' => "Passwuert fir d'Benotzernummer (User_id) $1 gouf zréckgesat",
	'passwordreset-disableuser' => 'Benotzerkont deaktivéieren?',
	'passwordreset-disableuserexplain' => '(en net vvalabele Passwuert-"Hash" setzen - de Benotzer ka sechnet aloggen)',
	'passwordreset-disablesuccess' => 'De benotzerkont gouf desaktivéiert (Benotzernummer/user ID:$1)',
	'passwordreset-accountdisabled' => 'De Benotzerkont gouf desaktivéiert',
	'disabledusers' => 'Desaktivéiert Benotzer',
	'disabledusers-summary' => 'Dëst ass eng Lëscht vun den, iwwer PasswordReset, deaktivéierte Benotzer.',
	'right-passwordreset' => 'Passwuert vun engem Benotzer zrécksetzen ([[Special:PasswordReset|Spezialsäit]])',
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'passwordreset' => 'Wachwaord obbenuuts insjtèlle',
	'passwordreset-desc' => "Duid 'n [[Speciaal:PasswordReset|speciaal pagina]] bie om wachwaorde van gebroekers obbenuuts in te sjtèlle - hieveur is 't rech 'passwordreset' nudig",
	'passwordreset-invalidusername' => 'Verkierde gebroeker',
	'passwordreset-emptyusername' => 'Gebroeker neet ingegeve',
	'passwordreset-nopassmatch' => 'De wachwäörd kómme neet euverein',
	'passwordreset-badtoken' => 'Ongeljig bewèrkingstoken',
	'passwordreset-username' => 'Gebroekersnaam:',
	'passwordreset-newpass' => 'Nuuj wachwaord',
	'passwordreset-confirmpass' => 'Bevestig wachwaord:',
	'passwordreset-submit' => 'Wachwaord obbenuuts insjtèlle',
	'passwordreset-success' => 'Wachwaord veur gebroekersnómmer $1 is obbenuuts ingesjtèld',
	'passwordreset-disableuser' => 'Gebroeker deaktivere?',
	'passwordreset-disableuserexplain' => "(sjtèlt 'ne foute wachwaordhash in - gebroeker kin neet aanmelje)",
	'passwordreset-disablesuccess' => 'Gebroeker is gedeaktiveerd (gebroekersnómmer $1)',
	'passwordreset-accountdisabled' => 'Gebroeker is gedeaktiveerd',
	'disabledusers' => 'Gedeaktiveerde gebroekers',
	'disabledusers-summary' => "Dit is 'n lies van gebroekers die gedeaktiveerd zien via PasswordReset",
	'right-passwordreset' => "Wachwaord van 'ne gebroeker obbenuuts insjtèlle ([[Speciaal:PasswordReset|speciaal pagina]])",
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'passwordreset-username' => 'Пайдаланышын лӱмжӧ',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'passwordreset' => 'രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കുക',
	'passwordreset-invalidusername' => 'അസാധുവായ ഉപയോക്തൃനാമം',
	'passwordreset-emptyusername' => 'ശൂന്യമായ ഉപയോക്തൃനാമം',
	'passwordreset-nopassmatch' => 'രഹസ്യ വാക്കുകള്‍ തമ്മില്‍ യോജിക്കുന്നില്ല',
	'passwordreset-username' => 'ഉപയോക്തൃനാമം',
	'passwordreset-newpass' => 'പുതിയ രഹസ്യവാക്ക്',
	'passwordreset-confirmpass' => 'രഹസ്യവാക്ക് ഉറപ്പിക്കുക',
	'passwordreset-submit' => 'രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കുക',
	'passwordreset-success' => 'ഈ ഉപയോക്തൃഐഡിയുടെ രഹസ്യവാക്ക് പുനഃക്രമീകരിച്ചു: $1',
	'passwordreset-disableuser' => 'ഉപയോക്തൃഅക്കൗണ്ട് ഡിസേബിള്‍ ചെയ്യണമോ?',
	'passwordreset-disablesuccess' => 'ഉപയോക്തൃ അക്കൗണ്ട് ഡിസേബിള്‍ ചെയ്തിരിക്കുന്നു. (ഉപയോക്തൃ ഐഡി: $1)',
	'passwordreset-accountdisabled' => 'അക്കൗണ്ട് പ്രവര്‍ത്തനരഹിതമാക്കിയിരിക്കുന്നു',
	'disabledusers' => 'ഡിസേബിള്‍ ചെയ്യപ്പെട്ട ഉപയോക്താക്കള്‍',
	'disabledusers-summary' => 'രഹസ്യവാക്ക് പുനഃക്രമീകരണത്തിലൂടെ പ്രവര്‍ത്തനരഹിതമാക്കിയ ഉപയോക്താക്കളുടെ പട്ടിക.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'passwordreset' => 'परवलीचा शब्द पूर्ववत करा',
	'passwordreset-desc' => "विकि सदस्याचा परवलीचा शब्द पूर्ववत करा - यासाठी 'passwordreset' अधिकार असणे आवश्यक आहे",
	'passwordreset-invalidusername' => 'चुकीचे सदस्यनाव',
	'passwordreset-emptyusername' => 'रिकामे सदस्यनाव',
	'passwordreset-nopassmatch' => 'परवलीचे शब्द जुळले नाहीत',
	'passwordreset-badtoken' => 'चुकीचे संपादन टोकन',
	'passwordreset-username' => 'सदस्यनाव',
	'passwordreset-newpass' => 'नवीन परवलीचा शब्द',
	'passwordreset-confirmpass' => 'परवलीचा शब्द पुन्हा लिहा',
	'passwordreset-submit' => 'परवलीचा शब्द पूर्ववत करा',
	'passwordreset-success' => 'पुढील सदस्यक्रमांकाकरीता परवलीचा शब्द पूर्ववत केलेला आहे: $1',
	'passwordreset-disableuser' => 'सदस्य खाते प्रलंबित करायचे का?',
	'passwordreset-disableuserexplain' => '(परवलीच्या शब्दात एक चुकीचा हॅश वाढवितो - सदस्य प्रवेश करू शकत नाही)',
	'passwordreset-disablesuccess' => 'सदस्य खाते बंद करण्यात आलेले आहे (सदस्य क्रमांक: $1)',
	'passwordreset-accountdisabled' => 'खाते बंद केलेले आहे',
	'disabledusers' => 'बंद केलेले सदस्य',
	'disabledusers-summary' => 'ही अशा सदस्यांची यादी आहे ज्यांची खाती PasswordReset वापरून बंद करण्यात आलेली आहेत.',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'passwordreset-username' => 'Isem l-utent',
	'passwordreset-submit' => 'Irrisettja l-password',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'passwordreset-invalidusername' => 'Амаштовикс теицянь лемесь',
	'passwordreset-username' => 'Теицянь лем',
	'passwordreset-newpass' => 'Од совамо вал',
	'passwordreset-confirmpass' => 'Кемекстык совамо валонть',
	'passwordreset-submit' => 'Полавтык совамо валонть',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'passwordreset-username' => 'Tlatequitiltilīltōcāitl:',
	'passwordreset-newpass' => 'Yancuīc tlahtōlichtacāyōtl:',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'passwordreset' => 'Wachtwoord opnieuw instellen',
	'passwordreset-desc' => "Voegt een [[Special:PasswordReset|speciale pagina]] toe om wachtwoorden van gebruikers opnieuw in te stellen - hiervoor is het recht 'passwordreset' nodig",
	'passwordreset-invalidusername' => 'Onjuiste gebruiker',
	'passwordreset-emptyusername' => 'Gebruiker niet ingegeven',
	'passwordreset-nopassmatch' => 'De wachtwoorden komen niet overeen',
	'passwordreset-badtoken' => 'Ongeldig bewerkingstoken',
	'passwordreset-username' => 'Gebruiker:',
	'passwordreset-newpass' => 'Nieuw wachtwoord:',
	'passwordreset-confirmpass' => 'Bevestig wachtwoord:',
	'passwordreset-submit' => 'Wachtwoord opnieuw instellen',
	'passwordreset-success' => 'Wachtwoord voor gebruikersummer $1 is opnieuw ingesteld',
	'passwordreset-disableuser' => 'Gebruiker deactiveren?',
	'passwordreset-disableuserexplain' => '(stelt een onjuiste wachtwoordhash in - gebruiker kan niet aanmelden)',
	'passwordreset-disablesuccess' => 'Gebruiker is gedeactiveerd (gebruikersnummer $1)',
	'passwordreset-accountdisabled' => 'Gebruiker is gedeactiveerd',
	'disabledusers' => 'Gedeactiveerde gebruikers',
	'disabledusers-summary' => 'Dit is een lijst van gebruikers die zijn gedeactiveerd via PasswordReset',
	'right-passwordreset' => 'Wachtwoord van een gebruiker opnieuw instellen ([[Special:PasswordReset|speciale pagina]])',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'passwordreset' => 'Attendestilling av passord',
	'passwordreset-desc' => '[[Special:PasswordReset|Still attende brukarpassord]] - krev rettar for attendestilling av passord',
	'passwordreset-invalidusername' => 'Ugyldig brukarnamn',
	'passwordreset-emptyusername' => 'Tomt brukarnamn',
	'passwordreset-nopassmatch' => 'Passorda er ikkje dei same',
	'passwordreset-badtoken' => 'Ugyldig redigeringsteikn',
	'passwordreset-username' => 'Brukarnamn:',
	'passwordreset-newpass' => 'Nytt passord:',
	'passwordreset-confirmpass' => 'Stadfest passord:',
	'passwordreset-submit' => 'Nullstill passord',
	'passwordreset-success' => 'Passordet for brukaren «$1» har blitt stilt attende.',
	'passwordreset-disableuser' => 'Deaktiver kontoen?',
	'passwordreset-disableuserexplain' => '(set eit ugyldig passord - brukaren kan ikkje logga inn)',
	'passwordreset-disablesuccess' => 'Brukarkontoen har blitt deaktivert for brukar-ID: $1',
	'passwordreset-accountdisabled' => 'Brukarkonto har blitt deaktivert',
	'disabledusers' => 'Deaktiverte kontoar',
	'disabledusers-summary' => 'Dette er ei lista over brukarkontoar som har blitt deaktiverte gjennom attendestilling av passord.',
	'right-passwordreset' => 'Stilla attende passordet for ein brukar ([[Special:PasswordReset|spesialsida]])',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'passwordreset' => 'Passordresetting',
	'passwordreset-desc' => "[[Special:PasswordReset|Nullstill brukeres passord]] &ndash; krever 'passwordreset'-rettigheter",
	'passwordreset-invalidusername' => 'Ugyldig brukernavn',
	'passwordreset-emptyusername' => 'Tomt brukernavn',
	'passwordreset-nopassmatch' => 'Passordene er ikke de samme',
	'passwordreset-badtoken' => 'Ugyldig redigeringstegn',
	'passwordreset-username' => 'Brukernavn',
	'passwordreset-newpass' => 'Nytt passord',
	'passwordreset-confirmpass' => 'Bekreft passord',
	'passwordreset-submit' => 'Nullstill passord',
	'passwordreset-success' => 'Passordet for brukeren «$1» har blitt resatt.',
	'passwordreset-disableuser' => 'Deaktiver kontoen?',
	'passwordreset-disableuserexplain' => '(setter et ugyldig passord – brukeren kan ikke logge inn)',
	'passwordreset-disablesuccess' => 'Kontoen er blitt deaktivert (bruker-ID: $1)',
	'passwordreset-accountdisabled' => 'Kontoen er blitt deaktivert',
	'disabledusers' => 'Deaktiverte kontoer',
	'disabledusers-summary' => 'Dette er en liste over kontoer som har blitt deaktiverte via passordresetting.',
	'right-passwordreset' => 'Tilbakestille en brukers passord ([[Special:PasswordReset|spesialside]])',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'passwordreset' => 'Remesa a zèro del senhal',
	'passwordreset-desc' => '[[Special:PasswordReset|Torna inicializar lo senhal wiki d’un utilizaire]] - necessita los dreches de « passwordreset »',
	'passwordreset-invalidusername' => "Nom d'utilizaire desconegut",
	'passwordreset-emptyusername' => "Nom d'utilizaire void",
	'passwordreset-nopassmatch' => "Los senhals qu'avètz picats son pas identics.",
	'passwordreset-badtoken' => 'Geton de modificacion desconegut',
	'passwordreset-username' => "Nom d'utilizaire :",
	'passwordreset-newpass' => 'Senhal novèl :',
	'passwordreset-confirmpass' => 'Confirmatz lo senhal :',
	'passwordreset-submit' => 'Remesa a zèro del senhal',
	'passwordreset-success' => "Lo senhal es estat remés a zèro per lo ''user_id'' $1.",
	'passwordreset-disableuser' => "Desactivar lo compte d'utilizaire ?",
	'passwordreset-disableuserexplain' => "(règla un hash de senhal pas valid - l'utilizaire pòt pas se connectar)",
	'passwordreset-disablesuccess' => "Compte d'utilizaire desactivat (user_id : $1)",
	'passwordreset-accountdisabled' => 'Aqueste compte es estat desactivat.',
	'disabledusers' => 'Utilizaires desactivats',
	'disabledusers-summary' => 'Aquò es la tièra dels utilizaires que son estats desactivats per PasswordReset.',
	'right-passwordreset' => 'Tòrna inicializar lo senhal d’un utilizaire ([[Special:PasswordReset|pagina especiala]])',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'passwordreset-username' => 'Bruckernome:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'passwordreset' => 'Wyczyszczenie hasła',
	'passwordreset-desc' => "[[Special:PasswordReset|Ponowne ustawienie hasła użytkownika]] – wymaga uprawnienia 'passwordreset'",
	'passwordreset-invalidusername' => 'Nieprawidłowa nazwa użytkownika',
	'passwordreset-emptyusername' => 'Pusta nazwa użytkownika',
	'passwordreset-nopassmatch' => 'Hasła nie są identyczne',
	'passwordreset-badtoken' => 'Nieprawidłowy żeton edycji',
	'passwordreset-username' => 'Nazwa użytkownika:',
	'passwordreset-newpass' => 'Nowe hasło:',
	'passwordreset-confirmpass' => 'Potwierdź hasło:',
	'passwordreset-submit' => 'Wyczyść hasło',
	'passwordreset-success' => 'Hasło zostało wyczyszczone dla użytkownika z ID: $1',
	'passwordreset-disableuser' => 'Czy wyłączyć konto tego użytkownika?',
	'passwordreset-disableuserexplain' => '(ustawienie błędnego skrótu hasła uniemożliwi użytkownikowi zalogowanie)',
	'passwordreset-disablesuccess' => 'Konto użytkownika zostało zablokowane (ID użytkownika: $1)',
	'passwordreset-accountdisabled' => 'Konto zostało zablokowane',
	'disabledusers' => 'Zablokowani użytkownicy',
	'disabledusers-summary' => 'Lista użytkowników, którzy zostali zablokowaniu poprzez użycie PasswordReset.',
	'right-passwordreset' => 'Resetowanie hasła użytkownika ([[Special:PasswordReset|strona specjalna]])',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'passwordreset' => 'Cambi ëd ciav',
	'passwordreset-invalidusername' => 'Stranòm nen giust',
	'passwordreset-emptyusername' => 'Stranòm veujd',
	'passwordreset-nopassmatch' => 'Le doe ciav a son pa mideme',
	'passwordreset-badtoken' => 'Còdes ëd modìfica nen bon',
	'passwordreset-username' => 'Stranòm',
	'passwordreset-newpass' => 'Ciav neuva',
	'passwordreset-confirmpass' => 'Confermè la ciav',
	'passwordreset-submit' => 'Cambié la ciav',
	'passwordreset-success' => "La ciav ëd l'utent $1 a l'é staita cambià",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'passwordreset-invalidusername' => 'ناسم کارن-نوم',
	'passwordreset-emptyusername' => 'تش کارن-نوم',
	'passwordreset-nopassmatch' => 'پټنوم مو کټ مټ د يو بل سره سمون نه خوري',
	'passwordreset-username' => 'کارن-نوم',
	'passwordreset-newpass' => 'نوی پټنوم',
	'passwordreset-disableuser' => 'آيا په رښتيا دا کارن-حساب ناچارنول غواړۍ؟',
	'passwordreset-disablesuccess' => 'کارن-حساب مو ناچارند شوی (د کارونکي پېژند: $1)',
	'passwordreset-accountdisabled' => 'کارن-حساب مو ناچارن شوی',
	'disabledusers' => 'ناچارن شوي کارونکي',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'passwordreset' => 'Repor Palavra-Chave',
	'passwordreset-desc' => "[[Special:PasswordReset|Repõe palavras-chaves de utilizadores do wiki]] - requer privilégios 'passwordreset'",
	'passwordreset-invalidusername' => 'Nome de Utilizador Inválido',
	'passwordreset-emptyusername' => 'Nome de Utilizador Vazio',
	'passwordreset-nopassmatch' => 'Palavras-Chave não coincidem',
	'passwordreset-username' => 'Nome de utilizador:',
	'passwordreset-newpass' => 'Nova palavra-chave:',
	'passwordreset-confirmpass' => 'Confirme a palavra-chave:',
	'passwordreset-submit' => 'Repor Palavra-Chave',
	'passwordreset-success' => 'A palavra-chave foi reposta para o utilizador com o ID: $1',
	'passwordreset-disableuser' => 'Desactivar Conta de Utilizador?',
	'passwordreset-disablesuccess' => 'A conta de utilizador foi desactivada (ID do utilizador: $1)',
	'passwordreset-accountdisabled' => 'A conta foi desactivada',
	'disabledusers' => 'Utilizadores desactivados',
	'right-passwordreset' => 'Repor palavra-chave de um utilizador ([[Special:PasswordReset|página especial]])',
);

/** Rhaeto-Romance (Rumantsch) */
$messages['rm'] = array(
	'passwordreset-username' => "Num d'utilisader",
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'passwordreset' => 'Resetare parolă',
	'passwordreset-invalidusername' => 'Nume de utilizator incorect',
	'passwordreset-emptyusername' => 'Nume de utilizator gol',
	'passwordreset-nopassmatch' => 'Parolele nu sunt identice',
	'passwordreset-username' => 'Nume de utilizator:',
	'passwordreset-newpass' => 'Parolă nouă:',
	'passwordreset-confirmpass' => 'Confirmare parolă:',
	'passwordreset-submit' => 'Resetează parola',
	'passwordreset-success' => 'Parola a fost resetată pentru ID-ul de utilizator: $1',
	'passwordreset-disableuser' => 'Dezactivare cont de utilizator?',
	'passwordreset-accountdisabled' => 'Contul a fost dezactivat',
	'disabledusers' => 'Utilizatori dezactivaţi',
);

/** Russian (Русский)
 * @author Illusion
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'passwordreset' => 'Сброс пароля',
	'passwordreset-desc' => "[[Special:PasswordReset|Сбрасывает пароли участников вики-проекта]] — требуются права 'passwordreset'",
	'passwordreset-invalidusername' => 'Недопустимое имя участника',
	'passwordreset-emptyusername' => 'Пустое имя участника',
	'passwordreset-nopassmatch' => 'Пароли не совпадают',
	'passwordreset-badtoken' => 'Ошибочный признак правки',
	'passwordreset-username' => 'Имя участника:',
	'passwordreset-newpass' => 'Новый пароль:',
	'passwordreset-confirmpass' => 'Подтверждение пароля:',
	'passwordreset-submit' => 'Сбросить пароль',
	'passwordreset-success' => 'Пароль сброшен для user_id: $1',
	'passwordreset-disableuser' => 'Отключить учётную запись?',
	'passwordreset-disableuserexplain' => '(установлен неверный хеш пароля — участник не может зайти)',
	'passwordreset-disablesuccess' => 'Учётная запись отключена (user_id: $1)',
	'passwordreset-accountdisabled' => 'Учётная запись отключена',
	'disabledusers' => 'Выключенные участники',
	'disabledusers-summary' => 'Это список участников, которые были «выключены» с помощью PasswordReset.',
	'right-passwordreset' => 'сбрасывать пароль участника ([[Special:PasswordReset|служебная страница]])',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'passwordreset' => 'Reset hesla',
	'passwordreset-desc' => 'Umožňuje [[Special:PasswordReset|vygenerovanie nového hesla používateľovi]]. Vyžaduje oprávnenie „passwordreset“.',
	'passwordreset-invalidusername' => 'Neplatné používateľské meno',
	'passwordreset-emptyusername' => 'Nevyplnené používateľské meno',
	'passwordreset-nopassmatch' => 'Heslá sa nezhodujú',
	'passwordreset-badtoken' => 'Neplatný upravovací token',
	'passwordreset-username' => 'Používateľské meno:',
	'passwordreset-newpass' => 'Nové heslo:',
	'passwordreset-confirmpass' => 'Potvrdiť heslo:',
	'passwordreset-submit' => 'Resetovať heslo',
	'passwordreset-success' => 'Heslo používateľa s user_id $1 bolo resetované',
	'passwordreset-disableuser' => 'Zablokovať používateľský účet?',
	'passwordreset-disableuserexplain' => '(nastaví neplatnú haš hodnotu hesla - používateľ sa nebude môcť prihlásiť)',
	'passwordreset-disablesuccess' => 'Používateľský účet bol zablokovaný (user_id: $1)',
	'passwordreset-accountdisabled' => 'Účet bol zablokovaný',
	'disabledusers' => 'Vypnutí používatelia',
	'disabledusers-summary' => 'Toto je zoznam používateľov, ktorí boli vypnutí prostredníctvom PasswordReset.',
	'right-passwordreset' => 'Vygenerovať nové heslo pre používateľa ([[Special:PasswordReset|špeciálna stránka]])',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'passwordreset' => 'Paaswoud touräächsätte',
	'passwordreset-invalidusername' => 'Uungultigen Benutsernoome',
	'passwordreset-emptyusername' => 'Loosen Benutsernoome',
	'passwordreset-nopassmatch' => 'Paaswoude stimme nit uureen',
	'passwordreset-badtoken' => 'Ungultigen „Edit Token“',
	'passwordreset-username' => 'Benutsernoome',
	'passwordreset-newpass' => 'Näi Paaswoud',
	'passwordreset-confirmpass' => 'Paaswoud bestäätigje',
	'passwordreset-submit' => 'Paaswoud touräächsätte',
	'passwordreset-success' => 'Paaswoud foar Benutser-ID $1 wuude touräächsät',
	'passwordreset-disableuser' => 'Benutserkonto deaktivierje?',
	'passwordreset-disableuserexplain' => '(sät n uungultich Paaswoud-Hash - Anmäldjen uunmuugelk)',
	'passwordreset-disablesuccess' => 'Benutserkonto wuude deaktivierd (Benutser-ID: $1)',
	'passwordreset-accountdisabled' => 'Benutserkonto is deaktivierd',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'passwordreset-username' => 'Landihan',
	'passwordreset-newpass' => 'Sandi anyar',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'passwordreset' => 'Lösenordsåterställning',
	'passwordreset-desc' => "[[Special:PasswordReset|Återställ användarens lösenord]] - kräver 'passwordreset'-rättigheter",
	'passwordreset-invalidusername' => 'Ogiltigt användarnamn',
	'passwordreset-emptyusername' => 'Tomt användarnamn',
	'passwordreset-nopassmatch' => 'Lösenordet matchar inte',
	'passwordreset-badtoken' => 'Ogiltigt redigeringstecken',
	'passwordreset-username' => 'Användarnamn:',
	'passwordreset-newpass' => 'Nytt lösenord:',
	'passwordreset-confirmpass' => 'Bekräfta lösenord:',
	'passwordreset-submit' => 'Återställ lösenord',
	'passwordreset-success' => 'Lösenordet för användaren "$1" har återställts.',
	'passwordreset-disableuser' => 'Avaktivera kontot?',
	'passwordreset-disableuserexplain' => '(sätter ett ogiltigt lösenord - användaren kan inte logga in)',
	'passwordreset-disablesuccess' => 'Kontot har avaktiverats (användar-ID: $1)',
	'passwordreset-accountdisabled' => 'Kontot har avaktiverats',
	'disabledusers' => 'Invalidisera konton',
	'disabledusers-summary' => 'Detta är en lista över konton som har blivit invalidiserade via PasswordReset.',
	'right-passwordreset' => 'Återställ en användares lösenord ([[Special:PasswordReset|specialsida]])',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'passwordreset-username' => 'பயனர் பெயர்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'passwordreset-invalidusername' => 'తప్పుడు వాడుకరిపేరు',
	'passwordreset-emptyusername' => 'ఖాళీ వాడుకరి పేరు',
	'passwordreset-nopassmatch' => 'సంకేతపదాలు సరిపోలలేదు',
	'passwordreset-username' => 'వాడుకరిపేరు:',
	'passwordreset-newpass' => 'కొత్త సంకేతపదం:',
	'passwordreset-confirmpass' => 'సంకేతపదాన్ని నిర్ధారించండి',
	'passwordreset-disableuser' => 'వాడుకరి ఖాతాని అచేతనం చేయాలా?',
	'passwordreset-disablesuccess' => 'వాడుకరి ఖాతాని అచేతనం చేసారు (user_id: $1)',
	'passwordreset-accountdisabled' => 'ఖాతాని అచేతనం చేసారు',
	'disabledusers' => 'అచేతన వాడుకరులు',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'passwordreset-invalidusername' => 'Номи корбарии номӯътабар',
	'passwordreset-username' => 'Номи корбарӣ',
	'passwordreset-newpass' => 'Гузарвожаи ҷадид',
	'passwordreset-confirmpass' => 'Тасдиқи гузарвожа',
);

/** Thai (ไทย)
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'passwordreset' => 'ล้างรหัสผ่าน',
	'passwordreset-desc' => 'ล้างรหัสผ่านของผู้ใช้วิกิ - ต้องการสิทธิ "ล้างรหัสผ่าน"',
	'passwordreset-invalidusername' => 'ชื่อผู้ใช้ไม่ถูกต้อง',
	'passwordreset-emptyusername' => 'ชื่อผู้ใช้ว่างเปล่า',
	'passwordreset-nopassmatch' => 'รหัสผ่านไม่ตรงกัน',
	'passwordreset-username' => 'ชื่อผู้ใช้',
	'passwordreset-newpass' => 'รหัสผ่านใหม่',
	'passwordreset-confirmpass' => 'ยืนยันรหัสผ่าน',
	'passwordreset-submit' => 'เปลี่ยนรหัสผ่าน',
	'passwordreset-success' => 'รหัสผ่านถูกเปลี่ยนใหม่เรียบร้อยแล้วสำหรับชื่อผู้ใช้: $1',
	'passwordreset-disableuser' => 'ระงับการใช้งานบัญชีผู้ใช้?',
	'passwordreset-disablesuccess' => 'บัญชีผู้ใช้ได้ถูกระงับแล้ว (ไอดีผู้ใช้: $1)',
	'passwordreset-accountdisabled' => 'บัญชีถูกระงับแล้ว',
	'disabledusers' => 'ผู้ใช้ที่ถูกระงับ',
	'disabledusers-summary' => 'นี่คือรายชื่อของผู้ใช้ที่ถูกระงับโดยการล้างรหัสผ่าน',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'passwordreset' => 'Tái tạo mật khẩu',
	'passwordreset-desc' => "[[Special:PasswordReset|Tái tạo mật khẩu của người dùng wiki]] - cần quyền 'passwordreset'",
	'passwordreset-invalidusername' => 'Tên người dùng không hợp lệ',
	'passwordreset-emptyusername' => 'Tên thành viên trống',
	'passwordreset-nopassmatch' => 'Mật khẩu không khớp',
	'passwordreset-badtoken' => 'Khóa sửa đổi không hợp lệ',
	'passwordreset-username' => 'Tên người dùng:',
	'passwordreset-newpass' => 'Mật khẩu mới:',
	'passwordreset-confirmpass' => 'Xác nhận mật khẩu:',
	'passwordreset-submit' => 'Tái tạo mật khẩu',
	'passwordreset-success' => 'Mật khẩu đã được tái tạo cho thành viên có id: $1',
	'passwordreset-disableuser' => 'Tắt tài khoản thành viên?',
	'passwordreset-disableuserexplain' => '(thiết lập một bảng băm mật khẩu sai - thành viên sẽ không thể đăng nhập)',
	'passwordreset-disablesuccess' => 'Tài khoản thành viên đã được tắt (mã số thành viên: $1)',
	'passwordreset-accountdisabled' => 'Tài khoản đã bị tắt',
	'disabledusers' => 'Thành viên bị tắt',
	'disabledusers-summary' => 'Đây là danh sách các thành viên đã bị tắt sử dụng bằng PasswordReset.',
	'right-passwordreset' => 'Tái tạo mật khẩu của người dùng ([[Special:PasswordReset|trang đặc biệt]])',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'passwordreset-username' => 'Gebananem',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'passwordreset' => '密碼重設',
	'passwordreset-invalidusername' => '無效嘅用戶名',
	'passwordreset-emptyusername' => '空白嘅用戶名',
	'passwordreset-nopassmatch' => '密碼唔對',
	'passwordreset-badtoken' => '無效嘅編輯幣',
	'passwordreset-username' => '用戶名',
	'passwordreset-newpass' => '新密碼',
	'passwordreset-confirmpass' => '確認新密碼',
	'passwordreset-submit' => '重設密碼',
	'passwordreset-success' => 'User_id: $1 嘅密碼已經重設咗',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'passwordreset' => '密码重设',
	'passwordreset-invalidusername' => '无效的用户名',
	'passwordreset-emptyusername' => '空白的用户名',
	'passwordreset-nopassmatch' => '密码不匹配',
	'passwordreset-badtoken' => '无效的编辑币',
	'passwordreset-username' => '用户名',
	'passwordreset-newpass' => '新密码',
	'passwordreset-confirmpass' => '确认新密码',
	'passwordreset-submit' => '重设密码',
	'passwordreset-success' => 'User_id: $1 的密码已经重设',
	'passwordreset-disableuser' => '禁用用户帐户？',
	'passwordreset-accountdisabled' => '账户已停用',
	'disabledusers' => '已禁用的用户',
	'disabledusers-summary' => '这是通过PasswordReset禁用账户的用户列表。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'passwordreset' => '密碼重設',
	'passwordreset-invalidusername' => '無效的用戶名',
	'passwordreset-emptyusername' => '空白的用戶名',
	'passwordreset-nopassmatch' => '密碼不匹配',
	'passwordreset-badtoken' => '無效的編輯幣',
	'passwordreset-username' => '用戶名',
	'passwordreset-newpass' => '新密碼',
	'passwordreset-confirmpass' => '確認新密碼',
	'passwordreset-submit' => '重設密碼',
	'passwordreset-success' => 'User_id: $1 的密碼已經重設',
	'passwordreset-disableuser' => '停用使用者戶口?',
	'passwordreset-accountdisabled' => '戶口經已停用',
	'disabledusers' => '已停用的使用者',
	'disabledusers-summary' => '這是透過PasswordReset停用戶口的使用者清單。',
);

