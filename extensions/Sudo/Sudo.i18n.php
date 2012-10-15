<?php
/**
 * Sudo
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Friesen (http://mediawiki.org/wiki/User:Dantman) <mediawiki@danielfriesen.name>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

$messages = array();

/** English
 * @author Daniel Friesen
 */
$messages['en'] = array(
	'sudo'                        => "Log into another user's account",
	'unsudo'                      => 'Return to your account',
	'sudo-desc'                   => 'Allows sudoers to login as other users',
	'sudo-personal-unsudo'        => 'Return to your account',
	'sudo-form'                   => 'Login to:',
	'sudo-user'                   => 'Username:',
	'sudo-reason'                 => 'Reason:',
	'sudo-submit'                 => 'Login',
	'sudo-unsudo'                 => 'Welcome $1, you are currently logged into the wiki as $2. Click on "{{int:sudo-unsudo-submit}}" to return to your own account.',
	'sudo-unsudo-submit'          => 'Return',
	'sudo-success'                => 'Welcome $1, you are now logged into the wiki as $2.',
	'sudo-error'                  => 'Sudo error: $1',
	'sudo-error-sudo-invaliduser' => 'Invalid username',
	'sudo-error-sudo-ip'          => 'Cannot login as an IP address',
	'sudo-error-sudo-nonexistent' => 'That user does not exist',
	'sudo-error-sudo-self'        => 'Cannot sudo into yourself',
	'sudo-error-nosudo'           => 'You do not appear to be logged on as another user using sudo.',
	'sudo-logpagename'            => 'Sudo log',
	'sudo-logpagetext'            => 'This is a log of all uses of sudo.',
	'sudo-logentry'               => "logged into $2's account",
	'right-sudo'                  => "Login to another user's account",
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'sudo-desc' => '{{desc}}',
	'sudo-user' => '{{Identical|Username}}',
	'sudo-reason' => '{{Identical|Reason}}',
	'sudo-submit' => '{{Identical|Login}}',
	'right-sudo' => '{{doc-right|sudo}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'unsudo' => 'Keer terug na u eie gebruiker',
	'sudo-personal-unsudo' => 'Keer terug na u eie gebruiker',
	'sudo-form' => 'Meld aan as:',
	'sudo-user' => 'Gebruikersnaam:',
	'sudo-reason' => 'Rede:',
	'sudo-submit' => 'Aanmeld',
	'sudo-unsudo-submit' => 'Terug',
	'sudo-error' => 'Sudo-fout: $1',
	'sudo-error-sudo-invaliduser' => 'Ongeldige gebruikersnaam',
);

/** Arabic (العربية)
 * @author OsamaK
 * @author روخو
 */
$messages['ar'] = array(
	'sudo' => 'تسجيل الدخول بحساب مستخدم آخر',
	'sudo-personal-unsudo' => 'عودة إلى حسابك',
	'sudo-form' => 'تسجيل الدخول إلى:',
	'sudo-user' => 'اسم المستخدم:',
	'sudo-reason' => 'السبب:',
	'sudo-submit' => 'تسجيل الدخول',
	'sudo-unsudo-submit' => 'تراجع',
	'sudo-success' => 'مرحبا $1, انت قمت الان بتسجيل الدخول الى الويكي باسم $2.',
	'sudo-error-sudo-invaliduser' => 'اسم المستخدم غير صحيح',
	'sudo-error-sudo-nonexistent' => 'ذلك المستخدم غير موجود',
	'sudo-logpagename' => 'سجل الأمر Sudo',
	'right-sudo' => 'تسجيل الدخول بحساب مستخدم آخر',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Wertuose
 */
$messages['az'] = array(
	'sudo-user' => 'İstifadəçi adı:',
	'sudo-reason' => 'Səbəb:',
	'sudo-submit' => 'Daxil ol',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'sudo' => 'Увайсьці ў рахунак іншага удзельніка',
	'unsudo' => 'Вярнуцца ў Ваш рахунак',
	'sudo-desc' => 'Дазваляе выбраным удзельнікам уваходзіць ў сыстэму як іншыя ўдзельнікі',
	'sudo-personal-unsudo' => 'Вярнуцца ў Ваш рахунак',
	'sudo-form' => 'Увайсьці ў:',
	'sudo-user' => 'Імя ўдзельніка:',
	'sudo-reason' => 'Прычына:',
	'sudo-submit' => 'Увайсьці',
	'sudo-unsudo' => 'Вітаем, $1! Цяпер Вы ўвайшлі ў {{GRAMMAR:вінавальны|{{SITENAME}}}} як $2. Націсьніце «{{int:sudo-unsudo-submit}}» каб вярнуцца ў свой рахунак.',
	'sudo-unsudo-submit' => 'Вярнуцца',
	'sudo-success' => 'Вітаем, $1! Цяпер Вы ўвайшлі ў {{GRAMMAR:вінавальны|{{SITENAME}}}} як $2.',
	'sudo-error' => 'Памылка уваходу ў сыстэму як іншага ўдзельніка: $1',
	'sudo-error-sudo-invaliduser' => 'Няслушнае імя ўдзельніка',
	'sudo-error-sudo-ip' => 'Немагчыма ўвайсьці ў IP-адрас',
	'sudo-error-sudo-nonexistent' => 'Гэты рахунак не існуе',
	'sudo-error-sudo-self' => 'Немагчыма пераўвайсьці ва ўласны рахунак',
	'sudo-error-nosudo' => 'Выглядае, што Вы не ўвайшлі ў рахунак, які дазваляе уваход ў сыстэму як іншага ўдзельніка',
	'sudo-logpagename' => 'Журнал уваходаў у рахункі іншых удзельнікаў',
	'sudo-logpagetext' => 'Гэта журнал усіх уваходаў у рахункі іншых удзельнікаў.',
	'sudo-logentry' => 'увайшоў у рахунак $2',
	'right-sudo' => 'уваход ў рахункі іншых удзельнікаў',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'sudo' => 'Kevreañ dre gont un implijer all',
	'unsudo' => "Distreiñ d'ho kont",
	'sudo-desc' => "Talvezout a ra d'ar sudoerien da gevreañ evel implijerien all",
	'sudo-personal-unsudo' => "Distreiñ d'ho kont",
	'sudo-form' => 'Kevreañ da :',
	'sudo-user' => 'Anv implijer :',
	'sudo-reason' => 'Abeg :',
	'sudo-submit' => 'Kevreañ',
	'sudo-unsudo' => 'DEgemer mat $1, evit ar poent emaoc\'h kevreet er wiki evel $2. Klikañ war "{{int:sudo-unsudo-submit}}" evit distreiñ d\'ho kevreadenn deoc\'h-c\'hwi.',
	'sudo-unsudo-submit' => 'Distreiñ',
	'sudo-success' => "Demeger mat $1, kevreet oc'h bremañ er wiki evel $2.",
	'sudo-error' => 'Fazi Sudo : $1',
	'sudo-error-sudo-invaliduser' => 'Anv implijer direizh',
	'sudo-error-sudo-ip' => "N'hall ket kevreañ ouzh ur chomlec'h IP",
	'sudo-error-sudo-nonexistent' => "N'eus ket eus an implijer-mañ",
	'sudo-error-sudo-self' => "Dibosupl eo sudoañ ennoc'h hoc'h-unan",
	'sudo-error-nosudo' => "Evit doare n'emaoc'h ket en ur gevreadenn sudo",
	'sudo-logpagename' => 'Marilh sudo',
	'sudo-logpagetext' => 'Hemañ zo ur marilh eus holl implijoù sudo.',
	'sudo-logentry' => 'keveet e kont $2',
	'right-sudo' => 'Kevreañ dre gont un implijer all.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'sudo' => 'Prijava na račun drugog korisnika',
	'unsudo' => 'Nazad na svoj račun',
	'sudo-desc' => 'Omogućuje sudo korisnicima da se prijave kao neki drugi korisnik',
	'sudo-personal-unsudo' => 'Nazad na svoj račun',
	'sudo-form' => 'Prijava na:',
	'sudo-user' => 'Korisničko ime:',
	'sudo-reason' => 'Razlog:',
	'sudo-submit' => 'Prijava',
	'sudo-unsudo' => 'Dobrodošli $1, trenutno ste prijavljeni na wiki kao $2. Kliknite na "{{int:sudo-unsudo-submit}}" da se vratite na vaš vlastiti račun.',
	'sudo-unsudo-submit' => 'Nazad',
	'sudo-success' => 'Dobrodošli $1, sada ste prijavljeni na wiki kao $2.',
	'sudo-error' => 'Sudo greška: $1',
	'sudo-error-sudo-invaliduser' => 'Nevaljano korisničko ime',
	'sudo-error-sudo-ip' => 'Ne mogu se prijaviti na IP adresu',
	'sudo-error-sudo-nonexistent' => 'Ovaj korisnik ne postoji.',
	'sudo-error-sudo-self' => 'Ne možete prijaviti samog sebe',
	'sudo-error-nosudo' => 'Izgleda da se ne nalazite unutar sudo prijave',
	'sudo-logpagename' => 'Sudo zapisnik',
	'sudo-logpagetext' => 'Ovo je zapisnik svih sudo korištenja.',
	'sudo-logentry' => 'prijavljen na račun od $2',
	'right-sudo' => 'Prijavljivanje na račun drugog korisnika',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'sudo-reason' => 'Motiu:',
);

/** German (Deutsch)
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de'] = array(
	'sudo' => 'Mit anderem Benutzerkonto anmelden',
	'unsudo' => 'Zum eigenen Benutzerkonto zurückkehren',
	'sudo-desc' => 'Ermöglicht die Anmeldung mit einem anderen Benutzerkonto als dem Eigenen',
	'sudo-personal-unsudo' => 'Zum eigenen Benutzerkonto zurückkehren',
	'sudo-form' => 'Anmelden als:',
	'sudo-user' => 'Benutzername:',
	'sudo-reason' => 'Grund:',
	'sudo-submit' => 'Anmelden',
	'sudo-unsudo' => 'Willkommen $1, du bist momentan als Benutzer „$2“ im Wiki angemeldet. Klicke auf „{{int:sudo-unsudo-submit}}“, um zu deinem eigenen Benutzerkonto zurückzukehren.',
	'sudo-unsudo-submit' => 'Zurückkehren',
	'sudo-success' => 'Willkommen $1, du bist jetzt im Wiki als Benutzer „$2“ angemeldet.',
	'sudo-error' => 'Sudo-Fehler: $1',
	'sudo-error-sudo-invaliduser' => 'Ungültiger Benutzername',
	'sudo-error-sudo-ip' => 'Man kann sich nicht mit einer IP-Adresse anmelden',
	'sudo-error-sudo-nonexistent' => 'Dieser Benutzer ist nicht vorhanden',
	'sudo-error-sudo-self' => 'Man kann sich nicht noch einmal selbst anmelden',
	'sudo-error-nosudo' => 'Du scheinst nicht mit einem anderen Benutzerkonto angemeldet zu sein',
	'sudo-logpagename' => 'Sudo-Logbuch',
	'sudo-logpagetext' => 'Dies ist das Logbuch aller Verwendungen von „sudo“.',
	'sudo-logentry' => 'hat sich mit dem Benutzerkonto von $2 angemeldet',
	'right-sudo' => 'Mit anderem Benutzerkonto anmelden',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'sudo-unsudo' => 'Willkommen $1, Sie sind momentan als Benutzer „$2“ im Wiki angemeldet. Klicken Sie auf „{{int:sudo-unsudo-submit}}“, um zu Ihrem eigenen Benutzerkonto zurückzukehren.',
	'sudo-success' => 'Willkommen $1, Sie sind jetzt im Wiki als Benutzer „$2“ angemeldet.',
	'sudo-error-nosudo' => 'Sie scheinen nicht mit einem anderen Benutzerkonto angemeldet zu sein',
);

/** Spanish (Español)
 * @author Fitoschido
 */
$messages['es'] = array(
	'sudo' => 'Iniciar sesión en la cuenta de otro usuario',
	'unsudo' => 'Volver a tu cuenta',
	'sudo-personal-unsudo' => 'Volver a tu cuenta',
	'sudo-form' => 'Iniciar sesión a:',
	'sudo-user' => 'Nombre de usuario:',
	'sudo-reason' => 'Motivo:',
	'sudo-submit' => 'Iniciar sesión',
	'sudo-unsudo' => 'Bienvenido $1, has iniciado sesión en el wiki como $2. Pulsa en «{{int:sudo-unsudo-submit}}» para volver a tu cuenta.',
	'sudo-unsudo-submit' => 'Volver',
	'sudo-success' => 'Bienvenido $1, ahora has iniciado sesión en el wiki como $2.',
	'sudo-error' => 'Error de sudo: $1',
	'sudo-error-sudo-invaliduser' => 'Nombre de usuario no válido',
	'sudo-error-sudo-ip' => 'No se puede iniciar sesión como una dirección IP',
	'sudo-error-sudo-nonexistent' => 'Ese usuario no existe',
	'sudo-error-sudo-self' => 'No se puede usar sudo en la cuenta propia',
	'sudo-logpagename' => 'Registro de sudo',
	'sudo-logpagetext' => 'Este es un registro de todos los usos de sudo.',
	'sudo-logentry' => 'sesión iniciada con la cuenta de $2',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Veikk0.ma
 */
$messages['fi'] = array(
	'sudo' => 'Kirjaudu toisena käyttäjänä',
	'unsudo' => 'Palaa omalle tunnuksellesi',
	'sudo-desc' => 'Mahdollistaa sudo-käyttäjien kirjautua toisena käyttäjänä',
	'sudo-personal-unsudo' => 'Palaa omalle tunnuksellesi',
	'sudo-form' => 'Kirjaudu:',
	'sudo-user' => 'Käyttäjätunnus',
	'sudo-reason' => 'Syy',
	'sudo-submit' => 'Kirjaudu',
	'sudo-unsudo' => 'Tervetuloa $1. Olet tällä hetkellä kirjautuneena käyttäjänä $2. Palaa omalle tunnuksellesi napsauttamalla {{int:sudo-unsudo-submit}}.',
	'sudo-unsudo-submit' => 'Palaa',
	'sudo-success' => 'Tervetuloa $1. Olet nyt kirjautuneena käyttäjänä $2.',
	'sudo-error' => 'Sudo-virhe: $1',
	'sudo-error-sudo-invaliduser' => 'Virheellinen käyttäjätunnus',
	'sudo-error-sudo-ip' => 'Ei voida kirjautua IP-osoitteeseen',
	'sudo-error-sudo-nonexistent' => 'Käyttäjää ei ole olemassa',
	'sudo-error-sudo-self' => 'Et voi käyttää sudoa omalle tunnuksellesi',
	'sudo-error-nosudo' => 'Et näytä olevan kirjautuneena sudo-tilillä',
	'sudo-logpagename' => 'Sudoloki',
	'sudo-logpagetext' => 'Tämä on loki kaikista sudon käytöistä.',
	'sudo-logentry' => 'kirjautui käyttäjänä $2',
	'right-sudo' => 'Kirjautua toisen käyttäjän tunnuksella',
);

/** French (Français)
 * @author Otourly
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'sudo' => "Connectez-vous au compte d'un autre utilisateur",
	'unsudo' => 'Retour à votre compte',
	'sudo-desc' => "Permet au ''sudoers'' de se connecter en tant qu'un autre utilisateur",
	'sudo-personal-unsudo' => 'Retour à votre compte',
	'sudo-form' => 'Connexion à:',
	'sudo-user' => 'Nom d’utilisateur :',
	'sudo-reason' => 'Raison :',
	'sudo-submit' => 'Connexion',
	'sudo-unsudo' => 'Bienvenue $1, vous êtes actuellement connecté au wiki en tant que $2. Cliquez sur {{int:sudo-unsudo-submit}} pour revenir à votre connexion précédente.',
	'sudo-unsudo-submit' => 'Retour',
	'sudo-success' => 'Bienvenue $1, vous êtes maintenant connecté au wiki en tant que $2.',
	'sudo-error' => "Erreur de ''sudo'': $1",
	'sudo-error-sudo-invaliduser' => 'Nom d’utilisateur invalide',
	'sudo-error-sudo-ip' => 'Ne peut se connecter à une adresse IP',
	'sudo-error-sudo-nonexistent' => "Cet utilisateur n'existe pas",
	'sudo-error-sudo-self' => "Impossible de s'identifier ''via sudo'' sur son propre compte",
	'sudo-error-nosudo' => 'Vous ne semblez pas être dans une connexion sudo',
	'sudo-logpagename' => "Historique de ''sudo''",
	'sudo-logpagetext' => "Ceci est un historique de toutes les utilisations de ''sudo''.",
	'sudo-logentry' => 'connecté au compte $2',
	'right-sudo' => "Connexion au compte d'un autre utilisateur",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'sudo' => 'Branchiéd-vos u compto a un ôtro usanciér',
	'unsudo' => 'Retôrn a voutron compto',
	'sudo-desc' => 'Pèrmèt ux usanciérs sudô de sè branchiér coment un ôtro usanciér.',
	'sudo-personal-unsudo' => 'Retôrn a voutron compto',
	'sudo-form' => 'Branchement a :',
	'sudo-user' => 'Nom d’usanciér :',
	'sudo-reason' => 'Rêson :',
	'sudo-submit' => 'Branchement',
	'sudo-unsudo-submit' => 'Retôrn',
	'sudo-success' => 'Benvegnua $1, vos éte ora branchiê u vouiqui coment $2.',
	'sudo-error' => 'Èrror sudô : $1',
	'sudo-error-sudo-invaliduser' => 'Nom d’utilisator envalido',
	'sudo-error-sudo-ip' => 'Sè pôt pas branchiér a una adrèce IP',
	'sudo-error-sudo-nonexistent' => 'Cél usanciér ègziste pas',
	'sudo-error-sudo-self' => "Empossiblo de sè branchiér ''per sudô'' sur son prôpro compto",
	'sudo-error-nosudo' => 'Vos semblâd pas étre dens un branchement sudô',
	'sudo-logpagename' => 'Historico sudô',
	'sudo-logpagetext' => "O est un historico de tôs los usâjos de ''sudô''.",
	'sudo-logentry' => 'branchiê u compto $2',
	'right-sudo' => 'Branchement u compto a un ôtro usanciér',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'sudo' => 'Acceder ao sistema coa conta doutro usuario',
	'unsudo' => 'Volver á súa conta',
	'sudo-desc' => 'Permite acceder ao sistema como outro usuario',
	'sudo-personal-unsudo' => 'Volver á súa conta',
	'sudo-form' => 'Rexistro en:',
	'sudo-user' => 'Nome de usuario:',
	'sudo-reason' => 'Motivo:',
	'sudo-submit' => 'Rexistro',
	'sudo-unsudo' => 'Benvido $1, está conectado no wiki como $2. Prema en "{{int:sudo-unsudo-submit}}" para regresar á súa conexión anterior.',
	'sudo-unsudo-submit' => 'Volver',
	'sudo-success' => 'Benvido $1, está conectado no wiki como $2.',
	'sudo-error' => 'Erro do sudo: $1',
	'sudo-error-sudo-invaliduser' => 'Nome de usuario inválido',
	'sudo-error-sudo-ip' => 'Non pode acceder ao sistema como un enderezo IP',
	'sudo-error-sudo-nonexistent' => 'Ese usuario non existe',
	'sudo-error-sudo-self' => 'Non se pode identificar como sudo na súa conta',
	'sudo-error-nosudo' => 'Semella non estar nunha conexión sudo',
	'sudo-logpagename' => 'Rexistro de sudo',
	'sudo-logpagetext' => 'Este é un rexistro de todos os usos do sudo.',
	'sudo-logentry' => 'accedeu ao sistema coa conta de $2',
	'right-sudo' => 'Acceder ao sistema coa conta doutro usuario',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'sudo' => 'Mit eme andere Benutzerkonto aamälde',
	'unsudo' => 'Zum eigene Benutzerkonto zruckchehre',
	'sudo-desc' => 'Macht d Aamäldig megli mit eme anderen Benutzerkonto („sudo“)',
	'sudo-personal-unsudo' => 'Zum eigene Benutzerkonto zruckchehre',
	'sudo-form' => 'Aamälden as:',
	'sudo-user' => 'Benutzername:',
	'sudo-reason' => 'Grund:',
	'sudo-submit' => 'Aamälde',
	'sudo-unsudo' => 'Willchuu $1, Du bisch zurzyt as Benutzer „$2“ im Wiki aagmäldet. Klick uf „{{int:sudo-unsudo-submit}}“ go zue Dyym eigen Benutzerkonto zruckchehre.',
	'sudo-unsudo-submit' => 'Zruckchehre',
	'sudo-success' => 'Willchuu $1, Du bisch jetz im Wiki as Benutzer „$2“ aagmäldet.',
	'sudo-error' => 'Sudo-Fäler: $1',
	'sudo-error-sudo-invaliduser' => 'Nit giltige Benutzername',
	'sudo-error-sudo-ip' => 'Mer cha sich nit mit ere IP-Adräss aamälde',
	'sudo-error-sudo-nonexistent' => 'Dää Benutzer git s nit.',
	'sudo-error-sudo-self' => 'Mer cha sich nit nomol sälber aamälde',
	'sudo-error-nosudo' => 'Du bisch schyns nit mit eme andere Benutzerkonto aagmäldet',
	'sudo-logpagename' => 'Sudo-Logbuech',
	'sudo-logpagetext' => 'Des isch s Logbuech vu allne Verwändige vu „sudo“.',
	'sudo-logentry' => 'het sich mit em Benutzerkonto vu $2 aagmäldet',
	'right-sudo' => 'Mit eme andere Benutzerkonto aamälde',
);

/** Manx (Gaelg)
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'sudo-reason' => 'Fa:',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'sudo' => 'להיכנס לחשבון של משתמש אחר',
	'unsudo' => 'חזרה לחשבונכם',
	'sudo-desc' => 'מאפשר למשתמשים מורשים (sudoers) להיכנס בתור משתמשים אחרים',
	'sudo-personal-unsudo' => 'חזרה לחשבונכם',
	'sudo-form' => 'להיכנס אל:',
	'sudo-user' => 'שם המשתמש:',
	'sudo-reason' => 'סיבה:',
	'sudo-submit' => 'להיכנס',
	'sudo-unsudo' => 'ברוך בואכם, $1, עכשיו אתם בחשבון בתור $2. לחצו על "{{int:sudo-unsudo-submit}}" כדי לחזור לחשבונכם.',
	'sudo-unsudo-submit' => 'חזרה',
	'sudo-success' => 'ברוכים הבאים, $1, עכשיו נכנסתם לוויקי בתור $2.',
	'sudo-error' => 'שגיאת מעבר חשבון: $1',
	'sudo-error-sudo-invaliduser' => 'שם משתמש בלתי־תקין',
	'sudo-error-sudo-ip' => 'לא ניתן להיכנס לכתובת IP',
	'sudo-error-sudo-nonexistent' => 'המשתמש אינו קיים',
	'sudo-error-sudo-self' => 'לא ניתן לעבור לאותו החשבון',
	'sudo-error-nosudo' => 'לא נראה שאתם במצב מעבר חשבון',
	'sudo-logpagename' => 'יומן מעבר חשבון',
	'sudo-logpagetext' => 'זהו יומן של כל השימושים במעבר חשבון',
	'sudo-logentry' => 'נכנס לחשבון $2',
	'right-sudo' => 'כניסה לחשבון של משתמש אחר',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'sudo' => 'Ke kontu druheho wužiwarja so přizjewić',
	'unsudo' => 'Wróćo k twojemu kontu',
	'sudo-desc' => 'Zmóžnja přizjewjenje wužiwarjow jako druzy wužiwarjo z pomuc přikaza "sudo"',
	'sudo-personal-unsudo' => 'Wróćo k twojemu kontu',
	'sudo-form' => 'Přizjewić so jako:',
	'sudo-user' => 'Wužiwarske mjeno:',
	'sudo-reason' => 'Přičina:',
	'sudo-submit' => 'Přizjewjenje',
	'sudo-unsudo' => 'Witaj $1, sy tuchwilu we wikiju jako $2 přizjewjeny. Klikń na "{{int:sudo-unsudo-submit}}", zo by so k swójskemu přizjewjenju wróćił.',
	'sudo-unsudo-submit' => 'Wróćić so',
	'sudo-success' => 'Witaj $1, sy nětko pola wikija $2 přizjewjeny.',
	'sudo-error' => 'Sudo-zmylk: $1',
	'sudo-error-sudo-invaliduser' => 'Njepłaćiwe wužiwarske mjeno',
	'sudo-error-sudo-ip' => 'Přizjewjenje z IP-adresu njeje móžno',
	'sudo-error-sudo-nonexistent' => 'Tón wužiwar njeeksistuje',
	'sudo-error-sudo-self' => 'Njemóžeš so samoho přez "sudo" přizjewić',
	'sudo-error-nosudo' => 'Zda so, zo njesy přez "sudo" přizjewjeny',
	'sudo-logpagename' => 'Sudo-protokol',
	'sudo-logpagetext' => 'To je protokol wšěch wužićow sudo.',
	'sudo-logentry' => 'je so pola konta $2 přizjewił',
	'right-sudo' => 'Pola konta druheho wužiwarja so přizjewić',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'sudo-personal-unsudo' => 'Vissza a saját fiókodhoz',
	'sudo-form' => 'Bejelentkezés ide:',
	'sudo-user' => 'Felhasználónév:',
	'sudo-reason' => 'Ok:',
	'sudo-submit' => 'Bejelentkezés',
	'sudo-unsudo-submit' => 'Visszatérés',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'sudo' => 'Aperir session in le conto de un altere usator',
	'unsudo' => 'Retornar al proprie conto',
	'sudo-desc' => 'Permitte a "transidentificatores" de aperir session in le conto de altere usatores',
	'sudo-personal-unsudo' => 'Retornar al proprie conto',
	'sudo-form' => 'Aperir session como:',
	'sudo-user' => 'Nomine de usator:',
	'sudo-reason' => 'Motivo:',
	'sudo-submit' => 'Aperir session',
	'sudo-unsudo' => 'Benvenite $1, tu es ora identificate in le wiki como $2. Clicca super "{{int:sudo-unsudo-submit}}" pro retornar a tu proprie conto de usator.',
	'sudo-unsudo-submit' => 'Retornar',
	'sudo-success' => 'Benvenite $1, tu es ora identificate in le wiki como $2.',
	'sudo-error' => 'Error de transidentification: $1',
	'sudo-error-sudo-invaliduser' => 'Nomine de usator invalide',
	'sudo-error-sudo-ip' => 'Non es possibile aperir session como un adresse IP',
	'sudo-error-sudo-nonexistent' => 'Iste usator non existe',
	'sudo-error-sudo-self' => 'Non es possibile transidentificar se con le proprie conto',
	'sudo-error-nosudo' => 'Tu non pare esser in un session transidentificate',
	'sudo-logpagename' => 'Registro de transidentification',
	'sudo-logpagetext' => 'Isto es un registro de tote le usos del facilitate de transidentification.',
	'sudo-logentry' => 'aperiva session in le conto de $2',
	'right-sudo' => 'Aperir session in le conto de un altere usator',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'sudo' => 'Masuk ke akun pengguna lain',
	'unsudo' => 'Kembali ke akun Anda',
	'sudo-desc' => 'Mengizinkan seorang pengguna untuk masuk sebagai pengguna lain (sudo)',
	'sudo-personal-unsudo' => 'Kembali ke akun Anda',
	'sudo-form' => 'Masuk ke:',
	'sudo-user' => 'Nama pengguna:',
	'sudo-reason' => 'Alasan:',
	'sudo-submit' => 'Masuk',
	'sudo-unsudo' => 'Selamat datang $1, Anda saat ini masuk ke wiki sebagai $2. Klik "{{int:sudo-unsudo-submit}}" untuk kembali masuk dengan akun Anda sendiri.',
	'sudo-unsudo-submit' => 'Kembali',
	'sudo-success' => 'Selamat datang $1, sekarang Anda masuk ke wiki sebagai $2.',
	'sudo-error' => 'Galat sudo: $1',
	'sudo-error-sudo-invaliduser' => 'Nama pengguna tidak sah',
	'sudo-error-sudo-ip' => 'Tidak dapat masuk dengan menggunakan alamat IP',
	'sudo-error-sudo-nonexistent' => 'Pengguna tidak ada',
	'sudo-error-sudo-self' => 'Tidak dapat sudo ke akun Anda sendiri',
	'sudo-error-nosudo' => 'Anda tampaknya tidak sedang menggunakan sudo',
	'sudo-logpagename' => 'Log sudo',
	'sudo-logpagetext' => 'Berikut adalah log semua penggunaan sudo.',
	'sudo-logentry' => 'masuk ke dalam akun $2',
	'right-sudo' => 'Masuk ke akun pengguna lain',
);

/** Japanese (日本語)
 * @author Ohgi
 * @author Schu
 */
$messages['ja'] = array(
	'sudo' => '他の利用者のアカウントにログイン',
	'unsudo' => '自分のアカウントに戻る',
	'sudo-desc' => '他の利用者としてログインするための sudoers を可能にします。',
	'sudo-personal-unsudo' => '自分のアカウントに戻る',
	'sudo-form' => 'ログイン :',
	'sudo-user' => '利用者名 :',
	'sudo-reason' => '理由:',
	'sudo-submit' => 'ログイン',
	'sudo-unsudo' => 'ようこそ $1 、あなたは現在 $2 としてウィキにログインしています。自分のログインに戻るには "{{int:sudo-unsudo-submit}}" をクリックしてください。',
	'sudo-unsudo-submit' => '戻る',
	'sudo-success' => 'ようこそ $1 、あなたは現在 $2 としてウィキにログインしています。',
	'sudo-error' => 'Sudo エラー: $1',
	'sudo-error-sudo-invaliduser' => '無効な利用者名',
	'sudo-error-sudo-ip' => 'IPアドレスにログインできません',
	'sudo-error-sudo-nonexistent' => 'その利用者は存在しません',
	'sudo-error-sudo-self' => '自分自身への sudo をすることはできません',
	'sudo-error-nosudo' => 'あなたは、sudo のログインの内部に表示されません',
	'sudo-logpagename' => 'sudo ログ',
	'sudo-logpagetext' => 'これは sudo 利用のすべてのログです。',
	'sudo-logentry' => '$2 のアカウントにログインしています',
	'right-sudo' => '他の利用者のアカウントにログイン',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'sudo' => 'Onger enem fremde Name enlogge (Sudo)',
	'unsudo' => 'Jangk retuur op Dinge eije Name als Metmaacher',
	'sudo-desc' => 'Määt et för berääschteschte Metmaacher müjjelesch, sesch onger främde Name enzelogge.',
	'sudo-personal-unsudo' => 'Jangk retuur op Dinge eije Name als Metmaacher',
	'sudo-form' => 'Enlogge als:',
	'sudo-user' => 'Metmaachername:',
	'sudo-reason' => 'Aanlass:',
	'sudo-submit' => 'Lohß jonn!',
	'sudo-unsudo' => 'Welkumme $1, 
De bes heh em Wiki em Momang als {{GENDER:$2|dä|dat|Metmaacher|de|et}} $2 enjelogg.
Donn op „{{int:sudo-unsudo-submit}}“ klecke, öm op Dinge eije Name als Metmaacher retuur ze jonn.',
	'sudo-unsudo-submit' => 'Retuur',
	'sudo-success' => 'Welkumme $1,
jäz bes De heh em Wiki als {{GENDER:$2|dä|dat|Metmaacher|de|et}} $2 enjelogg.',
	'sudo-error' => 'Fähler: Dat Enlogge met enem fremde Name hät nit jeflupp.
$1',
	'sudo-error-sudo-invaliduser' => 'Dat es ene onjöltije Metmaachername',
	'sudo-error-sudo-ip' => 'Mer kann nit als Namelose met ene <i lang="en">IP</i>-Adräß enlogge',
	'sudo-error-sudo-nonexistent' => 'Esu ene Metmaacher ham_mer nit.',
	'sudo-error-sudo-self' => 'Do kanns Desch nit mim eije Name enlogge wi wann et ene främde Name wöhr.',
	'sudo-error-nosudo' => 'Do schingks jaa nit met enem fremde Name enjelogg ze sin.',
	'sudo-logpagename' => 'Logbooch vum Enlogge onger fremde Name (Sudo)',
	'sudo-logpagetext' => 'En heh däm Logbooch fengk mer jeedes Enlogge onger enem fremde Name (Sudo)',
	'sudo-logentry' => 'hät sesch als {{GENDER:$2|dä|dat|Metmaacher|de|et}} $2 enjelogg.',
	'right-sudo' => 'Onger enem fremde Name enlogge (Sudo)',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'sudo-user' => 'Navê bikarhêner:',
	'sudo-reason' => 'Sedem:',
	'sudo-submit' => 'Têketin',
	'sudo-error-sudo-nonexistent' => 'Ev bikarhêner tune ye',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'sudo' => 'Mat engem anere Benotzerkont aloggen',
	'unsudo' => 'Zréck op Äre Benotzerkont',
	'sudo-personal-unsudo' => 'Zréck op Äre Benotzerkont',
	'sudo-form' => 'Aloggen als:',
	'sudo-user' => 'Benotzernumm:',
	'sudo-reason' => 'Grond:',
	'sudo-submit' => 'Umellen',
	'sudo-unsudo-submit' => 'Zréck',
	'sudo-error' => 'Sudo-Feeler: $1',
	'sudo-error-sudo-invaliduser' => 'Ongëltege Benotzernumm',
	'sudo-error-sudo-nonexistent' => 'Dee Benotzer gëtt et net.',
	'sudo-logpagename' => 'Sudo-Logbuch',
	'right-sudo' => 'Alogge mat engem anere sengem Benotzerkont',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'sudo' => 'Најава со туѓа сметка',
	'unsudo' => 'Назад на својата сметка',
	'sudo-desc' => 'Им овозможува на корисниците на Sudo да се најавуваат со туѓи сметки',
	'sudo-personal-unsudo' => 'Назад на својата сметка',
	'sudo-form' => 'Најава на:',
	'sudo-user' => 'Корисничко име:',
	'sudo-reason' => 'Причина:',
	'sudo-submit' => 'Најава',
	'sudo-unsudo' => 'Добредојдовте, $1. Моментално сте најавени на викито како $2. За да се вратите на вашата редовна сметка, кликнете на „{{int:sudo-unsudo-submit}}“.',
	'sudo-unsudo-submit' => 'Назад',
	'sudo-success' => 'Добредојдовте, $1. Сега сте најавени на викито како $2.',
	'sudo-error' => 'Грешка во Sudo: $1',
	'sudo-error-sudo-invaliduser' => 'Неважечко корисничко име',
	'sudo-error-sudo-ip' => 'Не можете да се најавите на IP-адреса',
	'sudo-error-sudo-nonexistent' => 'Нема таков корисник.',
	'sudo-error-sudo-self' => 'Не можете да се најавите на својата сметка како на туѓа',
	'sudo-error-nosudo' => 'Се чини дека не сте во Sudo-сметка',
	'sudo-logpagename' => 'Дневник на Sudo',
	'sudo-logpagetext' => 'Ова е дневник на сите употреби на Sudo',
	'sudo-logentry' => 'најава на сметката на $2',
	'right-sudo' => 'Најавување на туѓа сметка',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'sudo' => 'Log masuk ke dalam akaun pengguna lain',
	'unsudo' => 'Kembali ke akaun anda',
	'sudo-desc' => 'Membolehkan ahli sudo untuk log masuk sebagai pengguna lain',
	'sudo-personal-unsudo' => 'Kembali ke akaun anda',
	'sudo-form' => 'Log masuk ke dalam:',
	'sudo-user' => 'Nama pengguna:',
	'sudo-reason' => 'Sebab:',
	'sudo-submit' => 'Log masuk',
	'sudo-unsudo' => 'Selama datang $1, anda sedang log masuk ke dalam wiki sebagai $2. Klik "{{int:sudo-unsudo-submit}}" untuk kembali ke log masuk anda sendiri.',
	'sudo-unsudo-submit' => 'Kembali',
	'sudo-success' => 'Selamat datang $1; kini, anda log masuk ke dalam wiki sebagai $2.',
	'sudo-error' => 'Ralat sudo: $1',
	'sudo-error-sudo-invaliduser' => 'Nama pengguna tidak sah',
	'sudo-error-sudo-ip' => 'Tidak dapat log masuk ke dalam alamat IP',
	'sudo-error-sudo-nonexistent' => 'Pengguna itu tidak wujud',
	'sudo-error-sudo-self' => 'Tidak boleh bersudo ke dalam diri sendiri',
	'sudo-error-nosudo' => 'Nampaknya anda tidak log masuk secara sudo',
	'sudo-logpagename' => 'Log sudo',
	'sudo-logpagetext' => 'Ini ialah log semua pengguna sudo.',
	'sudo-logentry' => 'log masuk ke dalam akaun $2',
	'right-sudo' => 'Log masuk ke dalam akaun pengguna lain',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'sudo' => 'Logg inn på en annen brukers konto',
	'unsudo' => 'Gå tilbake til din konto',
	'sudo-desc' => 'Tillat sudoere å logge inn som andre brukere',
	'sudo-personal-unsudo' => 'Gå tilbake til din konto',
	'sudo-form' => 'Logg inn på:',
	'sudo-user' => 'Brukernavn:',
	'sudo-reason' => 'Årsak:',
	'sudo-submit' => 'Logg inn',
	'sudo-unsudo' => 'Velkommen $1, du er nå logget inn på wikien som $2. Klikk på «{{int:sudo-unsudo-submit}}» for å gå tilbake til din egen pålogging.',
	'sudo-unsudo-submit' => 'Tilbake',
	'sudo-success' => 'Velkommen $1, du er nå logget inn på wikien som $2.',
	'sudo-error' => 'Sudo-feil: $1',
	'sudo-error-sudo-invaliduser' => 'Ugyldig brukernavn',
	'sudo-error-sudo-ip' => 'Kan ikke logge inn på en IP-adresse',
	'sudo-error-sudo-nonexistent' => 'Den brukeren finnes ikke',
	'sudo-error-sudo-self' => 'Kan ikke sudoe inn i deg selv',
	'sudo-error-nosudo' => 'Du ser ikke ut til å være inne i en sudo-pålogging',
	'sudo-logpagename' => 'Sudo-logg',
	'sudo-logpagetext' => 'Dette er en logg over all bruk av sudo.',
	'sudo-logentry' => 'logget på $2 sin konto',
	'right-sudo' => 'Logget inn på en annen brukers konto',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'sudo-user' => 'प्रयोगकर्ता नाम:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'sudo' => 'Aanmelden als een andere gebruiker',
	'unsudo' => 'Terugkeren naar uw eigen gebruiker',
	'sudo-desc' => 'Staat gebruikers met het recht "sudo" toe als andere gebruikers aan te melden',
	'sudo-personal-unsudo' => 'Terugkeren naar uw eigen gebruiker',
	'sudo-form' => 'Aanmelden als:',
	'sudo-user' => 'Gebruikersnaam:',
	'sudo-reason' => 'Reden:',
	'sudo-submit' => 'Aanmelden',
	'sudo-unsudo' => 'Welkom, $1. U bent nu aangemeld bij de wiki als $2. Klik op "{{int:sudo-unsudo-submit}}" om terug te keren naar uw eigen gebruiker.',
	'sudo-unsudo-submit' => 'Terug',
	'sudo-success' => 'Welkom $1. U bent u bij de wiki aangemeld als $2.',
	'sudo-error' => 'Sudo-fout: $1',
	'sudo-error-sudo-invaliduser' => 'Ongeldige gebruikersnaam',
	'sudo-error-sudo-ip' => 'Het is niet mogelijk aan te melden als een anonieme gebruiker',
	'sudo-error-sudo-nonexistent' => 'Die gebruiker bestaat niet',
	'sudo-error-sudo-self' => 'Het is niet mogelijk een sudo naar uzelf uit te voeren',
	'sudo-error-nosudo' => 'U bevindt zich niet in een sudosessie',
	'sudo-logpagename' => 'Sudologboek',
	'sudo-logpagetext' => 'Dit logboek bevat alle keren dat sudo gebruikt is.',
	'sudo-logentry' => 'heeft aangemeld als $2',
	'right-sudo' => 'Aanmelden als een andere gebruiker',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'sudo' => 'Zaloguj się jako inny użytkownik',
	'unsudo' => 'Powrócić do własnego konta',
	'sudo-desc' => 'Pozwala wybranym użytkownikom logować się na konta innych',
	'sudo-personal-unsudo' => 'Powrócić do własnego konta',
	'sudo-form' => 'Zaloguj się jako',
	'sudo-user' => 'Nazwa użytkownika',
	'sudo-reason' => 'Powód',
	'sudo-submit' => 'Zaloguj',
	'sudo-unsudo' => 'Witaj $1. Jesteś obecnie zalogowany do wiki jako $2. Kliknij „{{int:sudo-unsudo-submit}}”, a wrócisz do swojego własnego konta.',
	'sudo-unsudo-submit' => 'Wróć',
	'sudo-success' => 'Witaj $1. Jesteś teraz zalogowany do wiki jako $2.',
	'sudo-error' => 'Błąd zmiany zalogowania $1',
	'sudo-error-sudo-invaliduser' => 'Nieprawidłowa nazwa użytkownika',
	'sudo-error-sudo-ip' => 'Nie można zalogować się jako adres IP',
	'sudo-error-sudo-nonexistent' => 'Taki użytkownik nie istnieje',
	'sudo-error-sudo-self' => 'Nie można przelogować się na własne konto',
	'sudo-error-nosudo' => 'Nie wygląda na to abyś był zalogowany na inne konto',
	'sudo-logpagename' => 'Rejestr zmian zalogowania się',
	'sudo-logpagetext' => 'Jest to rejestr wszystkich zdarzeń zmian zalogowania się.',
	'sudo-logentry' => 'zalogowany jako $2',
	'right-sudo' => 'Zaloguj się jako inny użytkownik',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'sudo' => "Ch'a intra ant ël sistema ant ël cont ëd n'àutr utent",
	'unsudo' => 'Artorna a tò cont',
	'sudo-desc' => "A përmët a j'utent \"sudo\" d'intré ant ël sistema coma a fusso d'àutri utent",
	'sudo-personal-unsudo' => 'Artorna a tò cont',
	'sudo-form' => 'Intré ant ël sistema ansima a:',
	'sudo-user' => 'Stranòm:',
	'sudo-reason' => 'Rason:',
	'sudo-submit' => 'Intré ant ël sistema',
	'sudo-unsudo' => 'Bin ëvnù $1, al moment a l\'é intrà ant la wiki com $2. Ch\'a sgnaca su "{{int:sudo-unsudo-submit}}" për artorné a soa conession.',
	'sudo-unsudo-submit' => 'Artorna',
	'sudo-success' => 'Bin ëvnù $1, adess it ses intrà ant la wiki com $2.',
	'sudo-error' => 'Eror sudo: $1',
	'sudo-error-sudo-invaliduser' => 'Stranòm pa bon',
	'sudo-error-sudo-ip' => "As peul pa intresse an n'adrëssa IP",
	'sudo-error-sudo-nonexistent' => 'Col utent a esist pa',
	'sudo-error-sudo-self' => 'As peul pa intré con sudo ansima a sò cont',
	'sudo-error-nosudo' => 'Chiel a smija pa esse andrinta a na conession sudo',
	'sudo-logpagename' => 'Registr ëd sudo',
	'sudo-logpagetext' => "Cost-sì a l'é un registr ëd tùit j'utent ëd sudo.",
	'sudo-logentry' => 'intrà ant el sistema ant ël cont ëd $2',
	'right-sudo' => "Intré ant ël sistema con ël cont ëd n'àutr utent",
);

/** Portuguese (Português)
 * @author Waldir
 */
$messages['pt'] = array(
	'sudo' => 'Iniciar sessão na conta de outro utilizador',
	'unsudo' => 'Retornar para a sua conta',
	'sudo-desc' => 'Permite iniciar sessão como outros utilizadores',
	'sudo-personal-unsudo' => 'Retornar para a sua conta',
	'sudo-form' => 'Iniciar sessão em:',
	'sudo-user' => 'Nome de utilizador:',
	'sudo-reason' => 'Motivo:',
	'sudo-submit' => 'Iniciar sessão',
	'sudo-unsudo' => 'Bem-vindo, $1, você atualmete tem sessão iniciada na wiki como $2. Clique em "{{int:sudo-unsudo-submit}}" para retornar à sua própria conta.',
	'sudo-unsudo-submit' => 'Voltar',
	'sudo-success' => 'Bem-vindo, $1, você está agora autenticado na wiki como $2.',
	'sudo-error' => 'Erro do Sudo: $1',
	'sudo-error-sudo-invaliduser' => 'Nome de utilizador inválido',
	'sudo-error-sudo-ip' => 'Não é possível iniciar sessão como um endereço IP',
	'sudo-error-sudo-nonexistent' => 'Esse utilizador não existe',
	'sudo-error-sudo-self' => 'Não é possível fazer sudo em si mesmo',
	'sudo-error-nosudo' => 'Você não parece estar dentro de uma conta sudo',
	'sudo-logpagename' => 'Registo do Sudo',
	'sudo-logpagetext' => 'Este é um registo de todas as utilizações do sudo.',
	'sudo-logentry' => 'Autenticado na conta de $2',
	'right-sudo' => 'Iniciar sessão na conta de outro utilizador',
);

/** Russian (Русский)
 * @author DCamer
 */
$messages['ru'] = array(
	'sudo' => 'Войти в учетную запись другого пользователя',
	'unsudo' => 'Вернуться к вашей учетной записи',
	'sudo-desc' => 'Позволяет судоерам войти в качестве другого пользователей',
	'sudo-personal-unsudo' => 'Вернуться к вашей учетной записи',
	'sudo-form' => 'Войти:',
	'sudo-user' => 'Имя участника:',
	'sudo-reason' => 'Причина:',
	'sudo-submit' => 'Представиться',
	'sudo-unsudo' => 'Приветствуем $1, вы вошли как $2. Нажмите "{{int:sudo-unsudo-submit}}" чтобы вернуться в свою учётную запись.',
	'sudo-unsudo-submit' => 'Вернуться',
	'sudo-success' => 'Приветствуем $1, вы вошли как $2.',
	'sudo-error' => 'Судо-ошибка: $1',
	'sudo-error-sudo-invaliduser' => 'Неправильное имя участника',
	'sudo-error-sudo-ip' => 'Не удалось войти в IP-адрес',
	'sudo-error-sudo-nonexistent' => 'Целевой участник не существует.',
	'sudo-error-sudo-self' => 'Нельзя войти в себя',
	'sudo-error-nosudo' => 'Вы не представились в Sudo',
	'sudo-logpagename' => 'Журнал Sudo',
	'sudo-logpagetext' => 'Это журнал всех использований Sudo.',
	'sudo-logentry' => 'вошел в учетную запись $2',
	'right-sudo' => 'Войти в учетную запись другого пользователя',
);

/** Swedish (Svenska)
 * @author Liftarn
 */
$messages['sv'] = array(
	'sudo-user' => 'Användarnamn:',
	'sudo-reason' => 'Anledning:',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'sudo-user' => 'వాడుకరి పేరు:',
	'sudo-reason' => 'కారణం:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'sudo-user' => "Naran uza-na'in:",
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'sudo' => 'Lumagdang papasok sa iba pang akawnt ng tagagamit',
	'unsudo' => 'Bumalik sa akawnt mo',
	'sudo-desc' => 'Nagpapahintulot sa mga nagsu-sudo na lumagda bilang ibang mga tagagamit',
	'sudo-personal-unsudo' => 'Bumalik sa akawnt mo',
	'sudo-form' => 'Lumagda sa:',
	'sudo-user' => 'Pangalan ng tagagamit:',
	'sudo-reason' => 'Dahilan:',
	'sudo-submit' => 'Lumagda',
	'sudo-unsudo' => 'Maligayang pagdating $1, pangkasalukuyang nakalagda ka sa wiki bilang si $2. Pindutin ang  "{{int:sudo-unsudo-submit}}" bumalik sa pansarili mong paglagda.',
	'sudo-unsudo-submit' => 'Bumalik',
	'sudo-success' => 'Maligayang pagdating $1, nakalagda ka na ngayon sa wiki bilang si $2.',
	'sudo-error' => 'Kamalian ng sudo: $1',
	'sudo-error-sudo-invaliduser' => 'Hindi katanggap-tanggap na pangalan ng tagagamit',
	'sudo-error-sudo-ip' => 'Hindi makalagda papunta sa isang tirahan ng IP',
	'sudo-error-sudo-nonexistent' => 'Hindi umiiral ang tagagamit na iyan',
	'sudo-error-sudo-self' => 'Hindi maaaring magsudo na papasok sa sarili mo',
	'sudo-error-nosudo' => 'Tila wala ka sa loob ng isang paglagda ng sudo',
	'sudo-logpagename' => 'Talaan ng sudo',
	'sudo-logpagetext' => 'Isa itong talaan ng lahat ng mga pinaggagamitan ng sudo.',
	'sudo-logentry' => 'nakalagda sa akawnt ni $2',
	'right-sudo' => 'Lumagdang papasok sa iba pang akawnt ng tagagamit',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'sudo-reason' => 'Причина:',
	'sudo-submit' => 'Увійти',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'sudo-user' => 'באַניצער נאָמען:',
	'sudo-submit' => 'אַרײַנלאגירן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'sudo' => '登录到另一个用户的帐户',
	'unsudo' => '返回到您的帐户',
	'sudo-desc' => '允许sudo者以其他用户身份登录',
	'sudo-personal-unsudo' => '返回到您的帐户',
	'sudo-form' => '登录到：',
	'sudo-user' => '用户名：',
	'sudo-reason' => '原因：',
	'sudo-submit' => '登入',
	'sudo-unsudo' => '欢迎$1，您当前以$2的身份登录到wiki。单击“{{int:sudo-unsudo-submit}}”以返回到您自己的登录。',
	'sudo-unsudo-submit' => '返回',
	'sudo-success' => '欢迎$1，您当前已经以$2的身份登录到wiki。',
	'sudo-error' => 'Sudo错误：$1',
	'sudo-error-sudo-invaliduser' => '无效用户名',
	'sudo-error-sudo-ip' => '不能登录到IP地址',
	'sudo-error-sudo-nonexistent' => '该用户不存在',
	'sudo-error-sudo-self' => '无法sudo到您自己',
	'sudo-error-nosudo' => '你似乎不在sudo登录中',
	'sudo-logpagename' => 'Sudo日志',
	'sudo-logpagetext' => '这是所有使用sudo的日志。',
	'sudo-logentry' => '登录到$2的帐户',
	'right-sudo' => '登录到另一个用户的帐户',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'sudo' => '登錄到另一個用戶的帳戶',
	'unsudo' => '返回到您的帳戶',
	'sudo-desc' => '允許sudo者以其他用戶身份登錄',
	'sudo-personal-unsudo' => '返回到您的帳戶',
	'sudo-form' => '登錄到：',
	'sudo-user' => '使用者名稱：',
	'sudo-reason' => '原因：',
	'sudo-submit' => '登入',
	'sudo-unsudo' => '歡迎$1，您當前以$2的身份登錄到wiki。單擊“{{int:sudo-unsudo-submit}}”以返回到您自己的登錄。',
	'sudo-unsudo-submit' => '返回',
	'sudo-success' => '歡迎$1，您當前已經以$2的身份登錄到wiki。',
	'sudo-error' => 'Sudo錯誤：$1',
	'sudo-error-sudo-invaliduser' => '無效用戶名',
	'sudo-error-sudo-ip' => '不能登錄到IP地址',
	'sudo-error-sudo-nonexistent' => '該用戶不存在',
	'sudo-error-sudo-self' => '無法sudo到您自己',
	'sudo-error-nosudo' => '你似乎不在sudo登錄中',
	'sudo-logpagename' => 'Sudo日誌',
	'sudo-logpagetext' => '這是所有使用sudo的日誌。',
	'sudo-logentry' => '登錄到$2的帳戶',
	'right-sudo' => '登錄到另一個用戶的帳戶',
);

