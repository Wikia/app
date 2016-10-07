<?php
/** Internationalization file for /extensions/wikia/WikiaMiscMessages/WikiaMiscMessages extension. */
$messages = [];

$messages['en'] = [
	'autocreatewiki-welcomebody-HTML' => '"<p>Hello $2,<br /><br />
The wiki you created is now available at <a href="$1">$1</a>.  We hope to see you editing there soon!<br /><br />
We have added some information and tips on your <a href="$5">user talk Page</a> to help you get started. If you have any questions, just reply to this e-mail or browse our help pages at <a href="http://help.wikia.com/">Fandom Help</a>.<br /><br />
Good luck with the project,<br /><br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Fandom Community Team<br /></p>',
	'confirmemail_body-HTML' => 'Hi $2,
<br /><br />
Thanks for registering on Wikia!
<br /><br />
Please take a minute to activate your new account by <a href="$3">confirming your email address</a>.
<br /><br />
Ready to get started?<br>
<ul><li>Look at all of the <a href="{{fullurl:{{ns:special}}:WikiActivity}}">recent activity</a> of the community you just joined! Start contributing by leaving comments or editing pages.</li>
<li><a href="http://www.wikia.com/Special:LandingPage">Watch</a> the Wikia video and start exploring some of our favorite wikis in Gaming, Entertainment, and Lifestyles.</li>
<li>Meet the Wikia community, learn about what\'s happening, and find help - all at <a href="http://community.wikia.com/wiki/Community_Central">Community Central</a>.</li></ul>
<br />
Have fun!<br>
- Wikia Community Support
<br /><hr />
<p>
<ul>
<li>Find help and advice on <a href="http://community.wikia.com">Community Central</a>.</li>
<li>Want to receive fewer messages from us? You can unsubscribe or change your email preferences <a href="http://community.wikia.com/Special:Preferences">here</a>.</li>',
	'confirmemailreminder_body-HTML' => '<p>Hello $1,<br /><br />
Last week you joined Wikia, but you still need to confirm your account. Please do so by clicking <a href="$2">here</a>.<br /><br />
We look forward to seeing you soon!<br /><br />
The Wikia Community Team<br />
<a href="http://www.wikia.com/">www.wikia.com</a></p>',
	'createaccount-text-HTML' => 'Hello,<br /><br />

An account has been created for you created on {{SITENAME}} with the username "$2" and password "$3". <br /><br />

Please log in at $4<br /><br />

If you do not need this account, you can ignore this message or contact community@wikia.com with any questions.<br /><br />

- Wikia Community Support

<br /><hr />
<p>
<ul>
<li>Find help and advice on <a href="http://www.community.wikia.com">Community Central</a>.</li>
<li>WWant to receive fewer messages from us? You can unsubscribe or change your email preferences <a href="http://community.wikia.com/Special:Preferences">here</a>.</li>
</ul>
</p>',
	'enotif_body-HTML' => 'Hi $WATCHINGUSERNAME,
<br /><br />
One of the pages you\'re following, $PAGETITLE on {{SITENAME}}, has been edited by $PAGEEDITOR.
<br /><br />
Interested in seeing what\'s changed?  See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.
<br /><br />
$NEWPAGEHTML
<br /><br />
$PAGESUMMARY
<br /><br />
- Wikia Community Support


<br /><hr />
<p>
<ul>
<li>Find help and advice on <a href="http://www.community.wikia.com">Community Central</a>.</li>
<li>Want to receive fewer messages from us? You can unsubscribe or change your email preferences <a href="http://community.wikia.com/Special:Preferences">here</a>.</li>
</ul>
</p>',
	'enotif_body_article_comment-HTML' => 'Hi $WATCHINGUSERNAME,
<br /><br />
There\'s a new comment at $PAGETITLE on {{SITENAME}}. Use this link to see all of the comments: <a href="$PAGETITLE_URL#WikiaArticleComments">$PAGETITLE</a>
<br /><br />
- Wikia Community Support
<br /><hr />
<p>
<ul>
<li>Find help and advice on <a href="http://www.community.wikia.com">Community Central</a>.</li>
<li>Want to receive fewer messages from us? You can unsubscribe or change your email preferences <a href="http://community.wikia.com/Special:Preferences">here</a>.
</li>
</ul>
</p>',
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
<li>Check out our featured wikis! <a href="http://www.wikia.com">Visit Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}"> User Preferences</a></li>
</ul></p>',
	'enotif_body_move-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A page you are watching on {{SITENAME}} has been moved.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out our featured wikis! <a href="http://www.wikia.com">Visit Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_prl_chn-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A problem has been updated for a page you are watching on {{SITENAME}}.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the page.<br /><br />
For a list of recent problem reports, see <a href="{{fullurl:{{ns:special}}:ProblemReports}}">{{ns:special}}:ProblemReports</a><br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out our featured wikis! <a href="http://www.wikia.com">Visit Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_prl_rep-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A problem has been reported for a page you are watching on {{SITENAME}}.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the page.<br /><br />
For a list of recent problem reports, see <a href="{{fullurl:{{ns:special}}:ProblemReports}}">{{ns:special}}:ProblemReports</a><br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out our featured wikis! <a href="http://www.wikia.com">Visit Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_protect-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A page you are watching on {{SITENAME}} has been protected.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out our featured wikis! <a href="http://www.wikia.com">Visit Them Here!</a></li>
<li>Want to control which e-mails you receive? Go to: <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul></p>',
	'enotif_body_restore-HTML' => '<p>Dear $WATCHINGUSERNAME,<br /><br />
A page you are watching on {{SITENAME}} has been restored from deletion.<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the current version.<br /><br />
$PAGESUMMARY<br /><br />
Please visit and edit often...<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li>Check out our featured wikis! <a href="http://www.wikia.com">Visit Them Here!</a></li>
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
<li>Check out our featured wikis! <a href="http://www.wikia.com">Visit Them Here!</a></li>
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
	'reconfirmemail_body-HTML' => '<p>Hello $2,<br /><br />
Thank you for updating the e-mail address for your Wikia account. Please confirm this is the correct e-mail address by <a href="$3">clicking here</a>.<br /><br /><br />
We look forward to seeing you on Wikia!<br /><br />
The Wikia Community Team<br />
www.wikia.com<br /></p>',
];

$messages['nl-informal'] = [
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
];

$messages['de'] = [
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
	'passwordremindertext-HTML' => '<p>Hallo!<br /><br />
Das Passwort für Benutzer "$2" lautet jetzt "$3".<br /><br />
Mach dir keine Sorgen, falls du kein neues Passwort angefordert hast. Das Ersatz-Passwort wurde nur an dich unter dieser E-Mail-Adresse geschickt. Dein Konto ist sicher und du kannst auch weiterhin dein altes Passwort benutzen.<br /><br />
Vielen Dank,<br /><br />
Dein Fandom Community-Team<br /><br />
www.wikia.com<br /><hr />
<ul>
<li>Deine Einstellungen oder dein Passwort kannst du in den <a href="http://de.community.wikia.com/wiki/Spezial:Einstellungen">Benutzereinstellungen</a> ändern.</li>
<li>Diese Passwort-Erinnerung wurde von dieser E-Mail-Adresse aus angefordert: $1.</li>
</ul></p>',
	'autocreatewiki-welcomebody-HTML' => '"<p>Hallo $2,<br /><br />
Das von dir erstellte Wiki steht nun unter <a href="$1">$1</a> bereit.  Wir hoffen, dass du bald mit dem Bearbeiten beginnst!<br /><br />
Wir haben dir auf deiner <a href="$5">Benutzer-Diskussionsseite</a> ein paar Informationen und Tipps eingestellt, damit du gleich richtig durchstarten kannst. Wenn du Fragen hast, antworte einfach auf diese E-Mail oder sieh dich auf unseren Hilfeseiten um. Hier findest du die <a href="http://help.wikia.com/">Fandom-Hilfe</a>.<br /><br />
Viel Glück mit deinem Projekt, <br /><br />
<a href="http://de.community.wikia.com/wiki/User:$4">$3</a><br />
Das Fandom Community-Team<br /></p>',
	'confirmemail_body-HTML' => '<p>
Hallo,<br /><br />

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
	'createaccount-text-HTML' => '<p>
Es wurde für dich ein Benutzerkonto „$2“ auf {{SITENAME}} ($4) erstellt. Das automatisch generierte Passwort für „$2“ ist „$3“. Du solltest dich nun anmelden und das Passwort ändern.<br /><br />

Falls das Benutzerkonto irrtümlich angelegt wurde, kannst du diese Nachricht ignorieren.
<br /></p>',
	'enotif_body-HTML' => '<p>
Hallo $WATCHINGUSERNAME,<br />
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
Um die Einstellungen Deiner Beobachtungsliste anzupassen, besuche: <a href="{{fullurl:Special:Watchlist/edit}}">{{fullurl:Special:Watchlist/edit}}</a><br />
<b>Folge uns auf</b><br />
<ul>
<li>Facebook: <a href="http://facebook.com/wikia.de">facebook.com/wikia.de</a></li>
<li>Twitter: <a href="http://twitter.com/wikia_de">twitter.com/wikia_de</a></li>
</ul>
</p>',
	'enotif_body_article_comment-HTML' => '<p>Hallo $WATCHINGUSERNAME,
<br /><br />
$PAGEEDITOR hat einen Kommentar auf der Seite "$PAGETITLE" hinterlassen.
<br /><br />
Um alle Kommentare zu sehen, folge diesem Link:
<a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Dein freundliches {{SITENAME}}-Benachrichtigungssystem
<br /><hr />
<ul>
<li>Um die Einstellungen deiner Beobachtungsliste anzupassen, besuche: <a href="{{fullurl:Special:Watchlist/edit}}">{{ns:special}}:Watchlist/edit<a>.</li>
</ul><br />
<b>Folge uns auf</b><br />
<ul>
<li>Facebook: <a href="http://facebook.com/wikia.de">facebook.com/wikia.de</a></li>
<li>Twitter: <a href="http://twitter.com/wikia_de">twitter.com/wikia_de</a></li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => 'Für alle Änderungen auf einen Blick <a href="$1">klicke hier</a>.',
	'founderemails-email-user-registered-body-HTML' => 'Hallo $USERNAME,<br /><br />
Es sieht so aus, als ob sich $EDITORNAME in deinem Wiki registriert hat! Warum besuchst du nicht seine <a href="$EDITORTALKPAGEURL">Diskussionsseite</a>, um Hallo zu sagen?<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Das Wikia-Team</div>',
];

$messages['es'] = [
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
	'autocreatewiki-welcomebody-HTML' => '<p>Hola $2, <br /><br /> 
El wiki que has creado está disponible en <a href="$1">$1</a>. ¡Esperamos verte editando allí pronto! <br />< br /> 
Hemos añadido cierta información y consejos en tu <a href="$5"> Página de discusión de usuario</a> para ayudarle a empezar. Si tienes alguna pregunta, responde a este correo electrónico o navega por nuestras páginas de ayuda en <a href="http://help.wikia.com/">Ayuda Fandom</a>.< br /><br /> 
Buena suerte con el proyecto, < br /><br /> 
<a href="http://comunidad.wikia.com/wiki/Usuario:$4">$3</a>< br /> 
Equipo comunitario de Fandom< br /></p>',
	'passwordremindertext-HTML' => '<p>Hola,<br /><br />
La contraseña de inicio de sesión del usuario "$2" es ahora "$3".<br /><br />
Si no has solicitado una nueva contraseña, ¡no te preocupes! La contraseña temporal ha sido enviada solamente a esta dirección de correo electrónico. Tu cuenta está segura y puedes acceder con tu antigua contraseña.<br /><br />
Atentamente,<br /><br />
El equipo comunitario de Fandom<br /><br />
www.fandom.com<br /><hr />
<ul>
<li>Para cambiar tus preferencias o contraseña, ingresa a: <a href="http://www.fandom.com/wiki/Especial:Preferencias">Preferencias de usuario</a>.</li> 
<li>Esta contraseña temporal fue pedida por la siguiente dirección de correo electrónico: $1.</li>
</ul></p>',
	'confirmemail_body-HTML' => 'Hola $2,
<br /><br />
¡Te damos la bienvenida a Wikia!
<br /><br />
Por favor, tómate un descanso para activar tu nueva cuenta <a href="$3">confirmando tu dirección de correo electrónico</a>.
<br /><br />
Y ahora, llegó el momento... ¡hora de empezar la aventura!<br>
<ul><li>Echa un vistazo a la <a href="{{fullurl:{{ns:special}}:WikiActivity}}">actividad reciente</a> de la comunidad en la que acabas de participar. Comienza a contribuir mejorando las páginas que ya hay o creando nuevas páginas.</li>
<li>Explora <a href="http://comunidad.wikia.com/wiki/Lista_de_Wikis">nuestras comunidades</a> sobre videojuegos, entretenimiento o cualquier otro tema y diviértete descubriendo cosas nuevas.</li>
<li>Descubre qué sucede en Wikia y conoce a otros usuarios de Wikia en nuestro <a href="http://comunidad.wikia.com/wiki/Wikia">wiki comunitario</a>.</li></ul>
<br />
¡Diviértete!<br>
- Equipo comunitario de Wikia
<br /><hr />
<p>
<ul>
<li>Si necesitas ayuda o consejos, visita nuestra <a href="http://comunidad.wikia.com">comunidad central</a>.</li>
<li>¿Quieres dejar de recibir estos mensajes? Puedes darte de baja en el servicio de emails desde tus preferencias <a href="http://comunidad.wikia.com/Especial:Preferencias">aquí</a>.</li>
</ul>
</p>',
	'createaccount-text-HTML' => 'Hola,<br /><br />

Alguien creó una cuenta de usuario en  {{SITENAME}} con el nombre "$2" y la contraseña "$3". <br /><br />

Por favor, identifícate en $4<br /><br />

Si no necesitas esta cuenta, puedes ignorar este mensaje o contactar con nosotros a través de community@wikia.com para informarnos al respecto.<br /><br />

- Equipo comunitario de Wikia
<br /><hr />
<p>
<ul>
<li>Si necesitas ayuda o consejos, visita nuestra <a href="http://comunidad.wikia.com">comunidad central</a>.</li>
<li>¿Quieres dejar de recibir estos mensajes? Puedes darte de baja en el servicio de emails desde tus preferencias <a href="http://comunidad.wikia.com/Especial:Preferencias">aquí</a>.</li>
</ul>
</p>',
	'enotif_body-HTML' => 'Hola $WATCHINGUSERNAME,
<br /><br />
Una de las páginas que estás siguiendo en {{SITENAME}}, $PAGETITLE, ha sido editada por $PAGEEDITOR.
<br /><br />
¿Quieres ver qué ha cambiado?  Visita <a href="$PAGETITLE_URL">$PAGETITLE</a> para ver la versión actual de la página.
<br /><br />
$NEWPAGEHTML
<br /><br />
$PAGESUMMARY
<br /><br />
- Equipo comunitario de Wikia
<br /><hr />
<p>
<ul>
<li>Si necesitas ayuda o consejos, visita nuestra <a href="http://comunidad.wikia.com">comunidad central</a>.</li>
<li>¿Quieres dejar de recibir estos mensajes? Puedes darte de baja en el servicio de emails desde tus preferencias <a href="http://comunidad.wikia.com/Especial:Preferencias">aquí</a>.</li>
</ul>
</p>',
	'enotif_body_article_comment-HTML' => 'Hola $WATCHINGUSERNAME,
<br /><br />
Hay nuevos comentarios en la página $PAGETITLE de {{SITENAME}}. Usa el siguiente enlace para ver todos los comentarios: <a href="$PAGETITLE_URL#article-comments">$PAGETITLE</a>
<br /><br />
- Equipo comunitario de Wikia
<br /><hr />
<p>
<ul>
<li>Si necesitas ayuda o consejos, visita nuestra <a href="http://comunidad.wikia.com">comunidad central</a>.</li>
<li>¿Quieres dejar de recibir estos mensajes? Puedes darte de baja en el servicio de emails desde tus preferencias <a href="http://comunidad.wikia.com/Especial:Preferencias">aquí</a>.</li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => '<a href="$1">Visita</a> para ver todos los cambios en esta página desde tu última visita.',
];

$messages['fr'] = [
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
	'autocreatewiki-welcomebody-HTML' => '"<p>Bonjour $2,<br /><br />
Le wiki que vous avez créé est disponible ici : <a href="$1">$1</a>.  Nous sommes impatients de voir vos prochaines contributions !<br /><br />
Pour vous aider à vous lancer, nous avons ajouté des informations et des astuces sur votre <a href="$5">page de discussion utilisateur</a>. En cas de question, vous pouvez répondre à cet e-mail ou consulter les <a href="http://communaute.wikia.com/wiki/Aide:Contenu">pages d\'aide de Fandom</a>.<br /><br />
Bonne réussite dans votre projet,<br /><br />
<a href="http://communaute.wikia.com/wiki/Utilisateur:$4">$3</a><br />
L\'équipe de la communauté Fandom<br /></p>',
	'passwordremindertext-HTML' => '<p>Bonjour,<br /><br />
Le mot de passe de l\'utilisateur "$2" est désormais "$3".<br /><br />
Si vous n\'avez pas demandé de nouveau mot de passe, ne vous inquiétez pas. Le mot de passe de substitution n\'a été envoyé qu\'à vous, à cette adresse e-mail. Votre compte est sain et sauf, et vous pouvez continuer à utiliser votre ancien mot de passe.<br /><br />
Merci,<br /><br />
L\'équipe de la communauté Fandom<br /><br />
www.wikia.com<br /><hr />
<ul>
<li>Pour modifier vos préférences ou changer de mot de passe, accédez à la page des <a href="http://community.wikia.com/wiki/Special:Preferences">préférences utilisateur</a>.</li>
<li>Cette demande de rappel de mot de passe a été envoyée depuis l\'adresse suivante : $1.</li>
</ul></p>',
	'confirmemail_body-HTML' => '<p>Bonjour $2,
<br /><br />
Merci de vous êtes inscrit sur Wikia !
<br /><br />
Veuillez prendre une minute pour activer votre nouveau compte en <a href="$3">confirmant votre adresse e-mail</a>.
<br /><br />
Prêt à commencer ?<br>
<ul><li>Regardez l\'<a href="{{fullurl:{{ns:special}}:WikiActivity}}">activité récente</a> de la communauté que vous venez de rejoindre ! Commencez à contribuer en laissant des commentaires ou en modifiant des pages.</li>
<li><a href="http://fr.wikia.com/Wikia">Découvrez</a> quelques wikias de jeux vidéo, divertissement et mode de vie.</li>
<li>Rencontrez la communauté Wikia, restez informé des derniers évènements et trouvez de l\'aide, tout cela sur le <a href="http://communaute.wikia.com/wiki/Centre_des_communautés">Centre des communautés</a>.</li></ul>
<br />
Bonnes modifications !<br>
— L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les e-mails que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>',
	'createaccount-text-HTML' => '<p>
Quelqu’un a créé un compte pour votre adresse e-mail sur {{SITENAME}} ($4), « $2 », avec le mot de passe « $3 ».<br />
Vous devriez ouvrir une session et modifier dès à présent votre mot de passe.<br />
<br />
Ignorez ce message si ce compte a été créé par erreur.<br />
</p>',
	'enotif_body-HTML' => '<p>$WATCHINGUSERNAME,
<br /><br />
Une des pages que vous suivez sur {{SITENAME}}, $PAGETITLE, a été modifiée par $PAGEEDITOR.
<br /><br />
Voulez-vous savoir ce qui a été fait ?  Consultez <a href="$PAGETITLE_URL">$PAGETITLE</a> pour voir la version actuelle.
<br /><br />
$NEWPAGEHTML
<br /><br />
$PAGESUMMARY
<br /><br />
— L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les e-mails que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner de tous les e-mails de Wikia.</div>',
	'enotif_body_article_comment-HTML' => '<p>$WATCHINGUSERNAME,
<br /><br />
Un nouveau commentaire a été laissé sur « $PAGETITLE » sur {{SITENAME}}. Utilisez <a href="$PAGETITLE_URL#WikiaArticleComments">ce lien</a> pour voir tous les commentaires.
<br /><br />
— L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les e-mails que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="http://communaute.wikia.com/Special:Preferences">ici</a> pour vous désabonner de tous les e-mails de Wikia.</div>',
	'enotif_lastvisited-HTML' => 'Pour toutes les modifications depuis votre dernière visite, <a href="$1">cliquez ici</a>',
	'founderemails-email-user-registered-body-HTML' => 'Bonjour $USERNAME,<br /><br />
On dirait que $EDITORNAME a créé un compte sur votre wikia ! Pourquoi ne pas passer lui dire bonjour sur sa <a href="$EDITORTALKPAGEURL">page de discussion</a> ?<br /><br />

<p style="line-height: 150%;font-family:Arial,sans-serif;color: #333;">– L’équipe Wikia</p>
<br /><hr />
<p>
<ul>
<li><a href="http://communaute.wikia.com">Venez voir les derniers évènements sur Wikia !</a></li>
<li>Vous souhaitez contrôler les e-mails que vous recevez ? Rendez-vous sur vos <a href="{{fullurl:{{ns:special}}:Preferences}}">préférences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Cliquez <a href="$UNSUBSCRIBEURL">ici</a> pour vous désabonner à tous les e-mails de Wikia.</div>',
];

$messages['it'] = [
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
	'autocreatewiki-welcomebody-HTML' => '<p>Ciao $2,<br /><br />
La wiki che hai creato è ora disponibile su <a href="$1">$1</a>.  Ci auguriamo di vederti contribuire lì presto!<br /><br />
Abbiamo aggiunto delle informazioni e suggerimenti nella tua <a href="$5">pagina di discussione utente</a> per aiutarti a iniziare. Se hai domande, rispondi semplicemente a questa e-mail o leggi le nostre guide sull\'<a href="http://it.community.wikia.com/wiki/Aiuto:Contenuti">Aiuto di Fandom</a>.<br /><br />
Buona fortuna con il tuo progetto,<br /><br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Team della community di Fandom<br /></p>',
	'passwordremindertext-HTML' => '<p>Ciao,<br /><br />
La password di accesso per l\'utente "$2" è ora "$3".<br /><br />
Se non hai richiesto una nuova password, non ti preoccupare. La password sostitutiva è stata inviata solo a te a questo indirizzo e-mail. Il tuo account è sicuro e puoi continuare a usare la tua vecchia password.<br /><br />
Grazie,<br /><br />
Il team della community di Fandom<br /><br />
www.wikia.com<br /><hr />
<ul>
<li>Per modificare le tue preferenze o la password, vai su: <a href="http://it.community.wikia.com/wiki/Speciale:Preferenze">Preferenze Utente</a>.</li>
<li>Questo promemoria sulla password è stato richiesto dal seguente indirizzo: $1.</li>
</ul></p>',
	'confirmemail_body-HTML' => '<p>
Qualcuno, probabilmente tu stesso dall\'indirizzo IP $1, ha registrato l\'account "$2" su {{SITENAME}} indicando questo indirizzo e-mail.
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
	'createaccount-text-HTML' => '<p>
Qualcuno ha creato un accesso a {{SITENAME}} ($4) a nome di $2, associato a questo indirizzo di posta elettronica. La password per l\'utente "$2" è impostata a "$3".<br />
È opportuno eseguire un accesso quanto prima e cambiare la password immediatamente.<br />
<br /><br />
Se l\'accesso è stato creato per errore, si può ignorare questo messaggio.<br />
</p>',
	'enotif_body-HTML' => '<p>
Gentile $WATCHINGUSERNAME,<br />
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
];

$messages['pl'] = [
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
	'passwordremindertext-HTML' => '<p>Cześć,<br /><br />
Hasło do konta użytkownika „$2” zostało zmienione na „$3”.<br /><br />
Jeżeli nie prosiłeś o zmianę hasła, nie przejmuj się. Nowe hasło zostało wysłane do ciebie wyłącznie pod ten adres e-mail. Twoje konto jest bezpieczne i możesz nadal używać swojego starego hasła.<br /><br />
Pozdrawiamy,<br /><br />
Zespół Społeczności Fandom<br /><br />
http://pl.wikia.com/Wikia<br /><hr />
<ul>
<li>Żeby zmienić hasło lub ustawienia konta, wejdź na stronę <a href="http://community.wikia.com/wiki/Special:Preferences">Preferencje Użytkownika</a>.</li>
<li>Prośba o przypomnienie hasła została wysłana z następującego adresu IP: $1.</li>
</ul></p>',
	'autocreatewiki-welcomebody-HTML' => '"<p>Cześć $2,<br /><br />
Wiki, którą stworzyłeś jest dostępna tutaj: <a href="$1">$1</a>. Mamy nadzieję już niedługo zobaczyć pierwsze efekty twoich edycji!<br /><br />
Do twojej <a href="$5">strony dyskusji</a> dodaliśmy przydatne informacje i porady, które pomogą Ci postawić pierwsze kroki z Fandom. Jeżeli masz jakieś pytania, po prostu odpisz na ten e-mail lub poszukaj odpowiedzi na <a href="http://spolecznosc.wikia.com/wiki/Pomoc:Zawarto%C5%9B%C4%87">stronach pomocy portalu Fandom</a>.<br /><br />
Powodzenia,<br /><br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Zespół Społeczności portalu Fandom<br /></p>',
	'confirmemail_body-HTML' => '<p>
Ktoś łącząc się z komputera o adresie IP $1<br/ >
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
	'createaccount-text-HTML' => '<p>
Ktoś utworzył w {{GRAMMAR:MS.lp|{{SITENAME}}}} ($4), podając Twój adres e‐mail, konto „$2”. Aktualnym hasłem jest „$3”.<br />
Zaloguj się teraz i je zmień.<br />
<br />
Możesz zignorować tę wiadomość, jeśli konto zostało utworzone przez pomyłkę.<br />
</p>',
	'enotif_body-HTML' => 'Witaj $WATCHINGUSERNAME,
<br /><br />
Strona $PAGETITLE na {{SITENAME}} została zmieniona przez użytkownika $PAGEEDITOR.
<br /><br />
Zobacz na stronie <a href="$PAGETITLE_URL">$PAGETITLE</a> aktualną wersję.
<br /><br />
$NEWPAGEHTML
<br /><br />
$PAGESUMMARY
<br /><br />
— Zespół Wikii


<br /><hr />
<p>
<ul>
<li>Aby uzyskać dodatkową pomoc od społeczności Wikii, odwiedź <a href="http://spolecznosc.wikia.com">Centrum Społeczności</a>.</li>
<li>W celu zmiany ustawień powiadomień e-mail, odwiedź <a href="http://spolecznosc.wikia.com/wiki/Special:Preferences">tą stronę</a>.</li>
</ul>
</p>',
	'enotif_body_article_comment-HTML' => '<p>Witaj $WATCHINGUSERNAME,
<br /><br />
Na {{SITENAME}} pojawił się nowy komentarz na stronie $PAGETITLE . Użyj tego linku aby zobaczyć wszystkie komentarze: <a href="$PAGETITLE_URL#WikiaArticleComments">$PAGETITLE</a>
<br /><br />
- Zespół Wikii
<br /><br />
___________________________________________
<ul>
<li>Aby uzyskać dodatkową pomoc od społeczności Wikii, odwiedź <a href="http://spolecznosc.wikia.com">Centrum Społeczności</a>.</li>
<li>W celu zmiany ustawień powiadomień e-mail, odwiedź <a href="http://spolecznosc.wikia.com/wiki/Special:Preferences">tą stronę</a>.</li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => 'Aby zobaczyć wszystkie zmiany od Twojej ostatniej wizyty, <a href="$1">kliknij tutaj</a>',
];

$messages['sv'] = [
	'autocreatewiki-welcomebody-HTML' => '<p>
Hej $2,<br />
<br />
Wikia du skapat är nu tillgänglig på <a href="$1">$1</a>. Vi hoppas att ni redigering där snart!<br />
<br />
Vi har lagt till lite information och tips om din <a href="$5">användardiskussionsida</a> för att hjälpa dig komma igång. Om du har några frågor, bara svara på denna post eller bläddra våra hjälpsidor på <a href="http://hjalp.wikia.com/">Wikia Hjälp</a>.<br />
<br />
Lycka till med projektet,<br />
<br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Wikia Community Support <br />
</p>',
	'passwordremindertext-HTML' => '<p>
Hej,<br />
Inloggningslösenordet för användaren "$2" är nu "$3".<br />
Om du inte begära ett nytt lösenord, oroa dig inte. Att ersätta lösenord har skickats bara till dig på denna e-postadress. Ditt konto är säkert och du kan fortsätta använda ditt gamla lösenord.<br />
<br />
Tack,
<br /><br />
Wikia Community Team
<br /><br />
www.wikia.com
<br />
<hr />
<ul>
<li>Om du vill ändra dina inställningar eller lösenord, gå till: <a href="http://community.wikia.com/wiki/Special:Preferences">Användarinställningar</a>.</li>
<li>Detta lösenord påminnelse begärdes från följande adress: $1.</li>
</ul>
</p>',
	'confirmemail_body-HTML' => '<p>
Hej $2,<br />
<br />
Tack för din registrering med Wikia.<br />
<br />
Vänligen aktivera det nya kontot genom att <a href="$3">bekräftar din e-postadress här</a>.<br />
<br />
<br />
Vi ser fram emot att se dig snart!<br />
<br />
Wikia Community Team<br />
<a href="http://community.wikia.com/">community.wikia.com</a><br />
</p>',
	'createaccount-text-HTML' => '<p>
Någon har skapat ett konto åt din e-postadress på {{SITENAME}} ($4) med namnet "$2" och lösenordet "$3".<br />
Du bör nu logga in och ändra ditt lösenord.
<br /><br />
Du kan ignorera detta meddelande om kontot skapats av misstag.
</p>',
];

$messages['zh'] = [
	'autocreatewiki-welcomebody-HTML' => '<p>嗨 $2,<br /><br />
您创建的Wiki已经可以在 <a href="$1">$1</a>访问。 期望很快能看到您的编辑！<br /><br />
我们在您的<a href="$5">用户对话页</a>提供了一些资讯来协助您开始。如果有任何问题，可以浏览我们的 <a href="http://zh.community.wikia.com/wiki/help:content">帮助中心</a>.<br /><br />
祝一切顺利。<br /><br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Wikia社区团队<br /></p>',
	'passwordremindertext-HTML' => '<p>您好<br /><br />
用户"$2" 的密码已更新为"$3"。<br /><br />
如果您并没有申请新帐号，请别担心。这个临时密码仅仅由这个电子信箱寄给您，因此您的帐号是安全的，您也可以继续使用旧密码登入。<br /><br />
谢谢,<br /><br />
Wikia 社区团队<br /><br />
www.wikia.com<br /><hr />
<ul>
<li>要改更您的个人设定或密码，请进入: <a href="http://zh.community.wikia.com/wiki/Special:Preferences">用户设定</li>
<li>这个密码提醒是由以下IP位址所申请发送： $1.</li>
</ul></p>',
	'confirmemail_body-HTML' => '<p> $2您好,<br /><br />
谢谢您在Wikia注册帐号。<br /><br />
请<a href="$3">点击这里确认您的电子邮件地址confirming your e-mail </a>以激活您的帐号<br /><br /><br />
我们期待很快能见到您！<br /><br />
Wikia支持团队<br />
<a href="http://zh.community.wikia.com/">zh.community.wikia.com</a><br /></p>',
	'createaccount-text-HTML' => '<p>有人用你的电子邮件地址在{{SITENAME}} ($4) 创建了名为"$2"的帐号，密码为 "$3".<br />
你应该立刻登入并更改你的密码。<br /><br />
如果你并没有申请这个帐号，请直接忽略这个讯息。</p>',
	'enotif_body-HTML' => '<p>亲爱的 $WATCHINGUSERNAME,<br /><br />
有人编辑了你在{{SITENAME}}监视的页面。<br /><br />
点击进入 <a href="$PAGETITLE_URL">$PAGETITLE</a>查看目前的版本。<br /><br />
$NEWPAGEHTML<br /><br />
$PAGESUMMARY<br /><br />
请常访问和编辑<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li><a href="http://zh.wikia.com">查看我们的特色Wiki社区！</a></li>
<li>想要设定收到的电子邮件通知，请造访<a href="{{fullurl:{{ns:special}}:Preferences}}">用户设定</a></li>
</ul></p>',
	'enotif_body_article_comment-HTML' => '<p>Hi，$WATCHINGUSERNAME,
<br /><br />
{{SITENAME}}上的$PAGETITLE有评论哦。点击如下链接查看全部评论：
<br /><br />
依如下链接查看评论：<a href="$PAGETITLE_URL">$PAGETITLE</a>$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia社区支持
<br /><br />

___________________________________________
<ul>
<li>在社区中心寻求帮助或建议：<a href="http://zh.community.wikia.com">http://zh.community.wikia.com</a><li>
<li>管理您收到的邮件，退订或改变邮件设置请点击： <a href="http://zh.community.wikia.com/Special:Preferences">http://zh.community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => '<a href="$1">点击这里</a>来查看自从你上次造访该页面后的所有更改。',
	'founderemails-email-page-edited-body-HTML' => '<strong>嗨 $1,</strong><br /><br />
$2 编辑了你的 wiki! 何不到他们的<a href="$3">用户页</a>打个招呼？<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia 团队</div>',
];

$messages['zh-hans'] = [
	'autocreatewiki-welcomebody-HTML' => '<p>您好$2,<br /><br />
您所创建的维基已经存在于<a href="$1">$1</a>。我们希望您可以尽快去那里编辑！<br /><br />
同时，我们已经在您的<a href="$5">用户对话页</a>添加了一些入门信息和技巧供您查看。如果您有任何问题，可以回复这封邮件或者访问<a href="http://zh.help.wikia.com/">Fandom帮助</a>查看所有帮助页。<br /><br />
祝您编辑一切顺利！<br /><br />
<a href="http://zh.community.wikia.com/wiki/User:$4">$3</a><br />
Fandom社区团队<br /></p>',
	'passwordremindertext-HTML' => '<p>你好，<br /><br />
用户"$2"的登入密码是"$3"。<br /><br />
如果您没有申请一个新的密码，请不要担心。重置密码只发送至您所使用的电子邮件，您的帐户十分安全。您可以继续使用旧密码登入。 <br /><br />
谢谢！<br /><br />
Fandom社区团队<br /><br />
www.wikia.com<br /><br />
<ul>
<li>若要更改您的个人设置或密码，请访问：<a href="http://zh.community.wikia.com/wiki/Special:Preferences">个人设置</a>。</li>
<li>密码提醒来源于以下地址：$1。</li>
</ul></p>',
	'confirmemail_body-HTML' => '<p> $2您好,<br /><br />
谢谢您在Wikia注册帐号。<br /><br />
请<a href="$3">点击这里确认您的电子邮件地址confirming your e-mail </a>以激活您的帐号<br /><br /><br />
我们期待很快能见到您！<br /><br />
Wikia支持团队<br />
<a href="http://zh.community.wikia.com/">zh.community.wikia.com</a><br /></p>',
	'createaccount-text-HTML' => '<p>有人用你的电子邮件地址在{{SITENAME}} ($4) 创建了名为"$2"的帐户，密码为 "$3".<br />
你应该立刻登入并更改你的密码。<br /><br />
如果你并没有申请这个帐户，请直接忽略这个讯息。</p>',
	'enotif_body-HTML' => '<p>亲爱的 $WATCHINGUSERNAME,<br /><br />
有人编辑了你在{{SITENAME}}监视的页面。<br /><br />
点击进入 <a href="$PAGETITLE_URL">$PAGETITLE</a>查看目前的版本。<br /><br />
$NEWPAGEHTML<br /><br />
$PAGESUMMARY<br /><br />
请常访问和编辑<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li><a href="http://zh.wikia.com">查看我们的特色Wiki社区！</a></li>
<li>想要设定收到的电子邮件通知，请造访<a href="{{fullurl:{{ns:special}}:Preferences}}">用户设定</a></li>
</ul></p>',
	'enotif_body_article_comment-HTML' => '<p>Hi，$WATCHINGUSERNAME,
<br /><br />
{{SITENAME}}上的$PAGETITLE有评论哦。点击如下链接查看全部评论：
<br /><br />
依如下链接查看评论：<a href="$PAGETITLE_URL">$PAGETITLE</a>$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia社区支持
<br /><br />

___________________________________________
<ul>
<li>在社区中心寻求帮助或建议：<a href="http://zh.community.wikia.com">http://zh.community.wikia.com</a><li>
<li>管理您收到的邮件，退订或改变邮件设置请点击： <a href="http://zh.community.wikia.com/Special:Preferences">http://zh.community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => '<a href="$1">点击这里</a>来查看自从你上次造访该页面后的所有更改。',
	'founderemails-email-page-edited-body-HTML' => '<strong>嗨 $1,</strong><br /><br />
$2 编辑了你的 wiki! 何不到他们的<a href="$3">用户页</a>打个招呼？<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia 团队</div>',
];

$messages['zh-hant'] = [
	'autocreatewiki-welcomebody-HTML' => '<p>您好$2，<br /><br />
您所創建的wiki已經存在於<a href="$1">$1</a>。我們希望您可以盡快去那裡編輯！<br /><br />
同時，我們已經在您的<a href="$5">用戶對話頁</a>添加了一些入門訊息和技巧供您查看。如果您有任何問題，可以回复這封郵件或者訪問<a href="http://help.wikia.com/">Fandom幫助</a>查看所有幫助頁。<br /><br />
祝您編輯一切順利！<br /><br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Fandom社區團隊<br /></p>',
	'passwordremindertext-HTML' => '<p>你好，<br /><br />
用戶"$2"的登入密碼是"$3"。<br /><br />
如果您沒有申請一個新的密碼，請不要擔心。重置密碼只發送至您所使用的電子郵件，您的帳戶十分安全。您可以繼續使用舊密碼登入。<br /><br />
謝謝！<br /><br />
Fandom社區團隊<br /><br />
www.wikia.com<br /><br />
<ul>
<li>若要更改您的個人設置或密碼，請訪問：<a href="http://community.wikia.com/wiki/Special:Preferences">個人設置</a>。</li>
<li>密碼提醒來源於以下地址：$1。</li>
</ul></p>',
	'confirmemail_body-HTML' => '<p> $2您好,<br /><br />
謝謝您在Wikia註冊帳號。<br /><br />
請<a href="$3">點擊這裡確認您的電子郵件地址confirming your e-mail </a>以啟用您的帳號<br /><br /><br />
我們期待很快能見到您！<br /><br />
Wikia支持團隊<br />
<a href="http://zh.community.wikia.com/">zh.community.wikia.com</a><br /></p>',
	'createaccount-text-HTML' => '<p>有人用你的電子郵件地址在{{SITENAME}} ($4) 創建了名為"$2"的帳號，密碼為 "$3".<br />
你應該立刻登入並更改你的密碼。<br /><br />
如果你並沒有申請這個帳號，請直接忽略這個訊息。</p>',
	'enotif_body-HTML' => '<p>親愛的 $WATCHINGUSERNAME,<br /><br />
有人編輯了你在{{SITENAME}}監視的頁面。<br /><br />
點擊進入 <a href="$PAGETITLE_URL">$PAGETITLE</a>查看目前的版本。<br /><br />
$NEWPAGEHTML<br /><br />
$PAGESUMMARY<br /><br />
請常訪問和編輯<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li><a href="http://zh-tw.wikia.com">查看我們的特色Wiki社區！</a></li>
<li>想要設定收到的電子郵件通知，請造訪<a href="{{fullurl:{{ns:special}}:Preferences}}">用戶設定</a></li>
</ul></p>',
	'enotif_body_article_comment-HTML' => '<p>Hi，$WATCHINGUSERNAME,
<br /><br />
{{SITENAME}} 上的 $PAGETITLE 有新評論。
<br /><br />
點此連結查看評論：<a href="$PAGETITLE_URL">$PAGETITLE</a>$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia 社群支援小組
<br /><br />

___________________________________________
<ul>
<li>您可在社區中心尋找協助和建議：<a href="http://zh.community.wikia.com">http://community.wikia.com</a><li>
<li>不想收到這麼多訊息？您可以在以下頁面退訂或變更電子信箱設定：<a href="http://zh.community.wikia.com/Special:Preferences">http://zh.community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => '<a href="$1">點擊這裡</a>來查看自從你上次造訪該頁面後的所有更改。',
	'founderemails-email-page-edited-body-HTML' => '<strong>嗨 $1,</strong><br /><br />
$2 編輯了你的 wiki! 何不到他們的<a href="$3">用戶頁</a>打個招呼？<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia 團隊</div>',
	'founderemails-email-user-registered-body-HTML' => '嗨$USERNAME,<br /><br />
$EDITORNAME在你的Wiki上註冊了！何不訪問一下新成員的<a href="$EDITORTALKPAGEURL">對話頁</a>去打個招呼呢？<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia團隊</div>',
];

$messages['zh-hk'] = [
	'autocreatewiki-welcomebody-HTML' => '<p>嗨 $2,<br /><br />
您創建的Wiki已經可以在 <a href="$1">$1</a>訪問。 期望很快能看到您的編輯！<br /><br />
我們在您的<a href="$5">用戶對話頁</a>提供了一些資訊來協助您開始。如果有任何問題，可以瀏覽我們的 <a href="http://zh.community.wikia.com/wiki/help:content">幫助中心</a>.<br /><br />
祝一切順利。<br /><br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Wikia社區團隊<br /></p>',
	'passwordremindertext-HTML' => '<p>您好<br /><br />
用戶"$2" 的密碼已更新為"$3"。<br /><br />
如果您並沒有申請新帳號，請別擔心。這個臨時密碼僅僅由這個電子信箱寄給您，因此您的帳號是安全的，您也可以繼續使用舊密碼登入。<br /><br />
謝謝,<br /><br />
Wikia 社區團隊<br /><br />
www.wikia.com<br /><hr />
<ul>
<li>要改更您的個人設定或密碼，請進入: <a href="http://zh.community.wikia.com/wiki/Special:Preferences">用戶設定</li>
<li>這個密碼提醒是由以下IP位址所申請發送： $1.</li>
</ul></p>',
	'confirmemail_body-HTML' => '<p> $2您好,<br /><br />
謝謝您在Wikia註冊帳號。<br /><br />
請<a href="$3">點擊這裡確認您的電子郵件地址confirming your e-mail </a>以啟用您的帳號<br /><br /><br />
我們期待很快能見到您！<br /><br />
Wikia支持團隊<br />
<a href="http://zh.community.wikia.com/">zh.community.wikia.com</a><br /></p>',
	'createaccount-text-HTML' => '<p>有人用你的電子郵件地址在{{SITENAME}} ($4) 創建了名為"$2"的帳號，密碼為 "$3".<br />
你應該立刻登入並更改你的密碼。<br /><br />
如果你並沒有申請這個帳號，請直接忽略這個訊息。</p>',
	'enotif_body-HTML' => '<p>親愛的 $WATCHINGUSERNAME,<br /><br />
有人編輯了你在{{SITENAME}}監視的頁面。<br /><br />
點擊進入 <a href="$PAGETITLE_URL">$PAGETITLE</a>查看目前的版本。<br /><br />
$NEWPAGEHTML<br /><br />
$PAGESUMMARY<br /><br />
請常訪問和編輯<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li><a href="http://zh-tw.wikia.com">查看我們的特色Wiki社區！</a></li>
<li>想要設定收到的電子郵件通知，請造訪<a href="{{fullurl:{{ns:special}}:Preferences}}">用戶設定</a></li>
</ul></p>',
	'enotif_body_article_comment-HTML' => '<p>Hi，$WATCHINGUSERNAME,
<br /><br />
{{SITENAME}} 上的 $PAGETITLE 有新評論。
<br /><br />
點此連結查看評論：<a href="$PAGETITLE_URL">$PAGETITLE</a>$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia 社群支援小組
<br /><br />

___________________________________________
<ul>
<li>您可在社區中心尋找協助和建議：<a href="http://zh.community.wikia.com">http://community.wikia.com</a><li>
<li>不想收到這麼多訊息？您可以在以下頁面退訂或變更電子信箱設定：<a href="http://zh.community.wikia.com/Special:Preferences">http://zh.community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => '<a href="$1">點擊這裡</a>來查看自從你上次造訪該頁面後的所有更改。',
	'founderemails-email-page-edited-body-HTML' => '<strong>嗨 $1,</strong><br /><br />
$2 編輯了你的 wiki! 何不到他們的<a href="$3">用戶頁</a>打個招呼？<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia 團隊</div>',
	'founderemails-email-user-registered-body-HTML' => '嗨$USERNAME,<br /><br />
$EDITORNAME在你的Wiki上註冊了！何不訪問一下新成員的<a href="$EDITORTALKPAGEURL">對話頁</a>去打個招呼呢？<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia團隊</div>',
];

$messages['zh-tw'] = [
	'autocreatewiki-welcomebody-HTML' => '<p>嗨 $2,<br /><br />
您創建的Wiki已經可以在 <a href="$1">$1</a>訪問。 期望很快能看到您的編輯！<br /><br />
我們在您的<a href="$5">用戶對話頁</a>提供了一些資訊來協助您開始。如果有任何問題，可以瀏覽我們的 <a href="http://zh.community.wikia.com/wiki/help:content">幫助中心</a>.<br /><br />
祝一切順利。<br /><br />
<a href="http://community.wikia.com/wiki/User:$4">$3</a><br />
Wikia社區團隊<br /></p>',
	'passwordremindertext-HTML' => '<p>您好<br /><br />
用戶"$2" 的密碼已更新為"$3"。<br /><br />
如果您並沒有申請新帳號，請別擔心。這個臨時密碼僅僅由這個電子信箱寄給您，因此您的帳號是安全的，您也可以繼續使用舊密碼登入。<br /><br />
謝謝,<br /><br />
Wikia 社區團隊<br /><br />
www.wikia.com<br /><hr />
<ul>
<li>要改更您的個人設定或密碼，請進入: <a href="http://zh.community.wikia.com/wiki/Special:Preferences">用戶設定</li>
<li>這個密碼提醒是由以下IP位址所申請發送： $1.</li>
</ul></p>',
	'confirmemail_body-HTML' => '<p> $2您好,<br /><br />
謝謝您在Wikia註冊帳號。<br /><br />
請<a href="$3">點擊這裡確認您的電子郵件地址confirming your e-mail </a>以啟用您的帳號<br /><br /><br />
我們期待很快能見到您！<br /><br />
Wikia支持團隊<br />
<a href="http://zh.community.wikia.com/">zh.community.wikia.com</a><br /></p>',
	'createaccount-text-HTML' => '<p>有人用你的電子郵件地址在{{SITENAME}} ($4) 創建了名為"$2"的帳號，密碼為 "$3".<br />
你應該立刻登入並更改你的密碼。<br /><br />
如果你並沒有申請這個帳號，請直接忽略這個訊息。</p>',
	'enotif_body-HTML' => '<p>親愛的 $WATCHINGUSERNAME,<br /><br />
有人編輯了你在{{SITENAME}}監視的頁面。<br /><br />
點擊進入 <a href="$PAGETITLE_URL">$PAGETITLE</a>查看目前的版本。<br /><br />
$NEWPAGEHTML<br /><br />
$PAGESUMMARY<br /><br />
請常訪問和編輯<br /><br />
{{SITENAME}}<br /><hr />
<ul>
<li><a href="http://zh-tw.wikia.com">查看我們的特色Wiki社區！</a></li>
<li>想要設定收到的電子郵件通知，請造訪<a href="{{fullurl:{{ns:special}}:Preferences}}">用戶設定</a></li>
</ul></p>',
	'enotif_body_article_comment-HTML' => '<p>Hi，$WATCHINGUSERNAME,
<br /><br />
{{SITENAME}} 上的 $PAGETITLE 有新評論。
<br /><br />
點此連結查看評論：<a href="$PAGETITLE_URL">$PAGETITLE</a>$PAGETITLE_URL#WikiaArticleComments
<br /><br />
- Wikia 社群支援小組
<br /><br />

___________________________________________
<ul>
<li>您可在社區中心尋找協助和建議：<a href="http://zh.community.wikia.com">http://community.wikia.com</a><li>
<li>不想收到這麼多訊息？您可以在以下頁面退訂或變更電子信箱設定：<a href="http://zh.community.wikia.com/Special:Preferences">http://zh.community.wikia.com/Special:Preferences</a></li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => '<a href="$1">點擊這裡</a>來查看自從你上次造訪該頁面後的所有更改。',
	'founderemails-email-page-edited-body-HTML' => '<strong>嗨 $1,</strong><br /><br />
$2 編輯了你的 wiki! 何不到他們的<a href="$3">用戶頁</a>打個招呼？<br /><br />
<div style="font-style: italic; font-size: 120%;">-- The Wikia 團隊</div>',
	'founderemails-email-user-registered-body-HTML' => '嗨$USERNAME,<br /><br />
$EDITORNAME在你的Wiki上註冊了！何不訪問一下新成員的<a href="$EDITORTALKPAGEURL">對話頁</a>去打個招呼呢？<br /><br />
<div style="font-style: italic; font-size: 120%;">-- Wikia團隊</div>',
];

$messages['ja'] = [
	'passwordremindertext-HTML' => '<p>こんにちは。<br /><br />
$2さんのログイン用パスワードが「$3」になりました。<br /><br />
新しいパスワードをリクエストしなかった場合でも、ご安心ください。この新しいパスワードはこのメールアドレス宛にのみ送信されたもので、お使いのアカウントは安全に保護されています。また、以前のパスワードを引き続きお使いいただけます。<br /><br />
今後ともFnadomをよろしくお願いいたします。<br /><br />
Fandomコミュニティ・チーム<br /><br />
ja.wikia.com<br /><hr />
<ul>
<li>個人設定やパスワードを変更する場合は、次のページにアクセスしてください：<a href="http://ja.community.wikia.com/wiki/特別:個人設定">個人設定</a></li>
<li>このパスワードのお知らせは次のIPアドレスからリクエストされました：$1</li>
</ul></p>',
	'autocreatewiki-welcomebody-HTML' => '<p>$2さん<br /><br />
このたび作成されたwikiに、<a href="$1">$1</a>からアクセスしていただけるようになりました。さっそく、編集をお楽しみください。<br /><br />
なお、<a href="$5">ユーザー・トークページ</a>にて基本情報やヒントをいくつかご紹介しています。その他ご不明な点がある場合、このメールにご返信いただくか、<a href="http://ja.community.wikia.com/wiki/ヘルプ:コンテンツ">Fandomヘルプページ</a>をご参照ください。<br /><br />
今後ともFandomをよろしくお願いいたします。<br /><br />
<a href="http://ja.community.wikia.com/wiki/ユーザー:$4">$3</a><br />
Fandomコミュニティ・チーム<br /></p>',
	'confirmemail_body-HTML' => 'こんにちは、$2 さん
<br /><br />
ウィキアに登録していただきありがとうございます！
<br /><br />
<a href="$3">あなたのメールアドレスの確認</a>によってあなたの新しいアカウントを有効にするため少し時間をください。
<br /><br />
始める用意はできましたか？<br>
<ul><li>あなたがたったいま参加したコミュニティの<a href="{{fullurl:{{ns:special}}:WikiActivity}}">最近の活動</a>のすべてを見てください！ コメントを残すかページを編集することで投稿を始めてみてください。</li>
<li>ウィキアビデオを<a href="http://www.wikia.com/Special:LandingPage">見て</a>ゲーム、エンターテイメント、ライフスタイルの中からお気に入りのウィキアを探索してみてください。</li>
<li>ウィキアのコミュニティと接触し、何が起きているかを知り、ヘルプを探してみてください - <a href="http://ja.community.wikia.com/wiki/コミュニティセントラル">コミュニティセントラル</a>にはそれがすべてあります</li></ul>
<br />
大いに楽しんでください！<br />
- ウィキア・コミュニティサポート
<br /><hr />
<p>
<ul>
<li><a href="http://ja.community.wikia.com/wiki/">コミュニティセントラル</a>でヘルプやアドバイスを探してみましょう。</li>
<li>私たちからのメッセージの受信を減らしたいですか？ Eメールの設定を<a href="http://ja.community.wikia.com/Special:Preferences">こちら</a>で変更するか登録解除することができます。</li>
</ul>
</p>',
	'createaccount-text-HTML' => 'こんにちは<br /><br />

あなたが {{SITENAME}} でユーザー名「$2」、パスワード「$3」として作ろうとしたアカウントが作成されました。<br /><br />

$4 でログインしてください<br /><br />

もしこのアカウントが必要ない場合は、このメッセージを無視するか、 community@wikia.com に質問の問い合わせをすることができます。<br /><br />

- ウィキアコミュニティーサポート

<br /><hr />
<p>
<ul>
<li><a href="http://ja.community.wikia.com/wiki/">コミュニティセントラル</a>でヘルプやアドバイスを探してみましょう。</li>
<li>私たちが送信するメッセージの受信を減らしたいですか？ 電子メールの設定を<a href="http://ja.community.wikia.com/Special:Preferences">こちら</a>で変更するか登録解除することができます。</li>
</ul>
</p>',
	'enotif_body-HTML' => 'こんにちは、$WATCHINGUSERNAME さん
<br /><br />
あなたがフォローしている {{SITENAME}} のページ $PAGETITLE が $PAGEEDITOR によって編集されました。
<br /><br />
何が更新されたのか興味がありますか？現在のバージョンの <a href="$PAGETITLE_URL">$PAGETITLE</a> をご覧ください。
<br /><br />
$NEWPAGEHTML
<br /><br />
$PAGESUMMARY
<br /><br />
- ウィキア・コミュニティサポート


<br /><hr />
<p>
<ul>
<li><a href="http://ja.community.wikia.com/wiki/">コミュニティセントラル</a>でヘルプやアドバイスを探してみましょう。</li>
<li>私たちが送信するメッセージの受信を減らしたいですか？ 電子メールの設定を<a href="http://ja.community.wikia.com/Special:Preferences">こちら</a>で変更するか登録解除することができます。</li>
</ul>
</p>',
	'enotif_body_article_comment-HTML' => 'こんにちは、$WATCHINGUSERNAME さん
<br /><br />
{{SITENAME}} の $PAGETITLE に新しいコメントがあります。すべてのコメントを閲覧するには次のリンクをご利用ください : <a href="$PAGETITLE_URL#WikiaArticleComments">$PAGETITLE</a>
<br /><br />
- ウィキア・コミュニティ・サポート
<br /><hr />
<p>
<ul>
<li><a href="http://ja.community.wikia.com/wiki/">コミュニティセントラル</a>でヘルプやアドバイスを探してみよう。</li>
<li>私たちが送信するメッセージの受信を減らしたいですか？ <a href="http://ja.community.wikia.com/特別:Preferences">こちら</a>にて定期購読解除や電子メールの設定変更をすることができます。</li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => '最後にアクセスして以来のこのページのすべての変更を閲覧するには、<a href="$1">こちらをクリック</a>',
	'founderemails-email-user-registered-body-HTML' => '$USERNAME さん、<br /><br />
$EDITORNAME が $WIKINAME に参加しました。<br /><br />
歓迎のメッセージを送るなどして、編集してもらえるように誘導してきましょう。参加者が多ければ多いほど、ウィキの成長は早まります。<br /><br />
トークページ:<br />
<a href="$EDITORTALKPAGEURL">$EDITORTALKPAGEURL</a><br /><br />
-- ウィキアチーム',
];

$messages['qqq'] = [
	'autocreatewiki-welcomebody-HTML' => 'Missing documentation',
	'passwordremindertext-HTML' => 'Missing documentation',
];

$messages['pt'] = [
	'autocreatewiki-welcomebody-HTML' => '<p>Olá $2,<br/><br /> 
A wiki que você criou está disponível agora em <a href="$1">$1</a>. Esperamos vê-lo editando por lá em breve!
<br />< br /> 
Nós adicionamos algumas informações e dicas em seu <a href="$5">mural de mensagens </a> para ajudá-lo a começar. Se você tiver alguma dúvida, basta responder a este e-mail ou procurar em nossas páginas de ajuda em <a href="http://comunidade.wikia.com/Ajuda:Conteúdos"> Ajuda do Fandom</a>.< br /><br />
Boa sorte com o projeto, <br />< br / >
<a href="http://comunidade.wikia.com/wiki/User:$4">$3</a><br />
 Equipe da comunidade Fandom <br /></p>',
	'passwordremindertext-HTML' => '<p>Olá,<br /><br />
A senha do usuário "$2" é agora "$3".<br /><br />
Se você não solicitou uma nova senha, não se preocupe. A senha de substituição foi enviada apenas para você neste endereço de e-mail. Sua conta é segura e você pode continuar a usar sua senha antiga.<br /><br />
Obrigado,<br /><br />
Equipe da comunidade Fandom<br /><br />
www.wikia.com<br /><hr />
<ul>
<li>Para alterar suas preferências ou a senha, vá para <a href="http://comunidade.wikia.com/wiki/Especial:Preferências">Preferências</a>.</li>
<li>Este lembrete de senha foi solicitado no seguinte endereço: $1.</li>
</ul></p>',
];

$messages['ru'] = [
	'autocreatewiki-welcomebody-HTML' => '<p>Здравствуйте, $2!<br /><br />
Созданная вами вики доступна по адресу <a href="$1">$1</a>. Мы надеемся, что вы скоро начнете её развивать. <br /><br />
Чтобы вам помочь, мы добавили информацию и полезные советы на вашу <a href="$5">стену обсуждения</a>. Если у вас есть вопросы, ответьте на это письмо или просмотрите наши справочные статьи в <a href="http://ru.community.wikia.com/wiki/Справка:Содержание">Справке Фэндома</a>. <br /><br />Желаем вам удачи в работе над вашим википроектом!<br /><br /><a href="http://ru.community.wikia.com/wiki/User:$4">$3</a><br /> 
Команда Фэндома<br /></p>',
	'passwordremindertext-HTML' => '<p>Здравствуйте,<br /><br />
Новый пароль для учётной записи «$2» — «$3».<br /><br />
Если вы не запрашивали смену пароля, не переживайте. Новый пароль был отправлен только вам на этот адрес электронной почты. Ваша учётная запись надежно защищена и вы можете продолжать использовать ваш старый пароль.<br /><br />
Команда Фэндома<br /><br />
www.wikia.com<br /><br />
<ul>
<li>Чтобы изменить настройки или пароль, перейдите в <a href="http://community.wikia.com/wiki/Special:Preferences">личные настройки</a>.
</li>
<li>Запрос на отправку этого письма был получен с адреса $1.</li>
</ul></p>',
	'enotif_body-HTML' => 'Здравствуйте, $WATCHINGUSERNAME.
<br /><br />
Одна из страниц, которую Вы отслеживаете, $PAGETITLE на {{SITENAME}}, была отредактирована $PAGEEDITOR.
<br /><br />
Хотите узнать, что изменилось? Зайдите на <a href="$PAGETITLE_URL">$PAGETITLE</a>, чтобы увидеть текущую версию страницы.
<br /><br />
$NEWPAGEHTML
<br /><br />
$PAGESUMMARY
<br /><br />
- Команда Викия


<br /><hr />
<p>
<ul>
<li>Найти помощь и совет можно на <a href="http://www.community.wikia.com">Community Central</a> и <a href="http://www.ru.community.wikia.com">Вики Сообщества</a>.</li>
<li>Хотите уменьшить количество данных писем? Вы можете отписаться от рассылки или внести в неё коррективы на <a href="http://community.wikia.com/Special:Preferences">странице личных настроек</a>.</li>
</ul>
</p>',
	'enotif_body_article_comment-HTML' => '<p>Уважаемый $WATCHINGUSERNAME,
<br /><br />
Участник $PAGEEDITOR оставил комментарий на "$PAGETITLE".
<br /><br />
Чтобы увидеть данный комментарий, проследуйте по этой ссылке: <a href="$PAGETITLE_URL">$PAGETITLE</a>
<br /><br />
Викия
<br /><hr />
<ul>
<li>Чтобы настроить уведомления по email, <a href="{{fullurl:Special:Preferences}}">обновите личные настройки<a>.</li>
</ul>
</p>',
	'enotif_lastvisited-HTML' => 'Чтобы просмотреть все изменения, произошедшие с вашего последнего посещения 
это страницы, <a href="$1">нажмите здесь</a>',
];

$messages['fa'] = [
	'confirmemail_body-HTML' => 'سلام $2،

از ثبت‌نام شما در ویکیا متشکریم! <br>

لطفا با <a href="$3">تایید آدرس پست الکترونیکی خود</a> یک دقیقه صرف فعال‌سازی حساب کاربری جدید خود کنید.<br>

آماده‌اید برای شروع؟<br>

<ul><li>یک نگاهی به تمام <a href="{{fullurl:{{ns:special}}:WikiActivity}}">فعالیت‌های اخیر</a> جامعه‌ای که پیوسته‌اید بکنید! فعالیت خود را با گذاشتن پیغام و یا ویرایش صفحات آغاز کنید.</li>
<li>ویدیوی ویکیا را <a href="http://www.wikia.com/Special:LandingPage">تماشا</a> و شروع کنید به کاوش‌کردن در یکی از ویکی‌های مورد علاقۀ ما در بازی‌ها، سرگرمی‌ها، و شیوۀ زندگی.
</li>
<li>با جامعۀ ویکیا دیدار داشته‌باشید، آنچه در حال اتفاق افتادن است را بیاموزید، و کمک پیدا کنید - همه را در<a href="http://community.wikia.com/wiki/Community_Central">ویکیای مرکزی</a>.</li></ul>


خوش باشید!<br/>

- بخش پشتبانی جامعۀ ویکیا<br>

<br /><hr />
<p>
<ul>
<li>Find help and advice on <a href="http://community.wikia.com">Community Central</a>.</li>
<li>Want to control which emails you receive? Go to <a href="{{fullurl:{{ns:special}}:Preferences}}">User Preferences</a></li>
</ul>
</p>
<div style="font-size: 70%;margin-top: 25px;text-align: center;">Click <a href="$UNSUBSCRIBEURL">here</a> to unsubscribe from all Wikia emails.</div>',
];

$messages['ko'] = [
	'confirmemail_body-HTML' => '안녕하세요, $2 님.
<br /><br />
위키아에 가입해주셔서 감사합니다!
<br /><br />
<a href="$3">이곳</a>에서 이메일 주소를 인증해 계정을 활성화해 주세요.
<br /><br />
시작할 준비가 되셨나요?<br>
<ul><li>귀하가 참여한 커뮤니티에서 <a href="{{fullurl:{{ns:special}}:WikiActivity}}">최근 일어난 일</a>들을 알아 보세요! 댓글을 남기거나 문서를 편집해 기여를 시작하실 수 있습니다.</li>
<li><a href="http://www.wikia.com/Special:LandingPage">영상</a>을 시청하시고 저희가 추천해드리는, 게임, 엔터테인먼트, 생활 등 다양한 분야의 위키를 탐방해 보시는 건 어떨까요?</li>
<li><a href="http://ko.community.wikia.com/wiki/">위키아 중앙 커뮤니티</a>에서 다양한 사람들과 대화를 나누고, 도움을 구해 보세요.</li></ul>
<br />
즐거운 위키아 이용 되세요!<br>
- 위키아 커뮤니티 지원팀
<br /><hr />
<p>
<ul>
<li>위키아 중앙 커뮤니티에서 도움을 구하실 수 있습니다: <a href="http://ko.community.wikia.com">위키아 중앙 커뮤니티</a>.</li>
<li>알림을 받고 싶지 않으신가요? 이곳에서 알림 설정을 변경하실 수 있습니다: <a href="http://ko.community.wikia.com/특수기능:환경설정">특수기능:환경설정</a></li>',
	'enotif_body_article_comment-HTML' => '<p> $WATCHINGUSERNAME님, <br /><br /> $PAGEEDITOR 사용자가 "$PAGETITLE" 문서에 댓글을 남겼습니다. <br /><br /> 댓글을 보시려면 다음 링크로 들어가세요: <a href="$PAGETITLE_URL">$PAGETITLE</a> <br /><br /> 자주 방문해주시고 기여도 많이 부탁드립니다. <br /><br /> {{SITENAME}} <br /><hr /> <ul> <li>메일로 알림받는 항목들을 관리하고 싶으신가요? <a href="{{fullurl:{{ns:special}}:환경설정}}">{{ns:special}}:환경설정<a>에서 해주세요.</li> </ul> </p>',
];

$messages['nl'] = [
	'enotif_body_article_comment-HTML' => '<p>Hoi $WATCHINGUSERNAME,
<br /><br />
$ PAGEEDITOR heeft een opmerking geplaatst bij "$PAGETITLE".
<br /><br />
Je kunt de discussie bekijken via de volgende verwijzing: <a href="$PAGETITLE_URL">$PAGETITLE</a> 
<br /><br />
Kom alsjeblieft vaak langs en bewerk veelvuldig...
<br /><br />
Wikia
<br /><hr />
<ul>
<li>Wilt je bepalen welke e-mails je ontvangt? <a href="{{fullurl:{{ns:special}}:Preferences}}">Pas dan je Voorkeuren<a> aan.</li>
</ul>
</p>',
];

