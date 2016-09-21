<?php
/**
 * Internationalisation file for extension GlobalMessages.
 *
 * @file
 * @ingroup Extensions
 */
$messages = array();

$messages['en'] = array(
	'december' => 'December',
	'december-gen' => 'December',
	'dec' => 'Dec',
	'delete' => 'Delete',
	'deletethispage' => 'Delete this page',
	'disclaimers' => 'Disclaimers',
	'disclaimerpage' => 'Project:General disclaimer',
	'databaseerror' => 'Database error',
	'dberrortext' => 'A database query syntax error has occurred.
This may indicate a bug in the software.
The last attempted database query was:
<blockquote><tt>$1</tt></blockquote>
from within function "<tt>$2</tt>".
Database returned error "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'A database query syntax error has occurred.
The last attempted database query was:
"$1"
from within function "$2".
Database returned error "$3: $4"',
	'directorycreateerror' => 'Could not create directory "$1".',
	'deletedhist' => 'Deleted history',
	'difference' => '(Difference between revisions)',
	'difference-multipage' => '(Difference between pages)',
	'diff-multi' => '({{PLURAL:$1|One intermediate revision|$1 intermediate revisions}} by {{PLURAL:$2|one user|$2 users}} not shown)',
	'diff-multi-manyusers' => '({{PLURAL:$1|One intermediate revision|$1 intermediate revisions}} by more than $2 {{PLURAL:$2|user|users}} not shown)',
	'datedefault' => 'No preference',
	'defaultns' => 'Otherwise search in these namespaces:',
	'default' => 'default',
	'diff' => 'diff',
	'destfilename' => 'Destination filename:',
	'duplicatesoffile' => 'The following {{PLURAL:$1|file is a duplicate|$1 files are duplicates}} of this file ([[Special:FileDuplicateSearch/$2|more details]]):',
	'download' => 'download',
	'disambiguations' => 'Pages linking to disambiguation pages',
	'disambiguations-summary' => '',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "The following pages link to a '''disambiguation page'''.
They should link to the appropriate topic instead.<br />
A page is treated as disambiguation page if it uses a template which is linked from [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Double redirects',
	'doubleredirects-summary' => '',
	'doubleredirectstext' => 'This page lists pages which redirect to other redirect pages.
Each row contains links to the first and second redirect, as well as the target of the second redirect, which is usually the "real" target page, which the first redirect should point to.
<del>Crossed out</del> entries have been solved.',
	'double-redirect-fixed-move' => '[[$1]] has been moved.
It now redirects to [[$2]].',
	'double-redirect-fixed-maintenance' => 'Fixing double redirect from [[$1]] to [[$2]].',
	'double-redirect-fixer' => 'Redirect fixer',
	'deadendpages' => 'Dead-end pages',
	'deadendpages-summary' => '',
	'deadendpagestext' => 'The following pages do not link to other pages in {{SITENAME}}.',
	'deletedcontributions' => 'Deleted user contributions',
	'deletedcontributions-title' => 'Deleted user contributions',
	'defemailsubject' => '{{SITENAME}} e-mail from user "$1"',
	'deletepage' => 'Delete page',
	'delete-confirm' => 'Delete "$1"',
	'delete-legend' => 'Delete',
	'deletedtext' => '"$1" has been deleted.
See $2 for a record of recent deletions.',
	'dellogpage' => 'Deletion log',
	'dellogpagetext' => 'Below is a list of the most recent deletions.',
	'deletionlog' => 'deletion log',
	'deletecomment' => 'Reason:',
	'deleteotherreason' => 'Other/additional reason:',
	'deletereasonotherlist' => 'Other reason',
	'deletereason-dropdown' => '*Common delete reasons
** Author request
** Copyright violation
** Vandalism',
	'delete-edit-reasonlist' => 'Edit deletion reasons',
	'delete-toobig' => 'This page has a large edit history, over $1 {{PLURAL:$1|revision|revisions}}.
Deletion of such pages has been restricted to prevent accidental disruption of {{SITENAME}}.',
	'delete-warning-toobig' => 'This page has a large edit history, over $1 {{PLURAL:$1|revision|revisions}}.
Deleting it may disrupt database operations of {{SITENAME}};
proceed with caution.',
	'databasenotlocked' => 'The database is not locked.',
	'delete_and_move' => 'Delete and move',
	'delete_and_move_text' => '== Deletion required ==
The destination page "[[:$1]]" already exists.
Do you want to delete it to make way for the move?',
	'delete_and_move_confirm' => 'Yes, delete the page',
	'delete_and_move_reason' => 'Deleted to make way for move from "[[$1]]"',
	'djvu_page_error' => 'DjVu page out of range',
	'djvu_no_xml' => 'Unable to fetch XML for DjVu file',
	'deletedrevision' => 'Deleted old revision $1',
	'days-abbrev' => '$1d',
	'days' => '{{PLURAL:$1|$1 day|$1 days}}',
	'deletedwhileediting' => "'''Warning''': This page was deleted after you started editing!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => '\'\'\'Warning:\'\'\' Default sort key "$2" overrides earlier default sort key "$1".',
	'dberr-header' => 'This wiki has a problem',
	'dberr-problems' => 'Sorry!
This site is experiencing technical difficulties.',
	'dberr-again' => 'Try waiting a few minutes and reloading.',
	'dberr-info' => '(Cannot contact the database server: $1)',
	'dberr-usegoogle' => 'You can try searching via Google in the meantime.',
	'dberr-outofdate' => 'Note that their indexes of our content may be out of date.',
	'dberr-cachederror' => 'This is a cached copy of the requested page, and may not be up to date.',
	'deletedarticle' => 'deleted "[[$1]]"',
	'defaultskin1' => 'The admins for this wiki have chosen: <b>$1</b> as the default skin.',
	'defaultskin2' => 'The admins for this wiki have chosen: <b>$1</b> as the default skin. Click <a href="$2">here</a> to see the code.',
	'defaultskin3' => 'The admins for this wiki have not chosen a default skin. Using the Wikia default: <b>$1</b>.',
	'defaultskin_choose' => 'Set the default theme for this wiki: ',
	'discuss' => 'Discuss this page',
);

$messages['qqq'] = array(
	'december' => 'The twelfth month of the Gregorian calendar',
	'december-gen' => 'The twelfth month of the Gregorian calendar. Must be in genitive, if the language has a genitive case.',
	'dec' => 'Abbreviation of December, the twelfth month of the Gregorian calendar',
	'delete' => 'Name of the Delete tab shown for admins. Should be in the imperative mood.

{{Identical|Delete}}',
	'deletethispage' => '{{Identical|Delete this page}}',
	'disclaimers' => 'Used as display name for the link to [[{{MediaWiki:Disclaimerpage}}]] shown at the bottom of every page on the wiki. Example [[{{MediaWiki:Disclaimerpage}}|{{MediaWiki:Disclaimers}}]].',
	'disclaimerpage' => 'Used as page for that contains the site disclaimer. Used at the bottom of every page on the wiki. Example: [[{{MediaWiki:Disclaimerpage}}|{{MediaWiki:Disclaimers}}]].
{{doc-important|Do not change <tt>Project:</tt> part.}}',
	'dberrortext' => 'Parameters:
* $1 - The last SQL command/query
* $2 - SQL function name
* $3 - Error number
* $4 - Error description',
	'dberrortextcl' => 'Parameters:
* $1 - The last SQL command/query
* $2 - SQL function name
* $3 - Error number
* $4 - Error description',
	'deletedhist' => 'Links to Special:Undelete at Special:RevisionDelete header together with links to the logs and page history.',
	'difference' => 'Displayed under the title when viewing the difference between two or more edits.',
	'diff-multi' => "This message appears in the revision history of a page when comparing two versions which aren't consecutive.",
	'defaultns' => 'Used in [[Special:Preferences]], tab "Search".',
	'default' => '{{Identical|Default}}',
	'diff' => 'Short form of "differences". Used on [[Special:RecentChanges]], [[Special:Watchlist]], ...',
	'destfilename' => 'In [[Special:Upload]]',
	'duplicatesoffile' => 'Shown on file description pages when a file is duplicated

* $1: Number of identical files
* $2: Name of the shown file to link to the special page "FileDuplicateSearch"',
	'download' => 'Direct download link in each line returned by [[Special:MIMESearch]]. Points to the actual file, rather than the image description page.
{{Identical|Download}}',
	'disambiguations' => 'Name of a special page displayed in [[Special:SpecialPages]].',
	'disambiguationspage' => 'This message is the name of the template used for marking disambiguation pages. It is used by [[Special:Disambiguations]] to find all pages which link to disambiguation pages.

{{doc-important|Don\'t translate the "Template:" part!}}',
	'disambiguations-text' => "This block of text is shown on [[:Special:Disambiguations]].

* '''Note:''' Do not change the link [[MediaWiki:Disambiguationspage]], even because it is listed as problematic. Be sure the \"D\" is in uppercase, so not \"d\".

* '''Background information:''' Beyond telling about links going to disambiguation pages, that they are generally bad, it should explain which pages in the article namespace are seen as diambiguations: [[MediaWiki:Disambiguationspage]] usually holds a list of diambiguation templates of the local wiki. Pages linking to one of them (by transclusion) will count as disambiguation pages. Pages linking to these disambiguation pages, instead to the disambiguated article itself, are listed on [[:Special:Disambiguations]].",
	'doubleredirects' => 'Name of [[Special:DoubleRedirects]] displayed in [[Special:SpecialPages]]',
	'doubleredirectstext' => 'Shown on top of [[Special:Doubleredirects]]',
	'double-redirect-fixed-move' => 'This is the message in the log when the software (under the username {{msg|double-redirect-fixer}}) updates the redirects after a page move. See also {{msg|fix-double-redirects}}.',
	'double-redirect-fixer' => "This is the '''username''' of the user who updates the double redirects after a page move. A user is created with this username, so it is perhaps better to not change this message too often. See also {{msg|double-redirect-fixed-move}} and {{msg|fix-double-redirects}}.",
	'deadendpages' => 'Name of special page displayed in [[Special:SpecialPages]]',
	'deadendpagestext' => 'Introductory text for [[Special:DeadendPages]]',
	'deletedcontributions' => 'The message is shown as a link on user contributions page (like [[Special:Contributions/User]]) to the corresponding [[Special:DeletedContributions]] page.

{{Identical|Deleted user contributions}}',
	'deletedcontributions-title' => 'Title of [[Special:DeletedContributions]] (extension), a special page with a list of edits to pages which were deleted. Only viewable by sysops.

{{Identical|Deleted user contributions}}',
	'delete-confirm' => 'The title of the form to delete a page.

$1 = the name of the page',
	'delete-backlink' => '{{optional}}',
	'delete-legend' => '{{Identical|Delete}}',
	'deletedtext' => 'Parameters:
* $1 is a page that was deleted
* $2 is {{msg-mw|deletionlog}}',
	'deletedarticle' => "This is a ''logentry'' message. Parameters:
* $1 is deleted page name.",
	'dellogpage' => 'The name of the deletion log. Used as heading on [[Special:Log/delete]] and in the drop down menu for selecting logs on [[Special:Log]].

{{Identical|Deletion log}}',
	'dellogpagetext' => 'Text in [[Special:Log/delete]].',
	'deletionlog' => 'This message is used to link to the deletion log as parameter $1 of {{msg|Filewasdeleted}}, as parameter $2 of {{msg|deletedtext}}, and in log lines on [[Special:DeletedContributions]].

{{Identical|Deletion log}}',
	'deletecomment' => '{{Identical|Reason}}',
	'deleteotherreason' => '{{Identical|Other/additional reason}}',
	'deletereasonotherlist' => '{{Identical|Other reason}}',
	'deletereason-dropdown' => 'Default reasons for deletion. Displayed as a drop-down list. Format:
<pre>* Group
** Common delete reason
** ...</pre>',
	'delete-edit-reasonlist' => 'Shown beneath the page deletion form on the right side. It is a link to [[MediaWiki:Deletereason-dropdown]]. See also {{msg|Ipb-edit-dropdown}} and {{msg|Protect-edit-reasonlist}}.

{{Identical|Edit delete reasons}}',
	'delete_and_move_text' => 'Used when moving a page, but the destination page already exists and needs deletion. This message is to confirm that you really want to delete the page. See also {{msg|delete and move confirm}}.',
	'delete_and_move_confirm' => 'Used when moving a page, but the destination page already exists and needs deletion. This message is for a checkbox to confirm that you really want to delete the page. See also {{msg|delete and move text}}.',
	'dberr-header' => 'This message does not allow any wiki nor html markup.',
	'dberr-problems' => 'This message does not allow any wiki nor html markup.',
	'dberr-again' => 'This message does not allow any wiki nor html markup.',
	'dberr-info' => 'This message does not allow any wiki nor html markup.',
	'dberr-usegoogle' => 'This message does not allow any wiki nor html markup.',
	'dberr-outofdate' => "In this sentence, '''their''' indexes refers to '''Google's''' indexes. This message does not allow any wiki nor html markup.",
);

$messages['ab'] = array(
	'december' => 'ҧхынҷкәын',
	'december-gen' => 'ҧхынҷкәын',
	'dec' => 'ҧхҷ',
);

$messages['ace'] = array(
	'december' => 'Buleuën Duwa Blah',
	'december-gen' => 'Buleuën Duwa Blah',
	'dec' => 'Dub',
	'delete' => 'Sampôh',
	'deletethispage' => 'Sampôh ôn nyoe',
	'disclaimers' => 'Beunantah',
	'disclaimerpage' => 'Project:Beunantah umom',
	'databaseerror' => 'Kesalahan basis data',
	'difference' => '(Bida antara geunantoë)',
	'diff-multi' => '({{PLURAL:$1|Sa|$1}} geunantoë antara hana geupeuleumah.)',
	'diff' => 'bida',
	'disambiguations' => 'Ôn disambiguasi',
	'doubleredirects' => 'Peuninah ganda',
	'deadendpages' => 'Ôn buntu',
	'deletepage' => 'Sampôh ôn',
	'deletedtext' => '"$1" ka geusampôh. Eu $2 keu log paléng barô bak ôn nyang ka geusampôh.',
	'dellogpage' => 'Log seunampoh',
	'deletecomment' => 'Choë:',
	'deleteotherreason' => 'Nyang la’én/choë la’én:',
	'deletereasonotherlist' => 'Choë la’én',
);

$messages['af'] = array(
	'december' => 'Desember',
	'december-gen' => 'Desember',
	'dec' => 'Des',
	'delete' => 'Skrap',
	'deletethispage' => 'Skrap die bladsy',
	'disclaimers' => 'Voorbehoud',
	'disclaimerpage' => 'Project:Voorwaardes',
	'databaseerror' => 'Databasisfout',
	'dberrortext' => 'Sintaksisfout in databasisnavraag.
Dit kan moontlik dui op \'n fout in die sagteware.
Die laaste navraag was:
<blockquote><tt>$1</tt></blockquote>
vanuit funksie "<tt>$2</tt>".
Databasis gee foutboodskap "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Sintaksisfout in databasisnavraag.
Die laaste navraag was:
"$1"
vanuit funksie "$2".
Databasis gee foutboodskap: "$3: $4".',
	'directorycreateerror' => 'Kon nie gids "$1" skep nie.',
	'deletedhist' => 'Verwyderde geskiedenis',
	'difference' => '(Verskil tussen weergawes)',
	'difference-multipage' => '(Verskil tussen bladsye)',
	'diff-multi' => '({{PLURAL:$1|Een tussenin wysiging|$1 tussenin wysigings}} deur {{PLURAL:$2|een gebruiker|$2 gebruikers}} word nie gewys nie)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Een tussenin wysiging|$1 tussenin wysigings}} deur meer as $2 {{PLURAL:$2|gebruiker|gebruikers}} nie gewys nie)',
	'datedefault' => 'Geen voorkeur',
	'defaultns' => 'Anders soek in hierdie naamruimtes:',
	'default' => 'verstek',
	'diff' => 'verskil',
	'destfilename' => 'Teikenlêernaam:',
	'duplicatesoffile' => "Die volgende {{PLURAL:$1|lêer is 'n duplikaat|$1 lêers is duplikate}} van die lêer ([[Special:FileDuplicateSearch/$2|meer details]]):",
	'download' => 'laai af',
	'disambiguations' => 'Bladsye wat na dubbelsinnigheidsbladsye skakel',
	'disambiguationspage' => 'Template:Dubbelsinnig',
	'disambiguations-text' => "Die volgende bladsye skakel na '''dubbelsinnigheidsbladsye'''.
Die bladsye moet gewysig word om eerder direk na die regte onderwerpe te skakel.<br />
'n Bladsy word beskou as 'n dubbelsinnigheidsbladsy as dit 'n sjabloon bevat wat geskakel is vanaf [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dubbele aansture',
	'doubleredirectstext' => 'Hierdie lys bevat bladsye wat aansture na ander aanstuurblaaie is.
Elke ry bevat skakels na die eerste en die tweede aanstuur, asook die eerste reël van van die tweede aanstuur se teks, wat gewoonlik die "regte" teiken-bladsy gee waarna die eerste aanstuur behoort te wys.
<del>Doodgekrapte reëls</del> dui aan dat die probleem reeds opgelos is.',
	'double-redirect-fixed-move' => "[[$1]] was geskuif en is nou 'n deurverwysing na [[$2]].",
	'double-redirect-fixed-maintenance' => 'Maak dubbele aanstuur vanaf [[$1]] na [[$2]] reg.',
	'double-redirect-fixer' => 'Aanstuur hersteller',
	'deadendpages' => 'Doodloopbladsye',
	'deadendpagestext' => 'Die volgende bladsye bevat nie skakels na ander bladsye in {{SITENAME}} nie:',
	'deletedcontributions' => 'Geskrapte gebruikersbydraes',
	'deletedcontributions-title' => 'Geskrapte gebruikersbydraes',
	'defemailsubject' => 'E-pos van {{SITENAME}}-gebruiker "$1"',
	'deletepage' => 'Skrap bladsy',
	'delete-confirm' => 'Skrap "$1"',
	'delete-legend' => 'Skrap',
	'deletedtext' => '"$1" is geskrap.
Kyk na $2 vir \'n rekord van onlangse skrappings.',
	'dellogpage' => 'Skraplogboek',
	'dellogpagetext' => "Hier onder is 'n lys van die mees onlangse skrappings. Alle tye is bedienertyd (UGT).",
	'deletionlog' => 'skrappings-logboek',
	'deletecomment' => 'Rede:',
	'deleteotherreason' => 'Ander/ekstra rede:',
	'deletereasonotherlist' => 'Andere rede',
	'deletereason-dropdown' => '*Algemene redes vir verwydering
** Op aanvraag van outeur
** Skending van kopieregte
** Vandalisme',
	'delete-edit-reasonlist' => 'Wysig skrap redes',
	'delete-toobig' => "Die bladsy het 'n lang wysigingsgeskiedenis, meer as $1 {{PLURAL:$1|weergawe|weergawes}}.
Verwydering van die soort blaaie is beperk om ontwrigting van {{SITENAME}} te voorkom.",
	'delete-warning-toobig' => "Hierdie bladsy het 'n lang wysigingsgeskiedenis; meer as $1 {{PLURAL:$1|wysiging|wysigings}}.
Deur weg te doen met hierdie bladsy mag dalk die werking van {{SITENAME}} versteur;
Tree asseblief versigtig op.",
	'databasenotlocked' => 'Die databasis is nie gesluit nie.',
	'delete_and_move' => 'Skrap en skuif',
	'delete_and_move_text' => '==Skrapping benodig==

Die teikenartikel "[[:$1]]" bestaan reeds. Wil u dit skrap om plek te maak vir die skuif?',
	'delete_and_move_confirm' => 'Ja, skrap die bladsy',
	'delete_and_move_reason' => 'Geskrap om plek te maak vir skuif vanaf "[[$1]]"',
	'djvu_page_error' => 'DjVu-bladsy buite bereik',
	'djvu_no_xml' => 'Die XML vir die DjVu-lêer kon nie bekom word nie',
	'deletedrevision' => 'Ou weergawe $1 geskrap',
	'days' => '{{PLURAL:$1|$1 dag|$1 dae}}',
	'deletedwhileediting' => "'''Let op''': die bladsy is verwyder terwyl u besig was om dit te wysig!",
	'descending_abbrev' => 'af',
	'duplicate-defaultsort' => 'Waarskuwing: Die standaardsortering "$2" kry voorrang voor die sortering "$1".',
	'dberr-header' => "Die wiki het 'n probleem",
	'dberr-problems' => 'Jammer! Die webwerf ondervind op die oomblik tegniese probleme.',
	'dberr-again' => "Wag 'n paar minute en probeer dan weer.",
	'dberr-info' => '(Kan nie die databasisbediener kontak nie: $1)',
	'dberr-usegoogle' => 'Tot tyd en wyl kan u inligting op Google soek.',
	'dberr-outofdate' => 'Let daarop dat hulle indekse van ons inhoud moontlik verouderd mag wees.',
	'dberr-cachederror' => "Hierdie is 'n gekaste kopie van die aangevraagde blad, en dit mag moontlik nie op datum wees nie.",
);

$messages['ak'] = array(
	'december' => 'Ɔpenimma',
);

$messages['aln'] = array(
	'december' => 'dhetor',
	'december-gen' => 'dhetorit',
	'dec' => 'Dhe',
	'delete' => 'Fshij',
	'deletethispage' => 'Fshije këtë faqe',
	'disclaimers' => 'Shfajsimet',
	'disclaimerpage' => 'Project:Shfajsimet e përgjithshme',
	'databaseerror' => 'Gabim në databazë',
	'dberrortext' => 'Ka ndodh nji gabim sintaksor në kërkesën në databazë.
Kjo mundet me tregue gabim në software.
Kërkesa e fundit në databazë ishte:
<blockquote><tt>$1</tt></blockquote>
mbrenda funksionit "<tt>$2</tt>".
Databaza ktheu gabimin "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ka ndodh nji gabim sintaksor në kërkesën në databazë.
Kërkesa e fundit në databazë ishte:
"$1"
mbrenda funksionit "$2".
Databaza ktheu gabimin "$3: $4".',
	'directorycreateerror' => 'Nuk mujta me krijue direktorinë "$1".',
	'deletedhist' => 'Historiku i grisjeve',
	'difference' => '(Dallimet midis verzioneve)',
	'diff-multi' => '({{PLURAL:$1|Një redaktim ndërmjet nuk është|$1 redaktime ndërmjet nuk janë}} treguar.)',
	'datedefault' => "S'ka parapëlqim",
	'defaultns' => 'Përndryshe kërko në këto hapësina:',
	'default' => 'e paracaktueme',
	'diff' => 'ndrysh',
	'download' => 'shkarkim',
	'deletepage' => 'Fshij faqen',
	'deletedtext' => '"$1" âsht fshi.
Shih $2 për regjistrin e fshimjeve të fundit.',
	'dellogpage' => 'Regjistri i fshimjeve',
	'deletecomment' => 'Arsyeja:',
	'deleteotherreason' => 'Arsyet tjera/shtesë:',
	'deletereasonotherlist' => 'Arsye tjetër',
);

$messages['als'] = array(
	'december' => 'dhetor',
	'december-gen' => 'dhetorit',
	'dec' => 'Dhe',
	'delete' => 'Fshij',
	'deletethispage' => 'Fshije këtë faqe',
	'disclaimers' => 'Shfajsimet',
	'disclaimerpage' => 'Project:Shfajsimet e përgjithshme',
	'databaseerror' => 'Gabim në databazë',
	'dberrortext' => 'Ka ndodh nji gabim sintaksor në kërkesën në databazë.
Kjo mundet me tregue gabim në software.
Kërkesa e fundit në databazë ishte:
<blockquote><tt>$1</tt></blockquote>
mbrenda funksionit "<tt>$2</tt>".
Databaza ktheu gabimin "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ka ndodh nji gabim sintaksor në kërkesën në databazë.
Kërkesa e fundit në databazë ishte:
"$1"
mbrenda funksionit "$2".
Databaza ktheu gabimin "$3: $4".',
	'directorycreateerror' => 'Nuk mujta me krijue direktorinë "$1".',
	'deletedhist' => 'Historiku i grisjeve',
	'difference' => '(Dallimet midis verzioneve)',
	'diff-multi' => '({{PLURAL:$1|Një redaktim ndërmjet nuk është|$1 redaktime ndërmjet nuk janë}} treguar.)',
	'datedefault' => "S'ka parapëlqim",
	'defaultns' => 'Përndryshe kërko në këto hapësina:',
	'default' => 'e paracaktueme',
	'diff' => 'ndrysh',
	'download' => 'shkarkim',
	'deletepage' => 'Fshij faqen',
	'deletedtext' => '"$1" âsht fshi.
Shih $2 për regjistrin e fshimjeve të fundit.',
	'dellogpage' => 'Regjistri i fshimjeve',
	'deletecomment' => 'Arsyeja:',
	'deleteotherreason' => 'Arsyet tjera/shtesë:',
	'deletereasonotherlist' => 'Arsye tjetër',
);

$messages['am'] = array(
	'december' => 'ዲሴምበር',
	'december-gen' => 'ዲሴምበር',
	'dec' => 'ዲሴም.',
	'delete' => 'ይጥፋ',
	'deletethispage' => 'ይህን ገጽ ሰርዝ',
	'disclaimers' => 'የኃላፊነት ማስታወቂያ',
	'disclaimerpage' => 'Project:አጠቃላይ የሕግ ነጥቦች',
	'databaseerror' => 'የመረጃ-ቤት ስህተት',
	'dberrortext' => 'የመረጃ-ቤት ጥያቄ ስዋሰው ስህተት ሆኗል። ይህ ምናልባት በሶፍትዌሩ ወስጥ ያለ ተውሳክ ሊጠቆም ይችላል። መጨረሻ የተሞከረው መረጃ-ቤት ጥያቄ <blockquote><tt>$1</tt></blockquote> ከተግባሩ «<tt>$2</tt>» ውስጥ ነበረ። MySQL ስህተት «<tt>$3: $4</tt>» መለሰ።',
	'dberrortextcl' => 'የመረጃ-ቤት ጥያቄ ስዋሰው ስህተት ሆኗል። መጨረሻ የተሞከረው መረጃ-ቤት ጥያቄ <blockquote><tt>$1</tt></blockquote> ከተግባሩ «<tt>$2</tt>» ውስጥ ነበረ። MySQL ስህተት «<tt>$3: $4</tt>» መለሰ።',
	'directorycreateerror' => 'ዶሴ «$1» መፍጠር አልተቻለም።',
	'difference' => '(በ2ቱ እትሞቹ ዘንድ ያለው ልዩነት)',
	'diff-multi' => '(ከነዚህ 2 እትሞች መካከል {{PLURAL:$1|አንድ ለውጥ ነበር|$1 ለውጦች ነበሩ}}።)',
	'datedefault' => 'ግድ የለኝም',
	'defaultns' => 'በመጀመርያው ፍለጋዎ በነዚህ ክፍለ-ዊኪዎች ብቻ ይደረግ:',
	'default' => 'ቀዳሚ',
	'diff' => 'ለውጡ',
	'destfilename' => 'የፋይሉ አዲስ ስም፦',
	'duplicatesoffile' => '{{PLURAL:$1|የሚከተለው ፋይል የዚህ ፋይል ቅጂ ነው|የሚከተሉት $1 ፋይሎች የዚሁ ፋይል ቅጂዎች ናቸው}}፦',
	'download' => 'አውርድ',
	'disambiguations' => 'ወደ መንታ መንገድ የሚያያይዝ',
	'disambiguationspage' => 'Template:መንታ',
	'disambiguations-text' => "የሚከተሉት ጽሑፎች ወደ '''መንታ መንገድ''' እየተያያዙ ነውና ብዙ ጊዜ እንዲህ ሳይሆን ወደሚገባው ርዕስ ቢወስዱ ይሻላል። <br />
መንታ መንገድ ማለት የመንታ መለጠፊያ ([[MediaWiki:Disambiguationspage]]) ሲኖርበት ነው።",
	'doubleredirects' => 'ድርብ መምሪያ መንገዶች',
	'doubleredirectstext' => 'ይህ ድርብ መምሪያ መንገዶች ይዘርዘራል።

ድርብ መምሪያ መንገድ ካለ ወደ መጨረሻ መያያዣ እንዲሄድ ቢስተካከል ይሻላል።',
	'double-redirect-fixed-move' => '[[$1]] ተዛውራልና አሁን ለ[[$2]] መምሪያ መንገድ ነው።',
	'double-redirect-fixer' => 'የመምሪያ መንገድ አስተካካይ',
	'deadendpages' => 'መያያዣ የሌለባቸው ፅሑፎች',
	'deadendpagestext' => 'የሚቀጥሉት ገጾች በ{{SITENAME}} ውስጥ ከሚገኙ ሌሎች ገጾች ጋር አያያይዙም።',
	'defemailsubject' => '{{SITENAME}} Email / ኢ-ሜል',
	'deletepage' => 'ገጹ ይጥፋ',
	'delete-confirm' => '«$1» ለማጥፋት',
	'delete-legend' => 'ለማጥፋት',
	'deletedtext' => '«$1» ጠፍቷል።

(የጠፉትን ገጾች ሁሉ ለመመልከት $2 ይዩ።)',
	'dellogpage' => 'የማጥፋት መዝገብ',
	'dellogpagetext' => 'በቅርቡ የጠፉት ገጾች ከዚህ ታች የዘረዝራሉ።',
	'deletionlog' => 'የማጥፋት መዝገብ',
	'deletecomment' => 'ምክንያት:',
	'deleteotherreason' => 'ሌላ /ተጨማሪ ምክንያት',
	'deletereasonotherlist' => 'ሌላ ምክንያት',
	'deletereason-dropdown' => '*ተራ የማጥፋት ምክንያቶች
** በአቅራቢው ጥያቄ
** ማብዛቱ ያልተፈቀደለት ጽሑፍ
** ተንኮል',
	'delete-edit-reasonlist' => "'ተራ የማጥፋት ምክንያቶች' ለማዘጋጀት",
	'databasenotlocked' => 'መረጃ-ቤቱ የተቆለፈ አይደለም።',
	'delete_and_move' => 'ማጥፋትና ማዛወር',
	'delete_and_move_text' => '==ማጥፋት ያስፈልጋል==

መድረሻው ገጽ ሥፍራ «[[:$1]]» የሚለው ገጽ አሁን ይኖራል። ሌላው ገጽ ወደዚያ እንዲዛወር እሱን ለማጥፋት ይወድዳሉ?',
	'delete_and_move_confirm' => 'አዎን፣ ገጹ ይጥፋ',
	'delete_and_move_reason' => 'ለመዛወሩ ሥፍራ እንዲገኝ ጠፋ',
	'deletedrevision' => 'የቆየው ዕትም $1 አጠፋ',
	'deletedwhileediting' => "'''ማስጠንቀቂያ'''፦ መዘጋጀት ከጀመሩ በኋላ ገጹ ጠፍቷል!",
);

$messages['an'] = array(
	'december' => 'aviento',
	'december-gen' => "d'aviento",
	'dec' => 'avi',
	'delete' => 'Borrar',
	'deletethispage' => 'Borrar ista pachina',
	'disclaimers' => 'Alvertencias chenerals',
	'disclaimerpage' => 'Project:Alvertencias chenerals',
	'databaseerror' => "Error d'a base de datos",
	'dberrortext' => 'Ha sucedito una error de sintaxi en una consulta a la base de datos.
Isto podría marcar una error en o programa.
A zaguera consulta estió:
<blockquote><tt>$1</tt></blockquote>
dende adintro d\'a función "<tt>$2</tt>".
A error retornata por a base de datos estió "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'S\'ha producito una error de sintaxi en una consulta a la base de datos.
A zaguera consulta estió:
"$1"
dende adintro d\'a función "$2".
A base de datos retornó a error "$3: $4"',
	'directorycreateerror' => 'No s\'ha puesto crear o directorio "$1".',
	'deletedhist' => 'Historial de borrau',
	'difference' => '(Esferencias entre versions)',
	'difference-multipage' => '(Diferencia entre pachinas)',
	'diff-multi' => "(No s'amuestra {{PLURAL:$1|una edición entremeya feita|$1 edicions entremeyas feitas}} por {{PLURAL:$2|un usuario|$2 usuarios}}).",
	'diff-multi-manyusers' => "(No s'amuestra {{PLURAL:$1|una edición entremeya|$1 edicions entremeyas}} feitas por más {{PLURAL:$2|d'un usuario|de $2 usuarios}})",
	'datedefault' => 'Sin de preferencias',
	'defaultns' => 'Si no, mirar en istos espacios de nombres:',
	'default' => 'por defecto',
	'diff' => 'dif',
	'destfilename' => "Nombre d'o fichero de destín:",
	'duplicatesoffile' => "{{PLURAL:$1|O siguient fichero ye un duplicato|Os siguients $1 fichers son duplicatos}} d'iste fichero ([[Special:FileDuplicateSearch/$2|más detalles]]):",
	'download' => 'descargar',
	'disambiguations' => 'Pachinas con vinclos enta pachinas de desambigación',
	'disambiguationspage' => 'Template:Desambigación',
	'disambiguations-text' => "As siguients pachinas tienen vinclos ta una '''pachina de desambigación'''.
Ixos vinclos habrían de ir millor t'a pachina especifica apropiada.<br />
Una pachina se considera pachina de desambigación si fa servir una plantilla provenient de  [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Reendreceras dobles',
	'doubleredirectstext' => "En ista pachina s'amuestran as pachinas que son reendreceras enta atras pachinas reendrezatas.
Cada ringlera contién o vinclo t'a primer y segunda reendreceras, y tamién o destino d'a segunda reendrecera, que ye a ormino a pachina obchectivo \"reyal\" a la que a primer pachina habría d'endrezar.",
	'double-redirect-fixed-move' => "S'ha tresladau [[$1]], agora ye una endrecera ta [[$2]]",
	'double-redirect-fixed-maintenance' => 'Correchindo a doble reendrecera dende [[$1]] ta [[$2]].',
	'double-redirect-fixer' => 'Apanyador de reendreceras',
	'deadendpages' => 'Pachinas sin salida',
	'deadendpagestext' => 'As siguients pachinas no tienen vinclos ta garra atra pachina de {{SITENAME}}.',
	'deletedcontributions' => "Contrebucions d'usuario borratas",
	'deletedcontributions-title' => "Contrebucions d'usuario borradas",
	'defemailsubject' => "Correu de {{SITENAME}} de l'usuario $1",
	'deletepage' => 'Borrar ista pachina',
	'delete-confirm' => 'Borrar "$1"',
	'delete-legend' => 'Borrar',
	'deletedtext' => 'S\'ha borrau "$1".
Se veiga en $2 un rechistro d\'os borraus recients.',
	'dellogpage' => 'Rechistro de borraus',
	'dellogpagetext' => "Contino se i amuestra una lista d'os borraus más recients.",
	'deletionlog' => 'rechistro de borraus',
	'deletecomment' => 'Razón:',
	'deleteotherreason' => 'Otras/Más razons:',
	'deletereasonotherlist' => 'Atra razón',
	'deletereason-dropdown' => "*Razons comuns de borrau
** A requesta d'o mesmo autor
** Trencar de copyright
** Vandalismo",
	'delete-edit-reasonlist' => "Editar as razons d'o borrau",
	'delete-toobig' => "Ista pachina tiene un historial d'edicions prou largo, con mas de $1 {{PLURAL:$1|versión|versions}}. S'ha restrinchito o borrau d'ista mena de pachinas ta aprevenir d'a corrompición accidental de {{SITENAME}}.",
	'delete-warning-toobig' => "Ista pachina tiene un historial d'edición prou largo, con más de $1 {{PLURAL:$1|versión|versions}}. Si la borra podría corromper as operacions d'a base de datos de {{SITENAME}}; contine con cuenta.",
	'databasenotlocked' => 'A base de datos no ye trancata.',
	'delete_and_move' => 'Borrar y tresladar',
	'delete_and_move_text' => '==S\'amenista borrar a pachina==

A pachina de destino ("[[:$1]]") ya existe. Quiere borrar-la ta premitir o treslau?',
	'delete_and_move_confirm' => 'Sí, borrar a pachina',
	'delete_and_move_reason' => 'Borrata ta permitir o treslau de "[[$1]]"',
	'djvu_page_error' => "Pachina DjVu difuera d'o rango",
	'djvu_no_xml' => "No s'ha puesto replegar o XML ta o fichero DjVu",
	'deletedrevision' => "S'ha borrato a versión antiga $1",
	'days' => '{{PLURAL:$1|un día|$1 días}}',
	'deletedwhileediting' => "Pare cuenta: Ista pachina s'ha borrato dimpués de que vusté prencipiase a editar!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => "Pare cuenta: A clau d'ordenación por defecto «$2» anula l'anterior clau d'ordenación por defecto «$1».",
	'dberr-header' => 'Iste wiki tiene un problema',
	'dberr-problems' => 'Lo sentimos. Iste sitio ye experimentando dificultatz tecnicas.',
	'dberr-again' => 'Mire de recargar en bells menutos.',
	'dberr-info' => "(No s'ha puesto contactar con o servidor d'a base de datos: $1)",
	'dberr-usegoogle' => 'Entremistanto puet preba a mirar a traviés de Google.',
	'dberr-outofdate' => "Pare cuenta que o suyo endice d'o nuestro conteniu puet que no siga esviellau.",
	'dberr-cachederror' => "A siguient pachina ye una pachina alzada d'a pachina solicitada, y podría no estar actualizada.",
);

$messages['ang'] = array(
	'december' => 'Ǣrra Ȝēola',
	'december-gen' => 'Ǣrran Ȝēolan',
	'dec' => 'Æf Ȝē',
	'delete' => 'Forlēos',
	'deletethispage' => 'Forlēos þās sīdan',
	'disclaimers' => 'Ætsacunga',
	'disclaimerpage' => 'Project:Ætsacunga',
	'databaseerror' => 'Cȳþþuhordes ƿōh',
	'dberrortext' => 'Cȳþþuhordes bēnes endebyrdnesse fremmode ƿōh.
Þis mæȝe mǣnan regolƿōh on þǣre sōftƿare.
Sēo nīƿoste ȝesōhte sōftƿare bēn ƿæs:
<blockquote><tt>$1</tt></blockquote>
fram innan ƿeorce "<tt>$2</tt>".
Cȳþþuhord edƿende ƿōh "<tt>$3: $4</tt>"',
	'difference' => '(Scēadung betwēonan hweorfungum)',
	'defaultns' => 'Sēcan in þissum namstedum be frambyge:',
	'default' => 'gewunelic',
	'diff' => 'scēa',
	'duplicatesoffile' => '{{PLURAL:$1|Sēo folgende fīl is ȝelīċnes|Þā folgende fīlan sind ȝelīċnessa}} þisses fīles (sēo [[Special:FileDuplicateSearch/$2|mā ȝeƿitnesse hērymb]]):',
	'doubleredirects' => 'Tƿifealde ymblǣderas',
	'deletepage' => 'Sīdan āfeorsian',
	'dellogpage' => 'Āfeorsunge ƿīsbōc',
	'deletionlog' => 'āfeorsunge wisbōc',
	'deletecomment' => 'Racu:',
	'deleteotherreason' => 'Ōðra/ēaca racu:',
	'deletereasonotherlist' => 'Ōðru racu',
);

$messages['anp'] = array(
	'december' => 'दिसंबर',
	'december-gen' => 'दिसंबर',
	'dec' => 'दिसं.',
	'delete' => 'हटाबॊ',
	'disclaimers' => 'अस्वीकरण',
	'disclaimerpage' => 'Project:साधारण अस्वीकरण',
	'difference' => '(संस्करणॊ मॆ अंतर)',
	'diff' => 'अंतर',
	'deletepage' => 'पन्ना हटाबॊ',
	'deletedtext' => '"$1" कॆ हटैलॊ गेलॊ छै.
हाल में हटैलॊ गेलॊ लेखॊ के सूची लेली $2 देखॊ.',
	'dellogpage' => 'हटाबै के सूची',
	'dellogpagetext' => 'नीचॆ हाल मॆं हटैलॊ गेलॊ पन्ना के सूची छै.',
	'deletionlog' => 'हटाबै के सूची',
	'deletecomment' => 'कारण:',
	'deleteotherreason' => 'दोसरॊ/अतिरिक्त कारण:',
	'deletereasonotherlist' => 'दोसरॊ कारण',
	'deletereason-dropdown' => '*हटाबै के सामान्य कारण
** लेखक के बिनती
** कॉपीराईट
** वॅन्डॅलिजम',
	'delete-edit-reasonlist' => 'हटाबै के कारण कॆ संपादित करॊ',
	'delete-toobig' => 'इ पन्ना केरॊ संपादन इतिहास $1 सॆं अधिक {{PLURAL:$1|संस्करण|संस्करण}} होला के वजह सॆं बहुत बड़ा छै.
{{SITENAME}} के अनपेक्षित रूप सॆं बंद होला सॆं रोकै लेली ऐसनॊ पन्ना कॆ हटाबै के अनुमति नै छै.',
	'delete-warning-toobig' => 'इस लेख केरॊ संपादन इतिहास काफ़ी लंबा चौड़ा छै, ऐकरॊ $1 सॆं अधिक {{PLURAL:$1|संस्करण|संस्करण}} छै.
एकरा हटैला सॆं {{SITENAME}} के आँकड़ाकोष के गतिविधियॊ मॆं व्यवधान आबॆ सकॆ छै;
कृपया सोची समझी कॆ आगू बढ़ॊ.',
);

$messages['ar'] = array(
	'december' => 'ديسمبر',
	'december-gen' => 'ديسمبر',
	'dec' => 'ديسمبر',
	'delete' => 'احذف',
	'deletethispage' => 'احذف هذه الصفحة',
	'disclaimers' => 'عدم مسؤولية',
	'disclaimerpage' => 'Project:عدم مسؤولية عام',
	'databaseerror' => 'خطأ في قاعدة البيانات',
	'dberrortext' => 'حدث خطأ في صيغة استعلام قاعدة البيانات.
ربما يكون هذا عيب بالبرنامج.
آخر استعلام طلب من قاعدة البيانات كان:
<blockquote><tt>$1</tt></blockquote>
من داخل الدالة "<tt>$2</tt>".
أرجعت قاعدة البيانات الخطأ "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'حدث خطأ في صيغة استعلام قاعدة البيانات.
آخر استعلام طلب من قاعدة البيانات كان:
"$1"
من داخل الدالة "$2".
أرجعت قاعدة البيانات الخطأ "$3: $4"',
	'directorycreateerror' => 'لم يمكن إنشاء المجلد "$1".',
	'deletedhist' => 'التاريخ المحذوف',
	'difference' => '(الفرق بين المراجعتين)',
	'difference-multipage' => '(الفرق بين الصفحتين)',
	'diff-multi' => '({{PLURAL:$1||مراجعة واحدة متوسطة غير معروضة|مراجعتان متوسطتان غير معروضتان|$1 مراجعات متوسطة غير معروضة|$1 مراجعة متوسطة غير معروضة}} أجراها {{PLURAL:$2||مستخدم واحد|مستخدمان|$2 مستخدمين|$2 مستخدمًا|$2 مستخدم}}.)',
	'diff-multi-manyusers' => '({{PLURAL:$1||مراجعة واحدة متوسطة غير معروضة أجراها|مراجعتان متوسطتان غير معروضتان أجراهما|$1 مراجعات متوسطة غير معروضة أجراها|$1 مراجعة متوسطة غير معروضة أجراها}} أكثر من {{PLURAL:$2||مستخدم واحد|مستخدمين|$2 مستخدمين|$2 مستخدمًا|$2 مستخدم}}.)',
	'datedefault' => 'لا تفضيل',
	'defaultns' => 'أو ابحث في هذه النطاقات:',
	'default' => 'افتراضي',
	'diff' => 'فرق',
	'destfilename' => 'اسم الملف المستهدف:',
	'duplicatesoffile' => '{{PLURAL:$1|الملف التالي مكرر|ال$1 ملف التالي مكررات}} لهذا الملف
([[Special:FileDuplicateSearch/$2|المزيد من التفاصيل]]):',
	'download' => 'تنزيل',
	'disambiguations' => 'الصفحات التي ترتبط بصفحات توضيح',
	'disambiguationspage' => 'Template:توضيح',
	'disambiguations-text' => "الصفحات التالية تصل إلى '''صفحة توضيح'''.
ينبغي في المقابل أن تصل إلى الصفحة الملائمة. <br />
تعامل الصفحة كصفحة توضيح إذا كان بها قالب موجود في [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'تحويلات مزدوجة',
	'doubleredirectstext' => 'هذه الصفحة تعرض الصفحات التي تحول إلى صفحات تحويل أخرى.
كل سطر يحتوي على وصلات للتحويلة الأولى والثانية وهدف التحويلة الثانية، والذي عادة ما يشير إلى صفحة الهدف "الحقيقية"، التي من المفترض أن تحول إليها التحويلة الأولى.
المدخلات <del>المشطوبة</del> صححت.',
	'double-redirect-fixed-move' => '[[$1]] تم نقلها، هي الآن تحويلة إلى [[$2]]',
	'double-redirect-fixed-maintenance' => 'تصليح تحويلة مزدوجة من [[$1]] إلى [[$2]].',
	'double-redirect-fixer' => 'مصلح التحويل',
	'deadendpages' => 'صفحات نهاية مسدودة',
	'deadendpagestext' => 'الصفحات التالية لا تصل إلى صفحات أخرى في {{SITENAME}}.',
	'deletedcontributions' => 'مساهمات المستخدم المحذوفة',
	'deletedcontributions-title' => 'مساهمات المستخدم المحذوفة',
	'defemailsubject' => 'رسالة {{SITENAME}} من المستخدم "$1"',
	'deletepage' => 'حذف الصفحة',
	'delete-confirm' => 'حذف "$1"',
	'delete-legend' => 'حذف',
	'deletedtext' => '"$1" تم حذفها.
انظر في $2 لسجل آخر عمليات الحذف.',
	'dellogpage' => 'سجل الحذف',
	'dellogpagetext' => 'بالأسفل قائمة بأحدث عمليات الحذف.',
	'deletionlog' => 'سجل الحذف',
	'deletecomment' => 'السبب:',
	'deleteotherreason' => 'سبب آخر/إضافي:',
	'deletereasonotherlist' => 'سبب آخر',
	'deletereason-dropdown' => '*أسباب الحذف الشائعة
** طلب المؤلف
** خرق لحقوق التأليف والنشر
** تخريب',
	'delete-edit-reasonlist' => 'عدل أسباب الحذف',
	'delete-toobig' => 'لهذه الصفحة تاريخ تعديل طويل، أكثر من {{PLURAL:$1||مراجعة واحدة|مراجعتين|$1 مراجعات|$1 مراجعة}}.
قُيّد محذف مثل هذه الصفحات لمنع الاضطراب المفاجئة في {{SITENAME}}.',
	'delete-warning-toobig' => 'لهذه الصفحة تاريخ تعديل طويل، أكثر من {{PLURAL:$1||مراجعة واحدة|مراجعتين|$1 مراجعات|$1 مراجعة}}.
قد يؤدي حذفها إلى اضطراب عمليات قاعدة البيانات في {{SITENAME}}؛
استمر مع الحذر.',
	'databasenotlocked' => 'قاعدة البيانات ليست مغلقة.',
	'delete_and_move' => 'حذف ونقل',
	'delete_and_move_text' => '==الحذف مطلوب==
الصفحة الهدف "[[:$1]]" موجودة بالفعل.
هل تريد حذفها لإفساح المجال للنقل؟',
	'delete_and_move_confirm' => 'نعم، احذف الصفحة',
	'delete_and_move_reason' => 'حُذِفت لإفساح مجال لنقل "[[$1]]"',
	'djvu_page_error' => 'صفحة DjVu خارج النطاق',
	'djvu_no_xml' => 'لا يمكن جلب XML لملف DjVu',
	'deletedrevision' => 'حذف المراجعة القديمة $1',
	'days' => '{{PLURAL:$1||يوم واحد|يومين|$1 أيام|$1 يومًا|$1 يوم}}',
	'deletedwhileediting' => "'''تحذير''': هذه الصفحة تم حذفها بعد أن بدأت أنت بتعديلها!",
	'descending_abbrev' => 'تنازلي',
	'duplicate-defaultsort' => '\'\'\'تحذير:\'\'\' مفتاح الترتيب الافتراضي "$2" يتجاوز مفتاح الترتيب الافتراضي السابق "$1".',
	'dberr-header' => 'هذا الويكي به مشكلة',
	'dberr-problems' => 'عذرا! هذا الموقع يعاني من صعوبات تقنية.',
	'dberr-again' => 'جرب الانتظار بضع دقائق وإعادة التحميل.',
	'dberr-info' => '(غير قادر على الاتصال بخادوم قاعدة البيانات: $1)',
	'dberr-usegoogle' => 'يمكنك محاولة البحث من خلال جوجل في الوقت الحاضر.',
	'dberr-outofdate' => 'لاحظ أن فهارسهم لمحتوانا ربما تكون غير محدثة.',
	'dberr-cachederror' => 'التالي نسخة مخزنة من الصفحة المطلوبة، وربما لا تكون محدثة.',
	'discuss' => 'ناقش',
);

$messages['arc'] = array(
	'december' => 'ܟܢܘܢ ܩܕܡ',
	'december-gen' => 'ܟܢܘܢ ܩܕܡ',
	'dec' => 'ܟܢܘܢ ܩܕܡ',
	'delete' => 'ܫܘܦ',
	'deletethispage' => 'ܫܘܦ ܦܐܬܐ ܗܕܐ',
	'disclaimers' => 'ܠܐ ܡܫܬܐܠܢܘܬܐ',
	'disclaimerpage' => 'Project:ܠܐ ܡܫܬܐܠܢܘܬܐ ܓܘܢܝܬܐ',
	'deletedhist' => 'ܬܫܥܝܬܐ ܫܝܦܬܐ',
	'difference' => '(ܦܪܝܫܘܬܐ ܒܝܬ ܬܢܝܬ̈ܐ)',
	'diff-multi' => '({{PLURAL:$1|ܚܕܐ ܬܢܝܬܐ ܡܨܥܝܬܐ|$1 ܬܢܝܬ̈ܐ ܡܨܥܝܬ̈ܐ}} ܒܝܕ {{PLURAL:$2|ܚܕ ܡܦܠܚܢܐ ܠܐ ܓܠܝܚܬܐ|$2 ܡܦܠܚܢ̈ܐ ܠܐ ܓܠܝܚܬ̈ܐ}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|One ܚܕܐ ܬܢܝܬܐ ܡܨܥܝܬܐ|$1 ܬܢܝܬ̈ܐ ܡܨܥܝܬ̈ܐ}} ܒܝܕ ܝܬܝܪ ܡܢ $2 {{PLURAL:$2|ܚܕ ܡܦܠܚܢܐ ܠܐ ܓܠܝܚܬܐ|ܡܦܠܚܢ̈ܐ ܠܐ ܓܠܝܚܬ̈ܐ}})',
	'datedefault' => 'ܠܐ ܓܒܝܬܐ',
	'defaultns' => 'ܐܘ ܒܨܝ ܒܚܩܠܬ̈ܐ ܗܢܝܢ',
	'diff' => 'ܦܪܝܫܘܬܐ',
	'download' => 'ܐܚܬ',
	'disambiguations' => 'ܦܐܬܬ̈ܐ ܐܣܝܪ̈ܬܐ ܒܦܐܬܬ̈ܐ ܕܬܘܚܡܐ ܐܚܪܢܐ',
	'disambiguationspage' => 'Template:ܬܘܚܡܐ ܐܚܪܢܐ',
	'doubleredirects' => 'ܨܘܝܒ̈ܐ ܥܦܝܦ̈ܐ',
	'double-redirect-fixed-move' => '[[$1]] ܐܫܬܢܝܬ.
ܗܫܐ ܐܝܬܝܗܝ  ܨܘܝܒܐ ܠ [[$2]].',
	'deadendpages' => 'ܦܐܬܬ̈ܐ ܥܡ ܚܪܬܐ ܡܝܬܬܐ',
	'deletedcontributions' => 'ܫܘܬܦܘܝܬ̈ܐ ܕܡܦܠܚܢܐ ܫܝܦܬ̈ܐ',
	'deletedcontributions-title' => 'ܫܘܬܦܘܝܬ̈ܐ ܕܡܦܠܚܢܐ ܫܝܦܬ̈ܐ',
	'defemailsubject' => 'ܒܝܠܕܪܐ ܐܠܩܛܪܘܢܝܐ  ܡܢ ܡܦܠܚܢܐ "$1"',
	'deletepage' => 'ܫܘܦ ܦܐܬܐ',
	'delete-confirm' => 'ܫܘܦ "$1"',
	'delete-legend' => 'ܫܘܦ',
	'dellogpage' => 'ܣܓܠܐ ܕܫܝܦܐ',
	'deletionlog' => 'ܣܓܠܐ ܕܫܝܦܐ',
	'deletecomment' => 'ܥܠܬܐ:',
	'deleteotherreason' => 'ܥܠܬܐ ܐܚܪܬܐ/ܝܬܝܪܬܐ:',
	'deletereasonotherlist' => 'ܥܠܬܐ ܐܚܪܬܐ',
	'delete-edit-reasonlist' => 'ܫܚܠܦ ܥܠܠܬ̈ܐ ܕܫܝܦܐ',
	'delete_and_move' => 'ܫܘܦ ܘܫܢܝ',
	'delete_and_move_confirm' => 'ܐܝܢ, ܫܘܦ ܦܐܬܐ',
	'descending_abbrev' => 'ܡܚܬܐܝܬ',
);

$messages['arn'] = array(
	'december' => 'disiempüre küyeṉ',
	'december-gen' => 'disiempüre küyeṉ',
	'dec' => 'disiempüre',
	'delete' => 'Liftun',
	'deletethispage' => 'Ñamümün tüfachi pakina',
	'disclaimers' => 'Tukuldungun ñi pin ley',
	'disclaimerpage' => 'Project:Katrütuwün ñi llowdüngun',
	'deletedhist' => 'Ñamümüngelu pünon',
	'difference' => '(Trürümün epu malün engu)',
	'diff-multi' => '(Pengelngelay {{PLURAL:$1 trürümün epu malün engu}} ta dewmafi {{PLURAL:$2|kiñe kellufe|$2 pu kellufe}})',
	'diff' => 'Kalelu',
	'download' => 'nakvmpafipe',
	'disambiguationspage' => 'Template:Kiñeduamngelu dungu',
	'deletepage' => 'Ñamümün tüfachi pakina',
	'delete-confirm' => 'Ñamümüngelu "$1"',
	'delete-legend' => 'Ñamümün',
	'dellogpage' => 'Liftungepelu wülngiñ ñi wirintukun',
	'deletereasonotherlist' => 'Kake dungu',
	'delete_and_move' => 'Ñamümün ka nengümün',
	'delete_and_move_confirm' => 'May, ñamümün pakina',
	'duplicate-defaultsort' => '\'\'\'Ngüneltun:\'\'\' Wünezullin ñi kümeelgen lonkolelu "$2" nentutuy rupalu wünezullin ñi kümeelgen lonkolelu "$1".',
);

$messages['ary'] = array(
	'december' => 'Dojanbir',
	'december-gen' => 'Dojanbir',
	'dec' => 'Doj',
	'delete' => 'Mḫi',
	'deletethispage' => "Suprimi had 'ṣ-ṣefḫa",
	'disclaimers' => 'Inḍaraṫ',
	'disclaimerpage' => 'Project:Inḍaraṫ ĝammin',
	'databaseerror' => 'khataaa f qaaaidat lbayanat',
	'dberrortext' => 'khata fsight amr qaaaidat lbayanat
hadchi iqdr ikon raja lchi khataa f lbrnamaj
akhir amr dyal qaaidat lbayanat kan
<blockquote><tt>$1</tt></blockquote>
dakhl had dalla "<tt>$2</tt>".
qaaidat lbayant rddat bhad lkhataa "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'wqĝ waḫd lmoċkil f siġt istiĝlam qaĝidat lbayanat

aĥir talab istiĝlam qaĝidat lbayanat kan

"$1"

li hwa mn daĥl ddala "$2".

qaĝidat lbayanat rjĝat lĥata\' "$3: $4"',
	'directorycreateerror' => 'maymknch had lmojllad itnchaa "$1".',
	'deletedhist' => 'tarikh lmhdof',
	'difference' => '(Ferq mabin lé-vérsyon)',
	'difference-multipage' => '(l-fṛq bin ṣ-ṣfaḫi)',
	'diff-multi' => '({{PLURAL:$1|ṃoṛajaĝa waṣita wḫda|$1 dl-ṃoṛajaĝaṫ l-waṣita}} ṫaĝṫ {{PLURAL:$2|mosṫĥdim waḫf|$2 dl-mosṫĥdimin}} ma mbeyyna-ċ)',
	'diff-multi-manyusers' => '({{PLURAL:$1|ṃoṛajaĝa waṣita wḫda|$1 dl-ṃoṛajaĝaṫ l-waṣita}} ṫaĝṫ kṫr mn $2 {{PLURAL:$2|l-mosṫĥdim|dl-mosṫĥdimin}} ma mbeyyna-ċ)',
	'datedefault' => 'la tafdil',
	'defaultns' => 'olla qlb f had dominat :',
	'default' => 'iftiradi',
	'diff' => 'ferq',
	'destfilename' => 'lmif lmostadhdaf:',
	'download' => 'telecharji',
	'disambiguations' => 'sfahi dyal tawdih',
	'disambiguationspage' => 'Template:tawdih',
	'doubleredirects' => 'ṫḫwila mḍoḅla',
	'double-redirect-fixed-move' => '[[$1]] ṫnqlaṫ.
daba ka ṫḫwwal l-[[$2]].',
	'double-redirect-fixed-maintenance' => 'iṣlaḫ ṫḫwil mḍobl mon [[$1]] l-[[$2]].',
	'double-redirect-fixer' => 'mosslih tahwil',
	'deadendpages' => 'sfahi andha nihaya msdoda',
	'deletedcontributions' => 'mosahamaṫ mosṫĥdim memḫiya',
	'deletedcontributions-title' => 'mosahamaṫ mosṫĥdim memḫiya',
	'defemailsubject' => 'Imayl dyal {{SITENAME}}',
	'deletepage' => "Mḫi had 'ṣ-ṣefḫa",
	'delete-confirm' => 'suprimi "$1"',
	'delete-legend' => 'Suprimi',
	'deletedtext' => '« $1 » ṫemḫa.
Ċof $2 ila bġiṫi ċi lista dyal kolċi li ṫemḫa aĥiran.',
	'dellogpage' => 'Ṫ-Ṫariĥ dyal ṣ-ṣefḫaṫ li ṫṫemḫaw',
	'dellogpagetext' => 'Ha hiya l-lista dyal dakċi li ĝad ṫṫemḫa.',
	'deletionlog' => 'Ṫ-Ṫariĥ dyal ṣ-ṣefḫaṫ li ṫṫemḫaw',
	'deletecomment' => 'S-Sbab:',
	'deleteotherreason' => 'Sabab weḫdaĥor/zayed:',
	'deletereasonotherlist' => 'Sabab weḫdaĥor',
	'delete-edit-reasonlist' => 'ĝddel asbab l-ḫdf',
	'databasenotlocked' => 'L-Bazdødoné raha ma meġloqaċ.',
	'delete_and_move' => 'Mḫi o neqqel',
	'delete_and_move_confirm' => 'Ah, mḫi ṣ-ṣefḫa',
	'djvu_no_xml' => 'ma ymkn-ċ ṫafḫḫoṣ XML l-milffaṫ DjVu',
	'deletedwhileediting' => "'''attansyo''': had sfha tmshat bad ma bditi taadil dyalha",
	'descending_abbrev' => 'tanazoli',
	'duplicate-defaultsort' => '\'\'\'ṫḫdir:\'\'\' saroṫ ṫrṫib fṫiṛaḍi "$2" faṫ saroṫ ṫrṫib fṫiṛaḍi "$1".',
	'dberr-header' => 'had lwiki fih chi mochkil',
	'dberr-problems' => 'smh lina had lmawqia ando chi machakil tiqniya',
	'dberr-again' => 'jrb tssna 5 dqayq oaawd thmil',
	'dberr-info' => 'mayqdrch ittasl b qaaidat lbayanat : $1',
	'dberr-usegoogle' => 'imkn lik tqllb f Google f lwaqt lhadir',
	'dberr-outofdate' => 'khssk tlahd anna lfahadriss dyalhom l lmohtawa dyalna iqdr matkonch met a jour',
	'dberr-cachederror' => 'hadchi rah ghir nskha msjla, o iqdr matkonch a jour',
);

$messages['arz'] = array(
	'december' => 'ديسمبر',
	'december-gen' => 'ديسمبر',
	'dec' => 'ديسمبر',
	'delete' => 'مسح',
	'deletethispage' => 'امسح الصفحه دى',
	'disclaimers' => 'تنازل عن مسئوليه',
	'disclaimerpage' => 'Project:تنازل عن مسئوليه عمومى',
	'databaseerror' => 'غلط فى قاعدة البيانات (database)',
	'dberrortext' => 'حصل غلط فى صيغة الاستعلام فى قاعدة البيانات (database).
ممكن يكون بسبب عيب فى البرنامج.
آخر محاوله استعلام اتطلبت من قاعدة البيانات كانت:
<blockquote><tt>$1</tt></blockquote>
من جوه الخاصيه "<tt>$2</tt>".
قاعدة البيانات رجعت الغلط "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'حصل غلط فى صيغة الاستعلام فى قاعدة البيانات (database).
آخر محاوله استعلام اتطلبت من قاعدة البيانات كانت:
"$1"
من جوه الخاصيه "$2".
قاعدة البيانات رجعت الغلط "$3: $4"',
	'directorycreateerror' => 'ما نفع ش يتعمل الدليل "$1".',
	'deletedhist' => 'التاريخ الممسوح',
	'difference' => '(الفرق بين النسخ)',
	'diff-multi' => '({{PLURAL:$1|نسخه واحده متوسطه|$1 نسخ متوسطه}} by {{PLURAL:$2|يوزر واحد |$2 يوزرات}}  مش معروضه)',
	'datedefault' => 'مافبش تفضيل',
	'defaultns' => 'أو دور فى النطاقات دى:',
	'default' => 'اوتوماتيكي',
	'diff' => 'التغيير',
	'destfilename' => 'اسم الملف المستهدف:',
	'duplicatesoffile' => '{{PLURAL:$1| الملف|ال$1 ملف اللى بعده}} متكررين من الملف ده:
([[Special:FileDuplicateSearch/$2| تفاصيل اكتر]]):',
	'download' => 'تنزيل',
	'disambiguations' => 'صفحات التوضيح',
	'disambiguationspage' => 'Template:توضيح',
	'disambiguations-text' => "الصفحات دى بتوصل لـ '''صفحة توضيح'''.
المفروض على العكس انهم يوصلو ل للصفحات المناسبة. <br />
أى صفحة بتتعامل على انها صفحة توضيح إذا كانت بتستعمل قالب موجود فى [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'تحويلات مزدوجه',
	'doubleredirectstext' => 'الصفحة دى فيها لستة الصفحات اللى فيها تحويلة لصفحة تانية فيها تحويلة.
كل سطر فى اللستة دى  فيه لينك للتحويلة الأولانية والتانية و كمان للصفحة بتاعة التحويلة التانية و اللى غالبا هى الصفحة الاصلية اللى المفروض التحويلة الاولانية توصل ليها.
<del>Crossed out</del> اتحلت.',
	'double-redirect-fixed-move' => '[[$1]] اتنقلت، هى دلوقتى تحويله ل [[$2]]',
	'double-redirect-fixer' => 'مصلح التحويل',
	'deadendpages' => 'صفحات ما بتوصلش  لحاجه',
	'deadendpagestext' => 'الصفحات دى مابتوصلش  لصفحات تانية فى {{SITENAME}}.',
	'deletedcontributions' => 'تعديلات اليوزر الممسوحة',
	'deletedcontributions-title' => 'تعديلات اليوزر الممسوحة',
	'defemailsubject' => 'إيميل من {{SITENAME}}',
	'deletepage' => 'امسح الصفحه',
	'delete-confirm' => 'مسح"$1"',
	'delete-legend' => 'مسح',
	'deletedtext' => '"$1" اتمسحت.
بص على $2 علشان تشوف سجل آخر عمليات المسح.',
	'dellogpage' => 'سجل المسح',
	'dellogpagetext' => 'لسته بأحدث عمليات المسح.',
	'deletionlog' => 'سجل المسح',
	'deletecomment' => 'السبب:',
	'deleteotherreason' => 'سبب تانى/اضافي:',
	'deletereasonotherlist' => 'سبب تانى',
	'deletereason-dropdown' => '*أسباب المسح المشهوره
** طلب المؤلف
** مخالفة قواعد حقوق النشر
** التخريب',
	'delete-edit-reasonlist' => 'عدل اسباب المسح',
	'delete-toobig' => 'الصفحه دى  ليها تاريخ تعديل كبير، أكتر من $1 {{PLURAL:$1|مراجعة|مراجعة}}.
مسح الصفحات اللى زى دى تم تحديده لمنع الاضطراب العرضى فى {{SITENAME}}.',
	'delete-warning-toobig' => 'الصفحة دى ليها تاريخ تعديل كبير، أكتر من $1 {{PLURAL:$1|مراجعة|مراجعة}}.
ممكن مسحها يعمل اضطراب  فى عمليات قاعدة البيانات فى {{SITENAME}}؛
استمر بس خد بالك.',
	'databasenotlocked' => 'قاعدة البيانات بتاعتك مش  مقفولة.',
	'delete_and_move' => 'مسح ونقل',
	'delete_and_move_text' => '==المسح مطلوب==
الصفحة الهدف "[[:$1]]" موجودة فعلا.
انت عايز تمسحها علشان تقدر تنقلها؟',
	'delete_and_move_confirm' => 'ايوة، امسح الصفحة',
	'delete_and_move_reason' => 'اتمسحت علشان تسمح للنقل',
	'djvu_page_error' => 'صفحة DjVu بره النطاق',
	'djvu_no_xml' => 'مش ممكن تجيب XML لملف DjVu',
	'deletedrevision' => 'مسح النسخة القديمة $1',
	'deletedwhileediting' => "'''تحذير''':  الصفحة دى اتمسحت بعد ما بدأت أنت  فى تحريرها!",
	'descending_abbrev' => 'نازل',
	'duplicate-defaultsort' => 'تحزير: زرار الترتيب الاوتوماتيكي"$2" بيوقف زرار الترتيب الاوتوماتيكي"$1" القديم.',
	'dberr-header' => 'الويكى دا فيه مشكله',
	'dberr-problems' => 'متأسفين، السايت دا بيعانى من صعوبات فنيه',
	'dberr-again' => 'حاول تستنا كام دقيقه و بعدين اعمل تحميل من تانى',
	'dberr-info' => '(مش قادرين نتصل بـ السيرفر بتاع قاعدة البيانات: $1)',
	'dberr-usegoogle' => 'ممكن تحاول تدور باستعمال جوجل دلوقتى.',
	'dberr-outofdate' => 'خد بالك فهارس المحتوى بتاعنا اللى عندهم ممكن تكون مش متحدثه.',
	'dberr-cachederror' => 'دى نسخه متخزنه من الصفحه المطلوبه، و ممكن ما تكونش متحدثه.',
);

$messages['as'] = array(
	'december' => 'ডিচেম্বৰ',
	'december-gen' => 'ডিচেম্বৰ',
	'dec' => 'ডিচে:',
	'delete' => 'বিলোপন (ডিলিট)',
	'deletethispage' => 'বৰ্তমান পৃষ্ঠাৰ বিলোপন (ডিলিট)',
	'disclaimers' => 'ঘোষণা',
	'disclaimerpage' => 'Project:সাধাৰণ দায়লুপ্তি',
	'databaseerror' => 'তথ্যকোষৰ ভুল',
	'dberrortext' => 'Database query-ত ভুল আছে।
ছফ্টৱেৰত থকা কোনো বাগৰ বাবে এনে হব পাৰে।
অন্তিমবাৰ চেষ্টা কৰা ডাটাবেচ কুৱেৰীটো আছিল এনেধৰণৰ:
<blockquote><tt>$1</tt></blockquote>
"<tt>$2</tt>" ফাংচনৰ পৰা
ডাটাবেচে প্ৰেৰণ কৰা ত্ৰুটি: "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'এক ডাটাবেচ চিণ্টেক্স ত্ৰুটি ঘটিছে।
অন্তিমবাৰ চেষ্টা কৰা ডাটাবেচ কুৱেৰীটো আছিল এনেধৰণৰ:
"$1"
"$2" ফাংচনৰ পৰা
ডাটাবেচে প্ৰেৰণ কৰা ত্ৰুটি "$3: $4"',
	'directorycreateerror' => '"$1" ডাইৰেক্টৰি সৃষ্টি কৰিব পৰা নগ’ল।',
	'deletedhist' => 'মচি পেলোৱা ইতিহাস',
	'difference' => 'বিভিন্ন সংস্কৰণৰ প্ৰভেদ',
	'difference-multipage' => '(পৃষ্ঠাসমূহৰ মাজত তফাৎ)',
	'diff-multi' => '({{PLURAL:$2|এজন সদস্যৰ|$2জন সদস্যৰ}} দ্বাৰা {{PLURAL:$1|এটা মধ্যৱৰ্তী সংশোধন|$1-টা মধ্যৱৰ্তী সংশোধন}} দেখোৱা হোৱা নাই)',
	'diff-multi-manyusers' => '({{PLURAL:$2|এজনতকৈ|$2-জনতকৈ}} অধিক সদস্যৰ দ্বাৰা {{PLURAL:$1|এটা মধ্যৱৰ্তী সংশোধন|$1-টা মধ্যৱৰ্তী সংশোধন}} দেখোৱা হোৱা নাই)',
	'datedefault' => 'কোনো পছন্দ নাই',
	'defaultns' => 'অন্যথা এই নামস্থান সমূহত অনুসন্ধান কৰিব:',
	'default' => 'অবিচল',
	'diff' => 'পাৰ্থক্য',
	'destfilename' => 'লক্ষ্য ফাইলৰ নাম:',
	'duplicatesoffile' => 'এই ফাইলটোৰ {{PLURAL:$1|ফাইলটো প্ৰতিলিপি|$1 ফাইলসমূহ প্ৰতিলিপি}}
([[Special:FileDuplicateSearch/$2|অধিক তথ্য]]):',
	'download' => 'ডাউনল’ড কৰক',
	'disambiguations' => 'দ্ব্যৰ্থতা-দূৰীকৰণ পৃষ্ঠাসমূহলৈ সংযোগ থকা পৃষ্ঠাসমূহ',
	'disambiguationspage' => 'Template:দ্ব্যৰ্থতা-দূৰীকৰণ',
	'disambiguations-text' => "তলৰ পৃষ্ঠাখনসমূহত '''দ্ব্যৰ্থতা দূৰীকৰণ পৃষ্ঠা'''ৰ লগত সংযোগ আছে ।
ইয়ে উপযুক্ত পৃষ্ঠাৰ লগত সংযোগ কৰিব পাৰে ।
[[MediaWiki:Disambiguationspage]]ৰ পৰা সংযোগ থকা কোনো সাঁচ ব্যৱহাৰ কৰিলে এখন পৃষ্ঠাক দ্ব্যৰ্থতা দূৰীকৰণ পৃষ্ঠা হিছাপে গণ্য কৰা হ’ব ।",
	'doubleredirects' => 'দ্বি-পুনঃনিৰ্দেশিত',
	'doubleredirectstext' => 'আন পুনৰ্নিদেশনা পৃষ্ঠালৈ পুনৰ্নিৰ্দেশিত পৃষ্ঠাসমূহ এই তালিকাত দিয়া হৈছে ।
প্ৰত্যেক পথালী শাৰীত প্ৰথম আৰু দ্বিতীয় পুনৰ্নিৰ্দেশনাৰ সংযোগৰ লগতে দ্বিতীয় পুনৰ্নিৰ্দেশনাৰ লক্ষ্য সংযোগ দিয়া আছে । এই লক্ষ্য সংযোগটো সাধাৰণতে "প্ৰকৃত" লক্ষ্য পৃষ্ঠা যাক প্ৰথম পুনৰ্নিৰ্দেশনাই আঙুলিয়াই দিয়ে ।
<del>Crossed out</del> ভৰ্তিসমূহ ঠিক কৰা হৈছে ।',
	'double-redirect-fixed-move' => '[[$1]] ক স্থানান্তৰ কৰা হৈছে ।
এইটো এতিয়া [[$2]]লৈ পুনৰ্নিৰ্দেশিত হৈছে ।',
	'double-redirect-fixed-maintenance' => '[[$1]] ৰ পৰা [[$2]] লৈ দ্বৈত পুনৰ্নিৰ্দেশনা ঠিক কৰি থকা হৈছে ।',
	'double-redirect-fixer' => 'পুনঃনিৰ্দেশ মেৰামতকাৰী',
	'deadendpages' => 'ডেড এণ্ড পৃষ্ঠাসমূহ',
	'deadendpagestext' => 'তলৰ পৃষ্ঠাসমূহৰ {{SITENAME}}ৰ কোনো পৃষ্ঠাৰ লগত সংযোগ নাই ।',
	'deletedcontributions' => 'ৰদ কৰা সদস্যৰ বৰঙণিসমূহ',
	'deletedcontributions-title' => 'ৰদ কৰা সদস্যৰ বৰঙণিসমূহ',
	'defemailsubject' => '"$1" সদস্যৰ পৰা {{SITENAME}} ই-মেইল',
	'deletepage' => 'পৃষ্ঠা বিলোপ কৰক',
	'delete-confirm' => '"$1" বিলোপ কৰক',
	'delete-legend' => 'বিলোপ কৰক',
	'deletedtext' => '"$1" ক বিলোপন কৰা হৈছে।
সাম্প্ৰতিক বিলোপনসমূহৰ তালিকা চাবলৈ $2 চাওক।',
	'dellogpage' => 'বাতিল কৰা সূচী',
	'dellogpagetext' => "তলত সাম্প্ৰতিক বিলোপনৰ তালিকা দিয়া হ'ল ।",
	'deletionlog' => 'বাতিল কৰা সূচী',
	'deletecomment' => 'কাৰণ:',
	'deleteotherreason' => 'আন/অতিৰিক্ত কাৰণ:',
	'deletereasonotherlist' => 'আন কাৰণ:',
	'deletereason-dropdown' => '* অৱলুপ্তিৰ সাধাৰণ কাৰণসমূহ
** লেখকৰ অনুৰোধ
** কপিৰাইট উলঙ্ঘন
** অসভ্যালি',
	'delete-edit-reasonlist' => 'অপসাৰণ কৰা কাৰণ সম্পাদনা কৰক',
	'delete-toobig' => 'এই পৃষ্ঠাখনৰ সম্পাদনা ইতিহাস অতি দীঘল, $1 {{PLURAL:$1|টা সংশোধনৰো|টা সংশোধনৰো}} বেছি ।
{{SITENAME}}ৰ আকস্মিক ক্ষতি ৰোধ কৰিবলৈ এনে পৃষ্ঠাৰ ইতিহাস বিলোপ কৰাত সীমাবদ্ধতা আৰোপ কৰা হৈছে ।',
	'delete-warning-toobig' => 'এই পৃষ্ঠাখনৰ সম্পাদনা ইতিহাস অতি দীঘল, $1 {{PLURAL:$1|টা সংশোধনৰো|টা সংশোধনৰো}} বেছি ।
ইয়াক বিলোপ কৰিলে {{SITENAME}} ৰ তথ্যভঁৰালৰ কাৰ্য্যকাৰীতাত সমস্যা হ’ব পাৰে;
সাৱধানেৰে আগ বাঢ়ক ।',
	'databasenotlocked' => 'তথ্যকোষ বন্ধ নহয় ।',
	'delete_and_move' => 'বিলোপ আৰু স্থানান্তৰ কৰক',
	'delete_and_move_text' => '== বিলোপন আৱশ্যক ==
লক্ষ্য পৃষ্ঠা "[[:$1]]" ইতিমেধ্যে আছেই ।
আপুনি স্থানান্তৰ কৰিবলৈ এইখন বিলোপ কৰিব খুজিছে নেকি ?',
	'delete_and_move_confirm' => 'হয়, পৃষ্ঠাখন বিলোপ কৰক',
	'delete_and_move_reason' => '"[[$1]]"ৰ পৰা স্থানান্তৰৰ স্বাৰ্থত বিলোপ কৰা হৈছে',
	'djvu_page_error' => 'DjVu পৃষ্ঠা পৰিসীমাৰ বাহিৰত',
	'djvu_no_xml' => "DjVu ফাইলৰ বাবে XML আনিব পৰা নগ'ল",
	'deletedrevision' => 'পুৰণি সংশোধনী $1 বিলোপ কৰা হ’ল',
	'days' => '{{PLURAL:$1|$1 দিন|$1 দিন}}',
	'deletedwhileediting' => "'''সতৰ্কবাণী''': আপুনি সম্পাদনা আৰম্ভ কৰাৰ পিছত পৃষ্ঠাখন বিলোপ কৰা হৈছে !",
	'descending_abbrev' => 'অৱতৰণ',
	'duplicate-defaultsort' => '\'\'\'সাৱধান!\'\'\' পূৰ্বনিৰ্ধাৰিত ক্ৰমসূচক "$2"-এ আগৰ ক্ৰমসূচক "$1"-অক বিস্থাপিত কৰিছে।',
	'dberr-header' => 'এই ৱিকিত এটা সমস্যা হৈছে',
	'dberr-problems' => 'দুঃখিত!
চাইটটোত কিছু কাৰিকৰী সমস্যা হৈছে ।',
	'dberr-again' => "অলপ সময় অপেক্ষা কৰি পুনৰ আপল'ডৰ চেষ্টা কৰক ।",
	'dberr-info' => '(তথ্যকোষৰ চাৰ্ভাৰৰ লগত যোগাযোগ কৰিব নোৱাৰি: $1)',
	'dberr-usegoogle' => 'এই পৰিস্থিতিত আপুনি গুগলৰ মাধ্যমেৰে অনুসন্ধান কৰিব পাৰে ।',
	'dberr-outofdate' => "মন কৰক যে, আমাৰ বিষয়বস্তু সম্পৰ্কে তেওঁলোকৰ সূচী পুৰণা হ'ব পাৰে ।",
	'dberr-cachederror' => "এইখন অনুৰোধ কৰা পৃষ্ঠাৰ কেশ্ব্‌ড কপী, নবীকৰণ নকৰা হ'ব পাৰে ।",
);

$messages['ast'] = array(
	'december' => 'avientu',
	'december-gen' => "d'avientu",
	'dec' => 'avi',
	'delete' => 'Desaniciar',
	'deletethispage' => 'Desaniciar esta páxina',
	'disclaimers' => 'Avisu llegal',
	'disclaimerpage' => 'Project:Alvertencia xeneral',
	'databaseerror' => 'Error na base de datos',
	'dberrortext' => 'Hebo un fallu de sintaxis nuna consulta de la base de datos.
Esti fallu puede ser por un problema del software.
La postrer consulta que s\'intentó foi:
<blockquote><tt>$1</tt></blockquote>
dende la función "<tt>$2</tt>".
La base datos dió el fallu "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Hebo un fallu de sintaxis nuna consulta a la base de datos.
La postrer consulta que s\'intentó foi:
"$1"
dende la función "$2".
La base de datos dió\'l fallu "$3: $4"',
	'directorycreateerror' => 'Nun se pudo crear el direutoriu "$1".',
	'deletedhist' => 'Historial elimináu',
	'difference' => '(Diferencia ente revisiones)',
	'difference-multipage' => '(Diferencia ente páxines)',
	'diff-multi' => "({{PLURAL:$1|Nun s'amuesa 1 revisión intermedia|Nun s'amuesen $1 revisiones intermedies}} {{PLURAL:$2|d'un usuariu|de $2 usuarios}} )",
	'diff-multi-manyusers' => "({{PLURAL:$1|Nun s'amuesa una revisión intermedia|Nun s'amuesen $1 revisiones intermedies}} de más de $2 {{PLURAL:$2|usuariu|usuarios}})",
	'datedefault' => 'Ensin preferencia',
	'defaultns' => "D'otra miente, guetar nestos espacios de nome:",
	'default' => 'predetermináu',
	'diff' => 'dif',
	'destfilename' => 'Nome de destín:',
	'duplicatesoffile' => "{{PLURAL:$1|El siguiente archivu ye un duplicáu|Los siguientes $1 archivos son duplicaos}} d'esti archivu ([[Special:FileDuplicateSearch/$2|más detalles]]):",
	'download' => 'descargar',
	'disambiguations' => "Páxines qu'enllacen con páxines de dixebra",
	'disambiguationspage' => 'Template:dixebra',
	'disambiguations-text' => "Les siguientes páxines enllacien a una '''páxina de dixebra'''. En cuenta d'ello habríen enllaciar al artículu apropiáu.<br />Una páxina considérase de dixebra si usa una plantía que tea enllaciada dende [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Redireiciones dobles',
	'doubleredirectstext' => 'Esta páxina llista páxines que redireicionen a otres páxines de redireición.
Cada filera contién enllaces a la primer y segunda redireición, asina como al oxetivu de la segunda redireición, que de vezu ye la páxina oxetivu "real", onde tendría d\'empobinar la primer redireición.
Les entraes <del>tachaes</del> tan resueltes.',
	'double-redirect-fixed-move' => '[[$1]] foi treslladáu, agora ye una redireición haza [[$2]]',
	'double-redirect-fixed-maintenance' => 'Iguando la doble redireición de [[$1]] a [[$2]].',
	'double-redirect-fixer' => 'Iguador de redireiciones',
	'deadendpages' => 'Páxines ensin salida',
	'deadendpagestext' => 'Les páxines siguientes nun enllacien a páxina dala de {{SITENAME}}.',
	'deletedcontributions' => "Contribuciones d'usuariu esborraes",
	'deletedcontributions-title' => "Contribuciones d'usuariu desaniciaes",
	'defemailsubject' => 'Corréu electrónicu del usuariu «$1» de {{SITENAME}}',
	'deletepage' => 'Esborrar páxina',
	'delete-confirm' => 'Desaniciar «$1»',
	'delete-legend' => 'Desaniciar',
	'deletedtext' => 'Esborróse "$1".
Mira en $2 la llista de les últimes páxines esborraes.',
	'dellogpage' => 'Rexistru de desanicios',
	'dellogpagetext' => 'Abaxo amuésase una llista de los artículos esborraos más recién.',
	'deletionlog' => 'rexistru de desanicios',
	'deletecomment' => 'Motivu:',
	'deleteotherreason' => 'Motivu distintu/adicional:',
	'deletereasonotherlist' => 'Otru motivu',
	'deletereason-dropdown' => "*Motivos comunes d'esborráu
** A pidimientu del autor
** Violación de Copyright
** Vandalismu",
	'delete-edit-reasonlist' => "Editar los motivos d'esborráu",
	'delete-toobig' => "Esta páxina tien un historial d'ediciones grande, más de $1 {{PLURAL:$1|revisión|revisiones}}.
Restrinxóse l'esborráu d'estes páxines pa evitar perturbaciones accidentales de {{SITENAME}}.",
	'delete-warning-toobig' => "Esta páxina tien un historial d'ediciones grande, más de $1 {{PLURAL:$1|revisión|revisiones}}.
Esborralu pue perturbar les operaciones de la base de datos de {{SITENAME}};
obra con precaución.",
	'databasenotlocked' => 'La base de datos nun ta candada.',
	'delete_and_move' => 'Esborrar y treslladar',
	'delete_and_move_text' => '==Necesítase esborrar==

La páxina de destín "[[:$1]]" yá esiste. ¿Quies esborrala pa dexar sitiu pal treslláu?',
	'delete_and_move_confirm' => 'Sí, esborrar la páxina',
	'delete_and_move_reason' => 'Desaniciada pa facer sitiu pa treslladar dende «[[$1]]»',
	'djvu_page_error' => 'Páxina DjVu fuera de llímites',
	'djvu_no_xml' => 'Nun se pudo obtener el XML pal archivu DjVu',
	'deletedrevision' => 'Esborrada la reversión vieya $1',
	'days' => '{{PLURAL:$1|$1 día|$1 díes}}',
	'deletedwhileediting' => "'''Avisu''': ¡Esta páxina foi esborrada depués de qu'entamaras a editala!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => 'Avisu: La clave d\'ordenación predeterminada "$2" anula la clave d\'ordenación anterior "$1".',
	'dberr-header' => 'Esta wiki tien un problema',
	'dberr-problems' => '¡Sentímoslo! Esti sitiu ta esperimentando dificultaes téuniques.',
	'dberr-again' => 'Tenta esperar dellos minutos y recargar.',
	'dberr-info' => '(Nun se pue contautar cola base de datos del sirvidor: $1)',
	'dberr-usegoogle' => 'Pues probar a guetar con Google mentanto.',
	'dberr-outofdate' => 'Atalanta que los sos índices del nuesu conteníu seique nun tean actualizaos.',
	'dberr-cachederror' => 'Esta ye una copia na caché de la páxina que se pidiera, y pue que nun tea actualizada.',
);

$messages['av'] = array(
	'diff' => 'батӀалъи',
);

$messages['avk'] = array(
	'december' => 'santoleaksat',
	'december-gen' => 'Santoleaksat',
	'dec' => '12-at',
	'delete' => 'Sulara',
	'deletethispage' => 'Busulara',
	'disclaimers' => 'Walzera se',
	'disclaimerpage' => 'Project:Jadifa walzera se',
	'databaseerror' => 'Origakrokla',
	'dberrortext' => 'Vurarokla pu origak. Ironokafa kucilara suleyena gan origak tiyir :
<blockquote><tt>$1</tt></blockquote>
mal fliok « <tt>$2</tt> ».
MySQL va « <tt>$3: $4</tt> » rokla al katacer.',
	'dberrortextcl' => 'Bibera va origak tir roklakirafa. Ironokafa stakseyena bibera tiyir:
« $1 »
skuyuna gan « $2 » fliok
MySQL va « $3 : $4 » rokla al dimstakser.',
	'directorycreateerror' => 'Redura va "$1" bonja me tir.',
	'deletedhist' => 'Sularizvot',
	'difference' => '(Siatosamidaceem)',
	'diff-multi' => '({{PLURAL:$1|1 walif betaks me zo nedir|$1 walif betaks me zo nedid}}.)',
	'datedefault' => 'Megelukon',
	'defaultns' => 'Omavon, aneyara ko bato yoltxo se :',
	'default' => 'omava',
	'diff' => 'amid-',
	'destfilename' => 'Warzaf iyeltakyolt:',
	'duplicatesoffile' => 'Bat {{PLURAL:$1|iyeltak tir|$1 iyeltak tid}} jontolaca ke bat iyeltak ([[Special:FileDuplicateSearch/$2|lo pinta]]) :',
	'download' => 'kalvajara',
	'disambiguations' => 'Bu dem milyoltaca yo',
	'disambiguationspage' => '{{ns:template}}:Milyoltaca',
	'doubleredirects' => 'Jontolafa graskara',
	'doubleredirectstext' => "<b>Attention:</b> cette liste peut contenir des « faux positifs ». Dans ce cas, c'est probablement la page du premier #REDIRECT contient aussi du texte.<br />Chaque ligne contient les liens à la 1re et 2e page de redirection, ainsi que la première ligne de cette dernière, qui donne normalement la « vraie » destination. Le premier #REDIRECT devrait lier vers cette destination.",
	'double-redirect-fixed-move' => 'arrundayan [[$1]], dure graskan kal [[$2]]',
	'deadendpages' => 'Axodabueem',
	'deadendpagestext' => 'Batu bu se tid gluyasikiiskafu gu aru bu koe {{SITENAME}}.',
	'deletedcontributions' => 'Sulayan favesikaf webeks',
	'defemailsubject' => 'internettwa staksayana mal {{SITENAME}}',
	'deletepage' => 'Busulara',
	'delete-confirm' => 'Sulara va "$1"',
	'delete-legend' => 'Sulara',
	'deletedtext' => '« <nowiki>$1</nowiki> » tir sulayan.
Ta vexala dem noeltaf sulareem va $2 disukel.',
	'deletedarticle' => 'al sular va « [[$1]] »',
	'dellogpage' => 'Izvot va sulareem',
	'dellogpagetext' => 'Tir tela vexala dem noeltaf sulareem.
Bazen bartiv tir tel ke zanisiko.',
	'deletionlog' => 'izvot va sulareem',
	'deletecomment' => 'Lazava :',
	'deleteotherreason' => 'Ara ik loplekufa lazava :',
	'deletereasonotherlist' => 'Ara lazava',
	'deletereason-dropdown' => '*Giltafa sularalazava
** Erura ke sutesik
** Aksara va sutesikroka
** Apkara',
	'delete-edit-reasonlist' => 'Betara va sularalazava',
	'delete-toobig' => 'Batu bu va izvotap (lo $1 {{PLURAL:$1|betara|betara}}) digir. Ta djira va waltafa empara va {{SITENAME}} sulara va manu bu zo irutar.',
	'delete-warning-toobig' => 'Batu bu va izvotap (lo $1 {{PLURAL:$1|betara|betara}}) digir. Sulara va manu bu va skura ke origak ke {{SITENAME}} rotempar, acum obrason diotel !',
	'databasenotlocked' => 'Origak me zo ixatcar.',
	'delete_and_move' => 'Sulara is arplekura',
	'delete_and_move_text' => '==Sulara eruna==
"[[:$1]]" kalefu bu ixam krulder.
Kas ta askira va darka ta arrundara va in djusulal ?',
	'delete_and_move_confirm' => 'En, va bu sulal !',
	'delete_and_move_reason' => 'Sulayan ta dark ta arrundara',
	'djvu_page_error' => 'DjVu bu dive kima',
	'djvu_no_xml' => 'XML Vexalara va DjVu iyeltak tir merotisa',
	'deletedrevision' => '$1 sulayan guazaf betaks',
	'deletedwhileediting' => "'''Obral''' : Batu bu zo sulayar vielu toz betayal !",
	'descending_abbrev' => 'tit-',
);

$messages['ay'] = array(
	'december' => 'jallu qallta phaxsi',
	'december-gen' => 'jallu qallta phaxsi',
	'dec' => 'jall',
	'delete' => 'Pichaña',
	'deletethispage' => 'Aka uñstawi phiskhuraña',
);

$messages['az'] = array(
	'december' => 'dekabr',
	'december-gen' => 'dekabr',
	'dec' => 'Dekabr',
	'delete' => 'Sil',
	'deletethispage' => 'Bu səhifəni sil',
	'disclaimers' => 'Məsuliyyətdən imtina',
	'disclaimerpage' => 'Project:Məsuliyyətdən imtina',
	'databaseerror' => 'Verilənlər bazası xətası',
	'dberrortext' => 'Verilənlər bazası sorğusunda sintaksis xətası yarandı.
Bu proqram təminatındakı xəta ilə əlaqədar ola bilər.
Verilənlər bazasına sonuncu sorğu "<tt>$2</tt>" funksiyasından
yaranan <blockquote><tt>$1</tt></blockquote>.
Verilənlər bazasının göstərdiyi xəta "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Verilənlər bazası sorğusunda sintaksis xətası yarandı.
Verilənlər bazasına sonuncu sorğu:
"$1"
"$2" funksiyasından yaranmışdır.
Verilənlər bazasının göstərdiyi xəta "$3: $4"',
	'directorycreateerror' => '"$1" direktoriyasını yaratmaq mümkün deyil',
	'deletedhist' => 'Silmə qeydləri',
	'difference' => '(Versiyalar arasındakı fərq)',
	'difference-multipage' => '(Səhifələr arasında fərq)',
	'diff-multi' => '({{PLURAL:$2|Bir istifadəçi|$2 istifadəçi}} tərəfindən edilən {{PLURAL:$1|bir ara redaktə|$1 ara redaktə}} göstərilmir)',
	'diff-multi-manyusers' => '({{PLURAL:$2|Bir istifadəçi|$2 istifadəçi}} tərəfindən edilən {{PLURAL:$1|bir ara redaktə|$1 ara redaktə}} göstərilmir)',
	'datedefault' => 'Seçim yoxdur',
	'defaultns' => 'Yaxud bu adlar fəzasında axtar:',
	'default' => 'boş',
	'diff' => 'fərq',
	'destfilename' => 'Fayl adı',
	'download' => 'Yüklə',
	'disambiguations' => 'Dəqiqləşdirmə səhifələrinə keçid verən səhifələr',
	'disambiguationspage' => 'Template:dəqiqləşdirmə',
	'disambiguations-text' => "Aşağıdakı səhifələr '''dəqiqləşdirmə səhifələrinə''' keçid verir. Bunun əvəzinə onlar çox guman ki, müvafiq konkret bir məqaləni göstərməlidirlər.
<br />Səhifə o zaman dəqiqləşdirmə səhifəsi hesab edilir ki, onda  [[MediaWiki:Disambiguationspage]]-dən keçid verilmiş şablon istifadə edilir.",
	'doubleredirects' => 'İkiqat istiqamətləndirmələr',
	'double-redirect-fixed-move' => '[[$1]] dəyişdirilib.
Hazırda [[$2]]-yə istiqamətlənib.',
	'double-redirect-fixed-maintenance' => '[[$1]]-dən [[$2]]-yə ikiqat istiqamətlənmə düzəldilir.',
	'double-redirect-fixer' => 'Yönləndirmə səhvdir',
	'deadendpages' => 'Keçid verməyən səhifələr',
	'deadendpagestext' => 'Aşağıdakı səhifələrdən bu Vikipediyadakı digər səhifələrə heç bir keçid yoxdur.',
	'deletedcontributions' => 'Silinmiş istifadəçi fəaliyyətləri',
	'deletedcontributions-title' => 'Silinmiş istifadəçi fəaliyyətləri',
	'defemailsubject' => '"$1" adlı istifadəçidən {{SITENAME}} e-məktubu',
	'deletepage' => 'Səhifəni sil',
	'delete-confirm' => 'Silinən səhifə: "$1"',
	'delete-legend' => 'Sil',
	'deletedtext' => '"$1" silindi.
Sonuncu silinmələrə bax: $2.',
	'dellogpage' => 'Silmə qeydləri',
	'dellogpagetext' => 'Ən son silinmiş səhifələrin siyahısı.',
	'deletionlog' => 'Silmə jurnal qeydləri',
	'deletecomment' => 'Səbəb:',
	'deleteotherreason' => 'Digər/əlavə səbəb:',
	'deletereasonotherlist' => 'Digər səbəb',
	'deletereason-dropdown' => '*Əsas silmə səbəbi
** Müəllif istəyi
** Müəllif hüququ pozuntusu
** Vandalizm',
	'delete-edit-reasonlist' => 'Silmə səbəblərinin redaktəsi',
	'databasenotlocked' => 'Verilənlər bazası bloklanmayıb.',
	'delete_and_move' => 'Sil və apar',
	'delete_and_move_text' => '==Hazırki məqalənin silinməsi lazımdır==

"[[$1]]" məqaləsi mövcuddur. Bu dəyişikliyin yerinə yetirilə bilməsi üçün həmin məqalənin silinməsini istəyirsinizmi?',
	'delete_and_move_confirm' => 'Bəli, səhifəni sil',
	'delete_and_move_reason' => '[[$1]] Ad dəyişməyə yer açmaq üçün silinmişdir',
	'djvu_page_error' => 'DjVu səhifəsi əlçatmazdır',
	'djvu_no_xml' => 'DjVu üçün XML faylı almaq mümkün deyil.',
	'deletedrevision' => 'Köhnə versiyaları silindi $1.',
	'deletedwhileediting' => "'''Diqqət!''' Bu səhifə siz redaktə etməyə başladıqdan sonra silinmişdir!",
	'descending_abbrev' => 'azalma sırasına görə',
	'duplicate-defaultsort' => '\'\'\'Diqqət:\'\'\' Ehtimal edilən "$2" klassifikasiya açarı əvvəlki "$1" klassifikasiya açarını keçərsiz edir.',
	'dberr-header' => 'Bu vikidə problem var',
	'dberr-problems' => 'Üzr istəyirik!
Bu saytda texniki problemlər var.',
	'dberr-info' => '($1: Məlumat bazası ilə əlaqə yoxdur)',
);

$messages['ba'] = array(
	'december' => 'декабрь',
	'december-gen' => 'декабрь',
	'dec' => 'дек',
	'delete' => 'Юҡ  итергә',
	'deletethispage' => 'Был битте юйырға',
	'disclaimers' => 'Яуаплылыҡтан баш тартыу',
	'disclaimerpage' => 'Project:Яуаплылыҡтан баш тартыу',
	'databaseerror' => 'Мәғлүмәттәр базаһы хатаһы',
	'dberrortext' => 'Мәғлүмәттәр базаһына ебәрелгән һорауҙа синтаксис хатаһы табылды.
Был программала хата булыу мөмкинселеген күрһәтә.
Мәғлүмәттәр базаһына ебәрелгән һуңғы һорау:
<blockquote><tt>$1</tt></blockquote>
<tt>«$2»</tt> функцияһынан.
База <tt>«$3: $4»</tt> хатаһын кире ҡайтарҙы.',
	'dberrortextcl' => 'Мәғлүмәттәр базаһына ебәрелгән һорауҙа синтаксис хатаһы табылды.
Мәғлүмәттәр базаһына ебәрелгән һуңғы һорау:
$1
«$2» функцияһынан килә.
База «$3: $4» хатаһын кире ҡайтарҙы.',
	'directorycreateerror' => '«$1» директорияһын яһап булмай.',
	'deletedhist' => 'Юйылған тарих',
	'difference' => '(Өлгөләр араһында айырма)',
	'difference-multipage' => '(Биттәр араһындағы айырма)',
	'diff-multi' => '({{PLURAL:$2|$2 ҡатнашыусының}} {{PLURAL:$1|ваҡытлы версияһы}} күрһәтелмәгән)',
	'diff-multi-manyusers' => '(Кәмендә {{PLURAL:$2|$2 ҡатнашыусының}} {{PLURAL:$1|ваҡытлы версияһы}} күрһәтелмәгән)',
	'datedefault' => 'Ғәҙәттәге',
	'defaultns' => 'Юғиһә киләһе исем арауыҡтарында эҙләргә:',
	'default' => 'ғәҙәттәге',
	'diff' => 'айыр.',
	'destfilename' => 'Файлдың яңы исеме:',
	'duplicatesoffile' => 'Түбәндәге {{PLURAL:$1|файл|файлдар}} был файл менән тап килә ([[Special:FileDuplicateSearch/$2|тулыраҡ мәғлүмәт]])',
	'download' => 'күсереп яҙырға',
	'disambiguations' => 'Күп мәғәнәле төшөнсәләр биттәренә һылтанған биттәр',
	'disambiguationspage' => 'Template:Күп_мәғәнәлелек',
	'disambiguations-text' => "Түбәндәге биттәрҙән '''күп мәғәнәле биттәргә''' һылтанма яһалған.
Бының урынына улар фәҡәт үҙенә кәрәкле мәҡәләгә һылтанырға тейеш.<br />
Әгәр биттә исеме [[MediaWiki:Disambiguationspage]] битендә күрһәтелгән ҡалып ҡулланылһа, ул күп мәғәнәле тип иҫәпләнә.",
	'doubleredirects' => 'Икеле йүнәлтеүҙәр',
	'doubleredirectstext' => 'Был биттә икенсе йүнәлтеү биттәренә йүнәлткән биттәр исемлеге килтерелгән.
Һәр юл беренсе һәм икенсе йүнәлтеүгә һылтанманан, шулай уҡ икенсе һылтанма йүнәлткән һәм беренсе йүнәлтмә һылтанма яһарға тейеш булған биттән  тора.
<del>Һыҙылған</del> яҙыуҙар төҙәтелгән.',
	'double-redirect-fixed-move' => '[[$1]] битенең исеме үҙгәртелгән.
Хәҙер ул [[$2]] битенә йүнәлтелгән.',
	'double-redirect-fixed-maintenance' => 'Икеле йүнәлтеүҙе ([[$1]] - [[$2]]) төҙәтеү.',
	'double-redirect-fixer' => 'Йүнәлтеүҙәрҙе төҙәтеүсе',
	'deadendpages' => 'Көрсөк биттәр',
	'deadendpagestext' => 'Түбәндәге биттәр {{SITENAME}} проектының башҡа биттәренә һылтанма яһамай.',
	'deletedcontributions' => 'Ҡулланыусыларҙың юйылған өлөшө',
	'deletedcontributions-title' => 'Ҡулланыусыларҙың юйылған өлөшө',
	'defemailsubject' => '{{SITENAME}} — $1 ҡулланыусыһынан хат',
	'deletepage' => 'Битте юйырға',
	'delete-confirm' => '$1 — юйырға',
	'delete-legend' => 'Юйырға',
	'deletedtext' => '«$1» юйылды.
Юйылған һуңғы биттәрҙе ҡарар өсөн: $2.',
	'dellogpage' => 'Юйыуҙар журналы',
	'dellogpagetext' => 'Түбәндә һуңғы юйыуҙар яҙмалары журналы килтерелгән.',
	'deletionlog' => 'Юйыуҙар журналы',
	'deletecomment' => 'Сәбәп:',
	'deleteotherreason' => 'Башҡа/өҫтәмә сәбәп:',
	'deletereasonotherlist' => 'Башҡа сәбәп',
	'deletereason-dropdown' => '* Ғәҙәттәге юйыу сәбәптәре
** Автор һорауы буйынса
** Авторлыҡ хоҡуҡтарын боҙоу
** Вандаллыҡ',
	'delete-edit-reasonlist' => 'Сәбәптәр исемлеген мөхәррирләргә',
	'delete-toobig' => 'Был биттең үҙгәртеүҙәр тарихы бик оҙон, $1 {{PLURAL:$1|өлгөнән}} күберәк.
{{SITENAME}} проектының эшмәкәрлеге боҙолмауы маҡсатында бындай биттәрҙе юйыу тыйылған.',
	'delete-warning-toobig' => 'Был биттең үҙгәртеүҙәр тарихы бик оҙон, $1 {{PLURAL:$1|өлгөнән}} күберәк.
Битте юйыу {{SITENAME}} проектының эшмәкәрлеге боҙолоуына килтереүе мөмкин, һаҡлыҡ менән эш итегеҙ.',
	'databasenotlocked' => 'Мәғлүмәттәр базаһы бикләнмәгән.',
	'delete_and_move' => 'Юйырға һәм исемен үҙгәртергә',
	'delete_and_move_text' => '==Юйыу талап ителә==
[[:$1|«$1»]] исемле бит бар инде. Исем үҙгәртеүҙе дауам итеү өсөн, уны юйырға теләйһегеҙме?',
	'delete_and_move_confirm' => 'Эйе, битте юйырға',
	'delete_and_move_reason' => 'Исем үҙгәртеүҙе дауам итеү өсөн юйылды «[[$1]]»',
	'djvu_page_error' => 'DjVu битенең һаны биттәр һанынан ашҡан',
	'djvu_no_xml' => 'DjVu файлы өсөн XML сығарып булмай',
	'deletedrevision' => 'Иҫке $1 өлгөһө юйылды',
	'days' => '{{PLURAL:$1|$1 көн|$1 көн}}',
	'deletedwhileediting' => "'''Иғтибар''': Был бит һеҙ мөхәррирләй башлар алдынан юйылған ине!",
	'descending_abbrev' => 'кәмеүгә табан',
	'duplicate-defaultsort' => '\'\'\'Иҫкәртеү:\'\'\' "$2" ғәҙәттәге тәпртипкә килтереү асҡысы элекке "$1" ғәҙәттәге тәртипкә килтереү асҡысын үҙгәртә.',
	'dberr-header' => 'Был вики проектта ҡыйынлыҡтар бар',
	'dberr-problems' => 'Ғәфү итегеҙ!
Был сайтта техник ҡыйынлыҡтар тыуҙы.',
	'dberr-again' => 'Битте бер нисә минуттан яңыртып ҡарағыҙ.',
	'dberr-info' => '(Мәғлүмәттәр базаһы серверы менән тоташтырылып булмай: $1)',
	'dberr-usegoogle' => 'Әлегә һеҙ Google ярҙамында эҙләп ҡарай алһығыҙ.',
	'dberr-outofdate' => 'Әммә уның индекстары иҫекргән булыуы мөмкинлеген күҙ уңында тотоғоҙ.',
	'dberr-cachederror' => 'Түбәндә һоралған биттең кэшта һаҡланған өлгөһө күрһәтелгән, унда аҙаҡҡы үҙгәртеүҙәр булмауы мөмкин.',
);

$messages['bar'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezember',
	'dec' => 'Dez.',
	'delete' => 'léschen',
	'deletethispage' => 'De Seiten leschen',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Feeler in da Daatenbånk',
	'dberrortext' => "Es is a Daatenbånkfeeler auftreeden!
Da Grund kå a Prógrammierfeeler seih.
D' létzde Daatenbånkobfrog wor:
<blockquote><tt>$1</tt></blockquote>
aus da Funkzión „<tt>$2</tt>“.
Dé Daatenbånk hod an Feeler „<tt>$3: $4</tt>“ gmödt.",
	'dberrortextcl' => "Tschuidigung! Es hod an Syntaxfeeler in da Daatenbånkobfrog geem.
D' letzte Daatenbånkobfrog hod  „$1“ aus da Funkzion „<tt>$2</tt>“ glautt.
De Daatenbånk möidt 'n Feeler: „<tt>$3: $4</tt>“.",
	'directorycreateerror' => 'As Vazeichnis „$1“ hod néd åglégt wern kenner.',
	'deletedhist' => 'Gléschde Versiónen',
	'difference' => '(Unterschiad zwischen dé Versiónen)',
	'diff-multi' => '({{PLURAL:$1|A dazwischenliegerte Versión|$1 dazwischenliegende Versiónen}} vohram {{PLURAL:$2|Benutzer|$2 Benutzern}} {{PLURAL:$1|werd|wern}} néd åzoagt)',
	'diff' => 'Unterschiad',
	'destfilename' => 'Zünaum:',
	'duplicatesoffile' => "{{PLURAL:$1|D'foignde Datei is a Duplikat|De foigndn $1 Datein han Duplikate}} vu dea Datei ([[Special:FileDuplicateSearch/$2|weidare Deteus]]):",
	'download' => 'Owerlooden',
	'disambiguationspage' => 'Template:Begriffsklärung',
	'disambiguations-text' => "D' fóigernden Seiten valinken af a Seiten za ner Begiefsklärung. Du sóiderst stott dém af d' oagerntlich gmoahde Seiten valinken.

A Seiten gijt ois Begriefsklärungsseiten, waunns oane vah dé af [[MediaWiki:Disambiguationspage]] afgfyrde Vurloog(ng) eihbindt.</br>
Links as Naumensraim wern do néd afglistt.",
	'doubleredirects' => 'Doppede Weiderloatungen',
	'deadendpages' => 'Néd valinkende Seiten',
	'deadendpagestext' => 'Dé fóigénden Seiten vaweisen néd auf aundre Seiten voh {{SITENAME}}.',
	'deletedcontributions' => 'Gléschde Beitrég',
	'deletepage' => 'Seiten léschen',
	'delete-confirm' => 'Léschen voh „$1“',
	'delete-legend' => 'Léschen',
	'deletedtext' => '„$1“ is glöscht worn. Im $2 findn Sie a Listn vo de letzten Löschungen.',
	'dellogpage' => 'Lésch-Logbiache',
	'deletionlog' => 'Lösch-Logbuach',
	'deletecomment' => 'Grund:',
	'deleteotherreason' => 'Ånderner/ergänzender Grund:',
	'deletereasonotherlist' => 'Åndrer Grund:',
	'deletereason-dropdown' => '* Oigmoane Léschgrynd
** Wunsch vom Autór
** Urhéwerrechtsvalétzung
** Vandalismus',
	'delete-edit-reasonlist' => 'Léschgrynd beorwaten',
	'databasenotlocked' => 'De Datenbank is net gsperrt.',
	'delete_and_move' => 'Löschn und vaschiam',
	'delete_and_move_reason' => 'glöscht, um Plåtz fia Vaschiam zum macha',
	'deletedrevision' => 'Oide Version $1 glöscht.',
	'descending_abbrev' => 'ob',
	'duplicate-defaultsort' => 'Ówocht: Da Sortiarungsschlyssel "$2" ywerschreibt dén vurher vawendten Schlyssel "$1".',
	'dberr-header' => 'Dés Wiki hod a Próblém',
	'dberr-problems' => 'Tschuidigung. Dé Seiten hod im Moment technische Próbléme.',
	'dberr-again' => "Wort a por Minuten und vasuachs dånn neich z' loon.",
	'dberr-info' => '(Kå koah Vabindung zum Daatenbånkserver herstön: $1)',
	'dberr-usegoogle' => 'Du kunntersd dawei mid Google suachen.',
	'dberr-outofdate' => 'Beochtt, daas da Suachindex voh inserne Inhoitt bei Google vaoiterd seih kunnt.',
);

$messages['bat-smg'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezember',
	'dec' => 'Dez.',
	'delete' => 'léschen',
	'deletethispage' => 'De Seiten leschen',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Feeler in da Daatenbånk',
	'dberrortext' => "Es is a Daatenbånkfeeler auftreeden!
Da Grund kå a Prógrammierfeeler seih.
D' létzde Daatenbånkobfrog wor:
<blockquote><tt>$1</tt></blockquote>
aus da Funkzión „<tt>$2</tt>“.
Dé Daatenbånk hod an Feeler „<tt>$3: $4</tt>“ gmödt.",
	'dberrortextcl' => "Tschuidigung! Es hod an Syntaxfeeler in da Daatenbånkobfrog geem.
D' letzte Daatenbånkobfrog hod  „$1“ aus da Funkzion „<tt>$2</tt>“ glautt.
De Daatenbånk möidt 'n Feeler: „<tt>$3: $4</tt>“.",
	'directorycreateerror' => 'As Vazeichnis „$1“ hod néd åglégt wern kenner.',
	'deletedhist' => 'Gléschde Versiónen',
	'difference' => '(Unterschiad zwischen dé Versiónen)',
	'diff-multi' => '({{PLURAL:$1|A dazwischenliegerte Versión|$1 dazwischenliegende Versiónen}} vohram {{PLURAL:$2|Benutzer|$2 Benutzern}} {{PLURAL:$1|werd|wern}} néd åzoagt)',
	'diff' => 'Unterschiad',
	'destfilename' => 'Zünaum:',
	'duplicatesoffile' => "{{PLURAL:$1|D'foignde Datei is a Duplikat|De foigndn $1 Datein han Duplikate}} vu dea Datei ([[Special:FileDuplicateSearch/$2|weidare Deteus]]):",
	'download' => 'Owerlooden',
	'disambiguationspage' => 'Template:Begriffsklärung',
	'disambiguations-text' => "D' fóigernden Seiten valinken af a Seiten za ner Begiefsklärung. Du sóiderst stott dém af d' oagerntlich gmoahde Seiten valinken.

A Seiten gijt ois Begriefsklärungsseiten, waunns oane vah dé af [[MediaWiki:Disambiguationspage]] afgfyrde Vurloog(ng) eihbindt.</br>
Links as Naumensraim wern do néd afglistt.",
	'doubleredirects' => 'Doppede Weiderloatungen',
	'deadendpages' => 'Néd valinkende Seiten',
	'deadendpagestext' => 'Dé fóigénden Seiten vaweisen néd auf aundre Seiten voh {{SITENAME}}.',
	'deletedcontributions' => 'Gléschde Beitrég',
	'deletepage' => 'Seiten léschen',
	'delete-confirm' => 'Léschen voh „$1“',
	'delete-legend' => 'Léschen',
	'deletedtext' => '„$1“ is glöscht worn. Im $2 findn Sie a Listn vo de letzten Löschungen.',
	'dellogpage' => 'Lésch-Logbiache',
	'deletionlog' => 'Lösch-Logbuach',
	'deletecomment' => 'Grund:',
	'deleteotherreason' => 'Ånderner/ergänzender Grund:',
	'deletereasonotherlist' => 'Åndrer Grund:',
	'deletereason-dropdown' => '* Oigmoane Léschgrynd
** Wunsch vom Autór
** Urhéwerrechtsvalétzung
** Vandalismus',
	'delete-edit-reasonlist' => 'Léschgrynd beorwaten',
	'databasenotlocked' => 'De Datenbank is net gsperrt.',
	'delete_and_move' => 'Löschn und vaschiam',
	'delete_and_move_reason' => 'glöscht, um Plåtz fia Vaschiam zum macha',
	'deletedrevision' => 'Oide Version $1 glöscht.',
	'descending_abbrev' => 'ob',
	'duplicate-defaultsort' => 'Ówocht: Da Sortiarungsschlyssel "$2" ywerschreibt dén vurher vawendten Schlyssel "$1".',
	'dberr-header' => 'Dés Wiki hod a Próblém',
	'dberr-problems' => 'Tschuidigung. Dé Seiten hod im Moment technische Próbléme.',
	'dberr-again' => "Wort a por Minuten und vasuachs dånn neich z' loon.",
	'dberr-info' => '(Kå koah Vabindung zum Daatenbånkserver herstön: $1)',
	'dberr-usegoogle' => 'Du kunntersd dawei mid Google suachen.',
	'dberr-outofdate' => 'Beochtt, daas da Suachindex voh inserne Inhoitt bei Google vaoiterd seih kunnt.',
);

$messages['bcc'] = array(
	'december' => 'دسمبر',
	'december-gen' => 'دسمبر',
	'dec' => 'دس',
	'delete' => 'حذف',
	'deletethispage' => 'ای صفحه حذف کن',
	'disclaimers' => 'بی میاری گیان',
	'disclaimerpage' => 'Project:عمومی بی میاریگان',
	'databaseerror' => 'حطا دیتابیس',
	'dberrortext' => 'یک اشتباه ته درخواست دیتابیس پیش آتک.
شی شاید یک باگی ته نرم افزار پیش داریت.
آهرین تلاش درخواست دیتابیس بوته:
<blockquote><tt>$1</tt></blockquote>
"<tt>$2</tt>".
ته ای عملگر ما اس کیو ال ای حطا پیش داشتت "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'یک اشتباه ته درخواست دیتابیس پیش آتک.
آهری تلاش درخواست دیتابیس بوتت:
"$1"
چه ای عملگر"$2".
مای اس کیو ال ای حطا پیش داشتت  "$3: $4"',
	'directorycreateerror' => 'نه تونیت مسیر شرکتن  "$1".',
	'deletedhist' => 'تاریح حذف بوت',
	'difference' => '(تفاوتان بین نسخه یان)',
	'diff-multi' => '({{PLURAL:$1|یک متوسطین بازبینیان میانی}} پیش دارگ نه بیت .)',
	'datedefault' => 'هچ ترجیح',
	'defaultns' => 'گردگ ته ای نام فضا آن په طور پیش فرض:',
	'default' => 'پیش فرض',
	'diff' => 'تفاوت',
	'destfilename' => 'مقصد نام فایل',
	'duplicatesoffile' => 'جهلیگین {{PLURAL:$1|فایل یک کپی انت|$2 فایلان کپی انت}} چه هی فایل ([[Special:FileDuplicateSearch/$2|گیشترین اطلاعات]]):',
	'download' => 'آیرگیزگ',
	'disambiguations' => 'صفحات رفع ابهام',
	'disambiguationspage' => 'Template:رفع ابهام',
	'disambiguations-text' => "جهلیگین صفحه لینک انت په یک '''صفحه رفع ابهام'''.
شما بایدن په جاه آیی په یک مناسبین موضوعی لینک دهیت.<br />
یک صفحه ای که په داب صفحه رفع ابهام چارگ بیت اگر آیء چه یک تمپلتی که لینک بیت چه [[MediaWiki:Disambiguationspage|صفحه رفع ابهام]] استفاده کنت.",
	'doubleredirects' => 'دوبل غیر مستقیم',
	'doubleredirectstext' => 'ای صفحه لیست کنت صفحاتی که غیر مستقیم رونت په دگه صفحات. هر ردیف شامل لینکانی انت به اولی و دومی غیر مستقیم، و هدف دومی غیر مستقیم، که معمولا استفاده بیت "real" صفحه هدف، که بایدن اولی غیر مستقیم پیش داریت.',
	'double-redirect-fixed-move' => '[[$1]] انتقال دهگ بوتت، و الان تغییر مسیری په [[$2]] انت',
	'double-redirect-fixer' => 'تعمیرکنوک غیر مستقیم',
	'deadendpages' => 'مرتگین صفحات',
	'deadendpagestext' => 'جهلیگین صفحات په صفحات دگر لینک نهنت ته {{SITENAME}}.',
	'deletedcontributions' => 'مشارکتان کابر حذف بوتء',
	'deletedcontributions-title' => 'مشارکتان کابر حذف بوتء',
	'defemailsubject' => '{{SITENAME}} ایمیل',
	'deletepage' => 'حذف صفحه',
	'delete-confirm' => 'حذف "$1"',
	'delete-legend' => 'حذف',
	'deletedtext' => '"$1" حذف بیت.
بگندیت $2 په ثبتی که نوکین حذفیات',
	'dellogpage' => 'حذف ورودان',
	'dellogpagetext' => 'جهلء یک لیستی چه نوکترین حذفیات هست.',
	'deletionlog' => 'آمار حذف',
	'deletecomment' => 'دلیل:',
	'deleteotherreason' => 'دگه/گیشترین دلیل:',
	'deletereasonotherlist' => 'دگه دلیل',
	'deletereason-dropdown' => '*متداولین دلایل حذف
** درخواست نویسوک
** نقض حق کپی
** حرابکاری',
	'delete-edit-reasonlist' => 'اصلاح کن دلایل حذفء',
	'delete-toobig' => 'صفحهء یک مزنین تاریح اصلاحی هست گیشتر چه $1 {{PLURAL:$1|بازبینی|بازبینی}}.
حذف چوشین صفحات په خاظر جلو گر چه ناگهانی اتفاق ته سایت {{SITENAME}} ممنوع بوتت.',
	'delete-warning-toobig' => 'ای صفحه  مزنین تاریح اصلاح هست، گیش چه  $1 {{PLURAL:$1|بازبینی|بازبینی}}.
حذف آی شاید کار دیتابیس  {{SITENAME}} قطع کنت؛
گون اخطار پیش روت.',
	'databasenotlocked' => 'دیتابیس کبل نهنت.',
	'delete_and_move' => 'حذف وجاه په جاه کن',
	'delete_and_move_text' => '== حذف نیاز داریت په ==
صفحه مبدا "[[:$1]]"  که هنگت هستن.
آیا شما لوٹیت آیء حذف کنیت دان په حذف‌ آیء راهی شر بیت؟',
	'delete_and_move_confirm' => 'بله، صفحه حذف کن',
	'delete_and_move_reason' => 'حذف بوت په شرکتن راه په جاه په جاه کتن',
	'djvu_page_error' => 'صفحه Djvu در چه محدوده انت',
	'djvu_no_xml' => 'نه تونیت XML بیاریت په فایل DjVu',
	'deletedrevision' => 'قدیمی بازبینی $1 حذف بوت',
	'deletedwhileediting' => "'''هوژاری''': ای صفحه حذف بوتت رند چه شمی اصلاح کتن شروه بیگ!",
	'descending_abbrev' => 'جهلادی',
	'duplicate-defaultsort' => 'هژاری: ترتیب پیش فرض «$2» ترتیب پیش فرض پیشگین «$1» را باطل کنت.',
	'dberr-header' => 'ای ویکی ءَ مشکل هستن',
	'dberr-problems' => 'شرمنده! این سایت ءَ تکنیکی مشکل هستن.',
	'dberr-again' => 'چنت دقیقه صبر کنیت و دگه صفحه بیاریت',
	'dberr-info' => '(نه توینت گون دیتابیس سرور تماس گیرت: $1)',
	'dberr-usegoogle' => 'شما تونید دان آ وهد گردگ ته گوگل ءَ آزمایش کنیت.',
	'dberr-outofdate' => 'توجه ببینت که می ایندکس محتواءَ بلکین قدیمی ببنت.',
	'dberr-cachederror' => 'آ چیزی که رندا کیت یک کپی ذخیره ای چه لوتگین صفحه انت و بلکین قدیمی ببیت',
);

$messages['bcl'] = array(
	'december' => 'Desyembre',
	'december-gen' => 'Desyembre',
	'dec' => 'Des',
	'delete' => 'Paraon',
	'deletethispage' => 'Paraon ining pahina',
	'disclaimers' => 'Mga pagpabayà',
	'disclaimerpage' => 'Project:Pankagabsán na pagpabayà',
	'databaseerror' => 'Salâ sa base nin datos',
	'dberrortext' => 'May salâ sa hapot na sintaksis kan base nin datos.
Pwedeng may salâ digdi.
An huring probar na hapót iyo:
<blockquote><tt>$1</tt></blockquote>
hale sa aksyón "<tt>$2</tt>".
AnSQL ko nagbalik nin salâ na"<tt>$3: $4</tt>".',
	'dberrortextcl' => 'May salâ sa hapót nin sintaksis kan base nin datos.
Ini an huring probar na hapót:
"$1"
sa aksyón na "$2".
AnSQL ko nagbalik nin salâ na"$3: $4"',
	'directorycreateerror' => 'Dai nagibo an direktorya na "$1".',
	'difference' => '(Kaibhán kan mga pagpakarháy)',
	'diff-multi' => '({{PLURAL:$1|One intermediate revision|$1 intermediate revisions}} dai ipinahihiling.)',
	'datedefault' => 'Mayong kabôtan',
	'defaultns' => 'Maghilíng mûna sa ining mga ngaran-espacio:',
	'default' => 'pwestong normal',
	'diff' => 'ibá',
	'destfilename' => "''Filename'' kan destinasyón",
	'download' => 'ideskarga',
	'disambiguations' => 'Mga pahinang klaripikasyon',
	'disambiguationspage' => 'Template:clarip',
	'disambiguations-text' => "An mga nasunod na páhina nakatakod sa sarong '''páhina nin klaripikasyon'''.
Imbis, kaipuhan na nakatakod sinda sa maninigong tema.<br />
An páhina pigkokonsiderar na páhina nin klaripikasyon kun naggagamit ini nin templatong nakatakod sa [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dobleng mga redirekta',
	'doubleredirectstext' => 'Piglilista kaining pahina an mga pahinang minalikay sa ibang pahinang paralikay. Kada raya may mga takod sa primero asin segundang likay, buda an destino kan segundong likay, na puro-pirme sarong "tunay " na pahinang destino, na dapat duman nakaturo an primerong likay.',
	'deadendpages' => 'Mga pahinang mayong luwasan',
	'deadendpagestext' => 'An mga nagsusunod na pahina dai nakatakod sa mga ibang pahina sa ining wiki.',
	'deletedcontributions' => 'Parâon an mga kontribusyon kan parágamit',
	'deletedcontributions-title' => 'Parâon an mga kontribusyon kan parágamit',
	'defemailsubject' => '{{SITENAME}} e-surat',
	'deletepage' => 'Paraon an pahina',
	'delete-legend' => 'Paraon',
	'deletedtext' => 'Pigparà na an "$1" .
Hilingón tabì an $2 para mahiling an lista nin mga kaaagi pa sanang pagparà.',
	'dellogpage' => 'Usip nin pagparà',
	'dellogpagetext' => 'Mahihiling sa babâ an lista kan mga pinakahuring pagparâ.',
	'deletionlog' => 'Historial nin pagparâ',
	'deletecomment' => 'Rason:',
	'deleteotherreason' => 'Iba/dugang na rason:',
	'deletereasonotherlist' => 'Ibang rason',
	'databasenotlocked' => 'Dai nakakandado an base nin datos.',
	'delete_and_move' => 'Parâon asin ibalyó',
	'delete_and_move_text' => '==Kaipuhan na parâon==

Igwa nang páhina na "[[:$1]]". Gusto mong parâon ini tangarig maibalyó?',
	'delete_and_move_confirm' => 'Iyo, parâon an pahina',
	'delete_and_move_reason' => 'Pinarâ tangarig maibalyó',
	'djvu_page_error' => 'luwas sa serye an páhina kan DjVu',
	'djvu_no_xml' => 'Dai makua an XML para sa DjVu file',
	'deletedrevision' => 'Pigparâ an lumang pagribay na $1.',
	'deletedwhileediting' => 'Patanid: Pigparâ na an pahinang ini antes na nagpoon kan maghirá!',
	'descending_abbrev' => 'ba',
);

$messages['be'] = array(
	'december' => 'Снежань',
	'december-gen' => 'снежня',
	'dec' => 'Сне',
	'delete' => 'сцерці',
	'deletethispage' => 'Сцерці гэту старонку',
	'disclaimers' => 'Адмова ад адказнасці',
	'disclaimerpage' => 'Project:Агульная адмова ад адказнасці',
	'databaseerror' => 'Памылка базы дадзеных',
	'dberrortext' => 'Памылка ў сінтаксісе звароту ў базу даных.
Магчыма, прычына ў памылцы ў праграмным забеспячэнні.
Апошні зварот у базу, які спрабаваўся:

<blockquote><tt>$1</tt></blockquote>
з функцыі "<tt>$2</tt>".
Памылка, вернутая з БД: "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Памылка ў сінтаксісе звароту ў базу даных.
Апошні зварот у базу, які спрабаваўся:
"$1"
з функцыі "$2".
Памылка, вернутая з БД: "$3: $4"',
	'directorycreateerror' => 'Немагчыма стварыць тэчку "$1".',
	'deletedhist' => 'Сцёртая гісторыя',
	'difference' => '(Розніца між версіямі)',
	'difference-multipage' => '(Розніца паміж старонкамі)',
	'diff-multi' => '(не паказан{{PLURAL:$1|а адна прамежкавая версія|ы $1 прамежкавых версій}}, зроблен{{PLURAL:$2|ая ўдзельнікам|ыя $2 удзельнікамі}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|не паказана $1 прамежкавая версія|не паказаны $1 прамежкавыя версіі|не паказаны $1 прамежкавых версій}}, зробленыя больш чым {{PLURAL:$2|$1 удзельнікам|$2 удзельнікамі}})',
	'datedefault' => 'Не вызначана',
	'defaultns' => 'Іначай шукаць у гэтых прасторах назваў:',
	'default' => 'прадвызначэнні',
	'diff' => 'розн.',
	'destfilename' => 'Назва мэтавага файла:',
	'duplicatesoffile' => "Наступн{{PLURAL:$1|ы файл з'яўляецца дублікатам|ыя $1 файлы з'яўляюцца дублікатамі}} гэтага файла ([[Special:FileDuplicateSearch/$2|падрабязна]]):",
	'download' => 'узяць сабе',
	'disambiguations' => 'Старонкі, якія спасылаюцца на старонкі вырашэння неадназначнасцяў',
	'disambiguationspage' => 'Template:Неадназначнасць',
	'disambiguations-text' => "Гэтыя старонкі спасылаюцца на '''старонкі развязкі неадназначнасцяў'''.
Лепей, каб яны спасылаліся на канкрэтныя тэматычныя старонкі.<br />
Старонка лічыцца старонкай развязкі, калі ў яе ўлучаецца такі шаблон, на які спасылаецца [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Падвойныя перасылкі',
	'doubleredirectstext' => 'Тут пералічаныя старонкі-перасылкі, якія паказваюць на іншыя перасылкі.
Кожны радок утрымлівае спасылкі на першую і другую перасылкі, а таксама мэту другой перасылкі, якая звычайна і ёсць "сапраўдная" мэтавая старонка, на якую павінна была паказваць першая перасылка.
<del>Закрэсленыя складнікі</del> ўжо былі папраўленыя.',
	'double-redirect-fixed-move' => 'Назва [[$1]] была перанесена, і зараз перасылае да [[$2]]',
	'double-redirect-fixed-maintenance' => 'Выпраўленне падвойнага перанакіравання з [[$1]] на [[$2]].',
	'double-redirect-fixer' => 'Выпраўляльнік перасылак',
	'deadendpages' => 'Старонкі без спасылак',
	'deadendpagestext' => 'Спіс старонак без спасылак на тутэйшыя артыкулы.',
	'deletedcontributions' => 'Выдалены ўклад удзельніка',
	'deletedcontributions-title' => 'Выдалены ўклад удзельніка',
	'defemailsubject' => '{{SITENAME}} — Ліст ад $1',
	'deletepage' => 'Сцерці старонку',
	'delete-confirm' => 'Сцерці "$1"',
	'delete-legend' => 'Сцерці',
	'deletedtext' => '"$1" было выдалена.
Бач $2 па журнал нядаўніх выдаленняў.',
	'dellogpage' => 'Журнал сціранняў',
	'dellogpagetext' => 'Ніжэй паказаны спіс самых нядаўніх сціранняў.',
	'deletionlog' => 'журнал сціранняў',
	'deletecomment' => 'Прычына:',
	'deleteotherreason' => 'Іншы/дадатковы повад:',
	'deletereasonotherlist' => 'Іншы повад',
	'deletereason-dropdown' => '*Звычайныя прычыны сцірання
** Жаданне аўтара тэксту
** Парушэнне аўтарскага права
** Вандалізм',
	'delete-edit-reasonlist' => 'Правіць прычыны сцірання',
	'delete-toobig' => 'Старонка мае вялікую гісторыю правак, больш за $1 {{PLURAL:$1|версію|версій}}. Сціранне такіх старонак было абмежавана, каб пазбегчы ўтварэння выпадковых перашкод працы {{SITENAME}}.',
	'delete-warning-toobig' => 'Старонка мае вялікую гісторыю правак, больш за $1 {{PLURAL:$1|версію|версій}}. Сціранне такіх старонак можа перашкодзіць працы базы даных {{SITENAME}}; будзьце асцярожнымі.',
	'databasenotlocked' => 'База дадзеных не замкнутая.',
	'delete_and_move' => 'Выдаліць і перанесці',
	'delete_and_move_text' => '==Патрабуецца сціранне==

Ужо існуе артыкул з мэтавай назвай "[[:$1]]". Дык ці жадаеце сцерці яго, каб зрабіць месца для пераносу?',
	'delete_and_move_confirm' => 'Так, сцерці старонку',
	'delete_and_move_reason' => 'Сцёрта, каб зрабіць месца для пераносу "[[$1]]"',
	'djvu_page_error' => 'Старонка DjVu па-за інтэрвалам',
	'djvu_no_xml' => 'Не ўдалося ўзяць XML для файла DjVu',
	'deletedrevision' => 'Сцёрта старая версія $1',
	'days' => '{{PLURAL:$1|$1 дзень|$1 дня|$1 дзён}}',
	'deletedwhileediting' => "'''Увага''': гэтая старонка была сцёрта пасля таго, як вы пачалі з ёй працаваць!",
	'descending_abbrev' => 'да менш.',
	'duplicate-defaultsort' => 'Увага: прадвызначаная клавіша ўпарадкавання "$2" замяніла ранейшую такую клавішу "$1".',
	'dberr-header' => 'Праблема на пляцоўцы',
	'dberr-problems' => 'Прабачце, на пляцоўцы здарыліся тэхнічныя цяжкасці.',
	'dberr-again' => 'Паспрабуйце перачытаць праз некалькі хвілін.',
	'dberr-info' => '(Немагчыма звязацца з серверам баз даных: $1)',
	'dberr-usegoogle' => 'Тымчасам можна паспрабаваць пошук праз Гугл.',
	'dberr-outofdate' => 'Заўважце, што тамтэйшыя індэксы тутэйшага зместу могуць быць састарэлымі.',
	'dberr-cachederror' => 'Гэта копія старонкі, узятая з кэшу, і, магчыма, састарэлая.',
);

$messages['be-tarask'] = array(
	'december' => 'сьнежань',
	'december-gen' => 'сьнежня',
	'dec' => '12',
	'delete' => 'Выдаліць',
	'deletethispage' => 'Выдаліць гэтую старонку',
	'disclaimers' => 'Адмова ад адказнасьці',
	'disclaimerpage' => 'Project:Адмова ад адказнасьці',
	'databaseerror' => 'Памылка базы зьвестак',
	'dberrortext' => 'Выяўленая памылка сынтаксісу ў звароце да базы зьвестак.
Магчыма, гэта памылка праграмнага забесьпячэньня.
Апошні запыт да базы:
<blockquote><tt>$1</tt></blockquote>
адбыўся з функцыі «<tt>$2</tt>».
База зьвестак вярнула памылку «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'Выяўлена памылка сынтаксісу ў звароце да базы зьвестак.
Апошні запыт да базы:
«$1»
адбыўся з функцыі «$2».
База зьвестак вярнула памылку «$3: $4»',
	'directorycreateerror' => 'Немагчыма стварыць дырэкторыю «$1».',
	'deletedhist' => 'Выдаленая гісторыя',
	'difference' => '(Адрозьненьні паміж вэрсіямі)',
	'difference-multipage' => '(Розьніца паміж старонкамі)',
	'diff-multi' => '($1 {{PLURAL:$1|прамежная вэрсія|прамежныя вэрсіі|прамежных вэрсіяў}} $2 {{PLURAL:$2|удзельніка|удзельнікаў|удзельнікаў}} {{PLURAL:$1|не паказаная|не паказаныя|не паказаныя}})',
	'diff-multi-manyusers' => '($1 {{PLURAL:$1|прамежная вэрсія|прамежныя вэрсіі|прамежных вэрсіяў}} $2 {{PLURAL:$2|удзельніка|удзельнікаў|удзельнікаў}} {{PLURAL:$1|не паказаная|не паказаныя|не паказаныя}})',
	'datedefault' => 'Па змоўчаньні',
	'defaultns' => 'Інакш шукаць у наступных прасторах назваў:',
	'default' => 'па змоўчваньні',
	'diff' => 'розьн',
	'destfilename' => 'Канчатковая назва файла:',
	'duplicatesoffile' => '{{PLURAL:$1|Наступны файл дублюе|Наступныя файлы дублююць}} гэты файл ([[Special:FileDuplicateSearch/$2|падрабязнасьці]]):',
	'download' => 'загрузіць',
	'disambiguations' => 'Старонкі, якія спасылаюцца на старонкі-неадназначнасьці',
	'disambiguationspage' => 'Template:Неадназначнасьць',
	'disambiguations-text' => "Наступныя старонкі спасылаюцца на '''старонкі-неадназначнасьці'''.
Замест гэтага, яны павінны спасылацца на пэўныя старонкі.<br />
Старонка лічыцца шматзначнай, калі яна ўтрымлівае шаблён назва якога знаходзіцца на старонцы [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Двайныя перанакіраваньні',
	'doubleredirectstext' => 'На гэтай старонцы пададзены сьпіс перанакіраваньняў на іншыя перанакіраваньні. Кожны радок утрымлівае спасылкі на першае і другое перанакіраваньне, а таксама мэтавую старонку другога перанакіраваньня, якая звычайна зьяўляецца «сапраўднай» мэтавай старонкай, куды павіннае спасылацца першае перанакіраваньне.
<del>Закрэсьленыя</del> элемэнты былі выпраўленыя.',
	'double-redirect-fixed-move' => '[[$1]] была перанесеная, яна цяпер перанакіроўвае на [[$2]]',
	'double-redirect-fixed-maintenance' => 'Выпраўленьне падвойнага перанакіраваньня з [[$1]] на [[$2]].',
	'double-redirect-fixer' => 'Выпраўленьне перанакіраваньняў',
	'deadendpages' => 'Тупіковыя старонкі',
	'deadendpagestext' => 'Наступныя старонкі не спасылаюцца на іншыя старонкі {{GRAMMAR:родны|{{SITENAME}}}}.',
	'deletedcontributions' => 'Выдалены ўнёсак удзельніка',
	'deletedcontributions-title' => 'Выдалены ўнёсак удзельніка',
	'defemailsubject' => 'Электронная пошта {{GRAMMAR:родны|{{SITENAME}}}} ад {{GENDER:$1|удзельніка|удзельніцы}} «$1»',
	'deletepage' => 'Выдаліць старонку',
	'delete-confirm' => 'Выдаліць «$1»',
	'delete-legend' => 'Выдаліць',
	'deletedtext' => '«$1» была выдаленая.
Глядзіце журнал выдаленьняў у $2.',
	'dellogpage' => 'Журнал выдаленьняў',
	'dellogpagetext' => 'Сьпіс апошніх выдаленьняў.',
	'deletionlog' => 'журнал выдаленьняў',
	'deletecomment' => 'Прычына:',
	'deleteotherreason' => 'Іншая/дадатковая прычына:',
	'deletereasonotherlist' => 'Іншая прычына',
	'deletereason-dropdown' => '* Агульныя прычыны выдаленьня
** Запыт аўтара/аўтаркі
** Парушэньне аўтарскіх правоў
** Вандалізм',
	'delete-edit-reasonlist' => 'Рэдагаваць прычыны выдаленьня',
	'delete-toobig' => 'Гэтая старонка мае доўгую гісторыю рэдагаваньняў, болей за $1 {{PLURAL:$1|вэрсію|вэрсіі|вэрсій}}.
Выдаленьне такіх старонак было забароненае, каб пазьбегнуць праблемаў у працы {{GRAMMAR:родны|{{SITENAME}}}}.',
	'delete-warning-toobig' => 'Гэтая старонка мае доўгую гісторыю рэдагаваньняў, больш за $1 {{PLURAL:$1|вэрсію|вэрсіі|вэрсій}}.
Яе выдаленьне можа выклікаць праблемы ў працы базы зьвестак {{GRAMMAR:родны|{{SITENAME}}}}; будзьце асьцярожны.',
	'databasenotlocked' => 'База зьвестак не заблякаваная.',
	'delete_and_move' => 'Выдаліць і перанесьці',
	'delete_and_move_text' => '==Патрабуецца выдаленьне==
Мэтавая старонка «[[:$1]]» ужо існуе.
Ці жадаеце Вы яе выдаліць, каб вызваліць месца для пераносу?',
	'delete_and_move_confirm' => 'Так, выдаліць старонку',
	'delete_and_move_reason' => 'Выдаленая, каб вызваліць месца для пераносу «[[$1]]»',
	'djvu_page_error' => 'Старонка DjVu па-за прамежкам',
	'djvu_no_xml' => 'Немагчыма атрымаць XML для DjVu-файла',
	'deletedrevision' => 'Выдаленая старая вэрсія $1',
	'days-abbrev' => '$1 дз',
	'days' => '$1 {{PLURAL:$1|дзень|дні|дзён}}',
	'deletedwhileediting' => "'''Увага''': Гэтая старонка была выдаленая пасьля таго, як Вы пачалі яе рэдагаваньне!",
	'descending_abbrev' => 'зьмянш.',
	'duplicate-defaultsort' => 'Папярэджаньне: Ключ сартыроўкі па змоўчваньні «$2» замяняе папярэдні ключ сартыроўкі па змоўчваньні «$1».',
	'dberr-header' => 'Гэтая вікі не функцыянуе спраўна',
	'dberr-problems' => 'Прабачце! На гэтым сайце ўзьніклі тэхнічныя цяжкасьці.',
	'dberr-again' => 'Паспрабуйце пачакаць некалькі хвілінаў і абнавіць.',
	'dberr-info' => '(Немагчыма злучыцца з сэрвэрам базы зьвестак: $1)',
	'dberr-usegoogle' => 'Вы можаце пакуль паспрабаваць пашукаць праз Google.',
	'dberr-outofdate' => 'Увага, індэксы нашага зьместу могуць быць састарэлымі.',
	'dberr-cachederror' => 'Наступная старонка была загружана з кэшу і можа быць састарэлай.',
);

$messages['be-x-old'] = array(
	'december' => 'сьнежань',
	'december-gen' => 'сьнежня',
	'dec' => '12',
	'delete' => 'Выдаліць',
	'deletethispage' => 'Выдаліць гэтую старонку',
	'disclaimers' => 'Адмова ад адказнасьці',
	'disclaimerpage' => 'Project:Адмова ад адказнасьці',
	'databaseerror' => 'Памылка базы зьвестак',
	'dberrortext' => 'Выяўленая памылка сынтаксісу ў звароце да базы зьвестак.
Магчыма, гэта памылка праграмнага забесьпячэньня.
Апошні запыт да базы:
<blockquote><tt>$1</tt></blockquote>
адбыўся з функцыі «<tt>$2</tt>».
База зьвестак вярнула памылку «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'Выяўлена памылка сынтаксісу ў звароце да базы зьвестак.
Апошні запыт да базы:
«$1»
адбыўся з функцыі «$2».
База зьвестак вярнула памылку «$3: $4»',
	'directorycreateerror' => 'Немагчыма стварыць дырэкторыю «$1».',
	'deletedhist' => 'Выдаленая гісторыя',
	'difference' => '(Адрозьненьні паміж вэрсіямі)',
	'difference-multipage' => '(Розьніца паміж старонкамі)',
	'diff-multi' => '($1 {{PLURAL:$1|прамежная вэрсія|прамежныя вэрсіі|прамежных вэрсіяў}} $2 {{PLURAL:$2|удзельніка|удзельнікаў|удзельнікаў}} {{PLURAL:$1|не паказаная|не паказаныя|не паказаныя}})',
	'diff-multi-manyusers' => '($1 {{PLURAL:$1|прамежная вэрсія|прамежныя вэрсіі|прамежных вэрсіяў}} $2 {{PLURAL:$2|удзельніка|удзельнікаў|удзельнікаў}} {{PLURAL:$1|не паказаная|не паказаныя|не паказаныя}})',
	'datedefault' => 'Па змоўчаньні',
	'defaultns' => 'Інакш шукаць у наступных прасторах назваў:',
	'default' => 'па змоўчваньні',
	'diff' => 'розьн',
	'destfilename' => 'Канчатковая назва файла:',
	'duplicatesoffile' => '{{PLURAL:$1|Наступны файл дублюе|Наступныя файлы дублююць}} гэты файл ([[Special:FileDuplicateSearch/$2|падрабязнасьці]]):',
	'download' => 'загрузіць',
	'disambiguations' => 'Старонкі, якія спасылаюцца на старонкі-неадназначнасьці',
	'disambiguationspage' => 'Template:Неадназначнасьць',
	'disambiguations-text' => "Наступныя старонкі спасылаюцца на '''старонкі-неадназначнасьці'''.
Замест гэтага, яны павінны спасылацца на пэўныя старонкі.<br />
Старонка лічыцца шматзначнай, калі яна ўтрымлівае шаблён назва якога знаходзіцца на старонцы [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Двайныя перанакіраваньні',
	'doubleredirectstext' => 'На гэтай старонцы пададзены сьпіс перанакіраваньняў на іншыя перанакіраваньні. Кожны радок утрымлівае спасылкі на першае і другое перанакіраваньне, а таксама мэтавую старонку другога перанакіраваньня, якая звычайна зьяўляецца «сапраўднай» мэтавай старонкай, куды павіннае спасылацца першае перанакіраваньне.
<del>Закрэсьленыя</del> элемэнты былі выпраўленыя.',
	'double-redirect-fixed-move' => '[[$1]] была перанесеная, яна цяпер перанакіроўвае на [[$2]]',
	'double-redirect-fixed-maintenance' => 'Выпраўленьне падвойнага перанакіраваньня з [[$1]] на [[$2]].',
	'double-redirect-fixer' => 'Выпраўленьне перанакіраваньняў',
	'deadendpages' => 'Тупіковыя старонкі',
	'deadendpagestext' => 'Наступныя старонкі не спасылаюцца на іншыя старонкі {{GRAMMAR:родны|{{SITENAME}}}}.',
	'deletedcontributions' => 'Выдалены ўнёсак удзельніка',
	'deletedcontributions-title' => 'Выдалены ўнёсак удзельніка',
	'defemailsubject' => 'Электронная пошта {{GRAMMAR:родны|{{SITENAME}}}} ад {{GENDER:$1|удзельніка|удзельніцы}} «$1»',
	'deletepage' => 'Выдаліць старонку',
	'delete-confirm' => 'Выдаліць «$1»',
	'delete-legend' => 'Выдаліць',
	'deletedtext' => '«$1» была выдаленая.
Глядзіце журнал выдаленьняў у $2.',
	'dellogpage' => 'Журнал выдаленьняў',
	'dellogpagetext' => 'Сьпіс апошніх выдаленьняў.',
	'deletionlog' => 'журнал выдаленьняў',
	'deletecomment' => 'Прычына:',
	'deleteotherreason' => 'Іншая/дадатковая прычына:',
	'deletereasonotherlist' => 'Іншая прычына',
	'deletereason-dropdown' => '* Агульныя прычыны выдаленьня
** Запыт аўтара/аўтаркі
** Парушэньне аўтарскіх правоў
** Вандалізм',
	'delete-edit-reasonlist' => 'Рэдагаваць прычыны выдаленьня',
	'delete-toobig' => 'Гэтая старонка мае доўгую гісторыю рэдагаваньняў, болей за $1 {{PLURAL:$1|вэрсію|вэрсіі|вэрсій}}.
Выдаленьне такіх старонак было забароненае, каб пазьбегнуць праблемаў у працы {{GRAMMAR:родны|{{SITENAME}}}}.',
	'delete-warning-toobig' => 'Гэтая старонка мае доўгую гісторыю рэдагаваньняў, больш за $1 {{PLURAL:$1|вэрсію|вэрсіі|вэрсій}}.
Яе выдаленьне можа выклікаць праблемы ў працы базы зьвестак {{GRAMMAR:родны|{{SITENAME}}}}; будзьце асьцярожны.',
	'databasenotlocked' => 'База зьвестак не заблякаваная.',
	'delete_and_move' => 'Выдаліць і перанесьці',
	'delete_and_move_text' => '==Патрабуецца выдаленьне==
Мэтавая старонка «[[:$1]]» ужо існуе.
Ці жадаеце Вы яе выдаліць, каб вызваліць месца для пераносу?',
	'delete_and_move_confirm' => 'Так, выдаліць старонку',
	'delete_and_move_reason' => 'Выдаленая, каб вызваліць месца для пераносу «[[$1]]»',
	'djvu_page_error' => 'Старонка DjVu па-за прамежкам',
	'djvu_no_xml' => 'Немагчыма атрымаць XML для DjVu-файла',
	'deletedrevision' => 'Выдаленая старая вэрсія $1',
	'days-abbrev' => '$1 дз',
	'days' => '$1 {{PLURAL:$1|дзень|дні|дзён}}',
	'deletedwhileediting' => "'''Увага''': Гэтая старонка была выдаленая пасьля таго, як Вы пачалі яе рэдагаваньне!",
	'descending_abbrev' => 'зьмянш.',
	'duplicate-defaultsort' => 'Папярэджаньне: Ключ сартыроўкі па змоўчваньні «$2» замяняе папярэдні ключ сартыроўкі па змоўчваньні «$1».',
	'dberr-header' => 'Гэтая вікі не функцыянуе спраўна',
	'dberr-problems' => 'Прабачце! На гэтым сайце ўзьніклі тэхнічныя цяжкасьці.',
	'dberr-again' => 'Паспрабуйце пачакаць некалькі хвілінаў і абнавіць.',
	'dberr-info' => '(Немагчыма злучыцца з сэрвэрам базы зьвестак: $1)',
	'dberr-usegoogle' => 'Вы можаце пакуль паспрабаваць пашукаць праз Google.',
	'dberr-outofdate' => 'Увага, індэксы нашага зьместу могуць быць састарэлымі.',
	'dberr-cachederror' => 'Наступная старонка была загружана з кэшу і можа быць састарэлай.',
);

$messages['bg'] = array(
	'december' => 'декември',
	'december-gen' => 'декември',
	'dec' => 'дек',
	'delete' => 'Изтриване',
	'deletethispage' => 'Изтриване',
	'disclaimers' => 'Условия за ползване',
	'disclaimerpage' => 'Project:Условия за ползване',
	'databaseerror' => 'Грешка при работа с базата от данни',
	'dberrortext' => 'Възникна синтактична грешка при заявка към базата данни.
Това може да означава грешка в софтуера.
Последната заявка към базата данни беше:
<blockquote><tt>$1</tt></blockquote>
при функцията „<tt>$2</tt>“.
MySQL върна грешка „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Възникна синтактична грешка при заявка към базата данни.
Последната заявка към базата данни беше:
„$1“
при функцията „$2“.
MySQL върна грешка „$3: $4“',
	'directorycreateerror' => 'Невъзможно е да бъде създадена директория „$1“.',
	'deletedhist' => 'Изтрита история',
	'difference' => '(Разлики между версиите)',
	'difference-multipage' => '(Разлики между страниците)',
	'diff-multi' => '({{PLURAL:$1|Не е показана една междинна версия|Не са показани $1 междинни версии}} от {{PLURAL:$2|един потребител|$2 потребителя}}.)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Не е показана една междинна версия|Не са показани $1 междинни версии}} от повече от $2 {{PLURAL:$2|потребител|потребителя}})',
	'datedefault' => 'Без предпочитание',
	'defaultns' => 'Или търсене в следните именни пространства:',
	'default' => 'по подразбиране',
	'diff' => 'разл',
	'destfilename' => 'Целево име:',
	'duplicatesoffile' => '{{PLURAL:$1|Следният файл се повтаря|Следните $1 файла се повтарят}} с този файл ([[Special:FileDuplicateSearch/$2|повече подробности]]):',
	'download' => 'сваляне',
	'disambiguations' => 'Страници, сочещи към пояснителни страници',
	'disambiguationspage' => 'Template:Пояснение',
	'disambiguations-text' => "Следните страници сочат към '''пояснителна страница''', вместо към истинската тематична страница.<br />Една страница се смята за пояснителна, ако ползва шаблон, към който се препраща от [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Двойни пренасочвания',
	'doubleredirectstext' => 'Тази страница съдържа списък със страници, които пренасочват към друга пренасочваща страница.
Всеки ред съдържа препратки към първото и второто пренасочване, както и целта на второто пренасочване, която обикновено е „истинската“ целева страница, към която първото пренасочване би трябвало да сочи.
<del>Задрасканите</del> записи са коригирани.',
	'double-redirect-fixed-move' => 'Оправяне на двойно пренасочване след преместването на [[$1]] като [[$2]]',
	'double-redirect-fixed-maintenance' => 'Поправяне на двойно пренасочване от [[$1]] към [[$2]].',
	'double-redirect-fixer' => 'Redirect fixer',
	'deadendpages' => 'Задънени страници',
	'deadendpagestext' => 'Следните страници нямат препратки към други страници от {{SITENAME}}.',
	'deletedcontributions' => 'Изтрити приноси на потребител',
	'deletedcontributions-title' => 'Изтрити приноси на потребител',
	'defemailsubject' => 'Писмо от потребител $1 в {{SITENAME}}',
	'deletepage' => 'Изтриване',
	'delete-confirm' => 'Изтриване на „$1“',
	'delete-legend' => 'Изтриване',
	'deletedtext' => 'Страницата „$1“ беше изтрита. Вижте $2 за запис на последните изтривания.',
	'dellogpage' => 'Дневник на изтриванията',
	'dellogpagetext' => 'Списък на последните изтривания.',
	'deletionlog' => 'дневник на изтриванията',
	'deletecomment' => 'Причина:',
	'deleteotherreason' => 'Друга/допълнителна причина:',
	'deletereasonotherlist' => 'Друга причина',
	'deletereason-dropdown' => '*Стандартни причини за изтриване
** По молба на автора
** Нарушение на авторски права
** Вандализъм',
	'delete-edit-reasonlist' => 'Редактиране на причините за изтриване',
	'delete-toobig' => 'Тази страница има голяма редакционна история с над $1 {{PLURAL:$1|версия|версии}}. Изтриването на такива страници е ограничено, за да се предотвратят евентуални поражения на {{SITENAME}}.',
	'delete-warning-toobig' => 'Тази страница има голяма редакционна история с над $1 {{PLURAL:$1|версия|версии}}. Възможно е изтриването да наруши някои операции в базата данни на {{SITENAME}}; необходимо е особено внимание при продължаване на действието.',
	'databasenotlocked' => 'Базата от данни не е заключена.',
	'delete_and_move' => 'Изтриване и преместване',
	'delete_and_move_text' => '== Наложително изтриване ==

Целевата страница „[[:$1]]“ вече съществува. Искате ли да я изтриете, за да освободите място за преместването?',
	'delete_and_move_confirm' => 'Да, искам да изтрия тази страница.',
	'delete_and_move_reason' => 'Изтрита, за да се освободи място за преместване от „[[$1]]“',
	'djvu_page_error' => 'Номерът на DjVu-страницата е извън обхвата',
	'djvu_no_xml' => 'Не е възможно вземането на XML за DjVu-файла',
	'deletedrevision' => 'Изтрита стара версия $1',
	'days' => '{{PLURAL:$1|$1 ден|$1 дни}}',
	'deletedwhileediting' => "'''Внимание''': Страницата е била изтрита, след като сте започнали да я редактирате!",
	'descending_abbrev' => 'низх',
	'duplicate-defaultsort' => 'Внимание: Ключът за сортиране по подразбиране „$2“ отменя по-ранния ключ „$1“.',
	'dberr-header' => 'Това уики има проблем',
	'dberr-problems' => 'Съжаляваме! Сайтът изпитва технически затруднения.',
	'dberr-again' => 'Изчакайте няколко минути и опитайте да презаредите.',
	'dberr-info' => '(Няма достъп до сървъра с базата данни: $1)',
	'dberr-usegoogle' => 'Междувременно опитайте да потърсите в Google.',
	'dberr-outofdate' => 'Имайте предвид, че индексираното от Гугъл наше съдържание може вече да е неактуално.',
	'dberr-cachederror' => 'Следва складирано копие на поисканата страница. Възможно е складираното копие да не е актуално.',
);

$messages['bh'] = array(
	'december' => 'декември',
	'december-gen' => 'декември',
	'dec' => 'дек',
	'delete' => 'Изтриване',
	'deletethispage' => 'Изтриване',
	'disclaimers' => 'Условия за ползване',
	'disclaimerpage' => 'Project:Условия за ползване',
	'databaseerror' => 'Грешка при работа с базата от данни',
	'dberrortext' => 'Възникна синтактична грешка при заявка към базата данни.
Това може да означава грешка в софтуера.
Последната заявка към базата данни беше:
<blockquote><tt>$1</tt></blockquote>
при функцията „<tt>$2</tt>“.
MySQL върна грешка „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Възникна синтактична грешка при заявка към базата данни.
Последната заявка към базата данни беше:
„$1“
при функцията „$2“.
MySQL върна грешка „$3: $4“',
	'directorycreateerror' => 'Невъзможно е да бъде създадена директория „$1“.',
	'deletedhist' => 'Изтрита история',
	'difference' => '(Разлики между версиите)',
	'difference-multipage' => '(Разлики между страниците)',
	'diff-multi' => '({{PLURAL:$1|Не е показана една междинна версия|Не са показани $1 междинни версии}} от {{PLURAL:$2|един потребител|$2 потребителя}}.)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Не е показана една междинна версия|Не са показани $1 междинни версии}} от повече от $2 {{PLURAL:$2|потребител|потребителя}})',
	'datedefault' => 'Без предпочитание',
	'defaultns' => 'Или търсене в следните именни пространства:',
	'default' => 'по подразбиране',
	'diff' => 'разл',
	'destfilename' => 'Целево име:',
	'duplicatesoffile' => '{{PLURAL:$1|Следният файл се повтаря|Следните $1 файла се повтарят}} с този файл ([[Special:FileDuplicateSearch/$2|повече подробности]]):',
	'download' => 'сваляне',
	'disambiguations' => 'Страници, сочещи към пояснителни страници',
	'disambiguationspage' => 'Template:Пояснение',
	'disambiguations-text' => "Следните страници сочат към '''пояснителна страница''', вместо към истинската тематична страница.<br />Една страница се смята за пояснителна, ако ползва шаблон, към който се препраща от [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Двойни пренасочвания',
	'doubleredirectstext' => 'Тази страница съдържа списък със страници, които пренасочват към друга пренасочваща страница.
Всеки ред съдържа препратки към първото и второто пренасочване, както и целта на второто пренасочване, която обикновено е „истинската“ целева страница, към която първото пренасочване би трябвало да сочи.
<del>Задрасканите</del> записи са коригирани.',
	'double-redirect-fixed-move' => 'Оправяне на двойно пренасочване след преместването на [[$1]] като [[$2]]',
	'double-redirect-fixed-maintenance' => 'Поправяне на двойно пренасочване от [[$1]] към [[$2]].',
	'double-redirect-fixer' => 'Redirect fixer',
	'deadendpages' => 'Задънени страници',
	'deadendpagestext' => 'Следните страници нямат препратки към други страници от {{SITENAME}}.',
	'deletedcontributions' => 'Изтрити приноси на потребител',
	'deletedcontributions-title' => 'Изтрити приноси на потребител',
	'defemailsubject' => 'Писмо от потребител $1 в {{SITENAME}}',
	'deletepage' => 'Изтриване',
	'delete-confirm' => 'Изтриване на „$1“',
	'delete-legend' => 'Изтриване',
	'deletedtext' => 'Страницата „$1“ беше изтрита. Вижте $2 за запис на последните изтривания.',
	'dellogpage' => 'Дневник на изтриванията',
	'dellogpagetext' => 'Списък на последните изтривания.',
	'deletionlog' => 'дневник на изтриванията',
	'deletecomment' => 'Причина:',
	'deleteotherreason' => 'Друга/допълнителна причина:',
	'deletereasonotherlist' => 'Друга причина',
	'deletereason-dropdown' => '*Стандартни причини за изтриване
** По молба на автора
** Нарушение на авторски права
** Вандализъм',
	'delete-edit-reasonlist' => 'Редактиране на причините за изтриване',
	'delete-toobig' => 'Тази страница има голяма редакционна история с над $1 {{PLURAL:$1|версия|версии}}. Изтриването на такива страници е ограничено, за да се предотвратят евентуални поражения на {{SITENAME}}.',
	'delete-warning-toobig' => 'Тази страница има голяма редакционна история с над $1 {{PLURAL:$1|версия|версии}}. Възможно е изтриването да наруши някои операции в базата данни на {{SITENAME}}; необходимо е особено внимание при продължаване на действието.',
	'databasenotlocked' => 'Базата от данни не е заключена.',
	'delete_and_move' => 'Изтриване и преместване',
	'delete_and_move_text' => '== Наложително изтриване ==

Целевата страница „[[:$1]]“ вече съществува. Искате ли да я изтриете, за да освободите място за преместването?',
	'delete_and_move_confirm' => 'Да, искам да изтрия тази страница.',
	'delete_and_move_reason' => 'Изтрита, за да се освободи място за преместване от „[[$1]]“',
	'djvu_page_error' => 'Номерът на DjVu-страницата е извън обхвата',
	'djvu_no_xml' => 'Не е възможно вземането на XML за DjVu-файла',
	'deletedrevision' => 'Изтрита стара версия $1',
	'days' => '{{PLURAL:$1|$1 ден|$1 дни}}',
	'deletedwhileediting' => "'''Внимание''': Страницата е била изтрита, след като сте започнали да я редактирате!",
	'descending_abbrev' => 'низх',
	'duplicate-defaultsort' => 'Внимание: Ключът за сортиране по подразбиране „$2“ отменя по-ранния ключ „$1“.',
	'dberr-header' => 'Това уики има проблем',
	'dberr-problems' => 'Съжаляваме! Сайтът изпитва технически затруднения.',
	'dberr-again' => 'Изчакайте няколко минути и опитайте да презаредите.',
	'dberr-info' => '(Няма достъп до сървъра с базата данни: $1)',
	'dberr-usegoogle' => 'Междувременно опитайте да потърсите в Google.',
	'dberr-outofdate' => 'Имайте предвид, че индексираното от Гугъл наше съдържание може вече да е неактуално.',
	'dberr-cachederror' => 'Следва складирано копие на поисканата страница. Възможно е складираното копие да не е актуално.',
);

$messages['bho'] = array(
	'december' => 'दिसम्बर',
	'december-gen' => 'दिसम्बर',
	'dec' => 'दिस',
	'delete' => 'मिटाईं',
	'deletethispage' => 'ई पन्ना के मिटाईं',
	'disclaimers' => 'अस्विकरण',
	'disclaimerpage' => 'Project:सामान्य अस्विकरण',
	'databaseerror' => 'डेटाबेस त्रुटी',
	'deletedhist' => 'मिटावल इतिहास',
	'difference' => '(संशोधन के बीच अन्तर)',
	'diff-multi' => '({{PLURAL:$1|एगो मध्यम संशोधन|$1 गो मध्यम संशोधन}} नईखे दिखावल)',
	'diff' => 'अन्तर',
);

$messages['bi'] = array(
	'december' => 'Desemba',
	'december-gen' => 'Desemba',
	'dec' => 'Des',
);

$messages['bjn'] = array(
	'december' => 'Disimbir',
	'december-gen' => 'Disimbir',
	'dec' => 'Dis',
	'delete' => 'Hapus',
	'deletethispage' => 'Hapus tungkaran ini',
	'disclaimers' => 'Panyangkalan',
	'disclaimerpage' => 'Project:Panyangkalan umum',
	'databaseerror' => 'Kasalahan Basisdata',
	'dberrortext' => 'Ada kasalahan sintaks pada parmintaan basisdata.
Kasalahan ini pina manandai adanya sabuah bug dalam parangkat lunak.
Parmintaan basisdata yang tadudi adalah:
<blockquote><tt>$1</tt></blockquote>
matan dalam pungsi "<tt>$2</tt>".
Basisdata kasalahan  babulik "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ada kasalahan sintaks pada parmintaan basisdata.
Parmintaan basisdata nang tadudi adalah:
"$1"
matan dalam pungsi "$2".
Basisdata kasalahan  babulik "$3: $4".',
	'directorycreateerror' => 'Kada kawa maulah direktori "$1".',
	'deletedhist' => 'Halam tahapus',
	'difference' => '(Nang balain antar ralatan)',
	'difference-multipage' => '(Nang balain antar tungkaran-tungkaran)',
	'diff-multi' => '({{PLURAL:$1|Asa ralatan tangah|$1 raralatan tangah}} ulih {{PLURAL:$2|asa pamuruk|$2 papamuruk}} kada ditampaiakan)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Asa ralatan tangah|$1 raralatan tangah}} ulih labih pada $2 {{PLURAL:$2|pamuruk|papamuruk}} kada ditampaiakan)',
	'datedefault' => 'Kadada katujuan',
	'defaultns' => 'Atawa-lah manggagai dalam ngaran kakamar nangini:',
	'default' => 'default',
	'diff' => 'bida',
	'destfilename' => 'Ngaranbarakas tujuan:',
	'duplicatesoffile' => 'Barikut {{PLURAL:$1|barakas panggandaan|$1 babarakas panggandaan}} matan barakas ngini ([[Special:FileDuplicateSearch/$2|rarincian labih]]):',
	'download' => 'hunduh',
	'disambiguations' => 'Tutungkaran disambigu',
	'disambiguationspage' => 'Template:Disambigu',
	'disambiguations-text' => "Tutungkaran barikut bataut ka sabuah '''tungkaran disambigu'''.
Tutungkaran ngitu harusnya ka tupik nang sasuai.<br />
Sabuah tungkaran dianggap sawagai tungkaran disambigu amun ngini mamuruk sabuah citakan nang tataut matan [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Paugahan ganda',
	'doubleredirectstext' => 'Tungkaran ngini mandaptar tutungkaran nang maugah ka tutungkaran ugahan lain.
Tiap baris mangandung tautan ka ugahan panambaian wan kadua, sasarannya adalah ugahn kadua, nang biasanya tungkaran sasaran "sabujurnya", nang ugahan partama tuju.
Masukan nang <del>Disilangi</del> sudah dibaiki.',
	'double-redirect-fixed-move' => '[[$1]] sudah dipindahakan.
Ngini wayah ini sudah diugahakan ka [[$2]].',
	'double-redirect-fixed-maintenance' => 'Mambaiki paugahan ganda matan [[$1]] ka [[$2]].',
	'double-redirect-fixer' => 'Ralatan paugahan',
	'deadendpages' => 'Tutungkaran buntu',
	'deadendpagestext' => 'Tutungkaran barikut kada bataut ka tutungkaran lain pada {{SITENAME}}.',
	'deletedcontributions' => 'Hapus sumbangan pamuruk',
	'deletedcontributions-title' => 'Hapus sumbangan pamuruk',
	'defemailsubject' => 'Suril {{SITENAME}} matan pamuruk "$1"',
	'deletepage' => 'Hapus tungkaran',
	'delete-confirm' => 'Hapus "$1"',
	'delete-legend' => 'Hapus',
	'deletedtext' => '"$1" sudah tahapus. Lihati $2 sabuah rakaman gasan nang hanyar ni tahapus.',
	'dellogpage' => 'Log pahapusan',
	'dellogpagetext' => 'Di bawah ngini adalah sabuah daptar matan pahapusan hahanyar ni.',
	'deletionlog' => 'log pahapusan',
	'deletecomment' => 'Alasan:',
	'deleteotherreason' => 'Alasan lain/tambahan:',
	'deletereasonotherlist' => 'Alasan lain',
	'deletereason-dropdown' => '*Alasan awam pahapusan
** Parmintaan panulis
** Parumpakan hak rekap
** Vandalisma',
	'delete-edit-reasonlist' => 'Babak alasan pahapusan',
	'delete-toobig' => 'Tungkaran ngini baisi sabuah halam ganal, labih pada $1 {{PLURAL:$1|ralatan|raralatan}}.
Pahapusan tutungkaran kaini dibatasi hagan mancagah parusakan mandadak di {{SITENAME}}.',
	'delete-warning-toobig' => 'Tungkaran ngini baisi halam babakan ganal, labih pada $1 {{PLURAL:$1|ralatan|raralatan}}.
Mahapus ngini kawa mangaruhi databasis oparasi {{SITENAME}};
jalanakan awan ba-a-awas.',
	'databasenotlocked' => 'Data basis kada basunduk.',
	'delete_and_move' => 'Hapus wan pindahakan',
	'delete_and_move_text' => '==pahapusan diparluakan==
Tungkaran tatuju"[[:$1]]" sadauh tasadia.
Pian handakkah hagan mahapus ngini maulah jalan gasan pamindahan?',
	'delete_and_move_confirm' => "I'ih, hapus tungkaran ngini",
	'delete_and_move_reason' => 'Dihapus hagan maulah jalan gasan pamindahan',
	'djvu_page_error' => 'Tungkaran DJVu di luar jarak',
	'djvu_no_xml' => 'Kada kawa kulihan XML gasan barakas DJVu',
	'deletedrevision' => 'Raralatan lawas tahapus: $1',
	'days' => '{{PLURAL:$1|$1 hari|$1 hahari}}',
	'deletedwhileediting' => "'''Paringatan''': Tungkaran ngini sudah dihapus satalah Pian bamula mambabak!",
	'descending_abbrev' => 'turun',
	'duplicate-defaultsort' => 'Paringatan: Sunduk pangurutan baku "$2" mangabaikan sunduk pangurutan baku "$1" sabalumnya.',
	'dberr-header' => 'Wiki ngini baisi sabuah masalah',
	'dberr-problems' => 'Ampun!
Situs ngini mangalami kangalihan teknik.',
	'dberr-again' => 'Cuba hadangi babarapa manit wan muat-pulang.',
	'dberr-info' => '(Kada kawa tasambung ka server databasis: $1)',
	'dberr-usegoogle' => 'Pian kawa cuba manggagai lung Google wayah samantara ni.',
	'dberr-outofdate' => 'Catat nang sidin indiks matan isi kami pina kawa kadaluarsa.',
	'dberr-cachederror' => 'Ngini adalah sabuah rekap timbuluk tungkaran nang dipinta, wan pinanya kada pahanyarnya.',
);

$messages['bm'] = array(
	'disclaimers' => 'Kangari',
);

$messages['bn'] = array(
	'december' => 'ডিসেম্বর',
	'december-gen' => 'ডিসেম্বর',
	'dec' => 'ডিসেম্বর',
	'delete' => 'অপসারণ',
	'deletethispage' => 'এই পাতাটি মুছে ফেলুন',
	'disclaimers' => 'দাবিত্যাগ',
	'disclaimerpage' => 'Project:সাধারণ দাবিত্যাগ',
	'databaseerror' => 'ডাটাবেস ত্রুটি',
	'dberrortext' => 'ডাটাবেজ কোয়েরি সিন্ট্যাক্সে ত্রুটি ঘটেছে।
সফটওয়্যারে কোন বাগের কারণে এমন হতে পারে।
সর্বশেষ ডাটাবেজ কোয়েরিটি ছিল এরকম:
<blockquote><tt>$1</tt></blockquote>
"<tt>$2</tt>" ফাংশনের ভিতর থেকে।
ডাটাবেজ যে ত্রুটি পাঠিয়েছে: "<tt>$3: $4</tt>"।',
	'dberrortextcl' => 'ডাটাবেজ কোয়েরি সিনট্যাক্স ত্রুটি ঘটেছে।
সর্বশেষ ডাটাবেজ কোয়েরিটি ছিল:
"$1"
"$2" ফাংশনের ভিতর থেকে।
ডাটাবেজ যে ত্রুটি পাঠিয়েছে: "$3: $4"',
	'directorycreateerror' => '"$1" ডাইরেক্টরি তৈরি করা যায়নি।',
	'deletedhist' => 'ইতিহাস মুছে ফেলো',
	'difference' => '(সংস্করণগুলোর মধ্যে পার্থক্য)',
	'difference-multipage' => 'পাতাগুলোর মধ্যে পার্থক্য',
	'diff-multi' => '({{PLURAL:$2|একজন ব্যবহারকারী |$2 জন ব্যবহারকারী}} সম্পাদিত {{PLURAL:$1|একটি অন্তর্বর্তীকালীন সংশোধন|$1টি অন্তর্বর্তীকালীন সংশোধন}} দেখানো হয়নি।)',
	'datedefault' => 'কোন পছন্দ নেই',
	'defaultns' => 'নতুবা এই নামস্থানগুলিতে অনুসন্ধান করো:',
	'default' => 'আদি অবস্থা',
	'diff' => 'পরিবর্তন',
	'destfilename' => 'লক্ষ্য ফাইলের নাম:',
	'download' => 'ডাউনলোড',
	'disambiguations' => 'দ্ব্যর্থতা-দূরীকরণ পাতাসমূহ',
	'disambiguationspage' => 'Template:দ্ব্যর্থতা_নিরসন',
	'disambiguations-text' => "নিচের পাতাগুলি থেকে একটি '''দ্ব্যর্থতা নিরসন পাতা'''-তে সংযোগ আছে। এর পরিবর্তে এগুলি থেকে একটি উপযুক্ত বিষয়ে সংযোগ থাকা আবশ্যক।<br />যদি কোন পাতায় এমন কোন টেমপ্লেট থাকে যেটিতে [[MediaWiki:Disambiguationspage]] থেকে সংযোগ আছে, তবে সেই পাতাটিকে একটি দ্ব্যর্থতা নিরসন পাতা হিসেবে গণ্য করা হয়।",
	'doubleredirects' => 'দুইবার করা পুনর্নির্দেশনাগুলি',
	'doubleredirectstext' => 'এই পাতায় এমন পাতাগুলোর তালিকা আছে, যেগুলো অন্য কোন পুনর্নির্দেশনা পাতায় পুনর্নির্দেশিত হয়েছে। প্রতিটি সারিতে প্রথম ও দ্বিতীয় পুনর্নির্দেশনার জন্য সংযোগ আছে এবং দ্বিতীয় পুনর্নির্দেশনাটির লক্ষ্য সংযোগটিও দেওয়া আছে। এই লক্ষ্য সংযোগটিই সাধারণত "আসল" লক্ষ্য পাতা, যেটিতে প্রথম পুনর্নির্দেশনাটি থেকে সংযোগ থাকা উচিত।
<del>কেটে দেওয়া</del> ভুক্তিগুলো ঠিক করা হয়েছে।',
	'double-redirect-fixed-move' => '[[$1]] সরিয়ে নেওয়া হয়েছে।
এটি এখন [[$2]] এ পুনঃনির্দেশিত হয়েছে।',
	'double-redirect-fixer' => 'পুনঃনির্দেশনা মেরামতকারী',
	'deadendpages' => 'যেসব পাতা থেকে কোনো সংযোগ নেই',
	'deadendpagestext' => 'নিচের পাতাগুলি থেকে {{SITENAME}}-এর অন্য কোন পাতায় সংযোগ নেই।',
	'deletedcontributions' => 'মুছে ফেলা ব্যবহারকারী অবদান',
	'deletedcontributions-title' => 'মুছে ফেলা ব্যবহারকারী অবদান',
	'defemailsubject' => '{{SITENAME}} ব্যবহারকারী "$1" প্রেরিত ইমেইল',
	'deletepage' => 'পাতাটি মুছে ফেলা হোক',
	'delete-confirm' => '"$1" অপসারণ',
	'delete-legend' => 'অপসারণ',
	'deletedtext' => '"$1" মুছে ফেলা হয়েছে। সাম্প্রতিক মুছে ফেলার ঘটনাগুলো $2-এ দেখুন।',
	'dellogpage' => 'পাতা অবলুপ্তি লগ',
	'dellogpagetext' => 'নিচে সবচেয়ে সাম্প্রতিক অবলুপ্তিগুলোর একাটি তালিকা দেওয়া হল।',
	'deletionlog' => 'পাতা অবলুপ্তি লগ',
	'deletecomment' => 'কারণ:',
	'deleteotherreason' => 'অন্য/অতিরিক্ত কারণ:',
	'deletereasonotherlist' => 'অন্য কারণ',
	'deletereason-dropdown' => '*মুছে ফেলার সাধারণ কারণগুলি
** লেখকের অনুরোধ
** কপিরাইট ভঙ্গ
** ধ্বংসপ্রবণতা',
	'delete-edit-reasonlist' => 'অপসারণের কারণ সম্পাদনা',
	'delete-toobig' => 'এই পাতার সম্পাদনার ইতিহাস অনেক বড়, যা $1টি {{PLURAL:$1|সংস্করণের|সংস্করণের}} বেশি।
{{SITENAME}}-এর দূর্ঘটনাজনিত সমস্যা এড়াতে এই ধরনের পাতা মুছার ব্যপারে সীমাবদ্ধতা আরোপিত হয়েছে।',
	'delete-warning-toobig' => 'এই পাতাটির একটি বৃহৎ সম্পাদনা ইতিহাস রয়েছে, যা $1 {{PLURAL:$1|সংস্করণেরও|সংস্করণেরও}} বেশি।
এই পাতাটি মুছে ফেললে তা {{SITENAME}} সাইটের ডেটাবেজ সমস্যার কারণ হতে পারে;
সাবধানতার সাথে এগিয়ে যান।',
	'databasenotlocked' => 'ডাটাবেজ বন্ধ নয়।',
	'delete_and_move' => 'মুছে ফেলা হোক ও সরানো হোক',
	'delete_and_move_text' => '==মুছে ফেলা আবশ্যক==

"[[:$1]]" শিরোনামের গন্তব্য পাতাটি ইতিমধ্যেই বিদ্যমান। আপনি কি স্থানান্তর সফল করার জন্য পাতাটি মুছে দিতে চান?',
	'delete_and_move_confirm' => 'হ্যাঁ, পাতাটি মুছে ফেলা হোক',
	'delete_and_move_reason' => '"[[$1]]" থেকে স্থানান্তরের স্বার্থে মুছে ফেলা হয়েছে',
	'djvu_page_error' => 'DjVu পাতা সীমার বাইরে',
	'djvu_no_xml' => 'DjVu ফাইলের জন্য XML আনতে পারা যায়নি।',
	'deletedrevision' => 'মুছে ফেলা পুরাতন সংশোধন $1',
	'days' => '{{PLURAL:$1|$1 দিন|$1 দিন}}',
	'deletedwhileediting' => "'''সতর্কীকরণ''': আপনি পাতাটি সম্পাদনা শুরু করার পরে তা মুছে ফেলা হয়েছে!",
	'descending_abbrev' => 'অবতরণ',
	'duplicate-defaultsort' => '\' \' \' সাবধান: \' \' \'  ডিফল্ট সাজানোর কীঃ "$2" পূর্বে ডিফল্ট সাজানোর কীঃ "$1" কে অগ্রাহ্য করে।',
	'dberr-header' => 'এই উইকিতে কোন সমস্যা রয়েছে',
	'dberr-problems' => 'দুঃখিত!
এই সাইটটি বর্তমানে কারীগরী অসুবিধার মুখোমুখি হয়েছে।',
	'dberr-again' => 'কয়েক মিনিট পর পুনরায় পরিদর্শনের চেষ্টা করুন।',
	'dberr-info' => '(ডেটাবেজ সার্ভার $1-এর সাথে যোগাযোগ করা সম্ভব হয়নি)',
	'dberr-usegoogle' => 'এই পরিস্থিতিতে আপনি গুগলের মাধ্যমে অনুসন্ধান করার চেষ্টা করতে পারেন।',
	'dberr-outofdate' => 'খেয়াল করুন যে, আমাদের বিষয়বস্তু সম্পর্কিত তাদের সূচি মেয়াদ উত্তীর্ণ হতে পারে।',
	'dberr-cachederror' => 'এটি অনুরোধকৃত পাতার ক্যাশে লিপি, যা হালনাগাতকৃত নাও হতে পারে।',
);

$messages['bo'] = array(
	'december' => 'ཟླ་བཅུ་གཉིས་པ།',
	'december-gen' => 'ཟླ་བཅུ་གཉིས་པ།',
	'dec' => 'ཟླ་བཅུ་གཉིས་པ།',
	'delete' => 'སུབས།',
	'deletethispage' => 'ཤོག་ངོས་འདི་འདོར་བ།',
	'disclaimers' => 'དགག་བྱ།',
	'disclaimerpage' => 'Project:སྤྱིའི་དགག་བྱ།',
	'diff' => 'མི་འདྲ་ས།',
	'download' => 'ཕབ་ལེན།',
	'deletepage' => 'ཤོག་ངོས་འདོར་བ།',
	'delete-confirm' => '"$1"སུབས་ཤིག',
	'delete-legend' => 'སུབས་ཤིག',
	'dellogpage' => 'རྩོམ་ཡིག་སུབ་དོར།',
	'deletecomment' => 'རྒྱུ་མཚན།',
	'deleteotherreason' => 'རྒྱུ་མཚན་གཞན་པའམ་འཕར་མ།',
	'deletereasonotherlist' => 'རྒྱུ་མཚན་གཞན།',
);

$messages['bpy'] = array(
	'december' => 'ডিসেম্বর',
	'december-gen' => 'ডিসেম্বর',
	'dec' => 'ডিসে',
	'delete' => 'পুসানি',
	'deletethispage' => 'পাতা এহান পুসে বেলিক',
	'disclaimers' => 'দাবি বেলানি',
	'disclaimerpage' => 'Project:ইজ্জু দাবি বেলানি',
	'databaseerror' => 'ডাটাবেসর লাল',
	'dberrortext' => 'ডাটাবেজ কোয়েরি সিন্ট্যাক্সর মা লালুইসে।
সফটওয়্যারে কোন বাগর কা এহান ইতে পারে।
লমিলগা ডাটাবেজ কোয়েরিহান এসারে আসিল:
<blockquote><tt>$1</tt></blockquote>
"<tt>$2</tt>" ফাংশনর ভিতরেত্ত।
ডাটাবেজ লাল হান দিল: "<tt>$3: $4</tt>"।',
	'dberrortextcl' => 'ডাটাবেজ কোয়েরি সিন্ট্যাক্সর মা লালুইসে।
লমিলগা ডাটাবেজ কোয়েরিহান এসারে আসিল:
"$1"
"$2" ফাংশনর ভিতরেত্ত।
ডাটাবেজ লাল হান দিল: "$3: $4"।',
	'directorycreateerror' => '"$1" ডাইরেক্টরিহান হঙকরানি নাইল।',
	'deletedhist' => 'ইতিহাসহান পুস',
	'difference' => '(রিভিসনহানির ফারাকহান)',
	'diff-multi' => '({{PLURAL:$1|হমবুকর রিভিসন আহান|$1 হমবুকর রিভিসন হানি}} দেহাদেনা এহাত না মিহিসে।)',
	'datedefault' => 'পছন করাতা নেই',
	'defaultns' => 'নাইলে এরে নাঙর লামে বিসারা:',
	'default' => 'আদি অঙতা',
	'diff' => 'ফারাক',
	'download' => 'ডাউনলোড',
	'disambiguations' => 'সন্দই চুমকরের পাতাহানি',
	'doubleredirects' => 'আলথকে যানা দ্বিমাউ মাতের',
	'deadendpages' => 'যে পাতাহানিত্ত কোন মিলাপ নেই',
	'defemailsubject' => '{{SITENAME}} ই-মেইল',
	'deletepage' => 'পাতাহান পুস',
	'deletedtext' => '"$1" পুসানি অইল।
চা $2 এহার বারে আগে আসে পুসানির লাতংগ।',
	'dellogpage' => 'পুসিসিতার লাতংগ',
	'deletecomment' => 'কারণ:',
	'deleteotherreason' => 'আরাক/উপরি কারন:',
	'deletereasonotherlist' => 'আর আর কারন',
	'delete_and_move' => 'পুসানি বারো থেইকরানি',
	'delete_and_move_confirm' => 'হায়, পাতা এহান পুস',
	'descending_abbrev' => 'লামানি',
	'dberr-header' => 'উইকি এহানাত সমস্যা ইসে',
	'dberr-problems' => 'ঙাক্করে দিবাঙ! সাইট এহানাত টেকনিক্যাল সমস্যা ইসে।',
	'dberr-again' => 'রিলোড আনার কা ডান্ড আহান বাসা।',
	'dberr-info' => '(ডাটা সার্ভারর লগে যোগাযোগ নেয়সে: $1)',
	'dberr-usegoogle' => 'হের অহাত তি গুগুলসে বিসারা পারর।',
	'dberr-outofdate' => 'সুচীক্রম অহান আপটুডেট নাইসে।',
	'dberr-cachederror' => 'এহান ক্যাস পাতাহানে, অহানে আপটুডেট না থাইব।',
);

$messages['bqi'] = array(
	'december' => 'دسامبر',
	'december-gen' => 'دسامبر',
	'dec' => 'دسامبر',
	'delete' => 'حذف',
	'disclaimers' => 'انکار کننده ها',
	'disclaimerpage' => 'Project:انکار کاربران',
	'difference' => '(تفاوت بین نسخه ها)',
	'diff-multi' => '({{PLURAL:$1|یه اصلاح میانی|$1 اصلاحات میانی}} نشو داده نوابیده.)',
	'diff' => 'تفاوت',
	'disambiguations' => 'صفحات رفع ابهام',
	'doubleredirects' => 'تغییر مسیر دوبله',
	'deadendpages' => 'صفحات بن بست ولاینحل',
	'deletepage' => 'حذف صفحه',
	'deletedtext' => '"$1" حذف وابیده.
بوین $2 سی ثبت حذف آخر.',
	'dellogpage' => 'نمایه _ حذف',
	'deletecomment' => 'دلیل:',
	'deleteotherreason' => 'دیه/دلیل اضافی:',
	'deletereasonotherlist' => 'دلیل دیه',
);

$messages['br'] = array(
	'december' => 'Kerzu',
	'december-gen' => 'Kerzu',
	'dec' => 'Kzu',
	'delete' => 'Diverkañ',
	'deletethispage' => 'Diverkañ ar bajenn-mañ',
	'disclaimers' => 'Kemennoù',
	'disclaimerpage' => 'Project:Kemenn hollek',
	'databaseerror' => 'Fazi bank roadennoù',
	'dberrortext' => 'C\'hoarvezet ez eus ur fazi ereadur eus ar reked er bank roadennoù, ar pezh a c\'hall talvezout ez eus un draen er meziant.
Setu ar goulenn bet pledet gantañ da ziwezhañ :
<blockquote><tt>$1</tt></blockquote>
adal an arc\'hwel "<tt>$2</tt>".
Adkaset eo bet ar fazi "<tt>$3: $4</tt>" gant ar bank roadennoù.',
	'dberrortextcl' => 'Ur fazi ereadur zo en ur reked savet ouzh ar bank roadennoù.
Setu ar goulenn bet pledet gantañ da ziwezhañ :
"$1"
adal an arc\'hwel "$2"
Adkaset eo bet ar fazi "$3 : $4" gant ar bank roadennoù.',
	'directorycreateerror' => 'N\'eus ket bet gallet krouiñ kavlec\'h "$1".',
	'deletedhist' => 'Diverkañ an istor',
	'difference' => "(Diforc'hioù etre ar stummoù)",
	'difference-multipage' => "(diforc'h etre ar pajennoù)",
	'diff-multi' => "({{PLURAL:$1|Ur reizhadenn da c'hortoz|$1 reizhadenn da c'hortoz}} gant {{PLURAL:$2|un implijer|$2 implijer}} kuzhet.)",
	'diff-multi-manyusers' => "({{PLURAL:$1|Ur reizhadenn da c'hortoz|$1 reizhadenn da c'hortoz}} gant muioc'h eget $2 {{PLURAL:$2|implijer|implijer}} kuzhet.)",
	'datedefault' => 'Dre ziouer',
	'defaultns' => 'Klask en esaouennoù-anv a-hend-all :',
	'default' => 'dre ziouer',
	'diff' => "diforc'h",
	'destfilename' => 'Anv ma vo enrollet ar restr :',
	'duplicatesoffile' => "Un eil eus ar restr-mañ eo {{PLURAL:$1|ar restr da-heul|ar restroù da-heul}}, ([[Special:FileDuplicateSearch/$2|evit gouzout hiroc'h]]) :",
	'download' => 'pellgargañ',
	'disambiguations' => 'Pajennoù enno liammoù war-zu pajennoù disheñvelout',
	'disambiguationspage' => 'Template:Disheñvelout',
	'disambiguations-text' => "Liammet eo ar pajennoù da-heul ouzh ur '''bajenn disheñvelout'''.
Padal e tlefent kas war-eeun d'an danvez anezho.<br />
Sellet e vez ouzh ur bajenn evel ouzh ur bajenn disheñvelout ma ra gant ur patrom liammet ouzh [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Adkasoù doubl',
	'doubleredirectstext' => 'Rollañ a ra ar bajenn-mañ ar pajennoù a adkas da bajennoù adkas all.
War bep linenn ez eus liammoù war-du pajennoù an adkas kentañ hag en eil adkas, hag ivez war-du pajenn-dal an eil adkas zo sañset bezañ ar pal "gwirion" a zlefe an adkas kentañ kas di.
Diskoulmet eo bet an enmontoù <del>barrennet</del>.',
	'double-redirect-fixed-move' => 'Adanvet eo bet [[$1]], adkaset eo war-du [[$2]] bremañ',
	'double-redirect-fixed-maintenance' => 'O reizhañ an adkas doubl adalek [[$1]] war-zu [[$2]].',
	'double-redirect-fixer' => 'Reizher adkasoù',
	'deadendpages' => 'Pajennoù dall (hep liamm diabarzh)',
	'deadendpagestext' => "Ar pajennoù da-heul n'int ket liammet ouzh pajenn ebet all eus {{SITENAME}}.",
	'deletedcontributions' => 'Degasadennoù diverket un implijer',
	'deletedcontributions-title' => 'Degasadennoù diverket un implijer',
	'defemailsubject' => 'Postel kaset eus {{SITENAME}} gant an implijer "$1"',
	'deletepage' => 'Diverkañ ur bajenn',
	'delete-confirm' => 'Diverkañ "$1"',
	'delete-legend' => 'Diverkañ',
	'deletedtext' => '"Diverket eo bet $1".
Sellet ouzh $2 evit roll an diverkadennoù diwezhañ.',
	'dellogpage' => 'Roll ar pajennoù diverket',
	'dellogpagetext' => 'Setu roll ar pajennnoù diwezhañ bet diverket.',
	'deletionlog' => 'roll an diverkadennoù',
	'deletecomment' => 'Abeg :',
	'deleteotherreason' => 'Abegoù/traoù all :',
	'deletereasonotherlist' => 'Abeg all',
	'deletereason-dropdown' => "*Abegoù diverkañ boazetañ
** Goulenn gant saver ar pennad
** Gaou ouzh ar gwirioù perc'hennañ
** Vandalerezh",
	'delete-edit-reasonlist' => 'Kemmañ a ra an abegoù diverkañ',
	'delete-toobig' => 'Bras eo istor ar bajenn-mañ, ouzhpenn $1 {{PLURAL:$1|stumm|stumm}} zo. Bevennet eo bet an diverkañ pajennoù a-seurt-se kuit da zegas reuz war {{SITENAME}} dre fazi .',
	'delete-warning-toobig' => "Bras eo istor ar bajenn-mañ, ouzhpenn {{PLURAL:$1|stumm|stumm}} zo.
Diverkañ anezhi a c'hallo degas reuz war mont en-dro diaz titouroù {{SITENAME}};
taolit evezh bras.",
	'databasenotlocked' => "N'eo ket prennet an diaz roadennoù.",
	'delete_and_move' => 'Diverkañ ha sevel adkas',
	'delete_and_move_text' => "==Ezhomm diverkañ==

Savet eo ar pennad tal \"[[:\$1]]\" c'hoazh.
Diverkañ anezhañ a fell deoc'h ober evit reiñ lec'h d'an adkas ?",
	'delete_and_move_confirm' => 'Ya, diverkañ ar bajenn',
	'delete_and_move_reason' => 'Diverket evit ober lec\'h d\'an adkas "[[$1]]"',
	'djvu_page_error' => 'Pajenn DjVu er-maez ar bevennoù',
	'djvu_no_xml' => 'Dibosupl da dapout an XML evit ar restr DjVu',
	'deletedrevision' => 'Diverket stumm kozh $1.',
	'days' => '{{PLURAL:$1|$1 deiz|$1 deiz}}',
	'deletedwhileediting' => "'''Diwallit''' : Diverket eo bet ar bajenn-mañ bremañ ha krog e oac'h da zegas kemmoù enni!",
	'descending_abbrev' => 'diskenn',
	'duplicate-defaultsort' => 'Diwallit : Frikañ a ra an alc\'hwez dre ziouer "$2" an hini a oa a-raok "$1".',
	'dberr-header' => 'Ur gudenn zo gant ar wiki-mañ',
	'dberr-problems' => "Ho tigarez ! Kudennoù teknikel zo gant al lec'hienn-mañ.",
	'dberr-again' => 'Gortozit un nebeud munutennoù a-raok adkargañ.',
	'dberr-info' => '(Dibosupl kevreañ ouzh servijer an diaz roadennoù: $1)',
	'dberr-usegoogle' => "E-keit-se esaeit klask dre c'hGoogle.",
	'dberr-outofdate' => "Notit mat e c'hall o menegerioù dezho bezañ dispredet e-keñver ar boued zo ganeomp.",
	'dberr-cachederror' => 'Un eilstumm memoret eus ar bajenn goulennet eo hemañ, gallout a ra bezañ dispredet.',
);

$messages['brh'] = array(
	'december' => 'Dasumbar',
	'december-gen' => 'Dasumbar',
	'dec' => 'Dasumbar',
	'delete' => 'Mesa',
	'disclaimers' => 'Dazkaşşík',
	'disclaimerpage' => 'Project:Las dazkaşşí',
	'difference' => '(Badal droşum teŧí fark)',
	'diff' => 'fark',
	'deletepage' => 'Panna e mesa',
	'deletedtext' => '"$1" mesingáne.
Zút áteaŧ mesing átá lekav kin $2 e ur.',
	'dellogpage' => 'Mesing ná hisáb',
	'deletecomment' => 'Dalíl:',
	'deleteotherreason' => 'Elo/pen dalíl:',
	'deletereasonotherlist' => 'Elo dalíl',
);

$messages['bs'] = array(
	'december' => 'decembar',
	'december-gen' => 'decembra',
	'dec' => 'dec',
	'delete' => 'Obriši',
	'deletethispage' => 'Obriši ovu stranicu',
	'disclaimers' => 'Odricanje odgovornosti',
	'disclaimerpage' => 'Project:Uslovi korištenja, pravne napomene i odricanje odgovornosti',
	'databaseerror' => 'Greška u bazi',
	'dberrortext' => 'Desila se sintaksna greška upita baze.
Ovo se desilo zbog moguće greške u softveru.
Posljednji pokušani upit je bio: <blockquote><tt>$1</tt></blockquote> iz funkcije "<tt>$2</tt>".
Baza podataka je vratila grešku "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Desila se sintaksna greška upita baze.
Posljednji pokušani upit je bio:
"$1"
iz funkcije "$2".
Baza podataka je vratila grešku "$3: $4".',
	'directorycreateerror' => 'Nije moguće napraviti direktorijum "$1".',
	'deletedhist' => 'Izbrisana historija',
	'difference' => '(Razlika između revizija)',
	'difference-multipage' => '(Razlika između stranica)',
	'diff-multi' => '({{plural:$1|Nije prikazana jedna međurevizija|Nisu prikazane $1 međurevizije|Nije prikazano $1 međurevizija}} od {{PLURAL:$2|jednog korisnika|$2 korisnika}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Jedna međurevizija|$1 međurevizije|$1 međurevizija}} od više od $2 {{PLURAL:$2|korisnika|korisnika}} {{PLURAL:$1|nije prikazana|nisu prikazane}})',
	'datedefault' => 'Nije bitno',
	'defaultns' => 'Inače tražite u ovim imenskim prostorima:',
	'default' => 'standardno',
	'diff' => 'razl',
	'destfilename' => 'Ime odredišne datoteke:',
	'duplicatesoffile' => '{{PLURAL:$1|Slijedeća datoteka je dvojnik|Slijedeće $1 datoteke su dvojnici}} ove datoteke ([[Special:FileDuplicateSearch/$2|detaljnije]]):',
	'download' => 'učitaj',
	'disambiguations' => 'Stranice za čvor članke',
	'disambiguationspage' => '{{ns:template}}:Čvor',
	'disambiguations-text' => "Slijedeće stranice su povezane sa '''čvor stranicom'''.
Po pravilu, one se trebaju povezati sa konkretnim člankom.<br />
Stranica se smatra čvorom, ukoliko koristi šablon koji je povezan sa spiskom [[MediaWiki:Disambiguationspage|čvor stranica]]",
	'doubleredirects' => 'Dvostruka preusmjerenja',
	'doubleredirectstext' => 'Ova stranica prikazuje stranice koje preusmjeravaju na druga preusmjerenja.
Svaki red sadrži veze na prvo i drugo preusmjerenje, kao i na prvu liniju teksta drugog preusmjerenja, što obično daje "pravi" ciljni članak, na koji bi prvo preusmjerenje i trebalo da pokazuje.
<del>Precrtane</del> stavke su riješene.',
	'double-redirect-fixed-move' => '[[$1]] je premješten, sada je preusmjerenje na [[$2]]',
	'double-redirect-fixed-maintenance' => 'Ispravljanje dvostrukih preusmjerenja sa [[$1]] na [[$2]].',
	'double-redirect-fixer' => 'Popravljač preusmjerenja',
	'deadendpages' => 'Stranice bez internih veza',
	'deadendpagestext' => 'Slijedeće stranice nisu povezane s drugim stranicama na {{SITENAME}}.',
	'deletedcontributions' => 'Obrisani doprinosi korisnika',
	'deletedcontributions-title' => 'Obrisani doprinosi korisnika',
	'defemailsubject' => '{{SITENAME}} e-pošta',
	'deletepage' => 'Obrišite stranicu',
	'delete-confirm' => 'Brisanje "$1"',
	'delete-legend' => 'Obriši',
	'deletedtext' => 'Članak "$1" je obrisan.
Pogledajte $2 za zapis o skorašnjim brisanjima.',
	'dellogpage' => 'Protokol brisanja',
	'dellogpagetext' => 'Ispod je spisak najskorijih brisanja.',
	'deletionlog' => 'zapis brisanja',
	'deletecomment' => 'Razlog:',
	'deleteotherreason' => 'Ostali/dodatni razlozi:',
	'deletereasonotherlist' => 'Ostali razlozi',
	'deletereason-dropdown' => '*Uobičajeni razlozi brisanja
** Zahtjev autora
** Kršenje autorskih prava
** Vandalizam',
	'delete-edit-reasonlist' => 'Uredi razloge brisanja',
	'delete-toobig' => 'Ova stranica ima veliku historiju promjena, preko $1 {{PLURAL:$1|revizije|revizija}}.
Brisanje takvih stranica nije dopušteno da bi se spriječilo slučajno preopterećenje servera na kojem je {{SITENAME}}.',
	'delete-warning-toobig' => 'Ova stranica ima veliku historiju izmjena, preko $1 {{PLURAL:$1|izmjene|izmjena}}.
Njeno brisanje može dovesti do opterećenja operacione baze na {{SITENAME}};
nastavite s oprezom.',
	'databasenotlocked' => 'Baza podataka nije zaključana.',
	'delete_and_move' => 'Brisanje i premještanje',
	'delete_and_move_text' => '==Brisanje neophodno==
Odredišna stranica "[[:$1]]" već postoji.
Da li je želite obrisati kako bi ste mogli izvršiti premještanje?',
	'delete_and_move_confirm' => 'Da, obriši stranicu',
	'delete_and_move_reason' => 'Obrisano da bi se napravio prostor za premještanje',
	'djvu_page_error' => 'DjVu stranica je van opsega',
	'djvu_no_xml' => 'Za XML-datoteku se ne može pozvati DjVu datoteka',
	'deletedrevision' => 'Obrisana stara revizija $1',
	'days' => '{{PLURAL:$1|$1 dan|$1 dana|$1 dana}}',
	'deletedwhileediting' => "'''Upozorenje''': Ova stranica je obrisana prije nego što ste počeli uređivati!",
	'descending_abbrev' => 'opad',
	'duplicate-defaultsort' => 'Upozorenje: Postavljeni ključ sortiranja "$2" zamjenjuje raniji ključ "$1".',
	'dberr-header' => 'Ovaj wiki ima problem',
	'dberr-problems' => 'Žao nam je! Ova stranica ima određene tehničke poteškoće.',
	'dberr-again' => 'Pokušajte pričekati par minuta i zatim osvježiti.',
	'dberr-info' => '(ne može se spojiti server baze podataka: $1)',
	'dberr-usegoogle' => 'U međuvremenu, možete pokušati pretraživanje putem Google.',
	'dberr-outofdate' => 'Zapamtite da njihovi indeksi našeg sadržaja ne moraju uvijek biti ažurni.',
	'dberr-cachederror' => 'Slijedeći tekst je keširana kopija zahtjevane stranice i možda nije potpuno ažurirana.',
);

$messages['bug'] = array(
	'december' => 'Désémber',
	'december-gen' => 'Désémber',
	'delete' => 'Peddé',
	'deletethispage' => 'Peddé iyé leppa',
	'disclaimers' => 'Diseklaima',
	'databaseerror' => 'Éro databése',
	'diff' => 'beda',
	'download' => 'unduh',
	'dellogpage' => 'Log peddé-peddé',
	'delete_and_move' => 'Peddé nappa paleccé',
	'delete_and_move_text' => '==Mapeddé riperelu==
Leppa destinasi "[[:$1]]" purani eŋka.
Eloko peddéï supaya weddiŋi mapalecé?',
	'delete_and_move_confirm' => "Iyé', peddé iyaro leppa",
	'delete_and_move_reason' => 'Ripeddé supaya weddiŋi mapalecé',
	'descending_abbrev' => 'no',
);

$messages['ca'] = array(
	'december' => 'desembre',
	'december-gen' => 'de desembre',
	'dec' => 'des',
	'delete' => 'Elimina',
	'deletethispage' => 'Elimina la pàgina',
	'disclaimers' => 'Avís general',
	'disclaimerpage' => 'Project:Avís general',
	'databaseerror' => "S'ha produït un error en la base de dades",
	'dberrortext' => "S'ha produït un error de sintaxi en una consulta a la base de dades.
Açò podria indicar un error en el programari.
La darrera consulta que s'ha intentat fer ha estat:
<blockquote><tt>$1</tt></blockquote>
des de la funció «<tt>$2</tt>».
L'error de retorn ha estat «<tt>$3: $4</tt>».",
	'dberrortextcl' => "S'ha produït un error de sintaxi en una consulta a la base de dades.
La darrera consulta que s'ha intentat fer ha estat:
<blockquote><tt>$1</tt></blockquote>
des de la funció «<tt>$2</tt>».
L'error de retorn ha estat «<tt>$3: $4</tt>».",
	'directorycreateerror' => "No s'ha pogut crear el directori «$1».",
	'deletedhist' => "Historial d'esborrat",
	'difference' => '(Diferència entre revisions)',
	'difference-multipage' => '(Diferència entre pàgines)',
	'diff-multi' => '({{PLURAL:$1|Hi ha una revisió intermèdia |Hi ha $1 revisions intermèdies}} sense mostrar fetes per {{PLURAL:$2|un usuari|$2 usuaris}})',
	'diff-multi-manyusers' => "({{PLURAL:$1|Hi ha una revisió intermèdia|Hi ha $1 revisions intermèdies}} sense mostrar fetes per més {{PLURAL:$2|d'un usuari|de $2 usuaris}})",
	'datedefault' => 'Cap preferència',
	'defaultns' => 'Cerca per defecte en els següents espais de noms:',
	'default' => 'per defecte',
	'diff' => 'dif',
	'destfilename' => 'Nom del fitxer de destinació:',
	'duplicatesoffile' => "{{PLURAL:$1|Aquest fitxer és un duplicat del que apareix a continuació|A continuació s'indiquen els $1 duplicats d'aquest fitxer}} ([[Special:FileDuplicateSearch/$2|vegeu-ne més detalls]]):",
	'download' => 'baixada',
	'disambiguations' => 'Pàgines que enllacen a pàgines de desambiguació',
	'disambiguationspage' => 'Template:Desambiguació',
	'disambiguations-text' => "Les següents pàgines enllacen a una '''pàgina de desambiguació'''.
Per això, caldria que enllacessin al tema apropiat.<br />
Una pàgina es tracta com de desambiguació si utilitza una plantilla que està enllaçada a [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Redireccions dobles',
	'doubleredirectstext' => 'Aquesta pàgina llista les pàgines que redirigeixen a altres pàgines de redirecció.
Cada fila conté enllaços a la primera i segona redireccions, així com el destí de la segona redirecció, què generalment és la pàgina destí "real", a la què hauria d\'apuntar la primera redirecció.
Les entrades <del>ratllades</del> s\'han resolt.',
	'double-redirect-fixed-move' => "S'ha reanomenat [[$1]], ara és una redirecció a [[$2]]",
	'double-redirect-fixed-maintenance' => "S'ha arreglat la redirecció doble [[$1]] - [[$2]].",
	'double-redirect-fixer' => 'Supressor de dobles redireccions',
	'deadendpages' => 'Pàgines atzucac',
	'deadendpagestext' => "Aquestes pàgines no tenen enllaços a d'altres pàgines del projecte {{SITENAME}}.",
	'deletedcontributions' => 'Contribucions esborrades',
	'deletedcontributions-title' => 'Contribucions esborrades',
	'defemailsubject' => 'Correu electrònic de l\'usuari "$1" de {{SITENAME}}',
	'deletepage' => 'Elimina la pàgina',
	'delete-confirm' => 'Elimina «$1»',
	'delete-legend' => 'Elimina',
	'deletedtext' => '«$1» ha estat esborrat.
Vegeu $2 per a un registre dels esborrats més recents.',
	'dellogpage' => "Registre d'eliminació",
	'dellogpagetext' => 'Davall hi ha una llista dels esborraments més recents.',
	'deletionlog' => "Registre d'esborrats",
	'deletecomment' => 'Motiu:',
	'deleteotherreason' => 'Motius diferents o addicionals:',
	'deletereasonotherlist' => 'Altres motius',
	'deletereason-dropdown' => "*Motius freqüents d'esborrat
** Demanada per l'autor
** Violació del copyright
** Vandalisme",
	'delete-edit-reasonlist' => "Edita els motius d'eliminació",
	'delete-toobig' => "Aquesta pàgina té un historial d'edicions molt gran, amb més de $1 {{PLURAL:$1|canvi|canvis}}. L'eliminació d'aquestes pàgines està restringida per a prevenir que hi pugui haver un desajustament seriós de la base de dades de tot el projecte {{SITENAME}} per accident.",
	'delete-warning-toobig' => "Aquesta pàgina té un historial d'edicions molt gran, amb més de $1 {{PLURAL:$1|canvi|canvis}}. Eliminar-la podria suposar un seriós desajustament de la base de dades de tot el projecte {{SITENAME}}; aneu en compte abans dur a terme l'acció.",
	'databasenotlocked' => 'La base de dades no està bloquejada.',
	'delete_and_move' => 'Elimina i trasllada',
	'delete_and_move_text' => "==Cal l'eliminació==

La pàgina de destinació, «[[:$1]]», ja existeix. Voleu eliminar-la per a fer lloc al trasllat?",
	'delete_and_move_confirm' => 'Sí, esborra la pàgina',
	'delete_and_move_reason' => 'Suprimit per donar pas a pas de " [[$1]] "',
	'djvu_page_error' => "La pàgina DjVu està fora de l'abast",
	'djvu_no_xml' => "No s'ha pogut recollir l'XML per al fitxer DjVu",
	'deletedrevision' => "S'ha eliminat la revisió antiga $1.",
	'days' => '{{PLURAL:$1|$1 dia|$1 dies}}',
	'deletedwhileediting' => "'''Avís''': S'ha eliminat aquesta pàgina després que haguéssiu començat a modificar-la!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => 'Atenció: La clau d\'ordenació per defecte "$2" invalida l\'anterior clau "$1".',
	'dberr-header' => 'Aquest wiki té un problema',
	'dberr-problems' => 'Ho sentim. Aquest lloc web està experimentant dificultats tècniques.',
	'dberr-again' => 'Intenteu esperar uns minuts i tornar a carregar.',
	'dberr-info' => '(No es pot contactar amb el servidor de dades: $1)',
	'dberr-usegoogle' => 'Podeu intentar fer la cerca via Google mentrestant.',
	'dberr-outofdate' => 'Tingueu en compte que la seva indexació del nostre contingut pot no estar actualitzada.',
	'dberr-cachederror' => 'A continuació hi ha una còpia emmagatzemada de la pàgina demanada, que pot no estar actualitzada.',
	'discuss' => 'Discussió',
);

$messages['cbk-zam'] = array(
	'december' => 'Diciembre',
	'december-gen' => 'Diciembre',
	'dec' => 'Dic',
	'delete' => 'Bora',
	'disclaimers' => 'Maga aviso legal',
	'disclaimerpage' => 'Project:El maga limitacion general de maga responsabilidad',
);

$messages['cdo'] = array(
	'december' => 'Sĕk-nê nguŏk',
	'december-gen' => 'Sĕk-nê nguŏk',
	'dec' => '12ng',
	'delete' => 'Chēng',
	'deletethispage' => 'Chēng ciā hiĕk',
	'disclaimers' => 'Mò̤ hô-cáik sĭng-mìng',
	'disclaimerpage' => 'Project:Mò̤ hô-cáik sĭng-mìng',
	'databaseerror' => 'Só-gé̤ṳ-kó ô dâng',
	'difference' => '(Bēng-buōng cĭ-găng gì chă-biék)',
	'diff-multi' => '(Dài-dŏng ô {{PLURAL:$1|ék|$1}} bĭk bēng-buōng mò̤ hiēng-sê.)',
	'datedefault' => 'Mò̤ siék-diâng',
	'diff' => 'chă',
	'destfilename' => 'Mŭk-biĕu ùng-giông-miàng:',
	'download' => 'hâ-diòng',
	'deletedcontributions' => 'Ké̤ṳk chēng lâi gì ê̤ṳng-hô góng-hióng',
	'deletedcontributions-title' => 'Ké̤ṳk chēng lâi gì ê̤ṳng-hô góng-hióng',
	'defemailsubject' => '{{SITENAME}} diêng-piĕ',
	'deletepage' => 'Chēng hiĕk',
	'deletedtext' => '"$1" ī-gĭng ké̤ṳk chēng lâi go̤ lāu. Cī-bŏng chēng hiĕk gì gé-liŏh dŭ gé diŏh $2.',
	'dellogpage' => 'Chēng hiĕk nĭk-cé',
	'dellogpagetext' => 'Â-dā̤ sê gé-liŏh cī-bŏng chēng hiĕk gì dăng-dăng.',
	'deletionlog' => 'chēng hiĕk nĭk-cé',
	'deletecomment' => 'Nguòng-ĭng',
	'databasenotlocked' => 'Só-gé̤ṳ-kó mò̤ sō̤',
	'delete_and_move' => 'Chēng lâi bêng-chiā iè-dông',
	'delete_and_move_confirm' => 'Ciáng-sê, chēng lâi cī miêng hiĕk',
	'deletedrevision' => 'Ī-gĭng chēng lâi gì bēng-buōng $1.',
	'deletedwhileediting' => 'Gīng-gó̤: Cī miêng hiĕk găk nṳ̄ kī-chiū siŭ-gāi cĭ hâiu ké̤ṳk chēng lâi go̤ lāu!',
	'descending_abbrev' => 'gáung',
);

$messages['ce'] = array(
	'december' => 'огой бутт',
	'december-gen' => 'огой бутт',
	'dec' => 'огой бутт',
	'delete' => 'Дlадайá',
	'deletethispage' => 'Дlайайá хlара агlо',
	'disclaimers' => 'Бехк тlе ца эцар',
	'disclaimerpage' => 'Project:Бяхк тlецалацар',
	'databaseerror' => 'Гlалат хаамийн бухера',
	'difference' => '(Тайпанара юкъар башхалла)',
	'diff' => 'тейп тайпнара',
	'disambiguations' => 'Дуккха маьIнаш долу хьажорца йолу агIонаш',
	'doubleredirects' => 'ШалгIа дIасахьажийнарш',
	'double-redirect-fixed-move' => 'Агlон [[$1]] цlе хийцна, хlинца иза дlахьажийна оцу [[$2]]',
	'deadendpages' => 'Дика йоцу агIонаш',
	'deletedcontributions' => 'Декъашхочуьн дlабайина къинхьегам',
	'defemailsubject' => 'Хаам {{grammar:genitive|{{SITENAME}}}} чура бу',
	'deletepage' => 'Дlайайá агlо',
	'delete-legend' => 'Дlадайáр',
	'deletedtext' => '«$1» дlаяккхина йара.
Хьажа. $2 хьажарна оцу тlаьхьара дlадайаран могlаме.',
	'dellogpage' => 'Дlадайарш долу тéптар',
	'deletionlog' => 'дlадайарш долу тéптар',
	'deletecomment' => 'Бахьан:',
	'deleteotherreason' => 'Кхин бахьан/тlетохар:',
	'deletereasonotherlist' => 'Кхин бахьан',
	'delete_and_move' => 'Цle а хуьйцуш дlадайá',
	'delete_and_move_confirm' => 'Хlаъ, дlайайъа хlара агlо',
	'dberr-header' => 'Хlара вики ловш йу халона бала',
	'dberr-problems' => 'Бехк ма бил! Хlинц машан меттиган хилла гlирсаца халонаш.',
	'dberr-again' => 'Хьажа карла йаккха агlо массех минот йаьлча.',
	'dberr-info' => '(аьтто ца хили зlе хlотта гlулкхдечуьнца бухара хаамашца: $1)',
	'dberr-usegoogle' => 'Цlачун хьо хьажа лаха гlонца Google.',
	'dberr-outofdate' => 'Хьуна хаалахь, цуьна йолу меттиг хила мега тишйелла черахь.',
);

$messages['ceb'] = array(
	'december' => 'Disyembre',
	'december-gen' => 'Disyembre',
	'dec' => 'Dis',
	'delete' => 'Papasa',
	'deletethispage' => 'Papasa kining panid',
	'disclaimers' => 'Mga pagpasabot',
	'disclaimerpage' => 'Project:Mga pagpasabot',
	'databaseerror' => 'Sayop sa database',
	'dberrortext' => 'May nahitabong sayop sa database query syntax.
Mahimong nagpakita kini og bug sa software.
Ang naulahing gi-attempt nga database query mao ang:
<blockquote><tt>$1</tt></blockquote>
from within function "<tt>$2</tt>".
MySQL returned error "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'May nahitabong sayop sa database query syntax.
Ang naulahing gi-attempt nga database query mao ang:
"$1"
from within function "$2".
MySQL returned error "$3: $4"',
	'directorycreateerror' => 'Dili makahimo og direktoryo nga "$1".',
	'deletedhist' => 'Napapas nga kaagi',
	'difference' => '(Kalainan sa mga rebisyon)',
	'datedefault' => 'Walay preperensiya',
	'defaultns' => 'Kondili, pangita na lang niining mga ngalang espasyo:',
	'default' => 'default',
	'diff' => 'kalainan',
	'deletepage' => 'Papasa ang panid',
	'deletedtext' => 'Ang "$1" napapas na.
Tan-awa ang $2 para sa rekord sa mga bag-ong napapas.',
	'dellogpage' => 'Log sa pagtangtang',
	'deletecomment' => 'Rason:',
	'deleteotherreason' => 'Uban pa/dugang nga rason:',
	'deletereasonotherlist' => 'Uban pang rason',
);

$messages['ch'] = array(
	'december' => 'Disiembre',
	'december-gen' => 'Disiembre',
	'dec' => 'Dis',
	'delete' => "Na'suha",
	'deletethispage' => "Na'suha i påhina",
	'disclaimers' => 'Diklarasion Inadahi',
	'disclaimerpage' => 'Project:Diklarasion inadahi henerat',
	'directorycreateerror' => 'Ti siña u fa\'tinas i direktorio "$1".',
	'deletedhist' => "Historia mana'suha",
	'difference' => '(Diferensia siha gi tinilaika)',
	'diff-multi' => "({{PLURAL:$1|Ti mana'a'annok unu na tinilaika gi talo'|Ti manmana'a'annok $1 na tinilaika siha gi talo'}}.)",
	'datedefault' => "Tåya' prifirensia",
	'defaultns' => "Fanaligao hålom este na sågan nå'an fine'nena:",
	'default' => 'default',
	'diff' => 'dif',
	'disambiguations' => "Ti mania'abak na påhina siha",
	'disambiguationspage' => 'Template:disambig',
	'doubleredirects' => "Mandoble na inachetton ma'dirihi siha",
	'deadendpages' => 'Påhina siha ni taiinachetton',
	'deletepage' => "Na'suha i påhina",
	'deletedtext' => 'Mana\'suha "$1".
Chek $2 para i historian muna\'suha gi halacha.',
	'dellogpage' => "Historian muna'suha",
	'deletecomment' => 'Rason:',
	'deleteotherreason' => 'Otru na rason:',
	'deletereasonotherlist' => 'Otru rason',
);

$messages['ckb'] = array(
	'december' => 'کانوونی یەکەم',
	'december-gen' => 'کانوونی یەکەمی',
	'dec' => 'كا١',
	'delete' => 'سڕینەوە',
	'deletethispage' => 'سڕینه‌وه‌ی ئه‌م په‌ڕه‌یه‌',
	'disclaimers' => 'نابەرپرسییەکان',
	'disclaimerpage' => 'Project:بەرپرس‌نەبوون',
	'databaseerror' => 'ھەڵەی داتابەیس',
	'dberrortext' => 'ھەڵەیەکی ڕستەنووسی لە داواکاریی بنکەیدراو ڕووی داوە.
لەوانەیە ئەوە نیشاندەری کەلێنێک لە نەرمامێرەکەدا بێت.
دوایین تێکۆشان بۆ داواکاری بنکەیدراو:
<blockquote><tt>$1</tt></blockquote>.
لە نێو کرداری "<tt>$2</tt>".
بنکەیدراو ھەڵەی"<tt>$3: $4</tt>" گەڕاندووتەوە.',
	'dberrortextcl' => 'هەڵەیەکی ڕستەنووسی لە داواکاریی بنکە‌یدراو ڕوویداوە.
دوایین تێکۆشان بۆ داواکاری بنکەیدراو ئەمە بووە:
"$1"
لە نێو کرداری "$2".
بنکەیدراو ھەڵەی "$3: $4" گەڕاندووەتەوە',
	'directorycreateerror' => 'نەتوانرا بوخچەی "$1"دروست بکرێت.',
	'deletedhist' => 'مێژوو بسڕەوە',
	'difference' => '(جیاوازی نێوان پێداچوونەوەکان)',
	'datedefault' => 'ھەڵنەبژێردراو',
	'defaultns' => 'ئەگەرنا لەم بۆشایی ناوانەدا بگەڕە:',
	'default' => 'بنچینەیی',
	'diff' => 'جیاوازی',
	'destfilename' => 'ناوی مەبەست:',
	'duplicatesoffile' => 'ئەم {{PLURAL:$1|پەڕگە دووبارەکرنەوەیەکی|پەڕگانە دووبارەکردنەوەی}} ئەم پەڕگەن ([[Special:FileDuplicateSearch/$2|وردەکاری زیاتر]]):',
	'download' => 'داگرتن',
	'disambiguations' => 'پەڕەکانی جوداکردنەوە',
	'disambiguationspage' => 'Template: خاوێن‌کردنەوەی ناوەڕۆک',
	'disambiguations-text' => "ئەم لاپەڕانە بەستەرن بۆ '''لاپەڕەی خاوێن‌کردنەوەی ناوەڕۆک'''.
ئەوانە دەبێ لە جیاتی ئەوە بەستەر بن بۆ بابەتی گونجاو.<br />
هەر لاپەڕەیەک کە لە داڕێژی بەستەر پێ‌دراو لە [[MediaWiki:Disambiguationspage]] کەڵک وەرگرێت وەک لاپەڕەی خاوێن‌کردنەوەی نوەڕۆک دەناسرێت.",
	'doubleredirects' => 'دووجار ڕەوانەکراوەکان',
	'double-redirect-fixed-move' => '[[$1]] گوێسترایەوە.
ئێستا ڕەوانکەرە بۆ [[$2]].',
	'double-redirect-fixer' => 'چارەسەرکەری ڕەوانکەر',
	'deadendpages' => 'لاپەڕەکانی دوایین بەستراو',
	'deadendpagestext' => 'ئەم لاپەرانە بە هیچ لاپەڕەیەکی دیکە لە {{SITENAME}}دا بەستەری نەداوە.',
	'deletedcontributions' => 'بەشدارییە سڕاوەکان',
	'deletedcontributions-title' => 'هاوبەشییەکانی سڕاوەی بەکارهێنەر',
	'defemailsubject' => 'ئیمەیلی {{SITENAME}}',
	'deletepage' => 'پەڕە بسڕەوەو',
	'delete-confirm' => 'سڕینەوەی "$1"',
	'delete-backlink' => '→ $1',
	'delete-legend' => 'سڕینەوە',
	'deletedtext' => '"<nowiki>$1</nowiki>"  سڕایەوە.
سەیری $2 بکە بۆ تۆمارێکی دوایین سڕینەوەکان.',
	'deletedarticle' => '«[[$1]]»ی سڕیەوە',
	'dellogpage' => 'لۆگی سڕینەوە',
	'dellogpagetext' => 'ئەوەی خوارەوە لیستێكە لە دوایین سڕینەوەکان',
	'deletionlog' => 'لۆگی سڕینەوە',
	'deletecomment' => 'هۆکار:',
	'deleteotherreason' => 'ھۆکاری دیکە:',
	'deletereasonotherlist' => 'ھۆکاری دیکە',
	'deletereason-dropdown' => '* ھۆکاری سڕینەوە
** داواکاریی نووسەر
** تێکدانی مافی لەبەرگرتنەوە
** خراپکاری',
	'delete-edit-reasonlist' => 'دەستکاری کردنی ھۆکارەکانی سڕینەوە',
	'delete-toobig' => 'ئەم لاپەڕە مێژوویەکی دەستکاری زۆر گەورەی هەیە، زیاتر لە $1 {{PLURAL:$1|پێداچوونەوە|پێداچوونەوە}}.
بۆ بەرگری لە خراپ‌بوونی چاوەڕوان نەکراوی {{SITENAME}}، سڕینەوەی لاپەڕەی وا بەربەست‌کراوە.',
	'delete-warning-toobig' => 'ئەم لاپەڕە مێژوویەکی دەستکاری زۆر گەورەی هەیە، زیاتر لە $1 {{PLURAL:$1|پێداچوونەوە|پێداچوونەوە}}.
سڕینەوی ئەوە لە وانەیە کارەکانی بنکەدراوی {{SITENAME}} تووشی کێشە بکات؛
دوورنواڕانە جێ‌بەجێی بکە.',
	'databasenotlocked' => 'بنکەدراو دانەخراوە.',
	'delete_and_move' => 'بیسڕەوە و بیگوازەوە',
	'delete_and_move_text' => '== پێویستییەکانی سڕینەوە ==
لاپەڕەی مەبەست "[[:$1]]" لە پێش‌دا هەیە.
ئایا دەتەوێ ئەوە بسڕیتەوە تا ڕێگە بۆ گواستنەوەی بکەیتەوە؟',
	'delete_and_move_confirm' => 'بەڵێ، لاپەڕەکە بسڕەوه',
	'delete_and_move_reason' => 'بۆ کردنەوەی ڕیگە بۆ گواستنەوەی لاپەڕە، سڕایەوە',
	'djvu_page_error' => 'لاپەڕەی DjVu لەدەرۆی ڕیز',
	'djvu_no_xml' => 'XML بۆ پەڕگەی DjVu ناکێشرێتەوە',
	'deletedrevision' => 'پێداچوونەوەی کۆنی سڕاوە $1',
	'dberr-header' => 'ئەم ویکی‌یە کێشەی هەیە',
	'dberr-problems' => 'ببورە! ئەم ماڵپەڕە ئێستا خەریک ئەزموونێکی کێشەی تەکنیکیە.',
	'dberr-again' => 'چەن خولک ڕاوەستە و نوێی بکەوە.',
	'dberr-info' => '(پەیوەندی دەگەڵ ڕاژەکاری بنکەدراو پێک‌نایەت: $1)',
	'dberr-usegoogle' => 'دەتوانی هاوکات هەوڵی گەڕان بە گووگڵ بدەیت.',
	'dberr-outofdate' => 'لەیادت بێ لەوانەیە پێرستەکەیان سەبارەت نە ناوەڕۆک ئەم ماڵپەڕە ماوە بەسەرچوو بێت.',
	'dberr-cachederror' => 'ئەمە ڕوونووسێکی کاش‌کراوی لاپەڕەی داواکراوە و لەوانەیە بەڕۆژ نەبێت.',
);

$messages['co'] = array(
	'december' => 'dicembre',
	'december-gen' => 'dicembre',
	'dec' => 'dic',
	'delete' => 'Supprimà',
	'deletethispage' => 'Cancellà issa pagina',
	'disclaimers' => 'Avertimenti',
	'disclaimerpage' => 'Project:Avertimenti generali',
	'deletepage' => 'Supprimà a pagina',
	'delete-legend' => 'Supprimà',
	'deletecomment' => 'Mutivu:',
	'delete_and_move_confirm' => 'Iè, supprimà issa pagina',
);

$messages['cps'] = array(
	'december' => 'Disyembre',
	'december-gen' => 'Disyembre',
	'dec' => 'Dis',
	'delete' => 'Panason',
	'deletethispage' => 'Panason ang mini nga pahina',
	'disclaimers' => 'Mga pagpangindi',
	'disclaimerpage' => 'Project:Pangkabilugan nga pagpangindi',
	'databaseerror' => 'Diperensya sa database',
	'dberrortext' => 'May sala sa database query syntax.
Posible tungod mini sa depekto sa software.
Ang nagligad nga database query mini:
<blockquote><tt>$1</tt></blockquote>
nga halin sa ulubrahon nga "<tt>$2</tt>".
Nagbalik sang sala nga "<tt>$3: $4</tt>" ang MySQL.',
	'dberrortextcl' => 'May ara sang kasal-anan sa usisa nga pangpapagpaangot sa kalipunan sang datos.
Ang ulihi nga pagtisting pagusisa sa kalipunan sang datos amu ang:
"$1"
halin sa ulubrahon nga "$2".
Ginbalik sang kalipunan sang datos ang kasal-anan nga "$3: $4"',
	'directorycreateerror' => 'Indi maka-ubra sang direktoryo nga "$1".',
	'difference' => '(Ginkala-in sang mga rebisyon)',
	'diff' => 'ginkala-in',
	'deletepage' => 'Panason ang pahina',
	'deletedtext' => 'Napanas na ang "$1".
Tan-awon ang $2 para sa nalista sang mga bag-o lang napanas.',
	'dellogpage' => 'Lista sang pagpanas',
	'deletecomment' => 'Rason:',
	'deleteotherreason' => 'Iban pa/dugang nga rason:',
	'deletereasonotherlist' => 'Iban nga rason',
);

$messages['crh'] = array(
	'december' => 'Disyembre',
	'december-gen' => 'Disyembre',
	'dec' => 'Dis',
	'delete' => 'Panason',
	'deletethispage' => 'Panason ang mini nga pahina',
	'disclaimers' => 'Mga pagpangindi',
	'disclaimerpage' => 'Project:Pangkabilugan nga pagpangindi',
	'databaseerror' => 'Diperensya sa database',
	'dberrortext' => 'May sala sa database query syntax.
Posible tungod mini sa depekto sa software.
Ang nagligad nga database query mini:
<blockquote><tt>$1</tt></blockquote>
nga halin sa ulubrahon nga "<tt>$2</tt>".
Nagbalik sang sala nga "<tt>$3: $4</tt>" ang MySQL.',
	'dberrortextcl' => 'May ara sang kasal-anan sa usisa nga pangpapagpaangot sa kalipunan sang datos.
Ang ulihi nga pagtisting pagusisa sa kalipunan sang datos amu ang:
"$1"
halin sa ulubrahon nga "$2".
Ginbalik sang kalipunan sang datos ang kasal-anan nga "$3: $4"',
	'directorycreateerror' => 'Indi maka-ubra sang direktoryo nga "$1".',
	'difference' => '(Ginkala-in sang mga rebisyon)',
	'diff' => 'ginkala-in',
	'deletepage' => 'Panason ang pahina',
	'deletedtext' => 'Napanas na ang "$1".
Tan-awon ang $2 para sa nalista sang mga bag-o lang napanas.',
	'dellogpage' => 'Lista sang pagpanas',
	'deletecomment' => 'Rason:',
	'deleteotherreason' => 'Iban pa/dugang nga rason:',
	'deletereasonotherlist' => 'Iban nga rason',
);

$messages['crh-cyrl'] = array(
	'december' => 'декабрь',
	'december-gen' => 'декабрьнинъ',
	'dec' => 'дек',
	'delete' => 'Ёкъ эт',
	'deletethispage' => 'Саифени ёкъ эт',
	'disclaimers' => 'Джевапкярлыкъ реди',
	'disclaimerpage' => 'Project:Умумий Малюмат Мукъавелеси',
	'databaseerror' => 'Малюмат базасынынъ хатасы',
	'dberrortext' => 'Малюмат базасындан сораткъанда синтаксис хатасы олды.
Бу язылымдаки бир хата ола биле.
"<tt>$2</tt>" функциясындан олгъан малюмат базасындан сонъки соратма:
<blockquote><tt>$1</tt></blockquote>.
Малюмат базасынынъ бильдирген хатасы "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Малюмат базасындан сораткъанда синтаксис хатасы олды.
Малюмат базасындан сонъки соратма:
«$1»
Къулланылгъан функция «$2».
Малюмат базасынынъ бильдирген хатасы «$3: $4».',
	'directorycreateerror' => '"$1" директориясы яратылып оламай.',
	'difference' => '(Версиялар арасы фаркълар)',
	'difference-multipage' => '(Саифелер арасындаки фаркъ)',
	'diff-multi' => '({{PLURAL:$2|Бир къулланыджы|$2 къулланыджы}}нынъ япкъан {{PLURAL:$1|бир ара версиясы|$1 ара версиясы}} косьтерильмей)',
	'diff-multi-manyusers' => '($2-ден зияде {{PLURAL:$2|къулланыджы|къулланыджы}}нынъ япкъан {{PLURAL:$1|бир ара версиясы|$1 ара версиясы}} косьтерильмей)',
	'datedefault' => 'Стандарт',
	'defaultns' => 'Акис алда бу исим фезаларында къыдыр:',
	'default' => 'оригинал',
	'diff' => 'фаркъ',
	'destfilename' => 'Файлнынъ истенильген ады:',
	'download' => 'юкле',
	'disambiguations' => 'Чокъ маналы терминлер саифелери',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Ашагъыдыки саифелер '''чокъ маналы саифелер'''ге багъланты ола.
Бельки де олар бир конкрет саифеге багъланты олмалы.<br />
Эгер саифеде, [[MediaWiki:Disambiguationspage]] саифесинде ады кечкен шаблон ерлештирильген олса, о саифе чокъ маналыдыр.",
	'doubleredirects' => 'Ёлламагъа олгъан ёлламалар',
	'doubleredirectstext' => 'Бу саифеде дигер ёллама саифелерине ёлланма олгъан саифелери косьтериле.
Эр сатырда биринджи ве экинджи ёлламагъа багълантылар да, экинджи ёлламанынъ макъсат саифеси (адетиндже о биринджи ёлламанынъ керекли макъсады ола) да бар.
<del>Устю сызылгъан</del> меселелер энди чезильген.',
	'double-redirect-fixed-move' => '[[$1]] авуштырылды, шимди [[$2]] саифесине ёллап тура.',
	'deadendpages' => 'Башкъа саифелерге багълантысы олмагъан саифелер',
	'deadendpagestext' => 'Бу {{SITENAME}} башкъа саифелерине багълантысы олмагъан саифелердир.',
	'defemailsubject' => '{{SITENAME}} e-mail',
	'deletepage' => 'Саифени ёкъ эт',
	'delete-confirm' => '«$1» саифесини ёкъ этмектесинъиз',
	'delete-legend' => 'Ёкъ этюв',
	'deletedtext' => '"$1" ёкъ этильди.
якъын заманда ёкъ этильгенлерни корьмек ичюн: $2.',
	'dellogpage' => 'Ёкъ этюв журналы',
	'dellogpagetext' => 'Ашагъыдаки джедвель сонъки ёкъ этюв журналыдыр.',
	'deletionlog' => 'ёкъ этюв журналы',
	'deletecomment' => 'Себеп:',
	'deleteotherreason' => 'Дигер/илявели себеп:',
	'deletereasonotherlist' => 'Дигер себеп',
	'delete_and_move' => 'Ёкъ эт ве адыны денъиштир',
	'delete_and_move_text' => '==Ёкъ этмек лязимдир==

«[[:$1]]» саифеси энди бар. Адыны денъиштирип олмакъ ичюн оны ёкъ этмеге истейсинъизми?',
	'delete_and_move_confirm' => 'Эбет, бу саифени ёкъ эт',
	'delete_and_move_reason' => 'Исим денъиштирип олмакъ ичюн ёкъ этильди',
	'deletedrevision' => '$1 сайылы эски версия ёкъ этильди.',
	'deletedwhileediting' => "'''Тенби''': Бу саифе сиз денъишиклик япмагъа башлагъандан сонъ ёкъ этильди!",
	'descending_abbrev' => 'буюктен кичикке',
);

$messages['crh-latn'] = array(
	'december' => 'dekabr',
	'december-gen' => 'dekabrniñ',
	'dec' => 'dek',
	'delete' => 'Yoq et',
	'deletethispage' => 'Saifeni yoq et',
	'disclaimers' => 'Cevapkârlıq redi',
	'disclaimerpage' => 'Project:Umumiy Malümat Muqavelesi',
	'databaseerror' => 'Malümat bazasınıñ hatası',
	'dberrortext' => 'Malümat bazasından soratqanda sintaksis hatası oldı.
Bu yazılımdaki bir hata ola bile.
"<tt>$2</tt>" funktsiyasından olğan malümat bazasından soñki soratma:
<blockquote><tt>$1</tt></blockquote>.
Malümat bazasınıñ bildirgen hatası "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Malümat bazasından soratqanda sintaksis hatası oldı.
Malümat bazasından soñki soratma:
"$1"
Qullanılğan funktsiya "$2".
Malümat bazasınıñ bildirgen hatası "$3: $4".',
	'directorycreateerror' => '"$1" direktoriyası yaratılıp olamay.',
	'difference' => '(Versiyalar arası farqlar)',
	'difference-multipage' => '(Saifeler arasındaki farq)',
	'diff-multi' => '({{PLURAL:$2|Bir qullanıcı|$2 qullanıcı}}nıñ yapqan {{PLURAL:$1|bir ara versiyası|$1 ara versiyası}} kösterilmey)',
	'diff-multi-manyusers' => '($2-den ziyade {{PLURAL:$2|qullanıcı|qullanıcı}}nıñ yapqan {{PLURAL:$1|bir ara versiyası|$1 ara versiyası}} kösterilmey)',
	'datedefault' => 'Standart',
	'defaultns' => 'Akis alda bu isim fezalarında qıdır:',
	'default' => 'original',
	'diff' => 'farq',
	'destfilename' => 'Faylnıñ istenilgen adı:',
	'download' => 'yükle',
	'disambiguations' => 'Çoq manalı terminler saifeleri',
	'disambiguationspage' => '{{ns:template}}:disambig',
	'disambiguations-text' => "Aşağıdıki saifeler '''çoq manalı saifeler'''ge bağlantı ola.
Belki de olar bir konkret saifege bağlantı olmalı.<br />
Eger saifede, [[MediaWiki:Disambiguationspage]] saifesinde adı keçken şablon yerleştirilgen olsa, o saife çoq manalıdır.",
	'doubleredirects' => 'Yollamağa olğan yollamalar',
	'doubleredirectstext' => 'Bu saifede diger yollama saifelerine yollanma olğan saifeleri kösterile.
Er satırda birinci ve ekinci yollamağa bağlantılar da, ekinci yollamanıñ maqsat saifesi (adetince o birinci yollamanıñ kerekli maqsadı ola) da bar.
<del>Üstü sızılğan</del> meseleler endi çezilgen.',
	'double-redirect-fixed-move' => '[[$1]] avuştırıldı, şimdi [[$2]] saifesine yollap tura.',
	'deadendpages' => 'Başqa saifelerge bağlantısı olmağan saifeler',
	'deadendpagestext' => 'Bu {{SITENAME}} başqa saifelerine bağlantısı olmağan saifelerdir.',
	'defemailsubject' => '{{SITENAME}} e-mail',
	'deletepage' => 'Saifeni yoq et',
	'delete-confirm' => '"$1" saifesini yoq etmektesiñiz',
	'delete-legend' => 'Yoq etüv',
	'deletedtext' => '"$1" yoq etildi.
yaqın zamanda yoq etilgenlerni körmek içün: $2.',
	'dellogpage' => 'Yoq etüv jurnalı',
	'dellogpagetext' => 'Aşağıdaki cedvel soñki yoq etüv jurnalıdır.',
	'deletionlog' => 'yoq etüv jurnalı',
	'deletecomment' => 'Sebep:',
	'deleteotherreason' => 'Diger/ilâveli sebep:',
	'deletereasonotherlist' => 'Diger sebep',
	'delete_and_move' => 'Yoq et ve adını deñiştir',
	'delete_and_move_text' => '== Yoq etmek lâzimdir ==

"[[:$1]]" saifesi endi bar. Adını deñiştirip olmaq içün onı yoq etmege isteysiñizmi?',
	'delete_and_move_confirm' => 'Ebet, bu saifeni yoq et',
	'delete_and_move_reason' => 'İsim deñiştirip olmaq içün yoq etildi',
	'deletedrevision' => '$1 sayılı eski versiya yoq etildi.',
	'deletedwhileediting' => "'''Tenbi''': Bu saife siz deñişiklik yapmağa başlağandan soñ yoq etildi!",
	'descending_abbrev' => 'büyükten kiçikke',
);

$messages['cs'] = array(
	'december' => 'prosinec',
	'december-gen' => 'prosince',
	'dec' => '12.',
	'delete' => 'Smazat',
	'deletethispage' => 'Smazat stránku',
	'disclaimers' => 'Vyloučení odpovědnosti',
	'disclaimerpage' => 'Project:Vyloučení odpovědnosti',
	'databaseerror' => 'Databázová chyba',
	'dberrortext' => 'Při dotazu do databáze došlo k syntaktické chybě.
Příčinou může být chyba v programu.
Poslední dotaz byl:
<blockquote><tt>$1</tt></blockquote>
z funkce „<tt>$2</tt>“.
Databáze vrátila chybu „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Při dotazu do databáze došlo k syntaktické chybě.
Poslední dotaz byl:
„$1“
z funkce „$2“.
Databáze vrátila chybu „$3: $4“',
	'directorycreateerror' => 'Nelze vytvořit adresář „$1“.',
	'delete-hook-aborted' => 'Smazání bylo bez bližšího vysvětlení zrušeno přípojným bodem.',
	'defaultmessagetext' => 'Výchozí text hlášení',
	'deletedhist' => 'Smazaná historie',
	'difference-title' => '$1: Porovnání verzí',
	'difference-title-multipage' => '$1 a $2: Porovnání stránek',
	'difference-multipage' => '(Rozdíly mezi stránkami)',
	'diff-multi' => '({{PLURAL:$1|Není zobrazena 1 mezilehlá verze|Nejsou zobrazeny $1 mezilehlé verze|Není zobrazeno $1 mezilehlých verzí}} od {{PLURAL:$2|1 uživatele|$2 uživatelů}}.)',
	'diff-multi-manyusers' => '(Není zobrazeno $1 mezilehlých verzí od více než $2 {{PLURAL:$2|uživatele|uživatelů}}.)',
	'datedefault' => 'Implicitní',
	'defaultns' => 'Nebo hledat v těchto jmenných prostorech:',
	'default' => 'implicitní',
	'diff' => 'rozdíl',
	'destfilename' => 'Cílové jméno:',
	'duplicatesoffile' => '{{plural:$1|Následující soubor je duplikát|Následující $1 soubory jsou duplikáty|Následujících $1 souborů jsou duplikáty}} tohoto souboru ([[Special:FileDuplicateSearch/$2|podrobnosti]]):',
	'download' => 'stažení',
	'disambiguations' => 'Stránky odkazující na rozcestníky',
	'disambiguationspage' => 'Template:Rozcestník',
	'disambiguations-text' => 'Odkazy na následujících stránkách vedou na rozcestníky (stránky obsahující některou ze šablon uvedených na [[MediaWiki:Disambiguationspage|seznamu rozcestníkových šablon]]) místo na příslušný článek.',
	'doubleredirects' => 'Dvojitá přesměrování',
	'doubleredirectstext' => 'Na této stránce je seznam přesměrování vedoucích na další přesměrování.
Každý řádek obsahuje odkaz na první a druhé přesměrování a k tomu cíl druhého přesměrování, který obvykle ukazuje jméno „skutečné“ cílové stránky, na kterou by mělo první přesměrování odkazovat.
<del>Přeškrtnuté</del> položky již byly vyřešeny.',
	'double-redirect-fixed-move' => 'Stránka [[$1]] byla přesunuta, nyní přesměrovává na [[$2]]',
	'double-redirect-fixed-maintenance' => 'Oprava dvojitého přesměrování z [[$1]] na [[$2]].',
	'double-redirect-fixer' => 'Opravář přesměrování',
	'deadendpages' => 'Slepé stránky',
	'deadendpagestext' => 'Následující stránky neodkazují na žádnou jinou stránku {{grammar:2sg|{{SITENAME}}}}.',
	'deletedcontributions' => 'Smazané editace uživatele',
	'deletedcontributions-title' => 'Smazané editace uživatele',
	'defemailsubject' => 'E-mail z {{grammar:2sg|{{SITENAME}}}} od {{gender:$1|uživatele|uživatelky|uživatele}} „$1“',
	'deletepage' => 'Smazat stránku',
	'delete-confirm' => 'Smazání stránky „$1“',
	'delete-legend' => 'Smazat',
	'deletedtext' => 'Stránka nebo soubor „$1“ byla smazána. $2 zaznamenává poslední smazání.',
	'dellogpage' => 'Kniha smazaných stránek',
	'dellogpagetext' => 'Zde je seznam posledních smazaných stránek.',
	'deletionlog' => 'Kniha smazaných stránek',
	'deletecomment' => 'Důvod:',
	'deleteotherreason' => 'Jiný/další důvod:',
	'deletereasonotherlist' => 'Jiný důvod',
	'deletereason-dropdown' => '*Obvyklé důvody smazání
** Na žádost autora
** Porušení autorských práv
** Vandalismus',
	'delete-edit-reasonlist' => 'Editovat důvody smazání',
	'delete-toobig' => 'Tato stránka má velkou historii editací, přes $1 {{plural:$1|verzi|verze|verzí}}. Mazání takových stránek je omezeno, aby se předešlo nechtěnému narušení {{grammar:2sg|{{SITENAME}}}}.',
	'delete-warning-toobig' => 'Tato stránka má velkou historii editací, přes $1 {{plural:$1|verzi|verze|verzí}}. Mazání takových stránek může narušit databázové operace {{grammar:2sg|{{SITENAME}}}}; postupujte opatrně.',
	'databasenotlocked' => 'Databáze není uzamčena.',
	'delete_and_move' => 'Smazat a přesunout',
	'delete_and_move_text' => '==Je potřeba smazání==

Cílová stránka „[[:$1]]“ již existuje. Přejete si ji smazat pro uvolnění místa pro přesun?',
	'delete_and_move_confirm' => 'Ano, smazat cílovou stránku',
	'delete_and_move_reason' => 'Smazáno pro umožnění přesunu z „[[$1]]“',
	'djvu_page_error' => 'Stránka DjVu mimo rozsah',
	'djvu_no_xml' => 'Vytvoření XML pro soubor DjVu se nezdařilo.',
	'deletedrevision' => 'Smazána stará revize $1',
	'days' => '{{PLURAL:$1|$1 den|$1 dny|$1 dní}}',
	'deletedwhileediting' => "'''Upozornění''': V průběhu vaší editace byla tato stránka smazána!",
	'descending_abbrev' => 'sest.',
	'duplicate-defaultsort' => 'Upozornění: Implicitní klíč řazení (DEFAULTSORTKEY) „$2“ přepisuje dříve nastavenou hodnotu „$1“.',
	'dberr-header' => 'Tato wiki má nějaké potíže',
	'dberr-problems' => 'Promiňte! Tento server má v tuto chvíli technické problémy.',
	'dberr-again' => 'Zkuste několik minut počkat a poté znovu načíst stránku.',
	'dberr-info' => '(Nelze navázat spojení s databázovým serverem: $1)',
	'dberr-usegoogle' => 'Mezitím můžete zkusit hledat pomocí Google.',
	'dberr-outofdate' => 'Uvědomte si, že jejich vyhledávací index našeho obsahu může být zastaralý.',
	'dberr-cachederror' => 'Následující stránka je kopie z cache a nemusí být aktuální.',
	'duration-seconds' => '$1 {{PLURAL:$1|sekunda|sekundy|sekund}}',
	'duration-minutes' => '$1 {{PLURAL:$1|minuta|minuty|minut}}',
	'duration-hours' => '$1 {{PLURAL:$1|hodina|hodiny|hodin}}',
	'duration-days' => '$1 {{PLURAL:$1|den|dny|dní}}',
	'duration-weeks' => '$1 {{PLURAL:$1|týden|týdny|týdnů}}',
	'duration-years' => '$1 {{PLURAL:$1|rok|roky|let}}',
	'duration-decades' => '$1 {{PLURAL:$1|dekáda|dekády|dekád}}',
	'duration-centuries' => '$1 {{PLURAL:$1|století}}',
	'duration-millennia' => '$1 {{PLURAL:$1|tisíciletí}}',
);

$messages['csb'] = array(
	'december' => 'gòdnik',
	'december-gen' => 'gòdnika',
	'dec' => 'gòd',
	'delete' => 'Rëmôj',
	'deletethispage' => 'Rëmôj nã starnã',
	'disclaimers' => 'Prawné zastrzedżi',
	'disclaimerpage' => 'Project:Prawné zastrzedżi',
	'databaseerror' => 'Fela w pòdôwkòwi baze',
	'deletedhist' => 'Rëmniãtô historëjô edicëji',
	'difference' => '(różnice midzë wersëjama)',
	'datedefault' => 'Felëje preferencëji',
	'defaultns' => 'Abò szëkôj w nôslédny rëmnoce mionów:',
	'default' => 'domëszlné',
	'diff' => 'jinosc',
	'disambiguationspage' => 'Template:Starnë_ùjednoznacznieniô',
	'doubleredirects' => 'Dëbeltné przeczérowania',
	'defemailsubject' => 'E-mail òd {{SITENAME}}',
	'deletepage' => 'Rëmôj starnã',
	'delete-legend' => 'Rëmôj',
	'deletedtext' => '^$1" òstôł rëmniãti.
Òbôczë na starnie $2 register slédnych rëmniãców.',
	'dellogpage' => 'Rëmóné',
	'deletionlog' => 'register rëmaniów',
	'deletecomment' => 'Przëczëna:',
	'deleteotherreason' => 'Jinszô, abò doôwnô przëczëna:',
	'deletereasonotherlist' => 'Jinszô przëczëna',
	'delete_and_move' => 'Rëmôj ë przeniesë',
	'delete_and_move_confirm' => 'Jo, rëmôj ną starnã',
);

$messages['cu'] = array(
	'december' => 'дєкємврїи',
	'december-gen' => 'дєкємврїꙗ',
	'dec' => 'дє҃к',
	'delete' => 'поничьжєниѥ',
	'deletethispage' => 'си страницѧ поничьжєниѥ',
	'deletedhist' => 'поничьжєна їсторїꙗ',
	'diff' => 'ра҃ꙁн',
	'download' => 'поѩти',
	'disambiguations' => 'страницѧ ижє съвѧꙁи съ мъногосъмꙑслиꙗ имѫтъ',
	'disambiguationspage' => 'Template:мъногосъмꙑслиѥ',
	'deletedcontributions' => 'поничьжєнꙑ добродѣꙗниꙗ',
	'deletedcontributions-title' => 'поничьжєнꙑ добродѣꙗниꙗ',
	'deletepage' => 'поничьжєниѥ',
	'delete-legend' => 'поничьжєниѥ',
	'deletedtext' => 'страница ⁖ $1 ⁖ поничьжєна ѥстъ ⁙
виждь ⁖ $2 ⁖ послѣдьнъ поничьжєниѩ дѣлꙗ',
	'dellogpage' => 'поничьжєниꙗ їсторїꙗ',
	'deletionlog' => 'поничьжєниꙗ їсторїꙗ',
	'deletecomment' => 'какъ съмꙑслъ :',
);

$messages['cv'] = array(
	'december' => 'раштав',
	'december-gen' => 'раштав уйăхĕн',
	'dec' => 'раш',
	'delete' => 'Кăларса пăрахасси',
	'deletethispage' => 'Хурат ăна',
	'disclaimers' => 'Яваплăха тивĕçтерменни',
	'disclaimerpage' => 'Project:Яваплăха тивĕçтерменни',
	'databaseerror' => 'Пĕлĕм пуххин йăнăшĕ',
	'dberrortext' => 'Пĕлĕм пуххине янă ыйтăвĕнче синтаксис йăнăшĕ пур.
Пĕлĕм пуххине янă юлашки ыйту:
<blockquote><tt>$1</tt></blockquote>
<tt>«$2»</tt> функци ыйтнă.
MySQL çак йăнăша тавăрнă <tt>«$3: $4»</tt>.',
	'dberrortextcl' => 'Пĕлĕм пуххине янă ыйтăвĕнче синтаксис йăнăшĕ пур.
Пĕлĕм пуххине янă юлашки ыйту:
«$1»
«$2» функци ыйтнă.
MySQL çак йăнăша тавăрнă «$3: $4».',
	'directorycreateerror' => '«$1» директорине тума май çук.',
	'deletedhist' => 'Кăларса пăрахнисен историйĕ',
	'difference' => '(Версисем хушшинчи улшăнусем)',
	'datedefault' => 'Палăртман чухнехи',
	'diff' => 'танл.',
	'disambiguations' => 'Нумай пĕлтерĕшлĕ статьясене кăтартакан страницăсем',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => "Çак статьясем '''нумай пĕлтерĕшле страницăсем'''çине куçараççĕ.
Унта куçарас вырăнне вĕсем кирлĕ страницăсем çине куçармалла пулĕ.<br />
Енчен те страница çинче [[MediaWiki:Disambiguationspage]] страницăра кăтартнă шаблон ятне вырнаçтарнă пулсан вăл нумай пĕлтерĕшлĕ страница шутланать.",
	'doubleredirects' => 'Икĕ хут куçаракансем',
	'deadendpages' => 'Ниăçта та урăх ертмен страницăсем',
	'deletepage' => 'Кăларса парахнă статьясем',
	'deletedtext' => '«$1» кăларса парахрăмăр.
Юлашки кăларса пăрахнă статьясен списокне курмашкăн кунта пăхăр: $2.',
	'dellogpage' => 'Кăларса пăрахнисем',
	'dellogpagetext' => 'Аяларах эсир юлашки кăларса пăрахнă статьясене куратăр.',
	'deletionlog' => 'кăларса пăрахнисем',
	'deletecomment' => 'Сăлтавĕ',
	'delete_and_move' => 'Кăларса пăрахса куçарасси',
	'delete_and_move_text' => '==Кăларса пăрахмалла==
[[:$1|«$1»]] ятлă страница пур. Урăх ят парас тесе ăна кăларса пăрахмалла-и?',
	'delete_and_move_confirm' => 'Ку страницăна чăнах та кăларса пăрахмалла',
	'delete_and_move_reason' => 'Урăх ят памашкăн кăларса парахнă',
	'deletedrevision' => '$1 кивĕ версине кăларса парахнă.',
	'deletedwhileediting' => 'Асăрхăр: эсир тӳрлетнĕ вăхăтра ку страницăна кăларса парахнă!',
);

$messages['cy'] = array(
	'december' => 'Rhagfyr',
	'december-gen' => 'Rhagfyr',
	'dec' => 'Rhag',
	'delete' => 'Dileu',
	'deletethispage' => 'Dileer y dudalen hon',
	'disclaimers' => 'Gwadiadau',
	'disclaimerpage' => 'Project:Gwadiad Cyffredinol',
	'databaseerror' => 'Gwall databas',
	'dberrortext' => 'Mae gwall cystrawen wedi taro\'r databas.
Efallai fod gwall yn y meddalwedd.
Y gofyniad olaf y trïodd y databas oedd:
<blockquote><tt>$1</tt></blockquote>
o\'r ffwythiant "<tt>$2</tt>".
Rhoddwyd y côd gwall "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Mae gwall cystrawen wedi taro\'r databas.
Y gofyniad olaf y trïodd y databas oedd:
"$1"
o\'r ffwythiant "$2".
Rhoddwyd y côd gwall "$3: $4<".',
	'directorycreateerror' => 'Wedi methu creu\'r cyfeiriadur "$1".',
	'deletedhist' => 'Hanes dilëedig',
	'difference' => '(Gwahaniaethau rhwng diwygiadau)',
	'difference-multipage' => '(Y gwahaniaeth rhwng y tudalennau)',
	'diff-multi' => '(Ni ddangosir {{PLURAL:$1|yr $1 diwygiad|yr $1 diwygiad|y $1 ddiwygiad|y $1 diwygiad|y $1 diwygiad|y $1 diwygiad}} rhyngol gan {{PLURAL:$2||un defnyddiwr|$2 ddefnyddiwr|$2 defnyddiwr|$2 o ddefnyddwyr|$2 o ddefnyddwyr}}.)',
	'diff-multi-manyusers' => '(Ni ddangosir {{PLURAL:$1|yr $1 diwygiad|yr $1 diwygiad|y $1 ddiwygiad|y $1 diwygiad|y $1 diwygiad|y $1 diwygiad}} rhyngol gan mwy na $2 {{PLURAL:$2|o ddefnyddwyr}}.)',
	'datedefault' => 'Dim dewisiad',
	'defaultns' => "Neu chwilio'r parthau isod:",
	'default' => 'rhagosodyn',
	'diff' => 'gwahan',
	'destfilename' => 'Enw ffeil y cyrchfan:',
	'duplicatesoffile' => "Mae'r {{PLURAL:$1||ffeil|$1 ffeil|$1 ffeil|$1 ffeil|$1 ffeil}} canlynol yn union debyg i'r ffeil hon ([[Special:FileDuplicateSearch/$2|rhagor o fanylion]]):",
	'download' => 'islwytho',
	'disambiguations' => "Tudalennau sy'n cysylltu â thudalennau gwahaniaethu",
	'disambiguationspage' => 'Template:Gwahaniaethu',
	'disambiguations-text' => "Mae'r tudalennau canlynol yn cynnwys un neu ragor o gysylltau wici, sydd yn cysylltu â '''thudalennau gwahaniaethu'''. Yn hytrach dylent arwain yn syth at yr erthygl briodol.<br />
Diffinir tudalen yn dudalen gwahaniaethu pan mae'n cynnwys un o'r nodiadau '[[MediaWiki:Disambiguationspage|tudalen gwahaniaethu]]'.",
	'doubleredirects' => 'Ailgyfeiriadau dwbl',
	'doubleredirectstext' => "Mae pob rhes yn cynnwys cysylltiad i'r ddau ail-gyfeiriad cyntaf, ynghyd â chyrchfan yr ail ailgyfeiriad. Fel arfer bydd hyn yn rhoi'r gwir dudalen y dylai'r tudalennau cynt gyfeirio ati.
Gosodwyd <del>llinell</del> drwy'r eitemau sydd eisoes wedi eu datrys.",
	'double-redirect-fixed-move' => "Symudwyd [[$1]], a'i droi'n ailgyfeiriad at [[$2]]",
	'double-redirect-fixed-maintenance' => 'Yn ailosod yr ailgyfeiriad dwbl o [[$1]] i [[$2]].',
	'double-redirect-fixer' => 'Y bot ailgyfeirio',
	'deadendpages' => 'Tudalennau heb gysylltiadau ynddynt',
	'deadendpagestext' => "Nid oes cysylltiad yn arwain at dudalen arall oddi wrth yr un o'r tudalennau isod.",
	'deletedcontributions' => 'Cyfraniadau defnyddiwr i dudalennau dilëedig',
	'deletedcontributions-title' => 'Cyfraniadau defnyddiwr i dudalennau dilëedig',
	'defemailsubject' => '{{SITENAME}} yn anfon e-bost oddi wrth y defnyddiwr "$1"',
	'deletepage' => 'Dileer y dudalen',
	'delete-confirm' => 'Dileu "$1"',
	'delete-legend' => 'Dileu',
	'deletedtext' => 'Mae "$1" wedi\'i ddileu.
Gwelwch y $2 am gofnod o\'r dileuon diweddar.',
	'dellogpage' => 'Lòg dileuon',
	'dellogpagetext' => "Ceir rhestr isod o'r dileadau diweddaraf.",
	'deletionlog' => 'lòg dileuon',
	'deletecomment' => 'Rheswm:',
	'deleteotherreason' => 'Rheswm arall:',
	'deletereasonotherlist' => 'Rheswm arall',
	'deletereason-dropdown' => "*Rhesymau arferol dros ddileu
** Ar gais yr awdur
** Torri'r hawlfraint
** Fandaliaeth",
	'delete-edit-reasonlist' => 'Golygu rhestr y rhesymau dros ddileu',
	'delete-toobig' => "Cafwyd dros $1 {{PLURAL:$1|o olygiadau}} i'r dudalen hon.
Cyfyngwyd ar y gallu i ddileu tudalennau sydd wedi eu golygu cymaint â hyn, er mwyn osgoi amharu ar weithrediad databas {{SITENAME}} yn ddamweiniol.",
	'delete-warning-toobig' => "Cafwyd dros $1 {{PLURAL:$1|o olygiadau}} i'r dudalen hon.
Gallai dileu tudalen, gyda hanes golygu cymaint â hyn iddi, beri dryswch i weithrediadau'r databas ar {{SITENAME}}; ewch ati'n ofalus.",
	'databasenotlocked' => "Nid yw'r gronfa ddata ar glo.",
	'delete_and_move' => 'Dileu a symud',
	'delete_and_move_text' => "==Angen dileu==

Mae'r erthygl \"[[:\$1]]\" yn bodoli'n barod. Ydych chi am ddileu'r erthygl er mwyn cwblhau'r symudiad?",
	'delete_and_move_confirm' => "Ie, dileu'r dudalen",
	'delete_and_move_reason' => 'Wedi\'i dileu er mwyn gallu symud y dudalen "[[$1]]" i gymryd ei lle',
	'djvu_page_error' => 'Y dudalen DjVu allan o amrediad',
	'djvu_no_xml' => 'Ddim yn gallu mofyn XML ar gyfer ffeil DjVu',
	'deletedrevision' => 'Wedi dileu hen ddiwygiad $1.',
	'days' => '{{PLURAL:$1||$1 diwrnod|$1 ddiwrnod|$1 diwrnod|$1 diwrnod|$1 diwrnod}}',
	'deletedwhileediting' => "'''Rhybudd''': Dilëwyd y dudalen wedi i chi ddechrau ei golygu!",
	'descending_abbrev' => 'am lawr',
	'duplicate-defaultsort' => 'Rhybudd: Mae\'r allwedd trefnu diofyn "$2" yn gwrthwneud yr allwedd trefnu diofyn blaenorol "$1".',
	'dberr-header' => 'Mae problem gan y wici hwn',
	'dberr-problems' => "Mae'n ddrwg gennym! Mae'r wefan hon yn dioddef anawsterau technegol.",
	'dberr-again' => 'Oedwch am ychydig funudau cyn ceisio ail-lwytho.',
	'dberr-info' => '(Ni ellir cysylltu â gweinydd y bas data: $1)',
	'dberr-usegoogle' => 'Yn y cyfamser gallwch geisio chwilio gyda Google.',
	'dberr-outofdate' => "Sylwch y gall eu mynegeion o'n cynnwys fod ar ei hôl hi.",
	'dberr-cachederror' => "Dyma gopi o'r dudalen a ofynnwyd amdani, a dynnwyd o'r celc. Mae'n bosib nad y fersiwn diweddaraf yw'r copi hwn.",
);

$messages['da'] = array(
	'december' => 'december',
	'december-gen' => 'decembers',
	'dec' => 'dec',
	'delete' => 'Slet',
	'deletethispage' => 'Slet side',
	'disclaimers' => 'Forbehold',
	'disclaimerpage' => 'Project:Generelle forbehold',
	'databaseerror' => 'Databasefejl',
	'dberrortext' => 'Der er opstået en syntaksfejl i en databaseforespørgsel.
Det kan tyde på en fejl i softwaren.
Den sidst forsøgte databaseforespørgsel var:
<blockquote><tt>$1</tt></blockquote>
fra funktionen "<tt>$2</tt>".
Databasen returnerede fejlen "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Der er opstået en syntaksfejl i en databaseforespørgsel.
Den seneste forsøgte databaseforespørgsel var:
"$1"
fra funktionen "$2".
Databasen returnerede fejlen "$3: $4"',
	'directorycreateerror' => 'Kunne ikke oprette kataloget "$1".',
	'deletedhist' => 'Slettet historik',
	'difference' => '(Forskel mellem versioner)',
	'difference-multipage' => '(Forskel mellem sider)',
	'diff-multi' => '({{PLURAL:$1|En mellemliggende version|$1 mellemliggende versioner}} af {{PLURAL:$2|en bruger|$2 brugere}} ikke vist)',
	'diff-multi-manyusers' => '({{PLURAL:$1|En mellemliggende version|$1 mellemliggende versioner}} af mere end $2 {{PLURAL:$2|bruger|brugere}} ikke vist)',
	'datedefault' => 'Ingen præference',
	'defaultns' => 'Ellers søg i disse navnerum:',
	'default' => 'standard',
	'diff' => 'forskel',
	'destfilename' => 'Nyt filnavn:',
	'duplicatesoffile' => 'Følgende {{PLURAL:$1|fil er en dublet|filer er dubletter}} af denne fil ([[Special:FileDuplicateSearch/$2|flere detaljer]]):',
	'download' => 'DownloadHerunterladen',
	'disambiguations' => 'Sider, der henviser til flertydige titler',
	'disambiguationspage' => 'Template:Flertydig',
	'disambiguations-text' => 'De følgende sider henviser til en flertydig titel. De bør henvise direkte til det passende emne i stedet. En side behandles som en side med en flertydig titel hvis den bruger en skabelon som er henvist til fra [[MediaWiki:Disambiguationspage]].',
	'doubleredirects' => 'Dobbelte omdirigeringer',
	'doubleredirectstext' => 'Dette er en liste over sider som omdirigerer til andre omdirigeringssider.
Hver linje indeholder henvisninger til den første og den anden omdirigering, såvel som til målet for den anden omdirigering som sædvanligvis er den "rigtige" målside som den første omdirigering burde henvise til.
<del>Overstregede</del> poster er rettede.',
	'double-redirect-fixed-move' => '[[$1]] blev flyttet og er nu en omdirigering til [[$2]]',
	'double-redirect-fixed-maintenance' => 'Rettelse af dobbelt omdirigering fra [[$1]] til [[$2]].',
	'double-redirect-fixer' => 'Omdirigerings-retter',
	'deadendpages' => 'Blindgydesider',
	'deadendpagestext' => 'De følgende sider henviser ikke til andre sider i denne wiki.',
	'deletedcontributions' => 'slettede brugerbidrag',
	'deletedcontributions-title' => 'Slettede brugerbidrag',
	'defemailsubject' => '{{SITENAME}}-email fra brugeren "$1"',
	'deletepage' => 'Slet side',
	'delete-confirm' => 'Slet "$1"',
	'delete-legend' => 'Slet',
	'deletedtext' => '"$1" er slettet. Se $2 for en fortegnelse over de nyeste sletninger.',
	'dellogpage' => 'Sletningslog',
	'dellogpagetext' => 'Herunder vises de nyeste sletninger. Alle tider er serverens tid.',
	'deletionlog' => 'sletningslog',
	'deletecomment' => 'Begrundelse:',
	'deleteotherreason' => 'Anden/uddybende begrundelse:',
	'deletereasonotherlist' => 'Anden begrundelse',
	'deletereason-dropdown' => '
*Hyppige sletningsårsager
** Efter forfatters ønske
** Overtrædelse af ophavsret
** Hærværk',
	'delete-edit-reasonlist' => 'Rediger sletningsårsager',
	'delete-toobig' => 'Denne side har en stor historik, over {{PLURAL:$1|en version|$1 versioner}}. Sletning af sådanne sider er begrænset blevet for at forhindre utilsigtet forstyrrelse af {{SITENAME}}.',
	'delete-warning-toobig' => 'Denne side har en stor historik, over {{PLURAL:$1|en version|$1 versioner}} versioner, slettes den kan det forstyrre driften af {{SITENAME}}, gå forsigtigt frem.',
	'databasenotlocked' => 'Databasen er ikke spærret.',
	'delete_and_move' => 'Slet og flyt',
	'delete_and_move_text' => '==Sletning nødvendig==

Artiklen "[[:$1]]" eksisterer allerede. Vil du slette den for at gøre plads til flytningen?',
	'delete_and_move_confirm' => 'Ja, slet siden',
	'delete_and_move_reason' => 'Slettet for at gøre plads til flytning fra "[[$1]]"',
	'djvu_page_error' => 'DjVu-side udenfor sideområdet',
	'djvu_no_xml' => 'XML-data kan ikke hentes til DjVu-filen',
	'deletedrevision' => 'Slettede gammel version $1',
	'days' => '{{PLURAL: $1|$1 dag|$1 dage}}',
	'deletedwhileediting' => 'Bemærk: Det blev forsøgt at slette denne side, efter at du var begyndt, at ændre den!
Kig i [{{fullurl:Special:Log|type=delete&page=}}{{FULLPAGENAMEE}} slette-loggen],
hvorfor siden blev slettet. Hvis du gemmer siden bliver den oprettet igen.',
	'descending_abbrev' => 'ned',
	'duplicate-defaultsort' => 'Advarsel: Standardsorteringsnøglen "$2" tilsidesætter den tidligere sorteringsnøgle "$1".',
	'dberr-header' => 'Wikien har et problem',
	'dberr-problems' => 'Undskyld! Siden har tekniske problemer.',
	'dberr-again' => 'Prøv at vente et par minutter og opdater så siden igen.',
	'dberr-info' => '(Kan ikke komme i kontakt med databaseserveren: $1)',
	'dberr-usegoogle' => 'Du kan prøve at søge med Google imens.',
	'dberr-outofdate' => 'Bemærk at deres indeks over vores sider kan være forældet.',
	'dberr-cachederror' => 'Det følgende er en mellemlagret kopi af den forespurgte side. Den kan være forældet.',
);

$messages['de'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezembers',
	'dec' => 'Dez.',
	'delete' => 'Löschen',
	'deletethispage' => 'Diese Seite löschen',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Datenbankfehler',
	'dberrortext' => 'Es ist ein Datenbankfehler aufgetreten.
Der Grund kann ein Programmierfehler sein.
Die letzte Datenbankabfrage lautete:
<blockquote><tt>$1</tt></blockquote>
aus der Funktion „<tt>$2</tt>“.
Die Datenbank meldete den Fehler „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Es gab einen Syntaxfehler in der Datenbankabfrage.
Die letzte Datenbankabfrage lautete: „$1“ aus der Funktion „<tt>$2</tt>“.
Die Datenbank meldete den Fehler: „<tt>$3: $4</tt>“.',
	'directorycreateerror' => 'Das Verzeichnis „$1“ konnte nicht angelegt werden.',
	'deletedhist' => 'Gelöschte Versionen',
	'difference' => '(Unterschied zwischen Versionen)',
	'difference-multipage' => '(Unterschied zwischen Seiten)',
	'diff-multi' => '({{PLURAL:$1|Eine dazwischenliegende Version|$1 dazwischenliegende Versionen}} von {{PLURAL:$2|einem Benutzer|$2 Benutzern}} {{PLURAL:$1|wird|werden}} nicht angezeigt)',
	'diff-multi-manyusers' => '({{PLURAL:$1|$1 dazwischenliegende Versionen}} von mehr als {{PLURAL:$2|$2 Benutzern}}, die nicht angezeigt werden)',
	'datedefault' => 'Standard',
	'defaultns' => 'Anderenfalls in diesen Namensräumen suchen:',
	'default' => 'Voreinstellung',
	'diff' => 'Unterschied',
	'destfilename' => 'Zielname:',
	'duplicatesoffile' => 'Die {{PLURAL:$1|folgende Datei ist ein Duplikat|folgenden $1 Dateien sind Duplikate}} dieser Datei ([[Special:FileDuplicateSearch/$2|weitere Details]]):',
	'download' => 'Herunterladen',
	'disambiguations' => 'Seiten die auf Begriffsklärungsseiten verlinken',
	'disambiguationspage' => 'Template:Begriffsklärung',
	'disambiguations-text' => 'Die folgenden Seiten verlinken auf eine Seite zur Begriffsklärung. Sie sollten statt dessen auf die eigentlich gemeinte Seite verlinken.

Eine Seite gilt als Begriffsklärungsseite, wenn sie eine der in [[MediaWiki:Disambiguationspage]] aufgeführte(n) Vorlage(n) einbindet.<br />
Links aus Namensräumen werden hier nicht aufgelistet.',
	'doubleredirects' => 'Doppelte Weiterleitungen',
	'doubleredirectstext' => 'Diese Liste enthält Weiterleitungen, die auf Weiterleitungen verlinken.
Jede Zeile enthält Links zur ersten und zweiten Weiterleitung sowie dem Ziel der zweiten Weiterleitung, welches für gewöhnlich die gewünschte Zielseite ist, auf die bereits die erste Weiterleitung zeigen sollte.
<del>Durchgestrichene</del> Einträge wurden bereits erfolgreich bearbeitet.',
	'double-redirect-fixed-move' => '[[$1]] wurde verschoben und leitet nun nach [[$2]] weiter.',
	'double-redirect-fixed-maintenance' => 'Bereinigung der doppelten Weiterleitung von [[$1]] nach [[$2]].',
	'double-redirect-fixer' => 'RedirectBot',
	'deadendpages' => 'Nicht verlinkende Seiten',
	'deadendpagestext' => 'Die folgenden Seiten verweisen nicht auf andere Seiten von {{SITENAME}}.',
	'deletedcontributions' => 'Gelöschte Beiträge',
	'deletedcontributions-title' => 'Gelöschte Beiträge',
	'defemailsubject' => '{{SITENAME}} - E-Mail von Benutzer „$1“',
	'deletepage' => 'Seite löschen',
	'delete-confirm' => 'Löschen von „$1“',
	'delete-legend' => 'Löschen',
	'deletedtext' => '„$1“ wurde gelöscht. Im $2 findest du eine Liste der letzten Löschungen.',
	'dellogpage' => 'Lösch-Logbuch',
	'dellogpagetext' => 'Dies ist das Logbuch der gelöschten Seiten und Dateien.',
	'deletionlog' => 'Lösch-Logbuch',
	'deletecomment' => 'Grund:',
	'deleteotherreason' => 'Anderer/ergänzender Grund:',
	'deletereasonotherlist' => 'Anderer Grund',
	'deletereason-dropdown' => '* Allgemeine Löschgründe
** Wunsch des Autors
** Urheberrechtsverletzung
** Vandalismus',
	'delete-edit-reasonlist' => 'Löschgründe bearbeiten',
	'delete-toobig' => 'Diese Seite hat mit mehr als $1 {{PLURAL:$1|Version|Versionen}} eine sehr lange Versionsgeschichte. Das Löschen solcher Seiten wurde eingeschränkt, um eine versehentliche Überlastung der Server zu verhindern.',
	'delete-warning-toobig' => 'Diese Seite hat mit mehr als $1 {{PLURAL:$1|Version|Versionen}} eine sehr lange Versionsgeschichte. Das Löschen kann zu Störungen im Datenbankbetrieb führen.',
	'databasenotlocked' => 'Die Datenbank ist nicht gesperrt.',
	'delete_and_move' => 'Löschen und Verschieben',
	'delete_and_move_text' => '== Löschung erforderlich ==

Die Seite „[[:$1]]“ existiert bereits. Möchtest du diese löschen, um die Seite verschieben zu können?',
	'delete_and_move_confirm' => 'Ja, Seite löschen',
	'delete_and_move_reason' => 'gelöscht, um Platz für die Verschiebung von „[[$1]]“ zu machen',
	'djvu_page_error' => 'DjVu-Seite außerhalb des Seitenbereichs',
	'djvu_no_xml' => 'XML-Daten können für die DjVu-Datei nicht abgerufen werden',
	'deletedrevision' => 'alte Version $1 gelöscht',
	'days' => '{{PLURAL:$1|$1 Tag|$1 Tage}}',
	'deletedwhileediting' => 'Achtung: Diese Seite wurde gelöscht, nachdem du angefangen hast sie zu bearbeiten!
Im [{{fullurl:{{#special:Log}}|type=delete&page={{FULLPAGENAMEE}}}} Lösch-Logbuch] findest du den Grund für die Löschung. Wenn du die Seite speicherst, wird sie neu angelegt.',
	'descending_abbrev' => 'ab',
	'duplicate-defaultsort' => 'Achtung: Der Sortierungsschlüssel „$2“ überschreibt den vorher verwendeten Schlüssel „$1“.',
	'dberr-header' => 'Dieses Wiki hat ein Problem',
	'dberr-problems' => 'Entschuldigung. Diese Seite hat momentan technische Schwierigkeiten.',
	'dberr-again' => 'Warte einige Minuten und versuche dann neu zu laden.',
	'dberr-info' => '(Kann keine Verbindung zum Datenbank-Server herstellen: $1)',
	'dberr-usegoogle' => 'Du könntest in der Zwischenzeit mit Google suchen.',
	'dberr-outofdate' => 'Beachte, dass der Suchindex unserer Inhalte bei Google veraltet sein kann.',
	'dberr-cachederror' => 'Folgendes ist eine Kopie des Caches der angeforderten Seite und kann veraltet sein.',
	'discuss' => 'Diskussion',
);

$messages['de-at'] = array(
	'december' => 'Dezember',
);

$messages['de-ch'] = array(
	'defaultns' => 'In diesen Namensräumen soll standardmässig gesucht werden:',
	'djvu_page_error' => 'DjVu-Seite ausserhalb des Seitenbereichs',
);

$messages['de-formal'] = array(
	'deletedtext' => '„<nowiki>$1</nowiki>“ wurde gelöscht. Im $2 finden Sie eine Liste der letzten Löschungen.',
	'delete_and_move_text' => '== Löschung erforderlich ==

Die Seite „[[:$1]]“ existiert bereits. Möchten Sie diese löschen, um die Seite verschieben zu können?',
	'deletedwhileediting' => 'Achtung: Diese Seite wurde gelöscht, nachdem Sie angefangen haben sie zu bearbeiten!
Im [{{fullurl:{{#special:Log}}|type=delete&page={{FULLPAGENAMEE}}}} Lösch-Logbuch] finden Sie den Grund für die Löschung.
Wenn Sie die Seite speichern, wird sie neu angelegt.',
	'dberr-again' => 'Warten Sie einige Minuten und versuchen Sie dann neu zuladen.',
	'dberr-usegoogle' => 'Sie könnten in der Zwischenzeit mit Google suchen.',
	'dberr-outofdate' => 'Beachten Sie, dass der Suchindex unserer Inhalte bei Google veraltet sein kann.',
);

$messages['de-weigsbrag'] = array(
	'december' => 'Desemb',
	'december-gen' => 'Desembs',
	'dec' => 'Des.',
	'delete' => 'Lösch',
	'deletethispage' => 'Dose Seid lösch',
	'disclaimers' => 'Imbresum',
	'disclaimerpage' => 'Project:Imbresum',
	'databaseerror' => 'Wehl in dose Dadesbang',
	'dberrortext' => 'Haddar eines Syndagswehl in dose Dadesbangabwräg geb.
Dose ledsdes Dadesbangabwräg wesdar: <blockquote><tt>$1</tt></blockquote> aus dose Wungsion „<tt>$2</tt>“.
MySQL haddar dose Wehl „<tt>$3: $4</tt>“ meld.',
	'dberrortextcl' => 'Haddar eines Syndagswehl in dose Dadesbangabwräg geb.
Dose ledsdes Dadesbangabwräg wesdar: „$1“ aus dose Wungsion „<tt>$2</tt>“.
MySQL haddar meld dose Wehl: „<tt>$3: $4</tt>“.',
	'directorycreateerror' => 'Dose Werseig „$1“ haddar noggs gön anleg.',
	'deletedrev' => '[gelöschdes]',
	'deletedhist' => 'Gelöschdes Wersiones',
	'difference' => '(Undschied swisch Wersiones)',
	'diff-multi' => '(Dose Wersionswergleig {{PLURAL:$1|1 daswisch liegdares Wersion|$1 daswisch liegdares Wersiones}} mid einbesiehdar.)',
	'dateformat' => 'Dadumeswormad',
	'datedefault' => 'Schdandard',
	'datetime' => 'Dadum und Dseid',
	'defaultns' => 'In dose Namesräumes schdandardmäs sol sug:',
	'default' => 'Woreinschdel',
	'diff' => 'Undschied',
	'destfilename' => 'Sielnam:',
	'duplicatesoffile' => 'Dose {{PLURAL:$1|wolgendes Dadei eines Dubligad|wolgendes $1 Dadeies Dubligades}} won dose Dadei sei:',
	'download' => 'Rundlad',
	'disambiguations' => 'Begriwsglärseides',
	'disambiguationspage' => 'Template:Begriwsglär',
	'disambiguations-text' => 'Dose wolgendes Seides auw eines Seid su Begriwsglär werweis. Schdadd dose sol dose auw dose Seid wo eig mein werweis.<br />Eines Seid als Begriwsglärseid behand, wan [[MediaWiki:Disambiguationspage]] auw dose werweis.<br />Werweises aus Namesräumes noggs auw dose auwlisd.',
	'doubleredirects' => 'Dobbeldes Weidleides',
	'doubleredirects-summary' => 'In dose Lisd seddar Weidleides, wo auw eines weideres Weidleid werweis.
In jedes Dseil Werweises sei su dose ersdes und suaides Weidleid und dose Siel won dose suaides Weidleid, wo normales dose gewünschdes Sielseid sei,
wo aba schon dose ersdes Weidleid sol drauwseig, werschdeddar?.',
	'doubleredirectstext' => '',
	'deadendpages' => 'Sagggassesseides',
	'deadendpages-summary' => 'Dose Schbesialseid eines Lisd won Seides seig, wo hadddar noggs Werweises auw anderes Seides od haddar nur Werweises auw Seides wo nog gar noggs geb.',
	'deadendpagestext' => '',
	'defemailsubject' => '{{SITENAME}}-I-Mehl',
	'deletepage' => 'Seid lösch',
	'delete-confirm' => 'Lösch won „$1“',
	'delete-legend' => 'Lösch',
	'deletedtext' => '„<nowiki>$1</nowiki>“ haddar lösch. In $2 eines Lisd mid dose ledsdes Lösches wend.',
	'deletedarticle' => 'haddar „[[$1]]“ lösch',
	'dellogpage' => 'Lösch-Logbug',
	'dellogpagetext' => 'Dose dose Logbug sei won gelöschdes Seides und Dadeies.',
	'deletionlog' => 'Lösch-Logbug',
	'deletecomment' => 'Grund won Lösch:',
	'deleteotherreason' => 'Anderes/ergänsendes Grund:',
	'deletereasonotherlist' => 'Anderes Grund',
	'deletereason-dropdown' => '
* Algemeines Löschgründes
** Wunsch won dose Audor
** Urhebregdswerleds
** Wandalism',
	'delete-edit-reasonlist' => 'Löschgründes bearbeid',
	'delete-toobig' => 'Dose Seid mid mehres wie $1 Wersiones haddar bruddales langes Wersionsgeschigd. Dose Lösch won solges Seides haddar einschräg, das noggs aus Werseddar dose Sörw üblasd.',
	'delete-warning-toobig' => 'Dose Seid mid mehres wie $1 Wersiones haddar bruddales langes Wersionsgeschigd. Dose Lösch gön mag das haddar Schdöres in dose Dadesbangbedrieb.',
	'databasenotlocked' => 'Dose Dadesbang noggs geschberdes sei.',
	'delete_and_move' => 'Lösch und Werschieb',
	'delete_and_move_text' => '==Sielseid gebdar, lösch?==

Dose Seid „[[$1]]“ schon geb. Wol dose lösch, das gön dose Seid werschieb?',
	'delete_and_move_confirm' => 'Sielseid wür dose Werschieb lösch',
	'delete_and_move_reason' => 'haddar lösch, das haddar Blads wür Werschieb',
	'djvu_page_error' => 'DjVu-Seid aushalb won Seidesbereig',
	'djvu_no_xml' => 'XML-Dades noggs gön wür dose DjVu-Dadei abruw',
	'deletedrevision' => 'aldes Wersion: $1',
	'deletedwhileediting' => '<span class="error">Obagd: Dose Seid haddar lösch, nagdem haddar anwäng su bearbeid dose!
Schauddar in dose [{{fullurl:Special:Log|type=delete&page=}}{{FULLPAGENAMEE}} Lösch-Logbug],
wies haddar lösch dose Seid. Wan dose Seid schbeig, dose neues anleg.</span>',
	'descending_abbrev' => 'ab',
);

$messages['diq'] = array(
	'december' => 'Kanun',
	'december-gen' => 'Kanuni',
	'dec' => 'Kan',
	'delete' => 'Bestere',
	'deletethispage' => 'Ena pele bestere',
	'disclaimers' => 'Redê mesulêti',
	'disclaimerpage' => 'Project:Reddê mesuliyetê bıngey',
	'databaseerror' => 'Xeta serveri',
	'dberrortext' => 'Rêzê vateyê database de xeta bı.
No xeta belka software ra yo.
"<tt>$2</tt>" ra pers kerdışê peyin:
<blockquote><tt>$1</tt></blockquote>.
Database yo ke xeta dayo "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Persê rêzê vateyê database de xeta bı.
Persê databaseyê peyin:
"$1"
Fonksiyono ke şuxulyo "$2".
Mesacê ke database dayo "$3: $4"',
	'directorycreateerror' => '"$1" rêzkiyê ey nêvırazya',
	'deletedhist' => 'tarixê hewna şiyaye',
	'difference' => '(Ferqê revizyonan)',
	'diff-multi' => '({{PLURAL:$1|Yew revizyono miyanên|$1 revizyonê miyanêni}} terefê {{PLURAL:$2|yew karberi|$2 karberan}} nêmocno)',
	'datedefault' => 'Tercih çıniyo',
	'defaultns' => 'Eke heni, enê cayanê namey de cı geyre (sae ke):',
	'default' => 'default',
	'diff' => 'ferq',
	'destfilename' => 'Destînasyonê nameyêdosya',
	'duplicatesoffile' => 'a {{PLURAL:$1|dosya|$1 dosya}}, kopyayê na dosyayi ([[Special:FileDuplicateSearch/$2|teferruati]]):',
	'download' => 'bar ke',
	'disambiguations' => 'Pelayanê tam beli niyo',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => 'satıro ewwil de ke peli ca genî; gıreyê pelê ciya-manayi mocneni. İkinci sırada <br />tiya de [[MediaWiki:Disambiguationspage]] gani heme gıreyê şablonê ciya-manayan  re gıre bıdiyo',
	'doubleredirects' => 'redireksiyonê herdi',
	'doubleredirectstext' => 'no pel pelê ray motışani liste keno.
gıreyê her satıri de gıreyi; raş motışê yewın u dıyıni esto.
<del>serê ey nuşteyi</del> safi biye.',
	'double-redirect-fixed-move' => '[[$1]] kırışiya, hıni ray dana [[$2]] no pel',
	'double-redirect-fixer' => 'Fixerî redirek bike',
	'deadendpages' => 'pelê ke pelê binan re gırey nêeşto',
	'deadendpagestext' => 'Ena pelan ke {{SITENAME}} de zerrî ey de link çini yo.',
	'deletedcontributions' => 'Îştirakê karberî wederna',
	'deletedcontributions-title' => 'Îştirakê karberî wederna',
	'defemailsubject' => '{{SITENAME}} e-posta',
	'deletepage' => 'Pele bıestere',
	'delete-confirm' => '"$1" bıestere',
	'delete-legend' => 'Bıestere',
	'deletedtext' => '"$1" biya wedariya.
Qe qeydê wedarnayışi, $2 bevinin.',
	'dellogpage' => 'Logê bıesterışi',
	'dellogpagetext' => 'listeya cêrıni heme qaydê hewn a kerdeyan o.',
	'deletionlog' => 'qaydê hewnakerdışani',
	'deletecomment' => 'Sebeb:',
	'deleteotherreason' => 'Sebebo bin:',
	'deletereasonotherlist' => 'Sebebo bin',
	'deletereason-dropdown' => '*sebebê hewnakerdışê pêroyî
** talebê nuştekari
** ihlalê heqê telifi
** Vandalizm',
	'delete-edit-reasonlist' => 'sebebê hewn a kerdışani bıvurn',
	'delete-toobig' => 'no pel, pê $1 {{PLURAL:$1|tene vuriyayiş|tene vuriyayiş}}i wayirê yew tarixo kehen o.
qey hewna nêşiyayişi wina pelani u {{SITENAME}}nêxerebnayişê keyepeli yew hed niyaya ro.',
	'delete-warning-toobig' => 'no pel wayirê tarixê vurnayiş ê derg o, $1 {{PLURAL:$1|revizyonê|revizyonê}} seri de.
hewn a kerdışê ıney {{SITENAME}} şuxul bıne gırano;
bı diqqet dewam kerê.',
	'databasenotlocked' => 'Database a nibiya.',
	'delete_and_move' => 'Biestere u bere',
	'delete_and_move_text' => '==gani hewn a bıbıo/bıesteriyo==

" no [[:$1]]" name de yew pel ca ra esto. şıma wazeni pê hewn a kerdışê ey peli vurnayişê nameyi bıkeri?',
	'delete_and_move_confirm' => 'Ya, ena pele biestere',
	'delete_and_move_reason' => 'qey vurnayişê nameyi esteriya',
	'djvu_page_error' => 'pelê DjVuyi bêşumulo',
	'djvu_no_xml' => 'Qe DjVu nieşkenî XML fetch bikî',
	'deletedrevision' => 'Veriyono kihan $1 wederna',
	'deletedwhileediting' => "'''Teme''': Ena pele  verniyê ti de eseteriyaya!",
	'descending_abbrev' => 'nızm',
	'duplicate-defaultsort' => '\'\'\'Teme:\'\'\' Tuşê default sort "$2" sero tuşê default sort "$1"î ra şino.',
	'dberr-header' => 'Ena Wiki de yew ğelet esta',
	'dberr-problems' => 'Qusir ma mevin! Site ma de nika ğeletê teknikî  esto.',
	'dberr-again' => 'Yew di dekika vinder u hin bar bike.',
	'dberr-info' => '(Nieşkenî serverê databaseyî bireso: $1)',
	'dberr-usegoogle' => 'Ti eşkeno hem zi ser Google de bigêre.',
	'dberr-outofdate' => 'Note bike ke belki îdeksê tedesteyî rocaniye niyo.',
	'dberr-cachederror' => 'Pel ke ti wazeno yew kopyayê cacheyî ay esto, ay belki rocaniyeyo.',
);

$messages['dsb'] = array(
	'december' => 'december',
	'december-gen' => 'decembra',
	'dec' => 'dec',
	'delete' => 'Wulašowaś',
	'deletethispage' => 'Toś ten bok wulašowaś',
	'disclaimers' => 'Impresum',
	'disclaimerpage' => 'Project:impresum',
	'databaseerror' => 'Zmólka w datowej bance',
	'dberrortext' => 'Syntaktiska zmólka pśi wótpšašowanju datoweje banki nastata.
To by mógło zmólki w softwarje byś.
Slědne wótpšašowanje jo było:
<blockquote><tt>$1</tt></blockquote>
z funkcije "<tt>$2</tt>".
Datowa banka jo zmólku "<tt>$3: $4</tt>" wrośiła.',
	'dberrortextcl' => 'Syntaktiska zmólka pśi wótpšašowanju datoweje banki nastata.
Slědne wopytane wótpšašowanje jo było:
"$1"
z funkcije "$2".
Datowa banka jo zmólku "$3: $4" wrośiła',
	'directorycreateerror' => 'Njejo było móžno, zapis „$1“ wutwóriś.',
	'delete-hook-aborted' => 'Wulašowanje pśez kokulu pśetergnjone.
Njejo žedno wujasnjenje.',
	'defaultmessagetext' => 'Standardny tekst powěźeńki',
	'deletedhist' => 'wulašowane stawizny',
	'difference-title' => '$1: Rozdźěl mjazy wersijami',
	'difference-title-multipage' => '$1 a $2: Rozdźěl mjazy bokami',
	'difference-multipage' => '(Rozdźěl mjazy bokami)',
	'diff-multi' => '({{PLURAL:$1|Jadna mjazywersija|$1 mjazywersiji|$1 mjazywersije|$1 mjazywersijow}} wót {{PLURAL:$2|jadnogo wužywarja|$2 wužywarjowu|$2 wužywarjow|$2 wužywarjow}} {{PLURAL:$1|njepokazana|njepokazanej|njepokazane|njepokazane}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Jadna mjazywersija|$1 mjazywersiji|$1 mjazywersije|$1 mjazywersijow}} wót wěcej ako {{PLURAL:$2|jadnogo wužywarja|$2 wužywarjowu|$2 wužywarjow|$2 wužywarjow}} {{PLURAL:$1|njepokazana|njepokazanej|njepokazane|njepokazane}})',
	'datedefault' => 'Standard',
	'defaultns' => 'Howac w toś tych mjenjowych rumach pytaś:',
	'default' => 'Standard',
	'diff' => 'rozdźěl',
	'destfilename' => 'Celowe mě:',
	'duplicatesoffile' => '{{PLURAL:$1|Slědujuca dataja jo duplikat|Slědujucej $1 dataji stej duplikata|Slědujuce dataje $1 su duplikaty|Slědujucych $1 datajow jo duplikaty}} toś teje dataje ([[Special:FileDuplicateSearch/$2|dalšne drobnostki]])::',
	'download' => 'Ześěgnuś',
	'disambiguations' => 'Boki, kótarež wótkazuju na boki wěcejzmysłowosći',
	'disambiguationspage' => 'Template:Rozjasnjenje zapśimjeśow',
	'disambiguations-text' => 'Slědujuce boki wótkazuju na bok za rozjasnjenje zapśimjeśow.
Wótkazujśo lubjej na pótrjefjony bok.<br />
Bok wobjadnawa se ako bok wujasnjenja zapśimjeśa, gaž wótkazujo na nju [[MediaWiki:Disambiguationspage]].',
	'doubleredirects' => 'Dwójne dalejpósrědnjenja',
	'doubleredirectstext' => 'Toś ten bok nalicujo boki, kótarež dalej pósrědnjaju na druge dalejpósrědnjenja.
Kužda smužka wopśimjejo wótkaze na prědne a druge dalejpósrědnjenje a teke na cel drugego dalejpósrědnjenja, což jo w normalnem paźe "napšawdny" celowy bok, na kótaryž by mógło prědne dalejpósrědnjenje pokazaś. <del>Pśešmarnjone</del> zapiski su južo wobstarane.',
	'double-redirect-fixed-move' => '[[$1]] jo se pśesunuł, jo něnto dalejposrědnjenje do [[$2]]',
	'double-redirect-fixed-maintenance' => 'Dwójne dalejpósrědnjenje wót [[$1]] do [[$2]] se pórěźa.',
	'double-redirect-fixer' => 'Pórěźaŕ dalejpósrědnjenjow',
	'deadendpages' => 'Nastawki bźez wótkazow',
	'deadendpagestext' => 'Slědujuce boki njewótkazuju na druge boki we {{GRAMMAR:lokatiw|{{SITENAME}}}}.',
	'deletedcontributions' => 'Wulašowane wužywarske pśinoski',
	'deletedcontributions-title' => 'Wulašowane wužywarske pśinoski',
	'defemailsubject' => '{{SITENAME}} - e-mail wót wužywarja "$1"',
	'deletepage' => 'Bok wulašowaś',
	'delete-confirm' => '„$1“ lašowaś',
	'delete-legend' => 'Lašowaś',
	'deletedtext' => '„$1“ jo se wulašował(a/o). W $2 namakajoš lisćinu slědnych wulašowanjow.',
	'dellogpage' => 'Protokol wulašowanjow',
	'dellogpagetext' => 'How jo protokol wulašowanych bokow a datajow.',
	'deletionlog' => 'protokol wulašowanjow',
	'deletecomment' => 'Pśicyna:',
	'deleteotherreason' => 'Druga/pśidatna pśicyna:',
	'deletereasonotherlist' => 'Druga pśicyna',
	'deletereason-dropdown' => '* Powšykne pśicyny za lašowanja
** Žycenje awtora
** Pśekśiwjenje stworiśelskego pšawa
** Wandalizm',
	'delete-edit-reasonlist' => 'Pśicyny za lašowanje wobźěłaś',
	'delete-toobig' => 'Toś ten bok ma z wěcej nježli $1 {{PLURAL:$1|wersiju|wersijomaj|wersijami|wersijami}} dłujku historiju. Lašowanje takich bokow bu wobgranicowane, aby wobškoźenju {{GRAMMAR:genitiw|{{SITENAME}}}} z pśigódy zajźowało.',
	'delete-warning-toobig' => 'Toś ten bok ma z wěcej ako $1 {{PLURAL:$1|wersiju|wersijomaj|wersijami|wersijami}} dłujke stawizny. Jich wulašowanje móžo źěło datoweje banki na {{SITENAME}} kazyś;
póstupujśo z glědanim.',
	'databasenotlocked' => 'Datowa banka njejo zamknjona.',
	'delete_and_move' => 'Wulašowaś a pśesunuś',
	'delete_and_move_text' => '==Celowy bok eksistěrujo - wulašowaś??==

Bok „[[:$1]]“ južo eksistěrujo. Coš jen wulašowaś, aby mógał toś ten bok pśesunuś?',
	'delete_and_move_confirm' => 'Jo, toś ten bok wulašowaś',
	'delete_and_move_reason' => 'Wulašowane, aby městno za pśesunjenje boka "[[$1]]" napórał',
	'djvu_page_error' => 'DjVu-bok pśesegujo wobłuk.',
	'djvu_no_xml' => 'Njejo móžno, XML za DjVu-dataju wótwołaś.',
	'deletedrevision' => 'wulašowana stara wersija: $1',
	'days' => '{{PLURAL:$1|$1 dnjom|$1 dnjoma|$1 dnjami|$1 dnjami}}',
	'deletedwhileediting' => "'''Warnowanje''': Toś ten bok se wulašujo, gaž zachopijoš jen wobźěłaś!",
	'descending_abbrev' => 'dołoj',
	'duplicate-defaultsort' => 'Glědaj: Standardny sortěrowański kluc (DEFAULT SORT KEY) "$2" pśepišo pjerwjej wužyty kluc "$1".',
	'dberr-header' => 'Toś ten wiki ma problem',
	'dberr-problems' => 'Wódaj! Toś to sedło ma techniske śěžkosći.',
	'dberr-again' => 'Pócakaj někotare minuty a aktualizěruj bok.',
	'dberr-info' => '(Njejo móžno ze serwerom datoweje banki zwězaś: $1)',
	'dberr-usegoogle' => 'Móžoš mjaztym pśez Google pytaś.',
	'dberr-outofdate' => 'Źiwaj na to, až jich indekse našogo wopśimjeśa by mógli zestarjone byś.',
	'dberr-cachederror' => 'Slědujuca jo pufrowana kopija pominanego boka a by mógła zestarjona byś.',
	'duration-seconds' => '$1 {{PLURAL:$1|sekunda|sekunźe|sekundy|sekundow}}',
	'duration-minutes' => '$1 {{PLURAL:$1|minuta|minuśe|minuty|minutow}}',
	'duration-hours' => '$1 {{PLURAL:$1|góźina|góźinje|góźiny|góźinow}}',
	'duration-days' => '$1 {{PLURAL:$1|źeń|dnja|dny|dnjow}}',
	'duration-weeks' => '$1 {{PLURAL: $1|tyźeń|tyźenja|tyźenje|tyźenjow}}',
	'duration-years' => '$1 {{PLURAL: $1|lěto|lěśe|lěta|lět}}',
	'duration-decades' => '$1 {{PLURAL:$1|lětźasetk|lětźasetka|lětźasetki|lětźastkow}}',
	'duration-centuries' => '$1 {{PLURAL:$1|stolěśe|stolěśi|stolěśa|stolěśow}}',
	'duration-millennia' => '$1 {{PLURAL:$1|lěttysac|lěttysaca|lěttysace|lěttysacow}}',
);

$messages['dtp'] = array(
	'december' => 'Tumomuhau',
	'december-gen' => 'Momuhau',
	'dec' => 'Hau',
	'delete' => 'Pugaso',
	'deletethispage' => 'Pugaso iti bolikon',
	'disclaimers' => 'Pogoliman',
	'disclaimerpage' => 'Project:Pogoliman kosoruan',
	'databaseerror' => 'Nakasala databing',
	'dberrortext' => 'Nokosilap pogiuludan databing.
Haro kaanto kutu id posuang-suangon.
Tohuri pinokianu pogiuludan databing nopo nga:
<blockquote><tt>$1</tt></blockquote>
mantad suang momoguno  "<tt>$2</tt>".
Databing nokosilap pinopoguli "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Haro kinosilapan pinongimuhatan sintak diri databing.
Pinokianu databing di nokotohuri nopo nga:
"$1"
mantad kopomogunoon "$2".
Nokosilap pinonimbar databing do "$3: $4"',
	'directorycreateerror' => 'Awu kowonsoi pailtuduk "$1".',
	'deletedhist' => 'Susuyan nopugas',
	'difference' => '(Pisuaian mantad sinimakan)',
	'datedefault' => 'Ingaa komoisoon',
	'diff' => 'pisuai',
	'deletedcontributions' => 'Pugaso pinototoluod do momoguno',
	'deletedcontributions-title' => 'Pugaso pinototoluod do momoguno',
	'deletepage' => 'Pugaso bolikon',
	'deletedtext' => '"$1" nopugas nodi.
Intaai $2 montok ruputan di wagu pinugas.',
	'dellogpage' => 'Log pinimpugasan',
	'deletecomment' => 'Sabab:',
	'deleteotherreason' => 'Sabab suai/poinsungku:',
	'deletereasonotherlist' => 'Sabab suai',
	'duplicate-defaultsort' => '\'\'\'Panansarahan:\'\'\' Popoguli nuludan kunsi "$2" mongolon nuludan kunsi nokopogulu "$1".',
);

$messages['dv'] = array(
	'december' => 'ޑިސެމްބަރު',
	'dec' => 'ޑިސެމްބަރ',
	'delete' => 'ފޮހެލައްވާ',
	'deletethispage' => 'މި ޞަފްޙާ ފޮހެލައްވާ',
	'disclaimers' => 'އިއުލާނުތައް',
	'databaseerror' => 'ކޮށާރުގެ އޮޅުމެއް',
	'difference' => '(އިސްލާހުތަކުގައި ހުރި ފަރަގު)',
	'diff' => 'ފަރަގު',
	'deletepage' => 'ޞަފްޙާ ފޮހެލައްވާ',
	'deletecomment' => 'ސަބަބު',
	'delete_and_move' => 'ފޮހެލައްވާފައި އެހެންނަމަކަށްބަދަލުކުރައްވާ',
	'delete_and_move_confirm' => 'އާދެ، މި ޞަފްޙާ ފޮހެލައްވާ',
	'delete_and_move_reason' => 'އެހެންނަމަކަށް ބަދަލުކުރުމަށްޓަކައި ފޮހެލެވިއްޖެ',
);

$messages['dz'] = array(
	'december' => 'སྤྱི་ཟླ་བཅུ་གཉིས་པ།',
	'december-gen' => 'སྤྱི་ཟླ་ ༡༢ པའི་',
	'dec' => 'ཟླ་༡༢ པ།',
	'delete' => 'བཏོན་གཏང་།',
	'disclaimers' => 'ཁས་མི་ལེན་པ།',
	'disclaimerpage' => 'Project: སྤྱིར་བཏང་ཁས་མི་ལེན་པ།',
	'difference' => '(བསྐྱར་ཞིབ་བར་ནའི་ཁྱད་པར)',
	'diff-multi' => '({{PLURAL:$1|བར་ནའི་བསྐྱར་ཞིབ་གཅིག་|$1 བར་ནའི་བསྐྱར་ཞིབ་ཚུ་}} མ་སྟོན་པས།)',
	'diff' => 'ཁྱད་པར།',
	'disambiguations' => 'ངེས་པ་ཡོད་པའི་བརྡ་དོན་ཤོག་ལེབ།',
	'doubleredirects' => 'སླར་ལོག་གཉིས་ལྡན།',
	'deadendpages' => 'ཤོག་ལེབ་མཇུག་',
	'deletepage' => 'ཤོག་ལེབ་བཏོན་གཏང་།',
	'deletedtext' => '"$1" འདི་ བཏོན་བཀོག་ནུག།
འཕྲལ་ཁམས་ལུ་བཏོན་བཀོག་མི་ཐོ་གི་དོན་ལུ་ $2 ལུ་བལྟ།',
	'dellogpage' => 'བཏོན་གཏང་ཡོད་པའི་ལོག།',
	'deletecomment' => 'རྒྱུ་མཚན:',
	'deleteotherreason' => 'གཞན་/ཁ་སྐོང་ཅན་གྱི་རྒྱུ་མཚན།',
	'deletereasonotherlist' => 'རྒྱུ་མཚན་གཞན།',
);

$messages['ee'] = array(
	'december' => 'Dzome',
	'december-gen' => 'Dzome',
	'dec' => 'Dzom',
	'delete' => 'Tutui',
	'deletethispage' => 'Tutu axa sia',
	'disclaimers' => 'Nuxlɔ̃amenyawo',
	'difference' => '(Vovototowo le tata xoxoawo me)',
	'diff' => 'tɔtrɔ',
	'deletepage' => 'Tutu axa sia',
	'delete-confirm' => 'Tutu "$1"',
	'delete-legend' => 'Tutui',
	'dellogpagetext' => 'Afisia wofia axa mamleawo siwo wotutu la',
);

$messages['el'] = array(
	'december' => 'Δεκέμβριος',
	'december-gen' => 'Δεκεμβρίου',
	'dec' => 'Δεκ',
	'delete' => 'Διαγραφή',
	'deletethispage' => 'Διαγραφή αυτής της σελίδας',
	'disclaimers' => 'Αποποίηση ευθυνών',
	'disclaimerpage' => 'Project:Γενική αποποίηση',
	'databaseerror' => 'Σφάλμα στη βάση δεδομένων',
	'dberrortext' => 'Σημειώθηκε συντακτικό σφάλμα σε αίτημα προς τη βάση δεδομένων.
Πιθανόν να πρόκειται για ένδειξη σφάλματος στο λογισμικό.
Το τελευταίο αίτημα προς τη βάση δεδομένων που επιχειρήθηκε ήταν:
<blockquote><tt>$1</tt></blockquote>
μέσα από τη λειτουργία "<tt>$2</tt>".
Η βάση δεδομένων επέστρεψε σφάλμα "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Σημειώθηκε συντακτικό σφάλμα σε αίτημα προς τη βάση δεδομένων.
Το τελευταίο αίτημα που επιχειρήθηκε ήταν:
"$1"
μέσα από τη λειτουργία "$2".
Η βάση δεδομένων επέστρεψε σφάλμα "$3: $4".',
	'directorycreateerror' => 'Δεν μπορούσε να δημιουργηθεί η κατηγορία "$1".',
	'deletedhist' => 'Διαγραμμένο ιστορικό',
	'difference' => '(Διαφορές μεταξύ αναθεωρήσεων)',
	'difference-multipage' => '(Διαφορές μεταξύ των σελίδων)',
	'diff-multi' => '({{PLURAL:$1|Μία ενδιάμεση αναθεώρηση|$1 ενδιάμεσες αναθεωρήσεις}} από {{PLURAL:$2|ένα χρήστη|$2 χρήστες}} δεν {{PLURAL:$1|εμφανίζεται|εμφανίζονται}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Μία ενδιάμεση αναθεώρηση|$1 ενδιάμεσες αναθεωρήσεις}} από περισσότερο από $2 {{PLURAL:$2|χρήστη|χρήστες}} δεν εμφανίζονται)',
	'datedefault' => 'Χωρίς προτίμηση',
	'defaultns' => 'Ειδάλλως αναζήτηση σε αυτές τις περιοχές ονομάτων:',
	'default' => 'προεπιλογή',
	'diff' => "'διαφορά'",
	'destfilename' => 'Όνομα αρχείου προορισμού:',
	'duplicatesoffile' => '{{PLURAL:$1|Το ακόλουθο αρχείο είναι διπλότυπο|Τα $1 ακόλουθα αρχεία είναι διπλότυπα}} αυτού του αρχείου ([[Special:FileDuplicateSearch/$2|περισσότερες λεπτομέρειες]]):',
	'download' => 'λήψη',
	'disambiguations' => 'Σελίδες με συνδέσμους σε σελίδες αποσαφήνισης',
	'disambiguationspage' => 'Project:Σύνδεσμοι_προς_τις_σελίδες_αποσαφήνισης',
	'disambiguations-text' => "Οι ακόλουθες σελίδες συνδέουν σε μια '''σελίδα αποσαφήνισης'''.
Αντιθέτως πρέπει να συνδέουν στο κατάλληλο θέμα.<br />
Μια σελίδα μεταχειρίζεται ως σελίδα αποσαφήνισης αν χρησιμοποιεί ένα πρότυπο το οποίο συνδέεται από το [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Διπλές ανακατευθύνσεις',
	'doubleredirectstext' => 'Αυτή η σελίδα συγκαταλέγει σελίδες οι οποίες ανακατευθύνουν σε άλλες σελίδες ανακατεύθυνσης. Κάθε σειρά περιέχει συνδέσμους προς την πρώτη και τη δεύτερη σελίδα ανακατεύθυνσης, όπως επίσης και την πρώτη αράδα του κειμένου στη δεύτερη σελίδα ανακατεύθυνσης η οποία και είναι, κανονικά, ο πραγματικός προορισμός της ανακατεύθυνσης -εκεί δηλαδή όπου θα έπρεπε να είχατε οδηγηθεί από την αρχή. Τα <del>διεγραμμένα</del> λήμματα έχουν επιλυθεί.',
	'double-redirect-fixed-move' => 'Η [[$1]] έχει μετακινηθεί, τώρα είναι ανακατεύθυνση στην [[$2]]',
	'double-redirect-fixed-maintenance' => 'Διόρθωση διπλής ανακατεύθυνσης από το [[$1]] στο [[$2]].',
	'double-redirect-fixer' => 'Διορθωτής ανακατευθύνσεων',
	'deadendpages' => 'Αδιέξοδες σελίδες',
	'deadendpagestext' => 'Οι σελίδες που ακολουθούν δεν συνδέονται με άλλες σελίδες στο {{SITENAME}}.',
	'deletedcontributions' => 'Διαγραμμένες συνεισφορές χρήστη',
	'deletedcontributions-title' => 'Διαγραμμένες συνεισφορές χρήστη',
	'defemailsubject' => '{{SITENAME}} e-mail από τον χρήστη "$1"',
	'deletepage' => 'Διαγραφή σελίδας',
	'delete-confirm' => 'Διαγραφή του "$1"',
	'delete-legend' => 'Διαγραφή',
	'deletedtext' => 'Η "$1" έχει διαγραφεί.
Για το ιστορικό των πρόσφατων διαγραφών ανατρέξτε στο σύνδεσμο $2',
	'dellogpage' => 'Καταγραφές διαγραφών',
	'dellogpagetext' => 'Λίστα των πιο πρόσφατων διαγραφών',
	'deletionlog' => 'Καταγραφές διαγραφών',
	'deletecomment' => 'Λόγος:',
	'deleteotherreason' => 'Άλλος/πρόσθετος λόγος:',
	'deletereasonotherlist' => 'Άλλος λόγος',
	'deletereason-dropdown' => '*Συνηθισμένοι λόγοι διαγραφής
** Αίτηση του δημιουργού της
** Παραβίαση των πνευματικών δικαιωμάτων
** Βανδαλισμός',
	'delete-edit-reasonlist' => 'Επεξεργασία λόγων διαγραφής',
	'delete-toobig' => 'Αυτή η σελίδα έχει μεγάλο ιστορικό τροποποιήσεων, πάνω από $1 {{PLURAL:$1|τροποποίηση|τροποποιήσεις}}.
Η διαγραφή τέτοιων σελίδων έχει περιοριστεί για την αποφυγή τυχαίας αναστάτωσης του {{SITENAME}}.',
	'delete-warning-toobig' => 'Αυτή η σελίδα έχει μεγάλο ιστορικό τροποποιήσεων, πάνω από $1 {{PLURAL:$1|τροποποίηση|τροποποιήσεις}}.
Η διαγραφή της μπορεί να αναστατώσει τη λειτουργία της βάσης δεδομένων του {{SITENAME}}. Συνιστούμε μεγάλη προσοχή.',
	'databasenotlocked' => 'Η βάση δεδομένων δεν είναι κλειδωμένη.',
	'delete_and_move' => 'Διαγραφή και μετακίνηση',
	'delete_and_move_text' => '==Χρειάζεται διαγραφή.==

Το άρθρο [[:$1]] υπάρχει ήδη. Θέλετε να το διαγράψετε για να εκτελεσθεί η μετακίνηση;',
	'delete_and_move_confirm' => 'Ναι, διέγραψε τη σελίδα',
	'delete_and_move_reason' => 'Διαγράφηκε για να δημιουργήσει χώρο για μετακίνηση από το "[[$1]]"',
	'djvu_page_error' => 'Σελίδα DjVu εκτός ορίων',
	'djvu_no_xml' => 'Αδυναμία προσκόμισης XML για το αρχείο DjVu',
	'deletedrevision' => 'Η παλιά έκδοση της $1 διαγράφτηκε',
	'days' => '{{PLURAL:$1|$1 μέρα|$1 μέρες}}',
	'deletedwhileediting' => "'''Προσοχή''': Αυτή η σελίδα έχει διαγραφεί αφότου ξεκινήσατε την επεξεργασία!",
	'descending_abbrev' => 'φθιν',
	'duplicate-defaultsort' => 'Προσοχή: Το προκαθορισμένο κλειδί ταξινόμησης "$2" υπερκαλύπτει το προηγούμενο "$1".',
	'dberr-header' => 'Αυτό το βίκι έχει ένα πρόβλημα',
	'dberr-problems' => 'Λυπούμαστε! Αυτός ο ιστότοπος αντιμετωπίζει τεχνικές δυσκολίες.',
	'dberr-again' => 'Δοκιμάστε να περιμενένετε λίγα λεπτά και να ανανεώσετε.',
	'dberr-info' => '(Δεν μπορεί να επικοινωνήσει με τον εξυπηρετητή της βάσης δεδομένων: $1)',
	'dberr-usegoogle' => 'Μπορείτε να δοκιμάσετε να ψάξετε στο Google εν τω μεταξύ.',
	'dberr-outofdate' => 'Σημειώστε ότι οι ενδείξεις τους περί του περιεχομένου μας ενδέχεται να μην είναι ενημερωμένες.',
	'dberr-cachederror' => 'Το ακόλουθο είναι ένα αντίγραφο από την μνήμη της σελίδας που ζητήσατε και ενδέχεται να μην είναι ενημερωμένο.',
	'discuss' => 'Συζήτηση',
);

$messages['eml'] = array(
	'december' => 'Dzèmber',
	'delete' => 'Dscanzèla',
	'diff' => 'diferèinzi',
	'deletedtext' => '"$1" l\'è stê scanzlê.
Guèrda $2 par vèdder la lésta d\'al pàgin ch\'i sun stèdi scanzlèdi di recèint.',
	'dellogpage' => 'Regestér dal scanzladûri',
	'deletionlog' => 'regéster dal scanzladûri',
);

$messages['eo'] = array(
	'december' => 'Decembro',
	'december-gen' => 'Decembro',
	'dec' => 'Dec',
	'delete' => 'Forigi',
	'deletethispage' => 'Forigi ĉi tiun paĝon',
	'disclaimers' => 'Malgarantio',
	'disclaimerpage' => 'Project:Malgarantia paĝo',
	'databaseerror' => 'Datumbaza eraro',
	'dberrortext' => 'Sintakseraro okazis dum informpeto al la datumaro.
Ĝi eble indikas cimon en la programaro.
Jen la plej laste provita informpeto:
<blockquote><tt>$1</tt></blockquote>
el la funkcio "<tt>$2</tt>".
MySQL liveris eraron "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Sintaksa eraro de la datumbaza informmendo okazis.
La lasta provita datumbaza informmendo estis:
"$1"
el la funkcio "$2".
Datumbazo liveris la erarmesaĝon "$3: $4".',
	'directorycreateerror' => 'Ne povis krei dosierujon "$1".',
	'deletedhist' => 'Forigita historio',
	'difference' => '(Malsamoj inter versioj)',
	'difference-multipage' => '(Diferenco inter paĝoj)',
	'diff-multi' => '({{PLURAL:$1|Unu intermeza versio|$1 intermezaj versioj}} de {{PLURAL:$2|unu uzanto|$2 uzantoj}} ne estas {{PLURAL:$1|montrata|montrataj}}.)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Unu intermeza versio|$1 intermezaj versioj}} de pli ol {{PLURAL:$2|unu uzanto|$2 uzantoj}} ne estas {{PLURAL:$1|montrata|montrataj}}.)',
	'datedefault' => 'Nenia prefero',
	'defaultns' => 'Alimaniere, traserĉi la jenajn nomspacojn:',
	'default' => 'defaŭlte',
	'diff' => 'malsamoj',
	'destfilename' => 'Celdosiernomo:',
	'duplicatesoffile' => 'La {{PLURAL:$1|jena dosiero estas duplikato|jenaj dosieroj estas duplikatoj}} de ĉi tiu dosiero ([[Special:FileDuplicateSearch/$2|pluaj detaloj]]):',
	'download' => 'elŝuti',
	'disambiguations' => 'Paĝoj ligitaj al apartigiloj',
	'disambiguationspage' => 'Template:Apartigilo',
	'disambiguations-text' => "La jenaj paĝoj alligas '''apartigilon'''.
Ili devus anstataŭe alligi la ĝustan temon.<br />
Paĝo estas traktata kiel apartigilo se ĝi uzas ŝablonon kiu estas ligita de [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Duoblaj alidirektadoj',
	'doubleredirectstext' => 'Ĉi tiu paĝo montras paĝojn kiuj alidirektas al aliaj alidirektiloj.
Ĉiu vico enhavas ligilojn ĉe la unua kaj dua alidirektadoj, kaj la unua linio de la dua alidirektado, kiu ĝenerale montras la "veran" celpaĝon, kiu celu la unuan alidirektadon.
<del>Forstrekitaj</del> listeroj estis riparitaj.',
	'double-redirect-fixed-move' => '[[$1]] estis alinomita; ĝi nun alidirektas al [[$2]]',
	'double-redirect-fixed-maintenance' => 'Riparas duoblan alidirektilon de [[$1]] al [[$2]].',
	'double-redirect-fixer' => 'Alidirektila riparilo',
	'deadendpages' => 'Paĝoj sen interna ligilo',
	'deadendpagestext' => 'La sekvaj paĝoj ne ligas al aliaj paĝoj en {{SITENAME}}.',
	'deletedcontributions' => 'Forigitaj kontribuoj de uzantoj',
	'deletedcontributions-title' => 'Forigitaj kontribuoj de uzantoj',
	'defemailsubject' => '{{SITENAME}} retmesaĝo de uzanto "$1"',
	'deletepage' => 'Forigi paĝon',
	'delete-confirm' => 'Forigi "$1"',
	'delete-legend' => 'Forigi',
	'deletedtext' => '"$1" estas forigita.
Vidu la paĝon $2 por registro de lastatempaj forigoj.',
	'dellogpage' => 'Protokolo pri forigoj',
	'dellogpagetext' => 'Jen listo de la plej lastaj forigoj el la datumaro.
Ĉiuj tempoj sekvas la horzonon UTC.',
	'deletionlog' => 'protokolo pri forigoj',
	'deletecomment' => 'Kialo:',
	'deleteotherreason' => 'Alia/plua kialo:',
	'deletereasonotherlist' => 'Alia kialo',
	'deletereason-dropdown' => '*Oftaj kialoj por forigo
** Peto de aŭtoro
** Neglekto de aŭtorrajto
** Vandalismo',
	'delete-edit-reasonlist' => 'Redakti kialojn de forigo',
	'delete-toobig' => 'Ĉi tiu paĝo havas grandan redakto-historion, pli ol $1 {{PLURAL:$1|version|versiojn}}. Forigo de ĉi tiaj paĝoj estis limigitaj por preventi akcidentan disrompigon de {{SITENAME}}.',
	'delete-warning-toobig' => 'Ĉi tiu paĝo havas grandan redakto-historion, pli ol $1 {{PLURAL:$1|version|versiojn}}. Forigo de ĝi povas disrompigi operacion de {{SITENAME}}; forigu singarde.',
	'databasenotlocked' => 'La datumbazo ne estas ŝlosita.',
	'delete_and_move' => 'Forigi kaj alinomigi',
	'delete_and_move_text' => '==Forigo nepras==

La celartikolo "[[:$1]]" jam ekzistas. Ĉu vi volas forigi ĝin por krei spacon por la movo?',
	'delete_and_move_confirm' => 'Jes, forigu la paĝon',
	'delete_and_move_reason' => 'Forigita por ebligi movadon de "[[$1]]"',
	'djvu_page_error' => 'DjVu-a paĝo el intervalo',
	'djvu_no_xml' => 'Ne povas akiri XML por DjVu dosiero',
	'deletedrevision' => 'Forigita malnova versio $1',
	'days' => '{{PLURAL:$1|$1 tago|$1 tagoj}}',
	'deletedwhileediting' => "'''Averto''': Ĉi tiu paĝo estis forigita post vi ekredaktis!",
	'descending_abbrev' => 'subn',
	'duplicate-defaultsort' => '\'\'\'Averto:\'\'\' Defaŭlta ordiga ŝlosilo "$2" anstataŭigas pli fruan defaŭltan ordigan ŝlosilon "$1".',
	'dberr-header' => 'Ĉi tiu vikio havas problemon',
	'dberr-problems' => 'Bedaŭrinde, ĉi tiu retejo suferas pro teknikaj problemoj.',
	'dberr-again' => 'Bonvolu atendi kelkajn minutojn kaj reŝargi.',
	'dberr-info' => '(Ne povas kontakti la datenbazan servilon: $1)',
	'dberr-usegoogle' => 'Vi povas serĉi Guglon dume.',
	'dberr-outofdate' => 'Notu ke iliaj indeksoj de nia enhavo eble ne estas ĝisdatigaj.',
	'dberr-cachederror' => 'Jen kaŝmemorigita kopio de la petita paĝo, kaj eble ne estas ĝisdatigita.',
);

$messages['es'] = array(
	'december' => 'diciembre',
	'december-gen' => 'diciembre',
	'dec' => 'dic',
	'delete' => 'Borrar',
	'deletethispage' => 'Borrar esta página',
	'disclaimers' => 'Aviso legal',
	'disclaimerpage' => 'Project:Limitación general de responsabilidad',
	'databaseerror' => 'Error de la base de datos',
	'dberrortext' => 'Ha ocurrido un error de sintaxis en una consulta a la base de datos.
Esto puede indicar un error en el software.
La última consulta a la base de datos que se intentó fue:
<blockquote><tt>$1</tt></blockquote>
dentro de la función «<tt>$2</tt>».
La base de datos devolvió el error «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'Ha ocurrido un error de sintaxis en una consulta a la base de datos.
La última consulta a la base de datos que se intentó fue:
«$1»
desde la función «$2».
Base de datos retornó error «$3: $4».',
	'directorycreateerror' => 'No se pudo crear el directorio «$1».',
	'deletedhist' => 'Historial borrado',
	'difference' => '(Diferencias entre revisiones)',
	'difference-multipage' => '(Diferencia entre las páginas)',
	'diff-multi' => '(No se {{PLURAL:$1|muestra una edición intermedia realizada|muestran $1 ediciones intermedias realizadas}} por {{PLURAL:$2|un usuario|$2 usuarios}})',
	'diff-multi-manyusers' => '(No se {{PLURAL:$1|muestra una edición intermedia|muestran $1 ediciones intermedias}} de {{PLURAL:$2|un usuario|$2 usuarios}})',
	'datedefault' => 'Sin preferencia',
	'defaultns' => 'Buscar en estos espacios de nombres por defecto:',
	'default' => 'por defecto',
	'diff' => 'dif',
	'destfilename' => 'Nombre del archivo de destino:',
	'duplicatesoffile' => '{{PLURAL:$1|El siguiente archivo es un duplicado|Los siguientes $1 archivos son duplicados}} de éste ([[Special:FileDuplicateSearch/$2|más detalles]]):',
	'download' => 'descargar',
	'disambiguations' => 'Páginas que enlazan con páginas de desambiguación',
	'disambiguationspage' => 'Template:Desambiguación',
	'disambiguations-text' => "Las siguientes páginas enlazan con una '''página de desambiguación'''.
En lugar de ello deberían enlazar con  el tema apropiado.<br />
Una página es considerada página de desambiguación si utiliza la plantilla que está enlazada desde [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Redirecciones dobles',
	'doubleredirectstext' => 'Esta página contiene una lista de páginas que redirigen a otras páginas de redirección.
Cada fila contiene enlaces a la segunda y tercera redirección, así como la primera línea de la segunda redirección, en la que usualmente se encontrará el artículo «real» al que la primera redirección debería apuntar.
Las entradas <del>tachadas</del> han sido resueltas.',
	'double-redirect-fixed-move' => '[[$1]] ha sido trasladado, ahora es una redirección a [[$2]]',
	'double-redirect-fixed-maintenance' => 'Corrigiendo la doble redirección desde [[$1]] a [[$2]].',
	'double-redirect-fixer' => 'Corrector de redirecciones',
	'deadendpages' => 'Páginas sin salida',
	'deadendpagestext' => 'Las siguientes páginas no enlazan a otras páginas de {{SITENAME}}.',
	'deletedcontributions' => 'Contribuciones borradas de usuario',
	'deletedcontributions-title' => 'Contribuciones borradas de usuario',
	'defemailsubject' => 'Correo de {{SITENAME}} para el usuario $1',
	'deletepage' => 'Borrar esta página',
	'delete-confirm' => 'Borrar «$1»',
	'delete-legend' => 'Borrar',
	'deletedtext' => '«$1» ha sido borrado.
Véase $2 para un registro de los borrados recientes.',
	'dellogpage' => 'Registro de borrados',
	'dellogpagetext' => 'A continuación se muestra una lista de los borrados más recientes.',
	'deletionlog' => 'registro de borrados',
	'deletecomment' => 'Motivo:',
	'deleteotherreason' => 'Otro motivo:',
	'deletereasonotherlist' => 'Otro motivo',
	'deletereason-dropdown' => '*Razones comunes de borrado
** A petición del mismo autor
** Violación de copyright
** Vandalismo',
	'delete-edit-reasonlist' => 'Editar razones de borrado',
	'delete-toobig' => 'Esta página tiene un historial muy grande, con más de $1 {{PLURAL:$1|revisión|revisiones}}. Borrar este tipo de páginas ha sido restringido para prevenir posibles problemas en {{SITENAME}}.',
	'delete-warning-toobig' => 'Esta página tiene un historial de más de $1 {{PLURAL:$1|revisión|revisiones}}. Eliminarla puede perturbar las operaciones de la base de datos de {{SITENAME}}. Ten cuidado al borrar.',
	'databasenotlocked' => 'La base de datos no está bloqueada.',
	'delete_and_move' => 'Borrar y trasladar',
	'delete_and_move_text' => '==Se necesita borrado==

La página de destino ("[[:$1]]") ya existe. ¿Quiere borrarla para permitir al traslado?',
	'delete_and_move_confirm' => 'Sí, borrar la página',
	'delete_and_move_reason' => 'Borrada para trasladar [[$1]]',
	'djvu_page_error' => 'Página DjVu fuera de rango',
	'djvu_no_xml' => 'Imposible obtener XML para el archivo DjVu',
	'deletedrevision' => 'Borrada revisión antigua $1',
	'days' => '{{PLURAL:$1|un día|$1 días}}',
	'deletedwhileediting' => "'''Aviso''': ¡Esta página fue borrada después de que usted empezara a editar!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => "'''Atención:''' La clave de ordenamiento predeterminada «$2» anula la clave de ordenamiento anterior «$1».",
	'dberr-header' => 'Este wiki tiene un problema',
	'dberr-problems' => 'Lo sentimos.
Este sitio está experimentando dificultades técnicas.',
	'dberr-again' => 'Prueba a recargar dentro de unos minutos.',
	'dberr-info' => '(No se puede contactar con la base de datos del servidor: $1)',
	'dberr-usegoogle' => 'Mientras tanto puedes probar buscando a través de Google.',
	'dberr-outofdate' => 'Ten en cuenta que su índice de nuestro contenido puede estar desactualizado.',
	'dberr-cachederror' => 'La siguiente es una página guardada de la página solicitada, y puede no estar actualizada.',
	'discuss' => 'Discusión',
);

$messages['et'] = array(
	'december' => 'detsember',
	'december-gen' => 'detsembri',
	'dec' => 'dets',
	'delete' => 'Kustuta',
	'deletethispage' => 'Kustuta see lehekülg',
	'disclaimers' => 'Hoiatused',
	'disclaimerpage' => 'Project:Hoiatused',
	'databaseerror' => 'Andmebaasi viga',
	'dberrortext' => 'Andmebaasipäringus oli süntaksiviga.
Selle võis tingida tarkvaraviga.
Viimane andmebaasipäring oli:
<blockquote><tt>$1</tt></blockquote>
ja see kutsuti funktsioonist "<tt>$2</tt>".
Andmebaas tagastas veateate "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Andmebaasipäringus oli süntaksiviga.
Viimane andmebaasipäring oli:
"$1"
ja see kutsuti funktsioonist "$2".
Andmebaas tagastas veateate "$3: $4".',
	'directorycreateerror' => 'Ei suuda luua kausta "$1".',
	'defaultmessagetext' => 'Sõnumi vaiketekst',
	'deletedhist' => 'Kustutatud ajalugu',
	'difference-title' => 'Erinevus lehekülje "$1" redaktsioonide vahel',
	'difference-title-multipage' => 'Erinevus lehekülgede "$1" ja "$2" vahel',
	'difference-multipage' => '(Lehekülgede erinevus)',
	'diff-multi' => '({{PLURAL:$1|Ühte|$1}} vahepealset {{PLURAL:$2|ühe|$2}} kasutaja redaktsiooni ei näidata.)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Ühte|$1}} vahepealset rohkem kui {{PLURAL:$2|ühe|$2}} kasutaja redaktsiooni ei näidata.)',
	'datedefault' => 'Eelistus puudub',
	'defaultns' => 'Muul juhul otsi järgmistest nimeruumidest:',
	'default' => 'vaikeväärtus',
	'diff' => 'erin',
	'destfilename' => 'Failinimi vikis:',
	'duplicatesoffile' => '{{PLURAL:$1|Järgnev fail|Järgnevad $1 faili}} on selle faili {{PLURAL:$1|duplikaat|duplikaadid}} ([[Special:FileDuplicateSearch/$2|üksikasjad]]):',
	'download' => 'laadi alla',
	'disambiguations' => 'Leheküljed, mis lingivad täpsustuslehekülgedele',
	'disambiguationspage' => 'Template:Täpsustuslehekülg',
	'disambiguations-text' => "Loetletud leheküljed viitavad '''täpsustusleheküljele'''.
Selle asemel peaks nad olema lingitud sobivasse artiklisse.
Lehekülg loetakse täpsustusleheküljeks, kui see kasutab malli, millele viitab sõnum [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Kahekordsed ümbersuunamised',
	'doubleredirectstext' => 'Käesolev leht esitab loendi lehtedest, mis sisaldavad ümbersuunamisi teistele ümbersuunamislehtedele.
Igal real on ära toodud esimene ja teine ümbersuunamisleht ning samuti teise ümbersuunamislehe sihtmärk, mis tavaliselt on esialgse ümbersuunamise tegelik siht, millele see otse osutama peakski.
<del>Läbikriipsutatud</del> kirjed on kohendatud.',
	'double-redirect-fixed-move' => '[[$1]] on teisaldatud, see suunab nüüd leheküljele [[$2]].',
	'double-redirect-fixed-maintenance' => 'Parandatakse kahekordne suunamine leheküljelt [[$1]] leheküljele [[$2]].',
	'double-redirect-fixer' => 'Ümbersuunamiste parandaja',
	'deadendpages' => 'Edasipääsuta leheküljed',
	'deadendpagestext' => 'Järgmised leheküljed ei viita ühelegi teisele viki leheküljele.',
	'deletedcontributions' => 'Kustutatud kaastöö',
	'deletedcontributions-title' => 'Kasutaja kustutatud kaastöö',
	'defemailsubject' => 'E-kiri {{GRAMMAR:genitive|{{SITENAME}}}} kasutajalt $1',
	'deletepage' => 'Kustuta lehekülg',
	'delete-confirm' => 'Lehekülje "$1" kustutamine',
	'delete-legend' => 'Kustutamine',
	'deletedtext' => '"$1" on kustutatud. Kustutatud leheküljed on ära toodud eraldi loendis ($2).',
	'dellogpage' => 'Kustutamislogi',
	'dellogpagetext' => 'Allpool on esitatud nimekiri viimastest kustutamistest.
Kõik toodud kellaajad järgivad serveriaega.',
	'deletionlog' => 'kustutamislogi',
	'deletecomment' => 'Põhjus:',
	'deleteotherreason' => 'Muu või täiendav põhjus:',
	'deletereasonotherlist' => 'Muu põhjus',
	'deletereason-dropdown' => '*Harilikud kustutamise põhjused
** Autori palve
** Autoriõiguste rikkumine
** Vandalism',
	'delete-edit-reasonlist' => 'Redigeeri kustutamise põhjuseid',
	'delete-toobig' => 'See lehekülg on pika redigeerimisajalooga – üle {{PLURAL:$1|ühe muudatuse|$1 muudatuse}}.
Selle kustutamine on keelatud, et ära hoida ekslikku {{GRAMMAR:genitive|{{SITENAME}}}} töö häirimist.',
	'delete-warning-toobig' => 'See lehekülg on pika redigeerimislooga – üle {{PLURAL:$1|ühe muudatuse|$1 muudatuse}}.
Ettevaatust, selle kustutamine võib esile kutsuda häireid {{GRAMMAR:genitive|{{SITENAME}}}} andmebaasi töös.',
	'databasenotlocked' => 'Andmebaas ei ole lukustatud.',
	'delete_and_move' => 'Kustuta ja teisalda',
	'delete_and_move_text' => '== Vajalik kustutamine ==
Sihtlehekülg "[[:$1]]" on juba olemas.
Kas kustutad selle, et luua võimalus teisaldamiseks?',
	'delete_and_move_confirm' => 'Jah, kustuta lehekülg',
	'delete_and_move_reason' => 'Kustutatud, et tõsta asemele lehekülg "[[$1]]"',
	'djvu_page_error' => 'DjVu-failis ei ole sellist lehekülge',
	'djvu_no_xml' => 'DjVu failist XML-i lugemine ebaõnnestus.',
	'deletedrevision' => 'Kustutatud vanem versioon $1',
	'days' => '{{PLURAL:$1|üks päev|$1 päeva}}',
	'deletedwhileediting' => "'''Hoiatus''': Sel ajal, kui sina lehekülge redigeerisid, kustutas keegi selle ära!",
	'descending_abbrev' => 'laskuv',
	'duplicate-defaultsort' => '\'\'\'Hoiatus:\'\'\' Järjestamisvõti "$2" tühistab eespool oleva järjestamisvõtme "$1".',
	'dberr-header' => 'Selles vikis on probleem',
	'dberr-problems' => 'Kahjuks on sellel saidil tehnilisi probleeme',
	'dberr-again' => 'Oota mõni hetk ja laadi lehekülg uuesti.',
	'dberr-info' => '(Ei saa ühendust andmebaasi serveriga: $1)',
	'dberr-usegoogle' => "Proovi vahepeal otsida Google'ist.",
	'dberr-outofdate' => "Pane tähele, et Google'is talletatud meie sisu võib olla iganenud.",
	'dberr-cachederror' => 'See koopia taotletud leheküljest on vahemälus ja ei pruugi olla ajakohane.',
	'duration-seconds' => '$1 {{PLURAL:$1|sekundi}}',
	'duration-minutes' => '$1 {{PLURAL:$1|minuti}}',
	'duration-hours' => '$1 {{PLURAL:$1|tunni}}',
	'duration-days' => '$1 {{PLURAL:$1|päeva}}',
	'duration-weeks' => '$1 {{PLURAL:$1|nädala}}',
	'duration-years' => '$1 {{PLURAL:$1|aasta}}',
	'duration-decades' => '$1 {{PLURAL:$1|kümnendi}}',
	'duration-centuries' => '$1 {{PLURAL:$1|sajandi}}',
	'duration-millennia' => '$1 {{PLURAL:$1|aastatuhande}}',
);

$messages['eu'] = array(
	'december' => 'Abendua',
	'december-gen' => 'Abendu',
	'dec' => 'Abe',
	'delete' => 'Ezabatu',
	'deletethispage' => 'Orrialde hau ezabatu',
	'disclaimers' => 'Mugaketak',
	'disclaimerpage' => 'Project:Erantzukizunen mugaketa orokorra',
	'databaseerror' => 'Datu-base errorea',
	'dberrortext' => 'Datu-basean kontsulta egiterakoan sintaxi errore bat gertatu da. Baliteke softwareak bug bat izatea. Datu-basean egindako azken kontsulta:
<blockquote><tt>$1</tt></blockquote>
funtzio honekin: "<tt>$2</tt>".
Datu-baseak emandako errore informazioa: "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Datu-basean kontsulta egiterakoan sintaxi errore bat gertatu da.
Datu-basean egindako azken kontsulta:
"$1"
funtzio honekin: "$2".
Datu-baseak emandako errore informazioa: "$3: $4"',
	'directorycreateerror' => 'Ezin izan da "$1" karpeta sortu.',
	'deletedhist' => 'Ezabatutako historia',
	'difference' => '(Bertsioen arteko ezberdintasunak)',
	'difference-multipage' => '(Orrialdeen arteko ezberdintasunak)',
	'diff-multi' => '({{PLURAL:$1|Ez da tarteko berrikuspen bat|Ez dira tarteko $1 berrikuspen}} erakusten {{PLURAL:$2|lankide batena|$2 lankiderena}}.)',
	'datedefault' => 'Hobespenik ez',
	'defaultns' => 'Bestela izen-tarte hauetan bilatu:',
	'default' => 'lehenetsia',
	'diff' => 'ezb',
	'destfilename' => 'Helburu fitxategi izena:',
	'duplicatesoffile' => 'Ondorengo fitxategi {{PLURAL:$1|hau beste honen berdina da|$1 hauek beste honen berdinak dira}} ([[Special:FileDuplicateSearch/$2|zehaztasun gehiago]]):',
	'download' => 'jaitsi',
	'disambiguations' => 'Argipen orrietara lotzen duten orriak',
	'disambiguationspage' => 'Template:argipen',
	'disambiguations-text' => "Jarraian azaltzen diren orrialdeek '''argipen orrialde''' baterako lotura dute. Kasu bakoitzean dagokion artikulu zuzenarekin izan beharko lukete lotura.<br />Orrialde bat argipen motakoa dela antzeman ohi da [[MediaWiki:Disambiguationspage]] orrialdean agertzen den txantiloietako bat duenean.",
	'doubleredirects' => 'Birzuzenketa bikoitzak',
	'doubleredirectstext' => 'Lerro bakoitzean lehen eta bigarren birzuzenketetarako loturak ikus daitezke, eta baita edukia daukan edo eduki beharko lukeen orrialderako lotura ere. Lehen birzuzenketak azken honetara <del>zuzendu</del> beharko luke.',
	'double-redirect-fixed-move' => '[[$1]] mugitu da eta orain [[$2]](e)ra birzuzenketa bat da',
	'double-redirect-fixed-maintenance' => 'Birzuzenketa bikoitza konpontzen [[$1]]-etik [[$2]]-ra',
	'double-redirect-fixer' => 'Birzuzenketa zuzentzailea',
	'deadendpages' => 'Orrialde itsuak',
	'deadendpagestext' => 'Jarraian zerrendatutako orrialdeek ez daukate wikiko beste edozein orrialdetarako loturarik.',
	'deletedcontributions' => 'Ezabatutako ekarpenak',
	'deletedcontributions-title' => 'Ezabatutako ekarpenak',
	'defemailsubject' => '{{SITENAME}} e-posta "$1" lankideak',
	'deletepage' => 'Orrialdea ezabatu',
	'delete-confirm' => '"$1" ezabatu',
	'delete-legend' => 'Ezabatu',
	'deletedtext' => '"$1" ezabatu egin da. Ikus $2 azken ezabaketen erregistroa ikusteko.',
	'dellogpage' => 'Ezabaketa erregistroa',
	'dellogpagetext' => 'Behean ikus daiteke azken ezabaketen zerrenda.',
	'deletionlog' => 'ezabaketa erregistroa',
	'deletecomment' => 'Arrazoia:',
	'deleteotherreason' => 'Arrazoi gehigarria:',
	'deletereasonotherlist' => 'Beste arrazoi bat',
	'deletereason-dropdown' => '*Ezabatzeko ohiko arrazoiak
** Egileak eskatuta
** Egile eskubideak urratzea
** Bandalismoa',
	'delete-edit-reasonlist' => 'Ezabaketa arrazoiak aldatu',
	'delete-toobig' => 'Orrialde honek aldaketa historia luzea du, {{PLURAL:$1|berrikuspen batetik|$1 berrikuspenetik}} gorakoa.
Orrialde horien ezabaketa mugatua dago {{SITENAME}}n ezbeharrak saihesteko.',
	'delete-warning-toobig' => 'Orrialde honek aldaketa historia luzea du, {{PLURAL:$1|berrikuspen batetik|$1 berrikuspenetik}} gorakoa.
Ezabatzeak ezbeharrak eragin ditzake {{SITENAME}}ren datu-basean;
kontu izan.',
	'databasenotlocked' => 'Datu-basea ez dago blokeatuta.',
	'delete_and_move' => 'Ezabatu eta mugitu',
	'delete_and_move_text' => '== Ezabatzeko beharra ==

"[[:$1]]" helburua existitzen da. Lekua egiteko ezabatu nahi al duzu?',
	'delete_and_move_confirm' => 'Bai, orrialdea ezabatu',
	'delete_and_move_reason' => 'Lekua egiteko ezabatu da',
	'djvu_page_error' => 'DjVu orrialdea eremuz kanpo',
	'djvu_no_xml' => 'Ezinezkoa izan da DjVu fitxategiaren XML lortzea',
	'deletedrevision' => '$1 berrikuspen zaharra ezabatu da',
	'deletedwhileediting' => "'''Oharra''': Zu aldaketak egiten hasi ondoren orrialdea ezabatua izan da!",
	'descending_abbrev' => 'behe',
	'duplicate-defaultsort' => 'Adi: Berezko "$2" antolatzeak aurreko berezko "$1" antolatzea gainditzen du.',
	'dberr-header' => 'Wiki honek arazo bat du',
	'dberr-problems' => 'Barkatu! Webgune honek zailtasun teknikoak jasaten ari da.',
	'dberr-again' => 'Saiatu pare bat minutu itxaroten edo kargatu ezazu orrialdea berriro.',
	'dberr-info' => '($1: Ezin da datu-base zerbitzariarekin konektatu)',
	'dberr-usegoogle' => 'Bitartean Google bidez bilatzen saiatu zintezke.',
	'dberr-outofdate' => 'Eduki hauek aurkibideak eguneratu gabe egon daitezke.',
	'dberr-cachederror' => 'Ondorengoa eskatutako orriaren katxedun kopia da, eta eguneratu gabe egon daiteke.',
);

$messages['ext'] = array(
	'december' => 'Diciembri',
	'december-gen' => 'Diciembri',
	'dec' => 'Dic',
	'delete' => 'Esborral',
	'deletethispage' => 'Esborral esta páhina',
	'disclaimers' => 'Avissu legal',
	'disclaimerpage' => 'Project:Arrayu heneral de responsabiliá',
	'databaseerror' => 'Marru ena basi e datus',
	'dberrortext' => 'Marru sintáticu ena consurta a la bassi de datus:
Estu puei sel ebiu a un marru nel software.
La úrtima consurta jue:
<blockquote><tt>$1</tt></blockquote>
endrentu la junción "<tt>$2</tt>".
La bassi de datus degorvió el marru "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Marru sintáticu ena consurta a la bassi de datus.
La úrtima consurta jue:
"$1"
endrentu la junción "$2".
La bassi de datus degorvió el marru "$3: $4"',
	'directorycreateerror' => 'Nu se puei crial el diretoriu "$1".',
	'deletedhist' => 'Estorial esborrau',
	'difference' => '(Deferéncias entri las revisionis)',
	'diff-multi' => '(Nu se {{PLURAL:$1|muestra una revisión entelmeya|muestran $1 revisionis entelmeyas}}.)',
	'datedefault' => 'Sin preferéncias',
	'defaultns' => 'Landeal nestus "espacius de nombris" pol defeutu:',
	'default' => 'defeutu',
	'diff' => 'def',
	'destfilename' => 'Nombri e destinu:',
	'download' => 'descargal',
	'disambiguations' => 'Páhinas de desambiguáncia',
	'disambiguationspage' => 'Prantilla:desambiguáncia',
	'disambiguations-text' => "Las siguientis páhinas atihan a una '''páhina e desambiguáncia'''. Estas eberian atihal al artículu apropiau.<br />Una páhina se consiera e desambiguáncia si gasta una prantilla qu'está atihá endi [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Redirecionis dobris',
	'deadendpages' => 'Callehonis',
	'deadendpagestext' => 'Las siguientis páhinas nu atihan a otras páhinas desti güiqui.',
	'deletedcontributions' => 'Contribucionis el usuáriu esborrás',
	'deletedcontributions-title' => 'Contribucionis el usuáriu esborrás',
	'defemailsubject' => 'E-mail de {{SITENAME}}',
	'deletepage' => 'Esborral páhina',
	'delete-confirm' => 'Esborral "$1"',
	'delete-legend' => 'Esborral',
	'deletedtext' => 'S\'á esborrau "$1" corretamenti.
Consurta $2 pa vel los úrtimus esborraus.',
	'dellogpage' => 'Rustrihu d´esborrau',
	'dellogpagetext' => 'Embahu se muestra una lista colos úrtimus esborraus.',
	'deletionlog' => 'rustrihu d´esborrau',
	'deletecomment' => 'Razón:',
	'deleteotherreason' => 'Otras razonis:',
	'deletereasonotherlist' => 'Otra razón',
	'deletereason-dropdown' => "*Motivus mas frecuentis d'esborrau
** Pol solicitú el autol
** Violación el Copyright
** Vandalismu",
	'delete-edit-reasonlist' => 'Eital razonis del esborrau',
	'delete-warning-toobig' => "Esta páhina tieni un estorial d'eicionis grandi, mas de $1 revisionis. Esborralu puei causal pobremas enas operacionis la basi e datus de {{SITENAME}}; atua con cudiau.",
	'databasenotlocked' => 'La basi e datus nu está atarugá.',
	'delete_and_move' => 'Esborral i movel',
	'delete_and_move_text' => '==Es mestel esborral==

Ya desisti la páhina "[[:$1]]". Te petaria esborrala pa premitil el treslau?',
	'delete_and_move_confirm' => 'Sí, esborral la páhina',
	'delete_and_move_reason' => 'Esborrá pa premitil el treslau',
	'djvu_page_error' => 'Páhina DjVu huera el rangu',
	'djvu_no_xml' => 'Nu á siu posibri otenel el XML pal archivu DjVu',
	'deletedrevision' => 'Esborrá la revisión antigua $1',
	'deletedwhileediting' => 'Avisu: esta página á siu esborrá endispués de tu encetal a eitala!',
	'dberr-header' => 'Marru ena wiki',
);

$messages['fa'] = array(
	'december' => 'دسامبر',
	'december-gen' => 'دسامبر',
	'dec' => 'دسامبر',
	'delete' => 'حذف',
	'deletethispage' => 'حذف این صفحه',
	'disclaimers' => 'تکذیب‌نامه‌ها',
	'disclaimerpage' => 'Project:تکذیب‌نامهٔ عمومی',
	'databaseerror' => 'خطای پایگاه داده',
	'dberrortext' => 'اشکال نحوی در درخواست فرستاده شده به پایگاه داده رخ داد.
دلیل این مشکل می‌تواند ایرادی در نرم‌افزار باشد.
آخرین درخواست که برای پایگاه داده فرستاد شد این بود:
<blockquote style="direction:ltr;"><tt>$1</tt></blockquote>
این درخواست از درون عملگر «<span class="ltr"><tt>$2</tt></span>» فرستاده شد.
پایگاه داده این خطا را بازگرداند:
<div class="ltr"><tt>$3: $4</tt></div>',
	'dberrortextcl' => 'اشکال نحوی در درخواست فرستاده شده به پایگاه داده رخ داد.
آخرین درخواستی که برای پایگاه داده فرستاد شد این بود:
<div class="ltr">$1</div>
این درخواست از درون عملگر «<span class="ltr">$2</span>» فرستاده شد.
پایگاه داده این خطا را بازگرداند:
<div class="ltr">$3: $4</div>',
	'directorycreateerror' => 'امکان ایجاد پوشه $1 وجود نداشت.',
	'deletedhist' => 'تاریخچهٔ حذف‌شده',
	'difference' => '(تفاوت بین نسخه‌ها)',
	'difference-multipage' => '(تفاوت بین صفحه‌ها)',
	'diff-multi' => '({{PLURAL:$1|یک|$1}} ویرایش میانی توسط {{PLURAL:$2|یک|$2}} کاربر نشان داده نشده‌است)',
	'diff-multi-manyusers' => '({{PLURAL:$1|یک|$1}} ویرایش میانی توسط بیش از {{PLURAL:$2|یک|$2}} کاربر نشان داده نشده‌است)',
	'datedefault' => 'بدون ترجیح',
	'defaultns' => 'در غیر این صورت جستجو در این فضاهای نام:',
	'default' => 'پیش‌فرض',
	'diff' => 'تفاوت',
	'destfilename' => 'نام پروندهٔ مقصد:',
	'duplicatesoffile' => '{{PLURAL:$1|پروندهٔ|پرونده‌های}} زیر نسخهٔ تکراری این پرونده {{PLURAL:$1|است|هستند}} ([[Special:FileDuplicateSearch/$2|اطلاعات بیشتر]]):',
	'download' => 'بارگیری',
	'disambiguations' => 'صفحه‌های دارای پیوند به صفحه‌های ابهام‌زدایی',
	'disambiguationspage' => 'Template:ابهام‌زدایی',
	'disambiguations-text' => "صفحه‌های زیر پیوندی به یک '''صفحهٔ ابهام‌زدایی''' هستند.
این صفحه‌ها باید در عوض به موضوعات مرتبط پیوند داده شوند.<br />
یک صفحه هنگامی صفحهٔ ابهام‌زدایی در نظر گرفته می‌شود که در آن از الگویی که به [[MediaWiki:Disambiguationspage]] پیوند دارد استفاده شده باشد.",
	'doubleredirects' => 'تغییرمسیرهای دوتایی',
	'doubleredirectstext' => 'این صفحه فهرستی از صفحه‌های تغییرمسیری را ارائه می‌کند که به صفحهٔ تغییرمسیر دیگری اشاره می‌کنند.
هر سطر دربردارندهٔ پیوندهایی به تغییرمسیر اول و دوم و همچنین مقصد تغییرمسیر دوم است، که معمولاً صفحهٔ مقصد واقعی است و نخستین تغییرمسیر باید به آن اشاره کند.
موارد <del>خط خورده</del> درست شده‌اند.',
	'double-redirect-fixed-move' => '[[$1]] انتقال داده شده‌است، و در حال حاضر تغییرمسیری به [[$2]] است',
	'double-redirect-fixed-maintenance' => 'رفع تغییرمسیر دوتایی از [[$1]] به [[$2]].',
	'double-redirect-fixer' => 'تعمیرکار تغییرمسیرها',
	'deadendpages' => 'صفحه‌های بن‌بست',
	'deadendpagestext' => 'صفحه‌های زیر به هیچ صفحهٔ دیگری در {{SITENAME}} پیوند ندارند.',
	'deletedcontributions' => 'مشارکت‌های حذف‌شده',
	'deletedcontributions-title' => 'مشارکت‌های حذف‌شده',
	'defemailsubject' => 'پست الکترونیکی {{SITENAME}} از طرف کاربر «$1»',
	'deletepage' => 'حذف صفحه',
	'delete-confirm' => 'حذف «$1»',
	'delete-legend' => 'حذف',
	'deletedtext' => '«$1» حذف شد.
برای سابقهٔ حذف‌های اخیر به $2 مراجعه کنید.',
	'dellogpage' => 'سیاههٔ حذف',
	'dellogpagetext' => 'فهرست زیر فهرستی از آخرین حذف‌هاست.
همهٔ زمان‌های نشان‌داده‌شده زمان خادم (وقت گرینویچ) است.',
	'deletionlog' => 'سیاههٔ حذف',
	'deletecomment' => 'دلیل:',
	'deleteotherreason' => 'دلیل دیگر/اضافی:',
	'deletereasonotherlist' => 'دلیل دیگر',
	'deletereason-dropdown' => '*دلایل متداول حذف
** درخواست کاربر
** نقض حق تکثیر
** خرابکاری',
	'delete-edit-reasonlist' => 'ویرایش دلایل حذف',
	'delete-toobig' => 'این صفحه تاریخچهٔ ویرایشی بزرگی دارد، که شامل بیش از $1 {{PLURAL:$1|نسخه|نسخه}} است.
به منظور جلوگیری از اختلال ناخواسته در {{SITENAME}} حذف این گونه صفحه‌ها محدود شده‌است.',
	'delete-warning-toobig' => 'این صفحه تاریخچهٔ ویرایشی بزرگی دارد، که شامل بیش از $1 {{PLURAL:$1|نسخه|نسخه}} است.
حذف آن ممکن است که عملکرد پایگاه دادهٔ {{SITENAME}} را مختل کند;
با احتیاط ادامه دهید.',
	'databasenotlocked' => 'پایگاه داده قفل نیست.',
	'delete_and_move' => 'حذف و انتقال',
	'delete_and_move_text' => '== نیاز به حذف ==

مقالهٔ مقصد «[[:$1]]» وجود دارد. آیا می‌خواهید آن را حذف کنید تا انتقال ممکن شود؟',
	'delete_and_move_confirm' => 'بله، صفحه حذف شود',
	'delete_and_move_reason' => 'حذف برای ممکن‌شدن انتقال  «[[$1]]»',
	'djvu_page_error' => 'صفحهٔ DjVu خارج از حدود مجاز',
	'djvu_no_xml' => 'امکان پیدا کردن پروندهٔ XML برای استفادهٔ DjVu وجود نداشت.',
	'deletedrevision' => '$1 نسخهٔ حذف شدهٔ قدیمی',
	'days' => '{{PLURAL: $1|روز|روز}}',
	'deletedwhileediting' => "'''هشدار''': این صفحه پس از اینکه شما آغاز به ویرایش آن کرده‌اید، حذف شده است!",
	'descending_abbrev' => 'نزولی',
	'duplicate-defaultsort' => 'هشدار: ترتیب پیش‌فرض «$2» ترتیب پیش‌فرض قبلی «$1» را باطل می‌کند.',
	'dberr-header' => 'این ویکی یک ایراد دارد',
	'dberr-problems' => 'شرمنده!
این تارنما از مشکلات فنی رنج می‌برد.',
	'dberr-again' => 'چند دقیقه صبر کند و دوباره صفحه را بارگیری کنید.',
	'dberr-info' => '(امکان برقراری ارتباط با کارساز پایگاه داده وجود ندارد: $1)',
	'dberr-usegoogle' => 'شما در این مدت می‌توانید با استفاده از گوگل جستجو کنید.',
	'dberr-outofdate' => 'توجه کنید که نمایه‌های آن‌ها از محتوای ما ممکن است به روز نباشد.',
	'dberr-cachederror' => 'آن‌چه در ادامه می‌آید یک کپی از صفحهٔ درخواست شده است که در کاشه قرار دارد، و ممکن است به روز نباشد.',
);

$messages['fi'] = array(
	'december' => 'joulukuu',
	'december-gen' => 'joulukuun',
	'dec' => 'joulukuu',
	'delete' => 'Poista',
	'deletethispage' => 'Poista tämä sivu',
	'disclaimers' => 'Vastuuvapaus',
	'disclaimerpage' => 'Project:Vastuuvapaus',
	'databaseerror' => 'Tietokantavirhe',
	'dberrortext' => 'Tietokantakyselyssä oli syntaksivirhe.
Se saattaa johtua ohjelmointivirheestä.
Viimeinen tietokantakysely, jota yritettiin, oli:
<blockquote><tt>$1</tt></blockquote>.
Se tehtiin funktiosta ”<tt>$2</tt>”.
Tietokanta palautti virheen ”<tt>$3: $4</tt>”.',
	'dberrortextcl' => 'Tietokantakyselyssä oli syntaksivirhe. Viimeinen tietokantakysely, jota yritettiin, oli: ”$1”. Se tehtiin funktiosta ”$2”. Tietokanta palautti virheen ”$3: $4”.',
	'directorycreateerror' => 'Hakemiston ”$1” luominen epäonnistui.',
	'deletedhist' => 'Poistettujen versioiden historia',
	'difference' => 'Versioiden väliset erot',
	'difference-multipage' => '(Sivujen välinen eroavaisuus)',
	'diff-multi' => '(Näytettyjen versioiden välissä on {{PLURAL:$1|yksi muokkaus|$1 versiota, jotka ovat {{PLURAL:$2|yhden käyttäjän tekemiä|$2 eri käyttäjän tekemiä}}}}.)',
	'diff-multi-manyusers' => '(Versioiden välissä on {{PLURAL:$1|yksi muu muokkaus|$1 muuta muokkausta, jotka on tehnyt {{PLURAL:$2|yksi käyttäjä|yli $2 eri käyttäjää}}}}.)',
	'datedefault' => 'Ei valintaa',
	'defaultns' => 'Muussa tapauksessa hae näistä nimiavaruuksista:',
	'default' => 'oletus',
	'diff' => 'ero',
	'destfilename' => 'Kohdenimi',
	'duplicatesoffile' => '{{PLURAL:$1|Seuraava tiedosto on tämän tiedoston kaksoiskappale|Seuraavat $1 tiedostoa ovat tämän tiedoston kaksoiskappaleita}} ([[Special:FileDuplicateSearch/$2|lisätietoja]]):',
	'download' => 'lataa',
	'disambiguations' => 'Linkit täsmennyssivuihin',
	'disambiguationspage' => 'Template:Täsmennyssivu',
	'disambiguations-text' => "Seuraavat artikkelit linkittävät ''täsmennyssivuun''. Täsmennyssivun sijaan niiden pitäisi linkittää asianomaiseen aiheeseen.<br />Sivua kohdellaan täsmennyssivuna jos se käyttää mallinetta, johon on linkki sivulta [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Kaksinkertaiset ohjaukset',
	'doubleredirectstext' => 'Tässä listassa on ohjaussivut, jotka ohjaavat toiseen ohjaussivuun.
Jokaisella rivillä on linkit ensimmäiseen ja toiseen ohjaukseen sekä toisen ohjauksen kohteen ensimmäiseen riviin, eli yleensä ”oikeaan” kohteeseen, johon ensimmäisen ohjauksen pitäisi osoittaa.
<del>Yliviivatut</del> kohteet on korjattu.',
	'double-redirect-fixed-move' => '[[$1]] on siirretty, ja se ohjaa nyt sivulle [[$2]]',
	'double-redirect-fixed-maintenance' => 'Korjataan kaksinkertainen ohjaus sivulta [[$1]] sivulle [[$2]]',
	'double-redirect-fixer' => 'Ohjausten korjaaja',
	'deadendpages' => 'Sivut, joilla ei ole linkkejä',
	'deadendpagestext' => 'Seuraavat sivut eivät linkitä muihin sivuihin wikissä.',
	'deletedcontributions' => 'Poistetut muokkaukset',
	'deletedcontributions-title' => 'Poistetut muokkaukset',
	'defemailsubject' => 'Sähköpostia käyttäjältä $1 sivustolta {{SITENAME}}',
	'deletepage' => 'Poista sivu',
	'delete-confirm' => 'Sivun ”$1” poistaminen',
	'delete-legend' => 'Sivun poisto',
	'deletedtext' => '”$1” on poistettu.
Sivulla $2 on lista viimeaikaisista poistoista.',
	'dellogpage' => 'Poistoloki',
	'dellogpagetext' => 'Alla on loki viimeisimmistä poistoista.',
	'deletionlog' => 'poistoloki',
	'deletecomment' => 'Syy',
	'deleteotherreason' => 'Muu syy tai tarkennus',
	'deletereasonotherlist' => 'Muu syy',
	'deletereason-dropdown' => '*Yleiset poistosyyt
** Lisääjän poistopyyntö
** Tekijänoikeusrikkomus
** Roskaa',
	'delete-edit-reasonlist' => 'Muokkaa poistosyitä',
	'delete-toobig' => 'Tällä sivulla on pitkä muutoshistoria – yli $1 {{PLURAL:$1|versio|versiota}}. Näin suurien muutoshistorioiden poistamista on rajoitettu suorituskykysyistä.',
	'delete-warning-toobig' => 'Tällä sivulla on pitkä muutoshistoria – yli $1 {{PLURAL:$1|versio|versiota}}. Näin suurien muutoshistorioiden poistaminen voi haitata sivuston suorituskykyä.',
	'databasenotlocked' => 'Tietokanta ei ole lukittu.',
	'delete_and_move' => 'Poista kohdesivu ja siirrä',
	'delete_and_move_text' => 'Kohdesivu [[:$1]] on jo olemassa. Haluatko poistaa sen, jotta nykyinen sivu voitaisiin siirtää?',
	'delete_and_move_confirm' => 'Poista sivu',
	'delete_and_move_reason' => 'Sivu on sivun [[$1]] siirron tiellä.',
	'djvu_page_error' => 'DjVu-tiedostossa ei ole pyydettyä sivua',
	'djvu_no_xml' => 'DjVu-tiedoston XML-vienti epäonnistui',
	'deletedrevision' => 'Poistettiin vanha versio $1',
	'days' => '{{PLURAL:$1|$1 päivä|$1 päivää}}',
	'deletedwhileediting' => "'''Varoitus''': Tämä sivu on poistettu sen jälkeen, kun aloitit sen muokkaamisen!",
	'descending_abbrev' => 'laskeva',
	'duplicate-defaultsort' => "'''Varoitus:''' Oletuslajitteluavain ”$2” korvaa aiemman oletuslajitteluavaimen ”$1”.",
	'dberr-header' => 'Wikissä on tietokantaongelma',
	'dberr-problems' => 'Tällä sivustolla on teknisiä ongelmia.',
	'dberr-again' => 'Odota hetki ja lataa sivu uudelleen.',
	'dberr-info' => '(Tietokantapalvelimeen yhdistäminen epäonnistui: $1)',
	'dberr-usegoogle' => 'Voit koettaa hakea Googlesta, kunnes virhe korjataan.',
	'dberr-outofdate' => 'Googlen indeksi ei välttämättä ole ajan tasalla.',
	'dberr-cachederror' => 'Alla on välimuistissa oleva sivun versio, joka ei välttämättä ole ajan tasalla.',
	'discuss' => 'Keskustele',
);

$messages['fiu-vro'] = array(
	'december' => 'joulukuu',
	'december-gen' => 'joulukuun',
	'dec' => 'joulukuu',
	'delete' => 'Poista',
	'deletethispage' => 'Poista tämä sivu',
	'disclaimers' => 'Vastuuvapaus',
	'disclaimerpage' => 'Project:Vastuuvapaus',
	'databaseerror' => 'Tietokantavirhe',
	'dberrortext' => 'Tietokantakyselyssä oli syntaksivirhe.
Se saattaa johtua ohjelmointivirheestä.
Viimeinen tietokantakysely, jota yritettiin, oli:
<blockquote><tt>$1</tt></blockquote>.
Se tehtiin funktiosta ”<tt>$2</tt>”.
Tietokanta palautti virheen ”<tt>$3: $4</tt>”.',
	'dberrortextcl' => 'Tietokantakyselyssä oli syntaksivirhe. Viimeinen tietokantakysely, jota yritettiin, oli: ”$1”. Se tehtiin funktiosta ”$2”. Tietokanta palautti virheen ”$3: $4”.',
	'directorycreateerror' => 'Hakemiston ”$1” luominen epäonnistui.',
	'deletedhist' => 'Poistettujen versioiden historia',
	'difference' => 'Versioiden väliset erot',
	'difference-multipage' => '(Sivujen välinen eroavaisuus)',
	'diff-multi' => '(Näytettyjen versioiden välissä on {{PLURAL:$1|yksi muokkaus|$1 versiota, jotka ovat {{PLURAL:$2|yhden käyttäjän tekemiä|$2 eri käyttäjän tekemiä}}}}.)',
	'diff-multi-manyusers' => '(Versioiden välissä on {{PLURAL:$1|yksi muu muokkaus|$1 muuta muokkausta, jotka on tehnyt {{PLURAL:$2|yksi käyttäjä|yli $2 eri käyttäjää}}}}.)',
	'datedefault' => 'Ei valintaa',
	'defaultns' => 'Muussa tapauksessa hae näistä nimiavaruuksista:',
	'default' => 'oletus',
	'diff' => 'ero',
	'destfilename' => 'Kohdenimi',
	'duplicatesoffile' => '{{PLURAL:$1|Seuraava tiedosto on tämän tiedoston kaksoiskappale|Seuraavat $1 tiedostoa ovat tämän tiedoston kaksoiskappaleita}} ([[Special:FileDuplicateSearch/$2|lisätietoja]]):',
	'download' => 'lataa',
	'disambiguations' => 'Linkit täsmennyssivuihin',
	'disambiguationspage' => 'Template:Täsmennyssivu',
	'disambiguations-text' => "Seuraavat artikkelit linkittävät ''täsmennyssivuun''. Täsmennyssivun sijaan niiden pitäisi linkittää asianomaiseen aiheeseen.<br />Sivua kohdellaan täsmennyssivuna jos se käyttää mallinetta, johon on linkki sivulta [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Kaksinkertaiset ohjaukset',
	'doubleredirectstext' => 'Tässä listassa on ohjaussivut, jotka ohjaavat toiseen ohjaussivuun.
Jokaisella rivillä on linkit ensimmäiseen ja toiseen ohjaukseen sekä toisen ohjauksen kohteen ensimmäiseen riviin, eli yleensä ”oikeaan” kohteeseen, johon ensimmäisen ohjauksen pitäisi osoittaa.
<del>Yliviivatut</del> kohteet on korjattu.',
	'double-redirect-fixed-move' => '[[$1]] on siirretty, ja se ohjaa nyt sivulle [[$2]]',
	'double-redirect-fixed-maintenance' => 'Korjataan kaksinkertainen ohjaus sivulta [[$1]] sivulle [[$2]]',
	'double-redirect-fixer' => 'Ohjausten korjaaja',
	'deadendpages' => 'Sivut, joilla ei ole linkkejä',
	'deadendpagestext' => 'Seuraavat sivut eivät linkitä muihin sivuihin wikissä.',
	'deletedcontributions' => 'Poistetut muokkaukset',
	'deletedcontributions-title' => 'Poistetut muokkaukset',
	'defemailsubject' => 'Sähköpostia käyttäjältä $1 sivustolta {{SITENAME}}',
	'deletepage' => 'Poista sivu',
	'delete-confirm' => 'Sivun ”$1” poistaminen',
	'delete-legend' => 'Sivun poisto',
	'deletedtext' => '”$1” on poistettu.
Sivulla $2 on lista viimeaikaisista poistoista.',
	'dellogpage' => 'Poistoloki',
	'dellogpagetext' => 'Alla on loki viimeisimmistä poistoista.',
	'deletionlog' => 'poistoloki',
	'deletecomment' => 'Syy',
	'deleteotherreason' => 'Muu syy tai tarkennus',
	'deletereasonotherlist' => 'Muu syy',
	'deletereason-dropdown' => '*Yleiset poistosyyt
** Lisääjän poistopyyntö
** Tekijänoikeusrikkomus
** Roskaa',
	'delete-edit-reasonlist' => 'Muokkaa poistosyitä',
	'delete-toobig' => 'Tällä sivulla on pitkä muutoshistoria – yli $1 {{PLURAL:$1|versio|versiota}}. Näin suurien muutoshistorioiden poistamista on rajoitettu suorituskykysyistä.',
	'delete-warning-toobig' => 'Tällä sivulla on pitkä muutoshistoria – yli $1 {{PLURAL:$1|versio|versiota}}. Näin suurien muutoshistorioiden poistaminen voi haitata sivuston suorituskykyä.',
	'databasenotlocked' => 'Tietokanta ei ole lukittu.',
	'delete_and_move' => 'Poista kohdesivu ja siirrä',
	'delete_and_move_text' => 'Kohdesivu [[:$1]] on jo olemassa. Haluatko poistaa sen, jotta nykyinen sivu voitaisiin siirtää?',
	'delete_and_move_confirm' => 'Poista sivu',
	'delete_and_move_reason' => 'Sivu on sivun [[$1]] siirron tiellä.',
	'djvu_page_error' => 'DjVu-tiedostossa ei ole pyydettyä sivua',
	'djvu_no_xml' => 'DjVu-tiedoston XML-vienti epäonnistui',
	'deletedrevision' => 'Poistettiin vanha versio $1',
	'days' => '{{PLURAL:$1|$1 päivä|$1 päivää}}',
	'deletedwhileediting' => "'''Varoitus''': Tämä sivu on poistettu sen jälkeen, kun aloitit sen muokkaamisen!",
	'descending_abbrev' => 'laskeva',
	'duplicate-defaultsort' => "'''Varoitus:''' Oletuslajitteluavain ”$2” korvaa aiemman oletuslajitteluavaimen ”$1”.",
	'dberr-header' => 'Wikissä on tietokantaongelma',
	'dberr-problems' => 'Tällä sivustolla on teknisiä ongelmia.',
	'dberr-again' => 'Odota hetki ja lataa sivu uudelleen.',
	'dberr-info' => '(Tietokantapalvelimeen yhdistäminen epäonnistui: $1)',
	'dberr-usegoogle' => 'Voit koettaa hakea Googlesta, kunnes virhe korjataan.',
	'dberr-outofdate' => 'Googlen indeksi ei välttämättä ole ajan tasalla.',
	'dberr-cachederror' => 'Alla on välimuistissa oleva sivun versio, joka ei välttämättä ole ajan tasalla.',
	'discuss' => 'Keskustele',
);

$messages['fj'] = array(
	'december' => 'Tiseba',
	'december-gen' => 'Tiseba',
	'dec' => 'Tiseba',
	'delete' => 'Vakarusa',
	'defemailsubject' => '{{SITENAME}} I vola livaliva',
);

$messages['fo'] = array(
	'december' => 'desember',
	'december-gen' => 'desember',
	'dec' => 'des',
	'delete' => 'Strika',
	'deletethispage' => 'Strika hesa síðuna',
	'disclaimers' => 'Fyrivarni',
	'disclaimerpage' => 'Project:Fyrivarni',
	'databaseerror' => 'Villa í dátagrunni',
	'dberrortext' => '↓ Tað er hend ein syntaks villa í fyrispurninginum til dátugrunnin.
Hetta kann merkja, at tað er feilur í ritbúnaðinum (software).
Seinasta royndin at spyrja dátugrunnin var:
<blockquote><tt>$1</tt></blockquote>
frá funktiónini "<tt>$2</tt>".
Dátugrunnurin sendi feilin aftur "<tt>$3: $4</tt>".',
	'dberrortextcl' => '↓ Ein syntaks feilur hendi í fyrispurningi til dátugrunnin.
Seinasta royndin at leita í dátugrunninum var:
 "$1"
frá funktiónini "$2".
Dátugrunnurin sendi aftur feilmeldingina: "$3: $4"',
	'directorycreateerror' => 'Kundi ikki upprætta mappuna "$1".',
	'deletedhist' => 'Strikingar søga',
	'difference-multipage' => '(Munur millum síður)',
	'diff-multi' => '({{PLURAL:$1|Ein versjón herímillum|$1 versjónir sum liggja ímillum}} av {{PLURAL:$2|einum brúkara|$2 brúkarar}} ikki víst)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Ein versjón sum liggur ímillum|$1 versjónir sum liggja ímillum}} skrivaðar av meira enn $2 {{PLURAL:$2|brúkara|brúkarum}} ikki víst)',
	'defaultns' => 'Um ikki, leita so í hesum navnateigum:',
	'default' => 'standard',
	'diff' => 'munur',
	'destfilename' => 'Destinatión fílunavn:',
	'disambiguations' => 'Síður sum vísa til síður við fleirfaldum týdningi',
	'disambiguationspage' => 'Template:fleiri týdningar',
	'doubleredirects' => 'Tvífaldað ávísing',
	'doubleredirectstext' => 'Henda síða gevur yvirlit yvir síður, sum vísa víðari til aðrar víðaristillaðar síður.
Hvør linja inniheldur leinkjur til ta fyrstu og næstu víðaristillingina, eins væl og málið fyri tað næstu víðaristillingina, sum vanliga er tann "veruliga" endamáls síðan, sum tann fyrsta víðaristillingin átti at peika móti.
<del>Útkrossaðir</del> postar eru loystir.',
	'double-redirect-fixed-move' => '[[$1]] er blivin flutt.
Víðaristilling verður nú gjørd til [[$2]].',
	'deadendpages' => 'Gøtubotnssíður',
	'defemailsubject' => '{{SITENAME}} t-postur frá brúkara $1',
	'deletepage' => 'Strika síðu',
	'deletedtext' => '"$1" er nú strikað.
Sí $2 fyri fulla skráseting av strikingum.',
	'dellogpage' => 'Striku logg',
	'deletionlog' => 'striku logg',
	'deletecomment' => 'Orsøk:',
	'delete_and_move' => 'Strika og flyt',
	'delete_and_move_text' => '==Striking krevst==

Grein við navninum "[[:$1]]" finst longu. Ynskir tú at strika hana til tess at skapa pláss til flytingina?',
	'delete_and_move_confirm' => 'Ja, strika hesa síðuna',
	'delete_and_move_reason' => 'Er strikað fyri at gera pláss til flyting frá "[[$1]]"',
	'duplicate-defaultsort' => '\'\'\'Ávaring:\'\'\' Standard sorteringslykilin "$2" yvirtekur fyrrverandi standard sorteringslykilin "$1".',
);

$messages['fr'] = array(
	'december' => 'décembre',
	'december-gen' => 'décembre',
	'dec' => 'déc',
	'delete' => 'Supprimer',
	'deletethispage' => 'Supprimer cette page',
	'disclaimers' => 'Avertissements',
	'disclaimerpage' => 'Project:Avertissements généraux',
	'databaseerror' => 'Erreur de la base de données',
	'dberrortext' => 'Une erreur de syntaxe de la requête dans la base de données est survenue.
Ceci peut indiquer un bogue dans le logiciel.
La dernière requête traitée par la base de données était :
<blockquote><tt>$1</tt></blockquote>
depuis la fonction « <tt>$2</tt> ».
La base de données a renvoyé l’erreur « <tt>$3 : $4</tt> ».',
	'dberrortextcl' => 'Une requête dans la base de données comporte une erreur de syntaxe.
La dernière requête émise était :
« $1 »
dans la fonction « $2 ».
La base de données a renvoyé l’erreur « $3 : $4 ».',
	'directorycreateerror' => 'Impossible de créer le dossier « $1 ».',
	'deletedhist' => 'Historique supprimé',
	'difference' => '(Différences entre les versions)',
	'difference-multipage' => '(Différence entre les pages)',
	'diff-multi' => '({{PLURAL:$1|Une révision intermédiaire|$1 révisions intermédiaires}} par {{PLURAL:$2|un utilisateur|$2 utilisateurs}} {{PLURAL:$1|est masquée|sont masquées}})',
	'diff-multi-manyusers' => "({{PLURAL:$1|Une révision intermédiaire|$1 révisions intermédiaires}} par plus {{PLURAL:$2|d'un utilisateur|de $2 utilisateurs}} {{PLURAL:$1|est masquée|sont masquées}})",
	'datedefault' => 'Aucune préférence',
	'defaultns' => 'Rechercher par défaut dans ces espaces de noms :',
	'default' => 'défaut',
	'diff' => 'diff',
	'destfilename' => 'Nom sous lequel le fichier sera enregistré :',
	'duplicatesoffile' => '{{PLURAL:$1|Le fichier suivant est un duplicata|Les fichiers suivants sont des duplicatas}} de celui-ci ([[Special:FileDuplicateSearch/$2|plus de détails]]) :',
	'download' => 'télécharger',
	'disambiguations' => 'Pages ayant des liens vers des pages d’homonymie',
	'disambiguationspage' => 'Template:Homonymie',
	'disambiguations-text' => "Les pages suivantes comportent un lien vers une '''page d’homonymie'''.
Ces liens ambigus devraient plutôt pointer vers le bon article.<br />
Une page est considérée comme une page d’homonymie si elle inclut (directement ou récursivement) un des modèles listés sur [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Doubles redirections',
	'doubleredirectstext' => 'Voici une liste des pages qui redirigent vers des pages qui sont elles-mêmes des pages de redirection.
Chaque entrée contient des liens vers la première et la seconde redirections, ainsi que la première ligne de texte de la seconde page, ce qui fournit habituellement la « vraie » page cible, vers laquelle la première redirection devrait rediriger.
Les entrées <del>barrées</del> ont été résolues.',
	'double-redirect-fixed-move' => 'Cette redirection, dont la cible [[$1]] a été renommée, mène maintenant vers [[$2]].',
	'double-redirect-fixed-maintenance' => 'Corrige la double redirection de [[$1]] vers [[$2]].',
	'double-redirect-fixer' => 'Correcteur de redirection',
	'deadendpages' => 'Pages en impasse',
	'deadendpagestext' => 'Les pages suivantes ne contiennent aucun lien vers d’autres pages du wiki.',
	'deletedcontributions' => 'Contributions supprimées',
	'deletedcontributions-title' => 'Contributions supprimées',
	'defemailsubject' => '{{SITENAME}} Courriel de l’utilisateur « $1 »',
	'deletepage' => 'Supprimer la page',
	'delete-confirm' => 'Supprimer « $1 »',
	'delete-legend' => 'Supprimer',
	'deletedtext' => '« $1 » a été supprimée.
Voir $2 pour une liste des suppressions récentes.',
	'dellogpage' => 'Journal des suppressions de page',
	'dellogpagetext' => 'Voici la liste des suppressions les plus récentes.',
	'deletionlog' => 'journal des suppressions',
	'deletecomment' => 'Motif :',
	'deleteotherreason' => 'Motif autre ou supplémentaire :',
	'deletereasonotherlist' => 'Autre motif',
	'deletereason-dropdown' => '* Motifs de suppression les plus courants
** Demande de l’auteur
** Violation des droits d’auteur
** Vandalisme',
	'delete-edit-reasonlist' => 'Modifier les motifs de suppression de page',
	'delete-toobig' => 'Cette page possède un historique important de modifications, dépassant $1 version{{PLURAL:$1||s}}.
La suppression de telles pages a été restreinte pour prévenir des perturbations accidentelles de {{SITENAME}}.',
	'delete-warning-toobig' => 'Cette page possède un historique important de modifications, dépassant $1 version{{PLURAL:$1||s}}.
La supprimer peut perturber le fonctionnement de la base de données de {{SITENAME}} ;
veuiller ne procéder qu’avec prudence.',
	'databasenotlocked' => 'La base de données n’est pas verrouillée.',
	'delete_and_move' => 'Supprimer et renommer',
	'delete_and_move_text' => '== Suppression requise ==
La page de destination « [[:$1]] » existe déjà.
Êtes-vous certain{{GENDER:||e|}} de vouloir la supprimer pour permettre ce renommage ?',
	'delete_and_move_confirm' => 'Oui, supprimer la page de destination',
	'delete_and_move_reason' => 'Page supprimée pour permettre le renommage depuis "[[$1]]"',
	'djvu_page_error' => 'Page DjVu hors limites',
	'djvu_no_xml' => 'Impossible de récupérer le XML pour le fichier DjVu',
	'deletedrevision' => 'Ancienne version $1 supprimée',
	'days' => '{{PLURAL:$1|$1 jour|$1 jours}}',
	'deletedwhileediting' => "'''Attention''' : cette page a été supprimée après que vous avez commencé à la modifier !",
	'descending_abbrev' => 'décr.',
	'duplicate-defaultsort' => 'Attention : la clé de tri par défaut « $2 » écrase la précédente « $1 ».',
	'dberr-header' => 'Ce wiki a un problème',
	'dberr-problems' => 'Désolé ! Ce site rencontre des difficultés techniques.',
	'dberr-again' => 'Essayez d’attendre quelques minutes et rechargez.',
	'dberr-info' => '(Connexion au serveur de base de données impossible : $1)',
	'dberr-usegoogle' => 'Vous pouvez essayer de chercher avec Google pendant ce temps.',
	'dberr-outofdate' => 'Notez que leurs index de notre contenu peuvent être dépassés.',
	'dberr-cachederror' => 'Ceci est une copie cachée de la page demandée et peut être dépassée.',
	'discuss' => 'Discuter',
);

$messages['frc'] = array(
	'december' => 'de décembre',
	'december-gen' => 'décembre',
	'dec' => 'déc',
	'delete' => 'Supprimer',
	'deletethispage' => 'Supprimer cette page',
	'disclaimers' => 'Avertissements',
	'disclaimerpage' => 'Project:Avertissements ordinaires',
	'databaseerror' => "Erreur de la base d'information",
	'dberrortext' => 'Erreur de syntaxe dans la base d\'information.

Ça pourrait vouloir dire qu\'y a une imperfection dans le software.<br />
La dernière demande faite dans la base d\'information était:
<blockquote><tt>$1</tt></blockquote>
dedans la fonction "<tt>$2</tt>".<br />
MySQL a retourné l\'erreur "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Erreur de syntaxe dans la base d\'information.

La dernière demande faite dans la base d\'information était:
"$1"
dedans la fonction "$2".
MySQL a retourné l\'erreur "$3: $4".',
	'directorycreateerror' => 'Impossible de créer le directoire "$1".',
	'difference' => '(Différences entre les versions)',
	'diff-multi' => '({{PLURAL:$1|Un changement moyen caché|$1 changements moyens cachés}})',
);

$messages['frp'] = array(
	'december' => 'de dècembro',
	'december-gen' => 'de dècembro',
	'dec' => 'dèc',
	'delete' => 'Suprimar',
	'deletethispage' => 'Suprimar ceta pâge',
	'disclaimers' => 'Avèrtissements',
	'disclaimerpage' => 'Project:Avèrtissements g·ènèrals',
	'databaseerror' => 'Èrror de la bâsa de balyês',
	'dberrortext' => 'Una èrror de sintaxa de la requéta dens la bâsa de balyês est arrevâ.
Cen pôt endicar una cofierie dens la programeria.
La dèrriére requéta trètâ per la bâsa de balyês ére :
<blockquote><tt>$1</tt></blockquote>
dês la fonccion « <tt>$2</tt> ».
La bâsa de balyês at retornâ l’èrror « <tt>$3 : $4</tt> ».',
	'dberrortextcl' => 'Una èrror de sintaxa de la requéta dens la bâsa de balyês est arrevâ.
La dèrriére requéta trètâ per la bâsa de balyês ére :
« $1 »
dês la fonccion « $2 ».
La bâsa de balyês at retornâ l’èrror « $3 : $4 ».',
	'directorycreateerror' => 'Empossiblo de fâre lo dossiér « $1 ».',
	'defaultmessagetext' => 'Mèssâjo per dèfôt',
	'deletedhist' => 'Historico suprimâ',
	'difference-title' => 'Difèrences entre les vèrsions de « $1 »',
	'difference-title-multipage' => 'Difèrences entre les pâges « $1 » et « $2 »',
	'difference-multipage' => '(Difèrences entre les pâges)',
	'diff-multi' => '({{PLURAL:$1|Yona vèrsion entèrmèdièra|$1 vèrsions entèrmèdières}} per {{PLURAL:$2|yon usanciér|$2 usanciérs}} {{PLURAL:$1|est pas montrâ|sont pas montrâs}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Yona vèrsion entèrmèdièra|$1 vèrsions entèrmèdières}} per més de $2 usanciér{{PLURAL:$2||s}} {{PLURAL:$1|est pas montrâ|sont pas montrâs}})',
	'datedefault' => 'Gins de prèference',
	'defaultns' => 'Ôtrament rechèrchiér dens cetos èspâços de noms :',
	'default' => 'per dèfôt',
	'diff' => 'dif',
	'destfilename' => 'Nom du fichiér de dèstinacion :',
	'duplicatesoffile' => '{{PLURAL:$1|Ceti fichiér est un doblo|Cetos fichiérs sont des doblos}} de ceti ([[Special:FileDuplicateSearch/$2|més de dètalys]]) :',
	'download' => 'Tèlèchargiér',
	'disambiguations' => 'Pâges qu’ont des lims de vers des pâges d’homonimia',
	'disambiguationspage' => 'Template:Homonimia',
	'disambiguations-text' => "Cetes pâges ont un lim de vers una '''pâge d’homonimia'''.
Devriant pletout pouentar vers una pâge que vat avouéc.<br />
Una pâge est trètâ coment una pâge d’homonimia s’encllut (tot drêt ou ben rècursivament) yon des modèlos listâs dessus [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Redirèccions dobles',
	'doubleredirectstext' => 'Vê-que la lista de les pâges que redirijont vers des pâges que sont lor-mémes des pâges de redirèccion.
Châque entrâ contint des lims de vers la premiére et la seconda redirèccion, et pués la premiére legne de tèxto de la seconda pâge, cen que balye habituèlament la « veré » pâge ciba, de vers laquinta la premiére redirèccion devrêt redirigiér.
Les entrâs <del>barrâs</del> ont étâ solucionâs.',
	'double-redirect-fixed-move' => 'Cela redirèccion, que la ciba [[$1]] at étâ renomâ, mène ora vers [[$2]].',
	'double-redirect-fixed-maintenance' => 'Correge la redirèccion dobla de [[$1]] vers [[$2]].',
	'double-redirect-fixer' => 'Corrèctor de redirèccion',
	'deadendpages' => 'Pâges en cul-de-sac',
	'deadendpagestext' => 'Cetes pâges ont gins de lim de vers d’ôtres pâges de {{SITENAME}}.',
	'deletedcontributions' => 'Contribucions suprimâs',
	'deletedcontributions-title' => 'Contribucions suprimâs',
	'defemailsubject' => 'Mèssâjo de {{SITENAME}} de l’usanciér « $1 »',
	'deletepage' => 'Suprimar la pâge',
	'delete-confirm' => 'Suprimar « $1 »',
	'delete-legend' => 'Suprimar',
	'deletedtext' => '« $1 » at étâ suprimâ.
Vêde lo $2 por una lista de les novèles suprèssions.',
	'dellogpage' => 'Jornal de les suprèssions',
	'dellogpagetext' => 'Vê-que la lista de les suprèssions les ples novèles.',
	'deletionlog' => 'jornal de les suprèssions',
	'deletecomment' => 'Rêson :',
	'deleteotherreason' => 'Ôtra rêson / rêson de ples :',
	'deletereasonotherlist' => 'Ôtra rêson',
	'deletereason-dropdown' => '* Rêsons de suprèssion les ples corentes
** Demanda a l’ôtor
** Violacion du drêt d’ôtor
** Vandalismo',
	'delete-edit-reasonlist' => 'Changiér les rêsons de suprèssion',
	'delete-toobig' => 'Ceta pâge at un historico important, dèpassent $1 vèrsion{{PLURAL:$1||s}}.
La suprèssion de tâles pâges at étâ limitâ por èvitar des pèrturbacions emprèvues de {{SITENAME}}.',
	'delete-warning-toobig' => 'Ceta pâge at un historico important, dèpassent $1 vèrsion{{PLURAL:$1||s}}.
La suprimar pôt troblar lo fonccionement de la bâsa de balyês de {{SITENAME}} ;
a fâre avouéc prudence.',
	'databasenotlocked' => 'La bâsa de balyês est pas vèrrolyê.',
	'delete_and_move' => 'Suprimar et renomar',
	'delete_and_move_text' => '== Suprèssion nècèssèra ==
La pâge de dèstinacion « [[:$1]] » ègziste ja.
La voléd-vos suprimar por pèrmetre lo changement de nom ?',
	'delete_and_move_confirm' => 'Ouè, j’accèpto de suprimar la pâge de dèstinacion por pèrmetre lo changement de nom.',
	'delete_and_move_reason' => 'Pâge suprimâ por pèrmetre lo changement de nom dês « [[$1]] »',
	'djvu_page_error' => 'Pâge DjVu en defôr de les limites',
	'djvu_no_xml' => 'Empossiblo de rècupèrar lo XML por lo fichiér DjVu',
	'deletedrevision' => 'La vielye vèrsion $1 at étâ suprimâ.',
	'days-abbrev' => '$1j',
	'days' => '$1 jorn{{PLURAL:$1||s}}',
	'deletedwhileediting' => "'''Atencion :''' ceta pâge at étâ suprimâ aprés que vos vos éte betâ a la changiér !",
	'descending_abbrev' => 'que dècrêt',
	'duplicate-defaultsort' => "'''Atencion :''' la cllâf de tri per dèfôt « $2 » ècllafe cela « $1 ».",
	'dberr-header' => 'Ceti vouiqui at un problèmo',
	'dberr-problems' => 'Dèsolâ ! Ceti seto rencontre des dificultâts tècniques.',
	'dberr-again' => 'Tâchiéd d’atendre doux-três menutes et pués rechargiéd.',
	'dberr-info' => '(Branchement u sèrvor de bâsa de balyês empossiblo : $1)',
	'dberr-usegoogle' => 'Vos pouede tâchiér de chèrchiér avouéc Google pendent cél temps.',
	'dberr-outofdate' => 'Notâd que lors endèxes de noutron contegnu pôvont étre dèpassâs.',
	'dberr-cachederror' => 'O est una copia cachiê de la pâge demandâ et pôt étre dèpassâ.',
	'duration-seconds' => '$1 second{{PLURAL:$1|a|es}}',
	'duration-minutes' => '$1 menut{{PLURAL:$1|a|es}}',
	'duration-hours' => '$1 hor{{PLURAL:$1|a|es}}',
	'duration-days' => '$1 jorn{{PLURAL:$1||s}}',
	'duration-weeks' => '$1 seman{{PLURAL:$1|a|es}}',
	'duration-years' => '$1 an{{PLURAL:$1||s}}',
	'duration-decades' => '$1 dècèni{{PLURAL:$1|a|es}}',
	'duration-centuries' => '$1 sièclo{{PLURAL:$1||s}}',
	'duration-millennia' => '$1 milènèro{{PLURAL:$1||s}}',
);

$messages['frr'] = array(
	'december' => 'Detsämber',
	'december-gen' => 'Detsämber',
	'dec' => 'Det.',
	'delete' => 'Strike',
	'deletethispage' => 'Jüdeer sid strike',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Dootebånkfäägel',
	'dberrortext' => 'Deer as en dootebånk-fäägel aptrin.
Di grün koon en programiirfäägel weese.
Jü leest dootebånk ouffrååg wus:
<blockquote><tt>$1</tt></blockquote>
üt jü funksjoon „<tt>$2</tt>“.
Jü dootebank mäldede di fäägel „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Dåt jäif en süntaksfäägel önj e dootebånk-ouffrååch.
Jü leest dootebånkouffrååch wus  „$1“ üt e funksjoon „<tt>$2</tt>“.
Jü dootebånk mälded jü fäägel: „<tt>$3: $4</tt>“.',
	'directorycreateerror' => 'Dåt fertiiknis "$1" köö ai mååged wårde.',
	'deletedhist' => 'Straagene färsjoone',
	'difference' => '(Ferschääl twasche Färsjoone)',
	'difference-multipage' => '(Ferschääl twasche side)',
	'diff-multi' => '({{PLURAL:$1|Ian wersjuun diartesken|$1 wersjuunen diartesken}} faan {{PLURAL:$2|ään brüker|$2 brükern}} {{PLURAL:$1|woort|wurd}} ei uunwiset)',
	'datedefault' => 'Foor-önjstaling',
	'defaultns' => 'Ouers säk önj jüheer noomerüme:',
	'default' => 'Forinstaling',
	'diff' => 'ferschääl',
	'disambiguationspage' => 'Template:Muardüüdag artiikel',
	'deletepage' => 'Sid tunintemååge',
	'delete-legend' => 'Strike',
	'deletedtext' => '„$1“ wörd tunintemååged. In e $2 fanst dü en list foon da tuleest tunintemåågede side.',
	'dellogpage' => 'Tunintemååg-Logbök',
	'deletecomment' => 'Grün:',
	'deleteotherreason' => 'Ouderen/tubaikaamenden grün:',
	'deletereasonotherlist' => 'Ouderen grün',
	'duplicate-defaultsort' => '\'\'\'Paase üüb:\'\'\' Di sortiarkai "$2" auerskraft di ual sortiarkai "$1"',
);

$messages['fur'] = array(
	'december' => 'Dicembar',
	'december-gen' => 'Dicembar',
	'dec' => 'Dic',
	'delete' => 'Elimine',
	'deletethispage' => 'Elimine cheste pagjine',
	'disclaimers' => 'Avîs legâi',
	'disclaimerpage' => 'Project:Avîs gjenerâi',
	'databaseerror' => 'Erôr de base di dâts',
	'difference' => '(Difarence jenfri des revisions)',
	'diff-multi' => '({{PLURAL:$1|Une revision intermedie|$1 revisions intermediis}} di {{PLURAL:$2|un utent no mostrade|$2 utents no mostradis}})',
	'datedefault' => 'Nissune preference',
	'defaultns' => 'Se no, cîr in chescj spazis dai nons:',
	'default' => 'predeterminât',
	'diff' => 'difarencis',
	'destfilename' => 'Non dal file di destinazion:',
	'download' => 'discjame',
	'disambiguations' => 'Pagjinis di disambiguazion',
	'disambiguationspage' => 'Template:disambig',
	'doubleredirects' => 'Re-indreçaments doplis',
	'deadendpages' => 'Pagjinis cence usite',
	'deletedcontributions' => 'Contribûts dal utent eliminâts',
	'deletedcontributions-title' => 'Contribûts dal utent eliminâts',
	'defemailsubject' => 'Messaç di {{SITENAME}}',
	'deletepage' => 'Elimine pagjine',
	'delete-confirm' => 'Elimine "$1"',
	'delete-legend' => 'Elimine',
	'deletedtext' => '"$1" al è stât eliminât.
Cjale $2 par une liste des ultimis eliminazions.',
	'dellogpage' => 'Regjistri des eliminazions',
	'deletionlog' => 'regjistri eliminazions',
	'deletecomment' => 'Reson:',
	'deleteotherreason' => 'Altri motîf o motîf in plui:',
	'deletereasonotherlist' => 'Altri motîf',
	'delete_and_move' => 'Elimine e môf',
	'delete_and_move_confirm' => 'Sì, elimine la pagjine',
	'descending_abbrev' => 'disc',
	'duplicate-defaultsort' => "'''Avîs:''' La clâf predeterminade par l'ordenament \"\$2\" invalide la clâf predeterminade precedente \"\$1\".",
	'dberr-header' => 'Cheste wiki e à un probleme',
	'dberr-problems' => 'Nus displâs, chest sît web al è daûr a vê dificoltâts tecnichis.',
	'dberr-again' => 'Prove a spietâ uns minûts e po torne a cjamâ la pagjine.',
	'dberr-info' => '(No si pues contatâ il servidor de base di dâts: $1)',
);

$messages['fy'] = array(
	'december' => 'desimber',
	'december-gen' => 'desimber',
	'dec' => 'des',
	'delete' => 'Wiskje',
	'deletethispage' => 'Side wiskje',
	'disclaimers' => 'Foarbehâld',
	'disclaimerpage' => 'Project:Algemien foarbehâld',
	'databaseerror' => 'Databankfout',
	'dberrortext' => 'Sinboufout in databankfraach.
De lêst besochte databankfraach wie:
<blockquote><tt>$1</tt></blockquote>
fan funksje "<tt>$2</tt>" út.
MySQL joech fout "<tt>$3: $4</tt>" werom.',
	'dberrortextcl' => 'Sinboufout yn databankfraach.
De lêst besochte databankfraach wie:
"$1"
fanút funksje "$2" .
MySQL joech fout "$3: $4"',
	'directorycreateerror' => 'Map "$1" koe net oanmakke wurde.',
	'deletedhist' => 'Wiske skiednis',
	'difference' => '(Ferskil tusken ferzjes)',
	'diff-multi' => '({{PLURAL:$1|Ien tuskenlizzende ferzje wurdt|$1 tuskenlizzende ferzjes wurde}} net sjen litten.)',
	'datedefault' => 'Gjin foarkar',
	'defaultns' => "Nammeromten dy't normaal trochsocht wurde:",
	'default' => 'standert',
	'diff' => 'ferskil',
	'destfilename' => 'Triemnamme om op te slaan:',
	'duplicatesoffile' => '{{PLURAL:$1|De folgjende triem is|De folgjende $1 triemmen binne}} idintyk oan dizze triem:',
	'download' => 'oanbiede',
	'disambiguations' => 'Betsjuttingssiden',
	'disambiguationspage' => 'Template:Neibetsjuttings',
	'disambiguations-text' => "De ûndersteande siden keppelje mei in '''Betsjuttingssiden'''.
Se soenen mei de side sels keppele wurde moatte.<br /> In side wurdt sjoen as betsjuttingssiden, as de side ien berjocht fan [[MediaWiki:Disambiguationspage]] brûkt.",
	'doubleredirects' => 'Dûbelde synonimen',
	'doubleredirectstext' => '<b>Let op!</b> Der kinne missen yn dizze list stean! Dat komt dan ornaris troch oare keppelings ûnder de "#REDIRECT". Eltse rigel jout keppelings nei it earste synonym, it twadde synonym en dan it werklike doel.',
	'double-redirect-fixed-move' => '[[$1]] is ferplakt en is no in trochferwizing nei [[$2]]',
	'double-redirect-fixer' => 'Trochferwizings himmelje',
	'deadendpages' => 'Siden sûnder ferwizings',
	'deadendpagestext' => 'De ûndersteande siden ferwize net nei oare siden yn {{SITENAME}}.',
	'deletedcontributions' => 'Wiske meidogger bydragen',
	'deletedcontributions-title' => 'Wiske meidogger bydragen',
	'defemailsubject' => 'E-post fan {{SITENAME}}',
	'deletepage' => 'Wisk side',
	'delete-confirm' => '"$1" wiskje',
	'delete-legend' => 'Wiskje',
	'deletedtext' => '"$1" is wiske.
Sjoch "$2" foar in list fan wat resint wiske is.',
	'dellogpage' => 'Wiskloch',
	'dellogpagetext' => 'Dit is wat der resint wiske is.
(Tiden oanjûn as UTC).',
	'deletionlog' => 'wiskloch',
	'deletecomment' => 'Reden:',
	'deleteotherreason' => 'Oare/eventuele reden:',
	'deletereasonotherlist' => 'Oare reden',
	'deletereason-dropdown' => '*Faak-brûkte redenen
** Frege troch de skriuwer
** Skeining fan auteursrjocht
** Fandalisme',
	'delete_and_move' => 'Wiskje en werneam',
	'delete_and_move_text' => '== Wiskjen nedich ==
De doelside "[[:$1]]" is der al. Moat dy wiske wurde om plak te meitsjen foar it werneamen?',
	'delete_and_move_confirm' => 'Ja, wiskje de side',
	'delete_and_move_reason' => 'Wiske om plak te meitsjen foar in werneamde side',
);

$messages['ga'] = array(
	'december' => 'Mí na Nollag',
	'december-gen' => 'na Nollag',
	'dec' => 'Noll',
	'delete' => 'Scrios',
	'deletethispage' => 'Scrios an lch seo',
	'disclaimers' => 'Séanadh',
	'disclaimerpage' => 'Project:Séanadh_ginearálta',
	'databaseerror' => 'Earráid sa bhunachar sonraí',
	'dberrortext' => 'Tharla earráid chomhréire in iarratas chuig an mbunachar sonraí.
B\'fhéidir gur fabht sa bhogearraí é seo.
Seo é an t-iarratas deireanach chuig an mbunachar sonrai:
<blockquote><tt>$1</tt></blockquote>
ón bhfeidhm "<tt>$2</tt>".
Thug MySQL an earráid seo: "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Tharla earráid chomhréire in iarratas chuig an bhunachar sonraí.
"$1",
ón bhfeidhm "$2",
ab ea an t-iarratas deireanach chuig an mbunachar sonrai.
Thug MySQL an earráid seo: "$3: $4".',
	'directorycreateerror' => 'Ní féidir an chomhadlann "$1" a chruth.',
	'deletedhist' => 'Stair scriosta',
	'difference' => '(Difríochtaí idir leaganacha)',
	'diff-multi' => '({{PLURAL:$1|Leasú idirmheánach amháin|$1 leasú idirmheánach}} nach thaispeántar.)',
	'datedefault' => 'Is cuma liom',
	'defaultns' => 'Cuardaigh sna ranna seo a los éagmaise:',
	'default' => 'réamhshocrú',
	'diff' => 'difr',
	'destfilename' => 'Comhadainm sprice:',
	'download' => 'íoslódáil',
	'disambiguations' => 'Leathanaigh idirdhealaithe',
	'disambiguationspage' => '{{ns:project}}:Naisc_go_leathanaigh_idirdhealaithe',
	'doubleredirects' => 'Athsheoltaí dúbailte',
	'doubleredirectstext' => '<b>Tabhair faoi deara:</b> B\'fheidir go bhfuil toraidh bréagacha ar an liosta seo.
De ghnáth cíallaíonn sé sin go bhfuil téacs breise le naisc thíos sa chéad #REDIRECT no #ATHSHEOLADH.<br />
 Sa
gach sraith tá náisc chuig an chéad is an dara athsheoladh, chomh maith le chéad líne an dara téacs athsheolaidh. De
ghnáth tugann sé sin an sprioc-alt "fíor".',
	'deadendpages' => 'Leathanaigh chaocha',
	'deletedcontributions' => 'Dréachtaí úsáideora scriosta',
	'deletedcontributions-title' => 'Dréachtaí úsáideora scriosta',
	'defemailsubject' => 'Ríomhphost {{GRAMMAR:genitive|{{SITENAME}}}}',
	'deletepage' => 'Scrios an leathanach',
	'delete-confirm' => 'Scrios "$1"',
	'delete-legend' => 'Scrios',
	'deletedtext' => 'scriosadh "$1".
Féach ar $2 chun cuntas na scriosiadh deireanacha a fháil.',
	'dellogpage' => 'Loga scriosta',
	'dellogpagetext' => 'Seo é liosta de na scriosaidh is déanaí.',
	'deletionlog' => 'cuntas scriosaidh',
	'deletecomment' => 'Fáth:',
	'deleteotherreason' => 'Fáth eile/breise:',
	'deletereasonotherlist' => 'Fáth eile',
	'deletereason-dropdown' => '*Fáthanna coitianta scriosta
** Iarratas ón údar
** Sárú cóipchirt
** Loitiméireacht',
	'databasenotlocked' => 'Níl an bunachar sonraí faoi ghlas.',
	'delete_and_move' => 'Scrios agus athainmnigh',
	'delete_and_move_text' => '==Tá scriosadh riachtanach==
Tá an leathanach sprice ("[[:$1]]") ann cheana féin.
Ar mhaith leat é a scriosadh chun áit a dhéanamh don athainmniú?',
	'delete_and_move_confirm' => 'Tá, scrios an leathanach',
	'delete_and_move_reason' => "Scriosta chun áit a dhéanamh d'athainmniú",
	'deletedrevision' => 'Scriosadh an seanleagan $1',
	'deletedwhileediting' => "'''Aire''': scriosadh an leathanach seo nuair a bhí tu ag athrú é!",
);

$messages['gag'] = array(
	'december' => 'Kırım ay',
	'december-gen' => 'Kırım ay',
	'dec' => 'Dek',
	'delete' => 'Sil',
	'deletethispage' => 'Sayfayı sil',
	'disclaimers' => 'Cuvapçılık reti',
	'disclaimerpage' => 'Project:Genel cuvapçılık reti',
	'databaseerror' => 'Data bazası kusurluu',
	'difference' => '(Versiyalar arası farklar)',
	'diff-multi' => '({{PLURAL:$1|Ara versiya|$1 ara versiyalar}} gösterilmedi.)',
	'diff' => 'fark',
	'disambiguations' => 'Maana aydınnatmak yaprakları',
	'doubleredirects' => 'İki kerä yönnendirmeler',
	'deadendpages' => 'Başka sayfalara baalantısız sayfalar',
	'deletepage' => 'Sayfayı sil',
	'deletedtext' => '"$1" silindi.
Yakın zamanda silinenleri görmää deyni: $2.',
	'dellogpage' => 'Silmää jurnalı',
	'deletecomment' => 'Sebep',
	'deleteotherreason' => 'Başka/ek sebep:',
	'deletereasonotherlist' => 'Başka sebep',
);

$messages['gan-hans'] = array(
	'december' => '12月',
	'december-gen' => '十二月',
	'dec' => '12月',
	'delete' => '删吥去',
	'deletethispage' => '删吥个页',
	'disclaimers' => '免责声明',
	'disclaimerpage' => 'Project:免责声明',
	'databaseerror' => '数据库错误',
	'dberrortext' => '数据库查询语法有错。
可能系软件有错。
最晏𠮶数据库指令系:
<blockquote><tt>$1</tt></blockquote>
来自函数 "<tt>$2</tt>"。
MySQL回到错误 "<tt>$3: $4</tt>"。',
	'dberrortextcl' => '数据库查询语法有错。
最晏𠮶数据库指令系:
“$1”
来自函数“$2”。
MySQL回到错误“$3: $4”。',
	'directorycreateerror' => '创建伓正目录 "$1"。',
	'deletedhist' => '删吥𠮶历史',
	'difference' => '（修改之间差异）',
	'diff-multi' => '{{PLURAL:$2|1只用户|$2只用户}}舞𠮶{{PLURAL:$1|一只中途修改|$1只中途修改}}冇拕显示）',
	'datedefault' => '默认项目',
	'defaultns' => '默认搜索𠮶名字空间:',
	'default' => '默认',
	'diff' => '差异',
	'destfilename' => '目标档案名:',
	'download' => '下载',
	'disambiguations' => '扤清楚页',
	'disambiguationspage' => 'Template:扤清楚',
	'disambiguations-text' => "底下𠮶页面都有到'''扤清楚页'''𠮶链接, 但系佢俚应当系连到正当𠮶标题。<br />
如果一只页面系链接自[[MediaWiki:Disambiguationspage]]，佢会拖当成扤清楚页。",
	'doubleredirects' => '双重重定向页面',
	'doubleredirectstext' => '底下𠮶重定向链接到别只重定向页面:',
	'double-redirect-fixed-move' => '[[$1]]拕移动正，佢个下拕重定向到[[$2]]。',
	'double-redirect-fixer' => '重定向𠮶修正器',
	'deadendpages' => '脱接页面',
	'deadendpagestext' => '下底个页面冇连到{{SITENAME}}𠮶别只页面:',
	'defemailsubject' => '{{SITENAME}} 电子邮件',
	'deletepage' => '删卟页面',
	'delete-confirm' => '删卟"$1"去',
	'delete-legend' => '删卟去',
	'deletedtext' => '"$1"删卟嘞。最晏𠮶删除记录请望$2。',
	'dellogpage' => '删除日志',
	'dellogpagetext' => '下底系最晏删除𠮶记录列表:',
	'deletionlog' => '删除日志',
	'deletecomment' => '原因:',
	'deleteotherreason' => '别𠮶/附加理由:',
	'deletereasonotherlist' => '别𠮶理由',
	'deletereason-dropdown' => '*常用删除𠮶理由
** 写𠮶人自家𠮶要求
** 侵犯版权
** 特试破坏',
	'databasenotlocked' => '数据库冇锁正。',
	'delete_and_move' => '删除跟到移动',
	'delete_and_move_text' => '==需要删除==

目标文章"[[:$1]]"存在嘞。为到移动佢，倷要删卟旧页面？',
	'delete_and_move_confirm' => '系𠮶，删卟个页',
	'delete_and_move_reason' => '为到移动删卟佢',
	'djvu_page_error' => 'DjVu页超出范围',
	'djvu_no_xml' => 'DjVu档案拿伓出XML',
	'deletedrevision' => '删卟嘞旧版本$1。',
	'deletedwhileediting' => '警告: 倷编辑𠮶时间有人删卟嘞个页！',
	'descending_abbrev' => '减',
	'duplicate-defaultsort' => '\'\'\'警告：\'\'\'预设𠮶排序键 "$2" 覆蓋先头𠮶预设排序键 "$1"。',
);

$messages['gan-hant'] = array(
	'december' => '12月',
	'december-gen' => '十二月',
	'dec' => '12月',
	'delete' => '刪吥去',
	'deletethispage' => '刪吥箇頁',
	'disclaimers' => '免責聲明',
	'disclaimerpage' => 'Project:免責聲明',
	'databaseerror' => '資料庫錯誤',
	'dberrortext' => '資料庫查詢語法有錯。
可能係軟件有錯。
最晏嗰資料庫指令係:
<blockquote><tt>$1</tt></blockquote>
來自函數 "<tt>$2</tt>"。
MySQL回到錯誤 "<tt>$3: $4</tt>"。',
	'dberrortextcl' => '資料庫查詢語法有錯。
最晏嗰資料庫指令係:
“$1”
來自函數“$2”。
MySQL回到錯誤“$3: $4”。',
	'directorycreateerror' => '創建伓正目錄 "$1"。',
	'deletedhist' => '刪吥嗰歷史',
	'difference' => '（修改之間差異）',
	'diff-multi' => '{{PLURAL:$2|1隻用戶|$2隻用戶}}舞嗰{{PLURAL:$1|一隻中途修改|$1隻中途修改}}冇拕顯示）',
	'datedefault' => '默認項目',
	'defaultns' => '默認搜索嗰名字空間:',
	'default' => '默認',
	'diff' => '差異',
	'destfilename' => '目標檔案名:',
	'download' => '下載',
	'disambiguations' => '扤清楚頁',
	'disambiguationspage' => 'Template:扤清楚',
	'disambiguations-text' => "底下嗰頁面都有到'''扤清楚頁'''嗰連結, 但係佢俚應當係連到正當嗰標題。<br />
如果一隻頁面係連結自[[MediaWiki:Disambiguationspage]]，佢會拕當成扤清楚頁。",
	'doubleredirects' => '雙重重定向頁面',
	'doubleredirectstext' => '底下嗰重定向連結到別隻重定向頁面:',
	'double-redirect-fixed-move' => '[[$1]]拕移動正，佢箇下拕重定向到[[$2]]。',
	'double-redirect-fixer' => '重定向嗰修正器',
	'deadendpages' => '脫接頁面',
	'deadendpagestext' => '下底箇頁面冇連到{{SITENAME}}嗰別隻頁面:',
	'defemailsubject' => '{{SITENAME}} 電子郵件',
	'deletepage' => '刪卟頁面',
	'delete-confirm' => '刪卟"$1"去',
	'delete-legend' => '刪卟去',
	'deletedtext' => '"$1"刪卟嘞。最晏嗰刪除記錄請望$2。',
	'dellogpage' => '刪除日誌',
	'dellogpagetext' => '下底係最晏刪除嗰記錄列表:',
	'deletionlog' => '刪除日誌',
	'deletecomment' => '原因:',
	'deleteotherreason' => '別嗰/附加理由:',
	'deletereasonotherlist' => '別嗰理由',
	'deletereason-dropdown' => '*常用刪除嗰理由
** 寫嗰人自家嗰要求
** 侵犯版權
** 特試破壞',
	'databasenotlocked' => '資料庫冇鎖正。',
	'delete_and_move' => '刪除跟到移動',
	'delete_and_move_text' => '==需要刪除==

目標文章"[[:$1]]"存在嘞。為到移動佢，倷要刪卟舊頁面？',
	'delete_and_move_confirm' => '係嗰，刪卟箇頁',
	'delete_and_move_reason' => '為到移動刪卟佢',
	'djvu_page_error' => 'DjVu頁超出範圍',
	'djvu_no_xml' => 'DjVu檔案拿伓出XML',
	'deletedrevision' => '刪卟嘞舊版本$1。',
	'deletedwhileediting' => '警告: 倷編輯嗰時間有人刪卟嘞箇頁！',
	'descending_abbrev' => '減',
	'duplicate-defaultsort' => '\'\'\'警告：\'\'\'預設嗰排序鍵 "$2" 覆蓋先頭嗰預設排序鍵 "$1"。',
);

$messages['gd'] = array(
	'december' => 'dhen Dùbhlachd',
	'december-gen' => 'dhen Dùbhlachd',
	'dec' => 'dùbh',
	'delete' => 'Sguab às',
	'deletethispage' => 'Sguab às an duilleag seo',
	'disclaimers' => 'Aithrisean-àichidh',
	'disclaimerpage' => 'Project:Aithris-àichidh choitcheann',
	'databaseerror' => 'Mearachd an stòir-dhàta',
	'dberrortext' => 'Thachair mearachd co-chàraidh rè iarrtas an stòir-dhàta.
Faodaidh gu bheil seo a\' comharrachadh mearachd sa bhathar-bhog.
Seo iarrtas an stòir-dhàta mu dheireadh a chaidh feuchainn ris:
<blockquote><tt>$1</tt></blockquote>
o bhroinn an fhoincsein "<tt>$2</tt>".
Thill an stòr-dàta a\' mhearachd "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Thachair mearachd co-chàraidh rè iarrtas an stòir-dhàta.
Seo iarrtas an stòir-dhàta mu dheireadh a chaidh feuchainn ris:
"$1"
o bhroinn an fhoincsein "$2".
Thill an stòr-dàta a\' mhearachd "$3: $4"',
	'directorycreateerror' => 'Cha do ghabh am pasgan "$1" a chruthachadh.',
	'difference' => '(An diofar eadar na mùthaidhean)',
	'diff-multi' => '({{PLURAL:$1|Aon lèirmheas eadar-mheadhanach|$1 lèirmheas eadar-mheadhanach|$1 lèirmheas eadar-mheadhanach|$1 lèirmheas eadar-mheadhanach$1 lèirmheasan eadar-mheadhanach|$1 lèirmheas eadar-mheadhanach}} le {{PLURAL:$2|aon chleachdaiche|$2 chleachdaiche|$2 chleachdaiche|$2 chleachdaiche|$2 cleachdaichean|$2 cleachdaiche}} gun sealltainn)',
	'default' => 'an roghainn bhunaiteach',
	'diff' => 'diof',
	'disambiguationspage' => 'Template:ciallan',
	'doubleredirects' => 'Ath-seòlaidhean dùbailte',
	'deletepage' => 'Sguab às duilleag',
	'delete-confirm' => 'Sguab às "$1"',
	'delete-legend' => 'Sguab às',
	'deletedtext' => 'Chaidh "$1" a sguabadh às.
Seall air $2 airson clàr de dhuilleagan a chaidh a sguabadh às o chionn ghoirid.',
	'dellogpage' => 'Loga an sguabaidh às',
	'deletecomment' => 'Adhbhar:',
	'deleteotherreason' => 'Adhbhar eile/a bharrachd:',
	'deletereasonotherlist' => 'Adhbhar eile',
	'deletereason-dropdown' => "*Adhbharan cumanta airson sguabadh às
** Dh'iarr an t-ùghdar e
** Tha e a' briseadh na còrach-lethbhreac
** Milleadh",
	'delete-edit-reasonlist' => 'Deasaich adhbharan sguabadh às',
	'delete_and_move' => 'Sguab às agus gluais',
	'delete_and_move_confirm' => 'Siuthad, sguab às an duilleag',
	'duplicate-defaultsort' => "'''Rabhadh:''' Tha an iuchair seòrsachaidh bhunaiteach \"\$2\" a' dol thairis air seann iuchair eile, \"\$1\".",
);

$messages['gl'] = array(
	'december' => 'decembro',
	'december-gen' => 'decembro',
	'dec' => 'dec',
	'delete' => 'Borrar',
	'deletethispage' => 'Borrar esta páxina',
	'disclaimers' => 'Advertencias',
	'disclaimerpage' => 'Project:Advertencia xeral',
	'databaseerror' => 'Erro na base de datos',
	'dberrortext' => 'Ocorreu un erro de sintaxe na consulta á base de datos.
Isto pódese deber a un erro no programa.
A última consulta á base de datos foi:
<blockquote><tt>$1</tt></blockquote>
desde a función "<tt>$2</tt>".
A base de datos devolveu o erro "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ocorreu un erro de sintaxe na consulta.
A última consulta á base de datos foi:
"$1"
desde a función "$2".
A base de datos devolveu o erro "$3: $4"',
	'directorycreateerror' => 'Non se puido crear o directorio "$1".',
	'deletedhist' => 'Historial de borrado',
	'difference' => '(Diferenzas entre revisións)',
	'difference-multipage' => '(Diferenzas entre páxinas)',
	'diff-multi' => '(Non se {{PLURAL:$1|mostra unha revisión|mostran $1 revisións}} do historial {{PLURAL:$1|feita|feitas}} por {{PLURAL:$2|un usuario|$2 usuarios}}.)',
	'diff-multi-manyusers' => '(Non se {{PLURAL:$1|mostra unha revisión|mostran $1 revisións}} do historial {{PLURAL:$1|feita|feitas}} por máis {{PLURAL:$2|dun usuario|de $2 usuarios}}.)',
	'datedefault' => 'Ningunha preferencia',
	'defaultns' => 'Se non, procurar nestes espazos de nomes:',
	'default' => 'predeterminado',
	'diff' => 'dif',
	'destfilename' => 'Nome do ficheiro de destino:',
	'duplicatesoffile' => '{{PLURAL:$1|O seguinte ficheiro é un duplicado|Os seguintes $1 ficheiros son duplicados}} destoutro ([[Special:FileDuplicateSearch/$2|máis detalles]]):',
	'download' => 'descargar',
	'disambiguations' => 'Páxinas que ligan con páxinas de homónimos',
	'disambiguationspage' => 'Template:Homónimos',
	'disambiguations-text' => "As seguintes páxinas ligan cunha '''páxina de homónimos'''.
No canto de ligar cos homónimos deben apuntar cara á páxina apropiada.<br />
Unha páxina trátase como páxina de homónimos cando nela se usa un modelo que está ligado desde [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Redireccións dobres',
	'doubleredirectstext' => 'Esta lista contén as páxinas que redirixen cara a outras páxinas de redirección.
Cada ringleira contén ligazóns cara á primeira e segunda redireccións, así como a primeira liña de texto da segunda páxina, que é frecuentemente o artigo "real", á que a primeira redirección debera apuntar.
As entradas <del>riscadas</del> xa foron resoltas.',
	'double-redirect-fixed-move' => 'A páxina "[[$1]]" foi movida, agora é unha redirección cara a "[[$2]]"',
	'double-redirect-fixed-maintenance' => 'Arranxo a redirección dobre entre "[[$1]]" e "[[$2]]".',
	'double-redirect-fixer' => 'Amañador de redireccións',
	'deadendpages' => 'Páxinas sen ligazóns cara a outras',
	'deadendpagestext' => 'Estas páxinas non ligan con ningunha outra páxina de {{SITENAME}}.',
	'deletedcontributions' => 'Contribucións borradas do usuario',
	'deletedcontributions-title' => 'Contribucións borradas do usuario',
	'defemailsubject' => 'Correo electrónico do usuario $1 de {{SITENAME}}',
	'deletepage' => 'Borrar a páxina',
	'delete-confirm' => 'Borrar "$1"',
	'delete-legend' => 'Borrar',
	'deletedtext' => 'Borrouse a páxina "$1".
No $2 pode ver unha lista cos borrados máis recentes.',
	'dellogpage' => 'Rexistro de borrados',
	'dellogpagetext' => 'A continuación atópase a lista cos borrados máis recentes.',
	'deletionlog' => 'rexistro de borrados',
	'deletecomment' => 'Motivo:',
	'deleteotherreason' => 'Outro motivo:',
	'deletereasonotherlist' => 'Outro motivo',
	'deletereason-dropdown' => '*Motivos frecuentes para borrar
** Solicitado polo autor
** Violación dos dereitos de autor
** Vandalismo',
	'delete-edit-reasonlist' => 'Editar os motivos de borrado',
	'delete-toobig' => 'Esta páxina conta cun historial longo, de máis {{PLURAL:$1|dunha revisión|de $1 revisións}}.
Limitouse a eliminación destas páxinas para previr problemas de funcionamento accidentais en {{SITENAME}}.',
	'delete-warning-toobig' => 'Esta páxina conta cun historial de edicións longo, de máis {{PLURAL:$1|dunha revisión|de $1 revisións}}.
Ao eliminala pódense provocar problemas de funcionamento nas operacións da base de datos de {{SITENAME}};
proceda con coidado.',
	'databasenotlocked' => 'A base de datos non está bloqueada.',
	'delete_and_move' => 'Borrar e mover',
	'delete_and_move_text' => '==Precísase borrar==
A páxina de destino, chamada "[[:$1]]", xa existe.
Quérea eliminar para facer sitio para mover?',
	'delete_and_move_confirm' => 'Si, borrar a páxina',
	'delete_and_move_reason' => 'Eliminado para facer sitio para mover "[[$1]]"',
	'djvu_page_error' => 'A páxina DjVu está fóra do rango',
	'djvu_no_xml' => 'Non se puido obter o XML para o ficheiro DjVu',
	'deletedrevision' => 'A revisión vella $1 foi borrada.',
	'days' => '{{PLURAL:$1|$1 día|$1 días}}',
	'deletedwhileediting' => "'''Aviso:''' Esta páxina foi borrada despois de que comezase a editala!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => '\'\'\'Aviso:\'\'\' A clave de ordenación por defecto "$2" anula a clave de ordenación anterior por defecto "$1".',
	'dberr-header' => 'Este wiki ten un problema',
	'dberr-problems' => 'Sentímolo! Este sitio está experimentando dificultades técnicas.',
	'dberr-again' => 'Por favor, agarde uns minutos e logo probe a cargar de novo a páxina.',
	'dberr-info' => '(Non se pode conectar coa base de datos do servidor: $1)',
	'dberr-usegoogle' => 'Mentres tanto, pode probar a buscar co Google.',
	'dberr-outofdate' => 'Teña en conta que os índices de Google do noso contido poden non estar actualizados.',
	'dberr-cachederror' => 'O seguinte contido é unha copia da memoria caché da páxina solicitada, polo que pode non estar actualizada.',
	'discuss' => 'Discusión',
);

$messages['glk'] = array(
	'deletethispage' => 'اَ هنه‌شره پاکأ کون.',
);

$messages['gn'] = array(
	'december' => 'jasypakői',
	'december-gen' => 'jasypakõi',
	'dec' => 'jasypakõi',
	'delete' => "Mboje'o",
	'disclaimers' => 'Marandu leiguigua',
	'difference' => "(Mba'épe ojaovy oñemyatyrõva'ekue)",
	'diff-multi' => '($1 ediciones intermedias no se muestran.)',
	'disambiguations' => 'Kuatiarogue mohesakãporãha',
	'disambiguationspage' => 'Template:Disambig',
	'doubleredirects' => "Ñembohapejey jo'apyre",
	'deadendpages' => "Kuatiarogue ñesẽ'ỹva",
	'dellogpage' => 'Ñemboguepyre ñonagatupy',
	'deletionlog' => 'ñemboguepyre ñonagatupy',
	'delete_and_move' => "Mboje'o ha guerova",
);

$messages['got'] = array(
	'december' => '𐌾𐌹𐌿𐌻𐌴𐌹𐍃',
	'december-gen' => '𐌾𐌹𐌿𐌻𐌴𐌹𐍃',
	'dec' => '𐌾𐌹𐌿',
	'delete' => '𐍄𐌰𐌹𐍂𐌰𐌽',
	'deletethispage' => '𐍄𐌰𐌹𐍂𐌰 𐌸𐍉 𐍃𐌴𐌹𐌳𐍉',
	'disclaimers' => '𐌰𐍆𐌰𐌹𐌺𐌰𐌽 𐍅𐌹𐍄𐍉𐌸',
	'disclaimerpage' => 'Project:𐌰𐍆𐌰𐌹𐌺𐌰𐌽 𐍅𐌹𐍄𐍉𐌸',
	'diff' => '𐌻𐌴𐌹𐌺𐍃',
	'deletepage' => '𐍄𐌰𐌹𐍂𐌰 𐍃𐌴𐌹𐌳𐍉',
	'delete-legend' => '𐍄𐌰𐌹𐍂𐌰𐌽',
	'dellogpage' => '𐍄𐌰𐌹𐍂𐌰 𐌰𐌹𐍂𐍅𐌱𐍉𐌺𐌰',
	'deleteotherreason' => '𐌰𐌽𐌸𐌰𐍂/𐌼𐌰𐌹𐍃 𐌼𐌹𐍄𐍉𐌽𐍃:',
	'deletereasonotherlist' => '𐌰𐌽𐌸𐌰𐍂 𐌼𐌹𐍄𐍉𐌽𐍃',
);

$messages['grc'] = array(
	'december' => 'Δεκέμβριος',
	'december-gen' => 'Δεκεμβρίου',
	'dec' => 'Δεκ',
	'delete' => 'Σβεννύναι',
	'deletethispage' => 'Διαγράφειν τήνδε τὴν δέλτον',
	'disclaimers' => 'Ἀποποιήσεις',
	'disclaimerpage' => 'Project:Γενικὴ ἀποποίησις',
	'databaseerror' => 'Σφάλμα βάσεως δεδομένων',
	'dberrortext' => 'Σφάλμα τι συντάξεως πεύσεως τινὸς πρὸς τὴν βάσιν δεδομένων ἀπήντησεν,
ὅπερ ὑποδηλοῖ τὴν ὕπαρξιν βλάβης τινὸς ἐν τῷ λογισμικῷ.
Ἡ ἐσχάτη ἀποπειραθεῖσα πεῦσις πρὸς τὴν βάσιν δεδομένων ἦν:
<blockquote><tt>$1</tt></blockquote>
ὑπὸ τῆς συναρτήσεως "<tt>$2</tt>".
Ἡ βάσις δεδομένων ἐπέστρεψεν σφάλμα "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Σφάλμα τι συντάξεως πεύσεως τινὸς πρὸς τὴν βάσιν δεδομένων ἀπήντησεν.
Ἡ ὑστάτη ἀπόπειρα πεύσεως πρὸς τὴν βάσιν δεδομένων ἦτο:
"$1"
ὑπὸ τῆς συναρτήσεως "$2".
Ἡ βάσις δεδομένων ἐπέστρεψεν σφάλμα "$3: $4"',
	'directorycreateerror' => 'Οὐκ ἦν δυνατὴ ἡ ποίησις τοῦ ἀρχειοκαταλόγου "$1".',
	'deletedhist' => 'Ἱστορία διαγεγραμμένη',
	'difference' => '(Τὰ μεταβεβλημένα)',
	'diff-multi' => '({{PLURAL:$1|Μία ἐνδιάμεσος ἀναθεώρησις|$1 ἐνδιάμεσοι ἀναθεωρήσεις}} οὐ φαίνονται.)',
	'datedefault' => 'Οὐδεμία προτίμησις',
	'defaultns' => 'Εἰ δὲ ἄλλως, ζήτησον ἐν τοῖσδε ὀνοματικοῖς χώροις:',
	'default' => 'προκαθωρισμένον',
	'diff' => 'διαφ.',
	'destfilename' => 'Ὄνομα τελικοῦ ἀρχείου:',
	'duplicatesoffile' => '{{PLURAL:$1|Τὸ ἀκόλουθον ἀρχεῖον διπλότυπον ἐστὶ|$1 Τὰ ἀκόλουθα ἀρχεῖα διπλότυπα εἰσὶ}} τοῦδε τοῦ ἀρχείου ([[Special:FileDuplicateSearch/$2|πλείω]]):',
	'download' => 'καταφορτίζειν',
	'disambiguations' => 'Σαφηνίσεως δέλτοι',
	'disambiguationspage' => 'Template:σαφήνισις',
	'doubleredirects' => 'Ἀναδιευθύνσεις διπλότυπαι',
	'doubleredirectstext' => 'Ἥδε ἡ δέλτος συγκαταλέγει δέλτους αἵπερ ἀνακατευθύνουσι πρὸς ἑτέρας δέλτους ἀνακατευθύνσεως. Πᾶσα σειρά περιέχει συνδέσμους πρὸς τὴν τε πρώτην καὶ τὴν τε δευτέραν δέλτον ἀνακατευθύνσεως καὶ τὸν τε προορισμὸν τῆς δευτέρας δέλτου ἀνακατευθύνσεως ἥπερ ἐστὶ συνήθως ὁ πραγματικὸς προορισμὸς τῆς ἀνακατευθύνσεως ὅπου σὲ ἔδει δεδεγμένος εἶναι. Τὰ <s>διαγεγραμμένα</s> λήμματα ἐπιλέλυνται.',
	'double-redirect-fixed-move' => 'Ἡ [[$1]] κεκίνηται, τὸ νῦν ἀναδιευθύνεται πρὸς τὴν [[$2]]',
	'double-redirect-fixer' => 'Διορθωτὴς ἀναδιευθύνσεων',
	'deadendpages' => 'Ἀδιέξοδαι δέλτοι',
	'deadendpagestext' => 'Aἱ ἀκόλουθοι δέλτοι μὴ συνδεδεμέναι μετὰ τινῶν ἑτέρων δέλτων ἐν τῷ {{SITENAME}} εἰσίν.',
	'deletedcontributions' => 'Διαγράψαι τοὺς ἐράνους τοῦ χρωμένου',
	'deletedcontributions-title' => 'Διαγράψαι τοὺς ἐράνους τοῦ χρωμένου',
	'defemailsubject' => '{{SITENAME}} ἠλ.-ταχυδρομεῖον',
	'deletepage' => 'Διαγράφειν τὴν δέλτον',
	'delete-confirm' => 'Διαγράφειν "$1"',
	'delete-legend' => 'Διαγράφειν',
	'deletedtext' => 'Τὸ "<nowiki>$1</nowiki>" διεγράφη.
Ἴδε τὸ $2 διὰ μητρῷόν τι προσφάτων διαγραφῶν.',
	'deletedarticle' => 'Ἐσβέσθη ἡ δέλτος "[[$1]]"',
	'dellogpage' => 'Τὰ ἐσβεσμένα',
	'dellogpagetext' => 'Κατωτέρω ἐστὶ διαλογή τις τῶν ὑστάτων διαγραφῶν.',
	'deletionlog' => 'κατάλογος διαγραφῶν',
	'deletecomment' => 'Αἰτία:',
	'deleteotherreason' => 'Αἰτία ἄλλη/πρὀσθετος:',
	'deletereasonotherlist' => 'Αἰτία ἄλλη',
	'deletereason-dropdown' => '*Κοιναὶ αἰτίαι διαγραφῆς
** Αἴτησις τοῦ δημιουργοῦ
** Παραβίασις δικαιωμάτων
** Βαρβαρότης',
	'delete-edit-reasonlist' => 'Μεταγράφειν τὰς αἰτίας διαγραφῆς',
	'databasenotlocked' => 'Ἡ βάσις δεδομένων οὐκ ἐστὶ κεκλῃσμένη.',
	'delete_and_move' => 'Διαγράφειν καὶ κινεῖν',
	'delete_and_move_text' => '==Διαγραφὴ ἀπαραίτητος==
Ἡ ἐγγραφὴ [[:$1]] ὑπάρχει ἤδη. Βούλῃ διαγράψειν τήνδε ἵνα ἐκτελέσηται ἡ μετακίνησις;',
	'delete_and_move_confirm' => 'Ναί, διάγραψον τὴν δέλτον',
	'delete_and_move_reason' => 'Διαγραφεῖσα οὕτως ὥστε ποιηθῇ χῶρος διὰ τὴν μετακίνησιν',
	'djvu_page_error' => 'Δέλτος DjVu ἐκτὸς ἐμβελείας',
	'djvu_no_xml' => 'Ἀδύνατον τὸ προσκομίζειν τὴν XML διὰ τὸ DjVu-ἀρχεῖον',
	'deletedrevision' => 'Προτέρα ἔκδοσις διαγραφεῖσα $1',
	'deletedwhileediting' => "'''Εἴδησις''': Ἥδε ἡ δέλτος διεγράφη πρὸ τοῦ ἄρχειν ὑπἐσοῦ τὸ μεταγράφειν!",
	'descending_abbrev' => 'καταβ',
	'duplicate-defaultsort' => 'Eἴδησις: Ἡ προκαθωρισμένη κλεὶς ταξινομήσεως "$2" ὑπερκαλύπτει προηγουμένην προκαθωρισμένην κλεῖδα ταξινομήσεως "$1".',
	'dberr-header' => 'Τόδε τὸ βίκι ἔχει πρόβλημα',
	'dberr-problems' => 'Συγγνώμην! Ἐμπεφανίκασι τεχνικαὶ δυσχέρειαι.',
	'dberr-again' => 'Πείρασον ἀναμένειν ὀλίγα λεπτὰ τῆς ὥρας καὶ ὕστερον ἐπιφόρτισον πάλιν.',
	'dberr-info' => '(Ἀδύνατος ἡ ἐπαφὴ μετὰ τοῦ ἐξυπηρετητικοῦ συστήματος τῆς βάσεως δεδομένων: $1)',
	'dberr-usegoogle' => 'Ἐν τῷ μεταξὺ χρόνῳ πείρασον τῆν ζήτησιν μέσῳ τοῦ Google.',
	'dberr-outofdate' => 'Αἱ ἐνδείξεις σφῶν περὶ τοῦ περιεχομένου ἡμῶν πιθανῶς ούκ είσὶ ἐνήμεραι.',
	'dberr-cachederror' => 'Τόδε λανθάνον ἀντίγραφόν τι τῆς ἐζητημένης δέλτου ἐστίν, πιθανῶς μὴ ἐνήμερον.',
);

$messages['gsw'] = array(
	'december' => 'Dezämber',
	'december-gen' => 'Dezämber',
	'dec' => 'Dez.',
	'delete' => 'Lösche',
	'deletethispage' => 'Syte lösche',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Fähler in dr Datebank',
	'dberrortext' => 'S isch e Datebankfähler ufträtte.
Dr Grund cha ne e Programmierfähler syy.
Di letscht Datebankabfrog isch
<blockquote><tt>$1</tt></blockquote>
us dr Funktion „<tt>$2</tt>“ gsi.
D Datebank het dr Fähler „<tt>$3: $4</tt>“ gmäldet.',
	'dberrortextcl' => 'S het e Syntaxfähler gee in dr Abfrog vu dr Datebank.
Di letscht Datebankabfrog isch
„$1“
us dr Funktion „$2“ gsi.
D Datebank het dr Fähler „$3: $4“ gmäldet.',
	'directorycreateerror' => 'S Verzeichnis „$1“ het nit chenne aaglait wäre.',
	'deletedhist' => 'Gleschti Versione',
	'difference' => '(Unterschide zwüsche Versione)',
	'difference-multipage' => '(Unterschid zwische Syte)',
	'diff-multi' => '({{PLURAL:$1|Ei Version|$1 Versione}} vu {{PLURAL:$2|eim Benutzer|$2 Benutzer}}, {{PLURAL:$1|wu derzwische lyt, wird|wu derzwische lige, wäre}} nit aazeigt)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Ei Version|$1 Versione}} vu meh {{PLURAL:$2|eim Benutzer|$2 Benutzer}}, {{PLURAL:$1|wu derzwische lyt un nit aazeigt wird|wu derzwische lige un nit aazeigt wäre}})',
	'datedefault' => 'kei Aagab',
	'defaultns' => 'Sunscht in däne Namensryym sueche:',
	'default' => 'Voryystellig',
	'diff' => 'Unterschid',
	'destfilename' => 'Ziilname:',
	'duplicatesoffile' => 'Die {{PLURAL:$1|Datei isch e Duplikat|$1 Dateie sin Duplikat}} vu däre Datei ([[Special:FileDuplicateSearch/$2|meh Detail]]):',
	'download' => 'Abelade',
	'disambiguations' => 'Begriffsklärigssytene',
	'disambiguationspage' => 'Template:Begriffsklärig',
	'disambiguations-text' => 'Die Syte vergleiche uf e Begriffsklärigs-Syte. Sie sotte aber besser uf d Syte vergleiche, wu eigetli gmeint sin.<br />E Syte wird as Begriffsklärigs-Syte behandlet, wänn [[MediaWiki:Disambiguationspage]] uf si vergleicht.<br />Gleicher us Namensryym wäre do nit ufglischtet.',
	'doubleredirects' => 'Doppleti Wyterleitige (Redirects)',
	'doubleredirectstext' => 'Die Lischt zeigt Wyterleitige, wu uf anderi Wyterleitige vergleiche.
In jedere Zyylete het s Gleicher zue dr erschte un dr zwote Wyterleitig un s Ziil vu dr zwote Wyterleitig, wu normalerwys di gwinscht Ziilsyten isch. Do sott eigetli scho di erscht Wyterleitig druf zeige.
<del>Durgstricheni</del> Yytreg sin scho erledigt wore.',
	'double-redirect-fixed-move' => 'doppleti Wyterleitig ufglest: [[$1]] → [[$2]]',
	'double-redirect-fixed-maintenance' => 'Di dopplet Wyterleitig vu [[$1]] no [[$2]] isch ufglest wore.',
	'double-redirect-fixer' => 'DoubleRedirectBot',
	'deadendpages' => 'Artikel ohni Links («Sackgasse»)',
	'deadendpagestext' => 'Die Syte sin nit zue anderi Syte in {{SITENAME}} vergleicht.',
	'deletedcontributions' => 'Gleschti Bytreg',
	'deletedcontributions-title' => 'Gleschti Bytreg',
	'defemailsubject' => '{{SITENAME}}-E-Mail vum Benutzer „$1“',
	'deletepage' => 'Syte lösche',
	'delete-confirm' => '„$1“ lesche',
	'delete-legend' => 'Lesche',
	'deletedtext' => '«$1» isch glescht wore.
Im $2 het s e Lischt vu dr letschte Leschige.',
	'dellogpage' => 'Lösch-Logbuech',
	'dellogpagetext' => 'Des isch s Logbuech vu dr gleschte Syte un Dateie.',
	'deletionlog' => 'Lösch-Logbuech',
	'deletecomment' => 'Grund:',
	'deleteotherreason' => 'Andere/zuesätzleche Grund:',
	'deletereasonotherlist' => 'Andere Grund',
	'deletereason-dropdown' => '* Allgmeini Leschgrind
** Wunsch vum Autor
** Urheberrächtsverletzig
** Vandalismus',
	'delete-edit-reasonlist' => 'Leschgrind bearbeite',
	'delete-toobig' => 'Die Syte het e arg langi Versionsgschicht mit meh as $1 {{PLURAL:$1|Version|Versione}}. S Lesche vu sonige Syte isch yygschränkt wore go verhindere, ass dr Server vu {{SITENAME}} us Versäh zytwys iberlaschtet wird.',
	'delete-warning-toobig' => 'Die Syte het e arg langi Versionsgschicht mit meh as $1 {{PLURAL:$1|Version|Versione}}. S Lesche cha dr Datebankbetriib vu {{SITENAME}} stere.',
	'databasenotlocked' => 'D Datebank isch nüt gsperrt.',
	'delete_and_move' => 'Lösche un Verschiebe',
	'delete_and_move_text' => '== D Ziilsyte isch scho vorhande, lösche?==

D Syte „[[:$1]]“ gits scho. Wottsch du si lösche, zume Platz zum verschiebe mache?',
	'delete_and_move_confirm' => 'D Ziilsyte für d Verschiebig lösche',
	'delete_and_move_reason' => 'glöscht, zume Platz für s Verschiebe vo „[[$1]]“ z mache',
	'djvu_page_error' => 'DjVu-Syte isch uusserhalb vum Sytebereich',
	'djvu_no_xml' => 'XML-Date chönne für d DjVu-Datei nüt abgruefe werde',
	'deletedrevision' => 'alti Version: $1',
	'days' => '{{PLURAL:$1|1 Tag|$1 Täg}}',
	'deletedwhileediting' => "'''Obacht''': Die Syte isch glescht wore, nochdäm Du aagfange hesch si z bearbeite!",
	'descending_abbrev' => 'ab',
	'duplicate-defaultsort' => 'Obacht: Dr Sortierigsschlüssel „$2“ iberschrybt dr vorig brucht Schlüssel „$1“.',
	'dberr-header' => 'Des Wiki het e Probläm',
	'dberr-problems' => 'Excusez! Die Seite het im Momänt tächnischi Schwirigkeite.',
	'dberr-again' => 'Wart e paar Minute un lad derno nej.',
	'dberr-info' => '(Cha kei Verbindig zum Datebank-Server härstelle: $1)',
	'dberr-usegoogle' => 'Du chenntsch in dr Zwischezyt mit Google sueche.',
	'dberr-outofdate' => 'Obacht: Dr Suechindex vu unsere Syte chennt veraltet syy.',
	'dberr-cachederror' => 'Des isch e Kopii vum Cache vu dr Syte, wu Du aagforderet hesch, un chennt veraltet syy.',
);

$messages['gu'] = array(
	'december' => 'ડિસેમ્બર',
	'december-gen' => 'ડિસેમ્બર',
	'dec' => 'ડિસે',
	'delete' => 'રદ કરો',
	'deletethispage' => 'આ પાનું હટાવો',
	'disclaimers' => 'જાહેર ઇનકાર',
	'disclaimerpage' => 'Project:સામાન્ય જાહેર ઇનકાર',
	'databaseerror' => 'ડેટાબેઝ ત્રુટિ',
	'dberrortext' => 'માહિતીસંચ ને અપાયેલ શોધના સૂત્રમાં ચૂક છે.
આ સોફ્ટવેરમાં માં નાની  ત્રુટિ (bug) ને લીધે હોઇ શકે.
માહિતીસંચ પર કરાયેલ છેલ્લામાં છેલ્લી શોધ આ પ્રમાણે હતી:
<blockquote><tt>$1</tt></blockquote>
આ ફંકશન થકી  "<tt>$2</tt>".
માહિતીસંચે આપેલ ચૂકનું વિવરણ "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'માહિતીસંચ ને અપાયેલ શોધના સૂત્રમાં ચૂક છે.
માહિતીસંચ પર કરાયેલ છેલ્લામાં છેલ્લી શોધ આ પ્રમાણે હતી:
"$1"
આ ફંકશન થકી "$2".
માહિતીસંચે આપેલ ચૂકનું વિવરણ  "$3: $4"',
	'directorycreateerror' => 'ડીરેક્ટરી "$1" ન બનાવી શકાઇ.',
	'deletedhist' => 'રદ કરેલનો ઇતિહાસ',
	'difference' => '(પુનરાવર્તનો વચ્ચેનો તફાવત)',
	'difference-multipage' => '(પાનાઓ વચ્ચેનો ફેરફાર)',
	'diff-multi' => '{{PLURAL:$2|એક સભ્યએ કરેલું|$2 સભ્યોએ કરેલા}} ({{PLURAL:$1|વચગાળાનું એક પુનરાવર્તન દર્શાવ્યં|વચગાળાનાં $1 પુનરાવર્તનો દર્શાવ્યાં}} નથી.)',
	'diff-multi-manyusers' => '{{PLURAL:$2|એક સભ્યએ કરેલું|$2 સભ્યોએ કરેલા}} ({{PLURAL:$1|વચગાળાનું એક પુનરાવર્તન દર્શાવ્યં|વચગાળાનાં $1 પુનરાવર્તનો દર્શાવ્યાં}} નથી.)',
	'datedefault' => 'મારી પસંદ',
	'defaultns' => 'અન્યથા આ નામ અવકાશ માં શોધો',
	'default' => 'મૂળ વિકલ્પ',
	'diff' => 'ભેદ',
	'destfilename' => 'લક્ષ્ય ફાઇલ નામ',
	'duplicatesoffile' => 'નીચે જણાવેલ {{PLURAL:$1|ફાઇલ|$1 ફાઇલો}} આ ફાઇલની નકલ છે. ([[Special:FileDuplicateSearch/$2|વધુ વિગતો]])',
	'download' => 'ડાઉનલોડ',
	'disambiguations' => 'સંદિગ્ધ શીર્ષકવાળાં પાનાં સાથે જોડાતાં પૃષ્ઠો',
	'disambiguationspage' => 'Template:અસંદિગ્ધ',
	'disambiguations-text' => "નીચેના પાના  '''સંદિગ્ધ વાક્યો વાળા પાના''' સાથે કડી દ્વારા જોડાયેલા છે.
તેના કરતા તેને યોગ્ય તે વિષ્ય સાથે જોડાયેલા હોવા જોઇએ.<br />
આ પાનાને સંદિગ્ધ  વાક્યો વાળા પાના ત્યારે કહી શકાય જ્યારે તે [[MediaWiki:Disambiguationspage]] નામના ઢાંચા સાથે જોડાયેલા હોય.",
	'doubleredirects' => 'બનણું દિશાનિર્દેશિત',
	'doubleredirectstext' => 'આ પાનું દિશા નિર્દેશિત પાના પર થયેલા દિશા નિર્દેશિત પાનાની યાદિ બતાવે છે.
દરેક લિટીમાં પાના પ્રથમ અને દ્વીતીય દિશા નિર્દેશન ક્ડી બતાવે છે, તે સિવાય દ્વીતીય દિશા નિર્દેશનનું લક્ષ્ય પણ બતાવે છે કે મોટે ભાગે મૂળ પાનું હોઇ શકે છેૢ જેના પર પ્રથમ દિશા નિર્દેશન લક્ષિત છે. <del>Crossed out</del> લિટીઓ  નો ઉત્તર મેળવાયો છે.',
	'double-redirect-fixed-move' => '[[$1]] હટાવી દેવાયું છે.
હવે તે [[$2]] પરાનિર્દેશીત છે.',
	'double-redirect-fixed-maintenance' => '[[$1]] થી [[$2]] સુધી બમણા દિશાનિર્દેશન સમાકરાયા.',
	'double-redirect-fixer' => 'નિર્દેશન સમારનાર',
	'deadendpages' => 'લેખ સમાપ્તિ પાના',
	'deadendpagestext' => 'નીચેના પાના {{SITENAME}}ના અન્ય પાનાને કડીઓ દ્વારા નથી જોડતાં.',
	'deletedcontributions' => 'સભ્યનું યોગદાન ભૂંસી નાખો',
	'deletedcontributions-title' => 'સભ્યનું ભૂંસેલું યોગદાન',
	'defemailsubject' => '{{SITENAME}} સભ્ય $1 તરફથી ઈ-મેલ',
	'deletepage' => 'પાનું હટાવો',
	'delete-confirm' => '$1ને ભૂસી નાંખો.',
	'delete-legend' => 'રદ કરો',
	'deletedtext' => '"$1" દૂર કરવામાં આવ્યું છે.
તાજેતરમાં દૂર કરેલા લેખોની વિગત માટે $2 જુઓ.',
	'dellogpage' => 'હટાવેલાઓનું માહિતિ પત્રક (ડિલિશન લૉગ)',
	'dellogpagetext' => 'હાલમાં હટાવેલ પાનાની યાદિ',
	'deletionlog' => 'હટાવેલાઓનું માહિતિ પત્રક (ડિલિશન લૉગ)',
	'deletecomment' => 'કારણ:',
	'deleteotherreason' => 'અન્ય/વધારાનું કારણ:',
	'deletereasonotherlist' => 'અન્ય કારણ',
	'deletereason-dropdown' => '* હટાવવાનાં સામાન્ય કારણો
** લેખકની વિનંતી
** પ્રકાશનાધિકાર ભંગ
** ભાંગફોડીયા પ્રવૃત્તિ',
	'delete-edit-reasonlist' => 'ભુંસવાનું કારણ બદલો.',
	'delete-toobig' => 'આ પાનાના ફેરફારોનો ઇતિહાસ ખૂબ લાંબો છે , $1 {{PLURAL:$1|ફેરફાર|ફેરફારો}}થી પણ વધારે.
{{SITENAME}}ને અક્સ્માતે ખોરવાતું અટકાવવા આવા પાનાને હટાવવા પર પ્રતિબંધ છે.',
	'delete-warning-toobig' => 'આ પાનાનો ઇતિહાસ ઘણો લાંબો છે લગભગ  $1 {{PLURAL:$1|ફેરફાર|ફેરફારો}}.
તેને ભૂંસતા {{SITENAME}}ના માહિતીસંચને લાગતા કામકાજ પર અસર થૈ શકે છે;
સંભાળ પૂર્વક આગળ વધો.


Deleting it may disrupt database operations of {{SITENAME}};',
	'databasenotlocked' => 'માહિતીસંચ પરા તાળું નથી લગાવી શકાયું',
	'delete_and_move' => 'હટાવો અને નામ બદલો',
	'delete_and_move_text' => '== પાનું દૂર કરવાની જરૂર છે  ==
લક્ષ્ય પાનું  "[[:$1]]" પહેલેથી અસ્તિત્વમાં છે.
શું તમે આને હટાવીને સ્થળાંતર કરવાનો માર્ગ મોકળો કરવા માંગો છો?',
	'delete_and_move_confirm' => 'હા, આ પાનું હટાવો',
	'delete_and_move_reason' => 'હટાવવાનું કામ આગળ વધાવવા ભૂંસી દેવાયુ "[[$1]]"',
	'djvu_page_error' => 'DjVu પાનું સીમાની બહાર',
	'djvu_no_xml' => 'DjVu ફાઇલ માટે XML લાવવા અસમર્થ',
	'deletedrevision' => 'જુના સુધારા ભૂસો $1',
	'days' => '{{PLURAL:$1|$1 દિવસ|$1 દિવસો}}',
	'deletedwhileediting' => "'''ચેતવણી''': તમે ફેરફાર  કર્યા પછી આ પાનું હટાવી દેવાયું !",
	'descending_abbrev' => 'ઉતરતો ક્ર્મ',
	'duplicate-defaultsort' => '\'\'\'ચેતવણી:\'\'\'  કી "$2" આગળનામૂળે પ્રસ્થાપિત ક્રમિકાવર્ગીકરણ કી "$1"નું સ્થાન લઈ લેશે..',
	'dberr-header' => 'આ વિકિમાં તકલીફ છે',
	'dberr-problems' => 'દિલગીરી!
આ સાઇટ તકનિકી અડચણ અનુભવી રહી છે.',
	'dberr-again' => 'થોડી વાર રાહ જોઈને ફરી પેજ લોડ કરવાનો પ્રયત્ન કરો.',
	'dberr-info' => '(માહિતી સંચય સર્વર : $1નો સંપર્ક નથી કરી શકાયો)',
	'dberr-usegoogle' => 'તેસમયા દરમ્યાન તમે ગુગલ દ્વારા શોધી શકો',
	'dberr-outofdate' => 'આપણી માહિતી સંબંધી તેમની સૂચિ કાલાતિત હોઇ શકે.',
	'dberr-cachederror' => 'વિનંતિ કરેલ પાનાની આ એક સંગ્રહીત પ્રત માત્ર છે અને તે અધ્યતન ન પણ હોય.',
);

$messages['gv'] = array(
	'december' => 'Mee ny Nollick',
	'december-gen' => 'Mee ny Nollick',
	'dec' => 'Noll',
	'delete' => 'Scryss',
	'deletethispage' => 'Scryss y duillag shoh',
	'disclaimers' => 'Jiooldeyderyn',
	'disclaimerpage' => 'Project:Obbalys cadjin',
	'deletedhist' => 'Shennaghys scryssit',
	'difference' => '(Anchaslys eddyr aavriwnyssyn)',
	'default' => 'loght',
	'diff' => 'anch',
	'download' => 'laad neose',
	'disambiguations' => 'Duillagyn reddaghyn',
	'doubleredirects' => 'Aa-enmyssyn dooblagh',
	'deadendpages' => 'Duillagyn kione kyagh',
	'deletepage' => 'Scryss y duillag',
	'delete-confirm' => 'Scryss "$1"',
	'delete-legend' => 'Scryss',
	'deletedtext' => 'Ta "<nowiki>$1</nowiki>" scrysst.<br />
Jeeagh er $2 son recortys ny scryssaghyn magh jeianagh.',
	'deletedarticle' => '"[[$1]]" scryssit',
	'dellogpage' => 'Lioar scryssaghyn magh',
	'deletecomment' => 'Fa:',
	'deleteotherreason' => 'Fa elley/tooilley:',
	'deletereasonotherlist' => 'Fa elley',
	'deletereason-dropdown' => '*Fa scryssey cadjin
** Aghin yn ughtar
** Brishey choip-chiart
** Cragheydys',
	'delete_and_move' => 'Scryss as scughey',
	'delete_and_move_confirm' => 'Ta, scryss magh y duillag',
);

$messages['ha'] = array(
	'december' => 'Disamba',
	'december-gen' => 'Disamba',
	'dec' => 'Dic',
	'delete' => 'Soke',
	'disclaimers' => 'Hattara',
	'disclaimerpage' => 'Project:Babban gargaɗi',
	'difference' => '(Bambanci tsakanin zubi da zubi)',
	'diff' => 'bamban',
	'deletepage' => 'Soke shafin',
	'delete-legend' => 'Soke',
	'deletedtext' => 'An soke "$1".
Ku duba $2 ku ga rajistan soke-soke na baya-bayan nan.',
	'dellogpage' => 'Rajistan sauye-sauye',
	'deletecomment' => 'Dalili:',
	'deleteotherreason' => 'Wani dalilin:',
	'deletereasonotherlist' => 'Wani dalili',
);

$messages['hak'] = array(
	'december' => 'Sṳ̍p-ngi-ngie̍t',
	'december-gen' => 'Sṳ̍p-ngi-ngie̍t',
	'dec' => 'Sṳ̍p-ngi-ngie̍t',
	'delete' => 'Chhù-thet',
	'deletethispage' => 'Chhù-thet pún-chông',
	'disclaimers' => 'Miên-chit sâng-mìn',
	'disclaimerpage' => 'Project:Yit-pân ke miên-chit sâng-mìn',
	'databaseerror' => 'Chṳ̂-liau-khu ke chho-ngu',
	'dberrortext' => 'Fat-sên chṳ̂-liau-khu chhà-chhìm fa-ngî chho-ngu. Khó-nèn he ngiôn-thí chhṳ-sṳ̂n ke chho-ngu só yîn-hí. Chui-heu yit-chhṳ chṳ̂-liau-khu chhà-chhìm chṳ́-lin he: <blockquote><tt>$1</tt></blockquote> lòi-chhṳ "<tt>$2</tt>"。 MySQL fán-fì chho-ngu "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Fat-sên liáu yit-ke chṳ̂-liau-khu thiàu-chhà fa-ngî chho-ngu. Chui-heu yit-chhṳ ke chṳ̂-liau-khu thiàu-chhà he: "$1" lòi-ngièn "$2". MySQL fì-chón chho-ngu "$3: $4".',
	'deletedhist' => 'Yí-kîn tshù-me̍t ke li̍t-sṳ́',
	'difference' => '（Siû-thin pán-pún-kiên ke chhâ-yi）',
	'diff-multi' => '（$1-ke chûng-thù ke siû-thin pán-pún mò-yû hién-sṳ.）',
	'datedefault' => 'Yi-sat-chhṳ̍t',
	'defaultns' => 'Yi-sat sêu-sok ke miàng-sṳ khûng-kiên:',
	'default' => 'Yi-sat',
	'diff' => 'chhâ-yi',
	'destfilename' => 'Muk-phêu tóng-on miàng',
	'download' => 'hâ-chai',
	'disambiguations' => 'Sêu-hàm fù-chông',
	'disambiguations-text' => 'Yî-ha ke hong-mien tû-yû to <b> sêu-hàm fù-chông </b> ke lièn-chiap, than yin-kôi he lièn-to sṳt-tông ke phêu-thì. <br /> Yit-ke hong-mien chiông-voi pûn-ngìn sṳ-vi Sêu-hàm fù-chông kó-yèn kí he lièn-chhṳ [[MediaWiki:disambiguationspage]].',
	'doubleredirects' => 'Sûng chhûng-chhûng thin-hiong',
	'doubleredirectstext' => 'Mî yit-hàng pâu-hàm to thi-yit lâu thi-ngi-ke chhûng-thin hong-mien ke lièn-chiap, yî-khi̍p thi-ngi ke chhûng-thin hong-mien ke thi-yit-hàng vùn-sṳ, thûng-sòng hién-sṳ ke he "chṳ̂n-chṳn" ke muk-phêu vùn-chông, ye-he thi-yit-ke chhûng-thin hong-mien  yin-kôi chṳ́-hiong ke vùn-chông.',
	'deadendpages' => 'Thôn-lièn vùn-chông',
	'deadendpagestext' => 'Yî-ha vùn-chông mò-yû pûn lièn-kiet to liá-ke wiki chûng ke khì-thâ vùn-chông:',
	'defemailsubject' => '{{SITENAME}} Email',
	'deletepage' => 'Chhù-thet hong-mien',
	'delete-legend' => 'Chhù-thet',
	'deletedtext' => '"$1" yí-kîn pûn chhù-thet. Chui-khiûn chhù-hi ke ki-liu̍k chhiáng chhâm-siòng $2.',
	'dellogpage' => 'Chhù-chhiang ki-liu̍k',
	'dellogpagetext' => 'Yî-ha he chui-khiûn chhù-thet ke ki-liu̍k lie̍t-péu.',
	'deletionlog' => 'Chhù-chhiang ki-liu̍k',
	'deletecomment' => 'Ngièn-yîn:',
	'deleteotherreason' => 'Khì-thâ/fu-kâ ke lî-yù:',
	'deletereasonotherlist' => 'Khì-thâ lî-yù',
	'databasenotlocked' => 'Chṳ̂-liau-khu mò-yû só-thin.',
	'delete_and_move' => 'Chhù-chhîn lâu yì-thung',
	'delete_and_move_text' => '==Sî-yeu chhù-thet==

Muk-phêu vùn-chông "[[:$1]]" yí-kîn chhùn-chhai.
Ngì khok-ngin sî-yeu chhù-thet ngièn hong-mien khi̍p chin-hàng yì-thung mâ?',
	'delete_and_move_confirm' => 'Chhie̍t-tui, chhù-thet chhṳ́ hong-mien',
	'delete_and_move_reason' => 'Chhù-thet yî-phien yì-thung',
	'djvu_page_error' => 'DjVu hong-mien chhêu-chhut fam-vì',
	'djvu_no_xml' => 'Mò-fap chhai DjVu tóng-on chûng chên-chhí XML',
	'deletedrevision' => 'Yí-kîn chhù-thet khiu-ke pán-pún $1.',
	'deletedwhileediting' => 'Kín-ko: Chhṳ́-hong chhai ngì khôi-sṳ́ phiên-cho chṳ̂-heu yí-kîn pûn Chhù-thet!',
	'descending_abbrev' => 'Suk-siá-kám',
);

$messages['haw'] = array(
	'december' => 'Kēkēmapa',
	'december-gen' => 'Kēkēmapa',
	'dec' => 'Kek',
	'delete' => 'E kāpae',
	'deletethispage' => 'E kāpae i kēia mo‘olelo',
	'disclaimers' => 'Palapala hoʻokuʻu kuleana',
	'disclaimerpage' => 'Project:Palapala hoʻokuʻu kuleana',
	'difference' => '(Ka ʻokoʻa ma waena o nā hoʻololi)',
	'datedefault' => 'ʻAʻohe makemake',
	'default' => 'paʻamau',
	'diff' => '‘oko‘a',
	'deletedcontributions' => 'Nā ha‘awina o ka inoa mea ho‘ohana i kāpae ‘ia ai',
	'deletedcontributions-title' => 'Nā ha‘awina o ka inoa mea ho‘ohana i kāpae ‘ia ai',
	'deletepage' => 'Kāpae ʻaoʻao',
	'deletedtext' => 'Ua kāpae ʻia ʻo "$1".
E ʻike iā $2 no ka papa o nā kāpae ʻana hou.',
	'dellogpage' => 'Mo‘olelo kāpae',
	'dellogpagetext' => 'He helu o nā mea i kāpae ʻia hou i lalo.',
	'deletionlog' => 'mo‘olelo kāpae',
	'deletecomment' => 'Kumu:',
	'deleteotherreason' => 'Kumu ʻē aʻe/hoʻokomo',
	'deletereasonotherlist' => 'Kumu ʻē aʻe',
	'delete-edit-reasonlist' => 'Ho‘opololei i nā kumu no ke kāpae ‘ana',
	'delete_and_move' => 'E kāpae a e ho‘ololi i ka inoa',
	'delete_and_move_confirm' => '‘Ae, e kāpae i ka ‘ao‘ao',
);

$messages['he'] = array(
	'december' => 'דצמבר',
	'december-gen' => 'בדצמבר',
	'dec' => "דצמ'",
	'delete' => 'מחיקה',
	'deletethispage' => 'מחיקת דף זה',
	'disclaimers' => 'הבהרה משפטית',
	'disclaimerpage' => 'Project:הבהרה משפטית',
	'databaseerror' => 'שגיאת בסיס נתונים',
	'dberrortext' => 'אירעה שגיאת תחביר בשאילתה לבסיס הנתונים.
שגיאה זו עלולה להעיד על באג בתוכנה.
השאילתה האחרונה שבוצעה לבסיס הנתונים הייתה:
<blockquote><tt>$1</tt></blockquote>
מתוך הפונקציה "<tt>$2</tt>".
בסיס הנתונים החזיר את השגיאה "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'אירעה שגיאת תחביר בשאילתה לבסיס הנתונים.
השאילתה האחרונה שבוצעה לבסיס הנתונים הייתה:
"$1"
מתוך הפונקציה "$2".
בסיס הנתונים החזיר את השגיאה "$3: $4".',
	'directorycreateerror' => 'יצירת התיקייה "$1" נכשלה.',
	'delete-hook-aborted' => 'המחיקה הופסקה על־ידי מבנה Hook.
לא ניתן הסבר.',
	'defaultmessagetext' => 'טקסט ההודעה המקורי',
	'deletedhist' => 'הגרסאות המחוקות',
	'difference-title' => '$1: הבדלים בין גרסאות',
	'difference-title-multipage' => '$1 ו{{GRAMMAR:תחילית|$2}}: הבדלים בין דפים',
	'difference-multipage' => '(הבדלים בין דפים)',
	'diff-multi' => '({{PLURAL:$1|גרסת ביניים אחת|$1 גרסאות ביניים}} של {{PLURAL:$2|משתמש אחד|$2 משתמשים}} {{PLURAL:$1|אינה מוצגת|אינן מוצגות}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|גרסת ביניים אחת|$1 גרסאות ביניים}} של יותר {{PLURAL:$2|ממשתמש אחד|מ־$2 משתמשים}} {{PLURAL:$1|אינה מוצגת|אינן מוצגות}})',
	'datedefault' => 'ברירת המחדל',
	'defaultns' => 'אחרת, החיפוש יתבצע במרחבי השם הבאים:',
	'default' => 'ברירת מחדל',
	'diff' => 'הבדל',
	'destfilename' => 'שמור קובץ בשם:',
	'duplicatesoffile' => '{{PLURAL:$1|הקובץ הבא זהה|הקבצים הבאים זהים}} לקובץ זה ([[Special:FileDuplicateSearch/$2|לפרטים נוספים]]):',
	'download' => 'הורדה',
	'disambiguations' => 'דפים שמקשרים לדפי פירושונים',
	'disambiguationspage' => 'Template:פירושונים',
	'disambiguations-text' => "הדפים הבאים מקשרים ל'''דפי פירושונים'''.
עליהם לקשר לדף הנושא הרלוונטי במקום זאת.<br />
הדף נחשב לדף פירושונים אם הוא משתמש בתבנית המקושרת מהדף [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'הפניות כפולות',
	'doubleredirectstext' => 'בדף הזה מופיעה רשימת דפי הפניה שמפנים לדפי הפניה אחרים.
כל שורה מכילה קישור לשתי ההפניות הראשונות, וכן את היעד של ההפניה השנייה, שהיא לרוב היעד ה"אמיתי" של ההפניה, שההפניה הראשונה אמורה להצביע אליו.
פריטים <del>מחוקים</del> כבר תוקנו.',
	'double-redirect-fixed-move' => '[[$1]] הועבר. כעת הוא הפניה לדף [[$2]].',
	'double-redirect-fixed-maintenance' => 'תיקון הפניה כפולה מ[[$1]] ל[[$2]].',
	'double-redirect-fixer' => 'מתקן הפניות',
	'deadendpages' => 'דפים ללא קישורים',
	'deadendpagestext' => 'הדפים הבאים אינם מקשרים לדפים אחרים באתר {{SITENAME}}.',
	'deletedcontributions' => 'תרומות משתמש מחוקות',
	'deletedcontributions-title' => 'תרומות משתמש מחוקות',
	'defemailsubject' => 'דוא"ל מ{{grammar:תחילית|{{SITENAME}}}} מהמשתמש "$1"',
	'deletepage' => 'מחיקה',
	'delete-confirm' => 'מחיקת $1',
	'delete-legend' => 'מחיקה',
	'deletedtext' => '"$1" נמחק.
ראו $2 לרשימת המחיקות האחרונות.',
	'dellogpage' => 'יומן מחיקות',
	'dellogpagetext' => 'להלן רשימה של המחיקות האחרונות שבוצעו.',
	'deletionlog' => 'יומן מחיקות',
	'deletecomment' => 'סיבה:',
	'deleteotherreason' => 'סיבה נוספת/אחרת:',
	'deletereasonotherlist' => 'סיבה אחרת',
	'deletereason-dropdown' => '* סיבות מחיקה נפוצות
** לבקשת הכותב
** הפרת זכויות יוצרים
** השחתה',
	'delete-edit-reasonlist' => 'עריכת סיבות המחיקה',
	'delete-toobig' => 'דף זה כולל מעל {{PLURAL:$1|גרסה אחת|$1 גרסאות}} בהיסטוריית העריכות שלו. מחיקת דפים כאלה הוגבלה כדי למנוע פגיעה בביצועי האתר.',
	'delete-warning-toobig' => 'דף זה כולל מעל {{PLURAL:$1|גרסה אחת|$1 גרסאות}} בהיסטוריית העריכות שלו. מחיקה שלו עלולה להפריע לפעולות בבסיס הנתונים; אנא שקלו שנית את המחיקה.',
	'databasenotlocked' => 'בסיס הנתונים אינו נעול.',
	'delete_and_move' => 'מחיקה והעברה',
	'delete_and_move_text' => '== בקשת מחיקה ==
דף היעד, [[:$1]], כבר קיים. האם ברצונכם למחוק אותו כדי לאפשר את ההעברה?',
	'delete_and_move_confirm' => 'אישור מחיקת הדף',
	'delete_and_move_reason' => 'מחיקה כדי לאפשר העברה מ[[$1]]',
	'djvu_page_error' => 'דף ה־DjVu מחוץ לטווח',
	'djvu_no_xml' => 'לא ניתן היה לקבל את ה־XML עבור קובץ ה־DjVu',
	'deletedrevision' => 'מחק גרסה ישנה $1',
	'days' => '{{PLURAL:$1|יום|$1 ימים|יומיים}}',
	'deletedwhileediting' => "'''אזהרה''': דף זה נמחק לאחר שהתחלתם לערוך!",
	'descending_abbrev' => 'יורד',
	'duplicate-defaultsort' => '\'\'\'אזהרה:\'\'\' המיון הרגיל "$2" דורס את המיון הרגיל המוקדם ממנו "$1".',
	'dberr-header' => 'בעיה בוויקי',
	'dberr-problems' => 'מצטערים! קיימת בעיה טכנית באתר זה.',
	'dberr-again' => 'נסו להמתין מספר שניות ולהעלות מחדש את הדף.',
	'dberr-info' => '(לא ניתן ליצור קשר עם שרת הנתונים: $1)',
	'dberr-usegoogle' => 'באפשרותכם לנסות לחפש דרך גוגל בינתיים.',
	'dberr-outofdate' => 'שימו לב שהתוכן שלנו כפי שנשמר במאגר שם עשוי שלא להיות מעודכן.',
	'dberr-cachederror' => 'זהו עותק שמור של המידע, והוא עשוי שלא להיות מעודכן.',
	'duration-seconds' => '{{PLURAL:$1|שנייה|$1 שניות}}',
	'duration-minutes' => '{{PLURAL:$1|דקה|$1 דקות}}',
	'duration-hours' => '{{PLURAL:$1|שעה|$1 שעות|שעתיים}}',
	'duration-days' => '{{PLURAL:$1|יום|$1 ימים|יומיים}}',
	'duration-weeks' => '{{PLURAL:$1|שבוע|$1 שבועות|שבועיים}}',
	'duration-years' => '{{PLURAL:$1|שנה|$1 שנים|שנתיים}}',
	'duration-decades' => '{{PLURAL:$1|עשור|$1 עשורים}}',
	'duration-centuries' => '{{PLURAL:$1|מאה שנה|$1 מאות שנים|מאתיים שנה}}',
	'duration-millennia' => '{{PLURAL:$1|אלף שנה|$1 אלפי שנים|אלפיים שנה}}',
	'discuss' => 'שיחה',
);

$messages['hi'] = array(
	'december' => 'दिसंबर',
	'december-gen' => 'दिसंबर',
	'dec' => 'दिसं॰',
	'delete' => 'हटायें',
	'deletethispage' => 'इस पृष्ठ को हटायें',
	'disclaimers' => 'अस्वीकरण',
	'disclaimerpage' => 'Project:साधारण अस्वीकरण',
	'databaseerror' => 'डाटाबेस गलती',
	'dberrortext' => 'आँकड़ाकोष प्रश्न वाक्यरचना में त्रुटि मिली है।
संभव है कि यह हमारे तंत्रांश में त्रुटि की वजह से हो।
पिछला आँकड़ाकोष प्रश्न था:
<blockquote><tt>$1</tt></blockquote>
 "<tt>$2</tt>" कार्य समूह से।
आँकड़ाकोष की त्रुटि थी "<tt>$3: $4</tt>"।',
	'dberrortextcl' => 'आँकड़ाकोष प्रश्न की वाक्यरचना में त्रुटि मिली।
आँकड़ाकोष में पिछला प्रश्न था:
"$1"
कार्यसमूह "$2" से।
आँकड़ाकोष से त्रुटि आई "$3: $4"',
	'directorycreateerror' => '"$1" डाइरेक्टरी नहीं बना पायें ।',
	'deletedhist' => 'हटाया हुआ इतिहास',
	'difference' => '(संस्करणों में अंतर)',
	'diff-multi' => '({{PLURAL:$1|बीच वाला एक अवतरण|बीचवाले $1 अवतरण}} दर्शाये नहीं हैं ।)',
	'datedefault' => 'खा़स पसंद नहीं',
	'defaultns' => 'अन्यथा इन नामस्थानों में खोजें:',
	'default' => 'अविचल',
	'diff' => 'अंतर',
	'destfilename' => 'लक्ष्य फ़ाईल नाम:',
	'duplicatesoffile' => 'निम्नोक्त {{PLURAL:$1|संचिका इस संचिका की प्रतिलिपि है|$1 संचिकाएँ इस संचिका की प्रतिलिपियाँ हैं}} ([[Special:FileDuplicateSearch/$2|और जानकारी]]):',
	'download' => 'डाउनलोड',
	'disambiguations' => 'डिसऍम्बिग्वीशन पन्ने',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "निम्नांकित पृष्ठ '''असमंजश पृष्ठ''' से जुड़े हुए हैं।
वरन, ये पृष्ठ उपयुक्त विषय से जुड़े हुए होने चाहिए।<br />
यदि कोई पृष्ठ ऐसे सांचे का प्रयोग करता है, जो की [[MediaWiki:Disambiguationspage]] से जुड़ा हुआ है, तो उसे असमंजश पृष्ठ समझा जाता है।",
	'doubleredirects' => 'दुगुनी-अनुप्रेषिते',
	'doubleredirectstext' => 'यह पन्ना उन पन्नों की सूची देता है जो अन्य पुनर्निर्देशित पन्नों की ओर पुनर्निर्देशित होते हैं।
हर कतार में पहले और दूसरे पुनर्निर्देशन की कड़ियाँ, तथा दूसरे पुनर्निर्देशन का लक्ष्य भी है, आमतौर पर यही "वास्तविक" लक्ष्यित पृष्ठ होगा, और पहला पुनर्देशन वास्तव में इसी को लक्ष्यित होना चाहिए था।
<s>एक दूसरे को काटने वाली</s> प्रविष्टियाँ सुलझा दी गई हैं।',
	'double-redirect-fixed-move' => '[[$1]] की जगह बदली जा चुकी है।
अब यह [[$2]] की ओर पुनर्निर्देशित होता है।',
	'double-redirect-fixer' => 'पुनर्निर्देशन मिस्त्री',
	'deadendpages' => 'डेड-एंड पन्ने',
	'deadendpagestext' => 'नीचे दिये पन्नों को {{SITENAME}} पर उपलब्ध अन्य पन्ने जुडते नहीं हैं।',
	'deletedcontributions' => 'हटाये गये सदस्य योगदान',
	'deletedcontributions-title' => 'हटाये गये सदस्य योगदान',
	'defemailsubject' => 'विकिपीडिया ई-मेल',
	'deletepage' => 'पन्ना हटायें',
	'delete-confirm' => '"$1" को हटायें',
	'delete-legend' => 'हटायें',
	'deletedtext' => '"<nowiki>$1</nowiki>" को हटाया गया है ।
हाल में हटाये गये लेखोंकी सूची के लिये $2 देखें ।',
	'deletedarticle' => '"$1" को हटाया गया है।',
	'dellogpage' => 'हटाने की सूची',
	'dellogpagetext' => 'नीचे हाल में हटायें गये पन्नोंकी सूची हैं।',
	'deletionlog' => 'हटाने की सूची',
	'deletecomment' => 'कारण:',
	'deleteotherreason' => 'दुसरा/अतिरिक्त कारण:',
	'deletereasonotherlist' => 'दुसरा कारण',
	'deletereason-dropdown' => '*हटाने के सामान्य कारण
** लेखक कि बिनती
** कॉपीराईट
** वॅन्डॅलिजम',
	'delete-edit-reasonlist' => 'हटाने के कारण संपादित करें',
	'delete-toobig' => 'इस पन्ने का संपादन इतिहास $1 से अधिक {{PLURAL:$1|संस्करण|संस्करण}} होने की वजह से बहुत बड़ा है।
{{SITENAME}} के अनपेक्षित रूप से बंद होने से रोकने के लिये ऐसे पन्नों को हटाने की अनुमति नहीं हैं।',
	'delete-warning-toobig' => 'इस लेख का संपादन इतिहास काफ़ी लंबा चौड़ा है, इसके $1 से अधिक {{PLURAL:$1|संस्करण|संस्करण}} हैं।
इसे हटाने से {{SITENAME}} के आँकड़ाकोष की गतिविधियों में व्यवधान आ सकता है;
कृपया सोच समझ कर आगे बढ़ें।',
	'databasenotlocked' => 'डाटाबेस को ताला नहीं लगाया गया हैं।',
	'delete_and_move' => 'हटाया और नाम बदला',
	'delete_and_move_text' => '==हटाने की जरूरत==
लक्ष्य पृष्ठ "[[:$1]]" पहले से अस्तित्वमें हैं।
नाम बदलने के लिये क्या आप इसे हटाना चाहतें हैं?',
	'delete_and_move_confirm' => 'जी हां, पन्ना हटाईयें',
	'delete_and_move_reason' => 'स्थानांतरण करने के लिये जगह बनाई',
	'djvu_page_error' => 'DjVu पन्ना रेंजके बाहर हैं',
	'djvu_no_xml' => 'DjVu फ़ाईलके लिये XML नहीं मिल पाया',
	'deletedrevision' => 'पुराना अवतरण $1 हटा दिया',
	'deletedwhileediting' => "'''Warning''': आपने जब से संपादन शुरू किया है, उसके बाद से यह पन्ना ही मिटा दिया गया है!",
	'descending_abbrev' => 'ज़ानकारी',
	'duplicate-defaultsort' => '\'\'\'Warning:\'\'\' पुरानी मूल क्रमांकन कुंजी "$1" के बजाय अब मूल क्रमांकन कुंजी "$2" होगी।',
	'dberr-header' => 'इस विकि को कुछ दिक्कत आ रही है',
	'dberr-problems' => 'माफ़ करें! इस स्थल को कुछ तकनीकी दिक्कतों का सामना करना पड़ रहा है।',
	'dberr-again' => 'कुछ मिनट रुकने के बाद फिर से चढ़ाएँ।',
	'dberr-info' => '(आँकड़ाकोष सेवक से संपर्क नहीं हो पा रहा:$1)',
	'dberr-usegoogle' => 'इस बीच आप गूगल से खोज करने की कोशिश कर सकते हैं।',
	'dberr-outofdate' => 'ध्यान दे, हो सकता है कि हमारी सामग्री से संबंधित उनकी सूची बासी हो।',
	'dberr-cachederror' => 'यह अनुरोधित पन्ने की संचित प्रति है, हो सकता है यह ताज़ी न हो।',
);

$messages['hif'] = array(
	'december' => 'दिसंबर',
	'december-gen' => 'दिसंबर',
	'dec' => 'दिसं॰',
	'delete' => 'हटायें',
	'deletethispage' => 'इस पृष्ठ को हटायें',
	'disclaimers' => 'अस्वीकरण',
	'disclaimerpage' => 'Project:साधारण अस्वीकरण',
	'databaseerror' => 'डाटाबेस गलती',
	'dberrortext' => 'आँकड़ाकोष प्रश्न वाक्यरचना में त्रुटि मिली है।
संभव है कि यह हमारे तंत्रांश में त्रुटि की वजह से हो।
पिछला आँकड़ाकोष प्रश्न था:
<blockquote><tt>$1</tt></blockquote>
 "<tt>$2</tt>" कार्य समूह से।
आँकड़ाकोष की त्रुटि थी "<tt>$3: $4</tt>"।',
	'dberrortextcl' => 'आँकड़ाकोष प्रश्न की वाक्यरचना में त्रुटि मिली।
आँकड़ाकोष में पिछला प्रश्न था:
"$1"
कार्यसमूह "$2" से।
आँकड़ाकोष से त्रुटि आई "$3: $4"',
	'directorycreateerror' => '"$1" डाइरेक्टरी नहीं बना पायें ।',
	'deletedhist' => 'हटाया हुआ इतिहास',
	'difference' => '(संस्करणों में अंतर)',
	'diff-multi' => '({{PLURAL:$1|बीच वाला एक अवतरण|बीचवाले $1 अवतरण}} दर्शाये नहीं हैं ।)',
	'datedefault' => 'खा़स पसंद नहीं',
	'defaultns' => 'अन्यथा इन नामस्थानों में खोजें:',
	'default' => 'अविचल',
	'diff' => 'अंतर',
	'destfilename' => 'लक्ष्य फ़ाईल नाम:',
	'duplicatesoffile' => 'निम्नोक्त {{PLURAL:$1|संचिका इस संचिका की प्रतिलिपि है|$1 संचिकाएँ इस संचिका की प्रतिलिपियाँ हैं}} ([[Special:FileDuplicateSearch/$2|और जानकारी]]):',
	'download' => 'डाउनलोड',
	'disambiguations' => 'डिसऍम्बिग्वीशन पन्ने',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "निम्नांकित पृष्ठ '''असमंजश पृष्ठ''' से जुड़े हुए हैं।
वरन, ये पृष्ठ उपयुक्त विषय से जुड़े हुए होने चाहिए।<br />
यदि कोई पृष्ठ ऐसे सांचे का प्रयोग करता है, जो की [[MediaWiki:Disambiguationspage]] से जुड़ा हुआ है, तो उसे असमंजश पृष्ठ समझा जाता है।",
	'doubleredirects' => 'दुगुनी-अनुप्रेषिते',
	'doubleredirectstext' => 'यह पन्ना उन पन्नों की सूची देता है जो अन्य पुनर्निर्देशित पन्नों की ओर पुनर्निर्देशित होते हैं।
हर कतार में पहले और दूसरे पुनर्निर्देशन की कड़ियाँ, तथा दूसरे पुनर्निर्देशन का लक्ष्य भी है, आमतौर पर यही "वास्तविक" लक्ष्यित पृष्ठ होगा, और पहला पुनर्देशन वास्तव में इसी को लक्ष्यित होना चाहिए था।
<s>एक दूसरे को काटने वाली</s> प्रविष्टियाँ सुलझा दी गई हैं।',
	'double-redirect-fixed-move' => '[[$1]] की जगह बदली जा चुकी है।
अब यह [[$2]] की ओर पुनर्निर्देशित होता है।',
	'double-redirect-fixer' => 'पुनर्निर्देशन मिस्त्री',
	'deadendpages' => 'डेड-एंड पन्ने',
	'deadendpagestext' => 'नीचे दिये पन्नों को {{SITENAME}} पर उपलब्ध अन्य पन्ने जुडते नहीं हैं।',
	'deletedcontributions' => 'हटाये गये सदस्य योगदान',
	'deletedcontributions-title' => 'हटाये गये सदस्य योगदान',
	'defemailsubject' => 'विकिपीडिया ई-मेल',
	'deletepage' => 'पन्ना हटायें',
	'delete-confirm' => '"$1" को हटायें',
	'delete-legend' => 'हटायें',
	'deletedtext' => '"<nowiki>$1</nowiki>" को हटाया गया है ।
हाल में हटाये गये लेखोंकी सूची के लिये $2 देखें ।',
	'deletedarticle' => '"$1" को हटाया गया है।',
	'dellogpage' => 'हटाने की सूची',
	'dellogpagetext' => 'नीचे हाल में हटायें गये पन्नोंकी सूची हैं।',
	'deletionlog' => 'हटाने की सूची',
	'deletecomment' => 'कारण:',
	'deleteotherreason' => 'दुसरा/अतिरिक्त कारण:',
	'deletereasonotherlist' => 'दुसरा कारण',
	'deletereason-dropdown' => '*हटाने के सामान्य कारण
** लेखक कि बिनती
** कॉपीराईट
** वॅन्डॅलिजम',
	'delete-edit-reasonlist' => 'हटाने के कारण संपादित करें',
	'delete-toobig' => 'इस पन्ने का संपादन इतिहास $1 से अधिक {{PLURAL:$1|संस्करण|संस्करण}} होने की वजह से बहुत बड़ा है।
{{SITENAME}} के अनपेक्षित रूप से बंद होने से रोकने के लिये ऐसे पन्नों को हटाने की अनुमति नहीं हैं।',
	'delete-warning-toobig' => 'इस लेख का संपादन इतिहास काफ़ी लंबा चौड़ा है, इसके $1 से अधिक {{PLURAL:$1|संस्करण|संस्करण}} हैं।
इसे हटाने से {{SITENAME}} के आँकड़ाकोष की गतिविधियों में व्यवधान आ सकता है;
कृपया सोच समझ कर आगे बढ़ें।',
	'databasenotlocked' => 'डाटाबेस को ताला नहीं लगाया गया हैं।',
	'delete_and_move' => 'हटाया और नाम बदला',
	'delete_and_move_text' => '==हटाने की जरूरत==
लक्ष्य पृष्ठ "[[:$1]]" पहले से अस्तित्वमें हैं।
नाम बदलने के लिये क्या आप इसे हटाना चाहतें हैं?',
	'delete_and_move_confirm' => 'जी हां, पन्ना हटाईयें',
	'delete_and_move_reason' => 'स्थानांतरण करने के लिये जगह बनाई',
	'djvu_page_error' => 'DjVu पन्ना रेंजके बाहर हैं',
	'djvu_no_xml' => 'DjVu फ़ाईलके लिये XML नहीं मिल पाया',
	'deletedrevision' => 'पुराना अवतरण $1 हटा दिया',
	'deletedwhileediting' => "'''Warning''': आपने जब से संपादन शुरू किया है, उसके बाद से यह पन्ना ही मिटा दिया गया है!",
	'descending_abbrev' => 'ज़ानकारी',
	'duplicate-defaultsort' => '\'\'\'Warning:\'\'\' पुरानी मूल क्रमांकन कुंजी "$1" के बजाय अब मूल क्रमांकन कुंजी "$2" होगी।',
	'dberr-header' => 'इस विकि को कुछ दिक्कत आ रही है',
	'dberr-problems' => 'माफ़ करें! इस स्थल को कुछ तकनीकी दिक्कतों का सामना करना पड़ रहा है।',
	'dberr-again' => 'कुछ मिनट रुकने के बाद फिर से चढ़ाएँ।',
	'dberr-info' => '(आँकड़ाकोष सेवक से संपर्क नहीं हो पा रहा:$1)',
	'dberr-usegoogle' => 'इस बीच आप गूगल से खोज करने की कोशिश कर सकते हैं।',
	'dberr-outofdate' => 'ध्यान दे, हो सकता है कि हमारी सामग्री से संबंधित उनकी सूची बासी हो।',
	'dberr-cachederror' => 'यह अनुरोधित पन्ने की संचित प्रति है, हो सकता है यह ताज़ी न हो।',
);

$messages['hif-latn'] = array(
	'december' => 'December',
	'december-gen' => 'December',
	'dec' => 'Dec',
	'delete' => 'Mitao',
	'deletethispage' => 'Ii panna ke mitao',
	'disclaimers' => 'Jimmewari se chhuut',
	'disclaimerpage' => 'Project:Saadharan jimmewari nai lo',
	'databaseerror' => 'Database me galti hai',
	'dberrortext' => 'Database ke khoj me syntax error hoe gais hae.
Saait software me bug hoi.
Pahile waala database ke khoj ke kosis rahaa:
<blockquote><tt>$1</tt></blockquote>
"<tt>$2</tt>" function ke bhitar se.
Database ke galti sandes rahaa "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Database ke khoj me syntax error hoe gais hae.
Pahile waala database ke khoj ke kosis rahaa:
"$1"
"$2" function ke bhitar se.
Database ke galti sandes rahaa "$3: $4"',
	'directorycreateerror' => 'Directory "$1" ke nai banae sakaa.',
	'deletedhist' => 'Mitawa gae itihass',
	'difference' => '(Badlao me farak)',
	'diff-multi' => '({{PLURAL:$1|Ek biich waala badlao|$1 biich waala badlao}} nai dekhawa jae hai.)',
	'datedefault' => 'Koi pasand nai',
	'defaultns' => 'Default se ii namespaces me khojo:',
	'default' => 'baaki',
	'diff' => 'farka',
	'destfilename' => 'Manjil waala file ke naam:',
	'duplicatesoffile' => 'Niche ke suchi waala {{PLURAL:$1|file ke dui copy hai|$1 files ke dui copy hai}} ii file ke ([[Special:FileDuplicateSearch/$2|more details]]):',
	'download' => 'download karo',
	'disambiguations' => 'Disambiguation panna',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Niche ke panna '''disambiguation panna''' se link hoe hai.
They should link to the appropriate topic instead.<br />
A page is treated as disambiguation page if it uses a template which is linked from [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dugna redirects',
	'doubleredirectstext' => 'Ii panna uu panna ke suchi de hai jon ki duusra redirect panna pe redirect kare hai.
Sab row me pahila aur duusra redirect ke jorr hae, aur isme duusra redirect ke nisana bhi hae, jon ki jaada kar ke "aslii" nisana waala panna, jon ki pahila redirect ke dekhae hae.
<s>Mitawa gais</s> entires ke solve kar dewa gais hae.',
	'double-redirect-fixed-move' => '[[$1]] ke naam badal dewa gais hai, ab ii [[$2]] pe redirect kare hai',
	'double-redirect-fixer' => 'Redirect ke banae waala',
	'deadendpages' => 'Jon panna se koi jurre nai hai',
	'deadendpagestext' => 'Niche ke panna {{SITENAME}} ke koi bhi panna se nai jurre hai.',
	'deletedcontributions' => 'Sadasya ke yogdaan ke mitae dia hai',
	'deletedcontributions-title' => 'Sadasya ke yogdaan ke mitae dia hai',
	'defemailsubject' => '{{SITENAME}} e-mail',
	'deletepage' => 'Pana ke delete karo',
	'delete-confirm' => '"$1" ke mitao',
	'delete-legend' => 'Mitao',
	'deletedtext' => '"<nowiki>$1</nowiki>" ke delete kar dewa gais hai. Abhi jaldi ke deletions ke record dekhe khatir $2 ke dekho.',
	'deletedarticle' => '"[[$1]]" ke mitae dewa gais hae',
	'dellogpage' => 'Mitae ke suchi',
	'dellogpagetext' => 'Niche nawaa mitawa gais panna ke suchi hai.',
	'deletionlog' => 'Mitae waala suchi',
	'deletecomment' => 'Kaaran:',
	'deleteotherreason' => 'Aur/duusra kaaran:',
	'deletereasonotherlist' => 'Duusra kaaran',
	'deletereason-dropdown' => '*Sadharan mitae ke kaaran
** Author ke request
** Copyright ke violation
** Vandalism',
	'delete-edit-reasonlist' => 'Mitae ke kaaran ke badlo',
	'delete-toobig' => 'Ii panna ke barraa balao ke itihass hai, $1 se jaada {{PLURAL:$1|revision|revisions}}.
Aisan panna ke mitae pe rok lagawa gais hai so that accidental disruption of {{SITENAME}} ke roka jaae sake hai.',
	'delete-warning-toobig' => 'Ii panna ke lambaa badlao ke itihaas hai, $1 {{PLURAL:$1|revision|revisions}} se jaada.
Iske mitae se {{SITENAME}} me database operations me baadha parri;
sawadhani se aage barrho.',
	'databasenotlocked' => 'Database band nai hai.',
	'delete_and_move' => 'Mitao aur hatao',
	'delete_and_move_text' => '== Mitae ke jaruri hai ==
Destination panna "[[:$1]]" abhi hai.
Ka aap mangta hai ki iske mitae dewa jaae, jisse ki ii naam se duusra paana ke save karaa jaae sake?',
	'delete_and_move_confirm' => 'Haan, panna ke mitao',
	'delete_and_move_reason' => 'Naam badle ke khatir mitao',
	'djvu_page_error' => 'DjVu panna range me nai hae',
	'djvu_no_xml' => ' DjVu file ke XML ke nai paawe sakaa hae',
	'deletedrevision' => 'Purana badlao ke mitae dia hai $1',
	'dberr-header' => 'Ii wiki me kuchh garrbarr hae',
);

$messages['hil'] = array(
	'december' => 'Disyimbre',
	'december-gen' => 'Disyimbre',
	'dec' => 'Dis',
	'delete' => 'Panason',
	'deletethispage' => 'Panason ang ini nga panid',
	'disclaimers' => 'Diskleymer',
	'disclaimerpage' => 'Project:Kabilogan nga diskleymer',
	'databaseerror' => 'May sala sa database',
	'dberrortext' => 'May sala sa syntax sang pagpangita sa database.
Ini nagakahulogan nga basi may sapat-sapat sa software.
Ang pinaka-ulihe nga pamilit sa pagpangita sa database amo ang:
<blockquote><tt>$1</tt></blockquote>
nga halin sa buluhaton nga "<tt>$2</tt>".
Ang database nagbalik sang sala/eror nga "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'May sala sa syntax sang pagpangita sa database.
Ang pinaka-ulihe nga pamilit sa pagpangita sa database amo ang:
"$1"
nga halin sa buluhaton nga "$2".
Ang database nagbalik sang sala/eror nga "$3: $4"',
	'directorycreateerror' => 'Indi mahimo nga mabuhat ang direktoryo nga "$1".',
	'deletedhist' => 'Ginpanas nga kasaysayan',
	'difference' => '(Naglain sa tunga sang mga rebisyon)',
	'difference-multipage' => '(Kinala-in sang mga panid)',
	'diff-multi' => '({{PLURAL:$1|Isa ka tunga-tunga nga pagbag-o|$1 ka tunga-tunga nga mga pagbag-o}} sang {{PLURAL:$2|isa ka manuggamit|$2 ka mga manuggamit}} nga wala ginpakita)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Isa ka tunga-tunga nga pagbag-o|$1 ka tunga-tunga nga mga pagbag-o}} sang masobra $2 ka {{PLURAL:$2|manuggamit|mga manuggamit}} nga wala ginpakita)',
	'datedefault' => 'Wala sang pagpalabi',
	'defaultns' => 'Kon indi magpangita na lang sa sini nga mga ngalan-espasyo',
	'default' => 'default',
	'diff' => 'diff',
	'deletepage' => 'Panason ang pahina',
	'delete-legend' => 'Panason',
	'deletedtext' => '"$1" ay nakakas na.
Lantawa $2 para sa mga lista sang mga bag-o lang ginkakas.',
	'dellogpage' => 'Ginkakas na log',
	'deletecomment' => 'Rason:',
	'deleteotherreason' => 'Iban/dugang nga rason:',
	'deletereasonotherlist' => 'Iban nga rason',
);

$messages['hr'] = array(
	'december' => 'prosinca',
	'december-gen' => 'prosinca',
	'dec' => 'pro',
	'delete' => 'Izbriši',
	'deletethispage' => 'Izbriši ovu stranicu',
	'disclaimers' => 'Odricanje od odgovornosti',
	'disclaimerpage' => 'Project:General_disclaimer',
	'databaseerror' => 'Pogreška baze podataka',
	'dberrortext' => 'Došlo je do sintaksne pogreške u upitu bazi.
Možda se radi o grešci u softveru.
Posljednji pokušaj upita je glasio:
<blockquote><tt>$1</tt></blockquote>
iz funkcije "<tt>$2</tt>".
Baza je vratila pogrešku "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Došlo je do sintaksne pogreške s upitom bazi.
Posljednji pokušaj upita je glasio:
"$1"
iz funkcije "$2".
Baza je vratila pogrešku "$3: $4"',
	'directorycreateerror' => 'Nije moguće kreirati direktorij "$1".',
	'deletedhist' => 'Obrisana povijest',
	'difference' => '(Usporedba među inačicama)',
	'difference-multipage' => '(Razlika između stranica)',
	'diff-multi' => '({{PLURAL:$1|Nije prikazana jedna međuinačica|Nisu prikazane $1 međuinačice|Nije prikazano $1 međuinačica}} {{PLURAL:$2|jednog|$2|$2}} suradnika)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Nije prikazana jedna međuinačica|Nisu prikazane $1 međuinačice|Nije prikazano $1 međuinačica}} više od {{PLURAL:$2|jednog|$2|$2}} suradnika)',
	'datedefault' => 'Nemoj postaviti',
	'defaultns' => 'Ako nije navedeno drugačije, traži u ovim prostorima:',
	'default' => 'prvotno',
	'diff' => 'razl',
	'destfilename' => 'Ime datoteke na wikiju:',
	'duplicatesoffile' => '{{PLURAL:$1|Sljedeća datoteka je kopija|$1 sljedeće datoteke su kopije|$1 sljedećih datoteka su kopije}} ove datoteke ([[Special:FileDuplicateSearch/$2|više detalja]]):',
	'download' => 'skidanje',
	'disambiguations' => 'Stranice koje vode na razdvojbene stranice',
	'disambiguationspage' => 'Template:Razdvojba',
	'disambiguations-text' => "Sljedeće stranice povezuju na '''razdvojbenu stranicu'''.
Umjesto toga bi trebale povezivati na prikladnu temu.<br />
Stranica se tretira kao razdvojbena stranica ako koristi predložak na kojega vodi [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dvostruka preusmjeravanja',
	'doubleredirectstext' => 'Ova stranica sadrži popis stranica koje preusmjeravju na druge stranice za preusmjeravanje.
Svaki redak sadrži poveznice na prvo i drugo preusmjeravanje, kao i odredište drugog preusmjeravanja
koja obično ukazuje na "pravu" odredišnu stranicu, na koju bi trebalo pokazivati prvo preusmjeravanje.
<del>Precrtane</del> stavke su riješene.',
	'double-redirect-fixed-move' => '[[$1]] je premješten, sada je preusmjeravanje na [[$2]]',
	'double-redirect-fixed-maintenance' => 'Ispravljanje dvostrukih preusmjeravanja s [[$1]] na [[$2]].',
	'double-redirect-fixer' => 'Popravljač preusmjeravanja',
	'deadendpages' => 'Slijepe ulice',
	'deadendpagestext' => 'Slijedeće stranice nemaju poveznice na druge stranice na ovom wikiju ({{SITENAME}}).',
	'deletedcontributions' => 'Obrisani suradnički doprinosi',
	'deletedcontributions-title' => 'Obrisani suradnički doprinosi',
	'defemailsubject' => '{{SITENAME}} e-mail od suradnika "$1"',
	'deletepage' => 'Izbriši stranicu',
	'delete-confirm' => 'Obriši "$1"',
	'delete-legend' => 'Izbriši',
	'deletedtext' => '"$1" je izbrisana.
Vidi $2 za evidenciju nedavnih brisanja.',
	'dellogpage' => 'Evidencija_brisanja',
	'dellogpagetext' => 'Dolje je popis nedavnih brisanja.
Sva vremena su prema poslužiteljevom vremenu.',
	'deletionlog' => 'evidencija brisanja',
	'deletecomment' => 'Razlog:',
	'deleteotherreason' => 'Drugi/dodatni razlog:',
	'deletereasonotherlist' => 'Drugi razlog',
	'deletereason-dropdown' => '*Razlozi brisanja stranica
** Zahtjev autora
** Kršenje autorskih prava
** Vandalizam',
	'delete-edit-reasonlist' => 'Uredi razloge brisanja',
	'delete-toobig' => 'Ova stranica ima veliku povijest uređivanja, preko $1 {{PLURAL:$1|promjene|promjena}}. Brisanje takvih stranica je ograničeno da se onemoguće slučajni problemi u radu {{SITENAME}}.',
	'delete-warning-toobig' => 'Ova stranica ima veliku povijest uređivanja, preko $1 {{PLURAL:$1|promjene|promjena}}. Brisanje može poremetiti bazu podataka {{SITENAME}}; postupajte s oprezom.',
	'databasenotlocked' => 'Baza podataka nije zaključana.',
	'delete_and_move' => 'Izbriši i premjesti',
	'delete_and_move_text' => '==Nužno brisanje==

Odredišni članak "[[:$1]]" već postoji. Želite li ga obrisati da biste napravili mjesto za premještaj?',
	'delete_and_move_confirm' => 'Da, izbriši stranicu',
	'delete_and_move_reason' => 'Obrisano kako bi se napravilo mjesta za premještaj, stari naziv "[[$1]]"',
	'djvu_page_error' => "DjVu stranica nije dohvatljiva (''out of range'')",
	'djvu_no_xml' => 'Ne mogu dohvatiti XML za DjVu datoteku',
	'deletedrevision' => 'Izbrisana stara inačica $1',
	'days' => '{{PLURAL:$1|$1 dan|$1 dana|$1 dana}}',
	'deletedwhileediting' => "'''Upozorenje''': Ova stranica je obrisana nakon što ste počeli uređivati!",
	'descending_abbrev' => 'pad',
	'duplicate-defaultsort' => '\'\'\'Upozorenje:\'\'\' Razvrstavanje po "$2" poništava ranije razvrstavanje po "$1".',
	'dberr-header' => 'Ovaj wiki ima problem',
	'dberr-problems' => 'Ispričavamo se! Ova stranica ima tehničkih poteškoća.',
	'dberr-again' => 'Pričekajte nekoliko minuta i ponovno učitajte.',
	'dberr-info' => '(Ne mogu se spojiti na poslužitelj baze: $1)',
	'dberr-usegoogle' => 'U međuvremenu pokušajte tražiti putem Googlea.',
	'dberr-outofdate' => 'Imajte na umu da su njihova kazala našeg sadržaja možda zastarjela.',
	'dberr-cachederror' => 'Sljedeće je dohvaćena kopija tražene stranice, te možda nije ažurirana.',
	'discuss' => 'Raspravljaj',
);

$messages['hsb'] = array(
	'december' => 'december',
	'december-gen' => 'decembra',
	'dec' => 'dec',
	'delete' => 'wušmórnyć',
	'deletethispage' => 'Stronu wušmórnyć',
	'disclaimers' => 'Licencne postajenja',
	'disclaimerpage' => 'Project:Impresum',
	'databaseerror' => 'Zmylk w datowej bance',
	'dberrortext' => 'Syntaktiski zmylk při wotprašowanju datoweje banki.
To móhło zmylk w programje być. Poslednje spytane wotprašenje w datowej bance běše:
<blockquote><tt>$1</tt></blockquote>
z funkcije "<tt>$2</tt>".
Datowa banka wróći zmylk "tt>$3: $4</tt>".',
	'dberrortextcl' => 'Syntaktiski zmylk je we wotprašowanju datoweje banki wustupił.
Poslednje wotprašenje w datowej bance běše:
"$1"
z funkcije "$2".
Datowa banka wróći zmylk "$3: $4"',
	'directorycreateerror' => 'Zapis „$1“ njeda so wutworić.',
	'deletedhist' => 'Wušmórnjene stawizny',
	'difference' => '(rozdźěl mjez wersijomaj)',
	'difference-multipage' => '(Rozdźěl mjez stronami)',
	'diff-multi' => '({{PLURAL:$1|Jedna mjezywersija|$1 mjezywersiji|$1 mjezywersije|$1 mjezywersijow}} wot {{PLURAL:$2|jednoho wužiwarja|$2 wužiwarjow|$2 wužiwarjow|$2 wužiwarjow}} {{PLURAL:$1|njepokazana|njepokazanej|njepokazane|njepokazane}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Jedna mjezywersija|$1 mjezywersiji|$1 mjezywersije|$1 mjezywersijow}} wot wjace hač {{PLURAL:$2|jednoho wužiwarja|$2 wužiwarjow|$2 wužiwarjow|$2 wužiwarjow}} {{PLURAL:$1|njepokazana|njepokazanej|njepokazane|njepokazane}})',
	'datedefault' => 'Žane nastajenje',
	'defaultns' => 'Hewak w tutych mjenowych rumach pytać:',
	'default' => 'standard',
	'diff' => 'rozdźěl',
	'destfilename' => 'Mjeno ciloweje dataje:',
	'duplicatesoffile' => '{{PLURAL:$1|Slědowaca dataja je duplikat|Slědowacej $1 dataji stej duplikata|Slědowace $1 dataje su duplikaty|Slědowacych $1 duplikatow je duplikaty}} tuteje dataje ([[Special:FileDuplicateSearch/$2|dalše podrobnosće]])::',
	'download' => 'Sćahnyć',
	'disambiguations' => 'Strony, kotrež na strony wjacezmyslnosće wotkazuja',
	'disambiguationspage' => 'Template:Wjacezmyslnosć',
	'disambiguations-text' => "Slědowace strony na '''rozjasnjenje wjacezmyslnosće''' wotkazuja. Měli město toho na poprawnu stronu wotkazać.<br />Strona so jako rozjasnjenje wjacezmyslnosće zarjaduje, jeli předłohu wužiwa, na kotruž so wot [[MediaWiki:Disambiguationspage]] wotkazuje.",
	'doubleredirects' => 'Dwójne daleposrědkowanja',
	'doubleredirectstext' => 'Tuta strona nalistuje strony, kotrež k druhim daleposrědkowanskim stronam dale posrědkuja.
Kóžda rjadka wobsahuje wotkazy k prěnjemu a druhemu daleposrědkowanju kaž tež cil druheho daleposrědkowanja, kotryž je zwjetša  "woprawdźita" cilowa strona, na kotruž prěnje daleposrědkowanje měło pokazać. <del>Přešmórnjene</del> zapiski su hižo sčinjene.',
	'double-redirect-fixed-move' => '[[$1]] bu přesunjeny, je nětko daleposrědkowanje do [[$2]]',
	'double-redirect-fixed-maintenance' => 'Dwójne dalesposrědkowanje wot [[$1]] do [[$2]] so porjedźuje',
	'double-redirect-fixer' => 'Porjedźer daleposrědkowanjow',
	'deadendpages' => 'Nastawki bjez wotkazow',
	'deadendpagestext' => 'Slědowace strony njejsu z druhimi stronami w tutym wikiju zwjazane.',
	'deletedcontributions' => 'wušmórnjene přinoški',
	'deletedcontributions-title' => 'wušmórnjene přinoški',
	'defemailsubject' => '{{SITENAME}} - e-mejlka wot wužiwarja "$1"',
	'deletepage' => 'Stronu zhašeć',
	'delete-confirm' => '„$1“ wušmórnyć',
	'delete-legend' => 'Wušmórnyć',
	'deletedtext' => 'Strona „$1” bu wušmórnjena. Hlej $2 za lisćinu aktualnych wušmórnjenjow.',
	'dellogpage' => 'Protokol wušmórnjenjow',
	'dellogpagetext' => 'Deleka je lisćina najaktualnišich wušmórnjenjow.',
	'deletionlog' => 'Protokol wušmórnjenjow',
	'deletecomment' => 'Přičina:',
	'deleteotherreason' => 'Druha/přidatna přičina:',
	'deletereasonotherlist' => 'Druha přičina',
	'deletereason-dropdown' => '*Zwučene přičiny za wušmórnjenje
** Požadanje awtora
** Zranjenje copyrighta
** Wandalizm',
	'delete-edit-reasonlist' => 'Přičiny za wušmórnjenje wobdźěłać',
	'delete-toobig' => 'Tuta strona ma z wjace hač $1 {{PLURAL:$1|wersiju|wersijomaj|wersijemi|wersijemi}} wulke wobdźěłanske stawizny. Wušmórnjenje tajkich stronow bu wobmjezowane, zo by připadne přetorhnjenje {{SITENAME}} wobešło.',
	'delete-warning-toobig' => 'Tuta strona ma z wjace hač $1 {{PLURAL:$1|wersiju|wersijomaj|wersijemi|wersijemi}} wulke wobdźěłanske stawizny. Wušmórnjenje móže operacije datoweje banki {{SITENAME}} přetorhnyć; pokročuj z kedźbliwosću.',
	'databasenotlocked' => 'Datajowa banka zamknjena njeje.',
	'delete_and_move' => 'wušmórnyć a přesunyć',
	'delete_and_move_text' => '== Wušmórnjenje trěbne ==

Cilowa strona „[[:$1]]” hižo eksistuje. Chceš ju wušmórnyć, zo by so přesunjenje zmóžniło?',
	'delete_and_move_confirm' => 'Haj, stronu wušmórnyć.',
	'delete_and_move_reason' => 'Wušmórnjena, zo by so rum za přesunjenje z "[[$1]]" wutworił.',
	'djvu_page_error' => 'Strona DjVU zwonka wobłuka strony',
	'djvu_no_xml' => 'Daty XML njemóža so za dataju DjVU wotwołać',
	'deletedrevision' => 'Stara wersija $1 wušmórnjena',
	'days' => '{{PLURAL:$1|$1 dnjom|$1 dnjomaj|$1 dnjemi|$1 dnjemi}}',
	'deletedwhileediting' => "'''Kedźbu''': Tuta strona bu wušmórnjena, po tym zo sy započał ju wobdźěłać!",
	'descending_abbrev' => 'zestupowacy',
	'duplicate-defaultsort' => 'Warnowanje: Standardny sortěrowonski kluč (DEFAULTSORTKEY) "$2" přepisa prjedawšu sortěrowanski kluč "$1".',
	'dberr-header' => 'Tutón wiki ma problem',
	'dberr-problems' => 'Wodaj! Tute sydło ma techniske ćežkosće.',
	'dberr-again' => 'Počakń někotre mjeńšiny a zaktualizuj stronu.',
	'dberr-info' => '(Njeje móžno ze serwerom datoweje banki zwjazać: $1)',
	'dberr-usegoogle' => 'Mjeztym móžeš z pomocu Google pytać.',
	'dberr-outofdate' => 'Wobkedźbuj, zo jich indeksy našeho wobsaha móhli zestarjene być.',
	'dberr-cachederror' => 'Slědowaca je pufrowana kopija požadaneje strony a móhła zestarjena być.',
);

$messages['ht'] = array(
	'december' => 'desanm',
	'december-gen' => 'desanm',
	'dec' => 'des',
	'delete' => 'Efase',
	'deletethispage' => 'Efase paj sa',
	'disclaimers' => 'Avètisman',
	'disclaimerpage' => 'Project:Avètisman jeneral yo',
	'databaseerror' => 'Erè nan bazdone.',
	'dberrortext' => 'Yon rekèt nan bazdone a bay yon erè.
Sa kapab vle di genyen yon erè nan lojisyèl nan.
Dènye esè a te :
<blockquote><tt>$1</tt></blockquote>
depi fonksyon sa « <tt>$2</tt> ».
Bazdone ritounen erè sa « <tt>$3 : $4</tt> ».',
	'dberrortextcl' => 'Yon rekèt nan bazdone a bay yon erè.
Dènye esè nan baz done a te:
« $1 »
depi fonksyon sa « $2 ».
Bazdone a te bay mesaj erè sa « $3 : $4 ».',
	'directorycreateerror' => 'Nou pa kapab kreye dosye « $1 ».',
	'deletedhist' => 'Istorik efase',
	'difference' => '(Diferans ant vèsyon yo)',
	'diff-multi' => '(Genyen {{PLURAL:$1|yon revizyon|$1 revizyon yo}} ki te fèt pa {{PLURAL:$2|yon itilizatè|$2 itilizatè yo}} nan mitan evolisyon ki kache)',
	'diff' => 'diferans',
	'disambiguations' => 'Paj yo ki genyen menm non',
	'doubleredirects' => 'Redireksyon de fwa',
	'deadendpages' => 'Paj yo ki pa gen lyen nan yo',
	'deletepage' => 'Efase yon paj',
	'deletedtext' => '« $1 » efase.
Gade $2 pou wè yon lis efasman resan.',
	'dellogpage' => 'Jounal efasman yo',
	'deletecomment' => 'Rezon:',
	'deleteotherreason' => 'Rezon an plis :',
	'deletereasonotherlist' => 'Lòt rezon',
);

$messages['hu'] = array(
	'december' => 'december',
	'december-gen' => 'december',
	'dec' => 'dec',
	'delete' => 'Törlés',
	'deletethispage' => 'Lap törlése',
	'disclaimers' => 'Jogi nyilatkozat',
	'disclaimerpage' => 'Project:Jogi nyilatkozat',
	'databaseerror' => 'Adatbázishiba',
	'dberrortext' => 'Szintaktikai hiba található az adatbázis-lekérdezésben.
Ezt szoftverhiba okozhatta.
Az utolsó adatbázis-lekérdezés a(z) „<tt>$2</tt>” függvényből történt, és a következő volt:
<blockquote><tt>$1</tt></blockquote>
Az adatbázis ezzel a hibával tért vissza: „<tt>$3: $4</tt>”.',
	'dberrortextcl' => 'Szintaktikai hiba található az adatbázis-lekérdezésben.
Az utolsó adatbázis-lekérdezés a(z) „$2” függvényből történt, és a következő volt:
„$1”
Az adatbázis ezzel a hibával tért vissza: „$3: $4”.',
	'directorycreateerror' => 'Nem tudtam létrehozni a(z) „$1” könyvtárat.',
	'deletedhist' => 'Törölt változatok',
	'difference' => '(Változatok közti eltérés)',
	'difference-multipage' => '(Lapok közti eltérés)',
	'diff-multi' => '({{PLURAL:$2|egy|$2}} szerkesztő {{PLURAL:$1|egy|$1}} közbeeső változata nincs mutatva)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Egy közbeeső változat|$1 közbeeső változat}} nincs mutatva, amit $2 szerkesztő módosított)',
	'datedefault' => 'Nincs beállítás',
	'defaultns' => 'Egyébként a következő névterekben keressen:',
	'default' => 'alapértelmezett',
	'diff' => 'eltér',
	'destfilename' => 'Célfájlnév:',
	'duplicatesoffile' => 'A következő {{PLURAL:$1|fájl|$1 fájl}} ennek a fájlnak a duplikátuma ([[Special:FileDuplicateSearch/$2|további részletek]]):',
	'download' => 'letöltés',
	'disambiguations' => 'Egyértelműsítő lapokra mutató lapok',
	'disambiguationspage' => 'Template:Egyért',
	'disambiguations-text' => "A következő oldalak '''egyértelműsítő lapra''' mutató hivatkozást tartalmaznak.
A megfelelő szócikkre kellene mutatniuk inkább.<br />
Egy oldal egyértelműsítő lapnak számít, ha tartalmazza a [[MediaWiki:Disambiguationspage]] oldalról belinkelt sablonok valamelyikét.",
	'doubleredirects' => 'Dupla átirányítások',
	'doubleredirectstext' => 'Ez a lap azokat a lapokat listázza, melyek átirányító lapokra irányítanak át.
Minden sor tartalmaz egy hivatkozást az első, valamint a második átirányításra, valamint a második átirányítás céljára, ami általában a valódi céllap, erre kellene az első átirányításnak mutatnia.
Az <del>áthúzott</del> sorok a lista elkészülése óta javítva lettek.',
	'double-redirect-fixed-move' => '[[$1]] átnevezve, a továbbiakban átirányításként működik a(z) [[$2]] lapra',
	'double-redirect-fixed-maintenance' => '[[$1]] dupla átirányítás javítása a következőre: [[$2]]',
	'double-redirect-fixer' => 'Átirányításjavító',
	'deadendpages' => 'Zsákutcalapok',
	'deadendpagestext' => 'Az itt található lapok nem kapcsolódnak hivatkozásokkal ezen wiki más oldalaihoz.',
	'deletedcontributions' => 'Törölt szerkesztések',
	'deletedcontributions-title' => 'Törölt szerkesztések',
	'defemailsubject' => '{{SITENAME}} e-mail a következő felhasználótól: „$1”',
	'deletepage' => 'Lap törlése',
	'delete-confirm' => '$1 törlése',
	'delete-legend' => 'Törlés',
	'deletedtext' => 'A(z) „$1” lapot törölted.
A legutóbbi törlések listájához lásd a $2 lapot.',
	'dellogpage' => 'Törlési_napló',
	'dellogpagetext' => 'Itt láthatók a legutóbb törölt lapok.',
	'deletionlog' => 'törlési napló',
	'deletecomment' => 'Ok:',
	'deleteotherreason' => 'További indoklás:',
	'deletereasonotherlist' => 'Egyéb indok',
	'deletereason-dropdown' => '*Gyakori törlési okok
** Szerző kérésére
** Jogsértő
** Vandalizmus',
	'delete-edit-reasonlist' => 'Törlési okok szerkesztése',
	'delete-toobig' => 'Ennek a lapnak a laptörténete több mint {{PLURAL:$1|egy|$1}} változatot őriz. A szervert kímélendő az ilyen lapok törlése nem engedélyezett.',
	'delete-warning-toobig' => 'Ennek a lapnak a laptörténete több mint {{PLURAL:$1|egy|$1}} változatot őriz. Törlése fennakadásokat okozhat a wiki adatbázis-műveleteiben; óvatosan járj el.',
	'databasenotlocked' => 'Az adatbázis nincs lezárva.',
	'delete_and_move' => 'Törlés és átnevezés',
	'delete_and_move_text' => '== Törlés szükséges ==

Az átnevezés céljaként megadott „[[:$1]]” szócikk már létezik.  Ha az átnevezést végre akarod hajtani, ezt a lapot törölni kell.  Valóban ezt szeretnéd?',
	'delete_and_move_confirm' => 'Igen, töröld a lapot',
	'delete_and_move_reason' => 'Törölve, hogy legyen hely átmozgatni [[$1]] lapot.',
	'djvu_page_error' => 'A DjVu lap a tartományon kívülre esik',
	'djvu_no_xml' => 'Nem olvasható ki a DjVu fájl XML-je',
	'deletedrevision' => 'Régebbi változat törölve: $1',
	'days' => '{{PLURAL:$1|egy|$1}} nappal',
	'deletedwhileediting' => "'''Figyelmeztetés:''' A lapot a szerkesztés megkezdése után törölték!",
	'descending_abbrev' => 'csökk',
	'duplicate-defaultsort' => 'Figyelem: a(z) „$2” rendezőkulcs felülírja a korábbit („$1”).',
	'dberr-header' => 'A wikivel problémák vannak',
	'dberr-problems' => 'Sajnáljuk, de az oldallal technikai problémák vannak.',
	'dberr-again' => 'Várj néhány percet, majd frissítsd az oldalt.',
	'dberr-info' => '(Nem sikerült kapcsolatot létesíteni az adatbázisszerverrel: $1)',
	'dberr-usegoogle' => 'A probléma elmúlásáig próbálhatsz keresni a Google-lel.',
	'dberr-outofdate' => 'Fontos tudnivaló, hogy az oldal tartalmáról készített indexeik elavultak lehetnek.',
	'dberr-cachederror' => 'Lenn a kért oldal gyorsítótárazott változata látható, és lehet, hogy nem teljesen friss.',
);

$messages['hy'] = array(
	'december' => 'Դեկտեմբեր',
	'december-gen' => 'Դեկտեմբերի',
	'dec' => 'դեկ',
	'delete' => 'Ջնջել',
	'deletethispage' => 'Ջնջել այս էջը',
	'disclaimers' => 'Ազատում պատասխանատվությունից',
	'disclaimerpage' => 'Project:Ազատում պատասխանատվությունից',
	'databaseerror' => 'Տվյալների բազայի սխալ',
	'dberrortext' => 'Հայտնաբերվել է տվյալների բազային հայցի շարահյուսության սխալ։
Սա կարող է լինել ծրագրային ապահովման սխալից։
Տվյալների բազային վերջին հայցն էր․
<blockquote><tt>$1</tt></blockquote>
հետևյալ ֆունկցիայի մարմնից <tt>«$2»</tt>։
Տվյլաների բազայի վերադարձրած սխալն է․ <tt>«$3: $4»</tt>։',
	'dberrortextcl' => 'Հայտնաբերվել է տվյալների բազային հայցի շարահյուսության սխալ։
Տվյալների բազային վերջին հայցն էր.
«$1»
հետևյալ ֆունկցիայի մարմնից <tt>«$2»</tt>։
Տվյալների բազայի վերադարձրած սխալն է. <tt>«$3: $4»</tt>։',
	'directorycreateerror' => 'Չհաջողվեց ստեղծել «$1» պանակը։',
	'deletedhist' => 'Ջնջումների պատմություն',
	'difference' => '(Խմբագրումների միջև եղած տարբերությունները)',
	'diff-multi' => '({{PLURAL:$1|$1 միջանկյալ տարբերակ|$1 միջանկյալ տարբերակ}} ցուցադրված չէ։)',
	'datedefault' => 'Առանց նախընտրության',
	'defaultns' => 'Հակառակ դեպքում, որոնել այս անվանատարծքներում․',
	'default' => 'լռությամբ',
	'diff' => 'տարբ',
	'destfilename' => 'Նիշքի նոր անվանում՝',
	'download' => 'Ներբեռնել',
	'disambiguations' => 'Երկիմաստության փարատման էջեր',
	'disambiguationspage' => 'Template:Երկիմաստ',
	'disambiguations-text' => 'Հետևյալ էջերը հղում են երկիմաստության փարատման էջերին։
Փոխարենը նրանք, հավանաբար, պետք է հղեն համապատասխան թեմային։<br />
Էջը համարվում է երկիմաստության փարատման էջ, եթե այն պարունակում է [[MediaWiki:Disambiguationspage]] էջում ընդգրկված կաղապարներից որևէ մեկը։',
	'doubleredirects' => 'Կրկնակի վերահղումներ',
	'doubleredirectstext' => 'Այս էջում բերված են վերահղման էջերին վերահղող էջերը։ Յուրաքանչյուր տող պարունակում է հղումներ դեպի առաջին և երկրորդ վերահղումները, ինչպես նաև երկրորդ վերահղման նպատակային էջի առաջին տողը, որում սովորաբար նշված է էջի անվանումը, որին պետք է հղի նաև առաջին վերահղումը։',
	'double-redirect-fixed-move' => '«[[$1]]» էջը վերանվանված է և այժմ վերահղում է «[[$2]]» էջին։',
	'double-redirect-fixer' => 'Վերահղումների շտկիչ',
	'deadendpages' => 'Հղումներ չպարունակող էջեր',
	'deadendpagestext' => 'Հետևյալ էջերը չունեն հղումներ վիքիի այլ էջերին։',
	'deletedcontributions' => 'Մասնակցի ջնջված ներդրում',
	'deletedcontributions-title' => 'Մասնակցի ջնջված ներդրում',
	'defemailsubject' => '{{SITENAME}} e-mail',
	'deletepage' => 'Ջնջել էջը',
	'delete-confirm' => '$1 ― ջնջում',
	'delete-legend' => 'Ջնջում',
	'deletedtext' => '«$1» էջը ջնջված է։
Տես $2՝ վերջին ջնջումների պատմության համար։',
	'dellogpage' => 'Ջնջման տեղեկամատյան',
	'dellogpagetext' => 'Ստորև բերված է ամենավերջին ջնջումների ցանկը։',
	'deletionlog' => 'ջնջման տեղեկամատյան',
	'deletecomment' => 'Պատճառ.',
	'deleteotherreason' => 'Լրացուցիչ պատճառ',
	'deletereasonotherlist' => 'Ուրիշ պատճառ',
	'databasenotlocked' => 'Տվյալների բազան կողպված չէ։',
	'delete_and_move' => 'Ջնջել և տեղափոխել',
	'delete_and_move_text' => '==Պահանջվում է ջնջում==

«[[:$1]]» անվանմամբ էջ արդեն գոյություն ունի։ Ուզո՞ւմ եք այն ջնջել՝ տեղափոխումը իրականացնելու համար։',
	'delete_and_move_confirm' => 'Այո, ջնջել էջը',
	'delete_and_move_reason' => 'Ջնջված է՝ տեղափոխման տեղ ազատելու համար',
	'djvu_page_error' => 'DjVu էջը լայնույթից դուրս է',
	'djvu_no_xml' => 'Չհաջողվեց ստեղծել XML DjVu նիշքի համար',
	'deletedrevision' => 'Ջնջված է հին տարբերակը $1',
	'deletedwhileediting' => 'Զգուշացում. ձեր խմբագրման ընթացքում այս էջը ջնջվել է։',
	'descending_abbrev' => 'նվազ',
	'dberr-header' => 'Այս վիքիում խնդիրներ են առաջացել',
	'dberr-problems' => 'Այս կայքում առաջացել են տեխնիկական խնդիրներ։ Հայցում ենք ձեր ներողությունը։',
	'dberr-again' => 'Փորձեք մի քանի րոպե սպասել և վերաբեռնել էջը։',
);

$messages['ia'] = array(
	'december' => 'decembre',
	'december-gen' => 'decembre',
	'dec' => 'dec',
	'delete' => 'Deler',
	'deletethispage' => 'Deler iste pagina',
	'disclaimers' => 'Declaration de non-responsabilitate',
	'disclaimerpage' => 'Project:Declaration general de non-responsabilitate',
	'databaseerror' => 'Error del base de datos',
	'dberrortext' => 'Un error de syntaxe occurreva durante un consulta del base de datos.
Isto pote indicar le presentia de un defecto in le software.
Le ultime consulta que esseva tentate es:
<blockquote><tt>$1</tt></blockquote>
effectuate per le function "<tt>$2</tt>".
Le base de datos retornava le error "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Un error de syntaxe occurreva durante un consulta del base de datos.
Le ultime consulta que esseva tentate es:
"$1"
effectuate per le function "$2".
Le base de datos retornava le error "$3: $4"',
	'directorycreateerror' => 'Impossibile crear le directorio "$1".',
	'deletedhist' => 'Historia delite',
	'difference' => '(Differentia inter versiones)',
	'difference-multipage' => '(Differentia inter paginas)',
	'diff-multi' => '({{PLURAL:$1|Un version intermedie|$1 versiones intermedie}} facite per {{PLURAL:$2|un usator|$2 usatores}} non es monstrate)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Un version intermedie|$1 versiones intermedie}} facite per plus de $2 {{PLURAL:$2|usator|usatores}} non es monstrate)',
	'datedefault' => 'Nulle preferentia',
	'defaultns' => 'Alteremente cercar in iste spatios de nomines:',
	'default' => 'predefinite',
	'diff' => 'diff',
	'destfilename' => 'Nomine del file de destination:',
	'duplicatesoffile' => 'Le sequente {{PLURAL:$1|file es un duplicato|$1 files es duplicatos}} de iste file ([[Special:FileDuplicateSearch/$2|plus detalios]]):',
	'download' => 'discargar',
	'disambiguations' => 'Paginas con ligamines a paginas de disambiguation',
	'disambiguationspage' => 'Template:Disambiguation',
	'disambiguations-text' => "Le sequente paginas ha ligamines a un '''pagina de disambiguation'''.
Istes deberea esser reimplaciate con ligamines al topicos appropriate.<br />
Un pagina se tracta como pagina de disambiguation si illo usa un patrono al qual [[MediaWiki:Disambiguationspage]] ha un ligamine.",
	'doubleredirects' => 'Redirectiones duple',
	'doubleredirectstext' => 'Iste pagina lista paginas de redirection verso altere paginas de redirection.
Cata linea contine ligamines al prime e al secunde redirection, con le destination del secunde redirection. Iste es normalmente le "ver" pagina de destination, al qual le prime redirection tamben deberea punctar.
Le entratas <del>cancellate</del> ha essite resolvite.',
	'double-redirect-fixed-move' => '[[$1]] ha essite renominate, illo es ora un redirection verso [[$2]]',
	'double-redirect-fixed-maintenance' => 'Corrige redirection duple de [[$1]] a [[$2]].',
	'double-redirect-fixer' => 'Corrector de redirectiones',
	'deadendpages' => 'Paginas sin exito',
	'deadendpagestext' => 'Le sequente paginas non ha ligamines a altere paginas in {{SITENAME}}.',
	'deletedcontributions' => 'Contributiones delite de usatores',
	'deletedcontributions-title' => 'Contributiones delite de usatores',
	'defemailsubject' => 'E-mail del usator "$1" de {{SITENAME}}',
	'deletepage' => 'Deler pagina',
	'delete-confirm' => 'Deler "$1"',
	'delete-legend' => 'Deler',
	'deletedtext' => '"$1" ha essite delite.
Vide $2 pro un registro de deletiones recente.',
	'dellogpage' => 'Registro de deletiones',
	'dellogpagetext' => 'Infra es un lista del plus recente deletiones.
Tote le horas es in le fuso horari del servitor.',
	'deletionlog' => 'registro de deletiones',
	'deletecomment' => 'Motivo:',
	'deleteotherreason' => 'Motivo altere/additional:',
	'deletereasonotherlist' => 'Altere motivo',
	'deletereason-dropdown' => '*Motivos habitual pro deler paginas
** Requesta del autor
** Violation de copyright
** Vandalismo',
	'delete-edit-reasonlist' => 'Modificar le motivos pro deletion',
	'delete-toobig' => 'Iste pagina ha un grande historia de modificationes con plus de $1 {{PLURAL:$1|version|versiones}}.
Le deletion de tal paginas ha essite restringite pro impedir le disruption accidental de {{SITENAME}}.',
	'delete-warning-toobig' => 'Iste pagina ha un grande historia de modificationes con plus de $1 {{PLURAL:$1|version|versiones}}.
Le deletion de illo pote disrumper le operationes del base de datos de {{SITENAME}};
procede con caution.',
	'databasenotlocked' => 'Le base de datos non es blocate.',
	'delete_and_move' => 'Deler e renominar',
	'delete_and_move_text' => '==Deletion requirite==
Le pagina de destination "[[:$1]]" existe ja.
Esque tu vole deler lo pro permitter le renomination?',
	'delete_and_move_confirm' => 'Si, deler le pagina',
	'delete_and_move_reason' => 'Delite pro permitter le renomination de "[[$1]]"',
	'djvu_page_error' => 'Pagina DjVu foras de limite',
	'djvu_no_xml' => 'Impossibile obtener XML pro file DjVu',
	'deletedrevision' => 'Deleva le ancian version $1',
	'days' => '{{PLURAL:$1|$1 die|$1 dies}}',
	'deletedwhileediting' => "'''Attention:''' Iste pagina esseva delite post que tu comenciava a modificar lo!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => 'Attention: Le clave de ordination predefinite "$2" supplanta le anterior clave de ordination predefinite "$1".',
	'dberr-header' => 'Iste wiki ha un problema',
	'dberr-problems' => 'Pardono! Iste sito ha incontrate difficultates technic.',
	'dberr-again' => 'Proba attender alcun minutas e recargar.',
	'dberr-info' => '(Non pote contactar le servitor del base de datos: $1)',
	'dberr-usegoogle' => 'Tu pote probar cercar con Google intertanto.',
	'dberr-outofdate' => 'Nota que lor indices de nostre contento pote esser obsolete.',
	'dberr-cachederror' => 'Lo sequente es un copia del cache del pagina requestate, e pote esser obsolete.',
);

$messages['id'] = array(
	'december' => 'Desember',
	'december-gen' => 'Desember',
	'dec' => 'Des',
	'delete' => 'Hapus',
	'deletethispage' => 'Hapus halaman ini',
	'disclaimers' => 'Penyangkalan',
	'disclaimerpage' => 'Project:Penyangkalan umum',
	'databaseerror' => 'Kesalahan basis data',
	'dberrortext' => 'Ada kesalahan sintaks pada permintaan basis data.
Kesalahan ini mungkin menandakan adanya sebuah \'\'bug\'\' dalam perangkat lunak.
Permintaan basis data yang terakhir adalah:
<blockquote><tt>$1</tt></blockquote>
dari dalam fungsi "<tt>$2</tt>".
Basis data menghasilkan kesalahan "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ada kesalahan sintaks pada permintaan basis data.
Permintaan basis data yang terakhir adalah:
"$1"
dari dalam fungsi "$2".
Basis data menghasilkan kesalahan "$3: $4".',
	'directorycreateerror' => 'Tidak dapat membuat direktori "$1".',
	'deletedhist' => 'Sejarah yang dihapus',
	'difference' => '(Perbedaan antarrevisi)',
	'difference-multipage' => '(Perbedaan antarhalaman)',
	'diff-multi' => '({{PLURAL:$1|Satu|$1}} revisi antara oleh {{PLURAL:$2|satu|$2}} pengguna tak ditampilkan)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Satu|$1}} revisi antara oleh lebih dari $2 {{PLURAL:$2|satu|$2}} pengguna tak ditampilkan)',
	'datedefault' => 'Tak ada preferensi',
	'defaultns' => 'Atau cari dalam ruang-ruang nama berikut:',
	'default' => 'baku',
	'diff' => 'beda',
	'destfilename' => 'Nama berkas tujuan:',
	'duplicatesoffile' => '{{PLURAL:$1|Ada satu berkas yang|Sebanyak $1 berkas berikut}} merupakan duplikat dari berkas ini ([[Special:FileDuplicateSearch/$2|rincian lebih lanjut]]):',
	'download' => 'unduh',
	'disambiguations' => 'Halaman yang terhubung ke halaman disambiguasi',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => "Halaman-halaman berikut memiliki pranala ke suatu '''halaman disambiguasi'''.
Halaman-halaman tersebut seharusnya berpaut ke topik-topik yang sesuai.<br />
Suatu halaman dianggap sebagai halaman disambiguasi apabila halaman tersebut menggunakan templat yang terhubung ke [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Pengalihan ganda',
	'doubleredirectstext' => 'Halaman ini memuat daftar halaman yang dialihkan ke halaman pengalihan yang lain.
Setiap baris memuat pranala ke pengalihan pertama dan pengalihan kedua serta target dari pengalihan kedua yang umumnya adalah halaman yang "sebenarnya". Halaman peralihan pertama seharusnya dialihkan ke halaman yang bukan merupakan halaman peralihan.
Nama yang telah <del>dicoret</del> berarti telah dibetulkan.',
	'double-redirect-fixed-move' => '[[$1]] telah dipindahkan menjadi halaman peralihan ke [[$2]]',
	'double-redirect-fixed-maintenance' => 'Memperbaiki pengalihan ganda dari [[$1]] ke [[$2]].',
	'double-redirect-fixer' => 'Revisi pengalihan',
	'deadendpages' => 'Halaman buntu',
	'deadendpagestext' => 'Halaman-halaman berikut tidak memiliki pranala ke halaman mana pun di wiki ini.',
	'deletedcontributions' => 'Kontribusi yang dihapus',
	'deletedcontributions-title' => 'Kontribusi yang dihapus',
	'defemailsubject' => 'Surel {{SITENAME}} dari pengguna "$1"',
	'deletepage' => 'Hapus halaman',
	'delete-confirm' => 'Hapus "$1"',
	'delete-legend' => 'Hapus',
	'deletedtext' => '"$1" telah dihapus. Lihat $2 untuk log terkini halaman yang telah dihapus.',
	'dellogpage' => 'Log penghapusan',
	'dellogpagetext' => 'Di bawah ini adalah log penghapusan halaman. Semua waktu yang ditunjukkan adalah waktu server.',
	'deletionlog' => 'log penghapusan',
	'deletecomment' => 'Alasan:',
	'deleteotherreason' => 'Alasan lain/tambahan:',
	'deletereasonotherlist' => 'Alasan lain',
	'deletereason-dropdown' => '*Alasan penghapusan
** Permintaan pengguna
** Pelanggaran hak cipta
** Vandalisme',
	'delete-edit-reasonlist' => 'Alasan penghapusan suntingan',
	'delete-toobig' => 'Halaman ini memiliki sejarah penyuntingan yang panjang, melebihi {{PLURAL:$1|revisi|revisi}}.
Penghapusan halaman dengan sejarah penyuntingan yang panjang tidak diperbolehkan untuk mencegah kerusakan di {{SITENAME}}.',
	'delete-warning-toobig' => 'Halaman ini memiliki sejarah penyuntingan yang panjang, melebihi {{PLURAL:$1|revisi|revisi}}.
Menghapus halaman ini dapat menyebabkan masalah dalam operasional basis data {{SITENAME}}.',
	'databasenotlocked' => 'Basis data tidak terkunci.',
	'delete_and_move' => 'Hapus dan pindahkan',
	'delete_and_move_text' => '==Penghapusan diperlukan==
Halaman yang dituju, "[[:$1]]", telah mempunyai isi. Apakah Anda hendak menghapusnya untuk memberikan ruang bagi pemindahan?',
	'delete_and_move_confirm' => 'Ya, hapus halaman tersebut',
	'delete_and_move_reason' => 'Dihapus untuk mengantisipasikan pemindahan halaman',
	'djvu_page_error' => 'Halaman DjVu di luar rentang',
	'djvu_no_xml' => 'XML untuk berkas DjVu tak dapat diperoleh',
	'deletedrevision' => 'Revisi lama yang dihapus $1',
	'deletedwhileediting' => "'''Peringatan''': Halaman ini telah dihapus setelah Anda mulai melakukan penyuntingan!",
	'descending_abbrev' => 'turun',
	'duplicate-defaultsort' => 'Peringatan: Kunci pengurutan baku "$2" mengabaikan kunci pengurutan baku "$1" sebelumnya.',
	'dberr-header' => 'Wiki ini bermasalah',
	'dberr-problems' => 'Maaf! Situs ini mengalami masalah teknis.',
	'dberr-again' => 'Cobalah menunggu beberapa menit dan muat ulang.',
	'dberr-info' => '(Tak dapat tersambung dengan server basis data: $1)',
	'dberr-usegoogle' => 'Anda dapat mencoba pencarian melalui Google untuk sementara waktu.',
	'dberr-outofdate' => 'Harap diperhatikan bahwa indeks mereka terhadap isi kami mungkin sudah kedaluwarsa.',
	'dberr-cachederror' => 'Berikut adalah salinan tersimpan halaman yang diminta, dan mungkin bukan yang terbaru.',
);

$messages['ie'] = array(
	'december' => 'decembre',
	'december-gen' => 'decembre',
	'dec' => 'dec',
	'delete' => 'Deleter',
	'deletethispage' => 'Deleter ti págine',
	'disclaimers' => 'Advertimentes',
	'disclaimerpage' => 'Project:Advertimentes comun',
	'difference' => '(Diferentie inter revisiones)',
	'diff-multi' => '({{PLURAL:$1|Un revision intermediari|$1 revisiones intermediari}} per {{PLURAL:$2|un usator|$2 usatores}} ne monstrat)',
	'diff' => 'dif',
	'disambiguationspage' => 'Template:disambig',
	'deadendpages' => 'Págines sin exeada',
	'deletepage' => 'Deleter págine',
	'delete-legend' => 'Deleter',
	'dellogpage' => 'Diarium de deletion',
	'deletecomment' => 'Motive:',
	'deleteotherreason' => 'Altri motive:',
	'deletereasonotherlist' => 'Altri motive',
	'duplicate-defaultsort' => '\'\'\'Advertiment:\'\'\' Clave de specie contumacie "$2" substitue temporanmen clave de specie contumacie "$1".',
);

$messages['ig'] = array(
	'december' => 'Önwa Iri na abụọ',
	'december-gen' => 'Önwa Iri na abụọ',
	'dec' => 'ÖIrinabụọ',
	'delete' => 'Kàcha',
	'deletethispage' => 'Kàcha ihü nkea',
	'disclaimers' => 'Ihe anyí chọrọ ki ma',
	'disclaimerpage' => 'Project:Ihe I kweshiri ma',
	'databaseerror' => 'Nsogbu nọr na njikota ómárí',
	'directorycreateerror' => "Enwerịkị ké usoro ''$1''.",
	'deletedhist' => 'Ákíkó mbu bakashịrị',
	'difference' => '(Ihe dị íche na orü ndi á)',
	'datedefault' => 'Otú é shị na dose ihe efù',
	'default' => 'nke éjị bịdó',
	'diff' => 'Íchè',
	'download' => 'danwèré',
	'disambiguationspage' => 'Template:ọlúchịgị',
	'double-redirect-fixed-move' => '[[$1]] a puziele.
Ubwa, o na ga [[$2]].',
	'defemailsubject' => 'e-mail {{SITENAME}}',
	'deletepage' => 'Kàchafu ihü',
	'delete-confirm' => 'Kàcha "$1"',
	'delete-legend' => 'Kàcha',
	'deletedtext' => '"$1" à gbákáshíálá.
Lé $2 màkà okwu gbásárá ihe ọ gbakashiri màkà.',
	'dellogpage' => 'Ntínyé ngbákashị',
	'deletecomment' => 'Màkà:',
	'deleteotherreason' => 'Màkà ihe ozor kwa:',
	'deletereasonotherlist' => 'Mgbághàpụtá ozor',
	'delete_and_move' => 'Bakahia na puzie',
	'delete_and_move_text' => '== I kachafu gi me ==
Ebe ihü gé rú "[[:$1]]" di kwa.
I chorí kàchafu ya ka uzor mepo maka mpuzie ne me?',
	'delete_and_move_confirm' => 'Eeh, kàchafu ihüa',
	'descending_abbrev' => 'ndạtạ',
	'dberr-header' => 'Wiki nka nwere nsogbu',
	'dberr-problems' => 'Ndó!
Ámá nka nwere nsogbu ime ime.',
);

$messages['ike-cans'] = array(
	'december' => 'ᑎᓯᒻᐳᕆ',
	'december-gen' => 'ᑎᓯᒻᐳᕆ',
	'dec' => 'ᑎᓯᒻ',
	'delete' => 'ᓂᐸᖅᑎᐹ',
	'difference' => '(ᐊᓯᐊᙳᑐᖅ ᒪᑉᐱᑕᖅ ᐊᑯᓐᓂᖓᓐᓂ ᑎᑎᕋᖅᑕᐅᒋᐊᕐᖓᕈᑦ)',
	'diff-multi' => '({{PLURAL:$1|ᐊᑕᐅᓯᖅ ᑭᒻᒥᐅᕗᖅ ᑎᑎᕋᖅᑕᐅᒋᐊᕐᖓᕈᑦ|$1 ᑭᒻᒥᐅᕗᖅ ᑎᑎᕋᖅᑕᐅᒋᐊᕐᖓᕈᑦ}} ᐊᔪᖅᑐᖅ ᐅᕝᕙ.)',
	'doubleredirects' => 'ᑕᐱᕐᖃᓕᒃ ᖃᓂᖓᓂ ᑲᒪᒋᔭᖅ ᐋᓯᑦ ᓇᑭᑦ',
	'dellogpage' => 'ᓂᐸᖅ ᓂᐱ',
	'deletionlog' => 'ᓂᐸᖅ ᓂᐱ',
	'delete_and_move' => 'ᓂᐸᖅᑎᐹ  ᐊᒻᒪ ᐅᐊᔪᖅ',
	'deletedrevision' => 'ᓂᐸᖅ ᐅᑐᖃᖅ ᑎᑎᕋᖅᑕᐅᒋᐊᕐᖓᕈᑦ $1',
);

$messages['ike-latn'] = array(
	'december' => 'tisimpuri',
	'december-gen' => 'tisimpuri',
	'delete' => 'nipaqtipaa',
	'difference' => '(asiaNngutuq mappitaq akunninganni titiraqtaugiarngarut)',
	'diff-multi' => '({{PLURAL:$1|atausiq kimmiuvuq titiraqtaugiarngarut|$1 kimmiuvuq titiraqtaugiarngarut}} ajuqtuq uvva.)',
	'doubleredirects' => 'tapirqilik qaningani kamagijaq aasit nakit',
	'dellogpage' => 'nipaq nipi',
	'deletionlog' => 'nipaq nipi',
	'delete_and_move' => 'nipaqtipaa amma uajuq',
	'deletedrevision' => 'nipaq utuqaq titiraqtaugiarngarut $1',
);

$messages['ilo'] = array(
	'december' => 'Disiembre',
	'december-gen' => 'Disiembre',
	'dec' => 'Dis',
	'delete' => 'Ikkaten',
	'deletethispage' => 'Ikkaten daytoy a panid',
	'disclaimers' => 'Dagiti karbengan ken rebbeng',
	'disclaimerpage' => 'Project:Sapasap ti karbengan ken rebbeng',
	'databaseerror' => 'Biddut iti database',
	'dberrortext' => 'Adda biddut ti database ti  gramatika na a pinagsapul.
Adda ngata  kiteb iti software.
Ti pinaudi a pinagsapul ti database ket:
<blockquote><tt>$1</tt></blockquote>
naggapu ti uneg ti opisio "<tt>$2</tt>".
Ti database ket nangipatulod ti biddut "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Adda biddut ti database ti  gramatika na a pinagsapul.
Ti pinaudi a panagsapul ti database ket:
"$1"
naggapu ti uneg ti opisio "$2".
Ti database ket nangipatulod ti biddut "$3: $4".',
	'directorycreateerror' => 'Saan a maaramid ti direktorio a "$1".',
	'deletedhist' => 'Naikkat a pakasaritaan',
	'difference' => '(Nagdudumaan iti baeten dagiti pannakabalbaliw)',
	'difference-multipage' => '(Paggiddiatan dagiti panid)',
	'diff-multi' => '({{PLURAL:$1|Maysa nga agtengnga a panangbalbaliw|$1 dagiti agtennga a panangbalbaliw}} ni {{PLURAL:$2|agararamat|$2 dagidiay agararamat}} ti saan a naipakita)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Maysa nga agtengnga a panangbalbaliw|$1 dagiti agtengnga a panangbalbaliw}} iti ad-adu nga $2 {{PLURAL:$2|agar-aramat|dagiti agar-aramat}} a saan a naipakita)',
	'datedefault' => 'Awan ti kaykayatan',
	'defaultns' => 'Wenno no saan agbiruk ka kadagitoy a nagan ti luglugar:',
	'default' => 'kinasigud',
	'diff' => 'sabali',
	'destfilename' => 'Pangipanan ti nagan ti papeles:',
	'duplicatesoffile' => 'Ti sumaganad a {{PLURAL:$1|papeles ket duplikado|$1 kadagiti papeles ket duplikado}} daytoy a papeles ([[Special:FileDuplicateSearch/$2|adu pay a salaysay]]):',
	'download' => 'Ikarga nga agpababa',
	'disambiguations' => 'Dagiti panid a nakasilpo kadagiti panangilawlawag',
	'disambiguationspage' => 'Template:pangipalpalawag',
	'disambiguations-text' => "Dagiti sumaganad a panid ket manilpo iti '''pagpalawag a panid'''.
Ngem agpasilpo da kuma ti husto a topiko.<br />
Ti panid ket kas a pagpalawag a panid no agusar ti templeta a nakasilpo idiay [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dagiti naminduan a panangbaw-ing',
	'doubleredirectstext' => 'Daytoy a panid ket ilista na dagiti panid nga agbaw-ing kadagiti sabsabali a baw-ing a pampanid.
Iti maysanga aray ket adda nagyan na kadagiti panilpo iti umuna ken maikadua a baw-ing, ken iti puntaan iti maikadua a baw-ing, nga isu ti "pudno" a puntaan ti panid, nga ti umuna a baw-ing ket isu ti ipatudo na.
<del>Nakurosan</del> dagita naikabil ket napadtuan.',
	'double-redirect-fixed-move' => '[[$1]] naiyalisen idiay.
Tattan ket naka baw-ing idiay [[$2]].',
	'double-redirect-fixed-maintenance' => 'Simsimpaen dagiti namindua a baw-ing a naggapo idiay [[$1]] idiay [[$2]].',
	'double-redirect-fixer' => 'Pagsimpa ti baw-ing',
	'deadendpages' => 'Dagiti ngudo a panid',
	'deadendpagestext' => 'Dagitoy a pampanid ket saan a nakasilpo ti sabali a pampanid ditoy {{SITENAME}} .',
	'deletedcontributions' => 'Dagiti naikkat nga inararamid ti agar-aramat',
	'deletedcontributions-title' => 'Dagiti naikkat nga inararamid iti agar-aramat',
	'defemailsubject' => '{{SITENAME}} e-surat naggapo ken ni "$1"',
	'deletepage' => 'Ikkaten ti panid',
	'delete-confirm' => 'Ikkaten ti "$1"',
	'delete-legend' => 'Ikkaten',
	'deletedtext' => 'Naikkaten ti "$1".
Kitaen ti $2 para iti panakrehistro dagiti naudi a naikkat.',
	'dellogpage' => 'Listaan ti panagikkat',
	'dellogpagetext' => 'Adda dita baba ti listaan dagiti kaudian a panangikkat.',
	'deletionlog' => 'listaan ti panagikkat',
	'deletecomment' => 'Rason:',
	'deleteotherreason' => 'Sabali/dadduma pay a rason:',
	'deletereasonotherlist' => 'Sabali a rason',
	'deletereason-dropdown' => '*Kadawyan a gapgapu dagiti pannakaikkat
** Kiddaw ti mannurat
** Panaglabsing iti karbengan ti pinagpablaak
** Bandalismo',
	'delete-edit-reasonlist' => 'Urnosen dagiti rason ti pinagikkat',
	'delete-toobig' => 'Daytoy a panid ket dakkel ti pakasaritaan na, mabalin ket $1 {{PLURAL:a panagbaliwan|dagiti panagbaliwan}}.
Ti panagikkat ti kastoy a pammpanid ket naparitan tapno mapawilan ti saan nga inkarkaro a panakadadael ti {{SITENAME}}.',
	'delete-warning-toobig' => 'Daytoy a panid ket addaan ti dakkel unay ti pakasaritaan na a panag-urnos, ti kaadu nga $1 {{PLURAL:$1|panagbaliw|dagiti panagbaliw}}.
Ti panagikkat ket madisturbo ti panagpataray ti database ti {{SITNAME}};
agal-aluad ka a mangrugi.',
	'databasenotlocked' => 'Saan a nabalunetan ti database.',
	'delete_and_move' => 'Ikkaten ken iyalis',
	'delete_and_move_text' => '== Masapul nga ikkaten ==
Ti pangipanan ti panid ket "[[:$1]]" addan.
Kayatmo nga ikkaten  tapno makaiyalis ka?',
	'delete_and_move_confirm' => 'Wen, ikkatenen ti panid',
	'delete_and_move_reason' => 'Naikkat tapno mawayaan ti panaka-iyalis idiay "[[$1]]"',
	'djvu_page_error' => 'Ti DjVu a panid ket saan a nasakup',
	'djvu_no_xml' => 'Saan a naala ti XML iti DjVu a papeles',
	'deletedrevision' => 'Naikkat ti daan a binaliwan $1',
	'days' => '{{PLURAL:$1|$1 aldaw|$1 al-aldaw}}',
	'deletedwhileediting' => "'''Ballaag''': Naikkaten daytoy a panid kalpasan a rinugiam nga agurnos!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => '\'\'\'Ballaag:\'\'\' Kinasigud a pinagilasin ti "$2" ket sukatan na ti immuna a kinasigud a pinagilasin "$1".',
	'dberr-header' => 'Adda ti pakirut na daytoy a wiki',
	'dberr-problems' => 'Pasensian a!
Daytoy a pagsaadan ket agdadama ti teknikal a pagrigrigatan.',
	'dberr-again' => 'Padasem ti agururay to manu a minutos ken agikarga.',
	'dberr-info' => '(San a makontak ti database server: $1)',
	'dberr-usegoogle' => 'Padasem  ti agbiruk idiay Google tatta.',
	'dberr-outofdate' => 'Palagip a dagiti listaan da kadagiti kukuami a nagyan ket baka nagpaso.',
	'dberr-cachederror' => 'Daytoy ket cached a kopia ti kiniddaw mo a panid, ken baka saan pay a barbaro.',
);

$messages['inh'] = array(
	'december' => 'Чантар',
	'december-gen' => 'Чантар бетт',
	'dec' => 'Чант.',
	'delete' => 'ДӀадаккха',
	'deletethispage' => 'Ер оагӀув дӀаяккха',
	'disclaimers' => 'Бокъонахь юхавалаp',
	'disclaimerpage' => 'Project:Бокъонахь юхавалаp',
	'deletedhist' => 'ДӀадакхамий искар',
	'difference' => '(Доржамашкахь юкъера къоастамаш)',
	'diff-multi' => '({{PLURAL:$1|$1 юкъара доржам хьахьекха дац|$1 юкъара доржамаш хьахьекха дац}} {{PLURAL:$2|$2 дакъалаьцархочунна|$2 дакъалаьцархоший}})',
	'diff' => 'кхы.',
	'download' => 'хьачуяккха',
	'disambiguationspage' => 'Template: ЦаI маIандоацар',
	'deletepage' => 'ОагIув дIаяккха',
	'deletedtext' => '"$1" дIаяккха хиннай.
ТIехьара дIадаьккха дагарчена хьожаргволаш/хьожаргьйолаш, $2 хьажа.',
	'dellogpage' => 'ДIадаккхара тептар',
	'deletecomment' => 'Бахьан:',
	'deleteotherreason' => 'Кхыдола бахьан/тIатохар:',
	'deletereasonotherlist' => 'Кхыдола бахьан',
	'duplicate-defaultsort' => 'Зем бе. Сатийна дIа-хьа хьоржама доагI "$2" хьалхара сатийна дIа-хьа хьоржама доагI "$1" хьахьоржа.',
	'dberr-header' => 'Укх викис халонаш ловш латта',
);

$messages['io'] = array(
	'december' => 'decembro',
	'december-gen' => 'di decembro',
	'dec' => 'dec',
	'delete' => 'Efacar',
	'deletethispage' => 'Efacar ica pagino',
	'disclaimers' => 'Legala averto',
	'disclaimerpage' => 'Project:Generala des-agnosko',
	'databaseerror' => 'Datumarala eroro',
	'deletedhist' => 'Efacita versionaro',
	'difference' => '(Diferi inter versioni)',
	'datedefault' => 'Sen prefero',
	'defaultns' => 'Altre serchar en ca nomari:',
	'diff' => 'dif',
	'disambiguations' => 'Pagini di desambiguizo',
	'doubleredirects' => 'Duopla ridirektili',
	'deadendpages' => 'Pagini sen ekiraji',
	'deletedcontributions' => 'Efacita uzanto-kontributadi',
	'deletedcontributions-title' => 'Efacita uzanto-kontributadi',
	'defemailsubject' => 'E-posto di {{SITENAME}}',
	'deletepage' => 'Efacar pagino',
	'delete-confirm' => 'Efacar "$1"',
	'delete-legend' => 'Efacar',
	'deletedtext' => '"$1" efacesis.
Videz $2 por obtenar registro di recenta efaci.',
	'dellogpage' => 'Efaco-registraro',
	'dellogpagetext' => 'Infre esas listo di la plu recenta efaci.',
	'deletionlog' => 'registro di efaciti',
	'deletecomment' => 'Motivo:',
	'deleteotherreason' => 'Altra/suplementala motivo:',
	'deletereasonotherlist' => 'Altra motivo',
	'deletereason-dropdown' => '*Ordinara motivi por efaco
** Demandita da autoro
** Kopiyuro Violaco
** Korupto',
	'delete_and_move_confirm' => 'Yes, efacez la pagino',
	'deletedwhileediting' => "'''Averto''': Ta pagino efacesis pos ke vu redakteskis!",
	'descending_abbrev' => 'decen',
	'dberr-header' => 'Ta wiki havas problemo',
);

$messages['is'] = array(
	'december' => 'desember',
	'december-gen' => 'desember',
	'dec' => 'des',
	'delete' => 'Eyða',
	'deletethispage' => 'Eyða þessari síðu',
	'disclaimers' => 'Fyrirvarar',
	'disclaimerpage' => 'Project:Almennur fyrirvari',
	'databaseerror' => 'Gagnagrunnsvilla',
	'dberrortext' => 'Málfræðivilla kom upp í gangagrnunsfyrirspurninni.
Þetta gæti verið vegna villu í hugbúnaðinum.
Síðasta gagnagrunnsfyrirspurnin var:
<blockquote><tt>$1</tt></blockquote>
úr aðgerðinni: „<tt>$2</tt>“.
MySQL skilar villuboðanum „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Málfræðivilla kom upp í gangagrnunsfyrirspurninni.
Síðasta gagnagrunnsfyrirspurnin var:
„$1“
úr aðgerðinni: „$2“.
MySQL skilar villuboðanum „$3: $4“',
	'directorycreateerror' => 'Gat ekki búið til efnisskrána "$1".',
	'deletedhist' => 'Eyðingaskrá',
	'difference-title' => '$1: Munur á milli útgáfa',
	'difference-title-multipage' => '$1 og $2: Munur á milli síðna',
	'difference-multipage' => '(Munur á milli síðna)',
	'diff-multi' => '({{PLURAL:$1|Ein millibreyting ekki sýnd|$1 millibreytingar ekki sýndar}} frá {{PLURAL:$2|notanda|$2 notendum}}.)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Ein millibreyting ekki sýnd|$1 millibreytingar ekki sýndar}} frá fleiri en {{PLURAL:$2|einum notanda|$2 notendum}}.)',
	'datedefault' => 'Sjálfgefið',
	'defaultns' => 'Leita í þessum nafnrýmum sjálfgefið:',
	'default' => 'sjálfgefið',
	'diff' => 'breyting',
	'destfilename' => 'Móttökuskráarnafn:',
	'duplicatesoffile' => 'Eftirfarandi {{PLURAL:$1|skrá er afrit|$1 skrár eru afrit}} af þessari skrá ([[Special:FileDuplicateSearch/$2|Frekari upplýsingar]]):',
	'download' => 'Hlaða niður',
	'disambiguations' => 'Síður sem tengja á aðgreiningarsíður',
	'disambiguationspage' => 'Template:Aðgreining',
	'disambiguations-text' => "Þessar síður innihalda tengla á svokallaðar „'''aðgreiningarsíður'''“.
Laga ætti tenglanna og láta þá vísa á rétta síðu.<br />
Farið er með síðu sem aðgreiningarsíðu ef að hún inniheldur snið sem vísað er í frá [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Tvöfaldar tilvísanir',
	'doubleredirectstext' => 'Þessi síða er listi yfir skrár sem eru tilvísanir á aðrar tilvísanir.
Hver lína inniheldur tengla á fyrstu og aðra tilvísun auk þeirrar síðu sem seinni tilvísunin beinist að, sem er oftast sú síða sem allar tilvísanirnar eiga að benda á.
<del>Yfirstrikaðar</del> færslur hafa verið leiðréttar.',
	'double-redirect-fixed-move' => '[[$1]] hefur verið færð.
Hún er tilvísun á [[$2]].',
	'double-redirect-fixed-maintenance' => 'Laga tvöfalda tilvísun frá [[$1]] til [[$2]].',
	'double-redirect-fixer' => 'Laga tilvísun',
	'deadendpages' => 'Botnlangar',
	'deadendpagestext' => 'Eftirfarandi síður tengjast ekki við aðrar síður á {{SITENAME}}.',
	'deletedcontributions' => 'Eyddar breytingar notanda',
	'deletedcontributions-title' => 'Eyddar breytingar notanda',
	'defemailsubject' => '{{SITENAME}} netfang notanda "$1"',
	'deletepage' => 'Eyða',
	'delete-confirm' => 'Eyða „$1“',
	'delete-legend' => 'Eyða',
	'deletedtext' => '„$1“ hefur verið eytt.
Sjá lista yfir nýlegar eyðingar í $2.',
	'dellogpage' => 'Eyðingaskrá',
	'dellogpagetext' => 'Að neðan gefur að líta lista yfir síður sem nýlega hefur verið eytt.',
	'deletionlog' => 'eyðingaskrá',
	'deletecomment' => 'Ástæða:',
	'deleteotherreason' => 'Aðrar/fleiri ástæður:',
	'deletereasonotherlist' => 'Önnur ástæða',
	'deletereason-dropdown' => '* Algengar ástæður
** Að beiðni höfundar
** Höfundaréttarbrot
** Skemmdarverk',
	'delete-edit-reasonlist' => 'Breyta eyðingarástæðum',
	'delete-toobig' => 'Þessi síða hefur stóra breytingarskrá, yfir $1 {{PLURAL:$1|breyting|breytingar}}.
Óheimilt er að eyða slíkum síðum til að valda ekki óæskilegum truflunum á {{SITENAME}}.',
	'delete-warning-toobig' => 'Þessi síða hefur stóra breytingarskrá, yfir $1 {{PLURAL:$1|breyting|breytingar}}.
Eyðing síðunnar gæti truflað vinnslu gangnasafns {{SITENAME}}; haltu áfram með varúð.',
	'databasenotlocked' => 'Gagnagrunnurinn er ekki læstur.',
	'delete_and_move' => 'Eyða og flytja',
	'delete_and_move_text' => '==Beiðni um eyðingu==

Síðan „[[:$1]]“ er þegar til. Viltu eyða henni til þess að rýma til fyrir flutningi?',
	'delete_and_move_confirm' => 'Já, eyða síðunni',
	'delete_and_move_reason' => 'Eytt til að rýma til fyrir flutning frá "[[$1]]"',
	'deletedrevision' => 'Eyddi gamla útgáfu $1',
	'days' => '{{PLURAL:$1|einn dagur|$1 dagar}}',
	'deletedwhileediting' => "'''Viðvörun''': Þessari síðu var eytt eftir að þú fórst að breyta henni!",
	'descending_abbrev' => 'lækkandi',
	'duplicate-defaultsort' => '\'\'\'Viðvörun:\'\'\' Sjálfgildur flýtihnappur "$2" tekur yfir fyrri flýtihnapp "$1".',
	'dberr-header' => 'Vandamál við þennan wiki',
	'dberr-problems' => 'Því miður!
Tæknilegir örðugleikar eru á þessari síðu.',
	'dberr-again' => 'Reyndu að bíða í nokkrar mínútur og endurhladdu síðan síðuna.',
	'dberr-info' => '(Mistókst að hafa samband við gagnaþjón: $1)',
	'dberr-usegoogle' => 'Þú getur notað Google til að leita á meðan.',
	'dberr-outofdate' => 'Athugaðu að afrit þeirra gætu verið úreld.',
	'dberr-cachederror' => 'Þetta er afritað eintak af umbeðinni síðu og gæti verið úreld.',
	'duration-seconds' => '$1 {{PLURAL:$1|sekúnda|sekúndur}}',
	'duration-minutes' => '$1 {{PLURAL:$1|mínúta|mínútur}}',
	'duration-hours' => '$1 {{PLURAL:$1|klukkustund|klukkustundir}}',
	'duration-days' => '$1 {{PLURAL:$1|dagur|dagar}}',
	'duration-weeks' => '$1 {{PLURAL:$1|vika|vikur}}',
	'duration-years' => '$1 {{PLURAL:$1|ár|ár}}',
	'duration-decades' => '$1 {{PLURAL:$1|áratugur|áratugir}}',
	'duration-centuries' => '$1 {{PLURAL:$1|öld|aldir}}',
	'discuss' => 'Spjall',
);

$messages['it'] = array(
	'december' => 'dicembre',
	'december-gen' => 'dicembre',
	'dec' => 'dic',
	'delete' => 'Cancella',
	'deletethispage' => 'Cancella questa pagina',
	'disclaimers' => 'Avvertenze',
	'disclaimerpage' => 'Project:Avvertenze generali',
	'databaseerror' => 'Errore del database',
	'dberrortext' => 'Errore di sintassi nella richiesta inoltrata al database.
Ciò potrebbe indicare la presenza di un bug nel software.
L\'ultima query inviata al database è stata:
<blockquote><tt>$1</tt></blockquote>
richiamata dalla funzione "<tt>$2</tt>".
Il database ha restituito il seguente errore "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Errore di sintassi nella richiesta inoltrata al database.
L\'ultima query inviata al database è stata:
"$1"
richiamata dalla funzione "$2".
Il database ha restituito il seguente errore "$3: $4".',
	'directorycreateerror' => 'Impossibile creare la directory "$1".',
	'deletedhist' => 'Cronologia cancellata',
	'difference' => '(Differenze fra le revisioni)',
	'difference-multipage' => '(Differenze fra le pagine)',
	'diff-multi' => '({{PLURAL:$1|Una revisione intermedia|$1 revisioni intermedie}} di {{PLURAL:$2|un utente|$2 utenti}} non mostrate)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Una revisione intermedia|$1 revisioni intermedie}} di oltre $2 {{PLURAL:$2|utente|utenti}} non mostrate)',
	'datedefault' => 'Nessuna preferenza',
	'defaultns' => 'In caso contrario, cerca in questi namespace:',
	'default' => 'predefinito',
	'diff' => 'diff',
	'destfilename' => 'Nome del file di destinazione:',
	'duplicatesoffile' => '{{PLURAL:$1|Il seguente file è un duplicato|I seguenti $1 file sono duplicati}} di questo file ([[Special:FileDuplicateSearch/$2|ulteriori dettagli]]):',
	'download' => 'scarica',
	'disambiguations' => 'Pagine che si collegano a pagine di disambiguazione',
	'disambiguationspage' => 'Template:Disambigua',
	'disambiguations-text' => "Le pagine nella lista che segue contengono dei collegamenti a '''pagine di disambiguazione''' e non all'argomento cui dovrebbero fare riferimento.<br />Vengono considerate pagine di disambiguazione tutte quelle che contengono i template elencati in [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Redirect doppi',
	'doubleredirectstext' => 'In questa pagina sono elencate pagine che reindirizzano ad altre pagine di redirect.
Ciascuna riga contiene i collegamenti al primo ed al secondo redirect, oltre alla prima riga di testo del secondo redirect che di solito contiene la pagina di destinazione "corretta" alla quale dovrebbe puntare anche il primo redirect.
I redirect <del>cancellati</del> sono stati corretti.',
	'double-redirect-fixed-move' => '[[$1]] è stata spostata automaticamente, ora è un redirect a [[$2]]',
	'double-redirect-fixed-maintenance' => 'Corretto doppio redirect da [[$1]] a [[$2]].',
	'double-redirect-fixer' => 'Correttore di redirect',
	'deadendpages' => 'Pagine senza uscita',
	'deadendpagestext' => 'Le pagine indicate di seguito sono prive di collegamenti verso altre pagine di {{SITENAME}}.',
	'deletedcontributions' => 'Contributi utente cancellati',
	'deletedcontributions-title' => 'Contributi utente cancellati',
	'defemailsubject' => 'Messaggio da {{SITENAME}} dall\'utente "$1"',
	'deletepage' => 'Cancella pagina',
	'delete-confirm' => 'Cancella "$1"',
	'delete-legend' => 'Cancella',
	'deletedtext' => 'La pagina "$1" è stata cancellata.
Consultare il log delle $2 per un elenco delle pagine cancellate di recente.',
	'dellogpage' => 'Cancellazioni',
	'dellogpagetext' => 'Di seguito sono elencate le pagine cancellate di recente.',
	'deletionlog' => 'cancellazioni',
	'deletecomment' => 'Motivo:',
	'deleteotherreason' => 'Altra motivazione o motivazione aggiuntiva:',
	'deletereasonotherlist' => 'Altra motivazione',
	'deletereason-dropdown' => "*Motivazioni più comuni per la cancellazione
** Richiesta dell'autore
** Violazione di copyright
** Vandalismo",
	'delete-edit-reasonlist' => 'Modifica i motivi di cancellazione',
	'delete-toobig' => 'La cronologia di questa pagina è molto lunga (oltre $1 {{PLURAL:$1|revisione|revisioni}}). La sua cancellazione è stata limitata per evitare di creare accidentalmente dei problemi di funzionamento al database di {{SITENAME}}.',
	'delete-warning-toobig' => 'La cronologia di questa pagina è molto lunga (oltre $1 {{PLURAL:$1|revisione|revisioni}}). La sua cancellazione può creare dei problemi di funzionamento al database di {{SITENAME}}; procedere con cautela.',
	'databasenotlocked' => 'Il database non è bloccato.',
	'delete_and_move' => 'Cancella e sposta',
	'delete_and_move_text' => '==Cancellazione richiesta==

La pagina specificata come destinazione "[[:$1]]" esiste già. Vuoi cancellarla per proseguire con lo spostamento?',
	'delete_and_move_confirm' => 'Sì, sovrascrivi la pagina esistente',
	'delete_and_move_reason' => 'Cancellata per rendere possibile lo spostamento da "[[$1]]"',
	'djvu_page_error' => 'Numero di pagina DjVu errato',
	'djvu_no_xml' => "Impossibile ottenere l'XML per il file DjVu",
	'deletedrevision' => 'Cancellata la vecchia revisione di $1.',
	'days' => '{{PLURAL:$1|un giorno|$1 giorni}}',
	'deletedwhileediting' => "'''Attenzione''': questa pagina è stata cancellata dopo che hai cominciato a modificarla!",
	'descending_abbrev' => 'decresc',
	'duplicate-defaultsort' => 'Attenzione: la chiave di ordinamento predefinita "$2" sostituisce la precedente "$1".',
	'dberr-header' => 'Questa wiki ha un problema',
	'dberr-problems' => 'Questo sito sta avendo dei problemi tecnici.',
	'dberr-again' => 'Prova ad attendere qualche minuto e ricaricare.',
	'dberr-info' => '(Impossibile contattare il server del database: $1)',
	'dberr-usegoogle' => 'Puoi provare a cercare su Google nel frattempo.',
	'dberr-outofdate' => 'Nota che la loro indicizzazione dei nostri contenuti potrebbe non essere aggiornata.',
	'dberr-cachederror' => 'Quella che segue è una copia cache della pagina richiesta, e potrebbe non essere aggiornata.',
);

$messages['iu'] = array(
	'december' => 'dicembre',
	'december-gen' => 'dicembre',
	'dec' => 'dic',
	'delete' => 'Cancella',
	'deletethispage' => 'Cancella questa pagina',
	'disclaimers' => 'Avvertenze',
	'disclaimerpage' => 'Project:Avvertenze generali',
	'databaseerror' => 'Errore del database',
	'dberrortext' => 'Errore di sintassi nella richiesta inoltrata al database.
Ciò potrebbe indicare la presenza di un bug nel software.
L\'ultima query inviata al database è stata:
<blockquote><tt>$1</tt></blockquote>
richiamata dalla funzione "<tt>$2</tt>".
Il database ha restituito il seguente errore "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Errore di sintassi nella richiesta inoltrata al database.
L\'ultima query inviata al database è stata:
"$1"
richiamata dalla funzione "$2".
Il database ha restituito il seguente errore "$3: $4".',
	'directorycreateerror' => 'Impossibile creare la directory "$1".',
	'deletedhist' => 'Cronologia cancellata',
	'difference' => '(Differenze fra le revisioni)',
	'difference-multipage' => '(Differenze fra le pagine)',
	'diff-multi' => '({{PLURAL:$1|Una revisione intermedia|$1 revisioni intermedie}} di {{PLURAL:$2|un utente|$2 utenti}} non mostrate)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Una revisione intermedia|$1 revisioni intermedie}} di oltre $2 {{PLURAL:$2|utente|utenti}} non mostrate)',
	'datedefault' => 'Nessuna preferenza',
	'defaultns' => 'In caso contrario, cerca in questi namespace:',
	'default' => 'predefinito',
	'diff' => 'diff',
	'destfilename' => 'Nome del file di destinazione:',
	'duplicatesoffile' => '{{PLURAL:$1|Il seguente file è un duplicato|I seguenti $1 file sono duplicati}} di questo file ([[Special:FileDuplicateSearch/$2|ulteriori dettagli]]):',
	'download' => 'scarica',
	'disambiguations' => 'Pagine che si collegano a pagine di disambiguazione',
	'disambiguationspage' => 'Template:Disambigua',
	'disambiguations-text' => "Le pagine nella lista che segue contengono dei collegamenti a '''pagine di disambiguazione''' e non all'argomento cui dovrebbero fare riferimento.<br />Vengono considerate pagine di disambiguazione tutte quelle che contengono i template elencati in [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Redirect doppi',
	'doubleredirectstext' => 'In questa pagina sono elencate pagine che reindirizzano ad altre pagine di redirect.
Ciascuna riga contiene i collegamenti al primo ed al secondo redirect, oltre alla prima riga di testo del secondo redirect che di solito contiene la pagina di destinazione "corretta" alla quale dovrebbe puntare anche il primo redirect.
I redirect <del>cancellati</del> sono stati corretti.',
	'double-redirect-fixed-move' => '[[$1]] è stata spostata automaticamente, ora è un redirect a [[$2]]',
	'double-redirect-fixed-maintenance' => 'Corretto doppio redirect da [[$1]] a [[$2]].',
	'double-redirect-fixer' => 'Correttore di redirect',
	'deadendpages' => 'Pagine senza uscita',
	'deadendpagestext' => 'Le pagine indicate di seguito sono prive di collegamenti verso altre pagine di {{SITENAME}}.',
	'deletedcontributions' => 'Contributi utente cancellati',
	'deletedcontributions-title' => 'Contributi utente cancellati',
	'defemailsubject' => 'Messaggio da {{SITENAME}} dall\'utente "$1"',
	'deletepage' => 'Cancella pagina',
	'delete-confirm' => 'Cancella "$1"',
	'delete-legend' => 'Cancella',
	'deletedtext' => 'La pagina "$1" è stata cancellata.
Consultare il log delle $2 per un elenco delle pagine cancellate di recente.',
	'dellogpage' => 'Cancellazioni',
	'dellogpagetext' => 'Di seguito sono elencate le pagine cancellate di recente.',
	'deletionlog' => 'cancellazioni',
	'deletecomment' => 'Motivo:',
	'deleteotherreason' => 'Altra motivazione o motivazione aggiuntiva:',
	'deletereasonotherlist' => 'Altra motivazione',
	'deletereason-dropdown' => "*Motivazioni più comuni per la cancellazione
** Richiesta dell'autore
** Violazione di copyright
** Vandalismo",
	'delete-edit-reasonlist' => 'Modifica i motivi di cancellazione',
	'delete-toobig' => 'La cronologia di questa pagina è molto lunga (oltre $1 {{PLURAL:$1|revisione|revisioni}}). La sua cancellazione è stata limitata per evitare di creare accidentalmente dei problemi di funzionamento al database di {{SITENAME}}.',
	'delete-warning-toobig' => 'La cronologia di questa pagina è molto lunga (oltre $1 {{PLURAL:$1|revisione|revisioni}}). La sua cancellazione può creare dei problemi di funzionamento al database di {{SITENAME}}; procedere con cautela.',
	'databasenotlocked' => 'Il database non è bloccato.',
	'delete_and_move' => 'Cancella e sposta',
	'delete_and_move_text' => '==Cancellazione richiesta==

La pagina specificata come destinazione "[[:$1]]" esiste già. Vuoi cancellarla per proseguire con lo spostamento?',
	'delete_and_move_confirm' => 'Sì, sovrascrivi la pagina esistente',
	'delete_and_move_reason' => 'Cancellata per rendere possibile lo spostamento da "[[$1]]"',
	'djvu_page_error' => 'Numero di pagina DjVu errato',
	'djvu_no_xml' => "Impossibile ottenere l'XML per il file DjVu",
	'deletedrevision' => 'Cancellata la vecchia revisione di $1.',
	'days' => '{{PLURAL:$1|un giorno|$1 giorni}}',
	'deletedwhileediting' => "'''Attenzione''': questa pagina è stata cancellata dopo che hai cominciato a modificarla!",
	'descending_abbrev' => 'decresc',
	'duplicate-defaultsort' => 'Attenzione: la chiave di ordinamento predefinita "$2" sostituisce la precedente "$1".',
	'dberr-header' => 'Questa wiki ha un problema',
	'dberr-problems' => 'Questo sito sta avendo dei problemi tecnici.',
	'dberr-again' => 'Prova ad attendere qualche minuto e ricaricare.',
	'dberr-info' => '(Impossibile contattare il server del database: $1)',
	'dberr-usegoogle' => 'Puoi provare a cercare su Google nel frattempo.',
	'dberr-outofdate' => 'Nota che la loro indicizzazione dei nostri contenuti potrebbe non essere aggiornata.',
	'dberr-cachederror' => 'Quella che segue è una copia cache della pagina richiesta, e potrebbe non essere aggiornata.',
);

$messages['ja'] = array(
	'december' => '12月',
	'december-gen' => '12月',
	'dec' => '12月',
	'delete' => '削除',
	'deletethispage' => 'このページを削除',
	'disclaimers' => '免責事項',
	'disclaimerpage' => 'Project:免責事項',
	'databaseerror' => 'データベース・エラー',
	'dberrortext' => 'データベースクエリの構文エラーが発生しました。
ソフトウェアにバグがある可能性があります。
最後に実行を試みたクエリは次の通りです：
関数「<tt>$2</tt>」内
<blockquote><tt>$1</tt></blockquote>。
データベースの返したエラー「<tt>$3：$4</tt>」',
	'dberrortextcl' => 'データベースクエリの構文エラーが発生しました。
最後に実行を試みたクエリは次の通りです:
関数 "$2" 内
"$1"
データベースの返したエラー "$3: $4"',
	'directorycreateerror' => 'ディレクトリー「$1」を作成できませんでした。',
	'deletedhist' => '削除された履歴',
	'difference' => '（版間での差分）',
	'difference-multipage' => '（ページ間の差分）',
	'diff-multi' => '（$2人の利用者による、間の$1版が非表示）',
	'diff-multi-manyusers' => '（$2人以上の利用者による、間の$1版が非表示）',
	'datedefault' => '選択なし',
	'defaultns' => 'その他の場合、次の名前空間でのみ検索する：',
	'default' => '既定',
	'diff' => '差分',
	'destfilename' => '登録するファイル名：',
	'duplicatesoffile' => '以下の$1ファイルが、このファイルと内容が同一です（[[Special:FileDuplicateSearch/$2|詳細]]）：',
	'download' => 'ダウンロード',
	'disambiguations' => '曖昧さ回避ページにリンクしているページ',
	'disambiguationspage' => 'Template:曖昧回避',
	'disambiguations-text' => "以下のページは'''曖昧さ回避ページ'''へリンクしています。
これらのページは、より適した主題のページへリンクされるべきです。<br />
[[MediaWiki:Disambiguationspage]]からリンクされたテンプレートを使用しているページは、曖昧さ回避ページと見なされます。",
	'doubleredirects' => '二重転送',
	'doubleredirectstext' => 'これは他のリダイレクトページへのリダイレクトの一覧です。
各行には、最初のリダイレクトと、その転送先のリダイレクト、そのまた転送先へのリンクが表示されています。多くの場合、最終の転送先が正しい転送先であり、最初のリダイレクトは直接最後の転送先に向けるべきです。
<del>打ち消し線</del>のはいった項目は既に修正されています。',
	'double-redirect-fixed-move' => '[[$1]]が移動されました。
これからは[[$2]]に転送されます。',
	'double-redirect-fixed-maintenance' => '[[$1]]から[[$2]]への二重転送を修正します。',
	'double-redirect-fixer' => '転送修正係',
	'deadendpages' => '行き止まりページ',
	'deadendpagestext' => '以下のページは、{{SITENAME}}の他のページにリンクしていません。',
	'deletedcontributions' => '利用者の削除された投稿',
	'deletedcontributions-title' => '利用者の削除された投稿',
	'defemailsubject' => '利用者「$1」からの {{SITENAME}} 電子メール',
	'deletepage' => 'ページを削除',
	'delete-confirm' => '「$1」の削除',
	'delete-legend' => '削除',
	'deletedtext' => '「$1」は削除されました。
最近の削除に関しては、$2を参照してください。',
	'dellogpage' => '削除記録',
	'dellogpagetext' => '以下は、最近の削除と復帰の一覧です。',
	'deletionlog' => '削除記録',
	'deletecomment' => '理由：',
	'deleteotherreason' => '他の、または追加の理由：',
	'deletereasonotherlist' => 'その他の理由',
	'deletereason-dropdown' => '*よくある削除理由
** 投稿者依頼
** 著作権侵害
** 荒らし',
	'delete-edit-reasonlist' => '削除理由を編集する',
	'delete-toobig' => 'このページには、$1版より多い編集履歴があります。
このようなページの削除は、{{SITENAME}}の偶発的な問題を避けるため、制限されています。',
	'delete-warning-toobig' => 'このページには、 $1版より多い編集履歴があります。
削除すると、{{SITENAME}}のデータベース処理に大きな負荷がかかります。
十分に注意してください。',
	'databasenotlocked' => 'データベースはロックされていません。',
	'delete_and_move' => '削除して移動する',
	'delete_and_move_text' => '== 削除が必要です ==
移動先「[[:$1]]」は既に存在しています。
移動するためにこのページを削除しますか？',
	'delete_and_move_confirm' => 'ページを削除します',
	'delete_and_move_reason' => '「[[$1]]」からの移動のために削除',
	'djvu_page_error' => 'DjVuページが範囲外です',
	'djvu_no_xml' => 'DjVuファイルのXMLデータを取得できません',
	'deletedrevision' => '古い版$1を削除しました',
	'days' => '{{PLURAL:$1|$1日}}',
	'deletedwhileediting' => "'''警告：'''このページが、編集開始後に削除されました！",
	'descending_abbrev' => '降順',
	'duplicate-defaultsort' => "'''警告：'''既定の並び替えキー「$2」が、その前に書かれている既定の並び替えキー「$1」を上書きしています。",
	'dberr-header' => '問題発生中です',
	'dberr-problems' => '申し訳ありません！
このウェブサイトに技術的な問題が発生しています。',
	'dberr-again' => '数分間待った後、もう一度読み込んでください。',
	'dberr-info' => '（データベースサーバー：$1に接続できませんでした。）',
	'dberr-usegoogle' => '元に戻るまで、Googleを利用して検索することができます。',
	'dberr-outofdate' => 'それらが収集した内容は古い可能性があることに注意してください。',
	'dberr-cachederror' => 'これは要求されたページをキャッシュした複製であり、古くなっている可能性があります。',
	'discuss' => 'このページについて話し合う',
);

$messages['jam'] = array(
	'december' => 'Disemba',
	'december-gen' => 'Disemba',
	'dec' => 'Dis',
	'delete' => 'Diliit',
	'deletethispage' => 'Diliit dis piej',
	'disclaimers' => 'Diskliema',
	'disclaimerpage' => 'Project: Jinaral diskliema',
	'databaseerror' => 'Dietabies era',
	'dberrortext' => 'A dietabies kwieri sintax era okor.
Dis maita indikiet wahn bog ina di saafwier.
Di laas atemp dietabies kwieri ena:
<blockquote><tt>$1</tt></blockquote>
frahn widin fongshan "<tt>$2</tt>".
Dietabies ritoern era "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'A dietabies kwieri sintax era okor.
Di laas attemp dietabies kwieri ena:
"$1"
frahn widin fongshan "$2".
Dietabies ritoern era "$3: $4"',
	'directorycreateerror' => 'Kudn kriet direkchri "$1".',
	'difference' => '(Difrans bitwiin rivijandem)',
	'diff' => 'dif',
	'deletepage' => 'Diliit piej',
	'deletedtext' => '"$1" don diliit.
Si $2 fi a rekaad a riisant diliishan.',
	'dellogpage' => 'Diliishan lag',
	'deletecomment' => 'Riizn:',
	'deleteotherreason' => 'Ada/adishanal riizn:',
	'deletereasonotherlist' => 'Ada riizn',
);

$messages['jbo'] = array(
	'december' => 'decmbero',
	'december-gen' => 'la gaimast.',
	'dec' => 'dec',
	'delete' => 'daspo',
	'disclaimers' => "nunxusra lo za'i na fuzme",
	'disclaimerpage' => "Project:kampu nunxusra be lo za'i na fuzme",
	'diff' => 'te frica',
	'dellogpage' => 'plivei fi loi nu daspo',
	'deletionlog' => 'plivei fi loi nu daspo',
);

$messages['jut'] = array(
	'december' => 'desember',
	'december-gen' => 'desembers',
	'dec' => 'des',
	'delete' => 'Slet',
	'deletethispage' => 'Slet side',
	'disclaimers' => 'Førbeholt',
	'disclaimerpage' => 'Project:Huses førbeholt',
	'databaseerror' => 'Databasefejl',
	'dberrortext' => 'Der er åpstået en syntaksfejl i en databaseførespørgsel.
Dette ken være på grund åf en ugyldeg førespørgsel,
æller det ken betyde en fejl i\'n softwær.
Den seneste førsøĝte databaseførespørgsel var:
<blockquote><tt>$1</tt></blockquote>
frå\'n funksje "<tt>$2</tt>".
MySQL æ returnerede fejl "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Der er åpstået en syntaksfejl i en databaseførespørgsel.
Den seneste førsøĝte databaseførespørgsel var: "$1" frå\'n funksje "$2".
MySQL æ returnerede fejl "$3: $4".',
	'directorycreateerror' => 'Kan ekke åprette katalåget "$1".',
	'difference' => '(Førskelle mellem hersenenger)',
	'diff-multi' => '(Æ hersenengssammenlegnenge vetåger {{PLURAL:$1|en mellemleggende hersenenge|$1 mellemleggende hersenenger}}.)',
	'diff' => 'førskel',
	'disambiguations' => 'Ertikler ve flertydige skrevselenger',
	'doubleredirects' => 'Dåbbelte åmstyrenger',
	'deadendpages' => 'Blendgydesider',
	'deletedcontributions' => 'Slettede brugerbidråg',
	'deletedcontributions-title' => 'Slettede brugerbidråg',
	'deletepage' => 'Slet side',
	'deletedtext' => '"$1" er slettet. Sæg $2 før en førtegnelse åver de nyeste sletnenger.',
	'dellogpage' => 'Sletnengslog',
	'deletecomment' => 'Begrundelse:',
	'deleteotherreason' => 'Anden/uddybende begrundelse:',
	'deletereasonotherlist' => 'Anden begrundelse',
);

$messages['jv'] = array(
	'december' => 'Désèmber',
	'december-gen' => 'Désèmber',
	'dec' => 'Des',
	'delete' => 'Busak',
	'deletethispage' => 'Busak kaca iki',
	'disclaimers' => 'Pamaidonan',
	'disclaimerpage' => 'Project:Panyangkalan umum',
	'databaseerror' => 'Kasalahan database',
	'dberrortext' => 'Ana kasalahan sintaks ing panyuwunan basis data.
Kasalahan iki mbokmenawa nuduhaké anané \'\'bug\'\' ing software.
Panyuwunan basis data sing pungkasan yakuwi: <blockquote><tt>$1</tt></blockquote>
saka jroning fungsi "<tt>$2</tt>".
Basis data ngasilaké kasalahan "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ana kasalahan sintaks ing panyuwunan basis data.
Panyuwunan basis data sing pungkasan iku:
"$1"
saka jroning fungsi "$2".
Basis data ngasilaké kasalahan "$3: $4".',
	'directorycreateerror' => 'Ora bisa nggawé dirèktori "$1".',
	'deletedhist' => 'Sajarah sing dibusak',
	'difference' => '(Prabédan antarrevisi)',
	'diff-multi' => '({{PLURAL:$1|Sawiji|$1}} revisi antara sing ora dituduhaké.)',
	'datedefault' => 'Ora ana préferènsi',
	'defaultns' => 'Utawa golèki ing bilik jeneng iki:',
	'default' => 'baku',
	'diff' => 'béda',
	'destfilename' => 'Jeneng berkas sing dituju',
	'duplicatesoffile' => '{{PLURAL:$1|berkas ing ngisor arupa duplikat|$1 berkas ing ngisor arupa duplikat}} saka berkas iki ([[Special:FileDuplicateSearch/$2|luwih rinci]]):',
	'download' => 'undhuh',
	'disambiguations' => 'Kaca disambiguasi',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => "Kaca-kaca iki ndarbèni pranala menyang sawijining ''kaca disambiguasi''.
Kaca-kaca iku sajatiné kuduné nyambung menyang topik-topik sing bener.<br />
Sawijining kaca dianggep minangka kaca disambiguasi yèn kaca iku nganggo cithakan sing nyambung menyang [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Pangalihan dobel',
	'doubleredirectstext' => 'Kaca iki ngandhut daftar kaca sing ngalih ing kaca pangalihan liyané. 
Saben baris ngandhut pranala menyang pangalihan kapisan lan kapindho, sarta tujuan saka pangalihan kapindho, sing biasané kaca tujuan sing "sajatiné", yakuwi pangalihan kapisan kuduné dialihaké menyang kaca tujuan iku.
Jeneng sing wis <s>dicorèk</s> tegesé wis rampung didandani.',
	'double-redirect-fixed-move' => '[[$1]] wis kapindhahaké, saiki dadi kaca peralihan menyang [[$2]]',
	'double-redirect-fixer' => 'Révisi pangalihan',
	'deadendpages' => 'Kaca-kaca buntu (tanpa pranala)',
	'deadendpagestext' => 'kaca-kaca iki ora nduwé pranala tekan ngendi waé ing wiki iki..',
	'deletedcontributions' => 'Kontribusi panganggo sing dibusak',
	'deletedcontributions-title' => 'Kontribusi panganggo sing dibusak',
	'defemailsubject' => 'Layang e-mail {{SITENAME}}',
	'deletepage' => 'Busak kaca',
	'delete-confirm' => 'Busak "$1"',
	'delete-legend' => 'Busak',
	'deletedtext' => '"<nowiki>$1</nowiki>" sampun kabusak. Coba pirsani $2 kanggé log paling énggal kaca ingkang kabusak.',
	'deletedarticle' => 'mbusak "[[$1]]"',
	'dellogpage' => 'Cathetan pambusakan',
	'dellogpagetext' => 'Ing ngisor iki kapacak log pambusakan kaca sing anyar dhéwé.',
	'deletionlog' => 'Cathetan sing dibusak',
	'deletecomment' => 'Alesan:',
	'deleteotherreason' => 'Alesan liya utawa tambahan:',
	'deletereasonotherlist' => 'Alesan liya',
	'deletereason-dropdown' => '*Alesan pambusakan
** Disuwun sing nulis
** Nglanggar hak cipta
** Vandalisme',
	'delete-edit-reasonlist' => 'Sunting alesan pambusakan',
	'delete-toobig' => 'Kaca iki ndarbèni sajarah panyuntingan sing dawa, yaiku ngluwihi $1 {{PLURAL:$1|revision|révisi}}.
Pambusakan kaca sing kaya mangkono mau wis ora diparengaké kanggo menggak anané karusakan ing {{SITENAME}}.',
	'delete-warning-toobig' => 'Kaca iki duwé sajarang panyuntingan sing dawa, luwih saka $1 {{PLURAL:$1|revision|révisi}}.
Mbusak kaca iki bisa ngrusak operasi basis data ing {{SITENAME}};
kudu ngati-ati.',
	'databasenotlocked' => 'Basis data ora dikunci.',
	'delete_and_move' => 'busak lan kapindahaken',
	'delete_and_move_text' => '== Perlu mbusak ==

Artikel sing dituju, "[[:$1]]", wis ana isiné.
Apa panjenengan kersa mbusak iku supaya kacané bisa dialihaké?',
	'delete_and_move_confirm' => 'Ya, busak kaca iku.',
	'delete_and_move_reason' => 'Dibusak kanggo antisipasi pangalihan kaca',
	'djvu_page_error' => "Kaca DjVu ana ing sajabaning ranggèhan (''range'')",
	'djvu_no_xml' => 'Ora bisa njupuk XML kanggo berkas DjVu',
	'deletedrevision' => 'Revisi lawas sing dibusak $1.',
	'deletedwhileediting' => "'''Pènget''': Kaca iki wis kabusak sawisé panjenengan miwiti nyunting!",
	'descending_abbrev' => 'mudhun',
	'duplicate-defaultsort' => 'Pènget: Kunci pilih asal (\'\'Default sort key\'\') "$2" nggantèkaké kunci pilih asal sadurungé "$1".',
	'dberr-header' => 'Wiki iki duwé masalah',
	'dberr-problems' => 'Nyuwun ngapura! Situs iki ngalami masalah tèknis.',
	'dberr-again' => 'Coba nunggu sawetara menit lan unggahna manèh.',
	'dberr-info' => '(Ora bisa nyambung menyang peladèn basis data: $1)',
	'dberr-usegoogle' => 'Panjenengan bisa nyoba nggolèki nganggo Google kanggo sauntara wektu.',
	'dberr-outofdate' => 'Perlu diweruhi yèn indhèks isi kita manawa wis kadaluwarsa.',
	'dberr-cachederror' => 'Iki sawijining salinan kasimpen kaca sing dijaluk, lan manawa dudu sing paling anyar.',
);

$messages['ka'] = array(
	'december' => 'დეკემბერი',
	'december-gen' => 'დეკემბრის',
	'dec' => 'დეკ',
	'delete' => 'წაშლა',
	'deletethispage' => 'გვერდის წაშლა',
	'disclaimers' => 'პასუხისმგებლობის მოხსნა',
	'disclaimerpage' => 'Project:პასუხისმგებლობის უარყოფა',
	'databaseerror' => 'შეცდომა მონაცემთა ბაზაში',
	'dberrortext' => 'აღმოჩენილია სინტაქსური შეცდომა მონაცემთა ბაზასთან დაკავშირებისას
შესაძლოა ეს არის შეცდომა პროგრამულ უზრუნველყოფაში,
ბოლო დაკავშირება მონაცემთა ბაზასან
<blockquote><tt>$1</tt></blockquote>
მოხდა ფუნქციიდან <tt>«$2»</tt>.
მონაცემთა ბაზამ დააბრუნა შეცდომა <tt>«$3: $4»</tt>.',
	'dberrortextcl' => 'მონაცემთა ბაზასთან დაკავშირებისას აღმოჩენილია სინტქსური შეცდომა.
საბოლოო დაკავშირება მოხდა:
«$1»
მოხდენილ იქნა ფუნქციიდან «$2».
მონაცემთა ბაზამ დააბრუნა შეცდომა «$3: $4».',
	'directorycreateerror' => 'დირექტორიის "$1" შექმნა შეუძლებელია.',
	'deletedhist' => 'წაშლილი ისტორია',
	'difference' => '(სხვაობა ვერსიებს შორის)',
	'diff-multi' => '({{PLURAL:$1|ერთი|$1}} შუა ვერსია არ არის ნაჩვენები.)',
	'datedefault' => 'წყარო მითითებული არაა',
	'defaultns' => 'სხვა შემთხვევაში ძიება შემდეგ სახელთა სივრცეებში:',
	'default' => 'სტანდარტული',
	'diff' => 'განსხ.',
	'destfilename' => 'საბოლოო სახელი:',
	'duplicatesoffile' => '{{PLURAL:$1|შემდეგი $1 ფაილი არის დუბლიკატი|შემდეგი $1 ფაილები არიან დუბლიკატები|შემდეგი $1 ფაილები არიან დუბლიკატები}} ამ ფაილისა ([[Special:FileDuplicateSearch/$2|დამატებითი ინფორმაცია]]):',
	'download' => 'გადმოტვირთვა',
	'disambiguations' => 'მრავალმნიშვნელოვანი გვერდები',
	'disambiguationspage' => 'Template:მრავალმნიშვნელოვანი',
	'disambiguations-text' => "შემდეგი გვერდები დაკავშირებულები არიან '''მრავალმნიშვნელობის გვერდთან'''.
ამის ნაცვლად იგი უნდა შეესაბამოს კონკრეტულ სტატიას.<br />
გვერდი ითვლება მრავალმნიშვნელოვნად, თუ მასზე გამოყენებულია [[MediaWiki:Disambiguationspage|მითსათითებელი თარგი]].",
	'doubleredirects' => 'ორმაგი გადამისამართება',
	'doubleredirectstext' => 'ამ გვერდზე ჩამოთვლილია გვერდები, რომლებიც გადამისამართებულია სხვა გადამისამართების გვერდებზე.
ყოველი მწკრივი შეიცავს ბმულებს პირველ და მეორე გადამისამართებაზე, აგრეთვე მეორე გადამისამართების ტექსტის პირველ სტრიქონს, რომელშიც ჩვეულებრივ მითითებულია რეალური “სამიზნე” გვერდის სათაური. საჭიროა, რომ პირველი გადამისამართებაც უთითებდეს ამ გვერდზე.
<s>გადახაზული</s> მონაცემები უკვე გამართულია.',
	'double-redirect-fixed-move' => '[[$1]] გადატანილ იქნა.
ამჟამად ის გადამისამართებულია [[$2]]-ზე.',
	'double-redirect-fixer' => 'გადამისამართება შემსწორებელი',
	'deadendpages' => 'ჩიხის გვერდები',
	'deadendpagestext' => 'ამ ვიკიში შემდგომ გვერდებს არ აქვთ ბმული სხვა გვერდებთან.',
	'deletedcontributions' => 'მომხმარებლის წაშლილი წვლილი',
	'deletedcontributions-title' => 'წაშლილი წვლილი',
	'defemailsubject' => 'წერილი ვიკიპედიიდან, თავისუფალი ქართული ენციკლოპედიიდან.',
	'deletepage' => 'გვერდის წაშლა',
	'delete-confirm' => '"$1"-ის წაშლა',
	'delete-legend' => 'წაშლა',
	'deletedtext' => '"<nowiki>$1</nowiki>" წაშლილია. ბოლო წაშლილი გვერდების სია იხილეთ $2-ში.',
	'deletedarticle' => 'წაშლილია "[[$1]]"',
	'dellogpage' => 'წაშლილთა_სია',
	'dellogpagetext' => 'ქვემოთ იხილეთ ახლად წაშლილთა სია.',
	'deletionlog' => 'წაშლილთა სია',
	'deletecomment' => 'მიზეზი:',
	'deleteotherreason' => 'სხვა/დამატებითი მიზეზი:',
	'deletereasonotherlist' => 'სხვა მიზეზი',
	'deletereason-dropdown' => '* წაშლის ხშირი მიზეზები
** ავტორის თხოვნით
** საავტორო უფლების დარღვევა
** ვანდალიზმი',
	'delete-edit-reasonlist' => 'წაშლის მიზეზების რედაქტირება',
	'delete-toobig' => 'ამ გვერდს ძალიან გრძელი ისტორია გააჩნია,  $1 {{PLURAL:$1|ვერსიაზე|ვერსიიებზე|ვერსიებზე}} მეტი. მისი წაშლა აიკრძალა {{SITENAME}}-ის კორექტურად მუშაობის უზრუნველყოფისთვის.',
	'delete-warning-toobig' => 'ამ გვერდს ძალიან გრძელი ისტორია გააჩნია,  $1 {{PLURAL:$1|ვერსიაზე|ვერსიიებზე|ვერსიებზე}} მეტი.
მისმა წაშლამ შესაძლოა გამოიწვიოს საიტის მონაცემთა ბაზის  {{SITENAME}} არაკორექტული მუშაობა;
იმოქმედეთ სიფრთხილით.',
	'databasenotlocked' => 'მონაცემთა ბაზა არაა ჩაკეტილი.',
	'delete_and_move' => 'წაშლა და გადატანა',
	'delete_and_move_text' => '==საჭიროა წაშლა==

სტატია დასახელებით "[[:$1]]" უკვე არსებობს. გსურთ მისი წაშლა გადატანისთვის ადგილის დასათმობად?',
	'delete_and_move_confirm' => 'დიახ, წაშალეთ ეს გვერდი',
	'delete_and_move_reason' => 'წაშლილია გადატანისთვის ადგილის დასათმობად',
	'djvu_page_error' => 'DjVu გვერდის ნომერი',
	'djvu_no_xml' => 'შეუძლებელია XML-ის მიღება DjVu-სთვის',
	'deletedrevision' => 'წაშლილია ძველი ვერსია $1.',
	'deletedwhileediting' => "'''ყურადღება''': ეს გვერდი წაიშალა მას შემდეგ, რაც თქვენ მისი რედაქტირება დაიწყეთ!",
	'descending_abbrev' => 'აღწერა',
	'duplicate-defaultsort' => "'''ყურადღება.'''სორტირების გასაღებს «$2»-ს გააჭრის წინა გასაღებს «$1»-ს.",
	'dberr-header' => 'ეს ვიკი განიცდის პრობლემას',
	'dberr-problems' => 'ბოდიში! საიტზე დროებითი ტექნიკური პრობლემებია',
	'dberr-again' => 'ეცადეთ რამდენიმე წუთით დაცდა და ამ გვერდის გადატვირთვა',
	'dberr-info' => 'ვერ მოხერხდა ინფორმაციის $1 სერვერთან დაკავშირება',
	'dberr-usegoogle' => 'ამ დროს კი  შეგიძლიათ Google-ით ძიება',
	'dberr-outofdate' => 'გაითვალისწინეთ, რომ თქვენი კონტენტის ინდექსები შეიძლება შეუსაბამო იყოს',
	'dberr-cachederror' => 'ეს არის მოთხოვნილი გვერდის კეშირებული ვერსია, და შესაძლება მოძველდა.',
);

$messages['kaa'] = array(
	'december' => 'Dekabr',
	'december-gen' => "dekabrdin'",
	'dec' => 'Dek',
	'delete' => "O'shiriw",
	'deletethispage' => "Usı betti o'shiriw",
	'disclaimers' => 'Juwapkershilikten bas tartıw',
	'disclaimerpage' => 'Project:Juwapkershilikten bas tartıw',
	'databaseerror' => "Mag'lıwmatlar bazası qa'tesi",
	'dberrortext' => "Mag'lıwmatlar bazası sorawında sintaksis qa'tesi sa'dir boldı.
Bul bag'darlamada qa'te barlıg'ın bildiriwi mu'mkin.
Aqırg'ı soralg'an mag'lıwmatlar bazası sorawı:
<blockquote><tt>\$1</tt></blockquote>
\"<tt>\$2</tt>\" funktsiyasınan.
Mag'lıwmatlar bazası qaytarg'an qa'tesi \"<tt>\$3: \$4</tt>\".",
	'dberrortextcl' => 'Mag\'lıwmatlar bazası sorawında sintaksis qa\'tesi sa\'dir boldı.
Aqırg\'ı soralg\'an mag\'lıwmatlar bazası sorawı:
"$1"
funktsiya: "$2".
Mag\'lıwmatlar bazası qaytarg\'an qa\'tesi "$3: $4".',
	'directorycreateerror' => '"$1" papkası jaratılmadı.',
	'deletedhist' => "O'shirilgenler tariyxı",
	'difference' => "(Nusqalar arasındag'ı ayırmashılıq)",
	'diff-multi' => "({{PLURAL:$2|bir paydalanıwshı|$2 paydalanıwshı}} ta'repinen {{PLURAL:$1|aralıq bir nusqa|aralıq $1 nusqa}} ko'rsetilmeydi.)",
	'datedefault' => 'Hesh sazlawlarsız',
	'defaultns' => "Bolmasa usı isimler ko'plikleri boyınsha izlew:",
	'default' => 'defolt',
	'diff' => 'parq',
	'destfilename' => 'Belgilengen fail atı:',
	'download' => 'koshirip alıw',
	'disambiguations' => "Ko'p ma'nisli betler",
	'disambiguationspage' => '{{ns:template}}:disambig',
	'doubleredirects' => 'Qos burıwshılar',
	'double-redirect-fixer' => "Qayta bag'ıtlawshılardı du'zetiwshi",
	'deadendpages' => "Hesh betke siltemeytug'ın betler",
	'deadendpagestext' => "To'mendegi betler {{SITENAME}} proyektindegi basqa betlerge siltelmegen.",
	'deletedcontributions' => "Paydalanıwshının' o'shiriw u'lesi",
	'defemailsubject' => '{{SITENAME}} e-mail',
	'deletepage' => "Betti o'shir",
	'delete-confirm' => '"$1" o\'shiriw',
	'delete-legend' => "O'shiriw",
	'deletedtext' => "\"\$1\" o'shirildi.
Aqırg'ı o'shirilgenlerdin' dizimin ko'riw ushin \$2 ni qaran'",
	'dellogpage' => "O'shiriw jurnalı",
	'dellogpagetext' => "To'mende en' aqırg'ı o'shirilgenlerdin' dizimi keltirilgen",
	'deletionlog' => "o'shiriw jurnalı",
	'deletecomment' => 'Sebep:',
	'deleteotherreason' => 'Basqa/qosımsha sebep:',
	'deletereasonotherlist' => 'Basqa sebep',
	'databasenotlocked' => "Mag'lıwmatlar bazası qulplanbag'an",
	'delete_and_move' => "O'shiriw ha'm ko'shiriw",
	'delete_and_move_confirm' => "Awa, bul betti o'shiriw",
	'delete_and_move_reason' => "Ko'shiriwge jol beriw ushın o'shirilgen",
	'deletedrevision' => "$1 eski nusqasın o'shirdi",
	'descending_abbrev' => 'kem.',
);

$messages['kab'] = array(
	'december' => 'Jember',
	'december-gen' => 'Jember',
	'dec' => 'Jember',
	'delete' => 'Mḥu',
	'deletethispage' => 'Mḥu asebter-agi',
	'disclaimers' => 'Iɣtalen',
	'disclaimerpage' => 'Project:Iɣtalen',
	'databaseerror' => 'Agul n database',
	'dberrortext' => 'Yella ugul n tseddast deg database.
Waqila yella bug deg software.
Query n database taneggarut hatt:
<blockquote><tt>$1</tt></blockquote>
seg tawuri  "<tt>$2</tt>".
MySQL yerra-d agul "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Yella ugul n tseddast deg database.
Query n database taneggarut hatt:
"$1"
seg tawuri "$2".
MySQL yerra-d agul "$3: $4"',
	'difference' => '(Imgerraden ger tisiwal)',
	'diff-multi' => '({{PLURAL:$1|Yiwen tasiwelt tabusarit|$1 n tisiwal tibusarin}} ur ttumlalent ara.)',
	'datedefault' => 'Ur sɛiɣ ara asemyifi',
	'defaultns' => 'Nadi deg yismawen n taɣult s umeslugen:',
	'default' => 'ameslugen',
	'diff' => 'amgirred',
	'destfilename' => 'Anda iruḥ afaylu',
	'download' => 'Ddem-it ɣer uselkim inek',
	'disambiguations' => 'isebtar n usefham',
	'disambiguationspage' => 'Template:Asefham',
	'disambiguations-text' => "Isebtar-agi sɛan azday ɣer '''usebter n usefham'''. Yessefk ad sɛun azday ɣer wezwel ṣaḥiḥ mačči ɣer usebter n usefham.",
	'doubleredirects' => 'Asemmimeḍ yeḍra snat tikwal',
	'doubleredirectstext' => 'Mkull ajerriḍ yesɛa azday ɣer asmimeḍ amezwaru akk d wis sin, ajerriḍ amezwaru n uḍris n usebter wis sin daɣen, iwumi yefkan asmimeḍ ṣaḥiḥ i yessefk ad sɛan isebtar azday ɣur-s.',
	'deadendpages' => 'isebtar mebla izdayen',
	'deadendpagestext' => 'isebtar-agi ur sɛan ara azday ɣer isebtar wiyaḍ deg wiki-yagi.',
	'defemailsubject' => 'e-mail n {{SITENAME}}',
	'deletepage' => 'Mḥu asebter',
	'deletedtext' => '"$1" yettumḥa.
Ẓer $2 i aɣmis n yimḥayin imaynuten.',
	'dellogpage' => 'Aɣmis n umḥay',
	'dellogpagetext' => 'Deg ukessar, yella wumuɣ n yimḥayin imaynuten.',
	'deletionlog' => 'Aɣmis n umḥay',
	'deletecomment' => 'Ayɣer',
	'delete_and_move' => 'Mḥu u smimeḍ',
	'delete_and_move_text' => '==Amḥay i tebɣiḍ==

Anda tebɣiḍ tesmimeḍ "[[:$1]]" yella yagi. tebɣiḍ ad temḥuḍ iwakken yeqqim-d wemkan i usmimeḍ?',
	'delete_and_move_confirm' => 'Ih, mḥu asebter',
	'delete_and_move_reason' => 'Mḥu iwakken yeqqim-d wemkan i usmimeḍ',
	'deletedrevision' => 'Tasiwelt taqdimt $1 tettumḥa.',
	'deletedwhileediting' => 'Aɣtal: Asebter-agi yettumḥa qbel ad tebdiḍ a t-tbeddleḍ!',
	'descending_abbrev' => 'akessar',
);

$messages['kbd'] = array(
	'december' => 'Jember',
	'december-gen' => 'Jember',
	'dec' => 'Jember',
	'delete' => 'Mḥu',
	'deletethispage' => 'Mḥu asebter-agi',
	'disclaimers' => 'Iɣtalen',
	'disclaimerpage' => 'Project:Iɣtalen',
	'databaseerror' => 'Agul n database',
	'dberrortext' => 'Yella ugul n tseddast deg database.
Waqila yella bug deg software.
Query n database taneggarut hatt:
<blockquote><tt>$1</tt></blockquote>
seg tawuri  "<tt>$2</tt>".
MySQL yerra-d agul "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Yella ugul n tseddast deg database.
Query n database taneggarut hatt:
"$1"
seg tawuri "$2".
MySQL yerra-d agul "$3: $4"',
	'difference' => '(Imgerraden ger tisiwal)',
	'diff-multi' => '({{PLURAL:$1|Yiwen tasiwelt tabusarit|$1 n tisiwal tibusarin}} ur ttumlalent ara.)',
	'datedefault' => 'Ur sɛiɣ ara asemyifi',
	'defaultns' => 'Nadi deg yismawen n taɣult s umeslugen:',
	'default' => 'ameslugen',
	'diff' => 'amgirred',
	'destfilename' => 'Anda iruḥ afaylu',
	'download' => 'Ddem-it ɣer uselkim inek',
	'disambiguations' => 'isebtar n usefham',
	'disambiguationspage' => 'Template:Asefham',
	'disambiguations-text' => "Isebtar-agi sɛan azday ɣer '''usebter n usefham'''. Yessefk ad sɛun azday ɣer wezwel ṣaḥiḥ mačči ɣer usebter n usefham.",
	'doubleredirects' => 'Asemmimeḍ yeḍra snat tikwal',
	'doubleredirectstext' => 'Mkull ajerriḍ yesɛa azday ɣer asmimeḍ amezwaru akk d wis sin, ajerriḍ amezwaru n uḍris n usebter wis sin daɣen, iwumi yefkan asmimeḍ ṣaḥiḥ i yessefk ad sɛan isebtar azday ɣur-s.',
	'deadendpages' => 'isebtar mebla izdayen',
	'deadendpagestext' => 'isebtar-agi ur sɛan ara azday ɣer isebtar wiyaḍ deg wiki-yagi.',
	'defemailsubject' => 'e-mail n {{SITENAME}}',
	'deletepage' => 'Mḥu asebter',
	'deletedtext' => '"$1" yettumḥa.
Ẓer $2 i aɣmis n yimḥayin imaynuten.',
	'dellogpage' => 'Aɣmis n umḥay',
	'dellogpagetext' => 'Deg ukessar, yella wumuɣ n yimḥayin imaynuten.',
	'deletionlog' => 'Aɣmis n umḥay',
	'deletecomment' => 'Ayɣer',
	'delete_and_move' => 'Mḥu u smimeḍ',
	'delete_and_move_text' => '==Amḥay i tebɣiḍ==

Anda tebɣiḍ tesmimeḍ "[[:$1]]" yella yagi. tebɣiḍ ad temḥuḍ iwakken yeqqim-d wemkan i usmimeḍ?',
	'delete_and_move_confirm' => 'Ih, mḥu asebter',
	'delete_and_move_reason' => 'Mḥu iwakken yeqqim-d wemkan i usmimeḍ',
	'deletedrevision' => 'Tasiwelt taqdimt $1 tettumḥa.',
	'deletedwhileediting' => 'Aɣtal: Asebter-agi yettumḥa qbel ad tebdiḍ a t-tbeddleḍ!',
	'descending_abbrev' => 'akessar',
);

$messages['kbd-cyrl'] = array(
	'december' => 'Дыгъэгъазэм и',
	'december-gen' => 'Дыгъэгъазэм и',
	'dec' => 'Дгъз',
	'delete' => 'Ихын',
	'deletethispage' => 'Мы напэкӀуэцӀыр ихын',
	'disclaimers' => 'Жэуап Ӏыгъыныр зыщхьэщыхын',
	'disclaimerpage' => 'Project:Пщэрылъу къэмыштэн',
	'databaseerror' => 'Ӏохугъуэлъэм и щыуагъэ',
	'dberrortext' => 'Ӏохугъуэлъэм и щӀэлъэуэн синтаксисым и щыуагъэ къахэкӀа.
Абым программэ къэтыным щыуагъэ иӀэфыну къокӀыр.
Яужырей Ӏохугъуэлъэм и щӀэлъэуэныр:
<blockquote><tt>$1</tt></blockquote>
функциэм къыхэкӀа <tt>«$2»</tt>.
Ӏохугъуэлъэм щыуагъэр къитыжащ <tt>«$3: $4»</tt>.',
	'dberrortextcl' => 'Ӏохугъуэлъэм и щӀэлъэуэн синтаксисым и щыуагъэ къахэкӀа.
Яужырей Ӏохугъуэлъэм и щӀэлъэуэныр:
$1
«$2» функциэм къыхэкӀа.
Ӏохугъуэлъэм щыуагъэр къитыжащ «$3: $4».',
	'directorycreateerror' => '«$1»-м и директориэ ищӀыфкъым.',
	'deletedhist' => 'Ихыгъуэхэм я тхыдэ',
	'difference' => '(Іэмалхэм я зэрызыщхьэщыкІыгъуэр)',
	'diff' => 'зэмылI.',
	'deletepage' => 'НапэкӀуэцӀыр ихын',
	'deletedtext' => '«$1» ираха.
Еплъ $2 яужыреуэ ирахахэм ярахахэм я тхылъ.',
	'dellogpage' => 'Ирахыжахэм я тхылъ',
	'deletecomment' => 'Щхьэусыгъуэ:',
	'deleteotherreason' => 'НэгъуэщӀ щхьэусыгъуэ/щӀыгъупхъэ:',
	'deletereasonotherlist' => 'НэгъуэщӀ щхьэусыгъуэ',
);

$messages['kg'] = array(
	'december' => 'ngôida ya kûmi na zôle',
	'december-gen' => 'ngônda ya kûmi na zôle',
	'dec' => 'ng12',
	'delete' => 'Kufwa',
	'deletethispage' => 'Kufwa mukanda yayi',
	'diff' => 'nsoba',
);

$messages['khw'] = array(
	'december' => 'دسمبر',
	'december-gen' => 'دسمبار',
	'dec' => 'دسمبر',
	'delete' => 'بوغاوے',
	'deletethispage' => 'ھیہ صفحہو بوغاوے',
	'disclaimers' => 'اعلانات',
	'disclaimerpage' => 'Project:عام کھوار اعلان',
	'databaseerror' => 'خطائے ڈیٹابیس',
	'dberrortext' => 'ڈیٹابیسہ ای خطائے نحوی واقع بیتی شیر.
ھمو وجھین مصنع‌لطیفا چاریو نشاندہیو اندیشہ شیر.
آچھو سعی‌شدہ ڈیٹابیسی استفسارہ ھیہ اوشوی:
<blockquote><tt>$1</tt></blockquote>
فعلیتو موژار "<tt>$2</tt>".
MySQL خطائی جواب پرائے "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'ڈیٹابیسو استفسارہ ای خطائے نحوی واقع بیتی شیر.
آچھو سعی‌شدہ ڈیٹابیسی استفسارہ ھیہ اوشوی:
"$1"
"$2" فعلیتو موژار.
MySQL جوابِ خطاء پرائے "$3: $4"',
	'directorycreateerror' => 'رہنامچہ "$1" تخلیق کورونو نو ھوی',
	'difference' => '(اصلاحاتہ فرق)',
	'diff-multi' => '({{PLURAL:$1|One intermediate revision|$1 intermediate revisions}} by {{PLURAL:$2|one user|$2 users}} not shown)',
	'diff' => 'فرق',
	'deadendpages' => 'بیردو صفحات',
	'deletepage' => 'صفحہو ضائع کورے',
	'deletedtext' => '"$1" حذف کورونو بیتی شیر ۔
حالیہ حذف شدگیو تاریخ نامو بچے  $2  لوڑے',
	'dellogpage' => 'نوشتۂ حذف شدگی',
	'deletecomment' => 'وجہ',
	'deleteotherreason' => 'جوو/اِضافی وجہ',
	'deletereasonotherlist' => 'جوو وجہ',
);

$messages['kiu'] = array(
	'december' => 'Gağan',
	'december-gen' => 'Gağani',
	'dec' => 'Gağ',
	'delete' => 'Bestere',
	'deletethispage' => 'Na pele bestere',
	'disclaimers' => 'Diwanê mesulêti',
	'disclaimerpage' => 'Project:Diwanê mesuliyetê bıngey',
	'databaseerror' => 'Xeta panga daeyu',
	'dberrortext' => 'Jü xeta persê cumla panga daeyu de amê meydan.
Heni aseno ke na xeta nustene de esta.
Persê panga daeyuno peyên nia bi:
<blockquote><tt>$1</tt></blockquote>
ebe gurê zerrê "<tt>$2</tt>"y ra.
Panga daeyu xetawa ke asnena "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Rêza cumleunê panga daeyu de jü xeta amê meydan.
Heni aseno ke na xeta nustene de esta.
Persê panga daeyuno peyên nia bi:
"$1"
Fonksiyono ke gureniyo "$2".
Panga daeyu xetawa ke asnena "$3: $4"',
	'directorycreateerror' => 'İndeksê "$1"i nêvıraşt.',
	'deletedhist' => 'Tarixo esterıte',
	'difference' => 'Ferqê wertê vurnaisu',
	'diff-multi' => '({{PLURAL:$1|Jü çımraviarnaena wertey|$1 çımraviarnaena wertey}} terefê {{PLURAL:$2|zu karberi|$2 karberu}} ra nêasnino)',
	'datedefault' => 'Tercihi çinê',
	'defaultns' => 'Halo bin de zerrê nê caunê namey de cıfeteliye:',
	'default' => 'ihmal',
	'diff' => 'ferq',
	'download' => 'bar ke',
	'disambiguationspage' => 'Template:vuriyaisê maney',
	'deletepage' => 'Pele bıestere',
	'deletedtext' => '"$1" esteriya.
Serba diyaena esterıteyunê peyênu $2 bıvêne.',
	'dellogpage' => 'Qeydê esterıtene',
	'deletecomment' => 'Sebeb:',
	'deleteotherreason' => 'Sebebo bin/ilaweki:',
	'deletereasonotherlist' => 'Sebebo bin',
);

$messages['kk-arab'] = array(
	'december' => 'جەلتوقسان',
	'december-gen' => 'جەلتوقساننىڭ',
	'dec' => 'جەل',
	'delete' => 'جويۋ',
	'deletethispage' => 'بەتتى جويۋ',
	'disclaimers' => 'جاۋاپكەرشىلىكتەن باس تارتۋ',
	'disclaimerpage' => 'Project:جاۋاپكەرشىلىكتەن باس تارتۋ',
	'databaseerror' => 'دەرەكقور قاتەسى',
	'dberrortext' => 'دەرەكقور سۇرانىمىندا سويلەم جۇيەسىنىڭ قاتەسى بولدى.
بۇل باعدارلامالىق جاساقتاما قاتەسىن بەلگىلەۋى مۇمكىن.
سوڭعى بولعان دەرەكقور سۇرانىمى:
<blockquote><tt>$1</tt></blockquote>
مىنا جەتەدەن «<tt>$2</tt>».
MySQL قايتارعان قاتەسى «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'دەرەكقور سۇرانىمىندا سويلەم جۇيەسىنىڭ قاتەسى بولدى.
سوڭعى بولعان دەرەكقور سۇرانىمى:
«$1»
مىنا جەتەدەن: «$2».
MySQL قايتارعان قاتەسى «$3: $4»',
	'directorycreateerror' => '«$1» قالتاسى قۇرىلمادى.',
	'deletedhist' => 'جويىلعان تارىيحى',
	'difference' => '(تۇزەتۋلەر اراسىنداعى ايىرماشىلىق)',
	'diff-multi' => '(اراداعى $1 تۇزەتۋ كورسەتىلمەگەن.)',
	'datedefault' => 'ەش قالاۋسىز',
	'defaultns' => 'مىنا ەسىم ايالاردا ادەپكىدەن ىزدەۋ:',
	'default' => 'ادەپكى',
	'diff' => 'ايىرم.',
	'destfilename' => 'نىسانا فايل اتاۋى:',
	'duplicatesoffile' => 'كەلەسى {{PLURAL:$1|فايل بۇل فايلدىڭ تەلنۇسقاسى|$1 فايل بۇل فايلدىڭ تەلنۇسقالارى}}:',
	'download' => 'قوتارىپ الۋ',
	'disambiguations' => 'ايرىقتى بەتتەر',
	'disambiguationspage' => '{{ns:template}}:ايرىق',
	'disambiguations-text' => "كەلەسى بەتتەر '''ايرىقتى بەتكە''' سىلتەيدى.
بۇنىڭ ورنىنا بەلگىلى تاقىرىپقا سىلتەۋى كەرەك.<br />
ەگەر [[MediaWiki:Disambiguationspage]] تىزىمىندەگى ۇلگى قولدانىلسا, بەت ايرىقتى دەپ سانالادى.",
	'doubleredirects' => 'شىنجىرلى ايداعىشتار',
	'doubleredirectstext' => 'بۇل بەتتە باسقا ايداتۋ بەتتەرگە سىلتەيتىن بەتتەر تىزىمدەلىنەدى. ٴاربىر جولاقتا ٴبىرىنشى جانە ەكىنشى ايداعىشقا سىلتەمەلەر بار, سونىمەن بىرگە ەكىنشى ايداعىش نىساناسى بار, ادەتتە بۇل ٴبىرىنشى ايداعىش باعىتتايتىن «ناقتى» نىسانا بەت اتاۋى بولۋى كەرەك.',
	'deadendpages' => 'ەش بەتكە سىلتەمەيتىن بەتتەر',
	'deadendpagestext' => 'كەلەسى بەتتەر {{SITENAME}} جوباسىنداعى باسقا بەتتەرگە سىلتەمەيدى.',
	'deletedcontributions' => 'قاتىسۋشىنىڭ جويىلعان ۇلەسى',
	'deletedcontributions-title' => 'قاتىسۋشىنىڭ جويىلعان ۇلەسى',
	'defemailsubject' => '{{SITENAME}} ە-پوشتاسىنىڭ حاتى',
	'deletepage' => 'بەتتى جويۋ',
	'delete-confirm' => '«$1» دەگەندى جويۋ',
	'delete-legend' => 'جويۋ',
	'deletedtext' => '«$1» جويىلدى.
جۋىقتاعى جويۋلار تۋرالى جازبالارىن $2 دەگەننەن قاراڭىز.',
	'dellogpage' => 'جويۋ_جۋرنالى',
	'dellogpagetext' => 'تومەندە جۋىقتاعى جويۋلاردىڭ ٴتىزىمى بەرىلگەن.',
	'deletionlog' => 'جويۋ جۋرنالى',
	'deletecomment' => 'سەبەبى:',
	'deleteotherreason' => 'باسقا/قوسىمشا سەبەپ:',
	'deletereasonotherlist' => 'باسقا سەبەپ',
	'deletereason-dropdown' => '* جويۋدىڭ جالپى سەبەپتەرى
** اۋتوردىڭ سۇرانىمى بويىنشا
** اۋتورلىق قۇقىقتارىن بۇزۋ
** بۇزاقىلىق',
	'delete-edit-reasonlist' => 'جويۋ سەبەپتەرىن وڭدەۋ',
	'delete-toobig' => 'بۇل بەتتە بايتاق تۇزەتۋ تارىيحى بار, $1 تۇزەتۋدەن استام.
بۇنداي بەتتەردىڭ جويۋى {{SITENAME}} تورابىن الدەقالاي ٴۇزىپ تاستاۋىنا بوگەت سالۋ ٴۇشىن تىيىمدالعان.',
	'delete-warning-toobig' => 'بۇل بەتتە بايتاق تۇزەتۋ تارىيحى بار, $1 تۇزەتۋدەن استام.
بۇنىڭ جويۋى {{SITENAME}} تورابىنداعى دەرەكقور ارەكەتتەردى ٴۇزىپ تاستاۋىن مۇمكىن;
بۇنى ابايلاپ وتكىزىڭىز.',
	'databasenotlocked' => 'دەرەكقور قۇلىپتالعان جوق.',
	'delete_and_move' => 'جويۋ جانە جىلجىتۋ',
	'delete_and_move_text' => '==جويۋ كەرەك==
«[[:$1]]» دەگەن نىسانا بەت الداقاشان بار.
جىلجىتۋعا جول بەرۋ ٴۇشىن بۇنى جوياسىز با?',
	'delete_and_move_confirm' => 'ٴىيا, بۇل بەتتى جوي',
	'delete_and_move_reason' => 'جىلجىتۋعا جول بەرۋ ٴۇشىن جويىلعان',
	'djvu_page_error' => 'DjVu بەتى اۋماق سىرتىنددا',
	'djvu_no_xml' => 'DjVu فايلى ٴۇشىن XML كەلتىرۋى ىيكەمدى ەمەس',
	'deletedrevision' => 'ەسكى تۇزەتۋىن جويدى: $1',
	'deletedwhileediting' => 'قۇلاقتاندىرۋ: بۇل بەتتى وڭدەۋىڭىزدى باستاعاندا, وسى بەت جويىلدى!',
	'descending_abbrev' => 'كەمۋ',
);

$messages['kk-cn'] = array(
	'december' => 'جەلتوقسان',
	'december-gen' => 'جەلتوقساننىڭ',
	'dec' => 'جەل',
	'delete' => 'جويۋ',
	'deletethispage' => 'بەتتى جويۋ',
	'disclaimers' => 'جاۋاپكەرشىلىكتەن باس تارتۋ',
	'disclaimerpage' => 'Project:جاۋاپكەرشىلىكتەن باس تارتۋ',
	'databaseerror' => 'دەرەكقور قاتەسى',
	'dberrortext' => 'دەرەكقور سۇرانىمىندا سويلەم جۇيەسىنىڭ قاتەسى بولدى.
بۇل باعدارلامالىق جاساقتاما قاتەسىن بەلگىلەۋى مۇمكىن.
سوڭعى بولعان دەرەكقور سۇرانىمى:
<blockquote><tt>$1</tt></blockquote>
مىنا جەتەدەن «<tt>$2</tt>».
MySQL قايتارعان قاتەسى «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'دەرەكقور سۇرانىمىندا سويلەم جۇيەسىنىڭ قاتەسى بولدى.
سوڭعى بولعان دەرەكقور سۇرانىمى:
«$1»
مىنا جەتەدەن: «$2».
MySQL قايتارعان قاتەسى «$3: $4»',
	'directorycreateerror' => '«$1» قالتاسى قۇرىلمادى.',
	'deletedhist' => 'جويىلعان تارىيحى',
	'difference' => '(تۇزەتۋلەر اراسىنداعى ايىرماشىلىق)',
	'diff-multi' => '(اراداعى $1 تۇزەتۋ كورسەتىلمەگەن.)',
	'datedefault' => 'ەش قالاۋسىز',
	'defaultns' => 'مىنا ەسىم ايالاردا ادەپكىدەن ىزدەۋ:',
	'default' => 'ادەپكى',
	'diff' => 'ايىرم.',
	'destfilename' => 'نىسانا فايل اتاۋى:',
	'duplicatesoffile' => 'كەلەسى {{PLURAL:$1|فايل بۇل فايلدىڭ تەلنۇسقاسى|$1 فايل بۇل فايلدىڭ تەلنۇسقالارى}}:',
	'download' => 'قوتارىپ الۋ',
	'disambiguations' => 'ايرىقتى بەتتەر',
	'disambiguationspage' => '{{ns:template}}:ايرىق',
	'disambiguations-text' => "كەلەسى بەتتەر '''ايرىقتى بەتكە''' سىلتەيدى.
بۇنىڭ ورنىنا بەلگىلى تاقىرىپقا سىلتەۋى كەرەك.<br />
ەگەر [[MediaWiki:Disambiguationspage]] تىزىمىندەگى ۇلگى قولدانىلسا, بەت ايرىقتى دەپ سانالادى.",
	'doubleredirects' => 'شىنجىرلى ايداعىشتار',
	'doubleredirectstext' => 'بۇل بەتتە باسقا ايداتۋ بەتتەرگە سىلتەيتىن بەتتەر تىزىمدەلىنەدى. ٴاربىر جولاقتا ٴبىرىنشى جانە ەكىنشى ايداعىشقا سىلتەمەلەر بار, سونىمەن بىرگە ەكىنشى ايداعىش نىساناسى بار, ادەتتە بۇل ٴبىرىنشى ايداعىش باعىتتايتىن «ناقتى» نىسانا بەت اتاۋى بولۋى كەرەك.',
	'deadendpages' => 'ەش بەتكە سىلتەمەيتىن بەتتەر',
	'deadendpagestext' => 'كەلەسى بەتتەر {{SITENAME}} جوباسىنداعى باسقا بەتتەرگە سىلتەمەيدى.',
	'deletedcontributions' => 'قاتىسۋشىنىڭ جويىلعان ۇلەسى',
	'deletedcontributions-title' => 'قاتىسۋشىنىڭ جويىلعان ۇلەسى',
	'defemailsubject' => '{{SITENAME}} ە-پوشتاسىنىڭ حاتى',
	'deletepage' => 'بەتتى جويۋ',
	'delete-confirm' => '«$1» دەگەندى جويۋ',
	'delete-legend' => 'جويۋ',
	'deletedtext' => '«$1» جويىلدى.
جۋىقتاعى جويۋلار تۋرالى جازبالارىن $2 دەگەننەن قاراڭىز.',
	'dellogpage' => 'جويۋ_جۋرنالى',
	'dellogpagetext' => 'تومەندە جۋىقتاعى جويۋلاردىڭ ٴتىزىمى بەرىلگەن.',
	'deletionlog' => 'جويۋ جۋرنالى',
	'deletecomment' => 'سەبەبى:',
	'deleteotherreason' => 'باسقا/قوسىمشا سەبەپ:',
	'deletereasonotherlist' => 'باسقا سەبەپ',
	'deletereason-dropdown' => '* جويۋدىڭ جالپى سەبەپتەرى
** اۋتوردىڭ سۇرانىمى بويىنشا
** اۋتورلىق قۇقىقتارىن بۇزۋ
** بۇزاقىلىق',
	'delete-edit-reasonlist' => 'جويۋ سەبەپتەرىن وڭدەۋ',
	'delete-toobig' => 'بۇل بەتتە بايتاق تۇزەتۋ تارىيحى بار, $1 تۇزەتۋدەن استام.
بۇنداي بەتتەردىڭ جويۋى {{SITENAME}} تورابىن الدەقالاي ٴۇزىپ تاستاۋىنا بوگەت سالۋ ٴۇشىن تىيىمدالعان.',
	'delete-warning-toobig' => 'بۇل بەتتە بايتاق تۇزەتۋ تارىيحى بار, $1 تۇزەتۋدەن استام.
بۇنىڭ جويۋى {{SITENAME}} تورابىنداعى دەرەكقور ارەكەتتەردى ٴۇزىپ تاستاۋىن مۇمكىن;
بۇنى ابايلاپ وتكىزىڭىز.',
	'databasenotlocked' => 'دەرەكقور قۇلىپتالعان جوق.',
	'delete_and_move' => 'جويۋ جانە جىلجىتۋ',
	'delete_and_move_text' => '==جويۋ كەرەك==
«[[:$1]]» دەگەن نىسانا بەت الداقاشان بار.
جىلجىتۋعا جول بەرۋ ٴۇشىن بۇنى جوياسىز با?',
	'delete_and_move_confirm' => 'ٴىيا, بۇل بەتتى جوي',
	'delete_and_move_reason' => 'جىلجىتۋعا جول بەرۋ ٴۇشىن جويىلعان',
	'djvu_page_error' => 'DjVu بەتى اۋماق سىرتىنددا',
	'djvu_no_xml' => 'DjVu فايلى ٴۇشىن XML كەلتىرۋى ىيكەمدى ەمەس',
	'deletedrevision' => 'ەسكى تۇزەتۋىن جويدى: $1',
	'deletedwhileediting' => 'قۇلاقتاندىرۋ: بۇل بەتتى وڭدەۋىڭىزدى باستاعاندا, وسى بەت جويىلدى!',
	'descending_abbrev' => 'كەمۋ',
);

$messages['kk-cyrl'] = array(
	'december' => 'желтоқсан',
	'december-gen' => 'желтоқсанның',
	'dec' => 'жел',
	'delete' => 'Жою',
	'deletethispage' => 'Бетті жою',
	'disclaimers' => 'Жауапкершіліктен бас тарту',
	'disclaimerpage' => 'Project:Жауапкершіліктен бас тарту',
	'databaseerror' => 'Дерекқор қатесі',
	'dberrortext' => 'Дерекқорға жасалған сұраныста синтаксистік қате табылды.
Бұл бағдарламада қате бар екенін көрсетуі мүмкін.
Дерекқорға түскен соңғы сұраным:
 «<tt>$2</tt>» фунциясынан <blockquote><tt>$1</tt></blockquote> шыққан.
Дерекқор  «<tt>$3: $4</tt>» қателігін қайтарды.',
	'dberrortextcl' => 'Дерекқорға жасалған сұранымда синтаксистік қате табылды.
Дерекқорға түскен соңғы сұраным:
«$1»
мына «$2» функциясынан болды .
Дерекқор "$3: $4" қатесін қайтарды.',
	'directorycreateerror' => '«$1» қалтасы құрылмады.',
	'deletedhist' => 'Жойылған тарихы',
	'difference' => '(Түзетулер арасындағы айырмашылық)',
	'diff-multi' => '(Арадағы $1 түзету көрсетілмеген.)',
	'datedefault' => 'Еш қалаусыз',
	'defaultns' => 'Мына есім аяларда әдепкіден іздеу:',
	'default' => 'әдепкі',
	'diff' => 'айырм.',
	'destfilename' => 'Нысана файл атауы:',
	'duplicatesoffile' => 'Келесі {{PLURAL:$1|файл бұл файлдың телнұсқасы|$1 файл бұл файлдың телнұсқалары}}:',
	'download' => 'қотарып алу',
	'disambiguations' => 'Айрықты беттер',
	'disambiguationspage' => '{{ns:template}}:Айрық',
	'disambiguations-text' => "Келесі беттер '''айрықты бетке''' сілтейді.
Бұның орнына белгілі тақырыпқа сілтеуі керек.<br />
Егер [[MediaWiki:Disambiguationspage]] тізіміндегі үлгі қолданылса, бет айрықты деп саналады.",
	'doubleredirects' => 'Екі мәрте айдағыштар',
	'doubleredirectstext' => 'Бұл бетте басқа айдату беттерге сілтейтін беттер тізімделінеді. Әрбір жолақта бірінші және екінші айдағышқа сілтемелер бар, сонымен бірге екінші айдағыш нысанасы бар, әдетте бұл бірінші айдағыш бағыттайтын «нақты» нысана бет атауы болуы керек.',
	'deadendpages' => 'Еш бетке сілтемейтін беттер',
	'deadendpagestext' => 'Келесі беттер {{SITENAME}} жобасындағы басқа беттерге сілтемейді.',
	'deletedcontributions' => 'Қатысушының жойылған үлесі',
	'deletedcontributions-title' => 'Қатысушының жойылған үлесі',
	'defemailsubject' => '{{SITENAME}} е-поштасының хаты',
	'deletepage' => 'Бетті жою',
	'delete-confirm' => '«$1» дегенді жою',
	'delete-legend' => 'Жою',
	'deletedtext' => '«$1» жойылды.
Жуықтағы жоюлар туралы жазбаларын $2 дегеннен қараңыз.',
	'dellogpage' => 'Жою_журналы',
	'dellogpagetext' => 'Төменде жуықтағы жоюлардың тізімі берілген.',
	'deletionlog' => 'жою журналы',
	'deletecomment' => 'Себебі:',
	'deleteotherreason' => 'Басқа/қосымша себеп:',
	'deletereasonotherlist' => 'Басқа себеп',
	'deletereason-dropdown' => '* Жоюдың жалпы себептері
** Автордың сұранымы бойынша
** Авторлық құқықтарын бұзу
** Вандализм',
	'delete-edit-reasonlist' => 'Жою себептерін өңдеу',
	'delete-toobig' => 'Бұл бетте байтақ түзету тарихы бар, $1 түзетуден астам.
Бұндай беттердің жоюы {{SITENAME}} торабын әлдеқалай үзіп тастауына бөгет салу үшін тиымдалған.',
	'delete-warning-toobig' => 'Бұл бетте байтақ түзету тарихы бар, $1 түзетуден астам.
Бұның жоюы {{SITENAME}} торабындағы дерекқор әрекеттерді үзіп тастауын мүмкін;
бұны абайлап өткізіңіз.',
	'databasenotlocked' => 'Дерекқор құлыпталған жоқ.',
	'delete_and_move' => 'Жою және жылжыту',
	'delete_and_move_text' => '==Жою керек==
«[[:$1]]» деген нысана бет алдақашан бар.
Жылжытуға жол беру үшін бұны жоясыз ба?',
	'delete_and_move_confirm' => 'Иә, бұл бетті жой',
	'delete_and_move_reason' => 'Жылжытуға жол беру үшін жойылған',
	'djvu_page_error' => 'DjVu беті аумақ сыртындда',
	'djvu_no_xml' => 'DjVu файлы үшін XML келтіруі икемді емес',
	'deletedrevision' => 'Ескі түзетуін жойды: $1',
	'deletedwhileediting' => 'Құлақтандыру: Бұл бетті өңдеуіңізді бастағанда, осы бет жойылды!',
	'descending_abbrev' => 'кему',
);

$messages['kk-kz'] = array(
	'december' => 'желтоқсан',
	'december-gen' => 'желтоқсанның',
	'dec' => 'жел',
	'delete' => 'Жою',
	'deletethispage' => 'Бетті жою',
	'disclaimers' => 'Жауапкершіліктен бас тарту',
	'disclaimerpage' => 'Project:Жауапкершіліктен бас тарту',
	'databaseerror' => 'Дерекқор қатесі',
	'dberrortext' => 'Дерекқорға жасалған сұраныста синтаксистік қате табылды.
Бұл бағдарламада қате бар екенін көрсетуі мүмкін.
Дерекқорға түскен соңғы сұраным:
 «<tt>$2</tt>» фунциясынан <blockquote><tt>$1</tt></blockquote> шыққан.
Дерекқор  «<tt>$3: $4</tt>» қателігін қайтарды.',
	'dberrortextcl' => 'Дерекқорға жасалған сұранымда синтаксистік қате табылды.
Дерекқорға түскен соңғы сұраным:
«$1»
мына «$2» функциясынан болды .
Дерекқор "$3: $4" қатесін қайтарды.',
	'directorycreateerror' => '«$1» қалтасы құрылмады.',
	'deletedhist' => 'Жойылған тарихы',
	'difference' => '(Түзетулер арасындағы айырмашылық)',
	'diff-multi' => '(Арадағы $1 түзету көрсетілмеген.)',
	'datedefault' => 'Еш қалаусыз',
	'defaultns' => 'Мына есім аяларда әдепкіден іздеу:',
	'default' => 'әдепкі',
	'diff' => 'айырм.',
	'destfilename' => 'Нысана файл атауы:',
	'duplicatesoffile' => 'Келесі {{PLURAL:$1|файл бұл файлдың телнұсқасы|$1 файл бұл файлдың телнұсқалары}}:',
	'download' => 'қотарып алу',
	'disambiguations' => 'Айрықты беттер',
	'disambiguationspage' => '{{ns:template}}:Айрық',
	'disambiguations-text' => "Келесі беттер '''айрықты бетке''' сілтейді.
Бұның орнына белгілі тақырыпқа сілтеуі керек.<br />
Егер [[MediaWiki:Disambiguationspage]] тізіміндегі үлгі қолданылса, бет айрықты деп саналады.",
	'doubleredirects' => 'Екі мәрте айдағыштар',
	'doubleredirectstext' => 'Бұл бетте басқа айдату беттерге сілтейтін беттер тізімделінеді. Әрбір жолақта бірінші және екінші айдағышқа сілтемелер бар, сонымен бірге екінші айдағыш нысанасы бар, әдетте бұл бірінші айдағыш бағыттайтын «нақты» нысана бет атауы болуы керек.',
	'deadendpages' => 'Еш бетке сілтемейтін беттер',
	'deadendpagestext' => 'Келесі беттер {{SITENAME}} жобасындағы басқа беттерге сілтемейді.',
	'deletedcontributions' => 'Қатысушының жойылған үлесі',
	'deletedcontributions-title' => 'Қатысушының жойылған үлесі',
	'defemailsubject' => '{{SITENAME}} е-поштасының хаты',
	'deletepage' => 'Бетті жою',
	'delete-confirm' => '«$1» дегенді жою',
	'delete-legend' => 'Жою',
	'deletedtext' => '«$1» жойылды.
Жуықтағы жоюлар туралы жазбаларын $2 дегеннен қараңыз.',
	'dellogpage' => 'Жою_журналы',
	'dellogpagetext' => 'Төменде жуықтағы жоюлардың тізімі берілген.',
	'deletionlog' => 'жою журналы',
	'deletecomment' => 'Себебі:',
	'deleteotherreason' => 'Басқа/қосымша себеп:',
	'deletereasonotherlist' => 'Басқа себеп',
	'deletereason-dropdown' => '* Жоюдың жалпы себептері
** Автордың сұранымы бойынша
** Авторлық құқықтарын бұзу
** Вандализм',
	'delete-edit-reasonlist' => 'Жою себептерін өңдеу',
	'delete-toobig' => 'Бұл бетте байтақ түзету тарихы бар, $1 түзетуден астам.
Бұндай беттердің жоюы {{SITENAME}} торабын әлдеқалай үзіп тастауына бөгет салу үшін тиымдалған.',
	'delete-warning-toobig' => 'Бұл бетте байтақ түзету тарихы бар, $1 түзетуден астам.
Бұның жоюы {{SITENAME}} торабындағы дерекқор әрекеттерді үзіп тастауын мүмкін;
бұны абайлап өткізіңіз.',
	'databasenotlocked' => 'Дерекқор құлыпталған жоқ.',
	'delete_and_move' => 'Жою және жылжыту',
	'delete_and_move_text' => '==Жою керек==
«[[:$1]]» деген нысана бет алдақашан бар.
Жылжытуға жол беру үшін бұны жоясыз ба?',
	'delete_and_move_confirm' => 'Иә, бұл бетті жой',
	'delete_and_move_reason' => 'Жылжытуға жол беру үшін жойылған',
	'djvu_page_error' => 'DjVu беті аумақ сыртындда',
	'djvu_no_xml' => 'DjVu файлы үшін XML келтіруі икемді емес',
	'deletedrevision' => 'Ескі түзетуін жойды: $1',
	'deletedwhileediting' => 'Құлақтандыру: Бұл бетті өңдеуіңізді бастағанда, осы бет жойылды!',
	'descending_abbrev' => 'кему',
);

$messages['kk-latn'] = array(
	'december' => 'jeltoqsan',
	'december-gen' => 'jeltoqsannıñ',
	'dec' => 'jel',
	'delete' => 'Joyw',
	'deletethispage' => 'Betti joyw',
	'disclaimers' => 'Jawapkerşilikten bas tartw',
	'disclaimerpage' => 'Project:Jawapkerşilikten bas tartw',
	'databaseerror' => 'Derekqor qatesi',
	'dberrortext' => 'Derekqor suranımında söýlem jüýesiniñ qatesi boldı.
Bul bağdarlamalıq jasaqtama qatesin belgilewi mümkin.
Soñğı bolğan derekqor suranımı:
<blockquote><tt>$1</tt></blockquote>
mına jeteden «<tt>$2</tt>».
MySQL qaýtarğan qatesi «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'Derekqor suranımında söýlem jüýesiniñ qatesi boldı.
Soñğı bolğan derekqor suranımı:
«$1»
mına jeteden: «$2».
MySQL qaýtarğan qatesi «$3: $4»',
	'directorycreateerror' => '«$1» qaltası qurılmadı.',
	'deletedhist' => 'Joýılğan tarïxı',
	'difference' => '(Tüzetwler arasındağı aýırmaşılıq)',
	'diff-multi' => '(Aradağı $1 tüzetw körsetilmegen.)',
	'datedefault' => 'Eş qalawsız',
	'defaultns' => 'Mına esim ayalarda ädepkiden izdew:',
	'default' => 'ädepki',
	'diff' => 'aýırm.',
	'destfilename' => 'Nısana faýl atawı:',
	'duplicatesoffile' => 'Kelesi {{PLURAL:$1|faýl bul faýldıñ telnusqası|$1 faýl bul faýldıñ telnusqaları}}:',
	'download' => 'qotarıp alw',
	'disambiguations' => 'Aýrıqtı better',
	'disambiguationspage' => '{{ns:template}}:Aýrıq',
	'disambiguations-text' => "Kelesi better '''aýrıqtı betke''' silteýdi.
Bunıñ ornına belgili taqırıpqa siltewi kerek.<br />
Eger [[{{ns:mediawiki}}:Disambiguationspage]] tizimindegi ülgi qoldanılsa, bet aýrıqtı dep sanaladı.",
	'doubleredirects' => 'Şınjırlı aýdağıştar',
	'doubleredirectstext' => 'Bul bette basqa aýdatw betterge silteýtin better tizimdelinedi. Ärbir jolaqta birinşi jäne ekinşi aýdağışqa siltemeler bar, sonımen birge ekinşi aýdağış nısanası bar, ädette bul birinşi aýdağış bağıttaýtın «naqtı» nısana bet atawı bolwı kerek.',
	'deadendpages' => 'Eş betke siltemeýtin better',
	'deadendpagestext' => 'Kelesi better {{SITENAME}} jobasındağı basqa betterge siltemeýdi.',
	'deletedcontributions' => 'Qatıswşınıñ joýılğan ülesi',
	'deletedcontributions-title' => 'Qatıswşınıñ joýılğan ülesi',
	'defemailsubject' => '{{SITENAME}} e-poştasınıñ xatı',
	'deletepage' => 'Betti joyw',
	'delete-confirm' => '«$1» degendi joyw',
	'delete-legend' => 'Joyw',
	'deletedtext' => '«$1» joýıldı.
Jwıqtağı joywlar twralı jazbaların $2 degennen qarañız.',
	'dellogpage' => 'Joyw_jwrnalı',
	'dellogpagetext' => 'Tömende jwıqtağı joywlardıñ tizimi berilgen.',
	'deletionlog' => 'joyw jwrnalı',
	'deletecomment' => 'Sebebi:',
	'deleteotherreason' => 'Basqa/qosımşa sebep:',
	'deletereasonotherlist' => 'Basqa sebep',
	'deletereason-dropdown' => '* Joywdıñ jalpı sebepteri
** Awtordıñ suranımı boýınşa
** Awtorlıq quqıqtarın buzw
** Buzaqılıq',
	'delete-edit-reasonlist' => 'Joyw sebepterin öñdew',
	'delete-toobig' => 'Bul bette baýtaq tüzetw tarïxı bar, $1 tüzetwden astam.
Bundaý betterdiñ joywı {{SITENAME}} torabın äldeqalaý üzip tastawına böget salw üşin tïımdalğan.',
	'delete-warning-toobig' => 'Bul bette baýtaq tüzetw tarïxı bar, $1 tüzetwden astam.
Bunıñ joywı {{SITENAME}} torabındağı derekqor äreketterdi üzip tastawın mümkin;
bunı abaýlap ötkiziñiz.',
	'databasenotlocked' => 'Derekqor qulıptalğan joq.',
	'delete_and_move' => 'Joyw jäne jıljıtw',
	'delete_and_move_text' => '==Joyw kerek==
«[[:$1]]» degen nısana bet aldaqaşan bar.
Jıljıtwğa jol berw üşin bunı joyasız ba?',
	'delete_and_move_confirm' => 'Ïä, bul betti joý',
	'delete_and_move_reason' => 'Jıljıtwğa jol berw üşin joýılğan',
	'djvu_page_error' => 'DjVu beti awmaq sırtındda',
	'djvu_no_xml' => 'DjVu faýlı üşin XML keltirwi ïkemdi emes',
	'deletedrevision' => 'Eski tüzetwin joýdı: $1',
	'deletedwhileediting' => 'Qulaqtandırw: Bul betti öñdewiñizdi bastağanda, osı bet joýıldı!',
	'descending_abbrev' => 'kemw',
);

$messages['kk-tr'] = array(
	'december' => 'jeltoqsan',
	'december-gen' => 'jeltoqsannıñ',
	'dec' => 'jel',
	'delete' => 'Joyw',
	'deletethispage' => 'Betti joyw',
	'disclaimers' => 'Jawapkerşilikten bas tartw',
	'disclaimerpage' => 'Project:Jawapkerşilikten bas tartw',
	'databaseerror' => 'Derekqor qatesi',
	'dberrortext' => 'Derekqor suranımında söýlem jüýesiniñ qatesi boldı.
Bul bağdarlamalıq jasaqtama qatesin belgilewi mümkin.
Soñğı bolğan derekqor suranımı:
<blockquote><tt>$1</tt></blockquote>
mına jeteden «<tt>$2</tt>».
MySQL qaýtarğan qatesi «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'Derekqor suranımında söýlem jüýesiniñ qatesi boldı.
Soñğı bolğan derekqor suranımı:
«$1»
mına jeteden: «$2».
MySQL qaýtarğan qatesi «$3: $4»',
	'directorycreateerror' => '«$1» qaltası qurılmadı.',
	'deletedhist' => 'Joýılğan tarïxı',
	'difference' => '(Tüzetwler arasındağı aýırmaşılıq)',
	'diff-multi' => '(Aradağı $1 tüzetw körsetilmegen.)',
	'datedefault' => 'Eş qalawsız',
	'defaultns' => 'Mına esim ayalarda ädepkiden izdew:',
	'default' => 'ädepki',
	'diff' => 'aýırm.',
	'destfilename' => 'Nısana faýl atawı:',
	'duplicatesoffile' => 'Kelesi {{PLURAL:$1|faýl bul faýldıñ telnusqası|$1 faýl bul faýldıñ telnusqaları}}:',
	'download' => 'qotarıp alw',
	'disambiguations' => 'Aýrıqtı better',
	'disambiguationspage' => '{{ns:template}}:Aýrıq',
	'disambiguations-text' => "Kelesi better '''aýrıqtı betke''' silteýdi.
Bunıñ ornına belgili taqırıpqa siltewi kerek.<br />
Eger [[{{ns:mediawiki}}:Disambiguationspage]] tizimindegi ülgi qoldanılsa, bet aýrıqtı dep sanaladı.",
	'doubleredirects' => 'Şınjırlı aýdağıştar',
	'doubleredirectstext' => 'Bul bette basqa aýdatw betterge silteýtin better tizimdelinedi. Ärbir jolaqta birinşi jäne ekinşi aýdağışqa siltemeler bar, sonımen birge ekinşi aýdağış nısanası bar, ädette bul birinşi aýdağış bağıttaýtın «naqtı» nısana bet atawı bolwı kerek.',
	'deadendpages' => 'Eş betke siltemeýtin better',
	'deadendpagestext' => 'Kelesi better {{SITENAME}} jobasındağı basqa betterge siltemeýdi.',
	'deletedcontributions' => 'Qatıswşınıñ joýılğan ülesi',
	'deletedcontributions-title' => 'Qatıswşınıñ joýılğan ülesi',
	'defemailsubject' => '{{SITENAME}} e-poştasınıñ xatı',
	'deletepage' => 'Betti joyw',
	'delete-confirm' => '«$1» degendi joyw',
	'delete-legend' => 'Joyw',
	'deletedtext' => '«$1» joýıldı.
Jwıqtağı joywlar twralı jazbaların $2 degennen qarañız.',
	'dellogpage' => 'Joyw_jwrnalı',
	'dellogpagetext' => 'Tömende jwıqtağı joywlardıñ tizimi berilgen.',
	'deletionlog' => 'joyw jwrnalı',
	'deletecomment' => 'Sebebi:',
	'deleteotherreason' => 'Basqa/qosımşa sebep:',
	'deletereasonotherlist' => 'Basqa sebep',
	'deletereason-dropdown' => '* Joywdıñ jalpı sebepteri
** Awtordıñ suranımı boýınşa
** Awtorlıq quqıqtarın buzw
** Buzaqılıq',
	'delete-edit-reasonlist' => 'Joyw sebepterin öñdew',
	'delete-toobig' => 'Bul bette baýtaq tüzetw tarïxı bar, $1 tüzetwden astam.
Bundaý betterdiñ joywı {{SITENAME}} torabın äldeqalaý üzip tastawına böget salw üşin tïımdalğan.',
	'delete-warning-toobig' => 'Bul bette baýtaq tüzetw tarïxı bar, $1 tüzetwden astam.
Bunıñ joywı {{SITENAME}} torabındağı derekqor äreketterdi üzip tastawın mümkin;
bunı abaýlap ötkiziñiz.',
	'databasenotlocked' => 'Derekqor qulıptalğan joq.',
	'delete_and_move' => 'Joyw jäne jıljıtw',
	'delete_and_move_text' => '==Joyw kerek==
«[[:$1]]» degen nısana bet aldaqaşan bar.
Jıljıtwğa jol berw üşin bunı joyasız ba?',
	'delete_and_move_confirm' => 'Ïä, bul betti joý',
	'delete_and_move_reason' => 'Jıljıtwğa jol berw üşin joýılğan',
	'djvu_page_error' => 'DjVu beti awmaq sırtındda',
	'djvu_no_xml' => 'DjVu faýlı üşin XML keltirwi ïkemdi emes',
	'deletedrevision' => 'Eski tüzetwin joýdı: $1',
	'deletedwhileediting' => 'Qulaqtandırw: Bul betti öñdewiñizdi bastağanda, osı bet joýıldı!',
	'descending_abbrev' => 'kemw',
);

$messages['kl'] = array(
	'december' => 'Decemberi',
	'december-gen' => 'Decembari',
	'dec' => 'Dec',
	'delete' => 'Peeruk',
	'deletethispage' => 'Qupperneq piiaruk',
	'disclaimers' => 'Aalajangersagaq',
	'diff' => 'assigiinng',
	'delete-confirm' => 'Peeruk "$1"',
	'deletedtext' => '"$1" peerpoq. Takukkit $2 peerneqarsimasut kingulliit.',
);

$messages['km'] = array(
	'december' => 'ខែធ្នូ',
	'december-gen' => 'ខែធ្នូ',
	'dec' => 'ធ្នូ',
	'delete' => 'លុបចោល',
	'deletethispage' => 'លុបទំព័រនេះចោល',
	'disclaimers' => 'ការបដិសេធ',
	'disclaimerpage' => 'Project:ការបដិសេធ​ទូទៅ',
	'databaseerror' => 'មូលដ្ឋានទិន្នន័យមានបញ្ហា',
	'directorycreateerror' => 'មិនអាចបង្កើតថត"$1"បានទេ។',
	'deletedhist' => 'ប្រវត្តិដែលត្រូវបានលុប',
	'difference-multipage' => '(ភាពខុសគ្នារវាងទំព័រនានា)',
	'diff-multi' => '({{PLURAL:$1|កំណែប្រែកម្រិតបង្គួរមួយ|កំណែប្រែកម្រិតបង្គួរចំនួន $1}}មិនត្រូវបានបង្ហាញ)',
	'datedefault' => 'គ្មានចំណូលចិត្ត',
	'defaultns' => 'ស្វែងរក​ក្នុង​លំហឈ្មោះ​ទាំងនេះ​តាម​បែប​ផ្សេង៖',
	'default' => 'លំនាំដើម',
	'diff' => 'ប្រៀបធៀប',
	'destfilename' => 'ឈ្មោះឯកសារគោលដៅ៖',
	'duplicatesoffile' => '{{PLURAL:$1|file is a duplicate|$1 ឯកសារ​ជាច្បាប់ចម្លង}}ដូចតទៅ​នៃ​ឯកសារ​នេះ​ ([[Special:FileDuplicateSearch/$2|ព័ត៌មាន​លំអិត]])​៖',
	'download' => 'ទាញយក',
	'disambiguations' => 'ទំព័រដែលភ្ជាប់ទៅទំព័រមានចំណងជើងស្រដៀងគ្នា',
	'disambiguationspage' => 'Template:ស្រដៀងគ្នា',
	'disambiguations-text' => "ទំព័រទាំងឡាយខាងក្រោមនេះភ្ជាប់ទៅកាន់'''ទំព័រពាក្យស្រដៀងគ្នា'''។

ទំព័រទាំងនេះគួរតែភ្ជាប់ទៅប្រធានបទត្រឹមត្រូវតែម្ដង។<br />
ទំព័រមួយត្រូវចាត់ទុកជាទំព័រពាក្យស្រដៀងគ្នា ប្រសិនបើវាប្រើទំព័រគំរូដែលភ្ជាប់មកពី[[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'ទំព័របញ្ជូនបន្តទ្វេដង',
	'doubleredirectstext' => 'ទំព័រនេះរាយឈ្មោះទំព័រដែលបញ្ជូនបន្តទៅទំព័របញ្ជូនបន្ដផ្សេងទៀត។

ជួរនីមួយៗមានតំនភ្ជាប់ទៅកាន់ទំព័របញ្ជូនបន្តទី១និងទី២ ព្រមជាមួយទំព័រគោលដៅរបស់ទំព័របញ្ជូនបន្តទី២(ដែលជាធម្មតានេះក៏ជាទំព័រគោលដៅ"ពិត"របស់ទំព័របញ្ជូនបន្តទី១ដែរ)។',
	'double-redirect-fixed-move' => '[[$1]] ត្រូវបានដកចេញ។

វាត្រូវបានបញ្ជូនបន្តទៅ [[$2]]',
	'double-redirect-fixed-maintenance' => 'កំពុងជួសជុលការបញ្ជូនបន្តផ្ទួនគ្នាពី [[$1]] ទៅ [[$2]] ។',
	'double-redirect-fixer' => 'អ្នកជួសជុលការបញ្ជូនបន្ត',
	'deadendpages' => 'ទំព័រ​ទាល់',
	'deadendpagestext' => 'ទំព័រដូចតទៅនេះមិនតភ្ជាប់ទៅទំព័រដទៃទៀតក្នុង {{SITENAME}} ទេ។',
	'deletedcontributions' => 'ការរួមចំណែកដែលត្រូវបានលុបចោល',
	'deletedcontributions-title' => 'ការរួមចំណែកដែលត្រូវបានលុបចោល',
	'defemailsubject' => 'អ៊ីមែល{{SITENAME}}ពី "$1"',
	'deletepage' => 'លុបទំព័រចោល',
	'delete-confirm' => 'លុប"$1"ចោល',
	'delete-legend' => 'លុបចោល',
	'deletedtext' => '"$1"ត្រូវបានលុបចោលរួចហើយ។

សូមមើល$2សំរាប់បញ្ជីនៃការលុបចោលនាពេលថ្មីៗ។',
	'dellogpage' => 'កំណត់ហេតុនៃការលុបចោល',
	'dellogpagetext' => 'ខាងក្រោមជាបញ្ជីនៃការលុបចោលថ្មីៗបំផុត។',
	'deletionlog' => 'កំណត់ហេតុនៃការលុបចោល',
	'deletecomment' => 'មូលហេតុ៖',
	'deleteotherreason' => 'មូលហេតុបន្ថែមផ្សេងទៀត៖',
	'deletereasonotherlist' => 'មូលហេតុផ្សេងទៀត',
	'deletereason-dropdown' => '*ហេតុផលទូទៅ
** សំណើរបស់អ្នកនិពន្ធ
** បំពានកម្មសិទ្ធិបញ្ញា
** អំពើបំផ្លាញទ្រព្យសម្បត្តិឯកជនឬសាធារណៈ',
	'delete-edit-reasonlist' => 'ពិនិត្យផ្ទៀងផ្ទាត់ហេតុផលនៃការលុប',
	'delete-toobig' => 'ទំព័រនេះមានប្រវត្តិកែប្រែធំលើសពី $1 {{PLURAL:$1|កំណែ|កំណែ}}។

ការលុបទំព័របែបនេះចោលត្រូវបានហាមឃាត់ ដើម្បីបង្ការកុំអោយមានការរអាក់រអួលក្នុង{{SITENAME}}។',
	'delete-warning-toobig' => 'ទំព័រនេះមានប្រវត្តិកែប្រែធំលើសពី $1 {{PLURAL:$1|កំណែ|កំណែ}}។

ការលុបទំព័របែបនេះចោលអាចធ្វើអោយមានការរអាក់រអួលប្រតិបត្តិការរបស់មូលដ្ឋានទិន្នន័យក្នុង{{SITENAME}}។

សូមបន្តសកម្មភាពនេះដោយប្រុងប្រយ័ត្ន។',
	'databasenotlocked' => 'មូលដ្ឋានទិន្នន័យ មិនត្រូវបានចាក់សោ។',
	'delete_and_move' => 'លុបនិងប្តូរទីតាំង',
	'delete_and_move_text' => '==ការលុបជាចាំបាច់==
"[[:$1]]"ដែលជាទីតាំងទំព័រត្រូវបញ្ជូនទៅ មានរួចជាស្រេចហើយ។
តើអ្នកចង់លុបវាដើម្បីជាវិធីសម្រាប់ប្តូរទីតាំងទេ?',
	'delete_and_move_confirm' => 'យល់ព្រម​លុប​ទំព័រ​នេះ',
	'delete_and_move_reason' => 'ត្រូវបានលុបដើម្បីផ្លាស់ប្តូរទីតាំងពី "[[$1]]"',
	'djvu_page_error' => 'ទំព័រ DjVu ក្រៅដែនកំណត់',
	'djvu_no_xml' => 'មិនអាចនាំយក XML សម្រាប់ឯកសារ DjVu',
	'deletedrevision' => 'កំណែចាស់ដែលត្រូវបានលុបចេញ $1',
	'days' => '{{PLURAL:$1|$1 ថ្ងៃ|$1 ថ្ងៃ}}',
	'deletedwhileediting' => "'''ប្រយ័ត្ន''' ៖ ទំព័រនេះបានត្រូវលុបចោល បន្ទាប់ពីអ្នកបានចាប់ផ្តើមកែប្រែ!",
	'descending_abbrev' => 'លំដាប់ចុះ',
	'dberr-header' => 'វិគីនេះមានបញ្ហា',
	'dberr-problems' => 'សូមអភ័យទោស! វិបសាយនេះកំពុងជួបបញ្ហាបច្ចេកទេស។',
	'dberr-again' => 'សូមរង់ចាំប៉ុន្មាននាទីសិនហើយផ្ទុកឡើងវិញម្ដងទៀត។',
	'dberr-info' => '(មិនអាចទាក់ទងទៅប្រភពទិន្នន័យរបស់ប្រព័ន្ធបំរើការបានទេ៖ $1)',
	'dberr-usegoogle' => 'អ្នកអាចសាកស្វែងរកតាមរយៈហ្គូហ្គល(Google)ជាបណ្ដោះអាសន្នសិន។',
	'dberr-outofdate' => 'សូមចំណាំ​​ថា​ លិបិក្រម​នៃ​មាតិការ​របស់យើងប្រហែលជាហួស​សម័យ​។​',
	'dberr-cachederror' => 'នេះ​គឺ​ជា​ច្បាប់​ចម្លង​ដែលបាន​ដាក់ទៅសតិភ្ជាប់នៃ​ទំព័រ​ដែលបានស្នើសុំ​ និងប្រហែលជាមិនទាន់សម័យ។',
);

$messages['kn'] = array(
	'december' => 'ಡಿಸೆಂಬರ್',
	'december-gen' => 'ಡಿಸೆಂಬರ್',
	'dec' => 'ಡಿಸೆಂಬರ್',
	'delete' => 'ಅಳಿಸಿ',
	'deletethispage' => 'ಈ ಪುಟವನ್ನು ಅಳಿಸಿ',
	'disclaimers' => 'ಅಬಾಧ್ಯತೆಗಳು',
	'disclaimerpage' => 'Project:ಸಾಮಾನ್ಯ ಅಬಾಧ್ಯತೆಗಳು',
	'databaseerror' => 'ಡೇಟಬೇಸ್ ದೋಷ',
	'dberrortext' => '!!FUZZY!ಒಂದು ಡೇಟಾಬೇಸ್ ನಿಮ್ಮಪ್ರಶ್ನೆಗೆ ಸಿಂಟಾಕ್ಸ್ ತಪ್ಪು ಸಂಭವಿಸಿದೆ
ಈ ಸಾಫ್ಟ್ವೇರ್ ಒಂದು ದೋಷವನ್ನು ನಿವಾರಿಸಲಾಗಿದೆ ಸೂಚಿಸಬಹುದು.
ಕೊನೆಯ ಪ್ರಯತ್ನ ಡೇಟಾಬೇಸ್ ನಿಮ್ಮಪ್ರಶ್ನೆಗೆ ಮಾಡಲಾಯಿತು:
<blockquote><tt>$1</tt></blockquote>
ಕ್ರಿಯೆ ಒಳಗಿನಿಂದಲೇ "<tt>$2</tt>"
ಡೇಟಾಬೇಸ್ ದೋಷವನ್ನು ತಿಳಿಸಿದೆ"<tt>$3: $4</tt>".',
	'dberrortextcl' => 'ಡೇಟಾಬೇಸ್ ಪ್ರಶ್ನೆಯ ವಿನ್ಯಾಸದಲ್ಲಿ ದೋಷ ಉಂಟಾಗಿದೆ.
ಕೊನೆಯದಾಗಿ ಪ್ರಯತ್ನಿಸಲಾದ ಡೇಟಾಬೇಸ್ ಪ್ರಶ್ನೆಯು:
"$1"
ಇದು ಉಂಟಾಗಿದ್ದು "$2" function ಒಳಗಿಂದ.
MySQL ಹಿಂದಿರುಗಿಸಿದ ದೋಷ "$3: $4"',
	'directorycreateerror' => '"$1" ನಿದರ್ಶಕವನ್ನು ಸೃಷ್ಟಿಸಲಾಗಲಿಲ್ಲ.',
	'deletedhist' => 'ಅಳಿಸಲ್ಪಟ್ಟ ಇತಿಹಾಸ',
	'difference' => '(ಆವೃತ್ತಿಗಳ ನಡುವಿನ ವ್ಯತ್ಯಾಸ)',
	'diff-multi' => '(ಮಧ್ಯದಲ್ಲಿ ಆಗಿರುವ {{PLURAL:$1|೧ ಬದಲಾವಣೆಯನ್ನು|$1 ಬದಲಾವಣೆಗಳನ್ನು}} ತೋರಿಸಲಾಗಿಲ್ಲ.)',
	'datedefault' => 'ಯಾವುದೇ ಪ್ರಾಶಸ್ತ್ಯ ಇಲ್ಲ',
	'defaultns' => 'ಮೂಲಸ್ಥಿತಿಯಲ್ಲಿ ಈ ಪುಟಪ್ರಬೇಧಗಳಲ್ಲಿ ಹುಡುಕಿ:',
	'default' => 'ಮೂಲಸ್ಥಿತಿ',
	'diff' => 'ವ್ಯತ್ಯಾಸ',
	'download' => 'ಡೌನ್‍ಲೋಡ್',
	'disambiguations' => 'ದ್ವಂದ್ವನಿವಾರಣಾ ಪುಟಗಳು',
	'disambiguationspage' => 'Template:ದ್ವಂದ್ವ ನಿವಾರಣೆ',
	'doubleredirects' => 'ಮರುಕಳಿಸಿದ ಪುನರ್ನಿರ್ದೇಶನಗಳು',
	'deadendpages' => 'ಕೊನೆಯಂಚಿನ ಪುಟಗಳು',
	'deadendpagestext' => 'ಈ ಕೆಳಗಿನ ಪುಟಗಳು {{SITENAME}} ಅಲ್ಲಿ ಇರುವ ಇತರ ಪುಟಗಳಿಗೆ ಕೊಂಡಿಯನ್ನು ಹೊಂದಿಲ್ಲ.',
	'defemailsubject' => 'ವಿಕಿಪೀಡಿಯ ವಿ-ಅ೦ಚೆ',
	'deletepage' => 'ಪುಟವನ್ನು ಅಳಿಸಿ',
	'delete-confirm' => '"$1" ಅಳಿಸುವಿಕೆ',
	'delete-legend' => 'ಅಳಿಸು',
	'deletedtext' => '"$1" ಅನ್ನು ಅಳಿಸಲಾಯಿತು.
ಇತ್ತೀಚೆಗಿನ ಅಳಿಸುವಿಕೆಗಳ ಪಟ್ಟಿಗಾಗಿ $2 ಅನ್ನು ನೋಡಿ.',
	'dellogpage' => 'ಅಳಿಸುವಿಕೆ ದಾಖಲೆ',
	'dellogpagetext' => 'ಇತ್ತೀಚಿನ ಅಳಿಸುವಿಕೆಗಳ ಪಟ್ಟಿ ಕೆಳಗಿದೆ.',
	'deletionlog' => 'ಅಳಿಸುವಿಕೆ ದಿನಚರಿ',
	'deletecomment' => 'ಕಾರಣ:',
	'deleteotherreason' => 'ಇತರ/ಹೆಚ್ಚುವರಿ ಕಾರಣ:',
	'deletereasonotherlist' => 'ಇತರ ಕಾರಣ',
	'deletereason-dropdown' => '*ಸಾಮಾನ್ಯ ಅಳಿಸುವಿಕೆಯ ಕಾರಣಗಳು
** ಸಂಪಾದಕರ ಕೋರಿಕೆ
** ಕೃತಿಸ್ವಾಮ್ಯತೆಯ ಉಲ್ಲಂಘನೆ
** Vandalism',
	'delete-edit-reasonlist' => 'ಅಳಿಸುವಿಕೆ ಕಾರಣಗಳನ್ನು ಸಂಪಾದಿಸು',
	'databasenotlocked' => 'ಈ ಡೇಟಬೇಸ್ ಮುಚ್ಚಲ್ಪಟ್ಟಿಲ್ಲ.',
	'delete_and_move' => 'ಅಳಿಸು ಮತ್ತು ಸ್ಥಳಾಂತರಿಸು',
	'delete_and_move_text' => '==ಅಳಿಸುವಿಕೆ ಬೇಕಾಗಿದೆ==
ಸ್ಥಳಾಂತರಿಬೇಕೆಂದಿರುವ ಪುಟ "[[:$1]]" ಆಗಲೆ ಅಸ್ಥಿತ್ವದಲ್ಲಿ ಇದೆ.
ಸ್ಥಳಾಂತರಿಕೆಗೆ ಜಾಗ ಮಾಡಲು ಆ ಪುಟವನ್ನು ಅಳಿಸಬೇಕೆ?',
	'delete_and_move_confirm' => 'ಹೌದು, ಪುಟವನ್ನು ಅಳಿಸಿ',
	'delete_and_move_reason' => 'ಸ್ಥಳಾಂತರಿಕೆಗೆ ಜಾಗ ಮಾಡಲು ಪುಟವನ್ನು ಅಳಿಸಲಾಯಿತು',
	'deletedrevision' => 'ಹಳೆ ಆವೃತ್ತಿ $1 ಅನ್ನು ಅಳಿಸಲಾಗಿದೆ',
	'deletedwhileediting' => "'''ಸೂಚನೆ''': ನೀವು ಸಂಪಾದನೆ ಪ್ರಾರಂಭಿಸಿದ ನಂತರ ಈ ಪುಟವನ್ನು ಅಳಿಸಲಾಗಿದೆ!",
	'descending_abbrev' => 'ಇಳಿ',
);

$messages['ko'] = array(
	'december' => '12월',
	'december-gen' => '12월',
	'dec' => '12',
	'delete' => '삭제',
	'deletethispage' => '이 문서 삭제하기',
	'disclaimers' => '면책 조항',
	'disclaimerpage' => 'Project:면책 조항',
	'databaseerror' => '데이터베이스 오류',
	'dberrortext' => '데이터베이스 쿼리 구문 오류가 발생했습니다.
소프트웨어의 버그가 있을 수 있습니다.
마지막으로 요청한 데이터베이스 쿼리는 "<tt>$2</tt>" 함수에서 쓰인
<blockquote><tt>$1</tt></blockquote>
입니다.
데이터베이스는 "<tt>$3: $4</tt>" 오류를 일으켰습니다.',
	'dberrortextcl' => '데이터베이스 쿼리 구문 오류가 발생했습니다.
마지막으로 요청한 데이터베이스 쿼리는 "$2" 함수에서 쓰인
"$1"
입니다.
데이터베이스는 "$3: $4" 오류를 일으켰습니다.',
	'directorycreateerror' => '‘$1’ 디렉토리를 만들 수 없습니다.',
	'deletedhist' => '삭제된 역사',
	'difference' => '(버전 사이의 차이)',
	'difference-multipage' => '(문서간의 차이)',
	'diff-multi' => '({{PLURAL:$2|한 사용자의|사용자 $2명의}} 중간의 편집 $1개 숨겨짐)',
	'diff-multi-manyusers' => '({{PLURAL:$2|한 사용자의|사용자 $2명 이상의}} 중간의 편집 $1개 숨겨짐)',
	'datedefault' => '기본값',
	'defaultns' => '다음 이름공간에서 검색하기:',
	'default' => '기본값',
	'diff' => '비교',
	'destfilename' => '파일의 새 이름:',
	'duplicatesoffile' => '다음 파일 $1개가 이 파일과 중복됩니다 ([[Special:FileDuplicateSearch/$2|자세한 정보]]):',
	'download' => '다운로드',
	'disambiguations' => '동음이의 문서를 가리키는 문서 목록',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => "다음의 문서들은 '''동음이의 문서'''를 가리키고 있습니다.
그 링크를 다른 적절한 문서로 연결해 주어야 합니다.<br />
[[MediaWiki:Disambiguationspage]]에서 링크된 틀을 사용하는 문서를 동음이의 문서로 간주합니다.",
	'doubleredirects' => '이중 넘겨주기 목록',
	'doubleredirectstext' => '이 문서는 다른 넘겨주기 문서로 넘겨주고 있는 문서의 목록입니다.
매 줄에는 첫 번째 문서와 두 번째 문서의 링크가 있습니다. 그리고 보통 첫 번째 문서가 넘겨주어야 할 "실제" 문서인 두 번째 넘겨주기의 대상이 있습니다.
<del>취소선이 그인</del> 부분은 이미 해결되었습니다.',
	'double-redirect-fixed-move' => '[[$1]] 문서를 옮겼습니다. 이 문서는 이제 [[$2]] 문서로 넘겨줍니다.',
	'double-redirect-fixed-maintenance' => '[[$1]]에서 [[$2]]로 이중 넘겨주기를 고치는 중',
	'double-redirect-fixer' => '넘겨주기 수리꾼',
	'deadendpages' => '막다른 문서 목록',
	'deadendpagestext' => '{{SITENAME}} 내의 다른 문서로 나가는 링크가 없는 문서의 목록입니다.',
	'deletedcontributions' => '삭제된 기여 목록',
	'deletedcontributions-title' => '삭제된 기여 목록',
	'defemailsubject' => '"$1" 사용자가 보낸 {{SITENAME}} 이메일',
	'deletepage' => '문서 삭제하기',
	'delete-confirm' => '‘$1’ 삭제',
	'delete-legend' => '삭제',
	'deletedtext' => '‘$1’ 문서를 삭제했습니다. 최근 삭제 기록은 $2에 있습니다.',
	'dellogpage' => '삭제 기록',
	'dellogpagetext' => '아래의 목록은 최근에 삭제된 문서들입니다.',
	'deletionlog' => '삭제 기록',
	'deletecomment' => '이유:',
	'deleteotherreason' => '다른 이유/추가적인 이유:',
	'deletereasonotherlist' => '다른 이유',
	'deletereason-dropdown' => '*일반적인 삭제 이유
** 작성자의 요청
** 저작권 침해
** 잘못된 문서',
	'delete-edit-reasonlist' => '삭제 이유 편집',
	'delete-toobig' => '이 문서에는 편집 역사가 $1개 있습니다. 편집 역사가 긴 문서를 삭제하면 {{SITENAME}}에 큰 혼란을 줄 수 있기 때문에 삭제할 수 없습니다.',
	'delete-warning-toobig' => '이 문서에는 편집 역사가 $1개 있습니다.
편집 역사가 긴 문서를 삭제하면 {{SITENAME}} 데이터베이스 동작에 큰 영향을 줄 수 있습니다.
주의해 주세요.',
	'databasenotlocked' => '데이터베이스가 잠겨 있지 않습니다.',
	'delete_and_move' => '삭제하고 이동',
	'delete_and_move_text' => '== 삭제 필요 ==

이동하려는 제목으로 된 ‘[[:$1]]’ 문서가 이미 존재합니다.
삭제하고 이동할까요?',
	'delete_and_move_confirm' => '네. 문서를 삭제합니다',
	'delete_and_move_reason' => '"[[$1]]"에서 문서를 이동하기 위해 삭제함',
	'djvu_page_error' => 'DjVu 페이지 범위 벗어남',
	'djvu_no_xml' => 'DjVu 파일의 XML 정보를 읽을 수 없음',
	'deletedrevision' => '예전 버전 $1이(가) 삭제되었습니다.',
	'days' => '$1일',
	'deletedwhileediting' => "'''주의''': 당신이 이 문서를 편집하던 중에 이 문서가 삭제되었습니다.",
	'descending_abbrev' => '내림차순',
	'duplicate-defaultsort' => '\'\'\'경고:\'\'\' 기본 정렬 키 "$2"가 이전의 기본 정렬 키 "$1"를 덮어쓰고 있습니다.',
	'dberr-header' => '이 위키에 문제가 있습니다.',
	'dberr-problems' => '죄송합니다. 이 사이트는 기술적인 문제가 있습니다.',
	'dberr-again' => '잠시 후에 다시 시도해주세요.',
	'dberr-info' => '(데이터베이스에 접속할 수 없습니다: $1)',
	'dberr-usegoogle' => '그 동안 구글을 통해 검색할 수도 있습니다.',
	'dberr-outofdate' => '참고로, 구글의 내용 개요는 오래된 것일 수도 있습니다.',
	'dberr-cachederror' => '다음은 요청한 문서의 캐시된 복사본이며, 최신이 아닐 수도 있습니다.',
);

$messages['ko-kp'] = array(
	'december' => '12월',
	'december-gen' => '12월',
	'dec' => '12',
	'delete' => '삭제',
	'deletethispage' => '이 문서 삭제하기',
	'disclaimers' => '면책 조항',
	'disclaimerpage' => 'Project:면책 조항',
	'databaseerror' => '데이터베이스 오류',
	'dberrortext' => '데이터베이스 쿼리 구문 오류가 발생했습니다.
소프트웨어의 버그가 있을 수 있습니다.
마지막으로 요청한 데이터베이스 쿼리는 "<tt>$2</tt>" 함수에서 쓰인
<blockquote><tt>$1</tt></blockquote>
입니다.
데이터베이스는 "<tt>$3: $4</tt>" 오류를 일으켰습니다.',
	'dberrortextcl' => '데이터베이스 쿼리 구문 오류가 발생했습니다.
마지막으로 요청한 데이터베이스 쿼리는 "$2" 함수에서 쓰인
"$1"
입니다.
데이터베이스는 "$3: $4" 오류를 일으켰습니다.',
	'directorycreateerror' => '‘$1’ 디렉토리를 만들 수 없습니다.',
	'deletedhist' => '삭제된 역사',
	'difference' => '(버전 사이의 차이)',
	'difference-multipage' => '(문서간의 차이)',
	'diff-multi' => '({{PLURAL:$2|한 사용자의|사용자 $2명의}} 중간의 편집 $1개 숨겨짐)',
	'diff-multi-manyusers' => '({{PLURAL:$2|한 사용자의|사용자 $2명 이상의}} 중간의 편집 $1개 숨겨짐)',
	'datedefault' => '기본값',
	'defaultns' => '다음 이름공간에서 검색하기:',
	'default' => '기본값',
	'diff' => '비교',
	'destfilename' => '파일의 새 이름:',
	'duplicatesoffile' => '다음 파일 $1개가 이 파일과 중복됩니다 ([[Special:FileDuplicateSearch/$2|자세한 정보]]):',
	'download' => '다운로드',
	'disambiguations' => '동음이의 문서를 가리키는 문서 목록',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => "다음의 문서들은 '''동음이의 문서'''를 가리키고 있습니다.
그 링크를 다른 적절한 문서로 연결해 주어야 합니다.<br />
[[MediaWiki:Disambiguationspage]]에서 링크된 틀을 사용하는 문서를 동음이의 문서로 간주합니다.",
	'doubleredirects' => '이중 넘겨주기 목록',
	'doubleredirectstext' => '이 문서는 다른 넘겨주기 문서로 넘겨주고 있는 문서의 목록입니다.
매 줄에는 첫 번째 문서와 두 번째 문서의 링크가 있습니다. 그리고 보통 첫 번째 문서가 넘겨주어야 할 "실제" 문서인 두 번째 넘겨주기의 대상이 있습니다.
<del>취소선이 그인</del> 부분은 이미 해결되었습니다.',
	'double-redirect-fixed-move' => '[[$1]] 문서를 옮겼습니다. 이 문서는 이제 [[$2]] 문서로 넘겨줍니다.',
	'double-redirect-fixed-maintenance' => '[[$1]]에서 [[$2]]로 이중 넘겨주기를 고치는 중',
	'double-redirect-fixer' => '넘겨주기 수리꾼',
	'deadendpages' => '막다른 문서 목록',
	'deadendpagestext' => '{{SITENAME}} 내의 다른 문서로 나가는 링크가 없는 문서의 목록입니다.',
	'deletedcontributions' => '삭제된 기여 목록',
	'deletedcontributions-title' => '삭제된 기여 목록',
	'defemailsubject' => '"$1" 사용자가 보낸 {{SITENAME}} 이메일',
	'deletepage' => '문서 삭제하기',
	'delete-confirm' => '‘$1’ 삭제',
	'delete-legend' => '삭제',
	'deletedtext' => '‘$1’ 문서를 삭제했습니다. 최근 삭제 기록은 $2에 있습니다.',
	'dellogpage' => '삭제 기록',
	'dellogpagetext' => '아래의 목록은 최근에 삭제된 문서들입니다.',
	'deletionlog' => '삭제 기록',
	'deletecomment' => '이유:',
	'deleteotherreason' => '다른 이유/추가적인 이유:',
	'deletereasonotherlist' => '다른 이유',
	'deletereason-dropdown' => '*일반적인 삭제 이유
** 작성자의 요청
** 저작권 침해
** 잘못된 문서',
	'delete-edit-reasonlist' => '삭제 이유 편집',
	'delete-toobig' => '이 문서에는 편집 역사가 $1개 있습니다. 편집 역사가 긴 문서를 삭제하면 {{SITENAME}}에 큰 혼란을 줄 수 있기 때문에 삭제할 수 없습니다.',
	'delete-warning-toobig' => '이 문서에는 편집 역사가 $1개 있습니다.
편집 역사가 긴 문서를 삭제하면 {{SITENAME}} 데이터베이스 동작에 큰 영향을 줄 수 있습니다.
주의해 주세요.',
	'databasenotlocked' => '데이터베이스가 잠겨 있지 않습니다.',
	'delete_and_move' => '삭제하고 이동',
	'delete_and_move_text' => '== 삭제 필요 ==

이동하려는 제목으로 된 ‘[[:$1]]’ 문서가 이미 존재합니다.
삭제하고 이동할까요?',
	'delete_and_move_confirm' => '네. 문서를 삭제합니다',
	'delete_and_move_reason' => '"[[$1]]"에서 문서를 이동하기 위해 삭제함',
	'djvu_page_error' => 'DjVu 페이지 범위 벗어남',
	'djvu_no_xml' => 'DjVu 파일의 XML 정보를 읽을 수 없음',
	'deletedrevision' => '예전 버전 $1이(가) 삭제되었습니다.',
	'days' => '$1일',
	'deletedwhileediting' => "'''주의''': 당신이 이 문서를 편집하던 중에 이 문서가 삭제되었습니다.",
	'descending_abbrev' => '내림차순',
	'duplicate-defaultsort' => '\'\'\'경고:\'\'\' 기본 정렬 키 "$2"가 이전의 기본 정렬 키 "$1"를 덮어쓰고 있습니다.',
	'dberr-header' => '이 위키에 문제가 있습니다.',
	'dberr-problems' => '죄송합니다. 이 사이트는 기술적인 문제가 있습니다.',
	'dberr-again' => '잠시 후에 다시 시도해주세요.',
	'dberr-info' => '(데이터베이스에 접속할 수 없습니다: $1)',
	'dberr-usegoogle' => '그 동안 구글을 통해 검색할 수도 있습니다.',
	'dberr-outofdate' => '참고로, 구글의 내용 개요는 오래된 것일 수도 있습니다.',
	'dberr-cachederror' => '다음은 요청한 문서의 캐시된 복사본이며, 최신이 아닐 수도 있습니다.',
);

$messages['koi'] = array(
	'december' => 'Декаб',
	'december-gen' => 'декаб',
	'dec' => 'дек',
	'delete' => 'Чышкыны',
	'deletethispage' => 'Чышкыны этiйö листбоксö',
	'disclaimers' => 'Мийö сöстöмöсь йöз одзын',
	'disclaimerpage' => 'Project:Мийö сöстöмöсь йöз одзын',
	'difference' => '(Неöткодьыс версияэз коласын)',
	'difference-multipage' => 'Неöткодьыс листбоккез коласын',
	'diff' => 'неöтк.',
	'deletepage' => 'Чышкыны листбок',
	'delete-confirm' => 'Чышкыны "$1"',
	'delete-legend' => 'Чышкыны',
	'deletedtext' => '«$1» чышкöм. Видзöт $2-ись медбöрья чышкöммесö.',
	'dellogpage' => 'Шупкан чукöр',
	'deletecomment' => 'Мыля:',
	'deleteotherreason' => 'Эшö мыля чышкöм:',
	'deletereasonotherlist' => 'Эшö мыля',
);

$messages['krc'] = array(
	'december' => 'декабрь',
	'december-gen' => 'декабрь',
	'dec' => 'дек',
	'delete' => 'Кетер',
	'deletethispage' => 'Бу бетни кетер',
	'disclaimers' => 'Джууаблылыкъны унамау',
	'disclaimerpage' => 'Project:Джууаблылыкъны унамау',
	'databaseerror' => 'Информация базада халат',
	'dberrortext' => 'Информация базагъа джиберилген сорууда синтаксис халат табылды.
Программада халатны ачыкъларгъа да боллукъду ол.
Информация базагъа ахыр соруу:
<blockquote><tt>$1</tt></blockquote>
<tt>«$2»</tt>функциясындан болгъанды.
База <tt>«$3: $4»</tt> халатны къайтарды.',
	'dberrortextcl' => 'Информация базагъа джиберилген сорууда синтаксис халат табылды.
Информация базагъа ахыр соруу:
«$1»
«$2» функциясындан болгъанды.
База «$3: $4»  халатны къайтарды.',
	'directorycreateerror' => '«$1» директория къураргъа болмайды.',
	'deletedhist' => 'Кетериулени тарихи',
	'difference' => '(Версияланы араларында башхалыкъ)',
	'difference-multipage' => '(Бетле арасында башхалыкъ)',
	'diff-multi' => '({{PLURAL:$2|Бир къошулуучу|$2 къошулуучу}} этген {{PLURAL:$1|$1 аралыкъ тюрлениу|$1 аралыкъ тюрлениу}} кёргюзюлмегенди)',
	'diff-multi-manyusers' => '($2 къошулуучудан кёб {{PLURAL:$2|Бир къошулуучу|къошулуучу}} этген {{PLURAL:$1|бир аралыкъ тюрлениу|$1 аралыкъ тюрлениу}} кёргюзюлмегенди)',
	'datedefault' => 'Сайлау джокъду',
	'defaultns' => 'Башха халда бу атла аламлада изле:',
	'default' => 'тынгылау бла',
	'diff' => 'башх.',
	'destfilename' => 'Файлны джангы аты:',
	'duplicatesoffile' => '{{PLURAL:$1|файл|$1 файл}}, бу файлны дубликатыды ([[Special:FileDuplicateSearch/$2|анданда кёб ангылатыу]]):',
	'download' => 'джюкле',
	'disambiguations' => 'Кёб магъаналы ангыламланы бетлери',
	'disambiguationspage' => 'Template:кёб магъаналылыкъ',
	'disambiguations-text' => "Бу бетле '''кёб магъаналы бетлеге''' джибериу этедиле. Аны орнуна ала белгили бир статьягъа джибериу этерге керек болурла.<br />
[[MediaWiki:Disambiguationspage]] бетде аты салынган шаблон бетде болса, ол бет кёб магъаналы бетге саналады.",
	'doubleredirects' => 'Джибериу болгъан джибериуле',
	'doubleredirectstext' => 'Бу бетде башхы джибериулеге этилген джибериулени списогу барды.
Хар тизгин биринчи неда экинчи джибериуню эмда асламысында бетни аты джазылгъан, биринчи джибериу кёргюзген, экинчи джибериуню нюзюр бети джазылады.
<del>Юсю сызылгъан</del> джазыула тюзетилген этгендиле.',
	'double-redirect-fixed-move' => '[[$1]] бет атын тюрлендиргенди, энди ол [[$2]] бетге джибериу этеди',
	'double-redirect-fixer' => 'Джибериулени тюзетиучю',
	'deadendpages' => 'Тупик бетле',
	'deadendpagestext' => 'Бу бетле,{{SITENAME}} сайтда башха бетлеге джибериу бермейдиле.',
	'deletedcontributions' => 'Кетерилген къошулуучуну къошхан юлюшю',
	'deletedcontributions-title' => 'Кетерилген къошулучуну къошхан юлюшю',
	'defemailsubject' => '{{SITENAME}} письмо',
	'deletepage' => 'Бетни кетер',
	'delete-confirm' => '«$1» — кетериу',
	'delete-legend' => 'Кетер',
	'deletedtext' => '«$1» бет кетерилди.
Ахыр кетерилгенлени списогун кёрюр ючюн, $2на къарагъыз.',
	'dellogpage' => 'Кетерилгенлени журналы',
	'dellogpagetext' => 'Тюбюндеги список ахыр кетериулени журналыды.',
	'deletionlog' => 'кетериулени журналы',
	'deletecomment' => 'Чурум:',
	'deleteotherreason' => 'башха чурум / дагъыда:',
	'deletereasonotherlist' => 'Башха чурум',
	'deletereason-dropdown' => '* Кетериуню баш чурумлары
** Авторну тилеги
** Автор хакъланы бузуу
** Вандализм',
	'delete-edit-reasonlist' => 'Чурумланы списогут тюрлендир',
	'delete-toobig' => 'Бу бетни, $1 {{PLURAL:$1|версияла|версияла}} бла бек узун тарихи барды.
Быллай бетлени кетерилиую, {{SITENAME}} сайтны бузмаз ючюн чекленгенди.',
	'delete-warning-toobig' => 'Бу бетни уллу тюрлендириу тарихи барды, $1 {{PLURAL:$1|версиядан|версиядан}} артыкъ.
Буну кетериу {{SITENAME}} ишлеулени асхатыргъа боллукъду;
эсгере андан ары ишлегиз.',
	'databasenotlocked' => 'Билги база киритли тюлдю.',
	'delete_and_move' => 'Кетер эмда атын тюрлендир',
	'delete_and_move_text' => '== Кетериу керекди ==
"[[:$1]]" атлы бет алайсызда джокъду. О бетни кетериб, атны тюрлендириуню андан ары бардырыргъа излеймисиз?',
	'delete_and_move_confirm' => 'Хоу, бетни кетер',
	'delete_and_move_reason' => 'Ат тюрлендирир ючюн кетерилди.',
	'djvu_page_error' => 'DjVu бетге джетилелмез',
	'djvu_no_xml' => 'DjVu файл ючюн XML алыналмайды',
	'deletedrevision' => '$1 эски версия кетерилгенди.',
	'deletedwhileediting' => "'''Эсериу''': Бу бет сиз тюрлендириб башлагъандан сора кетерилгенди!",
	'descending_abbrev' => 'азалгъан',
	'duplicate-defaultsort' => '\'\'\'Эсгериу:\'\'\' Бар саналгъан "$2" сыныфлама ачхыч, аллындагъы "$1" сыныфлама ачхычны джараусуз этеди.',
	'dberr-header' => 'Бу викини проблемасы барды',
	'dberr-problems' => 'Кечериксиз! Бу сайтда техника джаны бла проблемала чыкъгъандыла.',
	'dberr-again' => 'Талай минутну сакълаб, джангыдан кириб кёрюгюз.',
	'dberr-info' => '(билги базаны сервери бла байлам къурулалмайды: $1)',
	'dberr-usegoogle' => 'Google сайтны болушлугъу бла излеб кёрюрге боллукъсуз.',
	'dberr-outofdate' => 'Аны индекси эски болургъа боллугъун унутмагъыз.',
	'dberr-cachederror' => 'Тюбюндеги бет, изленнген бетни кэш этилген версиясыды, эмда ахыр тюрлендириулени кёргюзмезге болур.',
);

$messages['kri'] = array(
	'december' => 'Disemba',
	'december-gen' => 'Disemba',
	'dec' => 'Dis',
	'delete' => 'Dilit',
	'deletethispage' => 'Dilit dis pej-ya',
	'disclaimers' => 'Disklema-dem',
	'disclaimerpage' => 'Project:Jeneral disklema',
	'diff-multi' => '({{PLURAL:$1|Wan intamidyet vazhon|$1 intamidyet vazhon-dem}} no de sho)',
	'diff' => 'dif',
	'deletepage' => 'Dilit dis pej-ya',
	'delete-legend' => 'Dilit',
	'dellogpage' => 'Dilishon Log',
);

$messages['krj'] = array(
	'december' => 'Disyembre',
	'december-gen' => 'Disyembre',
	'dec' => 'Dis',
	'delete' => 'Para',
	'deletethispage' => 'Paraun ang dya nga Pahina',
	'disclaimers' => 'Mga Panginwala',
	'disclaimerpage' => 'Project:Panginwala nga Pangtanan',
	'databaseerror' => 'Sayup sa database',
	'directorycreateerror' => "Indi mahimo ang ''directory'' nga \"\$1\".",
	'delete-legend' => 'Para',
);

$messages['ks'] = array(
	'december' => 'ڈیٚسَمبَر',
);

$messages['ks-arab'] = array(
	'december' => 'ڈیٚسَمبَر',
);

$messages['ksh'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezember',
	'dec' => 'Dez',
	'delete' => 'Fottschmieße',
	'deletethispage' => 'De Sigg fottschmieße',
	'disclaimers' => 'Hinwies',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Fähler en de Daatebank',
	'dberrortext' => 'Enne Fääler es opjefalle en dä Süntax vun ennem Befääl för de Datebank.
Dat künnd_enne Fääler em Wikki-Projamm sin.
De läzde Date_Bank_Befääl eß jewääse:
<blockquote><code>$1</code></blockquote>
uß dä Funkzjohn: „<code>$2</code>“.
De Datebank mälldt dä Fääler: „<code>$3: $4</code>“.',
	'dberrortextcl' => 'En dä Syntax vun enem Befähl för de Daatebank es
ene Fähler es opjefalle.
Dä letzte Befähl för de Daatebank es jewäse:
<blockquote><code>$1</code></blockquote>
un kohm us däm Projramm singe Funktion: „<code>$2</code>“.
De Datebank meld dä Fähler: „<code>$3: $4</code>“.',
	'directorycreateerror' => 'Dat Verzeichnis „$1“ kunnte mer nit aanläje.',
	'deletedhist' => 'Fottjeschmesse Versione',
	'difference' => '(Ungerscheid zwesche de Versione)',
	'difference-multipage' => '(Ongerscheide zwesche Sigge)',
	'diff-multi' => '(Mer don hee {{PLURAL:$1|eij Version|$1 Versione|keij Version}} dozwesche beim Verjliesche översprenge. Di sin vun jesamp {{PLURAL:$2|einem Metmaacher|$2 Metmaachere|keinem Metmaacher}} jemaat woode)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Ein Version|$1 Versione|kei Version}} dozwesche vun mieh wi {{PLURAL:$2|einem Metmaacher|$2 Metmaachere|keinem Metmaacher}} wääde nit jezeish)',
	'datedefault' => 'Ejaal - kein Vörliebe',
	'defaultns' => 'Söns don en hee dä Appachtemengs söhke:',
	'default' => 'Standaad',
	'diff' => 'Ungerscheid',
	'destfilename' => 'Unger däm Dateiname avspeichere:',
	'duplicatesoffile' => 'Mer hann_er {{PLURAL:$1|en dubbelte Datei|$1 dubbelte Dateie|kei dubbelte Dateije}} fon he dä Datei, di {{PLURAL:$1|hät|han all|han}} dersellve Enhalldt ([[Special:FileDuplicateSearch/$2|mieh Einzelheite]]):',
	'download' => 'eronger laade',
	'disambiguations' => 'Sigge met Lengks dren op „(Wat ėß dat?)“-Sigge',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => 'En de Sigge hee noh sin Links dren, di op en „(Watt ėßß datt?)“-Sigg jonn.
Esu en Links sollte eijentlesch op en Sigg jon, di tirek jemeint es.

Ene Atikel jelld als en „(Watt ėßß datt?)“-Sigg, wann en dä Sigg [[MediaWiki:Disambiguationspage]] ene Link op en drop dren es. Alles wat keij Atikele sin, weed dobei jaa nit eez metjezallt.',
	'doubleredirects' => 'Ömleitunge op Ömleitunge',
	'doubleredirectstext' => 'Hee fings De en jede Reih ene Link op de iertste un de zweite Ömleitung, donoh ene Link op de Sigg, wo de
zweite Ömleitung hin jeiht. För jewöhnlich es dat dann och de richtije Sigg, wo de iertste Ömleitung ald hen jonn sullt.
<del>Ußjeshtreshe</del> Reije sin ald äleedesh.
Met däm „(Ändere)“-Link kanns De de eetste Sigg tirek aanpacke.
Tipp: Merk Der dä Tittel vun dä Sigg dovör.',
	'double-redirect-fixed-move' => 'dubbel Ömleidung nohm Ömnenne automattesch opjelös: [[$1]] → [[$2]]',
	'double-redirect-fixed-maintenance' => 'De dubbelte Ömleidung vun [[$1]] noh [[$2]] wood opjelühß.',
	'double-redirect-fixer' => '(Opjaveleß)',
	'deadendpages' => 'Atikele ohne Links dren',
	'deadendpagestext' => 'De Atikele hee han kein Links op ander Atikele em Wiki.',
	'deletedcontributions' => 'Fottjeschmesse Versione',
	'deletedcontributions-title' => 'Fottjeschmesse Versione',
	'defemailsubject' => 'e-mail fum $1 {{GRAMMAR:fun|{{SITENAME}}}}.',
	'deletepage' => 'Schmieß die Sigg jetz fott',
	'delete-confirm' => '„$1“ fottschmieße',
	'delete-legend' => 'Fottschmieße',
	'deletedtext' => 'De Sigg „$1“ es jetz fottjeschmesse woode. Luur Der „$2“ aan, do häs De en Liss met de Neuste fottjeschmesse Sigge.',
	'dellogpage' => 'Logboch met de fottjeschmesse Sigge',
	'dellogpagetext' => 'Hee sin de Sigge oppjeliss, die et neus fottjeschmesse woodte.',
	'deletionlog' => 'Dat Logboch fum Sigge-Fottschmieße',
	'deletecomment' => 'Aanlaß odder Jrund:',
	'deleteotherreason' => 'Ander Jrund oder Zosätzlich:',
	'deletereasonotherlist' => 'Ander Jrund',
	'deletereason-dropdown' => '* Alljemein Jrönde
** dä Schriever wollt et esu
** wohr jäje et Urhävverrääsch
** et wohd jet kapott jemaat',
	'delete-edit-reasonlist' => 'De Jrönde för et Fottschmieße beärbeide',
	'delete-toobig' => 'Di Sigg hät {{PLURAL:$1|ein Version|$1 Versione|jaa kein Version}}. Dat sinn_er ärsch fill. Domet unsere ẞööver do nit draan en de Kneen jeit, dom_mer esu en Sigg nit fottschmieße.',
	'delete-warning-toobig' => 'Di Sigg hät {{PLURAL:$1|ein Version|$1 Versione|jakein Version}}. Dat sinn_er ärsch fill. Wann De die all fottschmieße wells, dat kann dem Wiki sing Datenbangk schwer ußbremse.',
	'databasenotlocked' => '<strong>Opjepass:</strong> De Daatebank es <strong>nit</strong> jesperrt.',
	'delete_and_move' => 'Fottschmieße un Ömnenne',
	'delete_and_move_text' => '== Dä! Dubbelte Name ==
Di Sigg „[[:$1]]“ jitt et ald. Wollts De se fottschmieße, öm heh di Sigg ömnenne ze künne?',
	'delete_and_move_confirm' => 'Jo, dun di Sigg fottschmieße.',
	'delete_and_move_reason' => 'Fottjeschmesse, öm de Sigg [[$1]] ömnenne ze künne.',
	'djvu_page_error' => 'De DjVu-Sgg es ußerhallef',
	'djvu_no_xml' => 'De XML-Date för di DjVu-Datei kunnte mer nit afrofe',
	'deletedrevision' => 'De ahl Version „$1“ es fottjeschmesse',
	'days' => '{{PLURAL:$1|einem Daach|$1 Dääsch|keinem Daach}}',
	'deletedwhileediting' => '<strong>Opjepass:</strong> De Sigg wood fottjeschmesse, nohdäm Do ald aanjefange häs, dran ze Ändere.
Em <span class="plainlinks">[{{fullurl:Special:Log|type=delete&page=}}{{FULLPAGENAMEE}} Logboch vum Sigge-Fottschmieße]</span> künnt der Jrund shtonn.
Wann De de Sigg avspeichere deis, weed se widder aanjelaat.',
	'descending_abbrev' => 'raffkaz zoteet',
	'duplicate-defaultsort' => "'''Opjepaß:'''
Dä Shtanndat-Zoot-Schlößel „$1“ övverschriif dä älldere Zoot-Schlößel „$2“.",
	'dberr-header' => 'Dat Wiki heh häd en Schwierischkeit',
	'dberr-problems' => 'Deit uns leid, die Sigg heh häd för der Momang e teschnisch Problem.',
	'dberr-again' => 'Versök eijfach en e paa Menutte, norr_ens die Sigg afzeroofe.',
	'dberr-info' => '(Mer han kei Verbindung noh_m Datebank-ẞööver krijje künne: $1)',
	'dberr-usegoogle' => 'De künnß zweschedorsch ad met <i lang="en">Google</i> söke.',
	'dberr-outofdate' => 'Müjjelesch, dat dat Verzeichnes vun uns Sigge do nit janß om neuste Shtannd es.',
	'dberr-cachederror' => 'Wat heh noh kütt es en Kopi vum Zwescheshpeisher vun dä Sigg,
die De häs han welle. Se künnt jet ällder un nit mieh aktoäll sin.',
);

$messages['ku'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezember',
	'dec' => 'Dez',
	'delete' => 'Fottschmieße',
	'deletethispage' => 'De Sigg fottschmieße',
	'disclaimers' => 'Hinwies',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Fähler en de Daatebank',
	'dberrortext' => 'Enne Fääler es opjefalle en dä Süntax vun ennem Befääl för de Datebank.
Dat künnd_enne Fääler em Wikki-Projamm sin.
De läzde Date_Bank_Befääl eß jewääse:
<blockquote><code>$1</code></blockquote>
uß dä Funkzjohn: „<code>$2</code>“.
De Datebank mälldt dä Fääler: „<code>$3: $4</code>“.',
	'dberrortextcl' => 'En dä Syntax vun enem Befähl för de Daatebank es
ene Fähler es opjefalle.
Dä letzte Befähl för de Daatebank es jewäse:
<blockquote><code>$1</code></blockquote>
un kohm us däm Projramm singe Funktion: „<code>$2</code>“.
De Datebank meld dä Fähler: „<code>$3: $4</code>“.',
	'directorycreateerror' => 'Dat Verzeichnis „$1“ kunnte mer nit aanläje.',
	'deletedhist' => 'Fottjeschmesse Versione',
	'difference' => '(Ungerscheid zwesche de Versione)',
	'difference-multipage' => '(Ongerscheide zwesche Sigge)',
	'diff-multi' => '(Mer don hee {{PLURAL:$1|eij Version|$1 Versione|keij Version}} dozwesche beim Verjliesche översprenge. Di sin vun jesamp {{PLURAL:$2|einem Metmaacher|$2 Metmaachere|keinem Metmaacher}} jemaat woode)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Ein Version|$1 Versione|kei Version}} dozwesche vun mieh wi {{PLURAL:$2|einem Metmaacher|$2 Metmaachere|keinem Metmaacher}} wääde nit jezeish)',
	'datedefault' => 'Ejaal - kein Vörliebe',
	'defaultns' => 'Söns don en hee dä Appachtemengs söhke:',
	'default' => 'Standaad',
	'diff' => 'Ungerscheid',
	'destfilename' => 'Unger däm Dateiname avspeichere:',
	'duplicatesoffile' => 'Mer hann_er {{PLURAL:$1|en dubbelte Datei|$1 dubbelte Dateie|kei dubbelte Dateije}} fon he dä Datei, di {{PLURAL:$1|hät|han all|han}} dersellve Enhalldt ([[Special:FileDuplicateSearch/$2|mieh Einzelheite]]):',
	'download' => 'eronger laade',
	'disambiguations' => 'Sigge met Lengks dren op „(Wat ėß dat?)“-Sigge',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => 'En de Sigge hee noh sin Links dren, di op en „(Watt ėßß datt?)“-Sigg jonn.
Esu en Links sollte eijentlesch op en Sigg jon, di tirek jemeint es.

Ene Atikel jelld als en „(Watt ėßß datt?)“-Sigg, wann en dä Sigg [[MediaWiki:Disambiguationspage]] ene Link op en drop dren es. Alles wat keij Atikele sin, weed dobei jaa nit eez metjezallt.',
	'doubleredirects' => 'Ömleitunge op Ömleitunge',
	'doubleredirectstext' => 'Hee fings De en jede Reih ene Link op de iertste un de zweite Ömleitung, donoh ene Link op de Sigg, wo de
zweite Ömleitung hin jeiht. För jewöhnlich es dat dann och de richtije Sigg, wo de iertste Ömleitung ald hen jonn sullt.
<del>Ußjeshtreshe</del> Reije sin ald äleedesh.
Met däm „(Ändere)“-Link kanns De de eetste Sigg tirek aanpacke.
Tipp: Merk Der dä Tittel vun dä Sigg dovör.',
	'double-redirect-fixed-move' => 'dubbel Ömleidung nohm Ömnenne automattesch opjelös: [[$1]] → [[$2]]',
	'double-redirect-fixed-maintenance' => 'De dubbelte Ömleidung vun [[$1]] noh [[$2]] wood opjelühß.',
	'double-redirect-fixer' => '(Opjaveleß)',
	'deadendpages' => 'Atikele ohne Links dren',
	'deadendpagestext' => 'De Atikele hee han kein Links op ander Atikele em Wiki.',
	'deletedcontributions' => 'Fottjeschmesse Versione',
	'deletedcontributions-title' => 'Fottjeschmesse Versione',
	'defemailsubject' => 'e-mail fum $1 {{GRAMMAR:fun|{{SITENAME}}}}.',
	'deletepage' => 'Schmieß die Sigg jetz fott',
	'delete-confirm' => '„$1“ fottschmieße',
	'delete-legend' => 'Fottschmieße',
	'deletedtext' => 'De Sigg „$1“ es jetz fottjeschmesse woode. Luur Der „$2“ aan, do häs De en Liss met de Neuste fottjeschmesse Sigge.',
	'dellogpage' => 'Logboch met de fottjeschmesse Sigge',
	'dellogpagetext' => 'Hee sin de Sigge oppjeliss, die et neus fottjeschmesse woodte.',
	'deletionlog' => 'Dat Logboch fum Sigge-Fottschmieße',
	'deletecomment' => 'Aanlaß odder Jrund:',
	'deleteotherreason' => 'Ander Jrund oder Zosätzlich:',
	'deletereasonotherlist' => 'Ander Jrund',
	'deletereason-dropdown' => '* Alljemein Jrönde
** dä Schriever wollt et esu
** wohr jäje et Urhävverrääsch
** et wohd jet kapott jemaat',
	'delete-edit-reasonlist' => 'De Jrönde för et Fottschmieße beärbeide',
	'delete-toobig' => 'Di Sigg hät {{PLURAL:$1|ein Version|$1 Versione|jaa kein Version}}. Dat sinn_er ärsch fill. Domet unsere ẞööver do nit draan en de Kneen jeit, dom_mer esu en Sigg nit fottschmieße.',
	'delete-warning-toobig' => 'Di Sigg hät {{PLURAL:$1|ein Version|$1 Versione|jakein Version}}. Dat sinn_er ärsch fill. Wann De die all fottschmieße wells, dat kann dem Wiki sing Datenbangk schwer ußbremse.',
	'databasenotlocked' => '<strong>Opjepass:</strong> De Daatebank es <strong>nit</strong> jesperrt.',
	'delete_and_move' => 'Fottschmieße un Ömnenne',
	'delete_and_move_text' => '== Dä! Dubbelte Name ==
Di Sigg „[[:$1]]“ jitt et ald. Wollts De se fottschmieße, öm heh di Sigg ömnenne ze künne?',
	'delete_and_move_confirm' => 'Jo, dun di Sigg fottschmieße.',
	'delete_and_move_reason' => 'Fottjeschmesse, öm de Sigg [[$1]] ömnenne ze künne.',
	'djvu_page_error' => 'De DjVu-Sgg es ußerhallef',
	'djvu_no_xml' => 'De XML-Date för di DjVu-Datei kunnte mer nit afrofe',
	'deletedrevision' => 'De ahl Version „$1“ es fottjeschmesse',
	'days' => '{{PLURAL:$1|einem Daach|$1 Dääsch|keinem Daach}}',
	'deletedwhileediting' => '<strong>Opjepass:</strong> De Sigg wood fottjeschmesse, nohdäm Do ald aanjefange häs, dran ze Ändere.
Em <span class="plainlinks">[{{fullurl:Special:Log|type=delete&page=}}{{FULLPAGENAMEE}} Logboch vum Sigge-Fottschmieße]</span> künnt der Jrund shtonn.
Wann De de Sigg avspeichere deis, weed se widder aanjelaat.',
	'descending_abbrev' => 'raffkaz zoteet',
	'duplicate-defaultsort' => "'''Opjepaß:'''
Dä Shtanndat-Zoot-Schlößel „$1“ övverschriif dä älldere Zoot-Schlößel „$2“.",
	'dberr-header' => 'Dat Wiki heh häd en Schwierischkeit',
	'dberr-problems' => 'Deit uns leid, die Sigg heh häd för der Momang e teschnisch Problem.',
	'dberr-again' => 'Versök eijfach en e paa Menutte, norr_ens die Sigg afzeroofe.',
	'dberr-info' => '(Mer han kei Verbindung noh_m Datebank-ẞööver krijje künne: $1)',
	'dberr-usegoogle' => 'De künnß zweschedorsch ad met <i lang="en">Google</i> söke.',
	'dberr-outofdate' => 'Müjjelesch, dat dat Verzeichnes vun uns Sigge do nit janß om neuste Shtannd es.',
	'dberr-cachederror' => 'Wat heh noh kütt es en Kopi vum Zwescheshpeisher vun dä Sigg,
die De häs han welle. Se künnt jet ällder un nit mieh aktoäll sin.',
);

$messages['ku-latn'] = array(
	'december' => 'Berfanbar',
	'december-gen' => 'Berfanbar',
	'dec' => 'ber',
	'delete' => 'Jê bibe',
	'deletethispage' => 'Vê rûpelê jê bibe',
	'disclaimers' => 'Ferexetname',
	'disclaimerpage' => 'Project:Ferexetname',
	'databaseerror' => 'Çewtiya bingeha daneyan',
	'dberrortext' => 'Li cem dîtina bingeha daneyan <blockquote><tt>$1</tt></blockquote>
ji fonksiyonê "<tt>$2</tt>" ye.
MySQL ev şaşîtî hate dîtin: "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Li cem dîtina bingeha daneyan "$1 ji fonksiyonê "<tt>$2</tt>" ye.
MySQL ev şaşîtî hate dîtin: "<tt>$3: $4</tt>".',
	'directorycreateerror' => 'Rêbera "$1" nehate çêkirin.',
	'deletedhist' => 'Dîroka jêbirî',
	'difference' => '(Ciyawaziya nav guhertoyan)',
	'difference-multipage' => '(Cudahî di navbera rûpelan de)',
	'diff-multi' => '({{PLURAL:$1|Guhertoyeke di navbera herduyan de|$1 guhertoyên di navbera herduyan de}} tê(n) dîtin.)',
	'datedefault' => 'Tercih tune ne',
	'default' => 'asayî',
	'diff' => 'ciyawazî',
	'destfilename' => 'Navê pela xwestî:',
	'download' => 'daxistin',
	'disambiguations' => 'Rûpelên cudakirinê',
	'disambiguationspage' => 'Template:disambig',
	'doubleredirects' => 'Beralîkirinên ducarî',
	'double-redirect-fixed-move' => 'Cihê [[$1]] hatiye guhertin, ew niha beralîkirina [[$2]] ye.',
	'deadendpages' => 'Rûpelên bê dergeh',
	'deletedcontributions' => 'Guherandinên bikarhênerekî yê jêbirî',
	'deletedcontributions-title' => 'Guherandinên bikarhênerekî yê jêbirî',
	'defemailsubject' => '{{SITENAME}} e-name',
	'deletepage' => 'Rûpelê jê bibe',
	'delete-confirm' => 'Jêbirina "$1"',
	'delete-legend' => 'Jêbirin',
	'deletedtext' => '"$1" hat jêbirin. Ji bo qeyda rûpelên ku di dema nêzîk de hatin jêbirin binêre $2.',
	'dellogpage' => 'Jêbirina rûpelê',
	'dellogpagetext' => 'Li jêr lîsteyek ji jêbirinên dawî heye.',
	'deletionlog' => 'jêbirina rûpelê',
	'deletecomment' => 'Sedem:',
	'deleteotherreason' => 'Sedemekî din:',
	'deletereasonotherlist' => 'Sedemekî din',
	'deletereason-dropdown' => '*Sedemên jêbirinê
** Daxwaziya xwedî
** Pirsgirêka lîsansê
** Vandalîzm',
	'delete-edit-reasonlist' => 'Sedemên jêbirinê biguherîne',
	'delete-toobig' => 'Dîroka vê rûpelê pir mezin e, zêdetirî $1 guherandin. Jêbirina van rûpelan hatîye sînorkirin, ji bo pir şaşbûn (error) di {{SITENAME}} da çênebin.',
	'delete-warning-toobig' => "Dîroka vê rûpelê pir mezin e, zêdetirî $1 guherandin. Jêbirina van rûpelan dikarin şaşbûnan di database'ê {{SITENAME}} da çêkin; zandibe tu çi dikê!",
	'databasenotlocked' => 'Danegeh ne girtî ye.',
	'delete_and_move' => 'Jêbibe û nav biguherîne',
	'delete_and_move_text' => '== Jêbirin gireke ==

Rûpela "[[:$1]]" berê heye. Tu rast dixazê wê jêbibê ji bo navguherandinê ra?',
	'delete_and_move_confirm' => 'Erê, wê rûpelê jêbibe',
	'delete_and_move_reason' => 'Jêbir ji bo navguherandinê',
	'deletedrevision' => 'Guhertoya berê $1 hate jêbirin.',
	'deletedwhileediting' => 'Hîşyar: Piştî te guherandinê xwe dest pê kir ev rûpela hate jêbirin!',
	'dberr-header' => "Problemeka vê wiki'yê heye.",
);

$messages['kv'] = array(
	'december' => 'ӧшым тӧлысь',
	'december-gen' => 'ӧшым',
	'delete' => 'Бырӧдны',
	'deletepage' => 'Лист бокӧс бырӧдны',
	'deletereason-dropdown' => '* Типовые причины удаления
** вандализм
** по запросу автора
** нарушение авторских прав
* MediaWiki
** Дубликат сообщения с translatewiki.net',
);

$messages['kw'] = array(
	'december' => 'Kevardhu',
	'december-gen' => 'Kevardhu',
	'dec' => 'Kev',
	'delete' => 'Dilea',
	'deletethispage' => 'Dilea an folen-ma',
	'disclaimers' => 'Avisyanjow',
	'disclaimerpage' => 'Project:Avisyans ollgebmen',
	'databaseerror' => 'Gwall database',
	'difference' => '(Dyffrans ynter an amendyanjow)',
	'difference-multipage' => '(Dyffrans ynter an folednow)',
	'diff' => 'dyffrans',
	'download' => 'iscarga',
	'defemailsubject' => 'E-bost {{SITENAME}}',
	'deletepage' => 'Dilea an folen',
	'delete-confirm' => 'Dilea "$1"',
	'delete-legend' => 'Dilea',
	'deletedtext' => '"$1" yw dileys.
Gwelowgh $2 rag covadh a dhileanjow a-dhiwedhes.',
	'dellogpage' => 'Covnoten dilea',
	'deletecomment' => 'Acheson:',
	'deleteotherreason' => 'Acheson aral/keworansel:',
	'deletereasonotherlist' => 'Acheson aral',
);

$messages['ky'] = array(
	'december' => 'Декабрь (Бештин айы)',
	'december-gen' => 'Декабрь (Бештин айы)',
	'dec' => 'Дек',
	'delete' => 'Өчүрүү',
	'deletethispage' => 'Бул баракты өчүрүп кой',
	'disclaimers' => 'Жоопкерчиликтен баш тартуу',
	'disclaimerpage' => 'Project:Жалпы жоопкерчиликтен баш тартуу',
	'difference' => '(Оңдоолордун айырмасы)',
	'diff-multi' => '({{PLURAL:$2|колдонуучу|$2 колдонуучу}} тарабынан жасалган {{PLURAL:$1|аралык версия|$1 аралык версия}} көрсөтүлгөн жок)',
	'diff' => 'айырма',
	'disambiguationspage' => 'Template:көп маанилүү',
	'deletepage' => 'Баракты өчүрүп кой',
	'dellogpage' => 'Өчүрүлгөндөрдүн тизмеси',
	'deletecomment' => 'Себеп',
	'delete_and_move_confirm' => 'Ооба, бул баракты өчүр',
	'duplicate-defaultsort' => '\'\'\'Абайлатуу:\'\'\' "$2" белгиленген ылгоочу ачкыч "$1" мурунку белгиленген ылгоочу ачкычты жокко чыгарат.',
);

$messages['la'] = array(
	'december' => 'December',
	'december-gen' => 'Decembris',
	'dec' => 'Dec',
	'delete' => 'Delere',
	'deletethispage' => 'Delere hanc paginam',
	'disclaimers' => 'Repudiationes',
	'disclaimerpage' => 'Project:Repudiationes',
	'databaseerror' => 'Erratum in basi datorum',
	'dberrortextcl' => 'Erratum syntacticum basis datorum accidit.
Inquisitio basis datorum ultime apparata erat:
"$1"
ex functionis "$2".
Basis datorum erratum reddidit "$3: $4"',
	'directorycreateerror' => 'Non potuit directorium "$1" creari.',
	'deletedhist' => 'Historia deleta',
	'difference' => '(Dissimilitudo inter emendationes)',
	'datedefault' => 'Nullum praeferentiae',
	'defaultns' => 'Quaerere per haec spatia nominalia a defalta:',
	'default' => 'praedeterminatum',
	'diff' => 'diss',
	'destfilename' => 'Nomen fasciculi petitum:',
	'download' => 'depromere',
	'disambiguations' => 'Paginae quae ad paginas discretivas nectunt',
	'disambiguationspage' => 'Template:Discretiva',
	'disambiguations-text' => "Paginae subter ad '''paginam discretivam''' nectunt.
Eae ad aptas paginas magis nectendae sunt.<br />
Pagina discretivam esse putatur si formulam adhibet ad quem [[MediaWiki:Disambiguationspage]] nectit.",
	'doubleredirects' => 'Redirectiones duplices',
	'double-redirect-fixed-move' => '[[$1]] mota est et nunc redirigit ad [[$2]]',
	'double-redirect-fixer' => 'Rectificator redirectionum',
	'deadendpages' => 'Paginae sine nexu',
	'deadendpagestext' => 'Paginae subter non nectunt ad alias paginas ullas in {{grammar:ablative|{{SITENAME}}}}.',
	'deletedcontributions' => 'Conlationes usoris deletae',
	'deletedcontributions-title' => 'Conlationes usoris deletae',
	'defemailsubject' => '{{SITENAME}} - Litterae electronicae ab usore "$1"',
	'deletepage' => 'Delere paginam',
	'delete-confirm' => 'Delere "$1"',
	'delete-legend' => 'Delere',
	'deletedtext' => '"$1" deletum est. Vide $2 pro indice deletionum recentum.',
	'dellogpage' => 'Index deletionum',
	'dellogpagetext' => 'Subter est index deletionum recentissimarum.',
	'deletionlog' => 'index deletionum',
	'deletecomment' => 'Causa:',
	'deleteotherreason' => 'Causa alia vel explicatio:',
	'deletereasonotherlist' => 'Causa alia',
	'deletereason-dropdown' => '*Causae deletionum communes
** Desiderium auctoris
** Violatio verborum privatorum
** Vandalismus',
	'delete-edit-reasonlist' => 'Causas deletionum recensere',
	'databasenotlocked' => 'Basis datorum non obstructa est.',
	'delete_and_move' => 'Delere et movere',
	'delete_and_move_text' => '==Deletio necesse est==
Paginae nomen petitum "[[:$1]]" iam existit. Vin tu eam delere ut pagina illic moveatur?',
	'delete_and_move_confirm' => 'Ita, paginam delere',
	'delete_and_move_reason' => 'Deleta ut moveatur ex "[[$1]]"',
	'djvu_page_error' => 'Pagina DjVu extra latitudinem',
	'deletedrevision' => 'Delevit emendationem $1 veterem',
	'deletedwhileediting' => "'''Monitio:''' Haec pagina deleta est postquam inceperis eam recensere!",
	'descending_abbrev' => 'desc',
);

$messages['lad'] = array(
	'december' => 'Diziembre',
	'december-gen' => 'Diziembre',
	'dec' => 'Diz',
	'delete' => 'Efaçar',
	'deletethispage' => 'Efassar esta hoja',
	'disclaimers' => 'Refuso de responsabilitá',
	'disclaimerpage' => 'Project:Rēfuso de responsabilitá jeneral',
	'databaseerror' => 'Yerro de la Databasa',
	'difference' => '(Diferencias entre rêvisiones)',
	'diff' => 'dif',
	'deletepage' => 'Efassar esta hoja',
	'deletedtext' => '"$1" fue efassado.
Mira $2 para un registro de los efassados nuevos.',
	'dellogpage' => 'Registro de efassados',
	'deletecomment' => 'Razón:',
	'deleteotherreason' => 'Otra razón:',
	'deletereasonotherlist' => 'Otra razón',
	'deletereason-dropdown' => '* Motivos generales de efassamientos
** La demanda del criador de la hoja
** Violación de copyright
** Vandalismo',
);

$messages['lb'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezember',
	'dec' => 'Dez.',
	'delete' => 'Läschen',
	'deletethispage' => 'Dës Säit läschen',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Datebank Feeler',
	'dberrortext' => 'En Datebank Syntax Feeler ass opgetrueden.
Dëst kann op e Feeler an der Software hiweisen.
De leschte versichten Datebank Query war:
<blockquote><tt>$1</tt></blockquote>
vun der Funktioun "<tt>$2</tt>".
D\'Datebank huet de Feeler "<tt>$3: $4</tt>" gemellt.',
	'dberrortextcl' => 'En Datebank Syntax Feeler ass opgetrueden.
De leschten Datebank Query war:
"$1"
vun der Funktioun "$2".
D\'Datebank huet de Feeler "$3: $4" gemellt.',
	'directorycreateerror' => 'De Repertoire "$1" konnt net geschafe ginn.',
	'deletedhist' => 'Geläschte Versiounen',
	'difference' => '(Ennerscheed tëscht Versiounen)',
	'difference-multipage' => '(Ënnerscheed tëschent Säiten)',
	'diff-multi' => '({{PLURAL:$1|Eng Tëscheversioun|$1 Tëscheversioune}} vun {{PLURAL:$2|engem|$2}} Benotzer {{PLURAL:$1|gëtt|ginn}} net gewisen)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Eng Tëscheversioun|$1 Tëscheversioune}} vu méi wéi $2 {{PLURAL:$2|Benotzer|Benotzer}} ginn net gewisen)',
	'datedefault' => 'Egal (Standard)',
	'defaultns' => 'Soss an dësen Nummraim sichen:',
	'default' => 'Standard',
	'diff' => 'Ënnerscheed',
	'destfilename' => 'Numm ënner deem de Fichier gespäichert gëtt:',
	'duplicatesoffile' => '{{PLURAL:$1|De Fichier ass een Doublon|Dës Fichiere sinn Doublone}} vum Fichier ([[Special:FileDuplicateSearch/$2|méi Detailer]]):',
	'download' => 'eroflueden',
	'disambiguations' => 'Säiten déi op Homonymie-Säite linken',
	'disambiguationspage' => 'Template:Homonymie',
	'disambiguations-text' => 'Dës Säite si mat enger Homonymie-Säit verlinkt.
Sie sollten am beschten op déi eigentlech gemengte Säit verlinkt sinn.<br />
Eng Säite gëtt als Homonymiesäit behandelt, wa si eng Schabloun benotzt déi vu [[MediaWiki:Disambiguationspage]] verlinkt ass.',
	'doubleredirects' => 'Duebel Viruleedungen',
	'doubleredirectstext' => 'Op dëser Säit stinn déi Säiten déi op aner Viruleedungssäite viruleeden.
An all Rei sti Linken zur éischter an zweeter Viruleedung, souwéi d\'Zil vun der zweeter Viruleedung, déi normalerweis déi "richteg" Zilsäit ass, op déi déi éischt Viruleedung hilinke soll.
<del>Duerchgestrachen</del> Linke goufe schonn esou verännert datt déi duebel Viruleedung opgeléist ass.',
	'double-redirect-fixed-move' => '[[$1]] gouf geréckelt, et ass elo eng Viruleedung op [[$2]]',
	'double-redirect-fixed-maintenance' => 'Flécke vun der duebeler Viruleedung vu(n) [[$1]] op [[$2]].',
	'double-redirect-fixer' => 'Verbesserung vu Viruleedungen',
	'deadendpages' => 'Sakgaasse-Säiten',
	'deadendpagestext' => 'Dës Säite si mat kenger anerer Säit op {{SITENAME}} verlinkt.',
	'deletedcontributions' => 'Geläschte Kontributiounen',
	'deletedcontributions-title' => 'Geläschte Kontributiounen',
	'defemailsubject' => '{{SITENAME}} E-Mail vum Benotzer "$1"',
	'deletepage' => 'Säit läschen',
	'delete-confirm' => 'Läsche vu(n) "$1"',
	'delete-legend' => 'Läschen',
	'deletedtext' => '"$1" gouf geläscht. Kuckt $2 fir eng Lëscht vun de Säiten déi viru Kuerzem geläscht goufen.',
	'dellogpage' => 'Läschlëscht',
	'dellogpagetext' => 'Hei fannt dir eng Lëscht mat rezent geläschte Säiten. All Auerzäiten sinn déi vum Server.',
	'deletionlog' => 'Läschlëscht',
	'deletecomment' => 'Grond:',
	'deleteotherreason' => 'Aneren/ergänzende Grond:',
	'deletereasonotherlist' => 'Anere Grond',
	'deletereason-dropdown' => '* Heefegst Grënn fir eng Säit ze läschen
** Wonsch vum Auteur
** Verletzung vun engem Copyright
** Vandalismus',
	'delete-edit-reasonlist' => 'Läschgrënn änneren',
	'delete-toobig' => "Dës Säit huet e laangen Historique, méi wéi $1 {{PLURAL:$1|Versioun|Versiounen}}.
D'Läsche vun esou Säite gouf limitéiert fir ongewollte Stéierungen op {{SITENAME}} ze verhënneren.",
	'delete-warning-toobig' => "Dës Säit huet eng laang Versiounsgeschicht, méi wéi $1 {{PLURAL:$1|Versioun|Versiounen}}.
D'Läschen dovun kann zu Stéierungen am Funktionnement vun {{SITENAME}} féieren;
dës Aktioun soll mat Vierssiicht gemaach ginn.",
	'databasenotlocked' => "D'Datebank ass net gespaart.",
	'delete_and_move' => 'Läschen a réckelen',
	'delete_and_move_text' => '== Läsche vun der Destinatiounssäit néideg == D\'Säit "[[:$1]]" existéiert schonn. Wëll der se läsche fir d\'Réckelen ze erméiglechen?',
	'delete_and_move_confirm' => "Jo, läsch d'Destinatiounssäit",
	'delete_and_move_reason' => 'Geläscht fir Plaz ze maache fir "[[$1]]" heihin ze réckelen',
	'djvu_page_error' => 'DjVu-Säit baussent dem Säiteberäich',
	'djvu_no_xml' => 'Den XML ka fir den DjVu-Fichier net ofgeruff ginn',
	'deletedrevision' => 'Al, geläschte Versioun $1',
	'days' => '{{PLURAL:$1|engem Dag|$1 Deeg}}',
	'deletedwhileediting' => "'''Opgepasst''': Dës Säit gouf geläscht nodeems datt dir ugefaangen hutt se z'änneren!",
	'descending_abbrev' => 'erof',
	'duplicate-defaultsort' => 'Opgepasst: Den Zortéierschlëssel "$2" iwwerschreift de viregen Zortéierschlëssel "$1".',
	'dberr-header' => 'Dës Wiki huet e Problem',
	'dberr-problems' => 'Pardon! Dëse Site huet technesch Schwieregkeeten.',
	'dberr-again' => 'Versicht e puer Minutten ze waarden an dann nei ze lueden.',
	'dberr-info' => '(Den Datebank-Server kann net erreecht ginn: $1)',
	'dberr-usegoogle' => 'An der Tëschenzäit kënnt Dir probéiere mam Google ze sichen.',
	'dberr-outofdate' => 'Denkt drunn, datt de Sichindex vun eisen Inhalte méiglecherweis net aktuell ass.',
	'dberr-cachederror' => 'Dëst ass eng tëschegespäichert Kopie vun der gefroter Säit, a si kann eventuell net aktuell sinn.',
);

$messages['lez'] = array(
	'december' => 'ФaндукӀ',
	'december-gen' => 'ФaндукӀ',
	'dec' => 'Фaн',
	'delete' => 'Алудун',
	'deletethispage' => 'И ччин алудун',
	'disclaimers' => 'Жавабдарвал хивяй акъудун',
	'disclaimerpage' => 'Project:Жавабдарвал хивяй акъудун',
	'difference' => '(Жуьрейрин арада тафаватар)',
	'diff-multi' => '({{PLURAL:$2|СА иштиракчи|$2 иштиракчияр}} патал авунвай {{PLURAL:$1|са арадин жуьре|$1 арадин жуьреяр}} къалурнавач)',
	'datedefault' => 'Туькlуьрмир',
	'diff' => 'тафават',
	'disambiguationspage' => 'Template:гзафманавал',
	'deletepage' => 'Къакъудун хъувун',
	'deletedtext' => '"$1" чlурнайтир.                                                                                                                                                       Килиг $2 эхиримжи  чlурунар ахтармишун.',
	'dellogpage' => 'Алудунин журнал',
	'deletecomment' => 'Кар',
	'deleteotherreason' => 'Масса/ ва мад кар',
	'deletereasonotherlist' => 'Маса фагьум',
	'duplicate-defaultsort' => '\'\'\'Дикъет:\'\'\' Авайд хьиз кьунвай жуьрейриз ччара авунин "$2" куьлег  виликан "$1" жуьрейриз ччара авунин куьлег гьич йийзва.',
);

$messages['lfn'] = array(
	'december' => 'desembre',
	'december-gen' => 'Desembre',
	'dec' => 'des',
	'delete' => 'Sutrae',
	'deletethispage' => 'Sutrae esta paje',
	'disclaimers' => 'Negas de respondablia',
	'disclaimerpage' => 'Project:Nega jeneral de respondablia',
	'databaseerror' => 'Era de base de datos',
	'difference' => '(Difere entre cambias)',
	'diff-multi' => '({{PLURAL:$1|$1 revise|$1 revises}} medial no mostrada.)',
	'diff' => 'dife',
	'disambiguations' => 'Pajes desambiguinte',
	'doubleredirects' => 'Redirijes duple',
	'deadendpages' => 'Pajes sin sorti',
	'deletepage' => 'Sutrae la paje',
	'deletedtext' => '"$1" ia es sutraeda.
Vide $2 per un catalogo de sutraes resente.',
	'dellogpage' => 'catalogo de sutraes',
	'deletecomment' => 'Razona:',
	'deleteotherreason' => 'Otra/plu razona:',
	'deletereasonotherlist' => 'Otra razona',
);

$messages['lg'] = array(
	'december' => 'Gwakkuminebiri',
	'december-gen' => 'Gwakkuminebiri',
	'dec' => 'Gw12',
	'delete' => 'Gyawo olupapula luno',
	'deletethispage' => 'Olupapula luno lugyewo',
	'disclaimers' => "Okutangaaza ku kkomo ery'obuvunaaniro bwaffe obw'omu mateeka",
	'disclaimerpage' => "Project:Okutangaaza ku kkomo ery'obuvunaaniro bwaffe obw'omu mateeka",
	'databaseerror' => 'Waliwo kiremya ku ggwanika lya data',
	'dberrortext' => 'Waliwo kiremya avudde ku mpandika y\'ekiragiro ekinoonyeza mu ggwanika lya data.<br />
Ayinza okuba nga azze lwa nsobi mu sofutiweya wa lyo.<br />
Ekiragiro ekinoonyeza mu ggwanika lya data ekisembye okuyisibwa kiri:<br />
<blockquote><tt>$1</tt></blockquote>
ekisangibwa mu mukolo gwa puloguramu "<tt>$2</tt>".<br />
Obubaka obuvudde mu ggwanika lya data obufa ku kiremya buli "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Waliwo kiremya avudde ku mpandika y\'ekiragiro ekinoonyeza mu ggwanika lya data.<br />
Ekiragiro ekinoonyeza mu ggwanika lya data ekisembye okuyisibwa kiri:<br />
"$1" <br />
ekisangibwa mu mukolo gwa mu puloguramu "$2".<br />
Obubaka obuvudde mu ggwanika lya data obufa ku kiremya buli "$3: $4"',
	'directorycreateerror' => 'Nnemedwa okukolawo etterekero "$1".',
	'difference' => "(Enjawulo mu mpandika ez'olupapula)",
	'diff' => 'enjawulo',
	'deletepage' => 'Gyawo olupapula',
	'deletedtext' => 'Olupapula "$1" lugyidwawo.

Kebera olukalala $2 okumanya ebifa ku byakagyibwawo.',
	'dellogpage' => 'Ebigyidwawo',
	'deletecomment' => 'Nsonga:',
	'deleteotherreason' => 'Nsonga ndala:',
	'deletereasonotherlist' => 'Nsonga ndala',
);

$messages['li'] = array(
	'december' => 'december',
	'december-gen' => 'december',
	'dec' => 'dec',
	'delete' => 'Wisse',
	'deletethispage' => 'Wisse',
	'disclaimers' => 'Aafwiezinge aansjprakelikheid',
	'disclaimerpage' => 'Project:Algemein aafwiezing aansjprakelikheid',
	'databaseerror' => 'Databasefout',
	'dberrortext' => 'Bie \'t zeuke is \'n syntaxfout in de database opgetraoje.
Dit kan zien veroorzaak door \'n fout in de software.
De lètste zeukpoging in de database waor:
<blockquote><tt>$1</tt></blockquote>
vanoet de functie "<tt>$2</tt>".
Database gaof de foutmelding "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Dao is \'n syntaxfout opgetreje bie \'t zeuke in de database.
De lèste opgevraogde zeukactie waor:
"$1"
vanoet de functie "$2".
Database brach fout "$3" nao veure: "$4"',
	'directorycreateerror' => 'Map "$1" kós neet aangemaak waere.',
	'deletedhist' => 'Verwiederde gesjiedenis',
	'difference' => '(Versjil tösje bewirkinge)',
	'difference-multipage' => '(Versjil tösje paazjes)',
	'diff-multi' => '({{PLURAL:$1|Ein tusseligkende versie|$1 Tusseligkende versies}} dórch {{PLURAL:$2|eine gebroeker|$2 gebroekers}} {{PLURAL:$1|weurt|waere}} neet getuund)',
	'diff-multi-manyusers' => '($1 tösseligkende versies door mier es $2 gebroekers waere neet waergaeve)',
	'datedefault' => 'Gein veurkäör',
	'defaultns' => 'Zeuk anges in dees naomruumdes:',
	'default' => 'sjtandaard',
	'diff' => 'vers',
	'destfilename' => 'Doeltitel:',
	'duplicatesoffile' => "{{PLURAL:$1|'t Nègsvóggendj bestandj is|De $1 nègsvóggendje bestenj zeen}} identiek aan dit bestandj ([[Special:FileDuplicateSearch/$2|deper]]):",
	'download' => 'Downloade',
	'disambiguations' => "Links nao verdudelikingspazjena's",
	'disambiguationspage' => 'Template:Verdudeliking',
	'disambiguations-text' => "Hiej onger staon pagina's die verwieze nao 'ne '''redirect'''.
Deze heure waarsjienlik direct nao 't zjuste ongerwerp te verwiezen.<br />
'ne pagina wörd gezeen es redirect wen d'r 'n sjabloon op stuit det gelink is vanaaf [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dobbel redirects',
	'doubleredirectstext' => "Dees lies haet paazjes mit redireks die nao anger redireks gaon.
Op eder raegel vings te de ierste redirectpazjena, de twiede redirectpazjena en de iesjte raegel van de twiede redirectpazjena. Meistes bevat dees litste de pazjena woe de iesjte redirect naotoe zouw mótte verwieze.
<del>Dórchstreipinge</del> zègke det 't al gedaon is.",
	'double-redirect-fixed-move' => "[[$1]] is verplaats en is noe 'n doorverwiezing nao [[$2]]",
	'double-redirect-fixed-maintenance' => 'Correctie dóbbel redirek van [[$1]] nao [[$2]].',
	'double-redirect-fixer' => 'Doorverwiezinge opsjone',
	'deadendpages' => "Doedloupende pazjena's",
	'deadendpagestext' => "De ongerstäönde pagina's verwieze neet nao anger pagina's in {{SITENAME}}.",
	'deletedcontributions' => 'Eweggesjafde gebroekersbiedrages',
	'deletedcontributions-title' => 'Eweggesjafde gebroekersbiedrages',
	'defemailsubject' => 'E-mail van {{SITENAME}}-gebroeker "$1"',
	'deletepage' => 'Pazjena wisse',
	'delete-confirm' => '"$1" wisse',
	'delete-legend' => 'Wisse',
	'deletedtext' => '"$1" is eweggesjaf. Bekiek $2 veur \'n euverzich van recènt eweggesjafde pagina\'s.',
	'deletedarticle' => '"[[$1]]" is eweggesjaf',
	'dellogpage' => 'Wislogbook',
	'dellogpagetext' => "Hie volg 'n lies van de meis recènt eweggesjafde pagina's en besjtandje.",
	'deletionlog' => 'Wislogbook',
	'deletecomment' => 'Reeje:',
	'deleteotherreason' => 'Angere/eventuele ree:',
	'deletereasonotherlist' => 'Angere ree',
	'deletereason-dropdown' => '*Väölveurkommende wisree
** Op aanvraog van auteur
** Sjending van auteursrech
** Gebroek es zandjbak
** Vandalisme/Sjeljerie',
	'delete-edit-reasonlist' => 'Reeje veur verwiedering bewèrke',
	'delete-toobig' => "Dees pazjena haet 'ne lange bewerkingsgesjiedenis, mieë es $1 {{PLURAL:$1|versie|versies}}. 't Wisse van dit saort pazjena's is mit rech beperk óm 't próngelök versteure van de werking van {{SITENAME}} te veurkómme.",
	'delete-warning-toobig' => "Dees pazjena haet 'ne lange bewerkingsgesjiedenis, mieë es $1 {{PLURAL:$1|versie|versies}}. 't Wisse van dees pazjena kan de werking van de database van {{SITENAME}} versteure. Bön veurzichtig.",
	'databasenotlocked' => 'De database is neet geblokkeerd.',
	'delete_and_move' => 'Wis en verplaats',
	'delete_and_move_text' => '==Wisse vereis==

De doeltitel "[[:$1]]" besjteit al. Wils te dit artikel wisse óm ruumde te make veur de verplaatsing?',
	'delete_and_move_confirm' => 'Jao, wis de pazjena',
	'delete_and_move_reason' => 'Gewis óm artikel [[$1]] te kónne verplaatse',
	'djvu_page_error' => 'DjVu-pagina boete bereik',
	'djvu_no_xml' => "De XML veur 't DjVu-bestandj kos neet opgehaald waere",
	'deletedrevision' => 'Aw versie $1 gewis',
	'days' => '{{PLURAL:$1|$1 daag|$1 daag}}',
	'deletedwhileediting' => "'''Waorsjoewing''': Dees pazjena is gewis naodats doe bis begós mit bewirke!",
	'descending_abbrev' => 'aaf.',
	'duplicate-defaultsort' => 'Waarsjuwing: De standaardsortering "$2" krieg veurrang veur de sortering "$1".',
	'dberr-header' => "Deze wiki haet 'n probleem",
	'dberr-problems' => 'Os excuses. Deze site ongervindj op t moment technische probleme.',
	'dberr-again' => 'Wach n aantal minute en probeer t daonao opnuuj.',
	'dberr-info' => '(Kan gein verbinjing make mit de databaseserver: $1)',
	'dberr-usegoogle' => 'Wellich kins se in de tussetied zeuke via Google.',
	'dberr-outofdate' => "Let op: häör indices ven os pagina's zeen wellich neet recent.",
	'dberr-cachederror' => 'Deze pagina is n kopie oet de cache en is wellich neet de lèste versie.',
);

$messages['lij'] = array(
	'december' => 'Dexembre',
	'december-gen' => 'Dexembre',
	'dec' => 'Dex',
	'delete' => 'Scancella',
	'deletethispage' => "Scassa 'sta paggina",
	'disclaimers' => 'Avértense',
	'disclaimerpage' => 'Project:Avertense generâli',
	'databaseerror' => 'Errô da a base de i dæti',
	'difference' => '(Differense fra e revixoîn)',
	'diff-multi' => '({{PLURAL:$1|Inna revixión intermedia|$1 revixioìn intermedie}} de {{PLURAL:$2|un utente|$2 utenti}} no son mostræ)',
	'default' => 'Predefinïo',
	'diff' => 'diff',
	'destfilename' => 'Nomme do papê de destin:',
	'disambiguations' => 'Paggine de desambiguassion',
	'disambiguationspage' => 'Template:Dizanbigoa',
	'doubleredirects' => 'Rindirissamenti doggi',
	'deadendpages' => 'Paggine sensa sciortîa',
	'defemailsubject' => '{{SITENAME}} posta elettronega',
	'deletepage' => 'Scassa a paggina',
	'delete-confirm' => 'Scassa "$1"',
	'delete-legend' => 'Scassa',
	'deletedtext' => 'A paggina "$1" a l\'è stæta scassâa. Consûltâ o $2 pe \'na lista de-e paggine scassæ de reçente.',
	'dellogpage' => 'Registro de-e cose scassæ',
	'deletecomment' => 'Raxon:',
	'deleteotherreason' => 'Ûn âtro motivo',
	'deletereasonotherlist' => "Ûnn'âtra raxon",
	'databasenotlocked' => "A base de i dæti a non l'è serrâ.",
	'delete_and_move' => 'Scassa e mescia',
	'delete_and_move_confirm' => 'Scì, scassa a pagina',
	'delete_and_move_reason' => 'Levoö pe fâ röso pe un remescio',
	'duplicate-defaultsort' => 'Atençión: a ciâve de ordinaménto predefinîa "$2" va in çimma a quella de prìmma "$1".',
);

$messages['liv'] = array(
	'december' => 'detsembõr',
	'december-gen' => 'Detsembõr',
	'dec' => 'dets',
	'delete' => 'Kištāntõgid jarā',
	'disclaimers' => 'Kūondõkst',
	'disclaimerpage' => 'Project:Kūondõkst',
	'difference' => '(Vaiţīd redaktsijõd vail)',
	'diff-multi' => '({{PLURAL:$1|Īdtõ|$1}} vail-vȯlbizt {{PLURAL:$2|īd|$2}} kȭlbatijiz redaktsijõ äb nägţõbõd.)',
	'diff' => 'vaiţ',
	'disambiguationspage' => 'Template:Jarā-seļţimiz-lēḑ',
	'deletepage' => 'Kištāntõgid se lēḑ jarā',
	'deletedtext' => ' "$1" um jarā kištāntõd. Jarā kištāntõd lēḑõd āt tūodõd nimkēras $2.',
	'dellogpage' => 'Jarā kištāntimiz log',
	'deletecomment' => 'Sī:',
	'deleteotherreason' => 'Mū agā jūrõ pandõb sī:',
	'deletereasonotherlist' => 'Mū sī',
	'duplicate-defaultsort' => "'''Kūondõks:''' Kõõrda-jadā võţīm ''$2'' tīeb tijāks jedsõ pūol vólbiz kõõrda-jadā võţīm ''$1''.",
);

$messages['lmo'] = array(
	'december' => 'Dicember',
	'december-gen' => 'Dizember',
	'dec' => 'Dic',
	'delete' => 'Scancela',
	'deletethispage' => 'Scancela quela pagina chì',
	'disclaimers' => 'Disclaimers',
	'disclaimerpage' => 'Project:Avertenz generaj',
	'databaseerror' => 'Erur in del database',
	'difference' => '(Diferenz intra i revisión)',
	'datedefault' => 'Nissüna preferenza',
	'defaultns' => 'Tröva sempar in di caamp:',
	'diff' => 'dif',
	'destfilename' => "Nomm da l'archivi da destinazziun:",
	'disambiguations' => 'Pagin da disambiguazziún',
	'doubleredirects' => 'Redirezziún dópi',
	'deadendpages' => 'Pagin senza surtida',
	'deletedcontributions' => 'Cuntribüziun scancelaa',
	'deletedcontributions-title' => 'Cuntribüziun scancelaa',
	'deletepage' => 'Scancela la pagina',
	'deletedtext' => 'La pagina "$1" l\'è stada scancelada. Varda el $2 per una lista di ültim scancelaziun.',
	'dellogpage' => 'Register di scancelament',
	'deletionlog' => 'log di scancelament',
	'deletecomment' => 'Reson:',
	'deleteotherreason' => 'Alter mutiv:',
	'deletereasonotherlist' => 'Altra resón',
	'deletereason-dropdown' => "*Mutiv cumün de scancelaziun
** Richiesta de l'aütur
** Viulaziun del copyright
** Vandalism",
	'delete-edit-reasonlist' => 'Mudifega i mutiv del scancelament',
	'delete_and_move' => 'Scancelá e mööf',
	'deletedrevision' => 'Scancelada la revision vegia de $1.',
);

$messages['ln'] = array(
	'december' => 'sánzá ya zómi na míbalé',
	'december-gen' => 'sánzá ya zómi na míbalé',
	'dec' => 's12',
	'delete' => 'Kolímwisa',
	'deletethispage' => 'Kolímwisa lonkásá loye',
	'disclaimers' => 'Ndelo ya boyanoli',
	'disclaimerpage' => 'Project:Boyanoli ndelo',
	'databaseerror' => 'Zíko ya litákoli ya kabo',
	'diff' => 'mbó.',
	'disambiguations' => 'Bokokani',
	'doubleredirects' => 'Boyendisi mbala míbalé',
	'defemailsubject' => '{{SITENAME}} mokánda',
	'deletepage' => 'Kolímwisa lonkásá loye',
	'dellogpage' => 'zuluná ya bolímwisi',
	'deletionlog' => 'zuluná ya bolímwisi',
	'deletecomment' => 'Ntína:',
	'deleteotherreason' => 'Ntína káka tǒ esúsu :',
	'deletereasonotherlist' => 'Ntína esúsu',
	'delete_and_move' => 'Kolímwisa mpé kobóngola nkómbó',
	'delete_and_move_confirm' => 'Boye, kolímwisa lonkásá',
	'delete_and_move_reason' => 'Ntína ya bolímwisi mpé bobóngoli bwa nkómbó',
);

$messages['lo'] = array(
	'december' => 'ທັນວາ',
	'december-gen' => 'ທັນວາ',
	'dec' => 'ທັນວາ',
	'delete' => 'ລຶບ',
	'deletethispage' => 'ລຶບໜ້ານີ້',
	'disclaimers' => 'ຂໍ້ປະຕິເສດຄວາມຮັບຜິດຊອບ',
	'disclaimerpage' => 'Project:ຂໍ້ປະຕິເສດຄວາມຮັບຜິດຊອບ',
	'databaseerror' => 'ມີຄວາມຜິດພາດ ດ້ານ ຖານຂໍ້ມູນ',
	'difference' => '(ສ່ວນຕ່າງລະຫວ່າງແຕ່ລະສະບັບ)',
	'datedefault' => 'ແນວໃດກໍ່ໄດ້',
	'defaultns' => 'ຄົ້ນຫາ ໃນ ຂອບເຂດຊື່ ນີ້ ເວລາບໍ່ມີການລະບຸ:',
	'diff' => 'ສ່ວນຕ່າງ',
	'disambiguations' => 'ໜ້າແກ້ຄວາມກຳກວມ',
	'disambiguations-text' => "ໜ້າຕໍ່ໄປນີ້ເຊື່ອມໂຍງໄປຍັງ '''ໜ້າແກ້ຄວາມກຳກວມ'''&nbsp;
ຊຶ່ງຄວນດັດແກ້ລິງຄ໌ໃຫ້ເຊື່ອມໂຍງໄປທີ່ໜ້າອື່ນທີ່ເໝາະສົມ<br />
ໜ້າໃດທີ່ຮຽກໃຊ້ແມ່ແບບ [[MediaWiki:Disambiguationspage|ແກ້ກຳກວມ]] ໜ້າເຫຼ່ານັ້ນຖຶກເປັນໜ້າແກ້ຄວາມກຳກວມ",
	'doubleredirects' => 'ໂອນໜ້າ 2 ຄັ້ງ',
	'deadendpages' => 'ໜ້າບໍ່ການເຊື່ອມຕໍ່ຫາໜ້າອື່ນ',
	'dellogpage' => 'ບັນທຶກ ການລຶບ',
	'dellogpagetext' => 'ຂ້າງລຸ່ມ ແມ່ນ ລາຍການ ການລຶບຫຼ້າສຸດ.',
	'deletionlog' => 'ບັນທຶກ ການລຶບ',
	'deletecomment' => 'ເຫດຜົນ:',
	'delete_and_move' => 'ລຶບ ແລະ ຍ້າຍ',
	'delete_and_move_confirm' => 'ແມ່ນແລ້ວ, ລຶບໜ້ານີ້',
	'delete_and_move_reason' => 'ລຶບແລ້ວ ເພື່ອ ຍ້າຍໜ້າອື່ນ ມານີ້',
);

$messages['loz'] = array(
	'december' => "Ng'ulule",
	'december-gen' => "Ng'ulule",
	'dec' => 'Ngu',
	'delete' => 'Afi kulobala',
	'deletethispage' => 'Afi kulobala bye petulo',
	'disclaimers' => 'Dikulemi',
	'disclaimerpage' => 'Project:Dikulemi generali',
	'databaseerror' => 'Bufosi di database',
	'directorycreateerror' => 'Ni sa hloli direktori "$1".',
	'difference' => '(Petuho kwa selt)',
	'diff-multi' => '({{PLURAL:$1|1 selt amebusilize|$1 selt amebusilize}} ni kamukile.)',
	'datedefault' => 'Ni di petohoni di sebelu',
	'default' => 'auto',
	'diff' => 'petuho',
	'download' => 'dawnlodezi',
	'disambiguations' => 'Disamebigasina',
	'doubleredirects' => 'Petulo abezi sa dužemi',
	'deadendpages' => "Mukoloko di petulo-ni ling'ki",
	'deadendpagestext' => "Bye petulo ni sa ling'ki medi petulo di {{SITENAME}}.",
	'deletedcontributions' => 'Afina di sebelu bye sa afi kulobala',
	'deletedcontributions-title' => 'Afina di sebelu bye sa afi kulobala',
	'defemailsubject' => '{{SITENAME}} meli',
	'deletepage' => 'Afi kulobala petulo',
	'deletedtext' => '"$1" sa afi kulobala. Fatukile $2 di desu di afi kulobala nca.',
	'dellogpage' => 'Desu di afi kulobala',
	'deletecomment' => 'Lyangutukezi:',
	'deleteotherreason' => 'Xetewi/ewi lyangutukezi:',
	'deletereasonotherlist' => 'Xetewi lyangutukezi',
	'delete_and_move' => 'Afi kulobala alo-di nyanganyisize',
	'descending_abbrev' => 'disendin',
);

$messages['lt'] = array(
	'december' => 'gruodžio',
	'december-gen' => 'Gruodis',
	'dec' => 'grd',
	'delete' => 'Trinti',
	'deletethispage' => 'Ištrinti šį puslapį',
	'disclaimers' => 'Atsakomybės apribojimas',
	'disclaimerpage' => 'Project:Atsakomybės apribojimas',
	'databaseerror' => 'Duomenų bazės klaida',
	'dberrortext' => 'Įvyko duomenų bazės užklausos sintaksės klaida.
Tai gali reikšti klaidą programinėje įrangoje.
Paskutinė mėginta duomenų bazės užklausa buvo:
<blockquote><tt>$1</tt></blockquote>
iš funkcijos: „<tt>$2</tt>“.
Duomenų bazė grąžino klaidą „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Įvyko duomenų bazės užklausos sintaksės klaida.
Paskutinė mėginta duomenų bazės užklausa buvo:
„$1“
iš funkcijos: „$2“.
Duomenų bazė grąžino klaidą „$3: $4“',
	'directorycreateerror' => 'Nepavyko sukurti aplanko „$1“.',
	'deletedhist' => 'Ištrinta istorija',
	'difference' => '(Skirtumai tarp versijų)',
	'difference-multipage' => '(Skirtumai tarp puslapių)',
	'diff-multi' => '($2 {{PLURAL:$2|naudotojo|naudotojų|naudotojų}} $1 {{PLURAL:$1|tarpinis keitimas nėra rodomas|tarpiniai keitimai nėra rodomi|tarpinių keitimų nėra rodoma}})',
	'diff-multi-manyusers' => '(daugiau nei $2 {{PLURAL:$2|naudotojo|naudotojų|naudotojų}} $1 {{PLURAL:$1|tarpinis keitimas nėra rodomas|tarpiniai keitimai nėra rodomi|tarpinių keitimų nėra rodoma}})',
	'datedefault' => 'Jokio pasirinkimo',
	'defaultns' => 'Pagal nutylėjimą ieškoti šiose vardų srityse:',
	'default' => 'pagal nutylėjimą',
	'diff' => 'skirt',
	'destfilename' => 'Norimas failo vardas:',
	'duplicatesoffile' => 'Šis failas turi {{PLURAL:$1|$1 dublikatą|$1 dublikatus|$1 dublikatų}} ([[Special:FileDuplicateSearch/$2|daugiau informacijos]]):',
	'download' => 'parsisiųsti',
	'disambiguations' => 'Puslapiai rodantys į daugiaprasmių žodžių puslapius',
	'disambiguationspage' => 'Template:Daugiareikšmis',
	'disambiguations-text' => "Žemiau išvardinti puslapiai nurodo į '''daugiaprasmių žodžių puslapius'''.
Nuorodos turėtų būti patikslintos, kad rodytų į konkretų puslapį.<br />
Puslapis laikomas daugiaprasmiu puslapiu, jei jis naudoja šabloną, kuris yra nurodomas iš [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Dvigubi peradresavimai',
	'doubleredirectstext' => 'Šiame puslapyje yra puslapių, kurie nukreipia į kitus peradresavimo puslapius, sąrašas.
Kiekvienoje eilutėje yra nuorodos į pirmąjį ir antrąjį peradresavimą, taip pat antrojo peradresavimo paskirtis, kuris paprastai yra „tikrasis“ paskirties puslapis, į kurį pirmasis peradresavimas ir turėtų rodyti.
<del>Išbraukti</del> įrašai yra išspręsti.',
	'double-redirect-fixed-move' => '[[$1]] buvo perkeltas, dabar tai peradresavimas į [[$2]]',
	'double-redirect-fixed-maintenance' => 'Tvarkomas dvigubas peradresavimas iš [[$1]] į [[$2]].',
	'double-redirect-fixer' => 'Peradresavimų tvarkyklė',
	'deadendpages' => 'Puslapiai-aklavietės',
	'deadendpagestext' => 'Šie puslapiai neturi nuorodų į kitus puslapius šiame projekte.',
	'deletedcontributions' => 'Ištrintas naudotojo indėlis',
	'deletedcontributions-title' => 'Ištrintas naudotojo indėlis',
	'defemailsubject' => '{{SITENAME}} el. pašto iš vartotojo " $1 "',
	'deletepage' => 'Trinti puslapį',
	'delete-confirm' => 'Ištrinti „$1“',
	'delete-legend' => 'Trynimas',
	'deletedtext' => '„$1“ ištrintas.
Paskutinių šalinimų istorija - $2.',
	'dellogpage' => 'Šalinimų istorija',
	'dellogpagetext' => 'Žemiau pateikiamas paskutinių trynimų sąrašas.',
	'deletionlog' => 'šalinimų istorija',
	'deletecomment' => 'Priežastis:',
	'deleteotherreason' => 'Kita/papildoma priežastis:',
	'deletereasonotherlist' => 'Kita priežastis',
	'deletereason-dropdown' => '*Dažnos trynimo priežastys
** Autoriaus prašymas
** Autorystės teisių pažeidimas
** Vandalizmas',
	'delete-edit-reasonlist' => 'Keisti trynimo priežastis',
	'delete-toobig' => 'Šis puslapis turi ilgą keitimų istoriją, daugiau nei $1 {{PLURAL:$1|revizija|revizijos|revizijų}}. Tokių puslapių trynimas yra apribotas, kad būtų išvengta atsitiktinio {{SITENAME}} žlugdymo.',
	'delete-warning-toobig' => 'Šis puslapis turi ilgą keitimų istoriją, daugiau nei $1 {{PLURAL:$1|revizija|revizijos|revizijų}}. Trinant jis gali sutrikdyti {{SITENAME}} duomenų bazės operacijas; būkite atsargūs.',
	'databasenotlocked' => 'Duomenų bazė neužrakinta.',
	'delete_and_move' => 'Ištrinti ir perkelti',
	'delete_and_move_text' => '==Reikia ištrinti==

Paskirties puslapis „[[:$1]]“ jau yra. Ar norite jį ištrinti, kad galėtumėte pervardinti?',
	'delete_and_move_confirm' => 'Taip, trinti puslapį',
	'delete_and_move_reason' => 'Ištrinta dėl perkėlimo iš "[[$1]]"',
	'djvu_page_error' => 'DjVu puslapis nepasiekiamas',
	'djvu_no_xml' => 'Nepavyksta gauti XML DjVu failui',
	'deletedrevision' => 'Ištrinta sena versija $1',
	'days' => '{{PLURAL:$1|$1 dieną|$1 dienas|$1 dienų}}',
	'deletedwhileediting' => 'Dėmesio: Šis puslapis ištrintas po to, kai pradėjote redaguoti!',
	'descending_abbrev' => 'mažėjanti tvarka',
	'duplicate-defaultsort' => 'Įspėjimas: Numatytasis rikiavimo raktas „$2“ pakeičia ankstesnį numatytąjį rikiavimo raktą „$1“.',
	'dberr-header' => 'Ši svetainė turi problemų.',
	'dberr-problems' => 'Atsiprašome! Svetainei iškilo techninių problemų.',
	'dberr-again' => 'Palaukite kelias minutes ir perkraukite puslapį.',
	'dberr-info' => '(Nepavyksta pasiekti duomenų bazės serverio: $1)',
	'dberr-usegoogle' => 'Šiuo metu jūs galite ieškoti per „Google“.',
	'dberr-outofdate' => 'Mūsų turinio kopijos ten gali būti pasenusios.',
	'dberr-cachederror' => 'Tai prašomo puslapio išsaugota kopija, ji gali būti pasenusi.',
);

$messages['ltg'] = array(
	'december' => 'Dekabrs / Zīmys mieness',
	'december-gen' => 'Dekabra / Zīmys mieneša',
	'dec' => 'dek.',
	'delete' => 'Iztreit',
	'deletethispage' => 'Iztreit itū puslopu',
	'disclaimers' => 'Daīšmu nūstatejumi',
	'disclaimerpage' => 'Project:Dasaīšonu nūstateišona',
	'difference' => '(Versiju saleidzynuojums)',
	'datedefault' => 'Piec nūklusiejuma',
	'diff' => 'izmainis',
	'deletepage' => 'Iztreit puslopu',
	'deletedtext' => '"$1" beja iztreits.
Kab apsavērtu pādejuo iztreitū sarokstu, verīs $2.',
	'dellogpage' => 'Iztreišonys registris',
	'deletionlog' => 'iztreišonys registru',
	'deletecomment' => 'Īmesle:',
	'deleteotherreason' => 'Cyta/papyldoma īmesle:',
	'deletereasonotherlist' => 'Cyta īmesle',
	'delete_and_move' => 'Iztreit i puorceļt',
	'delete_and_move_confirm' => 'Nui, iztreit puslopu',
);

$messages['lv'] = array(
	'december' => 'decembrī',
	'december-gen' => 'Decembra',
	'dec' => 'decembrī,',
	'delete' => 'Dzēst',
	'deletethispage' => 'Dzēst šo lapu',
	'disclaimers' => 'Saistību atrunas',
	'disclaimerpage' => 'Project:Saistību atrunas',
	'databaseerror' => 'Datu bāzes kļūda',
	'dberrortext' => 'Konstatēta sintakses kļūda datubāzes pieprasījumā.
Iespējams, tā radusies dēļ kļūdas programmatūrā.
Pēdējais datubāzes pieprasījums bija:
<blockquote><tt>$1</tt></blockquote>
no funkcijas "<tt>$2</tt>".
Datubāzes atgrieztais kļūdas paziņojums: "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Datubāzes vaicājumā pieļauta sintakses kļūda.
Pēdējais priekšraksts:
"$1"
palaists funkcijā "$2".
Izdotā MySQL kļūda: "$3: $4"',
	'directorycreateerror' => 'Nevar izveidot mapi "$1".',
	'deletedhist' => 'Vēsture dzēsta',
	'difference' => '(Atšķirības starp versijām)',
	'difference-multipage' => '(Atšķirības starp lapām)',
	'diff-multi' => '({{PLURAL:$1|Viena starpversija|$1 starpversijas}} no {{PLURAL:$2|viena lietotāja|$2 lietotājiem}} nav parādīta)',
	'datedefault' => 'Vienalga',
	'defaultns' => 'Meklēt šajās palīglapās pēc noklusējuma:',
	'default' => 'pēc noklusējuma',
	'diff' => 'izmaiņas',
	'destfilename' => 'Mērķa faila nosaukums:',
	'download' => 'lejupielādēt',
	'disambiguations' => 'Nozīmju atdalīšanas lapas',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => "Šeit esošajās lapās ir saite uz '''nozīmju atdalīšanas lapu'''.
Šīs saites vajadzētu izlabot, lai tās vestu tieši uz attiecīgo lapu.<br />
Lapu uzskata par nozīmju atdalīšanas lapu, ja tā satur veidni, uz kuru ir saite no [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Divkāršas pāradresācijas lapas',
	'doubleredirectstext' => 'Šajā lapā ir uzskaitītas pāradresācijas lapas, kuras pāradresē uz citām pāradresācijas lapām.
Katrā rindiņā ir saites uz pirmo un otro pāradresācijas lapu, kā arī pirmā rindiņa no otrās pāradresācijas lapas teksta, kas parasti ir faktiskā "gala" lapa, uz kuru vajadzētu būt saitei pirmajā lapā.
<del>Nosvītrotie</del> ieraksti jau ir tikuši salaboti.',
	'double-redirect-fixed-move' => '[[$1]] bija ticis pārvietots, tas tagad ir pāradresācija uz [[$2]]',
	'double-redirect-fixed-maintenance' => 'Labota dubultā pāradresācija no [[$1]] uz [[$2]].',
	'double-redirect-fixer' => 'Pāradresāciju labotājs',
	'deadendpages' => 'Lapas bez izejošām saitēm',
	'deletedcontributions' => 'Izdzēstais lietotāju devums',
	'deletedcontributions-title' => 'Izdzēstais lietotāju devums',
	'defemailsubject' => '{{SITENAME}} e-pasts no lietotāja "$1"',
	'deletepage' => 'Dzēst lapu',
	'delete-confirm' => 'Dzēst "$1"',
	'delete-legend' => 'Dzēšana',
	'deletedtext' => 'Lapa "$1" ir izdzēsta.
Šeit var apskatīties pēdējos izdzēstos: "$2".',
	'dellogpage' => 'Dzēšanas reģistrs',
	'dellogpagetext' => 'Šajā lapā ir pēdējo dzēsto lapu saraksts.',
	'deletionlog' => 'dzēšanas reģistrs',
	'deletecomment' => 'Iemesls:',
	'deleteotherreason' => 'Cits/papildu iemesls:',
	'deletereasonotherlist' => 'Cits iemesls',
	'deletereason-dropdown' => '*Izplatīti dzēšanas iemesli
** Autora pieprsījums
** Autortiesību pārkāpums
** Vandālisms',
	'delete-edit-reasonlist' => 'Izmainīt dzēšanas iemeslus',
	'delete-toobig' => 'Šai lapai ir liela izmaiņu hronoloģija, vairāk nekā $1 {{PLURAL:$1|versija|versijas}}.
Šādu lapu dzēšana ir atslēgta, lai novērstu nejaušus traucējumus {{grammar:lokatīvs|{{SITENAME}}}}.',
	'databasenotlocked' => 'Datubāzē nav bloķēta.',
	'delete_and_move' => 'Dzēst un pārvietot',
	'delete_and_move_text' => '==Nepieciešama dzēšana==
Mērķa lapa "[[:$1]]" jau eksistē.
Vai tu to gribi izdzēst, lai atbrīvotu vietu pārvietošanai?',
	'delete_and_move_confirm' => 'Jā, dzēst lapu',
	'delete_and_move_reason' => 'Izdzēsts, lai atbrīvotu vietu pārvietošanai no "[[$1]]"',
	'djvu_page_error' => 'DjVu lapa ir ārpus diapazona',
	'djvu_no_xml' => 'Neizdevās ielādēt XML DjVu failam',
	'deletedrevision' => 'Izdzēstā vecā versija $1',
	'days' => '{{PLURAL:$1|$1 diena|$1 dienas}}',
	'deletedwhileediting' => "'''Brīdinājums:''' Šī lapa tika izdzēsta, pēc tam, kad tu to sāki izmainīt!",
	'descending_abbrev' => 'dilst.',
	'dberr-header' => 'Šim viki ir problēma',
	'dberr-problems' => 'Atvainojiet!
Šai vietnei ir radušās tehniskas problēmas.',
	'dberr-again' => 'Uzgaidiet dažas minūtes un pārlādējiet šo lapu.',
	'dberr-info' => '(Nevar sazināties ar datubāzes serveri: $1)',
	'dberr-usegoogle' => 'Pa to laiku Jūs varat izmantot Google meklēšanu.',
	'dberr-outofdate' => 'Ņemiet vērā, ka mūsu satura indeksācija var būt novecojusi.',
	'dberr-cachederror' => 'Šī ir lapas agrāk saglabātā kopija, tā var nebūt atjaunināta.',
);

$messages['lzh'] = array(
	'december' => '十二月',
	'december-gen' => '十二月',
	'dec' => '十二月',
	'delete' => '刪',
	'deletethispage' => '刪',
	'disclaimers' => '免責宣',
	'disclaimerpage' => 'Project:免責宣',
	'databaseerror' => '庫藏誤然',
	'dberrortext' => '問庫語誤，或軟體瑕焉。
末語道：
<blockquote><tt>$1</tt></blockquote>
內此函式"<tt>$2</tt>".
庫藏報有誤"<tt>$3: $4</tt>"。',
	'dberrortextcl' => '庫藏問語有誤，末道：
"$1"
內此函式"$2".
庫藏報有誤"$3: $4"',
	'directorycreateerror' => '立目"$1"，未可為也。',
	'deletedhist' => '刪史',
	'difference' => '（辨異）',
	'difference-multipage' => '（辨頁）',
	'diff-multi' => '（$2作未示之審有$1）',
	'diff-multi-manyusers' => '（$2多作未示之審有$1）',
	'datedefault' => '原註',
	'defaultns' => '則尋之名集：',
	'default' => '予定',
	'diff' => '辨',
	'destfilename' => '欲置檔名：',
	'duplicatesoffile' => '下檔重此檔有$1（[[Special:FileDuplicateSearch/$2|詳]]）：',
	'download' => '載下',
	'disambiguations' => '釋義',
	'disambiguations-text' => '頁下引[[MediaWiki:Disambiguationspage]]模，求釋義，宜正題之。',
	'doubleredirects' => '窮渡',
	'doubleredirectstext' => '頁下窮渡，迭列以示。首尾宿合，宜正渡之。
<del>劃</del>已解之。',
	'double-redirect-fixed-move' => '[[$1]]遷畢，現渡至[[$2]]',
	'double-redirect-fixer' => '修渡',
	'deadendpages' => '此無路也',
	'deletedcontributions' => '已刪之積',
	'deletedcontributions-title' => '所棄之事',
	'defemailsubject' => '{{SITENAME}}來書',
	'deletepage' => '刪頁',
	'delete-confirm' => '刪"$1"',
	'delete-legend' => '刪',
	'deletedtext' => '"$1"刪矣，見誌刪於$2。',
	'dellogpage' => '誌刪',
	'dellogpagetext' => '近刪如下：',
	'deletionlog' => '誌刪',
	'deletecomment' => '因：',
	'deleteotherreason' => '另／附之因：',
	'deletereasonotherlist' => '另因',
	'deletereason-dropdown' => '*常刪之因
** 作者之求
** 侵版權
** 破壞',
	'delete-edit-reasonlist' => '纂刪因',
	'delete-toobig' => '此頁含大誌，過$1修。刪頁限矣，防於{{SITENAME}}之亂也。',
	'delete-warning-toobig' => '此頁含大誌，過$1修。刪之可亂{{SITENAME}}之事也；續時留神之。',
	'databasenotlocked' => '庫未閉焉。',
	'delete_and_move' => '刪遷',
	'delete_and_move_text' => '==准刪==

往遷"[[:$1]]"存，刪之以替乎？',
	'delete_and_move_confirm' => '刪之',
	'delete_and_move_reason' => '為遷而刪之',
	'deletedrevision' => '刪舊審$1',
	'deletedwhileediting' => '警：纂中見刪。',
	'descending_abbrev' => '降冪',
	'duplicate-defaultsort' => '警：預之排鍵「$2」蓋前之排鍵「$1」。',
);

$messages['lzz'] = array(
	'december' => 'Xristʼana',
	'december-gen' => 'Xristʼana',
	'dec' => 'Xri',
	'delete' => 'Jili',
	'deletethispage' => 'Am sayfa jili',
	'disclaimers' => 'Kʼabuli na var ixvenu ondepe',
	'disclaimerpage' => 'Project:Mtelot kʼabuli na var ixvenu ondepe',
	'difference' => '(Versiyonepeşi farkʼepe)',
	'diff' => 'farkʼi',
	'deletepage' => 'Butʼkʼa jili',
	'deletedtext' => '"$1" nijilu.
Xolosi oras jileri na renanpe oz*iru şeni: $2.',
	'dellogpage' => 'Ojiluşi kʼayitʼepe',
	'deletecomment' => 'Muşen:',
	'deleteotherreason' => 'Majurani/ilave sebebi:',
	'deletereasonotherlist' => 'Majurani sebebepe',
);

$messages['mai'] = array(
	'december' => 'दिसंबर',
	'december-gen' => 'दिसंबर',
	'dec' => 'दिस.',
	'delete' => 'मेटाउ',
	'deletethispage' => 'ई पन्ना मेटाउ',
	'disclaimers' => 'अनाधिकार घोषणा',
	'disclaimerpage' => 'Project:अनाधिकार घोषणा',
	'databaseerror' => 'दत्तनिधि भ्रम',
	'dberrortext' => 'एकटा दत्तनिधि अभ्यर्थना क्रम भंग भेल अछि।
ई तंत्रांशमे एकटा दोषक संकेत अछि।
अन्तिम बेर प्रयास कएल दत्तनिधि अभ्यर्थना रहए:
<blockquote><tt>$1</tt></blockquote>
प्रकार्यक अन्तर्गत "<tt>$2</tt>". ।
दत्तनिधि ई दोष देखेलक "<tt>$3: $4</tt>" ।',
	'dberrortextcl' => 'एकटा दत्तनिधि अभ्यर्थना क्रम भंग भेल अछि।
अन्तिम बेर प्रयास कएल दत्तनिधि अभ्यर्थना अछि:
"$1"
"$2" प्रकार्यक अन्तर्गत।
दत्तनिधि दोष देखेलक "$3: $4"',
	'directorycreateerror' => 'विभाग "$1" नै बना सकल।',
	'deletedhist' => 'मेटाएल इतिहास',
	'difference' => '(नव संशोधन सभक बीच अन्तर)',
	'difference-multipage' => '(पन्ना सभक बीचमे अन्तर)',
	'diff-multi' => '({{PLURAL:$1|मध्यबला संशोधन|$1 मध्यबला संशोधन सभ}} द्वारा {{PLURAL:$2|एकटा प्रयोक्ता|$2 प्रयोक्ता सभ}} नै देखाएल)',
	'diff-multi-manyusers' => '({{PLURAL:$1|एकटा मध्यस्थ संशोधन|$1 मध्यस्थ संशोधन सभ}} $2 सँ बेसी {{PLURAL:$2|प्रयोक्ता|प्रयोक्ता सभ}} नै देखाएल)',
	'datedefault' => 'कोनो मोनपसंद नै',
	'defaultns' => 'नै तँ ऐ नामस्थान सभमे ताकू:',
	'default' => 'पूर्वनिर्धारित',
	'diff' => 'अंतर',
	'destfilename' => 'लक्ष्य संचिकानाम:',
	'duplicatesoffile' => 'ऐ संचिकाक {{PLURAL:$1|file is a duplicate|$1 संचिका सभ द्वितीयक अछि}} अछि ([[Special:FileDuplicateSearch/$2|आर वर्णन]]):',
	'download' => 'अवारोपन',
	'disambiguations' => 'स्पष्ट पन्नासँ लागिबला पन्ना',
	'disambiguationspage' => 'नमूना: निवारण',
	'disambiguations-text' => "ई सभ पन्ना '''स्पष्ट कएल''' सँ लागिमे अछि।
ओ सभ एकर बदला उचित वार्तापर लागि करथि।<br />
[[MediaWiki:Disambiguationspage]] सँ लागिमे जँ नमूनाक प्रयोग करैत अछि तखने ओ  '''स्पष्ट कएल'''  पन्ना कहाएत।",
	'doubleredirects' => 'द्वितीयक लागिबला बदलेन',
	'doubleredirectstext' => 'ई पन्ना ओइ पन्ना सभक संकलन छी जे बदलेन करैए दोसर बदलेनबला पन्नासँ।
प्रत्येक पाँती पहिल आ दोसर बदलेनक लागि रखने अछि आ संगे दोसर बदलेनक लक्ष्य सेहो, जे वास्तवमे "वास्तव" लक्ष्य पन्ना अछि, जकरापर पहिल बदलेनकेँ जेबाक चाही।
 <del>Crossed out</del> प्रविष्टिक हल भेटल अछि।',
	'double-redirect-fixed-move' => '[[$1]] घसकाएल गेल।
ई आब [[$2]] दिस जा रहल अछि।',
	'double-redirect-fixed-maintenance' => 'द्वितीयक बदलेन [[$1]] सँ [[$2]] कएल गेल।',
	'double-redirect-fixer' => 'बदलेन स्थायित्व',
	'deadendpages' => 'एकदमसँ अन्त भऽ जाएबला पन्ना सभ',
	'deadendpagestext' => 'ई पन्ना सभ {{अन्तर्जाल}} क दोसर पन्नासँ लागिमे नै रहत।',
	'deletedcontributions' => 'मेटाएल प्रयोक्ता योगदान सभ',
	'deletedcontributions-title' => 'मेटाएल प्रयोक्ता योगदान सभ',
	'defemailsubject' => '{{जालस्थल}} प्रयोक्ता "$1" सँ ई-पत्र',
	'deletepage' => 'पन्ना मेटाउ',
	'delete-confirm' => '$1 केँ मेटाउ',
	'delete-legend' => 'मेटाउ',
	'deletedtext' => '"$1" केँ मेटा देल गेल अछि।
देखू $2 हालक मेटाएल सामिग्रीक अभिलेख लेल।',
	'dellogpage' => 'मेटाएल सामिग्रीक वृत्तलेख',
	'dellogpagetext' => 'नीचाँ एकदम हालक मेटाएलबला सूची अछि।',
	'deletionlog' => 'मेटाएल सामिग्रीक वृत्तलेख',
	'deletecomment' => 'कारण:',
	'deleteotherreason' => 'दोसर/ अतिरिक्त कारण:',
	'deletereasonotherlist' => 'दोसर कारण',
	'deletereason-dropdown' => '* सामान्य हटेबाक कारण
** लेखक आग्रह
** सर्वाधिकार उल्लंघन
** बिना मतलबक काँट-छाँट',
	'delete-edit-reasonlist' => 'मेटेबाक कारणक सम्पादन करू',
	'delete-toobig' => 'ऐ पन्नामे बड्ड बेसी सम्पादन इतिहास अछि, $1 सँ बेसी {{PLURAL:$1|revision|revisions}}।
ओइ सभ पन्नाक मेटाएब प्रतिबन्धित कएल गेल अछि जइसँ आकस्मिक क्षति नै हुअए {{जालस्थलक}}।',
	'delete-warning-toobig' => 'ऐ पन्नामे बड्ड सम्पादन इतिहास अछि, $1 सँ बेसी {{PLURAL:$1|revision|revisions}}।
एकरा मेटेलापर दत्तनिधि क्रिया {{जालस्थल}} खतरामे पड़त;
सतर्कीसँ आगाँ बढ़ू।',
	'databasenotlocked' => 'दत्तांशनिधि प्रतिबन्धित नै अछि।',
	'delete_and_move' => 'मेटाउ आ हटू',
	'delete_and_move_text' => '==हटाबैक जरूरत==
लक्ष्य पृष्ठ "[[:$1]]" पहिने सें अस्तित्व में अछि.
नाम के बदलहि ले की अहां एकरा हटाबय चाहैत छी ?',
	'delete_and_move_confirm' => 'हँ, पन्ना मेटाउ',
	'delete_and_move_reason' => '"[[$1]]" सँ घसकेबा लेल जगह बनेबा लेल मेटाएल गेल',
	'djvu_page_error' => 'डेजावू पन्ना सकक बाहर अछि',
	'djvu_no_xml' => 'डेजावू संचिकाक एक्स.एम.एल. नै आनि सकलौं',
	'deletedrevision' => 'पुरान संशोधन $1 हटा देलौं',
	'days-abbrev' => '$1d',
	'days' => '{{PLURAL:$1|$1 दिन|$1 दिन}}',
	'deletedwhileediting' => "'''Warning''': अहां जखन सें संपादन शुरू केने छी, ओकर बाद से ई पृष्ठ के मिटा देल गेल अछि.",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => '\'\'\'चेतौनी:\'\'\' पूर्वनिर्धारित विन्यास चाभी "$2" पहिलुका पूर्वनिर्धारित विन्यास चाभी "$1" केँ खतम करैए।',
	'dberr-header' => 'ऐ विकीमे एकटा समस्या अछि',
	'dberr-problems' => 'दुखी छी!
ई जालस्थल तकनीकी समस्या अनुभव कऽ अछि।',
	'dberr-again' => 'किछु काल बाट ताकू आ फेरसँ भारित करू।',
	'dberr-info' => '(दत्तनिधि वितरककेँ सम्पर्क नै कऽ सकल: $1)',
	'dberr-usegoogle' => 'ऐ बीचमे अहाँ गूगलसँ खोज कऽ सकै छी।',
	'dberr-outofdate' => 'मोन राखू जे हमर सामिग्रीक ओकर सूची पुरान भऽ सकैए।',
	'dberr-cachederror' => 'ई आग्रह कएल पन्नाक उपस्मृति संरक्षित द्वितीयक अछि, आ भऽ सकैए जे अद्यतन नै हुअए।',
);

$messages['map-bms'] = array(
	'december' => 'Desember',
	'december-gen' => 'Desember',
	'dec' => 'Des',
	'delete' => 'Busek',
	'deletethispage' => 'Busak kaca kiye',
	'disclaimers' => 'Pamaidonan',
	'disclaimerpage' => 'Project:Panyangkalan umum',
	'databaseerror' => 'Kasalahan basis data',
	'dberrortext' => 'Ana kesalahan sintaksnang penjalukan basis data.
Kesalahan kiye ndeyan nandakna nek ana \'\'bug\'\' nang piranti alus.
Penjalukan basis data sing pungkasan yakuwe:
<blockquote><tt>$1</tt></blockquote>
sekang jerone fungsi "<tt>$2</tt>".
Basis data ngasilna kesalahan "<tt>$3: $4</tt>".',
	'directorycreateerror' => 'Ora teyeng nggawé dirèktori "$1".',
	'deletedhist' => 'Sajarah sing dibusak',
	'difference' => '(Prabédan antarrevisi)',
	'difference-multipage' => '(Prabedan antarkaca)',
	'diff-multi' => 'Ana ({{PLURAL:$1|Siji|$1}} revisi antara sekang {{PLURAL:$2|siji|$2}} panganggo sing ora ditidokna)',
	'diff-multi-manyusers' => 'Ana ({{PLURAL:$1|Siji|$1}} revisi antara gaweane lewih sekang {{PLURAL:$2|siji|$2}} panganggo sing ora ditidokna)',
	'datedefault' => 'Ora ana préferènsi',
	'defaultns' => 'Utawa goleti nang bilik jeneng kiye:',
	'default' => 'baku',
	'diff' => 'bédane',
	'disambiguations' => 'Kaca sing nggandeng maring kaca disambiguasi',
	'disambiguationspage' => 'Template:Disambig',
	'disambiguations-text' => "Kaca-kaca kiye nduwe pranala maring '''kaca disambiguasi'''.
Kaca-kaca kuwe kudune nggandeng maring topik sing bener/pas.<br />
Sawijining kaca bakal dianggep dadi kaca disambiguasi angger nggunakna cithakan sing nggandeng maring
[[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Pangalihan dobel',
	'doubleredirectstext' => 'Kaca kiye muat daftar kaca sing dialihna maring kaca pangalihan liyane.
Saben barise nduwe pranala maring pangalihan pertama lan kepindho, lan tujuan sekang pengalihan kepindho sing biasane kuwe kaca tujuan sing "sebenere", sing kudune dadi tujuane kaca pangalihan pertama.
 Tembung sing <del>dicorèk</del> artine kuwe wis rampung didandani.',
	'double-redirect-fixed-move' => '[[$1]] uwis dipindahna.
Kiye sekiye dialihna maring [[$2]].',
	'double-redirect-fixed-maintenance' => 'Mbenerna pangalihan dobel sekang [[$1]] maring [[$2]].',
	'double-redirect-fixer' => 'Révisi pangalihan',
	'deadendpages' => 'Kaca-kaca buntu (tanpa pranala)',
	'deadendpagestext' => 'Kaca-kaca kiye ora duwe pranala maring kaca liyane nang {{SITENAME}}.',
	'delete-confirm' => 'Busek "$1"',
	'delete-legend' => 'Busek',
	'deletedtext' => '"$1" uwis dibusek.
Deleng $2 nggo log/cathetan pambusekan paling anyar.',
	'dellogpage' => 'Log pambusakan',
	'dellogpagetext' => 'Nang ngisor kiye kuwe daftar pambusekan sing paling anyar.',
	'deletionlog' => 'Log pambusekan',
	'deletecomment' => 'Alesan:',
	'deleteotherreason' => 'Alesan liyane/tambahan:',
	'deletereasonotherlist' => 'Alesan liyane',
	'deletereason-dropdown' => '*Alesan pembusekan sing umum
** Penjaluke sing nulis
** Nglanggar Hak Cipta
** Vandalisme',
	'delete-edit-reasonlist' => 'Sunting alesan pembusekan',
	'delete-toobig' => 'Kaca kiye nduwe sejarah panyuntingan sing dawa, lewih sekang $1 {{PLURAL:$1|revisi|revisi}}.
Mbusek kaca sing kaya kiye ora kena dilakokna nggo menggak karusakan nang {{SITENAME}}.',
	'delete-warning-toobig' => 'Kaca kiye duwé sajarah panyuntingan sing dawa, lewih sekang $1 {{PLURAL:$1|révisi|révisi}}.
Mbusek kaca kiye teyeng ngrusak operasi basis data nang {{SITENAME}};
kudu ngati-ati.',
	'delete_and_move' => 'Busek lan pindahna',
	'delete_and_move_text' => '== Perlu mbusek ==
Kaca sing dituju "[[:$1]]" wis ana isine.
Apa Rika kepengin mbusek kuwe ben teyeng dipindahna?',
	'delete_and_move_confirm' => 'Ya, busek kaca kuwe',
	'delete_and_move_reason' => 'Dibusek nggo gawe dalan nggo mindah sekang "[[$1]]"',
	'duplicate-defaultsort' => "'''Pènget:''' Kunci baku sing nggo ngurutna (''Default sort key'') yakuwe \"\$2\" wis nggantèkna kunci baku sing nggo ngurutna sedurungé \"\$1\".",
);

$messages['mdf'] = array(
	'december' => 'Кучкаков',
	'december-gen' => 'Кучкаковонь',
	'dec' => 'Куч',
	'delete' => 'Нардамс',
	'deletethispage' => 'Нардамс тя лопать',
	'disclaimers' => 'Видешинь корхтаматне',
	'disclaimerpage' => 'Project:Пря видешинь корхнема',
	'databaseerror' => 'Датабаза эльбятькс',
	'dberrortext' => 'Датабазань вешендембачк лиссь синтакс эльбятькс.
Тя, улема, програмонь эльбятькс.
Мекольце датабазонь вешендема ульсь:
<blockquote><tt>$1</tt></blockquote>
функциеста "<tt>$2</tt>".
Датабазась мърдафтозе эльбятьксть "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Датабазонь вешендембачк лиссь синтакс эльбятькс.
Мекольце датабазонь вешендема ульсь:
"$1"
функциеста "$2".
Датабазась мърдафтозе эльбятьксть "$3: $4"',
	'directorycreateerror' => 'Директорие "$1" аф тиеви.',
	'deletedhist' => 'Нардаф историяц',
	'difference' => '(Явомась верзиетнень ёткова)',
	'difference-multipage' => 'Явомась лопаланготнень ёткова',
	'diff-multi' => '({{PLURAL:$1|$1-нь ётконь верзиец изь няфтев|$1-нь ётконь верзиенза исть няфтев}}.)',
	'datedefault' => 'Апак полафтт',
	'defaultns' => 'Илякс вешентть ня лемботмова:',
	'default' => 'апак полафтт',
	'diff' => 'яв.',
	'destfilename' => 'Сувафтома файлонь лемоц',
	'duplicatesoffile' => 'Сай {{PLURAL:$1|файлсь ащи кафонзафксокс|$1 файлхне ащихть кафонзафксокс}} тя файлонди ([[Special:FileDuplicateSearch/$2|сяда лама информацие]]):',
	'download' => 'тонгомс',
	'disambiguations' => 'Лама смузьса лопат',
	'disambiguationspage' => 'Template:лама смусть',
	'disambiguations-text' => "Ня лопатне сюлмафт '''лама смузень лопа''' мархта. Синьдеест эрявихть сюлмамс иля башка сёрмафкснень мархта.<br />Лопась лувови лама смузеннекс мъзярда сон сюлмаф [[MediaWiki:Disambiguationspage]] кепотькс мархта.",
	'doubleredirects' => 'Кафонзаф умборондафтфксне',
	'doubleredirectstext' => 'Тя лопань лувомаса няфтевихть умборондафтфксне сюлмафт иля умборондафтфкснень мархта. Эрь луфксса (строкаса) улихть васенце ди омбоце умборондафтфкснень сюлмафкссна, тяса тага ули омбоце умборондафтфксонь васенце киксонцты сюлмафкссь, тоса ули няфтемась лопань лемонц лангс конань мархта эряволь васенце умборондафтфксть сюлмафтомс.
<del>Туркс кикс мархта</del> тяшксне латцефольхть.',
	'double-redirect-fixed-move' => '[[$1]] шашфтфоль, сон тяни [[$2]]нь умборондафтфксоц',
	'double-redirect-fixer' => 'Умборондафтфксонь латцема',
	'deadendpages' => 'Полатксфтома лопат',
	'deadendpagestext' => 'Ся лопат аф сюлмафт иля лопатнень мархта {{SITENAME}}-са.',
	'deletedcontributions' => 'Нардаф тиихнень путкссна',
	'deletedcontributions-title' => 'Нардаф тиихнень путкссна',
	'defemailsubject' => '{{SITENAME}}-нь электрононь сёрма',
	'deletepage' => 'Нардамс лопать',
	'delete-confirm' => 'Нардамс "$1"',
	'delete-legend' => 'Нардамс',
	'deletedtext' => 'Лопась "$1" нардафоль. Ванк $2 мекольце нардаматнень няфтеманкса.',
	'dellogpage' => 'Нардамань лувома',
	'dellogpagetext' => 'Ватт сяда мекольце нардаматнень лувомась ала.',
	'deletionlog' => 'нардамань лувома',
	'deletecomment' => 'Туфтал:',
	'deleteotherreason' => 'Лия/поладомань туфтал:',
	'deletereasonotherlist' => 'Иля туфтал',
	'deletereason-dropdown' => '*Марстонь нардама туфталхт
** Тиить вешфкссь
** Копияма видексть сърафтома
** Колендемась',
	'delete-edit-reasonlist' => 'Петнемс нардамань туфталхне',
	'delete-toobig' => 'Тя лопать кувака петнемань историясь, $1 {{PLURAL:$1|верзиеда|верзиеда}} лама. Тяфтама лопатнень нардамась кардаф {{SITENAME}}-нь уф учсеви колавомада араламать туфталонкса.',
	'delete-warning-toobig' => 'Тя лопать кувака петнемань историясь, $1 {{PLURAL:$1|верзиеда|верзиеда}} лама. Сонь нардамаста, улема, лиси {{SITENAME}}-нь датабаза якаманц колавомась; тик тянь инголе арьсезь.',
	'databasenotlocked' => 'Датабазась аф пякстаф.',
	'delete_and_move' => 'Нардамс эди од вастс шашфтомс',
	'delete_and_move_text' => '==Нардамась вешф==
Эрявкстовсь лопа "[[:$1]]" ульсь ни.
Мяльце нардамонза од вастс шашфтомань шумордаманкса?',
	'delete_and_move_confirm' => 'Ина, нардак лопать',
	'delete_and_move_reason' => 'Нардаф од вастс шашфтомань шумордамонкса',
	'djvu_page_error' => 'DjVu лопась аф сатови',
	'djvu_no_xml' => 'Аш кода латцемс XML DjVu файлти',
	'deletedrevision' => 'Нардаф сире илякстоптома $1',
	'deletedwhileediting' => "'''Инголе кардама''': Тя лопась нардафоль ёт тон кармать петнеманза!",
	'descending_abbrev' => 'тум.',
	'duplicate-defaultsort' => 'Инголе мярьгома: Апак полафтт сортонь панжема "$2" апак полафтт сортонь панжема "$1"да вяре.',
);

$messages['mg'] = array(
	'december' => 'Desambra',
	'december-gen' => 'Desambra',
	'dec' => 'Des',
	'delete' => 'Hamafa',
	'deletethispage' => 'Fafao ity pejy ity',
	'disclaimers' => 'Fampitandremana',
	'disclaimerpage' => 'Project:General disclaimer',
	'databaseerror' => "Tsy fetezana eo amin'ny toby",
	'dberrortext' => 'Nisy tsy fetezana ao amin\'ny fangatahana tany amin\'ny database.
Inoana fa ny rindrankajy no misy olana (bug).
Ny fangatahana farany dia:
<blockquote><tt>$1</tt></blockquote>
tao amin\'ny tao "<tt>$2</tt>".
Toy izao no navalin\'ny MySQL "<tt>$3: $4</tt>".',
	'dberrortextcl' => "Ao amin'ny fangatahana tao amin'ny banky angona dia misy tsi-fetezana ara-pehezanteny.
Ny fangatahana farany nalefa dia :
« $1 »
tao amin'ny asa « $2 ».
Ny banky angona dia namerina ny tsi-fetezana « $3 : $4 »",
	'directorycreateerror' => "Tsy afaka amboarina ny petra-drakitra (''dossier, directory'') « $1 ».",
	'deletedhist' => 'Tantara voafafa',
	'difference' => "(Fahasamihafan'ny pejy)",
	'difference-multipage' => "(Fahasamihafan'ny pejy)",
	'diff-multi' => "({{PLURAL:$1|Famerenana tokana|Famerenana $1}} nataon'ny {{PLURAL:$2|mpikambana iray|mpikambana $2}} tsy miseho)",
	'datedefault' => 'Tsy misy safidy',
	'defaultns' => "Fikarohana tsipalotra anatin'ireo anaran-tsehatra ireo :",
	'default' => 'tsipalotra',
	'diff' => 'Fampitahana',
	'destfilename' => "Anaran'ny rakitra:",
	'download' => 'Hampidina',
	'disambiguations' => 'pejina homonimia',
	'disambiguationspage' => 'Template:homonimia',
	'doubleredirects' => 'Fihodinana roa',
	'double-redirect-fixed-move' => "Ity fihodinana ity, nanana ny tanjona [[$1]] novaina anarana, dia mitondra mankany amin'ny [[$2]].",
	'double-redirect-fixer' => 'Mpanitsy fihodinana',
	'deadendpages' => 'Pejy tsy mirohy',
	'deadendpagestext' => "Tsy misy rohy mitondra makany amin'ny pejin'ny wiki hafa ireo pejy ireo.",
	'deletedcontributions' => "Fandraisan'anjara voafafa",
	'deletedcontributions-title' => "fandraisan'anjara voafafa",
	'defemailsubject' => "imailaka avy amin'ny sehatra {{SITENAME}}",
	'deletepage' => 'Hamafa ny pejy',
	'delete-confirm' => 'Hamafa ny « $1 »',
	'delete-legend' => 'Fafao',
	'deletedtext' => 'Voafafa i "$1".
Jereo amin\'ny $2 ny lisitry ny famafana pejy faramparany.',
	'dellogpage' => 'Laogim-pamafana pejy',
	'dellogpagetext' => 'Eto ambany eto ny lisitry ny famafana pejy/sary faramparany.',
	'deletionlog' => 'laogim-pamafàna',
	'deletecomment' => 'Antony :',
	'deleteotherreason' => 'antony hafa miampyy:',
	'deletereasonotherlist' => 'antony',
	'deletereason-dropdown' => "* Antom-pamafana matetika miasa
** Hataka avy amin'ny tompony
** Tsi-fanajana ny zom-pamorona
** Fandotoana",
	'delete-edit-reasonlist' => 'Hanova ny antony amafana pejy',
	'delete-toobig' => 'Ity pejy  ity dia manana tantaram-panovana be, mihoatra ny santiôna {{PLURAL:$1}} $1.
Ny famafana ireo pejy ireto dia voafetra mba tsy hikorontana {{SITENAME}}.',
	'delete-warning-toobig' => "Lava be mihitsy ny tantaram-piovan'ity pejy ity, mihoatra santiôna $1{{PLURAL:}}.
Mety hitondra fikorontanana ao amin'ny banky angon'i {{SITENAME}} ny famafana azy ;
ataovy am-pitandremana ity tao ity.",
	'databasenotlocked' => 'Tsy voaidy ny banky angona.',
	'delete_and_move' => 'Ovay toerana dia fafao',
	'delete_and_move_text' => '==Mila fafàna==

Efa misy ny lahatsoratra hoe "[[:$1]]". Irinao ve ny hamafana azy mba hahafahana mamindra toerana ity lahatsoratra ity?',
	'delete_and_move_confirm' => 'Eny, fafao io pejy io',
	'delete_and_move_reason' => 'Fafao mba hamindrana toerana ny anankiray',
	'djvu_page_error' => "Pejy DjVu any ivelan'ny fetra",
	'djvu_no_xml' => "Tsy afaka alaina ny XML ho an'ny rakitra DjVu",
	'deletedrevision' => "Fanovana an'i $1 taloha voafafa.",
	'deletedwhileediting' => 'Fampitandremana: Nisy namafa ity pejy ity raha mbola teo am-panovana azy ianao!',
	'descending_abbrev' => 'mihid.',
	'duplicate-defaultsort' => '\'\'\'Tandremo\'\'\' : manitsaka ny sort key taloha "$1" ilay sort key ankehitriny "$2".',
	'dberr-header' => 'Misy olana io wiki io',
	'dberr-problems' => 'Azafady Tompoko ! Manana olana ara-teknika ny sehatra.',
	'dberr-again' => 'Miandrasa minitra vitsivitsy ary alefaso fanindroany',
	'dberr-info' => "(Tsy afaka mifandray amin'ny lohamilin'ny database : $1)",
	'dberr-usegoogle' => "Afaka manandrana mikaroka eo amin'ny Google ianao mandritra izay.",
	'dberr-cachederror' => 'Izy io dia dika nasitriky ny pejy nangatahana ary mety efa tola.',
);

$messages['mhr'] = array(
	'december' => 'Теле',
	'december-gen' => 'Теле',
	'dec' => 'Теле',
	'delete' => 'Шӧраш',
	'deletethispage' => 'Тиде лаштыкым шӧраш',
	'disclaimers' => 'Вуйшиймаш деч кораҥмаш',
	'disclaimerpage' => 'Project:Вуйшиймаш деч кораҥмаш',
	'deletedhist' => 'Шӧрымо эртымгорно',
	'difference' => '(Тӱрлык-влакын ойыртемышт)',
	'default' => 'ойлыде',
	'diff' => 'ойырт.',
	'deletepage' => 'Лаштыкым шӧраш',
	'delete-confirm' => 'Шӧраш "$1"',
	'delete-legend' => 'Шӧраш',
	'deletedtext' => '«$1» шӧрымӧ.
Ончо $2 пытартыш шӧрымӧ-влак лӱмер гыч.',
	'dellogpage' => 'Шӧрымӧ нерген журнал',
	'deletionlog' => 'шӧрымӧ нерген журнал',
	'deletecomment' => 'Амал:',
	'deleteotherreason' => 'Вес/ешартыш амал:',
	'deletereasonotherlist' => 'Вес амал',
);

$messages['mi'] = array(
	'december' => 'Hakihea',
	'delete' => 'tangohia',
);

$messages['min'] = array(
	'december' => 'Desember',
	'december-gen' => 'Desember',
	'dec' => 'Des',
	'delete' => 'Hapuih',
	'deletethispage' => 'Hapuih laman iko',
	'disclaimers' => 'Penyangkalan',
	'disclaimerpage' => 'Project:Penyangkalan umum',
	'databaseerror' => 'Kasalahan basis data',
	'dberrortext' => 'Ado kasalahan sintaks pado pamintaan basis data.
Kasalahan ini mungkin manandokan adonyo sabuah \'\'bug\'\' dalam parangkek lunak.
Pamintaan basis data nan tarakhir adalah:
<blockquote><tt>$1</tt></blockquote>
dari dalam fungsi "<tt>$2</tt>".
Basis data manghasilkan kasalahan "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ado kasalahan sintaks pado pamintaan basis data.
Pamintaan basis data nan terakhir adalah:
"$1"
dari dalam fungsi "$2".
Basis data manghasilkan kasalahan "$3: $4".',
	'directorycreateerror' => 'Indak dapek mambuek direktori "$1".',
	'difference' => '(Parbedaan antaro revisi)',
	'diff-multi' => '({{PLURAL:$1|ciek |$1 revisi antaro}} oleh {{PLURAL:$2|ciek|$2 pangguno}} indak ditampilkan)',
	'diff' => 'beda',
	'disambiguationspage' => 'Template:disambig',
	'deletepage' => 'Hapuih laman',
	'deletedtext' => '"$1" lah dihapuih.
Lihek $2 untuak rekam jejak laman yang lah dihapuih.',
	'dellogpage' => 'Log penghapusan',
	'deletecomment' => 'Alasan:',
	'deleteotherreason' => 'Alasan lain/tambahan:',
	'deletereasonotherlist' => 'Alasan lain',
	'duplicate-defaultsort' => '\'\'\'Peringatan:\'\'\' Kunci panguruitan default "$2" sabalunnyo maabaikan kunci panguruitan default "$1".',
);

$messages['mk'] = array(
	'december' => 'декември',
	'december-gen' => 'декември',
	'dec' => 'дек',
	'delete' => 'Избриши',
	'deletethispage' => 'Избриши ја оваа страница',
	'disclaimers' => 'Услови на употреба',
	'disclaimerpage' => 'Project:Услови на употреба',
	'databaseerror' => 'Грешка во базата',
	'dberrortext' => 'Синтаксна грешка во барањето до базата.
Ова може да значи грешка во програмската опрема.
Последното барање до базата беше:
<blockquote><tt>$1</tt></blockquote>
од функцијата „<tt>$2</tt>“.
Вратена е грешката „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Грешка во барањето до базата.
Последното барање до базата беше:
„$1“
од функцијата „$2“.
Вратена е следната грешка „$3: $4“.',
	'directorycreateerror' => 'Не можеше да се создаде именикот „$1“.',
	'deletedhist' => 'Историја на бришења',
	'difference' => '(Разлика меѓу ревизија)',
	'difference-multipage' => '(Разлики помеѓу страници)',
	'diff-multi' => '({{PLURAL:$1|Не е прикажана една меѓувремена ревизија|Не се прикажани $1 меѓувремени ревизии}} од {{PLURAL:$2|еден корисник|$2 корисници}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Не е прикажана една меѓувремена ревизија направена|Не се прикажани $1 меѓувремени ревизии направени}} од повеќе од $2 {{PLURAL:$2|корисник|корисници}})',
	'datedefault' => 'Небитно',
	'defaultns' => 'Инаку пребарувај во овие именски простори:',
	'default' => 'по основно',
	'diff' => 'разл',
	'destfilename' => 'Целно име на податотеката:',
	'duplicatesoffile' => '{{PLURAL:$1|Следната податотека е дупликат|$1 Следните податотеки се дупликати}} на оваа податотека ([[Special:FileDuplicateSearch/$2|повеќе информации]]):',
	'download' => 'преземи',
	'disambiguations' => 'Страници што водат до страници за појаснување',
	'disambiguationspage' => 'Template:Појаснување',
	'disambiguations-text' => "Следните страници имаат врски кои водат до '''страница за појаснување'''.
Наместо тоа тие треба да водат до соодветната тема.<br />
Страница се третира како страница за појаснување ако таа го користи шаблонот кој е наведен [[MediaWiki:Disambiguationspage|тука]]",
	'doubleredirects' => 'Двојни пренасочувања',
	'doubleredirectstext' => 'Оваа страница ги прикажува пренасочувачките страници до други пренасочувачки страници.
Секој ред содржи врски кон првото и второто пренасочување, како и целта на второто пренасочување, кое обично ја посочува <i>вистинската</i> целна страница кон која првото пренасочување би требало да насочува.
<del>Пречкртаните</del> ставки треба да се разрешат.',
	'double-redirect-fixed-move' => 'Страницата [[$1]] е преместена.
Сега пренасочува кон [[$2]]',
	'double-redirect-fixed-maintenance' => 'Исправка на двојно пренасочување од [[$1]] на [[$2]].',
	'double-redirect-fixer' => 'Исправувач на пренасочувања',
	'deadendpages' => 'Ќорсокак страници',
	'deadendpagestext' => 'Следните страници немаат врски кон ниту една друга страница на ова вики.',
	'deletedcontributions' => 'Избришани кориснички придонеси',
	'deletedcontributions-title' => 'Избришани кориснички придонеси',
	'defemailsubject' => '{{SITENAME}} — писмо од корисникот „$1“',
	'deletepage' => 'Избриши страница',
	'delete-confirm' => 'Избриши „$1“',
	'delete-legend' => 'Бришење',
	'deletedtext' => '„$1“ е избришана. Евиденција на скорешните бришења ќе најдете на $2.',
	'dellogpage' => 'Дневник на бришења',
	'dellogpagetext' => 'Подолу е наведен список на најновите бришења.',
	'deletionlog' => 'дневник на бришењата',
	'deletecomment' => 'Причина:',
	'deleteotherreason' => 'Друга/дополнителна причина:',
	'deletereasonotherlist' => 'Друга причина',
	'deletereason-dropdown' => '*Вообичаени причини за бришење
** На барање на авторот
** Прекршување на авторски права
** Вандализам',
	'delete-edit-reasonlist' => 'Уредување на причини за бришење',
	'delete-toobig' => 'Оваа страница има долга историја на уредување, преку $1 {{PLURAL:$1|ревизија|ревизии}}.
Бришењето на ваквии страници е забрането со цел {{SITENAME}} да се заштити од оштетувања.',
	'delete-warning-toobig' => 'Оваа страница има долга историја на уредување, преку $1 {{PLURAL:$1|ревизија|ревизии}}.
Бришењето може да предизвика проблеми при работењето на базата на податоци на {{SITENAME}};
продолжете доколку сте сигруни дека треба тоа да го сторите.',
	'databasenotlocked' => 'Базата не е заклучена.',
	'delete_and_move' => 'Избриши и премести',
	'delete_and_move_text' => '==Потребно бришење==
Целната статија „[[:$1]]“ веќе постои.
Дали сакате да ја избришете за да ослободите место за преместувањето?',
	'delete_and_move_confirm' => 'Да, избриши ја страницата',
	'delete_and_move_reason' => 'Избришано за да се ослободи место за преместувањето од „[[$1]]“',
	'djvu_page_error' => 'Недостапна DjVu страница',
	'djvu_no_xml' => 'Не е можно да се излачи XML за DjVu податотеки',
	'deletedrevision' => 'Избришана стара ревизија $1.',
	'days-abbrev' => '$1 д',
	'days' => '{{PLURAL:$1|$1 ден|$1 дена}}',
	'deletedwhileediting' => "'''Предупредување''': Оваа страница беше избришана откако почнавте со нејзино уредување!",
	'descending_abbrev' => 'опаѓ',
	'duplicate-defaultsort' => 'Предупредување: Основниот клуч за подредување „$2“ го поништува претходниот основен клуч за подредување „$1“.',
	'dberr-header' => 'Ова вики не функционира како што треба',
	'dberr-problems' => 'Жалиме! Ова мрежно место се соочува со технички потешкотии.',
	'dberr-again' => 'Почекајте неколку минути и обидете се повторно.',
	'dberr-info' => '(Не може да се добие опслужувачот на базата на податоци: $1)',
	'dberr-usegoogle' => 'Во меѓувреме можете да се обидете да пребарувате со Google.',
	'dberr-outofdate' => 'Да напоменеме дека нивните индекси на нашата содржина можат да бидат застарени.',
	'dberr-cachederror' => 'Следнава содржина е кеширана копија на бараната страница, која може да е застарена.',
);

$messages['ml'] = array(
	'december' => 'ഡിസംബർ',
	'december-gen' => 'ഡിസംബർ',
	'dec' => 'ഡിസം.',
	'delete' => 'മായ്ക്കുക',
	'deletethispage' => 'ഈ താൾ നീക്കം ചെയ്യുക',
	'disclaimers' => 'നിരാകരണങ്ങൾ',
	'disclaimerpage' => 'Project:പൊതുനിരാകരണം',
	'databaseerror' => 'ഡാറ്റാബേസ് പിഴവ്',
	'dberrortext' => 'ഒരു വിവരശേഖര അന്വേഷണത്തിന്റെ ഉപയോഗക്രമത്തിൽ പിഴവ് സംഭവിച്ചിരിക്കുന്നു.
ഇത് ചിലപ്പോൾ സോഫ്റ്റ്‌വെയർ ബഗ്ഗിനെ സൂചിപ്പിക്കുന്നതാവാം.
അവസാനം ശ്രമിച്ച വിവരശേഖര അന്വേഷണം താഴെ കൊടുക്കുന്നു:
<blockquote><tt>$1</tt></blockquote>
"<tt>$2</tt>" എന്ന നിർദ്ദേശത്തിനകത്ത് നിന്നും.
വിവരശേഖരത്തിൽ നിന്നും ലഭിച്ച പിഴവ് "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'വിവരശേഖര അന്വേഷണ ഘടനയിൽ ഒരു പിഴവ് സംഭവിച്ചിരിക്കുന്നു.
അവസാനം ശ്രമിച്ച വിവരശേഖര അന്വേഷണം താഴെ കൊടുക്കുന്നു:
"$1"
"$2" എന്ന നിർദ്ദേശത്തിനകത്ത് നിന്നും .
വിവരശേഖരത്തിൽ നിന്നും ലഭിച്ച പിഴവ് "$3: $4"',
	'directorycreateerror' => '"$1" എന്ന directory സൃഷ്ടിക്കാൻ സാധിച്ചില്ല.',
	'deletedhist' => 'ഒഴിവാക്കപ്പെട്ട നാൾവഴി',
	'difference' => '(തിരഞ്ഞെടുത്ത പതിപ്പുകൾ തമ്മിലുള്ള വ്യത്യാസം)',
	'difference-multipage' => '(താളുകൾ തമ്മിലുള്ള വ്യത്യാസം)',
	'diff-multi' => '(ഇടയ്ക്ക് {{PLURAL:$2|ഒരു ഉപയോക്താവ്|$2 ഉപയോക്താക്കൾ}} ചെയ്ത {{PLURAL:$1|ഒരു പതിപ്പ്|$1 പതിപ്പുകൾ}} പ്രദർശിപ്പിക്കുന്നില്ല.)',
	'diff-multi-manyusers' => '(ഇടയ്ക്ക് {{PLURAL:$2|ഒന്നിലധികം|$2 എണ്ണത്തിലധികം}} ഉപയോക്താക്കൾ ചെയ്തിട്ടുള്ള {{PLURAL:$1|ഒരു പതിപ്പ്|$1 പതിപ്പുകൾ}} പ്രദർശിപ്പിക്കുന്നില്ല.)',
	'datedefault' => 'ക്രമീകരണങ്ങൾ വേണ്ട',
	'defaultns' => 'അല്ലെങ്കിൽ ഈ നാമമേഖലകളിൽ തിരയുക:',
	'default' => 'സ്വതേ',
	'diff' => 'മാറ്റം',
	'destfilename' => 'പ്രമാണത്തിന് ഉദ്ദേശിക്കുന്ന പേര്:',
	'duplicatesoffile' => 'ഈ പ്രമാണത്തിന്റെ {{PLURAL:$1|ഒരു അപര പ്രമാണത്തെ|$1 അപര പ്രമാണങ്ങളെ}} താഴെ കൊടുത്തിരിക്കുന്നു ([[Special:FileDuplicateSearch/$2|കൂടുതൽ വിവരങ്ങൾ]]):',
	'download' => 'ഡൗൺലോഡ്',
	'disambiguations' => 'വിവക്ഷിത താളുകളിലേയ്ക്ക് കണ്ണിചേർക്കുന്ന താളുകൾ',
	'disambiguationspage' => 'Template:വിവക്ഷകൾ',
	'disambiguations-text' => 'താഴെ കൊടുത്തിരിക്കുന്ന താളുകൾ വിവക്ഷിതങ്ങൾ താളിലേക്കു കണ്ണി ചേർക്കപ്പെട്ടിരിക്കുന്നു. അതിനു പകരം അവ ലേഖനതാളുകളിലേക്കു കണ്ണി ചേക്കേണ്ടതാണ്‌. <br /> ഒരു താളിനെ വിവക്ഷിത താൾ ആയി പരിഗണിക്കണമെങ്കിൽ അതു  [[MediaWiki:Disambiguationspage]] എന്ന താളിൽ നിന്നു കണ്ണി ചേർക്കപ്പെട്ട ഒരു ഫലകം ഉപയോഗിക്കണം.',
	'doubleredirects' => 'ഇരട്ട തിരിച്ചുവിടലുകൾ',
	'doubleredirectstext' => 'ഈ താളിൽ ഒരു തിരിച്ചുവിടലിൽ നിന്നും മറ്റു തിരിച്ചുവിടൽ താളുകളിലേയ്ക്ക് പോകുന്ന താളുകൾ കൊടുത്തിരിക്കുന്നു. ഓരോ വരിയിലും ഒന്നാമത്തേയും രണ്ടാമത്തേയും തിരിച്ചുവിടൽ താളിലേക്കുള്ള കണ്ണികളും, രണ്ടാമത്തെ തിരിച്ചുവിടൽ താളിൽ നിന്നു ശരിയായ ലക്ഷ്യതാളിലേക്കുള്ള കണ്ണികളും ഉൾക്കൊള്ളുന്നു.
<del>വെട്ടിക്കൊടുത്തിരിക്കുന്നവ</del> ശരിയാക്കേണ്ടതുണ്ട്.',
	'double-redirect-fixed-move' => '[[$1]] മാറ്റിയിരിക്കുന്നു.
ഇത് ഇപ്പോൾ [[$2]] എന്നതിലേയ്ക്ക് തിരിച്ചുവിടപ്പെട്ടിരിക്കുന്നു.',
	'double-redirect-fixed-maintenance' => '[[$1]] എന്ന താളിൽ നിന്ന് [[$2]] എന്ന താളിലേയ്ക്കുള്ള ഇരട്ട തിരിച്ചുവിടൽ ശരിയാക്കുന്നു.',
	'double-redirect-fixer' => 'തിരിച്ചുവിടൽ ശരിയാക്കിയത്',
	'deadendpages' => 'അന്തർ വിക്കി കണ്ണിയാൽ ബന്ധിപ്പിക്കപ്പെടാത്ത താളുകൾ',
	'deadendpagestext' => 'താഴെക്കാണുന്ന താളുകളിൽനിന്ന് {{SITENAME}} സം‌രംഭത്തിലെ മറ്റൊരു താളിലേയ്ക്കും കണ്ണി ചേർത്തിട്ടില്ല.',
	'deletedcontributions' => 'മായ്ക്കപ്പെട്ട ഉപയോക്തൃസംഭാവനകൾ',
	'deletedcontributions-title' => 'മായ്ക്കപ്പെട്ട ഉപയോക്തൃസംഭാവനകൾ',
	'defemailsubject' => '"$1" എന്ന ഉപയോക്താവ് അയച്ച {{SITENAME}} ഇമെയിൽ',
	'deletepage' => 'താൾ മായ്ക്കുക',
	'delete-confirm' => '"$1" മായ്ക്കുക',
	'delete-legend' => 'മായ്ക്കുക',
	'deletedtext' => '"$1" മായ്ച്ചിരിക്കുന്നു. പുതിയതായി നടന്ന മായ്ക്കലുകളുടെ വിവരങ്ങൾ $2 ഉപയോഗിച്ച് കാണാം.',
	'dellogpage' => 'മായ്ക്കൽ രേഖ',
	'dellogpagetext' => 'സമീപകാലത്ത് മായ്ക്കപ്പെട്ട താളുകളുടെ പട്ടിക താഴെ കാണാം.',
	'deletionlog' => 'മായ്ക്കൽ രേഖ',
	'deletecomment' => 'കാരണം:',
	'deleteotherreason' => 'മറ്റ്/കൂടുതൽ കാരണങ്ങൾ:',
	'deletereasonotherlist' => 'മറ്റു കാരണങ്ങൾ',
	'deletereason-dropdown' => '*മായ്ക്കാനുള്ള സാധാരണ കാരണങ്ങൾ
** സ്രഷ്ടാവ് ആവശ്യപ്പെട്ടതു പ്രകാരം
** പകർപ്പവകാശ ലംഘനം
** നശീകരണ പ്രവർത്തനം',
	'delete-edit-reasonlist' => 'മായ്ക്കലിന്റെ കാരണം തിരുത്തുക',
	'delete-toobig' => 'ഈ താളിനു വളരെ വിപുലമായ തിരുത്തൽ ചരിത്രമുണ്ട്. $1 മേൽ {{PLURAL:$1|പതിപ്പുണ്ട്|പതിപ്പുകളുണ്ട്}}. ഇത്തരം താളുകൾ മായ്ക്കുന്നതു {{SITENAME}} സം‌രംഭത്തിന്റെ നിലനില്പ്പിനെ തന്നെ ബാധിക്കുമെന്നതിനാൽ ഈ താൾ മായ്ക്കുന്നതിനുള്ള അവകാശം പരിമിതപ്പെടുത്തിയിരിക്കുന്നു.',
	'delete-warning-toobig' => 'ഈ താളിനു വളരെ വിപുലമായ തിരുത്തൽ ചരിത്രമുണ്ട്. അതായത്, ഇതിനു് $1 മേൽ {{PLURAL:$1|പതിപ്പുണ്ട്|പതിപ്പുകളുണ്ട്}}. ഇത്തരം താളുകൾ മായ്ക്കുന്നതു {{SITENAME}} സം‌രംഭത്തിന്റെ ഡാറ്റാബേസ് ഓപ്പറേഷനെ ബാധിച്ചേക്കാം. അതിനാൽ വളരെ ശ്രദ്ധാപൂർവ്വം തുടർനടപടികളിലേക്കു നീങ്ങുക.',
	'databasenotlocked' => 'ഡാറ്റാബേസ് ബന്ധിച്ചിട്ടില്ല.',
	'delete_and_move' => 'മായ്ക്കുകയും മാറ്റുകയും ചെയ്യുക',
	'delete_and_move_text' => '==താൾ മായ്ക്കേണ്ടിയിരിക്കുന്നു==

താങ്കൾ സൃഷ്ടിക്കാൻ ശ്രമിച്ച "[[:$1]]" എന്ന താൾ നിലവിലുണ്ട്. ആ താൾ മായ്ച്ച് പുതിയ തലക്കെട്ട് നൽകേണ്ടതുണ്ടോ?',
	'delete_and_move_confirm' => 'ശരി, താൾ നീക്കം ചെയ്യുക',
	'delete_and_move_reason' => '"[[$1]]" എന്നതിൽ നിന്നും മാറ്റാനുള്ള സൗകര്യത്തിനായി മായ്ച്ചു',
	'djvu_page_error' => 'DjVu താൾ പരിധിയ്ക്കു പുറത്താണ്',
	'djvu_no_xml' => 'DjVu പ്രമാണത്തിനു വേണ്ടി XML ശേഖരിക്കുവാൻ പറ്റിയില്ല',
	'deletedrevision' => '$1 എന്ന പഴയ പതിപ്പ് മായ്ച്ചിരിക്കുന്നു',
	'days' => '{{PLURAL:$1|ഒരു ദിവസം|$1 ദിവസം}}',
	'deletedwhileediting' => "'''മുന്നറിയിപ്പ്''': താങ്കൾ തിരുത്തുവാൻ തുടങ്ങിയ ശേഷം താൾ മായ്ക്കപ്പെട്ടിരിക്കുന്നു!",
	'descending_abbrev' => 'അവരോഹണം',
	'duplicate-defaultsort' => '\'\'\'മുന്നറിയിപ്പ്:\'\'\' ക്രമപ്പെടുത്താനുള്ള ചാവിയായ "$2" മുമ്പ് ക്രമപ്പെടുത്താനുള്ള ചാവിയായിരുന്ന "$1" എന്നതിനെ അതിലംഘിക്കുന്നു.',
	'dberr-header' => 'ഈ വിക്കിയിൽ പ്രശ്നമുണ്ട്',
	'dberr-problems' => 'ക്ഷമിക്കണം! 
ഈ സൈറ്റിൽ സാങ്കേതിക തകരാറുകൾ അനുഭവപ്പെടുന്നുണ്ട്.',
	'dberr-again' => 'കുറച്ച് മിനിട്ടുകൾ കാത്തിരുന്ന് വീണ്ടും തുറക്കുവാൻ ശ്രമിക്കുക.',
	'dberr-info' => '(വിവരശേഖര സെർവറുമായി ബന്ധപ്പെടാൻ പറ്റിയില്ല: $1)',
	'dberr-usegoogle' => 'അതേസമയം താങ്കൾക്ക് ഗൂഗിൾ വഴി തിരയുവാൻ ശ്രമിക്കാവുന്നതാണ്.',
	'dberr-outofdate' => 'അവരുടെ പക്കലുള്ള നമ്മുടെ ഉള്ളടക്കത്തിന്റെ സൂചികകൾ കാലഹരണപ്പെട്ടതാകാമെന്ന് ഓർക്കുക.',
	'dberr-cachederror' => 'ആവശ്യപ്പെട്ട താളിന്റെ കാഷ് ചെയ്യപ്പെട്ട പകർപ്പാണിത്, ഇത് ഇപ്പോഴുള്ളതാകണമെന്നില്ല.',
);

$messages['mn'] = array(
	'december' => 'Арванхоёрдугаар сар',
	'december-gen' => 'Арванхоёрдугаар сар',
	'dec' => '12-р сар',
	'delete' => 'Устгах',
	'deletethispage' => 'Энэ хуудсыг устга',
	'disclaimers' => 'Татгалзлууд',
	'disclaimerpage' => 'Project:Ерөнхий татгалзал',
	'databaseerror' => 'Өгөгдлийн сангийн алдаа',
	'dberrortext' => 'Өгөгдлийн сан дахь хайлтанд синтаксийн алдаа гарлаа.
Энэ нь програм хангамжид алдаа байгааг харуулж байж болзошгүй.
Хамгийн сүүлд гүйцэтгэсэн өгөгдлийн сан дахь хайлт нь:
"<tt>$2</tt>" функц доторх
<blockquote><tt>$1</tt></blockquote> байна.
Өгөгдлийн сан нь "<tt>$3: $4</tt>" гэсэн алдааг буцаав.',
	'dberrortextcl' => 'Өгөгдлийн сан дахь хайлтанд синтаксийн алдаа гарлаа.
Хамгийн сүүлд гүйцэтгэсэн мэдээллийн бааз дахь хайлт нь
"$2" функц доторх:
"$1" байна.
Өгөгдлийн сан нь "$3: $4" алдааг буцаав',
	'directorycreateerror' => '"$1" жагсаалтыг үүсгэж чадсангүй.',
	'deletedhist' => 'Устгагдсан түүх',
	'difference' => '(Засварууд хоорондын ялгаа)',
	'difference-multipage' => '(Хуудсууд хоорондын ялгаа)',
	'diff-multi' => '({{PLURAL:$2|Нэг хэрэглэгчийн|$2 хэрэглэгчийн}} завсрын {{PLURAL:$1|нэг засварыг|$1 засварыг}} үзүүлээгүй)',
	'diff-multi-manyusers' => '($2 гаруй {{PLURAL:$2|хэрэглэгчийн}} {{PLURAL:$1|дундын нэг засварыг|дундын $1 засварыг}} үзүүлсэнгүй)',
	'datedefault' => 'Анхны байдал',
	'defaultns' => 'Үгүй бол эдгээр нэрний зайнуудад хайх:',
	'default' => 'анхны байдал',
	'diff' => 'ялгаа',
	'destfilename' => 'Зорьсон файлын нэр:',
	'duplicatesoffile' => 'Дараах {{PLURAL:$1|файл|$1 файл}} нь энэ файлтай яг ижилхэн байна （[[Special:FileDuplicateSearch/$2|дэлгэрэнгүй мэдээлэл]]）:',
	'download' => 'Татаж авах',
	'disambiguations' => 'Салаа утгатай үгнүүд',
	'disambiguationspage' => 'Template:Салаа утгатай',
	'disambiguations-text' => "Дараах хуудсууд '''салаа утгатай үгнүүдийн хуудас''' руу холбогдоно.
Тэдгээр нь зөв сэдэв руу холбогдох ёстой.<br />
[[MediaWiki:Disambiguationspage]]-с холбогдсон загвар хэрэглэж байвал хуудас нь салаа утгатай үгнүүдийн хуудас гэж тооцогдоно.",
	'doubleredirects' => 'Давхар чиглүүлэгчүүд',
	'doubleredirectstext' => 'Энэ хуудас нь өөр чиглүүлэгч хуудас руу чиглүүлдэг хуудсуудыг жагсаана.
Мөр тус бүр нь эхний ба хоёр дахь чиглүүлэгч рүүх холбоосыг болон эхний чиглүүлэгчийн чиглэх ёстой, хоёр дахь чиглүүлэгчийн чиглэх "жинхэнэ" чиглэх ёстой хуудсыг заана.',
	'double-redirect-fixed-move' => '[[$1]] зөөгдөж, [[$2]] руух чиглүүлэгч боллоо',
	'double-redirect-fixer' => 'Чиглүүлэгчийг засварлагч',
	'deadendpages' => 'Төгсгөлийн хуудсууд',
	'deadendpagestext' => 'Дараах хуудсууд викигийн бусад хуудсуудтай холбогдоогүй байна.',
	'deletedcontributions' => 'Устгагдсан хэрэглэгчийн хувь нэмэр',
	'deletedcontributions-title' => 'Устгагдсан хэрэглэгчийн хувь нэмэр',
	'defemailsubject' => '{{SITENAME}} и-мэйл',
	'deletepage' => 'Хуудсыг устга',
	'delete-confirm' => '"$1"-г устгах',
	'delete-legend' => 'Устгах',
	'deletedtext' => '"$1" нь устгагдлаа.
Сүүлд устгагдсан зүйлсийг $2-с харна уу.',
	'dellogpage' => 'Устгалын лог',
	'dellogpagetext' => 'Доорх нь хамгийн сүүлд устгагдсан зүйлсийн жагсаалт.',
	'deletionlog' => 'устгалын лог',
	'deletecomment' => 'Шалтгаан:',
	'deleteotherreason' => 'Өөр/нэмэлт шалтгаан:',
	'deletereasonotherlist' => 'Өөр шалтгаан',
	'deletereason-dropdown' => '*Устгах нийтлэг шалтгаанууд
** Бичлэг үйлдэгчийн хүсэлтээр
** Зохиогчийн эрхэд халдсан
** Вандализм',
	'delete-edit-reasonlist' => 'Устгах шалтгаануудыг засварлах',
	'delete-toobig' => 'Энэ хуудасны засварын түүх маш том байгаа бөгөөд $1 гаруй засвартай байна.
{{SITENAME}}-д санамсаргүй байдлаар муугаар нөлөөлж болзошгүй тул эдгээр хуудсуудыг устгах явдлыг хорьсон байна.',
	'delete-warning-toobig' => 'Энэ хуудасны засварын түүх маш том байгаа бөгөөд $1 гаруй засвартай байна.
Устгавал {{SITENAME}}-н мэдээллийн сангийн үйл ажиллагаанд нөлөөлж магадгүй тул та анхаар сэрэмжтэйгээр дараах үйлдлээ гүйцэтгэнэ үү.',
	'databasenotlocked' => 'Өгөгдлийн сан хаагдаагүй байна.',
	'delete_and_move' => 'Устгаад зөөх',
	'delete_and_move_text' => '==Устгалын шаардав==
Зорьсон хуудас "[[:$1]]"-г нь урьд нь оруулсан байна.
Та зөөхөд зай гаргахын тулд устгах уу?',
	'delete_and_move_confirm' => 'Тийм, хуудсыг устга',
	'delete_and_move_reason' => '[[$1]] -с зөөхөд зай гаргахын тулд устгагдсан',
	'djvu_page_error' => 'DjVu хуудас хэсгийн гадна байна',
	'djvu_no_xml' => 'DjVu файлын XML-г авч чадсангүй',
	'deletedrevision' => 'Хуучин засвар $1 нь устгагдлаа',
	'deletedwhileediting' => 'Анхаар: Таныг засвар хийж байх явцад энэ хуудас устгагдсан байна!',
	'descending_abbrev' => 'буурах',
	'duplicate-defaultsort' => '\'\'\'Анхаар:\'\'\' "$2" гэсэн default sort key нь "$1" гэсэн өмнөх key-н дээгүүр бичигдэх болж байна.',
	'dberr-header' => 'Энэхүү викид асуудал үүсэв',
	'dberr-problems' => 'Уучлаарай!
Энэхүү сайтад техникийн саатал учирч байна.',
	'dberr-again' => 'Хэдэн минут хүлээгээд дахин ачаалж үзнэ үү.',
	'dberr-info' => '(өгөгдлийн сангийн серверт хандаж чадсангүй: $1)',
	'dberr-usegoogle' => 'Та одоохондоо Google-г ашиглан хайлтаа хийх боломжтой.',
	'dberr-outofdate' => 'Энэ сайт дахь агуулгын гадны индекс хуучирсан байж болзошгүйг анхаарна уу.',
	'dberr-cachederror' => 'Энэ нь таны хандах гэж буй хуудсын кэшлэгдсэн хувилбар. Иймд агуулга нь хуучирсан байж болзошгүй.',
);

$messages['mo'] = array(
	'december' => 'дечембрие',
	'december-gen' => 'дечембрие',
	'dec' => 'деч',
	'delete' => 'Штерӂе',
	'disclaimers' => 'Деклараций',
	'disclaimerpage' => 'Project:Декларацие ӂенералэ',
	'difference' => '(Диференца динтре версиунь)',
	'diff' => 'диф',
	'deletepage' => 'Штерӂе паӂина',
	'deletedtext' => 'Паӂина «$1» а фост штярсэ.
Везь $2 пентру о листэ а елементелор штерсе речент.',
	'dellogpage' => 'Журнал штерӂерь',
	'deletecomment' => 'Мотив:',
	'deleteotherreason' => 'Мотив диферит/суплиментар:',
	'deletereasonotherlist' => 'Алт мотив',
);

$messages['mr'] = array(
	'december' => 'डिसेंबर',
	'december-gen' => 'डिसेंबर',
	'dec' => 'डिसें.',
	'delete' => 'वगळा',
	'deletethispage' => 'हे पृष्ठ काढून टाका',
	'disclaimers' => 'उत्तरदायित्वास नकार',
	'disclaimerpage' => 'Project: सर्वसाधारण उत्तरदायकत्वास नकार',
	'databaseerror' => 'माहितीसंग्रहातील त्रुटी',
	'dberrortext' => 'एक विदा पृच्छारचना त्रुटी घडली आहे.
ही बाब संचेतनात (सॉफ्टवेअरमध्ये) क्षितिजन्तु असण्याची शक्यता निर्देशित करते.
"<tt>$2</tt>" या कार्यातून निघालेली शेवटची विदापृच्छा पुढील प्रमाणे होती:
<blockquote><tt>$1</tt></blockquote>
मायएसक्युएलने "<tt>$3: $4</tt>" ही त्रुटी दिलेली आहे.',
	'dberrortextcl' => 'चुकीच्या प्रश्नलेखनामुळे माहितीसंग्रह त्रुटी.
शेवटची माहितीसंग्रहाला पाठविलेला प्रश्न होता:
"$1"
"$2" या कार्यकृतीमधून .
MySQL returned error "$3: $4".',
	'directorycreateerror' => '"$1" कार्यधारीका (directory) तयार केली जाऊ शकली नाही.',
	'deletedhist' => 'वगळलेला इतिहास',
	'difference-title' => '"$1" च्या विविध उजळण्या',
	'difference-title-multipage' => '"$1" व "$2" या पानान मधला फरक',
	'difference-multipage' => '(पानांमधील फरक)',
	'diff-multi' => '{{PLURAL:$2|सदस्याची|$2 सदस्यांच्या}} ({{PLURAL:$1|आवृत्ती|$1 आवृत्त्या}} दाखवल्या नाहीत)',
	'diff-multi-manyusers' => '{{PLURAL:$2|सदस्याची|$2 सदस्यांच्या}} ({{PLURAL:$1|आवृत्ती|$1 आवृत्त्या}} दाखवल्या नाहीत)',
	'datedefault' => 'प्राथमिकता नाही',
	'defaultns' => 'या नामविश्वातील अविचल शोध :',
	'default' => 'अविचल',
	'diff' => 'फरक',
	'destfilename' => 'नवे संचिकानाम:',
	'duplicatesoffile' => 'खालील संचिका या दिलेल्या {{PLURAL:$1|संचिकेची प्रत आहे|$1 संचिकांच्या प्रती आहेत}}. [[Special:FileDuplicateSearch/$2|अधिक माहिती]]',
	'download' => 'उतरवा',
	'disambiguations' => 'नि:संदिग्धकरण पृष्ठे',
	'disambiguationspage' => 'Template:नि:संदिग्धीकरण',
	'disambiguations-text' => "निम्नलिखीत पाने एका '''नि:संदिग्धकरण पृष्ठास'''जोडली जातात. त्याऐवजी ती सुयोग्य विषयाशी जोडली जावयास हवीत.<br /> जर जर एखादे पान [[MediaWiki:Disambiguationspage]]पासून जोडलेला साचा वापरत असेल तर ते पान '''नि:संदिग्धकरण पृष्ठ''' गृहीत धरले जाते",
	'doubleredirects' => 'दुहेरी-पुनर्निर्देशने',
	'doubleredirectstext' => 'हे पान अशा पानांची सूची पुरवते की जी पुर्ननिर्देशीत पाने दुसऱ्या पुर्ननिर्देशीत पानाकडे निर्देशीत झाली आहेत.प्रत्येक ओळीत पहिल्या आणि दुसऱ्या पुर्ननिर्देशनास दुवा दिला आहे सोबतच दुसरे पुर्ननिर्देशन ज्या पानाकडे पोहचते ते पण दिले आहे, जे की बरोबर असण्याची शक्यता आहे ,ते वस्तुतः पहिल्या पानापासूनचेही पुर्ननिर्देशन असावयास हवे.',
	'double-redirect-fixed-move' => '[[$1]] हलवले गेले आहे.
ते [[$2]] येथे निर्देशित होते.',
	'double-redirect-fixed-maintenance' => '[[$1]] ते [[$2]] हे चुकीचे पुनर्निर्देशन नीट केले.',
	'double-redirect-fixer' => 'पुनर्निर्देशन नीट करणारा',
	'deadendpages' => 'टोकाची पाने',
	'deadendpagestext' => 'या पानांवर या विकिवरील इतर कुठल्याही पानाला जोडणारा दुवा नाही.',
	'deletedcontributions' => 'वगळलेली सदस्य संपादने',
	'deletedcontributions-title' => 'वगळलेली सदस्य संपादने',
	'defemailsubject' => '{{SITENAME}} "$1" सदस्याकडून विपत्र',
	'deletepage' => 'पान वगळा',
	'delete-confirm' => '"$1" वगळा',
	'delete-legend' => 'वगळा',
	'deletedtext' => '"$1" हा लेख वगळला. अलीकडे वगळलेले लेख पाहण्यासाठी $2 पहा.',
	'dellogpage' => 'वगळल्याची नोंद',
	'dellogpagetext' => 'नुकत्याच वगळलेल्या पानांची यादी खाली आहे.',
	'deletionlog' => 'वगळल्याची नोंद',
	'deletecomment' => 'कारण:',
	'deleteotherreason' => 'दुसरे/अतिरिक्त कारण:',
	'deletereasonotherlist' => 'दुसरे कारण',
	'deletereason-dropdown' => '* वगळण्याची सामान्य कारणे
** लेखकाची(लेखिकेची) विनंती
** प्रताधिकार उल्लंघन
** उत्पात',
	'delete-edit-reasonlist' => 'वगळण्याची कारणे संपादित करा',
	'delete-toobig' => 'या पानाला खूप मोठी इतिहास यादी आहे, तसेच हे पान $1 {{PLURAL:$1|पेक्षा|पेक्षा}}पेक्षा जास्त वेळा बदलण्यात आलेले आहे. अशी पाने वगळणे हे {{SITENAME}} ला धोकादायक ठरू नये म्हणून शक्य केलेले नाही.',
	'delete-warning-toobig' => 'या पानाला खूप मोठी इतिहास यादी आहे, तसेच हे पान $1 {{PLURAL:$1|पेक्षा|पेक्षा}} पेक्षा जास्त वेळा बदलण्यात आलेले आहे.
अशी पाने वगळणे हे {{SITENAME}} ला धोकादायक ठरू शकते;
कृपया काळजीपूर्वक हे पान वगळा.',
	'databasenotlocked' => 'विदागारास ताळे नही',
	'delete_and_move' => 'वगळा आणि स्थानांतरित करा',
	'delete_and_move_text' => '==वगळण्याची आवशकता==

लक्ष्यपान  "[[:$1]]" आधीच अस्तीत्वात आहे.स्थानांतराचा मार्ग मोकळाकरण्या करिता तुम्हाला ते वगळावयाचे आहे काय?',
	'delete_and_move_confirm' => 'होय, पान वगळा',
	'delete_and_move_reason' => '"[[$1]]" पासून वगळून स्थानांतर केले.',
	'djvu_page_error' => 'टप्प्याच्या बाहेरचे DjVu पान',
	'djvu_no_xml' => 'DjVu संचिकेकरिता XML ओढण्यात असमर्थ',
	'deletedrevision' => 'जुनी आवृत्ती ($1) वगळली.',
	'days-abbrev' => '$1दि',
	'days' => '{{PLURAL:$1|$1 दिवस|$1 दिवस}}',
	'deletedwhileediting' => '”’सूचना:”’ तुम्ही संपादन सुरू केल्यानंतर हे पान वगळले गेले आहे.',
	'descending_abbrev' => 'उतर',
	'duplicate-defaultsort' => '\'\'\'वॉर्निंग:\'\'\' डिफॉल्ट सॉर्ट की "$2"ओवर्राइड्स अर्लीयर डिफॉल्ट सॉर्ट की "$1".',
	'dberr-header' => 'या विकीत एक चूक आहे',
	'dberr-problems' => 'माफ करा, हे संकेतस्थळ सध्या तांत्रिक अडचणींना सामोरे जात आहे.',
	'dberr-again' => 'थोडा वेळ थांबून पुन्हा पहा.',
	'dberr-info' => '( विदादाताशी संपर्क साधण्यात  असमर्थ : $1)',
	'dberr-usegoogle' => 'तोपर्यंत गूगलवर शोधून पहा',
	'dberr-outofdate' => 'लक्षात घ्या, आमच्या मजकुराबाबत त्यांची सुची कालबाह्य असु शकते',
	'dberr-cachederror' => 'ही मागवलेल्या पानाची सयीतील प्रत आहे, ती अद्ययावत नसण्याची शक्यता आहे.',
	'duration-seconds' => '$1 {{PLURAL:$1|सेकंदापूर्वी|सेकंदांपूर्वी}}',
	'duration-minutes' => '$1 {{PLURAL:$1|मिनिटापूर्वी|मिनिटांपूर्वी}}',
	'duration-hours' => '$1 {{PLURAL:$1|तासापूर्वी|तासांपूर्वी}}',
	'duration-days' => '$1 {{PLURAL:$1|दिवसापूर्वी|दिवसांपूर्वी}}',
	'duration-weeks' => '$1 {{PLURAL:$1|आठवड्यापूर्वी | आठवड्यांपूर्वी}}',
	'duration-years' => '$1 {{PLURAL:$1|वर्षापूर्वी|वर्षांपूर्वी}}',
	'duration-decades' => '$1 {{PLURAL:$1|दशकापूर्वी|दशकांपूर्वी }}',
	'duration-centuries' => '$1 {{PLURAL:$1|शतकापूर्वी|शतकांपूर्वी }}',
);

$messages['mrj'] = array(
	'december' => 'декабрь',
	'december-gen' => 'декабрьын',
	'dec' => 'дек',
	'delete' => 'Карангдаш',
	'disclaimers' => 'Вӓшештӹмӹ шая (ответственность) гӹц карангмаш',
	'disclaimerpage' => 'Project:Вӓшештӹмӓш (ответственность) гӹц карангмаш',
	'difference' => '(Версивлӓ лошты вашталтмашвлӓ)',
	'diff' => 'ма-шон',
	'deletepage' => 'Ӹлӹштӓшӹм карангдаш',
	'deletedtext' => '«$1» карангдымы.
Анжы: $2 тидӹ мам карангдымы тӹ списокым анжыкта',
	'dellogpage' => 'Мам карангдымы анжыктышы сирмӓш',
	'deletecomment' => 'Ӓмӓлжӹ:',
	'deleteotherreason' => 'Вес ӓмӓл/ынгылдарал:',
	'deletereasonotherlist' => 'Вес ӓмӓл',
);

$messages['ms'] = array(
	'december' => 'Disember',
	'december-gen' => 'Disember',
	'dec' => 'Dis',
	'delete' => 'Hapuskan',
	'deletethispage' => 'Hapuskan laman ini',
	'disclaimers' => 'Penolak tuntutan',
	'disclaimerpage' => 'Project:Penolak tuntutan umum',
	'databaseerror' => 'Ralat pangkalan data',
	'dberrortext' => 'Ralat sintaks pertanyaan pangkalan data telah terjadi.
Ini mungkin menandakan pepijat dalam perisian wiki ini.
Pertanyaan pangkalan data yang terakhir ialah:
<blockquote><tt>$1</tt></blockquote>
daripada fungsi "<tt>$2</tt>".
Pangkalan data memulangkan ralat "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Terdapat ralat sintaks pertanyaan pangkalan data.
Pertanyaan terakhir ialah:
"$1"
daripada fungsi "$2".
Pangkalan data memulangkan ralat "$3: $4".',
	'directorycreateerror' => 'Direktori "$1" gagal diciptakan.',
	'deletedhist' => 'Sejarah yang dihapuskan',
	'difference' => '(Perbezaan antara semakan)',
	'difference-multipage' => '(Perbezaan antara laman)',
	'diff-multi' => '($1 {{PLURAL:$1|semakan pertengahan|semakan pertengahan}} oleh $2 {{PLURAL:$2|pengguna|pengguna}} tidak dipaparkan)',
	'diff-multi-manyusers' => '($1 {{PLURAL:$1|semakan pertengahan|semakan pertengahan}} oleh lebih daripada $2 {{PLURAL:$2|pengguna|pengguna}} tidak dipaparkan)',
	'datedefault' => 'Tiada keutamaan',
	'defaultns' => 'Jika tidak cari dalam ruang nama ini:',
	'default' => 'asali',
	'diff' => 'beza',
	'destfilename' => 'Nama fail destinasi:',
	'duplicatesoffile' => '{{PLURAL:$1|Fail|$1 buah fail}} berikut adalah salinan bagi fail ini ([[Special:FileDuplicateSearch/$2|butiran lanjut]]):',
	'download' => 'muat turun',
	'disambiguations' => 'Laman-laman yang berpaut dengan laman penyahkekaburan',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Laman-laman berikut mengandungi pautan ke '''laman penyahtaksaan'''. Pautan ini sepatutnya ditujukan kepada topik yang sepatutnya.<br />Sesebuah laman dianggap sebagai laman penyahtaksaan jika ia menggunakan templat yang dipaut dari [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Lencongan berganda',
	'doubleredirectstext' => 'Yang berikut ialah senarai laman yang melencong ke laman lencongan lain. Setiap baris mengandungi pautan ke laman lencongan pertama dan kedua, serta baris pertama bagi teks lencongan kedua, lazimnya merupakan laman sasaran "sebenar", yang sepatutnya ditujui oleh lencongan pertama.
Masukan yang <del>dipotong</del> telah diselesaikan.',
	'double-redirect-fixed-move' => '[[$1]] dilencongkan ke [[$2]]',
	'double-redirect-fixed-maintenance' => 'Membetulkan dwilecongan daripada [[$1]] kepada [[$2]].',
	'double-redirect-fixer' => 'Pembaiki lencongan',
	'deadendpages' => 'Laman buntu',
	'deadendpagestext' => 'Laman-laman berikut tidak mengandungi pautan ke laman lain di {{SITENAME}}.',
	'deletedcontributions' => 'Sumbangan dihapuskan',
	'deletedcontributions-title' => 'Sumbangan dihapuskan',
	'defemailsubject' => 'E-mel {{SITENAME}} daripada pengguna "$1"',
	'deletepage' => 'Hapus laman',
	'delete-confirm' => 'Hapus "$1"',
	'delete-legend' => 'Hapuskan',
	'deletedtext' => '"$1" telah dihapuskan.
Sila lihat $2 untuk rekod penghapusan terkini.',
	'dellogpage' => 'Log penghapusan',
	'dellogpagetext' => 'Yang berikut ialah senarai penghapusan terkini.',
	'deletionlog' => 'log penghapusan',
	'deletecomment' => 'Sebab:',
	'deleteotherreason' => 'Sebab lain/tambahan:',
	'deletereasonotherlist' => 'Sebab lain',
	'deletereason-dropdown' => '* Sebab-sebab lazim
** Permintaan pengarang
** Melanggar hak cipta
** Vandalisme',
	'delete-edit-reasonlist' => 'Ubah sebab-sebab hapus',
	'delete-toobig' => 'Laman ini mempunyai sejarah yang besar, iaitu melebihi $1 jumlah semakan. Oleh itu, laman ini dilindungi daripada dihapuskan untuk mengelak kerosakan di {{SITENAME}} yang tidak disengajakan.',
	'delete-warning-toobig' => 'Laman ini mempunyai sejarah yang besar, iaitu melebihi $1 jumlah semakan. Menghapuskannya boleh mengganggu perjalanan pangkalan data {{SITENAME}}. Sila berhati-hati.',
	'databasenotlocked' => 'Pangkalan data tidak dikunci.',
	'delete_and_move' => 'Hapus dan pindah',
	'delete_and_move_text' => '==Penghapusan diperlukan==

Laman destinasi "[[:$1]]" telah pun wujud. Adakah anda mahu menghapuskannya supaya laman ini dapat dipindahkan?',
	'delete_and_move_confirm' => 'Ya, hapuskan laman ini',
	'delete_and_move_reason' => 'Dihapuskan untuk membuka laluan untuk pemindahan dari "[[$1]]"',
	'djvu_page_error' => 'Laman DjVu di luar julat',
	'djvu_no_xml' => 'Gagal mendapatkan data XML bagi fail DjVu',
	'deletedrevision' => 'Menghapuskan semakan lama $1.',
	'days-abbrev' => '$1h',
	'days' => '$1 hari',
	'deletedwhileediting' => "'''Amaran''': Laman ini dihapuskan ketika anda sedang menyuntingnya!",
	'descending_abbrev' => 'menurun',
	'duplicate-defaultsort' => '\'\'\'Amaran\'\'\': Kunci susunan asali "$2" membatalkan kunci susunan asali "$1" yang sebelumnya.',
	'dberr-header' => 'Wiki ini dilanda masalah',
	'dberr-problems' => 'Harap maaf. Tapak web ini dilanda masalah teknikal.',
	'dberr-again' => 'Cuba tunggu selama beberapa minit dan muat semula.',
	'dberr-info' => '(Tidak dapat menghubungi pelayan pangkalan data: $1)',
	'dberr-usegoogle' => 'Buat masa ini, anda boleh cuba mencari melalui Google.',
	'dberr-outofdate' => 'Sila ambil perhatian bahawa indeks mereka bagi kandungan kami mungkin sudah ketinggalan zaman.',
	'dberr-cachederror' => 'Yang berikut ialah salinan bagi laman yang diminta yang diambil daripada cache, dan mungkin bukan yang terkini.',
);

$messages['mt'] = array(
	'december' => 'Diċembru',
	'december-gen' => 'Diċembru',
	'dec' => 'Diċ',
	'delete' => 'Ħassar',
	'deletethispage' => 'Ħassar din il-paġna',
	'disclaimers' => 'Ċaħdiet',
	'disclaimerpage' => 'Project:Ċaħda ġenerali',
	'databaseerror' => 'Problema fid-database',
	'dberrortext' => 'Kien hemm żball fis-sintassi ta\' rikjesta tad-databażi.
Dan jista\' jindika li hemm problema fis-softwer.
L-aħħar attentat ta\' rikjesta tad-databażi kienet:
<blockquote><tt>$1</tt></blockquote>
mill-funzjoni ta\' "<tt>$2</tt>".
Id-databażi tat problema ta\' "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Kien hemm żball fis-sintassi ta\' rikjesta tad-databażi.
L-aħħar attentat ta\' rikjesta tad-databażi kienet:
"$1"
mill-funzjoni "$2".
Id-databażi tat il-problema segwenti "$3: $4"',
	'directorycreateerror' => 'Id-direttorju "$1" ma setax jiġi maħluq.',
	'deletedhist' => 'Kronoloġija mħassra',
	'difference' => '(Differenzi bejn ir-reviżjonijiet)',
	'difference-multipage' => '(Differenzi bejn il-paġni)',
	'diff-multi' => '(Mhux qed {{PLURAL:$1|tintwera reviżjoni intermedja|jintwerew $1 reviżjonijit intermedji}} minn {{PLURAL:$2|utent|$2 utenti}})',
	'diff-multi-manyusers' => '(Mhux qed {{PLURAL:$1|tintwera reviżjoni intermedja|jintwerew $1 reviżjonijit intermedji}} mingħand iktar minn $2 {{PLURAL:$2|utent|$2 utenti}})',
	'datedefault' => 'L-ebda preferenza',
	'defaultns' => "Fil-każ kuntrarju, fittex f'dawn l-ispazji tal-isem:",
	'default' => 'predefinit',
	'diff' => 'diff',
	'destfilename' => 'L-Isem tal-fajl tad-destinazzjoni:',
	'duplicatesoffile' => "{{PLURAL:$1|Il-fajl segwenti huwa duplikat|Il-$1 fajls segwenti huma duplikati}} ta' dan il-fajl ([[Special:FileDuplicateSearch/$2|aktar dettalji]]):",
	'download' => 'niżżel',
	'disambiguations' => "Paġni ta' diżambigwazzjoni",
	'disambiguationspage' => 'Template:diżambig',
	'disambiguations-text' => "Il-Paġni li jinsabu f'din lista huma parti minn '''paġna ta' diżambigwazzjoni''' b'hekk għandhom jiġu relatati mas-suġġett preċiż minflok. <br />
Paġna tiġi stimata paġna ta' diżambigwazzjoni dawk kollha li jagħmlu użu mit-template elenkat f'[[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Riindirizzi doppji',
	'doubleredirectstext' => 'Din il-paġna telenka dawk il-paġni li jindirizzaw lejn paġna oħra ta\' riindirizzament.
Kull filliera għandha ħolqa għall-ewwel u t-tieni riindirizz, kif ukoll fejn tirrindirizza t-tieni paġna, is-soltu magħrufa bħalha l-paġna "reali" fejn se twassal, fejn suppost l-ewwel riindirizz għandu jipponta.',
	'double-redirect-fixed-move' => '[[$1]] ġie mmexxi awtomatikament, issa hu rindirizz għal [[$2]]',
	'double-redirect-fixed-maintenance' => "Tiswija ta' rindirizz doppju minn [[$1]] għal [[$2]].",
	'double-redirect-fixer' => "Tiswija ta' rindirizz",
	'deadendpages' => 'Paġni bla ħruġ',
	'deadendpagestext' => "Il-Paġni segwenti m'għandhomx link għal paġna oħra.",
	'deletedcontributions' => 'Kontribuzzjonijiet imħassra tal-utent',
	'deletedcontributions-title' => 'Kontribuzzjonijiet imħassra tal-utent',
	'defemailsubject' => 'Messaġ minn {{SITENAME}} mingħand l-utent "$1"',
	'deletepage' => 'Ħassar il-paġna',
	'delete-confirm' => 'Ħassar "$1"',
	'delete-legend' => 'Ħassar',
	'deletedtext' => 'Il-paġna "$1" ġiet imħassra.
Ikkonsulta r-$2 biex tara paġni li ġew imħassra riċentament.',
	'dellogpage' => 'Tħassir',
	'dellogpagetext' => 'Hawn taħt hawn lista tal-paġni li ġew imħassra riċentament.',
	'deletionlog' => 'reġistru tat-tħassir',
	'deletecomment' => 'Raġuni:',
	'deleteotherreason' => 'Raġunijiet oħra/addizzjonali:',
	'deletereasonotherlist' => 'Raġuni oħra',
	'deletereason-dropdown' => "*Raġunijiet ta' tħassir komuni
** Rikjesta tal-awtur
** Vjolazzjoni tal-copyright
** Vandaliżmu",
	'delete-edit-reasonlist' => "Immodifika r-raġunijiet ta' tħassir",
	'delete-toobig' => "Din il-paġna għandha kronoloġija ta' modifikar kbira, l-fuq minn $1 {{PLURAL:$1|reviżjoni|reviżjonijiet}}.
Tħassir ta' dawn il-paġni huwa limitat sabiex tnaqqas il-ħolqien aċċidentalment ta' problemi fil-funżjoni tad-database ta' {{SITENAME}}.",
	'delete-warning-toobig' => "Din il-paġna għandha kronoloġija ta' modifikar kbira, l-fuq minn $1 {{PLURAL:$1|reviżjoni|reviżjonijiet}}.
Tħassara tista' toħloq problema ta' funżjoni fid-database ta' {{SITENAME}}; moħħok hemm.",
	'databasenotlocked' => 'Id-Database mhux magħluq.',
	'delete_and_move' => 'Ħassar u mexxi',
	'delete_and_move_text' => '==Rikjesta ta\' tħassir==
Il-Paġna tad-destinazzjoni "[[:$1]]" ġa teżisti.
Trid tħassara sabiex tkun tista\' tagħmel triq għal ċaqlieqa?',
	'delete_and_move_confirm' => 'Iva, ħassar il-paġna',
	'delete_and_move_reason' => 'Imħassra sabiex isseħħ it-tmexxija minn "[[$1]]"',
	'djvu_page_error' => 'Numru tal-paġna DjVu bla klassifika',
	'djvu_no_xml' => 'Impossibli ġġib il-XML għal fajl DjVu',
	'deletedrevision' => 'Reviżjoni preċedenti, mħassra: $1',
	'days' => '{{PLURAL:$1|ġurnata|$1 ġranet}}',
	'deletedwhileediting' => "'''Twissija''': Din il-paġna ġiet imħassra wara li int bdejt timmodifikaha!",
	'descending_abbrev' => 'dixx',
	'duplicate-defaultsort' => '\'\'\'Twissija:\'\'\' iċ-ċavetta tal-issortjar oriġinali "$2" tissostitwixxi dik preċedenti "$1".',
	'dberr-header' => 'Din il-wiki għandha problema',
	'dberr-problems' => 'Jiddispjaċina! Dan is-sit għandu diffikultajiet tekniċi.',
	'dberr-again' => "Prova stenna ftit minuti u erġa' tella' l-paġna.",
	'dberr-info' => '(Impossibbli li jsir kuntratt mas-server tad-databażi: $1)',
	'dberr-usegoogle' => "Fil-frattemp, tista' tipprova tfittex permezz tal-Google.",
	'dberr-outofdate' => "Kun af li l-indiċi tagħhom tal-kontenut tagħna jista' ma jkunx aġġornat.",
	'dberr-cachederror' => "Din hija kopja cache tal-paġna rikjesta, u tista' tkun li mhijiex aġġornata.",
);

$messages['mwl'] = array(
	'december' => 'Dezembro',
	'december-gen' => 'Dezembre',
	'dec' => 'Dez.',
	'delete' => 'Botar fuora',
	'deletethispage' => 'Apagar esta páigina',
	'disclaimers' => 'Abiso de Cuntenido',
	'disclaimerpage' => 'Project:Abiso giral',
	'databaseerror' => 'Erro na base de dados',
	'directorycreateerror' => 'Nun fui possible criar la diretorie "$1".',
	'difference' => '(Defréncias antre rebisones)',
	'diff-multi' => '({{PLURAL:$1|ua eidiçon antermédia nun stá a ser amostrada|$1 eidiçones antermédias nun stan a ser amostradas}}.)',
	'default' => 'defeito',
	'diff' => 'defr',
	'disambiguations' => 'Páigina de zambiguaçon',
	'doubleredirects' => 'Ancaminamientos duplos',
	'deadendpages' => 'Páiginas sin salida',
	'deletepage' => 'Botar fuora páigina',
	'delete-confirm' => 'Botar fuora "$1"',
	'delete-legend' => 'Botar fuora',
	'deletedtext' => '"$1" fue elhiminada.
Consulte $2 para um registo de eliminações recentes.',
	'dellogpage' => 'Registro de botado fuora',
	'deletecomment' => 'Rezon:',
	'deleteotherreason' => 'Rezon adicional:',
	'deletereasonotherlist' => 'Outra rezon',
	'descending_abbrev' => 'decer',
);

$messages['my'] = array(
	'december' => 'ဒီ​ဇင်​ဘာ​',
	'december-gen' => 'ဒီ​ဇင်​ဘာ​',
	'dec' => 'ဒီ',
	'delete' => 'ဖျက်​ပါ​',
	'deletethispage' => 'ဤစာမျက်နှာဖျက်ပါ',
	'disclaimers' => 'သတိပြုစရာများ',
	'disclaimerpage' => 'Project: အထွေထွေ သတိပြုဖွယ်',
	'databaseerror' => 'ဒေတာဘေ့စ် အမှား',
	'directorycreateerror' => 'လမ်းညွှန် "$1" ကို ဖန်တီးမရနိုင်ပါ။',
	'deletedhist' => 'ဖျက်ပစ်လိုက်သော မှတ်တမ်း',
	'difference' => 'တည်းဖြတ်မူများ အကြား ကွဲပြားမှုများ',
	'difference-multipage' => '(စာမျက်နှာများကြားမှ ကွဲပြားချက်များ)',
	'diff-multi' => '({{PLURAL:$2|အသုံးပြုသူတစ်ဦး|အသုံးပြုသူ $2 ဦး}}၏{{PLURAL:$1|အလယ်အလတ်တည်းဖြတ်မူတစ်ခု|အလယ်အလတ်တည်းဖြတ်မူ $1 ခု}}ကို မပြပါ)',
	'datedefault' => 'မရွေးချယ်',
	'defaultns' => 'သို့မဟုတ်ပါက ဤအမည်ညွှန်းများတွင် ရှာပါ -',
	'default' => 'ပုံမှန်အားဖြင့်',
	'diff' => 'ကွဲပြားမှု',
	'destfilename' => 'အလိုရှိရာဖိုင်အမည် -',
	'download' => 'ဒေါင်းလုဒ်',
	'disambiguationspage' => 'Template:သံတူကြောင်းကွဲများ',
	'doubleredirects' => 'နှစ်ဆင့်ပြန် ပြန်ညွှန်းများ',
	'double-redirect-fixed-move' => '[[$1]] ကို ရွှေ့ပြောင်းပြီးဖြစ်သည်။ ယခုအခါ [[$2]] သို့ ပြန်ညွှန်းထားသည်။',
	'deadendpages' => 'လမ်းပိတ်နေသော (လင့်မရှိသော) စာမျက်နှာများ',
	'deletedcontributions' => 'ဖျက်လိုက်သော ပံ့ပိုးမှုများ',
	'deletedcontributions-title' => 'ဖျက်လိုက်သော ပံ့ပိုးမှုများ',
	'defemailsubject' => '{{SITENAME}} အီးမေး',
	'deletepage' => 'စာမျက်နှာကိုဖျက်ပါ',
	'delete-confirm' => '"$1"ကို ဖျက်ပါ',
	'delete-legend' => 'ဖျက်',
	'deletedtext' => '"$1" ကို ဖျက်ပစ်လိုက်ပြီးဖြစ်သည်။
လတ်တလောဖျက်ထားသည်များ၏ မှတ်တမ်းကို $2 တွင် ကြည့်ပါ။',
	'dellogpage' => 'ဖျက်ထားသည်များ မှတ်တမ်း',
	'deletionlog' => 'ဖျက်ပစ်သည့်မှတ်တမ်း',
	'deletecomment' => 'အ​ကြောင်း​ပြ​ချက် -',
	'deleteotherreason' => 'အခြားသော/နောက်ထပ် အကြောင်းပြချက် -',
	'deletereasonotherlist' => 'အခြား အကြောင်းပြချက်',
	'delete-edit-reasonlist' => 'ဖျက်ပစ်ရသော အကြောင်းရင်းများကို တည်းဖြတ်ရန်',
	'delete_and_move' => 'ဖျက်ပြီးရွှေ့ရန်',
	'delete_and_move_confirm' => 'ဟုတ်ပါသည်။ စာမျက်နှာကို ဖျက်ပါ။',
	'duplicate-defaultsort' => '\'\'\'သတိပေးချက် -\'\'\' ပုံမှန် sort key "$2" oသည် ယခင်ပုံမှန်ဖြစ်သော sort key "$1" ကို override ထပ်ရေးမည်ဖြစ်သည်.',
	'dberr-header' => 'ဤဝီကီတွင် ပြဿနာတစ်ခု ရှိနေသည်',
	'dberr-problems' => 'ဝမ်းနည်းပါသည်။
ဤဆိုက်သည် နည်းပညာပိုင်းဆိုင်ရာ အခက်အခဲများ ကြုံတွေ့နေရပါသည်။',
);

$messages['myv'] = array(
	'december' => 'Ацамков',
	'december-gen' => 'Ацамковонь',
	'dec' => 'Аца',
	'delete' => 'Нардамс',
	'deletethispage' => 'Нардамс те лопанть',
	'disclaimers' => 'Видечинь кортамотне',
	'disclaimerpage' => 'Project:Видечинь прякс кортнема',
	'databaseerror' => 'Датабазань ильведькс',
	'directorycreateerror' => '"$1" директориясь а тееви.',
	'deletedhist' => 'Нардань икелькс умазо',
	'difference' => '(Явовкс ванокснень юткова)',
	'diff-multi' => '↓({{PLURAL:$2|Вейке совицясь тейсь {{PLURAL:$1|юткине версия, конась|$1 юткине версият, конатне}}|$2 совицят тейсть {{PLURAL:$1| юткине версия, конась|$1 юткине версият, конатне}}}} апак невте.)',
	'datedefault' => 'Икелькс вешема арась',
	'default' => 'зярдо лиякс апак йовта',
	'diff' => 'кадовикс',
	'destfilename' => 'Теевиця файланть лемезэ',
	'download' => 'таргамс',
	'disambiguations' => 'Лопат, конат сёрмадстовтовить ламосмустев терминтт',
	'disambiguationspage' => 'Template:смустень коряс явома',
	'doubleredirects' => 'Кавксть ютавтозь',
	'double-redirect-fixer' => 'Печтевтемс витнема-петнема пель',
	'deadendpages' => 'Поладкстомо-лисемавтомо лопат',
	'deadendpagestext' => 'Не вана лопатне апак сюлмаво {{SITENAME}} сайтсэ лия лопа марто.',
	'defemailsubject' => '{{SITENAME}} е-сёрма',
	'deletepage' => 'Нардамс лопанть',
	'delete-confirm' => 'Нардамс "$1"',
	'delete-legend' => 'Нардамс',
	'deletedtext' => '"$1"-сь ульнесь нардазь.
Вант $2 тосо веси уаль умоконь нардавксне.',
	'dellogpage' => 'Нардазде мезе йовтамс',
	'deletionlog' => 'нардамонь сёрмалема',
	'deletecomment' => 'Тувталось:',
	'deleteotherreason' => 'Лия/топавтозь тувтал:',
	'deletereasonotherlist' => 'Лия тувтал',
	'deletereason-dropdown' => '*Нардамонь сех вастневиця тувталтнэ
** Теицянть вешемазо
** Теицянь видечинть коламозо
** Вандализма',
	'delete-edit-reasonlist' => 'Витнемс-петнемс нардамонь тувталтнэнь',
	'databasenotlocked' => 'Датабазась апак сёлго.',
	'delete_and_move' => 'Нардык ды печтевтик',
	'delete_and_move_confirm' => 'Нардыка те лопанть',
	'delete_and_move_reason' => 'Печтевтемга нардазь',
	'deletedrevision' => 'Нардань ташто лиякстомтома $1',
	'dberr-header' => 'Те викисэнть проблема',
);

$messages['mzn'] = array(
	'december' => 'ده‌سـه‌مـبـر',
	'december-gen' => 'ده‌سـه‌مـبـر',
	'dec' => 'ده‌سه‌مبر',
	'delete' => 'پاک هاکردن',
	'deletethispage' => 'این صفحه ره پاک هاکردن',
	'disclaimers' => 'تکذیب‌نومه‌ئون',
	'disclaimerpage' => 'Project:تکذیب‌نومه',
	'databaseerror' => 'خطای داده‌ئون پایگا',
	'dberrortext' => 'اشکال نحوی بخاستن دله برسنی‌یه بیّه به پایگاه داده.
دلیل این مشکل بتونده ایرادی نرم‌افزار دله بائه.
آخرین بخاسته‌یی که پایگاه وسّه برسنی‌بیَ‌بی‌یه اینتا بی‌یه:
<blockquote style="direction:ltr;"><tt>$1</tt></blockquote>
این بخاسته درون عملگر «<span class="ltr"><tt>$2</tt></span>» جه برسنی بیّه.
پایگاه داده این خطا ره بردگاردنی‌یه:
<div class="ltr"><tt>$3: $4</tt></div>',
	'dberrortextcl' => 'اشکال نحوی در درخواست فرستاده شده به پایگاه داده رخ داد.
آخرین درخواست که برای پایگاه داده فرستاد شد این بود:
<div class="ltr">$1</div>
این درخواست از درون عملگر «<span class="ltr">$2</span>» فرستاده شد.
پایگاه داده این خطا را بازگرداند:
<div class="ltr">$3: $4</div>',
	'directorycreateerror' => 'امکان بساتن پوشه $1 وجود نداشته.',
	'diff' => 'فرق و فـَسِل',
	'disambiguations' => 'گجگجی‌بَیری صفحه‌ئون',
	'deletepage' => 'صفحه پاک هاکردن',
	'dellogpage' => 'وه ره بییته‌ئون گوزارش',
	'delete_and_move_confirm' => 'أره، پاک هاکه‌ن وه ره',
);

$messages['na'] = array(
	'delete' => 'Iyababa',
);

$messages['nah'] = array(
	'december' => 'Pànketzalistli',
	'december-gen' => 'ic mahtlāctetl omōme mētztli',
	'dec' => 'ic mahtlāctli onōme',
	'delete' => 'Ticpolōz',
	'deletethispage' => 'Ticpolōz inīn zāzanilli',
	'disclaimers' => 'Nahuatīllahtōl',
	'databaseerror' => 'Tlahcuilōltzintlān īahcuallo',
	'deletedhist' => 'Ōtlapolo tlahcuilōlloh',
	'difference' => '(Ahneneuhquiliztli tlapatlaliznepantlah)',
	'diff-multi' => '({{PLURAL:$1|Cē tlapatlaliztli nepantlah ahmo motta in ōquichīuh|$1 Tlapatlaliztli nepantlah ahmo mottah in ōquinchīuh}}  {{PLURAL:$2|cē tlatequitiltilīlli|$2 tlatequitiltilīltin}})',
	'datedefault' => 'Ayāc tlanequiliztli',
	'defaultns' => 'Tlatēmōz inīn tōcātzimpan achtopa:',
	'default' => 'ic default',
	'diff' => 'ahneneuh',
	'destfilename' => 'Tōcāhuīc:',
	'duplicatesoffile' => 'Inōn {{PLURAL:$1|tlahcuilōlli cah|$1 tlahcuilōlli cateh}} ōntiah inīn zāzanilli ([[Special:FileDuplicateSearch/$2|ocahci]]):',
	'download' => 'tictemōz',
	'disambiguations' => 'Āmatl tlein motzonhuiliah īca tlahtōlmelāhuacātlāliztli āmatl',
	'disambiguationspage' => 'Template:Tlahtōlmelāhuacātlālīliztli',
	'doubleredirects' => 'Ōntetl tlacuepaliztli',
	'deadendpages' => 'Ahtlaquīzaliztli zāzaniltin',
	'defemailsubject' => '{{SITENAME}} correo tlatequitiltilīlhuīc $1',
	'deletepage' => 'Ticpolōz inīn zāzanilli',
	'delete-confirm' => 'Ticpolōz "$1"',
	'delete-legend' => 'Ticpolōz',
	'deletedtext' => '"$1" ōmopolo.
Xiquitta $2 ic yancuīc tlapololiztli.',
	'dellogpage' => 'Tlapololiztli tlahcuilōlloh',
	'deletionlog' => 'tlapololiztli tlahcuilōlloh',
	'deletecomment' => 'Īxtlamatiliztli:',
	'deleteotherreason' => 'Occē īxtlamatiliztli:',
	'deletereasonotherlist' => 'Occē īxtlamatiliztli',
	'delete-edit-reasonlist' => 'Tiquimpatlāz īxtlamatiliztli tlapoloaliztechcopa',
	'delete_and_move' => 'Ticpolōz auh ticzacāz',
	'delete_and_move_confirm' => 'Quēmah, ticpolōz in zāzanilli',
	'descending_abbrev' => 'temoa',
);

$messages['nan'] = array(
	'december' => '12-goe̍h',
	'december-gen' => 'Cha̍p-jī-goe̍h',
	'dec' => '12g',
	'delete' => 'Thâi',
	'deletethispage' => 'Thâi chit ia̍h',
	'disclaimers' => 'Bô-hū-chek seng-bêng',
	'disclaimerpage' => 'Project:It-poaⁿ ê seng-bêng',
	'databaseerror' => 'Chu-liāu-khò· chhò-gō·',
	'dberrortext' => 'Chu-liāu-khò͘ hoat-seng cha-sûn ê gí-hoat chhò-ngō͘.
Che khó-lêng sī nńg-thé ê chhò-ngō͘.
Téng chi̍t ê cha-sûn sī :
<blockquote><tt>$1</tt></blockquote>
tī hâm-sò͘  "<tt>$2</tt>".
Chu-liāu-khò͘ thoân hoê ê chhò-ngō͘ "<tt>$3: $4</tt>".',
	'dberrortextcl' => '發生一个查詢資料庫語法錯誤，頂一个欲查詢資料庫是：
"$1"
佇"$2"
資料庫送回一个錯誤"$3: $4"',
	'directorycreateerror' => 'Bô-hoat-tō͘ khui bo̍k-lo̍k "$1".',
	'deletedhist' => '已經刣掉的歷史',
	'difference' => '(Bô kâng pán-pún ê cheng-chha)',
	'difference-multipage' => '（頁中間的精差）',
	'diff-multi' => '（由{{PLURAL:$2|个用者|$2个用者}}的{{PLURAL:$1|一个中央修訂本|$1个中央修訂本}}無顯示）',
	'diff-multi-manyusers' => '（{{PLURAL:$2|个用者|$2个用者}}的{{PLURAL:$1|一个中途修訂本|$1个中途修訂本}}無顯示）',
	'datedefault' => 'Chhìn-chhái',
	'defaultns' => 'Tī chiah ê miâ-khong-kan chhiau-chhōe:',
	'default' => '設便',
	'diff' => 'Cheng-chha',
	'destfilename' => 'Tóng-àn sin miâ:',
	'duplicatesoffile' => '下跤{{PLURAL:$1|个|个}}檔案佮這个仝款（[[Special:FileDuplicateSearch/$2|詳細]]）：',
	'download' => '下載',
	'disambiguations' => 'Khu-pia̍t-ia̍h',
	'disambiguationspage' => 'Template:disambig
Template:KhPI
Template:Khu-pia̍t-iah
Template:Khu-pia̍t-ia̍h',
	'doubleredirects' => 'Siang-thâu choán-ia̍h',
	'deadendpages' => 'Khu̍t-thâu-ia̍h',
	'deadendpagestext' => 'Ē-kha ê ia̍h bô liân kàu wiki lāi-té ê kî-thaⁿ ia̍h.',
	'deletedcontributions' => 'Hō͘ lâng thâi tiāu ê kòng-hiàn',
	'deletedcontributions-title' => 'Hō͘ lâng thâi tiāu ê kòng-hiàn',
	'deletepage' => 'Thâi ia̍h',
	'delete-confirm' => '刣掉$1',
	'delete-legend' => '刣掉',
	'deletedtext' => '"$1" í-keng thâi tiāu. Tùi $2 khoàⁿ-ē-tio̍h chòe-kīn thâi ê kì-lo̍k.',
	'dellogpage' => '刣掉的記錄',
	'dellogpagetext' => 'Í-hā lia̍t chhut chòe-kīn thâi tiāu ê hāng-bo̍k.',
	'deletionlog' => '刣掉的記錄',
	'deletecomment' => 'Lí-iû:',
	'deleteotherreason' => '其他／另外的理由：',
	'deletereasonotherlist' => '其他的理由',
	'deletereason-dropdown' => '*一般刣掉的理由
** 作者的要求
** 違反著作權
** 破壞',
	'delete-edit-reasonlist' => '編輯刣掉的理由',
	'databasenotlocked' => '資料庫無封鎖牢咧。',
	'deletedrevision' => 'Kū siu-tēng-pún $1 thâi-tiāu ā.',
	'duplicate-defaultsort' => '\'\'\'Thê-chhíⁿ lí:\'\'\'Siat-piān ê pâi-lia̍t hong-sek "$2" thè-oāⁿ chìn-chêng ê siat-piān ê pâi-lia̍t hong-sek "$1".',
	'dberr-header' => '這个Wiki遇著問題',
	'dberr-problems' => '失禮！
這馬這个站有技術上的問題。',
);

$messages['nap'] = array(
	'december' => 'dicèmbre',
	'december-gen' => 'dicembre',
	'dec' => 'dic',
	'delete' => 'Scancèlla',
	'deletethispage' => 'Scancèlla chésta paggena',
	'disclaimers' => 'Avvertimiènte',
	'disclaimerpage' => 'Project:Avvertimiènte generale',
	'disambiguations' => "Paggene 'e disambigua",
	'doubleredirects' => 'Redirect duppie',
	'deletepage' => 'Scancella paggena',
	'deletedtext' => 'Qauccheruno ha scancellata \'a paggena "$1".  Addumannà \'o $2 pe na lista d"e ppaggene scancellate urdemamente.',
	'dellogpage' => 'Scancellazione',
	'deletionlog' => 'Log d"e scancellazione',
	'deletecomment' => 'Raggióne',
	'delete_and_move' => 'Scancèlla e spusta',
	'delete_and_move_confirm' => "Sì, suprascrivi 'a paggena asistente",
	'deletedwhileediting' => 'Attenziòne: quaccherùno have scancellàto chesta pàggena prìmma ca tu accuminciàste â scrìvere!',
);

$messages['nb'] = array(
	'december' => 'desember',
	'december-gen' => 'desember',
	'dec' => 'des',
	'delete' => 'Slett',
	'deletethispage' => 'Slett denne siden',
	'disclaimers' => 'Forbehold',
	'disclaimerpage' => 'Project:Generelle forbehold',
	'databaseerror' => 'Databasefeil',
	'dberrortext' => 'Det har oppstått en syntaksfeil i en databaseforespørsel.
Dette kan tyde på en feil i programvaren.
Forrige databaseforespørsel var:
<blockquote><tt>$1</tt></blockquote>
fra funksjonen «<tt>$2</tt>».
Databasen returnerte feilen «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'Det oppsto en syntaksfeil i en databaseforespørsel.
Forrige databaseforespørsel var:
«$1»
fra funksjonen «$2».
Databasen returnerte feilen «$3: $4».',
	'directorycreateerror' => 'Klarte ikke å opprette mappe «$1».',
	'deletedhist' => 'Slettet historikk',
	'difference' => '(Forskjell mellom revisjoner)',
	'difference-multipage' => '(Forskjell mellom sider)',
	'diff-multi' => '({{PLURAL:$1|Én mellomrevisjon|$1 mellomrevisjoner}} av {{PLURAL:$2|én bruker|$2 brukere}} vises ikke)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Én mellomrevisjon|$1 mellomrevisjoner}} av mer enn $2 {{PLURAL:$2|bruker|brukere}} vises ikke)',
	'datedefault' => 'Ingen foretrukket',
	'defaultns' => 'Søk ellers i disse navnerommene:',
	'default' => 'standard',
	'diff' => 'diff',
	'destfilename' => 'Ønsket filnavn:',
	'duplicatesoffile' => 'Følgende {{PLURAL:$1|fil er en dublett|filer er dubletter}} av denne filen ([[Special:FileDuplicateSearch/$2|fler detaljer]]):',
	'download' => 'last ned',
	'disambiguations' => 'Sider som lenker til artikler med flertydige titler',
	'disambiguationspage' => 'Template:Peker',
	'disambiguations-text' => "Følgende sider lenker til en '''pekerside'''.
De burde i stedet lenke til en passende innholdsside.<br />
En side anses om en pekerside om den inneholder en mal som det lenkes til fra [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Doble omdirigeringer',
	'doubleredirectstext' => 'Denne siden lister opp de sidene som er omdirigeringer til andre omdirigeringssider.
Hver rad inneholder lenker til første og andre omdirigering, samt målet for den andre omdirigeringen, som vanligvis er den «virkelige» målsiden som den første omdirigeringen burde peke til.
<del>Gjennomstrøkne</del> sider har blitt fikset.',
	'double-redirect-fixed-move' => '[[$1]] har blitt flyttet, og er nå en omdirigering til [[$2]]',
	'double-redirect-fixed-maintenance' => 'Fikser dobbel omdirigering fra [[$1]] til [[$2]].',
	'double-redirect-fixer' => 'Omdirigeringsfikser',
	'deadendpages' => 'Blindveisider',
	'deadendpagestext' => 'Følgende sider lenker ikke til andre sider på {{SITENAME}}.',
	'deletedcontributions' => 'Slettede brukerbidrag',
	'deletedcontributions-title' => 'Slettede brukerbidrag',
	'defemailsubject' => '{{SITENAME}}-type e-post fra bruker "$1"',
	'deletepage' => 'Slett side',
	'delete-confirm' => 'Slett «$1»',
	'delete-legend' => 'Slett',
	'deletedtext' => '«$1» er slettet.
Se $2 for en oversikt over de siste slettingene.',
	'dellogpage' => 'Slettingslogg',
	'dellogpagetext' => 'Under er ei liste over nylige slettinger.',
	'deletionlog' => 'slettingslogg',
	'deletecomment' => 'Årsak:',
	'deleteotherreason' => 'Annen/utdypende grunn:',
	'deletereasonotherlist' => 'Annen grunn',
	'deletereason-dropdown' => '* Vanlige grunner for sletting
** På forfatters forespørsel
** Opphavsrettsbrudd
** Vandalisme',
	'delete-edit-reasonlist' => 'Rediger begrunnelser for sletting',
	'delete-toobig' => 'Denne siden har en stor redigeringshistorikk, med over {{PLURAL:$1|$1&nbsp;revisjon|$1&nbsp;revisjoner}}. Muligheten til å slette slike sider er begrenset for å unngå utilsiktet forstyrring av {{SITENAME}}.',
	'delete-warning-toobig' => 'Denne siden har en stor redigeringshistorikk, med over {{PLURAL:$1|$1&nbsp;revisjon|$1&nbsp;revisjoner}}. Sletting av denne siden kan forstyrre databasen til {{SITENAME}}; vær varsom.',
	'databasenotlocked' => 'Databasen er ikke låst.',
	'delete_and_move' => 'Slett og flytt',
	'delete_and_move_text' => '==Sletting nødvendig==
Målsiden «[[:$1]]» finnes allerede. Vil du slette den så denne siden kan flyttes dit?',
	'delete_and_move_confirm' => 'Ja, slett siden',
	'delete_and_move_reason' => 'Slettet for å muliggjøre flytting fra "[[$1]]"',
	'djvu_page_error' => 'DjVu-side ute av rekkevidde',
	'djvu_no_xml' => 'Klarte ikke å hente XML for DjVu-fil',
	'deletedrevision' => 'Slettet gammel revisjon $1.',
	'days' => '{{PLURAL:$1|$1 dag|$1 dager}}',
	'deletedwhileediting' => "'''Advarsel:''' Denne siden har blitt slettet etter at du begynte å redigere den!",
	'descending_abbrev' => 'synk.',
	'duplicate-defaultsort' => 'Advarsel: Standardsorteringen «$2» tar over for den tidligere sorteringen «$1».',
	'dberr-header' => 'Wikien har et problem',
	'dberr-problems' => 'Siden har tekniske problemer.',
	'dberr-again' => 'Prøv å oppdatere siden om noen minutter.',
	'dberr-info' => '(Kan ikke kontakte databasetjeneren: $1)',
	'dberr-usegoogle' => 'Du kan prøve å søke via Google imens.',
	'dberr-outofdate' => 'Merk at deres indeks over våre sider kan være utdatert.',
	'dberr-cachederror' => 'Følgende er en mellomlagret kopi av den etterspurte siden, og kan være foreldet.',
);

$messages['nds'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezember',
	'dec' => 'Dez',
	'delete' => 'Wegsmieten',
	'deletethispage' => 'Disse Siet wegsmieten',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Fehler in de Datenbank',
	'dberrortext' => 'Dor weer en Syntaxfehler in de Datenbankaffraag.
De Grund kann en Programmeerfehler ween
De letzte Datenbankaffraag weer:

<blockquote><tt>$1</tt></blockquote>

ut de Funkschoon <tt>$2</tt>.
MySQL mell den Fehler <tt>$3: $4</tt>.',
	'dberrortextcl' => 'Dor weer en Syntaxfehler in de Datenbankaffraag.
De letzte Datenbankaffraag weer: $1 ut de Funkschoon <tt>$2</tt>.
MySQL mell den Fehler: <tt>$3: $4</tt>.',
	'directorycreateerror' => 'Kunn Orner „$1“ nich anleggen.',
	'deletedhist' => 'wegsmetene Versionen',
	'difference' => '(Ünnerscheed twischen de Versionen)',
	'diff-multi' => '({{PLURAL:$1|Een Twischenversion|$1 Twischenversionen}} von {{PLURAL:$2|een Bruker|$2 Brukers}} warrt nich wiest.)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Een Twischenversion|$1 Twischenversionen}} von mehr as $2 {{PLURAL:$2|Bruker|Brukers}} warrt nich wiest)',
	'datedefault' => 'Standard',
	'defaultns' => 'Anners söök in disse Naamrüüm:',
	'default' => 'Standard',
	'diff' => 'Ünnerscheed',
	'destfilename' => 'Dateinaam, so as dat hier spiekert warrn schall:',
	'duplicatesoffile' => 'Disse {{PLURAL:$1|Datei is|Datein sünd}} jüst de {{PLURAL:$1|glieke|glieken}} as disse Datei hier ([[Special:FileDuplicateSearch/$2|mehr Infos]]):',
	'download' => 'Dalladen',
	'disambiguations' => 'Mehrdüdige Begrepen',
	'disambiguationspage' => 'Template:Mehrdüdig_Begreep',
	'disambiguations-text' => 'Disse Sieden wist na Sieden för mehrdüdige Begrepen. Se schöölt lever op de Sieden wiesen, de egentlich meent sünd.<br />Ene Siet warrt as Siet för en mehrdüdigen Begreep ansehn, wenn [[MediaWiki:Disambiguationspage]] na ehr wiest.<br />Lenken ut annere Naamrüüm sünd nich mit in de List.',
	'doubleredirects' => 'Dubbelte Wiederleiden',
	'doubleredirectstext' => '<b>Wohrscho:</b> Disse List kann „falsche Positive“ bargen.
Dat passeert denn, wenn en Wiederleiden blangen de Wiederleiden-Verwies noch mehr Text mit annere Verwiesen hett.
De schallen denn löscht warrn. Elk Reeg wiest de eerste un tweete Wiederleiden un de eerste Reeg Text ut de Siet,
to den vun den tweeten Wiederleiden wiest warrt, un to den de eerste Wiederleiden mehrst wiesen schall.',
	'double-redirect-fixed-move' => '[[$1]] is schaven worrn un wiest nu na [[$2]]',
	'double-redirect-fixer' => 'Redirect-Utbeterer',
	'deadendpages' => 'Sackstraatsieden',
	'deadendpagestext' => 'Disse Sieden wiest op kene annern Sieden vun {{SITENAME}}.',
	'deletedcontributions' => 'Wegsmetene Bidrääg vun’n Bruker',
	'deletedcontributions-title' => 'Wegsmetene Bidrääg vun’n Bruker',
	'defemailsubject' => '{{SITENAME}} E-Mail',
	'deletepage' => 'Siet wegsmieten',
	'delete-confirm' => '„$1“ wegsmieten',
	'delete-legend' => 'Wegsmieten',
	'deletedtext' => 'De Artikel „$1“ is nu wegsmeten. Op $2 gifft dat en Logbook vun de letzten Löschakschonen.',
	'dellogpage' => 'Lösch-Logbook',
	'dellogpagetext' => 'Hier is en List vun de letzten Löschen.',
	'deletionlog' => 'Lösch-Logbook',
	'deletecomment' => 'Grund:',
	'deleteotherreason' => 'Annere/tosätzliche Grünn:',
	'deletereasonotherlist' => 'Annern Grund',
	'deletereason-dropdown' => '* Grünn för dat Wegsmieten
** op Wunsch vun’n Schriever
** gegen dat Oorheverrecht
** Vandalismus',
	'delete-edit-reasonlist' => 'Grünn för’t Wegsmieten ännern',
	'delete-toobig' => 'Disse Siet hett en temlich lange Versionsgeschicht vun mehr as {{PLURAL:$1|ene Version|$1 Versionen}}. Dat Wegsmieten kann de Datenbank vun {{SITENAME}} för längere Tied utlasten un den Bedriev vun dat Wiki stöörn.',
	'delete-warning-toobig' => 'Disse Siet hett en temlich lange Versionsgeschicht vun mehr as {{PLURAL:$1|ene Version|$1 Versionen}}. Dat Wegsmieten kann de Datenbank vun {{SITENAME}} för längere Tied utlasten un den Bedriev vun dat Wiki stöörn.',
	'databasenotlocked' => 'De Datenbank is nich sparrt.',
	'delete_and_move' => 'Wegsmieten un Schuven',
	'delete_and_move_text' => '== Siet gifft dat al, wegsmieten? ==

De Siet „[[:$1]]“ gifft dat al. Wullt du ehr wegsmieten, dat disse Siet schaven warrn kann?',
	'delete_and_move_confirm' => 'Jo, de Siet wegsmieten',
	'delete_and_move_reason' => 'wegsmeten, Platz to maken för Schuven',
	'djvu_page_error' => 'DjVu-Siet buten de verföögboren Sieden',
	'djvu_no_xml' => 'kunn de XML-Daten för de DjVu-Datei nich afropen',
	'deletedrevision' => 'Löschte ole Version $1',
	'deletedwhileediting' => "'''Wohrschau''': Disse Siet is wegsmeten worrn, wieldes du ehr graad ännert hest!",
	'descending_abbrev' => 'dal',
	'duplicate-defaultsort' => 'Wohrschau: De DEFAULTSORTKEY „$2“ överschrifft den vörher bruukten Slötel „$1“.',
	'dberr-header' => 'Dit Wiki hett en Problem',
	'dberr-problems' => 'Deit uns leed. Disse Websteed hett opstunns en beten technische Problemen.',
	'dberr-again' => 'Tööv en poor Minuten un versöök dat denn noch wedder.',
	'dberr-info' => '(Kunn nich mit’n Datenbank-Server verbinnen: $1)',
	'dberr-usegoogle' => 'Du kannst dat solang mit Google versöken.',
	'dberr-outofdate' => 'Wees gewohr, dat de Söökindex, de se vun uns Inhold hebbt, oold wesen kann.',
	'dberr-cachederror' => 'Dit is en Kopie ut’n Cache vun de opropen Sied un is villicht nich de ne’este Version.',
);

$messages['nds-nl'] = array(
	'december' => 'desember',
	'december-gen' => 'desember',
	'dec' => 'des',
	'delete' => 'Vortdoon',
	'deletethispage' => 'Disse pagina vortdoon',
	'disclaimers' => 'Veurbehold',
	'disclaimerpage' => 'Project:Veurbehoud',
	'databaseerror' => 'Fout in de databanke',
	'dberrortext' => 'Bie t zeuken is n syntaxisfout in de databanke op-etrejen.
De oorzake hiervan kan dujen op n fout in de programmatuur.
Der is n syntaxisfout in t databankeverzeuk op-etrejen.
t Kan ween dat der n fout in de programmatuur zit.
De leste zeukpoging in de databanke was:
<blockquote><tt>$1</tt></blockquote>
vanuut de funksie "<tt>$2</tt>".
De databanke gaf de volgende foutmelding "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Der is n syntaxisfout in t databankeverzeuk op-etrejen.
t Leste veurzeuk an de databanke was:
"$1"
vanuut de funksie "$2"
De databanke gaf de volgende foutmelding: "$3: $4"',
	'directorycreateerror' => 'Map "$1" kon niet an-emaakt wörden.',
	'deletedhist' => 'Geschiedenisse die vortehaold is',
	'difference' => '(Verschil tussen bewarkingen)',
	'difference-multipage' => "(Verschil tussen pagina's)",
	'diff-multi' => '(Hier {{PLURAL:$1|zit nog 1 versie|zitten nog $1 versies}} van {{PLURAL:$2|1 gebruker|$2 gebrukers}} tussen die der niet bie staon.)',
	'diff-multi-manyusers' => '($1 tussenliggende {{PLURAL:$1|versie|versies}} deur meer as $2 {{PLURAL:$2|gebruker|gebrukers}} niet weeregeven)',
	'datedefault' => 'Gien veurkeur',
	'defaultns' => 'Aanders in de volgende naamruumten zeuken:',
	'default' => 'standard',
	'diff' => 'wiezig',
	'destfilename' => 'Opslaon as (optioneel)',
	'duplicatesoffile' => '{{PLURAL:$1|t Volgende bestaand is|De volgende $1 bestaanden bin}} liek alleens as dit bestaand ([[Special:FileDuplicateSearch/$2|meer informasie]]):',
	'download' => 'binnenhaolen',
	'disambiguations' => "Pagina's die verwiezen naor deurverwiespagina's",
	'disambiguationspage' => 'Template:Dv',
	'disambiguations-text' => "De onderstaonde pagina's verwiezen naor n '''deurverwiespagina'''. Disse verwiezingen mutten eigenliks rechtstreeks verwiezen naor t juuste onderwarp.

Pagina's wörden ezien as n deurverwiespagina, as de mal gebruukt wörden die vermeld steet op [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dubbele deurverwiezingen',
	'doubleredirectstext' => "Op disse lieste staon alle pagina's die deurverwiezen naor aandere deurverwiezingen.
Op elke regel steet de eerste en de tweede deurverwiezing, daorachter steet de doelpagina van de tweede deurverwiezing.
Meestentieds is leste pagina de gewunste doelpagina, waor oek de eerste pagina heer zol mutten liejen.",
	'double-redirect-fixed-move' => '[[$1]] is herneumd en is noen n deurverwiezing naor [[$2]]',
	'double-redirect-fixed-maintenance' => 'Verbeteren van dubbele deurverwiezing van [[$1]] naor [[$2]].',
	'double-redirect-fixer' => 'Deurverwiezingsverbeteraar',
	'deadendpages' => "Pagina's zonder verwiezingen",
	'deadendpagestext' => "De onderstaonde pagina's verwiezen niet naor aandere pagina's in disse wiki.",
	'deletedcontributions' => 'Vortedaone gebrukersbiedragen',
	'deletedcontributions-title' => 'Vortedaone gebrukersbiedragen',
	'defemailsubject' => 'Bericht van {{SITENAME}}-gebruker "$1"',
	'deletepage' => 'Vortdoon',
	'delete-confirm' => '"$1" vortdoon',
	'delete-legend' => 'Vortdoon',
	'deletedtext' => 't Artikel "$1" is vortedaon. Zie de "$2" veur n lieste van pagina\'s die as lest vortedaon bin.',
	'dellogpage' => 'Vortdologboek',
	'dellogpagetext' => "Hieronder steet n lieste van pagina's en bestaanden die as lest vortedaon bin.",
	'deletionlog' => 'Vortdologboek',
	'deletecomment' => 'Reden:',
	'deleteotherreason' => 'Aandere/extra reden:',
	'deletereasonotherlist' => 'Aandere reden',
	'deletereason-dropdown' => "*Redens veur t vortdoon van pagina's
** Op vrage van de auteur
** Schending van de auteursrechten
** Vandelisme",
	'delete-edit-reasonlist' => 'Redens veur t vortdoon bewarken',
	'delete-toobig' => "Disse pagina hef n lange bewarkingsgeschiedenisse, meer as $1 {{PLURAL:$1|versie|versies}}.
t Vortdoon van dit soort pagina's is mit rechten bepark um t per ongelok versteuren van de warking van {{SITENAME}} te veurkoemen.",
	'delete-warning-toobig' => 'Disse pagina hef n lange bewarkingsgeschiedenisse, meer as $1 {{PLURAL:$1|versie|versies}}.
Woart je: t vortdoon van disse pagina kan de warking van de databanke van {{SITENAME}} versteuren.
Wees veurzichtig',
	'databasenotlocked' => 'De databanke is niet eblokkeerd.',
	'delete_and_move' => 'Vortdoon en herneumen',
	'delete_and_move_text' => '==Mut vortedaon wörden==
<div style="color: red"> Onder de nieje naam "[[:$1]]" besteet al n artikel. Wi\'j t vortdoon um plaotse te maken veur t herneumen?</div>',
	'delete_and_move_confirm' => 'Ja, disse pagina vortdoon',
	'delete_and_move_reason' => 'Vortedaon vanwegen de herneuming van "[[$1]]"',
	'djvu_page_error' => 'DjVu-pagina buten bereik',
	'djvu_no_xml' => 'Kon de XML-gegevens veur t DjVu-bestaand niet oproepen',
	'deletedrevision' => 'Vortedaone ouwe versie $1.',
	'days' => '{{PLURAL:$1|$1 dag|$1 dagen}}',
	'deletedwhileediting' => "'''Waorschuwing''': disse pagina is vortedaon terwiel jie t an t bewarken waren!",
	'descending_abbrev' => 'opl.',
	'duplicate-defaultsort' => 'Waorschuwing: de standardsortering "$2" krig veurrang veur de sortering "$1".',
	'dberr-header' => 'Disse wiki hef n probleem',
	'dberr-problems' => 't Spiet ons, mer disse webstee hef op t moment wat techniese problemen.',
	'dberr-again' => 'Wach n paor minuten en probeer t daornao opniej.',
	'dberr-info' => '(Kan gien verbiending maken mit de databankeserver: $1)',
	'dberr-usegoogle' => "Misschien ku'j ondertussen zeuken via Google.",
	'dberr-outofdate' => "Let op: indexen die zee hebben van onze pagina's bin misschien niet aktueel.",
	'dberr-cachederror' => 'Disse pagina is n kopie uut t tussengeheugen en is misschien niet aktueel.',
);

$messages['ne'] = array(
	'december' => 'डिसेम्बर',
	'december-gen' => 'डिसेम्बर',
	'dec' => 'डिसेम्बर',
	'delete' => 'मेट्नुहोस्',
	'deletethispage' => 'यो पृष्ठ हटाउनुहोस्',
	'disclaimers' => 'अस्विकारोक्तिहरु',
	'disclaimerpage' => 'Project:सामान्य अस्वीकारोक्ति',
	'databaseerror' => 'डेटावेस त्रुटी',
	'dberrortext' => '↓ डेटाबेस क्वेरी सुत्र त्रुटि भएको छ ।
यसले सफ्टवेयरमा बग रहेको देखाउँदछ ।
डेटावेसमा पछिल्लो पटक प्रयास गरिएको क्वेरी:
<blockquote><tt>$1</tt></blockquote>
 "<tt>$2</tt>" फङ्सन बाट बोलाइएको
थियो "<tt>$3: $4</tt>" डेटावेस त्रुटि उत्पन्न ।',
	'dberrortextcl' => 'डेटाबेस क्वेरी वाक्यविन्यास त्रुटि भयो।
"$2" कार्य भित्रबाट "$1" अन्तिम प्रयास गरिएको डेटाबेस क्वेरी थियो।
डेटाबेसले दिएको त्रुटि "$3: $4"',
	'directorycreateerror' => 'डाइरेक्टरी "$1" निर्माणगर्न सकिएन ।',
	'deletedhist' => 'मेटाएका इतिहास',
	'difference' => '(पुनरावलोकनहरुको बीचमा भिन्नता)',
	'diff-multi' => '({{PLURAL:$1|एक मध्य पुनरावलोकन|$1 मध्य पुनरावलोकनहरू}} नदेखाइएको)',
	'datedefault' => 'कुनै अभिरुचि छैन',
	'defaultns' => 'अन्यथा यी नेमस्पेसेजमा खोज्ने :',
	'default' => 'पूर्वनिर्धारित',
	'diff' => 'भिन्न',
	'destfilename' => 'गन्तव्य फाइलनाम :',
	'download' => 'डाउनलोड',
	'disambiguations' => 'बहुविकल्पी पृष्ठहरु',
	'disambiguationspage' => 'Template:बहुविकल्प',
	'doubleredirects' => 'दोहोरो अनुप्रेषण',
	'deadendpages' => 'हदै-अन्तकि पृष्ठहरु',
	'deadendpagestext' => 'निम्न पृष्ठहरु {{SITENAME}}मा रहेका अरु पृष्ठहरुसँग जोडिदैनन् ।',
	'deletedcontributions' => 'प्रयोगकर्ता योगदानहरु मेटाइयो',
	'deletedcontributions-title' => 'प्रयोगकर्ता योगदानहरु मेटाइयो',
	'defemailsubject' => '{{SITENAME}} ई-मेल',
	'deletepage' => 'पृष्ठ मेट्नुहोस्',
	'delete-confirm' => 'मेट्नुहोस् "$1"',
	'delete-legend' => 'मेट्नुहोस्',
	'deletedtext' => '"<nowiki>$1</nowiki>" मेटिएको छ।
हालै हटाइएको सूची $2 मा हेर्नुहोस् ।',
	'deletedarticle' => '"[[$1]]" मेटियो',
	'dellogpage' => 'मेटाएको लग',
	'deletionlog' => 'मेटाइएको लग',
	'deletecomment' => 'कारण :',
	'deleteotherreason' => 'अरू/थप कारणहरू :',
	'deletereasonotherlist' => 'अरु कारण',
	'delete-edit-reasonlist' => 'मेट्नुको कारण सम्पादन गर्नुहोस्',
	'databasenotlocked' => 'डेटाबेस ताल्चा मारिइएको छैन',
	'delete_and_move' => 'I र P बिचमा B फ्रेम',
	'delete_and_move_confirm' => 'हो, पृष्ठ मेट्नुहोस्',
	'deletedrevision' => 'संशोधन/ट्याग प्रयोग गर्नुहोस्:',
	'dberr-header' => 'यो विकिमा समस्या छ',
);

$messages['new'] = array(
	'december' => 'डिसेम्बर',
	'december-gen' => 'डिसेम्बर',
	'dec' => 'डिस',
	'disclaimers' => 'डिस्क्लेमर्स',
	'disclaimerpage' => 'Project:साधारण डिस्क्लेमर्स',
	'databaseerror' => 'डेटाबेस इरर',
	'dberrortext' => 'छगू डेटाबेस क्वेरी सिन्ट्याक्स इरर जूगु दु।
थ्व इररं सफ्टवेयरय् bug दूगु इंगीत यायेफु।
थ्व स्वया न्हः कोशिस जूगु डेटाबेस क्वेरी
"<tt>$2</tt>" फंक्सनया
<blockquote><tt>$1</tt></blockquote> ख।
MySQL नं इरर "<tt>$3: $4</tt>" क्यंगु दु।',
);

$messages['niu'] = array(
	'december' => 'Tesemo',
	'december-gen' => 'Tesemo',
	'delete' => 'Tamate',
	'delete-legend' => 'Tamate',
);

$messages['nl'] = array(
	'december' => 'december',
	'december-gen' => 'december',
	'dec' => 'dec',
	'delete' => 'Verwijderen',
	'deletethispage' => 'Deze pagina verwijderen',
	'disclaimers' => 'Voorbehoud',
	'disclaimerpage' => 'Project:Algemeen voorbehoud',
	'databaseerror' => 'Databasefout',
	'dberrortext' => 'Er is een syntaxisfout in het databaseverzoek opgetreden.
Mogelijk zit er een fout in de software.
Het laatste verzoek aan de database was:
<blockquote><tt>$1</tt></blockquote>
vanuit de functie “<tt>$2</tt>”.
De database gaf de volgende foutmelding “<tt>$3: $4</tt>”.',
	'dberrortextcl' => 'Er is een syntaxisfout in het databaseverzoek opgetreden.
Het laatste verzoek aan de database was:
“$1”
vanuit de functie “$2”.
De database gaf de volgende foutmelding: “$3: $4”',
	'directorycreateerror' => 'Map “$1” kon niet aangemaakt worden.',
	'deletedhist' => 'verwijderde geschiedenis',
	'difference' => '(Verschil tussen bewerkingen)',
	'difference-multipage' => "(Verschil tussen pagina's)",
	'diff-multi' => '({{PLURAL:$1|Eén tussenliggende versie|$1 tussenliggende versies}} door {{PLURAL:$2|één gebruiker|$2 gebruikers}} {{PLURAL:$1|wordt|worden}} niet weergegeven)',
	'diff-multi-manyusers' => '($1 tussenliggende {{PLURAL:$1|versie|versies}} door meer dan $2 {{PLURAL:$2|gebruiker|gebruikers}}  worden niet weergegeven)',
	'datedefault' => 'Geen voorkeur',
	'defaultns' => 'Anders in de volgende naamruimten zoeken:',
	'default' => 'standaard',
	'diff' => 'wijz',
	'destfilename' => 'Opslaan als:',
	'duplicatesoffile' => '{{PLURAL:$1|Het volgende bestand is|De volgende $1 bestanden zijn}} identiek aan dit bestand ([[Special:FileDuplicateSearch/$2|meer details]]):',
	'download' => 'downloaden',
	'disambiguations' => "Pagina's die verwijzen naar doorverwijspagina's",
	'disambiguationspage' => 'Template:Doorverwijspagina',
	'disambiguations-text' => "Hieronder staan pagina's die verwijzen naar een '''doorverwijspagina'''.
Deze horen waarschijnlijk direct naar het juiste onderwerp te verwijzen.
<br />Een pagina wordt gezien als doorverwijspagina als er een sjabloon op staat dat opgenomen is op [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dubbele doorverwijzingen',
	'doubleredirectstext' => "Deze lijst bevat pagina's die doorverwijzen naar andere doorverwijspagina's.
Elke rij bevat verwijzingen naar de eerste en de tweede doorverwijspagina en een verwijzing naar de doelpagina van de tweede doorverwijspagina.
Meestal is de laatste pagina het eigenlijke doel, waar de eerste pagina naar zou moeten doorverwijzen.
<del>Doorgehaalde regels</del> geven aan dat het probleem al is opgelost.",
	'double-redirect-fixed-move' => '[[$1]] is verplaatst en is nu een doorverwijzing naar [[$2]]',
	'double-redirect-fixed-maintenance' => 'Correctie dubbele doorverwijzing van [[$1]] naar [[$2]].',
	'double-redirect-fixer' => 'Doorverwijzingen opschonen',
	'deadendpages' => "Pagina's zonder verwijzingen",
	'deadendpagestext' => "De onderstaande pagina's verwijzen niet naar andere pagina's in deze wiki.",
	'deletedcontributions' => 'Verwijderde bijdragen',
	'deletedcontributions-title' => 'Verwijderde gebruikersbijdragen',
	'defemailsubject' => 'E-mail van {{SITENAME}}-gebruiker "$1"',
	'deletepage' => 'Pagina verwijderen',
	'delete-confirm' => '"$1" verwijderen',
	'delete-legend' => 'Verwijderen',
	'deletedtext' => '"$1" is verwijderd.
Zie het $2 voor een overzicht van recente verwijderingen.',
	'dellogpage' => 'Verwijderingslogboek',
	'dellogpagetext' => "Hieronder wordt een lijst met recent verwijderde pagina's en bestanden weergegeven.",
	'deletionlog' => 'verwijderingslogboek',
	'deletecomment' => 'Reden:',
	'deleteotherreason' => 'Andere reden:',
	'deletereasonotherlist' => 'Andere reden',
	'deletereason-dropdown' => '*Veel voorkomende verwijderredenen
** Op aanvraag van auteur
** Schending van auteursrechten
** Vandalisme',
	'delete-edit-reasonlist' => 'Redenen voor verwijderen bewerken',
	'delete-toobig' => "Deze pagina heeft een lange bewerkingsgeschiedenis, meer dan $1 {{PLURAL:$1|versie|versies}}.
Het verwijderen van dit soort pagina's is met rechten beperkt om het per ongeluk verstoren van de werking van {{SITENAME}} te voorkomen.",
	'delete-warning-toobig' => 'Deze pagina heeft een lange bewerkingsgeschiedenis, meer dan $1 {{PLURAL:$1|versie|versies}}.
Het verwijderen van deze pagina kan de werking van de database van {{SITENAME}} verstoren.
Wees voorzichtig.',
	'databasenotlocked' => 'De database is niet geblokkeerd.',
	'delete_and_move' => 'Verwijderen en hernoemen',
	'delete_and_move_text' => '==Verwijdering nodig==
Onder de naam "[[:$1]]" bestaat al een pagina.
Wilt u deze verwijderen om plaats te maken voor de te hernoemen pagina?',
	'delete_and_move_confirm' => 'Ja, de pagina verwijderen',
	'delete_and_move_reason' => 'Verwijderd in verband met hernoeming van "[[$1]]"',
	'djvu_page_error' => 'DjVu-pagina buiten bereik',
	'djvu_no_xml' => 'De XML voor het DjVu-bestand kon niet opgehaald worden',
	'deletedrevision' => 'De oude versie $1 is verwijderd',
	'days' => '{{PLURAL:$1|$1 dag|$1 dagen}}',
	'deletedwhileediting' => "'''Let op''': deze pagina is verwijderd terwijl u bezig was met uw bewerking!",
	'descending_abbrev' => 'afl.',
	'duplicate-defaultsort' => 'Waarschuwing: De standaardsortering "$2" krijgt voorrang voor de sortering "$1".',
	'dberr-header' => 'Deze wiki heeft een probleem',
	'dberr-problems' => 'Onze excuses. Deze site ondervindt op het moment technische problemen.',
	'dberr-again' => 'Wacht een aantal minuten en probeer het daarna opnieuw.',
	'dberr-info' => '(Kan geen verbinding maken met de databaseserver: $1)',
	'dberr-usegoogle' => 'Wellicht kunt u in de tussentijd zoeken via Google.',
	'dberr-outofdate' => "Let op: hun indexen van onze pagina's zijn wellicht niet recent.",
	'dberr-cachederror' => 'Deze pagina is een kopie uit de cache en is wellicht niet de meest recente versie.',
	'discuss' => 'Overleg',
);

$messages['nl-informal'] = array(
	'delete_and_move_text' => '==Verwijdering nodig==
Onder de naam "[[:$1]]" bestaat al een pagina.
Wil je deze verwijderen om plaats te maken voor de te hernoemen pagina?',
	'deletedwhileediting' => "'''Let op''': deze pagina is verwijderd terwijl je bezig was met je bewerking!",
	'dberr-usegoogle' => 'Wellicht kun je in de tussentijd zoeken via Google.',
);

$messages['nn'] = array(
	'december' => 'desember',
	'december-gen' => 'desember',
	'dec' => 'des',
	'delete' => 'Slett',
	'deletethispage' => 'Slett denne sida',
	'disclaimers' => 'Atterhald',
	'disclaimerpage' => 'Project:Atterhald',
	'databaseerror' => 'Databasefeil',
	'dberrortext' => 'Det oppstod ein syntaksfeil i databaseførespurnaden. Dette kan tyde på ein feil i programvara. Den sist prøvde førespurnaden var: <blockquote><tt>$1</tt></blockquote> frå innan funksjonen «<tt>$2</tt>». Databasen returnerte feilen «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'Det oppstod ein syntaksfeil i databaseførespurnaden.
Den sist prøvde førespurnaden var: «$1» frå funksjonen «$2».
Databasen returnerte feilen «$3: $4».',
	'directorycreateerror' => 'Kunne ikkje opprette mappa «$1».',
	'deletedhist' => 'Sletta historikk',
	'difference' => '(Skilnad mellom versjonar)',
	'difference-multipage' => '(Skilnad mellom sider)',
	'diff-multi' => '({{PLURAL:$1|Éin mellomversjon|$1 mellomversjonar}} frå {{PLURAL:$2|éin brukar|$2 brukarar}} er ikkje {{PLURAL:$1|vist|viste}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Ein mellomversjon|$1 mellomversjonar}} av meir enn $2 {{PLURAL:$2|brukar|brukarar}}  er ikkje {{PLURAL:$1|vist|viste}})',
	'datedefault' => 'Standard',
	'defaultns' => 'Søk elles i desse namneromma:',
	'default' => 'standard',
	'diff' => 'skil',
	'destfilename' => 'Målfilnamn:',
	'duplicatesoffile' => 'Følgjande {{PLURAL:$1|fil er ein dublett|filer er dublettar}} av denne fila ([[Special:FileDuplicateSearch/$2|fleire detaljar]]):',
	'download' => 'last ned',
	'disambiguations' => 'Sider som lenkjer til fleirtydingssider',
	'disambiguationspage' => 'Template:Fleirtyding',
	'disambiguations-text' => "Sidene nedanfor har lenkje til ei '''fleirtydingsside'''. Dei bør ha lenkje til det rette oppslagsordet i staden for.<br />Sider vert handsama som fleirtydingssider dersom dei inneheld ein mal som har lenkje på [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Doble omdirigeringar',
	'doubleredirectstext' => 'Kvar line inneheld lenkjer til den første og den andre omdirigeringa, og den første lina frå den andre omdirigeringsteksten. Det gjev som regel den «rette» målartikkelen, som den første omdirigeringa skulle ha peikt på. <del>Overstrykne</del> liner har vorte retta på.',
	'double-redirect-fixed-move' => '[[$1]] har blitt flytta, og er no ei omdirigering til [[$2]]',
	'double-redirect-fixed-maintenance' => 'Rettar dobbel omdirigering frå [[$1]] til [[$2]].',
	'double-redirect-fixer' => 'Omdirigeringsfiksar',
	'deadendpages' => 'Blindvegsider',
	'deadendpagestext' => 'Desse sidene har ikkje lenkjer til andre sider på {{SITENAME}}.',
	'deletedcontributions' => 'Sletta brukarbidrag',
	'deletedcontributions-title' => 'Sletta brukarbidrag',
	'defemailsubject' => '{{SITENAME}} epost frå brukar "$1"',
	'deletepage' => 'Slett sida',
	'delete-confirm' => 'Slett «$1»',
	'delete-legend' => 'Slett',
	'deletedtext' => '«$1» er sletta. Sjå $2en for eit oversyn over dei siste slettingane.',
	'dellogpage' => 'Slettelogg',
	'dellogpagetext' => 'Her er ei liste over dei siste slettingane.',
	'deletionlog' => 'slettelogg',
	'deletecomment' => 'Årsak:',
	'deleteotherreason' => 'Annan grunn:',
	'deletereasonotherlist' => 'Annan grunn',
	'deletereason-dropdown' => '*Vanlege grunnar for sletting
** På førespurnad frå forfattaren
** Brot på opphavsretten
** Hærverk',
	'delete-edit-reasonlist' => 'Endre grunnar til sletting',
	'delete-toobig' => 'Denne sida har ein stor endringsshistorikk, med over {{PLURAL:$1|$1&nbsp;endring|$1&nbsp;endringar}}. Sletting av slike sider er avgrensa for å unngå utilsikta forstyrring av {{SITENAME}}.',
	'delete-warning-toobig' => 'Denne sida har ein lang endringshistorikk, med meir enn {{PLURAL:$1|$1&nbsp;endring|$1&nbsp;endringar}}. Dersom du slettar henne kan det forstyrre handlingar i databasen til {{SITENAME}}, ver varsam.',
	'databasenotlocked' => 'Databasen er ikkje låst.',
	'delete_and_move' => 'Slett og flytt',
	'delete_and_move_text' => '== Sletting påkrevd ==

Målsida «[[:$1]]» finst allereie. Vil du slette ho for å gje rom for flytting?',
	'delete_and_move_confirm' => 'Ja, slett sida',
	'delete_and_move_reason' => 'Sletta for å gi rom for flytting frå "[[$1]]"',
	'djvu_page_error' => 'DjVu-sida er utanfor rekkjevidd',
	'djvu_no_xml' => 'Klarte ikkje hente inn XML for DjVu-fila',
	'deletedrevision' => 'Slett gammal versjon $1',
	'deletedwhileediting' => "'''Åtvaring:''' Denne sida har vorte sletta etter du starta å endre henne!",
	'descending_abbrev' => 'synkande',
	'duplicate-defaultsort' => 'Åtvaring: Standarsorteringa «$2» tar over for den tidlegare sorteringa «$1».',
	'dberr-header' => 'Denne wikien har eit problem',
	'dberr-problems' => 'Nettstaden har tekniske problem.',
	'dberr-again' => 'Venta nokre minutt og last sida inn på nytt.',
	'dberr-info' => '(Kan ikkje kontakta databasetenaren: $1)',
	'dberr-usegoogle' => 'Du kan søkja gjennom Google i mellomtida.',
	'dberr-outofdate' => 'Merk at versjonane deira av innhaldet vårt kan vera forelda.',
	'dberr-cachederror' => 'Fylgjande er ein mellomlagra kopi av den etterspurde sida, og er, kan henda, ikkje den siste versjonen av ho.',
);

$messages['no'] = array(
	'december' => 'desember',
	'december-gen' => 'desember',
	'dec' => 'des',
	'delete' => 'Slett',
	'deletethispage' => 'Slett denne sida',
	'disclaimers' => 'Atterhald',
	'disclaimerpage' => 'Project:Atterhald',
	'databaseerror' => 'Databasefeil',
	'dberrortext' => 'Det oppstod ein syntaksfeil i databaseførespurnaden. Dette kan tyde på ein feil i programvara. Den sist prøvde førespurnaden var: <blockquote><tt>$1</tt></blockquote> frå innan funksjonen «<tt>$2</tt>». Databasen returnerte feilen «<tt>$3: $4</tt>».',
	'dberrortextcl' => 'Det oppstod ein syntaksfeil i databaseførespurnaden.
Den sist prøvde førespurnaden var: «$1» frå funksjonen «$2».
Databasen returnerte feilen «$3: $4».',
	'directorycreateerror' => 'Kunne ikkje opprette mappa «$1».',
	'deletedhist' => 'Sletta historikk',
	'difference' => '(Skilnad mellom versjonar)',
	'difference-multipage' => '(Skilnad mellom sider)',
	'diff-multi' => '({{PLURAL:$1|Éin mellomversjon|$1 mellomversjonar}} frå {{PLURAL:$2|éin brukar|$2 brukarar}} er ikkje {{PLURAL:$1|vist|viste}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Ein mellomversjon|$1 mellomversjonar}} av meir enn $2 {{PLURAL:$2|brukar|brukarar}}  er ikkje {{PLURAL:$1|vist|viste}})',
	'datedefault' => 'Standard',
	'defaultns' => 'Søk elles i desse namneromma:',
	'default' => 'standard',
	'diff' => 'skil',
	'destfilename' => 'Målfilnamn:',
	'duplicatesoffile' => 'Følgjande {{PLURAL:$1|fil er ein dublett|filer er dublettar}} av denne fila ([[Special:FileDuplicateSearch/$2|fleire detaljar]]):',
	'download' => 'last ned',
	'disambiguations' => 'Sider som lenkjer til fleirtydingssider',
	'disambiguationspage' => 'Template:Fleirtyding',
	'disambiguations-text' => "Sidene nedanfor har lenkje til ei '''fleirtydingsside'''. Dei bør ha lenkje til det rette oppslagsordet i staden for.<br />Sider vert handsama som fleirtydingssider dersom dei inneheld ein mal som har lenkje på [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Doble omdirigeringar',
	'doubleredirectstext' => 'Kvar line inneheld lenkjer til den første og den andre omdirigeringa, og den første lina frå den andre omdirigeringsteksten. Det gjev som regel den «rette» målartikkelen, som den første omdirigeringa skulle ha peikt på. <del>Overstrykne</del> liner har vorte retta på.',
	'double-redirect-fixed-move' => '[[$1]] har blitt flytta, og er no ei omdirigering til [[$2]]',
	'double-redirect-fixed-maintenance' => 'Rettar dobbel omdirigering frå [[$1]] til [[$2]].',
	'double-redirect-fixer' => 'Omdirigeringsfiksar',
	'deadendpages' => 'Blindvegsider',
	'deadendpagestext' => 'Desse sidene har ikkje lenkjer til andre sider på {{SITENAME}}.',
	'deletedcontributions' => 'Sletta brukarbidrag',
	'deletedcontributions-title' => 'Sletta brukarbidrag',
	'defemailsubject' => '{{SITENAME}} epost frå brukar "$1"',
	'deletepage' => 'Slett sida',
	'delete-confirm' => 'Slett «$1»',
	'delete-legend' => 'Slett',
	'deletedtext' => '«$1» er sletta. Sjå $2en for eit oversyn over dei siste slettingane.',
	'dellogpage' => 'Slettelogg',
	'dellogpagetext' => 'Her er ei liste over dei siste slettingane.',
	'deletionlog' => 'slettelogg',
	'deletecomment' => 'Årsak:',
	'deleteotherreason' => 'Annan grunn:',
	'deletereasonotherlist' => 'Annan grunn',
	'deletereason-dropdown' => '*Vanlege grunnar for sletting
** På førespurnad frå forfattaren
** Brot på opphavsretten
** Hærverk',
	'delete-edit-reasonlist' => 'Endre grunnar til sletting',
	'delete-toobig' => 'Denne sida har ein stor endringsshistorikk, med over {{PLURAL:$1|$1&nbsp;endring|$1&nbsp;endringar}}. Sletting av slike sider er avgrensa for å unngå utilsikta forstyrring av {{SITENAME}}.',
	'delete-warning-toobig' => 'Denne sida har ein lang endringshistorikk, med meir enn {{PLURAL:$1|$1&nbsp;endring|$1&nbsp;endringar}}. Dersom du slettar henne kan det forstyrre handlingar i databasen til {{SITENAME}}, ver varsam.',
	'databasenotlocked' => 'Databasen er ikkje låst.',
	'delete_and_move' => 'Slett og flytt',
	'delete_and_move_text' => '== Sletting påkrevd ==

Målsida «[[:$1]]» finst allereie. Vil du slette ho for å gje rom for flytting?',
	'delete_and_move_confirm' => 'Ja, slett sida',
	'delete_and_move_reason' => 'Sletta for å gi rom for flytting frå "[[$1]]"',
	'djvu_page_error' => 'DjVu-sida er utanfor rekkjevidd',
	'djvu_no_xml' => 'Klarte ikkje hente inn XML for DjVu-fila',
	'deletedrevision' => 'Slett gammal versjon $1',
	'deletedwhileediting' => "'''Åtvaring:''' Denne sida har vorte sletta etter du starta å endre henne!",
	'descending_abbrev' => 'synkande',
	'duplicate-defaultsort' => 'Åtvaring: Standarsorteringa «$2» tar over for den tidlegare sorteringa «$1».',
	'dberr-header' => 'Denne wikien har eit problem',
	'dberr-problems' => 'Nettstaden har tekniske problem.',
	'dberr-again' => 'Venta nokre minutt og last sida inn på nytt.',
	'dberr-info' => '(Kan ikkje kontakta databasetenaren: $1)',
	'dberr-usegoogle' => 'Du kan søkja gjennom Google i mellomtida.',
	'dberr-outofdate' => 'Merk at versjonane deira av innhaldet vårt kan vera forelda.',
	'dberr-cachederror' => 'Fylgjande er ein mellomlagra kopi av den etterspurde sida, og er, kan henda, ikkje den siste versjonen av ho.',
	'discuss' => 'Diskuter',
);

$messages['nov'] = array(
	'december' => 'desembre',
	'december-gen' => 'de desembre',
	'dec' => 'des',
	'delete' => 'Ekarta',
	'deletethispage' => 'Ekarta disi pagine',
	'deadendpages' => 'Pagines sin kuplures',
	'dellogpage' => 'Loge de ekartos',
	'dellogpagetext' => 'Subu es liste del maxim resenti ekartos.',
	'deletionlog' => 'registre de ekartos',
	'deletecomment' => 'Resone:',
	'delete_and_move' => 'Ekarta e mova',
	'delete_and_move_confirm' => 'Yes, ekarta li pagine',
	'delete_and_move_reason' => 'Ekartat por fa spatie por movo "[[$1]]"',
);

$messages['nso'] = array(
	'december' => 'Manthole',
	'december-gen' => 'Manthole',
	'dec' => 'Manthole',
	'delete' => 'Phumula',
	'deletethispage' => 'Phumula letlakala le',
	'disclaimers' => 'Hlapa-matsogo',
	'disclaimerpage' => 'Project:Hlapa-Matsogo',
	'databaseerror' => 'Phošo ya Database',
	'difference' => '(Phapang magareng ga dipoeletšo)',
	'diff-multi' => '({{PLURAL:$1|Phetogo ye kgolo|Diphetogo tše $1 tše kgolo}} gadi laetšwe.)',
	'diff' => 'phapang',
	'disambiguations' => "Matlakala a ''Disambiguation''",
	'doubleredirects' => "Di''redirect'' goya go ''redirect''",
	'deadendpages' => "Matlakala a seye felo(''Dead-end'')",
	'deletedcontributions' => 'Diabe tša mošomiši tšeo di phumutšwego',
	'deletedcontributions-title' => 'Diabe tša mošomiši tšeo di phumutšwego',
	'deletepage' => 'Phumula letlakala',
	'delete-legend' => 'Phumula',
	'deletedtext' => '"<nowiki>$1</nowiki>" e phumutšwe.
Lebelela $2 go hweetša sedi ka diphulo tša bjale.',
	'deletedarticle' => 'E phumutšwe "[[$1]]"',
	'dellogpage' => "''Log'' yago phumula",
	'deletecomment' => 'Lebaka:',
	'deleteotherreason' => 'Mabaka a mangwe:',
	'deletereasonotherlist' => 'Mabaka a mangwe',
	'delete_and_move_confirm' => 'E, phumula letlakala le',
);

$messages['nv'] = array(
	'december' => 'Níłchʼitsoh',
	'december-gen' => 'Níłchʼitsoh',
	'dec' => 'Ntsx',
	'delete' => 'sisxé (delete)',
);

$messages['oc'] = array(
	'december' => 'de decembre',
	'december-gen' => 'Decembre',
	'dec' => 'de dec',
	'delete' => 'Suprimir',
	'deletethispage' => 'Suprimir aquesta pagina',
	'disclaimers' => 'Avertiments',
	'disclaimerpage' => 'Project:Avertiments generals',
	'databaseerror' => 'Error de la banca de donadas',
	'dberrortext' => "Una error de sintaxi de la requèsta dins la banca de donadas s'es producha.
Aquò pòt indicar una error dins lo logicial.
La darrièra requèsta tractada per la banca de donadas èra :
<blockquote><tt>$1</tt></blockquote>
dempuèi la foncion « <tt>$2</tt> ».
La banca de donadas a renviat l’error « <tt>$3 : $4</tt> ».",
	'dberrortextcl' => 'Una requèsta dins la banca de donadas compòrta una error de sintaxi.
La darrièra requèsta emesa èra :
« $1 »
dins la foncion « $2 ».
La banca de donadas a renviat l’error « $3 : $4 ».',
	'directorycreateerror' => 'Impossible de crear lo dorsièr « $1 ».',
	'deletedhist' => 'Istoric de las supressions',
	'difference' => '(Diferéncias entre las versions)',
	'difference-multipage' => '(Diferéncias entre las paginas)',
	'diff-multi' => '({{PLURAL:$1|Una revision intermediària amagada|$1 revisions intermediàrias amagadas}}) per ({{PLURAL:$2|un utilizaire pas afichada|$2 utilizaires pas afichadas}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Una revision intermediària amagada|$1 revisions intermediàrias amagadas}}) per ({{PLURAL:$2|un utilizaire pas afichada|$2 utilizaires pas afichadas}})',
	'datedefault' => 'Cap de preferéncia',
	'defaultns' => 'Autrament recercar dins aquestes espacis de noms :',
	'default' => 'defaut',
	'diff' => 'dif',
	'destfilename' => 'Nom jolqual lo fichièr serà enregistrat&nbsp;:',
	'duplicatesoffile' => "{{PLURAL:$1|Lo fichièr seguent es un duplicata|Los fichièrs seguents son de duplicatas}} d'aqueste fichièr ([[Special:FileDuplicateSearch/$2|mai de detalhs]]):",
	'download' => 'telecargament',
	'disambiguations' => "Paginas d'omonimia",
	'disambiguationspage' => 'Template:Omonimia',
	'disambiguations-text' => "Las paginas seguentas puntan cap a una '''pagina d’omonimia'''.
Deurián puslèu puntar cap a una pagina apropriada.<br />
Una pagina es tractada coma una pagina d’omonimia s'utiliza un modèl qu'es ligat a partir de [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Redireccions doblas',
	'doubleredirectstext' => 'Vaquí una lista de las paginas que redirigisson cap a de paginas que son elas-meteissas de paginas de redireccion.
Cada entrada conten de ligams cap a la primièra e la segonda redireccions, e mai la primièra linha de tèxte de la segonda pagina, çò que provesís, de costuma, la « vertadièra » pagina cibla, cap a la quala la primièra redireccion deuriá redirigir.
Las entradas <del>barradas</del> son estadas resolgudas.',
	'double-redirect-fixed-move' => '[[$1]] es estat renomenat, aquò es ara una redireccion cap a [[$2]]',
	'double-redirect-fixer' => 'Corrector de redireccion',
	'deadendpages' => "Paginas sul camin d'enlòc",
	'deadendpagestext' => 'Las paginas seguentas contenon pas cap de ligam cap a d’autras paginas de {{SITENAME}}.',
	'deletedcontributions' => 'Contribucions suprimidas d’un utilizaire',
	'deletedcontributions-title' => 'Contribucions suprimidas d’un utilizaire',
	'defemailsubject' => 'Corrièr electronic mandat dempuèi {{SITENAME}}',
	'deletepage' => 'Suprimir la pagina',
	'delete-confirm' => 'Escafar «$1»',
	'delete-legend' => 'Escafar',
	'deletedtext' => '"$1" es estat suprimit.
Vejatz $2 per una lista de las supressions recentas.',
	'dellogpage' => 'Istoric dels escafaments',
	'dellogpagetext' => 'Vaquí çaijós la lista de las supressions recentas.',
	'deletionlog' => 'istoric dels escafaments',
	'deletecomment' => 'Motiu :',
	'deleteotherreason' => 'Motius suplementaris o autres :',
	'deletereasonotherlist' => 'Autre motiu',
	'deletereason-dropdown' => "*Motius de supression mai corrents
** Demanda de l'autor
** Violacion dels dreches d'autor
** Vandalisme",
	'delete-edit-reasonlist' => 'Modifica los motius de la supression',
	'delete-toobig' => "Aquesta pagina dispausa d'un istoric important, depassant {{PLURAL:$1|revision|revisions}}.
La supression de talas paginas es estada limitada per evitar de perturbacions accidentalas de {{SITENAME}}.",
	'delete-warning-toobig' => "Aquesta pagina dispausa d'un istoric important, depassant {{PLURAL:$1|revision|revisions}}.
La suprimir pòt perturbar lo foncionament de la banca de donada de {{SITENAME}}.
D'efectuar amb prudéncia.",
	'databasenotlocked' => 'La banca de donadas es pas varrolhada.',
	'delete_and_move' => 'Suprimir e tornar nomenar',
	'delete_and_move_text' => '==Supression requerida==
L’article de destinacion « [[:$1]] » existís ja.
Lo volètz suprimir per permetre lo cambiament de nom ?',
	'delete_and_move_confirm' => 'Òc, accèpti de suprimir la pagina de destinacion per permetre lo cambiament de nom.',
	'delete_and_move_reason' => 'Pagina suprimida per permetre un cambiament de nom',
	'djvu_page_error' => 'Pagina DjVu fòra limits',
	'djvu_no_xml' => "Impossible d’obténer l'XML pel fichièr DjVu",
	'deletedrevision' => 'La version anciana $1 es estada suprimida.',
	'deletedwhileediting' => "'''Atencion''' : aquesta pagina es estada suprimida aprèp qu'avètz començat de la modificar !",
	'descending_abbrev' => 'descreissent',
	'duplicate-defaultsort' => 'Atencion : La clau de triada per defaut « $2 » espotís la mai recenta « $1 ».',
	'dberr-header' => 'Aqueste wiki a un problèma',
	'dberr-problems' => 'O planhèm ! Aqueste site rencontra de dificultats tecnicas.',
	'dberr-again' => "Ensajatz d'esperar qualques minutas e tornatz cargar.",
	'dberr-info' => '(Se pòt pas connectar al servidor de la banca de donadas : $1)',
	'dberr-usegoogle' => 'Podètz ensajar de cercar amb Google pendent aqueste temps.',
	'dberr-outofdate' => 'Notatz que lors indèxes de nòstre contengut pòdon èsser depassats.',
	'dberr-cachederror' => 'Aquò es una còpia amagada de la pagina demandada e pòt èsser depassada.',
);

$messages['om'] = array(
	'december' => 'Muddee',
	'deletecomment' => 'Sababa:',
);

$messages['or'] = array(
	'december' => 'ଡିସେମ୍ବର',
	'december-gen' => 'ଡିସେମ୍ବର',
	'dec' => 'ଡିସେମ୍ବର',
	'delete' => 'ଲିଭାଇବେ',
	'deletethispage' => 'ଏହି ପୃଷ୍ଠାଟି ଲିଭାଇବେ',
	'disclaimers' => 'ଆମେ ଦାୟୀ ନୋହୁଁ',
	'disclaimerpage' => 'Project:ଆମେ ଦାୟୀ ନୋହୁଁ',
	'databaseerror' => 'ଡାଟାବେସରେ ଭୁଲ',
	'dberrortext' => 'ଡାଟାବେସ ପ୍ରଶ୍ନ ଖୋଜା ଭୁଲ ଟିଏ ହୋଇଅଛି ।
ଏହା ଏହି ସଫ୍ଟବେରରେ ଭୁଲଟିଏକୁ ମଧ୍ୟ ସୂଚାଇପାରେ ।
ଶେଷ ଥର ଖୋଜାଯାଇଥିବା ଡାଟାବେସ ପ୍ରଶ୍ନ ଖୋଜାଟି ଥିଲା:
"<tt>$2</tt>" କାମ ଭିତରୁ
<blockquote><tt>$1</tt></blockquote> ।
ଡାଟାବେସ ଫେରନ୍ତା ଭୁଲ "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'ଡାଟାବେସ ପ୍ରଶ୍ନ ଖୋଜା ଭୁଲଟିଏ ହୋଇଅଛି ।
ଶେଷ ଖୋଜା ଡାଟାବେସ ପ୍ରଶ୍ନଟି ଥିଲା:
"$1"
ଯାହା "$2" ଭିତରୁ ନିଆଯାଇଥିଲା ।
ଡାଟାବେସ ଫେରନ୍ତା ଭୁଲ "$3: $4"',
	'directorycreateerror' => '"$1" ସୂଚିଟି ତିଆରି କରିପାରିଲୁଁ ନାହିଁ ।',
	'deletedhist' => 'ଲିଭାଯାଇଥିବା ଇତିହାସ',
	'difference' => '(ସଙ୍କଳନ ଭିତରେ ଥିବା ତଫାତ)',
	'difference-multipage' => '(ପୃଷ୍ଠା ଭିତରେ ଥିବା ତଫାତ)‌',
	'diff-multi' => '({{PLURAL:$2|ଜଣେ ବ୍ୟବହାରକାରୀ|$2 ଜଣ ବ୍ୟବହାରକାରୀ}}ଙ୍କ ଦେଇ ହୋଇଥିବା {{PLURAL:$1|ଗୋଟିଏ ମଝି ସଙ୍କଳନ|$1ଟି ମଝି ସଙ୍କଳନ}} ଦେଖାଯାଉନାହିଁ)',
	'diff-multi-manyusers' => '($2 {{PLURAL:$2|ଜଣ|ଜଣ}} ସଭ୍ୟଙ୍କ ଦେଇ କରାଯାଇଥିବା {{PLURAL:$1|ଗୋଟିଏ ମଝି ସଂସ୍କରଣ|$1 ଗୋଟି ମଝି ସଂସ୍କରଣମାନ}} ଦେଖାଯାଉ ନାହିଁ)',
	'datedefault' => 'କୌଣସି ପସନ୍ଦ ନାହିଁ',
	'defaultns' => 'ନଚେତ ଏହି ନେମସ୍ପେସ ଗୁଡ଼ିକରେ ଖୋଜନ୍ତୁ:',
	'default' => 'ପୂର୍ବ ନିର୍ଦ୍ଧାରିତ',
	'diff' => 'ଅଦଳ ବଦଳ',
	'destfilename' => ':ମୁକାମ ଫାଇଲ ନାମ:',
	'duplicatesoffile' => 'ତଳଲିଖିତ {{PLURAL:$1|ଫାଇଲଟି ଏହି ଫାଇଲର ଏକ ନକଲ|$1 ଫାଇଲସବୁ ଏହି ଫାଇଲର ନକଲ ଅଟନ୍ତି}} ([[Special:FileDuplicateSearch/$2|ଅଧିକ ସବିଶେଷ]]):',
	'download' => 'ଡାଉନଲୋଡ଼',
	'disambiguations' => 'ବହୁବିକଳ୍ପ ପୃଷ୍ଠାମାନଙ୍କ ସହ ଯୋଡ଼ା ପୃଷ୍ଠା',
	'disambiguationspage' => 'Template:ବହୁବିକଳ୍ପ',
	'disambiguations-text' => "ତଲାଲିଖିତ ପୃଷ୍ଠାମାନ '''ବହୁବିକଳ୍ପ ପୃଷ୍ଠା'''କୁ ଯୋଡ଼ିଥାନ୍ତି ।
ସେହିସବୁ ଉପଯୁକ୍ତ ପ୍ରସଙ୍ଗ ସହ ଯୋଡ଼ାହେବା ଜରୁରୀ ।<br />
A page is treated as disambiguation page if it uses a template which is linked from [[MediaWiki:Disambiguationspage]] ସହ ଯୋଡ଼ାଥିବା ଛାଞ୍ଚ ବ୍ୟବହାର କରୁଥିଲେ ପୃଷ୍ଠାଟିଏକୁ ବହୁବିକଳ୍ପ ପୃଷ୍ଠା ବୋଲି କୁହାଯାଏ",
	'doubleredirects' => 'ଯୋଡ଼ା ପୁନପ୍ରେରଣ',
	'doubleredirectstext' => 'ଏହି ପୃଷ୍ଠା ବାକି ବହୁବିକଳ୍ପ ପୃଷ୍ଠାମାନଙ୍କ ସହ ଯୋଡ଼ିଥାଏ ।
ପ୍ରତ୍ୟେକ ଧାଡ଼ିରେ ପ୍ରଥମ ଓ ଶେଷ ପୁନପ୍ରେରଣ ସହ ଯୋଡ଼ିବା ଲିଙ୍କ ରହିଥାଏ, ଆହୁରି ମଧ୍ୟ ଏଥିରେ ଦ୍ଵିତୀୟ ପୁନପ୍ରେରଣର ଲକ୍ଷ ସହ ଯୋଡ଼ିବାର ଲିଙ୍କ ଥାଏ , ଯାହାକି ସାଧାରଣତ "ପ୍ରକୃତ" ଲକ୍ଷ ପୃଷ୍ଠା ହୋଇଥାଏ, ଯାହାକୁ ପ୍ରଥମ ପୁନପ୍ରେରଣ ପୃଷ୍ଠା ଯୋଡ଼ିଥାଏ ।
<del>କଟାହୋଇଥିବା</del> ନିବେଶସବୁ ସଜଡ଼ାଗଲା ।',
	'double-redirect-fixed-move' => '[[$1]]କୁ ଘୁଞ୍ଚାଯାଇଅଛି ।
ଏବେ ଏହା [[$2]]କୁ ପୁନପ୍ରେରିତ ହୋଇଥାଏ ।',
	'double-redirect-fixed-maintenance' => '[[$1]] ରୁ [[$2]] କୁ ଦୁଇଟି ପୁନପ୍ରେରଣରେ ଥିବା ଅସୁବିଧା ସୁଧାରିଦେଲୁଁ ।',
	'double-redirect-fixer' => 'ପୁନପ୍ରେରଣ ସୁଧାରକ',
	'deadendpages' => 'ଆଗକୁ ଯାଇପାରୁନଥିବା ପୃଷ୍ଠା',
	'deadendpagestext' => 'ଏହି ପୃଷ୍ଠାସବୁ {{SITENAME}}ର ବାକି ପୃଷ୍ଠାମାନଙ୍କ ସଙ୍ଗେ ଯୋଡ଼ା ହୋଇ ନାହାନ୍ତି ।',
	'deletedcontributions' => 'ଲିଭାଇ ଦିଆଯାଇଥିବା ସଭ୍ୟଙ୍କ ଅବଦାନ',
	'deletedcontributions-title' => 'ଲିଭାଇ ଦିଆଯାଇଥିବା ସଭ୍ୟଙ୍କ ଅବଦାନସମୂହ',
	'defemailsubject' => '{{SITENAME}} "$1" ସଭ୍ୟଙ୍କ ଠାରୁ ଇ-ମେଲ କରିବେ',
	'deletepage' => 'ପୃଷ୍ଠାଟି ଲିଭାଇଦେବେ',
	'delete-confirm' => 'ଲିଭେଇବେ $1',
	'delete-legend' => 'ଲିଭାଇବେ',
	'deletedtext' => '"$1"କୁ ଲିଭାଇ ଦିଆଗଲା ।
ନଗଦ ଲିଭାଯାଇଥିବା ଫାଇଲର ଇତିହାସ $2ରେ ଦେଖନ୍ତୁ ।',
	'dellogpage' => 'ଲିଭାଇବା ଇତିହାସ',
	'dellogpagetext' => 'ତଳେ ନଗଦ ଲିଭାଯାଇଥିବା ପୃଷ୍ଠାମାନଙ୍କର ତାଲିକା ରହିଅଛି ।',
	'deletionlog' => 'ଲିଭାଇବା ଇତିହାସ',
	'deletecomment' => 'କାରଣ:',
	'deleteotherreason' => 'ବାକି/ଅଧିକ କାରଣ:',
	'deletereasonotherlist' => 'ଅଲଗା କାରଣ',
	'deletereason-dropdown' => '*ସାଧାରଣ ଲିଭାଇବା କାରଣ
** ଲେଖକ ଅନୁରୋଧ
** ସତ୍ଵାଧିକାର ଉଲଂଘନ
** ଅନୀତିକର କାମ',
	'delete-edit-reasonlist' => 'ଲିଭାଇବା କାରଣମାନ ବଦଳାଇବେ',
	'delete-toobig' => 'ଏହି ପୃଷ୍ଠାର ଏକ ଲମ୍ବା ସମ୍ପାଦନା ଇତିହାସ ଅଛି, ଯେଉଁଥିରେ $1  {{PLURAL:$1|ଟି ସଂସ୍କରଣ|ଗୋଟି ସଂସ୍କରଣ}} ରହିଛି ।
{{SITENAME}}ରେ ଦୁର୍ଘଟଣାବଶତ ଅସୁବିଧାକୁ ଏଡ଼ାଇବା ପାଇଁ ଏହାକୁ ଲିଭାଇବାରୁ ବାରଣ କରାଯାଇଛି ।',
	'delete-warning-toobig' => 'ଏହି ପୃଷ୍ଠାର ଏକ ଲମ୍ବ ସମ୍ପାଦନ ଇତିହାସ ରହିଛି, ଯେଉଁଥିରେ $1 {{PLURAL:$1|ଗୋଟି ସଂସ୍କରଣ|ଗୋଟି ସଂସ୍କରଣ}} ରହିଛି ।
ଏହାକୁ ଲିଭାଇଲେ {{SITENAME}}ରେ ଅସୁବିଧା ହୋଇପାରେ ।
ସାବଧାନତାର ସହ ଆଗକୁ ବଢ଼ନ୍ତୁ ।',
	'databasenotlocked' => 'ଡାଟାବେସଟି କିଳାଯାଇନାହିଁ ।',
	'delete_and_move' => 'ଲିଭାଇବେ ଓ ଘୁଞ୍ଚାଇବେ',
	'delete_and_move_text' => '== ଲିଭାଇବା ଦରକାର ==
ମୁକାମ ପୃଷ୍ଠା "[[:$1]]" ଟି ଆଗରୁ ଅଛି ।
ଆପଣ ଏହାକୁ ଲିଭାଇ ଘୁଞ୍ଚାଇବାକୁ ବାଟ କଢ଼ାଇବାକୁ ଚାହାନ୍ତି କି?',
	'delete_and_move_confirm' => 'ହଁ, ଏହି ପୃଷ୍ଠାଟିକୁ ଲିଭାଇଦେବେ',
	'delete_and_move_reason' => '"[[$1]]" ପାଇଁ ପଥ ସଳଖ କରିବା ନିମନ୍ତେ ଲିଭାଇଦିଆଗଲା',
	'djvu_page_error' => 'DjVu ପୃଷ୍ଠା ସୀମା ବାହାରେ ରହିଅଛି',
	'djvu_no_xml' => 'DjVu ଫାଇଲ ନିମନ୍ତେ XML ଆଣିବାରେ ବିଫଳ ହେଲୁଁ',
	'deletedrevision' => 'ଲିଭାଯାଇଥିବା ପୁରୁଣା $1',
	'days' => '{{PLURAL:$1|$1 ଦିନ|$1 ଦିନ}}',
	'deletedwhileediting' => "''' ସାବଧାନ ''' : ଆପଣ ବଦଳାଇବା ପାଇଁ ଆରମ୍ଭ କରିବା ପରେ ପରେ ହିଁ ଏହି ପୃଷ୍ଠାଟିକୁ ଲିଭାଇ ଦିଆଯାଇଛି !",
	'descending_abbrev' => 'ବଖାଣ',
	'duplicate-defaultsort' => '\'\'\'ସୂଚନା:\'\'\' ଆପେଆପେ କାମକରୁଥିବା "$2" ଆଗରୁ ଆପେ ଆପେ ସଜାଡୁଥିବା "$1"କୁ ବନ୍ଦ କରିଦେଇଛି ।',
	'dberr-header' => 'ଏହି ଉଇକିରେ କିଛି ଅସୁବିଧା ଅଛି ।',
	'dberr-problems' => 'କ୍ଷମାକରିବେ !
ଏହି ସାଇଟରେ ଟିକେ ଯାନ୍ତ୍ରିକ',
	'dberr-again' => 'କିଛି ମିନିଟ ଅପେକ୍ଷା କରିବା ସହ ଆଉ ଥରେ ଲୋଡ କରନ୍ତୁ ।',
	'dberr-info' => '(ଡାଟାବେସ ସର୍ଭର ସହ ଯୋଗାଯୋଗ କରିପାରିଲୁ ନାହିଁ: $1)',
	'dberr-usegoogle' => 'ଏହି ସମୟ ଭିତରେ ଆପଣ ଗୁଗଲରେ ଖୋଜି ପାରିବେ ।',
	'dberr-outofdate' => 'ଜାଣିରଖନ୍ତୁ ଯେ ଆମ ବିଷୟବସ୍ତୁକୁ ନେଇ ସେମାନେ ତିଆରିଥିବା ସୂଚି ବହୁପୁରାତନ ହୋଇପାରେ ।',
	'dberr-cachederror' => 'ଏହା ଅନୁରୋଧ କରାଯାଇଥିବା ପୃଷ୍ଠାର ଏକ ଆଗରୁ ସାଇତାଥିବା ନକଲ ଓ ସତେଜ ହୋଇ ନଥାଇପାରେ ।',
);

$messages['os'] = array(
	'december' => 'декабрь',
	'december-gen' => 'декабры',
	'dec' => 'дек',
	'delete' => 'Аппар',
	'deletethispage' => 'Аппарын ацы фарс',
	'disclaimers' => 'Бæрн нæ исыны тыххæй',
	'disclaimerpage' => 'Project:Нæ бæрн исыны тыххæй',
	'databaseerror' => 'Рарддоны рæдыд',
	'directorycreateerror' => 'Нæй саразæн файлдон «$1».',
	'difference' => '(Дыууæ фæлтæры ’хсæн хъауджы)',
	'diff-multi' => '{{PLURAL:$2|1 архайæджы|$2 архайæджы}} {{PLURAL:$1|1 æхсæйнаг фæлтæр æвдыст нæу|$1 æхсæйнаг фæлтæры æвдыст не сты}}',
	'diff' => 'хицæн.',
	'download' => 'æрбавгæн',
	'disambiguationspage' => 'Template:бирæнысанон',
	'deletepage' => 'Схаф фарс',
	'delete-confirm' => 'Схаф "$1"',
	'dellogpage' => 'Аппарыны лог',
	'deletionlog' => 'аппарыны лог',
	'deletecomment' => 'Аххос:',
	'deleteotherreason' => 'Æндæр кæнæ уæлæмхасæн аххос:',
	'deletereasonotherlist' => 'Æндæр аххос',
	'databasenotlocked' => 'Рарддон æхгæд неу.',
);

$messages['pa'] = array(
	'december' => 'ਦਸੰਬਰ',
	'december-gen' => 'ਦਸੰਬਰ',
	'dec' => 'ਦਸੰ',
	'delete' => 'ਹਟਾਓ',
	'deletethispage' => 'ਇਹ ਪੇਜ ਹਟਾਓ',
	'disclaimers' => 'ਦਾਅਵੇ',
	'disclaimerpage' => 'Project:ਆਮ ਦਾਅਵਾ',
	'databaseerror' => 'ਡਾਟਾਬੇਸ ਗਲਤੀ',
	'deletedhist' => 'ਹਟਾਇਆ ਗਿਆ ਅਤੀਤ',
	'difference' => '(ਰੀਵਿਜ਼ਨ ਵਿੱਚ ਅੰਤਰ)',
	'datedefault' => 'ਕੋਈ ਪਸੰਦ ਨਹੀਂ',
	'default' => 'ਡਿਫਾਲਟ',
	'diff' => 'ਅੰਤਰ',
	'download' => 'ਡਾਊਨਲੋਡ',
	'defemailsubject' => '{{SITENAME}} ਈਮੇਲ',
	'deletepage' => 'ਪੇਜ ਹਟਾਓ',
	'delete-confirm' => '"$1" ਹਟਾਓ',
	'delete-legend' => 'ਹਟਾਓ',
	'dellogpage' => 'ਹਟਾਉਣ ਲਾਗ',
	'deletecomment' => 'ਕਾਰਨ:',
	'deleteotherreason' => 'ਹੋਰ/ਵਾਧੂ ਕਾਰਨ:',
	'deletereasonotherlist' => 'ਹੋਰ ਕਾਰਨ',
	'delete_and_move' => 'ਹਟਾਓ ਅਤੇ ਮੂਵ ਕਰੋ',
);

$messages['pag'] = array(
	'delete' => 'Buralen',
	'deletethispage' => 'Buralen so ayan page',
	'difference' => '(Say niduma diad saray revision)',
	'datedefault' => 'Anggapoy preference',
	'download' => 'mangileksab (download)',
	'deletepage' => 'Buralen so bolong',
	'deletedtext' => 'Abural lay "$1".
Pinengneng so $2 para ed listaan na saray abural ran balo.',
	'deletecomment' => 'Katonongan',
	'delete_and_move' => 'Buralen san iyales',
	'delete_and_move_confirm' => 'On, buralen yan page',
	'deletedwhileediting' => 'Pasakbay: Abural yan bolong nen ginapuan mon baloen!',
);

$messages['pam'] = array(
	'december' => 'Diciembri',
	'december-gen' => 'Diciembri',
	'dec' => 'Dic',
	'delete' => 'Buran',
	'deletethispage' => 'Buran ya ing bulung a ini',
	'disclaimers' => 'Pamananggi',
	'disclaimerpage' => 'Project:Pangkabilugan a pamananggi',
	'databaseerror' => 'Pamagkamali king database (simpanan)',
	'dberrortext' => 'Ating migkamali king database query syntax.
Mapaliaring ating bug king software.
Ing tauling mesubuk a kutang king database (database query) yapin iti:
<blockquote><tt>$1</tt></blockquote>
from within function "<tt>$2</tt>".
MySQL returned error "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Mika pamagkamali king syntax ning pamangutang king database (database query).
Ing tauling kutang king database yapin iti:
"$1"
manibat king kilub ning function "$2".
Ini ing pamagkamaling linto king MySQL - "$3: $4"',
	'directorycreateerror' => 'E ne agawa ing directory "$1".',
	'deletedhist' => 'Meburang amlat',
	'difference' => '(Pamiyaliwa da reng pamibayu)',
	'diff-multi' => '({{PLURAL:$1|1 a pamagbayung miyalilan na |$1 pamagbayung miyalilan na}} a e makalto.)',
	'datedefault' => 'Alang mepili',
	'defaultns' => 'Paintunan ya karening pirinan lagyu (namespaces) nung alang mepili:',
	'default' => 'alang mepili',
	'diff' => 'aliwa',
	'destfilename' => 'Lagyungsimpan (filename) ning puntalan:',
	'download' => 'ikuldas (download)',
	'disambiguations' => 'Bulung a pamipalino',
	'disambiguationspage' => 'Template:pamipalino',
	'disambiguations-text' => "Makasuglung la king '''bulung pamipalino''' (disambiguation page) deng makatuking bulung.
Ing dapat, keta lang makatud a paksa makasuglung.<br />
Tuturing yang bulung pamipalino ing metung a bulung nung gagamit yang modelung (template)  makasuglung manibat king
[[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dobling pamanaliling direksiun',
	'doubleredirectstext' => 'Pakalista la king bulung a ini deng bulung a makayalis direksiun (redirect) kareng aliwang bulung pamanalis direksiun. Atin yang suglung ing balang dane (row) king mumuna ampong kaduang pamanalis direksiun, ampo king tuturu (target) ning kaduang pamanalis direksiun, a keraklan ya ing "tagana" o "tutung" bulung a tuturu, nung nu ya dapat tambing makaturu ing mumunang pamanalis direksiun.',
	'deadendpages' => 'Bulung a alang lualan (dead-end)',
	'deadendpagestext' => 'E la makatuglung kareng aliwang bulung king wiking iti deng bulung a makatuki.',
	'deletedcontributions' => 'Deng ambag da reng talagamit a mebura',
	'deletedcontributions-title' => 'Deng ambag da reng talagamit a mebura',
	'defemailsubject' => 'e-mail ning {{SITENAME}}',
	'deletepage' => 'Buran ya ing bulung',
	'delete-confirm' => 'Buran ya ing "$1"',
	'delete-legend' => 'Buran',
	'deletedtext' => 'Mebura ya ing "$1".
Makasulat la king $2 deng pekabayung mebura.',
	'dellogpage' => 'Tala da reng mebura',
	'dellogpagetext' => 'Makabili la king lalam deng pekabayung mebura.',
	'deletionlog' => 'tala da ring mebura',
	'deletecomment' => 'Sangkan:',
	'deleteotherreason' => 'Aliwa/karagdagang sangkan:',
	'deletereasonotherlist' => 'Aliwang sangkan',
	'deletereason-dropdown' => '*Karaniwang sangkan king pamamura
** Pekisabi ning sinulat
** Pamaglabang king katulirang mangopia
** Pamanyira',
	'delete-edit-reasonlist' => 'I-edit la reng sangkan king pamamura',
	'delete-toobig' => 'Maki maragul yang amlat ning pamag-edit ing bulung a ini, nung nu maigit lang $1 deng miyalilan.
Me-limita ing pamamura kareng bulung a anti kaniti, bang e maliliari ing e sasarian a kaguluan o pamag-distorbu king {{SITENAME}}.',
	'delete-warning-toobig' => 'Makaba ya ing amlat ding mibayu/me-edit ning bulung a ini, maigit la king $1 ding pamagbayu.
Posibling miyapektuan ing palakad ning database ning {{SITENAME}};
pakakalale ka.',
	'databasenotlocked' => 'E makasara ing database.',
	'delete_and_move' => 'Buran at ialis',
	'delete_and_move_text' => '==Kailangan ing pamamura==
Atiu ne ing "[[:$1]]" a bulung a puntalan.
Buri meng buran bang malaus ing pamanales?',
	'delete_and_move_confirm' => 'Wa, buran ya ing bulung',
	'delete_and_move_reason' => 'Mebura ya bang malaus ing pamanalis',
	'djvu_page_error' => 'Ala yu king saklo na ing bulung DjVu',
	'djvu_no_xml' => 'E menikuang XML para king simpan (file) a DjVu file',
	'deletedrevision' => 'Meburang matuang pamagbayu $1',
	'deletedwhileediting' => 'Kapiadian: Mebura ya ing bulung ini kaibat mung migumpisang mag-edit!',
);

$messages['pap'] = array(
	'december' => 'desèmber',
	'dec' => 'des',
	'delete' => 'Kita',
	'disclaimers' => 'Deklarashon di Liberashon for di Responsabilidatnan',
	'disclaimerpage' => 'Project:Deklarashon di Liberashon for di Responsabilidat General',
	'defemailsubject' => 'E-mail di {{SITENAME}}',
);

$messages['pcd'] = array(
	'december' => 'ed Déchimbe',
	'december-gen' => 'Déchimbe',
	'dec' => 'Déc',
	'delete' => 'Défacer',
	'deletethispage' => "Défacer chl'pache lo",
	'disclaimers' => 'Démintis',
	'disclaimerpage' => 'Project:Déminti général',
	'databaseerror' => "Bérlurache din l'database",
	'directorycreateerror' => 'Éj pux poin créer ch\'répértoère "$1".',
	'difference' => '(Diférinche intre chés érvisions)',
	'diff' => 'dif',
	'deletepage' => "Défacer l'pache",
	'deletedtext' => "« $1 » o té défacé.
Vir $2 pou eune lisse d'chés darinnes défachons.",
	'dellogpage' => 'jornal éd chés défacions',
	'deletecomment' => 'Motif:',
	'deleteotherreason' => 'Motif eute/suplémintère :',
	'deletereasonotherlist' => 'Eute motif',
	'dberr-header' => 'Ech wiki-lo il o dés problémes',
);

$messages['pdc'] = array(
	'december' => 'Disember',
	'december-gen' => 'Disember',
	'dec' => 'Dis.',
	'delete' => 'Lösche',
	'deletethispage' => 'Des Blatt lösche',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Fehler in de Daadescheier',
	'difference' => '(Unnerschidd zwische Versione)',
	'diff' => 'Unnerschidd',
	'download' => 'Runnerlaade',
	'doubleredirects' => 'Zweefache Weiderleidinge',
	'double-redirect-fixer' => 'Xqbot',
	'defemailsubject' => '{{SITENAME}}-E-Poschde',
	'deletepage' => 'Blatt lösche',
	'delete-confirm' => 'Lösche vun „$1“',
	'delete-legend' => 'Lösche',
	'deletedtext' => '"<nowiki>$1</nowiki>" iss gelescht warre.
Guck $2 fer e Lischt vun de letscht Leschunge.',
	'deletedarticle' => 'hot „[[$1]]“ gelöscht',
	'dellogpage' => 'Lischt vun gelöschte Bledder',
	'deletecomment' => 'Grund:',
	'deleteotherreason' => 'Annre Grind:',
	'deletereasonotherlist' => 'Annerer Grund',
	'delete-edit-reasonlist' => "Grind fer's Lesche ennere",
	'delete_and_move_confirm' => 'Ya, es Blatt lösche',
	'descending_abbrev' => 'ab',
);

$messages['pdt'] = array(
	'december' => 'Deetsamba',
	'december-gen' => 'Deetsamba',
	'dec' => 'Dez',
	'delete' => 'Lasche',
	'deletethispage' => 'Dise Sied lasche',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Fehla enne Dotebank',
	'dberrortext' => 'Daut gauf een Syntaxfehla biem Opproope vonne Dotebank.
Doa kaun een Probleem enne Software senne.
Daut latzte Opproope vonne Dotebank we:
<blockquote><tt>$1</tt></blockquote>
ute Funktioon "<tt>$2</tt>".
MySQL mald dem Fehla "<tt>$3: $4</tt>".',
	'diff' => 'Unjascheet',
	'doubleredirects' => 'Dobbelt Wiedawiesinje',
	'deleteotherreason' => 'Aundra Grunt:',
	'deletereasonotherlist' => 'Aundre Grunt',
);

$messages['pfl'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezember',
	'dec' => 'Dez',
	'delete' => 'Lesche',
	'disclaimers' => 'Hafdungsausschluß',
	'disclaimerpage' => 'Project:Impressum',
	'difference' => '(Unnerschied zwische de Versione)',
	'diff' => 'Unnerschied',
	'deletepage' => 'Said lesche',
	'delete-legend' => 'Lesche',
	'deletedtext' => '"$1" isch gelescht worre.
Guck $2 fer e Lischt vun de letschte Leschunge.',
	'dellogpage' => 'Leschlogbuch',
	'deletecomment' => 'Grund:',
	'deleteotherreason' => 'Annere/zusätzliche Grund:',
	'deletereasonotherlist' => 'Annere Grund',
	'delete_and_move' => 'Lesche un Verschiewe',
);

$messages['pi'] = array(
	'december' => 'दिसम्बर',
);

$messages['pl'] = array(
	'december' => 'grudzień',
	'december-gen' => 'grudnia',
	'dec' => 'gru',
	'delete' => 'Usuń',
	'deletethispage' => 'Usuń tę stronę',
	'disclaimers' => 'Informacje prawne',
	'disclaimerpage' => 'Project:Informacje prawne',
	'databaseerror' => 'Błąd bazy danych',
	'dberrortext' => 'Wystąpił błąd składni w zapytaniu do bazy danych.
Może to oznaczać błąd w oprogramowaniu.
Ostatnie, nieudane zapytanie to:
<blockquote><tt>$1</tt></blockquote>
wysłane przez funkcję „<tt>$2</tt>”.
Baza danych zgłosiła błąd „<tt>$3: $4</tt>”.',
	'dberrortextcl' => 'Wystąpił błąd składni w zapytaniu do bazy danych.
Ostatnie, nieudane zapytanie to:
„$1”
wywołane zostało przez funkcję „$2”.
Baza danych zgłosiła błąd „$3: $4”',
	'directorycreateerror' => 'Nie udało się utworzyć katalogu „$1”.',
	'deletedhist' => 'Usunięta historia edycji',
	'difference' => '(Różnice między wersjami)',
	'difference-multipage' => '(Różnica między stronami)',
	'diff-multi' => '(Nie pokazano $1 wersji {{PLURAL:$1|utworzonej|utworzonych}} przez {{PLURAL:$2|jednego użytkownika|$2 użytkowników}})',
	'diff-multi-manyusers' => '(Nie pokazano $1 {{PLURAL:$1|pośredniej wersji utworzonej|pośrednich wersji utworzonych}} przez {{PLURAL:$2|jednego użytkownika|$2 użytkowników}})',
	'datedefault' => 'Domyślny',
	'defaultns' => 'Albo przeszukuj przestrzenie nazw:',
	'default' => 'domyślnie',
	'diff' => 'różn.',
	'destfilename' => 'Nazwa docelowa',
	'duplicatesoffile' => '{{PLURAL:$1|Następujący plik jest kopią|Następujące pliki są kopiami}} pliku ([[Special:FileDuplicateSearch/$2|więcej informacji]]):',
	'download' => 'pobierz',
	'disambiguations' => 'Strony linkujące do stron ujednoznaczniających',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Poniższe strony odwołują się do '''stron ujednoznaczniających''',
a powinny odwoływać się bezpośrednio do stron treści.<br />
Strona uznawana jest za ujednoznaczniającą, jeśli zawiera szablon linkowany przez stronę [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Podwójne przekierowania',
	'doubleredirectstext' => 'Lista zawiera strony z przekierowaniami do stron, które przekierowują do innej strony.
Każdy wiersz zawiera linki do pierwszego i drugiego przekierowania oraz link, do którego prowadzi drugie przekierowanie. Ostatni link prowadzi zazwyczaj do strony, do której powinna w rzeczywistości przekierowywać pierwsza strona.
<del>Skreślenie</del> oznacza naprawienie przekierowania.',
	'double-redirect-fixed-move' => 'Naprawa podwójnego przekierowania [[$1]] → [[$2]]',
	'double-redirect-fixed-maintenance' => 'Naprawiono podwójne przekierowanie z [[$1]] do [[$2]].',
	'double-redirect-fixer' => 'Naprawiacz przekierowań',
	'deadendpages' => 'Strony bez linków wewnętrznych',
	'deadendpagestext' => 'Poniższe strony nie posiadają odnośników do innych stron znajdujących się w {{GRAMMAR:MS.lp|{{SITENAME}}}}.',
	'deletedcontributions' => 'Usunięty wkład użytkownika',
	'deletedcontributions-title' => 'Usunięty wkład użytkownika',
	'defemailsubject' => '{{SITENAME}} – e‐mail od użytkownika „$1“',
	'deletepage' => 'Usuń stronę',
	'delete-confirm' => 'Usuwanie „$1”',
	'delete-legend' => 'Usuń',
	'deletedtext' => 'Usunięto „$1”.
Zobacz na stronie $2 rejestr ostatnio wykonanych usunięć.',
	'dellogpage' => 'Usunięte',
	'dellogpagetext' => 'Poniżej znajduje się lista ostatnio wykonanych usunięć.',
	'deletionlog' => 'rejestr usunięć',
	'deletecomment' => 'Powód',
	'deleteotherreason' => 'Inny lub dodatkowy powód:',
	'deletereasonotherlist' => 'Inny powód',
	'deletereason-dropdown' => '* Najczęstsze powody usunięcia
** Prośba autora
** Naruszenie praw autorskich
** Wandalizm',
	'delete-edit-reasonlist' => 'Edytuj listę przyczyn usunięcia',
	'delete-toobig' => 'Ta strona ma bardzo długą historię edycji, ponad $1 {{PLURAL:$1|zmianę|zmiany|zmian}}.
Usunięcie jej mogłoby spowodować zakłócenia w pracy {{GRAMMAR:D.lp|{{SITENAME}}}} i dlatego zostało ograniczone.',
	'delete-warning-toobig' => 'Ta strona ma bardzo długą historię edycji, ponad $1 {{PLURAL:$1|zmianę|zmiany|zmian}}.
Bądź ostrożny, ponieważ usunięcie jej może spowodować zakłócenia w pracy {{GRAMMAR:D.lp|{{SITENAME}}}}.',
	'databasenotlocked' => 'Baza danych nie jest zablokowana.',
	'delete_and_move' => 'Usuń i przenieś',
	'delete_and_move_text' => '== Przeniesienie wymaga usunięcia innej strony ==
Strona docelowa „[[:$1]]” istnieje.
Czy chcesz ją usunąć, by zrobić miejsce dla przenoszonej strony?',
	'delete_and_move_confirm' => 'Tak, usuń stronę',
	'delete_and_move_reason' => 'Usunięto, by zrobić miejsce dla przenoszonej strony „[[$1]]”',
	'djvu_page_error' => 'Strona DjVu poza zakresem',
	'djvu_no_xml' => 'Nie można pobrać danych w formacie XML dla pliku DjVu',
	'deletedrevision' => 'Usunięto poprzednie wersje $1',
	'days' => '{{PLURAL:$1|$1 dzień|$1 dni}}',
	'deletedwhileediting' => "'''Uwaga!''' Ta strona została usunięta po tym, jak rozpoczął{{GENDER:|eś|aś|eś(‐aś)}} jej edycję!",
	'descending_abbrev' => 'mal.',
	'duplicate-defaultsort' => 'Uwaga: Domyślnym kluczem sortowania będzie „$2” i zastąpi on wcześniej wykorzystywany klucz „$1”.',
	'dberr-header' => 'Ta wiki nie działa poprawnie',
	'dberr-problems' => 'Przepraszamy! Witryna ma problemy techniczne.',
	'dberr-again' => 'Spróbuj przeładować stronę za kilka minut.',
	'dberr-info' => '(Brak komunikacji z serwerem bazy danych – $1)',
	'dberr-usegoogle' => 'Możesz spróbować wyszukać w międzyczasie za pomocą Google.',
	'dberr-outofdate' => 'Uwaga – indeksy zawartości serwisu mogą być nieaktualne.',
	'dberr-cachederror' => 'Strona została pobrana z pamięci podręcznej i może być nieaktualna.',
	'discuss' => 'Dyskutuj',
);

$messages['pms'] = array(
	'december' => 'Dzèmber',
	'december-gen' => 'Dzèmber',
	'dec' => 'Dzè',
	'delete' => 'Scancela',
	'deletethispage' => 'Scancela pàgina',
	'disclaimers' => 'Difide',
	'disclaimerpage' => 'Project:Avertense generaj',
	'databaseerror' => 'Eror ant la base dat',
	'dberrortext' => 'A l\'é capitaje n\'eror ëd sintassi ant la domanda mandà a la base dat.
Sòn a peul vorèj dì n\'eror ant ël programa.
L\'ùltima domanda mandà a la base dat a l\'é stàita:
<blockquote><tt>$1</tt></blockquote>
da \'nt la funsion "<tt>$2</tt>".
La base dat a l\'ha dane andré n\'eror "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'A-i é staje n\'eror ant la sintassi d\'anterogassion dla base dat.
L\'ùltima anterogassion a l\'é stàita:
"$1"
da andrinta a la funsion "$2".
La base dat a l\'ha dane n\'eror "$3: $4"',
	'directorycreateerror' => 'A l\'é pa podusse fé ël dossié "$1".',
	'deletedhist' => 'Stòria scancelà',
	'difference' => '(Diferense antra revision)',
	'difference-multipage' => '(Diferense tra pàgine)',
	'diff-multi' => "({{PLURAL:$1|Na revision antërmedia|$1 revision antërmedie}} ëd {{PLURAL:$2|n'utent|$2 utent}} pa mostrà)",
	'diff-multi-manyusers' => "({{PLURAL:$1|Na revision antërmedia|$1 revision antërmedie}} da pi che $2 {{PLURAL:$2|n'utent|utent}} pa mostrà)",
	'datedefault' => "Franch l'istess",
	'defaultns' => 'Dësnò, sërché an costi spassi nominaj-sì:',
	'default' => 'stàndard',
	'diff' => 'dif.',
	'destfilename' => "Nòm dl'archivi ëd destinassion:",
	'duplicatesoffile' => "{{PLURAL:$1|L'archivi sì-dapress a l'é un|Ij $1 archivi sì-dapress a son dij}} duplicà ëd s'archivi ([[Special:FileDuplicateSearch/$2|pì ëd detaj]]):",
	'download' => 'dëscarié',
	'disambiguations' => "Pàgine ch'a men-o vers dle pàgine d'omonimìe",
	'disambiguationspage' => "Template:Gestion dj'omonimìe",
	'disambiguations-text' => "Ste pàgine-sì a men-o a na '''pàgina ëd gestion dj'omònim''', mach che a dovrìo ëmné bele drit a n'artìcol.<br />
Na pàgina as trata coma \"pàgina ëd gestion dj'omònim\" se a deuvra në stamp dont l'anliura as treuva ant ël [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Ridiression dobie',
	'doubleredirectstext' => "Sta pàgina-sì a a lista dle pàgine ch'a armando a d'àutre pàgine ëd ridiression.
Vira riga a l'ha andrinta j'anliure a la prima e a la sconda ridiression, ant sël pat ëd la prima riga ëd test dla seconda ridiression, che për sòlit a l'ha andrinta l'artìcol ëd destinassion vèir, col andoa che a dovrìa ëmné ëdcò la prima ridiression.
Le ridiression <del>sganfà</del> a son stàite arzolvùe.",
	'double-redirect-fixed-move' => "[[$1]] a l'é stàit spostà.
Adess a l'é na ridiression a [[$2]].",
	'double-redirect-fixed-maintenance' => 'Rangé le ridiression dobie da [[$1]] a [[$2]].',
	'double-redirect-fixer' => 'Coretor ëd ridiression',
	'deadendpages' => 'Pàgine che a men-o da gnun-a part',
	'deadendpagestext' => "Le pàgine ambelessì-sota a l'han pa d'anliure anvers a j'àutre pàgine ëd {{SITENAME}}.",
	'deletedcontributions' => 'Modìfiche faite da utent scancelà',
	'deletedcontributions-title' => 'Modìfiche faite da utent scancelà',
	'defemailsubject' => 'Mëssagi da l\'utent "$1"',
	'deletepage' => 'Scancelé la pàgina',
	'delete-confirm' => 'Scancelé «$1»',
	'delete-legend' => 'Scancelé',
	'deletedtext' => "La pàgina «$1» a l'é stàita scancelà.
Che a varda $2 për na lista dle pàgine scancelà ant j'ùltim temp.",
	'dellogpage' => 'Registr djë scancelament',
	'dellogpagetext' => "Ambelessì-sota a-i é na lista dle pàgine scancelà ant j'ùltim temp.",
	'deletionlog' => 'Registr djë scancelament',
	'deletecomment' => 'Rason:',
	'deleteotherreason' => 'Rason àutra/adissional:',
	'deletereasonotherlist' => 'Àutra rason',
	'deletereason-dropdown' => "*Rason sòlite ch'a së scancela la ròba
** A lo ciama l'àutor
** Violassion dij drit d'autor
** Vandalism",
	'delete-edit-reasonlist' => 'Modifiché la rason dlë scancelament',
	'delete-toobig' => "Sta pàgina-sì a l'ha na stòria motobin longa, bele pì che $1 {{PLURAL:$1|revision|revision}}.
Lë scancelassion ëd pàgine parèj a l'é stàita limità për evité ch'as fasa darmagi për eror a {{SITENAME}}.",
	'delete-warning-toobig' => "Sta pàgina-sì a l'ha na stòria motobin longa, bele pì che $1 {{PLURAL:$1|revision|revision}}.
A scancelela as peul fesse darmagi a j'operassion dla base ëd dat ëd {{SITENAME}};
ch'a daga da ment a lòn ch'a fa.",
	'databasenotlocked' => "La base dat a l'é nen blocà.",
	'delete_and_move' => 'Scancela e tramuda',
	'delete_and_move_text' => '==A fa da manca dë scancelé==

L\'artìcol ëd destinassion "[[:$1]]" a-i é già. Veul-lo scancelelo për avej ëd pòst për tramudé l\'àutr?',
	'delete_and_move_confirm' => 'É, scancela la pàgina',
	'delete_and_move_reason' => 'Scancelà për liberé ël pòst për tramudé "[[$1]]"',
	'djvu_page_error' => 'Pàgina DjVu fòra dij lìmit',
	'djvu_no_xml' => "As rièss pa a carié l'XML për l'archivi DjVu",
	'deletedrevision' => 'Veja version scancelà $1',
	'days' => '{{PLURAL:$1|$1 di|$1 di}}',
	'deletedwhileediting' => "'''Avertensa''': sta pàgina-sì a l'é staita scancelà quand che chiel (chila) a l'avìa già anandiasse a modifichela!",
	'descending_abbrev' => 'a calé',
	'duplicate-defaultsort' => "'''Atension:''' La ciav d'ordinament ëd default \"\$2\" a ven al pòst ëd cola ëd prima \"\$1\"",
	'dberr-header' => "Sta wiki-sì a l'ha un problema",
	'dberr-problems' => "Spiasent! Sto sit-sì a l'ha dle dificoltà técniche.",
	'dberr-again' => 'Preuva a speté cheich minute e a torna carié.',
	'dberr-info' => '(As peul pa contaté ël database server: $1)',
	'dberr-usegoogle' => 'It peule prové a serché con Google ant ël mentre.',
	'dberr-outofdate' => 'Nòta che la soa indicisassion dij nòst contnù a podrìa nen esse agiornà.',
	'dberr-cachederror' => 'Sta sì a l\'ìé na còpia an "cache" ëd la pàgina ciamà, e a peul esse pa agiornà.',
);

$messages['pnb'] = array(
	'december' => 'دسمبر',
	'december-gen' => 'دسمبر',
	'dec' => 'دسمبر',
	'delete' => 'مٹاؤ',
	'deletethispage' => 'اے صفحہ مٹاؤ',
	'disclaimers' => 'منکرنا',
	'disclaimerpage' => 'Project:عام منکرنا',
	'databaseerror' => 'ڈیٹابیس دی غلطی',
	'dberrortext' => 'اک ڈیٹابیس کویری سنٹیکس غلطی ہوگئی اے۔
اے سوفٹویر چ اک بگ وی ہوسکدا اے۔
آخری کوشش کیتی ڈیٹابیس کھوج:
<blockquote><tt>$1</tt></blockquote>
فنکشن چوں "<tt>$2</tt>".
ڈیٹا بیس ریٹرنڈ غلطی "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'اکڈیٹابیس کویری سنٹیکس غلطی ہوگئی اے
آخری ڈیٹابیس کویری سی:
"$1"
فنکش دے اندروں "$2"
ڈیٹابیس ریٹرنڈ غلطی "$3: $4"',
	'directorycreateerror' => 'ڈائریکٹری "$1" نئیں بنا جاسکی۔',
	'deletedhist' => 'مٹائی گئی تریخ',
	'difference' => '(صفحیاں وچ فرق)',
	'difference-multipage' => '(صفیاں چ فرق)',
	'diff-multi' => '({{PLURAL:$1|اک درمیانی تبدیلی|$1 درمیانی تبدیلی}} {{PLURAL:$2|اک ورتن والا|$2 ورتن والے}} کولوں نئیں وکھائی گئی۔)',
	'diff-multi-manyusers' => '({{انیک:$1|اک وشکارلی ریوین|$1 وشکارلیاں ریویناں}} توں ود $2 {{انیک:$2|ورتن والا|ورتن والا}} نئیں دسی گئی)',
	'datedefault' => 'خاص پسند نئیں',
	'defaultns' => 'نئیں تے ایناں ناں تھاواں تے کھوج کرو:',
	'default' => 'ڈیفالٹ',
	'diff' => 'فرق',
	'destfilename' => 'وکی دے اتے فائل دا ناں:',
	'duplicatesoffile' => 'تھلے دتی گئی {{PLURAL:$1|فائل دوہری اے|1$ فائل دوہری نیں}} ایس فائل دیاں ([[Special:FileDuplicateSearch/$2|ہور گلاں]]) کاپی نیں۔',
	'download' => 'فائل کاپی کرو',
	'disambiguations' => 'اوہ صفے جیہڑے گنجل کھول صفیاں نال جڑدے نیں۔',
	'disambiguationspage' => 'سانچہ: ڈسایمبگ',
	'disambiguations-text' => "تھلے دتے گۓ صفیاں دا اک '''گنجل کھول''' نال جوڑ اے۔
ایدے بجاۓ ایدا جوڑ کسے ٹھیک سرناویں نال جوڑو<br />
اک صفہ گنجل کھول صفے لئی منیا جائیگا  اگر اے اک ٹمپلیٹ ورتدا جیدا جوڑ [[MediaWiki:Disambiguationspage]] نال ہووے۔",
	'doubleredirects' => 'دوہری ریڈیرکٹس',
	'doubleredirectstext' => 'ایس صفے تے اوناں صفیاں دی لسٹ اے جیہڑے ریڈائرکٹ کردے نیں دوجے ریڈائرکٹ صفیاں ول۔
ہر قطار چ جوڑ نیں  پہلے تے دوجے ریڈائرکٹ نال ، نال دوجے دیڑائرکٹ ول دا تارگٹ نیں جیہڑا کے ٹھیک تارگٹ صفہ ہوندا اے جیہڑا کہ پہلے ریڈائرکٹ نوں اشارہ کرنا چائیدا اے۔
<del>کراسڈ</del> اینٹریاں حل ہوگیاں نیں۔',
	'double-redirect-fixed-move' => '[[$1]] نوں بدل دتا گیا اے۔
اے ہن [[$2]] نوں ریڈائرکٹ اے۔',
	'double-redirect-fixed-maintenance' => '[[$1]] توں [[$2]] تک دوہرے ریڈائرکٹ ٹھیک کرنا۔',
	'double-redirect-fixer' => 'ریڈائرکٹ فکسر',
	'deadendpages' => 'انے صفے',
	'deadendpagestext' => 'تھلے دتے گۓ صفیاں نوں {{سائیٹناں}} تے دوجیاں صفیاں تے نئیں جوڑیا گیا۔',
	'deletedcontributions' => 'ورتن والے دے کم مٹادتے گۓ۔',
	'deletedcontributions-title' => 'ورتن والے دے کم مٹادتے گۓ۔',
	'defemailsubject' => '{{SITENAME}}ای-میل ورتن والے "$1" توں',
	'deletepage' => 'صفہ مٹاؤ',
	'delete-confirm' => '"$1" مٹاؤ',
	'delete-legend' => 'مٹاؤ',
	'deletedtext' => '"$1" مٹایا جا چکیا اے۔<br />
نیڑے نیڑے مٹاۓ گۓ ریکارڈ نوں دیکن آسطے $2 ایتھے چلو۔',
	'dellogpage' => 'مٹان آلی لاگ',
	'dellogpagetext' => 'تھلے نویاں مٹائے گۓ صفحیاں دی لسٹ اے۔',
	'deletionlog' => 'مٹان آلی لاگ',
	'deletecomment' => 'وجہ:',
	'deleteotherreason' => 'دوجی/ہور وجہ:',
	'deletereasonotherlist' => 'ہور وجہ',
	'deletereason-dropdown' => '*مٹان دیاں عام وجہاں
**لکھن والا کہ ریا اے
**کاپی حق توڑنا
**وینڈالزم',
	'delete-edit-reasonlist' => 'مٹانے دیاں وجہ لکھو',
	'delete-toobig' => 'ایس صفے دی اک لمبی تبدیلی دی تریخ اے $1 توں ود {{PLURAL:$1|ریوین|ریویناں}}
ایے صفیاں دے مٹان تے کج روک اے {{SITENAME }} دی اچانک خرابی توں بچن لئی۔',
	'delete-warning-toobig' => 'ایس صفے دی تبدیلی دی اک لمی تریخ اے۔ $1 توں ود {{PLURAL:$1|ریوین|ریویناں}}۔
اینوں مٹان تے {{SITENAME}} دے ڈیٹا اوپریشنز چ مسلہ بن سکدا اے۔
سوچ سمج کے اگے ودو۔',
	'databasenotlocked' => 'ڈیٹابیس تے تالا نئیں لگیا۔',
	'delete_and_move' => 'مٹاؤ تے لے جاؤ',
	'delete_and_move_text' => '== مٹان دی لوڑ ==
پونچن والا صفہ "[[:$1]]" پہلے ای موجود.
کیا تسیں اینون مٹادینا چاندے او تھاں بدلن دی گل بنان لئی؟',
	'delete_and_move_confirm' => 'آہو، صفحہ مٹا دیو',
	'delete_and_move_reason' => 'مٹایا گیا ایتھوں "[[$1]]" ٹورن لئی۔',
	'djvu_page_error' => 'DjVu  صفہ رینج توں بار',
	'djvu_no_xml' => 'DjVu  فائل لئی XML  ناں لیایا جاسکیا',
	'deletedrevision' => 'پرانیاں مٹائیاں ریوین $1',
	'days' => ' {{PLURAL:$1|دن|دناں}}',
	'deletedwhileediting' => "'''خبردار''': تھواڈے لکھن مکرون اے صفہ مٹا دتا گیا!",
	'descending_abbrev' => 'ڈی ایایس سی',
	'duplicate-defaultsort' => '\'\'\'خبردار:\'\'\' ڈیفالٹ چابی "$2" پہلی ڈیفالٹ چابی "$1" دے اتے لگ گئی اے۔',
	'dberr-header' => 'ایس وکی چ کوئی مسلہ اے۔',
	'dberr-problems' => 'معاف کرنا !
ایس صفے تے تکنیکی مسلے آرۓ نیں۔',
	'dberr-again' => 'تھو ڑے منٹ انتظار کرو تے دوبارہ لوڈ کرو۔',
	'dberr-info' => '(ڈیٹابیس سرور نال میل نئیں ہوسکیا:$1)',
	'dberr-usegoogle' => 'تسیں گوکل راہیں کھوج کر سکدے او۔',
	'dberr-outofdate' => 'اے نوٹ کرو جے اوناں دے انڈیکس ساڈے مواد چوں پرانے ناں ہون۔',
	'dberr-cachederror' => 'اے کاشے کاپی اے منگے ہوۓ صفے دی تے ہوسکدا اے پرانی ہووے۔',
);

$messages['pnt'] = array(
	'december' => 'Χριστουγεννάρτς',
	'december-gen' => 'Χριστουγενναρί',
	'dec' => 'Χριστ',
	'delete' => 'Σβήσον',
	'deletethispage' => 'Σβήσεμαν τη σελίδας',
	'disclaimers' => 'Ιμπρέσουμ',
	'disclaimerpage' => 'Project:Ιμπρέσουμ',
	'databaseerror' => 'Λάθος σην βάσην τη δογμενίων',
	'directorycreateerror' => 'Η κατηγορία "$1" \'κ εγέντον.',
	'deletedhist' => 'Σβηγμένον ιστορίαν',
	'difference' => '(Διαφορά μεταξύ τη μορφίων)',
	'diff-multi' => "({{PLURAL:$1|Μίαν αλλαγήν|$1 αλλαγάς}} 'κ δεκνίζκουνταν.)",
	'default' => 'προεπιλογήν',
	'diff' => 'διαφορά',
	'disambiguations' => 'Σελίδας εξηγησίων',
	'doubleredirects' => 'Περισσά διπλά συνδέσμ',
	'deadendpages' => 'Αδιέξοδα σελίδας',
	'deletepage' => 'Σβήσον τη σελίδαν',
	'delete-confirm' => 'Σβήσον "$1"',
	'delete-legend' => 'Σβήσεμαν',
	'deletedtext' => 'Το "$1" εσβήγανατο.
Τερέστεν το $2 και δεαβάστεν για τα υστερνά τα σβησίματα.',
	'dellogpage' => "Κατάλογον με τ' ατά ντ' ενεσβύγαν",
	'deletionlog' => 'αρχείον ασπαλιγματίων',
	'deletecomment' => 'Αιτία:',
	'deleteotherreason' => 'Άλλον/αλλομίαν λόγον:',
	'deletereasonotherlist' => 'Άλλον λόγον',
	'databasenotlocked' => "Η βάση δογμενίων 'κ εν ασπαλιγμένον.",
	'delete_and_move' => 'Σβήσον και ετεροχλάεψον',
	'descending_abbrev' => 'κατεβ',
);

$messages['prg'] = array(
	'december' => 'sallaws',
	'december-gen' => 'sallawas',
	'dec' => 'sal',
	'delete' => 'Āupausinais',
	'deletethispage' => 'Āupausinais šin pāusan',
	'disclaimers' => 'Etrāwingiskwas arāikinsenei',
	'disclaimerpage' => 'Project:Etrāwingiskwas arāikinsenei',
	'databaseerror' => 'Dātanbazis blānda',
	'dberrortext' => 'Sīntaksis blānda tikka en prasīseņu stessei dātanbazin.
Sta mazzi būtwei blānda en prōgramijai.
Panzdaums, niizpalts prasīsenis ast:
<blockquote><tt>$1</tt></blockquote>
tengīntan pra funkciōnin „<tt>$2</tt>”.
Dātanbazi etwārtai wartinna blāndan "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Sīntaksis blānda tikka en prasīseņu stessei dātanbazin.
Panzdaums, niizpalts prasīsenis ast:
"$1"
<blockquote><tt>$1</tt></blockquote>
izwakītan iz funkciōnin „$2”.
Dātanbazi etwārtai wartinna blāndan "$3: $4".',
	'directorycreateerror' => 'Ni mazīngi teīktun fōlderan "$1"',
	'deletedhist' => 'Aupausintā istōrija',
	'difference' => '(Šlaitīntai sirzdau wersiōnins)',
	'diff-multi' => '(Ni pawaidinnā di $1{{PLURAL:$1|wersiōnin|wersiōnins}}  sirzdau šans)',
	'datedefault' => 'Auprestaminan',
	'default' => 'Auprestaminai',
	'diff' => 'šlaitīn.',
	'destfilename' => 'Naunā zūrbrukes pabilisnā:',
	'duplicatesoffile' => '{{PLURAL:$1|Šis zūrbrukis ast kōpija|Šai zūrbrukei ast kōpijas}} stesse zūrbrukin ([[Special:FileDuplicateSearch/$2|tūls infōrmaciōnis]]):',
	'download' => 'izkraūneis',
	'disambiguations' => 'Ainapreslinsnas pāusai',
	'disambiguationspage' => 'Template:Ainapreslinsna',
	'disambiguations-text' => "Zemmaišai pāusai autenginna prei '''ainapreslinsnas pāusan'''.
Tenēimans prawerru autengīntun entikriskai prei pāusas ēnturan. </br>
Pāusan ast laikātan per ainapreslinsnan pāusan ik tennan tērpaui šablōnin prei kawīdan autenginna [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dwigubbai prawessenei',
	'doubleredirectstext' => 'Zemmais ast listi wisēisan pāusan sen prawessenins en pāusans, kawīdai prawedda en kittan pāusan.
Erainā rindā turri ēn sen autengīnsenins en pirman be āntran prawessenin, tīt dīgi autengīnsenin kwēi wedda āntars prawessenis. Jāuku panzdaums autengīnsenin wedda en pāusan, en kawīdan prawerru prawestun pirmasmu pāusan.
<del>Praglaubātai</del> prawessenei ast reparītan.',
	'double-redirect-fixed-move' => 'pāusan [[$1]] pastāi praskajjintan.
Teinū tennan prawedda prei [[$2]].',
	'double-redirect-fixer' => 'Prawessenin tikrintajs',
	'deadendpages' => 'Pāusai šlāit ēntrewingins autengīnsenins',
	'deadendpagestext' => 'Zemmaišai pāusai ni autenginna prei kittans pāusans en {{SITENAME}}.',
	'deletedcontributions' => 'Aupausintā tērpautajas ēndija',
	'deletedcontributions-title' => 'Aupausintā tērpautajas ēndija',
	'defemailsubject' => 'e-mail waīstis ezze {{SITENAME}}',
	'deletepage' => 'Āupausinais pāusan',
	'delete-confirm' => 'Āupausinais "$1"',
	'delete-legend' => 'Āupausinais',
	'deletedtext' => 'Āupausinā di "$1"
Wīdais en $2 listin stēisan panzdauman āupausinsenin.',
	'dellogpage' => 'Regīsterin stēisan āupausinsenin',
	'dellogpagetext' => 'Zemmais ast panzdauman āupausinsenin listi.',
	'deletionlog' => 'regīsterin stēisan āupausinsenin',
	'deletecomment' => 'Brewīnsli:',
	'deleteotherreason' => 'Kitā/papilnimina brewīnsli:',
	'deletereasonotherlist' => 'Kitā brewīnsli',
	'deletereason-dropdown' => 'Ukadeznas āupausinsenes brewīnslis:
** Autōras mādla
** Autōran tikrōmin perptrepsenis
** Wandalizmus',
	'delete-edit-reasonlist' => 'Redigīs āupausinsenes brewīnslins',
	'delete-toobig' => 'Šin pāusan turri spārtai ilgan istōrijan stēisan redigīsenin, kīrsa $1 {{PLURAL:$1|kitawīdisnan|kitawīdisnans}}.
Tenesse āupausinsenins mazīlai dīlintun ārdisenins en dīlasnan stesse {{SITENAME}} be pastāi arāikintan.',
	'databasenotlocked' => 'Dātanbazi ni ast auklaūtan.',
	'delete_and_move' => 'Āupausinais be praskajjinais',
	'delete_and_move_text' => '== Praskajjinsenis izkīnina āupausenin ==
Kakīnslis pāusan "[[:$1]]" ekzistijja.
Kwāitu āupausintun din, kāi segīlai deīktan per praskajjintan pāusan?',
	'delete_and_move_confirm' => 'Jā, āupausinais pāusan',
	'delete_and_move_reason' => 'Āupausinā di, kāi segītun deīktan per praskajjintan pāusan',
	'djvu_page_error' => 'DjVu pāusan per ebīmtan',
	'djvu_no_xml' => 'Ni mazīngi kraūtun XML dātan per DjVu zūrbrukin',
	'deletedrevision' => 'Āupausinā di panzdaumans wersiōnins stesse $1',
	'deletedwhileediting' => "'''Ēmpirsergīsenis''': Šin pāusan pastāi āupausintan panzdau tū pagaūwa redigītun!",
	'descending_abbrev' => 'zemmai ēntei',
	'dberr-header' => 'Šī wīki ni dīlai tikrōmiskai',
	'dberr-again' => 'Bandais etkūmps kraūtun šin pāusan pa delli minūtins.',
	'dberr-info' => '(Ni mazīngi sēitun si sen dātanbazis sērwerin: $1)',
	'dberr-usegoogle' => 'En šissei kērdan tu mazzi laukītun sen Google.',
	'dberr-outofdate' => 'Waīdais, kāi tenēi mazzi turītun niaktuālins nūsas ēnturas indicins.',
	'dberr-cachederror' => 'Šin pāusan ast kitse pāusas kōpija iz rānkas minīsnan be mazzi būtwei niaktuālin.',
);

$messages['ps'] = array(
	'december' => 'ډيسمبر',
	'december-gen' => 'ډيسمبر',
	'dec' => 'ډيسمبر',
	'delete' => 'ړنګول',
	'deletethispage' => 'دا مخ ړنګ کړه',
	'disclaimers' => 'ردادعاليکونه',
	'disclaimerpage' => 'Project:ټولګړی ردادعاليک',
	'databaseerror' => 'د ډاټابېز تېروتنه',
	'directorycreateerror' => 'د "$1" په نامه ليکلړ جوړ نه شو.',
	'deletedhist' => 'د ړنګولو پېښليک',
	'difference' => '(د بڼو تر مېنځ توپير)',
	'difference-multipage' => '(د مخونو تر مېنځ توپير)',
	'diff-multi' => ' د ({{PLURAL:$2| يو کارن|$2 کارنانو}} لخوا {{PLURAL:$1|يوه منځګړې بڼه|$1 منځګړې بڼې}}د  نه ده ښکاره شوې)',
	'datedefault' => 'هېڅ نه ټاکل',
	'defaultns' => 'او يا هم په دغو نوم-تشيالونو کې پلټل:',
	'default' => 'تلواليز',
	'diff' => 'توپير',
	'destfilename' => 'د موخيزې دوتنې نوم:',
	'duplicatesoffile' => 'دا لاندينۍ {{PLURAL:$1| دوتنه د همدې دوتنې غبرګونې لمېسه ده|$1 دوتنې د همدې دوتنې غبرګونې لمېسې دي}} ([[Special:FileDuplicateSearch/$2|نور تفصيل]]):',
	'download' => 'ښکته کول',
	'disambiguations' => 'د مبهمو مخونو سره تړلي مخونه',
	'disambiguationspage' => 'Template:ناجوت',
	'doubleredirects' => 'دوه ځلي ورګرځېدنې',
	'deadendpages' => 'بې پايه مخونه',
	'deadendpagestext' => 'همدا لانديني مخونه په دغه ويکي کې د نورو مخونو سره تړنې نه لري.',
	'deletedcontributions' => 'د کارونکي ونډې ړنګې شوې',
	'deletedcontributions-title' => 'د کارونکي ونډې ړنګې شوې',
	'defemailsubject' => 'د "$1" کارن لخوا د {{SITENAME}} برېښليک',
	'deletepage' => 'پاڼه ړنګول',
	'delete-confirm' => '"$1" ړنګوول',
	'delete-legend' => 'ړنګول',
	'deletedtext' => '"$1" ړنګ شوی.
د نوو ړنګ شوو سوانحو لپاره $2 وګورۍ.',
	'dellogpage' => 'د ړنګولو يادښت',
	'dellogpagetext' => 'دا لاندې د نوو ړنګ شوو کړنو لړليک دی.',
	'deletionlog' => 'د ړنګولو يادښت',
	'deletecomment' => 'سبب:',
	'deleteotherreason' => 'بل/اضافه سبب:',
	'deletereasonotherlist' => 'بل سبب',
	'deletereason-dropdown' => '*د ړنګولو ټولګړی سبب
** د ليکوال غوښتنه
** د رښتو تېری
** د پوهې سره دښمني',
	'delete-edit-reasonlist' => 'د ړنګولو سببونه سمول',
	'delete_and_move' => 'ړنګول او لېږدول',
	'delete_and_move_confirm' => 'هو, دا مخ ړنګ کړه',
	'days' => '{{PLURAL:$1|$1 ورځ|$1 ورځې}}',
	'descending_abbrev' => 'مخښکته',
	'dberr-header' => 'دا ويکي يوه ستونزه لري',
	'dberr-problems' => 'اوبخښۍ!
دم مهال دا وېبپاڼه د تخنيکي ستونزو سره مخامخ شوې.',
	'dberr-usegoogle' => 'تاسې کولای شی چې هم مهاله د ګووګل له لخوا هم د پلټنې هڅه وکړۍ.',
);

$messages['pt'] = array(
	'december' => 'Dezembro',
	'december-gen' => 'Dezembro',
	'dec' => 'Dez.',
	'delete' => 'Eliminar',
	'deletethispage' => 'Eliminar esta página',
	'disclaimers' => 'Exoneração de responsabilidade',
	'disclaimerpage' => 'Project:Aviso_geral',
	'databaseerror' => 'Erro na base de dados',
	'dberrortext' => 'Ocorreu um erro sintáctico na pesquisa à base de dados.
Isto pode indicar um defeito neste programa.
A última tentativa de consulta à base de dados foi:
<blockquote><tt>$1</tt></blockquote>
na função "<tt>$2</tt>".
A base de dados devolveu o erro "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ocorreu um erro sintáctico na pesquisa à base de dados.
A última tentativa de consulta à base de dados foi:
"$1"
na função "$2".
A base de dados devolveu o erro "$3: $4"',
	'directorycreateerror' => 'Não foi possível criar o directório "$1".',
	'deletedhist' => 'Histórico de eliminações',
	'difference' => '(Diferença entre edições)',
	'difference-multipage' => '(Diferenças entre páginas)',
	'diff-multi' => '({{PLURAL:$1|Uma edição intermédia|$1 edições intermédias}} de {{PLURAL:$2|um utilizador|$2 utilizadores}} {{PLURAL:$1|não apresentada|não apresentadas}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Uma edição intermédia|$1 edições intermédias}} de mais de {{PLURAL:$2|um utilizador|$2 utilizadores}} não {{PLURAL:$1|apresentada|apresentadas}})',
	'datedefault' => 'Sem preferência',
	'defaultns' => 'Por omissão, pesquisar nestes espaços nominais:',
	'default' => 'padrão',
	'diff' => 'dif',
	'destfilename' => 'Nome do ficheiro de destino:',
	'duplicatesoffile' => '{{PLURAL:$1|O seguinte ficheiro é duplicado|Os seguintes $1 ficheiros são duplicados}} deste ficheiro ([[Special:FileDuplicateSearch/$2|mais detalhes]]):',
	'download' => 'download',
	'disambiguations' => 'Páginas com ligações para páginas de desambiguação',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => 'As páginas abaixo contêm links para uma página de desambiguação.
Estes links deviam ser desambiguados, apontando-os para a página apropriada.<br />
Considera-se que uma página é de desambiguação se nela for utilizada uma predefinição que esteja definida em [[MediaWiki:Disambiguationspage]].',
	'doubleredirects' => 'Redireccionamentos duplos',
	'doubleredirectstext' => 'Esta página lista todas as páginas que redireccionam para outras páginas de redireccionamento.
Cada linha contém links para o primeiro e segundo redireccionamentos, bem como o destino do segundo redireccionamento, geralmente contendo a verdadeira página de destino, que devia ser o destino do primeiro redireccionamento.
<del>Entradas cortadas</del> já foram solucionadas.',
	'double-redirect-fixed-move' => '[[$1]] foi movido.
Agora redirecciona para [[$2]].',
	'double-redirect-fixed-maintenance' => 'A corrigir redireccionamento duplo de [[$1]] para [[$2]].',
	'double-redirect-fixer' => 'Corrector de redireccionamentos',
	'deadendpages' => 'Páginas sem saída',
	'deadendpagestext' => 'As seguintes páginas não contêm links para outras páginas na {{SITENAME}}.',
	'deletedcontributions' => 'Edições eliminadas',
	'deletedcontributions-title' => 'Edições eliminadas',
	'defemailsubject' => '{{SITENAME}} e-mail do usuário "$1"',
	'deletepage' => 'Eliminar página',
	'delete-confirm' => 'Eliminar "$1"',
	'delete-legend' => 'Eliminar',
	'deletedtext' => '"$1" foi eliminada.
Consulte $2 para um registo de eliminações recentes.',
	'dellogpage' => 'Registo de eliminações',
	'dellogpagetext' => 'Abaixo uma lista das eliminações mais recentes.',
	'deletionlog' => 'registo de eliminações',
	'deletecomment' => 'Motivo:',
	'deleteotherreason' => 'Outro/motivo adicional:',
	'deletereasonotherlist' => 'Outro motivo',
	'deletereason-dropdown' => '* Motivos de eliminação comuns
** Pedido do autor
** Violação de direitos de autor
** Vandalismo',
	'delete-edit-reasonlist' => 'Editar motivos de eliminação',
	'delete-toobig' => 'Esta página tem um histórico longo, com mais de $1 {{PLURAL:$1|edição|edições}}.
A eliminação de páginas como esta foi restringida na {{SITENAME}}, para evitar problemas acidentais.',
	'delete-warning-toobig' => 'Esta página tem um histórico de edições longo, com mais de $1 {{PLURAL:$1|edição|edições}}.
Eliminá-la poderá causar problemas na base de dados da {{SITENAME}};
prossiga com precaução.',
	'databasenotlocked' => 'A base de dados não está bloqueada.',
	'delete_and_move' => 'Eliminar e mover',
	'delete_and_move_text' => '==Eliminação necessária==
A página de destino ("[[:$1]]") já existe. Deseja eliminá-la de modo a poder mover?',
	'delete_and_move_confirm' => 'Sim, eliminar a página',
	'delete_and_move_reason' => 'Eliminada para poder mover "[[$1]]" para este título',
	'djvu_page_error' => 'página DjVu inacessível',
	'djvu_no_xml' => 'Não foi possível aceder ao XML para o ficheiro DjVU',
	'deletedrevision' => 'Apagou a versão antiga $1',
	'days' => '{{PLURAL:$1|um dia|$1 dias}}',
	'deletedwhileediting' => "'''Aviso''': Esta página foi eliminada após ter começado a editá-la!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => 'Aviso: A chave de ordenação padrão "$2" sobrepõe-se à anterior chave de ordenação padrão "$1".',
	'dberr-header' => 'Esta wiki tem um problema',
	'dberr-problems' => 'Desculpe! Este site está a experienciar dificuldades técnicas.',
	'dberr-again' => 'Experimente esperar uns minutos e actualizar.',
	'dberr-info' => '(Não foi possível contactar o servidor da base de dados: $1)',
	'dberr-usegoogle' => 'Pode tentar pesquisar no Google entretanto.',
	'dberr-outofdate' => 'Note que os seus índices relativos ao nosso conteúdo podem estar desactualizados.',
	'dberr-cachederror' => 'A seguinte página é uma cópia em cache da página pedida e pode não estar actualizada.',
	'discuss' => 'Discussão',
);

$messages['pt-br'] = array(
	'december' => 'dezembro',
	'december-gen' => 'dezembro',
	'dec' => 'dez.',
	'delete' => 'Eliminar',
	'deletethispage' => 'Eliminar esta página',
	'disclaimers' => 'Exoneração de responsabilidade',
	'disclaimerpage' => 'Project:Aviso_geral',
	'databaseerror' => 'Erro no banco de dados',
	'dberrortext' => 'Ocorreu um erro de sintaxe de busca no banco de dados.
Isto pode indicar um problema com o \'\'software\'\'.
A última tentativa de busca no banco de dados foi:
<blockquote><tt>$1</tt></blockquote>
na função "<tt>$2</tt>".
O banco de dados retornou o erro "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ocorreu um erro de sintaxe de busca no banco de dados.
A última tentativa de busca no banco de dados foi:
"$1"
na função "$2".
O banco de dados retornou o erro "$3: $4".',
	'directorycreateerror' => 'Não foi possível criar o diretório "$1".',
	'defaultmessagetext' => 'Texto da mensagem padrão',
	'deletedhist' => 'Histórico de eliminações',
	'difference-title' => 'Mudanças entre as edições de "$1"',
	'difference-title-multipage' => 'Mudanças entre as páginas "$1" e "$2"',
	'difference-multipage' => '(Diferenças entre páginas)',
	'diff-multi' => '({{PLURAL:$1|Uma edição intermediária|$1 edições intermediárias}} de {{PLURAL:$2|um usuário|$2 usuários}} {{PLURAL:$1|não apresentada|não apresentadas}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|Uma edição intermediária|$1 edições intermediárias}} de mais de {{PLURAL:$2|um usuário|$2 usuário}} não {{PLURAL:$1|apresentada|apresentadas}})',
	'datedefault' => 'Sem preferência',
	'defaultns' => 'Caso contrário pesquisar nestes espaços nominais:',
	'default' => 'padrão',
	'diff' => 'dif',
	'destfilename' => 'Nome do arquivo de destino:',
	'duplicatesoffile' => '{{PLURAL:$1|O seguinte arquivo é duplicado|Os seguintes arquivos são duplicados}} deste arquivo ([[Special:FileDuplicateSearch/$2|mais detalhes]]):',
	'download' => 'download',
	'disambiguations' => 'Páginas com links para páginas de desambiguação',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => 'As páginas a seguir ligam a "páginas de desambiguação" ao invés de aos tópicos adequados.<br />
Uma página é considerada como de desambiguação se utilizar uma predefinição que esteja definida em [[MediaWiki:Disambiguationspage]]',
	'doubleredirects' => 'Redirecionamentos duplos',
	'doubleredirectstext' => 'Esta página lista as páginas que redirecionam para outros redirecionamentos.
Cada linha contém links para o primeiro e o segundo redirecionamentos, juntamente com o alvo do segundo redirecionamento, que é geralmente a verdadeira página de destino, para a qual o primeiro redirecionamento deveria apontar.
Entradas <del>riscadas</del> foram resolvidas.',
	'double-redirect-fixed-move' => '[[$1]] foi movido e agora é um redirecionamento para [[$2]]',
	'double-redirect-fixed-maintenance' => 'Corrigindo redirecionamento duplo de [[$1]] para [[$2]].',
	'double-redirect-fixer' => 'Corretor de redirecionamentos',
	'deadendpages' => 'Páginas sem saída',
	'deadendpagestext' => 'As seguintes páginas não contêm links para outras páginas no wiki {{SITENAME}}.',
	'deletedcontributions' => 'Contribuições de usuário eliminadas',
	'deletedcontributions-title' => 'Contribuições de usuário eliminadas',
	'defemailsubject' => 'E-mail do usuário "$1" da {{SITENAME}}',
	'deletepage' => 'Eliminar página',
	'delete-confirm' => 'Eliminar "$1"',
	'delete-legend' => 'Eliminar',
	'deletedtext' => '"$1" foi eliminada.
Consulte $2 para um registro de eliminações recentes.',
	'dellogpage' => 'Registro de eliminação',
	'dellogpagetext' => 'Abaixo uma lista das eliminações mais recentes.',
	'deletionlog' => 'registro de eliminação',
	'deletecomment' => 'Motivo:',
	'deleteotherreason' => 'Justificativa adicional:',
	'deletereasonotherlist' => 'Outro motivo',
	'deletereason-dropdown' => '* Motivos de eliminação comuns
** Pedido do autor
** Violação de direitos de autor
** Vandalismo',
	'delete-edit-reasonlist' => 'Editar motivos de eliminação',
	'delete-toobig' => 'Esta página possui um longo histórico de edições, com mais de $1 {{PLURAL:$1|edição|edições}}.
A eliminação de tais páginas foi restrita, a fim de se evitarem problemas acidentais em {{SITENAME}}.',
	'delete-warning-toobig' => 'Esta página possui um longo histórico de edições, com mais de $1 {{PLURAL:$1|edição|edições}}.
Eliminá-la poderá causar problemas na base de dados de {{SITENAME}};
prossiga com cuidado.',
	'databasenotlocked' => 'A base de dados não encontra-se bloqueada.',
	'delete_and_move' => 'Eliminar e mover',
	'delete_and_move_text' => '==Eliminação necessária==
A página de destino ("[[:$1]]") já existe. Deseja eliminá-la de modo a poder mover?',
	'delete_and_move_confirm' => 'Sim, eliminar a página',
	'delete_and_move_reason' => 'Eliminada para mover "[[$1]]"',
	'djvu_page_error' => 'página DjVu inacessível',
	'djvu_no_xml' => 'Não foi possível acessar o XML do arquivo DjVU',
	'deletedrevision' => 'Apagou a versão antiga $1',
	'days' => '{{PLURAL:$1|um dia|$1 dias}}',
	'deletedwhileediting' => "'''Aviso''': Esta página foi eliminada após você ter começado a editar!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => 'Aviso: A chave de ordenação padrão "$2" sobrepõe-se à anterior chave de ordenação padrão "$1".',
	'dberr-header' => 'Este wiki tem um problema',
	'dberr-problems' => 'Desculpe! Este sítio está passando por dificuldades técnicas.',
	'dberr-again' => 'Experimente esperar alguns minutos e atualizar.',
	'dberr-info' => '(Não foi possível contactar o servidor de base de dados: $1)',
	'dberr-usegoogle' => 'Você pode tentar pesquisar no Google entretanto.',
	'dberr-outofdate' => 'Note que os seus índices relativos ao nosso conteúdo podem estar desatualizados.',
	'dberr-cachederror' => 'A seguinte página é uma cópia em cache da página pedida e pode não ser atual.',
	'duration-seconds' => '$1 {{PLURAL:$1|segundo|segundos}}',
	'duration-minutes' => '$1 {{PLURAL:$1|minuto|minutos}}',
	'duration-hours' => '$1 {{PLURAL:$1|hora|horas}}',
	'duration-days' => '$1 {{PLURAL:$1|dia|dias}}',
	'duration-weeks' => '$1 {{PLURAL:$1|semana|semanas}}',
	'duration-years' => '$1 {{PLURAL:$1|ano|anos}}',
	'duration-decades' => '$1 {{PLURAL:$1|década|décadas}}',
	'duration-centuries' => '$1 {{PLURAL:$1|século|séculos}}',
	'duration-millennia' => '$1 {{PLURAL:$1|milênio|milênios}}',
);

$messages['qu'] = array(
	'december' => 'disimri',
	'december-gen' => 'disimri',
	'dec' => 'dis',
	'delete' => 'Qulluy',
	'deletethispage' => "Kay p'anqata qulluy",
	'disclaimers' => 'Chiqakunamanta rikuchiy',
	'disclaimerpage' => 'Project:Sapsilla saywachasqa paqtachiy',
	'databaseerror' => 'Willañiqintin pantasqa',
	'dberrortext' => 'Willañiqimanta mañakuptiyki sintaksis pantasqam tukurqan.
Llamp\'u kaq wakichipi pantasqachá.
Qayna willañiqimanta mañakusqaqa karqan kaypacham: <blockquote><tt>$1</tt></blockquote> kay ruraypim: "<tt>$2</tt>". MySQL-pa kutichisqan pantasqaqa karqan "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Willañiqimanta mañakuptiyki sintaksis pantasqam tukurqan.
Qayna willañiqimanta mañakusqaqa karqan kaymi:
"$1"
kay ruraymantam: "$2".
MySQL-pa kutichisqan pantasqaqa karqan "$3: $4".',
	'directorycreateerror' => 'Manam atinichu "$1" sutiyuq willañiqi churanata kamayta.',
	'defaultmessagetext' => 'Ñawpaq qillqa',
	'deletedhist' => 'Qullusqa wiñay kawsay',
	'difference-title' => '$1 nisqapaq musuqchasqapura wakin kaynin',
	'difference-title-multipage' => '$1, $2 sutiyuq willañiqipura wakin kaynin',
	'difference-multipage' => "(P'anqakunaqa manam kaqllachu)",
	'diff-multi' => "({{PLURAL:$2|Huk ruraqpa|$2 ruraqpa}} {{PLURAL:$1|chawpipi huk llamk'apusqanqa manam rikuchisqachu|chawpipi $1 llamk'apusqankunaqa manam rikuchisqachu}})",
	'diff-multi-manyusers' => "({{PLURAL:$2|Hukmanta|$2-manta}} aswan ruraqkunap {{PLURAL:$1|chawpipi huk llamk'apusqanqa manam rikuchisqachu|chawpipi $1 llamk'apusqankunaqa manam rikuchisqachu}})",
	'datedefault' => 'Kikinmanta allinkachina',
	'defaultns' => "Mana hinaptintaq kay suti k'itikunapi maskay:",
	'default' => 'kikinmanta',
	'diff' => 'dif',
	'destfilename' => 'Tukuna willañiqip sutin:',
	'duplicatesoffile' => 'Kay willañiqimanta iskaychasqa {{PLURAL:$1|willañiqim|$1 willañiqikunam}} kay qatiqpi ([[Special:FileDuplicateSearch/$2|astawan willachikuy]]):',
	'download' => 'chaqnamuy',
	'disambiguations' => "Sut'ichana qillqakunaman t'inkimuq p'anqakuna",
	'disambiguationspage' => "Template:Sut'ichana qillqa",
	'disambiguations-text' => "Kay qatiq p'anqakunam t'inkimun '''sut'ichana qillqaman'''. Chiqap, hukchanasqa p'anqaman t'inkichun.<br />Tukuy [[MediaWiki:Disambiguationspage]] plantillayuq p'anqakunaqa sut'ichana qillqam.",
	'doubleredirects' => 'Iskaylla pusapunakuna',
	'doubleredirectstext' => "Kay p'anqapiqa huk pusapuna p'anqaman pusapuq p'anqakunap sutinkunatam rikunki. Sapa sinrupiqa ñawpaq ñiqin, iskay ñiqinpas pusapunaman t'inkikunam, iskay ñiqin pusapunap taripananpa qallariyninpas, sapsilla \"chiqap\" allin taripana qillqam, maymanchus ñawpaq ñiqin pusapuna p'anqa pusachun.
<del>Chakapusqa</del> taripasqakunaqa paskasqañam.",
	'double-redirect-fixed-move' => '[[$1]] nisqaqa astasqam, kunantaq [[$2]] nisqaman pusapunam',
	'double-redirect-fixed-maintenance' => '[[$1]]-manta [[$2]]-man iskaylla pusapunata allinchaspa.',
	'double-redirect-fixer' => 'Pusapuna allinchaq',
	'deadendpages' => "Lluqsinannaq p'anqakuna",
	'deadendpagestext' => "Kay p'anqakunaqa mana ima p'anqakunamanpas t'inkimunchu.",
	'deletedcontributions' => 'Qullusqa ruraqpa hukchasqankuna',
	'deletedcontributions-title' => 'Qullusqa ruraqpa hukchasqankuna',
	'defemailsubject' => '{{SITENAME}} p\'anqamanta chaski "$1" sutiyuq ruraqmanta',
	'deletepage' => "Kay p'anqata qulluy",
	'delete-confirm' => '"$1"-ta qulluy',
	'delete-legend' => 'Qulluy',
	'deletedtext' => '"$1" qullusqañam.
$2 nisqa p\'anqata qhaway ñaqha qullusqakunata rikunaykipaq.',
	'dellogpage' => 'Qullusqakuna',
	'dellogpagetext' => 'Kay qatiqpiqa lliwmanta aswan ñaqha qullusqakunatam rikunki. Rikuchisqa pachankunaqa sirwiqpa pachanpim.',
	'deletionlog' => 'qullusqakuna',
	'deletecomment' => 'Kayrayku:',
	'deleteotherreason' => 'Huk rayku:',
	'deletereasonotherlist' => 'Huk rayku',
	'deletereason-dropdown' => "*Qulluypaq sapsi raykukuna
** Kikin kamariqpa mañakusqan
** Ruraqpa hayñinta k'irisqa
** Wandaluchasqa",
	'delete-edit-reasonlist' => "Qullusqapaq raykukunata llamk'apuy",
	'delete-toobig' => "Kay p'anqaqa ancha wiñay kawsaysapa, $1-manta aswan {{PLURAL:$1|musuqchasqayuq|musuqchasqayuq}}. Kay hina p'anqakunata qulluyqa saywachasqam, {{SITENAME}}ta mana waqllinapaq.",
	'delete-warning-toobig' => "Kay p'anqaqa ancha wiñay kawsaysapa, $1-manta aswan {{PLURAL:$1|musuqchasqayuq|musuqchasqayuq}}. Kay hina p'anqata qulluspaykiqa, {{SITENAME}}ta waqllinkimanchá. Kay ruraymanta anchata yuyaychakuspa hamut'ay.",
	'databasenotlocked' => "Willañiqintinqa manam hark'asqachu.",
	'delete_and_move' => 'Qulluspa astay',
	'delete_and_move_text' => '==Qullunam tiyan==

Tukuna p\'anqaqa ("[[:$1]]") kachkañam. Astanapaq qulluyta munankichu?',
	'delete_and_move_confirm' => "Arí, kay p'anqata qulluy",
	'delete_and_move_reason' => '"[[$1]]" nisqamanta astanapaq qullusqa',
	'djvu_page_error' => "DjVu nisqa p'anqaqa nisyum",
	'djvu_no_xml' => 'Manam atinichu XML-ta apamuy DjVu willañiqipaq',
	'deletedrevision' => "Qullusqam mawk'a qhawakipasqa $1",
	'days' => "{{PLURAL:$1|huk p'unchaw|$1 p'unchaw}}",
	'deletedwhileediting' => "'''Paqtataq''': Kay p'anqataqa qullurqankum qam llamk'apuyta qallarirqaptiyki.",
	'descending_abbrev' => 'uray',
	'duplicate-defaultsort' => 'Paqtataq: Kikinmanta allinchana llawi «$2» ñawpaq kikinmanta allinchana llawitam «$1» huknachan.',
	'dberr-header' => 'Kay wikiqa sasachakuyniyuqmi',
	'dberr-problems' => 'Achachaw! Kay tiyayqa allwiya sasachakuykunayuqmi kachkan.',
	'dberr-again' => 'Ratullata suyaspa musuqmanta chaqnaspa huk kutita ruraykachay.',
	'dberr-info' => '(Manam atinichu willañiqintin sirwiqwan willanakuyta: $1)',
	'dberr-usegoogle' => 'Hinaptinqa Google nisqawan maskayta atinkiman.',
	'dberr-outofdate' => "Musyariy, ñuqaykup samiqniykumanta yuyarisqankunaqa mawk'ayasqañachá.",
	'dberr-cachederror' => "Kay qatiqpiqa mañakusqa p'anqamanta hallch'asqa iskaychasqam, mawk'ayasqañachá.",
	'duration-seconds' => '$1 {{PLURAL:$1|sikundu|sikundukuna}}',
	'duration-minutes' => '$1 {{PLURAL:$1|minutu|minutukuna}}',
	'duration-hours' => '$1 {{PLURAL:$1|ura|urakuna}}',
	'duration-days' => "{{PLURAL:$1|p'unchaw|p'unchawkuna}}",
	'duration-weeks' => '{{PLURAL:$1|simana|simanakuna}}',
	'duration-years' => '{{PLURAL:$1|wata|watakuna}}',
	'duration-decades' => '{{PLURAL:$1|chunkawata|chunkawatakuna}}',
	'duration-centuries' => '{{PLURAL:$1|pachakwata|pachakwatakuna}}',
	'duration-millennia' => '{{PLURAL:$1|waranqawata|waranqawatakuna}}',
);

$messages['qug'] = array(
	'december' => 'Kapak',
	'december-gen' => 'Kapak',
	'dec' => 'Kap',
	'delete' => 'pichay',
	'deletethispage' => 'Kay pankata pichana',
	'disclaimers' => 'Kamachikmanta willaykuna',
	'disclaimerpage' => 'Project:Kamachikmanta kapak willaykuna',
	'databaseerror' => 'Yachayyuk ukupi pantay',
	'directorycreateerror' => '$1 allichina ukuta na wachachinata atirkanchikchu',
	'difference' => '(imashpa shikan shikanmi kan)',
	'diff-multi' => '({{PLURAL:$2|Shuk rurakpa|$2 rurakkunapa}} {{PLURAL:$1|chawpipi shuk mushuk killkayta mana rikuchishkachu|chawpipi $1 mushuk killkaykunata mana rikuchishkachu}})',
	'diff' => 'dif',
	'disambiguationspage' => 'Template:Alli killkata akllankapak yanapa',
	'deletepage' => 'kay pankata pichana',
	'deletedtext' => '"$1" ñami pichashkami kan.
$2 rikpika, ima pankakunaka pichashkami kan yachakupanki.',
	'dellogpage' => 'Pichaykunapa kamu',
	'deletecomment' => 'Imashpa:',
	'deleteotherreason' => 'Yapa imashpa:',
	'deletereasonotherlist' => 'Yapa imashpa',
	'duplicate-defaultsort' => "'''Rikupay''': Kikinmanta ordenankapak llawita «$2» ñawpak pachamanta «$1» llawita pichankami.",
);

$messages['rgn'] = array(
	'december' => 'Dizèmbar',
	'december-gen' => 'Dizèmbar',
	'dec' => 'diz',
	'delete' => 'Scanzèla',
	'disclaimers' => 'Infurmaziòn legêli',
	'disclaimerpage' => 'Project: Avìs generèl',
	'difference' => "(Difarénza fra'l versiòn)",
	'diff' => 'dif.',
	'deletepage' => 'Scanzela la pàgina',
	'deletedtext' => 'La pàgina "$1" l\'è stëda scanzlèda.
Guèrda $2 par avdé la lèsta daglj ultum scanzeladür.',
	'dellogpage' => 'Regèstar dal scanzladùr',
	'deletecomment' => 'Rasòn:',
	'deleteotherreason' => 'Ètar mutiv:',
	'deletereasonotherlist' => 'Ètar mutiv',
);

$messages['rif'] = array(
	'december' => 'Dujanbir',
	'december-gen' => 'Dujanbir',
	'dec' => 'Dujanbir',
	'delete' => 'Kks',
	'disclaimers' => 'Ismigilen',
	'disclaimerpage' => 'Project:Asmigel amatu',
	'difference' => '(Amsebḍi jar ifeggiden)',
	'diff-multi' => '({{PLURAL:$1|ijj n ufegged|$1 ifeggiden}} war ad twamlen ca.)',
	'diff' => 'imṣebḍan',
	'disambiguations' => 'Tasniwin n usefhem',
	'doubleredirects' => '(redirects) ɛɛawdent',
	'deadendpages' => 'Tasniwin s tizdayin mmutent',
	'deletepage' => 'Kks tasna',
	'delete-legend' => 'Sfaḍ',
	'deletedtext' => '"$1" Twakkes.
Xemm $2 i tikkas timaynutin.',
	'dellogpage' => 'Aɣmis n uṣfaḍ',
	'deletecomment' => 'Ssebba:',
	'deleteotherreason' => 'Ca n ssebba nniḍn:',
	'deletereasonotherlist' => 'Ssebba nniḍn',
);

$messages['rm'] = array(
	'december' => 'december',
	'december-gen' => 'december',
	'dec' => 'dec',
	'delete' => 'Stizzar',
	'deletethispage' => 'Stizzar questa pagina',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Sbagl da la datoteca',
	'dberrortext' => 'In sbagl da la sintaxa da la dumonda a la banca da datas è capità.
Quai po esser in sbagl en la software.
L\'ultima dumonda per la banca da datas era:
<blockquote><tt>$1</tt></blockquote>
ord la funcziun "<tt>$2</tt>".
La banca da datas ha rapportà l\'errur "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'In sbagl da la sintaxa da la dumonda a la banca da datas è capità.
L\'ultima dumonda per la banca da datas era:
"$1"
ord la funcziun "$2".
La banca da datas ha rapportà l\'errur "$3: $4"',
	'directorycreateerror' => 'Betg pussaivel da crear l\'ordinatur "$1".',
	'difference' => '(differenza tranter versiuns)',
	'difference-multipage' => '(Differenzas tranter las paginas)',
	'diff-multi' => '({{PLURAL:$1|Ina versiun|$1 versiuns}} {{PLURAL:$2|dad in utilisader|da $2 utilisaders}} tranter en na {{PLURAL:$1|vegn betg mussada|na vegnan betg mussadas}}.)',
	'datedefault' => 'Nagina preferenza',
	'defaultns' => 'Uschiglio tschertgar en quests tips da pagina:',
	'default' => 'Standard',
	'diff' => 'diff',
	'destfilename' => 'Num da la datoteca da destinaziun:',
	'download' => 'telechargiar',
	'disambiguations' => 'Paginas per la decleraziun da noziuns',
	'disambiguationspage' => 'Template:disambiguiziun',
	'doubleredirects' => 'Renviaments dubels',
	'doubleredirectstext' => "Questa glista mussa renviaments che mainan puspè a renviaments.
Mintga colonna cuntegna colliaziuns a l'emprim ed al segund renviaments, sco era la pagina finala dal segund renviament che è probablamain la pagina a la quala duess vegnir renvià.
Elements <del>stritgads</del> èn gia eliminads.",
	'double-redirect-fixed-move' => '[[$1]] è vegnì spustà.
I renviescha uss a [[$2]].',
	'double-redirect-fixer' => 'Bot da renviaments',
	'deadendpages' => 'Artitgels senza colliaziuns internas',
	'deletedcontributions' => "Contribuziuns d'utilisaders stidadas",
	'deletedcontributions-title' => 'Contribuziuns dad utilisaders stizzadas',
	'defemailsubject' => '{{SITENAME}} e-mail da l\'utilisader "$1"',
	'deletepage' => 'Stizzar la pagina',
	'delete-confirm' => 'Stizzar "$1"',
	'delete-legend' => 'Stizzar',
	'deletedtext' => '"$1" è vegnì stizzà.
Sin $2 chattas ti ina glista dals davos artitgels stizzads.',
	'dellogpage' => 'log dal stizzar',
	'dellogpagetext' => "Sutvart è ina glista dals elements stizzads l'ultim.",
	'deletionlog' => 'log dal stizzar',
	'deletecomment' => 'Motiv:',
	'deleteotherreason' => 'Autra / supplementara raschun:',
	'deletereasonotherlist' => 'Autra raschun:',
	'deletereason-dropdown' => "*Motivs frequents per stizzar
** Dumonda da l'autur
** Violaziun dals dretgs d'autur
** Vandalissem",
	'delete-edit-reasonlist' => 'Midar ils motivs per il stizzar',
	'databasenotlocked' => 'Questa banca da datas è betg bloccada.',
	'delete_and_move' => 'Stizzar e spustar',
	'delete_and_move_text' => '==Stizzar necessari==

L\'artitgel da destinaziun "[[:$1]]" exista gia. Vul ti stizzar el per far plaz per spustar?',
	'delete_and_move_confirm' => 'Gea, stizzar il artitgel da destinaziun per spustar',
	'delete_and_move_reason' => 'Stizzà per far plaz per spustar',
	'djvu_page_error' => 'Pagina da DjVu è ordaifer la limita',
	'djvu_no_xml' => "Betg pussaivel da retschaiver l'XML per la datoteca da DjVu",
	'deletedrevision' => 'Stizzà la versiun veglia $1.',
	'deletedwhileediting' => "'''Attenziun:''' Questa pagina è vegnida stizzada suenter che ti has cumanzà a la modifitgar.",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => '\'\'\'Attenziun:\'\'\' La clav da zavrar da standard "$2" remplazza la clav da zavrar da standard veglia "$1".',
	'dberr-header' => 'Questa wiki ha in problem',
	'dberr-problems' => 'Stgisa!
Questa pagina ha actualmain difficultads tecnicas.',
	'dberr-again' => 'Spetga in per minutas ed emprova alura da chargiar danovamain.',
	'dberr-info' => '(Betg pussaivel da contactar il server da la banca da datas: $1)',
	'dberr-usegoogle' => 'Ti pos empruvar da tschertgar cun Google en il fratemp.',
	'dberr-outofdate' => 'Resguarda che lur index da noss cuntegn po esser antiquà.',
	'dberr-cachederror' => 'Quai è ina copia or dal cache da questa pagina ed è eventualmain betg actuala.',
);

$messages['rmy'] = array(
	'december' => 'deshuduitonai',
	'dec' => 'ddui',
	'delete' => 'Khosipen',
	'deletethispage' => 'Khos i patrin',
	'disclaimers' => 'Termenurya',
	'disclaimerpage' => 'Project:Termenurya',
	'datedefault' => 'Ni ekh kamipen',
	'defaultns' => 'Rod savaxt vi kai kadale riga:',
	'default' => 'acharuno',
	'diff' => 'ververipen',
	'deadendpages' => 'Biphandimatenge patrya',
	'deletepage' => 'Khos i patrin',
	'deletedtext' => '"$1" sas khosli.
Dikh ando $2 ek patrinipen le palutne butyange khosle.',
	'delete_and_move' => 'Khos thai inger',
	'deletedrevision' => 'Khoslo o purano paruvipen $1',
	'deletedwhileediting' => 'Dikh: Kadaya patrin sas khosli de kana shirdyas (astardyas) te editisares la!',
);

$messages['ro'] = array(
	'december' => 'decembrie',
	'december-gen' => 'decembrie',
	'dec' => 'dec',
	'delete' => 'Ștergere',
	'deletethispage' => 'Șterge pagina',
	'disclaimers' => 'Termeni',
	'disclaimerpage' => 'Project:Termeni',
	'databaseerror' => 'Eroare la baza de date',
	'dberrortext' => 'A apărut o eroare în sintaxa interogării.
Aceasta poate indica o problemă în program.
Ultima interogare încercată a fost:
<blockquote><tt>$1</tt></blockquote>
din cadrul funcției "<tt>$2</tt>".
Baza de date a returnat eroarea "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'A apărut o eroare de sintaxă în interogare.
Ultima interogare încercată a fost:
„$1”
din funcția „$2”.
Baza de date a returnat eroarea „$3: $4”',
	'directorycreateerror' => 'Nu se poate crea directorul "$1".',
	'deletedhist' => 'Istoric șters',
	'difference' => '(Diferența dintre versiuni)',
	'difference-multipage' => '(Diferență între pagini)',
	'diff-multi' => '({{PLURAL:$1|O revizie intermediară|$1 revizii intermediare|$1 de revizii intermediare}} efectuată de {{PLURAL:$2|un utilizator|$2 utilizatori|$2 de utilizatori}} {{PLURAL:$1|neafișată|neafișate}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|O versiune intermediară efectuată de|$1 (de) versiuni intermediare efectuate de peste}} $2 {{PLURAL:$2|utilizator|utilizatori}} {{PLURAL:$1|neafișată|neafișate}})',
	'datedefault' => 'Nici o preferință',
	'defaultns' => 'Altfel, caută în aceste spații de nume:',
	'default' => 'standard',
	'diff' => 'dif',
	'destfilename' => 'Numele fișierului de destinație:',
	'duplicatesoffile' => '{{PLURAL:$1|Fișierul următor este duplicat|Următoarele $1 fișiere sunt duplicate}} ale acestui fișier ([[Special:FileDuplicateSearch/$2|mai multe detalii]]):',
	'download' => 'descarcă',
	'disambiguations' => 'Pagini care trimit către pagini de dezambiguizare',
	'disambiguationspage' => 'Template:Dezambiguizare',
	'disambiguations-text' => "Paginile următoare conțin legături către o '''pagină de dezambiguizare'''.
În locul acesteia ar trebui să conțină legături către un articol.<br />
O pagină este considerată o pagină de dezambiguizare dacă folosește formate care apar la [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Redirecționări duble',
	'doubleredirectstext' => 'Această listă conține pagini care redirecționează la alte pagini de redirecționare.
Fiecare rând conține legături la primele două redirecționări, precum și ținta celei de-a doua redirecționări, care este de obicei pagina țintă "reală", către care ar trebui să redirecționeze prima pagină.
Intrările <del>tăiate</del> au fost rezolvate.',
	'double-redirect-fixed-move' => '[[$1]] a fost mutat, acum este un redirect către [[$2]]',
	'double-redirect-fixed-maintenance' => 'Reparat dubla redirecționare de la [[$1]] înspre [[$2]].',
	'double-redirect-fixer' => 'Corector de redirecționări',
	'deadendpages' => 'Pagini fără legături',
	'deadendpagestext' => 'Următoarele pagini nu se leagă de alte pagini din acestă wiki.',
	'deletedcontributions' => 'Contribuții șterse',
	'deletedcontributions-title' => 'Contribuții șterse',
	'defemailsubject' => 'E-mail {{SITENAME}} de la utilizatorul „$1”',
	'deletepage' => 'Șterge pagina',
	'delete-confirm' => 'Şterge "$1"',
	'delete-legend' => 'Şterge',
	'deletedtext' => 'Pagina „$1” a fost ștearsă.
Accesați $2 pentru o listă cu elementele recent șterse.',
	'dellogpage' => 'Jurnal ștergeri',
	'dellogpagetext' => 'Mai jos se află lista celor mai recente elemente șterse.',
	'deletionlog' => 'jurnal pagini șterse',
	'deletecomment' => 'Motiv:',
	'deleteotherreason' => 'Motiv diferit/suplimentar:',
	'deletereasonotherlist' => 'Alt motiv',
	'deletereason-dropdown' => '*Motive uzuale
** La cererea autorului
** Violarea drepturilor de autor
** Vandalism',
	'delete-edit-reasonlist' => 'Modifică motivele ștergerii',
	'delete-toobig' => 'Această pagină are un istoric al modificărilor mare, mai mult de $1 {{PLURAL:$1|revizie|revizii}}.
Ştergerea unei astfel de pagini a fost restricționată pentru a preveni apariția unor erori în {{SITENAME}}.',
	'delete-warning-toobig' => 'Această pagină are un istoric al modificărilor mult prea mare, mai mult de $1 {{PLURAL:$1|revizie|revizii}}.
Ştergere lui poate afecta baza de date a sitului {{SITENAME}};
continuă cu atenție.',
	'databasenotlocked' => 'Baza de date nu este blocată.',
	'delete_and_move' => 'Șterge și redenumește',
	'delete_and_move_text' => '==Ștergere necesară==

Pagina destinație „[[:$1]]” există deja. Doriți să o ștergeți pentru a face loc redenumirii?',
	'delete_and_move_confirm' => 'Da, șterge pagina.',
	'delete_and_move_reason' => 'Șters pentru a face loc redenumirii paginii „[[$1]]”',
	'djvu_page_error' => 'Numărul paginii DjVu eronat',
	'djvu_no_xml' => 'Imposibil de obținut XML-ul pentru fișierul DjVu',
	'deletedrevision' => 'A fost ștearsă vechea versiune $1.',
	'days' => '{{PLURAL:$1|o zi|$1 zile|$1 de zile}}',
	'deletedwhileediting' => "'''Atenție''': Această pagină a fost ștearsă după ce ați început s-o modificați!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => "'''Atenție:''' Cheia de sortare implicită („$2”) o înlocuiește pe precedenta („$1”).",
	'dberr-header' => 'Acest site are o problemă',
	'dberr-problems' => 'Ne cerem scuze! Acest site întâmpină dificultăți tehnice.',
	'dberr-again' => 'Așteaptă câteva minute și încearcă din nou.',
	'dberr-info' => '(Nu pot contacta baza de date a serverului: $1)',
	'dberr-usegoogle' => 'Între timp poți efectua căutarea folosind Google.',
	'dberr-outofdate' => 'De reținut ca indexarea conținutului nostru de către ei poate să nu fie actualizată.',
	'dberr-cachederror' => 'Următoarea pagină este o copie în cache a paginii cerute, s-ar putea să nu fie actualizată.',
	'discuss' => 'Discuţie',
);

$messages['roa-rup'] = array(
	'december' => 'Andreulu',
	'december-gen' => 'Andreulu',
	'delete' => 'Ashcirdzire',
	'disclaimers' => 'Nipricunuschire',
);

$messages['roa-tara'] = array(
	'december' => 'Decèmmre',
	'december-gen' => 'Decèmmre',
	'dec' => 'Dec',
	'delete' => 'Scangìlle',
	'deletethispage' => 'Scangille sta pàgene',
	'disclaimers' => 'No ne sacce ninde',
	'disclaimerpage' => 'Project:Scareca uarrile',
	'databaseerror' => "Errore de l'archivije",
	'dberrortext' => "Ha assute n'errore de sindassi de 'na inderrogazione sus a 'u database.
Quiste pò indicà 'nu bochere jndr'à 'u software.
L'urteme tendative de inderrogazione sus a 'u database ha state:
<blockquote><tt>\$1</tt></blockquote>
cu 'a funzione \"<tt>\$2</tt>\".
'U database ha returnate l'errore \"<tt>\$3: \$4</tt>\".",
	'dberrortextcl' => 'A assute \'n\'errore de sindasse sus a \'n\'inderrogazione d\'u database.
L\'urteme tendative de inderrogazione sus a \'u database ha state:
"$1"
ausanne \'a funzione "$2".
\'U database ha returnate l\'errore "$3: $4"',
	'directorycreateerror' => 'Non ge pozze ccrejà \'a cartelle "$1".',
	'deletedhist' => "Storie d'u scangellamende",
	'difference' => "(Differenze 'mbrà versiune)",
	'difference-multipage' => "(Differenze 'mbrà le pàggene)",
	'diff-multi' => "({{PLURAL:$1|'na versione de mmienze|$1 cchiù versiune de mmienze}} de {{PLURAL:$2|'n'utende|$2 utinde}} non ge se vèdene)",
	'diff-multi-manyusers' => "({{PLURAL:$1|'Na revisione de 'mmienze|$1 revisiune de 'mmienze}} non g'è viste da cchiù de $2 {{PLURAL:$2|utende|utinde}})",
	'datedefault' => 'Nisciuna preferenze',
	'defaultns' => "Cirche jndr'à chiste namespace:",
	'default' => 'defolt',
	'diff' => 'diff',
	'destfilename' => "Nome d'u file de destinazione:",
	'duplicatesoffile' => "{{PLURAL:$1|'U seguende file ète 'nu|Le seguende $1 file sonde}} duplicate de stu file ([[Special:FileDuplicateSearch/$2|cchiù 'mbormaziune]]):",
	'download' => 'scareche',
	'disambiguations' => 'Pàggene collegate a le pàggene de disambiguazione',
	'disambiguationspage' => 'Template:disambigue',
	'disambiguations-text' => "Le pàggene seguende appondene a 'na '''pàgene de disambiguazione'''.
'Nvece avessere appondà a 'a temateca appropriate.<br />
'Na pàgene jè trattate cumme pàgene de disambiguazione ce tu ause 'nu template ca è appundate da [[MediaWiki:Disambiguationspage|Pàggene de disambiguazione]]",
	'doubleredirects' => 'Ridirezionaminde a doppie',
	'doubleredirectstext' => "Sta pàgene elenghe le pàggene ca se ridirezionane sus a otre pàggene de ridirezionaminde.
Ogne righe condene 'nu collegamende a 'u prime e a 'u seconde ridirezionamende pe fà vedè addò arrive 'u seconde ridirezionamende, 'u quale jè normalmende 'a pàgena de destinaziona \"rèale\", addò 'u prime ridirezionamende avesse appondà.
Le situaziune de <del>ingrocie</del> onne state resolte.",
	'double-redirect-fixed-move' => "[[$1]] ha state spustate.
Mò s'avène redirette a [[$2]].",
	'double-redirect-fixed-maintenance' => 'Aggiuste le doppie redirezionaminde da [[$1]] a [[$2]].',
	'double-redirect-fixer' => 'Correttore de redirezionaminde',
	'deadendpages' => 'Pàggene senza collegamende',
	'deadendpagestext' => "Le pàggene ca seguene non g'appondute a otre pàggene sus a {{SITENAME}}.",
	'deletedcontributions' => "Condrebbute de l'utende scangellete",
	'deletedcontributions-title' => "Condrebbute de l'utende scangellate",
	'defemailsubject' => 'e-mail de {{SITENAME}} da l\'utende "$1"',
	'deletepage' => "Scangille 'a pàgene",
	'delete-confirm' => 'Scangille "$1"',
	'delete-legend' => 'Scangille',
	'deletedtext' => '"$1" onne state scangillete.
Vide $2 pe \'na reggistrazione de le scangellaziune recende.',
	'dellogpage' => 'Archivie de le scangellaminde',
	'dellogpagetext' => "Sotte ste 'na liste de le cchiù recende scangellaziune.",
	'deletionlog' => 'Archivije de le scangellaminde',
	'deletecomment' => 'Mutive:',
	'deleteotherreason' => 'Otre mutive de cchiù:',
	'deletereasonotherlist' => 'Otre mutive',
	'deletereason-dropdown' => "*Mutive comune de scangellaminde
** Richieste de l'autore
** Violazione d'u Copyright
** Vandalisme",
	'delete-edit-reasonlist' => 'Mutive de scangellazione de le cangiaminde',
	'delete-toobig' => "Sta pàgene tène 'na storie de cangiaminde troppe longhe, sus a $1 {{PLURAL:$1|revisione|revisiune}}.
'U scangellamende de stuèzze de pàgene avène ristrette pe prevenì 'ngasinaminde accidentale de {{SITENAME}}.",
	'delete-warning-toobig' => "Sta pàgene tène 'na storie troppo longhe, sus a $1 {{PLURAL:$1|revisione|revisiune}}.
Scangellanne pò ccreja casine sus a le operazione d'u database de {{SITENAME}};
và cunge cunge!",
	'databasenotlocked' => "'U database non g'è blocchete.",
	'delete_and_move' => 'Scangille e spuèste',
	'delete_and_move_text' => '== Scangellazzione richieste ==
\'A pàgene de destinazione "[[:$1]]" esiste già.
Tu à vuè ccu scangille o vuè ccù iacchie \'nu mode pe spustarle?',
	'delete_and_move_confirm' => "Sine, scangille 'a pàggene",
	'delete_and_move_reason' => '\'U scangellamende avène fatte pe spustà da "[[$1]]"',
	'djvu_page_error' => 'Pàgene DjVu fore da le limite',
	'djvu_no_xml' => "Non ge riesche a esaminà l'XML d'u file DjVu",
	'deletedrevision' => 'Vecchia revisione scangellete $1',
	'days-abbrev' => '$1g',
	'days' => '{{PLURAL: $1|$1 sciurne|$1 sciurne}}',
	'deletedwhileediting' => "'''Fà attenziò''': Sta pàgene ha state scangellete apprime ca tu acumenzasse a fà 'u cangiamende!",
	'descending_abbrev' => 'desc',
	'duplicate-defaultsort' => "'''Attenziò:''' 'A chiave de arrangamende de default \"\$2\" sovrascrive quedda precedende \"\$1\".",
	'dberr-header' => "Sta Uicchi tène 'nu probbleme",
	'dberr-problems' => "Simw spiacende! Stu site stè 'ngondre de le diffcoltà tecniche.",
	'dberr-again' => 'Aspitte quacche minute e pò recareche.',
	'dberr-info' => "(Non ge riuscime a condattà 'u server d'u database: $1)",
	'dberr-usegoogle' => 'Pu mumende tu puè pruvà a cercà cu Google.',
	'dberr-outofdate' => 'Vide ca le indice lore de le condenute nuèstre ponne essere non aggiornate.',
	'dberr-cachederror' => "Queste jè 'na copie ''cache'' d'a pàgene ca è cercate e allore non g'à puè cangià.",
);

$messages['ru'] = array(
	'december' => 'декабрь',
	'december-gen' => 'декабря',
	'dec' => 'дек',
	'delete' => 'Удалить',
	'deletethispage' => 'Удалить эту страницу',
	'disclaimers' => 'Отказ от ответственности',
	'disclaimerpage' => 'Project:Отказ от ответственности',
	'databaseerror' => 'Ошибка базы данных',
	'dberrortext' => 'Обнаружена ошибка синтаксиса запроса к базе данных.
Это может означать ошибку в программном обеспечении.
Последний запрос к базе данных:
: <code>$1</code>
произошёл из функции «<code>$2</code>».
База данных возвратила ошибку «<code>$3: $4</code>».',
	'dberrortextcl' => 'Обнаружена ошибка синтаксиса запроса к базе данных.
Последний запрос к базе данных:
: «<code>$1</code>»
произошёл из функции «<code>$2</code>».
База данных возвратила ошибку «<code>$3: $4</code>».',
	'directorycreateerror' => 'Невозможно создать директорию «$1».',
	'deletedhist' => 'История удалений',
	'difference' => '(Различия между версиями)',
	'difference-multipage' => '(Различия между страницами)',
	'diff-multi' => '({{PLURAL:$1|не показана $1 промежуточная версия|не показаны $1 промежуточные версии|не показаны $1 промежуточных версий}} {{PLURAL:$2|$2 участника|$2 участников|$2 участников}})',
	'diff-multi-manyusers' => '(не {{PLURAL:$1|показана $1 промежуточная версия|показаны $1 промежуточные версии|показаны $1 промежуточных версий}}, сделанные более чем $2 {{PLURAL:$2|участником|участниками}})',
	'datedefault' => 'По умолчанию',
	'defaultns' => 'Иначе искать в следующих пространствах имён:',
	'default' => 'по умолчанию',
	'diff' => 'разн.',
	'destfilename' => 'Новое имя файла:',
	'duplicatesoffile' => '{{PLURAL:$1|Следующий $1 файл является дубликатом|Следующие $1 файла являются дубликатами|Следующие $1 файлов являются дубликатами}} этого файла ([[Special:FileDuplicateSearch/$2|подробности]]):',
	'download' => 'загрузить',
	'disambiguations' => 'Страницы, ссылающиеся на страницы разрешения неоднозначности',
	'disambiguationspage' => 'Template:Неоднозначность',
	'disambiguations-text' => "Следующие страницы ссылаются на '''многозначные страницы'''.
Вместо этого они, вероятно, должны указывать на соответствующую конкретную статью.<br />
Страница считается многозначной, если на ней размещён шаблон, имя которого указано на странице [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Двойные перенаправления',
	'doubleredirectstext' => 'На этой странице представлен список перенаправлений на другие перенаправления.
Каждая строка содержит ссылки на первое и второе перенаправления, а также целевую страницу второго перенаправления, в которой обычно указывается название страницы, куда должно ссылаться первое перенаправление.
<del>Зачёркнутые</del> записи были исправлены.',
	'double-redirect-fixed-move' => 'Страница [[$1]] была переименована, сейчас она перенаправляет на [[$2]]',
	'double-redirect-fixed-maintenance' => 'Исправление двойного перенаправления с [[$1]] на [[$2]].',
	'double-redirect-fixer' => 'Исправитель перенаправлений',
	'deadendpages' => 'Тупиковые страницы',
	'deadendpagestext' => 'Следующие страницы не содержат ссылок на другие страницы в этой вики.',
	'deletedcontributions' => 'Удалённый вклад участника',
	'deletedcontributions-title' => 'Удалённый вклад',
	'defemailsubject' => '{{SITENAME}} — Письмо от $1',
	'deletepage' => 'Удалить страницу',
	'delete-confirm' => '$1 — удаление',
	'delete-legend' => 'Удаление',
	'deletedtext' => '«$1» была удалена.
См. $2 для просмотра списка последних удалений.',
	'dellogpage' => 'Журнал удалений',
	'dellogpagetext' => 'Ниже приведён журнал последних удалений.',
	'deletionlog' => 'журнал удалений',
	'deletecomment' => 'Причина:',
	'deleteotherreason' => 'Другая причина/дополнение:',
	'deletereasonotherlist' => 'Другая причина',
	'deletereason-dropdown' => '* Типовые причины удаления
** вандализм
** по запросу автора
** нарушение авторских прав',
	'delete-edit-reasonlist' => 'Править список причин',
	'delete-toobig' => 'У этой страницы очень длинная история изменений, более $1 {{PLURAL:$1|версии|версий|версий}}.
Удаление таких страниц было запрещено во избежание нарушений в работе сайта {{SITENAME}}.',
	'delete-warning-toobig' => 'У этой страницы очень длинная история изменений, более $1 {{PLURAL:$1|версии|версий|версий}}.
Её удаление может привести к нарушению нормальной работы базы данных сайта {{SITENAME}};
действуйте с осторожностью.',
	'databasenotlocked' => 'База данных не была заблокирована.',
	'delete_and_move' => 'Удалить и переименовать',
	'delete_and_move_text' => '== Требуется удаление ==
Страница с именем «[[:$1]]» уже существует.
Хотите удалить её, чтобы сделать возможным переименование?',
	'delete_and_move_confirm' => 'Да, удалить эту страницу',
	'delete_and_move_reason' => 'Удалено для возможности переименования «[[$1]]»',
	'djvu_page_error' => 'Номер страницы DjVu вне досягаемости',
	'djvu_no_xml' => 'Невозможно получить XML для DjVu',
	'deletedrevision' => 'Удалена старая версия $1',
	'days-abbrev' => '$1 д',
	'days' => '{{PLURAL:$1|$1 день|$1 дня|$1 дней}}',
	'deletedwhileediting' => "'''Внимание'''. Эта страница была удалена после того, как вы начали её править!",
	'descending_abbrev' => 'убыв',
	'duplicate-defaultsort' => 'Внимание. Ключ сортировки по умолчанию «$2» переопределяет прежний ключ сортировки по умолчанию «$1».',
	'dberr-header' => 'Эта вики испытывает затруднения',
	'dberr-problems' => 'Извините! На данном сайте возникли технические трудности.',
	'dberr-again' => 'Попробуйте обновить страницу через несколько минут.',
	'dberr-info' => '(невозможно соединиться с сервером баз данных: $1)',
	'dberr-usegoogle' => 'Пока вы можете попробовать поискать с помощью Google.',
	'dberr-outofdate' => 'Но имейте в виду, что его индекс может оказаться устаревшим.',
	'dberr-cachederror' => 'Ниже представлена закэшированная версия запрашиваемой страницы, возможно, она не отражает последних изменений.',
	'discuss' => 'Обсудить',
);

$messages['rue'] = array(
	'december' => 'децембер',
	'december-gen' => 'децембра',
	'dec' => 'дец',
	'delete' => 'Вымазати',
	'deletethispage' => 'Змазати тоту сторінку',
	'disclaimers' => 'Вылучіня зодповідности',
	'disclaimerpage' => 'Project:Вылучіня зодповідности',
	'databaseerror' => 'Датабазова хыба',
	'dberrortext' => 'Найджена  сінтактічна хыба в запросї до датабазы.
Тото може вказовати на хыбу в проґрамовім забезпечіню.
Послїднїй запрос до датабазы:
<blockquote><tt>$1</tt></blockquote>
з функції "<tt>$2</tt>".
Датабаза вернула хыбу "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Найджена сінтактічна хыба в запросї до датабазы.
Послїднїй запрос до датабазы:
«$1»
з функції «$2».
Датабаза вернула хыбу «$3: $4».',
	'directorycreateerror' => 'Не є можне вытворити адресарь «$1».',
	'deletedhist' => 'Вымазана історія',
	'difference' => '(роздїл міджі ревізіями)',
	'difference-multipage' => '(Роздїлы міджі сторінками)',
	'diff-multi' => '({{PLURAL:$1|Не є зображена єдна міджілегла верзія|Не суть зображены $1 міджілеглы верзії|Не є зображено $1 міджілеглых верзій}} од {{PLURAL:$2|1 хоснователя|$2 хоснователїв}} .)',
	'diff-multi-manyusers' => '(Не є зображено $1 міджілеглых верзій од веце як $2 {{PLURAL:$2|хоснователя|хоснователїв}}.)',
	'datedefault' => 'Імпліцітный',
	'defaultns' => 'Інакше глядати в такых просторах назв:',
	'default' => 'імпліцітне',
	'diff' => 'різн.',
	'destfilename' => 'Назва цілёвого файлу:',
	'duplicatesoffile' => '{{plural:$1|Наслїдуючій файл є дуплікат|Наслїдуючі $1 файлы суть дуплікаты|Наслїдуючіх $1 файлів є дуплікатами}} того файлу ([[Special:FileDuplicateSearch/$2|детайлы]]):',
	'download' => 'скачати',
	'disambiguations' => 'Сторінкы одказуючі на богатозначны статї',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Одказы на наслїдуючіх сторінках ведуть на '''богатозначны сторінкы'''. (сторінкы котры обсягують дакотру з тых шаблон на [[MediaWiki:Disambiguationspage|списку шаблон про богатозначны сторінкы]]) намісто на дану статю.",
	'doubleredirects' => 'Двоїты напрямлїня',
	'doubleredirectstext' => 'На тій сторінцї є список напрямлїн ведучіх на далшы напрямлїня.
Каждый рядок обсягує одказ на перше і друге напрямлїня і ку тому ціль другого напрямлїня, котрый звычайно вказує мено „реалной“ цілёвой сторінкы, на котру бы ся мало перше напрямлїня одказовати.
<del>Перечаркнуты</del> положкы уж были вырїшены.',
	'double-redirect-fixed-move' => 'Сторінка [[$1]] была переменована, нынї напрямлює на [[$2]]',
	'double-redirect-fixed-maintenance' => 'Корекція двоїтого напрямлїня з [[$1]] на [[$2]].',
	'double-redirect-fixer' => 'Оправарь напрямлїнь',
	'deadendpages' => 'Слїпы сторінкы',
	'deadendpagestext' => 'Наслїдуючі сторінкы не одказують на жадну іншу сторінку {{grammar:2sg|{{SITENAME}}}}.',
	'deletedcontributions' => 'Вымазаны приспевкы хоснователя',
	'deletedcontributions-title' => 'Вымазаны приспевкы хоснователя',
	'defemailsubject' => '{{SITENAME}}: лист од "$1"',
	'deletepage' => 'Змазати сторінку',
	'delete-confirm' => 'Змазаня  $1',
	'delete-legend' => 'Вымазати',
	'deletedtext' => '"$1" было змазане.
Смоть $2 про список послїднїх змазань.',
	'dellogpage' => 'Лоґ вымазаня',
	'dellogpagetext' => 'Ту є список послїднїх змазаных сторінок.',
	'deletionlog' => 'Лоґ вымазаня',
	'deletecomment' => 'Причіна:',
	'deleteotherreason' => 'Інша/додаткова причіна:',
	'deletereasonotherlist' => 'Інша причіна',
	'deletereason-dropdown' => '*Звычайны причіны змазаня
** На жадость автора
** Порушїня авторьскых прав
** Вандалізм',
	'delete-edit-reasonlist' => 'Едітовати причіны вымазаня',
	'delete-toobig' => 'Тота сторінка має велику історію едітованя, через $1 {{plural:$1|верзії|верзій|верзій}}. Мазаня такых сторінок є обмеджено, жебы ся передішло нехоченому нарушіню {{grammar:2sg|{{SITENAME}}}}.',
	'delete-warning-toobig' => 'Тота сторінка має велику історію едітацій, через $1 {{plural:$1|верзії|верзій|верзій}}. Мазаня такых сторінок може нарушыти датабазовы операцім {{grammar:2sg|{{SITENAME}}}}; мерькуйте.',
	'databasenotlocked' => 'Датабаза не є замкнута.',
	'delete_and_move' => 'Змазати і переменовати',
	'delete_and_move_text' => '==Є треба змазаня==

Цілёва сторінка „[[:$1]]“ уж екзістує. Желате собі єй змазати про уволнїня місця про пересун?',
	'delete_and_move_confirm' => 'Гей, змазати сторінку',
	'delete_and_move_reason' => 'Змазане про уможнїня переменованя з „[[$1]]“',
	'djvu_page_error' => 'Сторінка DjVu мімо россяг',
	'djvu_no_xml' => 'Створїня XML про файл DjVu ся не подарило.',
	'deletedrevision' => 'Змазана стара ревізія $1',
	'days' => '{{PLURAL:$1|$1 день|$1 днї|$1 днїв}}',
	'deletedwhileediting' => "'''Увага:''' почас вашой едітації была тота сторінка змазана!",
	'descending_abbrev' => 'спад',
	'duplicate-defaultsort' => 'Увага: Імпліцітный ключ сортованя (DEFAULTSORTKEY) „$2“ переписує скоре наставлену годноту „$1“.',
	'dberr-header' => 'Тота вікі має даякы проблемы',
	'dberr-problems' => 'Перебачте! Тот сервер має теперь технічны проблемы.',
	'dberr-again' => 'Спробуйте обновити сторінку за пару мінут.',
	'dberr-info' => '(не годен навязати споїня з датабазовым сервером: $1)',
	'dberr-usegoogle' => 'Можете спробовати поглядати за допомогов Google.',
	'dberr-outofdate' => 'Майте на увазї, же ёго індексы можуть быти застарілыма.',
	'dberr-cachederror' => 'Наслїдуюча сторінка є копія з кеш і не мусить быти актуалне.',
);

$messages['rup'] = array(
	'december' => 'Andreulu',
	'december-gen' => 'Andreulu',
	'delete' => 'Ashcirdzire',
	'disclaimers' => 'Nipricunuschire',
);

$messages['ruq'] = array(
	'december' => 'Andreulu',
	'december-gen' => 'Andreulu',
	'delete' => 'Ashcirdzire',
	'disclaimers' => 'Nipricunuschire',
);

$messages['ruq-cyrl'] = array(
	'december' => 'децембри',
	'december-gen' => 'децември',
	'dec' => 'дец',
	'delete' => 'Делајре',
	'disclaimers' => 'Тајменулс',
	'disclaimerpage' => 'Project:тајменул',
	'diff' => 'диференћу',
);

$messages['ruq-latn'] = array(
	'december' => 'decembri',
	'december-gen' => 'decembri',
	'dec' => 'dec',
	'delete' => 'Delăre',
	'disclaimers' => 'tǎmenuls',
	'disclaimerpage' => 'Project:tǎmenul',
	'diff' => 'diferenţu',
);

$messages['sa'] = array(
	'december' => 'दशम्बर्',
	'december-gen' => 'दशम्बर्',
	'dec' => 'दशं॰',
	'delete' => 'विलुप्यताम्',
	'deletethispage' => 'इदं पृष्ठम् अपाक्रियताम्',
	'disclaimers' => 'प्रत्याख्यानम्',
	'disclaimerpage' => 'Project:साधारणं प्रत्याख्यानम्',
	'databaseerror' => 'दत्ताधारे दोषः',
	'dberrortext' => 'समंकाधार पृच्छायां वाक्यरचना त्रुटिरेका अभवत्।
अनेन अस्माकं तन्त्रांशे त्रुटिरपि निर्दिष्टा स्यात्।
अन्तिमा चेष्टिता समंकाधार-पृच्छा आसीत्:
<blockquote><tt>$1</tt></blockquote>
 "<tt>$2</tt>" इत्यस्मात् फलनात्।
समंकाधारे त्रुटिरासीत्:  "<tt>$3: $4</tt>" इति।',
	'dberrortextcl' => 'समंकाधार पृच्छायां वाक्यरचना त्रुटिरेका अभवत्।
अन्तिमा चेष्टिता समंकाधार पृच्छा आसीत् :
"$1"
"$2" इति फलनात्।
समंकाधारे "$3:$4" इति त्रुटिर्जाता।',
	'directorycreateerror' => '$1 इति निर्देशिकां स्रष्टुं न अपारयत्',
	'difference' => '(संस्करणानां भेदाः)',
	'datedefault' => 'वरीयांसि नास्ति',
	'default' => 'यदभावे',
	'diff' => 'भेदः',
	'download' => 'डाउनलोड',
	'disambiguationspage' => 'Template:असन्दिग्धम्',
	'doubleredirects' => 'दुगुनी-अनुप्रेषिते',
	'deletepage' => 'पृष्ठं निराकरोतु।',
	'delete-confirm' => 'विलुप्यताम् "$1"',
	'delete-legend' => 'विलुप्यताम्',
	'deletedtext' => '"$1" इत्येतद् अपाकृतमस्ति।
सद्यःकृतानां अपाकरणानाम् अभिलेखः $2 इत्यस्मिन् पश्यतु।',
	'dellogpage' => 'अपाकरणानां सूचिका',
	'deletecomment' => 'कारणम् :',
	'deleteotherreason' => 'अपरं/अतिरिक्तं कारणम् :',
	'deletereasonotherlist' => 'इतर कारणम्',
	'duplicate-defaultsort' => '\'\'\'प्रबोधः\'\'\' पुरानी मूल क्रमांकन कुंजी "$1" के बजाय अब मूल क्रमांकन कुंजी "$2" होगी।',
	'dberr-header' => 'अस्मिन् विकिमध्ये काचित् समस्या विद्यते',
	'dberr-problems' => 'क्षम्यताम् ! अस्मिन् जालपुटे तान्त्रिकसमस्याः अनुभूयमानाः सन्ति ।',
);

$messages['sah'] = array(
	'december' => 'Ахсынньы',
	'december-gen' => 'Ахсынньы',
	'dec' => 'Ахс',
	'delete' => 'Соттор',
	'deletethispage' => 'Бу сирэйи соттор',
	'disclaimers' => 'Бүк охсунуу',
	'disclaimerpage' => 'Project:Бүк охсунуу',
	'databaseerror' => 'Билии олоҕор сыыһа',
	'dberrortext' => 'Билии олоҕор ыйытык синтаксииһа сыыһалаах эбит.
Ол бырагырааммаҕар баар сыыһаттан буолуон сөп.
Билии олоҕор бүтэһик ыйытык маннык:
<blockquote><tt>$1</tt></blockquote>
(бу пуунсуйаттан тахсыбыт "<tt>$2</tt>").
Билии олоҕо сыыһаны көрдөрдө "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Билии олоҕор ыйытык синтаксииһын сыыһата таҕыста.
Билии олоҕор бүтэһик ыйытык:
"$1"
"$2" пуунсуйаттан тахсыбыт.
Билии олоҕо маннык сыыһаны көрдөрдө "$3: $4"',
	'directorycreateerror' => '"$1" диэн ыйдарыы кыайан оҥоһуллубата.',
	'deletedhist' => 'Сотуллубут история',
	'difference' => '(Торумнар бэйэ-бэйэлэриттэн уратылара)',
	'difference-multipage' => '(Сирэйдэр ыккардыларынааҕы уратылар)',
	'diff-multi' => '({{PLURAL:$2|$2 кыттааччы|$2 ахсааннаах кыттааччы}} {{PLURAL:$1|$1 ыккардынааҕы барыла көрдөрүллүбэтэ|$1 ахсааннаах ыккардынааҕы барыла көрдөрүллүбэтэ|$1.}})',
	'diff-multi-manyusers' => '(Кырата {{PLURAL:$2|$1 кыттааччы|$2 ахсааннаах кыттааччы}} оҥорбут {{PLURAL:$1|ыккардынааҕы $1 барыла|ыккардынааҕы $1 барыллара}} көрдөрүллүбэтэ)',
	'datedefault' => 'Көннөрү көстүүтэ',
	'defaultns' => 'Атын ыйыллыбатаҕына бу аат далларыгар көрдүүргэ:',
	'default' => 'чопчу ыйыллыбатаҕына маннык',
	'diff' => 'уратыта',
	'destfilename' => 'Билэ хайдах ааттаах буолуохтааҕа:',
	'duplicatesoffile' => 'Бу билэ {{PLURAL:$1|дубликаата манна көстөр|$1 дубликаата манна көстөллөр}} ([[Special:FileDuplicateSearch/$2|сиһилии]]):',
	'download' => 'хачайдаан ылыы',
	'disambiguations' => 'Элбэх суолталаах өйдөбүллэргэ сигэнэр сирэйдэр',
	'disambiguationspage' => 'Template:элбэх суолталаах өйдөбүллэр',
	'disambiguations-text' => "Маннык сирэйдэр '''омонимнар сирэйдэрин''' кытта сибээстээхтэр. Ол оннугар чуолаан теманы кытта сибээстэһиэхтээхтэр.<br />Өскө бу халыыбы [[MediaWiki:Disambiguationspage]] туттубут буоллахтарына, сирэй омонимнары суох оҥоруу курдук обработкаламмыт.",
	'doubleredirects' => 'Хос көһөрөөһүн',
	'doubleredirectstext' => 'Бу сирэйгэ атын сиргэ утаарар хос утаарыылар тиһиктэрэ көстөр.
Хас устуруока аайы бастакы уонна иккис утаарыга сигэ баар, ону таһынан иккис утаарыыга баар сирэй аадырыһа (аата) баар, ол аата бастакы утаарыы дьиҥинэн ханна утаарыахтааҕа көстөр.
<del>Сотуллубут</del> суруктар көннөрүллүбүттэр.',
	'double-redirect-fixed-move' => '[[$1]] сирэй аата уларытыллыбыт, билигин манна утаарар [[$2]]',
	'double-redirect-fixed-maintenance' => '[[$1]] сирэйтэн [[$2]] сирэйгэ хос утаарыыны көннөрүү.',
	'double-redirect-fixer' => 'Утаарыылары көннөрөөччү',
	'deadendpages' => 'Dead-end (Бүтэй) сирэйдэр',
	'deadendpagestext' => 'Бу ыстатыйалар {{SITENAME}} саайтын атын сирэйдэригэр сигэммэттэр.',
	'deletedcontributions' => 'Сотуллубут көннөрүү',
	'deletedcontributions-title' => 'Сотуллубут көннөрүү',
	'defemailsubject' => '{{SITENAME}} —  бу киһиттэн $1 сурук кэлбит',
	'deletepage' => 'Сирэйи сот',
	'delete-confirm' => 'Маны "$1" соторго',
	'delete-legend' => 'Сотуу',
	'deletedtext' => '«$1» сотуллубут.
Бүтэһик сотуулар испииһэктэрин манна: $2 көр.',
	'dellogpage' => 'Сотуу испииһэгэ',
	'dellogpagetext' => 'Манна кэнники сотуулар испииһэктэрэ көстөр.',
	'deletionlog' => 'сотуу испииһэгэ',
	'deletecomment' => 'Төрүөтэ:',
	'deleteotherreason' => 'Атын/эбии биричиинэлэр:',
	'deletereasonotherlist' => 'Атын биричиинэ',
	'deletereason-dropdown' => '*Common сотуу биричиинэтэ
** ааптар ирдээһинэ
** ааптар быраабын күөмчүлээһин
** Алдьатыы (Вандализм)',
	'delete-edit-reasonlist' => 'Сотуу төрүөтүн уларытыы',
	'delete-toobig' => 'Бу сирэй уларытыыларын историята уһун, хас да ($1) {{PLURAL:$1|хат көрүүлээх|хат көрүүлэрдээх}}. Маннык сирэйдэри сотор хааччахтанар, тоҕо диэххэ алҕас {{SITENAME}} алдьаныан сөп.',
	'delete-warning-toobig' => 'Бу сирэй уларыылара уһун историялаах, хас да ($1) {{PLURAL:$1|хат көрүүлээх|хат көрүүлэрдээх}}. Маны соттоххуна, {{SITENAME}} билэтин тиһигин алдьатыан сөп; салгыыр буоллаххына сэрэнэн үлэлээ.',
	'databasenotlocked' => 'БД уларытааһын бобуллубата.',
	'delete_and_move' => 'Суох гын уонна аатын уларыт',
	'delete_and_move_text' => '==Сотуохха наада==

Маннык ааттаах сирэй [[:$1|«$1»]] бэлиэр баар. Эн ону суох гынан баран аатын уларытаары гынаҕын дуо?',
	'delete_and_move_confirm' => 'Сөп, бу сирэйи суох гын',
	'delete_and_move_reason' => 'Аатын уларытаары сотулунна "[[$1]]"',
	'djvu_page_error' => 'DjVu сирэй тиһик таһыгар эбит',
	'djvu_no_xml' => 'DjVu билэтигэр аналлаах XML кыайан ылыллыбата',
	'deletedrevision' => '$1 урукку торума сотулунна',
	'days' => '{{PLURAL:$1|$1 күн|$1 күн}}',
	'deletedwhileediting' => "'''Болҕой''': Сирэйи көннөрө олордоххуна ким эрэ сотон кэбистэ!",
	'descending_abbrev' => 'кыччат',
	'duplicate-defaultsort' => 'Болҕой: Наардааһын «$2» күлүүһэ урукку «$1» күлүүһү сабар (Ключ сортировки переопределяет прежний ключ).',
	'dberr-header' => 'Бу биики туга эрэ сатаммата',
	'dberr-problems' => 'Баалаама! Бу саайт техническэй ыарахаттары көрсүбүт.',
	'dberr-again' => 'Аҕыйах мүнүүтэннэн саҥардан көрөөр.',
	'dberr-info' => '(Билэ тиһигин кытта ситим быстыбыт: $1)',
	'dberr-usegoogle' => 'Онуоха-маныаха дылы Google көмөтүнэн көрдүөххүн сөп.',
	'dberr-outofdate' => 'Индэксэ эргэрбит буолуон сөбүн умнума.',
	'dberr-cachederror' => 'Сирэй кээштэммит барыла көстөр, баҕар эргэрбит буолуон сөп.',
);

$messages['sc'] = array(
	'december' => 'Nadale',
	'december-gen' => 'Nadale',
	'dec' => 'Nad',
	'delete' => 'Fùlia',
	'deletethispage' => 'Fùlia custa pàgina',
	'disclaimers' => 'Abbertimentos',
	'disclaimerpage' => 'Project:Abbertimentos generales',
	'databaseerror' => 'Faddina de su database',
	'dberrortext' => 'Faddina de sintassi in sa pregunta fata a su database.
Custu podet indicare unu sbàlliu de su software.
S\'ùrtima consulta imbiada a su database est istada:
<blockquote><tt>$1</tt></blockquote>
aintru de sa funtzione "<tt>$2</tt>".
Su database at torradu custa faddina "<tt>$3: $4</tt>".',
	'deletedhist' => 'Istòria fuliada',
	'difference' => '(Diferèntzias intre revisiones)',
	'diff' => 'dif',
	'destfilename' => 'Nùmene de su file de destinatzione:',
	'download' => 'scàrriga',
	'disambiguationspage' => 'Template:Disambìgua',
	'doubleredirects' => 'Redirects dòpios',
	'doubleredirectstext' => 'Custa pàgina cuntenet una lista de pàginas ki re-indiritzant a àteras pàginas de re-indiritzamentu.
Ogni lìnia cuntenet ligàmines a su primu e a su de duos re-indiritzamentu, aici comente sa prima lìnia de sa de duos re-indiritzamentos, chi de sòlitu adòbiat s\'artìculu "beru", a sa cale fintzas su primu re-indiritzamentu dia depet puntare.
Is re-indiritzamentos <del>cantzellados</del> sunt stados curretos.',
	'deadendpages' => 'Pàginas chentza bessida',
	'defemailsubject' => 'Missada dae {{SITENAME}}',
	'deletepage' => 'Fùlia pàgina',
	'delete-confirm' => 'Fùlia "$1"',
	'delete-legend' => 'Fuliare',
	'deletedtext' => 'Sa pàgina "$1" est istada fuliada.
Càstia su log $2 pro unu registru de is ùrtimas fuliaduras.',
	'dellogpage' => 'Burraduras',
	'dellogpagetext' => 'A sighire una lista de is prus reghentes burraduras.',
	'deletecomment' => 'Motivu:',
	'deleteotherreason' => 'Àteru motivu o motivu agiuntivu:',
	'deletereasonotherlist' => 'Àteru motivu',
	'databasenotlocked' => 'Su database no est bloccadu.',
	'delete_and_move_confirm' => 'Eja, cantzella sa pàgina',
);

$messages['scn'] = array(
	'december' => 'Dicèmmiru',
	'december-gen' => 'Dicèmmiru',
	'dec' => 'Dic',
	'delete' => 'elìmina',
	'deletethispage' => 'Elìmina sta pàggina',
	'disclaimers' => 'Avvirtenzi',
	'disclaimerpage' => 'Project:Avvirtenzi ginirali',
	'databaseerror' => 'Erruri dû database',
	'dberrortext' => 'Erruri di sintassi ntâ richiesta nultrata a lu databbasi.
Chistu putissi innicari la prisenza d\'un bug ntô software.
L\'ùrtima query mannata a lu database fu:
<blockquote><tt>$1</tt></blockquote>
richiamata dâ funzioni "<tt>$2</tt>".
Lu databbasi desi l\'erruri "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Erruri di sintassi ntâ richiesta nultrata a lu database.
L\'ùrtima query mannata a lu database hà stata:
"$1"
richiamata dâ funzioni "$2".
MySQL hà ristituitu lu siquenti erruri "$3: $4".',
	'directorycreateerror' => 'Mpussìbbili criari la directory "$1".',
	'deletedhist' => 'Storia cancillata',
	'difference' => '(Diffirenzi tra li rivisioni)',
	'diff-multi' => '({{PLURAL:$1|Na rivisioni ntirmèdia nun ammustrata|$1 rivisioni ntirmedi nun ammustrati}}.)',
	'datedefault' => 'Nudda prifirenza',
	'defaultns' => 'In casu cuntrariu cerca ni sti namespace:',
	'default' => 'pridifinitu',
	'diff' => 'diff',
	'destfilename' => 'Nomu dû file di distinazzioni:',
	'duplicatesoffile' => '{{PLURAL:$1|Chistu|Chisti $1}} file {{PLURAL:$1|è nu dupppiuni|sunnu duppiuni}} di stu file ([[Special:FileDuplicateSearch/$2|cchiù dittagli]]):',
	'download' => 'scarica',
	'disambiguations' => 'Pàggini cu liami ambìgui',
	'disambiguationspage' => 'Template:Disambigua',
	'disambiguations-text' => "Li pàggini ntâ lista ca sequi cuntèninu dî culligamenti a '''pàggini di disambiguazzioni''' e nun a l'argumentu cui avìssiru a fari rifirimentu.<br />
Vèninu cunzidirati pàggini di disambiguazzioni tutti chiddi ca cuntèninu li template alincati 'n [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Rinnirizzamenti duppi',
	'doubleredirectstext' => 'Chista pàggina alenca li pàggini chi rinnirìzzanu a àutri pàggini di rinnirizzamentu.
Ognuna riga cunteni li culligamenti a lu primu e a lu secunnu redirect, oltri â prima riga di testu dû secunnu redirect ca di sòlitu cunteni la pàggina di distinazzioni "curretta" â quali avissi a puntari macari lu primu redirect.
Li redirect <del>cancillati</del> furunu curretti.',
	'double-redirect-fixed-move' => "[[$1]] fu spustata 'n modu automàticu, ora è nu redirect a [[$2]]",
	'double-redirect-fixer' => 'Curritturi di redirect',
	'deadendpages' => 'Pàggini senza nisciuta',
	'deadendpagestext' => 'Li pàggini ndicati di sèquitu sunnu privi di culligamenti versu àutri pàggini dû situ.',
	'deletedcontributions' => 'Cuntribbuti utenti scancillati',
	'deletedcontributions-title' => 'Cuntribbuti utenti scancillati',
	'defemailsubject' => 'Missaggiu di {{SITENAME}}',
	'deletepage' => 'Elìmina la pàggina',
	'delete-confirm' => 'Cancella "$1"',
	'delete-legend' => 'Cancella',
	'deletedtext' => '"$1" ha statu cancillatu.
Talìa $2 pi na lista di cancillazzioni ricenti.',
	'dellogpage' => 'Cancillazzioni',
	'dellogpagetext' => 'Di sèquitu sunnu alincati li pàggini cancillati di ricenti.',
	'deletionlog' => 'Log dî cancillazzioni',
	'deletecomment' => 'Mutivu:',
	'deleteotherreason' => 'Autra mutivazioni o mutivazioni in più:',
	'deletereasonotherlist' => 'Autra mutivazioni',
	'deletereason-dropdown' => "*Mutivazzioni cchiù cumuni pi la cancillazzioni
** Dumanna di l'auturi
** Viulazzioni di copyright
** Vannalismu",
	'delete-edit-reasonlist' => 'Cancia li mutivazzioni pi la cancillazioni',
	'delete-toobig' => 'La storia dî canciamenti di sta pàggina è assai longa (ortri $1 {{PLURAL:$1|rivisioni|rivisioni}}). La sò scancillazzioni vinni limitata pi scanzari la pussibbilitati di criari senza vulìrilu prubbremi di funziunamentu ô database di {{SITENAME}}.',
	'delete-warning-toobig' => 'La storia di sta pàggina è assai longa (ortri $1 {{PLURAL:$1|rivisioni|rivisioni}}). La sò scancillazzioni pò dari prubbremi di funziunamentu ô database di {{SITENAME}}; prucèdiri cu attinzioni.',
	'databasenotlocked' => 'Lu database nun è bluccatu.',
	'delete_and_move' => 'Scancella e sposta',
	'delete_and_move_text' => '==Richiesta di cancillazzioni==

La pàggina di distinazzioni "[[:$1]]" asisti già. S\'addisìa cancillàrila pi rènniri pussìbbili lu spustamentu?',
	'delete_and_move_confirm' => 'Sì, suvrascrivi la pàggina asistenti',
	'delete_and_move_reason' => 'Cancillata pi rènniri pussìbbili lu spustamentu',
	'djvu_page_error' => 'Nùmmuru di pàggina DjVu erratu',
	'djvu_no_xml' => 'Mpussibbili òtteniri lu XML pô file DjVu',
	'deletedrevision' => 'Rivisioni pricidenti, cancillata: $1.',
	'deletedwhileediting' => "'''Accura''': Sta pàggina vinni scancillata doppu c'hai accuminzatu a scanciàrila!",
	'descending_abbrev' => 'dicrisc',
	'duplicate-defaultsort' => 'Accura: la chiavi priddifinuta d\'urdinamentu "$2" si sciarrìa cu chidda d\'antura "$1".',
	'dberr-header' => 'Sta wiki havi nu prublema',
	'dberr-problems' => 'Spiacenti! Stu situ sta havennu prublema tecnici.',
	'dberr-again' => 'Prova a aspittari na para di minuti e ricaricari.',
	'dberr-info' => '(Impussibili cuntattari lu server dô database: $1)',
	'dberr-usegoogle' => 'Poi pruvari a circari supra Google ammentri.',
	'dberr-outofdate' => 'Nota ca la loru indicizzazioni dê nostri cuntintinuta po essiri nun aggiurnata.',
	'dberr-cachederror' => 'Chista ca segui è na copia cache da pàggina richiesta, e putissi essiri nun aggiurnata.',
);

$messages['sco'] = array(
	'december' => 'December',
	'december-gen' => 'Dizember',
	'dec' => 'Diz',
	'delete' => 'Delete',
	'deletethispage' => 'Delete this page',
	'disclaimers' => 'Disclamation',
	'disclaimerpage' => 'Project:General_disclamation',
	'databaseerror' => 'Database error',
	'dberrortext' => 'A database query syntax error haes occurt. This micht indicate a bug in the saftware. The last attemptit database query wis: <blockquote><tt>$1</tt></blockquote> frae athin function "<tt>$2</tt>". Database returned error "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'A database query syntax error haes occurt. The last attemptit database query wis: "$1" frae athin function "$2". Database returned error "$3: $4".',
	'directorycreateerror' => 'Culdnae mak directory "$1".',
	'difference' => '(Difference atween revisions)',
	'diff-multi' => '({{PLURAL:$1|One intermediate revision|$1 intermediate revisions}} by {{PLURAL:$2|one user|$2 users}} nae shown)',
	'datedefault' => 'Nae preference',
	'defaultns' => 'Rake in thir namespaces bi defaut:',
	'default' => 'defaut',
	'diff' => 'diff',
	'download' => 'dounlaid',
	'disambiguationspage' => 'Template:disambig',
	'doubleredirects' => 'Dooble reguidals',
	'doubleredirectstext' => 'Ilka raw hauds airtins tae the first an saicont reguidal, as weel as the first line o the saicont reguidal text, for usual giein the "rael" tairget page, that the first reguidal shuid pynt til.',
	'deadendpages' => 'Deid-end pages',
	'deletepage' => 'Delete page',
	'delete-confirm' => 'Delete "$1"',
	'delete-legend' => 'Delete',
	'deletedtext' => '"$1" haes been delete. See $2 for a record o recent deletions.',
	'dellogpage' => 'Deletion log',
	'dellogpagetext' => 'Ablo is a leet o the maist recent deletions.',
	'deletionlog' => 'deletion log',
	'deletecomment' => 'Raeson:',
	'deletereasonotherlist' => 'Ither raeson',
	'databasenotlocked' => 'The database isna lockit.',
	'delete_and_move' => 'Delete an flit',
	'delete_and_move_text' => '==Deletion caad for==

The destination airticle "[[:$1]]" aareadies exists. Div ye want tae delete it for tae mak wey for the flittin?',
	'delete_and_move_confirm' => 'Aye, delete the page',
	'delete_and_move_reason' => 'Delete for tae mak wey for flittin',
	'deletedrevision' => 'Deletit auld revision $1.',
	'deletedwhileediting' => 'Warnin: This page haes been delete syne ye stertit editin!',
	'duplicate-defaultsort' => '\'\'\'Wairnin:\'\'\' Default sort key "$2" overrides earlier default sort key "$1".',
);

$messages['sd'] = array(
	'december' => 'ڊسمبر',
	'december-gen' => 'ڊسمبر',
	'dec' => 'ڊسمبر',
	'delete' => 'ڊاھيو',
	'deletethispage' => 'هيءُ صفحو ڊاهيو',
	'disclaimers' => 'غيرجوابداريناما',
	'disclaimerpage' => 'Project:عام غيرجوابدارينامو',
	'databaseerror' => 'اعدادخاني ۾ چڪ',
	'difference' => '(مسودن درميان تفاوت)',
	'diff-multi' => '({{PLURAL:$1|هڪ وسطي مسودو|$1 وسطي مسودا}} لڪايل.)',
	'datedefault' => 'بلا ترجيحا',
	'diff' => 'تفاوت',
	'disambiguations' => 'سلجھائپ صفحا',
	'doubleredirects' => 'ٻٽا چورڻا',
	'deadendpages' => 'اڻ ڳنڍيندڙ صفحا',
	'deletepage' => 'صفحو ڊاهيو',
	'deletedtext' => '"$1" ڊهي چڪو آهي.
تازو ڊاٺل صفحن جي فهرست لاءِ $2 ڏسندا.',
	'dellogpage' => 'ڊاٺ لاگ',
	'deletecomment' => 'سبب:',
	'deleteotherreason' => 'اڃا ڪو ٻيو سبب:',
	'deletereasonotherlist' => 'ٻيو سبب',
	'delete_and_move_confirm' => 'جي ها، صفحو ڊاهيو',
	'delete_and_move_reason' => 'چورڻ جو عمل ممڪن بنائڻ لاءِ ڊاٺو ويو',
);

$messages['sdc'] = array(
	'december' => 'Naddari',
	'december-gen' => 'Naddari',
	'dec' => 'Nad',
	'delete' => 'Canzella',
	'deletethispage' => 'Canzella chistha pàgina',
	'disclaimers' => 'Avvirthènzi',
	'disclaimerpage' => 'Project:Avvirthènzi ginarari',
	'databaseerror' => 'Errori di la bancadati',
	'dberrortext' => 'Errori di sintassi i\' la prigonta inviadda a la bancadati.
Lu chi pudaria indicà la prisènzia d\'un bacu i\' lu software.
L\'ulthima interrogazioni inviadda a la bancadati è isthadda:
<blockquote><tt>$1</tt></blockquote>
riciamadda da la funzioni "<tt>$2</tt>".
MySQL à turraddu lu sighenti errori "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Errori di sintassi i\' la prigonta inviadda a la bancadati.
L\'ulthima interrogazioni inviadda a la bancadati è isthadda:
"$1"
riciamadda da la funzioni "$2".
MySQL à turraddu lu sighenti errori "$3: $4".',
	'directorycreateerror' => 'Impussìbiri crià la directory "$1".',
	'difference' => '(Diffarènzia i li ribisioni)',
	'diff-multi' => '({{PLURAL:$1|Una ribisioni di mezu nò musthradda|$1 ribisioni di mezu nò musthraddi}}.)',
	'datedefault' => 'Nisciuna prifirènzia',
	'defaultns' => 'Namespace pridifiniddi pa zirchà:',
	'default' => 'pridifiniddu',
	'diff' => 'diff',
	'destfilename' => 'Nommu di lu file di disthinazioni:',
	'download' => 'ischarriggamentu',
	'disambiguations' => 'Pàgini cu lu matessi innòmmu',
	'disambiguationspage' => 'Template:Matessi innòmmu',
	'disambiguations-text' => "Li pàgini i' la sighenti listha cuntènani cullegamenti a '''pàgini cu' lu matessi innòmmu''' e nò a la rasgiòni a chi dubaristhia fà rifirimentu.<br />So cunsidaraddi pàgini cu lu matessi innòmmu tutti chissi chi cuntènini li mudelli erencaddi in [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Rinvii doppi',
	'doubleredirectstext' => 'Inogghi v\'è una listha di li pàgini chi puntani a pàgini di rinviu. Ogna riga cunteni i cullegamenti a lu primmu e sigundu rinviu, cumenti a la disthinazioni di lu sigundu rinviu, che noimmaimmenti è la pàgina "curretta" a la quari dubia puntà puru lu primmu rinviu.',
	'deadendpages' => 'Pàgini chena iscidda',
	'deadendpagestext' => 'Li sighenti pàgini so chena cullegamenti bessu althri pàgini di {{SITENAME}}.',
	'defemailsubject' => 'Imbasciadda da {{SITENAME}}',
	'deletepage' => 'Canzella pàgina',
	'delete-confirm' => 'Canzella "$1"',
	'delete-legend' => 'Canzella',
	'deletedtext' => 'La pàgina "$1" è isthadda canzilladda. Cunsultha lu $2 pa un\'erencu di li pàgini canzilladdi da poggu tempu.',
	'dellogpage' => 'Canzilladduri',
	'dellogpagetext' => 'Inogghi so erencaddi li pàgini canzilladdi da poggu tempu.',
	'deletionlog' => 'Rigisthru di li canzilladduri',
	'deletecomment' => 'Mutibu di la canzilladdura:',
	'deleteotherreason' => 'Althra mutibazioni o mutibazioni aggiuntiba:',
	'deletereasonotherlist' => 'Althra mutibazioni',
	'deletereason-dropdown' => "*Mutibazioni più cumuni pa la canzilladdura
** Prigonta de l'autori
** Viorazioni di lu dirittu d'autori
** Vandarismu",
	'delete-edit-reasonlist' => 'Mudìfigga li mutibazioni pa la canzilladdura',
	'databasenotlocked' => 'La bancadati nò è broccadda.',
	'delete_and_move' => 'Canzella e ippustha',
	'delete_and_move_text' => '==Prigonga di canzilladdura==

La pàgina di disthinazioni "[[:$1]]" isisthi già. Vói canzillalla pa rindì pussìbiri l\'ippusthamentu?',
	'delete_and_move_confirm' => 'Emmo, sobbraischribì la pàgini',
	'delete_and_move_reason' => "Canzilladda pa rindì pussìbiri l'ippusthamentu",
	'djvu_page_error' => 'Nùmaru di pàgina DjVu ibbagliaddu',
	'djvu_no_xml' => "Impussìbiri uttinì l'XML pa lu file DjVu",
	'deletedrevision' => 'Prizzidenti ribisioni canzilladda: $1',
	'deletedwhileediting' => "Attinzioni: Chistha pàgina è isthadda canzilladda daboi ch'ài ischuminzaddu a mudìfiggarla!",
	'descending_abbrev' => 'miminan',
);

$messages['se'] = array(
	'december' => 'juovlamánnu',
	'december-gen' => 'juovlamánu',
	'dec' => 'juovlamánnu',
	'delete' => 'Sihko',
	'deletethispage' => 'Sihko dán siiddu',
	'disclaimers' => 'Friijavuohta vástideamis',
	'disclaimerpage' => 'Project:Friijavuohta vástideamis',
	'databaseerror' => 'Diehtovuođđofeaila',
	'directorycreateerror' => 'Logahallama ”$1” ráhkadeapmi ii lihkosmuvvan.',
	'deletedhist' => 'Šluhtejuvvon veršuvnnaid historjá',
	'difference' => 'Veršuvnnaid erohusat',
	'diff-multi' => '(Veršuvnnaid gaskas {{PLURAL:$1|okta rievdadus|$1 eará rievdadusa}}.)',
	'datedefault' => 'Eai válljemat',
	'diff' => 'erohus',
	'destfilename' => 'Mearrenamma',
	'download' => 'láde',
	'disambiguations' => 'Liŋkkat dárkonsiidduide',
	'doubleredirects' => 'Guovttegeardán ođđasitstivremat',
	'deadendpages' => 'Siiddut, main eai leat liŋkkat',
	'deadendpagestext' => 'Čuovvovaš siidduin eai leat liŋkkat eara siidduide dán wikis.',
	'defemailsubject' => '{{SITENAME}}-e-poasta',
	'deletepage' => 'Sihko siiddu',
	'deletedtext' => '"$1" lea sihkojuvvon.
Siiddus $2 lea listu maŋimus sihkomiin.',
	'dellogpage' => 'Sihkkunlogga',
	'dellogpagetext' => 'Vuolábealde lea logga maŋimus sihkkumiin.',
	'deletionlog' => 'sihkkunlogga',
	'deletecomment' => 'Sivva',
	'delete_and_move' => 'Sihko siiddu ja sirdde',
	'delete_and_move_confirm' => 'Sihko siiddu',
	'descending_abbrev' => 'vuolláneaddji',
);

$messages['sei'] = array(
	'december' => 'Tlamantilacuntöx',
	'december-gen' => 'Tlamantilacuntöx',
	'dec' => 'T12',
	'delete' => 'Delarom',
	'deletethispage' => 'Delarom jan páhina',
	'disclaimers' => 'Isój cacóomx',
	'disclaimerpage' => 'Project:Isoj cacóomx geniiraloj',
	'databaseerror' => 'Römjde database',
	'dberrortext' => 'Römjde syntaxde database query coccebj icmaaniit.
Jan pos-coccebj bug zo software zo iti.
Hunattemptöx database query coccebjöx:
<blockquote><tt>$1</tt></blockquote>
funccion xi "<tt>$2</tt>".
MySQL returnöx römj iti "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Römjde syntaxde database query coccebj icmaaniit.
Hunattemptöx database query coccebjöx:
"$1"
funccion xi "$2".
MySQL returnöx römj iti "$3: $4"',
	'directorycreateerror' => 'Necreatöx directoran "$1".',
	'diff-multi' => '({{PLURAL:$1|1 revicion páult|$1 revición páultíi}} necohuatlöx.)',
	'datedefault' => 'Diiquáatlaac',
	'defaultns' => 'Yahöx jan ipartuatl iti auto:',
	'default' => 'auto',
	'diff' => 'quiix',
	'destfilename' => 'Destinacion IDde ciúchan:',
	'download' => 'downloadan',
	'doubleredirects' => 'Meniitomöx daj ti zon',
	'deadendpages' => 'Páhinám huiquiix',
	'deadendpagestext' => 'Jan páhinám huiquiix linkámde jömdeman páhinám jan wiki iti.',
	'defemailsubject' => '{{SITENAME}} e-iitom',
	'deletepage' => 'Delatar páhina',
	'databasenotlocked' => 'Database zo necoccebj lockomöx.',
	'delete_and_move' => 'Delatom ö yacom',
);

$messages['sg'] = array(
	'december' => 'Kakawuka',
	'december-gen' => 'Kakawuka',
	'dec' => 'Kak',
	'delete' => 'Lungûla',
	'deletethispage' => 'Lungûla lêmbëtï sô',
	'disclaimers' => 'Zïngö-lê',
	'disclaimerpage' => 'Project:Zïngö-lê',
);

$messages['sgs'] = array(
	'december' => 'groudė',
	'december-gen' => 'Groudis',
	'dec' => 'grd',
	'delete' => 'Trintė',
	'deletethispage' => 'Trintė ton poslapė',
	'disclaimers' => 'Atsakuomībės aprėbuojims',
	'disclaimerpage' => 'Project:Atsakuomībės aprėbuojims',
	'databaseerror' => 'Doumenū bazės klaida',
	'difference' => '(Skėrtomā terp versėju)',
	'diff-multi' => '($2 {{PLURAL:$2|nauduotoja|nauduotoju|naudotoju}} $1 {{PLURAL:$1|tarpėnis keitėms nier ruodomos|tarpėnē keitėmā nier ruodomė|tarpėniu keitėmu nier ruodoma}})',
	'datedefault' => 'Juokė pasėrėnkėma',
	'defaultns' => 'Palē nutīliejėma ėiškuotė šėtuosė vardū srėtīsė:',
	'default' => 'palē nūtīliejėma',
	'diff' => 'skėrt',
	'destfilename' => 'Nuorims faila pavadinims',
	'download' => 'parsėsiūstė',
	'disambiguations' => 'Daugiareikšmiu žuodiu poslapē',
	'disambiguationspage' => 'Template:Tor daug reikšmiū',
	'doubleredirects' => 'Dvėgobė paradresavėmā',
	'doubleredirectstext' => 'Tėi paradresavėmā ruod i kėtus paradresavėma poslapius. Kuožnuo eilotē pamėnavuots pėrmasā ėr ontrasā paradresavėmā, tēpuogi ontrojė paradresavėma paskėrtis, katra paprastā ė paruod i tėkraji poslapi, i katra pėrmasā paradresavėms ė torietu ruodītė.',
	'double-redirect-fixed-move' => '[[$1]] bova parkelts, daba tas īr paradresavėms i [[$2]]',
	'deadendpages' => 'Straipsnē-aklavėitės',
	'deadendpagestext' => 'Tė poslapē netor nūruodu i kėtus poslapius šėtom pruojektė.',
	'deletedcontributions' => 'Panaikėnts nauduotuojė duovis',
	'deletedcontributions-title' => 'Ėštrėnts nauduotuojė duovis',
	'deletepage' => 'Trintė poslapi',
	'delete-confirm' => 'Ėštrėnta "$1"',
	'delete-legend' => 'Trīnėms',
	'deletedtext' => '„$1“ ėštrints.
Paskotiniu pašalinėmu istuorėjė - $2.',
	'dellogpage' => 'Pašalinėmu istuorėjė',
	'dellogpagetext' => 'Žemiau īr pateikiams paskotiniu ėštrīnimu sārašos.',
	'deletionlog' => 'pašalinėmu istuorėjė',
	'deletecomment' => 'Prīžastis:',
	'deleteotherreason' => 'Kėta/papėlduoma prižastis:',
	'deletereasonotherlist' => 'Kėta prižastis',
	'deletereason-dropdown' => '*Dažnas trīnėma prižastīs
** Autorė prašīms
** Autorėniu teisiu pažeidėms
** Vandalėzmos',
	'delete-edit-reasonlist' => 'Keistė trėnėma prīžastis',
	'delete_and_move' => 'Ėštrintė ė parkeltė',
	'delete_and_move_text' => '==Rēkalings ėštrīnims==
Paskėrties straipsnis „[[:$1]]“ jau īr. A nuorėt ana ėštrintė, kū galietomiet parvadintė?',
	'delete_and_move_confirm' => 'Tēp, trintė poslapi',
	'delete_and_move_reason' => 'Ėštrinta diel parkielima',
	'deletedrevision' => 'Ėštrinta sena versėjė $1.',
	'deletedwhileediting' => 'Diemesė: Šėts poslapis ėštrints po šėta, kumet pradiejot redagoutė!',
	'descending_abbrev' => 'mažiejontė tvarka',
);

$messages['sh'] = array(
	'december' => 'decembar',
	'december-gen' => 'decembar',
	'dec' => 'dec',
	'delete' => 'Obriši',
	'deletethispage' => 'Obriši ovu stranicu',
	'disclaimers' => 'Odricanje odgovornosti',
	'disclaimerpage' => 'Project:Uslovi korištenja, pravne napomene i odricanje odgovornosti',
	'databaseerror' => 'Greška u bazi podataka',
	'dberrortext' => 'Desila se sintaksna greška upita baze.
Ovo se desilo zbog moguće greške u softveru.
Posljednji pokušani upit je bio:
<blockquote><tt>$1</tt></blockquote>
iz funkcije "<tt>$2</tt>".
MySQL je vratio grešku "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Desila se sintaksna greška upita baze.
Posljednji pokušani upit je bio:
"$1"
iz funkcije "$2".
MySQL je vratio grešku "$3: $4".',
	'directorycreateerror' => 'Nije moguće napraviti direktorijum "$1".',
	'deletedhist' => 'Izbrisana historija',
	'difference' => '(Razlika između revizija)',
	'difference-multipage' => '(Razlika između stranica)',
	'diff-multi' => '({{PLURAL:$1|Nije prikazana jedna međuverzija|Nisu prikazane $1 međuverzije|Nije prikazano $1 međuverzija}}) od strane {{PLURAL:$2|korisnika|korisnika}}',
	'diff-multi-manyusers' => '({{PLURAL:$1|Nije prikazana jedna međuverzija|Nisu prikazane $1 međuverzije|Nije prikazano $1 međuverzija}}) od strane {{PLURAL:$2|korisnika|korisnika}}',
	'datedefault' => 'Bez preferenci',
	'defaultns' => 'Inače tražite u ovim imenskim prostorima:',
	'default' => 'standardno',
	'diff' => 'razl',
	'destfilename' => 'Ime odredišne datoteke:',
	'duplicatesoffile' => '{{PLURAL:$1|Slijedeća datoteka je dvojnik|Slijedeće $1 datoteke su dvojnici}} ove datoteke ([[Special:FileDuplicateSearch/$2|detaljnije]]):',
	'download' => 'učitaj',
	'disambiguations' => 'Stranice do višeznačnih odrednica',
	'disambiguationspage' => 'Template:Višeznačna odrednica',
	'disambiguations-text' => "Slijedeće stranice su povezane sa '''stranicom za razvrstavanje'''.
Po pravilu, one se trebaju povezati sa konkretnim člankom.<br />
Stranica se smatra stranicom za razvrstavanje, ukoliko koristi šablon koji je povezan sa spiskom [[MediaWiki:Disambiguationspage|stranica za razvrstavanje]]",
	'doubleredirects' => 'Dvostruka preusmjerenja',
	'doubleredirectstext' => 'Ova stranica prikazuje stranice koje preusmjeravaju na druga preusmjerenja.
Svaki red sadrži veze na prvo i drugo preusmjerenje, kao i na prvu liniju teksta drugog preusmjerenja, što obično daje "pravi" ciljni članak, na koji bi prvo preusmjerenje i trebalo da pokazuje.
<del>Precrtane</del> stavke su riješene.',
	'double-redirect-fixed-move' => '[[$1]] je premješten, sada je preusmjerenje na [[$2]]',
	'double-redirect-fixed-maintenance' => 'Popravak dvostrukih datoteka od [[$1]] do [[$2]].',
	'double-redirect-fixer' => 'Popravljač preusmjerenja',
	'deadendpages' => 'Stranice bez internih linkova',
	'deadendpagestext' => 'Slijedeće stranice nisu povezane s drugim stranicama na {{SITENAME}}.',
	'deletedcontributions' => 'Obrisani doprinosi korisnika',
	'deletedcontributions-title' => 'Obrisani doprinosi korisnika',
	'defemailsubject' => '{{SITENAME}} e-mail od korisnika "$1"',
	'deletepage' => 'Izbrišite stranicu',
	'delete-confirm' => 'Brisanje "$1"',
	'delete-legend' => 'Obriši',
	'deletedtext' => '"$1" je obrisan/a.
V. $2 za registar nedavnih brisanja.',
	'dellogpage' => 'Registar brisanja',
	'dellogpagetext' => 'Ispod je spisak najskorijih brisanja.',
	'deletionlog' => 'registar brisanja',
	'deletecomment' => 'Razlog:',
	'deleteotherreason' => 'Ostali/dodatni razlog/zi:',
	'deletereasonotherlist' => 'Ostali razlog/zi',
	'deletereason-dropdown' => '*Uobičajeni razlozi brisanja
** Zahtjev autora
** Kršenje autorskih prava
** Vandalizam',
	'delete-edit-reasonlist' => 'Uredi razloge brisanja',
	'delete-toobig' => 'Ova stranica ima veliku historiju promjena, preko $1 {{PLURAL:$1|revizije|revizija}}.
Brisanje takvih stranica nije dopušteno da bi se spriječilo slučajno preopterećenje servera na kojem je {{SITENAME}}.',
	'delete-warning-toobig' => 'Ova stranica ima veliku historiju izmjena, preko $1 {{PLURAL:$1|izmjene|izmjena}}.
Njeno brisanje može dovesti do opterećenja operacione baze na {{SITENAME}};
nastavite s oprezom.',
	'databasenotlocked' => 'Baza podataka nije zaključana.',
	'delete_and_move' => 'Brisanje i premještanje',
	'delete_and_move_text' => '==Brisanje neophodno==
Odredišna stranica "[[:$1]]" već postoji.
Da li je želite obrisati kako bi ste mogli izvršiti premještanje?',
	'delete_and_move_confirm' => 'Da, obriši stranicu',
	'delete_and_move_reason' => 'Obrisano da se oslobodi mjesto za premještanje iz „[[$1]]“',
	'djvu_page_error' => 'DjVu stranica je van opsega',
	'djvu_no_xml' => 'Za XML-datoteku se ne može pozvati DjVu datoteka',
	'deletedrevision' => 'Obrisana stara revizija $1',
	'days' => '{{PLURAL:$1|$1 dan|$1 dana|$1 dana}}',
	'deletedwhileediting' => "'''Upozorenje''': Ova stranica je obrisana prije nego što ste počeli uređivati!",
	'descending_abbrev' => 'opad',
	'duplicate-defaultsort' => '\'\'\'Upozorenje\'\'\': Postavljeni ključ sortiranja "$2" zamjenjuje raniji ključ "$1".',
	'dberr-header' => 'Ovaj wiki ima problem',
	'dberr-problems' => 'Žao nam je! Ova stranica ima tehničke poteškoće.',
	'dberr-again' => 'Pokušajte pričekati nekoliko minuta i ponovno učitati.',
	'dberr-info' => '(Ne može se spojiti server baze podataka: $1)',
	'dberr-usegoogle' => 'U međuvremenu pokušajte pretraživati preko Googlea.',
	'dberr-outofdate' => 'Uzmite u obzir da njihovi indeksi našeg sadržaja ne moraju uvijek biti ažurni.',
	'dberr-cachederror' => 'Sljedeći tekst je keširana kopija tražene stranice i možda nije potpuno ažurirana.',
);

$messages['shi'] = array(
	'december' => 'Dujanbir',
	'december-gen' => 'Dujanbir',
	'dec' => 'Duj',
	'delete' => 'Ḥiyd',
	'deletethispage' => 'Ḥiyd tasna yad',
	'disclaimers' => 'Ur darssuq',
	'disclaimerpage' => 'Project: Ur illa maddar illa ssuq',
	'databaseerror' => 'Laffut ɣ database',
	'dberrortext' => 'Tlla laffut ɣikli s tskert database.
Ulla mayad kis kra ntmukrist.
May igguran ittu isigal ɣ mayad igat.
<blockquote><tt>$1</tt></blockquote>
S ussiglad "<tt>$2</tt>".
laffut d yurrin ɣ database "<tt>$3: $4</tt>".',
	'directorycreateerror' => 'Ur as tufit an tgt asddaw « $1 ».',
	'deletedhist' => 'Amzruy lli ittuykkasn',
	'difference' => 'laḥna gr tamzwarut d tamǧarut',
	'diff-multi' => '({{PLURAL:$1|Gr yan usurri|$1 gr isuritn}} ura tuyfsar)',
	'datedefault' => 'Timssusmin',
	'defaultns' => 'ghd sigl gh nitaqat ad',
	'default' => 'iftiradi',
	'diff' => 'Gar',
	'deletepage' => 'Amḥiyd n tasna',
	'deletedtext' => '"<nowiki>$1</nowiki>"  ttuykkas.
Ẓṛ $2 inɣmas imggura n ma ittuykkasn',
	'deletedarticle' => 'Kkiss "[[$1]]"',
	'dellogpage' => 'Qqiyd akkas ad',
	'deletecomment' => '! Maɣ:',
	'deleteotherreason' => 'Wayyaḍ/ maf ittuykkas yaḍn',
	'deletereasonotherlist' => 'Maf ittuykkas yaḍn',
	'descending_abbrev' => 'aritgiiz',
);

$messages['si'] = array(
	'december' => 'දෙසැම්බර්',
	'december-gen' => 'දෙසැම්බර්',
	'dec' => 'දෙසැ',
	'delete' => 'මකන්න',
	'deletethispage' => 'මෙම පිටුව මකන්න',
	'disclaimers' => 'වියාචනයන්',
	'disclaimerpage' => 'Project:පොදු වියාචන',
	'databaseerror' => 'දත්ත-ගබඩා දෝෂය',
	'dberrortext' => 'දත්තසංචිත විමසුම් කාරක-රීති දෝෂයක් (syntax erro)සිදුවී ඇත.
මෙය මෘදුකාංගයේ bugදෝෂයක් හඟවන්නක් විය හැක.
අවසන් වරට උත්සාහ කල දත්ත-ගබඩා විමසුම:
"<tt>$2</tt>" ශ්‍රිතය අනුසාරයෙන්
<blockquote><tt>$1</tt></blockquote> විය.
දත්තසංචිතය විසින් වාර්තාකල දෝෂය "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'දත්ත-ගබඩා විමසුමෙහි කාරක-රීති දෝෂයක් හට ගෙන ඇත.
අවසන් වරට උත්සාහ කල දත්ත-ගබඩා විමසුම:
"$2" ශ්‍රිතය අනුසාරයෙන්,
"$1" විය
දත්ත-ගබඩාව විසින් වාර්තා කල දෝෂය "$3: $4"',
	'directorycreateerror' => '"$1" නාමාවලිය තැනීම කල නොහැකි විය.',
	'deletedhist' => 'මකාදැමූ ඉතිහාසය',
	'difference' => '(අනුවාද අතර වෙනස්කම්)',
	'difference-multipage' => 'පිටු අතර වෙනස',
	'diff-multi' => '({{PLURAL:$2|one user|$2 users}} විසින් සිදුකල {{PLURAL:$1|එක් අතරමැදි සංශෝධනයක්| අතරමැදි සංශෝධන $1 ක්}} පෙන්නුම් කර නොමැත.)',
	'diff-multi-manyusers' => '(පරිශීලකයන් $2 කට වඩා වැඩි ගණනකගේ ආසන්න පුනරීක්‍ෂණ $1ක් පෙන්වා නොමැත)',
	'datedefault' => 'අභිරුචියක් නොමැත',
	'defaultns' => 'පෙරනිමියෙන් මෙම නාමඅවකාශයන්හි ගවේෂණය කරන්න:',
	'default' => 'පෙරනිමි',
	'diff' => 'වෙනස',
	'destfilename' => 'අන්ත ගොනුනාමය:',
	'duplicatesoffile' => 'පහත {{PLURAL:$1|ගොනුව |ගොනු $1 }} මෙම ගොනුවේ {{PLURAL:$1|අනුපිටපත |අනුපිටපත් }} වේ ([[Special:FileDuplicateSearch/$2|වැඩි විස්තර සඳහා]]):',
	'download' => 'බාගතකිරීම',
	'disambiguations' => 'නිරාකරණ පිටු සඳහා සබැදෙන පිටු',
	'disambiguationspage' => 'Template:තේරුම් නිරාකරණය',
	'disambiguations-text' => "ඉදිරි පිටු '''වක්‍රෝත්තිහරණ පිටුව'''කට සබැ‍ඳේ.
ඒවා ඒ වෙනුවට අනුරූප මාතෘකාවට සබැඳිය යුතුය.<br />
යම් පිටුවක් වක්‍රෝත්තිහරණ පිටුවක් ලෙස සලකනුයේ එය [[MediaWiki:Disambiguationspage]] වෙතින් සබැඳුනු සැකිල්ලක් භාවිතා කරන්නේ නම්ය",
	'doubleredirects' => 'ද්විත්ව යළි-යොමුකිරීම්',
	'doubleredirectstext' => 'අනෙකුත් යළි-යොමුවීම් පිටුවලට යළි-යොමුවන පිටුවල ලැයිස්තුවක් මෙම පිටුවේ දැක්වේ.
එක් එක් පේළියක අඩංගු වන්නේ පළමු හා දෙවන යළි-යොමුවීම් වලට සබැඳි හා ඒ සමග පළමු යළි-යොමුව එල්ල වන්නාවූ, සාමාන්‍යයෙන් "සත්‍ය" ඉලක්ක පිටුව වන, දෙවන යළි-යොමුවේ ඉලක්කයයි.<del>කපා හැරි</del> නිවේශිතයන් පිලිබඳ ගැටළු විසඳා ඇත.',
	'double-redirect-fixed-move' => '[[$1]] ගෙන ගොස් ඇත, එය දැන් [[$2]] වෙතට යළි-යොමුවකි',
	'double-redirect-fixed-maintenance' => '[[$1]] සිට [[$2]] දක්වා ද්විත්ව යළි-යොමුකිරීමක් පිළිසකර කරමිනි.',
	'double-redirect-fixer' => 'යළි-යොමුවීම් උපස්ථායක',
	'deadendpages' => 'අපගත-සීමා පිටු',
	'deadendpagestext' => 'පහත පිටු, {{SITENAME}} හි අනෙකුත් පිටු වෙත සබැඳී නොමැත.',
	'deletedcontributions' => 'මකාදැමූ පරිශීලක දායකත්වයන්',
	'deletedcontributions-title' => 'මකාදැමූ පරිශීලක දායකත්වයන්',
	'defemailsubject' => '{{SITENAME}} පරිශීලක "$1" වෙතින් විද්‍යුත්-තැපෑල',
	'deletepage' => 'පිටුව මකා දමන්න',
	'delete-confirm' => '"$1" මකා දමන්න',
	'delete-legend' => 'මකන්න',
	'deletedtext' => '"$1" මකා දමා ඇත.
මෑත මකාදැමීම් පිළිබඳ වාර්තාවක් සඳහා $2 බලන්න.',
	'dellogpage' => 'මකාදැමුම් ලොග් සටහන',
	'dellogpagetext' => 'පහත දැක්වෙන්නේ ඉතා මෑතදී සිදු කර ඇති මකාදැමීම් ලැයිස්තුවකි.',
	'deletionlog' => 'මකා-දැමුම් ලඝු-සටහන',
	'deletecomment' => 'හේතුව:',
	'deleteotherreason' => 'අනෙකුත්/අමතර හේතුව:',
	'deletereasonotherlist' => 'අනෙකුත් හේතුව',
	'deletereason-dropdown' => '*සාමාන්‍ය මකාදැමීම් හේතූන්
** කතෘගේ ඉල්ලීම
** හිමිකම් උල්ලංඝනය
** වන්ධල්‍යය',
	'delete-edit-reasonlist' => 'සංස්කරණ මකා දැමීම් හේතු',
	'delete-toobig' => '{{PLURAL:$1|එක් සංශෝධනයකට|සංශෝධන $1 කට}} වඩා වැඩි, විශාල සංස්කරණ ඉතිහාසයක් මෙම පිටුව සතු වෙයි.
අනවධානය නිසා  {{SITENAME}}හි සිදුවිය හැකි අක්‍රමවත්වීම් වලකනු වස්, මෙවැනි පිටු මකාදැමීම පිළිබඳ සීමා තහංචි පනවා ඇත.',
	'delete-warning-toobig' => 'මෙම පිටුවට, {{PLURAL:$1|එක් සංශෝධනයකට|සංශෝධන $1 කට}} වඩා වැඩි විශාල සංස්කරණ ඉතිහාසයක් ඇත.
මෙය මකාදැමීම  {{SITENAME}} හි දත්ත-ගබඩා ක්‍රියාකාරකම් වලට අවහිරතා පැන නැංවීමට හේතු විය හැක;
පරිස්සමින් ඉදිරි කටයුතු කරන්න.',
	'databasenotlocked' => 'දත්ත-ගබඩාව අවුරා නොමැත.',
	'delete_and_move' => 'මකාදමා ගෙන යන්න',
	'delete_and_move_text' => '==මකාදැමීම අවශ්‍යව ඇත==
අන්ත පිටුව "[[:$1]]" දැනටමත් පවතියි.
එය මකාදමා ගෙනයාම සඳහා පෙත එළි කිරීමට ඔබ හට ඇවැසිද?',
	'delete_and_move_confirm' => 'ඔව්, පිටුව මකා දමන්න',
	'delete_and_move_reason' => '"[[$1]]" ගෙනයෑම සඳහා ඉඩ ලබාගැනීම සඳහා මකාදමන ලදී',
	'djvu_page_error' => 'සීමාව ඉක්මවා ගිය DjVu පිටුව',
	'djvu_no_xml' => 'XML හෝ  DjVu හෝ ගොනුව අත්කරගැනුමට නොහැකි විය',
	'deletedrevision' => 'පැරැණි සංශෝධනය $1 මකාදමන ලදි',
	'days' => '{{PLURAL:$1|$1 දවස|$1 දවස්}}',
	'deletedwhileediting' => "'''අවවාදයයි''': ඔබ විසින් මෙම පිටුව සංස්කරණය ඇරැඹි පසුව එය මකා දමන ලදි!",
	'descending_abbrev' => 'අවරෝහණ',
	'duplicate-defaultsort' => 'අවවාදයයි: "$2" පෙරනිමි සුබෙදුම් යතුර විසින් ‍පූර්ව පෙරනිමි සුබෙදුම් යතුර  වූ  "$1" අතික්‍රමණය කරයි.',
	'dberr-header' => 'මෙම විකියෙහි ගැටළුවක් පවතියි',
	'dberr-problems' => 'සමාවන්න! මෙම අඩවිය තාක්ෂණික ගැටළු අත්දකියි.',
	'dberr-again' => 'විනාඩි කිහිපයක් කල්ගතකර යළි-බාගැනුම උත්සාහ කරන්න.',
	'dberr-info' => '(දත්තගබඩා සේවාදායකය හා සම්බන්ධ වීම‍ට නොහැක: $1)',
	'dberr-usegoogle' => 'මේ අතරතුර ගූගල් ඔස්සේ ගවේෂණය කිරීමට ඔබ විසින් යත්න දැරිය හැක.',
	'dberr-outofdate' => 'අපගේ අන්තර්ගතයෙහි සූචියන් යල් පැන ගොස් තිබිය හැකි බව සටහන් කර ගන්න.',
	'dberr-cachederror' => 'මෙය ඉල්ලා ඇති පිටුවෙහි පූර්වාපේක්ෂිත සංචිත පිටුවක් වන අතර එය යාවත්කාලින නොවිය හැකි බව සලකන්න.',
);

$messages['sk'] = array(
	'december' => 'december',
	'december-gen' => 'decembra',
	'dec' => 'dec',
	'delete' => 'Vymazať',
	'deletethispage' => 'Vymazať túto stránku',
	'disclaimers' => 'Vylúčenie zodpovednosti',
	'disclaimerpage' => 'Project:Vylúčenie zodpovednosti',
	'databaseerror' => 'Chyba v databáze',
	'dberrortext' => 'Nastala syntaktická chyba v príkaze na prehľadávanie databázy.
To môže značiť chybu v softvéri.
Posledná požiadavka na databázu bola:
<blockquote><tt>$1</tt></blockquote>
z funkcie „<tt>$2</tt>“.
Databáza vrátila chybu „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Nastala syntaktická chyba pri požiadavke do databázy.
Posledná požiadavka na databázu bola:
„$1“
z funkcie „$2“.
Databáza vrátila chybu „$3: $4“.',
	'directorycreateerror' => 'Nebolo možné vytvoriť adresár „$1“.',
	'delete-hook-aborted' => 'Zmazanie zrušila prídavná funkcia (prípojný bod syntaktického analyzátora).
Neudala vysvetlenie.',
	'defaultmessagetext' => 'Predvolený text správy',
	'deletedhist' => 'Zmazaná história',
	'difference-title' => '$1: Rozdiel medzi revíziami',
	'difference-title-multipage' => '$1 a $2: Rozdiel medzi stránkami',
	'difference-multipage' => '(Rozdiel medzi stránkami)',
	'diff-multi' => '{{PLURAL:$1|Jedna medziľahlá revízia|$1 medziľahlé revízie|$1 medziľahlých revízií}} od {{PLURAL:$2|jedného používateľa|$2 používateľov}} {{PLURAL:$1|nie je zobrazená|nie sú zobrazené|nie je zobrazených}}.',
	'diff-multi-manyusers' => '({{PLURAL:$1|$1 medziľahlá revízia|$1 medziľahlé revízie|$1 medziľahlých revízií}} od viac ako {{PLURAL:$2|$2 používateľa|$2 používateľov}} {{PLURAL:$1|nie je zobrazená|nie sú zobrazené|nie je zobrazených}})',
	'datedefault' => 'štandardný',
	'defaultns' => 'Inak vyhľadávať v týchto menných priestoroch:',
	'default' => 'predvolený',
	'diff' => 'rozdiel',
	'destfilename' => 'Názov cieľového súboru:',
	'duplicatesoffile' => '{{PLURAL:$1|Nasledujúci súbor je duplikát|Nasledujúce $1 súbory sú duplikáty||Nasledujúcich $1 súborov sú duplikáty}} tohto súboru ([[Special:FileDuplicateSearch/$2|podrobnosti]]):',
	'download' => 'stiahnuť',
	'disambiguations' => 'Stránky odkazujúce na rozlišovacie stránky',
	'disambiguationspage' => 'Template:Rozlišovacia stránka',
	'disambiguations-text' => "Nasledovné stránky odkazujú na '''rozlišovaciu stránku'''.
Mali by však odkazovať priamo na príslušnú tému.<br />
Stránka sa považuje za rozlišovaciu, keď používa šablónu, na ktorú odkazuje [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dvojité presmerovania',
	'doubleredirectstext' => 'Táto stránka obsahuje zoznam stránok, ktoré presmerovávajú na iné presmerovacie stránky.
Každý riadok obsahuje odkaz na prvé a druhé presmerovanie a tiež prvý riadok z textu na ktorý odkazuje druhé presmerovanie, ktoré zvyčajne odkazuje na „skutočný“ cieľ, na ktorý má odkazovať prvé presmerovanie.
<del>Prečiarknuté</del> položky boli vyriešené.',
	'double-redirect-fixed-move' => 'Stránka [[$1]] bola presunutá, teraz je presmerovaním na [[$2]]',
	'double-redirect-fixed-maintenance' => 'Opravuje sa dvojité presmerovanie z [[$1]] na [[$2]].',
	'double-redirect-fixer' => 'Korektor presmerovaní',
	'deadendpages' => 'Slepé stránky',
	'deadendpagestext' => 'Nasledujúce stránky neodkazujú na žiadne iné stránky na {{GRAMMAR:lokál|{{SITENAME}}}}.',
	'deletedcontributions' => 'Zmazané príspevky používateľa',
	'deletedcontributions-title' => 'Zmazané príspevky používateľa',
	'defemailsubject' => 'email {{GRAMMAR:genitív|{{SITENAME}}}} od používateľa „$1“',
	'deletepage' => 'Zmazať stránku',
	'delete-confirm' => 'Zmazať „$1“',
	'delete-legend' => 'Zmazať',
	'deletedtext' => '"$1" bol zmazaný.
Na $2 nájdete zoznam posledných zmazaní.',
	'dellogpage' => 'Záznam zmazaní',
	'dellogpagetext' => 'Tu je zoznam posledných zmazaní.',
	'deletionlog' => 'záznam zmazaní',
	'deletecomment' => 'Dôvod:',
	'deleteotherreason' => 'Iný/ďalší dôvod:',
	'deletereasonotherlist' => 'Iný dôvod',
	'deletereason-dropdown' => '*Bežné dôvody zmazania
** Na žiadosť autora
** Porušenie autorských práv
** Vandalizmus',
	'delete-edit-reasonlist' => 'Upraviť dôvody zmazania',
	'delete-toobig' => 'Táto stránka má veľkú históriu úprav, viac ako $1 {{PLURAL:$1|revíziu|revízie|revízií}}. Mazanie takýchto stránok bolo obmedzené, aby sa zabránilo náhodnému poškodeniu {{GRAMMAR:genitív|{{SITENAME}}}}.',
	'delete-warning-toobig' => 'Táto stránka má veľkú históriu úprav, viac ako $1 {{PLURAL:$1|revíziu|revízie|revízií}}. Jej zmazanie by mohlo narušiť databázové operácie {{GRAMMAR:genitív|{{SITENAME}}}}; postupujte opatrne.',
	'databasenotlocked' => 'Databáza nie je zamknutá.',
	'delete_and_move' => 'Vymazať a presunúť',
	'delete_and_move_text' => '==Je potrebné zmazať stránku==

Cieľová stránka „[[:$1]]“ už existuje. Chcete ho vymazať a vytvoriť tak priestor pre presun?',
	'delete_and_move_confirm' => 'Áno, zmaž stránku',
	'delete_and_move_reason' => 'Vymazané, aby sa umožnil presun z „[[$1]]“',
	'djvu_page_error' => 'DjVu stránka mimo rozsahu',
	'djvu_no_xml' => 'Nebolo možné priniesť XML DjVu súboru',
	'deletedrevision' => 'Zmazať staré verzie $1',
	'days' => '{{PLURAL:$1|$1 deň|$1 dni|$1 dní}}',
	'deletedwhileediting' => "'''Upozornenie''': Táto stránka bola zmazaná potom ako ste začali s jej úpravami!",
	'descending_abbrev' => 'zostupne',
	'duplicate-defaultsort' => 'Upozornenie: Štandardný kláves na zoraďovanie „$2“ nahrádza starý kláves „$1“.',
	'dberr-header' => 'Táto wiki má problém',
	'dberr-problems' => 'Prepáčte! Táto stránka má práve technické problémy.',
	'dberr-again' => 'Skúste niekoľko minút počkať a potom opäť načítať stránku.',
	'dberr-info' => '(Spojenie s databázovým serverom neúspešné: $1)',
	'dberr-usegoogle' => 'Zatiaľ môžete skúsiť hľadať pomocou Google.',
	'dberr-outofdate' => 'Pamätajte, že ich indexy nemusia byť aktuálne.',
	'dberr-cachederror' => 'Toto je kópia požadovanej stránky z vyrovnávacej pamäte a nemusí byť aktuálna.',
	'duration-seconds' => '$1 {{PLURAL:$1|sekunda|sekundy|sekúnd}}',
	'duration-minutes' => '$1 {{PLURAL:$1|minúta|minúty|minút}}',
	'duration-hours' => '$1 {{PLURAL:$1|hodina|hodiny|hodín}}',
	'duration-days' => '$1 {{PLURAL:$1|deň|dni|dní}}',
	'duration-weeks' => '$1 {{PLURAL:$1|týždeň|týždne|týždňov}}',
	'duration-years' => '$1 {{PLURAL:$1|rok|roky|rokov}}',
	'duration-decades' => '$1 {{PLURAL:$1|dekáda|dekády|dekád}}',
	'duration-centuries' => '$1 {{PLURAL:$1|storočie|storočia|storočí}}',
	'duration-millennia' => '$1 {{PLURAL:$1|tisícročie|tisícročia|tisícročí}}',
);

$messages['sl'] = array(
	'december' => 'december',
	'december-gen' => 'decembra',
	'dec' => 'dec.',
	'delete' => 'Briši',
	'deletethispage' => 'Briši stran',
	'disclaimers' => 'Zanikanja odgovornosti',
	'disclaimerpage' => 'Project:Splošno zanikanje odgovornosti',
	'databaseerror' => 'Napaka zbirke podatkov',
	'dberrortext' => 'Prišlo je do napake podatkovne zbirke.
Vzrok bi lahko bil nesprejemljiv iskalni niz ali programski hrošč.
Zadnje poskušano iskanje:
<blockquote><tt>$1</tt></blockquote>
znotraj funkcije »<tt>$2</tt>«.
Podatkovna zbirka je vrnila napako »<tt>$3: $4</tt>«.',
	'dberrortextcl' => 'Pri iskanju v podatkoovni zbirki je prišlo do skladenjske napake.
Zadnje iskanje v zbirki podatkov:
»$1«
iz funkcije »$2«.
Podatkovna zbirka je vrnila napako »$3: $4«.',
	'directorycreateerror' => 'Ne morem ustvariti direktorija »$1«.',
	'deletedhist' => 'Zgodovina brisanja',
	'difference' => '(Primerjava redakcij)',
	'difference-multipage' => '(Razlika med stranmi)',
	'diff-multi' => '({{PLURAL:$1|$1 vmesna redakcija|$1 vmesni redakciji|$1 vmesne redakcije|$1 vmesnih redakcij}} {{PLURAL:$2|$2 uporabnika|$2 uporabnikov}} {{PLURAL:$1|ni prikazana|nista prikazani|niso prikazane|ni prikazanih}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|$1 vmesna redakcija|$1 vmesni redakciji|$1 vmesne redakcije|$1 vmesnih redakcij}} več kot $2 {{PLURAL:$2|uporabnika|uporabnikov}} {{PLURAL:$1|ni prikazana|nista prikazani|niso prikazane|ni prikazanih}})',
	'datedefault' => 'Kakor koli',
	'defaultns' => 'Navadno išči v naslednjih imenskih prostorih:',
	'default' => 'privzeto',
	'diff' => 'prim',
	'destfilename' => 'Ime ciljne datoteke:',
	'duplicatesoffile' => '{{PLURAL:$1|Sledeča datoteka je dvojnik|Sledeči datoteki sta dvojnika|Sledeče $1 datoteke so dvojniki|Sledečih $1 datotek so dvojniki}} te datoteke ([[Special:FileDuplicateSearch/$2|več podrobnosti]]):',
	'download' => 'prenesi',
	'disambiguations' => 'Strani s povezavami na razločitvene strani',
	'disambiguationspage' => 'Template:Razločitev',
	'disambiguations-text' => "Naslednje strani se povezujejo na '''razločitvene strani'''.
Namesto tega bi se naj povezovale na primerno temo.<br />
Stran se obravnava kot razločitvena, če uporablja predloge povezane iz [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Dvojne preusmeritve',
	'doubleredirectstext' => 'Ta stran navaja strani, ki se preusmerjajo na druge preusmeritvene strani.
Vsaka vrstica vsebuje povezavo do prve in druge preusmeritve, kakor tudi do cilja druge preusmeritve, ki je po navadi »prava« ciljna stran, na katero naj bi kazala prva preusmeritev.
<del>Prečrtani</del> vnosi so bili razrešeni.',
	'double-redirect-fixed-move' => 'Stran [[$1]] je bil premaknjen.
Sedaj je preusmeritev na [[$2]].',
	'double-redirect-fixed-maintenance' => 'Popravljanje dvojne preusmeritve z [[$1]] na [[$2]].',
	'double-redirect-fixer' => 'Popravljalec preusmeritev',
	'deadendpages' => 'Članki brez delujočih povezav',
	'deadendpagestext' => 'Spodaj navedene strani se ne povezujejo na druge članke v {{GRAMMAR:dajalnik|{{SITENAME}}}}.',
	'deletedcontributions' => 'Izbrisani uporabnikovi prispevki',
	'deletedcontributions-title' => 'Izbrisani uporabnikovi prispevki',
	'defemailsubject' => 'Elektronska pošta {{GRAMMAR:rodilnik|{{SITENAME}}}} od uporabnika »$1«',
	'deletepage' => 'Briši stran',
	'delete-confirm' => 'Brisanje »$1«',
	'delete-legend' => 'Izbriši',
	'deletedtext' => 'Stran »$1« je izbrisana.
Za zapise nedavnih brisanj glej $2.',
	'dellogpage' => 'Dnevnik brisanja',
	'dellogpagetext' => 'Spodaj je prikazan seznam nedavnih brisanj.',
	'deletionlog' => 'dnevnik brisanja',
	'deletecomment' => 'Razlog:',
	'deleteotherreason' => 'Drugi/dodatni razlogi:',
	'deletereasonotherlist' => 'Drug razlog',
	'deletereason-dropdown' => '* Pogosti razlogi za brisanje
** zahteva avtorja
** kršitev avtorskih pravic
** vandalizem',
	'delete-edit-reasonlist' => 'Uredi razloge za brisanje',
	'delete-toobig' => 'Ta stran ima obsežno zgodovino urejanja, tj. čez $1 {{PLURAL:$1|redakcijo|redakciji|redakcije|redakcij}}.
Izbris takšnih strani je bil omejen v izogib neželenim motnjam {{GRAMMAR:dative|{{SITENAME}}}}.',
	'delete-warning-toobig' => 'Ta stran ima obsežno zgodovino urejanja, tj. čez $1 {{PLURAL:$1|redakcijo|redakciji|redakcije|redakcij}}.
Njeno brisanje lahko zmoti obratovanje zbirke podatkov {{GRAMMAR:dative|{{SITENAME}}}};
nadaljujte s previdnostjo.',
	'databasenotlocked' => 'Zbirka podatkov ni zaklenjena.',
	'delete_and_move' => 'Briši in prestavi',
	'delete_and_move_text' => '==Treba bi bilo brisati==

Ciljna stran »[[:$1]]« že obstaja. Ali jo želite, da bi pripravili prostor za prestavitev, izbrisati?',
	'delete_and_move_confirm' => 'Da, izbriši stran',
	'delete_and_move_reason' => 'Izbrisano z namenom pripraviti prostor za »[[$1]]«',
	'djvu_page_error' => 'Stran DjVu je izven območja',
	'djvu_no_xml' => 'Ni mogoče pridobiti XML za datoteko DjVu',
	'deletedrevision' => 'Prejšnja redakcija $1 je izbrisana',
	'days-abbrev' => '$1 d',
	'days' => '$1 {{PLURAL:$1|dan|dneva|dnevi|dni}}',
	'deletedwhileediting' => "'''Opozorilo''': Med vašim urejanjem je bila stran izbrisana!",
	'descending_abbrev' => 'pad',
	'duplicate-defaultsort' => "'''Opozorilo:''' Privzeti ključ razvrščanja »$2« prepiše prejšnji privzeti ključ razvrščanja »$1«.",
	'dberr-header' => 'Ta wiki ima težavo',
	'dberr-problems' => 'Oprostite!
Ta stran se sooča s tehničnimi težavami.',
	'dberr-again' => 'Poskusite počakati nekaj minut in ponovno naložite stran.',
	'dberr-info' => '(Ne morem se povezati s strežnikom zbirke podatkov: $1)',
	'dberr-usegoogle' => 'V vmesnem času lahko poskusite z iskanjem preko Googla',
	'dberr-outofdate' => 'Pomnite, da so njegovi imeniki naših vsebin lahko zastareli.',
	'dberr-cachederror' => 'To je shranjena kopija zahtevane strani, ki morda ni najnovejša.',
	'discuss' => 'Razpravljaj',
);

$messages['sli'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezembers',
	'dec' => 'Dez.',
	'delete' => 'Löschen',
	'deletethispage' => 'Diese Seite läscha',
	'disclaimers' => 'Impressum',
	'disclaimerpage' => 'Project:Impressum',
	'databaseerror' => 'Fehler ei der Datenbank',
	'dberrortext' => 'Is ies a Datenbankfahler uffgetreten.
Dar Grund koan a Programmierfahler sei.
De letzte Datenbankoabfroage lautete:
<blockquote><tt>$1</tt></blockquote>
aus dar Funksjonn „<tt>$2</tt>“.
De Datenbank meldete dann Fahler „<tt>$3: $4</tt>“.',
	'dberrortextcl' => "Is goab an'n Syntaxfahler ei dar Datenbankobfroage.
De letzte Datenbankobfroage lautete: „$1“ aus dar Funksjonn „<tt>$2</tt>“.
De Datenbank meldete dann Fahler: „<tt>$3: $4</tt>“.",
	'deletedhist' => 'Geläschte Versiona',
	'difference' => '(Underschied zwischa Versiona)',
	'diff-multi' => '({{PLURAL:$1|Eine dazwischenliegende Version|$1 dazwischenliegende Versionen}} von {{PLURAL:$2|einem Benutzer|$2 Benutzern}} {{PLURAL:$1|wird|werden}} nicht angezeigt)',
	'defaultns' => 'Andernfoalls ei diesen Noamasräumen sucha:',
	'diff' => 'Unt.',
	'destfilename' => 'Zielnoame:',
	'duplicatesoffile' => 'De {{PLURAL:$1|folgende Datei ies a Duplikat|folgenda $1 Dateien sein Duplikate}} dieser Datei ([[Special:FileDuplicateSearch/$2|wettere Details]]):',
	'download' => 'Herunderloada',
	'disambiguations' => 'Begriffsklärungsseyta',
	'disambiguationspage' => 'Template:Begriffsklärung',
	'disambiguations-text' => 'De fulgenda Seita verlinka uff anne Seite zur Begriefsklärung. Se sullta stoats dassens uff de eigentlich gemeente Seite verlinka.<br />Anne Seite werd ols Begriefsklärungsseite behandelt, wenn [[MediaWiki:Disambiguationspage]] uff se verlinkt.<br />Links aus Noamasräumen waan hier ne uffgelistet.',
	'doubleredirects' => 'Doppelte Weiterleitunga',
	'doubleredirectstext' => 'Diese Liste enthält Weiterleitunga, de uff wettere Wetterleitunga verlinka.
Jede Zeile enthält Links zu dar erschta und zweeta Wetterleitung suwie doas Ziel dar zweeta Wetterleitung, welches fier gewehnlich die gewünschte Zielseyte ies, uff de bereits de erschte Wetterleitung zeiga sullte.
<del>Durchgestrichene</del> Einträge wurden bereits erledigt.',
	'double-redirect-fixed-move' => 'doppelte Wetterleitung uffgelest: [[$1]] → [[$2]]',
	'deadendpages' => 'Sackgassenseyta',
	'deadendpagestext' => 'Aus dann folgenden Seyta werd ne aus {{SITENAME}} verwiesa.',
	'deletedcontributions' => 'Geläschte Beiträge',
	'deletedcontributions-title' => 'Geläschte Beiträge',
	'deletepage' => 'Seite läscha',
	'delete-confirm' => 'Läscha vun „$1“',
	'delete-legend' => 'Läscha',
	'deletedtext' => '„$1“ wurde geläscht. Eim $2 findest du eene Liste dar letzta Läschunga.',
	'dellogpage' => 'Läsch-Logbuch',
	'dellogpagetext' => 'Dies ies doas Logbuch dar geläschta Seyta und Dateien.',
	'deletionlog' => 'Läsch-Logbuch',
	'deletecomment' => 'Begriendung:',
	'deletereason-dropdown' => '* Allgemeene Läschgrinde
** Wunsch des Autors
** Urheberrechtsverletzung
** Vandalismus',
	'delete-edit-reasonlist' => 'Läschgrinde bearbta',
	'delete-toobig' => 'Diese Seite hoot miet meh ols $1 {{PLURAL:$1|Version|Versionen}} anne siehr lange Versionsgeschichte. Doas Läscha sulcher Seita wurde eingeschränkt, im anne versehentliche Ieberlastung der Server zu verhindern.',
	'delete-warning-toobig' => 'Diese Seite hoot miet meh ols $1 {{PLURAL:$1|Version|Versionen}} anne sehr lange Versionsgeschichte. Doas Läscha koan zu Sterunga eim Datenbankbetrieb fiehrn.',
	'databasenotlocked' => 'De Datenbank ies ne gesperrt.',
	'delete_and_move' => 'Läscha und Verschieba',
	'delete_and_move_text' => '== Läschung erforderlich ==

De Seite „[[:$1]]“ existiert bereits. Mechtest du diese läscha, im de Seite verschieba zu kinna?',
	'delete_and_move_confirm' => 'Zielseyte fier de Verschiebung läscha',
	'delete_and_move_reason' => 'geläscht, im Ploatz fier Verschiebung zu macha',
	'djvu_page_error' => 'DjVu-Seite außerholb des Seitabereichs',
	'djvu_no_xml' => 'XML-Daten kinna fier de DjVu-Datei ne obgeruffa waan',
	'deletedrevision' => 'aale Version: $1',
	'deletedwhileediting' => 'Ochtiche: Diese Seite wurde geläscht, nachdem du oagefanga host se zu bearbta!
Eim [{{fullurl:{{#special:Log}}|type=delete&page={{FULLPAGENAMEE}}}} Läsch-Logbuch] fendest du den Grund fier de Läschung. Wenn du de Seite speicherst, werd se neu oagelegt.',
	'descending_abbrev' => 'oab',
	'duplicate-defaultsort' => 'Ochtiche: Dar Sortierungsschlissel „$2“ ieberschreibt dann vorher verwendeta Schlissel „$1“.',
	'dberr-header' => 'Dieses Wiki hoot a Problem',
);

$messages['sm'] = array(
	'december' => 'Tesema',
	'december-gen' => 'Tesema',
	'dec' => 'Tesema',
	'delete' => 'Tape',
);

$messages['sma'] = array(
	'december' => 'Goeve',
	'december-gen' => 'Goeve',
	'dec' => 'Goe',
	'delete' => 'Tjåegkedh',
	'disclaimers' => 'Friijavuohte vastideamis',
	'disclaimerpage' => 'Project:Bäjjesereaktah',
	'databaseerror' => 'Daatabaase båajhtode',
	'difference' => '(Joekehts gaskesne gïehtjedammeh)',
	'diff-multi' => '({{PLURAL:$1|Akte gaskese gïehtjedamme|$1 gaskese gïehtjedammeh}} vuesehte ijje.)',
	'diff' => 'joekehts',
	'disambiguations' => 'Disambirgusjovne bielieh',
	'doubleredirects' => 'Guektien-gïerth bïjre-dirisjovneh',
	'deadendpages' => 'Tsuvvedh bielieh',
	'defemailsubject' => '{{SITENAME}} e-påaste',
	'deletepage' => 'Tjåegkedh bielie',
	'deletedtext' => '"$1" lea sihkojuvvon.
Vuajna $2 ihke galtege bïjre männgan sihkojuvvonh.',
	'dellogpage' => 'Sihkkun logge',
	'deletecomment' => 'Gaavhtan ihke sihkkuma',
	'deleteotherreason' => 'Jeatjebh/ehkstre gaavhtan:',
	'deletereasonotherlist' => 'Jeatjebh gaavhtan',
	'databasenotlocked' => 'Daatabaase lea ijje tjuevtedh.',
);

$messages['sn'] = array(
	'december' => 'Zvita',
	'december-gen' => 'Zvita',
	'delete' => 'Bharanura',
	'disclaimers' => 'Matandanyadzi',
);

$messages['so'] = array(
	'december' => 'Diseembar',
	'december-gen' => 'Diseembar',
	'dec' => 'Dis',
	'delete' => 'Tirtir',
	'deletethispage' => 'Tirtir bogaan',
	'databaseerror' => 'Qalad ka dhacay database;ka',
	'datedefault' => "Ma'jiro dooq",
	'deadendpages' => 'Boggaga aanan la daba joogin',
	'deadendpagestext' => 'Boggogaan linki lamalaha boggaga kale ee wikiga .',
);

$messages['sq'] = array(
	'december' => 'dhjetor',
	'december-gen' => 'dhjetor',
	'dec' => 'Dhje',
	'delete' => 'Grise',
	'deletethispage' => 'Grise këtë faqe',
	'disclaimers' => 'Shfajësimet',
	'disclaimerpage' => 'Project:Shfajësimet e përgjithshme',
	'databaseerror' => 'Gabim në databazë',
	'dberrortext' => 'Ka ndodhur një gabim me pyetjen e regjistrit.
Kjo mund të ndodhi n.q.s. pyetja nuk është e vlehshme,
ose mund të jetë një yçkël e softuerit.
Pyetja e fundit që i keni bërë regjistrit ishte:
<blockquote><tt>$1</tt></blockquote>
nga funksioni "<tt>$2</tt>".
MySQL kthehu gabimin "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ka ndodhur një gabim me sintaksën query në databazë.
Query e fundit që i keni bërë regjistrit ishte:
"$1"
nga funksioni "$2".
MySQL kthehu gabimin "$3: $4".',
	'directorycreateerror' => 'I pamundur krijimi i direktorisë "$1".',
	'deletedhist' => 'Historiku i grisjeve',
	'difference' => '(Ndryshime midis versioneve)',
	'difference-multipage' => '(Ndryshimi midis faqeve)',
	'diff-multi' => '({{PLURAL:$1|Një version i ndërmjetshëm|$1 versione të ndërmjetshme}} nga {{PLURAL:$2|një përdorues|$2 përdorues}} i/të pashfaqur)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Një versioni i ndërmjetshëm|$1 versione të ndërmjetshme}} nga më shumë se $2 {{PLURAL:$2|përdorues|përdorues}} i/të pashfaqur)',
	'datedefault' => 'Parazgjedhje',
	'defaultns' => 'Kërko automatikisht vetëm në këto hapësira:',
	'default' => 'parazgjedhje',
	'diff' => 'ndrysh',
	'destfilename' => 'Emri mbas dhënies:',
	'duplicatesoffile' => 'Në vijim {{PLURAL:$1|skeda është identike|$1 janë idnetike}} me këtë skedë
([[Special:FileDuplicateSearch/$2|më shumë detaje]]):',
	'download' => 'shkarkim',
	'disambiguations' => 'Faqet që lidhen te faqet kthjelluese',
	'disambiguationspage' => 'Template:Kthjellim',
	'disambiguations-text' => "Faqet e mëposhtme lidhen tek një '''faqe kthjelluese'''.
Ato duhet të kenë lidhje të drejtpërdrejtë tek artikujt e nevojshëm.<br />
Një faqe trajtohet si faqe kthjelluese nëse përdor stampat e lidhura nga [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Përcjellime dopjo',
	'doubleredirectstext' => "Kjo faqe liston faqet përcjellëse tek faqet e tjera përcjellëse.
Secili rresht përmban lidhjet tek përcjellimi i parë dhe përcjellimi i dytë, gjithashtu synimin e përcjellimit të dytë, që është zakonisht faqja synuese '''e vërtetë''', që faqja w parë duhej të ishte përcjellëse e kësaj faqeje.
<del>Kalimet nga</del> hyrjet janë zgjidhur.",
	'double-redirect-fixed-move' => '[[$1]] u zhvendos, tani është gjendet në [[$2]]',
	'double-redirect-fixed-maintenance' => 'Duke zgjidhur përcjellimin e dyfishtë nga [[$1]] tek [[$2]].',
	'double-redirect-fixer' => 'Rregullues zhvendosjesh',
	'deadendpages' => 'Artikuj pa rrugëdalje',
	'deadendpagestext' => 'Artikujt në vijim nuk kanë asnjë lidhje me artikuj e tjerë në këtë wiki.',
	'deletedcontributions' => 'Kontribute të grisura',
	'deletedcontributions-title' => 'Kontribute të grisura',
	'defemailsubject' => '{{SITENAME}} posta elektronike nga përdoruesi "$1"',
	'deletepage' => 'Grise faqen',
	'delete-confirm' => 'Grise "$1"',
	'delete-legend' => 'Grise',
	'deletedtext' => '"$1" është grisur nga regjistri. Shikoni $2 për një pasqyrë të grisjeve së fundmi.',
	'dellogpage' => 'Regjistri i grisjeve',
	'dellogpagetext' => 'Më poshtë është një listë e grisjeve më të fundit.',
	'deletionlog' => 'regjistrin e grisjeve',
	'deletecomment' => 'Arsyeja:',
	'deleteotherreason' => 'Arsye tjetër:',
	'deletereasonotherlist' => 'Arsyeja tjetër',
	'deletereason-dropdown' => '*Arsye për grisje:
** Pa të drejtë autori
** Kërkesë nga autori
** Vandalizëm',
	'delete-edit-reasonlist' => 'Ndrysho arsyet e grisjes',
	'delete-toobig' => 'Kjo faqe ka një historik të madh redaktimesh, më shumë se $1 {{PLURAL:$1|version|versione}}.
Grisja e faqeve të tilla ka qenë kufizuar për të parandaluar përçarjen aksidentale të {{SITENAME}}.',
	'delete-warning-toobig' => 'Kjo faqe ka një historik të madh redaktimesh, më shumë se $1 {{PLURAL:$1|version|versione}}.
Grisja e saj mund të ndërpresë operacionet e bazës së të dhënave të {{SITENAME}};
vazhdoni me kujdes.',
	'databasenotlocked' => 'Regjistri nuk është bllokuar.',
	'delete_and_move' => 'Grise dhe zhvendose',
	'delete_and_move_text' => '==Nevojitet grisje==

Faqja "[[:$1]]" ekziston, dëshironi ta grisni për të mundësuar zhvendosjen?',
	'delete_and_move_confirm' => 'Po, grise faqen',
	'delete_and_move_reason' => 'U gris për të liruar vendin për përcjellim të "[[$1]]"',
	'djvu_page_error' => 'Faqja DjVu jashtë renditjes',
	'djvu_no_xml' => 'Nuk mund të gjendet XML për skedën DjVu',
	'deletedrevision' => 'Gris versionin e vjetër $1',
	'days' => '{{PLURAL:$1|$1 ditë|$1 ditë}}',
	'deletedwhileediting' => 'Kujdes! Kjo faqe është grisur pasi keni filluar redaktimin!',
	'descending_abbrev' => 'zbritje',
	'duplicate-defaultsort' => '\'\'\'Kujdes:\'\'\' Renditja kryesore e çelësit "$2" refuzon renditjen e mëparshme kryesore të çelësit "$1".',
	'dberr-header' => 'Kjo wiki ka një problem',
	'dberr-problems' => 'Na vjen keq!
Kjo faqe është duke përjetuar vështirësi teknike.',
	'dberr-again' => 'Pritni disa minuta dhe provoni të ringarkoni faqen.',
	'dberr-info' => '(Nuk mund të lidhet me serverin bazë e të dhënave : $1)',
	'dberr-usegoogle' => 'Ju mund të provoni të kërkoni përmes Googles në ndërkohë.',
	'dberr-outofdate' => 'Vini re se indekset e tyre të përmbajtjes tona mund të jetë e vjetëruar.',
	'dberr-cachederror' => 'Kjo është një kopje e faqes së kërkuar dhe mund të jetë e vjetëruar.',
);

$messages['sr'] = array(
	'december' => 'dhjetor',
	'december-gen' => 'dhjetor',
	'dec' => 'Dhje',
	'delete' => 'Grise',
	'deletethispage' => 'Grise këtë faqe',
	'disclaimers' => 'Shfajësimet',
	'disclaimerpage' => 'Project:Shfajësimet e përgjithshme',
	'databaseerror' => 'Gabim në databazë',
	'dberrortext' => 'Ka ndodhur një gabim me pyetjen e regjistrit.
Kjo mund të ndodhi n.q.s. pyetja nuk është e vlehshme,
ose mund të jetë një yçkël e softuerit.
Pyetja e fundit që i keni bërë regjistrit ishte:
<blockquote><tt>$1</tt></blockquote>
nga funksioni "<tt>$2</tt>".
MySQL kthehu gabimin "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Ka ndodhur një gabim me sintaksën query në databazë.
Query e fundit që i keni bërë regjistrit ishte:
"$1"
nga funksioni "$2".
MySQL kthehu gabimin "$3: $4".',
	'directorycreateerror' => 'I pamundur krijimi i direktorisë "$1".',
	'deletedhist' => 'Historiku i grisjeve',
	'difference' => '(Ndryshime midis versioneve)',
	'difference-multipage' => '(Ndryshimi midis faqeve)',
	'diff-multi' => '({{PLURAL:$1|Një version i ndërmjetshëm|$1 versione të ndërmjetshme}} nga {{PLURAL:$2|një përdorues|$2 përdorues}} i/të pashfaqur)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Një versioni i ndërmjetshëm|$1 versione të ndërmjetshme}} nga më shumë se $2 {{PLURAL:$2|përdorues|përdorues}} i/të pashfaqur)',
	'datedefault' => 'Parazgjedhje',
	'defaultns' => 'Kërko automatikisht vetëm në këto hapësira:',
	'default' => 'parazgjedhje',
	'diff' => 'ndrysh',
	'destfilename' => 'Emri mbas dhënies:',
	'duplicatesoffile' => 'Në vijim {{PLURAL:$1|skeda është identike|$1 janë idnetike}} me këtë skedë
([[Special:FileDuplicateSearch/$2|më shumë detaje]]):',
	'download' => 'shkarkim',
	'disambiguations' => 'Faqet që lidhen te faqet kthjelluese',
	'disambiguationspage' => 'Template:Kthjellim',
	'disambiguations-text' => "Faqet e mëposhtme lidhen tek një '''faqe kthjelluese'''.
Ato duhet të kenë lidhje të drejtpërdrejtë tek artikujt e nevojshëm.<br />
Një faqe trajtohet si faqe kthjelluese nëse përdor stampat e lidhura nga [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Përcjellime dopjo',
	'doubleredirectstext' => "Kjo faqe liston faqet përcjellëse tek faqet e tjera përcjellëse.
Secili rresht përmban lidhjet tek përcjellimi i parë dhe përcjellimi i dytë, gjithashtu synimin e përcjellimit të dytë, që është zakonisht faqja synuese '''e vërtetë''', që faqja w parë duhej të ishte përcjellëse e kësaj faqeje.
<del>Kalimet nga</del> hyrjet janë zgjidhur.",
	'double-redirect-fixed-move' => '[[$1]] u zhvendos, tani është gjendet në [[$2]]',
	'double-redirect-fixed-maintenance' => 'Duke zgjidhur përcjellimin e dyfishtë nga [[$1]] tek [[$2]].',
	'double-redirect-fixer' => 'Rregullues zhvendosjesh',
	'deadendpages' => 'Artikuj pa rrugëdalje',
	'deadendpagestext' => 'Artikujt në vijim nuk kanë asnjë lidhje me artikuj e tjerë në këtë wiki.',
	'deletedcontributions' => 'Kontribute të grisura',
	'deletedcontributions-title' => 'Kontribute të grisura',
	'defemailsubject' => '{{SITENAME}} posta elektronike nga përdoruesi "$1"',
	'deletepage' => 'Grise faqen',
	'delete-confirm' => 'Grise "$1"',
	'delete-legend' => 'Grise',
	'deletedtext' => '"$1" është grisur nga regjistri. Shikoni $2 për një pasqyrë të grisjeve së fundmi.',
	'dellogpage' => 'Regjistri i grisjeve',
	'dellogpagetext' => 'Më poshtë është një listë e grisjeve më të fundit.',
	'deletionlog' => 'regjistrin e grisjeve',
	'deletecomment' => 'Arsyeja:',
	'deleteotherreason' => 'Arsye tjetër:',
	'deletereasonotherlist' => 'Arsyeja tjetër',
	'deletereason-dropdown' => '*Arsye për grisje:
** Pa të drejtë autori
** Kërkesë nga autori
** Vandalizëm',
	'delete-edit-reasonlist' => 'Ndrysho arsyet e grisjes',
	'delete-toobig' => 'Kjo faqe ka një historik të madh redaktimesh, më shumë se $1 {{PLURAL:$1|version|versione}}.
Grisja e faqeve të tilla ka qenë kufizuar për të parandaluar përçarjen aksidentale të {{SITENAME}}.',
	'delete-warning-toobig' => 'Kjo faqe ka një historik të madh redaktimesh, më shumë se $1 {{PLURAL:$1|version|versione}}.
Grisja e saj mund të ndërpresë operacionet e bazës së të dhënave të {{SITENAME}};
vazhdoni me kujdes.',
	'databasenotlocked' => 'Regjistri nuk është bllokuar.',
	'delete_and_move' => 'Grise dhe zhvendose',
	'delete_and_move_text' => '==Nevojitet grisje==

Faqja "[[:$1]]" ekziston, dëshironi ta grisni për të mundësuar zhvendosjen?',
	'delete_and_move_confirm' => 'Po, grise faqen',
	'delete_and_move_reason' => 'U gris për të liruar vendin për përcjellim të "[[$1]]"',
	'djvu_page_error' => 'Faqja DjVu jashtë renditjes',
	'djvu_no_xml' => 'Nuk mund të gjendet XML për skedën DjVu',
	'deletedrevision' => 'Gris versionin e vjetër $1',
	'days' => '{{PLURAL:$1|$1 ditë|$1 ditë}}',
	'deletedwhileediting' => 'Kujdes! Kjo faqe është grisur pasi keni filluar redaktimin!',
	'descending_abbrev' => 'zbritje',
	'duplicate-defaultsort' => '\'\'\'Kujdes:\'\'\' Renditja kryesore e çelësit "$2" refuzon renditjen e mëparshme kryesore të çelësit "$1".',
	'dberr-header' => 'Kjo wiki ka një problem',
	'dberr-problems' => 'Na vjen keq!
Kjo faqe është duke përjetuar vështirësi teknike.',
	'dberr-again' => 'Pritni disa minuta dhe provoni të ringarkoni faqen.',
	'dberr-info' => '(Nuk mund të lidhet me serverin bazë e të dhënave : $1)',
	'dberr-usegoogle' => 'Ju mund të provoni të kërkoni përmes Googles në ndërkohë.',
	'dberr-outofdate' => 'Vini re se indekset e tyre të përmbajtjes tona mund të jetë e vjetëruar.',
	'dberr-cachederror' => 'Kjo është një kopje e faqes së kërkuar dhe mund të jetë e vjetëruar.',
	'discuss' => 'Diskutujte',
);

$messages['sr-ec'] = array(
	'december' => 'децембар',
	'december-gen' => 'децембра',
	'dec' => 'дец',
	'delete' => 'Обриши',
	'deletethispage' => 'Обриши ову страницу',
	'disclaimers' => 'Одрицање одговорности',
	'disclaimerpage' => 'Project:Одрицање одговорности',
	'databaseerror' => 'Грешка у бази података',
	'dberrortext' => 'Дошло је до синтаксне грешке у бази.
Можда се ради о грешци у софтверу.
Последњи покушај упита је гласио:
<blockquote><tt>$1</tt></blockquote>
унутар функције „<tt>$2</tt>“.
База података је пријавила грешку „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Дошло је до синтаксне грешке у бази.
Последњи покушај упита је гласио:
„$1“
унутар функције „$2“.
База података је пријавила грешку „$3: $4“',
	'directorycreateerror' => 'Не могу да направим фасциклу „$1“.',
	'deletedhist' => 'Обрисана историја',
	'difference' => '(разлике између измена)',
	'difference-multipage' => '(разлике између страница)',
	'diff-multi' => '({{PLURAL:$1|није приказана међуизмена|нису приказане $1 међуизмене|није приказано $1 међуизмена}} {{PLURAL:$2|једног|$2|$2}} корисника)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Није приказана међуизмена|Нису приказане $1 међуизмене|Није приказано $1 међуизмена}} од више од $2 корисника)',
	'datedefault' => 'Свеједно',
	'defaultns' => 'Ако није наведено другачије, тражи у овим именским просторима:',
	'default' => 'подразумевано',
	'diff' => 'разл',
	'destfilename' => 'Назив:',
	'duplicatesoffile' => '{{PLURAL:$1|Следећа датотека је дупликат|Следеће $1 датотеке су дупликати|Следећих $1 датотека су дупликати}} ове датотеке ([[Special:FileDuplicateSearch/$2|детаљније]]):',
	'download' => 'преузми',
	'disambiguations' => 'Странице до вишезначних одредница',
	'disambiguationspage' => 'Template:Вишезначна одредница',
	'disambiguations-text' => "Следеће странице су повезане с '''вишезначном одредницом'''.
Оне би требало бити упућене ка одговарајућем чланку.
Страница се сматра вишезначном одредницом ако користи шаблон који је повезан са списком [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Двострука преусмерења',
	'doubleredirectstext' => 'Ова страница приказује странице које преусмеравају на друга преусмерења.
Сваки ред садржи везе према првом и другом преусмерењу, као и одредишну страницу другог преусмерења која је обично „прави“ чланак на кога прво преусмерење треба да упућује.
<del>Прецртани</del> уноси су већ решени.',
	'double-redirect-fixed-move' => '[[$1]] је премештен.
Сада је преусмерење на [[$2]].',
	'double-redirect-fixed-maintenance' => 'Исправљање двоструких преусмерења из [[$1]] у [[$2]].',
	'double-redirect-fixer' => 'Исправљач преусмерења',
	'deadendpages' => 'Странице без унутрашњих веза',
	'deadendpagestext' => 'Следеће странице немају везе до других страница на овом викију.',
	'deletedcontributions' => 'Обрисани кориснички доприноси',
	'deletedcontributions-title' => 'Обрисани кориснички доприноси',
	'defemailsubject' => '{{SITENAME}} е-адреса {{GENDER:$1|корисника|кориснице|корисника}} $1',
	'deletepage' => 'Обриши страницу',
	'delete-confirm' => 'Брисање странице „$1“',
	'delete-legend' => 'Обриши',
	'deletedtext' => "Страница „$1“ је обрисана.
Погледајте ''$2'' за више детаља.",
	'dellogpage' => 'Дневник брисања',
	'dellogpagetext' => 'Испод је списак последњих брисања.',
	'deletionlog' => 'историја брисања',
	'deletecomment' => 'Разлог:',
	'deleteotherreason' => 'Други/додатни разлог:',
	'deletereasonotherlist' => 'Други разлог',
	'deletereason-dropdown' => '*Најчешћи разлози за брисање
** Захтев аутора
** Кршење ауторских права
** Вандализам',
	'delete-edit-reasonlist' => 'Уреди разлоге брисања',
	'delete-toobig' => 'Ова страница има велику историју, преко $1 {{PLURAL:$1|измене|измене|измена}}.
Брисање таквих страница је ограничено да би се спречило случајно оптерећење сервера.',
	'delete-warning-toobig' => 'Ова страница има велику историју, преко $1 {{PLURAL:$1|измене|изменe|измена}}.
Њено брисање може пореметити базу података, стога поступајте с опрезом.',
	'databasenotlocked' => 'База није закључана.',
	'delete_and_move' => 'Обриши и премести',
	'delete_and_move_text' => '== Потребно брисање ==

Одредишна страница „[[:$1]]“ већ постоји.
Желите ли да је обришете да бисте ослободили место за преусмерење?',
	'delete_and_move_confirm' => 'Да, обриши страницу',
	'delete_and_move_reason' => 'Обрисано да се ослободи место за премештање из „[[$1]]“',
	'djvu_page_error' => 'DjVu страница је недоступна',
	'djvu_no_xml' => 'Не могу да преузмем XML за датотеку DjVu.',
	'deletedrevision' => 'Обрисана стара измена $1.',
	'days-abbrev' => '$1 д',
	'days' => '{{PLURAL:$1|$1 дан|$1 дана|$1 дана}}',
	'deletedwhileediting' => "'''Упозорење''': ова страница је обрисана након што сте почели с уређивањем!",
	'descending_abbrev' => 'опад.',
	'duplicate-defaultsort' => "'''Упозорење:''' подразумевани кључ сврставања „$2“ мења некадашњи кључ „$1“.",
	'dberr-header' => 'Овај вики не ради како треба',
	'dberr-problems' => 'Дошло је до техничких проблема.',
	'dberr-again' => 'Сачекајте неколико минута и поново учитајте страницу.',
	'dberr-info' => '(не могу да се повежем са сервером базе: $1)',
	'dberr-usegoogle' => 'У међувремену, покушајте да претражите помоћу Гугла.',
	'dberr-outofdate' => 'Имајте на уму да њихови примерци нашег садржаја могу бити застарели.',
	'dberr-cachederror' => 'Ово је привремено меморисан примерак стране који можда није ажуран.',
);

$messages['sr-el'] = array(
	'december' => 'decembar',
	'december-gen' => 'decembra',
	'dec' => 'dec',
	'delete' => 'obriši',
	'deletethispage' => 'Obriši ovu stranicu',
	'disclaimers' => 'Odricanje odgovornosti',
	'disclaimerpage' => 'Project:Odricanje odgovornosti',
	'databaseerror' => 'Greška u bazi',
	'dberrortext' => 'Došlo je do sintaksne greške u bazi.
Ovo može da označi bag u softveru.
Poslednji poslati upit bazi bio je:
<blockquote><tt>$1</tt></blockquote>
unutar funkcije "<tt>$2</tt>".
Baza podataka je vratila grešku "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Došlo je do sintaksne greške u bazi.
Poslednji poslati upit bazi bio je:
"$1"
unutar funkcije "$2".
Baza podataka je vratila grešku "$3: $4"',
	'directorycreateerror' => 'Ne mogu da napravim direktorijum "$1".',
	'deletedhist' => 'Obrisana istorija',
	'difference' => '(Razlika između revizija)',
	'diff-multi' => '({{PLURAL:$1|Jedna revizija nije prikazana|$1 revizije nisu prikazane|$1 revizija nije prikazano}}.)',
	'datedefault' => 'Nije bitno',
	'defaultns' => 'U suprotnom, traži u ovim imenskim prostorima:',
	'default' => 'standard',
	'diff' => 'razl',
	'destfilename' => 'Ciljano ime fajla:',
	'duplicatesoffile' => 'Sledeći {{PLURAL:$1|fajl je duplikat|$1 fajla su duplikati|$1 fajlova su duplikati}} ovog fajla ([[Special:FileDuplicateSearch/$2|više detalja]]):',
	'download' => 'Preuzmi',
	'disambiguations' => 'Stranice za višeznačne odrednice',
	'disambiguationspage' => '{{ns:template}}:Višeznačna odrednica',
	'disambiguations-text' => "Sledeće stranice imaju veze ka '''višeznačnim odrednicama'''. Potrebno je da upućuju na odgovarajući članak.

Stranica se smatra višeznačnom odrednicom ako koristi šablon koji je upućen sa stranice [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Dvostruka preusmerenja',
	'doubleredirectstext' => 'Ova strana pokazuje spisak strana koje preusmeravaju na druge strane preusmerenja.
Svaki red sadrži veze prema prvom i drugom redirektu, kao i ciljanu stranu drugog redirekta, koja je obično „pravi“ članak, na koga prvo preusmerenje treba da pokazuje.
<s>Precrtani unosi</s> su već rešeni.',
	'double-redirect-fixed-move' => '[[$1]] je premešten, sada je preusmerenje na [[$2]]',
	'double-redirect-fixer' => 'Popravljač preusmerenja',
	'deadendpages' => 'Stranice bez unutrašnjih veza',
	'deadendpagestext' => 'Sledeće stranice ne vežu na druge stranice na ovom vikiju.',
	'deletedcontributions' => 'Obrisane izmene',
	'deletedcontributions-title' => 'Obrisane izmene',
	'defemailsubject' => '{{SITENAME}} e-pošta',
	'deletepage' => 'Obriši stranicu',
	'delete-confirm' => 'Obriši „$1“',
	'delete-legend' => 'Obriši',
	'deletedtext' => 'Članak "<nowiki>$1</nowiki>" je obrisan.
Pogledajte $2 za zapis o skorašnjim brisanjima.',
	'deletedarticle' => 'je obrisao „[[$1]]“',
	'dellogpage' => 'istorija brisanja',
	'dellogpagetext' => 'Ispod je spisak najskorijih brisanja.',
	'deletionlog' => 'istorija brisanja',
	'deletecomment' => 'Razlog:',
	'deleteotherreason' => 'Drugi/dodatni razlog:',
	'deletereasonotherlist' => 'Drugi razlog',
	'deletereason-dropdown' => '*Najčešći razlozi brisanja
** Zahtev autora
** Kršenje autorskih prava
** Vandalizam',
	'delete-edit-reasonlist' => 'Uredi razloge za brisanje',
	'delete-toobig' => 'Ova stranica ima veliku istoriju stranice, preko $1 {{PLURAL:$1|revizije|revizije|revizija}}.
Brisanje takvih stranica je zabranjeno radi preventive od slučajnog oštećenja sajta.',
	'delete-warning-toobig' => 'Ova strana ima veliku istoriju izmena, preko $1 {{PLURAL:$1|izmene|izmena}}.
Njeno brisanje bi moglo da omete operacije and bazom {{SITENAME}};
produžite oprezno.',
	'databasenotlocked' => 'Baza podataka nije zaključana.',
	'delete_and_move' => 'Obriši i premesti',
	'delete_and_move_text' => '==Potrebno brisanje==

Ciljani članak "[[:$1]]" već postoji. Da li želite da ga obrišete da biste napravili mesto za premeštanje?',
	'delete_and_move_confirm' => 'Da, obriši stranicu',
	'delete_and_move_reason' => 'Obrisano kako bi se napravilo mesto za premeštanje',
	'djvu_page_error' => 'DjVu strana je van opsega.',
	'djvu_no_xml' => 'Ne mogu preuzeti XML za DjVu fajl.',
	'deletedrevision' => 'Obrisana stara revizija $1',
	'deletedwhileediting' => "'''Upozorenje''': Ova stranica je obrisana nakon što ste počeli uređivanje!",
	'descending_abbrev' => 'opad',
	'duplicate-defaultsort' => "'''Upozorenje:''' Podrazumevani ključ sortiranja „$2“ prepisuje ranije podrazumevani ključ sortiranja „$1“.",
	'dberr-header' => 'Ovaj viki ima problem',
	'dberr-problems' => 'Žao nam je! Ovaj sajt ima tehničkih poteškoća.',
	'dberr-again' => 'Sačekajte nekoliko minuta pre nego što ponovo učitate stranicu.',
	'dberr-info' => '(Server baze podataka ne može da se kontaktira: $1)',
	'dberr-usegoogle' => 'U međuvremenu, pokušajte da pretražite pomoću Gugla.',
	'dberr-outofdate' => 'Primetite da Guglov keš našeg sadržaja može biti neažuran.',
	'dberr-cachederror' => 'Ovo je keširana kopija zahtevane strane, i možda nije ažurna.',
);

$messages['srn'] = array(
	'december' => 'fostwarfu mun',
	'december-gen' => 'fostwarfu mun',
	'dec' => 'twa',
	'delete' => 'Puru',
	'deletethispage' => 'Puru a papira disi',
	'disclaimers' => 'Disclaimers',
	'disclaimerpage' => 'Project:Disclaimer gi ala',
	'databaseerror' => 'Database fowtu',
	'directorycreateerror' => 'No ben man meki a map “$1”.',
	'difference' => '(A difrenti fu den kenki)',
	'diff-multi' => '(No e sori {{PLURAL:$1|wan versi|$1 versi}} na mindrisey.)',
	'datedefault' => 'No wana',
	'defaultns' => 'Soma ini disi nenpreki suku:',
	'default' => 'soma',
	'diff' => 'kenki',
	'download' => 'Dawnloti',
	'disambiguations' => 'Seni doro papira',
	'doubleredirects' => 'Seni doro tu leisi',
	'doubleredirectstext' => 'Disi rei abi peprewoysi dy stir na trawan stir. Ies rei abi skaki na a foswan nanga a fostu stirpapira nanga wan skaki na a duli fu a fosty stirpapira. Pasa den ten ben a bakaseywan papira a tru duli.',
	'deadendpages' => 'Papira sondro miti',
	'deadendpagestext' => 'Den ondroben peprewoysi abi no skaki na trawan peprewoysi ini {{SITENAME}}.',
	'deletedcontributions' => 'Trowe kenki fu masyin',
	'deletedcontributions-title' => 'Trowe kenki fu masyin',
	'defemailsubject' => 'E-mail fu {{SITENAME}}',
	'deletepage' => 'Disi papira trowe',
	'deletedtext' => '"$1" ben e trowe. Si a $2 fu wan sibuku fu bakaseywan trowe.',
	'dellogpage' => 'Log buku fu puru',
	'deletecomment' => 'Yesikrari:',
	'deleteotherreason' => 'Trawan/okwan yesikrari:',
	'deletereasonotherlist' => 'Trawan yesikrari',
	'descending_abbrev' => 'afo.',
);

$messages['ss'] = array(
	'december' => 'iNgongoni',
	'december-gen' => 'iNgongoni',
	'dec' => 'iNgo',
	'delete' => 'Sula',
	'deletethispage' => 'Sula lelikhasi',
);

$messages['st'] = array(
	'december' => 'Tshitwe',
	'dec' => 'Tshitwe',
	'download' => 'Jarolla',
);

$messages['stq'] = array(
	'december' => 'Dezember',
	'december-gen' => 'Dezember',
	'dec' => 'Dez',
	'delete' => 'Läskje',
	'deletethispage' => 'Disse Siede läskje',
	'disclaimers' => 'Begriepskläärenge',
	'disclaimerpage' => 'Project:Siede tou Begriepskläärenge',
	'databaseerror' => 'Failer in ju Doatenboank',
	'dberrortext' => 'Der is n Doatenboankfailer aptreeden.
Die Gruund kon n Programmierfailer weese.
Ju lääste Doatenboankoufroage lutte:
<blockquote><tt>$1</tt></blockquote>
uut de Funktion "<tt>$2</tt>".
Die Doatenboank mäldede dän Failer "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Dät roate n Syntaxfailer in ju Doatenboankoufroage.
Ju lääste Doatenboankoufroage lutte: „$1“ uut ju Funktion „<tt>$2</tt>“.
Die Doatenboank mäldede dän Failer: „<tt>$3: $4</tt>“.',
	'directorycreateerror' => 'Dät Ferteeknis „$1“ kuude nit anlaid wäide.',
	'deletedhist' => 'Läskede Versione',
	'difference' => '(Unnerskeed twiske Versione)',
	'difference-multipage' => '(Unnerskeed twiske Sieden)',
	'diff-multi' => ' ({{PLURAL:$1|Ne deertwiske lääsende Version|$1 deertwiske lääsende Versione}} fon {{PLURAL:$2|n Benutser|$2 Benutsere}} {{PLURAL:$1|wäd|wäide}} nit wiesd)',
	'diff-multi-manyusers' => ' ({{PLURAL:$1|Ne deertwiske lääsende Version|$1 deertwiske lääsende Versione}} fon moor as {{PLURAL:$2|Benutser|$2 Benutsere}} nit wiesd)',
	'datedefault' => 'Neen Preferenz',
	'defaultns' => 'Uursiede in disse Noomensruume säike:',
	'default' => 'Standoardienstaalenge',
	'diff' => 'Unnerskeed',
	'destfilename' => 'Sielnoome:',
	'duplicatesoffile' => '{{PLURAL:$1|Ju foulgjende Doatäi is n Duplikoat|Do foulgjende $1 Doatäie sunt Duplikoate}} fon disse Doatäi ([[Special:FileDuplicateSearch/$2|wiedere Details]]):',
	'download' => 'Deelleede',
	'disambiguations' => 'Begriepskläärengssieden',
	'disambiguationspage' => 'Template:Begriepskläärenge',
	'disambiguations-text' => "Do foulgjende Sieden ferlinkje ap ne Siede tou ju '''Begriepskläärenge'''.
Jie skuulen insteede deerfon ap ju eegentelk meende Siede ferlinkje.<br />
Ne Siede wäd as Begriepskläärengssiede behonneld, wan [[MediaWiki:Disambiguationspage]] ap ju ferlinket.",
	'doubleredirects' => 'Dubbelde Fäärelaitengen',
	'doubleredirectstext' => 'Disse Lieste änthoalt Fääreleedengen, do der ap wiedere Fääreleedengen ferlinkje.
Älke Riege änthoalt Links tou ju eerste un twäide Fääreleedenge as uk dät Siel fon ju twäide Fääreleedenge, wät foar gewöönelk ju wonskede Sielsiede is, ap ju al ju eerste Fääreleedenge wiese skuul.
<del>Truchstriekene</del> Iendraage wuuden al oumoaked.',
	'double-redirect-fixed-move' => 'dubbelde Fäärelaitenge aplöösd: [[$1]] → [[$2]]',
	'double-redirect-fixed-maintenance' => 'Foarnunner moakjen fon ju dubbelde Fääreleedenge fon [[$1]] ätter [[$2]].',
	'double-redirect-fixer' => 'RedirectBot',
	'deadendpages' => 'Siede sunner Ferwiese',
	'deadendpagestext' => 'Do foulgjende Sieden linkje nit tou uur Sieden in {{SITENAME}}.',
	'deletedcontributions' => 'Läskede Benutserbiedraage',
	'deletedcontributions-title' => 'Läskede Benutserbiedraage',
	'defemailsubject' => '{{SITENAME}}-E-Mail',
	'deletepage' => 'Siede läskje',
	'delete-confirm' => 'Läskjen fon „$1“',
	'delete-legend' => 'Läskje',
	'deletedtext' => '"$1" wuude läsked.
In $2 fiende Jie ne Lieste fon do lääste Läskengen.',
	'dellogpage' => 'Läsk-Logbouk',
	'dellogpagetext' => 'Hier is ne Lieste fon do lääste Läskengen.',
	'deletionlog' => 'Läsk-Logbouk',
	'deletecomment' => 'Gruund:',
	'deleteotherreason' => 'Uur/additionoalen Gruund:',
	'deletereasonotherlist' => 'Uur Gruund',
	'deletereason-dropdown' => '* Algemeene Läskgruunde
** Wonsk fon dän Autor
** Urhebergjuchtsferlätsenge
** Vandalismus',
	'delete-edit-reasonlist' => 'Läskgruunde beoarbaidje',
	'delete-toobig' => 'Disse Siede häd mäd moor as $1 {{PLURAL:$1|Version|Versionen}} ne gjucht loange Versionsgeskichte. Dät Läskjen fon sukke Sieden wuud ienskränkt, uum ne toufällige Uurlastenge fon {{SITENAME}} tou ferhinnerjen.',
	'delete-warning-toobig' => 'Disse Siede häd mäd moor as $1 {{PLURAL:$1|Version|Versione}} ne gjucht loange Versionsgeskichte. Dät Läskjen kon tou Stöörengen in {{SITENAME}} fiere.',
	'databasenotlocked' => 'Ju Doatenboank is nit speerd.',
	'delete_and_move' => 'Läskje un ferskuuwe',
	'delete_and_move_text' => '==Sielartikkel is al deer, läskje?==
Die Artikkel "[[:$1]]" existiert al.
Moatest du him foar ju Ferskuuwenge läskje?',
	'delete_and_move_confirm' => 'Jee, Sielartikkel foar ju Ferskuuwenge läskje',
	'delete_and_move_reason' => 'Läsked uum Plats tou moakjen foar Ferskuuwenge',
	'djvu_page_error' => 'DjVu-Siede buute dät Siedenberäk',
	'djvu_no_xml' => 'XML-Doaten konnen foar ju DjVu-Doatei nit ouruupen wäide',
	'deletedrevision' => 'Oolde Version $1 läsked',
	'deletedwhileediting' => 'Oachtenge: Disse Siede wuude al läsked, ätter dät du anfangd hiedest, hier tou beoarbaidjen!
Kiekje in dät [{{fullurl:Special:Log|type=delete&page=}}{{FULLPAGENAMEE}} Läsk-Logbouk] ätter,
wieruum ju Siede läsked wuude. Wan du ju Siede spiekerst, wäd ju näi anlaid.',
	'descending_abbrev' => 'fon',
	'duplicate-defaultsort' => 'Paas ap: Die Sortierengskoai „$2“ uurskrift dän toufoarne ferwoanden Koai „$1“.',
	'dberr-header' => 'Dit Wiki häd n Problem',
	'dberr-problems' => 'Äntskeeldenge. Disse Siede häd apstuuns techniske Meelasje.',
	'dberr-again' => 'Fersäik n poor Minuten tou täiwen un dan näi tou leeden.',
	'dberr-info' => '(Kon neen Ferbiendenge tou dän Doatenboank-Server moakje: $1)',
	'dberr-usegoogle' => 'Du kuust in ju Twisketied mäd Google säike.',
	'dberr-outofdate' => 'Beoachtje, dät die Säikindex fon uus Inhoolde ferallerd weese kon.',
	'dberr-cachederror' => 'Dät Foulgjende is ne Kopie fon dän Cache fon ju anfoarderde Siede un kon ferallerd weese.',
);

$messages['su'] = array(
	'december' => 'Désémber',
	'december-gen' => 'Désémber',
	'dec' => 'Dés',
	'delete' => 'Hapus',
	'deletethispage' => 'Hapus kaca ieu',
	'disclaimers' => 'Bantahan',
	'disclaimerpage' => 'Project:Bantahan_umum',
	'databaseerror' => 'Kasalahan gudang data',
	'dberrortext' => 'Éror rumpaka kueri pangkalan data.
Ieu bisa jadi alatan ayana bug dina sopwérna.
Kueri pangkalan data nu panungtung nyaéta:
<blockquote><tt>$1</tt></blockquote>
ti antara fungsi "<tt>$2</tt>".
Éror ti pangkalan data "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Éror rumpaka kueri pangkalan data.
Kueri pangkalan data nu panungtung nyaéta:
"$1"
ti antara fungsi "$2".
Éror ti pangkalan data "$3: $4".',
	'directorycreateerror' => 'Henteu bisa nyieun diréktori "$1".',
	'deletedhist' => 'Sajarah nu dihapus',
	'difference' => '(Béda antarrévisi)',
	'difference-multipage' => '(béda antarkaca)',
	'diff-multi' => '({{PLURAL:$1|Hiji révisi antara|$1 révisi antara}} karya {{PLURAL:$2|hiji kontributor|$2 kontributor}} teu ditémbongkeun)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Hiji révisi antara|$1 révisi antara}} karya leuwih ti {{PLURAL:$2|pamaké|pamaké}} teu ditémbongkeun)',
	'datedefault' => 'Tanpa préferénsi',
	'defaultns' => 'Lamun teu kitu, paluruh dina rohang ngaran di handap ieu:',
	'default' => 'ti dituna',
	'diff' => 'béda',
	'destfilename' => 'Ngaran koropak tujuan:',
	'download' => 'pulut',
	'disambiguations' => 'Kaca disambiguasi',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Kaca-kaca ieu ngabogaan tumbu ka hiji ''kaca disambiguasi''.
Kaca eta sakuduna numbu ka topik-topik anu luyu.<br />
Sahiji kaca dianggap minangka kaca disambiguasi lamun kaca kasebut ngagunakeun citakan anu nyambung ka [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Alihan ganda',
	'doubleredirectstext' => 'Ieu kaca ngabéréndélkeun kaca-kaca alihan ka kaca alihan lianna. Unggal baris ngandung tutumbu ka alihan kahiji jeung kadua, ogé tujul alihan kadua anu biasana tujul kaca anu "bener", anu sakuduna dituju ku alihan kahiji. Ëntri nu <del>dicorét</del> geus diropéa.',
	'double-redirect-fixed-move' => '[[$1]] geus pindah, dialihkeun ka [[$2]].',
	'double-redirect-fixed-maintenance' => 'Ngoméan alihan ganda ti [[$1]] ka [[$2]].',
	'double-redirect-fixer' => 'Pangomé alihan',
	'deadendpages' => 'Kaca buntu',
	'deadendpagestext' => 'Kaca-kaca di handap ieu teu numbu ka kaca séjén di {{SITENAME}}:',
	'deletedcontributions' => 'Kontribusi nu dihapus',
	'deletedcontributions-title' => 'Kontribusi nu dihapus',
	'defemailsubject' => 'Surélék {{SITENAME}}',
	'deletepage' => 'Hapus kaca',
	'delete-confirm' => 'Hapus "$1"',
	'delete-legend' => 'Hapus',
	'deletedtext' => '"$1" geus dihapus. Tempo $2 pikeun rékaman hapusan anyaran ieu.',
	'dellogpage' => 'Log_hapusan',
	'dellogpagetext' => 'Di handap ieu daptar hapusan nu ahir-ahir, sakabéh wanci dumasar wanci server.',
	'deletionlog' => 'log hapusan',
	'deletecomment' => 'Alesan:',
	'deleteotherreason' => 'Alesan séjén/panambih:',
	'deletereasonotherlist' => 'Alesan séjén',
	'deletereason-dropdown' => '*Alesan ilahar
** Paménta pamaké
** Ngarumpak hak cipta
** Vandalismeu',
	'delete-edit-reasonlist' => 'Alesan ngahapus éditan',
	'delete-toobig' => 'Jujutan édit ieu kaca panjang pisan, leuwih ti {{PLURAL:$1|révisi|révisi}}.
Hal ieu teu diwenangkeun pikeun nyegah karuksakan {{SITENAME}} nu teu dihaja.',
	'delete-warning-toobig' => 'Jujutan ieu kaca panjang pisan, leuwih ti{{PLURAL:$1|révisi|révisi}}. Dihapusna ieu kaca bisa ngaruksak jalanna pangkalan data {{SITENAME}}; sing ati-ati.',
	'databasenotlocked' => 'Gudang data teu kakonci.',
	'delete_and_move' => 'Hapus jeung pindahkeun',
	'delete_and_move_text' => '==Merlukeun hapusan==

Artikel nu dituju "[[:$1]]" geus aya. Badé dihapus baé sangkan bisa mindahkeun?',
	'delete_and_move_confirm' => 'Enya, hapus kaca éta',
	'delete_and_move_reason' => 'Hapus sangkan bisa mindahkeun',
	'djvu_page_error' => 'Kaca DjVu teu kawadahan',
	'djvu_no_xml' => 'XML keur koropak DjVu teu bisa dicokot',
	'deletedrevision' => 'Révisi heubeul nu dihapus $1',
	'deletedwhileediting' => "'''Awas''': ieu kaca geus dihapus nalika anjeun mitembeyan ngédit!",
	'descending_abbrev' => 'turun',
	'duplicate-defaultsort' => '\'\'\'Awas\'\'\': Konci runtuyan asal "$2" ngalindih konci runtuyan asal "$1" anu saméméhna.',
	'dberr-header' => 'Aya masalah dina ieu wiki',
	'dberr-problems' => 'Punten! Nuju aya gangguan téhnis.',
	'dberr-again' => 'Cobi antos sababaraha menit, lajeng dimuat ulang.',
	'dberr-info' => '(Teu bisa nyambung jeung server pangkalan data: $1)',
	'dberr-usegoogle' => 'Kanggo samentawis, tiasa dicobi milari di Google.',
);

$messages['sv'] = array(
	'december' => 'december',
	'december-gen' => 'decembers',
	'dec' => 'dec',
	'delete' => 'Radera',
	'deletethispage' => 'Radera denna sida',
	'disclaimers' => 'Förbehåll',
	'disclaimerpage' => 'Project:Allmänt förbehåll',
	'databaseerror' => 'Databasfel',
	'dberrortext' => 'Ett syntaxfel i databasfrågan har uppstått.
Detta kan indikera en bug i mjukvaran.
Den senaste databasfrågan att köras var:
<blockquote><tt>$1</tt></blockquote>
från funktionen "<tt>$2</tt>".
Databasen returnerade felet "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Det har uppstått ett syntaxfel i databassökningen.
Senaste sökbegrepp var:
"$1"
från funktionen "$2".
Databasen svarade med felmeddelandet "$3: $4"',
	'directorycreateerror' => 'Kunde inte skapa katalogen "$1".',
	'deletedhist' => 'Raderad historik',
	'difference' => '(Skillnad mellan versioner)',
	'difference-multipage' => '(Skillnad mellan sidor)',
	'diff-multi' => '({{PLURAL:$1|En mellanliggande version|$1 mellanliggande versioner}} av {{PLURAL:$2|en användare|$2 användare}} visas inte)',
	'diff-multi-manyusers' => '({{PLURAL:$1|En mellanliggande version|$1 mellanliggande versioner}} av mer än $2 användare visas inte)',
	'datedefault' => 'Ovidkommande',
	'defaultns' => 'Sök annars i dessa namnrymder:',
	'default' => 'ursprungsinställning',
	'diff' => 'skillnad',
	'destfilename' => 'Nytt filnamn:',
	'duplicatesoffile' => 'Följande {{PLURAL:$1|fil är en dubblett|filer är dubbletter}} till den här filen ([[Special:FileDuplicateSearch/$2|mer detaljer]]):',
	'download' => 'ladda ner',
	'disambiguations' => 'Sidor som länkar till förgreningssidor',
	'disambiguationspage' => 'Template:Förgrening',
	'disambiguations-text' => "Följande sidor länkar till ''förgreningssidor''.
Länkarna bör troligtvis ändras så att de länkar till en artikel istället.<br />
En sida anses vara en förgreningssida om den inkluderar en mall som länkas till från [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Dubbla omdirigeringar',
	'doubleredirectstext' => 'Det här är en lista över sidor som dirigerar om till andra omdirigeringssidor. Varje rad innehåller länkar till den första och andra omdirigeringsidan, samt till målet för den andra omdirigeringen. Målet för den andra omdirigeringen är ofta den "riktiga" sidan, som den första omdirigeringen egentligen ska leda till.
<del>Stryk över</del> poster som har åtgärdats.',
	'double-redirect-fixed-move' => '[[$1]] har flyttats, och är nu en omdirigering till [[$2]]',
	'double-redirect-fixed-maintenance' => 'Fixar dubbel omdirigering från [[$1]] till [[$2]].',
	'double-redirect-fixer' => 'Omdirigeringsrättaren',
	'deadendpages' => 'Sidor utan länkar',
	'deadendpagestext' => 'Följande sidor saknar länkar till andra sidor på {{SITENAME}}.',
	'deletedcontributions' => 'Raderade användarbidrag',
	'deletedcontributions-title' => 'Raderade användarbidrag',
	'defemailsubject' => '{{SITENAME}} e-post från användare "$1"',
	'deletepage' => 'Ta bort sida',
	'delete-confirm' => 'Radera "$1"',
	'delete-legend' => 'Radera',
	'deletedtext' => '"$1" har tagits bort.
Se $2 för noteringar om de senaste raderingarna.',
	'dellogpage' => 'Raderingslogg',
	'dellogpagetext' => 'Nedan listas de senaste raderingarna.',
	'deletionlog' => 'raderingsloggen',
	'deletecomment' => 'Anledning:',
	'deleteotherreason' => 'Annan/ytterligare anledning:',
	'deletereasonotherlist' => 'Annan anledning',
	'deletereason-dropdown' => '*Vanliga anledningar till radering
** Författarens begäran
** Upphovsrättsbrott
** Vandalism',
	'delete-edit-reasonlist' => 'Redigera anledningar för radering',
	'delete-toobig' => 'Denna sida har en lång redigeringshistorik med mer än $1 {{PLURAL:$1|sidversion|sidversioner}}. Borttagning av sådana sidor har begränsats för att förhindra oavsiktliga driftstörningar på {{SITENAME}}.',
	'delete-warning-toobig' => 'Denna sida har en lång redigeringshistorik med mer än $1 {{PLURAL:$1|sidversion|sidversioner}}. Att radera sidan kan skapa problem med hanteringen av databasen på {{SITENAME}}; var försiktig.',
	'databasenotlocked' => 'Databasen är inte låst.',
	'delete_and_move' => 'Radera och flytta',
	'delete_and_move_text' => '==Radering krävs==
Den titel du vill flytta sidan till, "[[:$1]]", finns redan. Vill du radera den för att möjliggöra flytt av denna sida dit?',
	'delete_and_move_confirm' => 'Ja, radera sidan',
	'delete_and_move_reason' => 'Raderad för att göra plats till flyttning av "[[$1]]"',
	'djvu_page_error' => 'DjVu-sida utanför gränserna',
	'djvu_no_xml' => 'Kan inte hämta DjVu-filens XML',
	'deletedrevision' => 'Raderade gammal sidversion $1',
	'days' => '{{PLURAL:$1|$1 dag|$1 dagar}}',
	'deletedwhileediting' => "'''Varning''': Denna sida raderades efter att du började redigera!",
	'descending_abbrev' => 'fallande',
	'duplicate-defaultsort' => 'Varning: Standardsorteringsnyckeln "$2" tar över från den tidigare standardsorteringsnyckeln "$1".',
	'dberr-header' => 'Den här wikin har ett problem',
	'dberr-problems' => 'Ursäkta! Denna sajt har just nu tekniska problem.',
	'dberr-again' => 'Pröva med att vänta några minuter och ladda om.',
	'dberr-info' => '(Kan inte kontakta databasservern: $1)',
	'dberr-usegoogle' => 'Du kan pröva att söka med Google under tiden.',
	'dberr-outofdate' => 'Observera att deras index av vårt innehåll kan vara föråldrat.',
	'dberr-cachederror' => 'Följande är en cachad kopia av den efterfrågade sidan, och kan vara föråldrad.',
	'discuss' => 'Diskutera',
);

$messages['sw'] = array(
	'december' => 'Desemba',
	'december-gen' => 'Desemba',
	'dec' => 'Des',
	'delete' => 'Futa',
	'deletethispage' => 'Futa ukurasa huo',
	'disclaimers' => 'Kanusho',
	'disclaimerpage' => 'Project:Kanusho kwa jumla',
	'databaseerror' => 'Hitilafu ya hifadhidata',
	'dberrortext' => 'Shina la kuulizia kihifadhidata kuna hitilafu imetokea.
Hii inaweza kuashiria kuna mdudu katika bidhaa pepe.
Jaribio la ulizio la mwisho la kihifadhidata lilikuwa:
<blockquote><tt>$1</tt></blockquote>
kutoka ndani ya kitendea "<tt>$2</tt>".
Kihifadhidata kikarejesha tatizo "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Shina la kuulizia kihifadhidata kuna hitilafu imetokea.
Jaribio la ulizio la mwisho la kihifadhidata lilikuwa:
"$1"
kutoka ndani ya kitendea "$2".
Kihifadhidata kikarejesha tatizo "<tt>$3: $4</tt>".',
	'directorycreateerror' => 'Haikuweza kuanzisha saraka ya "$1".',
	'deletedhist' => 'Historia iliyofutwa',
	'difference' => '(Tofauti baina ya mapitio)',
	'difference-multipage' => '(Tofauti kati ya kurasa)',
	'diff-multi' => '(Haionyeshwi {{PLURAL:$1|pitio moja la katikati lililoandikwa|mapitio $1 ya katikati yaliyoandikwa}} na {{PLURAL:$2|mtumiaji moja|watumiaji $2}})',
	'datedefault' => 'Chaguo-msingi',
	'defaultns' => 'La sivyo tafuta kwenye maeneo haya:',
	'default' => 'chaguo-msingi',
	'diff' => 'tofauti',
	'destfilename' => 'Jina la faili la mwishilio:',
	'duplicatesoffile' => '{{PLURAL:$1|Faili linalofuata ni nakala ya|Mafaili $1 yanayofuata ni nakala za}} faili hili ([[Special:FileDuplicateSearch/$2|maelezo mengine]]):',
	'download' => 'pakua',
	'disambiguations' => 'Kurasa za kuainisha maneno',
	'disambiguationspage' => 'Template:Maana',
	'disambiguations-text' => "Kurasa zinazofuata zina viungo vinavyoelekea '''kurasa ya kutofautishana maana'''.
Ni afadhali kiungo kiende makala inayostahili moja kwa moja.<br />
Kurasa za kutofautishana maana ni zile zinazotumia kigezo kinachoorodheshwa katika ukurasa wa [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Maelekezo mawilimawili',
	'doubleredirectstext' => 'Ukurasa huu unaorodhesha kurasa zinazoelekeza kurasa zingine za kuelekeza.
Katika kila mstari kuna viungo vinavyokwenda katika kurasa za kuelekeza zote mbili, pamoja na ukurasa wa mwishilio mwa elekezo la pili. Ukurasa huu wa mwishilio huwa ni ukurasa unaostahili kuelekezwa kutoka kwa ukurasa wa kuelekeza wa kwanza. Vitu <del>vilivyokatwa kwa mstari</del> vimeshatatuliwa.',
	'double-redirect-fixed-move' => '[[$1]] umehamishwa.
Sasa unaelekeza [[$2]].',
	'double-redirect-fixed-maintenance' => 'Elekezo maradufu inarekebishwa toka [[$1]] kwenda [[$2]].',
	'double-redirect-fixer' => 'Boti ya kurekebisha maelekezo',
	'deadendpages' => 'Kurasa ambazo haziungi na ukurasa mwingine wowote',
	'deadendpagestext' => 'Kurasa zifuatazo haziungana na kurasa zingine katika {{SITENAME}}.',
	'deletedcontributions' => 'Michango ya mtumiaji aliyefutwa',
	'deletedcontributions-title' => 'Michango ya mtumiaji aliyefutwa',
	'defemailsubject' => 'Barua pepe ya {{SITENAME}} iliyotumwa na mtumiaji "$1"',
	'deletepage' => 'Futa ukurasa',
	'delete-confirm' => 'Futa "$1"',
	'delete-legend' => 'Futa',
	'deletedtext' => '"$1" imefutwa. Ona $2 kwa historia ya kurasa zilizofutwa hivi karibuni.',
	'dellogpage' => 'Kumbukumbu ya ufutaji',
	'dellogpagetext' => 'Kurasa na mafaili zilizofutwa hivi karibuni zinaorodheshwa chini.',
	'deletionlog' => 'kumbukumbu za kufuta',
	'deletecomment' => 'Sababu:',
	'deleteotherreason' => 'Sababu nyingine:',
	'deletereasonotherlist' => 'Sababu nyingine',
	'deletereason-dropdown' => '*Sababu za kawaida za ufutaji
** Ombi la mmiliki
** Ukiukaji wa hakimiliki
** Uharabu',
	'delete-edit-reasonlist' => 'Uhariri orodha ya sababu za kufuta',
	'delete-toobig' => 'Ukurasa huu una historia ya kuhariri ndefu sana, yenye {{PLURAL:$1|badiliko|mabadiliko}} zaidi na $1.
Ufutaji wa kurasa hizi moja kwa moja umezuluiwa ili {{SITENAME}} isivurugwe kwa bahati mbaya.',
	'delete-warning-toobig' => 'Ukurasa huu unao mapitio mengi, zaida ya {{PLURAL:$1|pitio|mapitio}} $1.
Ukiufuta labda itavuruga uendeshaji wa hifadhidata ya {{SITENAME}};
endelea kwa uangalifu.',
	'databasenotlocked' => 'Hifadhidata haijafunguliwa.',
	'delete_and_move' => 'Kufuta na kuhamisha',
	'delete_and_move_confirm' => 'Ndiyo, ukurasa ufutwe',
	'deletedrevision' => 'Pitio la awali lililofutwa $1',
	'days' => 'siku {{PLURAL:$1|$1}}',
	'deletedwhileediting' => "'''Ilani''': Ukurasa huu ulifutwa ulipokwisha kuanza huuhariri!",
	'descending_abbrev' => 'shuk',
	'duplicate-defaultsort' => '!\'\'\'Ilani:\'\'\' Neno msingi la kupanga "$2" linafunika neno msingi la kupanga la awali "$1".',
	'dberr-header' => 'Wiki imekuta tatizo',
	'dberr-problems' => 'Kumradhi!
Tovuti hii inapata matatatizo wakati huu.',
	'dberr-again' => 'Jaribu tena baada ya kusubiri dakika chache.',
	'dberr-info' => '(Hamna mawasiliano na seva ya hifadhidata: $1)',
	'dberr-usegoogle' => 'Unaposubiri unaweza kujaribu kutafuta kwa kutumia Google.',
	'dberr-outofdate' => 'Elewa kwamba fahirisi yao ya yaliyomo katika tovuti hii inaweza kuwa imepitwa na wakati.',
	'dberr-cachederror' => 'Ifuatayo ni nakala ya kache ya ukurasa uliyoombwa, na huenda isiwe ya sasa.',
);

$messages['szl'] = array(
	'december' => 'grudźyń',
	'december-gen' => 'grudńa',
	'dec' => 'gru',
	'delete' => 'Wyćep',
	'deletethispage' => 'Wyćep ta zajta',
	'disclaimers' => 'Prawne informacyje',
	'disclaimerpage' => 'Project:Prawne informacyje',
	'databaseerror' => 'Feler bazy danych',
	'dberrortext' => 'Zdorziu sie feler we skuadńi zapytańo do bazy danych. Uostatńy, ńyudane zapytańy to:
<blockquote><tt>$1</tt></blockquote>
wysuane bez funkcja "<tt>$2</tt>".
MySQL zguośiu feler "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Zdorziu śe feler we skuadńi zapytańo do bazy danych. Uostatńy, ńyudane zapytańy to:
"$1"
kere wywououa funkcyjo "$2".
MySQL zguośiu feler "$3: $4"',
	'directorycreateerror' => 'Ńy idźe utwořić katalogu "$1".',
	'deletedhist' => 'Wyćepano historyjo sprowjyń',
	'difference' => '(Růžńice mjyndzy škryflańami)',
	'difference-multipage' => '(Porůwnańje zajt)',
	'diff-multi' => '(Ńy pokozano {{PLURAL:$1|jydnyj wersyji postrzedńij|$1 wersyji postrzedńich}}, sprowjanej bez {{PLURAL:$2|jydnygo sprowjorza|$2 sprowjorzow}} .)',
	'diff-multi-manyusers' => '(Ńy pokozano {{PLURAL:$1|jydnyj wersyji postrzedńij|$1 wersyji postrzedńich}}, sprowjanej bez {{PLURAL:$2|jydnygo sprowjorza|$2 sprowjorzow}} .)',
	'datedefault' => 'Důmyślny',
	'defaultns' => 'Důmyślńy sznupej we nastympujůncych przystrzyńach mjan:',
	'default' => 'důmyślńy',
	'diff' => 'zmj.',
	'destfilename' => 'Mjano docylowe:',
	'duplicatesoffile' => '{{PLURAL:$1|Nastympujůncy plik je kopjům|Nastympujůnce pliki sům kopjůma}} tygo plika:',
	'download' => 'pobier',
	'disambiguations' => 'Zajty ujydnoznačńajůnce',
	'disambiguationspage' => '{{ns:template}}:disambig',
	'disambiguations-text' => "Artikle půńižej uodwouůjům śe do '''zajtůw ujydnoznačńajůncych''', a powinny uodwouywać śe bezpostředńo do hasua kere je zwjůnzane ze treśćům artikla.<br />
Zajta uznawano je za ujydnoznačńajůnco kej zawiyro šablůn uokreślůny we [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Podwůjne překierowańa',
	'doubleredirectstext' => 'Na tyi liśće mogům znojdować śe překerowańo pozorne. Uoznača to, aže půńižej pjyrwšej lińii artikla, zawjerajůncyj "#REDIRECT ...", može znojdować śe dodotkowy tekst. Koždy wjerš listy zawjero uodwouańo do pjyrwšygo i drůgygo překerowańo a pjyrwšom lińjům tekstu drůgygo překerowańo. Uůmožliwjo to na ogůu uodnaleźyńy wuaśćiwygo artikla, do kerygo powinno śe překerowywać.',
	'double-redirect-fixed-move' => 'zajta [[$1]] zostoła zastůmpjůno bez przekerowańy, skiż jeij przekludzyńo ku [[$2]]',
	'double-redirect-fixer' => 'Korektor przekerowań',
	'deadendpages' => 'Artikle bez linkůw',
	'deadendpagestext' => 'Zajty wymjyńůne půńižej ńy majům uodnośńikůw do žodnych inkšych zajtůw kere sům na tej wiki.',
	'deletedcontributions' => 'Wyćepane sprowjyńa użytkowńika',
	'deletedcontributions-title' => 'Wyćepane sprowjyńa użytkowńika',
	'defemailsubject' => 'Wjadůmość uod {{GRAMMAR:D.pl|{{SITENAME}}}}',
	'deletepage' => 'Wyćep artikel',
	'delete-confirm' => 'Wyćep „$1”',
	'delete-legend' => 'Wyćep',
	'deletedtext' => 'Wyćepano "$1". Rejer uostatnio zrobiůnych wyćepań možeš uobejžyć tukej: $2.',
	'dellogpage' => 'Wyćepane',
	'dellogpagetext' => 'To je lista uostatńo wykůnanych wyćepań.',
	'deletionlog' => 'rejer wyćepań',
	'deletecomment' => 'Čymu:',
	'deleteotherreason' => 'Inkšy powůd:',
	'deletereasonotherlist' => 'Inkszy powůd',
	'deletereason-dropdown' => '* Nojčynstše přičyny wyćepańa
** Prośba autora
** Narušyńy praw autorskych
** Wandalizm',
	'delete-edit-reasonlist' => 'Sprowjańe listy powodůw wyćepańo zajty',
	'delete-toobig' => 'Ta zajta mo fest dugo historyja sprowjyń, wjyncyj jak $1 {{PLURAL:$1|půmjyńańy|půmjyńańo|půmjyńań}}.
Jeij wyćepańy mogło by spowodować zakłucyńo we dźołańu {{GRAMMAR:D.lp|{{SITENAME}}}} a bez tůż zostało uograńiczůne.',
	'delete-warning-toobig' => 'Ta zajta mo fest dugo historia sprowjyń, wjyncy kej $1 {{PLURAL:$1|půmjyńeńe|půmjyńańo|půmjyńań}}.
Dej pozůr, bo jei wyćepańe może spowodować zakłůcyńo w pracy {{GRAMMAR:D.lp|{{SITENAME}}}}.',
	'databasenotlocked' => 'Baza danych ńy je zawarto.',
	'delete_and_move' => 'Wyćep i przećep',
	'delete_and_move_text' => '== Přećepańy wymaga wyćepańo inkšyj zajty ==
Zajta docelowo „[[:$1]]” juž sam jest.
Čy chceš jům wyćepać, coby zrobić plac do přećepywanej zajty?',
	'delete_and_move_confirm' => 'Toć, wyćep zajta',
	'delete_and_move_reason' => 'Wyćepano coby zrobić plac do přećepywanyj zajty',
	'djvu_page_error' => 'Zajta DjVu poza zakresym',
	'djvu_no_xml' => 'Ńy idźe pobrać danych we formaće XML do plika DjVu',
	'deletedrevision' => 'Wyćepano popředńy wersyje $1',
	'deletedwhileediting' => "'''Pozůr''': Ta zajta zostoła wyćepano po tym, jak żeś rozpoczůł jei sprowjańy!",
	'descending_abbrev' => 'mal.',
	'duplicate-defaultsort' => 'Pozůr: Zmjarkowanym kluczym sortowańo bydźe "$2" a zastůmpi uůn zawczasu używany klucz "$1".',
);

$messages['ta'] = array(
	'december' => 'டிசம்பர்',
	'december-gen' => 'டிசம்பர்',
	'dec' => 'டிச',
	'delete' => 'நீக்கவும்',
	'deletethispage' => 'இப்பக்கத்தை நீக்கு',
	'disclaimers' => 'பொறுப்புத் துறப்புகள்',
	'disclaimerpage' => 'Project:பொதுவான பொறுப்புத் துறப்புகள்',
	'databaseerror' => 'தரவுத்தள தவறு',
	'dberrortext' => 'ஒரு தரவுத்தள வினவல் தொடரமைப்புத் தவறு ஏற்பட்டுள்ளது.
கடைசியாக முயற்சிக்கப்பட்ட தரவுத்தள வினவல்:
<blockquote><tt>$1</tt></blockquote>
செயலுக்குள் இருந்து "<tt>$2</tt>".
MySQL பிழையை விளைவாக்கியது "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'ஒரு தரவுத்தள வினவல் தொடரமைப்புத் தவறு ஏற்பட்டுள்ளது.
கடைசியாக முயற்சிக்கப்பட்ட தரவுத்தள வினவல்:
"$1"
செயலுக்குள்(function) இருந்து "$2".
MySQL returned error "$3: $4".',
	'directorycreateerror' => '"$1" அடைவை உருவாக்க முடியவில்லை.',
	'deletedhist' => 'நீக்கப்பட்ட வரலாறு',
	'difference' => '(திருத்தங்களுக்கிடையான வேறுபாடு)',
	'difference-multipage' => 'பக்கங்களுக்கு இடையேயான வேறுபாடு',
	'diff-multi' => '({{PLURAL:$1|ஒரு இடைப்பட்ட திருத்தம்|$1 இடைப்பட்ட திருத்தங்கள்}} {{PLURAL:$2|பயனர்|$2 பயனர்கள்}}  செய்தவைகளை காட்டப்படவில்லை.)',
	'datedefault' => 'விருப்பத்தேர்வுகள் இல்லை',
	'defaultns' => 'அப்படியில்லையென்றால் இந்த பொயர்வெளிகளில் தேடவும்:',
	'default' => 'பொதுவானது',
	'diff' => 'வேறுபாடு',
	'destfilename' => 'இலக்குக் கோப்பின் பெயர்:',
	'download' => 'தரவிறக்கு',
	'disambiguations' => 'வழிநெறிப்படுத்தல் பக்கங்களை இணைக்கும் பக்கங்கள்',
	'disambiguationspage' => 'Template:பக்கவழி நெறிப்படுத்தல்',
	'disambiguations-text' => "பின்வரும் பக்கங்கள் '''பக்கவழி நெறிப்படுத்தல் பக்கத்துக்கு''' இணைக்கப்பட்டுள்ளன. மாறாக இவை பொருத்தமன தலைப்பிற்கு இணைக்கப்பட வேண்டும். <br />[[MediaWiki:Disambiguationspage|பக்கவழி நெறிப்படுத்தல் பக்கங்கத்தில்]] உள்ள வார்ப்புரு இணைக்கப்பட்ட பக்கங்கள்  பக்கவழி நெறிப்படுத்தல் பக்கங்கள் என் கருதப்படும்.",
	'doubleredirects' => 'இரட்டை வழிமாற்றுகள்',
	'doubleredirectstext' => 'இந்தப் பட்டியல் போலியான நேர்மதிப்புக்களைக் கொண்டிருக்கக்கூடும். இது வழக்கமாக, இணைப்புடன் கூடிய மேலதிக உரை முதலாவது #வழிமாற்றுக்குக் கீழ் இருப்பதைக் குறிக்கும்.ஒவ்வொரு வரியும், முதலாம் இரண்டாம் வழிமாற்றுகளுக்கு இணைப்புகளைக் கொண்டிருப்பதுடன், இரண்டாவது வழிமாற்று உரையின் முதல் வரிக்கும் இணைப்பைக் கொண்டிருக்கும், இது வழக்கமாக முதலாவது வழிமாற்று குறித்துக் காட்ட வேண்டிய "உண்மையான" இலக்குக் கட்டுரையைக் கொடுக்கும்.',
	'double-redirect-fixed-move' => '[[$1]] நகர்த்தப்பட்டுவிட்டது. இப்பொழுது [[$2]] உக்கு வழிமாற்று தருகின்றது.',
	'double-redirect-fixer' => '(இரட்டை) வழிமாற்றைத் திருத்தியபயனர்',
	'deadendpages' => 'தொடராப் பக்கங்கள்',
	'deadendpagestext' => 'பின்வரும் பக்கங்கள் {{SITENAME}} தளத்தின் ஏனைய பக்கங்களுக்கு இணைக்க்ப்படவில்லை.',
	'deletedcontributions' => 'பயனரின் நீக்கப்பட்ட பங்களிப்புகள்',
	'deletedcontributions-title' => 'பயனரின நீக்கப்பட்ட பங்களிப்புக்கள்',
	'defemailsubject' => '{{SITENAME}} மின்னஞ்சல் பயனர்  " $1 "-இடமிருந்து.',
	'deletepage' => 'பக்கத்தை நீக்கு',
	'delete-confirm' => '"$1" பக்கத்தை நீக்கு',
	'delete-legend' => 'நீக்கவும்',
	'deletedtext' => '"$1" நீக்கப்பட்டு விட்டது. அண்மைய நீக்குதல்களின் பதிவுக்கு $2 ஐப் பார்க்க.',
	'dellogpage' => 'நீக்கல் பதிவு',
	'dellogpagetext' => 'கீழே காணப்படுவது மிக அண்மைய நீக்கல்களின் அட்டவணையாகும்.',
	'deletionlog' => 'நீக்கல் பதிவு',
	'deletecomment' => 'காரணம்:',
	'deleteotherreason' => 'வேறு மேலதிக காரணம்:',
	'deletereasonotherlist' => 'வேறு காரணம்',
	'deletereason-dropdown' => '*பொதுவான நீக்கல் காரணங்கள்
** காப்புரிமை மீறப்பட்டமை
** விசமத் தொகுப்பு
** ஆசிரியர் வேண்டுகோள்',
	'delete-edit-reasonlist' => 'நீக்கல் காரணங்களைத் தொகு',
	'delete-toobig' => 'இப்பக்கம் அதிகமான திருத்தங்களை கொண்டுள்ளது, குறிப்பாக $1 {{PLURAL:$1|திருத்தத்திற்கு|திருத்தங்களிற்கு}} மேல்.
{{SITENAME}} தளத்தின் தரவுகள் தற்செயலாக அழிந்துப்போவதை தடுப்பதற்க்காக இவ்வாறான பக்கங்கள் நீக்கப்படுவது முடக்கப்பட்டுள்ளது.',
	'delete-warning-toobig' => 'இப்பக்கம் அதிகமான திருத்தங்களை கொண்டுள்ளது, குறிப்பாக $1 {{PLURAL:$1|திருத்தத்திற்கு|திருத்தங்களிற்கு}} மேல்.
இப்பக்கத்தை நீக்குவது {{SITENAME}} தளத்தின் தரவுவழங்கனின் செயற்பாட்டை பாதிக்கலாம்;
கவனத்துடன் முன்னெடுக்கவும்.',
	'databasenotlocked' => 'தரவுத்தளம் பூட்டப்படவில்லை.',
	'delete_and_move' => 'நீக்கிவிட்டு நகர்த்து',
	'delete_and_move_text' => '==நீக்கம் தேவை==

நகர்த்தப்படவேண்டியப் பக்கம் "[[:$1]]" ஏற்கனவே உள்ளது. நகர்த்தலுக்கு வழி ஏற்படுத்த அப்பக்கத்தை நீக்க வேண்டுமா?',
	'delete_and_move_confirm' => 'ஆம், இப்பக்கத்தை நீக்குக',
	'delete_and_move_reason' => "''[[$1]]'' லிருந்து நகர்த்துவதற்கு இடமளிப்பதற்காக நீக்கப்பட்டது",
	'djvu_page_error' => 'DjVu பக்கம் வரம்பிற்கு வெளியே உள்ளது',
	'djvu_no_xml' => 'DjVu கோப்பிற்க்காக XML ஐ எடுக்க இயலவில்லை',
	'deletedrevision' => 'பழைய திருத்தம் $1 நீக்கப்பட்டது',
	'days' => '{{PLURAL:$1|$1நாள்|$1 நாட்கள்}}',
	'deletedwhileediting' => "'''எச்சரிக்கை''': நீங்கள் இப்பக்கத்தை தொகுக்க தொடங்கியப் பின் அது நீக்கப்பட்டுள்ளது!",
	'descending_abbrev' => 'இறங்கு',
	'duplicate-defaultsort' => "''' எச்சரிக்கை:''' இயல்புநிலை வரிசைப்படுத்து விசை ''\$2 \" முன்னால் இயல்புநிலை வரிசைப்படுத்து விசை\" \$1 \" ஐ மீறுகிறது.",
	'dberr-header' => 'இந்த விக்கிக்குஒரு கோளாறு உள்ளது',
	'dberr-problems' => 'மன்னிக்கவும்!
இந்த தளம், தொழில்நுட்ப பிரச்சினைகளுக்கு உள்ளாகியுள்ளது..',
	'dberr-again' => 'சில நிமிடங்கள் காத்திரு மற்றும் மறுபடியும் முயற்சிக்கவும்',
	'dberr-info' => '(தரவுதள சேவகனை தொடர்பு கொள்ள முடியாது:  $1 )',
	'dberr-usegoogle' => 'இதே நேரத்தில் நீங்கள் கூகிள் வழியாக தேட முயற்சிக்கலாம்.',
	'dberr-outofdate' => 'கவனிக்கவும் எங்கள் உள்ளடக்கத்திற்க்கானஅவர்களின் குறியீடுகள் காலாவதியாகி இருக்கலாம் .',
	'dberr-cachederror' => 'இது கோரிய பக்கத்தின் தற்காலிக நகல் , மற்றும் தற்போதைய  தேதி வரை இருக்காது.',
);

$messages['tcy'] = array(
	'december' => 'ಡಿಸಂಬರ್',
	'december-gen' => 'ಡಿಸೆಂಬರ್',
	'dec' => 'ಡಿಸೆಂಬರ್',
	'delete' => 'ದೆತ್ತ್ ಪಾಡ್ಲೆ',
	'deletethispage' => 'ಈ ಪುಟೊನು ದೆತ್ತ್ ಪಾಡ್ಲೆ',
	'disclaimers' => 'ಅಬಾಧ್ಯತೆಲು',
	'disclaimerpage' => 'Project:ಸಾಮಾನ್ಯ ಅಬಾಧ್ಯತೆಲು',
	'databaseerror' => 'ಡೇಟಾಬೇಸ್ ದೋಷ',
	'directorycreateerror' => '"$1" ಡೈರೆಕ್ಟರಿನ್ ಉ೦ಡು ಮಲ್ಪೆರೆ ಆವೊ೦ದಿಜ್ಜಿ.',
	'deletedhist' => 'ಮಾಜಾಯಿನ ಚರಿತ್ರೆ',
	'difference' => '(ಆವೃತ್ತಿಲೆದ ನಡುತ ವ್ಯತ್ಯಾಸ)',
	'diff' => 'ವ್ಯತ್ಯಾಸ',
	'disambiguationspage' => 'ದ್ವಂದ್ವ ನಿವಾರಣೆ',
	'dellogpage' => 'ಡಿಲೀಟ್ ಮಲ್ತಿನ ಫೈಲ್’ಲೆದ ದಾಖಲೆ',
);

$messages['te'] = array(
	'december' => 'డిసెంబరు',
	'december-gen' => 'డిసెంబరు',
	'dec' => 'డిసెం',
	'delete' => 'తొలగించు',
	'deletethispage' => 'ఈ పేజీని తొలగించండి',
	'disclaimers' => 'అస్వీకారములు',
	'disclaimerpage' => 'Project:సాధారణ నిష్పూచీ',
	'databaseerror' => 'డేటాబేసు లోపం',
	'dberrortext' => 'డేటాబేసుకు పంపిన క్వీరీలో ఒక తప్పు దొర్లింది.
ఇది సాఫ్టువేరులోనే ఉన్న లోపం గావచ్చు.
చివరి సారిగా డేటాబేసుకు పంపిన క్వీరీ ఇది:
<blockquote><tt>$1</tt></blockquote>
దీనిని "<tt>$2</tt>" అనే ఫంక్షను నుండి వచ్చింది.
డేటాబేసు ఇచ్చిన లోప-సమాచారం "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'డేటాబేసుకు పంపిన క్వీరీలో ఒక తప్పు దొర్లింది.
చివరి సారిగా డేటాబేసుకు పంపిన క్వీరీ ఇది:
"$1"
దీనిని "$2" అనే ఫంక్షను నుండి వచ్చింది.
డేటాబేసు ఇచ్చిన లోప-సమాచారం "$3: $4".',
	'directorycreateerror' => '"$1" అనే డైరెక్టరీని సృష్టించలేక పోతున్నాను.',
	'deletedhist' => 'తొలగించిన చరిత్ర',
	'difference' => '(సంచికల మధ్య తేడా)',
	'difference-multipage' => '(పేజీల మధ్య తేడా)',
	'diff-multi' => '({{PLURAL:$2|ఒక వాడుకరి|$2 వాడుకరుల}} యొక్క {{PLURAL:$1|ఒక మధ్యంతర కూర్పును|$1 మధ్యంతర కూర్పులను}} చూపించట్లేదు)',
	'diff-multi-manyusers' => '$2 మంది పైన ({{PLURAL:$2|ఒక వాడుకరి|వాడుకరుల}} యొక్క {{PLURAL:$1|ఒక మధ్యంతర కూర్పును|$1 మధ్యంతర కూర్పులను}} చూపించట్లేదు)',
	'datedefault' => 'ఏదైనా పరవాలేదు',
	'defaultns' => 'లేకపోతే ఈ నేంస్పేసులలో అన్వేషించు:',
	'default' => 'అప్రమేయం',
	'diff' => 'తేడాలు',
	'destfilename' => 'ఉద్దేశించిన ఫైలుపేరు:',
	'duplicatesoffile' => 'క్రింద పేర్కొన్న {{PLURAL:$1|ఫైలు ఈ ఫైలుకి నకలు|$1 ఫైళ్ళు ఈ ఫైలుకి నకళ్ళు}} ([[Special:FileDuplicateSearch/$2|మరిన్ని వివరాలు]]):',
	'download' => 'డౌన్‌లోడు',
	'disambiguations' => 'అయోమయ నివృత్తి పుటలకు లింకున్న పుటలు',
	'disambiguationspage' => 'Template:అయోమయ నివృత్తి',
	'disambiguations-text' => "కింది పేజీలు '''అయోమయ నివృత్తి''' పేజీకి లింకవుతున్నాయి. కానీ అవి సంబంధిత పేజీకి నేరుగా లింకు అవాలి. <br /> [[MediaWiki:Disambiguationspage]] నుంది లింకు ఉన్న మూసను వాడే పేజీని అయోమయ నివృత్తి పేజీగా భావిస్తారు.",
	'doubleredirects' => 'జంట దారిమార్పులు',
	'doubleredirectstext' => 'ఇతర దారిమార్పు పుటలకి తీసుకెళ్ళే దారిమార్పులని ఈ పుట చూపిస్తుంది.
ప్రతీ వరుసలో మొదటి మరియు రెండవ దారిమార్పులకు లంకెలు, ఆలానే రెండవ దారిమార్పు పుట యొక్క లక్ష్యం ఉన్నాయి. సాధారణంగా ఈ రెండవ దారిమార్పు యొక్క లక్ష్యమే "అసలైనది", అదే మొదటి దారిమార్పు యొక్క లక్ష్యంగా ఉండాలి.
<del>కొట్టివేయబడిన</del> పద్దులు పరిష్కరించబడ్డవి.',
	'double-redirect-fixed-move' => '[[$1]]ని తరలించారు, అది ప్రస్తుతం [[$2]]కి దారిమార్పు.',
	'double-redirect-fixed-maintenance' => '[[$1]] కు జమిలి దారిమార్పును [[$2]] కు సరిచేస్తున్నాం.',
	'double-redirect-fixer' => 'దారిమార్పు సరిద్దువారు',
	'deadendpages' => 'అగాధ (డెడ్ఎండ్) పేజీలు',
	'deadendpagestext' => 'కింది పేజీల నుండి ఈ వికీ లోని ఏ ఇతర పేజీకీ లింకులు లేవు.',
	'deletedcontributions' => 'తొలగించబడిన వాడుకరి రచనలు',
	'deletedcontributions-title' => 'తొలగించబడిన వాడుకరి రచనలు',
	'defemailsubject' => 'వాడుకరి "$1" నుండి {{SITENAME}} ఈ-మెయిలు',
	'deletepage' => 'పేజీని తొలగించు',
	'delete-confirm' => '"$1"ని తొలగించు',
	'delete-legend' => 'తొలగించు',
	'deletedtext' => '"$1" తుడిచివేయబడింది. ఇటీవలి తుడిచివేతలకు సంబంధించిన నివేదిక కొరకు $2 చూడండి.',
	'dellogpage' => 'తొలగింపుల చిట్టా',
	'dellogpagetext' => 'ఇది ఇటీవలి తుడిచివేతల జాబితా.',
	'deletionlog' => 'తొలగింపుల చిట్టా',
	'deletecomment' => 'కారణం:',
	'deleteotherreason' => 'ఇతర/అదనపు కారణం:',
	'deletereasonotherlist' => 'ఇతర కారణం',
	'deletereason-dropdown' => '* తొలగింపుకి సాధారణ కారణాలు
** రచయిత అభ్యర్థన
** కాపీహక్కుల ఉల్లంఘన
** దుశ్చర్య',
	'delete-edit-reasonlist' => 'తొలగింపు కారణాలని మార్చండి',
	'delete-toobig' => 'ఈ పేజీకి $1 {{PLURAL:$1|కూర్పుకు|కూర్పులకు}} మించిన, చాలా పెద్ద దిద్దుబాటు చరితం ఉంది. {{SITENAME}}కు అడ్డంకులు కలగడాన్ని నివారించేందుకు గాను, అలాంటి పెద్ద పేజీల తొలగింపును నియంత్రించాం.',
	'delete-warning-toobig' => 'ఈ పేజీకి $1 {{PLURAL:$1|కూర్పుకు|కూర్పులకు}} మించిన, చాలా పెద్ద దిద్దుబాటు చరితం ఉంది. దాన్ని తొలగిస్తే {{SITENAME}}కి చెందిన డేటాబేసు కార్యాలకు ఆటంకం కలగొచ్చు; అప్రమత్తతో ముందుకుసాగండి.',
	'databasenotlocked' => 'డేటాబేసు లాకవలేదు.',
	'delete_and_move' => 'తొలగించి, తరలించు',
	'delete_and_move_text' => '==తొలగింపు అవసరం==

ఉద్దేశించిన వ్యాసం "[[:$1]]" ఇప్పటికే ఉనికిలో ఉంది. ప్రస్తుత తరలింపుకు వీలుగా దాన్ని తొలగించేయమంటారా?',
	'delete_and_move_confirm' => 'అవును, పేజీని తొలగించు',
	'delete_and_move_reason' => '"[[$1]]"ను తరలించడానికి వీలుగా తొలగించారు',
	'djvu_page_error' => 'DjVu పేజీ రేంజి దాటిపోయింది',
	'djvu_no_xml' => 'DjVu ఫైలు కోసం XMLను తీసుకుని రాలేకపోయాను',
	'deletedrevision' => 'పాత సంచిక $1 తొలగించబడినది.',
	'days-abbrev' => '$1రో',
	'days' => '{{PLURAL:$1|ఒక రోజు|$1 రోజుల}}',
	'deletedwhileediting' => "'''హెచ్చరిక''': మీరు మార్పులు చేయటం మొదలుపెట్టాక ఈ పేజీ తొలగించబడింది!",
	'descending_abbrev' => 'అవరోహణ',
	'duplicate-defaultsort' => 'హెచ్చరిక: డిఫాల్టు పేర్చు కీ "$2", గత డిఫాల్టు పేర్చు కీ "$1" ని అతిక్రమిస్తుంది.',
	'dberr-header' => 'ఈ వికీ సమస్యాత్మకంగా ఉంది',
	'dberr-problems' => 'క్షమించండి! ఈ సైటు సాంకేతిక సమస్యలని ఎదుర్కొంటుంది.',
	'dberr-again' => 'కొన్ని నిమిషాలాగి మళ్ళీ ప్రయత్నించండి.',
	'dberr-info' => '(డాటాబేసు సర్వరుని సంధానించలేకున్నాం: $1)',
	'dberr-usegoogle' => 'ఈలోపు మీరు గూగుల్ ద్వారా వెతకడానికి ప్రయత్నించండి.',
	'dberr-outofdate' => 'మా విషయం యొక్క వారి సూచీలు అంత తాజావి కావపోవచ్చని గమనించండి.',
	'dberr-cachederror' => 'అభ్యర్థించిన పేజీ యొక్క కోశం లోని కాపీ ఇది, అంత తాజాది కాకపోవచ్చు.',
);

$messages['tet'] = array(
	'december' => 'Dezembru',
	'december-gen' => 'Dezembru nian',
	'dec' => 'Dez.',
	'delete' => 'Halakon',
	'deletethispage' => "Halakon pájina ne'e",
	'disclaimers' => 'Avisu legál',
	'disclaimerpage' => 'Project:Avisu legál',
	'diff' => 'diferensa',
	'defemailsubject' => '{{SITENAME}} - korreiu eletróniku husi uza-na\'in "$1"',
	'deletepage' => 'Halakon pájina',
	'delete-legend' => 'Halakon',
	'deletedtext' => 'Ita foin halakon pájina "$1". Haree $2 ba "operasaun halakon" seluk.',
	'dellogpage' => 'Lista halakon',
	'deletionlog' => 'lista halakon',
	'deletecomment' => 'Motivu:',
	'deleteotherreason' => 'Motivu seluk/ida tan:',
	'deletereasonotherlist' => 'Motivu seluk',
	'delete-edit-reasonlist' => 'Edita lista motivu nian',
	'delete_and_move' => 'Halakon ho book',
	'delete_and_move_confirm' => 'Sin, halakon pájina',
	'dberr-header' => "Wiki ne'e iha problema",
);

$messages['tg'] = array(
	'december' => 'Dezembru',
	'december-gen' => 'Dezembru nian',
	'dec' => 'Dez.',
	'delete' => 'Halakon',
	'deletethispage' => "Halakon pájina ne'e",
	'disclaimers' => 'Avisu legál',
	'disclaimerpage' => 'Project:Avisu legál',
	'diff' => 'diferensa',
	'defemailsubject' => '{{SITENAME}} - korreiu eletróniku husi uza-na\'in "$1"',
	'deletepage' => 'Halakon pájina',
	'delete-legend' => 'Halakon',
	'deletedtext' => 'Ita foin halakon pájina "$1". Haree $2 ba "operasaun halakon" seluk.',
	'dellogpage' => 'Lista halakon',
	'deletionlog' => 'lista halakon',
	'deletecomment' => 'Motivu:',
	'deleteotherreason' => 'Motivu seluk/ida tan:',
	'deletereasonotherlist' => 'Motivu seluk',
	'delete-edit-reasonlist' => 'Edita lista motivu nian',
	'delete_and_move' => 'Halakon ho book',
	'delete_and_move_confirm' => 'Sin, halakon pájina',
	'dberr-header' => "Wiki ne'e iha problema",
);

$messages['tg-cyrl'] = array(
	'december' => 'Декабр',
	'december-gen' => 'Декабри',
	'dec' => 'Дек',
	'delete' => 'Ҳазф',
	'deletethispage' => 'Ин саҳифаро ҳазф кунед',
	'disclaimers' => 'Такзибнома',
	'disclaimerpage' => 'Project:Такзибномаи умумӣ',
	'databaseerror' => 'Хатои бойгоҳи дода',
	'dberrortext' => 'Ишколе дар дастури фиристанда шуда ба пойгоҳи дода рух дод.
Далели ин мушкил метавонад эроде дар нармафзор бошад.
Ин охирин дастуре буд ки барои пойгоҳи дода фиристода шуд:
<blockquote><tt>$1</tt></blockquote>
ин дастур аз даруни амалгир "<tt>$2</tt>".
Погоҳи дода ин хаторо бозгардонд "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Хатое дар дастури фиристодашуда ба пойгоҳи дода рух дод.
Охирин дастуре ки ба пойгоҳи дода фиристода шуд ин буд:
"$1"
аз даруни амалгар фиристода шуд "$2".
Пойгоҳи дода (MySQL) ин хаторо бозгардонд "$3: $4"',
	'directorycreateerror' => 'Имкони эҷоди пӯшаи "$1" вуҷуд надорад.',
	'deletedhist' => 'Таърихи ҳазфшуда',
	'difference' => '(Фарқияти байни нусхаҳо)',
	'diff-multi' => '({{PLURAL:$1|вироиши миёнӣ|$1 вироишоти миёнӣ}} нишон дода нашудааст.)',
	'datedefault' => 'Бе тарҷиҳ',
	'defaultns' => 'Ба таври пешфарз дар ин фазоҳои ном ҷустуҷӯ шавад:',
	'default' => 'пешфарз',
	'diff' => 'фарқият',
	'destfilename' => 'Номи парвандаи мақсад:',
	'download' => 'боргирӣ',
	'disambiguations' => 'Саҳифаҳои ибҳомзудоӣ',
	'disambiguationspage' => 'Template:ибҳомзудоӣ',
	'disambiguations-text' => "Саҳифаҳои зерин пайванд ба '''саҳифаи ибҳомзудоӣ''' доранд. Ин саҳифаҳо бояд ба мавзӯъи муносиби худ пайваст шаванд.<br />Саҳифа Ибҳомзудоӣ дар назар гирифта мешавад, ки дар он шаблоне, ки ба [[MediaWiki:Disambiguationspage]] пайванд дорад истифода шуда бошад",
	'doubleredirects' => 'Тағйири масирҳои дутоӣ',
	'doubleredirectstext' => 'Ҳар сатр дар бар дорандаи пайвандҳое ба тағйири масири аввал ва дувум ва ҳамчунин хати нахуст тагйири масири дувум аст. Маъмулан саҳифаи мақсади воқеъӣ, ки нахустин тағйири масир бояд ба он бошад ба ин гуна мушаххас мешавад.',
	'double-redirect-fixer' => 'Таъмиркори тағйирмасирҳо',
	'deadendpages' => 'Саҳифаҳои бемаъно',
	'deadendpagestext' => 'Саҳифаҳои зерин ба ҳеҷ дигар саҳифае дар {{SITENAME}} пайванд нестанд.',
	'deletedcontributions' => 'Ҳиссагузориҳои ҳазфшудаи корбар',
	'deletedcontributions-title' => 'Ҳиссагузориҳои ҳазфшудаи корбар',
	'defemailsubject' => 'Википедиа e-mail',
	'deletepage' => 'Ҳазфи саҳифа',
	'delete-confirm' => 'Ҳазф "$1"',
	'delete-legend' => 'Ҳазф',
	'deletedtext' => '"$1" ҳазф шудааст.
Нигаред ба $2 барои гузориши ҳазфи охирин.',
	'dellogpage' => 'Гузоришҳои ҳазф',
	'dellogpagetext' => 'Феҳристи зер феҳристи аз охирин ҳазфҳост. Ҳамаи вақтҳои нишон додашуда, вақти Ҷаҳонӣ (вақти Гринвич) аст.',
	'deletionlog' => 'гузоришҳои ҳазф',
	'deletecomment' => 'Сабаб:',
	'deleteotherreason' => 'Далели дигар/иловагӣ:',
	'deletereasonotherlist' => 'Дигар сабаб',
	'deletereason-dropdown' => '*Далелҳои умумии ҳазф
** Дархости корбар
** Нақзи ҳаққи таксир
** Харобкорӣ',
	'delete-edit-reasonlist' => 'Вироиш ҳазф далелҳо',
	'delete-toobig' => 'Ин саҳифа таърихчаи бузурге дорад, ки шомили беш аз $1 вироиш аст. Ҳазфи ин гуна саҳифаҳо барои пешгири аз шикастани тасодуфӣ дар {{SITENAME}} маҳдуд шудааст.',
	'delete-warning-toobig' => 'Ин саҳифа таърихи бузурге дорад, ки шомили беш аз $1 вироиш аст. Ҳазфи ин саҳифа метавонад ихтилол ба амалгари пойгоҳи додаи {{SITENAME}} бишавад; лутфан бо эҳтиёт иқдом кунед.',
	'databasenotlocked' => 'Пойгоҳи дода қуфл нест.',
	'delete_and_move' => 'Ҳазф ва кӯчонидан',
	'delete_and_move_text' => '==Ниёз ба ҳазф==

Мақолаи мақсад "[[:$1]]" вуҷуд дорад. Оё мехоҳед онро ҳазф кунед то интиқол мумкин шавад?',
	'delete_and_move_confirm' => 'Бале, саҳифа ҳазф шавад',
	'delete_and_move_reason' => 'Ҳазф шуд барои мумкин шудани кӯчонидан',
	'djvu_page_error' => 'Саҳифаи DjVu хориҷ аз ҳудуди саф',
	'djvu_no_xml' => 'Барои истифодаи XML имкони пайдо кардани парвандаи DjVu вуҷуд надошт',
	'deletedrevision' => 'Нусхаи ҳазфшудаи кӯҳнаи $1',
	'deletedwhileediting' => "'''Огоҳӣ''': Ин саҳифа баъди ба вироиш шурӯъ кардани шумо ҳазф шуда буд!",
	'descending_abbrev' => 'поёнӣ',
	'dberr-info' => '(Имкони барқарори иртибот бо пойгоҳи дода вуҷуд надорад: $1)',
	'dberr-usegoogle' => 'Дар ин муддат метавонед бо истифода аз Гугл ҷустуҷӯ кунед.',
	'dberr-outofdate' => 'Таваҷҷӯҳ кунед, ки намояҳои онҳо аз мӯҳтавои мо мумкин аст барӯз набошад.',
	'dberr-cachederror' => 'Ин як нусхаи саҳифаи дархостшуда аст, ки дар кэш қарор дорад ва шояд барӯз нест.',
);

$messages['tg-latn'] = array(
	'december' => 'Dekabr',
	'december-gen' => 'Dekabri',
	'dec' => 'Dek',
	'delete' => 'Hazf',
	'deletethispage' => 'In sahifaro hazf kuned',
	'disclaimers' => 'Takzibnoma',
	'disclaimerpage' => 'Project:Takzibnomai umumī',
	'databaseerror' => 'Xatoi bojgohi doda',
	'dberrortext' => 'Işkole dar dasturi firistanda şuda ba pojgohi doda rux dod.
Daleli in muşkil metavonad erode dar narmafzor boşad.
In oxirin dasture bud ki baroi pojgohi doda firistoda şud:
<blockquote><tt>$1</tt></blockquote>
in dastur az daruni amalgir "<tt>$2</tt>".
Pogohi doda in xatoro bozgardond "<tt>$3: $4</tt>".',
	'directorycreateerror' => 'Imkoni eçodi pūşai "$1" vuçud nadorad.',
	'deletedhist' => "Ta'rixi hazfşuda",
	'difference' => '(Farqijati bajni nusxaho)',
	'diff-multi' => '({{PLURAL:$1|viroişi mijonī|$1 viroişoti mijonī}} nişon doda naşudaast.)',
	'datedefault' => 'Be tarçih',
	'default' => 'peşfarz',
	'diff' => 'farqijat',
	'destfilename' => 'Nomi parvandai maqsad:',
	'download' => 'borgirī',
	'disambiguations' => 'Sahifahoi ibhomzudoī',
	'disambiguationspage' => 'Template:ibhomzudoī',
	'disambiguations-text' => "Sahifahoi zerin pajvand ba '''sahifai ibhomzudoī''' dorand. In sahifaho bojad ba mavzū'i munosibi xud pajvast şavand.<br />Sahifa Ibhomzudoī dar nazar girifta meşavad, ki dar on şablone, ki ba [[MediaWiki:Disambiguationspage]] pajvand dorad istifoda şuda boşad",
	'doubleredirects' => 'Taƣjiri masirhoi dutoī',
	'double-redirect-fixer' => "Ta'mirkori taƣjirmasirho",
	'deadendpages' => "Sahifahoi bema'no",
	'deadendpagestext' => 'Sahifahoi zerin ba heç digar sahifae dar {{SITENAME}} pajvand nestand.',
	'deletedcontributions' => 'Hissaguzorihoi hazfşudai korbar',
	'deletedcontributions-title' => 'Hissaguzorihoi hazfşudai korbar',
	'defemailsubject' => 'Vikipedia e-mail',
	'deletepage' => 'Hazfi sahifa',
	'delete-confirm' => 'Hazf "$1"',
	'delete-legend' => 'Hazf',
	'deletedtext' => '"$1" hazf şudaast.
Nigared ba $2 baroi guzorişi hazfi oxirin.',
	'dellogpage' => 'Guzorişhoi hazf',
	'dellogpagetext' => 'Fehristi zer fehristi az oxirin hazfhost. Hamai vaqthoi nişon dodaşuda, vaqti Çahonī (vaqti Grinvic) ast.',
	'deletionlog' => 'guzorişhoi hazf',
	'deletecomment' => 'Sabab:',
	'deleteotherreason' => 'Daleli digar/ilovagī:',
	'deletereasonotherlist' => 'Digar sabab',
	'deletereason-dropdown' => '*Dalelhoi umumiji hazf
** Darxosti korbar
** Naqzi haqqi taksir
** Xarobkorī',
	'delete-edit-reasonlist' => 'Viroiş hazf dalelho',
	'databasenotlocked' => 'Pojgohi doda qufl nest.',
	'delete_and_move' => 'Hazf va kūconidan',
	'delete_and_move_text' => '==Nijoz ba hazf==

Maqolai maqsad "[[:$1]]" vuçud dorad. Ojo mexohed onro hazf kuned to intiqol mumkin şavad?',
	'delete_and_move_confirm' => 'Bale, sahifa hazf şavad',
	'delete_and_move_reason' => 'Hazf şud baroi mumkin şudani kūconidan',
	'djvu_page_error' => 'Sahifai DjVu xoriç az hududi saf',
	'djvu_no_xml' => 'Baroi istifodai XML imkoni pajdo kardani parvandai DjVu vuçud nadoşt',
	'deletedrevision' => 'Nusxai hazfşudai kūhnai $1',
	'deletedwhileediting' => "'''Ogohī''': In sahifa ba'di ba viroiş şurū' kardani şumo hazf şuda bud!",
	'descending_abbrev' => 'pojonī',
	'dberr-info' => '(Imkoni barqarori irtibot bo pojgohi doda vuçud nadorad: $1)',
	'dberr-usegoogle' => 'Dar in muddat metavoned bo istifoda az Gugl çustuçū kuned.',
	'dberr-outofdate' => 'Tavaççūh kuned, ki namojahoi onho az mūhtavoi mo mumkin ast barūz naboşad.',
	'dberr-cachederror' => 'In jak nusxai sahifai darxostşuda ast, ki dar keş qaror dorad va şojad barūz nest.',
);

$messages['th'] = array(
	'december' => 'ธันวาคม',
	'december-gen' => 'ธันวาคม',
	'dec' => 'ธ.ค.',
	'delete' => 'ลบ',
	'deletethispage' => 'ลบหน้านี้',
	'disclaimers' => 'ข้อปฏิเสธความรับผิดชอบ',
	'disclaimerpage' => 'Project:ข้อปฏิเสธความรับผิดชอบ',
	'databaseerror' => 'ความผิดพลาดที่ฐานข้อมูล',
	'dberrortext' => 'ไวยากรณ์ในการค้นฐานข้อมูลผิดพลาด
สาเหตุอาจเกิดจากบั๊กของซอฟต์แวร์
การค้นฐานข้อมูลล่าสุดกระทำเมื่อ:
<blockquote><tt>$1</tt></blockquote>
จากฟังก์ชัน "<tt>$2</tt>"
ฐานข้อมูลแจ้งข้อผิดพลาดว่า "<tt>$3: $4</tt>"',
	'dberrortextcl' => 'ไวยากรณ์ในการค้นฐานข้อมูลผิดพลาด
การค้นฐานข้อมูลล่าสุดกระทำเมื่อ:
"$1"
จากฟังก์ชัน "$2"
ฐานข้อมูลแจ้งข้อผิดพลาดว่า "$3: $4"',
	'directorycreateerror' => 'ไม่สามารถสร้างไดเรกทอรี "$1"',
	'deletedhist' => 'ลบประวัติ',
	'difference' => '(ความแตกต่างระหว่างรุ่นปรับปรุง)',
	'difference-multipage' => '(ความแตกต่างระหว่างหน้าต่างๆ)',
	'diff-multi' => 'การแก้ไข({{PLURAL:$1|หนึ่งรุ่นระหว่างรุ่นที่เปรียบเทียบ|$1 รุ่นระหว่างรุ่นที่เปรียบเทียบ}} โดย {{PLURAL:$2|หนึ่งผู้ใช้|$2 ผู้ใช้}} ไม่แสดงผล)',
	'diff-multi-manyusers' => 'การแก้ไข({{PLURAL:$1|หนึ่งรุ่นระหว่างรุ่นที่เปรียบเทียบ|$1 รุ่นระหว่างรุ่นที่เปรียบเทียบ}} โดยผู้ใช้มากกว่า {{PLURAL:$2|หนึ่งผู้ใช้|$2 ผู้ใช้}} ไม่แสดงผล)',
	'datedefault' => 'ค่าตั้งต้น',
	'defaultns' => 'หรือค้นหาในเนมสเปซต่อไปนี้:',
	'default' => 'ค่าตั้งต้น',
	'diff' => 'ต่าง',
	'destfilename' => 'ชื่อไฟล์ที่ต้องการ:',
	'duplicatesoffile' => '{{PLURAL:$1|ไฟล์|$1 ไฟล์}}ต่อไปนี้ เป็นไฟล์เดียวกับไฟล์นี้ ([[Special:FileDuplicateSearch/$2|รายละเอียดเพิ่ม]]):',
	'download' => 'ดาวน์โหลด',
	'disambiguations' => 'หน้าแก้ความกำกวม',
	'disambiguationspage' => 'Template:แก้กำกวม',
	'disambiguations-text' => "หน้าต่อไปนี้เชื่อมโยงไปยัง '''หน้าคำกำกวม''' ซึ่งเนื้อหาในหน้าเหล่านั้นควรถูกเชื่อมโยงไปยังหัวข้อที่เหมาะสมแทนที่<br />

หน้าใดที่เรียกใช้ [[MediaWiki:Disambiguationspage]] หน้าเหล่านั้นจะถูกนับเป็นหน้าคำกำกวม",
	'doubleredirects' => 'หน้าเปลี่ยนทางซ้ำซ้อน',
	'doubleredirectstext' => 'หน้านี้แสดงรายการชื่อที่เปลี่ยนทางไปยังหน้าเปลี่ยนทางอื่น
แต่ละแถวคือลิงก์ของการเปลี่ยนทางครั้งแรกและครั้งที่สอง พร้อมกับหน้าปลายทางของการเปลี่ยนทางครั้งที่สอง ซึ่งควรแก้ไขการเปลี่ยนทางครั้งแรกเป็นหน้าปลายทางดังกล่าว
รายการที่ <del>ขีดฆ่า</del> คือรายการที่แก้ไขแล้ว',
	'double-redirect-fixed-move' => '[[$1]] ถูกเปลี่ยนชื่อแล้ว และเปลี่ยนทางไปยัง [[$2]]',
	'double-redirect-fixed-maintenance' => 'การแก้ไขการเปลี่ยนทางซ้ำซ้อนจาก [[$1]] ไปยัง [[$2]]',
	'double-redirect-fixer' => 'Redirect fixer',
	'deadendpages' => 'หน้าสุดทาง',
	'deadendpagestext' => 'หน้าต่อไปนี้ไม่ได้ลิงก์ไปหน้าหน้าใดในวิกิ',
	'deletedcontributions' => 'การแก้ไขที่ถูกลบ',
	'deletedcontributions-title' => 'การแก้ไขที่ถูกลบ',
	'defemailsubject' => '{{SITENAME}} อีเมล์จากผู้ใช้งาน "$1"',
	'deletepage' => 'ลบหน้า',
	'delete-confirm' => 'ลบ "$1"',
	'delete-legend' => 'ลบ',
	'deletedtext' => '"$1" ถูกลบ
ดู $2 สำหรับบันทึกการลบล่าสุด',
	'dellogpage' => 'ปูมการลบ',
	'dellogpagetext' => 'ด้านล่างเป็นรายการของการลบล่าสุด',
	'deletionlog' => 'บันทึกการลบ',
	'deletecomment' => 'เหตุผล:',
	'deleteotherreason' => 'เหตุผลอื่นเพิ่มเติม:',
	'deletereasonotherlist' => 'เหตุผลอื่น',
	'deletereason-dropdown' => '* เหตุผลทั่วไปของการลบ
** รับแจ้งจากผู้เขียน
** ละเมิดลิขสิทธิ์
** ก่อกวน',
	'delete-edit-reasonlist' => 'แก้ไขรายชื่อเหตุผลในการลบ',
	'delete-toobig' => 'หน้านี้มีประวัติการแก้ไขมากเกินกว่า $1 {{PLURAL:$1|รุ่น|รุ่น}} ซึ่งถือว่าเยอะมาก เพื่อป้องกันไม่ให้ {{SITENAME}} ได้รับความเสียหายอย่างที่ไม่เคยคาดคิดมาก่อน จึงไม่อนุญาตให้ลบหน้านี้',
	'delete-warning-toobig' => 'หน้านี้มีประวัติการแก้ไขมากเกินกว่า $1 {{PLURAL:$1|รุ่น|รุ่น}} ซึ่งถือว่าเยอะมาก การลบหน้านี้อาจทำให้ {{SITENAME}} ได้รับความเสียหายอย่างที่ไม่เคยคาดคิดมาก่อน จึงได้เตือนไว้ ก่อนที่จะกระทำสิ่งนี้',
	'databasenotlocked' => 'ฐานข้อมูลไม่ได้ล็อก',
	'delete_and_move' => 'ลบและย้าย',
	'delete_and_move_text' => '== จำเป็นต้องลบ ==

ชื่อหัวข้อที่ต้องการ "[[:$1]]" มีอยู่แล้ว แน่ใจหรือไม่ว่าต้องการลบเพื่อที่จะให้การเปลี่ยนชื่อสำเร็จ',
	'delete_and_move_confirm' => 'ยืนยัน ต้องการลบ',
	'delete_and_move_reason' => 'ถูกลบสำหรับการเปลี่ยนชื่อ',
	'djvu_page_error' => 'หน้าเดจาวู (DjVu) เกินขนาด',
	'djvu_no_xml' => 'ไม่สามารถส่งเอกซ์เอ็มแอล (XML) สำหรับไฟล์เดจาวู (DjVu)',
	'deletedrevision' => 'รุ่นเก่าที่ถูกลบ $1',
	'deletedwhileediting' => "'''คำเตือน''': หน้านี้ถูกลบไปแล้วในขณะที่คุณกำลังแก้ไข!",
	'descending_abbrev' => 'หลังมาหน้า',
	'duplicate-defaultsort' => 'คำเตือน: หลักเรียงลำดับปริยาย "$2" ได้ลบล้างหลักเรียงลำดับปริยาย "$1" ที่มีอยู่ก่อนหน้า',
	'dberr-header' => 'วิกินี้กำลังประสบปัญหา',
	'dberr-problems' => 'ขออภัย เว็บไซต์นี้กำลังพบกับข้อผิดพลาดทางเทคนิค',
	'dberr-again' => 'กรุณารอสักครู่แล้วจึงโหลดใหม่',
	'dberr-info' => '(ไม่สามารถติดต่อเซิร์ฟเวอร์ฐานข้อมูลได้: $1)',
	'dberr-usegoogle' => 'คุณสามารถลองสืบค้นผ่านกูเกิลในระหว่างนี้',
	'dberr-outofdate' => 'โปรดทราบว่าดัชนีเนื้อหาของเราในกูเกิลอาจล้าสมัยแล้ว',
	'dberr-cachederror' => 'นี่คือข้อมูลคัดลอกชั่วคราวของหน้าที่ร้องขอ และอาจไม่เป็นปัจจุบัน',
);

$messages['ti'] = array(
	'december' => 'ታኅሣሥ',
);

$messages['tk'] = array(
	'december' => 'dekabr',
	'december-gen' => 'dekabr',
	'dec' => 'dek',
	'delete' => 'Öçür',
	'deletethispage' => 'Bu sahypany öçür',
	'disclaimers' => 'Jogapkärçilikden boýun gaçyrma',
	'disclaimerpage' => 'Project:Umumy jogapkärçilikden boýun gaçyrma',
	'databaseerror' => 'Maglumat bazasynyň säwligi',
	'dberrortext' => 'Maglumat bazasy gözleginde sintaksis säwligi ýüze çykdy.
Onuň programmadaky bir säwlik bolmagy ahmal.
"<tt>$2</tt>" funksiýasyndan synalyp görülen iň soňky maglumat bazasy gözlegi:
<blockquote><tt>$1</tt></blockquote>.
Maglumat bazasy tarapyndan yzyna gaýtarylan säwlik "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Maglumat bazasy gözleginde sintaksis säwligi ýüze çykdy.
Iň soňky maglumat bazasy gözlegi:
"$1"
Ulanylan funksiýa "$2".
Maglumat bazasy tarapyndan yzyna gaýtarylan säwlik "$3: $4"',
	'directorycreateerror' => '"$1" direktoriýasyny döredip bolmady',
	'deletedhist' => 'Öçürilen geçmiş',
	'difference' => '(Wersiýalaryň aratapawudy)',
	'difference-multipage' => '(Sahypalaryň arasyndaky tapawut)',
	'diff-multi' => '({{PLURAL:$2|Bir ulanyjy|$2 ulanyjy}} tarapyndan edilen {{PLURAL:$1|aralyk wersiýa|$1 sany aralyk wersiýa}} görkezilmeýär)',
	'diff-multi-manyusers' => '($2 ulanyjydan köp {{PLURAL:$2|ulanyjy|ulanyjy}} tarapyndan edilen {{PLURAL:$1|aralyk wersiýa|$1 sany aralyk wersiýa}} görkezilmeýär)',
	'datedefault' => 'Gaýybana',
	'defaultns' => 'Bolmasa şu at giňişliklerinde gözleg geçiriň:',
	'default' => 'gaýybana',
	'diff' => 'tapawut',
	'destfilename' => 'Niýetlenilýän faýlyň ady:',
	'duplicatesoffile' => 'Aşakdaky {{PLURAL:$1|faýl|$1 faýl}} şu faýlyň dublikatydyr ([[Special:FileDuplicateSearch/$2|jikme-jik maglumat]]):',
	'download' => 'düşür',
	'disambiguations' => 'Dürli manyly sahypalar',
	'disambiguationspage' => 'Template:Dürli manylar',
	'disambiguations-text' => "Aşakdaky sahypalar '''dürli manyly sahypa''' çykgyt berýär.
Olar muňa derek degişli anyk sahypa çykgyt bermelidir.<br />
[[MediaWiki:Disambiguationspage]] sahypasyndan çykgyt berilýän bir şablony ulanýan bolsa, onda ol sahypa dürli manyly hökmünde çemeleşilýär.",
	'doubleredirects' => 'Jübüt gönükdirmeler',
	'doubleredirectstext' => 'Bu sahypa başga gönükdirme sahypalaryna gönükdirýän sahypalaryň sanawyny görkezýär.
Her bir hatar birinji we ikinji gönükdirmeleri, şeýle-de ikinji gönükdirmäniň maksady bolup durýan hem-de şol bir wagtyň özünde birinji gönükdirmäniň adatça barmaly ýeri bolan "hakyky" maksat edinilýän sahypany öz içine alýar.
<del>Üsti çyzylan</del> ýazgylar düzedilenlerdir.',
	'double-redirect-fixed-move' => '[[$1]] sahypasynyň ady üýtgedildi.
Ol indi [[$2]] sahypasyna gönükdirýär.',
	'double-redirect-fixer' => 'Gönükdirme bejeriji',
	'deadendpages' => 'Petige direýän sahypalar',
	'deadendpagestext' => 'Aşakdaky sahypalar {{SITENAME}} saýtyndaky başga sahypalara çykgyt bermeýär.',
	'deletedcontributions' => 'Öçürilen ulanyjy goşantlary',
	'deletedcontributions-title' => 'Öçürilen ulanyjy goşantlary',
	'defemailsubject' => '{{SITENAME}} e-poçtasy',
	'deletepage' => 'Sahypany öçür',
	'delete-confirm' => '"$1" sahypasyny öçür',
	'delete-legend' => 'Öçür',
	'deletedtext' => '"$1" öçürildi.
Ýaňy-ýakynda öçürilenleri görmek üçin: $2.',
	'dellogpage' => 'Öçürme gündeligi',
	'dellogpagetext' => 'Aşakdaky sanaw iň soňky öçürmeleriň sanawydyr.',
	'deletionlog' => 'öçürme gündeligi',
	'deletecomment' => 'Sebäp:',
	'deleteotherreason' => 'Başga/goşmaça sebäp:',
	'deletereasonotherlist' => 'Başga sebäpler',
	'deletereason-dropdown' => '*Adaty öçürme sebäpleri
** Awtoryň talaby
** Awtorlyk hukugynyň bozulmagy
** Wandalizm',
	'delete-edit-reasonlist' => 'Öçürme sebäplerini redaktirle',
	'delete-toobig' => 'Bu sahypanyň $1 {{PLURAL:$1|wersiýadan|wersiýadan}} agdyk uly özgerdiş geçmişi bar.
{{SITENAME}} saýtynyň atdanlykda bökdelmegine ýol bermezlik maksady bilen beýle sahypalaryň öçürilmegi çäklendirilýär.',
	'delete-warning-toobig' => 'Bu sahypanyň $1 {{PLURAL:$1|wersiýadan|wersiýadan}} agdyk uly özgerdiş geçmişi bar.
Muny öçürmek {{SITENAME}} maglumat bazasynyň amallaryna päsgel berip biler;
seresaplyk bilen hereket ediň.',
	'databasenotlocked' => 'Maglumat bazasy gulply däl.',
	'delete_and_move' => 'Öçür we adyny üýtget',
	'delete_and_move_text' => '== Öçürilmegi zerur ==
Niýetlenilýän "[[:$1]]" sahypasy eýýäm bar.
Ady üýgetmek üçin ony öçürmek isleýärsiňizmi?',
	'delete_and_move_confirm' => 'Hawa, sahypany öçür',
	'delete_and_move_reason' => 'At üýtgetmeklik üçin öçürildi',
	'djvu_page_error' => 'DjVu sahypasy elýeterden daşda',
	'djvu_no_xml' => 'DjVu faýly üçin XML alyp bolmaýar',
	'deletedrevision' => '$1 köne wersiýasy öçürildi.',
	'deletedwhileediting' => "'''Duýduryş''': Bu sahypa siz redaktirläp başlanyňyzdan soňra öçürildi!",
	'descending_abbrev' => 'uludan kiçä',
	'duplicate-defaultsort' => '\'\'\'Duýduryş\'\'\': Gaýybana "$2" sortlaýyş açary mundan ozalky "$1" sortlaýyş açaryny aradan aýyrýar.',
	'dberr-header' => 'Bu wikiniň bir problemasy bar',
	'dberr-problems' => 'Bagyşlaň! Bu saýtda tehniki kynçylyklar ýüze çykdy.',
	'dberr-again' => 'Birnäçe minut garaşyň we gaýtadan ýükläp görüň.',
	'dberr-info' => '(Maglumat bazasynyň serwerine birigip bolanok: $1)',
	'dberr-usegoogle' => 'Ýogsa-da, oňa çenli Google bilen gözleg geçirip bilersiňiz.',
	'dberr-outofdate' => 'Olaryň biziň sahypalarymyz baradaky indeksi köne bolmagy mümkin.',
	'dberr-cachederror' => 'Bu talap edilen sahypanyň keşirlenen nusgasy bolup, soňky üýtgeşmeleri görkezmezligi mümkin.',
);

$messages['tl'] = array(
	'december' => 'Disyembre',
	'december-gen' => 'Disyembre',
	'dec' => 'Dis',
	'delete' => 'Burahin',
	'deletethispage' => 'Burahin itong pahina',
	'disclaimers' => 'Mga pagtatanggi',
	'disclaimerpage' => 'Project:Pangkalahatang pagtatanggi',
	'databaseerror' => 'Kamalian sa kalipunan ng dato',
	'dberrortext' => 'Nagkaroon po ng isang pagkakamali sa usisang pampalaugnayan sa kalipunan ng datos.
Maaaring dahil ito sa depekto sa sopwer (\'\'software\'\').
Ang huling sinubukang paguusisa sa kalipunan ng datos ay:
<blockquote><tt>$1</tt></blockquote>
mula sa gawaing "<tt>$2</tt>".
Ibinalik ng kalipunan ng datos ang kamaliang "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Nagkaroon po ng isang pagkakamali sa usisang pampalaugnayan sa kalipunan ng datos.
Ang huling sinubukang paguusisa sa kalipunan ng datos ay:
"$1"
mula sa gawaing "$2".
Ibinalik ng kalipunan ng datos ang kamaliang "$3: $4"',
	'directorycreateerror' => 'Hindi malikha ang direktoryong "$1".',
	'deletedhist' => 'Naburang kasaysayan',
	'difference' => '(Pagkakaiba sa pagitan ng mga pagbabago)',
	'difference-multipage' => '(Pagkakaiba sa pagitan ng mga pahina)',
	'diff-multi' => '({{PLURAL:$1|Isang panggitnang pagbabago|$1 panggitnang mga pagbabago}} ng {{PLURAL:$2|isang tagagamit|$2 mga tagagamit}} ang hindi ipinakikita.)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Isang panggitnang pagbabago|$1 panggitnang mga pagbabago}} ng {{PLURAL:$2|isang tagagamit|$2 mga tagagamit}} ang hindi ipinapakikita.)',
	'datedefault' => 'Walang kagustuhan',
	'defaultns' => 'O kaya maghanap sa mga pangalan ng espasyong ito:',
	'default' => 'Likas na pagtatakda',
	'diff' => 'pagkakaiba',
	'destfilename' => 'Pangalan ng patutunguhang talaksan:',
	'duplicatesoffile' => 'Ang sumusunod na {{PLURAL:$1|file is a duplicate|$1 mga talaksan ay mga kapareho}} ng talaksang ito ([[Special:FileDuplicateSearch/$2|mas marami pang mga detalye]]):',
	'download' => "magkargang-pakuha ng talaksan (''download'')",
	'disambiguations' => 'Mga pahina ng paglilinaw',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Ang sumusunod ay mga pahinang may ugnay (link) sa isang '''pahinang naglilinaw'''.
Dapat silang umugnay sa tamang paksa<br />
Tinuturing ang isang pahina bilang pahinang naglilinaw kung ginagamit nito ang isang suleras (template) na nakaugnay mula sa [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Mga dobleng karga',
	'doubleredirectstext' => 'Nagtatala ang pahinang ito ng mga pahinang pumupunta sa iba pang mga pahinang nililipatan.  Naglalaman ang bawat hanay ng mga kawing sa una ang pangalawang kapupuntahan, maging ng puntiryang pangalawang kapupuntahan, na karaniwang "tunay" na puntiryang pahina, na dapat kinatuturuan ng unang pupuntahan.
Nasugpo na ang mga ipinasok na <del>inekisan</del>.',
	'double-redirect-fixed-move' => 'Inilipat na ang [[$1]], isa na ngayon itong panuto/panturo patungo sa [[$2]]',
	'double-redirect-fixed-maintenance' => 'Inaayos ang mga pagpapapuntang nagkadalawa magmula [[$1]] papunta sa [[$2]].',
	'double-redirect-fixer' => 'Tagapagayos ng panuto/panturo',
	'deadendpages' => 'Mga pahinang walang panloob na ugnay (internal link)',
	'deadendpagestext' => "Ang mga sumusunod na mga pahina'y hindi umuugnay sa ibang mga pahina sa wiking ito.",
	'deletedcontributions' => 'Naburang ambag ng tagagamit',
	'deletedcontributions-title' => 'Naburang ambag ng tagagamit',
	'defemailsubject' => 'E-liham ng {{SITENAME}}',
	'deletepage' => 'Burahin ang pahina',
	'delete-confirm' => 'Burahin "$1"',
	'delete-legend' => 'Burahin',
	'deletedtext' => 'Nabura na ang "$1".  Tingnan ang $2 para sa talaan ng kamakailan lamang na mga pagbubura.',
	'dellogpage' => 'Talaan ng pagbubura',
	'dellogpagetext' => 'Nasa ibaba ang isang talaan ng pinakakamailan lamang na mga pagbubura.',
	'deletionlog' => 'tala ng pagbubura',
	'deletecomment' => 'Dahilan:',
	'deleteotherreason' => 'Iba pa/karagdagang dahilan:',
	'deletereasonotherlist' => 'Ibang dahilan',
	'deletereason-dropdown' => '*Pangkaraniwang mga dahilan ng pagbura
** Kahilingan ng may-akda
** Paglabag sa karapatang-ari/kopirayt
** Bandalismo',
	'delete-edit-reasonlist' => 'Baguhin ang mga dahilan ng pagbura',
	'delete-toobig' => 'May isang malaking kasaysayan ng pagbabago ang pahinang ito, mahigit sa $1 {{PLURAL:$1|pagbabago|mga pagbabago}}.
Ipanagbabawal ang pagbura ng ganyang mga pahina upang maiwasan ang hindi sinasadyang pagantala/paggambala sa {{SITENAME}}.',
	'delete-warning-toobig' => 'May malaking kasaysayan ng pagbabago ang pahinang ito, mahigit sa $1 {{PLURAL:$1|pagbabago|mga pagbabago}}.
Maaaring makagambala/makaabala sa pagpapatakbo sa kalipunan ng dato ng {{SITENAME}};
magpatuloy na may pagiingat.',
	'databasenotlocked' => 'Hindi nakakandado ang kalipunan ng datos.',
	'delete_and_move' => 'Burahin at ilipat',
	'delete_and_move_text' => '==Kinakailangan ang pagbura==

Mayroon na ang pupuntahang artikulo na "[[$1]]". Nais mo bang burahin ito para magbigay daan para sa paglipat?',
	'delete_and_move_confirm' => 'Oo, burahin ang pahina',
	'delete_and_move_reason' => 'Binura upang makalipat',
	'djvu_page_error' => 'Wala sa nasasakupan ang pahinang DjVu',
	'djvu_no_xml' => 'Hindi makuha ang XML para sa talaksang DjVu',
	'deletedrevision' => 'Binurang lumang pagbabago $1',
	'deletedwhileediting' => 'Babala: Binura ang pahinang ito pagkaraan mong simulan ang pagbago!',
	'descending_abbrev' => 'baba',
	'duplicate-defaultsort' => 'Babala: Madadaig ng susi ng pagtatakdang "$2" ang mas naunang susi ng pagtatakdang "$1".',
	'dberr-header' => 'May isang suliranin ang wiking ito',
	'dberr-problems' => 'Paumanhin! Dumaranas ng mga kahirapang teknikal ang sityong ito.',
	'dberr-again' => 'Subuking maghintay ng ilang mga minuto at muling magkarga.',
	'dberr-info' => '(Hindi makaugnay sa tagapaghain ng kalipunan ng dato: $1)',
	'dberr-usegoogle' => 'Pansamantalang maaaring subukin mong maghanap muna sa pamamagitan ng Google.',
	'dberr-outofdate' => 'Pakiunawang maaaring wala na sa panahon ang kanilang mga talatuntunan ng aming mga nilalaman.',
	'dberr-cachederror' => 'Ang sumusunod ay isang nakatagong sipi ng hiniling na pahina, at maaaring wala na sa panahon.',
);

$messages['tn'] = array(
	'december' => 'Sedimonthole',
	'december-gen' => 'Sedimonthole',
	'delete' => 'Sutlha',
	'disclaimers' => 'Tlhapa diatla',
);

$messages['to'] = array(
	'december' => 'Tisema',
	'december-gen' => 'Tisema',
	'dec' => 'Tis',
	'delete' => 'Tāmateʻi',
	'deletethispage' => 'Tāmateʻi he pēsí ni',
	'disclaimers' => 'Ngaahi fakaʻataʻatā',
	'disclaimerpage' => 'Project:Fakaʻataʻatā lūkufua',
	'databaseerror' => 'Halaʻi tānekingaʻilo',
	'difference' => '(Kehekehe he ongo paaki)',
	'diff-multi' => '(Naʻe ʻikai ʻasi mai ʻa e paaki lotoloto ʻe $1).',
	'datedefault' => 'ʻIkai ha faʻiteliha',
	'defaultns' => 'Kumi ʻi he vā hingoa fakatuʻunga:',
	'default' => 'tuʻunga',
	'diff' => 'kehe',
	'destfilename' => 'Hingoa ʻo e faile ʻe ʻalu ki ai:',
	'download' => 'hiki hifo',
	'disambiguations' => 'Peesi fakaʻuhingakehe',
	'disambiguationspage' => 'Template:Fakaʻuhingakehe',
	'disambiguations-text' => "ʻOku ʻi ai haʻanau fehokotaki ki ha '''Peesi fakaʻuhingakehe''' maʻa e ngaahi kupu ʻoku ʻasi ʻi lalo. ʻE taau ʻo ʻenau fehokotaki ki he kupu totonu. ʻOku kau ʻa e kupu ki he peesi fakaʻuhingakehe kapau ʻoku ngāueʻaki ha sīpinga ʻoku ʻasi ʻi he  [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Ngaahi leʻeleʻei',
	'doubleredirectstext' => 'ʻOku ʻasi ʻi he ʻotu kotoa pē ha ongo fehokotaki ki he leʻei, mo e leʻeleʻei, mo e kamataʻanga ʻo e leʻeleʻei, taimi ʻe niʻihi ko e peesi totonu ia, ʻoku taau ʻe tuhu ki ai ʻe he leʻei.',
	'deadendpages' => 'Peesi ngata-mate',
	'deletedcontributions' => 'Ngaahi foaki ʻo ha ʻetita kuo tāmateʻi',
	'deletedcontributions-title' => 'Ngaahi foaki ʻo ha ʻetita kuo tāmateʻi',
	'defemailsubject' => 'Ko e tohila ʻo e {{SITENAME}}',
	'deletepage' => 'Tāmateʻi peesi',
	'deletedtext' => 'Kuo tāmateʻi "$1"
Vakai ki he $2 maʻa e fakamatala ʻo e ngaahi toki tāmateʻi.',
	'dellogpage' => 'Tohinoa ʻo e tāmateʻi',
	'dellogpagetext' => 'ʻOku ʻasi ʻi lalo ha hokohoko ʻo e ngaahi tāmateʻi fakamuimui taha.',
	'deletionlog' => 'tohinoa ʻo e tāmateʻi',
	'deletecomment' => 'ʻUhinga',
	'databasenotlocked' => 'ʻOku ʻikai lokaʻi ʻa e tānekingaʻilo',
	'delete_and_move' => 'Tāmateʻi pea ʻunu',
	'delete_and_move_text' => '==Fiemaʻu tāmateʻi==

ʻOku toka tuʻu ʻa e kupu pehē "[[:$1]]". ʻOku ke fietāmateʻi ia ke fakaʻatā he ʻunu?',
	'delete_and_move_confirm' => 'ʻIo, tāmateʻi e pēsí',
	'delete_and_move_reason' => 'Kuo tāmateʻi maʻa e fakaʻatā he ʻunu',
	'deletedrevision' => 'Kuo tāmateʻi he paaki motuʻa $1.',
	'deletedwhileediting' => 'Tokanga: Naʻe tāmateʻi he pēsí ni ʻosi hoʻo kamataʻanga tohi!',
	'descending_abbrev' => 'hifo',
);

$messages['tokipona'] = array(
	'december' => 'tenpo mun pi nanpa luka luka tu',
	'delete' => 'o weka',
	'deletethispage' => 'o weka e lipu ni',
	'disclaimers' => 'wile ala',
);

$messages['tpi'] = array(
	'december' => 'Disemba',
	'december-gen' => 'Disemba',
	'dec' => 'Dis',
	'delete' => 'Rausim',
	'deletethispage' => 'Rausim dispela pes',
	'disclaimers' => 'Ol toksave bilong lo',
	'disclaimerpage' => 'Project:Ol tok warn long lo',
	'datedefault' => 'Nogat laik',
	'diff' => 'dispela senis',
	'defemailsubject' => '{{SITENAME}} e-mel',
	'deletepage' => 'Rausim dispela pes',
	'delete-confirm' => 'Rausim $1',
	'delete-legend' => 'Rausim',
	'dellogpage' => 'Ripot long rausim ol pes',
	'deletecomment' => 'As bilong en:',
	'deletereasonotherlist' => 'Arapela as bilong en',
);

$messages['tr'] = array(
	'december' => 'Aralık',
	'december-gen' => 'Aralık',
	'dec' => 'Ara',
	'delete' => 'sil',
	'deletethispage' => 'Sayfayı sil',
	'disclaimers' => 'Sorumluluk reddi',
	'disclaimerpage' => 'Project:Genel sorumluluk reddi',
	'databaseerror' => 'Veritabanı hatası',
	'dberrortext' => 'Veritabanı sorgu sözdizimi hatası oluştu.
Bu yazılımdaki bir hatadan kaynaklanabilir.
"<tt>$2</tt>" işlevinden denenen son sorgulama:
<blockquote><tt>$1</tt></blockquote>.
Veritabanının rapor ettiği hata "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Veritabanı sorgu sözdizimi hatası oluştu.
Son yapılan veritabanı sorgusu:
"$1"
Kullanılan fonksiyon "$2".
Veritabanının verdiği hata mesajı "$3: $4"',
	'directorycreateerror' => '"$1" dizini oluşturulamadı',
	'deletedhist' => 'Silinmiş geçmiş',
	'difference' => '(Sürümler arası farklar)',
	'difference-multipage' => '(Sayfalar arasındaki fark)',
	'diff-multi' => '({{PLURAL:$2|Bir kullanıcı|$2 kullanıcı}} tarafından yapılan {{PLURAL:$1|bir ara revizyon|$1 ara revizyon}} gösterilmiyor)',
	'diff-multi-manyusers' => '($2 kullancıdan fazla {{PLURAL:$2|kullanıcı|kullanıcı}} tarafından yapılan {{PLURAL:$1|bir ara revizyon|$1 ara revizyon}} gösterilmiyor)',
	'datedefault' => 'Tercih yok',
	'defaultns' => 'Aksi halde bu ad alanlarında ara:',
	'default' => 'orijinal',
	'diff' => 'fark',
	'destfilename' => 'Hedef dosya adı:',
	'duplicatesoffile' => 'Şu {{PLURAL:$1|dosya|$1 dosya}}, bu dosyanın kopyası ([[Special:FileDuplicateSearch/$2|daha fazla ayrıntı]]):',
	'download' => 'yükle',
	'disambiguations' => 'Anlam ayrım sayfalarına bağlantısı olan sayfalar',
	'disambiguationspage' => 'Template:Anlam ayrımı',
	'disambiguations-text' => 'İlk satırda yer alan sayfalar bir anlam ayrım sayfasına iç bağlantı olduğunu gösterir. İkinci sırada yer alan sayfalar anlam ayrım sayfalarını gösterir. <br />Burada [[MediaWiki:Disambiguationspage]] tüm anlam ayrım şablonlarına bağlantılar verilmesi gerekmektedir.',
	'doubleredirects' => 'Çift yönlendirmeler',
	'doubleredirectstext' => 'Bu sayfa diğer yönlendirme sayfalarına yönlendirme yapan sayfaları listeler.
Her satırın içerdiği bağlantılar; birinci ve ikinci yönlendirme, ayrıca ikinci yönlendirmenin hedefi, ki bu genelde birinci yönlendirmenin göstermesi gereken "gerçek" hedef sayfasıdır.
<del>Üstü çizili</del> girdiler çözülmüştür.',
	'double-redirect-fixed-move' => '[[$1]] taşındı, artık [[$2]] sayfasına yönlendiriyor',
	'double-redirect-fixed-maintenance' => '[[$1]] - [[$2]] yapılan çift yönlendirme düzeltiliyor.',
	'double-redirect-fixer' => 'Yönlendirme tamircisi',
	'deadendpages' => 'Başka sayfalara bağlantısı olmayan sayfalar',
	'deadendpagestext' => 'Aşağıdaki sayfalar, {{SITENAME}} sitesinde diğer sayfalara bağlantı vermiyor.',
	'deletedcontributions' => 'Silinen kullanıcı katkıları',
	'deletedcontributions-title' => 'Silinen kullanıcı katkıları',
	'defemailsubject' => '"$1" kullanıcısından {{SITENAME}} e-postası',
	'deletepage' => 'Sayfayı sil',
	'delete-confirm' => '"$1" sil',
	'delete-legend' => 'sil',
	'deletedtext' => '"$1" silindi.
Yakın zamanda silinenleri görmek için: $2.',
	'dellogpage' => 'Silme kayıtları',
	'dellogpagetext' => 'Aşağıdaki liste son silme kayıtlarıdır.',
	'deletionlog' => 'silme kayıtları',
	'deletecomment' => 'Neden:',
	'deleteotherreason' => 'Diğer/ilave neden:',
	'deletereasonotherlist' => 'Diğer nedenler',
	'deletereason-dropdown' => '*Genel silme gerekçeleri
** Yazarın talebi
** Telif hakları ihlali
** Vandalizm',
	'delete-edit-reasonlist' => 'Silme nedenlerini değiştir',
	'delete-toobig' => 'Bu sayfa, $1 {{PLURAL:$1|tane değişiklik|tane değişiklik}} ile çok uzun bir geçmişe sahiptir.
Böyle sayfaların silinmesi, {{SITENAME}} sitesini bozmamak için sınırlanmaktadır.',
	'delete-warning-toobig' => 'Bu sayfanın büyük bir değişiklik geçmişi var, $1 {{PLURAL:$1|revizyonun|revizyonun}} üzerinde.
Bunu silmek {{SITENAME}} işlemlerini aksatabilir;
dikkatle devam edin.',
	'databasenotlocked' => 'Veritabanı kilitli değil.',
	'delete_and_move' => 'Sil ve taşı',
	'delete_and_move_text' => '==Silinmesi gerekiyor==

"[[:$1]]" isimli bir sayfa zaten mevcut. O sayfayı silerek, isim değişikliğini gerçekleştirmeye devam etmek istiyor musunuz?',
	'delete_and_move_confirm' => 'Evet, sayfayı sil',
	'delete_and_move_reason' => '[[$1]] sayfasının isim değişikliğinin gerçekleşmesi için silindi.',
	'djvu_page_error' => 'DjVu sayfası kapsamdışı',
	'djvu_no_xml' => 'DjVu dosyası için XML alınamıyor',
	'deletedrevision' => '$1 sayılı eski sürüm silindi.',
	'days' => '{{PLURAL:$1|$1 gün|$1 gün}}',
	'deletedwhileediting' => "'''Uyarı''': Bu sayfa siz değişiklik yapmaya başladıktan sonra silinmiş!",
	'descending_abbrev' => 'azalan',
	'duplicate-defaultsort' => '\'\'\'Uyarı:\'\'\' Varsayılan "$2" sınıflandırma anahtarı, önceki "$1" sınıflandırma anahtarını geçersiz kılıyor.',
	'dberr-header' => 'Bu vikinin bir sorunu var',
	'dberr-problems' => 'Üzgünüz! Bu site teknik zorluklar yaşıyor.',
	'dberr-again' => 'Bir kaç dakika bekleyip tekrar yüklemeyi deneyin.',
	'dberr-info' => '(Veritabanı sunucusuyla irtibat kurulamıyor: $1)',
	'dberr-usegoogle' => 'Bu zaman zarfında Google ile aramayı deneyebilirsiniz.',
	'dberr-outofdate' => 'İçeriğimizin onların dizinlerinde güncel olmayabileceğini dikkate alın.',
	'dberr-cachederror' => 'Aşağıdaki istenen sayfanın önbellekteki bir kopyasıdır, ve güncel olmayabilir.',
	'discuss' => 'Tartış',
);

$messages['ts'] = array(
	'december' => "N'wendzamhala",
	'delete' => 'Sula',
	'deletethispage' => 'Sula tluka leri',
	'disclaimers' => 'Swi alanandzu',
	'disclaimerpage' => 'Project:Swithsuxa nadzu hikuangara',
	'databaseerror' => 'Xihoxo xo Database',
	'deletedhist' => 'Matimu lamasuriweke',
);

$messages['tt-cyrl'] = array(
	'december' => 'декабрь',
	'december-gen' => 'декабрь',
	'dec' => 'дек',
	'delete' => 'Бетерү',
	'deletethispage' => 'Бу битне бетерү',
	'disclaimers' => 'Җаваплылыктан баш тарту',
	'disclaimerpage' => 'Project:Җаваплылыктан баш тарту',
	'databaseerror' => 'Мәгълүматлар базасында хата',
	'dberrortext' => 'Мәгълүматлар базасына җибәрелгән сорауда синтаксик хата табылды.
Программада хата булырга мөмкин.
Мәгълүматлар базасына җибәрелгән соңгы сорау:
<blockquote><tt>$1</tt></blockquote>
<tt>«$2»</tt> функциясеннән.
База <tt>«$3: $4»</tt> хатасын кайтарды.',
	'dberrortextcl' => 'Мәгълүматлар базасына җибәрелгән сорауда синтаксик хата табылды.
Мәгълүматлар базасына җибәрелгән соңгы сорау:
"$1"
«$2» функциясеннән.
База «$3: $4» хатасын кайтарды.',
	'directorycreateerror' => '«$1» директориясен ясап булмый.',
	'deletedhist' => 'Бетерүләр тарихы',
	'difference' => '(Юрамалар арасында аерма)',
	'datedefault' => 'Баштагы көйләнмәләр',
	'defaultns' => 'Алайса менә бу исемнәр мәйданында эзләү',
	'default' => 'килешү буенча',
	'diff' => 'аерма',
	'destfilename' => 'Файлның яңа исеме:',
	'duplicatesoffile' => '{{PLURAL:$1|Әлеге $1 файл }} астагы файлның күчерелмәсе булып тора ([[Special:FileDuplicateSearch/$2|тулырак]]):',
	'download' => 'йөкләү',
	'disambiguations' => 'Күп мәгънәле сүзләр турында битләр',
	'disambiguationspage' => 'Template:disambig',
	'doubleredirects' => 'Икеләтә юнәлтүләр',
	'deadendpages' => 'Тупик битләре',
	'defemailsubject' => '{{SITENAME}}: хат',
	'deletepage' => 'Битне бетерү',
	'delete-confirm' => '«$1» бетерү',
	'delete-legend' => 'Бетерү',
	'deletedtext' => '«$1» бетерелгән инде.<br />
Соңгы бетерелгән битләрне күрер өчен, $2 карагыз.',
	'dellogpage' => 'Бетерү көндәлеге',
	'deletionlog' => 'бетерү көндәлеге',
	'deletecomment' => 'Сәбәп:',
	'deleteotherreason' => 'Башка/өстәмә сәбәп:',
	'deletereasonotherlist' => 'Башка сәбәп',
	'deletereason-dropdown' => '* Бетерүнең сәбәпләре
** вандаллык
** автор соравы буенча
** автор хокукларын бозу',
	'delete-edit-reasonlist' => 'Сәбәпләр исемлеген үзгәртү',
	'delete_and_move' => 'Бетерү һәм исемен алмаштыру',
	'delete_and_move_reason' => 'Күчерүне мөмкин итәр өчен бетерелде',
	'deletedrevision' => '$1 битенең иске юрамасы бетерелде',
	'descending_abbrev' => 'кимү',
	'dberr-header' => 'Бу вики авырлык кичерә',
	'dberr-problems' => 'Гафу итегез! Сайтта техник кыенлыклар чыкты.',
	'dberr-again' => 'Сәхифәне берничә минуттан соң яңартып карагыз.',
	'dberr-info' => '(Мәгълүматлар базасы серверы белән тоташырга мөмкин түгел: $1)',
);

$messages['tt-latn'] = array(
	'december' => 'dekaber',
	'december-gen' => 'dekaber',
	'dec' => 'dek',
	'delete' => 'Beterü',
	'deletethispage' => 'Bu bitne beterü',
	'disclaimers' => 'Cawaplılıqtan baş tartu',
	'disclaimerpage' => 'Project:Cawaplılıqtan baş tartu',
	'databaseerror' => 'Mäğlümatlar bazasında xata',
	'dberrortext' => 'Mäğlümatlar bazasına cibärelgän sorawda sintaksik xata tabıldı.
Programmada xata bulırğa mömkin.
Mäğlümatlar bazasına cibärelgän soñğı soraw:
<blockquote><tt>$1</tt></blockquote>
<tt>«$2»</tt> funksiäsennän.
Baza <tt>«$3: $4»</tt> xatasın qaytardı.',
	'dberrortextcl' => 'Mäğlümatlar bazasına cibärelgän sorawda sintaksik xata tabıldı.
Mäğlümatlar bazasına cibärelgän soñğı soraw:
"$1"
«$2» funksiäsennän.
Baza «$3: $4» xatasın qaytardı.',
	'directorycreateerror' => '«$1» direktoriäsen yasap bulmıy.',
	'deletedhist' => 'Beterülär tarixı',
	'difference' => '(Yuramalar arasında ayırma)',
	'datedefault' => 'Baştağı köylänmälär',
	'defaultns' => 'Alaysa menä bu isemnär mäydanında ezläw',
	'default' => 'kileşü buyınça',
	'diff' => 'ayırma',
	'destfilename' => 'Faylnıñ yaña iseme:',
	'duplicatesoffile' => '{{PLURAL:$1|Älege $1 fayl }} astağı faylnıñ küçerelmäse bulıp tora ([[Special:FileDuplicateSearch/$2|tulıraq]]):',
	'download' => 'yökläw',
	'disambiguations' => 'Küp mäğnäle süzlär turında bitlär',
	'doubleredirects' => 'İkelätä yünältülär',
	'deadendpages' => 'Tupik bitläre',
	'defemailsubject' => '{{SITENAME}}: xat',
	'deletepage' => 'Bitne beterü',
	'delete-confirm' => '«$1» beterü',
	'delete-legend' => 'Beterü',
	'deletedtext' => '«$1» beterelgän inde.<br />
Soñğı beterelgän bitlärne kürer öçen, $2 qarağız.',
	'dellogpage' => 'Beterü köndälege',
	'deletionlog' => 'beterü köndälege',
	'deletecomment' => 'Säbäp:',
	'deleteotherreason' => 'Başqa/östämä säbäp:',
	'deletereasonotherlist' => 'Başqa säbäp',
	'deletereason-dropdown' => '* Beterüneñ säbäpläre
** vandallıq
** avtor sorawı buyınça
** avtor xoquqların bozu',
	'delete-edit-reasonlist' => 'Säbäplär isemlegen üzgärtü',
	'delete_and_move' => 'Beterü häm isemen almaştıru',
	'delete_and_move_reason' => 'Küçerüne mömkin itär öçen beterelde',
	'deletedrevision' => '$1 biteneñ iske yuraması beterelde',
	'descending_abbrev' => 'kimü',
	'dberr-header' => 'Bu wiki awırlıq kiçerä',
	'dberr-problems' => 'Ğafu itegez! Saytta texnik qıyınlıqlar çıqtı.',
);

$messages['ty'] = array(
	'december' => 'nō tītema',
	'december-gen' => 'nō tītema',
	'dec' => 'nō tītema',
	'delete' => 'Fa’a’ore',
);

$messages['tyv'] = array(
	'december' => 'Он ийи ай',
	'december-gen' => 'Он ийи ай',
	'dec' => '12.ай',
	'delete' => 'Ап каары',
	'deletethispage' => 'Бо арынны ап каар',
	'disclaimers' => 'Ажыглаарынка чомпээрежил',
	'databaseerror' => 'Медээ шыгжамыры алдаг',
	'default' => 'ниити',
	'diff' => 'ылгал',
	'download' => 'алыры',
	'defemailsubject' => '{{grammar:ablative|{{SITENAME}}}} э-чагаа',
	'deletepage' => 'Арынны ап каары',
	'deletedarticle' => '"[[$1]]" деп арынны ап каан',
	'deletecomment' => 'Чылдагаан:',
	'deleteotherreason' => 'Өске/немелде чылдагаан:',
	'deletereasonotherlist' => 'Өске чылдагаан',
	'delete_and_move' => 'Ап каар болгаш шимчээр',
);

$messages['udm'] = array(
	'december' => 'толсур',
	'december-gen' => 'толсурэ',
	'dec' => 'тст',
	'delete' => 'Быдтыны',
	'delete_and_move' => 'Быдтыны но мукет интые выжтыны',
);

$messages['ug'] = array(
	'december' => 'толсур',
	'december-gen' => 'толсурэ',
	'dec' => 'тст',
	'delete' => 'Быдтыны',
	'delete_and_move' => 'Быдтыны но мукет интые выжтыны',
);

$messages['ug-arab'] = array(
	'december' => 'كۆنەك',
	'december-gen' => 'كۆنەك',
	'dec' => 'كۆنەك',
	'delete' => 'ئۆچۈر',
	'deletethispage' => 'بۇ بەتنى ئۆچۈر',
	'disclaimers' => 'جاۋابكارلىقنى كەچۈرۈم قىلىش باياناتى',
	'disclaimerpage' => 'Project:ئادەتتىكى جاۋابكارلىقنى كەچۈرۈم قىلىش باياناتى',
	'databaseerror' => 'ساندان خاتالىقى',
	'dberrortext' => 'ساندان سۈرۈشتۈرۈشتە گرامماتىكىلىق خاتالىق يۈز بەردى.
يۇمشاق دېتالنىڭ ئۆزىدىكى خاتالىقتىن كېلىپ چىققان بولۇشى مۇمكىن.
ئاخىرقى قېتىملىق ساندان سۈرۈشتۈرۈش بۇيرۇقى:
<blockquote><tt>$1</tt></blockquote>
 \\"<tt>$2</tt>\\"فۇنكسىيىدىن كەلگەن.
MySQL قايتۇرغان خاتالىق \\"<tt>$3: $4</tt>\\".',
	'dberrortextcl' => 'ساندان سۈرۈشتۈرۈشتە گرامماتىكىلىق خاتالىق يۈز بەردى.
ئاخىرقى قېتىملىق ساندان سۈرۈشتۈرۈش بۇيرۇقى:
"$1"
"$2" فۇنكسىيىدىن كەلگەن.
MySQL قايتۇرغان خاتالىقى"$3: $4"',
	'directorycreateerror' => '"$1" مۇندەرىجىنى قۇرالمىدى.',
	'deletedhist' => 'ئۆچۈرۈلگەن تارىخ',
	'difference' => '(تۈزەتكەن نەشرىلىرىنىڭ پەرقى)',
	'difference-multipage' => '(بەتلەر ئارىسىدىكى پەرق)',
	'diff-multi' => '({{PLURAL:$2|ئىشلەتكۈچى|$2 ئىشلەتكۈچى}} نىڭ{{PLURAL:$1|تۈزىتىلگەن نەشرى|$1 تۈزىتىلگەن نەشرى}} كۆرسىتىلمىدى)',
	'diff-multi-manyusers' => '( $2  دىن كۆپ{{PLURAL:$2|ئىشلەتكۈچى|ئىشلەتكۈچى}} نىڭ {{PLURAL:$1|تۈزىتىلگەن نەشرى|$1 تۈزىتىلگەن نەشرى}}  كۆرسىتىلمىدى)',
	'datedefault' => 'مايىللىق يوق',
	'defaultns' => 'بولمىسا بۇ ئات بوشلۇقلىرىدىن ئىزدە:',
	'default' => 'كۆڭۈلدىكى',
	'diff' => 'پەرق',
	'destfilename' => 'نىشان ھۆججەت ئاتى:',
	'duplicatesoffile' => 'تۆۋەندىكى {{PLURAL:$1|ھۆججەت|$1 ھۆججەت}}  بۇ ھۆججەت بىلەن تەكرارلانغان  ([[Special:FileDuplicateSearch/$2|تېخىمۇ كۆپ تەپسىلاتى]]):',
	'download' => 'چۈشۈر',
	'disambiguations' => 'ئىككى بىسلىق بەتنى يوقىتىش',
	'disambiguationspage' => 'Template:ئىككى بىسلىق بەت',
	'disambiguations-text' => "تۆۋەندىكى بەت '''ئىككى بىسلىق بەت'''كە ئۇلانغان.
ئەمما ئۇلار مۇۋاپىق ماۋزۇغا ئۇلىنىشى كېرەك ئىدى.<br />
ئەگەر بىر بەت [[MediaWiki:Disambiguationspage]] غا ئۇلانغان بولسا ئىككى بىسلىق بەت دەپ قارىلىدۇ.",
	'doubleredirects' => 'قوش قايتا نىشانلانغان بەت',
	'doubleredirectstext' => 'بۇ بەتتە قايتا نىشانلانغان بەت يەنە بىر قايتا نىشانلانغان بەتنى نىشانغانلىق تىزىملىكى كۆرسىتىلدى.
ھەر بىر قۇردا بىرىنچى ۋە ئىككىنچى قايتا نىشانلانغان بەتنىڭ ئۇلانمىسىنى شۇنداقلا ئىككىنچى قايتا نىشانلانغان بەتنىڭ نىشانىنى ئۆز ئىچىگە ئالىدۇ، ئادەتتە كۆرسىتىلىدىغىنى  "ھەقىقىي" نىشان بەت، مۇنداقچە ئېيتقاندا بىرىنچى نىشانلانغان بەت نىشانلايدىغان بەتتۇر.',
	'double-redirect-fixed-move' => '[[$1]] يۆتكەلدى.\\n
ھازىر [[$2]] نى قايتا نىشانلىدى.',
	'double-redirect-fixed-maintenance' => '[[$1]] دىن [[$2]] غا قوش قايتا نىشانلاشنى ئوڭشاۋاتىدۇ.',
	'double-redirect-fixer' => 'قايتا نىشانلانغان تۈزەتكۈچ',
	'deadendpages' => 'ئۇلىنىشى ئۈزۈلگەن بەت',
	'deadendpagestext' => 'تۆۋەندىكى بەتلەر {{SITENAME}} دىكى باشقا بەتلەرگە ئۇلانمىغان.',
	'deletedcontributions' => 'ئۆچۈرۈلگەن ئىشلەتكۈچى تۆھپىسى',
	'deletedcontributions-title' => 'ئۆچۈرۈلگەن ئىشلەتكۈچى تۆھپىسى',
	'defemailsubject' => '{{SITENAME}}بېكەتتىكى "$1" ئىشلەتكۈچىنىڭ ئېلخەت',
	'deletepage' => 'بەت ئۆچۈر',
	'delete-confirm' => 'ئۆچۈر "$1"',
	'delete-legend' => 'ئۆچۈر',
	'deletedtext' => '"$1" ئۆچۈرۈلدى.
 يېقىندا ئۆچۈرۈلگەن خاتىرىنى $2 دىن كۆرۈڭ.',
	'dellogpage' => 'ئۆچۈرۈش خاتىرىسى',
	'dellogpagetext' => 'تۆۋەندىكىسى يېقىندا ئۆچۈرۈلگەن خاتىرە تىزىملىكى.',
	'deletionlog' => 'ئۆچۈرۈش خاتىرىسى',
	'deletecomment' => 'سەۋەب:',
	'deleteotherreason' => 'باشقا/قوشۇمچە سەۋەب:',
	'deletereasonotherlist' => 'باشقا سەۋەب',
	'deletereason-dropdown' => '*كۆپ ئىشلىتىدىغان ئۆچۈرۈش سەۋەبلىرى
** ئاپتور ئىلتىماسى
** نەشر ھوقۇقىغا خىلاپ
** بۇزغۇنچىلىق',
	'delete-edit-reasonlist' => 'ئۆچۈرۈش سەۋەبى تەھرىر',
	'delete-toobig' => 'بۇ بەتنىڭ بەك كۆپ تەھرىرلەش تارىخى بار، {{PLURAL:$1|تۈزىتىلگەن نەشرى|تۈزىتىلگەن نەشرى}} قېتىمدىن ئارتۇق. {{SITENAME}} قالايمىقانچىلىقنىڭ ئالدىنى ئېلىش ئۈچۈن بۇ خىل بەتلەرنى ئۆچۈرۈش مەشغۇلاتى چەكلەندى.',
	'delete-warning-toobig' => 'بۇ بەتنىڭ تەھرىرلەش تارىخى بەك كۆپ، {{PLURAL:$1|تۈزىتىلگەن نەشرى|تۈزىتىلگەن نەشرى}} قېتىمدىن ئارتۇق.
بۇ بەت ئۆچۈرۈلسە {{SITENAME}} ساندانىنىڭ مەشغۇلاتىنى قالايمىقانلاشتۇرۇۋېتىشى مۇمكىن؛
بۇ مەشغۇلاتنى داۋاملاشتۇرۇشتىن ئىلگىرى ئېھتىيات قىلىڭ.',
	'databasenotlocked' => 'ساندان قۇلۇپلانمىغان.',
	'delete_and_move' => 'ئۆچۈرۈپ يۆتكە',
	'delete_and_move_text' => '== ئۆچۈرۈش زۆرۈر ==
نىشان بەت "[[:$1]]" مەۋجۇد.
يۆتكەشكە قولاي بولۇشى ئۈچۈن بۇ بەتنى ئۆچۈرەمسىز؟',
	'delete_and_move_confirm' => 'ھەئە، بۇ بەتنى ئۆچۈر',
	'delete_and_move_reason' => 'يۆتكەشكە قولاي بولۇشى ئۈچۈن ئۆچۈر',
	'djvu_page_error' => 'DjVu بېتى دائىرىدىن ھالقىپ كەتتى',
	'djvu_no_xml' => 'DjVu ھۆججىتىدىن XML گە ئېرىشەلمىدى',
	'deletedrevision' => '$1 كونا تۈزىتىلگەن نەشرى ئۆچۈرۈلدى',
	'deletedwhileediting' => "'''ئاگاھلاندۇرۇش''': بۇ بەت تەھرىرلەشكە باشلىغاندىن كېيىن ئۆچۈرۈلگەن!",
	'descending_abbrev' => 'كېمەيگۈچى',
	'duplicate-defaultsort' => '\'\'\'ئاگاھلاندۇرۇش:\'\'\' كۆڭۈلدىكى تەرتىپلەش كۇنۇپكىسى "$2" ئىلگىرىكى كۆڭۈلدىكى تەرتىپلەش كۇنۇپكىسى "$1" نى قاپلىۋېتىدۇ.',
	'dberr-header' => 'بۇ wiki مەسىلىگە يولۇقتى',
	'dberr-problems' => 'كەچۈرۈڭ!
بۇ بېكەتتە تېخنىكىلىق قىيىنچىلىق كۆرۈلدى.',
	'dberr-again' => 'بىر قانچە مىنۇت كۈتۈپ ئاندىن قايتا يۈكلەڭ.',
	'dberr-info' => '(ساندان مۇلازىمىتىرىغا ئۇلىنالمىدى:  $1)',
	'dberr-usegoogle' => 'بۇ ۋاقىتتا Google ئىزدىگۈچتىن ئىزدەشنى سىناپ بېقىڭ.',
	'dberr-outofdate' => 'دىققەت ئۇلار ئىندىكېسلىغان مەزمۇن ئەڭ يېڭى بولماسلىقى مۇمكىن.',
	'dberr-cachederror' => 'بۇ ئىلتىماس قىلغان بەتنىڭ غەملەنگەن كۆپەيتىلمىسى، ئەڭ يېڭىسى بولماسلىقى مۇمكىن.',
);

$messages['ug-latn'] = array(
	'december' => 'Dékabr',
	'december-gen' => 'Dékabr',
	'dec' => '12-Ay',
	'delete' => 'Yukhutush',
);

$messages['uk'] = array(
	'december' => 'грудень',
	'december-gen' => 'грудня',
	'dec' => 'груд',
	'delete' => 'Вилучити',
	'deletethispage' => 'Вилучити цю сторінку',
	'disclaimers' => 'Відмова від відповідальності',
	'disclaimerpage' => 'Project:Відмова від відповідальності',
	'databaseerror' => 'Помилка бази даних',
	'dberrortext' => 'Знайдено синтаксичну помилку в запиті до бази даних.
Це може вказувати на помилку в програмному забезпеченні.
Останній запит до бази даних:
<blockquote><tt>$1</tt></blockquote>
відбувся з функції "<tt>$2</tt>".
База даних виявила помилку "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Знайдено синтаксичну помилку в запиті до бази даних.
Останній запит до бази даних:
«$1»
відбувся з функції «$2».
База даних виявила помилку «$3: $4».',
	'directorycreateerror' => 'Неможливо створити директорію «$1».',
	'deletedhist' => 'Історія вилучень',
	'difference' => '(відмінності між версіями)',
	'difference-multipage' => '(Різниця між сторінками)',
	'diff-multi' => '({{PLURAL:$1|Одна проміжна версія одного користувача не показана|$1 проміжні версії {{PLURAL:$2|одного користувача|$2 користувачів}} не показані|$1 проміжних версій {{PLURAL:$2|одного користувача|$2 користувачів}} не показані}})',
	'diff-multi-manyusers' => '({{PLURAL:$1|не показана $1 проміжна я версія|не показані $1 проміжні версії|не показано $1 проміжних версій}}, зроблених більш, ніж {{PLURAL:$2|$1 користувачем|$2 користувачами}})',
	'datedefault' => 'Стандартний',
	'defaultns' => 'Інакше шукати в таких просторах назв:',
	'default' => 'за умовчанням',
	'diff' => 'різн.',
	'destfilename' => 'Назва завантаженого файлу:',
	'duplicatesoffile' => '{{PLURAL:$1|Дублікатом цього файлу є файл|Такі $1 файли є дублікатами цього файлу|Такі $1 файлів є дублікатами цього файлу}}
([[Special:FileDuplicateSearch/$2|докладніше]]):',
	'download' => 'завантажити',
	'disambiguations' => 'Сторінки, що посилаються на сторінки неоднозначності.',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Наступні сторінки посилаються на '''багатозначні сторінки'''. Однак вони, ймовірно, повинні вказувати на відповідну конкретну статтю.<br />Сторінка вважається багатозначною, якщо на ній розміщений шаблон, назва якого є на сторінці [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Подвійні перенаправлення',
	'doubleredirectstext' => 'На цій сторінці наведено список перенаправлень на інші перенаправлення.
Кожен рядок містить посилання на перше та друге перенаправлення, а також перший рядок тексту другого перенаправлення, що зазвичай містить «реальне» перенаправлення на необхідну сторінку, куди повинно вказувати й перше перенаправлення.
<del>Закреслені</del> записи були виправлені.',
	'double-redirect-fixed-move' => 'Сторінка «[[$1]]» була перейменована, зараз вона є перенаправленням на «[[$2]]»',
	'double-redirect-fixed-maintenance' => 'Виправлення подвійного перенаправлення з [[$1]] на [[$2]].',
	'double-redirect-fixer' => 'Redirect fixer',
	'deadendpages' => 'Сторінки без посилань',
	'deadendpagestext' => 'Наступні сторінки не містять посилань на інші сторінки цієї вікі.',
	'deletedcontributions' => 'Вилучений внесок користувача',
	'deletedcontributions-title' => 'Вилучений внесок користувача',
	'defemailsubject' => '{{SITENAME}} - електронний лист від користувача " $1 "',
	'deletepage' => 'Вилучити сторінку',
	'delete-confirm' => 'Вилучення «$1»',
	'delete-legend' => 'Вилучення',
	'deletedtext' => '"$1" було вилучено.
Див. $2 для перегляду списку останніх вилучень.',
	'dellogpage' => 'Журнал вилучень',
	'dellogpagetext' => 'Нижче наведений список останніх вилучень.',
	'deletionlog' => 'журнал вилучень',
	'deletecomment' => 'Причина:',
	'deleteotherreason' => 'Інша/додаткова причина:',
	'deletereasonotherlist' => 'Інша причина',
	'deletereason-dropdown' => '* Типові причини вилучення
** вандалізм
** за запитом автора
** порушення авторських прав',
	'delete-edit-reasonlist' => 'Редагувати причини вилучення',
	'delete-toobig' => 'У цієї сторінки дуже довга історія редагувань, більше $1 {{PLURAL:$1|версії|версій|версій}}.
Вилучення таких сторінок було заборонене з метою уникнення порушень у роботі сайту {{SITENAME}}.',
	'delete-warning-toobig' => 'У цієї сторінки дуже довга історія редагувань, більше $1 {{PLURAL:$1|версії|версій|версій}}.
Її вилучення може призвести до порушень у роботі бази даних сайту {{SITENAME}};
дійте обережно.',
	'databasenotlocked' => 'База даних не заблокована.',
	'delete_and_move' => 'Вилучити і перейменувати',
	'delete_and_move_text' => '== Потрібне вилучення ==
Сторінка з назвою [[:$1|«$1»]] вже існує.
Бажаєте вилучити її для можливості перейменування?',
	'delete_and_move_confirm' => 'Так, вилучити цю сторінку',
	'delete_and_move_reason' => 'Вилучена для можливості перейменування сторінки «[[$1]]»',
	'djvu_page_error' => 'Номер сторінки DjVu недосяжний',
	'djvu_no_xml' => 'Неможливо отримати XML для DjVu',
	'deletedrevision' => 'Вилучена стара версія $1',
	'days-abbrev' => '$1діб',
	'days' => '{{PLURAL:$1|$1 день|$1 дні|$1 днів}}',
	'deletedwhileediting' => "'''Увага:''' ця сторінка була вилучена після того, як ви розпочали редагування!",
	'descending_abbrev' => 'спад',
	'duplicate-defaultsort' => 'Увага. Ключ сортування «$2» перекриває попередній ключ сортування «$1».',
	'dberr-header' => 'Ця вікі має проблеми',
	'dberr-problems' => 'Вибачте! На цьому сайті виникли технічні труднощі.',
	'dberr-again' => 'Спробуйте оновити сторінку за кілька хвилин.',
	'dberr-info' => "(неможливо з'єднатися з сервером баз даних: $1)",
	'dberr-usegoogle' => 'Можете спробувати пошукати за допомогою Google.',
	'dberr-outofdate' => 'Майте на увазі, що його індекси можуть бути застарілими.',
	'dberr-cachederror' => 'Нижче наведена закешована версія запитаної сторінки, можливо, вона не показує останні зміни.',
	'discuss' => 'Обговорення',
);

$messages['ur'] = array(
	'december' => 'دسمبر',
	'december-gen' => 'دسمبر',
	'dec' => 'دسمبر',
	'delete' => 'حذف',
	'deletethispage' => 'یہ صفحہ حذف کریں',
	'disclaimers' => 'اعلانات',
	'disclaimerpage' => 'Project:عام اعلان',
	'databaseerror' => 'خطائے ڈیٹابیس',
	'dberrortext' => 'ڈیٹابیس کے استفسارہ میں ایک خطائے نحوی واقع ہوئی ہے.
اِس سے مصنع‌لطیف میں کھٹمل کی نشاندہی کا اندیشہ ہے.
پچھلا سعی‌شدہ ڈیٹابیسی استفسارہ یہ تھا:
<blockquote><tt>$1</tt></blockquote>
فعلیت میں سے "<tt>$2</tt>".
MySQL نے خطائی جواب دیا "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'ڈیٹابیس کے استفسارہ میں ایک خطائے نحوی واقع ہوئی ہے.
پچھلا سعی‌شدہ ڈیٹابیسی استفسارہ یہ تھا:
"$1"
"$2" فعلیت میں سے.
MySQL نے جوابِ خطاء دیا "$3: $4"',
	'directorycreateerror' => 'رہنامچہ "$1" تخلیق نہیں کیا جاسکا.',
	'deletedhist' => 'حذف شدہ تاریخچہ',
	'difference' => '(اصلاحات میں فرق)',
	'datedefault' => 'کوئی ترجیحات نہیں',
	'default' => 'طے شدہ',
	'diff' => 'فرق',
	'destfilename' => 'تعین شدہ اسم ملف:',
	'download' => 'زیراثقال (ڈاؤن لوڈ)',
	'disambiguations' => 'ضد ابہام صفحات',
	'doubleredirects' => 'دوہرے متبادل ربط',
	'deadendpages' => 'مردہ صفحات',
	'defemailsubject' => '{{SITENAME}} سے برقی خط',
	'deletepage' => 'صفحہ ضائع کریں',
	'deletedtext' => '"$1" کو حذف کر دیا گیا ہے ۔
حالیہ حذف شدگی کے تاریخ نامہ کیلیۓ  $2  دیکھیۓ',
	'dellogpage' => 'نوشتۂ حذف شدگی',
	'dellogpagetext' => 'حالیہ حذف شدگی کی فہرست درج ذیل ہے۔',
	'deletionlog' => 'نوشتۂ حذف شدگی',
	'deletecomment' => 'وجہ:',
	'deleteotherreason' => 'دوسری/اِضافی وجہ:',
	'deletereasonotherlist' => 'دوسری وجہ',
	'delete_and_move' => 'حذف اور منتقل',
	'delete_and_move_text' => '==حذف شدگی لازم==

منتقلی کے سلسلے میں انتخاب کردہ مضمون "[[:$1]]" پہلے ہی موجود ہے۔ کیا آپ اسے حذف کرکے منتقلی کیلیۓ راستہ بنانا چاہتے ہیں؟',
	'delete_and_move_confirm' => 'ہاں، صفحہ حذف کر دیا جائے',
	'delete_and_move_reason' => 'منتقلی کے سلسلے میں حذف',
	'deletedrevision' => 'حذف شدہ پرانی ترمیم $1۔',
	'deletedwhileediting' => 'انتباہ: آپ کے ترمیم شروع کرنے کے بعد یہ صفحہ حذف کیا جا چکا ہے!',
);

$messages['uz'] = array(
	'december' => 'dekabr',
	'december-gen' => 'dekabrning',
	'dec' => 'dek',
	'delete' => "O'chirish",
	'disclaimers' => 'Ogohlantirishlar',
	'disclaimerpage' => 'Project:Umumiy ogohlatirish',
	'difference' => '(Koʻrinishlar orasidagi farq)',
	'diff' => 'farq',
	'disambiguationspage' => '{{ns:template}}:Disambig',
	'deletedtext' => '"$1" yoʻqotildi.
Yaqinda sodir etilgan yoʻqotishlar uchun $2ni koʻring.',
	'dellogpage' => 'Yoʻqotish qaydlari',
	'deletecomment' => 'Sabab:',
	'deleteotherreason' => 'Boshqa/qoʻshimcha sabab:',
	'deletereasonotherlist' => 'Boshqa sabab',
);

$messages['val'] = array(
	'december' => 'decembre',
	'december-gen' => 'decembre',
	'dec' => 'dec',
	'delete' => 'Elimina',
	'deletethispage' => 'Elimina la pàgina',
	'disclaimers' => 'Avís general',
	'disclaimerpage' => 'Proyecte:Avís general',
	'databaseerror' => "S'ha produït un error en la base de dades",
	'dberrortext' => "S'ha produït un error de sintaxis en una consulta a la base de dades.
Açò podria indicar un error en el programa.
L'última consulta que s'ha intentat fer ha segut:
<blockquote><tt>$1</tt></blockquote>
des de la funció «<tt>$2</tt>».
L'error de retorn de MySQL ha segut «<tt>$3: $4</tt>».",
	'dberrortextcl' => "S'ha produït un error de sintaxis en una consulta a la base de dades.
L'última consulta que s'ha intentat fer ha segut:
<blockquote><tt>$1</tt></blockquote>
des de la funció «<tt>$2</tt>».
L'error de retorn de MySQL ha segut «<tt>$3: $4</tt>».",
	'deletedrev' => '[suprimit]',
	'difference' => '(Diferència entre revisions)',
	'diff-multi' => '(Hi ha {{plural:$1|una revisió intermedia|$1 revisions intermedies}})',
	'dateformat' => 'Format de la data',
	'datedefault' => 'Cap preferència',
	'datetime' => 'Data i hora',
	'defaultns' => 'Busca per defecte en els següents espais de noms:',
	'default' => 'per defecte',
	'diff' => 'dif',
	'destfilename' => 'Nom del ficher de destinació',
	'deleteimg' => 'bor',
	'deleteimgcompletely' => "Borra totes les versions d'este archiu",
	'download' => 'descarrega',
	'disambiguations' => 'Pàgines de desambiguació',
	'disambiguationspage' => 'Template:desambiguació',
	'disambiguations-text' => "Les següents pàgines enllacen a una '''pàgina de desambiguació'''. Per això, fa falta que enllacen al tema apropiat.<br />Una pàgina se tracta com de desambiguació si utilisa una plantilla que prové de [[MediaWiki:disambiguationspage]]",
	'doubleredirects' => 'Redireccions dobles',
	'doubleredirectstext' => '<b>Atenció:</b> este llistat pot contindre falsos positius. Això normalment significa que hi ha text

addicional en enllaços baix el primer #REDIRECT.<br />
Cada fila conté enllaços al segon i tercer redireccionament, així com la primera llínia del

segon redireccionament, la qual cosa dòna normalment l\'artícul "real", al que el primer redireccionamet hauria d\'apuntar.',
	'deadendpages' => 'Pàgines assucac',
	'deadendpagestext' => "Estes pàgines no tenen enllaços a d'atres pàgines d'esta mateixa wiki.",
	'data' => 'Dades',
	'defemailsubject' => 'Direcció correu de {{SITENAME}}',
	'deletepage' => 'Borra esta pàgina',
	'deletesub' => '(Borrant "$1")',
	'deletedtext' => '"$1" ha segut borrat.
Mostra $2 per a un registre dels artículs borrats més recents.',
	'deletedarticul' => 'borrat "$1"',
	'dellogpage' => 'Registre_de_borrats',
	'dellogpagetext' => 'Baix hi ha una llista dels artículs borrats recentment.',
	'deletionlog' => 'Registre de borrats',
	'deletecomment' => 'Motiu per a ser borrat',
	'databasenotlocked' => 'La base de dades no està bloquejada.',
	'delete_and_move' => 'Borra i trasllada',
	'delete_and_move_text' => '==Fa falta borrar==

L\'articul de destí, "[[$1]]",ya existix. Vols borrar-lo per fer lloc per al trasllat?',
	'delete_and_move_confirm' => 'Sí, borra la pàgina',
	'delete_and_move_reason' => "S'ha eliminat per a permetre el renomenament",
	'deletedrevision' => "S'ha eliminat la revisió antiga $1.",
	'deletedwhileediting' => "Avís: S'ha suprimit esta pàgina adés que hages començat a editar-la!",
	'descending_abbrev' => 'desc',
);

$messages['vec'] = array(
	'december' => 'disenbre',
	'december-gen' => 'disenbre',
	'dec' => 'dis',
	'delete' => 'Scansela',
	'deletethispage' => 'Scansela sta pagina',
	'disclaimers' => 'Avertenxe',
	'disclaimerpage' => 'Project:Avertense xenerali',
	'databaseerror' => 'Erore del database',
	'dberrortext' => 'Erore de sintassi ne ła richiesta inoltrà al database.
Ciò podaria indicare ła presensa de on bug nel software.
L\'ultima query invià al database xè sta:
<blockquote><tt>$1</tt></blockquote>
riciamà da ła funsion "<tt>$2</tt>".
El database el ga restituio el seguente erore "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Erore de sintasi ne ła richiesta inoltrà al database.
L\'ultima query invià al database xè sta:
"$1"
riciamà da ła funsion "$2".
El database ga restituio el seguente erore "$3: $4".',
	'directorycreateerror' => 'Inposibiłe creare ła directory "$1".',
	'deletedhist' => 'Cronologia scancelà',
	'difference' => '(Difarense fra le version)',
	'difference-multipage' => '(Difarensa tra le pagine)',
	'diff-multi' => '({{PLURAL:$1|Una revision intermedia|$1 revision intermedie}} de {{PLURAL:$2|un utente|$2 utenti}} mia mostrà)',
	'diff-multi-manyusers' => '({{PLURAL:$1|Una revision intermedia|$1 revision intermedie}} de pi de {{PLURAL:$2|un utente|$2 utenti}} mia mostrà)',
	'datedefault' => 'Nissuna preferensa',
	'defaultns' => 'Serca in sti namespace se no diversamente specificà:',
	'default' => 'predefinìo',
	'diff' => 'dif',
	'destfilename' => 'Nome del file de destinazion:',
	'duplicatesoffile' => '{{PLURAL:$1|El file seguente el xe un dopion|I $1 file seguenti i xe dei dopioni}} de sto file ([[Special:FileDuplicateSearch/$2|ulteriori detagli]]):',
	'download' => 'descarga',
	'disambiguations' => 'Pagine de disanbigua',
	'disambiguationspage' => 'Template:Disambigua',
	'disambiguations-text' => "Le pagine ne la lista che segue le contien dei colegamenti a '''pagine de disanbiguazion''' e no a l'argomento a cui le dovarìà far riferimento.<br />
Vien considerà pagine de disanbiguazion tute quele che contien i modèi elencà in [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Redirect dopi',
	'doubleredirectstext' => 'Sta pagina le elenca pagine che rimanda a altre pagine de rimando.
Ogni riga la contien dei colegamenti al primo e al secondo rimando, oltre a la destinassion del secondo rimando, che de solito la xe la "vera" pagina de destinassion, a cui dovarìa pontar el primo rimando.
Le righe <del>sbarà</del> le xe xà stà sistemà.',
	'double-redirect-fixed-move' => '[[$1]] xe stà spostà, desso el xe solo un rimando a [[$2]]',
	'double-redirect-fixer' => 'Coretòr de redirect',
	'deadendpages' => 'Pagine sensa uscita',
	'deadendpagestext' => 'Le pagine indicà de seguito no le gà colegamenti verso altre pagine de {{SITENAME}}.',
	'deletedcontributions' => 'Contributi utente scancelà',
	'deletedcontributions-title' => 'Contributi utente scancelà',
	'defemailsubject' => 'Messagio da {{SITENAME}}',
	'deletepage' => 'Scancela pagina',
	'delete-confirm' => 'Scancela "$1"',
	'delete-legend' => 'Scancela',
	'deletedtext' => "''$1'' xe stà scanselà.
Varda $2 par n'elenco de le ultime pagine scanselà.",
	'dellogpage' => 'Registro de scancelassion',
	'dellogpagetext' => 'Qui de seguito ghe xe un ełenco de łe pàxene scancełae de reçente.',
	'deletionlog' => 'Registro de scancełasión',
	'deletecomment' => 'Motivassion:',
	'deleteotherreason' => 'Altra motivazion o motivazion agiuntiva:',
	'deletereasonotherlist' => 'Altra motivazion',
	'deletereason-dropdown' => "*Motivazion piassè comuni par la scancelazion
** Richiesta de l'autor
** Violazion de copyright
** Vandalismo",
	'delete-edit-reasonlist' => 'Modifica le motivazion par la scancelazion',
	'delete-toobig' => 'La cronologia de sta pagina la xe longa assè (oltre $1 {{PLURAL:$1|revision|revisioni}}). La so scancelazion la xe stà limità par evitar de crear acidentalmente dei problemi de funzionamento al database de {{SITENAME}}.',
	'delete-warning-toobig' => 'La cronologia de sta pagina le xe longa assè (oltre $1 {{PLURAL:$1|revision|revisioni}}). La so scancelazion la pode crear dei problemi de funzionamento al database de {{SITENAME}}; procedi con cautela.',
	'databasenotlocked' => "El database no l'è mìa blocà.",
	'delete_and_move' => 'Scanceła e sposta',
	'delete_and_move_text' => '==Scancełassion richiesta==

La voxe specificà come destinassion "[[:$1]]" l\'esiste xà. Vóto scancełarla par proseguir con ło spostamento?',
	'delete_and_move_confirm' => 'Sì, scancèla la pagina',
	'delete_and_move_reason' => "Scancelà par spostar n'altra pagina a sto titolo",
	'djvu_page_error' => 'Nùmaro de pagina DjVu sbaglià',
	'djvu_no_xml' => "Inpossibile otegner l'XML par el file DjVu",
	'deletedrevision' => 'Vecia version scancełà $1',
	'deletedwhileediting' => "'''Ocio''': Sta pàxena la xè stà scancełà dopo che te ghè scominzià a modificarla!",
	'descending_abbrev' => 'decresc',
	'duplicate-defaultsort' => 'Ocio: la ciave de ordinamento predefinìa "$2" la va in conflito co\' quela de prima "$1".',
	'dberr-header' => 'Sta wiki la ga un problema',
	'dberr-problems' => 'Sto sito al momento el gà qualche problema tènico.',
	'dberr-again' => 'Próa a spetar un par de minuti e ricargar la pàxena.',
	'dberr-info' => '(No se riesse a métarse in contato col server del database: $1)',
	'dberr-usegoogle' => 'Fin che te speti, te podi proar a sercar su Google.',
	'dberr-outofdate' => 'Tien presente che la so indicixassion dei nostri contenuti la podarìa no èssar ajornà.',
	'dberr-cachederror' => 'Quela che segue la xe na copia cache de la pàxena richiesta, e la podarìa no èssar mia ajornà.',
);

$messages['vep'] = array(
	'december' => 'tal’vku',
	'december-gen' => 'tal’vkun',
	'dec' => 'tal’vku',
	'delete' => 'Čuta poiš',
	'deletethispage' => "Čuta nece lehtpol'",
	'disclaimers' => 'Pučind vastusenpidandaspäi',
	'disclaimerpage' => 'Project:Pučind vastusenpidandaspäi',
	'databaseerror' => 'Andmusiden bazan petuz',
	'dberrortextcl' => 'Andmusiden bazas ectes ozaižihe petuz.
Jäl\'gmäine ecind andmusiden bazas oli:
"$1"
funkcijaspäi "$2".
Andmusiden baz pördi petusen "$3: $4"',
	'directorycreateerror' => 'Ei voi säta "$1"-failhodrad.',
	'deletedhist' => 'Čudandoiden istorii',
	'difference' => '(Erod versijoiden keskes)',
	'diff-multi' => "({{PLURAL:$1|üks' keskmäine versii ei ole|$1 keskmäšt versijad ei olgoi}} {{PLURAL:$2|one user|$2 users}} ozutadud)",
	'datedefault' => 'Augotižjärgendused',
	'defaultns' => 'Toižiš statjoiš ectä neniš nimiavarusiš:',
	'default' => 'augotižjärgendusen mödhe',
	'diff' => 'erod',
	'destfilename' => 'Failan metnimi:',
	'duplicatesoffile' => '{{PLURAL:$1|Nece fail om|$1 Nened failad oma}} ([[Special:FileDuplicateSearch/$2|ližainformacii]])-failan {{PLURAL:$1|dublikat|$1 dublikatad}}:',
	'download' => 'jügutoitta',
	'disambiguations' => 'Lehtpoled, kudambil om kosketusid lehtpolihe, kus om äiznamoičendusen laskendoid.',
	'disambiguationspage' => 'Template:Äiznamoičenduz',
	'doubleredirects' => 'Kaksitadud läbikosketused',
	'double-redirect-fixed-move' => "[[$1]]-lehtpol' om udesnimitadud. Se läbikosketab nügüd' [[$2]]-lehtpolele.",
	'double-redirect-fixer' => 'Läbikosketusiden kohendai',
	'deadendpages' => 'Lehtpoled, kudambid ei kosketagoi toižed lehtpoled',
	'deadendpagestext' => 'Nened lehtpoled ei kosketagoi toižid necen wikin lehtpolid.',
	'deletedcontributions' => 'Čutud tond',
	'deletedcontributions-title' => 'Čutud tond',
	'defemailsubject' => '$1-kävutajan počt {{SITENAME}}-saitalpäi',
	'deletepage' => "Čuta lehtpol' poiš",
	'delete-confirm' => '"$1"-lehtpolen čudand',
	'delete-legend' => 'Čuta poiš',
	'deletedtext' => '"$1" om čutud poiš.
Kc. $2, miše lugeda tantoižiden čudandoiden nimikirjutez.',
	'dellogpage' => 'Čudandoiden aigkirj',
	'dellogpagetext' => 'Naku om tantoižiden čudandoiden nimikirjutez.',
	'deletionlog' => 'čudandoiden aigkirj',
	'deletecomment' => 'Sü:',
	'deleteotherreason' => 'Toine sü/ližasü:',
	'deletereasonotherlist' => 'Toinejitte sü',
	'deletereason-dropdown' => '*Tipižed čudandan süd:
** Avtoran pakičend
** Avtoran oiktusen murenduz
** Vandalizm',
	'delete-edit-reasonlist' => 'Redaktiruida čudandan süiden nimikirjutez',
	'delete-toobig' => "Necil lehtpolel om avar redaktiruinadan istorii - enamba {{PLURAL:$1|versii|versijad}}.
Mugoižiden lehtpoliden čudand om kel'tud, miše sait radaiži normaližikš.",
	'delete-warning-toobig' => 'Necil lehtpolel om avar redaktiruinadan istorii - enamba $1 {{PLURAL:$1|versii|versijad}}.
Mugoižiden lehtpoliden čudand voiži telustada {{SITENAME}}-saitan andmuzbazan normaližele radole.
Tehkat kaik varumujandanke!',
	'databasenotlocked' => 'Andmusiden baz ei ole luklostadud.',
	'delete_and_move' => 'Čuta poiš da udesnimitada',
	'delete_and_move_confirm' => "Ka, čuta lehtpol' poiš",
	'delete_and_move_reason' => 'Čutud poiš "[[$1]]"n udesnimitamižen voimusen täht.',
	'djvu_page_error' => 'En voi sadas DjVu-lehtpolen nomerhasai',
	'djvu_no_xml' => 'Ei voi sada XMLad DjVu-failan täht',
	'deletedrevision' => '$1-lehtpolen vanh versii om čutud',
	'deletedwhileediting' => "'''Homaikat''': Nece lehtpol' čutihe poiš jälges sidä, konz tö olit toižetaškanuded necidä lehtpol't!",
	'descending_abbrev' => 'lask.',
	'duplicate-defaultsort' => '\'\'\'Varutuz:\'\'\' Sortiruindan avadim äugotižjärgendusen mödhe "$2" toižetab edeližen avadimen äugotižjärgendusen mödhe "$1".',
	'dberr-header' => 'Necil wikil om problemoid',
	'dberr-problems' => 'Pakičem armahtust! Necil saital om tehnižid problemoid.',
	'dberr-again' => "Varastagat pordon aigad da udištagat lehtpol'.",
	'dberr-info' => '(Ei voi säta sidod admusiden baziden serveranke: $1)',
	'dberr-usegoogle' => "Täl aigal tö voit ectä Google'an abul.",
	'dberr-outofdate' => "Google'an indeks voib olda vanhtunuden.",
	'dberr-cachederror' => 'Naku om ectud lehtpolen keširuidud versii. Voib olda, siš ei ole tantoižid toižetusid.',
);

$messages['vi'] = array(
	'december' => 'tháng 12',
	'december-gen' => 'tháng Mười hai',
	'dec' => 'tháng 12',
	'delete' => 'Xóa',
	'deletethispage' => 'Xóa trang này',
	'disclaimers' => 'Phủ nhận',
	'disclaimerpage' => 'Project:Phủ nhận chung',
	'databaseerror' => 'Lỗi cơ sở dữ liệu',
	'dberrortext' => 'Đã xảy ra lỗi cú pháp trong truy vấn cơ sở dữ liệu.
Có vẻ như nguyên nhân của vấn đề này xuất phát từ một lỗi trong phần mềm.
Truy vấn vừa rồi là:
<blockquote><tt>$1</tt></blockquote>
từ hàm “<tt>$2</tt>”.
Cơ sở dữ liệu  báo lỗi “<tt>$3: $4</tt>”.',
	'dberrortextcl' => 'Đã xảy ra lỗi cú pháp trong truy vấn cơ sở dữ liệu.
Truy vấn vừa rồi là:
“$1”
từ hàm “$2”.
Cơ sở dữ liệu báo lỗi “$3: $4”',
	'directorycreateerror' => 'Không thể tạo được danh mục “$1”.',
	'deletedhist' => 'Lịch sử đã xóa',
	'difference' => '(Khác biệt giữa các bản)',
	'difference-multipage' => '(Khác biệt giữa các trang)',
	'diff-multi' => '(Không hiển thị {{PLURAL:$1||$1}} phiên bản {{PLURAL:$2||của $2 thành viên}} ở giữa)',
	'diff-multi-manyusers' => '(Không hiển thị {{PLURAL:$1||$1}} phiên bản của hơn $2 thành viên ở giữa)',
	'datedefault' => 'Không quan tâm',
	'defaultns' => 'Nếu không thì tìm trong không gian sau:',
	'default' => 'mặc định',
	'diff' => 'khác',
	'destfilename' => 'Tên tập tin mới:',
	'duplicatesoffile' => '{{PLURAL:$1|Tập tin sau|$1 tập tin sau}} là bản sao của tập tin này ([[Special:FileDuplicateSearch/$2|chi tiết]]):',
	'download' => 'tải về',
	'disambiguations' => 'Trang liên kết đến trang định hướng',
	'disambiguationspage' => 'Template:disambig',
	'disambiguations-text' => "Các trang này có liên kết đến một '''trang định hướng'''. Nên sửa các liên kết này để chỉ đến một trang đúng nghĩa hơn.<br />Các trang định hướng là trang sử dụng những bản mẫu được liệt kê ở [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Đổi hướng kép',
	'doubleredirectstext' => 'Trang này liệt kê các trang đổi hướng đến một trang đổi hướng khác.
Mỗi hàng có chứa các liên kết đến trang đổi hướng thứ nhất và thứ hai, cũng như mục tiêu của trang đổi hướng thứ hai, thường là trang đích “thực sự”, là nơi mà trang đổi hướng đầu tiên nên trỏ đến.
Các mục <del>bị gạch bỏ</del> là các trang đã được sửa.',
	'double-redirect-fixed-move' => '[[$1]] đã được đổi tên, giờ nó là trang đổi hướng đến [[$2]]',
	'double-redirect-fixed-maintenance' => 'Giải quyết đổi hướng kép từ [[$1]] đến [[$2]].',
	'double-redirect-fixer' => 'Người sửa trang đổi hướng',
	'deadendpages' => 'Trang đường cùng',
	'deadendpagestext' => 'Các trang này không có liên kết đến trang khác trong {{SITENAME}}.',
	'deletedcontributions' => 'Đóng góp đã bị xóa của thành viên',
	'deletedcontributions-title' => 'Đóng góp đã bị xóa của thành viên',
	'defemailsubject' => 'Thư của người dùng "$1" tại {{SITENAME}}',
	'deletepage' => 'Xóa trang',
	'delete-confirm' => 'Xóa “$1”',
	'delete-legend' => 'Xóa',
	'deletedtext' => 'Đã xóa “$1”. Xem danh sách các xóa bỏ gần nhất tại $2.',
	'dellogpage' => 'Nhật trình xóa',
	'dellogpagetext' => 'Dưới đây là danh sách các trang bị xóa gần đây nhất.',
	'deletionlog' => 'nhật trình xóa',
	'deletecomment' => 'Lý do:',
	'deleteotherreason' => 'Lý do khác/bổ sung:',
	'deletereasonotherlist' => 'Lý do khác',
	'deletereason-dropdown' => '*Các lý do xóa phổ biến
** Tác giả yêu cầu
** Vi phạm bản quyền
** Phá hoại',
	'delete-edit-reasonlist' => 'Sửa lý do xóa',
	'delete-toobig' => 'Trang này có lịch sử sửa đổi lớn, đến hơn {{PLURAL:$1|lần|lần}} sửa đổi.
Việc xóa các trang như vậy bị hạn chế để ngăn ngừa phá hoại do vô ý cho {{SITENAME}}.',
	'delete-warning-toobig' => 'Trang này có lịch sử sửa đổi lớn, đến hơn {{PLURAL:$1|lần|lần}} sửa đổi.
Việc xóa các trang có thể làm tổn hại đến hoạt động của cơ sở dữ liệu {{SITENAME}};
hãy cẩn trọng khi thực hiện.',
	'databasenotlocked' => 'Cơ sở dữ liệu không bị khóa.',
	'delete_and_move' => 'Xóa và đổi tên',
	'delete_and_move_text' => '==Cần xóa==

Trang với tên “[[:$1]]” đã tồn tại. Bạn có muốn xóa nó để dọn chỗ di chuyển tới tên này không?',
	'delete_and_move_confirm' => 'Xóa trang để đổi tên',
	'delete_and_move_reason' => 'Xóa để có chỗ đổi tên “[[$1]]”',
	'djvu_page_error' => 'Trang DjVu quá xa',
	'djvu_no_xml' => 'Không thể truy xuất XML cho tập tin DjVu',
	'deletedrevision' => 'Đã xóa phiên bản cũ $1',
	'days-abbrev' => '$1d',
	'days' => '$1 ngày',
	'deletedwhileediting' => "'''Cảnh báo''': Trang này đã bị xóa sau khi bắt đầu sửa đổi!",
	'descending_abbrev' => 'giảm',
	'duplicate-defaultsort' => 'Cảnh báo: Từ khóa xếp mặc định “$2” ghi đè từ khóa trước, “$1”.',
	'dberr-header' => 'Wiki này đang gặp trục trặc',
	'dberr-problems' => 'Xin lỗi! Trang này đang gặp phải những khó khăn về kỹ thuật.',
	'dberr-again' => 'Xin thử đợi vài phút rồi tải lại trang.',
	'dberr-info' => '(Không thể liên lạc với máy chủ cơ sở dữ liệu: $1)',
	'dberr-usegoogle' => 'Bạn có thể thử tìm trên Google trong khi chờ đợi.',
	'dberr-outofdate' => 'Chú ý rằng các chỉ mục của Google có thể đã lỗi thời.',
	'dberr-cachederror' => 'Sau đây là bản sao được lưu bộ đệm của trang bạn muốn xem, và có thể đã lỗi thời.',
);

$messages['vls'] = array(
	'december' => 'december',
	'december-gen' => 'december',
	'dec' => 'dec',
	'delete' => 'Wegdoen',
	'deletethispage' => 'Da blad ier verwydern',
	'disclaimers' => 'Aansprakelekeid',
	'delete_and_move' => 'Wegdoen en ernoemn',
);

$messages['vmf'] = array(
	'december' => 'Dädsembär',
	'december-gen' => 'Fom Dädsembâr',
	'dec' => 'Däds.',
	'delete' => 'Leschn',
	'deletethispage' => 'Dii sajdn leschn',
	'disclaimers' => 'Imbräsum',
	'disclaimerpage' => 'Project:Imbräsum',
	'databaseerror' => 'Feelâr fon dr Daadnbangg',
	'dberrortext' => 'Bam abfrôôchn fon dr daadnbangg is was schiif gangn.
Filajchd weechn am brogramiir-feelâr?
Jeednfals wôôr di ledsd abfrôôchn:
<blockquote><tt>$1</tt></blockquote>
aus dr fungdsjoon „<tt>$2</tt>“.
Un dôôdruf had dan di daadnbangg den feelâr „<tt>$3: $4</tt>“ gmeld.',
	'dberrortextcl' => 'Dii daadnbangg-abfrôôchn wôôr falsch gschriiwn.
Di abfrôôchn wôôr neemlich
<blockquote><tt>$1</tt></blockquote>
aus dr fungdsjoon "<tt>$2</tt>". Un dôôdruf had dan di daadnbangg den feelâr „$3: $4“ gmeld.',
	'difference' => '(Undârschiid dswischâ wärsjoonâ)',
	'datedefault' => 'Nôrmaal',
	'diff' => 'undârschiid',
	'duplicatesoffile' => 'Dii {{PLURAL:$1|folchende dadaj is â dublighaad|folchende $1 dadajâ sn dublighaade}} fon dâr dadaj ([[Special:FileDuplicateSearch/$2|wajdâre ôôndlshajdâ]]):',
	'deletepage' => 'Sajdn leschn',
	'deletedtext' => '„$1“ is gleschd wôrn. Im $2 findsd â lisdn mid dâ ledsdn leschunga.',
	'dellogpage' => 'Logbuch fo di leschunga',
	'deletecomment' => 'Grund:',
	'deleteotherreason' => 'Noch a Grund dâfiir:',
	'deletereasonotherlist' => 'Andrâr Grund',
	'deletereason-dropdown' => "* Iibliche Grind fir's Leschn
** Wal's dr Audhoor woln had
** Wal's uurheewâr-rechd iwârdreedn wôrn is
** Wal anâr nôr ghausd had",
	'delete-edit-reasonlist' => "D'grind fir's leschn ändârn",
	'delete-toobig' => "Dii sajdn had iiwâr $1 {{PLURAL:$1|Wersjoon|Wersjoon'n}}, des is fiil. Solche sajdn däf mr nima miir nigs diir nigs leschn, damid dii seewâr ned in d'gnii geen.",
	'delete-warning-toobig' => "Dii sajdn had mäa wii $1 {{PLURAL:$1|wärsjoon|wärsjoon'n}}, des is fiil. Wem ma solchene leschd, ghan dr seerwâr fiir {{SITENAME}} ins scholbârn ghomn.",
);

$messages['vo'] = array(
	'december' => 'dekul',
	'december-gen' => 'dekul',
	'dec' => 'dek',
	'delete' => 'Moükön',
	'deletethispage' => 'Moükolös padi at',
	'disclaimers' => 'Nuneds',
	'disclaimerpage' => 'Project:Gididimiedükam valemik',
	'databaseerror' => 'Pöl in nünodem',
	'dberrortext' => 'Süntagapök pö geb vüka at ejenon.
Atos ba sinifön, das dabinon säkäd pö program.
Steifül lätik ad gebön vüki äbinon:
<blockquote><tt>$1</tt></blockquote>
se dunod: „<tt>$2</tt>“.
Nünodem ägesedon pökanuni: „<tt>$3: $4</tt>“.',
	'dberrortextcl' => 'Süntagapök pö geb vüka at ejenon.
Steifül lätik ad gebön vüki at äbinon:
„$1“
se dunod: „$2“.
Nünodem ägesedon pökanuni: „$3: $4“',
	'directorycreateerror' => 'No eplöpos ad jafön ragiviäri: "$1".',
	'deletedhist' => 'Jenotem pemoüköl',
	'difference' => '(Dif vü revids)',
	'diff-multi' => '({{PLURAL:$1|Revid vüik bal no pejonon|Revids vüik $1 no pejonons}}.)',
	'datedefault' => 'Buükam nonik',
	'defaultns' => 'Votiko sukolös in nemaspads at:',
	'default' => 'stad kösömik',
	'diff' => 'dif',
	'destfilename' => 'Ragivanem nulik:',
	'duplicatesoffile' => '{{Plural:$1|Ragiv fovik leigon|Ragivs fovik $1 leigons}} ko ragiv at ([[Special:FileDuplicateSearch/$2|nüns pluik]]):',
	'download' => 'donükön',
	'disambiguations' => 'Telplänovapads',
	'disambiguationspage' => 'Template:Telplänov',
	'disambiguations-text' => "Pads sököl payümons ad '''telplanövapad'''.
Sötons plao payümon lü yeged pötik.<br />
Pad palelogon telplänovapad if gebon samafomoti, lü kel payümon pad [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Lüodüköms telik',
	'doubleredirectstext' => 'Kedet alik labon yümis lü lüodüköm balid e telid, ed i kedeti balid vödema lüodüköma telid, kel nomiko ninädon padi, ko kel lüodüköm balid söton payümön.',
	'double-redirect-fixed-move' => 'Pad: [[$1]] petopätükon, anu binon lüodüköm lü pad: [[$2]]',
	'double-redirect-fixer' => 'Nätüköm lüodükömas',
	'deadendpages' => 'Pads nen yüms lü votiks',
	'deadendpagestext' => 'Pads sököl no labons yümis ad pads votik in vüki at.',
	'deletedcontributions' => 'Gebanakeblünots pemoüköl',
	'deletedcontributions-title' => 'Gebanakeblünots pemoüköl',
	'defemailsubject' => 'Ladet leäktronik ela {{SITENAME}}',
	'deletepage' => 'Moükolöd padi',
	'delete-confirm' => 'Moükön padi: "$1"',
	'delete-legend' => 'Moükön',
	'deletedtext' => 'Pad: "<nowiki>$1</nowiki>" pemoükon;
$2 jonon moükamis nulik.',
	'deletedarticle' => 'Pad: "[[$1]]" pemoükon',
	'dellogpage' => 'Jenotalised moükamas',
	'dellogpagetext' => 'Dono binon lised moükamas nulikün.',
	'deletionlog' => 'jenotalised moükamas',
	'deletecomment' => 'Kod:',
	'deleteotherreason' => 'Kod votik:',
	'deletereasonotherlist' => 'Kod votik',
	'deletereason-dropdown' => '* Kods kösömik moükama
** Beg lautana
** Kopiedagitäts
** Vandalim',
	'delete-edit-reasonlist' => 'Redakön kodis moükama',
	'delete-toobig' => 'Pad at labon redakamajenotemi lunik ({{PLURAL:$1|revid|revids}} plu $1).
Moükam padas somik pemiedükon ad vitön däropami pö {{SITENAME}}.',
	'delete-warning-toobig' => 'Pad at labon jenotemi lunik: {{PLURAL:$1|revid|revids}} plu $1.
Prudö! Moükam onik ba osäkädükon jäfidi nünodema: {{SITENAME}}.',
	'databasenotlocked' => 'Vük at no pefärmükon.',
	'delete_and_move' => 'Moükolöd e topätükolöd',
	'delete_and_move_text' => '==Moükam peflagon==

Yeged nulik "[[:$1]]" ya dabinon. Vilol-li moükön oni ad jafön spadi pro topätükam?',
	'delete_and_move_confirm' => 'Si! moükolöd padi',
	'delete_and_move_reason' => 'Pemoükon ad jafön spadi pro topätükam',
	'djvu_no_xml' => 'No eplöpos ad tuvön eli XML pro ragiv fomätü DjVu',
	'deletedrevision' => 'Fomam büik: $1 pemoükon.',
	'deletedwhileediting' => "'''Nuned''': Pad at pemoükon posä äprimol ad redakön oni!",
	'descending_abbrev' => 'donio',
	'duplicate-defaultsort' => 'Nüned: Leodükamakik kösömik: „$2“ buon bu leodükamakik kösömik büik: „$1“.',
	'dberr-header' => 'Vük at labon säkädi',
	'dberr-problems' => 'Säkusadolös! Bevüresodatopäd at nu labon säkädis kaenik.',
	'dberr-again' => 'Steifülolös dönu pos stebedüp minutas anik.',
	'dberr-info' => '(No eplöpos ad kosikön ko dünanünöm nünodema: $1)',
	'dberr-usegoogle' => 'Kanol sukön me el Google vütimo.',
	'discuss' => 'Bespik',
);

$messages['vot'] = array(
	'december' => 'dekaabri',
	'december-gen' => 'dekaabrii',
	'dec' => 'dekaabri',
	'delete' => 'Pühi',
	'disclaimers' => 'Tšeeltümin vassamizõõ',
	'disclaimerpage' => 'Project:Tšeeltümin vassamizõõ',
	'difference' => '(Vahõd verzijoďďee väliz)',
	'diff' => 'vahõ',
	'deletepage' => 'Pühi tšültši',
	'deletedtext' => '"$1" on pühittü.
Tšüľľellä $2 on spiiska viimeiziss pühtšimühsiiss.',
	'dellogpage' => 'Pühitüd tšüľľed',
	'deletecomment' => 'Süü',
	'deleteotherreason' => 'Muu vai lisä süü',
	'deletereasonotherlist' => 'Muu süü',
);

$messages['vro'] = array(
	'december' => 'joulukuu',
	'december-gen' => 'joulukuu',
	'dec' => 'jouluk',
	'delete' => 'Kistudaq ärq',
	'deletethispage' => 'Kistudaq seo artikli ärq',
	'disclaimers' => 'Hoiatuisi',
	'disclaimerpage' => 'Project:Üledseq hoiatusõq',
	'databaseerror' => 'Teedüskogo viga',
	'dberrortext' => 'Teedüskogo perräküsümisen oll\' süntaksiviga.
Perräküsümine oll\' viganõ vai om tarkvaran viga.
Viimäne teedüskogo perräküsümine oll\':
<blockquote><tt>$1</tt></blockquote>
ja tuu tetti funktsioonist "<tt>$2</tt>".
Teedüskogo and\' viateedüse "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Teedüskogo perräküsümisen oll\' süntaksiviga.
Viimäne teedüskogo perräküsümine oll\':
"$1"
ja tuu tetti funktsioonist "$2".
Teedüskogo and\' viateedüse "$3: $4".',
	'directorycreateerror' => 'Saa-s luvvaq kausta "$1".',
	'difference' => '(Kujjõ lahkominegiq)',
	'diff-multi' => '(Kujjõ vaihõl {{PLURAL:$1|üts näütämäldä muutminõ|$1 näütämäldä muutmist}}.)',
	'datedefault' => 'Ütskõik',
	'defaultns' => 'Otsiq vaikimiisi naist nimeruumõst:',
	'default' => 'vaikimiisi',
	'diff' => 'lahk',
	'destfilename' => 'Teedüstü nimi vikin:',
	'download' => 'laat',
	'disambiguations' => 'Lingiq, miä näütäseq täpsüstüslehekülgi pääle',
	'disambiguationspage' => 'Template:Linke täpsüstüslehekülile',
	'disambiguations-text' => "Naaq leheq näütäseq '''täpsüstüslehti''' pääle.
Tuu asõmal pidänüq nä näütämä as'a sisu pääle.<br />
Lehte peetäs täpsüstüslehes, ku timän om pruugit näüdüst, kohe näütäs link lehelt [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'Katõkõrdsõq ümbresaatmisõq',
	'doubleredirectstext' => 'Egä ria pääl om ärq tuud edimäne ja tõõnõ ümbresaatmisleht ja niisama tõõsõ ümbresaatmislehe link, miä näütäs hariligult kotusõ pääle, kohe edimäne ümbersaatmisleht pidänüq õkva näütämä.',
	'deadendpages' => 'Leheq, kon olõ-i linke',
	'deadendpagestext' => 'Nail lehil olõ-i linke tõisi viki lehti pääle.',
	'defemailsubject' => '{{SITENAME}} e-post',
	'deletepage' => 'Kistudaq lehekülg ärq',
	'deletedtext' => '"$1" om ärq kistutõt.
Perämäidsi kistutuisi nimekirjä näet siist: $2.',
	'dellogpage' => 'Kistutõduq leheküleq',
	'dellogpagetext' => 'Naaq ommaq perämädseq kistutamisõq.
Kelläaoq ummaq serveriao perrä.',
	'deletionlog' => 'Kistutõduq leheküleq',
	'deletecomment' => 'Põhjus:',
	'deleteotherreason' => 'Muu põhjus vai täpsüstüs:',
	'deletereasonotherlist' => 'Muu põhjus',
	'deletereason-dropdown' => "*Hariliguq kistutamisõ põhjusõq
** Kirotaja hindä palvõl
** Tegijäõigusõ rikminõ
** Lehe ts'urkminõ",
	'databasenotlocked' => 'Teedüskoko panda-s lukku.',
	'delete_and_move' => 'Kistudaq tsihtlehekülg ärq ja panõq timä asõmalõ taa leht',
	'delete_and_move_text' => 'Tsihtlehekülg  "[[:$1]]" om jo olõman, kas tahat tuu ärq kistutaq, et taa leht timä asõmalõ pandaq?',
	'delete_and_move_confirm' => 'Jah, kistudaq tuu leht ärq',
	'delete_and_move_reason' => 'Ärq kistutõt, et tõõnõ timä asõmalõ pandaq',
	'djvu_page_error' => 'DjVu lehe viga',
	'djvu_no_xml' => 'Saa-s DjVu-teedüstü jaos XML-i kätte',
	'deletedrevision' => 'Kistutõdi ärq vana kujo $1.',
	'deletedwhileediting' => "<center>'''Hoiatus''': taa leht om ärq kistutõt päält tuud, ku sa taad toimõndama naksit!</center>",
	'descending_abbrev' => 'allapoolõ',
);

$messages['wa'] = array(
	'december' => 'decimbe',
	'december-gen' => 'decimbe',
	'dec' => 'dec',
	'delete' => 'Disfacer',
	'deletethispage' => "Disfacer l' pådje",
	'databaseerror' => "Åk n' a nén stî avou l' båze di dnêyes",
	'dberrortext' => "Åk n' a nén stî avou l' sintacse do cweraedje del båze di dnêyes.
Çoula pout esse cåze d' on bug dins l' programe.
Li dierin cweraedje del båze di dnêyes di sayî esteut:
<blockquote><tt>$1</tt></blockquote>
a pårti del fonccion «<tt>$2</tt>».
MySQL a rtourné l' aroke «<tt>$3: $4</tt>».",
	'dberrortextcl' => "Åk n' a nén stî avou l' sintacse do cweraedje del båze di dnêyes.
Li dierin cweraedje del båze di dnêyes di sayî esteut:
«$1»
a pårti del fonccion «$2».
MySQL a rtourné l' aroke «$3: $4».",
	'directorycreateerror' => 'On n\' såreut askepyî l\' dossî "$1".',
	'difference' => '(Diferinces inte les modêyes)',
	'datedefault' => 'Nole preferince',
	'defaultns' => 'Prémetous spåces di nos pol cweraedje:',
	'default' => 'prémetou',
	'diff' => 'dif.',
	'destfilename' => "No d' fitchî a eployî so {{SITENAME}}:",
	'download' => 'aberweter',
	'disambiguations' => "Pådjes d' omonimeye",
	'disambiguationspage' => 'Template:Omonimeye',
	'doubleredirects' => 'Dobes redjiblaedjes',
	'doubleredirectstext' => "Tchaeke roye a-st on loyén viè l' prumî eyet l' deujhinme redjiblaedje, avou on mostraedje del prumire roye do tecse do deujhinme redjiblaedje, çou ki å pus sovint dene li «vraiy» årtike såme, ki l' prumî redjiblaedje divreut evoyî viè lu.",
	'deadendpages' => 'Pådjes sins nou loyén wiki',
	'defemailsubject' => 'Emile da {{SITENAME}}',
	'deletepage' => "Disfacer l' pådje",
	'deletedtext' => 'Li pådje «$1» a stî disfacêye. Loukîz li $2 po ene
djivêye des dierins disfaçaedjes.',
	'dellogpage' => 'Djournå des disfaçaedjes',
	'dellogpagetext' => "Chal pa dzo c' est l' djivêye des dierins disfaçaedjes.",
	'deletionlog' => 'djournå des disfaçaedjes',
	'deletecomment' => 'Råjhon:',
	'delete_and_move' => 'Disfacer et displaecî',
	'delete_and_move_text' => "==I gn a mezåjhe di disfacer==

L' årtike såme «[[:$1]]» egzistêye dedja. El voloz vs disfacer po vs permete di displaecî l' ôte?",
	'delete_and_move_confirm' => "Oyi, disfacer l' pådje",
	'delete_and_move_reason' => 'Disfacé po permete on displaeçaedje',
	'deletedrevision' => 'Viye modêye $1 disfacêye',
	'deletedwhileediting' => 'Asteme: Cisse pådje ci a stî disfacêye sol tins ki vos scrijhîz!',
);

$messages['war'] = array(
	'december' => 'Disyembre',
	'december-gen' => 'han Disyembre',
	'dec' => 'Dis',
	'delete' => 'Para-a',
	'deletethispage' => 'Para-a ini nga pakli',
	'disclaimers' => 'Mga Disclaimer',
	'disclaimerpage' => 'Project:Kasahiran nga disclaimer',
	'databaseerror' => 'Sayop hin database',
	'dberrortext' => 'Mayda nahinabo nga sayop hin syntax ha database nga kwery.
Bangin ini nagpapakita hin bug dida han softweyr.
An kataposan nga ginsari nga database nga kweri amo in:
<blockquote><tt>$1</tt></blockquote>
tikang ha sakob han funsyon nga "<tt>$2</tt>".
Nagbalik an database hin sayop nga "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'Mayda nahitabo nga sayop hin syntax ha database nga kwery.
An kataposan nga ginsari nga kweri han database amo an:
"$1"
tikang ha sakob han funsyon nga "$2".
Nagbalik hin sayop an database nga "$3: $4"',
	'difference' => '(Kaibhan han kabutngaan han mga pagliwat)',
	'diff-multi' => '({{PLURAL:$1|Usa nga panbutnga nga pagbag-o|$1 nga panbutnga nga pagbag-o}} ni {{PLURAL:$2|usa nga gumaramit|$2 nga mga gumaramit}} waray ginpakita)',
	'datedefault' => 'Waray pinaurog nga karuyag',
	'diff' => 'kaibhan',
	'download' => 'pagkarga paubos',
	'disambiguations' => 'Mga pakli nga nasumpay ha mga pansayod nga pakli',
	'disambiguationspage' => 'Template:pansayod',
	'deletedcontributions' => 'Mga ginpara nga mga ámot hin nágámit',
	'deletedcontributions-title' => 'Ginpara nga mga amot han nagamit',
	'deletepage' => 'Igpara an pakli',
	'delete-confirm' => 'Igpara "$1"',
	'delete-legend' => 'Igpara',
	'deletedtext' => 'Ginpara an "$1".
Kitaa an $2 para hin talaan han mga gibag-ohi nga mga ginpamara.',
	'dellogpage' => 'Talaan han mga ginpara',
	'deletecomment' => 'Katadungan:',
	'deletereasonotherlist' => 'Lain nga katadungan',
	'deletereason-dropdown' => "*Agsob nga rason hin pagpara
** Tugon han manunurat
** Pagtalapas ha katungod hin pagtatag-iya (''copyright'')
** Bandalismo",
	'databasenotlocked' => 'An database in diri nakatrangka.',
	'delete_and_move' => 'Igapara ngan igbalhin',
	'duplicate-defaultsort' => '\'\'\'Pahimatngon:\'\'\' An daan-aada nga paglainlain nga piridlitan nga "$2" in igsasapaw an durudaan nga daan-aada nga paglainlain nga piridlitan nga "$1".',
	'dberr-header' => 'Ini nga wiki mayda problema',
);

$messages['wo'] = array(
	'december' => 'Deesàmbar',
	'december-gen' => 'Disembar',
	'dec' => 'Dis',
	'delete' => 'Far',
	'deletethispage' => 'Far wii xët',
	'disclaimers' => 'Ay aartu',
	'disclaimerpage' => 'Project:Aartu yu daj',
	'databaseerror' => 'Njuumtey dàttub njoxe bi',
	'dberrortext' => '�Njuumtey mbindin ci laaj bi nga yónne dàttub njoxe bi.
Man na nekk it ab njuumte ci tëriin bi.
Laaj bees mujje yónne ci dàttub njoxe bi moo doonoon:
<blockquote><tt>$1</tt></blockquote>.
bàyyikoo ci bii solo « <tt>$2</tt> ».
Dàttub njoxe bee delloo bii njuumte « <tt>$3 : $4</tt> ».',
	'dberrortextcl' => 'Ab laajub dàttub njoxe bi jur na njuumte.
Laaj bees mujje yónne dàttub njoxe bi moo doon :
« $1 »
bàyyikoo ci bii solo « $2 ».
Dàttub njoxe bi delloo bii njuumte « $3 : $4 ».',
	'directorycreateerror' => 'Sosug wayndare bii di « $1 » antuwul.',
	'deletedhist' => 'Jaar-jaaru far gi',
	'difference' => '(Wuute gi ci sumb yi)',
	'diff-multi' => '({{PLURAL:$1|am sumb mu diggu feeñul|$1 sumb yu diggu feeñuñu}}.)',
	'datedefault' => 'Benn tànneef',
	'defaultns' => 'Walla nga seet ci barabi tur yi:',
	'default' => 'wàccaale',
	'diff' => 'wuute',
	'destfilename' => 'Tur bi nga bëgg a jox ŋara wi:',
	'duplicatesoffile' => '{{PLURAL:$1|Dencukaay bii|$1 Dencukaay  yii}} di toftal {{PLURAL:$1|ab duppitu|ay duppitu}} bii {{PLURAL:$2|la|lañu}} ([[Special:FileDuplicateSearch/$2|yeneeni faramfacce]])::',
	'download' => 'yebbi',
	'disambiguations' => 'Xëti turandoo',
	'disambiguationspage' => 'Template:turandoo',
	'disambiguations-text' => "Xët yii di toftal dañoo ëmb ay lëkkalekaay yuy jëme ciy '''xëti turandoo'''.
Dañoo waroon a jublu ci jukki yu baax. <br />
Xëti turandoo yi ñooy yi ëmb benn ci royuwaay yees def fii [[MediaWiki:Disambiguationspage]]",
	'doubleredirects' => 'Jubluwaat ñaari yoon',
	'doubleredirectstext' => "Wii xët dafa ëmb mbooleem xët yees jubluwaatal ci yeneen xëti jubluwaat.
Rëdd wu ne am na lëkkalekaay buy jëme ci bu njëkk ak ñaareelu jubluwaat bi, ak rëdduw mbind wu njëkk wu ñaareelu jubluwaat bi, biy ëmb xëtu jëmuwaay wu ''baax'' wi, wi jubluwaat bu njëkk bi war a jublu moom itam.",
	'double-redirect-fixed-move' => '[[$1]] tuddewaat nañu ko.
Léegi mi ngi jublu [[$2]].',
	'double-redirect-fixer' => 'Jubbantikaayu jubluwaat',
	'deadendpages' => 'Xët yi amul génnuwaay',
	'deadendpagestext' => 'Xët yii di toftal lëkkaloowuñu ak wenn xët ci bii wiki',
	'deletedcontributions' => 'Cëru yees far',
	'deletedcontributions-title' => 'Cëru yees far',
	'defemailsubject' => 'M-bataaxalu {{SITENAME}}',
	'deletepage' => 'Far xët wi',
	'delete-confirm' => 'Far « $1 »',
	'delete-legend' => 'Far',
	'deletedtext' => '« $1 » far nañu ko.
Xolal $2 ngir gis limu farte bi mujj.',
	'dellogpage' => 'Jaar-jaaru farte bi',
	'dellogpagetext' => 'Li toftal ab limu farte yi mujj la.',
	'deletionlog' => 'jaar-jaaru  farte bi',
	'deletecomment' => 'Ngirte :',
	'deleteotherreason' => 'Yeneeni ngirte :',
	'deletereasonotherlist' => 'Yeneeni ngirte',
	'deletereason-dropdown' => '*Ngirtey farte yi gëna bari
** Aji-sos jee ko deflu
** Jalgati aqi aji-sos
** Caay-caay',
	'delete-edit-reasonlist' => 'Soppi ngirtey farte gi',
	'delete-toobig' => 'Xët wii dafa am jaar-jaar bu bari, bu weesu $1 {{PLURAL:$1|sumb|sumb}}. Farteg yooyule xët dañu koo digal ngir bañ ay jafe-jafe yu mana am ci doxinu {{SITENAME}}.',
	'delete-warning-toobig' => 'Xët wii dafa am jaar-jaar bu bari, bu weesu $1 {{PLURAL:$1|sumb|sumb}}. Seenug farte man naa jur ag jaxasoo ci dáttub njoxeeb {{SITENAME}} ; def ko ak teey.',
	'databasenotlocked' => 'Kenn caabiwul dàttub njoxe bi',
	'delete_and_move' => 'Far te tuddewaat',
	'delete_and_move_text' => '== Laajub far ==
Xët wi nga joge niki àgguwaay « [[:$1]] » am na fi.
Dëgg-dëgg namm nga koo far ngir tuddewaat gi mana antu?',
	'delete_and_move_confirm' => 'Waaw, faral xët wi',
	'delete_and_move_reason' => 'Far nañu ko ngir mana amal tuddewaat gi',
);

$messages['wuu'] = array(
	'december' => '12月',
	'december-gen' => '十二月',
	'dec' => '12月',
	'delete' => '删除',
	'deletethispage' => '删除此页',
	'disclaimers' => '免责声明',
	'disclaimerpage' => 'Project:免责声明',
	'databaseerror' => '数据库错误',
	'dberrortext' => '发生仔数据库查询语法错误，作兴是软件自身个错误所引起个。压末一趟数据库查询指令是：
<blockquote><tt>$1</tt></blockquote>
来自函数“<tt>$2</tt>”内。数据库返回错误“<tt>$3: $4</tt>”。',
	'dberrortextcl' => '发生了数据库查询语法错误。压末一趟数据库查询指令是：
“$1”
来自函数“$2”内。数据库返回错误“$3: $4”。',
	'directorycreateerror' => '创建目录“$1”失败。',
	'deletedhist' => '已删除之历史',
	'difference' => '（修订版本间差异）',
	'diff-multi' => '（$1个中途个修订版本无没显示。）',
	'datedefault' => '呒拨偏好',
	'default' => '默认',
	'diff' => '两样',
	'destfilename' => '目标文件名:',
	'download' => '下载',
	'deletepage' => '删脱页面',
	'deletedtext' => '"$1"已经删除。最近删除记录请参见$2。',
	'dellogpage' => '删除记录',
	'deletionlog' => '删除记录',
	'deletecomment' => '理由:',
	'deleteotherreason' => '其它／附加理由：',
	'deletereasonotherlist' => '别个理由',
	'delete_and_move' => '删脱搭仔捅荡',
	'delete_and_move_confirm' => '对哉，删脱该只页面',
	'deletedrevision' => '拨删脱个旧修订 $1',
	'descending_abbrev' => '降序',
);

$messages['xal'] = array(
	'december' => 'Бар сар',
	'december-gen' => 'Бар сарин',
	'dec' => 'Бар',
	'delete' => 'Һарһх',
	'deletethispage' => 'Эн халхиг һарһх',
	'disclaimers' => 'Дааврас эс зөвшәрлһн',
	'disclaimerpage' => 'Project:Даарас эс зөвшәрлһн',
	'databaseerror' => 'Өггцнә базин эндү',
	'dberrortext' => 'Өггцнә базд сурврин синтаксисин эндү аҗглв.
Эн заклһна теткүлин эндү болвза.
Шидрә өггцнә базд сурвр:
<blockquote><tt>$1</tt></blockquote>
<tt>«$2»</tt> функцас һарад бәәнә.
Өггцнә баз <tt>«$3: $4»</tt> эндү хәрү өгв.',
	'dberrortextcl' => 'Өггцнә базд сурврин синтаксисин эндү аҗглв.
Шидрә өггцнә базд сурвр:
«$1»
«$2» функцас һарад бәәнә.
Өггцнә баз «$3: $4» эндү хәрү өгв.',
	'difference' => '(Йилһән)',
	'datedefault' => 'Келхлә уга',
	'diff' => 'йилһ',
	'deletepage' => 'Эн халхиг һарһҗ',
	'delete-confirm' => '$1 һарһх',
	'delete-legend' => 'Һарһлһн',
	'deletedtext' => '«$1» һарһҗ болв.
$2 шидрә һарһлһна төлә хәләтн.',
	'dellogpage' => 'Һарһллһна сеткүл',
	'deletecomment' => 'Учр:',
	'deleteotherreason' => 'Талдан аль дәкәд учр:',
	'deletereasonotherlist' => 'Талдан учр',
);

$messages['xh'] = array(
	'december' => 'Eyo Mnga',
	'december-gen' => 'Eyo Mnga',
	'delete' => 'Cima',
);

$messages['xmf'] = array(
	'december' => 'ქირსეთუთა',
	'december-gen' => 'ქირსეთუთაშ',
	'dec' => 'ქირ.',
	'delete' => 'ლასუა',
	'deletethispage' => 'დოლასი თე ხასჷლა',
	'disclaimers' => 'გამამინჯალაშ ვარება',
	'disclaimerpage' => 'Project:გამამინჯალაშ ვარება',
	'difference' => '(ვერსიეფშკას შხვაოფეფ)',
	'diff-multi' => '( {{PLURAL:$2|ართი მახვარებუშ|$2 მახვარებუშ}} {{PLURAL:$1|ართი შქაშქუმალირი რევიზია|$1 შქაშქუმალირი რევიზია}} ვა რე ძირაფილი)',
	'diff' => 'შხვანერობა',
	'disambiguationspage' => 'Template:ანდობურმნიშვნელიანი',
	'deletepage' => 'ხასილაშ ლასუა',
	'deletedtext' => '"$1\\" ლასირქ იყ’უ.
ასერდე ლასირ ხასილეფიშ ერკებულ ქოძირით $2–ს.',
	'dellogpage' => 'ლასირეფიშ ერკებულ',
	'deletecomment' => 'სამანჯელ:',
	'deleteotherreason' => 'შხვა/გეძინელ სამანჯელ:',
	'deletereasonotherlist' => 'შხვა სამანჯელ',
	'duplicate-defaultsort' => '\'\'გური ქუჩით:\'\'\' სტანდარტული დანწყუალაშ კილა "$2"-შო გინარჯგინანს ორდონი დონწყუალაშ კილა "$1"-ს.',
);

$messages['yi'] = array(
	'december' => 'דעצעמבער',
	'december-gen' => 'דעצעמבער',
	'dec' => 'דעצ׳',
	'delete' => 'אויסמעקן',
	'deletethispage' => 'אויסמעקן דעם בלאַט',
	'disclaimers' => 'געזעצליכע אויפֿקלערונג',
	'disclaimerpage' => 'Project:קלארשטעלונג',
	'databaseerror' => 'דאטנבאזע פעלער',
	'dberrortext' => 'א דאטנבאזע זוכונג סינטאקס גרייז האט פאסירט.
דאס טעות קען זיין צוליב א באג אינעם ווייכווארג.
די לעצטע דאטנבאזע זוכונג איז געווען:
<blockquote><tt>$1</tt></blockquote>
פון דער פונקציע "<tt>$2</tt>".
דאטנבאזע האט צוריקגעגעבן גרייז "<tt>$3: $4</tt>".',
	'dberrortextcl' => 'א דאטנבאזע זוכונג סינטאקס גרייז האט פאסירט.
די לעצטע דאטנבאזע זוכונג איז געווען:
"$1"
פון דער פונקציע "$2".
דאטנבאזע האט צוריקגעגעבן גרייז "$3: $4".',
	'directorycreateerror' => 'קען נישט באשאפן דירעקטארי "$1".',
	'deletedhist' => 'אויסגעמעקטע ווערסיעס',
	'difference' => '(אונטערשייד צווישן ווערסיעס)',
	'difference-multipage' => '(אונטערשייד צווישן בלעטער)',
	'diff-multi' => '({{PLURAL:$1|איין מיטלסטע ווערסיע |$1 מיטלסטע ווערסיעס}} פֿון {{PLURAL:$2|איין באַניצער|$2 באַניצער}} נישט געוויזן.)',
	'diff-multi-manyusers' => '({{PLURAL:$1|איין מיטלסטע ווערסיע |$1 מיטלסטע ווערסיעס}} פֿון מער ווי {{PLURAL:$2|איין באַניצער|$2 באַניצער}} נישט געוויזן.)',
	'datedefault' => 'נישטא קיין פרעפערענץ',
	'defaultns' => 'אנדערשט זוך אין די נאמענטיילן:',
	'default' => 'גרונטלעך',
	'diff' => 'אונטערשייד',
	'destfilename' => 'ציל טעקע נאמען:',
	'duplicatesoffile' => 'די פֿאלגנדע {{PLURAL:$1|טעקע דופליקירט|$1 טעקעס דופליקירן}} די דאזיגע טעקע ([[Special:FileDuplicateSearch/$2|נאך פרטים]]):',
	'download' => 'אַראָפלאָדן',
	'disambiguations' => 'בלעטער וואס פֿארבינדן מיט באדייטן בלעטער',
	'disambiguationspage' => 'Template:באדייטן',
	'disambiguations-text' => "די קומענדיגע בלעטער פארבינדען צו א '''באדייטן בלאט'''. זיי ברויכן ענדערשט פֿארבינדן צו דער רעלעוואנטער טעמע בלאט.<br />א בלאט ווערט פאררעכענט אלס א בלאט ווערט גערעכנט פאר א באדײַטן בלאט אויב ער באניצט זיך מיט א מוסטער וואס איז פארבינדען פון [[MediaWiki:Disambiguationspage]].",
	'doubleredirects' => 'געטאפלטע ווײַטערפֿירונגען',
	'doubleredirectstext' => 'דער בלאט רעכנט אויס בלעטער וואס פירן ווייטער צו אנדערע ווייטערפירן בלעטער.
יעדע שורה אנטהאלט א לינק צום ערשטן און צווייטן ווייטערפירונג, ווי אויך די ציל פון דער צווייטער ווייטערפירונג, וואס רוב מאל געפינט זיך די ריכטיגע ציל וואו די ערשטע ווייטערפירונג זאל ווייזן.
<del>אויסגעשטראכענע</del> טעמעס זענען שוין געלייזט.',
	'double-redirect-fixed-move' => '[[$1]] איז געווארן באוועגט, און איז יעצט א ווייטערפֿירונג צו [[$2]]',
	'double-redirect-fixed-maintenance' => 'פֿאַררעכטן געטאפלטע ווײַטערפֿירונג פֿון [[$1]] צו [[$2]].',
	'double-redirect-fixer' => 'מתקן ווײַטערפֿירונגען',
	'deadendpages' => 'בלינדע בלעטער',
	'deadendpagestext' => 'די פאלגנדע בלעטער לינקען נישט צו קיין אנדערע בלעטער אין דער וויקי.',
	'deletedcontributions' => 'אויסגעמעקטע באַניצער בײַשטײַערונגען',
	'deletedcontributions-title' => 'אויסגעמעקטע באַניצער בײַשטײַערונגען',
	'defemailsubject' => 'ע-פאסט פון באַניצער "$1" {{SITENAME}}',
	'deletepage' => 'מעק אויס בלאט',
	'delete-confirm' => 'אויסמעקן $1',
	'delete-legend' => 'אויסמעקן',
	'deletedtext' => '"$1" אויסגעמעקט.
זעט $2 פֿאַר א רשימה פֿון לעצטיגע אויסמעקונגען.',
	'dellogpage' => 'אויסמעקונג לאג',
	'dellogpagetext' => 'ווייטער איז א ליסטע פון די מערסט לעצטיגע אויסמעקונגען.',
	'deletionlog' => 'אויסמעקונג לאג',
	'deletecomment' => 'אורזאַך:',
	'deleteotherreason' => 'אנדער/נאך אן אורזאך:',
	'deletereasonotherlist' => 'אנדער אורזאך',
	'deletereason-dropdown' => '* געוויינטלעכע אויסמעקן אורזאכן
** פֿארלאנג פֿון שרייבער
** קאפירעכט ברעכונג
** וואנדאליזם
** נישט יידיש',
	'delete-edit-reasonlist' => 'רעדאַקטירן די אויסמעקן סיבות',
	'delete-toobig' => 'דער בלאַט האט א גרויסע רעדאקטירונג היסטאריע, מער ווי $1 {{PLURAL:$1|רעוויזיע|רעוויזיעס}}. אויסמעקן אזעלכע בלעטער איז באַגרענעצט געווארן בכדי צו פֿאַרמײַדן א צופֿעליגע פֿאַרשטערונג פֿון  {{SITENAME}}.',
	'delete-warning-toobig' => 'דער בלאַט האט א גרויסע רעדאקטירונג היסטאריע, מער ווי $1 {{PLURAL:$1|רעוויזיע|רעוויזיעס}}. אויסמעקן אים קען פֿאַרשטערן דאַטנבאַזע אפעראַציעס פֿון {{SITENAME}}; זײַט פֿארזיכטיג איידער איר מעקט אויס.',
	'databasenotlocked' => 'די דאַטנבאַזע איז נישט פֿאַרשלאסן.',
	'delete_and_move' => 'אויסמעקן און באוועגן',
	'delete_and_move_text' => '== אויסמעקן פארלאנגט ==
דער ציל בלאַט "[[:$1]]" עקזיסטירט שוין.
צי ווילט איר אים אויסמעקן כדי צו ערמעגליכן די באוועגונג?',
	'delete_and_move_confirm' => 'יא, מעק אויס דעם בלאט',
	'delete_and_move_reason' => 'אויסגעמעקט כדי צו קענען באוועגן פֿון "[[$1]]"',
	'djvu_page_error' => 'DjVu בלאט ארויס פֿון גרייך',
	'djvu_no_xml' => "מ'קען נישט באקומען דעם XML פֿאַר דער DjVu טעקע",
	'deletedrevision' => 'אויסגעמעקט אלטע ווערסיע $1.',
	'deletedwhileediting' => 'ווארענונג: דער בלאט איז געווארן אויסגעמעקט נאכדעם וואס איר האט אנגעהויבן רעדאקטירן!',
	'descending_abbrev' => 'נידערן',
	'duplicate-defaultsort' => '\'\'\'ווארענונג:\'\'\' גרונט סארטשליסל "$2" פֿאָרט איבערן פֿריערדיגן גרונט סארטשליסל "$1".',
	'dberr-header' => 'די וויקי האט א פראבלעם',
	'dberr-problems' => 'אנטשולדיגט! דער דאזיקער סייט האט טעכנישע פראבלעמען.',
	'dberr-again' => 'וואַרט א פאָר מינוט און לאָדנט אָן ווידער.',
	'dberr-info' => '(קען נישט פֿאַרבינדן מיטן דאַטנבאַזע באַדינער: $1)',
	'dberr-usegoogle' => 'אינצווישנצײַט קענט איר פרובירן זוכן דורך גוגל.',
	'dberr-outofdate' => 'גיט אַכט אַז זײַערע אינדעקסן פֿון אונזער אינהאַלט איז מעגלעך פֿאַרעלטערט.',
	'dberr-cachederror' => 'דאָס איז אַן אײַנגעשפייכלערט קאפיע פֿון  דעם געפֿאדערטן בלאַט, און קען זײַן פֿאַרעלטערט.',
);

$messages['yo'] = array(
	'december' => 'Oṣù Kejìlá',
	'december-gen' => 'Oṣù Kejìlá',
	'dec' => 'Oṣù 12',
	'delete' => 'Ìparẹ́',
	'deletethispage' => 'Pa ojúewé yi rẹ́',
	'disclaimers' => 'Ikìlọ̀',
	'disclaimerpage' => 'Project:Ìkìlọ̀ gbogbo',
	'databaseerror' => 'Àsìṣe ibùdó dátà',
	'directorycreateerror' => 'Kò le dá àpò "$1".',
	'deletedhist' => 'Ìtàn ìparẹ́',
	'difference' => '(Ìyàtọ̀ láàrin àwọn àtúnyẹ́wò)',
	'datedefault' => 'Kò sí ìfẹ́ràn',
	'default' => 'níbẹ̀rẹ̀',
	'diff' => 'ìyàtọ̀',
	'destfilename' => 'Ìdópin orúkọ fáìlì:',
	'download' => 'ìrùsílẹ̀',
	'disambiguations' => 'Àwọn ojúewé ìpínsọ́tọ̀',
	'disambiguationspage' => 'Template:ojútùú',
	'doubleredirects' => 'Àwọn àtúnjúwe ẹ̀mẹjì',
	'double-redirect-fixed-move' => '[[$1]] ti yípò padà.
Ó ti ṣe àtúnjúwe sí [[$2]].',
	'deadendpages' => 'Àwọn ojúewé aláìníjàápọ́',
	'deadendpagestext' => 'Àwọn ojúewé wọ̀nyí kò jápọ̀ mọ́ àwọn ojúewé míràn ní {{SITENAME}}.',
	'deletedcontributions' => 'Àwọn àfikún píparẹ́ oníṣe',
	'deletedcontributions-title' => 'Àwọn àfikún píparẹ́ oníṣe',
	'defemailsubject' => 'e-mail {{SITENAME}}',
	'deletepage' => 'Ìparẹ́ ojúewé',
	'delete-confirm' => 'Ìparẹ́ "$1"',
	'delete-legend' => 'Paárẹ́',
	'deletedtext' => 'A ti pa "<nowiki>$1</nowiki>" rẹ́.
Ẹ wo $2 fún àkọọ́lẹ̀ àwọn ìparẹ́ àìpẹ́.',
	'deletedarticle' => 'A ti pa "[[$1]]" rẹ́',
	'dellogpage' => 'Àkọsílẹ̀ ìparẹ́',
	'deletionlog' => 'àkọsílẹ̀ ìparẹ́',
	'deletecomment' => 'Ìdíẹ̀:',
	'deleteotherreason' => 'Àwọn ìdí mìíràn:',
	'deletereasonotherlist' => 'Ìdí mìíràn',
	'deletereason-dropdown' => '*Àwọn ìdí tówọ́pọ̀ fún ìparẹ́
**Olùkọ̀wé ló tọrọ
**Àìtẹ̀lé ẹ́tọ́àwòkọ
**Ìbàjẹ́',
	'delete-edit-reasonlist' => 'Àtúnṣe àwọn ìdí ìparẹ́',
	'delete_and_move' => 'Parẹ́ kí o sì yípò',
	'delete_and_move_text' => '== Ìparẹ́ pọndandan ==
Ojúewé àdésí "[[:$1]]" wà tẹ́lẹ̀tẹ́lẹ̀.
Ṣé ẹ fẹ́ paárẹ́ láti sínà fún ìyípò?',
	'delete_and_move_confirm' => 'Bẹ́ẹ̀ni, pa ojúewé náà rẹ́',
	'descending_abbrev' => 'relẹ̀',
	'dberr-header' => 'Wiki yìí ní ìsòro',
);

$messages['yue'] = array(
	'december' => '12月',
	'december-gen' => '十二月',
	'dec' => '12月',
	'delete' => '刪除',
	'deletethispage' => '刪除呢頁',
	'disclaimers' => '免責聲明',
	'disclaimerpage' => 'Project:一般免責聲明',
	'databaseerror' => '資料庫錯誤',
	'dberrortext' => '資料庫查詢語法錯咗。
咁係可能指出軟件中可能有臭蟲。
最後一次資料庫嘅嘗試係：
<blockquote><tt>$1</tt></blockquote>
於 "<tt>$2</tt>" 功能中。
數據庫嘅錯誤回應 "<tt>$3: $4</tt>"。',
	'dberrortextcl' => '資料庫查詢語法錯咗。
最後一次資料庫嘅嘗試係：
"$1"
於 "$2"功能中。
數據庫嘅錯誤回應 "$3: $4"',
	'directorycreateerror' => '目錄 "$1" 開唔到。',
	'deletedhist' => '刪除咗嘅歷史',
	'difference' => '（修訂之間嘅差異）',
	'difference-multipage' => '（版之間嘅差異）',
	'diff-multi' => '（由$2位用戶所做嘅$1個中途修訂冇顯示到）',
	'diff-multi-manyusers' => '（由$2位更多用戶所做嘅$1個中途修訂冇顯示到）',
	'datedefault' => '冇喜好',
	'defaultns' => '否則喺呢啲空間名搵嘢：',
	'default' => '預設',
	'diff' => '差異',
	'destfilename' => '目標檔名:',
	'duplicatesoffile' => '下面嘅$1個檔案係同呢個檔案重覆 ([[Special:FileDuplicateSearch/$2|更多細節]]):',
	'download' => '下載',
	'disambiguations' => '搞清楚頁',
	'disambiguationspage' => 'Template:disambig
Template:搞清楚',
	'disambiguations-text' => "以下呢啲頁面連結去一個'''搞清楚頁'''。佢哋先至應該指去正確嘅主題。<br />如果一個頁面連結自[[MediaWiki:Disambiguationspage]]，噉就會當佢係搞清楚頁。",
	'doubleredirects' => '雙重跳轉',
	'doubleredirectstext' => '每一行都順次序寫住第一頁名，佢嘅目的頁，同埋目的頁再指去邊度。改嘅時候，應該將第一個跳轉頁轉入第三頁。
<del>劃咗</del>嘅項目係已經解決咗嘅。',
	'double-redirect-fixed-move' => '[[$1]]已經搬好咗，佢而家跳轉過去[[$2]]。',
	'double-redirect-fixed-maintenance' => '修復[[$1]]嘅重定向到[[$2]]。',
	'double-redirect-fixer' => '跳轉修正器',
	'deadendpages' => '掘頭頁',
	'deadendpagestext' => '呢啲頁無連到{{SITENAME}}內嘅任何一頁。',
	'deletedcontributions' => '已經刪除咗嘅用戶貢獻',
	'deletedcontributions-title' => '已經刪除咗嘅用戶貢獻',
	'defemailsubject' => '{{SITENAME}} 電郵',
	'deletepage' => '刪除頁面',
	'delete-confirm' => '刪除"$1"',
	'delete-legend' => '刪除',
	'deletedtext' => '"$1"已經刪除。最近嘅刪除記錄請睇$2。',
	'dellogpage' => '刪除日誌',
	'dellogpagetext' => '以下係最近嘅刪除清單。',
	'deletionlog' => '刪除日誌',
	'deletecomment' => '原因：',
	'deleteotherreason' => '其它／附加嘅原因:',
	'deletereasonotherlist' => '其它原因',
	'deletereason-dropdown' => '*常用刪除原因
** 作者請求
** 侵犯版權
** 破壞',
	'delete-edit-reasonlist' => '編輯刪除原因',
	'delete-toobig' => '呢一版有一個好大量嘅編輯歷史，過咗$1次修訂。刪除呢類版嘅動作已經限制咗，以防止響{{SITENAME}}嘅意外擾亂。',
	'delete-warning-toobig' => '呢一版有一個好大量嘅編輯歷史，過咗$1次修訂。刪除佢可能會擾亂{{SITENAME}}嘅資料庫操作；響繼續嗰陣請小心。',
	'databasenotlocked' => '資料庫而家冇鎖到。',
	'delete_and_move' => '刪除並移動',
	'delete_and_move_text' => '==需要刪除==

目標頁「[[:$1]]」已經存在。你要唔要刪咗佢空個位出嚟畀個搬文動作？',
	'delete_and_move_confirm' => '好，刪咗嗰個頁面',
	'delete_and_move_reason' => '已經刪咗嚟畀位畀個搬文動作',
	'djvu_page_error' => 'DjVu頁超出範圍',
	'djvu_no_xml' => '唔能夠響DjVu檔度攞個XML',
	'deletedrevision' => '刪除咗$1嘅舊有修訂',
	'deletedwhileediting' => '警告：你寫緊文嗰陣，有用戶洗咗呢版！',
	'descending_abbrev' => '減',
	'duplicate-defaultsort' => '警告: 預設嘅排序鍵 "$2" 覆蓋之前嘅預設排序鍵 "$1"。',
	'dberr-header' => '呢個 wiki 出咗問題',
	'dberr-problems' => '對唔住！
呢一版出現咗一啲技術性問題。',
	'dberr-again' => '試吓等多幾分種然後開試。',
	'dberr-info' => '(唔能夠連繫個資料伺服器: $1)',
	'dberr-usegoogle' => '響現階段你可以用 Google 去搵嘢。',
	'dberr-outofdate' => '留意佢哋索引嘅內容可能會過時。',
	'dberr-cachederror' => '呢個係所要求版嘅快取複本，可能會過時。',
);

$messages['za'] = array(
	'december' => 'Nin Cwbx Yeih',
	'december-gen' => 'Cibngeih nyied',
	'dec' => 'Cibngeihnyied',
	'delete' => 'Duz',
	'disclaimers' => 'gangjmingz mienxcwz',
	'disclaimerpage' => 'Project:Itbuen mienxcwz',
	'diff' => 'Faenbied',
);

$messages['zea'] = array(
	'december' => 'december',
	'december-gen' => 'december',
	'dec' => 'dec',
	'delete' => 'Wissen',
	'deletethispage' => 'Wis deêze bladzie',
	'disclaimers' => 'Voebehoud',
	'disclaimerpage' => 'Project:Alhemeên voebehoud',
	'databaseerror' => 'Databasefout',
	'dberrortext' => "Der is een syntaxisfout in 't databaseverzoek opetreeën.
Meuhlijk zit der een fout in de software.
't Lèste verzoek an de database was:
<blockquote><tt>$1</tt></blockquote>
vanuut de functie “<tt>$2</tt>”.
MySQL haf de foutmeldieng “<tt>$3: $4</tt>”.",
	'dberrortextcl' => "Der is een syntaxisfout in 't databaseverzoek opetreeën.
't Lèste verzoek an de database was:
“$1”
vanuut de functie “$2”.
MySQL haf de volhende foutmeldieng: “$3: $4”",
	'directorycreateerror' => 'Map “$1” kon nie anemikt worn.',
	'deletedhist' => 'Verwiederde heschiedenisse',
	'difference' => '(Verschil tussen bewerkiengen)',
	'diff-multi' => 'Von {{PLURAL:$2|eên gebruker|$2 gebrukers}} ({{PLURAL:$1|wor eên tussenlihhende versie|worn $1 tussenlihhende versies}} nie weereheven)',
	'datedefault' => 'Hin vòkeur',
	'defaultns' => "Standard in deêze naemruum'n zoeken:",
	'default' => 'standard',
	'diff' => 'wiez',
	'disambiguationspage' => 'Template:Deurverwiespagina',
	'dellogpage' => 'Wislogboek',
	'duplicate-defaultsort' => 'Waerschiewienge: De standaardsorterienge "$2" kriet vòrang vò de sorterienge "$1".',
);

$messages['zh-hans'] = array(
	'december' => '12月',
	'december-gen' => '十二月',
	'dec' => '12月',
	'delete' => '删除',
	'deletethispage' => '删除本页',
	'disclaimers' => '免责声明',
	'disclaimerpage' => 'Project:免责声明',
	'databaseerror' => '数据库错误',
	'dberrortext' => '发生了数据库查询语法错误，可能是由于软件自身的错误所引起。最后一次数据库查询指令是：
<blockquote><tt>$1</tt></blockquote>
来自函数“<tt>$2</tt>”内。数据库返回错误“<tt>$3: $4</tt>”。',
	'dberrortextcl' => '发生了数据库查询语法错误。最后一次数据库查询指令是：
“$1”
来自函数“$2”内。数据库返回错误“$3: $4”。',
	'directorycreateerror' => '无法创建目录“$1”。',
	'deletedhist' => '已删除历史',
	'difference' => '（版本间的差异）',
	'difference-multipage' => '（页面间的差异）',
	'diff-multi' => '（未显示$2个用户的$1个中间版本）',
	'diff-multi-manyusers' => '（未显示超过$2个用户的$1个中间版本）',
	'datedefault' => '默认值',
	'defaultns' => '否则在这些名字空间中搜索：',
	'default' => '默认',
	'diff' => '差异',
	'destfilename' => '目标文件名：',
	'duplicatesoffile' => '以下的$1个文件跟这个文件重复（[[Special:FileDuplicateSearch/$2|更多细节]]）：',
	'download' => '下载',
	'disambiguations' => '链接到消歧义页的页面',
	'disambiguationspage' => 'Template:消歧义',
	'disambiguations-text' => "以下的页面都有到'''消歧义页'''的链接，但它们应该链接到适当的页面。<br />一个页面如果使用了[[MediaWiki:Disambiguationspage]]内的模板，则会被视为消歧义页。",
	'doubleredirects' => '双重重定向页',
	'doubleredirectstext' => '此页列出了所有重定向到另一重定向页面的页面。每一行都包含有到第一和第二个重定向页面的链接，以及第二个重定向页面的目标——通常就是“真正的”目标页面，亦即是第一个重定向页面应该指向的页面。<del>已划去</del>的为已经解决的项目。',
	'double-redirect-fixed-move' => '[[$1]]已被移动。它现在重定向至[[$2]]。',
	'double-redirect-fixed-maintenance' => '修复双重重定向自[[$1]]至[[$2]]。',
	'double-redirect-fixer' => '重定向页修复器',
	'deadendpages' => '断链页面',
	'deadendpagestext' => '以下页面没有链接到{{SITENAME}}中的其它页面。',
	'deletedcontributions' => '已删除的用户贡献',
	'deletedcontributions-title' => '已删除的用户贡献',
	'defemailsubject' => "{{SITENAME}} 来自用户''$1''的电子邮件",
	'deletepage' => '删除页面',
	'delete-confirm' => '删除“$1”',
	'delete-legend' => '删除',
	'deletedtext' => '"$1"已经被删除。最近删除的记录请参见$2。',
	'dellogpage' => '删除日志',
	'dellogpagetext' => '以下是最近的删除的列表。',
	'deletionlog' => '删除记录',
	'deletecomment' => '原因：',
	'deleteotherreason' => '其他/附加原因：',
	'deletereasonotherlist' => '其他原因',
	'deletereason-dropdown' => '*常见删除原因
** 作者申请
** 侵犯著作权
** 破坏行为',
	'delete-edit-reasonlist' => '编辑删除理由',
	'delete-toobig' => '这个页面有一个十分大量的编辑历史，超过$1次修订。删除此类页面的动作已经被限制，以防止在{{SITENAME}}上的意外扰乱。',
	'delete-warning-toobig' => '这个页面有一个十分大量的编辑历史，超过$1次修订。删除它可能会扰乱{{SITENAME}}的数据库操作；在继续此动作前请小心。',
	'databasenotlocked' => '数据库没有锁定。',
	'delete_and_move' => '删除并移动',
	'delete_and_move_text' => '==　需要删除　==

目标页面“[[:$1]]”已存在。是否确认删除该页面以便进行移动？',
	'delete_and_move_confirm' => '是，删除该页面',
	'delete_and_move_reason' => '删除以便移动[[$1]]',
	'djvu_page_error' => 'DjVu页面超出范围',
	'djvu_no_xml' => '无法在DjVu文件中获取XML',
	'deletedrevision' => '已删除旧版本$1',
	'days' => '$1天',
	'deletedwhileediting' => "'''警告'''：此页在您开始编辑之后已经被删除！",
	'descending_abbrev' => '降',
	'duplicate-defaultsort' => "'''警告：'''默认排序关键字“$2”覆盖了之前的默认排序关键字“$1”。",
	'dberr-header' => '本wiki出现了问题',
	'dberr-problems' => '抱歉！
本网站出现了一些技术问题。',
	'dberr-again' => '请等待几分钟后重试。',
	'dberr-info' => '（无法连接到数据库服务器：$1）',
	'dberr-usegoogle' => '在此期间您可以尝试用Google来搜索。',
	'dberr-outofdate' => '须注意他们索引出来的内容可能不是最新的。',
	'dberr-cachederror' => '这是所请求页面的缓存副本，可能不是最新的。',
);

$messages['zh-hant'] = array(
	'december' => '12月',
	'december-gen' => '十二月',
	'dec' => '12月',
	'delete' => '刪除',
	'deletethispage' => '刪除本頁',
	'disclaimers' => '免責聲明',
	'disclaimerpage' => 'Project:一般免責聲明',
	'databaseerror' => '資料庫錯誤',
	'dberrortext' => '發生資料庫查詢語法錯誤。
可能是由於軟體自身的錯誤所引起。
最後一次資料庫查詢指令是:
<blockquote><tt>$1</tt></blockquote>
來自於函數 "<tt>$2</tt>"。
數據庫返回錯誤 "<tt>$3: $4</tt>"。',
	'dberrortextcl' => '發生了一個資料庫查詢語法錯誤。
最後一次的資料庫查詢是:
「$1」
來自於函數「$2」。
數據庫返回錯誤「$3: $4」。',
	'directorycreateerror' => '無法建立目錄"$1"。',
	'deletedhist' => '已刪除之歷史',
	'difference' => '（修訂版本間的差異）',
	'difference-multipage' => '（頁面間的差異）',
	'diff-multi' => '（由{{PLURAL:$2|1名用戶|$2名用戶}}作出的{{PLURAL:$1|一個中途修訂版本|$1個中途修訂版本}}未被顯示）',
	'diff-multi-manyusers' => '（由多於$2名用戶作出的{{PLURAL:$1|一個中途修訂版本|$1個中途修訂版本}} 未被顯示）',
	'datedefault' => '預設值',
	'defaultns' => '否則在這些名字空間搜尋：',
	'default' => '預設',
	'diff' => '差異',
	'destfilename' => '目標檔案名：',
	'duplicatesoffile' => '以下的$1個檔案跟這個檔案重覆（[[Special:FileDuplicateSearch/$2|更多細節]]）：',
	'download' => '下載',
	'disambiguations' => '鏈接到消歧義頁的頁面',
	'disambiguationspage' => 'Template:disambig
Template:消含糊
Template:消除含糊
Template:消歧义
Template:消除歧义
Template:消歧義
Template:消除歧義',
	'disambiguations-text' => "以下的頁面都有到'''消歧義頁'''的鏈接，但它們應該鏈接到適當的頁面。<br />一個頁面如果使用了[[MediaWiki:Disambiguationspage]]內的模板，則會被視為消歧義頁。",
	'doubleredirects' => '雙重重定向頁面',
	'doubleredirectstext' => '這一頁列出所有重定向頁面重定向到另一個重定向頁的頁面。每一行都包含到第一和第二個重定向頁面的連結，以及第二個重定向頁面的目標，通常顯示的都會是"真正"的目標頁面，也就是第一個重定向頁面應該指向的頁面。
<del>已劃去</del>的為已經解決之項目。',
	'double-redirect-fixed-move' => '[[$1]]已經完成移動，它現在重新定向到[[$2]]。',
	'double-redirect-fixed-maintenance' => '修復從[[$1]]到[[$2]]的雙重重定向。',
	'double-redirect-fixer' => '重新定向修正器',
	'deadendpages' => '斷連頁面',
	'deadendpagestext' => '以下頁面沒有連結到{{SITENAME}}中的其它頁面。',
	'deletedcontributions' => '已刪除的用戶貢獻',
	'deletedcontributions-title' => '已刪除的用戶貢獻',
	'defemailsubject' => '{{SITENAME}}用戶 $1 發送電子郵件',
	'deletepage' => '刪除頁面',
	'delete-confirm' => '刪除「$1」',
	'delete-legend' => '刪除',
	'deletedtext' => '「$1」已經被刪除。最近刪除的記錄請參見$2。',
	'dellogpage' => '刪除紀錄',
	'dellogpagetext' => '以下是最近的刪除的列表。',
	'deletionlog' => '刪除紀錄',
	'deletecomment' => '理由：',
	'deleteotherreason' => '其它／附加的理由:',
	'deletereasonotherlist' => '其它理由',
	'deletereason-dropdown' => '*常用刪除理由
** 作者請求
** 侵犯版權
** 破壞',
	'delete-edit-reasonlist' => '編輯刪除理由',
	'delete-toobig' => '這個頁面有一個十分大量的編輯歷史，超過$1次修訂。刪除此類頁面的動作已經被限制，以防止在{{SITENAME}}上的意外擾亂。',
	'delete-warning-toobig' => '這個頁面有一個十分大量的編輯歷史，超過$1次修訂。刪除它可能會擾亂{{SITENAME}}的資料庫操作；在繼續此動作前請小心。',
	'databasenotlocked' => '資料庫沒有鎖定。',
	'delete_and_move' => '刪除並移動',
	'delete_and_move_text' => '==需要刪除==

目標頁面"[[:$1]]"已經存在。{{GENDER:|你|妳|你}}確認需要刪除原頁面並以進行移動嗎？',
	'delete_and_move_confirm' => '是的，刪除此頁面',
	'delete_and_move_reason' => '刪除以便移動[[$1]]',
	'djvu_page_error' => 'DjVu頁面超出範圍',
	'djvu_no_xml' => '無法在DjVu檔案中擷取XML',
	'deletedrevision' => '已刪除舊版本$1',
	'days' => '$1天',
	'deletedwhileediting' => '警告: 此頁在您開始編輯之後已經被刪除﹗',
	'descending_abbrev' => '遞減',
	'duplicate-defaultsort' => '警告: 預設的排序鍵 "$2" 覆蓋先前的預設排序鍵 "$1"。',
	'dberr-header' => '這個 wiki 出現了問題',
	'dberr-problems' => '抱歉！
這個網站出現了一些技術上的問題。',
	'dberr-again' => '嘗試等候數分鐘後，然後再試。',
	'dberr-info' => '（無法連繫到資料庫伺服器: $1）',
	'dberr-usegoogle' => '在現階段您可以嘗試透過 Google 搜尋。',
	'dberr-outofdate' => '留意他們索引出來之內容可能不是最新的。',
	'dberr-cachederror' => '這個是所要求出來的快取複本，可能不是最新的。',
);

$messages['zh-hk'] = array(
	'december' => '十二月',
);

$messages['zh-min-nan'] = array(
	'december' => '十二月',
);

$messages['zh-mo'] = array(
	'december' => '十二月',
);

$messages['zh-my'] = array(
	'december' => '十二月',
);

$messages['zh-tw'] = array(
	'december' => '十二月',
	'december-gen' => '十二月',
	'dec' => '12月',
	'delete' => '刪除',
	'disclaimers' => '免責聲明',
	'defaultns' => '預設搜尋的名字空間',
	'disambiguations' => '消歧義',
	'disambiguations-text' => '以下的頁面都有到<b>消歧義頁</b>的鏈接,
但它們應該是連到適當的標題。<br />
個頁面會被視為消含糊頁如果它是連自[[MediaWiki:Disambiguationspage]]。',
	'deadendpagestext' => '以下頁面沒有連結到這個wiki中的其它頁面。',
	'deletedtext' => '「$1」已經被刪除。
最近刪除的紀錄請參見$2。',
	'dellogpagetext' => '以下是最近刪除的紀錄列表。
所有的時間都是使用伺服器時間。',
	'deletecomment' => '原因：',
	'discuss' => '討論',
);

$messages['zh-yue'] = array(
	'december' => '十二月',
	'december-gen' => '十二月',
	'dec' => '12月',
	'delete' => '刪除',
	'disclaimers' => '免責聲明',
	'defaultns' => '預設搜尋的名字空間',
	'disambiguations' => '消歧義',
	'disambiguations-text' => '以下的頁面都有到<b>消歧義頁</b>的鏈接,
但它們應該是連到適當的標題。<br />
個頁面會被視為消含糊頁如果它是連自[[MediaWiki:Disambiguationspage]]。',
	'deadendpagestext' => '以下頁面沒有連結到這個wiki中的其它頁面。',
	'deletedtext' => '「$1」已經被刪除。
最近刪除的紀錄請參見$2。',
	'dellogpagetext' => '以下是最近刪除的紀錄列表。
所有的時間都是使用伺服器時間。',
	'deletecomment' => '原因：',
	'discuss' => '討論',
);

$messages['zu'] = array(
	'december' => 'uDisemba',
	'december-gen' => 'uDisemba',
	'delete' => 'Sula',
	'deletethispage' => 'Sula lelikhasi',
	'databaseerror' => 'Idatabheyisi linecala',
	'deletepage' => 'Sula ikhasi',
	'databasenotlocked' => 'Idatabheyisi alikhiyiwi.',
	'delete_and_move' => 'Sula futhi sunduza',
	'delete_and_move_confirm' => 'Yebo, sula ikhasi',
);

