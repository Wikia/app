<?php

$messages = array();

$messages['en'] = array(
	'autocreatewiki-welcomebody-HTML' => '<p>Hello $2,<br /><br />
The wiki you created is now available at <a href="$1">$1</a>.  We hope to see you editing there soon!<br /><br />
We have added some information and tips on your <a href="$5">user talk Page</a> to help you get started. If you have any questions, just reply to this e-mail or browse our help pages at <a href="http://help.wikia.com/">Fandom Help</a>.<br /><br />
Good luck with the project,<br /><br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Fandom Community Team<br /></p>',
	'confirmemail_body-HTML' => '<p>Hello $2,<br /><br />
Thank you for registering with Wikia.<br /><br />
Please activate your new account by <a href="$3">confirming your e-mail address here</a>.<br /><br /><br />
We look forward to seeing you soon!<br /><br />
The Wikia Community Team<br />
<a href="http://community.wikia.com/">community.wikia.com</a><br /></p>',
	'confirmemailreminder_body-HTML' => '<p>Hello $1,<br /><br />
Last week you joined Wikia, but you still need to confirm your account. Please do so by clicking <a href="$2">here</a>.<br /><br />
We look forward to seeing you soon!<br /><br />
The Wikia Community Team<br />
<a href="http://www.wikia.com/">www.wikia.com</a></p>',
	'createaccount-text-HTML' => '<p>Someone created an account for your e-mail address on {{SITENAME}} ($4) named "$2", with password "$3".<br />
You should log in and change your password now.<br /><br />
You may ignore this message if this account was created in error.</p>',
	'enotif_body-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
There has been an edit to a page you are watching on {{SITENAME}}.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$NEWPAGEHTML<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Check out the latest Fandom articles</a></li>
<li>Want to control which e-mails you receive? Go to <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_article_comment-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
An article you following, $PAGETITLE, has new comments.<br /><br />
To see the comment thread, follow the link below: <a href="$PAGETITLE_URL#article-comments">$PAGETITLE</a> <br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">{{ns:special}}:Preferences<a>.</li>
</ul></p>',
	'enotif_body_blogs_comment-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
$PAGEEDITOR made a comment on the blog post "$BLOGTITLE".<br /><br />
<a href="$PAGETITLE_URL#comments">View the comments</a><br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Check out our featured wikis!</a></li>
<li>Want to control which e-mails you receive? Go to <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_delete-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A page you are watching on {{SITENAME}} has been deleted.<br /><br />
The page was at <a href="$PAGETITLE_URL">$PAGETITLE</a> <br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out the latest Fandom articles! <a href="http://fandom.wikia.com/">View Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}"> User Preferences</a></li>
</ul></p>',
	'enotif_body_move-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A page you are watching on {{SITENAME}} has been moved.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out the latest Fandom articles! <a href="http://fandom.wikia.com/">View Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_prl_chn-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A problem has been updated for a page you are watching on {{SITENAME}}.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the page.<br /><br />
For a list of recent problem reports, see <a href="{{fullurl:{{ns:special}}:ProblemReports}}">{{ns:special}}:ProblemReports</a><br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out the latest Fandom articles! <a href="http://fandom.wikia.com/">View Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_prl_rep-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A problem has been reported for a page you are watching on {{SITENAME}}.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the page.<br /><br />
For a list of recent problem reports, see <a href="{{fullurl:{{ns:special}}:ProblemReports}}">{{ns:special}}:ProblemReports</a><br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out the latest Fandom articles! <a href="http://fandom.wikia.com/">View Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_protect-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A page you are watching on {{SITENAME}} has been protected.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out the latest Fandom articles! <a href="http://fandom.wikia.com/">View Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_restore-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A page you are watching on {{SITENAME}} has been restored from deletion.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out the latest Fandom articles! <a href="http://fandom.wikia.com/">View Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}"> User Preferences</a></li>
</ul></p>',
	'enotif_body_rights-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
User rights on {{SITENAME}} have been changed for a person whose user page you are watching. You can see their user page here: <a href="$PAGETITLE_URL">$PAGETITLE</a><br /><br />
$PAGESUMMARY<br /><br />
<a href="{{fullurl:{{ns:special}}:Log/rights}}">Click here</a> for a log of all recent rights changes.<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out our featured wikis! <a href="http://www.wikia.com">Visit Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_unprotect-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A page you are watching on {{SITENAME}} has been unprotected.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out the latest Fandom articles! <a href="http://fandom.wikia.com/">View Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_upload-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A file you are watching on {{SITENAME}} has been uploaded.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Have you checked out our hubs? <a href="http://www.wikia.com/wiki/Category:Hubs">Visit Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">{{fullurl:{{ns:special}}:Preferences}}<a>.</li>
</ul></p>',
	'enotif_lastvisited-HTML' => 'To see all changes to this page since your last visit, <a href="$1">click here</a>',
	'founderemails-email-page-edited-body-HTML' => '<strong>Hey $1,</strong><br /><br />
It looks like $2 has edited your wiki! Why don\'t you drop by their <a href="$3">userpage</a> to say hello?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'founderemails-email-user-registered-body-HTML' => '<strong>Hey $1,</strong><br /><br />
It looks like $2 has registered on your wiki! Why don\'t you drop by their <a href="$3">userpage</a> to say hello?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia Team</div>',
	'flobalwatchlist-digest-email-body-HTML' => '<p>Dear $1,<br /><br />
This is a list of pages on your Wikia watchlist that have been edited since you last visited them.<br /><br />
$2<br /><br />
This is a list of blog pages on your Wikia watchlist that have been edited or commented since you last visited them.<br /><br />
$3<br /><br />
Please visit and edit often...<br /><br />
Wikia<br /><hr />
<ul>
<li>To change your preferences for watchlist notifications, please visit <a href="http://community.wikia.com/wiki/Special:Preferences">Your Preferences</a></li>
<li>To mark all pages from this Weekly Digest as visited, see the option in the "Watchlist" tab of your Preferences page</li>
</ul></p>',
	'passwordremindertext-HTML' => '<p>Hi,<br /><br />
The login password for user "$2" is now "$3".<br /><br />
If you did not request a new password, don’t worry. The replacement password has been sent only to you at this e-mail address. Your account is secure and you can continue to use your old password.<br /><br />
Thanks,<br /><br />
The Fandom Community Team<br /><br />
www.wikia.com<br /><hr />
<ul>
<li>To change your preferences or password, go to: <a href="http://community.wikia.com/wiki/Special:Preferences">User Preferences</a>.</li>
<li>This password reminder was requested from the following address: $1.</li>
</ul></p>',
);

$messages['nl-informal'] = array(
	'autocreatewiki-welcomebody-html' => 'Hallo $2,


De Wikia die je gemaakt hebt is nu beschikbaar op <a href="$1">$1</a>. We hopen je daar snel te zien bewerken!


We hebben wat informatie en tips toegevoegd op <a href="$5">je overleg pagina</a> om je op gang te helpen komen. Als je enige vragen hebt, reageer dan op deze e-mail of bekijk onze hulp pagina\'s op <a href="http://hulp.wikia.com/">Wikia Hulp</a>.
Veel succes met je project,


<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Wikia Community Team',
	'confirmemail_body-html' => 'Hallo $2,

Bedankt voor het registreren bij Wikia.


Activeer a.u.b. je nieuwe account door <a href="$3">je email adres te bevestigen.</a>


We kijken er naar uit om je binnenkort te zien!

Het Wikia Community Team<br />
<a href="http://community.wikia.com/">http://community.wikia.com/</a>',
	'createaccount-text-html' => 'Iemand maakte een account met jouw e-mail adres op {{SITENAME}} ($4) genaamd "$2", met het wachtwoord "$3". <br />
Je zou in moeten loggen en je wachtwoord nu veranderen.
<br /><br />
Je kan dit bericht negeren, als de aanmaak van deze account een fout was.',
	'reconfirmemail_body-html' => 'Hallo $2,

Bedankt voor het updaten van het mail adres voor je Wikia account. Bevestig a.u.b. dat dit het correcte email adres is door <a href="$3">hier te klikken</a>.


We kijken er naar uit om je op Wikia te zien!

Het Wikia Community Team <br />
<a href="http://community.wikia.com/">community.wikia.com</a>',
);

$messages['de'] = array(
	'confirmemail_body-html' => '<p>Hallo,<br /><br />

dies ist eine automatisch erstellte Nachricht. <br /><br />

Jemand mit der IP-Adresse $1, wahrscheinlich Du selbst, hat eine Bestätigung dieser E-Mail-Adresse für das Benutzerkonto "$2" für {{SITENAME}} angefordert.<br /><br />

Um die E-Mail-Funktion für {{SITENAME}} (wieder) zu aktivieren und um zu bestätigen, dass dieses Benutzerkonto wirklich zu Deiner E-Mail-Adresse und damit zu Dir gehört, öffne bitte folgenden Link in Deinem Browser: <a href="$3">$3</a><br /><br />

Sollte der vorstehende Link in Deinem E-Mail-Programm über mehrere Zeilen gehen, musst du ihn eventuell per Hand in die URL-Zeile des Browsers einfügen. <br /><br />

Der Bestätigungscode ist bis zum folgenden Zeitpunkt gültig: $4<br /><br />

Wenn diese E-Mail-Adresse *nicht* zu dem genannten Benutzerkonto gehört, folge diesem Link bitte *nicht*.<br /><br />
<hr />
<br />
{{SITENAME}}: <a href="{{fullurl:{{Mediawiki:mainpage}}}}">{{fullurl:{{Mediawiki:mainpage}}}}</a>
</p>',
	'createaccount-text-html' => '<p>Es wurde für dich ein Benutzerkonto „$2“ auf {{SITENAME}} ($4) erstellt. Das automatisch generierte Passwort für „$2“ ist „$3“. Du solltest dich nun anmelden und das Passwort ändern.<br /><br />

Falls das Benutzerkonto irrtümlich angelegt wurde, kannst du diese Nachricht ignorieren.
<br /></p>',
	'enotif_body-html' => '<p>Hallo $WATCHINGUSERNAME,<br />
<br />
die {{SITENAME}}-Seite "$PAGETITLE" wurde von $PAGEEDITOR am $PAGEEDITDATE $CHANGEDORCREATED.<br />
<br />
Aktuelle Version: <a href="$PAGETITLE_URL">$PAGETITLE</a><br />
<br />
$NEWPAGEHTML<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Kontakt zum Benutzer:<br />
E-Mail: $PAGEEDITOR_EMAIL<br />
Wiki: $PAGEEDITOR_WIKI<br />
<br />
Es werden solange keine weiteren Benachrichtigungsmails gesendet, bis Du die Seite wieder besucht hast. Auf Deiner Beobachtungsseite kannst Du alle Benachrichtigungsmarker zusammen zurücksetzen.<br />
<br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem<br />
<br /><hr />
Um die Einstellungen Deiner Beobachtungsliste anzupassen, besuche: <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a>
</p>',
	'enotif_body_delete-html' => '<p>Hallo $WATCHINGUSERNAME,<br />
<br />
die {{SITENAME}}-Seite "$PAGETITLE" wurde von $PAGEEDITOR am $PAGEEDITDATE gelöscht.<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Kontakt zum Benutzer:<br />
E-Mail: $PAGEEDITOR_EMAIL<br />
Wiki: $PAGEEDITOR_WIKI<br />
<br />
Es werden solange keine weiteren Benachrichtigungsmails gesendet, bis Du die Seite wieder besucht hast. Auf Deiner Beobachtungsseite kannst Du alle Benachrichtigungsmarker zusammen zurücksetzen.<br />
<br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem<br />
<br />
<hr />
<ul>
<li>Möchtest du die Einstellungen deiner Beobachtungsliste anpassen? Besuche <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a></li>
<li>Eine Reihe weiterer Wikis findest du in unseren Hubs: <a href="http://de.wikia.com/wiki/Kategorie:Hubs">http://de.wikia.com/wiki/Kategorie:Hubs</a></li>
</ul>
</p>',
	'enotif_body_move-html' => '<p>Hallo $WATCHINGUSERNAME,<br />
<br />
die {{SITENAME}}-Seite "$PAGETITLE" wurde von $PAGEEDITOR am $PAGEEDITDATE verschoben.<br />
<br />
Aktuelle Version: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br />
$NEWPAGE<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Kontakt zum Benutzer:<br />
E-Mail: $PAGEEDITOR_EMAIL<br />
Wiki: $PAGEEDITOR_WIKI<br />
<br />
Es werden solange keine weiteren Benachrichtigungsmails gesendet, bis Du die Seite wieder besucht hast. Auf Deiner Beobachtungsseite kannst Du alle Benachrichtigungsmarker zusammen zurücksetzen.<br />
<br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem<br />
<br />
<hr />
<ul>
<li>Möchtest du die Einstellungen deiner Beobachtungsliste anpassen? Besuche <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a><li>
<li>Eine Reihe weiterer Wikis findest du in unseren Hubs: <a href="http://de.wikia.com/wiki/Kategorie:Hubs">http://de.wikia.com/wiki/Kategorie:Hubs</a>
</ul>
</p>',
	'enotif_body_prl_rep-html' => '<p>Hallo $WATCHINGUSERNAME,<br />
<br />
Ein Benutzer von {{SITENAME}} hat ein Problem auf einer Seite gemeldet, die du beobachtest.<br />
<br />
Klicke hier, um die Seite aufzurufen: <a href="$PAGETITLE_URL">$PAGETITLE_URL</a><br />
<br />
Um eine Liste aller aktuellen Problemmeldungen anzuzeigen, besuche <a href="{{fullurl:{{ns:special}}:ProblemReports}}">{{fullurl:{{ns:special}}:ProblemReports}}</a><br />
<br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem<br />
<br />
<hr />
<ul>
<li>Möchtest du die Einstellungen deiner Beobachtungsliste anpassen? Besuche <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a></li>
<li>Eine Reihe weiterer Wikis findest du in unseren Hubs: <a href="http://de.wikia.com/wiki/Kategorie:Hubs">http://de.wikia.com/wiki/Kategorie:Hubs</a></li>
</ul>
</p>',
	'enotif_body_protect-html' => '<p>Hallo $WATCHINGUSERNAME,<br />
<br />
die {{SITENAME}}-Seite "$PAGETITLE" wurde von $PAGEEDITOR am $PAGEEDITDATE geschützt.<br />
<br />
Aktuelle Version: <a href="$PAGETITLE_URL">$PAGETITLE</a><br />
<br />
$NEWPAGE<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Kontakt zum Benutzer:<br />
E-Mail: $PAGEEDITOR_EMAIL<br />
Wiki: $PAGEEDITOR_WIKI<br />
<br />
Es werden solange keine weiteren Benachrichtigungsmails gesendet, bis Du die Seite wieder besucht hast. Auf Deiner Beobachtungsseite kannst Du alle Benachrichtigungsmarker zusammen zurücksetzen.<br />
<br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem<br />
<br />
<hr />
<ul>
<li>Möchtest du die Einstellungen deiner Beobachtungsliste anpassen? Besuche <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a></li>
<li>Eine Reihe weiterer Wikis findest du in unseren Hubs: <a href="http://de.wikia.com/wiki/Kategorie:Hubs">http://de.wikia.com/wiki/Kategorie:Hubs</a></li>
</ul>
</p>',
	'enotif_body_restore-html' => '<p>Hallo $WATCHINGUSERNAME,<br />
<br />
die {{SITENAME}}-Seite "$PAGETITLE" wurde von $PAGEEDITOR am $PAGEEDITDATE wiederhergestellt.<br />
<br />
Aktuelle Version: <a href="$PAGETITLE_URL">$PAGETITLE</a><br />
<br />
$NEWPAGE<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Kontakt zum Benutzer:<br />
E-Mail: $PAGEEDITOR_EMAIL<br />
Wiki: $PAGEEDITOR_WIKI<br />
<br />
Es werden solange keine weiteren Benachrichtigungsmails gesendet, bis Du die Seite wieder besucht hast. Auf Deiner Beobachtungsseite kannst Du alle Benachrichtigungsmarker zusammen zurücksetzen.<br />
<br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem<br />
<br />
<hr />
<ul>
<li>Möchtest du die Einstellungen deiner Beobachtungsliste anpassen? Besuche <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a></li>
<li>Eine Reihe weiterer Wikis findest du in unseren Hubs: <a href="http://de.wikia.com/wiki/Kategorie:Hubs">http://de.wikia.com/wiki/Kategorie:Hubs</a>
</ul>
</p>',
	'enotif_body_rights-html' => '<p>Hallo $WATCHINGUSERNAME,<br />
<br />
es gab eine Änderung der Benutzerrechte eines {{SITENAME}}-Benutzers, dessen Benutzerseite du beobachtest. Die entsprechende Seite findest du hier: <a href="$PAGETITLE_URL">$PAGETITLE</a><br />
<br />
Um eine Liste aller aktuellen Log-Einträge anzuzeigen, besuche <a href="{{fullurl:{{ns:special}}:Log}}">{{fullurl:{{ns:special}}:Log}}</a><br />
<br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem<br />
<br />
<hr />
<ul>
<li>Möchtest du die Einstellungen deiner Beobachtungsliste anpassen? Besuche <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a></li>
<li>Eine Reihe weiterer Wikis findest du in unseren Hubs: <a href="http://de.wikia.com/wiki/Kategorie:Hubs">http://de.wikia.com/wiki/Kategorie:Hubs</a></li>
</ul>
</p>',
	'enotif_body_unprotect-html' => '<p>Hallo $WATCHINGUSERNAME,<br />
<br />
die {{SITENAME}}-Seite "$PAGETITLE" wurde von $PAGEEDITOR am $PAGEEDITDATE entsperrt.<br />
<br />
Aktuelle Version: <a href="$PAGETITLE_URL">$PAGETITLE</a><br />
<br />
$NEWPAGE<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Kontakt zum Benutzer:<br />
E-Mail: $PAGEEDITOR_EMAIL<br />
Wiki: $PAGEEDITOR_WIKI<br />
<br />
Es werden solange keine weiteren Benachrichtigungsmails gesendet, bis Du die Seite wieder besucht hast. Auf Deiner Beobachtungsseite kannst Du alle Benachrichtigungsmarker zusammen zurücksetzen.<br />
<br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem<br />
<br />
<hr />
<ul>
<li>Möchtest du die Einstellungen deiner Beobachtungsliste anpassen? Besuche <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a></li>
<li>Eine Reihe weiterer Wikis findest du in unseren Hubs: <a href="http://de.wikia.com/wiki/Kategorie:Hubs">http://de.wikia.com/wiki/Kategorie:Hubs</a></li>
</ul>
</p>',
	'enotif_lastvisited-html' => 'Alle Änderungen auf einen Blick, <a href="$1">klicke hier</a>',
	'globalwatchlist-digest-email-body-html' => '<p>Hallo $1,
<br /><br />
Das ist eine Liste von Seiten die nach deinem letzten Besuch geändert wurden und seither noch nicht wieder besucht hast.
<br /><br />
$2
<br /><br />
Das ist eine Liste von Seiten die jemand nach dir kommentiert oder editiert hat, und die du seither noch nicht wieder besucht hast.
<br /><br />
$3
<br /><br />
Bitte besuche uns und bearbeite oft...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Um deine Benachrichtigungseinstellungen zu ändern, besuche <a href="http://de.wikia.com/wiki/Special:Preferences">deine Einstellungen</a></li>
<li>Um alle Seiten von der wöchentlichen Zusammenfassung als besucht zu markieren, besuche den "Beobachtungsliste"-Tab in deinen Einstellungen</li>
</ul>
</p>',
	'passwordremindertext-html' => '<p>Jemand mit der IP-Adresse $1, wahrscheinlich du selbst, hat ein neues Passwort für die Anmeldung bei {{SITENAME}} ($4) angefordert.<br />
<br />
Das automatisch generierte Passwort für Benutzer „$2“ lautet nun: $3<br /><br />

Du solltest dich jetzt anmelden und das Passwort ändern: <a href="{{fullurl:{{ns:special}}:Userlogin}}" rel="nofollow">{{fullurl:{{ns:special}}:Userlogin}}</a><br />
Das neue Passwort ist {{PLURAL:$5|1 Tag|$5 Tage}} gültig.<br />
<br />
Bitte ignoriere diese E-Mail, falls du sie nicht selbst angefordert hast. Das alte Passwort bleibt weiterhin gültig.<br />
</p>',
);

$messages['es'] = array(
	'confirmemail_body-html' => '<p>Hola $2,
<br /><br />
¡Te damos la bienvenida a Wikia!
<br /><br />
Con las miles de comunidades que existen en Wikia, hay muchas formas de divertirse aquí. Te recomendamos tomar algo de tu tiempo conociendo Wikia, ya sea visitando su página principal (<a href="http://es.wikia.com">es.wikia.com</a>), siguiendo un tutorial (<a href="http://es.wikia.com/wiki/Ayuda:Tutorial_1">Tutorial 1</a>), leyendo artículos interesantes y geniales, escribiendo contenidos en tu tema favorito, o conociendo a otros miembros de la comunidad.
<br /><br />
Para activar completamente tu cuenta, te pedimos que confirmes tu dirección de correo electrónico haciendo clic en el enlace de más abajo o pegándolo en tu navegador.
<br /><br />
<a href="$3">$3</a>
<br /><br />
Este enlace de confirmación expirará en $4.
<br /><br />
(Este nombre de usuario fue creado por la siguiente dirección: $1 en el wiki {{SITENAME}}. Si la cuenta *no* es tuya, sigue este enlace para cancelar la confirmación de la dirección de correo: $5 )
<br /><br />
¡Esperamos verte en Wikia!<br />
El equipo comunitario de Wikia<br />
<a href="http://es.wikia.com>es.wikia.com</a>
</p>',
	'createaccount-text-html' => '<p>Alguien creó una cuenta para este correo electrónico en  {{SITENAME}} ($4) con el nombre "$2", y la contraseña "$3".<br />
Por favor entra y cambia tu contraseña ahora.<br />
<br />
Puedes ignorar este mensaje si esta cuenta fue creada erróneamente.<br />
</p>',
	'enotif_body-html' => '<p>Estimado/a $WATCHINGUSERNAME,<br />
<br />
Una de las páginas de tu lista de seguimiento en {{SITENAME}} ha tenido cambios.<br />
<br />
Puedes ver su versión actual en <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br />
$NEWPAGEHTML<br />
<br />
El resumen de edición es: "$PAGESUMMARY"<br />
<br />
Esperamos que sigas visitando y editando {{SITENAME}}.<br />
<hr/>
<ul>
<li>¿Quieres especificar qué correos electrónicos recibes de Wikia? Visita: <a href="{{fullurl:{{ns:special}}:Preferences}}">{{fullurl:{{ns:special}}:Preferences}}</a>.</li>
<li>Para ver los nuevos wikis creados esta semana, puedes visitar <http://www.wikia.com/wiki/New_wikis_this_week>.</li>
</ul>
</p>',
	'enotif_body_blogs_comment-html' => '<p>Estimado $WATCHINGUSERNAME,<br />
<br />
$PAGEEDITOR puso un comentario en la entrada de blog "$BLOGTITLE". <br />
<br />
Para ver el comentario, sigue el enlace de debajo:<br />
<a href="$PAGETITLE_URL">$PAGETITLE</a><br />
<br />
Por favor, visita la entrada y edítala a menudo para seguir los cambios...<br />
<br />
Wikia<br />
</p>',
	'enotif_lastvisited-html' => '<a href="$1">Visita</a> para ver todos los cambios en esta página desde tu última visita.',
	'globalwatchlist-digest-email-body-html' => '<p>Estimado/a $1,<br />
<br />
Esta es una lista de las páginas de tu lista de seguimiento de Wikia que han sido editadas desde tu última visita.<br />
<br />
$2
<br />
Por favor visítalas y edítalas si lo consideras necesario...<br />
<br />
Wikia<br />
<br />
<ul>
<li>Para cambiar tus preferencias para las notificaciones de tu lista de seguimiento, por favor, visita <a href="http://www.wikia.com/wiki/Special:Preferences">Preferences</a></li>
<li>Para marcar todas las páginas como visitadas de este Boletín Semanal ve a la pestaña de "Seguimiento"  en tus Preferencias</li>
</ul>
</p>',
	'passwordremindertext-html' => '<p>Hola<br />
La contraseña para el usuario "$2" es ahora "$3".<br />
Si no solicitaste una nueva contraseña, no te preocupes. La contraseña de reemplazo ha sido enviada sólo a ti a esta dirección de correo. Tu cuenta seguirá segura y puedes continuar utilizando tu antigua contraseña.<br /><br />

Gracias,
<br /><br />
El Equipo Comunitario de Wikia
<br /><br />
www.wikia.com
<br /><hr />
<ul>
<li>Para cambiar tus preferencias o tu contraseña, visita: <a href="http://www.wikia.com/wiki/Special:Preferences">Special:Preferences</a>.</li>
<li>Este recordatorio de contraseña fue solicitado por la siguiente dirección: $1.</li>
</ul>
</p>',
);

$messages['fr'] = array(
	'confirmemail_body-html' => '<p>Quelqu’un, probablement vous, à partir de l’adresse IP $1,<br />
a enregistré un compte « $2 » avec cette adresse de courriel<br />
sur le site {{SITENAME}}.
<br /><br />
Pour confirmer que ce compte vous appartient vraiment et afin<br />
d’activer les fonctions de messagerie sur {{SITENAME}},<br />
veuillez suivre ce lien dans votre navigateur:<br />
<br /><br />
<a href="$3">$3</a>
<br /><br />
Si vous n’avez *pas* enregistré ce compte, n’ouvrez pas ce lien ;<br />
vous pouvez suivre l’autre lien ci-dessous pour annuler la<br />
confirmation de votre adresse courriel :<br />
<br /><br />
<a href="$5">$5</a>
<br /><br />
Ce code de confirmation expirera le $4.
<br /></p>',
	'createaccount-text-html' => '<p>Quelqu’un a créé un compte pour votre adresse de courriel sur {{SITENAME}} ($4) intitulé « $2 », avec le mot de passe « $3 ».<br />
Vous devriez ouvrir une session et modifier dès à présent votre mot de passe.<br />
<br />
Ignorez ce message si ce compte a été créé par erreur.<br />
</p>',
	'enotif_body-html' => '<p>Cher $WATCHINGUSERNAME,<br />
<br />
la page $PAGETITLE de {{SITENAME}} a été $CHANGEDORCREATED le $PAGEEDITDATE par $PAGEEDITOR, voyez <a href="$PAGETITLE_URL">$PAGETITLE</a> pour la version actuelle.<br />
<br />
$NEWPAGEHTML<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Contactez l’éditeur :<br />
courriel : $PAGEEDITOR_EMAIL<br />
wiki : $PAGEEDITOR_WIKI<br />
<br />
Il n’y aura pas de nouvelles notifications en cas d’autres modifications à moins que vous ne visitiez cette page. Vous pouvez aussi remettre à zéro le notificateur pour toutes les pages de votre liste de suivi.<br />
<br />
Votre système de notification {{SITENAME}}<br />
<hr />
Pour modifier les paramètres de votre liste de suivi, visitez<br />
<a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a><br />
<br />
Retour et assistance :<br />
<a href="{{fullurl:{{MediaWiki:Helppage}}}}">{{fullurl:{{MediaWiki:Helppage}}}}</a>
</p>',
	'enotif_body_delete-html' => '<p>Bonjour $WATCHINGUSERNAME,<br />
<br />
la page « $PAGETITLE » de {{SITENAME}} a été effacé de $PAGEEDITOR le $PAGEEDITDATE.<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Contacter cet utilisateur:<br />
E-Mail: $PAGEEDITOR_EMAIL<br />
Wiki: $PAGEEDITOR_WIKI<br />
<br />
Il n\'aura plus des messages depuis vous avez visité cette page. Sur ta page de la liste de suivi tu peux organiser tes pages suives.<br />
<br />
Votre system gentil de messages de {{SITENAME}}<br />
<br />
<hr />
<ul>
<li>Veuillez rganiser tes préférences de la liste de suivi ?  Visitez <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a></li>
<li>Plus des trucs vous trouvez sur : <a href="http://fr.wikia.com">http://fr.wikia.com</a></li>
</ul>
</p>',
	'enotif_body_restore-html' => '<p>Bonjour $WATCHINGUSERNAME,<br />
<br />
la page « $PAGETITLE » de {{SITENAME}} a été restauré de $PAGEEDITOR le $PAGEEDITDATE.<br />
<br />
Version currente: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br />
$NEWPAGE<br />
<br />
$PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Contacter l\'utilisateur:<br />
E-Mail: $PAGEEDITOR_EMAIL<br />
Wiki: $PAGEEDITOR_WIKI<br />
<br />
Il n\'aura plus des messages depuis vous avez visité cette page. Sur ta page de la liste de suivi tu peux organiser tes pages suives.<br />
<br />
Votre system gentil de messages de {{SITENAME}}<br />
<br />
<hr />
<ul>
<li>Veuillez rganiser tes préférences de la liste de suivi ?  Visitez <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a></li>
<li>Plus des trucs vous trouvez sur : <a href="http://fr.wikia.com">http://fr.wikia.com</a></li>
</ul>
</p>',
	'enotif_lastvisited-html' => 'Pour tous les changements depuis votre dernière visite, voyez <a href="$1">ce lien</a>',
	'globalwatchlist-digest-email-body-html' => '<p>Bonjour $1,<br />
<br />
Au dessous vous trouvez une liste des toutes pages qui étaient modifiés après votre dernière visite.<br />
<br />
$2<br />
<br />
Visitez et modifiez, si le cas échant...<br />
<br />
Wikia<br /><br />
<ul>
<li>Vous pouvez modifier vos préférences ici, si vous ne voulez plus recevoir: <a href="http://www.wikia.com/wiki/Special:Preferences">http://www.wikia.com/wiki/Special:Preferences</a></li>
</ul>
</p>',
	'passwordremindertext-html' => '<p>Quelqu’un (probablement vous, ayant l’adresse IP $1) a demandé un nouveau mot de<br />
passe pour {{SITENAME}} ($4). Un mot de passe temporaire a été créé pour<br />
l’utilisateur « $2 » et est « $3 ». Si cela était votre intention, vous devrez<br />
vous connecter et choisir un nouveau mot de passe.<br />
Votre mot de passe temporaire expirera dans $5 jour{{PLURAL:$5||s}}.<br />
<br />
Si vou n’êtes pas l’auteur de cette demande, ou si vous vous souvenez à présent<br />
de votre ancien mot de passe et que vous ne souhaitez plus en changer, vous<br />
pouvez ignorer ce message et continuer à utiliser votre ancien mot de passe.<br />
</p>',
);

$messages['it'] = array(
	'confirmemail_body-html' => '<p>Qualcuno, probabilmente tu stesso dall\'indirizzo IP $1, ha registrato l\'account "$2" su {{SITENAME}} indicando questo indirizzo e-mail.
<br /><br />
Per confermare che l\'account ti appartiene veramente e attivare le funzioni relative all\'invio di e-mail su {{SITENAME}}, apri il collegamento seguente con il tuo browser:
<br /><br />
<a href="$3">$3</a>
<br /><br />
Se *non* hai registrato tu l\'account, segui questo collegamento per annullare la conferma dell\'indirizzo e-mail:
<br /><br />
<a href="$5">$5</a>
<br /><br />
Questo codice di conferma scadrà automaticamente alle $4.
</p>',
	'createaccount-text-html' => '<p>Qualcuno ha creato un accesso a {{SITENAME}} ($4) a nome di $2, associato a questo indirizzo di posta elettronica. La password per l\'utente "$2" è impostata a "$3".<br />
È opportuno eseguire un accesso quanto prima e cambiare la password immediatamente.<br />
<br /><br />
Se l\'accesso è stato creato per errore, si può ignorare questo messaggio.<br />
</p>',
	'enotif_body-html' => '<p>Gentile $WATCHINGUSERNAME,<br />
<br />
la pagina $PAGETITLE di {{SITENAME}} è stata $CHANGEDORCREATED in data $PAGEEDITDATE da $PAGEEDITOR; la versione attuale si trova all\'indirizzo <a href="$PAGETITLE_URL">$PAGETITLE</a>.<br />
<br />
$NEWPAGEHTML<br />
<br />
Riassunto della modifica, inserito dall\'autore: $PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Contatta l\'autore della modifica:<br />
via e-mail: $PAGEEDITOR_EMAIL<br />
sul sito: $PAGEEDITOR_WIKI<br />
<br />
Non verranno inviate altre notifiche in caso di ulteriori cambiamenti, a meno che tu non visiti la pagina. Inoltre, è possibile reimpostare l\'avviso di notifica per tutte le pagine nella lista degli osservati speciali.<br />
<br />
Il sistema di notifica di {{SITENAME}}, al tuo servizio<br />
<hr/ >
Per modificare le impostazioni della lista degli osservati speciali, visita <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a><br />
<br />
Per dare il tuo feedback e ricevere ulteriore assistenza: <a href="{{fullurl:Help:Aiuto}}">{{fullurl:Help:Aiuto}}</a>.<br />
</p>',
	'passwordremindertext-html' => '<p>Qualcuno (probabilmente tu, con indirizzo IP $1) ha richiesto l\'invio di una nuova password di accesso a {{SITENAME}} ($4).<br />
Una password temporanea per l\'utente "$2" è stata impostata a "$3".<br />
È opportuno eseguire un accesso quanto prima e cambiare la password immediatamente. La password temporanea scadrà dopo {{PLURAL:$5|un giorno|$5 giorni}}.<br />
<br />
Se non sei stato tu a fare la richiesta, oppure hai ritrovato la password e non desideri più cambiarla, puoi ignorare questo messaggio e continuare a usare la vecchia password.<br />
</p>',
);

$messages['pl'] = array(
	'confirmemail_body-html' => '<p>Ktoś łącząc się z komputera o adresie IP $1<br/ >
zarejestrował w {{GRAMMAR:MS.lp|{{SITENAME}}}} konto „$2” podając niniejszy adres e‐mail.<br />
<br />
Aby potwierdzić, że to Ty zarejestrowałeś to konto oraz, aby włączyć<br />
wszystkie funkcje korzystające z poczty elektronicznej, otwórz w swojej<br />
przeglądarce ten link:<br />
<br /><br />
<a href="$3">$3</a >
<br /><br />
Jeśli to *nie* Ty zarejestrowałeś konto, otwórz w swojej przeglądarce<br />
poniższy link, aby anulować potwierdzenie adresu e‐mail:<br />
<br /><br />
<a href="$5">$5</a>
<br /><br />
Kod zawarty w linku straci ważność $4.
<br /></p>',
	'createaccount-text-html' => '<p>Ktoś utworzył w {{GRAMMAR:MS.lp|{{SITENAME}}}} ($4), podając Twój adres e‐mail, konto „$2”. Aktualnym hasłem jest „$3”.<br />
Zaloguj się teraz i je zmień.<br />
<br />
Możesz zignorować tę wiadomość, jeśli konto zostało utworzone przez pomyłkę.<br />
</p>',
	'enotif_body-html' => '<p>Drogi (droga) $WATCHINGUSERNAME,<br />
<br />
strona $PAGETITLE w {{GRAMMAR:MS.lp|{{SITENAME}}}} została $CHANGEDORCREATED $PAGEEDITDATE przez użytkownika $PAGEEDITOR. Zobacz na stronie <a href="$PAGETITLE_URL">$PAGETITLE</a> aktualną wersję.<br />
<br />
$NEWPAGEHTML<br />
<br />
Opis zmiany: $PAGESUMMARY $PAGEMINOREDIT<br />
<br />
Skontaktuj się z autorem:<br />
mail: $PAGEEDITOR_EMAIL<br />
wiki: $PAGEEDITOR_WIKI<br />
<br />
W przypadku kolejnych zmian nowe powiadomienia nie zostaną wysłane, dopóki nie odwiedzisz tej strony.<br />
Możesz także zresetować wszystkie flagi powiadomień na swojej liście stron obserwowanych.<br />
<br />
Wiadomość systemu powiadomień {{GRAMMAR:D.lp|{{SITENAME}}}}<br />
<br />
<hr />
W celu zmiany ustawień swojej listy obserwowanych odwiedź<br />
<a href="{{fullurl:{{ns:special}}:Watchlist/edit}}">{{fullurl:{{ns:special}}:Watchlist/edit}}</a>
<br /><br />
Pomoc:<br />
<a href="{{fullurl:{{MediaWiki:Helppage}}}}">{{fullurl:{{MediaWiki:Helppage}}}}</a><br />
</p>',
	'passwordremindertext-html' => '<p>Ktoś (prawdopodobnie Ty, spod adresu IP $1)<br />
poprosił o przesłanie nowego hasła do {{GRAMMAR:D.lp|{{SITENAME}}}} ($4).<br/ >
Dla użytkownika „$2” zostało wygenerowane tymczasowe hasło i jest nim „$3”.<br />
Jeśli było to zamierzone działanie, to po zalogowaniu się, musisz podać nowe hasło. <br />
Tymczasowe hasło wygaśnie za {{PLURAL:$5|1 dzień|$5 dni}}.<br />
<br />
Jeśli to nie Ty prosiłeś o przesłanie hasła lub przypomniałeś sobie hasło i nie chcesz go zmieniać, wystarczy, że zignorujesz tę wiadomość i dalej będziesz się posługiwać swoim dotychczasowym hasłem.<br />
</p>',
);
