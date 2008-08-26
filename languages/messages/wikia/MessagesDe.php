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
Wenn Du die Seite wieder von der Beobachtungsliste entfernen möchtest, klicke auf der jeweiligen Seite auf „Nicht mehr beobachten“.',
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
'common.css' => '/** CSS an dieser Stelle wirkt sich auf alle Skins aus */

/* Siehe auch: [[MediaWiki:Monobook.css]] */
/* <pre><nowiki> */


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
'contactintro' => 'Mit diesem E-Mail-Formular kannst Du direkten Kontakt zum <a href=http://www.wikia.com/wiki/Community_Team>Community Support von Wikia</a> aufnehmen. Du kannst in Englisch aber auch in Deutsch und einigen anderen Sprachen schreiben.<p />
Bitte schildere möglichst exakt, worum es geht (Links sind hilfreich) und gib eine gültige E-Mail-Adresse an, wenn Du eine Antwort bekommen möchtest. Diese kann je nach Anzahl anderer Anfragen und Dringlichkeit einige Tage dauern; wir bemühen uns jedoch um zeitnahe Bearbeitung.<p />
Hinweise zu Problemberichten technischer oder rechtlicher Natur bietet die Seite „<a href=http://www.wikia.com/wiki/Report_a_problem>Report a problem</a>“.',
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
<span id="edittools_symbols">\'\'\'Symbole:\'\'\' <charinsert> ~ | ¡ ¿ † ‡ ↔ ↑ ↓ • ¶</charinsert> &nbsp;
<charinsert> # ¹ ² ³ ½ ⅓ ⅔ ¼ ¾ ⅛ ⅜ ⅝ ⅞ ∞ </charinsert> &nbsp;
<charinsert> ‘ “ ’ ” «+»</charinsert> &nbsp;
<charinsert> ¤ ₳ ฿ ₵ ¢ ₡ ₢ $ ₫ ₯ € ₠ ₣ ƒ ₴ ₭ ₤ ℳ ₥ ₦ № ₧ ₰ £ ៛ ₨ ₪ ৳ ₮ ₩ ¥ </charinsert> &nbsp;
<charinsert> ♠ ♣ ♥ ♦ </charinsert><br/></span>
<!-- Extra characters, hidden by default
<span id="edittools_characters">\'\'\'Sonderzeichen:\'\'\'
<span class="latinx">
<charinsert> Á á Ć ć É é Í í Ĺ ĺ Ń ń Ó ó Ŕ ŕ Ś ś Ú ú Ý ý Ź ź </charinsert> &nbsp;
<charinsert> À à È è Ì ì Ò ò Ù ù </charinsert> &nbsp;
<charinsert> Â â Ĉ ĉ Ê ê Ĝ ĝ Ĥ ĥ Î î Ĵ ĵ Ô ô Ŝ ŝ Û û Ŵ ŵ Ŷ ŷ </charinsert> &nbsp;
<charinsert> Ä ä Ë ë Ï ï Ö ö Ü ü Ÿ ÿ </charinsert> &nbsp;
<charinsert> ß </charinsert> &nbsp;
<charinsert> Ã ã Ẽ ẽ Ĩ ĩ Ñ ñ Õ õ Ũ ũ Ỹ ỹ</charinsert> &nbsp;
<charinsert> Ç ç Ģ ģ Ķ ķ Ļ ļ Ņ ņ Ŗ ŗ Ş ş Ţ ţ </charinsert> &nbsp;
<charinsert> Đ đ </charinsert> &nbsp;
<charinsert> Ů ů </charinsert> &nbsp;
<charinsert> Ǎ ǎ Č č Ď ď Ě ě Ǐ ǐ Ľ ľ Ň ň Ǒ ǒ Ř ř Š š Ť ť Ǔ ǔ Ž ž </charinsert> &nbsp;
<charinsert> Ā ā Ē ē Ī ī Ō ō Ū ū Ȳ ȳ Ǣ ǣ </charinsert> &nbsp;
<charinsert> ǖ ǘ ǚ ǜ </charinsert> &nbsp;
<charinsert> Ă ă Ĕ ĕ Ğ ğ Ĭ ĭ Ŏ ŏ Ŭ ŭ </charinsert> &nbsp;
<charinsert> Ċ ċ Ė ė Ġ ġ İ ı Ż ż </charinsert> &nbsp;
<charinsert> Ą ą Ę ę Į į Ǫ ǫ Ų ų </charinsert> &nbsp;
<charinsert> Ḍ ḍ Ḥ ḥ Ḷ ḷ Ḹ ḹ Ṃ ṃ Ṇ ṇ Ṛ ṛ Ṝ ṝ Ṣ ṣ Ṭ ṭ </charinsert> &nbsp;
<charinsert> Ł ł </charinsert> &nbsp;
<charinsert> Ő ő Ű ű </charinsert> &nbsp;
<charinsert> Ŀ ŀ </charinsert> &nbsp;
<charinsert> Ħ ħ </charinsert> &nbsp;
<charinsert> Ð ð Þ þ </charinsert> &nbsp;
<charinsert> Œ œ </charinsert> &nbsp;
<charinsert> Æ æ Ø ø Å å </charinsert> &nbsp;
<charinsert> Ə ə </charinsert></span>&nbsp;<br/></span>
<span id="edittools_greek">\'\'\'Greek:\'\'\'
<charinsert> Ά ά Έ έ Ή ή Ί ί Ό ό Ύ ύ Ώ ώ </charinsert> &nbsp; 
<charinsert> Α α Β β Γ γ Δ δ </charinsert> &nbsp;
<charinsert> Ε ε Ζ ζ Η η Θ θ </charinsert> &nbsp;
<charinsert> Ι ι Κ κ Λ λ Μ μ </charinsert> &nbsp;
<charinsert> Ν ν Ξ ξ Ο ο Π π </charinsert> &nbsp;
<charinsert> Ρ ρ Σ σ ς Τ τ Υ υ </charinsert> &nbsp;
<charinsert> Φ φ Χ χ Ψ ψ Ω ω </charinsert> &nbsp;<br/></span>
<span id="edittools_cyrillic">\'\'\'Cyrillic:\'\'\' <charinsert> А а Б б В в Г г </charinsert> &nbsp;
<charinsert> Ґ ґ Ѓ ѓ Д д Ђ ђ </charinsert> &nbsp;
<charinsert> Е е Ё ё Є є Ж ж </charinsert> &nbsp;
<charinsert> З з Ѕ ѕ И и І і </charinsert> &nbsp;
<charinsert> Ї ї Й й Ј ј К к </charinsert> &nbsp;
<charinsert> Ќ ќ Л л Љ љ М м </charinsert> &nbsp;
<charinsert> Н н Њ њ О о П п </charinsert> &nbsp;
<charinsert> Р р С с Т т Ћ ћ </charinsert> &nbsp;
<charinsert> У у Ў ў Ф ф Х х </charinsert> &nbsp;
<charinsert> Ц ц Ч ч Џ џ Ш ш </charinsert> &nbsp;
<charinsert> Щ щ Ъ ъ Ы ы Ь ь </charinsert> &nbsp;
<charinsert> Э э Ю ю Я я </charinsert> &nbsp;<br/></span>
<span id="edittools_ipa">\'\'\'IPA:\'\'\' <span title="Pronunciation in IPA" class="IPA"><charinsert>t̪ d̪ ʈ ɖ ɟ ɡ ɢ ʡ ʔ </charinsert> &nbsp;
<charinsert> ɸ ʃ ʒ ɕ ʑ ʂ ʐ ʝ ɣ ʁ ʕ ʜ ʢ ɦ </charinsert> &nbsp;
<charinsert> ɱ ɳ ɲ ŋ ɴ </charinsert> &nbsp;
<charinsert> ʋ ɹ ɻ ɰ </charinsert> &nbsp;
<charinsert> ʙ ʀ ɾ ɽ </charinsert> &nbsp;
<charinsert> ɫ ɬ ɮ ɺ ɭ ʎ ʟ </charinsert> &nbsp;
<charinsert> ɥ ʍ ɧ </charinsert> &nbsp;
<charinsert> ɓ ɗ ʄ ɠ ʛ </charinsert> &nbsp;
<charinsert> ʘ ǀ ǃ ǂ ǁ </charinsert> &nbsp;
<charinsert> ɨ ʉ ɯ </charinsert> &nbsp;
<charinsert> ɪ ʏ ʊ </charinsert> &nbsp;
<charinsert> ɘ ɵ ɤ </charinsert> &nbsp;
<charinsert> ə ɚ </charinsert> &nbsp;
<charinsert> ɛ ɜ ɝ ɞ ʌ ɔ </charinsert> &nbsp;
<charinsert> ɐ ɶ ɑ ɒ </charinsert> &nbsp;
<charinsert> ʰ ʷ ʲ ˠ ˤ ⁿ ˡ </charinsert> &nbsp;
<charinsert> ˈ ˌ ː ˑ  ̪ </charinsert>&nbsp;</span><br/></span>
-->
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
'footer_1.5' => 'Beiträge zu dieser Seite',
'footer_1' => 'Verbessere $1 durch',
'footer_10' => 'Verbreite via $1',
'footer_2' => 'Kommentiere diesen Artikel',
'footer_5' => '$1 hat diese Seite am $2 bearbeitet',
'footer_6' => 'Zufälligen Artikel anzeigen',
'footer_7' => 'Artikel per Mail versenden',
'footer_8' => 'Verbreite diesen Artikel',
'footer_9' => 'Bewerte diesen Artikel',
'footer_About_Wikia' => '[http://www.wikia.com/wiki/About_Wikia Über Wikia]',
'footer_Contact_Wikia' => '[http://www.wikia.com/wiki/Contact_us Kontakt]',
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
**#visited#|Most visited
**#voted#|Am besten bewertet
**#newlychanged#|Newly changed
*Community
**#topusers#|Top-Benutzer
**{{SITENAME}}:Community Portal|Community-Portal
**Forum:Index|Forum
*#category1#
*#category2#',
'monaco-toolbox' => '* Special:Random|Zufällige Seite
* Special:Upload|Hochladen
* Special:Whatlinkshere/{{FULLPAGENAME}}|Verweise
* Special:Recentchanges|Zuletzt geändert
* Special:Specialpages|Spezialseiten
* Help:Contents|Hilfe',
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
) );
