<?php
/**
 * Internationalisation file for extension GlobalBlocking.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Andrew Garrett
 */
$messages['en'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Allows]] IP addresses to be [[Special:GlobalBlockList|blocked across multiple wikis]]',
	'globalblocking-block' => 'Globally block an IP address',
	'globalblocking-expiry-options' => '-', # do not translate or duplicate this message to other languages
	'globalblocking-modify-intro' => 'You can use this form to change the settings of a global block.',
	'globalblocking-block-intro' => 'You can use this page to block an IP address on all wikis.',
	'globalblocking-block-reason' => 'Reason:',
	'globalblocking-block-otherreason' => 'Other/additional reason:',
	'globalblocking-block-reasonotherlist' => 'Other reason',
	'globalblocking-block-reason-dropdown' => '* Common block reasons
** Crosswiki spamming
** Crosswiki abuse
** Vandalism',
	'globalblocking-block-edit-dropdown' => 'Edit block reasons',
	'globalblocking-block-expiry' => 'Expiry:',
	'globalblocking-block-expiry-other' => 'Other expiry time',
	'globalblocking-block-expiry-otherfield' => 'Other time:',
	'globalblocking-block-legend' => 'Block an IP address globally',
	'globalblocking-block-options' => 'Options:',
	'globalblocking-ipaddress' => 'IP address:',
	'globalblocking-ipbanononly' => 'Block anonymous users only',
	'globalblocking-block-errors' => "Your block was unsuccessful, for the following {{PLURAL:$1|reason|reasons}}:",
	'globalblocking-block-ipinvalid' => 'The IP address ($1) you entered is invalid.
Please note that you cannot enter a user name!',
	'globalblocking-block-expiryinvalid' => 'The expiry you entered ($1) is invalid.',
	'globalblocking-block-submit' => 'Block this IP address globally',
	'globalblocking-modify-submit' => 'Modify this global block',
	'globalblocking-block-success' => 'The IP address $1 has been successfully blocked on all projects.',
	'globalblocking-modify-success' => 'The global block on $1 has been successfully modified',
	'globalblocking-block-successsub' => 'Global block successful',
	'globalblocking-modify-successsub' => 'Global block modified successfully',
	'globalblocking-block-alreadyblocked' => 'The IP address $1 is already blocked globally.
You can view the existing block on the [[Special:GlobalBlockList|list of global blocks]],
or modify the settings of the existing block by re-submitting this form.',
	'globalblocking-block-bigrange' => 'The range you specified ($1) is too big to block.
You may block, at most, 65,536 addresses (/16 ranges)',

	'globalblocking-list-intro' => 'This is a list of all global blocks which are currently in effect.
Some blocks are marked as locally disabled: this means that they apply on other sites, but a local administrator has decided to disable them on this wiki.',
	'globalblocking-list' => 'List of globally blocked IP addresses',
	'globalblocking-search-legend' => 'Search for a global block',
	'globalblocking-search-ip' => 'IP address:',
	'globalblocking-search-submit' => 'Search for blocks',
	'globalblocking-list-ipinvalid' => 'The IP address you searched for ($1) is invalid.
Please enter a valid IP address.',
	'globalblocking-search-errors' => "Your search was unsuccessful, for the following {{PLURAL:$1|reason|reasons}}:",
	'globalblocking-list-blockitem' => "$1: <span class=\"plainlinks\">'''$2'''</span> (''$3'') globally blocked [[Special:Contributions/$4|$4]] ''($5)''",
	'globalblocking-list-expiry' => 'expiry $1',
	'globalblocking-list-anononly' => 'anonymous only',
	'globalblocking-list-unblock' => 'remove',
	'globalblocking-list-whitelisted' => 'locally disabled by $1: $2',
	'globalblocking-list-whitelist' => 'local status',
	'globalblocking-list-modify' => 'modify',
	'globalblocking-list-noresults' => 'The requested IP address is not blocked.',
	'globalblocking-goto-block' => 'Globally block an IP address',
	'globalblocking-goto-unblock' => 'Remove a global block',
	'globalblocking-goto-status' => 'Change local status for a global block',

	'globalblocking-return' => 'Return to the list of global blocks',
	'globalblocking-notblocked' => 'The IP address ($1) you entered is not globally blocked.',

	'globalblocking-unblock' => 'Remove a global block',
	'globalblocking-unblock-ipinvalid' => 'The IP address ($1) you entered is invalid.
Please note that you cannot enter a user name!',
	'globalblocking-unblock-legend' => 'Remove a global block',
	'globalblocking-unblock-submit' => 'Remove global block',
	'globalblocking-unblock-reason' => 'Reason:',
	'globalblocking-unblock-unblocked' => "You have successfully removed the global block #$2 on the IP address '''$1'''",
	'globalblocking-unblock-errors' => "Your removal of the global block was unsuccessful, for the following {{PLURAL:$1|reason|reasons}}:",
	'globalblocking-unblock-successsub' => 'Global block successfully removed',
	'globalblocking-unblock-subtitle' => 'Removing global block',
	'globalblocking-unblock-intro' => 'You can use this form to remove a global block.',

	'globalblocking-whitelist' => 'Local status of global blocks',
	'globalblocking-whitelist-notapplied' => 'Global blocks are not applied at this wiki,
so the local status of global blocks cannot be modified.',
	'globalblocking-whitelist-legend' => 'Change local status',
	'globalblocking-whitelist-reason' => 'Reason:',
	'globalblocking-whitelist-status' => 'Local status:',
	'globalblocking-whitelist-statuslabel' => 'Disable this global block on {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Change local status',
	'globalblocking-whitelist-whitelisted' => "You have successfully disabled the global block #$2 on the IP address '''$1''' on {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "You have successfully re-enabled the global block #$2 on the IP address '''$1''' on {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Local status successfully changed',
	'globalblocking-whitelist-nochange' => 'You made no change to the local status of this block.
[[Special:GlobalBlockList|Return to the global block list]].',
	'globalblocking-whitelist-errors' => 'Your change to the local status of a global block was unsuccessful, for the following {{PLURAL:$1|reason|reasons}}:',
	'globalblocking-whitelist-intro' => "You can use this form to edit the local status of a global block.
If a global block is disabled on this wiki, users on the affected IP address will be able to edit normally.
[[Special:GlobalBlockList|Return to the global block list]].",

	'globalblocking-blocked' => "Your IP address $5 has been blocked on all wikis by '''$1''' (''$2'').
The reason given was ''\"$3\"''.
The block ''$4''.",
	'globalblocking-blocked-nopassreset' => "You cannot reset user's passwords because you are blocked globally.",

	'globalblocking-logpage' => 'Global block log',
	'globalblocking-logpagetext' => 'This is a log of global blocks which have been made and removed on this wiki.
It should be noted that global blocks can be made and removed on other wikis, and that these global blocks may affect this wiki.
To view all active global blocks, you may view the [[Special:GlobalBlockList|global block list]].',
	'globalblocking-block-logentry' => 'globally blocked [[$1]] with an expiry time of $2',
	'globalblocking-block2-logentry' => 'globally blocked [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'removed global block on [[$1]]',
	'globalblocking-whitelist-logentry' => 'disabled the global block on [[$1]] locally',
	'globalblocking-dewhitelist-logentry' => 're-enabled the global block on [[$1]] locally',
	'globalblocking-modify-logentry' => 'modified the global block on [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'expires $1',
	'globalblocking-logentry-noexpiry' => 'no expiry set',
	'globalblocking-loglink' => 'The IP address $1 is blocked globally ([[{{#Special:GlobalBlockList}}/$1|full details]]).',
	'globalblocking-showlog' => 'This IP address has been blocked previously.
The block log is provided below for reference:',
	'globalblocklist' => 'List of globally blocked IP addresses',
	'globalblock' => 'Globally block an IP address',
	'globalblockstatus' => 'Local status of global blocks',
	'removeglobalblock' => 'Remove a global block',

	// User rights
	'right-globalblock' => 'Make global blocks',
	'action-globalblock' => 'make global blocks',
	'right-globalunblock' => 'Remove global blocks',
	'action-globalunblock' => 'remove global blocks',
	'right-globalblock-whitelist' => 'Disable global blocks locally',
	'action-globalblock-whitelist' => 'disable global blocks locally',
	'right-globalblock-exempt' => 'Bypass global blocks',
	'action-globalblock-exempt' => 'bypass global blocks',
);

/** Message documentation (Message documentation)
 * @author Crt
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Ficell
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Lloffiwr
 * @author Meno25
 * @author Mormegil
 * @author Nike
 * @author Purodha
 * @author Raymond
 * @author SPQRobin
 * @author Siebrand
 * @author Tgr
 * @author The Evil IP address
 * @author Umherirrender
 * @author Urhixidur
 * @author Yekrats
 * @author Тест
 */
$messages['qqq'] = array(
	'globalblocking-desc' => '{{desc}}',
	'globalblocking-block' => 'Same special page with this page:

* [[MediaWiki:Globalblock/{{SUBPAGENAME}}]]',
	'globalblocking-block-reason' => '{{Identical|Reason}}',
	'globalblocking-block-otherreason' => '{{Identical/Other/additional reason}}',
	'globalblocking-block-reasonotherlist' => '{{Identical|Other reason}}',
	'globalblocking-block-reason-dropdown' => 'The choices that appear in the drop-down box, for the Global Blocking extension.
The top star is the unclicked list. The double-starred items are the reasons in the list.
For more information about Global Blocking, see http://www.mediawiki.org/wiki/Global_Blocking',
	'globalblocking-block-expiry' => 'After the colon, the user can enter a timestamp on which the block automatically ends or a time period like "1 hour", "2 days", "1 year" etc. But in English only because the time period is parsed by the underlying OS, not by MediaWiki.

{{Identical/Expiry}}',
	'globalblocking-block-expiry-otherfield' => '{{Identical|Other time}}',
	'globalblocking-block-options' => '{{Identical|Options}}',
	'globalblocking-ipaddress' => 'Form label for ip-address',
	'globalblocking-ipbanononly' => 'Label for checkbox to block anonymous users only.',
	'globalblocking-block-errors' => "The first line of the error message shown on [[Special:GlobalBlock]] (see [[mw:Extension:GlobalBlocking]]) if the block has been unsuccessful. After this message, a list of specific errors is shown (see [[Special:Prefixindex/MediaWiki:Globalblocking-block-bigrange|globalblocking-block-bigrange]], [[Special:Prefixindex/MediaWiki:Globalblocking-block-expiryinvalid|globalblocking-block-expiryinvalid]] etc.).

* $1 – the ''number'' of errors (not the errors themselves)",
	'globalblocking-block-ipinvalid' => '{{Identical|The IP address ($1) ...}}',
	'globalblocking-block-bigrange' => 'Not clear at all what the English message means about ranges. Unfortunately, http://www.mediawiki.org/wiki/Extension:GlobalBlocking supplies no explanation whatsoever.',
	'globalblocking-list-intro' => 'Appears on top of [[Special:Globalblocklist]] (part of [[mw:Extension:GlobalBlocking|Extension:GlobalBlocking]], which is not installed on translatewiki.net; example: [[wikipedia:Special:Globalblocklist]]).',
	'globalblocking-search-ip' => '{{Identical|IP Address}}',
	'globalblocking-list-blockitem' => '* $1 is a time stamp
* $2 is the blocking user
* $3 is the source wiki for the blocking user
* $4 is the blocked user
* $5 are the block options',
	'globalblocking-list-anononly' => '{{Identical|Anon only}}',
	'globalblocking-list-unblock' => '{{Identical|Remove}}',
	'globalblocking-list-whitelist' => '{{Identical|Local status}}',
	'globalblocking-list-modify' => '{{Identical|Modify}}',
	'globalblocking-unblock-ipinvalid' => '{{Identical|The IP address ($1) ...}}',
	'globalblocking-unblock-reason' => '{{Identical|Reason}}',
	'globalblocking-whitelist-legend' => '{{Identical|Change local status}}',
	'globalblocking-whitelist-reason' => '{{Identical|Reason}}',
	'globalblocking-whitelist-status' => '{{Identical|Local status}}',
	'globalblocking-whitelist-submit' => '{{Identical|Change local status}}',
	'globalblocking-blocked' => "A message shown to a [[mw:Extension:GlobalBlocking|globally blocked]] user trying to edit.

* <code>$1</code> is the username of the blocking user (steward), with link
* <code>$2</code> is the project name where the user is registered (usually “meta.wikimedia.org” on Wikimedia servers)
* <code>$3</code> is the reason specified by the blocking user
* <code>$4</code> is either the contents of {{msg-mw|Infiniteblock}} (''{{int:Infiniteblock}}''), or {{msg-mw|Expiringblock}} (''{{int:Expiringblock}}'') with the expiry time
* <code>$5</code> is the user's IP address",
	'globalblocking-logpagetext' => 'Shown as header of [[Special:Log/gblblock]] (part of [[mw:Extension:GlobalBlocking|Extension:GlobalBlocking]], which is not installed on translatewiki.net; example: [[wikipedia:Special:Log/gblblock]])',
	'globalblocking-block2-logentry' => '* $1 is a link to a user page of the form User:Name
* $2 is a reason for the action.',
	'globalblocking-unblock-logentry' => "This message is a log entry. '''$1''' are contributions of an IP. For an example see http://meta.wikimedia.org/wiki/Special:Log/gblblock?uselang=en",
	'globalblocking-modify-logentry' => '$1 is a link to a user page of the form User:Name, $2 is a reason for the action.',
	'globalblocking-loglink' => 'Shown at Special:IPBlocklist when the GlobalBlocking extension is enabled (not on translatewiki).
* $1 is the requested IP address',
	'globalblock' => 'Same special page with this page:

* [[MediaWiki:Globalblocking-block/{{SUBPAGENAME}}]]',
	'right-globalblock' => '{{doc-right|globalblock}}',
	'action-globalblock' => '{{doc-action|globalblock}}',
	'right-globalunblock' => '{{doc-right|globalunblock}}',
	'action-globalunblock' => '{{doc-action|globalunblock}}',
	'right-globalblock-whitelist' => '{{doc-right|globalblock-whitelist}}',
	'action-globalblock-whitelist' => '{{doc-action|globalblock-whitelist}}',
	'right-globalblock-exempt' => '{{doc-right|globalblock-exempt}}',
	'action-globalblock-exempt' => '{{doc-action|globalblock-exempt}}',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'globalblocking-desc' => "[[Special:GlobalBlock|Maak dit moontlik]] om IP-adresse [[Special:GlobalBlockList|oor veelvoudige wiki's]] te versper",
	'globalblocking-block' => "Versper 'n IP adres globaal",
	'globalblocking-modify-intro' => "U kan hierdie vorm gebruik om die instellings van 'n globale blokkade te verander.",
	'globalblocking-block-intro' => "U kan hierdie bladsy gebruik om 'n IP adres op alle wikis te versper.",
	'globalblocking-block-reason' => 'Rede:',
	'globalblocking-block-otherreason' => 'Ander/ekstra rede:',
	'globalblocking-block-reasonotherlist' => 'Ander rede',
	'globalblocking-block-reason-dropdown' => "* Algemene redes vir blokkades
** Spam oor veelvuldige wiki's
** Misbruik oor veelvuldige wiki's
** Vandalisme",
	'globalblocking-block-edit-dropdown' => 'Werk die lys van redes by',
	'globalblocking-block-expiry' => 'Verval:',
	'globalblocking-block-expiry-other' => 'Ander verstryktyd',
	'globalblocking-block-expiry-otherfield' => 'Ander tyd:',
	'globalblocking-block-legend' => "Versper 'n IP-adres globaal",
	'globalblocking-block-options' => 'Opsies:',
	'globalblocking-ipaddress' => 'IP-adres:',
	'globalblocking-ipbanononly' => 'Blok anonieme gebruikers slegs',
	'globalblocking-block-errors' => 'Die versperring was nie suksesvol nie, as gevolg van die volgende {{PLURAL:$1|rede|redes}}:',
	'globalblocking-block-ipinvalid' => "Die IP adres ($1) wat U ingevoer het is ongeldig.
Let asseblief dat U nie 'n gebruikersnaam kan invoer nie!",
	'globalblocking-block-expiryinvalid' => 'Die verstryking ($1) wat U ingevoer het is ongeldig.',
	'globalblocking-block-submit' => 'Versper hierdie IP adres globaal',
	'globalblocking-modify-submit' => 'Wysig hierdie globale blokkade',
	'globalblocking-block-success' => 'Die IP adres $1 is op alle Wikimedia projekte geblokkeer.',
	'globalblocking-modify-success' => 'Die globale blokkade vir $1 is suksesvol verander',
	'globalblocking-block-successsub' => 'Globale versperring suksesvol',
	'globalblocking-modify-successsub' => 'Die globale blokkade is suksesvol verander',
	'globalblocking-block-alreadyblocked' => 'Die IP-adres $1 is reeds globaal geblokkeer.
U kan die bestaande blokkade op die [[Special:GlobalBlockList|lys van globale blokkades]] sien of die instellings van die bestaande blokkade aanpas deur die inligting op die vorm aan te pas en in te stuur.',
	'globalblocking-block-bigrange' => 'Die reeks wat u verskaf het ($1) is te groot om te versper. U mag op die meeste 65.536 adresse versper (/16-reekse)',
	'globalblocking-list-intro' => "Hierdie is 'n lys van al die globale blokkades wat tans aktief is.
Sommige blokkades is as lokaal gemerk.
Dit beteken dat hulle van toepassing is op ander werwe, maar 'n plaaslike administrateur het besluit dat hulle nie op hierdie wiki van toepassing is nie.",
	'globalblocking-list' => 'Lys van globale versperde IP adresse',
	'globalblocking-search-legend' => "Soek vir 'n globale versperring",
	'globalblocking-search-ip' => 'IP-adres:',
	'globalblocking-search-submit' => 'Soek vir versperrings',
	'globalblocking-list-ipinvalid' => "Die IP adres wat U na gesoek het ($1) is ongeldig.
Voer asseblief 'n geldige IP adres in.",
	'globalblocking-search-errors' => 'U soektog was nie suksesvol nie, as gevolg van die volgende {{PLURAL:$1|rede|redes}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') het [[Special:Contributions/\$4|\$4]] globaal versper, met ''(\$5)''",
	'globalblocking-list-expiry' => 'verstryking $1',
	'globalblocking-list-anononly' => 'anoniem-alleen',
	'globalblocking-list-unblock' => 'deurlaat',
	'globalblocking-list-whitelisted' => 'lokaal afgeskakel deur $1: $2',
	'globalblocking-list-whitelist' => 'lokale status',
	'globalblocking-list-modify' => 'wysig',
	'globalblocking-list-noresults' => 'Die opgegewe IP-adres is nie geblokkeer nie.',
	'globalblocking-goto-block' => "Blokkeer 'n IP-adres globaal",
	'globalblocking-goto-unblock' => "Skrap 'n globale blokkade",
	'globalblocking-goto-status' => "Verander lokale status van 'n globale blokkade",
	'globalblocking-return' => 'Terug na die lys met globale blokkades',
	'globalblocking-notblocked' => 'Die IP-adres ($1) wat u verskaf het is nie globaal geblokkeer nie.',
	'globalblocking-unblock' => "Skrap 'n globale blokkade",
	'globalblocking-unblock-ipinvalid' => "Die IP adres ($1) wat U ingevoer het is ongeldig.
Let asseblief dat U nie 'n gebruikersnaam kan invoer nie!",
	'globalblocking-unblock-legend' => "Verwyder 'n globale versperring",
	'globalblocking-unblock-submit' => 'Verwyder globale versperring',
	'globalblocking-unblock-reason' => 'Rede:',
	'globalblocking-unblock-unblocked' => "U het suksesvol die globale versperring #$2 op die IP adres '''$1''' verwyder",
	'globalblocking-unblock-errors' => 'Die globale versperring is nie verwyder as gevolg van die volgende {{PLURAL:$1|rede|redes}}:',
	'globalblocking-unblock-successsub' => 'Globale versperring suksesvol verwyder',
	'globalblocking-unblock-subtitle' => 'Verwyder globale versperring',
	'globalblocking-unblock-intro' => "U kan hierdie vorm gebruik om 'n globale blokkade te verwyder.",
	'globalblocking-whitelist' => 'Lokale status van globale blokkades',
	'globalblocking-whitelist-notapplied' => 'Globale blokkades word nie op hierdie wiki toegepas nie,
dus kan die lokale status van globale blokkades nie gewysig word nie.',
	'globalblocking-whitelist-legend' => 'Wysig lokale status',
	'globalblocking-whitelist-reason' => 'Rede:',
	'globalblocking-whitelist-status' => 'Lokale status:',
	'globalblocking-whitelist-statuslabel' => 'Skakel hierdie globale versperring op {{SITENAME}} af',
	'globalblocking-whitelist-submit' => 'Wysig lokale status',
	'globalblocking-whitelist-whitelisted' => "U het suksesvol die globale versperring #$2 op die IP adres '''$1''' op {{SITENAME}} afgeskakel.",
	'globalblocking-whitelist-dewhitelisted' => "U het suksesvol die globale versperring #$2 op die IP adres '''$1''' op {{SITENAME}} heraangeskakel.",
	'globalblocking-whitelist-successsub' => 'Lokale status suksesvol gewysig',
	'globalblocking-whitelist-nochange' => 'U het nie die lokale status van hierdie blokkade gewysig nie.
[[Special:GlobalBlockList|Keer terug na die lys van globale blokkades]].',
	'globalblocking-whitelist-errors' => 'U kon nie die lokale status van die globale blokkade wysig nie om die volgende {{PLURAL:$1|rede|redes}}:',
	'globalblocking-whitelist-intro' => "U kan die vorm gebruik om die lokale status van 'n globale blokkade te wysig.
As 'n globale blokkade op hierdie wiki opgehef is, kan gebruikers vanaf die IP-adres gewone wysigings deurvoer.
[[Special:GlobalBlockList|Keer terug na die lys van globale blokkades]].",
	'globalblocking-blocked' => "U IP-adres \$5 is deur '''\$1''' (''\$2'') op alle wiki's geblokkeer.
Die rede hiervoor is ''\"\$3\"''.
Die blokkade is ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'U kan nie wagwoorde van gebruikers herstel nie omdat u globaal geblokkeer word.',
	'globalblocking-logpage' => 'Globale versperring boekstaaf',
	'globalblocking-logpagetext' => "Die logboek bevat blokkades wat op hierdie wiki geskep of verwyder is.
Globale blokkades kan ook op ander wiki's geskep of verwyder word, en invloed hê op hierdie wiki.
Alle globale blokkades is opgeteken in die [[Special:GlobalBlockList|lys van globale blokkades]].",
	'globalblocking-block-logentry' => "[[$1]] is globaal versper met 'n verstryktyd van $2",
	'globalblocking-block2-logentry' => 'het [[$1]] globaal geblokkeer ($2)',
	'globalblocking-unblock-logentry' => 'verwyder globale versperring op [[$1]]',
	'globalblocking-whitelist-logentry' => 'die globale versperring op [[$1]] is lokaal afgeskakel',
	'globalblocking-dewhitelist-logentry' => 'die globale versperring op [[$1]] is heraangeskakel',
	'globalblocking-modify-logentry' => 'het die globale blokkade vir [[$1]] aangepas ($2)',
	'globalblocking-logentry-expiry' => 'verval op $1',
	'globalblocking-logentry-noexpiry' => 'geen vervaldatum ingestel',
	'globalblocking-loglink' => 'Die IP-adres is globaal geblokkeer ([[{{#Special:GlobalBlockList}}/$1|volledige details]]).',
	'globalblocking-showlog' => 'Die IP-adres was vantevore geblokkeer gewees.
Die blokkeerlogboek word hieronder weergegee:',
	'globalblocklist' => 'Lys van globaal versperde IP adresse',
	'globalblock' => "Versper 'n IP adres globaal",
	'globalblockstatus' => 'Lokale status van globale blokkades',
	'removeglobalblock' => "Verwyder 'n globale blokkade",
	'right-globalblock' => 'Rig globale versperrings op',
	'right-globalunblock' => 'Verwyder globale versperrings',
	'right-globalblock-whitelist' => 'Skakel globale versperrings lokaal af',
	'right-globalblock-exempt' => 'Omseil globale blokkades',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Lejon]] IP adresat që do të [[Special:GlobalBlockList|bllokuar të gjithë të shumta wikis]]',
	'globalblocking-block' => 'Globalisht bllokojnë një adresë IP',
	'globalblocking-modify-intro' => 'Ju mund të përdorni këtë formular për të ndryshuar parametrat e një bllok globale.',
	'globalblocking-block-intro' => 'Ju mund të përdorni këtë faqe për të bllokuar një adresë IP në të gjitha wikis.',
	'globalblocking-block-reason' => 'Arsyeja:',
	'globalblocking-block-otherreason' => 'Të tjera / arsye shtesë:',
	'globalblocking-block-reasonotherlist' => 'arsye të tjera',
	'globalblocking-block-reason-dropdown' => '* Bllok arsye të përbashkëta spamming Crosswiki ** ** ** Crosswiki abuzimit vandalizëm',
	'globalblocking-block-edit-dropdown' => 'bllok arsye Edit',
	'globalblocking-block-expiry' => 'Skadimi:',
	'globalblocking-block-expiry-other' => 'kohë të tjera të kalimit',
	'globalblocking-block-expiry-otherfield' => 'kohë të tjera:',
	'globalblocking-block-legend' => 'Blloku një adresë IP globalisht',
	'globalblocking-block-options' => 'Mundësitë e zgjedhjes:',
	'globalblocking-block-errors' => 'blloku juaj ka qenë i pasuksesshëm, për këto {{PLURAL:$1|arsye|arsye}}:',
	'globalblocking-block-ipinvalid' => 'Adresa IP ($1) keni hyrë është i pavlefshëm. Ju lutem vini re se ju nuk mund të hyjë në një emër përdoruesi!',
	'globalblocking-block-expiryinvalid' => 'Skadimit të hyrë ($1) është e pavlefshme.',
	'globalblocking-block-submit' => 'Blloko këtë adresë IP globalisht',
	'globalblocking-modify-submit' => 'Modifiko këtë bllok globale',
	'globalblocking-block-success' => 'IP adresa $1 u bllokua me sukses në të gjitha projektet.',
	'globalblocking-modify-success' => 'Blloku globale për $1 u ndryshua me sukses',
	'globalblocking-block-successsub' => 'Global bllok i suksesshëm',
	'globalblocking-modify-successsub' => 'Global bllok modifikuar me sukses',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'globalblocking-block-expiry-otherfield' => 'ሌላ ጊዜ፦',
	'globalblocking-block-options' => 'ምርጫዎች:',
	'globalblocking-unblock-reason' => 'ምክንያት:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permite]] bloqueyar adrezas IP [[Special:GlobalBlockList|de vez en quantos wikis]]',
	'globalblocking-block' => 'Bloqueyar globalment una adreza IP',
	'globalblocking-modify-intro' => "Puetz usar iste formulario ta cambiar as configuracions d'un bloqueo global.",
	'globalblocking-block-intro' => 'Puede usar ista pachina ta bloqueyar una adreza IP en totz os wikis.',
	'globalblocking-block-reason' => 'Razón:',
	'globalblocking-block-otherreason' => 'Atra/mas razons:',
	'globalblocking-block-reasonotherlist' => 'Atra razón',
	'globalblocking-block-reason-dropdown' => '* Razons comuns de bloqueyo
** Spam sobre quantos wikis
** Abusos en quantos wikis
** Vandalismo',
	'globalblocking-block-edit-dropdown' => "Editar as razons d'o bloqueyo",
	'globalblocking-block-expiry' => 'Circumducción:',
	'globalblocking-block-expiry-other' => 'Atro tiempo de caducidat',
	'globalblocking-block-expiry-otherfield' => 'Atro tiempo:',
	'globalblocking-block-legend' => 'Bloqueyar una adreza IP globalment',
	'globalblocking-block-options' => 'Opcions:',
	'globalblocking-ipaddress' => 'Adreza IP:',
	'globalblocking-ipbanononly' => 'Bloqueyar solament os usuarios anonimos',
	'globalblocking-block-errors' => 'O suyo bloqueyo falló por {{PLURAL:$1|a siguient razón|as siguients razons}}:',
	'globalblocking-block-ipinvalid' => "L'adreza IP ($1) que introdució no ye valida. Por favor, pare en cuenta cuenta que no puetzintroducir un nombre d'usuario.",
	'globalblocking-block-expiryinvalid' => 'A circumducción que introdució ($1) ye invalida.',
	'globalblocking-block-submit' => 'Bloqueyar ista adreza IP globalment',
	'globalblocking-modify-submit' => 'Modificar este bloqueyo global',
	'globalblocking-block-success' => "l'adreza IP $1 ha estau bloqueyada con exito en totz os prochectos.",
	'globalblocking-modify-success' => 'O bloqueyo global en $1 ha estau modificau correctament',
	'globalblocking-block-successsub' => "O bloqueo global s'ha feito correctament",
	'globalblocking-modify-successsub' => "Bloqueo global s'ha modificau correctament",
	'globalblocking-block-alreadyblocked' => "L'adreza IP $1 ya ye bloqueyada globalment.
Puede veyer o bloqueyo existent en a [[Special:GlobalBlockList|lista de bloqueyos globals]],
u modificar as configuracions d'o bloqueyo existent reninviando iste formulario.",
	'globalblocking-block-bigrange' => 'O rango que especificó ($1) ye masiau gran ta estar bloqueyau.
Puet bloqueyar, como muito, 65.536 adrezas (un rango de /16)',
	'globalblocking-list-intro' => "Ista ye una lista de totz os bloqueyos globals que actualment son vichents.
Qualques bloqueyos son marcaus como desactivaus localment: isto significa que s'aplican en atros puestos, y que un administrador local ha decidiu desactivar-los en ista wiki.",
	'globalblocking-list' => "Lista d'adrezas IP bloqueyadas globalment",
	'globalblocking-search-legend' => 'Buscar un bloqueyo global',
	'globalblocking-search-ip' => 'Adreza IP:',
	'globalblocking-search-submit' => 'Mirar bloqueyos',
	'globalblocking-list-ipinvalid' => "L'adreza IP que buscó ($1) no ye valida.
Por favor, introduzca una adreza IP valida.",
	'globalblocking-search-errors' => 'A suya busca no tenió exito por {{PLURAL:$1|a siguient razón|as siguients razons}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bloqueyó globalment a [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'circumduce o $1',
	'globalblocking-list-anononly' => 'nomás anonimos',
	'globalblocking-list-unblock' => 'eliminar',
	'globalblocking-list-whitelisted' => 'desactivau localment por $1: $2',
	'globalblocking-list-whitelist' => 'estau local',
	'globalblocking-list-modify' => 'modificar',
	'globalblocking-list-noresults' => "l'adreza IP solicitada no ye bloqueyada.",
	'globalblocking-goto-block' => 'Bloqueyar globalment una adreza IP',
	'globalblocking-goto-unblock' => 'Sacar un bloqueyo global',
	'globalblocking-goto-status' => "Cambiar estau local d'un bloqueyo global",
	'globalblocking-return' => 'Tornar ta la lista de bloqueyos globals',
	'globalblocking-notblocked' => "l'adreza IP ($1) que escribió no ye bloqueyada globalment.",
	'globalblocking-unblock' => 'Sacar un bloqueyo global',
	'globalblocking-unblock-ipinvalid' => "L'adreza IP ($1) que introdució ye invalida.
Por favor pare cuenta que no puede introducir un nombre d'usuario!",
	'globalblocking-unblock-legend' => 'Sacar un bloqueyo global',
	'globalblocking-unblock-submit' => 'Sacar o bloqueyo global',
	'globalblocking-unblock-reason' => 'Razón:',
	'globalblocking-unblock-unblocked' => "Ha sacau con exito o bloqueyo global #$2 en l'adreza IP '''$1'''",
	'globalblocking-unblock-errors' => "A eliminación d'o bloqueyo global no s'ha puesto fer, por as siguients {{PLURAL:$1|razón|razones}}:",
	'globalblocking-unblock-successsub' => 'Se sacó o bloqueyo global correctament',
	'globalblocking-unblock-subtitle' => 'Sacando bloqueyo global',
	'globalblocking-unblock-intro' => 'Puet usar iste formulario ta sacar un bloqueyo global.',
	'globalblocking-whitelist' => 'Estau local de bloqueyos globals',
	'globalblocking-whitelist-notapplied' => 'Os bloqueos globals no son aplicaus en iste wiki,
alavez o status de bloqueos globals no pueden estar modificaus.',
	'globalblocking-whitelist-legend' => 'Cambiar estau local',
	'globalblocking-whitelist-reason' => 'Razón:',
	'globalblocking-whitelist-status' => 'Estau local:',
	'globalblocking-whitelist-statuslabel' => 'Desactivar iste bloqueyo global en {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Cambiar estaus local',
	'globalblocking-whitelist-whitelisted' => "Has desactivau correctament o bloqueyo global #$2 de l'adreza IP '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Has reactivau correctament o bloqueyo global #$2 de l'adreza IP '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Se cambió o status local con exito',
	'globalblocking-whitelist-nochange' => "No ha feito garra cambeo a o estau local d'este bloqueyo.
[[Special:GlobalBlockList|Tornar a la lista de bloqueyos globals]].",
	'globalblocking-whitelist-errors' => "A modificación d'o bloqueyo global no s'ha puesto fer, por as siguients {{PLURAL:$1|razón|razones}}:",
	'globalblocking-whitelist-intro' => "Puet usar iste formulario ta editar o estau local d'un bloqueyo global.
Si un bloqueyo global ye desactivau en ista wiki, os usuarios de l'adreza IP afectada podrán editar normalment.
[[Special:GlobalBlockList|Tornar a la lista de bloqueyos globals]].",
	'globalblocking-blocked' => "'''$1''' (''$2'') bloqueyó a suya adreza IP $5 en totz os wikis.
O motivo dau estió ''«$3»''.
O bloqueyo ''$4''.",
	'globalblocking-blocked-nopassreset' => "No puede demandar recordatorios de claves d'usuario porque vusté ye bloqueyau globalment.",
	'globalblocking-logpage' => 'Rechistro de bloqueyos globals',
	'globalblocking-logpagetext' => "Ista ye una lista de bloqueyos globals que s'han feito y retirau en iste wiki.
Cal sinyalar que os bloqueyos globals se pueden fer y sacar en atros wikis, y que istos bloqueyos globals pueden afectar a iste wiki.
Ta veyer totz os bloqueyos globals activos, puede veyer [[Special:GlobalBlockList|lista de bloqueyos globals]].",
	'globalblocking-block-logentry' => 'bloquió globalment a [[$1]] con un tiempo de circumducción de $2',
	'globalblocking-block2-logentry' => 'bloqueyó globalment a [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'ha desactivau o bloqueyo global en [[$1]]',
	'globalblocking-whitelist-logentry' => 'ha desactivau o bloqueyo global en [[$1]] localment',
	'globalblocking-dewhitelist-logentry' => 'ha reactivau localment o bloqueyo global en [[$1]]',
	'globalblocking-modify-logentry' => 'ha modificau o bloqueyo global en [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'circumduce o $1',
	'globalblocking-logentry-noexpiry' => 'sin calendata de circumducción',
	'globalblocking-loglink' => "L'adreza IP $1 ye bloqueyada globalment ([[{{#Special:GlobalBlockList}}/$1|detalles]]).",
	'globalblocking-showlog' => 'Ista adreza IP ha estau bloquiada previament.
O rechistro de bloqueyos se proporciona contino como referencia:',
	'globalblocklist' => "Lista d'adrezas IP bloqueyadas globalment",
	'globalblock' => 'Bloqueyar una adreza IP globalment',
	'globalblockstatus' => 'Estau local de bloqueyos globals',
	'removeglobalblock' => 'Sacar un bloqueyo global',
	'right-globalblock' => 'Fer bloqueyos globals',
	'right-globalunblock' => 'Sacar bloqueyos globals',
	'right-globalblock-whitelist' => 'Desactivar localment os bloqueyos globals',
	'right-globalblock-exempt' => 'Eludir bloqueyos globals',
);

/** Arabic (العربية)
 * @author Aiman titi
 * @author Alnokta
 * @author AwamerT
 * @author Loya
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|يسمح]] بمنع عناوين الأيبي [[Special:GlobalBlockList|عبر ويكيات متعددة]]',
	'globalblocking-block' => 'منع عام لعنوان أيبي',
	'globalblocking-modify-intro' => 'يمكنك استخدام هذه الاستمارة لتغيير إعدادات المنع العام.',
	'globalblocking-block-intro' => 'أنت يمكنك استخدام هذه الصفحة لمنع عنوان أيبي في كل الويكيات.',
	'globalblocking-block-reason' => 'السبب:',
	'globalblocking-block-otherreason' => 'سبب آخر/إضافي:',
	'globalblocking-block-reasonotherlist' => 'سبب آخر',
	'globalblocking-block-reason-dropdown' => '* الأسباب العامة للمنع
 **تعارضات الويكي غير المرغوب فيه
 ** وجود التعارضات
 ** التخريب',
	'globalblocking-block-edit-dropdown' => 'عدل أسباب المنع',
	'globalblocking-block-expiry' => 'الانتهاء:',
	'globalblocking-block-expiry-other' => 'وقت انتهاء آخر',
	'globalblocking-block-expiry-otherfield' => 'وقت آخر:',
	'globalblocking-block-legend' => 'منع عنوان أيبي منعا عاما',
	'globalblocking-block-options' => 'خيارات:',
	'globalblocking-ipaddress' => 'عنوان الأيبي:',
	'globalblocking-ipbanononly' => 'امنع المستخدمين المجهولين فقط',
	'globalblocking-block-errors' => 'منعك كان غير ناجح، {{PLURAL:$1|للسبب التالي|للأسباب التالية}}:',
	'globalblocking-block-ipinvalid' => 'عنوان الأيبي ($1) الذي أدخلته غير صحيح.
من فضلك لاحظ أنه لا يمكنك إدخال اسم مستخدم!',
	'globalblocking-block-expiryinvalid' => 'تاريخ الانتهاء الذي أدخلته ($1) غير صحيح.',
	'globalblocking-block-submit' => 'منع عنوان الأيبي هذا منعا عاما',
	'globalblocking-modify-submit' => 'تعديل هذا المنع العام',
	'globalblocking-block-success' => 'عنوان الأيبي $1 تم منعه بنجاح في كل المشاريع.',
	'globalblocking-modify-success' => 'المنع العام على $1 تم تعديله بنجاح',
	'globalblocking-block-successsub' => 'نجح المنع العام',
	'globalblocking-modify-successsub' => 'المنع العام تم تعديله بنجاح',
	'globalblocking-block-alreadyblocked' => 'عنوان الأيبي $1 ممنوع منعا عاما بالفعل.
يمكنك رؤية المنع الموجود في [[Special:GlobalBlockList|قائمة عمليات المنع العامة]]،
أو تعديل إعدادات المنع الموجود عن طريق إعادة تنفيذ هذه الاستمارة.',
	'globalblocking-block-bigrange' => 'النطاق الذي حددته ($1) كبير جدا للمنع. يمكنك منع، كحد أقصى، 65,536 عنوان (نطاقات /16)',
	'globalblocking-list-intro' => 'هذه قائمة بكل عمليات المنع العامة الحالية. بعض عمليات المنع معلمة كمعطلة محليا: هذا يعني أنها تنطبق على المواقع الأخرى، لكن إداريا محليا قرر تعطيلها في هذا الويكي.',
	'globalblocking-list' => 'قائمة عناوين الأيبي الممنوعة منعا عاما',
	'globalblocking-search-legend' => 'بحث عن منع عام',
	'globalblocking-search-ip' => 'عنوان الأيبي:',
	'globalblocking-search-submit' => 'بحث عن عمليات المنع',
	'globalblocking-list-ipinvalid' => 'عنوان الأيبي الذي بحثت عنه ($1) غير صحيح.
من فضلك أدخل عنوان أيبي صحيح.',
	'globalblocking-search-errors' => 'بحثك لم يكن ناجحا، {{PLURAL:$1|للسبب التالي|للأسباب التالية}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') منع بشكل عام [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'الانتهاء $1',
	'globalblocking-list-anononly' => 'المجهولون فقط',
	'globalblocking-list-unblock' => 'إزالة',
	'globalblocking-list-whitelisted' => 'تم تعطيله محليا بواسطة $1: $2',
	'globalblocking-list-whitelist' => 'الحالة المحلية',
	'globalblocking-list-modify' => 'تعديل',
	'globalblocking-list-noresults' => 'عنوان الأيبي المطلوب ليس ممنوعا.',
	'globalblocking-goto-block' => 'منع عام لعنوان أيبي',
	'globalblocking-goto-unblock' => 'إزالة منع عام',
	'globalblocking-goto-status' => 'تغيير الحالة المحلية لمنع عام',
	'globalblocking-return' => 'رجوع إلى قائمة عمليات المنع العامة',
	'globalblocking-notblocked' => 'عنوان الأيبي ($1) الذي أدخلته ليس ممنوعا منعا عاما.',
	'globalblocking-unblock' => 'إزالة منع عام',
	'globalblocking-unblock-ipinvalid' => 'عنوان الأيبي ($1) الذي أدخلته غير صحيح.
من فضلك لاحظ أنه لا يمكنك إدخال اسم مستخدم!',
	'globalblocking-unblock-legend' => 'إزالة منع عام',
	'globalblocking-unblock-submit' => 'إزالة المنع العام',
	'globalblocking-unblock-reason' => 'السبب:',
	'globalblocking-unblock-unblocked' => "أنت أزلت بنجاح المنع العام #$2 على عنوان الأيبي '''$1'''",
	'globalblocking-unblock-errors' => 'إزالتك للمنع العام لم تكن ناجحة، {{PLURAL:$1|للسبب التالي|لأسباب التالية}}:',
	'globalblocking-unblock-successsub' => 'المنع العام تمت إزالته بنجاح',
	'globalblocking-unblock-subtitle' => 'إزالة المنع العام',
	'globalblocking-unblock-intro' => 'يمكنك استخدام هذه الاستمارة لإزالة منع عام.',
	'globalblocking-whitelist' => 'الحالة المحلية لعمليات المنع العامة',
	'globalblocking-whitelist-notapplied' => 'عمليات المنع العامة لا يتم تطبيقها في هذه الويكي،
لذا فالحالة المحلية لعمليات المنع العامة لا يمكن تعديلها.',
	'globalblocking-whitelist-legend' => 'تغيير الحالة المحلية',
	'globalblocking-whitelist-reason' => 'السبب:',
	'globalblocking-whitelist-status' => 'الحالة المحلية:',
	'globalblocking-whitelist-statuslabel' => 'تعطيل هذا المنع العام في {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'تغيير الحالة المحلية',
	'globalblocking-whitelist-whitelisted' => "لقد عطلت بنجاح المنع العام #$2 على عنوان الأيبي '''$1''' في {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "أنت أعدت تفعيل بنجاح المنع العام #$2 على عنوان الأيبي '''$1''' في {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'الحالة المحلية تم تغييرها بنجاح',
	'globalblocking-whitelist-nochange' => 'أنت لم تقم بأي تغيير للحالة المحلية لهذا المنع.
[[Special:GlobalBlockList|رجوع إلى قائمة المنع العامة]].',
	'globalblocking-whitelist-errors' => 'تغييرك للحالة المحلية للمنع العام لم يكن ناجحا، {{PLURAL:$1|للسبب التالي|للأسباب التالية}}:',
	'globalblocking-whitelist-intro' => 'يمكنك استخدام هذه الاستمارة لتعديل الحالة المحلية لمنع عام. لو أن منعا عاما تم تعطيله في هذا الويكي، المستخدمون على عنوان الأيبي المتأثر سيمكنهم التعديل بشكل طبيعي.
[[Special:GlobalBlockList|رجوع إلى قائمة المنع العامة]].',
	'globalblocking-blocked' => "عنوان الأيبي الخاص بك \$5 تم منعه على كل الويكيات بواسطة '''\$1''' (''\$2'').
السبب المعطى كان ''\"\$3\"''. المنع ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'لا يمكنك إعادة ضبط كلمات سر المستخدم لأنك ممنوع منعا عاما.',
	'globalblocking-logpage' => 'سجل المنع العام',
	'globalblocking-logpagetext' => 'هذا سجل بعمليات المنع العامة التي تم عملها وإزالتها على هذا الويكي.
ينبغي ملاحظة أن عمليات المنع العامة يمكن عملها وإزالتها على الويكيات الأخرى، وأن عمليات المنع العامة هذه ربما تؤثر على هذا الويكي.
لرؤية كل عمليات المنع العامة النشطة، يمكنك رؤية [[Special:GlobalBlockList|قائمة المنع العامة]].',
	'globalblocking-block-logentry' => 'منع بشكل عام [[$1]] لمدة $2',
	'globalblocking-block2-logentry' => 'ممنوع منعا عاما [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'أزال المنع العام على [[$1]]',
	'globalblocking-whitelist-logentry' => 'عطل المنع العام على [[$1]] محليا',
	'globalblocking-dewhitelist-logentry' => 'أعاد تفعيل المنع العام على [[$1]] محليا',
	'globalblocking-modify-logentry' => 'عدل المنع العام في [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'ينتهي في $1',
	'globalblocking-logentry-noexpiry' => 'لا انتهاء مضبوط',
	'globalblocking-loglink' => 'عنوان الأيبي $1 ممنوع منعا عاما ([[{{#Special:GlobalBlockList}}/$1|تفاصيل كاملة]]).',
	'globalblocking-showlog' => 'عنوان الأيبي هذا تم منعه مسبقا.
سجل المنع معروض بالأسفل كمرجع:',
	'globalblocklist' => 'قائمة عناوين الأيبي الممنوعة منعا عاما',
	'globalblock' => 'منع عام لعنوان أيبي',
	'globalblockstatus' => 'الحالة المحلية للمنع العام',
	'removeglobalblock' => 'إزالة منع عام',
	'right-globalblock' => 'عمل عمليات منع عامة',
	'right-globalunblock' => 'إزالة عمليات المنع العامة',
	'right-globalblock-whitelist' => 'تعطيل عمليات المنع العامة محليا',
	'right-globalblock-exempt' => 'تجاوز عمليات المنع العامة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'globalblocking-block-reason' => 'ܥܠܬܐ:',
	'globalblocking-block-otherreason' => 'ܥܠܬܐ ܐܚܪܬܐ/ܢܩܝܦܬܐ:',
	'globalblocking-block-reasonotherlist' => 'ܥܠܬܐ ܐܚܪܬܐ',
	'globalblocking-block-expiry-otherfield' => 'ܥܕܢܐ ܐܚܪܬܐ:',
	'globalblocking-block-options' => 'ܓܒܝܬ̈ܐ',
	'globalblocking-list' => 'ܡܟܬܒܘܬܐ ܕܦܪ̈ܫܓܢܐ ܕܐܝܦܝ ܚܪ̈ܝܡܐ ܓܘܢܐܝܬ',
	'globalblocking-list-anononly' => 'ܠܐ ܝܕ̈ܝܥܐ ܒܠܚܘܕ',
	'globalblocking-list-whitelist' => 'ܐܝܟܢܝܘܬܐ ܕܘܟܬܢܝܬܐ',
	'globalblocking-whitelist-reason' => 'ܥܠܬܐ:',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock| بيسمح]] بمنع عناوين الاى بى [[Special:GlobalBlockList|على اكتر من ويكي]]',
	'globalblocking-block' => 'اعمل منع عام لعنوان اى بي',
	'globalblocking-block-intro' => 'ممكن تستعمل الصفحة دى هلشان تمنع عنوان اى بى من على كل الويكيهات.',
	'globalblocking-block-reason' => 'السبب:',
	'globalblocking-block-expiry' => 'انتهاء المنع:',
	'globalblocking-block-expiry-other' => 'وقت انتها تاني',
	'globalblocking-block-expiry-otherfield' => 'وقت تاني:',
	'globalblocking-block-legend' => 'اعمل منع عام لأيبي',
	'globalblocking-block-options' => 'اختيارات:',
	'globalblocking-block-errors' => 'المنع اللى عملته مانفعش، علشان {{PLURAL:$1|السبب دا|الاسباب دي}}:',
	'globalblocking-block-ipinvalid' => 'عنوان الأيبى ($1) اللى دخلته مش صحيح.
لو سمحت تاخد بالك انه ماينفعش تدخل  اسم يوزر!',
	'globalblocking-block-expiryinvalid' => 'تاريخ الانتهاء ($1) اللى دخلته مش صحيح.',
	'globalblocking-block-submit' => 'امنع عنوان الاى بى دا منع عام',
	'globalblocking-block-success' => 'عنوان الاى بى $1 اتمنع بنجاح فى كل المشاريع',
	'globalblocking-block-successsub' => 'المنع العام ناجح',
	'globalblocking-block-alreadyblocked' => 'عنوان الايبى $1 ممنوع منع عام من قبل كدا.
ممكن تشوف المنع الموجود هنا [[Special:GlobalBlockList|لستة المنع العام]].
أو تعديل إعدادات المنع الموجود عن طريق إعادة تنفيذ هذه الاستمارة.',
	'globalblocking-block-bigrange' => 'النطاق اللى حددته ($1) كبير قوى على المنع. انت ممكن تمنع، كحد أقصى، 65,536 عنوان (نطاقات /16)',
	'globalblocking-list-intro' => 'دى لستة بكل عمليات المنع العام اللى شغالة دلوقتى.
فى شوية منهم متعلم على انهم متعطلين ع المستوى المحلى، دا معناه انهم بينطبقو على المواقع التانية
بس فى ادارى محلى قرر يعطلها فى الويكى دا.',
	'globalblocking-list' => 'لستة عناوين الأيبى الممنوعة منع عام',
	'globalblocking-search-legend' => 'تدوير على منع عام',
	'globalblocking-search-ip' => 'عنوان الأيبي:',
	'globalblocking-search-submit' => 'تدوير على عمليات المنع',
	'globalblocking-list-ipinvalid' => 'عنوان الأيبى اللى دورت عليه($1) مش صحيح.
لو سمحت تدخل عنوان أيبى صحيح.',
	'globalblocking-search-errors' => 'تدويرك مانفعش ،{{PLURAL:$1|علشان|علشان}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') ممنوعين منع عام [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => '$1 بينتهي',
	'globalblocking-list-anononly' => 'المجهولين بس',
	'globalblocking-list-unblock' => 'شيل',
	'globalblocking-list-whitelisted' => 'اتعطل  محلى بواسطة $1: $2',
	'globalblocking-list-whitelist' => 'الحالة المحلية',
	'globalblocking-goto-block' => 'منع عام لعنوان أيبي',
	'globalblocking-goto-unblock' => 'شيل منع عام',
	'globalblocking-goto-status' => 'تغيير الحالة المحلية لمنع عام',
	'globalblocking-return' => 'ارجع للستة المنع  العام',
	'globalblocking-notblocked' => 'عنوان الاى بى ($1) اللى دخلته مش ممنوع منع عام',
	'globalblocking-unblock' => 'شيل منع عام',
	'globalblocking-unblock-ipinvalid' => 'عنوان الأيبى ($1) اللى دخلته مش صحيح.
لو سمحت تاخد بالك  انه ماينفعش تدخل اسم يوزر!',
	'globalblocking-unblock-legend' => 'شيل منع العام',
	'globalblocking-unblock-submit' => 'شيل المنع العام',
	'globalblocking-unblock-reason' => 'السبب:',
	'globalblocking-unblock-unblocked' => "إنتا شيلت بنجاح المنع العام #$2 على عنوان الأيبى '''$1'''",
	'globalblocking-unblock-errors' => 'شيلانك للمنع العام كان مش ناجح، علشان {{PLURAL:$1|السبب دا|الاسباب دي}}:',
	'globalblocking-unblock-successsub' => 'المنع العام اتشال بنجاح.',
	'globalblocking-unblock-subtitle' => 'شيل المنع العام',
	'globalblocking-unblock-intro' => 'ممكن تستعمل الاستمارة دى علشان تشيل منع عام.',
	'globalblocking-whitelist' => 'الحالة المحلية لعمليات المنع العامة',
	'globalblocking-whitelist-legend' => 'غير الحالة المحلية',
	'globalblocking-whitelist-reason' => 'سبب:',
	'globalblocking-whitelist-status' => 'الحالة المحلية:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} عطل المنع العام دا على',
	'globalblocking-whitelist-submit' => 'غير الحالة المحلية.',
	'globalblocking-whitelist-whitelisted' => "إنتا عطلت بنجاح المنع العام #$2 على عنوان الأيبى '''$1''' فى {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "انت فعلت تانى بنجاح المنع العام #$2 على عنوان الاى بى  '''$1''' فى {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'الحالة المحلية اتغيرت ببنجاح',
	'globalblocking-whitelist-nochange' => 'انت ما عملتش اى تغيير فى للحالة المحلية للمنع دا.
[[Special:GlobalBlockList|ارجع للستة المنع العام]].',
	'globalblocking-whitelist-errors' => 'التغيير اللى عملته للحالة المحلية للمنع العام ما نجحش،علشان{{PLURAL:$1|السبب دا|الاسباب دي}}:',
	'globalblocking-whitelist-intro' => 'ممكن تستعمل الاستمارة دى علشان تعدل الحالة المحلية للمنع العام.لو  فى منع عام متعطل على الويكى دا ،اليوزرز على عنوان الاى بى المتاثر ح يقدرو يعملو تعديل بشكل طبيعى.
[[Special:GlobalBlockList|الرجوع للستة المنع العامة]].',
	'globalblocking-blocked' => "'''\$1''' (''\$2'') عمل منع لعنوان الاى بى بتاعك  على كل الويكيهات.
السبب هو ''\"\$3\"''.
المنع ''\"\$4\"''.",
	'globalblocking-logpage' => 'سجل المنع العام',
	'globalblocking-logpagetext' => 'دا سجل بعمليات المنع العام اللى اتعملت و اتشالت فى الويكى دا.
لازم تاخد بالك ان عمليات المنع العام ممكن تتعمل و تتشال على الويكيهات التانية، و ان عمليات المنع العام دى ممكن تاثر على الويكى دا.
علشان تشوف  كل عمليات المنع العام النشيطة، بص على [[Special:GlobalBlockList|لستة المنع العام]].',
	'globalblocking-block-logentry' => '$2 امنع [[$1]] على المستوى العام وينتهى بتاريخ',
	'globalblocking-unblock-logentry' => 'شيل المنع العام من على [[$1]]',
	'globalblocking-whitelist-logentry' => 'عطل المنع العام على [[$1]] على المستوى المحلى',
	'globalblocking-dewhitelist-logentry' => 'شغل من تانى المنع العام على [[$1]] على المستوى المحلى',
	'globalblocklist' => 'لستة عناوين الاى بى الممنوعة منع عام',
	'globalblock' => 'منع عام لعنوان أى بي',
	'globalblockstatus' => 'الحالة المحلية للمنع العام',
	'removeglobalblock' => 'شيل منع عام',
	'right-globalblock' => 'اعمل منع عام',
	'right-globalunblock' => 'شيل المنع العام',
	'right-globalblock-whitelist' => 'عطل المنع العام على المستوى المحلي',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permite]] [[Special:GlobalBlockList|bloquiar en múltiples wikis]] direicciones IP',
	'globalblocking-block' => 'Bloquiar globalmente una direición IP',
	'globalblocking-modify-intro' => "Pues usar esti formulariu pa camudar les preferencies d'un bloquéu global.",
	'globalblocking-block-intro' => 'Pues usar esta páxina pa bloquiar una direición IP en toles wikis.',
	'globalblocking-block-reason' => 'Motivu:',
	'globalblocking-block-otherreason' => 'Motivu distintu/adicional:',
	'globalblocking-block-reasonotherlist' => 'Otru motivu',
	'globalblocking-block-reason-dropdown' => '*Motivos pa bloquiar de vezu
** Spam cruzáu nes wikis
** Abusu cruzáu nes wikis
** Vandalismu',
	'globalblocking-block-edit-dropdown' => 'Editar motivos del bloquéu',
	'globalblocking-block-expiry' => 'Caducidá:',
	'globalblocking-block-expiry-other' => 'Otra caducidá',
	'globalblocking-block-expiry-otherfield' => 'Otru periodu:',
	'globalblocking-block-legend' => 'Bloquiar globalmente una direición IP',
	'globalblocking-block-options' => 'Opciones:',
	'globalblocking-ipaddress' => 'Direición IP:',
	'globalblocking-ipbanononly' => 'Bloquiar namái usuarios anónimos',
	'globalblocking-block-errors' => 'El bloquéu nun tuvo ésitu {{PLURAL:$1|pol siguiente motivu|polos siguientes motivos}}:',
	'globalblocking-block-ipinvalid' => "La direición IP ($1) qu'especificasti nun ye válida.
¡Por favor fíxate en que nun pues poner un nome d'usuariu!",
	'globalblocking-block-expiryinvalid' => "La caducidá qu'especificasti ($1) nun ye válida.",
	'globalblocking-block-submit' => 'Bloquiar globalmente esta direición IP',
	'globalblocking-modify-submit' => 'Camudar esti bloquéu global',
	'globalblocking-block-success' => 'La direición IP $1 foi bloquiada en tolos proyeutos con ésitu.',
	'globalblocking-modify-success' => 'El bloquéu global de $1 se camudó correutamente',
	'globalblocking-block-successsub' => 'Bloquéu global con ésitu',
	'globalblocking-modify-successsub' => 'El bloquéu global se camudó correutamente',
	'globalblocking-block-alreadyblocked' => 'La direición IP $1 yá ta bloquiada globalmente.
Pues ver el bloquéu esistente na [[Special:GlobalBlockList|llista de bloqueos globales]],
o camudar les preferencies del bloquéu esistente volviendo a unviar esti formulariu.',
	'globalblocking-block-bigrange' => "L'intervalu especificáu ($1) ye demasiao grande pa bloquialu.
Pues bloquiar, como muncho, 65.536 direiciones (/16 intervalos)",
	'globalblocking-list-intro' => "Esta ye una llista de tolos bloqueos globales activos anguaño.
Dalgunos bloqueos tán marcaos como desactivaos llocalmente: esto significa qu'afeuta a otros sitios pero qu'un alministrador llocal decidió desactivalu nesa wiki.",
	'globalblocking-list' => 'Llista de direiciones IP bloquiaes globalmente',
	'globalblocking-search-legend' => 'Buscar una cuenta global',
	'globalblocking-search-ip' => 'Direición IP:',
	'globalblocking-search-submit' => 'Buscar bloqueos',
	'globalblocking-list-ipinvalid' => 'La direición IP que busques pa ($1) nun ye válida.
Por favor escribi una direición IP válida.',
	'globalblocking-search-errors' => 'La to busca nun tuvo ésitu {{PLURAL:$1|pol siguiente motivu|polos siguientes motivos}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bloquió globalmente a [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'caducidá $1',
	'globalblocking-list-anononly' => 'namái anónimos',
	'globalblocking-list-unblock' => 'desaniciar',
	'globalblocking-list-whitelisted' => 'desactiváu llocalmente por $1: $2',
	'globalblocking-list-whitelist' => 'estatus llocal',
	'globalblocking-list-modify' => 'camudar',
	'globalblocking-list-noresults' => 'La direición IP nun ta bloquiada.',
	'globalblocking-goto-block' => 'Bloquiar globalmente una direición IP',
	'globalblocking-goto-unblock' => 'Eliminar un bloquéu global',
	'globalblocking-goto-status' => "Camudar l'estatus llocal d'un bloquéu global",
	'globalblocking-return' => 'Tornar a la llista de bloqueos globales',
	'globalblocking-notblocked' => "La direición IP ($1) qu'escribisti nun ta bloquiada globalmente.",
	'globalblocking-unblock' => 'Eliminar un bloquéu global',
	'globalblocking-unblock-ipinvalid' => "La direición IP ($1) qu'especificasti nun ye válida.
¡Por favor fíxate en que nun pues poner un nome d'usuariu!",
	'globalblocking-unblock-legend' => 'Eleminar un bloquéu global',
	'globalblocking-unblock-submit' => 'Eliminar bloquéu global',
	'globalblocking-unblock-reason' => 'Motivu:',
	'globalblocking-unblock-unblocked' => "Eliminasti con ésitu'l bloquéu global númberu $2 de la direición IP '''$1'''",
	'globalblocking-unblock-errors' => 'La eliminación del bloquéu global nun tuvo ésitu {{PLURAL:$1|pol siguiente motivu|polos siguientes motivos}}:',
	'globalblocking-unblock-successsub' => 'Bloquéu global elimináu con ésitu',
	'globalblocking-unblock-subtitle' => 'Eliminando bloquéu global',
	'globalblocking-unblock-intro' => 'Pues usar esti formulariu pa eleminar un bloquéu global.',
	'globalblocking-whitelist' => 'Estatus lloal de bloqueos globales',
	'globalblocking-whitelist-notapplied' => "Los bloqueos globales nun s'apliquen nesta wiki, y poro
nun se pue camudar l'estáu de los bloqueos globales.",
	'globalblocking-whitelist-legend' => "Camudar l'estatus llocal",
	'globalblocking-whitelist-reason' => 'Motivu:',
	'globalblocking-whitelist-status' => 'Estatus llocal:',
	'globalblocking-whitelist-statuslabel' => 'Desactivar esti bloquéu global en {{SITENAME}}',
	'globalblocking-whitelist-submit' => "Camudar l'estatus llocal",
	'globalblocking-whitelist-whitelisted' => "Desactivasti con ésitu'l bloquéu global númberu $2 de la direición IP '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Reactivasti con ésitu'l bloquéu global númberu $2 de la direición IP '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Estatus llocal camudáu con ésitu',
	'globalblocking-whitelist-nochange' => "Nun se ficieron cambeos nel estatus llocal d'esti bloquéu.
[[Special:GlobalBlockList|Torna a la llista de bloqueos globlaes]].",
	'globalblocking-whitelist-errors' => "El to cambéu del estatus llocal d'un bloquéu global nun tuvo ésitu {{PLURAL:$1|pol siguiente motivu|polos siguientes motivos}}:",
	'globalblocking-whitelist-intro' => "Pues usar esti formulariu pa editar l'estatus llocal d'un bloquéu global.
Si un bloquéu global ta desactiváu nesta wiki, los usuarios de la direición IP afectada podrán editar normalmente.
[[Special:GlobalBlockList|Tornar a la llista de bloqueos globales]].",
	'globalblocking-blocked' => "La to direición IP \$5 foi bloquiada en toles wikis por '''\$1''' ('''\$2''').
El motivu dau foi ''\"\$3\"''.
El tiempu de bloquéu: ''\$4''.",
	'globalblocking-blocked-nopassreset' => "Nun puedes reaniciar les contraseñes d'usuariu porque tas bloquiáu de mou global.",
	'globalblocking-logpage' => 'Rexistru de bloqueos globales',
	'globalblocking-logpagetext' => "Esti ye un rexistru de bloqueos globales que fueron efeutuaos o eliminaos nesta wiki.
Ha recordase que los bloqueos globales puen efeutuase y eliminase n'otres wikis, y qu'esos bloqueos globales puen afeutar a esta wiki.
Pa ver tolos bloqueos globales activos, pues ver la [[Special:GlobalBlockList|llista de bloqueos globales]].",
	'globalblocking-block-logentry' => 'bloquió globalmente a [[$1]] con una caducidá de $2',
	'globalblocking-block2-logentry' => 'bloquió globalmente a [[$1]] ($2)',
	'globalblocking-unblock-logentry' => "eliminó'l bloquéu global de [[$1]]",
	'globalblocking-whitelist-logentry' => "desactivó'l bloquéu global de [[$1]] llocalmente",
	'globalblocking-dewhitelist-logentry' => "reactivó'l bloquéu global de [[$1]] llocalmente",
	'globalblocking-modify-logentry' => "camudó'l bloquéu global de [[$1]] ($2)",
	'globalblocking-logentry-expiry' => 'caduca el $1',
	'globalblocking-logentry-noexpiry' => 'nun se conseñó la caducidá',
	'globalblocking-loglink' => 'La direición IP $1 ta bloquiada globalmente ([[{{#Special:GlobalBlockList}}/$1|más detalles]]).',
	'globalblocking-showlog' => "Esta direición IP yá se bloquió previamente.
El rexistru de bloqueos s'ufre darréu pa referencia:",
	'globalblocklist' => 'Llista de direiciones IP bloquiaes globalmente',
	'globalblock' => 'Bloquiar globalmente una direición IP',
	'globalblockstatus' => 'Estatus llocal de bloqueos globales',
	'removeglobalblock' => 'Eliminar un bloquéu global',
	'right-globalblock' => 'Aplicar bloqueos globales',
	'right-globalunblock' => 'Eliminar bloqueos globales',
	'right-globalblock-whitelist' => 'Desactivar llocalmente bloqueos globales',
	'right-globalblock-exempt' => 'Saltar los bloqueos globales',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 * @author Vugar 1981
 */
$messages['az'] = array(
	'globalblocking-block-reason' => 'Səbəb:',
	'globalblocking-block-otherreason' => 'Digər/əlavə səbəb:',
	'globalblocking-block-reasonotherlist' => 'Digər səbəb',
	'globalblocking-block-expiry' => 'Bitmə müddəti:',
	'globalblocking-block-expiry-otherfield' => 'Başqa vaxt:',
	'globalblocking-block-options' => 'Nizamlamalar:',
	'globalblocking-search-ip' => 'IP ünvanı:',
	'globalblocking-list-whitelist' => 'lokal status',
	'globalblocking-list-modify' => 'dəyişmək',
	'globalblocking-unblock-reason' => 'Səbəb:',
	'globalblocking-whitelist-reason' => 'Səbəb:',
	'globalblocking-logpage' => 'Qlobal blok gündəliyi',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'globalblocking-desc' => 'IP адрестарҙы [[Special:GlobalBlockList|бер нисә викила дөйөм бикләү]] [[Special:GlobalBlock|мөмкинлеге бирә]]',
	'globalblocking-block' => 'IP адресты дөйөм бикләү',
	'globalblocking-modify-intro' => 'Дөйөм бикләү көйләүҙәрен үҙгәтеү өсөн ошо форманы ҡуллана алаһығыҙ.',
	'globalblocking-block-intro' => 'IP адресты бөтә викиларҙа бикләү өсөн ошо битте ҡуллана алаһығыҙ.',
	'globalblocking-block-reason' => 'Сәбәп:',
	'globalblocking-block-otherreason' => 'Башҡа/өҫтәмә сәбәп:',
	'globalblocking-block-reasonotherlist' => 'Башҡа сәбәп',
	'globalblocking-block-reason-dropdown' => '* Ғәҙәттәге бикләү сәбәптәре
** Вики-ара спам
** Вики-ара урынһыҙ ҡулланыуҙар
** Вандаллыҡ',
	'globalblocking-block-edit-dropdown' => 'Бикләү сәбәптәрен мөхәррирләргә',
	'globalblocking-block-expiry' => 'Тамамлана:',
	'globalblocking-block-expiry-other' => 'Башҡа тамамланыу ваҡыты',
	'globalblocking-block-expiry-otherfield' => 'Башҡа ваҡыт:',
	'globalblocking-block-legend' => 'IP адресты дөйөм бикләү',
	'globalblocking-block-options' => 'Көйләүҙәр:',
	'globalblocking-block-errors' => 'Һеҙҙең бикләүегеҙ түбәндәге {{PLURAL:$1|сәбәп|сәбәптәр}} арҡаһында уңышһыҙ тамамланды:',
	'globalblocking-block-ipinvalid' => 'Һеҙ кереткән IP адрес ($1) дөрөҫ түгел.
Зинһар, ҡатнашыусы исемен керетә алмауығыҙҙы иғтибарға алығыҙ!',
	'globalblocking-block-expiryinvalid' => 'Һеҙ кереткән тамамланыу ваҡыты ($1) дөрөҫ түгел.',
	'globalblocking-block-submit' => 'Был IP адресты дөйөм бикләргә',
	'globalblocking-modify-submit' => 'Был дөйөм бикләүҙе үҙгәртергә',
	'globalblocking-block-success' => '$1 IP адресы бөтә проекттарҙа ла уңышлы бикләнде.',
	'globalblocking-modify-success' => '$1 дөйөм бикләү уңышлы үҙгәртелде.',
	'globalblocking-block-successsub' => 'Дөйөм бикләү уңышлы тамамланды',
	'globalblocking-modify-successsub' => 'Дөйөм бикләү уңышлы үҙгәртелде',
	'globalblocking-block-alreadyblocked' => '$1 IP адресы дөйөм бикләнгән ине инде.
[[Special:GlobalBlockList|Һеҙ дөйөм бикләүҙәр исемлегендә]] булған бикләүҙәрҙе ҡарай алаһығыҙ, йәки булған бикләүҙең көйләүҙәрен, ошо форманы ҡабаттан ебәреп, үҙгәртә алаһығыҙ.',
	'globalblocking-block-bigrange' => 'Һеҙ күрһәткән арауыҡ ($1) бикләу өсөн бигерәк ҙур.
Һеҙ иң күбендә 65 536 адрес бикләй алаһығыҙ (/16 арауыҡ)',
	'globalblocking-list-intro' => 'Был — хәҙерге ваҡытта булған дөйөм бикләүҙәр исемлеге.
Ҡайһы бер бикләүҙәр урында һүндерелгән, тип билдәләнгән: был улар башҡа сайттарҙа ҡулланыла, әммә урындағы хәким был викила уларҙы һүндерергә булған, тигәнде аңлата.',
	'globalblocking-list' => 'Дөйөм бикләнгән IP адрестар исемлеге',
	'globalblocking-search-legend' => 'Дөйөм бикләүҙе эҙләү',
	'globalblocking-search-ip' => 'IP-адрес:',
	'globalblocking-search-submit' => 'Бикләүҙәрҙе табырға',
	'globalblocking-list-ipinvalid' => 'Һеҙ эҙләгән IP адрес ($1) дөрөҫ түгел.
Зинһар, дөрөҫ IP адрес керетегеҙ.',
	'globalblocking-search-errors' => 'Һеҙҙең эҙләүегеҙ түбәндәге {{PLURAL:$1|сәбәп|сәбәптәр}} арҡаһында уңышһыҙ тамамланды:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') [[Special:Contributions/\$4|\$4]] адресын дөйөм бикләгән ''(\$5)''",
	'globalblocking-list-expiry' => '$1 тамамлана',
	'globalblocking-list-anononly' => 'танылмағандар ғына',
	'globalblocking-list-unblock' => 'бикте алырға',
	'globalblocking-list-whitelisted' => '$1 тарафынан урында һүндерелгән: $2',
	'globalblocking-list-whitelist' => 'урындағы торошо',
	'globalblocking-list-modify' => 'үҙгәртергә',
	'globalblocking-list-noresults' => 'Һоратылған IP адрес бикләнмәгән.',
	'globalblocking-goto-block' => 'IP адресты дөйөм бикләргә',
	'globalblocking-goto-unblock' => 'Дөйөм бикте алырға',
	'globalblocking-goto-status' => 'Дөйөм биктең урындағы торошон үҙгәртергә',
	'globalblocking-return' => 'Дөйөм бикләүҙәр исемлегенә кире ҡайтырға',
	'globalblocking-notblocked' => 'Һеҙ кереткән IP адрес ($1) дөйөм бикләнмәгән.',
	'globalblocking-unblock' => 'Дөйөм бикте алырға',
	'globalblocking-unblock-ipinvalid' => 'Һеҙ кереткән IP адрес ($1) дөрөҫ түгел.
Зинһар, ҡатнашыусы исемен керетә алмауығыҙҙы иғтибарға алығыҙ!',
	'globalblocking-unblock-legend' => 'Дөйөм бикте алыу',
	'globalblocking-unblock-submit' => 'Дөйөм бикте алырға',
	'globalblocking-unblock-reason' => 'Сәбәп:',
	'globalblocking-unblock-unblocked' => "Һеҙ '''$1''' IP адресынан №$2 дөйөм бикте уңышлы алдығыҙ.",
	'globalblocking-unblock-errors' => 'Һеҙҙең бикте алыуығыҙ түбәндәге {{PLURAL:$1|сәбәп|сәбәптәр}} арҡаһында уңышһыҙ тамамланды:',
	'globalblocking-unblock-successsub' => 'Дөйөм бик уңышлы кире алынды',
	'globalblocking-unblock-subtitle' => 'Дөйөм бикте алыу',
	'globalblocking-unblock-intro' => 'Дөйөм бикте алыу өсөн ошо форманы ҡуллана алаһығыҙ.',
	'globalblocking-whitelist' => 'Дөйөм биктәрҙең урындағы торошо',
	'globalblocking-whitelist-notapplied' => 'Был викила дөйөм биктәр ҡулланылмай, 
шуға күрә дөйөм биктәрҙең урындағы торошо үҙгәртелә алмай.',
	'globalblocking-whitelist-legend' => 'Урындағы торошто үҙгәртеү',
	'globalblocking-whitelist-reason' => 'Сәбәп:',
	'globalblocking-whitelist-status' => 'Урындағы торошо:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} проектында был дөйөм бикте һүндерергә',
	'globalblocking-whitelist-submit' => 'Урындағы торошто үҙгәртергә',
	'globalblocking-whitelist-whitelisted' => "Һеҙ {{SITENAME}} проектында '''$1''' IP адресының №$2 дөйөм биген уңышлы һүндерҙегеҙ.",
	'globalblocking-whitelist-dewhitelisted' => "Һеҙ {{SITENAME}} проектында '''$1''' IP адресының №$2 дөйөм биген уңышлы тергеҙҙегеҙ.",
	'globalblocking-whitelist-successsub' => 'Урындағы торош уңышлы үҙгәртелде',
	'globalblocking-whitelist-nochange' => 'Һеҙ был биктең урындағы торошон үҙгәртмәнегеҙ.
[[Special:GlobalBlockList|Дөйөм бикләүҙәр исемлегенә кире ҡайтырға]].',
	'globalblocking-whitelist-errors' => 'Һеҙҙең биктең урындағы торошон үҙәртеүегеҙ түбәндәге {{PLURAL:$1|сәбәп|сәбәптәр}} арҡаһында уңышһыҙ тамамланды:',
	'globalblocking-whitelist-intro' => 'Дөйөм бикләүҙең урындағы торошон үҙгәртеү өсөн ошо форманы ҡуллана алаһығыҙ.
Әгәр был викила дөйөм бикләү һүндерелгән булһа, ул IP адреслы ҡатнашыусылар биттәрҙе ғәҙәттәгесә үҙгәртә аласаҡ.
[[Special:GlobalBlockList|Дөйөм бикләүҙәр исемлегенә кире ҡайтырға]].',
	'globalblocking-blocked' => "Һеҙҙең IP адресығыҙ \$5 бөтә вики проекттарҙа '''\$1''' (''\$2'') тарафынан бикләнгән.
Күрһәтелгән сәбәп: ''\"\$3\"''.
Бикләү ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Һеҙ ҡатнашыусыларҙың паролен үҙгәртә алмайһығыҙ, сөнки дөйөм бикләнгәнһегеҙ.',
	'globalblocking-logpage' => 'Дөйөм бикләүҙәр яҙмалары журналы',
	'globalblocking-logpagetext' => 'Был — ошо вики проектта ҡуйылған йәки һүндерелгән дөйөм бикләү яҙмалары журналы.
Дөйөм бикләүҙәр башҡа вики проекттарҙа ҡуйыла йәки һүндерелә ала һәм был вики проектта ҡулланыла ала икәнен иғтибарға алырға кәрәк.
Һеҙ шулай уҡ [[Special:GlobalBlockList|дөйөм бикләүҙәр исемлеген]] ҡарай алаһығыҙ.',
	'globalblocking-block-logentry' => '[[$1]] IP адресын дөйөм бикләгән, тамамланыу ваҡыты: $2',
	'globalblocking-block2-logentry' => '[[$1]] IP адресын дөйөм бикләгән ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] IP адресының дөйөм биген алған',
	'globalblocking-whitelist-logentry' => '[[$1]] IP адресының дөйөм биген урында һүндергән',
	'globalblocking-dewhitelist-logentry' => '[[$1]] IP адресының дөйөм биген урында тергеҙгән',
	'globalblocking-modify-logentry' => '[[$1]] IP адресының дөйөм биген үҙгәрткән ($2)',
	'globalblocking-logentry-expiry' => '$1 тамамлана',
	'globalblocking-logentry-noexpiry' => 'тамамланыу ваҡыты билдәләнмәгән',
	'globalblocking-loglink' => '$1 IP адресы дөйөм бикләнгән ([[{{#Special:GlobalBlockList}}/$1|тулыраҡ мәғлүмәт]]).',
	'globalblocking-showlog' => 'Был IP адрес бикләнгән ине инде.
Түбәндә белешмә өсөн бикләү яҙмалары журналы килтерелгән:',
	'globalblocklist' => 'Дөйөм бикләнгән IP адрестар исемлеге',
	'globalblock' => 'IP адресты дөйөм бикләү',
	'globalblockstatus' => 'Дөйөм биктәрҙең урындағы торошо',
	'removeglobalblock' => 'Дөйөм бикте алырға',
	'right-globalblock' => 'Дөйөм бикләү',
	'right-globalunblock' => 'Дөйөм биктәрҙе алыу',
	'right-globalblock-whitelist' => 'Дөйөм биктәрҙе урында һүндереү',
	'right-globalblock-exempt' => 'Дөйөм биктәрҙе урап үтеү',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'globalblocking-block-reason' => 'Прычына:',
	'globalblocking-unblock-reason' => 'Прычына:',
	'globalblocking-whitelist-reason' => 'Прычына:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Дазваляе]] блякаваньне IP-адрасоў у [[Special:GlobalBlockList|некалькіх вікі]]',
	'globalblocking-block' => 'Глябальнае блякаваньне IP-адрасу',
	'globalblocking-modify-intro' => 'Вы можаце выкарыстоўваць гэтую форму, каб зьмяняць налады глябальнага блякаваньня.',
	'globalblocking-block-intro' => 'Вы можаце выкарыстоўваць гэту старонку для блякаваньня ІР-адрасу на ўсіх вікі.',
	'globalblocking-block-reason' => 'Прычына:',
	'globalblocking-block-otherreason' => 'Іншая/дадатковая прычына:',
	'globalblocking-block-reasonotherlist' => 'Іншая прычына',
	'globalblocking-block-reason-dropdown' => '* Агульныя прычыны блякаваньняў
** Cпам у розных вікі
** Злоўжываньні ў розных вікі
** Вандалізм',
	'globalblocking-block-edit-dropdown' => 'Рэдагаваць прычыны блякяваньняў',
	'globalblocking-block-expiry' => 'Тэрмін:',
	'globalblocking-block-expiry-other' => 'Іншы тэрмін',
	'globalblocking-block-expiry-otherfield' => 'Іншы тэрмін:',
	'globalblocking-block-legend' => 'Глябальнае блякаваньне IP-адрасу',
	'globalblocking-block-options' => 'Налады:',
	'globalblocking-ipaddress' => 'IP-адрас:',
	'globalblocking-ipbanononly' => 'Блякаваць толькі ананімаў',
	'globalblocking-block-errors' => 'Блякаваньне не адбылося па {{PLURAL:$1|наступнай прычыне|наступных прычынах}}:',
	'globalblocking-block-ipinvalid' => 'Уведзены Вамі ІР-адрас ($1) — няслушны.
Калі ласка, зьвярніце ўвагу, што Вы ня можаце ўводзіць імя ўдзельніка!',
	'globalblocking-block-expiryinvalid' => 'Уведзены Вамі тэрмін блякаваньня ($1) — няслушны.',
	'globalblocking-block-submit' => 'Заблякаваць гэты ІР-адрас глябальна',
	'globalblocking-modify-submit' => 'Зьмяніць гэта глябальнае блякаваньне',
	'globalblocking-block-success' => 'ІР-адрас $1 быў пасьпяхова заблякаваны ва ўсіх праектах.',
	'globalblocking-modify-success' => 'Глябальнае блякаваньне $1 было пасьпяхова зьмененае',
	'globalblocking-block-successsub' => 'Глябальнае блякаваньне пасьпяховае',
	'globalblocking-modify-successsub' => 'Глябальнае блякаваньне было пасьпяхова зьменена',
	'globalblocking-block-alreadyblocked' => 'ІР-адрас $1 ужо глябальна заблякаваны.
Вы можаце праглядзець існуючыя блякаваньні ў [[Special:GlobalBlockList|сьпісе глябальных блякаваньняў]], ці зьмяніць настройкі існуючага блякаваньня праз зьмяненьне гэтай формы.',
	'globalblocking-block-bigrange' => 'Пазначаны Вамі дыяпазон ($1) занадта вялікі для блякаваньня.
Вы можаце заблякаваць ня больш за 65 536 адрасоў (/16 дыяпазону)',
	'globalblocking-list-intro' => 'Гэта сьпіс усіх дзейных глябальных блякаваньняў. 
Некаторыя блякаваньні пазначаныя як лякальна выключаныя: што азначае, што яны дзейнічаюць на іншых сайтах, але лякальны адміністратар вырашыў адключыць блякаваньне ў сваёй вікі.',
	'globalblocking-list' => 'Сьпіс глябальна заблякаваных ІР-адрасоў',
	'globalblocking-search-legend' => 'Пошук глябальнага блякаваньня',
	'globalblocking-search-ip' => 'IP-адрас:',
	'globalblocking-search-submit' => 'Пошук блякаваньняў',
	'globalblocking-list-ipinvalid' => 'Няслушны ІР-адрас ($1), які Вы шукаеце.
Калі ласка, увядзіце слушны ІР-адрас.',
	'globalblocking-search-errors' => 'Ваш пошук быў няўдалым па {{PLURAL:$1|наступнай прычыне|наступных прычынах}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') глябальна заблякаваў [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'канчаецца $1',
	'globalblocking-list-anononly' => 'толькі ананімаў',
	'globalblocking-list-unblock' => 'разблякаваць',
	'globalblocking-list-whitelisted' => 'лякальна адключыў $1: $2',
	'globalblocking-list-whitelist' => 'лякальны статус',
	'globalblocking-list-modify' => 'зьмяніць',
	'globalblocking-list-noresults' => 'Запытаны IP-адрас не заблякаваны.',
	'globalblocking-goto-block' => 'Заблякаваць ІР-адрас глябальна',
	'globalblocking-goto-unblock' => 'Разблякаваць глябальна',
	'globalblocking-goto-status' => 'Зьмяніць лякальны статус глябальнага блякаваньня',
	'globalblocking-return' => 'Вярнуцца да сьпісу глябальных блякаваньняў',
	'globalblocking-notblocked' => 'Уведзены ІР-адрас ($1) не заблякаваны глябальна.',
	'globalblocking-unblock' => 'Разблякаваць глябальна',
	'globalblocking-unblock-ipinvalid' => 'Уведзены Вамі ІР-адрас ($1) — няслушны.
Калі ласка, зьвярніце ўвагу, што Вы ня можаце ўводзіць імя ўдзельніка!',
	'globalblocking-unblock-legend' => 'Глябальнае разблякаваньне',
	'globalblocking-unblock-submit' => 'Разблякаваць глябальна',
	'globalblocking-unblock-reason' => 'Прычына:',
	'globalblocking-unblock-unblocked' => "Вы пасьпяхова глябальна разблякавалі IP-адрас '''$1''' (#$2)",
	'globalblocking-unblock-errors' => 'Спроба глябальнага разблякаваньня не атрымалася па {{PLURAL:$1|наступнай прычыне|наступных прычынах}}:',
	'globalblocking-unblock-successsub' => 'Глябальнае разблякаваньне пасьпяховае',
	'globalblocking-unblock-subtitle' => 'Зьняцьце глябальнага блякаваньня',
	'globalblocking-unblock-intro' => 'Вы можаце карыстацца гэтай формай для глябальнага разблякаваньня.',
	'globalblocking-whitelist' => 'Лякальны статус глябальных блякаваньняў',
	'globalblocking-whitelist-notapplied' => 'Глябальныя блякаваньні ня дзейнічаюць у {{GRAMMAR:месны|{{SITENAME}}}},
таму лякальны статус глябальнага блякаваньня ня можа быць зьменены.',
	'globalblocking-whitelist-legend' => 'Зьмена лякальнага статусу',
	'globalblocking-whitelist-reason' => 'Прычына:',
	'globalblocking-whitelist-status' => 'Лякальны статус:',
	'globalblocking-whitelist-statuslabel' => 'Адключыць гэтае глябальнае блякаваньне ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Зьмяніць лякальны статус',
	'globalblocking-whitelist-whitelisted' => "Глябальнае блякаваньне #$2 IP-адрасу '''$1''' было пасьпяхова адключанае ў {{GRAMMAR:месны|{{SITENAME}}}}.",
	'globalblocking-whitelist-dewhitelisted' => "Глябальнае блякаваньне #$2 IP-адрасу '''$1''' было пасьпяхова адноўленае ў {{GRAMMAR:месны|{{SITENAME}}}}.",
	'globalblocking-whitelist-successsub' => 'Лякальны статус пасьпяхова зьменены',
	'globalblocking-whitelist-nochange' => 'Вы не зьмянілі лякальны статус гэтага блякаваньня.
[[Special:GlobalBlockList|Вярнуцца да сьпісу глябальных блякаваньняў]].',
	'globalblocking-whitelist-errors' => 'Спроба зьмяніць лякальны статус гэтага глябальнага блякаваньня была няўдалай па {{PLURAL:$1|наступнай прычыне|наступных прычынах}}:',
	'globalblocking-whitelist-intro' => 'Вы можаце карыстацца гэтай формай для рэдагаваньня лякальнага статусу глябальнага блякаваньня.
Калі глябальнае блякаваньне будзе адключанае ў гэтай вікі, удзельнікі з адпаведнымі ІР-адрасамі будуць мець магчымасьць звычайнага рэдагаваньня старонак.
[[Special:GlobalBlockList|Вярнуцца да сьпісу глябальных блякаваньняў]].',
	'globalblocking-blocked' => "Ваш ІР-адрас $5 быў заблякаваны ва ўсіх вікі ўдзельнікам '''$1''' (''$2'').
Прычына блякаваньня: ''«$3»''.
Блякаваньне ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Вы ня можаце аднавіць пароль удзельніка, таму што Вы заблякаваны глябальна.',
	'globalblocking-logpage' => 'Журнал глябальных блякаваньняў',
	'globalblocking-logpagetext' => 'Гэта сьпіс глябальных блякаваньняў, якія былі зробленыя і адмененыя ў гэтай вікі.
Майце на ўвазе, што глябальныя блякаваньні могуць быць зробленыя і адмененыя ў іншых вікі, але глябальныя блякаваньні могуць дзейнічаць таксама і ў гэтай вікі.
Вы можаце паглядзець усе актыўныя глябальныя блякаваньні [[Special:GlobalBlockList|тут]].',
	'globalblocking-block-logentry' => 'глябальна заблякаваны [[$1]] на тэрмін $2',
	'globalblocking-block2-logentry' => 'заблякаваны глябальна [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'глябальна разблякаваў [[$1]]',
	'globalblocking-whitelist-logentry' => 'лякальна адключанае глябальнае блякаваньне [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'лякальна адноўленае глябальнае блякаваньне [[$1]]',
	'globalblocking-modify-logentry' => 'зьмененае глябальнае блякаваньне [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'канчаецца $1',
	'globalblocking-logentry-noexpiry' => 'сканчэньне ня ўстаноўленае',
	'globalblocking-loglink' => 'IP-адрас заблякаваны глябальна ([[{{#Special:GlobalBlockList}}/$1|ўсе падрабязнасьці]]).',
	'globalblocking-showlog' => 'Гэты IP-адрас быў заблякаваны раней.
Ніжэй пададзены журнал блякаваньняў для даведкі:',
	'globalblocklist' => 'Сьпіс глябальна заблякаваных IP-адрасоў',
	'globalblock' => 'Глябальнае блякаваньне ІР-адрасу',
	'globalblockstatus' => 'Лякальны статус глябальных блякаваньняў',
	'removeglobalblock' => 'Разблякаваць глябальна',
	'right-globalblock' => 'глябальныя блякаваньні',
	'action-globalblock' => 'стварэньне глябальных блякаваньняў',
	'right-globalunblock' => 'глябальныя разблякаваньні',
	'action-globalunblock' => 'зьняцьце глябальных блякаваньняў',
	'right-globalblock-whitelist' => 'Лякальнае адключэньне глябальных блякаваньняў',
	'action-globalblock-whitelist' => 'адключэньне глябальных блякаваньняў лякальна',
	'right-globalblock-exempt' => 'ігнараваньне глябальных блякаваньняў',
	'action-globalblock-exempt' => 'ігнараваньне глябальных блякаваньняў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Позволява]] IP-адреси да се [[Special:GlobalBlockList|блокират едновременно в множество уикита]]',
	'globalblocking-block' => 'Глобално блокиране на IP-адрес',
	'globalblocking-modify-intro' => 'Може да използвате тази форма, за да промените настройките на глобално блокиране.',
	'globalblocking-block-intro' => 'Чрез тази страница може да се блокира IP-адрес едновременно във всички уикита.',
	'globalblocking-block-reason' => 'Причина:',
	'globalblocking-block-otherreason' => 'Друга или допълнителна причина:',
	'globalblocking-block-reasonotherlist' => 'Друга причина',
	'globalblocking-block-reason-dropdown' => '* Най-често срещани причини за блокиране
 ** Crosswiki спам
 ** Crosswiki злоупотреба
 ** Вандализъм',
	'globalblocking-block-edit-dropdown' => 'Редактиране на причините за блокиране',
	'globalblocking-block-expiry' => 'Срок на изтичане:',
	'globalblocking-block-expiry-other' => 'Друг срок за изтичане',
	'globalblocking-block-expiry-otherfield' => 'Друг срок:',
	'globalblocking-block-legend' => 'Глобално блокиране на IP-адрес',
	'globalblocking-block-options' => 'Настройки:',
	'globalblocking-block-errors' => 'Блокирането беше неуспешно поради {{PLURAL:$1|следната причина|следните причини}}:',
	'globalblocking-block-ipinvalid' => 'Въведеният IP-адрес ($1) е невалиден.
Имайте предвид, че не можете да въвеждате потребителско име!',
	'globalblocking-block-expiryinvalid' => 'Въведеният краен срок ($1) е невалиден.',
	'globalblocking-block-submit' => 'Блокиране на този IP адрес глобално',
	'globalblocking-modify-submit' => 'Промяна на това глобално блокиране',
	'globalblocking-block-success' => 'IP-адресът $1 беше успешно блокиран във всички проекти.',
	'globalblocking-modify-success' => 'Глобалното блокиране на $1 е успешно променено',
	'globalblocking-block-successsub' => 'Глобалното блокиране беше успешно',
	'globalblocking-modify-successsub' => 'Глобалното блокиране е успешно променено',
	'globalblocking-block-alreadyblocked' => 'IP-адресът $1 е вече блокиран глобално.
Можете да прегледате съществуващите блокирания в [[Special:GlobalBlockList|списъка с глобални блокирания]]
или да промените настройките на съществуващото блокиране, като изпратите повторно тази форма.',
	'globalblocking-block-bigrange' => 'Избраният регистър ($1) е твърде голям, за да бъде изцяло блокиран.
Наведнъж е възможно да се блокират най-много 65,536 адреса (/16 регистри)',
	'globalblocking-list-intro' => 'Това е списък на всички глобални блокирания, които понастоящем са в сила.
Някои блокирания са отбелязани като локално отменени: това означава, че те са приложими в другите уикита, но администраторът на локалното уики е решил да свали блокирането.',
	'globalblocking-list' => 'Списък на глобално блокирани IP адреси',
	'globalblocking-search-legend' => 'Търсене на глобално блокиране',
	'globalblocking-search-ip' => 'IP адрес:',
	'globalblocking-search-submit' => 'Търсене на блокирания',
	'globalblocking-list-ipinvalid' => 'Потърсеният от нас IP-адрес ($1) е невалиден.
Въведете валиден IP-адрес.',
	'globalblocking-search-errors' => 'Търсенето беше неуспешно по {{PLURAL:$1|следната причина|следните причини}}: 
$1',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') блокира глобално [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'срок на изтичане $1',
	'globalblocking-list-anononly' => 'само анонимни',
	'globalblocking-list-unblock' => 'отблокиране',
	'globalblocking-list-whitelisted' => 'локално изключен от $1: $2',
	'globalblocking-list-whitelist' => 'локален статут',
	'globalblocking-list-modify' => 'промяна',
	'globalblocking-list-noresults' => 'Заявеният IP-адрес не е блокиран.',
	'globalblocking-goto-block' => 'Глобално блокиране на IP-адрес',
	'globalblocking-goto-unblock' => 'Премахване на глобално блокиране',
	'globalblocking-goto-status' => 'Промяна на локалния статут на глобално блокиране',
	'globalblocking-return' => 'Връщане към списъка с глобалните блокирания',
	'globalblocking-notblocked' => 'Въведеният IP адрес ($1) не е блокиран глобално.',
	'globalblocking-unblock' => 'Премахване на глобално блокиране',
	'globalblocking-unblock-ipinvalid' => 'Въведеният IP адрес ($1) е невалиден.
Имайте предвид, че не можете да въвеждате потребителско име!',
	'globalblocking-unblock-legend' => 'Премахване на глобално блокиране',
	'globalblocking-unblock-submit' => 'Премахване на глобално блокиране',
	'globalblocking-unblock-reason' => 'Причина:',
	'globalblocking-unblock-unblocked' => "Успешно премахнахте глобалното блокиране #$2 на IP адрес '''$1'''",
	'globalblocking-unblock-errors' => 'Не можете да премахнете глобалното блокиране на този IP адрес поради {{PLURAL:$1|следната причина|следните причини}}:',
	'globalblocking-unblock-successsub' => 'Глобалното блокиране беше премахнато успешно',
	'globalblocking-unblock-subtitle' => 'Премахване на глобално блокиране',
	'globalblocking-unblock-intro' => 'Можете да използвате този формуляр, за да премахнете глобално блокиране.',
	'globalblocking-whitelist' => 'Локално състояние на глобалните блокирания',
	'globalblocking-whitelist-notapplied' => 'В това уики не се прилагат глобални блокирания,
затова локалното състояние на глобалните блокирания не може да се променя.',
	'globalblocking-whitelist-legend' => 'Промяна на локалния статут',
	'globalblocking-whitelist-reason' => 'Причина:',
	'globalblocking-whitelist-status' => 'Локален статут:',
	'globalblocking-whitelist-statuslabel' => 'Изключване на това глобално блокиране за {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Промяна на локалния статут',
	'globalblocking-whitelist-whitelisted' => "Успешно изключихте глобално блокиране #$2 на IP адрес '''$1''' в {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Успешно активирахте глобално блокиране #$2 на IP адрес '''$1''' в {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Локалният статут беше променен успешно',
	'globalblocking-whitelist-nochange' => 'Не сте внесли промени в локалното състояние на това блокиране.
[[Special:GlobalBlockList|Върнете се към списъка с глобални блокирания]].',
	'globalblocking-whitelist-errors' => 'Вашият опит за промяна на локалното състояние на глобалното блокиране беше неуспешен по  {{PLURAL:$1|следната причина|следните причини}}:',
	'globalblocking-whitelist-intro' => 'Можете да използвате този формуляр, за да промените локалното състояние на дадено глобално блокиране.
Ако глобалното блокиране бъде свалено за това уики, потребителите с достъп от съответния IP-адрес ще могат да редактират нормално.
[[Special:GlobalBlockList|Върнете се към списъка с глобални блокирания]].',
	'globalblocking-blocked' => "Вашият IP адрес беше блокиран във всички уикита от '''$1''' (''$2'').
Посочената причина е ''„$3“''. Блокирането ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Не можете да смените потребителската парола, защото сте блокиран глобално.',
	'globalblocking-logpage' => 'Дневник на глобалните блокирания',
	'globalblocking-logpagetext' => 'Това е дневник на глобалните блокирания, които са били наложени или премахнати в това уики.
Глобални блокирания могат да се налагат и премахват и в други уикита, и те могат да се отразят локално и тук.
[[Special:GlobalBlockList|Вижте списъка на всички текущи глобални блокирания.]]',
	'globalblocking-block-logentry' => 'глобално блокиране на [[$1]] със срок на изтичане $2',
	'globalblocking-block2-logentry' => 'глобално блокиран [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'премахна глобалното блокиране на [[$1]]',
	'globalblocking-whitelist-logentry' => 'премахна на локално ниво глобалното блокиране на [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'възвърна на локално ниво глобалното блокиране на [[$1]]',
	'globalblocking-modify-logentry' => 'промени глобалното блокиране на [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'изтича $1',
	'globalblocking-logentry-noexpiry' => 'не е зададено изтичане',
	'globalblocking-loglink' => 'IP-адресът $1 е блокиран глобално ([[{{#Special:GlobalBlockList}}/$1|пълни данни]]).',
	'globalblocking-showlog' => 'Този IP-адрес е бил блокиран преди.
За справка по-долу следва дневник на блокирането:',
	'globalblocklist' => 'Списък на глобално блокираните IP адреси',
	'globalblock' => 'Глобално блокиране на IP адрес',
	'globalblockstatus' => 'Локално състояние на глобалните блокирания',
	'removeglobalblock' => 'Премахване на глобално блокиране',
	'right-globalblock' => 'Създаване на глобални блокирания',
	'right-globalunblock' => 'Премахване на глобални блокирания',
	'right-globalblock-whitelist' => 'Локално спиране на глобалните блокирания',
	'right-globalblock-exempt' => 'Пренебрегване на глобалните блокирания',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'globalblocking-block-reason' => 'কারণ:',
	'globalblocking-block-otherreason' => 'অন্য/বাড়তি কারণ:',
	'globalblocking-block-reasonotherlist' => 'অন্য কারণ:',
	'globalblocking-block-edit-dropdown' => 'বাধাদানের কারণ সম্পাদনা',
	'globalblocking-block-expiry' => 'মেয়াদ উত্তীর্ণ:',
	'globalblocking-block-expiry-other' => 'অন্যান্য মেয়াদ উত্তীর্ণের সময়',
	'globalblocking-block-expiry-otherfield' => 'অন্য সময়:',
	'globalblocking-block-legend' => 'একটি আইপি ঠিকানাকে গ্লোবালি বাধা প্রদান করো',
	'globalblocking-block-options' => 'অপশন:',
	'globalblocking-ipaddress' => 'আইপি ঠিকানা:',
	'globalblocking-ipbanononly' => 'কেবল বেনামী ব্যবহারকারীদের বাধা দেওয়া হোক',
	'globalblocking-block-errors' => 'আপনার ব্লক ব্যর্থ হয়েছে, নিচের {{PLURAL:$1|কারণে|কারণসমূহের জন্য}}:',
	'globalblocking-block-expiryinvalid' => 'মেয়াদ উত্তীর্ণের যে সময় ($1) আপনি প্রবেশ করিয়েছেন তা গ্রহণযোগ্য নয়।',
	'globalblocking-block-submit' => 'এই আইপি ঠিকানাকে গ্লোবালি বাধাদান করো',
	'globalblocking-modify-submit' => 'এই গ্লোবাল বাধাটি পরিবর্তন করুন',
	'globalblocking-modify-success' => '$1-এর ওপর থাকা গ্লোবাল বাধাটি সফলভাবে পরিবর্তিত হয়েছে',
	'globalblocking-block-successsub' => 'গ্লোবাল বাধাটি সফল',
	'globalblocking-modify-successsub' => 'গ্লোবাল বাধাটি সফলভাবে পরিবর্তিত হয়েছে।',
	'globalblocking-list' => 'গ্লোবালি বাধা বলবৎ রয়েছে এমন আইপি ঠিকানাসমূহের তালিকা',
	'globalblocking-search-legend' => 'গ্লোবাল বাধার জন্য অনুসন্ধান',
	'globalblocking-search-ip' => 'আইপি ঠিকানা:',
	'globalblocking-search-submit' => 'বাধার জন্য অনুসন্ধান',
	'globalblocking-list-expiry' => 'মেয়াদ উত্তীর্ণের সময় $1',
	'globalblocking-list-anononly' => 'শুধুমাত্র বেনামী',
	'globalblocking-list-unblock' => 'অপসারণ',
	'globalblocking-list-whitelist' => 'স্থানীয় অবস্থা',
	'globalblocking-list-modify' => 'পরিবর্তন',
	'globalblocking-goto-block' => 'একটি আইপি ঠিকানাকে গ্লেবালি বাধা প্রদান করুন',
	'globalblocking-goto-unblock' => 'একটি গ্লোবাল বাধা তুলে নাও',
	'globalblocking-goto-status' => 'একটি গ্লোবল বাধার স্থানীয় অবস্থা পরিবর্তন করুন',
	'globalblocking-return' => 'গ্লোবাল বাধার তালিকায় ফিরে যান',
	'globalblocking-unblock' => 'একটি গ্লোবাল বাধা তুলে নাও',
	'globalblocking-unblock-legend' => 'একটি গ্লোবাল বাধা তুলে নাও',
	'globalblocking-unblock-submit' => 'গ্লোবাল বাধা তুলে নাও',
	'globalblocking-unblock-reason' => 'কারণ:',
	'globalblocking-unblock-successsub' => 'গ্লোবাল বাধা সফলভাবে তুলে নেওয়া হয়েছে',
	'globalblocking-unblock-subtitle' => 'গ্লোবাল বাধা তুলে নেওয়া হয়েছে',
	'globalblocking-unblock-intro' => 'গ্লোবাল বাধা তুলে নিতে আপনি নিচের ফর্মটি ব্যবহার করতে পারেন।',
	'globalblocking-whitelist' => 'গ্লোবাল বাধা স্থানীয় অবস্থা',
	'globalblocking-whitelist-legend' => 'স্থানীয় অবস্থা পরিবর্তন',
	'globalblocking-whitelist-reason' => 'কারণ:',
	'globalblocking-whitelist-status' => 'স্থানীয় অবস্থা:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} সাইটে গ্লোবাল বাধাটি নিষ্ক্রিয় করো',
	'globalblocking-whitelist-submit' => 'স্থানীয় অবস্থা পরিবর্তন',
	'globalblocking-whitelist-successsub' => 'স্থানীয় অবস্থা সফলভাবে পরিবর্তিত হয়েছে',
	'globalblocking-logentry-expiry' => 'মেয়াদ উত্তীর্ণের সময় $1',
	'globalblocking-logentry-noexpiry' => 'কোনো মেয়াদ উত্তীর্ণের সময় ঠিক করা হয়নি',
	'globalblocking-showlog' => 'এই ব্যবহারকারীকে পূর্বেও বাধা প্রদান করা হয়েছিলো।
তথ্যসূত্র হিসেবে তাই পূর্বের বাধাদানের লগটি নিচে প্রদর্শন করা হচ্ছে:',
	'globalblocklist' => 'গ্লোবালি বাধা বলবৎ রয়েছে এমন আইপি ঠিকানাসমূহের তালিকা',
	'globalblock' => 'একটি আইপি ঠিকানাকে গ্লেবালি বাধা প্রদান করুন',
	'globalblockstatus' => 'গ্লোবাল বাধা স্থানীয় অবস্থা',
	'removeglobalblock' => 'একটি গ্লোবাল বাধা তুলে নাও',
	'right-globalblock' => 'গ্লোবাল বাধা তৈরি করো',
	'right-globalunblock' => 'গ্লোবাল বাধা তুলে নাও',
	'right-globalblock-whitelist' => 'স্থানীয়ভাবে গ্লোবাল বাধা নিষ্ক্রিয় করো',
	'right-globalblock-exempt' => 'গ্লোবাল বাধা বাইপাস করো',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'globalblocking-desc' => "[[Special:GlobalBlock|Posupl]] eo stankañ ar chomlec'hioù IP [[Special:GlobalBlockList|dre wikioù disheñvel]]",
	'globalblocking-block' => "Stankañ en un doare hollek ur chomlec'h IP",
	'globalblocking-modify-intro' => 'Gellout a rit implijout ar furmskrid evit kefluniañ ur stankadenn hollek.',
	'globalblocking-block-intro' => "Gellout a rit implijout ar bajenn-mañ evit stankañ ur chomlec'h IP war an holl wikioù.",
	'globalblocking-block-reason' => 'Abeg :',
	'globalblocking-block-otherreason' => 'Abegoù all/ouzhpenn :',
	'globalblocking-block-reasonotherlist' => 'Abeg all',
	'globalblocking-block-reason-dropdown' => '* Abegoù anavezet evit ar stankadenn
** Strob war meur a wiki
** Kammimplijoù war meur a wiki
** Vandalerezh',
	'globalblocking-block-edit-dropdown' => 'Kemmañ an abegoù stankañ dre ziouer',
	'globalblocking-block-expiry' => 'Termen :',
	'globalblocking-block-expiry-other' => 'Pad echuiñ all',
	'globalblocking-block-expiry-otherfield' => 'Amzervezh all :',
	'globalblocking-block-legend' => "Stankañ ur chomlec'h IP en un doare hollek",
	'globalblocking-block-options' => 'Dibarzhioù :',
	'globalblocking-ipaddress' => "Chomlec'h IP :",
	'globalblocking-ipbanononly' => 'Stankañ an implijerien dizanv hepken',
	'globalblocking-block-errors' => "C'hwitet eo ar stankadenn evit an {{PLURAL:$1|abeg|abegoù}} da-heul :",
	'globalblocking-block-ipinvalid' => "Direizh eo ar chomlec'h IP lakaet ($1).
Bezit war evezh, n'hallit ket lakaat anv un implijer !",
	'globalblocking-block-expiryinvalid' => 'Direizh eo an termen lakaet ($1).',
	'globalblocking-block-submit' => "Stankañ ar chomlec'h IP-mañ en un doare hollek",
	'globalblocking-modify-submit' => 'Kemmañ ar stankadenn hollek-mañ',
	'globalblocking-block-success' => "Stanket eo bet ar chomlec'h IP $1 war an holl raktresoù.",
	'globalblocking-modify-success' => 'Kemmet eo bet stankadenn hollek $1',
	'globalblocking-block-successsub' => 'Graet eo bet ar stankadenn hollek',
	'globalblocking-modify-successsub' => 'Kemmet eo bet ar stankadenn hollek',
	'globalblocking-block-alreadyblocked' => "Ar chomlec'h IP $1 a zo stanket en un doare hollek dija.
Gallout a rit diskwel ar stankadennoù e [[Special:GlobalBlockList|listenn ar stankadennoù hollek]],
pe kemm ar c'hefluniadur eus ar stankadennoù hag a zo, dre kinnig en-dro ar furmskrid.",
	'globalblocking-block-bigrange' => "Al lijorenn hoc'h eus spisaet ($1) a zo re vras evit bezañ stanket.
D'ar muiañ e c'helloc'h stankañ 65 536 chomlec'h (/16 lijorenn)",
	'globalblocking-list-intro' => "Setu aze roll ar stankadennoù hollek oberiat.
Lod anezho zo merket evel diweredekaet e lec'hioù zo : ar pezh a dalvez e vezont lakaet da dalvezout war lec'hiennoù all, hag ur merour lec'hel en deus dibabet diweredekaat anezho er wiki-mañ.",
	'globalblocking-list' => "Roll ar chomlec'hioù IP stanket en un doare hollek",
	'globalblocking-search-legend' => "Klask war-lerc'h ur stankadenn hollek",
	'globalblocking-search-ip' => "Chomlec'h IP :",
	'globalblocking-search-submit' => 'Klask stankadennoù',
	'globalblocking-list-ipinvalid' => "Direizh eo ar chomlec'h IP a glaskit evit ($1).
Mar plij lakait ur chomlec'h IP reizh.",
	'globalblocking-search-errors' => 'Mat eo bet ho klask evit an {{PLURAL:$1|abeg|abegoù}} da heul :',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') en deus stanket en un doare hollek [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => "a ya d'e dermen d'an $1",
	'globalblocking-list-anononly' => 'dizanv hepken',
	'globalblocking-list-unblock' => 'lemel',
	'globalblocking-list-whitelisted' => "diweredekaet en un doare lec'hel gant $1 : $2",
	'globalblocking-list-whitelist' => "statud lec'hel",
	'globalblocking-list-modify' => 'kemmañ',
	'globalblocking-list-noresults' => "N'eo ket stanket ar chomlec'h IP hoc'h eus goulennet.",
	'globalblocking-goto-block' => "Stankañ ur chomlec'h IP en un doare hollek",
	'globalblocking-goto-unblock' => 'Lemel kuit ur stankadenn hollek',
	'globalblocking-goto-status' => "Kemmañ statud lec'hel ur stankadenn hollek",
	'globalblocking-return' => 'Distreiñ da roll ar stankadennoù hollek',
	'globalblocking-notblocked' => "N'eo ket stanket en un doare hollek ar chomlec'h IP ($1) ho peus lakaet.",
	'globalblocking-unblock' => 'Lemel kuit ur stankadenn hollek',
	'globalblocking-unblock-ipinvalid' => "N'eo ket reizh ar chomlec'h IP hoc'h eus lakaet ($1).
Mar plij bezit war evezh, ne c'halloc'h ket lakaat anv un implijer !",
	'globalblocking-unblock-legend' => 'Lemel kuit ur stankadenn hollek',
	'globalblocking-unblock-submit' => 'Lemel kuit ar stankadenn hollek',
	'globalblocking-unblock-reason' => 'Abeg :',
	'globalblocking-unblock-unblocked' => "Lamet eo bet ervat ar stankadenn hollek niv. $2 a glot gant ar chomlec'h IP '''$1'''.",
	'globalblocking-unblock-errors' => "An dilammadenn eus ar stankadenn hollek en deus c'hwitet evit an {{PLURAL:$1|abeg|abegoù}} da-heul :",
	'globalblocking-unblock-successsub' => 'Lamet eo bet ar stankadenn hollek',
	'globalblocking-unblock-subtitle' => 'O lemel ar stankadenn hollek',
	'globalblocking-unblock-intro' => 'Gellout a rit implijout ar furmskrid-mañ evit dilemel ur stankadenn hollek.',
	'globalblocking-whitelist' => "Statud lec'hel ar stankadennoù hollek",
	'globalblocking-whitelist-notapplied' => "N'eus ket eus ar stankadennoù hollek war ar wiki-mañ,
dre-se ne c'hell ket bezañ kemmet statud lec'hel ar stankadenn hollek.",
	'globalblocking-whitelist-legend' => "Kemmañ ar statud lec'hel",
	'globalblocking-whitelist-reason' => 'Abeg :',
	'globalblocking-whitelist-status' => "Statud lec'hel :",
	'globalblocking-whitelist-statuslabel' => 'Diweredekaat ar stankadenn hollek-mañ war {{SITENAME}}',
	'globalblocking-whitelist-submit' => "Kemmañ ar statud lec'hel",
	'globalblocking-whitelist-whitelisted' => "Diweredekaet ho peus ar stankadenn hollek #$2 evit ar chomlec'h IP '''$1''' war {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Adgweredekaet ho peus ar stankadenn hollek #$2 evit ar chomlec'h IP '''$1''' war {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => "Kemmet eo bet ar statud lec'hel",
	'globalblocking-whitelist-nochange' => "N'hoc'h eus ket kemmet stad lec'hel ar stankadenn-se.
[[Special:GlobalBlockList|Distreiñ da roll ar stankadennoù hollek]].",
	'globalblocking-whitelist-errors' => "Ar c'hemm eus statud lec'hel ur stankadenn hollek en deus c'hwitet evit an {{PLURAL:$1|abeg|abegoù}} da-heul :",
	'globalblocking-whitelist-intro' => "Gallout a rit implijout ar furmskrid-mañ evit kemm statud lec'hel ur stankadenn hollek.
Mard eo diweredekaet ur stankadenn hollek er wiki-mañ, an implijerien gant ar chomlec'hioù IP merket a c'hello kemmañ d'un doare normal.
[[Special:GlobalBlockList|Mont en-dro e listenn ar stankadennoù hollek]].",
	'globalblocking-blocked' => "Stanket eo bet ho chomlec'h IP \$5 war an holl wikioù gant '''\$1''' (''\$2'').
An abeg a oa ''\"\$3\"''.
Stankadenn : ''\$4''.",
	'globalblocking-blocked-nopassreset' => "Ne c'hellit ket adderaouekaat gerioù-tremen implijerien dre ma 'z oc'h stanket en un doare hollek.",
	'globalblocking-logpage' => 'Marilh ar stankadennoù hollek',
	'globalblocking-logpagetext' => "Setu aze marilh ar stankadennoù hollek zo bet lakaet e plas ha lamet kuit er wiki-mañ.
Notit mat e c'hall ar stankadennoù hollek bezañ lakaet e plas pe dilamet war wikioù all, hag e c'hall ar stankadennoù hollek-se degas strafuilh war ar wiki-mañ.
Evit gwelet an holl stankadennoù oberiant evit ar poent e c'hallit mont da sellet ouzh [[Special:GlobalBlockList|roll ar stankadennoù hollek]].",
	'globalblocking-block-logentry' => 'en deus stanket [[$1]] en un doare hollek, gant ur pad termen a $2',
	'globalblocking-block2-logentry' => 'en deus stanket [[$1]] dre-vras ($2)',
	'globalblocking-unblock-logentry' => 'en deus tennet stankadenn hollek [[$1]]',
	'globalblocking-whitelist-logentry' => "en deus dilemet en un doare lec'hel stankadenn hollek [[$1]]",
	'globalblocking-dewhitelist-logentry' => "en deus adweredekaet en un doare lec'hel stankadenn hollek [[$1]]",
	'globalblocking-modify-logentry' => 'en deus kemmet stankadenn hollek [[$1]] ($2)',
	'globalblocking-logentry-expiry' => "a ya d'e dermen d'an $1",
	'globalblocking-logentry-noexpiry' => "n'eus bet resisaet deiziad termen ebet",
	'globalblocking-loglink' => "Stanket eo ar c'homlec'h IP $1 en un doare hollek ([[{{#Special:GlobalBlockList}}/$1|muioc'h a ditouroù]]).",
	'globalblocking-showlog' => "Stanket eo bet an implijer-mañ c'hoazh.
A-is emañ marilh ar stankadennoù :",
	'globalblocklist' => "Roll ar chomlec'hioù IP stanket en un doare hollek",
	'globalblock' => "Stankañ ur chomlec'h IP en un doare hollek",
	'globalblockstatus' => "Statud lec'hel ar stankadennoù hollek",
	'removeglobalblock' => 'Lemel ur stankadur hollek',
	'right-globalblock' => 'Stankañ implijerien en un doare hollek',
	'right-globalunblock' => 'Lemel ar stankadennoù hollek',
	'right-globalblock-whitelist' => "Diweredekaat en un doare lec'hel ar stankadennoù hollek",
	'right-globalblock-exempt' => 'Mont dreist ar stankadennoù hollek',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Omogućava]] da se IP adrese [[Special:GlobalBlockList|blokiraju na većem broju wikija]]',
	'globalblocking-block' => 'Globalno blokiranje IP adrese',
	'globalblocking-modify-intro' => 'Možete koristiti ovaj obrazac za izmjenu postavki globalne blokade.',
	'globalblocking-block-intro' => 'Možete koristiti ovu stranicu za blokiranje IP adrese na svim wikijima.',
	'globalblocking-block-reason' => 'Razlog:',
	'globalblocking-block-otherreason' => 'Ostali/dodatni razlog:',
	'globalblocking-block-reasonotherlist' => 'Ostali razlozi',
	'globalblocking-block-reason-dropdown' => '* Uobičajeni razlozi blokiranja
** Spamovi na više wikija
** Zloupotreba na više wikiija
** Vandalizam',
	'globalblocking-block-edit-dropdown' => 'Uredi razloge blokiranja',
	'globalblocking-block-expiry' => 'Ističe:',
	'globalblocking-block-expiry-other' => 'Ostali vremenski period',
	'globalblocking-block-expiry-otherfield' => 'Ostali period:',
	'globalblocking-block-legend' => 'Blokiranje IP adrese globalno',
	'globalblocking-block-options' => 'Opcije:',
	'globalblocking-block-errors' => 'Vaše blokiranje je bilo bez uspjeha, iz {{PLURAL:$1|slijedećeg razloga|slijedećih razloga}}:',
	'globalblocking-block-ipinvalid' => 'IP adresa ($1) koju ste unijeli nije validna.
Zapamtite da ovdje ne možete unijeti korisničko ime!',
	'globalblocking-block-expiryinvalid' => 'Period isticanja koji ste unijeli ($1) nije valjan.',
	'globalblocking-block-submit' => 'Globalno blokiraj ovu IP adresu',
	'globalblocking-modify-submit' => 'Izmijeni ovu globalnu blokadu',
	'globalblocking-block-success' => 'IP adresa $1 je uspješno blokirana na svim projektima.',
	'globalblocking-modify-success' => 'Globalna blokada na $1 je uspješno izmijenjena',
	'globalblocking-block-successsub' => 'Globalno blokiranje uspješno',
	'globalblocking-modify-successsub' => 'Globalna blokada uspješno izmijenjena',
	'globalblocking-block-alreadyblocked' => 'IP adresa $1 je već blokirana globalno.
Možete pregledati postojeće blokade na [[Special:GlobalBlockList|spisku globalnih blokada]] ili izmijeniti postavke postojećih blokada putem ponovnog slanja ovog obrasca.',
	'globalblocking-block-bigrange' => 'Okvir koji ste odredili ($1) je prevelik za blokiranje.
Možete blokirati, najviše, 65.536 adresa (1/16 okvira)',
	'globalblocking-list-intro' => 'Ovo je spisak svih globalnih blokada koje su trenutni na snazi.
Neke blokade su označene kao lokalno onemogućene: to znači da se one primjenjuju na drugim sajtovima, ali je lokalni administrator odlučio da ih ukloni na ovoj wiki.',
	'globalblocking-list' => 'Spisak globalno blokiranih IP adresa',
	'globalblocking-search-legend' => 'Pretraga globalnih blokada',
	'globalblocking-search-ip' => 'IP adresa:',
	'globalblocking-search-submit' => 'Pretraga blokada',
	'globalblocking-list-ipinvalid' => 'IP adresa koju ste tražili ($1) nije validna.
Molimo Vas unesite validnu IP adresu.',
	'globalblocking-search-errors' => 'Vaša pretraga nije bila uspješna iz {{PLURAL:$1|slijedećeg razloga|slijedećih razloga}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">Korisnik '''\$2'''</span> (sa ''\$3'') je globalno blokirao [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'istječe $1',
	'globalblocking-list-anononly' => 'samo anonimni korisnici',
	'globalblocking-list-unblock' => 'ukloni',
	'globalblocking-list-whitelisted' => 'lokalno onemogućena od strane $1: $2',
	'globalblocking-list-whitelist' => 'lokalni status',
	'globalblocking-list-modify' => 'izmijeni',
	'globalblocking-list-noresults' => 'Zahtijevana IP adresa nije blokirana.',
	'globalblocking-goto-block' => 'Globalno blokirajte IP adrese',
	'globalblocking-goto-unblock' => 'Ukloni globalnu blokadu',
	'globalblocking-goto-status' => 'Promijenite lokalni status globalne blokade',
	'globalblocking-return' => 'Vrati se na spisak globalnih blokada',
	'globalblocking-notblocked' => 'IP adresa ($1) koju ste unijeli nije blokirana globalno.',
	'globalblocking-unblock' => 'Ukloni globalnu blokadu',
	'globalblocking-unblock-ipinvalid' => 'IP adresa ($1) koju ste unijeli nije validna.
Zapamtite da ovdje ne možete unijeti korisničko ime!',
	'globalblocking-unblock-legend' => 'Uklanjanje globalne blokade',
	'globalblocking-unblock-submit' => 'Ukloni globalnu blokadu',
	'globalblocking-unblock-reason' => 'Razlog:',
	'globalblocking-unblock-unblocked' => "Uspješno ste uklonili globalnu blokadu #$2 IP adrese '''$1'''",
	'globalblocking-unblock-errors' => 'Vaše uklanjanje globalne blokade je bilo neuspješno iz {{PLURAL:$1|slijedećeg razloga|slijedećih razloga}}:',
	'globalblocking-unblock-successsub' => 'Globalna blokada uspješno uklonjena',
	'globalblocking-unblock-subtitle' => 'Uklanjanje globalne blokade',
	'globalblocking-unblock-intro' => 'Možete koristiti ovaj obrazac da uklonite globalnu blokadu.',
	'globalblocking-whitelist' => 'Lokalno stanje globalnih blokada',
	'globalblocking-whitelist-notapplied' => 'Globalne blokade se ne primjenjuju na ovoj wiki,
tako da se lokalni status globalnih blokada ne može mijenjati.',
	'globalblocking-whitelist-legend' => 'Promjena lokalnog statusa',
	'globalblocking-whitelist-reason' => 'Razlog:',
	'globalblocking-whitelist-status' => 'Lokalni status:',
	'globalblocking-whitelist-statuslabel' => 'Onemogući ovu globalnu blokadu na {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Promjena lokalnog statusa',
	'globalblocking-whitelist-whitelisted' => "Uspješno ste uklonili globalnu blokadu #$2 IP adrese '''$1''' na {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Uspješno se ponovno omogućili globalnu blokadu #$2 IP adrese '''$1''' na {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Lokalni status uspješno promijenjen',
	'globalblocking-whitelist-nochange' => 'Niste napravili izmjene lokalnog statusa ove blokade.
[[Special:GlobalBlockList|Povratak na spisak globalnih blokada]].',
	'globalblocking-whitelist-errors' => 'Vaša izmjena lokalnog statusa globalne blokade nije bila izmjena iz {{PLURAL:$1|slijedećeg razloga|slijedećih razloga}}:',
	'globalblocking-whitelist-intro' => 'Možete koristiti ovaj obrazac za uređivanje lokalnog statusa globalne blokade.
Ako je globalna blokada onemogućena na ovoj wiki, korisnici na blokiranoj IP adresi će biti u mogućnosti na normalno uređuju.
[[Special:GlobalBlockList|Povratak na spisak globalnih blokada]].',
	'globalblocking-blocked' => "Vaša IP adresa je blokirana na svim wikijima od strane '''\$1''' (sa ''\$2'').
Naveden je razlog ''\"\$3\"''.
Ova blokada ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Ne možete poništiti korisničku šifru jer ste globalno blokirani.',
	'globalblocking-logpage' => 'Zapis globalnih blokada',
	'globalblocking-logpagetext' => 'Ovo je zapis globalnih blokada koji su napravljene i uklonjene na ovoj wiki.
Treba obratiti pažnju da se globalne blokade mogu napraviti i ukloniti na drugim wikijima i da te globalne blokade utjecati na ovu wiki.
Da bi ste pregledali aktivne globalne blokade, kliknite na [[Special:GlobalBlockList|spisak globalnih blokada]].',
	'globalblocking-block-logentry' => 'je globalno blokirao [[$1]] sa vremenom isticanja blokade od $2',
	'globalblocking-block2-logentry' => 'globalno blokiran [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'je uklonjena globalna blokada za [[$1]]',
	'globalblocking-whitelist-logentry' => 'onemogući globalnu blokadu [[$1]] lokalno',
	'globalblocking-dewhitelist-logentry' => 'ponovno omogućena globalna blokada lokalno na [[$1]]',
	'globalblocking-modify-logentry' => 'izmijenjena globalna blokada [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'ističe $1',
	'globalblocking-logentry-noexpiry' => 'nije postavljeno vrijeme isticanja',
	'globalblocking-loglink' => 'IP adresa $1 je blokirana globalno ([[{{#Special:GlobalBlockList}}/$1|svi detalji]]).',
	'globalblocking-showlog' => 'Ova IP adresa je ranije bila blokirana.
Zapisnik blokiranja je naveden ispod kao referenca:',
	'globalblocklist' => 'Spisak globalno blokiranih IP adresa',
	'globalblock' => 'Globalno blokiranje IP adrese',
	'globalblockstatus' => 'Lokalni status globalnih blokada',
	'removeglobalblock' => 'Ukloni globalnu blokadu',
	'right-globalblock' => 'Pravljenje globalnih blokada',
	'right-globalunblock' => 'Uklanjanje globalnih blokada',
	'right-globalblock-whitelist' => 'Onemogućavanje globalnih blokada na lokalnom nivou',
	'right-globalblock-exempt' => 'Zaobilaženje globalnih blokada',
);

/** Catalan (Català)
 * @author Aleator
 * @author Paucabot
 * @author SMP
 * @author Solde
 * @author Toniher
 */
$messages['ca'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permet]] [[Special:GlobalBlockList|bloquejar]] les adreces IP de diversos wikis',
	'globalblocking-block' => 'Bloqueja una adreça IP globalment',
	'globalblocking-modify-intro' => 'Podeu usar aquest formulari per canviar els paràmetres del bloqueig global.',
	'globalblocking-block-intro' => 'Podeu usar aquesta pàgina per bloquejar una adreça IP a tots els wikis.',
	'globalblocking-block-reason' => 'Motiu:',
	'globalblocking-block-otherreason' => 'Motius diferents o addicionals:',
	'globalblocking-block-reasonotherlist' => 'Altres motius',
	'globalblocking-block-reason-dropdown' => '* Motius habituals de bloqueig
** Spam crosswiki
** Abusos crosswiki
** Vandalisme',
	'globalblocking-block-edit-dropdown' => 'Edita els motius per a blocar',
	'globalblocking-block-expiry' => 'Caducitat:',
	'globalblocking-block-expiry-other' => "Una altra data d'expiració",
	'globalblocking-block-expiry-otherfield' => 'Una altra durada:',
	'globalblocking-block-legend' => 'Bloqueja aquesta adreça IP globalment',
	'globalblocking-block-options' => 'Opcions:',
	'globalblocking-ipaddress' => 'Adreça IP:',
	'globalblocking-ipbanononly' => 'Bloca només els usuaris anònims',
	'globalblocking-block-errors' => "El bloqueig no s'ha completat correctament, per {{PLURAL:$1|la següent raó|les següents raons}}:",
	'globalblocking-block-ipinvalid' => "L'adreça IP ($1) introduïda no és vàlida.
Recordau que no podeu introduir un nom d'usuari!",
	'globalblocking-block-expiryinvalid' => 'La caducitat introduïda ($1) no és vàlida.',
	'globalblocking-block-submit' => 'Bloqueja aquesta adreça IP globalment',
	'globalblocking-modify-submit' => 'Modifica aquest bloqueig global',
	'globalblocking-block-success' => "L'adreça IP $1 ha estat blocada a tots els projectes de forma satisfactòria.",
	'globalblocking-modify-success' => "El bloqueig global de $1 s'ha modificat correctament.",
	'globalblocking-block-successsub' => 'Bloqueig global amb èxit',
	'globalblocking-modify-successsub' => 'Bloqueig global modificat amb èxit',
	'globalblocking-block-alreadyblocked' => "L'adreça IP $1 ja està bloquejada globalment.
Podeu veure el bloqueig a la [[Special:GlobalBlockList|llista de bloquejos globals]],
o modificar els paràmetres del bloqueig reenviant aquest formulari.",
	'globalblocking-block-bigrange' => 'El rang que heu especificat ($1) és massa gros per bloquejar-lo.
Podeu bloquejar, com a màxim, 65,536 addreces (rangs /16)',
	'globalblocking-list-intro' => 'Aquesta és una llista de tots els bloquejos globals que actualment estan en vigor.
Alguns bloquejos estan marcats com a desactivats localment: això vol dir que estan activats a altres llocs web però que un administrador local ha decidit desactivar en aquest wiki.',
	'globalblocking-list' => 'Llista de les adreces IP bloquejades globalment',
	'globalblocking-search-legend' => 'Cerca bloquejos globals',
	'globalblocking-search-ip' => 'Adreça IP:',
	'globalblocking-search-submit' => 'Cerca bloquejos',
	'globalblocking-list-ipinvalid' => "L'adreça IP que busqueu ($1) no és vàlida.
Entreu, si us plau, una adreça IP vàlida.",
	'globalblocking-search-errors' => 'La vostra recerca ha resultat infructuosa {{PLURAL:$1|pel següent motiu|pels següents motius}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') ha blocat globalment l'usuari [[Special:Contributions/\$4|\$4]] (''\$5'')",
	'globalblocking-list-expiry' => 'venç el $1',
	'globalblocking-list-anononly' => 'només anònims',
	'globalblocking-list-unblock' => 'Suprimeix',
	'globalblocking-list-whitelisted' => 'desactivat localment per $1: $2',
	'globalblocking-list-whitelist' => 'estat local',
	'globalblocking-list-modify' => 'modifica',
	'globalblocking-list-noresults' => 'La adreça IP demanada no està bloquejada.',
	'globalblocking-goto-block' => 'Bloqueja globalment una adreça IP',
	'globalblocking-goto-unblock' => 'Canceŀla un bloqueig global',
	'globalblocking-goto-status' => "Canvi de l'estat local d'un blocatge global",
	'globalblocking-return' => 'Torna a la llista de bloquejos globals',
	'globalblocking-notblocked' => "L'adreça IP que heu introduït ($1) no està bloquejada globalment.",
	'globalblocking-unblock' => 'Canceŀla un bloqueig global',
	'globalblocking-unblock-ipinvalid' => "L'adreça IP ($1) introduïda no és vàlida.
Recordau que no podeu introduir un nom d'usuari!",
	'globalblocking-unblock-legend' => 'Canceŀla un bloqueig global',
	'globalblocking-unblock-submit' => 'Canceŀla un bloqueig global',
	'globalblocking-unblock-reason' => 'Motiu:',
	'globalblocking-unblock-unblocked' => "Heu eliminat el bloqueig global #$2 a l'adreça IP '''$1'''",
	'globalblocking-unblock-errors' => 'La vostra eliminació de bloqueig global ha estat infructuosa, {{PLURAL:$1|pel següent motiu|pels següents motius}}:',
	'globalblocking-unblock-successsub' => "S'ha canceŀlat correctament el bloqueig global",
	'globalblocking-unblock-subtitle' => "S'està canceŀlant el bloqueig global",
	'globalblocking-unblock-intro' => 'Podeu usar aquest formulari per a eliminar un bloqueig global.',
	'globalblocking-whitelist' => 'Estat local dels bloquejos globals',
	'globalblocking-whitelist-notapplied' => "Els bloquejos globals no s'apliquen a aquesta wiki,
així que l'estat local dels bloquejos globals no pot ser modificat.",
	'globalblocking-whitelist-legend' => "Canvia l'estat local",
	'globalblocking-whitelist-reason' => 'Motiu:',
	'globalblocking-whitelist-status' => 'Estat local:',
	'globalblocking-whitelist-statuslabel' => 'Inhabilita aquest bloqueig global a {{SITENAME}}',
	'globalblocking-whitelist-submit' => "Canvia l'estat local",
	'globalblocking-whitelist-whitelisted' => "Heu desactivat el bloqueig global #$2 de l'adreça IP '''$1''' al projecte {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Heu reactivat el bloqueig global #$2 de l'adreça IP '''$1''' al projecte {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Estat local canviat satisfactòriament',
	'globalblocking-whitelist-nochange' => "No heu fet cap canvi a l'estat local d'aquest bloqueig.
[[Special:GlobalBlockList|Retorna a la llista de bloqueigs globals]].",
	'globalblocking-whitelist-errors' => "El vostre canvi local de l'estat del bloqueig global ha estat infructuós {{PLURAL:$1|pel següent motiu|pels següents motius}}:",
	'globalblocking-whitelist-intro' => "Podeu fer servir aquest formulari per a editar l'estat local d'un bloqueig global.
Si un bloqueig global està desactivat en aquest wiki, els usuaris de l'adreça IP afectada podran editar normalment.
[[Special:GlobalBlockList|Retorna a la llista de bloqueigs globals]].",
	'globalblocking-blocked' => "La vostra adreça IP $5 ha estat blocada en tots els wikis per l'usuari '''$1''' (''$2'').
El motiu donat és: $3.
Aquest blocatge té la data d'expiració següent: ''$4''.",
	'globalblocking-blocked-nopassreset' => "No podeu reinicialitzar les contrasenyes d'usuari perquè estau bloquejat globalment.",
	'globalblocking-logpage' => 'Registre de bloquejos globals',
	'globalblocking-logpagetext' => "Això és un registre dels bloquejos globals que s'han fet o s'han eliminat en aquest wiki.
Cal notar que els bloquejos globals es poden aplicar i eliminar des d'altres wikis, i aquests bloquejos globals poden afectar aquest wiki.
Per a veure tots els bloquejos globals actius, vegeu la [[Special:GlobalBlockList|llista de bloquejos globals]].",
	'globalblocking-block-logentry' => "[[$1]] blocat globalment amb una data d'expiració de $2",
	'globalblocking-block2-logentry' => 'Bloquejat globalment [[$1]] ($2)',
	'globalblocking-unblock-logentry' => "S'ha canceŀlat el bloqueig global de [[$1]]",
	'globalblocking-whitelist-logentry' => "S'ha inhabilitat localment el bloqueig global de [[$1]]",
	'globalblocking-dewhitelist-logentry' => "S'ha rehabilitat localment el bloqueig global de [[$1]]",
	'globalblocking-modify-logentry' => "S'ha modificat el bloqueig global de [[$1]] ($2)",
	'globalblocking-logentry-expiry' => 'Venç el $1',
	'globalblocking-logentry-noexpiry' => "No s'ha especificat la caducitat",
	'globalblocking-loglink' => "L'adreça IP $1 està bloquejada globalment ([[{{#Special:GlobalBlockList}}/$1|detalls]]).",
	'globalblocking-showlog' => 'Aquesta adreça IP ha estat prèviament bloquejada.
Per més detalls, a continuació es mostra el registre de bloquejos:',
	'globalblocklist' => 'Llista de les adreces IP bloquejades globalment',
	'globalblock' => 'Bloqueja una adreça IP globalment',
	'globalblockstatus' => 'Estat local dels bloquejos globals',
	'removeglobalblock' => 'Canceŀla el bloqueig global',
	'right-globalblock' => 'Fer blocatges globals',
	'right-globalunblock' => 'Canceŀlar bloquejos globals',
	'right-globalblock-whitelist' => 'Desactivar a nivell local els blocatges globals',
	'right-globalblock-exempt' => 'Eludir els blocatges globals',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'globalblocking-block-reasonotherlist' => 'Кхин бахьан',
	'globalblocking-list' => 'МогIам, сацийна массанхьара IP-долу меттиг',
	'globalblocking-unblock-reason' => 'Бахьан:',
	'globalblocklist' => 'МогIам, массанхьа сацийна IP-долу меттиг',
	'globalblockstatus' => 'Хlоттайелчаьрца долу хьал, масхьара сацорца',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'globalblocking-block-reason' => 'هۆکار:',
	'globalblocking-block-reasonotherlist' => 'هۆکاری دیکە',
	'globalblocking-unblock-reason' => 'هۆکار:',
	'globalblocking-whitelist-reason' => 'هۆکار:',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Mormegil
 */
$messages['cs'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Umožňuje]] blokovat IP adresy [[Special:GlobalBlockList|na více wiki současně]]',
	'globalblocking-block' => 'Globálně zablokovat IP adresu',
	'globalblocking-modify-intro' => 'Pomocí tohoto formuláře můžete změnit nastavení globálního zablokování.',
	'globalblocking-block-intro' => 'Pomocí této stránky můžete některou IP adresu zablokovat na všech wiki.',
	'globalblocking-block-reason' => 'Důvod:',
	'globalblocking-block-otherreason' => 'Jiný/další důvod:',
	'globalblocking-block-reasonotherlist' => 'Jiný důvod',
	'globalblocking-block-reason-dropdown' => '* Časté důvody blokování
** Spamování na více wiki
** Narušování více wiki
** Vandalismus',
	'globalblocking-block-edit-dropdown' => 'Editace seznamu důvodů zablokování',
	'globalblocking-block-expiry' => 'Čas vypršení:',
	'globalblocking-block-expiry-other' => 'Jiná délka bloku',
	'globalblocking-block-expiry-otherfield' => 'Jiný čas vypršení:',
	'globalblocking-block-legend' => 'Globálně zablokovat IP adresu',
	'globalblocking-block-options' => 'Možnosti:',
	'globalblocking-ipaddress' => 'IP adresa:',
	'globalblocking-ipbanononly' => 'Zablokovat pouze anonymní uživatele',
	'globalblocking-block-errors' => 'Blokování se {{PLURAL:$1|z následujícího důvodu|z následujících důvodů}} nezdařilo:',
	'globalblocking-block-ipinvalid' => 'Vámi zadaná IP adresa ($1) je neplatná.
Uvědomte si, že nemůžete zadat uživatelské jméno!',
	'globalblocking-block-expiryinvalid' => 'Vámi zadaný čas vypršení ($1) je neplatný.',
	'globalblocking-block-submit' => 'Globálně zablokovat tuto IP adresu',
	'globalblocking-modify-submit' => 'Změnit toto globální zablokování',
	'globalblocking-block-success' => 'IP adresa $1 byla na všech projektech úspěšně zablokována.',
	'globalblocking-modify-success' => 'Globální zablokování $1 bylo úspěšně změněno.',
	'globalblocking-block-successsub' => 'Úspěšné globální zablokování',
	'globalblocking-modify-successsub' => 'Globální zablokování úspěšně změněno',
	'globalblocking-block-alreadyblocked' => 'IP adresa $1 již je globálně zablokována.
Existující zablokování si můžete prohlédnout na [[Special:GlobalBlockList|seznamu globálních bloků]], nastavení stávajícího bloku můžete změnit opětovným odesláním tohoto formuláře.',
	'globalblocking-block-bigrange' => 'Nelze zablokovat vámi uvedený rozsah ($1), protože je příliš velký. Můžete zablokovat maximálně 65&nbsp;535 adres (rozsah /16).',
	'globalblocking-list-intro' => 'Toto je seznam všech platných globálních zablokování. Některá zablokování jsou označena jako lokálně zneplatněná: to znamená, že působí na ostatních wiki, ale místní správce se rozhodl je na této wiki vypnout.',
	'globalblocking-list' => 'Seznam globálně zablokovaných IP adres',
	'globalblocking-search-legend' => 'Hledání globálního bloku',
	'globalblocking-search-ip' => 'IP adresa:',
	'globalblocking-search-submit' => 'Hledat blok',
	'globalblocking-list-ipinvalid' => 'IP adresa ($1), kterou jste chtěli vyhledat, není platná.
Zadejte platnou IP adresu.',
	'globalblocking-search-errors' => 'Vaše hledání bylo z {{PLURAL:$1|následujícího důvodu|následujících důvodů}} neúspěšné:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') globálně blokuje [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'vyprší $1',
	'globalblocking-list-anononly' => 'jen anonymové',
	'globalblocking-list-unblock' => 'uvolnit',
	'globalblocking-list-whitelisted' => 'lokálně zneplatněno uživatelem $1: $2',
	'globalblocking-list-whitelist' => 'lokální stav',
	'globalblocking-list-modify' => 'změnit',
	'globalblocking-list-noresults' => 'Uvedená IP adresa není zablokována.',
	'globalblocking-goto-block' => 'Globálně zablokovat IP adresu',
	'globalblocking-goto-unblock' => 'Globálně odblokovat',
	'globalblocking-goto-status' => 'Změnit místní stav globálního zablokování',
	'globalblocking-return' => 'Návrat na seznam globálních blokování',
	'globalblocking-notblocked' => 'Vámi zadaná IP adresa ($1) není globálně zablokovaná.',
	'globalblocking-unblock' => 'Globální odblokování',
	'globalblocking-unblock-ipinvalid' => 'Vámi zadaná IP adresa ($1) je neplatná.
Uvědomte si, že nemůžete zadat uživatelské jméno!',
	'globalblocking-unblock-legend' => 'Uvolnění globálního zablokování',
	'globalblocking-unblock-submit' => 'Globálně odblokovat',
	'globalblocking-unblock-reason' => 'Důvod:',
	'globalblocking-unblock-unblocked' => "Úspěšně jste uvolnili globální blokování ID #$2 na IP adresu '''$1'''",
	'globalblocking-unblock-errors' => 'Váš pokus o odblokování nebyl úspěšný z {{PLURAL:$1|následujícího důvodu|následujících důvodů|následujících důvodů}}:',
	'globalblocking-unblock-successsub' => 'Odblokování proběhlo úspěšně',
	'globalblocking-unblock-subtitle' => 'Uvolňuje se globální blokování',
	'globalblocking-unblock-intro' => 'Tímto formulářem je možno uvolnit globální blokování.',
	'globalblocking-whitelist' => 'Lokální nastavení globálního zablokování',
	'globalblocking-whitelist-notapplied' => 'Na této wiki se neaplikují globální zablokování, takže nelze měnit jejich lokální nastavení.',
	'globalblocking-whitelist-legend' => 'Změnit lokální nastavení',
	'globalblocking-whitelist-reason' => 'Důvod:',
	'globalblocking-whitelist-status' => 'Lokální stav:',
	'globalblocking-whitelist-statuslabel' => 'Zneplatnit toto globální blokování na {{GRAMMAR:6sg|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Změnit místní stav',
	'globalblocking-whitelist-whitelisted' => "Úspěšně jste na {{grammar:6sg|{{SITENAME}}}} zneplatnili globální zablokování #$2 IP adresy '''$1'''.",
	'globalblocking-whitelist-dewhitelisted' => "Úspěšně jste na {{grammar:6sg|{{SITENAME}}}} zrušili výjimku z globálního zablokování #$2 IP adresy '''$1'''.",
	'globalblocking-whitelist-successsub' => 'Lokální stav byl úspěšně upraven',
	'globalblocking-whitelist-nochange' => 'Na stavu tohoto zablokování jste nic nezměnili. [[Special:GlobalBlockList|Návrat na seznam globálních blokování.]]',
	'globalblocking-whitelist-errors' => 'Z {{PLURAL:$1|následujícího důvodu|následujících důvodů}} se nepodařilo změnit lokální stav globálního zablokování:',
	'globalblocking-whitelist-intro' => 'Pomocí tohoto formuláře můžete změnit místní stav globálního zablokování.
Pokud bude globální blok na této wiki zrušen, budou moci uživatelé na dotčené IP adrese normálně editovat.
[[Special:GlobalBlockList|Návrat na seznam globálních bloků]].',
	'globalblocking-blocked' => "Vaše IP adresa $5 byla globálně na všech wiki zablokována uživatelem '''$1''' (''$2'').
Udaným důvodem bylo ''„$3“''.
Zablokování platí ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Nemůžete žádat o zaslání nového hesla, protože jste globálně {{GENDER:|zablokován|zablokována|zablokován}}.',
	'globalblocking-logpage' => 'Kniha globálních zablokování',
	'globalblocking-logpagetext' => 'Toto je kniha globální blokování a jejich uvolnění provedených na této wiki. 
Globální blokování lze provést i na jiných wiki a i ty ovlivňují blokování na této wiki. 
Všechny aktivní globální blokování naleznete na [[Special:GlobalBlockList|seznamu globálně blokovaných IP adres]].',
	'globalblocking-block-logentry' => 'globálně blokuje [[$1]] s časem vypršení $2',
	'globalblocking-block2-logentry' => 'globálně blokuje [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'globálně odblokovává [[$1]]',
	'globalblocking-whitelist-logentry' => 'lokálně zneplatnil globální zablokování [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'zrušil lokální výjimku globálního zablokování [[$1]]',
	'globalblocking-modify-logentry' => 'změnil globální zablokování [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'vyprší $1',
	'globalblocking-logentry-noexpiry' => 'bez vypršení',
	'globalblocking-loglink' => 'IP adresa $1 je globálně zablokována ([[{{#Special:GlobalBlockList}}/$1|podrobnosti]]).',
	'globalblocking-showlog' => 'Tato IP adresa byla dříve blokována.
Zde je pro přehled zobrazen výpis z knihy zablokování:',
	'globalblocklist' => 'Seznam globálně blokovaných IP adres',
	'globalblock' => 'Globálně zablokovat IP adresu',
	'globalblockstatus' => 'Místní stav globálního blokování',
	'removeglobalblock' => 'Odstranit globální zablokování',
	'right-globalblock' => 'Globální blokování',
	'action-globalblock' => 'globálně blokovat',
	'right-globalunblock' => 'Rušení globálních blokování',
	'action-globalunblock' => 'rušit globální blokování',
	'right-globalblock-whitelist' => 'Definování výjimek z globálního zablokování',
	'action-globalblock-whitelist' => 'definovat výjimky z globálního zablokování',
	'right-globalblock-exempt' => 'Obcházení globálního blokování',
	'action-globalblock-exempt' => 'obcházet globální blokování',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 * @author Pwyll
 */
$messages['cy'] = array(
	'globalblocking-desc' => 'Yn [[Special:GlobalBlock|galluogi]] cyfeiriadau IP i gael eu [[Special:GlobalBlockList|blocio ar sawl wici gwahanol]]',
	'globalblocking-block' => 'Blocio cyfeiriad IP yn fyd-eang',
	'globalblocking-modify-intro' => "Gallwch ddefnyddio'r ffurflen hon i newid gosodiadau bloc byd-eang.",
	'globalblocking-block-intro' => "Gallwch ddefnyddio'r dudalen hon i flocio cyfeiriad IP ar bob wici.",
	'globalblocking-block-reason' => 'Rheswm:',
	'globalblocking-block-otherreason' => 'Rheswm arall/ychwanegol:',
	'globalblocking-block-reasonotherlist' => 'Rheswm arall',
	'globalblocking-block-reason-dropdown' => '* Rhesymau cyffredin dros flocio
** Spamio trawswici
** Camddefnydd trawswici
** Fandaliaeth',
	'globalblocking-block-edit-dropdown' => 'Golygu rhesymau dros flocio',
	'globalblocking-block-expiry' => 'I ddod i ben am/wedi:',
	'globalblocking-block-expiry-other' => 'Amser darfod gwahanol',
	'globalblocking-block-expiry-otherfield' => 'Cyfnod arall:',
	'globalblocking-block-legend' => 'Blocio cyfeiriad IP yn fyd-eang',
	'globalblocking-block-options' => 'Dewisiadau:',
	'globalblocking-ipaddress' => 'Cyfeiriad IP:',
	'globalblocking-ipbanononly' => 'Blocio defnyddwyr anhysbys yn unig',
	'globalblocking-block-errors' => 'Roedd eich bloc yn aflwyddiannus, oherwydd y {{PLURAL:$1|rheswm|rhesymau}} canlynol:',
	'globalblocking-block-ipinvalid' => "Mae'r cyfeiriad IP ($1) a nodwyd gennych yn annilys.
Noder nad oes modd defnyddio enw defnyddiwr os gwelwch yn dda!",
	'globalblocking-block-submit' => "Blocio'r cyfeiriad IP hwn yn fyd-eang",
	'globalblocking-modify-submit' => "Addasu'r bloc byd-eang hwn",
	'globalblocking-block-success' => "Mae cyfeiriad IP $1 wedi'i flocio'n llwyddiannus ar bob prosiect.",
	'globalblocking-modify-success' => "Mae'r bloc byd-eang ar $1 wedi'i addasu'n llwyddiannus.",
	'globalblocking-block-successsub' => 'Bloc byd-eang llwyddiannus',
	'globalblocking-modify-successsub' => 'Addaswyd y bloc byd-eang yn llwyddiannus',
	'globalblocking-block-alreadyblocked' => "Mae'r cyfeiriad IP $1 wedi'i flocio'n fyd-eang eisoes.
Gallwch weld y bloc sy'n bodoli eisoes ar [[Special:GlobalBlockList|y rhestr o flociau byd-eang]], neu addasu gosodiadau y bloc hwnnw trwy ail-gyflwyno'r ffurflen hon.",
	'globalblocking-block-bigrange' => "Mae'r ystod a nodwyd gennych ($1) yn rhy fawr i'w flocio.
Gallwch flocio uchafswm o 65,536 o gyfeiriadau (/ystod)",
	'globalblocking-list-intro' => "Dyma restr o'r holl flociau byd-eang sy'n weithredol ar hyn o bryd.
Nodir rhai blociau fel rhai a analluwyd yn lleol: golyga hyn eu bod yn weithredol ar safleoedd eraill, ond bod gweinyddwr lleol wedi penderfynu eu analluogi ar y wici hwn.",
	'globalblocking-list' => 'Rhestr o gyfeiriadau IP a flociwyd yn fyd-eang',
	'globalblocking-search-legend' => 'Chwilio am floc byd-eang',
	'globalblocking-search-ip' => 'Cyfeiriad IP:',
	'globalblocking-search-submit' => 'Chwilio am flociau',
	'globalblocking-list-ipinvalid' => "Mae'r cyfeiriad IP roeddech wedi chwilio amdano ($1) yn annilys.
Nodwch gyfeiriad IP dilys os gwelwch yn dda.",
	'globalblocking-search-errors' => 'Roedd eich chwiliad yn aflwyddiannus, am y {{PLURAL:$1|rheswm|rhesymau}} canlynol:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') blociwyd yn fyd-eang [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'yn dod i ben am $1',
	'globalblocking-list-anononly' => 'anhysbys yn unig',
	'globalblocking-list-unblock' => 'tynnu',
	'globalblocking-list-whitelisted' => 'analluogwyd yn lleol gan $1, $2',
	'globalblocking-list-whitelist' => 'statws lleol',
	'globalblocking-list-modify' => 'addasu',
	'globalblocking-list-noresults' => "Nid yw cyfeiriad IP yr ymholiad wedi'i rwystro.",
	'globalblocking-goto-block' => 'Blocio cyfeiriad IP yn fyd-eang',
	'globalblocking-unblock-reason' => 'Rheswm:',
	'globalblocking-whitelist-legend' => 'Newid y statws lleol',
	'globalblocking-whitelist-reason' => 'Rheswm:',
	'globalblocking-whitelist-status' => 'Statws lleol:',
	'globalblocking-whitelist-submit' => 'Newid y statws lleol',
	'globalblocking-logpage' => 'Lòg blocio cydwici',
);

/** Danish (Dansk)
 * @author Masz
 * @author Peter Alberti
 * @author Sarrus
 * @author Tjernobyl
 */
$messages['da'] = array(
	'globalblocking-block' => 'Bloker en IP-adresse globalt',
	'globalblocking-modify-intro' => 'Du kan bruge denne formular til at ændre indstillingerne for en global blokkering',
	'globalblocking-block-intro' => 'Du kan bruge denne side til at blokere en IP-adresse på alle wikier.',
	'globalblocking-block-reason' => 'Begrundelse:',
	'globalblocking-block-otherreason' => 'Anden/uddybende begrundelse:',
	'globalblocking-block-reasonotherlist' => 'Anden grund',
	'globalblocking-block-reason-dropdown' => '* Normale blokeringsbegrundelser
** Crosswikispamming
** Crosswikimisbrug
** Hærværk',
	'globalblocking-block-edit-dropdown' => 'Rediger blokeringsbegrundelser',
	'globalblocking-block-expiry' => 'Udløber:',
	'globalblocking-block-legend' => 'Bloker en IP-adresse globalt',
	'globalblocking-block-options' => 'Indstillinger:',
	'globalblocking-ipaddress' => 'IP-adresse:',
	'globalblocking-ipbanononly' => 'Kun anonyme brugere spærres',
	'globalblocking-block-errors' => 'Din blokering lykkedes ikke af følgende {{PLURAL:$1|årsag|årsager}}:',
	'globalblocking-block-ipinvalid' => 'IP-adressen, du indtastede ($1), er ugyldig.
Bemærk venligst, at du ikke kan indtaste et brugernavn!',
	'globalblocking-block-expiryinvalid' => 'Den udløbstid, du valgte ($1) er ugyldigt',
	'globalblocking-block-submit' => 'Blokér denne ip-adresse globalt',
	'globalblocking-modify-submit' => 'Ændr denne globale blokering',
	'globalblocking-block-success' => 'IP-adressen $1 er blevet blokeret på alle projekter.',
	'globalblocking-modify-success' => 'Den globale blokering på $1 er blevet ændret',
	'globalblocking-block-successsub' => 'Global blokering lykkedes',
	'globalblocking-modify-successsub' => 'Global blokering er ændret',
	'globalblocking-block-bigrange' => 'Intervallet, du angav, ($1) er for stort, til at det kan blokeres.
Du kan højst blokere 65.536 adresser (/16-intervaller)',
	'globalblocking-list' => 'Liste over globalt blokerede IP-adresser',
	'globalblocking-search-ip' => 'IP-adresse:',
	'globalblocking-search-submit' => 'Søg efter blokke',
	'globalblocking-list-ipinvalid' => 'IP-adressen du søgte efter ($1) er ugyldig.
Skriv en gyldig IP-adresse.',
	'globalblocking-list-expiry' => 'varighed $1',
	'globalblocking-list-anononly' => 'kun anonyme',
	'globalblocking-list-unblock' => 'fjern',
	'globalblocking-list-whitelisted' => 'slået fra lokalt af $1: $2',
	'globalblocking-list-whitelist' => 'lokal status',
	'globalblocking-list-modify' => 'Ændr',
	'globalblocking-list-noresults' => 'Den efterspurgte IP-adresse er ikke blokeret.',
	'globalblocking-goto-unblock' => 'Ophæv en global blokering',
	'globalblocking-unblock' => 'Ophæv en global blokering',
	'globalblocking-unblock-legend' => 'Ophæv en global blokering',
	'globalblocking-unblock-submit' => 'Ophæv global blokering',
	'globalblocking-unblock-reason' => 'Begrundelse:',
	'globalblocking-unblock-subtitle' => 'Ophæver global blokering',
	'globalblocking-whitelist-legend' => 'Ændr lokal status',
	'globalblocking-whitelist-reason' => 'Begrundelse:',
	'globalblocking-whitelist-status' => 'Lokal status:',
	'globalblocking-whitelist-statuslabel' => 'Ophæv global blokering på {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Ændr lokal status',
	'globalblocking-whitelist-intro' => 'Du kan bruge denne formular, til at ophæve en global blokering lokalt. Hvis blokeringen bliver ophævet, kan den globalt blokerede bruger redigere sider normalt. Se også [[Special:GlobalBlockList|loggen for globale blokeringer]].',
	'globalblocking-blocked' => "Din IP-adresse, \$5, er blevet blokeret på alle wikier af '''\$1''' (''\$2'').
Begrundelsen var ''\"\$3\"''.
Blokeringen ''\$4''.",
	'globalblocking-logpage' => 'Global blokeringslog',
	'globalblocking-block-logentry' => 'blokerede [[$1]] globalt med en udløbstid på $2',
	'globalblocking-block2-logentry' => 'blokerede [[$1]] globalt ($2)',
	'globalblocking-unblock-logentry' => 'fjernede global blokering af [[$1]]',
	'globalblocking-modify-logentry' => 'ændrede den globale blokering af [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'udløber $1',
	'globalblock' => 'Bloker en IP-adresse globalt',
	'removeglobalblock' => 'Ophæv en global blokering',
	'right-globalblock' => 'Blokere brugere globalt',
	'right-globalunblock' => 'Ophæve globale blokeringer',
	'right-globalblock-whitelist' => 'Ophæve globale blokeringer lokalt',
	'right-globalblock-exempt' => 'Omgå globale blokeringer',
);

/** German (Deutsch)
 * @author DaSch
 * @author Imre
 * @author Kghbln
 * @author Lukas9950
 * @author MF-Warburg
 * @author Metalhead64
 * @author Purodha
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'globalblocking-desc' => 'Ermöglicht das [[Special:GlobalBlock|Sperren]] von IP-Adressen auf [[Special:GlobalBlockList|allen Wikis]]',
	'globalblocking-block' => 'IP-Adresse global sperren',
	'globalblocking-modify-intro' => 'Du kannst dieses Formular nutzen, um die Einstellungen einer globalen Sperre zu ändern.',
	'globalblocking-block-intro' => 'Auf dieser Seite kannst du IP-Adressen für alle Wikis sperren.',
	'globalblocking-block-reason' => 'Grund:',
	'globalblocking-block-otherreason' => 'Anderer/ergänzender Grund:',
	'globalblocking-block-reasonotherlist' => 'Anderer Grund',
	'globalblocking-block-reason-dropdown' => '* Allgemeine Sperrgründe
** Spam in mehreren Wikis
** Missbrauch in mehreren Wikis
** Vandalismus in mehreren Wikis',
	'globalblocking-block-edit-dropdown' => 'Sperrgründe bearbeiten',
	'globalblocking-block-expiry' => 'Sperrdauer:',
	'globalblocking-block-expiry-other' => 'Andere Dauer',
	'globalblocking-block-expiry-otherfield' => 'Andere Dauer (englisch):',
	'globalblocking-block-legend' => 'IP-Adresse global sperren',
	'globalblocking-block-options' => 'Optionen:',
	'globalblocking-ipaddress' => 'IP-Adresse:',
	'globalblocking-ipbanononly' => 'Nur anonyme Benutzer sperren',
	'globalblocking-block-errors' => 'Die Sperre war nicht erfolgreich. {{PLURAL:$1|Grund|Gründe}}:',
	'globalblocking-block-ipinvalid' => 'Du hast eine ungültige IP-Adresse ($1) eingegeben.
Beachte, dass du keinen Benutzernamen eingeben darfst!',
	'globalblocking-block-expiryinvalid' => 'Die Sperrdauer ($1) ist ungültig.',
	'globalblocking-block-submit' => 'IP-Adresse global sperren',
	'globalblocking-modify-submit' => 'Globale Sperre ändern',
	'globalblocking-block-success' => 'Die IP-Adresse $1 wurde erfolgreich auf allen Projekten gesperrt.',
	'globalblocking-modify-success' => 'Die globale Sperre an $1 wurde erfolgreich geändert',
	'globalblocking-block-successsub' => 'Erfolgreich global gesperrt',
	'globalblocking-modify-successsub' => 'Globale Sperre erfolgreich geändert',
	'globalblocking-block-alreadyblocked' => 'Die IP-Adresse $1 wurde schon global gesperrt.
Du kannst die bestehende Sperre in der [[Special:GlobalBlockList|globalen Sperrliste]] einsehen oder die Einstellungen der Sperre über dieses Formular ändern.',
	'globalblocking-block-bigrange' => 'Der Adressbereich, den du angegeben hast ($1) ist zu groß.
Du kannst höchstens 65.536 IPs sperren (/16-Adressbereiche)',
	'globalblocking-list-intro' => 'Dies ist eine Liste aller gültigen globalen Sperren.
Die Markierung von Sperren als lokal deaktiviert bedeutet, dass die Sperren auf anderen Projekten gültig sind, aber ein lokaler Administrator entschieden hat, sie für dieses Wiki zu deaktivieren.',
	'globalblocking-list' => 'Liste global gesperrter IP-Adressen',
	'globalblocking-search-legend' => 'Globale Sperre suchen',
	'globalblocking-search-ip' => 'IP-Adresse:',
	'globalblocking-search-submit' => 'Sperren suchen',
	'globalblocking-list-ipinvalid' => 'Du hast eine ungültige IP-Adresse ($1) eingegeben.
Bitte gib eine gültige IP-Adresse ein.',
	'globalblocking-search-errors' => 'Die Suche war nicht erfolgreich. {{PLURAL:$1|Grund|Gründe}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (auf ''\$3'') sperrte [[Special:Contributions/\$4|\$4]] global ''(\$5)''",
	'globalblocking-list-expiry' => 'Sperrdauer $1',
	'globalblocking-list-anononly' => 'nur Anonyme',
	'globalblocking-list-unblock' => 'entsperren',
	'globalblocking-list-whitelisted' => 'lokal abgeschaltet von $1: $2',
	'globalblocking-list-whitelist' => 'lokaler Status',
	'globalblocking-list-modify' => 'ändern',
	'globalblocking-list-noresults' => 'Die genannte IP-Adresse ist nicht gesperrt.',
	'globalblocking-goto-block' => 'IP-Adresse global sperren',
	'globalblocking-goto-unblock' => 'Globale Sperre aufheben',
	'globalblocking-goto-status' => 'Lokalen Status für eine globale Sperre ändern',
	'globalblocking-return' => 'Zurück zur Liste der globalen Sperren',
	'globalblocking-notblocked' => 'Die eingegebene IP-Adresse ($1) ist nicht global gesperrt.',
	'globalblocking-unblock' => 'Globale Sperre aufheben',
	'globalblocking-unblock-ipinvalid' => 'Du hast eine ungültige IP-Adresse ($1) eingegeben.
Beachte, dass du keinen Benutzernamen eingeben darfst!',
	'globalblocking-unblock-legend' => 'Global entsperren',
	'globalblocking-unblock-submit' => 'Global entsperren',
	'globalblocking-unblock-reason' => 'Grund:',
	'globalblocking-unblock-unblocked' => "Die hast erfolgreich die IP-Adresse '''$1''' (Sperr-ID $2) entsperrt",
	'globalblocking-unblock-errors' => 'Die Aufhebung der globalen Sperre war nicht erfolgreich. {{PLURAL:$1|Grund|Gründe}}:',
	'globalblocking-unblock-successsub' => 'Erfolgreich global entsperrt',
	'globalblocking-unblock-subtitle' => 'Globale Sperre entfernen',
	'globalblocking-unblock-intro' => 'Mit diesem Formular kannst du eine globale Sperre aufheben.',
	'globalblocking-whitelist' => 'Lokaler Status einer globalen Sperre',
	'globalblocking-whitelist-notapplied' => 'Globale Sperren sind in diesem Wiki nicht aktiviert.
Deshalb kann der lokale Status von globalen Sperren nicht geändert werden.',
	'globalblocking-whitelist-legend' => 'Lokalen Status bearbeiten',
	'globalblocking-whitelist-reason' => 'Grund:',
	'globalblocking-whitelist-status' => 'Lokaler Status:',
	'globalblocking-whitelist-statuslabel' => 'Diese globale Sperre auf {{SITENAME}} aufheben',
	'globalblocking-whitelist-submit' => 'Lokalen Status ändern',
	'globalblocking-whitelist-whitelisted' => "Du hast erfolgreich die globale Sperre der IP-Adresse '''$1''' (Sperr-ID $2) auf {{SITENAME}} aufgehoben.",
	'globalblocking-whitelist-dewhitelisted' => "Du hast erfolgreich die globale Sperre der IP-Adresse '''$1''' (Sperr-ID $2) auf {{SITENAME}} wieder eingeschaltet.",
	'globalblocking-whitelist-successsub' => 'Lokaler Status erfolgreich geändert',
	'globalblocking-whitelist-nochange' => 'Du hast den lokalen Status der Sperre nicht verändert.
[[Special:GlobalBlockList|Zurück zur Liste der globalen Sperre]].',
	'globalblocking-whitelist-errors' => 'Deine Änderung des lokalen Status einer globalen Sperre war nicht erfolgreich. {{PLURAL:$1|Grund|Gründe}}:',
	'globalblocking-whitelist-intro' => 'Du kannst mit diesem Formular den lokalen Status einer globalen Sperre ändern. Wenn eine globale Sperre in dem Wiki deaktiviert wurde, können Seiten über die entsprechende IP-Adresse normal bearbeitet werden. [[Special:GlobalBlockList|Klicke hier]], um zur Liste der globalen Sperren zurückzukehren.',
	'globalblocking-blocked' => "Deine IP-Adresse $5 wurde von '''$1''' ''($2)'' für alle Wikis gesperrt.
Als Begründung wurde ''„$3“'' angegeben. 
Die Sperre ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Du kannst kein Passwort eines Benutzers zurücksetzen, da du global gesperrt wurdest.',
	'globalblocking-logpage' => 'Globales Sperr-Logbuch',
	'globalblocking-logpagetext' => 'Dies ist das Logbuch der globalen Sperren, die in diesem Wiki eingerichtet oder aufgehoben wurden.
Globale Sperren können in einem anderen Wiki eingerichtet und aufgehoben werden, so dass die dortigen Sperren auch dieses Wiki betreffen können.
Für eine Liste aller aktiven globalen Sperren siehe die [[Special:GlobalBlockList|globale Sperrliste]].',
	'globalblocking-block-logentry' => 'sperrte [[$1]] global für einen Zeitraum von $2',
	'globalblocking-block2-logentry' => 'sperrte global [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'entsperrte [[$1]] global',
	'globalblocking-whitelist-logentry' => 'schaltete die globale Sperre von „[[$1]]“ lokal ab',
	'globalblocking-dewhitelist-logentry' => 'schaltete die globale Sperre von „[[$1]]“ lokal wieder ein',
	'globalblocking-modify-logentry' => 'änderte die globale Sperre für [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'bis $1',
	'globalblocking-logentry-noexpiry' => 'kein Sperrende festgelegt',
	'globalblocking-loglink' => 'Die IP-Adresse $1 ist global gesperrt ([[{{#Special:GlobalBlockList}}/$1|Details]]).',
	'globalblocking-showlog' => 'Diese IP-Adresse war früher gesperrt.
Es folgt ein Auszug aus dem Benutzersperr-Logbuch:',
	'globalblocklist' => 'Liste global gesperrter IP-Adressen',
	'globalblock' => 'IP-Adresse global sperren',
	'globalblockstatus' => 'Lokaler Status der globalen Sperre',
	'removeglobalblock' => 'Globale Sperre aufheben',
	'right-globalblock' => 'Globale Sperren einrichten',
	'action-globalblock' => 'globale Sperren einzurichten',
	'right-globalunblock' => 'Globale Sperren aufheben',
	'action-globalunblock' => 'globale Sperren aufzuheben',
	'right-globalblock-whitelist' => 'Globale Sperren lokal aufheben',
	'action-globalblock-whitelist' => 'globale Sperren lokal aufzuheben',
	'right-globalblock-exempt' => 'Globale Sperren umgehen',
	'action-globalblock-exempt' => 'globale Sperren zu umgehen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author MichaelFrey
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'globalblocking-modify-intro' => 'Sie können dieses Formular nutzen, um die Einstellungen einer globalen Sperre zu ändern.',
	'globalblocking-block-intro' => 'Auf dieser Seite können Sie IP-Adressen für alle Wikis sperren.',
	'globalblocking-block-ipinvalid' => 'Sie haben eine ungültige IP-Adresse ($1) eingegeben.
Beachten Sie, dass Sie keinen Benutzernamen eingeben dürfen!',
	'globalblocking-block-alreadyblocked' => 'Die IP-Adresse $1 wurde schon global gesperrt.
Sie können die bestehende Sperre in der [[Special:GlobalBlockList|globalen Sperrliste]] einsehen oder die Einstellungen der Sperre über dieses Formular ändern.',
	'globalblocking-block-bigrange' => 'Der Adressbereich, den Sie angegeben haben ($1) ist zu groß.
Sie können höchstens 65.536 IPs sperren (/16-Adressbereiche)',
	'globalblocking-list-ipinvalid' => 'Sie haben eine ungültige IP-Adresse ($1) eingegeben.
Bitte geben Sie eine gültige IP-Adresse ein.',
	'globalblocking-unblock-ipinvalid' => 'Sie haben eine ungültige IP-Adresse ($1) eingegeben.
Beachten Sie, dass Sie keinen Benutzernamen eingeben dürfen!',
	'globalblocking-unblock-unblocked' => "Sie haben erfolgreich die IP-Adresse '''$1''' (Sperr-ID $2) entsperrt",
	'globalblocking-unblock-intro' => 'Mit diesem Formular können Sie eine globale Sperre aufheben.',
	'globalblocking-whitelist-whitelisted' => "Sie haben erfolgreich die globale Sperre der IP-Adresse '''$1''' (Sperr-ID $2) auf {{SITENAME}} aufgehoben.",
	'globalblocking-whitelist-dewhitelisted' => "Sie haben erfolgreich die globale Sperre der IP-Adresse '''$1''' (Sperr-ID $2) auf {{SITENAME}} wieder eingeschaltet.",
	'globalblocking-whitelist-nochange' => 'Sie haben den lokalen Status der Sperre nicht verändert.
[[Special:GlobalBlockList|Zurück zur Liste der globalen Sperre]].',
	'globalblocking-whitelist-errors' => 'Ihre Änderung des lokalen Status einer globalen Sperre war nicht erfolgreich. {{PLURAL:$1|Grund|Gründe}}:',
	'globalblocking-whitelist-intro' => 'Sie können mit diesem Formular den lokalen Status einer globalen Sperre ändern. Wenn eine globale Sperre in dem Wiki deaktiviert wurde, können Seiten über die entsprechende IP-Adresse normal bearbeitet werden. [[Special:GlobalBlockList|Klicken Sie hier]], um zur Liste der globalen Sperren zurückzukehren.',
	'globalblocking-blocked' => "Ihre IP-Adresse $5 wurde von '''$1''' ''($2)'' für alle Wikis gesperrt.
Als Begründung wurde ''„$3“'' angegeben. 
Die Sperre ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Sie können kein Passwort eines Benutzers zurücksetzen, da Sie global gesperrt wurden.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Mirzali
 * @author Xoser
 */
$messages['diq'] = array(
	'globalblocking-desc' => 'IP addreslerinin [[Special:GlobalBlockList|çoklu vikiler boyunca engellenmesine]] [[Special:GlobalBlock|izin verir]]',
	'globalblocking-block' => "yew adresa Ip'i bı global bloke bıker",
	'globalblocking-modify-intro' => 'qey vurnayişê eyarê blokeya globali şıma eşkêni no form bışuxulni.',
	'globalblocking-block-intro' => 'şıma pê no peleşkêni yew IPadres heme wikiyan de bloke bıker.',
	'globalblocking-block-reason' => 'Sebeb:',
	'globalblocking-block-otherreason' => 'Sebebo bin:',
	'globalblocking-block-reasonotherlist' => 'Sebebo bin',
	'globalblocking-block-reason-dropdown' => '* Sebebanê blok kerdışi
** Crosswiki spam kerdış
** Crosswiki xeripnayış
** Vandalizm kerdış',
	'globalblocking-block-edit-dropdown' => 'Sebebê blokî bivurne',
	'globalblocking-block-expiry' => 'Çi wext de qediyeno:',
	'globalblocking-block-expiry-other' => 'wexê qediyayişi yo bin',
	'globalblocking-block-expiry-otherfield' => 'wexto bin:',
	'globalblocking-block-legend' => "adresa IP'yi bı global bloke bıker",
	'globalblocking-block-options' => 'Tercihi:',
	'globalblocking-block-errors' => 'blokekerdış nêbı, semedê no {{PLURAL:$1|sebeb ra|sebeban ra}}:',
	'globalblocking-block-ipinvalid' => 'IP addresa ke şıma pê keweni cı ($1) nemeqbulo.
xo vir ra mekerê ke şıma nêeşkeni pê nameyê yew karberi cıkewi!',
	'globalblocking-block-expiryinvalid' => 'Girdiğiniz bitiş ($1) geçersiz.',
	'globalblocking-block-submit' => 'na IPadres bı global bloke bıker',
	'globalblocking-modify-submit' => 'na blokeyê globali wedar',
	'globalblocking-block-success' => "IPadresa $1'i heme projeyan de bı serkewte bloke bi.",
	'globalblocking-modify-success' => "blokeyê globalê ke serê $1'i de yi bıserkewte vuriya.",
	'globalblocking-block-successsub' => 'blokeya globali bı serkewteya',
	'globalblocking-modify-successsub' => 'blokeya globali bı serkewte vuriya',
	'globalblocking-block-alreadyblocked' => "IP adresa $1'i ca ra bı global bloke biyayeya.
şıma blokeya mevcudi [[Special:GlobalBlockList|listeya blokeyi ya globali]] ra eşkêni bıvini,
ya zi şıma eşkêni no form anciya bışawe u eyarê blokeya mewcudi bıvurni.",
	'globalblocking-block-bigrange' => "mabêno ke şıma diyari kerdo ($1) qey bloke kerdışi zaf gırdo.
şıma tewr zaf adresa 65.536'i (/16 mabên) eşkêni bıvurni",
	'globalblocking-list-intro' => 'na liste, listeya heme blokebiyayeyê globalana.
tayi blokeyi bı battal nişan biyê: manayê ına, blokebiyayişi keyepelê binan de zi beni,',
	'globalblocking-list' => 'listeya IPadresan a ke bı globali cıresayişê inan vındariyo.',
	'globalblocking-search-legend' => 'bıgêr yew blokeya globali',
	'globalblocking-search-ip' => "Adresa IP'i:",
	'globalblocking-search-submit' => 'blokan bıgêr',
	'globalblocking-list-ipinvalid' => 'IP adresa ke şıma geyrenê cı ($1) nêvêrena.
Kerem kerên, pê jû IP-adresa vêrdiye cı kewên.',
	'globalblocking-search-errors' => 'cıgêrayiş serkewte nêbı, seba no {{PLURAL:$1|sebeb ra|sebeban ra}}:',
	'globalblocking-list-blockitem' => "karberê \$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3''), [[Special:Contributions/\$4|\$4]]'i bı global bloke bı ''(\$5)''",
	'globalblocking-list-expiry' => 'qediyayiş $1',
	'globalblocking-list-anononly' => 'têna anonim',
	'globalblocking-list-unblock' => 'werad/wedar',
	'globalblocking-list-whitelisted' => "hetê $1'i ra bı mehelli pasif bı: $2",
	'globalblocking-list-whitelist' => 'weziyeto mehelli',
	'globalblocking-list-modify' => 'bıvurn',
	'globalblocking-list-noresults' => 'IPadres bloke nêbı',
	'globalblocking-goto-block' => 'yew IPadres bı global bloke bıker',
	'globalblocking-goto-unblock' => 'yew blokê globali wedar/werad',
	'globalblocking-goto-status' => 'qey yew blokeya globali weziyeto mehelli bıvurn',
	'globalblocking-return' => 'agêr listeya blokeyi ya globali',
	'globalblocking-notblocked' => 'IP adresa ke şıma pê keweni cı ($1) bı global blokebiyaye niya.',
	'globalblocking-unblock' => 'yew blokê globali wedar/werad',
	'globalblocking-unblock-ipinvalid' => 'IP adresa ke şıma pê keweni cı ($1) nemeqbulo.
xo vir ra mekerê ke şıma nêeşkeni pê nameyê yew karberi cıkewi!',
	'globalblocking-unblock-legend' => 'yew blokê globali wedar/werad',
	'globalblocking-unblock-submit' => 'blokê globali wedar/werad',
	'globalblocking-unblock-reason' => 'Sebeb:',
	'globalblocking-unblock-unblocked' => "#$2 blokeya globali ya ke IPadresa '''$1'''i de ya şıma bı serkewte wedarna/da wera",
	'globalblocking-unblock-errors' => 'wedarıtışê şıma yo blokeya globali serkewte nêbı, seba no {{PLURAL:$1|sebeb ra|sebeban ra}}:',
	'globalblocking-unblock-successsub' => 'blokeya globali bı serkewte wedariya/wera diya',
	'globalblocking-unblock-subtitle' => 'blokeya globali wedariyena/wera diyena',
	'globalblocking-unblock-intro' => 'Şıma şenê seba wedardena yew kılitkerdışê kurewi nê formi bıgurenê.',
	'globalblocking-whitelist' => 'Küresel engellemelerin yerel durumları',
	'globalblocking-whitelist-notapplied' => 'blokê globali na wiki de tetbiq nıbeni,
mo sebeb ra weziyeto mehelli yê blokeyê globalan nêvuriyeno.',
	'globalblocking-whitelist-legend' => 'weziyetê mehelli bıvurn',
	'globalblocking-whitelist-reason' => 'Sebeb:',
	'globalblocking-whitelist-status' => 'weziyeto mehelli',
	'globalblocking-whitelist-statuslabel' => "no blokê globali keyepelê {{SITENAME}}'i de battal verd",
	'globalblocking-whitelist-submit' => 'weziyeto mehelli bıvurn',
	'globalblocking-whitelist-whitelisted' => "şıma keyepelê {{SITENAME}}i de blokeya IPaddresa '''$1'''i ya globali #$2 bı serkewte battal verda.",
	'globalblocking-whitelist-dewhitelisted' => "şıma keyepelê {{SITENAME}}i de blokeya IPaddresa '''$1'''i ya globali #$2 bı serkewte reyna eşt faaliyet.",
	'globalblocking-whitelist-successsub' => 'weziyeto mehelli bı serkewte vuriya',
	'globalblocking-whitelist-nochange' => 'şıma weziyetê mehelli yo na blokeyi re çı vurnayiş nêkerd.
[[Special:GlobalBlockList|agêrê listeya blokeyi ya globali]].',
	'globalblocking-whitelist-errors' => 'vurnayişo ke şıma weziyetê mehelli yo blokeya globali re kerdo serkewte nêbı, semedê no {{PLURAL:$1|sebeb ra|sebeban ra}}:',
	'globalblocking-whitelist-intro' => 'Küresel bir engellemenin yerel durumunu değiştirmek için bu formu kullanabilirsiniz.
Eğer bir küresel engelleme bu vikide devre dışı bırakılmış ise, etkilenen IP adresindeki kullanıcılar normal olarak değişiklik yapabilecektir.
[[Special:GlobalBlockList|Küresel engelleme listesine geri dönün]].',
	'globalblocking-blocked' => "IP adresa şıma hetê '''\$1''' (''\$2'') ra heme wikiyan de bloke bı.
sebebo ke beyan biyo: ''\"\$3\"''.
bloke kerdış ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'şıma bı global blok biyê u no sebeb ra şıma nêeşkeni şifreya karberi sıfır keri.',
	'globalblocking-logpage' => 'rocaneyê blokeyê globali',
	'globalblocking-logpagetext' => 'Bu, bu vikide yapılan ve kaldırılan küresel engellemelerin günlüğüdür.
Küresel engellemelerin diğer vikilerde yapılıp kaldırılabileceğini, ve bu küresel engellemelerin bu vikiyi etkileyebileceğini unutmayın.
Tüm aktif küresel engellemeri görmek için, [[Special:GlobalBlockList|küresel engelleme listesine]] bakabilirsiniz.',
	'globalblocking-block-logentry' => "[[$1]], pê qediyayişê xewtê $2'i bı global bloke bı",
	'globalblocking-block2-logentry' => 'bı global bloke bı [[$1]] ($2)',
	'globalblocking-unblock-logentry' => "qey [[$1]]'i blokeya global wedariya / wera diya",
	'globalblocking-whitelist-logentry' => "qey [[$1]]'i blokeya global bı mehelli battal verdiya",
	'globalblocking-dewhitelist-logentry' => "qey [[$1]]'i blokeya global bı mehelli reyna kewt faaliyet",
	'globalblocking-modify-logentry' => "serê [[$1]] ($2)'i de blokeya global wedariya / wera diya",
	'globalblocking-logentry-expiry' => 'qediyeno $1',
	'globalblocking-logentry-noexpiry' => 'eyarê qediyayîşî nika nironiyo',
	'globalblocking-loglink' => 'IP-adresa globali $1 kilit biyo ([[{{#Special:GlobalBlockList}}/$1|detayan]]).',
	'globalblocking-showlog' => 'Ena adresê IPyi verni de bloke biyo. 
Logê bloki qe referansi cor de mocnayiyo',
	'globalblocklist' => 'Liteyê IPyî ke wîkîyê hemî de blok biyê',
	'globalblock' => 'Yew adresê IPyî wîkîyê hemî de blok bike',
	'globalblockstatus' => 'Statuyê lokaliyê blokanê hemî',
	'removeglobalblock' => 'Yew global blok wedarne',
	'right-globalblock' => 'Blokanê globalî bike',
	'right-globalunblock' => 'Blokanê globalî wedarne',
	'right-globalblock-whitelist' => 'Lokal wîkî de blokanê globalî biqefilne',
	'right-globalblock-exempt' => 'Global blokî bypass bike',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Zmóžnja]] IP-adrese na [[Special:GlobalBlockList|někotarych wikijach blokěrowaś]]',
	'globalblocking-block' => 'Ip-adresu globalnje blokěrowaś',
	'globalblocking-modify-intro' => 'Móžoš toś ten formular wužywaś, aby změnił nastajenja globalnego blokěrowanja',
	'globalblocking-block-intro' => 'Móžoš tos ten bok wužywaś, aby blokěrował IP-adresu na wšych wikijach.',
	'globalblocking-block-reason' => 'Pśicyna:',
	'globalblocking-block-otherreason' => 'Druga/pśidatna pśicyna:',
	'globalblocking-block-reasonotherlist' => 'Druga pśicyna',
	'globalblocking-block-reason-dropdown' => '* Zwucone pśicyny za blokěrowanje
** Spamowanje crosswiki
** Znjewužywanje crosswiki
** Wandalizm',
	'globalblocking-block-edit-dropdown' => 'Pśicyny blokěrowanja wobźěłaś',
	'globalblocking-block-expiry' => 'Spadnjenje:',
	'globalblocking-block-expiry-other' => 'Drugi cas spadnjenja',
	'globalblocking-block-expiry-otherfield' => 'Drugi cas:',
	'globalblocking-block-legend' => 'IP-adresu globalnje blokěrowaś',
	'globalblocking-block-options' => 'Opcije:',
	'globalblocking-ipaddress' => 'IP-adresa:',
	'globalblocking-ipbanononly' => 'Jano anonymnych wužywarjow blokěrowaś',
	'globalblocking-block-errors' => 'Wašo blokěrowanje jo było njewuspěšne ze {{PLURAL:$1|slědujuceje pśicyny|slědujuceju pśicynowu|slědujucych pśicynow|slědujucych pśicynow}}:',
	'globalblocking-block-ipinvalid' => 'IP-adresa ($1), kótaruž sy zapódał, jo njepłaśiwa.
Pšosym źiwaj na to, až njamóžoš wužywarske mě zapódaś!',
	'globalblocking-block-expiryinvalid' => 'Cas spadnjenja ($1) jo njepłaśiwy.',
	'globalblocking-block-submit' => 'Toś tu IP-adresu globalnje blokěrowaś',
	'globalblocking-modify-submit' => 'Toś to globalne blokěrowanje změniś',
	'globalblocking-block-success' => 'IP-adresa $1 jo se wuspěšnje na wšych projektach blokěrowała.',
	'globalblocking-modify-success' => 'Globalne blokěrowanje na $1 jo se wuspěšnje změniło',
	'globalblocking-block-successsub' => 'Globalne blokěrowanje wuspěšne',
	'globalblocking-modify-successsub' => 'Globalne blokěrowanje wuspěšnje změnjone',
	'globalblocking-block-alreadyblocked' => 'IP-adresa $1 jo južo globalnje blokěrowana.
Móžoš se eksistěrujuce blokěrowanje na [[Special:GlobalBlockList|lisćinje globalnych blokěrowanjow]] woglědaś abo nastajenja eksistujucego blokěrowanja pśez wśopjetowane wótpósłanje formulara změniś.',
	'globalblocking-block-bigrange' => 'Wobcerk, kótaryž sy pódał ($1), jo pśewjeliki za blokěrowanje.
Móžoš blokěrowaś w njewušem paźe 65.536 adresow (/16 wobcerkow)',
	'globalblocking-list-intro' => 'To jo lisćina wšych globalnych blokěrowanjow, kótarež su tuchylu płaśiwe.
Někotare blokěrowanja su ako lokalnje znjemóžnjone markěrowane: to wóznamjenijo, až blokěrowanja su płaśiwe na drugich wikijach, lokalny administrator pak jo rozsuźił je na toś tom wikiju znjemóžniś.',
	'globalblocking-list' => 'Lisćina globalnje blokěrowanych IP-adresow',
	'globalblocking-search-legend' => 'Globalne blokěrowanje pytaś',
	'globalblocking-search-ip' => 'IP-adresa:',
	'globalblocking-search-submit' => 'Blokěrowanja pytaś',
	'globalblocking-list-ipinvalid' => 'IP-adresa, kótaruž sy pytał ($1), jo njepłaśiwa.
Pšosym zapódaj płaśiwu IP-adresu.',
	'globalblocking-search-errors' => 'Twójo pytanje jo ze {{PLURAL:$1|slědujuceje pśicyny|slědujuceju pśicynowu|slědujucych pśicynow|slědujucych pśicynow}} njewuspěšne było:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''na \$3'') jo [[Special:Contributions/\$4|\$4]] globalnje blokěrował ''(\$5)''",
	'globalblocking-list-expiry' => 'Cas spadnjenja $1',
	'globalblocking-list-anononly' => 'jano anonymne',
	'globalblocking-list-unblock' => 'wótpóraś',
	'globalblocking-list-whitelisted' => 'lokalnje znjemóžnjony wót $1: $2',
	'globalblocking-list-whitelist' => 'lokalny status',
	'globalblocking-list-modify' => 'změniś',
	'globalblocking-list-noresults' => 'Póžedana IP-adresa njejo blokěrowany.',
	'globalblocking-goto-block' => 'IP-adresu globalnje blokěrowaś',
	'globalblocking-goto-unblock' => 'Globalne blokěrowanje wótpóraś',
	'globalblocking-goto-status' => 'Lokalny status za globalne blokěrowanje změniś',
	'globalblocking-return' => 'Slědk k lisćinje globalnych blokěrowanjow',
	'globalblocking-notblocked' => 'IP-adresa ($1), kótaruž sy zapódał, njejo globalnje blokěrowana.',
	'globalblocking-unblock' => 'Globalne blokěrowanje wótpóraś',
	'globalblocking-unblock-ipinvalid' => 'IP-adresa ($1), kótaruž sy zapódał, jo njepłaśiwa.
Pšosym źiwaj na to, až njamóžoš wužywarske mě zapódaś!',
	'globalblocking-unblock-legend' => 'Globalne blokěrowanje wótpóraś',
	'globalblocking-unblock-submit' => 'Globalne blokěrowanje wótpóraś',
	'globalblocking-unblock-reason' => 'Pśicyna:',
	'globalblocking-unblock-unblocked' => "Sy wuspěšnje wótpórał globalne blokěrowanje #$2 za IP-adresu '''$1'''",
	'globalblocking-unblock-errors' => 'Wótpóranje globalnego blokěrowanja jo było njewuspěšne ze {{PLURAL:$1|slědujuceje pśicyny|slědujuceju pśicynowu|slědujucych pśicynow|slědujucych pśicynow}}:',
	'globalblocking-unblock-successsub' => 'Globalne blokěrowanje wuspěšnje wótpórane',
	'globalblocking-unblock-subtitle' => 'Globalne blokěrowanje se wótpórajo',
	'globalblocking-unblock-intro' => 'Móžoš wužiwaś toś ten formular, aby globalne blokěrowanje wótpórał.',
	'globalblocking-whitelist' => 'Lokalny status globalnych blokěrowanjow',
	'globalblocking-whitelist-notapplied' => 'Globalne blokěrowanja njenałožuju se na toś ten wiki, 
togodla lokalny status globalnych blokěrowanjow njedajo se změniś.',
	'globalblocking-whitelist-legend' => 'Lokalny status změniś',
	'globalblocking-whitelist-reason' => 'Pśicyna:',
	'globalblocking-whitelist-status' => 'Lokalny status:',
	'globalblocking-whitelist-statuslabel' => 'Toś to globalne blokěrowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}} znjemóžniś',
	'globalblocking-whitelist-submit' => 'Lokalny status změniś',
	'globalblocking-whitelist-whitelisted' => "Sy wuspěšnje znjemóžnił globalne blokěrowanje #$2 IP-adrese '''$1''' na {{GRAMMAR:lokatiw|{{SITENAME}}}}.",
	'globalblocking-whitelist-dewhitelisted' => "Sy zasej wuspěšnje zmóžnił globalne blokěrowanje #$2 IP-adrese '''$1''' na {{GRAMMAR:lokatiw|{{SITENAME}}}}.",
	'globalblocking-whitelist-successsub' => 'Lokalny status wuspěšnje změnjony',
	'globalblocking-whitelist-nochange' => 'Njejsy změnił lokalny status toś togo blokěrowanja.
[[Special:GlobalBlockList|Slědk k lisćinje globalnych blokěrowanjow]].',
	'globalblocking-whitelist-errors' => 'Twójo změnjenje lokalnego statusa globalnego blokěrowanja jo było njewuspěšne ze {{PLURAL:$1|slědujuceje pśicyny|slědujuceju pśicynowu|slědujucych pśicynow|slědujucych pśicynow}}:',
	'globalblocking-whitelist-intro' => 'Móžoš wužiwaś toś ten formular, aby wobźěłał lokalny status globalnego blokěrowanja.
Jolic globalne blokěrowanje jo znjemóžnjone na toś tom wikiju, wužywarje na pótrjefjonej IP-adresy mógu normalnje wobźěłaś.
[[Special:GlobalBlockList|Slědk k lisćinje globalnych blokěrowanjow]].',
	'globalblocking-blocked' => "Waša IP-adresa \$5 jo se blokěrowała wót '''\$1''' (''\$2'') na wšych wikijach.
Pódana pśicyna jo była ''\"\$3\"''.
Blokěrowanje ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Njamóžoš gronidła wužywarja slědk wzaś, dokulaž sy globalnje blokěrowany.',
	'globalblocking-logpage' => 'Protokol globalnych blokěrowanjow',
	'globalblocking-logpagetext' => 'To jo protokol globalnych blokěrowanjow, kótarež su se cynili a wótpórali na toś tom wikiju.
Ty by měł źiwaś na to, až globalne blokěrowanja daju se cyniś a wótpóraś na drugich wikijach a až toś te globalne blokěrowanja mógu wobwliwowaś toś ten wiki.
Aby se woglědał wšykne aktiwne globalne blokěrowanja, móžoš se woglědaś [[Special:GlobalBlockList|lisćinu globalnych blokěrowanjow]].',
	'globalblocking-block-logentry' => 'jo [[$1]] z casom spadnjenja $2 globalnje blokěrował',
	'globalblocking-block2-logentry' => 'globalnje blokěrowany [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'jo globalne blokěrowanje za [[$1]] wótpórał',
	'globalblocking-whitelist-logentry' => 'jo globalne blokěrowanje za [[$1]] lokalnje wótpórał',
	'globalblocking-dewhitelist-logentry' => 'jo globalne blokěrowanje za [[$1]] zasej lokalnje zmóžnił',
	'globalblocking-modify-logentry' => 'jo změnił globalne blokěrowanje na [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'pśepadnjo $1',
	'globalblocking-logentry-noexpiry' => 'žedno pśepadnjenje póstajone',
	'globalblocking-loglink' => 'IP-adresa $1 jo globalnje zablokěrowana ([[{{#Special:GlobalBlockList}}/$1|drobnostki]]).',
	'globalblocking-showlog' => 'Toś ta IP-adresa jo se pjerwjej zablokěrowała.
Protokol blokěrowanjow jo dołojce pódał slědujuce ako referencu:',
	'globalblocklist' => 'Lisćina globalnje blokěrowanych IP-adresow',
	'globalblock' => 'IP-adresu globalnje blokěrowaś',
	'globalblockstatus' => 'Lokalny status globalnych blokěrowanjow',
	'removeglobalblock' => 'Globalne blokěrowanje wótpóraś',
	'right-globalblock' => 'Globalne blokěrowanja napóraś',
	'action-globalblock' => 'globalne blokěrowanja napóraś',
	'right-globalunblock' => 'Globalne blokěrowanja wótpóraś',
	'action-globalunblock' => 'globalne blokěrowanja wótpóraś',
	'right-globalblock-whitelist' => 'Globalne blokěrowanja lokalnje wótpóraś',
	'action-globalblock-whitelist' => 'globalne blokěrowanja lokalnje wótpóraś',
	'right-globalblock-exempt' => 'Globalne blokěrowanja wobejś',
	'action-globalblock-exempt' => 'globalne blokěrowanja wobejś',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'globalblocking-block-expiry' => 'Nuwuwu:',
	'globalblocking-blocked' => "'''\$1''' (''\$2'') xemɔ na wòƒe 'IP address' le wikiwo katã dzi.<br />
Nusita wòwoɔ enye be ''\"\$3\"''.<br />
Mɔxexea ''\$4''.",
);

/** Greek (Ελληνικά)
 * @author AK
 * @author Consta
 * @author Crazymadlover
 * @author Dead3y3
 * @author Geraki
 * @author Omnipaedista
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Επιτρέπει]] διευθύνσεις IP να [[Special:GlobalBlockList|φραγούν σε πολλαπλά wikis]]',
	'globalblocking-block' => 'Καθολική φραγή μιας διεύθυνσης IP',
	'globalblocking-modify-intro' => 'Μπορείτε να χρησιμοποιείσετε αυτή τη φόρμα για να αλλάξετε τις ρυθμίσεις μιας καθολικής φραγής.',
	'globalblocking-block-intro' => 'Μπορείτε να χρησιμοποιήσετε αυτή τη σελίδα για να φράξετε μια διεύθυνση IP σε όλα τα wikis',
	'globalblocking-block-reason' => 'Αιτία:',
	'globalblocking-block-otherreason' => 'Άλλος/πρόσθετος λόγος:',
	'globalblocking-block-reasonotherlist' => 'Άλλος λόγος',
	'globalblocking-block-reason-dropdown' => '* Συνήθεις λόγοι φραγής
** Spam σε πολλαπλά wiki
** Κατάχρηση λογαριασμού σε πολλαπλά wiki
** Βανδαλισμός',
	'globalblocking-block-edit-dropdown' => 'Επεξεργασία των αιτίων για φραγή',
	'globalblocking-block-expiry' => 'Λήξη:',
	'globalblocking-block-expiry-other' => 'Άλλος χρόνος λήξης',
	'globalblocking-block-expiry-otherfield' => 'Άλλος χρόνος:',
	'globalblocking-block-legend' => 'Φραγή μιας διεύθυνσης IP καθολικά',
	'globalblocking-block-options' => 'Επιλογές:',
	'globalblocking-ipaddress' => 'Διεύθυνση IP:',
	'globalblocking-ipbanononly' => 'Φραγή ανώνυμων χρηστών μόνο',
	'globalblocking-block-errors' => 'Η φραγή σας ήταν ανεπιτυχής, για {{PLURAL:$1|τον ακόλουθο λόγο|τους ακόλουθους λόγους}}:',
	'globalblocking-block-ipinvalid' => 'Η διεύθυνση IP ($1) που εισάγατε είναι άκυρη.<br />
Παρακαλώ σημειώστε ότι δεν μπορείτε να εισαγετε ένα όνομα χρήστη!',
	'globalblocking-block-expiryinvalid' => 'Η ημερομηνία λήξης που εισάγατε ($1) είναι άκυρη.',
	'globalblocking-block-submit' => 'Φραγή αυτής της διεύθυνσης IP καθολικά',
	'globalblocking-modify-submit' => 'Τροποποίηση αυτής της καθολικής φραγής',
	'globalblocking-block-success' => 'Η διεύθυνση IP $1 φράχτηκε επιτυχώς σε όλα τα εγχειρήματα.',
	'globalblocking-modify-success' => 'Η καθολική φραγή στον/στην $1 τροποποιήθηκε επιτυχώς',
	'globalblocking-block-successsub' => 'Καθολική φραγή επιτυχής',
	'globalblocking-modify-successsub' => 'Η καθολική φραγή τροποποιήθηκε επιτυχώς',
	'globalblocking-block-alreadyblocked' => 'Η διεύθυνση IP $1 είναι ήδη φραγμένη καθολικά.<br />
Μπορείτε να δείτε την υπάρχουσα φραγή στον [[Special:GlobalBlockList|κατάλογο καθολικών φραγών]],
ή να τροποποιήσετε τις ρυθμίσεις της υπάρχουσας φραγής επανακαταχωρώντας αυτή την φόρμα.',
	'globalblocking-block-bigrange' => 'Το εύρος που ορίσατε ($1) είναι πολύ μεγάλο για να φραγεί.<br />
Μπορείτε να φράξετε, το πολύ, 65.536 διευθύνσεις (/16 εύρη)',
	'globalblocking-list-intro' => 'Αυτός είναι ένας κατάλογος με όλες τις καθολικές φραγές οι οποίες ισχύουν αυτή τη στιγμή.<br />
Μερικές φραγές είναι σημασμένες ως τοπικά απενεργοποιημένες: αυτό σημαίνει ότι εφαρμόζονται σε άλλους ιστοτόπους, αλλά ο τοπικός διαχειριστής έχει αποφασίσει να τις απενεργοποιήσει σε αυτό το wiki.',
	'globalblocking-list' => 'Κατάλογος καθολικά φραγμένων διευθύνσεων IP',
	'globalblocking-search-legend' => 'Αναζήτηση για μια καθολική φραγή',
	'globalblocking-search-ip' => 'διεύθυνση IP:',
	'globalblocking-search-submit' => 'Αναζήτηση για φραγές',
	'globalblocking-list-ipinvalid' => 'Η διεύθυνση IP για την οποία αναζητήσατε ($1) είναι άκυρη.<br />
Παρακαλώ εισάγετε μια έγκυρη διεύθυνση IP.',
	'globalblocking-search-errors' => 'Η αναζήτηση σας ήταν ανεπιτυχής, για {{PLURAL:$1|τον ακόλουθο λόγο|τους ακόλουθους λόγους}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">Ο/Η '''\$2'''</span> (''\$3'') έφραξε καθολικά τον/την [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'λήξη $1',
	'globalblocking-list-anononly' => 'μόνο ανώνυμος',
	'globalblocking-list-unblock' => 'αφαίρεση',
	'globalblocking-list-whitelisted' => 'τοπικά απενεργοποιημένη από τον/την $1: $2',
	'globalblocking-list-whitelist' => 'τοπική κατάσταση',
	'globalblocking-list-modify' => 'τροποποίηση',
	'globalblocking-list-noresults' => 'Η ζητούμενη διεύθυνση IP δεν είναι φραγμένη.',
	'globalblocking-goto-block' => 'Καθολική φραγή μιας διεύθυνσης IP',
	'globalblocking-goto-unblock' => 'Αφαίρεση μιας καθολικής φραγής',
	'globalblocking-goto-status' => 'Αλλαγή τοπικής κατάστασης για μια καθολική φραγή',
	'globalblocking-return' => 'Επιστροφή στον κατάλογο καθολικών φραγών',
	'globalblocking-notblocked' => 'Η διεύθυνση IP ($1) που εισάγατε δεν είναι καθολικά φραγμένη.',
	'globalblocking-unblock' => 'Αφαίρεση μιας καθολικής φραγής',
	'globalblocking-unblock-ipinvalid' => 'Η διεύθυνσης IP ($1) που εισάγατε είναι άκυρη.<br />
Παρακαλώ σημειώστε ότι δεν μπορείτε να εισαγετε ένα όνομα χρήστη!',
	'globalblocking-unblock-legend' => 'Αφαίρεση μιας καθολικής φραγής',
	'globalblocking-unblock-submit' => 'Αφαίρεση καθολικής φραγής',
	'globalblocking-unblock-reason' => 'Λόγος:',
	'globalblocking-unblock-unblocked' => "Αφαιρέσατε επιτυχώς την καθολική φραγή #$2 στην διεύθυνση IP '''$1'''",
	'globalblocking-unblock-errors' => 'Η αφαίρεση σας της καθολικής φραγής ήταν ανεπιτυχής, για {{PLURAL:$1|τον ακόλουθο λόγο|τους ακόλουθους λόγους}}:',
	'globalblocking-unblock-successsub' => 'Καθολική φραγή αφαιρέθηκε επιτυχώς',
	'globalblocking-unblock-subtitle' => 'Αφαίρεση καθολικής φραγής',
	'globalblocking-unblock-intro' => 'Μπορείτε να χρησιμοποιήσετε αυτή τη φόρμα για να αφαιρέσετε μια καθολική φραγή.',
	'globalblocking-whitelist' => 'Τοπική κατάσταση καθολικών φραγών',
	'globalblocking-whitelist-notapplied' => 'Οι καθολικές φραγές δεν εφαρμόζονται σε αυτό το wiki,
οπότε η τοπική κατάσταση των καθολικών φραγών δεν μπορεί να τροποποιηθεί.',
	'globalblocking-whitelist-legend' => 'Αλλαγή τοπικής κατάστασης',
	'globalblocking-whitelist-reason' => 'Αιτία:',
	'globalblocking-whitelist-status' => 'Τοπική κατάσταση:',
	'globalblocking-whitelist-statuslabel' => 'Απενεργοποίηση αυτής της καθολικής φραγής στον ιστότοπο {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Αλλαγή τοπικής κατάστασης',
	'globalblocking-whitelist-whitelisted' => "Απενεργοποιήσατε επιτυχώς την καθολική φραγή #$2 στην διεύθυνση IP '''$1''' στον ιστότοπο {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Ενεργοποιήσατε πάλι επιτυχώς την καθολική φραγή #$2 στην διεύθυνση IP '''$1''' στον ιστότοπο {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Η τοπική κατάσταση άλλαξε επιτυχώς',
	'globalblocking-whitelist-nochange' => 'Δεν έχετε κάνει καμία αλλαγή στην τοπική κατάσταση αυτής της φραγής.<br />
[[Special:GlobalBlockList|Επιστροφή στον κατάλογο καθολικών φραγών]].',
	'globalblocking-whitelist-errors' => 'Η αλλαγή σας στην τοπική κατάσταση μιας καθολικής φραγής ήταν ανεπιτυχής, για {{PLURAL:$1|τον ακόλουθο λόγο|τους ακόλουθους λόγους}}:',
	'globalblocking-whitelist-intro' => 'Μπορείτε να χρησιμοποιήσετε αυτή τη φόρμα για να επεξεργαστείτε την τοπική κατάσταση μιας καθολικής φραγής.<br />
Αν μια καθολική φραγή είναι απενεργοποιημένη σε αυτό το wiki, οι χρήστες της επηρεαζόμενης διεύθυνσης IP θα είναι ικανοί να επεξεργαστούν σελίδες κανονικά.<br />
[[Special:GlobalBlockList|Επιστροφή στον κατάλογο καθολικών φραγών]].',
	'globalblocking-blocked' => "Η διεύθυνση IP σας έχει φραγεί σε όλα τα wikis από τον/την '''$1''' (''$2'').<br />
Ο λόγος που δόθηκε ήταν ''«$3»''.<br />
Τύπος φραγής: ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Δεν μπορείτε να επαναφέρετε του κωδικούς χρήστη επειδή είστε καθολικά φραγμένος.',
	'globalblocking-logpage' => 'Αρχείο καταγραφής καθολικών φραγών',
	'globalblocking-logpagetext' => 'Αυτό είναι ένα αρχείο καταγραφής των καθολικών φραγών οι οποίες έχουν γίνει και αφαιρέθηκαν σε αυτό το wiki.<br />
Πρέπει να σημειωθεί ότι οι καθολικές φραγές μπορούν να γίνουν και να αφαιρεθούν σε άλλα wikis, και ότι αυτές οι καθολικές φραγές μπορεί να επηρεάσουν αυτό το wiki.<br />
Για να δείτε όλες τις ενεργές καθολικές φραγές, μπορείτε να δείτε τον [[Special:GlobalBlockList|κατάλογο καθολικών φραγών]].',
	'globalblocking-block-logentry' => 'έφραξε καθολικά τον/την [[$1]] με χρόνο λήξης $2',
	'globalblocking-block2-logentry' => 'έφραξε καθολικά τον/την [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'αφαίρεσε την καθολική φραγή στον/στην [[$1]]',
	'globalblocking-whitelist-logentry' => 'απενεργοποίησε την καθολική φραγή στον/στην [[$1]] τοπικά',
	'globalblocking-dewhitelist-logentry' => 'ενεργοποίησε πάλι την καθολική φραγή στον/στην [[$1]] τοπικά',
	'globalblocking-modify-logentry' => 'τροποποίησε την καθολική φραγή στον/στην [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'λήγει $1',
	'globalblocking-logentry-noexpiry' => 'δεν τέθηκε ημερομηνία λήξης',
	'globalblocking-loglink' => 'Η διεύθυνση IP $1 φράχτηκε καθολικά ([[{{#Special:GlobalBlockList}}/$1|δείτε όλες τις λεπτομέρειες]]).',
	'globalblocking-showlog' => 'Αυτή η διεύθυνση IP έχει φραγεί προηγουμένως.
Το αρχείο καταγραφής φραγών παρουσιάζεται παρακάτω:',
	'globalblocklist' => 'Κατάλογος καθολικά φραγμένων διευθύνσεων IP',
	'globalblock' => 'Καθολική φραγή μιας διεύθυνσης IP',
	'globalblockstatus' => 'Τοπική κατάσταση καθολικών φραγών',
	'removeglobalblock' => 'Αφαίρεση μιας καθολικής φραγής',
	'right-globalblock' => 'Δημιουργία καθολικών φραγών',
	'right-globalunblock' => 'Αφαίρεση καθολικών φραγών',
	'right-globalblock-whitelist' => 'Απενεργοποίηση καθολικών φραγών τοπικά',
	'right-globalblock-exempt' => 'Παράκαμψη καθολικών φραγών',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permesas]] IP-adreso esti [[Special:GlobalBlockList|forbarita trans multaj vikioj]].',
	'globalblocking-block' => 'Ĝenerale forbari IP-adreson',
	'globalblocking-modify-intro' => 'Vi povas uzi ĉi tiun formularon por ŝanĝi la agordojn de ĝeneralan forbaron.',
	'globalblocking-block-intro' => 'Vi povas uzi ĉi tiun paĝon por forbari IP-adreson en ĉiuj vikioj.',
	'globalblocking-block-reason' => 'Kialo:',
	'globalblocking-block-otherreason' => 'Alia/plua kialo:',
	'globalblocking-block-reasonotherlist' => 'Alia kialo',
	'globalblocking-block-reason-dropdown' => '* Oftaj kialoj de forbarado
** Transvikia spamado
** Transvikia misuzado
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Redakti kialojn por forbaro',
	'globalblocking-block-expiry' => 'Findaŭro:',
	'globalblocking-block-expiry-other' => 'Alia limdato',
	'globalblocking-block-expiry-otherfield' => 'Alia tempo:',
	'globalblocking-block-legend' => 'Forbari IP-adreson ĝenerale',
	'globalblocking-block-options' => 'Opcioj:',
	'globalblocking-ipaddress' => 'IP-adreso:',
	'globalblocking-ipbanononly' => 'Forbari nur anonimulojn',
	'globalblocking-block-errors' => 'La forbaro malsukcesis, pro la {{PLURAL:$1|jena kialo|jenaj kialoj}}:
$1',
	'globalblocking-block-ipinvalid' => 'La IP-adreso ($1) kiun vi enigis estas malvalida.
Bonvolu noti ke vi ne povas enigi salutnomo!',
	'globalblocking-block-expiryinvalid' => 'La findaton kiun vi enigis ($1) estas malvalida.',
	'globalblocking-block-submit' => 'Forbari ĉi tiun IP-adreson ĝenerale',
	'globalblocking-modify-submit' => 'Modifi ĉi tiun ĝeneralan forbaron',
	'globalblocking-block-success' => 'La IP-adreso $1 estis sukcese forbarita por ĉiuj projektoj.',
	'globalblocking-modify-success' => 'La ĝenerala forbaro por $1 estis sukcese modifita.',
	'globalblocking-block-successsub' => 'Ĝenerala forbaro estis sukcesa',
	'globalblocking-modify-successsub' => 'Ĝenerala forbaro estis modifita sukcese',
	'globalblocking-block-alreadyblocked' => 'La IP-adreso $1 estas jam forbarita ĝenerale. 
Vi povas rigardi la ekzistanta forbaro en la [[Special:GlobalBlockList|Listo de ĝeneralaj forbaroj]],
aŭ modifi la agordojn de la ekzistanta forbaro resendante ĉi tiun formularon.',
	'globalblocking-block-bigrange' => 'La intervalo kiun vi entajpis ($1) estas tro grando por forbari.
Vi povas forbari maksimume 65,536 adrresojn (/16 IP-intervalojn)',
	'globalblocking-list-intro' => 'Jen listo de ĉiuj transvikiaj forbaroj kiuj nune efikas.
Iuj forbaroj estas markitaj kiel loke permesitaj; ĉi tiu signifas ke la forbaro efikas en aliaj vikioj, sed loka administranto decidis permesi la konton en ĉi tiu vikio.',
	'globalblocking-list' => 'Listo de ĝenerale forbaritaj IP-adresoj',
	'globalblocking-search-legend' => 'Serĉi ĝeneralan forbaron',
	'globalblocking-search-ip' => 'IP-adreso:',
	'globalblocking-search-submit' => 'Serĉi forbarojn',
	'globalblocking-list-ipinvalid' => 'La serĉita IP-adreso ($1) estas malvalida.
Bonvolu enigi validan IP-adreson.',
	'globalblocking-search-errors' => 'Via serĉo estis malsukcesa, ĉar la {{PLURAL:$1|jena kialo|jenaj kialoj}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') ĝenerale forbaris uzanton [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'findato $1',
	'globalblocking-list-anononly' => 'nur anonimuloj',
	'globalblocking-list-unblock' => 'malforbari',
	'globalblocking-list-whitelisted' => 'loke malebligita de $1: $2',
	'globalblocking-list-whitelist' => 'loka statuso',
	'globalblocking-list-modify' => 'modifi',
	'globalblocking-list-noresults' => 'La petita IP-adreso ne estas forbarita.',
	'globalblocking-goto-block' => 'Ĝenerale forbari IP-adreson',
	'globalblocking-goto-unblock' => 'Forigi ĝeneralan forbaron',
	'globalblocking-goto-status' => 'Ŝanĝigi lokan statuson por ĝenerala forbaro',
	'globalblocking-return' => 'Reiri al listo de ĝeneralaj forbaroj',
	'globalblocking-notblocked' => 'La IP-adreso ($1) kiun vi enigis ne estas ĝenerale forbarita.',
	'globalblocking-unblock' => 'Forigi ĝeneralan forbaron',
	'globalblocking-unblock-ipinvalid' => 'La IP-adreso ($1) kiun vi enigis estas malvalida.
Bonvolu noti ke vi ne povas enigi salutnomon!',
	'globalblocking-unblock-legend' => 'Forigi ĝeneralan forbaron',
	'globalblocking-unblock-submit' => 'Forigi ĝeneralan forbaron',
	'globalblocking-unblock-reason' => 'Kialo:',
	'globalblocking-unblock-unblocked' => "Vi sukcese forigis la ĝeneralan forbaron #$2 por la IP-adreso '''$1'''",
	'globalblocking-unblock-errors' => 'Via restarigo de la ĝenerala forbaro estis nesukcesa, por la {{PLURAL:$1|jena kialo|jenaj kialoj}}:',
	'globalblocking-unblock-successsub' => 'Ĝenerala forbaro estis sukcese forigita',
	'globalblocking-unblock-subtitle' => 'Forigante ĝeneralan forbaron',
	'globalblocking-unblock-intro' => 'Vi povas uzi ĉi tiu paĝo por forviŝi ĝeneralan forbaron.',
	'globalblocking-whitelist' => 'Loka statuso de ĝeneralaj blokoj',
	'globalblocking-whitelist-notapplied' => 'Ĝeneralaj forbaroj ne estas aplikataj en ĉi tiu vikio,
do la loka statuso de ĝenerala forbaroj ne povas esti modifita.',
	'globalblocking-whitelist-legend' => 'Ŝanĝi lokan statuson',
	'globalblocking-whitelist-reason' => 'Kialo:',
	'globalblocking-whitelist-status' => 'Loka statuso:',
	'globalblocking-whitelist-statuslabel' => 'Malebligi ĉi tiun ĝeneralan forbaron por {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Ŝanĝi lokan statuson',
	'globalblocking-whitelist-whitelisted' => "Vi sukcese malebligis la ĝeneralan forbaron #$2 por la IP-adreso '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Vi sukcese reebligis la ĝeneralan forbaron #$2 por la IP-adreso '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Loka statuso sukcese ŝanĝiĝis.',
	'globalblocking-whitelist-nochange' => 'Vi faris neniun ŝanĝon al la loka statuso de ĉi tiu forbaro.
[[Special:GlobalBlockList|Reiri al la listo de ĝeneralaj forbaroj]].',
	'globalblocking-whitelist-errors' => 'Via ŝanĝo al la loka statuso de ĝenerala forbaro malsukcesis, pro la {{PLURAL:$1|jena kialo|jenaj kialoj}}:',
	'globalblocking-whitelist-intro' => 'Vi povas uzi ĉi tiun paĝon por redakti la lokan statuson de ĝenerala forbaro.
Se ĝenerala forbaro estas malŝaltita en ĉi tiu vikio, uzantoj de tiu IP-adreso eblos redakti norme.
[[Special:GlobalBlockList|Reiri al la listo de ĝeneralaj forbaroj]].',
	'globalblocking-blocked' => "Via IP-adreso \$5 estis forbarita en ĉiuj Wikimedia-retejoj de '''\$1''' (''\$2'').
La kialo donata estis ''\"\$3\"''. 
La forbaro estas ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Vi ne povas restarigi pasvortojn de aliaj uzantoj, cxar vi estas forbarita ĝenerale.',
	'globalblocking-logpage' => 'Protokolo de ĝeneralaj forbaroj',
	'globalblocking-logpagetext' => 'Jen protokolo de ĝeneralaj forbaroj kiuj estis faritaj kaj forigitaj en ĉi tiu vikio.
Estas notinda ke ĝeneralaj forbaroj povas esti faritaj kaj forigitaj en aliaj vikioj, kaj ĉi tiuj forbaroj povas efiki ĉi tiun vikion.
Vidi ĉiujn aktivajn ĝeneralajn forbarojn, vi povas vidi la [[Special:GlobalBlockList|liston de ĝeneralaj forbaroj]].',
	'globalblocking-block-logentry' => 'ĝenerale forbaris [[$1]] kun findato de $2',
	'globalblocking-block2-logentry' => 'ĝenerale forbarita [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'forigis ĝeneralajn forbarojn por [[$1]]',
	'globalblocking-whitelist-logentry' => 'malebligis la ĝeneralan forbaron por [[$1]] loke',
	'globalblocking-dewhitelist-logentry' => 'reebligis la ĝeneralan forbaron por [[$1]] loke',
	'globalblocking-modify-logentry' => 'modifis la ĝeneralan forbaron je [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'finas je $1',
	'globalblocking-logentry-noexpiry' => 'neniu fintempo',
	'globalblocking-loglink' => 'La IP-adreso $1 estas forbarita ĝenerale ([[{{#Special:GlobalBlockList}}/$1|plenaj detaloj]]).',
	'globalblocking-showlog' => 'Ĉi tiu IP-adreso estis antaŭe forbarita.
Jen la protokolo pri forbaroj sube por via referenco:',
	'globalblocklist' => 'Listo de ĝenerale forbaritaj IP-adresoj',
	'globalblock' => 'Ĝenerale forbari IP-adreson',
	'globalblockstatus' => 'Loka statuso de ĝeneralaj forbaroj',
	'removeglobalblock' => 'Forigi ĝeneralan forbaron',
	'right-globalblock' => 'Fari ĝeneralajn forbarojn',
	'right-globalunblock' => 'Forigi ĝeneralajn forbarojn',
	'right-globalblock-whitelist' => 'Malŝalti ĝeneralajn forbarojn loke',
	'right-globalblock-exempt' => 'Preterigi ĝeneralajn forbarojn',
);

/** Spanish (Español)
 * @author Aleator
 * @author Armando-Martin
 * @author Crazymadlover
 * @author Dferg
 * @author Fitoschido
 * @author Lin linao
 * @author Locos epraix
 * @author Mor
 * @author Peter17
 * @author Platonides
 * @author Remember the dot
 * @author Sanbec
 * @author Translationista
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permite]] bloquear direcciones IP [[Special:GlobalBlockList|simultáneamente en varios wikis]]',
	'globalblocking-block' => 'Bloquear globalmente una dirección IP',
	'globalblocking-modify-intro' => 'Puedes usar este formulario para cambiar las configuraciones de un bloqueo global.',
	'globalblocking-block-intro' => 'Puede usar esta página para bloquear una dirección IP en todos los wikis.',
	'globalblocking-block-reason' => 'Motivo:',
	'globalblocking-block-otherreason' => 'Otros/razón adicional:',
	'globalblocking-block-reasonotherlist' => 'Otro motivo',
	'globalblocking-block-reason-dropdown' => '* Motivos comunes de bloqueo
** Spam sobre varios wikis
** Abusos sobre varios wikis
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Editar motivos de bloqueo',
	'globalblocking-block-expiry' => 'Caducidad:',
	'globalblocking-block-expiry-other' => 'Otro tiempo de caducidad',
	'globalblocking-block-expiry-otherfield' => 'Otro tiempo:',
	'globalblocking-block-legend' => 'Bloquear una dirección IP globalmente',
	'globalblocking-block-options' => 'Opciones:',
	'globalblocking-ipaddress' => 'Dirección IP:',
	'globalblocking-ipbanononly' => 'Bloquear sólo los usuarios anónimos',
	'globalblocking-block-errors' => 'Tu bloqueo falló por {{PLURAL:$1|la siguiente razón|las siguientes razones}}:',
	'globalblocking-block-ipinvalid' => 'La dirección IP ($1) que introdujiste no es válida. Por favor, ten en cuenta que no puedes introducir un nombre de usuario.',
	'globalblocking-block-expiryinvalid' => 'La caducidad que introdujo ($1) es inválida.',
	'globalblocking-block-submit' => 'Bloquear esta dirección IP globalmente',
	'globalblocking-modify-submit' => 'Modificar este bloqueo global',
	'globalblocking-block-success' => 'La dirección IP $1 ha sido bloqueada con éxito en todos los proyectos.',
	'globalblocking-modify-success' => 'El bloqueo global en $1 ha sido exitosamente modificado',
	'globalblocking-block-successsub' => 'El bloqueo global tuvo éxito',
	'globalblocking-modify-successsub' => 'Bloqueo global modificado con éxito',
	'globalblocking-block-alreadyblocked' => 'La dirección IP $1 ya está bloqueada globalmente.
Puede ver el bloqueo existente en la [[Special:GlobalBlockList|lista de bloqueos globales]], o modificar las configuraciones del bloqueo existente reeenviando este formulario.',
	'globalblocking-block-bigrange' => 'El rango que especificaste ($1) es demasiado grande para ser bloqueado.
Puedes bloquear, a lo sumo, 65.536 direcciones (un rango de /16)',
	'globalblocking-list-intro' => 'Esta es una lista de todos los bloqueos globales que actualmente están en efecto.
Algunos bloqueos están marcados como desactivados localmente: esto significa que se aplican en otros sitios, y que un administrador local ha decidido desactivarlos en esta wiki.',
	'globalblocking-list' => 'Lista de direcciones IP bloqueadas globalmente',
	'globalblocking-search-legend' => 'Buscar un bloqueo global',
	'globalblocking-search-ip' => 'Dirección IP:',
	'globalblocking-search-submit' => 'Buscar bloqueos',
	'globalblocking-list-ipinvalid' => 'La dirección IP que buscaste ($1) no es válida.
Por favor, introduce una dirección IP válida.',
	'globalblocking-search-errors' => 'Tu búsqueda no tuvo éxito por {{PLURAL:$1|la siguiente razón|las siguientes razones}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bloqueó globalmente a [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'expira $1',
	'globalblocking-list-anononly' => 'sólo anónimos',
	'globalblocking-list-unblock' => 'desbloquear',
	'globalblocking-list-whitelisted' => 'desactivado localmente por $1: $2',
	'globalblocking-list-whitelist' => 'estado local',
	'globalblocking-list-modify' => 'modificar',
	'globalblocking-list-noresults' => 'La dirección IP solicitada no está bloqueada.',
	'globalblocking-goto-block' => 'Bloquear globalmente una dirección IP',
	'globalblocking-goto-unblock' => 'Quitar un bloqueo global',
	'globalblocking-goto-status' => 'Cambiar estatus local de un bloqueo global',
	'globalblocking-return' => 'Volver a la lista de bloqueos globales',
	'globalblocking-notblocked' => 'La dirección IP ($1) que escribiste no está bloqueada globalmente.',
	'globalblocking-unblock' => 'Quitar un bloqueo global',
	'globalblocking-unblock-ipinvalid' => 'La dirección IP ($1) que introdujo es inválida.
¡Por favor tenga en cuenta que no puede introducir un nombre de usuario!',
	'globalblocking-unblock-legend' => 'Quitar un bloqueo global',
	'globalblocking-unblock-submit' => 'Quitar el bloqueo global',
	'globalblocking-unblock-reason' => 'Motivo:',
	'globalblocking-unblock-unblocked' => "Has quitado con éxito el bloqueo global #$2 en la dirección IP '''$1'''",
	'globalblocking-unblock-errors' => 'La eliminación del bloqueo global fracasó, por las siguientes {{PLURAL:$1|razón|razones}}:',
	'globalblocking-unblock-successsub' => 'Se quitó el bloqueo global con éxito',
	'globalblocking-unblock-subtitle' => 'Quitando bloqueo global',
	'globalblocking-unblock-intro' => 'Puedes usar este formulario para quitar un bloqueo global.',
	'globalblocking-whitelist' => 'Estatus local de bloqueos globales',
	'globalblocking-whitelist-notapplied' => 'Bloqueos globales no son aplicados en este wiki,
entonces el status de bloqueos globales no pueden ser modificados.',
	'globalblocking-whitelist-legend' => 'Cambiar estatus local',
	'globalblocking-whitelist-reason' => 'Motivo:',
	'globalblocking-whitelist-status' => 'Estatus local:',
	'globalblocking-whitelist-statuslabel' => 'Desactivar este bloqueo global en {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Cambiar estatus local',
	'globalblocking-whitelist-whitelisted' => "Has desactivado con éxito el bloqueo global #$2 de la dirección IP '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Has reactivado con éxito el bloqueo global #$2 de la dirección IP '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Se cambió el estatus local con éxito',
	'globalblocking-whitelist-nochange' => 'Usted no hizo ningún cambio al estado local de este bloqueo.
[[Special:GlobalBlockList|Volver a la lista de bloqueos globales]].',
	'globalblocking-whitelist-errors' => 'Su cambio al estatus local de un bloqueo global no tuvo éxito, a causa de {{PLURAL:$1|la siguiente razón|las siguientes razones}}:',
	'globalblocking-whitelist-intro' => 'Puedes usar este formulario para editar el estatus local de un bloqueo global.
Si un bloqueo global está desactivado en esta wiki, los usuarios de la dirección IP afectada podrán editar normalmente.
[[Special:GlobalBlockList|Volver a la lista de bloqueos globales]].',
	'globalblocking-blocked' => "'''$1''' (''$2'') bloqueó su dirección IP $5 en todos los wikis.
El motivo dado fue ''«$3»''.
El bloqueo ''$4''.",
	'globalblocking-blocked-nopassreset' => 'No puede solicitar recordatorios de claves de usuario porque usted está bloqueado globalmente.',
	'globalblocking-logpage' => 'Registro de bloqueos globales',
	'globalblocking-logpagetext' => 'Esta es una lista de bloqueos globales que se han hecho y retirado en este wiki.
Hay que señalar que los bloqueos globales pueden ser hechos y retirados en otros wikis, y que estos bloqueos globales pueden afectar a este wiki.
Para ver todos los bloqueos globales activos, puede ver [[Special:GlobalBlockList|lista de bloqueos globales]].',
	'globalblocking-block-logentry' => 'bloqueó globalmente a [[$1]] con un tiempo de caducidad de $2',
	'globalblocking-block2-logentry' => 'bloqueó globalmente a [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'desactivó el bloqueo global en [[$1]]',
	'globalblocking-whitelist-logentry' => 'desactivó el bloqueo global en [[$1]] localmente',
	'globalblocking-dewhitelist-logentry' => 'reactivó localmente el bloqueo global en [[$1]]',
	'globalblocking-modify-logentry' => 'modificó el bloqueo global en [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'caduca el $1',
	'globalblocking-logentry-noexpiry' => 'sin fecha de caducidad',
	'globalblocking-loglink' => 'La dirección IP $1 está bloqueada globalmente ([[{{#Special:GlobalBlockList}}/$1|detalles]]).',
	'globalblocking-showlog' => 'Esta dirección IP ha sido bloqueada previamente.
El registro de bloqueos se proporciona a continuación como referencia:',
	'globalblocklist' => 'Lista de direcciones IP bloqueadas globalmente',
	'globalblock' => 'Bloquear una dirección IP globalmente',
	'globalblockstatus' => 'Estatus local de bloqueos globales',
	'removeglobalblock' => 'Quitar un bloqueo global',
	'right-globalblock' => 'Hacer bloqueos globales',
	'action-globalblock' => 'hacer bloques mundiales',
	'right-globalunblock' => 'Quitar un bloqueo global',
	'action-globalunblock' => 'eliminar bloqueos globales',
	'right-globalblock-whitelist' => 'Desactivar bloqueos globales localmente',
	'action-globalblock-whitelist' => 'deshabilitar localmente bloqueos globales',
	'right-globalblock-exempt' => 'Eludir bloqueos globales',
	'action-globalblock-exempt' => 'eludir bloqueos globales',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Jaan513
 * @author Ker
 * @author Pikne
 * @author WikedKentaur
 */
$messages['et'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Lubab]] IP-aadresse [[Special:GlobalBlockList|korraga mitmetes vikides blokeerida]].',
	'globalblocking-block' => 'Blokeeri IP-aadress globaalselt',
	'globalblocking-modify-intro' => 'Seda vormi saad kasutada globaalse blokeeringu sätete muutmiseks.',
	'globalblocking-block-intro' => 'Seda lehekülge saad IP-aadressi kõigis vikiprojektides blokeerimiseks kasutada.',
	'globalblocking-block-reason' => 'Põhjus:',
	'globalblocking-block-otherreason' => 'Muu või täiendav põhjus:',
	'globalblocking-block-reasonotherlist' => 'Muu põhjus',
	'globalblocking-block-reason-dropdown' => '* Tavalised blokeerimispõhjused
** Rämpspostitamine erinevates vikides
** Rikkumised erinevates vikides
** Vandalism',
	'globalblocking-block-edit-dropdown' => 'Muuda blokeerimispõhjuseid',
	'globalblocking-block-expiry' => 'Aegumistähtaeg:',
	'globalblocking-block-expiry-other' => 'Muu tähtaeg',
	'globalblocking-block-expiry-otherfield' => 'Muu aeg:',
	'globalblocking-block-legend' => 'Blokeeri IP-aadress globaalselt',
	'globalblocking-block-options' => 'Sätted:',
	'globalblocking-ipaddress' => 'IP-aadress:',
	'globalblocking-ipbanononly' => 'Blokeeri ainult anonüümseid kasutajaid',
	'globalblocking-block-errors' => 'Blokeerimine ei õnnestunud {{PLURAL:$1|järgneval põhjusel|järgnevatel põhjustel}}:',
	'globalblocking-block-ipinvalid' => 'Sisestatud IP aadress $1 on vigane.
Pane tähele, et kasutajanime ei saa sisestada.',
	'globalblocking-block-expiryinvalid' => 'Valitud tähtaeg ($1) on vigane.',
	'globalblocking-block-submit' => 'Blokeeri see IP-aadress globaalselt',
	'globalblocking-modify-submit' => 'Muuda seda globaalset blokeeringut',
	'globalblocking-block-success' => 'IP-aadress $1 on edukalt blokeeritud kõigis projektides.',
	'globalblocking-modify-success' => 'Kasutaja $1 globaalne blokeering on edukalt muudetud',
	'globalblocking-block-successsub' => 'Globaalne blokeering õnnestus',
	'globalblocking-modify-successsub' => 'Globaalse blokeeringu muudatused õnnestusid',
	'globalblocking-block-alreadyblocked' => 'IP-aadress $1 on juba globaalselt blokeeritud.
Sa saad [[Special:GlobalBlockList|globaalsete blokeeringute nimekirjas]] olemasolevat blokeeringut vaatada või selle vormi taasesitamisega olemasoleva blokeeringu seadeid muuta.',
	'globalblocking-list-intro' => 'Siin on loetletud globaalsed blokeeringud, mis on praegu jõus.
Mõned blokeeringud on märgitud kui siin vikis välja lülitatud – see tähendab, et blokeering kehtib teistes vikides, aga siinne administraator on otsustanud, et siin pole vastavat blokeeringut vaja.',
	'globalblocking-list' => 'Globaalselt blokeeritud IP-aadresside loend',
	'globalblocking-search-legend' => 'Globaalse blokeeringu otsimine',
	'globalblocking-search-ip' => 'IP-aadress:',
	'globalblocking-search-submit' => 'Otsi blokeeringuid',
	'globalblocking-list-ipinvalid' => 'Otsitud IP-aadress $1 on vigane.
Palun sisesta õige IP-aadress.',
	'globalblocking-search-errors' => 'Su otsing oli {{PLURAL:$1|järgmisel põhjusel|järgmistel põhjustel}} edutu:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') blokeeris globaalselt kasutaja [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'tähtaeg $1',
	'globalblocking-list-anononly' => 'ainult nimetuna',
	'globalblocking-list-unblock' => 'eemalda',
	'globalblocking-list-whitelisted' => '$1 lülitas siin vikis blokeeringu välja: $2',
	'globalblocking-list-whitelist' => 'kohalik olek',
	'globalblocking-list-modify' => 'muuda',
	'globalblocking-goto-block' => 'Blokeeri IP-aadress globaalselt',
	'globalblocking-goto-unblock' => 'Eemalda globaalne blokeering',
	'globalblocking-goto-status' => 'Muuda globaalse blokeeringu kohalikku olekut',
	'globalblocking-return' => 'Naase blobaalsete blokeeringute loendisse',
	'globalblocking-notblocked' => 'Sisestatud IP-aadress $1 ei ole globaalselt blokeeritud.',
	'globalblocking-unblock' => 'Eemalda globaalne blokeering',
	'globalblocking-unblock-ipinvalid' => 'Sisestatud IP-aadress $1 on vigane.
Pane tähele, et kasutajanime ei saa sisestada!',
	'globalblocking-unblock-legend' => 'Eemalda globaalne blokeering',
	'globalblocking-unblock-submit' => 'Eemalda globaalne blokeering',
	'globalblocking-unblock-reason' => 'Põhjus:',
	'globalblocking-unblock-unblocked' => "Globaalne blokeering #$2 on IP-aadressilt '''$1''' edukalt eemaldatud",
	'globalblocking-unblock-errors' => 'Globaalse blokeeringu eemaldamine oli {{PLURAL:$1|järgneval põhjusel|järgnevatel põhjustel}} edutu:',
	'globalblocking-unblock-successsub' => 'Globaalne blokeering edukalt eemaldatud',
	'globalblocking-unblock-subtitle' => 'Globaalse blokeeringu eemaldamine',
	'globalblocking-unblock-intro' => 'Seda vormi kasutades saab globaalse blokeeringu eemaldada.',
	'globalblocking-whitelist' => 'Globaalsete blokeeringute kohalik olek',
	'globalblocking-whitelist-notapplied' => 'Globaalseid blokeeringuid ei ole selles vikis rakendatud,
seega ei saa globaalsete blokeeringute kohalikku olekut muuta.',
	'globalblocking-whitelist-legend' => 'Kohaliku oleku muutmine',
	'globalblocking-whitelist-reason' => 'Põhjus:',
	'globalblocking-whitelist-status' => 'Kohalik olek:',
	'globalblocking-whitelist-statuslabel' => 'Tühista see globaalne blokeering {{GRAMMAR:inessive|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Muuda kohalikku olekut',
	'globalblocking-whitelist-whitelisted' => "IP-aadressi '''$1''' globaalne blokeering #$2 on võrgukohas {{SITENAME}} edukalt välja lülitatud.",
	'globalblocking-whitelist-dewhitelisted' => "IP-aadressi '''$1''' globaalne blokeering #$2 on taas võrgukohas {{SITENAME}} edukalt sisse lülitatud.",
	'globalblocking-whitelist-successsub' => 'Kohalik olek edukalt muudetud',
	'globalblocking-whitelist-nochange' => 'Selle blokeeringu kohalikku olektud ei muudetud.
[[Special:GlobalBlockList|Naase globaalsete blokeeringute nimekirja]].',
	'globalblocking-whitelist-errors' => 'Globaalse blokeeringu kohaliku oleku muutmine ebaõnnestus {{PLURAL:$1|järgneval põhjusel|järgnevatel põhjustel}}:',
	'globalblocking-whitelist-intro' => 'Seda vormi saab kasutada globaalse blokeeringu kohaliku oleku muutmiseks.
Kui globaalne blokeering on selles vikis välja lülitatud, saavad kasutajad selle IP-aadressi alt tavapäraselt toimetada.
[[Special:GlobalBlockList|Naase globaalsete blokeeringute nimekirja]].',
	'globalblocking-blocked' => "'''$1''' (''$2'') on sinu IP-aadressi $5 kõigis vikides blokeerinud.
Põhjus: ''$3''
Kehtivus: ''$4''",
	'globalblocking-blocked-nopassreset' => 'Sa ei saa kasutaja salasõna lähtestada, sest oled globaalselt blokeeritud.',
	'globalblocking-logpage' => 'Globaalne blokeerimislogi',
	'globalblocking-logpagetext' => 'Siin logis on selles vikis üles seatud ja eemaldatud globaalsed blokeeringud.
Tuleks arvesse võtta, et globaalseid blokeeringuid saab teistes vikides üles seada ja eemaldada ning et need globaalsed blokeeringud võivad puudutada ka seda vikit.
Kõigi jõus olevate blokeeringute nägemiseks võid vaadata [[Special:GlobalBlockList|globaalsete blokeeringute nimekirja]].',
	'globalblocking-block-logentry' => 'blokeeris globaalselt kasutaja [[$1]] aegumistähtajaga $2',
	'globalblocking-block2-logentry' => 'blokeeris globaalselt kasutaja [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'eemaldas IP-aadressi [[$1]] globaalse blokeeringu',
	'globalblocking-whitelist-logentry' => 'lülitas kohalikus vikis kasutaja [[$1]] globaalse blokeeringu välja',
	'globalblocking-dewhitelist-logentry' => 'taaskehtestas kohalikult kasutaja [[$1]] globaalse blokeeringu',
	'globalblocking-modify-logentry' => 'muutis kasutaja [[$1]] globaalset blokeeringut ($2)',
	'globalblocking-logentry-expiry' => 'aegub $1',
	'globalblocking-logentry-noexpiry' => 'aegumistähtajata',
	'globalblocking-loglink' => 'IP-aadress $1 on globaalselt blokeeritud ([[{{#Special:GlobalBlockList}}/$1|üksikasjad]]).',
	'globalblocking-showlog' => 'See IP-aadress on varem blokeeritud.
Allpool on toodud blokeerimislogi:',
	'globalblocklist' => 'Globaalselt blokeeritud IP-aadresside loend',
	'globalblock' => 'Blokeeri IP-aadress globaalselt',
	'globalblockstatus' => 'Globaalsete blokeeringute kohalik olek',
	'removeglobalblock' => 'Eemalda globaalne blokeering',
	'right-globalblock' => 'Blokeerida globaalselt',
	'right-globalunblock' => 'Eemaldada globaalseid blokeeringuid',
	'right-globalblock-whitelist' => 'Kohalikus vikis globaalseid blokeeringuid välja lülitada',
	'right-globalblock-exempt' => 'Mööduda globaalsetest blokeeringutest',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Joxemai
 * @author Kobazulo
 */
$messages['eu'] = array(
	'globalblocking-block-reason' => 'Arrazoia:',
	'globalblocking-block-reasonotherlist' => 'Beste arrazoi bat',
	'globalblocking-block-expiry' => 'Iraungipena:',
	'globalblocking-block-options' => 'Aukerak:',
	'globalblocking-ipaddress' => 'IP helbidea:',
	'globalblocking-search-legend' => 'Blokeo global bat bilatu',
	'globalblocking-search-ip' => 'IP helbidea:',
	'globalblocking-search-submit' => 'Blokeoak bilatu',
	'globalblocking-list-anononly' => 'anonimoak bakarrik',
	'globalblocking-list-unblock' => 'kendu',
	'globalblocking-list-modify' => 'aldatu',
	'globalblocking-goto-unblock' => 'Blokeo global bat kendu',
	'globalblocking-unblock' => 'Blokeo global bat kendu',
	'globalblocking-unblock-legend' => 'Blokeo global bat kendu',
	'globalblocking-unblock-submit' => 'Blokeo globala kendu',
	'globalblocking-unblock-reason' => 'Arrazoia:',
	'globalblocking-unblock-successsub' => 'Blokeo globala ongi kendu da',
	'globalblocking-unblock-subtitle' => 'Blokeo globala kentzen',
	'globalblocking-whitelist-reason' => 'Arrazoia:',
);

/** Persian (فارسی)
 * @author Bersam
 * @author Ebraminio
 * @author Huji
 * @author Ladsgroup
 * @author Leyth
 * @author Mardetanha
 * @author Sahim
 * @author Wayiran
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'globalblocking-desc' => 'قطع دسترسی نشانی‌های اینترنتی [[Special:GlobalBlockList|در چندین ویکی]] را [[Special:GlobalBlock|ممکن می‌سازد]]',
	'globalblocking-block' => 'قطع دسترسی یک نشانی آی‌پی به صورت سراسری',
	'globalblocking-modify-intro' => 'می‌توانید از این فرم برای تغییر تنظیمات بستن سراسری استفاده کنید.',
	'globalblocking-block-intro' => 'شما می‌توانید از این صفحه برای قطع دسترسی یک نشانی آی‌پی در تمام ویکی‌ها استفاده کنید.',
	'globalblocking-block-reason' => 'دلیل:',
	'globalblocking-block-otherreason' => 'دلیل دیگر/اضافی:',
	'globalblocking-block-reasonotherlist' => 'دیگر دلایل',
	'globalblocking-block-reason-dropdown' => '* دلیل‌های متداول بستن
** هرزه‌نگاری در چند ویکی
** فحاشی در چند ویکی
** خرابکاری',
	'globalblocking-block-edit-dropdown' => 'ویرایش دلایل قطع‌دسترسی',
	'globalblocking-block-expiry' => 'زمان سرآمدن:',
	'globalblocking-block-expiry-other' => 'زمان‌ خاتمه دیگر',
	'globalblocking-block-expiry-otherfield' => 'زمانی دیگر:',
	'globalblocking-block-legend' => 'قطع دسترسی نشانی یک آی‌پی به صورت سراسری',
	'globalblocking-block-options' => 'گزینه‌ها:',
	'globalblocking-ipaddress' => 'نشانی آی‌پی:',
	'globalblocking-ipbanononly' => 'فقط بستن کاربران گمنام',
	'globalblocking-block-errors' => 'قطع دسترسی شما به این {{PLURAL:$1|دلیل|دلایل}} ناموفق بود:',
	'globalblocking-block-ipinvalid' => 'نشانی آی‌پی که وارد کردید ($1) غیر مجاز است.
توجه داشته باشید که شما نمی‌توانید یک نام کاربری را وارد کنید!',
	'globalblocking-block-expiryinvalid' => 'زمان خاتمه‌ای که وارد کردید ($1) غیر مجاز است.',
	'globalblocking-block-submit' => 'قطع دسترسی سراسری این نشانی آی‌پی',
	'globalblocking-modify-submit' => 'اصلاح این بستن سراسری',
	'globalblocking-block-success' => 'دسترسی نشانی آی‌پی $1 با موفقیت در تمام پروژه‌ها قطع شد.',
	'globalblocking-modify-success' => 'بستن سراسری $1 با موفقیت تغییر یافت',
	'globalblocking-block-successsub' => 'قطع دسترسی سراسری موفق بود',
	'globalblocking-modify-successsub' => 'بستن سراسری با موفقیت تغییر یافت',
	'globalblocking-block-alreadyblocked' => 'دسترسی نشانی آی‌پی $1 از قبل به طور سراسری بسته است.
شما می‌توانید قطع دسترسی موجود را در [[Special:GlobalBlockList|فهرست قطع دسترسی‌های سراسری]] ببینید،
یا تنظیمات قطع دسترسی فعلی را با ارسال دوباره این فرم تغییر دهید.',
	'globalblocking-block-bigrange' => 'بازه‌ای که شما معین کردید ($1) بیش از اندازه بزرگ است.
شما حداکثر می‌توانید ۶۵۵۳۶ نشانی (یک بازه ‎/16) را غیر فعال کنید.',
	'globalblocking-list-intro' => 'این فهرستی از تمام قطع دسترسی‌های سراسری است که در حال حاضر فعال هستند.
برخی قطع دسترسی‌ها ممکن است به طور محلی غیر فعال شده باشند: این به آن معنی است که آن‌ها روی دیگر وبگاه‌ها اثر می‌گذارند، اما یک مدیر محلی تصمیم گرفته‌است که آن‌ها را در این ویکی غیرفعال کند.',
	'globalblocking-list' => 'فهرست نشانی‌های اینترنتی که دسترسی‌شان به طور سراسری قطع شده‌است',
	'globalblocking-search-legend' => 'جستجو برای یک قطع دسترسی سراسری',
	'globalblocking-search-ip' => 'نشانی آی‌پی:',
	'globalblocking-search-submit' => 'جستجوی قطع دسترسی‌ها',
	'globalblocking-list-ipinvalid' => 'نشانی آی‌پی که شما جستجو کردید ($1) غیر مجاز است.
لطفاً یک نشانی آی‌پی مجاز وارد کنید.',
	'globalblocking-search-errors' => 'جستجوی شما به {{PLURAL:$1|دلیل|دلایل}} روبرو ناموفق بود:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') دسترسی [[Special:Contributions/\$4|\$4]] ''(\$5)'' را به طور سراسری بست",
	'globalblocking-list-expiry' => 'خاتمه $1',
	'globalblocking-list-anononly' => 'فقط کاربران گمنام',
	'globalblocking-list-unblock' => 'حذف',
	'globalblocking-list-whitelisted' => 'توسط $1: $2 به طور محلی غیر فعال شد',
	'globalblocking-list-whitelist' => 'وضعیت محلی',
	'globalblocking-list-modify' => 'تغییر',
	'globalblocking-list-noresults' => 'آی‌پی درخواست شده مسدود نمی‌باشد.',
	'globalblocking-goto-block' => 'قطع دسترسی سراسری یک نشانی آی‌پی',
	'globalblocking-goto-unblock' => 'حذف یک قطع دسترسی سراسری',
	'globalblocking-goto-status' => 'تغییر وضعیت محلی یک قطع دسترسی سراسری',
	'globalblocking-return' => 'بازگشت به فهرست قطع دسترسی‌های سراسری',
	'globalblocking-notblocked' => 'دسترسی نشانی آی‌پی که وارد کردید ($1) به طور سراسری بسته نیست.',
	'globalblocking-unblock' => 'حذف یک قطع دسترسی سراسری',
	'globalblocking-unblock-ipinvalid' => 'نشانی آی‌پی که وارد کردید ($1) غیر مجاز است.
لطفاً توجه داشته باشید که نمی‌تواند یک نام کاربری را وارد کنید.',
	'globalblocking-unblock-legend' => 'حذف یک قطع دسترسی سراسری',
	'globalblocking-unblock-submit' => 'حذف قطع دصترسی سراسری',
	'globalblocking-unblock-reason' => 'دلیل:',
	'globalblocking-unblock-unblocked' => "شما با موفقیت قطع دسترسی سراسری شماره $2 را از نشانی آی‌پی '''$1''' برداشتید",
	'globalblocking-unblock-errors' => 'حذف قطع دسترسی سراسری به {{PLURAL:$1|دلیل|دلایل}} روبرو ناموفق بود:',
	'globalblocking-unblock-successsub' => 'قطع دسترسی سراسری با موفقیت حذف شد',
	'globalblocking-unblock-subtitle' => 'حذف قطع دسترسی سراسری',
	'globalblocking-unblock-intro' => 'شما می‌توانید این فرم را برای حذف یک قطع دسترسی سراسری استفاده کنید.',
	'globalblocking-whitelist' => 'وضعیت محلی قطع دسترسی‌های سراسری',
	'globalblocking-whitelist-notapplied' => 'بستن‌های سراسری در این ویکی اعمال نشده است،
بنابراین وضعیت محلی بستن‌های سراسری را نمی‌توان تغییر داد.',
	'globalblocking-whitelist-legend' => 'تغییر وضعیت محلی',
	'globalblocking-whitelist-reason' => 'دلیل:',
	'globalblocking-whitelist-status' => 'وضعیت محلی:',
	'globalblocking-whitelist-statuslabel' => 'غیر فعال کردن قطع دسترسی سراسری در {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'تغییر وضعیت محلی',
	'globalblocking-whitelist-whitelisted' => "شما با موفقیت قطع دسترسی شماره $2 را روی نشانی آی‌پی '''$1''' در {{SITENAME}} غیر فعال کردید.",
	'globalblocking-whitelist-dewhitelisted' => "شما با موفقیت قطع دسترسی شماره $2 را روی نشانی آی‌پی '''$1''' در {{SITENAME}} دوباره فعال کردید.",
	'globalblocking-whitelist-successsub' => 'وضعیت محلی به طور موفق تغییر یافت',
	'globalblocking-whitelist-nochange' => 'شما تغییری در وضعیت محلی این قطع دسترسی سراسری ایجاد نکردید
[[Special:GlobalBlockList|بازگشت به فهرست قطع دسترسی های سراسری]].',
	'globalblocking-whitelist-errors' => 'تغییری که شما در وضعیت محلی یک قطع دسترسی سراسری ایجاد کردید به {{PLURAL:$1|دلیل|دلایل}} روبرو موفق نبود:',
	'globalblocking-whitelist-intro' => 'شما می‌توانید از این فرم برای ویرایش وضعیت محلی یک قطع دسترسی سراسری استفاده کنید.
اگر یک قطع دسترسی سراسری در این ویکی غیر فعال شود، کاربرهایی که روی نشانی آی‌پی مربوط به آن قرار دارند قادر به ویرایش به صورت معمولی خواهند بود.
[[Special:GlobalBlockList|بازگشت به فهرست قطع دسترسی‌های سراسری]].',
	'globalblocking-blocked' => "دسترسی نشانی آی‌پی شما $5 به تمام ویکی‌ها توسط '''$1''' (''$2'') قطع شده‌است.
دلیل ارائه شده این است: ''«$3»''.
این قطع دسترسی ''$4''.",
	'globalblocking-blocked-nopassreset' => 'شما نمی‌توانید کلمات عبور کاربران را تغییر دهید زیرا شما به صورت سراسری مسدود شده‌اید.',
	'globalblocking-logpage' => 'سیاههٔ قطع دسترسی سراسری',
	'globalblocking-logpagetext' => 'این یک سیاهه از قطع دسترسی‌های سراسری است که در این ویکی ایجاد و حذف شده‌اند.
باید توجه داشت که قطع دسترسی‌های سراسری می‌تواند در ویکی‌های دیگر ایجاد یا حذف شود، و چنین قطع دسترسی‌هایی می‌تواند در این ویکی تاثیر بگذارد.
برای مشاهدهٔ تمام قطع دسترسی‌های سراسری فعال، شما می‌توانید [[Special:GlobalBlockList|فهرست قطع دسترسی‌های سراسری]] را ببینید.',
	'globalblocking-block-logentry' => 'دسترسی [[$1]] را تا $2 به طور سراسری قطع کرد',
	'globalblocking-block2-logentry' => 'دسترسی [[$1]] را به طور سراسری قطع کرد ($2)',
	'globalblocking-unblock-logentry' => 'قطع دسترسی سراسری [[$1]] را حذف کرد',
	'globalblocking-whitelist-logentry' => 'قطع دسترسی سراسری [[$1]] را به طور محلی غیر فعال کرد',
	'globalblocking-dewhitelist-logentry' => 'قطع دسترسی سراسری [[$1]] را به طور محلی دوباره فعال کرد',
	'globalblocking-modify-logentry' => 'قطع دسترسی سراسری [[$1]] را تغییر داد ($2)',
	'globalblocking-logentry-expiry' => 'انقضا $1',
	'globalblocking-logentry-noexpiry' => 'هیچ انقضایی تنظیم نشده',
	'globalblocking-loglink' => 'آدرس آی‌پی $1 به صورت سراسری مسدود شده‌است ([[{{#Special:GlobalBlockList}}/$1|جزئیات کامل]]).',
	'globalblocking-showlog' => 'این نشانی آی‌پی قبلاً بسته شده‌است.
سیاههٔ قطع دسترسی در زیر نمایش یافته‌است:',
	'globalblocklist' => 'فهرست نشانی‌های اینترنتی بسته شده به طور سراسری',
	'globalblock' => 'قطع دصترسی سراسری یک نشانی آی‌پی',
	'globalblockstatus' => 'وضعیت محلی قطع‌ دسترسی‌های سراسری',
	'removeglobalblock' => 'حذف یک قطع دسترسی سراسری',
	'right-globalblock' => 'ایجاد قطع دسترسی‌های سراسری',
	'right-globalunblock' => 'حذف قطع دسترسی‌های سراسری',
	'right-globalblock-whitelist' => 'غیر فعال کردن قطع دسترسی‌های سراسری به طور محلی',
	'right-globalblock-exempt' => 'گذرگاه قطع دسترسی‌های سراسری',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Nedergard
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Tarmo
 */
$messages['fi'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Mahdollistaa]] IP-osoitteiden [[Special:GlobalBlockList|estämisen useasta wikistä kerralla]].',
	'globalblocking-block' => 'Estä IP-osoite globaalisti',
	'globalblocking-modify-intro' => 'Voit käyttää tätä lomaketta muuttaaksesi globaaliestojen asetuksia.',
	'globalblocking-block-intro' => 'Voit käyttää tätä sivua IP-osoitteen estämiseen kaikista wikeistä.',
	'globalblocking-block-reason' => 'Syy',
	'globalblocking-block-otherreason' => 'Muu syy tai tarkennus',
	'globalblocking-block-reasonotherlist' => 'Muu syy',
	'globalblocking-block-reason-dropdown' => '* Yleiset estosyyt
** Usean wikin sotkeminen
** Usean wikin väärinkäyttö
** Vandalismi',
	'globalblocking-block-edit-dropdown' => 'Muokkaa estosyitä',
	'globalblocking-block-expiry' => 'Kesto',
	'globalblocking-block-expiry-other' => 'Muu kestoaika',
	'globalblocking-block-expiry-otherfield' => 'Muu aika',
	'globalblocking-block-legend' => 'Estä IP-osoite globaalisti',
	'globalblocking-block-options' => 'Asetukset',
	'globalblocking-ipaddress' => 'IP-osoite:',
	'globalblocking-ipbanononly' => 'Estä vain kirjautumattomat käyttäjät',
	'globalblocking-block-errors' => 'Esto epäonnistui {{PLURAL:$1|seuraavan syyn|seuraavien syiden}} takia:',
	'globalblocking-block-ipinvalid' => 'Antamasi IP-osoite $1 oli virheellinen.
Huomaathan ettet voi syöttää käyttäjätunnusta.',
	'globalblocking-block-expiryinvalid' => 'Antamasi eston kesto ”$1” oli virheellinen.',
	'globalblocking-block-submit' => 'Estä tämä IP-osoite globaalisti',
	'globalblocking-modify-submit' => 'Muuta tätä globaaliestoa',
	'globalblocking-block-success' => 'IP-osoite $1 on estetty kaikissa projekteissa.',
	'globalblocking-modify-success' => 'Käyttäjän $1 globaaliestoa on onnistuneesti muutettu',
	'globalblocking-block-successsub' => 'Globaaliesto onnistui',
	'globalblocking-modify-successsub' => 'Globaaliestoa muutettu onnistuneesti',
	'globalblocking-block-alreadyblocked' => 'IP-osoite $1 on jo estetty globaalisti.
Voit tarkastella estoa [[Special:GlobalBlockList|globaalien estojen luettelosta]]
tai muokata nykyisen eston asetuksia lähettämällä tämän lomakkeen uudelleen.',
	'globalblocking-block-bigrange' => 'Antamasi osoiteavaruus $1 on liian suuri. Voit estää korkeintaan 65&nbsp;536 osoitetta kerralla (/16-avaruus)',
	'globalblocking-list-intro' => 'Tämä lista sisältää kaikki voimassa olevat globaalit estot. Jotkut estoista on saatettu merkitä paikallisesti poiskytketyiksi: tämä tarkoittaa että esto on voimassa muilla sivustoilla, mutta paikallinen ylläpitäjä on päättänyt poiskytkeä eston paikallisesta wikistä.',
	'globalblocking-list' => 'Globaalisti estetyt IP-osoitteet',
	'globalblocking-search-legend' => 'Etsi globaaleja estoja',
	'globalblocking-search-ip' => 'IP-osoite',
	'globalblocking-search-submit' => 'Etsi estoja',
	'globalblocking-list-ipinvalid' => 'Haettu IP-osoite $1 oli virheellinen.
Anna kelvollinen IP-osoite.',
	'globalblocking-search-errors' => 'Haku epäonnistui {{PLURAL:$1|seuraavasta syystä|seuraavista syistä}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') esti globaalisti käyttäjän [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'päättyy $1',
	'globalblocking-list-anononly' => 'vain anonyymit',
	'globalblocking-list-unblock' => 'poista',
	'globalblocking-list-whitelisted' => 'paikallisesti poiskytketty käyttäjän $1 toimesta: $2',
	'globalblocking-list-whitelist' => 'paikallinen tila',
	'globalblocking-list-modify' => 'muuta',
	'globalblocking-list-noresults' => 'Pyydettyä IP-osoitetta ei ole estetty.',
	'globalblocking-goto-block' => 'Estä IP-osoite globaalisti',
	'globalblocking-goto-unblock' => 'Poista globaaliesto',
	'globalblocking-goto-status' => 'Vaihda globaalin eston paikallista tilaa',
	'globalblocking-return' => 'Palaa globaalien estojen listaan',
	'globalblocking-notblocked' => 'Antamasi IP-osoite $1 ei ole globaalisti estetty.',
	'globalblocking-unblock' => 'Poista globaaliesto',
	'globalblocking-unblock-ipinvalid' => 'Antamasi IP-osoite $1 oli virheellinen.
Huomaathan ettet voi syöttää käyttäjätunnusta!',
	'globalblocking-unblock-legend' => 'Globaalieston poisto',
	'globalblocking-unblock-submit' => 'Poista globaaliesto',
	'globalblocking-unblock-reason' => 'Syy',
	'globalblocking-unblock-unblocked' => "IP-osoitteen '''$1''' globaaliesto #$2 poistettu onnistuneesti",
	'globalblocking-unblock-errors' => 'Globaalin eston poisto epäonnistui {{PLURAL:$1|seuraavan syyn|seuraavien syiden}} takia:',
	'globalblocking-unblock-successsub' => 'Globaaliesto poistettu onnistuneesti',
	'globalblocking-unblock-subtitle' => 'Globaalieston poisto',
	'globalblocking-unblock-intro' => 'Voit käyttää tätä lomaketta globaalin eston poistamiseksi.',
	'globalblocking-whitelist' => 'Globaalien estojen paikallinen tila',
	'globalblocking-whitelist-notapplied' => 'Globaaliestoja ei sovelleta tässä wikissä, 
joten paikallisten globaaliestojen tilaa ei voi muuttaa.',
	'globalblocking-whitelist-legend' => 'Vaihda paikallinen tila',
	'globalblocking-whitelist-reason' => 'Syy',
	'globalblocking-whitelist-status' => 'Paikallinen tila:',
	'globalblocking-whitelist-statuslabel' => 'Poiskytke tämä globaaliesto {{GRAMMAR:elative|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Vaihda paikallinen tila',
	'globalblocking-whitelist-whitelisted' => "IP-osoitteen '''$1''' globaalieston #$2 poiskytkentä {{GRAMMAR:inessive|{{SITENAME}}}} onnistui.",
	'globalblocking-whitelist-dewhitelisted' => "IP-osoitteen '''$1''' globaalin eston #$2 uudelleenkytkentä {{GRAMMAR:inessive|{{SITENAME}}}} onnistui.",
	'globalblocking-whitelist-successsub' => 'Paikallinen tila vaihdettu onnistuneesti',
	'globalblocking-whitelist-nochange' => 'Et tehnyt muutoksia tämän eston paikalliseen tilaan. [[Special:GlobalBlockList|Voit myös palata globaaliestojen listaan]].',
	'globalblocking-whitelist-errors' => 'Globaalin eston paikallisen tilan muuttaminen epäonnistui {{PLURAL:$1|seuraavan syyn|seuraavien syiden}} takia:',
	'globalblocking-whitelist-intro' => 'Voit käyttää tätä lomaketta globaalieston paikallisen tilan muokkaamiseksi. Jos globaaliesto on poiskytetty tästä wikistä, IP-osoitetta käyttävät käyttäjät voivat muokata normaalisti. [[Special:GlobalBlockList|Napsauta tästä]] palataksesi takaisin globaalien estojen listaan.',
	'globalblocking-blocked' => "'''$1''' (''$2'') on estänyt IP-osoitteesi $5 kaikissa wikeissä.
Syy: ''$3''
Esto: ''$4''",
	'globalblocking-blocked-nopassreset' => 'Et voi palauttaa käyttäjien salasanoja, koska sinut on estetty globaalisti.',
	'globalblocking-logpage' => 'Globaaliestoloki',
	'globalblocking-logpagetext' => 'Tämä on loki tässä wikissä tehdyistä ja poistetuista globaaliestoista.
Globaaliestoja voi tehdä ja poistaa myös muissa wikeissä, ja ne voivat vaikuttaa tähän wikiin.
Kaikki voimassa olevat globaaliestot ovat [[Special:GlobalBlockList|globaaliestojen listalla]].',
	'globalblocking-block-logentry' => 'globaalisti estetty [[$1]], vanhenemisaika $2',
	'globalblocking-block2-logentry' => 'esti globaalisti käyttäjän [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'poisti IP-osoitteen [[$1]] globaalin eston',
	'globalblocking-whitelist-logentry' => 'kytki globaalin eston [[$1]] pois paikallisesti',
	'globalblocking-dewhitelist-logentry' => 'kytki globaalin eston [[$1]] uudelleen paikallisesti',
	'globalblocking-modify-logentry' => 'muutti globaaliestoa käyttäjälle [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'vanhenee $1',
	'globalblocking-logentry-noexpiry' => 'vanhentumisaikaa ei asetettu',
	'globalblocking-loglink' => 'IP-osoite $1 on estetty globaalisti ([[{{#Special:GlobalBlockList}}/$1|tiedot]]).',
	'globalblocking-showlog' => 'Tämä IP-osoite on ollut estettynä.
Alla on ote estolokista.',
	'globalblocklist' => 'Globaalisti estetyt IP-osoitteet',
	'globalblock' => 'Estä IP-osoite globaalisti',
	'globalblockstatus' => 'Globaalien estojen paikallinen tila',
	'removeglobalblock' => 'Poista globaaliesto',
	'right-globalblock' => 'Estää globaalisti',
	'right-globalunblock' => 'Poistaa globaaleja estoja',
	'right-globalblock-whitelist' => 'Poiskytkeä globaaleja estoja paikallisesti',
	'right-globalblock-exempt' => 'Ohittaa globaaliestot',
);

/** Faroese (Føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'globalblocking-block' => 'Sperra eina IP adressu globalt',
	'globalblocking-modify-intro' => 'Tú kanst brúka henda formularin fyri at broyta innstillingarnar fyri eina globala blokkadu.',
	'globalblocking-block-intro' => 'Tú kanst brúka hesa síðu fyri at sperra eina IP adressu á øllum wikium.',
	'globalblocking-block-reason' => 'Orsøk:',
	'globalblocking-block-otherreason' => 'Onnur orsøk:',
	'globalblocking-block-reasonotherlist' => 'Onnur orsøk',
	'globalblocking-block-reason-dropdown' => '* Vanligar orsøkir fyri sperring
** Spamming á fleiri wikium
** Misnýtsla á fleiri wikium
** Herverk (vandalisma)',
	'globalblocking-block-edit-dropdown' => 'Rætta orsøkir fyri sperring',
	'globalblocking-block-expiry' => 'Gongur út:',
	'globalblocking-block-expiry-other' => 'Onnur tíð sum gongur út',
	'globalblocking-block-expiry-otherfield' => 'Onnur tíð:',
	'globalblocking-block-legend' => 'Sperra eina IP adressu globalt',
	'globalblocking-block-options' => 'Møguleikar:',
	'globalblocking-ipaddress' => 'IP-adressa:',
	'globalblocking-ipbanononly' => 'Sperra bert dulnevndir brúkarar',
	'globalblocking-block-errors' => 'Tín sperring miseydnaðist, orsakað av fylgjandi {{PLURAL:$1|orsøk|orsøkum}}:',
	'globalblocking-block-ipinvalid' => 'IP adressan ($1) sum tú tastaði inn er ógyldug.
Vinarliga legg til merkis at tú kanst ikki inntasta eitt brúkaranavn!',
	'globalblocking-block-expiryinvalid' => 'Tann tíðin sum tú hevur skrivað ($1) at ganga út er ógyldug.',
	'globalblocking-block-submit' => 'Sperra hesa IP adressuna globalt',
	'globalblocking-modify-submit' => 'Broyt hesa globalu sperring',
	'globalblocking-block-success' => 'IP adressan $1 er blivin sperrað við hepni á øllum verkætlanum.',
	'globalblocking-modify-success' => 'Globala sperringin á $1 er blivin broytt.',
	'globalblocking-block-successsub' => 'Global sperring eydnaðist',
	'globalblocking-modify-successsub' => 'Tað eydnaðist at broyta globalu sperringina',
	'globalblocking-block-alreadyblocked' => 'IP adressan $1 er longu sperrað globalt.
Tú kanst síggja verandi sperring á [[Special:GlobalBlockList|lista við globalum sperringum]],
ella broyta innstillingarnar á verandi sperring við at senda henda formularin enn einaferð.',
	'globalblocking-block-bigrange' => 'Røðin sum tú skrivaði ($1) er ov stórt til sperring.
Tú kanst í mesta lagi sperra 65.536 adressur (/16 intervallir)',
	'globalblocking-search-ip' => 'IP adressa:',
	'globalblocking-search-submit' => 'Leita eftir sperringum',
	'globalblocking-list-ipinvalid' => 'IP adressan, sum tú leitaði eftir ($1) er ógildug.
Vinarliga skriva eina gylduga IP adressu.',
	'globalblocking-search-errors' => 'Tín leitan gav onki úrslit av fylgjandi {{PLURAL:$1|orsøk|orsøkum}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') sperraði globalt [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'gongur út $1',
	'globalblocking-list-anononly' => 'bert dulnevnd',
	'globalblocking-list-unblock' => 'tak burtur',
	'globalblocking-list-whitelisted' => 'sligið frá lokalt av $1: $2',
	'globalblocking-list-whitelist' => 'lokalur status',
	'globalblocking-list-modify' => 'broyt',
	'globalblocking-list-noresults' => 'Umbidnað IP adressan er ikki sperrað.',
	'globalblocking-goto-block' => 'Sperra eina IP adressu globalt',
	'globalblocking-goto-unblock' => 'Tak burtur globala sperring',
	'globalblocking-unblock-legend' => 'Tak burtur eina globala sperring',
	'globalblocking-unblock-submit' => 'Tak burtur globala sperring',
	'globalblocking-unblock-reason' => 'Orsøk:',
	'globalblocking-unblock-unblocked' => "Tað eydnaðist tær at taka burtur globalu sperringina #$2 á IP adressu '''$1'''",
	'globalblocking-whitelist-reason' => 'Orsøk:',
	'globalblocking-whitelist-status' => 'Lokalur status:',
	'globalblocking-whitelist-statuslabel' => 'Tak burtur globala sperring á {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Broyt lokala støðu',
	'globalblocking-whitelist-whitelisted' => "Tað eydnaðist tær at taka burtur globala sperring #$2 á IP adressuni '''$1''' á {{SITENAME}}.",
	'globalblocking-blocked-nopassreset' => 'Tú kanst ikki nullstilla loyniorð hjá brúkarum, tí tú ert sperrað/ur globalt.',
	'globalblocking-logpage' => 'Globalut sperringsloggur',
	'globalblocking-block-logentry' => 'global sperring [[$1]] sum gongur út $2',
	'globalblocking-block2-logentry' => 'globalt blokkerað/ur [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'tók burtur globala sperring á',
	'globalblocking-loglink' => 'IP adressan $1 er sperrað globalt ([[{{#Special:GlobalBlockList}}/$1|sí fullfíggjaða kunning]]).',
	'globalblocking-showlog' => 'Henda IP adressan er áður blivin sperrað.
Sperringarloggurin er her niðanfyri fyri ávísing:',
	'globalblocklist' => 'Listi við globalt sperraðum IP adressum',
	'globalblock' => 'Blokkera IP adressu globalt',
);

/** French (Français)
 * @author Crochet.david
 * @author Gomoko
 * @author Grondin
 * @author IAlex
 * @author Peter17
 * @author PieRRoMaN
 * @author Seb35
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permet]] de bloquer des adresses IP [[Special:GlobalBlockList|à travers plusieurs wikis]]',
	'globalblocking-block' => 'Bloquer globalement une adresse IP',
	'globalblocking-modify-intro' => 'Vous pouvez utiliser ce formulaire pour configurer un blocage global.',
	'globalblocking-block-intro' => 'Vous pouvez utiliser cette page pour bloquer une adresse IP sur l’ensemble des wikis.',
	'globalblocking-block-reason' => 'Motif :',
	'globalblocking-block-otherreason' => 'Motif autre / supplémentaire :',
	'globalblocking-block-reasonotherlist' => 'Autre motif',
	'globalblocking-block-reason-dropdown' => '* Raisons communes de blocage
** Spam sur plusieurs wikis
** Abus sur plusieurs wikis
** Vandalisme',
	'globalblocking-block-edit-dropdown' => 'Modifier les motifs de blocage par défaut',
	'globalblocking-block-expiry' => 'Expiration :',
	'globalblocking-block-expiry-other' => 'Autre durée d’expiration',
	'globalblocking-block-expiry-otherfield' => 'Autre durée :',
	'globalblocking-block-legend' => 'Bloquer globalement une adresse IP',
	'globalblocking-block-options' => 'Options :',
	'globalblocking-ipaddress' => 'Adresse IP :',
	'globalblocking-ipbanononly' => 'Bloquer uniquement les utilisateurs anonymes',
	'globalblocking-block-errors' => 'Le blocage a échoué pour {{PLURAL:$1|la raison suivante|les raisons suivantes}} :',
	'globalblocking-block-ipinvalid' => 'L’adresse IP ($1) que vous avez entrée est incorrecte.
Veuillez noter que vous ne pouvez pas inscrire un nom d’utilisateur !',
	'globalblocking-block-expiryinvalid' => 'La durée d’expiration que vous avez entrée ($1) est incorrecte.',
	'globalblocking-block-submit' => 'Bloquer globalement cette adresse IP',
	'globalblocking-modify-submit' => 'Modifier ce blocage global',
	'globalblocking-block-success' => 'L’adresse IP $1 a été bloquée sur l’ensemble des projets.',
	'globalblocking-modify-success' => 'Le blocage global de $1 a été modifié avec succès',
	'globalblocking-block-successsub' => 'Blocage global réussi',
	'globalblocking-modify-successsub' => 'Blocage global modifié avec succès',
	'globalblocking-block-alreadyblocked' => 'L’adresse IP $1 est déjà bloquée globalement.
Vous pouvez afficher les blocages existants sur la [[Special:GlobalBlockList|liste des blocages globaux]]
ou reconfigurer ce blocage en soumettant de nouveau ce formulaire.',
	'globalblocking-block-bigrange' => 'La plage que vous avez spécifiée ($1) est trop grande pour être bloquée. Vous ne pouvez pas bloquer plus de 65&nbsp;536 adresses.',
	'globalblocking-list-intro' => 'Voici la liste de tous les blocages globaux actifs. Quelques plages sont marquées comme localement désactivées : ceci signifie qu’elles sont appliquées sur d’autres sites, mais qu’un administrateur local a décidé de les désactiver sur ce wiki.',
	'globalblocking-list' => 'Liste des adresses IP bloquées globalement',
	'globalblocking-search-legend' => 'Rechercher un blocage global',
	'globalblocking-search-ip' => 'Adresse IP :',
	'globalblocking-search-submit' => 'Rechercher des blocages',
	'globalblocking-list-ipinvalid' => 'L’adresse IP que vous recherchez pour ($1) est incorrecte.
Veuillez entrez une adresse IP correcte.',
	'globalblocking-search-errors' => 'Votre recherche a été infructueuse pour {{PLURAL:$1|la raison suivante|les raisons suivantes}} :',
	'globalblocking-list-blockitem' => "\$1 : <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') a bloqué globalement [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'expiration $1',
	'globalblocking-list-anononly' => 'uniquement anonyme',
	'globalblocking-list-unblock' => 'débloquer',
	'globalblocking-list-whitelisted' => 'désactivé localement par $1 : $2',
	'globalblocking-list-whitelist' => 'statut local',
	'globalblocking-list-modify' => 'modifier',
	'globalblocking-list-noresults' => 'L’adresse IP demandée n’est pas bloquée.',
	'globalblocking-goto-block' => 'Bloquer globalement une adresse IP',
	'globalblocking-goto-unblock' => 'Enlever un blocage global',
	'globalblocking-goto-status' => 'Modifier le statut local d’un blocage global',
	'globalblocking-return' => 'Retourner à la liste des blocages globaux',
	'globalblocking-notblocked' => 'L’adresse IP ($1) que vous avez indiquée n’est pas bloquée globalement.',
	'globalblocking-unblock' => 'Enlever un blocage global',
	'globalblocking-unblock-ipinvalid' => 'L’adresse IP que vous avez indiquée ($1) est incorrecte.
Veuillez noter que que vous ne pouvez pas entrer un nom d’utilisateur !',
	'globalblocking-unblock-legend' => 'Enlever un blocage global',
	'globalblocking-unblock-submit' => 'Enlever le blocage global',
	'globalblocking-unblock-reason' => 'Motif :',
	'globalblocking-unblock-unblocked' => "Le blocage global n° $2 correspondant à l’adresse IP '''$1''' a été retiré avec succès.",
	'globalblocking-unblock-errors' => 'La suppression du blocage global a échoué pour {{PLURAL:$1|la raison suivante|les raisons suivantes}} :
$1',
	'globalblocking-unblock-successsub' => 'Blocage global retiré avec succès',
	'globalblocking-unblock-subtitle' => 'Suppression du blocage global',
	'globalblocking-unblock-intro' => 'Vous pouvez utiliser ce formulaire pour retirer un blocage global.',
	'globalblocking-whitelist' => 'Statut local des blocages globaux',
	'globalblocking-whitelist-notapplied' => 'Les blocages globaux ne sont pas appliqués à ce wiki,
de ce fait le statut local du blocage global ne peut être modifié.',
	'globalblocking-whitelist-legend' => 'Modifier le statut local',
	'globalblocking-whitelist-reason' => 'Motif :',
	'globalblocking-whitelist-status' => 'État local :',
	'globalblocking-whitelist-statuslabel' => 'Désactiver ce blocage global sur {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Changer le statut local',
	'globalblocking-whitelist-whitelisted' => "Vous avez désactivé avec succès le blocage global n° $2 de l’adresse IP '''$1''' sur {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Vous avez réactivé avec succès le blocage global n° $2 de l’adresse IP '''$1''' sur {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Statut local modifié avec succès',
	'globalblocking-whitelist-nochange' => 'Vous n’avez pas modifié l’état local de ce blocage.
[[Special:GlobalBlockList|Revenir à la liste des blocages globaux]].',
	'globalblocking-whitelist-errors' => 'La modification du statut local d’un blocage global a échoué pour {{PLURAL:$1|la raison suivante|les raisons suivantes}} :',
	'globalblocking-whitelist-intro' => 'Vous pouvez utiliser ce formulaire pour modifier l’état local d’un blocage global.
Si un blocage global est désactivé sur ce wiki, les utilisateurs des adresses IP affectées pourront modifier normalement.
[[Special:GlobalBlockList|Retourner à la liste des bloquages globaux]].',
	'globalblocking-blocked' => "Votre adresse IP $5 a été bloquée sur l’ensemble des wikis par '''$1''' (''$2'').
Le motif indiqué était « $3 ».
Blocage : ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Vous ne pouvez pas réinitialiser les mots de passe d’utilisateur parce que vous êtes bloqué globalement.',
	'globalblocking-logpage' => 'Journal des blocages globaux',
	'globalblocking-logpagetext' => 'Voici un journal des blocages globaux qui ont été faits et retirés sur ce wiki.
Notez que les blocages globaux peuvent être faits ou annulés sur d’autres wikis, et que ces blocages globaux sont de nature à interférer sur ce wiki.
Pour visionner tous les blocages globaux actifs, vous pouvez visiter la [[Special:GlobalBlockList|liste des blocages globaux]].',
	'globalblocking-block-logentry' => 'a bloqué globalement [[$1]] avec une durée d’expiration de $2',
	'globalblocking-block2-logentry' => 'a bloqué globalement [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'a retiré le blocage global de [[$1]]',
	'globalblocking-whitelist-logentry' => 'a désactivé localement le blocage global de [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'a réactivé localement le blocage global de [[$1]]',
	'globalblocking-modify-logentry' => 'a modifié le blocage global de [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'expire le $1',
	'globalblocking-logentry-noexpiry' => 'date d’expiration non spécifiée',
	'globalblocking-loglink' => 'L’adresse IP $1 est bloquée globalement ([[{{#Special:GlobalBlockList}}/$1|détails]]).',
	'globalblocking-showlog' => 'Cette adresse IP a été bloquée antérieurement.
Le journal des blocages est disponible ci-dessous :',
	'globalblocklist' => 'Liste des adresses IP bloquées globalement',
	'globalblock' => 'Bloquer globalement une adresse IP',
	'globalblockstatus' => 'Statuts locaux des blocages globaux',
	'removeglobalblock' => 'Supprimer un blocage global',
	'right-globalblock' => 'Bloquer des utilisateurs globalement',
	'action-globalblock' => 'faire des blocages globaux',
	'right-globalunblock' => "Retirer des blocages globaux d'utilisateurs",
	'action-globalunblock' => 'supprimer des blocages globaux',
	'right-globalblock-whitelist' => 'Désactiver localement des blocages globaux',
	'action-globalblock-whitelist' => 'désactiver localement les blocages globaux',
	'right-globalblock-exempt' => 'Passer outre les blocages globaux',
	'action-globalblock-exempt' => 'passer outre les blocages globaux',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Pèrmèt]] de blocar des adrèces IP [[Special:GlobalBlockList|a travèrs un mouél de vouiquis]].',
	'globalblocking-block' => 'Blocar dens l’ensemblo una adrèce IP',
	'globalblocking-modify-intro' => 'Vos pouede utilisar ceti formulèro por configurar un blocâjo globâl.',
	'globalblocking-block-intro' => 'Vos pouede utilisar ceta pâge por blocar una adrèce IP sur l’ensemblo des vouiquis.',
	'globalblocking-block-reason' => 'Rêson :',
	'globalblocking-block-otherreason' => 'Ôtra rêson / rêson de ples :',
	'globalblocking-block-reasonotherlist' => 'Ôtra rêson',
	'globalblocking-block-reason-dropdown' => '* Rêsons de blocâjo les ples corentes
** Spame sur un mouél de vouiquis
** Abus sur un mouél de vouiquis
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Changiér les rêsons de blocâjo',
	'globalblocking-block-expiry' => 'Èxpiracion :',
	'globalblocking-block-expiry-other' => 'Ôtro temps d’èxpiracion',
	'globalblocking-block-expiry-otherfield' => 'Ôtro temps :',
	'globalblocking-block-legend' => 'Blocar dens l’ensemblo una adrèce IP',
	'globalblocking-block-options' => 'Chouèx :',
	'globalblocking-ipaddress' => 'Adrèce IP :',
	'globalblocking-ipbanononly' => 'Blocar ren que los usanciérs pas encartâs',
	'globalblocking-block-errors' => 'Lo blocâjo at pas reussi por {{PLURAL:$1|ceta rêson|cetes rêsons}} :',
	'globalblocking-block-ipinvalid' => 'L’adrèce IP ($1) que vos éd buchiê est fôssa.
Volyéd notar que vos pouede pas buchiér un nom d’usanciér !',
	'globalblocking-block-expiryinvalid' => 'Lo temps d’èxpiracion que vos éd buchiê ($1) est fôx.',
	'globalblocking-block-submit' => 'Blocar dens l’ensemblo ceta adrèce IP',
	'globalblocking-modify-submit' => 'Changiér ceti blocâjo globâl',
	'globalblocking-block-success' => 'L’adrèce IP $1 at étâ blocâ sur l’ensemblo des projèts.',
	'globalblocking-modify-success' => 'Lo blocâjo globâl de $1 at étâ changiê avouéc reusséta',
	'globalblocking-block-successsub' => 'Blocâjo globâl ben reussi',
	'globalblocking-modify-successsub' => 'Blocâjo globâl changiê avouéc reusséta',
	'globalblocking-block-alreadyblocked' => 'L’adrèce IP $1 est ja blocâ dens l’ensemblo.
Vos pouede fâre vêre los blocâjos ègzistents sur la [[Special:GlobalBlockList|lista des blocâjos globâls]]
ou ben tornar configurar cél blocâjo en tornent sometre ceti formulèro.',
	'globalblocking-block-bigrange' => 'La plage d’adrèces IP que vos éd spècefiâ ($1) est trop granta por étre blocâ.
Vos pouede pas blocar més de 65&nbsp;536 adrèces (plages d’adrèces IP /16)',
	'globalblocking-list-intro' => 'Vê-que la lista de tôs los blocâjos globâls actifs.
Quârques plages sont marcâs coment dèsactivâs localament : cen vôt dére que sont aplicâs sur d’ôtros setos, mas qu’un administrator local at dècidâ de les dèsactivar sur ceti vouiqui.',
	'globalblocking-list' => 'Lista a les adrèces IP blocâs dens l’ensemblo',
	'globalblocking-search-legend' => 'Rechèrchiér un blocâjo globâl',
	'globalblocking-search-ip' => 'Adrèce IP :',
	'globalblocking-search-submit' => 'Rechèrchiér des blocâjos',
	'globalblocking-list-ipinvalid' => 'L’adrèce IP que vos rechèrchiéd por ($1) est fôssa.
Volyéd buchiér una adrèce IP valida.',
	'globalblocking-search-errors' => 'Voutra rechèrche at pas reussia por {{PLURAL:$1|ceta rêson|cetes rêsons}} :',
	'globalblocking-list-blockitem' => "\$1 : <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') at blocâ dens l’ensemblo [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'èxpiracion $1',
	'globalblocking-list-anononly' => 'solament los usanciérs pas encartâs',
	'globalblocking-list-unblock' => 'enlevar',
	'globalblocking-list-whitelisted' => 'dèsactivâ localament per $1 : $2',
	'globalblocking-list-whitelist' => 'statut local',
	'globalblocking-list-modify' => 'changiér',
	'globalblocking-list-noresults' => 'L’adrèce IP demandâ est pas blocâ.',
	'globalblocking-goto-block' => 'Blocar dens l’ensemblo una adrèce IP',
	'globalblocking-goto-unblock' => 'Enlevar un blocâjo globâl',
	'globalblocking-goto-status' => 'Changiér lo statut local d’un blocâjo globâl',
	'globalblocking-return' => 'Tornar a la lista des blocâjos globâls',
	'globalblocking-notblocked' => 'L’adrèce IP ($1) que vos éd buchiê est pas blocâ dens l’ensemblo.',
	'globalblocking-unblock' => 'Enlevar un blocâjo globâl',
	'globalblocking-unblock-ipinvalid' => 'L’adrèce IP ($1) que vos éd buchiê est fôssa.
Volyéd notar que vos pouede pas buchiér un nom d’usanciér !',
	'globalblocking-unblock-legend' => 'Enlevar un blocâjo globâl',
	'globalblocking-unblock-submit' => 'Enlevar lo blocâjo globâl',
	'globalblocking-unblock-reason' => 'Rêson :',
	'globalblocking-unblock-unblocked' => "Vos éd enlevâ avouéc reusséta lo blocâjo globâl n° $2 sur l’adrèce IP '''$1'''",
	'globalblocking-unblock-errors' => 'La suprèssion du blocâjo globâl at pas reussia por {{PLURAL:$1|ceta rêson|cetes rêsons}} :',
	'globalblocking-unblock-successsub' => 'Blocâjo globâl enlevâ avouéc reusséta',
	'globalblocking-unblock-subtitle' => 'Suprèssion du blocâjo globâl',
	'globalblocking-unblock-intro' => 'Vos pouede utilisar ceti formulèro por enlevar un blocâjo globâl.',
	'globalblocking-whitelist' => 'Statut local des blocâjos globâls',
	'globalblocking-whitelist-notapplied' => 'Los blocâjos globâls sont pas aplicâs a ceti vouiqui,
de ceti fêt lo statut local du blocâjo globâl pôt pas étre changiê.',
	'globalblocking-whitelist-legend' => 'Changiér lo statut local',
	'globalblocking-whitelist-reason' => 'Rêson :',
	'globalblocking-whitelist-status' => 'Statut local :',
	'globalblocking-whitelist-statuslabel' => 'Dèsactivar ceti blocâjo globâl dessus {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Changiér lo statut local',
	'globalblocking-whitelist-whitelisted' => "Vos éd dèsactivâ avouéc reusséta lo blocâjo globâl n° $2 sur l’adrèce IP '''$1''' dessus {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Vos éd rèactivâ avouéc reusséta lo blocâjo globâl n° $2 sur l’adrèce IP '''$1''' dessus {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Statut local changiê avouéc reusséta',
	'globalblocking-whitelist-nochange' => 'Vos éd pas changiê lo statut local de ceti blocâjo.
[[Special:GlobalBlockList|Tornar a la lista des blocâjos globâls]].',
	'globalblocking-whitelist-errors' => 'Lo changement du statut local d’un blocâjo globâl at pas reussi por {{PLURAL:$1|ceta rêson|cetes rêsons}} :',
	'globalblocking-whitelist-intro' => 'Vos pouede utilisar ceti formulèro por changiér lo statut local d’un blocâjo globâl.
S’un blocâjo globâl est dèsactivâ sur ceti vouiqui, los usanciérs a les adrèces IP afèctâs porront changiér normalament.
[[Special:GlobalBlockList|Tornar a la lista des blocâjos globâls]].',
	'globalblocking-blocked' => "Voutra adrèce IP $5 at étâ blocâ sur l’ensemblo des vouiquis per '''$1''' (''$2'').
La rêson balyê ére ''« $3 »''.
Blocâjo : ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Vos pouede pas tornar inicialisar los contresegnos d’usanciér perce que vos éte blocâ dens l’ensemblo.',
	'globalblocking-logpage' => 'Jornal des blocâjos globâls',
	'globalblocking-logpagetext' => 'Vê-que lo jornal des blocâjos globâls qu’ont étâ fêts et pués enlevâs sur ceti vouiqui.
Notâd que los blocâjos globâls pôvont étre fêts et pués enlevâs sur d’ôtros vouiquis, et que celos blocâjos globâls pôvont afèctar ceti vouiqui.
Por vêre tôs los blocâjos globâls actifs, vos pouede visitar la [[Special:GlobalBlockList|lista des blocâjos globâls]].',
	'globalblocking-block-logentry' => 'at blocâ dens l’ensemblo [[$1]] avouéc un temps d’èxpiracion de $2',
	'globalblocking-block2-logentry' => 'at blocâ dens l’ensemblo [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'at enlevâ lo blocâjo globâl de [[$1]]',
	'globalblocking-whitelist-logentry' => 'at dèsactivâ localament lo blocâjo globâl de [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'at rèactivâ localament lo blocâjo globâl de [[$1]]',
	'globalblocking-modify-logentry' => 'at changiê lo blocâjo globâl de [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'èxpire lo $1',
	'globalblocking-logentry-noexpiry' => 'temps d’èxpiracion pas spècefiâ',
	'globalblocking-loglink' => 'L’adrèce IP $1 est blocâ dens l’ensemblo ([[{{#Special:GlobalBlockList}}/$1|dètalys]]).',
	'globalblocking-showlog' => 'Ceta adrèce IP at étâ blocâ dês devant.
Lo jornal des blocâjos est disponiblo ce-desot :',
	'globalblocklist' => 'Lista a les adrèces IP blocâs dens l’ensemblo',
	'globalblock' => 'Blocar dens l’ensemblo una adrèce IP',
	'globalblockstatus' => 'Statuts locals des blocâjos globâls',
	'removeglobalblock' => 'Enlevar un blocâjo globâl',
	'right-globalblock' => 'Blocar des usanciérs dens l’ensemblo',
	'right-globalunblock' => 'Enlevar des usanciérs blocâs dens l’ensemblo',
	'right-globalblock-whitelist' => 'Dèsactivar localament los blocâjos globâls',
	'right-globalblock-exempt' => 'Passar per-dessus los blocâjos globâls',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'globalblocking-block-reason' => 'Reson:',
	'globalblocking-search-ip' => 'Direzion IP:',
	'globalblocking-list-unblock' => 'gjave',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'globalblocking-block-expiry-otherfield' => 'In oare tiid:',
);

/** Galician (Galego)
 * @author Prevert
 * @author Toliño
 */
$messages['gl'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permite]] que os enderezos IP sexan [[Special:GlobalBlockList|bloqueados en múltiples wikis]]',
	'globalblocking-block' => 'Bloqueo global dun enderezo IP',
	'globalblocking-modify-intro' => 'Pode usar este formulario para cambiar a configuración dun bloqueo global.',
	'globalblocking-block-intro' => 'Pode usar esta páxina para bloquear un enderezo IP en todos os wikis.',
	'globalblocking-block-reason' => 'Motivo:',
	'globalblocking-block-otherreason' => 'Outro motivo:',
	'globalblocking-block-reasonotherlist' => 'Outro motivo',
	'globalblocking-block-reason-dropdown' => '*Motivos frecuentes para bloquear
** Spam en varios wikis
** Abuso en varios wikis
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Editar os motivos de bloqueo',
	'globalblocking-block-expiry' => 'Caducidade:',
	'globalblocking-block-expiry-other' => 'Outro período de tempo de caducidade',
	'globalblocking-block-expiry-otherfield' => 'Outro período de tempo:',
	'globalblocking-block-legend' => 'Bloquear un enderezo IP globalmente',
	'globalblocking-block-options' => 'Opcións:',
	'globalblocking-ipaddress' => 'Enderezo IP:',
	'globalblocking-ipbanononly' => 'Bloquear só os usuarios anónimos',
	'globalblocking-block-errors' => 'O seu bloqueo non puido levarse a cabo {{PLURAL:$1|pola seguinte razón|polas seguintes razóns}}:',
	'globalblocking-block-ipinvalid' => 'O enderezo IP ($1) que tecleou é inválido.
Por favor, decátese de que non pode teclear un nome de usuario!',
	'globalblocking-block-expiryinvalid' => 'O período de caducidade que tecleou ($1) é inválido.',
	'globalblocking-block-submit' => 'Bloquear este enderezo IP globalmente',
	'globalblocking-modify-submit' => 'Modificar este bloqueo global',
	'globalblocking-block-success' => 'O enderezo IP $1 foi bloqueado con éxito en todos os proxectos.',
	'globalblocking-modify-success' => 'O bloqueo global que $1 tiña foi modificado con éxito',
	'globalblocking-block-successsub' => 'Bloqueo global exitoso',
	'globalblocking-modify-successsub' => 'O bloqueo global foi modificado con éxito',
	'globalblocking-block-alreadyblocked' => 'O enderezo IP "$1" xa está globalmente bloqueado.
Pode ollar os bloqueos vixentes na [[Special:GlobalBlockList|lista de bloqueos globais]]
ou modificar as características do bloqueo existente volvendo enviar este formulario.',
	'globalblocking-block-bigrange' => 'O rango especificado ($1) é demasiado grande para bloquealo. Pode bloquear, como máximo, 65.536 enderezos (/16 rangos)',
	'globalblocking-list-intro' => 'Esta é unha lista de todos os bloqueos globais vixentes.
Algúns bloqueos están marcados como deshabilitados localmente: isto significa que se aplican noutros sitios, pero que un administrador local decidiu retirar o bloqueo neste wiki.',
	'globalblocking-list' => 'Lista dos bloqueos globais a enderezos IP',
	'globalblocking-search-legend' => 'Procurar bloqueos globais',
	'globalblocking-search-ip' => 'Enderezo IP:',
	'globalblocking-search-submit' => 'Procurar os bloqueos',
	'globalblocking-list-ipinvalid' => 'O enderezo IP que procurou ($1) é inválido.
Por favor, teclee un enderezo IP válido.',
	'globalblocking-search-errors' => 'A súa procura non tivo éxito {{PLURAL:$1|pola seguinte razón|polas seguintes razóns}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bloqueou globalmente a \"[[Special:Contributions/\$4|\$4]]\" ''(\$5)''",
	'globalblocking-list-expiry' => 'expira $1',
	'globalblocking-list-anononly' => 'só anón.',
	'globalblocking-list-unblock' => 'desbloquear',
	'globalblocking-list-whitelisted' => 'deshabilitado localmente por $1: $2',
	'globalblocking-list-whitelist' => 'estado local',
	'globalblocking-list-modify' => 'modificar',
	'globalblocking-list-noresults' => 'O enderezo IP solicitado non está bloqueado.',
	'globalblocking-goto-block' => 'Bloquear globalmente un enderezo IP',
	'globalblocking-goto-unblock' => 'Retirar un bloqueo global',
	'globalblocking-goto-status' => 'Cambiar o estado local dun bloqueo global',
	'globalblocking-return' => 'Volver á lista de bloqueos globais',
	'globalblocking-notblocked' => 'O enderezo IP ($1) que inseriu non está globalmente bloqueado.',
	'globalblocking-unblock' => 'Retirar un bloqueo global',
	'globalblocking-unblock-ipinvalid' => 'O enderezo IP ($1) que tecleou é inválido.
Por favor, decátese de que non pode teclear un nome de usuario!',
	'globalblocking-unblock-legend' => 'Retirar un bloqueo global',
	'globalblocking-unblock-submit' => 'Retirar bloqueo global',
	'globalblocking-unblock-reason' => 'Motivo:',
	'globalblocking-unblock-unblocked' => "Retirou con éxito o bloqueo global #$2 que tiña o enderezo IP '''$1'''",
	'globalblocking-unblock-errors' => 'A súa eliminación do bloqueo global non puido levarse a cabo {{PLURAL:$1|pola seguinte razón|polas seguintes razóns}}:',
	'globalblocking-unblock-successsub' => 'A retirada do bloqueo global foi un éxito',
	'globalblocking-unblock-subtitle' => 'Eliminando o bloqueo global',
	'globalblocking-unblock-intro' => 'Pode usar este formulario para retirar un bloqueo global.',
	'globalblocking-whitelist' => 'Estado local dos bloqueos globais',
	'globalblocking-whitelist-notapplied' => 'Os bloqueos globais non son aplicados neste wiki,
polo que o estado local dos bloqueos globais non pode ser modificado.',
	'globalblocking-whitelist-legend' => 'Cambiar o estado local',
	'globalblocking-whitelist-reason' => 'Motivo:',
	'globalblocking-whitelist-status' => 'Estado local:',
	'globalblocking-whitelist-statuslabel' => 'Deshabilitar este bloqueo global en {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Cambiar o estado local',
	'globalblocking-whitelist-whitelisted' => "Deshabilitou con éxito en {{SITENAME}} o bloqueo global #$2 do enderezo IP '''$1'''.",
	'globalblocking-whitelist-dewhitelisted' => "Volveu habilitar con éxito en {{SITENAME}} o bloqueo global #$2 do enderezo IP '''$1'''.",
	'globalblocking-whitelist-successsub' => 'O estado local foi trocado con éxito',
	'globalblocking-whitelist-nochange' => 'Non lle fixo ningún cambio ao estado local deste bloqueo.
[[Special:GlobalBlockList|Volver á lista dos bloqueos globais]].',
	'globalblocking-whitelist-errors' => 'O cambio do estado local dun bloqueo global fracasou {{PLURAL:$1|polo seguinte motivo|polos seguintes motivos}}:',
	'globalblocking-whitelist-intro' => 'Pode usar este formulario para editar o estado local dun bloqueo global.
Se un bloqueo global está deshabilitado neste wiki, os usuarios que usen o enderezo IP afectado poderán editar sen problemas.
[[Special:GlobalBlockList|Volver á lista dos bloqueos globais]].',
	'globalblocking-blocked' => "O seu enderezo IP \$5 foi bloqueado en todos os wikis por '''\$1''' (''\$2'').
A razón que deu foi ''\"\$3\"''.
O bloqueo ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Non pode restablecer o contrasinal do usuario porque vostede está bloqueado globalmente.',
	'globalblocking-logpage' => 'Rexistro de bloqueos globais',
	'globalblocking-logpagetext' => 'Este é un rexistro dos bloqueos globais que foron feitos e retirados neste wiki.
Déase de conta de que os bloqueos globais poden ser feitos e retirados noutros wikis e este bloqueos poden afectar a este.
Para ver todos os bloqueos globais activos, pode ollar a [[Special:GlobalBlockList|lista dos bloqueos globais]].',
	'globalblocking-block-logentry' => 'bloqueou globalmente a "[[$1]]" cun período de caducidade de $2',
	'globalblocking-block2-logentry' => 'bloqueou globalmente a "[[$1]]" ($2)',
	'globalblocking-unblock-logentry' => 'retirado o bloqueo global en [[$1]]',
	'globalblocking-whitelist-logentry' => 'deshabilitou localmente o bloqueo global en [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'volveu habilitar localmente o bloqueo global en [[$1]]',
	'globalblocking-modify-logentry' => 'modificou o bloqueo global de "[[$1]]" ($2)',
	'globalblocking-logentry-expiry' => 'caduca o $1',
	'globalblocking-logentry-noexpiry' => 'non hai fixada ningunha caducidade',
	'globalblocking-loglink' => 'O enderezo IP $1 está bloqueado globalmente ([[{{#Special:GlobalBlockList}}/$1|máis detalles]]).',
	'globalblocking-showlog' => 'Este enderezo IP foi bloqueado previamente.
Velaquí está o rexistro de bloqueos, por se quere consultalo:',
	'globalblocklist' => 'Lista dos bloqueos globais a enderezos IP',
	'globalblock' => 'Bloquear globalmente un enderezo IP',
	'globalblockstatus' => 'Estado local dos bloqueos globais',
	'removeglobalblock' => 'Retirar un bloqueo global',
	'right-globalblock' => 'Realizar bloqueos globais',
	'action-globalblock' => 'realizar bloqueos globais',
	'right-globalunblock' => 'Eliminar bloqueos globais',
	'action-globalunblock' => 'eliminar bloqueos globais',
	'right-globalblock-whitelist' => 'Deshabilitar bloqueos globais localmente',
	'action-globalblock-whitelist' => 'deshabilitar bloqueos globais localmente',
	'right-globalblock-exempt' => 'Saltar bloqueos globais',
	'action-globalblock-exempt' => 'saltar bloqueos globais',
);

/** Gothic (Gothic)
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'globalblocking-unblock-reason' => '𐍆𐌰𐌹𐍂𐌹𐌽𐌰:',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'globalblocking-block-options' => 'Ἐπιλογαί:',
	'globalblocking-search-ip' => 'IP-διεύθυνσις:',
	'globalblocking-list-unblock' => 'ἀφαιρεῖν',
	'globalblocking-list-modify' => 'τροποποιεῖν',
	'globalblocking-unblock-reason' => 'Αἰτία:',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Sperrt]] IP-Adrässe uf [[Special:GlobalBlockList|allene Wiki]]',
	'globalblocking-block' => 'E IP-Adräss wältwyt sperre',
	'globalblocking-modify-intro' => 'Du chasch des Formular neh go d Yystellige vun ere wältwyte Sperri ändere.',
	'globalblocking-block-intro' => 'Uf däe Syte chasch IP-Adrässe fir alli Wiki sperre.',
	'globalblocking-block-reason' => 'Grund:',
	'globalblocking-block-otherreason' => 'Andere/Zuesätzlige Grund:',
	'globalblocking-block-reasonotherlist' => 'Andere Grund',
	'globalblocking-block-reason-dropdown' => '* Gängigi Sperrgrind
** Crosswiki-Spamming
** Crosswiki-Missbruch
** Vandalismus',
	'globalblocking-block-edit-dropdown' => 'Sperrgrind bearbeite',
	'globalblocking-block-expiry' => 'Sperrduur:',
	'globalblocking-block-expiry-other' => 'Anderi Duur',
	'globalblocking-block-expiry-otherfield' => 'Anderi Duur (änglisch):',
	'globalblocking-block-legend' => 'E IP-Adräss  wältwyt sperre',
	'globalblocking-block-options' => 'Optione:',
	'globalblocking-ipaddress' => 'IP-Addräss:',
	'globalblocking-ipbanononly' => 'Nume anonymi Benutzer sperre',
	'globalblocking-block-errors' => 'D Sperri isch nit erfolgryych gsi. {{PLURAL:$1|Grund|Grind}}:',
	'globalblocking-block-ipinvalid' => 'Du hesch e uugiltigi IP-Adräss ($1) yygee.
Obacht, Du chasch kei Benutzername yygee!',
	'globalblocking-block-expiryinvalid' => 'D Sperrduur ($1) isch uugiltig.',
	'globalblocking-block-submit' => 'Die IP-Adräss wältwyt sperre',
	'globalblocking-modify-submit' => 'Die wältwyt Sperri ändere',
	'globalblocking-block-success' => 'D IP-Adräss $1 isch mit Erfolg uf allene Projäkt gsperrt wore.',
	'globalblocking-modify-success' => 'Di wältwyt Sperri an $1 isch erfolgryych gänderet wore',
	'globalblocking-block-successsub' => 'Mit Erfolg wältwyt gsperrt',
	'globalblocking-modify-successsub' => 'Wältwyti Sperri erfolgryych gänderet',
	'globalblocking-block-alreadyblocked' => 'D IP-Adräss $1 isch scho wältwyt gsperrt.
Du chasch d Sperri in dr [[Special:GlobalBlockList|wältwyte Sperrlischt]] aaluege oder d Yystellige vu dr Sperri mit däm Formular ändere.',
	'globalblocking-block-bigrange' => 'Dr Adrässberyych, wu Du aagee hesch ($1), isch z groß.
Du chasch hegschtens 65.536 Adrässe sperre (/16-Adrässberyych)',
	'globalblocking-list-intro' => 'Des isch e Lischt vu allene giltige wältwyte Sperrine. E Teil Sperrine sin lokal deaktiviert wore. Des heisst, ass d Sperrine uf andere Projäkt giltig sin, aber e hiesige Ammann het entschide, si fir dä Wiki z deaktiviere.',
	'globalblocking-list' => 'Lischt vu wältwyt gsperrte IP-Adrässe',
	'globalblocking-search-legend' => 'E wältwyti Sperri sueche',
	'globalblocking-search-ip' => 'IP-Adräss:',
	'globalblocking-search-submit' => 'Sperrine sueche',
	'globalblocking-list-ipinvalid' => 'Du hesch e uugiltigi IP-Adräss ($1) yygee.
Bitte gib e giltigi IP-Adräss yy.',
	'globalblocking-search-errors' => 'D Suechi isch nit erfolgryych gsi. {{PLURAL:$1|Grund|Grind}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (uf ''\$3'') het [[Special:Contributions/\$4|\$4]] wältwyt gsperrt ''(\$5)''",
	'globalblocking-list-expiry' => 'Sperrduur $1',
	'globalblocking-list-anononly' => 'nume Anonymi',
	'globalblocking-list-unblock' => 'entsperre',
	'globalblocking-list-whitelisted' => 'lokal abgschalte vu $1: $2',
	'globalblocking-list-whitelist' => 'lokale Status',
	'globalblocking-list-modify' => 'ändere',
	'globalblocking-list-noresults' => 'Di gfrogt IP-Adräss isch nit gsperrt.',
	'globalblocking-goto-block' => 'IP-Adräss wältwyt sperre',
	'globalblocking-goto-unblock' => 'Wältwyti Sperri ufhebe',
	'globalblocking-goto-status' => 'Dr lokal Status fir e wältwyti Sperri ändere',
	'globalblocking-return' => 'Zruck zue dr Lischt vu wältwyte Sperrine',
	'globalblocking-notblocked' => 'D IP-Adräss, wu yygee woren isch ($1), isch nit wältwyt gsperrt.',
	'globalblocking-unblock' => 'Wältwyti Sperri ufhebe',
	'globalblocking-unblock-ipinvalid' => 'Du hesch e uugiltigi IP-Adräss ($1) yygee.
Obacht: D derfsch kei Benutzername yygee!',
	'globalblocking-unblock-legend' => 'Wältwyt entsperre',
	'globalblocking-unblock-submit' => 'Wältwyt entsperre',
	'globalblocking-unblock-reason' => 'Grund:',
	'globalblocking-unblock-unblocked' => "Du hesch IP-Adräss '''$1''' (Sperr-ID $2) mit Erfolg entsperrt",
	'globalblocking-unblock-errors' => 'D Ufhebig vu dr wältwyte Sperri isch nit erfolgryych gsi. {{PLURAL:$1|Grund|Grind}}:',
	'globalblocking-unblock-successsub' => 'Mit Erfolg wältwyt entsperrt',
	'globalblocking-unblock-subtitle' => 'Wältwyti Sperri useneh',
	'globalblocking-unblock-intro' => 'Mit däm Formular chasch e wältwyti Sperri ufhebe.',
	'globalblocking-whitelist' => 'Lokaler Status vun ere wältwyte Sperri',
	'globalblocking-whitelist-notapplied' => 'Wältwyti Sperrine wäre in däm Wiki nit aagwändet, wäge däm cha dr lokal Status vu dr wältwyte Sperri nit gänderet wäre.',
	'globalblocking-whitelist-legend' => 'Dr lokal Status ändere',
	'globalblocking-whitelist-reason' => 'Grund:',
	'globalblocking-whitelist-status' => 'Lokaler Status:',
	'globalblocking-whitelist-statuslabel' => 'Die wältwyt Sperri uf {{SITENAME}} ufhebe',
	'globalblocking-whitelist-submit' => 'Dr lokal Status ändere',
	'globalblocking-whitelist-whitelisted' => "Du hesch erfolgryych di wältwyt Sperri #$2 vu dr IP-Adräss '''$1''' uf {{SITENAME}} ufghobe.",
	'globalblocking-whitelist-dewhitelisted' => "Du hesch erfolgryych di wältwyt Sperri #$2 vu dr IP-Adräss '''$1''' uf {{SITENAME}} wider yygschalte.",
	'globalblocking-whitelist-successsub' => 'Lokaler Status erfolgrych gänderet',
	'globalblocking-whitelist-nochange' => 'Du hesch dr lokal Status vu dr Sperri nit gänderet.
[[Special:GlobalBlockList|Zruck zue dr Lischt vu dr wältwyte Sperrine]]',
	'globalblocking-whitelist-errors' => 'Dyyni Änderig vum lokale Status vun ere wältwyte Sperri isch nit erfolgryych gsi. {{PLURAL:$1|Grund|Grind}}:',
	'globalblocking-whitelist-intro' => 'Du chasch mit däm Formular dr lokal Status vun ere wältwyte Sperri ändere. Wänn e wältwyti Sperri in däm Wiki deaktiviert woren isch, chenne Syte iber die IP-Adräss normal bearbeitet wäre. [[Special:GlobalBlockList|Druck do]], zum uf d Lischt vu dr wältwyte Sperrine zruckzgoh.',
	'globalblocking-blocked' => "Dyyni IP-Adräss $5 isch vu '''$1''' ''($2)'' fir alli Wiki gsperrt wore.
As Grund isch ''„$3“'' aagee wore. D Sperri ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Du chasch s Passwort vum Benutzer nit zrucksetze, wel Du wältwyt gsperrt bisch.',
	'globalblocking-logpage' => 'Wältwyt Sperrlogbuech',
	'globalblocking-logpagetext' => 'Des isch s Logbuech vu dr wältwyte Sperrine, wu in däm Wiki yygrichtet oder ufghobe wore sin.
Wältwyti Sperrine chenne in eme andere Wiki yygrichtet un ufghobe wäre, dodemit chenne au d Sperrine in däm Wiki troffe wäre.
Go ne Lischt vu allene aktive wältwyte Sperrine aaluege, lueg uf dr [[Special:GlobalBlockList|wältwyte Sperrlischt]].',
	'globalblocking-block-logentry' => 'het [[$1]] wältwyt fir e Zytruum vu $2 gsperrt',
	'globalblocking-block2-logentry' => 'het [[$1]] ($2) wältwyt gperrt',
	'globalblocking-unblock-logentry' => 'het d Sperri vu [[$1]] wältwyt ufghobe',
	'globalblocking-whitelist-logentry' => 'het di wältwyt Sperri vu „[[$1]]“ lokal abgschalte',
	'globalblocking-dewhitelist-logentry' => 'het di wältwyt Sperri vu „[[$1]]“ lokal wider yygschalte',
	'globalblocking-modify-logentry' => 'het di wältwyt Sperri an [[$1]] ($2) gänderet',
	'globalblocking-logentry-expiry' => 'bis $1',
	'globalblocking-logentry-noexpiry' => 'kei Sperränd feschtgleit',
	'globalblocking-loglink' => 'D IP-Adräss $1 isch wältwyt gsperrt ([[{{#Special:GlobalBlockList}}/$1|Details]]).',
	'globalblocking-showlog' => 'Die IP-Adräss isch fiejer gsperrt gsi.
Do chunnt e Uuszug us em Benutzersperr-Logbuech:',
	'globalblocklist' => 'Lischt vu wältwyt gsperrte IP-Adrässe',
	'globalblock' => 'E IP-Adräss wältwyt sperre',
	'globalblockstatus' => 'Lokaler Status vu dr wältwyte Sperri',
	'removeglobalblock' => 'Wältwyti Sperri ufhebe',
	'right-globalblock' => 'Wältwyti Sperrine yyrichte',
	'right-globalunblock' => 'Wältwyti Sperrine ufhebe',
	'right-globalblock-whitelist' => 'Wältwyti Sperrine lokal abschalte',
	'right-globalblock-exempt' => 'Wältwyti Sperrine umgoh',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'globalblocking-block' => 'IP ને વૈશ્વિક રીતે પ્રતિબંધીત કરો',
	'globalblocking-modify-intro' => 'તમે આ ફોર્મ વાપરીને આ વૈશ્વિક ખાતાની વિકલ્પ વ્યવસ્થા બદલી શકો છો.',
	'globalblocking-block-intro' => 'તમે આ પૃષ્ઠ વાપરીને દરેક વિકિ પર કોઈ IP ઍડ્રેસ પર પ્રતિબંધ મૂકી શકો છો',
	'globalblocking-block-reason' => 'કારણ:',
	'globalblocking-block-otherreason' => 'અન્ય/વધારાનું કારણ:',
	'globalblocking-block-reasonotherlist' => 'બીજું કારણ',
	'globalblocking-block-reason-dropdown' => '* પ્રતિબંધ મૂકવાના સામાન્ય કારણો
** આંતર વિકિ સ્પૅમિંગ
** આંતરવિકિ ગાળાગાળી
** ભાંગફોડ',
	'globalblocking-block-edit-dropdown' => 'સામૂહિક પ્રતિબંધ કારણોમાં ફેરફાર કરો',
	'globalblocking-block-expiry' => 'કાલાતિત',
	'globalblocking-block-expiry-other' => 'અન્ય કાલાતિત સમય',
	'globalblocking-block-expiry-otherfield' => 'અન્ય સમય:',
	'globalblocking-block-legend' => 'IP એડ્રેસ પર વૈશ્વીક પ્રતિબંધ મૂકો',
	'globalblocking-block-options' => 'વિકલ્પો:',
	'globalblocking-ipaddress' => 'IP સરનામું:',
	'globalblocking-ipbanononly' => 'માત્ર અજ્ઞાત સભ્ય છુપાવો',
	'globalblocking-block-errors' => 'તમારા દ્વારા લગાવેલ પ્રતિબંધ નીચેના {{PLURAL:$1|કારણ|કારણો}}ને લીધે અસફળ રહ્યો:',
	'globalblocking-block-ipinvalid' => 'તમે દાખલ કરેલ IP સરનામું ($1) અયોગ્ય છે.
મહેરબાની કરીને નોંધ લો કે તમે સભ્યનામ દાખલ કરી શકશો નહી!',
	'globalblocking-block-expiryinvalid' => 'તમે  જણાવેલ કાલાતીત સીમા  ($1) અમાન્ય છે',
	'globalblocking-block-submit' => 'IP એડ્રેસ પર વૈશ્વીક પ્રતિબંધ મૂકો',
	'globalblocking-modify-submit' => 'આ વૈશ્વીક સમૂહને બદલો',
	'globalblocking-block-success' => 'IP એડ્રેસ $1 પર બધી પરિયોજનાઓ ઉપર પ્રતિબંધ મુકાયો',
	'globalblocking-modify-success' => 'વૈશ્વીક પ્રતિબંધ $1 ને સફળતા પૂર્વક સુધારાયો.',
	'globalblocking-block-successsub' => 'વૈશ્વીક પ્રતિબંધ સફળ',
	'globalblocking-modify-successsub' => 'વૈશ્વીક સમૂહને સફળતા પૂર્વક બદલાયો',
	'globalblocking-list' => 'વૈશ્વીક રીતે પ્રતિબંધીત IP એડ્રેસની યાદી',
	'globalblocking-search-legend' => 'વૈશ્વીક સમૂહ શોધો',
	'globalblocking-search-ip' => 'IP સરનામું:',
	'globalblocking-search-submit' => 'પ્રતિબંધને શોધો',
	'globalblocking-list-ipinvalid' => 'ત્તમે શોધો છો તે IP એડ્રેસ  ($1) અમાન્ય છે.
મહેરબાની કરી વૈધ IP એડ્રેસ આપો.',
	'globalblocking-search-errors' => 'નીચેના {{PLURAL:$1|કારણ|કારણો}}ને લીધે, તમારી શોધ અસફળ રહી હતી:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'')એ [[Special:Contributions/\$4|\$4]] પર વૈશ્વિક પ્રતિબંધ મુક્યો ''(\$5)''",
	'globalblocking-list-expiry' => 'કાલાતીત $1',
	'globalblocking-list-anononly' => 'માત્ર અજ્ઞાત',
	'globalblocking-list-unblock' => 'દુર કરો',
	'globalblocking-list-whitelisted' => '$1 દ્વારા સ્થાનીય સ્તરે નીષ્ક્રિય કરાયું: $2',
	'globalblocking-list-whitelist' => 'સ્થાનિક સ્થિતિ:',
	'globalblocking-list-modify' => 'સુધારો',
	'globalblocking-list-noresults' => 'અર્જીત IP સરનામું કે સભ્યનામ પ્રતિબંધિત નથી',
	'globalblocking-goto-block' => 'એક IP ને વૈશ્વિક રીતે પ્રતિબંધીત કરો',
	'globalblocking-goto-unblock' => 'વૈશ્વીક પ્રતિબંધ હટાવો',
	'globalblocking-goto-status' => 'વૈશ્વિક પ્રતિબંધનું સ્થાનીક સ્તર ધરાવો',
	'globalblocking-return' => 'વૈશ્વીક સમોહોની યાદી પર પાછા જાવ',
	'globalblocking-notblocked' => 'તમે લખેલો IP એડ્રેસ ($1) વૈશ્વીક રીતે પ્રતિબંધિત છે.',
	'globalblocking-unblock' => 'વૈશ્વીક પ્રતિબંધ હટાવો',
	'globalblocking-unblock-ipinvalid' => 'તમે દાખલ કરેલ IP સરનામું ($1) અયોગ્ય છે.
મહેરબાની કરીને નોંધ લો કે તમે સભ્યનામ દાખલ કરી શકશો નહી!',
	'globalblocking-unblock-legend' => 'વૈશ્વીક પ્રતિબંધ હટાવાયો',
	'globalblocking-unblock-submit' => 'વૈશ્વીક સમૂહ હટાવો',
	'globalblocking-unblock-reason' => 'કારણ:',
	'globalblocking-unblock-unblocked' => "તમે સફળતા પૂર્વક  IP એડ્રેસ '''$1''' પરનો વૈશ્વીક પ્રતિબંધ #$2 હટાવ્યો",
	'globalblocking-unblock-errors' => 'તમારા દ્વારા લગાવેલ પ્રતિબંધ નીચેના {{PLURAL:$1|કારણ|કારણો}}ને લીધે અસફળ રહ્યો:',
	'globalblocking-unblock-successsub' => 'વૈશ્વીક પ્રતિબંધ સફળતા પૂર્વક હટાવાયો',
	'globalblocking-unblock-subtitle' => 'વૈશ્વીક પ્રતિબંધ હટાવાય છે',
	'globalblocking-unblock-intro' => 'તમે આ ફોર્મ વાપરી વૈશ્વીક પ્રતિબંધ હટાવી શકો છો',
	'globalblocking-whitelist' => 'વૈશ્વીક પ્રતિબંધોનો સ્થાનીય સ્તર',
	'globalblocking-whitelist-notapplied' => 'આ વિકિ પર વૈશ્વીક પ્રતિબંધ લગાવાયા નથી
આથી વૈશ્વીક પ્રતિબંધોનું સ્થનીય સ્થિતી સુધારી નહીં શકાય',
	'globalblocking-whitelist-legend' => 'સ્થાનિક સ્થિતિ બદલો',
	'globalblocking-whitelist-reason' => 'કારણ:',
	'globalblocking-whitelist-status' => 'સ્થાનિક સ્થિતિ:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} પરનો વૈશ્વીક પ્રતિબંધ હટાવો',
	'globalblocking-whitelist-submit' => 'સ્થાનિક સ્થિતિ બદલો',
	'globalblocking-whitelist-whitelisted' => "તમે {{SITENAME}} પર સફળતા પૂર્વક  IP એડ્રેસ '''$1''' પરનો વૈશ્વીક પ્રતિબંધ #$2 હટાવ્યો",
	'globalblocking-whitelist-successsub' => 'સ્થાનીય સ્તર સફળતા પૂર્વક બદલાયો',
	'globalblocking-blocked' => "તમારું IP સરનામું \$5 દરેક વિકિ પર '''\$1''' (''\$2'') વડે પ્રતિબંધિત છે. 
તેના માટે ''\"\$3\"'' કારણ આપેલ છે.
પ્રતિબંધ ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'તમે સભ્યનો પાસવર્ડ ફરી ન ગોઠવી શકો કેમકે તમારા પર વૈશ્વીક પ્રતિબંધ લાગેલો છે.',
	'globalblocking-logpage' => 'સામૂહિક પ્રતિબંધનો લોગ',
	'globalblocking-block-logentry' => '[[$1]] પર પ્રતિબંધ $2 સુધી મુકવામાં આવ્યો છે.',
	'globalblocking-block2-logentry' => 'વૈશ્વીક રીતે પ્રતિબંધીત [[$1]] ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] નો વૈશ્વીક પ્રતિબંધ રદ્દ કરો',
	'globalblocking-whitelist-logentry' => '[[$1]] પરનો વૈશ્વીક પ્રતિબંધ સ્થાનીય સ્તરે નિષ્ક્રીય કરો',
	'globalblocking-dewhitelist-logentry' => '[[$1]] પરનો વૈશ્વીક પ્રતિબંધ સ્થાનીય સ્તરે ફરી સષ્ક્રીય કરો',
	'globalblocking-modify-logentry' => '[[$1]] ($2) પ્રના વૈશ્વીક પ્રતિબંધ મઠાર્યા',
	'globalblocking-logentry-expiry' => 'કાલાતીત $1',
	'globalblocking-logentry-noexpiry' => 'કાલાતિત સમૂહ નથી',
	'globalblocking-showlog' => 'આ IP એડ્રેસ પર પહેલા રોક લગાવાઈ છે.
રોકા લગાવાયેલા IP એડ્રેસની યાદિ આ મુજબ છે',
	'globalblocklist' => 'વૈશ્વીક રીતે પ્રતિબંધીત IP એડ્રેસની યાદી',
	'globalblock' => 'IP ને વૈશ્વિક રીતે પ્રતિબંધીત કરો',
	'globalblockstatus' => 'વૈશ્વીક પ્રતિબંધોનો સ્થાનીય સ્તર',
	'removeglobalblock' => 'વૈશ્વીક પ્રતિબંધ હટાવો',
	'right-globalblock' => 'વૈશ્વીક પ્રતિબંધો બનાવો',
	'action-globalblock' => 'વૈશ્વીક પ્રતિબંધો બનાવો',
	'right-globalunblock' => 'વૈશ્વીક પ્રતિબંધ હટાવો',
	'action-globalunblock' => 'વૈશ્વીક પ્રતિબંધ હટાવો',
	'right-globalblock-whitelist' => 'વૈશ્વીક પ્રતિબંધને સ્થાનીય સ્તરે હટાવો',
	'action-globalblock-whitelist' => 'વૈશ્વીક પ્રતિબંધને સ્થાનીય સ્તરે નિષ્ક્રીય કરો',
	'right-globalblock-exempt' => 'વૈશ્વીક પ્રતિબંધો દરગુજર કરો',
	'action-globalblock-exempt' => 'વૈશ્વીક પ્રતિબંધો દરગુજર કરો',
);

/** Manx (Gaelg)
 * @author MacTire02
 * @author Shimmin Beg
 */
$messages['gv'] = array(
	'globalblocking-block-reason' => 'Fa:',
	'globalblocking-block-expiry-otherfield' => 'Am elley:',
	'globalblocking-block-options' => 'Reihyn:',
	'globalblocking-search-ip' => 'Enmys IP:',
	'globalblocking-unblock-reason' => 'Fa:',
	'globalblocking-whitelist-reason' => 'Fa:',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'globalblocking-block-reason' => 'Dalili:',
	'globalblocking-block-reasonotherlist' => 'Wani dalili',
	'globalblocking-unblock-reason' => 'Dalili:',
	'globalblocking-whitelist-reason' => 'Dalili:',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'globalblocking-unblock-reason' => 'Kumu:',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 * @author Yonidebest
 */
$messages['he'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|אפשרות]] ל[[Special:GlobalBlockList|חסימה גלובלית בין אתרי הוויקי]] של כתובות IP',
	'globalblocking-block' => 'חסימה גלובלית של כתובת IP',
	'globalblocking-modify-intro' => 'באפשרותכם להשתמש בטופס זה כדי לשנות את ההגדרות של חסימה גלובלית.',
	'globalblocking-block-intro' => 'באפשרותכם להשתמש בדף זה כדי לחסום כתובת IP בכל אתרי הוויקי.',
	'globalblocking-block-reason' => 'סיבה:',
	'globalblocking-block-otherreason' => 'סיבה נוספת/אחרת:',
	'globalblocking-block-reasonotherlist' => 'סיבה אחרת',
	'globalblocking-block-reason-dropdown' => '* סיבות חסימה נפוצות
** ספאם בין-מיזמי
** שימוש לרעה בין-מיזמי
** השחתה',
	'globalblocking-block-edit-dropdown' => 'עריכת סיבות החסימה',
	'globalblocking-block-expiry' => 'זמן פקיעה:',
	'globalblocking-block-expiry-other' => 'זמן פקיעה אחר',
	'globalblocking-block-expiry-otherfield' => 'זמן אחר:',
	'globalblocking-block-legend' => 'חסימה גלובלית של כתובת IP',
	'globalblocking-block-options' => 'אפשרויות:',
	'globalblocking-ipaddress' => 'כתובת IP:',
	'globalblocking-ipbanononly' => 'לחסום משתמשים אלמוניים בלבד',
	'globalblocking-block-errors' => 'החסימה נכשלה בגלל {{PLURAL:$1|הסיבה הבאה|הסיבות הבאות}}:',
	'globalblocking-block-ipinvalid' => 'כתובת ה־IP שהקלדתם ($1) אינה תקינה.
שימו לב שאין באפשרותכם להכניס שם משתמש!',
	'globalblocking-block-expiryinvalid' => 'זמן פקיעת החסימה שהקלדתם ($1) אינו תקין.',
	'globalblocking-block-submit' => 'חסימה גלובלית של כתובת ה־IP הזו',
	'globalblocking-modify-submit' => 'שינוי חסימה גלובלית זו',
	'globalblocking-block-success' => 'כתובת ה־IP $1 נחסמה בהצלחה בכל אתרי הוויקי.',
	'globalblocking-modify-success' => 'החסימה הגלובלית של $1 שונתה בהצלחה',
	'globalblocking-block-successsub' => 'החסימה הגלובלית הושלמה בהצלחה',
	'globalblocking-modify-successsub' => 'החסימה הגלובלית שונתה בהצלחה',
	'globalblocking-block-alreadyblocked' => 'כתובת ה־IP $1 כבר נחסמה באופן גלובלי.
באפשרותכם לצפות בחסימה הקיימת ב[[Special:GlobalBlockList|רשימת החסימות הגלובליות]],
או לשנות את הגדרות החסימה הקיימת באמצעות שליחה מחדש של הטופס.',
	'globalblocking-block-bigrange' => 'הטווח שציינתם ($1) גדול מדי לחסימה. באפשרותכם לחסום לכל היותר 65,536 כתובות (טווחים מסוג /16)',
	'globalblocking-list-intro' => 'זוהי רשימה של כל החסימות הגלובליות הקיימות כרגע. חלק מהחסימות מסומנות כחסימות מוגבלות באופן מקומי: פירוש הדבר שהן תקפות באתרים אחרים, אך אחד ממפעילי המערכת המקומיים החליט לבטלן באתר זה.',
	'globalblocking-list' => 'רשימת כתובות IP שנחסמו גלובלית',
	'globalblocking-search-legend' => 'חיפוש חסימה גלובלית',
	'globalblocking-search-ip' => 'כתובת IP:',
	'globalblocking-search-submit' => 'חיפוש חסימות',
	'globalblocking-list-ipinvalid' => 'כתובת ה־IP שהקלדתם ($1) אינה תקינה.
אנא הקלידו כתובת IP תקינה.',
	'globalblocking-search-errors' => 'החיפוש נכשל בגלל {{PLURAL:$1|הסיבה הבאה|הסיבות הבאות}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') חסם באופן גלובלי את [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'פקיעת החסימה: $1',
	'globalblocking-list-anononly' => 'משתמשים אנונימיים בלבד',
	'globalblocking-list-unblock' => 'הסרה',
	'globalblocking-list-whitelisted' => 'בוטל באופן מקומי על ידי $1: $2',
	'globalblocking-list-whitelist' => 'מצב מקומי',
	'globalblocking-list-modify' => 'שינוי',
	'globalblocking-list-noresults' => 'כתובת ה־IP המבוקשת אינה חסומה.',
	'globalblocking-goto-block' => 'חסימה גלובלית של כתובת IP',
	'globalblocking-goto-unblock' => 'הסרת חסימה גלובלית',
	'globalblocking-goto-status' => 'שינוי המצב המקומי של חסימה גלובלית',
	'globalblocking-return' => 'חזרה לרשימת החסימות הגלובליות',
	'globalblocking-notblocked' => 'כתובת ה־IP שהקלדתם ($1) אינה חסומה באופן גלובלי.',
	'globalblocking-unblock' => 'הסרת חסימה גלובלית',
	'globalblocking-unblock-ipinvalid' => 'כתובת ה־IP ($1) שהקלדתם אינה תקינה.
שימו לב שאין באפשרותכם להכניס שם משתמש!',
	'globalblocking-unblock-legend' => 'הסרת חסימה גלובלית',
	'globalblocking-unblock-submit' => 'הסרת חסימה גלובלית',
	'globalblocking-unblock-reason' => 'סיבה:',
	'globalblocking-unblock-unblocked' => "החסימה הגלובלית #$2 של כתובת ה־IP '''$1''' הוסרה בהצלחה",
	'globalblocking-unblock-errors' => 'הסרת החסימה הגלובלית נכשלה בגלל {{PLURAL:$1|הסיבה הבאה|הסיבות הבאות}}:',
	'globalblocking-unblock-successsub' => 'החסימה הגלובלית הוסרה בהצלחה',
	'globalblocking-unblock-subtitle' => 'הסרת חסימה גלובלית',
	'globalblocking-unblock-intro' => 'ניתן להיעזר בטופס זה כדי להסיר חסימה גלובלית.',
	'globalblocking-whitelist' => 'המצב המקומי של החסימות הגלובליות',
	'globalblocking-whitelist-notapplied' => 'חסימות גלובליות אינן פעילות באתר זה,
לכן לא ניתן לשנות את המצב המקומי שלהן.',
	'globalblocking-whitelist-legend' => 'שינוי המצב המקומי',
	'globalblocking-whitelist-reason' => 'סיבה:',
	'globalblocking-whitelist-status' => 'מצב מקומי:',
	'globalblocking-whitelist-statuslabel' => 'ביטול החסימה הגלובלית ב{{grammar:תחילית|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'שינוי המצב המקומי',
	'globalblocking-whitelist-whitelisted' => "החסימה הגלובלית #$2 של כתובת ה־IP '''$1''' בוטלה בהצלחה ב{{grammar:תחילית|{{SITENAME}}}}.",
	'globalblocking-whitelist-dewhitelisted' => "החסימה הגלובלית #$2 של כתובת ה־IP '''$1''' הופעלה מחדש בהצלחה ב{{grammar:תחילית|{{SITENAME}}}}.",
	'globalblocking-whitelist-successsub' => 'המצב המקומי שונה בהצלחה',
	'globalblocking-whitelist-nochange' => 'לא ביצעתם שינוי במצב המקומי של חסימה זו. [[Special:GlobalBlockList|חזרה לרשימת החסימות הגלובליות]].',
	'globalblocking-whitelist-errors' => 'השינוי למצב המקומי של החסימה הגלובלית נכשל בגלל {{PLURAL:$1|הסיבה הבאה|הסיבות הבאות}}:',
	'globalblocking-whitelist-intro' => 'באפשרותכם להשתמש בטופס זה כדי לערוך את המצב המקומי של חסימה גלובלית. אם החסימה הגלובלית תבוטל באתר זה, המשתמשים בכתובת ה־IP המושפעת מהחסימה יוכלו לערוך כרגיל. [[Special:GlobalBlockList|חזרה לרשימת החסימות הגלובליות]].',
	'globalblocking-blocked' => "כתובת ה־IP שלכם \$5 נחסמה בכל אתרי הוויקי על ידי '''\$1''' ('''\$2''').
הסיבה שניתנה הייתה '''\"\$3\"'''.
זמן פקיעת החסימה: '''\$4'''.",
	'globalblocking-blocked-nopassreset' => 'אין באפשרותכם לאפס סיסמאות של משתמשים כיוון שאתם חסומים באופן גלובלי.',
	'globalblocking-logpage' => 'יומן החסימות הגלובליות',
	'globalblocking-logpagetext' => 'זהו יומן החסימות הגלובליות שהופעלו והוסרו באתר זה.
שימו לב שניתן להפעיל ולהסיר חסימות גלובליות גם באתרים אחרים, ושהחסימות הגלובליות האלה עשויות להשפיע גם על האתר הזה.
כדי לצפות בכל החסימות הגלובליות הפעילות, ראו [[Special:GlobalBlockList|רשימת החסימות הגלובליות]].',
	'globalblocking-block-logentry' => 'חסם באופן גלובלי את [[$1]] עם זמן פקיעה של $2',
	'globalblocking-block2-logentry' => 'חסם באופן גלובלי את [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'הסיר את החסימה הגלובלית של [[$1]]',
	'globalblocking-whitelist-logentry' => 'ביטל את החסימה הגלובלית של [[$1]] באופן מקומי',
	'globalblocking-dewhitelist-logentry' => 'הפעיל מחדש את החסימה הגלובלית של [[$1]] באופן מקומי',
	'globalblocking-modify-logentry' => 'שינה את החסימה הגלובלית של [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'עם זמן פקיעה של $1',
	'globalblocking-logentry-noexpiry' => 'ללא זמן פקיעה',
	'globalblocking-loglink' => 'כתובת ה־IP שמספרה $1 חסומה באופן גלובלי ([[{{#Special:GlobalBlockList}}/$1|פרטים נוספים]]).',
	'globalblocking-showlog' => 'כתובת IP זו נחסמה בעבר.
יומן החסימות מוצג להלן:',
	'globalblocklist' => 'רשימת כתובות IP החסומות באופן גלובלי',
	'globalblock' => 'חסימת כתובת IP באופן גלובלי',
	'globalblockstatus' => 'המצב המקומי של החסימות הגלובליות',
	'removeglobalblock' => 'הסרת חסימה גלובלית',
	'right-globalblock' => 'יצירת חסימות גלובליות',
	'action-globalblock' => 'לעשות חסימות גלובליות',
	'right-globalunblock' => 'הסרת חסימות גלובליות',
	'action-globalunblock' => 'לשחרר חסימות גלובליות',
	'right-globalblock-whitelist' => 'ביטול חסימות גלובליות באופן מקומי',
	'action-globalblock-whitelist' => 'לכבות חסימות גלובליות באופן מקומי',
	'right-globalblock-exempt' => 'עקיפת חסימות גלובליות',
	'action-globalblock-exempt' => 'לעקוף חסימות גלובליות',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Kaustubh
 * @author Shyam123.ckp
 */
$messages['hi'] = array(
	'globalblocking-desc' => 'आइपी एड्रेस को [[Special:GlobalBlockList|एक से ज्यादा विकियोंपर ब्लॉक]] करने की [[Special:GlobalBlock|अनुमति]] देता हैं।',
	'globalblocking-block' => 'एक आइपी एड्रेस को ग्लोबलि ब्लॉक करें',
	'globalblocking-modify-intro' => 'वैश्विक अवरोध की सेटिंग्स बदलने के लिए आप इस प्रपत्र का उपयोग कर सकते हैं ।',
	'globalblocking-block-intro' => 'आप इस पन्ने का इस्तेमाल करके सभी विकियोंपर एक आईपी एड्रेस ब्लॉक कर सकतें हैं।',
	'globalblocking-block-reason' => 'कारण:',
	'globalblocking-block-otherreason' => 'अन्य/अतिरिक्त कारण:',
	'globalblocking-block-reasonotherlist' => 'अन्य कारण',
	'globalblocking-block-reason-dropdown' => '* आम ब्लॉक कारण
 ** क्रॉसविकि स्पैमिंग
 ** क्रॉसविकि दुरुपयोग
 ** बर्बरता',
	'globalblocking-block-edit-dropdown' => 'सम्पादन अवरोधी कारण',
	'globalblocking-block-expiry' => 'अवरुद्ध-ब्लॉक समाप्ति वैश्विक',
	'globalblocking-block-expiry-other' => 'अन्य समाप्ती समय',
	'globalblocking-block-expiry-otherfield' => 'अन्य समय:',
	'globalblocking-block-legend' => 'एक सदस्य को ग्लोबली ब्लॉक करें',
	'globalblocking-block-options' => 'विकल्प',
	'globalblocking-ipaddress' => 'आईपी पता:',
	'globalblocking-ipbanononly' => 'केवल अनाम सदस्यों पे प्रतिबंध लगाएँ',
	'globalblocking-block-errors' => 'ब्लॉक अयशस्वी हुआ, कारण:',
	'globalblocking-block-ipinvalid' => 'आपने दिया हुआ आईपी एड्रेस ($1) अवैध हैं।
कृपया ध्यान दें आप सदस्यनाम नहीं दे सकतें!',
	'globalblocking-block-expiryinvalid' => 'आपने दिया हुआ समाप्ती समय ($1) अवैध हैं।',
	'globalblocking-block-submit' => 'इस आईपी को ग्लोबली ब्लॉक करें',
	'globalblocking-modify-submit' => 'इस वैश्विक अवरोध को संशोधित करें',
	'globalblocking-block-success' => '$1 इस आयपी एड्रेसको सभी विकिंयोंपर ब्लॉक कर दिया गया हैं।
आप शायद [[Special:GlobalBlockList|वैश्विक ब्लॉक सूची]] देखना चाहते हैं।',
	'globalblocking-modify-success' => 'वैश्विक अवरोध $1 पे सफलता पुर्बक संशोधित किया गया',
	'globalblocking-block-successsub' => 'ग्लोबल ब्लॉक यशस्वी हुआ',
	'globalblocking-modify-successsub' => 'वैश्विक अवरोध सफलतापूर्वक संशोधित हुई',
	'globalblocking-block-alreadyblocked' => '$1 इस आइपी एड्रेसको पहलेसे ब्लॉक किया हुआ हैं। आप अस्तित्वमें होनेवाले ब्लॉक [[Special:GlobalBlockList|वैश्विक ब्लॉक सूचीमें]] देख सकतें हैं।',
	'globalblocking-list' => 'ग्लोबल ब्लॉक किये हुए आईपी एड्रेसोंकी सूची',
	'globalblocking-search-legend' => 'ग्लोबल ब्लॉक खोजें',
	'globalblocking-search-ip' => 'आइपी एड्रेस:',
	'globalblocking-search-submit' => 'ब्लॉक खोजें',
	'globalblocking-list-ipinvalid' => 'आपने खोजने के लिये दिया हुआ आइपी एड्रेस ($1) अवैध हैं।
कृपया वैध आइपी एड्रेस दें।',
	'globalblocking-search-errors' => 'वैश्विक अवरुद्ध-खोज त्रुटियों',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') ग्लोबली ब्लॉक किया [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'समाप्ती $1',
	'globalblocking-list-anononly' => 'सिर्फ-अनामक',
	'globalblocking-list-unblock' => 'अनब्लॉक',
	'globalblocking-list-whitelisted' => '$1 ने स्थानिक स्तरपर रद्द किया: $2',
	'globalblocking-list-whitelist' => 'स्थानिक स्थिती',
	'globalblocking-list-modify' => 'संशोधित करें',
	'globalblocking-list-noresults' => 'अनुरोध किया गया आईपि पता अवरोध नहीं है ।',
	'globalblocking-goto-block' => 'ग्लोबली एक आईपी पते को अवरोध करें',
	'globalblocking-goto-unblock' => 'एक वैश्विक अवरोध हटाएँ',
	'globalblocking-goto-status' => 'एक वैश्विक अवरोध के लिए स्थानीय स्थिति बदले',
	'globalblocking-return' => 'वैश्विक अवरोध के तालिका में बापिस जाएँ',
	'globalblocking-notblocked' => 'आईपि पता ($1) जो आप निवेश किए ग्लोबली अवरोध नहीं है ।',
	'globalblocking-unblock' => 'एक वैश्विक अवरोध निकाले',
	'globalblocking-unblock-ipinvalid' => 'आपने दिया हुआ आईपी एड्रेस ($1) अवैध हैं।
कृपया ध्यान दें आप सदस्यनाम नहीं दे सकतें!',
	'globalblocking-unblock-legend' => 'ग्लोबल ब्लॉक हटायें',
	'globalblocking-unblock-submit' => 'ग्लोबल ब्लॉक हटायें',
	'globalblocking-unblock-reason' => 'कारण:',
	'globalblocking-unblock-unblocked' => "आपने '''$1''' इस आइपी एड्रेस पर होने वाला ग्लोबल ब्लॉक #$2 हटा दिया हैं",
	'globalblocking-unblock-errors' => 'वैश्विक अवरुद्ध त्रुटियों खोल देना',
	'globalblocking-unblock-successsub' => 'ग्लोबल ब्लॉक हटा दिया गया हैं',
	'globalblocking-unblock-subtitle' => 'वैश्विक अवरोध हटा रहे हैं',
	'globalblocking-unblock-intro' => 'आप इस प्रपत्र की उपयोग वैश्विक अवरोध को निकालने मे कर सकते हैं ।',
	'globalblocking-whitelist' => 'वैश्विक अवरोध के स्थानीय स्थिति',
	'globalblocking-whitelist-legend' => 'स्थानिक स्थिती बदलें',
	'globalblocking-whitelist-reason' => 'कारण:',
	'globalblocking-whitelist-status' => 'स्थानिक स्थिती:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} पर से यह वैश्विक ब्लॉक हटायें',
	'globalblocking-whitelist-submit' => 'स्थानिक स्थिती बदलें',
	'globalblocking-whitelist-whitelisted' => "आपने '''$1''' इस एड्रेसपर दिया हुआ वैश्विक ब्लॉक #$2, {{SITENAME}} पर रद्द कर दिया हैं।",
	'globalblocking-whitelist-dewhitelisted' => "आपने '''$1''' इस आइपी एड्रेसपर दिया हुआ वैश्विक ब्लॉक #$2, {{SITENAME}} पर फिरसे दिया हैं।",
	'globalblocking-whitelist-successsub' => 'स्थानिक स्थिती बदल दी गई हैं',
	'globalblocking-blocked' => "आपके आइपी एड्रेसको सभी विकिमीडिया विकिंवर '''\$1''' (''\$2'') ने ब्लॉक किया हुआ हैं।
इसके लिये ''\"\$3\"'' यह कारण दिया हुआ हैं। इस ब्लॉक की समाप्ति ''\$4'' हैं।",
	'globalblocking-blocked-nopassreset' => 'आप सदस्य के पासवर्ड रीसेट नहीं कर सकते क्यूंकी आप ग्लोबली ब्लॉक्ड है ।',
	'globalblocking-logpage' => 'ग्लोबल ब्लॉक सूची',
	'globalblocking-block-logentry' => '[[$1]] को ग्लोबली ब्लॉक किया समाप्ति समय $2',
	'globalblocking-block2-logentry' => 'ग्लोबली अवरोधित [[$1]] ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] का ग्लोबल ब्लॉक निकाल दिया',
	'globalblocking-whitelist-logentry' => '[[$1]] पर दिया हुआ वैश्विक ब्लॉक स्थानिक स्तरपर रद्द कर दिया',
	'globalblocking-dewhitelist-logentry' => '[[$1]] पर दिया हुआ वैश्विक ब्लॉक स्थानिक स्तरपर फिरसे दिया',
	'globalblocking-modify-logentry' => 'वैश्विक अवरोध को संशोधित करें [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'समयसीमा समाप्त $1',
	'globalblocking-logentry-noexpiry' => 'कोई समय सीमा सेट नहीं',
	'globalblocking-loglink' => 'आईपि पते $1 ग्लोबली ब्लॉक्ड ([[{{#Special:GlobalBlockList}}/$1|पूरी विवरण]]) ।',
	'globalblocking-showlog' => 'आईपि पते पेहले से ही ब्लॉक है ।
नीचे ब्लॉक लॉग दिया गया है संदर्भ के लिए:',
	'globalblocklist' => 'ग्लोबल ब्लॉक होनेवाले आइपी एड्रेसकी सूची',
	'globalblock' => 'एक आइपी एड्रेसको ग्लोबल ब्लॉक करें',
	'globalblockstatus' => 'वैश्विक अवरोध के स्थानीय स्थिति',
	'removeglobalblock' => 'एक वैश्विक अवरोध हटाएँ',
	'right-globalblock' => 'वैश्विक ब्लॉक तैयार करें',
	'right-globalunblock' => 'वैश्विक ब्लॉक हटा दें',
	'right-globalblock-whitelist' => 'वैश्विक ब्लॉक स्थानिक स्तरपर रद्द करें',
	'right-globalblock-exempt' => 'बाईपास वैश्विक ब्लॉक',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'globalblocking-unblock-reason' => 'Rason:',
);

/** Croatian (Hrvatski)
 * @author CERminator
 * @author Dalibor Bosits
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Omogućuje]] blokiranje IP adresa [[Special:GlobalBlockList|na svim wikijima]]',
	'globalblocking-block' => 'Globalno blokiraj IP adresu',
	'globalblocking-modify-intro' => 'Možete koristiti ovaj obrazac za promjenu postavki globalnog blokiranja.',
	'globalblocking-block-intro' => 'Možete koristiti ovu stranicu kako biste blokirali IP adresu na svim wikijima.',
	'globalblocking-block-reason' => 'Razlog:',
	'globalblocking-block-otherreason' => 'Drugi/dodatni razlog:',
	'globalblocking-block-reasonotherlist' => 'Drugi razlog',
	'globalblocking-block-reason-dropdown' => '* Uobičajeni razlozi blokiranja
** Spamovi na više wikija
** Zloupotreba na više wikiija
** Vandalizam',
	'globalblocking-block-edit-dropdown' => 'Uredi razloge blokiranja',
	'globalblocking-block-expiry' => 'Istječe:',
	'globalblocking-block-expiry-other' => 'Drugo vrijeme isteka',
	'globalblocking-block-expiry-otherfield' => 'Drugo vrijeme:',
	'globalblocking-block-legend' => 'Globalno blokiranje IP adrese',
	'globalblocking-block-options' => 'Mogućnosti:',
	'globalblocking-block-errors' => 'Vaše blokiranje je neuspješno, iz {{PLURAL:$1|sljedećeg razloga|sljedećih razloga}}:',
	'globalblocking-block-ipinvalid' => 'IP adresa ($1) koju ste upisali je neispravna.
Uzmite u obzir da ne možete upisati suradničko ime!',
	'globalblocking-block-expiryinvalid' => 'Vremenski rok koji ste upisali ($1) je neispravan.',
	'globalblocking-block-submit' => 'Blokiraj ovu IP adresu globalno',
	'globalblocking-modify-submit' => 'Izmijeni ovo globalno blokiranje',
	'globalblocking-block-success' => 'IP adresa $1 je uspješno blokirana na svim projektima.',
	'globalblocking-modify-success' => 'Globalno blokiranje na $1 uspješno je izmijenjeno',
	'globalblocking-block-successsub' => 'Globalno blokiranje je uspješno',
	'globalblocking-modify-successsub' => 'Globalno blokiranje uspješno je izmijenjeno',
	'globalblocking-block-alreadyblocked' => 'IP adresa $1 je već globalno blokirana.
Možete vidjeti postojeća blokiranja na [[Special:GlobalBlockList|popisu globalnih blokiranja]],
ili promijeniti postavke postojećeg blokiranja slanjem ovog obrasca.',
	'globalblocking-block-bigrange' => 'Opseg koji ste odredili ($1) je prevelik za blokiranje.
Možete blokirati najviše 65,536 adresa (/16 opseg)',
	'globalblocking-list-intro' => 'Ovo je popis globalno blokiranih adresu trenutačno aktivnih.
Neka blokiranja su označena kao mjesno onemogućena: to znači da je blokiranje aktivno na drugim projektima, ali ne na ovom wikiju.',
	'globalblocking-list' => 'Popis globalno blokiranih IP adresa',
	'globalblocking-search-legend' => 'Traži globalno blokiranje',
	'globalblocking-search-ip' => 'IP adresa:',
	'globalblocking-search-submit' => 'Traži blokiranja',
	'globalblocking-list-ipinvalid' => 'IP adresa koju ste tražili ($1) je neispravna.
Molimo vas upišite ispravnu IP adresu.',
	'globalblocking-search-errors' => 'Važe traženje je neuspješno, iz {{PLURAL:$1|sljedećeg razloga|sljedećih razloga}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') globalno blokirao [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'istječe $1',
	'globalblocking-list-anononly' => 'samo neprijavljeni',
	'globalblocking-list-unblock' => 'ukloni',
	'globalblocking-list-whitelisted' => '$1 mjesno onemogućio: $2',
	'globalblocking-list-whitelist' => 'mjesni status',
	'globalblocking-list-modify' => 'izmijeni',
	'globalblocking-list-noresults' => 'Tražena IP adresa nije blokirana.',
	'globalblocking-goto-block' => 'Globalno blokiraj IP adresu',
	'globalblocking-goto-unblock' => 'Ukloni globalno blokiranje',
	'globalblocking-goto-status' => 'Promijeni mjesni status za globalno blokiranje',
	'globalblocking-return' => 'Vrati se na popis globalnih blokiranja',
	'globalblocking-notblocked' => 'IP adresa ($1) koju ste upisali nije globalno blokirana.',
	'globalblocking-unblock' => 'Ukloni globalno blokiranje',
	'globalblocking-unblock-ipinvalid' => 'IP adresa ($1) koju ste upisali je neispravna.
Molimo vas uzmite u obzir da ne možete upisati suradničko ime!',
	'globalblocking-unblock-legend' => 'Ukloni globalno blokiranje',
	'globalblocking-unblock-submit' => 'Ukloni globalno blokiranje',
	'globalblocking-unblock-reason' => 'Razlog:',
	'globalblocking-unblock-unblocked' => "Uspješno ste uklonili globalno blokiranje #$2 za IP adresu '''$1'''",
	'globalblocking-unblock-errors' => 'Vaše uklanjanje globalnog blokiranja je neuspješno, iz {{PLURAL:$1|sljedećeg razloga|sljedećih razloga}}:',
	'globalblocking-unblock-successsub' => 'Globalno blokiranje uspješno uklonjeno',
	'globalblocking-unblock-subtitle' => 'Uklanjanje globalnog blokiranja',
	'globalblocking-unblock-intro' => 'Ovu stranicu možete koristiti za uklanjanje globalnog blokiranja.',
	'globalblocking-whitelist' => 'Mjesni status globalnih blokiranja',
	'globalblocking-whitelist-notapplied' => 'Globalna blokiranja se ne primjenjuju na ovom wikiju, pa se lokalni status globalnih blokiranja ne može mijenjati.',
	'globalblocking-whitelist-legend' => 'Promijeni mjesni status',
	'globalblocking-whitelist-reason' => 'Razlog:',
	'globalblocking-whitelist-status' => 'Mjesni status:',
	'globalblocking-whitelist-statuslabel' => 'Onemogući ovo globalno blokiranje na {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Promijeni mjesni status',
	'globalblocking-whitelist-whitelisted' => "Uspješno ste onemogućili globalno blokiranje #$2 za IP adresu '''$1''' na {{SITENAME}}",
	'globalblocking-whitelist-dewhitelisted' => "Uspješno ste omogućili globalno blokiranje #$2 za IP adresu '''$1''' na {{SITENAME}}",
	'globalblocking-whitelist-successsub' => 'Mjesni status uspješno promijenjen',
	'globalblocking-whitelist-nochange' => 'Niste napravili promjene za mjesni status ovog blokiranja.
[[Special:GlobalBlockList|Vrati se na popis globalno blokiranih adresa]].',
	'globalblocking-whitelist-errors' => 'Vaša promjena mjesnog statusa za globalno blokiranje je neuspješna, iz {{PLURAL:$1|sljedećeg razloga|sljedećih razloga}}:',
	'globalblocking-whitelist-intro' => 'Možete koristiti ovu stranicu za uređivanje mjesnog statusa globalnog blokiranja.
Ako je globalno blokiranje onemogućeno na ovom wikiju, suradnici s tom IP adresom će moći normalno uređivati.
[[Special:GlobalBlockList|Vrati se na popis globalno blokiranih adresa]].',
	'globalblocking-blocked' => "Vaša IP adresa je blokirana na svim wikijima od '''\$1''' (''\$2'').
Razlog je ''\"\$3\"''.
Blokiranje ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Ne možete resetirati lozinke suradnika jer ste blokirani globalno.',
	'globalblocking-logpage' => 'Evidencija globalnog blokiranja',
	'globalblocking-logpagetext' => 'Ovo je evidencija globalnih blokiranja koja su napravljena ili uklonjena na ovom wikiju.
Globalno blokiranje može biti napravljeno i uklonjeno na drugim wikijima, i ova globalna blokiranja mogu imati utjecaj na ovom wikiju.
Za popis svih aktivnih globalnih blokiranja, pogledajte [[Special:GlobalBlockList|popis globalnih blokiranja]].',
	'globalblocking-block-logentry' => 'globalno blokirao [[$1]] s istekom vremena od $2',
	'globalblocking-block2-logentry' => 'globalno blokirao [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'uklonio globalno blokiranje za [[$1]]',
	'globalblocking-whitelist-logentry' => 'onemogućio mjesno globalno blokiranje za [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'mjesno omogućio globalno blokiranje za [[$1]]',
	'globalblocking-modify-logentry' => 'izmijeni globalno blokiranje na [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'blokada istječe $1',
	'globalblocking-logentry-noexpiry' => 'istek nije postavljen',
	'globalblocking-loglink' => 'IP adresa $1 je blokirana globalno ([[{{#Special:GlobalBlockList}}/$1|svi detalji]]).',
	'globalblocking-showlog' => 'Ova IP adresa je ranije bila blokirana.
Evidencija blokiranja navedena je niže kao napomena:',
	'globalblocklist' => 'Popis globalno blokiranih IP adresa',
	'globalblock' => 'Globalno blokiraj IP adresu',
	'globalblockstatus' => 'Mjesni status globalnih blokiranja',
	'removeglobalblock' => 'Ukloni globalno blokiranje',
	'right-globalblock' => 'Mogućnost globalnog blokiranja',
	'right-globalunblock' => 'Uklanjanje globalnog blokiranja',
	'right-globalblock-whitelist' => 'Mjesno uklanjanje globalnog blokiranja',
	'right-globalblock-exempt' => 'Zaobilaženje globalnih blokiranja',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Zmóžnja]] IP-adresy [[Special:GlobalBlockList|přez wjacore wikije blokować]]',
	'globalblocking-block' => 'IP-adresu globalnje blokować',
	'globalblocking-modify-intro' => 'Móžeš tutón formular wužiwać, zo by nastajenja globalneho blokowanja změnił.',
	'globalblocking-block-intro' => 'Móžeš tutu stronu wužiwać, zo by Ip-adresu na wšěch wikijach blokował.',
	'globalblocking-block-reason' => 'Přičina:',
	'globalblocking-block-otherreason' => 'Druha/přidatna přičina:',
	'globalblocking-block-reasonotherlist' => 'Druha přičina',
	'globalblocking-block-reason-dropdown' => '* Zwučene přičiny blokowanja
** Spamowanje crosswiki
** Znjewužiwanje crosswiki
** Wandalizm',
	'globalblocking-block-edit-dropdown' => 'Přičiny blokowanja wobdźěłać',
	'globalblocking-block-expiry' => 'Spadnjenje:',
	'globalblocking-block-expiry-other' => 'Druhi čas spadnjenja',
	'globalblocking-block-expiry-otherfield' => 'Druhi čas:',
	'globalblocking-block-legend' => 'IP-adresu globalnje blokować',
	'globalblocking-block-options' => 'Opcije:',
	'globalblocking-ipaddress' => 'IP-adresa:',
	'globalblocking-ipbanononly' => 'Jenož anonymnych wužiwarjow blokować',
	'globalblocking-block-errors' => 'Twoje blokowanje je ze {{PLURAL:$1|slědowaceje přičiny|slědowaceju přičinow|slědowacych přičinow|slědowacych přičinow}} njewuspěšne było:',
	'globalblocking-block-ipinvalid' => 'IP-adresa ($1), kotruž sy zapodał, je njepłaćiwa.
Prošu dźiwaj na to, zo njesměš wužiwarske mjeno zapodać!',
	'globalblocking-block-expiryinvalid' => 'Čas spadnjenja, kotryž sy zapodał ($1), je njepłaćiwy.',
	'globalblocking-block-submit' => 'Tutu IP-adresu globalnje blokować',
	'globalblocking-modify-submit' => 'Tute globalne blokowanje změnić',
	'globalblocking-block-success' => 'IP-adresa $1 bu wuspěšnje we wšěch projektach blokowana.',
	'globalblocking-modify-success' => 'Globalne blokowanje na $1 je so wuspěšnje změniło.',
	'globalblocking-block-successsub' => 'Globalne blokowanje wuspěšne',
	'globalblocking-modify-successsub' => 'Globalne blokowanje wuspěšnje změnjeny',
	'globalblocking-block-alreadyblocked' => 'IP-adresa $1 je hižo globalnje zablokokowana.
Móžeš sej eksistowace blokowanje na [[Special:GlobalBlockList|lisćinje globalnych blokowanjow]] wobhladać abo nastajenja eksistowaceho blokowanja přez wospjetowane wotpósłanje formulara změnić.',
	'globalblocking-block-bigrange' => 'Wobwod, kotryž sy podał ($1), je přewulki za blokowanje.
Móžeš maksimalnje 65.636 adresow (/16 wobwodow) blokować.',
	'globalblocking-list-intro' => 'To je lisćina wšěch lokalnych blokowanjow, kotrež su tuchwilu aktiwne.
Někotre blokowanja su jako lokalnje znjemóžnjene markěrowane. To woznamjenja, zo skutkuja na druhich projektach, ale lokalny administrator je rozsudźił, je na tutym wikiju znjemóžnić.',
	'globalblocking-list' => 'Lisćina globalnych zablokowanych IP-adresow',
	'globalblocking-search-legend' => 'Globalne blokowanje pytać',
	'globalblocking-search-ip' => 'IP-adresa:',
	'globalblocking-search-submit' => 'Blokowanja pytać',
	'globalblocking-list-ipinvalid' => 'IP-adresu, kotruž sy pytał ($1), je njepłaćiwa.
Prošu zapodaj płaćiwu IP-adresu.',
	'globalblocking-search-errors' => 'Twoje pytanje njeje ze {{PLURAL:$1|slědowaceje přičiny|slědowaceju přičinow|slědowacych přičinow|slědowacych přičinow}} wuspěšne było:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') je [[Special:Contributions/\$4|\$4]] ''(\$5)'' globalnje zablokował",
	'globalblocking-list-expiry' => 'Čas spadnjenja $1',
	'globalblocking-list-anononly' => 'jenož anonymne',
	'globalblocking-list-unblock' => 'wotstronić',
	'globalblocking-list-whitelisted' => 'lokalnje znjemóžnjeny wot $1: $2',
	'globalblocking-list-whitelist' => 'lokalny status',
	'globalblocking-list-modify' => 'změnić',
	'globalblocking-list-noresults' => 'Požadana IP-adresa njeje zablokowany.',
	'globalblocking-goto-block' => 'IP-adresu globalnje blokować',
	'globalblocking-goto-unblock' => 'Globalne blokowanje wotstronić',
	'globalblocking-goto-status' => 'Lokalny status za globalne blokowanje změnić',
	'globalblocking-return' => 'Wróćo k lisćinje globalnych blokowanjow',
	'globalblocking-notblocked' => 'IP-adresa ($1), kotruž sy zapodał, njeje globalnje zablokowana.',
	'globalblocking-unblock' => 'Globalne blokowanje wotstronić',
	'globalblocking-unblock-ipinvalid' => 'IP-adresa ($1), kotruž sy zapodał, je njepłaćiwa.
Prošu dźiwaj na to, zo njesměš wužiwarske mjeno zapodać!',
	'globalblocking-unblock-legend' => 'Globalne blokowanje wotstronić',
	'globalblocking-unblock-submit' => 'Globalne blokowanje wotstronić',
	'globalblocking-unblock-reason' => 'Přičina:',
	'globalblocking-unblock-unblocked' => "Sy globalne blokowanje #$2 za IP-adresu '''$1''' wuspěšnje wotstronił",
	'globalblocking-unblock-errors' => 'Wotstronjenje globalneho blokowanja bě ze {{PLURAL:$1|slědowaceje přičiny|slědowaceju přičinow|slědowacych přičinow|slědowacych přičinow}} njewuspěšne:',
	'globalblocking-unblock-successsub' => 'Globalne blokowanje wuspěšnje wotstronjene',
	'globalblocking-unblock-subtitle' => 'Globalne blokowanje so wotstronja',
	'globalblocking-unblock-intro' => 'Móžeš tutón formular wužiwać, zo by globalne blokowanje wotstronił.',
	'globalblocking-whitelist' => 'Lokalny status globalnych blokowanjow',
	'globalblocking-whitelist-notapplied' => 'Globalne blokowanja so na tutón wiki njenałožuja,
tohodla lokalny status globalnych blokowanjow njeda so změnić.',
	'globalblocking-whitelist-legend' => 'Lokalny status změnić',
	'globalblocking-whitelist-reason' => 'Přičina:',
	'globalblocking-whitelist-status' => 'Lokalny status:',
	'globalblocking-whitelist-statuslabel' => 'Tute globalne blokowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}} znjemóžnić',
	'globalblocking-whitelist-submit' => 'Lokalny status změnić',
	'globalblocking-whitelist-whitelisted' => "Sy globalne blokowanje #$2 za IP-adresu '''$1''' na {{GRAMMAR:lokatiw|{{SITENAME}}}} wuspěšnje znjemóžnił.",
	'globalblocking-whitelist-dewhitelisted' => "Sy globalne blokowanje #$2 za IP-adresu '''$1''' na {{GRAMMAR:lokatiw|{{SITENAME}}}} zaso zmóžnił.",
	'globalblocking-whitelist-successsub' => 'Lokalny status wuspěšnje změnjeny',
	'globalblocking-whitelist-nochange' => 'Njejsy lokalny status tutoho blokowanja změnił.
[[Special:GlobalBlockList|Wróćo k lisćinje globalnych blokowanjow]].',
	'globalblocking-whitelist-errors' => 'Twoje změnjenje lokalneho statusa globalneho blokowanja bě ze {{PLURAL:$1|slědowaceje přičiny|slědowaceju přičinow|slědowacych přičinow|slědowacych přičinow}} njewuspěšne:',
	'globalblocking-whitelist-intro' => 'Móžeš tutón formular wužiwać, zo by lokalny status globalneho blokowanja wobdźěłał.
Jeli je globalne blokowanje na tutym wikiju znjemóžnjene, móža wužiwarjo z wotpowědnej IP-adresu normalnje wobdźěłać.
[[Special:GlobalBlockList|Wróćo k lisćinje globalnych blokowanjow]].',
	'globalblocking-blocked' => "Twoja IP-adresa \$5 bu na wšěch wikijach wot '''\$1''' (''\$2'') zablokowana.
Podata přičina bě ''\"\$3\"''.
Blokowanje ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Njemóžeš hesła wužiwarja cofnyć, dokelž sy globalnje blokowany.',
	'globalblocking-logpage' => 'Protokol globalnych blokowanjow',
	'globalblocking-logpagetext' => 'To je protokol globalnych blokowanjow, kotrež buchu na tutym wikiju přewjedźene a wotstronjene.
Wobkedźbuj, zo globalne blokowanja dadźa so na druhich wikijach přewjesć a wotstronić a zo tute globalne blokowanja móža tutón wiki wobwliwować.
Zo by sej wšě aktiwne globalne blokowanja wobhladał, móžeš sej [[Special:GlobalBlockList|lisćinu globalnych blokowanjow]] wobhladać.',
	'globalblocking-block-logentry' => 'je [[$1]] za dobu $2 globalnje zablokował',
	'globalblocking-block2-logentry' => 'globalnje zablokowany [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'je globalne blokowanje za [[$1]] wotstronił',
	'globalblocking-whitelist-logentry' => 'je globalne blokowanje za [[$1]] lokalnje znjemóžnił',
	'globalblocking-dewhitelist-logentry' => 'je globalne blokowanje za [[$1]] lokalnje zaso zmóžnił',
	'globalblocking-modify-logentry' => 'je globalne blokowanje na [[$1]] ($2) změnił',
	'globalblocking-logentry-expiry' => 'spadnje $1',
	'globalblocking-logentry-noexpiry' => 'žane spadnjenje postajene',
	'globalblocking-loglink' => 'IP-adresa $1 je globalnje zablokowana ([[{{#Special:GlobalBlockList}}/$1|wšě podrobnosće]]).',
	'globalblocking-showlog' => 'Tuta IP-adresa bu prjedy zablokowana.
Protokol blokowanjow podawa so deleka jako referencu:',
	'globalblocklist' => 'Lisćina globalnych zablokowanych IP-adresow',
	'globalblock' => 'IP-adresu globalnje blokować',
	'globalblockstatus' => 'Lokalny status globalnych blokowanjow',
	'removeglobalblock' => 'Globalne blokowanje wotstronić',
	'right-globalblock' => 'Globalne blokowanja činić',
	'action-globalblock' => 'globalne blokowanja činić',
	'right-globalunblock' => 'Globalne blokowanja wotstronić',
	'action-globalunblock' => 'globalne blokowanja wotstronić',
	'right-globalblock-whitelist' => 'Globalne blokowanja lokalnje znjemóžnić',
	'action-globalblock-whitelist' => 'globalne blokowanja lokalnje znjemóžnić',
	'right-globalblock-exempt' => 'Globalne blokowanja wobeńć',
	'action-globalblock-exempt' => 'globalne blokowanja wobeńć',
);

/** Haitian (Kreyòl ayisyen)
 * @author Boukman
 * @author Jvm
 */
$messages['ht'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Pemèt]] adrès IP yo [[Special:GlobalBlockList|bloke atravè plizyè wiki]]',
	'globalblocking-block' => 'Bloke yon adrès IP globalman',
	'globalblocking-block-intro' => 'Ou kapab itilize paj sa pou bloke yon adrès IP nan tout wiki yo.',
	'globalblocking-block-reason' => 'Rezon:',
	'globalblocking-block-expiry' => 'Ekspirasyon:',
	'globalblocking-block-expiry-other' => 'Lòt delè pou ekspirasyon',
	'globalblocking-block-expiry-otherfield' => 'Lòt delè:',
	'globalblocking-block-legend' => 'Bloke yon adrès IP globalman',
	'globalblocking-block-options' => 'Opsyon yo:',
	'globalblocking-block-errors' => 'Blokaj sa pa reyisi pou {{PLURAL:$1|rezon sa|rezon sa yo}}:',
	'globalblocking-block-ipinvalid' => 'Adrès IP sa ($1) ou te antre a pa bon.
Tanpri note ke ou pa kapab antre yon non itlizatè!',
	'globalblocking-block-expiryinvalid' => 'Expirasyon ($1) ou te antre a pa bon.',
	'globalblocking-block-submit' => 'Bloke adrès IP sa globalman',
	'globalblocking-block-success' => 'Adrès IP $1 byen bloke nan tout pwojè yo.',
	'globalblocking-block-successsub' => 'Blokaj global reyisi',
	'globalblocking-block-alreadyblocked' => 'Adrès IP $1 deja bloke globalman.
Ou ka wè blokaj ki deja ekziste a nan [[Special:GlobalBlockList|lis blokaj global yo]], oubyen voye fomilè sa ankò pou modifye paramèt blokaj la.',
	'globalblocking-list' => 'Lis adrès IP ki bloke globalman yo',
	'globalblocking-search-legend' => 'Chache pou yon blokaj global',
	'globalblocking-search-ip' => 'Adrès IP:',
	'globalblocking-search-submit' => 'Chache pou blokaj yo',
	'globalblocking-list-ipinvalid' => 'Adrès IP ou t ap chache pou ($1) pa bon.
Tanpri antre yon adrès IP ki bon.',
	'globalblocking-search-errors' => 'Rechèch ou a pa t reyisi pou rezon {{PLURAL:$1|sa|sa yo}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bloke globalman '''[[Special:Contributions/\$4|\$4]]''' ''(\$5)''",
	'globalblocking-list-expiry' => 'expirasyon $1',
	'globalblocking-list-anononly' => 'Anonim sèlman',
	'globalblocking-list-unblock' => 'Debloke',
	'globalblocking-list-whitelisted' => 'Te deaktive lokalman pa $1: $2',
	'globalblocking-list-whitelist' => 'estati lokal',
	'globalblocking-unblock-ipinvalid' => 'Adrès IP ($1) ou te antre a pa bon.
Tanpri note ke ou pa kapab antre yon non itilizatè!',
	'globalblocking-unblock-legend' => 'Retire yon blokaj global',
	'globalblocking-unblock-submit' => 'Retire blokaj global',
	'globalblocking-unblock-reason' => 'Rezon:',
	'globalblocking-unblock-unblocked' => "Ou reyisi retire blokaj global #$2 sou adrès IP '''$1'''",
	'globalblocking-unblock-errors' => 'Ou pa t kabap retire yon blokaj global pou adrès IP sa pou rezon {{PLURAL:$1|sa|sa yo}}:',
	'globalblocking-unblock-successsub' => 'Blokaj global reyisi retire.',
	'globalblocking-whitelist-legend' => 'Chanje estati local',
	'globalblocking-whitelist-reason' => 'Rezon:',
	'globalblocking-whitelist-status' => 'Estati lokal:',
	'globalblocking-whitelist-statuslabel' => 'Dezame blokaj global sa nan {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Chanje estati lokal',
	'globalblocking-whitelist-whitelisted' => "Ou reyisi retire blokaj global #$2 pou adrès IP '''$1''' nan {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Ou te reyisi remèt blokaj global #$2 sou adrès IP '''$1''' nan {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Estati lokal te reyisi chanje',
	'globalblocking-blocked' => "Adrès IP w la te bloke nan tout wiki yo pa '''\$1''' (''\$2'').
Rezon ki te bay la se ''\"\$3\"''.
Blòkaj la ''\$4''.",
	'globalblocking-logpage' => 'Jounal blokaj global',
	'globalblocking-block-logentry' => 'te bloke globalman [[$1]] avèk yon tan ekspirasyon $2',
	'globalblocking-unblock-logentry' => 'retire blokaj global la sou [[$1]]',
	'globalblocking-whitelist-logentry' => 'dezame blokaj global la sou [[$1]] lokalman',
	'globalblocking-dewhitelist-logentry' => 're-mete blokaj global sou [[$1]] lokalman',
	'globalblocklist' => 'Lis Adrès IP bloke globalman yo',
	'globalblock' => 'Bloke yon adrès IP globalman',
	'right-globalblock' => 'Fè blokaj global',
	'right-globalunblock' => 'Retire blokaj global yo',
	'right-globalblock-whitelist' => 'Dezame blokaj global yo lokalman',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dj
 * @author Dorgan
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Lehetővé teszi]] IP-címek [[Special:GlobalBlockList|blokkolását]] egyszerre több wikiben',
	'globalblocking-block' => 'IP-cím globális blokkolása',
	'globalblocking-modify-intro' => 'Ezen az űrlapon módosíthatod egy globális blokk beállításait.',
	'globalblocking-block-intro' => 'A lap segítségével az összes wikin blokkolhatsz egy IP-címet.',
	'globalblocking-block-reason' => 'Indoklás:',
	'globalblocking-block-otherreason' => 'Egyéb/további indok:',
	'globalblocking-block-reasonotherlist' => 'Egyéb indok',
	'globalblocking-block-reason-dropdown' => '* Gyakori blokkolási okok
** Wikiközi spammelés
** Wikiközi visszaélés
** Vandalizmus',
	'globalblocking-block-edit-dropdown' => 'Blokkolási okok szerkesztése',
	'globalblocking-block-expiry' => 'Lejárat:',
	'globalblocking-block-expiry-other' => 'Más lejárati idő',
	'globalblocking-block-expiry-otherfield' => 'Más időtartam:',
	'globalblocking-block-legend' => 'IP-cím globális blokkolása',
	'globalblocking-block-options' => 'Beállítások:',
	'globalblocking-ipaddress' => 'IP-cím:',
	'globalblocking-ipbanononly' => 'Csak anonim felhasználók blokkolása',
	'globalblocking-block-errors' => 'A blokkolás nem sikerült, az alábbi {{PLURAL:$1|ok|okok}} miatt:',
	'globalblocking-block-ipinvalid' => 'Az általad megadott IP-cím ($1) érvénytelen.
Nem adhatsz meg felhasználói nevet!',
	'globalblocking-block-expiryinvalid' => 'A megadott lejárati idő ($1) érvénytelen.',
	'globalblocking-block-submit' => 'IP-cím blokkolása globálisan',
	'globalblocking-modify-submit' => 'Globális blokk módosítása',
	'globalblocking-block-success' => 'Az „$1” IP-cím sikeresen blokkolva lett az összes projekten.',
	'globalblocking-modify-success' => '$1 globális blokkja sikeresen módosítva',
	'globalblocking-block-successsub' => 'A globális blokkolás sikerült',
	'globalblocking-modify-successsub' => 'Globális blokk sikeresen módosítva',
	'globalblocking-block-alreadyblocked' => 'Az $1 IP cím már blokkolva van globálisan.
Az érvényben lévő blokkot a [[Special:GlobalBlockList|globális blokkok listájában]] tekintheted meg,
vagy módosíthatod a jelenleg érvényben lévő blokk beállításait ezen űrlap elküldésével.',
	'globalblocking-block-bigrange' => 'Az általad megadott tartomány ($1) túl nagy a blokkoláshoz.
Legfeljebb 65 536 címet blokkolhatsz (/16-os tartományokat)',
	'globalblocking-list-intro' => 'Ezen a lapon a jelenleg érvényben lévő globális blokkok listája látható.
Néhány blokk helyileg feloldottként van jelölve: ez azt jelenti, hogy míg más oldalakon alkalmazzák, addig a helyi adminisztátorok úgy döntöttek, hogy feloldják ezen a wikin.',
	'globalblocking-list' => 'Globálisan blokkolt IP-címek listája',
	'globalblocking-search-legend' => 'Globális blokk keresése',
	'globalblocking-search-ip' => 'IP-címek:',
	'globalblocking-search-submit' => 'Blokkok keresése',
	'globalblocking-list-ipinvalid' => 'Az általad megadott IP-cím ($1) érvénytelen.
Kérlek adj meg egy érvényes címet.',
	'globalblocking-search-errors' => 'A keresés sikertelen volt az alábbi {{PLURAL:$1|ok|okok}} miatt:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') globálisan blokkolta a(z) [[Special:Contributions/\$4|\$4]] nevű szerkesztőt ''(\$5)''",
	'globalblocking-list-expiry' => 'lejárat: $1',
	'globalblocking-list-anononly' => 'csak be nem jelentkezett',
	'globalblocking-list-unblock' => 'eltávolítás',
	'globalblocking-list-whitelisted' => 'helyben feloldotta $1: $2',
	'globalblocking-list-whitelist' => 'helyi állapot',
	'globalblocking-list-modify' => 'módosítás',
	'globalblocking-list-noresults' => 'A kért IP-cím nincs blokkolva.',
	'globalblocking-goto-block' => 'IP-cím globális blokkolása',
	'globalblocking-goto-unblock' => 'Globális blokk eltávolítása',
	'globalblocking-goto-status' => 'Globális blokk helyi állapotának megváltoztatása',
	'globalblocking-return' => 'Visszatérés a globális blokkok listájához',
	'globalblocking-notblocked' => 'Az általad megadott IP-cím ($1) nincs globálisan blokkolva.',
	'globalblocking-unblock' => 'Globális blokk eltávolítása',
	'globalblocking-unblock-ipinvalid' => 'Az általad megadott IP-cím ($1) érvénytelen.
Nem adhatsz meg felhasználói nevet!',
	'globalblocking-unblock-legend' => 'Globális blokk eltávolítása',
	'globalblocking-unblock-submit' => 'Globális blokk eltávolítása',
	'globalblocking-unblock-reason' => 'Ok:',
	'globalblocking-unblock-unblocked' => "Sikeresen eltávolítottad a(z) $2 azonosítójú globális blokkot a(z) '''$1''' IP-címről",
	'globalblocking-unblock-errors' => 'A globális blokk eltávolítása sikertelen az alábbi {{PLURAL:$1|ok|okok}} miatt:',
	'globalblocking-unblock-successsub' => 'Globális blokk sikeresen eltávolítva',
	'globalblocking-unblock-subtitle' => 'Globális blokk eltávolítása',
	'globalblocking-unblock-intro' => 'Az űrlap használatával eltávolíthatsz egy globális blokkot.',
	'globalblocking-whitelist' => 'Globális blokkok helyi állapota',
	'globalblocking-whitelist-notapplied' => 'A globális blokkok nem érvényesek ezen a wikin,
így a helyi állapotuk nem módosítható.',
	'globalblocking-whitelist-legend' => 'Helyi állapot megváltoztatása',
	'globalblocking-whitelist-reason' => 'Indoklás:',
	'globalblocking-whitelist-status' => 'Helyi állapot:',
	'globalblocking-whitelist-statuslabel' => 'A blokk feloldása a(z) {{SITENAME}} wikin',
	'globalblocking-whitelist-submit' => 'Helyi állapot megváltoztatása',
	'globalblocking-whitelist-whitelisted' => "Sikeresen kikapcsoltad a(z) '''$1''' IP-címre vonatkozó $2 azonosítójú blokkot a(z) {{SITENAME}} wikin.",
	'globalblocking-whitelist-dewhitelisted' => "Sikeresen engedélyezted a(z) '''$1''' IP-címre vonatkozó $2 azonosítójú blokkot a(z) {{SITENAME}} wikin.",
	'globalblocking-whitelist-successsub' => 'Helyi állapot sikeresen megváltoztatva',
	'globalblocking-whitelist-nochange' => 'Nem változtattad meg a blokk helyi állapotát.
[[Special:GlobalBlockList|Visszatérés a globális blokkok listájához]].',
	'globalblocking-whitelist-errors' => 'Nem sikerült megváltoztatnod a blokk helyi állapotát az alábbi {{PLURAL:$1|ok|okok}} miatt:',
	'globalblocking-whitelist-intro' => 'Az alábbi űrlap használatával megváltoztathatod egy globális blokk helyi állapotát.
Ha egy globális blokk fel van oldva ezen a wikin, az IP-címet használó szerkesztők újra képesek lesznek szerkeszteni a wikit.
[[Special:GlobalBlockList|Visszatérés a globális blokkok listájához]].',
	'globalblocking-blocked' => "Az IP-címedet ($5) az összes wikin blokkolta '''$1''' (''$2'').
A blokkolás oka: ''„$3”''.
A blokk ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Nem kérhetsz új jelszót, mert globálisan blokkolva vagy.',
	'globalblocking-logpage' => 'Globális blokkolási napló',
	'globalblocking-logpagetext' => 'Ez azon globális blokkok naplója, amelyet ezen a wikin készítettek és távolítottak el.
Globális blokkokat más wikiken is készíthetnek és távolíthatnak el, ezek hatással lehetnek erre a wikire is.
Az összes aktív blokk listáját a [[Special:GlobalBlockList|globális blokkok listáján]] találod meg.',
	'globalblocking-block-logentry' => 'globálisan blokkolta [[$1]] szerkesztőt, $2 lejárati idővel',
	'globalblocking-block2-logentry' => 'globálisan blokkolta [[$1]] szerkesztőt ($2)',
	'globalblocking-unblock-logentry' => 'eltávolította [[$1]] globális blokkját',
	'globalblocking-whitelist-logentry' => 'feloldotta [[$1]] globális blokkját helyileg',
	'globalblocking-dewhitelist-logentry' => 'újra engedélyezte [[$1]] globális blokkját helyileg',
	'globalblocking-modify-logentry' => 'módosította [[$1]] globális blokkját ($2)',
	'globalblocking-logentry-expiry' => 'lejárat: $1',
	'globalblocking-logentry-noexpiry' => 'nem adott meg lejárati időt',
	'globalblocking-loglink' => 'A(z) $1 IP-cím globálisan blokkolva van ([[{{#Special:GlobalBlockList}}/$1|részletek]]).',
	'globalblocking-showlog' => 'Ez az IP-cím korábban már blokkolva volt.
A blokkolási napló alább látható tájékoztatásul:',
	'globalblocklist' => 'Globálisan blokkolt IP-címek listája',
	'globalblock' => 'IP-cím globális blokkolása',
	'globalblockstatus' => 'Globális blokkok helyi állapota',
	'removeglobalblock' => 'Globális blokk eltávolítása',
	'right-globalblock' => 'globális blokkok készítése',
	'right-globalunblock' => 'globális blokkok eltávolítása',
	'right-globalblock-whitelist' => 'globális blokkok kikapcsolása helyileg',
	'right-globalblock-exempt' => 'globális blokkok figyelmen kívül hagyása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permitte]] que adresses IP sia [[Special:GlobalBlockList|blocate trans plure wikis]]',
	'globalblocking-block' => 'Blocar globalmente un adresse IP',
	'globalblocking-modify-intro' => 'Tu pote usar iste formulario pro cambiar le configurationes de un blocada global.',
	'globalblocking-block-intro' => 'Tu pote usar iste pagina pro blocar un adresse IP in tote le wikis.',
	'globalblocking-block-reason' => 'Motivo:',
	'globalblocking-block-otherreason' => 'Altere/additional motivo:',
	'globalblocking-block-reasonotherlist' => 'Altere motivo',
	'globalblocking-block-reason-dropdown' => '* Motivos commun pro blocar
** Spam trans wikis
** Abuso trans wikis
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Modificar le motivos pro blocar',
	'globalblocking-block-expiry' => 'Expiration:',
	'globalblocking-block-expiry-other' => 'Altere termino de expiration',
	'globalblocking-block-expiry-otherfield' => 'Altere duration:',
	'globalblocking-block-legend' => 'Blocar un adresse IP globalmente',
	'globalblocking-block-options' => 'Optiones:',
	'globalblocking-ipaddress' => 'Adresse IP:',
	'globalblocking-ipbanononly' => 'Blocar solmente usatores anonyme',
	'globalblocking-block-errors' => 'Tu blocada non ha succedite, pro le sequente {{PLURAL:$1|motivo|motivos}}:',
	'globalblocking-block-ipinvalid' => 'Le adresse IP ($1) que tu entrava es invalide.
Per favor nota que tu non pote entrar un nomine de usator!',
	'globalblocking-block-expiryinvalid' => 'Le expiraton que tu entrava ($1) es invalide.',
	'globalblocking-block-submit' => 'Blocar globalmente iste adresse IP',
	'globalblocking-modify-submit' => 'Modificar iste blocada global',
	'globalblocking-block-success' => 'Le adresse IP $1 ha essite blocate con successo in tote le projectos.',
	'globalblocking-modify-success' => 'Le blocada global de $1 ha essite modificate con successo',
	'globalblocking-block-successsub' => 'Blocada global succedite',
	'globalblocking-modify-successsub' => 'Blocada global modificate con successo',
	'globalblocking-block-alreadyblocked' => 'Le adresse IP $1 es ja blocate globalmente. Tu pote vider le blocada existente in le [[Special:GlobalBlockList|lista de blocadas global]],
o modificar le configurationes del blocada existente per resubmitter iste formulario.',
	'globalblocking-block-bigrange' => 'Le intervallo que tu specificava ($1) es troppo grande pro esser blocate. Tu pote blocar, al maximo, 65&nbsp;536 adresses (i.e.: intervallos /16).',
	'globalblocking-list-intro' => 'Isto es un lista de tote le blocadas global actualmente in effecto. Alcun blocadas es marcate como localmente disactivate: isto significa que illos es applicabile in altere sitos, sed un administrator local ha decidite a disactivar los in iste wiki.',
	'globalblocking-list' => 'Lista de adresses IP blocate globalmente',
	'globalblocking-search-legend' => 'Cercar un blocada global',
	'globalblocking-search-ip' => 'Adresse IP:',
	'globalblocking-search-submit' => 'Cercar blocadas',
	'globalblocking-list-ipinvalid' => 'le adresse IP que tu cercava ($1) es invalide.
Per favor entra un adresse IP valide.',
	'globalblocking-search-errors' => 'Tu recerca non ha succedite, pro le sequente {{PLURAL:$1|motivo|motivos}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') blocava globalmente [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'expiration $1',
	'globalblocking-list-anononly' => 'anon-solmente',
	'globalblocking-list-unblock' => 'remover',
	'globalblocking-list-whitelisted' => 'disactivate localmente per $1: $2',
	'globalblocking-list-whitelist' => 'stato local',
	'globalblocking-list-modify' => 'modificar',
	'globalblocking-list-noresults' => 'Le adresse IP requestate non es blocate.',
	'globalblocking-goto-block' => 'Blocar globalmente un adresse IP',
	'globalblocking-goto-unblock' => 'Remover un blocada global',
	'globalblocking-goto-status' => 'Cambiar le stato local de un blocada global',
	'globalblocking-return' => 'Retornar al lista de blocadas global',
	'globalblocking-notblocked' => 'Le adresse IP ($1) que tu entrava non es globalmente blocate.',
	'globalblocking-unblock' => 'Remover un blocada global',
	'globalblocking-unblock-ipinvalid' => 'Le adresse IP ($1) que tu entrava es invalide.
Per favor nota que tu non pote entrar un nomine de usator!',
	'globalblocking-unblock-legend' => 'Remover un blocada global',
	'globalblocking-unblock-submit' => 'Remover blocada global',
	'globalblocking-unblock-reason' => 'Motivo:',
	'globalblocking-unblock-unblocked' => "Tu ha removite con successo le blocada global #$2 del adresse IP '''$1'''",
	'globalblocking-unblock-errors' => 'Le remotion del blocada global non ha succedite, pro le sequente {{PLURAL:$1|motivo|motivos}}:',
	'globalblocking-unblock-successsub' => 'Blocada global removite con successo',
	'globalblocking-unblock-subtitle' => 'Remotion de blocada global',
	'globalblocking-unblock-intro' => 'Tu pote usar iste formulario pro remover un blocada global.',
	'globalblocking-whitelist' => 'Stato local de blocadas global',
	'globalblocking-whitelist-notapplied' => 'Le blocadas global non es applicate in iste wiki,
dunque le stato local del blocadas global non pote esser modificate.',
	'globalblocking-whitelist-legend' => 'Cambiar stato local',
	'globalblocking-whitelist-reason' => 'Motivo:',
	'globalblocking-whitelist-status' => 'Stato local:',
	'globalblocking-whitelist-statuslabel' => 'Disactivar iste blocada global in {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Cambiar stato local',
	'globalblocking-whitelist-whitelisted' => "Tu ha disactivate con successo le blocada global #$2 del adresse IP '''$1''' in {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Tu ha reactivate con successo le blocada global #$2 del adresse IP '''$1''' in {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Stato local cambiate con successo',
	'globalblocking-whitelist-nochange' => 'Tu non ha cambiate le stato local de iste blocada.
[[Special:GlobalBlockList|Retornar al lista de blocadas global]].',
	'globalblocking-whitelist-errors' => 'Le cambio del stato local de un blocada global non ha succedite, pro le sequente {{PLURAL:$1|motivo|motivos}}:',
	'globalblocking-whitelist-intro' => 'Tu pote usar iste formulario pro modificar le stato local de un blocada global. Si un blocada global es disactivate in iste wiki, le usatores que se connecte a partir del adresse IP in question potera facer modificationes normalmente. [[Special:GlobalBlockList|Clicca hic]] pro returnar al lista de blocadas global.',
	'globalblocking-blocked' => "Tu adresse IP \$5 ha essite blocate in tote le wikis per '''\$1''' (''\$2'').
Le motivo date esseva ''\"\$3\"''.
Le blocada ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Tu non pote reinitialisar le contrasignos de usatores proque tu ha essite blocate globalmente.',
	'globalblocking-logpage' => 'Registro de blocadas global',
	'globalblocking-logpagetext' => 'Isto es un registro de blocadas global que ha essite facite e removite in iste wiki.
Il debe esser notate que le blocadas global pote esser facite e removite in altere wikis, e que iste blocadas global pote afficer etiam iste wiki.
Pro vider tote le blocadas global active, tu pote vider le [[Special:GlobalBlockList|lista de blocadas global]].',
	'globalblocking-block-logentry' => 'blocava globalmente [[$1]] con un tempore de expiration de $2',
	'globalblocking-block2-logentry' => 'blocava globalmente [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'removeva blocada global de [[$1]]',
	'globalblocking-whitelist-logentry' => 'disactivava localmente le blocada global de [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'reactivava localmente le blocada global de [[$1]]',
	'globalblocking-modify-logentry' => 'modificava le blocada global de [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'expira le $1',
	'globalblocking-logentry-noexpiry' => 'data de expiration non specificate',
	'globalblocking-loglink' => 'Le adresse IP $1 es blocate globalmente ([[{{#Special:GlobalBlockList}}/$1|detalios complete]]).',
	'globalblocking-showlog' => 'Iste adresse IP ha essite blocate previemente.
Le registro de blocadas es fornite ci infra pro referentia:',
	'globalblocklist' => 'Lista de adresses IP blocate globalmente',
	'globalblock' => 'Blocar globalmente un adresse IP',
	'globalblockstatus' => 'Stato local de blocadas global',
	'removeglobalblock' => 'Remover un blocada global',
	'right-globalblock' => 'Facer blocadas global',
	'action-globalblock' => 'facer blocadas global',
	'right-globalunblock' => 'Remover blocadas global',
	'action-globalunblock' => 'remover blocadas global',
	'right-globalblock-whitelist' => 'Disactivar blocadas global localmente',
	'action-globalblock-whitelist' => 'disactivar blocadas global localmente',
	'right-globalblock-exempt' => 'Contornar blocadas global',
	'action-globalblock-exempt' => 'contornar blocadas global',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author Anakmalaysia
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Rex
 */
$messages['id'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Memblokir]] alamat IP [[Special:GlobalBlockList|di banyak wiki sekaligus]]',
	'globalblocking-block' => 'Memblokir sebuah alamat IP secara global',
	'globalblocking-modify-intro' => 'Anda dapat menggunakan formulir ini untuk mengubah pengaturan suatu pemblokiran global.',
	'globalblocking-block-intro' => 'Anda dapat menggunakan halaman ini untuk memblokir sebuah alamat IP di seluruh wiki.',
	'globalblocking-block-reason' => 'Alasan:',
	'globalblocking-block-otherreason' => 'Alasan lain/tambahan:',
	'globalblocking-block-reasonotherlist' => 'Alasan lain',
	'globalblocking-block-reason-dropdown' => '* Alasan pemblokiran umum
** Spam crosswiki
** Penyalahgunaan crosswiki
** Vandalisme',
	'globalblocking-block-edit-dropdown' => 'Sunting alasan pemblokiran',
	'globalblocking-block-expiry' => 'Kedaluwarsa:',
	'globalblocking-block-expiry-other' => 'Waktu lain',
	'globalblocking-block-expiry-otherfield' => 'Waktu lain:',
	'globalblocking-block-legend' => 'Blokir suatu alamat IP secara global',
	'globalblocking-block-options' => 'Pilihan:',
	'globalblocking-ipaddress' => 'Alamat IP:',
	'globalblocking-ipbanononly' => 'Hanya blokir pengguna anonim',
	'globalblocking-block-errors' => 'Pemblokiran tidak berhasil, atas {{PLURAL:$1|alasan|alasan-alasan}} berikut:',
	'globalblocking-block-ipinvalid' => 'Anda memasukkan alamat IP ($1) yang tidak sah.
Ingat, Anda tidak dapat memasukkan nama pengguna!',
	'globalblocking-block-expiryinvalid' => 'Waktu kedaluwarsa tidak sah ($1).',
	'globalblocking-block-submit' => 'Blokir alamat IP ini secara global',
	'globalblocking-modify-submit' => 'Ubah pengaturan pemblokiran global ini',
	'globalblocking-block-success' => 'Alamat IP $1 berhasil diblokir di seluruh proyek.',
	'globalblocking-modify-success' => 'Pemblokiran global atas $1 telah berhasil diubah',
	'globalblocking-block-successsub' => 'Pemblokiran global berhasil',
	'globalblocking-modify-successsub' => 'Pemblokiran global berhasil diubah',
	'globalblocking-block-alreadyblocked' => 'Alamat IP $1 telah diblokir secara global.
Anda dapat melihat status pemblokiran tersebut di [[Special:GlobalBlockList|daftar pemblokiran global]],
atau ubah status pemblokiran dengan mengirimkan kembali formulir ini.',
	'globalblocking-block-bigrange' => 'Rentang yang Anda masukkan ($1) terlalu besar untuk diblokir.
Anda dapat memblokir maksimum 65.536 alamat (/16 rentang)',
	'globalblocking-list-intro' => 'Ini adalah daftar seluruh pemblokiran global yang efektif pada saat ini.
Beberapa pemblokiran ditandai sebagai non-aktif pada wiki lokal: ini artinya pemblokiran ini aktif pada situs-situs lain, tapi Pengurus di wiki lokal telah memutuskan untuk menon-aktifkannya di wiki ini.',
	'globalblocking-list' => 'Daftar pemblokiran global alamat IP',
	'globalblocking-search-legend' => 'Pencarian pemblokiran global',
	'globalblocking-search-ip' => 'Alamat IP:',
	'globalblocking-search-submit' => 'Pencarian pemblokiran',
	'globalblocking-list-ipinvalid' => 'Alamat IP yang Anda cari ($1) tidak sah.
Harap masukkan alamat IP yang sah.',
	'globalblocking-search-errors' => 'Pencarian Anda tidak berhasil, untuk {{PLURAL:$1|alasan|alasan-alasan}} berikut:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') memblokir secara global [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'kedaluwarsa $1',
	'globalblocking-list-anononly' => 'hanya pengguna anonim',
	'globalblocking-list-unblock' => 'hapuskan',
	'globalblocking-list-whitelisted' => 'dinon-aktifkan di wiki lokal oleh $1: $2',
	'globalblocking-list-whitelist' => 'status lokal',
	'globalblocking-list-modify' => 'ubah',
	'globalblocking-list-noresults' => 'Alamat IP yang diminta tidak sedang diblokir.',
	'globalblocking-goto-block' => 'Memblokir alamat IP secara global',
	'globalblocking-goto-unblock' => 'Menghapuskan pemblokiran global',
	'globalblocking-goto-status' => 'Mengubah status lokal untuk sebuah pemblokiran global',
	'globalblocking-return' => 'Kembali ke daftar pemblokiran global',
	'globalblocking-notblocked' => 'Alamat IP ($1) yang Anda masukkan tidak diblokir secara global.',
	'globalblocking-unblock' => 'Membatalkan pemblokiran global',
	'globalblocking-unblock-ipinvalid' => 'Anda memasukkan alamat IP ($1) yang tidak sah.
Ingat, Anda tidak dapat memasukkan nama pengguna!',
	'globalblocking-unblock-legend' => 'Membatalkan pemblokiran global',
	'globalblocking-unblock-submit' => 'Membatalkan pemblokiran global',
	'globalblocking-unblock-reason' => 'Alasan:',
	'globalblocking-unblock-unblocked' => "Anda telah berhasil membatalkan pemblokiran global #$2 atas alamat IP '''$1'''",
	'globalblocking-unblock-errors' => 'Pembatalan pemblokiran global tidak berhasil, karena {{PLURAL:$1|alasan|alasan-alasan}} berikut:',
	'globalblocking-unblock-successsub' => 'Pemblokiran global berhasil dibatalkan',
	'globalblocking-unblock-subtitle' => 'Membatalkan pemblokiran global',
	'globalblocking-unblock-intro' => 'Anda dapat menggunakan formulir ini untuk membatalkan sebuah pemblokiran global.',
	'globalblocking-whitelist' => 'Status wiki lokal atas pemblokiran global',
	'globalblocking-whitelist-notapplied' => 'Pemblokiran global tidak digunakan pada wiki ini,
jadi status lokal dari suatu pemblokiran global tidak dapat diubah.',
	'globalblocking-whitelist-legend' => 'Mengubah status di wiki lokal',
	'globalblocking-whitelist-reason' => 'Alasan:',
	'globalblocking-whitelist-status' => 'Status lokal:',
	'globalblocking-whitelist-statuslabel' => 'Menon-aktifkan pemblokiran global ini di {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Mengubah status di wiki lokal',
	'globalblocking-whitelist-whitelisted' => "Anda telah berhasil membatalkan pemblokiran global #$2 atas alamat IP '''$1''' di {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Anda telah berhasil mengaktifkan kembali pemblokiran global #$2 atas alamat IP '''$1''' di {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Status wiki lokal berhasil diubah',
	'globalblocking-whitelist-nochange' => 'Anda tidak mengubah status lokal atas pemblokiran ini.
[[Special:GlobalBlockList|Kembali ke daftar pemblokiran global]].',
	'globalblocking-whitelist-errors' => 'Perubahan atas status lokal dari pemblokiran global tidak berhasil; atas {{PLURAL:$1|alasan|alasan-alasan}} berikut:',
	'globalblocking-whitelist-intro' => 'Anda dapat menggunakan formulir ini untuk menyunting status lokal dari suatu pemblokiran global.
Jika sebuah pemblokiran global dinon-aktifkan di wiki ini, pengguna-pengguna dengan alamat IP tersebut akan dapat kembali menyunting secara normal.
[[Special:GlobalBlockList|Kembali ke daftar pemblokiran global]].',
	'globalblocking-blocked' => "Alamat IP Anda (\$5) telah diblokir di seluruh wiki oleh '''\$1''' (''\$2'').
Alasan pemblokiran adalah ''\"\$3\"''.
Pemblokiran ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Anda tidak dapat mengganti kata sandi pengguna karena Anda sedang diblokir secara global.',
	'globalblocking-logpage' => 'Log pemblokiran global',
	'globalblocking-logpagetext' => 'Ini adalah log pemblokiran global yang dibuat dan dihapuskan di wiki ini.
Sebagai catatan, pemblokiran global dapat dibuat dan dihapuskan di wiki lain yang akan juga mempengaruhi wiki ini.
Untuk menampilkan seluruh pemblokiran global yang aktif saat ini, Anda dapat melihat [[Special:GlobalBlockList|daftar pemblokiran global]].',
	'globalblocking-block-logentry' => 'memblokir secara global [[$1]] dengan kedaluwarsa $2',
	'globalblocking-block2-logentry' => 'memblokir global [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'menghapuskan pemblokiran global atas [[$1]]',
	'globalblocking-whitelist-logentry' => 'menonaktifkan pemblokiran global atas [[$1]] di wiki lokal',
	'globalblocking-dewhitelist-logentry' => 'mengaktifkan kembali pemblokiran global pada [[$1]] di wiki lokal',
	'globalblocking-modify-logentry' => 'mengubah pemblokiran global atas [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'kedaluwarsa $1',
	'globalblocking-logentry-noexpiry' => 'selamanya',
	'globalblocking-loglink' => 'Alamat IP $1 diblokir secara global ([[{{#Special:GlobalBlockList}}/$1|detail lengkap]]).',
	'globalblocking-showlog' => 'Alamat IP ini telah diblokir sebelumnya.
Log pemblokiran disediakan di bawah ini sebagai rujukan:',
	'globalblocklist' => 'Daftar alamat IP yang diblokir secara global',
	'globalblock' => 'Memblokir suatu alamat IP secara global',
	'globalblockstatus' => 'Status pemblokiran global di wiki lokal',
	'removeglobalblock' => 'Menghapuskan pemblokiran global',
	'right-globalblock' => 'Melakukan pemblokiran global',
	'right-globalunblock' => 'Menghapuskan pemblokiran global',
	'right-globalblock-whitelist' => 'Menonaktifkan suatu pemblokiran global di wiki lokal',
	'right-globalblock-exempt' => 'Tidak dikenakan pemblokiran global',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'globalblocking-block-reason' => 'Mgbághapụtà:',
	'globalblocking-block-expiry' => 'Gbá okà:',
	'globalblocking-block-options' => 'I cho, ka I chogị:',
	'globalblocking-list-unblock' => 'wéfù',
	'globalblocking-unblock-reason' => 'Mgbághapụtà:',
	'globalblocking-whitelist-reason' => 'Mgbághapụtà:',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Agpalubos]] kadagiti IP a pagtaengan a [[Special:GlobalBlockList|maserraan kadagiti amin a wiki]]',
	'globalblocking-block' => 'Sangalubongan na a seraan ti IP a pagtaengan',
	'globalblocking-modify-intro' => 'Mausar mo daytoy a kinabuklan ti pinagsukat dagiti kasasaad iti sangalubongan a serra.',
	'globalblocking-block-intro' => 'Mausar mo daytoy a panid ti pinagserra ti IP a pagtaengan kadagiti amin a wiki.',
	'globalblocking-block-reason' => 'Rason:',
	'globalblocking-block-otherreason' => 'Sabali/dadduma pay a rason:',
	'globalblocking-block-reasonotherlist' => 'Sabali a rason',
	'globalblocking-block-reason-dropdown' => '* Kadawyan a rasrason ti panagserra
** Panagspam kadagiti amin a wiki
** Panag-abuso kadagiti amin a wiki
** Bandalismo',
	'globalblocking-block-edit-dropdown' => 'Urnosen dagiti rason ti panagserra',
	'globalblocking-block-expiry' => 'Agpaso:',
	'globalblocking-block-expiry-other' => 'Sabali pay a pinagpaso nga oras',
	'globalblocking-block-expiry-otherfield' => 'Sabali nga oras:',
	'globalblocking-block-legend' => 'Serraan ti IP a pagtaengan iti sangalubongan',
	'globalblocking-block-options' => 'Dagiti pinagpilian:',
	'globalblocking-ipaddress' => 'IP a pagtaengan:',
	'globalblocking-ipbanononly' => 'Serraan dagiti di am-ammo nga agar-aramat laeng',
	'globalblocking-block-errors' => 'Napaay ti pinagserram, kadagiti sumaganad {{PLURAL:$1|rason|dagiti rason}}:',
	'globalblocking-block-ipinvalid' => 'Ti IP a pagtaengan ($1) nga inkabil mo ket imbalido.
Pangngaasi a lagipem a saan ka a makaikabil ti nagan ti agar-aramat!',
	'globalblocking-block-expiryinvalid' => 'Ti pinagpaso nga inkabil mo ($1) ket imbalido.',
	'globalblocking-block-submit' => 'Serraan daytoy nga IP a pagtaengan iti sangalubongan',
	'globalblocking-modify-submit' => 'Baliwam daytoy sangalubongan a serra',
	'globalblocking-block-success' => 'Ti IP a pagtaengan $1 ket nagballigi a naseraan kadagiti amin a gandat.',
	'globalblocking-modify-success' => 'Ti sangalubongan a serra idiay $1 ket naballigi a nabaliwan',
	'globalblocking-block-successsub' => 'Balligi ti sangalubongan a serra',
	'globalblocking-modify-successsub' => 'Balligi ti pinagbaliw ti sangalubongan a serra',
	'globalblocking-block-alreadyblocked' => 'Ti IP a pagtaengan $1 ket naserraan metten iti sangalubongan.
Makitam ti addaan a serra idiay [[Special:GlobalBlockList|listaan dagiti sangalubongan a serra]],
wenno baliwam ti kasasaad ti addaan a serra babaeten ti pinagited iti daytoy a kinabuklan.',
	'globalblocking-block-bigrange' => 'Ti nasakup a nainaganan a ($1) ket dakkel unay a maserraan.
Maserraam, ti kaaduuan a, 65, 536 a pagtaengan (/16 nasaksakup)',
	'globalblocking-list-intro' => 'Daytoy ket listaan kadagiti amin a sangalubongan a serra nga agdama a banag.
Adda dagiti serra a namarkaan a kas lokal a nabaldado: kayat na a sawen daytoy a naikabil da kadagit sabali a pagsaadan, ngem ti lokal nga administrador ket ipato na a nabaldado iti daytoy a wiki.',
	'globalblocking-list' => 'Listaan dagiti naserraan nga IP a pagtaengan iti sangalubongan',
	'globalblocking-search-legend' => 'Agbiruk iti sangalubongan a serra',
	'globalblocking-search-ip' => 'IP a pagtaengan:',
	'globalblocking-search-submit' => 'Agbiruk kadagiti serra',
	'globalblocking-list-ipinvalid' => 'Ti IP a pagtaengan a biniruk mo iti ($1) ket imbalido.
Pangngaasi ta agikabil iti umisu nga IP a pagtaengan.',
	'globalblocking-search-errors' => 'Napaay ti pinagbiruk mo, kadagiti sumaganad {{PLURAL:$1|rason|dagiti rason}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') sangalubongan a naserraan [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'agpaso $1',
	'globalblocking-list-anononly' => 'di amammo laeng',
	'globalblocking-list-unblock' => 'ikkaten',
	'globalblocking-list-whitelisted' => 'lokal a nabaldado babaen ti $1 : $2',
	'globalblocking-list-whitelist' => 'lokal a kasasaad',
	'globalblocking-list-modify' => 'baliwan',
	'globalblocking-list-noresults' => 'Ti kiniddaw nga IP a pagtaengan ket saan a naserraan',
	'globalblocking-goto-block' => 'Sangalubongan a seraan ti IP a pagtaengan',
	'globalblocking-goto-unblock' => 'Ikkaten ti maysa a sangalubongan a serra',
	'globalblocking-goto-status' => 'Sukatan ti lokal a kasasaad ti maysa a sangalubongan a serra',
	'globalblocking-return' => 'Agsubli idiay listaan kadagiti sangalubongan a serra',
	'globalblocking-notblocked' => 'Ti IP a pagtaengan ($1) nga inkabil mo ket saan saan a naserraan iti sangalubongan.',
	'globalblocking-unblock' => 'Ikkaten ti maysa a sangalubongan a serra',
	'globalblocking-unblock-ipinvalid' => 'Ti IP a pagtaengan ($1) nga inkabil mo ket imbalido.
Pangngaasi a lagipem a saan ka a makaikabil ti nagan ti agar-aramat!',
	'globalblocking-unblock-legend' => 'Ikkaten ti maysa a sangalubongan a serra',
	'globalblocking-unblock-submit' => 'Ikkaten ti sangalubongan a serra',
	'globalblocking-unblock-reason' => 'Rason:',
	'globalblocking-unblock-unblocked' => "Nagballigi ka ti pinag-ikkat ti sangalubongan a serra #$2 idiay IP a pagtaengan '''$1'''",
	'globalblocking-unblock-errors' => 'Napaay ti pinagikkat mo ti sangalubongan a serra, kadagiti sumaganad {{PLURAL:$1|rason|dagiti rason}}:',
	'globalblocking-unblock-successsub' => 'Balligi ti pinagikkat ti sangalubongan a serra',
	'globalblocking-unblock-subtitle' => 'Ikikkaten ti sangalubongan a serra',
	'globalblocking-unblock-intro' => 'Mausar mo daytoy a kinabuklan ti pinagikkat ti sangalubongan a serra.',
	'globalblocking-whitelist' => 'Local a kasasaad iti sangalubongan a serra',
	'globalblocking-whitelist-notapplied' => 'TI sangalubongan a serra ket saan a naikabil ditoy a wiki,
ket ti lokal a kasaad iti sangalubongan a serra ket saan a mabaliwan.',
	'globalblocking-whitelist-legend' => 'Sukatan ti lokal a kasasaad',
	'globalblocking-whitelist-reason' => 'Rason:',
	'globalblocking-whitelist-status' => 'Lokal a kasasaad:',
	'globalblocking-whitelist-statuslabel' => 'Ibaldado daytoy a sangalubongan a serra idiay {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Sukatan ti lokal a kasasaad',
	'globalblocking-whitelist-whitelisted' => "Balligi ti pinagbaldadom ti sangalubongan a serra #$2 idiay IP a pagtaengan '''$1''' idiay {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Balligi ti pinagsublim ti sangalubongan a serra #$2 idiay IP a pagtaengan '''$1''' idiay {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Balligi ti pinagsukat ti lokal a kasasaad',
	'globalblocking-whitelist-nochange' => 'Awan ti sinukatan iti lokal a kasasaad iti daytoy a serra.
[[Special:GlobalBlockList|Agsubli idiay listaan ti sangalubongan a serra]].',
	'globalblocking-whitelist-errors' => 'Napaay ti pinagikkat mo ti lokal a kasasaad ti sangalubongan a serra, kadagiti sumaganad {{PLURAL:$1|rason|dagiti rason}}:',
	'globalblocking-whitelist-intro' => 'Mausar mo daytoy a kinabuklan ti pinagurnos ti lokal a kasasaad iti sangalubongan a serra.
No nabaldado ti sangalubongan a serra iti daytoy a wiki, dagiti agar-aramat iti naarigan nga IP a pagtaengan ket mabalin da ti kadawyan nga agurnos.
[[Special:GlobalBlockList|Agsubli idiay listaan ti sangalubongan a serra]].',
	'globalblocking-blocked' => "Ti IP a pagtaengam \$5 ket naserraan kadagiti amin a wiki ni '''\$1''' (''\$2'') .
Ti rason nga inted ket ''\"\$3\"''.
Ti serra ''\$4'' .",
	'globalblocking-blocked-nopassreset' => 'Saan mo a maipasubli ti kontrasenias ti agar-aramat ngamin ket naserraan iti sangalubongan.',
	'globalblocking-logpage' => 'Listaan ti sangalubongan a serra',
	'globalblocking-logpagetext' => 'Daytoy ket listaan dagiti sangalubongan a serra a naaramid ken naikkat ditoy a wiki.
Laglagipen a ti sangalubongan a serra ket maaramid ken maikkat kadagiti sabali a wiki, ken dagitoy a sangalubongan a serra ket tignayen na daytoy a wiki.
Ti agkita kadagiti amin nga agdama a serra, kitaen ti [[Special:GlobalBlockList|listaan ti sangalubongan a serra]].',
	'globalblocking-block-logentry' => 'sangalubonga a naserraan [[$1]] nga addaan ti oras ti pinagpaso a $2',
	'globalblocking-block2-logentry' => 'sangalubongan a naserraan [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'ikkaten ti sangalubongan a serra idiay [[$1]]',
	'globalblocking-whitelist-logentry' => 'ibaldado ti sangalubongan a serra idiay [[$1]] lokal laeng',
	'globalblocking-dewhitelist-logentry' => 'ipasubli ti sangalubongan a serra idiay [[$1]] lokal laeng',
	'globalblocking-modify-logentry' => 'binaliwan ti sangalubongan a serra idiay [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'agpaso $1',
	'globalblocking-logentry-noexpiry' => 'awan ti agpaso nga agasmang',
	'globalblocking-loglink' => 'Ti IP a pagtaengan $1 ket naserraan iti sangalubongan ([[{{#Special:GlobalBlockList}}/$1|dagiti amin a detalye]]).',
	'globalblocking-showlog' => 'Daytoy nga IP a pagtaengan ket naserraan idin.
Ti listaan ti serra ket naikabil dita baba tapno mausar a reperensia:',
	'globalblocklist' => 'Listaan dagiti naserraan nga IP a pagtaengan iti sangalubongan',
	'globalblock' => 'Sangalubongan a seraan ti IP a pagtaengan',
	'globalblockstatus' => 'Lokal a kasasaad iti sangalubongan a serra',
	'removeglobalblock' => 'Ikkaten ti maysa a sangalubongan a serra',
	'right-globalblock' => 'Agaramid kadagiti sangalubongan a serra',
	'right-globalunblock' => 'Ikikkaten dagiti sangalubongan a serra',
	'right-globalblock-whitelist' => 'Ibaldado a lokal dagiti sangalubongan a serra',
	'right-globalblock-exempt' => 'Palabsan dagiti sangalubongan a serra',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'globalblocking-block-expiry-otherfield' => 'Altra tempo:',
	'globalblocking-block-options' => 'Selekti:',
	'globalblocking-search-ip' => 'IP-adreso:',
	'globalblocking-list-anononly' => 'nur anonima',
	'globalblocking-list-unblock' => 'forigar',
	'globalblocking-unblock-reason' => 'Motivo:',
	'globalblocking-whitelist-reason' => 'Motivo:',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Snævar
 */
$messages['is'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Leyfir]] bönnun á vistföngum [[Special:GlobalBlockList|yfir mörg wiki verkefni]]',
	'globalblocking-block' => 'Banna vistfang altækt',
	'globalblocking-modify-intro' => 'Þú getur notað þetta eyðublað til að breyta stillingum altæks banns.',
	'globalblocking-block-intro' => 'Þú getur notað þessa síðu til að banna vistföng á öllum wiki verkefnum.',
	'globalblocking-block-reason' => 'Ástæða:',
	'globalblocking-block-otherreason' => 'Önnur ástæða:',
	'globalblocking-block-reasonotherlist' => 'Önnur ástæða',
	'globalblocking-block-reason-dropdown' => '*Algengar ástæður fyrir bönnun
*Altækar amasendingar
*Altæk misnotkun
*Skemmdarverk',
	'globalblocking-block-edit-dropdown' => 'Breyta ástæðu fyrir banni',
	'globalblocking-block-expiry' => 'Rennur út:',
	'globalblocking-block-expiry-other' => 'Önnur gildislok',
	'globalblocking-block-expiry-otherfield' => 'Annar tími:',
	'globalblocking-block-legend' => 'Banna vistfang altækt',
	'globalblocking-block-options' => 'Möguleikar:',
	'globalblocking-ipaddress' => 'Vistfang:',
	'globalblocking-ipbanononly' => 'Banna einungis ónafngreinda notendur',
	'globalblocking-block-errors' => 'Bannið þitt mistókst, vegna eftirfarandi {{PLURAL:$1|ástæðu|ástæðna}}:',
	'globalblocking-block-ipinvalid' => 'Vistfangið ($1) sem þú tilgreindir er ógilt.
Athugaðu að þú getur ekki tilgreint notendanafn!',
	'globalblocking-block-expiryinvalid' => 'Gildislokin sem þú tilgreindir ($1) eru ógild.',
	'globalblocking-block-submit' => 'Banna þetta vistfang altækt',
	'globalblocking-modify-submit' => 'Breyta þessu altæku banni',
	'globalblocking-block-success' => 'Tókst að banna vistfangið $1 öllum verkefnum.',
	'globalblocking-modify-success' => 'Tókst að breyta altæka banninu $1',
	'globalblocking-block-successsub' => 'Altækt bann tókst',
	'globalblocking-modify-successsub' => 'Tókst að breyta altæku banni',
	'globalblocking-block-alreadyblocked' => 'Vistfangið $1 er þegar bannað altækt.
Þú getur skoðað það bann sem fyrir er á [[Special:GlobalBlockList|lista yfir altæk bönn]],
eða breytt stillingum bannsins með því að endursenda þetta eyðublað.',
	'globalblocking-block-bigrange' => 'Fjöldabannið sem þú tilgreindir ($1) er of stórt til að banna.
Þú mátt banna, í mestalagi, 65.536 vistföng (/16 raðir)',
	'globalblocking-list-intro' => 'Hér er listi yfir öll altæk bönn sem eru enn virk
Þau bönn sem eru merkt sem óvirk svæðisbundið eiga við aðrar wiki síður en möppudýr á þessari síðu hefur ákveðið að afvirkja bannið á þessum wiki.',
	'globalblocking-list' => 'Altæk bönn vistfanga',
	'globalblocking-search-legend' => 'Leita að altæku banni',
	'globalblocking-search-ip' => 'Vistfang:',
	'globalblocking-search-submit' => 'Leita að bönnum',
	'globalblocking-list-ipinvalid' => 'Vistfangið sem þú leitaðir að ($1) er ógilt.
Vinsamlegast sláðu inn gilt vistfang.',
	'globalblocking-search-errors' => 'Leitin þín mistókst, vegna eftirfarandi {{PLURAL:$1|ástæðu|ástæðna}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bannaði altækt [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'rennur út $1',
	'globalblocking-list-anononly' => 'nafnlausir eingöngu',
	'globalblocking-list-unblock' => 'fjarlægja',
	'globalblocking-list-whitelisted' => 'Óvirkt svæðisbundið af $1: $2',
	'globalblocking-list-whitelist' => 'Svæðisbundin staða',
	'globalblocking-list-modify' => 'breyta',
	'globalblocking-list-noresults' => 'Umbeðið vistfang er ekki í bannað.',
	'globalblocking-goto-block' => 'Banna vistfang altækt',
	'globalblocking-goto-unblock' => 'Fjarlægja altækt bann',
	'globalblocking-goto-status' => 'Breyta staðbundri stöðu altæks banns',
	'globalblocking-return' => 'Fara aftur á lista yfir altæk bönn',
	'globalblocking-notblocked' => 'Vistfangið ($1) sem þú tilgreindir er ekki bannað altækt.',
	'globalblocking-unblock' => 'Fjarlægja altækt bann',
	'globalblocking-unblock-ipinvalid' => 'Vistfangið ($1) sem þú tilgreindir er ógilt.
Athugaðu að þú getur ekki tilgreint notendanafn!',
	'globalblocking-unblock-legend' => 'Fjarlægja altækt bann',
	'globalblocking-unblock-submit' => 'Fjarlægja altækt bann',
	'globalblocking-unblock-reason' => 'Ástæða:',
	'globalblocking-unblock-unblocked' => "Þér hefur tekist að fjarlægja altæka bannið #$2 á vistfanginu '''$1'''",
	'globalblocking-unblock-errors' => 'Fjarlægingin þín mistókst, vegna eftirfarandi {{PLURAL:$1|ástæðu|ástæðna}}:',
	'globalblocking-unblock-successsub' => 'Tókst að fjarlægja altækt bann',
	'globalblocking-unblock-subtitle' => 'Fjarlægji altækt bann',
	'globalblocking-unblock-intro' => 'Þú getur notað þetta eyðublað til að fjarlægja altækt bann.',
	'globalblocking-whitelist' => 'Svæðisbundin staða altækra banna',
	'globalblocking-whitelist-notapplied' => 'Altæk bönn eru óstudd á þessum wiki,
svo ekki er hægt að breyta staðbundinni stöðu altækra banna.',
	'globalblocking-whitelist-legend' => 'Breyta svæðisbundnri stöðu',
	'globalblocking-whitelist-reason' => 'Ástæða:',
	'globalblocking-whitelist-status' => 'Svæðisbundin staða:',
	'globalblocking-whitelist-statuslabel' => 'Óvirkja þetta alvirka bann á {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Breyta svæðisbundnri stöðu',
	'globalblocking-whitelist-whitelisted' => "Þér hefur tekist að óvirkja altæka bannið #$2 á vistfanginu '''$1''' á {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Þér hefur tekist að endurvirkja altæka bannið #$2 á vistfanginu '''$1''' á {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Tókst að breyta staðbundinni stöðu banns.',
	'globalblocking-whitelist-nochange' => 'Þú gerðir engar breytingar á staðbundinni stöðu bannsins.
[[Special:GlobalBlockList|Fara á lista yfir altæk bönn]].',
	'globalblocking-whitelist-errors' => 'Breyting þín á staðbundinni stöðu altæks banns mistókst, vegna eftirfarandi {{PLURAL:$1|ástæðu|ástæðna}}:',
	'globalblocking-whitelist-intro' => 'Þú getur notað þetta eyðublað til að breyta staðbundinni stöðu altæks banns.
Ef altækt bann er óvirkjað á þessum wiki, geta notendur á þeim vistföngum sem bannið beinist að breytt eins og venjulega.
[[Special:GlobalBlockList|Fara á lista yfir altæk bönn]].',
	'globalblocking-blocked' => "Vistfang þitt \$5 hefur verið bannað á öllum wiki verkefnum af '''\$1''' (''\$2'').
Ástæða bannsins var: ''\"\$3\"''
Bannið ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Þú getur ekki endurstillt lykilorð notenda því þú ert bannaður altækt.',
	'globalblocking-logpage' => 'Altæk eyðingarskrá',
	'globalblocking-logpagetext' => 'Þetta er skrá yfir altækar bannanir og afbannanir á notendum.
Altæk bönn ná yfir wiki á öllum tungumálum. Þannig gildir altækt bann sem var sett á öðrum wiki einnig hér.
Tæmandi lista yfir öll virk altæk bönn er að finna á [[Special:GlobalBlockList|Listi yfir altæk bönn]].',
	'globalblocking-block-logentry' => 'bannaði altækt „[[$1]]“; rennur út eftir: $2',
	'globalblocking-block2-logentry' => 'bannaði altækt [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'fjarlægði altækt bann sem beindist að [[$1]]',
	'globalblocking-whitelist-logentry' => 'óvirkjaði altæka bannið á [[$1]] svæðisbundið',
	'globalblocking-dewhitelist-logentry' => 'endurvirkjaði altæka bannið á [[$1]] svæðisbundið',
	'globalblocking-modify-logentry' => 'breytti altæku banni á [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'rennur út $1',
	'globalblocking-logentry-noexpiry' => 'Engin gildislok tilgreind',
	'globalblocking-loglink' => 'Vistfangið $1 er bannað altækt ([[{{#Special:GlobalBlockList}}/$1|frekari upplýsingar]])',
	'globalblocking-showlog' => 'Vistfangið hefur verið bannað áður.
Síðasta færsla vistfangsins úr bönnunarskrá er sýnd hér fyrir neðan til skýringar:',
	'globalblocklist' => 'Listi yfir altæk bönn vistfanga',
	'globalblock' => 'Banna vistfang altækt',
	'globalblockstatus' => 'Svæðisbundin staða altækra banna',
	'removeglobalblock' => 'Fjarlægja altækt bann',
	'right-globalblock' => 'Búa til altækt bann',
	'right-globalunblock' => 'Fjarlægja altæk bönn',
	'right-globalblock-whitelist' => 'Óvirkja altæk bönn staðbundið',
	'right-globalblock-exempt' => 'Hunsa altæk bönn',
);

/** Italian (Italiano)
 * @author Beta16
 * @author BrokenArrow
 * @author Civvì
 * @author Darth Kule
 * @author Gianfranco
 * @author Melos
 */
$messages['it'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permette]] di [[Special:GlobalBlockList|bloccare su più wiki]] indirizzi IP',
	'globalblocking-block' => 'Blocca globalmente un indirizzo IP',
	'globalblocking-modify-intro' => 'Questo modulo può essere utilizzato per modificare le impostazioni di un blocco globale.',
	'globalblocking-block-intro' => 'È possibile usare questa pagina per bloccare un indirizzo IP su tutte le wiki.',
	'globalblocking-block-reason' => 'Motivo:',
	'globalblocking-block-otherreason' => 'Altri motivi/dettagli:',
	'globalblocking-block-reasonotherlist' => 'Altra motivazione',
	'globalblocking-block-reason-dropdown' => '* Motivi di blocco comune 
** Spam crosswiki  
** Abuso crosswiki 
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Modifica i motivi per il blocco',
	'globalblocking-block-expiry' => 'Scadenza:',
	'globalblocking-block-expiry-other' => 'Altri tempi di scadenza',
	'globalblocking-block-expiry-otherfield' => 'Durata non in elenco:',
	'globalblocking-block-legend' => 'Blocca globalmente un indirizzo IP',
	'globalblocking-block-options' => 'Opzioni:',
	'globalblocking-ipaddress' => 'Indirizzo IP:',
	'globalblocking-ipbanononly' => 'Blocca solo utenti anonimi',
	'globalblocking-block-errors' => 'Il blocco non è stato eseguito per {{PLURAL:$1|il seguente motivo|i seguenti motivi}}:',
	'globalblocking-block-ipinvalid' => "L'indirizzo IP ($1) che hai inserito non è valido. Fai attenzione al fatto che non puoi inserire un nome utente!",
	'globalblocking-block-expiryinvalid' => 'La scadenza che hai inserito ($1) non è valida.',
	'globalblocking-block-submit' => 'Blocca questo indirizzo IP globalmente',
	'globalblocking-modify-submit' => 'Modifica questo blocco globale',
	'globalblocking-block-success' => "L'indirizzo IP $1 è stato bloccato con successo su tutti i progetti.",
	'globalblocking-modify-success' => 'Il blocco globale di $1 è stato modificato',
	'globalblocking-block-successsub' => 'Blocco globale eseguito con successo',
	'globalblocking-modify-successsub' => 'Modifica del blocco globale riuscita',
	'globalblocking-block-alreadyblocked' => "L'indirizzo IP $1 è già bloccato globalmente. È possibile consultare il blocco attivo nell'[[Special:GlobalBlockList|elenco dei blocchi globali]] o modificare le impostazioni del blocco esistente ricompilando questo modulo.",
	'globalblocking-block-bigrange' => 'La classe che hai indicato ($1) è troppo ampia per essere bloccata. È possibile bloccare, al massimo, 65.536 indirizzi (classe /16)',
	'globalblocking-list-intro' => 'Di seguito sono elencati tutti i blocchi globali che sono attualmente attivi. Alcuni blocchi sono segnati come disattivati localmente: ciò significa che questi sono attivi su altri siti, ma un amministratore locale ha deciso di disattivarli su quella wiki.',
	'globalblocking-list' => 'Elenco degli indirizzi IP bloccati globalmente',
	'globalblocking-search-legend' => 'Ricerca un blocco globale',
	'globalblocking-search-ip' => 'Indirizzo IP:',
	'globalblocking-search-submit' => 'Ricerca blocchi',
	'globalblocking-list-ipinvalid' => "L'indirizzo IP che hai cercato ($1) non è valido. Inserisci un indirizzo IP valido.",
	'globalblocking-search-errors' => 'La tua ricerca non ha prodotto risultati per {{PLURAL:$1|il seguente motivo|i seguenti motivi}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') ha bloccato globalmente [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'scadenza del blocco $1',
	'globalblocking-list-anononly' => 'solo anonimi',
	'globalblocking-list-unblock' => 'rimuovi',
	'globalblocking-list-whitelisted' => 'disattivato localmente da $1: $2',
	'globalblocking-list-whitelist' => 'stato locale',
	'globalblocking-list-modify' => 'modifica',
	'globalblocking-list-noresults' => "L'indirizzo IP richiesto non è bloccato.",
	'globalblocking-goto-block' => 'Blocca globalmente un indirizzo IP',
	'globalblocking-goto-unblock' => 'Rimuovi un blocco globale',
	'globalblocking-goto-status' => 'Cambia stato locale di un blocco globale',
	'globalblocking-return' => "Torna all'elenco dei blocchi globali",
	'globalblocking-notblocked' => "L'indirizzo IP ($1) che hai inserito non è bloccato globalmente.",
	'globalblocking-unblock' => 'Rimuovi un blocco globale',
	'globalblocking-unblock-ipinvalid' => "L'indirizzo IP ($1) che hai inserito non è valido. Fai attenzione al fatto che non puoi inserire un nome utente!",
	'globalblocking-unblock-legend' => 'Rimuovi un blocco globale',
	'globalblocking-unblock-submit' => 'Rimuovi blocco globale',
	'globalblocking-unblock-reason' => 'Motivo:',
	'globalblocking-unblock-unblocked' => "È stato rimosso con successo il blocco globale #$2 sull'indirizzo IP '''$1'''",
	'globalblocking-unblock-errors' => 'La rimozione del blocco globale che hai richiesto non è stata eseguita per {{PLURAL:$1|il seguente motivo|i seguenti motivi}}:',
	'globalblocking-unblock-successsub' => 'Blocco globale rimosso con successo',
	'globalblocking-unblock-subtitle' => 'Rimozione blocco globale',
	'globalblocking-unblock-intro' => 'È possibile usare questo modulo per rimuovere un blocco globale.',
	'globalblocking-whitelist' => 'Stato locale dei blocchi globali',
	'globalblocking-whitelist-notapplied' => 'I blocchi globali non sono attivi su questo sito wiki.
Non è possibile modificare lo stato locale dei blocchi globali.',
	'globalblocking-whitelist-legend' => 'Cambia stato locale',
	'globalblocking-whitelist-reason' => 'Motivo:',
	'globalblocking-whitelist-status' => 'Stato locale:',
	'globalblocking-whitelist-statuslabel' => 'Disattiva il blocco globale su {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Cambia stato locale',
	'globalblocking-whitelist-whitelisted' => "Hai disattivato con successo il blocco globale #$2 sull'indirizzo IP '''$1''' su {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Hai riabilitato con successo il blocco globale #$2 sull'indirizzo IP '''$1''' su {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Stato locale cambiato con successo',
	'globalblocking-whitelist-nochange' => "Non hai effettuato cambiamenti allo stato locale di questo blocco. [[Special:GlobalBlockList|Torna all'elenco dei blocchi globali]].",
	'globalblocking-whitelist-errors' => 'Il tuo cambiamento allo stato locale di un blocco globale non è stato effettuato per {{PLURAL:$1|il seguente motivo|i seguenti motivi}}:',
	'globalblocking-whitelist-intro' => "È possibile usare questo modulo per modificare lo stato locale di un blocco globale. Se un blocco globale è disattivato su questa wiki, gli utenti che utilizzano l'indirizzo IP colpito saranno in grado di editare normalmente.
[[Special:GlobalBlockList|Fai clic qui]] per tornare all'elenco dei blocchi globali.",
	'globalblocking-blocked' => "Il tuo indirizzo IP \$5 è stato bloccato su tutte le wiki da '''\$1''' (''\$2'').
Il motivo fornito è ''\"\$3\"''. Il blocco ''\$4''.",
	'globalblocking-blocked-nopassreset' => "Non è possibile reimpostare la password dell'utente perché sei bloccato a livello globale.",
	'globalblocking-logpage' => 'Log dei blocchi globali',
	'globalblocking-logpagetext' => "Di seguito sono elencati i blocchi globali che sono stati effettuati e rimossi su questa wiki. I blocchi globali possono essere effettuati su altre wiki e questi blocchi globali possono essere validi anche su questa wiki.
Per visualizzare tutti i blocchi globali attivi si veda l'[[Special:GlobalBlockList|elenco dei blocchi globali]].",
	'globalblocking-block-logentry' => 'ha bloccato globalmente [[$1]] con una scadenza di $2',
	'globalblocking-block2-logentry' => 'ha bloccato globalmente [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'ha rimosso il blocco globale su [[$1]]',
	'globalblocking-whitelist-logentry' => 'ha disattivato il blocco globale su [[$1]] localmente',
	'globalblocking-dewhitelist-logentry' => 'ha riabilitato il blocco globale su [[$1]] localmente',
	'globalblocking-modify-logentry' => 'ha modificato il blocco globale di [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'scade il $1',
	'globalblocking-logentry-noexpiry' => 'nessuna scadenza impostata',
	'globalblocking-loglink' => "L'indirizzo IP $1 è bloccato a livello globale ([[{{#Special:GlobalBlockList}}/$1|vedi dettagli]]).",
	'globalblocking-showlog' => 'Questo indirizzo IP è stato bloccato in precedenza.
Il registro dei blocchi è riportato di seguito per informazione:',
	'globalblocklist' => 'Elenco degli indirizzi IP bloccati globalmente',
	'globalblock' => 'Blocca globalmente un indirizzo IP',
	'globalblockstatus' => 'Stato locale di blocchi globali',
	'removeglobalblock' => 'Rimuovi un blocco globale',
	'right-globalblock' => 'Effettua blocchi globali',
	'right-globalunblock' => 'Rimuove blocchi globali',
	'right-globalblock-whitelist' => 'Disattiva blocchi globali localmente',
	'right-globalblock-exempt' => 'Bypassa i blocchi globali',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Muttley
 * @author Schu
 * @author 青子守歌
 */
$messages['ja'] = array(
	'globalblocking-desc' => 'IP アドレスを[[Special:GlobalBlockList|複数のウィキで横断的に]][[Special:GlobalBlock|ブロックします。]]',
	'globalblocking-block' => 'IPアドレスをグローバルブロック',
	'globalblocking-modify-intro' => 'このフォームを使って、グローバルブロックの設定を変更できます。',
	'globalblocking-block-intro' => 'このページで全ウィキでの IP アドレスをブロックできます。',
	'globalblocking-block-reason' => '理由：',
	'globalblocking-block-otherreason' => '他の、または追加の理由:',
	'globalblocking-block-reasonotherlist' => 'その他の理由',
	'globalblocking-block-reason-dropdown' => '*共通ブロックの理由
**ウィキ間のスパム
**ウィキ間での不正利用
**荒らし',
	'globalblocking-block-edit-dropdown' => 'ブロック理由を編集',
	'globalblocking-block-expiry' => '有効期限：',
	'globalblocking-block-expiry-other' => 'その他の有効期限',
	'globalblocking-block-expiry-otherfield' => '期間 (その他のとき)',
	'globalblocking-block-legend' => 'IP アドレスをグローバルブロック',
	'globalblocking-block-options' => 'オプション:',
	'globalblocking-ipaddress' => 'IP アドレス:',
	'globalblocking-ipbanononly' => '匿名利用者のみブロック',
	'globalblocking-block-errors' => '実施しようとしたブロックは以下の{{PLURAL:$1|理由}}のために実行できませんでした:',
	'globalblocking-block-ipinvalid' => 'あなたが入力したIPアドレス ($1) には誤りがあります。アカウント名では入力できない点に注意してください！',
	'globalblocking-block-expiryinvalid' => '入力した期限 ($1) に誤りがあります。',
	'globalblocking-block-submit' => 'このIPアドレスをグローバルブロック',
	'globalblocking-modify-submit' => 'このグローバルブロックを修正',
	'globalblocking-block-success' => 'IPアドレス $1 の全プロジェクトでのブロックに成功しました。',
	'globalblocking-modify-success' => '$1 のグローバルブロックの修正に成功しました。',
	'globalblocking-block-successsub' => 'グローバルブロックに成功',
	'globalblocking-modify-successsub' => 'グローバルブロックの修正に成功',
	'globalblocking-block-alreadyblocked' => 'IPアドレス $1 はすでにグローバルブロックされています。現在のブロックの状態については[[Special:GlobalBlockList|グローバルブロック一覧]]で確認できます。また、このフォームから再投稿することにより、ブロック設定を修正することができます。',
	'globalblocking-block-bigrange' => '指定したレンジ ($1) が広すぎるためブロックできません。ブロックできるアドレスの最大数は 65,536 (/16 レンジ) です。',
	'globalblocking-list-intro' => 'これは現在有効なグローバルブロックの全一覧です。
いくつかは「ローカルで無効」とマークされています。このマークのあるグローバルブロックは他のサイトでは有効ですが、このウィキではローカル管理者が無効とすることにしたことを意味します。',
	'globalblocking-list' => 'グローバルブロックを受けているIPアドレス一覧',
	'globalblocking-search-legend' => 'グローバルブロックの検索',
	'globalblocking-search-ip' => 'IPアドレス:',
	'globalblocking-search-submit' => 'ブロックを検索',
	'globalblocking-list-ipinvalid' => 'あなたが検索したIPアドレス ($1) には誤りがあります。
再度有効なIPアドレスを入力してください。',
	'globalblocking-search-errors' => '以下の{{PLURAL:$1|理由}}により検索に失敗しました:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') が [[Special:Contributions/\$4|\$4]] を全プロジェクトでブロック ''(\$5)''",
	'globalblocking-list-expiry' => '満了 $1',
	'globalblocking-list-anononly' => '匿名利用者のみ',
	'globalblocking-list-unblock' => '解除',
	'globalblocking-list-whitelisted' => '$1 によりローカルで無効化: $2',
	'globalblocking-list-whitelist' => 'ローカル状態',
	'globalblocking-list-modify' => '改変',
	'globalblocking-list-noresults' => '指定された IP アドレスはブロックされていません。',
	'globalblocking-goto-block' => 'IPアドレスをグローバルブロック',
	'globalblocking-goto-unblock' => 'グローバルブロックを解除',
	'globalblocking-goto-status' => 'グローバルブロックのローカル状態を変更',
	'globalblocking-return' => 'グローバルブロック一覧へ戻る',
	'globalblocking-notblocked' => '入力したIPアドレス ($1) はグローバルブロックを受けていません。',
	'globalblocking-unblock' => 'グローバルブロックを解除',
	'globalblocking-unblock-ipinvalid' => 'あなたが入力したIPアドレス ($1) には誤りがあります。アカウント名では入力できない点に注意してください！',
	'globalblocking-unblock-legend' => 'グローバルブロックを解除',
	'globalblocking-unblock-submit' => 'グローバルブロックを解除',
	'globalblocking-unblock-reason' => '理由：',
	'globalblocking-unblock-unblocked' => "IPアドレス '''$1''' に対するグローバルブロック #$2 を解除に成功しました。",
	'globalblocking-unblock-errors' => '実施しようとしたグローバルブロックの解除は以下の{{PLURAL:$1|理由}}により実行できませんでした:',
	'globalblocking-unblock-successsub' => 'グローバルブロックの解除に成功',
	'globalblocking-unblock-subtitle' => 'グローバルブロックを解除中',
	'globalblocking-unblock-intro' => 'このフォームを使用してグローバルブロックを解除できます。',
	'globalblocking-whitelist' => 'グローバルブロックのローカル状態',
	'globalblocking-whitelist-notapplied' => 'このウィキではグローバルブロックは適用されず、よってグローバルブロックのローカル状態を変更できません。',
	'globalblocking-whitelist-legend' => 'ローカル状態の変更',
	'globalblocking-whitelist-reason' => '理由：',
	'globalblocking-whitelist-status' => 'ローカル状態:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}}でのグローバルブロックを無効にする',
	'globalblocking-whitelist-submit' => 'ローカル状態を変更',
	'globalblocking-whitelist-whitelisted' => "{{SITENAME}}におけるIPアドレス '''$1''' のアカウント#$2のグローバルブロックを解除しました。",
	'globalblocking-whitelist-dewhitelisted' => "{{SITENAME}}におけるIPアドレス '''$1''' のアカウント #$2 のグローバルブロックの再有効化に成功しました。",
	'globalblocking-whitelist-successsub' => 'ローカル状態は正常に変更されました',
	'globalblocking-whitelist-nochange' => 'このブロックのローカル状態は変更されませんでした。[[Special:GlobalBlockList|グローバルブロックの一覧に戻る]]。',
	'globalblocking-whitelist-errors' => 'グローバルブロックのローカル状態の変更に失敗しました。{{PLURAL:$1|理由}}は以下の通りです:',
	'globalblocking-whitelist-intro' => 'このフォームを使用してグローバルブロックのローカル状態を変更できます。
もしグローバルブロックがこのウィキで無効になっている場合は、該当IPアドレスは通常の編集ができるようになります。
[[Special:GlobalBlockList|グローバルブロックの一覧に戻る]]。',
	'globalblocking-blocked' => "あなたのIPアドレス $5 は、'''$1''' ('''$2''') によって全ての関連ウィキからブロックされています。
理由は'''$3'''です。
このブロックは'''$4'''の予定です。",
	'globalblocking-blocked-nopassreset' => 'あなたはグローバルブロックを受けているため、利用者パスワードを再設定できません。',
	'globalblocking-logpage' => 'グローバルブロック記録',
	'globalblocking-logpagetext' => '以下はこのウィキで実施および解除されたグローバルブロックの記録です。グローバルブロックは他のウィキでも実施したり解除したりすることができ、その結果がこのウィキにも及びます。現在有効なグローバルブロックの一覧は[[Special:GlobalBlockList]]を参照してください。',
	'globalblocking-block-logentry' => '[[$1]] を $2 グローバルブロックしました',
	'globalblocking-block2-logentry' => '[[$1]] をグローバルブロックしました ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] のグローバルブロックを解除しました',
	'globalblocking-whitelist-logentry' => '[[$1]] のグローバルブロックをローカルで無効にしました',
	'globalblocking-dewhitelist-logentry' => '[[$1]] のグローバルブロックをローカルで再有効化しました',
	'globalblocking-modify-logentry' => '[[$1]] のグローバルブロックを修正しました ($2)',
	'globalblocking-logentry-expiry' => '有効期限: $1',
	'globalblocking-logentry-noexpiry' => '期限設定なし',
	'globalblocking-loglink' => 'IP アドレス $1 はグローバルブロックされています ([[{{#Special:GlobalBlockList}}/$1|全詳細]])。',
	'globalblocking-showlog' => 'この IP アドレスは以前にブロックされたことがあります。
参考のためにブロック記録を以下に示します。',
	'globalblocklist' => 'グローバルブロックされたIPアドレス一覧',
	'globalblock' => 'IPアドレスをグローバルブロック',
	'globalblockstatus' => 'グローバルブロックのローカル状態',
	'removeglobalblock' => 'グローバルブロックを解除',
	'right-globalblock' => '他利用者のグローバルブロック',
	'right-globalunblock' => 'グローバルブロックを解除',
	'right-globalblock-whitelist' => 'グローバルブロックをローカルで無効化',
	'right-globalblock-exempt' => 'グローバルブロックを回避',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Marengaké]] alamat-alamat IP [[Special:GlobalBlockList|diblokir sacara lintas wiki]]',
	'globalblocking-block' => 'Blokir alamat IP sacara global',
	'globalblocking-block-intro' => 'Panjenengan bisa nganggo kaca iki kanggo mblokir sawijining alamat IP ing kabèh wiki.',
	'globalblocking-block-reason' => 'Alesan:',
	'globalblocking-block-expiry' => 'Kadaluwarsa pamblokiran:',
	'globalblocking-block-expiry-other' => 'Wektu kadaluwarsa liya',
	'globalblocking-block-expiry-otherfield' => 'Wektu liya:',
	'globalblocking-block-legend' => 'Blokir sawijining panganggo sacara global',
	'globalblocking-block-options' => 'Pilihan:',
	'globalblocking-block-errors' => 'Pamblokiran ora kasil, amarga {{PLURAL:$1|alesan|alesan-alesan}} iki:',
	'globalblocking-block-ipinvalid' => 'AlamatIP sing dilebokaké ($1) iku ora absah.
Tulung digatèkaké yèn panjenengan ora bisa nglebokaké jeneng panganggo!',
	'globalblocking-block-expiryinvalid' => 'Wektu kadaluwarsa sing dilebokaké ($1) ora absah.',
	'globalblocking-block-submit' => 'Blokir alamat IP iki sacara global',
	'globalblocking-block-success' => 'Alamat IP $1 bisa diblokir sacara suksès ing kabèh proyèk Wikimedia.
Panjenengan mbok-menawa kersa mirsani [[Special:GlobalBlockList|daftar blokade global]].',
	'globalblocking-block-successsub' => 'Pamblokiran global bisa kasil suksès',
	'globalblocking-block-alreadyblocked' => 'Alamat IP $1 wis diblokir sacara global. 
Panjenengan bisa mirsani blokade sing ana ing [[Special:GlobalBlockList|dhaptar blokade global]],
utawa owahi status pamblokiran sing ana kanthi ngirimaké manèh formulir iki.',
	'globalblocking-block-bigrange' => 'Rentang sing panjenengan lebokaké ($1) kekamban kanggo diblokir.
Panjenengan bisa mblokir, paling akèh, 65.536 alamat (/16 rentang)',
	'globalblocking-list-intro' => 'Iki dhaptar kabèh pamblokiran global sing ana.
Sawetara pamblokiran ditandhani minangka ora-aktif sacara lokal: iki tegesé pambokiran iki aktif ing situs liya, nanging pangurus lokal mutusaké mbukak blokade ing wiki lokal kasebut.',
	'globalblocking-list' => 'Daftar alamat-alamat IP sing diblokir sacara global',
	'globalblocking-search-legend' => 'Nggolèki blokade global',
	'globalblocking-search-ip' => 'Alamat IP:',
	'globalblocking-search-submit' => 'Nggolèki blokade',
	'globalblocking-list-ipinvalid' => 'Alamat IP sing digolèki ($1) iku ora absah.
Tulung lebokna alamat IP sing absah.',
	'globalblocking-search-errors' => 'Panggolèkan panjenengan ora kasil, amarga {{PLURAL:$1|alesan|alesan-alesan}} iki:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') sacara global mblokir [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'kadaluwarsa $1',
	'globalblocking-list-anononly' => 'anon-waé',
	'globalblocking-list-unblock' => 'batal blokir',
	'globalblocking-list-whitelisted' => 'dijabel sacara lokal déning $1: $2',
	'globalblocking-list-whitelist' => 'status lokal',
	'globalblocking-goto-block' => 'Blokir alamat IP sacara global',
	'globalblocking-goto-unblock' => 'Busak pamblokiran global',
	'globalblocking-goto-status' => 'Owahi status lokal kanggo sawijining pamblokiran global',
	'globalblocking-return' => 'Bali menyang dhaptar pamblokiran global',
	'globalblocking-notblocked' => 'Alamat IP ($1) sing panjenengan lebokaké ora diblokir sacara global.',
	'globalblocking-unblock' => 'Jabel pamblokiran global',
	'globalblocking-unblock-ipinvalid' => 'AlamatIP sing dilebokaké ($1) iku ora absah.
Tulung digatèkaké yèn panjenengan ora bisa nglebokaké jeneng panganggo!',
	'globalblocking-unblock-legend' => 'Ilangana sawijining pamblokiran global',
	'globalblocking-unblock-submit' => 'Jabel pamblokiran global',
	'globalblocking-unblock-reason' => 'Alesan:',
	'globalblocking-unblock-unblocked' => "Panjenengan sacara suksès njabel blokade global #$2 ing alamat IP '''$1'''",
	'globalblocking-unblock-errors' => 'Panjenengan gagal njabel blokade global, kanthi {{PLURAL:$1|alesan|alesan}}:',
	'globalblocking-unblock-successsub' => 'Blokade global bisa dijabel',
	'globalblocking-unblock-subtitle' => 'Njabel blokade global',
	'globalblocking-unblock-intro' => '[[Special:GlobalBlockList|Klik ing kéné]] kanggo bali menyang dhaptar pamblokiran global.',
	'globalblocking-whitelist' => 'Status lokal saka pamblokiran global',
	'globalblocking-whitelist-legend' => 'Ganti status lokal',
	'globalblocking-whitelist-reason' => 'Alesan:',
	'globalblocking-whitelist-status' => 'Status lokal:',
	'globalblocking-whitelist-statuslabel' => 'Batalna pamblokiran global iki ing {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Ngganti status lokal',
	'globalblocking-whitelist-whitelisted' => "Panjenengan sacara suksès njabel blokade global #$2 ing alamat IP '''$1''' ing {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Panjenengan sacara suksès blokade global #$2 ing alamat IP '''$1''' ing {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Status lokal kasil diganti',
	'globalblocking-whitelist-nochange' => 'Panjenengan ora ngowahi status lokal pamblokiran iki.
[[Special:GlobalBlockList|Bali menyang dhaptar pamblokiran global]].',
	'globalblocking-whitelist-errors' => 'Pangowahan marang status lokal saka pamblokiran global ora kasil; amarga {{PLURAL:$1|alesan|alesan-alesan}} iki:',
	'globalblocking-whitelist-intro' => 'Panjenengan bisa migunakaké formulir iki kanggo nyunting status lokal saka sawijining pamblokiran global.
Yèn pamblokiran dinon-aktifaké ing wiki iki, panganggo-panganggo kanthi alamat IP kasebut bakal bisa nyunting kaya adaté.
[[Special:GlobalBlockList|Bali menyang dhaptar pamblokiran global]].',
	'globalblocking-blocked' => "Alamat IP panjenengan diblokir ing kabèh wiki '''\$1''' (''\$2'').
Alesan pamblokiran yakuwi ''\"\$3\"''. 
Pamblokiran ''\$4''.",
	'globalblocking-logpage' => 'Log pamblokiran global',
	'globalblocking-logpagetext' => 'Iki log pamblokiran global sing digawé lan dibusak ing situs iki.
Perlu diweruhi yèn pamblokiran global disa digawé lan dibusak ing wiki liya sing bisa karasa uga ing wiki iki.
Kanggo mirsani kabèh pamblokiran global sing aktif wektu iki, pirsani ing[[Special:GlobalBlockList|dhaptar pamblokiran global]] iki.',
	'globalblocking-block-logentry' => 'diblokir sacara global [[$1]] mawa wektu kadaluwarsa $2',
	'globalblocking-unblock-logentry' => 'jabelen blokade global ing [[$1]]',
	'globalblocking-whitelist-logentry' => 'njabel blokade global ing [[$1]] sacara lokal',
	'globalblocking-dewhitelist-logentry' => 'trapna ulang blokade global ing [[$1]] sacara lokal',
	'globalblocklist' => 'Tuduhna daftar alamat-alamat IP sing diblokir sacara global',
	'globalblock' => 'Mblokir alamat IP sacara global',
	'globalblockstatus' => 'Status lokal saka pamblokiran global',
	'removeglobalblock' => 'Jabel pamblokiran global',
	'right-globalblock' => 'Nggawé pamblokiran global',
	'right-globalunblock' => 'Ilangana pamblokiran global',
	'right-globalblock-whitelist' => 'Jabel blokade global sacara lokal',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author ITshnik
 * @author Malafaya
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'globalblocking-desc' => 'ნებას რთავს [[Special:GlobalBlock|დაბლოკოს]]  IP-მისამართები [[Special:GlobalBlockList|რამდენიმე ვიკიში]]',
	'globalblocking-block' => 'IP მისამართის გლობალურად დაბლოკვა',
	'globalblocking-modify-intro' => 'თქვენ შეგიძლიათ ამ ფორმის გამოენება გლობალური ბლოკირების სტატუსის შესაცვლელად.',
	'globalblocking-block-intro' => 'თქვენ შეგიძლიათ გამოიყენოთ ეს გვერდი რათა დაბლოკოთ IP ყველა ვიკის.',
	'globalblocking-block-reason' => 'მიზეზი:',
	'globalblocking-block-otherreason' => 'სხვა/დამატებითი მიზეზი:',
	'globalblocking-block-reasonotherlist' => 'სხვა მიზეზი',
	'globalblocking-block-reason-dropdown' => '* ბლოკირების სტანდარტული მიზეზები
** ტრანსვიკი სპამი
** ტრანსვიკი ბოროტად გამოყენება
** ვანდალიზმი',
	'globalblocking-block-edit-dropdown' => 'დაბლოკვის მიზეზების ჩამატება',
	'globalblocking-block-expiry' => 'ვადის გვასვლა:',
	'globalblocking-block-expiry-other' => 'სხვა ვადის გასვლა',
	'globalblocking-block-expiry-otherfield' => 'სხვა დრო:',
	'globalblocking-block-legend' => 'მომხმარებლის გლობალური ბლოკირება',
	'globalblocking-block-options' => 'კონფიგურაცია',
	'globalblocking-ipaddress' => 'IP-მისამართი:',
	'globalblocking-block-errors' => 'ბლოკირების მცდელობა წარუმატებელია, {{PLURAL:$1|მიზეზი|მიზეზები}}:',
	'globalblocking-block-ipinvalid' => 'თქვენს მიერ მითითებული IP მისამართი ($1) არასწორია.
გთოვთ, გაითვალისწინეთ, თქვენ არ შეგიძლიათ მომხმარებლის სახელის შეყვანა!',
	'globalblocking-block-expiryinvalid' => 'შეყვანილი ვადა ($1) არასწორია',
	'globalblocking-block-submit' => 'ამ IP მისამართის გლობალური ბლოკირება',
	'globalblocking-modify-submit' => 'ამ გლობალური ბლოკირების შეცვლა',
	'globalblocking-block-success' => 'IP მისამართი $1 წარმატებით დაიბლოკა ყველა პროექტში.',
	'globalblocking-modify-success' => 'გლობალური ბლოკირება $1 წარმატებით შეიცვალა',
	'globalblocking-block-successsub' => 'გლობალური ბლოკირება წარმატებით დამთავრდა',
	'globalblocking-modify-successsub' => 'გლობალური ბლოკირება წარმატებით შეიცვალა',
	'globalblocking-block-alreadyblocked' => 'IP მისამართი $1 უკვე დაბლოკილია გლობალურად.
თქვენ შეგიძლიათ ნახოთ არსებული ბლოკირება [[Special:GlobalBlockList|გლობალური ბლოკირებების სიაზე]],
ან შეცვალოთ არსებული ბლოკირების პარამეტრები, ამ ფორმის განმეორებით გაგზავნით.',
	'globalblocking-block-bigrange' => 'თქვენს მიერ მითითებული დიაპაზონი ($1) ნამეტანად დიდია დასაბლოკად
თქვენ შეგიძლიათ დაბლოკოთ 65,536 მისამართზე მეტი',
	'globalblocking-list-intro' => 'ეს არის ყველა არსებული გლობალური დაბლოკვის სია.
ზოგი ბლოკი არის მონიშნული როგორც ლოკალურად გაუქმებული:
ეს ნიშნავს იმას, რომ ბლოკი არსებობდა სხვა საიტზე, თუმცა ლოკალურმა ადმინისტრატორმა მისი გაუქმება არჩია',
	'globalblocking-list' => 'გლობალურად ბლოკირებული IP-მისამართების სია',
	'globalblocking-search-legend' => 'მოიძიეთ გლობალური ბლოკი',
	'globalblocking-search-ip' => 'IP მისამართი:',
	'globalblocking-search-submit' => 'მოიძიეთ დაბლოკვები',
	'globalblocking-list-ipinvalid' => 'შეყვანილი IP ($1) არის არასწორი.
გთხოვთ შეიყვანოთ კორექტული IP',
	'globalblocking-search-errors' => 'თქვენი ძიება ვერ შენარჩუნდა:
 {{PLURAL:$1|მიზეზი|მიზეზებუ}}:
$1',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'')გლობალურად დაბლოკა [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'ვადა გასდის $1',
	'globalblocking-list-anononly' => 'მხოლოდ ანონიმები',
	'globalblocking-list-unblock' => 'წაშლა',
	'globalblocking-list-whitelisted' => 'ლოკალურად გათიშა $1: $2',
	'globalblocking-list-whitelist' => 'ლოკალური სტატუსი',
	'globalblocking-list-modify' => 'შეცვლა',
	'globalblocking-list-noresults' => 'მოთხოვნილი IP მისამართი არ არის დაბლოკილი.',
	'globalblocking-goto-block' => 'IP მისამართის გლობალურად დაბლოკვა',
	'globalblocking-goto-unblock' => 'გლობალური ბლოკირების წაშლა',
	'globalblocking-goto-status' => 'ლოკალური სტატუსის შეცვლა გლობალური ბლოკირებისთვის',
	'globalblocking-return' => 'გლობალური ბლოკირების სიაზე დაბრუნება',
	'globalblocking-notblocked' => 'IP მისამართი ($1), რომელიც თქვენ მიუთითეთ არ არის გლობალურად დაბლოკილი.',
	'globalblocking-unblock' => 'გლობალური ბლოკირების მოხსნა.',
	'globalblocking-unblock-ipinvalid' => 'თქვენ შეცდომით მიუთითეთ IP მისამართი ($1).
გთხოვთ, გაითვალისწინეთ, თქვენ არ შეგიძლიათ მომხმარებლის სახელის შეყვანა!',
	'globalblocking-unblock-legend' => 'გლობალური ბლოკირების მოხსნა',
	'globalblocking-unblock-submit' => 'გლობალური ბლოკირების მოხსნა',
	'globalblocking-unblock-reason' => 'მიზეზი:',
	'globalblocking-unblock-unblocked' => "თქვენ წარმატებით მოხსენით გლობალური ბლოკირება #$2 IP მისამართზე '''$1'''",
	'globalblocking-unblock-errors' => 'გლობალური ბლოკირების მოხსნა ვერ მოხერხდა. {{PLURAL:$1|მიზეზი|მიზეზები}}:',
	'globalblocking-unblock-successsub' => 'გლობალური ბლოკირება წარმატებით მოიხსნა',
	'globalblocking-unblock-subtitle' => 'გლობალური ბლოკირების მოხსნა',
	'globalblocking-unblock-intro' => 'თქვენ შეგიძლიათ გამოიყენოთ ეს ფორმა გლობალური ბლოკირების მოსახსნელად.',
	'globalblocking-whitelist' => 'გლობალური ბლოკირებების ლოკალური სტატუსი',
	'globalblocking-whitelist-notapplied' => 'ამ ვიკიზე არ გამოიყენება გლობალური ბლოკირებები,
ამიტომ გლობალური ბლოკირებების ლოკალური სტატუსების შეცვლა არ შეიძლება.',
	'globalblocking-whitelist-legend' => 'ლოკალური სტატუსის შეცვლა',
	'globalblocking-whitelist-reason' => 'მიზეზი:',
	'globalblocking-whitelist-status' => 'ლოკალური სტატუსი:',
	'globalblocking-whitelist-statuslabel' => 'ამ გლობალური ბლოკირების გამორთვა {{SITENAME}}-ზე',
	'globalblocking-whitelist-submit' => 'ლოკალური სტატუსის შეცვლა',
	'globalblocking-whitelist-whitelisted' => "თქვენ წარმატებით გამორთეთ გლობალური ბლოკირება #$2 IP მისამართი '''$1''' {{SITENAME}}-ზე.",
	'globalblocking-whitelist-dewhitelisted' => "თქვენ წარმატებით აღადგინეთ გლობალური ბლოკირება #$2 IP მისამართზე '''$1''' {{SITENAME}}-ზე.",
	'globalblocking-whitelist-successsub' => 'ლოკალური სტატუსი წარმატებით შეიცვალა',
	'globalblocking-whitelist-nochange' => 'თქვენ არ შეგიტანიათ ამ ბლოკირების ლოკალურ სტატუსზე.
[[Special:GlobalBlockList|გლობალური ბლოკირების სიაზე დაბრუნება]].',
	'globalblocking-whitelist-errors' => 'გლობალური ბლოკირების ლოკალური სტატუსის შეცვლა ვერ მოხერხდა. {{PLURAL:$1|მიზეზი|მიზეზები}}:',
	'globalblocking-whitelist-intro' => 'თქვენ შეგიძლიათ გამოიყენოთ ეს ფორმა გლობალური ბლოკის შესასწორებლად.
თუ გლობალური ბლოკი ამ ვიკიზე გათიშულია, ამ IP მისამართის მქონე მომხმარებლები შესძლებენ ნორმალურად რედაქტირებას.
[[Special:GlobalBlockList|დაბლოკვის სიაში დაბრუნება]].',
	'globalblocking-blocked' => "თქვენი IP მისამართი დაბლოკილ იქნა ყველა ვიკიზე მომხმარებელ '''\$1''' (''\$2'') მიერ.
მითითებულ იქნა მიზეზი ''\"\$3\"''.
ბლოკირება ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'თქვენ არ შეგიძლიათ მომხმარებლის პაროლის შეცვლა, რადგან თქვენი ანგარიში გლობალურად ბლოკირებულია.',
	'globalblocking-logpage' => 'გლობალური ბლოკირების ჟურნალი',
	'globalblocking-logpagetext' => 'ეს არის ამ ვიკიში განხორციელებული გლობალური დაბლოკვების ნუსხა,
გასათვალისწინებელია, რომ გლობალური ბლოკი შესაძლოა არ იყო დაყენებული ამ ვიკიში - თუმცა ისინი თქვენ ვიკისაც ეხებიან.
ყველა ბლოკის სანახავად იხილეთ [[Special:GlobalBlockList|სია]].',
	'globalblocking-block-logentry' => 'გლობალურად დაბლოკილია [[$1]]; ვადა გასდის $2',
	'globalblocking-block2-logentry' => 'გლობალურად დაბლოკილია [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'მოხსნილია გლობალური ბლოკირება [[$1]]-ზე',
	'globalblocking-whitelist-logentry' => 'ლოკალურად გათიშულია ბლოკი [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'გლობალური ბლოკირება ხელახლა ჩართულია [[$1]]ზე ლოკალურად',
	'globalblocking-modify-logentry' => 'შეცვალა გლობალური ბლოკი [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'ვადა გასდის $1',
	'globalblocking-logentry-noexpiry' => 'ვადა არ არის დანიშნული',
	'globalblocking-loglink' => 'IP-მისამართი დაბლოკა $1 -მა გლობალურად ([[{{#Special:GlobalBlockList}}/$1|დამ. ინფ.]]).',
	'globalblocking-showlog' => 'ეს IP მისამართი დაბლოკილი იყო ადრე. ქვემოთ მოყვანილია ამონაწერი ბლოკირებათა ჟურნალიდან:',
	'globalblocklist' => 'გლობალურად დაბლოკილი IP მისამართების სია',
	'globalblock' => 'IP მისამართის გლობალური ბლოკირება',
	'globalblockstatus' => 'გლობალური ბლოკირების ლოკალური სტატუსი',
	'removeglobalblock' => 'გლობალური ბლოკირების მოხსნა',
	'right-globalblock' => 'გლობალური ბლოკირების გაკეთება',
	'right-globalunblock' => 'გლობალური ბლოკირების მოხსნა',
	'right-globalblock-whitelist' => 'გლობალური ბლოკირების ლოკალური გამორთვა',
	'right-globalblock-exempt' => 'გლობალური ბლოკირების გვერდის ავლა',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'globalblocking-block' => 'រាំងខ្ទប់​អាសយដ្ឋាន IP ជា​សកល',
	'globalblocking-block-intro' => 'អ្នកអាចប្រើប្រាស់ទំព័រនេះដើម្បីហាមឃាត់អាសយដ្ឋាន IP នៅគ្រប់វិគីទាំងអស់។',
	'globalblocking-block-reason' => 'មូលហេតុ៖',
	'globalblocking-block-otherreason' => 'មូលហេតុផ្សេង​ៗ/បន្ថែមទៀត៖',
	'globalblocking-block-reasonotherlist' => 'មូលហេតុផ្សេង​ទៀត​',
	'globalblocking-block-expiry' => 'ផុតកំណត់៖',
	'globalblocking-block-expiry-other' => 'រយៈពេលផុតកំណត់ផ្សេងទៀត',
	'globalblocking-block-expiry-otherfield' => 'រយៈពេលផុតកំណត់ផ្សេងទៀត៖',
	'globalblocking-block-legend' => 'រាំងខ្ទប់​អាសយដ្ឋាន​IPជា​សកល',
	'globalblocking-block-options' => 'ជម្រើសនានា៖',
	'globalblocking-block-errors' => 'ការរាំងខ្ទប់​របស់​អ្នក មិន​បាន​ជោគជ័យ​ទេ, សម្រាប់ {{PLURAL:$1|ហេតុផល|ហេតុផល}}​ដូចតទៅ:',
	'globalblocking-block-expiryinvalid' => 'រយៈពេល​ផុតកំណត់​ដែល​អ្នក​បាន​បញ្ចូល ($1) មិន​ត្រឹមត្រូវ​ទេ​។',
	'globalblocking-block-submit' => 'រាំងខ្ទប់​អាសយដ្ឋាន IP ជា​សកល',
	'globalblocking-block-success' => 'អាសយដ្ឋាន IP $1 ត្រូវ​បាន​រាំងខ្ទប់​លើ​គ្រប់​គម្រោង​ទាំងអស់ ដោយជោគជ័យ​ហើយ​។',
	'globalblocking-block-successsub' => 'រាំងខ្ទប់​​ជា​សកល​ដោយជោគជ័យ',
	'globalblocking-search-legend' => 'ស្វែងរក​ការរាំងខ្ទប់​សកល',
	'globalblocking-search-ip' => 'អាសយដ្ឋាន IP ៖',
	'globalblocking-search-submit' => 'ស្វែងរកចំពោះការហាមឃាត់',
	'globalblocking-search-errors' => 'ការស្វែងរក​របស់​អ្នក​មិន​ទទួល​បាន​ជោគជ័យ​ទេ, សម្រាប់ {{PLURAL:$1|ហេតុផល|ហេតុផល}}​ដូចតទៅ:',
	'globalblocking-list-expiry' => 'ផុតកំណត់ $1',
	'globalblocking-list-anononly' => 'អនាមិកជនប៉ុណ្ណោះ',
	'globalblocking-list-unblock' => 'ដកហូត',
	'globalblocking-list-whitelisted' => 'បាន​បិទ​ជា​មូលដ្ឋាន​ដោយ $1: $2',
	'globalblocking-list-whitelist' => 'ស្ថានភាព​មូលដ្ឋាន',
	'globalblocking-list-modify' => 'កែសំរួល',
	'globalblocking-goto-block' => 'រាំងខ្ទប់​អាសយដ្ឋាន​ជា​សកល',
	'globalblocking-goto-unblock' => 'ដកចេញ​ការរាំងខ្ទប់​សកល',
	'globalblocking-return' => 'ត្រឡប់​ទៅកាន់​បញ្ជី​នៃ​ការរាំងខ្ទប់​សកល',
	'globalblocking-notblocked' => 'អាសយដ្ឋាន IP ($1) ដែល​អ្នក​បាន​បញ្ចូល​មិន​ត្រូវ​បាន​រាំងខ្ទប់​ជា​សកល​ទេ​។',
	'globalblocking-unblock' => 'ដកចេញ​ការរាំងខ្ទប់​សកល',
	'globalblocking-unblock-ipinvalid' => 'អាសយដ្ឋាន IP ($1) ដែល​អ្នក​បាន​បញ្ចូល​មិន​ត្រឹមត្រូវ​ទេ​។

សូម​ចំណាំ​ថា អ្នក​មិន​អាច​បញ្ចូល​ឈ្មោះរបស់អ្នកប្រើប្រាស់​បាន​ទេ!',
	'globalblocking-unblock-legend' => 'ដកចេញ​ការរាំងខ្ទប់​សកល',
	'globalblocking-unblock-submit' => 'ដាកចេញ​ការរាំងខ្ទប់​សកល',
	'globalblocking-unblock-reason' => 'មូលហេតុ៖',
	'globalblocking-unblock-unblocked' => "អ្នក​បាន​ដកចេញ​ការរាំងខ្ទប់​សកល ដោយជោគជ័យ #$2 នៅលើ​អាសយដ្ឋាន IP '''$1'''",
	'globalblocking-unblock-successsub' => 'ដកចេញ​ការរាំងខ្ទប់​សកល ដោយជោគជ័យ',
	'globalblocking-unblock-subtitle' => 'ដកចេញ​ការរាំងខ្ទប់​សកល',
	'globalblocking-unblock-intro' => 'អ្នក​បាន​ប្រើប្រាស់​ទម្រង់​នេះ ដើម្បី​ដកចេញ​ការរាំងខ្ទប់​សកល​។',
	'globalblocking-whitelist-legend' => 'ប្ដូរ​ស្ថានភាព​មូលដ្ឋាន',
	'globalblocking-whitelist-reason' => 'មូលហេតុ៖',
	'globalblocking-whitelist-status' => 'ស្ថានភាព​មូលដ្ឋាន:',
	'globalblocking-whitelist-submit' => 'ប្ដូរ​ស្ថានភាព​មូលដ្ឋាន',
	'globalblocking-whitelist-successsub' => 'បាន​ប្ដូរ​ស្ថានភាព​មូលដ្ឋាន ដោយ​ជោគជ័យ',
	'globalblocking-blocked' => "អាសយដ្ឋាន IP  \$5 ត្រូវ​បាន​រាំងខ្ទប់​នៅលើ​វិគី​ទាំងអស់​ដោយ '''\$1''' (''\$2'') ។

ហេតុផល​គឺ ''\"\$3\"'' ។

ការរាំងខ្ទប់ ''\$4'' ។",
	'globalblocking-logpage' => 'កំណត់ហេតុនៃការហាមឃាត់ជាសាកល',
	'globalblocking-unblock-logentry' => 'ដកចេញ​ការរាំងខ្ទប់​សកល​នៅលើ [[$1]]',
	'globalblock' => 'រាំងខ្ទប់​ជា​សកល​ចំពោះ​អាសយដ្ឋាន IP',
	'removeglobalblock' => 'ដកចេញ​ការរាំងខ្ទប់​សកល',
	'right-globalunblock' => 'ដកចេញ​ការរាំងខ្ទប់​សកល',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'globalblocking-block-reason' => 'ಕಾರಣ:',
	'globalblocking-block-otherreason' => 'ಇತರ/ಹೆಚ್ಚುವರಿ ಕಾರಣ:',
	'globalblocking-block-reasonotherlist' => 'ಇತರ ಕಾರಣ',
	'globalblocking-block-expiry-otherfield' => 'ಇತರ ಸಮಯ:',
	'globalblocking-unblock-reason' => 'ಕಾರಣ:',
	'globalblocking-whitelist-reason' => 'ಕಾರಣ:',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Devunt
 * @author Ficell
 * @author Klutzy
 * @author Kwj2772
 */
$messages['ko'] = array(
	'globalblocking-desc' => '특정 IP를 [[Special:GlobalBlockList|모든 위키]]에서 [[Special:GlobalBlock|차단]]하는 권한을 추가',
	'globalblocking-block' => 'IP 주소를 모든 위키에서 차단',
	'globalblocking-modify-intro' => '당신은 전체 차단 설정을 변경할 때 이 양식을 사용할 수 있습니다.',
	'globalblocking-block-intro' => '당신은 모든 위키에서 특정 IP를 차단할 때 이 페이지를 사용할 수 있습니다.',
	'globalblocking-block-reason' => '이유:',
	'globalblocking-block-otherreason' => '다른 이유/추가적인 이유:',
	'globalblocking-block-reasonotherlist' => '다른 이유',
	'globalblocking-block-reason-dropdown' => '*일반적인 차단 이유
** 여러 위키에서의 광고/스팸 행위
** 여러 위키에서의 부정 행위
** 문서 훼손',
	'globalblocking-block-edit-dropdown' => '차단 이유 목록 편집하기',
	'globalblocking-block-expiry' => '기간:',
	'globalblocking-block-expiry-other' => '다른 기간',
	'globalblocking-block-expiry-otherfield' => '다른 기간:',
	'globalblocking-block-legend' => '특정 IP를 전체 위키에서 차단하기',
	'globalblocking-block-options' => '설정:',
	'globalblocking-ipaddress' => 'IP 주소:',
	'globalblocking-ipbanononly' => '익명 사용자만 차단',
	'globalblocking-block-errors' => '다음 {{PLURAL:$1|이유로|$1가지 이유로}} 인해 차단하는 데 실패하였습니다:',
	'globalblocking-block-ipinvalid' => '당신이 입력한 IP 주소 ($1) 가 잘못되었습니다.
계정 이름을 입력할 수 없다는 것을 알아 두시기 바랍니다!',
	'globalblocking-block-expiryinvalid' => '당신이 입력한 기한($1)이 잘못되었습니다.',
	'globalblocking-block-submit' => '이 IP 주소를 전체 위키에서 차단',
	'globalblocking-modify-submit' => '차단 설정 변경',
	'globalblocking-block-success' => 'IP 주소 $1이 모든 프로젝트에서 성공적으로 차단되었습니다.',
	'globalblocking-modify-success' => '$1 계정에 대한 광역 차단 설정이 변경되었습니다.',
	'globalblocking-block-successsub' => '전체 차단 성공',
	'globalblocking-modify-successsub' => '전체 차단 설정이 성공적으로 변경되었습니다.',
	'globalblocking-block-alreadyblocked' => 'IP 주소 $1은 이미 전체적으로 차단되었습니다.
당신은 [[Special:GlobalBlockList|전체 차단된 사용자의 목록]]에서 현재 차단된 IP를 보거나,
이 양식을 사용하여 이미 차단된 IP의 차단 설정을 변경할 수 있습니다.',
	'globalblocking-block-bigrange' => '당신이 입력한 범위 ($1)는 차단하기에 너무 넓습니다.
당신은 아무리 많아도, 65,536개의 주소 (/16 광역) 이상을 차단할 수 없습니다.',
	'globalblocking-list-intro' => '현재 유효한 전체 차단의 목록입니다. 전체 차단은 로컬의 관리자의 권한으로 무효화 할 수 있습니다. 단 로컬에서 무효화하더라도 다른 위키에서는 차단 상태가 지속됩니다.',
	'globalblocking-list' => '모든 위키에서 차단된 IP 목록',
	'globalblocking-search-legend' => '전체 차단 찾기',
	'globalblocking-search-ip' => 'IP 주소:',
	'globalblocking-search-submit' => '차단 찾기',
	'globalblocking-list-ipinvalid' => '당신이 입력한 IP 주소 ($1)가 잘못되었습니다.
유효한 IP 주소를 입력해주세요.',
	'globalblocking-search-errors' => '검색에 실패했습니다. 아래의 {{PLURAL:$1|원인}}를 확인해주세요.',
	'globalblocking-list-blockitem' => '$1: <span class="plainlinks">\'\'\'$2\'\'\'</span> ($3) 이(가) [[Special:Contributions/$4|$4]] 을(를) 전체 위키에서 차단하였습니다. ($5)',
	'globalblocking-list-expiry' => '기한 $1',
	'globalblocking-list-anononly' => '익명 사용자만',
	'globalblocking-list-unblock' => '차단 해제',
	'globalblocking-list-whitelisted' => '$1에 의해 로컬에서 해제됨: $2',
	'globalblocking-list-whitelist' => '로컬 상태 변경',
	'globalblocking-list-modify' => '차단 설정 변경',
	'globalblocking-list-noresults' => '당신이 입력한 IP 주소는 차단되지 않았습니다.',
	'globalblocking-goto-block' => 'IP를 전체 위키에서 차단',
	'globalblocking-goto-unblock' => '전체 차단 해제',
	'globalblocking-goto-status' => '전체 차단의 로컬 상태 바꾸기',
	'globalblocking-return' => '전체 차단된 IP의 목록으로 돌아가기',
	'globalblocking-notblocked' => '당신이 입력한 IP 주소 ($1)은 전체 차단되지 않았습니다.',
	'globalblocking-unblock' => '전체 차단 해제',
	'globalblocking-unblock-ipinvalid' => '입력한 IP 주소($1)가 잘못되었습니다.
계정 이름은 입력이 불가능하다는 것을 주의해주세요.',
	'globalblocking-unblock-legend' => '전체 차단 해제',
	'globalblocking-unblock-submit' => '전체 차단 해제',
	'globalblocking-unblock-reason' => '이유:',
	'globalblocking-unblock-unblocked' => "IP 주소 '''$1'''에 대한 전체 차단 #$2가 성공적으로 해제되었습니다.",
	'globalblocking-unblock-errors' => '전체 차단 해제에 실패했습니다. {{PLURAL:$1|이유}}는 다음과 같습니다:',
	'globalblocking-unblock-successsub' => '전체 차단이 성공적으로 해제되었습니다.',
	'globalblocking-unblock-subtitle' => '전체 차단 해제',
	'globalblocking-unblock-intro' => '이 양식을 이용해 전체 차단을 해제할 수 있습니다.',
	'globalblocking-whitelist' => '전체 차단의 로컬 상태',
	'globalblocking-whitelist-notapplied' => '이 위키에서는 전체 차단이 적용되지 않습니다.
따라서 전체 차단의 로컬 상태를 바꿀 수 없습니다.',
	'globalblocking-whitelist-legend' => '로컬 상태 변경',
	'globalblocking-whitelist-reason' => '이유:',
	'globalblocking-whitelist-status' => '로컬 상태:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}}에서 전체 위키 차단을 비활성화하기',
	'globalblocking-whitelist-submit' => '로컬 상태 변경',
	'globalblocking-whitelist-whitelisted' => "{{SITENAME}}에서 IP 주소 '''$1'''에 대한 전체 차단 #$2를 비활성화하는 데 성공했습니다.",
	'globalblocking-whitelist-dewhitelisted' => "{{SITENAME}}에서 IP 주소 '''$1'''에 대한 전체 차단 #$2가 성공적으로 다시 활성화되었습니다.",
	'globalblocking-whitelist-successsub' => '전체 차단의 로컬 상태가 성공적으로 변경되었습니다.',
	'globalblocking-whitelist-nochange' => '전체 차단의 로컬 상태를 바꾸지 않았습니다.
[[Special:GlobalBlockList|전체 차단된 IP의 목록으로 돌아갑니다]].',
	'globalblocking-whitelist-errors' => '광역 차단 설정 변경에 실패했습니다. 이유는 다음과 같습니다: $1',
	'globalblocking-whitelist-intro' => '이 양식을 통해 전체 차단의 로컬 상태를 바꿀 수 있습니다.
전체 차단이 이 위키에서 비활성화되면 해당 IP 주소를 이용하는 사용자는 정상적으로 편집할 수 있게 됩니다.
[[Special:GlobalBlockList|전체 차단 목록으로 돌아가기]].',
	'globalblocking-blocked' => "당신의 IP 주소 \$5는 '''\$1''' (''\$2'')에 의해 모든 위키에서 차단되었습니다.
차단 사유는 \"\$3\"이며, 기한은 \"\$4\"입니다.",
	'globalblocking-blocked-nopassreset' => '당신은 모든 위키에서 차단되었기 때문에 비밀번호를 바꿀 수 없습니다.',
	'globalblocking-logpage' => '전체 위키 차단 기록',
	'globalblocking-logpagetext' => '이 페이지는 이 위키에서 이루어진 전체 차단 및 해제와 관련된 기록입니다.
전체 차단은 다른 위키에서 이루어질 수 있으며 이 위키에 영향을 줄 수 있다는 것을 알아두십시오.
지금 활성화된 모든 [[Special:GlobalBlockList|전체 차단 목록]]을 볼 수 있습니다.',
	'globalblocking-block-logentry' => '[[$1]] 사용자를 모든 위키에서 $2 차단함',
	'globalblocking-block2-logentry' => '[[$1]] 사용자를 모든 위키에서 차단함 ($2)',
	'globalblocking-unblock-logentry' => '[[$1]]의 전체 위키 차단을 해제함',
	'globalblocking-whitelist-logentry' => '[[$1]]의 전체 차단을 로컬에서 비활성화함',
	'globalblocking-dewhitelist-logentry' => '[[$1]]의 전체 차단을 로컬에서 다시 활성화함',
	'globalblocking-modify-logentry' => '[[$1]]에 대한 전체 차단 설정을 변경 ($2)',
	'globalblocking-logentry-expiry' => '$1에 해제',
	'globalblocking-logentry-noexpiry' => '기한이 정해지지 않음',
	'globalblocking-loglink' => 'IP 주소 $1은 모든 위키에서 차단되었습니다. ([[{{#Special:GlobalBlockList}}/$1|자세한 정보]])',
	'globalblocking-showlog' => '이 IP 주소는 이전에 차단된 적이 있습니다.
아래의 차단 기록을 참고하십시오:',
	'globalblocklist' => '모든 위키에서 차단된 IP 목록',
	'globalblock' => '전체 위키에서 IP 주소를 차단',
	'globalblockstatus' => '전체 차단의 로컬 상태',
	'removeglobalblock' => '전체 차단을 해제',
	'right-globalblock' => '전체 위키 차단',
	'action-globalblock' => '전체 위키 차단을 할',
	'right-globalunblock' => '전체 위키에서 차단을 해제',
	'action-globalunblock' => '전체 위키 차단을 해제할',
	'right-globalblock-whitelist' => '로컬에서 전체 차단을 비활성화',
	'action-globalblock-whitelist' => '로컬에서 전체 차단을 비활성화할',
	'right-globalblock-exempt' => '전체 차단을 우회',
	'action-globalblock-exempt' => '전체 차단을 우회할',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 */
$messages['krc'] = array(
	'globalblocklist' => 'Глобал халда блокланнган IP-адреслени списогу',
	'globalblockstatus' => 'Глобал блоклауланы локал халлары',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Älaup]] IP Addresses ze [[Special:GlobalBlockList|sperre övver ettlijje Wikis]].',
	'globalblocking-block' => 'En IP-Address en alle Wikis sperre',
	'globalblocking-modify-intro' => 'Hee kanns de Enstellunge för de Sperre övver ettlijje Wikis ändere.',
	'globalblocking-block-intro' => 'He op dä Sigg kans De IP-Address en alle Wikis sperre.',
	'globalblocking-block-reason' => 'Aanlass:',
	'globalblocking-block-otherreason' => 'Ene andere ov zohsäzlejje Jrund:',
	'globalblocking-block-reasonotherlist' => 'Ene andere Jrond',
	'globalblocking-block-reason-dropdown' => '* Jemeinsam Jrönde för et Sperre
** Spam en etlijje Wikis
** Hät en etlijje Wikis Meß jemaat 
** Kappotmaachereie',
	'globalblocking-block-edit-dropdown' => 'De Jründ för et Sperre beärrbejde',
	'globalblocking-block-expiry' => 'De Dooer för ze Sperre:',
	'globalblocking-block-expiry-other' => 'En ander Dooer',
	'globalblocking-block-expiry-otherfield' => 'Ander Dooer (op änglesch):',
	'globalblocking-block-legend' => 'Don en <i lang="en">IP</i>-Addräß en alle Wikis sperre',
	'globalblocking-block-options' => 'Enstellunge:',
	'globalblocking-ipaddress' => 'De <i lang="en">IP</i>-Adräß:',
	'globalblocking-ipbanononly' => 'Bloß de Namelose sperre',
	'globalblocking-block-errors' => 'Dat Sperre hät nit jeklapp.
{{PLURAL:$1|Der Jrond:|De Jrönd:|Woröm, wesse mer nit.}}',
	'globalblocking-block-ipinvalid' => 'Do häs en kapodde IP-Address ($1) aanjejovve.
Denk draan, dat De kein Name fun Metmaacher he aanjevve kanns.',
	'globalblocking-block-expiryinvalid' => 'De Door ($1) es Kappes.',
	'globalblocking-block-submit' => 'Don hee di IP Address in alle Wikis sperre',
	'globalblocking-modify-submit' => 'Donn hee di Sperr en alle Wikis ändere',
	'globalblocking-block-success' => 'Di IP adress „$1“ eß jetz en alle Wikis jesperrt.',
	'globalblocking-modify-success' => 'De Sperr en alle Wikis för $1 es jez jeändert',
	'globalblocking-block-successsub' => 'En alle Wikis jesperrt',
	'globalblocking-modify-successsub' => 'Di Sperr en alle Wikis es jez jeändert',
	'globalblocking-block-alreadyblocked' => 'De <i lang="en">IP</i> Adress $1 es ald en alle Wikis jesperrt. Do kanns Der di Sperr en de
[[Special:GlobalBlockList|{{int:Globalblocking-list}}]] aanloore, udder och de
Enshtellunge för die Sperr ändere, indämm dat de hee dat Fommulaa noch ens ajschecke deihß.',
	'globalblocking-block-bigrange' => 'Do häs $1 aanjejovve. Dä Bereisch es ze jruuß zom Sperre.
Do kanns beß op {{formatnum:65536}}&nbsp;IP-Adresse, udder ene /16-er Knubbel, op eijmohl sperre.',
	'globalblocking-list-intro' => 'Dat hee es en Leß met alle Sperre, di för alle Wikis op eijmol sin.
E paa Sperre künnte mekeet sin, dat se hee em Wiki för hee dat Wiki
opjehovve sin. Dat bedügg, dat se en ander Wikis bestonn, ävver för
hee hat ene Wiki-Köbes se opjehovve.',
	'globalblocking-list' => 'Leß met de en alle Wikis jesperrte IP-Addresse',
	'globalblocking-search-legend' => 'Noh en Sperr en alle Wikis söke',
	'globalblocking-search-ip' => 'IP Address:',
	'globalblocking-search-submit' => 'Sperre söke',
	'globalblocking-list-ipinvalid' => 'De IP-Address $1, woh De noh jesooht häß, di es nit jölltesch.
Donn en reschtejje IP-Addrss enjävve.',
	'globalblocking-search-errors' => 'Beim Söke kohm nix erus.
{{PLURAL:$1|Der Jrond:|De Jrönd:|Woröm, wesse mer nit.}}',
	'globalblocking-list-blockitem' => "\$1: dä <span class=\"plainlinks\">'''\$2'''</span> (fun ''\$3'') hät dä [[Special:Contributions/\$4|\$4]] en alle Wikis jesperrt. ''(\$5)''",
	'globalblocking-list-expiry' => 'dooht bes $1',
	'globalblocking-list-anononly' => 'nor namelose',
	'globalblocking-list-unblock' => 'Ophävve',
	'globalblocking-list-whitelisted' => 'hee em Wiki opjehovve fum $1: $2',
	'globalblocking-list-whitelist' => 'dä Zoshtand hee em Wiki',
	'globalblocking-list-modify' => 'ändere',
	'globalblocking-list-noresults' => 'De jewönschte <i lang="en">IP</i>-Addräß es jespert.',
	'globalblocking-goto-block' => 'En IP-Address för alle Wikis sperre',
	'globalblocking-goto-unblock' => 'En Sperr för alle Wikis ophävve',
	'globalblocking-goto-status' => 'Donn ä Stattus hee em Wiki ändere, fun en Sperr för alle Wikis',
	'globalblocking-return' => 'Op di {{int:globalblocking-list}} zerök jon.',
	'globalblocking-notblocked' => 'De IP-Adress $1 es nit för alle Wikis jesperrt.',
	'globalblocking-unblock' => 'En Sperr för alle Wikis ophävve',
	'globalblocking-unblock-ipinvalid' => 'De IP-Adress $1 es nit jöltesch.
Do kanns hee kein Metmaacher-Name aanjävve!',
	'globalblocking-unblock-legend' => 'En Sperr för alle Wikis ophävve',
	'globalblocking-unblock-submit' => 'Öphävve',
	'globalblocking-unblock-reason' => 'Aanlass:',
	'globalblocking-unblock-unblocked' => "Do häß de Sperr en alle Wikis met de Nommer #$2, fun de IP-Adress '''$1''', opjehovve.",
	'globalblocking-unblock-errors' => 'De Sperr en alle Wikis upzehävve hät nit jeflupp.
{{PLURAL:$1|Der Jrond|De Jrönde sin}}:',
	'globalblocking-unblock-successsub' => 'De Sperr en alle Wikis es opjehovve',
	'globalblocking-unblock-subtitle' => 'En Sperr för alle Wikis ophävve',
	'globalblocking-unblock-intro' => 'Hee kanns De en Sperr för alle Wikis ophävve.',
	'globalblocking-whitelist' => 'Dä Stattus hee em Wiki fun de Sperre för alle Wikis',
	'globalblocking-whitelist-notapplied' => 'De Sperre för alle Wikis wääde hee en däm Wiki nit opjenumme,
dröm künne mer der Stattus fun dänne Sperre för hee em Wiki och nit ändere,
nur för anderswoh.',
	'globalblocking-whitelist-legend' => 'Der Zostand hee em Wiki ändere',
	'globalblocking-whitelist-reason' => 'Jrund:',
	'globalblocking-whitelist-status' => 'Der Zostand hee em Wiki:',
	'globalblocking-whitelist-statuslabel' => 'De Sperr fun alle Wikis hee em Wiki ophävve',
	'globalblocking-whitelist-submit' => 'Der Zostand hee em Wiki ändere',
	'globalblocking-whitelist-whitelisted' => "Do häß de Sperr en alle Wikis met de Nommer #$2, fun de IP-Adress '''$1''', en hee dämm Wiki opjehovve.",
	'globalblocking-whitelist-dewhitelisted' => "Do häß de Sperr en alle Wikis met de Nommer #$2, fun de IP-Adress '''$1''', en hee dämm Wiki widder ennjeschalldt.",
	'globalblocking-whitelist-successsub' => 'Der Zohstand hee em Wiki eß jez jeändert',
	'globalblocking-whitelist-nochange' => 'Do häß hee em Wiki nix aan dä Sperr verändert. Jangk zeröck noh de
[[Special:GlobalBlockList|{{int:Globalblocking-list}}]].',
	'globalblocking-whitelist-errors' => 'Dinge Versooch, aan dä Sperr nur för hee dat Wiki jet ze ändere, hät nit jeflupp.
{{PLURAL:$1|Der Jrond|De Jrönde sin}}:',
	'globalblocking-whitelist-intro' => 'För en Sperr en alle Wikis kanns De hee, nur för dat Wiki
en Ußnahm maache. Wann esu en Sperr hee em Wiki ußjesaz es,
künne de Metmaacher en hee däm Wiki fun dä IP-Adress udder
dä IP-Adresse uß janz nommaal alles don. Jangk zeröck noh de
[[Special:GlobalBlockList|{{int:Globalblocking-list}}]].',
	'globalblocking-blocked' => "Ding IP_Address $5 es in alle Wikis jespert woode.
Dä '''$1''' (''$2'') hädd_et jedonn.
Sing Jrund wohr: „''$3''“.
De Sperr jeiht ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Do kanns andere Metmaachere ier Paßwoot nit retuur säze, Do bes en alle Wikis jesperrt.',
	'globalblocking-logpage' => 'Logboch fum IP-Adresse en alle Wikis sperre',
	'globalblocking-logpagetext' => "Dat es et Logboch met alle Sperre, di op alle Wikis op eimohl jemaat ov opjehovve woode sen.
Mer moß sesch em klore sen, dat die Sperre ''op ander Wikis'' jemaat woode sin künne.
Dobei donn se ävver och för hee dat Wiki wirke.
Öm der all de jrad jötijje Sperre för all de Wikis op eijmohl aanzeloohre, jangk noh de [[Special:GlobalBlockList|{{int:Globalblocking-list}}]].",
	'globalblocking-block-logentry' => 'hät [[$1]] en alle Wikis jesperrt, för en Duuer fun: $2',
	'globalblocking-block2-logentry' => 'hät {{GENDER:$1|dä|et|dä Metmaacher|dat|de}} [[$1]] en alle Wikis jespert, wäje: $2',
	'globalblocking-unblock-logentry' => 'hät en alle Wikis [[$1]] widder freijejovve',
	'globalblocking-whitelist-logentry' => 'hät dem [[$1]] sing Sperr en alle Wikis för dat Wiki hee ußjesatz',
	'globalblocking-dewhitelist-logentry' => 'hät däm [[$1]] sing Sperr en alle Wiki för dat Wiki hee och widder enjeschalldt',
	'globalblocking-modify-logentry' => 'hät de Sperr {{GENDER:$1|vum|vum|vum Metmaacher|vum|vun der}} [[$1]] en alle Wikis verändert, wäje: $2.',
	'globalblocking-logentry-expiry' => 'löüf uß: $1',
	'globalblocking-logentry-noexpiry' => 'Nix jesaz, wann de Sperr ußloufe sull',
	'globalblocking-loglink' => 'Di <i lang="en">IP</i>-Addräß es en alle Wikis jespert ([[{{#Special:GlobalBlockList}}/$1|All Eijnzelheijte]])',
	'globalblocking-showlog' => 'Di <i lang="en">IP</i>-Addräß es ald ens jespert jewääse.
Et {{int:blocklogpage}} es hee dronger opjeföhrt, do kanns De nohkike, wat wohr:',
	'globalblocklist' => 'Less met dä en alle Wikis jesperrte IP-Addresse',
	'globalblock' => 'Don en IP-Address en alle Wikis sperre',
	'globalblockstatus' => 'Der Zohstand hee em Wiki fun de IP-Address-Sperre en alle Wikis',
	'removeglobalblock' => 'En Sperr för en IP-Address en alle Wikis ophevve',
	'right-globalblock' => 'En Sperr för en IP-Address en alle Wikis enreschte',
	'right-globalunblock' => 'En Sperr fun alle Wiki ophevve',
	'right-globalblock-whitelist' => 'En Sperr för en IP-Address en alle Wikis ophevve, ävver nur för hee dat Wiki',
	'right-globalblock-exempt' => 'Jemeinsam Sperre ömjonn',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'globalblocking-block-reason' => 'Sedem:',
	'globalblocking-block-reasonotherlist' => 'Sedemekî din',
	'globalblocking-block-expiry-otherfield' => 'Demeka din:',
	'globalblocking-block-submit' => "Vê IP'yê li her cihî asteng bike",
	'globalblocking-search-ip' => "Adresê IP'ê:",
	'globalblocking-unblock-reason' => 'Sedem:',
	'globalblocking-whitelist-reason' => 'Sedem:',
);

/** Latin (Latina)
 * @author UV
 */
$messages['la'] = array(
	'globalblocking-whitelist' => 'Status localis obstructionum globalium',
	'globalblocking-showlog' => 'Hic locus IP antea obstructus est.
Commodule notatio obstructionum subter datur.',
	'globalblockstatus' => 'Status localis obstructionum globalium',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Erlaabt et]] IP-Adressen op [[Special:GlobalBlockList|méi Wikie mateneen ze spären]]',
	'globalblocking-block' => 'Eng IP-Adress global spären',
	'globalblocking-modify-intro' => "Dir kënnt dëse Formulaire benotze fir eng global Spär z'änneren.",
	'globalblocking-block-intro' => 'Dir kënnt dës Säit benotze fir eng IP-Adress op alle Wikien ze spären.',
	'globalblocking-block-reason' => 'Grond:',
	'globalblocking-block-otherreason' => 'Aneren/zousätzleche Grond:',
	'globalblocking-block-reasonotherlist' => 'Anere Grond',
	'globalblocking-block-reason-dropdown' => '* Heefegst Spärgrënn
** Spam op méi Wikien
** Mëssbrauch op méi Wikien
** Vandalismus',
	'globalblocking-block-edit-dropdown' => 'Spärgrënn änneren',
	'globalblocking-block-expiry' => 'Dauer:',
	'globalblocking-block-expiry-other' => 'Aner Dauer vun der Spär',
	'globalblocking-block-expiry-otherfield' => 'Aner Dauer:',
	'globalblocking-block-legend' => 'Eng IP-Adress global spären',
	'globalblocking-block-options' => 'Optiounen:',
	'globalblocking-ipaddress' => 'IP-Adress:',
	'globalblocking-ipbanononly' => 'Nëmmen anonym Benotzer spären',
	'globalblocking-block-errors' => "D'Spär huet net fonctionnéiert, aus {{PLURAL:$1|dësem Grond|dëse Grënn}}:",
	'globalblocking-block-ipinvalid' => 'Dir hutt eng ongëlteg IP-Adress ($1) aginn.
Denkt w.e.g. drun datt Dir och e Benotzernumm agi kënnt!',
	'globalblocking-block-expiryinvalid' => "D'Dauer déi dir aginn hutt ($1) ass ongëlteg.",
	'globalblocking-block-submit' => 'Dës IP-Adress global spären',
	'globalblocking-modify-submit' => 'Dës global Spär änneren',
	'globalblocking-block-success' => "D'IP-Adress $1 gouf op alle Wikimedia-Projete gespaart.",
	'globalblocking-modify-success' => "D'global Spär vun $1 gouf geännert",
	'globalblocking-block-successsub' => 'Global gespaart',
	'globalblocking-modify-successsub' => 'Déi global Spär gouf geännert',
	'globalblocking-block-alreadyblocked' => "D'IP-Adress $1 ass scho global gespaart.
Dir kënnt d'Spären op der [[Special:GlobalBlockList|Lëscht vun de globale Späre]] kucken,
oder d'Astellunge vun de Spären mat dësem Formulaire änneren.",
	'globalblocking-block-bigrange' => 'De Beräich den dir uginn hutt ($1) ass ze grouss fir ze spären. Dir kënnt maximal 65.536 Adressen (/16 Beräicher) spären',
	'globalblocking-list-intro' => 'Dëst ass eng Lëscht vun alle globale Spärendéi elo aktiv sinn.
E puer Spären sinn lokal ausgeschalt: dat heescht si si just op anere Site gëlteg, well e lokalen Administrateur entscheed huet se op dëser Wiki ze desaktivéieren.',
	'globalblocking-list' => 'Lëscht vun de global gespaarten IP-Adressen',
	'globalblocking-search-legend' => 'No enger globaler Spär sichen',
	'globalblocking-search-ip' => 'IP-Adress:',
	'globalblocking-search-submit' => 'Späre sichen',
	'globalblocking-list-ipinvalid' => "D'IP-adress no där Dir Gesicht hutt ($1) ass net korrekt.
Gitt w.e.g eng korrekt IP-Adress an.",
	'globalblocking-search-errors' => 'Beim Siche gouf, aus {{PLURAL:$1|dësem Grond|dëse Grënn}} näischt fonnt:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (vu(n) ''\$3'') huet [[Special:Contributions/\$4|\$4]] global gespaart ''(\$5)''",
	'globalblocking-list-expiry' => 'Dauer vun der Spär $1',
	'globalblocking-list-anononly' => 'nëmmen anonym Benotzer',
	'globalblocking-list-unblock' => 'Spär ophiewen',
	'globalblocking-list-whitelisted' => 'lokal ausgeschalt vum $1: $2',
	'globalblocking-list-whitelist' => 'lokale Status',
	'globalblocking-list-modify' => 'änneren',
	'globalblocking-list-noresults' => 'Déi gefroten IP-Adress ass net gespaart',
	'globalblocking-goto-block' => 'Eng IP-Adress global spären',
	'globalblocking-goto-unblock' => 'Eng global Spär ophiewen',
	'globalblocking-goto-status' => 'Lokale Status vun enger globaler Spär änneren',
	'globalblocking-return' => "Zréck op d'Lëscht vun de globale Spären",
	'globalblocking-notblocked' => 'Déi IP-Adress ($1) déi Dir aginn hutt ass net global gespaart.',
	'globalblocking-unblock' => 'Eng global Spär ophiewen',
	'globalblocking-unblock-ipinvalid' => 'Dir hutt eng ongëlteg IP-Adress ($1) aginn.
Denkt w.e.g. drun datt Dir och e Benotzernumm agi kënnt!',
	'globalblocking-unblock-legend' => 'Eng global Spär ophiewen',
	'globalblocking-unblock-submit' => 'Global Spär ophiewen',
	'globalblocking-unblock-reason' => 'Grond:',
	'globalblocking-unblock-unblocked' => "Dir hutt d'global Spär #$2 vun der IP-Adress '''$1''' opgehuewen",
	'globalblocking-unblock-errors' => "Dir kënnt d'global Spär fir déi IP-Adress net ophiewen, aus {{PLURAL:$1|dësem Grond|dëse Grënn}}:",
	'globalblocking-unblock-successsub' => 'Global Spär ass opgehuewen',
	'globalblocking-unblock-subtitle' => 'Global Spär gëtt opgehuewen',
	'globalblocking-unblock-intro' => 'Dir kënnt dëse Formulaire benotze fir eng global Spär opzehiewen.',
	'globalblocking-whitelist' => 'Lokale Statut vun e globale Spären',
	'globalblocking-whitelist-notapplied' => 'Global Späre sinn op dëser Wiki net aktivéiert,
dofir kann de lokale Status vu globale Spären net geännert ginn.',
	'globalblocking-whitelist-legend' => 'De lokale Status änneren',
	'globalblocking-whitelist-reason' => 'Grond:',
	'globalblocking-whitelist-status' => 'Lokale Status:',
	'globalblocking-whitelist-statuslabel' => 'Dës global Spär op {{SITENAME}} ophiewen',
	'globalblocking-whitelist-submit' => 'De globale Status änneren',
	'globalblocking-whitelist-whitelisted' => "Dir hutt d'global Spär #$2 vun der IP-Adress '''$1''' op {{SITENAME}} opgehiuewen.",
	'globalblocking-whitelist-dewhitelisted' => "Dir hutt d'global Spär #$2 vun der IP-Adress '''$1''' op {{SITENAME}} nees aktivéiert.",
	'globalblocking-whitelist-successsub' => 'De lokale Status gouf geännert',
	'globalblocking-whitelist-nochange' => "Dir hutt de lokale Status vun dëser Spär net geännert.
[[Special:GlobalBlockList|Zréck op d'Lëscht vun de globale Spären]].",
	'globalblocking-whitelist-errors' => 'Är Ännerung vum lokale Status vun enger globaler Spär huet aus {{PLURAL:$1|dësem Grond|dëse Grënn}} net fonctionéiert:',
	'globalblocking-whitelist-intro' => "Dir kënnt dëse Formulaire benotze fir de lokal Status vun enger globaler Spär z'änneren.
Wann eng global Spär op dëser Wiki opgehuewe gëtt, kënne Benotzer déi déi betraffen IP-Adresse benotzen normal Ännerungen maachen.
[[Special:GlobalBlockList|Zréck op d'Lëscht vun de globale Spären]].",
	'globalblocking-blocked' => "Är IP-Adress \$5 gouf op alle Wikimedia Wikie vum '''\$1''' (''\$2'') gespaart.
De Grond den ugi gouf war ''\"\$3\"''.
De Beräich ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Dir kënnt engem Benotzer säi Paswuert net zrécksetze well Dir global gespaart sidd.',
	'globalblocking-logpage' => 'Lëscht vun de globale Spären',
	'globalblocking-logpagetext' => "Dëst ass eng Lëscht vun de globale Spären déi op dëser Wiki gemaach an opgehuewe goufen.
Dir sollt wëssen datt global Spären op anere Wikie gemaach an opgehuewe kënne ginn an datt déi global Spären dës Wiki beaflosse kënnen.
Fir all aktiv global Spären ze gesinn, gitt w.e.g op d'[[Special:GlobalBlockList|Lëscht vun de globale Spären]].",
	'globalblocking-block-logentry' => '[[$1]] gouf global gespaart fir $2',
	'globalblocking-block2-logentry' => 'huet global gespaart [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'global Spär vum [[$1]] opgehuewen',
	'globalblocking-whitelist-logentry' => 'huet déi global Spär vum [[$1]] lokal ausgeschalt',
	'globalblocking-dewhitelist-logentry' => 'huet déi global Spär vun [[$1]] lokal nees aktivéiert',
	'globalblocking-modify-logentry' => 'huet déi global Spär geännert op [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'bis $1',
	'globalblocking-logentry-noexpiry' => 'keen Enn vun der Spär festgeluecht',
	'globalblocking-loglink' => "D'IP-Adress $1 ass global gespaart ([[{{#Special:GlobalBlockList}}/$1|fir all Detailer]]).",
	'globalblocking-showlog' => "Dës IP-Adress gouf virdru gespaart.
D'Lëscht vun de Späre steet hei ënnendrënner.",
	'globalblocklist' => 'Lëscht vun de global gespaarten IP-Adressen',
	'globalblock' => 'Eng IP-Adress global spären',
	'globalblockstatus' => 'Lokale Statut vu globale Spären',
	'removeglobalblock' => 'Eng global Spär ophiewen',
	'right-globalblock' => 'Benotzer global spären',
	'action-globalblock' => 'global Späre maachen',
	'right-globalunblock' => 'Global Spären ophiewen',
	'action-globalunblock' => 'global Spären ophiewen',
	'right-globalblock-whitelist' => 'Global Späre lokal ausschalten',
	'action-globalblock-whitelist' => 'global Späre lokal ausschalten',
	'right-globalblock-exempt' => 'Global Spären ëmgoen',
	'action-globalblock-exempt' => 'global Spären ëmgoen',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Benopat
 * @author Ooswesthoesbes
 * @author Pahles
 */
$messages['li'] = array(
	'globalblocking-desc' => "[[Special:GlobalBlock|Maak 't meugelijk]] IP-addresse [[Special:GlobalBlockList|in meerdere wiki's tegeliek]] te blokkere",
	'globalblocking-block' => 'Een IP-adres globaal blokkere',
	'globalblocking-modify-intro' => "Doe kins deze breef broeke-n óm g'r instèllinger ven 'ner wikiwiejer spiekering tö-n angere.",
	'globalblocking-block-intro' => "De kins deze pagina gebroeke om 'n IP-adres op alle wiki's te blokkere.",
	'globalblocking-block-reason' => 'Reeje:',
	'globalblocking-block-otherreason' => 'Angere/additionele ree:',
	'globalblocking-block-reasonotherlist' => 'Angere ree',
	'globalblocking-block-reason-dropdown' => "* Väöl veurkómmendje blokreje
** Spamme in meerder wiki's
** Misbroek van meerder wiki's
** Vandalisme",
	'globalblocking-block-edit-dropdown' => 'Bewerk lies van rejer',
	'globalblocking-block-expiry' => 'Verloup:',
	'globalblocking-block-expiry-other' => 'Anger verlouptermien',
	'globalblocking-block-expiry-otherfield' => 'Angere tied:',
	'globalblocking-block-legend' => 'Dit IP-adres globaal blokkere',
	'globalblocking-block-options' => 'Opties:',
	'globalblocking-ipaddress' => 'IP-adres:',
	'globalblocking-ipbanononly' => 'Blokkeer allein anoniem gebroekers',
	'globalblocking-block-errors' => 'De blókkaasj is neet ingesteldj om de volgendje {{PLURAL:$1|reeje|reeje}}:',
	'globalblocking-block-ipinvalid' => "'t IP-adres ($1) det se höbs opgegaeve is neet zjuus.
Lèt óp: de kins geine gebroekersnaam opgaeve!",
	'globalblocking-block-expiryinvalid' => 'De verlouppdatum/tied daese höbs opgegaeve is óngèljig ($1).',
	'globalblocking-block-submit' => 'Dit IP-adres globaal blokkere',
	'globalblocking-modify-submit' => 'Anger dees wikiwiej spiekering',
	'globalblocking-block-success' => "'t IP-adres $1 is op alle projekte geblokkeerd",
	'globalblocking-modify-success' => 'De wikipediablokkering veur $1 is veranderd',
	'globalblocking-block-successsub' => 'Globale ingesteldj',
	'globalblocking-modify-successsub' => 'De wikiwiej spiekering is angerdj',
	'globalblocking-block-alreadyblocked' => "'t IP $1 is al globaal geblok. 
De kins de bestaonde blok betrachte in de [[Special:GlobalBlockList|lies mit globaal bloks]] of instellinge van bestaonde bloks aanpasse door gegaeves oet dit formulier opnuuj op te slaon.",
	'globalblocking-block-bigrange' => 'De reeks dae se höbs opgegaeve ($1) is te groot om te blokkere. De maags ten hoogste 65.536 adresse blokkere (/16-reekse)',
	'globalblocking-list-intro' => "Dit is 'n lies mit alle globale blokkades die op 't moment actief zeen.
Sommige blokkades zeen gemarkeerd es lokaal opgeheve.
Dit betekent det ze op andere sites van toepassing zeen, mer det 'ne lokale beheerder haet beslaote det de blokkade op deze wiki neet van toepassing is.",
	'globalblocking-list' => 'Lies van globaal geblokkeerde IP-adresse',
	'globalblocking-search-legend' => "Nao 'ne globale blok zeuke",
	'globalblocking-search-ip' => 'IP-adres:',
	'globalblocking-search-submit' => 'Nao blokkaasj zeuke',
	'globalblocking-list-ipinvalid' => "Het IP-adres wo s enao zochs is onjuus ($1).
Voer 'n correct IP-adres in.",
	'globalblocking-search-errors' => "De zeukopdrach kinde {{PLURAL:$1|'t volgende probleem|de volgende probleme}}:",
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') haet [[Special:Contributions/\$4|\$4]] globaal geblokkeerd ''(\$5)''",
	'globalblocking-list-expiry' => 'verlöp $1',
	'globalblocking-list-anononly' => 'allein anonieme',
	'globalblocking-list-unblock' => 'blok opheffe',
	'globalblocking-list-whitelisted' => 'lokaal genegeerd door $1: $2',
	'globalblocking-list-whitelist' => 'lokaal status',
	'globalblocking-list-modify' => 'anger',
	'globalblocking-list-noresults' => 'De aangevraoge IP is neet geblok.',
	'globalblocking-goto-block' => 'IP-adres globaal blokkere',
	'globalblocking-goto-unblock' => 'Globaal bloks wisse',
	'globalblocking-goto-status' => "Lokaal status ven 'ne globale blokkaasj angere",
	'globalblocking-return' => 'Trök nao de lies mit globaal blokkaasj',
	'globalblocking-notblocked' => "'t Ingegaeve IP-adres ($1) is neet globaal gezatj.",
	'globalblocking-unblock' => 'Globaal blok wisse',
	'globalblocking-unblock-ipinvalid' => "'t IP-adres ($1) det se höbs ingegaeve is onzjuus.
Lèt óp: de kins geine gebroekersnaam ingaeve!",
	'globalblocking-unblock-legend' => "'ne Globale blok wisse",
	'globalblocking-unblock-submit' => 'Globale blok wisse',
	'globalblocking-unblock-reason' => 'Reeje:',
	'globalblocking-unblock-unblocked' => "De höbs 'ne globaal blok mit nummer $2 veur t IP-adres '''$1''' gewis",
	'globalblocking-unblock-errors' => 'De globaale blok is neet gewis om de volgende {{PLURAL:$1|reden|redene}}:',
	'globalblocking-unblock-successsub' => 'De globale blok is gewis',
	'globalblocking-unblock-subtitle' => 'Globale blok aan t wisse',
	'globalblocking-unblock-intro' => "De kins dit formeleer gebroeke om 'ne globaale blok op te heffe.",
	'globalblocking-whitelist' => 'Lokale status van globale bloks',
	'globalblocking-whitelist-notapplied' => 'Globaal bloks waere neet toegepas op deze wiki, dus de lokale status van globaal bloks kan neet verangerdj waere.',
	'globalblocking-whitelist-legend' => 'Lokale status angere',
	'globalblocking-whitelist-reason' => 'Reeje:',
	'globalblocking-whitelist-status' => 'Lokaal status:',
	'globalblocking-whitelist-statuslabel' => 'Dizze globale blok op {{SITENAME}} oetzitte',
	'globalblocking-whitelist-submit' => 'Lokaal status angere',
	'globalblocking-whitelist-whitelisted' => "De höbs de globale blokkaasj #$2 mit 't IP-adres '''$1''' op {{SITENAME}} eweggedoon.",
	'globalblocking-whitelist-dewhitelisted' => "De höbs de globale blokkade #$2 met t IP-adres '''$1''' op {{SITENAME}} opnuuj actief gemaat.",
	'globalblocking-whitelist-successsub' => 'De lokaal status is anges',
	'globalblocking-whitelist-nochange' => 'De höbs de lokaal status ven deze blok neet angerd.
[[Special:GlobalBlockList|Trökkere nao de lies met globale blokkades]].',
	'globalblocking-whitelist-errors' => 'De kos de lokale status van de globale blokkade neet wiezige om de volgende {{PLURAL:$1|rede|redene}}:',
	'globalblocking-whitelist-intro' => "De kins dit formulier gebroeke om de lokale status van 'n globale blokkade te wiezige.
Als een globale blokkade op deze wiki is opgeheve, kunne gebroekers vanaaf  t IP-adres geeuon bewerkinge oetvoere.
[[Special:GlobalBlockList|Trökkere nao de lies met globale blokkades]].",
	'globalblocking-blocked' => "Dien IP-adres \$5 is door '''\$1''' (''\$2'') geblokkeerd op alle wiki's.
De rede is ''\"\$3\"''.
De blokkade ''\$4''.",
	'globalblocking-blocked-nopassreset' => "Doe kins 't wachwaord neet resette ómdesse wikiwied geblok bös gewaore.",
	'globalblocking-logpage' => 'Globaal bloklogbook',
	'globalblocking-logpagetext' => "Dit logbook bevat aangemaakte en verwiejderde globale blokkades op deze wiki.
Globale blokkades kunne ouk op andere wiki's aangemaat en verwiederd worde, en invloed hebbe op deze wiki.
Alle globale blokkades stoan in de [[Special:GlobalBlockList|liest met globale blokkades]].",
	'globalblocking-block-logentry' => 'haet [[$1]] globaal gezatj mit de verlouptied es $2',
	'globalblocking-block2-logentry' => 'haet [[$1]] globaal geblok ($2)',
	'globalblocking-unblock-logentry' => 'haet de globaal bol veur [[$1]] gewösj',
	'globalblocking-whitelist-logentry' => 'haet de globaal blok van [[$1]] lokaal opgeheffe',
	'globalblocking-dewhitelist-logentry' => 'haet de globaal blok van [[$1]] lokaal opnuuj ingesteldj',
	'globalblocking-modify-logentry' => 'haet de globale blok veur [[$1]] aangepas ($2)',
	'globalblocking-logentry-expiry' => 'verlöp $1',
	'globalblocking-logentry-noexpiry' => 'geine doer gezatj',
	'globalblocking-loglink' => "'t IP-adres is globaal geblokkeerd ([[{{#Special:GlobalBlockList}}/$1|volledige details]])",
	'globalblocking-showlog' => "Dit IP-adres is eerder geblokkeerd gewaes.
't Blokkeerlogbook wört hiejonger weergaeve:",
	'globalblocklist' => 'Lies van globaal geblokkeerde IP-adresse',
	'globalblock' => "'n IP-adres globaal zitte",
	'globalblockstatus' => 'Lokaal status ven globaal bloks',
	'removeglobalblock' => 'Globaal blok wisse',
	'right-globalblock' => 'Globaal bloks instelle',
	'right-globalunblock' => 'Globaal bloks wisse',
	'right-globalblock-whitelist' => 'Globaal bloks lokaal negere',
	'right-globalblock-exempt' => 'Loup globaal bloks óm',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Garas
 * @author Homo
 * @author Matasg
 */
$messages['lt'] = array(
	'globalblocking-block' => 'Visuotinai blokuoti IP adresą',
	'globalblocking-block-reason' => 'Priežastis:',
	'globalblocking-block-otherreason' => 'Kita/papildoma priežastis:',
	'globalblocking-block-reasonotherlist' => 'Kita priežastis',
	'globalblocking-block-expiry' => 'Galiojimo pabaiga:',
	'globalblocking-block-expiry-otherfield' => 'Kitas laikas:',
	'globalblocking-block-legend' => 'Blokuoti IP adresą globaliai',
	'globalblocking-block-options' => 'Parinktys:',
	'globalblocking-block-errors' => 'Jūsų blokavimas buvo nesėkmingas, dėl šių  {{PLURAL:$1|priežasties|priežasčių}}:',
	'globalblocking-block-ipinvalid' => 'IP adresas ( $1 ) kuri įrašėte negalimas.
Atkreipkite dėmesį, kad negalima įvesti vartotojo vardo!',
	'globalblocking-block-submit' => 'Visuotinai blokuoti šį IP adresą',
	'globalblocking-modify-submit' => 'Keisti šį pasaulini blokavimą',
	'globalblocking-block-successsub' => 'Visuotinis blokavimas pavyko',
	'globalblocking-list' => 'Visuotinai blokuotų IP adresų sąrašas',
	'globalblocking-search-legend' => 'Ieškoti pasaulinio blokavimo',
	'globalblocking-search-ip' => 'IP adresas:',
	'globalblocking-search-submit' => 'Ieškoti blokavimų',
	'globalblocking-list-expiry' => 'baigia galioti $1',
	'globalblocking-list-anononly' => 'tik anonimai',
	'globalblocking-list-unblock' => 'pašalinti',
	'globalblocking-list-whitelist' => 'vietinis statusas',
	'globalblocking-list-modify' => 'pakeisti',
	'globalblocking-list-noresults' => 'Prašomas IP adresas nėra užblokuotas.',
	'globalblocking-goto-block' => 'Visuotinai blokuoti IP adresą',
	'globalblocking-goto-unblock' => 'Pašalinti pasaulini blokavimą',
	'globalblocking-return' => 'Grįžti į pasaulinių blokavimų sąrašą',
	'globalblocking-notblocked' => 'IP adresas ( $1 ), kurį įvedėte nėra globaliau užblokuotas.',
	'globalblocking-unblock' => 'Pašalinti pasaulini blokavimą',
	'globalblocking-unblock-ipinvalid' => 'IP adresas ( $1 ) kuri įrašėte negalimas.
Atkreipkite dėmesį, kad negalima įvesti vartotojo vardo!',
	'globalblocking-unblock-legend' => 'Pašalinti pasaulini blokavimą',
	'globalblocking-unblock-submit' => 'Pašalinti pasaulini blokavimą',
	'globalblocking-unblock-reason' => 'Priežastis:',
	'globalblocking-unblock-unblocked' => "Jūs sėkmingai pašalinote pasaulini blokavimą # $2  IP adresui '''$1'''",
	'globalblocking-unblock-errors' => 'Jūsų šalinimas pasaulinio blokavimo buvo nesėkmingas dėl sekančių {{PLURAL:$1|priežasties|priežasčių}}',
	'globalblocking-unblock-successsub' => 'Pasaulinis blokavimas sėkmingai pašalintas',
	'globalblocking-unblock-subtitle' => 'Šalinamas pasaulinis blokavimas',
	'globalblocking-unblock-intro' => 'Šią formą galite naudoti norėdami pašalinti pasaulini blokavimą.',
	'globalblocking-whitelist-reason' => 'Priežastis:',
	'globalblocking-whitelist-status' => 'Vietos statusas:',
	'globalblocking-whitelist-submit' => 'Pakeisti vietos statusą',
	'globalblocking-blocked' => "Jūsų IP adresas visuose projektuose užblokavo '''\$1''' (''\$2'').
Nurodyta priežastis ''\"\$3\"''.
Užblokavimas ''\$4''.",
	'globalblocking-logpage' => 'Visuotinio blokavimo sąrašas',
	'globalblocking-logentry-expiry' => 'baigia galioti $1',
	'globalblocking-logentry-noexpiry' => 'galiojimas nenurodytas',
	'globalblocklist' => 'Visuotinai blokuotų IP adresų sąrašas',
	'globalblock' => 'Visuotinai blokuoti IP adresą',
	'removeglobalblock' => 'Pašalinti pasaulini blokavimą',
);

/** Latvian (Latviešu)
 * @author Geimeris
 * @author GreenZeb
 * @author Papuass
 */
$messages['lv'] = array(
	'globalblocking-block' => 'Globāli bloķēt IP adresi',
	'globalblocking-block-reason' => 'Iemesls:',
	'globalblocking-block-otherreason' => 'Cits/papildu iemesls:',
	'globalblocking-block-reasonotherlist' => 'Cits iemesls',
	'globalblocking-block-reason-dropdown' => '* Biezākie bloķēšanas iemesli
** Spamošana vairākos viki
** Noteikumu neievērošana vairākos viki
** Vandālisms',
	'globalblocking-block-expiry-otherfield' => 'Cits laiks:',
	'globalblocking-block-legend' => 'Bloķēt IP adresi globāli',
	'globalblocking-ipaddress' => 'IP adrese:',
	'globalblocking-ipbanononly' => 'Bloķēt tikai anonīmos lietotājus',
	'globalblocking-list' => 'Globāli bloķēto IP adrešu saraksts',
	'globalblocking-search-ip' => 'IP adrese:',
	'globalblocking-list-ipinvalid' => 'IP adrese, ko tu ievadīji ($1), ir nederīga.
Lūdzu, ievadiet derīgu IP adresi.',
	'globalblocking-list-whitelist' => 'lokālais statuss',
	'globalblocking-unblock-reason' => 'Iemesls:',
	'globalblocking-whitelist-reason' => 'Iemesls:',
	'globalblocking-whitelist-status' => 'Lokālais statuss:',
	'globalblocking-whitelist-submit' => 'Mainīt lokālo statusu',
	'globalblocklist' => 'Globāli bloķēto IP adrešu saraksts',
	'right-globalblock' => 'Veikt lietotāju globālu bloķēšanu',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'globalblocking-logpage' => 'Tatitr’asa momban’ny sakana ankapobe',
	'globalblocking-logpagetext' => "Ity ny laogy momban'ny sakana ankapobe natao ary nesorina tamin'ity wiki ity.
Tokony fantarina eny amin'ny wiki hafa mahazo esorina ny sakana ankapobe, ary mety mikasika an'ity wiki ity ny sakana ankapobe.
Raha te-hijery ny sakana ankapobe miasa, azonao jerena ny [[Special:GlobalBlockList|lisitry ny sakana ankapobe]].",
	'globalblocking-block-logentry' => "nanao sakana ankapobe tamin'i [[$1]] ary ny daty itsaharany dia $2",
	'globalblocking-block2-logentry' => "nanao sakana ankapobe tamin'i [[$1]] ($2)",
	'globalblocking-unblock-logentry' => "nanala ny sakana ankapobe an'i [[$1]]",
	'globalblocking-whitelist-logentry' => "nanala ny sakana ankapoben'i [[$1]] teto an-toerana",
	'globalblocking-dewhitelist-logentry' => "namerina ny sakana ankapoben'i [[$1]] teto an-toerana",
	'globalblocking-modify-logentry' => "nanova ny sakana ankapoben'i [[$1]] ($2)",
	'globalblocking-logentry-expiry' => "mitsahatra amin'ny $1",
	'globalblocking-logentry-noexpiry' => 'tsy nametraka daty itsaharana',
	'globalblocking-loglink' => "Voasakana amin'ny ankapobeny ny adiresy IP $1 ([[{{#Special:GlobalBlockList}}/$1|hijery ny antsipirihany]]).",
	'globalblocking-showlog' => 'Efa voasakana ity adiresy IP ity taloha.
Eo ambany ny laogim-panakanana.',
	'globalblocklist' => "Lisitry ny adiresy IP voasakana amin'ny ankapobe",
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'globalblocking-unblock-reason' => 'Амал:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Овозможува]] блокирање на IP-адреси [[Special:GlobalBlockList|на повеќе викија]]',
	'globalblocking-block' => 'Глобално блокирање на IP-адреса',
	'globalblocking-modify-intro' => 'Користете го овој образец за менување на нагодувањата за еден глобален блок.',
	'globalblocking-block-intro' => 'Оваа страница служи за блокирање на IP-адреса на сите викија.',
	'globalblocking-block-reason' => 'Причина:',
	'globalblocking-block-otherreason' => 'Друга/дополнителна причина:',
	'globalblocking-block-reasonotherlist' => 'Друга причина',
	'globalblocking-block-reason-dropdown' => '* Чести причини за блокирање
** Спамирање низ повеќе викија
** Злоупотреби низ повеќе викија
** Вандализам',
	'globalblocking-block-edit-dropdown' => 'Уреди причини за блокирање',
	'globalblocking-block-expiry' => 'Истекува:',
	'globalblocking-block-expiry-other' => 'Друг рок на блокирање',
	'globalblocking-block-expiry-otherfield' => 'Друго време:',
	'globalblocking-block-legend' => 'Глобално блокирање на IP-адреса',
	'globalblocking-block-options' => 'Нагодувања:',
	'globalblocking-ipaddress' => 'IP-адреса:',
	'globalblocking-ipbanononly' => 'Блокирај само анонимни корисници',
	'globalblocking-block-errors' => 'Вашето блокирање беше неуспешно, од {{PLURAL:$1|следнава причина|следниве причини}}:',
	'globalblocking-block-ipinvalid' => 'IP-адресата ($1) која ја внесовте не е важечка.
Напомена: не може да се внесува корисничко име!',
	'globalblocking-block-expiryinvalid' => 'Рокот на истекување кој го внесовте ($1) не е важечки.',
	'globalblocking-block-submit' => 'Глобално блокирање на оваа IP-адреса',
	'globalblocking-modify-submit' => 'Измени го овој глобален блок',
	'globalblocking-block-success' => 'IP-адресата $1 е успешно блокирана на сите проекти.',
	'globalblocking-modify-success' => 'Глобалниот блок на $1 е успешно изменет.',
	'globalblocking-block-successsub' => 'Глобалното блокирање е успешно',
	'globalblocking-modify-successsub' => 'Глобалниот блок е успешно изменет.',
	'globalblocking-block-alreadyblocked' => 'IP-адресата $1 е веќе глобално блокирана.
Можете да го погледате постоечкиот блок на [[Special:GlobalBlockList|списокот на глобални блокови]],
или пак да ги измените нагодувањата на постоечкиот блок со тоа што ќе го повторно ќе го поднесете овој образец.',
	'globalblocking-block-bigrange' => 'Назначениот опсег ($1) е преголем за блокирање.
Можете да блокирате највеќе до 65 536 адреси (/16 регистри)',
	'globalblocking-list-intro' => 'Ова е список на сите моментални глобални блокови во дејство.
Некои блокови се означени како локално оневозможени: ова значи дека тие важат за други страници, но локалниот администратор решил да ги оневозможи на ова вики.',
	'globalblocking-list' => 'Список на глобално блокирани IP-адреси',
	'globalblocking-search-legend' => 'Пребарај глобален блок',
	'globalblocking-search-ip' => 'IP-адреса:',
	'globalblocking-search-submit' => 'Пребарај блокирања',
	'globalblocking-list-ipinvalid' => 'IP-адресата која ја барате ($1) е неважечка.
Внесете важечка IP-адреса.',
	'globalblocking-search-errors' => 'Вашето пребарување беше неуспешно, од {{PLURAL:$1|следнава причина|следниве причини}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') глобално го блокираше корисникот [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'истекува $1',
	'globalblocking-list-anononly' => 'само анонимни',
	'globalblocking-list-unblock' => 'отстрани',
	'globalblocking-list-whitelisted' => 'локално оневозможено од $1: $2',
	'globalblocking-list-whitelist' => 'локален статус',
	'globalblocking-list-modify' => 'измени',
	'globalblocking-list-noresults' => 'Бараната IP-адреса не е блокирана.',
	'globalblocking-goto-block' => 'Блокирај IP-адреса глобално',
	'globalblocking-goto-unblock' => 'Отстрани глобален блок',
	'globalblocking-goto-status' => 'Промена на локален статус на глобален блок',
	'globalblocking-return' => 'Назад кон списокот на глобални блокови',
	'globalblocking-notblocked' => 'IP-адресата ($1) која ја внесовте не е глобално блокирана.',
	'globalblocking-unblock' => 'Отстрани глобален блок',
	'globalblocking-unblock-ipinvalid' => 'IP-адресата ($1) која ја внесовте е неважечка.
Имајте предвид дека не можете да внесувате кориснички имиња!',
	'globalblocking-unblock-legend' => 'Отстрани глобален блок',
	'globalblocking-unblock-submit' => 'Отстрани го глобалниот блок',
	'globalblocking-unblock-reason' => 'Причина:',
	'globalblocking-unblock-unblocked' => "Успешно го отстранивте глобалниот блок #$2 на IP-адресата '''$1'''",
	'globalblocking-unblock-errors' => 'Вашиот обид за отстранување на глобалниот блок е неуспешен, од {{PLURAL:$1|следнава причина|следниве причини}}:',
	'globalblocking-unblock-successsub' => 'Глобалниот блок е успеешно отстранет',
	'globalblocking-unblock-subtitle' => 'Отстранување на глобален блок',
	'globalblocking-unblock-intro' => 'Овој образец служи за отстранување на глобални блокови.',
	'globalblocking-whitelist' => 'Локален статус на глобални блокирања',
	'globalblocking-whitelist-notapplied' => 'На ова вики не се применуваат глобални блокиви,
па затоа локалниот статус на глобалните блокови не може да се менува..',
	'globalblocking-whitelist-legend' => 'Промена на локален статус',
	'globalblocking-whitelist-reason' => 'Причина:',
	'globalblocking-whitelist-status' => 'Локален статус:',
	'globalblocking-whitelist-statuslabel' => 'Оневозможи го овој глобален блок на {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Промени локален статус',
	'globalblocking-whitelist-whitelisted' => "Успешно го оневозможивте глобалниот блок #$2 на IP-адресата '''$1''' на {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Успешно го реактивиравте глобалниот блок #$2 на IP-адресата '''$1''' на {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Локалниот статус е успешно променет',
	'globalblocking-whitelist-nochange' => 'Немате направено промени во локалниот статус на овој блок.
[[Special:GlobalBlockList|Назад кон списокот на глобални блокови]].',
	'globalblocking-whitelist-errors' => 'Вашиот обид за измена на локалниот статус на глобален блок е неуспешен, од {{PLURAL:$1|следнава причина|следниве причини}}:',
	'globalblocking-whitelist-intro' => 'Со овој образец можете да го менувате локалниот статус на некој глобален блок.
Ако глобалниот блок е оневозможен на ова вики, корисниците на таа IP-адреса ќе можат да уредуваат нормално.
[[Special:GlobalBlockList|Назад кон списокот на глобални блокови]].',
	'globalblocking-blocked' => "Вашата IP-адреса $5 е блокирана на сите викија од '''$1''' (''$2'').
Наведената причина гласи: „''$3''“.
Блокот ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Не можете да ја смените лозинката на корисникот бидејќи сте блокирани глобално.',
	'globalblocking-logpage' => 'Дневник на глобални блокирања',
	'globalblocking-logpagetext' => 'Ова е дневник на глобалните блокови зададени и отстранети на ова вики.
Треба да се напомене дека глобални блокови можат да се задаваат и отстрануваат и на други викија, и дека тие глобални блокови може да се одразат на ова вики.
За преглед на сите активни глобални блокови, можете да ја погледате [[Special:GlobalBlockList|списокот на глобални блокови]].',
	'globalblocking-block-logentry' => 'глобално го блокираше корисникот [[$1]] со рок на истекување од $2',
	'globalblocking-block2-logentry' => 'глобално го блокираше корисникот [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'го отстрани глобалниот блок на [[$1]]',
	'globalblocking-whitelist-logentry' => 'локално го оневозможи глобалниот блок на [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'локално повторно го овозможи глобалниот блок на [[$1]]',
	'globalblocking-modify-logentry' => 'го измени глобалниот блок на [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'истекува $1',
	'globalblocking-logentry-noexpiry' => 'нема поставен рок на истекување',
	'globalblocking-loglink' => 'IP-адресата $1 е блокирана глобално ([[{{#Special:GlobalBlockList}}/$1|повеќе информации]]).',
	'globalblocking-showlog' => 'Оваа IP-адреса била претходно блокирана.
Подолу е даден дневникот на блокирања за ваша консултација:',
	'globalblocklist' => 'Список на глобално блокирани IP-адреси',
	'globalblock' => 'Глобално блокирање на IP-адреса',
	'globalblockstatus' => 'Локален статус на глобални блокови',
	'removeglobalblock' => 'Отстранување на глобален блок',
	'right-globalblock' => 'Вршење на глобални блокирања',
	'action-globalblock' => 'вршење на глобални блокирања',
	'right-globalunblock' => 'Отстранување на глобални блокирања',
	'action-globalunblock' => 'отстранување на глобални блокирања',
	'right-globalblock-whitelist' => 'Локално оневозможување на глобални блокови',
	'action-globalblock-whitelist' => 'локално оневозможување на глобални блокови',
	'right-globalblock-exempt' => 'Заобиколување глобални блокови',
	'action-globalblock-exempt' => 'заобиколување на глобални блокови',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'globalblocking-desc' => 'ഐ.പി. വിലാസങ്ങളെ [[Special:GlobalBlockList|വിവിധ വിക്കികളിൽ തടയാൻ]] [[Special:GlobalBlock|അനുവദിക്കുന്നു]]',
	'globalblocking-block' => 'ഒരു ഐ.പി. വിലാസത്തെ ആഗോളമായി തടയുക',
	'globalblocking-modify-intro' => 'ആഗോള തടയലിന്റെ ക്രമീകണങ്ങൾ മാറ്റാൻ ഈ ഫോം താങ്കൾക്ക് ഉപയോഗിക്കാവുന്നതാണ്.',
	'globalblocking-block-intro' => 'ഈ താൾ ഉപയോഗിച്ച് ഒരു ഐ.പി. വിലാസത്തെ എല്ലാ വിക്കികളിലും തടയാൻ താങ്കൾക്ക് സാധിക്കും.',
	'globalblocking-block-reason' => 'കാരണം:',
	'globalblocking-block-otherreason' => 'മറ്റ്/കൂടുതൽ കാരണം:',
	'globalblocking-block-reasonotherlist' => 'മറ്റ് കാരണം',
	'globalblocking-block-reason-dropdown' => '*തടയാനുള്ള സാധാരണ കാരണങ്ങൾ
**ബഹുവിക്കി സ്പാമിങ്
**ബഹുവിക്കി ദുരുപയോഗം
**നശീകരണപ്രവർത്തനം',
	'globalblocking-block-edit-dropdown' => 'തടയാനുള്ള കാരണങ്ങൾ തിരുത്തുക',
	'globalblocking-block-expiry' => 'കാലാവധി:',
	'globalblocking-block-expiry-other' => 'മറ്റ് കാലാവധി',
	'globalblocking-block-expiry-otherfield' => 'മറ്റ് കാലാവധി:',
	'globalblocking-block-legend' => 'ഒരു ഐ.പി. വിലാസത്തെ ആഗോളമായി തടയുക',
	'globalblocking-block-options' => 'ഐച്ഛികങ്ങൾ:',
	'globalblocking-ipaddress' => 'ഐ.പി. വിലാസം:',
	'globalblocking-ipbanononly' => 'അജ്ഞാത ഉപയോക്താക്കളെ മാത്രം തടയുക',
	'globalblocking-block-errors' => 'താഴെ പറയുന്ന {{PLURAL:$1|കാരണത്താൽ|കാരണങ്ങളാൽ}} തടയൽ പരാജയപ്പെട്ടു:',
	'globalblocking-block-ipinvalid' => 'താങ്കൾ കൊടുത്ത ഐ.പി. വിലാസം ($1) അസാധുവാണ്‌. 
താങ്കൾക്കു ഇവിടെ ഒരു ഉപയോക്തൃനാമം കൊടുക്കുവാൻ പറ്റില്ല എന്നതു പ്രത്യേകം ശ്രദ്ധിക്കുക.',
	'globalblocking-block-expiryinvalid' => 'താങ്കൾ കൊടുത്ത കാലാവധി ($1) അസാധുവാണ്‌.',
	'globalblocking-block-submit' => 'ഈ ഐ.പി.വിലാസത്തെ ആഗോളമായി തടയുക',
	'globalblocking-modify-submit' => 'ഈ ആഗോള തടയലിൽ മാറ്റം വരുത്തുക',
	'globalblocking-block-success' => 'എല്ലാ പദ്ധതികളിൽ നിന്നും $1 എന്ന ഐ.പി. വിലാസത്തെ വിജയകരമായി തടഞ്ഞിരിക്കുന്നു.',
	'globalblocking-modify-success' => '$1 മേൽ ഉണ്ടായിരുന്ന ആഗോള തടയലിൽ വിജയകരമായി മാറ്റം വരുത്തിയിരിക്കുന്നു',
	'globalblocking-block-successsub' => 'ആഗോള തടയൽ വിജയകരം',
	'globalblocking-modify-successsub' => 'ആഗോള തടയലിൽ വിജയകരമായി മാറ്റം വരുത്തിയിരിക്കുന്നു',
	'globalblocking-block-alreadyblocked' => '$1 എന്ന ഐ.പി. വിലാസം ആഗോളമായി തടയപ്പെട്ടിരിക്കുന്ന ഒന്നാണ്.
താങ്കൾക്ക് നിലവിലുള്ള തടയലുകൾ [[Special:GlobalBlockList|ആഗോള തടയലുകളുടെ പട്ടികയിൽ]] കാണാവുന്നതാണ്,
അല്ലെങ്കിൽ ഈ ഫോം പുനർസമർപ്പിച്ച് ക്രമീകരണങ്ങളിൽ മാറ്റം വരുത്താവുന്നതാണ്.',
	'globalblocking-block-bigrange' => 'താങ്കൾ നിർദ്ദേശിച്ച പരിധി  ($1) തടയാൻ സാധിക്കാത്തയത്ര വലുതാണ്.
താങ്കൾക്ക് പരമാവധി 65,536 വിലാസങ്ങൾ (/16 പരിധികൾ) തടയാവുന്നതാണ്.',
	'globalblocking-list-intro' => 'ഇപ്പോൾ പ്രാവർത്തികമായിട്ടുള്ള ആഗോള തടയലുകളുടെ പട്ടികയാണിത്.
ചില തടയലുകൾ പ്രാദേശികമായി അനുഭവത്തിലില്ല എന്ന് അടയാളപ്പെടുത്തിയിട്ടുണ്ടാകും; അതിനർത്ഥം അവ മറ്റ് സൈറ്റുകളിൽ അനുഭവത്തിലുണ്ടാവാമെങ്കിലും, ഈ വിക്കിയിലെ ഒരു കാര്യനിർവാഹകൻ അത് നടപ്പിലാക്കണ്ട എന്ന് ഇവിടെ തീരുമാനിച്ചിട്ടുണ്ടെന്നാണ്.',
	'globalblocking-list' => 'ആഗോളമായി തടയപ്പെട്ട ഐ.പി. വിലാസങ്ങൾ',
	'globalblocking-search-legend' => 'ആഗോള തടയലിന്റെ വിവരത്തിനായി തിരയുക',
	'globalblocking-search-ip' => 'ഐ.പി. വിലാസം:',
	'globalblocking-search-submit' => 'തടയലിന്റെ വിവരങ്ങൾ തിരയുക',
	'globalblocking-list-ipinvalid' => 'താങ്കൾ തിരഞ്ഞ ഐ.പി. വിലാസം ($1) സാധുവല്ല.
ദയവായി സാധുവായ ഐ.പി. വിലാസം നൽകുക.',
	'globalblocking-search-errors' => 'താഴെ പറയുന്ന {{PLURAL:$1|കാരണത്താൽ|കാരണങ്ങളാൽ}} തിരച്ചിൽ വിജയകരമല്ലായിരുന്നു:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') [[Special:Contributions/\$4|\$4]] എന്ന ഉപയോക്താവിനെ ആഗോളമായി തടഞ്ഞിരിക്കുന്നു ''(\$5)''",
	'globalblocking-list-expiry' => 'കാലാവധി $1',
	'globalblocking-list-anononly' => 'അജ്ഞാത ഉപയോക്താക്കളെ മാത്രം',
	'globalblocking-list-unblock' => 'സ്വതന്ത്രമാക്കുക',
	'globalblocking-list-whitelisted' => '$1 ഇതിനെ പ്രാദേശികമായി നിർവീര്യമാക്കിയിക്കുന്നു: $2',
	'globalblocking-list-whitelist' => 'പ്രാദേശിക സ്ഥിതി',
	'globalblocking-list-modify' => 'പുനർനിശ്ചയിക്കുക',
	'globalblocking-list-noresults' => 'ആവശ്യപ്പെട്ട ഐ.പി. വിലാസത്തെ തടഞ്ഞിട്ടില്ല.',
	'globalblocking-goto-block' => 'ഐ.പി. വിലാസത്തെ ആഗോളം തടയുക',
	'globalblocking-goto-unblock' => 'ആഗോള തടയൽ നീക്കുക',
	'globalblocking-goto-status' => 'ആഗോള തടയലിന്റെ പ്രാദേശിക സ്ഥിതി മാറ്റുക',
	'globalblocking-return' => 'ആഗോള തടയലുകളുടെ പട്ടികയിലേയ്ക്ക് തിരിച്ചു പോവുക',
	'globalblocking-notblocked' => 'താങ്കൾ നൽകിയ ഐ.പി. വിലാസം ($1) ആഗോളം തടയപ്പെട്ടിട്ടില്ല.',
	'globalblocking-unblock' => 'ആഗോള തടയൽ നീക്കുക',
	'globalblocking-unblock-ipinvalid' => 'താങ്കൾ കൊടുത്ത ഐ.പി. വിലാസം ($1) അസാധുവാണ്‌. 
താങ്കൾക്കു ഇവിടെ ഒരു ഉപയോക്തൃനാമം കൊടുക്കുവാൻ പറ്റില്ല എന്നതു പ്രത്യേകം ശ്രദ്ധിക്കുക.',
	'globalblocking-unblock-legend' => 'ആഗോള തടയൽ മാറ്റുക',
	'globalblocking-unblock-submit' => 'ആഗോള തടയൽ മാറ്റുക',
	'globalblocking-unblock-reason' => 'കാരണം:',
	'globalblocking-unblock-unblocked' => "'''$1''' എന്ന ഐ.പി. വിലാസത്തിന്മേലുള്ള #$2 എന്ന ആഗോള തടയൽ താങ്കൾ വിജയകരമായി ഒഴിവാക്കിയിരിക്കുന്നു",
	'globalblocking-unblock-errors' => 'ഈ ഐ.പി. വിലാസത്തിന്മേലുള്ള ആഗോള തടയൽ ഒഴിവാക്കാൻ താങ്കൾക്ക് പറ്റില്ല, അതിന്റെ {{PLURAL:$1|കാരണം|കാരണങ്ങൾ}}: $1',
	'globalblocking-unblock-successsub' => 'ആഗോള തടയൽ വിജയകരമായി നീക്കിയിരിക്കുന്നു',
	'globalblocking-unblock-subtitle' => 'ആഗോള തടയൽ നീക്കംചെയ്യുന്നു',
	'globalblocking-unblock-intro' => 'ആഗോള തടയൽ ഒഴിവാക്കാനായി താങ്കൾക്ക് ഈ ഫോം ഉപയോഗിക്കാവുന്നതാണ്.',
	'globalblocking-whitelist' => 'ആഗോള തടയലുകളുടെ പ്രാദേശിക സ്ഥിതി',
	'globalblocking-whitelist-notapplied' => 'ഈ വിക്കിയിൽ ആഗോള തടയലുകൾ പ്രാവർത്തികമാക്കിയിട്ടില്ല,
അതുകൊണ്ട് ആഗോള തടയലുകളുടെ പ്രാദേശിക സ്ഥിതിയിൽ മാറ്റം വരുത്തിയിട്ടില്ല.',
	'globalblocking-whitelist-legend' => 'പ്രാദേശിക സ്ഥിതി മാറ്റുക',
	'globalblocking-whitelist-reason' => 'കാരണം:',
	'globalblocking-whitelist-status' => 'പ്രാദേശിക സ്ഥിതി:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} സം‌രംഭത്തിൽ ഈ ആഗോള തടയൽ ഒഴിവാക്കുക',
	'globalblocking-whitelist-submit' => 'പ്രാദേശിക സ്ഥിതി മാറ്റുക',
	'globalblocking-whitelist-whitelisted' => "'''$1''' എന്ന ഐ.പി. വിലാസത്തിന്റെ #$2 എന്ന ആഗോളതടയൽ {{SITENAME}} സം‌രംഭത്തിൽ വിജയകരമായി പ്രവർത്തനരഹിതമാക്കിയിരിക്കുന്നു",
	'globalblocking-whitelist-dewhitelisted' => "'''$1''' എന്ന ഐ.പി. വിലാസത്തിന്റെ #$2 എന്ന ആഗോളതടയൽ {{SITENAME}} സം‌രംഭത്തിൽ വിജയകരമായി പ്രവർത്തനയോഗ്യമാക്കിയിരിക്കുന്നു.",
	'globalblocking-whitelist-successsub' => 'പ്രാദേശിക സ്ഥിതി വിജയകരമായി മാറ്റിയിരിക്കുന്നു',
	'globalblocking-whitelist-nochange' => 'ഈ തടയലിന്റെ പ്രാദേശിക സ്ഥിതിയിൽ താങ്കൾ മാറ്റമൊന്നും വരുത്തിയില്ല.
[[Special:GlobalBlockList|ആഗോള തടയൽ പട്ടികയിലേയ്ക്ക് തിരിച്ചു പോവുക]]',
	'globalblocking-whitelist-errors' => 'ആഗോള തടയലിന്റെ പ്രാദേശിക സ്ഥിതിയിൽ താങ്കൾ വരുത്തിയ മാറ്റം ഇനി കൊടുത്തിരിക്കുന്ന {{PLURAL:$1|കാരണത്താൽ|കാരണങ്ങളാൽ}} വിജയകരമായില്ല:',
	'globalblocking-whitelist-intro' => 'ആഗോള തടയലിന്റെ പ്രാദേശിക സ്ഥിതിയിൽ തിരുത്തലുകൾ വരുത്താൻ താങ്കൾക്ക് ഈ ഫോം ഉപയോഗിക്കാവുന്നതാണ്.
ഒരു ആഗോള തടയൽ ഈ വിക്കിയിൽ നിർജീവമാക്കപ്പെട്ടിട്ടുണ്ടെങ്കിൽ, പ്രസ്തുത ഐ.പി. വിലാസത്തിലെ ഉപയോക്താക്കൾക്ക് സാധാരണപോലെ തിരുത്താൻ കഴിയുന്നതാണ്.
[[Special:GlobalBlockList|ആഗോള തടയലുകളുടെ പട്ടികയിലേയ്ക്ക് തിരിച്ചുപോവുക]]',
	'globalblocking-blocked' => "താങ്കളുടെ ഐ.പി. വിലാസം \$5 എല്ലാ വിക്കിമീഡിയ സം‌രംഭങ്ങളിലും '''\$1''' (''\$2'') തടഞ്ഞിരിക്കുന്നു. അതിനു സൂചിപ്പിച്ച കാരണം ''\"\$3\"'' ആണ്‌. തടയലിന്റെ ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'താങ്കൾ ആഗോളമായി തടയപ്പെട്ടിരിക്കുന്നതിനാൽ രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കാൻ കഴിയില്ല.',
	'globalblocking-logpage' => 'ആഗോള തടയലിന്റെ പ്രവർത്തനരേഖ',
	'globalblocking-logpagetext' => 'ഈ വിക്കിയിൽ നിന്ന് സൃഷ്ടിക്കുകയോ നീക്കംചെയ്യുകയോ ചെയ്ത ആഗോള തടയലുകളുടെ രേഖയാണിത്.
മറ്റ് വിക്കികളിൽ നിന്ന് ആഗോള തടയലുകൾ സൃഷ്ടിക്കാൻ കഴിയുമെന്നും, അവ ഇവിടെ പ്രാബല്യത്തിലുണ്ടാകുമെന്നും ഓർക്കുക.
പ്രാബല്യത്തിലുള്ള എല്ലാ ആഗോള തടയലുകളും [[Special:GlobalBlockList|ആഗോള തടയൽ പട്ടികയിൽ]] താങ്കൾക്ക് കാണാവുന്നതാണ്.',
	'globalblocking-block-logentry' => '$2 കാലയളവിലേക്ക് [[$1]] എന്ന അംഗത്വത്തെ ആഗോളമായി തടഞ്ഞിരിക്കുന്നു.',
	'globalblocking-block2-logentry' => '[[$1]] ആഗോളമായി തടയപ്പെട്ടിരിക്കുന്നു ($2)',
	'globalblocking-unblock-logentry' => '[[$1]]നു മേലുള്ള ആഗോള തടയൽ ഒഴിവാക്കിയിരിക്കുന്നു',
	'globalblocking-whitelist-logentry' => '[[$1]] നു മേലുള്ള ആഗോള തടയൽ പ്രാദേശികമായി ഒഴിവാക്കിയിരിക്കുന്നു',
	'globalblocking-dewhitelist-logentry' => 'ആഗോള തടയൽ [[$1]] പ്രാദേശികമായി പുനഃസ്ഥാപിച്ചിരിക്കുന്നു',
	'globalblocking-modify-logentry' => '[[$1]] മേൽ ഉള്ള ആഗോള തടയലിൽ മാറ്റം വരുത്തിയിരിക്കുന്നു ($2)',
	'globalblocking-logentry-expiry' => '$1-നു അവസാനിക്കുന്നു',
	'globalblocking-logentry-noexpiry' => 'അവസാനിക്കൽ ക്രമീകരിച്ചിട്ടില്ല',
	'globalblocking-loglink' => 'ഐ.പി. വിലാസം $1 ആഗോളമായി തടയപ്പെട്ടിരിക്കുന്നു ([[{{#Special:GlobalBlockList}}/$1|പൂർണ്ണ വിവരങ്ങൾ]]).',
	'globalblocking-showlog' => 'ഈ ഐ.പി. വിലാസം മുമ്പേ തടയപ്പെട്ടിട്ടുള്ളതാണ്.
അവലംബമായി തടയൽ രേഖ താഴെ കൊടുക്കുന്നു:',
	'globalblocklist' => 'ആഗോളമായി തടയപ്പെട്ട ഐ.പി. വിലാസങ്ങളുടെ പട്ടിക',
	'globalblock' => 'ഒരു ഐ.പി. വിലാസത്തെ ആഗോളമായി തടയുക',
	'globalblockstatus' => 'ആഗോള തടയലുകളുടെ പ്രാദേശിക സ്ഥിതി',
	'removeglobalblock' => 'ആഗോള തടയൽ നീക്കുക',
	'right-globalblock' => 'ആഗോള തടയൽ നടത്തുക',
	'right-globalunblock' => 'ആഗോള തടയൽ മാറ്റുക',
	'right-globalblock-whitelist' => 'ആഗോള തടയലിനെ പ്രാദേശികമായി നിർവീര്യമാക്കുക',
	'right-globalblock-exempt' => 'ആഗോള തടയലുകളെ പാർശ്വവത്കരിച്ചു ഗമിക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'globalblocking-block-reason' => 'Шалтгаан:',
	'globalblocking-block-otherreason' => 'Өөр/нэмэлт шалтгаан:',
	'globalblocking-block-reasonotherlist' => 'Өөр шалтгаан',
	'globalblocking-block-expiry-otherfield' => 'Өөр хугацаа:',
	'globalblocking-unblock-reason' => 'Шалтгаан:',
	'globalblocking-whitelist-reason' => 'Шалтгаан:',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaajawa
 * @author Kaustubh
 * @author Mahitgar
 * @author Rahuldeshmukh101
 * @author V.narsikar
 */
$messages['mr'] = array(
	'globalblocking-desc' => 'आइपी अंकपत्त्याला [[Special:GlobalBlockList|अनेक विकिंवर ब्लॉक]] करण्याची [[Special:GlobalBlock|परवानगी]] देतो.',
	'globalblocking-block' => 'आयपी अंकपत्ता वैश्विक पातळीवर ब्लॉक करा',
	'globalblocking-modify-intro' => 'वैश्विक रोध बदलविण्यासाठी आपण या आवेदनपत्राचा वापर करू शकता.',
	'globalblocking-block-intro' => 'तुम्ही हे पान वापरून एखाद्या आयपी अंकपत्त्याला सर्व विकिंवर ब्लॉक करू शकता.',
	'globalblocking-block-reason' => 'कारण:',
	'globalblocking-block-otherreason' => 'इतर / अतिरिक्त कारण:',
	'globalblocking-block-reasonotherlist' => 'इतर कारणे',
	'globalblocking-block-reason-dropdown' => '* सामान्य प्रतिबंधन कारणे
** आंतरविकि उत्पात
** आंतरविकि अनिष्ट आचरण 
**आंतरविकि व्यक्तिगत आरोप 
** आंतरविकि शिवीगाळ
** उपद्रव',
	'globalblocking-block-edit-dropdown' => 'प्रतिबंधाची कारणे संपादित करा',
	'globalblocking-block-expiry' => 'समाप्ती:',
	'globalblocking-block-expiry-other' => 'इतर समाप्ती वेळ',
	'globalblocking-block-expiry-otherfield' => 'इतर वेळ:',
	'globalblocking-block-legend' => 'ह्या आयपी अंकपत्त्याला वैश्विक पातळीवर ब्लॉक करा',
	'globalblocking-block-options' => 'विकल्प:',
	'globalblocking-ipaddress' => 'अंकपत्ता',
	'globalblocking-ipbanononly' => 'केवळ अनामिक सदस्यांना प्रतिबंधीत करा',
	'globalblocking-block-errors' => 'ब्लॉक अयशस्वी झालेला आहे, {{PLURAL:$1|कारण|कारण}}:',
	'globalblocking-block-ipinvalid' => 'तुम्ही दिलेला आयपी अंकपत्ता ($1) अयोग्य आहे.
कृपया नोंद घ्या की तुम्ही सदस्य नाव देऊ शकत नाही!',
	'globalblocking-block-expiryinvalid' => 'तुम्ही दिलेली समाप्तीची वेळ ($1) अयोग्य आहे.',
	'globalblocking-block-submit' => 'ह्या आयपी अंकपत्त्याला वैश्विक पातळीवर ब्लॉक करा',
	'globalblocking-modify-submit' => 'हा वैश्विक रोध बदलवा',
	'globalblocking-block-success' => '$1 या आयपी अंकपत्त्याला सर्व विकिंवर यशस्वीरित्या अवरोधित करण्यात आलेले आहे.',
	'globalblocking-modify-success' => '$1  वर असलेला वैश्विक रोध यशस्वीरित्या अनुरूप करण्यात आलेला आहे.',
	'globalblocking-block-successsub' => 'वैश्विक ब्लॉक यशस्वी',
	'globalblocking-modify-successsub' => 'वैश्विक रोध यशस्वीरित्या अनुरूपित.',
	'globalblocking-block-alreadyblocked' => '$1 हा आयपी अंकपत्ता अगोदरच वैश्विकरित्या अवरूद्ध केलेला आहे. तुम्ही अस्तित्वात असलेले अवरोध [[Special:GlobalBlockList|वैश्विक अवरोधाच्या यादीत]] पाहू शकता, किंवा हे आवेदनपत्र पुन्हा सादर करून सध्या अस्तित्वात असलेल्या अवरोधाची मांडणी बदलू शकता',
	'globalblocking-block-bigrange' => 'तुम्ही दिलेली रेंज ($1) ही ब्लॉक करण्यासाठी खूप मोठी आहे. तुम्ही एकावेळी जास्तीत जास्त ६५,५३६ पत्ते ब्लॉक करू शकता (/१६ रेंज)',
	'globalblocking-list-intro' => 'ही सध्या क्रियान्वित असलेल्या सर्व वैश्विक रोधांची यादी आहे.
या पैकी काही रोधांवर स्थानिकरित्या हटविल्याची खूण केल्या गेलेली आहे:याचा अर्थ असा कि, हा रोध इतर संकेतस्थळांवर लागु आहे, परंतु,स्थानिक प्रशासकाने या विकिवर तो रोध हटविण्याचा निर्णय घेतला आहे.',
	'globalblocking-list' => 'वैश्विक पातळीवर ब्लॉक केलेले आयपी अंकपत्ते',
	'globalblocking-search-legend' => 'एखाद्या वैश्विक ब्लॉक ला शोधा',
	'globalblocking-search-ip' => 'आयपी अंकपत्ता:',
	'globalblocking-search-submit' => 'ब्लॉक साठी शोध',
	'globalblocking-list-ipinvalid' => 'तुम्ही शोधायला दिलेला आयपी अंकपत्ता ($1) अयोग्य आहे.
कृपया योग्य आयपी अंकपत्ता द्या.',
	'globalblocking-search-errors' => 'आपला शोध पुढील कारण/कारणांसाठी अयशस्वी झालेला आहे {{PLURAL:$1|कारण|कारणे}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') वैश्विक पातळीवर ब्लॉक [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'समाप्ती $1',
	'globalblocking-list-anononly' => 'फक्त-अनामिक',
	'globalblocking-list-unblock' => 'अनब्लॉक',
	'globalblocking-list-whitelisted' => '$1 ने स्थानिक पातळीवर रद्द केले: $2',
	'globalblocking-list-whitelist' => 'स्थानिक स्थिती',
	'globalblocking-list-modify' => 'बदला',
	'globalblocking-list-noresults' => 'विनंती केलेला अंकपत्ता अथवा सदस्यनाव प्रतिबंधीत केलेले नाही.',
	'globalblocking-goto-block' => '(आयपी ) अंकपत्ता वैश्विक पातळीवर ब्लॉक करा',
	'globalblocking-goto-unblock' => 'एक वैश्विक ब्लॉक काढा',
	'globalblocking-goto-status' => 'वैश्विक रोधाची स्थानिक स्थिती बदलवा',
	'globalblocking-return' => 'वैश्विक पातळीवर ब्लॉक असलेल्यांची यादी द्या',
	'globalblocking-notblocked' => 'आपण टाकलेला ($1) हा आय पी अंकपत्ता हा वैश्विकरित्या रोधित नाही.',
	'globalblocking-unblock' => 'एक वैश्विक ब्लॉक काढा',
	'globalblocking-unblock-ipinvalid' => 'तुम्ही दिलेला आयपी अंकपत्ता ($1) अयोग्य आहे.
कृपया नोंद घ्या की तुम्ही सदस्य नाव वापरू शकत नाही!',
	'globalblocking-unblock-legend' => 'एक वैश्विक ब्लॉक काढा',
	'globalblocking-unblock-submit' => 'वैश्विक ब्लॉक काढा',
	'globalblocking-unblock-reason' => 'कारण:',
	'globalblocking-unblock-unblocked' => "तुम्ही आयपी अंकपत्ता '''$1''' वर असणारा वैश्विक ब्लॉक #$2 यशस्वीरित्या काढलेला आहे",
	'globalblocking-unblock-errors' => 'आपले या आयपी अंकपत्त्यावरील वैश्विक रोध काढणे अयशस्वी झाले आहे,{{PLURAL:$1|कारण|कारणे}}:',
	'globalblocking-unblock-successsub' => 'वैश्विक ब्लॉक काढलेला आहे',
	'globalblocking-unblock-subtitle' => 'वैश्विक ब्लॉक काढत आहे',
	'globalblocking-unblock-intro' => 'तुम्ही ह्या पानाचा वापर वैश्विक ब्लॉक काढण्या साठी करू शकता',
	'globalblocking-whitelist' => 'वैश्विक ब्लॉकची स्थानिक स्थिति',
	'globalblocking-whitelist-notapplied' => 'वैश्विक रोधांचे या विकिवर प्रयोजन  नाही,त्यामुळे वैश्विक रोधांची स्थानिक स्थिती अनुरूपित करता येऊ शकत नाही.',
	'globalblocking-whitelist-legend' => 'स्थानिक स्थिती बदला',
	'globalblocking-whitelist-reason' => 'कारण:',
	'globalblocking-whitelist-status' => 'स्थानिक स्थिती:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} वर हा वैश्विक ब्लॉक रद्द करा',
	'globalblocking-whitelist-submit' => 'स्थानिक स्थिती बदला',
	'globalblocking-whitelist-whitelisted' => "तुम्ही '''$1''' या अंकपत्त्याचा वैश्विक ब्लॉक #$2 {{SITENAME}} वर रद्द केलेला आहे.",
	'globalblocking-whitelist-dewhitelisted' => "तुम्ही '''$1''' या अंकपत्त्याचा वैश्विक ब्लॉक #$2 {{SITENAME}} वर पुन्हा दिलेला आहे.",
	'globalblocking-whitelist-successsub' => 'स्थानिक स्थिती बदलली',
	'globalblocking-whitelist-nochange' => 'वैश्विक रोधाच्या स्थानिक स्थितीत आपण काहीच बदल केला नाही.
[[Special:GlobalBlockList|वैश्विक रोधांच्या यादीकडे परत]].',
	'globalblocking-whitelist-errors' => 'वैश्विक रोधाच्या स्थानिक स्थितीत आपण केलेला बदल अयशस्वी होता.त्याची {{PLURAL:$1|कारण|कारणे}} पुढीलप्रमाणे:',
	'globalblocking-whitelist-intro' => 'आपण हे आवेदनपत्र वैश्विक रोधाची स्थानिक स्थिती संपादण्यास वापरू शकता.जर या विकिवर वैश्विक रोध वगळण्यात आला असेल तर बाधित अंकपत्त्याचा वापरकर्ता सामान्यपणे संपादने करू शकेल.
[[Special:GlobalBlockList|वैश्विक रोधांच्या यादीकडे परत]].',
	'globalblocking-blocked' => "तुमचा आयपी अंकपत्ता \$5 सर्व  विकींवर '''\$1''' (''\$2'') ने रोधित केलेला आहे.
यासाठी ''\"\$3\"'' हे कारण दिलेले आहे.
ही बंदी ''\$4'' वर.",
	'globalblocking-blocked-nopassreset' => 'आपण सदस्याचा परवलीचा शब्द पुनर्स्थापित करू शकत नाही कारण आपणांवर वैश्विक रोध आहे.',
	'globalblocking-logpage' => 'वैश्विक ब्लॉक सूची',
	'globalblocking-logpagetext' => 'हा या विकिवर लावण्यात आलेल्या व काढलेल्या वैश्विक रोधांचा  क्रमलेख आहे.याची नोंद घ्यावी कि,इतर विकिंवर वैश्विक रोध लावल्या व काढल्या जाऊ शकतात, जेणेकरून या विकिवर त्याचा परिणाम होऊ शकतो.सध्या क्रियाशील असणारे वैश्विक रोध बघण्यासाठी बघा:[[Special:GlobalBlockList|वैश्विक रोध यादी]].',
	'globalblocking-block-logentry' => '$2 हा समाप्ती कालावधी देऊन [[$1]] ला वैश्विक पातळीवर ब्लॉक केले',
	'globalblocking-block2-logentry' => '[[$1]]ला वैश्विकरित्या रोधित केले ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] वरील वैश्विक ब्लॉक काढला',
	'globalblocking-whitelist-logentry' => '[[$1]] वरचा वैश्विक ब्लॉक स्थानिक पातळीवर रद्द केला',
	'globalblocking-dewhitelist-logentry' => '[[$1]] वरचा वैश्विक ब्लॉक स्थानिक पातळीवर पुन्हा दिला',
	'globalblocking-modify-logentry' => '[[$1]]वर असणारा वैश्विक रोध अनुरूपित केला ($2)',
	'globalblocking-logentry-expiry' => 'समाप्ती $1',
	'globalblocking-logentry-noexpiry' => 'अनंत',
	'globalblocking-loglink' => '$1 हा आयपी अंकपत्ता वैश्विकरित्या रोधित केला  ([[{{#Special:GlobalBlockList}}/$1|संपूर्ण तपशील]]).',
	'globalblocking-showlog' => 'हा आयपी अंकपत्ता पूर्वी वैश्विकरित्या रोधित केल्या गेला होता.
संदर्भासाठी रोधाचा क्रमलेख खाली देण्यात येत आहे:',
	'globalblocklist' => 'वैश्विक पातळीवर ब्लॉक केलेल्या आयपी अंकपत्त्यांची यादी',
	'globalblock' => 'आयपी अंकपत्त्याला वैश्विक पातळीवर ब्लॉक करा',
	'globalblockstatus' => 'वैश्विक रोधाची स्थानिक स्थिती',
	'removeglobalblock' => 'वैश्विक रोध हटवा',
	'right-globalblock' => 'वैश्विक ब्लॉक तयार करा',
	'right-globalunblock' => 'वैश्विक ब्लॉक काढून टाका',
	'right-globalblock-whitelist' => 'वैश्विक ब्लॉक स्थानिक पातळीवर रद्द करा',
	'right-globalblock-exempt' => 'वैश्विक रोधास बगल द्या',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 * @author Aviator
 * @author Izzudin
 * @author Kurniasan
 */
$messages['ms'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Membolehkan]] sekatan alamat IP di [[Special:GlobalBlockList|pelbagai wiki]] sekaligus',
	'globalblocking-block' => 'Sekat alamat IP di semua wiki',
	'globalblocking-modify-intro' => 'Anda boleh gunakan borang ini untuk tukar tetapan penyekatan global.',
	'globalblocking-block-intro' => 'Anda boleh menggunakan laman khas ini untuk menyekat alamat IP di semua wiki.',
	'globalblocking-block-reason' => 'Alasan:',
	'globalblocking-block-otherreason' => 'Sebab lain/tambahan:',
	'globalblocking-block-reasonotherlist' => 'Sebab lain',
	'globalblocking-block-reason-dropdown' => '* Sebab-sebab sekatan lazim
** Spam merentasi wiki
** Penyalahgunaan merentasi wiki
** Vandalisme',
	'globalblocking-block-edit-dropdown' => 'Sunting sebab sekatan',
	'globalblocking-block-expiry' => 'Tamat:',
	'globalblocking-block-expiry-other' => 'Waktu tamat lain',
	'globalblocking-block-expiry-otherfield' => 'Waktu lain:',
	'globalblocking-block-legend' => 'Sekat alamat IP di semua wiki',
	'globalblocking-block-options' => 'Pilihan:',
	'globalblocking-ipaddress' => 'Alamat IP:',
	'globalblocking-ipbanononly' => 'Sekat pengguna tanpa nama sahaja',
	'globalblocking-block-errors' => 'Sekatan anda tidak dapat dilakukan kerana {{PLURAL:$1|sebab|sebab-sebab}} berikut:',
	'globalblocking-block-ipinvalid' => 'Alamat IP tersebut ($1) tidak sah.
Sila ambil perhatian bahawa anda tidak boleh menyatakan nama pengguna!',
	'globalblocking-block-expiryinvalid' => 'Tarikh tamat yang anda nyatakan ($1) tidak sah.',
	'globalblocking-block-submit' => 'Sekat alamat IP ini di semua wiki',
	'globalblocking-modify-submit' => 'Ubah penyekatan global ini',
	'globalblocking-block-success' => 'Alamat IP $1 telah disekat di semua projek wiki.',
	'globalblocking-modify-success' => 'Sekatan sejagat pada $1 telah berjaya diubah',
	'globalblocking-block-successsub' => 'Sekatan sejagat berjaya',
	'globalblocking-modify-successsub' => 'Sekatan sejagat berjaya diubah',
	'globalblocking-block-alreadyblocked' => 'Alamat IP $1 telah pun disekat di semua wiki.
Anda boleh melihat sekatan ini di [[Special:GlobalBlockList|senarai sekatan sejagat]], atau ubah tetapan untuk sekatan ini dengan menghantar semula borang ini.',
	'globalblocking-block-bigrange' => 'Julat yang anda nyatakan ($1) terlalu besar.
Anda hanya boleh menyekat sehingga 65,536 alamat (julat /16)',
	'globalblocking-list-intro' => 'Yang berikut ialah senarai sekatan sejagat yang sedang berkuat kuasa.
Sesetengah sekatan telah dimatikan di wiki tempatan. Dalam kata lain, sekatan itu berkuat kuasa di wiki-wiki lain tetapi pentadbir tempatan telah memutuskan untuk membatalkan sekatan itu di wiki ini.',
	'globalblocking-list' => 'Senarai sekatan sejagat',
	'globalblocking-search-legend' => 'Cari sekatan sejagat',
	'globalblocking-search-ip' => 'Alamat IP:',
	'globalblocking-search-submit' => 'Cari sekatan',
	'globalblocking-list-ipinvalid' => 'Alamat IP yang anda ingin cari ($1) tidak sah.
Sila nyatakan alamat IP yang sah.',
	'globalblocking-search-errors' => 'Carian anda tidak dapat dilakukan kerana {{PLURAL:$1|sebab|sebab-sebab}} berikut:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') menyekat [[Special:Contributions/\$4|\$4]] di semua wiki ''(\$5)''",
	'globalblocking-list-expiry' => 'tamat $1',
	'globalblocking-list-anononly' => 'pengguna tanpa nama sahaja',
	'globalblocking-list-unblock' => 'nyahsekat',
	'globalblocking-list-whitelisted' => 'dimatikan di wiki tempatan oleh $1: $2',
	'globalblocking-list-whitelist' => 'status tempatan',
	'globalblocking-list-modify' => 'ubahsuai',
	'globalblocking-list-noresults' => 'Alamat IP yang diminta tidak disekat.',
	'globalblocking-goto-block' => 'Sekat alamat IP di semua wiki',
	'globalblocking-goto-unblock' => 'Batalkan sekatan sejagat',
	'globalblocking-goto-status' => 'Tukar status tempatan bagi sekatan sejagat',
	'globalblocking-return' => 'Kembali ke senarai sekatan sejagat',
	'globalblocking-notblocked' => 'Alamat IP yang anda nyatakan ($1) tidak disekat di semua wiki.',
	'globalblocking-unblock' => 'Batalkan sekatan sejagat',
	'globalblocking-unblock-ipinvalid' => 'Alamat IP yang anda nyatakan ($1) tidak sah.
Sila ambil perhatian bahawa anda tidak boleh menyatakan nama pengguna!',
	'globalblocking-unblock-legend' => 'Batalkan sekatan sejagat',
	'globalblocking-unblock-submit' => 'Batalkan sekatan sejagat',
	'globalblocking-unblock-reason' => 'Sebab:',
	'globalblocking-unblock-unblocked' => "Anda telah membatalkan sekatan sejagat #$2 terhadap alamat IP '''$1'''",
	'globalblocking-unblock-errors' => 'Sekatan sejagat itu tidak dapat dibatalkan kerana {{PLURAL:$1|sebab|sebab-sebab}} berikut:',
	'globalblocking-unblock-successsub' => 'Sekatan sejagat telah dibatalkan',
	'globalblocking-unblock-subtitle' => 'Membatalkan sekatan sejagat',
	'globalblocking-unblock-intro' => 'Anda boleh menggunakan borang ini untuk membatalkan sekatan sejagat.',
	'globalblocking-whitelist' => 'Status tempatan bagi sekatan sejagat',
	'globalblocking-whitelist-notapplied' => 'Sekatan sejagat tidak digunakan di wiki ini,
maka status sekatan sejagat tidak boleh diubah.',
	'globalblocking-whitelist-legend' => 'Tukar status tempatan',
	'globalblocking-whitelist-reason' => 'Sebab:',
	'globalblocking-whitelist-status' => 'Status tempatan:',
	'globalblocking-whitelist-statuslabel' => 'Matikan sekatan sejagat ini di {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Tukar status tempatan',
	'globalblocking-whitelist-whitelisted' => "Anda telah mematikan sekatan sejagat #$2 terhadap alamat IP '''$1''' di {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Anda telah menghidupkan semula sekatan sejagat #$2 terhadap alamat IP '''$1''' di {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Status tempatan telah ditukar',
	'globalblocking-whitelist-nochange' => 'Anda tidak melakukan apa-apa perubahan pada status tempatan bagi sekatan ini.
[[Special:GlobalBlockList|Kembali ke senarai sekatan sejagat]].',
	'globalblocking-whitelist-errors' => 'Status tempatan bagi sekatan sejagat itu tidak dapat ditukar kerana {{PLURAL:$1|sebab|sebab-sebab}} berikut:',
	'globalblocking-whitelist-intro' => 'Gunakan borang ini untuk mengubah status tempatan bagi suatu sekatan sejagat.
Jika suatu sekatan sejagat dimatikan di wiki ini, pengguna alamat IP yang berkenaan boleh menyunting seperti biasa.
[[Special:GlobalBlockList|Kembali ke senarai sekatan sejagat]].',
	'globalblocking-blocked' => "Alamat IP anda, \$5, telah disekat di semua wiki oleh '''\$1''' (''\$2'').
Sebab yang diberikan ialah ''\"\$3\"''.
Sekatan ini ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Anda tidak boleh mengeset semula kata laluan pengguna kerana anda telah disekat di semua wiki.',
	'globalblocking-logpage' => 'Log sekatan sejagat',
	'globalblocking-logpagetext' => 'Yang berikut ialah log sekatan sejagat yang telah dikenakan dan dibatalkan di wiki ini. Sila ambil perhatian bahawa sekatan sejagat boleh dikenakan dan dibatalkan di wiki-wiki lain, justeru berkuatkuasa di wiki ini juga. Anda juga boleh melihat [[Special:GlobalBlockList|senarai semakan sejagat yang sedang berkuatkuasa]].',
	'globalblocking-block-logentry' => 'menyekat [[$1]] di semua wiki sehingga $2',
	'globalblocking-block2-logentry' => '[[$1]] telah disekat secara sejagat ($2)',
	'globalblocking-unblock-logentry' => 'membatalkan sekatan sejagat terhadap [[$1]]',
	'globalblocking-whitelist-logentry' => 'mematikan sekatan sejagat terhadap [[$1]] di wiki tempatan',
	'globalblocking-dewhitelist-logentry' => 'menghidupkan semula sekatan sejagat terhadap [[$1]] di wiki tempatan',
	'globalblocking-modify-logentry' => 'sekatan sejagat untuk [[$1]] ($2) telah diubahsuai',
	'globalblocking-logentry-expiry' => 'luput $1',
	'globalblocking-logentry-noexpiry' => 'perluputan tidak ditetapkan',
	'globalblocking-loglink' => 'Alamat IP $1 telah disekat di semua wiki ([[{{#Special:GlobalBlockList}}/$1|butiran penuh]]).',
	'globalblocking-showlog' => 'Alamat IP ini pernah disekat sebelum ini. Log sekatan disediakan di bawah sebagai rujukan:',
	'globalblocklist' => 'Senarai sekatan sejagat',
	'globalblock' => 'Sekat alamat IP di semua wiki',
	'globalblockstatus' => 'Status tempatan bagi sekatan sejagat',
	'removeglobalblock' => 'Batalkan sekatan sejagat',
	'right-globalblock' => 'Mengenakan sekatan sejagat',
	'action-globalblock' => 'membuat sekatan sejagat',
	'right-globalunblock' => 'Membatalkan sekatan sejagat',
	'action-globalunblock' => 'membuang sekatan sejagat',
	'right-globalblock-whitelist' => 'Mematikan sekatan sejagat di wiki tempatan',
	'action-globalblock-whitelist' => 'mematikan sekatan sejagat secara setempat',
	'right-globalblock-exempt' => 'Mengatasi sekatan sejagat',
	'action-globalblock-exempt' => 'memintas sekatan sejagat',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'globalblocking-list' => "Lista ta' indirizzi IP imblukkati globalment",
	'globalblocking-search-legend' => 'Fittex għal blokk globali',
	'globalblocking-search-ip' => 'Indirizz IP:',
	'globalblocking-search-submit' => 'Fittex għal blokki',
	'globalblocking-goto-unblock' => 'Neħħi blokk globali',
	'globalblocking-unblock' => 'Neħħi blokk globali',
	'globalblocking-unblock-intro' => "Tista' tuża' din il-formola sabiex tneħħi blokk globali.",
	'globalblocking-whitelist' => 'Stat lokali tal-blokki globali',
	'globalblocking-blocked' => "L-indrizz IP tiegħek ġie imblukkat fuq il-wikis kollha minn '''\$1''' (''\$2'').
Ir-raġuni li ngħatat kienet ''\"\$3\"''.
Il-blokk huwa ''\$4''.",
	'globalblocklist' => "Lista ta' indirizzi IP imblukkati globalment",
	'globalblockstatus' => 'Stat lokali tal-blokki globali',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'globalblocking-block-reason' => 'Тувталось:',
	'globalblocking-block-otherreason' => 'Лия/поладкс тувталось:',
	'globalblocking-block-reasonotherlist' => 'Лия тувтал',
	'globalblocking-block-expiry' => 'Шказо лиси:',
	'globalblocking-list-anononly' => 'ансяк лемтеме',
	'globalblocking-unblock-reason' => 'Тувталось:',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'globalblocking-search-ip' => 'IP:',
	'globalblocking-list-anononly' => 'zan ahtōcā',
	'globalblocking-unblock-reason' => 'Tlèka:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Gjør det mulig]] å blokkere IP-adresser på [[Special:GlobalBlockList|alle wikier]]',
	'globalblocking-block' => 'Blokker en IP-adresse globalt',
	'globalblocking-modify-intro' => 'Du kan bruke dette skjemaet for å endre innstillingene av en global blokkering.',
	'globalblocking-block-intro' => 'Du kan bruke denne siden for å blokkere en IP-adresse på alle wikier.',
	'globalblocking-block-reason' => 'Årsak:',
	'globalblocking-block-otherreason' => 'Annen/ytterligere årsak:',
	'globalblocking-block-reasonotherlist' => 'Annen årsak',
	'globalblocking-block-reason-dropdown' => '* Vanlige blokkeringsårsaker
** Crosswiki-spamming
** Crosswiki-misbruk
** Vandalisme',
	'globalblocking-block-edit-dropdown' => 'Rediger blokkeringsgrunner',
	'globalblocking-block-expiry' => 'Utløp:',
	'globalblocking-block-expiry-other' => 'Annen varighet',
	'globalblocking-block-expiry-otherfield' => 'Annen tid:',
	'globalblocking-block-legend' => 'Blokker en IP-adresse globalt',
	'globalblocking-block-options' => 'Alternativer:',
	'globalblocking-ipaddress' => 'IP-adresse:',
	'globalblocking-ipbanononly' => 'Blokker bare anonyme brukere',
	'globalblocking-block-errors' => 'Blokkeringen mislyktes fordi:<!--{{PLURAL:$1}}-->',
	'globalblocking-block-ipinvalid' => 'IP-adressen du skrev inn ($1) er ugyldig.
Merk at du ikke kan skrive inn brukernavn.',
	'globalblocking-block-expiryinvalid' => 'Varigheten du skrev inn ($1) er ugyldig.',
	'globalblocking-block-submit' => 'Blokker denne IP-adressen globalt',
	'globalblocking-modify-submit' => 'Endre denne globale blokkering',
	'globalblocking-block-success' => 'IP-adressen $1 har blitt blokkert på alle prosjekter.',
	'globalblocking-modify-success' => 'Den globale blokkeringen av $1 har blitt endret',
	'globalblocking-block-successsub' => 'Global blokkering lyktes',
	'globalblocking-modify-successsub' => 'Global blokkering har blitt endret',
	'globalblocking-block-alreadyblocked' => 'IP-adressen $1 er blokkert globalt fra før. 
Du kan se eksisterende blokkeringer på [[Special:GlobalBlockList|listen over globale blokkeringer]],
eller redigere innstillingene av den eksisterende blokkeringen ved å lagre dette skjemaet på nytt.',
	'globalblocking-block-bigrange' => 'IP-området du oppga ($1) er for stort til å blokkeres. Du kan blokkere maks 65&nbsp;536 adresser (/16-områder)',
	'globalblocking-list-intro' => 'Dette er en liste over nåværende globale blokkeringer. Noen blokkeringer er slått av lokalt; dette betyr at den gjelder andre steder, men at en lokal administrator har bestemt seg for å slå av blokkeringen på sin wiki.',
	'globalblocking-list' => 'Liste over globalt blokkerte IP-adresser',
	'globalblocking-search-legend' => 'Søk etter en global blokkering',
	'globalblocking-search-ip' => 'IP-adresse:',
	'globalblocking-search-submit' => 'Søk etter blokkeringer',
	'globalblocking-list-ipinvalid' => 'IP-adressen du skrev inn ($1) er ugyldig.
Skriv inn en gyldig IP-adresse.',
	'globalblocking-search-errors' => 'Søket ditt mislyktes fordi:<!--{{PLURAL:$1}}-->',
	'globalblocking-list-blockitem' => "\$1 <span class=\"plainlinks\">'''\$2'''</span> ('''\$3''') blokkerte [[Special:Contributions/\$4|\$4]] globalt ''(\$5)''",
	'globalblocking-list-expiry' => 'varighet $1',
	'globalblocking-list-anononly' => 'kun uregistrerte',
	'globalblocking-list-unblock' => 'avblokker',
	'globalblocking-list-whitelisted' => 'slått av lokalt av $1: $2',
	'globalblocking-list-whitelist' => 'lokal status',
	'globalblocking-list-modify' => 'endre',
	'globalblocking-list-noresults' => 'Den etterspurte IP-adressen er ikke blokkert.',
	'globalblocking-goto-block' => 'Blokker in IP-adresse globalt',
	'globalblocking-goto-unblock' => 'Fjern en global blokkering',
	'globalblocking-goto-status' => 'Endre lokal status for en global blokkering',
	'globalblocking-return' => 'Tilbake til listen over globale blokkeringer',
	'globalblocking-notblocked' => 'IP-adressen du oppga ($1) er ikke blokkert globalt.',
	'globalblocking-unblock' => 'Fjern global blokkering',
	'globalblocking-unblock-ipinvalid' => 'IP-adressen du skrev inn ($1) er ugyldig.
Merk at du ikke kan skrive inn brukernavn.',
	'globalblocking-unblock-legend' => 'Fjern en global blokkering',
	'globalblocking-unblock-submit' => 'Fjern global blokkering',
	'globalblocking-unblock-reason' => 'Årsak:',
	'globalblocking-unblock-unblocked' => "Du har fjernet den globale blokkeringen (#$2) på IP-adressen '''$1'''",
	'globalblocking-unblock-errors' => 'Du kan ikke fjerne en global blokkering på den IP-adressen fordi:<!--{{PLURAL:$1}}-->',
	'globalblocking-unblock-successsub' => 'Global blokkering fjernet',
	'globalblocking-unblock-subtitle' => 'Fjerner global blokkering',
	'globalblocking-unblock-intro' => 'Du kan bruke dette skjemaet for å fjerne en global blokkering.',
	'globalblocking-whitelist' => 'Lokal status for globale blokkeringer',
	'globalblocking-whitelist-notapplied' => 'Globale blokkeringer gjelder ikke på denne wikien,
så den lokale statusen for globale blokkeringer kan ikke endres her.',
	'globalblocking-whitelist-legend' => 'Endre lokal status',
	'globalblocking-whitelist-reason' => 'Årsak:',
	'globalblocking-whitelist-status' => 'Lokal status:',
	'globalblocking-whitelist-statuslabel' => 'Slå av denne globale blokkeringen på {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Endre lokal status',
	'globalblocking-whitelist-whitelisted' => "Du har slått av global blokkering nr. $2 på IP-adressen '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Du har slått på igjen global blokkering nr. $2 på IP-adressen '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Lokal status endret',
	'globalblocking-whitelist-nochange' => 'Du endret ikke denne blokkeringens lokale status. [[Special:GlobalBlockList|Tilbake til den globale blokkeringslista.]]',
	'globalblocking-whitelist-errors' => 'Endringen i lokal status lyktes ikke fordi:<!--{{PLURAL:$1}}-->',
	'globalblocking-whitelist-intro' => 'Du kan bruke dette skjemaet til å redigere en global blokkerings lokale status. Om en global blokkering er slått av på denne wikien, vil brukerne av de påvirkede IP-adressene kunne redigere normalt. [[Special:GlobalBlockList|Tilbake til den globale blokkeringslista.]]',
	'globalblocking-blocked' => "IP-adressen din ($5) har blitt blokkert på alle wikier av '''$1''' (''$2'') med følgende begrunnelse: '''$3'''.
Blokkeringen ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Du kan ikke nullstille brukerpassord fordi du er blokkert globalt.',
	'globalblocking-logpage' => 'Global blokkeringslogg',
	'globalblocking-logpagetext' => 'Dette er en logg over globale blokkeringer som har blitt gjort eller fjernet på denne wikien.
Det burde merkes at globale blokkeringer goså kan foretas på andre wikier, og at disse vil ha utslag på denne wikien.
For å vise alle aktive globale blokkeringer, se den [[Special:GlobalBlockList|globale blokkeringslisten]].',
	'globalblocking-block-logentry' => 'blokkerte [[$1]] globalt med en varighet på $2',
	'globalblocking-block2-logentry' => 'blokkerte [[$1]] globalt ($2)',
	'globalblocking-unblock-logentry' => 'fjernet global blokkering på [[$1]]',
	'globalblocking-whitelist-logentry' => 'slo av global blokkering av [[$1]] lokalt',
	'globalblocking-dewhitelist-logentry' => 'slo på igjen global blokkering av [[$1]] lokalt',
	'globalblocking-modify-logentry' => 'endret den globale blokkeringen av [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'utgår $1',
	'globalblocking-logentry-noexpiry' => 'ingen utgangstid satt',
	'globalblocking-loglink' => 'IP-adressen $1 er blokkert globalt ([[{{#Special:GlobalBlockList}}/$1|detaljer]]).',
	'globalblocking-showlog' => 'Denne IP-adressen har tidligere blitt blokkert.
Blokkeringsloggen vises under som referanse:',
	'globalblocklist' => 'Liste over globalt blokkerte IP-adresser',
	'globalblock' => 'Blokker en IP-adresse globalt',
	'globalblockstatus' => 'Lokal status for globale blokkeringer',
	'removeglobalblock' => 'Fjern en global blokkering',
	'right-globalblock' => 'Blokkere IP-er globalt',
	'right-globalunblock' => 'Fjerne globale blokkeringer',
	'right-globalblock-whitelist' => 'Slå av globale blokkeringer lokalt',
	'right-globalblock-exempt' => 'Gå utenom globale blokkeringer',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Sperrt]] IP-Adressen op [[Special:GlobalBlockList|all Wikis]]',
	'globalblocking-block' => 'En IP-Adress global sperren',
	'globalblocking-modify-intro' => 'Mit dit Formular kannst du en globale Sperr instellen un ännern.',
	'globalblocking-block-intro' => 'Op disse Sied kannst du IP-Adressen för alle Wikis sperren.',
	'globalblocking-block-reason' => 'Grund:',
	'globalblocking-block-expiry' => 'Sperrduur:',
	'globalblocking-block-expiry-other' => 'Annere Aflooptied',
	'globalblocking-block-expiry-otherfield' => 'Annere Tied:',
	'globalblocking-block-legend' => 'En Bruker global sperren',
	'globalblocking-block-options' => 'Opschonen:',
	'globalblocking-block-errors' => 'De Sperr hett nich klappt. Dat harr {{PLURAL:$1|dissen Grund|disse Grünn}}:',
	'globalblocking-block-ipinvalid' => 'Du hest en ungüllige IP-Adress ($1) ingeven.
Denk dor an, dat du keen Brukernaam ingeven kannst!',
	'globalblocking-block-expiryinvalid' => 'De Sperrduur ($1) is ungüllig.',
	'globalblocking-block-submit' => 'Disse IP-Adress global sperren',
	'globalblocking-modify-submit' => 'Disse globale Sperr ännern',
	'globalblocking-block-success' => 'De IP-Adress $1 is op all Projekten sperrt.',
	'globalblocking-modify-success' => 'De globale Sperr vun $1 is nu ännert',
	'globalblocking-block-successsub' => 'Globale Sperr instellt',
	'globalblocking-modify-successsub' => 'Globale Sperr ännert',
	'globalblocking-block-alreadyblocked' => 'De IP-Adress $1 is al global sperrt.
Du kannst de Sperr in de [[Special:GlobalBlockList|globale Sperrlist]] ankieken oder de vörhannen Sperr över dit Formular ännern.',
	'globalblocking-block-bigrange' => 'De angeven IP-Block ($1) is to groot.
Du kannst hööchstens 65.536 Adressen sperren (/16-IP-Blöck)',
	'globalblocking-list-intro' => 'Dit is en List vun all globale Sperren, de opstunns gellt.
Welk sperrt Brukers sünd lokal nich sperrt. Dat bedüüdt, dat de Sperr op annere Projekten gellt, aver dat de lokale Administrater meent hett, dat de Bruker dor nich sperrt wesen schall.',
	'globalblocking-list' => 'List vun global sperrte IP-Adressen',
	'globalblocking-search-legend' => 'Globale Sperr söken',
	'globalblocking-search-ip' => 'IP-Adress:',
	'globalblocking-search-submit' => 'Sperren söken',
	'globalblocking-list-ipinvalid' => 'Du hest en ungüllige IP-Adress ($1) ingeven.
Geev en güllige IP-Adress an.',
	'globalblocking-search-errors' => 'De Söök hett nix funnen. Dit {{PLURAL:$1|is de Grund|sünd de Grünn}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') hett [[Special:Contributions/\$4|\$4]] global sperrt ''(\$5)''",
	'globalblocking-list-expiry' => 'löppt $1 ut',
	'globalblocking-list-anononly' => 'blot Anonyme',
	'globalblocking-list-unblock' => 'opheven',
	'globalblocking-list-whitelisted' => 'lokal utstellt vun $1: $2',
	'globalblocking-list-whitelist' => 'lokalen Status',
	'globalblocking-list-modify' => 'ännern',
	'globalblocking-goto-block' => 'IP-Adress global sperren',
	'globalblocking-goto-unblock' => 'Globale Sperr opheven',
	'globalblocking-goto-status' => 'Lokalen Status för en globale Sperr ännern',
	'globalblocking-return' => 'Trüch na de List vun globale Sperren',
	'globalblocking-notblocked' => 'De angeven IP-Adress ($1) is nich global sperrt.',
	'globalblocking-unblock' => 'Globale Sperr opheven',
	'globalblocking-unblock-ipinvalid' => 'Du hest en ungüllige IP-Adress ($1) ingeven.
Denk dor an, dat du keen Brukernaam ingeven kannst!',
	'globalblocking-unblock-legend' => 'Globale Sperr opheven',
	'globalblocking-unblock-submit' => 'Globale Sperr opheven',
	'globalblocking-unblock-reason' => 'Grund:',
	'globalblocking-unblock-unblocked' => "Du hest de globale Sperr #$2 vun de IP-Adress '''$1''' ophoven",
	'globalblocking-unblock-errors' => 'De globale Sperr is nich ophoven worrn. Dat harr {{PLURAL:$1|dissen Grund|disse Grünn}}:',
	'globalblocking-unblock-successsub' => 'Globale Sperr ophoven',
	'globalblocking-unblock-subtitle' => 'Globale Sperr opheven',
	'globalblocking-unblock-intro' => 'Mit dit Formular kannst du en globale Sperr wedder opheven.',
	'globalblocking-whitelist' => 'Lokalen Status vun en globale Sperr',
	'globalblocking-whitelist-notapplied' => 'Globale Sperren gellt op dit Wiki nich,
de lokale Status vun globale Sperren kann also ok nich ännert warrn.',
	'globalblocking-whitelist-legend' => 'Lokalen Status ännern',
	'globalblocking-whitelist-reason' => 'Grund:',
	'globalblocking-whitelist-status' => 'Lokalen Status:',
	'globalblocking-whitelist-statuslabel' => 'Disse globale Sperr op {{SITENAME}} opheven',
	'globalblocking-whitelist-submit' => 'Lokalen Status ännern',
	'globalblocking-whitelist-whitelisted' => "Du hest de globale Sperr #$2 vun de IP-Adress '''$1''' op {{SITENAME}} ophoven.",
	'globalblocking-whitelist-dewhitelisted' => "Du hest de globale Sperr #$2 vun de IP-Adress '''$1''' op {{SITENAME}} wedder inschalt.",
	'globalblocking-whitelist-successsub' => 'Lokalen Status ännert',
	'globalblocking-whitelist-nochange' => 'Du hest den lokalen Status vun de Sperr nich ännert.
[[Special:GlobalBlockList|Trüch na de List vun globale Sperren]]',
	'globalblocking-whitelist-errors' => 'Dien Ännern vun’n lokalen Status vun en globale Sperr hett nich klappt. {{PLURAL:$1|Grund|Grünn}}:',
	'globalblocking-whitelist-intro' => 'Mit dit Formular kannst du den lokalen Status vun en globale Sperr ännern.
Wenn en globale Sperr in dat Wiki utstellt worrn is, köönt Brukers över de bedrapen IP-Adress normal Sieden ännern.
[[Special:GlobalBlockList|Trüch na de List mit de globalen Sperren]].',
	'globalblocking-blocked' => "Dien IP-Adress is vun '''$1''' (''$2'') op all Wikis sperrt worrn.
De Grund is mit ''„$3“'' angeven.
De Sperr ''$4''.",
	'globalblocking-logpage' => 'Global Sperrlogbook',
	'globalblocking-logpagetext' => 'Dit is dat Logbook mit de globalen Sperren, de in dit Wiki instellt oder utstellt worrn sünd.
Globale Sperren köönt ok in en anner Wiki instellt und utstellt warrn, un de Sperren dor warkt sik ok op dit Wiki ut.
För en List mit all aktive globale Sperren kiek na de [[Special:GlobalBlockList|globale Sperrlist]].',
	'globalblocking-block-logentry' => 'hett [[$1]] för en Tied vun $2 global sperrt',
	'globalblocking-block2-logentry' => 'hett [[$1]] ($2) global sperrt',
	'globalblocking-unblock-logentry' => 'hett de globale Sperr för [[$1]] ophoven',
	'globalblocking-whitelist-logentry' => 'hett de globale Sperr vun [[$1]] lokal afschalt',
	'globalblocking-dewhitelist-logentry' => 'hett de globale Sperr vun [[$1]] lokal wedder inschalt',
	'globalblocking-modify-logentry' => 'hett de globale Sperr vun [[$1]] ($2) ännert',
	'globalblocking-logentry-expiry' => 'löppt $1 ut',
	'globalblocking-logentry-noexpiry' => 'löppt nich ut',
	'globalblocklist' => 'List vun all global sperrte IP-Adressen',
	'globalblock' => 'En IP-Adress global sperren',
	'globalblockstatus' => 'Lokalen Status vun de globale Sperr',
	'removeglobalblock' => 'Globale Sperr opheven',
	'right-globalblock' => 'Globale Sperren maken',
	'right-globalunblock' => 'Globale Sperren opheven',
	'right-globalblock-whitelist' => 'Globale Sperren lokal afschalten',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'globalblocking-block-options' => 'Opsies:',
	'globalblocking-whitelist' => 'Lokale staotus van globale blokkeringen',
	'globalblocklist' => 'Lieste van globaal eblokkeerden IP-adressen',
	'globalblockstatus' => 'Lokale staotus van globale blokkeringen',
);

/** Dutch (Nederlands)
 * @author Romaine
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'globalblocking-desc' => "[[Special:GlobalBlock|Maakt het mogelijk]] IP-addressen [[Special:GlobalBlockList|in meerdere wiki's tegelijk]] te blokkeren",
	'globalblocking-block' => 'Een IP-adres globaal blokkeren',
	'globalblocking-modify-intro' => 'U kunt dit formulier gebruiken om de instellingen van een globale blokkade te wijzigen.',
	'globalblocking-block-intro' => "U kunt deze pagina gebruiken om een IP-adres op alle wiki's te blokkeren.",
	'globalblocking-block-reason' => 'Reden:',
	'globalblocking-block-otherreason' => 'Andere reden:',
	'globalblocking-block-reasonotherlist' => 'Andere reden',
	'globalblocking-block-reason-dropdown' => "* Veel voorkomende blokkaderedenen
** Spammen in meerdere wiki's
** Misbruik maken van meerdere wiki's
** Vandalisme",
	'globalblocking-block-edit-dropdown' => 'Lijst van redenen bewerken',
	'globalblocking-block-expiry' => 'Vervalt:',
	'globalblocking-block-expiry-other' => 'Andere vervaltermijn',
	'globalblocking-block-expiry-otherfield' => 'Andere tijd:',
	'globalblocking-block-legend' => 'Een IP-adres globaal blokkeren',
	'globalblocking-block-options' => 'Opties:',
	'globalblocking-ipaddress' => 'IP-adres:',
	'globalblocking-ipbanononly' => 'Alleen anonieme gebruikers blokkeren',
	'globalblocking-block-errors' => 'De blokkade is niet ingesteld om de volgende {{PLURAL:$1|reden|redenen}}:',
	'globalblocking-block-ipinvalid' => 'Het IP-adres ($1) dat u hebt opgegeven is onjuist.
Let op: u kunt geen gebruikersnaam opgeven!',
	'globalblocking-block-expiryinvalid' => 'De vervaldatum/tijd die u hebt opgegeven is ongeldig ($1).',
	'globalblocking-block-submit' => 'Dit IP-adres globaal blokkeren',
	'globalblocking-modify-submit' => 'Deze globale blokkade wijzigen',
	'globalblocking-block-success' => 'Het IP-adres $1 is op alle projecten geblokkeerd.',
	'globalblocking-modify-success' => 'De globale blokkade voor $1 is gewijzigd',
	'globalblocking-block-successsub' => 'Globale blokkade ingesteld',
	'globalblocking-modify-successsub' => 'De globale blokkade is gewijzigd',
	'globalblocking-block-alreadyblocked' => 'Het IP-adres $1 is al globaal geblokkeerd.
U kunt de bestaande blokkade bekijken in de [[Special:GlobalBlockList|lijst met globale blokkades]] of de instellingen van de bestaande blokkade aanpassen door de gegevens uit dit formulier opnieuw op te slaan.',
	'globalblocking-block-bigrange' => 'De reeks die u hebt opgegeven ($1) is te groot om te blokkeren. U mag ten hoogste 65.536 adressen blokkeren (/16-reeksen)',
	'globalblocking-list-intro' => 'Dit is een lijst met alle globale blokkades die op het moment actief zijn.
Sommige blokkades zijn gemarkeerd als lokaal opgeheven.
Dit betekent dat ze op andere sites van toepassing zijn, maar dat een lokale beheerder heeft besloten dat de blokkade op deze wiki niet van toepassing is.',
	'globalblocking-list' => 'Lijst met globaal geblokkeerde IP-adressen',
	'globalblocking-search-legend' => 'Naar een globale blokkade zoeken',
	'globalblocking-search-ip' => 'IP-adres:',
	'globalblocking-search-submit' => 'Naar blokkades zoeken',
	'globalblocking-list-ipinvalid' => 'Het IP-adres waar u naar zocht is onjuist ($1).
Voer een correct IP-adres in.',
	'globalblocking-search-errors' => 'Uw zoekopdracht kende {{PLURAL:$1|het volgende probleem|de volgende problemen}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') heeft [[Special:Contributions/\$4|\$4]] globaal geblokkeerd ''(\$5)''",
	'globalblocking-list-expiry' => 'vervalt $1',
	'globalblocking-list-anononly' => 'alleen anoniemen',
	'globalblocking-list-unblock' => 'blokkade opheffen',
	'globalblocking-list-whitelisted' => 'lokaal genegeerd door $1: $2',
	'globalblocking-list-whitelist' => 'lokale status',
	'globalblocking-list-modify' => 'wijzigen',
	'globalblocking-list-noresults' => 'Het opgegeven IP-adres is niet geblokkeerd.',
	'globalblocking-goto-block' => 'IP-adres globaal blokkeren',
	'globalblocking-goto-unblock' => 'Globale blokkades verwijderen',
	'globalblocking-goto-status' => 'Lokale status van een globale blokkade wijzigen',
	'globalblocking-return' => 'Terug naar de lijst met globale blokkades',
	'globalblocking-notblocked' => 'Het ingegeven IP-adres ($1) is niet globaal geblokkeerd.',
	'globalblocking-unblock' => 'Globale blokkades verwijderen',
	'globalblocking-unblock-ipinvalid' => 'Het IP-adres ($1) dat u hebt ingegeven is onjuist.
Let op: u kunt geen gebruikersnaam ingeven!',
	'globalblocking-unblock-legend' => 'Een globale blokkade verwijderen',
	'globalblocking-unblock-submit' => 'Globale blokkade verwijderen',
	'globalblocking-unblock-reason' => 'Reden:',
	'globalblocking-unblock-unblocked' => "U hebt de globale blokkade met nummer $2 voor het IP-adres '''$1''' verwijderd",
	'globalblocking-unblock-errors' => 'De globale blokkade is niet verwijderd om de volgende {{PLURAL:$1|reden|redenen}}:',
	'globalblocking-unblock-successsub' => 'De globale blokkade is verwijderd',
	'globalblocking-unblock-subtitle' => 'Globale blokkade aan het verwijderen',
	'globalblocking-unblock-intro' => 'U kunt dit formulier gebruik om een globale blokkade op te heffen.',
	'globalblocking-whitelist' => 'Lokale status van globale blokkades',
	'globalblocking-whitelist-notapplied' => 'Globale blokkades worden niet toegepast op deze wiki, dus de lokale status van globale blokkades kan niet gewijzigd worden.',
	'globalblocking-whitelist-legend' => 'Lokale status wijzigen',
	'globalblocking-whitelist-reason' => 'Reden:',
	'globalblocking-whitelist-status' => 'Lokale status:',
	'globalblocking-whitelist-statuslabel' => 'Deze globale blokkade op {{SITENAME}} uitschakelen',
	'globalblocking-whitelist-submit' => 'Lokale status wijzigen',
	'globalblocking-whitelist-whitelisted' => "U hebt de globale blokkade #$2 met het IP-adres '''$1''' op {{SITENAME}} opgeheven.",
	'globalblocking-whitelist-dewhitelisted' => "U hebt de globale blokkade #$2 met het IP-adres '''$1''' op {{SITENAME}} opnieuw actief gemaakt.",
	'globalblocking-whitelist-successsub' => 'De lokale status is gewijzigd',
	'globalblocking-whitelist-nochange' => 'U hebt de lokale status van deze blokkade niet gewijzigd.
[[Special:GlobalBlockList|Terugkeren naar de lijst met globale blokkades]].',
	'globalblocking-whitelist-errors' => 'U kon de lokale status van de globale blokkade niet wijzigen om de volgende {{PLURAL:$1|reden|redenen}}:',
	'globalblocking-whitelist-intro' => 'U kunt dit formulier gebruiken om de lokale status van een globale blokkade te wijzigen.
Als een globale blokkade op deze wiki is opgeheven, kunnen gebruikers vanaf het IP-adres gewoon bewerkingen uitvoeren.
[[Special:GlobalBlockList|Terugkeren naar de lijst met globale blokkades]].',
	'globalblocking-blocked' => "Uw IP-adres \$5 is door '''\$1''' (''\$2'') geblokkeerd op alle wiki's.
De reden is ''\"\$3\"''.
De blokkade ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'U kunt het wachtwoord van gebruikers niet opnieuw instellen omdat u globaal geblokkeerd bent.',
	'globalblocking-logpage' => 'Globaal blokkeerlogboek',
	'globalblocking-logpagetext' => "Dit logboek bevat aangemaakte en verwijderde globale blokkades op deze wiki.
Globale blokkades kunnen ook op andere wiki's aangemaakt en verwijderd worden, en invloed hebben op deze wiki.
Alle globale blokkades staan in de [[Special:GlobalBlockList|lijst met globale blokkades]].",
	'globalblocking-block-logentry' => 'heeft [[$1]] globaal geblokkeerd met een vervaltijd van $2',
	'globalblocking-block2-logentry' => 'heeft [[$1]] globaal geblokkeerd ($2)',
	'globalblocking-unblock-logentry' => 'heeft de globale blokkade voor [[$1]] verwijderd',
	'globalblocking-whitelist-logentry' => 'heeft de globale blokkade van [[$1]] lokaal opgeheven',
	'globalblocking-dewhitelist-logentry' => 'heeft de globale blokkade van [[$1]] lokaal opnieuw ingesteld',
	'globalblocking-modify-logentry' => 'heeft de globale blokkade voor [[$1]] aangepast ($2)',
	'globalblocking-logentry-expiry' => 'vervalt op $1',
	'globalblocking-logentry-noexpiry' => 'geen vervaldatum ingesteld',
	'globalblocking-loglink' => 'Het IP-adres is globaal geblokkeerd ([[{{#Special:GlobalBlockList}}/$1|volledige details]])',
	'globalblocking-showlog' => 'Dit IP-adres is eerder geblokkeerd geweest.
Het blokkeerlogboek wordt hieronder weergegeven:',
	'globalblocklist' => 'Lijst van globaal geblokkeerde IP-adressen',
	'globalblock' => 'Een IP-adres globaal blokkeren',
	'globalblockstatus' => 'Lokale status van globale blokkades',
	'removeglobalblock' => 'Globale blokkade verwijderen',
	'right-globalblock' => 'Globale blokkades instellen',
	'right-globalunblock' => 'Globale blokkades verwijderen',
	'right-globalblock-whitelist' => 'Globale blokkades lokaal negeren',
	'right-globalblock-exempt' => 'Globale blokkades omzeilen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Jorunn
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Gjer det råd]] å blokkera IP-adresser [[Special:GlobalBlockList|krosswiki]]',
	'globalblocking-block' => 'Blokker ei IP-adresse krosswiki',
	'globalblocking-modify-intro' => 'Du kan nytta dette skjemaet til å endra instillingane til ei global blokkering.',
	'globalblocking-block-intro' => 'Du kan nytte denne sida til å blokkere ei IP-adresse krosswiki.',
	'globalblocking-block-reason' => 'Årsak:',
	'globalblocking-block-otherreason' => 'Annan grunn/tilleggsgrunn:',
	'globalblocking-block-reasonotherlist' => 'Annan årsak',
	'globalblocking-block-expiry' => 'Opphøyrstid:',
	'globalblocking-block-expiry-other' => 'Anna varigheit',
	'globalblocking-block-expiry-otherfield' => 'Anna tid:',
	'globalblocking-block-legend' => 'Blokker ein brukar krosswiki',
	'globalblocking-block-options' => 'Alternativ:',
	'globalblocking-block-errors' => 'Blokkeringa gjekk ikkje gjennom grunna {{PLURAL:$1|den følgjande årsaka|dei følgjande årsakene}}:',
	'globalblocking-block-ipinvalid' => 'IP-adressa du skreiv inn ($1) er ugyldig.
Merk at du ikkje kan skrive inn brukarnamn.',
	'globalblocking-block-expiryinvalid' => 'Varigheita du skreiv inn ($1) er ikkje gyldig.',
	'globalblocking-block-submit' => 'Blokker denne IP-adressa krosswiki',
	'globalblocking-modify-submit' => 'Endra denne globale blokkeringa',
	'globalblocking-block-success' => 'IP-adressa $1 har vorte blokkert på alle Wikimedia-prosjekta.',
	'globalblocking-modify-success' => 'Den globale blokkeringa av $1 er vorten endra',
	'globalblocking-block-successsub' => 'Krosswikiblokkeringa vart utførd',
	'globalblocking-modify-successsub' => 'Global blokkering er vorten endra',
	'globalblocking-block-alreadyblocked' => 'IP-adressa $1 er allereie blokkert globalt.
Du kan sjå blokkeringa på [[Special:GlobalBlockList|lista over globale blokkeringar]], 
eller endra innstillingane hennar gjennom å senda inn dette skjemaet på nytt.',
	'globalblocking-block-bigrange' => 'IP-området du oppgav ($1) er for stor til å verta blokkert. 
Du kan blokkera høgst 65&nbsp;536 adresser (/16-område)',
	'globalblocking-list-intro' => 'Dett er ei lista over noverande globale blokkeringar. 
Nokre blokkeringar er slegne av lokalt; dette tyder at blokkeringa gjeld andre stader, men at ein lokal administrator har bestemt seg for å slå av blokkeringa på sin wiki.',
	'globalblocking-list' => 'Liste over krosswikiblokkertet IP-adresser',
	'globalblocking-search-legend' => 'Søk etter ei krosswikiblokkering',
	'globalblocking-search-ip' => 'IP-adresse:',
	'globalblocking-search-submit' => 'Søk etter blokkeringar',
	'globalblocking-list-ipinvalid' => 'IP-adressa du skreiv inn ($1) er ikkje gyldig.
Skriv inn ei gyldig IP-adresse.',
	'globalblocking-search-errors' => 'Søket ditt lukkast ikkje grunna {{PLURAL:$1|den følgjande årsaka|dei følgjande årsakene}}:',
	'globalblocking-list-blockitem' => "\$1 <span class=\"plainlinks\">'''\$2'''</span> ('''\$3''') blokkerte [[Special:Contributions/\$4|\$4]] krosswiki ''(\$5)''",
	'globalblocking-list-expiry' => 'varigheit $1',
	'globalblocking-list-anononly' => 'berre uregistrerte',
	'globalblocking-list-unblock' => 'fjern blokkeringa',
	'globalblocking-list-whitelisted' => 'slegi av lokalt av $1: $2',
	'globalblocking-list-whitelist' => 'lokal status',
	'globalblocking-list-modify' => 'endra',
	'globalblocking-goto-block' => 'Blokker ei IP-adressa globalt',
	'globalblocking-goto-unblock' => 'Fjern ei global blokkering',
	'globalblocking-goto-status' => 'Endra lokal status for ei global blokkering',
	'globalblocking-return' => 'Attende til lista over globale blokkeringar',
	'globalblocking-notblocked' => 'IP-adressa du oppgav ($1) er ikkje blokkert globalt.',
	'globalblocking-unblock' => 'Fjern global blokkering',
	'globalblocking-unblock-ipinvalid' => 'IP-adressa du skreiv inn ($1) er ugyldig.
Merk at du ikkje kan skrive inn brukarnamn.',
	'globalblocking-unblock-legend' => 'Fjern ei krosswikiblokkering',
	'globalblocking-unblock-submit' => 'Fjern krosswikiblokkering',
	'globalblocking-unblock-reason' => 'Grunngjeving:',
	'globalblocking-unblock-unblocked' => "Du har fjerna den globale blokkeringa #$2 på IP-adressa '''$1'''",
	'globalblocking-unblock-errors' => 'Du lukkast ikkje å fjerna den globale blokkeringa grunna {{PLURAL:$1|den følgjande årsaka|dei følgjande årsakene}}:',
	'globalblocking-unblock-successsub' => 'Global blokkering fjerna',
	'globalblocking-unblock-subtitle' => 'Fjernar global blokkering',
	'globalblocking-unblock-intro' => 'Du kan nytta dette skjemaet for å fjerna ei global blokkering.',
	'globalblocking-whitelist' => 'Lokal status for globale blokkeringar',
	'globalblocking-whitelist-notapplied' => 'Globale blokkeringar gjeld ikkje på denne wikien, og med di vil ikkje den lokale stoda til globale blokkeringar kunna verta endra her.',
	'globalblocking-whitelist-legend' => 'Endra lokal status',
	'globalblocking-whitelist-reason' => 'Årsak:',
	'globalblocking-whitelist-status' => 'Lokal status:',
	'globalblocking-whitelist-statuslabel' => 'Slå av denne globale blokkeringa på {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Endra lokal status',
	'globalblocking-whitelist-whitelisted' => "Du har slegi av den globale blokkeringa #$2 på IP-adressa '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Du har slegi på att den globale blokkeringa #$2 på IP-adressa '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Lokal status endra',
	'globalblocking-whitelist-nochange' => 'Du endra ikkje den lokale statusen til denne blokkeringa.
[[Special:GlobalBlockList|Attende til den globale blokkeringslista]].',
	'globalblocking-whitelist-errors' => 'Freistnaden din på å endra den lokale statusen til den globale blokkeringa gjekk ikkje grunna {{PLURAL:$1|denne årsaka|dei følgjande årsakene}}:',
	'globalblocking-whitelist-intro' => 'Du kan nytta dette skjemaet for å endra den lokale statusen til ei global blokkering. Om ei global blokkering er slegi av på denne wikien, kan brukarar på den påverka IP-adressa vera i stand til å endra sider normalt.
[[Special:GlobalBlockList|Attende til den globale blokkeringslista]].',
	'globalblocking-blocked' => "IP-adressa di har vorti blokkert på alle wikiar av '''$1''' (''$2'').
Årsaka som vart oppgjevi var '''$3'''.
Blokkeringa ''$4''.",
	'globalblocking-logpage' => 'Global blokkeringslogg',
	'globalblocking-logpagetext' => 'Dette er ein logg over globale blokkeringar som har vortne gjennomførte eller fjerna på denne wikien.
Det bør merkast at globale blokkeringar òg kan både verta til og påfølgjande fjerna på andre wikiar, og at desse kan påverka denne wikien.
For å visa alle aktive globale blokkeringar, sjå den [[Special:GlobalBlockList|globale blokkeringslista]].',
	'globalblocking-block-logentry' => 'blokkerte [[$1]] globalt med ei opphøyrstid på $2',
	'globalblocking-block2-logentry' => 'blokkerte [[$1]] globalt ($2)',
	'globalblocking-unblock-logentry' => 'fjerna global blokkering på [[$1]]',
	'globalblocking-whitelist-logentry' => 'slo av global blokkering av [[$1]] lokalt',
	'globalblocking-dewhitelist-logentry' => 'slo på att global blokkering av [[$1]] lokalt',
	'globalblocking-modify-logentry' => 'endra den globale blokkeringa av [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'endar $1',
	'globalblocking-logentry-noexpiry' => 'endelaus blokkering',
	'globalblocklist' => 'Lista over IP-adresser blokkerte globalt',
	'globalblock' => 'Blokker ei IP-adressa globalt',
	'globalblockstatus' => 'Lokal status for globale blokkeringar',
	'removeglobalblock' => 'Fjern ei global blokkering',
	'right-globalblock' => 'Gjennomføra globale blokkeringar',
	'right-globalunblock' => 'Fjerna globale blokkeringar',
	'right-globalblock-whitelist' => 'Slå av globale blokkeringar lokalt',
);

/** Novial (Novial)
 * @author Malafaya
 */
$messages['nov'] = array(
	'globalblocking-unblock-reason' => 'Resone:',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permet]] lo blocatge de las adreças IP [[Special:GlobalBlockList|a travèrs maites wikis]]',
	'globalblocking-block' => 'Blocar globalament una adreça IP',
	'globalblocking-modify-intro' => 'Podètz utilizar aqueste formulari per configurar un blocatge global.',
	'globalblocking-block-intro' => 'Podètz utilizar aquesta pagina per blocar una adreça IP sus l’ensemble dels wikis.',
	'globalblocking-block-reason' => 'Motiu :',
	'globalblocking-block-otherreason' => 'Autra rason / rason suplementària :',
	'globalblocking-block-reasonotherlist' => 'Autra rason',
	'globalblocking-block-reason-dropdown' => '* Rasons comunas de blocatge
** Spam sus mantun wiki
** Abús sus mantun wiki
** Vandalisme',
	'globalblocking-block-edit-dropdown' => 'Modificar los motius de blocatge per defaut',
	'globalblocking-block-expiry' => 'Expiracion :',
	'globalblocking-block-expiry-other' => 'Autra durada d’expiracion',
	'globalblocking-block-expiry-otherfield' => 'Autra durada :',
	'globalblocking-block-legend' => 'Blocar globalament una adreça IP',
	'globalblocking-block-options' => 'Opcions :',
	'globalblocking-block-errors' => 'Lo blocatge a fracassat {{PLURAL:$1|pel motiu seguent|pels motius seguents}} :',
	'globalblocking-block-ipinvalid' => "L’adreça IP ($1) qu'avètz picada es incorrècta.
Notatz que podètz pas inscriure un nom d’utilizaire !",
	'globalblocking-block-expiryinvalid' => "L’expiracion qu'avètz picada ($1) es incorrècta.",
	'globalblocking-block-submit' => 'Blocar globalament aquesta adreça IP',
	'globalblocking-modify-submit' => 'Modificar aqueste blocatge global',
	'globalblocking-block-success' => 'L’adreça IP $1 es estada blocada amb succès sus l’ensemble dels projèctes.',
	'globalblocking-modify-success' => 'Lo blocatge global de $1 es estat modificat amb succès',
	'globalblocking-block-successsub' => 'Blocatge global capitat',
	'globalblocking-modify-successsub' => 'Blocatge global modificat amb succès',
	'globalblocking-block-alreadyblocked' => "L’adreça IP $1 ja es blocada globalament.
Podètz afichar los blocatges qu'existisson sus la tièra [[Special:GlobalBlockList|dels blocatges globals]], o tornar configurar aqueste blocatge en sosmetent aqueste formulari tornamai.",
	'globalblocking-block-bigrange' => "La plaja qu'avètz especificada ($1) es tròp granda per èsser blocada. Podètz pas blocar mai de 65'536 adreças (plajas en /16).",
	'globalblocking-list-intro' => 'Vaquí la lista de totes los blocatges globals actius. Qualques plajas son marcadas coma localament desactivadas : aquò significa que son aplicadas sus d’autres sites, mas qu’un administrator local a decidit de las desactivar sus aqueste wiki.',
	'globalblocking-list' => 'Tièra de las adreças IP blocadas globalament',
	'globalblocking-search-legend' => 'Recèrca d’un blocatge global',
	'globalblocking-search-ip' => 'Adreça IP :',
	'globalblocking-search-submit' => 'Recèrca dels blocatges',
	'globalblocking-list-ipinvalid' => 'L’adreça IP que recercatz per ($1) es incorrècta.
Picatz una adreça IP corrècta.',
	'globalblocking-search-errors' => 'Vòstra recèrca es estada infructuosa, {{PLURAL:$1|pel motiu seguent|pels motius seguents}} :',
	'globalblocking-list-blockitem' => "\$1 : <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') blocat globalament [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'expiracion $1',
	'globalblocking-list-anononly' => 'utilizaire non enregistrat unicament',
	'globalblocking-list-unblock' => 'desblocar',
	'globalblocking-list-whitelisted' => 'desactivat localament per $1 : $2',
	'globalblocking-list-whitelist' => 'estatut local',
	'globalblocking-list-modify' => 'modificar',
	'globalblocking-list-noresults' => "L'adreça IP demandada es pas blocada.",
	'globalblocking-goto-block' => 'Blocar globalament una adreça IP',
	'globalblocking-goto-unblock' => 'Levar un blocatge global',
	'globalblocking-goto-status' => "Modifica l'estatut local d’un blocatge global",
	'globalblocking-return' => 'Tornar a la lista dels blocatges globals',
	'globalblocking-notblocked' => "L’adreça IP ($1) qu'avètz inscricha es pas blocada globalament.",
	'globalblocking-unblock' => 'Levar un blocatge global',
	'globalblocking-unblock-ipinvalid' => "L’adreça IP ($1) qu'avètz picada es incorrècta.
Notatz que podètz pas inscriure un nom d’utilizaire !",
	'globalblocking-unblock-legend' => 'Levar un blocatge global',
	'globalblocking-unblock-submit' => 'Levar lo blocatge global',
	'globalblocking-unblock-reason' => 'Motiu :',
	'globalblocking-unblock-unblocked' => "Avètz capitat de levar lo blocatge global n° $2 correspondent a l’adreça IP '''$1'''",
	'globalblocking-unblock-errors' => 'Podètz pas levar un blocatge global per aquesta adreça IP {{PLURAL:$1|pel motiu seguent|pels motius seguents}} :
$1',
	'globalblocking-unblock-successsub' => 'Blocatge global levat amb succès',
	'globalblocking-unblock-subtitle' => 'Supression del blocatge global',
	'globalblocking-unblock-intro' => 'Podètz utilizar aqueste formulari per levar un blocatge global.',
	'globalblocking-whitelist' => 'Estatut local dels blocatges globals',
	'globalblocking-whitelist-notapplied' => "Los blocatges globals son pas aplicats a aqueste wiki,
d'aquel fach l'estatut local del blocatge global pòt pas èsser modificat.",
	'globalblocking-whitelist-legend' => "Cambiar l'estatut local",
	'globalblocking-whitelist-reason' => 'Motiu :',
	'globalblocking-whitelist-status' => 'Estatut local :',
	'globalblocking-whitelist-statuslabel' => 'Desactivar aqueste blocatge global sus {{SITENAME}}',
	'globalblocking-whitelist-submit' => "Cambiar l'estatut local",
	'globalblocking-whitelist-whitelisted' => "Avètz desactivat amb succès lo blocatge global n° $2 sus l'adreça IP '''$1''' sus {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Avètz reactivat amb succès lo blocatge global n° $2 sus l'adreça IP '''$1''' sus {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Estatut local cambiat amb succès',
	'globalblocking-whitelist-nochange' => "Avètz pas modificat l'estatut local d'aqueste blocatge.
[[Special:GlobalBlockList|Tornar a la lista globala dels blocatges]].",
	'globalblocking-whitelist-errors' => "Vòstra modificacion de l'estatut local d’un blocage global a pas capitat {{PLURAL:$1|pel motiu seguent|pels motius seguents}} :",
	'globalblocking-whitelist-intro' => "Podètz utilizar aqueste formulari per modificar l'estatut local d’un blocatge global. Se un blocatge global es desactivat sus aqueste wiki, los utilizaires concernits per l’adreça IP poiràn editar normalament. [[Special:GlobalBlockList|Clicatz aicí]] per tornar a la lista globala.",
	'globalblocking-blocked' => "Vòstra adreça IP es estada blocada sus l’ensemble dels wiki per '''$1''' (''$2'').
Lo motiu indicat èra « $3 ». La plaja ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Podètz pas tornar inicializar los senhals d’utilizaire perque sètz blocat(ada) globalament.',
	'globalblocking-logpage' => 'Jornal dels blocatges globals',
	'globalblocking-logpagetext' => 'Vaquí un jornal dels blocatges globals que son estats faches e revocats sus aqueste wiki.
Deuriá èsser relevat que los blocatges globals pòdon èsser faches o anullats sus d’autres wikis, e que losdiches blocatges globals son de natura a interferir sus aqueste wiki.
Per visionar totes los blocatges globals actius, podètz visitar la [[Special:GlobalBlockList|lista dels blocatges globals]].',
	'globalblocking-block-logentry' => '[[$1]] blocat globalament amb una durada d’expiracion de $2',
	'globalblocking-block2-logentry' => 'a blocat globalament [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'blocatge global levat sus [[$1]]',
	'globalblocking-whitelist-logentry' => 'a desactivat localament lo blocatge global de [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'a tornat activar localament lo blocatge global de [[$1]]',
	'globalblocking-modify-logentry' => 'a modificat lo blocatge global de [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'expira lo $1',
	'globalblocking-logentry-noexpiry' => "data d'expiracion pas especificada",
	'globalblocking-loglink' => "L'adreça IP $1 es blocada globalament ([[{{#Special:GlobalBlockList}}/$1|detalhs]]).",
	'globalblocking-showlog' => 'Aquesta adreça IP es estada blocada anteriorament.
Lo jornal dels blocatges es disponible çaijós :',
	'globalblocklist' => 'Tièra de las adreças IP blocadas globalament',
	'globalblock' => 'Blocar globalament una adreça IP',
	'globalblockstatus' => 'Estatuts locals dels blocatges globals',
	'removeglobalblock' => 'Suprimir un blocatge global',
	'right-globalblock' => "Blocar d'utilizaires globalament",
	'right-globalunblock' => "Desblocar d'utilizaires blocats globalament",
	'right-globalblock-whitelist' => 'Desactivar localament los blocatges globals',
	'right-globalblock-exempt' => 'Passar otra los blocatges globals',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlockList|ବହୁ ଉଇକିରେ ଅଟକାଯିବାକୁ]] IP ଠିକଣାମାନଙ୍କୁ [[Special:GlobalBlock|ସଚଳ କରାଇବେ]]',
	'globalblocking-block' => 'ଏହି IP ଠିକଣାଟି ଜଗତଯାକ ଉଇକିରେ ଅଟକାଇ ଦେବେ',
	'globalblocking-modify-intro' => 'ଏହି ଜଗତ ଅଟକକୁ ବଦଳାଇବା ନିମନ୍ତେ ଆପଣ ଏହି ଫର୍ମଟି ବ୍ୟବହାର କରିପାରିବେ ।',
	'globalblocking-block-intro' => 'ସବୁ ଉଇକିରେ ଆପଣ ଏହ ଇପୃଷ୍ଠା ବ୍ୟବହାର କରି ଏକ IP ଠିକଣାକୁ ଅଟକାଇପାରିବେ ।',
	'globalblocking-block-reason' => 'କାରଣ:',
	'globalblocking-block-otherreason' => 'ବାକି/ଅଧିକ କାରଣ:',
	'globalblocking-block-reasonotherlist' => 'ଅଲଗା କାରଣ',
	'globalblocking-block-reason-dropdown' => '* ସାଧାରଣ ଅଟକ କାରଣ
** ଅଲଗା ଅଲଗା ଉଇକିରେ ସ୍ପାମିଙ୍ଗ
** ଅଲଗା ଅଲଗା ଉଇକିରେ ଅପବ୍ୟବହାର
** ବର୍ବରତା',
	'globalblocking-block-edit-dropdown' => 'ସମ୍ପାଦନା ଅଟକ କାରଣମାନ',
	'globalblocking-block-expiry' => 'ମିଆଦ:',
	'globalblocking-block-expiry-other' => 'ବାକି ମିଆଦ ସମୟ',
	'globalblocking-block-expiry-otherfield' => 'ବାକି ସମୟ:',
	'globalblocking-block-legend' => 'ଏକ IP ଠିକଣାକୁ ଜଗତ ସାରା ଅଟକାଇ ଦେବେ',
	'globalblocking-block-options' => 'କାମସବୁ:',
	'globalblocking-ipaddress' => 'ଆଇ.ପି. ଠିକଣା:',
	'globalblocking-ipbanononly' => 'କେବଳ ବେନାମି ସଭ୍ୟଙ୍କୁ ଅଟକାଇଦିଅନ୍ତୁ',
	'globalblocking-block-errors' => 'ତଳଲିଖିତ {{PLURAL:$1|ଗୋଟିଏ କାରଣ|ଗୋଟି କାରଣ}} ନିମନ୍ତେ  ଆପଣଙ୍କ ଦେଇ କରାଯାଇଥିବା ଅଟକ ବିଫଳ ହେଲା:',
	'globalblocking-block-ipinvalid' => 'ଆପଣ ଦେଇଥିବା IP ଠିକଣାଟି ($1) ଭୁଲ ଅଟେ ।
ଜାଣିରଖନ୍ତୁ ଯେ ଆପଣ ଏକ ଇଉଜର ନାମ ଦେଇପାରିବେ ନାହିଁ !',
	'globalblocking-block-expiryinvalid' => 'ଆପଣ ଦେଇଥିବା ମିଆଦଟି ($1) କାମ କରୁନାହିଁ।',
	'globalblocking-block-submit' => 'ଏକ IP ଠିକଣାକୁ ଜଗତ ସାରା ଅଟକାଇ ଦେବେ',
	'globalblocking-modify-submit' => 'ଜଗତ ଯାକ ଅଟକକୁ ବଦଳାଇବେ',
	'globalblocking-block-success' => 'ଏହି IP ଠିକଣା ($1 )ଟି ସଫଳ ଭାବରେ ସବୁ ପ୍ରକଳ୍ପରେ ଅଟକାଇଦିଆଗଲା ।',
	'globalblocking-modify-success' => '$1 ଉପରେ ଥିବା ଜଗତ ସାରା ଅଟକ ସଫଳ ଭାବରେ ବଦଳାଗଲା',
	'globalblocking-block-successsub' => 'ଜଗତ ସାରା ଅଟକ ସଫଳ ହେଲା',
	'globalblocking-modify-successsub' => 'ସଫଳଭାବରେ ଜଗତ ସାରା ଅଟକାଇବା ସଫଳ ହେଲା',
	'globalblocking-block-alreadyblocked' => '$1 IP ଠିକଣାଟି ଜଗତଯାକ ଅଟକାଯାଇଛି ।
ଆପଣ ଏବେକାର ଅଟକ [[Special:GlobalBlockList|ଜଗତ ବାସନ୍ଦ ତାଲିକା]]ରୁ ଦେଖିପାରିବେ
ଅବା ଏବେକାର ଜଗତ ଅଟକ ସଜାଣି ବଦଳାଇ ଆଉଥରେ ଆବେଦନ କରିପାରିବେ ।',
	'globalblocking-block-bigrange' => 'ଆପଣ ଦେଇଥିବା ସୀମା ($1) ଅଟକାଇବା ପାଇଁ ଖୁବ ବଡ଼ ବୋଲି ବୋଧ ହୁଏ ।
ଆପଣ ସବୁଠାରୁ ଅଧିକ ହେଲେ, ୬୫, ୫୩୬ ଗୋଟି ଠିକଣା ଅଟକାଇ ପାରିବେ (/୧୬ ଗୋଟି ସୀମା)',
	'globalblocking-list-intro' => 'ଅଧୁନା ସଚଳ ଥିବା ସବୁଯାକ ଜଗତ ବାସନ୍ଦର ତାଲିକା ।
କେତେକ ବାସନ୍ଦ ଆଞ୍ଚଳିକ ଭାବେ ଅଚଳ କରାଯାଇଛି ବୋଲି ଚିହ୍ନିତ: ଅର୍ଥାତ ସେହି ବାସନ୍ଦ ବାକି ସବୁ ଉଇକି ପାଇଁ ଲାଗୁ ହେବ, କିନ୍ତୁ ଜଣେ ଆଞ୍ଚଳିକ ପରିଛା ତାହାକୁ ଏହି ଉଇକିରେ ଅଚଳ କରିବାକୁ ସିଦ୍ଧାନ୍ତ ନେଇଛନ୍ତି ।',
	'globalblocking-list' => 'ଜଗତ ସାରା ଅଟକାଯାଇଥିବା IP ଠିକଣାର ତାଲିକା',
	'globalblocking-search-legend' => 'ଜଗତ ସାରା ଥିବା ଅଟକ ପାଇଁ ଖୋଜିବେ',
	'globalblocking-search-ip' => 'ଆଇ.ପି. ଠିକଣା:',
	'globalblocking-search-submit' => 'ଅଟକ ପାଇଁ ଖୋଜିବେ',
	'globalblocking-list-ipinvalid' => 'ଆପଣ ଖୋଜିଥିବା IP ଠିକଣା ($1)ଟି ଭୁଲ ଅଟେ ।
ଏକ ସଚଳ IP ଠିକଣା ଦିଅନ୍ତୁ ।',
	'globalblocking-search-errors' => 'ତଳଲିଖିତ {{PLURAL:$1|ଗୋଟିଏ କାରଣ|ଗୋଟି କାରଣ}} ନିମନ୍ତେ  ଆପଣଙ୍କର ଖୋଜିବା ବିଫଳ ହେଲା:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') [[Special:Contributions/\$4|\$4]] ''(\$5)''ଙ୍କୁ ଜଗତ ସାରା ଅଟକାଗଲା",
	'globalblocking-list-expiry' => '$1ରେ ଅଚଳ ହୋଇଯିବ',
	'globalblocking-list-anononly' => 'କେବଳ ବେନାମି',
	'globalblocking-list-unblock' => 'କାଢ଼ିଦେବେ',
	'globalblocking-list-whitelisted' => ' $1ଙ୍କ ଦେଇ ସ୍ଥାନୀୟ ଭାବେ ଅଚଳ କରାଯାଇଅଛି: $2',
	'globalblocking-list-whitelist' => 'ସ୍ଥାନୀୟ ସ୍ଥିତି',
	'globalblocking-list-modify' => 'ରୂପାନ୍ତର କରିବେ',
	'globalblocking-list-noresults' => 'ଅନୁରୋଧ କରାଯାଇଥିବା IP ଠିକଣାଟି ଅଟକାଗଲା ନାହିଁ ।',
	'globalblocking-goto-block' => 'ଏକ IP ଠିକଣାଟିକୁ ଜଗତଯାକ ଉଇକିରେ ଅଟକାଇ ଦେବେ',
	'globalblocking-goto-unblock' => 'ଏକ ଜଗତ ସାରାର ଅଟକକୁ ହଟାଇଦେବେ',
	'globalblocking-goto-status' => 'ଏକ ଜଗତ ସାରାରର ଅଟକର ସ୍ଥିତିକୁ ବଦଳାଇବେ',
	'globalblocking-return' => 'ଜଗତ ସାରାର ଅଟକସବୁର ତାଲିକା ଫେରିଯିବେ',
	'globalblocking-notblocked' => 'ଆପଣ ଦେଇଥିବା IP ଠିକଣା ($1)ଟି ଜଗତ ଯାକ ଅଟକଯାଇନାହିଁ ।',
	'globalblocking-unblock' => 'ଏକ ଜଗତ ସାରାର ଅଟକକୁ ହଟାଇଦେବେ',
	'globalblocking-unblock-ipinvalid' => 'ଆପଣ ଦେଇଥିବା IP ଠିକଣାଟି ($1) ଭୁଲ ଅଟେ ।
ଜାଣିରଖନ୍ତୁ ଯେ ଆପଣ ଏକ ଇଉଜର ନାମ ଦେଇପାରିବେ ନାହିଁ !',
	'globalblocking-unblock-legend' => 'ଏକ ଜଗତ ସାରାର ଅଟକକୁ ହଟାଇଦେବେ',
	'globalblocking-unblock-submit' => 'ଏକ ଜଗତ ସାରାର ଅଟକକୁ ହଟାଇଦେବେ',
	'globalblocking-unblock-reason' => 'କାରଣ:',
	'globalblocking-unblock-unblocked' => "'''$1''' IP ଠିକଣା ଉପରେ ଲାଗିଥିବା ଜଗତ ବାସନ୍ଦ #$2କୁ ଆପଣ ସଫଳ ଭାବେ ଉଠାଇ ଦେଲେ",
	'globalblocking-unblock-errors' => 'ତଳଲିଖିତ {{PLURAL:$1|ଗୋଟିଏ କାରଣ|ଗୋଟି କାରଣ}} ନିମନ୍ତେ  ଆପଣଙ୍କର ଜଗତ ବାସନ୍ଦ ହଟାଇବା ବିଫଳ ହେଲା:',
	'globalblocking-unblock-successsub' => 'ଜଗତ ବାସନ୍ଦ ସଫଳ ଭାବେ ହଟାଇଦିଆଗଲା',
	'globalblocking-unblock-subtitle' => 'ଜଗତ ବାସନ୍ଦ ହଟାଉଛୁଁ',
	'globalblocking-unblock-intro' => 'ଆପଣ ଏକ ଜଗତ ବାସନ୍ଦ ଉଠାଇବେ ନିମନ୍ତେ ଏହି ଫର୍ମର ବ୍ୟବହାର କରିପାରିବେ ।',
	'globalblocking-whitelist' => 'ଜଗତ ବାସନ୍ଦର ଆଞ୍ଚଳିକ ସ୍ଥିତି',
	'globalblocking-whitelist-notapplied' => 'ଏହି ଉଇକି ପାଇଁ ଜଗତ ବାସନ୍ଦ ଲାଗୁ ହେବ ନାହିଁ,
ତେଣୁ ଜଗତ ବାସନ୍ଦର ଆଞ୍ଚଳିକ ସ୍ଥିତି ବଦଳାଯାଇପାରିବ ନାହିଁ ।',
	'globalblocking-whitelist-legend' => 'ଆଞ୍ଚଳିକ ସ୍ଥିତି ବଦଳାଇବେ',
	'globalblocking-whitelist-reason' => 'କାରଣ:',
	'globalblocking-whitelist-status' => 'ସ୍ଥାନୀୟ ସ୍ଥିତି:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} ସାଇଟ ଉପରେ ଲାଗିଥିବା ଜଗତ ବାସନ୍ଦ ଉଠାଇଦେବେ',
	'globalblocking-whitelist-submit' => 'ଆଞ୍ଚଳିକ ସ୍ଥିତି ବଦଳାଇବେ',
	'globalblocking-whitelist-whitelisted' => "'''$1''' IP ଠିକଣା ଉପରେ ଲାଗିଥିବା {{SITENAME}}ର ଜଗତ ବାସନ୍ଦ #$2କୁ ଆପଣ ସଫଳ ଭାବେ ଅଚଳ କରିଦେଲେ ।",
	'globalblocking-whitelist-dewhitelisted' => "'''$1''' IP ଠିକଣା ଉପରେ ଲାଗିଥିବା {{SITENAME}}ର ଜଗତ ବାସନ୍ଦ #$2କୁ ଆପଣ ସଫଳ ଭାବେ ଆଉଥରେ ସଚଳ କରିଦେଲେ ।",
	'globalblocking-whitelist-successsub' => 'ଆଞ୍ଚଳିକ ସ୍ଥିତି ସଫଳ ଭାବେ ବଦଳାଇ ଦେଲେ',
	'globalblocking-whitelist-nochange' => 'ଏହି ବାସନ୍ଦରେ ଆପଣ ଆଞ୍ଚଳିକ ସ୍ଥିତିରେ କିଛି ବି ବଦଳାଇଲେ ନାହିଁ ।
[[Special:GlobalBlockList|ଜଗତ ବାସନ୍ଦ ତାଳିକାକୁ ଫେରିଯିବେ]] ।',
	'globalblocking-whitelist-errors' => 'ତଳଲିଖିତ {{PLURAL:$1|ଗୋଟିଏ କାରଣ|ଗୋଟି କାରଣ}} ନିମନ୍ତେ  ଆପଣଙ୍କର ଜଗତ ବାସନ୍ଦର ଆଞ୍ଚଳିକ ସ୍ଥିତି ବଦଳାଇବା ବିଫଳ ହେଲା:',
	'globalblocking-whitelist-intro' => 'ଆପଣ ଏହି ଫର୍ମଟି ଜଗତ ବାସନ୍ଦର ଆଞ୍ଚଳିକ ଅବସ୍ଥା ବଦଳାଇବାକୁ ବ୍ୟବହାର କରିପାରିବେ ।
ଯଦି ଏହି ଉଇକିରେ ଜଗତ ବାସନ୍ଦଟି ଅଚଳ ହୋଇଥାଏ ତେବେ ପ୍ରଭାବିତ IP  ଠିକଣାର ସଭ୍ୟଗଣ ଏହାକୁ ସାଧାରଣ ଭାବରେ ସମ୍ପାଦନ କରିପାରିବେ ।
[[Special:GlobalBlockList|ଜଗତ ବାସନ୍ଦ ତାଲିକାକୁ ଫେରିବା]] ।',
	'globalblocking-blocked' => "ଆପଣଙ୍କ IP ଠିକଣା \$5 ଟି ସବୁଯାକ ଉଇକିରେ '''\$1''' (''\$2'')ଙ୍କ ଦେଇ ଅଟକାଯାଇଛି ।
ଅଟକାଇବାର କାରଣ ''\"\$3\"'' ବୋଲି ଦିଆଯାଇଛି ।
ବାସନ୍ଦ IP ଠିକଣା ''\$4'' ।",
	'globalblocking-blocked-nopassreset' => 'ଆପଣଙ୍କୁ ଜଗତଯାକ ବାସନ୍ଦ କରାଯାଇଥିବାରୁ ଆପଣ ନିଜର ସଭ୍ୟ ପାସବାର୍ଡ଼ ବଦଳାଇପାରିବେ ନାହିଁ ।',
	'globalblocking-logpage' => 'ଜଗତ ଅଟକ ଇତିହାସ',
	'globalblocking-logpagetext' => 'ଏହା ଜଗତ ବାସନ୍ଦର ଏକ ତାଲିକା ଯାହା ଏହି ଉଇକିରେ ହୋଇଥିଲା ଓ ପରେ ଉଠାଇ ଦିଆଯାଇଥିଲା ।
ଜାଣିରଖନ୍ତୁ ଯେ ଜଗତ ବାସନ୍ଦସବୁ ବାକି ଉଇକିରେ ତିଆରି କରାଯାଇପାରିବ ଓ  ଓଠାଯାଇପାରିବ ଓ ଏହି ଜଗତ ବାସନ୍ଦ ଆଞ୍ଚଳିକ ଉଇକିକୁ ପ୍ରଭାବିତ କରିପାରେ ।
ସବୁଯାକ ଜଗତ ବାସନ୍ଦକୁ ଦେଖିବା ନିମନ୍ତେ ଆପଣ [[Special:GlobalBlockList|ଜଗତ ବାସନ୍ଦ ତାଲିକା]] ଦେଖିପାରିବେ ।',
	'globalblocking-block-logentry' => '[[$1]]ଙ୍କୁ ବିଶ୍ଵ ସାରା ଅଟକାଯାଇଛି ଯାହା $2 ପରେ ସଚଳ ହେବ',
	'globalblocking-block2-logentry' => '[[$1]] ଙ୍କୁ ବିଶ୍ଵ ସାରା ଅଟକାଇଦିଆଗଲା ($2)',
	'globalblocking-unblock-logentry' => '[[$1]]ଙ୍କ ଉପରେ ଥିବା ବିଶ୍ଵ ଅଟକକୁ ହଟାଇ ଦିଆଗଲା',
	'globalblocking-whitelist-logentry' => '[[$1]]ଙ୍କ ଉପରେ ଥିବା ବିଶ୍ଵ ଅଟକକୁ ସ୍ଥାନୀୟ ଭାବରେ ଅଚଳ କରିଦିଆଗଲା',
	'globalblocking-dewhitelist-logentry' => '[[$1]]ଙ୍କ ଉପରେ ଥିବା ବିଶ୍ଵ ଅଟକକୁ ସ୍ଥାନୀୟ ଭାବରେ ଆଉଥରେ ସଚଳ କରାଗଲା',
	'globalblocking-modify-logentry' => '[[$1]]ଙ୍କ ଉପରେ ଥିବା ବିଶ୍ଵ ଅଟକକୁ ବଦଳଗଲା ($2)',
	'globalblocking-logentry-expiry' => '$1ରେ ଅଚଳ ହୋଇଯିବ',
	'globalblocking-logentry-noexpiry' => 'ଅଚଳହେବା ଗୋଠ ନାହିଁ',
	'globalblocking-loglink' => '$1 ଙ୍କ IP ଠିକଣା ବିଶ୍ଵସାରା ଅଟକାଯାଇଛି ([[{{#Special:GlobalBlockList}}/$1|ସବିଶେଷ]]).',
	'globalblocking-showlog' => 'ଏହି IP ଠିକଣାଟି ଆଗରୁ ଅଟକାଯାଇଅଛି ।
ତଳେ ଅଟକ ଇତିହାସ ଅବଗତି ନିମନ୍ତେ ଦିଆଗଲା:',
	'globalblocklist' => 'ଜଗତ ସାରା ଅଟକାଯାଇଥିବା IP ଠିକଣାର ତାଲିକା',
	'globalblock' => 'ଏହି IP ଠିକଣାଟି ଜଗତଯାକ ଉଇକିରେ ଅଟକାଇ ଦେବେ',
	'globalblockstatus' => 'ଜଗତ ବାସନ୍ଦର ଆଞ୍ଚଳିକ ସ୍ଥିତି',
	'removeglobalblock' => 'ଏକ ଜଗତ ଯାକର ଅଟକକୁ ହଟାଇଦେବେ',
	'right-globalblock' => 'ଜଗତ ଯାକ ବାସନ୍ଦ କରିବେ',
	'right-globalunblock' => 'ଏକ ଜଗତ ଯାକର ବାସନ୍ଦକୁ ହଟାଇଦେବେ',
	'right-globalblock-whitelist' => 'ଜଗତ ବାସନ୍ଦକୁ ଆଞ୍ଚଳିକ ଭାବରେ ଅଚଳ କରିବେ',
	'right-globalblock-exempt' => 'ଜଗତ ଯାକ ବାସନ୍ଦକୁ ଅଲଗା ପଥଗାମୀ କରିବେ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'globalblocking-block-expiry-otherfield' => 'Æндæр рæстæг:',
	'globalblocking-block-alreadyblocked' => 'IP-адрис $1 раздæр хъодыгонд æрцыд глобалонæй. Фен [[Special:GlobalBlockList|глобалон хъодыты номхыгъд]].',
	'globalblocking-unblock' => 'Аиуварс кæн глобалон хъоды',
	'globalblocking-unblock-submit' => 'Аиуварс кæн глобалон хъоды',
	'globalblocking-unblock-reason' => 'Аххос:',
	'globalblocking-unblock-errors' => 'Глобалон хъоды аиуварс кæнын нæ бантысти. {{PLURAL:$1|Аххос|Аххостæ}}:',
	'removeglobalblock' => 'Аиуварс кæн глобалон хъоды',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'globalblocking-block-reason' => 'Grund:',
	'globalblocking-block-reasonotherlist' => 'Annerer Grund',
	'globalblocking-block-expiry-otherfield' => 'Annere Zeit:',
	'globalblocking-list-modify' => 'ennere',
	'globalblocking-unblock-reason' => 'Grund:',
	'globalblocking-whitelist-reason' => 'Grund:',
	'globalblocking-logentry-expiry' => 'bis $1',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Lampak
 * @author Leinad
 * @author Nux
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Umożliwia]] równoczesne [[Special:GlobalBlockList|blokowanie]] adresów IP na wielu wiki',
	'globalblocking-block' => 'Zablokuj globalnie adres IP',
	'globalblocking-modify-intro' => 'Możesz użyć tego formularza, aby zmienić ustawienia globalnej blokady.',
	'globalblocking-block-intro' => 'Na tej stronie możesz blokować adresy IP na wszystkich wiki.',
	'globalblocking-block-reason' => 'Powód',
	'globalblocking-block-otherreason' => 'Inny lub dodatkowy powód',
	'globalblocking-block-reasonotherlist' => 'Inny powód',
	'globalblocking-block-reason-dropdown' => '* Najczęstsze powody blokad** Spamowanie w wielu projektach** Nadużycia w wielu projektach** Wandalizm',
	'globalblocking-block-edit-dropdown' => 'Edytuj listę przyczyn blokady',
	'globalblocking-block-expiry' => 'Upływa',
	'globalblocking-block-expiry-other' => 'Inny czas blokady',
	'globalblocking-block-expiry-otherfield' => 'Inny czas blokady',
	'globalblocking-block-legend' => 'Zablokuj globalnie adres IP',
	'globalblocking-block-options' => 'Opcje:',
	'globalblocking-ipaddress' => 'Adres IP',
	'globalblocking-ipbanononly' => 'Blokuj wyłącznie niezalogowanych użytkowników',
	'globalblocking-block-errors' => 'Zablokowanie nie powiodło się z {{PLURAL:$1|następującego powodu|następujących powodów}}:',
	'globalblocking-block-ipinvalid' => 'Wprowadzony przez Ciebie adres IP ($1) jest nieprawidłowy.
Zwróć uwagę na to, że nie możesz wprowadzić nazwy użytkownika!',
	'globalblocking-block-expiryinvalid' => 'Czas obowiązywania blokady ($1) jest nieprawidłowy.',
	'globalblocking-block-submit' => 'Zablokuj ten adres IP globalnie',
	'globalblocking-modify-submit' => 'Zmień tę globalną blokadę',
	'globalblocking-block-success' => 'Adres IP $1 został zablokowany na wszystkich projektach.',
	'globalblocking-modify-success' => 'Globalna blokada dla $1 została zmieniona',
	'globalblocking-block-successsub' => 'Globalna blokada założona',
	'globalblocking-modify-successsub' => 'Blokada globalna została zmieniona',
	'globalblocking-block-alreadyblocked' => 'Adres IP $1 jest obecnie zablokowany globalnie.
Możesz przejrzeć aktualnie obowiązujące blokady w [[Special:GlobalBlockList|spisie globalnych blokad]]
lub zmienić ustawienia istniejącej blokady poprzez zapisanie tego formularza.',
	'globalblocking-block-bigrange' => 'Podany przez Ciebie zakres ($1) jest za duży by mógł zostać zablokowany.
Możesz zablokować nie więcej niż 65536 adresów (maska 16 bitów)',
	'globalblocking-list-intro' => 'Poniżej znajduje się lista wszystkich obecnie nałożone globalnych blokad.
Niektóre blokady zostały oznaczone jako odblokowane lokalnie – oznacza to, że jeden z lokalnych administratorów zdecydował się zdjąć blokadę na tej wiki, ale wciąż obowiązuje ona na innych projektach.',
	'globalblocking-list' => 'Spis globalnie zablokowanych adresów IP',
	'globalblocking-search-legend' => 'Szukaj globalnej blokady',
	'globalblocking-search-ip' => 'Adres IP',
	'globalblocking-search-submit' => 'Szukaj blokad',
	'globalblocking-list-ipinvalid' => 'Adres IP którego szukasz ($1) jest nieprawidłowy.
Wprowadź poprawny adres.',
	'globalblocking-search-errors' => 'Wyszukiwanie nie powiodło się z {{PLURAL:$1|następującego powodu|następujących powodów}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') globalnie zablokował [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'wygaśnie $1',
	'globalblocking-list-anononly' => 'tylko niezalogowani',
	'globalblocking-list-unblock' => 'odblokowanie',
	'globalblocking-list-whitelisted' => 'lokalnie zniesiona przez $1: $2',
	'globalblocking-list-whitelist' => 'status lokalny',
	'globalblocking-list-modify' => 'zmień',
	'globalblocking-list-noresults' => 'Podany adres IP nie jest zablokowany.',
	'globalblocking-goto-block' => 'Globalnie zablokuj adres IP',
	'globalblocking-goto-unblock' => 'Zdejmij globalną blokadę',
	'globalblocking-goto-status' => 'Zmień lokalny status globalnej blokady',
	'globalblocking-return' => 'Powrót do listy globalnych blokad',
	'globalblocking-notblocked' => 'Podany adres IP ($1) nie jest globalnie zablokowany.',
	'globalblocking-unblock' => 'Zdejmij globalną blokadę',
	'globalblocking-unblock-ipinvalid' => 'Wprowadzony przez Ciebie adres IP ($1) jest nieprawidłowy.
Zwróć uwagę na to, że nie możesz wprowadzić nazwy użytkownika!',
	'globalblocking-unblock-legend' => 'Zdejmowanie globalnej blokady',
	'globalblocking-unblock-submit' => 'Zdejmij globalną blokadę',
	'globalblocking-unblock-reason' => 'Powód',
	'globalblocking-unblock-unblocked' => "{{GENDER:|Zdjąłeś globalną blokadę|Zdjęłaś globalną blokadę|Globalna blokada}} numer $2 dla adresu IP '''$1'''{{GENDER:|||&#32;została zdjęta}}",
	'globalblocking-unblock-errors' => 'Nie udało się zdjąć globalnej blokady z {{PLURAL:$1|poniższego powodu|poniższych powodów}}:',
	'globalblocking-unblock-successsub' => 'Globalna blokada została zdjęta',
	'globalblocking-unblock-subtitle' => 'Zdejmowanie globalnej blokady',
	'globalblocking-unblock-intro' => 'Za pomocą tego formularza możesz zdjąć globalną blokadę.',
	'globalblocking-whitelist' => 'Lokalny status globalnych blokad',
	'globalblocking-whitelist-notapplied' => 'Globalne blokady nie obowiązują na tej wiki,
więc lokalny status globalnej blokady nie może być zmieniony.',
	'globalblocking-whitelist-legend' => 'Zmień lokalny status',
	'globalblocking-whitelist-reason' => 'Powód',
	'globalblocking-whitelist-status' => 'Lokalny status:',
	'globalblocking-whitelist-statuslabel' => 'Znieś tę globalną blokadę na {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Zmień lokalny status',
	'globalblocking-whitelist-whitelisted' => "Wyłączyłeś na {{GRAMMAR:MS.lp|{{SITENAME}}}} stosowanie globalnej blokady $2 dla adresu IP '''$1'''.",
	'globalblocking-whitelist-dewhitelisted' => "Uruchomiłeś ponownie na {{GRAMMAR:MS.lp|{{SITENAME}}}} globalną blokadę $2 dla adresu IP '''$1'''.",
	'globalblocking-whitelist-successsub' => 'Status lokalny blokady został zmieniony',
	'globalblocking-whitelist-nochange' => 'Nie wprowadzono żadnych zmian do lokalnego statusu tej blokady.
[[Special:GlobalBlockList|Powrót do spisu globalnie zablokowanych adresów IP]].',
	'globalblocking-whitelist-errors' => 'Twoja zmiana lokalnego statusu globalnej blokady nie powiodła się z {{PLURAL:$1|następującej przyczyny|następujących przyczyn}}:',
	'globalblocking-whitelist-intro' => 'Możesz użyć tego formularza do lokalnego odblokowania globalnie nałożonej blokady.
Jeśli globalna blokada zostanie zdjęta na tej wiki, użytkownicy będą mogli normalnie edytować z odblokowanego adresu IP.
[[Special:GlobalBlockList|Powrót do spisu globalnie zablokowanych adresów IP]].',
	'globalblocking-blocked' => "Twój adres IP $5 został zablokowany we wszystkich wiki przez '''$1''' (''$2'').
Przyczyna blokady ''„$3”''.
Blokada ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Nie możesz resetować haseł użytkowników, ponieważ zostałeś zablokowany globalnie.',
	'globalblocking-logpage' => 'Rejestr globalnych blokad',
	'globalblocking-logpagetext' => 'To jest rejestr globalnych blokad, które zostały nałożone i zdjęte na tej wiki.
Należy mieć na uwadze, że globalne blokady mogą być nakładane i zdejmowane na innych wiki i ich działanie obejmuje także tę wiki.
Wszystkie aktywne globalne blokady można zobaczyć w [[Special:GlobalBlockList|spisie globalnie zablokowanych adresów IP]].',
	'globalblocking-block-logentry' => 'zablokował globalnie [[$1]], czas blokady $2',
	'globalblocking-block2-logentry' => 'zablokował globalnie [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'zdjął globalną blokadę z [[$1]]',
	'globalblocking-whitelist-logentry' => 'wyłączył lokalne stosowanie globalnej blokady dla [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'ponownie uaktywnił lokalnie globalną blokadę dla [[$1]]',
	'globalblocking-modify-logentry' => 'zmienił blokadę globalną dla [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'wygasa $1',
	'globalblocking-logentry-noexpiry' => 'wygaśnięcie nie ustalone',
	'globalblocking-loglink' => 'Adres IP $1 jest zablokowany globalnie ([[{{#Special:GlobalBlockList}}/$1|pełny opis]]).',
	'globalblocking-showlog' => 'Ten adres IP był wcześniej blokowany.
Poniżej znajduje się rejestr blokad:',
	'globalblocklist' => 'Spis globalnie zablokowanych adresów IP',
	'globalblock' => 'Zablokuj globalnie adres IP',
	'globalblockstatus' => 'Lokalny status globalnych blokad',
	'removeglobalblock' => 'Usuwanie globalnej blokady',
	'right-globalblock' => 'Zakładanie globalnych blokad',
	'right-globalunblock' => 'Zdejmowanie globalnych blokad',
	'right-globalblock-whitelist' => 'Lokalne odblokowywanie globalnych blokad',
	'right-globalblock-exempt' => 'Ignorowanie globalnych blokad',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'globalblocking-desc' => "[[Special:GlobalBlock|A përmët]] che dj'adrësse IP a sio [[Special:GlobalBlockList|blocà su vàire wiki]]",
	'globalblocking-block' => "Blòca globalment n'adrëssa IP:",
	'globalblocking-modify-intro' => "A peul dovré sto formolari-sì për cangé j'ampostassion d'un blocagi global.",
	'globalblocking-block-intro' => "It peule dovré sta pàgina-sì për bloché n'adrëssa IP su tute le wiki.",
	'globalblocking-block-reason' => 'Rason:',
	'globalblocking-block-otherreason' => 'Rason àutra/adissional:',
	'globalblocking-block-reasonotherlist' => 'Àutra rason',
	'globalblocking-block-reason-dropdown' => '* Rason sòlite ëd blocagi
** Rumenta tra wiki
** Abus tra wiki
** Vandalism',
	'globalblocking-block-edit-dropdown' => 'Motiv dël blocagi',
	'globalblocking-block-expiry' => 'Fin:',
	'globalblocking-block-expiry-other' => 'Àutr temp ëd fin',
	'globalblocking-block-expiry-otherfield' => 'Àutr temp:',
	'globalblocking-block-legend' => "Blòca n'adrëssa IP globalment",
	'globalblocking-block-options' => 'Opsion:',
	'globalblocking-ipaddress' => 'Adrëssa IP:',
	'globalblocking-ipbanononly' => "Blòca mach j'utent anònim",
	'globalblocking-block-errors' => "Sò blocagi a l'é pa andàit bin, për {{PLURAL:$1|la rason|le rason}} sì-sota:",
	'globalblocking-block-ipinvalid' => "L'adrëssa IP ($1) ch'a l'ha butà a l'é pa bon-a.
Për piasì, ch'a nòta ch'a peul pa anserì un nòm utent!",
	'globalblocking-block-expiryinvalid' => "La durà ch'a l'has anserì ($1) a va nen bin.",
	'globalblocking-block-submit' => "Blòca st'adrëssa IP-sì globalment.",
	'globalblocking-modify-submit' => 'Modifiché sto blocagi global',
	'globalblocking-block-success' => "L'adrëssa IP $1 a l'é stàita blocà da bin dzora tùit ij proget.",
	'globalblocking-modify-success' => "Ël blocagi global ëd $1 a l'é stàit modificà da bin",
	'globalblocking-block-successsub' => 'Blocagi global andàit bin',
	'globalblocking-modify-successsub' => 'Blocagi global modificà da bin',
	'globalblocking-block-alreadyblocked' => "L'adrëssa IP $1 a l'é già blocà globalment.
A peule vëdde ël blocagi esistent an sla [[Special:GlobalBlockList|lista dij blocagi globaj]],
o modifiché j'ampostassion dij blocagi esistent an spedend torna cost formolari.",
	'globalblocking-block-bigrange' => "L'antërval ch'a l'ha spessificà ($1) a l'é tròp gròss da bloché.
A peul bloché, al pi, 65.536 adrësse (/16 antërvaj)",
	'globalblocking-list-intro' => "Costa-sì a l'é na lista ëd tùit ij blocagi globaj che a son al moment ativ.
Chèich blocagi a son marcà com localment disabilità: sòn a veul dì ch'a-i son dzora d'àutri sit, ma che n'aministrator local a l'ha decidù ëd disabilitelo dzora a costa wiki.",
	'globalblocking-list' => "Lista d'adrësse IP blocà globalment",
	'globalblocking-search-legend' => 'Arsërché un blocagi global',
	'globalblocking-search-ip' => 'Adrëssa IP:',
	'globalblocking-search-submit' => 'Sërché dij blocagi',
	'globalblocking-list-ipinvalid' => "L'adrëssa IP ch'a l'ha sërcà ($1) a l'é pa bon-a.
Për piasì ch'a anserissa n'adrëssa IP bon-a.",
	'globalblocking-search-errors' => "Toa arserca a l'é stàita sensa arzultà, për {{PLURAL:$1|la rason|le rason}} sota:",
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') blocà globalment [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'scadensa $1',
	'globalblocking-list-anononly' => 'mach anònim',
	'globalblocking-list-unblock' => 'gava',
	'globalblocking-list-whitelisted' => 'disabilità localment da $1: $2',
	'globalblocking-list-whitelist' => 'stat local',
	'globalblocking-list-modify' => 'modìfica',
	'globalblocking-list-noresults' => "L'adrëssa IP ciamà a l'é pa blocà",
	'globalblocking-goto-block' => "Blòca globalment n'adrëssa IP",
	'globalblocking-goto-unblock' => 'Gavé un blocagi global',
	'globalblocking-goto-status' => "Cangé lë statù local d'un blocagi global",
	'globalblocking-return' => 'Artorné a la lista dij blòcagi globaj',
	'globalblocking-notblocked' => "L'adrëssa IP ($1) ch'a l'ha anserì a l'é pa blocà globalment.",
	'globalblocking-unblock' => 'Gavé un blocagi global',
	'globalblocking-unblock-ipinvalid' => "L'adrëssa IP ($1) ch'a l'ha anserì a l'é pa bon-a.
Për piasì, ch'a nòta ch'a peul pa buté un nòm utent!",
	'globalblocking-unblock-legend' => 'Gavé un blocagi global',
	'globalblocking-unblock-submit' => 'Gavé ël blocagi global',
	'globalblocking-unblock-reason' => 'Rason:',
	'globalblocking-unblock-unblocked' => "A l'ha gavà da bin ël blocagi global $2 për l'adrëssa IP '''$1'''",
	'globalblocking-unblock-errors' => "Sò scancelament dël blocagi global a l'ha falì, për {{PLURAL:$1|la rason|le rason}} sì-sota:",
	'globalblocking-unblock-successsub' => 'Blocagi global gavà da bin',
	'globalblocking-unblock-subtitle' => 'Gavé ël blocagi global',
	'globalblocking-unblock-intro' => 'A peul dovré cost formolari-sì për gavé un blocagi global.',
	'globalblocking-whitelist' => 'Stat local dij blocagi globaj',
	'globalblocking-whitelist-notapplied' => 'Ij blocagi globaj a son pa aplicà an costa wiki-sì,
parèj lë stat local dij blocagi globaj a peul pa esse modificà.',
	'globalblocking-whitelist-legend' => 'Cangia stat local',
	'globalblocking-whitelist-reason' => 'Rason:',
	'globalblocking-whitelist-status' => 'Stat local:',
	'globalblocking-whitelist-statuslabel' => 'Disabilité sto blocagi global-sì dzora a {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Cangia stat local',
	'globalblocking-whitelist-whitelisted' => "A l'ha disabilità da bin ël blocagi global  #$2 dl'adrëssa IP '''$1''' dzora a {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "A l'ha ativà torna da bin ël blocagi global nùmer $2 dl'adrëssa IP '''$1''' dzora a {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Stat local cangià da bin',
	'globalblocking-whitelist-nochange' => "A l'has pa fàit gnun cangiament a lë stat local ëd cost blocagi.
[[Special:GlobalBlockList|Artorné a la lista dij blocagi globaj]].",
	'globalblocking-whitelist-errors' => "Sò cangiament a lë statù local d'un blocagi global a l'ha pa marcià, për {{PLURAL:$1|la rason|le rason}} sì-sota:",
	'globalblocking-whitelist-intro' => "A peul dovré cost formolari për modifiché lë statù local d'un blocagi global.
Se un blocagi global a l'é disabilità dzora a sta wiki-sì, j'utent con l'adrëssa IP colpìa a podran modifiché normalment.
[[Special:GlobalBlockList|Artorné a la lista dij blocagi globaj]].",
	'globalblocking-blocked' => "Soa adrëssa IP \$5 a l'é stàita blocà dzora a tute le wiki da '''\$1''' (''\$2'').
La rason smonùa a l'é stàita ''\"\$3\"''.
Blocagi: ''\$4''.",
	'globalblocking-blocked-nopassreset' => "A peule pa torna amposté la ciav d'utent përchè a l'é blocà daspërtut.",
	'globalblocking-logpage' => 'Registr dij blocagi globaj',
	'globalblocking-logpagetext' => "Cost-sì a l'é un registr dij blocagi globaj che a son ëstàit fàit e gavà dzora a sta wiki-sì.
As podrìa notesse che blocagi globaj a peulo esse fàit e gavà dzora a d'àutre wiki, e che sti blocagi globaj a peulo colpì sta wiki-sì.
Për vëdde tùit ij blocagi globaj ativ, a peul vëdde la [[Special:GlobalBlockList|lista dij blocagi globaj]].",
	'globalblocking-block-logentry' => 'blocà globalment [[$1]] con un temp ëd fin ëd $2',
	'globalblocking-block2-logentry' => 'blocà globalment [[$1]] ($2)',
	'globalblocking-unblock-logentry' => "a l'ha gavà ël blocagi global ëd [[$1]]",
	'globalblocking-whitelist-logentry' => "a l'ha disabilità ël blocagi global ëd [[$1]] an local",
	'globalblocking-dewhitelist-logentry' => "a l'ha torna ativà ël blocagi global ëd [[$1]] an local",
	'globalblocking-modify-logentry' => "a l'ha modificà ël blocagi global ëd [[$1]] ($2)",
	'globalblocking-logentry-expiry' => 'a finiss ai $1',
	'globalblocking-logentry-noexpiry' => 'dàita ëd fin pa butà',
	'globalblocking-loglink' => "L'adrëssa IP $1 a l'é blocà globalment ([[{{#Special:GlobalBlockList}}/$1|detaj complet]]).",
	'globalblocking-showlog' => "L'adrëssa IP a l'é stàita blocà prima.
Ël registr dij blocagi a l'é smonù sì-sota për arferiment:",
	'globalblocklist' => "Lista dj'adrësse IP blocà globalment",
	'globalblock' => "Blòca globalment n'adrëssa IP",
	'globalblockstatus' => 'Statù local dij blocagi globaj',
	'removeglobalblock' => 'Gavé un blocagi global',
	'right-globalblock' => 'Fé dij blocagi globaj',
	'right-globalunblock' => 'Gavé dij blocagi globaj',
	'right-globalblock-whitelist' => 'Disabilité dij blocagi globaj localment',
	'right-globalblock-exempt' => 'Passé dzora a ij blocagi globaj',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Allows]] آئی پی پتے [[Special:GlobalBlockList|blocked across multiple wikis]] تے۔',
	'globalblocking-block' => 'گلوبلی اس IP پتے نوں روکو',
	'globalblocking-modify-intro' => 'تسی ایس فارم نوں ایس گلوبل روک دا سٹیٹس بدلن لئی ورت سکدے او۔',
	'globalblocking-block-intro' => 'تسی اس صفحے نوں سارے وکیاں تے IP پتے نوں روکن واسطے ورت سکدے او۔',
	'globalblocking-block-reason' => 'وجہ:',
	'globalblocking-block-otherreason' => 'دوجی/ہور وجہ:',
	'globalblocking-block-reasonotherlist' => 'ہور وجہ',
	'globalblocking-block-reason-dropdown' => '*چھوٹے موٹی روک دی وجہ
**اک توں بوتے وکیاں تے سپیمنگ
**اک توں بوتے وکیاں دا غلط ورتن
**گند مارنا',
	'globalblocking-block-edit-dropdown' => 'روک دی وجہ تبدیل کرو',
	'globalblocking-block-expiry' => 'انت:',
	'globalblocking-block-expiry-other' => 'دوجا انت ویلا',
	'globalblocking-block-expiry-otherfield' => 'دوجے ویلے:',
	'globalblocking-block-legend' => 'IP پتے نوں گلوبلی روکو',
	'globalblocking-block-options' => 'چنوتیاں:',
	'globalblocking-block-errors' => 'تسی روک نئیں سکے، {{PLURAL:$1|اس وجہ توں|ایناں وجاں توں}}:',
	'globalblocking-block-ipinvalid' => 'جیڑا IP ($1) تسی لکھیا اے اوہ غلط اے۔
اے گل یاد رکھو تسی ورتن ناں نئیں لکھ سکدے!',
	'globalblocking-block-expiryinvalid' => 'جیڑا انت ویلا تسی لکھیا اے ($1) اوہ غلط اے۔',
	'globalblocking-block-submit' => 'IP پتے نوں گلوبلی روکو',
	'globalblocking-modify-submit' => 'گلوبل روک نوں تبدیل کرو',
	'globalblocking-block-success' => 'اے IP پتہ $1 سارے ویونتاں تے روکیا ہویا اے۔',
	'globalblocking-modify-success' => '$1 دے اتے گلوبل روک تبدیل کر دتی گئی اے',
	'globalblocking-block-successsub' => 'گلوبل روک لگ گئی اے',
	'globalblocking-modify-successsub' => 'گلوبل روک تبدیل ہو گئی اے',
	'globalblocking-block-alreadyblocked' => 'آی پی پتہ $1 پورے جگ تے روکیا گیا جے۔
تسیں ہن دی روک ویکھ سکدے او [[Special:GlobalBlockList|جگت روکاں دی لسٹ]] تے،
یا ہن دی روک دے ول نوں  بدلو ایس فارم نوں دوبارہ پعر کے۔',
	'globalblocking-block-bigrange' => 'جیہڑی رینج تساں دسی اے ($1) چوکھی وڈی اے جے اودے تے روک لگے۔ تسیں زیادہ توں زیادہ 65,536 پتے روک سکدے او (/16 رینجاں)',
	'globalblocking-list-intro' => 'اے جگت روکے گیاں دی لسٹ اے جیہڑی کہ ہن چل رئی اے۔ کج روکاں لوکل نیں: جیدا ایہ مطلب اے جے اوہ دوجیاں سائیٹاں تے وی چلدیاں نیں پر اک لوکل مکھۓ نین اے اوناں نوں ایس وکی نکارہ کیتا۔',
	'globalblocking-list' => 'جگت روک آئی پی پتیاں دی لسٹ',
	'globalblocking-search-legend' => 'گلوبل روک نوں کھوجو',
	'globalblocking-search-ip' => 'آئی پی پتہ:',
	'globalblocking-search-submit' => 'روکاں نوں کھوجو',
	'globalblocking-list-ipinvalid' => 'جیڑا IP پتہ ($1) تسی کھوجیا اے اوہ غلط اے۔
مہربانی کر کے ٹھیک IP پتہ لکھو۔',
	'globalblocking-search-errors' => 'تواڈی کھوج نقام رئی، {{PLURAL:$1|اس وجہ توں|ایناں وجاں توں}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') جگت روکے [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'انت $1',
	'globalblocking-list-anononly' => 'صرف گمنام',
	'globalblocking-list-unblock' => 'ہٹاؤ',
	'globalblocking-list-whitelisted' => '$1 نے لوکلی بند کیتا: $2',
	'globalblocking-list-whitelist' => 'لوکل حالت',
	'globalblocking-list-modify' => 'تبدیل کرو',
	'globalblocking-list-noresults' => 'پچھیا گیا IP پتے نوں نئیں روکیا گیا۔',
	'globalblocking-goto-block' => 'گلوبلی اس IP پتے نوں روکو',
	'globalblocking-goto-unblock' => 'گلوبل روک ہٹاؤ',
	'globalblocking-goto-status' => 'گلوبل روک دی حالت بدلو',
	'globalblocking-return' => 'گلوبل روکاں دی لسٹ ول چلو',
	'globalblocking-notblocked' => 'آئی پی پتہ ($1) تساں دسیا اے گلوبلی روکیا ہویا اے۔',
	'globalblocking-unblock' => 'گلوبل روک ہٹاؤ',
	'globalblocking-unblock-ipinvalid' => 'جیڑا IP ($1) تسی لکھیا اے اوہ غلط اے۔
اے گل یاد رکھو تسی ورتن ناں نئیں لکھ سکدے!',
	'globalblocking-unblock-legend' => 'گلوبل روک ہٹاؤ',
	'globalblocking-unblock-submit' => 'گلوبل روک ہٹاؤ',
	'globalblocking-unblock-reason' => 'وجہ:',
	'globalblocking-unblock-unblocked' => "تساں کامیابی نال گلوبل روک #$2 آئی پی پتے '''$1''' توں ہٹا دتی اے۔",
	'globalblocking-unblock-errors' => 'تواڈا گلوبل روک نئیں چل سکی تھلے دتیاں گیاں {{PLURAL:$1|وجہ|وجہاں}}: توں:',
	'globalblocking-unblock-successsub' => 'جگت روک ہٹادتی گئی',
	'globalblocking-unblock-subtitle' => 'جگت روک ہٹا ریاں واں',
	'globalblocking-unblock-intro' => 'تسی اے فارم جگت روک نوں ہٹان لئی ورت سکدے او۔',
	'globalblocking-whitelist' => 'جگت روکاں دا لوکل سٹیٹس',
	'globalblocking-whitelist-notapplied' => 'جگت روکاں ایس وکی تے نئیں چلدیاں،
ایس لئی جگت روکاں دا لوکل سٹیٹس نوں بدلیا نئیں جاسکدا۔',
	'globalblocking-whitelist-legend' => 'لوکل حالت بدلو',
	'globalblocking-whitelist-reason' => 'وجہ:',
	'globalblocking-whitelist-status' => 'لوکل حالت:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} دے اتے گلوبل روک بند کرو',
	'globalblocking-whitelist-submit' => 'لوکل حالت بدلو',
	'globalblocking-whitelist-whitelisted' => "تساں کامیابی نال گلوبل روک #$2 آئی پی پتے '''$1''' توں {{سائٹناں}} تے ہٹا دتی اے۔",
	'globalblocking-whitelist-dewhitelisted' => "تساں کامیابی نال جگت روک #$2 آئی پی پتے '''$1''' {{ساغٹناں}} توں ہٹا دتی اے۔",
	'globalblocking-whitelist-successsub' => 'لوکل سٹیٹس کامیابی نال بدل دتا گیا اے۔',
	'globalblocking-whitelist-nochange' => 'تساں ایس روک دے لوکل سٹیٹس تے کوئی تبدیلی نئیں کیتی۔
[[Special:GlobalBlockList|جگت روک لسٹ ول واپسی]]۔',
	'globalblocking-whitelist-errors' => 'تواڈی جگت روک لوکل سٹیٹس دی کامیاب نئیں، تھلے دتیاں گیاں {{انیک:$1|وجہ|وجہاں}} توں:',
	'globalblocking-whitelist-intro' => 'تسیں ایس فارم نوں اک جگت روک لوکل سٹیٹس نوں بدلن لئی ورت سکدے او۔
اگر اک جگت روک ایس وکی تے کم نئیں کردی، ورتن والے متاثرہ آئی پی پتے اینوں تبدیل کرن گے۔
[[Special:GlobalBlockList|جگت روک لسٹ ول چلو]]',
	'globalblocking-blocked' => "تواڈا آئی پی پتہ \$5 سارے وکیاں تے روک دتا اے '''\$1''' (''\$2'') نیں۔
وجہ ''\"\$3\"'' دتی گئی۔ 
روک ''\$4''",
	'globalblocking-blocked-nopassreset' => 'تسیں اک ورتن والے دی کنجی نئیں بدل سکدے کیوں جے تساں تے جگت روک اے۔',
	'globalblocking-logpage' => 'جگت روک لاگ',
	'globalblocking-logpagetext' => 'ایہ جگت روکاں دی لاگ اے جیہڑی بنائی گئی اے تے ایس وکی توں ہٹا دتی گئی اے۔
اے گل یاد رکھن والی اے جے جگت روکاں بنایاں جا سکدیاں نیں تے دوجے وکیاں تے ہٹائیاں جاسکدیاں نیں، تے ایہ جگت روکاں  ایس وکی تے وی اثر پاندیاں نیں۔ 
سارے چلدے جگت روکاں نوں ویکھن لئی تسیں ویکھو [[خاص:جگت روک لسٹ|جگت روک لسٹ]]',
	'globalblocking-block-logentry' => 'جگت روک [[$1]] جیدا مکن ویلہ $2 اے۔',
	'globalblocking-block2-logentry' => 'جگت روکیا گیا[[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'جگت روک [[$1]] توں ہٹادتی گئی۔',
	'globalblocking-whitelist-logentry' => 'جگت روک [[$1]] تے لوکلی کم نئیں کریگی۔',
	'globalblocking-dewhitelist-logentry' => 'جگت روک [[$1]] لوکلی دوبارہ کم کریگی۔',
	'globalblocking-modify-logentry' => 'جگت روک نوں [[$1]] ($2) تے بدلو',
	'globalblocking-logentry-expiry' => 'انت $1',
	'globalblocking-logentry-noexpiry' => 'کوئی مکن سیٹ نئیں',
	'globalblocking-loglink' => 'آئی پی پتہ $1 تے جگت روک اے ([[{{#حاص:جگت روکلسٹ}}/$1|پوری گل]])',
	'globalblocking-showlog' => 'آئی پی پتہ پہلے وی روکیا گیا اے۔
روک لاگ تھلے اتے پتے لئی دتی گئی اے:',
	'globalblocklist' => 'جگت روک آئی پی پتیاں دی لسٹ',
	'globalblock' => 'گلوبلی اس آئی پی  پتے نوں روکو',
	'globalblockstatus' => 'جگت روکاں دا لوکل سٹیٹس',
	'removeglobalblock' => 'گلوبل تالا ہٹاؤ',
	'right-globalblock' => 'گلوبل روکاں لاؤ',
	'right-globalunblock' => 'گلوبل روکاں ہٹاؤ',
	'right-globalblock-whitelist' => 'جگت روک نوں لوکلی نکما کرو۔',
	'right-globalblock-exempt' => 'گلوبل روکاں نون نان تکو',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'globalblocking-block' => 'په يوې آی پي پتې نړېواله بنديز لګول',
	'globalblocking-block-reason' => 'سبب:',
	'globalblocking-block-otherreason' => 'بل/اضافي سبب:',
	'globalblocking-block-reasonotherlist' => 'بل سبب',
	'globalblocking-block-reason-dropdown' => '* د بنديز ټولګړي سببونه
** په ويکي ګانو کې اپلاتې
** په ويکي ګانو کې ناوړه چارې
** ورانکاري',
	'globalblocking-block-edit-dropdown' => 'د بنديز سببونه سمول',
	'globalblocking-block-expiry' => 'د پای نېټه:',
	'globalblocking-block-expiry-other' => 'د پای بل وخت',
	'globalblocking-block-expiry-otherfield' => 'بل وخت:',
	'globalblocking-block-legend' => 'په يوې آي پي پتې نړېوال بنديز لګول',
	'globalblocking-block-options' => 'خوښنې:',
	'globalblocking-ipaddress' => 'IP پته:',
	'globalblocking-ipbanononly' => 'يواځې په ورکنومو کارنانو بنديز لګول',
	'globalblocking-block-submit' => 'په دې آي پي پتې نړېوال بنديز لګول',
	'globalblocking-modify-submit' => 'دا نړېوال بنديز بدلول',
	'globalblocking-block-successsub' => 'نړېوال بنديز بريالی شو',
	'globalblocking-modify-successsub' => 'د نړېوال بنديز بدلون بريالی شو',
	'globalblocking-list' => 'د نړېوال بنديز لګېدلو آي پي پتو لړليک',
	'globalblocking-search-legend' => 'د يوه نړېوال بنديز پلټل',
	'globalblocking-search-ip' => 'IP پته:',
	'globalblocking-search-submit' => 'د بنديزونو لپاره پلټل',
	'globalblocking-list-expiry' => 'پای نېټه $1',
	'globalblocking-list-anononly' => 'يوازې ورکنومی',
	'globalblocking-list-unblock' => 'غورځول',
	'globalblocking-list-whitelist' => 'سيمه ايز دريځ',
	'globalblocking-list-modify' => 'بدلول',
	'globalblocking-list-noresults' => 'په غوښتلې آي پي پتې بنديز نه دی.',
	'globalblocking-goto-block' => 'په يوې آی پي پتې نړېواله بنديز لګول',
	'globalblocking-goto-unblock' => 'يو نړيوال بنديز غورځول',
	'globalblocking-return' => 'د نړېوالو بنديزونو لړليک ته ورګرځېدل.',
	'globalblocking-notblocked' => 'د ($1) آی پي پته چې مو ورکړې په نړېواله توګه بنديز شوې نه ده.',
	'globalblocking-unblock' => 'يو نړيوال بنديز غورځول',
	'globalblocking-unblock-legend' => 'يو نړيوال بنديز غورځول',
	'globalblocking-unblock-submit' => 'نړيوال بنديز غورځول',
	'globalblocking-unblock-reason' => 'سبب:',
	'globalblocking-unblock-subtitle' => 'نړيوال بنديز غورځول',
	'globalblocking-unblock-intro' => 'تاسې دا فورمه د يوه نړېوال بنديز د لرې کولو لپاره کارولی شی.',
	'globalblocking-whitelist' => 'د نړېوالو بنديزونو سيمه ايز دريځ',
	'globalblocking-whitelist-legend' => 'سيمه ايز دريځ بدلول',
	'globalblocking-whitelist-reason' => 'سبب:',
	'globalblocking-whitelist-status' => 'سيمه ايز دريځ:',
	'globalblocking-whitelist-statuslabel' => 'په {{SITENAME}} کې نړېوال بنديز ناچارنول',
	'globalblocking-whitelist-submit' => 'سيمه ايز دريځ بدلول',
	'globalblocking-whitelist-successsub' => 'سيمه ايز دريځ په برياليتوب بدل شو',
	'globalblocking-logpage' => 'د نړېوال بنديز يادښت',
	'globalblocking-block2-logentry' => 'نړېوال بنديز لګېدلي [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'پای نېټه $1',
	'globalblocklist' => 'د نړېوال بنديز لګېدلو آي پي پتو لړليک',
	'globalblock' => 'په يوې آی پي پتې نړېواله بنديز لګول',
	'globalblockstatus' => 'د نړېوالو بنديزونو سيمه ايز دريځ',
	'removeglobalblock' => 'يو نړيوال بنديز غورځول',
	'right-globalblock' => 'نړېوال بنديز لګول',
	'right-globalunblock' => 'نړېوال بنديزونه غورځول',
);

/** Portuguese (Português)
 * @author 555
 * @author GKnedo
 * @author Giro720
 * @author Hamilton Abreu
 * @author João Sousa
 * @author Lijealso
 * @author Malafaya
 * @author SandroHc
 * @author Waldir
 */
$messages['pt'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permite]] que endereços IP sejam [[Special:GlobalBlockList|bloqueados em várias wikis]]',
	'globalblocking-block' => 'Bloquear globalmente um endereço IP',
	'globalblocking-modify-intro' => 'Pode usar este formulário para alterar as definições de um bloqueio global.',
	'globalblocking-block-intro' => 'Pode usar esta página para bloquear um endereço IP em todas as wikis.',
	'globalblocking-block-reason' => 'Motivo:',
	'globalblocking-block-otherreason' => 'Outro motivo ou motivo adicional:',
	'globalblocking-block-reasonotherlist' => 'Outro motivo',
	'globalblocking-block-reason-dropdown' => '* Motivos comuns de bloqueio
** Spam em várias wikis
** Abuso em várias wikis
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Editar motivos de bloqueio',
	'globalblocking-block-expiry' => 'Expiração:',
	'globalblocking-block-expiry-other' => 'Outro tempo de validade',
	'globalblocking-block-expiry-otherfield' => 'Outra duração:',
	'globalblocking-block-legend' => 'Bloquear um endereço IP globalmente',
	'globalblocking-block-options' => 'Opções:',
	'globalblocking-ipaddress' => 'Endereço IP:',
	'globalblocking-ipbanononly' => 'Bloquear apenas utilizadores anónimos',
	'globalblocking-block-errors' => 'O bloqueio não teve sucesso {{PLURAL:$1|pelo seguinte motivo|pelos seguintes motivos}}:',
	'globalblocking-block-ipinvalid' => 'O endereço IP ($1) que introduziu é inválido.
Por favor, note que não pode introduzir um nome de utilizador!',
	'globalblocking-block-expiryinvalid' => 'A expiração que introduziu ($1) é inválida.',
	'globalblocking-block-submit' => 'Bloquear este endereço IP globalmente',
	'globalblocking-modify-submit' => 'Modificar este bloqueio global',
	'globalblocking-block-success' => 'O endereço IP $1 foi bloqueado com sucesso em todos os projectos.',
	'globalblocking-modify-success' => 'O bloqueio global sobre $1 foi modificado com sucesso',
	'globalblocking-block-successsub' => 'Bloqueio global com sucesso',
	'globalblocking-modify-successsub' => 'Bloqueio global modificado com sucesso',
	'globalblocking-block-alreadyblocked' => 'O endereço IP $1 já está bloqueado globalmente.
Pode ver o bloqueio existente na [[Special:GlobalBlockList|lista de bloqueios globais]],
ou modificar as definições do bloqueio existente ao re-submeter este formulário.',
	'globalblocking-block-bigrange' => 'O intervalo especificado ($1) é demasiado grande para ser bloqueado.
Pode bloquear, no máximo, 65.536 endereços (intervalos /16)',
	'globalblocking-list-intro' => 'Esta é uma lista de todos os bloqueios globais em efeito.
Alguns estão marcados como desactivados localmente: isto significa que se aplicam a outros sites, mas um administrador local decidiu desactivá-los nesta wiki.',
	'globalblocking-list' => 'Lista de endereços IP bloqueados globalmente',
	'globalblocking-search-legend' => 'Pesquisar bloqueio global',
	'globalblocking-search-ip' => 'Endereço IP:',
	'globalblocking-search-submit' => 'Pesquisar bloqueios',
	'globalblocking-list-ipinvalid' => 'O endereço IP que procurou ($1) é inválido.
Por favor, introduza um endereço IP válido.',
	'globalblocking-search-errors' => 'A sua busca não teve sucesso {{PLURAL:$1|pelo seguinte motivo|pelos seguintes motivos}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bloqueou globalmente [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'expira $1',
	'globalblocking-list-anononly' => 'só anónimos',
	'globalblocking-list-unblock' => 'desbloquear',
	'globalblocking-list-whitelisted' => 'localmente desactivado por $1: $2',
	'globalblocking-list-whitelist' => 'estado local',
	'globalblocking-list-modify' => 'modificar',
	'globalblocking-list-noresults' => 'O endereço IP solicitado não está bloqueado.',
	'globalblocking-goto-block' => 'Bloquear globalmente um endereço IP',
	'globalblocking-goto-unblock' => 'Remover um bloqueio global',
	'globalblocking-goto-status' => 'Alterar estado local de um bloqueio global',
	'globalblocking-return' => 'Voltar à lista de bloqueios globais',
	'globalblocking-notblocked' => 'O endereço IP ($1) introduzido não está bloqueado globalmente.',
	'globalblocking-unblock' => 'Eliminar um bloqueio global',
	'globalblocking-unblock-ipinvalid' => 'O endereço IP ($1) que introduziu é inválido.
Por favor, note que não pode introduzir um nome de utilizador!',
	'globalblocking-unblock-legend' => 'Remover um bloqueio global',
	'globalblocking-unblock-submit' => 'Remover bloqueio global',
	'globalblocking-unblock-reason' => 'Motivo:',
	'globalblocking-unblock-unblocked' => "Removeu o bloqueio global #$2 sobre o endereço IP '''$1''' com sucesso",
	'globalblocking-unblock-errors' => 'Não foi possível remover este bloqueio global, {{PLURAL:$1|pelo seguinte motivo|pelos seguintes motivos}}:',
	'globalblocking-unblock-successsub' => 'Bloqueio global removido com sucesso',
	'globalblocking-unblock-subtitle' => 'Removendo bloqueio global',
	'globalblocking-unblock-intro' => 'Pode usar este formulário para eliminar um bloqueio global.',
	'globalblocking-whitelist' => 'Estado local de bloqueios globais',
	'globalblocking-whitelist-notapplied' => 'Bloqueios globais não são aplicados nesta wiki,
logo o estado local de bloqueios globais não pode ser modificado.',
	'globalblocking-whitelist-legend' => 'Alterar estado local',
	'globalblocking-whitelist-reason' => 'Motivo:',
	'globalblocking-whitelist-status' => 'Estado local:',
	'globalblocking-whitelist-statuslabel' => 'Desactivar este bloqueio global na {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Alterar estado local',
	'globalblocking-whitelist-whitelisted' => "Desactivou com sucesso o bloqueio global #$2 sobre o endereço IP '''$1''' na {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Reactivou com sucesso o bloqueio global #$2 sobre o endereço IP '''$1''' na {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Estado local alterado com sucesso',
	'globalblocking-whitelist-nochange' => 'Não fez qualquer alteração ao estado local deste bloqueio.
[[Special:GlobalBlockList|Voltar à lista de bloqueios globais]].',
	'globalblocking-whitelist-errors' => 'A sua alteração ao estado local de um bloqueio global não teve sucesso {{PLURAL:$1|pela seguinte razão|pelas seguintes razões}}:',
	'globalblocking-whitelist-intro' => 'Pode usar este formulário para editar o estado local de um bloqueio global.
Se um bloqueio global está desactivado nesta wiki, os utilizadores nos endereços IP afectados poderão editar normalmente.
[[Special:GlobalBlockList|Voltar à lista de bloqueios globais]].',
	'globalblocking-blocked' => "O seu endereço IP \$5 foi bloqueado em todas as wikis por '''\$1''' (''\$2'').
O motivo dado foi ''\"\$3\"''.
Duração: ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Não pode repor palavras-chave de utilizadores porque está bloqueado globalmente.',
	'globalblocking-logpage' => 'Registo de bloqueios globais',
	'globalblocking-logpagetext' => 'Este é um registo de bloqueios globais que foram feitos e removidos nesta wiki.
Deve ser notado que bloqueios globais podem também ser feitos e removidos noutras wikis e que esses bloqueios poderão afectar esta wiki.
Para ver todos os bloqueios globais, consulte a [[Special:GlobalBlockList|lista de bloqueios globais]].',
	'globalblocking-block-logentry' => 'bloqueou globalmente [[$1]] com um tempo de expiração de $2',
	'globalblocking-block2-logentry' => 'bloqueou globalmente [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'removeu bloqueio global de [[$1]]',
	'globalblocking-whitelist-logentry' => 'desactivou o bloqueio global sobre [[$1]] localmente',
	'globalblocking-dewhitelist-logentry' => 'reactivou o bloqueio global sobre [[$1]] localmente',
	'globalblocking-modify-logentry' => 'modificou o bloqueio global sobre [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'expira em $1',
	'globalblocking-logentry-noexpiry' => 'nenhum prazo especificado',
	'globalblocking-loglink' => 'O endereço IP $1 está bloqueado globalmente ([[{{#Special:GlobalBlockList}}/$1|detalhes completos]]).',
	'globalblocking-showlog' => 'Este endereço IP já foi bloqueado anteriormente.
Para sua referência, é apresentado abaixo o registo de bloqueios:',
	'globalblocklist' => 'Lista de endereços IP bloqueados globalmente',
	'globalblock' => 'Bloquear um endereço IP globalmente',
	'globalblockstatus' => 'Estado local de bloqueios globais',
	'removeglobalblock' => 'Remover um bloqueio global',
	'right-globalblock' => 'Fazer bloqueios globais',
	'right-globalunblock' => 'Remover bloqueios globais',
	'right-globalblock-whitelist' => 'Desactivar bloqueios globais localmente',
	'right-globalblock-exempt' => 'Contornar bloqueios globais',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Brunoy Anastasiya Seryozhenko
 * @author Eduardo.mps
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Luckas Blade
 * @author Rafael Vargas
 * @author Sir Lestaty de Lioncourt
 */
$messages['pt-br'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permite]] que endereços IP sejam [[Special:GlobalBlockList|bloqueados através de múltiplos wikis]]',
	'globalblocking-block' => 'Bloquear globalmente um endereço IP',
	'globalblocking-modify-intro' => 'Você pode usar este formulário para alterar as definições de um bloqueio global.',
	'globalblocking-block-intro' => 'Você pode usar esta página para bloquear um endereço IP em todos os wikis.',
	'globalblocking-block-reason' => 'Motivo:',
	'globalblocking-block-otherreason' => 'Outro motivo/motivo adicional:',
	'globalblocking-block-reasonotherlist' => 'Outro motivo',
	'globalblocking-block-reason-dropdown' => '* Motivos comuns de bloqueio
** Spam sobre vários wikis
** Abusos sobre vários wikis
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Editar motivos de bloqueio',
	'globalblocking-block-expiry' => 'Validade do bloqueio:',
	'globalblocking-block-expiry-other' => 'Outro tempo de validade',
	'globalblocking-block-expiry-otherfield' => 'Outra duração:',
	'globalblocking-block-legend' => 'Bloquear um endereço IP globalmente',
	'globalblocking-block-options' => 'Opções:',
	'globalblocking-ipaddress' => 'Endereço IP:',
	'globalblocking-ipbanononly' => 'Bloquear apenas usuários anônimos',
	'globalblocking-block-errors' => 'O bloqueio não teve sucesso {{PLURAL:$1|pelo seguinte motivo|pelos seguintes motivos}}:',
	'globalblocking-block-ipinvalid' => 'O endereço IP ($1) que introduziu é inválido.
Por favor, note que não pode introduzir um nome de utilizador!',
	'globalblocking-block-expiryinvalid' => 'A expiração que introduziu ($1) é inválida.',
	'globalblocking-block-submit' => 'Bloquear globalmente este endereço IP',
	'globalblocking-modify-submit' => 'Modificar este bloqueio global',
	'globalblocking-block-success' => 'O endereço IP $1 foi bloqueado com sucesso em todos os projetos.',
	'globalblocking-modify-success' => 'O bloqueio global sobre $1 foi modificado com sucesso',
	'globalblocking-block-successsub' => 'Bloqueio global bem sucedido',
	'globalblocking-modify-successsub' => 'Bloqueio global modificado bem sucedido',
	'globalblocking-block-alreadyblocked' => 'O endereço IP $1 já está bloqueado globalmente.
Você pode ver o bloqueio existente na [[Special:GlobalBlockList|lista de bloqueios globais]],
ou modificar as definições do bloqueio existente ao re-submeter este formulário.',
	'globalblocking-block-bigrange' => 'O intervalo especificado ($1) é grande demais para ser bloqueado.
Pode bloquear, no máximo, 65.536 endereços (intervalos /16)',
	'globalblocking-list-intro' => 'Isto é uma lista de todos os bloqueios globais que estão atualmente em efeito.
Alguns bloqueios está marcados como desativados localmente: isto significa que se aplicam a outros sítios, mas um administrador local decidiu desativá-los neste wiki.',
	'globalblocking-list' => 'Lista de endereços IP bloqueados globalmente',
	'globalblocking-search-legend' => 'Pesquisar por um bloqueio global',
	'globalblocking-search-ip' => 'Endereço IP:',
	'globalblocking-search-submit' => 'Pesquisar bloqueios',
	'globalblocking-list-ipinvalid' => 'O endereço IP que procurou ($1) é inválido.
Por favor, introduza um endereço IP válido.',
	'globalblocking-search-errors' => 'A sua busca não teve sucesso {{PLURAL:$1|pelo seguinte motivo|pelos seguintes motivos}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bloqueou globalmente [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'expira $1',
	'globalblocking-list-anononly' => 'só anônimos',
	'globalblocking-list-unblock' => 'desbloquear',
	'globalblocking-list-whitelisted' => 'localmente desativado por $1: $2',
	'globalblocking-list-whitelist' => 'estado local',
	'globalblocking-list-modify' => 'modificar',
	'globalblocking-list-noresults' => 'O endereço IP solicitado não está bloqueado.',
	'globalblocking-goto-block' => 'Bloquear globalmente um endereço IP',
	'globalblocking-goto-unblock' => 'Remover um bloqueio global',
	'globalblocking-goto-status' => 'Alterar estado local de um bloqueio global',
	'globalblocking-return' => 'Voltar à lista de bloqueios globais',
	'globalblocking-notblocked' => 'O endereço IP ($1) introduzido não está bloqueado globalmente.',
	'globalblocking-unblock' => 'Eliminar um bloqueio global',
	'globalblocking-unblock-ipinvalid' => 'O endereço IP ($1) que introduziu é inválido.
Por favor, note que não pode introduzir um nome de utilizador!',
	'globalblocking-unblock-legend' => 'Remover um bloqueio global',
	'globalblocking-unblock-submit' => 'Remover bloqueio global',
	'globalblocking-unblock-reason' => 'Motivo:',
	'globalblocking-unblock-unblocked' => "Você removeu o bloqueio global #$2 sobre o endereço IP '''$1''' com sucesso",
	'globalblocking-unblock-errors' => 'Você não pôde remover este bloqueio global, {{PLURAL:$1|pelo seguinte motivo|pelos seguintes motivos}}:',
	'globalblocking-unblock-successsub' => 'Bloqueio global removido com sucesso',
	'globalblocking-unblock-subtitle' => 'Removendo bloqueio global',
	'globalblocking-unblock-intro' => 'Você pode usar este formulário para eliminar um bloqueio global.',
	'globalblocking-whitelist' => 'Estado local de bloqueios globais',
	'globalblocking-whitelist-notapplied' => 'Bloqueios globais não são aplicados neste wiki,
logo o estado local de bloqueios globais não pode ser modificado.',
	'globalblocking-whitelist-legend' => 'Alterar estado local',
	'globalblocking-whitelist-reason' => 'Motivo:',
	'globalblocking-whitelist-status' => 'Estado local:',
	'globalblocking-whitelist-statuslabel' => 'Desativar este bloqueio global em {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Alterar estado local',
	'globalblocking-whitelist-whitelisted' => "Você desativou com sucesso o bloqueio global #$2 sobre o endereço IP '''$1''' em {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Você reativou com sucesso o bloqueio global #$2 sobre o endereço IP '''$1''' em {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Estado local alterado com sucesso',
	'globalblocking-whitelist-nochange' => 'Você não fez qualquer alteração ao estado local deste bloqueio.
[[Special:GlobalBlockList|Voltar à lista de bloqueios globais]].',
	'globalblocking-whitelist-errors' => 'A sua alteração ao estado local de um bloqueio global não teve sucesso {{PLURAL:$1|pela seguinte razão|pelas seguintes razões}}:',
	'globalblocking-whitelist-intro' => 'Você pode usar este formulário para editar o estado local de um bloqueio global.
Se um bloqueio global está desativado neste wiki, os utilizadores nos endereços IP afetados poderão editar normalmente.
[[Special:GlobalBlockList|Voltar à lista de bloqueios globais]].',
	'globalblocking-blocked' => "O seu endereço IP \$5 foi bloqueado em todos os wikis por '''\$1''' (''\$2'').
O motivo apontado foi ''\"\$3\"''.
O bloqueio ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Você não pode repor palavras-chave de utilizadores porque você está bloqueado globalmente.',
	'globalblocking-logpage' => 'Registro de bloqueios globais',
	'globalblocking-logpagetext' => 'Isto é um registro de bloqueios globais que foram feitos e removidos neste wiki.
Deve ser notado que bloqueios globais podem ser feitos e removidos em outros wikis, e que estes bloqueios globais podem afetar este wiki.
Para ver todos os bloqueios globais, poderá consultar a [[Special:GlobalBlockList|lista de bloqueios globais]].',
	'globalblocking-block-logentry' => 'bloqueou globalmente [[$1]] com um tempo de expiração de $2',
	'globalblocking-block2-logentry' => '[[$1]] ($2) bloqueado globalmente',
	'globalblocking-unblock-logentry' => 'Removido bloqueio global de [[$1]]',
	'globalblocking-whitelist-logentry' => 'desativou o bloqueio global sobre [[$1]] localmente',
	'globalblocking-dewhitelist-logentry' => 'reativou o bloqueio global sobre [[$1]] localmente',
	'globalblocking-modify-logentry' => 'modificado o bloqueio global sobre [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'expira em $1',
	'globalblocking-logentry-noexpiry' => 'nenhum prazo especificado',
	'globalblocking-loglink' => 'O endereço IP $1 está bloqueado globalmente ([[{{#Special:GlobalBlockList}}/$1|detalhes]]).',
	'globalblocking-showlog' => 'Este endereço IP já foi bloqueado anteriormente.
O registro de bloqueios é fornecido abaixo como referência:',
	'globalblocklist' => 'Lista de endereços IP bloqueados globalmente',
	'globalblock' => 'Bloquear um endereço IP globalmente',
	'globalblockstatus' => 'Estado local de bloqueios globais',
	'removeglobalblock' => 'Remover um bloqueio global',
	'right-globalblock' => 'Fazer bloqueios globais',
	'right-globalunblock' => 'Remover bloqueios globais',
	'right-globalblock-whitelist' => 'Desativar bloqueios globais localmente',
	'right-globalblock-exempt' => 'Contornar bloqueios globais',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'globalblocking-block-reason' => 'Kayrayku:',
	'globalblocking-block-otherreason' => 'Huk/aswan rayku:',
	'globalblocking-block-reasonotherlist' => 'Huk rayku',
	'globalblocking-block-reason-dropdown' => "* Hark'anapaq sapsi raykukuna
** Wikipura spam yapay
** Wikipura millay ruray
** Wandalismu",
	'globalblocking-block-edit-dropdown' => "Hark'aypa hamunta llamk'apuy",
	'globalblocking-block-expiry' => "Hark'ay kaykama:",
	'globalblocking-list' => "Sapsita hark'asqa IP tiyaykuna",
	'globalblocking-whitelist' => "Sapsi hark'asqakunap kayllapi kachkaynin",
	'globalblocking-block2-logentry' => "sapsilla hark'an [[$1]] sutiyuqta ($2)",
	'globalblocking-loglink' => "$1 sutiyuq IP tiyayqa tukuy wikikunapaqmi hark'asqa ([[{{#Special:GlobalBlockList}}/$1|tukuyta rikuy]]).",
	'globalblocking-showlog' => "Kay IP tiyayqa ñawpaqta hark'asqam.
Hark'ay hallch'ataqa kaypim rikunki willasunaykipaq:",
	'globalblocklist' => "Sapsita hark'asqa IP tiyaykuna",
	'globalblock' => "IP huchha imamaytata tukuy wikikunapaq hark'ay",
	'globalblockstatus' => "Sapsi hark'asqakunap kayllapi kachkaynin",
);

/** Romanian (Română)
 * @author Cin
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permite]] ca adresele IP să fie [[Special:GlobalBlockList|blocate pe mai multe wikiuri]]',
	'globalblocking-block' => 'Blochează global o adresă IP',
	'globalblocking-modify-intro' => 'Puteți folosi acest formular pentru a schimba setările unei blocări globale.',
	'globalblocking-block-intro' => 'Această pagină permite blocarea unei adrese IP pe toate proiectele wiki.',
	'globalblocking-block-reason' => 'Motiv:',
	'globalblocking-block-otherreason' => 'Altul/motiv suplimentar:',
	'globalblocking-block-reasonotherlist' => 'Alt motiv',
	'globalblocking-block-reason-dropdown' => '* Motive comune pentru blocare
** Spam pe mai multe wikiuri
** Abuz pe mai multe wikiuri
** Vandalism',
	'globalblocking-block-edit-dropdown' => 'Modifică motivele blocării',
	'globalblocking-block-expiry' => 'Expirare:',
	'globalblocking-block-expiry-other' => 'Alte termene de expirare',
	'globalblocking-block-expiry-otherfield' => 'Alt termen:',
	'globalblocking-block-legend' => 'Blochează global o adresă IP',
	'globalblocking-block-options' => 'Opțiuni:',
	'globalblocking-ipaddress' => 'Adresă IP:',
	'globalblocking-ipbanononly' => 'Blochează doar utilizatorii anonimi',
	'globalblocking-block-errors' => 'Blocarea nu a avut succes, din {{PLURAL:$1|următorul motiv|următoarele motive}}:',
	'globalblocking-block-ipinvalid' => 'Adresa IP introdusă ($1) este invalidă.
Atenție, nu poate fi introdus un nume de utilizator!',
	'globalblocking-block-expiryinvalid' => 'Data expirării introdusă ($1) este invalidă.',
	'globalblocking-block-submit' => 'Blochează global această adresă IP',
	'globalblocking-modify-submit' => 'Modifică această blocare globală',
	'globalblocking-block-success' => 'Adresa IP $1 a fost blocată cu succes în toate proiectele.',
	'globalblocking-modify-success' => 'Blocarea globală a lui $1 a fost modificată cu succes',
	'globalblocking-block-successsub' => 'Blocare globală cu succes',
	'globalblocking-modify-successsub' => 'Blocarea globală modificată cu succes',
	'globalblocking-list' => 'Listă de adrese IP blocate global',
	'globalblocking-search-legend' => 'Caută blocare globală',
	'globalblocking-search-ip' => 'Adresă IP:',
	'globalblocking-search-submit' => 'Caută blocări',
	'globalblocking-list-ipinvalid' => 'Adresa IP pe care o căutați ($1) este nevalidă.
Introduceți o adresă IP validă.',
	'globalblocking-search-errors' => 'Căutarea dumneavoastră nu a avut succes din {{PLURAL:$1|următorul motiv|următoarele motive}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') a blocat global [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'expiră $1',
	'globalblocking-list-anononly' => 'doar anonimi',
	'globalblocking-list-unblock' => 'elimină',
	'globalblocking-list-whitelisted' => 'dezactivat local de $1: $2',
	'globalblocking-list-whitelist' => 'statut local',
	'globalblocking-list-modify' => 'modifică',
	'globalblocking-list-noresults' => 'Adresa IP solicitată nu este blocată.',
	'globalblocking-goto-block' => 'Blochează global o adresă IP',
	'globalblocking-goto-unblock' => 'Elimină o blocare globală',
	'globalblocking-goto-status' => 'Schimbă statutul local al unei blocări globale',
	'globalblocking-return' => 'Înapoi la lista blocărilor globale',
	'globalblocking-notblocked' => 'Adresa IP introdusă ($1) nu este blocată global.',
	'globalblocking-unblock' => 'Elimină o blocare globală',
	'globalblocking-unblock-ipinvalid' => 'Adresa IP introdusă ($1) este invalidă.
Atenție, nu poate fi introdus un nume de utilizator!',
	'globalblocking-unblock-legend' => 'Elimină o blocare globală',
	'globalblocking-unblock-submit' => 'Elimină blocare globală',
	'globalblocking-unblock-reason' => 'Motiv:',
	'globalblocking-unblock-unblocked' => "Blocarea #$2 a adresei IP '''$1''' a fost eliminată cu succes",
	'globalblocking-unblock-errors' => 'Nu s-a eliminat blocarea globală din {{PLURAL:$1|următorul motiv|următoarele motive}}:',
	'globalblocking-unblock-successsub' => 'Blocare globală eliminată cu succes',
	'globalblocking-unblock-subtitle' => 'Eliminare blocare globală',
	'globalblocking-unblock-intro' => 'Puteți folosi acest formular pentru a elimina o blocare globală.',
	'globalblocking-whitelist' => 'Statutul local al blocărilor globale',
	'globalblocking-whitelist-notapplied' => 'Blocările globale nu se aplică în acest wiki,
deci statutul local al blocărilor globale nu poate fi modificat.',
	'globalblocking-whitelist-legend' => 'Schimbă statut local',
	'globalblocking-whitelist-reason' => 'Motiv:',
	'globalblocking-whitelist-status' => 'Statut local:',
	'globalblocking-whitelist-statuslabel' => 'Dezactivează această blocare gloablă pe {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Schimbă statut local',
	'globalblocking-whitelist-whitelisted' => "Blocarea #$2 a adresei IP '''$1''' la {{SITENAME}} a fost dezactivată cu succes.",
	'globalblocking-whitelist-dewhitelisted' => "Blocarea #$2 a adresei IP '''$1''' la {{SITENAME}} a fost reactivată cu succes.",
	'globalblocking-whitelist-successsub' => 'Statut global schimbat cu succes',
	'globalblocking-whitelist-errors' => 'Schimbarea dumneavoastră la starea locală a blocărilor globale a eșuat, din {{PLURAL:$1|următorul motiv|următoarele motive}}:',
	'globalblocking-blocked' => "Adresa dumneavoastră IP $5 a fost blocată pe toate wiki-urile de către '''$1''' (''$2'').
Motivul dat a fost ''„$3”''.
Blocarea ''$4''.",
	'globalblocking-logpage' => 'Jurnal blocări globale',
	'globalblocking-block-logentry' => 'a blocat global [[$1]] cu un timp de expirare de $2',
	'globalblocking-block2-logentry' => 'blocat global pe [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'eliminat blocare globală pentru [[$1]]',
	'globalblocking-whitelist-logentry' => 'a dezactivat o blocare globală pentru [[$1]] local',
	'globalblocking-dewhitelist-logentry' => 'a reactivat blocarea globală pentru [[$1]] local',
	'globalblocking-modify-logentry' => 'a modificat blocarea globală pentru [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'expiră la $1',
	'globalblocking-logentry-noexpiry' => 'nicio dată de expirare setată',
	'globalblocking-loglink' => 'Adresa IP $1 este blocată global ([[{{#Special:GlobalBlockList}}/$1|detalii complete]]).',
	'globalblocking-showlog' => 'Această adresă IP a fost blocată anterior.
Jurnalul blocărilor este disponibil mai jos:',
	'globalblocklist' => 'Listă de adrese IP blocate global',
	'globalblock' => 'Blochează global o adresă IP',
	'globalblockstatus' => 'Statutul local al blocărilor globale',
	'removeglobalblock' => 'Elimină o blocare globală',
	'right-globalblock' => 'Efectuează blocări globale',
	'right-globalunblock' => 'Elimină blocări globale',
	'right-globalblock-whitelist' => 'Dezactivează local blocările globale',
	'right-globalblock-exempt' => 'Ocolește blocările globale',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Permette]] a le indirizze IP de essere [[Special:GlobalBlockList|bloccate attraverse le diverse Uicchi]]',
	'globalblocking-block' => "Bluecche globalmende 'n'indirizze IP",
	'globalblocking-modify-intro' => "Tu puè ausà stu module pe cangià le 'mbostaziune d'u blocche globale.",
	'globalblocking-block-intro' => "Tu puè ausà sta pàgene pe bloccà 'n'indirizze IP sus a tutte le uicchi.",
	'globalblocking-block-reason' => 'Mutive:',
	'globalblocking-block-otherreason' => 'Otre/addizionale mutive:',
	'globalblocking-block-reasonotherlist' => 'Otre mutive',
	'globalblocking-block-reason-dropdown' => "* Mutive comune de blocche
** Spamming 'mbrà le Uicchi
** Abuse de 'ngorce 'mbrà le Uicchi
** Vandalisme",
	'globalblocking-block-edit-dropdown' => "Cange le mutive d'u blocche",
	'globalblocking-block-expiry' => 'Scadenze:',
	'globalblocking-block-expiry-other' => 'Otre orarie de scadenze',
	'globalblocking-block-expiry-otherfield' => 'Otre orarie:',
	'globalblocking-block-legend' => "Bluècche 'n'indirizze IP globalmende",
	'globalblocking-block-options' => 'Opziune:',
	'globalblocking-ipaddress' => 'Indirizze IP:',
	'globalblocking-block-errors' => "'U blocche tune non g'à riuscite, {{PLURAL:$1|pe stu|pe le seguende}} mutive:",
	'globalblocking-block-ipinvalid' => "L'indirizze IP ($1) ca tu è mise non g'è valide.<br />
Pe piacere vide ca tu non ge puè mettere 'nu nome utende!",
	'globalblocking-block-expiryinvalid' => "'A scadenze ca tu è mise ($1) non g'è valide.",
	'globalblocking-block-submit' => "Bluecche globalmende st'indirizze IP",
	'globalblocking-modify-submit' => 'Cange stu blocche globale',
	'globalblocking-block-success' => "L'indirizze IP $1 ha state bloccate cu successe sus a tutte le pruggette.",
	'globalblocking-modify-success' => "'U bluecche globale sus a $1 ha state cangiate cu successe",
	'globalblocking-block-successsub' => 'Bluècche globale riuscite',
	'globalblocking-modify-successsub' => 'Blocche globale cangiate cu successe',
	'globalblocking-block-alreadyblocked' => "L'indirizze IP $1 ha state ggià bloccate.<br />
Tu puè vedè le bluecche ca esistene sus a l'[[Special:GlobalBlockList|elenghe de le bluecche globale]], o cangià l'imbostaziune de le bluecche ca esistene e re-confermà stu module.",
	'globalblocking-block-bigrange' => "L'indervalle ca è specificate ($1) jè troppe gruèsse pe bloccà.<br />
Tu puè bloccà, assaije assaije, 65.536 indirizze (/16 indervalle)",
	'globalblocking-list-intro' => "Quiste jè l'elenghe de tutte le bluecche globale ca mò stonne a funzionane.<br />
Certe blocche sonde signate cumme disabbilitate in locale: quiste signifeche ca lore se applecascene su otre site, ma 'n'amministratore locale ha decise de disabbilitarle sus a sta Uicchi.",
	'globalblocking-list' => 'Elenghe de le indirizze IP bloccate globalmende',
	'globalblocking-search-legend' => "Cirche 'nu blocche globale",
	'globalblocking-search-ip' => 'Indirizze IP:',
	'globalblocking-search-submit' => 'Cirche le blocche',
	'globalblocking-list-ipinvalid' => "L'indirizze IP ca è cercate ($1) jè invalide.<br />
Pe piacere mitte 'n'indirizze IP valide.",
	'globalblocking-search-errors' => "'A ricerca toje non g'à avute resultate, {{PLURAL:$1|pu seguende|pe le seguende}} mutive:",
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bloccate globalmende [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => "scade 'u $1",
	'globalblocking-list-anononly' => 'sulamende anonime',
	'globalblocking-list-unblock' => 'live',
	'globalblocking-list-whitelisted' => 'localmende disabbiletate da $1: $2',
	'globalblocking-list-whitelist' => 'state locale',
	'globalblocking-list-modify' => 'cange',
	'globalblocking-list-noresults' => "L'indirizze IP richieste non g'è bloccate.",
	'globalblocking-goto-block' => "Bluecche globalmende 'n'indirizze IP",
	'globalblocking-goto-unblock' => "Live 'nu blocche globale",
	'globalblocking-goto-status' => "Cange 'u state locale pe 'nu blocche globale",
	'globalblocking-return' => "Tuèrne a l'elenghe de le blocche globale",
	'globalblocking-notblocked' => "L'indirizze IP ($1) ca tu è mise non g'è bloccate globalmende.",
	'globalblocking-unblock' => "Live 'nu blocche globale",
	'globalblocking-unblock-ipinvalid' => "L'indirizze IP ($1) ca tu è mise jè invalide.<br />
Pe piacere vide ca tu non ge puè mettere 'nu nome utende!",
	'globalblocking-unblock-legend' => "Live 'nu blocche globale",
	'globalblocking-unblock-submit' => "Live 'nu blocche globale",
	'globalblocking-unblock-reason' => 'Mutive:',
	'globalblocking-unblock-unblocked' => "Tu è luate 'u blocche globale #$2 cu successe sus a l'indirizze IP '''$1'''",
	'globalblocking-unblock-errors' => "'U luamende d'u blocche globale non g'à riuscute, {{PLURAL:$1|pu seguende|pe le seguende}} mutive:",
	'globalblocking-unblock-successsub' => 'Blocche globale luate cu successe',
	'globalblocking-unblock-subtitle' => "Stoche a leve 'u blocche globale",
	'globalblocking-unblock-intro' => "Tu puè ausà stu module pe luà 'nu blocche globale.",
	'globalblocking-whitelist' => 'State locale de le blocche globale',
	'globalblocking-whitelist-notapplied' => "Le blocche globale non g'onne state applicate a sta Uicchi, accussì 'u state locale de le blocche globale non ge pò essere cangiate.",
	'globalblocking-whitelist-legend' => "Cange 'u state locale",
	'globalblocking-whitelist-reason' => 'Mutive:',
	'globalblocking-whitelist-status' => 'State locale:',
	'globalblocking-whitelist-statuslabel' => 'Disabbilete stu blocche globale sus a {{SITENAME}}',
	'globalblocking-whitelist-submit' => "Cange 'u state locale",
	'globalblocking-whitelist-whitelisted' => "Tu è disabbilitate cu successe 'u blocche globale #$2 sus a l'indirizze IP '''$1''' sus a {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Tu è riabbilitate cu successe 'u blocche globale #$2 sus a l'indirizze IP '''$1''' sus a {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'ìU state locale ha state cangiate cu successe',
	'globalblocking-whitelist-nochange' => "Tu non gè fatte cangiaminde sus a le state locale de stu blocche.<br />
[[Special:GlobalBlockList|Tuèrne a l'elenghe de le blocche globale]].",
	'globalblocking-whitelist-errors' => "'U cangiamende tune a 'u state locale d'u blocche globale non g'à riuscite, {{PLURAL:$1|pu|pe le}} seguende mutive:",
	'globalblocking-whitelist-intro' => "Tu puè ausà stu module pe cangià 'u state locale de 'nu blocche globale.<br />
Ce 'nu blocche globale jè disabbilitate sus a sta Uicchi, l'utinde ca usane ste indirizze IP ponne turnà a fa cangiaminde normalmende.<br />
[[Special:GlobalBlockList|Tuèrne a l'elenghe de le blocche globale]].",
	'globalblocking-blocked' => "L'indirizze IP tune, \$5, ha state bloccate sus a tutte le Uicchi da '''\$1''' (''\$2'').<br />
'U mutive date ha state ''\"\$3\"''.<br />
'U blocche ''\$4''.",
	'globalblocking-blocked-nopassreset' => "tu non ge puè azzerà 'a password de l'utende purcé è state bloccate globalmende.",
	'globalblocking-logpage' => 'Archivije de le blocche globale',
	'globalblocking-logpagetext' => "Quiste è 'n'archivije de le blocche globale ca onne state fatte o luate da sus a sta Uicchi.<br />
S'avesse notà ca le blocche globale ponne essere fatte e luate pure sus a otre Uicchi, e 'u stesse onne effette sus a sta Uicchi.<br />
Pe vedè tutte le blocche globale attive, tu puè vedè l'[[Special:GlobalBlockList|elenghe de le blocche globale]].",
	'globalblocking-block-logentry' => "bloccate globalmende [[$1]] cu 'na scadenze de $2",
	'globalblocking-block2-logentry' => 'bloccate globalmende [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'blocche globale luate sus a [[$1]]',
	'globalblocking-whitelist-logentry' => "'u blocche globale sus a [[$1]] disabbilitate localmende",
	'globalblocking-dewhitelist-logentry' => "'u blocche globale sus a [[$1]] riabbilitate localmende",
	'globalblocking-modify-logentry' => "'u blocche globale sus a [[$1]] ha state cangiate ($2)",
	'globalblocking-logentry-expiry' => "scade 'u $1",
	'globalblocking-logentry-noexpiry' => "nisciuna scadenze 'mbostate",
	'globalblocking-loglink' => "L'indirizze IP $1 ha state bloccate globalmende ([[{{#Special:GlobalBlockList}}/$1|dettaglie comblete]]).",
	'globalblocking-showlog' => "Quiste indirizze IP ha state bloccate precedendemende.<br />
L'archivije de le blocche t'avène date aqquà sotte pe conzultazione:",
	'globalblocklist' => 'Elenghe de le indirizze IP bloccate globalmende',
	'globalblock' => "Blocche globalmende 'n'indirizze IP",
	'globalblockstatus' => 'State locale de le blocche globale',
	'removeglobalblock' => "Live 'nu blocche globale",
	'right-globalblock' => 'Mitte le blocche globale',
	'right-globalunblock' => 'Live le blocche globale',
	'right-globalblock-whitelist' => 'Disabbilete le blocche globale localmende',
	'right-globalblock-exempt' => 'Zumbe le blocche globale',
);

/** Russian (Русский)
 * @author Dim Grits
 * @author Ferrer
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Разрешает]] блокировку IP-адресов [[Special:GlobalBlockList|на нескольких вики]]',
	'globalblocking-block' => 'Глобальная блокировка IP-адреса',
	'globalblocking-modify-intro' => 'Вы можете использовать эту форму для изменения параметров глобальной блокировки.',
	'globalblocking-block-intro' => 'Вы можете использовать эту страницу чтобы заблокировать IP-адрес на всех вики.',
	'globalblocking-block-reason' => 'Причина:',
	'globalblocking-block-otherreason' => 'Другая/дополнительная причина:',
	'globalblocking-block-reasonotherlist' => 'Другая причина',
	'globalblocking-block-reason-dropdown' => '* Стандартные причины блокировки
** Межвики спам
** Межвики злоупотребления
** Вандализм',
	'globalblocking-block-edit-dropdown' => 'Править список причин',
	'globalblocking-block-expiry' => 'Закончится через:',
	'globalblocking-block-expiry-other' => 'другое время окончания',
	'globalblocking-block-expiry-otherfield' => 'Другое время:',
	'globalblocking-block-legend' => 'Глобальная блокировка участника',
	'globalblocking-block-options' => 'Настройки:',
	'globalblocking-ipaddress' => 'IP-адрес:',
	'globalblocking-ipbanononly' => 'Блокировать только анонимных участников',
	'globalblocking-block-errors' => 'Блокировка неудачна. {{PLURAL:$1|Причина|Причины}}:
$1',
	'globalblocking-block-ipinvalid' => 'Введённый вами IP-адрес ($1) ошибочен.
Пожалуйста, обратите внимание, вы не можете вводить имя участника!',
	'globalblocking-block-expiryinvalid' => 'Введённый срок окончания ($1) ошибочен.',
	'globalblocking-block-submit' => 'Заблокировать этот IP-адрес глобально',
	'globalblocking-modify-submit' => 'Изменить эту глобальную блокировку',
	'globalblocking-block-success' => 'IP-адрес $1 был успешно заблокирован во всех проектах.',
	'globalblocking-modify-success' => 'Глобальная блокировка $1 успешно изменена',
	'globalblocking-block-successsub' => 'Глобальная блокировка выполнена успешно',
	'globalblocking-modify-successsub' => 'Глобальная блокировка успешно изменена',
	'globalblocking-block-alreadyblocked' => 'IP-адрес $1 уже был заблокирован глобально.
Вы можете просмотреть существующие блокировки в [[Special:GlobalBlockList|списке глобальных блокировок]]
или изменить параметры существующей блокировки, повторно отправив эту форму.',
	'globalblocking-block-bigrange' => 'Указанный вами диапазон ($1) слишком велик для блокировки.
Вы можете заблокировать максимум 65 536 адресов (/16 область)',
	'globalblocking-list-intro' => 'Это список всех действующих глобальных блокировок.
Некоторые блокировки отмечены как выключенные локально, это означает, что они действуют на других сайтах, но локальный администратор решил отключить её в этой вики.',
	'globalblocking-list' => 'Список глобально заблокированных IP-адресов',
	'globalblocking-search-legend' => 'Поиск глобальной блокировки',
	'globalblocking-search-ip' => 'IP-адрес:',
	'globalblocking-search-submit' => 'Найти блокировки',
	'globalblocking-list-ipinvalid' => 'Вы ищете ошибочный IP-адрес ($1).
Пожалуйста введите корректный IP-адрес.',
	'globalblocking-search-errors' => 'Ваш поиск не был успешен. {{PLURAL:$1|Причина|Причины}}:
$1',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') глобально заблокировал [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'истекает $1',
	'globalblocking-list-anononly' => 'только анонимов',
	'globalblocking-list-unblock' => 'разблокировать',
	'globalblocking-list-whitelisted' => 'локально отключил $1: $2',
	'globalblocking-list-whitelist' => 'локальное состояние',
	'globalblocking-list-modify' => 'изменить',
	'globalblocking-list-noresults' => 'Запрашиваемый адрес не заблокирован.',
	'globalblocking-goto-block' => 'Заблокировать IP-адрес глобально',
	'globalblocking-goto-unblock' => 'Убрать глобальную блокировку',
	'globalblocking-goto-status' => 'Изменить локальное состояние глобальной блокировки',
	'globalblocking-return' => 'Вернуться к списку глобальных блокировок',
	'globalblocking-notblocked' => 'Введённый вами IP-адрес ($1) не заблокирован глобально.',
	'globalblocking-unblock' => 'Снять глобальную блокировку',
	'globalblocking-unblock-ipinvalid' => 'Введённый вами IP-адрес ($1) ошибочен.
Пожалуйста, обратите внимание, вы не можете вводить имя участника!',
	'globalblocking-unblock-legend' => 'Снятие глобальной блокировки',
	'globalblocking-unblock-submit' => 'Снять глобальную блокировку',
	'globalblocking-unblock-reason' => 'Причина:',
	'globalblocking-unblock-unblocked' => "Вы успешно сняли глобальную блокировку #$2 с IP-адреса '''$1'''",
	'globalblocking-unblock-errors' => 'Попытка снять глобальную блокировку не удалась. {{PLURAL:$1|Причина|Причины}}:',
	'globalblocking-unblock-successsub' => 'Глобальная блокировка успешно снята',
	'globalblocking-unblock-subtitle' => 'Снятие глобальной блокировки',
	'globalblocking-unblock-intro' => 'Вы можете использовать эту форму для снятия глобальной блокировки.',
	'globalblocking-whitelist' => 'Локальное состояние глобальной блокировки',
	'globalblocking-whitelist-notapplied' => 'В этой вики не применяются глобальные блокировки,
поэтому локальные статусы глобальных блокировок не могут быть изменены.',
	'globalblocking-whitelist-legend' => 'Изменение локального состояния',
	'globalblocking-whitelist-reason' => 'Причина:',
	'globalblocking-whitelist-status' => 'Локальное состояние:',
	'globalblocking-whitelist-statuslabel' => 'Отключить эту глобальную блокировку в {{grammar:genitive|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Изменить локальное состояние',
	'globalblocking-whitelist-whitelisted' => "Вы успешно отключили глобальную блокировку #$2 IP-адреса '''$1''' в {{grammar:genitive|{{SITENAME}}}}",
	'globalblocking-whitelist-dewhitelisted' => "Вы успешно восстановили глобальную блокировку #$2 IP-адреса '''$1''' в {{grammar:genitive|{{SITENAME}}}}",
	'globalblocking-whitelist-successsub' => 'Локальное состояние успешно измененно',
	'globalblocking-whitelist-nochange' => 'Вы не произвели изменений локального состояния этой блокировки.
[[Special:GlobalBlockList|Вернуться к списку глобальных блокировок]].',
	'globalblocking-whitelist-errors' => 'Попытка изменить локальное состояние глобальной блокировки не удалась. {{PLURAL:$1|Причина|Причины}}:',
	'globalblocking-whitelist-intro' => 'Вы можете использовать эту форму для изменения локального состояния глобальной блокировки.
Если глобальная блокировка будет выключена в этой вики, участники с соответствующими IP-адресами смогут нормально редактировать страницы.
[[Special:GlobalBlockList|Вернуться к списку глобальных блокировок]].',
	'globalblocking-blocked' => "Ваш IP-адрес $5 был заблокирован во всех вики участником '''$1''' (''$2'').
Была указана причина: ''«$3»''.
Эта блокировка ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Вы не можете сбрасывать пароли участников, так как вы заблокированы на глобальном уровне.',
	'globalblocking-logpage' => 'Журнал глобальных блокировок',
	'globalblocking-logpagetext' => 'Это журнал глобальных блокировок, установленных и снятых в этой вики.
Следует отметить, что глобальные блокировки могут быть установлены в других вики, но действовать также и в данной вики.
Чтобы просмотреть список всех глобальных блокировок, обратитесь к [[Special:GlobalBlockList|соответствующему списку]].',
	'globalblocking-block-logentry' => 'заблокировал глобально [[$1]] со сроком блокировки $2',
	'globalblocking-block2-logentry' => 'глобально заблокировал [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'снял глобальную блокировку с [[$1]]',
	'globalblocking-whitelist-logentry' => 'локально отключена глобальная блокировка [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'локально восстановлена глобальная блокировка [[$1]]',
	'globalblocking-modify-logentry' => 'изменил глобальную блокировку [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'истекает  $1',
	'globalblocking-logentry-noexpiry' => 'срок действия не установлен',
	'globalblocking-loglink' => 'IP-адрес $1 заблокирован глобально ([[{{#Special:GlobalBlockList}}/$1|подробнее]]).',
	'globalblocking-showlog' => 'Этот IP-адрес уже был заблокирован ранее.
Ниже для справки приведён журнал блокировок:',
	'globalblocklist' => 'Список заблокированных глобально IP-адресов',
	'globalblock' => 'Глобальная блокировка IP-адреса',
	'globalblockstatus' => 'Локальные состояния глобальных блокировок',
	'removeglobalblock' => 'Снять глобальную блокировку',
	'right-globalblock' => 'наложение глобальных блокировок',
	'right-globalunblock' => 'снятие глобальных блокировок',
	'right-globalblock-whitelist' => 'локальное отключение глобальных блокировок',
	'right-globalblock-exempt' => 'обход глобальных блокировок',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Доволює]] блоковати IP адресы [[Special:GlobalBlockList|на веце вікі сучасно]]',
	'globalblocking-block' => 'Заблоковати IP адресу ґлобално',
	'globalblocking-modify-intro' => 'За помочі того формуларя можете змінити наставлїня ґлобалного блокованя.',
	'globalblocking-block-intro' => 'За помочі той сторінкы можете дакотру IP адресу блоковати на вшыткых вікі.',
	'globalblocking-block-reason' => 'Причіна:',
	'globalblocking-block-otherreason' => 'Інша/далша причіна:',
	'globalblocking-block-reasonotherlist' => 'Інша причіна',
	'globalblocking-block-reason-dropdown' => '* Часты причіны блокованя
** Спам на різных вікі
** Знеужываня на різных вікі
** Вандалізм',
	'globalblocking-block-edit-dropdown' => 'Едітовати причіны блоковань',
	'globalblocking-block-expiry' => 'Кінчіть:',
	'globalblocking-block-expiry-other' => 'Інша довжка блоку',
	'globalblocking-block-expiry-otherfield' => 'Іншый час:',
	'globalblocking-block-legend' => 'Ґлобално блоковати IP адресу',
	'globalblocking-block-options' => 'Можности:',
	'globalblocking-block-errors' => 'Спроба наставити ґлобалне блокованя ся не подарила про  {{PLURAL:$1|наступну причіну|наступны причіны}}:',
	'globalblocking-block-ipinvalid' => 'Вами зазначена IP адреса ($1) не є платна.
Усвідомте собі, же не можете задати імя хоснователя!',
	'globalblocking-block-expiryinvalid' => 'Уведеный час експірації  ($1) неправилный.',
	'globalblocking-block-submit' => 'Ґлобално блоковати IP адресу',
	'globalblocking-modify-submit' => 'Змінити тото ґлобалне блокованя',
	'globalblocking-block-success' => 'IP адреса $1 была на вшыткых проєктах успішно заблокована.',
	'globalblocking-modify-success' => 'Ґлобалне блокованя $1 успішно змінене',
	'globalblocking-block-successsub' => 'Ґлобалне блокованя прошло успішно.',
	'globalblocking-modify-successsub' => 'Ґлобалне блокваня успішно змінене',
	'globalblocking-block-alreadyblocked' => 'IP адреса $1 є уж успішно блокована.
Єствуючі блокованя собі можете посмотрити на [[Special:GlobalBlockList|списки ґлобалных блоковань]], наставлїна актуалного блокованя можете змінити повторным одосланём того формуларя.',
	'globalblocking-block-bigrange' => 'Вами зазначеный россяг  ($1) ся не дасть блоковати,  бо є дуже великый. Можете блоковати максімално 65&nbsp;535 адрес (россяг /16).',
	'globalblocking-list-intro' => 'Тото є список вшыткых платных ґлобалных блоковань. Дакотры блокованя суть означены як локално неплатны: то значіть, же учінкує на іншых вікі, але локалный адміністратор зволив їх на тій вікі выпнути.',
	'globalblocking-list' => 'Список ґлобално заблокованых IP адрес',
	'globalblocking-search-legend' => 'Гляданя ґлобалного блокованя',
	'globalblocking-search-ip' => 'IP-адреса:',
	'globalblocking-search-submit' => 'Найти блокованя',
	'globalblocking-list-ipinvalid' => 'IP адреса ($1), котру сьте хотїли найти є неправилна.
Уведьте правилну IP адресу.',
	'globalblocking-search-errors' => 'Ваше гляданя было неуспішне про  {{PLURAL:$1|наступну причіну|наступны причіны}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') ґлобално блокує [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'кінчіть ся $1',
	'globalblocking-list-anononly' => 'лем анонімы',
	'globalblocking-list-unblock' => 'уволнити',
	'globalblocking-list-whitelisted' => 'локално знеплатнив $1: $2',
	'globalblocking-list-whitelist' => 'локалный статус',
	'globalblocking-list-modify' => 'змінити',
	'globalblocking-list-noresults' => 'Зазначена IP-адреса не є блокована.',
	'globalblocking-goto-block' => 'Заблоковати IP адресу ґлобално',
	'globalblocking-goto-unblock' => 'Зняти ґлобалне блокованя',
	'globalblocking-goto-status' => 'Змінити локалный статус ґлобалного блокованя',
	'globalblocking-return' => 'Навернутя на список ґлобалных блоковань',
	'globalblocking-notblocked' => 'Вами зазначена IP адреса ($1) не є ґлобално блокована.',
	'globalblocking-unblock' => 'Зняти ґлобалне блокованя',
	'globalblocking-unblock-ipinvalid' => 'Вами зазначена IP адреса ($1) не є платна.
Усвідомте собі, же не можете задати імя хоснователя!',
	'globalblocking-unblock-legend' => 'Знятя ґлобалного блокованя',
	'globalblocking-unblock-submit' => 'Зняти ґлобалне блокованя',
	'globalblocking-unblock-reason' => 'Причіна:',
	'globalblocking-unblock-unblocked' => "Успішно сьте зняли ґлобалне блокованя #$2 з IP адресы '''$1'''",
	'globalblocking-unblock-errors' => 'Спроба зняти ґлобалне блокованя ся не подарила. {{PLURAL:$1|Причіна|Причіны}}:',
	'globalblocking-unblock-successsub' => 'Ґлобалне блокованя успішно зняте',
	'globalblocking-unblock-subtitle' => 'Знятя ґлобалного блокованя',
	'globalblocking-unblock-intro' => 'Тым формуларём можете зняти ґлобалне блокованя.',
	'globalblocking-whitelist' => 'Локалный статус ґлобалного блокованя',
	'globalblocking-whitelist-notapplied' => 'На тій вікі ся не аплікує ґлобалне блокованя, также ся не дасть мінити їх локалне наставлїня.',
	'globalblocking-whitelist-legend' => 'Зміна локалного статуса',
	'globalblocking-whitelist-reason' => 'Причіна:',
	'globalblocking-whitelist-status' => 'Локалный статус:',
	'globalblocking-whitelist-statuslabel' => 'Знеплатнити тото ґлобалне блокованя на {{GRAMMAR:6sg|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Змінити локалный статус',
	'globalblocking-whitelist-whitelisted' => "Успішно сьте зняли ґлобалне блокованя #$2 з IP адресы '''$1'''",
	'globalblocking-whitelist-dewhitelisted' => "Успішно сьте на {{grammar:6sg|{{SITENAME}}}} зрушыли выняток з ґлобалного блокованя #$2 IP адресы '''$1'''.",
	'globalblocking-whitelist-successsub' => 'Локалный статус быв успішно зміненый',
	'globalblocking-whitelist-nochange' => 'На статусі того блокованя сьте ніч не змінилу. [[Special:GlobalBlockList|Навернутя на список ґлобалных блоковань.]]',
	'globalblocking-whitelist-errors' => 'Z {{PLURAL:$1|наступной причіны|наступных причін}} ся не подарило змінити локалный статус ґлобалного блокованя:',
	'globalblocking-whitelist-intro' => 'За помочі того формуларя можете змінити локалный статус ґлобалного блокованя.
Кідь буде ґлобалне блокованя на тій вікі зрушене, хоснователї будуть мочі на одповідній IP адресї нормално едітовати.
[[Special:GlobalBlockList|Навернутя на список ґлобалных блоковань]].',
	'globalblocking-blocked' => "Вашій IP aдресї $5 было ґлобално заблокована на вшыткых вікі можность едітованя. Заблоковав вас хоснователь '''$1''' (''$2'').
Уведенов причінов было ''„$3“''. Блокованя тырвать до ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Не можете жадати о посланя нового гесла, бо сьте ґлобално {{GENDER:|блокованый|блокована|блокованый}}.',
	'globalblocking-logpage' => 'Лоґ ґлобалных блоковань',
	'globalblocking-logpagetext' => 'Тото є лоґ ґлобалного блокованя і їх уволнїня выконаных на тій вікі. 
Ґлобалны блокованя ся дають провести і на іншых вікі і тоты овпливнюють блокованя на тотій вікі. 
Вшыткы актівны ґлобалны блокованя найдете на [[Special:GlobalBlockList|списки ґлобално блокованых IP адрес]].',
	'globalblocking-block-logentry' => 'ґлобално заблокoвав [[$1]] на термін $2',
	'globalblocking-block2-logentry' => 'ґлобално заблоковав [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'зняв ґлобалне блокованя з [[$1]]',
	'globalblocking-whitelist-logentry' => 'локално знеплатнив ґлобалне блокованя [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'локално зрушыв выняток з ґлобалного блокованя [[$1]]',
	'globalblocking-modify-logentry' => 'змінив ґлобалне блокованя [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'кінчіть ся $1',
	'globalblocking-logentry-noexpiry' => 'без терміну закінчіня',
	'globalblocking-loglink' => 'IP адреса $1 є ґлобално блокованя ([[{{#Special:GlobalBlockList}}/$1|детайлы]]).',
	'globalblocking-showlog' => 'Тота IP адреса была уж скоре блокована.
Ту є про перегляд вказаный выпис з книгы блокованя:',
	'globalblocklist' => 'Список ґлобално заблокованых IP адрес',
	'globalblock' => 'Заблоковати IP адресу ґлобално',
	'globalblockstatus' => 'Локалный статус ґлобалного блокованя',
	'removeglobalblock' => 'Зняти ґлобалне блокованя',
	'right-globalblock' => 'Ґлобалне блокованя',
	'right-globalunblock' => 'Знятя ґлобалных блоковань',
	'right-globalblock-whitelist' => 'Дефінованя вынятків з ґлобалного блокованя',
	'right-globalblock-exempt' => 'Обходжаня ґлобалных блоковань',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'globalblocking-block-reason' => 'कारणम् :',
	'globalblocking-unblock-reason' => 'कारणम् :',
	'globalblocking-whitelist-reason' => 'कारणम् :',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlockList|Хас да биикигэ]] IP аадырыһы [[Special:GlobalBlock|бобору көҥүллүүр]]',
	'globalblocking-block' => 'IP аадырыһы бырайыактарга барыларыгар бобуу',
	'globalblocking-modify-intro' => 'Бу форманы биирдэһиллибит бобуу туруорууларын уларытарга туттуоххун сөп.',
	'globalblocking-block-intro' => 'Бу сирэйи туһанан IP аадырыһы бары биикилэргэ бобуоххун сөп.',
	'globalblocking-block-reason' => 'Төрүөтэ:',
	'globalblocking-block-otherreason' => 'Атын/эбии төрүөт:',
	'globalblocking-block-reasonotherlist' => 'Атын төрүөт',
	'globalblocking-block-reason-dropdown' => '* Хааччахтааһын стандартнай төрүөттэрэ
** Биики ыккардынааҕы спаам
** Биики ыккардынааҕы омсолор
** Вандааллааһын',
	'globalblocking-block-edit-dropdown' => 'Бобуу төрүөтүн уларыт',
	'globalblocking-block-expiry' => 'Түмүктэниэ:',
	'globalblocking-block-expiry-other' => 'Бүтүү атын больдьоҕо',
	'globalblocking-block-expiry-otherfield' => 'Атын болдьох:',
	'globalblocking-block-legend' => 'IP-ны бары бырайыактарга хааччахтааһын',
	'globalblocking-block-options' => 'Туруоруулар:',
	'globalblocking-block-errors' => 'Хааччахтааһын сатаммата, {{PLURAL:$1|төрүөтэ|төрүөттэрэ}}:',
	'globalblocking-block-ipinvalid' => 'Киллэрбит ($1) IP-ҥ алҕастаах.
Бука диэн өйдөө, кытааччы аатын киллэрэр кыаҕыҥ суох!',
	'globalblocking-block-expiryinvalid' => 'Болдьообутуҥ ($1) алҕастаах.',
	'globalblocking-block-submit' => 'Бу IP-ну бары бырайыактарга хааччахтаа',
	'globalblocking-modify-submit' => 'Бу биирдэһиллибит бобууну уларытыы',
	'globalblocking-block-success' => '$1 IP туох баар бырайыактарга хааччахтанна.',
	'globalblocking-modify-success' => '$1 биирдэһиллибит бобуу сөпкө уларыйда',
	'globalblocking-block-successsub' => 'Хааччахтааһын сатанна',
	'globalblocking-modify-successsub' => 'Биирдэһиллибит бобуу сөпкө уларыйда',
	'globalblocking-block-alreadyblocked' => 'Бу $1 IP бэлиэр хааччахтаммыт.
[[Special:GlobalBlockList|Бырайыактар ыккардыларынааҕы хааччахтар тиһиктэригэр]] билиҥҥи хааччахтары көрүөххүн сөп
эбэтэр бу форманы иккистээн ыытан, бобуу туруорууларын уларытан биэриэххин сөп.',
	'globalblocking-block-bigrange' => 'Эппит ($1) диапазонуҥ хааччахтыырга наһаа улахан.
65 536 аадырыһы (/16 уобалас) биирдэ хааччахтыаххын сөп.',
	'globalblocking-list-intro' => 'Бу бырайыактар ыккардыларыгар туттуллар хааччахтар тиһиктэрэ.
Сорох хааччахтар сорох бырайыактарга арахсыбыт курдук көстөллөр: ол аата, хааччахтааһын ол биирдиилээн биикигэ дьаһабыл быһаарыытынан уһуллубут, ол гынан баран атын бырайыактарга үлэлиир.',
	'globalblocking-list' => 'Бырайыактар ыккардыларынааҕы бобуллубут IP-лар тиһиктэрэ',
	'globalblocking-search-legend' => 'Бобууну көрдөөһүн',
	'globalblocking-search-ip' => 'IP аадырыһа:',
	'globalblocking-search-submit' => 'Бобуулары бул',
	'globalblocking-list-ipinvalid' => 'Эн сыыһа IP аадырыһы көрдөөтүҥ ($1).
Бука диэн сөптөөх IP-ны киллэр.',
	'globalblocking-search-errors' => 'Көрдөөбүтүҥ сатаммата, ол {{PLURAL:$1|төрүөтэ|төрүөттэрэ}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') бу кыттааччыны бопто: [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'болдьоҕо баччаҕа бүтэр: $1',
	'globalblocking-list-anononly' => 'ааттамматах эрэ кыттааччылары',
	'globalblocking-list-unblock' => 'хааччаҕын уһул',
	'globalblocking-list-whitelisted' => '$1 миэстэтигэр араарбыт: $2',
	'globalblocking-list-whitelist' => 'маннааҕы турук (статус)',
	'globalblocking-list-modify' => 'тупсарарга',
	'globalblocking-list-noresults' => 'Көрдөбүлгэ ыйыллыбыт аадырыс хааччахтамматах.',
	'globalblocking-goto-block' => 'IP-ны бары бырайыактарга боп',
	'globalblocking-goto-unblock' => 'Бобууну суох гын',
	'globalblocking-goto-status' => 'Бобуу туругун уларытыы',
	'globalblocking-return' => 'Бобуулар тиһиктэригэр төннүү',
	'globalblocking-notblocked' => 'Эн киллэрбит IP-ҥ ($1) бырайыактарга барытыгар бобуллубатах.',
	'globalblocking-unblock' => 'Бобууну уһул',
	'globalblocking-unblock-ipinvalid' => 'Киллэрбит IP-ҥ алҕастаах ($1).
Кыттааччы аатын киллэрэр табыллыбатын билэр инигин.',
	'globalblocking-unblock-legend' => 'Бобууну устуу',
	'globalblocking-unblock-submit' => 'Бобууну суох оҥор',
	'globalblocking-unblock-reason' => 'Төрүөтэ:',
	'globalblocking-unblock-unblocked' => "'''$1''' IP-тан #$2 бобууну уһуллуҥ",
	'globalblocking-unblock-errors' => 'Бобууну уһулар сатаммата, {{PLURAL:$1|төрүөтэ|төрүөттэрэ}} маннык:',
	'globalblocking-unblock-successsub' => 'Бобуу сөпкө уһулунна',
	'globalblocking-unblock-subtitle' => 'Бобууну уһулуу',
	'globalblocking-unblock-intro' => 'Бу форманы туһанан бобууну суох оҥоруоххун сөп.',
	'globalblocking-whitelist' => 'Бырайыактар ыккардыларынааҕы бобуулар олохтоох туруктара (локальное состояние)',
	'globalblocking-whitelist-notapplied' => 'Бу биикигэ аан бобуулар туттуллубаттар,
ол иһин олохтоох (локальнай) стаатустар уларытыллар кыахтара суох.',
	'globalblocking-whitelist-legend' => 'Олохтоох турук (локальный статус) уларытыыта',
	'globalblocking-whitelist-reason' => 'Төрүөтэ:',
	'globalblocking-whitelist-status' => 'Олохтоох (локальнай) турук:',
	'globalblocking-whitelist-statuslabel' => 'Бу бобууну {{SITENAME}} саайтыгар араар',
	'globalblocking-whitelist-submit' => 'Олохтоох (локальнай) туругу уларытыы',
	'globalblocking-whitelist-whitelisted' => "IP-ны '''$1''' {{SITENAME}} саайтыгар #$2 хааччахтаныытын уһуллуҥ.",
	'globalblocking-whitelist-dewhitelisted' => "IP '''$1''' {{SITENAME}} саайтыгар #$2 бобуллуутун сөпкө төннөрдүҥ.",
	'globalblocking-whitelist-successsub' => 'Олохтоох (локал) статус сөпкө уларыйда',
	'globalblocking-whitelist-nochange' => 'Бу бобуу олохтоох (локал) туругун уларыппатыҥ.
[[Special:GlobalBlockList|Бобуу тиһигэр төнүн]].',
	'globalblocking-whitelist-errors' => 'Олохтоох туругу уларытыы табыллыбытата. {{PLURAL:$1|Төрүөтэ|Төрүөттэрэ}} маннык:',
	'globalblocking-whitelist-intro' => 'Бу форманы туһанан бырайыактар ыккардыларынааҕы бобуу олохтоох (локал) туругун уларытыаххын сөп. 
Өскө бырайыак ыккардынааҕы бобуу бу биикигэ араарыллар түбэлтэтигэр бобуллубут IP-тан киирэр кыттааччылар сирэйдэри уларытар кыахтаныахтара.
[[Special:GlobalBlockList|Бобуу тиһигэр төннөргө]].',
	'globalblocking-blocked' => "Эн IP-гыттан бары биикилэргэ киирэри '''\$1''' (''\$2'') боппут.
Ыйыллыбыт төрүөтэ: ''\"\$3\"''.
Бобуу ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Атыттар киирии тылларын сотор кыаҕыҥ суох, тоҕо диэтэххэ эн бэлиэтэммит аатыҥ үрдүк таһымҥа хааччахтаммыт.',
	'globalblocking-logpage' => 'Бырайыактар ыккардыларынааҕы бобуу сурунаала',
	'globalblocking-logpagetext' => 'Бырайыактар ыккардыларынааҕы бобуу сурунаала, манна хааччахтааһыны туруоруу уонна ону устуу суруллар.
Бырайыак ыккардыларынааҕы бобуу атын биикигэ туруоруллубут буолуон сөп, оччоҕо ол бобуу бу биикигэ эмиэ үлэлиир.
Туох баар бобуулары көрөргө [[Special:GlobalBlockList|бары бобуулар аналлаах тиһиктэрин]] көр.',
	'globalblocking-block-logentry' => 'бырайыактарга барытыгар [[$1]] бопто, болдьоҕо: $2',
	'globalblocking-block2-logentry' => 'бопто [[$1]] ($2)',
	'globalblocking-unblock-logentry' => '[[$1]]-тан бобууну уһулла',
	'globalblocking-whitelist-logentry' => 'бырайыактарга барытыгар дьайар бобуу [[$1]] манна араарыллыбыт',
	'globalblocking-dewhitelist-logentry' => 'бырайыактарга барытыгар дьайар бобуу [[$1]] иккистээн холбонно',
	'globalblocking-modify-logentry' => 'бобууну уларытта [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'болдьоҕо $1',
	'globalblocking-logentry-noexpiry' => 'болдьоҕо суох',
	'globalblocking-loglink' => 'IP-аадырыс $1 бары бырайыактарга хааччахтаммыт. ([[{{#Special:GlobalBlockList}}/$1|Сиһилии]]).',
	'globalblocking-showlog' => 'Бу аадырыс урут хааччахтана сылдьыбыт эбит.
Аллара хааччахтааһын сурунаала бэриллэр:',
	'globalblocklist' => 'Бырйыактарга барыларыгар бобуллубут IP-лар тиһиктэрэ',
	'globalblock' => 'IP-ны бары бырайыактарга бобуу',
	'globalblockstatus' => 'Бырайыактарга барыларыгар бобуу олохтоох (локал) туруга',
	'removeglobalblock' => 'Бырайыактарга барытыгар бобуллууну уһул',
	'right-globalblock' => 'Бырайыактарга барыларыгар дьайар бобууну туруоруу',
	'right-globalunblock' => 'бобууну устуу',
	'right-globalblock-whitelist' => 'бырайыактарга барытыгар дьайар бобуулары араарыы',
	'right-globalblock-exempt' => 'Үрдүк таһымҥа бобууну тумнуу',
);

/** Sardinian (Sardu)
 * @author Marzedu
 */
$messages['sc'] = array(
	'globalblocking-search-ip' => 'Indiritzu IP:',
	'globalblocking-unblock-reason' => 'Motivu:',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 * @author Gmelfi
 * @author Melos
 * @author Santu
 */
$messages['scn'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Pirmetti]] di [[Special:GlobalBlockList|bluccari supra a chiossai wiki]] nnirizzi IP',
	'globalblocking-block' => 'Blocca gubbalmenti nu nnirizzu IP',
	'globalblocking-block-intro' => 'È pussìbbili usari sta pàggina pi bluccari nu nnirizzu IP supra a tutti li wiki.',
	'globalblocking-block-reason' => 'Mutivu:',
	'globalblocking-block-expiry' => 'Finuta dô bloccu:',
	'globalblocking-block-expiry-other' => 'Àutri tempi di scadenza',
	'globalblocking-block-expiry-otherfield' => 'Durata non ntâ lista:',
	'globalblocking-block-legend' => "Blocca n'utenti glubbalmenti",
	'globalblocking-block-options' => 'Opzioni:',
	'globalblocking-block-errors' => 'Lu bloccu non fu fattu pi {{PLURAL:$1|stu mutivu|sti mutivi}}:',
	'globalblocking-block-ipinvalid' => 'Lu nnirizzu IP ($1) ca nziristi nun è vàlidu. Teni accura ô fattu ca non po nziriri nu nomu utenti!',
	'globalblocking-block-expiryinvalid' => 'La scadenza ca nziristi ($1) non vali.',
	'globalblocking-block-submit' => 'Blocca stu nnirizzu IP glubbalmenti',
	'globalblocking-block-success' => 'Lu nnirizzu IP $1 vinni bluccatu cu successu supra a tutti li pruggetti.',
	'globalblocking-block-successsub' => 'Bloccu glubbali fattu cu successu',
	'globalblocking-block-alreadyblocked' => 'Lu nnirizzu IP $1 già vinni bluccatu. È pussìbbili taliari lu bloccu attivu ntâ [[Special:GlobalBlockList|lista dê blocchi glubbali]].',
	'globalblocking-block-bigrange' => 'La classi ca nnicasti ($1) è troppu granni pi èssiri bluccata. È pussìbbili bluccari, ô cchiossai, 65.536 nnirizzi (classi /16)',
	'globalblocking-list-intro' => "Ccà di sècutu c'è la lista di tutti li blocchi ca sunnu ora attivi. Ci sunnu tanti blocchi signaliati comu disattivati lucalmenti: chistu voli diri ca chissi sunnu attivi supra a àutri siti, ma n'amministraturi lucali dicidìu di disattivàrili supra a ddà wiki.",
	'globalblocking-list' => 'Lista di li nnirizzi IP bluccati glubbalmenti',
	'globalblocking-search-legend' => 'Cerca nu bloccu glubbali',
	'globalblocking-search-ip' => 'Nnirizzu IP:',
	'globalblocking-search-submit' => 'Circata di blocchi',
	'globalblocking-list-ipinvalid' => 'Lu nnirizzu IP ca circasti ($1) non vali. Nzirisci nu nnirizzu IP ca vali.',
	'globalblocking-search-errors' => 'La tò circata non desi nuddu risurtatu pi {{PLURAL:$1|stu mutivu|sti mutivi}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bluccau glubbalmenti [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'finuta dû bloccu $1',
	'globalblocking-list-anononly' => 'Sulu anònimi',
	'globalblocking-list-unblock' => 'rimovi',
	'globalblocking-list-whitelisted' => 'disattivatu lucalmenti di $1: $2',
	'globalblocking-list-whitelist' => 'statu lucali',
	'globalblocking-list-modify' => 'cancia',
	'globalblocking-goto-block' => 'Blocca glubbalmenti nu nnirizzu IP',
	'globalblocking-goto-unblock' => 'Scancella nu bloccu glubbali',
	'globalblocking-goto-status' => 'Cancia statu lucali di nu bloccu glubbali',
	'globalblocking-return' => 'Torna ntâ lista dê blocchi glubbali',
	'globalblocking-notblocked' => 'Lu nnirizzu IP ($1) ca nziristi nun è bluccatu glubbalmenti.',
	'globalblocking-unblock' => 'Scancella nu bloccu glubbali',
	'globalblocking-unblock-ipinvalid' => 'Lu nnirizzu IP ($1) ca nziristi non vali. Teni accura ô fattu ca non pooi nziriri nu nomu utenti!',
	'globalblocking-unblock-legend' => 'Scancella nu bloccu glubbali',
	'globalblocking-unblock-submit' => 'Scancella bloccu glubbali',
	'globalblocking-unblock-reason' => 'Mutivu:',
	'globalblocking-unblock-unblocked' => "Vinni scancillatu cu successu lu bloccu glubbali #$2 pupra a lu nnirizzu IP '''$1'''",
	'globalblocking-unblock-errors' => "La scancillazzioni dû bloccu glubbali c'addumannasti non fi fatta pi {{PLURAL:$1|stu mutivu|sti  mutivi}}:",
	'globalblocking-unblock-successsub' => 'Bloccu glubbali scancillatu cu successu',
	'globalblocking-unblock-subtitle' => 'Scancillazzioni bloccu glubbali',
	'globalblocking-whitelist-reason' => 'Mutivu:',
	'globalblocking-logentry-expiry' => 'scari $1',
	'globalblockstatus' => 'Statu lucali di blocca glubbali',
	'right-globalblock-exempt' => 'Bypassa li blocchi globali',
);

/** Samogitian (Žemaitėška)
 * @author Hugo.arg
 */
$messages['sgs'] = array(
	'globalblocking-list' => 'Gluobalē ožblokoutu IP adresū sārošos',
	'globalblocking-list-expiry' => 'beng galiuotė $1',
);

/** Sinhala (සිංහල)
 * @author Budhajeewa
 * @author Thameera123
 * @author තඹරු විජේසේකර
 * @author නන්දිමිතුරු
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'globalblocking-desc' => 'IP ලිපිනය [[Special:GlobalBlockList|විකියන් කිහිපයකදී අවහිර කිරීමට]] [[Special:GlobalBlock|ඉඩදෙයි]]',
	'globalblocking-block' => 'IP ලිපිනයක් ගෝලීයව වාරණය කරන්න',
	'globalblocking-modify-intro' => 'මෙම ගෝලීය අවහිරතාවයේ තත්වය වෙනස් කෙරුමට මෙම ෆෝරමය භාවිතා කළ හැක.',
	'globalblocking-block-intro' => 'සියළුම විකියන්හීදි IP ලිපිනයක් වාරණය කිරීමට මෙම පිටුව භාවිතා කළ හැක.',
	'globalblocking-block-reason' => 'හේතුව:',
	'globalblocking-block-otherreason' => 'වෙනත්/අමතර හේතු:',
	'globalblocking-block-reasonotherlist' => 'අනෙකුත් හේතුව',
	'globalblocking-block-reason-dropdown' => '* පොදු වාරණ හේතු
** විකියන් කිහිපයකදී ස්පෑමීම
** විකියන් කිහිපයක් අපයෝජනය කිරීම
** විනාශකාරීත්වය',
	'globalblocking-block-edit-dropdown' => 'වාරණ හේතූන් සංස්කරණය කරන්න',
	'globalblocking-block-expiry' => 'කල් ඉකුත්වීම:',
	'globalblocking-block-expiry-other' => 'අනෙකුත් කල් ඉකුත්වීම් වේලාව',
	'globalblocking-block-expiry-otherfield' => 'අනෙකුත් වේලාව:',
	'globalblocking-block-legend' => 'IP ලිපිනයක් ගෝලීයව වාරණය කරන්න',
	'globalblocking-block-options' => 'විකල්පයන්:',
	'globalblocking-ipaddress' => 'IP ලිපිනය:',
	'globalblocking-ipbanononly' => 'නිර්නාමික පරිශීලකයන් පමණක් වාරණය කරන්න',
	'globalblocking-block-errors' => 'පහත සඳහන් {{PLURAL:$1|හේතුව|හේතූන්}} නිසා වාරණය අසාර්ථක විය:',
	'globalblocking-block-ipinvalid' => 'ඔබ ඇතුළත් කළ IP ලිපිනය ($1) සදොස්ය. 
ඔබට පරිශීලක නමක් ඇතුළත් කළ නොහැකි බව සළකන්න!',
	'globalblocking-block-expiryinvalid' => 'ඔබ ඇතුල් කළ කල් ඉකුතුව ($1) සදොස්ය.',
	'globalblocking-block-submit' => 'මෙම IP ලිපිනය ගෝලීයව වාරණය කරන්න',
	'globalblocking-modify-submit' => 'මෙම ගෝලීය වාරණය වෙනස් කරන්න',
	'globalblocking-block-success' => '$1 IP ලිපිනය සියළුම ව්‍යාපෘතීන්හිදී සාර්ථකව වාරණය කෙරිනි.',
	'globalblocking-modify-success' => '$1 සඳහා වූ ගෝලීය වාරණය සාර්ථකව වෙනස් කෙරිනි',
	'globalblocking-block-successsub' => 'සාර්ථකව ගෝලීය වාරණය කෙරිනි',
	'globalblocking-modify-successsub' => 'සාර්ථකව ගෝලීය වාරණය වෙනස් කෙරිනි',
	'globalblocking-block-alreadyblocked' => '$1 IP ලිපිනය දැනටම ගෝලීයව වාරණය කර ඇත.
ඔබට [[Special:GlobalBlockList|ගෝලීය වාරණ ලයිස්තුව]] මගින් දැනට පවතින වාරණය දැකගත හැක,
එසේ නැතිනම් මෙම ෆෝරමය නැවත එවීමෙන් දැනට පවතින වාරණයේ සැකසුම් වෙනස් කළ හැක.',
	'globalblocking-block-bigrange' => 'ඔබ දැක්වූ පරාසය ($1) වාරණය සඳහා විශාල වැඩිය.
ඔබට උපරිම වශයෙන් ලිපින 65,536ක්(/පරාස 16ක්) වාරණය කළ හැක.',
	'globalblocking-list-intro' => 'මේ දැන් ක්‍රියාත්මක තත්වයේ පවතින ගෝලීය වාරණ ලයිස්තුවකි.
ඇතැම් වාරණ ප්‍රාදේශිය අක්‍රීය ලෙස දක්වා ඇත: එයින් හැඟවෙන්නේ එම වාරණ අනෙක් අඩවි මත ක්‍රියා කරන නමුත් මෙම විකියේදී ඒවා අක්‍රීය කෙරුමට ප්‍රාදේශීය පරිපාලකයෙකු තීරණය කර ඇති බවයි.',
	'globalblocking-list' => 'ගෝලීයව වාරණය කළ IP ලිපින ලයිස්තුව',
	'globalblocking-search-legend' => 'ගෝලීය වාරණයක් සඳහා සොයන්න',
	'globalblocking-search-ip' => 'අන්තර්ජාල ලිපිනය:',
	'globalblocking-search-submit' => 'වාරණ සඳහා සොයන්න',
	'globalblocking-list-ipinvalid' => 'ඔබ සෙවූ IP ලිපිනය ($1) සදොස්ය.
කරුණාකර නිවැරදි IP ලිපිනයක් ඇතුලත් කරන්න.',
	'globalblocking-search-errors' => 'පහත සඳහන් {{PLURAL:$1|හේතුව|හේතූන්}} නිසා සෙවුම අසාර්ථක විය:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') [[Special:Contributions/\$4|\$4]] ගෝලීයව වාරිතයි. ''(\$5)''",
	'globalblocking-list-expiry' => 'කල් ඉකුත්වීම $1',
	'globalblocking-list-anononly' => 'නිර්නාමිකයන් පමණයි',
	'globalblocking-list-unblock' => 'ඉවත්කරන්න',
	'globalblocking-list-whitelisted' => 'පෙදෙසිව අක්‍රීය කළේ $1: $2',
	'globalblocking-list-whitelist' => 'ස්ථානික තත්ත්වය',
	'globalblocking-list-modify' => 'වෙනස් කරන්න',
	'globalblocking-list-noresults' => 'ඉල්ලුම් කළ IP ලිපිනය වාරණය කර නැත',
	'globalblocking-goto-block' => 'IP ලිපිනයක් ගෝලීයව වාරණය කරන්න',
	'globalblocking-goto-unblock' => 'ගෝලීය වාරණයක් ඉවත් කරන්න',
	'globalblocking-goto-status' => 'ගෝලීය වාරණයක පෙදෙසි තත්වය වෙනස් කරන්න',
	'globalblocking-return' => 'ගෝලීය වාරණ ලයිස්තුවට නැවත පිවිසෙන්න',
	'globalblocking-notblocked' => 'ඔබ ඇතුළත් කළ IP ලිපිනය ($1) ගෝලීයව වාරණය කර නැත',
	'globalblocking-unblock' => 'ගෝලීය වාරණයක් ඉවත් කරන්න',
	'globalblocking-unblock-ipinvalid' => 'ඔබ ඇතුළත් කළ IP ලිපිනය ($1) අවලංගු එකකි. 
ඔබට පරිශීලක නමක් ඇතුළත් කළ නොහැකි බව කරුණාවෙන් සළකන්න.',
	'globalblocking-unblock-legend' => 'ගෝලීය වාරණයක් ඉවත් කරන්න',
	'globalblocking-unblock-submit' => 'ගෝලීය වාරණය ඉවත් කරන්න',
	'globalblocking-unblock-reason' => 'හේතුව:',
	'globalblocking-unblock-unblocked' => "'''$1''' IP ලිපිනයේ #$2 ගෝලීය වාරණය සාර්ථකව ඉවත් කරන ලදී",
	'globalblocking-unblock-errors' => 'පහත සඳහන් {{PLURAL:$1|හේතුව|හේතූන්}} නිසා ගෝලීය වාරණය ඉවත් කිරීම අසාර්ථක විය:',
	'globalblocking-unblock-successsub' => 'ගෝලීය වාරණය සාර්ථකව ඉවත්කරන ලදී',
	'globalblocking-unblock-subtitle' => 'ගෝලීය වාරණය ඉවත් කරමින්',
	'globalblocking-unblock-intro' => 'මෙමෙ පෝරමය ඔබට ගෝලීය වාරණයක් ඉවත් කිරීම සඳහා භාවිතා කළ හැකිය.',
	'globalblocking-whitelist' => 'ගෝලීය වාරණවල පෙදෙසි තත්වය',
	'globalblocking-whitelist-notapplied' => 'ගෝලීය වාරණ මෙම විකියට අදාළ නැත,
එබැවින් මෙහි ගෝලීය වාරණවල පෙදෙසි තත්වය වෙනස් කළ නොහැක.',
	'globalblocking-whitelist-legend' => 'පෙදෙසි තත්වය වෙනස් කරන්න',
	'globalblocking-whitelist-reason' => 'හේතුව:',
	'globalblocking-whitelist-status' => 'පෙදෙසි තත්වය:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} හි ගෝලීය වාරණය අවලංගු කරන්න',
	'globalblocking-whitelist-submit' => 'පෙදෙසි තත්වය වෙනස් කරන්න',
	'globalblocking-whitelist-whitelisted' => "{{SITENAME}} හි '''$1''' IP ලිපිනයේ #$2 ගෝලීය වාරණය සාර්ථකව ඉවත් කරන ලදී",
	'globalblocking-whitelist-dewhitelisted' => "{{SITENAME}} හි '''$1''' IP ලිපිනයේ #$2 ගෝලීය වාරණය සාර්ථකව නැවත සක්‍රීීය කරන ලදී",
	'globalblocking-whitelist-successsub' => 'පෙදෙසි තත්වය සාර්ථකව වෙනස් විය',
	'globalblocking-whitelist-nochange' => 'ඔබ මේ වාරණයේ පෙදෙසි තත්වයට වෙනසක් සිදුකර නැත.
[[Special:GlobalBlockList|ගෝලීය වාරණ ලයිස්තුවට ආපසු යන්න]].',
	'globalblocking-whitelist-errors' => 'පහත සඳහන් {{PLURAL:$1|හේතුව|හේතූන්}} නිසා ඔබේ ගෝලීය වාරණයක ප්‍රාදේශීය තත්වය වෙනස් කෙරුම අසාර්ථක විය:',
	'globalblocking-whitelist-intro' => 'ගෝලීය වාරණයක ප්‍රාදේශිය තත්වය වෙනස් කෙරුමට ඔබට මෙම ෆෝරමය භාවිතා කළ හැක.
ගෝලීය වාරණයක් මෙම විකියේදී අක්‍රීය නම්, අදාළ වාරණය බලපාන IP ලිපිනයෙන් එන පරිශීලකයන්ට සාමාන්‍ය ලෙස සංස්කරණ කටයුතු කළ හැකි වනු ඇත.
[[Special:GlobalBlockList|ගෝලීය වාරණ ලයිස්තුවට ආපසු යන්න]].',
	'globalblocking-blocked' => "ඔබේ අයිපී ලිපිනය \$5 '''\$1''' (''\$2'') විසින් සියළුම විකි මතදී වාරිතයි.
ලබාදුන් හේතුව වන්නේ ''\"\$3\"''.
වාරණය වන්නේ ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'ඔබ ගෝලීයව වාරණිත බැවින් පරිශීලක මුරපද වෙනස් කළ නොහැක.',
	'globalblocking-logpage' => 'ගෝලීය වාරණ ලොගය',
	'globalblocking-logpagetext' => 'මේ මෙම විකිය මත තැනූ හා ඉවත් කළ ගෝලීය වාරණ ලොගයකි.
අනෙකුත් විකියන් මතදීද ගෝලීය වාරණ තැනීමට හා ඉවත් කිරීමට ඉඩ ඇති බවත්, එම ගෝලීය වාරණ මෙම විකිය මතද ක්‍රියාත්මක විය හැකි බව සැලකිය යුතුය.
සියළු සක්‍රීය ගෝලීය වාරණ දැක ගැනීමට [[Special:GlobalBlockList|ගෝලීය වාරණ ලයිස්තුව]] වෙත යන්න.',
	'globalblocking-block-logentry' => '$2 ඉකුත්වීම් කාලයක් සහිතව [[$1]] ගෝලීයව වාරණය කෙරිනි',
	'globalblocking-block2-logentry' => '[[$1]] ගෝලීයව වාරණය කරනලදී ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] වෙත පනවා තිබූ ගෝලීය වාරණය ඉවත් කෙරිනි',
	'globalblocking-whitelist-logentry' => 'ගෝලීය වාරණය [[$1]] මතදී ප්‍රාදේශීයව අක්‍රීය කෙරිනි',
	'globalblocking-dewhitelist-logentry' => 'ගෝලීය වාරණය [[$1]] මතදී ප්‍රාදේශීයව ප්‍රති-සක්‍රීය කෙරිනි',
	'globalblocking-modify-logentry' => '[[$1]] වෙත පනවා තිබූ ගෝලීය වාරණය වෙනස් කෙරිනි ($2)',
	'globalblocking-logentry-expiry' => 'කල් ඉකුත්වීම $1',
	'globalblocking-logentry-noexpiry' => 'කල් ඉකුතුවක් නියම කර නැත',
	'globalblocking-loglink' => '$1 IP ලිපිනය ගෝලීය වාරණය කෙරිනි ([[{{#Special:GlobalBlockList}}/$1|සම්පූර්ණ විස්තර]]).',
	'globalblocking-showlog' => 'මෙම IP ලිපිනය මීට පෙර අවහිර කරනු ලැබ ඇත.
අවහිරි කිරීම් ලඝු සටහන යොමුව සඳහා පහතින් සපයනු ලැබේ:',
	'globalblocklist' => 'ගෝලීයව වාරණය කළ IP ලිපින ලයිස්තුව',
	'globalblock' => 'IP ලිපිනයක් ගෝලීයව වාරණය කරන්න',
	'globalblockstatus' => 'ගෝලීය වාරණවල ප්‍රාදේශිය තත්වය',
	'removeglobalblock' => 'ගෝලීය වාරණයක් ඉවත් කරන්න',
	'right-globalblock' => 'ගෝලීය වාරණ තනන්න',
	'right-globalunblock' => 'ගෝලීය වාරණ ඉවත් කරන්න',
	'right-globalblock-whitelist' => 'ගෝලීය වාරණයන් ප්‍රාදේශීයව අහෝසි කරන්න',
	'right-globalblock-exempt' => 'ගෝලීය වාරණ මගහරින්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Umožňuje]] zablokovať IP adresy [[Special:GlobalBlockList|na viacerých wiki]]',
	'globalblocking-block' => 'Globálne zablokovať IP adresu',
	'globalblocking-modify-intro' => 'Tento formulár môžete použiť na zmenu nastavení globálneho blokovania.',
	'globalblocking-block-intro' => 'Táto stránka slúži na zablokovanie IP adresy na všetkých wiki.',
	'globalblocking-block-reason' => 'Dôvod:',
	'globalblocking-block-otherreason' => 'Iný/ďalší dôvod:',
	'globalblocking-block-reasonotherlist' => 'Iný dôvod',
	'globalblocking-block-reason-dropdown' => '* Bežné dôvody blokovania
** Spam na viacerých wiki
** Zneužitie na viacerých wiki
** Vandalizmus',
	'globalblocking-block-edit-dropdown' => 'Upraviť dôvody blokovania',
	'globalblocking-block-expiry' => 'Vypršanie:',
	'globalblocking-block-expiry-other' => 'Iný čas vypršania',
	'globalblocking-block-expiry-otherfield' => 'Iný čas:',
	'globalblocking-block-legend' => 'Globálne zablokovať IP adresu',
	'globalblocking-block-options' => 'Voľby:',
	'globalblocking-ipaddress' => 'IP adresa:',
	'globalblocking-block-errors' => 'Blokovanie bolo neúspešné z {{PLURAL:$1|nasledovného dôvodu|nasledovných dôvodov}}:',
	'globalblocking-block-ipinvalid' => 'IP adresa ($1), ktorú ste zadali nie je platná.
Majte na pamäti, že nemôžete zadať meno používateľa!',
	'globalblocking-block-expiryinvalid' => 'Čas vypršania, ktorý ste zadali ($1) je neplatný.',
	'globalblocking-block-submit' => 'Globálne zablokovať túto IP adresu',
	'globalblocking-modify-submit' => 'Zmeniť toto globálne blokovanie',
	'globalblocking-block-success' => 'IP adresa $1 bola úspešne zablokovaná na všetkých projektoch.',
	'globalblocking-modify-success' => 'Globálne blokovanie $1 bolo úspešne zmenené',
	'globalblocking-block-successsub' => 'Globálne blokovanie úspešné',
	'globalblocking-modify-successsub' => 'Globélne blokovanie úspešne zmenené',
	'globalblocking-block-alreadyblocked' => 'IP adresa $1 je už globálne zablokovaná.
Existujúce blokovanie si môžete pozrieť v [[Special:GlobalBlockList|Zozname globálnych blokovaní]] alebo môžete zmeniť voľby existujúceho blokovania tým, že znova odošlete tento formulár.',
	'globalblocking-block-bigrange' => 'Rozsah, ktorý ste uviedli ($1) nemožno zablokovať, pretože je príliš veľký. Najviac môžete zablokovať 65&nbsp;536 adries (CIDR zápis: /16).',
	'globalblocking-list-intro' => 'Toto je zoznam všetkých globálnych blokovaní, ktoré sú momentálne účinné. Niektoré blokovania sú označené ako lokálne vypnuté: To znamená, že sú účinné na ostatných stránkach, ale lokálny správca sa rozhodol ich vypnúť na tejto wiki.',
	'globalblocking-list' => 'Zoznam globálne zablokovaných IP adries',
	'globalblocking-search-legend' => 'Hľadať globálne blokovanie',
	'globalblocking-search-ip' => 'IP adresa:',
	'globalblocking-search-submit' => 'Hľadať blokovania',
	'globalblocking-list-ipinvalid' => 'IP adresa, ktorú ste hľadali ($1) je neplatná.
Prosím, zadajte platnú IP adresu.',
	'globalblocking-search-errors' => 'Vaše hľadanie bolo neúspešné z {{PLURAL:$1|nasledovného dôvodu|nasledovných dôvodov}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') globálne zablokoval [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'vyprší $1',
	'globalblocking-list-anononly' => 'iba anonym',
	'globalblocking-list-unblock' => 'odblokovať',
	'globalblocking-list-whitelisted' => 'lokálne vypol $1: $2',
	'globalblocking-list-whitelist' => 'lokálny stav',
	'globalblocking-list-modify' => 'zmeniť',
	'globalblocking-list-noresults' => 'Požadovaná IP adresa nie je zablokovaná.',
	'globalblocking-goto-block' => 'Globálne zablokovať IP adresu',
	'globalblocking-goto-unblock' => 'Odstrániť globálne blokovanie',
	'globalblocking-goto-status' => 'Zmeniť lokálny stav globálneho blokovania',
	'globalblocking-return' => 'Vrátiť sa na zoznam globálnych blokovaní',
	'globalblocking-notblocked' => 'IP adresa ($1), ktorú ste zadali, nie je globálne zablokovaná.',
	'globalblocking-unblock' => 'Odstrániť globálne blokovanie',
	'globalblocking-unblock-ipinvalid' => 'IP adresa ($1), ktorú ste zadali, je neplatná.
Majte na pamäti, že nemôžete zadať používateľské meno!',
	'globalblocking-unblock-legend' => 'Odstrániť globálne blokovanie',
	'globalblocking-unblock-submit' => 'Odstrániť globálne blokovanie',
	'globalblocking-unblock-reason' => 'Dôvod:',
	'globalblocking-unblock-unblocked' => "Úspešne ste odstránili globálne blokovanie #$2 IP adresy '''$1'''",
	'globalblocking-unblock-errors' => 'Nemôžete odstrániť globálne blokovanie tejto IP adresy z {{PLURAL:$1|nasledovného dôvodu|nasledovných dôvodov}}:',
	'globalblocking-unblock-successsub' => 'Globálne blokovanie bolo úspešne odstránené',
	'globalblocking-unblock-subtitle' => 'Odstraňuje sa globálne blokovanie',
	'globalblocking-unblock-intro' => 'Tento formulár slúži na odstránenie globálneho blokovania.',
	'globalblocking-whitelist' => 'Lokálny stav globálneho blokovania',
	'globalblocking-whitelist-notapplied' => 'Táto wiki nepoužíva globálne blokovania,
takže lokálny stav globálnych blokovaní nemožno meniť.',
	'globalblocking-whitelist-legend' => 'Zmeniť lokálny stav',
	'globalblocking-whitelist-reason' => 'Dôvod:',
	'globalblocking-whitelist-status' => 'Lokálny stav:',
	'globalblocking-whitelist-statuslabel' => 'Vypnúť toto globálne blokovanie na {{GRAMMAR:lokál|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Zmeniť lokálny stav',
	'globalblocking-whitelist-whitelisted' => "Úspešne ste vypli globálne blokovanie #$2 IP adresy '''$1''' na {{GRAMMAR:lokál|{{SITENAME}}}}.",
	'globalblocking-whitelist-dewhitelisted' => "Úspešne ste znova zapli globálne blokovanie #$2 IP adresy '''$1''' na {{GRAMMAR:lokál|{{SITENAME}}}}.",
	'globalblocking-whitelist-successsub' => 'Lokálny stav bol úspešne zmenený',
	'globalblocking-whitelist-nochange' => 'Nevykonali ste zmeny lokálneho stavu tohto blokovania.
Môžete sa vrátiť na [[Special:GlobalBlockList|Zoznam globálnych blokovaní]].',
	'globalblocking-whitelist-errors' => 'Vaša zmena lokálneho stavu globálneho blokovania bola neúspešná z {{PLURAL:$1|nasledovného dôvodu|nasledovných dôvodov}}:',
	'globalblocking-whitelist-intro' => 'Tento formulár slúži na úpravu lokálneho stavu globálneho blokovania. Ak vypnete globálne blokovanie pre túto wiki, používatelia z danej IP adresy budú môcť normálne vykonávať úpravy.
Môžete sa vrátiť na [[Special:GlobalBlockList|Zoznam globálnych blokovaní]].',
	'globalblocking-blocked' => "Vašu IP adresu $5 zablokoval na všetkých wiki '''$1''' (''$2'').
Ako dôvod udáva ''„$3“''.
Blokovanie ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Nemôžete nastaviť nové heslo používateľovi, pretože ste globáne zablokovaný.',
	'globalblocking-logpage' => 'Záznam globálnych blokovaní',
	'globalblocking-logpagetext' => 'Toto je záznam globálnych blokovaní, ktoré boli vytvorené a zrušené na tejto wiki.
Mali by ste pamätať na to, že globálne blokovania je možné vytvoriť a odstrániť na iných wiki a tieto globálne blokovania môžu ovplyvniť túto wiki.
Všetky aktívne blokovania si môžete pozrieť na [[Special:GlobalBlockList|zozname globálnych blokovaní]].',
	'globalblocking-block-logentry' => 'globálne zablokoval [[$1]] s časom vypršania $2',
	'globalblocking-block2-logentry' => 'globálne zablokoval [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'odstránil globálne blokovanie [[$1]]',
	'globalblocking-whitelist-logentry' => 'lokálne vypol globálne blokovanie [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'lokálne znovu zapol globálne blokovanie [[$1]]',
	'globalblocking-modify-logentry' => 'zmenil globálne blokovanie [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'vyprší $1',
	'globalblocking-logentry-noexpiry' => 'nebolo nastavené vypršanie',
	'globalblocking-loglink' => 'IP adresa $1 je globálne zablokovaná ([[{{#Special:GlobalBlockList}}/$1|podrobnosti]]).',
	'globalblocking-showlog' => 'IP adresa bola v minulosti zablokovaná.
Dolu je pre informáciu záznam blokovaní:',
	'globalblocklist' => 'Zoznam globálne zablokovaných IP adries',
	'globalblock' => 'Globálne zablokovať IP adresu',
	'globalblockstatus' => 'Lokálny stav globálnych blokovaní',
	'removeglobalblock' => 'Odstrániť globálne blokovanie',
	'right-globalblock' => 'Robiť globálne blokovania',
	'right-globalunblock' => 'Odstraňovať globálne blokovania',
	'right-globalblock-whitelist' => 'Lokálne vypnúť globálne blokovania',
	'right-globalblock-exempt' => 'Obísť globálne blokovania',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 * @author Smihael
 */
$messages['sl'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Omogoča]] blokado IP-naslovov [[Special:GlobalBlockList|preko več wikijev]]',
	'globalblocking-block' => 'Globalno blokiraj IP-naslov',
	'globalblocking-modify-intro' => 'Ta obrazec lahko uporabite za spreminjanje nastavitev globalne blokade.',
	'globalblocking-block-intro' => 'To stran lahko uporabite za blokado IP-naslova na vseh wikijih.',
	'globalblocking-block-reason' => 'Razlog:',
	'globalblocking-block-otherreason' => 'Drug/dodaten razlog:',
	'globalblocking-block-reasonotherlist' => 'Drug razlog',
	'globalblocking-block-reason-dropdown' => '* Pogosti razlogi za blokado
** Smetenje po wikijih
** Zloraba po wikijih
** Vandalizem',
	'globalblocking-block-edit-dropdown' => 'Uredi razloge za blokado',
	'globalblocking-block-expiry' => 'Poteče:',
	'globalblocking-block-expiry-other' => 'Drugačen čas poteka',
	'globalblocking-block-expiry-otherfield' => 'Drugačen čas:',
	'globalblocking-block-legend' => 'Blokiraj IP-naslov globalno',
	'globalblocking-block-options' => 'Možnosti:',
	'globalblocking-ipaddress' => 'IP-naslov:',
	'globalblocking-ipbanononly' => 'Blokiraj samo brezimne uporabnike',
	'globalblocking-block-errors' => 'Vaša blokada je bila neuspešna zaradi {{PLURAL:$1|naslednjega razloga|naslednjih razlogov}}:',
	'globalblocking-block-ipinvalid' => 'Vnesen IP-naslov ($1) ni veljaven.
Prosimo, upoštevajte, da ne morete vnesti uporabniškega imena!',
	'globalblocking-block-expiryinvalid' => 'Vnesen datum poteka ($1) je neveljaven.',
	'globalblocking-block-submit' => 'Blokiraj ta IP-naslov globalno',
	'globalblocking-modify-submit' => 'Spremenite to globalno blokado',
	'globalblocking-block-success' => 'IP-naslov $1 je bil uspešno blokiran na vseh projektih.',
	'globalblocking-modify-success' => 'Globalna blokada na $1 je bila uspešno spremenjena',
	'globalblocking-block-successsub' => 'Globalna blokada je uspešno izvedena',
	'globalblocking-modify-successsub' => 'Globalna blokada je uspešno spremenjena',
	'globalblocking-block-alreadyblocked' => 'IP-naslov $1 je že globalno blokiran.
Obstoječo blokado si lahko ogledate na [[Special:GlobalBlockList|seznamu globalnih blokad]],
ali pa spremenite nastavitve obstoječe blokade s ponovnim pošiljanjem tega obrazca.',
	'globalblocking-block-bigrange' => 'Naveden obseg ($1) je prevelik za blokado.
Blokirate lahko največ 65.536 naslovov (/16 obsegov)',
	'globalblocking-list-intro' => 'To je seznam vseh globalnih blokad, ki so trenutno v veljavi.
Nekatere blokade so označene kot lokalno onemogočene: to pomeni, da so v uporabi na drugih straneh, vendar se je lokalni administrator odločil, da jih bo onemogočil na tem wikiju.',
	'globalblocking-list' => 'Seznam globalno blokiranih IP-naslovov',
	'globalblocking-search-legend' => 'Iskanje globalnih blokad',
	'globalblocking-search-ip' => 'IP-naslov:',
	'globalblocking-search-submit' => 'Iskanje blokad',
	'globalblocking-list-ipinvalid' => 'Iskan IP-naslov ($1) ni veljaven.
Prosimo, vpišite veljaven IP-naslov.',
	'globalblocking-search-errors' => 'Vaše iskanje je bilo neuspešna zaradi {{PLURAL:$1|naslednjega razloga|naslednjih razlogov}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') je globalno blokiral(-a) [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'poteče $1',
	'globalblocking-list-anononly' => 'samo brezimneži',
	'globalblocking-list-unblock' => 'odstrani',
	'globalblocking-list-whitelisted' => 'lokalno onemogočil(-a) $1: $2',
	'globalblocking-list-whitelist' => 'lokalno stanje',
	'globalblocking-list-modify' => 'spremeni',
	'globalblocking-list-noresults' => 'Zahtevan IP-naslov ni blokiran.',
	'globalblocking-goto-block' => 'Globalno blokiraj IP-naslov',
	'globalblocking-goto-unblock' => 'Odstrani globalno blokado',
	'globalblocking-goto-status' => 'Spremeni lokalno stanje globalne blokade',
	'globalblocking-return' => 'Vrnitev na seznam globalnih blokad',
	'globalblocking-notblocked' => 'Vnesen IP-naslov ($1) ni globalno blokiran.',
	'globalblocking-unblock' => 'Odstrani globalno blokado',
	'globalblocking-unblock-ipinvalid' => 'Vnesen IP-naslov ($1) ni veljaven.
Prosimo, upoštevajte, da ne morete vnesti uporabniškega imena!',
	'globalblocking-unblock-legend' => 'Odstrani globalno blokado',
	'globalblocking-unblock-submit' => 'Odstrani globalno blokado',
	'globalblocking-unblock-reason' => 'Razlog:',
	'globalblocking-unblock-unblocked' => "Uspešno ste odstranili globalno blokado št. $2 IP-naslova '''$1'''",
	'globalblocking-unblock-errors' => 'Vaša odstranitev blokade je bila neuspešna zaradi {{PLURAL:$1|naslednjega razloga|naslednjih razlogov}}:',
	'globalblocking-unblock-successsub' => 'Globalna blokada je uspešno odstranjena',
	'globalblocking-unblock-subtitle' => 'Odstranjevanje globalne blokade',
	'globalblocking-unblock-intro' => 'Ta obrazec lahko uporabite za odstranitev globalne blokade.',
	'globalblocking-whitelist' => 'Lokalno stanje globalnih blokad',
	'globalblocking-whitelist-notapplied' => 'Globalne blokade na tem wikiju niso uveljavljene,
zato lokalnega stanja globalnih blokad ni mogoče spremeniti.',
	'globalblocking-whitelist-legend' => 'Spremeni lokalno stanje',
	'globalblocking-whitelist-reason' => 'Razlog:',
	'globalblocking-whitelist-status' => 'Lokalno stanje:',
	'globalblocking-whitelist-statuslabel' => 'Onemogoči to globalno blokado na {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Spremeni lokalno stanje',
	'globalblocking-whitelist-whitelisted' => "Uspešno ste onemogočili globalno blokado št. $2 IP-naslova '''$1''' na {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Uspešno ste ponovno omogočili globalno blokado št. $2 IP-naslova '''$1''' na {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Lokalno stanje je uspešno spremenjeno',
	'globalblocking-whitelist-nochange' => 'Lokalnega stanja te blokade niste spremenili.
[[Special:GlobalBlockList|Vrnitev na seznam globalnih blokad]].',
	'globalblocking-whitelist-errors' => 'Vaša sprememba lokalnega stanja globalne blokade je bila neuspešna zaradi {{PLURAL:$1|naslednjega razloga|naslednjih razlogov}}:',
	'globalblocking-whitelist-intro' => 'Ta obrazec lahko uporabite za urejanje lokalnega stanja globalne blokade.
Če je globalna blokada na tem wikiju onemogočena, bodo uporabniki na določenem IP-naslovu lahko normalno urejali.
[[Special:GlobalBlockList|Vrnitev na seznam globalnih blokad]].',
	'globalblocking-blocked' => "Vaš IP-naslov %5 je na vseh wikijih blokiral '''$1''' (''$2'').
Podan razlog je ''»$3«''.
Blokada ''$4''.",
	'globalblocking-blocked-nopassreset' => 'Ne morete ponastaviti gesla uporabnika, ker je globalno blokiran.',
	'globalblocking-logpage' => 'Dnevnik globalnih blokad',
	'globalblocking-logpagetext' => 'To je dnevnik globalnih blokad, ki so bile izvedene ali odstranjene na tem wikiju.
Potrebno je opozoriti, da je globalne blokade mogoče izvesti ali odstraniti na drugih wikijih in da omenjene blokade lahko vplivajo na ta wiki.
Če si želite ogledati vse dejavne globalne blokade, pojdite na [[Special:GlobalBlockList|seznam globalnih blokad]].',
	'globalblocking-block-logentry' => 'je globalno blokiral(-a) [[$1]] s časom poteka $2',
	'globalblocking-block2-logentry' => 'globalno blokiran uporabnik [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'je odstranil(-a) globalno blokado [[$1]]',
	'globalblocking-whitelist-logentry' => 'je onemogočil(-a) globalno blokado [[$1]] na lokalni ravni',
	'globalblocking-dewhitelist-logentry' => 'je ponovno omogočil(-a) globalno blokado [[$1]] na lokalni ravni',
	'globalblocking-modify-logentry' => 'je spremenil(-a) globalno blokado [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'poteče $1',
	'globalblocking-logentry-noexpiry' => 'potek ni določen',
	'globalblocking-loglink' => 'IP-naslov $1 je globalno blokiran ([[{{#Special:GlobalBlockList}}/$1|vse podrobnosti]]).',
	'globalblocking-showlog' => 'Ta IP-naslov je že bil blokiran.
Dnevnik blokiranja je na voljo spodaj:',
	'globalblocklist' => 'Seznam globalno blokiranih IP-naslovov',
	'globalblock' => 'Globalno blokiraj IP-naslov',
	'globalblockstatus' => 'Lokalno stanje globalnih blokad',
	'removeglobalblock' => 'Odstrani globalno blokado',
	'right-globalblock' => 'Uveljavljanje globalnih blokad',
	'right-globalunblock' => 'Odstranjevanje globalnih blokad',
	'right-globalblock-whitelist' => 'Onemogočanje globalnih blokad na lokalni ravni',
	'right-globalblock-exempt' => 'Izmikanje globalnim blokadam',
);

/** Albanian (Shqip)
 * @author Mikullovci11
 * @author Olsi
 */
$messages['sq'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Lejon]] adresat IP të jenë [[Special:GlobalBlockList|të bllokuara në shumë wiki]]',
	'globalblocking-block' => 'Bllokoni globalisht një adresë IP',
	'globalblocking-modify-intro' => 'Ju mund të përdorni këtë formular për të ndryshuar parametrat e një bllokimi global.',
	'globalblocking-block-intro' => 'Ju mund të përdorni këtë faqe për të bllokuar një adresë IP në të gjithë wiki-t.',
	'globalblocking-block-reason' => 'Arsyeja:',
	'globalblocking-block-otherreason' => 'Arsye tjetër/shtesë:',
	'globalblocking-block-reasonotherlist' => 'Arsye tjetër',
	'globalblocking-block-reason-dropdown' => '*Arsye të shpeshta bllokimi
**Spam
**Abuzim
**Vandalizëm',
	'globalblocking-block-edit-dropdown' => 'Redakto arsyet e bllokimit',
	'globalblocking-block-expiry' => 'Afati',
	'globalblocking-block-expiry-other' => 'Kohë tjetër skadimi:',
	'globalblocking-block-expiry-otherfield' => 'Kohë tjetër:',
	'globalblocking-block-legend' => 'Bllokoni një adresë IP globalisht',
	'globalblocking-block-options' => 'Opcionet:',
	'globalblocking-ipaddress' => 'Adresa IP:',
	'globalblocking-ipbanononly' => 'Blloko vetëm përdoruesin anonim',
	'globalblocking-block-errors' => 'Bllokimi juaj ishte i pasuksesshëm, për {{PLURAL:$1|arsyen|arsyet}} e mëposhtme:',
	'globalblocking-block-ipinvalid' => 'Adresa IP ($1) që shkruat është e pavlefshme.
Ju lutemi vini re se ju nuk mund të shkruani një emër përdoruesi!',
	'globalblocking-block-expiryinvalid' => 'Afati që dhatë ($1) është i pavlefshëm.',
	'globalblocking-block-submit' => 'Bllokojeni këtë adresë IP globalisht',
	'globalblocking-modify-submit' => 'Modifikoni këtë bllokim global',
	'globalblocking-block-success' => 'Adresa IP $1 është bllokuar me sukses në të gjitha projektet.',
	'globalblocking-modify-success' => 'Bllokimi global në $1 është modifikuar me sukses',
	'globalblocking-block-successsub' => 'Bllokim global me sukses',
	'globalblocking-modify-successsub' => 'Modifikim i bllokimit global me sukses',
	'globalblocking-block-alreadyblocked' => 'Adresa IP $1 është e bllokuar tashmë globalisht.
Ju mund ta shihni këtë bllokim ekzistues në [[Special:GlobalBlockList|listën e bllokimeve globale]],
ose të modifikoni parametrat e bllokimit ekzistues duke riparaqitur këtë formular.',
	'globalblocking-block-bigrange' => "Vargu që specifikuat ($1) është shumë i madh për t'u bllokuar.
Ju mund të bllokoni, të shumtën, 65,536 adresa (/16 vargje)",
	'globalblocking-list-intro' => "Kjo është një listë e të gjitha bllokimeve globale që janë aktualisht në fuqi.
Disa bllokime janë të shënuara si të çaktivizuara në nivel lokal: kjo do të thotë se ato zbatohen në sajte të tjera, por një administrator lokal ka vendosur t'i zhbllokojë ata në këtë wiki.",
	'globalblocking-list' => 'Lista e adresave IP të bllokuara globalisht',
	'globalblocking-search-legend' => 'Kërkoni bllokim globale',
	'globalblocking-search-ip' => 'IP Adresë/përdorues',
	'globalblocking-search-submit' => 'Kërkim për bllokimet',
	'globalblocking-list-ipinvalid' => 'Ju e keni dhënë një adresë IP ($1) të pavlefshëm.
Ju lutem shkruani një adresë IP të vlefshme.',
	'globalblocking-search-errors' => 'Kërkimi juaj ishte i pasuksesshëm, për {{PLURAL:$1|arsyen|arsyet}} e mëposhtme:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') bllokoi globalisht [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'Kohëzgjatja e bllokimit $1',
	'globalblocking-list-anononly' => 'Vetëm anonimet',
	'globalblocking-list-unblock' => 'grise',
	'globalblocking-list-whitelisted' => 'çaktivizuar në nivel lokal nga $1: $2',
	'globalblocking-list-whitelist' => 'statusi lokal',
	'globalblocking-list-modify' => 'modifiko',
	'globalblocking-list-noresults' => 'Adresa IP e kërkuar nuk është e bllokuar.',
	'globalblocking-goto-block' => 'Bllokoni globalisht një adresë IP',
	'globalblocking-goto-unblock' => 'Grisni një bllokimin global',
	'globalblocking-goto-status' => 'Ndryshoni statusin lokal për një bllokim global',
	'globalblocking-return' => 'Kthehuni tek lista e bllokimeve globale',
	'globalblocking-notblocked' => 'Adresa IP ($1) që shkruat nuk është e bllokuar globalisht.',
	'globalblocking-unblock' => 'Grise bllokimin global',
	'globalblocking-unblock-ipinvalid' => 'Adresa IP ($1) që shkruat është e pavlefshme.
Ju lutemi vini re se ju nuk mund të shkruani një emër përdoruesi!',
	'globalblocking-unblock-legend' => 'Grise bllokimin global',
	'globalblocking-unblock-submit' => 'Grise bllokimin global',
	'globalblocking-unblock-reason' => 'Arsyeja:',
	'globalblocking-unblock-unblocked' => "Ju keni hequr me sukses bllokimin global #$2 tek adresa IP '''$1'''",
	'globalblocking-unblock-errors' => 'Heqja e bllokimit global ishte e pasuksesshme, për {{PLURAL:$1|arsyen|arsyet}} e mëposhtme:',
	'globalblocking-unblock-successsub' => 'Bllokimi global u hoq me sukses',
	'globalblocking-unblock-subtitle' => 'Grise bllokimin global',
	'globalblocking-unblock-intro' => 'Ju mund të përdorni këtë formular për të hequr një bllokim global.',
	'globalblocking-whitelist' => 'Statusi lokal i bllokimeve globale',
	'globalblocking-whitelist-notapplied' => 'Bllokimet globale nuk janë të aplikuara në këtë wiki,
kështu që statusi i bllokimeve globale nuk mund të modifikohet.',
	'globalblocking-whitelist-legend' => 'Ndrysho statusin lokal',
	'globalblocking-whitelist-reason' => 'Arsyeja:',
	'globalblocking-whitelist-status' => 'Statusi lokal',
	'globalblocking-whitelist-statuslabel' => 'Çaktivizo këtë bllokim global në {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Ndrysho statusin lokal',
	'globalblocking-whitelist-whitelisted' => "Ju keni çaktivizuar me sukses bllokimin global #$2 tek adresa IP '''$1''' në {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Ju keni ri-aktivizuar me sukses bllokimin global #$2 tek adresa IP '''$1''' në {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Statusi lokal u ndryshua me sukses',
	'globalblocking-whitelist-nochange' => 'Ju nuk bëtë ndonjë ndryshim tek statusi lokal i këtij bllokimi.
[[Special:GlobalBlockList|Kthehuni tek lista e bllokimve globale]].',
	'globalblocking-whitelist-errors' => 'Ndryshimi juaj tek statusi lokal i bllokimit global ishte i pasuksesshëm, për {{PLURAL:$1|arsyen|arsyet}} e mëposhtme:',
	'globalblocking-whitelist-intro' => 'Ju mund të përdorni këtë formular për të redaktuar statusin lokal të një bllokimi global.
Nëse një bllokim global është i çaktivizuar në këtë wiki, përdoruesit e adresës IP do të jenë në gjendje të redaktojnë normalisht.
[[Special:GlobalBlockList|Kthehuni tek lsita e bllokimeve globale]].',
	'globalblocking-blocked' => "Adresa juaj IP \$5 është bllokuar në të gjithë wiki-t nga '''\$1''' (''\$2'').
Arsyeja e dhënë ishte ''\"\$3\"''.
Bllokimi ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Ju nuk mund të rivendosni fjalëkalimet e përdoresve sepse jeni i bllokuar globalisht.',
	'globalblocking-logpage' => 'Regjistri i bllokimeve globale',
	'globalblocking-logpagetext' => 'Ky është një regjistër i bllokimeve globale që janë bërë dhe hequr në këtë wiki.
Duhet të theksohet se bllokimet globale mund të bëhen dhe të hiqen në wiki-t e tjerë, dhe këtë bllokime globale mund të ndikojnë në këtë wiki.
Për të parë të gjitha bllokimet globale aktive, ju mund të shikoni [[Special:GlobalBlockList|listën e bllokimeve globale]].',
	'globalblocking-block-logentry' => 'bllokoi globalisht [[$1]] për një kohë prej $2',
	'globalblocking-block2-logentry' => 'bllokoi globalisht [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'hoqi bllokimin global në [[$1]]',
	'globalblocking-whitelist-logentry' => 'çaktivizoi bllokimin global për [[$1]] në nivel lokal',
	'globalblocking-dewhitelist-logentry' => 'ri-çaktivizoi bllokimin global për [[$1]] në nivel lokal',
	'globalblocking-modify-logentry' => 'modifikoi bllokimin global në [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'skadon $1',
	'globalblocking-logentry-noexpiry' => 'nuk u vendos afat',
	'globalblocking-loglink' => 'Adresa IP $1 është bllokuar globalisht ([[{{#Special:GlobalBlockList}}/$1|detajet e plota]]).',
	'globalblocking-showlog' => 'Kjo adresë IP është bllokuar më parë.
Regjistri i bllokimit është poshtë për referncë:',
	'globalblocklist' => 'Lista e adresave IP të bllokuara globalisht',
	'globalblock' => 'Bllokoni globalisht një adresë IP',
	'globalblockstatus' => 'Statusi lokal i bllokimeve globale',
	'removeglobalblock' => 'Hiq një bllokim global',
	'right-globalblock' => 'Bëni bllokime globale',
	'right-globalunblock' => 'Hiqni bllokime globale',
	'right-globalblock-whitelist' => 'Çaktivizoni bllokimet globale në nivel lokal',
	'right-globalblock-exempt' => 'Anashkaloni bllokimet globale',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Јованвб
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Омогућује]] [[Special:GlobalBlockList|глобално блокирање]] ИП адреса на више викија',
	'globalblocking-block' => 'Глобално блокирајте ИП адресу',
	'globalblocking-modify-intro' => 'Овим обрасцем можете да промените поставке глобалне блокаде.',
	'globalblocking-block-intro' => 'Можете користити ову страницу да блокирате ИП адресу на свим викијима.',
	'globalblocking-block-reason' => 'Разлог:',
	'globalblocking-block-otherreason' => 'Други/додатни разлог:',
	'globalblocking-block-reasonotherlist' => 'Други разлог',
	'globalblocking-block-reason-dropdown' => '* Уобичајени разлози за блок
** Међувики спам
** Међувики малтретирање
** Вандализам',
	'globalblocking-block-edit-dropdown' => 'Измени разлоге за блок',
	'globalblocking-block-expiry' => 'Истек:',
	'globalblocking-block-expiry-other' => 'Друго време истека',
	'globalblocking-block-expiry-otherfield' => 'Друго време:',
	'globalblocking-block-legend' => 'Глобално блокирање IP адресе',
	'globalblocking-block-options' => 'Опције:',
	'globalblocking-ipaddress' => 'ИП адреса:',
	'globalblocking-ipbanononly' => 'Блокирај само анонимне кориснике',
	'globalblocking-block-errors' => 'Блок није успешан због {{PLURAL:$1|следеђег разлога|следећих разлога}}:',
	'globalblocking-block-ipinvalid' => 'ИП адреса ($1) коју сте унели није добра.
Запамтите да не можете унети корисничко име!',
	'globalblocking-block-expiryinvalid' => 'Време истека блока које сте унели ($1) није исправно.',
	'globalblocking-block-submit' => 'Блокирајте ову ИП адресу глобално',
	'globalblocking-modify-submit' => 'Промени овај глобални блок',
	'globalblocking-block-success' => 'Ип адреса $1 је успешно блокирана на свим Викимедијиним пројектима.',
	'globalblocking-modify-success' => 'Глобални блок на $1 је успешно промењен',
	'globalblocking-block-successsub' => 'Успешан глобални блок',
	'globalblocking-modify-successsub' => 'Глобални блок је успешно промењен',
	'globalblocking-block-alreadyblocked' => 'ИП адреса $1 је већ глобално блокирана.
Можете погледати списак постојећих [[Special:GlobalBlockList|глобалних блокирања]],
или пак изменити поставке постојеће блокаде тако што ћете поново поднети овај образац.',
	'globalblocking-block-bigrange' => 'Наведени опсег ($1) је превелик да би био блокиран.
Можете блокирати највише 65.536 адреса (/16 опсези)',
	'globalblocking-list' => 'Списак глобално блокираних ИП адреса',
	'globalblocking-search-legend' => 'Претражите глобалне блокове',
	'globalblocking-search-ip' => 'ИП адреса:',
	'globalblocking-search-submit' => 'Претражите блокове',
	'globalblocking-list-ipinvalid' => 'ИП адреса коју тражите ($1) није исправна.
Молимо Вас унесите исправну ИП адресу.',
	'globalblocking-search-errors' => 'Ваша претрага није успешна због {{PLURAL:$1|следећег разлога|следећих разлога}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') глобално блокирао [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'истиче $1',
	'globalblocking-list-anononly' => 'само анонимне',
	'globalblocking-list-unblock' => 'уклони',
	'globalblocking-list-whitelist' => 'локални статус',
	'globalblocking-list-modify' => 'измени',
	'globalblocking-list-noresults' => 'Тражена ИП адреса није блокирана.',
	'globalblocking-goto-block' => 'Блокирај IP адресу глобално',
	'globalblocking-goto-unblock' => 'Уклони глобални блок',
	'globalblocking-return' => 'Врати се на списак глобалних блокова',
	'globalblocking-unblock' => 'Уклони глобални блок',
	'globalblocking-unblock-ipinvalid' => 'ИП адреса ($1) коју сте унели није исправна.
Запамтите да не можете уносити корисничка имена!',
	'globalblocking-unblock-legend' => 'Уклоните глобални блок',
	'globalblocking-unblock-submit' => 'Уклоните глобални блок',
	'globalblocking-unblock-reason' => 'Разлог:',
	'globalblocking-unblock-unblocked' => "Успешно сте уклонили глобалну блокаду #$2 за ИП адресу '''$1'''.",
	'globalblocking-unblock-errors' => 'Не можете да уклоните глобалну блокаду због {{PLURAL:$1|следећег разлога|следећих разлога}}:',
	'globalblocking-unblock-successsub' => 'Глобални блок успешно уклоњен',
	'globalblocking-unblock-subtitle' => 'Уклањање глобалног блока',
	'globalblocking-unblock-intro' => 'Можете користити ову форму да уклоните глобални блок.',
	'globalblocking-whitelist' => 'Локално стање глобалних блокада',
	'globalblocking-whitelist-legend' => 'Промена локалног стања',
	'globalblocking-whitelist-reason' => 'Разлог:',
	'globalblocking-whitelist-status' => 'Локални статус:',
	'globalblocking-whitelist-statuslabel' => 'Онемогући ову глобалну блокаду на {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Промени локално стање',
	'globalblocking-whitelist-whitelisted' => "Успешно сте онемогућили глобалну блокаду #$2 за ИП адресу '''$1''' на пројекту {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Успешно сте омогућили глобалну блокаду #$2 за ИП адресу '''$1''' на пројекту {{SITENAME}}.",
	'globalblocking-whitelist-errors' => 'Не можете да промените локално стање глобалне блокаде због {{PLURAL:$1|следећег разлога|следећих разлога}}:',
	'globalblocking-blocked' => "Ваша ИП адреса \$5 је блокирана на свим викијима од '''\$1''' (''\$2'').
Наведени разлог гласи: „''\"\$3\"''“.
Блокада ''\$4''.",
	'globalblocking-logpage' => 'Историја глобалних блокова',
	'globalblocking-block-logentry' => '{{GENDER:|је глобално блокирао|је глобално блокирала|је глобално блокирао}} [[$1]] с роком истицања од $2',
	'globalblocking-block2-logentry' => 'глобално блокиран [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'уклонио глобални блок за [[$1]]',
	'globalblocking-whitelist-logentry' => 'локално онемогућен глобални блок над [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'локално је враћен глобални блок над [[$1]]',
	'globalblocking-modify-logentry' => 'глобални блок је промењен над [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'истиче $1',
	'globalblocking-logentry-noexpiry' => 'није назначен рок истека',
	'globalblocking-loglink' => 'IP адреса $1 је глобално блокирана ([[{{#Special:GlobalBlockList}}/$1|сви детаљи]]).',
	'globalblocking-showlog' => 'Ова IP адреса је била раније блокирана.
Испод је приложена историја блокирања:',
	'globalblocklist' => 'Списак глобално блокираних ИП адреса',
	'globalblock' => 'Глобално блокирајте ИП адресу',
	'globalblockstatus' => 'Локално стање глобалних блокада',
	'removeglobalblock' => 'Уклони глобални блок',
	'right-globalblock' => 'Постави глобалне блокове',
	'right-globalunblock' => 'Уклони глобалне блокове',
	'right-globalblock-whitelist' => 'Онемогући глобалне блокове локално',
	'right-globalblock-exempt' => 'заобилажење глобалних блокада',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-el'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Omogućuje]] [[Special:GlobalBlockList|globalno blokiranje]] IP adresa na više vikija',
	'globalblocking-block' => 'Globalno blokirajte IP adresu',
	'globalblocking-modify-intro' => 'Ovom formom menjate podešavanja globalnog bloka.',
	'globalblocking-block-intro' => 'Možete koristiti ovu stranicu da blokirate IP adresu na svim vikijima.',
	'globalblocking-block-reason' => 'Razlog:',
	'globalblocking-block-otherreason' => 'Drugi/dodatni razlog:',
	'globalblocking-block-reasonotherlist' => 'Drugi razlog',
	'globalblocking-block-reason-dropdown' => '* Uobičajeni razlozi za blok
** Međuviki spam
** Međuviki maltretiranje
** Vandalizam',
	'globalblocking-block-edit-dropdown' => 'Izmeni razloge za blok',
	'globalblocking-block-expiry' => 'Istek:',
	'globalblocking-block-expiry-other' => 'Drugo vreme isteka',
	'globalblocking-block-expiry-otherfield' => 'Drugo vreme:',
	'globalblocking-block-legend' => 'Globalno blokiranje IP adrese',
	'globalblocking-block-options' => 'Opcije:',
	'globalblocking-ipaddress' => 'IP adresa:',
	'globalblocking-block-errors' => 'Blok nije uspešan zbog {{PLURAL:$1|sledeđeg razloga|sledećih razloga}}:',
	'globalblocking-block-ipinvalid' => 'IP adresa ($1) koju ste uneli nije dobra.
Zapamtite da ne možete uneti korisničko ime!',
	'globalblocking-block-expiryinvalid' => 'Vreme isteka bloka koje ste uneli ($1) nije ispravno.',
	'globalblocking-block-submit' => 'Blokirajte ovu IP adresu globalno',
	'globalblocking-modify-submit' => 'Promeni ovaj globalni blok',
	'globalblocking-block-success' => 'Ip adresa $1 je uspešno blokirana na svim Vikimedijinim projektima.',
	'globalblocking-modify-success' => 'Globalni blok na $1 je uspešno promenjen',
	'globalblocking-block-successsub' => 'Uspešan globalni blok',
	'globalblocking-modify-successsub' => 'Globalni blok je uspešno promenjen',
	'globalblocking-block-alreadyblocked' => 'IP adresa $1 je već globalno blokirana.
Možete pogledati spisak postojećih [[Special:GlobalBlockList|globalnih blokiranja]],
ili pak izmeniti postavke postojeće blokade tako što ćete ponovo podneti ovaj obrazac.',
	'globalblocking-block-bigrange' => 'Navedeni opseg ($1) je prevelik da bi bio blokiran.
Možete blokirati najviše 65.536 adresa (/16 opsezi)',
	'globalblocking-list' => 'Spisak globalno blokiranih IP adresa',
	'globalblocking-search-legend' => 'Pretražite globalne blokove',
	'globalblocking-search-ip' => 'IP adresa:',
	'globalblocking-search-submit' => 'Pretražite blokove',
	'globalblocking-list-ipinvalid' => 'IP adresa koju tražite ($1) nije ispravna.
Molimo Vas unesite ispravnu IP adresu.',
	'globalblocking-search-errors' => 'Vaša pretraga nije uspešna zbog {{PLURAL:$1|sledećeg razloga|sledećih razloga}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') globalno blokirao [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'ističe $1',
	'globalblocking-list-anononly' => 'samo anonimne',
	'globalblocking-list-unblock' => 'deblokiraj',
	'globalblocking-list-whitelist' => 'lokalni status',
	'globalblocking-goto-block' => 'Blokiraj IP adresu globalno',
	'globalblocking-goto-unblock' => 'Ukloni globalni blok',
	'globalblocking-return' => 'Vrati se na spisak globalnih blokova',
	'globalblocking-unblock' => 'Ukloni globalni blok',
	'globalblocking-unblock-ipinvalid' => 'IP adresa ($1) koju ste uneli nije ispravna.
Zapamtite da ne možete unositi korisnička imena!',
	'globalblocking-unblock-legend' => 'Uklonite globalni blok',
	'globalblocking-unblock-submit' => 'Uklonite globalni blok',
	'globalblocking-unblock-reason' => 'Razlog:',
	'globalblocking-unblock-unblocked' => "Uspešno ste uklonili globalni blok #$2 za IP adresu '''$1'''.",
	'globalblocking-unblock-errors' => 'Ne možete ukloniti globalni blok za tu IP adresu zbog {{PLURAL:$1|sledećeg razloga|sledećih razloga}}:',
	'globalblocking-unblock-successsub' => 'Globalni blok uspešno uklonjen',
	'globalblocking-unblock-subtitle' => 'Uklanjanje globalnog bloka',
	'globalblocking-unblock-intro' => 'Možete koristiti ovu formu da uklonite globalni blok.',
	'globalblocking-whitelist-reason' => 'Razlog:',
	'globalblocking-whitelist-status' => 'Lokalni status:',
	'globalblocking-whitelist-submit' => 'Promeni lokalni status',
	'globalblocking-blocked' => "Vaša IP adresa \$5 je blokirana na svim vikijima od '''\$1''' (''\$2'').
Navedeni razlog glasi: „''\"\$3\"''“.
Blokada ''\$4''.",
	'globalblocking-logpage' => 'Istorija globalnih blokova',
	'globalblocking-block-logentry' => 'globalno blokirao [[$1]] sa vremenom isticanja od $2',
	'globalblocking-block2-logentry' => 'globalno blokiran [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'uklonio globalni blok za [[$1]]',
	'globalblocking-whitelist-logentry' => 'lokalno onemogućen globalni blok nad [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'lokalno je vraćen globalni blok nad [[$1]]',
	'globalblocking-modify-logentry' => 'globalni blok je promenjen nad [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'ističe $1',
	'globalblocking-logentry-noexpiry' => 'nije naznačen rok isteka',
	'globalblocking-loglink' => 'IP adresa $1 je globalno blokirana ([[{{#Special:GlobalBlockList}}/$1|svi detalji]]).',
	'globalblocking-showlog' => 'Ova IP adresa je bila ranije blokirana.
Ispod je priložena istorija blokiranja:',
	'globalblocklist' => 'Spisak globalno blokiranih IP adresa',
	'globalblock' => 'Globalno blokirajte IP adresu',
	'globalblockstatus' => 'Lokalni status globalnih blokova',
	'removeglobalblock' => 'Ukloni globalni blok',
	'right-globalblock' => 'Postavi globalne blokove',
	'right-globalunblock' => 'Ukloni globalne blokove',
	'right-globalblock-whitelist' => 'Onemogući globalne blokove lokalno',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Speert]] IP-Adressen ap [[Special:GlobalBlockList|aal Wikis]]',
	'globalblocking-block' => 'Ne IP-Adresse globoal speere',
	'globalblocking-block-intro' => 'Ap disse Siede koast du IP-Adressen foar aal Wikis speere.',
	'globalblocking-block-reason' => 'Gruund:',
	'globalblocking-block-expiry' => 'Speerduur:',
	'globalblocking-block-expiry-other' => 'Uur Duur:',
	'globalblocking-block-expiry-otherfield' => 'Uur Duur (ängelsk):',
	'globalblocking-block-legend' => 'N Benutser globoal speere',
	'globalblocking-block-options' => 'Optione:',
	'globalblocking-block-errors' => 'Ju Speere hied naan Ärfoulch. {{PLURAL:$1|Gruund|Gruunde}}:',
	'globalblocking-block-ipinvalid' => 'Du hääst ne uungultige IP-Adresse ($1) ienroat.
Beoachtje, dät du naan Benutsernoome ienreeke doarst!',
	'globalblocking-block-expiryinvalid' => 'Ju Speerduur ($1) is uungultich.',
	'globalblocking-block-submit' => 'Disse IP-Adresse globoal speere',
	'globalblocking-block-success' => 'Ju IP-Adresse $1 wuud mäd Ärfoulch ap aal Projekte speerd.',
	'globalblocking-block-successsub' => 'Mäd Ärfoulch globoal speerd',
	'globalblocking-block-alreadyblocked' => 'Ju IP-Adresse $1 wuud al globoal speerd. 
Du koast ju bestoundene Speere in ju [[Special:GlobalBlockList|globoale Speerlieste]] bekiekje of do Ienstaalengen fon ju Speere uur dit Formular annerje.',
	'globalblocking-block-bigrange' => 'Die Adresseberäk, dän du ounroat hääst ($1) is tou groot.
Du koast höchstens 65.536 IPs speere (/16-Adresseberäkke)',
	'globalblocking-list-intro' => 'Dit is ne Lieste fon aal gultige globoale Speeren. Wäkke Speeren wuuden lokoal deaktivierd. Dät betjut, dät do Speeren ap uur Projekte gultich sunt, man dät n lokoalen Administrator äntskat häd, do foar dit Wiki tou deaktivierjen.',
	'globalblocking-list' => 'Lieste fon lokoal speerde IP-Adressen',
	'globalblocking-search-legend' => 'Ne globoale Speere säike',
	'globalblocking-search-ip' => 'IP-Adresse:',
	'globalblocking-search-submit' => 'Speeren säike',
	'globalblocking-list-ipinvalid' => 'Du hääst ne uungultige IP-Adresse ienroat ($1).
Reek ne gultige IP-Adresse ien.',
	'globalblocking-search-errors' => 'Ju Säike hied naan Ärfoulch. {{PLURAL:$1|Gruund|Gruunde}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (ap ''\$3'') speerde [[Special:Contributions/\$4|\$4]] globoal ''(\$5)''",
	'globalblocking-list-expiry' => 'Speerduur $1',
	'globalblocking-list-anononly' => 'bloot Anonyme',
	'globalblocking-list-unblock' => 'äntspeere',
	'globalblocking-list-whitelisted' => 'lokoal ouskalted fon $1: $2',
	'globalblocking-list-whitelist' => 'lokoalen Stoatus',
	'globalblocking-list-modify' => 'annerje',
	'globalblocking-goto-block' => 'IP-Adresse globoal speere',
	'globalblocking-goto-unblock' => 'Globoale Speere aphieuwje',
	'globalblocking-goto-status' => 'Lokoalen Stoatus foar ne globoale Speere annerje',
	'globalblocking-return' => 'Tourääch ätter ju Lieste fon globoale Speeren',
	'globalblocking-notblocked' => 'Ju ienroate IP-Adresse ($1) is nit globoal speerd.',
	'globalblocking-unblock' => 'Globoale Speere aphieuwje',
	'globalblocking-unblock-ipinvalid' => 'Du hääst ne uungultige IP-Adresse ($1) ienroat.
Beoachtje, dät du naan Benutsernoome ienreeke duurst!',
	'globalblocking-unblock-legend' => 'Globoal äntspeere',
	'globalblocking-unblock-submit' => 'Globoal äntspeere',
	'globalblocking-unblock-reason' => 'Gruund:',
	'globalblocking-unblock-unblocked' => "Du hääst mäd Ärfoulch ju IP-Adresse '''$1''' (Speer-ID $2) äntspeerd",
	'globalblocking-unblock-errors' => 'Ju Aphieuwenge fon ju globoale Speere hied naan Ärfoulch. {{PLURAL:$1|Gruund|Gruunde}}:',
	'globalblocking-unblock-successsub' => 'Mäd Ärfoulch globoal äntspeerd',
	'globalblocking-unblock-subtitle' => 'Globoale Speere wächhoald',
	'globalblocking-unblock-intro' => 'Mäd dit Formular koast du ne globoale Speere aphieuwje.',
	'globalblocking-whitelist' => 'Lokoalen Stoatus fon ne globoale Speere',
	'globalblocking-whitelist-legend' => 'Lokoalen Stoatus beoarbaidje',
	'globalblocking-whitelist-reason' => 'Gruund:',
	'globalblocking-whitelist-status' => 'Lokoalen Stoatus:',
	'globalblocking-whitelist-statuslabel' => 'Disse globoale Speere ap {{SITENAME}} aphieuwje',
	'globalblocking-whitelist-submit' => 'Lokoalen Stoatus annerje',
	'globalblocking-whitelist-whitelisted' => "Du hääst mäd Ärfoulch ju globoale Speere fon ju IP-Adresse '''$1''' (Speer-ID $2) ap {{SITENAME}} aphieuwed.",
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'globalblocking-unblock-reason' => 'Alesan:',
	'globalblocking-whitelist-reason' => 'Alesan:',
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Boivie
 * @author Diupwijk
 * @author Fluff
 * @author GameOn
 * @author Jon Harald Søby
 * @author M.M.S.
 * @author Per
 * @author Rotsee
 */
$messages['sv'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Tillåter]] IP-adresser att bli [[Special:GlobalBlockList|blockerade tvärs över mångfaldiga wikier]]',
	'globalblocking-block' => 'Blockerar en IP-adress globalt',
	'globalblocking-modify-intro' => 'Du kan använda detta formulär för att ändra inställningarna för en global blockering.',
	'globalblocking-block-intro' => 'Du kan använda denna sida för att blockera en IP-adress på alla wikier.',
	'globalblocking-block-reason' => 'Anledning:',
	'globalblocking-block-otherreason' => 'Annan/ytterligare anledning:',
	'globalblocking-block-reasonotherlist' => 'Annan anledning',
	'globalblocking-block-reason-dropdown' => '* Vanliga blockeringsanledningar
** Crosswiki-spamning
** Crosswiki-missbruk
** Vandalisering',
	'globalblocking-block-edit-dropdown' => 'Redigera blockeringsanledningar',
	'globalblocking-block-expiry' => 'Går ut:',
	'globalblocking-block-expiry-other' => 'Annan varighet',
	'globalblocking-block-expiry-otherfield' => 'Annan tid:',
	'globalblocking-block-legend' => 'Blockera en användare globalt',
	'globalblocking-block-options' => 'Alternativ:',
	'globalblocking-ipaddress' => 'IP-adress:',
	'globalblocking-ipbanononly' => 'Blockera endast oinloggade användare',
	'globalblocking-block-errors' => 'Blockeringen misslyckades på grund av följande {{PLURAL:$1|anledning|anledningar}}:',
	'globalblocking-block-ipinvalid' => 'IP-adressen du skrev in ($1) är ogiltig.
Notera att du inte kan skriva in användarnamn.',
	'globalblocking-block-expiryinvalid' => 'Varigheten du skrev in ($1) är ogiltig.',
	'globalblocking-block-submit' => 'Blockera denna IP-adress globalt',
	'globalblocking-modify-submit' => 'Modifiera denna globala blockering',
	'globalblocking-block-success' => 'IP-adressen $1 har blivit blockerad på alla projekt.',
	'globalblocking-modify-success' => 'Den globala blockeringen på $1 har lyckats ändras',
	'globalblocking-block-successsub' => 'Global blockering lyckades',
	'globalblocking-modify-successsub' => 'Global blockering lyckats ändras',
	'globalblocking-block-alreadyblocked' => 'IP-adressen $1 är redan blockerad globalt.
Du kan visa den existerande blockeringen på [[Special:GlobalBlockList|listan över globala blockeringar]],
eller ändra inställningarna för den liggande blockeringen genom att igen använda detta formulär.',
	'globalblocking-block-bigrange' => 'IP-området du angav ($1) är för stort att blockeras. Du kan blockera högst 65&nbsp;536 adresser (/16-områden)',
	'globalblocking-list-intro' => 'Det här är en lista över nuvarande globala blockeringar. Vissa blockeringar är lokalt avslagna: det här betyder att den gäller på andra sajter, men att en lokal administratör har bestämt sig för att stänga av blockeringen på sin wiki.',
	'globalblocking-list' => 'Lista över globalt blockerade IP-adresser',
	'globalblocking-search-legend' => 'Sök efter en global blockering',
	'globalblocking-search-ip' => 'IP-adress:',
	'globalblocking-search-submit' => 'Sök efter blockeringar',
	'globalblocking-list-ipinvalid' => 'IP-adressen du skrev in ($1) är ogiltig.
Skriv in en giltig IP-adress.',
	'globalblocking-search-errors' => 'Din sökning misslyckades på grund av följande {{PLURAL:$1|anledning|anledningar}}:',
	'globalblocking-list-blockitem' => "\$1 <span class=\"plainlinks\">'''\$2'''</span> ('''\$3''') blockerade [[Special:Contributions/\$4|\$4]] globalt ''(\$5)''",
	'globalblocking-list-expiry' => 'varighet $1',
	'globalblocking-list-anononly' => 'endast oregistrerade',
	'globalblocking-list-unblock' => 'avblockera',
	'globalblocking-list-whitelisted' => 'lokalt avslagen av $1: $2',
	'globalblocking-list-whitelist' => 'lokal status',
	'globalblocking-list-modify' => 'modifiera',
	'globalblocking-list-noresults' => 'Den efterfrågade IP-adressen är inte blockerad.',
	'globalblocking-goto-block' => 'Blockera en IP-adress globalt',
	'globalblocking-goto-unblock' => 'Ta bort en global blockering',
	'globalblocking-goto-status' => 'Ändra lokal status för en global blockering',
	'globalblocking-return' => 'Tillbaka till listan över globala blockeringar',
	'globalblocking-notblocked' => 'IP-adressen du angav ($1) är inte globalt blockerad.',
	'globalblocking-unblock' => 'Ta bort en global blockering',
	'globalblocking-unblock-ipinvalid' => 'IP-adressen du skrev in ($1) är ogiltig.
Notera att du inte kan skriva in användarnamn!',
	'globalblocking-unblock-legend' => 'Ta bort en global blockering',
	'globalblocking-unblock-submit' => 'Ta bort global blockering',
	'globalblocking-unblock-reason' => 'Anledning:',
	'globalblocking-unblock-unblocked' => "Du har tagit bort den globala blockeringen (#$2) på IP-adressen '''$1'''",
	'globalblocking-unblock-errors' => 'Du kan inte ta bort en global blockering på den IP-adressen på grund av följande {{PLURAL:$1|anledning|anledningar}}:',
	'globalblocking-unblock-successsub' => 'Global blockering borttagen',
	'globalblocking-unblock-subtitle' => 'Tar bort global blockering',
	'globalblocking-unblock-intro' => 'Du kan använda detta formulär för att ta bort en global blockering.',
	'globalblocking-whitelist' => 'Lokal status för globala blockeringar',
	'globalblocking-whitelist-notapplied' => 'Globala blockeringar tillämpas inte på denna wiki,
så den lokala statusen av globala blockeringar kan inte ändras.',
	'globalblocking-whitelist-legend' => 'Ändra lokal status',
	'globalblocking-whitelist-reason' => 'Orsak:',
	'globalblocking-whitelist-status' => 'Lokal status:',
	'globalblocking-whitelist-statuslabel' => 'Slå av den här globala blockeringen på {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Ändra lokal status',
	'globalblocking-whitelist-whitelisted' => "Du har slagit av global blockering nr. $2 på IP-adressen '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Du har slagit på global blockering nr. $2 igen på IP-adressen '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Lokal status ändrad',
	'globalblocking-whitelist-nochange' => 'Du gjorde ingen ändring av den här blockeringens lokala status.
[[Special:GlobalBlockList|Återvänd till den globala blockeringslistan]].',
	'globalblocking-whitelist-errors' => 'Din ändring i den lokala statusen av en global blockering lyckades inte på grund av följande {{PLURAL:$1|anledning|anledningar}}:',
	'globalblocking-whitelist-intro' => 'Du kan använda det här formuläret till att redigera den lokala statusen för en global blockering. Om en global blockering är avslagen på den här wikin, kommer användarna av de påverkade IP-adresserna kunna redigera normalt. [[Special:GlobalBlockList|Klicka här]] för att gå tillbaka till den globala blockeringslistan.',
	'globalblocking-blocked' => "Din IP-adress \$5 har blockerats på alla wikis genom '''\$1''' (''\$2'').
Anledningen var ''\"\$3\"''.
Blockeringen ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Du kan inte återställa den här användarens lösenord eftersom ditt konto är globalblockerat.',
	'globalblocking-logpage' => 'Logg för globala blockeringar',
	'globalblocking-logpagetext' => 'Detta är en logg över globala blockeringar som har lagts och tagits bort på den här wikin.
Det bör noteras att globala blockeringar kan läggas och tas bort på andra wikier, och att dessa globala blockeringar kan påverka den här wikin.
För att se alla aktiva globala blockeringar, kan du se den [[Special:GlobalBlockList|globala blockeringslistan]].',
	'globalblocking-block-logentry' => 'blockerade [[$1]] globalt med en varighet på $2',
	'globalblocking-block2-logentry' => 'blockerade globalt [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'tog bort global blockering på [[$1]]',
	'globalblocking-whitelist-logentry' => 'slog av global blockering av [[$1]] lokalt',
	'globalblocking-dewhitelist-logentry' => 'slog på global blockering igen av [[$1]] lokalt',
	'globalblocking-modify-logentry' => 'modifierade den globala blockeringen på [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'varaktighet $1',
	'globalblocking-logentry-noexpiry' => 'ingen utgångstid satt',
	'globalblocking-loglink' => 'IP-adressen $1 är blockerad globalt ([[{{#Special:GlobalBlockList}}/$1|detaljer]]).',
	'globalblocking-showlog' => 'Denna IP-adress har tidigare blivit blockerad.
Blockeringsloggen visas nedan som referens:',
	'globalblocklist' => 'Lista över globalt blockerade IP-adresser',
	'globalblock' => 'Blockera en IP-adress globalt',
	'globalblockstatus' => 'Lokal status för globala blockeringar',
	'removeglobalblock' => 'Ta bort en global blockering',
	'right-globalblock' => 'Göra globala blockeringar',
	'right-globalunblock' => 'Ta bort globala blockeringar',
	'right-globalblock-whitelist' => 'Slå av globala blockeringar lokalt',
	'right-globalblock-exempt' => 'Gå förbi globala blockeringar',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'globalblocking-block-reason' => 'Sababu:',
	'globalblocking-block-otherreason' => 'Sababu nyingine:',
	'globalblocking-block-expiry' => 'Itakwisha:',
	'globalblocking-block-expiry-otherfield' => 'Kipindi kingine:',
	'globalblocking-list-unblock' => 'ondoa',
	'globalblocking-unblock-reason' => 'Sababu:',
	'globalblocking-whitelist-reason' => 'Sababu:',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 * @author TRYPPN
 */
$messages['ta'] = array(
	'globalblocking-modify-intro' => 'நீங்கள் இந்த படிவத்தை உலகளாவிய தடையின் அமைப்புகளை மாற்ற பயன்படுத்தலாம்.',
	'globalblocking-block-intro' => 'நீங்கள் இந்த பக்கத்தை ஒரு IP முகவரியை அனைத்து விக்கிகளிலும் தடை செய்ய பயன்படுத்தலாம்.',
	'globalblocking-block-reason' => 'காரணம்:',
	'globalblocking-block-otherreason' => 'மற்ற/கூடுதல் காரணங்கள்',
	'globalblocking-block-reasonotherlist' => 'மற்ற காரணங்கள்',
	'globalblocking-block-reason-dropdown' => '* பொதுவான தடைக்கான காரணங்கள்
** Crosswiki spamming
** Crosswiki முறைகேடு
** Vandalism',
	'globalblocking-block-edit-dropdown' => 'தடை காரணங்களை தொகு',
	'globalblocking-block-expiry' => 'முடிவுறுதல்:',
	'globalblocking-block-expiry-other' => 'மற்ற காலாவதியாகும் நேரம்',
	'globalblocking-block-expiry-otherfield' => 'வேறு நேரம்:',
	'globalblocking-block-legend' => 'உலகளவில் ஒரு IP முகவரியை தடு',
	'globalblocking-block-options' => 'விருப்பத்தேர்வுகள்:',
	'globalblocking-ipaddress' => 'ஐ.பி. முகவரி:',
	'globalblocking-ipbanononly' => 'அடையாளம் தெரியாத பயனர்களை மட்டும் தடு',
	'globalblocking-block-errors' => 'உங்கள் தடை தோல்வியடைந்து, பின்வரும் {{PLURAL:$1| காரணம்|காரணங்கள்}}:',
	'globalblocking-block-submit' => 'உலகளவில் இந்த IP முகவரியை தடைசெய்',
	'globalblocking-modify-submit' => 'இந்த உலகளவிய தடையை திருத்து',
	'globalblocking-block-success' => 'IPமுகவரி $1 அனைத்து திட்டங்களிலும் வெற்றிகரமாக தடுக்கப்பட்டது.',
	'globalblocking-modify-success' => '$1 ல் உலகலவிய தடை வெற்றிகரமாக திருத்தப்பட்டது.',
	'globalblocking-block-successsub' => 'உலகளவிய தடை வெற்றிகரமாக செயல்படுத்தப்பட்டது.',
	'globalblocking-modify-successsub' => 'உலகளவிய தடை வெற்றிகரமாக திருத்தப்பட்டது.',
	'globalblocking-block-alreadyblocked' => 'IP முகவரி $1 ஏற்கனவே உலகளவில் தடுக்கப்பட்டுள்ளது.
ஏற்கனவே உள்ள தடையை [[Special:GlobalBlockList|உலகளவிய தடைகளின் பட்டியல்]] மூலம் நீங்கள் பார்க்கலாம்.
அல்லது இந்த படிவத்தை மறு சமர்ப்பித்தல் மூலம் ஏற்கனவே உள்ள தடையின் அமைவுகளை திருத்தவும்.',
	'globalblocking-list' => 'உலகளவில் தடை செய்யப்பட்ட IP முகவரிகளின் பட்டியல்.',
	'globalblocking-search-legend' => 'ஒரு உலகளவிய தடையை தேடு',
	'globalblocking-search-ip' => 'ஐ.பி. முகவரி:',
	'globalblocking-search-submit' => 'தடைகளை தேடு',
	'globalblocking-list-ipinvalid' => '($1)க்காக நீங்கள் தேடிய IP முகவரி செல்லாதது.
தயவுசெய்து ஒரு செல்லத்தக்க  IP முகவரியை உள்ளிடவும்',
	'globalblocking-search-errors' => 'உங்கள் தேடல் தோல்வியடைந்தது, பின்வரும் {{PLURAL:$1|காரணம்|காரணங்கள்}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') உலகளவில் தடைசெய்யப்பட்டது [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'காலாவதியாகும் $1',
	'globalblocking-list-anononly' => 'அநாமதேய பயனர்கள் மட்டும்',
	'globalblocking-list-unblock' => 'நீக்கு',
	'globalblocking-list-whitelisted' => 'உள்ளமைவாக தடுக்கப்பட்டுள்ளது $1: $2 ஆல்',
	'globalblocking-list-whitelist' => 'உள் நிலைமை',
	'globalblocking-list-modify' => 'திருத்தம் செய்',
	'globalblocking-list-noresults' => 'கோரிய IP  முகவரி தடை செய்யப்படவில்லை',
	'globalblocking-goto-block' => 'உலகளவில் ஒரு IP முகவரியை தடைசெய்',
	'globalblocking-goto-unblock' => 'ஒரு உலகளவிய தடையை நீக்கு',
	'globalblocking-goto-status' => 'ஒரு உலகளவிய தடையின் உள்ளமைவு நிலைமையை மாற்று',
	'globalblocking-return' => 'உலகளாவிய தடையின் பட்டியலுக்கு திரும்பு',
	'globalblocking-unblock' => 'ஒரு உலகளவிய தடையை நீக்கு',
	'globalblocking-unblock-legend' => 'உலகளவிய தடையை நீக்கு',
	'globalblocking-unblock-submit' => 'உலகளவிய தடையை நீக்கு',
	'globalblocking-unblock-reason' => 'காரணம்:',
	'globalblocking-unblock-unblocked' => "நீங்கள் வெற்றிகரமாக உலகளவிய தடை #$2 வை IP முகவரி '''$1''' ல் நீக்கிவிட்டீர்கள்.",
	'globalblocking-unblock-errors' => 'உங்கள் தடை நீக்கல் தோல்வியடைந்தது, பின்வரும் {{PLURAL:$1| காரணம்|காரணங்கள்}}:',
	'globalblocking-unblock-successsub' => 'உலகளவிய தடை வெற்றிகரமாக நீக்கப்பட்டது.',
	'globalblocking-unblock-subtitle' => 'உலகளவிய தடையை நீக்கு',
	'globalblocking-unblock-intro' => 'நீங்கள் இந்த படிவத்தை ஒரு உலகளவிய தடையை நீக்க பயன்படுத்தலாம்.',
	'globalblocking-whitelist' => 'உலகளாவிய தடையின் உள்ளமை நிலை',
	'globalblocking-whitelist-notapplied' => 'உலகளாவிய தடுப்புகள் இந்த விக்கியில் பயன்படுத்தப்படவில்லை.
எனவே உலகளாவிய தடுப்புகளின் உள் நிலையை திருத்த முடியாது.',
	'globalblocking-whitelist-legend' => 'உள் நிலை மாற்று',
	'globalblocking-whitelist-reason' => 'காரணம்:',
	'globalblocking-whitelist-status' => 'உள்ளூர் நிலைமை:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}} ல் உலகளவிய தடையை செயலிழக்க செய்',
	'globalblocking-whitelist-submit' => 'உள் நிலை மாற்று',
	'globalblocking-block2-logentry' => 'உலகளவில் தடைசெய்யப்பட்டுள்ளது [[$1]] ($2)',
	'globalblocking-unblock-logentry' => ' [[$1]] ல் நீக்கப்பட்ட உலகளவிய தடைகள்',
	'globalblocklist' => 'உலகளவில் தடை செய்யப்பட்ட IP முகவரிகளின் பட்டியல்',
	'globalblock' => 'உலகளவில் ஒரு IP முகவரியை தடைசெய்',
	'globalblockstatus' => 'உலகளவிய தடையின் உள்நிலைமை',
	'removeglobalblock' => 'ஒரு உலகளவிய தடையை நீக்கு',
	'right-globalblock' => 'உலகளவிய தடையை உருவாக்கு',
	'right-globalunblock' => 'உலகளவிய தடைகளை நீக்கு',
	'right-globalblock-whitelist' => 'உள்ளமைவில் உலகளாவிய தடைகளை செயல்நீக்கவும்',
	'right-globalblock-exempt' => 'உலகளவிய தடையை மீறு',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'globalblocking-block' => 'ఒక ఐపీ చిరునామాని సార్వత్రికంగా నిరోధించు',
	'globalblocking-modify-intro' => 'సార్వత్రిక నిరోధం యొక్క అమరికలను మార్చడానికి ఈ క్రింది ఫారాన్ని ఉపయోగించగలరు.',
	'globalblocking-block-intro' => 'ఈ పేజీని ఉపయోగించి మీరు అన్ని వికీలలోనూ ఒక IP చిరునామాని నిరోధించగలరు.',
	'globalblocking-block-reason' => 'కారణం:',
	'globalblocking-block-otherreason' => 'ఇతర/అదనపు కారణం:',
	'globalblocking-block-reasonotherlist' => 'ఇతర కారణం',
	'globalblocking-block-edit-dropdown' => 'నిరోధపు కారణాలను మార్చండి',
	'globalblocking-block-expiry' => 'కాలపరిమితి:',
	'globalblocking-block-expiry-other' => 'ఇతర కాలపరిమితి సమయం',
	'globalblocking-block-expiry-otherfield' => 'ఇతర సమయం:',
	'globalblocking-block-legend' => 'ఐపీ చిరునామా సార్వత్రిక నిరోధం',
	'globalblocking-block-options' => 'ఎంపికలు:',
	'globalblocking-ipaddress' => 'ఐపీ చిరునామా:',
	'globalblocking-ipbanononly' => 'అజ్ఞాత వాడుకరులను మాత్రమే నిరోధించండి',
	'globalblocking-block-errors' => 'మీ నిరోధం విఫలమైంది, ఈ క్రింది {{PLURAL:$1|కారణం|కారణాల}} వల్ల:',
	'globalblocking-block-ipinvalid' => 'మీరు ఇచ్చిన ఐపీ చిరునామా ($1) చెల్లదు.
మీరు వాడుకరి పేరుని ఇవ్వకూడదని గమనించండి!',
	'globalblocking-block-expiryinvalid' => 'మీరు ఇచ్చిన కాలపరిమితి ($1) చెల్లదు.',
	'globalblocking-block-submit' => 'ఈ ఐపీ చిరునామాని సార్వత్రికంగా నిరోధించు',
	'globalblocking-modify-submit' => 'ఈ సార్వత్రిక నిరోధాన్ని మార్చండి',
	'globalblocking-block-success' => 'ఐపీ చిరునామా $1 ని అన్ని ప్రాజెక్టులలోనూ జయప్రదంగా నిరోధించాం.',
	'globalblocking-modify-success' => '$1 పై సార్వత్రిక నిరోధాన్ని విజయవంతంగా మార్చాం',
	'globalblocking-block-successsub' => 'సార్వత్రిక నిరోధం విజయవంతం',
	'globalblocking-modify-successsub' => 'సార్వత్రిక నిరోధాన్ని విజయవంతంగా మార్చాం',
	'globalblocking-block-alreadyblocked' => '$1 అనే ఐపీ చిరునామాని ఇప్పటికే సార్వత్రికంగా నిరోధించారు.
[[Special:GlobalBlockList|సార్వత్రిక నిరోధాల జాబితా]] వద్ద మీరు ప్రస్తుత నిరోధాన్ని చూడవచ్చు,
లేదా ఈ ఫారాన్ని తిరిగి దాఖలుచెయ్యడం ద్వారా ప్రస్తుత నిరోధపు అమరికలని మార్చవచ్చు.',
	'globalblocking-block-bigrange' => 'నిరోధించడానికి మీరు ఇచ్చిన అవధి ($1) చాలా పెద్దగా ఉంది.
మీరు, గరిష్ఠంగా, 65,536 చిరునామాలని (/16 అవధులు) నిరోధించవచ్చు',
	'globalblocking-list' => 'సార్వత్రికంగా నిరోధించిన ఐపీ చిరునామాల జాబితా',
	'globalblocking-search-legend' => 'సార్వత్రిక నిరోధానికై అన్వేషణ',
	'globalblocking-search-ip' => 'IP చిరునామా:',
	'globalblocking-search-submit' => 'నిరోధాల కోసం వెతుకు',
	'globalblocking-list-ipinvalid' => 'మీరు వెతికిన ఐపీ చిరునామా ($1) చెల్లనిది.
దయచేసి సరైన ఐపీ చిరునామాని ఇవ్వండి.',
	'globalblocking-search-errors' => 'ఈ క్రింది {{PLURAL:$1|కారణం|కారణాల}} వల్ల, మీ అన్వేషణ విఫలమైంది:',
	'globalblocking-list-expiry' => 'కాలపరిమితి $1',
	'globalblocking-list-anononly' => 'అజ్ఞాతలు మాత్రమే',
	'globalblocking-list-unblock' => 'తొలగించు',
	'globalblocking-list-whitelisted' => '$1 స్థానికంగా అచేతనం చేసారు: $2',
	'globalblocking-list-whitelist' => 'స్థానిక స్థితి',
	'globalblocking-list-modify' => 'మార్చు',
	'globalblocking-list-noresults' => 'అభ్యర్థించిన ఐపీ చిరునామాపై నిరోధం లేదు.',
	'globalblocking-goto-block' => 'ఒక ఐపీ చిరునామాని సార్వత్రికంగా నిరోధించు',
	'globalblocking-goto-unblock' => 'ఒక సార్వత్రిక నిరోధాన్ని తొలగించు',
	'globalblocking-goto-status' => 'సార్వత్రిక నిరోధానికి స్థానిక స్థితిని మార్చండి',
	'globalblocking-return' => 'తిరిగి సార్వత్రిక నిరోధాల జాబితాకి',
	'globalblocking-notblocked' => 'మీరు ఇచ్చిన ఐపీ చిరునామా ($1) పై సార్వత్రిక నిరోధం లేదు.',
	'globalblocking-unblock' => 'సార్వత్రిక నిరోధపు తొలగింపు',
	'globalblocking-unblock-ipinvalid' => 'మీరు ఇచ్చిన ఐపీ చిరునామా ($1) చెల్లనిది.
మీరు వాడుకరి పేరుని ఇవ్వకూడదని దయచేసి గమనించండి!',
	'globalblocking-unblock-legend' => 'సార్వత్రిక నిరోధపు తొలగింపు',
	'globalblocking-unblock-submit' => 'సార్వత్రిక నిరోధాన్ని తొలగించు',
	'globalblocking-unblock-reason' => 'కారణం:',
	'globalblocking-unblock-unblocked' => "మీరు '''$1''' ఐపీ చిరునామాపై ఉన్న సార్వత్రిక నిరోధం #$2ని విజయవంతంగా తొలగించారు",
	'globalblocking-unblock-errors' => 'మీ సార్వత్రిక నిరోధపు ఎత్తివేత విఫలమైంది, ఈ క్రింది {{PLURAL:$1|కారణం|కారణాల}} వల్ల:',
	'globalblocking-unblock-successsub' => 'సార్వత్రిక నిరోధాన్ని జయప్రదంగా తొలగించారు',
	'globalblocking-unblock-subtitle' => 'సార్వత్రిక నిరోధపు తొలగింపు',
	'globalblocking-unblock-intro' => 'సార్వత్రిక నిరోధాలని తొలగించడానికి మీరు ఈ ఫారాన్ని ఉపయోగించవచ్చు.',
	'globalblocking-whitelist' => 'సార్వత్రిక నిరోధాల యొక్క స్థానిక స్థితి',
	'globalblocking-whitelist-notapplied' => 'ఈ వికీలో సార్వత్రిక నిరోధాలు వర్తించవు,
కాబట్టి సార్వత్రిక నిరోధాల యొక్క స్థానిక స్థితిని మార్చలేరు.',
	'globalblocking-whitelist-legend' => 'స్థానిక స్థితి మార్పు',
	'globalblocking-whitelist-reason' => 'కారణం:',
	'globalblocking-whitelist-status' => 'స్థానిక స్థితి:',
	'globalblocking-whitelist-statuslabel' => '{{SITENAME}}లో ఈ సార్వత్రిక నిరోధాన్ని అచేతనం చేయి',
	'globalblocking-whitelist-submit' => 'స్థానిక స్థితిని మార్చండి',
	'globalblocking-whitelist-whitelisted' => "'''$1''' అన్న ఐపీ చిరునామాపై సార్వత్రిక నిరోధం #$2ని {{SITENAME}}లో మీరు విజయవంతంగా అచేతనం చేసారు.",
	'globalblocking-whitelist-dewhitelisted' => "'''$1''' అన్న ఐపీ చిరునామాపై సార్వత్రిక నిరోధం #$2ని {{SITENAME}}లో మీరు విజయవంతంగా పునఃచేతనం చేసారు.",
	'globalblocking-whitelist-successsub' => 'స్థానిక స్థితిని విజయవంతంగా మార్చాం',
	'globalblocking-whitelist-nochange' => 'ఈ నిరోధపు స్థానిక స్థితికి మీరు మార్పులేమీ చెయ్యలేదు.
[[Special:GlobalBlockList|తిరిగి సార్వత్రిక నిరోధాల జాబితాకి]].',
	'globalblocking-whitelist-errors' => 'సార్వత్రిక నిరోధపు స్థానిక స్థితికి మీరు చేసిన మార్పు విఫలమైంది, ఈ క్రింది {{PLURAL:$1|కారణం|కారణాల}} వల్ల:',
	'globalblocking-blocked' => "మీ ఐపీ చిరునామాని అన్ని వికీలలో '''\$1''' నిరోధించారు (''\$2'').
పేర్కొన్న కారణం ''\"\$3\"''.
నిరోధం ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'మీరు వాడుకరి సంకేతపదాన్ని అమర్చలేరు ఎందుకంటే మిమ్మల్ని సార్వత్రికంగా నిరోధించారు.',
	'globalblocking-logpage' => 'సార్వత్రిక నిరోధాల చిట్టా',
	'globalblocking-block-logentry' => '[[$1]]ని $2 కాలపరిమితితో సార్వత్రికంగా నిరోధించారు',
	'globalblocking-block2-logentry' => '[[$1]]ని సార్వత్రికంగా నిరోధించారు ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] పై సార్వత్రిక నిరోధాన్ని ఎత్తివేసారు',
	'globalblocking-whitelist-logentry' => '[[$1]]పై సార్వత్రిక నిరోధాన్ని స్థానికంగా అచేతనం చేసారు',
	'globalblocking-dewhitelist-logentry' => '[[$1]]పై సార్వత్రిక నిరోధాన్ని స్థానికంగా పునఃచేతనం చేసారు',
	'globalblocking-modify-logentry' => '[[$1]]పై సార్వత్రిక నిరోధాన్ని మార్చారు ($2)',
	'globalblocking-logentry-expiry' => '$1న కాలంచెల్లుతుంది',
	'globalblocking-logentry-noexpiry' => 'కాలపరిమితిని అమర్చలేదు',
	'globalblocking-loglink' => '$1 అనే ఐపీ చిరునామాని సార్వత్రికంగా నిరోధించారు ([[{{#Special:GlobalBlockList}}/$1|పూర్తి వివరాలు]]).',
	'globalblocking-showlog' => 'ఈ ఐపీ చిరునామాని గతంలో నిరోధించి ఉన్నారు.
మీ సమాచారం కోసం నిరోధపు చిట్టాని క్రింద ఇస్తున్నాం:',
	'globalblocklist' => 'సార్వత్రికంగా నిరోధించబడిన ఐపీ చిరునామాల జాబితా',
	'globalblock' => 'సర్వత్రా ఈ ఐపీ చిరునామాను నిరోధించు',
	'globalblockstatus' => 'సార్వత్రిక నిరోధాల స్థానిక స్థితి',
	'removeglobalblock' => 'ఒక సార్వత్రిక నిరోధాన్ని తొలగించు',
	'right-globalblock' => 'సార్వత్రిక నిరోధాల్ని చేయడం',
	'right-globalunblock' => 'సార్వత్రిక నిరోధాల్ని తొలగించడం',
	'right-globalblock-whitelist' => 'సార్వత్రిక నిరోధాల్ని స్థానికంగా అచేతనం చేయగలగడం',
	'right-globalblock-exempt' => 'సార్వత్రిక నిరోధాలని తప్పించగలడం',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'globalblocking-block-expiry-otherfield' => 'Tempu seluk:',
	'globalblocking-search-ip' => 'Diresaun IP:',
	'globalblocking-list-anononly' => "ema anónimu de'it",
	'globalblocking-unblock-reason' => 'Motivu:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'globalblocking-block' => 'Бастани як нишонаи IP ба сурати саросарӣ',
	'globalblocking-block-intro' => 'Шумо ин саҳифаро барои бастани нишонаи IP дар ҳамаи викиҳо метавонед истифода баред.',
	'globalblocking-block-reason' => 'Сабаб:',
	'globalblocking-block-expiry' => 'Хоти қатъи дастрасӣ:',
	'globalblocking-block-expiry-other' => 'Дигар вақти хотима',
	'globalblocking-block-expiry-otherfield' => 'Дигар вақт:',
	'globalblocking-block-legend' => 'Бастани дастрасии корбар ба сурати саросарӣ',
	'globalblocking-block-options' => 'Ихтиёрот:',
	'globalblocking-block-errors' => 'Бастани дастрасии аз тарафи шумо номуваффақ шуд, аз рӯи {{PLURAL:$1|сабаби|сабаҳои}} зерин:',
	'globalblocking-block-ipinvalid' => 'Нишонаи IP ($1) шумо ворид намуда номӯътабар аст.
Лутфан дар хотир нигоҳ доред, ки шумо наметавонед як номи корбариро ворид кунед!',
	'globalblocking-block-expiryinvalid' => 'Санаи эътибороти шумо вориднамуд ($1) номӯътабар аст.',
	'globalblocking-block-submit' => 'Бастани ин нишонаи IP ба сурати саросарӣ',
	'globalblocking-block-success' => 'Нишонаи IP $1 бо муваффақият дар ҳамаи лоиҳаҳо баста шуд.',
	'globalblocking-block-successsub' => 'Бастани дастрасӣ ба сурати саросарӣ муваффақ шуд',
	'globalblocking-block-alreadyblocked' => 'Нишонаи IP $1 қаблан саросарӣ басташуда аст.
Шумо метавонед бастаҳои вуҷуддоштаро дар [[Special:GlobalBlockList|феҳристи бастаҳои саросарӣ]] бинигаред.',
	'globalblocking-list' => 'Феҳристи нишонаҳои IP саросари басташуда',
	'globalblocking-search-legend' => 'Ҷустуҷӯи саросари басташуда',
	'globalblocking-search-ip' => 'Нишонаи IP:',
	'globalblocking-search-submit' => 'Ҷустуҷӯи басташудаҳо',
	'globalblocking-list-ipinvalid' => 'Нишонаи IP шумо ҷустуҷӯ намуда ($1) номӯътабар аст.
Лутфан нишонаи IP мӯътабареро ворид кунед.',
	'globalblocking-search-errors' => 'Ҷустуҷӯи шумо номуваффақ буд, аз рӯи {{PLURAL:$1|сабаби|сабабҳои}} зерин:',
	'globalblocking-list-expiry' => 'хотима $1',
	'globalblocking-list-anononly' => 'фақат гумном',
	'globalblocking-list-unblock' => 'пок кардан',
	'globalblocking-list-whitelisted' => 'маҳаллӣ ғайрифаъол карда шудааст аз тарафи $1: $2',
	'globalblocking-list-whitelist' => 'вазъияти маҳаллӣ',
	'globalblocking-goto-block' => 'Саросарӣ бастани як нишонаи IP',
	'globalblocking-goto-unblock' => 'Пок кардани бастаи саросарӣ',
	'globalblocking-goto-status' => 'Тағйири вазъияти маҳаллӣ ба як бастаи саросарӣ',
	'globalblocking-return' => 'Бозгашта ба феҳристи бастаҳои саросарӣ',
	'globalblocking-notblocked' => 'Нишонаи IP ($1) шумо ворид карда саросарӣ баста нашудааст.',
	'globalblocking-unblock' => 'Пок кардани бастаи саросарӣ',
	'globalblocking-unblock-ipinvalid' => 'Нишоани IP ($1) ворид намуда номӯътабар аст.
Лутфан дар ёд доред, ки шумо наметавонед як номи корбариро ворид кунед!',
	'globalblocking-unblock-legend' => 'Пок кардани бастаи саросарӣ',
	'globalblocking-unblock-submit' => 'Пок кардани бастаи саросарӣ',
	'globalblocking-unblock-reason' => 'Сабаб:',
	'globalblocking-unblock-unblocked' => "Шумо бо муваффақият бастаи саросарии #$2 аз рӯи нишонаи IP '''$1''' пок кардед",
	'globalblocking-unblock-errors' => 'Поккунии бастаи саросарии шумо номуваффақ шуд, аз {{PLURAL:$1|сабаби|сабабҳои}} зерин:',
	'globalblocking-unblock-successsub' => 'Бастаи саросарӣ бо муваффақият пок шуд',
	'globalblocking-unblock-subtitle' => 'Дар ҳоли пок кардани баста саросарӣ',
	'globalblocking-unblock-intro' => 'Шумо метавонед барои пок кардани бастаи саросарӣ аз ин форм истифода баред.',
	'globalblocking-whitelist' => 'Вазъияти маҳаллии бастаҳои саросарӣ',
	'globalblocking-whitelist-legend' => 'Тағйири вазъияти маҳаллӣ',
	'globalblocking-whitelist-reason' => 'Сабаб:',
	'globalblocking-whitelist-status' => 'Вазъияти маҳаллӣ:',
	'globalblocking-whitelist-statuslabel' => 'Ғайрифаъол кардани ин бастаи саросарӣ дар {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Тағйири вазъияти маҳаллӣ',
	'globalblocking-whitelist-successsub' => 'Вазъияти маҳаллӣ бо муваффақият тағйир ёфт',
	'globalblocking-whitelist-nochange' => 'Шумо ягон тағйире ба вазъияти маҳалли ин қатъи дастрасӣ ворид накардед.
[[Special:GlobalBlockList|Баргардед ба феҳристи қатъи дастрасии саросарӣ]].',
	'globalblocking-blocked' => "Нишоани IP шумо дар ҳамаи викиҳо тавассути '''\$1''' (''\$2'') баста шудааст.
Сабаби додашуда ''\"\$3\"'' буд.
Бастаи ''\$4''.",
	'globalblocking-logpage' => 'Гузориши бастаи саросарӣ',
	'globalblocking-unblock-logentry' => 'қатъи дастрасии саросарӣ дар [[$1]] пок шуд',
	'globalblocking-whitelist-logentry' => 'қатъи дастрасии саросарӣ дар [[$1]] маҳаллӣ ғайрифаъол шуд',
	'globalblocklist' => 'Феҳристи нишонаҳои IP саросарӣ қатъ кардашуда',
	'globalblock' => 'Ба сурати саросарӣ қатъ кардани нишонаи IP',
	'globalblockstatus' => 'Вазъияти маҳаллии қатъи дастрасии саросарӣ',
	'removeglobalblock' => 'Пок кардани қатъи дастрасӣ',
	'right-globalblock' => 'Эҷоди қатъи дастрасиҳои саросарӣ',
	'right-globalunblock' => 'Ҳазфи қатъи дастрасиҳои саросарӣ',
	'right-globalblock-whitelist' => 'Ғайри фаъол кардани қатъи дастрасиҳои саросарӣ ба таври маҳаллӣ',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'globalblocking-block' => 'Bastani jak nişonai IP ba surati sarosarī',
	'globalblocking-block-intro' => 'Şumo in sahifaro baroi bastani nişonai IP dar hamai vikiho metavoned istifoda bared.',
	'globalblocking-block-reason' => 'Sabab:',
	'globalblocking-block-expiry' => "Xoti qat'i dastrasī:",
	'globalblocking-block-expiry-other' => 'Digar vaqti xotima',
	'globalblocking-block-expiry-otherfield' => 'Digar vaqt:',
	'globalblocking-block-options' => 'Ixtijorot:',
	'globalblocking-block-errors' => 'Bastani dastrasiji az tarafi şumo nomuvaffaq şud, az rūi {{PLURAL:$1|sababi|sabahoi}} zerin:',
	'globalblocking-block-ipinvalid' => "Nişonai IP ($1) şumo vorid namuda nomū'tabar ast.
Lutfan dar xotir nigoh dored, ki şumo nametavoned jak nomi korbariro vorid kuned!",
	'globalblocking-block-expiryinvalid' => "Sanai e'tiboroti şumo voridnamud ($1) nomū'tabar ast.",
	'globalblocking-block-submit' => 'Bastani in nişonai IP ba surati sarosarī',
	'globalblocking-block-success' => 'Nişonai IP $1 bo muvaffaqijat dar hamai loihaho basta şud.',
	'globalblocking-block-successsub' => 'Bastani dastrasī ba surati sarosarī muvaffaq şud',
	'globalblocking-list' => 'Fehristi nişonahoi IP sarosari bastaşuda',
	'globalblocking-search-legend' => 'Çustuçūi sarosari bastaşuda',
	'globalblocking-search-ip' => 'Nişonai IP:',
	'globalblocking-search-submit' => 'Çustuçūi bastaşudaho',
	'globalblocking-list-ipinvalid' => "Nişonai IP şumo çustuçū namuda ($1) nomū'tabar ast.
Lutfan nişonai IP mū'tabarero vorid kuned.",
	'globalblocking-search-errors' => 'Çustuçūi şumo nomuvaffaq bud, az rūi {{PLURAL:$1|sababi|sababhoi}} zerin:',
	'globalblocking-list-expiry' => 'xotima $1',
	'globalblocking-list-anononly' => 'faqat gumnom',
	'globalblocking-list-unblock' => 'pok kardan',
	'globalblocking-list-whitelisted' => "mahallī ƣajrifa'ol karda şudaast az tarafi $1: $2",
	'globalblocking-list-whitelist' => "vaz'ijati mahallī",
	'globalblocking-goto-block' => 'Sarosarī bastani jak nişonai IP',
	'globalblocking-goto-unblock' => 'Pok kardani bastai sarosarī',
	'globalblocking-goto-status' => "Taƣjiri vaz'ijati mahallī ba jak bastai sarosarī",
	'globalblocking-return' => 'Bozgaşta ba fehristi bastahoi sarosarī',
	'globalblocking-notblocked' => 'Nişonai IP ($1) şumo vorid karda sarosarī basta naşudaast.',
	'globalblocking-unblock' => 'Pok kardani bastai sarosarī',
	'globalblocking-unblock-ipinvalid' => "Nişoani IP ($1) vorid namuda nomū'tabar ast.
Lutfan dar jod dored, ki şumo nametavoned jak nomi korbariro vorid kuned!",
	'globalblocking-unblock-legend' => 'Pok kardani bastai sarosarī',
	'globalblocking-unblock-submit' => 'Pok kardani bastai sarosarī',
	'globalblocking-unblock-reason' => 'Sabab:',
	'globalblocking-unblock-unblocked' => "Şumo bo muvaffaqijat bastai sarosariji #$2 az rūi nişonai IP '''$1''' pok karded",
	'globalblocking-unblock-errors' => 'Pokkuniji bastai sarosariji şumo nomuvaffaq şud, az {{PLURAL:$1|sababi|sababhoi}} zerin:',
	'globalblocking-unblock-successsub' => 'Bastai sarosarī bo muvaffaqijat pok şud',
	'globalblocking-unblock-subtitle' => 'Dar holi pok kardani basta sarosarī',
	'globalblocking-unblock-intro' => 'Şumo metavoned baroi pok kardani bastai sarosarī az in form istifoda bared.',
	'globalblocking-whitelist' => "Vaz'ijati mahalliji bastahoi sarosarī",
	'globalblocking-whitelist-legend' => "Taƣjiri vaz'ijati mahallī",
	'globalblocking-whitelist-reason' => 'Sabab:',
	'globalblocking-whitelist-status' => "Vaz'ijati mahallī:",
	'globalblocking-whitelist-statuslabel' => "Ƣajrifa'ol kardani in bastai sarosarī dar {{SITENAME}}",
	'globalblocking-whitelist-submit' => "Taƣjiri vaz'ijati mahallī",
	'globalblocking-whitelist-successsub' => "Vaz'ijati mahallī bo muvaffaqijat taƣjir joft",
	'globalblocking-whitelist-nochange' => "Şumo jagon taƣjire ba vaz'ijati mahalli in qat'i dastrasī vorid nakarded.
[[Special:GlobalBlockList|Bargarded ba fehristi qat'i dastrasiji sarosarī]].",
	'globalblocking-blocked' => "Nişoani IP şumo dar hamai vikiho tavassuti '''\$1''' (''\$2'') basta şudaast.
Sababi dodaşuda ''\"\$3\"'' bud.
Bastai ''\$4''.",
	'globalblocking-logpage' => 'Guzorişi bastai sarosarī',
	'globalblocking-unblock-logentry' => "qat'i dastrasiji sarosarī dar [[$1]] pok şud",
	'globalblocking-whitelist-logentry' => "qat'i dastrasiji sarosarī dar [[$1]] mahallī ƣajrifa'ol şud",
	'globalblocklist' => "Fehristi nişonahoi IP sarosarī qat' kardaşuda",
	'globalblock' => "Ba surati sarosarī qat' kardani nişonai IP",
	'globalblockstatus' => "Vaz'ijati mahalliji qat'i dastrasiji sarosarī",
	'removeglobalblock' => "Pok kardani qat'i dastrasī",
	'right-globalblock' => "Eçodi qat'i dastrasihoi sarosarī",
	'right-globalunblock' => "Hazfi qat'i dastrasihoi sarosarī",
	'right-globalblock-whitelist' => "Ƣajri fa'ol kardani qat'i dastrasihoi sarosarī ba tavri mahallī",
);

/** Thai (ไทย)
 * @author Ans
 * @author Horus
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|อนุญาต]]ให้คุณสามารถบล็อกผู้ใช้ที่เป็น ไอพี [[Special:GlobalBlockList|ในหลาย ๆ วิกิ]]ในครั้งเดียวได้',
	'globalblocking-block-reason' => 'เหตุผล:',
	'globalblocking-block-otherreason' => 'เหตุผลอื่น/เพิ่มเติม',
	'globalblocking-block-reasonotherlist' => 'เหตุผลอื่น',
	'globalblocking-block-edit-dropdown' => 'แก้ไขเหตุผลการบล็อก',
	'globalblocking-block-expiry' => 'หมดอายุ:',
	'globalblocking-block-expiry-other' => 'เวลาหมดอายุอื่น',
	'globalblocking-block-expiry-otherfield' => 'เวลาอื่น:',
	'globalblocking-block-options' => 'ตัวเลือก:',
	'globalblocking-ipaddress' => 'ที่อยู่ไอพี:',
	'globalblocking-block-errors' => 'การสกัดกั้นไม่สำเร็จ เนื่องจาก{{PLURAL:$1|เหตุผลต่อไปนี้}}:',
	'globalblocking-block-submit' => 'บล็อกที่อยู่ไอพีนี้ทั่วโลก',
	'globalblocking-search-ip' => 'หมายเลขไอพี:',
	'globalblocking-unblock-reason' => 'เหตุผล:',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'globalblocking-desc' => 'IP adresleriniň [[Special:GlobalBlockList|köp sanly wikide blokirlenmegine]] [[Special:GlobalBlock|rugsat berýär]]',
	'globalblocking-block' => 'IP adresini global blokirle',
	'globalblocking-modify-intro' => 'Global blokirlemäniň sazlamalryny üýtgetmek üçin şu formdan peýdalanyp bilersiňiz.',
	'globalblocking-block-intro' => 'IP adresini ähli wikilerde blokirlemek üçin şu sahypany ulanyp bilersiňiz.',
	'globalblocking-block-reason' => 'Sebäp:',
	'globalblocking-block-otherreason' => 'Başga/goşmaça sebäp:',
	'globalblocking-block-reasonotherlist' => 'Başga sebäp',
	'globalblocking-block-reason-dropdown' => '* Umumy blokirleme sebäpleri
** Wiki-ara spam
** Wiki-ara betniýetli ulanyş
** Wandalizm',
	'globalblocking-block-edit-dropdown' => 'Blokirleme sebäplerini redaktirle',
	'globalblocking-block-expiry' => 'Blokirlemäniň gutarýan senesi:',
	'globalblocking-block-expiry-other' => 'Başga gutaryş wagty',
	'globalblocking-block-expiry-otherfield' => 'Başga wagt:',
	'globalblocking-block-legend' => 'IP adresini global blokirle',
	'globalblocking-block-options' => 'Opsiýalar:',
	'globalblocking-block-errors' => 'Blokirlemäňiz başa barmady, şu {{PLURAL:$1|sebäp|sebäpler}} zerarly:',
	'globalblocking-block-ipinvalid' => 'Ýazan IP adresiňiz ($1) nädogry.
Ulanyjy adyny ýazmak bolýan däldir!',
	'globalblocking-block-expiryinvalid' => 'Ýazan gutaryş möhletiňiz ($1) nädogry.',
	'globalblocking-block-submit' => 'Bu IP adresini global blokirle',
	'globalblocking-modify-submit' => 'Bu global blokirlemäni üýtget',
	'globalblocking-block-success' => '$1 IP adresi ähli taslamalarda şowly blokirlendi.',
	'globalblocking-modify-success' => '$1 hakdaky global blokirleme şowly üýtgedildi',
	'globalblocking-block-successsub' => 'Global blokirleme şowly',
	'globalblocking-modify-successsub' => 'Global blokirleme şowly üýtgedildi',
	'globalblocking-block-alreadyblocked' => '$1 IP adresi eýýäm global blokirlengi.
Bar bolan blokirlemäni [[Special:GlobalBlockList|global blokirleme sanawynda]] görüp bilersiňiz,
ýa-da bu formy gaýtadan ibermek arkaly bar bolan blokirlemäniň sazlamalryny üýtgedip bilersiňiz.',
	'globalblocking-block-bigrange' => 'Görkezen aralygyňyz ($1) blokirlärden has uly. 
Köp bolanda 65.536 adresi (/16 aralygy) blokirläp bilersiňiz',
	'globalblocking-list-intro' => 'Bu sanaw häzirki wagtda güýjüni saklaýan ähli global blokirlemeleri görkezýär. 
Käbir blokirlemeler ýerli tertipde ýapyk diýlip bellenilýär: munuň manysy şeýle, blokirleme başga saýtlarda ýöreýär, emma bir ýerli administrator ony bu wikide ýapmaly diýen netije gelipdir.',
	'globalblocking-list' => 'Global blokirlenen IP adresleriniň sanawy',
	'globalblocking-search-legend' => 'Global blokirleme gözle',
	'globalblocking-search-ip' => 'IP adresi:',
	'globalblocking-search-submit' => 'Blokirlemeleri gözle',
	'globalblocking-list-ipinvalid' => 'Gözlän IP adresiňiz ($1) nädogry.
Dogry IP adresi ýazyň.',
	'globalblocking-search-errors' => 'Gözlegiňiz şowsuz, şu {{PLURAL:$1|sebäp|sebäpler}} zerarly:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3''), [[Special:Contributions/\$4|\$4]] ulanyjysyny global blokirledi ''(\$5)''",
	'globalblocking-list-expiry' => 'gutarýar $1',
	'globalblocking-list-anononly' => 'diňe anonim',
	'globalblocking-list-unblock' => 'aýyr',
	'globalblocking-list-whitelisted' => '$1 tarapyndan ýerli tertipde ýapyldy: $2',
	'globalblocking-list-whitelist' => 'ýerli status',
	'globalblocking-list-modify' => 'üýtget',
	'globalblocking-list-noresults' => 'Talap edilýän IP adresi blokirlenmedik.',
	'globalblocking-goto-block' => 'IP adresini global blokirle',
	'globalblocking-goto-unblock' => 'Global blokirlemäni aýyr',
	'globalblocking-goto-status' => 'Global blokirlemäniň ýerli statusyny üýtget',
	'globalblocking-return' => 'Global blokirlemeleriň sanawyna gaýdyp bar',
	'globalblocking-notblocked' => 'Ýazan IP adresiňiz ($1) global blokirlenmedik.',
	'globalblocking-unblock' => 'Global blokirlemäni aýyr',
	'globalblocking-unblock-ipinvalid' => 'Ýazan IP adresiňiz ($1) nädogry.
Ulanyjy adyny ýazmak bolýan däldir!',
	'globalblocking-unblock-legend' => 'Global blokirlemäni aýyr',
	'globalblocking-unblock-submit' => 'Global blokirlemäni aýyr',
	'globalblocking-unblock-reason' => 'Sebäp:',
	'globalblocking-unblock-unblocked' => "'''$1''' IP adresindäki #$2 global blokirlemesini şowly aýyrdyňyz",
	'globalblocking-unblock-errors' => 'Global blokirlmäni aýyrmagyňyz şowsuz, şu {{PLURAL:$1|sebäp|sebäpler}} zerarly:',
	'globalblocking-unblock-successsub' => 'Global blokirleme şowly aýyryldy',
	'globalblocking-unblock-subtitle' => 'Global blokirleme aýyrylýar',
	'globalblocking-unblock-intro' => 'Bu formy global blokirleme aýyrmak üçin ulanyp bilersiňiz.',
	'globalblocking-whitelist' => 'Global blokirlemeleriň ýerli statusy',
	'globalblocking-whitelist-notapplied' => 'Global blokirlemeler bu wikide berjaý edilmeýär,
şol sebäpli global blokirlemeleriň ýerli statusyny üýtgedip bolmaýar.',
	'globalblocking-whitelist-legend' => 'Ýerli statusy üýtget',
	'globalblocking-whitelist-reason' => 'Sebäp:',
	'globalblocking-whitelist-status' => 'Ýerli status:',
	'globalblocking-whitelist-statuslabel' => 'Bu global blokirlemäni {{SITENAME}} saýtynda ýap',
	'globalblocking-whitelist-submit' => 'Ýerli statusy üýtget',
	'globalblocking-whitelist-whitelisted' => "{{SITENAME}} saýtynda '''$1''' IP adresli #$2 global blokirlemesini şowly ýapdyňyz.",
	'globalblocking-whitelist-dewhitelisted' => "{{SITENAME}} saýtynda '''$1''' IP adresli #$2 global blokirlemesini şowly gaýtadan açdyňyz.",
	'globalblocking-whitelist-successsub' => 'Ýerli status şowly üýtgedildi',
	'globalblocking-whitelist-nochange' => 'Bu blokirlemäni ýerli statusyny him hili üýtgetmediňiz.
[[Special:GlobalBlockList|Global blokirleme sanawyna gaýdyp baryň]].',
	'globalblocking-whitelist-errors' => 'Global blokirlemäniň ýerli statusyndaky üýtgeşmäňiz şowsuz, şu {{PLURAL:$1|sebäp|sebäpler}} zerarly:',
	'globalblocking-whitelist-intro' => 'Global blokirlemäniň ýerli statusyny üýtgetmek üçin bu formdan peýdalanyp bilersiňiz. 
eger global blokirleme bu wikide ýapylyp goýlan bolsa, degişli IP adresindäki ulanyjylar adatça redaktirläp bilýärler. 
[[Special:GlobalBlockList|Global blokirleme sanawyna gaýdyp baryň]].',
	'globalblocking-blocked' => "IP adresiňiz '''\$1''' (''\$2'') tarapyndan ähli wikilerde blokirlendi.
Görkezilen sebäp: ''\"\$3\"''.
Blokirleme ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Ulanyjynyň parolyny başky ýagdaýa getirip bilmeýärsiňiz, sebäbi siz global blokirlenilgi.',
	'globalblocking-logpage' => 'Global blokirleme gündeligi',
	'globalblocking-logpagetext' => 'Bu gündelik şu wikide goýulan we ondan aýrylan global blokirlemeleri görkezýär. 
Global blokirlemeler başga wikilerde goýlup we aýrylyp bilinýändir, şol blokirlemeler bolsa şu wikä-de täsirini ýetirip bilýändir. 
Ähli işjeň global blokirlemeleri görmek üçin, [[Special:GlobalBlockList|global blokirleme sanawyna]] seredip bilersiňiz.',
	'globalblocking-block-logentry' => '[[$1]], $2 gutaryş wagty bilen global blokirlendi',
	'globalblocking-block2-logentry' => 'global blokirlendi [[$1]] ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] üçin global blokirleme aýyryldy',
	'globalblocking-whitelist-logentry' => '[[$1]] üçin global blokirleme ýerli tertipde ýapyldy',
	'globalblocking-dewhitelist-logentry' => '[[$1]] üçin global blokirleme ýerli tertipde gaýtadan açyldy',
	'globalblocking-modify-logentry' => '[[$1]] ($2) üçin global blokirlemäni üýtgetdi',
	'globalblocking-logentry-expiry' => 'gutarýar $1',
	'globalblocking-logentry-noexpiry' => 'gutaryş möhleti goýulmady',
	'globalblocking-loglink' => '$1 IP adresi global blokirlendi ([[{{#Special:GlobalBlockList}}/$1|ähli jikme-jikler]]).',
	'globalblocking-showlog' => 'Bu IP adresi ozaldan blokirlenipdir.
Blokirleme gündeligi salgylanmak üçin aşakda berilýär:',
	'globalblocklist' => 'Global blokirlenen IP adresleriniň sanawy',
	'globalblock' => 'IP adresini global blokirle',
	'globalblockstatus' => 'Global blokirlemeleriň ýerli statusy',
	'removeglobalblock' => 'Global blokirlemäni aýyr',
	'right-globalblock' => 'Global blokirleme ediň',
	'right-globalunblock' => 'Global blokirlemeleri aýyr',
	'right-globalblock-whitelist' => 'Global blokirlemeleri ýerli tertipde ýap',
	'right-globalblock-exempt' => 'Global blokirlemelerden aýlanyp geç',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Nagpapahintulot]] na [[Special:GlobalBlockList|mahadlangan/maharang sa kahabaan ng maraming mga wiki]] ang mga adres ng IP',
	'globalblocking-block' => 'Pandaigdigang harangin/hadlangan ang isang adres ng IP',
	'globalblocking-modify-intro' => 'Magagamit mo ang pormularyong ito upang baguhin ang mga pagtatakda ng isang pandaigdigang paghadlang.',
	'globalblocking-block-intro' => 'Magagamit mo ang pahinang ito para hadlangan/harangin ang isang adres ng IP sa lahat ng mga wiki.',
	'globalblocking-block-reason' => 'Dahilan:',
	'globalblocking-block-otherreason' => 'Iba pa/dagdag na dahilan:',
	'globalblocking-block-reasonotherlist' => 'Ibang dahilan',
	'globalblocking-block-reason-dropdown' => '* Karaniwang mga dahilan ng paghadlang
** Panglulusob na tumatawid ng wiki
** Pang-aabusong tumatawid ng wiki
** Pambababoy',
	'globalblocking-block-edit-dropdown' => 'Baguhin ang mga dahilan sa pagharang',
	'globalblocking-block-expiry' => 'Katapusan:',
	'globalblocking-block-expiry-other' => 'Ibang oras/panahon ng pagtatapos',
	'globalblocking-block-expiry-otherfield' => 'Ibang oras/panahon:',
	'globalblocking-block-legend' => 'Pandaigdigang harangin ang isang adres ng IP',
	'globalblocking-block-options' => 'Mga pagpipilian:',
	'globalblocking-block-errors' => 'Hindi nagtagumpay ang pagharang/paghadlang mo, dahil sa sumusunod na mga {{PLURAL:$1|dahilan|mga dahilan}}:',
	'globalblocking-block-ipinvalid' => 'Hindi tanggap ang ipinasok mong adres ng IP ($1).
Pakitaandaang hindi mo maipapasok ang isang pangalan ng tagagamit!',
	'globalblocking-block-expiryinvalid' => 'Hindi tanggap ang ipinasok ($1) mong panahon ng pagtatapos.',
	'globalblocking-block-submit' => 'Pandaigdigang hadlangan ang adres ng IP na ito',
	'globalblocking-modify-submit' => 'Baguhin ang pandaigdigang paghadlang na ito',
	'globalblocking-block-success' => 'Matagumpay na nahadlangan ang adres ng IP na $1 sa lahat ng mga proyekto.',
	'globalblocking-modify-success' => 'Ang pandaigdigang paghadlang sa $1 ay matagumpay na nabago',
	'globalblocking-block-successsub' => 'Matagumpay ang pagharang na pandaigdigan',
	'globalblocking-modify-successsub' => 'Matagumpay na nabago ang pandaigdigang paghadlang',
	'globalblocking-block-alreadyblocked' => 'Pandaigdigang hinahadlangan na ang adress ng IP na $1.
Matitingnan mo ang umiiral na paghadlang sa [[Special:GlobalBlockList|talaan ng mga pandaigdigang paghadlang]],
o baguhin ang mga pagtatakda ng umiiral na paghadlang sa pamamagitan ng muling pagpapasa ng pormularyong ito.',
	'globalblocking-block-bigrange' => 'Ang saklaw na tinukoy ($1) mo ay napakalaki para hadlangan.
Maaari kang mangharang, sa pinakamarami, ng 65,536 mga adres (/16 sakop)',
	'globalblocking-list-intro' => 'Talaan ito ng lahat ng mga pangkasalukuyang umiiral na pandaigdigang mga paghadlang. 
May ilang mga pagharang na tinatakan bilang hinadlangan sa iisang pook (lokal) lamang: nangangahulugang umiiral din ang mga ito sa iba pang mga sayt/sityo, subalit may isang katutubong tagapangasiwang nagpasya na huwag paganahin ang mga ito sa wiking ito.',
	'globalblocking-list' => 'Talaan ng mga adres ng IP na may pandaigdigang pagkakaharang',
	'globalblocking-search-legend' => 'Maghanap ng isang pandaigdigang pagharang',
	'globalblocking-search-ip' => 'Adres ng IP:',
	'globalblocking-search-submit' => 'Maghanap ng mga pagharang/paghadlang',
	'globalblocking-list-ipinvalid' => 'Hindi tanggap ang hinanap mong ($1) adres ng IP. 
Pakipasok ang isang naaangkop na adres ng IP.',
	'globalblocking-search-errors' => 'Hindi matagumapay ang iyong paghahanap, dahil sa sumusunod na {{PLURAL:$1|dahilan|mga dahilan}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') pandaigdigang hinarang/hinadlangan si [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'katapusan $1',
	'globalblocking-list-anononly' => 'hindi nagpapakilala lamang',
	'globalblocking-list-unblock' => 'tanggalin',
	'globalblocking-list-whitelisted' => 'hindi pinaandar na pangmalawakan (pampook lamang) ni $1: $2',
	'globalblocking-list-whitelist' => 'katutubong kalagayan',
	'globalblocking-list-modify' => 'baguhin',
	'globalblocking-list-noresults' => 'Hindi hinaharangan ang hiniling na adres ng IP.',
	'globalblocking-goto-block' => 'Pandaigdigang hadlangan/harangin ang isang adres ng IP',
	'globalblocking-goto-unblock' => 'Tanggalin ang isang paghahadlang na pandaigdigan',
	'globalblocking-goto-status' => 'Baguhin ang kalagayang pampook (lokal) para sa isang pagharang/paghadlang',
	'globalblocking-return' => 'Bumalik sa talaan ng mga pandaigdigang paghaharang/paghahadlang',
	'globalblocking-notblocked' => 'Hindi hinarang/hinadlangang pandaigdigan ang ipinasok mong adres ng IP ($1)',
	'globalblocking-unblock' => 'Tanggalin ang isang pandaigdigang paghahadlang',
	'globalblocking-unblock-ipinvalid' => 'Hindi tanggap ang ipinasok mong adres ng IP ($1).
Pakitandaang hindi mo maaaring ipasok ang isang pangalan ng tagagamit!',
	'globalblocking-unblock-legend' => 'Tanggalin ang isang pandaigdigang pagharang',
	'globalblocking-unblock-submit' => 'Tanggalin ang pandaigdigang paghadlang',
	'globalblocking-unblock-reason' => 'Dahilan:',
	'globalblocking-unblock-unblocked' => "Matagumpay mong natanggal ang pandaigdigang pagharang/paghahadlang na #$2 para sa adres ng IP na '''$1'''",
	'globalblocking-unblock-errors' => 'Hindi matagumpay ang pagtatanggal mong pandaigdigang pagharang/paghahadlang, dahil sa sumusunod na {{PLURAL:$1|dahilan|mga dahilan}}:',
	'globalblocking-unblock-successsub' => 'Matagumpay na natanggal ang pandaigdigang pagharang/paghadlang',
	'globalblocking-unblock-subtitle' => 'Tinatanggal ang pandaigdigang pagharang/paghadlang',
	'globalblocking-unblock-intro' => 'Magagamit mo ang pormularyong ito upang tanggalin ang isang pandaigdigang pagharang/paghadlang.',
	'globalblocking-whitelist' => 'Katutubo o lokal na kalagayan ng mga pandaigdigang paghadlang',
	'globalblocking-whitelist-notapplied' => "Ang pandaigdigang paghadlang ay hindi ginagamit sa wiking ito,
kaya't hindi mababago ang pampook na kalagayan ng pandaigdigang mga paghadlang.",
	'globalblocking-whitelist-legend' => 'Baguhin ang katutubo o lokal na kalagayan',
	'globalblocking-whitelist-reason' => 'Dahilan:',
	'globalblocking-whitelist-status' => 'Katutubong kalagayan:',
	'globalblocking-whitelist-statuslabel' => 'Huwag paganahin ang pandaigdigang paghadlang/pagharang na ito sa {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Baguhin ang kalagayang pampook (lokal)',
	'globalblocking-whitelist-whitelisted' => "Matagumpay mong napawalan ng bisa ng pandaigdigang pagharang/paghadlang na #$2 sa adres ng IP na '''$1''' na nasa {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Matagumpay mong muling-binuhay (pinagana uli) ang pandaigdigang pagharang na #$2 sa adres ng IP na '''$1''' na nasa {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Matagumpay na nabago ang katutubong kalagayan',
	'globalblocking-whitelist-nochange' => 'Wala kang ginawang pagbabago para sa katutubong kalagayan ng paghadlang na ito.
[[Special:GlobalBlockList|Magbalik sa talaan ng mga pandaigdigang pagharang]].',
	'globalblocking-whitelist-errors' => 'Hindi matagumpay ang pagbabagong ginawa mo sa katutubong kalagayan ng isang pandaigdigang pagharang, dahil sa sumusunod na {{PLURAL:$1|dahilan|mga dahilan}}:',
	'globalblocking-whitelist-intro' => 'Magagamit mo ang pormularyong ito para magbago ng katutubong kalagayan ng isang pandaigdigang pagharang.
Kapag hindi pinagana ang isang pandaigdigang paghadlang sa wiking ito, maaaring mamatnugot sa karaniwang paraan ang mga tatagamit na nasa loob ng apektadong adres ng IP.
[[Special:GlobalBlockList|Bumalik sa talaan ng mga pandaigdigang pagharang]]',
	'globalblocking-blocked' => "Hinadlangan ni '''\$1''' (''\$2'') ang adres ng IP mo sa lahat ng mga wiki. 
Ang ibinigay na dahilan ay ''\"\$3\"''.
Ang pagharang ay ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Hindi mo maaaring itakdang muli ang hudyat ng tagagamit dahil pandaigdigan kang hinarang.',
	'globalblocking-logpage' => 'Talaan ng pandaigdigang pagharang/paghadlang',
	'globalblocking-logpagetext' => 'Isa itong talaan ng mga pandaigdigang pagharang na isinagawa at tinanggal mula sa wiking ito.
Dapat tandaan na maaaring gawin ang pandaigdigang mga paghadlang at alisin mula sa iba pang mga wiki, at maaaring makaapekto sa wiking ito ang ganitong mga pandaigdigang pagharang.
Para matanaw ang lahat ng mga masigla o gumaganang pandaigdigang mga paghadlang, maaari mong tingnan ang [[Special:GlobalBlockList|talaan ng mga pandaigdigang pagharang]].',
	'globalblocking-block-logentry' => 'Pandaigdigang hinarang/hinadlangan ang [[$1]] na may panahon o oras ng pagtatapos na $2',
	'globalblocking-block2-logentry' => 'pandaigdigang hinadlangan si [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'tinanggal ang pandaigdigang pagharang sa/kay [[$1]]',
	'globalblocking-whitelist-logentry' => 'hindi pinagana/pinaandar sa katutubo o lokal na pook ang pandaigdigang pagharang o paghadlang sa/kay [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'Muling binuhay/pinagana sa katutubong (lokal na) pook ang pandaigdigang pagharang o paghadlang sa/kay [[$1]]',
	'globalblocking-modify-logentry' => 'binago ang pandaigdigang paghadlang sa [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'magtatapos sa $1',
	'globalblocking-logentry-noexpiry' => 'walang katapusang nakatakda',
	'globalblocking-loglink' => 'Ang adres ng IP na $1 ay pandaigdigang hinadlangang ([[{{#Special:GlobalBlockList}}/$1|buong mga detalye]]).',
	'globalblocking-showlog' => 'Dati nang naharang ang adres ng IP na ito.
Ibinigay sa ibaba ang talaan ng paghadlang upang masangguni:',
	'globalblocklist' => 'Talaan ng mga adres ng IP na may pandaigdigang paghadlang/pagharang',
	'globalblock' => 'Pandaigdigang harangin/hadlangan ang isang adres ng IP',
	'globalblockstatus' => 'Katutubo/lokal na kalagayan ng mga paghadlang/pagharang na pandaigdigan',
	'removeglobalblock' => 'Tanggalin ang isang pandaigdigang paghahadlang',
	'right-globalblock' => 'Gumawa ng pandaigdigang mga pagharang',
	'right-globalunblock' => 'Tanggalin ang mga pandaigdigang paghahadlang',
	'right-globalblock-whitelist' => 'Pampook (lokal) lamang na hindi paganahin/huwag paandarin ang mga pandaigdigang pagharang',
	'right-globalblock-exempt' => 'Laktawan ang mga pagharang na pandaigdigan',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Homonihilis
 * @author Joseph
 * @author Runningfridgesrule
 * @author Suelnur
 */
$messages['tr'] = array(
	'globalblocking-desc' => 'IP addreslerinin [[Special:GlobalBlockList|çoklu vikiler boyunca engellenmesine]] [[Special:GlobalBlock|izin verir]]',
	'globalblocking-block' => 'Bir IP adresini küresel olarak engelle',
	'globalblocking-modify-intro' => 'Bir küresel engellemenin ayarlarını değiştirmek için bu formu kullanabilirsiniz.',
	'globalblocking-block-intro' => 'Bu sayfayı, bir IP adresini tüm vikilerde engellemek için kullanabilirsiniz.',
	'globalblocking-block-reason' => 'Sebep:',
	'globalblocking-block-otherreason' => 'Diğer/Ek sebepler:',
	'globalblocking-block-reasonotherlist' => 'Diğer sebepler',
	'globalblocking-block-reason-dropdown' => '* Genel engelleme sebepleri
** Çaprazviki spam
** Çaprazviki suistimali
** Vandallık',
	'globalblocking-block-edit-dropdown' => 'Engelleme sebeplerini değiştirin',
	'globalblocking-block-expiry' => 'Bitiş:',
	'globalblocking-block-expiry-other' => 'Diğer bitiş zamanı',
	'globalblocking-block-expiry-otherfield' => 'Diğer zaman:',
	'globalblocking-block-legend' => 'Bir IP adresini küresel olarak engelle',
	'globalblocking-block-options' => 'Seçenekler:',
	'globalblocking-ipaddress' => 'IP adresi:',
	'globalblocking-block-errors' => 'Engelleme başarısız, şu {{PLURAL:$1|sebepten|sebeplerden}} dolayı:',
	'globalblocking-block-ipinvalid' => 'Girdiğiniz IP addresi ($1) geçersiz.
Lütfen bir kullanıcı adı giremeyeceğinizi unutmayın!',
	'globalblocking-block-expiryinvalid' => 'Girdiğiniz bitiş ($1) geçersiz.',
	'globalblocking-block-submit' => 'Bu IP adresini küresel olarak engelle',
	'globalblocking-modify-submit' => 'Bu küresel engellemeyi değiştir',
	'globalblocking-block-success' => '$1 IP adresi bütün projelerde başarıyla engellendi.',
	'globalblocking-modify-success' => '$1 üzerindeki küresel engelleme başarıyla değiştirildi',
	'globalblocking-block-successsub' => 'Küresel engelleme başarılı',
	'globalblocking-modify-successsub' => 'Küresel engelleme başarıyla değiştirildi',
	'globalblocking-block-alreadyblocked' => '$1 IP adresi zaten küresel olarak engelli.
Mevcut engellemeyi [[Special:GlobalBlockList|küresel engelleme listesinde]] görebilirsiniz,
ya da bu formu tekrar göndererek mevcut engellemenin ayarlarını değiştirebilirsiniz.',
	'globalblocking-block-bigrange' => 'Belirttiğiniz aralık ($1) engellemek için çok büyük.
En fazla 65.536 adresi (/16 aralık) engelleyebilirsiniz',
	'globalblocking-list-intro' => 'Bu liste şu anda etkin olan tüm küresel engellemelerin listesidir.
Bazı engellemeler yerel olarak devre dışı işaretlenmiş: bu şu demektir, engelleme diğer sitelerde etkilidir, fakat bir yerel yönetici onları bu vikide devre dışı bırakmaya karar vermiştir.',
	'globalblocking-list' => 'Küresel olarak erişimi durdurulmuş IP adresleri listesi',
	'globalblocking-search-legend' => 'Bir küresel engelleme ara',
	'globalblocking-search-ip' => 'IP adresi:',
	'globalblocking-search-submit' => 'Engellemeleri ara',
	'globalblocking-list-ipinvalid' => 'Aradığınız IP adresi ($1) geçersiz.
Lütfen geçerli bir IP adresi girin.',
	'globalblocking-search-errors' => 'Aramanız başarısız, şu {{PLURAL:$1|sebepten|sebeplerden}} dolayı:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3''), [[Special:Contributions/\$4|\$4]] kullanıcısını küresel olarak engelledi ''(\$5)''",
	'globalblocking-list-expiry' => 'bitiş $1',
	'globalblocking-list-anononly' => 'sadece anonim',
	'globalblocking-list-unblock' => 'kaldır',
	'globalblocking-list-whitelisted' => '$1 tarafından yerel olarak etkisizleştirildi: $2',
	'globalblocking-list-whitelist' => 'yerel durum',
	'globalblocking-list-modify' => 'değiştir',
	'globalblocking-list-noresults' => 'İstenen IP adresi engellenmedi.',
	'globalblocking-goto-block' => 'Bir IP adresini küresel olarak engelle',
	'globalblocking-goto-unblock' => 'Küresel bir engellemeyi kaldır',
	'globalblocking-goto-status' => 'Küresel bir engelleme için yerel durumu değiştir',
	'globalblocking-return' => 'Küresel engellemeler listesine geri dön',
	'globalblocking-notblocked' => 'Girdiğiniz IP adresi ($1) küresel olarak engelli değil.',
	'globalblocking-unblock' => 'Küresel bir engellemeyi kaldır',
	'globalblocking-unblock-ipinvalid' => 'Girdiğiniz IP addresi ($1) geçersiz.
Lütfen bir kullanıcı adı giremeyeceğinizi unutmayın!',
	'globalblocking-unblock-legend' => 'Küresel bir engellemeyi kaldır',
	'globalblocking-unblock-submit' => 'Küresel engellemeyi kaldır',
	'globalblocking-unblock-reason' => 'Neden:',
	'globalblocking-unblock-unblocked' => "'''$1''' IP adresindeki #$2 küresel engellemesini başarıyla kaldırdınız",
	'globalblocking-unblock-errors' => 'Küresel engelleme kaldırmanız başarısız, şu {{PLURAL:$1|sebepten|sebeplerden}} dolayı:',
	'globalblocking-unblock-successsub' => 'Küresel engelleme başarıyla kaldırıldı',
	'globalblocking-unblock-subtitle' => 'Küresel engelleme kaldırılıyor',
	'globalblocking-unblock-intro' => 'Bu formu küresel bir engellemeyi kaldırmak için kullanabilirsiniz.',
	'globalblocking-whitelist' => 'Küresel engellemelerin yerel durumları',
	'globalblocking-whitelist-notapplied' => 'Küresel engellemeler bu vikide uygulanmıyor,
bu yüzden küresel engellemelerin yerel durumu değiştirilemez.',
	'globalblocking-whitelist-legend' => 'Yerel durumu değiştir',
	'globalblocking-whitelist-reason' => 'Sebep:',
	'globalblocking-whitelist-status' => 'Yerel durum:',
	'globalblocking-whitelist-statuslabel' => 'Bu küresel engellemeyi {{SITENAME}} sitesinde devre dışı bırak',
	'globalblocking-whitelist-submit' => 'Yerel durumu değiştir',
	'globalblocking-whitelist-whitelisted' => "{{SITENAME}} sitesinde '''$1''' IP addresli #$2 küresel engellemesini başarıyla devre dışı bıraktınız.",
	'globalblocking-whitelist-dewhitelisted' => "{{SITENAME}} sitesinde '''$1''' IP addresli #$2 küresel engellemesini başarıyla tekrar devreye soktunuz.",
	'globalblocking-whitelist-successsub' => 'Yerel durum başarıyla değiştirildi',
	'globalblocking-whitelist-nochange' => 'Bu engellemenin yerel durumuna hiçbir değişiklik yapmadınız.
[[Special:GlobalBlockList|Küresel engelleme listesine geri dönün]].',
	'globalblocking-whitelist-errors' => 'Küresel engellemenin yerel durumuna yaptığınız değişiklik başarısız oldu, şu {{PLURAL:$1|sebepten|sebeplerden}} dolayı:',
	'globalblocking-whitelist-intro' => 'Küresel bir engellemenin yerel durumunu değiştirmek için bu formu kullanabilirsiniz.
Eğer bir küresel engelleme bu vikide devre dışı bırakılmış ise, etkilenen IP adresindeki kullanıcılar normal olarak değişiklik yapabilecektir.
[[Special:GlobalBlockList|Küresel engelleme listesine geri dönün]].',
	'globalblocking-blocked' => "IP adresiniz '''\$1''' (''\$2'') tarafından tüm vikilerde engellendi.
Verilen sebep şu: ''\"\$3\"''.
Engelleme ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Küresel olarak engellenmiş olduğunuz için kullanıcının şifresini sıfırlayamazsınız.',
	'globalblocking-logpage' => 'Küresel engelleme günlüğü',
	'globalblocking-logpagetext' => 'Bu, bu vikide yapılan ve kaldırılan küresel engellemelerin günlüğüdür.
Küresel engellemelerin diğer vikilerde yapılıp kaldırılabileceğini, ve bu küresel engellemelerin bu vikiyi etkileyebileceğini unutmayın.
Tüm aktif küresel engellemeri görmek için, [[Special:GlobalBlockList|küresel engelleme listesine]] bakabilirsiniz.',
	'globalblocking-block-logentry' => '[[$1]], $2 bitiş zamanı ile küresel olarak engellendi',
	'globalblocking-block2-logentry' => 'küresel olarak engelledi [[$1]] ($2)',
	'globalblocking-unblock-logentry' => '[[$1]] için küresel engelleme kaldırıldı',
	'globalblocking-whitelist-logentry' => '[[$1]] için küresel engelleme yerel olarak devre dışı bırakıldı',
	'globalblocking-dewhitelist-logentry' => '[[$1]] için küresel engelleme yerel olarak tekrar devreye sokuldu',
	'globalblocking-modify-logentry' => '[[$1]] ($2) üzerinde küresel engellemeyi değiştirdi',
	'globalblocking-logentry-expiry' => '$1 tarihinde bitiyor',
	'globalblocking-logentry-noexpiry' => 'bitiş tarihi ayarlanmadı',
	'globalblocking-loglink' => 'IP adresi $1 küresel olarak engellenmiş ([[{{#Special:GlobalBlockList}}/$1|tüm ayrıntılar]]).',
	'globalblocking-showlog' => 'Bu IP adresi daha önce engellenmiş.
Engelleme günlüğü referans için aşağıda verilmiştir:',
	'globalblocklist' => 'Küresel olarak engellenmiş IP adresleri listesi',
	'globalblock' => 'Bir IP adresini küresel olarak engelle',
	'globalblockstatus' => 'Küresel engellemelerin yerel durumları',
	'removeglobalblock' => 'Küresel bir engelleme kaldırıldı',
	'right-globalblock' => 'Küresel engellemeler yap',
	'right-globalunblock' => 'Küresel engellemeleri kaldır',
	'right-globalblock-whitelist' => 'Küresel engellemeleri yerel olarak devre dışı bırak',
	'right-globalblock-exempt' => 'Küresel engellemeleri atla',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'globalblocking-list' => 'Гомум чикләнгән IP-юлламалар исемлеге',
	'globalblocking-search-legend' => 'Гомум чикләүне эзләү',
	'globalblocking-search-ip' => 'IP юлламасы:',
	'globalblocking-search-submit' => 'Чикләүләрне эзләү',
	'globalblocking-whitelist' => 'Гомум чикләүләрнең җирле халәте',
	'globalblocking-whitelist-notapplied' => 'Әлеге викида гомум чикләүләр кулланылмый,
шуңа күрә гомум чикләүләрнең җирле халәтләрен үзгәртү мөмкин түгел.',
	'globalblocking-whitelist-legend' => 'Җирле халәтне үзгәртү',
	'globalblocking-whitelist-reason' => 'Сәбәп:',
	'globalblocking-whitelist-status' => 'Җирле халәт:',
	'globalblocking-whitelist-statuslabel' => 'Әлеге гомум чикләүне {{grammar:genitive|{{SITENAME}}}} проектында сүндерү',
	'globalblocking-whitelist-submit' => 'Җирле халәтне үзгәртү',
	'globalblocking-whitelist-whitelisted' => "{{grammar:genitive|{{SITENAME}}}} проектында IP-юлламасы '''$1''' кулланучы исеме  #$2 булган кулланучының гомум чикләүләрен сүндерү уңышлы үтте.",
	'globalblocking-whitelist-dewhitelisted' => "{{grammar:genitive|{{SITENAME}}}} проектында IP-юлламасы - '''$1''' кулланучы исеме - #$2 булган кулланучының гомум чикләүләрен яңадан билгеләү уңышлы үтте.",
	'globalblocking-whitelist-successsub' => 'Җирле халәтне үзгәртү уңышлы үтте.',
);

/** Tuvinian (Тыва дыл)
 * @author Sborsody
 */
$messages['tyv'] = array(
	'globalblocking-block-reason' => 'Чылдагаан:',
	'globalblocking-unblock-reason' => 'Чылдагаан:',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Dim Grits
 * @author NickK
 * @author Prima klasy4na
 * @author Sodmy
 */
$messages['uk'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Дозволяє]] блокування IP-адрес [[Special:GlobalBlockList|на кількох вікі]]',
	'globalblocking-block' => 'Глобальне блокування IP-адреси',
	'globalblocking-modify-intro' => 'Ви можете використати цю форму для зміни параметрів глобального блокування.',
	'globalblocking-block-intro' => 'За допомогою цієї сторінки ви можете заблокувати IP-адресу в усіх вікі.',
	'globalblocking-block-reason' => 'Причина:',
	'globalblocking-block-otherreason' => 'Інша/додаткова причина:',
	'globalblocking-block-reasonotherlist' => 'Інша причина',
	'globalblocking-block-reason-dropdown' => '* Загальні причини блокування
** Спам на різних вікі
** Зловживання на різних вікі
** Вандалізм',
	'globalblocking-block-edit-dropdown' => 'Редагувати причини блокувань',
	'globalblocking-block-expiry' => 'Закінчення:',
	'globalblocking-block-expiry-other' => 'Інший час завершення',
	'globalblocking-block-expiry-otherfield' => 'Інший час:',
	'globalblocking-block-legend' => 'Глобальне блокування IP-адреси',
	'globalblocking-block-options' => 'Налаштування:',
	'globalblocking-ipaddress' => 'IP-адреса:',
	'globalblocking-ipbanononly' => 'Блокувати тільки анонімних користувачів',
	'globalblocking-block-errors' => 'Спроба блокування не вдалася через {{PLURAL:$1|наступну причину|наступні причини}}:',
	'globalblocking-block-ipinvalid' => "Уведена вами IP-адреса ($1) неправильна.
Зверніть увагу, що ви не можете вводити ім'я користувача!",
	'globalblocking-block-expiryinvalid' => 'Уведений час завершення ($1) неправильний.',
	'globalblocking-block-submit' => 'Заблокувати цю IP-адресу глобально',
	'globalblocking-modify-submit' => 'Змінити це глобальне блокування',
	'globalblocking-block-success' => 'IP-адреса $1 була успішно заблокована в усіх проектах.',
	'globalblocking-modify-success' => 'Глобальне блокування $1 успішно змінене',
	'globalblocking-block-successsub' => 'Глобальне блокування пройшло успішно.',
	'globalblocking-modify-successsub' => 'Глобальне блокування успішно змінено',
	'globalblocking-block-alreadyblocked' => 'IP-адреса $1 вже є глобально заблокованою.
Ви можете переглянути поточні блокування у [[Special:GlobalBlockList|списку глобальних блокувань]] або змінити параметри поточного блокування, повторно відправивши цю форму.',
	'globalblocking-block-bigrange' => 'Зазначений вами діапазон ($1) завеликий для блокування.
Ви можете заблокувати щонайбільше 65 536 адрес (діапазон /16)',
	'globalblocking-list-intro' => 'Це список усіх наявних глобальних блокувань.
Деякі блокування відзначені як вимкнені локально, тобто в деяких вікі адміністратор вирішив відключити блокування локально.',
	'globalblocking-list' => 'Список глобально заблокованих IP-адрес',
	'globalblocking-search-legend' => 'Пошук глобального блокування',
	'globalblocking-search-ip' => 'IP-адреса:',
	'globalblocking-search-submit' => 'Знайти блокування',
	'globalblocking-list-ipinvalid' => 'IP-адреса ($1), яку ви ввели, неправильна.
Будь ласка, введіть правильну IP-адресу.',
	'globalblocking-search-errors' => 'Ваш пошук був невдалим. {{PLURAL:$1|Причина|Причини}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') глобально заблокував [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'закінчується $1',
	'globalblocking-list-anononly' => 'тільки анонімів',
	'globalblocking-list-unblock' => 'розблокувати',
	'globalblocking-list-whitelisted' => 'локально відключив $1: $2',
	'globalblocking-list-whitelist' => 'локальний стан',
	'globalblocking-list-modify' => 'змінити',
	'globalblocking-list-noresults' => 'Зазначена IP-адреса не заблокована.',
	'globalblocking-goto-block' => 'Заблокувати IP-адресу глобально',
	'globalblocking-goto-unblock' => 'Зняти глобальне блокування',
	'globalblocking-goto-status' => 'Змінити локальний стан глобального блокування',
	'globalblocking-return' => 'Повернутися до списку глобальних блокувань',
	'globalblocking-notblocked' => 'IP-адреса, яку ви ввели ($1) не є глобально заблокованою.',
	'globalblocking-unblock' => 'Зняти глобальне блокування',
	'globalblocking-unblock-ipinvalid' => "IP-адреса, яку ви ввели ($1) є помилковою.
Будь ласка, зверніть увагу, що ви не можете вводити ім'я користувача!",
	'globalblocking-unblock-legend' => 'Зняття глобального блокування',
	'globalblocking-unblock-submit' => 'Зняти глобальне блокування',
	'globalblocking-unblock-reason' => 'Причина:',
	'globalblocking-unblock-unblocked' => "Ви успішно зняли глобальне блокування #$2 з IP-адреси '''$1'''",
	'globalblocking-unblock-errors' => 'Спроба зняти глобальне блокування не вдалася. {{PLURAL:$1|Причина|Причини}}:',
	'globalblocking-unblock-successsub' => 'Глобальне блокування успішно зняте',
	'globalblocking-unblock-subtitle' => 'Зняття глобального блокування',
	'globalblocking-unblock-intro' => 'Ви можете використовувати цю форму для зняття глобального блокування.',
	'globalblocking-whitelist' => 'Локальний стан глобальних блокувань',
	'globalblocking-whitelist-notapplied' => 'Глобальні блокування не застосовуються в цій вікі,
тому локальний статус глобальних блокувань не може бути змінений.',
	'globalblocking-whitelist-legend' => 'Зміна локального стану',
	'globalblocking-whitelist-reason' => 'Причина:',
	'globalblocking-whitelist-status' => 'Локальний стан:',
	'globalblocking-whitelist-statuslabel' => 'Відключити це глобальне блокування в {{grammar:genitive|{{SITENAME}}}}',
	'globalblocking-whitelist-submit' => 'Змінити локальний стан',
	'globalblocking-whitelist-whitelisted' => "Ви успішно відключили глобальне блокування #$2 IP-адреси '''$1''' в {{grammar:genitive|{{SITENAME}}}}",
	'globalblocking-whitelist-dewhitelisted' => "Ви успішно відновили глобальне блокування #$2 IP-адреси '''$1''' в {{grammar:genitive|{{SITENAME}}}}",
	'globalblocking-whitelist-successsub' => 'Локальний стан успішно змінений',
	'globalblocking-whitelist-nochange' => 'Ви не виконали жодних змін локального стану цього блокування.
[[Special:GlobalBlockList|Повернутися до списку глобальних блокувань]].',
	'globalblocking-whitelist-errors' => 'Спроба змінити локальний стан глобального блокування не вдалася. {{PLURAL:$1|Причина|Причини}}:',
	'globalblocking-whitelist-intro' => 'Ви можете використовувати цю форму для зміни локального стану глобального блокування.
Якщо глобальне блокування вимкнене у цій вікі, то користувачі з відповідними IP-адресами зможуть нормально редагувати.
[[Special:GlobalBlockList|Повернутися до списку глобальних глобувань]].',
	'globalblocking-blocked' => "Ваша IP-адреса \$5 була заблокована на всіх вікіпроектах користувачем '''\$1''' (''\$2'').
Причиною вказано ''\"\$3\"''.
Блокування ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'Ви не можете змінювати паролі користувачів, тому що ви заблоковані на глобальному рівні.',
	'globalblocking-logpage' => 'Журнал глобальних блокувань',
	'globalblocking-logpagetext' => 'Це журнал глобальних блокувань, встановлених і знятих в цієї вікі.
Слід зазначити, що глобальні блокування можуть бути встановлені в інших вікі, але діяти також у цій вікі.
Щоб переглянути список всіх глобальних блокувань, зверніться до [[Special:GlobalBlockList|відповідного списку]].',
	'globalblocking-block-logentry' => 'глобально заблокував [[$1]] з терміном блокування $2',
	'globalblocking-block2-logentry' => 'глобально заблокував [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'зняв глобальне блокування з [[$1]]',
	'globalblocking-whitelist-logentry' => 'локально відключене глобальне блокування [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'локально відновлене глобальне блокування [[$1]]',
	'globalblocking-modify-logentry' => 'змінив глобальне блокування [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'закінчується $1',
	'globalblocking-logentry-noexpiry' => 'не встановлено термін дії',
	'globalblocking-loglink' => 'IP-адреса $1 заблокована глобально ([[{{#Special:GlobalBlockList}}/$1|детальніше]]).',
	'globalblocking-showlog' => 'Ця IP-адреса вже була заблокована раніше.
Для довідки нижче наведений журнал блокувань:',
	'globalblocklist' => 'Список глобально заблокованих IP-адрес',
	'globalblock' => 'Глобальне блокування IP-адреси',
	'globalblockstatus' => 'Локальний стан глобальних блокувань',
	'removeglobalblock' => 'Зняти глобальне блокування',
	'right-globalblock' => 'накладання глобальних блокувань',
	'right-globalunblock' => 'зняття глобальних блокувань',
	'right-globalblock-whitelist' => 'Локальне відключення глобального блокування',
	'right-globalblock-exempt' => 'Обхід глобальних блокувань',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'globalblocking-block-reason' => 'وجہ:',
	'globalblocking-unblock-reason' => 'وجہ:',
	'globalblocking-whitelist-reason' => 'وجہ:',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Consentir]] el bloco de un indirisso IP su [[Special:GlobalBlockList|tante wiki]]',
	'globalblocking-block' => 'Bloca globalmente un indirisso IP',
	'globalblocking-modify-intro' => 'Con sto modulo te pol canbiar le inpostassion de un bloco globale.',
	'globalblocking-block-intro' => 'Ti pol doparar sta pagina par blocar un indirisso IP su tute le wiki.',
	'globalblocking-block-reason' => 'Motivassion:',
	'globalblocking-block-otherreason' => 'Altra motivazion o motivazion agiuntiva:',
	'globalblocking-block-reasonotherlist' => 'Altra motivassion',
	'globalblocking-block-reason-dropdown' => '* Motivi comuni de bloco
** Spam crosswiki  
** Abuso crosswiki 
** Vandalismo',
	'globalblocking-block-edit-dropdown' => 'Canbia i motivi del bloco',
	'globalblocking-block-expiry' => 'Scadensa:',
	'globalblocking-block-expiry-other' => 'Altra scadensa',
	'globalblocking-block-expiry-otherfield' => 'Altro tenpo:',
	'globalblocking-block-legend' => 'Bloca un indirisso IP globalmente',
	'globalblocking-block-options' => 'Opzioni:',
	'globalblocking-block-errors' => "El bloco no'l ga vu sucesso, par {{PLURAL:$1|el seguente motivo|i seguenti motivi}}:",
	'globalblocking-block-ipinvalid' => "L'indirisso IP ($1) che te gh'è scrito no'l xe valido.
Par piaser tien conto che no ti pol inserir un nome utente!",
	'globalblocking-block-expiryinvalid' => 'La scadensa che ti ga inserìo ($1) no la xe valida.',
	'globalblocking-block-submit' => 'Bloca sto indirisso IP globalmente',
	'globalblocking-modify-submit' => 'Canbia sto bloco globale',
	'globalblocking-block-success' => "L'indirisso IP $1 el xe stà blocà con sucesso su tuti i progeti.",
	'globalblocking-modify-success' => 'El bloco globale de $1 el xe stà canbià',
	'globalblocking-block-successsub' => 'Bloco global efetuà',
	'globalblocking-modify-successsub' => 'Modifica del bloco globale riussìa',
	'globalblocking-block-alreadyblocked' => "L'indirisso IP $1 el xe de zà blocà globalmente. Ti pol védar el bloco esistente su la [[Special:GlobalBlockList|lista dei blochi globali]], o canbiar le inpostassion del bloco esistente riconpilando sto modulo.",
	'globalblocking-block-bigrange' => 'La classe che ti gà indicà ($1) le xe massa granda par èssar blocà. Se pol blocar, al massimo, 65.536 indirissi (classe /16)',
	'globalblocking-list-intro' => 'De sèvito xe elencà tuti i blochi globali che xe ativi in sto momento. Çerti blochi i xe segnà come disativài localmente: cioè vorìa dir che sti blochi i xe ativi su altri siti, ma un aministrador locale el gà decidesto de disativarli su sta wiki.',
	'globalblocking-list' => 'Lista de indirissi IP blocà globalmente',
	'globalblocking-search-legend' => 'Serca un bloco global',
	'globalblocking-search-ip' => 'Indirisso IP:',
	'globalblocking-search-submit' => 'Serca un bloco',
	'globalblocking-list-ipinvalid' => "L'indirisso IP che ti gà sercà ($1) no'l xe mìa valido.
Par piaser, inserissi un indirisso IP valido.",
	'globalblocking-search-errors' => 'La to riserca no la gà catà gnente, par {{PLURAL:$1|el seguente motivo|i seguenti motivi}}:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') gà blocà globalmente [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'scadensa $1',
	'globalblocking-list-anononly' => 'solo anonimi',
	'globalblocking-list-unblock' => 'desbloca',
	'globalblocking-list-whitelisted' => 'localmente disabilità da $1: $2',
	'globalblocking-list-whitelist' => 'stato local',
	'globalblocking-list-modify' => 'canbia',
	'globalblocking-list-noresults' => "L'indirisso IP richiesto no'l xe mia blocà.",
	'globalblocking-goto-block' => 'Bloca globalmente un indirisso IP',
	'globalblocking-goto-unblock' => 'Cava un bloco global',
	'globalblocking-goto-status' => 'Canbia el stato locale de un bloco globale',
	'globalblocking-return' => "Torna indrìo a l'elenco dei blochi globali",
	'globalblocking-notblocked' => "L'indirisso IP ($1) che ti gà inserìo no'l xe mia blocà globalmente.",
	'globalblocking-unblock' => 'Cava un bloco globale',
	'globalblocking-unblock-ipinvalid' => "L'indirisso IP che ti gà inserìo ($1) no'l xe mìa valido.
Par piaser tien presente che no ti pol inserir un nome utente!",
	'globalblocking-unblock-legend' => 'Cava un bloco global',
	'globalblocking-unblock-submit' => 'Cava el bloco global',
	'globalblocking-unblock-reason' => 'Motivassion:',
	'globalblocking-unblock-unblocked' => "Ti gà cavà con sucesso el bloco global #$2 su l'indirisso IP '''$1'''",
	'globalblocking-unblock-errors' => 'La rimozion del bloco global che te ghè domandà no la xe riussìa, par {{PLURAL:$1|el seguente motivo|i seguenti motivi}}:',
	'globalblocking-unblock-successsub' => 'El bloco global el xe stà cava',
	'globalblocking-unblock-subtitle' => 'Rimozion del bloco globale',
	'globalblocking-unblock-intro' => 'Ti pol doparar sto modulo par cavar un bloco globale.',
	'globalblocking-whitelist' => 'Stato locale dei blochi globali',
	'globalblocking-whitelist-notapplied' => 'I blochi globali no i xe ativi su sta wiki.
No se pol mia canbiar el stato locale dei blochi globali.',
	'globalblocking-whitelist-legend' => 'Canbia el stato local',
	'globalblocking-whitelist-reason' => 'Motivassion:',
	'globalblocking-whitelist-status' => 'Stato local:',
	'globalblocking-whitelist-statuslabel' => 'Disabilita sto bloco global su {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Canbia stato local',
	'globalblocking-whitelist-whitelisted' => "Ti ga disabilità el bloco global #$2 su l'indirisso IP '''$1''' su {{SITENAME}}",
	'globalblocking-whitelist-dewhitelisted' => "Ti gà ri-ativà el bloco global #$2 su l'indirisso IP '''$1''' su {{SITENAME}}",
	'globalblocking-whitelist-successsub' => 'Stato local canbià',
	'globalblocking-whitelist-nochange' => "No ti gà fato canbiamenti al stato locale de sto blocco. [[Special:GlobalBlockList|Torna indrìo a l'elenco dei blochi globali]].",
	'globalblocking-whitelist-errors' => "El to canbiamento al stato locale de un bloco globale no'l xe mia stà fato par {{PLURAL:$1|el seguente motivo|i seguenti motivi}}:",
	'globalblocking-whitelist-intro' => "Ti pol doparar sto modulo par canbiar el stato locale de un bloco globale. Se un blocco globale el xe disativà su sta wiki, i utenti che i dòpara l'indirisso IP colpìo i sarà in grado de far modifiche normalmente.
[[Special:GlobalBlockList|Struca qua]] par tornar indrìo a l'elenco dei blochi globali.",
	'globalblocking-blocked' => "El to indirisso IP el xe stà blocà su tute le wiki da '''\$1''' (''\$2'').
La motivassion fornìa la xe ''\"\$3\"''. 
El bloco ''\$4''.",
	'globalblocking-blocked-nopassreset' => 'No te podi resetar le password dei utenti, parché a te sì blocà globalmente.',
	'globalblocking-logpage' => 'Registro dei blochi globali',
	'globalblocking-logpagetext' => "De sèvito xe elencà i blochi globali che xe stà messi o cavà su sta wiki. I blochi globali i pol vegner fati su altre wiki e sti blochi globali i pol èssar validi anca su sta wiki.
Par védar tuti i blochi globali ativi, varda l'[[Special:GlobalBlockList|elenco dei blochi globali]].",
	'globalblocking-block-logentry' => '[[$1]] xe stà blocà globalmente con scadensa: $2',
	'globalblocking-block2-logentry' => 'gà blocà globalmente [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'cavà el bloco global su [[$1]]',
	'globalblocking-whitelist-logentry' => 'disabilità localmente el bloco global su [[$1]]',
	'globalblocking-dewhitelist-logentry' => 'ri-abilità localmente el bloco global su [[$1]]',
	'globalblocking-modify-logentry' => 'gà canbià el bloco globale de [[$1]] ($2)',
	'globalblocking-logentry-expiry' => 'scade el $1',
	'globalblocking-logentry-noexpiry' => 'nissuna scadensa inpostà',
	'globalblocking-loglink' => "L'indirisso IP el xe blocà globalmente ([[{{#Special:GlobalBlockList}}/$1|tuti i detagli]]).",
	'globalblocking-showlog' => 'Sto indirisso IP i lo gavéa zà blocà tenpo fa.
El registro dei blochi se pol védarlo qua de soto par comodità:',
	'globalblocklist' => 'Lista dei indirissi IP blocà globalmente',
	'globalblock' => 'Bloca globalmente un indirisso IP',
	'globalblockstatus' => 'Stato locale de blochi globali',
	'removeglobalblock' => 'Cava un bloco globale',
	'right-globalblock' => 'Bloca dei utenti globalmente',
	'right-globalunblock' => 'Cava blochi globali',
	'right-globalblock-whitelist' => 'Disabilita localmente blochi globali',
	'right-globalblock-exempt' => 'Scavalca blochi globali',
);

/** Veps (Vepsän kel')
 * @author Triple-ADHD-AS
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'globalblocking-block-reason' => 'Sü:',
	'globalblocking-block-expiry-otherfield' => 'Toine aig:',
	'globalblocking-block-options' => 'Opcijad:',
	'globalblocking-ipaddress' => 'IP-adres:',
	'globalblocking-search-ip' => 'IP-adres:',
	'globalblocking-list-unblock' => 'Heitta blokiruind',
	'globalblocking-list-modify' => 'modificiruida',
	'globalblocking-list-noresults' => 'Ectud IP-adres ei ole blokiruidud.',
	'globalblocking-goto-block' => 'Blokiruida IP-adres kogonaz',
	'globalblocking-goto-unblock' => 'Heitta kogonaz blokiruind',
	'globalblocking-unblock-legend' => 'Heitta kogonaz blokiruind',
	'globalblocking-unblock-reason' => 'Sü:',
	'globalblocking-unblock-subtitle' => 'Heitta kogonaz blokiruind',
	'globalblocking-whitelist-reason' => 'Sü:',
	'globalblocking-whitelist-status' => 'Lokaline status:',
	'globalblocking-whitelist-submit' => 'Toižetada lokaline status',
	'globalblockstatus' => 'Kogonaz-blokiruindoiden lokaline status',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Cho phép]] [[Special:GlobalBlockList|cấm địa chỉ IP trên nhiều wiki]]',
	'globalblocking-block' => 'Cấm một địa chỉ IP trên toàn hệ thống',
	'globalblocking-modify-intro' => 'Có thể sử dụng biểu mẫu này để cấu hình một tác vụ cấm toàn hệ thống.',
	'globalblocking-block-intro' => 'Bạn có thể sử dụng trang này để cấm một địa chỉ IP trên tất cả các wiki.',
	'globalblocking-block-reason' => 'Lý do:',
	'globalblocking-block-otherreason' => 'Lý do khác/bổ sung:',
	'globalblocking-block-reasonotherlist' => 'Lý do khác',
	'globalblocking-block-reason-dropdown' => '* Lý do cấm thường gặp
** Spam các wiki
** Lạm dụng các wiki
** Phá hoại',
	'globalblocking-block-edit-dropdown' => 'Sửa đổi các lý do cấm',
	'globalblocking-block-expiry' => 'Hết hạn cấm:',
	'globalblocking-block-expiry-other' => 'Thời gian hết hạn khác',
	'globalblocking-block-expiry-otherfield' => 'Thời hạn khác:',
	'globalblocking-block-legend' => 'Cấm địa chỉ IP trên toàn hệ thống',
	'globalblocking-block-options' => 'Tùy chọn:',
	'globalblocking-ipaddress' => 'Địa chỉ IP:',
	'globalblocking-ipbanononly' => 'Chỉ cấm người dùng vô danh',
	'globalblocking-block-errors' => 'Cấm không thành công vì {{PLURAL:$1||các}} lý do sau:',
	'globalblocking-block-ipinvalid' => 'Bạn đã nhập địa chỉ IP ($1) không hợp lệ.
Xin chú ý rằng không thể nhập một tên người dùng!',
	'globalblocking-block-expiryinvalid' => 'Thời hạn bạn nhập ($1) không hợp lệ.',
	'globalblocking-block-submit' => 'Cấm địa chỉ IP này trên toàn hệ thống',
	'globalblocking-modify-submit' => 'Sửa đổi tác vụ cấm toàn hệ thống này',
	'globalblocking-block-success' => 'Đã cấm thành công địa chỉ IP $1 trên tất cả các dự án.',
	'globalblocking-modify-success' => 'Đã sửa đổi tác vụ cấm $1 toàn hệ thống thành công.',
	'globalblocking-block-successsub' => 'Cấm thành công trên toàn hệ thống',
	'globalblocking-modify-successsub' => 'Đã sửa đổi tác vụ cấm toàn hệ thống thành công',
	'globalblocking-block-alreadyblocked' => 'Địa chỉ IP $1 đã bị cấm trên toàn hệ thống.
Bạn có thể xem những IP đang bị cấm tại [[Special:GlobalBlockList|danh sách các tác vụ cấm trên toàn hệ thống]], hoặc sửa đổi các thuộc tính của tác vụ cấm bằng cách lưu lại biểu mẫu này.',
	'globalblocking-block-bigrange' => 'Tầm địa chỉ mà bạn chỉ định ($1) quá lớn nên không thể cấm. Bạn chỉ có thể cấm nhiều nhất là 65.536 địa chỉ (tầm vực /16)',
	'globalblocking-list-intro' => 'Đây là danh sách tất cả các tác vụ cấm trên toàn hệ thống đang có hiệu lực.
Một số tác vụ cấm được đánh dấu là tắt cục bộ: điều đó có nghĩa là người dùng vẫn bị cấm tại các website khác, nhưng một bảo quản viên tại đây đã quyết định bỏ cấm tại wiki này.',
	'globalblocking-list' => 'Danh sách các địa chỉ IP bị cấm trên toàn hệ thống',
	'globalblocking-search-legend' => 'Tìm một lần cấm toàn hệ thống',
	'globalblocking-search-ip' => 'Địa chỉ IP:',
	'globalblocking-search-submit' => 'Tìm lần cấm',
	'globalblocking-list-ipinvalid' => 'Địa chỉ IP bạn muốn tìm ($1) không hợp lệ.
Xin hãy nhập một địa chỉ IP hợp lệ.',
	'globalblocking-search-errors' => 'Tìm kiếm không thành công vì {{PLURAL:$1||các}} lý do sau:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') đã cấm [[Special:Contributions/\$4|\$4]] trên toàn hệ thống ''(\$5)''",
	'globalblocking-list-expiry' => 'hết hạn $1',
	'globalblocking-list-anononly' => 'chỉ cấm vô danh',
	'globalblocking-list-unblock' => 'bỏ cấm',
	'globalblocking-list-whitelisted' => 'bị tắt cục bộ bởi $1: $2',
	'globalblocking-list-whitelist' => 'trạng thái cục bộ',
	'globalblocking-list-modify' => 'thay đổi',
	'globalblocking-list-noresults' => 'Địa chỉ IP được yêu cầu không bị cấm.',
	'globalblocking-goto-block' => 'Cấm địa chỉ IP toàn cục',
	'globalblocking-goto-unblock' => 'Bỏ cấm toàn cục',
	'globalblocking-goto-status' => 'Thay đổi trạng thái cục bộ của tác vụ cấm toàn cục',
	'globalblocking-return' => 'Trở lại danh sách cấm toàn cục',
	'globalblocking-notblocked' => 'Địa chỉ IP ($1) mà bạn cho vào chưa bị cấm toàn cục.',
	'globalblocking-unblock' => 'Bỏ cấm toàn cục',
	'globalblocking-unblock-ipinvalid' => 'Bạn đã nhập địa chỉ IP ($1) không hợp lệ.
Xin chú ý rằng không thể nhập một tên người dùng!',
	'globalblocking-unblock-legend' => 'Bỏ cấm toàn hệ thống',
	'globalblocking-unblock-submit' => 'Bỏ cấm hệ thống',
	'globalblocking-unblock-reason' => 'Lý do:',
	'globalblocking-unblock-unblocked' => "Bạn đã bỏ thành công lần cấm #$2 đối với địa chỉ IP '''$1'''",
	'globalblocking-unblock-errors' => 'Bạn không thể bỏ cấm cho địa chỉ IP này vì {{PLURAL:$1||các}} lý do sau:',
	'globalblocking-unblock-successsub' => 'Đã bỏ cấm trên toàn hệ thống thành công',
	'globalblocking-unblock-subtitle' => 'Bỏ cấm toàn bộ',
	'globalblocking-unblock-intro' => 'Biểu mẫu này để bỏ cấm toàn cục.',
	'globalblocking-whitelist' => 'Trạng thái cục bộ của các tác vụ cấm toàn cục',
	'globalblocking-whitelist-notapplied' => 'Các tác vụ cấm toàn hệ thống không được áp dụng tại wiki này, nên không thể sửa đổi trạng thái địa phương của các tác vụ cấm toàn hệ thống.',
	'globalblocking-whitelist-legend' => 'Thay đổi trạng thái cục bộ',
	'globalblocking-whitelist-reason' => 'Lý do:',
	'globalblocking-whitelist-status' => 'Trạng thái cục bộ:',
	'globalblocking-whitelist-statuslabel' => 'Tắt tác vụ cấm toàn cục này tại {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Thay đổi trạng thái cục bộ',
	'globalblocking-whitelist-whitelisted' => "Bạn đã tắt tác vụ cấm địa chỉ IP '''$1''' toàn cục (#$2) tại {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Bạn đã bật lên tác vụ cấm địa chỉ IP '''$1''' toàn cục (#$2) tại {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Thay đổi trạng thái cục bộ thành công',
	'globalblocking-whitelist-nochange' => 'Bạn không thay đổi trạng thái cục bộ của tác vụ cấm này.
[[Special:GlobalBlockList|Trở lại danh sách cấm toàn cục]].',
	'globalblocking-whitelist-errors' => 'Không thể thay đổi trạng thái cục bộ của tác vụ cấm toàn cục vì {{PLURAL:$1||các}} lý do sau:',
	'globalblocking-whitelist-intro' => 'Biểu mẫu này để thay đổi trạng thái cục bộ của tác vụ cấm toàn cục.
Nếu tác vụ cấm bị tắt tại wiki này, những người dùng những địa chỉ IP đó sẽ được phép sửa đổi bình thường.
[[Special:GlobalBlockList|Trở lại danh sách cấm toàn cục]].',
	'globalblocking-blocked' => "Địa chỉ IP của bạn, $5, đã bị '''$1''' (''$2'') cấm trên tất cả các wiki.
Lý do được đưa ra là: ''$3''.
Thời hạn cấm sẽ $4.",
	'globalblocking-blocked-nopassreset' => 'Bạn không thể tái tạo mật khẩu vì bạn đã bị cấm trên toàn hệ thống.',
	'globalblocking-logpage' => 'Nhật trình cấm trên toàn hệ thống',
	'globalblocking-logpagetext' => 'Đây là danh sách các tác vụ cấm toàn cục được thực hiện hoặc lùi lại tại wiki này. Lưu ý rằng có thể thực hiện và lùi các tác vụ cấm tại wiki khác, nhưng các tác vụ cấm đó cũng có hiệu lực tại đây.

Xem [[Special:GlobalBlockList|tất cả các tác vụ cấm toàn cục]].',
	'globalblocking-block-logentry' => 'đã cấm [[$1]] trên toàn hệ thống với thời gian hết hạn của $2',
	'globalblocking-block2-logentry' => 'cấm [[$1]] toàn hệ thống ($2)',
	'globalblocking-unblock-logentry' => 'đã bỏ cấm trên toàn hệ thống vào [[$1]]',
	'globalblocking-whitelist-logentry' => 'đã tắt tác vụ cấm [[$1]] cục bộ',
	'globalblocking-dewhitelist-logentry' => 'đã bật lên tác vụ cấm [[$1]] cục bộ',
	'globalblocking-modify-logentry' => 'sửa đổi tác vụ cấm [[$1]] toàn hệ thống ($2)',
	'globalblocking-logentry-expiry' => 'hết hạn $1',
	'globalblocking-logentry-noexpiry' => 'vô hạn',
	'globalblocking-loglink' => 'Địa chỉ IP $1 đã bị cấm trên toàn hệ thống ([[{{#Special:GlobalBlockList}}/$1|chi tiết đầy đủ]]).',
	'globalblocking-showlog' => 'Địa chỉ IP này đã bị cấm trước đây.
Hãy tham khảo nhật trình cấm ở dưới:',
	'globalblocklist' => 'Danh sách các địa chỉ IP bị cấm trên toàn hệ thống',
	'globalblock' => 'Cấm một địa chỉ IP trên toàn hệ thống',
	'globalblockstatus' => 'Trạng thái cục bộ của các tác vụ cấm toàn cục',
	'removeglobalblock' => 'Bỏ cấm toàn cục',
	'right-globalblock' => 'Cấm toàn cục',
	'right-globalunblock' => 'Bỏ cấm toàn cục',
	'right-globalblock-whitelist' => 'Tắt tác vụ cấm toàn cục',
	'right-globalblock-exempt' => 'Bỏ qua vụ cấm toàn cục',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Dälon]] ladetis-IP ad [[Special:GlobalBlockList|pablokön in vüks mödik]]',
	'globalblocking-block' => 'Blokön ladeti-IP valöpo',
	'globalblocking-block-intro' => 'Kanol gebön padi at ad blokön ladeti-IP in vüks valik.',
	'globalblocking-block-reason' => 'Kod:',
	'globalblocking-block-reasonotherlist' => 'Kod votik',
	'globalblocking-block-expiry' => 'Blokamadul:',
	'globalblocking-block-expiry-otherfield' => 'Tim votik:',
	'globalblocking-block-legend' => 'Blokön ladeti-IP valöpo',
	'globalblocking-block-options' => 'Välots:',
	'globalblocking-block-errors' => 'Blokam olik no eplöpon, sekü {{PLURAL:$1|kod|kods}} sököl:',
	'globalblocking-block-ipinvalid' => 'Ladet-IP fa ol pepenöl no lonöfon. Demolös, das no dalol penön gebananemi is!',
	'globalblocking-block-expiryinvalid' => 'Dul fa ol pepenöl ($1) no lonöfon.',
	'globalblocking-block-submit' => 'Blokön ladeti-IP at valöpo',
	'globalblocking-block-success' => 'Ladet-IP: $1 peblokon benosekiko pro proyegs valik.',
	'globalblocking-block-successsub' => 'Blokam valöpik benosekik',
	'globalblocking-block-alreadyblocked' => 'Ladet-IP: $1 ya peblokon valöpo.
Kanol logön blokami dabinöl su [[Special:GlobalBlockList|lised blokamas valöpik]].',
	'globalblocking-list-intro' => 'Is palisedons blokams valöpik anu lonöföls valiks.
Blokams anik pabepenons as topiko pesädunöls: atos sinifon, das lonöfons su bevüresodatopäds votik, ab guvan topik esludon ad sädunön onis in vük okik.',
	'globalblocking-list' => 'Lised ladetas-IP valöpo peblokölas',
	'globalblocking-search-legend' => 'Sukön blokami valöpik',
	'globalblocking-search-ip' => 'Ladet-IP:',
	'globalblocking-search-submit' => 'Sukön blokamis',
	'globalblocking-list-ipinvalid' => 'Ladet-IP fa ol pesuköl ($1) no lonöfon.
Penolös ladeti-IP lonöföl.',
	'globalblocking-search-errors' => 'Suk olik no eplopon, sekü {{PLURAL:$1|kod|kods}} sököl:',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') päblokon valöpo [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => 'dul jü $1',
	'globalblocking-list-anononly' => 'te nennemik',
	'globalblocking-list-unblock' => 'moükön',
	'globalblocking-list-whitelisted' => 'penemögükon topiko fa geban: $1: $2',
	'globalblocking-list-whitelist' => 'stad topik',
	'globalblocking-goto-block' => 'Blokön ladeti-IP valöpo',
	'globalblocking-goto-unblock' => 'Moükön blokami valöpik',
	'globalblocking-goto-status' => 'Votükön stadi topik blokama valöpik',
	'globalblocking-return' => 'Geikön lü lised blokamas valöpik',
	'globalblocking-notblocked' => 'Ladet-IP fa ol pepenöl ($1) no peblokon valöpo.',
	'globalblocking-unblock' => 'Moükön blokami valöpik',
	'globalblocking-unblock-ipinvalid' => 'Ladet-IP fa ol pepenöl ($1) no lonöfon.
Demolös, das no dalon penön gebananemi!',
	'globalblocking-unblock-legend' => 'Moükön blokami valöpik',
	'globalblocking-unblock-submit' => 'Moükön blokami valöpik',
	'globalblocking-unblock-reason' => 'Kod:',
	'globalblocking-unblock-unblocked' => "Emoükol benosekiko blokami valöpik: #$2 ladeta-IP: '''$1'''",
	'globalblocking-unblock-errors' => 'Moükam olik blokama valöpik no eplöpon, sekü {{PLURAL:$1|kod|kods}} fovik:',
	'globalblocking-unblock-successsub' => 'Blokam valöpik pemoükon benosekiko',
	'globalblocking-unblock-subtitle' => 'Moükön blokami valöpik',
	'globalblocking-unblock-intro' => 'Kanol gebön fometi at ad moükön blokami valöpik.',
	'globalblocking-whitelist' => 'Stad topik blokamas valöpik',
	'globalblocking-whitelist-legend' => 'Votükön stadi topik',
	'globalblocking-whitelist-reason' => 'Kod:',
	'globalblocking-whitelist-status' => 'Stad topik:',
	'globalblocking-whitelist-statuslabel' => 'Sädunön blokami valöpik at in {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Votükön stadi topik',
	'globalblocking-whitelist-whitelisted' => "Esädunol benosekiko blokami valöpik: #$2 ladeta-IP: '''$1''' in {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Edönudunol benosekiko blokami valöpik: #$2 ladeta-IP: '''$1''' in {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Stad topik pevotükon benosekiko',
	'globalblocking-whitelist-nochange' => 'No evotükol stadi topik blokama at.
[[Special:GlobalBlockList|Gegolön lü lised blokamas valöpik]].',
	'globalblocking-whitelist-errors' => 'Votükam olik stada topik blokama valöpik no eplöpon, sekü {{PLURAL:$1|kod|kods}} sököl:',
	'globalblocking-whitelist-intro' => 'Kanol gebön fometi at ad votükön stadi topik blokama valöpik.
If blokam valöpik pesädunon in vük at, gebans ladetas-IP teföl okanons redakön nensäkädiko.
[[Special:GlobalBlockList|Geikön lü lised blokamas valöpik]].',
	'globalblocking-blocked' => "Ladet-IP olik peblokon in vüks falik fa geban: '''$1''' ('''$2''').
Kod äbinon: ''„$3“''.
Blokam dulon ''$4''.",
	'globalblocking-logpage' => 'Jenotalised blokamas valöpik',
	'globalblocking-logpagetext' => 'Atos binon jenotalised blokamas valöpik, kels peledunons e/u pemoükons in vük at.
Demolös, das blokams valöpik kanons paledunön e pamoükön in vüks votik, e das blokams valöpik at kanons tefön vüki at.
Kanol tuvön blokamis valöpik lonöfol valik in [[Special:GlobalBlockList|lised blokamas valöpik]].',
	'globalblocking-block-logentry' => 'eblokon valöpo gebani: [[$1]], blokamadul: $2',
	'globalblocking-unblock-logentry' => 'blokam valöpik pemoükon in [[$1]]',
	'globalblocking-whitelist-logentry' => 'enemögükon blokami valöpik in [[$1]] topiko',
	'globalblocking-dewhitelist-logentry' => 'edönumögükon blokami valöpik in [[$1]] topiko',
	'globalblocklist' => 'Lised ladetas-IP valöpo peblokölas',
	'globalblock' => 'blokön ladeti-IP valöpo',
	'globalblockstatus' => 'Stad topik blokamas valöpik',
	'removeglobalblock' => 'Moükön blokami valöpik',
	'right-globalblock' => 'Dunön blokamis valöpik',
	'right-globalunblock' => 'Moükön blokamis valöpik',
	'right-globalblock-whitelist' => 'Sädunön blokamis valöpik topiko',
);

/** Wolof (Wolof)
 * @author Ibou
 */
$messages['wo'] = array(
	'globalblocking-list-anononly' => 'Alaxam rek',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'globalblocking-block-reason' => '理由：',
	'globalblocking-unblock-reason' => '理由：',
	'globalblocking-whitelist-reason' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'globalblocking-block' => 'בלאקירן גלאבאַליש IP אַדרעס',
	'globalblocking-block-reason' => 'אורזאַך:',
	'globalblocking-block-otherreason' => 'אַנדער/נאך א סיבה:',
	'globalblocking-block-reasonotherlist' => 'אַנדער סיבה',
	'globalblocking-block-reason-dropdown' => '* געמיינזאַמע בלאָקירן גרונדן
** אַריבערוויקי ספאַם
** אַריבערוויקי קרומבאַניץ 
** וואַנדאַליזם',
	'globalblocking-block-edit-dropdown' => 'רעדאַקטירן בלאקירונג סיבות',
	'globalblocking-block-expiry' => 'אויסלאז:',
	'globalblocking-block-expiry-other' => 'אַנדער אויסלאז צײַט',
	'globalblocking-block-expiry-otherfield' => 'אַנדער צײַט:',
	'globalblocking-search-ip' => 'IP אַדרעס:',
	'globalblocking-list-expiry' => 'אויסלאז $1',
	'globalblocking-list-anononly' => 'בלויז אַנאנימע',
	'globalblocking-list-unblock' => 'אַראָפּנעמען',
	'globalblocking-list-whitelist' => 'לאקאַלער סטאַטוס',
	'globalblocking-list-modify' => 'ענדערן',
	'globalblocking-unblock-legend' => 'אַראָפנעמען גלאבאָלן בלאק',
	'globalblocking-unblock-submit' => 'אַראָפנעמען גלאבאָלן בלאק',
	'globalblocking-unblock-reason' => 'אורזאַך:',
	'globalblocking-unblock-subtitle' => 'אַראָפנעמען גלאבאָלן בלאק',
	'globalblocking-whitelist-legend' => 'ענדערן לאקאַלן סטאַטוס',
	'globalblocking-whitelist-reason' => 'אורזאַך:',
	'globalblocking-whitelist-status' => 'לאקאַלער סטאַטוס:',
	'globalblocking-whitelist-submit' => 'ענדערן לאקאַלן סטאַטוס',
	'globalblocking-block-logentry' => 'בלאקירט גלאבאַליש "[[$1]]" מיט אן אויסלאז צײַט פֿון $2',
	'globalblocking-block2-logentry' => 'בלאקירט גלאבאַליש [[$1]] ($2)',
	'globalblocking-unblock-logentry' => 'אַוועקגענומען גלאבאלע פאַרשפּאַרן פֿון [[$1]]',
	'globalblocking-logentry-expiry' => 'ביז $1',
	'globalblocking-logentry-noexpiry' => 'קיין אויסלאז צײַט',
	'removeglobalblock' => 'אויפהייבן גלאבאלן בלאק',
	'right-globalblock' => 'אײַנריכטן גלאבאָלע בלאקן',
	'right-globalunblock' => 'אַראָפנעמען גלאבאָלע בלאקן',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'globalblocking-block-reason' => 'Ìdíẹ̀:',
	'globalblocking-block-reasonotherlist' => 'Ìdíẹ̀ míràn:',
	'globalblocking-block-edit-dropdown' => 'Àtúnṣe àwọn ìdí ìdínà',
	'globalblocking-block-expiry-otherfield' => 'Àsìkò míràn:',
	'globalblocking-block-options' => 'Àwọn àṣàyàn:',
	'globalblocking-block-errors' => 'Ìdínà yín jẹ́ aláìyọrísírere, fún {{PLURAL:$1|ìdí yìí|àwọn ìdí wọ̀nyí}}:',
	'globalblocking-search-ip' => 'Àdírẹ́ẹ̀sì IP:',
	'globalblocking-search-submit' => 'Ṣàwárí fún àwọn ìdínà',
	'globalblocking-list-anononly' => 'aláìlórúkọ nìkan',
	'globalblocking-list-unblock' => 'ṣèyọkúrò',
	'globalblocking-list-modify' => 'ṣàtúnṣe',
	'globalblocking-list-noresults' => 'Àdírẹ́sì IP tìtọrọ kó jẹ́ dídílọ́nà.',
	'globalblocking-unblock-reason' => 'Ìdíẹ̀:',
	'globalblocking-whitelist-reason' => 'Ìdíẹ̀:',
	'globalblocking-logentry-expiry' => 'yíò parí ní $1',
);

/** Cantonese (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|容許]]IP地址可以[[Special:GlobalBlockList|響多個wiki度封鎖]]',
	'globalblocking-block' => '全域封鎖一個IP地址',
	'globalblocking-block-intro' => '你可以用呢版去封鎖全部wiki嘅一個IP地址。',
	'globalblocking-block-reason' => '原因:',
	'globalblocking-block-expiry' => '封鎖到期:',
	'globalblocking-block-expiry-other' => '其它嘅到期時間',
	'globalblocking-block-expiry-otherfield' => '其它時間:',
	'globalblocking-block-legend' => '全域封鎖一位用戶',
	'globalblocking-block-options' => '選項',
	'globalblocking-block-errors' => '個封鎖唔成功，因為:
$1',
	'globalblocking-block-ipinvalid' => '你所輸入嘅IP地址 ($1) 係無效嘅。
請留意嘅係你唔可以輸入一個用戶名！',
	'globalblocking-block-expiryinvalid' => '你所輸入嘅到期 ($1) 係無效嘅。',
	'globalblocking-block-submit' => '全域封鎖呢個IP地址',
	'globalblocking-block-success' => '個IP地址 $1 已經響所有Wikimedia計劃度成功噉封鎖咗。
你亦都可以睇吓個[[Special:GlobalBlockList|全域封鎖一覽]]。',
	'globalblocking-block-successsub' => '全域封鎖成功',
	'globalblocking-block-alreadyblocked' => '個IP地址 $1 已經全域封鎖緊。你可以響[[Special:GlobalBlockList|全域封鎖一覽]]度睇吓現時嘅封鎖。',
	'globalblocking-block-bigrange' => '你所指定嘅範圍 ($1) 太大去封鎖。
你可以封鎖，最多65,536個地址 (/16 範圍)',
	'globalblocking-list-intro' => '呢個係全部現時生效緊嘅全域封鎖。
一啲嘅封鎖標明咗響本地停用：即係呢個封鎖響其它wiki度應用咗，但係本地管理員決定咗響呢個wiki度停用佢哋。',
	'globalblocking-list' => '全域封鎖IP地址一覽',
	'globalblocking-search-legend' => '搵一個全域封鎖',
	'globalblocking-search-ip' => 'IP地址:',
	'globalblocking-search-submit' => '搵封鎖',
	'globalblocking-list-ipinvalid' => '你所搵嘅IP地址 ($1) 係無效嘅。
請輸入一個有效嘅IP地址。',
	'globalblocking-search-errors' => '你之前搵過嘅嘢唔成功，因為:
$1',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> (''\$3'') 全域封鎖咗 [[Special:Contributions/\$4|\$4]] ''(\$5)''",
	'globalblocking-list-expiry' => '於$1到期',
	'globalblocking-list-anononly' => '限匿名',
	'globalblocking-list-unblock' => '解封',
	'globalblocking-list-whitelisted' => '由$1於本地封鎖: $2',
	'globalblocking-list-whitelist' => '本地狀態',
	'globalblocking-goto-block' => '全域封鎖一個 IP 地址',
	'globalblocking-goto-unblock' => '拎走一個全域封鎖',
	'globalblocking-goto-status' => '改一個全域封鎖嘅本地狀態',
	'globalblocking-return' => '返去全域封鎖一覽',
	'globalblocking-notblocked' => '你所輸入嘅 IP 地址 ($1) 並無全域封鎖到。',
	'globalblocking-unblock' => '拎走一個全域封鎖',
	'globalblocking-unblock-ipinvalid' => '你輸入嘅IP地址 ($1) 係無效嘅。
請留意嘅係你唔可以輸入一個用戶名！',
	'globalblocking-unblock-legend' => '拎走一個全域封鎖',
	'globalblocking-unblock-submit' => '拎走全域封鎖',
	'globalblocking-unblock-reason' => '原因:',
	'globalblocking-unblock-unblocked' => "你己經成功噉拎走咗響IP地址 '''$1''' 嘅全域封鎖 #$2",
	'globalblocking-unblock-errors' => '你唔可以拎走嗰個IP地址嘅全域封鎖，因為:
$1',
	'globalblocking-unblock-successsub' => '全域封鎖已經成功噉拎走咗',
	'globalblocking-unblock-subtitle' => '拎走全域封鎖',
	'globalblocking-unblock-intro' => '你可以用呢個表去拎走一個全域封鎖。',
	'globalblocking-whitelist' => '全域封鎖嘅本地狀態',
	'globalblocking-whitelist-legend' => '改本地狀態',
	'globalblocking-whitelist-reason' => '原因:',
	'globalblocking-whitelist-status' => '本地狀態:',
	'globalblocking-whitelist-statuslabel' => '停用響{{SITENAME}}嘅全域封鎖',
	'globalblocking-whitelist-submit' => '改本地狀態',
	'globalblocking-whitelist-whitelisted' => "你已經成功噉響{{SITENAME}}嘅IP地址 '''$1''' 度停用咗全域封鎖 #$2。",
	'globalblocking-whitelist-dewhitelisted' => "你已經成功噉響{{SITENAME}}嘅IP地址 '''$1''' 度再次啟用咗全域封鎖 #$2。",
	'globalblocking-whitelist-successsub' => '本地狀態已經成功噉改咗',
	'globalblocking-whitelist-nochange' => '你未對呢個封鎖嘅本地狀態改過嘢。
[[Special:GlobalBlockList|返去全域封鎖一覽]]。',
	'globalblocking-whitelist-errors' => '基於下面嘅{{PLURAL:$1|原因|原因}}，你改過嘅全域封鎖本地狀態唔成功：',
	'globalblocking-whitelist-intro' => '你可以用呢個表去改全域封鎖嘅本地狀態。
如果一個全域封鎖響呢個wiki度停用咗，受影響嘅 IP 地址可以正常噉編輯。
[[Special:GlobalBlockList|返去全域封鎖一覽]]。',
	'globalblocking-blocked' => "你嘅IP地址已經由'''\$1''' (''\$2'') 響所有嘅Wikimedia wiki 度全部封鎖晒。
個原因係 ''\"\$3\"''。個封鎖會響''\$4''到期。",
	'globalblocking-logpage' => '全域封鎖日誌',
	'globalblocking-logpagetext' => '呢個係響呢個wiki度，整過同拎走過嘅全域封鎖日誌。
要留意嘅係全域封鎖可以響其它嘅wiki度整同拎走。
要睇活躍嘅全域封鎖，你可以去睇個[[Special:GlobalBlockList|全域封鎖一覽]]。',
	'globalblocking-block-logentry' => '全域封鎖咗[[$1]]於 $2 到期',
	'globalblocking-unblock-logentry' => '拎走咗[[$1]]嘅全域封鎖',
	'globalblocking-whitelist-logentry' => '停用咗[[$1]]響本地嘅全域封鎖',
	'globalblocking-dewhitelist-logentry' => '再開[[$1]]響本地嘅全域封鎖',
	'globalblocklist' => '全域封鎖IP地址一覽',
	'globalblock' => '全域封鎖一個IP地址',
	'globalblockstatus' => '全域封鎖嘅本地狀態',
	'removeglobalblock' => '拎走一個全域封鎖',
	'right-globalblock' => '整一個全域封鎖',
	'right-globalunblock' => '拎走全域封鎖',
	'right-globalblock-whitelist' => '響本地停用全域封鎖',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Anakmalaysia
 * @author Bencmq
 * @author Breawycker
 * @author Gaoxuewei
 * @author Liangent
 * @author Mark85296341
 * @author PhiLiP
 * @author Shinjiman
 * @author Wmr89502270
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|允许]][[Special:GlobalBlockList|在多个wiki中封禁]]IP地址',
	'globalblocking-block' => '全局封禁IP地址',
	'globalblocking-modify-intro' => '您可以使用本表单改变全域封锁的设置。',
	'globalblocking-block-intro' => '您可以用这个页面去封锁全部wiki中的一个IP地址。',
	'globalblocking-block-reason' => '原因：',
	'globalblocking-block-otherreason' => '其他/附加原因：',
	'globalblocking-block-reasonotherlist' => '其他原因',
	'globalblocking-block-reason-dropdown' => '* 一般封禁原因
** 跨维基破坏
** 跨维基滥用
** 破坏',
	'globalblocking-block-edit-dropdown' => '编辑查封原因',
	'globalblocking-block-expiry' => '封锁到期日:',
	'globalblocking-block-expiry-other' => '其它的到期时间',
	'globalblocking-block-expiry-otherfield' => '其它时间:',
	'globalblocking-block-legend' => '全域封锁一个IP地址',
	'globalblocking-block-options' => '选项：',
	'globalblocking-ipaddress' => 'IP地址：',
	'globalblocking-ipbanononly' => '仅阻止匿名用户',
	'globalblocking-block-errors' => '该封锁不成功，因为如下{{PLURAL:$1|原因|原因}}：',
	'globalblocking-block-ipinvalid' => '您所输入的IP地址 （$1） 是无效的。
请留意的是您不可以输入一个用户名！',
	'globalblocking-block-expiryinvalid' => '您所输入的到期 （$1） 是无效的。',
	'globalblocking-block-submit' => '全域封锁这个IP地址',
	'globalblocking-modify-submit' => '修改这个全域封锁',
	'globalblocking-block-success' => '该IP地址 $1 已经在所有的项目中成功地封锁。',
	'globalblocking-modify-success' => '$1 的全域封锁已经被成功修改',
	'globalblocking-block-successsub' => '全域封锁成功',
	'globalblocking-modify-successsub' => '全域封锁已修改成功',
	'globalblocking-block-alreadyblocked' => '该IP地址 $1 已经被全域封锁。
您可以在[[Special:GlobalBlockList|全域封锁名单]]中参看现时的封锁，或通过修改重新提交此表单设置现有封锁。',
	'globalblocking-block-bigrange' => '您所指定的范围 （$1） 太大去封锁。
您可以封锁，最多65,536个地址 （/16 范围）',
	'globalblocking-list-intro' => '这是全部现时生效中的全域封锁。
一些的封锁已标明在本地停用：即是这个封锁在其它wiki上应用，但是本地管理员已决定在这个wiki上停用它们。',
	'globalblocking-list' => '全局封禁IP地址列表',
	'globalblocking-search-legend' => '搜寻一个全域封锁',
	'globalblocking-search-ip' => 'IP地址:',
	'globalblocking-search-submit' => '搜寻封锁',
	'globalblocking-list-ipinvalid' => '您所搜自导引IP地址 （$1） 是无效的。
请输入一个有效的IP地址。',
	'globalblocking-search-errors' => '您先前搜寻过的项目不成功，因为:
$1',
	'globalblocking-list-blockitem' => "\$1: <span class=\"plainlinks\">'''\$2'''</span> （''\$3''） 全域封锁了 [[Special:Contributions/\$4|\$4]] ''（\$5）''",
	'globalblocking-list-expiry' => '于$1到期',
	'globalblocking-list-anononly' => '只限匿名',
	'globalblocking-list-unblock' => '解除封锁',
	'globalblocking-list-whitelisted' => '由$1于本地封锁: $2',
	'globalblocking-list-whitelist' => '本地状态',
	'globalblocking-list-modify' => '修改',
	'globalblocking-list-noresults' => '请求的IP地址没有被封锁。',
	'globalblocking-goto-block' => '全域封锁一个 IP 地址',
	'globalblocking-goto-unblock' => '移除一个全域封锁',
	'globalblocking-goto-status' => '修改全域封锁的本地状态',
	'globalblocking-return' => '回到全域封锁名单',
	'globalblocking-notblocked' => '您所输入的 IP 地址 （$1） 并无全域封锁。',
	'globalblocking-unblock' => '移除一个全域封锁',
	'globalblocking-unblock-ipinvalid' => '您所输入的IP地址 （$1） 是无效的。
请留意的是您不可以输入一个用户名！',
	'globalblocking-unblock-legend' => '移除一个全域封锁',
	'globalblocking-unblock-submit' => '移除全域封锁',
	'globalblocking-unblock-reason' => '原因：',
	'globalblocking-unblock-unblocked' => "您己经成功地移除了在IP地址 '''$1''' 上的全域封锁 #$2",
	'globalblocking-unblock-errors' => '您不可以移除该IP地址的全域封锁，因为:
$1',
	'globalblocking-unblock-successsub' => '全域封锁已经成功地移除',
	'globalblocking-unblock-subtitle' => '移除全域封锁',
	'globalblocking-unblock-intro' => '您可以用这个表格去移除一个全域封锁。',
	'globalblocking-whitelist' => '全域封锁的本地状态',
	'globalblocking-whitelist-notapplied' => '全域封锁不适用于本维基，
所以本地全域封锁状态没有被修改。',
	'globalblocking-whitelist-legend' => '更改本地状态',
	'globalblocking-whitelist-reason' => '原因：',
	'globalblocking-whitelist-status' => '本地状态:',
	'globalblocking-whitelist-statuslabel' => '停用在{{SITENAME}}上的全域封锁',
	'globalblocking-whitelist-submit' => '更改本地状态',
	'globalblocking-whitelist-whitelisted' => "您已经成功地在{{SITENAME}}上的IP地址 '''$1''' 中停用了全域封锁 #$2。",
	'globalblocking-whitelist-dewhitelisted' => "您已经成功地在{{SITENAME}}上的IP地址 '''$1''' 中再次启用了全域封锁 #$2。",
	'globalblocking-whitelist-successsub' => '本地状态已经成功地更改',
	'globalblocking-whitelist-nochange' => '您未对这个封锁的本地状态更改过。
[[Special:GlobalBlockList|回到全域封锁名单]]。',
	'globalblocking-whitelist-errors' => '基于以下的{{PLURAL:$1|原因|原因}}，您更改过的全域封锁本地状态不成功：',
	'globalblocking-whitelist-intro' => '您可以利用这个表格去更改全域封锁的本地状态。
如果一个全域封锁在这个wiki度停用，受影响的 IP 地址可以正常地编辑。
[[Special:GlobalBlockList|回到全域封锁名单]]。',
	'globalblocking-blocked' => "你的IP地址（$5）已经由'''$1'''（''$2''）在所有wiki中封禁。理由是''“$3”''。该封禁''$4''。",
	'globalblocking-blocked-nopassreset' => '您无法修改用户密码，因为您正被全域封锁。',
	'globalblocking-logpage' => '全局封禁日志',
	'globalblocking-logpagetext' => '这个是在这个wiki中的全域封锁日志。要留意的是全域封锁可以在其它的wiki中被创建和移除并且会影响到这个wiki。要查看活跃的全域封锁，您可以去参阅[[Special:GlobalBlockList|全域封锁名单]]。',
	'globalblocking-block-logentry' => '全域封锁了[[$1]]于 $2 到期',
	'globalblocking-block2-logentry' => '已全域封禁[[$1]]（$2）',
	'globalblocking-unblock-logentry' => '移除了[[$1]]的全域封锁',
	'globalblocking-whitelist-logentry' => '停用了[[$1]]于本地的全域封锁',
	'globalblocking-dewhitelist-logentry' => '再次启用[[$1]]于本地的全域封锁',
	'globalblocking-modify-logentry' => '修改全域封锁[[$1]] （$2）',
	'globalblocking-logentry-expiry' => '过期 $1',
	'globalblocking-logentry-noexpiry' => '未设置过期',
	'globalblocking-loglink' => 'IP地址 $1 被全域封锁（[[{{#Special:GlobalBlockList}}/$1|详细信息]]）。',
	'globalblocking-showlog' => '这个IP地址已经被封锁。
封锁记录提供如下，供参考：',
	'globalblocklist' => '全局封禁IP地址列表',
	'globalblock' => '全局封禁IP地址',
	'globalblockstatus' => '全域封锁的本地状态',
	'removeglobalblock' => '移除一个全域封锁',
	'right-globalblock' => '弄一个全域封锁',
	'right-globalunblock' => '移除全域封锁',
	'right-globalblock-whitelist' => '在本地停用全域封锁',
	'right-globalblock-exempt' => '绕过全域封锁',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Anakmalaysia
 * @author Gaoxuewei
 * @author Horacewai2
 * @author Liangent
 * @author Mark85296341
 * @author Shinjiman
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|容許]] IP 位址可以[[Special:GlobalBlockList|在多個 wiki 中封鎖]]',
	'globalblocking-block' => '全域封鎖一個 IP 位址',
	'globalblocking-modify-intro' => '您可以使用本表單改變全域封鎖的設定。',
	'globalblocking-block-intro' => '您可以用這個頁面去封鎖全部 wiki 中的一個 IP 位址。',
	'globalblocking-block-reason' => '封鎖的原因：',
	'globalblocking-block-otherreason' => '其他／附加的理由：',
	'globalblocking-block-reasonotherlist' => '其他理由',
	'globalblocking-block-reason-dropdown' => '* 一般封禁原因
** 跨維基破壞
** 跨維基濫用
** 破壞',
	'globalblocking-block-edit-dropdown' => '編輯查封原因',
	'globalblocking-block-expiry' => '封鎖到期日：',
	'globalblocking-block-expiry-other' => '其它的到期時間',
	'globalblocking-block-expiry-otherfield' => '其他時間：',
	'globalblocking-block-legend' => '全域封鎖一個 IP 位址',
	'globalblocking-block-options' => '選項',
	'globalblocking-ipaddress' => 'IP地址：',
	'globalblocking-ipbanononly' => '僅阻止匿名用戶',
	'globalblocking-block-errors' => '該封鎖不成功，因為如下{{PLURAL:$1|原因|原因}}：',
	'globalblocking-block-ipinvalid' => '您所輸入的 IP 位址 （$1） 是無效的。
請留意的是您不可以輸入一個用戶名！',
	'globalblocking-block-expiryinvalid' => '您所輸入的到期 （$1） 是無效的。',
	'globalblocking-block-submit' => '全域封鎖這個 IP 位址',
	'globalblocking-modify-submit' => '修改這個全域封鎖',
	'globalblocking-block-success' => '該 IP 位址 $1 已經在所有的項目中成功地封鎖。',
	'globalblocking-modify-success' => '$1 的全域封鎖已經被成功修改',
	'globalblocking-block-successsub' => '全域封鎖成功',
	'globalblocking-modify-successsub' => '全域封鎖已修改成功',
	'globalblocking-block-alreadyblocked' => '該 IP 位址 $1 已經全域封鎖中。
您可以在[[Special:GlobalBlockList|全域封鎖名單]]中參見現時的封鎖，或透過修改重新提交此表單設定現有封鎖。',
	'globalblocking-block-bigrange' => '指定封鎖的區段（$1）過於龐大。
您最多只能封鎖 65536 個 IP 位址（ /16區段）',
	'globalblocking-list-intro' => '這是全部現時生效中的全域封鎖。
一些的封鎖已標明在本地停用：即是這個封鎖在其他 wiki 上應用，但是本地管理員已決定在這個 wiki 上停用它們。',
	'globalblocking-list' => '全域封鎖 IP 位址名單',
	'globalblocking-search-legend' => '搜尋一個全域封鎖',
	'globalblocking-search-ip' => 'IP 位址：',
	'globalblocking-search-submit' => '搜尋封鎖',
	'globalblocking-list-ipinvalid' => '您所搜尋的 IP 位址 （$1） 是無效的。
請輸入一個有效的 IP 位址。',
	'globalblocking-search-errors' => '您先前搜尋過的項目不成功，因為：
$1',
	'globalblocking-list-blockitem' => "\$1：<span class=\"plainlinks\">'''\$2'''</span> （''\$3''） 全域封鎖了 [[Special:Contributions/\$4|\$4]] ''（\$5）''",
	'globalblocking-list-expiry' => '於$1到期',
	'globalblocking-list-anononly' => '只限匿名',
	'globalblocking-list-unblock' => '解除封鎖',
	'globalblocking-list-whitelisted' => '由 $1 於本地封鎖：$2',
	'globalblocking-list-whitelist' => '本地狀態',
	'globalblocking-list-modify' => '修改',
	'globalblocking-list-noresults' => '請求的 IP 位址沒有被封鎖。',
	'globalblocking-goto-block' => '全域封鎖一個 IP 位址',
	'globalblocking-goto-unblock' => '移除全域封鎖',
	'globalblocking-goto-status' => '修改全域封鎖的本地狀態',
	'globalblocking-return' => '回到全域封鎖清單',
	'globalblocking-notblocked' => '您輸入的 IP 位址（$1）尚未被全域封鎖。',
	'globalblocking-unblock' => '移除一個全域封鎖',
	'globalblocking-unblock-ipinvalid' => '您所輸入的 IP 位址 （$1） 是無效的。
請留意的是您不可以輸入一個用戶名！',
	'globalblocking-unblock-legend' => '移除一個全域封鎖',
	'globalblocking-unblock-submit' => '移除全域封鎖',
	'globalblocking-unblock-reason' => '原因：',
	'globalblocking-unblock-unblocked' => "您己經成功地移除了在 IP 位址 '''$1''' 上的全域封鎖 #$2",
	'globalblocking-unblock-errors' => '您不可以移除該 IP 位址的全域封鎖，因為：
$1',
	'globalblocking-unblock-successsub' => '全域封鎖已經成功地移除',
	'globalblocking-unblock-subtitle' => '移除全域封鎖',
	'globalblocking-unblock-intro' => '可以用這個表格去移除一個全域封鎖。',
	'globalblocking-whitelist' => '全域封鎖的本地狀態',
	'globalblocking-whitelist-notapplied' => '全域封鎖不適用於本維基，
所以本地全域封鎖狀態沒有被修改。',
	'globalblocking-whitelist-legend' => '更改本地狀態',
	'globalblocking-whitelist-reason' => '原因：',
	'globalblocking-whitelist-status' => '本地狀態：',
	'globalblocking-whitelist-statuslabel' => '停用在{{SITENAME}}上的全域封鎖',
	'globalblocking-whitelist-submit' => '更改本地狀態',
	'globalblocking-whitelist-whitelisted' => "您已經成功地在{{SITENAME}}上的 IP 位址 '''$1''' 中停用了全域封鎖 #$2。",
	'globalblocking-whitelist-dewhitelisted' => "您已經成功地在{{SITENAME}}上的 IP 位址 '''$1''' 中再次啟用了全域封鎖 #$2。",
	'globalblocking-whitelist-successsub' => '本地狀態已經成功地更改',
	'globalblocking-whitelist-nochange' => '您未對這個封鎖的本地狀態更改過。
[[Special:GlobalBlockList|回到全域封鎖名單]]。',
	'globalblocking-whitelist-errors' => '基於以下的{{PLURAL:$1|原因|原因}}，您更改過的全域封鎖本地狀態不成功：',
	'globalblocking-whitelist-intro' => '您可以利用這個表格去更改全域封鎖的本地狀態。
如果一個全域封鎖在這個 wiki 度停用，受影響的 IP 位址可以正常地編輯。
[[Special:GlobalBlockList|回到全域封鎖名單]]。',
	'globalblocking-blocked' => "您的 IP 位址 （\$5）已經由'''\$1''' （''\$2''）在所有的 Wikimedia wiki 中全部封鎖。
而理由是 ''\"\$3\"''。該封鎖將會在''\$4''到期。",
	'globalblocking-blocked-nopassreset' => '您無法修改用戶密碼，因為您正被全域封鎖。',
	'globalblocking-logpage' => '全域封鎖日誌',
	'globalblocking-logpagetext' => '這個是在這個 wiki 中，弄過和移除整過的全域封鎖日誌。
要留意的是全域封鎖可以在其它的 wiki 中度弄和移除。
要檢視活躍的全域封鎖，您可以去參閱[[Special:GlobalBlockList|全域封鎖名單]]。',
	'globalblocking-block-logentry' => '全域封鎖了[[$1]]於 $2 到期',
	'globalblocking-block2-logentry' => '已全域封鎖[[$1]]（$2）',
	'globalblocking-unblock-logentry' => '移除了[[$1]]的全域封鎖',
	'globalblocking-whitelist-logentry' => '停用了[[$1]]於本地的全域封鎖',
	'globalblocking-dewhitelist-logentry' => '再次啟用[[$1]]於本地的全域封鎖',
	'globalblocking-modify-logentry' => '修改全域封鎖[[$1]] （$2）',
	'globalblocking-logentry-expiry' => '過期 $1',
	'globalblocking-logentry-noexpiry' => '未設定過期',
	'globalblocking-loglink' => 'IP 位址 $1 被全域封鎖（[[{{#Special:GlobalBlockList}}/$1|詳細資訊]]）。',
	'globalblocking-showlog' => '這個 IP 位址已經被封鎖。
封鎖記錄提供如下，供參考：',
	'globalblocklist' => '全域封鎖 IP 位址名單',
	'globalblock' => '全域封鎖一個 IP 位址',
	'globalblockstatus' => '全域封鎖的本地狀態',
	'removeglobalblock' => '移除一個全域封鎖',
	'right-globalblock' => '弄一個全域封鎖',
	'right-globalunblock' => '移除全域封鎖',
	'right-globalblock-whitelist' => '在本地停用全域封鎖',
	'right-globalblock-exempt' => '繞過全域封鎖',
);

