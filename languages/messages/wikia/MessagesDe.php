<?php

$messages = array_merge( $messages, array(
'recentchangestext' => '<div style=\'border:solid 3px #e9e9e9; margin-bottom:0.3em;\'>
<div style=\'padding-left:0.5em; padding-right:0.5em;\'>
Auf dieser Spezialseite kannst Du die \'\'\'letzten Änderungen\'\'\' in diesem Wiki nachvollziehen.

\'\'\'Organisatorisches:\'\'\' [[Spezial:Newpages|Neue Seiten]] – [[Spezial:Newimages|Neue Dateien]] – [[Spezial:Log|Logbücher]] – [[Spezial:Activeusers|Aktive Benutzer]] – [[Spezial:Listusers/sysop|Admins]]
</div>
</div>',
'title' => 'Titel',
'login_greeting' => 'Willkommen bei Wikia!',
'create_an_account' => 'Neues Benutzerkonto erstellen',
'login_as_another' => 'Als anderer Benutzer anmelden',
'not_you' => 'Das bist nicht Du?',
'this_wiki' => 'Dieses Wiki',
'home' => 'Hauptseite',
'forum' => 'Forum',
'helpfaq' => 'Hilfe',
'createpage' => 'Neue Seite anlegen',
'joinnow' => 'Jetzt registrieren',
'most_popular_articles' => 'Beliebteste Seiten',
'expert_tools' => 'Werkzeuge für Experten',
'this_article' => 'Dieser Artikel',
'this_page' => 'Diese Seite',
'this_user' => 'Diese Benutzerseite',
'this_project' => 'Diese Projektseite',
'this_image' => 'Diese Datei',
'this_message' => 'Dieser Systemtext',
'this_template' => 'Diese Vorlage',
'this_help' => 'Diese Hilfeseite',
'this_category' => 'Diese Kategorie',
'this_forum' => 'Diese Forumsseite',
'this_special' => 'Diese Spezialseite',
'edit_contribute' => 'Bearbeiten/Seite anlegen',
'discuss' => 'Diskussion',
'share_it' => 'Mitteilen:',
'my_stuff' => 'Meine Sachen',
'choose_reason' => 'Wähle einen Grund',
'top_five' => 'Top Fünf',
'most_popular' => 'Am beliebtesten',
'most_visited' => 'Am häufigsten besucht',
'newly_changed' => 'Zuletzt geändert',
'highest_ratings' => 'Am besten bewertet',
'most_emailed' => 'Am häufigsten verschickt',
'community' => 'Community',
'rate_it' => 'Bewerten:',
'unrate_it' => 'Bewertung entfernen',
'use_old_formatting' => 'Zu Monobook wechseln',
'use_new_formatting' => 'Neue Formatierung verwenden',
'review_reason_1' => 'Bewertungsgrund 1',
'review_reason_2' => 'Bewertungsgrund 2',
'review_reason_3' => 'Bewertungsgrund 3',
'review_reason_4' => 'Bewertungsgrund 4',
'review_reason_5' => 'Bewertungsgrund 5',
'watchlist_s' => 'Beobachtungsliste',
'preferences' => 'Einstellungen',
'aboutpage' => '{{ns:project}}:Über_dieses_Wiki',
'accountcreatedtext' => 'Das Benutzerkonto $1 wurde erstellt.',
'acct_creation_throttle_hit' => 'Du hast schon $1 Benutzerkonten angelegt und kannst vorerst keine weiteren mehr anlegen.',
'activeusers' => 'Aktive Benutzer',
'activeusersempty' => 'In diesem Wiki wurden noch keine Bearbeitungen von registrierten Benutzern vorgenommen.',
'activeusersintro' => 'Diese Spezialseite listet die aktiven Benutzer auf, die in diesem Wiki bereits Bearbeitungen vorgenommen haben.',
'activeusersline' => '* [[$1]] ([[Special:Contributions/$2|Beiträge]]; letzte Bearbeitung: $3)',
'activeusersnext' => 'Nächste $1 >>',
'activeuserstitle' => 'Aktive Benutzer',
'add_comment' => 'Kommentieren',
'addedwatchtext' => 'Die Seite „$1“ wurde zu Deiner [[{{ns:special}}:Watchlist|Beobachtungsliste]] hinzugefügt. <br />
Spätere Änderungen an dieser Seite und der zugehörigen Diskussionsseite werden dort gelistet und die Seite wird in der [[{{ns:special}}:Recentchanges|Liste der letzten Änderungen]] in \'\'\'Fettschrift\'\'\' angezeigt. 
Wenn Du die Seite wieder von der Beobachtungsliste entfernen möchtest, klicke auf der jeweiligen Seite auf „Nicht beobachten“.',
'addsection' => 'Kommentieren',
'admin_skin' => 'Admin-Optionen',
'adminskin_ds' => 'Voreinstellung',
'ajaxLogin1' => 'Du musst ein neues Passwort eingeben um die Anmeldung durchzuführen. Dies geschieht auf einer andere Seite, so dass du deine aktuellen Änderungen auf dieser Seite möglicherweise verlieren wirst.',
'ajaxLogin2' => 'Bist du sicher? Möglicherweise gehen deine aktuellen Änderungen verloren, wenn du diese Seite verlässt.',
'all_the_wikia' => 'Alle Wikias',
'allinnamespace' => 'Alle Seiten im Namensraum „$1“',
'alllogstext' => 'Diese Spezialseite bietet eine kombinierte Anzeige verschiedener Logbücher. Sie können nach Typ, Benutzernamen und nach betroffener Seite bzw. betroffenem Benutzer gefiltert werden.',
'allmessages' => 'MediaWiki-Systemnachrichten',
'allmessagestext' => 'Dies ist eine Liste aller Systemnachrichten im MediaWiki-Namensraum. Diese werden von der MediaWiki-Software verwendet und können nur von Administratoren geändert werden.',
'allnotinnamespace' => 'Alle Seiten (nicht im Namensraum „$1“)',
'allpages-summary' => '{|cellpadding="4px" style="width:100%; background-color:#f9f9f9; border-style:solid; border-color:#e9e9e9; border-width:4px; margin:auto; margin-top:4px; margin-bottom:4px; clear:both; position:relative;"
|<div style="float:right">http://images.wikia.com/de/images/4/47/Allpages-summary-de.png</div>
<span style="font-weight:bold; font-size:140%;">Inhalt von A–Z</span>

Diese automatisch erstellte Spezialseite bietet eine \'\'\'alphabetische Übersicht aller Seiten\'\'\' in diesem Wiki. Aktuell gibt es bereits \'\'\'{{NUMBEROFARTICLES}} Seiten\'\'\', die als „Artikel“ gelten. 

* Mit dem Auswahlfeld lassen sich Seiten in bestimmten [[w:de:Hilfe:Namensräume|Namensräumen]] anzeigen.
* \'\'Kursiv\'\' dargestellte Einträge sind Weiterleitungen auf andere Seitentitel. 
* Alternativ zu dieser automatisch erstellten Auflistung gibt es noch die [[:Kategorie:Inhalt|\'\'\'Kategorienübersicht\'\'\' als thematisch gegliederten Einstieg]].
|}',
'allpagesbadtitle' => 'Der angegeben Seitentitel war ungültig oder hatte einen Interlanguage- oder Interwiki-Präfix. Eventuell enthält er auch ein Zeichen, das nicht in einem Seitentitel verwendet werden kann.',
'almosttheretext' => 'Benutze den Schieber um eine Vorschaubild-Größe zu wählen, gib eine Beschreibung an und klicke auf Einfügen.',
'already_bureaucrat' => 'Dieser Benutzer ist bereits Bürokrat.',
'already_sysop' => 'Dieser Benutzer ist bereits Administrator.',
'alreadyloggedin' => '\'\'\'Benutzer $1, Du bist bereits angemeldet!\'\'\'<br />',
'alreadyrolled' => 'Das Zurücksetzen der Änderungen von [[{{ns:user}}:$2|$2]] <span style=\'font-size: smaller\'>([[{{ns:user_talk}}:$2|Diskussion]], [[{{ns:special}}:Contributions/$2|Beiträge]])</span> am Artikel [[:$1]] war nicht erfolgreich, da in der Zwischenzeit bereits ein anderer Benutzer 
Änderungen an diesem Artikel vorgenommen hat.<br />Die letzte Änderung stammt von [[{{ns:user}}:$3|$3]] <span style=\'font-size: smaller\'>([[{{ns:user_talk}}:$3|Diskussion]])</span>.',
'ancientpages-summary' => 'Diese Spezialseite zeigt eine Liste von Artikeln, die sehr lange nicht mehr geändert wurden. Sie ist hilfreich, um Artikel zu finden, die gegebenenfalls aktualisiert werden müssen.',
'anoneditwarning' => '{| align=center width=75% cellpadding=5 style="background: #D3E1F2; border: 1px solid #aaa;"
|-
| rowspan=2 | http://images3.wikia.nocookie.net/messaging/images//6/68/Login.png
| valign=top colspan=2 | \'\'\'Hast du vergessen dich anzumelden?\'\'\' Ein Benutzername hilft dir dabei deine Änderungen nachzuvollziehen und mit anderen Nutzern zu kommunizieren. Wenn du dich nicht anmeldest, wird deine aktuelle IP-Adresse in der Versionsgeschichte aufgezeichnet und ist damit unwiderruflich \'\'\'öffentlich\'\'\' einsehbar.
|-
| class=plainlinks align=center | [{{FULLURL:Special:Userlogin}} http://images3.wikia.nocookie.net/messaging/images//f/f1/Greenbutton.png] \'\'\'[[Special:Userlogin|Hier zum Anmelden klicken]]\'\'\'
| class=plainlinks align=left | [{{SERVER}}/index.php?title=Special:Userlogin&type=signup http://images3.wikia.nocookie.net/messaging/images//f/f1/Greenbutton.png] \'\'\'[{{SERVER}}/index.php?title=Special:Userlogin&type=signup Benutzerkonto erstellen]\'\'\'
|}
<br />',
'anontalkpagetext' => '---- 
\'\'Diese Seite dient dazu, einem nicht angemeldeten Benutzer Nachrichten zu hinterlassen. Wenn du mit den Kommentaren auf dieser Seite nichts anfangen kannst, richten sie sich vermutlich an einen früheren Inhaber deiner momentanen IP-Adresse und du kannst sie ignorieren. Du kannst [[{{ns:special}}:Userlogin|Dich anmelden]], um zukünftige Verwirrung zu vermeiden.\'\'',
'anonymous' => 'Anonyme(r) Benutzer von {{SITENAME}}',
'antispam_label' => 'Dieses Feld dient als Spam-Falle. <strong>Fülle es nicht aus!</strong>',
'articleexists' => 'Unter diesem Namen existiert bereits eine Seite.
Bitte wähle einen anderen Titel.',
'back' => 'Zurück',
'badfilename' => 'Der Dateiname wurde zu „$1“ abgeändert.',
'blockededitsource' => 'Der Text von \'\'\'Deinen Änderungen\'\'\' an \'\'\'$1\'\'\' wird hier angezeigt:',
'blockedtext' => 'Dein Benutzername oder Deine IP-Adresse wurde von $1 blockiert.

Folgender Grund wurde angegeben: $2

Du kannst $1 oder andere [[Project:Administratoren|Administratoren]] kontaktieren, um über die Blockierung zu diskutieren. Bei Problemen kannst Du [[Special:Contact|Kontakt zu Wikia]] aufnehmen.

Bitte gib bei entsprechenden Anfragen immer Deine IP-Adresse ($3), den Namen dieses Wikis und das heutige Datum an.',
'blockiptext' => 'Mit diesem Formular sperrst du eine IP-Adresse oder einen Benutzernamen, so dass von dort keine Änderungen mehr vorgenommen werden können.
Dies sollte nur erfolgen, um Vandalismus zu verhindern und in Übereinstimmung mit den [[{{ns:project}}:Leitlinien|Projektleitlinien]] geschehen.
Bitte gib immer einen Grund für die Blockade an.',
'blocklogtext' => 'Dies ist das Logbuch über Sperrungen und Entsperrungen von Benutzern und IP-Adressen. Die Spezialseite [[Spezial:Ipblocklist|Liste gesperrter Benutzer/IP-Adressen]] führt alle aktuell gesperrten Benutzer auf, einschließlich automatisch geblockter IP-Adressen.',
'brokenredirectstext' => 'Die folgenden Weiterleitungen führen zu einer nicht (mehr) existenten Seite.',
'cannotundelete' => 'Wiederherstellung fehlgeschlagen; die Seite oder Datei wurde bereits wiederhergestellt.',
'captcha-createaccount-fail' => 'Falscher oder fehlender Bestätigungscode!',
'captcha-createaccount' => 'Zum Schutz vor automatisierter Anlage von Spam-Benutzerkonten musst du einmalig das Nebenstehende abtippen bzw. die Aufgabe lösen.
<br />([[{{ns:special}}:Captcha/help|Was soll das?]])',
'captchahelp-text' => 'Dieses Projekt ist ein offenes Wiki. Das bedeutet, dass praktisch jeder Beiträge einstellen kann. Solche Projekte sind daher häufiges Ziel von Spammern, die spezielle Programme benutzen, um automatisiert Weblinks zu anderen Internetseiten zu platzieren. Da diese unerwünschten Links einzeln wieder entfernt werden müssen, können sie die Arbeit an diesem Projekt enorm beeinträchtigen. 

Um zu verhindern, dass so genannte „Spam-“ oder „Vandal-Bots“ automatisch externe Links einfügen oder zahllose neue Benutzerkonten für spätere Spam- oder Vandalismusattacken registrieren können, verwendet Wikia sogenannte „Captchas“ (kleine Aufgaben, die für Menschen gut, für Bots aber nur schwer lösbar sind).

Leider bereitet diese Methode für einige Benutzer Unannehmlichkeiten, besonders für solche mit eingeschränktem Sehvermögen, textbasierten Browsern oder Browsern mit Sprachsteuerung. Momentan ist leider keine Audioversion verfügbar. Bei Problemen kannst Du [[{{ns:special}}:Contact|Kontakt zu Wikia]] aufnehmen.',
'categoryarticlecount' => 'Es gibt {{PLURAL:$1|eine|$1}} Seite(n) in dieser Kategorie.',
'checkuser' => 'CheckUser',
'cite_error_-3' => 'Interner Fehler: Ungültiger „name“',
'common.css' => '/* <pre><nowiki> */
/** CSS an dieser Stelle wirkt sich auf alle Skins aus */

/* Siehe auch: [[MediaWiki:Monobook.css]] */

/*** Forum-Formatierung (von -Algorithm und -Splarka) ***/

.forumheader { 
     border: 1px solid #aaaaaa; background-color: #f9f9f9; margin-top: 0.5em; padding: 10px; 
}
.forumlist td.forum_edited a { 
     color: black; text-decoration: none;
}
.forumlist td.forum_title a { 
     padding-left: 20px; 
}
.forumlist td.forum_title a.forum_new {  
     font-weight: bold; background: url(/images/4/4e/Forum_new.gif) center left no-repeat; padding-left: 20px; 
}
.forumlist td.forum_title a.forum_new:visited { 
     font-weight: normal; background: none; padding-left: 20px; 
}
.forumlist th.forum_title { 
     padding-left: 20px; 
}

/*** Hauptseiten CSS ***/

.hs-box {
     border:1px solid #4a4a4a;
     border-top:0px solid #ffffff;
     background-color:#ffffff;
     margin-bottom:0.8em;
     padding:0.2em 0.8em 0.1em 0.8em;
}

 /* Markierung von Weiterleitungen in [[Special:Allpages]]  */
 
 .allpagesredirect {
     background-color:#F5F5F5;
     font-style: italic;
 }

/*** (± Zahl) wird in den letzen Änderungen bei minus rot dargestellt, bei plus grün ***/
 span.mw-plusminus-pos {color: #006400;} 
 span.mw-plusminus-neg {color: #8B0000;}

/* </pre></nowiki> */',
'confirmdeletetext' => 'Du bist dabei, eine Seite oder Datei und alle zugehörigen älteren Versionen zu löschen. Bitte bestätige dazu, dass Du Dir der Konsequenzen bewusst bist, und dass Du in Übereinstimmung mit den [[{{ns:project}}:Leitlinien|Projektleitlinien]] handelst.',
'confirmedittext' => 'Du musst deine E-Mail-Adresse erst bestätigen, bevor du bearbeiten kannst. Bitte ergänze und bestätige deine E-Mail in den [[{{ns:special}}:Preferences|Einstellungen]].',
'confirmemail_body' => 'Hallo,

dies ist eine automatisch erstellte Nachricht. 

Jemand mit der IP-Adresse $1, wahrscheinlich Du selbst, hat eine Bestätigung dieser E-Mail-Adresse für das Benutzerkonto "$2" für {{SITENAME}} angefordert.

Um die E-Mail-Funktion für {{SITENAME}} (wieder) zu aktivieren und um zu bestätigen, dass dieses Benutzerkonto wirklich zu Deiner E-Mail-Adresse und damit zu Dir gehört, öffne bitte folgenden Link in Deinem Browser: $3

Sollte der vorstehende Link in Deinem E-Mail-Programm über mehrere Zeilen gehen, musst du ihn eventuell per Hand in die URL-Zeile des Browsers einfügen. 

Der Bestätigungscode ist bis zum folgenden Zeitpunkt gültig: $4

Wenn diese E-Mail-Adresse *nicht* zu dem genannten Benutzerkonto gehört, folge diesem Link bitte *nicht*.

----

{{SITENAME}}: {{fullurl:{{Mediawiki:mainpage}}}}',
'confirmemail_loggedin' => 'Deine E-Mail-Adresse wurde erfolgreich bestätigt.',
'confirmemail_subject' => '[{{SITENAME}}] Bestätigung deiner E-Mail-Adresse',
'confirmemail_success' => 'Deine E-Mail-Adresse wurde erfolgreich bestätigt.',
'confirmemail_text' => 'Dieses Wiki erfordert, dass du deine E-Mail-Adresse bestätigst (authentifizierst), bevor du die E-Mail-Funktionen benutzen kannst. Durch einen Klick auf die Schaltfläche unten wird eine automatische E-Mail an dich gesendet. Diese E-Mail enthält einen Link mit einem Bestätigungscode. Durch Klicken auf diesen Link kannst du dann bestätigen, dass deine E-Mail-Adresse tatsächlich korrekt und gültig ist.

Falls du keine E-Mail erhältst, prüfe bitte in [[{{ns:special}}:Preferences|Deinen Einstellungen]], ob du eine gültige E-Mail-Adresse eingetragen hast.',
'confirmrecreate' => 'Benutzer [[{{ns:user}}:$1|$1]] ([[{{ns:user_talk}}:$1|Diskussion]]) hat diese Seite gelöscht, nachdem Du angefangen hast, sie zu bearbeiten. Die Begründung lautete:<br />
\'\'$2\'\'

Bitte bestätige, dass Du diese Seite tatsächlich neu anlegen möchtest.',
'contact' => 'Kontakt zu Wikia',
'contactintro' => 'Mit diesem E-Mail-Formular kannst du direkten Kontakt zum <a href=http://www.wikia.com/wiki/Community_Team>Community Support von Wikia</a> aufnehmen. Du kannst in Englisch aber auch in Deutsch und einigen anderen Sprachen schreiben.<p />

<p>Hinweise zu Problemberichten technischer oder rechtlicher Natur bietet die Seite „<a href=http://www.wikia.com/wiki/Report_a_problem>Report a problem</a>“.</p>

<p>Das öffentliche Community-Forum von Wikia findest du unter dem Punkt <a href="http://de.wikia.com/wiki/Forum:%C3%9Cbersicht">Forum:Übersicht</a>. Wenn du auf Software-Fehler hinweisen möchstest, kannst du das auf im <a href="http://inside.wikia.com/forum">Inside Wikia forum</a> (auf Englisch).</p>

<p>Falls du aber lieber eine private Nachricht an <a href=http://www.wikia.com/wiki/Wikia>Wikia</a> schreiben möchstest, dann benutze dieses Formular. <i>Alle Felder sind optional</i>.</p>

<p>Bitte schildere möglichst exakt, worum es geht (Links sind hilfreich) und gib eine gültige E-Mail-Adresse an, wenn Du eine Antwort bekommen möchtest. Diese kann je nach Anzahl anderer Anfragen und Dringlichkeit einige Tage dauern; wir bemühen uns jedoch um zeitnahe Bearbeitung.<p />

<p>Das Formular reagiert momentan etwas langsam, aber drücke bitte <b>nur einmal</b> auf <i>Abschicken</i>.</p>',
'contactmail' => 'Abschicken',
'contactmailsub' => 'Wikia Kontakt-Adresse',
'contactpagetitle' => 'Kontakt zu Wikia',
'contactproblem' => 'Betreff',
'contactproblemdesc' => 'Nachricht',
'contactrealname' => 'Dein Name',
'contactsubmitcomplete' => 'Danke für deine Nachricht an Wikia.

Sofern du eine gültige E-Mail-Adresse angegeben hast und die Nachricht dies erfordert, erhältst du möglichst bald eine Antwort per E-Mail.',
'contactwikiname' => 'Name des Wikis',
'contris' => 'Beiträge',
'contris_s' => 'Beiträge',
'copyrightwarning' => '{| style="width:100%; padding: 5px; font-size: 95%; border-style:solid; border-color:#c00000; border-width:2px;"
|- valign="top"
|
Alle Beiträge zu {{SITENAME}} werden unter der $2 veröffentlicht (siehe $1 für weitere Informationen).<br/>
Deine Änderungen sind direkt sichtbar. \'\'\'Bitte gib unten eine Kurzzusammenfassung an.\'\'\'

<div style="font-weight: bold; font-size: 120%;">Füge keine urheberrechtlich geschützten Bilder oder Texte ohne Erlaubnis ein!</div>

| NOWRAP |
* Du kannst auch Bilder \'\'\'[[Special:Upload|hochladen]]\'\'\'.
* Vergiss nicht, Seiten zu \'\'\'[[Special:Categories|kategorisieren]]\'\'\'.
* Falls möglich, gib deine Quellen an.\'\'\'
<div><small>\'\'[[MediaWiki:Copyrightwarning|Diese Vorlage anschauen]]\'\'</small></div>
|}',
'createpage_alternate_creation' => 'oder klicke $1, um den herkömmlichen Editor zu verwenden',
'createpage_button' => 'Neue Seite anlegen',
'createpage_button_caption' => 'Seite speichern',
'createpage_caption' => 'Seitentitel',
'createpage_categories' => 'Kategorien:',
'createpage_categories_help' => 'Kategorien sind hilfreich beim Organisieren der Wiki-Inhalte. Bitte wähle die passende Kategorie aus der Vorschlagsliste oder gib eine neue Kategorie ein (mehrere Kategorien bitte durch Kommata trennen).',
'createpage_here' => 'hier',
'createpage_hide_cloud' => '[Kategorien nicht anzeigen]',
'createpage_loading_mesg' => '… warte bitte einen Moment …',
'createpage_show_cloud' => '[Kategorien anzeigen]',
'createpage_title' => 'Neue Seite anlegen',
'createpage_title_caption' => 'Seitentitel:',
'createwiki' => 'Neues Wiki beantragen',
'createwikiaddtnl' => 'Ergänzende Informationen',
'createwikidesc' => 'Beschreibung des Wikis',
'createwikilang' => 'Sprache des Wikis',
'createwikimailsub' => 'Beantragung eines neue Wikis',
'createwikiname' => 'Name des Wikis',
'createwikinamevstitle' => 'Der „Name“ des Wikis unterscheidet sich vom „Titel“. Als <b>Name</b> wird der Bestandteil der Webadresse bezeichnet. Er sollte möglichst eindeutig, kurz und gut zu merken sein. Der  <b>Titel</b> kann auch Leerzeichen enthalten.

<b>Beispiel:</b> Ein Wiki über Filme hat den Namen „film“ (demzufolge die URL „film.wikia.com“) und den Titel „Film-Wiki“ (demzufolge gibt es Seitentitel wie „Film-Wiki:Administratoren“).',
'createwikipagetitle' => 'Beantragung eines neuen Wikis',
'createwikisubmitcomplete' => 'Dein Antrag ist komplett. Falls du eine E-Mail-Adresse angegeben hast, wirst du innerhalb der nächsten Tage über den Status informiert.',
'createwikitext' => 'Um ein neues Wiki zu beantragen, fülle bitte dieses Formular sorgfältig aus.',
'createwikititle' => 'Titel des Wikis (Projektname)',
'custom_info' => 'Angepasste Schemata können erstellt werden, indem du oben "Angepasst" auswählst und dann editierst.',
'defaultskin1' => 'Die Admins dieses Wikis haben <b>$1</b> als Standard-Skin gewählt.',
'defaultskin2' => 'Die Admins dieses Wikis haben <b>$1</b> als Standard-Skin gewählt. Klicke <a href="$2">hier</a> um den Quellcode zu sehen.',
'defaultskin3' => 'Die Admins dieses Wikis haben keinen Standard-Skin gewählt. Benutzt wird der Standard-Skin von Wikia: <b>$1</b>.',
'defaultskin_choose' => 'Setze das Standard-Farbschema für dieses Wiki:',
'defemailsubject' => '[{{SITENAME}}-E-Mail]',
'edit-summary' => 'Zusammenfassung',
'edit' => 'bearbeiten',
'edit_this_page' => '<a href="$1">Artikel bearbeiten</a>',
'editedrecently' => 'Zuletzt geändert von',
'edithelppage' => '{{ns:help}}:Bearbeitungshilfe',
'edittools' => '<!-- Dieser Text wird unter dem „Bearbeiten“-Formular sowie dem "Hochladen"-Formular angezeigt. -->
<small>Unten sind häufig verwendete Sonderzeichen aufgelistet. Einfach draufklicken und sie erscheinen im Textfenster:</small>

<div id="editpage-specialchars" class="plainlinks" style="border-width: 1px; border-style: solid; border-color: #aaaaaa; padding: 2px;">
<span id="edittools_main">\'\'\'Sonderzeichen:\'\'\' <charinsert>– — … ° ≈ ≠ ≤ ≥ ± − × ÷ ← → · § </charinsert></span><span id="edittools_name">&nbsp;&nbsp;\'\'\'Signatur:\'\'\' <charinsert>~~&#126;~</charinsert></span>
----
<small><span id="edittools_wikimarkup">\'\'\'Wiki Syntax:\'\'\'
<charinsert><nowiki>{{</nowiki>+<nowiki>}}</nowiki> </charinsert> &nbsp;
<charinsert><nowiki>|</nowiki></charinsert> &nbsp;
<charinsert>[+]</charinsert> &nbsp;
<charinsert>[[+]]</charinsert> &nbsp;
<charinsert>[[Kategorie:+]]</charinsert> &nbsp;
<charinsert>#REDIRECT&#32;[[+]]</charinsert> &nbsp;
<charinsert><s>+</s></charinsert> &nbsp;
<charinsert><sup>+</sup></charinsert> &nbsp;
<charinsert><sub>+</sub></charinsert> &nbsp;
<charinsert><code>+</code></charinsert> &nbsp;
<charinsert><blockquote>+</blockquote></charinsert> &nbsp;
<charinsert><ref>+</ref></charinsert> &nbsp;
<charinsert><nowiki>{{</nowiki>Reflist<nowiki>}}</nowiki></charinsert> &nbsp;
<charinsert><references/></charinsert> &nbsp;
<charinsert><includeonly>+</includeonly></charinsert> &nbsp;
<charinsert><noinclude>+</noinclude></charinsert> &nbsp;
<charinsert><nowiki>{{</nowiki>DEFAULTSORT:+<nowiki>}}</nowiki></charinsert> &nbsp;
<charinsert>&lt;nowiki>+</nowiki></charinsert> &nbsp;
<charinsert><nowiki><!-- </nowiki>+<nowiki> --></nowiki></charinsert>&nbsp;
<charinsert><nowiki><span class="plainlinks"></nowiki>+<nowiki></span></nowiki></charinsert><br/></span>
<span id="edittools_symbols">\'\'\'Symbole:\'\'\' <charinsert> ~ | ¡ ¿ † ↔ ↑ ↓ • ¶</charinsert> &nbsp;
<charinsert> # ¹ ² ³ ½ ⅓ ⅔ ¼ ¾ ∞ </charinsert> &nbsp;
<charinsert> „+“ ’ ‚+‘ “+” «+» »+« ›+‹</charinsert> &nbsp;
<charinsert> $ € № </charinsert> &nbsp;
<charinsert> ♠ ♣ ♥ ♦ </charinsert><br/></span>
<span id="edittools_characters">\'\'\'Sonderzeichen:\'\'\'
<span class="latinx">
<charinsert> Á á É é </charinsert> &nbsp;
<charinsert> À à È è </charinsert> &nbsp;
<charinsert> Â â Ê ê </charinsert> &nbsp;
<charinsert> Ä ä Ë ë Ï ï Ö ö Ü ü </charinsert> &nbsp;
<charinsert> ß </charinsert> &nbsp;
<charinsert> Ç ç ñ </charinsert> &nbsp;</span><br/></span>

</small></div>
<span style="float:right;"><small>\'\'[[MediaWiki:Edittools|Diese Vorlage anzeigen.]]\'\'</small></span>',
'emailauthenticated' => 'Deine E-Mail-Adresse wurde am $1 authentifiziert.',
'emailnotauthenticated' => 'Deine E-Mail-Adresse ist <strong>noch nicht authentifiziert</strong>. Es kann Dir daher keine E-Mail für eine der folgenden Funktionen zugesandt werden.',
'enotif_body' => 'Hallo $WATCHINGUSERNAME,

die {{SITENAME}}-Seite "$PAGETITLE" wurde von $PAGEEDITOR am $PAGEEDITDATE $CHANGEDORCREATED.

Aktuelle Version: $PAGETITLE_URL

$NEWPAGE

Zusammenfassung des Bearbeiters: $PAGESUMMARY $PAGEMINOREDIT

Kontakt zum Benutzer:
E-Mail: $PAGEEDITOR_EMAIL
Wiki: $PAGEEDITOR_WIKI

Es werden solange keine weiteren Benachrichtigungsmails gesendet, bis Du die Seite wieder besucht hast. Auf Deiner Beobachtungsseite kannst Du alle Benachrichtigungsmarker zusammen zurücksetzen.

Dein freundliches {{SITENAME}}-Benachrichtigungssystem

-- 
Um die Einstellungen Deiner Beobachtungsliste anzupassen, besuche: {{fullurl:Special:Watchlist/edit}}',
'filename-prefix-blacklist' => ' #<!-- Belasse diese Zeile genau so wie sie ist --> <pre>
# Die Syntax lautet wie folgt: 
#   * Alles vom "#"-Zeichen bis zum Ende der Zeile ist ein Kommentar
#   * Jede nicht-leere Zeile ist ein Prefix für typische Dateinamen, die automatisch durch Digitalkameras vergeben werden
CIMG # Casio
DSC_ # Nikon
DSCF # Fuji
DSCN # Nikon
DUW # some mobil phones
IMG # generic
JD # Jenoptik
MGP # Pentax
PICT # misc.
 #</pre> <!-- Belasse diese Zeile genau so wie sie ist -->',
'findspam-ip' => 'IP-Adresse:',
'findspam' => 'Finde Spam',
'footer_1.5' => 'bearbeite diese Seite',
'footer_1' => 'Verbessere $1 und',
'footer_10' => 'Verbreite via $1',
'footer_2' => 'Kommentiere diesen Artikel',
'footer_5' => '$1 hat diese Seite am $2 bearbeitet',
'footer_6' => 'Zufälligen Artikel anzeigen',
'footer_7' => 'Artikel per Mail versenden',
'footer_8' => 'Verbreite diesen Artikel',
'footer_9' => 'Bewerte diesen Artikel',
'footer_About_Wikia' => '[http://www.wikia.com/wiki/About_Wikia Über Wikia]',
'footer_Contact_Wikia' => '[http://de.wikia.com/wiki/Kontaktiere_uns Kontakt]',
'footer_Terms_of_use' => '[http://www.wikia.com/wiki/Terms_of_use Nutzungsbedingungen]',
'forum-url' => 'Forum:Übersicht',
'forum_by' => 'von',
'forum_edited' => '- letzte Änderung',
'forum_never' => 'Nie',
'forum_toofew' => 'DPL Forum: Zu wenig Kategorien!',
'forum_toomany' => 'DPL Forum: Zu viele Kategorien!',
'group-helper-member' => 'Helfer',
'group-helper' => 'Helfer',
'group-janitor' => 'Hausmeister',
'imagereverted' => 'Das Zurücksetzen auf eine vorherige Version war erfolgreich. <strong>Es kann einige Minuten dauern, bis die Änderung sichtbar wird.</strong>',
'importfreeimages' => 'Importiere Freie Bilder',
'importfreeimages_description' => 'Diese Seite ermöglicht eine Suche nach frei lizenzierten Fotos bei Flickr und deren Import.',
'importfreeimages_filefromflickr' => '$1 von Benutzer <b>[$2]</b> aus Flickr. Original-URL',
'importfreeimages_importthis' => 'importieren',
'importfreeimages_next' => 'Nächste $1',
'importfreeimages_noapikey' => 'Du hast keinen Flickr-API-Key angegeben. Bitte besorge dir [http://www.flickr.com/services/api/misc.api_keys.html hier] einen API-Key und setze wgFlickrAPIKey in ImportFreeImages.php.',
'importfreeimages_nophotosfound' => 'Bei der Suche nach \'$1\' konnten keine Fotos gefunden werden.',
'importfreeimages_owner' => 'Urheber',
'importfreeimages_promptuserforfilename' => 'Bitte gib einen Ziel-Dateinamen an:',
'importfreeimages_returntoform' => 'Oder klicke <a href=\'$1\'>hier</a> um zu den Such-Resultaten zurück zu kehren.',
'insertfullsize' => 'Bild in Originalgröße einfügen',
'insertimage' => 'Bild einfügen',
'insertthumbnail' => 'Vorschaubild einfügen',
'irc' => 'Echtzeit-Hilfe',
'its_easy' => '...einfach und kostenlos',
'leftalign-tooltip' => 'Linksbündig',
'location_src' => 'Suche Ort',
'locked' => 'gesperrt',
'manage_widgets' => 'Widgets verwalten',
'message404' => '\'\'\'Es tut uns leid, aber die Seite, die du angefordert hast, existiert nicht.\'\'\'
Der Artikel \'\'\'$0\'\'\' konnte nicht gefunden werden.

* Vielleicht hilft der Artikel [[$1]] weiter.
* Du kannst das Suchfeld benutzen.
* Um auf die Hauptseite zu wechseln, klicke den folgenden Link: [{{SERVER}} {{SITENAME}}]',
'messagebar_mess' => 'Wusstest du, dass du <a href="$1">diese Seite bearbeiten</a> und <a href="$2">eine neue Seite erstellen</a> kannst? <a href="$3">Finde heraus</a> wie das funktioniert.',
'monaco-articles-on' => '$1 Artikel in diesem Wiki<br />',
'monaco-custom' => 'Angepasst',
'monaco-edit-this-menu' => 'Menü bearbeiten',
'monaco-latest-item' => '$1 von $2',
'monaco-latest' => 'Letzte Aktivität',
'monaco-sidebar' => '*mainpage|{{SITENAME}}
*Top-Inhalte
**#popular#|Ausgewählte Artikel
**#visited#|Am häufigsten besucht
**#voted#|Am besten bewertet
**#newlychanged#|Zuletzt geändert
*Community
**#topusers#|Top-Benutzer
**{{SITENAME}}:Community Portal|Community-Portal
**Forum:Index|Forum
*#category1#
*#category2#',
'monaco-toolbox' => '* randompage-url|Zufällige Seite
* upload-url|Hochladen
* whatlinkshere|Verweise
* recentchanges-url|Zuletzt geändert
* specialpages-url|Spezialseiten
* helppage|Hilfe',
'monaco-welcome-back' => 'Willkommen zurück, <b>$1</b><br />',
'monaco-whos-online' => 'Wer ist online?',
'monobook.css' => '/***** CSS an dieser Stelle wirkt sich auf die Monobook-Skin für alle Benutzer aus *****/

/* Siehe auch: [[MediaWiki:Common.css]] */

/* <pre><nowiki> */


/*** Kleinschreibung nicht erzwingen ***/

.portlet h5,
.portlet h6,
#p-personal ul,
#p-cactions li a {
    text-transform: none;
}


/*** Fetter Bearbeiten-Link ***/

#ca-edit a { 
    font-weight: bold !important; 
}


/*** Reiter in linker Navigation ***/

.portlet h5 {
    background-color: #e0e3e6;
    border: thin solid silver;
}

/* </pre></nowiki> */',
'mu_login' => 'Du musst angemeldet sein um Dateien hochladen zu können.',
'new_article' => 'Neue Seite',
'new_wiki' => 'Neues Wiki',
'or' => 'oder',
'profile' => 'Profil',
'sitestatstext' => '__NOTOC__
{| class="plainlinks" align="top" width="100%"
| valign="top" width="50%" | 
=== Seiten-Statistiken ===
{{SITENAME}} hat \'\'\'[[Special:Allpages|insgesamt $1 Seiten]]\'\'\' ([[Special:Newpages|neue Seiten]]):

*\'\'\'$2 eigenständige Seiten:\'\'\'
**die im [[Special:Allpages|Artikelnamensraum]] liegen
**die mindestens einen internen Link haben
**die sowohl [[Special:Shortpages|kurze]] als auch [[Special:Longpages|lange Seiten]] umfassen
**die [[Special:Disambiguations|Begriffsklärungen]] sein können
**die [[Special:Lonelypages|verwaist]] sein können

*zusätzlich weitere Seiten, unter anderem:
**Seiten außerhalb des Artikelnamensraums<br/>(z.B. Vorlagen und Diskussionsseiten)
**[[Special:Listredirects|Weiterleitungen]] ([[Special:BrokenRedirects|kaputte]]/[[Special:DoubleRedirects|doppelte]])
**[[Special:Deadendpages|Sackgassen-Seiten]]

| valign="top" width="50%" |

=== Weitere Statistiken ===
*\'\'\'$8 [[Special:Imagelist|Dateien]]\'\'\', in der Regel Bilder ([[Special:Newimages|neue Dateien]])
*\'\'\'$4\'\'\' Seitenbearbeitungen / \'\'\'$1\'\'\' Seiten = \'\'\'$5\'\'\' Bearbeitungen/Seiten ([[Special:Mostrevisions|meistbearbeitete Seiten]])

=== Warteschlange ===
*Momentan stehen \'\'\'$7 Aufträge\'\'\' in der [http://meta.wikimedia.org/wiki/Help:Job_queue Warteschlange]

=== Weitere Informationen ===
* [[Special:Specialpages|Spezialseiten]]
* [[Special:Allmessages|MediaWiki-Systemnachrichten]]

Weitere, wesentlich detaillierte Statistiken sind auf der \'\'\'[[Wikia:Wikia:Statistics|WikiStats-Seite]]\'\'\' in der Zentral-Wikia verlinkt.
|}',
'this_discussion' => 'Diese Diskussionsseite',
'thiswiki' => 'Dieses Wiki',
'tog-enotifrevealaddr' => 'Deine E-Mail-Adresse wird in Benachrichtigungsmails gezeigt',
'wikia_messages' => 'Wikia-Nachrichten',
'yourmail' => 'Deine E-Mail-Adresse',
'already_a_member' => 'Bereits Wikia-Nutzer?',
'blockip' => 'Benutzer sperren',
'click_stats' => 'Klick Statistik',
'createpage_about_info' => 'Dies ist der vereinfachte Editor. Weitere Informationen darüber findest du im [[w:c:de:Hilfe:Createpage|hier]].',
'createpage_add_content' => 'Inhalte erstellen',
'createpage_advanced_edit' => 'erweiterter Editor',
'createpage_advanced_text' => 'Dir steht auch ein $1 zur Verfügung.',
'createpage_advanced_warning' => 'Der Wechsel des Editors kann die Formatierung der Seite stören - trotzdem fortfahren?',
'createpage_article_do_edit' => 'Diese Seite bearbeiten.',
'createpage_article_exists' => 'Diese Seite existiert bereits. Bearbeite',
'createpage_article_exists2' => 'oder gib einen neuen Titel an.',
'createpage_article_title' => 'Name des Artikels',
'createpage_button_createplate_submit' => 'Diese Vorlage laden',
'createpage_choose_createplate' => 'Wähle einen Seitentyp',
'createpage_give_title' => 'Gib bitte einen Titel an',
'createpage_image_label' => 'Ort des Bildes',
'createpage_image_rename_label' => 'Name des Bildes',
'createpage_img_uploaded' => 'Bild erfolgreich hochgeladen',
'createpage_initial_run' => 'Zur Bearbeitung',
'createpage_insert_image' => 'Bild einfügen',
'createpage_login_href' => 'anmelden',
'createpage_login_required' => 'Du musst dich',
'createpage_login_required2' => 'um Bilder hochzuladen',
'createpage_login_warning' => 'Wenn du dich jetzt anmeldest, verlierst du möglicherweise deinen noch nicht gespeicherten Text. Trotzdem fortfahren?',
'createpage_no' => 'Nein',
'createpage_please_wait' => 'Bitte warten...',
'createpage_preview_end' => 'Ende der Vorschau. Du kannst jetzt unten mit deine Bearbeitung fortsetzen:',
'createpage_rename_label' => 'Name',
'createpage_title_additional' => 'Diese Seite existiert noch nicht. Um einen neuen Artikel zu erstellen, fülle das untenstehende Formular aus.',
'createpage_title_check_header' => 'Du musst warten, bis der Namen überprüft wurde. Klicke dann erneut auf den Knopf zum fortfahren.',
'createpage_title_invalid' => 'Gib bitte einen gültigen Titel an',
'createpage_top_of_page' => 'Seitenanfang',
'createpage_upload_aborted' => 'Einfügung des Bildes abgebrochen',
'createpage_upload_directory_read_only' => 'Das Upload-Verzeichnis konnte nicht vom Webserver beschrieben werden',
'createpage_upload_location' => 'Ort',
'createpage_uploaded_from' => 'Upload via Special:Createpage',
'createpage_yes' => 'Ja',
'createplate-Blank' => '<!---blanktemplate--->

Füge hier Text ein',
'createplate-list' => 'Blank|Leer',
'createwiki_welcomebody' => 'Hallo $2, 

Das von dir beantrage Wiki ist jetzt unter <$1> erreichbar. Hoffentlich sehen wir dich bald dort editieren :-)

Wir haben auf deiner Diskussionsseite (<$5>) ein paar Tipps für den Start hinterlassen. Falls du irgendwelche Fragen hast, antworte einfach auf diese E-Mail oder stöber ein wenig in unseren Hilfe-Seiten <http://help.wikia.com> (auf Englisch) oder in den noch im Aufbau befindlichen deutschsprachigen Hilfeseiten <http://de.wikia.com/wiki/Kategorie:Hilfe>.

Viel Erfolg mit deinem neuen Wiki,

$3
Wikia Community Team 
<http://de.wikia.com/wiki/Benutzer:$4>',
'createwiki_welcomesubject' => '$1 wurde erstellt!',
'createwiki_welcometalk' => 'Hi $1 -- wir freuen uns, dass \'\'\'$4\'\'\' jetzt Teil der Wikia-Gemeinschaft ist!

Der Start eines Wikis kann am Anfang etwas ungewohnt sein, aber keine Angst: Das [[w:c:de:Community Team|Wikia-Community-Team]] steht mit Rat und Tat zur Seite. Wir haben ein paar Hinweise zusammengestellt, wie man am besten loslegen kann. Man sagt, dass Nachahmung das schönste Kompliment ist. Von den anderen Wikis bei [[w:c:de:Wikia|Wikia]] kann man sich jede Menge Anregungen für das Layout, die Ordnung der Inhalte und ähnliches holen. Wir bei Wikia sind eine große Familie und das wichtigste ist, dass jeder Spaß an der Mitarbeit hat!

* Unsere "[[w:c:de:Hilfe:Starte dein Wiki|Starte dein Wiki]]"-Seite gibt dir 5 direkt umsetzbare Tipps, um das neue Wiki erfolgreich zu machen.
* Wir haben auch "[[w:c:help:Help:Advice on starting a wiki|Hinweise zum Start eines neuen Wikis]]" <small>(englisch)</small> zusammengestellt, die eine tiefergehende Betrachtung mehrerer wichtiger Punkte beinhalten, die beim Aufbau eines Wikis berücksichtigt werden sollten.
* Wer zum ersten Mal mit Wikis in Berührung kommt, dem empfehlen wir unsere [[w:c:de:Hilfe:FAQ|FAQ]].

Falls Du Hilfe benötigst (und glaub mir: die haben wir alle gebraucht) findest du unsere umfangreichen englischen Hilfe-Seiten unter [[w:c:Help|Help Wikia]] oder wirf einen Blick in die stetig wachsende Zahl [[w:c:de:Kategorie:Hilfe|deutschsprachiger Hilfeseiten]]. 

Oder schreib uns eine Mail über unser [[Special:Contact|Kontaktformular]]. Ebenso kannst du jederzeit unseren [http://irc.wikia.com #wikia Live-Chat] besuchen. Hier finden sich in der Regel eine Menge erfahrener Wikianer, so dass der Chat eine gute Möglichkeit darstellt, den ein oder anderen Tipp zu bekommen oder einfach nur um neue Bekanntschaften zu schließen.

Genug der Begrüßung - jetzt kannst du mit dem Bearbeiten starten! :-)
Wir freuen uns darauf dieses Projekt gedeihen zu sehen!

Viel Erfolg, [[User:Avatar|Tim \'avatar\' Bartel]] <staff />',
'description' => '{{SITENAME}} ist eine Datenbank, die von jedem bearbeitet werden kann.',
'editcount_allwikis' => 'Alle Wikis',
'editingTips' => '= Text formatieren =

Du kannst Text mit "Wiki-Markup" oder HTML formatieren.

<br />
<span style="font-family: courier"><nowiki>\'\'kursiv\'\'</nowiki></span> => \'\'kursiv\'\'

<br />
<span style="font-family: courier"><nowiki>\'\'\'fett\'\'\'</nowiki></span> => \'\'\'fett\'\'\'

<br />
<span style="font-family: courier"><nowiki>\'\'\'\'\'kursiv und fett\'\'\'\'\'</nowiki></span> => \'\'\'\'\'kursiv und fett\'\'\'\'\'

----

<br />
<nowiki><s>durchstreichen</s></nowiki> => <s>durchstreichen</s>

<br />
<nowiki><u>unterstreichen</u></nowiki> => <u>unterstreichen</u>

<br />
<nowiki><span style="color:red;">roter Text</span></nowiki> => <span style="color:red;">roter Text</span>
= Links erstellen =

Links werden mit ein oder zwei eckigen Klammern erzeugt.

<br />
\'\'\'Ein einfacher interner Link:\'\'\'<br />
<nowiki>[[Artikelname]]</nowiki>

<br />
\'\'\'Ein interner Link mit abweichender Beschreibung:\'\'\'<br />
<nowiki>[[Artikelname | Beschreibung]]</nowiki>

<br />
----

<br />
\'\'\'Ein externer Link (mit Nummer):\'\'\'<br />
<nowiki>[http://www.example.com]</nowiki>

<br />
\'\'\'Ein externer Link mit Beschreibung:\'\'\'

<nowiki>[http://www.example.com Link-Beschreibung]</nowiki>
=Überschrift hinzufügen=

Überschriften werden durch Gleich-Zeichen markiert. Je mehr "=", desto kleiner die Überschrift. 
Überschrift 1 ist für den Titel der Seite reserviert.

<br />
<span style="font-size: 1.6em"><nowiki>==Überschrift 2==</nowiki></span>

<br />
<span style="font-size: 1.3em"><nowiki>===Überschrift 3===</nowiki></span>

<br />
<nowiki>====Überschrift 4====</nowiki>
= Text einrücken =

Einrückungen können durch Leerzeichen, Punkte oder Nummern erstellt werden.

<br />
<nowiki>: eingerückt</nowiki><br />
<nowiki>: eingerückt</nowiki><br />
<nowiki>:: weiter eingerückt</nowiki><br />
<nowiki>::: noch weiter eingerückt</nowiki>

<br />
<nowiki>* Aufzählungspunkt</nowiki><br />
<nowiki>* Aufzählungspunkt</nowiki><br />
<nowiki>** Unterpunkt</nowiki><br />
<nowiki>* Aufzählungspunkt</nowiki>

<br />
<nowiki># Nummerierte Liste</nowiki><br />
<nowiki># Nummerierte Liste</nowiki><br />
<nowiki>## Unterliste</nowiki><br />
<nowiki># Nummerierte Liste</nowiki>
=Bilder einfügen=

Bilder werden so ähnlich wie Links hinzugefügt und formatiert.

<br />
<nowiki>[[Bild:Name.jpg]]</nowiki>

<br />
\'\'\'Mit Bildbeschreibungstext:\'\'\'<br />
<nowiki>[[Bild:Name.jpg | Beschreibungstext]]</nowiki>

<br />
\'\'\'Um ein Vorschaubild zu erzeugen:\'\'\'<br />
<nowiki>[[Bild:Name.jpg | thumb | ]]</nowiki>

<br />
\'\'\'Die Größe des Bildes angeben:\'\'\'<br />
<nowiki>[[Bild:Name.jpg | 200px | ]]</nowiki>

<br />
\'\'\'Das Bild ausrichten:\'\'\'<br />
<nowiki>[[Bild:Name.jpg | right|]]</nowiki>

<br />
Du kannst diese Attribute verknüpfen, wenn du einen senkrechten Strich "|" zwischen sie stellst. Alles was nach dem letzten senkrechten Strich folgt, ist Beschreibungstext.',
'editingtips_enter_widescreen' => 'Volle Breite',
'editingtips_exit_widescreen' => 'Normale Breite',
'editingtips_hide' => 'Bearbeitungs-Tipps ausblenden',
'editingtips_show' => 'Bearbeitungs-Tipps einblenden',
'editsimilar-link-disable' => 'Einstellungen',
'editsimilar-thanks-notsimilar-singleresult' => 'Vielen Dank für deine Bearbeitung. Dieser Artikel könnte auch noch etwas Hilfe gebrauchen: $1.',
'editsimilar-thanks-notsimilar' => 'Vielen Dank für deine Bearbeitung. Diese Artikel könnten auch noch etwas Hilfe gebrauchen: $1.',
'editsimilar-thanks-singleresult' => 'Vielen Dank für deine Bearbeitung. Wirf auch einen Blick auf diesen verwandten Artikel: $1.',
'editsimilar-thanks' => 'Vielen Dank für deine Bearbeitung. Wirf auch einen Blick auf diese verwandten Artikel: $1.',
'editsimilar-thankyou' => 'Vielen Dank für deine Bearbeitung, $1!',
'filetype-badtype' => 'Dateiformat nicht unterstützt.',
'flickr4' => '{| class="toccolours" style="width:100%" cellpadding="2"
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em; width:15%;" | Beschreibung
| \'\'Dieses Bild wurde über die Spezialseite [[Special:ImportFreeImages|ImportFreeImages]] von Flickr importiert. Eine detaillierte Beschreibung findet sich u.U. dort und kann bei Bedarf übertragen werden.\'\'
|-
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em; white-space:nowrap;" | Datum
| \'\'Siehe Angaben in der Flickr-Beschreibung, vgl. Link bei „Quelle“.\'\'
|-
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em;" | Author
| [http://flickr.com/people/{{{3}}}/ {{{3}}}]
|-
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em;" | Source
| [http://flickr.com/photos/{{{2}}}/{{{1}}}/ Diese Datei auf \'\'\'flickr.com\'\'\']
|-
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em;" | Lizenz
| \'\'\'CC-by-2.0\'\'\' – \'\'[[Media:{{PAGENAME}}|Diese Datei]] steht unter der [[Wikipedia:Creative Commons|Creative Commons]] [http://creativecommons.org/licenses/by/2.0/ Attribution 2.0] Lizenz.\'\'
|}<includeonly>[[Kategorie:CC-by-2.0|{{PAGENAME}}]]</includeonly>',
'flickr5' => '{| class="toccolours" style="width:100%" cellpadding="2"
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em; width:15%;" | Beschreibung
| \'\'Dieses Bild wurde über die Spezialseite [[Special:ImportFreeImages|ImportFreeImages]] von Flickr importiert. Eine detaillierte Beschreibung findet sich u.U. dort und kann bei Bedarf übertragen werden.\'\'
|-
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em; white-space:nowrap;" | Datum
| \'\'Siehe Angaben in der Flickr-Beschreibung, vgl. Link bei „Quelle“.\'\'
|-
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em;" | Author
| [http://flickr.com/people/{{{3}}}/ {{{3}}}]
|-
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em;" | Source
| [http://flickr.com/photos/{{{2}}}/{{{1}}}/ Diese Datei auf \'\'\'flickr.com\'\'\']
|-
! style="background:#8da5cc; text-align:right; vertical-align:middle; padding-right:0.5em;" | License
| \'\'\'CC-by-sa-2.0\'\'\' – \'\'[[Media:{{PAGENAME}}|Diese Datei]] steht unter der [[Wikipedia:Creative Commons|Creative Commons]] [http://creativecommons.org/licenses/by-sa/2.0/ Attribution ShareAlike 2.0] Lizenz.\'\'
|}<includeonly>[[Kategorie:CC-by-sa-2.0|{{PAGENAME}}]]</includeonly>',
'footer_Advertise_on_Wikia' => '[http://www.wikia.com/wiki/Advertising Auf Wikia werben]',
'hidebots' => 'Bots ausblenden',
'history_short' => 'Versionen',
'invitespecialpage' => 'Lade Freunde zu Wikia ein',
'last_downloaded' => 'Zuletzt heruntergeladen',
'log_in' => 'Anmelden',
'makesysop-see-userrights' => 'Siehe [[Special:Userrights]] für weitere Optionen.',
'me_edit_normal' => 'Erweiterter Editor',
'me_hide' => 'Ausblenden',
'me_show' => 'Einblenden',
'me_tip' => 'Tipp: Du kannst einen neuen Abschnitt erstellen, indem du einfach den Titel des Abschnitts in doppelte Gleichheitszeichen einbettest, z.B. == Neuer Abschnitt ==',
'miniupload' => 'Vereinfachtes Hochladen',
'monaco-category-list' => '*w:Category:Hubs|Weitere Wikis
**w:Gaming|Gaming
**w:Entertainment|Entertainment
**w:Sci-Fi|Science-Fiction
**w:Big_wikis|Größte Wikis
**w:Hobbies|Hobbies
**w:Technology|Technologie',
'monaco-related-communities' => '*w:Entertainment|Entertainment|TV-Serien, Filme, Cartoons und Comics.
*w:Gaming|Gaming|Besuche Wikias Computer- und Video-Spiele-Wikis.
*w:Sci-Fi|Science-Fiction|Entdecke die Welt der Zukunft.
*w:Big_wikis|Größte Wikis|Wirf einen Blick auf Wikias größte Wikis.
*w:Hubs|alle ansehen...',
'monobook.js' => '/* Veraltet; benutze stattdessen [[MediaWiki:common.js]] */',
'mu_size_your_image' => 'Bildgröße anpassen',
'multidelete' => 'Lösche mehrere Seiten',
'multidelete_all_wikis' => 'allen Wikis',
'multidelete_as' => 'Führe Skript aus als',
'multidelete_both_modes' => 'Bitte wähle entweder eine spezifische Seite oder eine vorgegebene Liste von Seiten.',
'multidelete_button' => 'LÖSCHEN',
'multidelete_caption' => 'Liste von Seiten',
'multidelete_choose_articles' => 'wähle, welche der gefundenen Artikel gelöscht werden sollen',
'multidelete_file_bad_format' => 'Die Datei sollte eine reine Textdatei sein',
'multidelete_file_missing' => 'Datei kann nicht gelesen werden',
'multidelete_from_file' => 'Dateiliste',
'multidelete_from_form' => 'Formulardaten',
'multidelete_help' => 'Lösche mehrere Seiten. Du kannst entweder eine einzelne Löschung durchführen oder Seiten, die in einer Datei gelistet sind. Du kannst dies nur für dieses Wiki, alle Wikis aus der gemeinsamen Datenbank oder ausgewählte Wikis (aus einer Textdatei, jedes in einer eigenen neuen Zeile) durchführen. Wähle einen Benutzer, der in den Löschlogs angezeigt wird. Die hochgeladene Seitenliste muss den Seitennamen und eine durch | abgetrennte optionale Begründung in jeder Zeile beinhalten.',
'multidelete_inbox_caption' => 'oder durch Kommata getrennt',
'multidelete_link_back' => 'Zurück zum Multidelete-Formular',
'multidelete_list_caption' => 'in einer vorgegebenen Liste von Wikis',
'multidelete_no_page' => 'Bitte gib mindestens eine zu löschende Seite an ODER wähle eine Datei mit einer Liste von Seiten.',
'multidelete_omitting_invalid' => 'Lasse ungültige Seite $1 aus.',
'multidelete_omitting_nonexistant' => 'Lasse nicht existente Seite $1 aus.',
'multidelete_on' => 'in',
'multidelete_or' => '<b>ODER</b>',
'multidelete_page' => 'Zu löschende Seiten',
'multidelete_processing' => 'Lösche Seiten',
'multidelete_reason' => 'Löschgrund',
'multidelete_select_script' => 'Seiten-Löschskript',
'multidelete_select_yourself' => 'eigener Benutzer',
'multidelete_selected_wikis' => 'ausgewählten Wikis',
'multidelete_success_subtitle' => 'auf $1',
'multidelete_task_added' => 'Der Multidelete-Auftrag wurde hinzugefügt.',
'multidelete_task_error' => 'Beim Hinzufügen des Multidelete-Auftrags ist ein Fehler aufgetreten.',
'multidelete_task_link' => 'Du kannst deinen Auftrag einsehen',
'multidelete_task_none_selected' => 'Du hast keine Artikel ausgewählt. Es wurde kein Auftrag hinzugefügt.',
'multidelete_this_wiki' => 'diesem Wiki',
'multidelete_title' => 'Multidelete',
'multilookup_help' => 'Suche Benutzerkonten eines Nutzers über mehrere Wikis.',
'multilookup_subtitle' => 'Suche nach Benutzerkonten von $1',
'multiplefileuploadsummary' => 'Zusammenfassung:',
'multipleupload-text' => 'Diese Seite dient zum gleichzeitigen Hochladen mehrerer Dateien.

Klicke auf \'\'Durchsuchen…\'\' und wähle alle Dateien aus, die du hochladen möchtest.

Du kannst gleichzeitig zwischen 1 und $1 Dateien hochladen. Falls sinnvoll kannst du wahlweise auch einen \'\'\'Ziel-Dateinamen\'\'\' vorgeben und eine \'\'\'Beschreibung\'\'\' für deine Dateien.

Ungeeignete Inhalte werden sofort gelöscht, siehe die [[{{MediaWiki:Multipleupload-page}}|Löschrichtlinien]].',
'multiupload-toolbox' => 'Mehrere Dateien hochladen',
'multiwikiedit' => 'Mehrere Seiten gleichzeitig editieren',
'multiwikiedit_all_wikis' => 'allen Wikis',
'multiwikiedit_as' => 'Führe Skript aus als',
'multiwikiedit_autosummary_caption' => 'Automatische Zusammenfassung',
'multiwikiedit_botedit_caption' => 'Bot-Bearbeitung (versteckt)',
'multiwikiedit_both_modes' => 'Bitte wähle eine bestimmte Seite oder eine vorgegebene Liste von Seiten.',
'multiwikiedit_button' => 'BEARBEITEN',
'multiwikiedit_caption' => 'Liste von Seiten',
'multiwikiedit_choose_articles' => 'wähle, welche der gefundenen Artikel bearbeitet werden sollen',
'multiwikiedit_file_bad_format' => 'Die Datei sollte eine reine Textdatei sein',
'multiwikiedit_file_missing' => 'Datei kann nicht gelesen werden',
'multiwikiedit_from_file' => 'Dateiliste',
'multiwikiedit_from_form' => 'Formulardaten',
'multiwikiedit_help' => 'Bearbeite mehrere Seiten gleichzeitig. Du kannst entweder eine einzelne Bearbeitung vornehmen oder Seiten, die in einer Datei gelistet sind. Wähle einen Benutzer, der in den Bearbeitungslogs angezeigt wird. Die hochgeladene Seitenliste muss den Seitennamen und eine durch | abgetrennte optionale Begründung in jeder Zeile beinhalten.',
'multiwikiedit_inbox_caption' => 'durch Kommata getrennt',
'multiwikiedit_link_back' => 'Zurück zum MultiWikiEdit-Formular',
'multiwikiedit_list_caption' => 'List der Wikis',
'multiwikiedit_minoredit_caption' => 'Kleine Änderung',
'multiwikiedit_no_page' => 'Bitte gib mindestens eine zu bearbeitende Seite an ODER wähle eine Datei mit einer Liste von Seiten.',
'multiwikiedit_norecentchanges_caption' => 'Bearbeitungen in den Letzten Änderungen verbergen',
'multiwikiedit_omitting_invalid' => 'Lasse ungültige Seite $1 aus.',
'multiwikiedit_omitting_nonexistant' => 'Lasse nicht existente Seite $1 aus.',
'multiwikiedit_on' => 'in',
'multiwikiedit_or' => '<b>ODER</b>',
'multiwikiedit_page' => 'Zu bearbeitende Seiten',
'multiwikiedit_page_text' => 'Zu speichernder Text',
'multiwikiedit_processing' => 'Bearbeite Seiten',
'multiwikiedit_reason' => 'Bearbeitungsgrund',
'multiwikiedit_select_script' => 'Seiten-Bearbeitungsskript',
'multiwikiedit_select_yourself' => 'eigener Benutzer',
'multiwikiedit_selected_wikis' => 'ausgewählten Wikis',
'multiwikiedit_success_subtitle' => 'auf $1',
'multiwikiedit_summary_text' => 'Zusammenfassungs-Feld',
'multiwikiedit_task_added' => 'Der MultiWikiEdit-Auftrag wurde hinzugefügt.',
'multiwikiedit_task_error' => 'Beim Hinzufügen des MultiWikiEdit-Auftrags ist ein Fehler aufgetreten.',
'multiwikiedit_task_link' => 'Du kannst deinen Auftrag einsehen',
'multiwikiedit_task_none_selected' => 'Du hast keine Artikel ausgewählt. Es wurde kein Auftrag hinzugefügt.',
'multiwikiedit_this_wiki' => 'diesem Wiki',
'multiwikiedit_title' => 'MultiWikiEdit',
'needhelp' => 'Hilfe benötigt: Bitte bearbeite [[MediaWiki:needhelp|diese Seite]] um hier Artikel anzuzeigen.',
'nocontributors' => 'Diese Seite hat keine Bearbeiter',
'nodata' => 'Keine Daten verfügbar',
'nologinlink' => 'Benutzerkonto anlegen',
'old_skins' => 'Alte Skins',
'other_people' => 'Andere Benutzer haben dies hier gesucht...',
'our404handler' => 'Error 404: Seite nicht gefunden!',
'our404handler_oops' => 'Die Seite nach der du gesucht hast, konnte nicht gefunden werden.',
'pollInfo' => 'Es gab $1 Stimmen, seit der Erstellung der Umfrage am $2.',
'pollNoVote' => 'Bitte stimme unten ab.',
'pollPercentVotes' => '$1% aller Stimmen',
'pollSubmitting' => 'Attends une moment, ta voix est traité...',
'pollVoteAdd' => 'Deine Stimme wurde gezählt.',
'pollVoteError' => 'Es gab ein Problem bei der Verarbeitung deiner Stimme. Probiere es bitte noch einmal.',
'pollVoteUpdate' => 'Deine Stimme wurde aktualisiert.',
'pollYourVote' => 'Du hast bereits für "$1" abgestimmt (am $2). Du kannst deine Stimme ändern, indem du eine der untenstehenden Antworten anklickst.',
'popular-articles' => 'Beliebte Artikel',
'popular-wikis' => 'Beliebte Wikis',
'pr_describe_problem' => 'Nachricht',
'pr_email_visible_only_to_staff' => 'nur sichtbar für Staff',
'pr_empty_email' => 'Bitte gib deine E-Mail-Adresse an',
'pr_empty_summary' => 'Bitte gib eine kurze Problembeschreibung an',
'pr_introductory_text' => 'Die meisten Seiten in diesem Wiki können bearbeitet werden und du bist ebenfalls herzlich eingeladen dies zu tun und Fehler zu korrigieren, falls dir welche auffallen. Auf der Seite [[w:c:de:Hilfe:Editieren|Hilfe:Editieren]] findest du weitere Hilfe.

Um Wikia direkt zu kontaktieren und Urheberrechtsprobleme zu melden, benutze bitte die Seite [[Special:Contact|Kontakt zu Wikia]].

Berichte, die über dieses Formular abgeschickt werden, sind für jeden [[Special:ProblemReports|im Wiki einsehbar]].',
'pr_mailer_notice' => 'Die von dir in deinen Einstellungen angegebene E-Mail-Adresse wird im "From"-Header der Mail angegeben, so dass der Empfänger dir antworten kann.',
'pr_mailer_subject' => 'Problembericht über',
'pr_mailer_tmp_info' => 'Du kannst die Antwortvorlagen [[MediaWiki:ProblemReportsResponses|hier]] anpassen.',
'pr_mailer_to_default' => 'Wikia-Benutzer',
'pr_no_reports' => 'Keine passenden Problemmeldungen gefunden',
'pr_raports_from_this_wikia' => 'Zeige nur Problemmeldungen dieses Wikis',
'pr_remove_ask' => 'Meldung endgültig löschen?',
'pr_reports_from' => 'Zeige nur Meldungen von',
'pr_spam_found' => 'In deiner Zusammenfassung wurde Spam gefunden. Bitte passe sie an.',
'pr_status_0' => 'offen',
'pr_status_1' => 'behoben',
'pr_status_10' => 'Meldung entfernen',
'pr_status_2' => 'geschlossen',
'pr_status_3' => 'benötigt Hilfe von Staff',
'pr_status_ask' => 'Status der Meldung ändern?',
'pr_status_undo' => 'Änderung des Status rückgängig machen',
'pr_status_wait' => 'Etwas Geduld...',
'pr_sysops_notice' => 'Wenn du den Status von Problemmeldungen deines Wikis ändern möchtest, kannst du das <a href="$1">hier</a> tun...',
'pr_table_actions' => 'Aktionen',
'pr_table_comments' => 'Kommentare',
'pr_table_date_submitted' => 'Gemeldet am',
'pr_table_description' => 'Beschreibung',
'pr_table_page_link' => 'Seite',
'pr_table_problem_id' => 'Problem-ID',
'pr_table_problem_type' => 'Art des Problems',
'pr_table_reporter_name' => 'Gemeldet von',
'pr_table_wiki_name' => 'Wiki-Name',
'pr_thank_you' => 'Danke für die Meldung des Problems! [[Special:ProblemReports/$1|Du kannst den aktuellen Status hier verfolgen]].',
'pr_thank_you_error' => 'Ein Fehler ist beim Versand der Problemmeldung aufgetreten, bitte probier es später noch einmal.',
'pr_total_number' => 'Gesamtzahl Problemmeldungen',
'pr_view_all' => 'Zeige alle Meldungen',
'pr_view_archive' => 'Zeige archivierte Meldungen',
'pr_view_staff' => 'Zeige Meldungen die Staff-Hilfe benötigen',
'pr_what_page' => 'Name der Seite',
'pr_what_problem' => 'Betreff',
'pr_what_problem_change' => 'Art des Problems ändern',
'pr_what_problem_incorrect_content' => 'Der Inhalt ist falsch',
'pr_what_problem_incorrect_content_short' => 'Inhalt',
'pr_what_problem_other' => 'Sonstiges',
'pr_what_problem_other_short' => 'Sonstiges',
'pr_what_problem_select' => 'Bitte wähle die Art des Problems',
'pr_what_problem_software_bug' => 'Fehler in der Wiki-Software',
'pr_what_problem_software_bug_short' => 'Bug',
'pr_what_problem_spam' => 'Seite enthält Spam',
'pr_what_problem_spam_short' => 'Spam',
'pr_what_problem_unselect' => 'Alle',
'pr_what_problem_vandalised' => 'Die Seite wurde vandaliert',
'pr_what_problem_vandalised_short' => 'Vandalismus',
'preferences_s' => 'Einstellungen',
'prlog_changedentry' => 'markierte Problem $1 als "$2"',
'prlog_emailedentry' => 'sandte E-Mail an $2 ($3)',
'prlog_removedentry' => 'löschte Problem $1',
'prlog_reportedentry' => 'meldete ein Problem mit $1 ($2)',
'prlog_typeentry' => 'änderte Art des Problems $1 auf "$2"',
'prlogheader' => 'Liste gemeldeter Probleme und des jeweiligen Status',
'prlogtext' => 'Problemmeldungen',
'problemreports' => 'Liste der Problemmeldungen',
'rcshowhideenhanced' => '$1 erweiterte Darstellung',
'refreshpage' => 'Seite erneut laden, um das Widget zu aktivieren',
'related_wiki' => 'Füge hier Links im Listenformat ein um ähnliche Wikis zu diesem im "Related Wikis" [[Special:Widgets|Widget]] anzuzeigen.

* [{{FULLURL:MediaWiki:Related wiki}} Bisher wurde kein ähnliches Wiki eingetragen.]',
'reportproblem' => 'Problem melden',
'requestcreatewiki' => 'Antrag abschicken',
'resetpass_text' => '<!-- Hier Text einfügen -->',
'return_to_article' => 'Zurück zum Artikel',
'return_to_category' => 'Zurück zur Kategorie-Seite',
'return_to_category_talk' => 'Zurück zur Diskussion',
'return_to_forum' => 'Zurück zum Forum',
'return_to_forum_talk' => 'Zurück zur Diskussion',
'return_to_help' => 'Zurück zur Hilfe-Seite',
'return_to_help_talk' => 'Zurück zur Diskussion',
'return_to_image' => 'Zurück zur Bildbeschreibungsseite',
'return_to_image_talk' => 'Zurück zur Diskussion',
'return_to_mediawiki' => 'Zurück zur Nachrichtenseite',
'return_to_mediawiki_talk' => 'Zurück zur Diskussion',
'return_to_project' => 'Zurück zur Projektseite',
'return_to_project_talk' => 'Zurück zur Diskussion',
'return_to_special' => 'Zurück zur Spezialseite',
'return_to_talk' => 'Zurück zur Diskussion',
'return_to_template' => 'Zurück zur Vorlagenseite',
'return_to_template_talk' => 'Zurück zur Diskussion',
'return_to_user' => 'Zurück zur Benutzerseite',
'return_to_user_talk' => 'Zurück zur Diskussion',
'right_now' => 'Gerade im Moment<br />sind Menschen dabei...',
'rightalign-tooltip' => 'Rechts ausrichten',
'save' => 'Speichern',
'search_age' => 'Suche Alter',
'search_keyword' => 'Suche Stichwort',
'search_src' => 'Suche Quelle',
'search_stats' => 'Suche Statistik',
'search_type' => 'Suche Art',
'searchresulttext' => 'Für mehr Informationen zur Suche siehe [[{{MediaWiki:Helppage}}|{{int:help}}]].',
'searchsuggest' => 'Suchvorschläge',
'searchtype' => 'Such-Frontend',
'see_more' => 'Zeige mehr...',
'seemoredotdotdot' => 'Zeige mehr...',
'serp_position' => 'Stichwort-Rang',
'serp_weight' => 'Prozent von allen%',
'shared-problemreport' => 'Problem melden',
'showall' => 'Alle anzeigen',
'site_url' => 'Seiten Url',
'sitemap_type' => 'Sitemap Typ',
'sitewidemessages' => 'Nachricht an Alle',
'skinchooser-customcss' => 'Um ein angepasstes Farbschema zu benutzen, wähle "Angepasst" und hinterlege eine entsprechende CSS-Datei unter dem Namen [[MediaWiki:Monaco.css]].',
'sp-contributions-footer-anon' => '{| id="anontalktext" class="plainlinks noeditsection" style="font-size:90%; border: 1px solid #B8B8B8; margin:1em 1em 0em 1em; padding:0.25em 1em 0.25em 1em; clear: both;" 
| \'\'\'Dies ist die Beitragsseite für unangemeldete Benutzer, die noch keine Benutzerkonto erstellt haben oder es nicht benutzen. Sie werden durch ihre [[wikipedia:de:IP-Adresse|IP-Adresse]] identifiziert.\'\'\'

Einige IP-Adressen werden dynamisch vergeben und können von verschiedenen Nutzern geteilt werden. Als anonymous Nutzer kannst du [[{{ns:Special}}:Userlogin|ein Benutzerkonto erstellen oder dich einloggen]] um zu vermeiden, mit anderen unangemeldeten Nutzern verwechselt zu werden. Bei Benutzerkonten wird die IP-Adresse versteckt. [[w:c:help:Help:Why create an account|Why create an account?]] ([[w:c:help:Help:Create an account|How to create an account]])

\'\'\'Informationen zur IP-Adresse:\'\'\' [http://samspade.org/whois?query=$1 WHOIS] • [http://openrbl.org/query?$1 RDNS] • [http://www.robtex.com/rbls/$1.html RBLs] • [http://www.dnsstuff.com/tools/tracert.ch?ip=$1 Traceroute] • [http://www.as3344.net/is-tor/?args=$1 TOR check] &mdash; [[wikipedia:Regional Internet registry|RIR]]s: [http://ws.arin.net/whois/?queryinput=$1 America] &bull; [http://www.ripe.net/fcgi-bin/whois?searchtext=$1 Europe] · [http://www.afrinic.net/cgi-bin/whois?query=$1 Africa] · [http://www.apnic.net/apnic-bin/whois.pl?searchtext=$1 Asia-Pacific] · [http://www.lacnic.net/cgi-bin/lacnic/whois?lg=EN&query=$1 Latin America/Caribbean]
|}',
'spamregex_summary' => 'Der Text wurde in der Zusammenfassung der Artikels gefunden.',
'spoiler-endshere' => 'Ende des Spoilers',
'spoiler-showhide-label' => 'Spoiler einblenden/ausblenden',
'spoiler-warning' => 'Spoiler-Warnung: Es folgen Informationen, die detaillierte Inhaltsbeschreibungen enthalten.',
'stf_abuse' => 'Diese E-Mail wurde über Wikia verschickt.
Wenn du glaubst, dass dieses Angebot missbraucht wird, teile uns dies bitte unter support@wikia.com mit!',
'stf_add_emails' => 'E-Mail-Addressen hinzufügen:',
'stf_after_reg' => 'Lade einen Freund zu Wikia ein! [[Special:InviteSpecialPage|Klick]].',
'stf_back_to_article' => 'Zurück zum Artikel',
'stf_button' => 'Artikel an einen Freund versenden',
'stf_choose_from_existing' => 'Wähle aus deinen bestehenden Kontakten:',
'stf_confirm' => 'Nachricht versandt! Weitere Freunde einladen?',
'stf_ctx_check' => 'Checke Kontakte',
'stf_ctx_empty' => 'Unter diesem Benutzerkonto existieren keine Kontakte.',
'stf_ctx_invalid' => 'Der Benutzername oder das Passwort ist ungültig. Bitte probier es noch einmal.',
'stf_ctx_invite' => 'Mehrere Adressen? Mit Komma getrennt - bis zu $1!',
'stf_email_label' => 'Deine E-Mail-Adresse:',
'stf_email_sent' => 'Bestätigung senden',
'stf_error' => 'Fehler beim Mailversand.',
'stf_error_from' => 'Du hast deine E-Mail-Adresse nicht angegeben.',
'stf_error_name' => 'Du hast deinen Namen nicht angegeben.',
'stf_error_to' => 'Du hast die E-Mail-Adresse deines Freundes nicht angegeben.',
'stf_frm1' => 'Deine E-Mail-Adresse:',
'stf_frm2' => 'E-Mail-Adressen (Mehr als eine? Trenne sie durch Kommata.)',
'stf_frm3_invite' => 'Hi!

Ich hab\' mich gerade bei diesem Wiki bei Wikia angemeldet: $1

Schau doch mal vorbei!',
'stf_frm3_send' => 'Hi!

$1 denkt, dass dir diese Seite von Wikia gefallen könnte: $2

Wirf mal einen Blick drauf!',
'stf_frm4_cancel' => 'Abbrechen',
'stf_frm4_invite' => 'Einladung verschicken!',
'stf_frm4_send' => 'Abschicken',
'stf_frm5' => '(Die URL dieser Seite wird an deine Nachricht angehängt.)',
'stf_frm6' => 'Fenster schließen',
'stf_instructions' => '1. Freunde auswählen.|2. "$1" klicken',
'stf_message' => 'Nachricht',
'stf_most_emailed' => 'Heute am häufigsten verschickter Artikel in $1:',
'stf_most_popular' => 'Beliebtester Artikel in $1:',
'stf_msg_label' => 'Zu versendende Nachricht',
'stf_multiemail' => 'An mehr als einen Empfänger verschicken?',
'stf_name_label' => 'Dein Name',
'stf_need_approval' => 'Es werden keine E-Mails ohne deine Zustimmung verschickt',
'stf_select_all' => 'Alle auswählen',
'stf_select_friends' => 'Freunde auswählen:',
'stf_sending' => 'Etwas Geduld...',
'stf_subject' => ' hat dir einen Artikel von $1 geschickt!',
'stf_throttle' => 'Aus Sicherheitsgründen kannst du nur $1 Einladungen pro Tag verschicken.',
'stf_we_dont_keep' => 'Diese E-Mail-Adresse und das Passwort werden nicht gespeichert',
'stf_your_address' => 'Deine E-Mail-Adresse',
'stf_your_email' => 'Dein Mail-Anbieter',
'stf_your_friends' => 'E-Mail-Adressen|deiner Freunde',
'stf_your_login' => 'Dein Benutzername',
'stf_your_name' => 'Dein Name',
'stf_your_password' => 'Dein Passwort',
'swm-button-new' => '[ Neu ]',
'swm-button-preview' => '[ Vorschau ]',
'swm-button-save' => '[ Speichern ]',
'swm-button-send' => '[ Abschicken ]',
'swm-days' => 'nie,Tag,Tage',
'swm-dismiss-content' => '<p>Die Nachricht wurde ausgeblendet.</p><p>%s</p>',
'swm-error-empty-group' => 'Gib den Namen der Gruppe ein.',
'swm-error-empty-message' => 'Gib den Inhalt der Nachricht ein.',
'swm-error-no-such-wiki' => 'Es gibt kein solches Wiki!',
'swm-expire-info' => 'Diese Nachricht wird am $1 ablaufen.',
'swm-expire-options' => '0,1,3,7,14,30,60',
'swm-label-comment' => 'Kommentar',
'swm-label-content' => 'Inhalt',
'swm-label-dismissed' => 'Ausgeblendet',
'swm-label-edit' => 'Bearbeiten',
'swm-label-expiration' => 'Verfallsdatum',
'swm-label-list' => 'Übersicht',
'swm-label-mode-all' => 'Alle Benutzer',
'swm-label-mode-group-hint' => '<i>Hinweis: Dies ist zeitaufwändiger und wird in die Warteschlange des TaskManagers eingestellt.</i>',
'swm-label-mode-group' => 'Benutzer der Gruppe',
'swm-label-mode-user' => 'Ausgewählte Benutzer',
'swm-label-mode-wiki' => 'Aktive Benutzer im Wiki',
'swm-label-preview' => 'Vorschau',
'swm-label-recipient' => 'Empfänger',
'swm-label-remove' => 'Entfernen',
'swm-label-sent' => 'Abgeschickt',
'swm-link-dismiss' => 'Nachricht ausblenden',
'swm-list-no-messages' => 'Keine Nachrichten.',
'swm-list-table-content' => 'Inhalt',
'swm-list-table-date' => 'Versanddatum',
'swm-list-table-expire' => 'Beenden',
'swm-list-table-group' => 'Gruppe',
'swm-list-table-id' => 'ID',
'swm-list-table-recipient' => 'Empfänger',
'swm-list-table-removed' => 'Entfernt',
'swm-list-table-sender' => 'Absender',
'swm-list-table-tools' => 'Tools',
'swm-list-table-wiki' => 'Wiki',
'swm-msg-sent-err' => '<h3>Die Nachricht wurde NICHT verschickt.</h3>
Mehr Informationen findest du im Fehler-Log.',
'swm-msg-sent-ok' => '<h3>Die Nachricht wurde verschickt.</h3>',
'swm-no' => 'Nein',
'swm-page-title-dismiss' => 'Nachricht an Alle :: Ausblenden',
'swm-page-title-editor' => 'Nachricht an Alle :: Editor',
'swm-page-title-list' => 'Nachricht an Alle :: Übersicht',
'swm-page-title-preview' => 'Nachricht an Alle :: Vorschau',
'swm-page-title-send' => 'Nachricht an Alle :: Abschicken',
'swm-page-title-sent' => 'Nachricht an Alle :: Abgeschickt',
'swm-yes' => 'Ja',
'tagline-url-interwiki' => 'Aus [[wikia:c:$1|{{SITENAME}}]], einem [[w:c:de|Wikia-Wiki]].',
'tagline-url' => 'Aus [{{SERVER}} {{SITENAME}}], einem [http://de.wikia.com Wikia-Wiki].',
'talkpagetext' => '<div style="margin: 0 0 1em; padding: .5em 1em; vertical-align: middle; border: solid #999 1px;">\'\'\'Dies ist eine Diskussionsseite. Denk bitte daran, deine Beiträge (mit vier Tilden) zu unterschreiben (<code><nowiki>~~~~</nowiki></code>).\'\'\'</div>',
'taskmanager' => 'Anzeige und Verwaltung von Hintergrund-Aufgaben',
'taskmanager_tasklist' => 'Zurück zur Aufgaben-Liste',
'taskmanager_title' => 'Anzeige und Verwaltung von Hintergrund-Aufgaben',
'thumbnailsize' => 'Größe des Vorschaubilds',
'tog-disableeditingtips' => 'Bearbeitungs-Tipps ausblenden',
'tog-disablelinksuggest' => 'Keine Link-Vorschläge anzeigen',
'tog-edit-similar' => 'Hinweis auf ähnliche Artikel aktivieren',
'tog-htmlemails' => 'E-Mails im HTML-Format',
'tog-searchsuggest' => 'Zeige Vorschläge im Suchformular',
'tog-showAds' => '<b>Zeige alle Werbebanner</b><br/>Wähle diese Option um alle Artikel-Seiten so darzustellen, wie sie nicht-angemeldete Nutzer sehen.<br/><br/>',
'tog-skinoverwrite' => '<b>Angepasste Wiki-Skins anzeigen</b> (empfohlen)<br>Einige Wiki-Administratoren investieren viel Zeit um das Aussehen ihrer Wikis anzupassen. Wähle diese Einstellung um die entsprechenden Anpassungen auch anzuzeigen.',
'ue-VisitN1' => 'Willkommen bei Wikia! <a href="http://de.wikia.com/index.php?title=Spezial:Anmelden&type=signup&uselang=de" id="ue-Visit1_1">Erstell\' dir ein eigenes Benutzerkonto!</a>',
'ue-VisitN10' => 'Um deine Bearbeitungen nachzuvollziehen und Seiten zu beobachten, erstell\' dir bitte <a href="/index.php?title=Special:Userlogin&type=signup&uselang=de" onClick="javascript:urchinTracker(\'/reg/ue-Visit10_10\'); ">ein eigenes Benutzerkonto</a>!',
'ue-VisitN2' => 'Willkommen bei %SITENAME% - lass\' dich bei Aktualisierungen dieser Seite informierten, durch die Erstellung eines <a href="/index.php?title=Special:Userlogin&type=signup&uselang=de" id="ue-Visit2_1">eigenen Benutzerkontos</a>!',
'ue.cancel' => 'Abbrechen',
'ue.status.failure' => 'Fehler!',
'ue.status.success' => 'Erledigt!',
'ue.step1.i.1' => 'Die folgenden Benutzer-Einbindungs-Aktionen sind für alle Wikis aktiv. <br/> Bitte stelle sicher, dass die dazugehörigen Nachrichten auf  messaging.wikia.com im Format ue_UserAction/language code existieren (englisch kann ignoriert werden).',
'unwatch' => 'nicht beobachten',
'uploadtext-ext' => 'Eine vollständige Liste aller aktivierten Extensions findet sich auf der [[{{ns:Special}}:Version|Versions-Seite]].',
'uploadtext' => '{|cellpadding="4px" style="width:100%; background-color:#f9f9f9; border-style:solid; border-color:#e9e9e9; border-width:4px; margin:auto; margin-top:4px; margin-bottom:4px; clear:both; position:relative;"
|
=== Allgemeines ===

Mit dem untenstehenden Formular kannst Du neue Dateien hochladen. Mögliche Dateiformate sind für Bilder \'\'jpg, jpeg, png, gif, svg\'\' und für Ton- bzw. Videodateien \'\'ogg\'\'.

Alle bereits vorhandenen Dateien sind in der [[{{ns:special}}:Imagelist|Dateiliste]] einsehbar. Die zuletzt hochgeladenen Dateien tauchen zudem in der [[{{ns:special}}:Newimages|Galerie neuer Bilder]] auf. Wie Du hochgeladene Bilder in Seiten einbaust, steht unter \'\'\'[[Hilfe:Bilder|Hilfe „Bilder“]]\'\'\'. 

=== Wichtig === 

* [[w:c:de:Hilfe:Bildrechte|Beachte die Bildrechte!]] – Urheberrechtsverstöße können Benutzersperrung zur Folge haben.
* [[w:c:de:Hilfe:Freie Lizenzen|Nur freie Lizenzen!]] – Alle hochgeladenen Dateien müssen unter einer freien Lizenz stehen, die überall freie Weiterverbreitung, Veränderung und auch kommerzielle Nutzung erlaubt.
* [[Hilfe:Löschen|Löschwarnung!]] – Dateien ohne hinreichende oder mit inkorrekten Quell- und Lizenzangaben können ohne Rückfrage kurzfristig gelöscht werden.

=== Kurzanleitung ([[w:c:de:Hilfe:Hochladen|ausführliche Anleitung]]) ===

<span style="color:#008b00;">\'\'\'1. Quelldatei:\'\'\'</span> Klicke auf „Durchsuchen“ und wähle die gewünschte Datei aus Deinem lokalen Verzeichnis.

<span style="color:#008b00;">\'\'\'2. Dateiname:\'\'\'</span> Gib der Datei im zweiten Feld einen für das Wiki sinnvollen Namen (\'\'Kugelfisch.jpg\'\' statt \'\'IMG1234.jpg\'\') ohne Sonderzeichen und mit einer Dateiendung in Kleinbuchstaben (\'\'.jpg\'\' statt \'\'.JPG\'\'). Nach dem Hochladen kann der Dateiname nicht mehr geändert werden.

<span style="color:#008b00;">\'\'\'3. Bildinformation:\'\'\'</span> Kopiere den Mustertext der Vorlage „[[Vorlage:Dateiinfo|Dateiinfo]]“ (links) in das dritte Eingabefeld und fülle alle Zeilen nach den Gleichheitszeichen sorgfältig aus.
{| width="100%"
|width="20%" |
<pre><nowiki>
&#123;&#123;Dateiinfo
|Beschreibung=
|Datum=
|Autor=
|Quelle=
|Lizenz=
|Sonstiges=
&#125;&#125;</nowiki></pre>
| width="80%" |
* \'\'\'Beschreibung:\'\'\' Was ist dargestellt, worum handelt es sich?
* \'\'\'Datum:\'\'\' Wann ist die Datei entstanden? 
* \'\'\'Autor:\'\'\' Wer ist der Urheber (Fotograf/Zeichner)? (ggf. mit 3 Tilden <nowiki>~~~</nowiki> signieren)
* \'\'\'Quelle:\'\'\' Woher genau stammt die Datei? (exakte URL oder ggf. \'\'selbst fotografiert\'\') 
* \'\'\'Lizenz:\'\'\' Unter welcher freien Lizenz steht die Datei? Dokumentiere ggf. die genaue Freigabe-Genehmigung. 
* \'\'\'Sonstiges:\'\'\' Feld für Anmerkungen (kann frei- oder weggelassen werden)
|}

<span style="color:#008b00;">\'\'\'4. Hochladen:\'\'\'</span> Kontrolliere alle Angaben und klicke dann auf „Datei hochladen“. Dies kann – je nach Dateigröße und Internetverbindung – eine Weile dauern. Wenn nötig, kannst Du die Beschreibung der Datei auch anschließend noch ergänzen oder korrigieren. 
|}',
'url_count' => 'Url Zähler',
'userengagement' => 'Benutzer-Einbindungs-Werkzeuge [BETA]',
'var_logheader' => 'Dies ist das Logbuch der Einstellungsänderungen.',
'var_logtext' => 'Einstellungs-Logbuch',
'var_set' => 'stellte den $2 auf "$3"',
'wg_lastwikis' => 'Zuletzt besucht',
'widget_description' => 'Beschreibung',
'widgets' => 'Widgets-Liste',
'widgetwikipage' => 'Diese \'\'Nachricht\'\' ist ein \'\'einfacher\'\' Test des WikiPage-Widgets. Du kannst \'\'\'den Inhalt bearbeiten\'\'\' indem du [[Mediawiki:$1|diese Seite]] im MediaWiki-Namensraum anpasst.',
'wikiastats_active_absent_wikians' => 'Aktive/Abwesende Wikianer, geordnet nach Beitragszahl',
'wikiastats_active_month' => 'Monat',
'wikiastats_active_months' => 'Monate',
'wikiastats_active_wikians_date' => 'Zeige Änderungen für letzte(n)',
'wikiastats_active_wikians_subtitle' => 'Rang: Es werden nur Artikel gezählt, keine Bearbeitungen von Diskussionsseiten, etc.',
'wikiastats_active_wikians_subtitle_info' => 'Δ = Veränderung des Rangs in 30 Tagen',
'wikiastats_anon_wikians' => 'Unangemeldete Benutzer, geordnet nach Beitragszahl',
'wikiastats_anon_wikians_count' => '$1 unangemeldete Benutzer gefunden',
'wikiastats_archived' => 'Archiviert',
'wikiastats_article_one_link' => 'Artikel, die mindestens einen internen Link enthalten',
'wikiastats_article_size' => 'Artikel, die mindestens einen internen Link enthalten und .. Zeichen lesbaren Text, <br />ohne Wiki- und HTML-Code, versteckte Links, etc.; ebenso zählen Header nicht (exkl. Weeiterleitungen)',
'wikiastats_article_size_subtitle' => 'Wähle eine oder mehrere Artikelgrößen und klicke den Knopf zur Anzeige der Statistik',
'wikiastats_articles' => 'Artikel (exkl. Weiterleitungen)',
'wikiastats_articles_text' => 'Artikel',
'wikiastats_back_to_mainpage' => 'Zur Statistik-Hauptseite',
'wikiastats_back_to_prevpage' => 'Zurück',
'wikiastats_charts' => 'Diagramme',
'wikiastats_comparision' => 'Vergleiche',
'wikiastats_comparisons_table_1' => 'Übersicht',
'wikiastats_comparisons_table_10' => 'Bearbeitungen pro Artikel',
'wikiastats_comparisons_table_11' => 'Bytes pro Artikel',
'wikiastats_comparisons_table_12' => 'Artikel über 0.5 KB',
'wikiastats_comparisons_table_13' => 'Artikel über 2 KB',
'wikiastats_comparisons_table_14' => 'Bearbeitungen pro Monat/Tag',
'wikiastats_comparisons_table_15' => 'Datenbankgröße',
'wikiastats_comparisons_table_16' => 'Wörter',
'wikiastats_comparisons_table_17' => 'Interne Links',
'wikiastats_comparisons_table_18' => 'Links zu anderen Wikia-Wikis',
'wikiastats_comparisons_table_19' => 'Bilder',
'wikiastats_comparisons_table_2' => 'Erstellungsgeschichte',
'wikiastats_comparisons_table_20' => 'Externe Links',
'wikiastats_comparisons_table_21' => 'Weiterleitungen',
'wikiastats_comparisons_table_22' => 'Seitenabrufe pro Tag',
'wikiastats_comparisons_table_23' => 'Visits pro Tag',
'wikiastats_comparisons_table_3' => 'Autoren',
'wikiastats_comparisons_table_4' => 'Neue Wikianer',
'wikiastats_comparisons_table_5' => 'Aktive Wikianer',
'wikiastats_comparisons_table_6' => 'Sehr aktive Wikianer',
'wikiastats_comparisons_table_7' => 'Artikelanzahl',
'wikiastats_comparisons_table_8' => 'Artikelanzahl (alternativ)',
'wikiastats_comparisons_table_9' => 'Neue Artikel pro Tag',
'wikiastats_connection_error' => 'Verbindungsfehler',
'wikiastats_count' => 'Anzahl',
'wikiastats_creation_legend' => 'Durchschnittlicher Anstieg pro Monat:',
'wikiastats_creation_panel_header' => 'Die "Erstellungsgeschichte"-Statistik wird generiert',
'wikiastats_creation_wikia_text' => 'Erstellungsgeschichte / Leistungen',
'wikiastats_current_dump_stats' => 'Aktuell',
'wikiastats_daily_usage' => 'Nutzung',
'wikiastats_database' => 'Datenbank',
'wikiastats_database_name_stats' => 'Datenbank-Name',
'wikiastats_date' => 'Datum',
'wikiastats_days_ago' => 'Tage zuvor',
'wikiastats_dbdump_generated' => 'geändert:',
'wikiastats_dbdumps_stats' => 'Datenbank-Dumps',
'wikiastats_distrib_article' => 'Verteilung der Artikelbearbeitungen zu Wikianern',
'wikiastats_distrib_article_subtext' => 'Es werden nur Artikelbearbeitungen gezählt, keine Bearbeitungen auf Diskussionsseiten, etc.',
'wikiastats_distrib_edits' => 'Bearbeitungen >=',
'wikiastats_distrib_edits_total' => 'Bearbeitungen gesamt',
'wikiastats_distrib_wikians' => 'Wikianer',
'wikiastats_edits' => 'Bearbeitungen',
'wikiastats_external' => 'Externe',
'wikiastats_first_edit' => 'Erste Bearbeitung',
'wikiastats_full_dump_stats' => 'Komplett',
'wikiastats_hide' => 'Verstecken',
'wikiastats_image' => 'Grafik',
'wikiastats_info' => 'Bitte wähle aus der Wikia-Datenbankliste aus und drücke "Statistik anzeigen"',
'wikiastats_internal' => 'Interne',
'wikiastats_interwiki' => 'Interwiki',
'wikiastats_last_edit' => 'Letzte Bearbeitung',
'wikiastats_mainstats_column_A' => 'Wikianer, mit mindestens 10 Bearbeitungen',
'wikiastats_mainstats_column_B' => 'Anstieg der Wikianer, mit mindestens 10 Bearbeitungen',
'wikiastats_mainstats_column_C' => 'Wikianer, mit mindestens 5 Bearbeitungen in diesem Monat',
'wikiastats_mainstats_column_D' => 'Wikianer, mit mindestens 100 Bearbeitungen in diesem Monat',
'wikiastats_mainstats_column_E' => 'Artikel, die mindestens einen internen Link enthalten',
'wikiastats_mainstats_column_F' => 'Artikel, die mindestens einen internen Link enthalten und 200 Zeichen lesbaren Text, <br />ohne Wiki- und HTML-Code, versteckte Links, etc.; ebenso zählen Header nicht<br />(andere Spalten basieren auf der offiziellen Zählmethode)',
'wikiastats_mainstats_column_G' => 'Neue Artikel pro Tag in diesem Monat',
'wikiastats_mainstats_column_H' => 'Durchschnittliche Versionsanzahl pro Artikel',
'wikiastats_mainstats_column_I' => 'Durchschnittliche Artikelgröße in Bytes',
'wikiastats_mainstats_column_J' => 'Anteil der Artikel mit mindestens 0.5 KB lesbaren Textes (siehe F)',
'wikiastats_mainstats_column_K' => 'Anteil der Artikel mit mindestens 2 KB lesbaren Textes (siehe F)',
'wikiastats_mainstats_column_L' => 'Bearbeitungen im letzten Monat (inkl. Weiterleitungen und unangemeldete Nutzer)',
'wikiastats_mainstats_column_M' => 'Gesamtgröße aller Artikel (inkl. Weiterleitungen)',
'wikiastats_mainstats_column_N' => 'Gesamtanzahl der Wörter (exkl. Weiterleitungen, HTML/Wiki-Code und versteckten Links)',
'wikiastats_mainstats_column_O' => 'Gesamtanzahl der internen Links (exkl. Weiterleitungen, Stubs und Linklisten)',
'wikiastats_mainstats_column_P' => 'Gesamtanzahl von Links zu anderen Wikia-Wikis',
'wikiastats_mainstats_column_Q' => 'Gesamtanzahl der angezeigten Bilder',
'wikiastats_mainstats_column_R' => 'Gesamtanzahl der Links zu anderen Angeboten',
'wikiastats_mainstats_column_S' => 'Gesamtanzahl der Weiterleitungen',
'wikiastats_mainstats_column_T' => 'Seitenabrufe pro Tag (Definition basiert auf Webalizer-Ausgabe)',
'wikiastats_mainstats_column_U' => 'Visits pro Tage (Definition basiert auf Webalizer-Ausgabe)',
'wikiastats_mainstats_info' => 'Bitte wähle eine Wikia aus der Datenbankliste und klicke "erstellen"',
'wikiastats_mainstats_short_column_A' => 'Autoren',
'wikiastats_mainstats_short_column_B' => 'Neue Wikianer',
'wikiastats_mainstats_short_column_C' => 'Aktive Wikianer',
'wikiastats_mainstats_short_column_D' => 'Sehr aktive Wikianer',
'wikiastats_mainstats_short_column_E' => 'Artikelanzahl',
'wikiastats_mainstats_short_column_F' => 'Artikelanzahl (alternativ)',
'wikiastats_mainstats_short_column_G' => 'Neue Artikel pro Tag',
'wikiastats_mainstats_short_column_I' => 'Bytes pro Artikel',
'wikiastats_mainstats_short_column_J' => 'Artikel über 0.5 KB',
'wikiastats_mainstats_short_column_K' => 'Artikel über 2.0 KB',
'wikiastats_mainstats_short_column_L' => 'Bearbeitungen pro Monat',
'wikiastats_mainstats_short_column_M' => 'Datenbankgröße',
'wikiastats_mainstats_short_column_N' => 'Wörter',
'wikiastats_mainstats_short_column_O' => 'Interne Links',
'wikiastats_mainstats_short_column_P' => 'Links zu Wikia-Wikis',
'wikiastats_mainstats_short_column_Q' => 'Bilder',
'wikiastats_mainstats_short_column_R' => 'Externe Links',
'wikiastats_mainstats_short_column_S' => 'Weiterleitungen',
'wikiastats_mainstats_short_column_T' => 'Seitenabrufe pro Tag',
'wikiastats_mainstats_short_column_U' => 'Visits pro Tag',
'wikiastats_mean' => 'Durchschnitt',
'wikiastats_month_ago' => 'vor $1 $2',
'wikiastats_more_200_ch' => '>200 Zeichen',
'wikiastats_more_txt' => 'mehr',
'wikiastats_namespace' => 'Namensraum',
'wikicities-nav' => 'Wikia',
'wikicitieshome' => 'Zentral-Wikia',
'wmu-back' => 'zurück',
'wmu-caption' => 'Bildbeschreibung',
'wmu-close' => 'schließen',
'wmu-conflict-inf' => '<h1>Es existiert bereits eine Datei unter diesem Namen!</h1>Was willst du mit <b>$1</b> machen?',
'wmu-details-inf' => '<h1>Dateiname</h1>Gib einen Namen für diese Datei an. Bitte einen möglichst aussagekräftigen.',
'wmu-details-inf2' => '<h1>Artikeloptionen</h1>Wähle, wie diese Datei im Artikel angezeigt werden soll.',
'wmu-existing' => 'Benutze existierendes Bild',
'wmu-find-btn' => 'Suchen',
'wmu-find' => 'Suchen',
'wmu-flickr-inf' => 'Durchsuche passend lizenzierte Fotos von Flickr und importiere sie in dein Wiki.',
'wmu-flickr' => 'Flickr',
'wmu-flickr2' => 'Flickr-Bilder ($1 Ergebnisse)',
'wmu-fullsize' => 'Original ($1px/$2px)',
'wmu-imagebutton' => 'Bilder hinzufügen',
'wmu-imagelink' => 'Bilder hinzufügen (neu!)',
'wmu-insert' => 'Einfügen',
'wmu-insert2' => 'Datei einfügen',
'wmu-insert3' => 'Dieses Bild einfügen',
'wmu-layout' => 'Ausrichtung',
'wmu-name' => 'Name',
'wmu-next' => 'Nächste 8',
'wmu-notlogged' => 'Melde dich an oder registriere dich, um Bilder von deinem Rechner hochzuladen',
'wmu-optional' => '(Optional)',
'wmu-overwrite' => 'Überschreibe das bestehende Bild mit deinem.',
'wmu-prev' => 'Vorherige 8',
'wmu-recent-inf' => 'Zuletzt hochgeladene Bilder',
'wmu-rename' => 'Benenne dein Bild um',
'wmu-return' => 'Zurück zur Bearbeitung',
'wmu-size' => 'Größe',
'wmu-success' => '<h1>Bild hinzugefügt</h1>Der folgende Code wurde erfolgreich in deinen Artikel eingefügt:',
'wmu-thiswiki' => 'Dieses Wiki',
'wmu-thiswiki2' => 'Bilder in diesem Wiki ($1 Ergebnisse)',
'wmu-thumbnail' => 'Vorschau',
'wmu-upload-btn' => 'Hochladen',
'wmu-upload' => 'Hochladen',
'wmu-warn1' => 'Du musst zuerst einen Suchbegriff eingeben!',
'wmu-warn2' => 'Du musst zuerst eine Datei auswählen!',
'wmu-width' => 'Breite',
'ws.cancel' => 'Abbrechen',
'ws.existingpage.h' => 'Bestehende Seite',
'ws.overwrite.confirm' => 'Einige der Seiten existieren bereits auf dem Ziel-Wiki. Sollen diese überschrieben werden?',
'ws.pagename.h' => 'Name der Seite',
'ws.startover.h' => 'Neu starten',
'ws.status.badurl' => 'Keine Seiten, die importiert werden können! :( Wir unterstützen nur korrekte Wikipedia-URLs.',
'ws.status.excludeall' => 'Alle ausschließen',
'ws.status.failure' => 'Ein Fehler ist aufgetreten. Probier es bitte später noch einmal.',
'ws.status.include' => 'Aufnehmen',
'ws.status.includeall' => 'Alle aufnehmen',
'ws.status.incomplete' => 'Import unvollständig',
'ws.status.preview' => 'Vorschau',
'ws.status.remred' => 'Entferne alle toten Links von importierten Seiten',
'ws.status.success' => 'Fertig!',
'ws.status.timeout' => 'Timeout. Probier es bitte später noch einmal.',
'ws.step1.h.1' => 'Start-URL in der Wikipedia',
'ws.step1.i.1' => 'Mit Hilfe dieses Formulars kannst du Artikel von der Wikipedia importieren - allerdings ohne die dazugehörigen Vorlagen und externe Links.<br /> Du kannst angeben, wieviele verwandte Seiten importiert werden sollen (die maximale Tiefe ist ein Level unterhalb des Hauptartikels).<br /> Kopiere und füge die komplette URL der Wikipedia-Seite ein, die in der Adressleiste deines Browser angezeigt wird!',
'ws.step2.i.1' => 'Die folgenden Seiten wurden gefunden. <br /> Prüfe alle Seiten-Titel. Falls dein Wiki eine Seite mit dem gleichen Titel hat, wird diese beim Importieren ÜBERSCHRIEBEN!',
'ws.step2.i.2' => 'Es können verwandte Seiten importiert werden.',
'wt_cancel' => 'Abbrechen',
'wt_click_stats' => 'Klick Statistik',
'wt_click_to_close' => 'Klicken um Tooltip zu schließen...',
'wt_countdown_give_date' => 'Bitte gib das Datum im Format YYYY-MM-DD HH:MM:SS (z.B. 2009-03-26 13:56:00) oder YYYY-MM-DD (z.B. 2009-02-23) oder HH:MM:SS (z.B. 17:01:00) an.',
'wt_countdown_show_seconds' => 'Sekunden anzeigen',
'wt_date_range' => 'Zeitraum',
'wt_help_cockpit' => '|Widgets-Cockpit||Ziehe die Widget-Vorschaubilder auf deine Seitenleite um ein Widget hinzuzufügen...',
'wt_help_sidebar' => '|Widgets-Seitenleite||Klicke "bearbeiten" um die Widgets-Einstellungen zu ändern. Du kannst Widgets mit einem Klick auf das x-Icon schließen.',
'wt_help_startup' => '|Noch keine Widget benutzt?||Öffne das Benutzermenü ("MEHR...") und wähle "Widgets verwalten"...',
'wt_lastwikis_noresults' => 'Es gibt keine zuletzt besuchten Wikis die angezeigt werden können. Besuche unsere [[w:c:Category:Hubs|Hub Liste]] für weitere Wikis.',
'wt_location_src' => 'Suche nach Ort',
'wt_nodata' => 'Keine Dateien verfügbar',
'wt_referers_empty_list' => 'Momentan haben wir keine Statistiken um eine "Top referrer"-Tagcloud für dieses Wiki zu erstellen. Probier es später noch einmal...',
'wt_search_src' => 'Suche nach Quelle',
'wt_search_stats' => 'Such Statistik',
'wt_shoutbox_initial_message' => 'Hi... Willkommen im Chat!',
'wt_show_external_urls' => 'Zeige nur externe URLs',
'wt_show_internal_urls' => 'Zeige auch interne URLs',
'wt_show_period' => 'Zeige Periode',
'wt_show_referrers' => 'Zeige Referrers',
'wt_update' => 'Aktualisierung',
) );
