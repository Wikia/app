<?php
/**
 * Internationalization file for AutoCreateWiki extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	"autocreatewiki" => "Create a new Wiki",
	"createwikipagetitle" => "Create a new Wiki",
	"createwiki"=> "Create a new Wiki",
	"autocreatewiki-chooseone" => "Choose one",
	"autocreatewiki-required" => "$1 = required",
	"autocreatewiki-web-address" => "Web Address:",
	"autocreatewiki-category-select" => "Select one",
	"autocreatewiki-language-top" => "Top $1 languages",
	"autocreatewiki-language-all" => "All languages",
	"autocreatewiki-birthdate" => "Birth date:",
	"autocreatewiki-blurry-word" => "Blurry word:",
	"autocreatewiki-remember" => "Remember me",
	"autocreatewiki-create-account" => "Create an Account",
	"autocreatewiki-done" => "done",
	"autocreatewiki-error" => "error",
	"autocreatewiki-language-top-list" => "de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh",
	"autocreatewiki-haveaccount-question" => "Do you already have a Wikia account?",
	"autocreatewiki-success-title" => "Your wiki has been created!",
	"autocreatewiki-success-subtitle" => "You can now begin working on your wiki by visiting:",
	"autocreatewiki-success-has-been-created" => "has been created!",
	"autocreatewiki-success-get-started" => "Get Started",
// form messages
	"autocreatewiki-info-domain" => "It's best to use a word likely to be a search keyword for your topic.",
	"autocreatewiki-info-topic" => "Add a short description such as \"Star Wars\" or \"TV Shows\".",
	"autocreatewiki-info-category" => "This will help visitors find your wiki.",
	"autocreatewiki-info-language" => "This will be the default language for visitors to your wiki.",
	"autocreatewiki-info-email-address" => "Your email address is never shown to anyone on Wikia.",
	"autocreatewiki-info-realname" => "If you choose to provide it this will be used for giving you attribution for your work.",
	"autocreatewiki-info-birthdate" => "Wikia requires all users to provide their real date of birth as both a safety precaution and as a means of preserving the integrity of the site while complying with federal regulations.",
	"autocreatewiki-info-blurry-word" => "To help protect against automated account creation, please type the blurry word that you see into this field.",
	"autocreatewiki-info-terms-agree" => "By creating a wiki and a user account, you agree to the <a href=\"http://www.wikia.com/wiki/Terms_of_use\">Wikia's Terms of Use</a>",
	"autocreatewiki-info-staff-username" => "<b>Staff only:</b> The specified user will be listed as the founder.",
// errors
	"autocreatewiki-limit-day" => "Wikia has exceeded the maximum number of wiki creations today ($1).",
	"autocreatewiki-limit-creation" => "You have exceeded the the maximum number of wiki creation in 24 hours ($1).",
	"autocreatewiki-empty-field" => "Please complete this field.",
	"autocreatewiki-bad-name" => "The name cannot contain special characters (like $ or @) and must be a single lower-case word without spaces.",
	"autocreatewiki-invalid-wikiname" => "The name cannot contain special characters (like $ or @) and cannot be empty",
	"autocreatewiki-violate-policy" => "This wiki name contains a word that violates our naming policy",
	"autocreatewiki-name-taken" => "A wiki with this name already exists. You are welcome to join us at <a href=\"http://$1.wikia.com\">http://$1.wikia.com</a>",
	"autocreatewiki-name-too-short" => "This name is too short, please choose a name with at least 3 characters.",
	"autocreatewiki-name-too-long" => "This name is too long, please choose a name with maximum 50 characters.",
	"autocreatewiki-similar-wikis" => "Below are the wikis already created on this topic. We suggest editing one of them.",
	"autocreatewiki-invalid-username" => "This username is invalid.",
	"autocreatewiki-busy-username" => "This username is already taken.",
	"autocreatewiki-blocked-username" => "You cannot create account.",
	"autocreatewiki-user-notloggedin" => "Your account was created but not logged in!",
	"autocreatewiki-empty-language" => "Please, select language of Wiki.",
	"autocreatewiki-empty-category" => "Please, select one of category.",
	"autocreatewiki-empty-wikiname" => "The name of Wiki cannot be empty.",
	"autocreatewiki-empty-username" => "Username cannot be empty.",
	"autocreatewiki-empty-password" => "Password cannot be empty.",
	"autocreatewiki-empty-retype-password" => "Retype password cannot be empty.",
	"autocreatewiki-set-username" => "Set username first.",
	"autocreatewiki-invalid-category" => "Invalid value of category. Please select proper from dropdown list.",
	"autocreatewiki-invalid-language" => "Invalid value of language. Please select proper from dropdown list.",
	"autocreatewiki-invalid-retype-passwd" => "Please, retype the same password as above",
	"autocreatewiki-invalid-birthday" => "Invalid birth date",
	"autocreatewiki-limit-birthday" => "Unable to create registration. ",
// processing
	"autocreatewiki-log-title" => "Your wiki is being created",
	"autocreatewiki-step0" => "Initializing process ... ",
	"autocreatewiki-stepdefault" => "Process is running, please wait ... ",
	"autocreatewiki-errordefault" => "Process was not finished ... ",
	"autocreatewiki-step1" => "Creating images folder ... ",
	"autocreatewiki-step2" => "Creating database ... ",
	"autocreatewiki-step3" => "Setting default information in database ...",
	"autocreatewiki-step4" => "Copying default images and logo ...",
	"autocreatewiki-step5" => "Setting default variables in database ...",
	"autocreatewiki-step6" => "Setting default tables in database ...",
	"autocreatewiki-step7" => "Setting language starter ... ",
	"autocreatewiki-step8" => "Setting user groups and categories ... ",
	"autocreatewiki-step9" => "Setting variables for new Wiki ... ",
	"autocreatewiki-step10" => "Setting pages on central Wiki ... ",
	"autocreatewiki-step11" => "Sending email to user ... ",
	"autocreatewiki-redirect" => "Redirecting to new Wiki: $1 ... ",
	"autocreatewiki-congratulation" => "Congratulations!",
	"autocreatewiki-welcometalk-log" => "Welcome Message",
	"autocreatewiki-regex-error-comment" => "used in Wiki $1 (whole text: $2)",
// processing errors
	"autocreatewiki-step2-error" => "Database exists!",
	"autocreatewiki-step3-error" => "Cannot set default information in database!",
	"autocreatewiki-step6-error" => "Cannot set default tables in database!",
	"autocreatewiki-step7-error" => "Cannot copy starter database for language!",
	"requestwiki-filter-language" => "kh,kp,mu,als,an,ast,de-form,de-weig,dk,en-gb,ia,ie,ksh,mwl,pdc,pfl,simple,tokipona,tp,zh-cn,zh-hans,zh-hant,zh-hk,zh-mo,zh-my,zh-sg,zh-tw",
// task
	"autocreatewiki-protect-reason" => 'Part of the official interface',
    "autocreatewiki-welcomesubject" => "$1 has been created!",
    "autocreatewiki-welcomebody" => "Hello, $2,

The Wikia you requested is now available at <$1> We hope to see you editing there soon!

We've added some Information and Tips on your User Talk Page (<$5> to help you get started.

If you have any problems, you can ask for community help on the wiki at <http://www.wikia.com/wiki/Forum:Help_desk>, or via email to community@wikia.com. You can also visit our live #wikia IRC chat channel <http://irc.wikia.com>.

I can be contacted directly by email or on my talk page, if you have any questions or concerns.

Good luck with the project!

$3

Wikia Community Team

<http://www.wikia.com/wiki/User:$4>",
    "autocreatewiki-welcometalk" => "== Welcome! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hi $1 -- we're excited to have '''$4''' as part of the Wikia community!

Now you've got a whole website to fill up with information, pictures and videos about your favorite topic. But right now, it's just blank pages staring at you... Scary, right? Here are some ways to get started.

* '''Introduce your topic''' on the front page. This is your opportunity to explain to your readers what your topic is all about. Write as much as you want! Your description can link off to all the important pages on your site.

* '''Start some new pages''' -- just a sentence or two is fine to get started. Don't let the blank page stare you down! A wiki is all about adding and changing things as you go along. You can also add pictures and videos, to fill out the page and make it more interesting.

And then just keep going! People like visiting wikis when there's lots of stuff to read and look at, so keep adding stuff, and you'll attract readers and editors. There's a lot to do, but don't worry -- today's your first day, and you've got plenty of time. Every wiki starts the same way -- a little bit at a time, starting with the first few pages, until it grows into a huge, busy site.

If you've got questions, you can e-mail us through our [[Special:Contact|contact form]]. Have fun!

-- [[User:$2|$3]] <staff /></div>",
// new wikis - special page
	"newwikis" => "New wikis",
	"newwikisstart" => "Display Wikis starting at:",
	"autocreatewiki-reminder-subject" => "{{SITENAME}}",
	"autocreatewiki-reminder-body" => "
Dear $1:

Congratulations on starting your new wiki, {{SITENAME}}! You can come back and add more to your wiki by visiting $2.

This is a brand-new project, so please write to us if you have any questions!


-- Wikia Community Team
	",
	"autocreatewiki-reminder-body-HTML" => "
Dear $1:

Congratulations on starting your new wiki, {{SITENAME}}! You can come back and add more to your wiki by visiting $2.

This is a brand-new project, so please write to us if you have any questions!


-- Wikia Community Team
	"
);


$messages['bg'] = array(
	'autocreatewiki' => 'Създаване на ново уики',
	'createwikipagetitle' => 'Заявка за ново уики',
	'createwiki' => 'Създаване на уики',
	'autocreatewiki-birthdate' => 'Дата на раждане:',
	'autocreatewiki-done' => 'готово',
	'autocreatewiki-error' => 'грешка',
	'autocreatewiki-info-category' => 'Това ще помогне на посетителите да открият вашето уики.',
	'autocreatewiki-bad-name' => 'Името не може да съдържа специални символи (като $ или @) и е необходимо да е една дума, изписана с малки букви и без интервали.',
	'autocreatewiki-busy-username' => 'Избраното потребителско име е вече заето.',
);


$messages['de'] = array(
	'autocreatewiki' => 'Erstelle ein neues Wiki',
	'createwikipagetitle' => 'Erstelle ein neues Wiki',
	'createwiki' => 'Neues Wiki erstellen',
	'autocreatewiki-chooseone' => 'Bitte wählen',
	'autocreatewiki-required' => '$1 = notwendige Angabe',
	'autocreatewiki-web-address' => 'Web-Adresse:',
	'autocreatewiki-category-select' => 'Bitte wählen',
	'autocreatewiki-language-top' => 'Top-$1 Sprachen',
	'autocreatewiki-language-all' => 'Alle Sprachen',
	'autocreatewiki-birthdate' => 'Geburtsdatum:',
	'autocreatewiki-blurry-word' => 'Spam-Schutz:',
	'autocreatewiki-remember' => 'Login-Daten behalten',
	'autocreatewiki-create-account' => 'Benutzerkonto erstellen',
	'autocreatewiki-done' => 'Fertig.',
	'autocreatewiki-error' => 'Fehler',
	'autocreatewiki-haveaccount-question' => 'Hast du bereits ein Benutzerkonto bei Wikia?',
	'autocreatewiki-success-title' => 'Dein Wiki wurde erstellt!',
	'autocreatewiki-success-subtitle' => 'Du kannst sofort in deinem Wiki loslegen - besuche einfach:',
	'autocreatewiki-success-get-started' => 'Auf gehts!',
	'autocreatewiki-info-domain' => 'Verwende am besten ein Wort, das vermutlich als Suchbegriff für dieses Thema verwendet wird.',
	'autocreatewiki-info-topic' => 'Wähle am besten einen kurzen, beschreibenden Namen (z.B. „Star Wars“ oder „Fernsehserien“).',
	'autocreatewiki-info-category' => 'Besucher können so dein Wiki einfacher finden.',
	'autocreatewiki-info-language' => 'Dies wird die Standard-Sprache für Besucher deines Wikis.',
	'autocreatewiki-info-email-address' => 'Deine E-Mail-Adresse wird niemandem angezeigt.',
	'autocreatewiki-info-realname' => 'Deine Arbeit wird deinem Namen zugeordnet, wenn du ihn angibst.',
	'autocreatewiki-info-blurry-word' => 'Um die automatische Erstellung von Benutzerkonten zu verhindern, tippe bitte das verschwommene Wort ein.',
	'autocreatewiki-info-terms-agree' => 'Mit Erstellung eines Wikis und eines Benutzerkontos stimmst du Wikias <a href="http://www.wikia.com/wiki/Terms_of_use">Nutzungsbedingungen</a> zu.',
	'autocreatewiki-info-staff-username' => 'Erstelle das Wiki für diesen Benutzer.',
	'autocreatewiki-limit-creation' => 'Du hast die maximale Anzahl an Wikis überschritten, die in 24 Stunden erstellen werden können.',
	'autocreatewiki-empty-field' => 'Fülle bitte dieses Feld aus.',
	'autocreatewiki-bad-name' => 'Diese Adresse darf keine Sonderzeichen (wie z.B. $ oder @) enthalten und muss ein einzelnes kleingeschriebenes Wort ohne Leerzeichen sein.',
	'autocreatewiki-invalid-wikiname' => 'Der Name des Wikis darf keine Sonderzeichen (z.B. $ oder @) enthalten und darf nicht leer sein.',
	'autocreatewiki-violate-policy' => 'Im Wiki-Namen ist ein Wort enthalten, dass unseren Namens-Regeln nicht entspricht.',
	'autocreatewiki-name-taken' => 'Ein Wiki mit diesem Namen existiert bereits. Du bist herzlich eingeladen, dich unter <a href="http://$1.wikia.com">http://$1.wikia.com</a> zu beteiligen.',
	'autocreatewiki-name-too-short' => 'Dieser Name ist zu kurz, bitte wähle einen mit mindestens 3 Buchstaben.',
	'autocreatewiki-similar-wikis' => 'Es existieren bereits Wiki zu diesem Thema. Wir raten, dass du dich dort einbringst.',
	'autocreatewiki-invalid-username' => 'Dieser Benutzername ist ungültig.',
	'autocreatewiki-busy-username' => 'Dieser Benutzername existiert bereits.',
	'autocreatewiki-blocked-username' => 'Du wurdest gesperrt - du kannst kein neues Benutzerkonto anlegen.',
	'autocreatewiki-empty-language' => 'Wähle bitte eine Sprache für dein Wiki.',
	'autocreatewiki-empty-category' => 'Bitte wähle eine Kategorie.',
	'autocreatewiki-empty-wikiname' => 'Bitte gib deinem Wiki einen Namen.',
	'autocreatewiki-empty-username' => 'Bitte gib einen Benutzernamen an.',
	'autocreatewiki-empty-password' => 'Das Passwort darf nicht leer sein.',
	'autocreatewiki-empty-retype-password' => 'Das Passwort darf nicht leer sein.',
	'autocreatewiki-set-username' => 'Wähle zuerst einen Benutzernamen.',
	'autocreatewiki-invalid-category' => 'Ungültige Kategorie-Auswahl. Bitte wähle eine Kategorie aus der Liste.',
	'autocreatewiki-invalid-language' => 'Ungültige Sprach-Auswahl. Bitte wähle eine Sprache aus der Liste.',
	'autocreatewiki-invalid-retype-passwd' => 'Bitte gib das gleiche Passwort wie oben ein.',
	'autocreatewiki-invalid-birthday' => 'Ungültiges Geburtsdatum',
	'autocreatewiki-limit-birthday' => 'Eine Registrierung ist nicht möglich - wende dich bitte an Wikia.',
	'autocreatewiki-log-title' => 'Dein Wiki wird erstellt.',
	'autocreatewiki-step0' => 'Initialisiere Prozess ...',
	'autocreatewiki-stepdefault' => 'Prozess läuft, bitte warten ...',
	'autocreatewiki-errordefault' => 'Der Prozess wurde nicht beendet ...',
	'autocreatewiki-step1' => 'Erstelle Bilder-Ordner ...',
	'autocreatewiki-step2' => 'Erstelle Datenbank ...',
	'autocreatewiki-step3' => 'Initialisiere Datenbank-Informationen ...',
	'autocreatewiki-step4' => 'Übertrage Logo und Standard-Bilder ...',
	'autocreatewiki-step5' => 'Initialisiere Datenbank-Variablen ...',
	'autocreatewiki-step6' => 'Initialisiere Datenbank-Tabellen ...',
	'autocreatewiki-step7' => 'Übertrage Sprach-Basisversion ...',
	'autocreatewiki-step8' => 'Erstelle Benutzer-Gruppen und Kategorien ...',
	'autocreatewiki-step9' => 'Anpassung der Variablen ...',
	'autocreatewiki-step10' => 'Erstelle Seiten im Zentral-Wikia ...',
	'autocreatewiki-step11' => 'Sende E-Mail an Benutzer ...',
	'autocreatewiki-redirect' => 'Weiterleitung zum neuen Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Glückwunsch!',
	'autocreatewiki-welcometalk-log' => 'Begrüßung des Wiki-Gründers',
	'autocreatewiki-step2-error' => 'Datenbank existiert bereits!',
	'autocreatewiki-step3-error' => 'Initialisierung der Datenbank-Informationen fehlgeschlagen!',
	'autocreatewiki-step6-error' => 'Initialisierung der Datenbank-Tabellen fehlgeschlagen!',
	'autocreatewiki-step7-error' => 'Fehler beim Übertragen der Sprach-Basisversion!',
	'autocreatewiki-welcomesubject' => '$1 wurde erstellt!',
	'autocreatewiki-welcomebody' => 'Hallo $2,

das von dir erstellte Wiki ist nun unter <$1> erreichbar. Hoffentlich sehen wir dich bald dort editieren :-)

Wir haben auf deiner Diskussionsseite (<$5>) ein paar Tipps für den Start hinterlassen.

Falls du irgendwelche Probleme hast, stöber doch ein wenig in unseren Hilfe-Seiten <http://hilfe.wikia.com>. Du kannst auch im Forum von Zentralwikia die Community um Hilfe bitten <http://de.wikia.com/wiki/Forum:Übersicht> oder dich per E-Mail an community@wikia.com wenden.

Falls du sonst weitere Fragen oder Probleme hast, kannst du dich auch direkt per Mail oder Diskussionsseite an mich wenden.

Viel Erfolg mit deinem neuen Wiki!

$3

Wikia Community-Team

<http://de.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => '== Willkommen! ==
<div style="font-size:120%; line-height:1.2em;">Hi $1 - wir freuen uns, dass \'\'\'$4\'\'\' jetzt Teil der Wikia-Gemeinschaft ist!

Jetzt hast du eine ganze Webseite, die du mit Informationen, Bildern und Videos über dein Thema füllen kannst. Aber im Moment gibt es nur leere Seiten, die dich anstarren... Gruselig, nicht wahr? Hier einige Anregungen, wie du anfangen kannst.

* \'\'\'Stelle dein Thema vor\'\'\' - auf der Hauptseite. Diese Seite ist deine Chance, den Lesern alles über dein Thema zu verraten. Schreib so viel du willst! Deine Beschreibung kann zu allen wichtigen Seiten im Wiki verlinken.

* \'\'\'Erstelle einige neue Seiten\'\'\' - nur ein oder zwei Sätze um anzufangen. Lass dich nicht von den leeren Seiten unterkriegen! Ein wiki ist eine Webseite wo du immerwieder Dinge hinzufügen oder ändern kannst. Du kannst auch Bilder und Videos auf die Hauptseite packen, um sie ineressanter zu machen.

Und im Anschluss mach einfach weiter! Leute mögen große Wikis, wenn man viel entdecken kann. Also füg weiterhin Inhalte hinzu, und du wirst neue Leser und Benutzer anziehen. Es gibt viel zu tun, aber sei unbesorgt - heute ist dein erster Tag, und du hast genügend Zeit. Jedes Wiki fängt auf die selbe Weise an - es braucht nur ein bisschen Zeit, und nach den ersten paar Seiten, und einer Weile wird das Wiki zu einer großen, oftbesuchten Seite anwachsen.

Falls du Hilfe benötigst (und glaub mir: die haben wir alle gebraucht) findest du unsere umfangreichen englischen Hilfe-Seiten unter [[w:c:Help|Help Wikia]]. Oder wirf einmal einen Blick in die stetig wachsende Zahl [[w:c:hilfe:Kategorie:Hilfe|deutschsprachiger Hilfeseiten]].

Wenn du weitere Hilfe brauchst, kannst du
*uns eine Mail über unser [[Special:Contact|Kontaktformular]] schreiben,
*unseren [http://irc.wikia.com #wikia Live-Chat] besuchen,
*oder bei allem rund um Logo, Skin und das Admin sein [[w:c:de.support|Wikia Support (deutschsprachig)]] besuchen.

Genug der Begrüßung - jetzt kannst du mit dem Bearbeiten starten! :-)
Wir freuen uns darauf dieses Projekt gedeihen zu sehen!

Viel Erfolg, [[User:Avatar|Tim \'avatar\' Bartel]] <staff /></div>',
);


$messages['es'] = array(
	'autocreatewiki' => 'Crear nuevo Wiki',
	'createwikipagetitle' => 'Crear un nuevo wiki',
	'createwiki' => 'Solicita un nuevo wiki',
	'autocreatewiki-chooseone' => 'Elije una',
	'autocreatewiki-required' => '$1 = requerido',
	'autocreatewiki-web-address' => 'Dirección Web',
	'autocreatewiki-category-select' => 'Selecciona una',
	'autocreatewiki-language-top' => 'Top $1 de idiomas',
	'autocreatewiki-language-all' => 'Todos los idiomas',
	'autocreatewiki-birthdate' => 'Fecha de nacimiento:',
	'autocreatewiki-blurry-word' => 'Palabra borrosa:',
	'autocreatewiki-remember' => 'Recordarme',
	'autocreatewiki-create-account' => 'Crear una Cuenta',
	'autocreatewiki-done' => 'hecho',
	'autocreatewiki-haveaccount-question' => '¿Tienes ya cuenta en Wikia?',
	'autocreatewiki-success-title' => '¡Tu wiki ha sido creado!',
	'autocreatewiki-success-subtitle' => 'Ya puedes comenzar a trabajar en tu wiki visitando:',
	'autocreatewiki-info-domain' => 'Lo mejor es usar las palabras que tengan más posibilidades de ser buscada sobre el tema de tu wiki. Por ejemplo si el tema es una serie de televisión, las palabras serían el nombre de la serie.',
	'autocreatewiki-info-topic' => 'Añade una descripción corta como por ejemplo "Star Wars" o "Series de TV".',
	'autocreatewiki-info-category' => 'Esto ayudará a los visitantes a encontrar tu wiki.',
	'autocreatewiki-info-language' => 'Este será el idioma por defecto para los visitantes de tu wiki.',
	'autocreatewiki-info-email-address' => 'Tu dirección de email no se mostrará a nadie en Wikia.',
	'autocreatewiki-info-realname' => 'Si optas por proporcionarlo, se usará para dar atribución a tu trabajo.',
	'autocreatewiki-info-birthdate' => 'Wikia solicita a todos los usuarios que pongan su fecha real de nacimiento como una medida de seguridad y como una forma de preservar la integridad del sitio mientras cumple con las regulaciones federales.',
	'autocreatewiki-info-blurry-word' => 'Para ayudar protegernos contra la creación de cuentas automáticas, escribe la palabra borrosa que ves en el campo que hay, por favor.',
	'autocreatewiki-info-terms-agree' => 'Con la creación de un wiki y una cuenta de usuario, aceptas los <a href="http://www.wikia.com/wiki/Terms_of_use">Términos de Uso de Wikia</a>',
	'autocreatewiki-limit-creation' => 'Has excedido el número máximo de creación de wikis en 24 horas.',
	'autocreatewiki-empty-field' => 'Por favor, completa este campo.',
	'autocreatewiki-bad-name' => 'El nombre no puede contener caracteres especiales (como $ o @) y deben ser palabras simples y sin espacios.',
	'autocreatewiki-invalid-wikiname' => 'El nombre no puede contener caracteres especiales (como $ o @) y el campo no puede estar vacío.',
	'autocreatewiki-violate-policy' => 'El nombre del wiki contiene una palabra que viola nuestra política de nombres',
	'autocreatewiki-name-taken' => 'Ya existe un wiki con ese nombre. Eres bienvenido a participar con nosotros en <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Este nombre es demasiado corto, por favor, elige un nombre con al menos 3 caracteres.',
	'autocreatewiki-similar-wikis' => 'Debajo están los wikis ya creados sobre este tema. Te sugerimos editar en alguno de ellos.',
	'autocreatewiki-invalid-username' => 'Este nombre de usuario no es válido',
	'autocreatewiki-busy-username' => 'Este nombre de usuario ya está en uso.',
	'autocreatewiki-blocked-username' => 'No puedes crear la cuenta.',
	'autocreatewiki-user-notloggedin' => '¡Tu cuenta fue creada, pero no te identificaste!',
	'autocreatewiki-empty-language' => 'Por favor, selecciona el idioma del wiki.',
	'autocreatewiki-empty-category' => 'Por favor, selecciona una de las categorías.',
	'autocreatewiki-empty-wikiname' => 'El campo del nombre del wiki no puede estar vacío.',
	'autocreatewiki-empty-username' => 'El campo del nombre de usuario no puede estar vacío.',
	'autocreatewiki-empty-password' => 'El campo de la contraseña no puede estar vacío.',
	'autocreatewiki-empty-retype-password' => 'El campo para repetir la contraseña no puede estar vacío.',
	'autocreatewiki-set-username' => 'Pon el nombre de usuario primero.',
	'autocreatewiki-invalid-category' => 'Valor inválido para la categoría. Por favor, selecciona el apropiado desde la lista desplegable de abajo.',
	'autocreatewiki-invalid-language' => 'Valor inválido para el idioma. Por favor, selecciona el apropiado desde la lista desplegable de abajo.',
	'autocreatewiki-invalid-retype-passwd' => 'Escribe la misma contraseña que arriba.',
	'autocreatewiki-invalid-birthday' => 'Fecha de nacimiento inválida',
	'autocreatewiki-limit-birthday' => 'Inhabilitado para crear registros.',
	'autocreatewiki-log-title' => 'Tu wiki está siendo creado',
	'autocreatewiki-step0' => 'Iniciando proceso ...',
	'autocreatewiki-stepdefault' => 'El proceso está en marcha, por favor, espera un poco ...',
	'autocreatewiki-errordefault' => 'El proceso no fue terminado...',
	'autocreatewiki-step1' => 'Creando carpeta de imágenes ...',
	'autocreatewiki-step2' => 'Creando base de datos ...',
	'autocreatewiki-step3' => 'Configurando la información por defecto en la base de datos ...',
	'autocreatewiki-step4' => 'Copiando imágenes y logo por defecto ...',
	'autocreatewiki-step5' => 'Configurando variables por defecto en la base de datos ...',
	'autocreatewiki-step6' => 'Configurando tablas por defecto en la base de datos ...',
	'autocreatewiki-step7' => 'Configurando el idioma del starter ...',
	'autocreatewiki-step8' => 'Configurando grupos de usuarios y categorías ...',
	'autocreatewiki-step9' => 'Configurando las variables para el nuevo wiki ...',
	'autocreatewiki-step10' => 'Configurando páginas de la central de Wikia ...',
	'autocreatewiki-step11' => 'Enviando email al usuario ...',
	'autocreatewiki-redirect' => 'Redirigiendo al nuevo Wiki: $1 ...',
	'autocreatewiki-congratulation' => '¡Felicidades!',
	'autocreatewiki-welcometalk-log' => 'Bienvenida al nuevo sysop',
	'autocreatewiki-step2-error' => '¡La base de datos ya existe!',
	'autocreatewiki-step3-error' => '¡No se puede configurar la información por defecto en la base de datos!',
	'autocreatewiki-step6-error' => '¡No se pueden configurar las tablas por defecto en la base de datos!',
	'autocreatewiki-step7-error' => '¡No se puede copiar el starter para este idioma en la base de datos!',
	'autocreatewiki-welcomesubject' => '¡$1 ha sido creado!',
	'autocreatewiki-welcomebody' => 'Hola, $2,

El wiki que solicitaste está disponible en <$1> ¡Esperamos verte editando ahí pronto!

Hemos añadido alguna Información y Consejos en tu Página de Discusión de Usuario (<$5>) para ayudarte a comenzar.

Si tienes cualquier problema, puedes preguntar por la comunidad de ayuda en el wiki en <http://es.wikia.com/wiki/Forum:Secci%C3%B3n_de_ayuda>, o vía email a community@wikia.com.

Puedes contactar conmigo directamente por email o en mi página de discusión, si tienes alguna pregunta o inquietud.

¡Buena suerte con el proyecto!

$3

Equipo Comunitario de Wikia

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => '== ¡Bienvenido! ==
Hola $1. ¡Estamos muy felices de tener a \'\'\'$4\'\'\' como parte de la comunidad de Wikia! Además de darte las gracias por unirte a Wikia, nos gustaría darte algunos consejos que pueden ayudarte a iniciar el wiki y hacerlo crecer.

=== \'\'\'Los cuatro primeros pasos:\'\'\' ===
1. \'\'\'Crea tu [[Usuario:$1|página de usuario]]\'\'\': éste es el mejor lugar para presentarte y que los demás puedan conocerte (¡y además practicar la edición wiki!)

2. \'\'\'Añade un logo\'\'\': aprende a [[w:c:ayuda:Ayuda:Logo|crear un logo]] y luego <span class="plainlinks">[[Especial:SubirArchivo/Wiki.png|haz clic aquí]]</span> para añadirlo al wiki.<div style="border: 1px solid black; margin: 0px 0px 5px 10px; padding: 5px; float: right; width: 25%;"><center>Crea un artículo en este wiki:</center>
   <createbox>
width=30
</createbox></div>
3. \'\'\'Crea tus 10 primeros artículos\'\'\': usa esta caja ubicada a la derecha para crear diez páginas, comenzando cada una con unos pocos párrafos. Por ejemplo, si estás iniciando un wiki sobre un programa de TV, podrías crear un artículo para cada uno de los personajes principales.

4. \'\'\'Edita la Portada\'\'\': incluye enlaces internos (<nowiki>[[de esta forma]]</nowiki>) a los diez artículos que recién creaste y realiza cualquier otra modificación que tu portada necesite.

Una vez que hayas realizado estas 4 tareas, habrás creado lo que servirá de gran punto de inicio: tu wiki luce más amigable y está listo para recibir visitantes. Ahora puedes invitar a algunos amigos para que te ayuden a crear las próximas veinte páginas y a expandir las que ya has creado.

¡Sigue así! Mientras más páginas crees y enlaces a otras, más rápido lograrás que quienes busquen por "$4" encuentren tu proyecto en los motores de búsqueda, lean tu contenido y se unan a la edición de artículos.

Si tienes más preguntas, hemos creado un completo conjunto de [[Ayuda:Contenidos|páginas de ayuda]] para que consultes. También puedes enviarnos un correo electrónico a través de nuestro [[Especial:Contact|formulario de contacto]]. No olvides revisar otros wiki de [[w:c:es:Wikia|Wikia]] para que veas más ideas de diseño, organización de páginas y muchos otros detalles. ¡Disfrútalo!

Los mejores deseos, [[User:$2|$3]] <staff />',
);


$messages['fa'] = array(
	'autocreatewiki' => 'ایجاد ویکی جدید',
	'createwikipagetitle' => 'ایجاد ویکی جدید',
	'createwiki' => 'ایجاد ویکی جدید',
	'autocreatewiki-chooseone' => 'یکی را انتخاب کنید',
	'autocreatewiki-web-address' => 'نشانی اینترنتی:',
	'autocreatewiki-category-select' => 'یکی را انتخاب کنید',
	'autocreatewiki-birthdate' => 'تاریخ تولد:',
	'autocreatewiki-blurry-word' => 'لغت نامعلوم:',
	'autocreatewiki-create-account' => 'ایجاد حساب کاربری',
	'autocreatewiki-done' => 'تمام شد',
	'autocreatewiki-error' => 'خطا',
	'autocreatewiki-haveaccount-question' => 'آیا از قبل در ویکیا حساب کاربری دارید؟',
	'autocreatewiki-success-title' => 'ویکی شما ایجاد شد!',
	'autocreatewiki-success-subtitle' => 'با مراجعه به نشانی روبرو شما می‌توانید کار بر روی ویکی خود را آغاز کنید:',
	'autocreatewiki-info-domain' => 'بهتر است از کلمه‌ای استفاده کنید که درصد جستجو شدن آن در موضوع ویکی شما زیاد باشد.',
	'autocreatewiki-info-category' => 'این به کاربران کمک می‌کند که ویکی شما را بیابند.',
	'autocreatewiki-info-language' => 'این زبان پیش‌فرض ویکی شما خواهد بود.',
	'autocreatewiki-info-email-address' => 'آدرس پست الکترونیکی شما به کاربران ویکیا نمایش داده نخواهد شد.',
	'autocreatewiki-info-birthdate' => 'تمام کاربران ویکیا مستلزم هستند که تاریخ تولد اصلی خود را برای احتیاط و حفظ منافع وب‌گاه در برابر دولت ارائه کنند.',
	'autocreatewiki-info-blurry-word' => 'برای جلوگیری از ایجاد خودکار حساب کاربری، لطفا حروف بالا را در این فیلد وارد کنید.',
	'autocreatewiki-info-terms-agree' => 'با ایجاد ویکی و حساب کاربری شما <a href="http://www.wikia.com/wiki/Terms_of_use">شرایط استفاده از ویکیا</a> را قبول می‌کنید.',
	'autocreatewiki-empty-field' => 'لطفا این فیلد را کامل کنید.',
	'autocreatewiki-bad-name' => 'نام ویکی شامل کاراکترهای مخصوص (مانند $ یا @) نمی‌تواند باشد و باید حروف کوچک انگلیسی بدون فاصله باشد.',
	'autocreatewiki-violate-policy' => 'نام این ویکی شامل لغتی است که ناقض سیاست‌ نام‌گذاری ما است',
	'autocreatewiki-busy-username' => 'این نام کاربری از قبل انتخاب شده‌است.',
	'autocreatewiki-blocked-username' => 'شما اجازۀ ایجاد حساب کاربری ندارید.',
	'autocreatewiki-user-notloggedin' => 'حساب کاربری شما ساخته‌شد ولی هنوز وارد سیستم نشده‌اید!',
	'autocreatewiki-empty-language' => 'لطفا زبان ویکی را انتخاب کنید.',
	'autocreatewiki-empty-category' => 'لطفا یکی از رده‌ها را انتخاب کنید.',
	'autocreatewiki-empty-wikiname' => 'نام ویکی نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-username' => 'نام کاربری نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-password' => 'گذرواژه نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-retype-password' => 'فیلد تکرار گذرواژه نمی‌تواند خالی باشد.',
	'autocreatewiki-stepdefault' => 'فرآیند در حال انجام‌شدن است، لطفا صبر کنید ...',
	'autocreatewiki-errordefault' => 'عمل پایان نیافت ...',
	'autocreatewiki-step7' => 'در حال تنظیم نسخه آغازگر ویکی ...',
	'autocreatewiki-step8' => 'در حال تنظیم اختیارات گروه‌های کاربری و رده‌ها ...',
	'autocreatewiki-step9' => 'در حال تنظیم متغیرهای ویکی جدید ...',
	'autocreatewiki-congratulation' => 'مبارک باشد!',
	'autocreatewiki-welcometalk-log' => 'پیغام خوش‌آمد گویی',
	'autocreatewiki-step7-error' => 'نسخه‌برداری از پایگاه آغازگر ویکی با موفقیت انجام نشد!',
	'autocreatewiki-welcomesubject' => '$1 ساخته شد!',
	'autocreatewiki-welcomebody' => 'سلام $2،

ویکیایی که شما درخواست کرده‌بودید در <$1> قابل دسترسی است. ما امیدواریم به زودی شاهد ویرایش شما در آن‌جا باشیم!

ما یکسری اطلاعات و نکته‌هایی در صحفه بحثتان (<$5>) اضافه کرده‌ایم تا به شما برای شروع ویکیتان کمک کند. اگر سوالی دارید، به این ایمیل پاسخ دهید یا در صفحات راهنمای ویکیا در <http://help.wikia.com> جستجو کنید.


$3

تیم محله ویکیا
<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => '<div align="right" dir="rtl" style="font-family: Tahoma;">
سلام $1، ما از داشتن \'\'\'$4\'\'\' در بین دیگر ویکیاهای ویکیا بسیار خوشحالیم!

شروع کردن ویکی جدید می‌تواند کار بزرگی باشد، ولی نگران نباشید، [[wikia:Community Team|تیم اجتماع ویکیا]] برای کمک اینجاست! ما راهنمایی‌هایی برای کمک به شروع ویکی جدید آماده کرده‌ایم. در کنار راهنمایی‌های ویکیا می‌توانید به ویکی‌های دیگر در [[w:c:fa:شرکت ویکیا|ویکیا]] برای گرفتن ایده جهت قالب بندی، رده بندی، و غیره سر بزنید. همه ما عضوی از خانواده بزرگ ویکیا هستیم که برای خوش گذرانی در اینجا با هم مشارکت می‌کنیم!
* [[w:c:help:Help:Starting this wiki|راهنمای شروع ویکی]] ما ۵ نکته به شما می‌دهد تا همین الان ویکی خود را به بهترین وجه تنظیم نمایید.
*ما همچنین [[w:c:help:Advice:Advice on starting a wiki| توصیه‌هایی برای شروع ویکی]] آماده  کرده‌ایم که اطلاعات عمیق‌تری برای ساخت ویکی جدید به شما می‌دهد.
*اگر شما کاربر جدید ویکیا هستید، ما به شما توصیه می‌کنیم که به [[w:c:fa:پرسش‌های رایج|پرسش‌های رایج کاربران جدید]]  مراجعه کنید.
اگر کمکی نیاز داشتید، می‌توانید به [[w:c:help|راهنمای ویکیا]] مراجعه کنید و یا از طریق [[Special:Contact|فرم تماس]] به ما پست الکترونیکی بزنید.

منتظر درخشش پروژه شما هستیم!

با آرزوی بهترین‌ها، [[User:$2|$3]] <staff />
</div>',
);


$messages['it'] = array(
	'autocreatewiki' => 'Crea un nuova wiki',
	'createwikipagetitle' => 'Crea un nuova wiki',
	'autocreatewiki-protect-reason' => 'parte dell\'interfaccia ufficiale',
	'autocreatewiki-welcomebody' => 'Ciao $2,

La wikia che hai creato è ora disponibile su <$1>. Speriamo di vedere i tuoi contributi al più presto! <br> Abbiamo aggiunto alcune informazione e suggerimenti alla tua pagina di discussione (<$5>) per aiutarti a mettere in moto la tua wiki. Per qualunque domanda, puoi rispondere a questa email o controllare sulle pagina di aiuto su <http://help.wikia.com>.

Buona fortuna per il progetto,

$3 Wikia Community Team <http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => '== Benvenuto! ==
Ciao $1 -- siamo molto contenti di avere \'\'\'$4\'\'\' nella nostra Wikia community!   Grazie per la tua collaborazione! Ti vogliamo dare alcuni suggerimenti per aiutarti a mettere in moto la tua wiki.


=== \'\'\'I tuoi primi quattro passi:\'\'\' ===
1. \'\'\'Crea la tua [[Utente:$1|Pagina Utente]]\'\'\' - è il posto per parlare di te stesso e farti conoscere (e fare pratica!)

2. \'\'\'Aggiungi un logo\'\'\' - impara come su [[w:c:help:Help:Logo|come creare un logo]], e poi <span class="plainlinks">[[Speciale:Carica/Wiki.png|clicca qui]]</span> per aggiungerlo alla tua wiki.<div style="border: 1px solid black; margin: 0px 0px 5px 10px; padding: 5px; float: right; width: 25%;"><center>Crea un articolo per questa wiki:</center>
   <createbox>
width=30
</createbox></div>
3. \'\'\'Crea i tuoi primi 10 articoli\'\'\' - usa il campo sulla destra per creare la pagine, iniziando con poche righe per ogni articolo.

4. \'\'\'Modifica la pagina principale\'\'\' - clicca sul logo e raggiungi la pagina principale. Ricordati di aggiungere dei link interni ([[come questo]]) per raggiungere le nuove pagine che hai appena creato.


Dopo aver seguito tutti i passi sei già a buon punto! La tua wiki deve sembrare attiva ed aperta ai nuovi utenti. Puoi sempre chiedere ai tuoi amici di aiutarti, oppure invitare nuove persone a creare nuovi articoli o modificare quelli già esistenti.

Più pagine e link vengono creati e più velocemente la tua wiki diventerà popolare. I visitatori che cercheranno "$4" saranno in grado di trovarlo facilmente.

Per qualunque altre domanda, puoi leggere le [[Help:Contents|pagine di aiuto]], oppure spedirci un\'e-mail attraverso il nostro [[Special:Contact|modulo dei contatti]]. Non dimenticare di controllare le altre wiki su [[wikia:Wikia|Wikia]] per idee, template, layout e molto altro!

Buona fortuna, [[User:$2|$3]] <staff />',
);


$messages['ja'] = array(
	'autocreatewiki' => '新しいWikiを作成する',
	'createwikipagetitle' => '新しいウィキのお申し込みはこちら!',
	'createwiki' => '新しいウィキのお申し込みはこちら!',
	'autocreatewiki-chooseone' => '一つを選ぶ',
	'autocreatewiki-required' => '$1 = 必須',
	'autocreatewiki-web-address' => 'サイトのアドレス:',
	'autocreatewiki-category-select' => 'どれか一つを選ぶ',
	'autocreatewiki-language-top' => '上位12言語',
	'autocreatewiki-language-all' => '全ての言語',
	'autocreatewiki-birthdate' => '生年月日:',
	'autocreatewiki-blurry-word' => '画像認証:',
	'autocreatewiki-remember' => 'パスワードを記憶する。',
	'autocreatewiki-create-account' => 'アカウントを作成する',
	'autocreatewiki-done' => '完了',
	'autocreatewiki-error' => 'エラー',
	'autocreatewiki-haveaccount-question' => 'すでにウィキアのアカウントをお持ちですか？',
	'autocreatewiki-success-title' => 'ウィキが作成されました！',
	'autocreatewiki-success-subtitle' => '下記のURLをクリックして作業を開始できます',
	'autocreatewiki-info-domain' => 'ウィキが扱う内容を表し、検索キーワードとなるようなものがよいでしょう。',
	'autocreatewiki-info-topic' => '"Star Wars"や"テレビ番組"など、ウィキの主題を簡単に示すような名称にしましょう。',
	'autocreatewiki-info-category' => 'ウィキアの訪問者があなたの作るウィキをみつけやすいようにします。',
	'autocreatewiki-info-language' => 'ここで指定した言語が、ウィキの訪問者に対して標準で表示される言語になります。',
	'autocreatewiki-info-email-address' => 'あなたのメールアドレスがウィキア上で誰かに直接知らされることはありません。',
	'autocreatewiki-info-realname' => '本名を入力すると、ページ・クレジットに利用者名（アカウント名）の代わりに本名が表示されます。',
	'autocreatewiki-info-birthdate' => 'ウィキアでは、アメリカ合衆国の法規定を満たす上で、サイトの品質を維持するための手段及び安全のための予防策としてすべての利用者に対して生年月日の入力を求めています。',
	'autocreatewiki-info-blurry-word' => 'ツールなどによる自動アカウント作成を防ぐため、画像で表示された文字を入力してください。',
	'autocreatewiki-info-terms-agree' => 'ウィキ及びアカウントを作成すると、<a href="http://www.wikia.com/wiki/Terms_of_use">ウィキアの利用規約</a>（<a href="http://ja.wikia.com/wiki/%E5%88%A9%E7%94%A8%E8%A6%8F%E7%B4%84">非公式日本語訳</a>）に同意したことになります。',
	'autocreatewiki-limit-day' => '一日にウィキアが作成可能なウィキの最大数を超えています。($1)',
	'autocreatewiki-limit-creation' => '24時間であなたが作成できるウィキの最大数を超えています。($1)',
	'autocreatewiki-empty-field' => 'この項目は空白にはできません。',
	'autocreatewiki-bad-name' => 'URLには$や@などの文字は使えません。また、ローマ字は全てスペースなしの小文字でなければなりません。',
	'autocreatewiki-invalid-wikiname' => '"{"や"<"など、一部の文字はウィキ名に使用できません。また、空白にもできません。',
	'autocreatewiki-violate-policy' => 'このウィキ名には、ウィキアの方針上問題のある単語が含まれています。',
	'autocreatewiki-name-taken' => 'この名称のウィキは既にあります。<a href="http://$1.wikia.com">http://$1.wikia.com</a>に是非ご参加ください。',
	'autocreatewiki-name-too-short' => 'アドレスが短すぎます。3文字以上のアドレスを指定してください。',
	'autocreatewiki-similar-wikis' => 'この主題について扱っているウィキとして下記のようなものがすでに存在します。これらのうちのどれかを編集することをお勧めいたします。',
	'autocreatewiki-invalid-username' => 'この利用者名は不適切です。',
	'autocreatewiki-busy-username' => 'この利用者名はすでに使われています。',
	'autocreatewiki-blocked-username' => 'アカウントを作成できません。',
	'autocreatewiki-user-notloggedin' => 'アカウントは作成されましたがログイン状態になっていません！',
	'autocreatewiki-empty-language' => 'ウィキで使用する言語を選んでください。',
	'autocreatewiki-empty-category' => 'どれか一つカテゴリを選んでください。',
	'autocreatewiki-empty-wikiname' => 'ウィキ名は空白にはできません。',
	'autocreatewiki-empty-username' => '利用者名は空にはできません。',
	'autocreatewiki-empty-password' => 'パスワードは空にはできません。',
	'autocreatewiki-empty-retype-password' => 'パスワードの再入力が空です。',
	'autocreatewiki-set-username' => 'まず利用者名を設定してください。',
	'autocreatewiki-invalid-category' => 'カテゴリの値が不適切です。ドロップダウンリストから適切なものを選んでください。',
	'autocreatewiki-invalid-language' => '言語の値が不適切です。ドロップダウンリストから適切なものを選んでください。',
	'autocreatewiki-invalid-retype-passwd' => '上のパスワードと同じものを再入力してください。',
	'autocreatewiki-invalid-birthday' => '不適切な生年月日です',
	'autocreatewiki-limit-birthday' => '登録できません。',
	'autocreatewiki-log-title' => 'ウィキが作成されています...',
	'autocreatewiki-step0' => 'プロセスを初期化しています...',
	'autocreatewiki-stepdefault' => 'プロセスが進行中です, お待ちください...',
	'autocreatewiki-errordefault' => 'プロセスが完了しませんでした。',
	'autocreatewiki-step1' => 'imagesフォルダを作成しています...',
	'autocreatewiki-step2' => 'データベースを作成しています...',
	'autocreatewiki-step3' => 'データベースに初期情報を設定しています...',
	'autocreatewiki-step4' => '初期設定画像とロゴをコピーしています...',
	'autocreatewiki-step5' => 'データベースに初期変数を設定しています...',
	'autocreatewiki-step6' => 'データベースに初期テーブルを設定しています...',
	'autocreatewiki-step7' => '標準言語のスターターを設定しています...',
	'autocreatewiki-step8' => '利用者グループ及びカテゴリを設定しています...',
	'autocreatewiki-step9' => '新しいウィキに変数を設定しています...',
	'autocreatewiki-step10' => 'セントラルウィキアにページを設置しています...',
	'autocreatewiki-step11' => '利用者にメールを送信しています...',
	'autocreatewiki-redirect' => '新しいウィキに転送しています: $1 ...',
	'autocreatewiki-welcometalk-log' => '自動メッセージ',
	'autocreatewiki-regex-error-comment' => 'ウィキ $1 で使用されています（全文: $2）',
	'autocreatewiki-step2-error' => 'データベースは既に存在します！',
	'autocreatewiki-step3-error' => 'データベースに初期情報を設定できません！',
	'autocreatewiki-step6-error' => 'データベースに初期テーブルを設定できません！',
	'autocreatewiki-step7-error' => 'スターターのデータベースをコピーできません！',
	'autocreatewiki-welcomesubject' => 'ウィキが作成されました！',
	'autocreatewiki-welcomebody' => '申請ありがとうございました。申請されたウィキアは、現在<$0>で利用可能です。すぐにでも編集を始めてくれるとこちらとしてもうれしく思います。 利用にあたってのヘルプのページは、「Help:トップページ<http://ja.wikia.com/wiki/Help:%E3%83%88%E3%83%83%E3%83%97%E3%83%9A%E3%83%BC%E3%82%B8>」にあります。何か問題のあったときは、「フォーラム <http://ja.wikia.com/wiki/Forum:Index>」でお尋ねください。もしくは、 community@wikia.com までメールをくださっても結構です。また、#wikia-jaのIRCチャンネルでウィキを問わずコミュニティの方々が議論をしていますので、アドバイスが欲しい場合は遠慮無くログインしてみてください。それ以外にも、疑問や気になることがあれば、直接わたしのところにメールや会話ページに書き込みをしていただいても構いません。それでは、プロジェクトの今後を期待しております。コミュニティ・チーム http://www.wikia.com/wiki/User:$3',
	'autocreatewiki-welcometalk' => '$1さん、$4の申請ありがとうございます。

ウィキを開始するというのはとても大変ですが、もし、何か困ったことがあったら、是非とも[[w:Community Team|ウィキアのコミュニティチーム]]([[w:c:ja:利用者‐会話:Yukichi|日本人スタッフ]])までどうぞ。利用者向けガイドもいくつかこのウィキにありますので、是非とも御覧ください。サイトデザインやコンテンツの作り方に迷ったら、[[w:c:ja:プロジェクトポータル|ウィキアの他のプロジェクト]]をチェックして見てください。ウィキア全体がその良い参考例になるはずです。
* まずは、良いウィキを作るために[[w:c:ja:Help:ウィキの開始|ウィキを開始するにあたってのアドバイス]]を御覧ください。
* また、それらをまとめた[[w:c:ja:Help:良いウィキを作るコツ|ウィキを作るコツ]]も御覧になってください。
* ウィキ自体が初めてなら、[[w:c:ja:Help:FAQ|FAQ]]もあります。
ウィキア自体のヘルプを[[w:c:ja:Help:トップページ|日本語でまとめています]]ので、詳細な情報はこちらを御覧ください。相談ごとは、[[Special:Contact|連絡用ページ]]からどうぞ。IRCチャンネルの #wikia-ja で、他の利用者とコンタクトすることもできます。是非とも御利用ください。

それでは、今後とも、よろしくお願いします。[[User:$2|$3]]',
	'newwikis' => '新しいウィキ',
	'newwikisstart' => '次の文字列から始まるウィキを表示:',
);


$messages['nl'] = array(
	'autocreatewiki' => 'Begin een nieuwe Wiki',
	'autocreatewiki-chooseone' => 'Kies er een',
	'autocreatewiki-required' => '$1 = vereist',
	'autocreatewiki-web-address' => 'Web Adres:',
	'autocreatewiki-category-select' => 'Kies er een',
	'autocreatewiki-language-top' => 'Top $1 talen',
	'autocreatewiki-language-all' => 'Alle talen',
	'autocreatewiki-birthdate' => 'Dag van geboorte:',
	'autocreatewiki-blurry-word' => 'Blurry woord:',
	'autocreatewiki-remember' => 'Onthoud mij',
	'autocreatewiki-create-account' => 'Maak een Account',
	'autocreatewiki-done' => 'volbracht',
	'autocreatewiki-error' => 'error',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,nl,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Heeft u al een Wikia account?',
	'autocreatewiki-success-title' => 'Je wiki is gecreëerd!',
	'autocreatewiki-success-subtitle' => 'Je kan nu beginnen met het werken aan je wiki door deze pagina te bezoeken:',
	'autocreatewiki-info-domain' => 'Het is het beste om een woord te kiezen dat vaak gebruikt zal worden om jouw onderwerp te vinden.',
	'autocreatewiki-info-topic' => 'Voeg een korte beschrijving toe, zoals "Star Wars" of "TV programma".',
	'autocreatewiki-info-category' => 'Dit zal bezoekers helpen je wiki te vinden.',
	'autocreatewiki-info-language' => 'Dit zal de standaard taal worden voor bezoekers aan jouw wiki.',
	'autocreatewiki-info-email-address' => 'Jouw email adres wordt nooit bekend gemaakt aan welk persoon dan ook op Wikia.',
	'autocreatewiki-info-realname' => 'Als je kiest om hem te verstrekken zal hij gebruikt worden om jouw werk aan de wiki toe te kennen.',
	'autocreatewiki-info-birthdate' => 'Wikia vraagt aan alle gebruikers om hun echte geboortedatum op te geven voor veiligheid maar ook om de integriteit van de site aan de federale regels te laten voldoen.',
	'autocreatewiki-info-blurry-word' => 'Om het automatisch creëren van een account tegen te gaan moet je het blurry woord dat je in dit veld ziet typen.',
	'autocreatewiki-info-terms-agree' => 'Door een wiki en een gebruikers account te maken, accepteer je de <a href="http://www.wikia.com/wiki/Terms_of_use">Wikia\'s Terms of Use</a>',
	'autocreatewiki-limit-day' => 'Wikia heeft het maximum aantal wiki creaties van vandaag ($1) overschreden.',
	'autocreatewiki-limit-creation' => 'Je hebt het maximum aantal wiki creaties in 24 uur ($1) overschreden.',
	'autocreatewiki-empty-field' => 'Vul alsjeblieft dit veld in.',
	'autocreatewiki-bad-name' => 'De naam kan geen speciale tekens bevatten (zoals $ of @) en moet bestaan uit één woord, zonder hoofdletters en zonder spaties.',
	'autocreatewiki-invalid-wikiname' => 'De naam kan geen speciale tekens (zoals $ of @) bevatten en kan niet leeg zijn.',
	'autocreatewiki-violate-policy' => 'Deze wiki bevat een naam dat ons beleid voor namen overschrijd.',
	'autocreatewiki-name-taken' => 'Een wiki met deze naam bestaat al. Je bent welkom om ons te helpen bij <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Deze naam is te kort, kies alsjeblieft een naam met tenminste 3 tekens.',
	'autocreatewiki-similar-wikis' => 'Hieronder zijn de wiki\'s die al gecreëerd zijn met dit onderwerp. We raden je aan een van deze te bewerken.',
	'autocreatewiki-invalid-username' => 'Deze gebruikersnaam is ongeldig.',
	'autocreatewiki-busy-username' => 'Deze gebruikersnaam is al in gebruik.',
	'autocreatewiki-blocked-username' => 'Je kan geen account maken.',
	'autocreatewiki-user-notloggedin' => 'Je account was gemaakt maar niet ingelogd!',
	'autocreatewiki-empty-language' => 'Selecteer alsjeblieft de taal van de Wiki.',
	'autocreatewiki-empty-category' => 'Selecteer alsjeblieft een van de categorieën.',
	'autocreatewiki-empty-wikiname' => 'De naam van de Wiki kan niet leeg zijn.',
	'autocreatewiki-empty-username' => 'Gebruikersnaam kan niet leeg zijn.',
	'autocreatewiki-empty-password' => 'Wachtwoord kan niet leeg zijn.',
	'autocreatewiki-empty-retype-password' => 'Herhaling wachtwoord kan niet leeg zijn.',
	'autocreatewiki-set-username' => 'Plaats eerst gebruikersnaam.',
	'autocreatewiki-invalid-category' => 'Ongeldige keuze van categorie. Kies er alsjeblieft een van de dropdown lijst.',
	'autocreatewiki-invalid-language' => 'Ongeldige keuze van taal. Kies er alsjeblieft een van de dropdown lijst.',
	'autocreatewiki-invalid-retype-passwd' => 'Herhaal alsjeblieft hetzelfde wachtwoord als het bovenstaande wachtwoord.',
	'autocreatewiki-invalid-birthday' => 'Ongeldige geboortedatum',
	'autocreatewiki-limit-birthday' => 'Kan geen registratie creëren.',
	'autocreatewiki-log-title' => 'Je wiki wordt gecreëerd.',
	'autocreatewiki-step0' => 'Proces aan het initialiseren ...',
	'autocreatewiki-stepdefault' => 'Proces is aan het werk, wacht alsjeblieft ...',
	'autocreatewiki-errordefault' => 'Proces was niet afgemaakt ...',
	'autocreatewiki-step1' => 'Afbeelding folder aan het creëren.',
	'autocreatewiki-step2' => 'Database aan het creëren ...',
	'autocreatewiki-step3' => 'Standaard informatie in de database aan het plaatsen ...',
	'autocreatewiki-step4' => 'Standaard afbeeldingen en logo aan het kopiëren ...',
	'autocreatewiki-step5' => 'Standaard variabele in de database aan het plaatsen ...',
	'autocreatewiki-step6' => 'Standaard tabellen in de database aan het plaatsen ...',
	'autocreatewiki-step7' => 'Taal starter aan het plaatsen ...',
	'autocreatewiki-step8' => 'Gebruikersgroepen en categorieën aan het plaatsen ...',
	'autocreatewiki-step9' => 'Variabele voor de nieuwe Wiki aan het plaatsen ...',
	'autocreatewiki-step10' => 'Pagina\'s op centrale Wiki aan het plaatsen ...',
	'autocreatewiki-step11' => 'Email aan het verzenden naar gebruiker ...',
	'autocreatewiki-redirect' => 'Bezig met het doorverwijzen naar de nieuwe Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gefeliciteerd!',
	'autocreatewiki-welcometalk-log' => 'geplaatst door bot',
	'autocreatewiki-regex-error-comment' => 'gebruikt in Wiki $1 (volledige tekst: $2)',
	'autocreatewiki-step2-error' => 'Database bestaat al!',
	'autocreatewiki-step3-error' => 'Kan standaard informatie niet in de database plaatsen!',
	'autocreatewiki-step6-error' => 'Kan de standaard tabellen niet in de database plaatsen!',
	'autocreatewiki-step7-error' => 'Kan de starter database voor talen niet kopiëren!',
);


$messages['fr'] = array(
	'createwikipagetitle' => 'Créer un wiki',
	'createwiki' => 'Créer un wiki',
	'autocreatewiki-info-language' => 'Langue du wiki',
	'autocreatewiki-welcomesubject' => '$1 a été créé!',
	'autocreatewiki-welcomebody' => 'Bonjour $2,

Le wiki que vous avez demandé est maintenant disponible <$1>.  Nous espérons que nous vous retrouverons dans les modifications de celui-ci !

Nous avons ajouté quelques informations sur votre page de discussion (<$5>) pour vous aider à commencer. Si vous avez encore des questions, répondez à ce message ou regardez nos pages d\'aide ici : <http://aide.wikia.com>.

Beaucoup de succès dans votre projet,

$3
Wikia Community Team
<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => 'Bonjour $1 -- nous sommes fiers d’héberger votre site \'\'\'$4\'\'\' chez Wikia!

Au début, c\'est toujours un peu difficile - mais n\'ayez crainte : L\'équipe [[w:c:fr:Community Team|de Wikia]] est toujours prête à vous aider !

Si vous ne savez pas à quoi votre wiki doit ressembler - regardez les autres wikis, cela vous donnera peut-être des idées. :)

Nous sommes ici une grande famille et le plus important est que vous vous divertissiez !

S\'il vous faut de l\'aide, vous pouvez consulter un wiki spécialisé avec des sujets sur l\'aide - en français, ici [[w:c:aide|Wikia Aide]] ! Vous pouvez y poser des questions et participer à y élaborer des articles !

Si vous comprenez l\'anglais, vous pouvez également regarder le wiki d\'aide en anglais qui est bien plus avancé : [[w:c:Help|Help Wikia]]

Ou bien, vous pouvez aussi nous écrire par cette page [[Special:Contact]].

Maintenant, tout est (presque) dit - Vous pouvez commencer à contribuer au wiki ! :-)

Nous espérons que votre wiki va bien grandir et vous souhaitons beaucoup de succès.

[[w:User:Zuirdj|Zuirdj]] <staff />',
);


$messages['pl'] = array(
	'createwikipagetitle' => 'Utwórz nową Wikię',
	'createwiki' => 'Utwórz nową Wikię',
	'autocreatewiki-welcomebody' => 'Witaj, $2!

Wikia, którą utworzyłeś, jest aktualnie dostępna jako <$1>. Mamy nadzieję, że dzięki Tobie wkrótce powstanie kolejny dobry projekt.

Umieściliśmy na Twojej stronie dyskusji trochę informacji i porad, aby pomóc Ci wystartować. Jeśli masz jakieś pytania, odpisz na tego emaila lub zajrzyj na nasze strony pomocy na <http://help.wikia.com>.

Życzymy powodzenia przy tworzeniu nowej Wikii.

$3 Wikia Community Team <http://www.wikia.com/wiki/User:$4>',
);


$messages['zh'] = array(
	'createwikipagetitle' => '申请wiki',
	'createwiki' => '申請Wiki',
	'autocreatewiki-info-language' => '的預設語文',
	'autocreatewiki-welcomesubject' => '$1 已建立!',
	'autocreatewiki-welcomebody' => '嗨 $2,

歡迎加入Wikia社群。相信很快能看到你對此站的貢獻。

如果您在使用上有任何問題，可先查閱說明頁面<http://help.wikia.com> (英文)，或是查看中文的[[w:c:zh:Category:中文說明|使用說明]]

祝您使用快

Wikia 社群團隊',
);


$messages['zh-cn'] = array(
	'createwikipagetitle' => '申请wiki',
	'createwiki' => '申请wiki',
);


$messages['zh-hans'] = array(
	'createwikipagetitle' => '申请wiki',
	'createwiki' => '申请wiki',
);


$messages['zh-hant'] = array(
	'createwikipagetitle' => '申請wiki',
	'createwiki' => '申請wiki',
);


$messages['zh-hk'] = array(
	'createwikipagetitle' => '申請wiki',
	'createwiki' => '申請wiki',
);


$messages['zh-sg'] = array(
	'createwikipagetitle' => '申请wiki',
	'createwiki' => '申请wiki',
);


$messages['zh-tw'] = array(
	'createwikipagetitle' => '申請wiki',
	'createwiki' => '申請wiki',
);


$messages['fi'] = array(
	'createwiki' => 'Luo uusi wiki',
);
