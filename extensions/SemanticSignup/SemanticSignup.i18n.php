<?php
/**
 * /**
 * Internationalization file for the SemanticSignup extension.
 * Created on 7 Jan 2008
 *
 * @file SemanticSignup.i18n.php
 * @ingroup SemanticSignup
 *
 * @author Serhii Kutnii
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$messages = array();

$messages['en'] = array(
	'semanticsignup' => 'Semantic Signup',
	'ses-desc' => 'A MediaWiki extension built on top of Semantic Forms allowing to populate a user page with semantic data at signup time',
	'ses-nousername' => 'Username has not been specified.',
	'ses-nopwdmatch' => 'Password and password confirmation do not match.',
	'ses-norealname' => 'Real name is required but has not been specified.',
	'ses-userexists' => 'User already exists.',
	'ses-emailfailed' => 'Confirmation e-mail sending failed.',
	'ses-createforbidden' => 'Current user is not allowed to create accounts.',
	'ses-throttlehit' => 'The maximum number of new user accounts per day has been exceeded for this IP address.',
	'ses-userexists' => 'User already exists.'
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'semanticsignup' => 'Rexistru semánticu',
	'ses-desc' => "Una estensión MediaWiki construída sobro Formularios Semánticos que permite poblar una páxina d'usuariu con datos semánticos nel momentu de rexistrase",
	'ses-nousername' => "Nun se conseñó un nome d'usuariu.",
	'ses-nopwdmatch' => 'La conseña y la confirmación de la mesma nun casen.',
	'ses-norealname' => " Ye necesariu'l nome real, pero nun se conseñó.",
	'ses-userexists' => "L'usuariu yá esiste.",
	'ses-emailfailed' => "Falló l'unviu del corréu electrónicu de confirmación.",
	'ses-createforbidden' => "L'usuariu actual nun tien permisu pa crear cuentes.",
	'ses-throttlehit' => "Esta direición IP pasó del númberu máximu de cuentes d'usuariu nueves al día.",
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Renessaince
 */
$messages['be-tarask'] = array(
	'ses-desc' => 'Пашырэньне MediaWiki, пабудаванае паверх Сэмантычных формаў, якое дазваляе зьмяшчаць на старонцы ўдзельніка падчас стварэньня рахунку сэмантычныя зьвесткі',
	'ses-nousername' => 'Імя ўдзельніка не пазначанае.',
	'ses-nopwdmatch' => 'Пароль і яго пацьверджаньне не супадаюць.',
	'ses-norealname' => 'Не пазначаны абавязковы атрыбут — сапраўднае імя.',
	'ses-userexists' => 'Удзельнік ужо існуе.',
	'ses-emailfailed' => 'Не атрымалася даслаць электронны ліст з пацьверджаньнем.',
	'ses-createforbidden' => 'Гэтаму ўдзельніку забаронена ствараць рахункі.',
	'ses-throttlehit' => 'Для гэтага IP-адрасу перавышаная дзённая колькасьць новых рахункаў.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'ses-userexists' => "An implijer-mañ zo anezhañ c'hoazh.",
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'semanticsignup' => 'Semantische Anmeldung',
	'ses-desc' => 'Ermöglicht das Ergänzen der Benutzerseite mit semantischen Benutzerdaten, die dieser während der Anmeldung angibt',
	'ses-nousername' => 'Der Benutzername wurde nicht angegeben.',
	'ses-nopwdmatch' => 'Das Passwort und die Passwortbestätigung stimmen nicht überein.',
	'ses-norealname' => 'Der bürgerliche Name ist erforderlich, wurde aber nicht angegeben.',
	'ses-userexists' => 'Der Benutzer ist bereits vorhanden.',
	'ses-emailfailed' => 'Der Versand der Bestätigungs-E-Mail ist gescheitert.',
	'ses-createforbidden' => 'Der aktuelle Benutzer ist nicht berechtigt, Konten zu erstellen.',
	'ses-throttlehit' => 'Die Anzahl neuer Benutzerkonten je Tag wurde für diese IP-Adresse überschritten.',
);

/** French (Français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'semanticsignup' => 'Inscription sémantique',
	'ses-desc' => "Une extension de MediaWiki construite par-dessus les formulaires sémantiques permettant de peupler une page utilisateur avec des données sémantiques au moment de l'inscription",
	'ses-nousername' => "Le nom d'utilisateur n'a pas été spécifié.",
	'ses-nopwdmatch' => 'Le mot de passe et sa confirmation ne concordent pas.',
	'ses-norealname' => "Le vrai nom est obligatoire mais n'a pas été spécifié.",
	'ses-userexists' => "L'utilisateur existe déjà.",
	'ses-emailfailed' => "L'envoi du courriel de confirmation a échoué.",
	'ses-createforbidden' => "L'utilisateur courant n'est pas autorisé à créer des comptes.",
	'ses-throttlehit' => 'Le nombre de nouveaux comptes utilisateur par jour a été dépassé pour cette adresse IP.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'semanticsignup' => 'Enscripcion sèmantica',
	'ses-userexists' => 'L’utilisator ègziste ja.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'semanticsignup' => 'Rexistro semántico',
	'ses-desc' => 'Unha extensión MediaWiki construída a partir de formularios semánticos para encher unha páxina de usuario con datos semánticos á hora do rexistro',
	'ses-nousername' => 'Non especificou o nome de usuario.',
	'ses-nopwdmatch' => 'O contrasinal e a confirmación do contrasinal non coinciden.',
	'ses-norealname' => 'O nome real é necesario, pero non o especificou.',
	'ses-userexists' => 'O usuario xa existe.',
	'ses-emailfailed' => 'Erro durante o envío do correo electrónico de confirmación.',
	'ses-createforbidden' => 'O usuario actual non ten permiso para crear contas.',
	'ses-throttlehit' => 'Este enderezo IP superou o número máximo de novas contas de usuario ao día.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'semanticsignup' => 'Semantiske přizjewjenje',
	'ses-desc' => 'Rozšěrjenje MediaWiki, kotrež zmóžnja, wužiwarsku stronu ze semantiskimi datami za přizjewjenje wuhotować',
	'ses-nousername' => 'Wužiwarske mjeno njeje so podało.',
	'ses-nopwdmatch' => 'Hesło a jeho wobkrućenje so njekryjetej.',
	'ses-norealname' => 'Woprawdźite mjeno je trěbne, ale njeje so podało.',
	'ses-userexists' => 'Wužiwar hižo eksistuje.',
	'ses-emailfailed' => 'Słanje wobkrućenskeje e-mejle je so njeporadźiło.',
	'ses-createforbidden' => 'Aktualny wužiwar njesmě konta załožić',
	'ses-throttlehit' => 'Maksimalna ličba nowych wužiwarskich kontow na dźeń je za tutu IP-adresu překročena.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'semanticsignup' => 'Inscription semantic',
	'ses-desc' => 'Un extension de MediaWiki, construite super Formularios Semantic, que permitte plenar un pagina de usator con datos semantic al momento de creation del conto',
	'ses-nousername' => 'Le nomine de usator non ha essite specificate.',
	'ses-nopwdmatch' => 'Contrasigno e confirmation non corresponde.',
	'ses-norealname' => 'Le nomine real es obligatori ma non ha essite specificate.',
	'ses-userexists' => 'Le usator existe jam.',
	'ses-emailfailed' => 'Le invio del e-mail de confirmation ha fallite.',
	'ses-createforbidden' => 'Le usator actual non ha le permission de crear contos.',
	'ses-throttlehit' => 'Le numero maxime de nove contos de usator per die ha essite excedite pro iste adresse IP.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'ses-nousername' => 'De Benotzernumm gouf net uginn.',
	'ses-norealname' => 'De richtegen Numm ass verlaangt mä e gouf net uginn.',
	'ses-userexists' => 'De Benotzer gëtt et schonn.',
	'ses-createforbidden' => 'Den aktuelle Benotzer däerf keng Benotzerkonten uleeën.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'semanticsignup' => 'Семантичка регистрација',
	'ses-desc' => 'Додаток за МедијаВики врз Семантичките обрасци кој овозможува пополнување на корисничка страница со семантички податоци во текот на регистрацијата',
	'ses-nousername' => 'Нема наведено корисничко име.',
	'ses-nopwdmatch' => 'Двете лозинки не се совпаѓаат.',
	'ses-norealname' => 'Нема наведено вистинско име, но ова е задолжително.',
	'ses-userexists' => 'Корисникот веќе постои.',
	'ses-emailfailed' => 'Не успеав да ја испратам потврдната порака по е-пошта.',
	'ses-createforbidden' => 'На тековниот корисник не му е дозволено да создава сметки.',
	'ses-throttlehit' => 'Надминат е максималниот дозволен број на новосоздадени кориснички сметки од оваа IP-адреса.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 */
$messages['nb'] = array(
	'semanticsignup' => 'Semantisk brukerkontoinformasjon',
	'ses-desc' => 'En MediaWiki-utvidelse bygd på Semantic Forms som tillater å legge inn semantiske data på en brukerside ved opprettelse av en bruker',
	'ses-nousername' => 'Brukernavn er ikke angitt.',
	'ses-nopwdmatch' => 'Passord og passord-bekreftelse stemmer ikke overens.',
	'ses-norealname' => 'Det kreves at virkelig navn oppgis.',
	'ses-userexists' => 'Bruker finnes allerede.',
	'ses-emailfailed' => 'Sendingen av bekreftende e-post feilet.',
	'ses-createforbidden' => 'Aktuell bruker tillates ikke å opprette brukerkontoer.',
	'ses-throttlehit' => 'Maksimalt antall nye brukere tillatt opprettet per døgn er overskredet for denne IP-adressen.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'semanticsignup' => 'Semantisch inschrijven',
	'ses-desc' => 'Uitbreiding bovenop Semantic Forms om een gebruikerspagina aan te maken met semantische gegevens tijdens de registratie',
	'ses-nousername' => 'De gebruikersnaam is niet opgegeven.',
	'ses-nopwdmatch' => 'Het wachtwoord en de bevestiging komen niet overeen.',
	'ses-norealname' => 'Een echte naam is vereist maar is niet opgegeven.',
	'ses-userexists' => 'De gebruiker bestaat al.',
	'ses-emailfailed' => 'Het verzenden van de bevestigingse-mail is mislukt.',
	'ses-createforbidden' => 'De huidige gebruiker mag geen nieuwe gebruikers aanmaken.',
	'ses-throttlehit' => 'Het maximale aantal aan te maken gebruikers per dag is bereikt voor dit IP-adres.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'semanticsignup' => 'Anscrission semàntica',
	'ses-desc' => "N'estension MediaWiki costruìa ansima ai formolari semàntich ch'a përmët ëd popolé na pàgina utent con dij dat semàntich al moment dl'anscrission",
	'ses-nousername' => "Lë stranòm a l'é nen ëstàit spessificà.",
	'ses-nopwdmatch' => 'La ciav e la ciav confirmà as corëspondo nen.',
	'ses-norealname' => "Ël nòm ver a l'é obligatòri ma a l'é pa stàit spessificà.",
	'ses-userexists' => "L'utent a esist già.",
	'ses-emailfailed' => "La spedission dël mëssagi ëd confirma a l'é falìa.",
	'ses-createforbidden' => "L'utent corent a peul pa creé ëd cont.",
	'ses-throttlehit' => "Ël nùmer màssim ëd cont utent neuv për di a l'é stàit superà për st'adrëssa IP.",
);

