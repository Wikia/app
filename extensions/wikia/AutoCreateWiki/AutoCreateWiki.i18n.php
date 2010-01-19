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
	"autocreatewiki-desc" => "Create wiki in WikiFactory by user requests",
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
	"autocreatewiki-category-other" => "Other",	
	"autocreatewiki-set-username" => "Set username first.",
	"autocreatewiki-invalid-category" => "Invalid value of category. Please select proper from dropdown list.",
	"autocreatewiki-invalid-language" => "Invalid value of language. Please select proper from dropdown list.",
	"autocreatewiki-invalid-retype-passwd" => "Please, retype the same password as above",
	"autocreatewiki-invalid-birthday" => "Invalid birth date",
	"autocreatewiki-limit-birthday" => "Unable to create registration.",
// processing
	"autocreatewiki-log-title" => "Your wiki is being created",
	"autocreatewiki-step0" => "Initializing process ...",
	"autocreatewiki-stepdefault" => "Process is running, please wait ...",
	"autocreatewiki-errordefault" => "Process was not finished ...",
	"autocreatewiki-step1" => "Creating images folder ...",
	"autocreatewiki-step2" => "Creating database ...",
	"autocreatewiki-step3" => "Setting default information in database ...",
	"autocreatewiki-step4" => "Copying default images and logo ...",
	"autocreatewiki-step5" => "Setting default variables in database ...",
	"autocreatewiki-step6" => "Setting default tables in database ...",
	"autocreatewiki-step7" => "Setting language starter ...",
	"autocreatewiki-step8" => "Setting user groups and categories ...",
	"autocreatewiki-step9" => "Setting variables for new Wiki ...",
	"autocreatewiki-step10" => "Setting pages on central Wiki ...",
	"autocreatewiki-step11" => "Sending email to user ...",
	"autocreatewiki-redirect" => "Redirecting to new Wiki: $1 ...",
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

// retention emails
	"autocreatewiki-reminder-subject" => "{{SITENAME}}",
	"autocreatewiki-reminder-body" => "
Dear $1:

Congratulations on starting your new wiki, {{SITENAME}}! You can come back and add more to your wiki by visiting $2.

This is a brand-new project, so please write to us if you have any questions!


-- Wikia Community Team",
	"autocreatewiki-reminder-body-HTML" => "
<p>Dear $1:</p>

<p>Congratulations on starting your new wiki, {{SITENAME}}! You can come back and add more to your wiki by visiting
<a href=\"$2\">$2</a>.</p>

<p>This is a brand-new project, so please write to us if you have any questions!</p>

<p>-- Wikia Community Team</p>"
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'autocreatewiki-success-has-been-created' => 'Looks like this is prefixed by a site name or something. Needs to be included as a variable.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'autocreatewiki' => "Skep 'n nuwe Wiki",
	'createwikipagetitle' => "Skep 'n nuwe Wiki",
	'createwiki' => "Skep 'n nuwe Wiki",
	'autocreatewiki-chooseone' => 'Kies een',
	'autocreatewiki-required' => '$1 = word vereis',
	'autocreatewiki-web-address' => 'Webtuiste:',
	'autocreatewiki-category-select' => 'Kies een',
	'autocreatewiki-language-top' => 'Top $1 tale',
	'autocreatewiki-language-all' => 'Alle tale',
	'autocreatewiki-birthdate' => 'Dag van geboorte:',
	'autocreatewiki-blurry-word' => 'Wasige woord:',
	'autocreatewiki-remember' => 'Onthou my',
	'autocreatewiki-create-account' => "Skep 'n rekening",
	'autocreatewiki-done' => 'gedoen',
	'autocreatewiki-error' => 'fout',
	'autocreatewiki-success-get-started' => 'Begin',
	'autocreatewiki-empty-field' => 'Voltooi asseblief hierdie veld.',
	'autocreatewiki-invalid-username' => 'Hierdie gebruikersnaam is ongeldig.',
	'autocreatewiki-busy-username' => 'Hierdie gebruikersnaam is reeds geneem.',
	'autocreatewiki-category-other' => 'Ander',
	'autocreatewiki-invalid-birthday' => 'Ongeldige geboortedatum',
	'autocreatewiki-step2' => 'Besig om databasis te skep...',
	'autocreatewiki-congratulation' => 'Baie geluk!',
	'autocreatewiki-step2-error' => 'Databasis bestaan al!',
	'autocreatewiki-protect-reason' => 'Deel van die amptelike koppelvlak',
	'autocreatewiki-welcomesubject' => '$1 is geskep!',
	'newwikis' => "Nuwe wiki's",
	'newwikisstart' => "Wys wiki's, beginnende by:",
	'autocreatewiki-reminder-subject' => '{{SITENAME}}',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'autocreatewiki' => 'Създаване на ново уики',
	'createwikipagetitle' => 'Заявка за ново уики',
	'createwiki' => 'Създаване на уики',
	'autocreatewiki-birthdate' => 'Дата на раждане:',
	'autocreatewiki-done' => 'готово',
	'autocreatewiki-error' => 'грешка',
	'autocreatewiki-info-category' => 'Това ще помогне на посетителите да открият вашето уики.',
	'autocreatewiki-bad-name' => 'Името не може да съдържа специални символи (като $ или @) и е необходимо да е една дума, изписана с малки букви и без интервали.',
	'autocreatewiki-invalid-username' => 'Това потребителско име е невалидно.',
	'autocreatewiki-busy-username' => 'Избраното потребителско име е вече заето.',
	'autocreatewiki-congratulation' => 'Поздравления!',
	'autocreatewiki-step2-error' => 'Базата данни съществува!',
	'newwikis' => 'Нови уикита',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'autocreatewiki' => 'Krouiñ ur Wiki nevez.',
	'autocreatewiki-desc' => 'Krouiñ ur wiki er WikiFactory dre rekedoù implijerien',
	'createwikipagetitle' => 'Krouiñ ur wiki nevez',
	'createwiki' => 'Krouiñ ur Wiki nevez',
	'autocreatewiki-chooseone' => 'Dibab unan',
	'autocreatewiki-web-address' => "Chomlec'h web :",
	'autocreatewiki-category-select' => 'Diuzañ unan',
	'autocreatewiki-language-top' => 'Ar $1 yezh implijetañ',
	'autocreatewiki-language-all' => 'An holl yezhoù',
	'autocreatewiki-birthdate' => 'Deiziad ganedigezh :',
	'autocreatewiki-done' => 'graet',
	'autocreatewiki-error' => 'fazi',
	'autocreatewiki-haveaccount-question' => 'Hag ur gont Wikia ho peus dija ?',
	'autocreatewiki-success-title' => 'Krouet eo bet ho wiki !',
	'autocreatewiki-success-get-started' => 'Kregiñ',
	'autocreatewiki-empty-field' => 'Mar plij leunit an takad-mañ.',
	'autocreatewiki-name-too-short' => "Re verr eo an anv-mañ, rankout a ra bezañ 3 araouezenn d'an nebeutañ.",
	'autocreatewiki-invalid-username' => "N'eo ket mat an anv-implijer-mañ.",
	'autocreatewiki-blocked-username' => "Ne c'heloc'h ket krouiñ ur gont.",
	'autocreatewiki-empty-category' => 'Mar plij dibabit ur rummad.',
	'autocreatewiki-category-other' => 'All',
	'autocreatewiki-step2' => 'O krouiñ an diaz roadennoù...',
	'autocreatewiki-congratulation' => "Gourc'hemennoù !",
	'autocreatewiki-welcometalk-log' => 'Kemenadenn Degemer',
	'autocreatewiki-step2-error' => 'Bez ez eus eus an diaz roadennoù-se !',
	'autocreatewiki-welcomesubject' => 'Krouet eo bet $1 !',
	'newwikis' => 'Wikioù nevez',
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

/** Spanish (Español)
 * @author Peter17
 */
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
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
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
	'autocreatewiki-limit-creation' => 'Has excedido el número máximo de creación de wikis en 24 horas ($1).',
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
	'autocreatewiki-category-other' => 'Otro',
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
	'autocreatewiki-welcometalk' => "== ¡Bienvenido! ==
Hola \$1. ¡Estamos muy felices de tener a '''\$4''' como parte de la comunidad de Wikia! Además de darte las gracias por unirte a Wikia, nos gustaría darte algunos consejos que pueden ayudarte a iniciar el wiki y hacerlo crecer.

=== '''Los cuatro primeros pasos:''' ===
1. '''Crea tu [[Usuario:\$1|página de usuario]]''': éste es el mejor lugar para presentarte y que los demás puedan conocerte (¡y además practicar la edición wiki!)

2. '''Añade un logo''': aprende a [[w:c:ayuda:Ayuda:Logo|crear un logo]] y luego <span class=\"plainlinks\">[[Especial:SubirArchivo/Wiki.png|haz clic aquí]]</span> para añadirlo al wiki.<div style=\"border: 1px solid black; margin: 0px 0px 5px 10px; padding: 5px; float: right; width: 25%;\"><center>Crea un artículo en este wiki:</center>
   <createbox>
width=30
</createbox></div>
3. '''Crea tus 10 primeros artículos''': usa esta caja ubicada a la derecha para crear diez páginas, comenzando cada una con unos pocos párrafos. Por ejemplo, si estás iniciando un wiki sobre un programa de TV, podrías crear un artículo para cada uno de los personajes principales.

4. '''Edita la Portada''': incluye enlaces internos (<nowiki>[[de esta forma]]</nowiki>) a los diez artículos que recién creaste y realiza cualquier otra modificación que tu portada necesite.

Una vez que hayas realizado estas 4 tareas, habrás creado lo que servirá de gran punto de inicio: tu wiki luce más amigable y está listo para recibir visitantes. Ahora puedes invitar a algunos amigos para que te ayuden a crear las próximas veinte páginas y a expandir las que ya has creado.

¡Sigue así! Mientras más páginas crees y enlaces a otras, más rápido lograrás que quienes busquen por \"\$4\" encuentren tu proyecto en los motores de búsqueda, lean tu contenido y se unan a la edición de artículos.

Si tienes más preguntas, hemos creado un completo conjunto de [[Ayuda:Contenidos|páginas de ayuda]] para que consultes. También puedes enviarnos un correo electrónico a través de nuestro [[Especial:Contact|formulario de contacto]]. No olvides revisar otros wiki de [[w:c:es:Wikia|Wikia]] para que veas más ideas de diseño, organización de páginas y muchos otros detalles. ¡Disfrútalo!

Los mejores deseos, [[User:\$2|\$3]] <staff />",
	'newwikis' => 'Nuevos wikis',
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

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'autocreatewiki' => 'Luo uusi wiki',
	'createwikipagetitle' => 'Luo uusi wiki',
	'createwiki' => 'Luo uusi wiki',
	'autocreatewiki-chooseone' => 'Valitse yksi',
	'autocreatewiki-required' => '$1 = vaadittu',
	'autocreatewiki-language-all' => 'Kaikki kielet',
	'autocreatewiki-remember' => 'Muista minut',
	'autocreatewiki-create-account' => 'Luo tunnus',
	'autocreatewiki-error' => 'virhe',
	'autocreatewiki-category-other' => 'Muu',
	'autocreatewiki-step1' => 'Luodaan kuvahakemisto...',
	'autocreatewiki-step2' => 'Luodaan tietokanta...',
	'autocreatewiki-step3' => 'Asetetaan oletustiedot tietokantaan...',
	'autocreatewiki-step4' => 'Kopioidaan oletuskuvat ja logo...',
	'autocreatewiki-redirect' => 'Ohjataan uuteen wikiin: $1...',
	'autocreatewiki-welcometalk-log' => 'Tervetuloviesti',
	'autocreatewiki-welcomesubject' => '$1 on luotu.',
	'newwikis' => 'Uudet wikit',
);

/** French (Français)
 * @author IAlex
 * @author Jean-Frédéric
 */
$messages['fr'] = array(
	'autocreatewiki' => 'Créer un nouveau Wiki',
	'autocreatewiki-desc' => 'Crée un wiki dans WikiFactory par des requêtes des utilisateurs',
	'createwikipagetitle' => 'Créer un wiki',
	'createwiki' => 'Créer un wiki',
	'autocreatewiki-chooseone' => 'Choisissez-un un',
	'autocreatewiki-required' => '$1 = obligatoire',
	'autocreatewiki-web-address' => 'Adresse Web :',
	'autocreatewiki-category-select' => 'Sélectionnez-en un',
	'autocreatewiki-language-top' => 'Les $1 langues les plus utilisées',
	'autocreatewiki-language-all' => 'Toutes les langues',
	'autocreatewiki-birthdate' => 'Date de naissance :',
	'autocreatewiki-blurry-word' => 'Mot floué :',
	'autocreatewiki-remember' => 'Se rappeler de moi',
	'autocreatewiki-create-account' => 'Créer un compte',
	'autocreatewiki-done' => 'fait',
	'autocreatewiki-error' => 'erreur',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Avez-vous déjà un compte Wikia ?',
	'autocreatewiki-success-title' => 'Votre wiki a bien été créé !',
	'autocreatewiki-success-subtitle' => 'Vous pouvez commencer à travailler sur votre wiki en visitant :',
	'autocreatewiki-success-has-been-created' => 'a bien été créé !',
	'autocreatewiki-success-get-started' => 'Démarrer',
	'autocreatewiki-info-domain' => "Le mieux est d'utiliser un mot qui sera vraisemblablement un mot clé de recherche pour votre sujet.",
	'autocreatewiki-info-topic' => 'Ajoutez une courte description comme « Star Wars » ou « Émission TV ».',
	'autocreatewiki-info-category' => 'Ceci aidera les visiteurs à trouver votre wiki.',
	'autocreatewiki-info-language' => 'Langue du wiki',
	'autocreatewiki-info-email-address' => "Votre adresse de courriel n'est jamais montrée à personne sir Wikia.",
	'autocreatewiki-info-realname' => 'Si vous choisissez de le donner, il sera utilisé pour vous attribuer votre travail.',
	'autocreatewiki-info-birthdate' => "Wikia requiert que les utilisateurs donnent leur réelle date de naissance comme mesure de précaution et comme un moyen de préserver l'intégrité du site tout en étant en accord avec les règles fédérales des États-Unis.",
	'autocreatewiki-info-blurry-word' => 'Pour nous aider à nous protéger contre la création automatisée de compte, veuillez taper le mot floué que vous voyez dans ce champ.',
	'autocreatewiki-info-terms-agree' => 'En créant un wiki et un compte utilisateur, vous acceptez les <a href="http://www.wikia.com/wiki/Terms_of_use">conditions d\'utilisation de Wiki</a>.',
	'autocreatewiki-info-staff-username' => "<b>Staff seulement :</b> l'utilisateur spécifié sera considéré comme le fondateur du wiki.",
	'autocreatewiki-limit-day' => "Wikia a dépassé la limite de création de nouveaux wikis pour aujourd'hui ($1).",
	'autocreatewiki-limit-creation' => 'Vous avez dépassée la limite maximale de création de wiki en 24 heures ($1).',
	'autocreatewiki-empty-field' => 'Complétez ce champ.',
	'autocreatewiki-bad-name' => 'Le nom ne doit pas contenir de caractères spéciaux (comme $ et @) et doit être un simple mot en minuscules sans espaces.',
	'autocreatewiki-invalid-wikiname' => 'Le nom ne doit pas contenir de caractères spéciaux (comme $ et @) et ne peut pas être vide',
	'autocreatewiki-violate-policy' => 'Ce wiki contient un nom qui viole notre politique de nommage',
	'autocreatewiki-name-taken' => 'Un wiki avec le même nom existe déjà. Vous êtes encouragé à le rejoindre sur <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Le nom est trop court, il doit contenir au moins 3 caractères.',
	'autocreatewiki-name-too-long' => 'Le nom est trop long, il doit contenir au plus 50 caractères.',
	'autocreatewiki-similar-wikis' => "Une liste des wikis créés sur le même sujet est affichée ci-dessous. Nous vous suggérons d'aller sur un de ceux-là.",
	'autocreatewiki-invalid-username' => "Le nom d'utilisateur est invalide.",
	'autocreatewiki-busy-username' => "Le nom d'utilisateur est déjà pris.",
	'autocreatewiki-blocked-username' => 'Vous ne pouvez pas créer un compte.',
	'autocreatewiki-user-notloggedin' => "Votre compte a été créé mais vous n'êtes pas connecté !",
	'autocreatewiki-empty-language' => 'Sélectionnez la langue du wiki.',
	'autocreatewiki-empty-category' => 'Sélectionnez une catégorie.',
	'autocreatewiki-empty-wikiname' => 'Le nom du wiki ne peut pas être vide.',
	'autocreatewiki-empty-username' => "Le nom d'utilisateur ne peut pas être vide.",
	'autocreatewiki-empty-password' => 'Le mot de passe ne peut pas être vide.',
	'autocreatewiki-empty-retype-password' => 'Le mot de passe ré-entré ne peut pas être vide.',
	'autocreatewiki-category-other' => 'Autre',
	'autocreatewiki-set-username' => "Définissez le nom d'utilisateur d'abord.",
	'autocreatewiki-invalid-category' => 'Valeur invalide pour la catégorie. Veuillez sélectionner une valeur de la liste.',
	'autocreatewiki-invalid-language' => 'Valeur invalide pour la langue. Veuillez sélectionner une valeur de la liste',
	'autocreatewiki-invalid-retype-passwd' => 'Veuillez retaper le même mot de passe que ci-dessus',
	'autocreatewiki-invalid-birthday' => 'Date de naissance invalide',
	'autocreatewiki-limit-birthday' => "Impossible de créer l'enregistrement.",
	'autocreatewiki-log-title' => 'Votre wiki est en cours de création',
	'autocreatewiki-step0' => 'Initialisation ...',
	'autocreatewiki-stepdefault' => "Le processus est en cours d'exécution, veuillez patienter ...",
	'autocreatewiki-errordefault' => "Le processus ne s'est pas terminé ...",
	'autocreatewiki-step1' => 'Création du dossier des images ...',
	'autocreatewiki-step2' => 'Création de la base de données ...',
	'autocreatewiki-step3' => 'Ajout des informations par défaut dans la base de données ...',
	'autocreatewiki-step4' => 'Copie des images par défaut et du logo ...',
	'autocreatewiki-step5' => 'Ajout des variables par défaut dans la base de données ...',
	'autocreatewiki-step6' => 'Ajout des tables par défaut dans la base de données ...',
	'autocreatewiki-step7' => 'Ajout des bases pour la langue ...',
	'autocreatewiki-step8' => 'Ajout des groupes utilisateurs et catégories ...',
	'autocreatewiki-step9' => 'Ajout des variables du nouveau wiki ...',
	'autocreatewiki-step10' => 'Ajout des pages dans le wiki central ...',
	'autocreatewiki-step11' => "Envoi du courriel à l'utilisateur ...",
	'autocreatewiki-redirect' => 'Redirection vers le nouveau wiki : $1 ...',
	'autocreatewiki-congratulation' => 'Félicitations !',
	'autocreatewiki-welcometalk-log' => 'Message de bienvenue',
	'autocreatewiki-regex-error-comment' => 'utilisé dans le wiki $1 (texte complet : $2)',
	'autocreatewiki-step2-error' => 'La base de données existe !',
	'autocreatewiki-step3-error' => "Impossible d'ajouter les informations par défaut dans la base de données !",
	'autocreatewiki-step6-error' => "Impossible d'ajouter les tables par défaut dans la base de données !",
	'autocreatewiki-step7-error' => 'Impossible de copier la base de données de base pour cette langue !',
	'autocreatewiki-protect-reason' => "Partie de l'interface officielle",
	'autocreatewiki-welcomesubject' => '$1 a été créé!',
	'autocreatewiki-welcomebody' => "Bonjour $2,

Le wiki que vous avez demandé est maintenant disponible <$1>.  Nous espérons que nous vous retrouverons dans les modifications de celui-ci !

Nous avons ajouté quelques informations sur votre page de discussion (<$5>) pour vous aider à commencer. Si vous avez encore des questions, répondez à ce message ou regardez nos pages d'aide ici : <http://aide.wikia.com>.

Beaucoup de succès dans votre projet,

$3
Wikia Community Team
<http://www.wikia.com/wiki/User:$4>",
	'autocreatewiki-welcometalk' => "== Bienvenue ! ==

<div style=\"font-size:120%; line-height:1.2em;\">Bonjour \$1, nous sommes fiers d’héberger votre site '''\$4''' chez Wikia!

Maintenant vous avez un site web qu'il faudra remplir avec des informations, des images et des vidéos. Mais à présent il est juste vide et il vous attend... Cela vous faît-il peur ? Voici quelques conseils pour bien débuter.

* '''Décrivez le sujet''' sur la page d'accueil. Ceci est votre opportunité pour expliquer aux lecteurs vos sujets préférés. Écrivez-en autant que vous voulez ! Votre description peut avoir des liens vers toutes les pages importantes de votre wiki.

* '''Commencez quelques pages''' -- juste quelques phrases peuvent suffire. Ne laissez pas de pages blanches ! Un wiki est fait pour ajouter et modifier le contenu au fil de votre avancement. Vous pouvez aussi ajouter des images et des vidéos, pour compléter les pages et les rendre plus intéressantes.

Et ensuite continuez ! Les gens aiment aller sur des wikis où il y a beaucoup de choses à lire, donc continuez à ajouter du contenu pour attirer les lecteurs et les éditeurs. Il y a beaucoup à faire mais ne vos en faîtes pas -- aujourd'hui est le premier jour, et vous avez beaucoup de temps. Tous les wikis ont bien commencé un jour -- juste un peu de temps pour débuter quelques pages, jusqu'à ce qu'il devienne un grand site

Si vous avez des questions, vous pouvez nous écrire par cette page [[Special:Contact]]. Nous vous souhaitons bien du plaisir ! 

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Nouveaux wikis',
	'newwikisstart' => 'Afficher les wikis depuis :',
	'autocreatewiki-reminder-subject' => '{{SITENAME}}',
	'autocreatewiki-reminder-body' => '
Cher $1 :

Félicitations pour le commencement de votre nouveau wiki, {{SITENAME}} ! Vous pouvez revenir et ajouter plus à votre wiki en visitant $2.

Ceci est un tout nouveau projet, veuillez nous écrire si avec une quelconque question !


-- Team de la communauté Wikia',
	'autocreatewiki-reminder-body-HTML' => '
<p>Cher $1 :</p>

<p>Félicitations pour le commencement de votre nouveau wiki, {{SITENAME}} ! Vous pouvez revenir et ajouter plus à votre wiki en visitant <a href="$2">$2</a>.</p>

<p>Ceci est un tout nouveau projet, veuillez nous écrire si avec une quelconque question !</p>

<p>-- Team de la communauté Wikia</p>',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'autocreatewiki' => 'Új Wiki létrehozása',
	'createwikipagetitle' => 'Új Wiki létrehozása',
	'createwiki' => 'Új Wiki létrehozása',
	'autocreatewiki-required' => '$1 = kötelező',
	'autocreatewiki-language-all' => 'Összes nyelv',
	'autocreatewiki-birthdate' => 'Születési dátum:',
	'autocreatewiki-done' => 'Kész.',
	'autocreatewiki-error' => 'hiba',
	'autocreatewiki-success-get-started' => 'Kezdő lépések',
	'autocreatewiki-category-other' => 'Egyéb',
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

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'autocreatewiki' => '新しいWikiを作成する',
	'autocreatewiki-desc' => '利用者からのリクエストによりWikiFactoryでウィキを作成する',
	'createwikipagetitle' => '新しいウィキのお申し込みはこちら!',
	'createwiki' => '新しいウィキのお申し込みはこちら!',
	'autocreatewiki-chooseone' => '一つを選ぶ',
	'autocreatewiki-required' => '$1 = 必須',
	'autocreatewiki-web-address' => 'サイトのアドレス:',
	'autocreatewiki-category-select' => 'どれか一つを選ぶ',
	'autocreatewiki-language-top' => '上位$1言語',
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
	'autocreatewiki-success-has-been-created' => 'が作成されました！',
	'autocreatewiki-success-get-started' => 'さあ始めましょう',
	'autocreatewiki-info-domain' => 'ウィキが扱う内容を表し、検索キーワードとなるようなものがよいでしょう。',
	'autocreatewiki-info-topic' => '"Star Wars"や"テレビ番組"など、ウィキの主題を簡単に示すような名称にしましょう。',
	'autocreatewiki-info-category' => 'ウィキアの訪問者があなたの作るウィキをみつけやすいようにします。',
	'autocreatewiki-info-language' => 'ここで指定した言語が、ウィキの訪問者に対して標準で表示される言語になります。',
	'autocreatewiki-info-email-address' => 'あなたのメールアドレスがウィキア上で誰かに直接知らされることはありません。',
	'autocreatewiki-info-realname' => '本名を入力すると、ページ・クレジットに利用者名（アカウント名）の代わりに本名が表示されます。',
	'autocreatewiki-info-birthdate' => 'ウィキアでは、アメリカ合衆国の法規定を満たす上で、サイトの品質を維持するための手段及び安全のための予防策としてすべての利用者に対して生年月日の入力を求めています。',
	'autocreatewiki-info-blurry-word' => 'ツールなどによる自動アカウント作成を防ぐため、画像で表示された文字を入力してください。',
	'autocreatewiki-info-terms-agree' => 'ウィキ及びアカウントを作成すると、<a href="http://www.wikia.com/wiki/Terms_of_use">ウィキアの利用規約</a>（<a href="http://ja.wikia.com/wiki/%E5%88%A9%E7%94%A8%E8%A6%8F%E7%B4%84">非公式日本語訳</a>）に同意したことになります。',
	'autocreatewiki-info-staff-username' => '<b>スタッフオンリー:</b> 指定されたユーザーが設立者としてリストされます。',
	'autocreatewiki-limit-day' => '一日にウィキアが作成可能なウィキの最大数を超えています。($1)',
	'autocreatewiki-limit-creation' => '24時間であなたが作成できるウィキの最大数を超えています。($1)',
	'autocreatewiki-empty-field' => 'この項目は空白にはできません。',
	'autocreatewiki-bad-name' => 'URLには$や@などの文字は使えません。また、ローマ字は全てスペースなしの小文字でなければなりません。',
	'autocreatewiki-invalid-wikiname' => '&quot;&lt;&quot;など、一部の文字はウィキ名に使用できません。また、空白にもできません。',
	'autocreatewiki-violate-policy' => 'このウィキ名には、ウィキアの方針上問題のある単語が含まれています。',
	'autocreatewiki-name-taken' => 'この名称のウィキは既にあります。<a href="http://$1.wikia.com">http://$1.wikia.com</a>に是非ご参加ください。',
	'autocreatewiki-name-too-short' => 'アドレスが短すぎます。3文字以上のアドレスを指定してください。',
	'autocreatewiki-name-too-long' => 'アドレスが長すぎます。50文字以下のアドレスを指定してください。',
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
	'autocreatewiki-category-other' => 'その他',
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
	'autocreatewiki-welcomesubject' => '$1 が作成されました！',
	'autocreatewiki-welcomebody' => '$2 さん、

申請ありがとうございます。申請されたウィキアは <$1> で利用可能です。すぐにでも編集を始めてくれるとこちらとしてもうれしく思います。

$2さんの会話ページ <$5> に、利用にあたっての情報などを追加しておきました。また、<http://ja.wikia.com/wiki/Help:%E3%83%88%E3%83%83%E3%83%97%E3%83%9A%E3%83%BC%E3%82%B8> にヘルプも用意されています。何か問題があったときは、フォーラム <http://ja.wikia.com/wiki/Forum:Index> でお尋ねください。また、freenode上のIRCチャンネル #wikia-ja でウィキを問わずコミュニティの方々が議論をしていますので、アドバイスが欲しい場合は遠慮無くログインしてみてください。

それでは、プロジェクトの今後を期待しております。

$3
コミュニティ・チーム
<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => '$1さん、$4の申請ありがとうございます。

ウィキを開始するというのはとても大変ですが、もし、何か困ったことがあったら、是非とも[[w:Community Team|ウィキアのコミュニティチーム]]([[w:c:ja:利用者‐会話:Yukichi|日本人スタッフ]])までどうぞ。利用者向けガイドもいくつかこのウィキにありますので、是非とも御覧ください。サイトデザインやコンテンツの作り方に迷ったら、[[w:c:ja:プロジェクトポータル|ウィキアの他のプロジェクト]]をチェックして見てください。ウィキア全体がその良い参考例になるはずです。
* まずは、良いウィキを作るために[[w:c:ja:Help:ウィキの開始|ウィキを開始するにあたってのアドバイス]]を御覧ください。
* また、それらをまとめた[[w:c:ja:Help:良いウィキを作るコツ|ウィキを作るコツ]]も御覧になってください。
* ウィキ自体が初めてなら、[[w:c:ja:Help:FAQ|FAQ]]もあります。
ウィキア自体のヘルプを[[w:c:ja:Help:トップページ|日本語でまとめています]]ので、詳細な情報はこちらを御覧ください。相談ごとは、[[Special:Contact|連絡用ページ]]からどうぞ。IRCチャンネルの #wikia-ja で、他の利用者とコンタクトすることもできます。是非とも御利用ください。

それでは、今後とも、よろしくお願いします。[[User:$2|$3]]',
	'newwikis' => '新しいウィキ',
	'newwikisstart' => '次の文字列から始まるウィキを表示:',
	'autocreatewiki-reminder-body' => '$1 さん、

新しいウィキの開始おめでとうございます。$1 さんが作成した $2 には、いつでも戻って情報を追加することができます。

このプロジェクトはできたばかりの状態です。もし、何か質問があれば、私たちまでおたずねください。

-- Wikia Community Team',
	'autocreatewiki-reminder-body-HTML' => '<p>$1 さん、</p>
<p>新しいウィキの開始おめでとうございます。$1 さんが作成した $2 には、いつでも戻って情報を追加することができます。</p>
<p>このプロジェクトはできたばかりの状態です。もし、何か質問があれば、私たちまでおたずねください。</p>
<p>-- Wikia Community Team</p>',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'autocreatewiki' => 'Создај ново вики',
	'autocreatewiki-desc' => 'Создавање на вики во ВикиФабрика по барања на корисници',
	'createwikipagetitle' => 'Создај ново вики',
	'createwiki' => 'Создај ново вики',
	'autocreatewiki-chooseone' => 'Изберете',
	'autocreatewiki-required' => '$1 = задолжително',
	'autocreatewiki-web-address' => 'Веб-адреса:',
	'autocreatewiki-category-select' => 'Одберете',
	'autocreatewiki-language-top' => 'Најуспешни $1 јазици',
	'autocreatewiki-language-all' => 'Сите јазици',
	'autocreatewiki-birthdate' => 'Датум на раѓање:',
	'autocreatewiki-blurry-word' => 'Заматен збор:',
	'autocreatewiki-remember' => 'Запомни ме',
	'autocreatewiki-create-account' => 'Создај сметка',
	'autocreatewiki-done' => 'готово',
	'autocreatewiki-error' => 'грешка',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Дали веќе имате сметка на Викија?',
	'autocreatewiki-success-title' => 'Вашето вики е создадено!',
	'autocreatewiki-success-subtitle' => 'Сега можете да почнете да работите на вашето вики со посетување на:',
	'autocreatewiki-success-has-been-created' => 'е создадено!',
	'autocreatewiki-success-get-started' => 'Започнете',
	'autocreatewiki-info-domain' => 'Најдобро е да се користи збор што веројатно би бил клучен збор за пребарување на вашата тема.',
	'autocreatewiki-info-topic' => 'Додајте краток опис, од типот „Војна на ѕвездите“, или „ТВ емисии“.',
	'autocreatewiki-info-category' => 'Ова ќе им помогне на посетителите да го пронајдат вашето вики.',
	'autocreatewiki-info-language' => 'Ова ќе биде автоматски-зададениот јазик за посетителите на вашето вики.',
	'autocreatewiki-info-email-address' => 'Вашата е-поштенска адреса никогаш не се покажува никому на Викија.',
	'autocreatewiki-info-realname' => 'Доколку изберете да го наведете вашето име, истото ќе се користи за оддавање на заслуги за вашата работа.',
	'autocreatewiki-info-birthdate' => 'Викија бара сите корисници да го наведат нивниот датум на раѓање како безбедносна мерка, но и каконачин на зачувување на интегритетот на оваа веб-страница, истовремено придржувајќи се до федералните регулативи.',
	'autocreatewiki-info-blurry-word' => 'За да ни помогнете да се заштитиме од автоматизирано создавање на сметки, внесете го заматениот збор прикажан во ова поле.',
	'autocreatewiki-info-terms-agree' => 'Со тоа што го создавате ова вики и корисничка сметка, вие се согласувате со <a href="http://www.wikia.com/wiki/Terms_of_use">Условите на употреба на Викија</a>',
	'autocreatewiki-info-staff-username' => '<b>Само за персонал:</b> Назначениот корисник ќе биде заведен како основач.',
	'autocreatewiki-limit-day' => 'Викија го надмина максималниот дозволен број на создадени викија за денес ($1).',
	'autocreatewiki-limit-creation' => 'Го надминавте максималниот број на создадени викија во рок од 24 часа ($1).',
	'autocreatewiki-empty-field' => 'Пополнете го ова поле.',
	'autocreatewiki-bad-name' => 'Името не може да содржи специјални знаци (како $ или @) и мора да еден збор составен од мали букви, без празни места помеѓу нив.',
	'autocreatewiki-invalid-wikiname' => 'Името не може да содржи специјални знаци (како $ или @) и не може да стои празно',
	'autocreatewiki-violate-policy' => 'Името на ова вики содржи збор што ги прекршува нашите правила за именување',
	'autocreatewiki-name-taken' => 'Веќе постои вики со тоа име. Добредојдени сте да ни се придружите на <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Името е прекратко. Одберете име со барем 3 знаци.',
	'autocreatewiki-name-too-long' => 'Името е предолго. Одберете име со највеќе 50 знаци.',
	'autocreatewiki-similar-wikis' => 'Подолу се наведени веќе создадените викија на оваа тема. Ви предлагаме да уредувате некое од нив.',
	'autocreatewiki-invalid-username' => 'Ова корисничко име е неважечко.',
	'autocreatewiki-busy-username' => 'Ова корисничко име е веќе зафатено.',
	'autocreatewiki-blocked-username' => 'Не можете да создадете сметка.',
	'autocreatewiki-user-notloggedin' => 'Вашата сметка е создадена, но не сте најавени со неа!',
	'autocreatewiki-empty-language' => 'Одберете јазик за викито.',
	'autocreatewiki-empty-category' => 'Одберете една категорија.',
	'autocreatewiki-empty-wikiname' => 'Името на викито не може да стои празно.',
	'autocreatewiki-empty-username' => 'Корисничкото име не може да стои празно.',
	'autocreatewiki-empty-password' => 'Лозинката не може да стои празна.',
	'autocreatewiki-empty-retype-password' => 'Превнесувањето на лозинката не може да стои празно.',
	'autocreatewiki-category-other' => 'Друго',
	'autocreatewiki-set-username' => 'Најпрвин постави корисничко име.',
	'autocreatewiki-invalid-category' => 'Неважечка вредност на категоријата. Одберете правилна категорија од расклопната листа.',
	'autocreatewiki-invalid-language' => 'Неважечка вредност за јазик. Одберете правилна вредност од расклопната листа.',
	'autocreatewiki-invalid-retype-passwd' => 'Превнесете ја истата лозинка од погоре',
	'autocreatewiki-invalid-birthday' => 'Неважечки датум на раѓање',
	'autocreatewiki-limit-birthday' => 'Не можам да ја создадам регистрацијата.',
	'autocreatewiki-log-title' => 'Вашето вики се создава',
	'autocreatewiki-step0' => 'Иницијализација на процесот...',
	'autocreatewiki-stepdefault' => 'Процесот е во тек. Почекајте...',
	'autocreatewiki-errordefault' => 'Процесот не е довршен ...',
	'autocreatewiki-step1' => 'Ја создавам папката за слики ...',
	'autocreatewiki-step2' => 'Ја создавам базата на податоци ...',
	'autocreatewiki-step3' => 'Поставувам основно-зададени информации во базата на податоци ...',
	'autocreatewiki-step4' => 'Ги копирам основно-зададените слики и лого ...',
	'autocreatewiki-step5' => 'Ги поставувам основно-зададените променливи во базата на податоци ...',
	'autocreatewiki-step6' => 'Ги поставувам основно-зададените табели во базата на податоци ...',
	'autocreatewiki-step7' => 'Го поставувам почетниот утврдувач на јазик ...',
	'autocreatewiki-step8' => 'Поставувам кориснички групи и категории ...',
	'autocreatewiki-step9' => 'Поставувам променливи за новото вики ...',
	'autocreatewiki-step10' => 'Поставувам страници на централното вики ...',
	'autocreatewiki-step11' => 'Испраќам е-пошта до корисникот ...',
	'autocreatewiki-redirect' => 'Пренасочувам кон новото вики: $1 ...',
	'autocreatewiki-congratulation' => 'Честитки!',
	'autocreatewiki-welcometalk-log' => 'Порака за добредојде',
	'autocreatewiki-regex-error-comment' => 'се користи на викито $1 (цел текст: $2)',
	'autocreatewiki-step2-error' => 'Базата на податоци постои!',
	'autocreatewiki-step3-error' => 'Неможам да поставам основно-зададени информации во базата на податоци!',
	'autocreatewiki-step6-error' => 'Не можам да поставам основно-зададени табели во базата на податоци!',
	'autocreatewiki-step7-error' => 'Не можам да ја ископирам почетната база на податоци за јазик!',
	'autocreatewiki-protect-reason' => 'Дел од официјалниот интерфејс',
	'autocreatewiki-welcomesubject' => '$1 е создадено!',
	'autocreatewiki-welcomebody' => 'Здраво, $2,

Викијата која ја побаравте сега е достапна на <$1> Се надеваме дека наскоро ќе почнете да ја уредувате!

Додадовме и некои информации и совети на вашата корисничка страница за разговор (<$5>) за да ви помогнеме да започнете со работа.

Ако имате било какви проблеми, слободно побарајте помош од заедницата на <http://www.wikia.com/wiki/Forum:Help_desk>, или по е-пошта, на адресата community@wikia.com. Можете и да го посетите нашиот ИРЦ-канал #wikia за разговори во живо<http://irc.wikia.com>.

Ако имате било какви прашања и проблеми, можете да ме контактирате директно по е-пошта, или пак на мојата страница за разговор.

Со среќа!

$3

Екипата на Викија-заедницата

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Добредојдовте! ==
<div style=\"font-size:120%; line-height:1.2em;\">Здраво \$1 -- баш ни е драго што го имаме викито '''\$4''' како дел од заедницата на Викија!

Сега имате една цела веб-страница за пополнување со информации, слики и видеоснимки на вашите омилени теми. Но засега има само страници што зјаат во вас празни... Застрашувачки, нели? Еве како можете да започнете.

* '''Напишете вовед за вашата тема''' на насловната страница. Ова е прилика да им објасните на читателите за какво вики се работи и која е темата. Пишувајте колку што сакате! Во писот може да се поврзат сите важни страници на викито.

* '''Започнете некои нови страници''' -- за почеток доволни се реченица-две. Не дозволувајте празнотијата да ве уплаши! Секое вики служи за додавање и менување на разни нешта како што тече времето. Можете да додавате и слики и видеоснимки за да ја пополните страницата и да ја направите поинтересна.

И само терајте! Луѓето многу сакаат да посетуваат викија кајшто има многу што да се прочита и разгледа, па затоа постојано додавајте разни нешта, и така ќе привлечете читатели и уредници. Има многу што да се работи, но не грижете се -- денес ви е прв ден, и имате многу време. Секое вики започнува исто -- малку по малку, почнувајќи со првите неколку страници, па со време нараснува во огромна, посетена и активна веб-страница.

Ако имате било какви прашања, обратете ни се по е-пошта преку вашиот [[Special:Contact|контактен образец]]. Забавувајте се!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Нови викија',
	'newwikisstart' => 'Прикажи викија со почеток во:',
	'autocreatewiki-reminder-body' => 'Почитуван(а) $1:

Ви го честитаме започнувањето на вашето ново вики, {{SITENAME}}! Можете да се навратите и да додавате уште нешта на викито со посета на страницата $2.

Ова е сосем нов проект, и затоа би ве замолиме да ни пишете ако имате било какви прашања!


-- Екипата на Викија-заедницата',
	'autocreatewiki-reminder-body-HTML' => '<p>Почитуван(а) $1:</p>

<p>Ви честитаме на започнувањето на вашето ново вики, {{SITENAME}}! Можете да се навратите и да додавате уште нешта на викито со посета на
<a href="$2">$2</a>.</p>

<p>Ова е сосем нов проект, и затоа би ве замолиле да ни пишете ако имате вило какви прашања!</p>

<p>-- Екипата на Викија-заедницата</p>',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'autocreatewiki' => 'Begin een nieuwe Wiki',
	'autocreatewiki-desc' => 'Wiki aanmaken in WikiFactory door gebruikersverzoeken',
	'createwikipagetitle' => 'Nieuwe wiki aanmaken',
	'createwiki' => 'Nieuwe wiki aanmaken',
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
	'autocreatewiki-success-has-been-created' => 'is aangemaakt!',
	'autocreatewiki-success-get-started' => 'Beginnen',
	'autocreatewiki-info-domain' => 'Het is het beste om een woord te kiezen dat vaak gebruikt zal worden om jouw onderwerp te vinden.',
	'autocreatewiki-info-topic' => 'Voeg een korte beschrijving toe, zoals "Star Wars" of "TV programma".',
	'autocreatewiki-info-category' => 'Dit zal bezoekers helpen je wiki te vinden.',
	'autocreatewiki-info-language' => 'Dit zal de standaard taal worden voor bezoekers aan jouw wiki.',
	'autocreatewiki-info-email-address' => 'Jouw email adres wordt nooit bekend gemaakt aan welk persoon dan ook op Wikia.',
	'autocreatewiki-info-realname' => 'Als je kiest om hem te verstrekken zal hij gebruikt worden om jouw werk aan de wiki toe te kennen.',
	'autocreatewiki-info-birthdate' => 'Wikia vraagt aan alle gebruikers om hun echte geboortedatum op te geven voor veiligheid maar ook om de integriteit van de site aan de federale regels te laten voldoen.',
	'autocreatewiki-info-blurry-word' => 'Om het automatisch creëren van een account tegen te gaan moet je het blurry woord dat je in dit veld ziet typen.',
	'autocreatewiki-info-terms-agree' => 'Door een wiki en een gebruikers account te maken, accepteer je de <a href="http://www.wikia.com/wiki/Terms_of_use">Wikia\'s Terms of Use</a>',
	'autocreatewiki-info-staff-username' => '<b>Alleen voor staf:</b> de aangegeven gebruiker wordt vermeld als de oprichter.',
	'autocreatewiki-limit-day' => 'Wikia heeft het maximum aantal wiki creaties van vandaag ($1) overschreden.',
	'autocreatewiki-limit-creation' => 'Je hebt het maximum aantal wiki creaties in 24 uur ($1) overschreden.',
	'autocreatewiki-empty-field' => 'Vul alsjeblieft dit veld in.',
	'autocreatewiki-bad-name' => 'De naam kan geen speciale tekens bevatten (zoals $ of @) en moet bestaan uit één woord, zonder hoofdletters en zonder spaties.',
	'autocreatewiki-invalid-wikiname' => 'De naam kan geen speciale tekens (zoals $ of @) bevatten en kan niet leeg zijn.',
	'autocreatewiki-violate-policy' => 'Deze wiki bevat een naam dat ons beleid voor namen overschrijd.',
	'autocreatewiki-name-taken' => 'Een wiki met deze naam bestaat al. Je bent welkom om ons te helpen bij <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Deze naam is te kort, kies alsjeblieft een naam met tenminste 3 tekens.',
	'autocreatewiki-name-too-long' => 'Deze naam is te lang.
Kies een naam met hoogstens zestig tekens.',
	'autocreatewiki-similar-wikis' => "Hieronder zijn de wiki's die al gecreëerd zijn met dit onderwerp. We raden je aan een van deze te bewerken.",
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
	'autocreatewiki-category-other' => 'Overige',
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
	'autocreatewiki-step10' => "Pagina's op centrale Wiki aan het plaatsen ...",
	'autocreatewiki-step11' => 'Email aan het verzenden naar gebruiker ...',
	'autocreatewiki-redirect' => 'Bezig met het doorverwijzen naar de nieuwe Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gefeliciteerd!',
	'autocreatewiki-welcometalk-log' => 'geplaatst door bot',
	'autocreatewiki-regex-error-comment' => 'gebruikt in Wiki $1 (volledige tekst: $2)',
	'autocreatewiki-step2-error' => 'Database bestaat al!',
	'autocreatewiki-step3-error' => 'Kan standaard informatie niet in de database plaatsen!',
	'autocreatewiki-step6-error' => 'Kan de standaard tabellen niet in de database plaatsen!',
	'autocreatewiki-step7-error' => 'Kan de starter database voor talen niet kopiëren!',
	'autocreatewiki-protect-reason' => 'Onderdeel van de officiële interface',
	'autocreatewiki-welcomesubject' => '$1 is aangemaakt!',
	'autocreatewiki-welcomebody' => 'Hallo $2!

De Wikia die u hebt aangevraagd is nu beschikbaar op de volgende URL: <$1>. We hopen dat u daar snel gaat bewerken!

We hebben informatie en tips op uw overlegpagina toegevoegd (<$5>) om u op weg te helpen.

Als u problemen ondervindt kunt u de gemeenschap om hulp vragen op de wiki (<http://www.wikia.com/wiki/Forum:Help_desk>), of via een e-mail naar community@wikia.com. U kunt ook ons live IRC-chatkanaal bezoeken via <http://irc.wikia.com>.

U kunt ook direct contact met mij opnemen per e-mail of op mijn overlegpagina bij vragen of zorgen.

Succes met uw project!

$3

Wikia Gemeenschapsteam

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Welkom! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hallo \$1 -- we zijn erg blij dat '''\$4''' onderdeel is geworden van de Wikia-gemeenschap!

U hebt nu een hele website tot uw beschikking hebt die u met informatie, afbeeldingen en video over uw favoriete onderwerp kunt gaan vullen. Maar nu staart een lege pagina u aan. Spannend, toch? Hier volgen wat tips om u op weg te helpen.

* '''Leid uw onderwerp in''' op de hoofdpagina. Dit is uw gelegenheid om uw lezers aan te geven wat uw onderwerp van belang maakt. Schrijf zoveel u wilt. In uw beschrijving kunt u naar alle belangrijke pagina's op uw site verwijzen.

* '''Maak nieuwe pagina's aan''' -- soms zijn een paar zinnen al voldoende als beginnetje. Laat het geen lege pagina's zijn! Een belangrijke werkwijze in een wiki is toevoegen en later verbeteren en verfijnen. U kunt ook afbeeldingen en video toevoegen om de pagina te vullen en deze interessanter en spannender te maken.

En daarna vooral volhouden! De wiki's waar veel te lezen en te zien is zijn het meest aantrekkelijk, dus blijf vooral informatie toevoegen zodat u meer lezers krijgt en daardoor nieuwe gebruikers die ook bijdragen. Er is veel te doen, maar maak u geen zorgen. Vandaag is uw eerste dag en er is voldoende tijd. Iedere wiki start op dezelfde manier. Beetje voor beetje, de eerste pagina's eerst, om zich in de tijd mogelijk tot een grote, drukke website te ontwikkelen.

Als u vragen hebt, e-mail ons dan via het [[Special:Contact|contactformulier]]. Veel plezier!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => "Nieuwe wiki's",
	'newwikisstart' => "Wiki's weergeven vanaf:",
	'autocreatewiki-reminder-body' => 'Beste $1.

Van harte gefeliciteerd met het starten van uw nieuwe wiki {{SITENAME}}! Kom vooral vaak terug om meer inhoud aan uw wiki toe te voegen op $2.

Dit is een volledig nieuw project, dus laat het ons weten als u met vragen zit.

-- Wikia gemeenschapsteam',
	'autocreatewiki-reminder-body-HTML' => '<p>Beste $1.</p>

<p>Van harte gefeliciteerd met het starten van uw nieuwe wiki {{SITENAME}}! Kom vooral vaak terug om meer inhoud aan uw wiki toe te voegen op <a href="$2">$2</a>.</p>

<p>Dit is een volledig nieuw project, dus laat het ons weten als u met vragen zit.</p>

<p>-- Wikia gemeenschapsteam</p>',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'newwikis' => 'Nye wikier',
	'newwikisstart' => 'Vis wikier fra og med:',
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

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'autocreatewiki' => 'Crea na neuva Wiki',
	'autocreatewiki-desc' => 'Crea wiki an WikiFactory për arcesta utent',
	'createwikipagetitle' => 'Crea na neuva Wiki',
	'createwiki' => 'Crea na neuva Wiki',
	'autocreatewiki-chooseone' => 'Sern-ne un-a',
	'autocreatewiki-required' => '$1 = ciamà',
	'autocreatewiki-web-address' => 'Adrëssa Web',
	'autocreatewiki-category-select' => 'Sern-ne un-a',
	'autocreatewiki-language-top' => 'Prime $1 lenghe',
	'autocreatewiki-language-all' => 'Tute lenghe',
	'autocreatewiki-birthdate' => 'Data nàssita:',
	'autocreatewiki-blurry-word' => 'Paròla confundùa:',
	'autocreatewiki-remember' => 'Arcòrdme',
	'autocreatewiki-create-account' => 'Crea un Cont',
	'autocreatewiki-done' => 'fàit',
	'autocreatewiki-error' => 'eror',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => "It l'has-to già un cont Wikia?",
	'autocreatewiki-success-title' => "Toa wiki a l'é stàita creà!",
	'autocreatewiki-success-subtitle' => 'It peule adess ancaminé a travajé dzora a toa wiki an visitand:',
	'autocreatewiki-success-has-been-created' => "a l'é stàita creà!",
	'autocreatewiki-success-get-started' => 'Ancamin-a',
	'autocreatewiki-info-domain' => "A l'é mej dovré na paròla ch'a peussa esse na ciav d'arserca për tò argoment.",
	'autocreatewiki-info-topic' => 'Gionta na descrission curta com "Guère Stelar" o "Show TV".',
	'autocreatewiki-info-category' => 'Sòn sì a giuterà ij visitador a trové toa wiki.',
	'autocreatewiki-info-language' => 'Sto sì a sarà la lenga ëd default për ij visitador ëd toa wiki.',
	'autocreatewiki-info-email-address' => "Toa adrëssa email a l'é mai mostà a mincadun an Wikia.",
	'autocreatewiki-info-realname' => "S'it serne ëd delo, sòn sì a sarà dovrà për dé toe atribussion për tò travaj.",
	'autocreatewiki-info-birthdate' => "Wikia a ciama a tùit j'utent ëd dé la soa vera data ëd nàssita sia për precaussion ëd sicurëssa sia com mojen ëd pr4eservé l'antegrità dël sit ant ël rispet dij regolament federaj.",
	'autocreatewiki-info-blurry-word' => "Për giuté a protege contra la creassion ëd cont automàtica, për piasì ansëriss la paròla confondùa ch'it vëdde an sto camp-sì.",
	'autocreatewiki-info-terms-agree' => 'An creand na wiki e un cont utent, it ses d\'acòrdi con ij <a href="http://www.wikia.com/wiki/Terms_of_use">Terme d\'usagi ëd Wikia</a>',
	'autocreatewiki-info-staff-username' => "<b>Mach Echip:</b> L'utent specificà a sarà lista com fondator.",
	'autocreatewiki-limit-day' => "Wikia a l'ha passà ël màssim nùmer ëd creassion ëd wiki ancheuj ($1).",
	'autocreatewiki-limit-creation' => "It l'has passà ël màssim nùmer ëd creassion ëd wiki an 24 ore ($1).",
	'autocreatewiki-empty-field' => 'Për piasì completa sto camp-sì.',
	'autocreatewiki-bad-name' => 'Ël nòm a peul pa conten-e caràter speciaj (com $ o @) e a deuv esse na sola paròla minùscola sensa spassi.',
	'autocreatewiki-invalid-wikiname' => 'Ël nòm a peul pa conten-e caràter speciaj (com $ e @) e a peul pa esse veuid',
	'autocreatewiki-violate-policy' => "Sto nòm ëd wiki-sì a conten na paròla ch'a rispeta pa nòsta polìtica dij nom",
	'autocreatewiki-name-taken' => 'Na wiki con sto nòm-sì a esist già. It ses bin ëvnù a unite a noi su <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => "Sto nòm a l'é tròp curt, për piasì sern un nòm con almanch 3 caràter.",
	'autocreatewiki-name-too-long' => "Sto nòm a l'é tròp longh, për piasì sern un nòm con al pi 50 caràter.",
	'autocreatewiki-similar-wikis' => "Sota a-i son le wiki già creà su sto argoment-sì. Nòst sugeriment a l'é ëd modifichene un-a ëd cole.",
	'autocreatewiki-invalid-username' => "Sto nòm utent a l'é pa bon.",
	'autocreatewiki-busy-username' => "Sto nòm utent a l'é già pijà.",
	'autocreatewiki-blocked-username' => 'It peule pa creé ëd cont.',
	'autocreatewiki-user-notloggedin' => "Tò cont a l'é stàit creà ma it ses pa intrà!",
	'autocreatewiki-empty-language' => 'Për piasì, selession-a lenga ëd Wiki.',
	'autocreatewiki-empty-category' => 'Për piasì, selession-a na categorìa.',
	'autocreatewiki-empty-wikiname' => 'Ël nòm ëd Wiki a peul pa esse veuid.',
	'autocreatewiki-empty-username' => 'Nòm utent a peul pa esse veuid.',
	'autocreatewiki-empty-password' => 'Ciav a peul pa esse veuida.',
	'autocreatewiki-empty-retype-password' => 'Torna scrive ciav a peul pa esse veuida.',
	'autocreatewiki-category-other' => 'Àutr',
	'autocreatewiki-set-username' => 'Ampòsta nòm utent prima.',
	'autocreatewiki-invalid-category' => 'Valor ëd categorìa pa bon. Për piasì selession-a col giust da la lista a tendin-a.',
	'autocreatewiki-invalid-language' => 'Valor ëd lenga pa bon. Për piasì selession-a col bon da la lista a tendin-a.',
	'autocreatewiki-invalid-retype-passwd' => 'Për piasì, torna scrive la midema ciav com dzora',
	'autocreatewiki-invalid-birthday' => 'Data nàssita pa bon-a',
	'autocreatewiki-limit-birthday' => 'As peul pa cresse registrassion',
	'autocreatewiki-log-title' => "Toa wiki a l'é an creassion",
	'autocreatewiki-step0' => 'Process an camin ...',
	'autocreatewiki-stepdefault' => 'Process a gira, për piasì speta ...',
	'autocreatewiki-errordefault' => "Process a l'é pa finì ...",
	'autocreatewiki-step1' => 'Creé cartela dle figure ...',
	'autocreatewiki-step2' => 'Creé database ...',
	'autocreatewiki-step3' => 'Amposté anformassion ëd default ant ël database ...',
	'autocreatewiki-step4' => 'Copié figure ëd default e logo ...',
	'autocreatewiki-step5' => 'Amposté variàbij ëd default ant ël database ...',
	'autocreatewiki-step6' => 'Amposté tàule ëd default ant ël database ...',
	'autocreatewiki-step7' => 'Amposté lenga inissial ...',
	'autocreatewiki-step8' => 'Amposté partìe utent e categorìe ...',
	'autocreatewiki-step9' => 'Amposté variàbij për neuva Wiki ...',
	'autocreatewiki-step10' => 'Amposté pàgine su Wiki sentral ...',
	'autocreatewiki-step11' => 'Mandé email a utent ...',
	'autocreatewiki-redirect' => 'rediressioné a neuva Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Congratulassion!',
	'autocreatewiki-welcometalk-log' => 'Mëssagi ëd Bin ëvnù',
	'autocreatewiki-regex-error-comment' => 'dovrà an Wiki $1 (test anter: $2)',
	'autocreatewiki-step2-error' => 'Database a esist!',
	'autocreatewiki-step3-error' => 'A peul pa amposté anformassion ëd default ant ël database!',
	'autocreatewiki-step6-error' => 'A peul pa amposté tàule ëd default ant ël database!',
	'autocreatewiki-step7-error' => 'A peul pa copié database inissial për la lenga!',
	'autocreatewiki-protect-reason' => "Part ëd l'antërfacia ufissial",
	'autocreatewiki-welcomesubject' => "$1 a l'é stàit creà!",
	'autocreatewiki-welcomebody' => "Cerea, $2,

la Wikia ch'it l'has ciamà a l'é adess disponibla a <$1> Noi i speroma ëd vëdde là prest toe modìfiche!

Noi i l'oma giontà cheich Anformassion e Tip dzora a toa Pàgina Utent ëd Discussion (<$5>) për giutete a ancaminé.

S'it l'has minca problem, it peule ciamé agiut a la comunità dzora la wiki a <http://www.wikia.com/wiki/Forum:Help_desk>, o via email a community@wikia.com. It peule ëdcò visité nòsta viva #wikia IRC chat channel <http://irc.wikia.com>.

Mi i peusso esse contatà diretament për email o dzora a mia pàgina ëd discussion, s'it l'has minca custion o dùbit.

Bon-a fortun-a con ël proget!

$3

Echip ëd la Comunità Wikia

<http://www.wikia.com/wiki/User:$4>",
	'autocreatewiki-welcometalk' => "== Bin ëvnù! ==
<div style=\"font-size:120%; line-height:1.2em;\">Cerea \$1 -- noi soma content d'avèj '''\$4''' com part ëd la comunità Wikia!

Adess it l'has n'anter sit da vempe con anformassion, figure e video dzora ai tò argoment favorì. Ma pròpi adess, a-i é mach ëd pagine bianche dëdnans a ti ... Brut, giust? Ambelessì a-i son cheich manere d'ancaminé.

* '''Antroduv tò argoment''' ant la prima pàgina. Sta sì a l'é toa oportunità dë spieghé ai tò letor lòn che tò argoment a l'é. Scriv vàire ch'it veule! Toa descrission a peul coleghesse a tute le pàgine amportante an dzora a tò sit.

* '''Ancamin-a cheich neuve pàgine''' -- mach na fras o doe a l'é giust për ancaminé. Fissa pa le pàgine bianche ! na wiki a l'é mach gionté e cangé còse man a man. It peule ëdcò gionté figure e video, për vempe le pàgine e feje pi antëressante.

E peui mantenla! A le përson-e a-i pias visité le wiki quand ch'a-i é motobin ëd ròba da lese e vardé, parèj continua a gionté ròba, e it tirerai letor e editor. A-i é motobin da fé, ma sagrinte pa -- ancheuj a l'é tò prim di, e a-i é motobin ëd temp. Minca wiki a part a l amidema manera -- un tòch për vòta, ancaminand con le prime pòche pàgine, fin a chërse an un sit gròss, pien.

S'it l'has ëd custion, it peule mandeje për email a nòsta [[Special:Contact|forma ëd contat]]. Bon-a fortun-a!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'neuve wiki',
	'newwikisstart' => 'Visualisa Wiki partend da:',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'autocreatewiki' => 'Crie uma nova Wiki',
	'createwikipagetitle' => 'Crie uma nova Wiki',
	'createwiki' => 'Crie uma nova Wiki',
	'autocreatewiki-required' => '$1 = campos obrigatórios',
	'autocreatewiki-web-address' => 'Endereço:',
	'autocreatewiki-category-select' => 'Escolha uma',
	'autocreatewiki-language-top' => 'Os $1 idiomas mais usados',
	'autocreatewiki-language-all' => 'Todos os idiomas',
	'autocreatewiki-birthdate' => 'Data de nascimento:',
	'autocreatewiki-blurry-word' => 'Palavra borrada:',
	'autocreatewiki-remember' => 'Me lembre',
	'autocreatewiki-create-account' => 'Crie uma conta',
	'autocreatewiki-haveaccount-question' => 'Você já tem uma conta Wikia?',
	'autocreatewiki-success-title' => 'Sua wiki foi criada!',
	'autocreatewiki-success-subtitle' => 'Você pode agora começar a trabalhar na sua wiki visitando:',
	'autocreatewiki-success-has-been-created' => 'foi criado!',
	'autocreatewiki-info-domain' => 'É melhor usar uma palavra com a qual as pessoas irão encontrar seu tópico através de buscas.',
	'autocreatewiki-info-topic' => 'Coloque uma descrição curta como "Star Wars" ou "Programas de TV".',
	'autocreatewiki-info-category' => 'Isso irá ajudar os visitantes a encontrar a sua wiki.',
	'autocreatewiki-info-language' => 'Esse irá ser o idioma padrão para os visitantes da sua wiki.',
	'autocreatewiki-info-email-address' => 'Seu e-mail nunca é mostrado para ninguém no Wikia.',
	'autocreatewiki-info-realname' => 'Se você optar por preencher este valor, ele vai ser usado para lhe dar uma atribuição pelo seu trabalho.',
	'autocreatewiki-info-birthdate' => 'O Wikia exige que todos os usuários providam suas verdadeiras datas de nascimento como uma medida de segurança e para preservar a integridade do site, mantendo a conformidade com os regulamentos federais.',
	'autocreatewiki-info-blurry-word' => 'Para ajudar a proteger o site contra a criação automática de contas, por favor digite a palavra borrada que você vê dentro deste campo.',
	'autocreatewiki-info-terms-agree' => 'Ao criar uma wiki e uma conta de usuário, você está concordando com os <a href="http://www.wikia.com/wiki/Terms_of_use">Termos de Uso do Wikia</a>',
	'autocreatewiki-limit-day' => 'O Wikia excedeu o número máximo de criação de wiki hoje ($1).',
	'autocreatewiki-limit-creation' => 'Você excedeu o máximo número de criação de wikis em 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, preencha esse campo.',
	'autocreatewiki-bad-name' => 'O nome não pode conter caracteres especiais (como $ ou @) nem espaços e precisa estar todo em minúsculo.',
	'autocreatewiki-invalid-wikiname' => 'O nome não pode conter caracteres especiais (como $ ou @) e não pode estar vazio.',
	'autocreatewiki-violate-policy' => 'Esse nome de wiki contém uma palavra que viola as nossas políticas de nomeação.',
	'autocreatewiki-name-too-short' => 'Esse nome é muito curto, por favor escolha um nome com no mímino 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Esse nome é muito longo, por favor escolha um nome com no máximo 50 caracteres.',
	'autocreatewiki-invalid-username' => 'Esse nome de usuário é inválido.',
	'autocreatewiki-busy-username' => 'Esse nome de usuário já é usado.',
	'autocreatewiki-blocked-username' => 'Você não pode criar uma conta.',
	'autocreatewiki-user-notloggedin' => 'Sua conta foi criada, mas você não está logado.',
	'autocreatewiki-empty-language' => 'Por favor, selecione o idioma da Wiki.',
	'autocreatewiki-empty-category' => 'Por favor, selecione uma categoria.',
	'autocreatewiki-empty-wikiname' => 'O nome da Wiki não pode estar vazio.',
	'autocreatewiki-empty-username' => 'O nome de usuário não pode estar vazio.',
	'autocreatewiki-empty-password' => 'A senha não pode estar vazia.',
	'autocreatewiki-empty-retype-password' => '"Redigite sua senha" não pode estar vazio.',
	'autocreatewiki-invalid-birthday' => 'Data de nascimento inválida',
	'autocreatewiki-log-title' => 'A sua wiki está sendo criada',
	'autocreatewiki-stepdefault' => 'O processo está sendo feito, por favor aguarde...',
	'autocreatewiki-errordefault' => 'O processo não foi finalizado...',
	'autocreatewiki-welcomebody' => 'Olá, $2,

O Wikia que você requisitou está agora disponível em <$1>. Nós esperamos vê-lo editando lá em breve!

Nós adicionamos algumas informações e dicas na sua página de discussão de usuário <$5> pra ajudar-lhe a começar.

Se você tiver algum problema, você pode pedir a ajuda da comunidade na wiki em <http://www.wikia.com/wiki/Forum:Help_desk> ou via email para community@wikia.com . Você também pode visitar nosso canal de chat IRC #wikia IRC <http://irc.wikia.com>.

Eu posso ser contatado diretamente por email ou na minha página de discussão, caso você tenha alguma pergunta ou preocupação.

Boa sorte com o projeto!

$3

Equipe da comunidade do Wikia (Wikia Community Team)

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Boas-vindas! ==
<div style=\"font-size:120%; line-height:1.2em;\">Olá \$1 -- nós estamos felizes por ter '''\$4''' como parte da comunidade do Wikia!

Agora você tem um website inteiro para encher de informações, figuras e vídeos sobre os seus tópicos favoritos. Mas, agora mesmo, há apenas páginas vazias olhando para você... Assustador, certo? Aqui estão algumas formas de começar.

* '''Introduza seu tópico''' na página principal. Essa é sua oportunidade de explicar aos seus leitores sobre o que seu tópico trata. Escreva o quanto quiser! Sua descrição pode conter links para todas as páginas importantes do seu site.

* '''Inicie algumas páginas novas''' -- apenas uma frase ou duas já esta bom para começar. Não deixe as páginas em branco desanimarem você! Um wiki é exatamente acrescentar, adicionar e mudar enquanto você está criando. Você também pode carregar imagens e vídeos para dar conteúdo à página e deixá-la mais interessante.

Então, apenas continue editando! As pessoas gostam de visitar wikis quando há muitas informações e coisa para serem lidas e vistas, então continue adicionando coisas e aumentando sua wiki e você irá atrair leitores e editores. Há muita coisa a ser feita, mas não se preocupe, hoje é apenas o seu primeiro dia e você ainda tem tempo de sobra. Toda wiki começa do mesmo jeito, com um pouco de cada vez, começando com poucas páginas até crescer e se transformar num enorme e ocupado site.

Se você tiver alguma dúvida, você pode nos contatar através do nosso [[Special:Contact|formulário de contato]]. Divirta-se!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Novas wikis',
	'newwikisstart' => 'Mostrar Wikis começando com:',
	'autocreatewiki-reminder-body' => '
Caro(a) $1:

Parabéns por começar a seu nova wiki, {{SITENAME}}! Você pode voltar e adicionar mais informações a sua wiki visitando $2.

Esse é um projeto novo, então, por favor, nos escreva caso você tenha alguma dúvida!


-- Equipe da comunidade do Wikia (Wikia Community Team)',
	'autocreatewiki-reminder-body-HTML' => '<p>Caro(a) $1:</p>

<p>Parabéns por começar a seu nova wiki, {{SITENAME}}! Você pode voltar e adicionar mais informações a sua wiki visitando
<a href="$2">$2</a>.</p>

<p>Este é um projeto novo, então, por favor, nos escreva se você tiver alguma dúvida!</p>

<p>-- Equipe da comunidade do Wikia (Wikia Community Team)</p>',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'autocreatewiki-done' => 'fatte',
	'autocreatewiki-error' => 'errore',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
);

/** Russian (Русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'autocreatewiki-required' => '$1 = обязательно',
	'autocreatewiki-web-address' => 'Веб-адрес:',
	'autocreatewiki-language-all' => 'Все языки',
	'autocreatewiki-birthdate' => 'Дата рождения:',
	'autocreatewiki-remember' => 'Запомнить меня',
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

