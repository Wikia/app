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
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author McDutchie
 * @author Purodha
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'passwordreset-desc' => '{{desc}}',
	'passwordreset-nopassmatch' => '{{Identical|Passwords do not match}}',
	'passwordreset-badtoken' => '{{Identical|Invalid edit token}}',
	'passwordreset-username' => '{{Identical|Username}}',
	'passwordreset-newpass' => '{{Identical|New password}}',
	'passwordreset-confirmpass' => '{{Identical|Confirm password}}',
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
	'passwordreset' => 'Wagwoord herstel',
	'passwordreset-desc' => "Voeg 'n [[Special:PasswordReset|spesiale bladsy]] by om wagwoorde van gebruikers te herstel - benodig 'passwordreset' regte",
	'passwordreset-invalidusername' => 'Ongeldige gebruiker',
	'passwordreset-emptyusername' => 'Gebruiker nie gespesifiseerd nie',
	'passwordreset-nopassmatch' => 'Die wagwoorde kom nie ooreen nie',
	'passwordreset-badtoken' => 'Ongeldige wysigingsteken ("edit token")',
	'passwordreset-username' => 'Gebruiker:',
	'passwordreset-newpass' => 'Nuwe wagwoord:',
	'passwordreset-confirmpass' => 'Bevestig wagwoord:',
	'passwordreset-submit' => 'Herstel wagwoord',
	'passwordreset-success' => 'Wagwoord vir gebruikersnommer $1 is herstel',
	'passwordreset-disableuser' => 'Gebruiker deaktiveer?',
	'passwordreset-disableuserexplain' => "(stel na 'n ongeldige wagwoord-hash - gebruiker kan nie inteken nie)",
	'passwordreset-disablesuccess' => 'Gebruiker is gedeaktiveer (gebruikersnommer $1)',
	'passwordreset-accountdisabled' => 'Gebruiker is gedeaktiveer',
	'disabledusers' => 'Gedeaktiveerde gebruikers',
	'disabledusers-summary' => "Dit is 'n lys van gebruikers wat met PasswordReset gedeaktiveer is.",
	'right-passwordreset' => "Herstel 'n gebruiker se wagwoord ([[Special:PasswordReset|spesiale bladsy]])",
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'passwordreset' => 'reset Fjalëkalimi',
	'passwordreset-desc' => "[[Special:PasswordReset|Rivendos llogaritsin user's wiki]] - kërkon 'passwordreset' privilegje",
	'passwordreset-invalidusername' => 'emrin e pavlefshme',
	'passwordreset-emptyusername' => 'username Bosh',
	'passwordreset-nopassmatch' => 'Fjalëkalimet nuk përputhen',
	'passwordreset-badtoken' => 'Pavlefshme redakto shenjë',
	'passwordreset-username' => 'Emri i përdoruesit:',
	'passwordreset-newpass' => 'Fjalëkalimi i ri:',
	'passwordreset-confirmpass' => 'Konfirmo fjalëkalimin:',
	'passwordreset-submit' => 'Reset password',
	'passwordreset-success' => 'Fjalëkalimi ka qenë për të rivendosur ID i perdoruesit: $1',
	'passwordreset-disableuser' => 'Disable llogari përdoruesi?',
	'passwordreset-disableuserexplain' => '(Vendos një fjalëkalim invalid hash - përdoruesi nuk mund të identifikohem)',
	'passwordreset-disablesuccess' => 'Profili i përdoruesit nuk është e mundshme për përdoruesit ID: $1',
	'passwordreset-accountdisabled' => 'Llogaria ka qenë i paaftë',
	'disabledusers' => 'përdoruesve me aftësi të kufizuara',
	'disabledusers-summary' => 'Kjo është një listë e përdoruesve që kanë qenë me aftësi të kufizuara nëpërmjet PasswordReset.',
	'right-passwordreset' => 'Fjalëkalimi Reset e një përdoruesi ([[Special:PasswordReset|faqe veçantë]])',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'passwordreset-submit' => 'Restablir a parola de paso',
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

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'passwordreset-invalidusername' => 'ܫܡܐ ܕܡܦܠܚܢܐ ܠܐ ܬܪܝܨܐ',
	'passwordreset-emptyusername' => 'ܫܡܐ ܕܡܦܠܚܢܐ ܣܦܝܩܐ',
	'passwordreset-nopassmatch' => 'ܡܠܬܐ ܕܥܠܠܐ ܠܐ ܐܘܝܢܬܐ',
	'passwordreset-username' => 'ܫܡܐ ܕܡܦܠܚܢܐ:',
	'passwordreset-newpass' => 'ܡܠܬܐ ܕܥܠܠܐ ܚܕܬܐ:',
	'passwordreset-confirmpass' => 'ܚܬܬ ܡܠܬܐ ܕܥܠܠܐ:',
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

/** Azerbaijani (Azərbaycanca)
 * @author Wertuose
 */
$messages['az'] = array(
	'passwordreset-submit' => 'Parolu sıfırla',
);

/** Bavarian (Boarisch)
 * @author Dardio
 * @author Man77
 */
$messages['bar'] = array(
	'passwordreset' => 'Passwoat zrucksetzn',
	'passwordreset-desc' => "[[Special:PasswordReset|Zrucksetzn vu am Benutza-Passwoat]] – s'''passwordreset''-Recht wiad braucht",
	'passwordreset-invalidusername' => 'Ungüitiga Benutzanãm',
	'passwordreset-emptyusername' => 'Laara Benutzanãm',
	'passwordreset-nopassmatch' => 'Passwöata passn ned zsãmm',
	'passwordreset-badtoken' => 'Ungüitiga „Edit Token“',
	'passwordreset-username' => 'Benutzanãm:',
	'passwordreset-newpass' => 'Neichs Passwoat:',
	'passwordreset-confirmpass' => 'Passwoat bestäting:',
	'passwordreset-submit' => 'Passwoat zrucksetzn',
	'passwordreset-success' => "s'Passwoat fia'd Benutza-ID $1 is zruckgsetzt woan",
	'passwordreset-disableuser' => 'Benutzakonto deaktivian?',
	'passwordreset-disablesuccess' => "s'Benutzakonto mid da Benutza-ID $1 is deaktiviad woan.",
	'passwordreset-accountdisabled' => 'Benutzakonto is deaktiviad',
	'disabledusers' => 'Deaktiviade Benutzakontn',
	'disabledusers-summary' => 'Des is a Listn vo Benutza de wo mim PasswordReset deaktiviad worn han.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'passwordreset' => 'Ачыстка паролю',
	'passwordreset-desc' => '[[Special:PasswordReset|Ачышчае паролі ўдзельнікаў]] — патрабуюцца правы на ачыстку пароляў',
	'passwordreset-invalidusername' => 'Няслушнае імя ўдзельніка',
	'passwordreset-emptyusername' => 'Пустое імя ўдзельніка',
	'passwordreset-nopassmatch' => 'Паролі не супадаюць',
	'passwordreset-badtoken' => 'Няслушная метка рэдагаваньня',
	'passwordreset-username' => 'Імя ўдзельніка:',
	'passwordreset-newpass' => 'Новы пароль:',
	'passwordreset-confirmpass' => 'Пацьверджаньне паролю:',
	'passwordreset-submit' => 'Ачысьціць пароль',
	'passwordreset-success' => 'Ачышчаны пароль для удзельніка з ідэнтыфікатарам: $1',
	'passwordreset-disableuser' => 'Заблякаваць рахунак удзельніка?',
	'passwordreset-disableuserexplain' => '(зрабіць няслушным хэш паролю, каб удзельнік ня мог ўвайсьці ў сыстэму)',
	'passwordreset-disablesuccess' => 'Заблякаваны рахунак для ўдзельніка з ідэнтыфікатарам: $1',
	'passwordreset-accountdisabled' => 'Рахунак заблякаваны',
	'disabledusers' => 'Заблякаваныя ўдзельнікі',
	'disabledusers-summary' => 'Гэта сьпіс удзельнікаў, якія былі заблякаваныя з дапамогай ачысткі пароляў.',
	'right-passwordreset' => 'ачыстка пароляў удзельнікаў з дапамогай [[Special:PasswordReset|службовай старонкі]]',
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

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'passwordreset' => 'Adderaouekaat ar ger-tremen',
	'passwordreset-desc' => "[[Special:PasswordReset|Adderaouekaat a ra ger-tremen un implijer wiki]] - rekis eo kaout ar gwirioù 'passwordreset'",
	'passwordreset-invalidusername' => 'Anv implijer direizh',
	'passwordreset-emptyusername' => 'Anv implijer goullo',
	'passwordreset-nopassmatch' => 'Ne glot ket ar gerioù-tremen',
	'passwordreset-badtoken' => 'Jedouer aozañ direizh',
	'passwordreset-username' => 'Anv implijer :',
	'passwordreset-newpass' => 'Ger-tremen nevez :',
	'passwordreset-confirmpass' => 'Kadarnaat ar ger-tremen :',
	'passwordreset-submit' => 'Adderaouekaat ar ger-tremen',
	'passwordreset-success' => 'Adlakaet eo bet da zero ar ger-tremen evit ID an implijer : $1.',
	'passwordreset-disableuser' => 'Diweredekaat ar gont implijer ?',
	'passwordreset-disableuserexplain' => "(Spisaat a ra un hachadur ger-tremen direizh - n'hallo ket an implijer kevreañ)",
	'passwordreset-disablesuccess' => 'Diweredekaet eo bet ar gont implijer evit ID an implijer : $1',
	'passwordreset-accountdisabled' => 'Diweredekaet eo bet ar gont',
	'disabledusers' => 'Implijerien diweredekaet',
	'disabledusers-summary' => 'Ur roll eus an implijerien bet diweredekaet dre PasswordReset eo.',
	'right-passwordreset' => 'Adderaouekaat ger tremen un implijer ([[Special:PasswordReset|pajenn ispisial]])',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'passwordreset' => 'Poništavanje šifre',
	'passwordreset-desc' => "[[Special:PasswordReset|Poništava šifre wiki korisnika]] - zahtijeva privilegije 'passwordreset'",
	'passwordreset-invalidusername' => 'Nevaljano korisničko ime',
	'passwordreset-emptyusername' => 'Prazno korisničko ime',
	'passwordreset-nopassmatch' => 'Šifre se ne slažu',
	'passwordreset-badtoken' => 'Nevaljan token izmjene',
	'passwordreset-username' => 'Korisničko ime:',
	'passwordreset-newpass' => 'Nova šifra:',
	'passwordreset-confirmpass' => 'Potvrdi šifru:',
	'passwordreset-submit' => 'Poništi šifru',
	'passwordreset-success' => 'Šifra je poništena za korisnički ID: $1',
	'passwordreset-disableuser' => 'Onemogući korisnički račun?',
	'passwordreset-disableuserexplain' => '(postavljen nevaljan haš šifre - korisnik se ne može prijaviti)',
	'passwordreset-disablesuccess' => 'Korisnički račun je onemogućen za korisnički ID: $1',
	'passwordreset-accountdisabled' => 'Račun je onemogućen',
	'disabledusers' => 'Onemogućeni korisnici',
	'disabledusers-summary' => 'Ovo je spisak korisnika koji su onemogućeni putem PasswordReset.',
	'right-passwordreset' => 'Poništavanje šifre korisnika ([[Special:PasswordReset|posebna stranica]])',
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
	'passwordreset-username' => 'по́льꙃєватєлꙗ и́мѧ :',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'passwordreset-username' => 'Brugernavn:',
	'passwordreset-newpass' => 'Ny adgangskode:',
	'passwordreset-submit' => 'Nullstille passord',
);

/** German (Deutsch)
 * @author Kghbln
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
	'passwordreset-success' => 'Passwort für Benutzerkennung $1 wurde zurückgesetzt.',
	'passwordreset-disableuser' => 'Benutzerkonto deaktivieren?',
	'passwordreset-disableuserexplain' => '(setzen eines ungültigen Passwort-Hashs - Anmelden unmöglich)',
	'passwordreset-disablesuccess' => 'Benutzerkonto für Benutzerkennung $1 wurde deaktiviert.',
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
	'passwordreset-disableuserexplain' => '(staja njepłaśiwy gronidłowy haš - wužywaŕ njamóžo se pśizjawiś)',
	'passwordreset-disablesuccess' => 'Wužywarske konto jo se znjemóžniło za wužywarski ID: $1',
	'passwordreset-accountdisabled' => 'Konto jo se znjemóžniło',
	'disabledusers' => 'Znjemóžnjone wužywarje',
	'disabledusers-summary' => 'To jo lisćina wužywarjow, kótarež su se znjemóžnili pśez PasswordReset.',
	'right-passwordreset' => 'Gronidło wužywarja slědk stajiś ([[Special:PasswordReset|specialny bok]])',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Evropi
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'passwordreset' => 'Κωδικός επαναφοράς',
	'passwordreset-invalidusername' => 'Άκυρο όνομα χρήστη',
	'passwordreset-emptyusername' => 'Κενό όνομα χρήστη',
	'passwordreset-nopassmatch' => 'Οι Κωδικοί δεν αντιστοιχούν',
	'passwordreset-badtoken' => 'Μη έγκυρο δείγμα επεξεργασίας',
	'passwordreset-username' => 'Όνομα χρήστη:',
	'passwordreset-newpass' => 'Νέος Κωδικός:',
	'passwordreset-confirmpass' => 'Επιβεβαίωση κωδικού:',
	'passwordreset-submit' => 'Επαναφορά κωδικού',
	'passwordreset-success' => 'Ο κωδικός έχει επαναφερθεί για τον user_id: $1',
	'passwordreset-accountdisabled' => 'Ο λογαριασμός έχει απενεργοποιηθεί',
	'disabledusers' => 'Απενεργοποιημένοι χρήστες',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'passwordreset' => 'Restarigo de pasvorto',
	'passwordreset-desc' => "[[Special:PasswordReset|Restarigas pasvortojn de vikia uzanto]] - nepras rajtojn 'passwordreset'",
	'passwordreset-invalidusername' => 'Nevalida Salutnomo',
	'passwordreset-emptyusername' => 'Malplena Salutnomo',
	'passwordreset-nopassmatch' => 'Pasvortoj ne estas samaj',
	'passwordreset-badtoken' => 'Malvalida redakta ĵetono',
	'passwordreset-username' => 'Salutnomo:',
	'passwordreset-newpass' => 'Nova pasvorto:',
	'passwordreset-confirmpass' => 'Konfirmi pasvorton:',
	'passwordreset-submit' => 'Refari pasvorton',
	'passwordreset-success' => 'Pasvorto estis restarigita por user_id: $1',
	'passwordreset-disableuser' => 'Ĉu ja malebligu konton de uzanto?',
	'passwordreset-disableuserexplain' => '(agardas malvalidan pasvortan haketon - uzanto ne povas ensaluti)',
	'passwordreset-disablesuccess' => 'Konto de uzanto estis malebligita (uzanto-identigo: $1)',
	'passwordreset-accountdisabled' => 'Konto estis malŝaltita',
	'disabledusers' => 'Malebligitaj uzantoj',
	'disabledusers-summary' => 'Jen listo de uzantoj malŝaltitaj per PasswordReset.',
	'right-passwordreset' => 'Refari pasvorton de uzanto ([[Special:PasswordReset|speciala paĝo]])',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author Imre
 * @author Kobazulo
 * @author Locos epraix
 */
$messages['es'] = array(
	'passwordreset' => 'Restablecimiento de contraseña',
	'passwordreset-desc' => "[[Special:PasswordReset|Restablecimientos de contraseñas de usuarios wiki]] - requiere privilegios 'passwordreset'",
	'passwordreset-invalidusername' => 'Nombre de usuario inválido',
	'passwordreset-emptyusername' => 'Nombre de usuario vacío',
	'passwordreset-nopassmatch' => 'Contraseñas no coinciden',
	'passwordreset-badtoken' => 'Ficha de edición inválida',
	'passwordreset-username' => 'Nombre de usuario:',
	'passwordreset-newpass' => 'Nueva contraseña:',
	'passwordreset-confirmpass' => 'Confirmar contraseña:',
	'passwordreset-submit' => 'Reestablecer contraseña',
	'passwordreset-success' => 'Contraseña ha sido reestablecida para ID de usuario: $1',
	'passwordreset-disableuser' => '¿Deshabilitar cuenta de usuario?',
	'passwordreset-disableuserexplain' => '(especifica un hash de contraseña inválido - el usuario no puede iniciar sesión)',
	'passwordreset-disablesuccess' => 'Cuenta de usuario ha sido deshabilitado para ID de usuario: $1',
	'passwordreset-accountdisabled' => 'Cuenta ha sido deshabilitada',
	'disabledusers' => 'Usuarios deshabilitados',
	'disabledusers-summary' => 'Esta es una lista de usuarios que han sido deshabilitados con PasswordReset.',
	'right-passwordreset' => 'Reestablecer contraseña de un usuario ([[Special:PasswordReset|página especial]])',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'passwordreset-invalidusername' => 'Vigane kasutajanimi',
	'passwordreset-emptyusername' => 'Tühi kasutajanimi',
	'passwordreset-nopassmatch' => 'Paroolid ei ühti',
	'passwordreset-username' => 'Kasutajanimi:',
	'passwordreset-newpass' => 'Uus parool:',
	'passwordreset-confirmpass' => 'Kinnita parool:',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'passwordreset' => 'Pasahitzaren berrezarpena',
	'passwordreset-nopassmatch' => 'Pasahitzak ez datoz bat',
	'passwordreset-username' => 'Lankide izena:',
	'passwordreset-newpass' => 'Pasahitz berria:',
	'passwordreset-confirmpass' => 'Pasahitza egiaztatu:',
	'passwordreset-submit' => 'Pasahitza berrezarri',
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
	'passwordreset-badtoken' => 'Virheellinen muokkauslipuke',
	'passwordreset-username' => 'Käyttäjätunnus:',
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
 * @author Crochet.david
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'passwordreset' => 'Remise à zéro du mot de passe',
	'passwordreset-desc' => '[[Special:PasswordReset|Réinitialise le mot de passe wiki d’un utilisateur]] - nécessite les droits de « passwordreset »',
	'passwordreset-invalidusername' => 'Nom d’usager inconnu',
	'passwordreset-emptyusername' => 'Nom d’usager vide',
	'passwordreset-nopassmatch' => 'Les mots de passe que vous avez saisis ne sont pas identiques.',
	'passwordreset-badtoken' => 'Jeton de modification inconnu',
	'passwordreset-username' => 'Nom d’utilisateur :',
	'passwordreset-newpass' => 'Nouveau mot de passe :',
	'passwordreset-confirmpass' => 'Confirmez le mot de passe :',
	'passwordreset-submit' => 'Remise à zéro du mot de passe',
	'passwordreset-success' => 'Le mot de passe a été remis à zéro pour l’utilisateur $1.',
	'passwordreset-disableuser' => 'Désactiver le compte utilisateur ?',
	'passwordreset-disableuserexplain' => '(spécifie un hachage de mot de passe invalide - l’utilisateur ne pourra pas se connecter)',
	'passwordreset-disablesuccess' => 'Compte utilisateur désactivé (user_id : $1)',
	'passwordreset-accountdisabled' => 'Ce compte a été désactivé.',
	'disabledusers' => 'Utilisateurs désactivés',
	'disabledusers-summary' => 'Ceci est la liste des utilisateurs qui ont été désactivés par PasswordReset.',
	'right-passwordreset' => 'Réinitialise le mot de passe d’un utilisateur ([[Special:PasswordReset|page spéciale]])',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'passwordreset-invalidusername' => 'Nom d’utilisator encognu',
	'passwordreset-username' => 'Nom d’utilisator :',
	'passwordreset-newpass' => 'Mot de pâssa novél :',
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
	'passwordreset-success' => 'Restableceuse o contrasinal para o ID de usuario: $1',
	'passwordreset-disableuser' => 'Quere desactivar a conta de usuario?',
	'passwordreset-disableuserexplain' => '(fixa un contrasinal hash inválido; o usuario non pode acceder ao sistema)',
	'passwordreset-disablesuccess' => 'Desactivouse a conta de usuario para o ID de usuario: $1',
	'passwordreset-accountdisabled' => 'A conta foi desabilitada',
	'disabledusers' => 'Usuarios desabilitados',
	'disabledusers-summary' => 'Esta é unha lista dos usuarios que foron deshabilitados por medio de PasswordReset.',
	'right-passwordreset' => 'Restablecer o contrasinal dun usuario ([[Special:PasswordReset|páxina especial]])',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'passwordreset-username' => 'Ὄνομα χρωμένου:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'passwordreset' => 'Passwort zruggsetze',
	'passwordreset-desc' => "[[Special:PasswordReset|Ztruggsetze vun eme Benuzuer-Passwort]] - ''passwordreset''-Rächt notwändig",
	'passwordreset-invalidusername' => 'Nit giltige Benutzername',
	'passwordreset-emptyusername' => 'Lääre Benutzername',
	'passwordreset-nopassmatch' => 'Passwerter stimme nit zämme',
	'passwordreset-badtoken' => 'Nit giltige „Edit Token“',
	'passwordreset-username' => 'Benutzername:',
	'passwordreset-newpass' => 'Nej Passwort:',
	'passwordreset-confirmpass' => 'Passwort bstätige:',
	'passwordreset-submit' => 'Passwort zruggsetze',
	'passwordreset-success' => 'Passwort fir Benutzer-ID $1 isch zrugggsetzt wore.',
	'passwordreset-disableuser' => 'Benutzerkonto deaktiviere?',
	'passwordreset-disableuserexplain' => '(setze vun eme nit giltige Passwort-Hash - Aamälde nit megli)',
	'passwordreset-disablesuccess' => 'Benutzerkonto fir Benutzer-ID $1 isch deaktiviert wore.',
	'passwordreset-accountdisabled' => 'Benutzerkonto isch deaktiviert',
	'disabledusers' => 'Deaktivierti Benutzerkonte',
	'disabledusers-summary' => 'Des isch d Lischt vu dr deaktivierte Benutzerkonte (via PasswordReset).',
	'right-passwordreset' => 'Passwort vun eme Benutzer zruggsetze ([[Special:PasswordReset|Spezialsyte]])',
);

/** Gujarati (ગુજરાતી)
 * @author Dineshjk
 */
$messages['gu'] = array(
	'passwordreset-username' => 'સભ્ય નામ:',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'passwordreset-username' => "Dt'ennym ymmydeyr:",
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'passwordreset-username' => 'Yung-fu-miàng',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 */
$messages['haw'] = array(
	'passwordreset-newpass' => 'ʻŌlelo hūnā hou:',
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
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'passwordreset' => 'Jelszó beállítása',
	'passwordreset-desc' => '[[Special:PasswordReset|Szerkesztő jelszavának visszaállítása]] ‒ „passwordreset” jogosultság szükséges hozzá',
	'passwordreset-invalidusername' => 'Érvénytelen felhasználói név',
	'passwordreset-emptyusername' => 'Nincs megadva felhasználói név',
	'passwordreset-nopassmatch' => 'A jelszavak nem egyeznek meg',
	'passwordreset-badtoken' => 'Hibás szerkesztési token',
	'passwordreset-username' => 'Felhasználónév:',
	'passwordreset-newpass' => 'Új jelszó:',
	'passwordreset-confirmpass' => 'Jelszó megerősítése:',
	'passwordreset-submit' => 'Jelszó visszaállítása',
	'passwordreset-success' => 'A(z) $1 azonosítószámú felhasználó jelszava be lett állítva',
	'passwordreset-disableuser' => 'Felhasználói fiók letiltása?',
	'passwordreset-disableuserexplain' => '(egy érvénytelen hasht állít be jelszónak, így a felhasználó nem tud bejelentkezni)',
	'passwordreset-disablesuccess' => 'A felhasználói fiók le lett tiltva (azonosító: $1)',
	'passwordreset-accountdisabled' => 'A felhasználói fiók le lett tiltva',
	'disabledusers' => 'Letiltott szerkesztők',
	'disabledusers-summary' => 'Azon szerkesztők listája, akik le lettek tiltva a PasswordReset segítségével.',
	'right-passwordreset' => 'Szerkesztő jelszavának alaphelyzetbe állítása ([[Special:PasswordReset|speciális lap]])',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'passwordreset' => 'Reinitialisar contrasigno',
	'passwordreset-desc' => "[[Special:PasswordReset|Reinitialisa le contrasigno de un usator del wiki]] - require le privilegio 'passwordreset'",
	'passwordreset-invalidusername' => 'Nomine de usator invalide',
	'passwordreset-emptyusername' => 'Nomine de usator vacue',
	'passwordreset-nopassmatch' => 'Le contrasignos non es identic',
	'passwordreset-badtoken' => 'Indicio de modification invalide',
	'passwordreset-username' => 'Nomine de usator:',
	'passwordreset-newpass' => 'Nove contrasigno:',
	'passwordreset-confirmpass' => 'Confirma contrasigno:',
	'passwordreset-submit' => 'Reinitialisar contrasigno',
	'passwordreset-success' => 'Le contrasigno ha essite reinitialisate pro le usator con ID: $1',
	'passwordreset-disableuser' => 'Disactivar conto de usator?',
	'passwordreset-disableuserexplain' => '(impone un hash de contrasigno invalide - le usator non potera aperir un session)',
	'passwordreset-disablesuccess' => 'Le conto del usator ha essite disactivate (ID del usator: $1)',
	'passwordreset-accountdisabled' => 'Le conto ha essite disactivate',
	'disabledusers' => 'Usatores disactivate',
	'disabledusers-summary' => 'Isto es un lista de usatores que ha essite disactivate per medio de PasswordReset.',
	'right-passwordreset' => 'Reinitialisar le contrasigno de un usator ([[Special:PasswordReset|pagina special]])',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'passwordreset' => 'Sandi diaturulang',
	'passwordreset-desc' => "[[Special:PasswordReset|Wiki pengaturan ulang kunci pengguna]] - diperlukan hak 'passwordreset'",
	'passwordreset-invalidusername' => 'Nama pengguna tidak sah',
	'passwordreset-emptyusername' => 'Nama pengguna tidak diisi',
	'passwordreset-nopassmatch' => 'Sandi tidak cocok',
	'passwordreset-badtoken' => 'Token penyuntingan tidak sah',
	'passwordreset-username' => 'Nama pengguna:',
	'passwordreset-newpass' => 'Kata sandi baru:',
	'passwordreset-confirmpass' => 'Konfirmasi password:',
	'passwordreset-submit' => 'Buat ulang kata sandi',
	'passwordreset-success' => 'Sandi telah diatur ulang untuk ID pengguna: $1',
	'passwordreset-disableuser' => 'Akun pengguna di nonaktifkan?',
	'passwordreset-disableuserexplain' => '(set password yang tidak valid - pengguna tidak dapat masuk log)',
	'passwordreset-disablesuccess' => 'Akun pengguna telah di nonaktifkan untuk ID pengguna: $1',
	'passwordreset-accountdisabled' => 'Akun telah di nonaktifkan',
	'disabledusers' => 'Nonaktifkan pengguna',
	'disabledusers-summary' => 'Ini adalah daftar pengguna yang telah di nonaktifkan melalui PasswordReset.',
	'right-passwordreset' => 'Aturulang kunci untuk pengguna ([[Special:PasswordReset|special page]])',
);

/** Interlingue (Interlingue) */
$messages['ie'] = array(
	'passwordreset-username' => 'Vor nómine usatori',
	'passwordreset-newpass' => 'Nov passa-parol',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'passwordreset' => 'Nkuwaria okwúngáfè',
);

/** Ido (Ido)
 * @author Malafaya
 * @author Wyvernoid
 */
$messages['io'] = array(
	'passwordreset-username' => 'Uzantonomo:',
	'passwordreset-newpass' => 'Nova Pasovorto:',
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
 * @author 青子守歌
 */
$messages['ja'] = array(
	'passwordreset' => 'パスワードの再設定',
	'passwordreset-desc' => '[[Special:PasswordReset|ウィキ利用者のパスワードを再設定する]] - パスワード再設定権限 (passwordreset) が必要',
	'passwordreset-invalidusername' => '無効な利用者名',
	'passwordreset-emptyusername' => '利用者名が空',
	'passwordreset-nopassmatch' => 'パスワードが一致しません',
	'passwordreset-badtoken' => '編集トークンが不正',
	'passwordreset-username' => '利用者名：',
	'passwordreset-newpass' => '新しいパスワード：',
	'passwordreset-confirmpass' => '確認用パスワード:',
	'passwordreset-submit' => 'パスワードを再設定',
	'passwordreset-success' => '利用者ID $1 のパスワードを再設定しました。',
	'passwordreset-disableuser' => '利用者アカウントを無効化しますか？',
	'passwordreset-disableuserexplain' => '(不正なパスワードハッシュを設定。利用者はログインできない)',
	'passwordreset-disablesuccess' => '利用者ID $1 のアカウントは無効化されています。',
	'passwordreset-accountdisabled' => 'アカウントを無効化しました',
	'disabledusers' => '無効化済利用者',
	'disabledusers-summary' => 'これはパスワードの再設定を使って無効化された利用者の一覧です。',
	'right-passwordreset' => '利用者のパスワードを再設定する ([[Special:PasswordReset|特別ページ]])',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'passwordreset-invalidusername' => 'Jeneng panganggo ora absah',
	'passwordreset-emptyusername' => 'Jeneng panganggo kosong',
	'passwordreset-nopassmatch' => 'Tembung sandhiné ora cocog',
	'passwordreset-badtoken' => 'Token panyuntingan ora absah',
	'passwordreset-username' => 'Jeneng panganggo:',
	'passwordreset-newpass' => 'Tembung sandi anyar:',
	'passwordreset-confirmpass' => 'Konfirmasi tembung sandi:',
	'passwordreset-submit' => 'Reset tembung sandhi',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'passwordreset' => 'កំណត់​ពាក្យសំងាត់​សាឡើងវិញ',
	'passwordreset-desc' => '[[Special:PasswordReset|ដើម្បី​កំណត់​ពាក្យសំងាត់​អ្នកប្រើប្រាស់​វិគី​សាឡើងវិញ]] ត្រូវ​ទាមទារ​ឱ្យ​មាន​សិទ្ធិ​លើ​ការកំណត់​ពាក្យសំងាត់',
	'passwordreset-invalidusername' => 'អត្តនាមគ្មានសុពលភាព',
	'passwordreset-emptyusername' => 'អត្តនាមទទេ',
	'passwordreset-nopassmatch' => 'ពាក់សំងាត់​មិន​ត្រឹមត្រូវ​ទេ',
	'passwordreset-username' => 'អត្តនាម៖',
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

/** Colognian (Ripoarisch)
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
	'passwordreset-disableuser' => 'Däm Metmaacher singe Zohjang stell lääje?',
	'passwordreset-disableuserexplain' => '(Dat setz ene onjölltijje <i lang="en">hash</i> för et Paßwoot — dat määt et Enlogge onmüjjelesch)',
	'passwordreset-disablesuccess' => 'Däm Metmaacher Nummero $1 singe Zojang es jez stilljelaat.',
	'passwordreset-accountdisabled' => 'Zojang still jelaat',
	'disabledusers' => 'Stilljelaate Metmaacher',
	'disabledusers-summary' => 'Hee es de Leß met (per Paßwoot Zeröcksetze) stilljelaate Metmaacher.',
	'right-passwordreset' => 'Dat Paßwoot fun enem Metmaacher zeröck setze ([[Special:PasswordReset|Söndersigg]])',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'passwordreset-username' => 'Navê bikarhêner:',
);

/** Latin (Latina)
 * @author UV
 */
$messages['la'] = array(
	'passwordreset-submit' => 'Tesseram mutare',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
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
	'passwordreset-disablesuccess' => 'De Benotzerkont gouf desaktivéiert (Benotzernummer/user ID:$1)',
	'passwordreset-accountdisabled' => 'De Benotzerkont gouf desaktivéiert',
	'disabledusers' => 'Desaktivéiert Benotzer',
	'disabledusers-summary' => 'Dëst ass eng Lëscht vun den, iwwer PasswordReset, deaktivéierte Benotzer.',
	'right-passwordreset' => 'Passwuert vun engem Benotzer zrécksetzen ([[Special:PasswordReset|Spezialsäit]])',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 * @author Pahles
 */
$messages['li'] = array(
	'passwordreset' => 'Wachwaord obbenuuts insjtèlle',
	'passwordreset-desc' => "Voog 'n [[Special:PasswordReset|speciaal pagina]] toe om wachwäörd van gebroekers opnuuj in te stelle - hieveur is 't rech 'passwordreset' neudig",
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
	'right-passwordreset' => "Wachwaord van 'ne gebroeker obbenuuts insjtèlle ([[Special:PasswordReset|speciaal pagina]])",
);

/** Latvian (Latviešu)
 * @author Geimeris
 */
$messages['lv'] = array(
	'passwordreset' => 'Paroles atiestatīšana',
	'passwordreset-invalidusername' => 'Nederīgs lietotājvārds',
	'passwordreset-emptyusername' => 'Tukšs lietotājvārda lauciņš',
	'passwordreset-nopassmatch' => 'Paroles nesakrīt.',
	'passwordreset-username' => 'Lietotājvārds:',
	'passwordreset-newpass' => 'Jaunā parole:',
	'passwordreset-confirmpass' => 'Atkārtota parole:',
	'passwordreset-submit' => 'Atiestatīt paroli',
	'passwordreset-success' => 'Parole atiestatīta lietotājam ar ID numuru $1',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'passwordreset-username' => 'Пайдаланышын лӱмжӧ',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'passwordreset' => 'Менување на лозинка',
	'passwordreset-desc' => "[[Special:PasswordReset|Менува лозинки на корисници на викито]] - треба 'passwordreset' привилегии",
	'passwordreset-invalidusername' => 'Неважечко корисничко име',
	'passwordreset-emptyusername' => 'Празно корисничко име',
	'passwordreset-nopassmatch' => 'Лозинките не се совпаѓаат',
	'passwordreset-badtoken' => 'Неважечки жетон при уредувањето',
	'passwordreset-username' => 'Корисничко име:',
	'passwordreset-newpass' => 'Нова лозинка:',
	'passwordreset-confirmpass' => 'Потврдете ја лозинката:',
	'passwordreset-submit' => 'Смени лозинка',
	'passwordreset-success' => 'Лозинката е променета за кориснички ид. бр.: $1',
	'passwordreset-disableuser' => 'Да ја оневозможам корисничката сметка?',
	'passwordreset-disableuserexplain' => '(постава неважечка тараба - корисникот не може да се најави)',
	'passwordreset-disablesuccess' => 'Корисничката сметка е оневозможена за корисничкиот ид. бр.: $1',
	'passwordreset-accountdisabled' => 'Сметката е оневозможена',
	'disabledusers' => 'Оневозможени корисници',
	'disabledusers-summary' => 'Ова е список на корисници кои се оневозможени со PasswordReset.',
	'right-passwordreset' => 'Менување на лозинка на корисник ([[Special:PasswordReset|специјална страница]])',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'passwordreset' => 'രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കുക',
	'passwordreset-desc' => "[[Special:PasswordReset|വിക്കി ഉപയോക്താക്കളുടെ രഹസ്യവാക്കുകൾ പുനഃക്രമീകരിക്കുക]] - 'passwordreset' പദവി ആവശ്യമാണ്",
	'passwordreset-invalidusername' => 'അസാധുവായ ഉപയോക്തൃനാമം',
	'passwordreset-emptyusername' => 'ശൂന്യമായ ഉപയോക്തൃനാമം',
	'passwordreset-nopassmatch' => 'രഹസ്യവാക്കുകൾ തമ്മിൽ യോജിക്കുന്നില്ല',
	'passwordreset-username' => 'ഉപയോക്തൃനാമം:',
	'passwordreset-newpass' => 'പുതിയ രഹസ്യവാക്ക്:',
	'passwordreset-confirmpass' => 'രഹസ്യവാക്ക് ഉറപ്പിക്കുക:',
	'passwordreset-submit' => 'രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കുക',
	'passwordreset-success' => 'ഈ ഉപയോക്തൃഐ.ഡി.യുടെ രഹസ്യവാക്ക് പുനഃക്രമീകരിച്ചു: $1',
	'passwordreset-disableuser' => 'ഉപയോക്തൃഅംഗത്വം പ്രവർത്തനരഹിതമാക്കണോ?',
	'passwordreset-disablesuccess' => 'ഉപയോക്തൃ അംഗത്വം ഡിസേബിൾ ചെയ്തിരിക്കുന്നു. (ഉപയോക്തൃ ഐ.ഡി.: $1)',
	'passwordreset-accountdisabled' => 'അംഗത്വം പ്രവർത്തനരഹിതമാക്കിയിരിക്കുന്നു',
	'disabledusers' => 'ഡിസേബിൾ ചെയ്യപ്പെട്ട ഉപയോക്താക്കൾ',
	'disabledusers-summary' => 'രഹസ്യവാക്ക് പുനഃക്രമീകരണത്തിലൂടെ പ്രവർത്തനരഹിതമാക്കിയ ഉപയോക്താക്കളുടെ പട്ടിക.',
	'right-passwordreset' => 'ഉപയോക്താക്കളുടെ രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കുക ([[Special:PasswordReset|പ്രത്യേക താൾ]])',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'passwordreset-nopassmatch' => 'Нууц үгнүүд ижил биш байна',
	'passwordreset-username' => 'Хэрэглэгчийн нэр:',
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

/** Malay (Bahasa Melayu)
 * @author Aviator
 * @author Diagramma Della Verita
 */
$messages['ms'] = array(
	'passwordreset' => 'Set semula kata laluan',
	'passwordreset-desc' => "[[Special:PasswordReset|Set semula kata laluan pengguna]] - memerlukan keistimewaan 'passwordreset'",
	'passwordreset-invalidusername' => 'Nama pengguna tidak sah',
	'passwordreset-emptyusername' => 'Nama pengguna kosong',
	'passwordreset-nopassmatch' => 'Kata laluan tidak sama',
	'passwordreset-badtoken' => 'Token sunting tidak sah',
	'passwordreset-username' => 'Nama pengguna:',
	'passwordreset-newpass' => 'Kata laluan baru:',
	'passwordreset-confirmpass' => 'Ulangi kata laluan:',
	'passwordreset-submit' => 'Set semula kata laluan',
	'passwordreset-success' => 'Kata laluan telah disetkan semula untuk ID pengguna: $1',
	'passwordreset-disableuser' => 'Lumpuhkan akaun pengguna?',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'passwordreset-username' => 'Isem tal-utent:',
	'passwordreset-submit' => 'Irrisettja l-password',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'passwordreset' => 'Совамо валонь лиялгавтома',
	'passwordreset-invalidusername' => 'Амаштовикс теицянь лемесь',
	'passwordreset-emptyusername' => 'Чаво теицянь лемесь',
	'passwordreset-nopassmatch' => 'Совамо валтнэ аволь вейкетть',
	'passwordreset-badtoken' => 'Витнемань-петнемань амаштовикс тешкст',
	'passwordreset-username' => 'Теиця леметь:',
	'passwordreset-newpass' => 'Од совамо валот:',
	'passwordreset-confirmpass' => 'Кемекстык совамо валот:',
	'passwordreset-submit' => 'Полавтык совамо валонть',
	'passwordreset-accountdisabled' => 'Совамо таркась лоткавтозь',
	'disabledusers' => 'Лоткавтозь теицят',
	'right-passwordreset' => 'Лиялгавтомс теицянь совамо вал ([[Special:PasswordReset|башка лопа]])',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'passwordreset-username' => 'Tlatequitiltilīltōcāitl:',
	'passwordreset-newpass' => 'Yancuīc tlahtōlichtacāyōtl:',
);

/** Dutch (Nederlands)
 * @author Naudefj
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
	'passwordreset-confirmpass' => 'Wachtwoord bevestigen:',
	'passwordreset-submit' => 'Wachtwoord opnieuw instellen',
	'passwordreset-success' => 'Wachtwoord voor gebruikersnummer $1 is opnieuw ingesteld',
	'passwordreset-disableuser' => 'Gebruiker deactiveren?',
	'passwordreset-disableuserexplain' => '(stelt een onjuiste wachtwoordhash in - gebruiker kan niet aanmelden)',
	'passwordreset-disablesuccess' => 'Gebruiker is gedeactiveerd (gebruikersnummer $1)',
	'passwordreset-accountdisabled' => 'Gebruiker is gedeactiveerd',
	'disabledusers' => 'Gedeactiveerde gebruikers',
	'disabledusers-summary' => 'Dit is een lijst van gebruikers die zijn gedeactiveerd via PasswordReset.',
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
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'passwordreset' => 'Passordresetting',
	'passwordreset-desc' => "[[Special:PasswordReset|Nullstill brukeres passord]] &ndash; krever 'passwordreset'-rettigheter",
	'passwordreset-invalidusername' => 'Ugyldig brukernavn',
	'passwordreset-emptyusername' => 'Tomt brukernavn',
	'passwordreset-nopassmatch' => 'Passordene er ikke de samme',
	'passwordreset-badtoken' => 'Ugyldig redigeringstegn',
	'passwordreset-username' => 'Brukernavn:',
	'passwordreset-newpass' => 'Nytt passord:',
	'passwordreset-confirmpass' => 'Bekreft passord:',
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

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'passwordreset-username' => 'Yuuser-Naame:',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'passwordreset-username' => 'Bruckernome:',
);

/** Polish (Polski)
 * @author Beau
 * @author Derbeth
 * @author Leinad
 * @author Saper
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'passwordreset' => 'Wyczyść hasło',
	'passwordreset-desc' => "[[Special:PasswordReset|Wyczyść hasło]] – ustawienie nowego hasła użytkownika wymaga uprawnienia 'passwordreset'",
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
	'passwordreset-disablesuccess' => 'Konto użytkownika zostało wyłączone (ID użytkownika – $1)',
	'passwordreset-accountdisabled' => 'Konto zostało wyłączone',
	'disabledusers' => 'Wyłączone konta użytkowników',
	'disabledusers-summary' => 'Lista użytkowników, których konta zostały wyłączone przy pomocy funkcji wyczyszczenia hasła.',
	'right-passwordreset' => 'Czyszczenie hasła użytkownika ([[Special:PasswordReset|na specjalnej stronie]])',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'passwordreset' => 'Cambi ëd ciav',
	'passwordreset-desc' => "[[Special:PasswordReset|A torna amposté le ciav ëd j'utent]] - a veul ël privilegi ëd 'passwordreset'",
	'passwordreset-invalidusername' => 'Stranòm nen giust',
	'passwordreset-emptyusername' => 'Stranòm veujd',
	'passwordreset-nopassmatch' => 'Le doe ciav a son pa mideme',
	'passwordreset-badtoken' => 'Còdes ëd modìfica nen bon',
	'passwordreset-username' => 'Stranòm:',
	'passwordreset-newpass' => 'Ciav neuva:',
	'passwordreset-confirmpass' => 'Conferma la ciav:',
	'passwordreset-submit' => 'Cambié la ciav',
	'passwordreset-success' => "La ciav ëd l'utent $1 a l'é staita cambià",
	'passwordreset-disableuser' => 'Disabilité ël cont utent?',
	'passwordreset-disableuserexplain' => "(a amposta na ciav pa bon-a a cas - l'utent a peul pa intré)",
	'passwordreset-disablesuccess' => "Ël cont ëd l'utent a l'é stàit disabilità për l'ID utent: $1",
	'passwordreset-accountdisabled' => "Ël cont a l'é stàit disabilità",
	'disabledusers' => 'Utent disabilità',
	'disabledusers-summary' => "Sta-sì a l'é na lista d'utent che a son ëstaàit disabilità via PasswordReset.",
	'right-passwordreset' => "Torna amposté la ciav ëd n'utent ([[Special:PasswordReset|pàgina special]])",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'passwordreset-invalidusername' => 'ناسم کارن-نوم',
	'passwordreset-emptyusername' => 'تش کارن-نوم',
	'passwordreset-nopassmatch' => 'پټنوم مو کټ مټ د يو بل سره سمون نه خوري',
	'passwordreset-username' => 'کارن-نوم:',
	'passwordreset-newpass' => 'نوی پټنوم:',
	'passwordreset-disableuser' => 'آيا په رښتيا دا ګڼون ناچارنول غواړۍ؟',
	'passwordreset-disablesuccess' => 'د دغه کارن پېژند ګڼون ناچارن شوی: $1',
	'passwordreset-accountdisabled' => 'ګڼون مو ناچارن شوی',
	'disabledusers' => 'ناچارن شوي کارنان',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'passwordreset' => 'Repor palavra-chave',
	'passwordreset-desc' => "[[Special:PasswordReset|Repõe palavras-chave dos utilizadores da wiki]] - requer privilégios 'passwordreset'",
	'passwordreset-invalidusername' => 'Nome de Utilizador Inválido',
	'passwordreset-emptyusername' => 'Nome de Utilizador Vazio',
	'passwordreset-nopassmatch' => 'Palavras-chave não coincidem',
	'passwordreset-badtoken' => 'Token de edição inválido',
	'passwordreset-username' => 'Nome de utilizador:',
	'passwordreset-newpass' => 'Nova palavra-chave:',
	'passwordreset-confirmpass' => 'Confirme a palavra-chave:',
	'passwordreset-submit' => 'Repor Palavra-Chave',
	'passwordreset-success' => 'A palavra-chave foi reposta para o utilizador com o ID: $1',
	'passwordreset-disableuser' => 'Desactivar Conta de Utilizador?',
	'passwordreset-disableuserexplain' => '(estabelece um hash de palavra-chave inválido - o utilizador não se consegue autenticar)',
	'passwordreset-disablesuccess' => 'A conta de utilizador foi desactivada (ID do utilizador: $1)',
	'passwordreset-accountdisabled' => 'A conta foi desactivada',
	'disabledusers' => 'Utilizadores desactivados',
	'disabledusers-summary' => 'Esta é a lista de utilizadores que foram desactivados via PasswordReset.',
	'right-passwordreset' => 'Repor palavra-chave de um utilizador ([[Special:PasswordReset|página especial]])',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'passwordreset' => 'Repor Palavra-chave',
	'passwordreset-desc' => "[[Special:PasswordReset|Repõe palavras-chaves de utilizadores do wiki]] - requer privilégios 'passwordreset'",
	'passwordreset-invalidusername' => 'Nome de Utilizador Inválido',
	'passwordreset-emptyusername' => 'Nome de Utilizador Vazio',
	'passwordreset-nopassmatch' => 'Palavras-Chave não coincidem',
	'passwordreset-badtoken' => 'Token de edição inválido',
	'passwordreset-username' => 'Nome de usuário:',
	'passwordreset-newpass' => 'Nova palavra-chave:',
	'passwordreset-confirmpass' => 'Confirme a palavra-chave:',
	'passwordreset-submit' => 'Repor Palavra-Chave',
	'passwordreset-success' => 'A palavra-chave foi reposta para o utilizador com o ID: $1',
	'passwordreset-disableuser' => 'Desativar Conta de Utilizador?',
	'passwordreset-disableuserexplain' => '(estabelece um hash de palavra-chave inválido - o utilizador não consegue se autenticar)',
	'passwordreset-disablesuccess' => 'A conta de utilizador foi desativada (ID do utilizador: $1)',
	'passwordreset-accountdisabled' => 'A conta foi desativada',
	'disabledusers' => 'Utilizadores desativados',
	'disabledusers-summary' => 'Esta é a lista de utilizadores que foram desativados via PasswordReset.',
	'right-passwordreset' => 'Repor palavra-chave de um utilizador ([[Special:PasswordReset|página especial]])',
);

/** Romansh (Rumantsch)
 * @author Gion-andri
 */
$messages['rm'] = array(
	'passwordreset-username' => "Num d'utilisader:",
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
	'disabledusers' => 'Utilizatori dezactivați',
);

/** Russian (Русский)
 * @author Ferrer
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
	'right-passwordreset' => 'сброс пароля участника ([[Special:PasswordReset|служебная страница]])',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'passwordreset-username' => 'Мено хоснователя:',
	'passwordreset-newpass' => 'Нове гесло:',
);

/** Sinhala (සිංහල)
 * @author තඹරු විජේසේකර
 */
$messages['si'] = array(
	'passwordreset' => 'මුරපදය වෙනස් කරන්න',
	'passwordreset-invalidusername' => 'පරිශීලක නාමය වලංගු නොවේ.',
	'passwordreset-emptyusername' => 'පරිශීලක නාමය හිස් කරන්න',
	'passwordreset-nopassmatch' => 'මුරපදයන් සමාන නොවේ.',
	'passwordreset-badtoken' => 'වලංගු නොවන සංස්කරණ සංඥාව',
	'passwordreset-username' => 'පරිශීලක නාමය:',
	'passwordreset-newpass' => 'නව මුර-පදය:',
	'passwordreset-confirmpass' => 'මුර-පදය සනාථ කිරීම:',
	'passwordreset-submit' => 'මුර-පදය යළි පිහිටුවන්න',
	'passwordreset-success' => '$1 ලෙස මුර-පදය යළි පිහිටුවිණි.',
	'passwordreset-disableuser' => 'පරිශීලක ගිණුම අක්‍රිය කරන්න ද?',
	'passwordreset-accountdisabled' => 'ගිණුම අක්‍රීය කෙරිණි.',
	'disabledusers' => 'අක්‍රීය පරිශීලකයන්',
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

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'passwordreset' => 'Обнављање лозинке',
	'passwordreset-invalidusername' => 'Неисправно корисничко име',
	'passwordreset-emptyusername' => 'Празно корисничко име',
	'passwordreset-nopassmatch' => 'Лозинке се не поклапају',
	'passwordreset-username' => 'Корисничко име:',
	'passwordreset-newpass' => 'Нова лозинка:',
	'passwordreset-confirmpass' => 'Потврдите лозинку:',
	'passwordreset-submit' => 'Обнови лозинку',
	'passwordreset-success' => 'Лозинка је обновљена за кориснички ID: $1',
	'passwordreset-disableuser' => 'Онемогућити кориснички налог?',
	'passwordreset-disableuserexplain' => '(поставља неисправан хеш лозинке — корисник не може да се улогује)',
	'passwordreset-disablesuccess' => 'Налог је онемогућен за кориснички ID: $1',
	'passwordreset-accountdisabled' => 'Налог је онемогућен',
	'disabledusers' => 'Онемогућени корисници',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'passwordreset' => 'Obnavljanje lozinke',
	'passwordreset-invalidusername' => 'Neispravno korisničko ime',
	'passwordreset-emptyusername' => 'Prazno korisničko ime',
	'passwordreset-nopassmatch' => 'Lozinke se ne poklapaju',
	'passwordreset-username' => 'Korisničko ime:',
	'passwordreset-newpass' => 'Nova lozinka:',
	'passwordreset-confirmpass' => 'Potvrdite lozinku:',
	'passwordreset-submit' => 'Obnovi lozinku',
	'passwordreset-success' => 'Lozinka je obnovljena za korisnički ID: $1',
	'passwordreset-disableuser' => 'Onemogućiti korisnički nalog?',
	'passwordreset-disableuserexplain' => '(postavlja neispravan heš lozinke — korisnik ne može da se uloguje)',
	'passwordreset-disablesuccess' => 'Nalog je onemogućen za korisnički ID: $1',
	'passwordreset-accountdisabled' => 'Nalog je onemogućen',
	'disabledusers' => 'Onemogućeni korisnici',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'passwordreset' => 'Paaswoud touräächsätte',
	'passwordreset-desc' => "[[Special:PasswordReset|Touräächsätten fon n Benutser-Paaswoud]] - ''passwordreset''-Gjucht nöödich",
	'passwordreset-invalidusername' => 'Uungultigen Benutsernoome',
	'passwordreset-emptyusername' => 'Loosen Benutsernoome',
	'passwordreset-nopassmatch' => 'Paaswoude stimme nit uureen',
	'passwordreset-badtoken' => 'Ungultigen „Edit Token“',
	'passwordreset-username' => 'Benutsernoome:',
	'passwordreset-newpass' => 'Näi Paaswoud:',
	'passwordreset-confirmpass' => 'Paaswoud bestäätigje:',
	'passwordreset-submit' => 'Paaswoud touräächsätte',
	'passwordreset-success' => 'Paaswoud foar Benutser-ID $1 wuude touräächsät',
	'passwordreset-disableuser' => 'Benutserkonto deaktivierje?',
	'passwordreset-disableuserexplain' => '(sät n uungultich Paaswoud-Hash - Anmäldjen uunmuugelk)',
	'passwordreset-disablesuccess' => 'Benutserkonto wuude deaktivierd (Benutser-ID: $1)',
	'passwordreset-accountdisabled' => 'Benutserkonto is deaktivierd',
	'disabledusers' => 'Deaktivierde Benutserkonten',
	'disabledusers-summary' => 'Dit is ju Lieste fon do deaktivierde Benutserkonten (via PasswordReset).',
	'right-passwordreset' => 'Paaswoud fon n Benutser touräächsätte ([[Special:PasswordReset|Spezioalsiede]])',
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
 * @author TRYPPN
 * @author Trengarasu
 */
$messages['ta'] = array(
	'passwordreset-username' => 'பயனர் பெயர்:',
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
	'passwordreset-confirmpass' => 'సంకేతపదాన్ని నిర్ధారించండి:',
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

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'passwordreset-invalidusername' => "Nomi korbariji nomū'tabar",
);

/** Thai (ไทย)
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'passwordreset' => 'ล้างรหัสผ่าน',
	'passwordreset-desc' => "[[Special:PasswordReset|เปลี่ยนรหัสผ่านของผู้ใช้]] - ต้องการสิทธิ 'เปลี่ยนรหัสผ่าน'",
	'passwordreset-invalidusername' => 'ชื่อผู้ใช้ไม่ถูกต้อง',
	'passwordreset-emptyusername' => 'ชื่อผู้ใช้ว่างเปล่า',
	'passwordreset-nopassmatch' => 'รหัสผ่านไม่ตรงกัน',
	'passwordreset-username' => 'ชื่อผู้ใช้:',
	'passwordreset-newpass' => 'รหัสผ่านใหม่:',
	'passwordreset-confirmpass' => 'ยืนยันรหัสผ่าน:',
	'passwordreset-submit' => 'เปลี่ยนรหัสผ่าน',
	'passwordreset-success' => 'รหัสผ่านถูกเปลี่ยนใหม่เรียบร้อยแล้วสำหรับชื่อผู้ใช้: $1',
	'passwordreset-disableuser' => 'ระงับการใช้งานบัญชีผู้ใช้?',
	'passwordreset-disableuserexplain' => '(มีอักขระในรหัสผ่านที่ไม่สามารถใช้งานได้ - ผู้ใช้ไม่สามารถล็อกอินได้)',
	'passwordreset-disablesuccess' => 'บัญชีผู้ใช้ได้ถูกระงับแล้ว (ไอดีผู้ใช้: $1)',
	'passwordreset-accountdisabled' => 'บัญชีถูกระงับแล้ว',
	'disabledusers' => 'ผู้ใช้ที่ถูกระงับ',
	'disabledusers-summary' => 'นี่คือรายชื่อของผู้ใช้ที่ถูกระงับโดยการล้างรหัสผ่าน',
	'right-passwordreset' => 'เปลี่ยนรหัสผ่านของผู้ใช้ ([[Special:PasswordReset|หน้าพิเศษ]])',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'passwordreset-username' => 'Ulanyjy ady:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'passwordreset' => 'Muling pagtatakda ng hudyat',
	'passwordreset-desc' => "[[Special:PasswordReset|Muling nagtatakda ng mga hudyat ng tagagamit]] - nangangailangan ng mga karapatang pang-'passwordreset'",
	'passwordreset-invalidusername' => 'Hindi tanggap na pangalan ng tagagamit',
	'passwordreset-emptyusername' => 'Walang lamang pangalan ng tagagamit',
	'passwordreset-nopassmatch' => 'Hindi nagtutugma ang mga hudyat',
	'passwordreset-badtoken' => 'Hindi tanggap na kahalip/tanda ng pagbabago',
	'passwordreset-username' => 'Pangalan ng tagagamit:',
	'passwordreset-newpass' => 'Bagong hudyat:',
	'passwordreset-confirmpass' => 'Tiyakin ang hudyat:',
	'passwordreset-submit' => 'Muling itakda ang hudyat',
	'passwordreset-success' => 'Muli nang itinakda ang hudyat para sa ID ng tagagamit: $1',
	'passwordreset-disableuser' => 'Huwag nang paganahin ang kuwenta ng tagagamit?',
	'passwordreset-disableuserexplain' => '(nagtatakda ng hindi tanggap na pampagulo ng hudyat - hindi makalalagda ang tagagamit)',
	'passwordreset-disablesuccess' => 'Hindi na pinagana ang kuwenta ng tagagamit para sa ID ng tagagamit: $1',
	'passwordreset-accountdisabled' => 'Hindi na pinagana ang kuwenta/akawnt',
	'disabledusers' => 'Mga hindi na pinagaganang mga tagagamit',
	'disabledusers-summary' => "Isa itong talaan ng mga tagagamit na hindi na pinagana sa pamamagitan ng ''PasswordReset''.",
	'right-passwordreset' => 'Muling itinakdang hudyat para sa isang tagagamit ([[Special:PasswordReset|natatanging pahina]])',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'passwordreset' => 'Parola sıfırlama',
	'passwordreset-desc' => "[[Special:PasswordReset|Viki kullanıcısının parolasını sıfırlar]] - 'passwordreset' yetkisini gerektirir",
	'passwordreset-invalidusername' => 'Geçersiz kullanıcı adı',
	'passwordreset-emptyusername' => 'Boş kullanıcı adı',
	'passwordreset-nopassmatch' => 'Parolalar eşleşmiyor',
	'passwordreset-badtoken' => 'Geçersiz değişiklik simgesi',
	'passwordreset-username' => 'Kullanıcı adı:',
	'passwordreset-newpass' => 'Yeni parola:',
	'passwordreset-confirmpass' => 'Parolayı doğrula:',
	'passwordreset-submit' => 'parola sıfırla',
	'passwordreset-success' => '$1 kullanıcı kimliği için parola sıfırlandı',
	'passwordreset-disableuser' => 'Kullanıcı hesabı devre dışı bırakılsın mı?',
	'passwordreset-disableuserexplain' => '(geçersiz bir parola sağlama ayarları - kullanıcı oturum açamaz)',
	'passwordreset-disablesuccess' => 'Kullanıcı hesabı, kullanıcı kimliği $1 için devre dışı bırakıldı',
	'passwordreset-accountdisabled' => 'Hesap devre dışı bırakıldı',
	'disabledusers' => 'Devre dışı bırakılan kullanıcılar',
	'disabledusers-summary' => 'PasswordReset ile devre dışı bırakılan kullanıcıların bir listesidir.',
	'right-passwordreset' => 'Bir kullanıcının parolasını sıfırlar ([[Special:PasswordReset|özel sayfa]])',
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'passwordreset-username' => 'ئىشلەتكۇچى ئىسمى:',
);

/** Uighur (Latin) (ئۇيغۇرچە / Uyghurche‎ (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'passwordreset-username' => 'Ishletkuchi ismi:',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'passwordreset-invalidusername' => "Неправильне ім'я користувача",
	'passwordreset-emptyusername' => "Пусте ім'я користувача",
	'passwordreset-nopassmatch' => 'Паролі не співпадають',
	'passwordreset-badtoken' => 'Неприпустимий маркер редагування',
	'passwordreset-username' => "Ім'я користувача:",
	'passwordreset-newpass' => 'Новий пароль:',
	'passwordreset-confirmpass' => 'Підтвердіть пароль:',
	'passwordreset-submit' => 'Скинути пароль',
);

/** Urdu (اردو)
 * @author محبوب عالم
 */
$messages['ur'] = array(
	'passwordreset' => 'پارلفظ کی بازتعینی',
	'passwordreset-invalidusername' => 'اسم صارف غلط ہے',
	'passwordreset-emptyusername' => 'اسمِ صارف خالی ہے',
	'passwordreset-nopassmatch' => 'پارالفاظ ایک دوسرے سے مطابقت نہیں رکھتے',
	'passwordreset-username' => 'اسمِ صارف:',
	'passwordreset-newpass' => 'نیا پارلفظ:',
	'passwordreset-confirmpass' => 'پارلفظ کی تصدیق:',
	'passwordreset-submit' => 'پارلفظ تبدیل کرو',
	'passwordreset-success' => 'شناخت $1 کیلئے پارلفظ تبدیل ہوگیا',
	'passwordreset-disableuser' => 'کھاتۂ صارف ناکارہ بنائیں؟',
	'passwordreset-disablesuccess' => 'شناخت $1 کیلئے کھاتۂ صارف ناکارہ بنادیا گیا',
	'passwordreset-accountdisabled' => 'کھاتہ ناکارہ بنادیا گیا',
	'disabledusers' => 'ناکارہ صارفین',
	'disabledusers-summary' => 'یہ اُن صارفین کی فہرست ہے جو پارلفظ بازتعینی کے ذریعے ناکارہ بنائے گئے ہیں.',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'passwordreset-invalidusername' => 'Vär kävutajannimi',
	'passwordreset-emptyusername' => "Pall'az kävutajan nimi",
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
	'passwordreset-emptyusername' => 'Gebenanem vagik',
	'passwordreset-username' => 'Gebananem:',
	'passwordreset-newpass' => 'Letavöd nulik:',
	'passwordreset-confirmpass' => 'Fümedolös letavödi:',
	'passwordreset-submit' => 'Dönuvälön letavödi',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'passwordreset-invalidusername' => 'אומגילטיקער באַניצער נאָמען',
	'passwordreset-emptyusername' => 'ליידיגער באַניצער נאָמען',
	'passwordreset-nopassmatch' => 'פאַסווערטער שטימען נישט',
	'passwordreset-username' => 'באַניצער נאָמען:',
	'passwordreset-newpass' => 'ניי פּאסוואָרט:',
	'passwordreset-confirmpass' => 'באַשטעטיקן פאַסוואָרט:',
);

/** Cantonese (粵語) */
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
 * @author Hydra
 * @author Kuailong
 */
$messages['zh-hans'] = array(
	'passwordreset' => '密码重设',
	'passwordreset-invalidusername' => '无效的用户名',
	'passwordreset-emptyusername' => '空白的用户名',
	'passwordreset-nopassmatch' => '密码不匹配',
	'passwordreset-badtoken' => '无效的编辑币',
	'passwordreset-username' => '用户名：',
	'passwordreset-newpass' => '新密码：',
	'passwordreset-confirmpass' => '密码确认：',
	'passwordreset-submit' => '重设密码',
	'passwordreset-success' => 'User_id: $1 的密码已经重设',
	'passwordreset-disableuser' => '禁用用户帐户？',
	'passwordreset-accountdisabled' => '账户已停用',
	'disabledusers' => '已禁用的用户',
	'disabledusers-summary' => '这是通过PasswordReset禁用账户的用户列表。',
	'right-passwordreset' => '重置密码或用户（[[Special:PasswordReset|特殊页面]]）',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'passwordreset' => '重新設定密碼',
	'passwordreset-invalidusername' => '無效的用戶名',
	'passwordreset-emptyusername' => '空白的用戶名',
	'passwordreset-nopassmatch' => '密碼不匹配',
	'passwordreset-badtoken' => '無效的編輯幣',
	'passwordreset-username' => '使用者名稱：',
	'passwordreset-newpass' => '新密碼：',
	'passwordreset-confirmpass' => '確認密碼：',
	'passwordreset-submit' => '重設密碼',
	'passwordreset-success' => 'User_id: $1 的密碼已經重設',
	'passwordreset-disableuser' => '停用使用者帳號？',
	'passwordreset-accountdisabled' => '帳號已停用',
	'disabledusers' => '已停用的使用者',
	'disabledusers-summary' => '這是透過 PasswordReset 停用帳號的使用者清單。',
	'right-passwordreset' => '使用者的密碼重新設定（[[Special:PasswordReset|特殊頁面]]）',
);

